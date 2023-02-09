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
      Quick <span class="text-theme-color-2 font-weight-600">Enquiry</span>
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
        <input type="tel" data-inputmask="'alias': 'date'" class="fstinput form-control dob_mask" name="dob" id="dob_qnform" placeholder="dd/mm/yyyy" value="<?php if(isset($this->session->userdata('student_login_data')->dob)) {   echo $this->session->userdata('student_login_data')->dob; } else { echo "";}?>" autocomplete="off" onchange="validatedob(this.value,this.id)" <?php echo $readOnly;?>>
        <!-- <input class="fstinput datepicker" name="dob" placeholder="mm/dd/yyyy" id="dob_qnform" autocomplete='off'> <span class="fa fa-calendar form-group-icon"> -->
        </span>
      </div>
      <span class="valid-validation dob_qnform_err"></span>
    </div>
    <div class="form-group col-md-12">
      <label>Services<span class="text-red">*</span></label>
      <select class="form-control selectpicker" name="enquiry_purpose_id" id="enquiry_purpose_id">
        <option value="">Select Services</option>
        <?php foreach ($serviceDataAll->error_message->data  as $d) { ?>
          <option value="<?php echo $d->id; ?>"><?php echo $d->enquiry_purpose_name; ?></option>
        <?php } ?>
      </select>
      <span class="valid-validation purpose_err"></span>
    </div>
    <div class="form-group col-md-12">
      <label>Message<span class="text-red">*</span></label>
      <textarea name="message" id="message_qnform" placeholder="Enter Message* (Max. 150 words)" rows="2" class="t-area form-control" onblur="getWordCount(this.value);"></textarea>
      <span class="valid-validation message_qnform_err"></span>
    </div>
    <input type="hidden" name="enquiry_id" id="enquiry_id" class="form-control">
    <div class="col-sm-12 small otpMsg"></div>
    <div class="col-sm-12 otp_form" style="display: none;">
      <div class="form-group mb-10">
        <input name="otp" id="otp" class="fstinput form-control" type="text" placeholder="Enter Verification code" aria-required="true" maxlength="4">
        <span class="valid-validation small otp_err"></span>
      </div>
    </div>
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

<script src="<?php echo site_url('resources-f/'); ?>js/date-mask.js"></script>
<script id="rendered-js">
  $(".dob_mask:input").inputmask();
</script>
<script type="text/javascript">
  
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
        $('.proBtn2').hide();
        $('.otp_form').show();
        if (response.status == 1) {
          $('.finalMsg').html('<div class="alert alert-success alert-dismissible"><a href="<?php echo site_url(''); ?>" class="close" data-dismiss="alert" aria-label="close">&times;</a> Verification code verified & enquiry sent successfully. Please check your email for more details.<a href="#" class="alert-link"></a>.</div>');
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
          //window.location.href='<?php echo current_url(); ?>'
        } 
        else if(response.status == 2){
          $('.finalMsg').html('<div class="alert alert-danger alert-dismissible"><a href="<?php echo site_url(''); ?>" class="close" data-dismiss="alert" aria-label="close">&times;</a> OOps..error occur. Please try again!<a href="#" class="alert-link"></a>.</div>');
        }
        else {
          $('.finalMsg').html('<div class="alert alert-danger alert-dismissible"><a href="<?php echo site_url(''); ?>" class="close" data-dismiss="alert" aria-label="close">&times;</a> OOps..Wrong verification code entered. Please try again!<a href="#" class="alert-link"></a>.</div>');
        }
      },
      beforeSend: function() {
        $('.proBtn2').show();
        $('.otp_form').hide();
      }
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
        $('.proBtn').hide();
        $('.enqBtn').hide();
        if (response.status == 1) {
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
        } 
        else if(response.status == 2)
        {
          $('.enqForm').hide();
          $('.otp_form').show();
          $('.enqBtn').hide();
          $('#enquiry_id').val(response.enquiry_id);
          $('.otpMsg').html('<div style="margin-top:-5px" class="alert alert-info alert-dismissible">Verification code has been sent on your email.<a href="#" class="alert-link"></a>.</div>');
        }
        else {
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
       
        $('.proBtn3').hide();
        if (response.status == 1) {
          $('.otpMsg').show();
          $('.otpMsg').html('<div class="alert alert-info alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Verification code resent on your email. Please enter.<a href="#" class="alert-link"></a>.</div>');
        } else {
          $('.otpMsg').hide();
        }
      },
      beforeSend: function() {
        $('.proBtn3').show();
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
</script>
<script>
  $(document).ready(function() {
    $(".selectpicker").selectpicker();
  });
</script>