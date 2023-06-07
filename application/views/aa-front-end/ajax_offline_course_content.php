<script src="<?php echo site_url('resources-f/js/jquery-steps.js'); ?>"></script>
<script src="<?php echo site_url('resources-f/js/date-mask.js'); ?>"></script>
<?php 

if (!empty($OfflinePack->error_message->data)) {
 foreach ($OfflinePack->error_message->data as $p)
{
  $package_id=$p->package_id;
  $test_module_id=$p->test_module_id;
    $programe_id=$p->programe_id;
     $center_id=$p->center_id;
     $currency_code=$p->currency_code;    
     $category_id = $p->category_id;
     $country_id = $p->country_id;
     
$img=site_url('resources-f/images/courses/course-1.jpg');
            $test_module_name = $p->test_module_name;
            if($test_module_name==IELTS_CD or $test_module_name==IELTS){
                $programe_name = ' | '.$p->programe_name;
            }else{
                $programe_name='';
            }
            $package_name=$p->package_name;
            $package_desc=$p->package_desc;
            $category_name=$p->category_name;
            if($category_name){
                $category_name= $category_name;
            }else{
                $category_name='All (LRWS)';
            }

            if($p->amount==$p->discounted_amount){

                $price1=$p->amount;
                $price2=$p->amount;
                $flag=0;

                $amount = '<span> Price <ins><span class="font-weight-400 price"> '.$p->amount.'</span></ins></span>';
            }elseif($p->amount>$p->discounted_amount){
                 $flag=1;
                 $price1=$p->amount;
                $price2=$p->discounted_amount;
                $amount = '<span> Price: <ins><span class="font-weight-400 price"><strike>'.$p->amount.'</strike></span></ins></span><br/>
                <span> Offer Price: <ins><span class="font-weight-400 price">'.$p->discounted_amount.'</span></ins></span>';
            }else{
 $flag=0;
            }

?>
<div class="grid-card-container mt-10"> 
                            <div class="grid-card">
                                <div class="service-block bg-white mb-20">
                                    <a href="#" data-toggle="modal" data-target="#onlinecoursemodel<?php echo $p->package_id ?>" data-keyboard="false" data-backdrop="static" class="onlinecard" onclick="setpackid('<?php echo $p->package_id ?>')">
                                        <div class="thumb"> <img alt="featured project" src="<?php echo $img?>" class="img-responsive img-fullwidth"> <span class="title"><?php echo $package_name;?></span> </div>
                                        <div class="content clearfix font-14 font-weight-500">
                                            <div class="disc">
                                                <h3><?php echo $test_module_name.$programe_name;?></h3>
                                                <p><span class="font-weight-600">Module:</span> <span class="font-12"><?php echo $category_name;?></span> </p>
                                                <p><span class="font-weight-600">Duration:</span> <?php echo $p->duration;?> <?php echo $p->duration_type;?></p>
                                                <?php 
                                                 if($flag ==1)
                                                {?>
                                           <p><span class="font-weight-600"> Price: </span> <?php echo $currency_code;?> <strike><?php echo $price1;?></strike></p>
                                     <?php   }  ?>

                                              </div>
                                            <div class="ftr-btm text-center"> <span class="more-info pull-left">More Info</span> <span class="purchase font-weight-600 pull-right">Buy Now: <span class="text-red"><?php echo $currency_code;?></span> <span class="font-16 text-red"><?php echo $price2;?></span> </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
            <!--END GRID ITEM -->
            
      <!---Modal Info-->
      <div class="modal fade modal-lg" id="onlinecoursemodel<?php echo $p->package_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close red-text font-16"></i></button>
                  <div class="w-title"><?php echo $package_name; ?></div>
                  <div class="w-subInfo">
                    <ul>
                      <li class="text-uppercase"><?php echo $test_module_name . $programe_name; ?></li>
                      <li><span class="text-uppercase">Module:</span> <?php echo $category_name; ?></li>
                      <li><span class="text-uppercase">Duration:</span> <?php echo $p->duration; ?> <?php echo $p->duration_type; ?></li>
                    </ul>
                  </div>
                </div>
                <form action="#" method="post" enctype="multipart/form-data" id="onlinecourseform<?php echo $package_id ?>" class="mt-15 theme-bg">
                <input type="hidden" value="<?php echo $package_id; ?>" name="package_id" id="package_id" />
          <input type="hidden" value="inhouse" name="pack_type" id="pack_type" />
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
                        <div class="row">
                          <div class="col-md-3"></div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <lable>Select Batch <span class="text-red">*</span></lable>
                              <select class="selectpicker form-control packageBatch" name="batch_id" title="Select" id="batch_option_<?php echo $p->package_id; ?>" onchange="GetPackageSchedule(this.value,<?php echo $p->package_id ?>)">
                                <option value="">Select Batch</option>

                              </select>
                              <div class="validation font-11 red-text batch_option_<?php echo $p->package_id; ?>_err"></div>
                            </div>
                            <div class="form-group">
                              <lable>Select Package Start Date<span class="text-red">*</span></lable>
                              <div class="has-feedback">
                                <!-- <input class="fstinput datepicker" name="db" placeholder="mm/dd/yyyy" id="db"> -->
                                <input type="text" data-inputmask="'alias': 'dd-mm-yyyy'" class="fstinput form-control dob_mask" name="packstartdate" id="packagestartdate_<?php echo $p->package_id; ?>" placeholder="dd-mm-yyyy" autocomplete="off" onchange="checkdob(this.value,this.id)">
                                <span class="fa fa-calendar form-group-icon"></span>
                                <div class="validation font-11 red-text packagestartdate_<?php echo $p->package_id; ?>_err"></div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3"></div>
                          <div class="col-md-12 text-center font-weight-600" id="upcomingclasstext_<?php echo $p->package_id ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="step-tab-panel" data-step="step3_<?php echo $p->package_id ?>">
                      <div class="PP-box-info">
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
                              <label>First Name<span class="red-text">*</span></label>
                              <input type="text" class="fstinput" placeholder="First Name" name="online_fname" id="online_fname<?php echo $p->package_id ?>" value="<?php if (isset($this->session->userdata('student_login_data')->fname)) {
                                                                                                                                                                      echo $this->session->userdata('student_login_data')->fname;
                                                                                                                                                                    } else {
                                                                                                                                                                      echo "";
                                                                                                                                                                    } ?>" <?php echo $readOnly; ?> maxlength="30">
                              <div class="validation font-11 red-text online_fname_error<?php echo $p->package_id ?>"></div>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                              <label>Last Name<span class="red-text">*</span></label>
                              <input type="text" class="fstinput" placeholder="Last Name" name="online_lname" id="online_lname<?php echo $p->package_id ?>" value="<?php if (isset($this->session->userdata('student_login_data')->lname)) {
                                                                                                                                                                      echo $this->session->userdata('student_login_data')->lname;
                                                                                                                                                                    } else {
                                                                                                                                                                      echo "";
                                                                                                                                                                    } ?>" maxlength="30" <?php echo $readOnly; ?>>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6">
                            <label>Country Code<span class="red-text">*</span></label>
                            <select class="selectpicker form-control" <?php echo $readOnly_dis; ?> data-live-search="true" name="online_country_code" id="online_country_code<?php echo $package_id ?>">
                              <?php
                              $c = '+91';
                              foreach ($countryCode->error_message->data as $pcc) {
                                $selected = ($pcc->country_code == $c) ? ' selected="selected"' : "";
                                echo '<option value="' . $pcc->country_code . '" ' . $selected . '>' . $pcc->country_code . '-' . $pcc->iso3 . '</option>';
                              }
                              ?>
                            </select>
                            <div class="validation font-11 red-text online_country_code_error<?php echo $package_id ?>"></div>
                          </div>
                          <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                              <label>Phone Number <span class="red-text">*</span></label>
                              <input type="text" class="fstinput" placeholder="Valid Phone" name="onlinec_mobile" id="onlinec_mobile<?php echo $package_id; ?>" value="<?php if (isset($this->session->userdata('student_login_data')->mobile)) {
                                                                                                                                                                          echo $this->session->userdata('student_login_data')->mobile;
                                                                                                                                                                        } else {
                                                                                                                                                                          echo "";
                                                                                                                                                                        } ?>" maxlength="10" <?php echo $readOnly; ?> autocomplete="off">
                              <div class="validation font-11 red-text online_mobile_error<?php echo $package_id; ?>"></div>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                              <label>Valid Email <span class="red-text">*</span></label>
                              <input type="email" class="fstinput" placeholder="Valid Email" name="online_email" id="online_email<?php echo $package_id; ?>" value="<?php if (isset($this->session->userdata('student_login_data')->email)) {
                                                                                                                                                                      echo $this->session->userdata('student_login_data')->email;
                                                                                                                                                                    } else {
                                                                                                                                                                      echo "";
                                                                                                                                                                    } ?>" onblur="validate_complaint_email(this.value)" maxlength="60" <?php echo $readOnly; ?> autocomplete="off">
                              <div class="validation font-11 red-text online_email_error<?php echo $package_id; ?>"></div>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                              <lable>Date Of Birth<span class="text-red">*</span></lable>
                              <div class="has-feedback">
                              <input type="text" data-inputmask="'alias': 'dd-mm-yyyy'" class="fstinput form-control dob_mask" name="dob" id="dob<?php echo $package_id; ?>" placeholder="dd-mm-yyyy" autocomplete="off" onchange="checkdob(this.value,this.id)"  value="<?php if(isset($this->session->userdata('student_login_data')->dob)) {   echo $this->session->userdata('student_login_data')->dob; } else { echo "";}?>"  placeholder="DOB*" maxlength="10" autocomplete='off'  <?php echo $readOnly_dis;?>>
                                <span class="fa fa-calendar form-group-icon"></span>
                                <div class="validation font-11 red-text dob<?php echo $package_id; ?>_err"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="step-footer">
                      <ul class="step-steps pull-left">
                        <li data-step-target="step1_<?php echo $p->package_id ?>">1</li>
                        <li data-step-target="step2_<?php echo $p->package_id ?>">2</li>
                        <li data-step-target="step3_<?php echo $p->package_id ?>">3</li>
                      </ul>
                      <span class="pull-right">
                        <span class="pac-price">
                          <?php
                          if ($flag == 1) { ?>
                            <strike> <span class="font-14"><?php echo $price1; ?>&nbsp;<?php echo $currency_code; ?> </span></strike>
                          <?php   }  ?>
                          <span class="price"><?php echo $price2; ?><span class="font-14"> <?php echo $currency_code; ?> </span></span>
                        </span>
                        <span> <button data-step-action="prev" class="btn btn-back btn-mdl step-btn">Back</button></span>
                        <span><button data-step-action="next" data-packid="<?php echo $p->package_id ?>" class="btn btn-red btn-mdl step-btn customnext" id="d_<?php echo $p->package_id ?>">Next</button></span>
                        <span>
                          <button data-step-action="finish" class="btn btn-red btn-mdl step-btn font-bold" onclick="return check_booking(<?php echo $package_id; ?>);" >Checkout</button></span>

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


            <?php }} else { ?>
<?php echo $OnlinePack->error_message->message; ?>
<?php } ?>
              <script type="text/javascript">
                 $('.selectpicker').selectpicker('refresh')  
              $('.datepicker').datepicker({
                format: "dd-mm-yyyy"
            });
              
            </script>
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
                $('#batch_option_' + packid).html(data);
                $('.selectpicker').selectpicker('refresh')
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
         /*  $('.datepicker').datepicker({
            format: "dd-mm-yyyy"
          }); */
        </script>
        <script type="text/javascript">
$(".dob_mask:input").inputmask();
function setpackid(x)
  {
    $('#hidpackageid').val(x)
  }  
  function checkdob(data, id)
   {
   // alert(data)
    var idd = '.' + id + '_err';
    var dt = data.split("-");
    if (dt[1] == '02') {
      if (dt[0] > 29) {
      //  $('.dob_mask').focus();
        $(idd).text('Invalid Date format');
        return false;
      } else {
        $(idd).text('');
      }
    }
    var pattern = /^([0-9]{2})\-([0-9]{2})\-([0-9]{4})$/;
    if (pattern.test(data) == false) {
     // $('.dob_mask').focus();
      $(idd).text('Invalid Date format');
      return false;
    } else {
      $(idd).text('');
    }
  }
  </script>