<div class="student-student_verification">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo $title;?></h3>
				</div>
				<?php echo $this->session->flashdata('flsh_msg');?>
				<?php echo form_open('adminController/student/student_verification'); ?>
				<div class="box-body">
		

						<div class="col-md-4">
							<label for="country_code" class="control-label"> Country code</label>
							<div class="form-group">
								<select name="country_code" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
									<option value=""> Country code</option>
									<?php
									foreach($all_country_code as $b){

										$selected=($b['country_code'] == '+91') ? ' selected="selected"' : "";
										echo '<option value="'.$b['country_code'].'" '.$selected.'>'.$b['iso3'].' - '.$b['country_code'].'</option>';

									}
									?>
								</select>
								<span class="text-danger"><?php echo form_error('country_code');?></span>
							</div>
						</div>

						<div class="col-md-4">
							<label for="mobile" class="control-label"> Mobile no.</label>							
							<div class="form-group">
								<div style="display:flex">								
									<span class="has-feedback" style="flex-grow: 1;">
									<input type="text" name="mobile" value="<?php echo $this->input->post('mobile'); ?>" class="form-control  input-ui-100" id="mobile" maxlength="10" minlength="10" onblur="validate_phone(this.value);"/>
									<span class="glyphicon glyphicon-phone form-control-feedback"></span>
									</span>
									<button type="button" class="btn btn-danger send_mobile_otp rd-20 ml-5" style="height: 33px !important;" onclick="send_mobile_otp();" disabled="disabled">Send Mobile OTP <i class="fa fa-send text-light"></i></button>
								</div>
								<span class="text-danger mobile_err"><?php echo form_error('mobile');?></span>
							</div>
						</div>
						<div class="col-md-4">
							<label for="mobileOTP" class="control-label">Mobile OTP Recieved</label>
							<div class="form-group">
								<input type="text" name="mobileOTP" id="mobileOTP" class="form-control input-ui-100"  maxlength="4" readonly="readonly" /><span class="text-success mobile_otp_err"></span>
							</div>
						</div>
			

						<div class="col-md-4">
							<label for="email" class="control-label">Email Id</label>
							<div class="form-group">
							<div style="display:flex">
							<span class="has-feedback" style="flex-grow: 1;">
								<input type="text" name="email" value="<?php echo $this->input->post('email'); ?>" class="form-control input-ui-100" id="email" maxlength="60" onblur="validate_email(this.value);"/>
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</span>
								<button type="button" class="btn btn-danger send_email_otp rd-20 ml-5" style="height: 33px !important;" onclick="send_email_otp();" disabled="disabled"> Send Email OTP <i class="fa fa-send text-light"></i></button>
								</div>
								<span class="text-danger email_err"><?php echo form_error('email');?></span>
							</div>
						</div>



						

						<div class="col-md-4">
							<label for="emailOTP" class="control-label">Email OTP Recieved</label>
							<div class="form-group">
								<input type="text" name="emailOTP" id="emailOTP" class="form-control input-ui-100"  maxlength="4" readonly="readonly" /><span class="text-success email_otp_err"></span>
							</div>
						</div>

					</div>
		
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

