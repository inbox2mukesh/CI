<?php 
//print_r($this->session->userdata('student_login_data'));
if(isset($this->session->userdata('student_login_data')->id)){
    $readOnly='readonly="readonly" ';
    $disabled_sel="disabled='disabled'";
  }else{
    $readOnly='" ';
    $disabled_sel="";
  }
  ?>
 

  

  <div class="qury-form-row">
  <div class="font-20 text-center mt-0 text-uppercase">
      Quick <span class="text-theme-color-2 font-weight-600 text-red">Enquiry</span>
    </div>
   
    <div class="form-group col-md-6 col-sm-6">
      <label>First Name<span class="text-red">*</span></label>
      <input type="text" name="fname" id="fname_qnform" class="fstinput form-control allow_alphabets length_validate" placeholder="First Name" value="<?php if(isset($this->session->userdata('student_login_data')->fname)) {   echo $this->session->userdata('student_login_data')->fname; } else { echo "";}?>" autocomplete="off" <?php echo $readOnly;?> maxlength="30">
      <div class="valid-validation fname_qnform_err"></div>
    </div>
    <div class="form-group col-md-6 col-sm-6">
      <label>Last Name</label>
      <input type="text" name="lname" id="lname_qnform" class="fstinput form-control allow_alphabets" placeholder="Last Name" autocomplete="off" value="<?php if(isset($this->session->userdata('student_login_data')->lname)) {   echo $this->session->userdata('student_login_data')->lname; } else { echo "";}?>" maxlength="30" <?php echo $readOnly;?>
       class="valid-validation lname_qnform_err"></div>
 
    <div class="form-group col-md-6 col-sm-6">     
      <label>Country Code<span class="text-red">*</span></label> 
      <select class="form-control selectpicker" name="country_code" id="country_code_qnform" data-live-search="true"  <?php echo $disabled_sel;?>>
       
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
          $sel = "";  

          if (trim($p->iso3) == $c) {
            $sel = "selected";
          } 
          if($p->country_code == $this->session->userdata('student_login_data')->country_code and $p->iso3 == $this->session->userdata('student_login_data')->country_iso3_code)
          {
            $sel = "selected";
          }
          
          ?>
          <option value="<?php echo $p->country_code.'|'.$p->iso3; ?>" <?php echo $sel; ?> ><?php echo $p->country_code. '- ' . $p->iso3; ?></option>
          <?php
        }
        ?>
      </select>
      <span class="valid-validation country_code_qnform_err"></span>
    </div>

    <div class="form-group col-md-6 col-sm-6">
      <label>Phone No<span class="text-red">*</span></label>
      <input type="tel" name="mobile" id="mobile_qnform" class="fstinput form-control allow_numeric" placeholder="Valid Phone No." maxlength="10" value="<?php if(isset($this->session->userdata('student_login_data')->mobile)) {   echo $this->session->userdata('student_login_data')->mobile; } else { echo "";}?>" <?php echo $readOnly;?>  autocomplete="off">
      <span class="valid-validation mobile_qnform_err"></span>
    </div>
    <div class="form-group col-md-6 col-sm-6">
      <label>Email ID<span class="text-red">*</span></label>
      <input type="email" name="email" id="email_qnform" class="fstinput form-control" placeholder="Valid Email ID" value="<?php if(isset($this->session->userdata('student_login_data')->email)) {   echo $this->session->userdata('student_login_data')->email; } else { echo "";}?>" maxlength="60" autocomplete="off" <?php echo $readOnly;?>>
      <span class="valid-validation email_qnform_err"></span>
    </div>
    <div class="form-group col-md-6 col-sm-6">
      <label>DOB<span class="text-red">*</span></label>
      <div class="has-feedback">
        <input type="text" data-inputmask="'alias': 'date'" class="fstinput form-control dob_mask" name="dob" id="dob_qnform" placeholder="dd/mm/yyyy" value="<?php if(isset($this->session->userdata('student_login_data')->dob)) {   echo $this->session->userdata('student_login_data')->dob; } else { echo "";}?>" autocomplete="off" onchange="validatedob(this.value,this.id)" onkeyup="filldob(this.value);"?php echo $readOnly;?>
        <input class="fstinput datepicker" name="hidden_dob"  id="hidden_dob" value="" type="hidden">
      </div>
      <span class="valid-validation dob_qnform_err"></span>
    </div>
        <?php 
        $hide = '';
        if($this->router->fetch_class() != 'home')
        {
          $hide = 'style="display:none;"';
        }
         if(isset($service_id))
         {
        ?>
        <div class="form-group col-md-12" <?php echo $hide; ?>>
      <label>Services<span class="text-red">*</span></label>
      <input type="text" class="fstinput form-control" name="enquiry_purpose_id" id="enquiry_purpose_id"  value="<?php echo $enquiry_purpose_name;?>" autocomplete="off"  readonly>
    </div>
    
    <?php } else {?>
      <div class="form-group col-md-12" <?php echo $hide; ?>>
      <label>Services<span class="text-red">*</span></label>
      <select class="form-control selectpicker" name="enquiry_purpose_id" id="enquiry_purpose_id">
      <option value="">Select Services</option>
        <?php  if(!empty($serviceDataAll)){ foreach ($serviceDataAll->error_message->data  as $d) { ?>          
          <option value="<?php echo $d->id; ?>"><?php echo $d->enquiry_purpose_name; ?></option>
        <?php } }?>
      </select>
      <span class="valid-validation purpose_err"></span>
    </div>
      <?php }?>

    <div class="form-group col-md-12">
      <label>Message<span class="text-red">*</span></label>
      <textarea name="message" id="message_qnform" placeholder="Enter Message* (Max. 150 words)" rows="2" class="t-area form-control" onblur="getWordCount(this.value);"></textarea>
      <span class="valid-validation message_qnform_err"></span>
    </div>
    <input type="hidden" name="enquiry_id" id="enquiry_id" class="form-control">
    <div class="col-sm-12 small otpMsg"></div>
   <!--  <div class="col-sm-12 otp_form" style="display: none;">
      <div class="form-group mb-10">
        <input name="otp" id="otp" class="fstinput form-control" type="text" placeholder="Enter Verification code" aria-required="true" maxlength="4">
        <span class="valid-validation small otp_err"></span>
      </div>
    </div> -->
    <div class="text-right col-md-12">
      <button class="enqBtn btn btn-red" onclick="return validate_enq();">SEND</button>
      <div class="proBtn" style="display: none;">
        <button type="button" class="enqBtn_processin btn btn-red" data-loading-text="Please wait...">Sending..</button>
        <i class="fa fa-spinner fa-spin mr-10"></i>
      </div>
      <a href="javascript:void(0);" class="otp_form" style="display: none;float: left;color: #d93025; font-size:13px; font-weight:500" onclick="resendOTP()">Resend Verification code?
      </a>

      <span class="proBtn3" style="display: none;">
        <i class="fa fa-spinner fa-spin mr-10"></i>
        </span>

      <button type="button" class="otp_form btn btn-red" data-loading-text="Please wait..." onclick="return verifyNsubmit();" style="display: none;">Verify & Submit</button>
      <div class="proBtn2" style="display: none;">
        <button type="button" class="enqBtn_processin2 btn btn-red" data-loading-text="Please wait...">Please wait..</button>
        <i class="fa fa-spinner fa-spin mr-10"></i>
      </div>
      <div class="small finalMsg"></div>
    </div>
  </div>
    </div>
  </div>
   </div>

   <div class="reg-otp" >
		<div class="modal fade" id="enqmodal-OTP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-body">
						<div class="reg-modal clearfix"> <span class="cross-btn pull-right text-white hide-btn" data-dismiss="modal"><i class="fa fa-close font-20"></i></span>
							<div class="reg-otp-info text-center text-white ">
								<h3>ENTER VERIFICATION CODE</h3>
								<p class="mb-10 font-12">Verification Code has been sent on your <?php if (DEFAULT_COUNTRY == 101){ echo "mobile";} else { echo "email";} ?>.</p>
									<div class="form-group" id="formsection">
									
									<div class="subs-group" id="main_sec">
										<input type="text" class="form-control allow_numeric removeerrmessage" name="otp" id="otp" maxlength="4" placeholder="Please Enter 4-digit Verification Code" autocomplete="off">
										 <button class="btn btn-red btn-subs"  onclick="return verifyNsubmit(this.value);" id="verifyBtn" type="button">Verify</button>			
									</div>
									<div class="validation hide otp_err" > Wrong Verification Code!</div>
									<div class="countdown" style="text-align: left;margin-top: 5px"></div>
									<a href="javascript:void(0);" class="hide" style="float: left;color: #fdfdfd;margin-top: 5px;" onclick="resendOTP()" btn-border="" id="enq_resend_btn">Resend OTP?</a>
									<div class="proBtnresend hide" style="text-align: initial;">Please wait....</div>
									</div>
									<div class="hide font-12 col-md-12 reg_otp_err alert alert-success alert-dismissible" id="enq_reg_opt_success" role="alert"><strong>SUCCESS:</strong>	
                  <span id="enq_reg_opt_success_message"> </span>
									</div>
										<div class="hide font-12 col-md-12 alert alert-danger alert-dismissible reg_otp_err " id="enq_reg_opt_danger" role="alert">
									<strong>WRONG: </strong>Ohh..Wrong Verification Code entered!. <br>Please try again!
									</div>
									
							</div>
							<!--End Login Popup-->
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

$(".hide-btn").click(function()
{
  location.reload();
});
  function optcountdown() {
    var timer2 = "0:30";
    var interval = setInterval(function() {
      var timer = timer2.split(':');
      //by parsing integer, I avoid all extra string processing
      var minutes = parseInt(timer[0], 10);
      var seconds = parseInt(timer[1], 10);
      --seconds;
      minutes = (seconds < 0) ? --minutes : minutes;
      if (seconds <= 0) {
        clearInterval(interval);
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        $('.countdown').html("");
        $('#enq_resend_btn').removeClass('hide');     
       
        $('#reg_opt_success').addClass('hide');
        $('.reg_otp_err').addClass('hide');
        $('#reg_opt_success').html('');
      } else {
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        $('.proBtnresend').addClass("hide");
        minutes = (minutes = 0) ? '0' + minutes : minutes;
        $('.countdown').html('<i class="fa fa-clock-o" aria-hidden="true"></i> 00:' + seconds);
        timer2 = minutes + ':' + seconds;
      }
    }, 1000);
  }

  function verifyNsubmit() {
    var otp = $("#otp").val();
    var enquiry_id = $("#enquiry_id").val();
    //otp   
    if (otp == '') {
      //$("#otp").focus();
      $(".otp_err").text("Please enter correct verification code!");
      return false;
    } else {
      $(".otp_err").text('');
    }

    $.ajax({
      url: "<?php echo site_url('enquiry/verify_otp'); ?>",
      type: 'post',
      data: {
        otp: otp,
        enquiry_id: enquiry_id
      },
      success: function(response) {              
        if (response.status == 1) 
        {          
          $('#formsection').addClass('hide');
          $('#enq_reg_opt_success').removeClass('hide');
          $('#enq_reg_opt_success_message').text('Hi! your enquiry sent successfully at our Enquiry team. We will get back to soon.');
          $('#enq_reg_opt_danger').addClass('hide');
          $('.enqBtn').prop('disabled', true);
          <?php if(DEFAULT_COUNTRY==101){ ?>        
            gtag('event', 'conversion', {'send_to': 'AW-11071945767/rYbECPGWmp8YEKf4wZ8p'});
          <?php } ?>
         <?php
         if(empty($this->session->userdata('student_login_data')))
         { ?>
          $('#fname_qnform').val('');
          $('#lname_qnform').val('');
          $('#mobile_qnform').val('');
          $('#email_qnform').val('');
          $("#dob_qnform").val('');
         <?php } ?>
          $('#enquiry_purpose_id').val('');
          $('#country_code_qnform').val('');
          $('#message_qnform').val('');
          setTimeout(function() {
           location.reload();
            }, 10000);
          //window.location.href='<?php echo current_url(); ?>'
        } 
        else if(response.status == 2){
          $('#otp').val('');
          $('#enq_reg_opt_success').addClass('hide');
          $('#enq_reg_opt_danger').removeClass('hide');         
        }
        else {
          $('#otp').val('');
           $('#enq_reg_opt_success').addClass('hide');
          $('#enq_reg_opt_danger').removeClass('hide');         
        }
      },
      beforeSend: function() { }
    });
  }
  
   function validate_enq() {  
      
    var flag = 1;
    var letters = /^[A-Za-z ]+$/;
    var filter = /^[0-9-+]+$/;
    var fname = $("#fname_qnform").val();
    var lname = $("#lname_qnform").val();
    var country_code = $("#country_code_qnform").val();
    var mobile = $("#mobile_qnform").val();
    var email = $("#email_qnform").val();
    var dob = $("#dob_qnform").val();
    var enquiry_purpose_id = $("#enquiry_purpose_id").val();
    var message = $("#message_qnform").val();
    if (fname == '') {
     // $("#fname_qnform").focus();
      $(".fname_qnform_err").text("Please enter first name");     
      flag = 0;
    } else if (!(fname.match(letters))) {
     // $("#fname_qnform").focus();
      $(".fname_qnform_err").text("Please enter valid Name. Numbers not allowed");     
      flag = 0;
    } else {
      $(".fname_qnform_err").text('');      
    }
    if (country_code == '') {
      //$("#country_code_qnform").focus();
      $(".country_code__qnform_err").text("Please select country code");
      flag = 0;
    } else {
      $(".country_code__qnform_err").text('');
    }
    if (!filter.test(mobile)) {
      $('.mobile_qnform_err').text('Please enter valid number');
      //$('#mobile_qnform').focus();
      flag = 0;
    } else if (mobile.length > 13) {
      $(".mobile_qnform_err").text('Please enter valid number of 13 digit');      
      flag = 0;
    } else {
      $('.mobile_qnform_err').text('');
    }    
    var atposition = email.indexOf("@");
    var dotposition = email.lastIndexOf(".");
    if (email == '') {
     // $("#email_qnform").focus();
      $(".email_qnform_err").text("Please enter email");     
      flag = 0;
    } else if (atposition < 1 || dotposition < atposition + 2 || dotposition + 2 >= email.length) {
      //$("#email_qnform").focus();
      $(".email_qnform_err").text("Please enter valid email");
      flag = 0;
    } else {
      $(".email_qnform_err").text('');      
    }    
    if (dob == '') {
     // $("#dob_qnform").focus();
      $(".dob_qnform_err").text("Please enter valid date of birth");
      flag = 0;
    } else {
      validatedob('','dob_qnform');
      $(".dob_qnform_err").text('');
    }
    var patterndob = /^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
    if (patterndob.test(dob) == false) {
      //$('.dob_mask').focus();
      $('.dob_qnform_err').text('Invalid date format');
      flag = 0;
    } else {
      $('.dob_qnform_err').text('');
    }
    var dt = dob.split("/");   
    if (dt[1] == '02') {
      if (dt[0] > 29) {
      //  $('.dob_mask').focus();
        $('.dob_qnform_err').text('Invalid date format');
        flag = 0;
      } else {
        $('.dob_qnform_err').text('');
      }
    }  
    if (enquiry_purpose_id == '') {
     // $("#enquiry_purpose_id").focus();
      $(".purpose_err").text("Please select services!");
      flag = 0;
    } else {
      $(".purpose_err").text('');      
    }  
    if (message == '') {
      //$("#message_qnform").focus();
      $(".message_qnform_err").text("Please enter message!");
      flag = 0;
    } else {
      $(".message_qnform_err").text('');      
    }  

    if (flag == 0) {
      return false;
    }
    else {    
      $('.enqBtn').prop('disabled', true);
      $('.enqBtn').text('Please wait...'); 
    $.ajax({
      url: "<?php echo site_url('enquiry/enquiry_submit'); ?>",
      type: 'post',
      data: {
        fname: fname,
        lname: lname,
        country_code: country_code,
        mobile: mobile,
        email: email,
        dob: dob,
        enquiry_purpose_id: enquiry_purpose_id,
        message: message
      },
      success: function(response) { 
        
        if (response.status == 1) {
          $('.enqBtn').prop('disabled', false);
          $('.enqBtn').text('Send'); 
          $('.finalMsg').html('<div class="alert alert-success alert-dismissible">Enquiry sent successfully. Please check your Email for more details.<a href="#" class="alert-link"></a>.</div>');
          $('.otp_form').hide();
          $('.otpMsg').hide();
          <?php
         if(empty($this->session->userdata('student_login_data')))
         { ?>
          $('#fname_qnform').val('');
          $('#lname_qnform').val('');
          $('#mobile_qnform').val('');
          $('#email_qnform').val('');
          $("#dob_qnform").val('');
         <?php } ?>
          $('#enquiry_purpose_id').val('');
          $('#country_code_qnform').val('');
          $('#message_qnform').val('');
          //$('.enqBtn').show();
          //window.location.href='<?php echo current_url(); ?>'
          setTimeout(() => {
            window.location.reload();
          }, 1500);
          
        } 
        else if(response.status == 2)
        {
          $('.enqBtn').prop('disabled', true);
          $('.enqBtn').text('Please wait...'); 
          optcountdown();
          $('#enquiry_id').val(response.enquiry_id);
          $('#enqmodal-OTP').modal('show');
          
         /*  $('.enqForm').hide();
          $('.otp_form').show();
          $('.enqBtn').hide();
          $('#enquiry_id').val(response.enquiry_id);
          $('.otpMsg').html('<div style="margin-top:-5px" class="alert alert-info alert-dismissible">Verification code has been sent on your email.<a href="#" class="alert-link"></a>.</div>'); */
        }
        else {
          $('.enqBtn').prop('disabled', false);
          $('.enqBtn').text('Send'); 
          $('.finalMsg').html('<div class="alert alert-danger alert-dismissible">OOps..Failed to send verification code. Please try again!<a href="#" class="alert-link"></a>.</div>');
        }

      },
      beforeSend: function() {
        //$('.proBtn').show();
        //$('.enqBtn').hide();
      },
    });
  }
  }
  function resendOTP() {
    $('#enq_resend_btn').addClass("hide");
    $('.proBtnresend').removeClass("hide");    
    var enquiry_id = $("#enquiry_id").val();
    var resend_for = 'students_enquiry';
    $.ajax({
      url: "<?php echo site_url('enquiry/resendOTP'); ?>",
      type: 'post',
      data: {
        enquiry_id: enquiry_id,
        resend_for: resend_for
      },
      success: function(response) {
       
       // $('.proBtn3').hide();
        if (response.status == 1) {
          optcountdown();
          $('#reg_opt_success').removeClass('hide');
          $('#reg_opt_danger').addClass('hide');
          $('#enq_reg_opt_success').removeClass('hide');
          $('#enq_reg_opt_success_message').text('Verification Code Resent on your email. Please Enter Verification Code');
          $('#enq_reg_opt_danger').addClass('hide');
          
        } else {
          $('#enq_reg_opt_success').addClass('hide');
          $('#enq_reg_opt_danger').addClass('hide');
        }
      },
      beforeSend: function() {
      //  $('.proBtn3').show();
      }
    });
  }
  function getWordCount(wordString) {
    var words = wordString.split(" ");
    words = words.filter(function(words) {
      return words.length > 0
    }).length;
    //alert(words)
    if (words > 150) {
      $(".message_qnform_err_err").text("Please enter max. 150 words only!");
      return false;
    } else {
      $(".message_qnform_err_err").text("");
    }
  }
  function filldob(txt)
  {
      $('#hidden_dob').val(txt);
  }
</script>
<script>
  $(document).ready(function() {
    $(".selectpicker").selectpicker();
  });
</script>