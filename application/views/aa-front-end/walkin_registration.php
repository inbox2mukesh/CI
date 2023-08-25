<?php
  if($this->session->userdata('student_login_data')->id){
    $readOnly='readonly="readonly" ';
    $readOnly_dis='disabled="disabled" ';
  }else{
    $readOnly='" ';
    $readOnly_dis='" ';
    
  }
?>
 
<section class="lt-bg-lighter">
    <div class="container">
      <div class="section-title">
        <div class="row">
          <div class="text-center">
            <h2 class="mb-20 text-uppercase font-weight-300 font-28 mt-0"><?php echo $title;?></h2> </div>
        </div>
      </div>
      <div class="content-wrapper">
      
        <!-- Start Content Part -->
        <div class="dash-main-box1">
         
        
          <div class="lt-clr-box"  id="wkn_load">
           
              <?php echo $this->session->flashdata('flsh_msg'); ?>
              <?php echo form_open('walkin/walkin_registration/'.$center_name, array('name'=>'walkin-form','id'=>'walkin-form', 'class'=>'clearfix')); ?>
              <div class="form-row clearfix">
                <div class="form-group col-md-3">
                  <label>Branch</label>
                  <select class="selectpicker form-control" id="center_id_x" name="center_id_x" aria-required="true" disabled="disabled">
                    <option selected>Branch</option>
                   <?php 
                foreach ($allEnqBranch->error_message->data as $p){
                  $selected = ($p->center_id === $center_id_enc) ? ' selected="selected"' : "";
                  echo '<option value="'.$p->center_id.'" '.$selected.'>'.$p->center_name.'</option>';
                } 
                ?>
                  </select>
                
                </div>
                
                <div class="form-group col-md-3">
                  <label>Country Code<span class="red-text">*</span></label>
                  <select class="selectpicker form-control" id="country_code" name="country_code" data-show-subtext="true" data-live-search="true" >
                   
              <?php 
                            $c='+91';
                            foreach ($countryCode->error_message->data as $p)
                            {  
                              $selected = ($p->country_code == $c) ? ' selected="selected"' : "";
                              echo '<option value="'.$p->country_code.'" '.$selected.'>'.$p->country_code.'-'.$p->iso3.'</option>';
                            } 
                        ?>
                  </select>
                  <div class="validation country_code_err"><?php echo form_error('country_code');?></div>
                </div>

<?php if($this->session->userdata('student_login_data')->mobile){ ?>
            <div class="form-group col-md-3">
              <label for="wkn_mobile"><span class="text-danger">*</span> Mobile No.</label>
              <input id="wkn_mobile" name="wkn_mobile" class="fstinput" type="text" value="<?php echo ($this->input->post('mobile') ? $this->input->post('mobile') : $this->session->userdata('student_login_data')->mobile); ?>" maxlength="10"  <?php echo $readOnly;?> >
            <div class="validation mobile_err"><?php echo form_error('mobile');?></div>

            </div> 
            <?php }else{ ?>
            <div class="form-group col-md-3">
              <label for="wkn_mobile"><span class="text-danger">*</span> Mobile No.</label>
              <input id="wkn_mobile" name="wkn_mobile" class="fstinput" type="text" value="<?php echo ($this->input->post('mobile') ? $this->input->post('mobile') : get_cookie('mobile')); ?>" maxlength="10">
             <div class="validation mobile_err"><?php echo form_error('mobile');?></div>
            </div> 
            <?php } ?>



               <?php if($this->session->userdata('student_login_data')->email){ ?>
              <div class="form-group col-md-3">
              <label for="wkn_email"> Email Id</label>
              <input id="wkn_email" name="wkn_email" class="fstinput" type="text" value="<?php echo ($this->input->post('email') ? $this->input->post('email') : $this->session->userdata('student_login_data')->email); ?>" maxlength="60" <?php echo $readOnly;?> onblur="validate_walkin_email(this.value);">
             
              <div class="validation email_err"><?php echo form_error('email');?></div>
            </div> 
            <?php }else{ ?>            
            <div class="form-group col-md-3">
              <label for="wkn_email"> Email Id</label>
              <input id="wkn_email" name="wkn_email" class="fstinput" type="text" value="<?php echo ($this->input->post('email') ? $this->input->post('email') : get_cookie('email')); ?>" maxlength="60" onblur="validate_walkin_email(this.value);" >
                <div class="validation email_err"><?php echo form_error('email');?></div>
            </div> 
            <?php } ?> 
                              
            
                
                  <div class="form-group col-md-12">
                  <label>Purpose<span class="red-text">*</span></label>
                    <select id="wkn_enquiry_purpose_id" name="wkn_enquiry_purpose_id"  class="selectpicker form-control selector" data-live-search="true"  onchange="reflect_fields(this.value);">
                          <option value="">Select Purpose</option>
                          <?php 
                              foreach ($enquiry_purpose->error_message->data as $p){
                                echo '<option value="'.$p->id.'">'.$p->enquiry_purpose_name.'</option>';
                              } 
                          ?>
                        </select>
                        <div class="validation wkn_purpose_err"><?php echo form_error('enquiry_purpose_id');?></div>
                </div>
                
                
                <div id="v1" class="form-group col-md-12 sub_events enqForm" style="display: none;" >                                 
                      <select  id="wkn_sub_events" name="wkn_sub_events"  class="selectpicker form-control">
                        <option value="">Select Sub Events</option>
                       <option value="Reality Test- IELTS">Reality Test- IELTS</option>
                              <option value="Reality Test- CD-IELTS">Reality Test- CD-IELTS</option>
                              <option value="Reality Test- PTE">Reality Test- PTE</option>
                              <option value="Workshop">Workshop</option>
                      </select>
                     <div class="validation wkn_sub_events_err"></div>     
                  
                </div>
                <div id="v2" class=" col-md-12  test enqForm" style="display: none;">
                  <div class="walkin-form-row">
                    <div class="col-md-4 form-group">
                      <select class="selectpicker form-control" id="wkn_test_module_id" name="wkn_test_module_id">
                        <option value="">Test</option>
                        <?php 
                                  foreach ($allTest->error_message->data as $p){                                    
                                    echo '<option value="'.$p->test_module_id.'">'.$p->test_module_name.'</option>';
                                  } 
                                ?> 
                      </select>
                       <div class="validation wkn_test_err"></div>
                    </div>
                    <div class="col-md-4 form-group pgm enqForm"  style="display: none;" >
                      <select id="wkn_programe_id" name="wkn_programe_id" class="selectpicker form-control">
                        <option value="">Programe</option>
                       <?php 
                                  foreach ($allPgm->error_message->data as $p){                                   
                                    echo '<option value="'.$p->programe_id.'">'.$p->programe_name.'</option>';
                                  }
                              ?>
                      </select>
                      <div class="validation wkn_pgm_err"></div>
                    </div>
                    <div class="col-md-4 form-group hide">
                      <select class="selectpicker form-control" data-live-search="true">
                        <option value="">Branch</option>
                        <?php 
                foreach ($allEnqBranch->error_message->data as $p){
                  $selected = ($p->center_id === $center_id_enc) ? ' selected="selected"' : "";
                  echo '<option value="'.$p->center_id.'" '.$selected.'>'.$p->center_name.'</option>';
                } 
                ?>
                      </select>
                    </div>
                    <div class="col-md-4 form-group demo enqForm"  style="display: none;">
                      <select id="wkn_free_demo" name="wkn_free_demo" class="selectpicker form-control">
                        <option value="">Demo</option>
                         <option value="1">Yes </option>
                                <option value="0">No </option>
                      </select>
                       <div class="validation wkn_demo_err"></div>
                    </div>
                  </div>
                </div>
                
                
                <div id="v5" class="col-md-12 cnt enqForm" style="display: none;">
                  <div class="walkin-form-row">
                    <div class="col-md-12 form-group">
                      <select id="country_id2" name="country_id2" class="selectpicker form-control" data-live-search="true">
                         <option value="">*Prefered Country</option>
                                <?php 
                                  foreach ($allCnt->error_message->data as $p)
                                  {                                    
                                    echo '<option value="'.$p->country_id.'">'.$p->name.'</option>';
                                  } 
                              ?>
                      </select>
                      <div class="validation cnt_err"></div>
                    </div>
                  </div>
                </div>              
                
                
                
                <?php if($this->session->userdata('student_login_data')->fname){ ?>
            <div class="form-group col-md-3">
            <label for="wkn_fname"><span class="text-danger">*</span> First Name</label>
              <input id="wkn_fname" name="wkn_fname" class="fstinput" type="text" value="<?php echo ($this->input->post('fname') ? $this->input->post('fname') : $this->session->userdata('student_login_data')->fname); ?>" maxlength="30" onblur="validate_fname(this.value)" <?php echo $readOnly;?> >
              <div class="validation fname_err"><?php echo form_error('fname');?></div>
          </div>
          <?php }else{ ?>
          
          <div class="form-group col-md-3">
            <label for="wkn_fname"><span class="text-danger">*</span> First Name</label>
              <input id="wkn_fname" name="wkn_fname" class="fstinput" type="text" value="<?php echo ($this->input->post('fname') ? $this->input->post('fname') : $this->session->userdata('student_login_data')->fname); ?>" maxlength="30" onblur="validate_fname(this.value)">
              <div class="validation fname_err"><?php echo form_error('fname');?></div>
          </div>
          <?php } ?>
                
           <?php if($this->session->userdata('student_login_data')->lname){ ?>
            <div class="form-group col-md-3">
            <label for="lname">Last Name</label>
            <input id="lname" name="lname" class="fstinput" type="text" value="<?php echo ($this->input->post('lname') ? $this->input->post('lname') : $this->session->userdata('student_login_data')->lname); ?>" maxlength="30" <?php echo $readOnly;?> >
            <div class="validation lname_err"></div>
          </div>
          <?php }else{ ?>
          
          <div class="form-group col-md-3">
            <label for="lname">Last Name</label>
            <input id="lname" name="lname" class="fstinput" type="text" value="<?php echo ($this->input->post('lname') ? $this->input->post('lname') : get_cookie('lname')); ?>" maxlength="30">
           <div class="validation lname_err"></div>
          </div>
          <?php } ?>

           <?php 
         if($this->session->userdata('student_login_data')->gender){ ?>
           

  <div class="form-group col-md-3">
                  <label for="wkn_gender_name">Gender<span class="red-text">*</span></label>
                  <select id="wkn_gender_name" name="wkn_gender_name" class="selectpicker form-control" <?php echo $readOnly;?>>
                      <option value="">Select Gender</option>
                  <?php 
                  foreach ($allGnd->error_message->data as $p){
                    $selected = ($p->id == $this->session->userdata('student_login_data')->gender) ? ' selected="selected"' : "";
                      echo '<option value="'.$p->id.'" '.$selected.'>'.$p->gender_name.'</option>';                           
                  } 
                ?> 
                  </select>
                  <div class="validation wkn_gender_name_err"><?php echo form_error('gender_name');?></div> 
                </div>


          <?php }else{ ?>
          
            <div class="form-group col-md-3">
                  <label for="wkn_gender_name">Gender<span class="red-text">*</span></label>
                  <select id="wkn_gender_name" name="wkn_gender_name" class="selectpicker form-control">
                      <option value="">Select Gender</option>
                  <?php 
                  foreach ($allGnd->error_message->data as $p){
                    $selected = ($p->id == $this->input->post('gender_name') or $p->id == get_cookie('gender_name') ) ? ' selected="selected"' : "";
                      echo '<option value="'.$p->id.'" '.$selected.'>'.$p->gender_name.'</option>';                           
                  } 
                ?> 
                  </select>
                  <div class="validation wkn_gender_name_err"><?php echo form_error('gender_name');?></div> 
                </div>
          <?php } ?>



                
              
                
                 <?php 
                 if($this->session->userdata('student_login_data')->dob){ ?>
                
                <div class="form-group col-md-3">
                  <label>Date of Birth<span class="red-text">*</span></label>
                  <div class="has-feedback">
                    <input id="dob" name="wkn_dob" class="fstinput datepicker" maxlength="10" autocomplete='off' data-date-format="dd-mm-yyyy" value="<?php echo ($this->input->post('dob') ? $this->input->post('dob') : $this->session->userdata('student_login_data')->dob); ?>" <?php echo $readOnly;?>> <span class="fa fa-calendar form-group-icon"></span>


                     </div>
                     <div class=" validation dob_err"><?php echo form_error('dob');?></div>
                </div>
<?php } else {?>
 <div class="form-group col-md-3">
                  <label>Date of Birth<span class="red-text">*</span></label>
                  <div class="has-feedback">
                    <input id="dob" name="wkn_dob" class="fstinput datepicker" maxlength="10" autocomplete='off' data-date-format="dd-mm-yyyy" value="<?php echo ($this->input->post('dob') ? $this->input->post('dob') : get_cookie('dob')); ?>"> <span class="fa fa-calendar form-group-icon"></span>


                     </div>
                     <div class=" validation dob_err"><?php echo form_error('dob');?></div>
                </div>
<?php }?>

                <div class="form-group col-md-3">
                  <label>Current Education<span class="red-text">*</span></label>
                   <select id="qualification_id" name="wkn_qualification_id" class="form-control "aria-required="true">
                <option value="">Qualification</option>
                <?php 
                  foreach ($allQua->error_message->data as $p){
                    $selected = ($p->id == $this->input->post('qualification_id') or $p->id == get_cookie('qualification_id') ) ? ' selected="selected"' : "";
                    echo '<option value="'.$p->id.'" '.$selected.'>'.$p->qualification_name.'</option>';
                    } 
                ?>
              </select>
 <div class="validation qua_err"><?php echo form_error('qualification_id');?></div>
                  </div>
                
                
            
                <div class="form-group col-md-3">
                  <label>Interested Country<span class="red-text">*</span></label>
                  
<select id="country_id" name="wkn_country_id" class="form-control" aria-required="true">
                <option value="">Country</option>
                <?php 
                  foreach ($allCnt->error_message->data as $p){                               
                    $selected = ($p->country_id == $this->input->post('country_id') or $p->country_id == get_cookie('country_id') ) ? ' selected="selected"' : "";
                    echo '<option value="'.$p->country_id.'" '.$selected.'>'.$p->name.'</option>';
                  } 
                ?>
              </select>
              <div class="validation country_id_err"><?php echo form_error('country_id');?></div>    

                  </div>
                 

                <div class="form-group col-md-12 text-right">
                  <button type="button" class="btn btn-blue btn-mdl" onclick="return validate_walkin();">SUBMIT</button>
                </div>
              </div>
            </form>
            <div class="alert alert-success hide  font-14" id="wknreg_failmssg" role="alert">
                    <div><i class="fa fa-check-circle font-48"></i></div> Verification Code Message Successfully Verified! 
                  </div>
            
          
            
          </div>
        </div>
        <!-- End Content Part -->
      </div>
    </div>

<div class="reg-otp" >
    <div class="modal fade" id="wakinreg-OTP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-body">
            <div class="reg-modal clearfix"> <span class="cross-btn pull-right text-white hide-btn" data-dismiss="modal"><i class="fa fa-close font-20"></i></span>
              <?php echo form_open('walkin/walkin_registration/'.$center_name, array('name'=>'walkin-form_otp','id'=>'walkin-form_otp')); ?>
              <div class="reg-otp-info text-center text-white ">
                <h3>Verification Code</h3>
                <p class="mb-10 font-12">Verification Code has been sent on your phone/email.</p>
                
                  <div class="form-group">
                  <div class="subs-group" id="main_sec">
                    <input type="text" class="form-control" name="wkn_reg_otp" id="wkn_reg_otp" maxlength="4" placeholder="Please Enter OTP" style="height:55px;">
                     <button class="btn btn-blue btn-subs"  onclick="return Verify_wakinreg(this.value);" id="verifyBtn" type="button">Verify</button>      
                  </div>
                  <div class="validation hide reg_otp_err" > Wrong Verification Code!</div>
                  </div>

                  <div class="alert alert-success hide font-12" id="reg_opt_success_wkn" role="alert">
                    <div><i class="fa fa-check-circle font-48"></i></div>  
                  </div>
                    <div class="alert alert-danger hide font-12" id="reg_opt_danger_wkn" role="alert">
                   
                  </div>
                  
                  <div class="mt-30 hide">
                    <button type="button" class="btn btn-yellow verifyBtn mt-20" onclick="return Verify_wakinreg(this.value);" id="verifyBtn">Verify</button>  
                  </div>
                
              </div>
            </form>
              <!--End Login Popup-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <script>
      $(function() {
        $('.selector').change(function() {
          $('.show-vlu').hide();
          $('#' + $(this).val()).show();
        });
      });
      </script>






<script type="text/javascript">


function Verify_wakinreg(){

  var reg_otp = $("#wkn_reg_otp").val();
  if(reg_otp!=''){
      $(".reg_otp_err").text('');
  }else{
      $("#wkn_reg_otp").focus();
     $('#reg_opt_danger_wkn').removeClass('hide'); 
     $('#reg_opt_danger_wkn').html("Please Enter Verification Code"); 
      return false;
  }
var form = document.getElementById('walkin-form_otp'); //id of form
var mainform = document.getElementById('walkin-form'); //id of form
  var formdata = new FormData(form);
  $.ajax({
        url: "<?php echo site_url('walkin/student_walkin_otp');?>",
        type: 'post',
          data: formdata,   
           processData: false,
        contentType: false,                        
        success: function(response){        
      // alert(JSON.stringify(response))
     //alert(response.status)
          if(response.status==1){
       // alert('jj')
            $('#main_sec').addClass('hide');
            
            $('#wkn_reg_otp').val('');
            $('#reg_opt_danger_wkn').addClass('hide');             
            $('#reg_opt_success_wkn').removeClass('hide'); 
            $('#reg_opt_success_wkn').html(response.msg); 
            mainform.reset();
       setTimeout(function(){
            window.location.href = "<?php echo site_url('walkin/walkin_registration/'.$center_name);?>";
         }, 2000);
                  
          }else{
           // alert('else')
        $('#wkn_reg_otp').val(''); 
        $('#reg_opt_success_wkn').addClass('hide');   
              $('#reg_opt_danger_wkn').removeClass('hide'); 
              $('#reg_opt_danger_wkn').html(response.msg); 
            //$('.otpform').show(); 
          }                  
        }
       
    });


}


function validate_walkin_email(email){
  
    var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
    if(email.match(mailformat)){
        $(".email_err").text('');
        $(':input[type="submit"]').prop('disabled', false);  
        return true;
    }else{
        $(".email_err").text("Please enter valid email Id!");
        $('#email').focus();
        $(':input[type="submit"]').prop('disabled', true);
        return false;
    }
}


function validate_walkin(){

  //alert('ok')
  var letters = /^[A-Za-z ]+$/;
  var filter = /^[0-9-+]+$/;

  var country_code  = $("#country_code").val();
  var mobile = $("#wkn_mobile").val();
  var email  = $("#wkn_email").val();
  var enquiry_purpose_id = $("#wkn_enquiry_purpose_id").val();
  var fname  = $("#wkn_fname").val();
  var lname  = $("#lname").val();
  var gender_name = $("#wkn_gender_name").val();
  var dob = $("#dob").val();
  var qualification_id = $("#qualification_id").val();
  var country_id = $("#country_id").val();  


  if(country_code==''){    
    $("#country_code").focus();
    $(".country_code_err").text("Please select country code!");
    return false;
  }else{
     $(".country_code_err").text('');
  }  

  
  if (!filter.test(mobile)) {
   $('.mobile_err').text('Please enter valid Number!');
   $('#wkn_mobile').focus();
   return false;
  }else if(mobile.length>10 || mobile.length<10){
    $(".mobile_err").text('Please enter valid Number of 10 digit');
    return false;
  }else{
    $('.mobile_err').text('');
  } 

  
  if(enquiry_purpose_id==''){
    $("#wkn_enquiry_purpose_id").focus();
    $(".wkn_purpose_err").text("Please select visit purpose!");
    return false;
  }else{
     $(".wkn_purpose_err").text('');
  }

  if(enquiry_purpose_id==1){
    var test_module_id  = $( "#wkn_test_module_id" ).val();
    var programe_id  = $( "#wkn_programe_id" ).val();
    var free_demo  = $( "#wkn_free_demo" ).val();

      if(test_module_id==''){     
        $("#wkn_test_module_id").focus();
        $(".wkn_test_err").text("Please select test!");
        return false;
      }else if(programe_id==''){
        $("#wkn_programe_id").focus();
        $(".wkn_pgm_err").text("Please select programe!");
        return false;
      }else if(free_demo==''){
        $("#wkn_free_demo").focus();
        $(".wkn_demo_err").text("Please select demo!");
        return false;
      }else{
        $(".wkn_test_err").text('');
        $(".wkn_pgm_err").text('');
        $(".wkn_demo_err").text('');
      }     

  }else if(enquiry_purpose_id==2){
    var test_module_id  = $("#wkn_test_module_id" ).val();
    var programe_id  = $( "#wkn_programe_id" ).val();
    if(test_module_id==''){     
        $("#wkn_test_module_id").focus();
        $(".wkn_test_err").text("Please select test!");
        return false;
      }else if(programe_id==''){
        $("#wkn_programe_id").focus();
        $(".wkn_pgm_err").text("Please select programe!");
        return false;
      }else{
        $(".wkn_test_err").text('');
        $(".wkn_pgm_err").text('');
      }

  }else if(enquiry_purpose_id==3){
    var test_module_id  = $("#wkn_test_module_id" ).val();
    var programe_id  = $( "#wkn_programe_id" ).val();
    //alert(test_module_id)
      if(test_module_id==''){     
        $("#wkn_test_module_id").focus();
        $(".wkn_test_err").text("Please select test!");
        return false;
      }else if(programe_id==''){
        $("#wkn_programe_id").focus();
        $(".wkn_pgm_err").text("Please select programe!");
        return false;
      }else{
        $(".wkn_test_err").text('');
        $(".pgm_err").text('');
      }
    
  }else if(enquiry_purpose_id==4){
    var country_id2  = $( "#country_id2" ).val();
      if(country_id2==''){     
        $("#country_id2").focus();
        $(".cnt_err").text("Please select country!");
        return false;
      }else{
        $(".cnt_err").text('');
      }
    
  }else if(enquiry_purpose_id==5){

    var sub_events = $("#wkn_sub_events").val();
    //alert(sub_events)
    if(sub_events==''){     
        $("#wkn_sub_events").focus();
        $(".wkn_sub_events_err").text("Please select event!");
        return false;
      }else{
        $(".wkn_sub_events_err").text('');
      }
    
  }else{

  }
  
  
  if(fname==''){     
    $("#wkn_fname").focus();
    $(".fname_err").text("Please enter First Name!");
    return false;
  }else if(!(fname.match(letters))){
    $("#wkn_fname").focus();
    $(".fname_err").text("Please enter valid Name.Numbers not allowed!");
    return false;
  }else{
     $(".fname_err").text('');
  }

  if(gender_name==''){    
    $("#wkn_gender_name").focus();
    $(".wkn_gender_name_err").text("Please select gender!");
    return false;
  }else{
     $(".wkn_gender_name_err").text('');
  }

  if(dob==''){    
    $("#dob").focus();
    $(".dob_err").text("Please enter DOB!");
    return false;
  }else{
     $(".dob_err").text('');
  }

  if(qualification_id==''){    
    $("#qualification_id").focus();
    $(".qua_err").text("Please select qualification!");
    return false;
  }else{
     $(".qua_err").text('');
  }

  if(country_id==''){    
    $("#country_id").focus();
    $(".country_id_err").text("Please select pref. country!");
    return false;
  }else{
     $(".country_id_err").text('');
  } 

  var form = document.getElementById('walkin-form'); //id of form
  var formdata = new FormData(form);
     
$.ajax({
        url: "<?php echo site_url('walkin/walkin_registration/'.$center_name);?>",
        type: 'post',
         data: formdata,   
         processData: false,
        contentType: false,                  
        success: function(response)
        {
          
        if(response.status==1)
            {

               $('#wakinreg-OTP').modal('show');
            }
            else
            {
             

              $('#wknreg_failmssg').removeClass('hide');
                //$("#wknreg_failmssg").offset().top;
                $('#wknreg_failmssg').html(response.msg);
            
                setTimeout(function() {
       window.location.href = "<?php echo site_url('walkin/walkin_registration/'.$center_name);?>"
      }, 2000);
            }
          },
          beforeSend: function(){

          $('#fbk_sub_review_btn').attr("disabled", true);

      
        },
  });
}

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
  </section>