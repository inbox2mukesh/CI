<?php
$packdetail->error_message->data->package_name;
if ($_SESSION['book_pack_type'] == "reality test") {
  $tilte = $packdetail->error_message->data->title;
  $test_module_name = $packdetail->error_message->data->test_module_name;
  $programe_name = "";
} else {
  $tilte = $packdetail->error_message->data->package_name;
  $test_module_name = $packdetail->error_message->data->test_module_name;
  if ($test_module_name == IELTS_CD or $test_module_name == IELTS) {
  } else {
    $programe_name = '';
  }
  $programe_name = ' | ' . $packdetail->error_message->data->programe_name;
}
$center_id = $packdetail->error_message->data->center_id;
$category_name = $packdetail->error_message->data->category_name;
if ($category_name) {
  $category_name = $category_name;
} else {
  $category_name = 'All (LRWS)';
}
if ($packdetail->error_message->data->amount == $packdetail->error_message->data->discounted_amount) {
  $price1 = $packdetail->error_message->data->amount;
  $price2 = $packdetail->error_message->data->amount;
  $flag = 0;
  $amount = '<span> Price <ins><span class="font-weight-400 price"> ' . $packdetail->error_message->data->amount . '</span></ins></span>';
} elseif ($packdetail->error_message->data->discounted_amount == "") {
  $price1 = $packdetail->error_message->data->amount;
  $price2 = $packdetail->error_message->data->amount;
  $flag = 0;
  $amount = '<span> Price <ins><span class="font-weight-400 price"> ' . $packdetail->error_message->data->amount . '</span></ins></span>';
} elseif ($packdetail->error_message->data->amount > $packdetail->error_message->data->discounted_amount) {
  $flag = 1;
  $price1 = $packdetail->error_message->data->amount;
  $price2 = $packdetail->error_message->data->discounted_amount;
  $amount = $packdetail->error_message->data->amount;
} else {
  $flag = 0;
}

$cgst_prcnt = $packdetail->error_message->cgst_tax_per;
$sgst_prcnt = $packdetail->error_message->sgst_tax_per;
$cgst_tax = number_format(($price2 * $cgst_prcnt)/100,2);
$sgst_tax = number_format(($price2 * $sgst_prcnt)/100,2);
$amt_to_pay = $price2 + $cgst_tax + $sgst_tax;
?>
<section class="bg-lighter checkout">
  <div class="container">
    <div class="section-title mb-10">
      <h2 class="mb-20 text-uppercase font-weight-400 font-28 mt-0">checkout payment</h2>
    </div>
    <div class="rw-flex">
      <!-- Start Checkout Details-->
      <div class="main-box">
        <form action="<?php echo base_url('handlePayment');?>" method="post" class="form-validation" data-cc-on-file="false" data-stripe-publishable-key="<?php echo $this->config->item('stripe_key') ?>" id="payment-form" >
          <div class="check-details">           
			<div class='row'>
								<div class='col-xs-12 form-group required'>
									<label class='control-label'>Name on Card<span class="text-red">*</span></label>
									<input class='fstinput allow_alphabets removeerrmessage' type='text' id="card_holder_name">
                  <p class="validation card_holder_name_err" id="card_holder_name_err"></p>
								</div>
							</div>
							<div class='row'>
								<div class='col-xs-12 form-group card required'>
									<label class='pull-left'>Card Number<span class="text-red">*</span></label>
									<input autocomplete='off' class='fstinput dob_mask_n card-number  removeerrmessage' data-inputmask="'mask': '9999 9999 9999 9999'" size='20' type='text' name="number" placeholder="xxxx xxxx xxxx xxxx" id="card_number" maxlength="20">
                  <p class="validation card_number_err" id="card_number_err"></p>
								</div>
							</div>
							<div class='row'>
								<div class='col-xs-12 col-md-4 form-group cvc required'>
									<label class='control-label'>CVC<span class="text-red">*</span></label>
									<input autocomplete='off' class='fstinput card-cvc allow_numeric change_focus removeerrmessage' placeholder='ex. 311'
										size='4' maxlength="3" type='password'  name="card_cvc" id="card_cvc">
                    <p class="validation card_cvc_err" id="card_cvc_err"></p>
								</div>
								<div class='col-xs-12 col-md-4 form-group expiration required'>
									<label class='control-label'>Expiration Month<span class="text-red">*</span></label>
									<input class='fstinput card-expiry-month allow_numeric change_focus removeerrmessage' placeholder='MM' size='2' type='text'  name="exp_month" maxlength="2" id="exp_month">
                  <p class="validation exp_month_err" id="exp_month_err"></p>
								</div>
								<div class='col-xs-12 col-md-4 form-group expiration required'>
									<label class='control-label'>Expiration Year<span class="text-red">*</span></label>
									<input class='fstinput card-expiry-year allow_numeric removeerrmessage' placeholder='YYYY' size='4'
										type='text'   name="exp_year" maxlength="4" id="exp_year" >
                    <p class="validation exp_year_err" id="exp_year_err"></p>
								</div>
					<?php 
          if($address_field_action == 1)
          {

            print_r($this->session->userdata('student_login_data')->country_namefull);
          ?>
           
                <h4>Address Detail</h4>
                <div class='col-xs-12 col-md-6 form-group'>
									<label class='control-label'>Country <span class="text-red">*</span></label>
                  <select class="selectpicker form-control select_removeerrmessagep countrylist" data-live-search="true" name="country" id="country" >
                  <option value="">Choose Country</option>
                  <?php
                  foreach ($allcountry->error_message->data as $pallcountry) {
                    $selected = ($pallcountry->name ==$this->session->userdata('student_login_data')->country_namefull) ? ' selected="selected"' : "";
                  echo '<option value="' . $pallcountry->country_id . '" ' . $selected . '>' . $pallcountry->name . '</option>';
                  }
                  ?>
                  </select>
                  <p class="validation country_err" id="country_err"></p>
								</div>
                <div class='col-xs-12 col-md-6 form-group '>
									<label class='control-label'>State<span class="text-red">*</span></label>
                  <select class="selectpicker form-control select_removeerrmessagep statelist" data-live-search="true" name="state" id="state" >
                  <option value="">Choose State</option>   
                  <?php 
                foreach ($allstate->error_message->data as $p)
                {
                  $selected = ($p->state_id == $this->session->userdata('student_login_data')->state_id) ? ' selected="selected"' : "";
                ?>
                 <option value="<?php echo $p->state_id?>" <?php echo $selected;?>><?php echo $p->state_name?></option>
              <?php }?>              
                  </select>
                  <p class="validation state_err" id="state_err"></p>
								</div>
                <div class='col-xs-12 col-md-6 form-group'>
									<label class='control-label'>City<span class="text-red">*</span></label>
                  <select class="selectpicker form-control select_removeerrmessagep citylist" data-live-search="true" name="city" id="city" >
                  <option value="">Choose City</option>       
                  <?php 
                foreach ($allcity->error_message->data as $p)
                {
                  $selected = ($p->city_id == $this->session->userdata('student_login_data')->city_id) ? ' selected="selected"' : "";
                ?>
                <option value="<?php echo $p->city_id?>" <?php echo $selected;?>><?php echo $p->city_name?></option>
                <?php }?>          
                  </select>
                  <p class="validation city_err" id="city_err"></p>
								</div>
                <div class='col-xs-12 col-md-6 form-group '>
									<label class='control-label'>Zip Code<span class="text-red">*</span></label>
									<input autocomplete='off' class='fstinput removeerrmessage' placeholder='Zip Code'
										maxlength="10" type='text'  name="zip_code" id="zip_code" value="<?php echo ($this->session->userdata('student_login_data')->zip_code != '') ? $this->session->userdata('student_login_data')->zip_code : '';?>">
                    <p class="validation zip_code_err" id="zip_code_err"></p>
								</div>
                <div class='col-xs-12 col-md-12 form-group'>
									<label class='control-label'>Address<span class="text-red">*</span></label>
                  <textarea class="form-control removeerrmessage" rows="3" name="residential_address" id="residential_address"><?php echo $this->session->userdata('student_login_data')->residential_address;  ?></textarea>
                    <p class="validation residential_address_err" id="residential_address_err"></p>
								</div>
              <?php  }?>
                </div>
              
            <div class="ftr-btm">Total To be Paid
              <span class="pull-right text-red"><?php echo $packdetail->error_message->data->currency_code; ?> <span class="final_paid_amt"><?php echo $amt_to_pay; ?></span></span>
            </div>
            <input type="hidden" name="payable_amount" id="payable_amount" value="<?php echo $amt_to_pay*100; ?>" />
           
            
            <input type="hidden" name="original_amount" id="original_amount" value="<?php echo $price2*100; ?>" />
           
            <input type="hidden" name="currency_code" id="currency_code" value="<?php echo $packdetail->error_message->data->currency_code; ?>" />

            <input type="hidden" name="address_field_action" id="address_field_action" value="<?php echo $address_field_action; ?>" />
           
            
			<div class='row mt-15'>
								<div class='col-md-12 error form-group hide'>
									<div class='alert-danger alert'>Error occured while making the payment.</div>
								</div>
							</div>
            <div class="mt-10">
            <!-- <a href="<?php echo site_url()?>stripePaymentController" type="button" class="btn mp-btn btn-lg btn-block"   >Stripe Checkout</a> -->
            <button type="button" class="btn mp-btn-disable btn-lg btn-block hide" id="pleasewaitpayment" disabled>Please Wait...</button>
              <button type="submit" class="btn mp-btn btn-lg btn-block" id="make_payment"  onclick="return check_validation();">Make Payment</button>
            </div>
          </div>
        </form>
      </div> 

    
      <!-- End  Checkout Details-->
      <!-- Start Terms and Condition-->
      <div class="terms-box">
        <h2><?php echo $term_cond->error_message->data->content_title; ?></h2>
        <div class="check-scroll" id="scroll-style">
          <?php
          echo $term_cond->error_message->data->content_desc;
          ?>
        </div>
      </div>
      <!--End Terms and Condition-->
    </div>
  </div>
  <div class="checkout_popup">
    <div class="modal fade" id="checkout_popup_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-body">
            <div class="reg-otp-info text-center">
              <div class="hide font-15" id="checkout_success_msg" role="alert" style="    padding: 0px;">
                <div class="success-box">
                  <h2>Booking Done Successfully</h2>
                  <p>Thankyou for Booking with us. </p>
                  <div class="font-14">More details have been sent to your email.</div>
                  <!--End Login Popup-->
                </div>
              </div>
              <div class="hide font-15" id="checkout_fail_msg" role="alert">
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
  </div>
</section>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
  $(".dob_mask_n:input").inputmask("9999 9999 9999 9999", {
    "placeholder": "xxxx xxxx xxxx xxxx"
  });

function check_validation()
{
  var flag=1;
  if($('#card_holder_name').val() == "")
  {
    $('#card_holder_name_err').text("Please Enter Name on Card")
    flag=0
  }
  if($('#card_number').val() == "")
  {
    $('#card_number_err').text("Please Enter Card Number")
    flag=0
  }
  if($('#card_cvc').val() == "")
  {
    $('#card_cvc_err').text("Please Enter CVC")
    flag=0
  }
  if($('#exp_month').val() == "")
  {
    $('#exp_month_err').text("Please Enter Expiration Month")
    flag=0
  }
  if($('#exp_year').val() == "")
  {
    $('#exp_year_err').text("Please Enter Expiration Year")
    flag=0
  }
  
    var country = $("#country").val();
    var state = $("#state").val();
    var city = $("#city").val();
    var zip_code = $("#zip_code").val();
    var residential_address = $("#residential_address").val();
    if (country == "") {    
     $(".country_err").text('Please enter the Country');
      flag=0;
    } else {
      $(".country_err").text('');
    } 

    if (state == "") {    
     $(".state_err").text('Please enter the State');
      flag=0;
    } else {
      $(".state_err").text('');
    } 

    if (city == "") {    
     $(".city_err").text('Please enter the City');
      flag=0;
    } else {
      $(".city_err").text('');
    } 
    if (zip_code == "") {    
     $(".zip_code_err").text('Please enter the Zip code');
      flag=0;
    } else {
      $(".zip_code_err").text('');
    } 
    if (residential_address == "") {    
     $(".residential_address_err").text('Please enter the Address');
      flag=0;
    } else {
      $(".residential_address_err").text('');
    } 


  //alert(flag)
  if(flag == 1)
  {
    return true;
  }
  else {
    return false;
  }
 
  
  
}
	$(function () {
  
		var $stripeForm = $(".form-validation");
		$('form.form-validation').bind('submit', function (e) {
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
			$inputs.each(function (i, el) {
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