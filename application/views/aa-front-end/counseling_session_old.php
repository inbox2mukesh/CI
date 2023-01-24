<div>
	<section class="bg-lighter-theme">
		<div class="container" style="padding-bottom: 80px;">
			<div class="text-center">
				<h2 class="mb-30 text-uppercase font-weight-300 font-28 mt-0">Book <span class="text-theme-color-2 font-weight-500"> Visa Counseling</span></h2>
			</div>
			<form method="post" action="<?php echo site_url('counseling/book_session'); ?>" enctype="multipart/form-data" id="studentPostForm">
				<div class="counselling-booking-box" id="order-object">
					<div class="left-info-sec" id="down">
						<div class="logo-section">
							<img src="<?php echo site_url(LOGO) ?>" alt="<?php echo COMPANY; ?>">
						</div>
						<div class="info-section">
							<h6><?php echo ADMIN_NAME; ?></h6>
							<h2><?php echo COMPANY; ?></h2>
							<!-- <p><i class="fa fa-clock-o"></i><span>30 min</span></p>
							<p><i class="fa fa-credit-card"></i><span>$50 CAD</span></p> -->
							<div class="details">
								<?php //echo "<pre>"; print_r($generalInfo);
								echo $generalInfo[0]['description']; ?>
							</div>
						</div>
					</div>
					<div class="right-info-sec" id="up">
						<div class="booking-form">
							<div class="row clearfix">
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Full Name<span class="text-red">*</span></label>
										<input type="text" name="cs_fname" id="cs_fname" class="fstinput allow_alphabets length_validate removeerrmessage" placeholder="" autocomplete="off" value="<?php if(isset($this->session->userdata('student_login_data')->fname)) {   echo $this->session->userdata('student_login_data')->fname.' '.$this->session->userdata('student_login_data')->lname;; } else { echo "";}?>">
										<p class="validation cs_fname_err" id="cs_fname_error"></p>
									</div>
								</div>
								<!-- <div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>Last Name<span class="text-red">*</span></label>
								<input type="text" class="fstinput" placeholder="" autocomplete="off" name="cs_lname" id="cs_lname" maxlength="30" onKeyPress="return noNumbers(event)"> 
								<p class="validation" id="cs_lname_error"></p>
							</div>
						</div> -->
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Email<span class="text-red">*</span></label>
										<input type="text" class="fstinput allow_email removeerrmessage"  value="<?php if(isset($this->session->userdata('student_login_data')->email)) {   echo $this->session->userdata('student_login_data')->email; } else { echo "";}?>"  placeholder="" autocomplete="off" name="cs_email" id="cs_email" maxlength="60" onchange="echeck(this.value)">
										<p class="validation" id="cs_email_error"></p>
									</div>
								</div>
								
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Country Code<span class="text-red">*</span></label>
										<select class="selectpicker form-control" data-live-search="true" name="cs_country_code" id="cs_country_code">

									

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
	  foreach($countryCode->error_message->data as $p)
	  {  
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
	  ?></select>
										<p class="validation cs_country_code_err" id="cs_country_code_error"></p>
									</div>
								</div>
								

								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Mobile Number<span class="text-red">*</span></label>
										<input type="text" class="fstinput allow_numeric removeerrmessage" placeholder="" autocomplete="off" maxlength="10" name="cs_phoneno" id="cs_phoneno" onKeyPress="return nochar(event)" value="<?php if(isset($this->session->userdata('student_login_data')->mobile)) {   echo $this->session->userdata('student_login_data')->mobile; } else { echo "";}?>">
										<p class="validation" id="cs_phoneno_error"></p>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Services<span class="text-red">*</span></label>
										<select class="selectpicker form-control select_removeerrmessagep" name="service_id" id="service_id">
											<option value="">Select</option>
											<?php foreach ($serviceDataAll->error_message->data  as $d) { ?>
          <option value="<?php echo $d->id; ?>"><?php echo $d->enquiry_purpose_name; ?></option>
        <?php } ?>
										</select>
										<p class="validation service_id_err" id="service_id_error"></p>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Session Type<span class="text-red">*</span></label>
										<select class="selectpicker form-control select_removeerrmessagep" name="cs_session_type" id="cs_session_type" onchange="getSessionDates(this.value)">
											<option value="">Select</option>
											<?php
											foreach ($GET_SESSION_TYPE_URL->error_message->data as $p) {
												echo '<option value="' . $p->session_type . '" >' . ucfirst($p->session_type) . '</option>';
											}
											?>
										</select>
										<p class="validation cs_session_type_err" id="cs_session_type_error"></p>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Booking Date<span class="text-red">*</span></label>
										<div class="has-feedback">
											<input type="text" class="fstinput datepickerp removeerrmessage" name="cs_bookingdate" id="cs_bookingdate" disabled autocomplete="off" onchange="getSessionTimeSlot(this.value)"><span class="fa fa-calendar form-group-icon"></span>
											<p class="validation" id="cs_bookingdate_error"></p>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Time Slot<span class="text-red">*</span></label>
										<select class="selectpicker form-control select_removeerrmessagep" id="cs_timeslot" name="cs_timeslot" onchange="getFinalSession(this.value)" disabled>
											<option value="">Choose Time Slot</option>
										</select>
										<p class="validation" id="cs_timeslot_error"></p>
									</div>
								</div>
								<div class="form-group col-md-12">
									<label>Message<span class="text-red">*</span></label>
									<textarea name="message" id="message" placeholder="Enter your message " rows="4" class="t-area form-control removeerrmessage" onblur="getWordCount(this.value);"></textarea>
									<span class="valid-validation cl_message_err"></span>
								</div>
								<div class="col-md-12 col-sm-12 text-right">
									<input type="hidden" id="sessiongroupid" name="sessiongroupid">
									<input type="hidden" id="bookid" name="bookid">
									<button type="submit" class="btn btn-red btn-md font-weight-600" onclick="return Send_demo_counelling_post();">BOOK SESSION</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
</div>
<?php ob_start(); ?>

<script>
	
	$(".allow_alphabets").on("input", function(evt) {
		var self = $(this);
		self.val(self.val().replace(/[^a-zA-Z ]/, ""));
		if ((evt.which < 65 || evt.which > 90)) {
			evt.preventDefault();
		}
	});
	$(".allow_email").on("input", function(evt) {
		var self = $(this);
		self.val(self.val().replace(/[^a-zA-Z0-9.@_-]/, ""));
		if ((evt.which < 65 || evt.which > 90)) {
			evt.preventDefault();
		}
	});

	function echeck(str) {
		var at = "@"
		var dot = "."
		var lat = str.indexOf(at)
		var lstr = str.length
		var ldot = str.indexOf(dot)
		if (str.indexOf(at) == -1) {
			$("#cs_email_error").text('Please enter valid Email Id');
			return false
		}
		if (str.indexOf(at) == -1 || str.indexOf(at) == 0 || str.indexOf(at) == lstr) {
			$("#cs_email_error").text('Please enter valid Email Id');
			return false
		}
		if (str.indexOf(dot) == -1 || str.indexOf(dot) == 0 || str.indexOf(dot) == lstr) {
			$("#cs_email_error").text('Please enter valid Email Id');
			return false
		}
		if (str.indexOf(at, (lat + 1)) != -1) {
			$("#cs_email_error").text('Please enter valid Email Id');
			return false
		}
		if (str.substring(lat - 1, lat) == dot || str.substring(lat + 1, lat + 2) == dot) {
			$("#cs_email_error").text('Please enter valid Email Id');
			return false
		}
		if (str.indexOf(dot, (lat + 2)) == -1) {
			$("#cs_email_error").text('Please enter valid Email Id');
			return false
		}
		if (str.indexOf(" ") != -1) {
			$("#cs_email_error").text('Please enter valid Email Id');
			return false
		}
		$("#cs_email_error").text('');
		return true
	}
	/*
	var datesEnabled = ["02-04-2022","04-04-2022"];
	var start_on="01-04-2022";
	var end_on="05-04-2022";*/
	$('#cs_bookingdate_pp').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true,
		todayBtn: false,
		todayHighlight: false,
		beforeShowDay: function(date) {
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

	function getFinalSession(sessionTimeSlot) {
		var sessionType = $("#cs_session_type").val();
		var sessionDates = $("#cs_bookingdate").val();
		$.ajax({
			url: "<?php echo site_url('counseling/getFinalSession'); ?>",
			async: true,
			type: 'post',
			data: {
				sessionType: sessionType,
				sessionDates: sessionDates,
				sessionTimeSlot: sessionTimeSlot
			},
			success: function(data) {
				// alert(JSON.stringify(data))        	
				$("#sessiongroupid").val(data.counseling_sessions_group_id)
				$("#bookid").val(data.id)
				//$("#sessionzoomlink").val(data.zoom_link)          
			},
			beforeSend: function() {},
		});
	}

	function getSessionTimeSlot(sessionDates) {
		var sessionType = $("#cs_session_type").val();
		$.ajax({
			url: "<?php echo site_url('counseling/getSessionTimeSlot'); ?>",
			async: true,
			type: 'post',
			data: {
				sessionDates: sessionDates,
				sessionType: sessionType
			},
			success: function(data) {
				$("#cs_timeslot").prop("disabled", false);
				///alert(JSON.stringify(data))
				$("#cs_timeslot").html(data);
				$('.selectpicker').selectpicker('refresh');
			},
			beforeSend: function() {},
		});
	}

	function getSessionDates(sessionBranch) {
		var date = new Date();
		date.setDate(date.getDate());
		var sessionType = $("#cs_session_type").val();
		$.ajax({
			url: "<?php echo site_url('counseling/getSessionDates'); ?>",
			async: true,
			type: 'post',
			data: {
				session_type: sessionType
			},
			success: function(data) {
				//alert(JSON.stringify(data))
				//	$('#cs_bookingdate').pop('remove');
				$("#cs_bookingdate").prop("disabled", false);
				var dt = JSON.parse(data);
				var ppp = JSON.stringify(dt.dt_range);
				//var ppp = ["10-08-2022", "11-08-2022", "12-08-2022", "13-08-2022", "14-08-2022", "15-08-2022", "16-08-2022"];	
				$('#cs_bookingdate').datepicker('remove');
				$('#cs_bookingdate').datepicker({
					format: 'dd-mm-yyyy',
					startDate: dt.min_date,
					endDate: dt.max_date,
					autoclose: true,
					beforeShowDay: function(date) {
						var month = ("0" + (date.getMonth() + 1)).slice(-2);
						//var allDates = date.getFullYear() + '-' + month + '-' + date.getDate();
						var allDates = date.getDate() + '-' + month + '-' + date.getFullYear();
						if (ppp.indexOf(allDates) != -1)
							//alert(allDates)
							return true;
						else
							return false;
					}
				});
			},
			beforeSend: function() {},
		});
	}

	function Send_demo_counelling_post() {
		var flag=1;
		var numberes = /^[0-9-+]+$/;
		var letters = /^[A-Za-z ]+$/;
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
		var fname = $("#cs_fname").val();
		var email = $("#cs_email").val();
		var mobile = $("#cs_phoneno").val();
		var country_code = $("#cs_country_code").val();
		var dc_session_type = $("#cs_session_type").val();
		var dc_bookingdate = $("#cs_bookingdate").val();
		var dc_timeslot = $("#cs_timeslot").val();
		var sessiongroupid = $("#sessiongroupid").val();
		var service_id = $("#service_id").val();
		var message = $("#message").val();
		if (fname.match(letters)) {
			$("#cs_fname_error").text('');
		} else if (fname == "") {
			//$("#cs_fname").focus();
			$("#cs_fname_error").text("Please enter last Name.");
			flag=0;			
		} else {
			//$("#cs_fname").focus();
			$("#cs_fname_error").text("Please enter valid Name. Numbers not allowed!");
			flag=0;			
		}		
		if (email != "") {
			$("#cs_email_error").text('');
		} else {
			//$("#cs_email").focus();
			$("#cs_email_error").text('Please enter valid Email Id');
			flag=0;			
		}
		if (country_code == "") {
			//$("#dc_country_code").focus();
			$(".dc_country_code_error").text('Please select country code');
			flag=0;
		} else {
			$(".dc_country_code_error").text('');
		}
		if (mobile.length > 10 || mobile.length < 10) {
			//$("#cs_phoneno").focus();
			$("#cs_phoneno_error").text('Please enter valid Number of 10 digit');
			flag=0;			
		} else {
			$("#cs_phoneno_error").text('');
		}
		if (service_id == "") {
			//$("#service_id").focus();
			$("#service_id_error").text('Please select service');
			flag=0;
		} else {
			$("#service_id_error").text('');
		}
		if (dc_session_type == "") {
			//$("#cs_session_type").focus();
			$("#cs_session_type_error").text('Please select session type ');
			flag=0;			
		} else {
			$("#cs_session_type_error").text('');
		}
		if (dc_bookingdate == "") {
			//$("#cs_bookingdate").focus();
			$("#cs_bookingdate_error").text('Please select booking date');
			flag=0;			
		} else {
			$("#cs_bookingdate_error").text('');
		}
		if (dc_timeslot == "") {
			//$("#cs_timeslot").focus();
			$("#cs_timeslot_error").text('Please select time slot');
			flag=0;			
		} else {
			$("#cs_timeslot_error").text('');
		}
		if (message == "") {
			//$("#message").focus();
			$(".cl_message_err").text('Please message');
			flag=0;			
		} else {
			$(".cl_message_err").text('');
		}
		if(flag == 1)
		{
			var form = $('#studentPostForm');
		    return true;	
		} 
		else{
			return false;
		}
		
		/*$.ajax({
          url: "<?php echo site_url('demo_counselling_session/book_session'); ?>",
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
								window.location.href = "<?php echo site_url('our_students/student_dashboard'); ?>";
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
      });*/
	}

	function validate_complaint_email(email) {
		var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
		if (email.match(mailformat)) {
			$(".dc_email_error").text('');
			// $('.complaintBtn').prop('disabled', false);  
			return true;
		} else {
			$(".dc_email_error").text("Please enter valid email Id!");
			//$('#dc_email').focus();
			// $('.complaintBtn').prop('disabled', true);
			return false;
		}
	}
</script>
<!-- /*---------js for validate input noNumbers entered and nochar entered------*/ -->
<script type="text/javascript">
	function nochar(e) {
		var keynum
		var keychar
		var numcheck
		if (window.event) // IE
		{
			keynum = e.keyCode
		} else if (e.which) // Netscape/Firefox/Opera
		{
			keynum = e.which
		}
		if (keynum == 8) {
			keychar = String.fromCharCode(keynum)
			numcheck = /\d/
			return !numcheck.test(keychar)
		}
		keychar = String.fromCharCode(keynum)
		numcheck = /\d/
		return numcheck.test(keychar)
	}
</script>
<script type="text/javascript">
	function noNumbers(e) {
		var keynum
		var keychar
		var numcheck
		if (window.event) // IE
		{
			keynum = e.keyCode
		} else if (e.which) // Netscape/Firefox/Opera
		{
			keynum = e.which
		}
		if (keynum == 8) {
			keychar = String.fromCharCode(keynum)
			numcheck = /\d/
			return !numcheck.test(keychar)
		}
		keychar = String.fromCharCode(keynum)
		numcheck = /\d/
		return !numcheck.test(keychar)
	}

	function getWordCount(wordString) {
		var words = wordString.split(" ");
		words = words.filter(function(words) {
			return words.length > 0
		}).length;
		//alert(words)
		if (words > 150) {
			$(".cl_message_err").text("Please enter max. 150 words only!");
			return false;
		} else {
			$(".cl_message_err").text("");
		}
	}
</script>

<?php
global $customJs; 
$customJs = ob_get_clean();
?>