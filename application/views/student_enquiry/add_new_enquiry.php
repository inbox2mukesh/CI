
      	<div class="box">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
                <div class="box-tools pull-right">
                 <a href="<?php echo site_url('adminController/student_enquiry/enquiry'); ?>" class="btn btn-success btn-sm">ALL</a> 
                 <a href="<?php echo site_url('adminController/student_enquiry/enquiry_not_replied'); ?>" class="btn btn-danger btn-sm">UN-TOUCHED Enquiry</a>
                    
                </div>	
            </div>  
            <div class="msg"></div>          
            <?php echo $this->session->flashdata('flsh_msg');?>
            <?php echo form_open('adminController/student_enquiry/add_new_enquiry'); ?>
          	<div class="box-body">
          		<div class="">

          		<input type="hidden" name="enquiry_id" id="enquiry_id" class="form-control"> 

          		<div class="col-md-3">
                    <div class="form-group mb-10 enqForm">
                      <input name="fname" id="fname" class="form-control input-ui-100" type="text" placeholder="First Name*" aria-required="true" maxlength="30" >
                      <span class="text-danger fname_err"></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-10 enqForm">
                      <input name="lname" id="lname" class="form-control input-ui-100" type="text" placeholder="Last Name" aria-required="true" maxlength="30">
                      <span class="text-danger lname_err"></span>
                    </div>
                </div> 

                <div class="col-md-3">
                    <div class="form-group mb-10 enqForm">
                      <input name="dob" id="dob" class="form-control noFutureDate input-ui-100" type="text" placeholder="DOB" aria-required="true" maxlength="10" autocomplete="off" readonly>
                      <span class="text-danger dob_err"></span>
                    </div>
                </div>                  

                    <div class="col-md-3 enqForm">
                    <div class="form-group mb-20">
                      <div class="styled-select">
                        <select id="country_code" name="country_code" class="form-control selectpicker selectpicker-ui-100"  aria-required="true">
                          <option value="">*Phone Code</option>
                          <?php 
                           $c='+91';
                            foreach ($all_country_code as $p){  
                              $selected = ($p['country_code'] == $c) ? ' selected="selected"' : "";
                              echo '<option value="'.$p['country_code'].'" '.$selected.'>'.$p['country_code'].'-'.$p['iso3'].'</option>';
                            } 
                        ?>
                        </select>
                        <span class="text-danger country_code_err"></span>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3 enqForm">
                    <div class="form-group mb-10">
                      <input name="mobile" id="mobile" class="form-control input-ui-100" type="text" placeholder="Valid Phone*" aria-required="true" maxlength="10" onblur="validate_phone(this.value);">
                      <span class="text-danger mobile_err"></span>
                    </div>
                  </div>

                  <div class="col-md-3 enqForm">
                    <div class="form-group mb-10">
                      <input name="email" id="email" class="form-control input-ui-100" type="text" placeholder="Valid Email*" aria-required="true" maxlength="60" onblur="validate_email(this.value);">
                      <span class="text-danger email_err"></span>
                    </div>
                  </div>
                  </div>
                  
                  <div class="col-md-6 enqForm">
                    <div class="form-group mb-20">
                      <div class="styled-select">
                      <select id="enquiry_purpose_id" name="enquiry_purpose_id" class="form-control selectpicker selectpicker-ui-100" aria-required="true" onchange="reflect_fields(this.value);">
                          <option value="">*Purpose</option> 
                          <?php 
                              foreach ($all_purpose as $p)
                              {                                
                                echo '<option value='.$p['id'].'>'.$p['enquiry_purpose_name'].'</option>';
                              } 
                          ?>
                        </select>
                        <span class="text-danger purpose_err"></span>
                      </div>
                    </div>
                  </div>

                      
                   

                      <div class="col-md-3 sub_events enqForm" style="display: none;">
                        <div class="form-group mb-20">
                          <div class="styled-select">
                            <select id="sub_events" name="sub_events" class="form-control selectpicker-ui-100 selectpicker" aria-required="true">
                              <option value="">*Sub Event</option> 
                              <option value="Reality Test- IELTS">Reality Test- IELTS</option>
                              <option value="Reality Test- CD-IELTS">Reality Test- CD-IELTS</option>
                              <option value="Reality Test- PTE">Reality Test- PTE</option>
                              <option value="Workshop">Workshop</option>   
                            </select>
                            <span class="text-danger sub_events_err"></span>
                          </div>
                        </div>
                      </div>                
                 
                      <div class="col-md-3 test enqForm" style="display: none;">
                        <div class="form-group mb-20">
                          <div class="styled-select">
                            <select id="test_module_id" name="test_module_id" class="form-control selectpocker selectpicker-ui-100" aria-required="true" onchange="reflectPgmBatch(this.value,'enquiry');">
                              <option value="">*Select Course</option> 
                              <?php 
                                  foreach ($all_test_module as $p)
                                  {                                    
                                    echo '<option value='.$p['test_module_id'].'>'.$p['test_module_name'].'</option>';
                                  } 
                                ?>                    
                            </select>
                            <span class="text-danger test_err"></span>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-3 pgm enqForm" style="display: none;">
                        <div class="form-group mb-20">
                          <div class="styled-select">
                            <select id="programe_id" name="programe_id" class="form-control selectpicker selectpicker-ui-100"aria-required="true">
                              <option value="">*Programe</option>
                             <?php 
                                  foreach ($all_programe_masters as $p)
                                  {                                   
                                    echo '<option value='.$p['programe_id'].'>'.$p['programe_name'].'</option>';
                                  } 
                              ?>
                            </select>
                            <span class="text-danger pgm_err"></span>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-3 demo enqForm" style="display: none;">
                          <div class="form-group mb-20">
                            <div class="styled-select">
                              <select id="free_demo" name="free_demo" class="form-control selectpicker selectpicker-ui-100" aria-required="true">
                                <option value="">*Demo</option>
                                <option value="1">Yes </option>
                                <option value="0">No </option>
                              </select>
                              <span class="text-danger demo_err"></span>
                            </div>
                          </div>
                      </div>

                      <div class="col-md-3 br enqForm" style="display: none;">
                          <div class="form-group mb-20">
                            <div class="styled-select">
                              <select id="center_id" name="center_id" class="form-control selectpicker-ui-100 selectpicker" aria-required="true">
                                <option value="">*Branch</option>
                                <?php 
                                  foreach ($all_branch as $p)
                                  {                                   
                                    echo '<option value='.$p['center_id'].'>'.$p['center_name'].'</option>';
                                  } 
                                ?>
                              </select>
                              <span class="text-danger br_err"></span>
                            </div>
                          </div>
                      </div>

                      <div class="col-md-3 cnt enqForm" style="display: none;">
                          <div class="form-group mb-20">
                            <div class="styled-select">
                              <select id="country_id" name="country_id" class="form-control selectpicker-ui-100 selectpicker" aria-required="true">
                                <option value="">*Prefered Country</option>
                                <?php 
                                  foreach ($allCnt as $p)
                                  {                                    
                                    echo '<option value='.$p['country_id'].'>'.$p['name'].'</option>';
                                  } 
                              ?>
                              </select>
                              <span class="text-danger cnt_err"></span>
                            </div>
                          </div>
                      </div>

                      <div class="col-md-12 enqForm">
                          <div class="form-group mb-10">
                            <textarea name="message" id="message" class="form-control required" placeholder="Enter Message* (Max. 150 words)" rows="3" aria-required="true" ></textarea>
                            <span class="text-danger message_err"></span>
                          </div>
                      </div>
				</div>
				
        <div class="box-footer">
     <div class="col-md-12">
            	<button type="button" class="btn btn-danger enqBtnv rd-20" onclick="return validate_enq();"><i class="fa fa-check"></i> <?php echo SAVE_LABEL;?> </button>
          
            <?php echo form_close(); ?>
      	</div>
        </div>
			</div>
       
        </div>


<script src="<?php echo site_url('resources/js/jquerynew-1.9.1.min.js');?>"></script>
<link rel="stylesheet" href="<?php echo site_url('resources/css/bootstrap-datepickernew.css');?>">
<script src="<?php echo site_url('resources/js/jquerynew2.min.js');?>"></script>
<script src="<?php echo site_url('resources/js/bootstrap-datepickernew.js');?>"></script>


<script type="text/javascript">

var currentDate = new Date();
    $('.noFutureDate').datepicker({
    endDate: "currentDate",
    maxDate: currentDate,
    autoclose:true,
    });

function validate_enq(){

  //alert('ok')
  var letters = /^[A-Za-z ]+$/;
  var filter = /^[0-9-+]+$/;

  var fname  = $("#fname").val();
  var lname  = $("#lname").val();
  var dob  = $("#dob").val();
  var country_code  = $("#country_code").val();
  var mobile = $("#mobile").val();
  var email  = $("#email").val();
  var enquiry_purpose_id = $("#enquiry_purpose_id").val();
  var message = $("#message").val();
  
  //fname
  if(fname==''){     
    $("#fname").focus();
    $(".fname_err").text("Please enter First Name!");
    //$('.enqBtn').prop('disabled', true);
    return false;
  }else if(!(fname.match(letters))){
    $("#fname").focus();
    $(".fname_err").text("Please enter valid Name.Numbers not allowed!");
    //$('.enqBtn').prop('disabled', true);
    return false;
  }else{
     $(".fname_err").text('');
     //$('.enqBtn').prop('disabled', false);
     //return true;   
  } 

  //country code
  if(dob==''){    
    $("#dob").focus();
    $(".dob_err").text("Please enter DOB");
    return false;
  }else{
     $(".dob_err").text('');
  }

  //country code
  if(country_code==''){    
    $("#country_code").focus();
    $(".country_code_err").text("Please select country code!");
    return false;
  }else{
     $(".country_code_err").text('');
  }

  //mobile
  if (!filter.test(mobile)) {
   $('.mobile_err').text('Please enter valid Number!');
   //$('.enqBtn').prop('disabled', true);
   $('#mobile').focus();
   return false;
  }else if(mobile.length>10 || mobile.length<10){
    $(".mobile_err").text('Please enter valid Number of 10 digit');
    //$('.enqBtn').prop('disabled', true);
    return false;
  }else{
    $('.mobile_err').text('');
    //$('.enqBtn').prop('disabled', false);
  } 

  //email
  var atposition=email.indexOf("@");  
  var dotposition=email.lastIndexOf("."); 
  if(email==''){     
    $("#email").focus();
    $(".email_err").text("Please enter email Id!");
    //$('.enqBtn').prop('disabled', true);
    return false;
  }else if(atposition<1 || dotposition<atposition+2 || dotposition+2>=email.length){  
    $("#email").focus();
    $(".email_err").text("Please enter valid email Id!");
    //$('.enqBtn').prop('disabled', true);
    return false; 
  }else{
     $(".email_err").text('');
     //$('.enqBtn').prop('disabled', false); 
  } 

  //purpose
  if(enquiry_purpose_id==''){
    $("#enquiry_purpose_id").focus();
    //$('.enqBtn').prop('disabled', true);
    $(".purpose_err").text("Please select purpose!");
    return false;
  }else{
     $(".purpose_err").text('');
     //$('.enqBtn').prop('disabled', false);
  }

  if(enquiry_purpose_id==1){  

    //test,pgm,demo
    var test_module_id  = $( "#test_module_id" ).val();
    var programe_id  = $( "#programe_id" ).val();
    var free_demo  = $( "#free_demo" ).val();

      if(test_module_id==''){     
        $("#test_module_id").focus();
        $(".test_err").text("Please select test!");
        return false;
      }else if(programe_id==''){
        $("#programe_id").focus();
        $(".pgm_err").text("Please select programe!");
        return false;
      }else if(free_demo==''){
        $("#free_demo").focus();
        $(".demo_err").text("Please select demo!");
        return false;
      }else{
        $(".test_err").text('');
        $(".pgm_err").text('');
        $(".demo_err").text('');
      }     

  }else if(enquiry_purpose_id==2){
    //test,pgm
    var test_module_id  = $( "#test_module_id" ).val();
    var programe_id  = $( "#programe_id" ).val();
    if(test_module_id==''){     
        $("#test_module_id").focus();
        $(".test_err").text("Please select test!");
        return false;
      }else if(programe_id==''){
        $("#programe_id").focus();
        $(".pgm_err").text("Please select programe!");
        return false;
      }else{
        $(".test_err").text('');
        $(".pgm_err").text('');
      }

  }else if(enquiry_purpose_id==3){
    //test,pgm,br
    var test_module_id  = $( "#test_module_id" ).val();
    var programe_id  = $( "#programe_id" ).val();
    var center_id  = $( "#center_id" ).val();
      if(test_module_id==''){     
        $("#test_module_id").focus();
        $(".test_err").text("Please select test!");
        return false;
      }else if(programe_id==''){
        $("#programe_id").focus();
        $(".pgm_err").text("Please select programe!");
        return false;
      }else if(center_id==''){
        $("#free_demo").focus();
        $(".br_err").text("Please select branch!");
        return false;
      }else{
        $(".test_err").text('');
        $(".pgm_err").text('');
        $(".br_err").text('');
      }
    
  }else if(enquiry_purpose_id==4){
    //cnt
    var country_id  = $( "#country_id" ).val();
      if(country_id==''){     
        $("#country_id").focus();
        $(".cnt_err").text("Please select country!");
        return false;
      }else{
        $(".cnt_err").text('');
      }
    
  }else if(enquiry_purpose_id==5){

    var sub_events = $("#sub_events").val();
    if(sub_events==''){     
        $("#sub_events").focus();
        $(".sub_events_err").text("Please select event!");
        return false;
      }else{
        $(".sub_events_err").text('');
      }
    
  }else{

  }

  if(message==''){     
    $("#message").focus();
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
        data: {fname: fname, lname: lname, dob: dob, country_code: country_code, mobile: mobile, email: email, enquiry_purpose_id: enquiry_purpose_id, message: message, sub_events: sub_events, country_id: country_id, center_id: center_id, test_module_id: test_module_id,  programe_id: programe_id,  free_demo: free_demo  },                              
        success: function(response){             
                              
            if(response.status=='true'){              
               
               $('#enquiry_id').val(response.enquiry_id);
               var enquiry_id = response.enquiry_id
               $.ajax({
                url: "<?php echo site_url('adminController/Student_enquiry/ajax_add_student_from_enquiry');?>",
                type: 'post',
                data: {enquiry_id: enquiry_id },                              
                success: function(response2){
                }
              });

               $('.msg').html('<div class="alert alert-info alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Enquiry sent successfully.<a href="#" class="alert-link"></a>.</div>');
            }else{
                 
                $('.msg').html('<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> OOps..Failed to send enquiry. Please try again!<a href="#" class="alert-link"></a>.</div>');
                $('#enquiry_id').val('');
            }                  
        }
  });

}
	
	
</script>

