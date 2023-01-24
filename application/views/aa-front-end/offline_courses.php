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
    <div class="fltr-row-5clmn">
          <div class="col">
          <div class="form-group">
            <select class="selectpicker form-control" data-live-search="true" name="center_id" id="center_id" onchange="GetOfflinePack();">
              <option value="">Select Branch</option>
              <?php
                 foreach($allOfflineCourseBranch->error_message->data as $p){                            
    ?>  
    <option value="<?php echo $p->center_id;?>"><?php echo $p->center_name;?></option> 
    <?php } ?>
            </select>
          </div>
          <!--          <div class="validation">Wrong!</div>-->
        </div>
           
          <div class="col">
            <div class="form-group">
              <select class="selectpicker form-control" data-live-search="true" name="test_module_id" id="test_module_id" onchange="GetOfflinePack();disableEnablepgm(this.value);" disabled="disabled">
                <option value="">Select Course</option>             
                <?php
                foreach($allOfflineCourseTestModule->error_message->data as $p)
                {                          
                ?>
                <option value="<?php echo $p->test_module_id;?>"><?php echo $p->test_module_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <select class="selectpicker form-control" data-live-search="true" name="programe_id" id="programe_id" onchange="GetOfflinePack();Getcategory();" disabled="disabled">
                <option value="">Select Course Type</option>
                <?php
                foreach($allOfflineCoursePgm->error_message->data as $p){                              
                ?>
                <option value="<?php echo $p->programe_id;?>"><?php echo $p->programe_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <select class="selectpicker form-control" name="duration" id="duration" onchange="GetOfflinePack();" disabled="disabled"data-live-search="true" >
                <option value="">Select Duration</option>
                
                <?php
                foreach($allOfflineCourseDuration->error_message->data as $p){                            
                ?>
                <option value="<?php echo $p->duration;?>"><?php echo $p->duration;?> <?php echo $p->duration_type;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <select class="selectpicker form-control catOption" name="category_id" id="category_id" onchange="GetOfflinePack();" disabled="disabled">
               <option value=''>All Module</option>
              </select>
            </div>
          </div>
        </div>
    <div class="sp-12" id="flter-btm-info">

      <span class="text-left font-weight-600 pull-left  loader_load_data" id="up"> <i class="fa fa-spinner fa-spin mr-10"></i> Showing All | Adjust Filters to change the view </span>
      <span class="pull-right font-weight-600" id="down"><a href="">Clear All </a></span>
    </div>
    <!---EndFilter--->
  </div>
</section>
<!---Modal Info-->
<script src="<?php echo site_url('resources-f/js/jquery-steps.js'); ?>"></script>
<script src="<?php echo site_url('resources-f/'); ?>js/date-mask.js"></script>
<section>
  <div class="container">
    <!--START GRID CONTAINER-->
    <div class="grid-container">
      <div class="grid-flex-cont4 onlinePackResultDiv">
        <?php
        foreach ($OfflinePack->error_message->data as $p) {
          $package_id = $p->package_id;
          $test_module_id = $p->test_module_id;
          $programe_id = $p->programe_id;
          $center_id = $p->center_id;
          $currency_code = $p->currency_code;
          $category_id = $p->category_id;
          $country_id = $p->country_id;

          $img = site_url('resources-f/images/courses/course-1.jpg');
          $test_module_name = $p->test_module_name;
          if ($test_module_name == IELTS_CD or $test_module_name == IELTS) {
            $programe_name = ' | ' . $p->programe_name;
          } else {
            $programe_name = '';
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
         
          <div class="grid-card-container mt-10">
            <div class="grid-card">
              <div class="service-block bg-white mb-20">
                <a href="#" data-toggle="modal" data-target="#onlinecoursemodel<?php echo $p->package_id ?>" data-keyboard="false" data-backdrop="static" class="onlinecard" onclick="setpackid('<?php echo $p->package_id ?>')">
                  <div class="thumb"> <img alt="featured project" src="<?php echo site_url(); ?>uploads/package_file/<?php echo $p->image; ?>" class="img-responsive img-fullwidth"> <span class="title"><?php echo $package_name; ?></span> </div>
                  <div class="content clearfix font-14 font-weight-500">
                    <div class="disc">
                      <h3><?php echo $test_module_name . $programe_name; ?></h3>
                      <p><span class="font-weight-600">Module:</span> <span class="font-12"><?php echo $category_name; ?></span> </p>
                      <p><span class="font-weight-600">Duration:</span> <?php echo $p->duration; ?> <?php echo $p->duration_type; ?></p>
                      <?php
                      if ($flag == 1) { ?>
                        <p><span class="font-weight-600"> Price: </span> <?php echo $currency_code; ?> <strike><?php echo $price1; ?></strike></p>
                      <?php   }  ?>

                    </div>
                    <div class="ftr-btm text-center"> <span class="more-info pull-left">More Info</span> <span class="purchase font-weight-600 pull-right">Buy Now: <span class="text-red"><?php echo $currency_code; ?></span> <span class="font-16 text-red"><?php echo $price2; ?></span> </span>
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
                <form action="#" method="post" enctype="multipart/form-data" id="onlinecourseform<?php echo $package_id ?>" >
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
                          <div class="form-group">
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
                        <li  data-step-target="step3_<?php echo $p->package_id ?>">3</li>
                      </ul>
                      <span class="pull-right">
                        <span class="pac-price">
                          <?php
                          if ($flag == 1) { ?>
                            <strike><?php echo $price1; ?> <span class="font-14"><?php echo $currency_code; ?> </span></strike>
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
      </div>
    </div>
    <!--END GRID CONTAINER-->
  </div>
</section>
<script id="rendered-js">
  $(".dob_mask:input").inputmask();
</script>
<script type="text/javascript">
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
        $('.dob_mask').focus();
        $(idd).text('Invalid Date format');
        return false;
      } else {
        $(idd).text('');
      }
    }
    var pattern = /^([0-9]{2})\-([0-9]{2})\-([0-9]{4})$/;
    if (pattern.test(data) == false) {
      $('.dob_mask').focus();
      $(idd).text('Invalid Date format');
      return false;
    } else {
      $(idd).text('');
    }
  }
</script>
<script type="text/javascript">
  function disableEnablepgm(test_module_id) {
       //1,2,6 ielts- 3,4 pte,spoken
    if (test_module_id == 1 || test_module_id == 2 || test_module_id == 6) {

      $('#programe_id').prop('selectedIndex', 0);
      $('#programe_id').prop('disabled', false);
      $('.selectpicker').selectpicker('refresh')

    } else if (test_module_id == 3 || test_module_id == 4) {

      $('#programe_id').prop('selectedIndex', 1);
      $('#programe_id').prop('disabled', true);
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


  function Getcategory(){

var test_module_id  = $("#test_module_id").val();
var programe_id     = $("#programe_id").val();
if(test_module_id && programe_id){
  
  $.ajax({
    url: "<?php echo site_url('offline_courses/Getcategory');?>",
    async : true,
    type: 'post',
    data: {test_module_id: test_module_id, programe_id: programe_id},
    success: function(data){
      $('#category_id').html(data);     
       $('.catOption').selectpicker('refresh');              
    },
    beforeSend: function(){
           
    },
  });

}else{
  //$('.catOption').html('');
   //$('.catOption').selectpicker('refresh'); 
}    

}

function GetOfflinePack(){    

var center_id       = $("#center_id").val();
var test_module_id  = $("#test_module_id").val();
var programe_id     = $("#programe_id").val();
var category_id     = $("#category_id").val();
var duration        = $("#duration").val();
if(center_id){      
  $('#test_module_id').prop('disabled', false);
  $('#programe_id').prop('disabled', false);
  $('#category_id').prop('disabled', false);
  $('#duration').prop('disabled', false);
  $('.selectpicker').selectpicker('refresh')   
}else{
  $('#test_module_id').prop('disabled', true);
  $('#programe_id').prop('disabled', true);
  $('#category_id').prop('disabled', true);
  $('#duration').prop('disabled', true);
  $('.selectpicker').selectpicker('refresh')   
 
}
$.ajax({
    url: "<?php echo site_url('offline_courses/GetOfflinePack');?>",
    async : true,
    type: 'post',
    data: {center_id: center_id, test_module_id: test_module_id, programe_id: programe_id, category_id: category_id, duration: duration},
    success: function(data){
      //alert(data) 
      if(data!=''){
          $('.loader_load_data').addClass('hide');
        $('.onlinePackResultDiv').html(data);
      }else{
          $('.loader_load_data').addClass('hide');
        $('.onlinePackResultDiv').html(data);
      }          
    },
    beforeSend: function(){
       $('.loader_load_data').removeClass('hide');
    },
});

}
  function GetOnlinePack() {

    var test_module_id = $("#test_module_id").val();
    var programe_id = $("#programe_id").val();
    var category_id = $("#category_id").val();
    var duration = $("#duration").val();

    if (test_module_id) {
      $('#programe_id').prop('disabled', false);
      $('#duration').prop('disabled', false);
      $('#category_id').prop('disabled', false);
      $('.selectpicker').selectpicker('refresh')
    } else {
      $('#programe_id').prop('disabled', true);
      $('#duration').prop('disabled', true);
      $('#category_id').prop('disabled', true);
      $('.selectpicker').selectpicker('refresh')
    }

    if (!test_module_id && !programe_id && !category_id && !duration) {
      //alert('no');
      $('.onlinePackResultDiv').html('');
      $('.no-res').show();
      $('.success-res').hide();
    } else {
      $.ajax({
        url: "<?php echo site_url('online_courses/GetOnlinePack'); ?>",
        async: true,
        type: 'post',
        data: {
          test_module_id: test_module_id,
          programe_id: programe_id,
          category_id: category_id,
          duration: duration
        },
        success: function(data) {
          //alert(data)
          if (data != '') {
            $('.loader_load_data').addClass('hide');
            /*$('.processing-res').hide();
            $('.success-res').show();*/
            $('.onlinePackResultDiv').html(data);
          } else {
            $('.loader_load_data').addClass('hide');
            /*$('.processing-res').hide();
            $('.no-res').show();
            $('.success-res').hide();*/
            $('.onlinePackResultDiv').html(data);
          }
        },
        beforeSend: function() {

          $('.loader_load_data').removeClass('hide');
          $('.loader_load_data').text('Loading...Please Wait');
          /* $('.processing-res').show();
          $('.success-res').hide();
          $('.failed-res').hide();
          $('.no-res').hide(); */
        },
      });
    }


  }

  function check_booking(package_id) {

    //alert(package_id)
    //return false;

    var numberes = /^[0-9-+]+$/;
    var letters = /^[A-Za-z ]+$/;
    var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
    
    //var package_id = $("#package_id").val();
    var fname = $("#online_fname" + package_id).val();
    var onlineemail = $("#online_email"+package_id).val();
    var mobile = $("#onlinec_mobile" + package_id).val();
    var country_code = $("#online_country_code" + package_id).val();
    var dob = $("#dob" + package_id).val();
   
    if (fname.match(letters)) {
      $(".online_fname_error" + package_id).text('');
    } else {
      $("#online_fname" + package_id).focus();
      $(".online_fname_error" + package_id).text("Please enter valid Name. Numbers not allowed!");
      return false;
    }

    if (mobile.length > 10 || mobile.length < 10) {
      $("#online_mobile" + package_id).focus();
      $(".online_mobile_error" + package_id).text('Please enter valid Number of 10 digit');
      return false;
    } else {
      $(".online_mobile_error" + package_id).text('');
    }
 
    if(onlineemail == "")
    {
      
       $(".online_email_error" + package_id).text('Please enter Email Id');
      return false;
    }
    
    if (onlineemail.match(mailformat)) {
      $(".online_email_error" + package_id).text('');
    } else {
      $("#online_email" + package_id).focus();
      $(".online_email_error" + package_id).text('Please enter valid Email Id');
      return false;
    }

    if (dob == "") {
      $("#dob" + package_id).focus();
      $(".onldob_error" + package_id).text('Please select dob');
      return false;
    } else {
      $(".onldob_error" + package_id).text('');
    }
  
    if (country_code == "") {
      $("#online_country_code" + package_id).focus();
      $(".online_country_code_error" + package_id).text('Please select country code');
      return false;
    } else {
      $(".online_country_code_error" + package_id).text('');
    }

   
    var form = $("#onlinecourseform" + package_id);
alert(package_id);

    $.ajax({
      url: "<?php echo site_url('booking/check_booking'); ?>",
      type: 'post',
      data: form.serialize(),
      success: function(response) {
      
        alert(response.status)
        if (response.status == 'true') {
          $('#onlinecoursemodel' + package_id).modal('hide');
          $('#modal-reg-OTP').modal('show');
        } 
       else if (response.status ==1) {
          $('#onlinecoursemodel' + package_id).modal('hide');
          $('#modal-reg-OTP').modal('show');
        }
        else if (response.status == 2) {
          
          $('#onlinecoursemodel' + package_id).modal('hide');
          $('#modal-login').modal('show');

        } else if (response.status == 3) {
          window.location.href = "<?php echo site_url('booking/checkout'); ?>"

        } else {
          $('#checkout_btn' + package_id).prop('disabled', false);
          $('#regmain_msg_danger' + package_id).html(response.msg);
          $(".anc_clickhere").focus();
          //$('.regsub_button').hide();
        } 
      },
      beforeSend: function() {
        $('#checkout_btn' + package_id).prop('disabled', true);
      }
    });
  }

  function validate_complaint_email(email) {

    var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
    if (email.match(mailformat)) {
    //  $(".dc_email_error").text('');
      // $('.complaintBtn').prop('disabled', false);
      return true;
    } else {
      //$(".dc_email_error").text("Please enter valid email Id!");
      //$('#dc_email').focus();
      // $('.complaintBtn').prop('disabled', true);
      return false;
    }
  }

  function anc_clickhere(pid) {
    $('#onlinecoursemodel' + pid).modal('hide');
    $('#dc_email').focus();
  }
</script>