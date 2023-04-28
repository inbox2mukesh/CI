<style type="text/css">
    input[type="checkbox"][readonly] {
        pointer-events: none;
    }
</style>
<div class="student-edit_widget">
    <?php
        $tomarrow = '';
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <?php $wallet = CURRENCY . ' ' . number_format($student['wallet'] / 100, 2); ?>
                    <h3 class="box-title"><?php //echo $title;?>
                        <?php
                        if ($student['student_identity'] != '') {
                            echo ' <span class="text-info">[ ' . $student['student_identity'] . ' ]</span>';
                        } else {
                            echo '<span class="small">[Not Enrolled yet!]</span>';
                        }
                        ?>
                        <?php echo SEP; ?>
                        <?php
                        if ($student['UID'] != '') {
                            echo ' <span class="text-blue">UID: ' . $student['UID'] . '</span>';
                        } else {
                            echo '<span class="small">...</span>';
                        }
                        ?>
                        <?php echo SEP; ?>
                        <?php echo $student['fname'] . ' ' . $student['lname']; ?>
                    </h3>
                    <div class="box-tools pull-right">
                        <?php
                        if ($this->Role_model->_has_access_('student', 'index')) {
                        ?>
                            <a href="<?php echo site_url('adminController/student/index') ?>" class="btn btn-success btn-sm">Student List</a>
                        <?php } ?>
                        <?php
                        if ($this->Role_model->_has_access_('student', 'student_full_details_')) {
                        ?>
                            <a href="<?php echo site_url('adminController/student/student_full_details_/' . base64_encode($student['id'])) ?>" class="btn btn-info btn-sm">Profile</a>
                        <?php } ?>
                        <?php
                            if($this->Role_model->_has_access_('student', 'add_document_')) {
                        ?>
                            <a href="javascript:void(0)" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-doc" name="<?php echo $student['id']; ?>" id="<?php echo $student['id']; ?>" title="Add new document"><span class="fa fa-plus"></span> &nbsp;Add Student Document</a>
                        <?php } ?>
                        <?php
                            if($this->Role_model->_has_access_('student', 'getWaiverHistory_')) {
                        ?>
                        <a href="javascript:void(0)" class="btn btn-success btn-sm" data-toggle="modal"
                            data-target="#modal-waiver-history" name="<?php echo $student['id']; ?>"
                            id="<?php echo $student['id']; ?>" title="Waiver History"
                            onclick="getWaiverHistory(this.id);"><span class="fa fa-arrow-down"></span> &nbsp;Waiver
                            History</a>
                        <?php } ?>
                        <?php
                            if($this->Role_model->_has_access_('student', 'getRefundHistory_')) {
                        ?>
                             <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-refund-history" name="<?php echo $student['id']; ?>" id="<?php echo $student['id']; ?>" title="Refund History" onclick="getRefundHistory(this.id);"><span class="fa fa-arrow-up"></span> &nbsp;Refund
                                History</a>
                        <?php } ?>
                        <?php
                        if ($this->Role_model->_has_access_('student', 'getWalletTransactionHistory_')) {
                        ?>
                             <a href="javascript:void(0)" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-Withdrawl" name="<?php echo $student['id']; ?>" id="<?php echo $student['id']; ?>" title="Withdrawl" onclick="getWalletTransactionHistory(this.id);"><?php echo $wallet; ?> &nbsp;/ Wallet</a>
                        <?php } ?>
                    </div>
                </div>
                <?php echo $this->session->flashdata('flsh_msg'); ?>
                <?php echo form_open_multipart('adminController/student/edit/' . base64_encode($student['id']), array('onsubmit' => 'return validate_form();')); ?>
                <div class="box-body" style="padding:10px;">
                    <div class="flex-auto clearfix">
                        <input type="hidden" id="wallet" name="wallet" value="<?php echo $student['wallet'] / 100; ?>">
                        <div class="col-md-3">
                            <label for="service_id" class="control-label"><span class="text-danger">*</span>Student's
                                Status</label>
                            <div class="form-group">
                                <select name="service_id" id="service_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="GetService2(this.value)">
                                    <option value="">Select Student Status</option>
                                    <?php
                                    foreach ($all_services as $t) {
                                        $selected = ($t['service_id'] == $student['service_id']) ? ' selected="selected"' : "";
                                        echo '<option value="' . $t['service_id'] . '" ' . $selected . '>' . $t['service_name'] . ' - ' . $t['short_code'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('service_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="profile_pic" class="control-label">Profile Pic</label>
                            <?php echo PROFILE_PIC_ALLOWED_TYPES_LABEL; ?>
                            <div class="form-group">
                                <input type="file" name="profile_pic" value="<?php echo ($this->input->post('profile_pic') ? $this->input->post('profile_pic') : $student['profile_pic']); ?>" class="form-control input-file-ui-100 input-file-ui" id="profile_pic" onchange="student_profile_pic_validation();" />
                                <span class="text-danger profile_pic_err" style="margin-top:-3px;"></span>
                                <span style="position:absolute;margin-top:2px;">
                                    <?php
                                    if (isset($student['profile_pic'])) {
                                        echo '<span>
                                                <a href="' . site_url($student['profile_pic']) . '" target="_blank">View Profile Pic</a>
                                                <input type="hidden" value="'.$student['profile_pic'].'" name="hid_profile_pic"/>
                                            </span>';
                                    } else {
                                        echo NO_FILE;
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="source_id" class="control-label">Source</label>
                            <div class="form-group">
                                <select name="source_id" id="source_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
                                    <option value="">Select Source</option>
                                    <?php
                                    foreach ($all_source as $b) {
                                        $selected = ($b['id'] == $student['source_id']) ? ' selected="selected"' : "";
                                        echo '<option value="' . $b['id'] . '" ' . $selected . '>' . $b['source_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('source_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="gender_name" class="control-label"><span class="text-danger">*</span>Gender</label>
                            <div class="form-group">
                                <select name="gender_name" class="form-control selectpicker selectpicker-ui-100">
                                    <option value="">Select gender</option>
                                    <?php
                                    foreach ($all_genders as $g) {
                                        $selected = ($g['id'] == $student['gender']) ? ' selected="selected"' : "";
                                        echo '<option value="' . $g['id'] . '" ' . $selected . '>' . $g['gender_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('gender_name'); ?></span>
                            </div>
                        </div>
                        <?php
                        if ($student['email'] != '') {
                            $readOnly = 'readonly="readonly"';
                        } else {
                            $readOnly = '';
                        }
                        ?>
                        <div class="col-md-3">
                            <label for="email" class="control-label">Email Id</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="email" value="<?php echo ($this->input->post('email') ? $this->input->post('email') : $student['email']); ?>" class="form-control input-ui-100" id="email" maxlength="60" <?php echo $readOnly; ?> onblur="check_std_email_availibility(this.value);" />
                                <span class="glyphicon glyphicon-envelope form-control-feedback text-info"></span>
                                <span class="text-danger val_err"><?php echo form_error('email'); ?></span>
                            </div>
                        </div>
                        <input type="hidden" name="country_code_hidden" id="country_code_hidden" value="<?php echo $student['country_code'];?>">
                        <div class="col-md-3">
                            <label for="country_code" class="control-label"><span class="text-danger">*</span>Country
                                code</label>
                            <div class="form-group">
                                <select name="country_code" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" disabled="disabled">
                                    <option value="">Select Country code</option>
                                    <?php
                                    foreach ($all_country_code as $b) {
                                        $selected = ($b['country_code'] == $student['country_code']) ? ' selected="selected"' : "";
                                        echo '<option value="' . $b['country_code'] . '" ' . $selected . '>' . $b['iso3'] . ' - ' . $b['country_code'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="mobile" class="control-label"><span class="text-danger">*</span>Mobile no.</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="mobile" value="<?php echo ($this->input->post('mobile') ? $this->input->post('mobile') : $student['mobile']); ?>" class="form-control chknum1 input-ui-100" id="mobile" maxlength="10" minlength="10" readonly="readonly" />
                                <span class="glyphicon glyphicon-phone form-control-feedback text-info"></span>
                            </div>
                        </div>
                        <div class="col-md-3">                            
                            <label for="fname" class="control-label"><span class="text-danger">*</span>First name</label>
                            <div class="form-group">
                                <input type="text" name="fname" value="<?php echo ($this->input->post('fname') ? $this->input->post('fname') : $student['fname']); ?>" class="form-control input-ui-100" id="fname" onblur="validate_fname(this.value);" maxlength="25" autocomplete="off" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" <?php if($student['fname'] !="")
                            {?>readonly <?php }?> />
                                <span class="text-danger fname_err"><?php echo form_error('fname'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="lname" class="control-label">Last name</label>
                            <div class="form-group">
                                <input type="text" name="lname" value="<?php echo ($this->input->post('lname') ? $this->input->post('lname') : $student['lname']); ?>" class="form-control input-ui-100" id="lname" onblur="validate_lname(this.value);" maxlength="25" autocomplete="off" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" <?php if($student['lname'] !="")
                            {?> readonly <?php }?>  />
                                <span class="text-danger lname_err"><?php echo form_error('lname'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="dob" class="control-label">Student DOB <?php echo DATE_FORMAT_LABEL; ?></label>
                            <div class="form-group has-feedback">
                                <input type="text" data-inputmask="'alias': 'date'" class="fstinput form-control dob_mask input-ui-100" name="dob" id="dob" placeholder="dd/mm/yyyy" autocomplete="off" value="<?php echo ($this->input->post('dob') ? $this->input->post('dob') : $student['dob']); ?>">
                                <span class="glyphicon glyphicon-calendar form-control-feedback text-info"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="father_name" class="control-label">Father's name</label>
                            <div class="form-group">
                                <input type="text" name="father_name" value="<?php echo ($this->input->post('father_name') ? $this->input->post('father_name') : $student['father_name']); ?>" class="form-control input-ui-100" id="father_name" onblur="validate_fatname(this.value);" autocomplete="off" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" />
                                <span class="text-danger father_name_err"><?php echo form_error('father_name'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="father_dob" class="control-label">Father's DOB</label>
                            <div class="form-group has-feedback">                                
                                <input type="text" data-inputmask="'alias': 'date'" class="fstinput form-control dob_mask input-ui-100" name="father_dob" id="father_dob" placeholder="dd/mm/yyyy" id="dob" autocomplete="off" value="<?php echo ($this->input->post('father_dob') ? $this->input->post('father_dob') : $student['father_dob']); ?>" onblur="validatefatherdob(this.value,this.id);">
                                <span class="text-danger father_dob_err"></span>
                                <span class="glyphicon glyphicon-calendar form-control-feedback text-info "></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="mother_name" class="control-label">Mother's name</label>
                            <div class="form-group">
                                <input type="text" name="mother_name" value="<?php echo ($this->input->post('mother_name') ? $this->input->post('mother_name') : $student['mother_name']); ?>" class="form-control input-ui-100" id="mother_name" onblur="validate_motname(this.value);" autocomplete="off" onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" />
                                <span class="text-danger father_name_err"><?php echo form_error('mother_name'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="mother_dob" class="control-label">Mother's DOB</label>
                            <div class="form-group has-feedback">                                
                                <input type="text" data-inputmask="'alias': 'date'" class="fstinput form-control dob_mask input-ui-100" name="mother_dob" id="mother_dob" placeholder="dd/mm/yyyy" id="dob" autocomplete="off" value="<?php echo ($this->input->post('mother_dob') ? $this->input->post('mother_dob') : $student['mother_dob']); ?>">
                                <span class="glyphicon glyphicon-calendar form-control-feedback text-info"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="parents_anniversary" class="control-label">Parents Anniv.</label>
                            <div class="form-group has-feedback">                                
                                <input type="text" data-inputmask="'alias': 'date'" class="fstinput form-control dob_mask input-ui-100" name="parents_anniversary" id="parents_anniversary" placeholder="dd/mm/yyyy" autocomplete="off" value="<?php echo ($this->input->post('parents_anniversary') ? $this->input->post('parents_anniversary') : $student['parents_anniversary']); ?>">
                                <span class="glyphicon glyphicon-calendar form-control-feedback text-info"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="gaurdian_contact" class="control-label">Guardian Contact No.</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="gaurdian_contact" value="<?php echo ($this->input->post('gaurdian_contact') ? $this->input->post('gaurdian_contact') : $student['gaurdian_contact']); ?>" class="form-control chknum1 input-ui-100" id="gaurdian_contact" maxlength=10 autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="qualification_id" class="control-label"> Qualification</label>
                            <div class="form-group">
                                <select name="qualification_id" id="qualification_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
                                    <option value="">Select Qualification</option>
                                    <?php
                                    foreach ($allQua as $t) {
                                        $selected = ($t['id'] == $student['qualification_id']) ? ' selected="selected"' : "";
                                        echo '<option value="' . $t['id'] . '" ' . $selected . '>' . $t['qualification_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('qualification_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="int_country_id" class="control-label"> Intrested Country</label>
                            <div class="form-group">
                                <select name="int_country_id" id="int_country_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
                                    <option value="">Select Intrested Country </option>
                                    <?php
                                    foreach ($allCnt as $t) {
                                        $selected = ($t['country_id'] == $student['int_country_id']) ? ' selected="selected"' : "";
                                        echo '<option value="' . $t['country_id'] . '" ' . $selected . '>' . $t['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('int_country_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="residential_address" class="control-label">Permanent Address</label>
                            <div class="form-group">
                                <textarea name="residential_address" class="form-control textarea-ui-16" id="residential_address"><?php echo ($this->input->post('residential_address') ? $this->input->post('residential_address') : $student['residential_address']); ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cred" class="control-label">
                                    <i class="fa fa-info-circle text-info" aria-hidden="true"></i> <span class="text-danger"><?php echo CREDS_NOTES; ?></span></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-checkbox">
                                <input type="checkbox" class="" name="mail_sent" value="1" id="mail_sent" checked="checked" readonly />
                                <label class="control-label">Do you wish to send E-Mail?</label>
                            </div>
                        </div>
                       
                        <div class="col-md-4">
                            <div class="form-group form-checkbox">
                                <input type="checkbox" class="" name="active" value="1" <?php echo ($student['active'] == 1 ? 'checked="checked"' : ''); ?> id='active' readonly />
                                <label class="control-label">Active<span class="text-info">(Means able to
                                        login)</span></label>
                            </div>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-4">
                            <label for="test_module_id" class="control-label"><span class="text-danger">*</span>Intrested in
                                Course</label>
                            <div class="form-group">
                                <select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'studentPage'); fire_change_event();">
                                    <option value="">Select Course</option>
                                    <?php
                                    foreach ($all_test_module as $t) {
                                        $selected = ($t['test_module_id'] == $student['test_module_id']) ? ' selected="selected"' : "";
                                        echo '<option value="' . $t['test_module_id'] . '">' . $t['test_module_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('test_module_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="programe_id" class="control-label"><span class="text-danger">*</span>Intrested in
                                Program</label>
                            <div class="form-group">
                                <select name="programe_id" id="programe_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="fire_change_event();">
                                    <option value="">Select Program</option>
                                </select>
                                <span class="text-danger"><?php echo form_error('programe_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="center_id" class="control-label"><span class="text-danger">*</span>Branch</label>
                            <div class="form-group">
                                <select name="center_id" id="center_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="false" onchange="unsetPackRadio();">
                                    <!-- <option value="">Select Branch</option> -->
                                    <option value="10">ONLINE</option>
                                    <?php
                                    // foreach ($all_branch as $b) {
                                    //     $selected = ($b['center_id'] == $student['center_id']) ? ' selected="selected"' : "";
                                    //     echo '<option value="' . $b['center_id'] . '" >' . $b['center_name'] . '</option>';
                                    // }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('center_id'); ?></span>
                            </div>
                        </div>

                        <?php 
                        if (DEFAULT_COUNTRY == 101) {
                            $verfiled_field=$student['is_otp_verified'];
                        }
                        else {
                            $verfiled_field=$student['is_email_verified'];
                        }
                        
                        if ($verfiled_field == 1 and $student['active'] == 1) { ?>
                            <?php /*if ($userPhysicalBranch == 1 and $this->Role_model->_has_access_('student','sell_inhouse_pack_')) { ?>
                                <?php if(WOSA_ONLINE_DOMAIN==1){ ?>
                                    <div class="col-md-2 radiCourse">
                                        <div class="form-group">
                                            <input type="radio" name="pack_cb" id="offline_cb" value='offline' class='ppp radio-btn-ui' />
                                            <label for="offline_cb" class="control-label">Inhouse Pack?</label>
                                        </div>
                                    </div><?php } ?>
                                <?php } */?>

                            <?php if ($userVirtualBranch == 1 and $this->Role_model->_has_access_('student', 'sell_online_pack_')) { ?>
                                <div class="col-md-2 radiCourse">
                                    <div class="form-group">
                                        <input type="radio" name="pack_cb" id="online_cb" value='online' class="ppp" />
                                        <label for="online_cb" class="control-label">Online Pack?</label>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($userVirtualBranch == 1  and $this->Role_model->_has_access_('student', 'sell_practice_pack_')) { ?>
                                <div class="col-md-2 radiCourse">
                                    <div class="form-group">
                                        <input type="radio" name="pack_cb" id="pp_cb" value='pp' class="ppp" />
                                        <label for="pp_cb" class="control-label">Practice Pack?</label>
                                    </div>
                                </div>
                            <?php } ?>                            
                            <div class="col-md-2 radiCourse hide">
                                <div class="form-group">
                                    <input type="radio" name="pack_cb" id="none_cb" value='none' class='ppp radio-btn-ui' />
                                    <label for="none_cb" class="control-label">None?</label>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        if (isset($waiver_approved_details['amount'])) {
                            $waiver_amount_given = $waiver_approved_details['amount'];
                        } else {
                            $waiver_amount_given = 0;
                        }
                        if (isset($waiver_approved_details['from_fname'])) {
                            $waiver_from_fname = $waiver_approved_details['from_fname'];
                        } else {
                            $waiver_from_fname = '';
                        }
                        if (isset($waiver_approved_details['from_lname'])) {
                            $waiver_from_lname = $waiver_approved_details['from_lname'];
                        } else {
                            $waiver_from_lname = '';
                        }
                        ?>
                        <!-- offline class pack -->
                        <div id="packbox_offline" class="edit-gray-bg" style="display: none;">
                            <div class="col-md-12 edit-rh">
                                <div class="bg-info">Student payment management for Inhouse pack!</div>
                            </div>
                            <?php if ($student['wallet'] / 100 > 0) { ?>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="checkbox" name="use_wallet_off" value="1" id='use_wallet_off' data-val="<?php echo $student['wallet'] / 100; ?>" />
                                        <label for="use_wallet_off" class="control-label">Use Wallet Amount?
                                            (<?php echo $student['wallet'] / 100; ?>)</label>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- offline class pack start-->
                            <div class="col-md-4">
                                <label for="package_id_off" class="control-label"><span class="text-danger">*</span>Inhouse
                                    Class Package <span class="text-info">(Format: Pack Name | Price | Pack Validity)</span>
                                </label>
                                <div class="form-group">
                                    <select name="package_id_off" id="package_id_off" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="getPackPrice(this.value);removePromocode('other_discount_off');getOnlineOfflinePackInfo(this.value);getPackBatch(this.value,this.id);checkDuplicateInhousePackBooking();">
                                        <option value="">Select Pack</option>
                                    </select>
                                    <span class="text-danger package_id_off_err"><?php echo form_error('package_id_off'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-12 packInfo"></div>
                            <div class="col-md-4 batchClass">
                                <label for="batch_id_off" class="control-label"><span class="text-danger">*</span>Batch</label>
                                <div class="form-group packBatch_off">
                                    <select name="batch_id_off" id="batch_id_off" class="form-control selectpicker selectpicker-ui-100" data-live-search="true" onchange="getPackageSchedule(this.value);">
                                        <option value="">Select Batch</option>
                                    </select>
                                    <span class="text-danger batch_id_off_err"><?php echo form_error('batch_id_off'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="method_off" class="control-label"><span class="text-danger">*</span>Payment mode</label>
                                <div class="form-group">
                                    <select name="method_off" id="method_off" class="form-control selectpicker selectpicker-ui-100" data-live-search="true">
                                        <?php echo PAYMENT_OPTIONS; ?>
                                    </select>
                                    <span class="text-danger method_off_err"><?php echo form_error('method_off'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="discount_type_off" class="control-label text-success"><span class="text-danger">*</span>Discount type</label>
                                <div class="form-group">
                                    <select name="discount_type_off" id="discount_type_off" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="showDiscountTypeFields_offline(this.value)">
                                        <option value="">Select type</option>
                                        <!-- <option value="Waiver">Waiver</option>
                                        <option value="Discount">Promocode</option> -->
                                        <option value="None" selected>None</option>
                                    </select>
                                    <span class="text-danger discount_type_off_err"><?php echo form_error('discount_type_off'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 waiverField_off" style="display: none;">
                                <label for="waiver_off" class="control-label">Waiver amount</label>
                                <div class="form-group">
                                    <input type="text" name="waiver_off" value="<?php echo $this->input->post('waiver_off') ? $this->input->post('waiver_off') : $waiver_amount_given; ?>" class="form-control input-ui-100" id="waiver_off" readonly />
                                    <span class="text-danger waiver_err"><?php echo form_error('waiver_off'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 waiverField_off" style="display: none;">
                                <label for="waiver_by_off" class="control-label">Waiver By</label>
                                <div class="form-group">
                                    <input type="text" name="waiver_by_off" value="<?php echo $this->input->post('waiver_by_off') ? $this->input->post('waiver_by_off') : $waiver_from_fname . ' ' . $waiver_from_lname; ?>" class="form-control input-ui-100" id="waiver_by_off" readonly />
                                    <span class="text-danger waiver_by_err"><?php echo form_error('waiver_by_off'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 discountField_off" style="display: none;">
                                <label for="other_discount_off" class="control-label">Discount</label>
                                <a href="javascript:void(0)" class="text-info promocode-txt" data-toggle="modal" data-target="#modal-Discount-PromoCode" name="<?php echo $student['id']; ?>" id="<?php echo $student['id']; ?>" title="Promocode" onclick="getApplicablePromocode(this.id);">Show Promo Code*</a> |
                                <a href="javascript:void(0)" class="text-warning" name="removePromocode_off" id="removePromocode_off" title="Remove Promocode" onclick="removePromocode('other_discount_off');">Remove Promo Code</a>
                                <div class="form-group">
                                    <input type="text" name="other_discount_off" id="other_discount_off" value="<?php echo ($this->input->post('other_discount_off') ? $this->input->post('other_discount_off') : 0); ?>" class="form-control input-ui-100" readonly />
                                    <span class="text-danger other_discount_err"><?php echo form_error('other_discount_off'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="amount_paid_off" class="control-label"><span class="text-danger">*</span>Amount
                                    paid <span class="text-warning"><i>(You may edit amount if any dues)</i></span></label>
                                <div class="form-group">
                                    <input type="text" name="amount_paid_off" id="amount_paid_off" value="<?php echo $this->input->post('amount_paid_off'); ?>" class="form-control chknum1 input-ui-100" onblur="validate_amount_paid(this.value);" maxlength="5" autocomplete="off" />
                                    <span class="text-danger amount_paid_err"><?php echo form_error('amount_paid_off'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="start_date_off" class="control-label"><span class="text-danger">*</span>Start Date <span class="packScheduleInfo_off text-success"></span></label>
                                <div class="form-group has-feedback">
                                    <input type="text" name="start_date_off" id="start_date_off" value="<?php echo ($this->input->post('start_date_off') ? $this->input->post('start_date_off') : $tomarrow); ?>" class="datepicker_timezone form-control input-ui-100 change_startdate" autocomplete="off" readonly="readonly" />
                                    <span class="glyphicon glyphicon-calendar form-control-feedback text-info"></span>
                                    <span class="text-danger start_date_off_err"><?php echo form_error('start_date_off'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="due_commitment_date_off" class="control-label">Due Commitment Date (If any)</label>
                                <div class="form-group has-feedback">
                                    <input type="text" name="due_commitment_date_off" value="<?php echo ($this->input->post('due_commitment_date_off') ? $this->input->post('due_commitment_date_off') : ''); ?>" class="datepicker_timezone form-control input-ui-100" id="due_commitment_date_off" autocomplete="off" readonly="readonly"/>
                                    <span class="glyphicon glyphicon-calendar form-control-feedback text-info"></span>
                                    <span class="text-danger due_commitment_date_off_err"><?php echo form_error('due_commitment_date_off'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="tran_id_off" class="control-label">Transaction ID (If any)</label>
                                <div class="form-group">
                                    <input type="text" name="tran_id_off" value="<?php echo ($this->input->post('tran_id_off') ? $this->input->post('tran_id_off') : ''); ?>" class="form-control input-ui-100" id="tran_id_off" maxlength="16" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="payment_file_off" class="control-label">Payment
                                    Slip<?php echo PAYMENT_SCREENSHOT_ALLOWED_LABEL; ?></label>
                                <div class="form-group">
                                    <input type="file" name="payment_file_off" value="<?php echo $this->input->post('payment_file_off'); ?>" class="form-control input-file-ui-100 input-file-ui" id="payment_file_off" />
                                </div>
                            </div>
                            
                            <div class="box-footer col-md-12">
                                <button type="submit" class="btn btn-info add_std_pack rd-20" onclick="return confirm('<?php echo SUBMISSION_CONFIRM; ?>');">
                                    <?php echo INHOUSE_LABEL; ?> <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                        <!-- offline class pack ends-->

                        <!-- online class pack -->                        
                        <div id="packbox_online" class="edit-gray-bg" style="display: none;">
                            <div class="col-md-12 edit-rh">
                                <div class="bg-info">Online class pack booking!</div>
                            </div>
                            <?php if ($student['wallet'] / 100 > 0) { ?>
                                <div class="col-md-12">
                                    <div class="form-group form-checkbox">
                                        <input type="checkbox" name="use_wallet_on" value="1" id='use_wallet_on' data-val="<?php echo $student['wallet'] / 100; ?>"/>
                                        <label for="use_wallet_on" class="control-label">Use Wallet Amount?
                                            (<?php echo $student['wallet'] / 100; ?>)</label>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-md-4">
                                <label for="package_id" class="control-label"><span class="text-danger">*</span>Online Class
                                    Package <span class="text-info">(Format: Pack Name | Price | Pack Validity)</span>
                                </label>
                                <div class="form-group">
                                    <select name="package_id" id="package_id" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-show-subtext="true" data-live-search="true" onchange="getPackPrice(this.value);removePromocode('other_discount');getOnlineOfflinePackInfo(this.value);getPackBatch(this.value,this.id)">
                                        <option value="">Select pack</option>
                                    </select>
                                    <span class="text-danger package_id_err"><?php echo form_error('package_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-12 packInfo"> </div>
                            <div class="col-md-4">
                                <label for="batch_id" class="control-label"><span class="text-danger">*</span>Batch</label>
                                <div class="form-group packBatch">
                                    <select name="batch_id" id="batch_id" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-live-search="true" onchange="getPackageSchedule_online(this.value);">
                                        <option value="">Select Batch</option>
                                    </select>
                                    <span class="text-danger batch_id_err"><?php echo form_error('batch_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="method" class="control-label"><span class="text-danger">*</span>Payment
                                    mode</label>
                                <div class="form-group">
                                    <select name="method" id="method" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-show-subtext="true" data-live-search="true">
                                        <?php echo PAYMENT_OPTIONS; ?>
                                    </select>
                                    <span class="text-danger method_err"><?php echo form_error('method'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="discount_type" class="control-label text-success"><span class="text-danger">*</span>Discount type</label>
                                <div class="form-group">
                                    <select name="discount_type" id="discount_type" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep"  data-show-subtext="true" data-live-search="true" onchange="showDiscountTypeFields_online(this.value)">
                                        <!-- <option value="">Select type</option> -->
                                         <!-- <option value="Discount">Promocode</option>  -->
                                        <?php if(WOSA_ONLINE_DOMAIN == 1){?> 
                                        <option value="Waiver">Waiver</option>                                       
                                        <?php } ?>
                                        <option value="None" selected>None</option>
                                    </select>
                                    <span class="text-danger discount_type_err"><?php echo form_error('discount_type'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 waiverField_online" style="display: none;">
                                <label for="waiver" class="control-label">Waiver amount</label>
                                <div class="form-group">
                                    <input type="text" name="waiver" value="<?php echo $this->input->post('waiver') ? $this->input->post('waiver') : $waiver_amount_given; ?>" class="form-control input-ui-100" id="waiver" readonly />
                                    <span class="text-danger waiver_err"><?php echo form_error('waiver'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 waiverField_online" style="display: none;">
                                <label for="waiver_by" class="control-label">Waiver By</label>
                                <div class="form-group">
                                    <input type="text" name="waiver_by" value="<?php echo $this->input->post('waiver_by') ? $this->input->post('waiver_by') : $waiver_from_fname . ' ' . $waiver_from_lname; ?>" class="form-control input-ui-100" id="waiver_by" readonly />
                                    <span class="text-danger waiver_by_err"><?php echo form_error('waiver_by'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 discountField_online" style="display: none;">
                                <label for="other_discount" class="control-label">Discount</label>
                                <a href="javascript:void(0)" class="text-info promocode-txt" data-toggle="modal" data-target="#modal-Discount-PromoCode" name="<?php echo $student['id']; ?>" id="<?php echo $student['id']; ?>" title="Promocode" onclick="getApplicablePromocode(this.id);">Show Promo Code</a> |
                                <a href="javascript:void(0)" class="text-warning" name="removePromocode" id="removePromocode" title="Remove Promocode" onclick="removePromocode('other_discount');">Remove Promo Code</a>
                                <div class="form-group">
                                    <input type="text" name="other_discount" value="<?php echo ($this->input->post('other_discount') ? $this->input->post('other_discount') : 0); ?>" class="form-control input-ui-100 removeerrmessage" id="other_discount" readonly />
                                    <span class="text-danger other_discount_err"><?php echo form_error('other_discount'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="amount_paid" class="control-label"><span class="text-danger">*</span>Amount paid
                                    <span class="text-warning"><i>(You may edit amount if any dues)</i></span></label>
                                <div class="form-group">
                                    <input type="text" name="amount_paid" id="amount_paid" value="<?php echo $this->input->post('amount_paid'); ?>" class="form-control chknum1 input-ui-100 removeerrmessage" onblur="validate_amount_paid(this.value);" maxlength="5" autocomplete="off" />
                                    <span class="text-danger amount_paid_err"><?php echo form_error('amount_paid'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="start_date" class="control-label"><span class="text-danger">*</span>Start Date<span class="packScheduleInfo text-success"></span></label>
                                <div class="form-group has-feedback">
                                    <input type="text" name="start_date" value="<?php echo ($this->input->post('start_date') ? $this->input->post('start_date') : $tomarrow); ?>" class="datepicker_timezone form-control input-ui-100 removeerrmessage change_startdate" id="start_date" autocomplete="off" readonly="readonly"/>
                                    <span class="glyphicon glyphicon-calendar form-control-feedback text-info"></span>
                                    <span class="text-danger start_date_err"><?php echo form_error('start_date'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="due_commitment_date" class="control-label">Due Commitment Date (If any)</label>
                                <div class="form-group has-feedback">
                                    <input type="text" name="due_commitment_date" value="<?php echo ($this->input->post('due_commitment_date') ? $this->input->post('due_commitment_date') : ''); ?>" class="datepicker_timezone form-control input-ui-100" id="due_commitment_date" autocomplete="off" readonly="readonly"/>
                                    <span class="glyphicon glyphicon-calendar form-control-feedback text-info"></span>
                                    <span class="text-danger due_commitment_date_err"><?php echo form_error('due_commitment_date'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="tran_id" class="control-label">Transaction ID (If any)</label>
                                <div class="form-group">
                                    <input type="text" name="tran_id" id="tran_id" value="<?php echo ($this->input->post('tran_id') ? $this->input->post('tran_id') : ''); ?>" class="form-control input-ui-100" maxlength="16" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="payment_file" class="control-label">Payment Slip
                                    <?php echo PAYMENT_SCREENSHOT_ALLOWED_LABEL; ?></label>
                                <div class="form-group">
                                    <input type="file" name="payment_file" id="image" value="<?php echo $this->input->post('payment_file'); ?>" class="form-control input-file-ui-100 input-file-ui" onchange="validate_file_type_paymentSlip(this.id)" />
                                    <span class="text-danger image_err"><?php echo form_error('payment_file'); ?></span>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary add_std_pack rd-20" onclick="return check_all_validation();">
                                    <?php echo ONLINE_LABEL; ?> <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                        <!-- online class pack ends-->

                        <!-- practice pack -->
                        <div id="packbox_pp" class="edit-gray-bg" style="display: none;">
                            <div class="col-md-12 edit-rh">
                                <div class="bg-info">
                                    Student payment management for Practice pack!
                                </div>
                            </div>
                            <?php if ($student['wallet'] / 100 > 0) { ?>
                                <div class="col-md-12">
                                    <div class="form-group form-checkbox">
                                        <input type="checkbox" name="use_wallet_pp" value="1" id='use_wallet_pp' />
                                        <label for="use_wallet_pp" class="control-label">Use Wallet Amount?
                                            (<?php echo $student['wallet'] / 100; ?>)</label>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-md-4">
                                <label for="package_id_pp" class="control-label"><span class="text-danger">*</span>
                                    Pack <span class="text-info">( Format: Pack Name | Offer Price | Org. Price | Pack
                                        Validity )</span> </label>
                                <div class="form-group">
                                    <select name="package_id_pp" id="package_id_pp" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-show-subtext="true" data-live-search="true" onchange="getPackPrice(this.value);getOnlineOfflinePackInfo(this.value);">
                                        <option value="">Select package</option>
                                    </select>
                                    <span class="text-danger package_id_pp_err"><?php echo form_error('package_id_pp'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-12 packInfo"></div>
                            <div class="col-md-4">
                                <label for="method_pp" class="control-label"><span class="text-danger">*</span>Payment mode</label>
                                <div class="form-group">
                                    <select name="method_pp" id="method_pp" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-live-search="true">
                                        <?php echo PAYMENT_OPTIONS; ?>
                                    </select>
                                    <span class="text-danger method_pp_err"><?php echo form_error('method_pp'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="discount_type_pp" class="control-label text-success"><span class="text-danger">*</span>Discount type</label>
                                <div class="form-group">
                                    <select name="discount_type_pp" id="discount_type_pp" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-show-subtext="true" data-live-search="true" onchange="showDiscountTypeFields_pp(this.value)">
                                    <?php if(WOSA_ONLINE_DOMAIN == 1){?> 
                                        <option value="Waiver">Waiver</option>                                       
                                        <?php } ?>
                                        <option value="None">None</option>
                                    </select>
                                    <span class="text-danger discount_type_pp_err"><?php echo form_error('discount_type_pp'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 waiverField_pp" style="display: none;">
                                <label for="waiver_pp" class="control-label">Waiver amount</label>
                                <div class="form-group">
                                    <input type="text" name="waiver_pp" value="<?php echo $this->input->post('waiver_pp') ? $this->input->post('waiver_pp') : $waiver_amount_given; ?>" class="form-control input-ui-100" id="waiver_pp" readonly />
                                    <span class="text-danger waiver_err"><?php echo form_error('waiver_pp'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 waiverField_pp" style="display: none;">
                                <label for="waiver_by_pp" class="control-label">Waiver By</label>
                                <div class="form-group">
                                    <input type="text" name="waiver_by_pp" value="<?php echo $this->input->post('waiver_by_pp') ? $this->input->post('waiver_by_pp') : $waiver_from_fname . ' ' . $waiver_from_lname; ?>" class="form-control input-ui-100" id="waiver_by_pp" readonly />
                                </div>
                            </div>
                            <div class="col-md-4 discountField_pp" style="display: none;">
                                <label for="other_discount_pp" class="control-label">Discount</label>
                                <a href="javascript:void(0)" class="text-info" data-toggle="modal" data-target="#modal-Discount-PromoCode" name="<?php echo $student['id']; ?>" id="<?php echo $student['id']; ?>" title="Promocode" onclick="getApplicablePromocode(this.id);">Show Promo Code*</a> |
                                <a href="javascript:void(0)" class="text-warning" name="removePromocode_pp" id="removePromocode_pp" title="Remove Promocode" onclick="removePromocode('other_discount_pp');">Remove Promo Code</a>
                                <div class="form-group">
                                    <input type="text" class="form-control input-ui-100" name="other_discount_pp" value="<?php echo ($this->input->post('other_discount_pp') ? $this->input->post('other_discount_pp') : 0); ?>" class="form-control removeerrmessage" id="other_discount_pp" readonly />
                                    <span class="text-danger other_discount_err"><?php echo form_error('other_discount_pp'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="amount_paid_pp" class="control-label"><span class="text-danger">*</span>Amount
                                    paid <span class="text-warning"><i>(You may edit amount if any dues)</i></span></label>
                                <div class="form-group">
                                    <input type="text" name="amount_paid_pp" id="amount_paid_pp" value="<?php echo $this->input->post('amount_paid_pp'); ?>" class="form-control chknum1 input-ui-100 removeerrmessage" onblur="validate_amount_paid_pp(this.value);" maxlength="5" autocomplete="off" />
                                    <span class="text-danger amount_paid_err"><?php echo form_error('amount_paid_pp'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="start_date_pp" class="control-label"><span class="text-danger">*</span>Package Starting Date</label>
                                <div class="form-group has-feedback">
                                    <input type="text" name="start_date_pp" id="start_date_pp" value="<?php echo ($this->input->post('start_date_pp') ? $this->input->post('start_date_pp') : $tomarrow); ?>" class="datepicker_timezone form-control input-ui-100 removeerrmessage change_startdate" autocomplete="off" readonly="readonly" />
                                    <span class="glyphicon glyphicon-calendar form-control-feedback text-info"></span>
                                    <span class="text-danger start_date_pp_err"><?php echo form_error('start_date_pp'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="due_commitment_date_pp" class="control-label">Due Commitment Date (If any)</label>
                                <div class="form-group has-feedback">
                                    <input type="text" name="due_commitment_date_pp" value="<?php echo ($this->input->post('due_commitment_date_pp') ? $this->input->post('due_commitment_date_pp') : ''); ?>" class="datepicker_timezone form-control input-ui-100" id="due_commitment_date_pp" autocomplete="off" readonly="readonly" />
                                    <span class="glyphicon glyphicon-calendar form-control-feedback text-info"></span>
                                    <span class="text-danger due_commitment_date_pp_err"><?php echo form_error('due_commitment_date_pp'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="tran_id_pp" class="control-label">Transaction ID (If any)</label>
                                <div class="form-group">
                                    <input type="text" name="tran_id_pp" id="tran_id_pp" value="<?php echo ($this->input->post('tran_id_off') ? $this->input->post('tran_id_pp') : ''); ?>" class="form-control input-ui-100" maxlength="16" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="payment_file_pp" class="control-label">Payment Slip
                                    <?php echo PAYMENT_SCREENSHOT_ALLOWED_LABEL; ?></label>
                                <div class="form-group">
                                    <input type="file" name="payment_file_pp" id="image_pp" value="<?php echo $this->input->post('payment_file_pp'); ?>" class="form-control input-file-ui-100 input-file-ui" onchange="validate_file_type_paymentSlip_pp(this.id)" />
                                    <span class="text-danger image_pp_err"><?php echo form_error('payment_file'); ?></span>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-warning add_std_pack rd-20"  onclick="return check_all_validation_pp();">
                                    <?php echo PP_LABEL; ?> <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                        <!-- practice pack ends-->
                       
                        <?php if (count($student_package_offline) > 0) { ?>
                            <div class="col-md-12">
                                <div class="head-bg" role="alert"> Inhouse Class Pack </div>
                                <div class="form-group bg-success" style="padding-top:10px;padding-bottom:10px;">
                                    <!-- table start -->
                                    <div class="table-ui-scroller">
                                        <div class="box-body table-responsive table-hr-scroller table-cb-none mheight200">
                                            <table class="table table-striped table-bordered table-sm">
                                            <thead class="bg-success">
                                                <tr class="bg-info"><?php echo TR_OFFLINE; ?></tr>
                                            </thead>
                                            <tbody id="myTable">
                                                <?php foreach ($student_package_offline as $sp) {
                                                        $encId = base64_encode($sp['student_id']);
                                                        $url = site_url('adminController/student/student_transaction_/' . $sp['student_package_id'] . '/' . $encId);
                                                        $classroom_id = $sp['classroom_id'];
                                                        $classroom_name = $sp['classroom_name'];
                                                        if ($sp['waiver_by']) {
                                                            $waiver_by = $sp['waiver_by'];
                                                        } else {
                                                            $waiver_by = NA;
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <a href="<?php echo site_url('adminController/student/adjust_online_and_inhouse_pack_/' . $sp['student_package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Update Payment/Dues"><span class="fa fa-usd"></span></a>
                                                                <a href="<?php echo $url; ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Transaction history"><span class="fa fa-history"></span></a>
                                                                <?php if ($sp['payment_file'] != '') { ?>
                                                                    <a href="<?php echo base_url(PAYMENT_SCREENSHOT_FILE_PATH_INHOUSE . $sp['payment_file']); ?>" target="_blank" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Transaction file"><span class="fa fa-download"></span></a>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($sp['packCloseReason'] == NULL) {
                                                                    echo '<span class="text-success"><a href="javascript:void(0);"data-toggle="tooltip" title="Active Pack"  >' . ACTIVE . '</a></span>';
                                                                } else if ($sp['packCloseReason'] == 'Partial Refund' or $sp['packCloseReason'] == 'Full Refund' or $sp['packCloseReason'] == 'Pack Terminated' or $sp['packCloseReason'] == 'Course switched' or $sp['packCloseReason'] == 'Branch switched' or $sp['packCloseReason'] == 'Pack on hold' or $sp['packCloseReason'] == 'Due
                                                                    ') {
                                                                    echo '<span class="text-danger"><a href="javascript:void(0);" data-toggle="tooltip" title="' . $sp['packCloseReason'] . ' "  >' . DEACTIVE . '</a></span>';
                                                                } else {
                                                                    echo '<span class="text-danger"><a href="javascript:void(0);" data-toggle="tooltip" title="Deactive/Expired pack"  >' . DEACTIVE . '</a></span>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $sp['package_name']; ?></td>
                                                            <td><?php echo $sp['package_cost'] . '/' . $sp['package_duration']; ?></td>
                                                            <td><a id="showdata_<?php echo $sp['student_package_id']; ?>" href="javascript:void(0)" onmouseover="show_classroom_desc('<?php echo $classroom_name; ?>','<?php echo $classroom_id; ?>','<?php echo $sp['student_package_id'];?>')" data-toggle="tooltip" data-placement="top"><?php echo $classroom_name; ?></a></td>
                                                            <td><?php echo $sp['amount_paid']; ?></td>
                                                            <td><?php echo $sp['amount_paid_by_wallet']; ?></td>
                                                            <td><?php echo $sp['ext_amount']; ?></td>
                                                            <td><?php echo $sp['waiver']; ?></td>
                                                            <td><?php echo $waiver_by; ?></td>
                                                            <td><?php echo $sp['other_discount']; ?></td>
                                                            <?php if ($sp['amount_due'] == '0.00') { ?>
                                                                <td class="bg-green"><?php echo $sp['amount_due']; ?></td>
                                                            <?php } else { ?>
                                                                <td class="bg-orange"><?php echo $sp['amount_due']; ?></td>
                                                            <?php } ?>
                                                            <td class="bg-danger"><?php echo $sp['irr_dues']; ?></td>
                                                            <td>
                                                                <?php
                                                                if ($sp['due_commitment_date']) {
                                                                    echo date('d-m-Y', $sp['due_commitment_date']);
                                                                } else {
                                                                    echo NA;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                        <?php
                                                          if(strtotime(date('d-m-Y')) <= strtotime($sp['holdDateTo'])){
                                                                echo $sp['holdDateFrom'].' - '. $sp['holdDateTo'];
                                                            }else { echo "N/A";}
                                                        ?></td>
                                                            <td><?php echo $sp['amount_refund']; ?></td>
                                                            <td><?php echo date('d-m-Y', $sp['subscribed_on']); ?></td>                 
                                                            <td><?php echo date('d-m-Y', $sp['expired_on']); ?></td>
                                                            <td><?php echo $sp['requested_on']; ?></td>                 
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- table ends -->
                                </div>
                            </div>
                        <?php } ?>

    <?php if (count($student_package_online) > 0) { ?>
    <div class="col-md-12">
        <div class="head-bg" role="alert"> Online Class Pack </div>
            <div class="form-group bg-success" style="padding-top:10px;padding-bottom:10px;">
            <!-- table start -->
            <div class="table-ui-scroller">
                <div class="box-body table-responsive table-hr-scroller table-cb-none mheight200">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="bg-success">
                            <tr><?php echo TR_ONLINE_OFFLINE; ?></tr>
                        </thead>
                        <tbody id="myTable">
                        <?php
                            foreach ($student_package_online as $sp) {
                            $encId = base64_encode($sp['student_id']);
                            $url = site_url('adminController/student/student_transaction_/' . $sp['student_package_id'] . '/' . $encId);
                            $classroom_id = $sp['classroom_id'];
                            $classroom_name = $sp['classroom_name'];
                            $holdDateFrom = $sp['holdDateFrom'];
                            $holdDateTo = $sp['holdDateTo'];
                            if(WOSA_ONLINE_DOMAIN==1){
                                if($sp['waiver_by']) {
                                    $waiver_by = $sp['waiver_by'];
                                }else{
                                    $waiver_by = NA;
                                }
                            }
                        ?>
                        <tr>
                            <td>
                                <a href="<?php echo site_url('adminController/student/adjust_online_and_inhouse_pack_/' . $sp['student_package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Update Payment/Dues"><span class="fa fa-usd"></span> </a>
                                <a href="<?php echo $url; ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Transaction history"><span class="fa fa-history"></span> </a>
                                <?php if (isset($sp['payment_file'])) { ?>
                                    <a href="<?php echo base_url(PAYMENT_SCREENSHOT_FILE_PATH_ONLINE . $sp['payment_file']); ?>" target="_blank" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Transaction file"><span class="fa fa-download"></span> </a>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                    if($sp['packCloseReason'] == NULL) {
                                        echo '<span class="text-success"><a href="javascript:void(0);"data-toggle="tooltip" title="Active Pack"  >' . ACTIVE . '</a></span>';
                                    }else if (($sp['packCloseReason'] == 'Partial Refund' AND $sp['package_status'] == 0) or $sp['packCloseReason'] == 'Full Refund' or $sp['packCloseReason'] == 'Pack Terminated' or $sp['packCloseReason'] == 'Course switched' or $sp['packCloseReason'] == 'Branch switched' or ( $sp['packCloseReason'] == 'Pack on hold' AND $sp['onHold'] == 1) or $sp['packCloseReason'] == 'Due') {
                                            echo '<span class="text-red"><a href="javascript:void(0);" data-toggle="tooltip" title="' . $sp['packCloseReason'] . ' "  >' . DEACTIVE . '</a></span>';
                                    }else if (($sp['packCloseReason'] == 'Partial Refund' AND $sp['package_status'] == 1)) {
                                        echo '<span class="text-success"><a href="javascript:void(0);"data-toggle="tooltip" title="Active Pack"  >' . ACTIVE . '</a></span>';
                                    }else if ($sp['packCloseReason'] == 'Have to be start' AND $sp['package_status']==0) {
                                        echo '<span class="text-red"><a href="javascript:void(0);"data-toggle="tooltip" title="Have to be start"  >' . DEACTIVE . '</a></span>';
                                    }else{
                                        echo '<span class="text-red"><a href="javascript:void(0);" data-toggle="tooltip" title="Deactive/Expired pack"  >' . DEACTIVE . '</a></span>';
                                    }
                                   
                                    ?>
                                     <div><?php echo $sp['packCloseReason'];?></div>
                                    </td>
                                    <td><?php echo $sp['package_name']; ?></td>
                                    <td><?php echo $sp['test_module_name'].'/'.$sp['programe_name']; ?></td>
                                    <td><?php echo $sp['package_cost'] . '/' . $sp['package_duration']; ?></td>
                                    <td><a class="text-blue" id="showdata_<?php echo $sp['student_package_id']; ?>" href="javascript:void(0)" onmouseover="show_classroom_desc('<?php echo $classroom_name; ?>','<?php echo $classroom_id; ?>','<?php echo $sp['student_package_id']; ?>')" data-toggle="tooltip" data-placement="top"><?php echo $classroom_name; ?></a></td>
                                    <!-- <td><?php echo $sp['payment_id']; ?></td> -->
                                    <td><?php echo $sp['amount_paid']; ?></td>
                                    <td><?php echo $sp['amount_paid_by_wallet']; ?></td>
                                    <td><?php echo $sp['ext_amount']; ?></td>
                                    <?php if(WOSA_ONLINE_DOMAIN==1){ ?>
                                        <td><?php echo $sp['waiver']; ?></td>
                                        <td><?php echo $waiver_by; ?></td>
                                    <?php } ?>
                                    <!-- <td><?php echo $sp['other_discount']; ?></td> -->
                                    <?php if ($sp['amount_due'] == '0.00') { ?>
                                        <td ><?php echo $sp['amount_due']; ?></td>
                                    <?php } else { ?>
                                    <td style="color:red"><?php echo $sp['amount_due']; ?></td><?php } ?>
                                    <?php if ($sp['irr_dues'] == '0.00') { ?>
                                        <td ><?php echo $sp['irr_dues']; ?></td>
                                    <?php } else { ?>
                                    <td style="color:red"><?php echo $sp['irr_dues']; ?></td>
                                    <?php } ?>
                                    <td>
                                    <?php
                                        if($sp['due_commitment_date'] != 0){
                                            echo date('d-m-Y', $sp['due_commitment_date']);
                                        }else{
                                            echo NA;
                                        }
                                    ?>
                                    </td>
                                    <td><?php echo $sp['amount_refund']; ?></td>
                                    <td><?php echo date('d-m-Y', $sp['subscribed_on']); ?></td>
                                    <td>
                                        <?php
                                            if(strtotime(date('d-m-Y')) <= strtotime($sp['holdDateTo'])){
                                                echo $sp['holdDateFrom'].' to '. $sp['holdDateTo'];
                                            }else { echo "N/A";}
                                        ?>                                            
                                    </td>
                                    <td><?php echo date('d-m-Y', $sp['expired_on']); ?></td>
                                    <td><?php echo $sp['requested_on']; ?></td>                 
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        </div>
        <!-- table ends -->
        </div>
    </div>
    <?php } ?>

                        <?php if (count($student_package_pp) > 0) { ?>
                            <div class="col-md-12">
                                <div class="head-bg" role="alert">Practice Pack </div>
                                <div class="form-group bg-warning" style="padding-top:10px;padding-bottom:10px;">
                                    <!-- table start -->
                                    <div class="table-ui-scroller">
                                        <div class="box-body table-responsive table-hr-scroller table-cb-none mheight200">
                                            <table class="table table-striped table-bordered table-sm pp-bg">
                                                <thead class="bg-warning">
                                                    <tr class="bg-warning">
                                                        <?php echo TR_PRACTICE_PACK; ?>
                                                    </tr>
                                                </thead>
                                                <tbody id="myTable">
                                                    <?php foreach ($student_package_pp as $sp) {
                                                        $encId = base64_encode($sp['student_id']);
                                                        $url = site_url('adminController/student/student_transaction_/' . $sp['student_package_id'] . '/' . $encId);
                                                        if(WOSA_ONLINE_DOMAIN==1){
                                                            if($sp['waiver_by']) {
                                                                $waiver_by = $sp['waiver_by'];
                                                            }else{
                                                                $waiver_by = NA;
                                                            }
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <a href="<?php echo site_url('adminController/student/adjust_practice_pack_/' . $sp['student_package_id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Update Payment/Dues"><span class="fa fa-usd"></span></a>
                                                                <a href="<?php echo $url; ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Transaction history"><span class="fa fa-history"></span></a>
                                                                <?php if ($sp['payment_file'] != '') { ?>
                                                                    <a href="<?php echo base_url(PAYMENT_SCREENSHOT_FILE_PATH_PP . $sp['payment_file']); ?>" target="_blank" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Transaction file"><span class="fa fa-download"></span></a>
                                                                <?php } ?>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <?php
                                                                  if ($sp['packCloseReason'] == NULL) {
                                                                    echo '<span class="text-success"><a href="javascript:void(0);"data-toggle="tooltip" title="Active Pack"  >' . ACTIVE . '</a></span>';
                                                                } else if (($sp['packCloseReason'] == 'Partial Refund' AND $sp['package_status'] == 0) or $sp['packCloseReason'] == 'Full Refund' or $sp['packCloseReason'] == 'Pack Terminated' or $sp['packCloseReason'] == 'Course switched' or $sp['packCloseReason'] == 'Branch switched' or $sp['packCloseReason'] == 'Pack on hold' or $sp['packCloseReason'] == 'Due') {
                                                                    echo '<span class="text-red"><a href="javascript:void(0);" data-toggle="tooltip" title="' . $sp['packCloseReason'] . ' "  >' . DEACTIVE . '</a></span>';
                                                                } 
                                                                else if (($sp['packCloseReason'] == 'Partial Refund' AND $sp['package_status'] == 1)) {
                                                                    echo '<span class="text-success"><a href="javascript:void(0);"data-toggle="tooltip" title="Active Pack"  >' . ACTIVE . '</a></span>';
                                                                }else if ($sp['packCloseReason'] == 'Have to be start' AND $sp['package_status']==0) {
                                                                    echo '<span class="text-res"><a href="javascript:void(0);"data-toggle="tooltip" title="Have to be start"  >' . DEACTIVE . '</a></span>';
                                                                }else {
                                                                    echo '<span class="text-red"><a href="javascript:void(0);" data-toggle="tooltip" title="Deactive/Expired pack"  >' . DEACTIVE . '</a></span>';
                                                                }
                                                                ?>
                                                                
                                                                <div><?php echo $sp['packCloseReason']?></div>
                                                            </td>
                                                            <td><?php echo $sp['package_name']; ?></td>
                                                            <td><?php echo $sp['test_module_name'] . '/' . $sp['programe_name']; ?></td>
                                                            <td><?php echo $sp['package_cost'] . '/' . $sp['package_duration'] ?></td>
                                                            <td><?php echo $sp['amount_paid']; ?></td>
                                                            <td><?php echo $sp['amount_paid_by_wallet']; ?></td>
                                                            <td><?php echo $sp['ext_amount']; ?></td>
                                                            <?php if(WOSA_ONLINE_DOMAIN==1){ ?>
                                                                <td><?php echo $sp['waiver']; ?></td>
                                                                <td><?php echo $waiver_by; ?></td>
                                                            <?php } ?>
                                                            <!-- <td><?php echo $sp['other_discount']; ?></td> -->
                                                            <?php if ($sp['amount_due'] == '0.00') { ?>
                                                                <td ><?php echo $sp['amount_due']; ?></td>
                                                            <?php } else { ?>
                                                                <td style="color:red"><?php echo $sp['amount_due']; ?></td>
                                                            <?php } ?>
                                                            <?php if ($sp['irr_dues'] == '0.00') { ?>
                                                                <td ><?php echo $sp['irr_dues']; ?></td>
                                                            <?php } else { ?>
                                                                <td style="color:red"><?php echo $sp['irr_dues']; ?></td>
                                                            <?php } ?>
                                                            <td>
                                                                <?php
                                                                if ($sp['due_commitment_date'] != 0) {
                                                                    echo date('d-m-Y', $sp['due_commitment_date']);
                                                                } else {
                                                                    echo NA;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $sp['amount_refund']; ?></td>
                                                            <td><?php echo date('d-m-Y', $sp['subscribed_on']); ?></td>
                                                            <td>
                                                            <?php
                                                                if(strtotime(date('d-m-Y')) <= strtotime($sp['holdDateTo'])){
                                                                    echo $sp['holdDateFrom'].' to '. $sp['holdDateTo'];
                                                                }else { echo "N/A";}
                                                            ?></td>                                                           
                                                            <td><?php echo date('d-m-Y', $sp['expired_on']); ?></td>
                                                            <td><?php echo $sp['requested_on']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- table ends -->
                                </div>
                            </div>
                        <?php } ?>

                        <!-- counselling booked data start-->
                        <?php if (count($student_counselling) > 0) { ?>
                            <div class="col-md-12">
                                <div class="form-group bg-danger">
                                    <div class="sess_cancelBookingMsg text-center text-danger">---</div>
                                    <div class="alert alert-danger" role="alert">
                                        Booked Session
                                    </div>
                                    <!-- table start -->
                                    <div class="table-ui-scroller">
                                        <div class="box-body table-responsive table-hr-scroller table-cb-none mheight200">
                                            <table class="table table-striped table-bordered table-sm">
                                                <thead>
                                                    <tr class="bg-danger">
                                                        <?php echo TR_SESSION; ?>
                                                    </tr>
                                                </thead>
                                                <tbody id="myTable">
                                                    <?php foreach ($student_counselling as $sp) { ?>
                                                        <tr>
                                                            <td><?php echo $sp['session_type']; ?></td>
                                                            <td><?php echo $sp['test_module_name'] . '-' . $sp['programe_name']; ?></td>
                                                            <td><?php echo $sp['center_name']; ?></td>
                                                            <td><?php echo $sp['booking_date'] . ' ' . $sp['booking_time_slot']; ?></td>
                                                            <td>
                                                                <?php
                                                                if ($sp['booking_link']) {
                                                                    echo $sp['booking_link'];
                                                                } else {
                                                                    echo NA;
                                                                }
                                                                ?>
                                                            </td>
                                                            <!-- <td>
                                            <?php
                                                        if ($sp['active'] == 1) {
                                                            echo '<span class="text-success"><a href="javascript:void(0);"data-toggle="tooltip" title="Active">' . ACTIVE . '</a></span>';
                                                        } else {
                                                            echo '<span class="text-danger"><a href="javascript:void(0);" data-toggle="tooltip" title="Cancelled"  >' . DEACTIVE . '</a></span>';
                                                        }
                                            ?>
                                        </td> -->
                                                            <td><?php echo $sp['created']; ?></td>
                                                            <td>
                                                                <?php
                                                                if ($sp['is_attended'] == 0) {
                                                                    echo NO;
                                                                } elseif ($sp['is_attended'] == 1) {
                                                                    echo YES;
                                                                } else {
                                                                    echo PENDING;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($sp['remarks']) {
                                                                    echo $sp['remarks'];
                                                                } else {
                                                                    echo NA;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0)" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-session" name="<?php echo $sp['booking_id']; ?>" id="<?php echo $sp['booking_id']; ?>" title="Has attended?" onclick="fillsessionBookingId(this.id)"></span> &nbsp; Has
                                                                    attended?</a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- table ends -->
                                </div>
                            </div>
                        <?php } ?>
                        <!-- counselling booked data end-->
                        <!-----Start Add Code By Neelu --->
                        <!-----Event Booked History --->
                        <?php //if (count($student_event_booking) > 0) {
                            //$this->load->view('event/student_event_booking_history.php');
                        //} ?>
                        <!-----Event Booked History End--->
                        <!-----End Add Code By Neelu --->
                    </div>
                    <input type="hidden" name="walletBalance" id="walletBalance" value="<?php echo $student['wallet'] / 100; ?>">
                    <input type="hidden" name="packPrice" id="packPrice" value="">
                    <input type="hidden" name="promoCodeId_val" id="promoCodeId_val" value="">
                    <input type="hidden" name="bulk_id" id="bulk_id">
                    <input type="hidden" name="bulk_promoCodeId_val" id="bulk_promoCodeId_val">
                    <div class="box-footer" style="padding:0px 15px;">
                        <button type="submit" class="btn btn-danger add_std_pack pull-right rd-20" onclick="return confirm('<?php echo SUBMISSION_CONFIRM; ?>');">
                            <i class="fa fa-pencil"></i> <?php echo UPDATE_STUDENT_LABEL; ?>
                        </button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <!-- modal box for refund history starts-->
        <div class="modal fade" id="modal-refund-history" style="display: none;">
            <div class="modal-dialog modal-xlg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-heading text-info">Refund History</h4>
                        <h5 class="msg_refund_history"></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-info">
                                        <div class="refund_history mt-10"></div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- modal box for refund history ends-->
        <!-- modal box for refund history2 starts-->
        <div class="modal fade" id="modal-refund-history1" style="display: none;">
            <div class="modal-dialog  modal-xlg">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                      
                    </div> -->
                    <div class="modal-body">
                        <div class="row">
                        <h5 class="msg"></h5>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left rd-20" data-dismiss="modal">Close</button>
                        <div class="makeBtn"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal box for refund history2 ends-->
        <!-- modal box for  waiver history starts-->
        <div class="modal fade" id="modal-waiver-history" style="display: none;">
            <div class="modal-dialog modal-xlg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-heading text-info">Waiver history</h4>
                        <h5 class="msg_waiver_history"></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-info">
                                    <div class="box-body">
                                        <div class="row clearfix"></div>
                                    </div>
                                    <div class="waiver_history">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal box for waiver history ends-->
        <!-- modal box for waiver history2 starts-->
        <div class="modal fade" id="modal-waiver-history1" style="display: none;">
            <div class="modal-dialog modal-xlg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h5 class="msg"></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-info">
                                    <div class="box-body">
                                        <div class="row clearfix">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <div class="makeBtn"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal box for waiver history2 ends-->
        <!-- modal box for add session starts-->
        <div class="modal fade" id="modal-session" style="display: none;">
            <div class="modal-dialog modal-xlg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="refresh_page();">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-heading text-info">Add session status</h4>
                        <h5 class="msg_session"></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-info">
                                    <div class="box-body">
                                        <div class="row clearfix">
                                            <div class="col-md-12">
                                                <label for="session_booking_remarks" class="control-label"><span class="text-danger">*</span>Remarks</label>
                                                <div class="form-group">
                                                    <textarea name="session_booking_remarks" class="form-control" id="session_booking_remarks"></textarea>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="is_attended" class="control-label">Has attended?</label>
                                                        <input type="checkbox" name="is_attended" id="is_attended" />
                                                    </div>
                                                </div>
                                                <input type="hidden" name="session_booking_id" id="session_booking_id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="refresh_page();">
                                Close
                            </button>
                            <button type="button" class="btn btn-info" id="saveSessionStatus" onclick="saveSessionStatus();">Save Status</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal box for add session ends-->
        <!-- modal box for add doc starts-->
        <div class="modal fade" id="modal-doc" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="refresh_page();">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-heading text-info">Upload Student Documents</h4>                        
                    </div>
                    <h5 class="msg"></h5>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-info">
                                    <div class="box-body">
                                        <div class="row">
                                            <form id="submit_doc">
                                                <div class="col-md-4">
                                                    <label for="doc_image" class="control-label"><span class="text-danger">*</span>Upload Documents</label>
                                                    <?php echo DOCUMENT_ALLOWED_LABEL; ?>
                                                    <div class="form-group">
                                                        <div class="d-inline">
                                                            <input type="file" name="fileDoc" id="fileDoc" class="form-control input-file-ui-100 input-file-ui removeerrmessage" onchange="validate_file_type_stdDoc(this.id)" />
                                                            <button class="btn btn-info input-ui-100 ml-5" id="btn_upload" type="submit">Upload</button>
                                                        </div>
                                                        <span class="fileDoc_err text-danger" id="doc_image_msg"></span>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="col-md-4">
                                                <label for="document_typeDoc" class="control-label"><span class="text-danger">*</span>Document Type</label>
                                                <div class="form-group">
                                                    <select name="document_typeDoc" id="document_typeDoc" class="form-control selectpicker selectpicker-ui-100 select_removeerrmessagep" data-show-subtext="true" data-live-search="true" onchange="validateDocExpiryField(this.value);">
                                                        <option value="">Select Doc Type</option>
                                                        <?php
                                                        foreach ($allDocType as $d) {
                                                            $selected = ($d['id'] == $this->input->post('document_typeDoc')) ? ' selected="selected"' : "";
                                                            echo '<option value="' . $d['id'] . '" ' . $selected . '>' . $d['document_type_name'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <span class="text-danger document_typeDoc_err" id="doc_image_msg"></span> 
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="document_no" class="control-label"><span class="text-danger">*</span>Document Number</label>
                                                <div class="form-group">
                                                    <input type="text" name="document_no" id="document_no" class="form-control input-ui-100" maxlength="20" />
                                                    <span class="text-danger document_no_err"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 docField" style="display: none">
                                                <label for="document_expiry" class="control-label"><span class="text-danger">*</span>Document Expiry Date</label>
                                                <div class="form-group">
                                                    <input type="text" name="document_expiry" id="document_expiry" class="noBackDate form-control input-ui-100" maxlength="16" readonly="readonly" />
                                                    <span class="text-danger document_expiry_err"></span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="student_id" id="student_id" value="<?php echo $student['id']; ?>">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="hidden" name="image_id" id="image_id" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group form-checkbox">
                                                    <input type="checkbox" name="activeDoc" value="1" id="activeDoc" checked="checked" />
                                                    <label for="activeDoc" class="control-label">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="refresh_page();">
                            Close
                        </button>
                        <button type="button" class="btn btn-info" id="sendDoc" onclick="sendDoc();" >Save Documents</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal box for add doc ends-->
      <!-- modal box for  withdrawl starts-->
      <div class="modal fade" id="modal-Withdrawl" style="display: none;">
            <div class="modal-dialog  modal-xlg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="refresh_page();">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-heading text-info">Wallet Withdrawal <span class="text-success small"><?php echo 'Available Balance '.$wallet;?></span> </h4>
                        
                    </div>
                    <h5 class="msg_withdrawl"></h5>
              
                        <div class="box-body">
                       <?php if ($student['wallet'] / 100 > 0) { ?>
                                                <form id="submit_withdrawl">
                                                    <div class="col-md-12">
                                                        <label for="withdrawl_image" class="control-label">Payment
                                                            Screenshot</label>
                                                        <?php echo DOCUMENT_ALLOWED_LABEL; ?>
                                                        <!-- <div class="form-group">
                                                    <input type="file" name="withdrawl_image" class="form-control"/><br/>
                                                    <button class="btn btn-info" id="btn_upload" type="submit">Upload</button>
                                                    <div id="withdrawl_image_msg"></div>
                                                    <div class="form-group file-upload-wallet">
                                                <div class="input-file"><input type="file" name="withdrawl_image" class="form-control"/></div>
                                                    <div class="btn_upload-gp">
                                                        <button class="btn btn-info" id="btn_upload" type="submit">Upload</button>
                                                        <div id="withdrawl_image_msg"></div>
                                                    </div> -->
                                                        <div class="form-group file-upload-wallet">
                                                            <div class="input-file"><input type="file" name="withdrawl_image" id="withdrawl_image" class="form-control input-file-ui-100 input-file-ui" onchange="validate_file_type_stdWithdrawl(this.id)" />
                                                            </div>
                                                            
                                                            <div class="btn_upload-gp">
                                                                <button class="btn btn-info" id="btn_upload" type="submit">Upload</button>
                                                                <div id="withdrawl_image_msg" style="margin-top:10px"></div>
                                                            </div>
                                                        </div>
                                                        <span class="text-danger withdrawl_image_err"style="margin-top: -20px;position: absolute; font-size:12px"></span>
                                                    </div>

                             
                                    </form>
                                    <div class="col-md-4">
                                        <label for="withdrawl_method" class="control-label"><span class="text-danger">*</span>Payment mode</label>
                                        <div class="form-group">
                                            <select name="withdrawl_method" id="withdrawl_method" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
                                                <?php echo PAYMENT_OPTIONS_WALLET; ?>
                                            </select>
                                            <span class="text-danger withdrawl_method_err"><?php echo form_error('withdrawl_method'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="withdrawl_amount" class="control-label"><span class="text-danger">*</span>Withdrawal Amount</label>
                                        <div class="form-group">
                                            <input type="text" name="withdrawl_amount" id="withdrawl_amount" class="form-control input-ui-100 chknum1" maxlength="5" onblur="checkbal(this.value)" />
                                            <span class="text-danger withdrawl_amount_err"><?php echo form_error('withdrawl_amount'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="withdrawl_tran_id" class="control-label">Transaction Id</label>
                                        <div class="form-group">
                                            <input type="text" name="withdrawl_tran_id" id="withdrawl_tran_id" class="form-control input-ui-100" maxlength="16" />
                                            <span class="text-danger withdrawl_tran_id_err"><?php echo form_error('withdrawl_tran_id'); ?></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="residential_address" class="control-label"><span class="text-danger">*</span>Remarks</label>
                                        <div class="form-group">
                                            <textarea name="student_withdrawl_remarks" class="form-control textarea-ui-16" id="student_withdrawl_remarks" maxlength="255"></textarea>
                                            <span class="text-danger student_withdrawl_remarks_err"><?php echo form_error('student_withdrawl_remarks'); ?></span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="bal" id="bal" value="<?php echo $student['wallet'] / 100; ?>">
                                    <input type="hidden" name="student_id" id="student_id" value="<?php echo $student['id']; ?>">
                                    <input type="hidden" name="withdrawl_image_id" id="withdrawl_image_id" class="form-control" />
                                   
                                <?php } ?>
                               
                                <div class="col-md-12 text-right">
                                <!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="refresh_page();">
                                    Close
                                </button> -->
                                <?php if ($student['wallet'] / 100 > 0) { ?>
                                    <button type="button" class="btn btn-danger rd-20" id="sendWithdrawl" onclick="sendWithdrawl();">Submit</button>
                                <?php } ?>
                            </div>

                            <div class="col-md-12">
                                <div class="wallet_tran_history"></div>
                            </div>
                        
                                
                         
                        </div>
                       
                
                </div>
            </div>
        </div>

<!-- modal box for withdrawl ends-->
<!-- modal box for promocode starts-->
<div class="modal fade" id="modal-Discount-PromoCode" style="display: none;">
    <div class="modal-dialog modal-xlg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-heading text-info">Promo Codes</h4>
                <h5 class="msg_promocode_offline"></h5>
            </div>
            <div class="modal-body">
                <label for="bulk_promocode" class="control-label">Enter promo code(If any)</label>
                <div class="form-group d-flex">
                    <input type="text" name="bulk_promocode" id="bulk_promocode" placeholder="Enter promocode" class="form-control input-ui-100">
                    <input type="button" class="btn btn-info btn-ui-100" value="Apply" onclick="applyBulkPromocode();">
                    <span class="text-danger bulk_promocode_err"></span>
                </div>
                <div class="bulk_promocode_response"></div>
                <div class="promocode_response"></div>
                <div class="special_promocode_response"></div>
                <div class="OnapplyPromocodeMSG"></div>
            </div>
            <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                        Close
                    </button>
                </div> -->
        </div>
    </div>
</div>
<!-- modal box for promocode ends-->
<!-- modal box for promocode range starts-->
<div class="modal fade" id="modal-Range-PromoCode" style="display: none;">
    <div class="modal-dialog" style="width:1000px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-heading text-info">Promo Codes Ranges</h4>
            </div>
            <div class="modal-body">
                <div class="range_response"></div>
            </div>
            <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                        Close
                    </button>
                </div> -->
        </div>
    </div>
</div>
<input type="hidden" name="pack_duration" id="pack_duration">
<!-- modal box for promocode range ends-->
<div>
<?php ob_start(); ?>
<script id="rendered-js">
    $(".dob_mask:input").inputmask();
</script>
<script type="text/javascript">

$(".change_startdate").change(function(){    
    var datew = $(this).datepicker("getDate"); 
    datew.setDate(datew.getDate() + 5); //Set date object adding 5 days.    
    /*  var date = new Date(this.value);   
    // Add ten days to specified date
    date.setDate(date.getDate() + 5);  */  
	$("#due_commitment_date,#due_commitment_date_pp,#due_commitment_date_off").datepicker("destroy");
    $("#due_commitment_date,#due_commitment_date_pp,#due_commitment_date_off").datepicker({
		startDate: this.value,
		endDate:datew,
		autoclose: true,
        //format:'dd/mm/yyyy'
	}); 
});

function check_all_validation()
{
    var flag=1;
    if( $('#package_id').val() == "")
    {			
    $(".package_id_err").html('The Online Class Package field is required.');
    flag=0;
    } else { $(".package_id_err").html(''); }

    if( $('#batch_id').val() == "")
    {			
    $(".batch_id_err").html('The Batch field is required.');
    flag=0;
    } else { $(".batch_id_err").html(''); }

    if( $('#method').val() == "")
    {			
    $(".method_err").html('The Batch field is required.');
    flag=0;
    } else { $(".method_err").html(''); }

    if( $('#discount_type').val() == "")
    {			
    $(".discount_type_err").html('The Discount Type field is required.');
    flag=0;
    } else { $(".discount_type_err").html(''); }

    if( $('#amount_paid').val() == "")
    {			
    $(".amount_paid_err").html('The Amount Paid field is required.');
    flag=0;
    } else { $(".amount_paid_err").html(''); }

    if( $('#start_date').val() == "")
    {			
    $(".start_date_err").html('The Start Date field is required.');
    flag=0;
    } else { $(".start_date_err").html(''); }  

    if(flag == 1)
    {
        var con = confirm('<?php echo SUBMISSION_CONFIRM ?>');
        if (con == false) {
        return false;
        }
        else {
        return true;
        }   
    } 
    else {
    return false;
    } 

}
function check_all_validation_pp()
{
    
    var flag=1;
    if( $('#package_id_pp').val() == "")
    {			
    $(".package_id_pp_err").html('The Online Class Package field is required.');
    flag=0;
    } else { $(".package_id_pp_err").html(''); }

    if( $('#method_pp').val() == "")
    {			
    $(".method_pp_err").html('The Batch field is required.');
    flag=0;
    } else { $(".method_pp_err").html(''); }

    if( $('#discount_type_pp').val() == "")
    {			
    $(".discount_type_pp_err").html('The Discount Type field is required.');
    flag=0;
    } else { $(".discount_type_pp_err").html(''); }

    if( $('#amount_paid_pp').val() == "")
    {			
    $(".amount_paid_err").html('The Amount Paid field is required.');
    flag=0;
    } else { $(".amount_paid_err").html(''); }

    if( $('#start_date_pp').val() == "")
    {			
    $(".start_date_pp_err").html('The Package Starting Date field is required.');
    flag=0;
    } else { $(".start_date_pp_err").html(''); }  

    if(flag == 1)
    {
        var con = confirm('<?php echo SUBMISSION_CONFIRM ?>');
        if (con == false) {
        return false;
        }
        else {
        return true;
        }   
    } 
    else {
    return false;
    } 

}

function validatefatherdob(data, id)
{
            if (data != "") {
				const today = new Date();
				const dob = new Date(data);
				const diffTime = Math.floor(today - dob);
				const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)/31/12); 
				
				if(diffDays < 28)	
					$('.father_dob_err').html('Age should be minimum 25 years');			
					$('#'+id).val('');
					return false;
				
            }

}

        //$(".dob_mask:input").inputmask();
        function checkDuplicateInhousePackBooking() {
            var package_id = $("#package_id_off").val();
            var student_id = $("#student_id").val();
            var type = $('input[name=pack_cb]:checked').val();
            $.ajax({
                url: WOSA_ADMIN_URL + 'student/ajax_checkDuplicateInhousePackBooking',
                async: true,
                type: 'post',
                data: {
                    package_id: package_id,
                    student_id: student_id,
                    type: type
                },
                dataType: 'json',
                success: function(response) {
                    if (response > 0) {
                        var con = confirm("Warning: This pack is already active for this student.Do you want to continue booking?");
                        if (con == false) {
                            $('#package_id_off').prop('selectedIndex', '');
                            $('#package_id_off').selectpicker('refresh');
                            $('.packInfo').hide();
                            return false;
                        } else {
                            return true;
                        }
                    } else {
                        return true;
                    }
                }
            });
        }
    </script>
    <?php global $customJs;
    $customJs = ob_get_clean(); ?>