<div class="registration">
		<div class="modal fade scroll-select-picker" id="modal-register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog modal-md">
				<div class="modal-content bg-white">
							<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
						<div class="modal-title text-uppercase">REGISTRATION</div>
					</div>
					<div class="modal-body">
						<div class="register-modal">
							<div class="info">
								<div class="hide" role="alert" id="regmain_msg_danger" >
									</div>
									 <div class="row">
										<div class="col-sm-6 ">
									<div class="form-group">
										<lable>First Name<span class="text-red">*</span></lable>
										<input  type="text" class="fstinput allow_alphabets length_validate" placeholder="" id="fname" name="fname"  value="<?php echo $this->input->post('fname'); ?>" maxlength="30" autocomplete="off">
										<div class="p-validation fname_err"><?php echo form_error('fname');?></div>
									</div></div>
									<div class="col-sm-6 ">
									<div class="form-group">
										<lable>Last Name</lable>
										<input type="text" class="fstinput allow_alphabets" placeholder="" id="lname" name="lname" value="<?php echo $this->input->post('lname'); ?>"  maxlength="30" autocomplete="off"> 
										<div class="p-validation lname_err"><?php echo form_error('lname');?></div>
										</div>
									</div>
								</div>

								<div class="row">
								<div class="col-sm-6">
									<div class="form-group selectpicker-auto">
										<lable>Country Code<span class="text-red">*</span></lable>
										<select class="selectpicker form-control" data-live-search="true" id="country_code" name="country_code">
											<option value="">Choose Country Code</option>
											<?php
												if(DEFAULT_COUNTRY==38){
													$c = 'CA';
												}elseif(DEFAULT_COUNTRY==13){
													$c = 'AU';
												}elseif(DEFAULT_COUNTRY==101){
													$c = 'IN';
												}else{
													$c = 'IN';
												}
        										
        										foreach($countryCode->error_message->data as $p){ 
										          if (trim($p->iso3) == $c){
										            $sel = "selected";
										          }else{
										            $sel = "";
										          }
										    ?>
          									<option value="<?php echo $p->country_code.'|'.$p->iso3; ?>" <?php echo $sel; ?>><?php echo $p->country_code. '- ' . $p->iso3; ?></option>
									        <?php } ?>
										</select>
										<div class="p-validation country_code_err"><?php echo form_error('country_code');?></div>
									</div>
								</div>
									<div class="col-sm-6 ">
									<div class="form-group">
										<lable>Phone Number<span class="text-red">*</span></lable>
										<input type="tel" class="fstinput allow_numeric" placeholder="" id="mobile" name="mobile" value="<?php echo $this->input->post('mobile'); ?>"  maxlength="10" autocomplete="off"> 
										<div class="p-validation mobile_err"><?php echo form_error('mobile');?></div>
									</div>
								</div>
							</div>
							<div class="form-group">                
	<lable>DOB<span class="text-red">*</span></lable>
                  <div class="has-feedback">
                 <!--  <input  name="regdob" id="regdob" type="text" class="fstinput datepicker"  value="<?php if(isset($this->session->userdata('student_login_data')->dob)) {   echo $this->session->userdata('student_login_data')->dob; } else { echo "";}?>" placeholder="DOB*" maxlength="10" autocomplete='off' readonly="readonly"  <?php echo $disabled_sel;?>>  -->
<input type="text" data-inputmask="'alias': 'date'" class="fstinput dob_mask" name="regdob" id="regdob" value="<?php if(isset($this->session->userdata('student_login_data')->dob)) {   echo $this->session->userdata('student_login_data')->dob; } else { echo "";}?>" placeholder="dd/mm/yyyy"  autocomplete="off" onchange="validatedob(this.value,this.id)"  <?php echo $disabled_sel;?>>
                  <span class="fa fa-calendar form-group-icon"></span> </div>
                  <div class="p-validation regdob_err"><?php echo form_error('dob');?></div>
                </div>
									<div class="form-group">
										<lable>Email ID<span class="text-red">*</span></lable>
										<input type="text" class="fstinput checkvalidemail removeerrmessage" placeholder=""  id="email" name="email" value="<?php echo $this->input->post('email'); ?>"  maxlength="60" autocomplete="off"> 
										<div class="p-validation email_err" id="email_err"><?php echo form_error('email');?></div>
										</div>
									<div class="text-center mt-20">
									<div class="col-md-6 complaintBtnDiv_pro" style="display:none; float:left">
									<button type="button" class="btn btn-success complaintBtn_pro">Please wait..</button> <i class="fa fa-spinner fa-spin mr-10 text-while" style="color: #fff;"></i>
									</div>
										<button type="submit" class="btn btn-red btn-mdl"  onclick="return Send_registration();" id="reg_button">REGISTER</button>
									</div>
							</div>
							<!--End Login Popup-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="reg-otp" >
		<div class="modal fade" id="modal-reg-OTP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-body">
						<div class="reg-modal clearfix"> <span class="cross-btn pull-right text-white hide-btn" data-dismiss="modal"><i class="fa fa-close font-20"></i></span>
							<div class="reg-otp-info text-center text-white ">
								<h3>ENTER VERIFICATION CODE</h3>
								<p class="mb-10 font-12">Verification Code has been sent on your email.</p>
									<div class="form-group">
									
									<div class="subs-group" id="main_sec">
										<input type="text" class="form-control allow_numeric removeerrmessage" name="reg_otp" id="reg_otp" maxlength="4" placeholder="Please Enter 4-digit Verification Code" autocomplete="off">
										 <button class="btn btn-red btn-subs"  onclick="return Verify_Complaints(this.value);" id="verifyBtn" type="button">Verify</button>			
									</div>
									<div class="validation hide reg_otp_err" > Wrong Verification Code!</div>
									<div class="countdown" style="text-align: left;margin-top: 5px"></div>
									<a href="javascript:void(0);" class="" style="float: left;color: #fdfdfd;margin-top: 5px; display:none" onclick="resendStuOTP()" btn-border="" id="resend_btn">Resend OTP?</a>
									<div class="proBtn3 " style="display:none;    text-align: initial;">Please wait....</div>
									</div>
									<div class=" hide font-12 reg_otp_err" id="reg_opt_success" role="alert">
										<div><i class="fa fa-check-circle font-48"></i></div> Verification Code Message Successfully Verified! 
									</div>
										<div class="hide font-12 col-md-12 reg_otp_err " id="reg_opt_danger" role="alert">
									 OOps..Wrong Verification Code entered. Please try again with correct!
									</div>
									<div class="mt-30 hide">
										<button type="button" class="btn btn-yellow verifyBtn mt-20" onclick="return Verify_Complaints(this.value);" id="verifyBtn">Verify</button>  
									</div>
							</div>
							<!--End Login Popup-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo site_url('resources-f/'); ?>js/date-mask.js"></script>
<script id="rendered-js">
$(".dob_mask:input").inputmask();
</script> 
<script type="text/javascript">
$(".allow_numeric").on("input", function (evt) {
    var self = $(this);
    self.val(self.val().replace(/\D/g, ""));
    if ((evt.which < 48 || evt.which > 57)) {
        evt.preventDefault();
    }
});
function checkdob(data,id)
{
 var idd = '.' + id+'_err';
 var id_m = '#' + id;
 var dt= data.split("/");
 //if(dt[1])
  if(dt[1] == '02')
  {
    if(dt[0] >29)
    {
    	 // $('.dob_mask').focus();
    	 //$(id_m).focus();
        $(idd).text('Invalid date format');
    return false;
    }
  }
  var pattern =/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
    if(pattern.test(data) == false)
    {
   // $('.dob_mask').focus();
    $(idd).text('Invalid date format');
    return false;
    }
    else {
    $('.dob_qnform_err').text('');
    }
}
function Verify_Complaints()
{
  var reg_otp = $("#reg_otp").val();
  if(reg_otp!=''){
      $(".reg_otp_err").text('');
  }else{
     // $("#reg_otp").focus();
     $('#reg_opt_danger').removeClass('hide'); 
     $('#reg_opt_danger').html("<div class='alert alert-danger alert-dismissible'><strong>Please Enter Verification code</strong> <a href='#' class='alert-link'> </a> </div>"); 
      return false;
  }
  $.ajax({
        url: "<?php echo site_url('our_students/student_otp');?>",
        type: 'post',
        data: {otp: reg_otp},                              
        success: function(response)
        {  
			      if(response.status=='true')
			      {
								$('#main_sec').addClass('hide');
								$('#reg_opt_danger').addClass('hide');             
								$('#reg_opt_success').removeClass('hide'); 
								$('#reg_opt_success').html(response.msg); 
								setTimeout(function(){
								window.location.href = "<?php echo site_url('our_students/student_dashboard');?>";
								}, 2000);                  
	          }
					  else if(response.status==2)
					  {
								window.location.href = "<?php echo site_url('booking/checkout');?>"
					  }
					  else if(response.status==3)
					  {
								$.ajax({
								url: "<?php echo site_url('demo_counselling_session/post_book_session');?>",
								async : true,
								type: 'post',								
								success: function(data)
								{								
								  if(data.status==1)// for success popup
									{
								   	$('#modal-reg-OTP').modal('hide'); 								 	
										$('#checkout_popup_modal').modal('show'); 
										$('#checkout_success_msg').removeClass('hide');   
										$('#checkout_fail_msg').addClass('hide');
										$('#studentPostForm')[0].reset();
										$('select').prop('selectedIndex',0);
										setTimeout(function()
										{
										window.location.href = "<?php echo site_url('my_login/');?>";
										}, 2000);
								 } 
									else if(response.status==2) // for login popup
									{
										$('#onlinecoursemodel'+package_id).modal('hide');
										$('#modal-reg-OTP').modal('show');       
									}
									else
									{
										$('#checkout_popup_modal').modal('show');
										$('#checkout_success_msg').addClass('hide');
										$('#checkout_fail_msg').removeClass('hide');     
									} 
								},
								beforeSend: function()
								{
								},
								});
					  }
						else
						{
							$('#reg_otp').val(''); 
							$('#reg_opt_success').addClass('hide');   
							$('#reg_opt_danger').removeClass('hide'); 
							$('#reg_opt_danger').html(response.msg); 
							//$('.otpform').show(); 
						}                  
        }       
    });
}
function validate_complaint_email(email){
    var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
    if(email.match(mailformat)){
        $(".email_err_comp").text('');
        $('.complaintBtn').prop('disabled', false);  
        return true;
    }else{
        $(".email_err_comp").text("Please enter valid email");
       //$('#email').focus();
        $('.complaintBtn').prop('disabled', true);
        return false;
    }
}
function echeck(str) 
{
		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   $(".email_err").text('Please enter valid email');
		   return false
		}
		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		  $(".email_err").text('Please enter valid email');
		   return false
		}
		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    $(".email_err").text('Please enter valid email');
		    return false
		}
		 if (str.indexOf(at,(lat+1))!=-1){
		    $(".email_err").text('Please enter valid email');
		    return false
		 }
		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    $(".email_err").text('Please enter valid email');
		    return false
		 }
		 if (str.indexOf(dot,(lat+2))==-1){
		    $(".email_err").text('Please enter valid email');
		    return false
		 }
		 if (str.indexOf(" ")!=-1){
		    //alert("Invalid E-mail ID")
			$(".email_err").text('Please enter valid email');
		    return false
		 }
 		 return true					
	}
function Send_registration()
{
    var numberes = /^[0-9-+]+$/;
    var letters = /^[A-Za-z ]+$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
    var fname = $("#fname").val();
    var lname = $("#lname").val();
    var mobile = $("#mobile").val();
    var dob = $("#regdob").val();
    var email = $("#email").val();
    var country_code = $("#country_code").val();
  // alert(country_code)
    if(fname.match(letters)){
      $(".fname_err").text('');
    }else{
     // $("#fname").focus();
      $(".fname_err").text("Please enter first name");
      return false;
    }	
    if(mobile.match(numberes)){
      $(".mobile_err").text('');
    }else{
//$("#mobile").focus();
      $(".mobile_err").text("Please enter valid number");
      return false;
    }
    if(mobile.length ==0 || mobile =="" || mobile.length>10 || mobile.length<10){
      //$("#mobile").focus();
      $(".mobile_err").text('Please enter valid number');
      return false;
    }else{ 
     $(".mobile_err").text('');
    }
		if(dob == "" || dob == null)
		{
		//$("#regdob").focus();
		$(".regdob_err").text('Please select DOB');
		return false;
		}
 var dt= dob.split("/");
 //if(dt[1])
  if(dt[1] == '02')
  {
    if(dt[0] >29)
    {
    	 // $('.dob_mask').focus();
    	//$("#regdob").focus();
		$(".regdob_err").text('Invalid DOB');
    return false;
    }
    else{
    	$(".regdob_err").text('');
    }
  }
		 var patterndob =/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
    if(patterndob.test(dob) == false)
    {
   // $('.dob_mask').focus();
  // 	$("#regdob").focus();
		$(".regdob_err").text('Invalid DOB');
    return false;
    }
    else {
    $('.dob_qnform_err').text('');
    }
		if(email == "" || email == null)
		{
		//$("#email").focus();
		$(".email_err").text('Please enter valid email');
		return false;
		}
		if (echeck(email)==false){
		//$("#email").focus();
		$(".email_err").text('Please enter valid email');
		return false;
		}
		else {
			$(".email_err").text('');
		}

		
    $.ajax({
        url: "<?php echo site_url('our_students/registration');?>",
        type: 'post',
        data: {fname: fname, lname: lname, mobile: mobile, email:email,country_code:country_code,dob:dob},                
        success: function(response){		
          if(response.status==1)
		  {
			   $('#modal-register').modal('hide');
			   $('#modal-reg-OTP').modal('show');   		
          }
		  else
		  {
			$('.complaintBtnDiv_pro').hide(); 
          	$('#reg_button').prop('disabled', false);
            $('#regmain_msg_danger').removeClass('hide');
            $('#regmain_msg_danger').html(response.msg);
            //$('.regsub_button').hide(); 
          }                  
        },
        beforeSend: function(){
          $('.complaintBtnDiv_pro').show(); 
          $('#reg_button').prop('disabled', true);
        }
    });
  }
</script>