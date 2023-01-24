<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
              	
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php 
			$attributes = ['name' => 'practicepack_edit_form', 'id' => 'practicepack_edit_form'];
			echo form_open_multipart('adminController/practice_packages/edit/'.$practice_packages['package_id'],$attributes); ?>
			<div class="box-body">
				
					<div class="col-md-3">
						<label for="package_name" class="control-label"><span class="text-danger">*</span>Package Name/Title</label>
						<div class="form-group">
							<input type="text" name="package_name" value="<?php echo ($this->input->post('package_name') ? $this->input->post('package_name') : $practice_packages['package_name']); ?>" class="form-control input-ui-100 removeerrmessage" id="package_name" maxlength="100"/>
							<span class="text-danger package_name_err"><?php echo form_error('package_name');?></span>
						</div>
					</div>

					<input type="hidden" name="country_id" value="<?php echo $practice_packages['country_id']; ?>" />
					

					<div class="col-md-3">
						<label for="fake_amount" class="control-label"><span class="text-danger">*</span>Fake Price</label>
						<div class="form-group has-feedback">
							<input type="text" placeholder="e.g. 2500" name="fake_amount" value="<?php echo ($this->input->post('fake_amount') ? $this->input->post('fake_amount') : $practice_packages['amount']); ?>" class="form-control chknum1 input-ui-100 removeerrmessage" id="amount" maxlength="5" onblur="validate_f_amount(this.value)" autocomplete="off"/>
							<span class="form-control-feedback"><?php echo $practice_packages['currency_code']; ?></span>
							<span class="text-danger fake_amount_err"><?php echo form_error('fake_amount');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="discounted_amount" class="control-label"><span class="text-danger">*</span>Real Price</label>
						<div class="form-group has-feedback">
							<input type="text" placeholder="e.g. 2500" name="discounted_amount" value="<?php echo ($this->input->post('discounted_amount') ? $this->input->post('discounted_amount') : $practice_packages['discounted_amount']); ?>" class="form-control chknum1 input-ui-100 removeerrmessage" id="discounted_amount" onblur='validate_discounted_amount(this.value)' maxlength="5" autocomplete="off"/>
							<span class="form-control-feedback"><?php echo $practice_packages['currency_code']; ?></span>
							<span class="text-danger da discounted_amount_err"><?php echo form_error('discounted_amount');?></span>
						</div>
					</div>
					<div class="col-md-3">
						<label for="duration_type" class="control-label"><span class="text-danger">*</span>Duration type</label>
						<div class="form-group">
							<select name="duration_type" id="duration_type" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep">
								<option value="">Select</option>
								<?php 
								foreach($all_duration_type as $p){
									$selected = ($p['id'] == $practice_packages['duration_type']) ? ' selected="selected"' : "";
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
							<input type="text" placeholder="e.g. 30" name="duration" value="<?php echo ($this->input->post('duration') ? $this->input->post('duration') : $practice_packages['duration']); ?>" class="form-control chknum1 input-ui-100 removeerrmessage" id="duration" onblur='validate_duration(this.value)' maxlength="3" autocomplete="off"/>
							<span class="glyphicon glyphicon-time form-control-feedback"></span>
							<span class="text-danger duration_err"><?php echo form_error('duration');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="test_module_id" class="control-label"><span class="text-danger">*</span>Course</label>
						<div class="form-group">
							<select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'pp_pack');">
								<option value="">Select </option>
								<?php 
								foreach($all_test_module as $t){
									$selected = ($t['test_module_id'] == $practice_packages['test_module_id']) ? ' selected="selected"' : "";
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
							<select name="programe_id"  id="programe_id" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-show-subtext="true" data-live-search="true" onchange="get_category_forPack(this.value);">
								<option data-subtext="" value="">Select Programe <?php echo $practice_packages['test_module_id'];?></option>
								<?php 
								foreach($all_programe_masters as $p){
									$selected = ($p['programe_id'] == $practice_packages['programe_id']) ? ' selected="selected"' : "";
									if($practice_packages['test_module_id'] == 3)
									{
										if($p['programe_id'] ==2)
										{
											continue;
										}
									}
									
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
							<select name="category_id[]" id="category_id" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-live-search="true" data-actions-box="true" multiple="multiple">
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
						<label for="mock_test_count" class="control-label"> Mock Test Limit</label>
						<div class="form-group has-feedback">
							<input type="text" placeholder="e.g. 5"name="mock_test_count" value="<?php echo ($this->input->post('mock_test_count') ? $this->input->post('mock_test_count') : $practice_packages['mock_test_count']); ?>" class="form-control chknum1 input-ui-100 removeerrmessage" id="mock_test_count" maxlength="2"/>
							<span class="text-danger mock_test_count_err"><?php echo form_error('mock_test_count');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="reading_test_count" class="control-label"> Reading Test Limit</label>
						<div class="form-group has-feedback">
							<input type="text" placeholder="e.g. 5"name="reading_test_count" value="<?php echo ($this->input->post('reading_test_count') ? $this->input->post('reading_test_count') : $practice_packages['reading_test_count']); ?>" class="form-control chknum1 input-ui-100 removeerrmessage" id="reading_test_count" maxlength="2"/>
							<span class="text-danger reading_test_count_err"><?php echo form_error('reading_test_count');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="listening_test_count" class="control-label"> Listening Test Limit</label>
						<div class="form-group has-feedback">
							<input type="text" placeholder="e.g. 5"name="listening_test_count" value="<?php echo ($this->input->post('listening_test_count') ? $this->input->post('listening_test_count') : $practice_packages['listening_test_count']); ?>" class="form-control chknum1 input-ui-100 " id="listening_test_count" maxlength="2"/>
							<span class="text-danger listening_test_count_err"><?php echo form_error('listening_test_count');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="writing_test_count" class="control-label"> Writing Test Limit</label>
						<div class="form-group has-feedback">
							<input type="text" placeholder="e.g. 5"name="writing_test_count" value="<?php echo ($this->input->post('writing_test_count') ? $this->input->post('writing_test_count') : $practice_packages['writing_test_count']); ?>" class="form-control chknum1 input-ui-100" id="writing_test_count" maxlength="2"/>
							<span class="text-danger writing_test_count_err"><?php echo form_error('writing_test_count');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="speaking_test_count" class="control-label"> Speaking Test Limit</label>
						<div class="form-group has-feedback">
							<input type="text" placeholder="e.g. 5"name="speaking_test_count" value="<?php echo ($this->input->post('speaking_test_count') ? $this->input->post('speaking_test_count') : $practice_packages['speaking_test_count']); ?>" class="form-control chknum1 input-ui-100" id="speaking_test_count" maxlength="2"/>
							<span class="text-danger speaking_test_count_err"><?php echo form_error('speaking_test_count');?></span>
						</div>
					</div>
				
					
					<div class="col-md-3">
						<label for="image" class="control-label"><span class="text-danger">*</span>Media File</label>
						<?php echo WEBP_ALLOWED_TYPES_LABEL;?>
						<div class="form-group">
							<input type="file" name="image" value="<?php echo ($this->input->post('image') ? $this->input->post('media_file') : $practice_packages['image']); ?>" class="form-control input-ui-100 removeerrmessage" id="image" onchange="validate_file_type_Webp(this.id)"/>
							<span>
								<?php 
								if($practice_packages['image']){      
                                    echo '<span>
                                            <a href="'.site_url(PACKAGE_FILE_PATH).$practice_packages['image'].'" target="_blank">'.OPEN_FILE.'</a>
                                        </span>';
                                }else{
                                    echo NO_FILE;
                                }
                                ?>
						</span>
						<input type="hidden" value="<?php echo $practice_packages['image'];?>" id="hidden_image" name="hidden_image"/>
						<span class="text-danger image_err"><?php echo form_error('image');?></span>
						</div>						
					</div>					
						<div class="col-md-3">
							<div class="form-group form-checkbox mt-30">
								
								<input type="checkbox" name="active" value="1" id="active" class=""  <?php echo ($practice_packages['active']==1 ? 'checked="checked"' : ''); ?> />
								<label for="active" class="control-label">Active</label>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group form-checkbox mt-30">
								
								<input type="checkbox" name="publish" value="1" class="" id="publish"<?php echo ($practice_packages['publish']==1 ? 'checked="checked"' : ''); ?> />
								<label for="publish" class="control-label">Publish</label>
							</div>
						</div>
			

					<div class="col-md-12">
						<label for="package_desc" class="control-label"><span class="text-danger">*</span>Package Description</label>
						<div class="form-group has-feedback">
							<textarea name="package_desc" class="form-control myckeditor" id="package_desc"><?php echo ($this->input->post('package_desc') ? $this->input->post('package_desc') : $practice_packages['package_desc']); ?></textarea>
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
	$('#practicepack_edit_form').on('submit', function(e){
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
		var image=$('#image').val();
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
			$(".image_err").html('The Media File field is required.');
			flag=0;
		} else { $(".image_err").html(''); }
		
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