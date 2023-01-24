<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
                <div class="box-tools pull-right">
                 <a href="<?php echo site_url('adminController/student_enquiry/enquiry'); ?>" class="btn btn-success btn-sm">ALL</a> 
                 <a href="<?php echo site_url('adminController/student_enquiry/enquiry_not_replied'); ?>" class="btn btn-danger btn-sm">UN-TOUCHED Enquiry</a>
                    
                </div>	
            </div>  
            <div class="msg"></div>          
            <?php echo $this->session->flashdata('flsh_msg');?>
            <?php echo form_open('adminController/student_enquiry/add_new_enquiry', 
            array('onsubmit'=>'return validate_enq()')); ?>
          	<div class="box-body">
          		<div class="row clearfix">

          			 <input type="hidden" name="enquiry_id" id="enquiry_id" class="form-control"> 

          		<div class="col-sm-6">
                    <div class="form-group mb-10 enqForm">
                      <input name="fname" id="fname" class="form-control" type="text" placeholder="First Name*" aria-required="true" value="" maxlength="30" >
                      <span class="text-danger fname_err"></span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group mb-10 enqForm">
                      <input name="lname" id="lname" class="form-control" type="text" placeholder="Last Name" aria-required="true" value="" maxlength="30">
                      <span class="text-danger lname_err"></span>
                    </div>
                </div>                  

                    <div class="col-sm-6 enqForm">
                    <div class="form-group mb-20">
                      <div class="styled-select">
                        <select id="country_code" name="country_code" class="form-control"  aria-required="true">
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

                  <div class="col-sm-6 enqForm">
                    <div class="form-group mb-10">
                      <input name="mobile" id="mobile" class="form-control" type="text" placeholder="Valid Phone*" aria-required="true" maxlength="10" onblur="validate_phone(this.value);">
                      <span class="text-danger mobile_err"></span>
                    </div>
                  </div>

                  <div class="col-sm-12 enqForm">
                    <div class="form-group mb-10">
                      <input name="email" id="email" class="form-control" type="text" placeholder="Valid Email*" aria-required="true" maxlength="60" onblur="validate_email(this.value);">
                      <span class="text-danger email_err"></span>
                    </div>
                  </div>
                  </div>
                  
                  <div class="col-sm-12 enqForm">
                    <div class="form-group mb-20">
                      <div class="styled-select">
                      <select id="enquiry_purpose_id" name="enquiry_purpose_id" class="form-control" aria-required="true" >
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
                      

                  <div class="col-sm-12 enqForm">
                    <div class="form-group mb-10">
                      <textarea name="message" id="message" class="form-control required" placeholder="Enter Message* (Max. 150 words)" rows="3" aria-required="true" ></textarea>
                    <span class="text-danger message_err"></span>
                  </div>
                </div>
				</div>
				
			</div>
          	<div class="box-footer">
            	<button type="submit" class="btn btn-danger">
            		<i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
            	</button>
            	<!-- <button type="button" class="btn btn-danger enqBtnv" onclick="return validate_enq();"><i class="fa fa-check"></i> <?php echo SAVE_LABEL;?> </button> -->
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>

<script type="text/javascript">

function validate_enq(){

  //alert('ok')
  var letters = /^[A-Za-z ]+$/;
  var filter = /^[0-9-+]+$/;

  var fname  = $("#fname").val();
  var lname  = $("#lname").val();
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

  i

  if(message==''){     
    $("#message").focus();
    $(".message_err").text("Please enter your message!");
    //$('.enqBtn').prop('disabled', true);
    return false;
  }else{
     $(".message_err").text('');
     //$('.enqBtn').prop('disabled', false);   
  }

}	
</script>

