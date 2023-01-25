<link href="<?php echo site_url('resources-f/css/steps.css'); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo site_url('resources-f/css/card-slider.css'); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo site_url('resources-f/css/event-booking.css'); ?>" rel="stylesheet" type="text/css">
<!-- <link rel="stylesheet" href="css/jquery-steps.css"> -->
<section class="bg-lighter book-visa-counselling">
	<div class="container">
		<h2 class="font-weight-300 text-uppercase text-center mb-30 font-28">Book Visa <span class="text-red font-weight-600">Counseling</span></h2>
		<!-- Start Main step section -->
		<form method="post" action="<?php echo site_url('counseling/book_session'); ?>" enctype="multipart/form-data" class="form-validation" id="studentPostForm" data-cc-on-file="false" data-stripe-publishable-key="<?php echo $this->config->item('stripe_key_cc') ?>">
			<div class="step-app event-booking" id="demo" style="position: relative;">
				<ul class="step-steps" style="display:none;">
					<li data-step-target="step1">Step 1</li>
					<li data-step-target="step2">Step 2</li>
					<li data-step-target="step3">Step 3</li>
				</ul>

				<div class="step-content counselling-booking-box">
					<div class="step-tab-panel bg-white" data-step="step1">
						<div>
							<div class="left-info-sec" id="down">
								<div class="logo-section">
									<img src="<?php echo site_url() ?>resources-f/images/logo-sm.webp" alt="<?php echo COMPANY; ?>">
									<div class="font-14 font-weight-600 text-grey mt-15"><?php echo ADMIN_NAME; ?></div>
									<div class="font-18 font-weight-600 mb-15"><?php echo COMPANY; ?></div>
								</div>
								<div class="info-section">
									<div class="details">
										<div class="text-limit"><?php echo $generalInfo[0]['description']; ?></div>
									</div>
								</div>
							</div>
							<!-- end left info -->
							<!-- Start Right info -->
							<div class="right-info-sec" id="up">
								<div class="book-title">Select Date<span class="text-red">*</span></div>
								<!-- Start Date Section -->
								<div class="date-section">
									<div class="glider-contain multiple">
										<div class="timeslot-card-row">
											<div class="glider" id="glider-cut">
												<?php
												if (count($sessionDates->error_message->data) > 0) {
													foreach ($sessionDates->error_message->data as $key => $val) {
														$date = date_create($val->session_date);
												?>
														<!--Card info-->
														<div class="card">
															<div class="time-slot">
																<input type="radio" class="cs_bookingdate" id="rd<?php echo $key; ?>" name="cs_bookingdate" value="<?php echo $val->session_date; ?>" onclick="getSessionTimeSlot(this,this.value)" data-sesstype="<?php echo ucfirst($val->session_type); ?>" data-sessduration="<?php echo $val->duration; ?>" data-sessamount="<?php echo $val->amount; ?>" data-sessdate="<?php echo date_format($date, "M d Y"); ?>">
																<label for="rd<?php echo $key; ?>">
																	<h2>
																		<p><?php echo date_format($date, "M"); ?></p>
																		<p><?php echo date_format($date, "Y"); ?></p>
																		<p><?php echo date_format($date, "d"); ?></p>
																	</h2>
																	<div class="info">
																		<div><?php echo $val->duration; ?> Minute </br><?php echo ucfirst($val->session_type); ?></div>
																		<div class="disc"><?php echo CURRENCY; ?> <?php echo $val->amount; ?></div>
																	</div>
																</label>
															</div>
														</div>
														<!--Card info-->
													<?php }
												} else { ?>
													<div class="card">No session found</div>
												<?php } ?>


											</div>
										</div>
										<?php
										if (count($sessionDates->error_message->data) > 4) {
										?>
											<div class="evnt-btn">
												<div class="glider-btn">
													<button role="button" aria-label="Previous" class="glider-prev"><i class="fa fa-chevron-left"></i></button>
													<button role="button" aria-label="Next" class="glider-next"><i class="fa fa-chevron-right"></i></button>
												</div>
											</div>
										<?php } ?>
									</div>
								</div>
								<!-- End date section -->
								<!-- Time slot section -->
								<div class="book-title">Time Slot<span class="text-red">*</span></div>
								<div class="font-13 text-grey mb-10"><i class="fa fa-spinner fa-spin mr-10"></i> Select Date and Load Time Slots</div>
								<div class="time-slot-row" id="time_slot_row"></div>
                               <div class="row">
							<div class="col-md-12">
								<div class="font-13 text-grey mb-10">Date and Time according to Toronto Canada (UTC - 5)</div>
										</div>
										</div>
							</div>
							<!-- End Right info -->
						</div>
					</div>
					<div class="step-tab-panel bg-white" data-step="step2">
						<!-- Start left info -->
						<div>
							<div class="left-info-sec" id="down">
								<div class="logo-section">
									<img src="<?php echo site_url() ?>resources-f/images/logo-sm.webp" alt="<?php echo COMPANY; ?>">
									<div class="font-14 font-weight-600 text-grey mt-15"><?php echo ADMIN_NAME; ?></div>
									<div class="font-18 font-weight-600 mb-15"><?php echo COMPANY; ?></div>
								</div>
								<div class="info-section">
									<p><i class="fa fa-calendar"></i><span class="display_session_datetime"></span></br>
										<span class="font-11 font-weight-500 text-grey">Date and Time according to Toronto Canada (UTC - 5)</span>
									</p>
									<p><i class="fa fa-desktop"></i><span class="display_session_type"></span></p>
									<p><i class="fa fa-clock-o"></i><span class="display_session_duration"></span></p>
									<p><i class="fa fa-credit-card"></i><span class="display_session_price"></span></p>
								</div>
							</div>
							<!-- end left info -->
							<!-- Start Right info -->
							<div class="right-info-sec" id="up">
								<div class="row mb-20">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label>Full Name<span class="red-text">*</span></label>
											<input type="text" name="cs_fname" id="cs_fname" class="fstinput allow_alphabets length_validate removeerrmessage" placeholder="Full Name" autocomplete="off" value="<?php if (isset($this->session->userdata('student_login_data')->fname)) {
																																																			echo $this->session->userdata('student_login_data')->fname . ' ' . $this->session->userdata('student_login_data')->lname;;
																																																		} else {
																																																			echo "";
																																																		} ?>">
											<div class="valid-validation cs_fname_err" id="cs_fname_error"></div>
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label>Email<span class="red-text">*</span></label>
											<input type="email" class="fstinput allow_email removeerrmessage" value="<?php if (isset($this->session->userdata('student_login_data')->email)) {
												echo $this->session->userdata('student_login_data')->email;} else {echo "";} ?>" placeholder="Email" autocomplete="off" name="cs_email" id="cs_email" maxlength="60" onchange="echeck(this.value)">
											<div class="valid-validation cs_email_error" id="cs_email_error"></div>
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label>Phone Number<span class="red-text">*</span></label>
											<div class="group-flex">
												<div class="input-rel">
													<select class="phone-code selectpicker" data-show-subtext="true" data-live-search="true" style="display: none" name="cs_country_code" id="cs_country_code">
														<?php
														if (DEFAULT_COUNTRY == 38) {
															$c = 'CA';
														} elseif (DEFAULT_COUNTRY == 13) {
															$c = 'AU';
														} elseif (DEFAULT_COUNTRY == 101) {
															$c = 'IN';
														} else {
															$c = 'IN';
														}
														foreach ($countryCode->error_message->data as $p) {
															$sel = "";

															if (trim($p->iso3) == $c) {
																$sel = "selected";
															}
															if ($p->country_code == $this->session->userdata('student_login_data')->country_code and $p->iso3 == $this->session->userdata('student_login_data')->country_iso3_code) {
																$sel = "selected";
															}

														?>
															<option value="<?php echo $p->country_code . '|' . $p->iso3; ?>" <?php echo $sel; ?>><?php echo $p->country_code . '- ' . $p->iso3; ?></option>
														<?php
														}
														?>
													</select>
													<input type="tel" placeholder="Phone Number" name="cs_phoneno" class="phoneNo" id="cs_phoneno" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" value="<?php if (isset($this->session->userdata('student_login_data')->mobile)) {
																																																										echo $this->session->userdata('student_login_data')->mobile;
																																																									} else {
																																																										echo "";
																																																									} ?>">

												</div>
												<div class="valid-validation cs_country_code_err" id="cs_phoneno_error"></div>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group service">
											<label>Service<span class="red-text">*</span></label>
											<select class="selectpicker form-control select_removeerrmessagep" data-live-search="true" name="service_id" id="service_id">
												<option value="">Select the Service </option>
												<?php foreach ($serviceDataAll->error_message->data  as $d) { ?>
													<option value="<?php echo $d->id; ?>"><?php echo $d->enquiry_purpose_name; ?></option>
												<?php } ?>
											</select>
											<div class="valid-validation service_id_err" id="service_id_error"></div>

										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group" style="margin-bottom:35px!important">
											<label>Message<span class="red-text">*</span></label>
											<textarea placeholder="Message" rows="7" class="t-area form-control removeerrmessage" name="message" id="message" style="height:inherit;max-height:inherit"  maxlength=""></textarea>
											<div class="valid-validation message_err cl_message_err" id="cl_message_err"></div>
										</div>
									</div>
								</div>
							</div>
							<!-- End Right info -->
						</div>
					</div>

					<!-- Step-3 -->
					<div class="step-tab-panel bg-white" data-step="step3">

						<!-- Star left info -->
						<div class="left-info-sec" id="down">
						<div class="logo-section">
									<img src="<?php echo site_url() ?>resources-f/images/logo-sm.webp" alt="<?php echo COMPANY; ?>">
									<div class="font-14 font-weight-600 text-grey mt-15"><?php echo ADMIN_NAME; ?></div>
									<div class="font-18 font-weight-600 mb-15"><?php echo COMPANY; ?></div>
								</div>
								<div class="info-section">
									<p><i class="fa fa-calendar"></i><span class="display_session_datetime"></span></br>
										<span class="font-11 font-weight-500 text-grey">Date and Time according to Toronto Canada (UTC - 5)</span>
									</p>
									<p><i class="fa fa-desktop"></i><span class="display_session_type"></span></p>
									<p><i class="fa fa-clock-o"></i><span class="display_session_duration"></span></p>
									<p><i class="fa fa-credit-card"></i><span class="display_session_price"></span></p>
								</div>
						</div>
						<!-- end left info -->


						<!-- Start Right info -->
						<div class="right-info-sec" id="up">
							<div class="form-row row mb-20">
							
									<div class='col-md-6 col-sm-6 form-group required'>
										<label class='control-label'>Name on Card<span class="text-red">*</span></label>
										<input class='fstinput allow_alphabets removeerrmessage' type='text' id="card_holder_name" placeholder="Name on Card">
										<p class="validation card_holder_name_err" id="card_holder_name_err"></p>
									</div>

									<div class='col-md-6 col-sm-6 form-group required'>
										<label class='pull-left'>Card Number<span class="text-red">*</span></label>
										<input autocomplete='off' class='fstinput dob_mask_n card-number  removeerrmessage' data-inputmask="'mask': '9999 9999 9999 9999'" size='20' type='text' name="number" placeholder="xxxx xxxx xxxx xxxx" id="card_number" maxlength="20">
										<p class="validation card_number_err" id="card_number_err"></p>
									</div>
								
							
							
									<div class='col-xs-12 col-md-4 form-group cvc required'>
										<label class='control-label'>CVC<span class="text-red">*</span></label>
										<input autocomplete='off' class='fstinput card-cvc allow_numeric change_focus removeerrmessage' placeholder='ex. 311' size='4' maxlength="3" type='password' name="card_cvc" id="card_cvc">
										<p class="validation card_cvc_err" id="card_cvc_err"></p>
									</div>
									<div class='col-xs-12 col-md-4 form-group expiration required'>
										<label class='control-label'>Expiration Month<span class="text-red">*</span></label>
										<input class='fstinput card-expiry-month allow_numeric change_focus removeerrmessage' placeholder='MM' size='2' type='text' name="exp_month" maxlength="2" id="exp_month">
										<p class="validation exp_month_err" id="exp_month_err"></p>
									</div>
									<div class='col-xs-12 col-md-4 form-group expiration required'>
										<label class='control-label'>Expiration Year<span class="text-red">*</span></label>
										<input class='fstinput card-expiry-year allow_numeric removeerrmessage' placeholder='YYYY' size='4' type='text' name="exp_year" maxlength="4" id="exp_year">
										<p class="validation exp_year_err" id="exp_year_err"></p>
									</div>

								
								<!-- <div class="ftr-btm">Total To be Paid
									<span class="pull-right text-red"><?php echo $packdetail->error_message->data->currency_code; ?> <span class="final_paid_amt"><?php echo $price2; ?></span></span>
								</div> -->
								
								<input type="hidden" name="payable_amount" id="payable_amount" value="" />
								<input type="hidden" name="currency_code" id="currency_code" value="<?php echo CURRENCY;?>" />
								<input type="hidden" name="address_field_action" id="address_field_action" value="<?php echo $address_field_action; ?>" />

								
									<div class='col-md-12 error form-group hide'>
										<div class='alert-danger alert'>Error occured while making the payment.</div>
									</div>
							
							</div>
						</div>
						<!-- End Right info -->
					
					</div>
					<!-- End step-3 -->
					<div class="step-footer ft-step">
					
						<div>
							<input type="hidden" id="sessiongroupid" name="sessiongroupid">
							<input type="hidden" id="bookid" name="bookid">
							<input type="hidden" id="bookedsessiontype" name="cs_session_type">
							<input type="hidden" id="stepindexcount" name="stepindexcount">
							<span data-step-action="prev" class="step-btn pull-left text-grey font-weight-600" id="btnPrev"><i class="fa fa-chevron-left btn-circle-back mr-5"></i> Back </span>
							<span data-step-action="next" class="step-btn pull-right font-weight-600 hide" id="btnNext" >Next <i class="fa fa-chevron-right btn-circle text-white ml-5"></i></span>
							<span data-step-action="finish" class="step-btn font-bold pull-right font-weight-600" onclick="return Send_demo_counelling_post();">Pay Now <i class="fa fa-chevron-right btn-paynow text-white ml-5"></i></span>
						</div>
					</div>
				</div>

			</div>
		</form>
		<!-- End Main step section -->
	</div>
</section>
<script src="<?php echo site_url('resources-f/js/jquery-steps.js'); ?>"></script>
<script src="<?php echo site_url('resources-f/js/card-slider-min.js'); ?>"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
	
  $(".dob_mask_n:input").inputmask("9999 9999 9999 9999", {
    "placeholder": "xxxx xxxx xxxx xxxx"
  });
	window.addEventListener('load', function() {
		var glider = new Glider(document.getElementById('glider-cut'), {
			slidesToScroll: 1,
			slidesToShow: 4,
			draggable: true,
			centerMode: true,
			//dots: '#frac-dots',
			arrows: {
				prev: '.glider-prev',
				next: '.glider-next'
			}
		});
	})
</script>
<script>
var wordLen = 2000,
len; // Maximum word length
$('#message').keydown(function(event) {	
	len = $('#message').val().split(/[\s]+/);
	if (len.length > wordLen) { 
		if ( event.keyCode == 46 || event.keyCode == 8 ) {// Allow backspace and delete buttons
    } else if (event.keyCode < 48 || event.keyCode > 57 ) {//all other buttons
    	event.preventDefault();
    }
	$(".cl_message_err").text("The maximium length for message is upto "+wordLen+ " words!");			
			//return false;
	}	
	//wordsLeft = (wordLen) - len.length;
	//$('.message_err').html(wordsLeft+ ' words left');
	});


	var steps = $('#demo').steps({
		//onChange:function(){alert("change")},
		onFinish: function() {}
	});

	steps_api = steps.data('plugin_Steps');

	// $('#btnPrev').on('click', function() {
	// 	steps_api.prev();
	// });

	$('#btnNext').on('click', function() {
		//steps_api.next();
		var idx = steps_api.getStepIndex();
		$('#stepindexcount').val(idx);
		if (idx == 2) {
			if (validate_step2() == 0) {
				steps_api.setStepIndex(1);
			}

		}
		update_leftbar();

	});
</script>
<script>
	function echeck(email) {
		var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,12}\b$/i
    if (email.match(mailformat)) {
      $(".cs_email_error").text('');
      // $('.complaintBtn').prop('disabled', false);
      return true;
    } else {
      $(".cs_email_error").text("Please enter the valid email ");
      // $('#online_email' + id).focus();
      // $('.complaintBtn').prop('disabled', true);
      return false;
    }
	}
	function validate_step2() {
		var flag = 1;
		var numberes = /^[0-9-+]+$/;
		var letters = /^[A-Za-z ]+$/;
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
		var fname = $("#cs_fname").val();
		var email = $("#cs_email").val();
		var mobile = $("#cs_phoneno").val();
		var service_id = $("#service_id").val();
		var message = $("#message").val();
		if (fname.match(letters)) {
			$("#cs_fname_error").text('');
		} else if (fname == "") {
			//$("#cs_fname").focus();
			$("#cs_fname_error").text("Please enter the full name");
			flag = 0;
		} else {
			//$("#cs_fname").focus();
			$("#cs_fname_error").text("Please enter the full name");
			flag = 0;
		}
		if (email != "") {
			$("#cs_email_error").text('');
		} else {
			//$("#cs_email").focus();
			$("#cs_email_error").text('Please enter the valid email');
			flag = 0;
		}

		if (mobile.length > 10 || mobile.length < 10) {
			//$("#cs_phoneno").focus();
			$("#cs_phoneno_error").text('Please enter the valid number');
			flag = 0;
		} else {
			$("#cs_phoneno_error").text('');
		}
		if (service_id == "") {
			//$("#service_id").focus();
			$("#service_id_error").text('Please select the service');
			flag = 0;
		} else {
			$("#service_id_error").text('');
		}


		if (message == "") {
			//$("#message").focus();
			$(".cl_message_err").text('Please enter the message');
			flag = 0;
		} else {
			$(".cl_message_err").text('');
		}
		return flag;
		if (flag == 1) {
			//var form = $('#studentPostForm');
			//form.submit();
			return true;
		} else {
			return false;
		}

	}

	function Send_demo_counelling_post() {


		var flag=1;
  if($('#card_holder_name').val() == "")
  {
    $('#card_holder_name_err').text("Please enter name on card")
    flag=0
  }
  if($('#card_number').val() == "")
  {
    $('#card_number_err').text("Please enter card number")
    flag=0
  }
  if($('#card_cvc').val() == "")
  {
    $('#card_cvc_err').text("Please enter CVC")
    flag=0
  }
  if($('#exp_month').val() == "")
  {
    $('#exp_month_err').text("Please enter expiration month")
    flag=0
  }
  if($('#exp_year').val() == "")
  {
    $('#exp_year_err').text("Please enter expiration year")
    flag=0
  }
  if (flag == 1) {
			var form = $('#studentPostForm');
			form.submit();
			return true;
		} else {
			return false;
		}

/* 


		var flag = 1;
		var numberes = /^[0-9-+]+$/;
		var letters = /^[A-Za-z ]+$/;
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
		var fname = $("#cs_fname").val();
		var email = $("#cs_email").val();
		var mobile = $("#cs_phoneno").val();
		var service_id = $("#service_id").val();
		var message = $("#message").val();
		if (fname.match(letters)) {
			$("#cs_fname_error").text('');
		} else if (fname == "") {
			//$("#cs_fname").focus();
			$("#cs_fname_error").text("Please enter Full Name");
			flag = 0;
		} else {
			//$("#cs_fname").focus();
			$("#cs_fname_error").text("Please enter valid Name. Numbers not allowed!");
			flag = 0;
		}
		if (email != "") {
			$("#cs_email_error").text('');
		} else {
			//$("#cs_email").focus();
			$("#cs_email_error").text('Please enter valid Email Id');
			flag = 0;
		}

		if (mobile.length > 10 || mobile.length < 10) {
			//$("#cs_phoneno").focus();
			$("#cs_phoneno_error").text('Please enter valid Number of 10 digit');
			flag = 0;
		} else {
			$("#cs_phoneno_error").text('');
		}
		if (service_id == "") {
			//$("#service_id").focus();
			$("#service_id_error").text('Please select service');
			flag = 0;
		} else {
			$("#service_id_error").text('');
		}


		if (message == "") {
			//$("#message").focus();
			$(".cl_message_err").text('Please enter message');
			flag = 0;
		} else {
			$(".cl_message_err").text('');
		}
		if (flag == 1) {
			var form = $('#studentPostForm');
			form.submit();
			return true;
		} else {
			return false;
		} */

		
	}

	function getWordCount(wordString) {
		var words = wordString.split(" ");
		words = words.filter(function(words) {
			return words.length > 0
		}).length;
		
		if (words > 5) {
			
			$(".cl_message_err").text("Please enter max.10 words only!");			
			return false;
		} else {
			$(".cl_message_err").text("");
		}
	}

	function update_leftbar() {
		$('#payable_amount').val($(".cs_bookingdate:checked").data('sessamount'));
		$('.display_session_datetime').html($(".cs_bookingtime:checked").val() + ' ' + $(".cs_bookingdate:checked").data('sessdate'));
		$('.display_session_type').html($(".cs_bookingdate:checked").data('sesstype'));
		$('.display_session_duration').html($(".cs_bookingdate:checked").data('sessduration') + ' Minutes');
		$('.display_session_price').html($(".cs_bookingdate:checked").data('sessamount') + ' ' + '<?php echo CURRENCY; ?>');

	}

	function getFinalSession(sessionTimeSlot) {
		var sessionType = $("#bookedsessiontype").val()
		var sessionDates = $(".cs_bookingdate:checked").val();
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
				$("#sessiongroupid").val(data.counseling_sessions_group_id)
				$("#bookid").val(data.id)
				
				action_btn_handle();
			},
			beforeSend: function() {},
		});
	}

	function getSessionTimeSlot(element, sessionDates) {
		var sessionType = element.dataset.sesstype;
		$("#btnNext").addClass("hide");
		$.ajax({
			url: "<?php echo site_url('counseling/getSessionTimeSlot'); ?>",
			async: true,
			type: 'post',
			data: {
				sessionType: sessionType,
				sessionDates: sessionDates
			},
			success: function(data) {
				$("#time_slot_row").html(data);
				$("#bookedsessiontype").val(sessionType);
				action_btn_handle();
				},
			beforeSend: function() {},
		});
	}

	function action_btn_handle()
	{
		var sessionDates = $(".cs_bookingdate:checked").val();
		var cs_bookingtime = $(".cs_bookingtime:checked").val();
		if($(".cs_bookingdate:checked").length >0 && $(".cs_bookingtime:checked").length>0)
		{
			$("#btnNext").removeClass("hide");
		}
		else {
			$("#btnNext").addClass("hide");
		}
		
	}
	
	if ($(window).width() <= 768) {
		$(".text-limit").each(function(i, v) {
			let tml = $(this).text();
			let tmlem = tml.replace(/ /g, "");
			//console.log(i+":" +tml.length +":"+ tml );
			if (tmlem.length > 375) {
				$(this).html('<p class="mx-height-20 index' + i +'">' + '<p> </p>' + tml.substr(0, 375) + '...' + '</p>').append("<div class='readmore-btn rd" + i + "'>Read More</div>");
				$(".rd" + i).click(function() {
					$(this).toggleClass("active");
					$(this).parent().toggleClass("p");
					if ($(".rd" + i).hasClass("active")) {
						$(".index" + i).text(tml);
						$(this).text(" Read Less");
						//console.log(this);
					} else {
						$(".index" + i).text(tml.substr(0, 375) + '...');
						$(this).text("Read More");
						// console.log(this);
					}
				});
			}
		});
	}
	
	function validate_email(email) {
    var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,10}\b$/i
    if (email.match(mailformat)) {
      $(".online_email_error" + id).text('');
      // $('.complaintBtn').prop('disabled', false);
      return true;
    } else {
      $(".online_email_error" + id).text("Please enter the valid Email Id");
      // $('#online_email' + id).focus();
      // $('.complaintBtn').prop('disabled', true);
      return false;
    }
  }
</script>
<script>
	$(function() {

		var $stripeForm = $(".form-validation");
		$('form.form-validation').bind('submit', function(e) {
			var $stripeForm = $(".form-validation"),
				inputSelector = ['input[type=email]', 'input[type=password]',
					'input[type=text]', 'input[type=file]',
					'textarea'
				].join(', '),
				$inputs = $stripeForm.find('.required').find(inputSelector),
				$errorMessage = $stripeForm.find('div.error'),
				valid = true;
			$errorMessage.addClass('hide');
			$('.has-error').removeClass('has-error');
			$inputs.each(function(i, el) {
				var $input = $(el);
				if ($input.val() === '') {

					$input.parent().addClass('has-error');
					$errorMessage.removeClass('hide');
					e.preventDefault();
				}
			});
			if (!$stripeForm.data('cc-on-file')) {
				e.preventDefault();
				Stripe.setPublishableKey($stripeForm.data('stripe-publishable-key'));
				Stripe.createToken({
					number: $('.card-number').val(),
					cvc: $('.card-cvc').val(),
					exp_month: $('.card-expiry-month').val(),
					exp_year: $('.card-expiry-year').val()
				}, stripeResponseHandler);
			}
		});

		function stripeResponseHandler(status, res) {
			if (res.error) {
				$('.error')
					.removeClass('hide')
					.find('.alert')
					.text(res.error.message);
			} else {
				$('#make_payment').addClass('hide');
				$('#pleasewaitpayment').removeClass("hide");
				var token = res['id'];
				// alert(token)
				$stripeForm.find('input[type=text]').empty();
				$stripeForm.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
				$stripeForm.get(0).submit();

			}
		}
	});

</script>