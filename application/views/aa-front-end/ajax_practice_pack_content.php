<script src="<?php echo site_url('resources-f/js/jquery-steps.js'); ?>"></script>
<script src="<?php echo site_url('resources-f/'); ?>js/date-mask.js"></script>
<?php
//echo "<pre>";
//print_r($OnlinePack);
if (!empty($OnlinePack->error_message->data)) {
  foreach ($OnlinePack->error_message->data as $p) {
    $package_id = $p->package_id;
    $test_module_id = $p->test_module_id;
    $programe_id = $p->programe_id;
    $center_id = $p->center_id;
    $currency_code = $p->currency_code;
    $img = site_url('resources-f/images/courses/course-1.jpg');
    $test_module_name = $p->test_module_name;
    if(trim($p->programe_name) == "General Training")
    {
      $programe_name_title="GT";
    }
    else if (trim($p->programe_name) == "None") {
      $programe_name_title = "";
    }
    else {
      $programe_name_title = $p->programe_name;
    }
    if($programe_name_title !="")
    {
      if ($test_module_name == IELTS_CD or $test_module_name == IELTS)  {
        $programe_name = ' | ' . $programe_name_title;
      } else {
        $programe_name = ' | ' . $programe_name_title;
      }

    }
    else{
      $programe_name="";
    }
    $package_name = $p->package_name;
    $package_desc = $p->package_desc;
    $category_name = $p->category_name;
    if ($category_name) {
      $category_name = $category_name;
    } else {
      $category_name = 'All (LRWS)';
    }
    if ($p->amount == $p->discounted_amount) {
      $price1 = $p->amount;
      $price2 = $p->amount;
      $flag = 0;
      $amount = '<span> Price <ins><span class="font-weight-400 price"> ' . $p->amount . '</span></ins></span>';
    } elseif ($p->amount > $p->discounted_amount) {
      $flag = 1;
      $price1 = $p->amount;
      $price2 = $p->discounted_amount;
      $amount = '<span> Price: <ins><span class="font-weight-400 price"><strike>' . $p->amount . '</strike></span></ins></span><br/>
                <span> Offer Price: <ins><span class="font-weight-400 price">' . $p->discounted_amount . '</span></ins></span>';
    } else {
      $flag = 0;
    }
?>

<div class="col-md-3 col-sm-6 mt-10">
<a href="#" data-toggle="modal" data-target="#onlinecoursemodel<?php echo $p->package_id ?>" data-keyboard="false" data-backdrop="static"  class="btn_reset">
        <div class="service-block bg-white mb-20">
      
            <div class="thumb"> <img alt="featured project" src="<?php echo site_url(); ?>uploads/package_file/<?php echo $p->image; ?>" class="img-responsive img-fullwidth">
             <span class="title"><?php echo $test_module_name . $programe_name; ?></span> </div>
            <div class="content clearfix font-14 font-weight-500">
              <div class="disc">
                <h3><?php echo $package_name; ?></h3>
                <p><span class="font-weight-600">Module:</span> <span><?php echo $category_name; ?></span> </p>
                <p><span class="font-weight-600">Duration:</span> <?php echo $p->duration; ?> <?php echo $p->duration_type; ?></p>
                <?php
                if ($flag == 1) { ?>
                  <p><span class="font-weight-600">Price:</span> <strike><?php echo $p->currency_code; ?>&nbsp;<?php echo $price1; ?></strike></p>
                <?php   }  ?>
                <!-- <p><span class="font-weight-600">Batch:</span> <?php //echo $p->center_name;
                                                                    ?></p> -->
              </div>
              <div class="ftr-btm text-center"> <span class="more-info pull-left">More Info</span> <span class="purchase font-weight-600 pull-right">Buy Now: <span class="text-red"><?php echo $p->currency_code; ?> <?php echo $price2; ?></span> 
              </div>
            </div>
        
			
        </div>
                </a>
      </div>
   
    <!--END GRID ITEM -->
    <div class="modal fade scroll-select-picker" id="onlinecoursemodel<?php echo $p->package_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close red-text font-16"></i></button>
                  <div class="w-title"><?php echo $package_name; ?></div>
                  <div class="w-subInfo">
                    <ul>
                      <li class="text-uppercase"><?php echo $test_module_name . $programe_name; ?></li>
                      <li><span class="text-uppercase">Module:</span> <?php echo $category_name; ?></li>
                      <!-- <li class="mob-break"></li> -->
                      <li><span class="text-uppercase">Duration:</span> <?php echo $p->duration; ?> <?php echo $p->duration_type; ?></li>
                    </ul>
                  </div>
                </div>
                <form action="#" method="post" enctype="multipart/form-data" id="onlinecourseform<?php echo $package_id ?>" >
                <input type="hidden" value="<?php echo $package_id; ?>" name="package_id" id="package_id" />
          <input type="hidden" value="practice" name="pack_type" id="pack_type" />
          <input type="hidden" value="<?php echo $test_module_id; ?>" name="test_module_id" id="test_module_id_<?php echo $p->package_id ?>" />
          <input type="hidden" value="<?php echo $programe_id; ?>" name="programe_id" id="programe_id_<?php echo $p->package_id ?>" />
          <input type="hidden" value="<?php echo $center_id; ?>" name="center_id" id="center_id_<?php echo $p->package_id ?>" />
          <input type="hidden" value="<?php echo $country_id; ?>" name="pack_country_id" id="pack_country_id<?php echo $p->package_id ?>" />
          <input type="hidden" value="<?php echo $p->duration_type; ?>" name="duration_type" id="pack_country_id<?php echo $p->package_id ?>" />
                <div class="step-app step" id="step">
                  <div class="step-content">
                    <div class="step-tab-panel" data-step="step1_<?php echo $p->package_id ?>">
                      <div class="PP-box-info">
                        <div class="pp-scroll">
                          <div class="pp-content">
                            <?php echo $package_desc; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="step-tab-panel" data-step="step2_<?php echo $p->package_id ?>">
                      <div class="PP-box-info">
                      <div class="pp-scroll">
                        <?php
                        if (isset($this->session->userdata('student_login_data')->id)) {
                          $readOnly = 'readonly="readonly" ';
                          $readOnly_dis = 'disabled="disabled" ';
                          //$disabled_sel="disabled='disabled'";
                        } else {
                          $readOnly = '';
                          $readOnly_dis = "";
                        }
                        ?>
                        <div class="row">
                          <div class="col-md-6 col-sm-6">
                            <div class="form-group ">
                              <label  class="font-weight-600">First Name<span class="text-red">*</span></label>
                              
                              <input type="text" class="fstinput allow_alphabets removeerrmessage" placeholder="First Name" name="online_fname" id="online_fname<?php echo $p->package_id ?>" value="<?php if (isset($this->session->userdata('student_login_data')->fname)) {
                                                                                                                                                                      echo $this->session->userdata('student_login_data')->fname;
                                                                                                                                                                    } else {
                                                                                                                                                                      echo "";
                                                                                                                                                                    } ?>" <?php echo $readOnly; ?> maxlength="30">
                              <div class="validation font-11 text-red online_fname<?php echo $p->package_id ?>_err online_fname_err<?php echo $p->package_id ?>"></div>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                              <label  class="font-weight-600">Last Name</label>
                              <input type="text" class="fstinput allow_alphabets" placeholder="Last Name" name="online_lname" id="online_lname<?php echo $p->package_id ?>" value="<?php if (isset($this->session->userdata('student_login_data')->lname)) {
                                                                                                                                                                      echo $this->session->userdata('student_login_data')->lname;
                                                                                                                                                                    } else {
                                                                                                                                                                      echo "";
                                                                                                                                                                    } ?>" maxlength="30" <?php echo $readOnly; ?>>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6">
                          <div class="form-group selectpicker-auto">
                            <label  class="font-weight-600">Country Code<span class="text-red">*</span></label>
                            <select class="selectpicker form-control" <?php echo $readOnly_dis; ?> data-live-search="true" name="online_country_code" id="online_country_code<?php echo $package_id ?>">
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
                              
                              foreach ($countryCode->error_message->data as $pcc) {
                                $selected = ($pcc->iso3 == $c) ? ' selected="selected"' : "";
                                $disabled_se = ($pcc->iso3 == $c) ? '' : ' disabled="disabled"';
                                echo '<option value="' . $pcc->country_code . '" ' . $selected . '>' . $pcc->country_code . '-' . $pcc->iso3 . '</option>';
                              }
                              ?>
                            </select>
                            <div class="validation font-11 text-red online_country_code_error<?php echo $package_id ?>"></div>
                          </div>
                          </div>
                          <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                              <label  class="font-weight-600">Phone Number<span class="text-red">*</span></label>
                              <input type="tel" class="fstinput allow_numeric removeerrmessage" placeholder="Phone Number " name="onlinec_mobile" id="onlinec_mobile<?php echo $package_id; ?>" value="<?php if (isset($this->session->userdata('student_login_data')->mobile)) {
                                                                                                                                                                          echo $this->session->userdata('student_login_data')->mobile;
                                                                                                                                                                        } else {
                                                                                                                                                                          echo "";
                                                                                                                                                                        } ?>" maxlength="10" <?php echo $readOnly; ?> autocomplete="off">
                              <div class="validation font-11 text-red onlinec_mobile<?php echo $package_id; ?>_err online_mobile_error<?php echo $package_id; ?>"></div>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                              <label  class="font-weight-600">Email<span class="text-red">*</span></label>
                              <input type="email" class="fstinput  removeerrmessage" placeholder="Email" name="online_email" id="online_email<?php echo $package_id; ?>" value="<?php if (isset($this->session->userdata('student_login_data')->email)) {
                                                                                                                                                                      echo $this->session->userdata('student_login_data')->email;
                                                                                                                                                                    } else {
                                                                                                                                                                      echo "";
                                                                                                                                                                    } ?>" onblur="validate_complaint_email(this.value,<?php echo $package_id; ?>)" maxlength="60" <?php echo $readOnly; ?> autocomplete="off">
                              <div class="validation font-11 text-red online_email<?php echo $package_id; ?>_err online_email_error<?php echo $package_id; ?>"></div>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                              <label  class="font-weight-600">Date Of Birth<span class="text-red">*</span></label>
                              <div class="has-feedback">
                              
                              

                              <input type="tel" data-inputmask="'alias': 'dd-mm-yyyy'" class="fstinput removeerrmessaged dob_mask_n" name="dob" id="dob<?php echo $package_id; ?>" placeholder="DD-MM-YYYY" value="<?php if(isset($this->session->userdata('student_login_data')->dob)) {   echo $this->session->userdata('student_login_data')->dob; } else { echo "";}?>" autocomplete="off" onchange="checkdobp(this.value,this.id)" <?php echo $readOnly_dis;?>>


                                <span class="fa fa-calendar form-group-icon"></span>
                                <div class="validation font-11 text-red  dob<?php echo $package_id; ?>_err dob_error<?php echo $package_id; ?>"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div></div>
                    <div class="step-footer">
                      <ul class="step-steps pull-left">
                        <li style="pointer-events: none;" data-step-target="step1_<?php echo $p->package_id ?>">1</li>
                        <li  style="pointer-events: none;" data-step-target="step2_<?php echo $p->package_id ?>">2</li>
                       
                      </ul>
                      <span class="pull-right ft-right">
                        <span class="pac-price">
                          <?php
                          if ($flag == 1) { ?>
                            <strike><span><?php echo $currency_code; ?>&nbsp;<?php echo $price1; ?></span></strike>
                          <?php   }  ?>
                          <span class="price"><span><?php echo $currency_code; ?></span>&nbsp;<?php echo $price2; ?></span>
                        </span>
                        <span class="p-rt">
                        <span><button type="button" data-step-action="prev" class="btn btn-border btn-mdl step-btn">Back</button></span>
                        <span><button type="button" data-step-action="next" data-packid="<?php echo $p->package_id ?>" class="btn btn-red btn-mdl step-btn customnext" id="d_<?php echo $p->package_id ?>">Next</button></span>
                        <span>
                        <span>
                          <button type="button" data-step-action="finish" id="checkout_btn<?php echo $package_id; ?>" class="btn btn-red btn-mdl step-btn font-bold checkout_btn" onclick="return check_booking(<?php echo $package_id; ?>);" >Checkout</button></span>

                      </span>
                    </div>
                  </div>
                </div>
                </form>
              </div>
            </div>
          </div>
          <script type="text/javascript">
            $('#onlinecoursemodel<?php echo $p->package_id ?>').steps({
              onFinish: function() {
            //alert('finish');   
                     },
             
            });
          </script>
    <!--End Modal info-->
  <?php }
} else { ?>
<div class="text-center"><?php echo $OnlinePack->error_message->message; ?></div>
<?php } ?>
<input type="hidden" id="stepcountp" />
        <input type="hidden" id="hidpackageid" />
        
<script type="text/javascript">
  $('.selectpicker').selectpicker('refresh')
  
</script>
<script id="rendered-js">
 $(".dob_mask_n:input").inputmask("99/99/9999",{ "placeholder": "DD-MM-YYYY" });
 $(document).on('keypress','.removeerrmessaged',function(){
	if($(this).val() !="")
  {
    var id=$(this).attr('id');
	//alert(id);
    var id_err 		= id+'_err';
    $("."+id_err).html(""); 
  }
    
});


$(".selectpicker-auto .bootstrap-select").each(function(i) {
	   $(this).addClass("pick"+i)
	   $(".pick"+i).on("click", function(e) {
		   e.preventDefault();
		   var minw = $(this).width();
		   var hgg = $(this).offset().top;
		   var hg2 = $(this).parents().find(".scroll-select-picker").offset().top;
		  var offt = hgg-hg2 + 10;   
		   var hggwa = $(this).offset();
		   //var countmdl = mdlw - mdlw1;
		   var mdlw = $(".scroll-select-picker").width();
		   var hglft = hggwa.left;
		   var jhd = $(window).width();
		//    alert(hglft);
		   var mdlw1 = $(".scroll-select-picker .modal-lg").width();
		   var hgdr = jhd - mdlw1;
		   var countmdlfinal = hglft - hgdr / 2;
		   if ($(window).width() > 900) {
			   $(this).children(".dropdown-menu.open").css({
				   "position": "fixed",
				   "top": offt,
				   "left": countmdlfinal,
				   "min-width": minw,
				   "max-width": minw
			   });
		   } else {
			   $(this).children(".dropdown-menu.open").css({
				   "position": "fixed",
				   "top": offt + 20,
				   "left": countmdlfinal,
				   "min-width": minw,
				   "max-width": minw
			   });
		   }
		   $(".scroll-select-picker .pp-scroll").toggleClass("active");
	   })
   })

   $(window).click(function() {
	   $(".scroll-select-picker .pp-scroll").removeClass("active");
   });



</script>






