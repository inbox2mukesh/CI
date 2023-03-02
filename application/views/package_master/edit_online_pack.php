<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>              	
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php 
			$attributes = ['name' => 'onlinepack_edit_form', 'id' => 'onlinepack_edit_form'];
			echo form_open_multipart('adminController/package_master/edit_online_pack_/'.$package_master['package_id'],$attributes); ?>
			<div class="box-body">
					<div class="col-md-3">
						<label for="package_name" class="control-label"><span class="text-danger">*</span>Pack Name</label>
						<div class="form-group">
							<input type="text" name="package_name" value="<?php echo ($this->input->post('package_name') ? $this->input->post('package_name') : $package_master['package_name']); ?>" class="form-control input-ui-100 removeerrmessage" id="package_name" maxlength="45"/>
							<span class="text-danger package_name_err"><?php echo form_error('package_name');?></span>
						</div>
					</div>
					<input type="hidden" name="country_id" value="<?php echo $package_master['country_id']; ?>" />
					
					<div class="col-md-3">
						<label for="fake_amount" class="control-label"><span class="text-danger">*</span>Fake Price</label>
						<div class="form-group has-feedback">
							<input type="text" placeholder="e.g. 2500" name="fake_amount" value="<?php echo ($this->input->post('fake_amount') ? $this->input->post('fake_amount') : $package_master['amount']); ?>" class="form-control chknum1 input-ui-100 removeerrmessage" id="amount" maxlength="5" onblur="validate_f_amount(this.value)" autocomplete="off"/>
							<span class="form-control-feedback"><?php echo $package_master['currency_code']; ?></span>
							<span class="text-danger fake_amount_err"><?php echo form_error('fake_amount');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="discounted_amount" class="control-label"><span class="text-danger">*</span>Real Price</label>
						<div class="form-group has-feedback">
							<input type="text" placeholder="e.g. 2500" name="discounted_amount" value="<?php echo ($this->input->post('discounted_amount') ? $this->input->post('discounted_amount') : $package_master['discounted_amount']); ?>" class="form-control chknum1 input-ui-100 removeerrmessage" id="discounted_amount" onblur='validate_discounted_amount(this.value)' maxlength="5" autocomplete="off"/>
							<span class="form-control-feedback"><?php echo $package_master['currency_code']; ?></span>
							<span class="text-danger da discounted_amount_err"><?php echo form_error('discounted_amount');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="duration_type" class="control-label"><span class="text-danger">*</span>Duration type</label>
						<div class="form-group">
							<select name="duration_type" id="duration_type" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep reset_duration_field">
								<option value="">Select</option>
								<?php 
								foreach($all_duration_type as $p){
									$selected = ($p['id'] == $package_master['duration_type']) ? ' selected="selected"' : "";
									echo '<option value="'.$p['id'].'" '.$selected.'>'.$p['duration_type'].'</option>';
								} 
								?>	
							</select>
							<span class="text-danger duration_type_err"><?php echo form_error('duration_type');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="duration" class="control-label"><span class="text-danger">*</span>Duration</label>
						<div class="form-group has-feedback">
							<input type="text" placeholder="e.g. 30" name="duration" value="<?php echo ($this->input->post('duration') ? $this->input->post('duration') : $package_master['duration']); ?>" class="form-control chknum1 input-ui-100 removeerrmessage" id="duration" maxlength="3" autocomplete="off"  onblur="validate_package_max_duration(this.value,'<?php echo PACKAGE_MAX_DURATION;?>');validate_duration(this.value)"  />
							<span class="glyphicon glyphicon-time form-control-feedback"></span>
							<span class="text-danger duration_err"><?php echo form_error('duration');?></span>
						</div>
					</div>
					
					<?php $c = count($prev_course_timing);?>
					<div class="col-md-3">
						<label for="course_timing" class="control-label"><span class="text-danger">*</span>Course Type</label>
						<div class="form-group">
							<select name="course_timing[]" id="course_timing" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep"  data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
								<option value="" disabled="disabled">Select</option>
								<?php 
								foreach($course_timing as $p){
									$selected='';
									for ($i=0; $i <$c ; $i++) { 
										if(in_array($p['id'],$prev_course_timing[$i])){
											$selected='selected="selected"';
										}
									}									
									echo '<option value="'.$p['id'].'" '.$selected.'>'.$p['course_timing'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger course_timing_err"><?php echo form_error('course_timing[]');?></span>
						</div>
					</div>

					<?php $c = count($prev_batch);?>
					<div class="col-md-3">
						<label for="batch_id" class="control-label"><span class="text-danger">*</span>Batch</label>
						<div class="form-group">
							<select name="batch_id[]" id="batch_id" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
								<option value=""  disabled="disabled">Select</option>
								<?php 
								foreach($all_batch as $p){
									$selected='';
									for ($i=0; $i <$c ; $i++) { 
										if(in_array($p['batch_id'],$prev_batch[$i])){
											$selected='selected="selected"';
										}
									}
									echo '<option value="'.$p['batch_id'].'" '.$selected.'>'.$p['batch_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger batch_id_err"><?php echo form_error('batch_id[]');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="test_module_id" class="control-label"><span class="text-danger">*</span>Course</label>
						<div class="form-group">
							<select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'online_pack');">
								<option value="">Select </option>
								<?php 
								foreach($all_test_module as $t){
									$selected = ($t['test_module_id'] == $package_master['test_module_id']) ? ' selected="selected"' : "";
									echo '<option value="'.$t['test_module_id'].'" '.$selected.'>'.$t['test_module_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger test_module_id_err"><?php echo form_error('test_module_id');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="programe_id" class="control-label"><span class="text-danger">*</span>Program</label>
						<div class="form-group">
							<select name="programe_id" id="programe_id" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-show-subtext="true" data-live-search="true" onchange="get_category_forPack(this.value);">
								<option data-subtext="" value="">Select programe</option>
								<?php 
								foreach($all_programe_masters as $p){
									$selected = ($p['programe_id'] == $package_master['programe_id']) ? ' selected="selected"' : "";
									echo '<option value="'.$p['programe_id'].'" '.$selected.'>'.$p['programe_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger programe_id_err"><?php echo form_error('programe_id');?></span>
						</div>
					</div>

					<?php $c = count($prev_category);?>
					<div class="col-md-3">
						<label for="category_id" class="control-label"><span class="text-danger">*</span>Category</label>
						<div class="form-group">
							<select name="category_id[]" id="category_id" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep"  data-live-search="true" data-actions-box="true" multiple="multiple">
								<option value="" disabled="disabled">Select Category</option>
								<?php 
								foreach($all_category as $p){
									$selected='';
									for ($i=0; $i <$c ; $i++) { 
										if(in_array($p['category_id'],$prev_category[$i])){
											$selected='selected="selected"';
										}
									}
									echo '<option value="'.$p['category_id'].'" '.$selected.'>'.$p['test_module_name'].SEP.$p['programe_name'].SEP.$p['category_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger category_id_err"><?php echo form_error('category_id[]');?></span>
						</div>
					</div>	

					<div class="col-md-3">
						<label for="image" class="control-label"><span class="text-danger">*</span>Media File</label>
						<?php echo WEBP_ALLOWED_TYPES_LABEL;?>
							<span>
								<?php 
									if($package_master['image']){      
	                                    echo '<span>
	                                            <a href="'.site_url(PACKAGE_FILE_PATH).$package_master['image'].'" target="_blank">'.OPEN_FILE.'</a>
	                                        </span>';
	                                }else{
	                                    echo NO_FILE;
	                                }
	                            ?>
							</span>
						<div class="form-group mediaFile">
							<!-- <input type="file" name="image" value="<?php echo ($this->input->post('image') ? $this->input->post('image') : $package_master['image']); ?>" class="form-control input-ui-100 removeerrmessage" id="image" onchange="validate_file_type_Webp(this.id)"/> -->

							<!-- file size check html -->						
							<input  accept="<?php echo PACK_IMAGE_TYPE_ALLOW;?>" onchange="uploadFile('upload_image', 'image',<?php echo PACK_IMAGE_WIDTH;?>, <?php echo PACK_IMAGE_HEIGHT;?>)" type="file" name="image" value="<?php echo $this->input->post('upload_file'); ?>" class="form-control input-file-ui-100 input-file-ui"  id="upload_image"/>
							<input type="hidden" name="upload_image_hidden"  id="upload_image_hidden">
							<div class="correct-accept text-blue" style="position:absolute;margin-top: 10px;"><?php echo PACK_IMAGE_SIZE_LABEL;?></div>
							<span class="text-danger validation-error" id="msg_image" style="margin-top:0px"><?php echo form_error('image');?></span>
							<progress id="upload_image_progressBar" value="0" max="100" style="width:100%;display:none; "></progress>
							<h3 id="upload_image_status"></h3>
							<p id="upload_image_loaded_n_total"></p>
							
							<!--END file size check html -->

							<input type="hidden" value="<?php echo $package_master['image'];?>" id="hidden_image"/>
							<span class="text-danger image_err"><?php echo form_error('image');?></span>
						</div>						
					</div>

					<div class="col-md-3 mt-30">
						<div class="col-md-6 p-0">
							<div class="form-group form-checkbox">
								<input type="checkbox" name="active" value="1" id="active" class=""  <?php echo ($package_master['active']==1 ? 'checked="checked"' : ''); ?> />
								<label for="active" class="control-label">Active</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group form-checkbox">
								<input type="checkbox" name="publish" value="1" class="" id="publish"<?php echo ($package_master['publish']==1 ? 'checked="checked"' : ''); ?> />
								<label for="publish" class="control-label">Publish</label>
							</div>
						</div>
					</div>




					<div class="col-md-12">
						<label for="package_desc" class="control-label"><span class="text-danger">*</span>Package Description</label>
						<div class="form-group has-feedback">
							<textarea name="package_desc" class="form-control removeerrmessage myckeditor" id="package_desc"><?php echo ($this->input->post('package_desc') ? $this->input->post('package_desc') : $package_master['package_desc']); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
							<span class="text-danger package_desc_err"><?php echo form_error('package_desc');?></span>
						</div>
					</div>
				</div>
		
			<div class="box-footer">
			<div class="col-md-12">
            	<button type="submit" class="btn btn-danger sbm rd-20" onclick="return confirm('<?php echo SUBMISSION_CONFIRM;?>');">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button>
	        </div>			
			</div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>
<?php ob_start(); ?>
<script>
	$('#onlinepack_edit_form').on('submit', function(e){
        e.preventDefault();
		var flag=1;
		var package_name=$('#package_name').val();
		var fake_amount=$('#amount').val();
		var discounted_amount=$('#discounted_amount').val();
		var duration_type=$('#duration_type').val();
		var duration=$('#duration').val();
		var course_timing=$('#course_timing').val();
		var batch_id=$('#batch_id').val();
		var test_module_id=$('#test_module_id').val();
		var programe_id=$('#programe_id').val();
		var category_id=$('#category_id').val();
		var image=$('#upload_image').val();
		var hidden_image=$('#hidden_image').val();
		var package_desc=CKEDITOR.instances.package_desc.getData();
		
		if(package_name == "")
		{			
			$(".package_name_err").html('The Pack Name field is required.');
			flag=0;
		} else { $(".package_name_err").html(''); }
		if(fake_amount == "")
		{			
			$(".fake_amount_err").html('The Fake Price field is required.');
			flag=0;
		} else { $(".fake_amount_err").html(''); }
		
		if(discounted_amount == "")
		{			
			$(".discounted_amount_err").html('The Real Price field is required.');
			flag=0;
		} else { $(".discounted_amount_err").html(''); }
		if(duration_type == "")
		{			
			$(".duration_type_err").html('The Duration type field is required.');
			flag=0;
		} else { $(".duration_type_err").html(''); }
		if(duration == "")
		{			
			$(".duration_err").html('The Duration field is required.');
			flag=0;
		} else { $(".duration_err").html(''); }
		if(course_timing == "")
		{			
			$(".course_timing_err").html('The Course Type field is required.');
			flag=0;
		} else { $(".course_timing_err").html(''); }	
		if(batch_id == "")
		{			
			$(".batch_id_err").html('The Batch field is required.');
			flag=0;
		} else { $(".batch_id_err").html(''); }		
		if(test_module_id == "")
		{			
			$(".test_module_id_err").html('The Course field is required.');
			flag=0;
		} else { $(".test_module_id_err").html(''); }	
		
		if(programe_id == "")
		{			
			$(".programe_id_err").html('The Program field is required.');
			flag=0;
		} else { $(".programe_id_err").html(''); }
		
		if(category_id == "")
		{			
			$(".category_id_err").html('The Category field is required.');
			flag=0;
		} else { $(".category_id_err").html(''); }
		
		if(image == "" && hidden_image =="")
		{			
			$(".upload_image_err").html('The Media File field is required.');
			flag=0;
		} else { $(".upload_image_err").html(''); }
		
		if(package_desc == "")
		{			
			$(".package_desc_err").html('The Package Description field is required.');
			flag=0;
		} else { $(".package_desc_err").html(''); }	
		//alert(flag)
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