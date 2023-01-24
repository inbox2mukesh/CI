<?php 
  if(isset($this->session->userdata('student_login_data')->id)){
    $readOnly='readonly="readonly" ';
     $readOnly_dis='disabled="disabled" ';
  }else{
    $readOnly='';
    $readOnly_dis='';
  }
?>
<section>
		<div class="container">
			<div class="counselling-booking">
				<div class="title">book a free online session</div>
				<form method="post" enctype="multipart/form-data" id="studentPostForm"   >
					<div class="row clearfix">
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label class="text-white">First Name<span class="text-white">*</span></label>
								<input type="text" class="fstinput"  name="dc_fname" id="dc_fname" placeholder="" value="<?php if(isset($this->session->userdata('student_login_data')->fname)) {   echo $this->session->userdata('student_login_data')->fname; } else { echo "";}?>" <?php echo $readOnly;?>  maxlength="30" > 
                         <div class="valid-validation text-yellow dc_fname_error"></div> 
							</div>
							<!--                       	<div class="validation"> Wrong!</div>--></div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label class="text-white">Last Name</label>
								<input type="text" name="dc_lname" id="dc_lname" class="fstinput" placeholder="" value="<?php if(isset($this->session->userdata('student_login_data')->lname)) {   echo $this->session->userdata('student_login_data')->lname; } else { echo "";}?>"    maxlength="30" <?php echo $readOnly;?>> 
							</div>
						</div>
						 <div class="form-group col-md-4 col-sm-6">
                    <label class="text-white">Date of Birth<span class="red-text">*</span></label>
                    <div class="has-feedback">
                      <input type="text" readonly autocomplete="off" class="fstinput datepicker"  name="dc_dob" id="dc_dob" value="<?php if(isset($this->session->userdata('student_login_data')->dob)) {   echo $this->session->userdata('student_login_data')->dob; } else { echo "";}?>" maxlength="10" data-date-format="dd-mm-yyyy" <?php echo $readOnly_dis;?>> <span class="fa fa-calendar form-group-icon"></span>

                       </div>
                       <div class="valid-validation text-yellow dc_dob_error"></div>
                  </div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label class="text-white">Email<span class="text-white">*</span></label>
								<input type="text" class="fstinput" name="dc_email" id="dc_email" placeholder="" value="<?php if(isset($this->session->userdata('student_login_data')->email)) {   echo $this->session->userdata('student_login_data')->email; } else { echo "";}?>" onblur="validate_complaint_email(this.value)"  maxlength="60"  <?php echo $readOnly;?> > 
								 <div class="valid-validation text-yellow  dc_email_error"></div> 
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label class="text-white">Country Code<span class="text-white">*</span></label>
								<select class="selectpicker form-control" data-live-search="true" name="dc_country_code" id="dc_country_code" <?php echo $readOnly_dis;?> >
									<option value="">Select</option>
									<?php 
                            $c='+91';
                            foreach ($countryCode->error_message->data as $p)
                            {  
                              $selected = ($p->country_code == $c) ? ' selected="selected"' : "";
                              echo '<option value="'.$p->country_code.'" '.$selected.'>'.$p->country_code.'-'.$p->iso3.'</option>';
                            } 
                        ?>
								</select>
								 <div class="valid-validation  text-yellow  dc_country_code_error"></div> 
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label class="text-white">Phone Number<span class="text-white">*</span></label>
								<input type="text" class="fstinput" name="dc_mobile" id="dc_mobile" placeholder=""  value="<?php if(isset($this->session->userdata('student_login_data')->mobile)) {   echo $this->session->userdata('student_login_data')->mobile; } else { echo "";}?>"   maxlength="10" <?php echo $readOnly;?> > 
								 <div class="valid-validation text-yellow  dc_mobile_error"></div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label class="text-white">Session Type<span class="text-white">*</span></label>
								<select class="selectpicker form-control" name="dc_session_type" id="dc_session_type" onchange="getSessionCourse(this.value),getSessionBranch(this.value)">
									<option value="">Select</option>
								<?php                             
								foreach ($GET_SESSION_TYPE_URL->error_message->data as $p)
								{                                
								echo '<option value="'.$p->session_type.'" >'.ucfirst($p->session_type).'</option>';
								} 
								?>
								</select>
								 <div class="valid-validation text-yellow dc_session_type_error"></div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label class="text-white">Course<span class="text-white">*</span></label>
								<select class="selectpicker form-control" data-live-search="true" name="dc_course" id="dc_course">
									<option value="">Select</option>
									
								</select>
								<div class="valid-validation text-yellow dc_course_error"></div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label class="text-white">Programe<span class="text-white">*</span></label>
								<select class="selectpicker form-control"  name="dc_programe" id="dc_programe"> 
									<option value="">Select</option>
									<?php 
                            
                            foreach ($allPgm->error_message->data as $p)
                            {  
                              
                     echo '<option value="'.$p->programe_id.'" >'.$p->programe_name.'</option>';
                            } 
                        ?>
								</select>
								<div class="valid-validation text-yellow dc_programe_error"></div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label class="text-white">Coaching Plateform<span class="text-white">*</span></label>
								<select class="selectpicker form-control" data-live-search="true" name="dc_coaching" id="dc_coaching" onchange="getSessionDates(this.value)">
									<option value="">Select</option>
									
								</select>
								<div class="valid-validation text-yellow dc_coaching_error"></div>
								 </div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label class="text-white">Booking Date<span class="text-white">*</span></label>
								<div class="has-feedback">
									<input type="text" class="fstinput datepickerp" name="dc_bookingdate" id="dc_bookingdate" readonly autocomplete="off" onchange="getSessionTimeSlot(this.value)"> <span class="fa fa-calendar form-group-icon" ></span>

								</div>
								<div class="valid-validation text-yellow dc_bookingdate_error"></div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label class="text-white">Time Slot<span class="text-white">*</span></label>
								<select class="selectpicker form-control" id="dc_timeslot" name="dc_timeslot"  onchange="getFinalSession(this.value)">
									<option value="">Choose Time Slot</option>
									
								</select>
								<div class="valid-validation text-yellow dc_timeslot_error"></div>

							</div>
						</div>
						<div class="col-md-12 text-right">
							<input type="hidden" value="0" id="sessionzoomlink" name="sessionzoomlink" />
							<input type="hidden" value="0" id="sessiongroupid" name="sessiongroupid" />

							<button type="button" class="btn btn-yellow btn-mdl font-weight-600" id="book_session"  onclick="return Send_demo_counelling_post();">BOOK SESSION</button>
						</div>
					</div>
				</form>
			</div>
		</div>
</section>
	<!--Start About Section-->
	<!--Start About Section-->
	<section class="bg-lighter">
		<div class="container">
			<!--Start Grid Container-->
			<style>
				.mns-80{
					margin-top:0px;
				}
			</style>
			<?php   include('home/product_marquee_short.php');?>
			<!--End Grid Container-->	
			<!--Start Grid Container-->
			<?php  include('home/about_us_short.php');?>
			<!--End Grid Container-->
		</div>
	</section>
	<!--End About Section-->
	<!-- Start Services section-->
	 <?php include('home/popular_courses.php');?>
	<!--End Courses Section-->
	<!--Start Practice Pack Section-->
	<?php include('home/popular_practice_pack.php');?>
	<!--End Practice Pack Section-->
	<!--Start Upcoming Reality Test Section-->
	<?php  include('home/reality_test_short.php'); ?>
	<!--End Upcoming Reality Test Section-->
	
		<!--Start Events Section-->
		<?php //include('home/workshop_short.php'); ?>
		<!--End Events Section-->
	
	<!--Start Testimonials Section-->
	<?php include('home/std_testimonials_videos_short.php');?>
	<!--End Testimonials Section-->
	<!--Start Result Section-->
	<?php 	include('home/recent_results_short.php');?>
	<!--End Result Section-->
	<!--Start Latest Post Section-->
	<?php 	include('home/free_resources_shot.php');?>
		
		<!--End Latest Post Section-->
		<?php include('home/subscribe.php');?>
	<!--End Latest Post Section-->
	 <div class="modal fade" id="checkout_popup_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-body">
            
              <div class="reg-otp-info text-center">
                <div class="alert alert-success hide font-15" id="checkout_success_msg" role="alert">
                    <div class="success-box">
                      <h2>Booking Done Successfully</h2>
                      <p>Thankyou for Booking  with us.</p>
                      <div class="font-14">More details have been sent to your email.</div>
                      <!--End Login Popup-->
                    </div>
                  </div>
                    <div class="alert alert-danger hide font-15" id="checkout_fail_msg" role="alert">
                      <div class="danger-box">
                      <h2>Booking Fail</h2>
                      <p>Error....Try again.</p>
                      
                      <!--End Login Popup-->
                    </div>     
                  </div>  
                </div>
              <!--End Login Popup-->
            
          </div>
          <div class="modal-footer"> <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> </div>
        </div>
      </div>
    </div>
	<!--End Latest Post Section-->
<script src="<?php echo site_url()?>resources-f/js/jquery.min.js"></script>	
<script src="<?php echo site_url()?>resources-f/js/bootstrap-datepicker.js"></script>
	
<script>


/*
var datesEnabled = ["02-04-2022","04-04-2022"];
var start_on="01-04-2022";
var end_on="05-04-2022";*/
$('.datepickerp').datepicker({format: 'dd-mm-yyyy',autoclose: true, todayBtn: false,
        todayHighlight: false,beforeShowDay: function (date) 
        {
/*
		var month = ("0" + (date.getMonth() + 1)).slice(-2);
		var hhh=('0' + date.getDate()).slice(-2);
		var allDates =  ('0' + date.getDate()).slice(-2) + '-' + month +'-' + date.getFullYear();
		if(datesEnabled.indexOf(allDates) != -1)
		{

		
		return [true,'hello','hhh'];
	}
		else
		{
		return false;
	}*/
return false;
    }
   });

</script>

<script type="text/javascript">
	function validate_complaint_email(email){
  
    var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
    if(email.match(mailformat)){
        $(".dc_email_error").text('');
       // $('.complaintBtn').prop('disabled', false);  
        return true;
    }else{
        $(".dc_email_error").text("Please enter valid email Id!");
        //$('#dc_email').focus();
       // $('.complaintBtn').prop('disabled', true);
       return false;
    }
}

/*
$("#dc_session_type").change(function() 
{
  alert( "Handler for .change() called." );
	$('.datepickerp').datepicker('destroy').datepicker({format: 'dd-mm-yyyy',autoclose: true, todayBtn: false,
        todayHighlight: false,beforeShowDay: function (date) 
        {

return false;
    }
   });
});*/

function getSessionCourse(sesstype_val)
{


			//$('#dc_bookingdate').val("");
     $.ajax({
          url: "<?php echo site_url('demo_counselling_session/GetSessionCourse');?>",
          async : true,
          type: 'post',
          data: {session_type:sesstype_val},
          success: function(data)
          {
			     $("#dc_course").html(data);
		       $('.selectpicker').selectpicker('refresh');
         //  $('#dc_bookingdate').datepicker('destroy');
          // $('#dc_bookingdate').val("");
          // getSessionDates("");

          },
          beforeSend: function(){
              
          },
      });
}
function getSessionBranch(sesstype_val)
{
	
	$.ajax({
          url: "<?php echo site_url('demo_counselling_session/GetSessionBranch');?>",
          async : true,
          type: 'post',
          data: {session_type:sesstype_val},
          success: function(data)
          {
			  $("#dc_coaching").html(data);
		      $('.selectpicker').selectpicker('refresh');
          },
          beforeSend: function(){
              
          },
      });

}
function getSessionDates(sessionBranch)
{
var date = new Date();
date.setDate(date.getDate());

	var sessionType = $("#dc_session_type").val();
    var sessionCourse = $("#dc_course").val(); 
	$.ajax({
          url: "<?php echo site_url('demo_counselling_session/getSessionDates');?>",
          async : true,
          type: 'post',
          data: {session_type:sessionType,sessionCourse:sessionCourse,sessionBranch:sessionBranch},
          success: function(data)
          {          	
							var dt=JSON.parse(data);		
							var ppp=JSON.stringify(dt.dt_range);
							//var ppp = ["5-04-2022","6-04-2022","20-04-2022"];	
							$('#dc_bookingdate').datepicker('remove');
							$('#dc_bookingdate').datepicker({format: 'dd-mm-yyyy',startDate: dt.min_date,endDate:dt.max_date,autoclose: true,beforeShowDay: function (date) 
							{
							var month = ("0" + (date.getMonth() + 1)).slice(-2);
							//var allDates = date.getFullYear() + '-' + month + '-' + date.getDate();
							var allDates =  date.getDate()+'-'+month+'-'+date.getFullYear();
							if(ppp.indexOf(allDates) != -1)			
							//alert(allDates)
							return true;      
							else
							return false;
							}
							});
          },
          beforeSend: function(){              
          },
      });

}

function getSessionTimeSlot(sessionDates)
{	
	var sessionType = $("#dc_session_type").val();
	var sessionCourse = $("#dc_course").val(); 
	var sessionBranch = $("#dc_coaching").val(); 
     $.ajax({
          url: "<?php echo site_url('demo_counselling_session/getSessionTimeSlot');?>",
          async : true,
          type: 'post',
          data: {sessionDates:sessionDates,sessionType:sessionType,sessionCourse:sessionCourse,sessionBranch:sessionBranch},
          success: function(data)
          {
          	
			  $("#dc_timeslot").html(data);
		      $('.selectpicker').selectpicker('refresh');
          },
          beforeSend: function(){
              
          },
      });
}

function getFinalSession(sessionTimeSlot)
{
	var sessionType = $("#dc_session_type").val();
	var sessionCourse = $("#dc_course").val(); 
	var sessionBranch = $("#dc_coaching").val(); 
	var sessionDates = $("#dc_bookingdate").val(); 
     $.ajax({
          url: "<?php echo site_url('demo_counselling_session/getFinalSession');?>",
          async : true,
          type: 'post',
          data: {sessionType:sessionType,sessionCourse:sessionCourse,sessionBranch:sessionBranch,sessionDates:sessionDates,sessionTimeSlot:sessionTimeSlot},
          success: function(data)
          {          	
          	$("#sessiongroupid").val(data.counseling_sessions_group_id)
          	$("#sessionzoomlink").val(data.zoom_link)          
          },
          beforeSend: function(){              
          },
      });
}

$( "#dc_session_typepp" ).change(function() 
{
	var session_type = $(this).val();	  
});
 function Send_demo_counelling_post()
    {
    	
		var numberes = /^[0-9-+]+$/;
		var letters = /^[A-Za-z ]+$/;
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
		var fname = $("#dc_fname").val();
		var email = $("#dc_email").val();
		var mobile = $("#dc_mobile").val();
		var country_code = $("#dc_country_code").val();
		var dc_session_type = $("#dc_session_type").val();
		var dc_course = $("#dc_course").val();    	
		var dc_programe = $("#dc_programe").val();
		var dc_coaching = $("#dc_coaching").val();
		var dc_bookingdate = $("#dc_bookingdate").val();
		var dc_timeslot = $("#dc_timeslot").val();
		var dob = $("#dc_dob").val();
		var sessiongroupid = $("#sessiongroupid").val();
		if(fname.match(letters)){
		$(".dc_fname_error").text('');
		}else{
		//$("#dc_fname").focus();
		$(".dc_fname_error").text("Please enter valid Name. Numbers not allowed!");
		return false;
		}

		if(dob == ""){
	//	$("#dc_dob").focus();
		$(".dc_dob_error").text('Please select dob');
		return false;
		}else{ 
		$(".dc_dob_error").text('');
		}
		if(validate_complaint_email(email)){
		$(".dc_email_error").text('');
		}else{ 
		//$("#dc_email").focus();
		$(".dc_email_error").text('Please enter valid Email Id');
		return false;
		}

		if(country_code == ""){
		//$("#dc_country_code").focus();
		$(".dc_country_code_error").text('Please select country code');
		return false;
		}else{ 
		$(".dc_country_code_error").text('');
		}

		if(mobile.length>10 || mobile.length<10){
		//$("#dc_mobile").focus();
		$(".dc_mobile_error").text('Please enter valid Number of 10 digit');
		return false;
		}else{ 
		$(".dc_mobile_error").text('');
		}

		if(dc_session_type == ""){
		//$("#dc_session_type").focus();
		$(".dc_session_type_error").text('Please select session type ');
		return false;
		}else{ 
		$(".dc_session_type_error").text('');
		}

		if(dc_course == ""){
		//$("#dc_course").focus();
		$(".dc_course_error").text('Please select course');
		return false;
		}else{ 
		$(".dc_course_error").text('');
		}

		if(dc_programe == ""){
		//$("#dc_programe").focus();
		$(".dc_programe_error").text('Please select programe');
		return false;
		}else{ 
		$(".dc_programe_error").text('');
		}

		if(dc_coaching == ""){
		//$("#dc_coaching").focus();
		$(".dc_coaching_error").text('Please select couching plateform');
		return false;
		}else{ 
		$(".dc_coaching_error").text('');
		}

		if(dc_bookingdate == ""){
		//$("#dc_bookingdate").focus();
		$(".dc_bookingdate_error").text('Please select booking date');
		return false;
		}else{ 
		$(".dc_bookingdate_error").text('');
		}

		if(dc_timeslot == ""){
		//$("#dc_timeslot").focus();
		$(".dc_timeslot_error").text('Please select time slot');
		return false;
		}else{ 
		$(".dc_timeslot_error").text('');
		}
		var form = $('#studentPostForm');
		//return false;
		$.ajax({
          url: "<?php echo site_url('demo_counselling_session/book_session');?>",
          async : true,
          type: 'post',
          data: form.serialize(),
          success: function(data)
          {          	
          	if(data.status==1)// for success popup
						{							
							$('#checkout_popup_modal').modal('show'); 
							$('#checkout_success_msg').removeClass('hide');   
							$('#checkout_fail_msg').addClass('hide');
							setTimeout(function(){
								window.location.href = "<?php echo site_url('our_students/student_dashboard');?>";
								}, 2000);    
							$('#studentPostForm')[0].reset();
						}
						else if(data.status==2) // for opt popup
						{
							$('#modal-reg-OTP').modal('show');       
						}
						else if(data.status==3) // for login popup
						{
							$('#modal-login').modal('show'); 
						}
						else if(data.status==4)
						{
							$('#checkout_popup_modal').modal('show');
							$('#checkout_success_msg').addClass('hide');
							$('#checkout_fail_msg').removeClass('hide');     
							$('#checkout_fail_msg').html(data.msg); 
						}
						else
						{
							$('#checkout_popup_modal').modal('show');
							$('#checkout_success_msg').addClass('hide');
							$('#checkout_fail_msg').removeClass('hide');     
							//$('#checkout_fail_msg').html(response.msg); 
						}           
          },
          beforeSend: function()
          {
              
          },
      });
}	

function anc_clickhere()
{
    $('#checkout_popup_modal').modal('hide');   
   	$('#studentPostForm')[0].reset();
   	$('select').prop('selectedIndex',0);
}
</script>