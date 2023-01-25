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

	function echeck(str) {
		var at = "@"
		var dot = "."
		var lat = str.indexOf(at)
		var lstr = str.length
		var ldot = str.indexOf(dot)
		if (str.indexOf(at) == -1) {
			alert("Invalid E-mail ID")
			return false
		}
		if (str.indexOf(at) == -1 || str.indexOf(at) == 0 || str.indexOf(at) == lstr) {
			alert("Invalid E-mail ID")
			return false
		}
		if (str.indexOf(dot) == -1 || str.indexOf(dot) == 0 || str.indexOf(dot) == lstr) {
			alert("Invalid E-mail ID")
			return false
		}
		if (str.indexOf(at, (lat + 1)) != -1) {
			alert("Invalid E-mail ID")
			return false
		}
		if (str.substring(lat - 1, lat) == dot || str.substring(lat + 1, lat + 2) == dot) {
			alert("Invalid E-mail ID")
			return false
		}
		if (str.indexOf(dot, (lat + 2)) == -1) {
			alert("Invalid E-mail ID")
			return false
		}
		if (str.indexOf(" ") != -1) {
			alert("Invalid E-mail ID")
			return false
		}
		return true
	}
</script>
<!--Start FAQ Section-->
<section class="bg-lighter-theme">
	<div class="container ">
		<div class="counselling-booking ">
			<form method="POST" id="form_agent">
				<div class="row">
					<div class="text-center">
						<h3 class="font-20 mb-30 text-uppercase">Become An Agent</h3>
					</div>
					<!-- <div class="col-md-3 col-sm-6">
				<div class="form-group">
				<label>First Name<span class="red-text">*</span></label>
                  <input type="text" name="fname" id="fname_ba" class="fstinput  allow_alphabets length_validate" placeholder="First Name*" class="height-47" onKeyPress="return noNumbers(event)"  autocomplete="off">
                  <div class="valid-validation fname_err fname_ba_err"></div>
                </div>
				</div> -->


					<div class="col-md-3 col-sm-6">
						<div class="form-group">
							<label>First Name<span class="red-text">*</span></label>
							<input type="text" name="fname" id="fname_ba" class="fstinput removeerrmessage allow_alphabets length_validate" placeholder="" class="" onKeyPress="return noNumbers(event)" autocomplete="off">
							<div class="valid-validation fname_err fname_ba_err"></div>
						</div>
					</div>



					<div class="col-md-3 col-sm-6">
						<div class="form-group">
							<label>Last Name<span class="red-text">*</span></label>
							<input type="text" name="lname" id="lname_ba" class="fstinput removeerrmessage allow_alphabets" placeholder="" class="" onKeyPress="return noNumbers(event)" autocomplete="off">
							<div class="valid-validation lname_err lname_ba_err"></div>
						</div>
					</div>

					<div class="col-md-3 col-sm-6">
						<div class="form-group">
							<label>Email ID<span class="red-text">*</span></label>
							<input type="text" name="email" id="email_ba" class="fstinput removeerrmessage checkvalidemail" placeholder="" class="" autocomplete="off">
							<div class="valid-validation email_ba_err email_err" id="email_ba_err"></div>
						</div>
					</div>

					<div class="col-md-3 col-sm-6">
						<div class="form-group">
							<label>Country Code<span class="red-text">*</span></label>
							<select class="form-control selectpicker select_removeerrmessagep" name="country_code" id="country_code_ba" data-live-search="true">
								<option value="">Select Country Code</option>
								<?php
								$c = 'CA';
								foreach ($countryCode->error_message->data as $p) {
									$sel = "";

									if (trim($p->iso3) == $c) {
										$sel = "selected";
									}
									if ($p->country_code == $this->session->userdata('student_login_data')->country_code and $p->iso3 == $this->session->userdata('student_login_data')->country_iso3_code) {
										$sel = "selected";
									}

								?>
									<option value="<?php echo $p->country_code; ?>" <?php echo $sel; ?>><?php echo $p->country_code . '- ' . $p->iso3; ?></option>
								<?php
								}
								?>
								<!-- <option value="+91" selected data-minlimit='10' data-maxlimit='10'>+91</option>
						<option value="+1" data-minlimit='9' data-maxlimit='10'>+1</option>
						<option value="+44" data-minlimit='10' data-maxlimit='10'>+44</option>
						<option value="" data-minlimit='10' data-maxlimit='10'>+61</option>
						<option value="+61" data-minlimit='9' data-maxlimit='10' >+64</option>
						<option value="+9777" data-minlimit='10' data-maxlimit='10'>+9777</option> -->
							</select>
							<div class="valid-validation country_code_ba_err country_code_err"></div>
						</div>
					</div>

					<div class="col-md-3 col-sm-6">
						<div class="form-group">
							<label>Phone Number<span class="red-text">*</span></label>
							<input type="text" name="mobile" id="mobile_ba" class="fstinput removeerrmessage nochar allow_numeric" placeholder="" onKeyPress="return nochar(event)" autocomplete="off" maxlength="10">
							<div class="valid-validation mobile_err mobile_ba_err"></div>
						</div>
					</div>

					<div class="col-md-3 col-sm-6">
						<div class="form-group">
							<label>City<span class="red-text">*</span></label>
							<input type="text" name="city" id="city_ba" class="fstinput removeerrmessage allow_alphabets" placeholder="" autocomplete="off">
							<div class="valid-validation city_ba_err"></div>
						</div>
					</div>



					<div class="col-md-3 col-sm-6">
						<div class="form-group">
							<label>Country<span class="red-text">*</span></label>
							<input type="text" name="country" id="country_ba" class=" fstinput removeerrmessage allow_alphabets" placeholder="" autocomplete="off">
							<div class="valid-validation email_err country_ba_err"></div>
						</div>
					</div>


					<div class="col-md-3 col-sm-6">
						<div class="form-group">
							<label>Organization Name (If Applied)</label>
							<input type="text" name="org_name" id="org_name_ba" class=" fstinput removeerrmessage allow_alphabets_numberic_withsomespecialchar" placeholder="" autocomplete="off">
							<div class="valid-validation email_err org_name_ba_err"></div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label>Message<span class="red-text">*</span></label>
							<textarea name="address" id="address_ba" placeholder="" rows="5" class="t-area form-control removeerrmessage"  style="height:inherit!important;max-height:inherit!important"></textarea>
							<div class="valid-validation address_ba_err"></div>
						</div>
					</div>
					<input type="hidden" name="enquiry_id" id="enquiry_id" class="">
					<div class="col-sm-12 small otpMsg"></div>
					<div class="col-sm-12 otp_form" style="display: none;">
						<div class="form-group mb-10">
							<input name="otp" id="otp" class="form-control" type="text" placeholder="Enter OTP" aria-required="true" maxlength="4">
							<div class="text-danger small otp_err"></div>
						</div>
					</div>

					<div class="text-right col-md-12">

						<button type="submit" class="btn btn-red btn-md" id="send_btn" style="float:right">SUBMIT</button>
						<div class="col-md-4 alert alert-success alert-dismissible hide" id="success_agen">

							Your request has been sent successfully<a href="#" class="alert-link"></a>.
						</div>
						<div class="col-md-4 alert alert-danger alert-dismissible hide" id="fail_agen">

							Oops..Try again<a href="#" class="alert-link"></a>.
						</div>
						<div class="proBtn hide" style="float:right">
							<span style="font-size: 12px;color: white;"> Sending..</span>
							<i class="fa fa-spinner fa-spin mr-10 m-10 text-white"></i>
						</div>
						<a href="javascript:void(0);" class="otp_form" style="display: none;float: left;color: #d93025;" onclick="resendOTP()">Resend Verfivation Code?
						</a>
						<div class="proBtn3" style="display: none;">
							<i class="fa fa-spinner fa-spin mr-10"></i>
						</div>
						<button type="button" class="otp_form btn btn-success btn-md" data-loading-text="Please wait..." onclick="return verifyNsubmit();" style="display: none;">Verify &amp; Submit</button>
						<div class="proBtn2" style="display: none;">
							<button type="button" class="enqBtn_processin2 btn btn-red" data-loading-text="Please wait...">Please wait..</button>
							<i class="fa fa-spinner fa-spin mr-10"></i>
						</div>
						<div class="small finalMsg"></div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<!--End FAQ Section-->
<script>
	var wordLen = 2000,
len; // Maximum word length
$('#address_ba').keydown(function(event) {	
	len = $('#address_ba').val().split(/[\s]+/);
	if (len.length > wordLen) { 
		if ( event.keyCode == 46 || event.keyCode == 8 ) {// Allow backspace and delete buttons
    } else if (event.keyCode < 48 || event.keyCode > 57 ) {//all other buttons
    	event.preventDefault();
    }
	$(".address_ba_err").text("The maximium length for message is upto "+wordLen+ " words!");			
			//return false;
	}	
	//wordsLeft = (wordLen) - len.length;
	//$('.message_err').html(wordsLeft+ ' words left');
	});
	function getWordCount(wordString) {
		var words = wordString.split(" ");
		words = words.filter(function(words) {
			return words.length > 0
		}).length;
		//alert(words)
		if (words > 2000) {
			$(".address_ba_err").text("Please enter max. 2000 words only!");
			$("#send_btn").prop("disabled", true);
			return false;
		} else {
			$(".address_ba_err").text("");
			$("#send_btn").prop("disabled", false);
		}
	}
	$('#form_agent').on('submit', function(e) {
		e.preventDefault();
		var flag = 1;
		var form = $(this);
		var fname = $('#fname_ba').val();
		var lname = $('#lname_ba').val();
		var email = $('#email_ba').val();
		var country_code = $('#country_code_ba').val();
		var mobile = $('#mobile_ba').val();
		var city = $('#city_ba').val();
		var country_id = $('#country_ba').val();
		var address = $('#address_ba').val();
		var min_len = $('#country_code_ba').find('option:selected').attr('data-minlimit');
		var max_len = $('#country_code_ba').find('option:selected').attr('data-maxlimit');
		mobile = $.trim(mobile);
		mobile = mobile.replace(/^0+/, '');
		var mobilele = mobile.length;
		if (fname == "" || fname == null) {
			$(".fname_ba_err").text("Please Enter First Name");
			flag = 0;
			//return false;
		} else {
			$(".fname_ba_err").text("")
		}

		if (lname == "" || lname == null) {
			$(".lname_ba_err").text("Please Enter Last Name");
			flag = 0;

		} else {
			$(".lname_ba_err").text("")
		}

		if (email == "" || email == null) {
			$(".email_ba_err").text("Please Enter Email Id");
			flag = 0;

		} else {
			$(".email_ba_err").text("")
		}
		if (country_code == "" || country_code == null) {
			$(".country_code_err").text("Please Select Country Code");
			flag = 0;

		} else {
			$(".country_code_err").text("")
		}

		if (mobile == "") {
			$(".mobile_ba_err").text("Please Enter Phone Number");
			flag = 0;
		} else {
			$(".mobile_ba_err").text("");
		}

		if (city == "" || city == null) {
			$(".city_ba_err").text("Please Enter City");
			flag = 0;
		} else {
			$(".city_ba_err").text("");
		}

		if (country_id == "" || country_id == null) {
			$(".country_ba_err").text("Please Enter Country");
			flag = 0;
		} else {
			$(".country_ba_err").text("");
		}

		if (address == "" || address == null) {
			$(".address_ba_err").text("Please Enter Message");
			flag = 0;
		} else {
			$(".address_ba_err").text("");
		}

		if (flag == 0) {
			return false;
		}

		$('.proBtn').removeClass('hide');
		$("#send_btn_ba").prop('disabled', true);
		$.post("<?php echo site_url('become_agent/save_booking/'); ?>", form.serialize(), function(data) {
			var dt = $.trim(data);
			if (dt == 1) {
				$('#success_agen').removeClass('hide');
				$('#fail_agen').addClass('hide');
				$('#form_agent')[0].reset();
				$('.proBtn').addClass('hide');
				$("#send_btn").prop('disabled', false);
			} else {
				//alert("Ohh..Verfivation code not sent! please try again.");
				$('#success_agen').addClass('hide');
				$('#fail_agen').removeClass('hide');
				$('#form_agent')[0].reset();
				$('.proBtn').addClass('hide');
				$("#send_btn").prop('disabled', false);
				//$("#first_button").prop('disabled', false);
			}
		});
		//this.submit();

	});
</script>