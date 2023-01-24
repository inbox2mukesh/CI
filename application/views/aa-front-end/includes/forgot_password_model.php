<div class="login">
		<div class="modal fade" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-body">
						<div class="login-modal"> <span class="cross-btn pull-right hide-btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close font-20"></i></span>
							<div class="info">
								<h2><i class="fa fa-lock mr-10 font-28"></i> FORGOT PASSWORD</h2>
								<p class="text-center">We will send a new system<br> generated password on your email</p>
								<div id="form-sec">
								<div class="form-group mt-20">
									<lable>Email</lable>
									<input type="email"  id="forgotemail" name="forgotemail" class="fstinput checkvalidemail removeerrmessage"  maxlength="60" placeholder="Enter Your Registered Email Id" autocomplete="off">
 <div class="p-validation forgotemail_err for_email_err" id="forgotemail_err"><?php echo form_error('forgotemail');?></div>

									 </div>
									  
								<div class="mt-30 text-center">
									<button type="button" onclick="return Send_forgot_pass();"  class="btn btn-red btn-mdl" id="forgot_password_btn">SUBMIT</button>
								</div>
								</div>
								<div class="hide font-12 forgotemail_err mt-20" id="danger_forgot_msg" role="alert"></div>
          <div class="hide" id="success_forgot_msg" ></div>
							</div>
							
							<!--End Login Popup-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	
	<script>
	function Send_forgot_pass()
	{
		var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,10}\b$/i;    
    var email = $("#forgotemail").val();   

    if (email == "")
	  {
      //$("#email").focus();
      $(".for_email_err").text("Please enter the valid Email Id");
      return false;
    }

	if (email.match(mailformat))
	 {
		
	}
	else {
		//$("#email").focus();
      $(".for_email_err").text("Please enter the valid Email Id");
      return false;
	}
	


		$.ajax({
        url: "<?php echo site_url('forgot_password/send_forgot_pass');?>",
        type: 'post',
        data: {email: email},                
        success: function(response){
			$('#forgot_password_btn').prop('disabled', false);
		  if(response.status==1)
		  {
		  	//alert(response.status)
		  	$("#form-sec").addClass('hide'); 
			  //$('#forgotemail').prop('disabled', true);
			   $('#success_forgot_msg').removeClass('hide');
			   $('#success_forgot_msg').html(response.msg);	 
				setTimeout(function()
				{
				window.location.href = "<?php echo site_url('my_login');?>";	
				}, 5000); 
      }
		   else
		  {
		  	$("#forgotemail").val(''); 
		  	$('#success_forgot_msg').addClass('hide');
			   $('#danger_forgot_msg').removeClass('hide');
			   $('#danger_forgot_msg').html(response.msg);	  
      }                  
     },
        beforeSend: function(){
         // $('.complaintBtnDiv_pro').show(); 
          $('#forgot_password_btn').prop('disabled', true);
        }
    });
	
    
    
  }
</script>