<style type="text/css">
	input[type="checkbox"][readonly] {
  	pointer-events: none;
}
</style>
<div class="student-add_widget">
<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
            </div>

            <?php echo $this->session->flashdata('flsh_msg');?>
            <?php echo form_open_multipart('adminController/student/add'); ?>
          	<div class="box-body">
          		<div class="row clearfix">

          			<div class="col-md-12">
						<label for="service_id" class="control-label"><span class="text-danger">*</span>Student's Status</label>
						<div class="form-group">
							<select name="service_id" id="service_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" onchange="GetService(this.value)">
								<option value="">Select Student's Status</option>
								<?php
								foreach($all_services as $t){
									$selected = ($t['service_id'] == $this->input->post('service_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$t['service_id'].'" '.$selected.'>'.$t['service_name'].' - '.$t['short_code'].'</option>';
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('service_id');?></span>
						</div>
					</div>

					<div class="col-md-12">
			            <label for="profile_pic" class="control-label">Profile Pic </label><?php echo PROFILE_PIC_ALLOWED_TYPES_LABEL;?>
			            <div class="form-group">
			              <input type="file" name="profile_pic" value="<?php echo $this->input->post('profile_pic'); ?>" class="form-control" id="profile_pic"/>
			            </div>
          			</div>

          			<div class="col-md-4">
						<label for="country_code" class="control-label"><span class="text-danger">*</span>Country code</label>
						<div class="form-group">
							<select name="country_code" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
								<option value=""> Country code</option>
								<?php
								foreach($all_country_code as $b){
									if(isset($_SESSION['country_code'])){

										$selected=($b['country_code'] == $_SESSION['country_code']) ? ' selected="selected"' : "";
										echo '<option value="'.$b['country_code'].'" '.$selected.'>'.$b['iso3'].' - '.$b['country_code'].'</option>';
									}else{
										$selected=($b['country_code'] == '+91') ? ' selected="selected"' : "";
										echo '<option value="'.$b['country_code'].'" '.$selected.'>'.$b['iso3'].' - '.$b['country_code'].'</option>';
									}
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('country_code');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="mobile" class="control-label"><span class="text-danger">*</span>Mobile no.</label>
						<div class="form-group has-feedback">
							<?php if(isset($_SESSION['mobile'])){ ?>
								<input type="text" name="mobile" value="<?php echo $_SESSION['mobile'];?>" class="form-control" id="mobile" maxlength="10" minlength="10" onblur="check_std_mobile_availibility(this.value);" readonly="readonly"/>
							<?php }else{ ?>
								<input type="text" name="mobile" value="<?php echo $this->input->post('mobile'); ?>" class="form-control" id="mobile" maxlength="10" minlength="10" onblur="check_std_mobile_availibility(this.value);"  readonly="readonly"/>
							<?php } ?>

							<span class="glyphicon glyphicon-phone form-control-feedback"></span>
							<span class="text-danger mobile_err"><?php echo form_error('mobile');?></span>
						</div>
					</div>

					<div class="col-md-2">
						<label for="get_otp" class="control-label">Get OTP</label>
						<div class="form-group">
							<button type="button" class="btn btn-danger get_otp" style="height: 33px !important;" onclick="get_otp();">Get OTP</button>
						</div>
					</div>

					<div class="col-md-4">
						<label for="otp" class="control-label"><span class="text-danger">*</span>Enter OTP</label>
						<div class="form-group">
							<input type="text" name="otp" class="form-control" id="otp" maxlength="4" /><span class="text-danger otp_err"></span>
						</div>
					</div>


					<div class="col-md-4">
						<label for="source_id" class="control-label"><span class="text-danger">*</span> Source</label>
						<div class="form-group">
							<select name="source_id" id="source_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
								<option value="">Select Source</option>
								<?php
								foreach($all_source as $b)
								{
									$selected = ($b['id'] == $this->input->post('source_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$b['id'].'" '.$selected.'>'.$b['source_name'].'</option>';
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('source_id');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="gender_name" class="control-label"><span class="text-danger">*</span>Gender</label>
						<div class="form-group">
							<select name="gender_name" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
								<option value="">Select gender</option>
								<?php
								foreach($all_genders as $p)
								{
									if($this->input->post('gender_name')){
										$selected = ($p['id'] == $this->input->post('gender_name')) ? ' selected="selected"' : "";
									}else{
										$selected= ($p['id'] == 1) ? ' selected="selected"' : "";
									}

									echo '<option value="'.$p['id'].'" '.$selected.'>'.$p['gender_name'].'</option>';
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('gender_name');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="email" class="control-label">Email Id</label>
						<div class="form-group has-feedback">
							<input type="text" name="email" value="<?php echo $this->input->post('email'); ?>" class="form-control" id="email" maxlength="60" onblur="check_std_email_availibility(this.value);"/>
							<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							<span class="text-danger val_err"><?php echo form_error('email');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="fname" class="control-label"><span class="text-danger">*</span>First name</label>
						<div class="form-group">
							<input type="text" name="fname" value="<?php echo $this->input->post('fname'); ?>" class="form-control" id="fname" onblur="validate_fname(this.value);" />
							<span class="text-danger fname_err"><?php echo form_error('fname');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="lname" class="control-label">Last name</label>
						<div class="form-group">
							<input type="text" name="lname" value="<?php echo $this->input->post('lname'); ?>" class="form-control" id="lname" onblur="validate_lname(this.value);" />
							<span class="text-danger lname_err"><?php echo form_error('lname');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="dob" class="control-label">Student DOB <?php echo DATE_FORMAT_LABEL;?></label>
						<div class="form-group has-feedback">
							<input type="text" name="dob" value="<?php echo $this->input->post('dob'); ?>" class="has-datepicker form-control" id="dob" />
							<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="father_name" class="control-label">Father name</label>
						<div class="form-group">
							<input type="text" name="father_name" value="<?php echo $this->input->post('father_name'); ?>" class="form-control" id="father_name" onblur="validate_fatname(this.value);" />
							<span class="text-danger father_name_err"><?php echo form_error('father_name');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="father_dob" class="control-label">Father DOB <?php echo DATE_FORMAT_LABEL;?></label>
						<div class="form-group has-feedback">
							<input type="text" name="father_dob" value="<?php echo $this->input->post('father_dob'); ?>" class="has-datepicker form-control" id="father_dob" />
							<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="mother_name" class="control-label">Mothers name</label>
						<div class="form-group">
							<input type="text" name="mother_name" value="<?php echo $this->input->post('mother_name'); ?>" class="form-control" id="mother_name" onblur="validate_motname(this.value);" />
							<span class="text-danger father_name_err"><?php echo form_error('mother_name');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="mother_dob" class="control-label">Mother DOB <?php echo DATE_FORMAT_LABEL;?></label>
						<div class="form-group has-feedback">
							<input type="text" name="mother_dob" value="<?php echo $this->input->post('mother_dob'); ?>" class="has-datepicker form-control" id="mother_dob" />
							<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="parents_anniversary" class="control-label">Parents Anniv.</label>
						<div class="form-group has-feedback">
							<input type="text" name="parents_anniversary" value="<?php echo $this->input->post('parents_anniversary'); ?>" class="has-datepicker form-control" id="parents_anniversary" />
							<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="gaurdian_contact" class="control-label">Gaurdian Contact No.</label>
						<div class="form-group has-feedback">
							<input type="text" name="gaurdian_contact" value="<?php echo $this->input->post('gaurdian_contact'); ?>" class="form-control" id="gaurdian_contact" maxlength=10/>
						</div>
					</div>

					<div class="col-md-4">
						<label for="qualification_id" class="control-label"> Qualification</label>
						<div class="form-group">
							<select name="qualification_id" id="qualification_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
								<option value="">Select Qualification</option>
								<?php
								foreach($allQua as $t)
								{
									$selected = ($t['id'] == $this->input->post('qualification_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$t['id'].'" '.$selected.'>'.$t['qualification_name'].'</option>';
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('qualification_id');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="int_country_id" class="control-label"> Intrested Country</label>
						<div class="form-group">
							<select name="int_country_id" id="int_country_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
								<option value="">Select Intrested Country </option>
								<?php
								foreach($allCnt as $t)
								{
									$selected = ($t['country_id'] == $this->input->post('int_country_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$t['country_id'].'" '.$selected.'>'.$t['name'].'</option>';
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('int_country_id');?></span>
						</div>
					</div>


					<div class="col-md-12">
						<label for="residential_address" class="control-label">Permanent Address</label>
						<div class="form-group has-feedback">
							<textarea name="residential_address" class="form-control" id="residential_address"><?php echo $this->input->post('residential_address'); ?></textarea>
							<span class="glyphicon glyphicon-home form-control-feedback"></span>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="cred" class="control-label">
							<span class="text-danger"><i><?php echo CREDS_NOTES;?></i> </span></label>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
						<input type="checkbox" name="mail_sent" value="1" id="mail_sent" checked="checked" readonly/>
						<label class="control-label">Do you wish to send E-Mail?</label>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<input type="checkbox" name="active" value="1" id="active" checked="checked" readonly/>
							<label class="control-label">Active <span class="text-info">(Means able to login)</span></label>
						</div>
					</div>

					<div class="col-md-4">
						<label for="test_module_id" class="control-label"><span class="text-danger">*</span>Intrested in Course</label>
						<div class="form-group">
							<select name="test_module_id" id="test_module_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'student');">
								<option value="">Select Course</option>
								<?php
								foreach($all_test_module as $t)
								{
									$selected = ($t['test_module_id'] == $this->input->post('test_module_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$t['test_module_id'].'" '.$selected.'>'.$t['test_module_name'].'</option>';
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('test_module_id');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="programe_id" class="control-label"><span class="text-danger">*</span>Intrested in Program</label>
						<div class="form-group">
							<select name="programe_id" id="programe_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
								<option value="">Select Program</option>
								<?php
								foreach($all_programe_masters as $programe_master)
								{
									$selected = ($programe_master['programe_id'] == $this->input->post('programe_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$programe_master['programe_id'].'" '.$selected.'>'.$programe_master['programe_name'].'</option>';
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('programe_id');?></span>
						</div>
					</div>

					<div class="col-md-4">
						<label for="center_id" class="control-label"><span class="text-danger">*</span>Branch</label>
						<div class="form-group">
							<select name="center_id" id="center_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" onchange="unsetPackRadio();">
								<option value="">Select Branch</option>
								<?php
								foreach($all_branch as $b)
								{
									$selected = ($b['center_id'] == $this->input->post('center_id')) ? ' selected="selected"' : "";
									echo '<option value="'.$b['center_id'].'" '.$selected.'>'.$b['center_name'].'</option>';
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('center_id');?></span>
						</div>
					</div>

				</div>
			</div>
          	<div class="box-footer">
            	<button type="submit" class="btn btn-danger add_std_pack" onclick="return confirm('<?php echo SUBMISSION_CONFIRM;?>');">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>
</div

