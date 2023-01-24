<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>              	
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
			<?php echo form_open_multipart('adminController/package_master/edit_offline_pack_/'.$package_master['package_id']); ?>
			<div class="box-body">
				
					
					<div class="col-md-3">
						<label for="package_name" class="control-label"><span class="text-danger">*</span>Pack Name</label>
						<div class="form-group">
							<input type="text" name="package_name" value="<?php echo ($this->input->post('package_name') ? $this->input->post('package_name') : $package_master['package_name']); ?>" class="form-control input-ui-100" id="package_name" maxlength="60"/>
							<span class="text-danger package_name_err"><?php echo form_error('package_name');?></span>
						</div>
					</div>

					<div class="col-md-3">
                        <label for="country_id" class="control-label"><span class="text-danger">*</span>
                            Country</label>
                        <div class="form-group">
                            <select id="country_id" name="country_id" class="form-control inDis selectpicker ccode selectCountry selectpicker-ui-100" data-show-subtext="true" disabled>
                                <option data-subtext="" value="">Select Country</option>
                                <?php 
								foreach($all_countries as $p) {	
									$selected = ($p['country_id'] == $package_master['country_id']) ? ' selected="selected"' : "";
										echo '<option  value="'.$p['country_id'].'" '.$selected.'>'.$p['name'].'</option>';
								}
								?>
                            </select>
                            <span class="text-danger country_id_err"><?php echo form_error('country_id');?></span>
                        </div>
                    </div>

					<div class="col-md-3">
						<label for="discounted_amount" class="control-label"><span class="text-danger">*</span>Real Price</label>
						<div class="form-group has-feedback">
							<input type="text" placeholder="e.g. 2500" name="discounted_amount" value="<?php echo ($this->input->post('discounted_amount') ? $this->input->post('discounted_amount') : $package_master['discounted_amount']); ?>" class="form-control chknum1 input-ui-100" id="discounted_amount" onblur='validate_discounted_amount(this.value)' />
							<span class="form-control-feedback"><?php echo $package_master['currency_code']; ?></span>
							<span class="text-danger da discounted_amount_err"><?php echo form_error('discounted_amount');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="fake_amount" class="control-label"><span class="text-danger">*</span>Fake Price</label>
						<div class="form-group has-feedback">
							<input type="text" placeholder="e.g. 2500" name="fake_amount" value="<?php echo ($this->input->post('fake_amount') ? $this->input->post('fake_amount') : $package_master['amount']); ?>" class="form-control chknum1 input-ui-100" id="amount" onblur='validate_fake_amount(this.value)' />
							<span class="form-control-feedback"><?php echo $package_master['currency_code']; ?></span>
							<span class="text-danger fake_amount_err"><?php echo form_error('fake_amount');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="duration_type" class="control-label"><span class="text-danger">*</span>Duration type</label>
						<div class="form-group">
							<select name="duration_type" id="duration_type" class="form-control selectpicker selectpicker-ui-100">
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
							<input type="text" placeholder="e.g. 30" name="duration" value="<?php echo ($this->input->post('duration') ? $this->input->post('duration') : $package_master['duration']); ?>" class="form-control chknum1 input-ui-100" id="duration" onblur='validate_duration(this.value)' maxlength="3"/>
							<span class="glyphicon glyphicon-time form-control-feedback"></span>
							<span class="text-danger duration_err"><?php echo form_error('duration');?></span>
						</div>
					</div>

					<?php $c = count($prev_course_timing);?>
					<div class="col-md-3">
						<label for="course_timing" class="control-label"><span class="text-danger">*</span>Course Type</label>
						<div class="form-group">
							<select name="course_timing[]" id="course_timing" class="form-control selectpicker selectpicker-ui-100"  data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
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
							<select name="batch_id[]" id="batch_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
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
							<select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true"  onchange="reflectPgmBatch(this.value,'offline_pack');">
								<option value="">Select </option>
								<?php 
								foreach($all_test_module as $t)
								{
									$selected = ($t['test_module_id'] == $package_master['test_module_id']) ? ' selected="selected"' : "";
									echo '<option value="'.$t['test_module_id'].'" '.$selected.'>'.$t['test_module_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('test_module_id');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="programe_id" class="control-label"><span class="text-danger">*</span>Program</label>
						<div class="form-group">
							<select name="programe_id" id="programe_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_category_forPack(this.value);">
								<option data-subtext="" value="">Select programe</option>
								<?php 
								foreach($all_programe_masters as $p)
								{
									$selected = ($p['programe_id'] == $package_master['programe_id']) ? ' selected="selected"' : "";
									echo '<option value="'.$p['programe_id'].'" '.$selected.'>'.$p['programe_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger"><?php echo form_error('programe_id');?></span>
						</div>
					</div>

					<?php $c = count($prev_category);?>
					<div class="col-md-3">
						<label for="category_id" class="control-label"><span class="text-danger">*</span>Category</label>
						<div class="form-group">
							<select name="category_id[]" id="category_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
								<option value="" disabled="disabled">Select Category</option>
								<?php 
								foreach($all_category as $p){
									$selected='';
									for ($i=0; $i <$c ; $i++) { 
										if(in_array($p['category_id'],$prev_category[$i])){
											$selected='selected="selected"';
										}
									}
									echo '<option data-subtext="'.$p['category_id'].'" value="'.$p['category_id'].'" '.$selected.'>'.$p['test_module_name'].SEP.$p['programe_name'].SEP.$p['category_name'].'</option>';
								} 
								?>
							</select>
							<span class="text-danger category_id_err"><?php echo form_error('category_id[]');?></span>
						</div>
					</div>

					<div class="col-md-3">
						<label for="image" class="control-label">Media File</label>
						<?php echo PACKAGE_ALLOWED_TYPES_LABEL;?>
						<div class="form-group">
							<input type="file" name="image" value="<?php echo ($this->input->post('image') ? $this->input->post('image') : $announcements['image']); ?>" class="form-control input-ui-100" id="image" onchange="validate_file_type(this.id)" />
							<span style="position:absolute; margin-top:4px;">
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
						<span class="text-danger image_err" style="margin-top:-2px;"><?php echo form_error('image');?></span>
						</div>						
					</div>

					<div class="col-md-3">
						<label for="center_id" class="control-label"><span class="text-danger">*</span>Branch</label>
						<div class="form-group">
							<select name="center_id" id="center_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
								<option value="">Select Branch</option>
								<?php 
									if($all_country_branches) { 
										foreach($all_country_branches as $branchObj) {
											if($branchObj["country_id"] == $package_master["country_id"]) {
												if($branchObj["branches"]) { 
													foreach($branchObj["branches"] as $b) {
														$selected = ($b['center_id'] == $package_master['center_id']) ? ' selected="selected"' : "";
														echo '<option value="'.$b['center_id'].'" '.$selected.'>'.$b['center_name'].'</option>';
													}
												}
											}
										}  
									} 
								?>
							</select>
							<span class="text-danger center_id_err"><?php echo form_error('center_id');?></span>
						</div>
					</div>

				
						<div class="col-md-2">
							<div class="form-group form-checkbox mt-30">								
								<input type="checkbox" name="active" value="1" id="active" <?php echo ($package_master['active']==1 ? 'checked="checked"' : ''); ?> />							
								<label for="active" class="control-label">Active</label>
							
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group form-checkbox mt-30">
								<input type="checkbox" name="publish" value="1" id="publish" <?php echo ($package_master['publish']==1 ? 'checked="checked"' : ''); ?> />							
								<label for="publish" class="control-label">Publish</label>
							</div>
						</div>
				

					<div class="col-md-12">
						<label for="package_desc" class="control-label">Package Description</label>
						<div class="form-group has-feedback">
							<textarea name="package_desc" class="form-control myckeditor" id="package_desc"><?php echo ($this->input->post('package_desc') ? $this->input->post('package_desc') : $package_master['package_desc']); ?></textarea>
							<span class="glyphicon glyphicon-text-size form-control-feedback"></span>
						</div>
					</div>
		
			</div>
			<div class="box-footer">
			<div class="col-md-12">
            	<button type="submit" class="btn btn-danger rd-20" onclick="return confirm('<?php echo SUBMISSION_CONFIRM;?>');">
					<i class="fa fa-level-up"></i> <?php echo UPDATE_LABEL;?>
				</button>
	        </div>	
			</div>			
			<?php echo form_close(); ?>
		</div>
    </div>
</div>