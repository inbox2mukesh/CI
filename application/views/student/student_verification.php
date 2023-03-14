<div class="student-student_verification">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">
						<?php if(DEFAULT_COUNTRY == 101){ ?>Verify Mobile<?php } else { ?>Verify Email<?php } ?></h3>
				</div>
				<?php echo $this->session->flashdata('flsh_msg');?>
				<?php echo form_open('adminController/student/student_verification'); ?>
				<div class="box-body">
		
				<?php if (DEFAULT_COUNTRY == 101) { ?>
						<div class="col-md-4">
							<label for="country_code" class="control-label"> Country code</label>
							<div class="form-group">
								<select name="country_code" id="country_code" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
									
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
								<input type="text" name="mobileOTP" id="mobileOTP" class="form-control input-ui-100"  maxlength="4" maxlength="4" minlength="4" onblur="validate_optp(this.value);"/>
								<span class="text-success mobile_otp_err emailOTP_err" id="mobileOTP_err"></span>
							</div>
						</div>
			
<?php } else {?>
						<div class="col-md-4">
							<label for="email" class="control-label">Email Id</label>
							<div class="form-group">
							<div style="display:flex">
							<span class="has-feedback" style="flex-grow: 1;">
								<input type="text" name="email" value="<?php echo $this->input->post('email'); ?>" class="form-control input-ui-100" id="email" maxlength="60" onblur="validate_emailn_(this.value);"/>
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
								<input type="text" name="emailOTP" id="emailOTP" class="form-control input-ui-100 allow_numeric"  maxlength="4" minlength="4" onblur="validate_optp(this.value);"/>
								<span class="text-success email_otp_err emailOTP_err" id="emailOTP_err"></span>
							</div>
						</div>
						<?php }?>

					</div>
					<div class="box-footer">
                <button type="submit" class="btn btn-danger " disabled  id="check_stu_verify" onclick="return check_stu_verification();"><i class="fa fa-check"></i> <?php echo SAVE_LABEL;?></button>
          	</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php ob_start(); ?>
<script type="text/javascript">
	function validate_emailn_(email) {
	//var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
	if (email.match(mailformat)) {
		$(".email_err").text('');
		$(':input[type="submit"]').prop('disabled', false);
		$('.enqBtnv').prop('disabled', false);
		$('.send_email_otp').prop('disabled', false);
		$('#check_stu_verify').prop('disabled', true);
		return true;
	} else {
		$(".email_err").text("Please enter valid email Id!");
		$('#email').focus();
		$(':input[type="submit"]').prop('disabled', true);
		$('.enqBtnv').prop('disabled', true);
		$('.send_email_otp').prop('disabled', true);
		$('#check_stu_verify').prop('disabled', true);
		return false;
	}
}
function validate_optp(opt)
{
	if(opt.length<4 )
	{
	$(".emailOTP_err").html('Please enter valid OTP.');
	$('#check_stu_verify').prop('disabled', true);
	return false;
	}
	else { 

	$(".emailOTP_err").html('');
	$('#check_stu_verify').prop('disabled', false);
	return true;

	}


}
function check_stu_verification()
{
	var flag=1;
	<?php 	
	if (DEFAULT_COUNTRY == 101) { 
	?>
	var country_code=$('#country_code').val();
	var mobile=$('#mobile').val();
	var emailOTP=$('#mobileOTP').val();
	if(mobile == '')
	{
		$(".mobile_err").html('The mobile no field is required.');
		flag=0;
	} else { $(".mobile_err").html('');}

	if(emailOTP =="")
	{
		
		$("#mobileOTP_err").html('The OTP field is required.');
		flag=0;
	}
	else
	{ $("#mobileOTP_err").html('');}	
		
	
	if(flag == 0)
    {
		return false;
	}
	else {
		return true;
	}
	<?php } else {?>
		var email=$('#email').val();
	var emailOTP=$('#emailOTP').val();
	if(email == '')
	{
		$(".email_err").html('The Email ID field is required.');
		flag=0;
	} else { $(".email_err").html('');}
	
	if(emailOTP =="")
	{
		alert(emailOTP+'-666')
		$("#emailOTP_err").html('The OTP field is required.');
		flag=0;
	}
	else { 
	
		$("#emailOTP_err").html('');}	
	
	if(flag == 0)
    {
		return false;
	}
	else {
		return true;
	}
		<?php }?>
	

}
</script>
<?php global $customJs;
$customJs = ob_get_clean(); ?>

