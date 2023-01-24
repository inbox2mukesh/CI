<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
              	<div class="box-tools">
              		<?php 
                  		if($this->Role_model->_has_access_('live_lecture','index')){
                  	?>
                   		<a href="<?php echo site_url('adminController/live_lecture/index'); ?>" class="btn btn-success btn-sm">ALL Lectures</a>  
                   <?php }?>                  
                </div>
                </div>
            
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php 
			$attributes = ['name' => 'lecture_add_form', 'id' => 'lecture_add_form'];
			 if($classroom_id >0){ 
				echo form_open_multipart('adminController/live_lecture/add/'.$classroom_id,$attributes);
			}else{
				echo form_open_multipart('adminController/live_lecture/add/',$attributes);
			}
			
			?>
          	<div class="box-body">
          		<div class="">
					<?php 
          			if($classroom_id>0){
          				$displayFilterBox='none';
          			}else{
          				$displayFilterBox='block';
          			}
          			$pattern = "/Trainer/i";
					$isTrainer = preg_match($pattern, $_SESSION['roleName']);
          			if(!$isTrainer){
          		?>
          		<div class="" style="background-color: <?php echo FILTER_BOX_COLOR;?>; display: <?php echo $displayFilterBox;?>">
          			<div class="col-md-2">
						<label for="test_module_id" class="control-label">Course</label>
						<div class="form-group">
							<select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'announcement');loadClassroom();">
								<option value="">Select course</option>
								<?php 
								foreach($all_test_module as $p)
								{
									$selected = ($p['test_module_id'] == $this->input->post('test_module_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['test_module_id'].'" '.$selected.'>'.$p['test_module_name'].'</option>';
								} 
								?>
							</select>
						</div>
					</div>

					<div class="col-md-3">
						<label for="programe_id" class="control-label">Program</label>
						<div class="form-group">
							<select name="programe_id" id="programe_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_category_forPack(this.value);loadClassroom();">
								<option data-subtext="" value="">Select program</option>
								<?php 
								foreach($all_programe_masters as $p)
								{
									$selected = ($p['programe_id'] == $this->input->post('programe_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$p['programe_id'].'" '.$selected.'>'.$p['programe_name'].'</option>';
								} 
								?>
							</select>
						</div>
					</div>

					<div class="col-md-3 catBox">
						<label for="category_id" class="control-label"> Category</label>
						<div class="form-group">
							<select name="category_id[]" id="category_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" onchange="loadClassroom();" >
								<option value="" disabled="disabled">Select Category</option>
							</select>
						</div>
					</div>

					<div class="col-md-2">
						<label for="batch_id" class="control-label"> Batch</label>
						<div class="form-group">
							<select name="batch_id" id="batch_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="loadClassroom();" >
								<option value="">Select Batch</option>
								<?php 
								foreach($all_batches as $b)
								{
									$selected = ($b['batch_id'] == $this->input->post('batch_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$b['batch_id'].'" '.$selected.'>'.$b['batch_name'].'</option>';
								} 
								?>
							</select>
						</div>
					</div>			

					<div class="col-md-2">
						<label for="center_id" class="control-label"> Branch</label>
						<div class="form-group">
							<select name="center_id" id="center_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="loadClassroom();" >
								<option value="">Select Branch</option>
								<?php 
								foreach($all_branch as $b)
								{
									$selected = ($b['center_id'] == $this->input->post('center_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$b['center_id'].'" '.$selected.'>'.$b['center_name'].'</option>';
								} 
								?>
							</select>
						</div>
					</div>
					</div>
					<?php } ?>
					
					<?php $classroom_id_post = $this->input->post('classroom_id[]');?>
					<div class="col-md-12">
						<label for="classroom_id" class="control-label"><span class="text-danger">*</span>Classroom</label>
						<div class="form-group">
							<select name="classroom_id[]" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-show-subtext="true" data-live-search="true" id="classroom_id" multiple="multiple" data-actions-box="true">
								<option value="" disabled="disabled">Select Classroom</option>
								<?php								
									foreach($all_classroom as $p){

										if($classroom_id!=0 && $p['id']==$classroom_id)
										{
											$clssroomProperty = $p['test_module_name'].'-'.$p['programe_name'].'-'.$p['Category']['category_name'].'-'.$p['batch_name'].'-'.$p['center_name'];
											$selected='';
											if(in_array($p['id'],$classroom_id_post)){
											$selected='selected="selected"';
											}
											if($classroom_id){
											$selected = ($p['id'] == $classroom_id) ? ' selected="selected"' : "disabled='disabled'";
											}
											echo '<option value="'.$p['id'].'" '.$selected.'>'.$p['classroom_name'].' / '.$clssroomProperty.'</option>';
										}
										if($classroom_id==0 )
										{
											if($p['active'] !=0)
										{										
										$clssroomProperty = $p['test_module_name'].'-'.$p['programe_name'].'-'.$p['Category']['category_name'].'-'.$p['batch_name'].'-'.$p['center_name'];										
										echo '<option value="'.$p['id'].'" >'.$p['classroom_name'].' / '.$clssroomProperty.'</option>';
										}
										}
									}	
								?>
							</select>
							<span class="text-danger classroom_id_err"><?php echo form_error('classroom_id[]');?></span>
						</div>
					</div>

					<div class="col-md-6">
						<label for="content_type_id" class="control-label">Content Type<span class="text-danger">*</span></label>
						<div class="form-group">
							<select name="content_type_id" id="content_type_id" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep">
							<option value="">Select Content Type</option>
							<?php foreach($content_type_list as $key=>$val){
								
								$selected = ($val['id'] == $this->input->post('content_type_id')) ? ' selected="selected"' : "";
								?>
								<option <?php echo $selected;?> value="<?php echo $val['id']?>" <?php echo $val['id']==$content_type_id ? 'selected="selected"':''?>  >
								<?php echo $val['content_type_name']?></option>
								<?php } ?>	
							</select>						
							<span class="text-danger content_type_id_err"><?php echo form_error('content_type_id');?></span>
						</div>
					</div>					

					<div class="col-md-6">
						<label for="live_lecture_title" class="control-label">Lecture Title<span class="text-danger">*</span></label>
						<div class="form-group">
							<input type="text" name="live_lecture_title" value="<?php echo $this->input->post('live_lecture_title'); ?>" class="form-control input-ui-100 removeerrmessage" id="live_lecture_title" maxlength="60"/>
							<span class="text-danger live_lecture_title_err"><?php echo form_error('live_lecture_title');?></span>
						</div>
					</div>					

					<!-- <div class="col-md-6">
						<label for="screenshot" class="control-label">Video Screen</label>
						<?php echo WEBP_ALLOWED_TYPES_LABEL;?>
						<div class="form-group">
							<input type="file" name="screenshot" value="<?php echo $_FILES['screenshot']['name'] ?>" class="form-control input-ui-100 removeerrmessage" id="screenshot" onchange="validate_file_type_Webp(this.id)" />
							<span class="text-danger screenshot_err"><?php echo form_error('screenshot');?></span>
						</div>
					</div> -->
					<div class="col-md-6">
						<label for="lecture_date" class="control-label"> Lecture Date<span class="text-danger">*</span></label>
						<div class="form-group has-feedback">
							<input type="text" name="lecture_date" value="<?php echo $this->input->post('lecture_date'); ?>" class="form-control input-ui-100 noFutureDate removeerrmessage" id="lecture_date" readonly/>
							<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
							<span class="text-danger lecture_date_err"><?php echo form_error('lecture_date');?></span>
						</div>
					</div>

					<div class="col-md-12">
						<label for="video_url" class="control-label"><span class="text-danger">*</span>Video URL</label>
						[
						<span class="text-danger"><a href="<?php echo site_url('adminController/gallery/add');?>" target="_blank">
							<?php echo GALLERY_URL_LABEL;?></a>
						</span>
						]&nbsp;
						[
						<span class="text-danger"><a href="<?php echo site_url('adminController/gallery/index');?>" target="_blank">
							<?php echo GALLERY_URL_LABEL_LIST;?></a>
						</span>
						]
						<div class="form-group has-feedback">
							<input type="url" name="video_url" value="<?php echo $this->input->post('video_url'); ?>" class="form-control input-ui-100 removeerrmessage" id="video_url" onblur="ValidURL(this.value,this.id),validate_video_url_mp4(this.id)" />
							<span class="glyphicon glyphicon-link form-control-feedback"></span>
							<span class="text-danger video_url_err"><?php echo form_error('video_url');?></span>
						</div>
					</div>
										
					<div class="col-md-6">
						<div class="form-group form-checkbox">
							<input type="checkbox" name="active" value="1"  id="active" checked="checked"/>
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
				</div>

			</div>
          	<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20" >
					<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
				</button>
          	</div>
			  </div>
            <?php echo form_close(); ?>
            </div>
      	</div>
    </div>
</div>

<?php ob_start(); ?>
<script>
$('#lecture_add_form').on('submit', function(e){
        e.preventDefault();
		var flag=1;
		var classroom_id=$('#classroom_id').val();
		var content_type_id=$('#content_type_id').val();
		var live_lecture_title=$('#live_lecture_title').val();
		var screenshot=$('#screenshot').val();
		var lecture_date=$('#lecture_date').val();
		var video_url=$('#video_url').val();
		
		if(classroom_id == "")
		{			
			$(".classroom_id_err").html('The Classroom field is required.');
			flag=0;
		} else { $(".classroom_id_err").html(''); }
		if(content_type_id == "")
		{			
			$(".content_type_id_err").html('The Content type field is required.');
			flag=0;
		} else { $(".content_type_id_err").html(''); }
		
		if(live_lecture_title == "")
		{			
			$(".live_lecture_title_err").html('The Lecture title field is required.');
			flag=0;
		} else { $(".live_lecture_title_err").html(''); }
		/*if(screenshot == "")
		{			
			$(".screenshot_err").html('The Screen field is required.');
			flag=0;
		} else { $(".screenshot_err").html(''); }*/
		if(lecture_date == "")
		{			
			$(".lecture_date_err").html('The Lecture date field is required.');
			flag=0;
		} else { $(".lecture_date_err").html(''); }
		if(video_url == "")
		{			
			$(".video_url_err").html('The Video url field is required.');
			flag=0;
		} else { $(".video_url_err").html(''); }		
		if(flag == 1)
		{
			this.submit();			
		} 
       
    });
	</script>

<?php
global $customJs;
$customJs = ob_get_clean();
?>