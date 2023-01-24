<div class="login">

		<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">

			<div class="modal-dialog modal-sm">

				<div class="modal-content bg-white">
					
					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>

						<div class="modal-title text-uppercase"> <i class="fa fa-lock mr-5 font-20"></i> LOGIN</div>

					</div>
				
					

					<div class="modal-body">


							<div class="info">

							

								<div class="form-group">

									<lable>Email/Mobile Number/Unique ID<span class="text-red">*</span></lable>

									<input type="text" class="fstinput" placeholder="Enter Email/Mobile Number/Unique ID" id="username" name="username"  value='<?php echo get_cookie('wosa_username_f');?>' maxlength="60" >

									<div class="p-validation username_error"><?php echo form_error('username');?></div>

								</div>

								<div class="form-group">

									<lable>Password<span class="text-red">*</span></lable>

									<input type="password" class="fstinput" id="password" name="password" placeholder="Enter Password" value='<?php echo get_cookie('wosa_pwd_f');?>'>

										<div class="p-validation password_error"><?php echo form_error('username');?>

							    </div>

								 <?php 

                  if(get_cookie('wosa_username_f') and get_cookie('wosa_pwd_f') ){

                    $checked_f = 'checked= "checked" ';

                  }else{

                    $checked_f = '';

                  }

                ?>

								<div class="form-checkbox text-center mt-20">

									<input type="checkbox" id="rememberme_f" name="rememberme_f" type="checkbox" <?php echo $checked_f; ?>>

									<label for="rememberme_f" class="">Remember Me!</label>

								</div>

								<div class="form-group text-center">

									<button type="submit" class="btn btn-red btn-mdl mt-10" onclick="return Send_login();" id="login_button">SUBMIT</button>

								</div>

								<div class=" hide font-12" id="reg_opt_success_1" role="alert">

										<div><i class="fa fa-check-circle font-48"></i></div> Verification Code Message Successfully Verified! 

									</div>

										<div class=" hide font-12" id="reg_opt_danger_1" role="alert">

									 OOps..Wrong OTP entered. Please try again with correct!

									</div>

								

								<div class="mt-20 text-center"> <a style="cursor: pointer;" class="" id="forgot_password" >Forgot Password?</a> </div>

							</div>

							<!--End Login Popup-->

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

		</div>

	<script>

	function Send_login()

	{



    var username = $("#username").val();

    var password = $("#password").val();

    var rememberme_f = $("#rememberme_f").val();

   

    if (username == "")

	{

     // $("#username").focus();

      $(".username_error").text("Please enter username");

      return false;

    }	



    if(password == "")

	{

     // $("#password").focus();

      $(".password_error").text("Please enter password");

      return false;

    }



 

   

    $.ajax({

        url: "<?php echo site_url('My_login/stu_login');?>",

        type: 'post',

        data: {username: username, password: password, rememberme_f: rememberme_f},                

        success: function(response){

//alert(response.status)

		//return false;

          if(response.status==1)

		  {

			   //$('#modal-register').modal('hide');

			  // $('#modal-reg-OTP').modal('show');  

          window.location.href = "<?php echo site_url('our_students/update_profile');?>";			  

          }

		  else if(response.status==2)

		  {

			  window.location.href = "<?php echo site_url('our_students/student_dashboard');?>";	

		  }

		  else if(response.status==3)

		  {

			  

			   window.location.href = "<?php echo site_url('booking/checkout');?>"

		  }

		  else if(response.status==4)

		  {



								$.ajax({

								url: "<?php echo site_url('demo_counselling_session/post_book_session');?>",

								async : true,

								type: 'post',								

								success: function(data)

								{								

								  if(data.status==1)// for success popup

									{

								   	$('#modal-login').modal('hide'); 								 	

										$('#checkout_popup_modal').modal('show'); 

										$('#checkout_success_msg').removeClass('hide');   

										$('#checkout_fail_msg').addClass('hide');

										$('#studentPostForm')[0].reset();

										$('select').prop('selectedIndex',0);

										setTimeout(function()

										{

										window.location.href = "<?php echo site_url('our_students/student_dashboard');?>";	

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

			  $("#username").val("");

			  $("#password").val("");

			//alert(response.msg)

            $('#reg_opt_danger_1').removeClass('hide');

            $('#reg_opt_danger_1').html(response.msg);

            //$('.regsub_button').hide(); 

			//$("#username").focus();

          }                  

        },

        beforeSend: function(){

          $('.complaintBtnDiv_pro').show(); 

          $('#reg_button').prop('disabled', true);

        }

    });

    

  }



$("#forgot_password").click(function()

{

 	$('#modal-login').modal('hide');

 	$('#modal-password').modal('show');  

});



  </script>