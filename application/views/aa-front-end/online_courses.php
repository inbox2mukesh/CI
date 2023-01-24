<link href="<?php echo site_url('resources-f/css/steps.css'); ?>" rel="stylesheet" type="text/css">
<section class="bg-lighter-theme" style="border-bottom: solid 1px #efeadd;">
  <div class="container" style="padding-bottom:30px;">

    <div class="section-title">
      <div class="row">
        <div class="text-center">
          <h2 class="mb-20 text-uppercase font-weight-300 font-28 mt-0">Online <span class="text-theme-color-2 font-weight-500"> Courses</span></h2>
        </div>
      </div>
    </div>
    <!--Filter--->
    <div class="filter-wht-box" style="display: flow-root;">
      <div class="fltr-row-5clmn">
        <div class="col-md-3 col-sm-6">
          <div class="form-group">
            <select class="selectpicker form-control " data-live-search="true" name="test_module_id" id="test_module_id" onChange="disableEnablepgm(this.value);GetDuation(this.value);GetOnlinePack();GetCourseType();">
              <option value="">Select Course</option>
              <?php
              foreach ($allOnlineCourseTestModule->error_message->data as $p) {
              ?>
                <option value="<?php echo $p->test_module_id; ?>"><?php echo $p->test_module_name; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="form-group">
            <select class="selectpicker form-control" data-live-search="true" name="programe_id" id="programe_id" onChange="GetDuation(this.value);GetOnlinePack();Getcategory();GetCourseType();">
              <option value="">Select Program</option>
              <?php
              foreach ($allOnlineCoursePgm->error_message->data as $p) {
              ?>
                <option value="<?php echo $p->programe_id; ?>"><?php echo $p->programe_name; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="form-group">
            <select class="selectpicker form-control catOption" name="category_id" id="category_id" onChange="GetOnlinePack();GetDuation(this.value);" disabled="disabled">
              <option value=''>Select Module</option>
            </select>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="form-group">
            <select class="selectpicker form-control" name="course_type" id="course_type" onChange="GetOnlinePack(),GetDuation(this.value);" disabled="disabled">
              <option value=''>Select Course Type</option>
            </select>
          </div>
        </div>

        <div class="col-md-3 col-sm-6">
          <div class="form-group">
            <select class="selectpicker form-control" name="duration" id="duration" onChange="GetOnlinePack();Getcategory();" disabled="disabled" data-live-search="true">
              <option value="">Select Duration</option>
              <?php
              foreach ($allOnlineCourseDuration->error_message->data as $p) {
              ?>
                <option value="<?php echo $p->duration; ?>"><?php echo $p->duration . ' ' . $p->duration_type; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>


      </div>

      <div id="flter-btm-info">

        <span class="text-left font-weight-600 pull-left loader_load_data_m " id="up"> <i class="fa fa-spinner fa-spin mr-10"></i> <span class="loader_load_data">Showing All | Adjust Filters to change the view</span></span>
        <span class="pull-right font-weight-600" id="down"><a href="">Reset</a></span>


      </div>

    </div>
    <!-- <div class="sp-12" id="flter-btm-info">
      <span class="text-left font-weight-600 pull-left hide loader_load_data" id="up"> <i class="fa fa-spinner fa-spin mr-10"></i> Loading...Please Wait </span>
      <span class="pull-right font-weight-600" id="down"><a href="">Clear All </a></span>
    </div> -->
    <!---EndFilter--->
  </div>
</section>
<!---Modal Info-->
<script src="<?php echo site_url('resources-f/js/jquery-steps.js'); ?>"></script>
<script src="<?php echo site_url('resources-f/'); ?>js/date-mask.js"></script>
<section>
  <div class="container">
    <!--START GRID CONTAINER-->

    <div class="row onlinePackResultDiv">
      <?php
      foreach ($OnlinePack->error_message->data as $p) {
        $package_id = $p->package_id;
        $test_module_id = $p->test_module_id;
        $programe_id = $p->programe_id;
        $center_id = $p->center_id;
        $currency_code = $p->currency_code;
        $category_id = $p->category_id;
        $country_id = $p->country_id;
        $img = site_url('resources-f/images/courses/course-1.jpg');
        $test_module_name = $p->test_module_name;
        if (trim($p->programe_name) == "General Training") {
          $programe_name_title = "GT";
        } else if (trim($p->programe_name) == "None") {
          $programe_name_title = "";
        } else {
          $programe_name_title = $p->programe_name;
        }
        if ($programe_name_title != "") {
          if ($test_module_name == IELTS_CD or $test_module_name == IELTS) {
            $programe_name = ' | ' . $programe_name_title;
          } else {
            $programe_name = ' | ' . $programe_name_title;
          }
        } else {
          $programe_name = "";
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
          $amount = '<span> Price: <ins><strike><span class="font-weight-400 price">' . $p->amount . '</span></ins></span></strike><br/>
<span> Offer Price: <ins><span class="font-weight-400 price">' . $p->discounted_amount . '</span></ins></span>';
        } else {
          $flag = 0;
        }
      ?>




        <div class="col-md-3 col-sm-6 mt-10">
          <a href="#" data-toggle="modal" data-target="#onlinecoursemodel<?php echo $p->package_id ?>" data-keyboard="false" data-backdrop="static" class="btn_reset onlinecard" onClick="setpackid('<?php echo $p->package_id ?>')">
            <div class="service-block bg-white mb-20">
              <div class="thumb"> <img alt="featured project" src="<?php echo site_url(); ?>uploads/package_file/<?php echo $p->image; ?>" class="img-responsive img-fullwidth">
                <span class="title"><?php echo $test_module_name . $programe_name; ?></span>
              </div>
              <div class="content clearfix font-14 font-weight-500">
                <div class="disc">
                  <h3><?php echo $package_name; ?> </h3>
                  <p><span class="font-weight-600">Module:</span> <span><?php echo $category_name; ?></span> </p>
                  <p><span class="font-weight-600">Course Type:</span> <span><?php echo $p->course_timing; ?></span> </p>
                  <p><span class="font-weight-600">Duration:</span> <?php echo $p->duration; ?> <?php echo $p->duration_type; ?></p>
                  <?php
                  if ($flag == 1) { ?>
                    <p><span class="font-weight-600"> Price: </span> <strike><?php echo $currency_code; ?>&nbsp;<?php echo $price1; ?></strike></p>
                  <?php   }  ?>
                </div>
                <div class="ftr-btm text-center"> <span class="more-info pull-left">More Info</span> <span class="purchase font-weight-600 pull-right">Buy Now: <span class="text-red"><?php echo $currency_code; ?></span> <span class="text-red"><?php echo $price2; ?></span> </span>
                </div>
              </div>
            </div>
          </a>
        </div>




        <!---Modal Info-->
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
                    <li><span class="text-uppercase">Course Type:</span> <?php echo $p->course_timing; ?> </li>
                    <!-- <li class="mob-break"></li>    -->
                    <li><span class="text-uppercase">Duration:</span> <?php echo $p->duration; ?> <?php echo $p->duration_type; ?></li>
                  </ul>
                </div>
              </div>
              <form action="#" method="post" enctype="multipart/form-data" id="onlinecourseform<?php echo $package_id ?>">
                <input type="hidden" value="<?php echo $package_id; ?>" name="package_id" id="package_id" />
                <input type="hidden" value="online" name="pack_type" id="pack_type" />
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
                          <div class="row">
                            <div class="col-md-3">&nbsp;</div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <div id="batch_option_sec_<?php echo $p->package_id; ?>">
                                </div>
                                <div class="validation font-11 red-text batch_option_<?php echo $p->package_id; ?>_err"></div>
                              </div>
                              <div class="form-group">
                                <lable class="font-weight-600">Select Package Start Date<span class="text-red">*</span></lable>
                                <div class="has-feedback">
                                  <input class="fstinput removeerrmessage datepicker" name="packstartdate" placeholder="DD-MM-YYYY" autocomplete="off" id="packagestartdate_<?php echo $p->package_id; ?>" readonly>
                                  <span class="fa fa-calendar form-group-icon"></span>
                                  <div class="validation font-11 red-text packagestartdate_<?php echo $p->package_id; ?>_err"></div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3">&nbsp;</div>
                            <div class="col-md-12 text-center font-weight-600" id="upcomingclasstext_<?php echo $p->package_id ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="step-tab-panel" data-step="step3_<?php echo $p->package_id ?>">
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
                                <label class="font-weight-600">First Name<span class="text-red">*</span></label>
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
                                <label class="font-weight-600">Last Name</label>
                                <input type="text" class="fstinput allow_alphabets" placeholder="Last Name" name="online_lname" id="online_lname<?php echo $p->package_id ?>" value="<?php if (isset($this->session->userdata('student_login_data')->lname)) {
                                                                                                                                                                                        echo $this->session->userdata('student_login_data')->lname;
                                                                                                                                                                                      } else {
                                                                                                                                                                                        echo "";
                                                                                                                                                                                      } ?>" maxlength="30" <?php echo $readOnly; ?>>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                            <!-- <div class="form-group selectpicker-auto"> -->
                              <div class="form-group">
                                <label class="font-weight-600">Country Code<span class="text-red">*</span></label>
                                <?php if ($this->session->userdata('student_login_data')->id) { ?>
                                  <select class="selectpicker form-control" <?php echo $readOnly_dis; ?> data-live-search="true" name="online_country_code" id="online_country_code<?php echo $package_id ?>">
                                    <?php
                                    echo '<option value="' . $this->session->userdata('student_login_data')->country_code . '|' . $this->session->userdata('student_login_data')->country_iso3_code . '" ' . $selected . '>' . $this->session->userdata('student_login_data')->country_code . '-' . $this->session->userdata('student_login_data')->country_iso3_code . '</option>';
                                    ?>
                                  </select>
                                <?php } else { ?>
                                  <select class="selectpicker form-control" <?php echo $readOnly_dis; ?> data-live-search="true" name="online_country_code" id="online_country_code<?php echo $package_id ?>">
                                    <?php
                                    $c = 'CA';
                                    foreach ($countryCode->error_message->data as $pcc) {
                                      $selected = ($pcc->iso3 == $c) ? ' selected="selected"' : "";
                                      $disabled_se = ($pcc->iso3 == $c) ? '' : ' disabled="disabled"';
                                      echo '<option value="' . $pcc->country_code . '|' . $pcc->iso3 . '" ' . $selected . '>' . $pcc->country_code . '-' . $pcc->iso3 . '</option>';
                                    }
                                    ?>
                                  </select>
                                <?php } ?>
                                <div class="validation font-11 text-red online_country_code_error<?php echo $package_id ?>"></div>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                              <div class="form-group">
                                <label class="font-weight-600">Phone Number<span class="text-red">*</span></label>
                                <input type="tel" class="fstinput allow_numeric removeerrmessage" placeholder="Phone Number" name="onlinec_mobile" id="onlinec_mobile<?php echo $package_id; ?>" value="<?php if (isset($this->session->userdata('student_login_data')->mobile)) {
                                                                                                                                                                                                          echo $this->session->userdata('student_login_data')->mobile;
                                                                                                                                                                                                        } else {
                                                                                                                                                                                                          echo "";
                                                                                                                                                                                                        } ?>" maxlength="10" <?php echo $readOnly; ?> autocomplete="off">
                                <div class="validation font-11 text-red onlinec_mobile<?php echo $package_id; ?>_err online_mobile_error<?php echo $package_id; ?>"></div>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                              <div class="form-group">
                                <label class="font-weight-600">Email<span class="text-red">*</span></label>
                                <input type="email" class="fstinput  removeerrmessage" placeholder="Email" name="online_email" id="online_email<?php echo $package_id; ?>" value="<?php if (isset($this->session->userdata('student_login_data')->email)) {
                                                                                                                                                                                    echo $this->session->userdata('student_login_data')->email;
                                                                                                                                                                                  } else {
                                                                                                                                                                                    echo "";
                                                                                                                                                                                  } ?>" onBlur="validate_complaint_email(this.value,<?php echo $package_id; ?>)" maxlength="60" <?php echo $readOnly; ?> autocomplete="off">
                                <div class="validation font-11 text-red online_email<?php echo $package_id; ?>_err online_email_error<?php echo $package_id; ?>"></div>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                              <div class="form-group">
                                <lable class="font-weight-600">Date Of Birth<span class="text-red">*</span></lable>
                                <div class="has-feedback">
                                  <!-- <input type="text" data-inputmask="'alias': 'date'" class="fstinput removeerrmessage dob_mask" placeholder="dd/mm/yyyy"  name="dob" id="dob<?php echo $package_id; ?>" autocomplete="off" value="" placeholder="DD-MM-YYYY" maxlength="10" autocomplete='off' onchange="checkdobp(this.value,this.id)" <?php echo $readOnly_dis; ?>> -->


                                  <input type="tel" data-inputmask="'alias': 'dd-mm-yyyy'" class="fstinput removeerrmessage dob_mask_n" name="dob" id="dob<?php echo $package_id; ?>" placeholder="DD-MM-YYYY" value="<?php if (isset($this->session->userdata('student_login_data')->dob)) {
                                                                                                                                                                                                                        echo $this->session->userdata('student_login_data')->dob;
                                                                                                                                                                                                                      } else {
                                                                                                                                                                                                                        echo "";
                                                                                                                                                                                                                      } ?>" autocomplete="off" onchange="checkdobp(this.value,this.id)" <?php echo $readOnly_dis; ?>>



                                  <span class="fa fa-calendar form-group-icon"></span>
                                  <div class="validation font-11 text-red dob<?php echo $package_id; ?>_err dob_error<?php echo $package_id; ?>"></div>
                                </div>
                              </div>
                            </div>


                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="step-footer">
                      <ul class="step-steps pull-left">
                        <li style="pointer-events: none;" data-step-target="step1_<?php echo $p->package_id ?>">1</li>
                        <li style="pointer-events: none;" data-step-target="step2_<?php echo $p->package_id ?>">2</li>
                        <li style="pointer-events: none;" data-step-target="step3_<?php echo $p->package_id ?>">3</li>
                      </ul>
                      <span class="pull-right">
                        <span class="pac-price">
                          <?php
                          if ($flag == 1) { ?>
                            <strike><span><?php echo $currency_code; ?>&nbsp;<?php echo $price1; ?></span></strike>
                          <?php   }  ?>
                          <span class="price"><span><?php echo $currency_code; ?></span>&nbsp;<?php echo $price2; ?></span>
                          <span class="p-rt">
                            <span><button type="button" data-step-action="prev" class="btn btn-border btn-mdl step-btn">Back</button></span>
                            <span><button type="button" data-step-action="next" data-packid="<?php echo $p->package_id ?>" class="btn btn-red btn-mdl step-btn customnext" id="d_<?php echo $p->package_id ?>">Next</button></span>
                            <span>
                              <button type="button" data-step-action="finish" id="checkout_btn<?php echo $package_id; ?>" class="btn btn-red btn-mdl step-btn font-bold checkout_btn" onClick="return check_booking(<?php echo $package_id; ?>);">Checkout</button></span>
                          </span>
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

        <!--END GRID ITEM -->

      <?php } ?>
      <input type="hidden" id="stepcountp" />
      <input type="hidden" id="hidpackageid" />
      <script type="text/javascript">
        $(".customnext").click(function() {
          var packid = $(this).data('packid');
          var countp = $('#stepcountp').val();
          if (countp == 0) {
            $.post("<?php echo site_url('Online_courses/GetPackageBatch/'); ?>", {
              packid: packid
            }, function(data) {
              $('#batch_option_sec_' + packid).html(data);
              $('.selectpicker').selectpicker('refresh')
              var optval = $('#batch_option_' + packid).val();
              //alert(optval)
              if (optval != "") {
                GetPackageSchedule(optval, packid);
              }
            });
          }
        });

        function GetPackageSchedule(branchid, packid) {
          var module_id = $('#test_module_id_' + packid).val();
          var programe_id = $('#programe_id_' + packid).val();
          var center_id = $('#center_id_' + packid).val();
          if (branchid != "") {
            $.post("<?php echo site_url('Online_courses/GetPackageSchedule/'); ?>", {
              packid: packid,
              branchid: branchid,
              module_id: module_id,
              programe_id: programe_id,
              center_id: center_id
            }, function(data) {
              $('#upcomingclasstext_' + packid).html(data);
            });
          } else {
            $('#upcomingclasstext_' + packid).html("");
          }
        }
        //  $('.selectpicker').selectpicker('refresh')
      </script>

    </div>


    <!--END GRID CONTAINER-->
    <?php if ($OnlinePackCount > LOAD_MORE_LIMIT_8) { ?>

      <div class="text-center mt-10">
        <button class="btn btn-primary btn-sm loadmore" id="loadmore" onClick="loadmore();">Load More</button>
        <img id="ajax_loader" class="hide" src="<?php echo site_url() ?>resources-f/images/ajax-loader1.gif" width="20px">

      </div>


    <?php } ?>
  </div>

</section>

<script id="rendered-js">
  //$(".dob_mask_n:input").inputmask();
  $(".dob_mask_n:input").inputmask("99/99/9999", {
    "placeholder": "DD-MM-YYYY"
  });
</script>

<input type="hidden" name="offset" id="offset" value="0" />
<script>
  function loadmore() {

    var test_module_id = $("#test_module_id").val();
    var programe_id = $("#programe_id").val();
    var category_id = $("#category_id").val();
    var duration = $("#duration").val();

    $('#ajax_loader').removeClass('hide')
    var limit_v = parseInt(<?php echo LOAD_MORE_LIMIT_8; ?>);
    var offset_v = parseInt($('#offset').val());
    var newoffset = limit_v + offset_v;
    $.ajax({
      url: "<?php echo site_url('online_courses/ajax_loadmore_onlinepack'); ?>",
      type: 'post',
      dataType: 'json',
      data: {
        offset: $('#offset').val(),
        test_module_id: test_module_id,
        programe_id: programe_id,
        category_id: category_id,
        duration: duration
      },
      success: function(data) {

        $('#ajax_loader').addClass('hide')
        $('.onlinePackResultDiv').append(data['html']);
        $('.selectpicker').selectpicker('refresh')
        $('#offset').val(newoffset)
        if (data["count"] == 0) {
          $('.loadmore').addClass('hide')

        }
        return false;
      }
    })
  }

  $(document).on('click', '.select_removeerrmessage', function() {
    var id = $(this).prev().attr('id')
    var id_err = id + '_err';
    $("." + id_err).html("");
  });

  function setpackid(x) {
    $('#hidpackageid').val(x)
  }

  function checkdobp(data, id) {
    //alert(data)
    if (data != "") {
      var idd = '.' + id + '_err';
      var dt = data.split("-");
      if (dt[1] == '02') {
        if (dt[0] > 29) {
          //  $('.dob_mask_n').focus();
          $(idd).text('Please enter the valid Date Of Birth');
          return false;
        } else {
          $(idd).text('');
        }
      }
      var pattern = /^([0-9]{2})\-([0-9]{2})\-([0-9]{4})$/;
      if (pattern.test(data) == false) {
        //  $('.dob_mask_n').focus();
        $(idd).text('Please enter the valid Date Of Birth');
        return false;
      } else {
        $(idd).text('');
      }
      //alert(isOver18(new Date("2000-03-27")))
      dt = dt[2] + '-' + dt[1] + '-' + dt[0];
      if (isOver15(new Date(dt)) == false) {

        // $('.dob_mask_n').focus();
        //$('.dob_mask_n').val('');
        $(idd).text('You must have at least 15 years of age');
        return false;
      }
    }

  }

  function checkdob_aa(data, package_id) {

    var dt = data.split("-");
    if (data != "") {
      var pattern = /^([0-9]{2})\-([0-9]{2})\-([0-9]{4})$/;
      if (pattern.test(data) == false) {
        $(".dob_error" + package_id).text('Please enter the valid Date Of Birth');
        return false;
      } else {
        dt = dt[2] + '-' + dt[1] + '-' + dt[0];
        if (isOver15(new Date(dt)) == false) {

          $(".dob_error" + package_id).text('You must have at least 15 years of age');
          return false;
        }
        return true;
      }

    }

  }

  function isOver15(dateOfBirth) {
    // dateOfBirth=new Date(dateOfBirth);
    // find the date 15 years ago
    const date15YrsAgo = new Date();
    date15YrsAgo.setFullYear(date15YrsAgo.getFullYear() - 15);
    // check if the date of birth is before that date
    return dateOfBirth <= date15YrsAgo;
  }
</script>
<script type="text/javascript">
  function disableEnablepgm(test_module_id) {
    //1,2,6 ielts- 3,4 pte,spoken
    $('#duration').prop('selectedIndex', 0);
    $('#course_type').prop('disabled', false);
    $('#course_type').prop('selectedIndex', 0);
    if (test_module_id == <?php echo IELTS_ID; ?> || test_module_id == <?php echo PTE_ID; ?> || test_module_id == <?php echo UKVI_CD_IELTS; ?>) {
      $('#programe_id').prop('selectedIndex', 0);
      $('#programe_id').prop('disabled', false);
      $('.selectpicker').selectpicker('refresh')
    } else if (test_module_id == <?php echo IELTS_CD_ID; ?>) {
      $('#programe_id').prop('selectedIndex', 1);
      $('#programe_id').prop('disabled', true);
      $('.selectpicker').selectpicker('refresh')
    } else if (test_module_id == <?php echo TOEFL_ID; ?>) {
      $('#programe_id').prop('selectedIndex', 0);
      $('#programe_id').prop('disabled', false);
      $('.selectpicker').selectpicker('refresh')
    } else if (test_module_id == '') {
      $('#programe_id').prop('selectedIndex', 0);
      $('#programe_id').prop('disabled', false);
      $('.selectpicker').selectpicker('refresh')
    } else {
      $('#programe_id').prop('selectedIndex', 0);
      $('#programe_id').prop('disabled', false);
      $('.selectpicker').selectpicker('refresh')
    }
    //$('.catOption').selectpicker('refresh');
    //  $('.catOption').html('<option value="">All Module</option>');
    // $('.catOption').selectpicker('refresh');
  }

  function GetDuation() {
    var test_module_id = $("#test_module_id").val();
    var programe_id = $("#programe_id").val();
    var category_id = $("#category_id").val();
    var course_type = $("#course_type").val();
    $.ajax({
      url: "<?php echo site_url('online_courses/GetDuation'); ?>",
      async: true,
      type: 'post',
      data: {
        test_module_id: test_module_id,
        programe_id: programe_id,
        category_id: category_id,
        course_type: course_type
      },
      success: function(data) {
        //alert(data)
        $('#duration').html(data);
        $('#duration').selectpicker('refresh');
        // Getcategory()
      },
      beforeSend: function() {},
    });
  }

  function Getcategory() {
    var test_module_id = $("#test_module_id").val();
    var programe_id = $("#programe_id").val();
    var duration = $("#duration").val();
    if (test_module_id && programe_id) {
      $.ajax({
        url: "<?php echo site_url('online_courses/Getcategory'); ?>",
        async: true,
        type: 'post',
        data: {
          test_module_id: test_module_id,
          programe_id: programe_id,
          duration: duration
        },
        success: function(data) {
          $('#category_id').html(data);
          $('#category_id').selectpicker('refresh');
        },
        beforeSend: function() {},
      });
    } else {
      $('#category_id').html("<option value=''>Select Module</option>");
      $('#category_id').selectpicker('refresh');
    }
  }

  function GetOnlinePack() {

    var test_module_id = $("#test_module_id").val();
    var programe_id = $("#programe_id").val();
    var category_id = $("#category_id").val();
    var duration = $("#duration").val();
    var course_type = $("#course_type").val();
    var limit_v = parseInt(<?php echo LOAD_MORE_LIMIT_8; ?>);
    var offset_v = parseInt($('#offset').val());
    var newoffset = limit_v + offset_v;


    if (test_module_id == <?php echo IELTS_ID; ?> || test_module_id == <?php echo PTE_ID; ?> || test_module_id == <?php echo UKVI_CD_IELTS; ?>) {
      $('#programe_id').prop('disabled', false);
      $('#duration').prop('disabled', false);
      $('#category_id').prop('disabled', false);
      $('.selectpicker').selectpicker('refresh')
    } else if (test_module_id == <?php echo IELTS_CD_ID; ?>) {
      $('#programe_id').prop('disabled', true);
      $('#duration').prop('disabled', false);
      $('#category_id').prop('disabled', false);
      $('.selectpicker').selectpicker('refresh')
    } else if (test_module_id == <?php echo TOEFL_ID; ?>) {
      $('#programe_id').prop('selectedIndex', 0);
      $('#programe_id').prop('disabled', false);
      $('.selectpicker').selectpicker('refresh')
    } else {
      $('#programe_id').prop('disabled', true);
      $('#duration').prop('disabled', true);
      $('#category_id').prop('disabled', true);
      $('.selectpicker').selectpicker('refresh')
    }
    $.ajax({
      url: "<?php echo site_url('online_courses/GetOnlinePack'); ?>",
      //async: true,
      type: 'post',
      dataType: 'json',
      data: {
        test_module_id: test_module_id,
        programe_id: programe_id,
        category_id: category_id,
        duration: duration,
        offset: $('#offset').val(),
        course_type: course_type
      },
      success: function(data) {

        if (data != '') {
          $('.loader_load_data').text('Adjust Filters to change the view');
          $('.onlinePackResultDiv').html(data['html']);
          $('.selectpicker').selectpicker('refresh')
          if (data["count"] == 0 || data["count"] == null) {
            $('.loadmore').addClass('hide')

          } else {
            $('.loadmore').removeClass('hide')
          }

        } else {
          $('.loader_load_data').text('Showing All | Adjust Filters to change the view');
          $('.onlinePackResultDiv').html(data['html']);
          $('.selectpicker').selectpicker('refresh')
        }
      },
      beforeSend: function() {
        $('.loader_load_data').text('Loading...Please Wait');
      },
    });
  }

  function GetCourseType() {
    var test_module_id = $("#test_module_id").val();
    var programe_id = $("#programe_id").val();
    $.ajax({
      url: "<?php echo site_url('online_courses/GetCourseType'); ?>",
      async: true,
      type: 'post',
      data: {
        test_module_id: test_module_id,
        programe_id: programe_id
      },
      success: function(data) {
        $('#course_type').html(data);
        $('#course_type').selectpicker('refresh');
      },
      beforeSend: function() {},
    });

  }

  function check_booking(package_id) {
    var flag = 1;
    var numberes = /^[0-9-+]+$/;
    var letters = /^[A-Za-z ]+$/;
    var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,10}\b$/i;
    var fname = $("#online_fname" + package_id).val();
    var onlineemail = $("#online_email" + package_id).val();
    var mobile = $("#onlinec_mobile" + package_id).val();
    var country_code = $("#online_country_code" + package_id).val();

    var dob = $("#dob" + package_id).val();
    var dobid = $("#dob" + package_id).attr('id');
    var dt = dob.split("-");
    dt = dt[2] + '-' + dt[1] + '-' + dt[0];
    var pattern = /^([0-9]{2})\-([0-9]{2})\-([0-9]{4})$/;
    if (fname.match(letters)) {
      $(".online_fname_err" + package_id).text('');
    } else {
      //$("#online_fname" + package_id).focus();
      $(".online_fname_err" + package_id).text("Please enter the valid Name");
      flag = 0;
    }
    if (mobile.length > 10 || mobile.length < 10) {
      //$("#online_mobile" + package_id).focus();
      $(".online_mobile_error" + package_id).text('Please enter the valid Number');
      flag = 0; // return false;
    } else {
      $(".online_mobile_error" + package_id).text('');
    }
    if (onlineemail == "") {
      $(".online_email_error" + package_id).text('Please enter the valid Email Id');
      flag = 0;
    } else {
      if (onlineemail.match(mailformat)) {
        $(".online_email_error" + package_id).text('');
      } else {
        //$("#online_email" + package_id).focus();
        $(".online_email_error" + package_id).text('Please enter the valid Email Id');
        flag = 0;
      }
    }
    if (country_code == "") {
      // $("#online_country_code" + package_id).focus();
      $(".online_country_code_error" + package_id).text('Please select the country code');
      flag = 0;
    } else {
      $(".online_country_code_error" + package_id).text('');
    }

    /* if (pattern.test(dob) == false)
      {
        $("#dob" + package_id).focus();
        $(".dob_error" + package_id).text('Please enter the valid dob hhh');
        flag=0;
      } else
      {
        $(".dob_error" + package_id).text('');
        if (isOver15(new Date(dt)) == false)
        {

        // $("#dob" + package_id).focus();
        $("#dob" + package_id).val('');
        $(".dob_error" + package_id).text('You must have at least 15 years of age');
        //return false;
        }
    }*/

    if (dob == "") {
      $(".dob_error" + package_id).text('Please enter the valid Date Of Birth');
      flag = 0
    } else {
      if (checkdob_aa(dob, package_id) == false) {
        flag = 0

        $("#dob" + package_id).prop('disabled', false);
      }
    }


    //alert(flag)
    if (flag == 0) {
      return false;
    } else {
      //alert("success")
      //return false;
      var form = $("#onlinecourseform" + package_id);
      $.ajax({
        url: "<?php echo site_url('booking/check_booking'); ?>",
        type: 'post',
        data: form.serialize(),
        success: function(response) {
          if (response.status == 'true') {
            $('#onlinecoursemodel' + package_id).modal('hide');
            optcountdown();
            $('#modal-reg-OTP').modal('show');
          } else if (response.status == 1) {
            $('#onlinecoursemodel' + package_id).modal('hide');
            optcountdown();
            $('#modal-reg-OTP').modal('show');
          } else if (response.status == 2) {
            $('#onlinecoursemodel' + package_id).modal('hide');
            $('#modal-login').modal('show');
          } else if (response.status == 3) {
            window.location.href = "<?php echo site_url('booking/checkout'); ?>"
          } else {
            $('#checkout_btn' + package_id).prop('disabled', false);
            $('#checkout_btn' + package_id).text('Checkout');
            $('#regmain_msg_danger' + package_id).html(response.msg);
            $(".anc_clickhere").focus();
            //$('.regsub_button').hide();
          }
        },
        beforeSend: function() {
          $('#checkout_btn' + package_id).prop('disabled', true);
          $('#checkout_btn' + package_id).text('Please wait..');
        }
      });
    }


  }

  function optcountdown() {
    var timer2 = "0:30";
    var interval = setInterval(function() {
      var timer = timer2.split(':');
      //by parsing integer, I avoid all extra string processing
      var minutes = parseInt(timer[0], 10);
      var seconds = parseInt(timer[1], 10);
      --seconds;
      minutes = (seconds < 0) ? --minutes : minutes;
      if (seconds <= 0) {
        clearInterval(interval);
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        $('.countdown').html("");
        $('#resend_btn').show();
        $('#reg_opt_success').addClass('hide');
        $('.reg_otp_err').addClass('hide');
        $('#reg_opt_success').html('');
      } else {
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;

        minutes = (minutes = 0) ? '0' + minutes : minutes;
        $('.countdown').html('<i class="fa fa-clock-o" aria-hidden="true"></i> 00:' + seconds);
        timer2 = minutes + ':' + seconds;
      }
    }, 1000);
  }

  function resendStuOTP() {
    $('#resend_btn').hide("");
    $('.reg_otp_err').addClass('hide');
    $.ajax({
      url: "<?php echo site_url('online_courses/resendStuOTP'); ?>",
      type: 'post',
      success: function(response) {
        $('.proBtn3').hide();
        if (response.status == 'true') {
          optcountdown();
          $('#reg_opt_success').removeClass('hide');
          $('#reg_opt_danger').addClass('hide');
          $('#reg_opt_success').html('<div class="alert alert-success alert-dismissible"><strong>Verification Code Resent on your email. Please Enter Verification Code</strong> <a href="#" class="alert-link"> </a> </div>');
        } else {
          $('#reg_opt_success').hide();
          //$('.proBtn3').hide();
        }
      },
      beforeSend: function() {
        $('.proBtn3').show();
      }
    });
  }

  function validate_complaint_email(email, id) {
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

  function anc_clickhere(pid) {
    $('#onlinecoursemodel' + pid).modal('hide');
    $('#dc_email').focus();
  }
</script>