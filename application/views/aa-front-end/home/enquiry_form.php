<!-- Enquiry form start --> 

<?php 
echo $this->session->flashdata('flsh_msg'); 

  if(isset($this->session->userdata('student_login_data')->id)){
    $readOnly='readonly="readonly" ';
    $disabled_sel="disabled='disabled'";
  }else{
    $readOnly='" ';
    $disabled_sel="";
  }

?>
<div class="row" id="enq_form" name="enq_form">
<div class="text-center">
   <h3 class="mt-0 mb-10 text-uppercase">Quick <span class="text-theme-color-2 font-weight-500">Enquiry ff</span></h3>
   
   </div>  
        
 

                  <div class="col-sm-6">
                    <div class="form-group mb-10 enqForm">
                      <input name="fname" id="fname_eq" class="fstinput" type="text" placeholder="First Name*" aria-required="true" value="<?php if(isset($this->session->userdata('student_login_data')->fname)) {   echo $this->session->userdata('student_login_data')->fname; } else { echo "";}?>" maxlength="30" onblur="validate_fname(this.value);" <?php echo $readOnly;?>>
                      <div class="valid-validation fname_err"></div>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group mb-10 enqForm">
                      <input name="lname" id="lname_eq" class="fstinput" type="text" placeholder="Last Name" aria-required="true" value="<?php if(isset($this->session->userdata('student_login_data')->lname)) {   echo $this->session->userdata('student_login_data')->lname; } else { echo "";}?>" maxlength="30" <?php echo $readOnly;?>>
                      <div class="valid-validation lname_err"></div>
                    </div>
                  </div>                  

                    <div class="col-sm-6 enqForm">
                    <div class="form-group mb-20">
                      <div class="styled-select">
                        <select id="country_code_eq" name="country_code" class="selectpicker form-control"  data-live-search="true" aria-required="true" <?php echo $disabled_sel;?> <?php echo $readOnly;?>>
                          <option value="">*Phone Code</option>
                          <?php 
                            $c='+91';
                            foreach ($countryCode->error_message->data as $p)
                            {  
                              $selected = ($p->country_code == $c) ? ' selected="selected"' : "";
                              echo '<option value="'.$p->country_code.'" '.$selected.'>'.$p->country_code.'-'.$p->iso3.'</option>';
                            } 
                        ?>
                        </select>
                        <script type="text/javascript">

  //$('.selectpicker').selectpicker('refresh');

</script>
                        <div class="valid-validation country_code_err" ></div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6 enqForm">
                    <div class="form-group mb-10">
                      <input name="mobile" id="mobile_eq" class="fstinput" type="text" placeholder="Valid Phone*" aria-required="true" value="<?php if(isset($this->session->userdata('student_login_data')->mobile)) {   echo $this->session->userdata('student_login_data')->mobile; } else { echo "";}?>" <?php echo $readOnly;?> >
                      <div class="valid-validation mobile_err"></div>
                    </div>
                  </div>
                <div class="form-group col-md-6 enqForm">                
                  <div class="has-feedback">
                  <input  name="dob" id="dob" type="text" class="fstinput datepicker"  value="<?php if(isset($this->session->userdata('student_login_data')->dob)) {   echo $this->session->userdata('student_login_data')->dob; } else { echo "";}?>" placeholder="DOB*" maxlength="10" autocomplete='off' readonly="readonly"  <?php echo $disabled_sel;?>> 
                  <span class="fa fa-calendar form-group-icon"></span> </div>
                  <div class="validation dob_err"><?php echo form_error('dob');?></div>
                </div>
                  <div class="col-sm-6 enqForm">
                    <div class="form-group mb-10">
                      <input name="email" id="email_eq" class="fstinput" type="text" placeholder="Valid Email*" aria-required="true" value="<?php if(isset($this->session->userdata('student_login_data')->email)) {   echo $this->session->userdata('student_login_data')->email; } else { echo "";}?>" maxlength="60" onblur="validate_email(this.value);" <?php echo $readOnly;?>>
                      <div class="valid-validation email_err"></div>
                    </div>
                  </div>

                  <div class="col-sm-12 enqForm">
                    <div class="form-group mb-20">
                      <div class="styled-select">
                      <select id="enquiry_purpose_id_eq" name="enquiry_purpose_id" class="selectpicker form-control" aria-required="true" onchange="reflect_fields(this.value);" data-live-search="true">
                          <option value="">*Purpose</option> 
                          <?php 
                              foreach ($enquiry_purpose->error_message->data as $p)
                              {                                
                                echo '<option value="'.$p->id.'">'.$p->enquiry_purpose_name.'</option>';
                              } 
                          ?>
                        </select>
                        <div class="valid-validation purpose_err"></div>
                      </div>
                    </div>
                  </div>

                      
                   

                      <div class="col-sm-12 sub_events enqForm" style="display: none;">
                        <div class="form-group mb-20">
                          <div class="styled-select">
                            <select id="sub_events_eq" name="sub_events" class="selectpicker form-control" data-live-search="true" aria-required="true">
                              <option value="">*Sub Event</option> 
                              <option value="Reality Test- IELTS">Reality Test- IELTS</option>
                              <option value="Reality Test- CD-IELTS">Reality Test- CD-IELTS</option>
                              <option value="Reality Test- PTE">Reality Test- PTE</option>
                              <option value="Workshop">Workshop</option>
                                                 
                            </select>
                            <div class="valid-validation sub_events_err"></div>
                          </div>
                        </div>
                      </div>                
                 
                      <div class="col-sm-6 test enqForm" style="display: none;">
                        <div class="form-group mb-20">
                          <div class="styled-select">
                            <select id="test_module_id_eq" name="test_module_id" class="selectpicker form-control" data-live-search="true" aria-required="true">
                              <option value="">*Test</option> 
                              <?php 
                                  foreach ($allTest->error_message->data as $p)
                                  {                                    
                                    echo '<option value="'.$p->test_module_id.'">'.$p->test_module_name.'</option>';
                                  } 
                                ?>                    
                            </select>
                            <div class="valid-validation test_err"></div>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-6 pgm enqForm" style="display: none;">
                        <div class="form-group mb-20">
                          <div class="styled-select">
                            <select id="programe_id_eq" name="programe_id" class="selectpicker form-control" data-live-search="true" aria-required="true">
                              <option value="">*Programe</option>
                             <?php 
                                  foreach ($allPgm->error_message->data as $p)
                                  {                                   
                                    echo '<option value="'.$p->programe_id.'">'.$p->programe_name.'</option>';
                                  } 
                              ?>
                            </select>
                            <div class="valid-validation pgm_err"></div>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-6 demo enqForm" style="display: none;">
                          <div class="form-group mb-20">
                            <div class="styled-select">
                              <select id="free_demo_eq" name="free_demo" class="selectpicker form-control" data-live-search="true" aria-required="true">
                                <option value="">*Demo</option>
                                <option value="1">Yes </option>
                                <option value="0">No </option>
                              </select>
                              <div class="valid-validation demo_err"></div>
                            </div>
                          </div>
                      </div>

                      <div class="col-sm-12 br enqForm" style="display: none;">
                          <div class="form-group mb-20">
                            <div class="styled-select">
                              <select id="center_id_eq" name="center_id" class="selectpicker form-control" data-live-search="true" aria-required="true">
                                <option value="">*Branch</option>
                                <?php 
                                  foreach ($allEnqBranch->error_message->data as $p)
                                  {                                   
                                    echo '<option value="'.$p->center_id.'">'.$p->center_name.'</option>';
                                  } 
                                ?>
                              </select>
                              <div class="valid-validation br_err"></div>
                            </div>
                          </div>
                      </div>

                      <div class="col-sm-12 cnt enqForm" style="display: none;">
                          <div class="form-group mb-20">
                            <div class="styled-select">
                              <select id="country_id_eq" name="country_id" class="selectpicker form-control" data-live-search="true" aria-required="true">
                                <option value="">*Prefered Country</option>
                                <?php 
                                  foreach ($allDealCnt->error_message->data as $p)
                                  {                                    
                                    echo '<option value="'.$p->country_id.'">'.$p->name.'</option>';
                                  } 
                              ?>
                              </select>
                              <div class="valid-validation cnt_err"></div>
                            </div>
                          </div>
                      </div>

                      <div class="col-sm-12 enqForm">
                          <div class="form-group mb-10">
                            <textarea name="message" id="message_eq" class="form-control required" placeholder="Enter Message* (Max. 150 words)" rows="3" aria-required="true" onblur="getWordCount(this.value);"></textarea>
                            <div class="valid-validation message_err"></div>
                          </div>
                      </div>

                      <input type="hidden" name="enquiry_id" id="enquiry_id" class="form-control">                     

                      <div class="col-sm-12 small otpMsg"></div>                  

                      <div class="col-sm-12 otp_form" style="display: none;">
                        <div class="form-group mb-10">
                          <input name="otp" id="otp_eq" class="fstinput" type="text" placeholder="Enter OTP" aria-required="true" maxlength="4">
                          <span class="text-danger small otp_err"></span>
                        </div>
                      </div>
                      <div class="col-sm-12 small finalMsg"></div>

                    <div class="col-sm-12">
                      <div class="mb-0 text-right">
                      <button type="button" class="enqBtn btn btn-red" data-loading-text="Please wait..." onclick="return validate_enq();">Send</button>
                      <div class="proBtn" style="display: none;"><button type="button" class="enqBtn_processin btn btn-red" data-loading-text="Please wait..." >Sending..</button>
                      <i class="fa fa-spinner fa-spin mr-10"></i></div>

                      <a href="javascript:void(0);" class="otp_form" style="display: none;float: left;color: #d93025;" onclick="resendOTP()">Resend OTP?
                      </a>
                      <div class="proBtn3" style="display: none;">
                        <i class="fa fa-spinner fa-spin mr-10"></i></div>
                      </div>

                      <button type="button" class="otp_form btn btn-red" data-loading-text="Please wait..." onclick="return verifyNsubmit();" style="display: none;">Submit</button>
                    </div>
                    
                      <div class="proBtn2" style="display: none;"><button type="button" class="enqBtn_processin2 btn btn-red" data-loading-text="Please wait..." >Please wait..</button>
                      <i class="fa fa-spinner fa-spin mr-10"></i></div>
                    </div>

            


<script type="text/javascript"> 

function verifyNsubmit(){

  var otp  = $("#otp_eq").val();
  var enquiry_id = $("#enquiry_id").val();
  //otp
  if(otp==''){     
    //$("#otp").focus();
    $(".otp_err").text("Please enter correct OTP!");
    return false;
  }else{
     $(".otp_err").text('');
  }

  $.ajax({
        url: "<?php echo site_url('enquiry/verify_otp');?>",
        type: 'post',
        data: {otp: otp, enquiry_id: enquiry_id },                              
        success: function(response){ 

            $('.proBtn2').hide();
            $('.otp_form').show();                
            if(response.status=='true'){

              //add student
              $.ajax({
                url: "<?php echo site_url('student/add');?>",
                type: 'post',
                data: {otp: otp, enquiry_id: enquiry_id },                              
                success: function(response2){
                  alert(response2.status) 
                }
              });

               $('.finalMsg').html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> OTP Verified & enquiry sent successfully. Please check your Email for more details.<a href="#" class="alert-link"></a>.</div>');
               $('.otp_form').hide();
               $('.otpMsg').hide(); 
               $('#fname').val(''); 
               $('#lname').val(''); 
               $('#mobile').val('');                     
               $('#email').val(''); 
               $('#enquiry_purpose_id').val(''); 
               $('#country_code').val(''); 
               $('#test_module_id').val(''); 
               $('#programe_id').val(''); 
               $('#free_demo').val(''); 
               $('#sub_events').val(''); 
               $('#country_id').val(''); 
               $('#center_id').val('');
               $('#message').val(''); 
               window.location.href='<?php echo current_url(); ?>'

            }else{                 
                $('.finalMsg').html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> OOps..Wrong OTP entered. Please try again!<a href="#" class="alert-link"></a>.</div>');
            }                  
        },
        beforeSend: function(){
          $('.proBtn2').show();
          $('.otp_form').hide();      
        }
  });

}

function validate_enq(){

  //alert('ok')
  var letters = /^[A-Za-z ]+$/;
  var filter = /^[0-9-+]+$/;

  var fname  = $("#fname_eq").val();
  //alert(fname);
  var lname  = $("#lname_eq").val();
  var country_code  = $("#country_code_eq").val();
  var mobile = $("#mobile_eq").val();
  var email  = $("#email_eq").val();
  var enquiry_purpose_id = $("#enquiry_purpose_id_eq").val();
  var message = $("#message_eq").val();
   var dob = $("#dob").val();
  //fname
  if(fname==''){     
   // $("#fname_eq").focus();
    $(".fname_err").text("Please enter First Name!");
    //$('.enqBtn').prop('disabled', true);
    return false;
  }else if(!(fname.match(letters))){
  //  $("#fname_eq").focus();
    $(".fname_err").text("Please enter valid Name.Numbers not allowed!");
    //$('.enqBtn').prop('disabled', true);
    return false;
  }else{
     $(".fname_err").text('');
     //$('.enqBtn').prop('disabled', false);
     //return true;   
  } 

  //country code
  if(country_code==''){    
   // $("#country_code_eq").focus();
    $(".country_code_err").text("Please select country code!");
    return false;
  }else{
     $(".country_code_err").text('');
  }

  //mobile
  if (!filter.test(mobile)) {
   $('.mobile_err').text('Please enter valid Number!');
   //$('.enqBtn').prop('disabled', true);
   //$('#mobile_eq').focus();
   return false;
  }else if(mobile.length>10 || mobile.length<10){
    $(".mobile_err").text('Please enter valid Number of 10 digit');
    //$('.enqBtn').prop('disabled', true);
    return false;
  }else{
    $('.mobile_err').text('');
    //$('.enqBtn').prop('disabled', false);
  } 
  //dob
if(dob==''){    
    //$("#dob").focus();
    $(".dob_err").text("Please select country code!");
    return false;
  }else{
     $(".dob_err").text('');
  }
  //email
  var atposition=email.indexOf("@");  
  var dotposition=email.lastIndexOf("."); 
  if(email==''){     
   //$("#email_eq").focus();
    $(".email_err").text("Please enter email Id!");
    //$('.enqBtn').prop('disabled', true);
    return false;
  }else if(atposition<1 || dotposition<atposition+2 || dotposition+2>=email.length){  
   // $("#email_eq").focus();
    $(".email_err").text("Please enter valid email Id!");
    //$('.enqBtn').prop('disabled', true);
    return false; 
  }else{
     $(".email_err").text('');
     //$('.enqBtn').prop('disabled', false); 
  } 

  //purpose
  if(enquiry_purpose_id==''){
   // $("#enquiry_purpose_id_eq").focus();
    //$('.enqBtn').prop('disabled', true);
    $(".purpose_err").text("Please select purpose!");
    return false;
  }else{
     $(".purpose_err").text('');
     //$('.enqBtn').prop('disabled', false);
  }

  if(enquiry_purpose_id==1){  

    //test,pgm,demo
    var test_module_id  = $( "#test_module_id_eq" ).val();
    var programe_id  = $( "#programe_id_eq" ).val();
    var free_demo  = $( "#free_demo_eq" ).val();

      if(test_module_id==''){     
        //$("#test_module_id_eq").focus();
        $(".test_err").text("Please select test!");
        return false;
      }else if(programe_id==''){
      //  $("#programe_id_eq").focus();
        $(".pgm_err").text("Please select programe!");
        return false;
      }else if(free_demo==''){
        //$("#free_demo_eq").focus();
        $(".demo_err").text("Please select demo!");
        return false;
      }else{
        $(".test_err").text('');
        $(".pgm_err").text('');
        $(".demo_err").text('');
      }     

  }else if(enquiry_purpose_id==2){
    //test,pgm
    var test_module_id  = $( "#test_module_id_eq" ).val();
    var programe_id  = $( "#programe_id_eq" ).val();
    if(test_module_id==''){     
       // $("#test_module_id_eq").focus();
        $(".test_err").text("Please select test!");
        return false;
      }else if(programe_id==''){
        //$("#programe_id_eq").focus();
        $(".pgm_err").text("Please select programe!");
        return false;
      }else{
        $(".test_err").text('');
        $(".pgm_err").text('');
      }

  }else if(enquiry_purpose_id==3){
    //test,pgm,br
    var test_module_id  = $( "#test_module_id_eq" ).val();
    var programe_id  = $( "#programe_id_eq" ).val();
    var center_id  = $( "#center_id_eq" ).val();
      if(test_module_id==''){     
       // $("#test_module_id_eq").focus();
        $(".test_err").text("Please select test!");
        return false;
      }else if(programe_id==''){
       // $("#programe_id_eq").focus();
        $(".pgm_err").text("Please select programe!");
        return false;
      }else if(center_id==''){
       // $("#free_demo").focus();
        $(".br_err").text("Please select branch!");
        return false;
      }else{
        $(".test_err").text('');
        $(".pgm_err").text('');
        $(".br_err").text('');
      }
    
  }else if(enquiry_purpose_id==4){
    //cnt
    var country_id  = $( "#country_id_eq" ).val();
      if(country_id==''){     
        //$("#country_id_eq").focus();
        $(".cnt_err").text("Please select country!");
        return false;
      }else{
        $(".cnt_err").text('');
      }
    
  }else if(enquiry_purpose_id==5){

    var sub_events = $("#sub_events_eq").val();
    if(sub_events==''){     
        //$("#sub_events_eq").focus();
        $(".sub_events_err").text("Please select event!");
        return false;
      }else{
        $(".sub_events_err").text('');
      }
    
  }else{

  }

  if(message==''){     
    //$("#message_eq").focus();
    $(".message_err").text("Please enter your message!");
    //$('.enqBtn').prop('disabled', true);
    return false;
  }else{
     $(".message_err").text('');
     //$('.enqBtn').prop('disabled', false);   
  }

  $.ajax({
        url: "<?php echo site_url('enquiry/send_otp');?>",
        type: 'post',
        data: {fname: fname, lname: lname, country_code: country_code, mobile: mobile, email: email, enquiry_purpose_id: enquiry_purpose_id, message: message, sub_events: sub_events, country_id: country_id, center_id: center_id, test_module_id: test_module_id,  programe_id: programe_id,  free_demo: free_demo ,dob:dob },                              
        success: function(response){

            $('.proBtn').hide();
            $('.enqBtn').hide(); 
                              
            if(response.status=='true'){
               $('.enqForm').hide();
               $('.otp_form').show();
               $('.enqBtn').hide();
               $('#enquiry_id').val(response.enquiry_id);
               $('.otpMsg').html('<div class="alert alert-info alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> OTP sent on your email. Please enter.<a href="#" class="alert-link"></a>.</div>');
            }else{
                 
                $('.otpMsg').html('<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> OOps..Failed to send OTP. Please try again!<a href="#" class="alert-link"></a>.</div>');
                $('.otp_form').hide();
                $('.enqBtn').show();
                $('#enquiry_id').val('');
                $('.enqForm').show();
            }                  
        },
        beforeSend: function(){

          $('.proBtn').show();
          $('.enqBtn').hide();
      
        },
  });

}

function resendOTP(){

    var enquiry_id = $("#enquiry_id").val();
    var resend_for = 'students_enquiry';
    $.ajax({
        url: "<?php echo site_url('enquiry/resendOTP');?>",
        type: 'post',
        data: {enquiry_id: enquiry_id, resend_for: resend_for},                              
        success: function(response){ 
          $('.proBtn3').hide();
          if(response.status=='true'){
            $('.otpMsg').show();
            $('.otpMsg').html('<div class="alert alert-info alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> OTP Resent on your email no. Please enter.<a href="#" class="alert-link"></a>.</div>');              
          }else{                 
            $('.otpMsg').hide();
          }                  
        },
        beforeSend: function(){
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
  if(words>150){
    $(".message_err").text("Please enter max. 150 words only!");
    return false;
  }else{
    $(".message_err").text("");
  }
}

  

/*function validate_fname(myval){

  var letters = /^[A-Za-z ]+$/;
  if(myval.match(letters)){
      $(".fname_err").text('');
  }else{
    $("#fname").focus();
    $(".fname_err").text("Please enter valid Name. Numbers not allowed!");
    return false;
  }
}

function validate_phone(myval){

  var filter = /^[0-9-+]+$/;
  if (!filter.test(myval)) {
   $('.mobile_err').text('Please enter valid Number!');
   $('#mobile').focus();
   return false;
  }else{
    $('.mobile_err').text('');
    return true;
  }

  if(myval.length>10 || myval.length<10){
      $(".mobile_err").text('Please enter 10 digit no.');
      $('#mobile').focus();
      return false;
  }else{ 
     $(".mobile_err").text('');
     return true;
  }    

}

function validate_emailid(myval){

  var atposition=myval.indexOf("@");  
  var dotposition=myval.lastIndexOf("."); 
  if(myval==''){     
    $("#email").focus();
    $(".email_err").text("Please enter email Id!");
    return false;
  }else if(atposition<1 || dotposition<atposition+2 || dotposition+2>=myval.length){  
    $("#email").focus();
    $(".email_err").text("Please enter valid email Id!");
    return false; 
  }
  else{
     $(".email_err").text('');   
     return true;
  } 

}

function validate_message(myval){

  if(myval==''){     
    $("#message").focus();
    $(".message_err").text("Please enter Your message!");
    $('.enqBtn').prop('disabled', true);
    return false;
  }else{
     $(".message_err").text('');
      var fname  = $("#fname").val();
      var country_code  = $("#country_code").val();
      var mobile = $("#mobile").val();
      var email  = $("#email").val();
      var enquiry_purpose_id = $("#enquiry_purpose_id").val();
      if(fname!=='' && country_code!=='' && mobile!=='' && email!=='' && enquiry_purpose_id!==''){
         $('.enqBtn').prop('disabled', false);
      }else{
        $('.enqBtn').prop('disabled', true);
      }        
  }
 
}*/
      
function reflect_fields(purpose){

    if(purpose==1){

      $('.test').show();
      $('.pgm').show();
      $('.demo').show();
      $('.br').hide();
      $('.cnt').hide();
      $('.sub_events').hide();

    }else if(purpose==2){

      $('.test').show();
      $('.pgm').show();
      $('.demo').hide();
      $('.br').hide();
      $('.cnt').hide();
      $('.sub_events').hide();

    }else if(purpose==3){

      $('.test').show();
      $('.pgm').show();
      $('.demo').hide();
      $('.br').show();
      $('.cnt').hide();
      $('.sub_events').hide();
          
    }else if(purpose==4){

      $('.test').hide();
      $('.pgm').hide();
      $('.demo').hide();
      $('.br').hide();
      $('.cnt').show();
      $('.sub_events').hide();
          
    }else if(purpose==5){

      $('.test').hide();
      $('.pgm').hide();
      $('.demo').hide();
      $('.br').hide();
      $('.cnt').hide();
      $('.sub_events').show();
          
    }else{

      $('.test').hide();
      $('.pgm').hide();
      $('.demo').hide();
      $('.br').hide();
      $('.cnt').hide();
      $('.sub_events').hide();

    }
}
</script>