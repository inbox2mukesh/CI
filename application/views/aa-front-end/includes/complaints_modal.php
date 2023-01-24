<style>
    .d-none {
        display: none !important;
    }
</style>
<!---Modal Complaint-->
<div class="modal fade modal-lg" id="modal-complaint" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close red-text font-16"></i></button>
                <div class="w-title">Register Complaint</div>
            </div>
            <form id="save_complaint_form" method="post" enctype="multipart/form-data" onsubmit="return validateWosaAdminForm('save_complaint_form');">
                <?php
                if (isset($this->session->userdata('student_login_data')->id)) {
                    $readOnly = ' readonly="readonly" ';
                    $disabled_sel = ' disabled="disabled" ';
                } else {
                    $readOnly = '';
                    $disabled_sel = '';
                }
                $fname = isset($this->session->userdata('student_login_data')->fname) ? $this->session->userdata('student_login_data')->fname : '';
                $lname = isset($this->session->userdata('student_login_data')->lname) ? $this->session->userdata('student_login_data')->lname : '';
                $mobile = isset($this->session->userdata('student_login_data')->mobile) ? $this->session->userdata('student_login_data')->mobile : '';
                $email = isset($this->session->userdata('student_login_data')->email) ? $this->session->userdata('student_login_data')->email : '';
                $studentId = isset($this->session->userdata('student_login_data')->id) ? $this->session->userdata('student_login_data')->id : 0;
                ?>
                <input type="hidden" name="comp_lead_origin_type" id="comp_lead_origin_type" value="op"/>
                <input type="hidden" name="comp_origin" id="comp_origin" value="website-1"/>
                <input type="hidden" name="comp_medium" id="comp_medium" value="complaints"/>
                <input type="hidden" name="comp_purpose_level_one" id="comp_purpose_level_one" value="42"/>
                <input type="hidden" name="comp_student_id" id="comp_student_id" value="<?php echo $studentId; ?>"/>
                <input type="hidden" name="comp_purpose_level_two" id="comp_purpose_level_two" value=""/>
                <input type="hidden" name="comp_division_id" id="comp_division_id" value=""/>
                <div class="wizard">
                    <div class="tab-content cmp-bg">
                        <!--Start Step-1-->
                        <div class="tab-pane active" role="tabpanel" id="step1">
                            <div class="disc-info-box"> 
                                <div class="f-title">Enter Details</div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Country Code<span class="red-text">*</span></label>
                                            <select class="selectpicker form-control" data-live-search="true" id="comp_country_code" name="comp_country_code"  <?php echo $disabled_sel; ?> <?php echo $readOnly; ?> title="Code" onchange="getMobileLimit();" required>
                                                <option value="">Select</option>
                                                <?php
                                                $c = '+91';
                                                foreach ($countryCode->error_message->data as $p) {
                                                    $selected = ($p->country_code == $c) ? ' selected="selected"' : "";
                                                    echo '<option value="' . $p->country_code . '" ' . $selected . ' data-iso="' . $p->iso3 . '">' . $p->country_code . '-' . $p->iso3 . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <div class="valid-validation comp_country_code_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Phone Number <span class="red-text">*</span></label>
                                            <input type="text" class="fstinput allow_numeric" name="comp_mobile" id="comp_mobile" value="<?php echo $mobile; ?>"  <?php echo $readOnly; ?> minlength="10" maxlength="10" autocomplete="off" title="Mobile Number" required/> 
                                            <div class="valid-validation comp_mobile_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 block-verify-btn">
                                        <div class="form-group verify-btn">
                                            <a href="javascript:void(0);" id="verify_phone_btn">Verify Phone  <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="block-verification-fields d-none">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Enter Verification Code <span class="red-text">*</span></label>						<input type="text" class="fstinput" placeholder="">				 
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group" style="margin-top: 28px;">
                                                <button type="button" class="btn btn-green font-weight-500">Verify</button> 
                                                <button type="button" class="btn btn-yellow font-weight-500">Resend</button> 
                                                <button type="button" class="btn btn-gray font-weight-500">Resend in 60 Sec</button>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="display: inline-block;">
                                            <p>A verification Code has been sent to your email, please enter verification code and click next.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ft-step">
                                <ul class="list-inline pull-right">
                                    <li>
                                        <button type="button" class="btn btn-mdl next-step">Next</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--End Step-1-->
                        <!--Start Step-2-->
                        <div class="tab-pane" role="tabpanel" id="step2">
                            <div class="disc-info-box"> 
                                <div class="f-title">User Details</div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group ">
                                            <label>First Name<span class="red-text">*</span></label>
                                            <input type="text" class="fstinput" name="comp_first_name" id="comp_first_name" value="<?php echo $fname; ?>" <?php echo $readOnly; ?>  maxlength="30" autocomplete="off" title="First Name" required/>
                                            <div class="valid-validation comp_first_name_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Last Name<span class="red-text">*</span></label>
                                            <input type="text" class="fstinput" name="comp_last_name" id="comp_last_name" value="<?php echo $lname; ?>"  <?php echo $readOnly; ?>  maxlength="30" autocomplete="off" title="Last Name" required/>
                                            <div class="valid-validation comp_last_name_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Valid Email <span class="red-text">*</span></label>
                                            <input type="email"  <?php echo $readOnly; ?> class="fstinput" autocomplete="off" name="comp_email" id="comp_email" value="<?php echo $email; ?>"  maxlength="60" autocomplete="off" title="Email address" required/> 
                                            <div class="valid-validation comp_email_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Date Of Birth<span class="text-red">*</span></label>
                                            <div class="has-feedback">
                                                <input class="fstinput datepicker" title="Date Of Birth" name="dc" placeholder="mm/dd/yyyy" id="dc" required> <span class="fa fa-calendar form-group-icon"></span> 
                                                <div class="valid-validation dc_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ft-step">
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="btn btn-mdl prev-step">Back</button></li>
                                    <li><button type="button" class="btn btn-mdl next-step">Next</button></li>
                                </ul>
                            </div>
                        </div>
                        <!--End Step-2-->
                        <!--Start Step-3-->
                        <div class="tab-pane" role="tabpanel" id="step3">
                            <div class="disc-info-box"> 
                                <div class="f-title">Add Complaints</div>			
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group ">
                                            <label>Product/Services<span class="red-text">*</span></label>
                                            <select class="selectpicker form-control complaint_product_id"  name="comp_product_id" id="comp_product_id" title="Product" required></select>
                                            <div class="valid-validation comp_product_id_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Subject<span class="red-text">*</span></label>
                                            <select class="selectpicker form-control complaint_subject_id"  name="comp_complain_subject" id="comp_complain_subject" title="Subject" required>
                                            <option value="">Select subject</option>
                                        </select> 
                                            <div class="valid-validation comp_complain_subject_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Message<span class="red-text">*</span></label>
                                            <textarea class="txtarea" placeholder="Write your complaint message upto 150 words.." rows="3" class="form-control" name="comp_note" id="comp_note" title="Description" required></textarea>
                                        <div class="valid-validation comp_note_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Attachments <span class="font-12">( Allowed: jpg, png, jpeg, pdf, mp3, mp4, wav )</span></label>
                                            <input type="file" class="fstinput" id="files" name="files" multiple="multiple"> </div>
                                    </div>
                                </div>
                                <div class="block-success-box d-none">
                                <div class="f-title">Dear User,</div>			
                                <div>Your Complaint has been registered and our customers representative will connect with you shortly.</div>
                                <div class="mt-20">Your Complaint ID is <span class="ylw-bg-info">123ZHKGN</span></div>
                            </div>
                            </div>
                            <div class="ft-step">
                                <ul class="list-inline pull-right">
                                    <!--									<li>Auto Close in 10 Sec.</li>-->
                                    <li><button type="button" class="btn btn-mdl prev-step">Back</button></li>
                                    <li><button type="button" id="btn-complain" class="btn btn-mdl next-step">Submit</button></li>
                                </ul>
                            </div>
                        </div>
                        <!--End Step-3-->
                        </form>
                    </div>
                    <div class="wizard-inner">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"> <a href="#step1" data-toggle="tab" aria-controls="step1"><span class="round-tab">1 </span></a></li>
                            <li role="presentation" class="disabled"> <a href="#step2" data-toggle="tab" aria-controls="step2"><span class="round-tab">2</span></a> </li>
                            <li role="presentation"> <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" class=""><span class="round-tab disabled">3</span></a> </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Modal Complaint-->
<?php ob_start(); ?>
<script type="text/javascript">

    function validate_complaint_email(email) {

        var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
        if (email.match(mailformat)) {
            $(".email_err").text('');
            $('.complaintBtn').prop('disabled', false);
            return true;
        } else {
            $(".email_err").text("Please enter valid email Id!");
            $('#email').focus();
            $('.complaintBtn').prop('disabled', true);
            return false;
        }
    }

    function Send_Complaints() {

        var numberes = /^[0-9-+]+$/;
        var letters = /^[A-Za-z ]+$/;
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;

        var complain_subject = $("#complain_subject_comp").val();
        var fname = $("#fname_comp").val();
        var lname = $("#lname_comp").val();
        var mobile = $("#mobile_comp").val();
        var email = $("#email_comp").val();
        var complaint_text = $("#complaint_text_comp").val();
        var country_code = $("#country_code").val();
        var attachment_file = $("#attachment_file").val().split('\\').pop();

        if (complain_subject != '') {
            $(".complain_subject_comp_err").text('');
        } else {
            $("#complain_subject_comp").focus();
            $(".complain_subject_comp_err").text("Please select subject of complaint!");
            return false;
        }

        if (fname.match(letters)) {
            $(".fname_err_comp").text('');
        } else {
            $("#fname").focus();
            $(".fname_err_comp").text("Please enter valid Name. Numbers not allowed!");
            return false;
        }

        /* if(lname.match(letters)){
         $(".lname_err_comp").text('');
         }else{
         $("#lname").focus();
         $(".lname_err_comp").text("Please enter valid Name. Numbers not allowed!");
         return false;
         }*/


        if (mobile.match(numberes)) {
            $(".mobile_err_comp").text('');
        } else {
            $("#mobile").focus();
            $(".mobile_err_comp").text("Please enter valid number. Alphabets not allowed!");
            return false;
        }

        if (mobile.length > 10 || mobile.length < 10) {
            $("#mobile").focus();
            $(".mobile_err_comp").text('Please enter valid Number of 10 digit');
            return false;
        } else {
            $(".mobile_err_comp").text('');
        }

        if (emailReg.test(email)) {
            $(".email_err_comp").text('');
        } else {
            $("#email").focus();
            $(".email_err_comp").text('Please enter valid Email Id');
            return false;
        }

        if (complaint_text != '' && complaint_text.length <= 150) {
            $(".complaint_text_err").text('');
        } else {
            $("#complaint_text").focus();
            $(".complaint_text_err").text("Please enter you message upto 150 chars!");
            return false;
        }
        if (attachment_file != "")
        {
            if (validate(attachment_file) == 1)
            {
                $(".attachment_err_comp").text('');
            } else {
                $("#attachment_file").val('');
                $("#attachment_file").focus();
                $(".attachment_err_comp").text("File Format not supported!");
                return false;
            }
        }
        //return false;
        var form = document.getElementById('first_form'); //id of form
        var formdata = new FormData(form);
        $.ajax({
            url: "<?php echo site_url('Complaints/send_complaint'); ?>",
            type: 'post',
// data: form_data,   
            data: formdata,
            processData: false,
            contentType: false,
            success: function (response)
            {
                if (response.status == 'true')
                {
                    $('#modal-complaint').modal('hide');
                    $('#modal-OTP').modal('show');
                } else
                {
                    $('.complaintBtnDiv_pro').hide();
                    $('.msg_comp').html(response.msg);
                    $('.otpform').hide();
                }
            },
            beforeSend: function () {
                $('#btn-complain').hide();
                $('.complaintBtnDiv_pro').show();
                $('.mainForm').show();
            }
        });

    }
    function validate(file) {
        //alert(file)
        var ext = file.split(".");
        ext = ext[ext.length - 1].toLowerCase();
        var arrayExtensions = ["jpg", "jpeg", "png", 'pdf', 'mp4', 'webm', 'ogg', 'mp3', 'wav', 'mpeg'];

        if (arrayExtensions.lastIndexOf(ext) == -1) {
            return -1;
//$("#image").val("");
        } else {
            return 1;
        }
    }

    $(document).on('keyup', '#comp_mobile', function () {
        var country_code = $('#comp_country_code').val();
        var mobile = $('#comp_mobile').val();
        if (country_code !== '' && mobile.length === 10) {
            getStudentInfo(country_code, mobile);
        }
    });

    $(document).on('click', '#btn-complain', function () {
        if (validateWosaAdminForm('save_complaint_form')) {
            var form = document.getElementById('save_complaint_form');
            var formdata = new FormData(form);
            $.ajax({
                url: "<?php echo site_url('Complaints/send_complaint'); ?>",
                type: 'post',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response)
                {
                    if (response.status == 'true')
                    {
                        if (response.data.is_otp_verified === '0') {
                            $('#modal-complaint').modal('hide');
                            $('#modal-OTP').modal('show');
                        } else {
                            $('#modal-complaint').modal('hide');
                            $('#modal_complaint_success').modal('show');
//                                $('.complaintBtnDiv_pro').hide();
//                                $('.msg_comp').html(response.msg);
//                                $('.otpform').hide();
                        }
                    } else
                    {
//                            $('.complaintBtnDiv_pro').hide();
//                            $('.msg_comp').html(response.msg);
//                            $('.otpform').hide();
                    }
                },
                beforeSend: function () {
//                        $('#btn-complain').hide();
//                        $('.complaintBtnDiv_pro').show();
//                        $('.mainForm').show();
                }
            });
        }
    });

    /**
     * This function can be used to validate any form.
     * Some attributes are mandetory to validate like required, minlength, maxlength etc.
     * 
     * @param {string} formId
     * @returns {Boolean}
     */
    function validateWosaAdminForm(formId) {
        var form = document.getElementById(formId);
        var data = new FormData(form);
        var checks = [];
        var validRegexEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        for (var [key, value] of data) {

            var input_type = $('#' + key).attr('type');
            var is_required = $('#' + key).attr('required');
            var min_length = $('#' + key).attr('minlength');
            var max_length = $('#' + key).attr('maxlength');
            var title = $('#' + key).attr('title');
            var message = (title !== undefined) ? title : 'This field ';
            var input_length = value.length;
            if (value === '' && is_required !== undefined) {
                $('.' + key + '_error').html(message + ' is mandatory');
                checks.push(false);
            } else if (input_type == 'email' && !value.match(validRegexEmail) && value != '') {

                $('.' + key + '_error').html('Invalid email address!');
                checks.push(false);
            } else {
                $('.' + key + '_error').html('');
            }
            if (min_length !== undefined && input_length < min_length) {
                $('.' + key + '_error').html(message + '  must be minimun ' + min_length + ' characters');
                checks.push(false);
            }
            if (max_length !== undefined && input_length > max_length) {

                $('.' + key + '_error').html(message + '  can not be more than ' + max_length + ' characters');
                checks.push(false);
            }
        }
        return checks.includes(false) ? false : true;
    }

    /**
     * This function is defined to validate numeric entries only.
     * 
     * @param {type} evt
     * @returns {Boolean}
     */
    $(".allow_numeric").on("input", function (evt) {
        var self = $(this);
        self.val(self.val().replace(/\D/g, ""));
        if ((evt.which < 48 || evt.which > 57))
        {
            evt.preventDefault();
        }
    });

    $(document).on('change', '.complaint_product_id#comp_product_id', function () {
        var division_id = $('.complaint_product_id#comp_product_id > option:selected').attr('data-division');
        var _id = $('.complaint_product_id#comp_product_id > option:selected').val();
        if (_id && division_id !== undefined) {
            $('#comp_division_id').val(division_id);
            var p2 = division_id === '<?php echo VISA_DIVISION_PKID; ?>' ? 45 : 43;
            $('#comp_purpose_level_two').val(p2);
            var uri = "<?php echo site_url('Products/subjects'); ?>/" + _id;
            globalAjaxCall(uri, 'get').done(function (response) {
                var rows = JSON.parse(response);
                var selectBox = '';
                if (rows.length) {
                    $.each(rows, function (index, row) {
                        selectBox += '<option value="' + row['id'] + '">' + row['subject'] + '</option>';
                    });
                }
                $('.complaint_subject_id#comp_complain_subject').html(selectBox);
                $('.complaint_subject_id#comp_complain_subject').selectpicker('refresh');
            });
        } else {
            $('#comp_division_id').val('');
            $('.complaint_subject_id#comp_complain_subject').html('');
            $('.complaint_subject_id#comp_complain_subject').selectpicker('refresh');
        }
    });

    /**
     * 
     
     * @returns {undefined}     */
    function getProducts() {
        var uri = "<?php echo site_url('Products/index'); ?>";
        globalAjaxCall(uri, 'get').done(function (response) {
            var rows = JSON.parse(response);
            var selectBox = '';
            if (rows.length) {
                $.each(rows, function (index, row) {
                    selectBox += '<option value="' + row['id'] + '" data-division="' + row['division_id'] + '">' + row['name'] + '</option>';
                });
            }
            $('.complaint_product_id#comp_product_id').html(selectBox);
            $('.complaint_product_id#comp_product_id').selectpicker('refresh');
        });
    }

    /**
     * 
     * @param {type} country_code
     * @param {type} mobile
     * @returns {undefined}
     */
    function getStudentInfo(country_code, mobile) {
        var uri = "<?php echo site_url('Products/get_student_id'); ?>";
        globalAjaxCall(uri, 'post', {country_code: country_code, mobile: mobile}).done(function (response) {
            var rows = JSON.parse(response);
            $('#comp_student_id').val(rows);
        });
    }

    /**
     * 
     * @type type
     */
    document.addEventListener('invalid', (function () {
        return function (e) {
            e.preventDefault();
        };
    })(), true);

    /**
     * This function is used to call AJAX request.
     * 
     * @param {string} uri
     * @param {string} req_type
     * @param {mixed} params
     * @returns {jqXHR}
     */
    function globalAjaxCall(uri, req_type = 'post', params = '') {
        return $.ajax({
            url: uri,
            type: req_type,
            data: params
        });
    }

    $(document).ready(function () {
        getProducts();
    });
    $('#modal-complaint').on('show.bs.modal', function () {
        $('#save_complaint_form').trigger('reset');
        $('.complaint_subject_id#comp_complain_subject').html('');
        $('.selectpicker').selectpicker('refresh');
    });

    getMobileLimit();
    function getMobileLimit() {
        var country_code = $('#comp_country_code > option:selected').attr('data-iso');
        $.ajax({
            url: "<?php echo site_url('purpose/ajax_getPhoneLimit'); ?>",
            async: true,
            type: 'post',
            data: {country_code: country_code},
            dataType: 'json',
            success: function (data) {
                for (i = 0; i < data.length; i++) {
                    if (data[i]['min_phoneNo_limit'] > 0) {
                        $("#comp_mobile").attr('minlength', data[i]['min_phoneNo_limit']);
                    } else {
                        $("#comp_mobile").attr('minlength', 10);
                    }

                    if (data[i]['phoneNo_limit'] > 0) {
                        $("#comp_mobile").attr('maxlength', data[i]['phoneNo_limit']);
                    } else {
                        $("#comp_mobile").attr('maxlength', 10);
                    }
                    $('#comp_mobile').val('');
                }
            }
        });
    }
</script>
<?php
global $customJs;
$customJs = ob_get_clean();
?>
