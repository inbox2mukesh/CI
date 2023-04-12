<div class="user-edit">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Employee<?php echo SEP;?>Profile</h3>
				</div>
				<?php echo $this->session->flashdata('flsh_msg');?>
				<?php echo form_open_multipart('adminController/user/edit/'.base64_encode($user['id']), array('onsubmit' => 'return validate_employee_form();'));?>
				<div class="box-body">
				
						<input type="hidden" name="userId_hidden" id="userId_hidden" value="<?php echo $user['id'];?>">
						<input type="hidden" name="page" id="page" value="edit">
						<div class="col-md-3">
							<label for="employeeCode" class="control-label"><span class="text-danger">*</span>Employe Code</label>
							<div class="form-group">
								<input type="text" name="employeeCode" value="<?php echo ($this->input->post('employeeCode') ? $this->input->post('employeeCode') : $user['employeeCode']); ?>" class="form-control chknum1 input-ui-100" id="employeeCode" maxlength="6" minlength="6" onblur="check_employeeCode_availibility_edit(this.value);"/>
								<span class="text-danger employeeCode_err"><?php echo form_error('employeeCode');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="image" class="control-label">Emp Image</label><?php echo EMP_ALLOWED_TYPES_LABEL;?>
							<div class="form-group" style="margin-bottom:0px;">
							<input type="file" name="image" class="form-control input-ui-100" id="image" onchange="validate_file_type(this.id);"/>
							<span>
									<?php
									if(isset($user['image'])){
										echo '<span>
												<a href="'.site_url(EMP_IMAGE_PATH.$user['image']).'" target="_blank">'.$user['image'].'</a>
											</span>';
											echo '<input type="hidden" name="uploaded_image" id="uploaded_image" value="'.EMP_IMAGE_PATH.$user['image'].'">';
									}else{
										echo NO_FILE;
									}
									?>
							</span>
							<span class="text-danger image_err" style="bottom:-9px;"><?php echo form_error('image');?></span>						
						</div>
							
						</div>

						<div class="col-md-3">
							<label for="fname" class="control-label"><span class="text-danger">*</span>First name</label>
							<div class="form-group">
								<input type="text" name="fname" value="<?php echo ($this->input->post('fname') ? $this->input->post('fname') : $user['fname']); ?>" class="form-control input-ui-100" id="fname" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" maxlength="30"/>
								<span class="text-danger fname_err"><?php echo form_error('fname');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="lname" class="control-label">Last name</label>
							<div class="form-group">
								<input type="text" name="lname" value="<?php echo ($this->input->post('lname') ? $this->input->post('lname') : $user['lname']); ?>" class="form-control input-ui-100" id="lname" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" maxlength="30"/>
							</div>
						</div>

						<div class="col-md-3">
							<label for="gender_name" class="control-label"><span class="text-danger">*</span>Gender</label>
							<div class="form-group">
								<select name="gender_name" id="gender_name" class="form-control selectpicker selectpicker-ui-100">
									<option data-subtext="" value="">Select gender</option>
									<?php
									foreach($all_genders as $g)
									{
										$selected = ($g['id'] == $user['gender']) ? ' selected="selected"' : "";
										echo '<option value="'.$g['id'].'" '.$selected.'>'.$g['gender_name'].'</option>';
									}
									?>
								</select>
								<span class="text-danger gender_name_err"><?php echo form_error('gender_name');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="dob" class="control-label"><span class="text-danger">*</span>Date of birth</label>
							<div class="form-group has-feedback">
								<input type="text" name="dob" value="<?php echo ($this->input->post('dob') ? $this->input->post('dob') : $user['dob']); ?>" class="noFutureDate form-control input-ui-100" id="dob" maxlength="10" autocomplete="off"/>
								<span class="glyphicon form-control-feedback"><i class="fa fa-birthday-cake"></i></span>
								<span class="text-danger dob_err"><?php echo form_error('dob');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="MA" class="control-label">Date of anniversary</label>
							<div class="form-group has-feedback">
								<input type="text" name="MA" value="<?php echo ($this->input->post('MA') ? $this->input->post('MA') : $user['MA']); ?>" class="noFutureDate form-control input-ui-100" id="MA" maxlength="10" autocomplete="off"/>
								<span class="glyphicon form-control-feedback"><i class="fa fa-birthday-cake"></i></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="DOJ" class="control-label"><span class="text-danger">*</span>Date of joining</label>
							<div class="form-group has-feedback">
								<input type="text" name="DOJ" value="<?php echo ($this->input->post('DOJ') ? $this->input->post('DOJ') : $user['DOJ']); ?>" class="datepicker form-control input-ui-100" id="DOJ" maxlength="10" autocomplete="off"/>
								<span class="glyphicon form-control-feedback"><i class="fa fa-link"></i></span>
								<span class="text-danger DOJ_err"><?php echo form_error('DOJ');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="DOE" class="control-label">Date of exit</label>
							<div class="form-group has-feedback">
								<input type="text" name="DOE" value="<?php echo ($this->input->post('DOE') ? $this->input->post('DOE') : $user['DOE']); ?>" class="form-control noBackDate input-ui-100" id="DOE" maxlength="10" autocomplete="off" readonly/>
								<span class="glyphicon form-control-feedback"><i class="fa fa-sign-out"></i></span>
								<span class="text-danger DOE_err"><?php echo form_error('DOE');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="personal_email" class="control-label"><span class="text-danger">*</span>Personal Email Id</label><span class="text-danger"> (Max. 60 chars)</span>
							<div class="form-group has-feedback">
								<input type="text" name="personal_email" value="<?php echo ($this->input->post('personal_email') ? $this->input->post('personal_email') : $user['personal_email']); ?>" class="form-control input-ui-100" id="personal_email" maxlength="60" onblur="check_personal_email_availibility(this.value,'edit');"/>
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								<span class="text-danger email_err_p"><?php echo form_error('personal_email');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="email" class="control-label"> Official Email Id</label><span class="text-danger"> (Max. 60 chars)</span>
							<div class="form-group has-feedback">
								<input type="text" name="email" value="<?php echo ($this->input->post('email') ? $this->input->post('email') : $user['email']); ?>" class="form-control input-ui-100" id="email" maxlength="60" onblur="check_official_email_availibility(this.value);"/>
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								<span class="text-danger email_err_o"><?php echo form_error('email');?></span>
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
								<input type="text" name="personal_contact" value="<?php echo ($this->input->post('personal_contact') ? $this->input->post('personal_contact') : $user['personal_contact']); ?>" class="form-control chknum1 input-ui-100" id="personal_contact" maxlength="10" onblur="check_personal_mobile_availibility_edit(this.value);"/>
								<span class="text-danger personal_contact_err"><?php echo form_error('personal_contact');?>
								</span>
								<span class="glyphicon glyphicon-phone form-control-feedback"></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="country_code_offc" class="control-label">Country code</label>
							<div class="form-group">
								<select name="country_code_offc" id="country_code_offc" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
									<option value="">Country code</option>
									<?php
									foreach($all_country_code as $b){
										$selected=($b['country_code'] == '+91') ? ' selected="selected"' : "";
										echo '<option value="'.$b['country_code'].'" '.$selected.'>'.$b['iso3'].' - '.$b['country_code'].'</option>';
									}
									?>
								</select>
								<span class="text-danger country_code_offc_err"><?php echo form_error('name="country_code_offc"');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="mobile" class="control-label">Official Mobile no.</label>
							<div class="form-group has-feedback">
								<input type="text" name="mobile" value="<?php echo ($this->input->post('mobile') ? $this->input->post('mobile') : $user['mobile']); ?>" class="form-control chknum1 input-ui-100" id="mobile" maxlength="10" />
								<span class="glyphicon glyphicon-phone form-control-feedback"></span>
								<span class="text-danger mobile_err"><?php echo form_error('name="country_code_offc"');?></span>
							</div>
						</div>

						<div class="col-md-3">
							<label for="center_id_home" class="control-label"><span class="text-danger">*</span>Home Branch</label>
							<div class="form-group">
								<select name="center_id_home" id="center_id_home" class="form-control selectpicker selectpicker-ui-100">
									<option value="">Select Home Branch</option>
									<?php
									foreach($all_branch as $b){
										$selected = ($b['center_id'] == $user['center_id_home']) ? ' selected="selected"' : "";
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
										$selected = ($r['id'] == $user['emp_designation']) ? ' selected="selected"' : "";
										echo '<option value="'.$r['id'].'" '.$selected.'>'.$r['designation_name'].'</option>';
									}
									?>
								</select>
								<span class="text-danger emp_designation_err"><?php echo form_error('emp_designation');?></span>
							</div>
						</div>

							<?php
							$division_id =$this->input->post('division_id');
							@$division_id=isset($division_id) ? $division_id:$user['division_id'];
							?>
							<div class="col-md-12">
								<label for="division_id" class="control-label"><span class="text-danger">*</span>Division</label>
								<?php
									foreach ($user_division as $c) {
									echo '<button type="button" class="btn btn-info btn-sm del" onclick=deleteUserDivision('.$c["division_id"].','.$user["id"].')>
									'.$c["division_name"].'<i class="fa fa-close cross-icn"></i></button>&nbsp;';
								} ?>
								<div class="form-group">
									<select name="division_id[]" id="division_id" class="form-control selectpicker selectpicker-ui-100"data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple" onchange="loadFuntionalBranchListByDivision();">
										<option value="" disabled="disabled">Select Division</option>
										<?php
										foreach($all_division as $b){
											$selected ='';
											echo '<option value="'.$b['id'].'" '.$selected.'>'.$b['division_name'].'</option>';
										}
										?>
									</select>
									<span class="text-danger division_id_err"><?php echo form_error('division_id[]');?></span>
								</div>
							</div>

							<div class="col-md-12">
								<label for="center_id" class="control-label"><span class="text-danger">*</span>Employee Functional Branch</label>
								<?php
									foreach ($user_branch as $c) {
									echo '<button type="button" class="btn btn-info btn-sm del" onclick=deleteUserBranch('.$c["center_id"].','.$user["id"].')>
									'.$c["center_name"].'<i class="fa fa-close cross-icn"></i></button>&nbsp;';
								} ?>
								<div class="form-group FuncBr">
									<select name="center_id[]" id="center_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
										<option value="" disabled="disabled">Select Functional Branch</option>
										<?php
										foreach($branch_list as $key=>$val){
										?>
										<option value="<?php echo $val['center_id']?>"><?php  echo $val['center_name'] ?></option>
										<?php
										}
										?>
									</select>
									<span class="text-danger center_id_err"><?php echo form_error('center_id[]');?></span>
								</div>
							</div>

							<div class="col-md-12">
								<label for="country_id" class="control-label">Functional Visa Service Country</label>
								<?php
									foreach ($user_country as $c) {
									echo '<button type="button" class="btn btn-warning btn-sm del" onclick=deleteUserCountry('.$c["country_id"].','.$user["id"].')>
									'.$c["name"].'<i class="fa fa-close cross-icn"></i></button>&nbsp;';
								} ?>
								<div class="form-group">
									<select name="country_id[]" id="country_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" data-actions-box="true"  multiple="multiple">
										<option value="" disabled="disabled">Select Functional Country</option>
										<?php
										foreach($all_countryNoIndia as $p){
											$selected = ($p['country_id'] == $this->input->post('country_id')) ? ' selected="selected"' : "";
											echo '<option value="'.$p['country_id'].'" '.$selected.'>'.$p['name'].'</option>';
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-md-4">
								<label for="country_id2" class="control-label"><span class="text-danger">*</span>Employee Country</label>
								<div class="form-group">
									<select name="country_id2" id="country_id2" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_state_list(this.value)">
										<option  data-subtext="" value="">Select country</option>
										<?php
										foreach($all_country_list as $p){
											$selected = ($p['country_id'] == $user['country_id']) ? ' selected="selected"' : "";
											echo '<option data-subtext="'.$p['name'].'" value="'.$p['country_id'].'" '.$selected.'>'.$p['name'].'</option>';
										}
										?>
									</select>
									<span class="text-danger country_id2_err"><?php echo form_error('country_id2');?></span>
								</div>
							</div>

							<div class="col-md-4">
								<label for="state_id" class="control-label"><span class="text-danger">*</span>Employee State</label>
								<div class="form-group" id="state_dd">
									<select name="state_id" id="state_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="get_city_list(this.value)">
										<option  data-subtext="" value="">Select state</option>
										<?php
										foreach($all_state_list as $p){
											$selected = ($p['state_id'] == $user['state_id']) ? ' selected="selected"' : "";
											echo '<option data-subtext="'.$p['state_name'].'" value="'.$p['state_id'].'" '.$selected.'>'.$p['state_name'].'</option>';
										}
										?>
									</select>
									<span class="text-danger state_id_err"><?php echo form_error('state_id');?></span>
								</div>
							</div>

							<div class="col-md-4">
								<label for="city_id" class="control-label"><span class="text-danger">*</span>Employee City</label>
								<div class="form-group" id="city_dd">
									<select name="city_id" id="city_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
										<option data-subtext="" value="">Select city</option>
										<?php
										foreach($all_city_list as $p){
											$selected = ($p['city_id'] == $user['city_id']) ? ' selected="selected"' : "";
											echo '<option data-subtext="'.$p['city_name'].'" value="'.$p['city_id'].'" '.$selected.'>'.$p['city_name'].'</option>';
										}
										?>
									</select>
									<span class="text-danger city_id_err"><?php echo form_error('city_id');?></span>
								</div>
							</div>

							<div class="col-md-12">
								<label for="residential_address" class="control-label"><span class="text-danger">*</span>Employee Address</label>
								<div class="form-group">
									<input type="text" name="residential_address" class="form-control input-ui-100" id="residential_address" value="<?php echo ($this->input->post('residential_address') ? $this->input->post('residential_address') : $user['residential_address']); ?>">
									<span class="text-danger residential_address_err"><?php echo form_error('residential_address');?></span>
								</div>
							</div>

							<div class="col-md-12">
							<div class="form-group form-checkbox">								
								<input type="checkbox" name="active" <?php echo ($user['active']==1 ? 'checked="checked"' : ''); ?> id='active' />
								<label for="active" class="control-label">Active</label>
							</div>
						</div>

				
				</div>
				<div class="box-footer">
				<div class="col-md-12">
					<button type="submit" class="btn btn-danger sbm rd-20">
						<?php echo UPDATE_LABEL;?>
					</button>
				</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>