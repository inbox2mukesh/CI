<div class="user-add">

			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo $title;?></h3>
					<div class="box-tools pull-right">
						<?php
							if($this->Role_model->_has_access_('user','employee_list')){
						?>
						<a href="<?php echo site_url('adminController/user/employee_list'); ?>" class="btn btn-success btn-sm">All employee list</a> <?php } ?>
						<?php
							if($this->Role_model->_has_access_('role','index')){
						?>
						<a href="<?php echo site_url('adminController/role/index'); ?>" class="btn btn-warning btn-sm">All Role List</a> <?php } ?>
					</div>
				</div>

				<?php echo $this->session->flashdata('flsh_msg');?>
				<?php echo form_open_multipart(('adminController/user/add'), array('onsubmit' => 'return validate_employee_form();'));?>
				<div class="box-body">
				   <div class="flex-auto">
						<input type="hidden" name="page" id="page" value="add">
						<div class="col-md-3">
							<label for="employeeCode" class="control-label"><span class="text-danger">*</span>Employe Code</label>
							<div class="form-group">
								<input type="text" name="employeeCode" value="<?php echo $this->input->post('employeeCode'); ?>" class="form-control chknum1 input-ui-100" id="employeeCode" maxlength="6" minlength="6" onblur="check_employeeCode_availibility(this.value);"/>
								<span class="text-danger employeeCode_err"><?php echo form_error('employeeCode');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="image" class="control-label">Emp Image</label><?php echo EMP_ALLOWED_TYPES_LABEL;?>
							<div class="form-group">
							  <input type="file" name="image" value="<?php echo $this->input->post('image'); ?>" class="form-control input-file-ui input-file-ui-100" id="image" onchange="validate_file_type(this.id);"/>
							  <span class="text-danger image_err"><?php echo form_error('image');?></span>							
							</div>	
						</div>

						<div class="col-md-3">
							<label for="fname" class="control-label"><span class="text-danger">*</span>First name</label>
							<div class="form-group">
								<input type="text" name="fname" value="<?php echo $this->input->post('fname'); ?>" class="form-control input-ui-100" id="fname" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" maxlength="30"/>
								<span class="text-danger fname_err"><?php echo form_error('fname');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="lname" class="control-label">Last name</label>
							<div class="form-group">
								<input type="text" name="lname" value="<?php echo $this->input->post('lname'); ?>" class="form-control input-ui-100" id="lname" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" maxlength="30"/>
							</div>
						</div>

						<div class="col-md-3">
							<label for="gender_name" class="control-label"><span class="text-danger">*</span>Gender</label>
							<div class="form-group">
								<select name="gender_name" id="gender_name" class="form-control selectpicker selectpicker-ui-100">
									<option value="">Select gender</option>
									<?php
									foreach($all_genders as $p){
										$selected = ($p['id'] == $this->input->post('gender_name')) ? ' selected="selected"' : "";
										echo '<option value="'.$p['id'].'" '.$selected.'>'.$p['gender_name'].'</option>';
									}
									?>
								</select>
								<span class="text-danger gender_name_err"><?php echo form_error('gender_name');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="dob" class="control-label"><span class="text-danger">*</span>Date of birth</label>
							<div class="form-group has-feedback">
								<input type="text" name="dob" value="<?php echo $this->input->post('dob'); ?>" class="noFutureDate form-control input-ui-100" id="dob" maxlength="10" autocomplete="off"/>
								<span class="glyphicon form-control-feedback"><i class="fa fa-birthday-cake"></i></span>
								<span class="text-danger dob_err"><?php echo form_error('dob');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="MA" class="control-label">Date of anniversary</label>
							<div class="form-group has-feedback">
								<input type="text" name="MA" value="<?php echo $this->input->post('MA'); ?>" class="noFutureDate form-control input-ui-100" id="MA"  maxlength="10" autocomplete="off"/>
								<span class="glyphicon form-control-feedback"><i class="fa fa-birthday-cake"></i></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="DOJ" class="control-label"><span class="text-danger">*</span>Date of joining</label>
							<div class="form-group has-feedback">
								<input type="text" name="DOJ" value="<?php echo $this->input->post('DOJ'); ?>" class="datepicker form-control input-ui-100" id="DOJ"maxlength="10" autocomplete="off"/>
								<span class="glyphicon form-control-feedback"><i class="fa fa-link"></i></span>
								<span class="text-danger DOJ_err"><?php echo form_error('DOJ');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="personal_email" class="control-label"><span class="text-danger">*</span>Personal Email Id</label><span class="text-info"> (Max. 60 chars)</span>
							<div class="form-group has-feedback">
								<input type="text" name="personal_email" value="<?php echo $this->input->post('personal_email'); ?>" class="form-control input-ui-100" id="personal_email" maxlength="60" onblur="check_personal_email_availibility(this.value,'add');"/>
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								<span class="text-danger email_err_p"><?php echo form_error('personal_email');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="country_code_pers" class="control-label"><span class="text-danger">*</span>Country code</label>
							<div class="form-group">
								<select name="country_code_pers" id="country_code_pers" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
									<option value=""> Country code</option>
									<?php
									foreach($all_country_code as $b){
										$selected=($b['country_code'] == '+91') ? ' selected="selected"' : "";
										echo '<option value="'.$b['country_code'].'" '.$selected.'>'.$b['iso3'].' - '.$b['country_code'].'</option>';
									}
									?>
								</select>
								<span class="text-danger country_code_pers_err"><?php echo form_error('country_code_pers');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="personal_contact" class="control-label"><span class="text-danger">*</span>Personal Mobile no.</label>
							<div class="form-group has-feedback">
								<input type="text" name="personal_contact" value="<?php echo $this->input->post('personal_contact'); ?>" class="form-control chknum1 input-ui-100" id="personal_contact" maxlength="10" minlength="10"  onblur="check_personal_mobile_availibility(this.value);"/>
								<span class="glyphicon glyphicon-phone form-control-feedback"></span>
								<span class="text-danger personal_contact_err"><?php echo form_error('personal_contact');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="center_id_home" class="control-label"><span class="text-danger">*</span>Home Branch</label>
							<div class="form-group">
								<select name="center_id_home" id="center_id_home" class="form-control selectpicker selectpicker-ui-100">
									<option value="">Select Home Branch</option>
									<?php
									foreach($all_branch as $b){
										$selected = ($b['center_id'] == $this->input->post('center_id_home')) ? ' selected="selected"' : "";
										echo '<option value="'.$b['center_id'].'" '.$selected.'>'.$b['center_name'].'</option>';
									}
									?>
								</select>
								<span class="text-danger center_id_home_err"><?php echo form_error('center_id_home');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="emp_designation" class="control-label"><span class="text-danger">*</span>Designation</label>
							<div class="form-group">
								<select name="emp_designation" id="emp_designation" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
									<option value="">Select designation</option>
									<?php
									foreach($all_designation as $r){
										$selected = ($r['id'] == $this->input->post('emp_designation')) ? ' selected="selected"' : "";
										echo '<option value="'.$r['id'].'" '.$selected.'>'.$r['designation_name'].'</option>';
									}
									?>
								</select>
								<span class="text-danger emp_designation_err"><?php echo form_error('emp_designation');?></span>
							</div>
						</div>

						<!-- <div class="col-md-3">
							<label for="role_id" class="control-label"><span class="text-danger">*</span>Role</label>
							<div class="form-group">
								<select name="role_id" id="role_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" onchange="display_trainerCourse(this.value);">
									<option value="">Select role</option>
									<?php
									foreach($all_roles as $r){
										$selected = ($r['id'] == $this->input->post('role_id')) ? ' selected="selected"' : "";
										echo '<option value="'.$r['id'].'" '.$selected.'>'.$r['name'].'</option>';
									}
									?>
								</select>
								<span class="text-danger role_id_err"><?php echo form_error('role_id');?></span>
							</div>
						</div> -->

						<!-- trainer options start -->
						<!-- <div class="col-md-12 testPgmBatchDiv" style="display: none;">
							<div class="col-md-3">
								<label for="test_module_id" class="control-label">Allowed Courses</label>
								<div class="form-group">
									<select name="test_module_id[]" id="test_module_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true"  data-actions-box="true" onchange="reflectPgmBatch(this.value,'userPage');" multiple="multiple">
										<option value="" disabled="disabled">Select Course</option>
										<?php
										foreach($all_test_module as $t){
											$selected = ($t['test_module_id'] == $this->input->post('test_module_id')) ? ' selected="selected"' : "";
											echo '<option value="'.$t['test_module_id'].'" '.$selected.'>'.$t['test_module_name'].'</option>';
										}
										?>
									</select>
									<span class="text-danger"><?php echo form_error('test_module_id');?></span>
								</div>
							</div>
							<div class="col-md-3">
								<label for="programe_id" class="control-label">Allowed Program</label>
								<div class="form-group">
									<select name="programe_id[]" id="programe_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" data-actions-box="true"  multiple="multiple">
										<option value="" disabled="disabled">Select Program</option>
										<?php
										foreach($all_programe_masters as $pgm){
											$selected = ($pgm['programe_id'] == $this->input->post('programe_id')) ? ' selected="selected"' : "";
											echo '<option value="'.$pgm['programe_id'].'" '.$selected.'>'.$pgm['programe_name'].'</option>';
										}
										?>
									</select>
									<span class="text-danger"><?php echo form_error('programe_id');?></span>
								</div>
							</div>
							<div class="col-md-3">
								<label for="batch_id" class="control-label">Allowed Batch</label>
								<div class="form-group">
									<select name="batch_id[]" id="batch_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true"  data-actions-box="true" multiple="multiple">
										<option value="" disabled="disabled">Select Batch</option>
										<?php
										foreach($all_batches as $b){
											$selected = ($b['batch_id'] == $this->input->post('batch_id')) ? ' selected="selected"' : "";
											echo '<option value="'.$b['batch_id'].'" '.$selected.'>'.$b['batch_name'].'</option>';
										}
										?>
									</select>
									<span class="text-danger"><?php echo form_error('batch_id');?></span>
								</div>
							</div>
							<div class="col-md-3">
								<label for="category_id" class="control-label">Allowed Category</label>
								<div class="form-group">
									<select name="category_id[]" id="category_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true"  data-actions-box="true" multiple="multiple">
										<option value="" disabled="disabled">Select Category</option>
										<option value="ALL">ALL</option>
										<option value="Listening">Listening</option>
										<option value="Reading">Reading</option>
										<option value="Writing">Writing</option>
										<option value="Speaking">Speaking</option>
									</select>
									<span class="text-danger"><?php echo form_error('category_id');?></span>
								</div>
							</div>
						</div> -->
						<!-- trainer options ends -->

						<?php
							$division_id=$this->input->post('division_id');
						?>
						<div class="col-md-3">
							<label for="division_id" class="control-label"><span class="text-danger">*</span>Division</label>
							<div class="form-group">
								<select name="division_id[]" id="division_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" onchange="loadFuntionalBranchListByDivision();">
									<option value="" disabled="disabled">Select Division</option>
									<?php
									foreach($all_division as $b){
										$selected = in_array($b['id'],$division_id) ? ' selected="selected"' : "";
										echo '<option value="'.$b['id'].'" '.$selected.'>'.$b['division_name'].'</option>';
									}
									?>
								</select>
								<span class="text-danger division_id_err"><?php echo form_error('division_id[]');?></span>
							</div>
						</div>
						<?php
							$center_id=$this->input->post('center_id');
							$branch_list=array();
							if(!empty($division_id)){
								$branch_list=$this->Center_location_model->funtionalBranchListByDivision($division_id);
							}
						?>
						<div class="col-md-3">
							<label for="center_id" class="control-label"><span class="text-danger">*</span>Employee Functional Branch</label>
							<div class="form-group FuncBr">
								<select name="center_id[]" id="center_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
									<option value="" disabled="disabled">Functional Branch</option>
									<?php
									foreach($branch_list as $key=>$val){
										$selected = in_array($val['center_id'],$center_id) ? ' selected="selected"' : "";
									?>
									<option value="<?php echo $val['center_id']?>" <?php echo $selected ?>><?php echo $val['center_name'] ?></option>
									<?php } ?>
								</select>
								<span class="text-danger center_id_err"><?php echo form_error('center_id[]');?></span>
							</div>
						</div>

						<?php
							$country_id=$this->input->post('country_id');
						?>
						<div class="col-md-3">
							<label for="country_id" class="control-label">Functional Visa Service Country</label>
							<div class="form-group">
								<select name="country_id[]" id="country_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
									<option value="" disabled="disabled">Select Functional Country</option>
									<?php
									foreach($all_countryNoIndia as $p){
										$selected = in_array($p['country_id'],$country_id) ? ' selected="selected"' : "";
										echo '<option value="'.$p['country_id'].'" '.$selected.'>'.$p['name'].'</option>';
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-3">
							<label for="country_id2" class="control-label">Employee Country<span class="text-danger">*</span></label>
							<div class="form-group">
								<select name="country_id2" id="country_id2" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_state_list(this.value)">
									<option data-subtext="" value="">Select country</option>
									<?php
									foreach($all_country_list as $p)
									{
										$selected = ($p['country_id'] == $this->input->post('country_id')) ? ' selected="selected"' : "";
										echo '<option value="'.$p['country_id'].'" '.$selected.'>'.$p['name'].'</option>';
									}
									?>
								</select>
								<span class="text-danger country_id2_err"><?php echo form_error('country_id2');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="state_id" class="control-label">Employee State<span class="text-danger">*</span></label>
							<div class="form-group" id="state_dd">
								<select name="state_id" id="state_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_city_list(this.value)">
									<option data-subtext="" value="">Select state</option>
									<?php
										$selected = $this->input->post('state_id') ? ' selected="selected"' : "";
										echo '<option value="'.$this->input->post('state_id').'" '.$selected.'>'.$p['state_name'].'</option>';
									?>
								</select>
								<span class="text-danger state_id_err"><?php echo form_error('state_id');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="city_id" class="control-label">Employee City<span class="text-danger">*</span></label>
							<div class="form-group" id="city_dd">
								<select name="city_id" id="city_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" >
									<option data-subtext="" value="">Select city</option>
								</select>
								<span class="text-danger city_id_err"><?php echo form_error('city_id');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="residential_address" class="control-label"><span class="text-danger">*</span>Employee Address</label>
							<div class="form-group">
								<input type="text" name="residential_address" class="form-control input-ui-100" id="residential_address" value="<?php echo $this->input->post('residential_address'); ?>">
								<span class="text-danger residential_address_err"><?php echo form_error('residential_address');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<input type="checkbox" name="active" value="1" id="active" class="checkbox-btn-ui" checked="checked"/>
								<label for="active" class="control-label">Active</label>
							</div>
						</div>

					</div>
				</div>
				<div class="box-footer">
				<div class="col-md-12">
					<button type="submit" class="btn btn-danger sbm rd-20">
						<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
					</button>
				</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>



