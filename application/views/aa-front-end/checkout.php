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
  if($packdetail->error_message->data->programe_name !='None') {
  $programe_name = ' | ' . $packdetail->error_message->data->programe_name;
  }
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
?>
<section class="bg-lighter checkout">
  <div class="container">
    <div class="section-title mb-10">
      <h2 class="mb-20 text-uppercase font-weight-400 font-28 mt-0">checkout</h2>
    </div>
    <div class="rw-flex">
      <!-- Start Checkout Details-->
      <div class="main-box">
        <form method="post" id="formbookingpack" >
          <div class="check-details">
            <div class="card-info">
              <h2><?php echo $tilte; ?> </h2>
              <ul>
                <li><?php echo $test_module_name . $programe_name; ?></li>
                
                  <li>MODULE:<span style="margin-left:5px"><?php echo $category_name; ?></span></li>
                  <?php if($packdetail->error_message->data->course_timing !=""){ ?>
                  <li>COURSE TYPE:<span style="margin-left:5px"><?php echo $packdetail->error_message->data->course_timing; ?></span></li>
                  <?php }?>                  
                  <li>DURATION:<span style="margin-left:5px"><?php echo $packdetail->error_message->data->duration; ?> <?php echo $packdetail->error_message->data->duration_type; ?> </span></li>
                
                <li>PRICE:<?php
                            if ($flag == 1) { ?><strike style="margin-left:5px"><?php echo $packdetail->error_message->data->currency_code; ?> <?php echo $price1; ?></strike><?php } ?>
               <?php echo $packdetail->error_message->data->currency_code; ?> <?php echo $price2; ?>
                </li>
              </ul>
            </div>

             <input type="hidden" name="wallet_amount" id="wallet_amount" value="0" />          

            <div class="check-info font-weight-600" id="summerysection">
              <div>Original Price <span class="pull-right"><?php echo $packdetail->error_message->data->currency_code; ?> <?php echo $price2; ?></span></div>
              <!-- <div class="hide">General Discount <span class="pull-right">(-) INR 2,000</span></div> -->
              <div class="hide" id="promocode_label">Promotion Code
                <span title="Removed Promo Code" id="removePromoCode" class="cursor_pointer"><i class="fa fa-times-circle text-red size-11" aria-hidden="true"></i></span><span class="pull-right">(-) <?php echo $packdetail->error_message->data->currency_code; ?> <span id="promocode_label_val"></span></span>
              </div>
              <!--              <div>Promotion Code <span class="ml-5 font-12">10% Off</span> <span class="pull-right">(-) INR 1,000</span></div>-->
              <div class="d-line"></div>
              <!--<div>Final Price <span class="pull-right">Rs. <span class="final_paid_amt"><?php echo $price2; ?></span></span></div>-->
              <div class="hide">Applied From Wallet <span class="pull-right">(-) INR 5,000</span></div>
            </div>
            <div class="ftr-btm">Total to be paid
              <span class="pull-right text-red"><?php echo $packdetail->error_message->data->currency_code; ?> <span class="final_paid_amt"><?php echo $price2; ?></span></span>
            </div>
            <input type="hidden" name="original_amount" id="original_amount" value="<?php echo $price2; ?>" />
            <input type="hidden" name="promocode_applied_id" id="promocode_applied_id" value="0" />
            <input type="hidden" name="bulk_id" id="bulk_id" value="0" />
            <input type="hidden" value="0" id="promocode" name="promocode" />
            <input type="hidden" name="promocode_amount" id="promocode_amount" value="0" />
            <input type="hidden" name="wallet_amount_used" id="wallet_amount_used" value="0" />
            <input type="hidden" name="wallet_amount" id="wallet_amount" value="0" />
            <input type="hidden" name="payable_amount" id="payable_amount" value="<?php echo $price2; ?>" />
            <input type="hidden" name="center_id" id="center_id" value="<?php echo $center_id; ?>" />
            <input type="hidden" name="currency_code" id="currency_code" value="<?php echo $packdetail->error_message->data->currency_code; ?>" />
            <input type="hidden" name="duration_type" id="duration_type" value="<?php echo $packdetail->error_message->data->duration_type; ?>" />
            <input type="hidden" name="duration" id="duration" value="<?php echo $packdetail->error_message->data->duration; ?>" />
            <div class="form-checkbox mt-30">
              <input type="checkbox" id="javascript" class="read_agree">
              <label for="javascript" class="font-weight-600">I have read and agree to the terms and conditions </label>
              <div class="valid-validation text-yellow read_agree_mg"></div>
            </div>
            <!-- <div class="terms-info text-justify mb-20">Your personal data will be used to precess your order, support your experience throughout this website and for other purposes described in our privacy policy.</div> -->
            <div class="mt-20">
            <!-- <a href="<?php echo site_url()?>stripePaymentController" type="button" class="btn mp-btn btn-lg btn-block"   >Stripe Checkout</a> -->
            <button type="button" class="btn mp-btn-disable btn-lg btn-block hide" id="pleasewaitpayment" disabled>Please Wait...</button>
              <button type="button" class="btn mp-btn btn-lg btn-block" id="make_payment" disabled onclick="return post_pack_booking();">Make Payment</button>
            </div>
          </div>
        </form>
      </div>
      <?php /*?>
      <div class="promotion">
        <div class="modal fade" id="modal-promotion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close text-white"></i></button>
                <div class="promo-box">
                  <div class="modal-scroll scroll-style">
                    <div class="title">Apply Promotions Code</div>
                    <div class="info">
                      <?php $bid = 0; ?>
                      <div class="d-flex mt-5"> <span>
                          <input type="text" class=" promocode_span promocode_span<?php echo $bid; ?> form-control" placeholder="Enter Promotion Code" id="entered_promocode">
                        </span>
                        <span class="pull-right mt-5 ml-10">
                          <span class="ml-5 hide promocode_button_applied  promocode_button_applied<?php echo $bid; ?>"><i class="fa fa-check text-green"></i></span>
                          <span class="ml-5 promocode_button_apply promocode_button_apply<?php echo $bid; ?>">
                            <button type="button" class="btn btn-apply apply_bulk_promocode" data-id="<?php echo $bid; ?>">APPLY</button>
                          </span>
                        </span>
                      </div>
                      <p class="font-weight-600 font-12 mt-10  promocode_msg promocode_msg<?php echo $bid; ?>" id="bulkmsg"></p>
                    </div>
                    <?php if (!empty($promocode->error_message->general_promocode) or !empty($promocode->error_message->special_promocode)) { ?>
                      <h2>Available Promotions Codes</h2>
                    <?php } ?>
                    <?php
                    foreach ($promocode->error_message->general_promocode as $p) {
                      if ($p->discount_type == "Percentage") {
                        $text1 = "Get " . $p->max_discount . '%' . " OFF up to INR " . $p->not_exceeding;
                      } else {
                        $text1 = "Get Rs." . $p->max_discount . ' OFF';
                      }
                    ?>
                      <div class="info mb-20">
                        <p class="font-weight-600"><?php echo $text1; ?></p>
                        <p>Valid on purchase more than equal to INR <?php echo $p->min_purchase_value; ?></p>
                        <p class="date font-12"> Valid till <?php echo $p->end_date . ' ' . $p->end_time; ?></p>
                        <div class="mt-20 clearfix">
                          <span class="coupon promocode_span promocode_span<?php echo $p->id; ?>"><?php echo $p->discount_code ?> </span>
                          <span class="ml-5 hide promocode_button_applied  promocode_button_applied<?php echo $p->id; ?>"><i class="fa fa-check text-green"></i></span>
                          <span class="ml-5 promocode_button_apply promocode_button_apply<?php echo $p->id; ?>">
                            <input type="text" value="<?php echo $p->discount_code ?>" class="inputpromocode<?php echo $p->id; ?>" id="inputpromocode<?php echo $p->id; ?>" name="inputpromocode" />
                            <button type="button" class="btn btn-apply apply_promocode" data-id="<?php echo $p->id; ?>">APPLY</button>
                            <p class="font-weight-600 font-12 mt-10 promocode_msg promocode_msg<?php echo $p->id; ?>"></p>
                          </span>
                        </div>
                      </div>
                    <?php } ?>
                    <?php foreach ($promocode->error_message->special_promocode as $p) {
                      if ($p->discount_type == "Percentage") {
                        $text1 = "Get " . $p->max_discount . '%' . " OFF up to INR " . $p->not_exceeding;
                      } else {
                        $text1 = "Get Rs." . $p->max_discount . ' OFF';
                      }
                    ?>
                      <div class="info mb-20">
                        <p class="font-weight-600"><?php echo $text1; ?></p>
                        <p>Valid on purchase more than equal to INR <?php echo $p->min_purchase_value; ?></p>
                        <p class="date font-12"> Valid till <?php echo $p->end_date . ' ' . $p->end_time; ?></p>
                        <div class="mt-20 clearfix">
                          <span class="coupon promocode_span promocode_span<?php echo $p->id; ?>"><?php echo $p->discount_code ?> </span>
                          <span class="ml-5 hide promocode_button_applied  promocode_button_applied<?php echo $p->id; ?>"><i class="fa fa-check text-green"></i></span>
                          <span class="ml-5 promocode_button_apply promocode_button_apply<?php echo $p->id; ?>">
                            <button type="button" class="btn btn-apply apply_promocode" data-id="<?php echo $p->id; ?>">APPLY</button>
                            <p class="font-weight-600 font-12 mt-10 promocode_msg promocode_msg<?php echo $p->id; ?>"></p>
                          </span>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><?php */?>
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
<script>
  $(document).ready(function() {
    $("#entered_promocode").keypress(function() {
      //  alert('')
      $('#bulkmsg').html('');
    });
  });
  $(".apply_bulk_promocode").click(function() {
    var promocodeid = $(this).data('id');
    $('#bulk_id').val(0);
    var entered_promocode = $('#entered_promocode').val();
    if (entered_promocode == "") {
      $('.promocode_msg' + promocodeid).addClass('text-red');
      $('.promocode_msg' + promocodeid).html("Please Enter Promo code");
      //$('#entered_promocode').focus();
      return false;
    }
    $('.promocode_span').removeClass('text-green');
    $('.promocode_span').removeClass('coupon-active');
    $('.promocode_button_applied').addClass('hide');
    $('.promocode_button_apply').removeClass('hide');
    $('.promocode_msg').html('');
    $.ajax({
      url: "<?php echo site_url('booking/apply_bulk_promocode'); ?>",
      type: 'post',
      data: {
        entered_promocode: entered_promocode
      },
      success: function(response) {
        if (response.status == 1) {
          $('.promocode_msg' + promocodeid).removeClass('text-red');
          $('.promocode_msg' + promocodeid).addClass('text-green');
          $('.promocode_msg' + promocodeid).html(response.msg);
          $('#promocode_amount').val(response.discount);
          $('#promocode_applied_id').val(response.promoCodeId)
          $('#bulk_id').val(response.bulk_id)
          $('.promocode_span' + promocodeid).addClass('coupon');
          $('.promocode_span' + promocodeid).addClass('coupon-active');
          $('.promocode_button_applied' + promocodeid).removeClass('hide');
          $('.promocode_button_apply' + promocodeid).addClass('hide');
          $('#promocode_label').removeClass('hide')
          $('#promocode_label_val').html(response.discount)
          $('#promocode').val(entered_promocode)
        } else {
          $('.promocode_msg' + promocodeid).addClass('text-red');
          $('.promocode_msg' + promocodeid).html(response.msg);
        }
        calculate_payableAmount()
        setTimeout(function() {
          $('#modal-promotion').modal('hide');
        }, 2000);
        //alert(response.msg)   
        // alert('.promocode_msg'+promocodeid)
      },
      beforeSend: function() {
        $('#summerysection').addClass('opacity-5');
      },
    });
  });
  $(".apply_promocode").click(function() {
    var promocodeid = $(this).data('id');
    $('.promocode_span').removeClass('text-green');
    $('.promocode_span').removeClass('coupon-active');
    $('.promocode_button_applied').addClass('hide');
    $('.promocode_button_apply').removeClass('hide');
    $('.promocode_msg').html('');
    $('#bulk_id').val(0);
    $('#promocode').val(0);
    $.ajax({
      url: "<?php echo site_url('booking/apply_promocode'); ?>",
      type: 'post',
      data: {
        promocodeid: promocodeid
      },
      success: function(response) {
        if (response.status == 1) {
          $('.promocode_msg' + promocodeid).addClass('text-green');
          $('.promocode_msg' + promocodeid).html(response.msg);
          $('#promocode_amount').val(response.discount);
          $('#promocode_applied_id').val(promocodeid)
          $('.promocode_span' + promocodeid).addClass('coupon');
          $('.promocode_span' + promocodeid).addClass('coupon-active');
          $('.promocode_button_applied' + promocodeid).removeClass('hide');
          $('.promocode_button_apply' + promocodeid).addClass('hide');
          $('#promocode_label').removeClass('hide')
          $('#promocode_label_val').html(response.discount)
          $('#promocode').val($('.inputpromocode' + promocodeid).val())
        } else {
          $('.promocode_msg' + promocodeid).addClass('text-red');
          $('.promocode_msg' + promocodeid).html(response.msg);
        }
        calculate_payableAmount()
        setTimeout(function() {
          $('#modal-promotion').modal('hide');
        }, 2000);
        //alert(response.msg)   
        // alert('.promocode_msg'+promocodeid)
      },
      beforeSend: function() {
        $('#summerysection').addClass('opacity-5');
      },
    });
  });
  $("#wa_checkbox").click(function() {
    $('#summerysection').addClass('opacity-5');
    if ($(this).is(":checked")) {
      $('#wallet_amount_used').val(1);
    } else {
      $('#wallet_amount_used').val(0);
    }
    calculate_payableAmount()
  });
  $("#removePromoCode").click(function() {
    var promocode_applied_id = $('#promocode_applied_id').val()
    if ($('#bulk_id').val() != 0) {
      promocode_applied_id = 0;
    }
    $('#summerysection').addClass('opacity-5');
    // return false;
    $('#promocode_amount').val(0);
    $('#promocode_label').addClass('hide')
    $('#promocode_label_val').html("")
    $('.promocode_span' + promocode_applied_id).addClass('coupon');
    $('.promocode_span' + promocode_applied_id).removeClass('coupon-active');
    $('.promocode_button_applied' + promocode_applied_id).addClass('hide');
    $('.promocode_button_apply' + promocode_applied_id).removeClass('hide');
    $('.promocode_msg' + promocode_applied_id).html("");
    $('#entered_promocode').val('');
    $('#bulk_id').val(0)
    $('#promocode_applied_id').val(0)
    $('#promocode').val(0)
    calculate_payableAmount()
  });

  function calculate_payableAmount() {
    var original_amount = $('#original_amount').val();
    var promocode_amount = $('#promocode_amount').val();
    var wallet_amount_used = $('#wallet_amount_used').val();
    var wallet_amount = 0;
    if (wallet_amount_used == 1) {
      var wallet_amount = $('#wallet_amount').val();
      wallet_amount = parseInt(wallet_amount);
    }
    var payamount = parseInt(original_amount) - parseInt(promocode_amount) - parseInt(wallet_amount);
    if (payamount > 0) {
      $('#payable_amount').val(payamount)
      $('.final_paid_amt').html(payamount)
    } else {
      $('#payable_amount').val(0)
      $('.final_paid_amt').html('0.00')
    }
    setTimeout(function() {
      $('#summerysection').removeClass('opacity-5');
    }, 800);
  }
  $(".read_agree").click(function() {
    if ($(this).is(":checked")) {
      $('#make_payment').prop('disabled', false);
    } else {
      $('#make_payment').prop('disabled', true);
    }
  });

  function post_pack_booking() {
    if ($('.read_agree').is(":checked")) {
      var form = $("#formbookingpack");
     // form.submit();
      
      $.ajax({
        url: "<?php echo site_url('booking/post_pack_booking'); ?>",
        type: 'post',
        data: form.serialize(),
        success: function(response) {
          //alert(response.status)
          if (response.status == 1) {
            //$('#checkout_popup_modal').modal('show');
            //$('#checkout_success_msg').removeClass('hide');
           // $('#checkout_fail_msg').addClass('hide');
            // $('#checkout_success_msg').html(response.msg);   
            setTimeout(function() {
              window.location.href = "<?php echo site_url('booking/make_payment'); ?>";
            }, 2000);
          } else if (response.status == 2) {
            $('#checkout_popup_modal').modal('show');
            $('#checkout_success_msg').removeClass('hide');
            $('#checkout_fail_msg').addClass('hide');
            // $('#checkout_success_msg').html(response.msg);   
            setTimeout(function() {
              window.location.href = "<?php echo site_url('my_login/'); ?>";
            }, 5000);
          } else {
            $('#checkout_popup_modal').modal('show');
            $('#checkout_success_msg').addClass('hide');
            $('#checkout_fail_msg').removeClass('hide');
            //$('#checkout_fail_msg').html(response.msg); 
          }
        },
        beforeSend: function() {
          $('#make_payment').addClass('hide');
          $('#pleasewaitpayment').removeClass("hide");
          
          //$('.complaintBtnDiv_pro').show(); 
          //$('#reg_button').prop('disabled', true);
        }
      });
      return true;
    } else {
      $('.read_agree_mg').html('Please check Term and condition')
      return false;
    }
  }
</script>