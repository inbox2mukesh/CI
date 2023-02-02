<section class="lt-bg-lighter">
  <div class="container">
    <div class="content-wrapper">
      <!-- Left sidebar -->
      <?php include('includes/student_profile_sidebar.php'); ?>
      <!-- End Left sidebar -->
      <!-- Start Content Part -->

      <div class="content-aside dash-main-box">
        <span class="top-btn">
          <button type="submit" class="btn btn-update-img text-uppercase launch-modal" data-toggle="modal" data-target="#modal-changeprofilepic">Update Profile Photo</button>
          <button type="submit" class="btn btn-blue text-uppercase launch-modal" data-toggle="modal" data-target="#modal-md">change password</button>
        </span>
        <div class="top-title mb-15 text-uppercase  mb-top-30 mob-top-20">
          <?php echo $title1; ?> <span class="text-theme-color-2 font-weight-500"><?php echo $title2; ?></span></div>
        <div class="lt-clr-box">
          <?php
          if ($stdInfo->error_message->data->profileUpdate == 1) {
            $disabledFields = 'disabled="disabled" ';
            $readonlyfield = "readonly";
          } else {
            $disabledFields = '';
            $readonlyfield = "";
          }
          ?>
          <?php echo $this->session->flashdata('flsh_msg'); ?>
          <?php echo form_open('our_students/update_profile', array('name' => 'update-form', 'class' => 'mb-0')); ?>
          <div class="form-row clearfix">
            <div class="form-group col-md-4">
              <label>First Name<span class="red-text">*</span></label>
              <input type="text" class="fstinput" id="fname" name="fname" value="<?php echo $stdInfo->error_message->data->fname; ?>" maxlength="30" <?php echo $disabledFields; ?> <?php if ($stdInfo->error_message->data->fname != "") { ?>readonly<?php } ?> autocomplete="off">
              <div class="validation fname_err"><?php echo form_error('fname'); ?></div>
            </div>
            <div class="form-group col-md-4">
              <label>Last Name</label>
              <input type="text" class="fstinput" id="lname" name="lname" value="<?php echo $stdInfo->error_message->data->lname;; ?>" maxlength="30" <?php echo $disabledFields; ?> autocomplete="off" <?php if ($stdInfo->error_message->data->lname != "") { ?>readonly<?php } ?>>
              <div class="validation lname_err"><?php echo form_error('fname'); ?></div>
            </div>
            <div class="form-group col-md-4">
              <label>Gender<span class="red-text">*</span></label>
              <select class="selectpicker form-control" id="gender" name="gender" data-show-subtext="true" data-live-search="true" <?php echo $disabledFields; ?>>
                <option value="">Choose Gender</option>
                <?php
                foreach ($allGenders->error_message->data as $p) {
                  $selected = (($p->id == $stdInfo->error_message->data->gender || $p->id == $this->input->post('gender'))) ? ' selected="selected"' : "";
                  echo '<option value="' . $p->id . '" ' . $selected . ' >' . $p->gender_name . '</option>';
                }
                ?>
              </select>
              <div class="validation gender_err"><?php echo form_error('gender'); ?></div>
            </div>
            <div class="form-group col-md-4">
              <label>Date of Birth<span class="red-text">*</span></label>
              <div class="has-feedback">
                <!-- <input  name="dob" id="dob" type="text" class="fstinput dob_mask" data-inputmask="'alias': 'date'" placeholder="dd/mm/yyyy"  value="<?php echo $stdInfo->error_message->data->dob; ?>" maxlength="10" autocomplete='off' readonly="readonly">  -->
                <input name="dob" id="dob" type="text" class="fstinput dob_mask" data-inputmask="'alias': 'date'" placeholder="dd/mm/yyyy" maxlength="10" autocomplete='off' value="<?php echo $this->session->userdata('student_login_data')->dob; ?>" onchange="checkdob(this.value,this.id)" <?php if($this->session->userdata('student_login_data')->dob!=""){ echo "readonly";}?>>
                <span class="fa fa-calendar form-group-icon"></span>
              </div>
              <div class="validation dob_err"><?php echo form_error('dob'); ?></div>
            </div>
            <div class="form-group col-md-4">
              <?php
              $c = $stdInfo->error_message->data->country_code;
              $abs_dis = ($stdInfo->error_message->data->country_code == '') ? '' : 'disabled';
              ?>
              <label>Country Code<span class="red-text">*</span></label>
              <select class="selectpicker form-control" data-live-search="true" name="country_code" id="country_code" <?php echo $disabledFields; ?> <?php echo $abs_dis; ?>>
                <option value="">Choose Country Code </option>
                <?php

                foreach ($countryCode->error_message->data as $p) {
                  $sel = "";
                  if ($p->country_code == $stdInfo->error_message->data->country_code and $p->iso3 == $stdInfo->error_message->data->country_iso3_code) {
                    $sel = "selected";
                  }
                ?>
                  <option value="<?php echo $p->country_code . '|' . $p->iso3; ?>" <?php echo $sel; ?>><?php echo $p->country_code . '- ' . $p->iso3; ?></option>
                <?php
                } ?>
              </select>
            </div>
            <?php //print_r($stdInfo->error_message->data)
            ?>
            <div class="form-group col-md-4">
              <label>Mobile Number<span class="red-text">*</span></label>
              <input type="text" class="fstinput" id="mobile" name="mobile" value="<?php echo $stdInfo->error_message->data->mobile; ?>" maxlength="10" disabled="disabled" autocomplete="off">
            </div>
            <div class="form-group col-md-4">
              <label>Email<span class="red-text">*</span></label>
              <input type="email" class="fstinput" value="<?php echo $stdInfo->error_message->data->email; ?>" maxlength="60" disabled="disabled" autocomplete="off">
            </div>
            <div class="form-group col-md-4">
              <label>Zip Code<span class="red-text">*</span></label>
              <?php
              if ($stdInfo->error_message->data->zip_code != '') {
                $dis = 'readonly';
              } else {
                $dis = "";
              }

              ?>
              <input type="text" class="fstinput" value="<?php echo ($stdInfo->error_message->data->zip_code != '') ? $stdInfo->error_message->data->zip_code : $this->input->post('zip_code'); ?>" autocomplete="off" name="zip_code" maxlength="10" id="zip_code" <?php echo $dis; ?>>
              <div class="validation zip_code_err"><?php echo form_error('zip_code'); ?></div>
            </div>

            <div class="form-group col-md-4">
              <label>Country<span class="red-text">*</span></label>
              <select class="selectpicker form-control " data-live-search="true" name="stu_country" id="stu_country" <?php echo $disabledFields; ?>>
                <option value="">Choose Country</option>
                <?php
                foreach ($allcountry->error_message->data as $p) {
                  $selected = ($p->country_id == $stdInfo->error_message->data->country_id || $p->country_id == $this->input->post('stu_country')) ? ' selected="selected"' : "";
                  echo '<option value="' . $p->country_id . '" ' . $selected . '>' . $p->name . '</option>';
                }
                ?>
              </select>
              <div class="validation stu_country_err"><?php echo form_error('stu_country'); ?></div>
            </div>
            <div class="form-group col-md-4">
              <label>State<span class="red-text">*</span></label>
              <select class="selectpicker form-control" data-live-search="true" name="stu_state" id="stu_state" <?php echo $disabledFields; ?>>
                <option value="">Choose State</option>

                <?php
                foreach ($allstate->error_message->data as $p) {
                  $selected = ($p->state_id == $stdInfo->error_message->data->state_id || $p->state_id == $this->input->post('stu_state')) ? ' selected="selected"' : "";
                ?>
                  <option value="<?php echo $p->state_id ?>" <?php echo $selected; ?>><?php echo $p->state_name ?></option>
                <?php } ?>

                ?>
              </select>
              <div class="validation stu_state_err"><?php echo form_error('stu_state'); ?></div>
            </div>
            <div class="form-group col-md-4">
              <label>City<span class="red-text">*</span></label>
              <select class="selectpicker form-control" data-live-search="true" name="stu_city" id="stu_city" <?php echo $disabledFields; ?>>
                <option value="">Choose City</option>
                <?php
                foreach ($allcity->error_message->data as $p) {
                  $selected = ($p->city_id == $stdInfo->error_message->data->city_id || $p->city_id == $this->input->post('stu_city')) ? ' selected="selected"' : "";
                ?>
                  <option value="<?php echo $p->city_id ?>" <?php echo $selected; ?>><?php echo $p->city_name ?></option>
                <?php } ?>
              </select>
              <div class="validation stu_city_err"><?php echo form_error('stu_city'); ?></div>
            </div>

            <div class="form-group col-md-12">
              <label>Permanent Address<span class="red-text">*</span> </label>
              <textarea class="form-control" rows="3" name="residential_address" id="residential_address" style="height: inherit!important;"><?php echo ($stdInfo->error_message->data->residential_address != '') ? $stdInfo->error_message->data->residential_address : $this->input->post('residential_address'); ?></textarea>
            </div>
            <div class="form-group col-md-12 font-12"> <span class="red-text">Note:</span> You can only change this information one time, If you would like any changes, please contact admission team. </div>
            <?php
            if ($stdInfo->error_message->data->profileUpdate == 0) {
            ?>
              <div class="form-group col-md-12 text-right">
                <button type="submit" class="btn btn-black">UPDATE</button>
              </div>
            <?php } ?>
          </div>
          </form>
        </div>
      </div>
      <!-- End Content Part -->
    </div>
  </div>
</section>
</div>
</div>
</div>
<?php include('change_password.php');
include('update_profilepic.php'); ?>

<script src="<?php echo site_url('resources-f/'); ?>js/date-mask.js"></script>
<script type="text/javascript">
  $(".dob_mask:input").inputmask();

  $('#stu_country').change(function() {
    var id = $(this).val();
    if (id != "") {
      $.ajax({
        url: "<?php echo site_url('our_students/ajax_get_state'); ?>",
        type: 'post',
        data: {
          id: id
        },
        success: function(response) {
          $('#stu_state').html(response);
          $('#stu_state').selectpicker('refresh');
          $("#stu_state").trigger("change");
        },
        beforeSend: function() {
          // $('.complaintBtnDiv_pro').show(); 
          //  $('#reg_button').prop('disabled', true);
        }
      });

    }

  });
  $('#stu_state').change(function() {
    var id = $(this).val();
    if (id != "") {
      $.ajax({
        url: "<?php echo site_url('our_students/ajax_get_city'); ?>",
        type: 'post',
        data: {
          id: id
        },
        success: function(response) {
          $('#stu_city').html(response);
          $('#stu_city').selectpicker('refresh');
        },
        beforeSend: function() {
          // $('.complaintBtnDiv_pro').show(); 
          //  $('#reg_button').prop('disabled', true);
        }
      });
    }
  });

  function checkdob(data, id) {
    var idd = '.' + id + '_err';
    //ert(data)
    var dt = data.split("/");
    //if(dt[1])
    if (dt[1] == '02') {
      if (dt[0] > 29) {
        //$('.dob_mask').focus();
        $(idd).text('Invalid Date format');
        return false;
      } else {
        $(".regdob_err").text('');
      }
    }
    var pattern = /^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
    if (pattern.test(data) == false) {
      // $('.dob_mask').focus();
      $(idd).text('Invalid Date format');
      return false;
    } else {
      $(idd).text('');
    }
  }
</script>