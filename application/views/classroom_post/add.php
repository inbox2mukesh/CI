<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3> 
              	<div class="box-tools">
              		<?php 
                  if($this->Role_model->_has_access_('classroom_post','index')){
                  ?>
                    <a href="<?php echo site_url('adminController/classroom_post/index'); ?>" class="btn btn-success btn-sm">All Post List</a>   
                    <?php }?>                 
                </div>              	
                </div>
            
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <?php
			$attributes = ['name' => 'classroom_post_add_form', 'id' => 'classroom_post_add_form'];
			echo form_open_multipart('adminController/classroom_post/add',$attributes); ?>
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
          		<div class="col-md-12" style="background-color: <?php echo FILTER_BOX_COLOR;?>; padding: 5px; display: <?php echo $displayFilterBox;?>">
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
						<label for="subject" class="control-label"><span class="text-danger">*</span>Subject</label>
						<div class="form-group">
							<input type="text" name="subject" value="<?php echo $this->input->post('subject'); ?>" class="form-control input-ui-100 removeerrmessage" id="subject" maxlength="100"/>
							<span class="text-danger subject_err"><?php echo form_error('subject');?></span>
						</div>
					</div>					

					<div class="col-md-6">
						<label for="media_file" class="control-label">Media File</label>
						<?php echo WEBP_ALLOWED_TYPES_LABEL;?>
						<div class="form-group">
							<input type="file" name="media_file" value="<?php echo $this->input->post('media_file'); ?>" class="form-control input-ui-100" id="media_file" onchange="validate_file_type_Webp(this.id) "/>
							<span class="text-danger media_file_err"><?php echo form_error('media_file');?></span>
						</div>
					</div>

					<div class="col-md-12">
					<span class="text-danger body_err" id="body_err"></span>
						<label for="body" class="control-label"><span class="text-danger">*</span>Body</label>
						<div class="form-group has-feedback">
							<span class="text-danger body_err" id="body_err"></span>
							<textarea name="body" class="form-control myckeditor_new removeerrmessage" id="body"><?php echo $this->input->post('body'); ?></textarea>
							<span class="text-danger body_err"><?php echo form_error('body');?></span>
						</div>
						
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="checkbox" name="active" value="1"  id="active" checked="checked"/>
							<label for="active" class="control-label">Active</label>
						</div>
					</div>
				</div>
			</div>
          	<div class="box-footer">
				<div class="col-md-12">
            	<button type="submit" class="btn btn-danger">
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
// 	CKEDITOR.replaceAll( 'myckeditor_new', {
// 	removeButtons: 'Source',
//     // The rest of options...
// } );
checkWordCountCkEditor('myckeditor_new');
	var element = CKEDITOR.document.getById( 'myckeditor_new' );
element.on( 'click', function( ev ) {
	alert('pp')
       // ev.removeListener();
        //someFunction();
    });
$('#classroom_post_add_form').on('submit', function(e){
        e.preventDefault();
		var flag=1;
		var classroom_id=$('#classroom_id').val();
		var subject=$('#subject').val();
	    var body=$('#body').val();	
		if(classroom_id == "")
		{			
			$(".classroom_id_err").html('The Classroom field is required.');
			flag=0;
		} else { $(".classroom_id_err").html(''); }

		if(subject == "")
		{			
			$(".subject_err").html('The Subject field is required.');
			flag=0;
		} else { $(".subject_err").html(''); }

		if(body == "")
		{			
			$(".body_err").html('The Body field is required.');
			flag=0;
		} else { $(".body_err").html(''); }	
			
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