<section>
    <div class="container">
      <div class="registration-wrapper">
              <div class="info">
                <h2 class="mb-0">REGISTRATION</h2>
               <p class="font-12 text-white mb-10" style="text-align: center;">Get Register now and increase chances to get more...</p>
                <?php echo $this->session->flashdata('flsh_msg'); ?>
    <p></p>
    
                <div class="row">
              
                  <div class="form-group col-md-6">
                    <lable>First Name<span class="text-white">*</span></lable>
                    <input  id="regnewfname" name="fname" class="form-control" type="text" value="<?php echo $this->input->post('fname'); ?>" maxlength="30">
                    <div class="valid-validation regnewfname_err"> <?php echo form_error('fname');?></div>
                  </div>
                  <div class="form-group col-md-6">
                    <lable>Last Name<span class="text-white">*</span></lable>
                    <input id="regnewlname" name="lname" class="form-control" type="text" value="<?php echo $this->input->post('lname'); ?>" maxlength="30">
                    <div class="valid-validation regnewlname_err"> <?php echo form_error('fname');?></div>
                  </div>
                  <div class="form-group col-md-6">
                    <lable>Country Code<span class="text-white">*</span></lable>
                    <select id="regnewcountry_code" name="country_code" class="form-control selectpicker " data-show-subtext="true" data-live-search="true">
                      <option value="">Choose Country Code</option>
                         <?php 
                            foreach ($countryCode->error_message->data as $p)
                            {
                              $selected = ($p->country_code == "+91") ? ' selected="selected"' : "";
                              echo '<option value="'.$p->country_code.'" '.$selected.'>'.$p->country_code.'-'.$p->iso3.'</option>';
                            } 
                        ?>
                    </select>
                     <div class="valid-validation regnewcountry_code_err"><?php echo form_error('country_code');?></div>
                  </div>
                  <div class="form-group col-md-6">
                    <lable>Phone Number<span class="text-white">*</span></lable>
                    <input id="regnewmobile" name="mobile" class="form-control" type="text" value="<?php echo $this->input->post('mobile'); ?>" maxlength="10">
                  <div class="valid-validation regnewmobile_err"><?php echo form_error('mobile');?></div>
                  </div>
                  <div class="form-group col-md-12">
                    <lable>DOB<span class="text-white">*</span></lable>
                    <input id="regnewregdob" name="regnewdob" class="form-control datepicker" type="text" value="<?php echo $this->input->post('regdob'); ?>" placeholder="DOB*" maxlength="10" autocomplete='off' readonly="readonly" >
                    <span class="fa fa-calendar form-group-icon" style="    top: 24px;
    right: 13px;"></span>
                    <div class="valid-validation  small regnewdob_err"><?php echo form_error('regdob');?></div>
                  </div>
                  <div class="form-group col-md-12">
                    <lable>Email ID<span class="text-white">*</span></lable>
                    <input id="regnewemail" name="email" class="form-control" type="text" value="<?php echo $this->input->post('email'); ?>" maxlength="60">
                    <div class="valid-validation regnewemail_err"><?php echo form_error('email');?></div>
                  </div>
                    <div class="form-group col-md-12 text-right">
                    <button type="button" onclick="return Send_registration(this.value);" id="verifyBtn" class="btn btn-yellow btn-mdl" >REGISTER</button>
                  </div>
                  
                  </div>
                  
              </div>
    </div>
      
    </div>
  </section>
  <script type="text/javascript"> 

function Verify_Complaints(){

  var reg_otp = $("#reg_otp").val();
  if(reg_otp!=''){
      $(".reg_otp_err").text('');
  }else{
     //$("#reg_otp").focus();
     $('#reg_opt_danger').removeClass('hide'); 
     $('#reg_opt_danger').html("Please Enter Verification Code"); 
      return false;
  }

  $.ajax({
        url: "<?php echo site_url('our_students/student_otp');?>",
        type: 'post',
        data: {otp: reg_otp},                              
        success: function(response){        
    //   alert(JSON.stringify(response))
          if(response.status=='true'){
        //alert('jj')
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
          else{
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
        $(".email_err_comp").text("Please enter valid email Id!");
     //   $('#email').focus();
        $('.complaintBtn').prop('disabled', true);
        return false;
    }
}
function echeck(str) {

    var at="@"
    var dot="."
    var lat=str.indexOf(at)
    var lstr=str.length
    var ldot=str.indexOf(dot)
    if (str.indexOf(at)==-1){
       $(".mobile_err").text('Invalid E-mail ID');
       return false
    }

    if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
      $(".mobile_err").text('Invalid E-mail ID');
       return false
    }

    if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
        $(".mobile_err").text('Invalid E-mail ID');
        return false
    }

     if (str.indexOf(at,(lat+1))!=-1){
        $(".mobile_err").text('Invalid E-mail ID');
        return false
     }

     if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
        $(".mobile_err").text('Invalid E-mail ID');
        return false
     }

     if (str.indexOf(dot,(lat+2))==-1){
        $(".mobile_err").text('Invalid E-mail ID');
        return false
     }
    
     if (str.indexOf(" ")!=-1){
        //alert("Invalid E-mail ID")
      $(".mobile_err").text('Invalid E-mail ID');
        return false
     }

     return true          
  }
  
function Send_registration(){
 


    var numberes = /^[0-9-+]+$/;
    var letters = /^[A-Za-z ]+$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;

    var fname = $("#regnewfname").val();
    var lname = $("#regnewlname").val();
    var mobile = $("#regnewmobile").val();
    var dob = $("#regnewregdob").val();
    var email = $("#regnewemail").val();
    var country_code = $("#regnewcountry_code").val();

    if(fname.match(letters)){
      $(".regnewfname_err").text('');
    }else{
      //$("#regnewfname").focus();
      $(".regnewfname_err").text("Please enter valid Name. Numbers not allowed!");
      return false;
    } 

    if(mobile.match(numberes)){
      $(".regnewmobile_err").text('');
    }else{
     // $("#regnewmobile").focus();
      $(".regnewmobile_err").text("Please enter valid Number of 10 digit");
      return false;
    }

    if(mobile.length ==0 || mobile =="" || mobile.length>10 || mobile.length<10){
     // $("#regnewmobile").focus();
      $(".regnewmobile_err").text('Please enter valid Number of 10 digit');
      return false;
    }else{ 
     $(".regnewmobile_err").text('');
    }

    if(dob == "" || dob == null)
    {
   // $("#regnewregdob").focus();
    $(".regnewregdob_err").text('Please select DOB');
    return false;
    }
   
    if(email == "" || email == null)
    {
    //$("#regnewemail").focus();
    $(".regnewemail_err").text('Please enter valid Email Id');
    return false;
    }
    if (echeck(email)==false){

    //$("#regnewemail").focus();
    $(".regnewemail_err").text('Please enter valid Email Id');
    return false;
    }

   
    $.ajax({
        url: "<?php echo site_url('our_students/registration');?>",
        type: 'post',
        data: {fname: fname, lname: lname, mobile: mobile, email:email,country_code:country_code,dob:dob},                
        success: function(response){
    alert(response)
          if(response.status=='true')
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
