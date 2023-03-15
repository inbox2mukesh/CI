<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title;?></h3>
                <div class="box-tools pull-right">
                 <a href="<?php echo site_url('adminController/lead_management/all_Leads'); ?>" class="btn btn-success btn-sm">All leads</a> 
                 <a href="<?php echo site_url('adminController/student_enquiry/enquiry_not_replied'); ?>" class="btn btn-danger btn-sm hide">UN-TOUCHED Enquiry</a>
                    
                </div>	
            </div>  
            <div class="msg"></div>          
            <?php echo $this->session->flashdata('flsh_msg');?>
            <?php echo form_open('adminController/lead_management/add_new_lead', 
            array('onsubmit'=>'return validate_enq()')); ?>
          	<div class="box-body">
          		<div class="clearfix">

          			 <input type="hidden" name="enquiry_id" id="enquiry_id" class="form-control"> 

          		<div class="col-sm-4">
              <label for="enquiry_purpose_name" class="control-label">First Name<span class="text-danger">*</span></label>
                    <div class="form-group enqForm">
                      <input name="fname" id="fname" class="form-control input-ui-100 removeerrmessage" type="text" placeholder="First Name" aria-required="true" value="" maxlength="30" >
                      <span class="text-danger fname_err"></span>
                    </div>
                </div>

                <div class="col-sm-4">
                <label for="enquiry_purpose_name" class="control-label">Last Name</label>
                    <div class="form-group enqForm">
                      <input name="lname" id="lname" class="form-control input-ui-100 removeerrmessage" type="text" placeholder="Last Name" aria-required="true" value="" maxlength="30">
                      <span class="text-danger lname_err"></span>
                    </div>
                </div>                  

                    <div class="col-sm-4 enqForm">
                    <label for="enquiry_purpose_name" class="control-label">Country Code<span class="text-danger">*</span></label>
                    <div class="form-group">
                      <div class="styled-select">
                        <select id="country_code" name="country_code" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep"  aria-required="true">
                        
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
                            foreach ($all_country_code as $p){  
                              $selected = ($p['iso3'] == $c) ? ' selected="selected"' : "";
                              echo '<option value="'.$p['country_code'].'|'.$p['iso3'].'" '.$selected.'>'.$p['country_code'].'-'.$p['iso3'].'</option>';
                            } 
                        ?>
                        </select>
                        <span class="text-danger country_code_err"></span>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-4 enqForm">
                  <label for="enquiry_purpose_name" class="control-label">Phone Number<span class="text-danger">*</span></label>
                    <div class="form-group">
                      <input name="mobile" id="mobile" class="form-control input-ui-100 removeerrmessage" type="text" placeholder="Phone Number" aria-required="true" maxlength="10" onblur="validate_phone(this.value);">
                      <span class="text-danger mobile_err"></span>
                    </div>
                  </div>

                  <div class="col-sm-4 enqForm">
                  <label for="enquiry_purpose_name" class="control-label">Email<span class="text-danger">*</span></label>
                    <div class="form-group">
                      <input name="email" id="email" class="form-control input-ui-100 removeerrmessage" type="text" placeholder="Email" aria-required="true" maxlength="60" onblur="validate_email(this.value);">
                      <span class="text-danger email_err"></span>
                    </div>
                  </div>
                  <div class="col-md-4">
						
						<div class="form-group">
            <label for="enquiry_purpose_name" class="control-label">Division<span class="text-danger">*</span></label>
            <select id="division_id" name="division_id" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" aria-required="true" >
								<option value="" >Select Division</option>
								<?php 								
								foreach($all_division as $b){
									if(in_array(strtolower($b['division_name']),array('visa','academy'))){
										
										$selected = in_array($b['id'],$division_id) ? ' selected="selected"' : "";
										echo '<option value="'.$b['id'].'" '.$selected.'>'.$b['division_name'].'</option>';
									}
								} 
								?>
							</select>
							<span class="text-danger division_id_err"><?php echo form_error('division_id[]');?></span>
						</div>
					</div>
                  
                  <div class="col-sm-4 enqForm">
                  <label for="enquiry_purpose_name" class="control-label">Purpose<span class="text-danger">*</span></label>
                    <div class="form-group">
                      <div class="styled-select">
                      <select id="enquiry_purpose_id" name="enquiry_purpose_id" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" aria-required="true" >
                          <option value="">Purpose</option> 
                          <?php 
                              /* foreach ($all_purpose as $p)
                              {                                
                                echo '<option value='.$p['id'].'>'.$p['enquiry_purpose_name'].'</option>';
                              } */ 
                          ?>
                        </select>
                        <span class="text-danger enquiry_purpose_id_err purpose_err"></span>
                      </div>
                    </div>
                  </div>
                      

                  <div class="col-sm-12 enqForm">
                  <label for="enquiry_purpose_name" class="control-label">Enter Message<span class="text-danger">*</span></label>
                    <div class="form-group">
                      <textarea name="message" id="message" class="form-control required removeerrmessage" placeholder="Enter Message (Max. 150 words)" rows="5" aria-required="true" ></textarea>
                    <span class="text-danger message_err"></span>
                  </div>
                </div>
</div>
            <div class="box-footer">
   
            	<button type="submit" class="btn btn-danger rd-20">
            	<?php echo SAVE_LABEL;?>
            	</button>
            	<!-- <button type="button" class="btn btn-danger enqBtnv" onclick="return validate_enq();"><i class="fa fa-check"></i> <?php echo SAVE_LABEL;?> </button> -->
          	
            </div>
            <?php echo form_close(); ?>
				</div>
				
			</div>
         
      	</div>
    </div>
</div>
<?php ob_start(); ?>
<script type="text/javascript">


$("#division_id").change(function(){
  var division_id=$(this).val();
$.ajax({
		url: WOSA_ADMIN_URL + 'lead_management/ajax_get_enqpurpose',
		type: 'post',
		data: { division_id: division_id },
		success: function (response) {		
				
				$('#enquiry_purpose_id').html(response);
        $('.selectpicker').selectpicker('refresh')
		}
	});
});


function validate_enq(){

  //alert('ok')
  var flag=1;		
  var letters = /^[A-Za-z ]+$/;
  var filter = /^[0-9-+]+$/;

  var fname  = $("#fname").val();
  var lname  = $("#lname").val();
  var country_code  = $("#country_code").val();
  var mobile = $("#mobile").val();
  var email  = $("#email").val();
  var enquiry_purpose_id = $("#enquiry_purpose_id").val();
  var division_id = $("#division_id").val();
  var message = $("#message").val();
  
  //fname
  if(fname==''){     
    $("#fname").focus();
    $(".fname_err").text("Please enter First Name!");
    //$('.enqBtn').prop('disabled', true);
    var flag=0;	
  }else if(!(fname.match(letters))){
    $("#fname").focus();
    $(".fname_err").text("Please enter valid Name.Numbers not allowed!");
    var flag=0;	
  }else{
     $(".fname_err").text('');
     //$('.enqBtn').prop('disabled', false);
     //return true;   
  } 

  //country code
  if(country_code==''){    
    $("#country_code").focus();
    $(".country_code_err").text("Please select country code!");
    var flag=0;	
  }else{
     $(".country_code_err").text('');
  }

  //mobile
  if (!filter.test(mobile)) {
   $('.mobile_err').text('Please enter valid Number!');
   //$('.enqBtn').prop('disabled', true);
  
   var flag=0;	
  }else if(mobile.length>10 || mobile.length<10){
    $(".mobile_err").text('Please enter valid Number of 10 digit');
    //$('.enqBtn').prop('disabled', true);
    var flag=0;	
  }else{
    $('.mobile_err').text('');
    //$('.enqBtn').prop('disabled', false);
  } 

   
  //email
  var atposition=email.indexOf("@");  
  var dotposition=email.lastIndexOf("."); 
  if(email==''){     
   
    $(".email_err").text("Please enter email Id!");
    //$('.enqBtn').prop('disabled', true);
    var flag=0;	
  }else if(atposition<1 || dotposition<atposition+2 || dotposition+2>=email.length){  
    
    $(".email_err").text("Please enter valid email Id!");
    //$('.enqBtn').prop('disabled', true);
    var flag=0;	
  }else{
     $(".email_err").text('');
     //$('.enqBtn').prop('disabled', false); 
  } 
 //country code
 if(division_id==''){    
    $("#division_id").focus();
    $(".division_id_err").text("Please select division!");
    var flag=0;	
  }else{
     $(".division_id_err").text('');
  }
  //purpose
  if(enquiry_purpose_id==''){
    $("#enquiry_purpose_id").focus();
    //$('.enqBtn').prop('disabled', true);
    $(".purpose_err").text("Please select purpose!");
    var flag=0;	
  }else{
     $(".purpose_err").text('');
     //$('.enqBtn').prop('disabled', false);
  }


  if(message==''){     
    $("#message").focus();
    $(".message_err").text("Please enter your message!");
    //$('.enqBtn').prop('disabled', true);
    var flag=0;	
  }else{
     $(".message_err").text('');
     //$('.enqBtn').prop('disabled', false);   
  }

  if(flag == 0)
		{
			return false;
		} 
    else {
      return true;
    }

}	
</script>
<?php global $customJs;
$customJs = ob_get_clean(); ?>