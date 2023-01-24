
                                            <style>

                                                .rating {
                                                    border: none;
                                                    float: left;
                                                    /*margin-right: 49px*/
                                                }

                                                .myratings {
                                                    font-size: 16px;
                                                    color: #221a18;
                                                    font-weight: bold;
                                                    line-height: 57px;
                                                    margin-left: 10px;
                                                }

                                                .rating>[id^="star"] {
                                                    display: none
                                                }

                                                .rating>label:before {
                                                    margin: 5px;
                                                    font-size: 2.25em;
                                                    font-family: FontAwesome;
                                                    display: inline-block;
                                                    content: "\f005"
                                                }

                                                .rating>.half:before {
                                                    content: "\f089";
                                                    position: absolute
                                                }

                                                .rating>label {
                                                    color: #ddd;
                                                    float: right
                                                }

                                                .rating>[id^="star"]:checked~label,
                                                .rating:not(:checked)>label:hover,
                                                .rating:not(:checked)>label:hover~label {
                                                    color: #000
                                                }

                                                .rating>[id^="star"]:checked+label:hover,
                                                .rating>[id^="star"]:checked~label:hover,
                                                .rating>label:hover~[id^="star"]:checked~label,
                                                .rating>[id^="star"]:checked~label:hover~label {
                                                    color: #000
                                                }

                                                .reset-option {
                                                    display: none
                                                }

                                                .reset-button {
                                                    margin: 6px 12px;
                                                    background-color: rgb(255, 255, 255);
                                                    text-transform: uppercase
                                                }
                                            </style>
<?php
if (isset($this->session->userdata('student_login_data')->id)) {
    $readOnly = 'readonly="readonly" ';
    $disabled_sel = "disabled='disabled'";
} else {
    $readOnly = '';
    $disabled_sel = "";
}
?>
<div class="feedback">
    <div class="modal fade" id="modal-feedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="feedback-modal"> <span class="cross-btn pull-right text-black hide-btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close font-20"></i></span>
                        <div class="review-info"><h2>FEEDBACK</h2>	
                            <div id="sec1">				
                                <select name="mySelect1" class="selector_feed selectpicker form-control" id="selector_feed">
                                    <option>Select Feedback Type</option>
                                    <option value="f1">Internal Feedback</option>
                                    <option value="f2">Google Review</option>
                                </select>

                                <div id="f1" class="show-vlu mt-15">
                                    <div class="feedback-scroll" id="scroll-style1">
                                        <form id="save_feedback_form" method="post" enctype="multipart/form-data" onsubmit="return validateWosaAdminForm('save_complaint_form');">
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
                            <input type="hidden" name="feed_lead_origin_type" id="feed_lead_origin_type" value="op"/>
                            <input type="hidden" name="feed_origin" id="feed_origin" value="website-1"/>
                            <input type="hidden" name="feed_medium" id="feed_medium" value="feedback"/>
                            <input type="hidden" name="feed_purpose_level_one" id="feed_purpose_level_one" value="47"/>
                            <input type="hidden" name="feed_student_id" id="feed_student_id" value="<?php echo $studentId; ?>"/>
                            <input type="hidden" name="feed_purpose_level_two" id="feed_purpose_level_two" value=""/>
                            <input type="hidden" name="feed_division_id" id="feed_division_id" value=""/>
                            <div class="row clearfix">
                                <div class="form-group col-md-6 col-sm-6">
                                    <div>
                                        <label>First Name<span class="red-text">*</span></label>
                                        <input type="text" class="fstinput" name="feed_first_name" id="feed_first_name" value="<?php echo $fname; ?>" <?php echo $readOnly; ?>  maxlength="30" autocomplete="off" title="First Name" required/> 
                                    </div>
                                    <div class="valid-validation feed_first_name_error"></div> 
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <div>
                                        <label>Last Name<span class="red-text">*</span></label>
                                        <input type="text" class="fstinput" name="feed_last_name" id="feed_last_name" value="<?php echo $lname; ?>"  <?php echo $readOnly; ?>  maxlength="30" autocomplete="off" title="Last Name" required/>
                                        <div class="valid-validation feed_last_name_error"></div>  
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="form-group col-md-4 col-sm-4">
                                    <div>
                                        <label>Country Code<span class="red-text">*</span></label>
                                        <select class="selectpicker form-control" data-live-search="true" id="feed_country_code" name="feed_country_code"  <?php echo $disabled_sel; ?> <?php echo $readOnly; ?> title="Code" onchange="getMobilePhoneLimit();" required>
                                            <option value="">Select</option>
                                            <?php
                                            $c = '+91';
                                            foreach ($countryCode->error_message->data as $p) {
                                                $selected = ($p->country_code == $c) ? ' selected="selected"' : "";
                                                echo '<option value="' . $p->country_code . '" ' . $selected . ' data-iso="'.$p->iso3.'">' . $p->country_code . '-' . $p->iso3 . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <div class="valid-validation feed_country_code_error"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-8 col-sm-8">
                                    <div>
                                        <label>Mobile Number<span class="red-text">*</span></label>
                                        <input type="text" class="fstinput allow_numeric" name="feed_mobile" id="feed_mobile" value="<?php echo $mobile; ?>"  <?php echo $readOnly; ?> minlength="10" maxlength="10" autocomplete="off" title="Mobile Number" required/>
                                        <div class="valid-validation feed_mobile_error"></div>   
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="form-group col-md-12 col-sm-12">			
                                    <div>
                                        <label>Email<span class="red-text">*</span></label>
                                        <input type="email"  <?php echo $readOnly; ?> class="fstinput" autocomplete="off" name="feed_email" id="feed_email" value="<?php echo $email; ?>"  maxlength="60" autocomplete="off" title="Email address" required/> 
                                        <div class="valid-validation feed_email_error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="form-group col-md-6 col-sm-6">
                                    <div>
                                        <label>Select Product<span class="red-text">*</span></label>
                                        <select class="selectpicker form-control feedback_product_id"  name="feed_product_id" id="feed_product_id" title="Product" required></select>
                                    </div>
                                    <div class="valid-validation feed_product_id_error"></div>   
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <div>
                                        <label>Select Subject<span class="red-text">*</span></label>
                                        <select class="selectpicker form-control feedback_subject_id"  name="feed_feedback_subject" id="feed_feedback_subject" title="Subject" required>
                                            <option value="">Select subject</option>
                                        </select>
                                    </div>
                                    <div class="valid-validation feed_feedback_subject_error"></div>   
                                </div>
                            </div>
                            <div class="row clearfix">
                                
                                <div class="col-md-12">	
                                    <div class="">
                                <div class="rating">
                                    <input type="radio" class="rating_star" id="star5" name="rating" value="5" />
                                    <label class="full" for="star5" title="Awesome - 5 stars"></label> 

                                    <!-- <input type="radio" class="rating_star" id="star4half" name="rating" value="4.5" />
                                    <label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>  -->

                                    <input type="radio" class="rating_star" id="star4" name="rating" value="4" />
                                    <label class="full" for="star4" title="Pretty good - 4 stars"></label>

                                    <!-- <input type="radio" class="rating_star" id="star3half" name="rating" value="3.5" />
                                    <label class="half" for="star3half" title="Meh - 3.5 stars"></label> -->

                                    <input type="radio" class="rating_star"id="star3" name="rating" value="3" />
                                    <label class="full" for="star3" title="Meh - 3 stars"></label> 

                                    <!-- <input type="radio" class="rating_star" id="star2half" name="rating" value="2.5" />
                                    <label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label> -->

                                    <input type="radio" class="rating_star" id="star2" name="rating" value="2" />
                                    <label class="full" for="star2" title="Kinda bad - 2 stars"></label> 

                                    <!-- <input type="radio" class="rating_star" id="star1half" name="rating" value="1.5" />
                                    <label class="half" for="star1half" title="Meh - 1.5 stars"></label>  -->

                                    <input type="radio" class="rating_star" id="star1" name="rating" value="1" />
                                    <label class="full" for="star1" title="Sucks big time - 1 star"></label>

                                    <!-- <input type="radio" class="rating_star" id="starhalf" name="rating" value="0.5" checked/><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>  -->
                                    
                                    <input type="radio" class="reset-option" name="rating" value="reset" /> 
                                    <div class="validation text-red rating_error" style="font-size: 12px !important;font-weight: 600;"></div>
                                </div>
                                        <div class="myratings">&nbsp;&nbsp;&nbsp;<span class="myratings_count">.5</span> Rate us</div>
                                    </div>				
                                </div>
                                
                                <div class="form-group col-md-12">
                                    <div>
                                        <label>Please Explain in Detail<span class="red-text">*</span></label>
                                        <textarea class="txtarea" placeholder="Write your feedback upto 150 words.." rows="3" class="form-control" name="feed_note" id="feed_note" title="Description" required></textarea>
                                        <div class="valid-validation feed_note_error"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="button" class="btn btn-red btn-mdl feedbackBtn" id="btn-feedback">SUBMIT</button>
                                </div>
<!--                                <div class="col-md-12 complaintBtnDiv_pro text-right" style="display: none;">
                                    <button type="button" class="btn btn-blue complaintBtn_pro">Sending please wait..</button> <i class="fa fa-spinner fa-spin mr-10"></i>
                                </div>-->
                                <div class="col-md-12 msg_feed"></div>
                            </div>
                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="hide" id="sec2">
                                <div class="alert alert-danger alert-dismissible hide" id="dis_fail_err">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <span id="dis_fail_err_text"></span>
                                </div>
                                <div class="alert alert-success alert-dismissible hide" id="dis_success_err">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <span id="dis_success_err_text"></span>
                                </div>

                            </div>
                        </div>
                        <div id="f2" class="show-vlu mt-15 pl-10  pr-10">
                            <div class="form-group">
                                <select name="subSelect1" class="selectpicker form-control" id="feed_googlebranch" data-live-search="true">
                                    <option value="">Select Branch</option>
<?php
foreach ($GET_GOOGLE_FEEDBACK_BRANCH->error_message->data as $p) {
    echo '<option value="' . $p->feedbackLink . '">' . $p->center_name . '</option>';
}
?>
                                </select>
                            </div>
                            <div class="text-center mt-15">
                                <a href="" target="_blank" class="btn btn-white btn-mdl" id="write_review_btn" disabled>Write Review</a>
                            </div>
                        </div>					
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<div class="subscription-otp" >
    <div class="modal fade" id="feedback-OTP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="reg-modal clearfix"> <span class="cross-btn pull-right text-black " data-dismiss="modal"><i class="fa fa-close font-20"></i></span>
                        <div class="reg-otp-info text-center text-black ">
                            <h3>Verification Code</h3>
                            <p class="mb-10 font-12 " id="sub_success_info"></p>

                            <div class="form-group">
                                <div class="subs-group" id="optmain_sec">
                                    <input type="text" class="form-control" name="fbk_otp" id="fbk_otp" maxlength="4" placeholder="Please Enter OTP" style="height:55px;">
                                    <input type="hidden" id="feed_student_id" name="feed_student_id"/>
                                    <input type="hidden" id="feedbackTopic" name="feedbackTopic"/>
                                    <input type="hidden" id="ratingPoint" name="ratingPoint"/>
                                    <input type="hidden" id="feedbackReview" name="feedbackReview"/>
                                    <button class="btn btn-blue btn-subs"  onclick="return Verify_fbk_opt(this.value);" id="verifyBtn" type="button">Verify</button>      
                                </div>
                                <div class="validation hide fbk_reg_otp_err" > Wrong OTP!</div>
                            </div>
                            <div class="alert alert-success hide alert-dismissible  mt-10  " id="otp_fbk_success_info" role="alert">               
                                <div id="opt_fbk_success_info_text"></div>
                            </div>
                            <div class="alert alert-danger hide alert-dismissible  mt-10  " id="otp_fbk_error_info" role="alert">
                                <div id="opt_fbk_error_info_text"></div>
                            </div>               
                        </div>
                        <!--End Login Popup-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(function ()
    {

        $('#fbk_review').change(function () {
            var wordString = $(this).val();
            var words = wordString.split(" ");
            words = words.filter(function (words) {
                return words.length > 0
            }).length;
            //alert(words)
            if (words > 150) {
                $(".text_error").text("Please enter max. 150 words only!");
                $("#fbk_review").focus();
                return false;
            } else {
                $(".text_error").text("");
            }
        });


        $('#selector_feed').change(function () {
            $('.show-vlu').hide();
            $('#' + $(this).val()).show();
        });

        $('#feed_googlebranch').change(function ()
        {
            $('#write_review_btn').attr("disabled", false);
            $('#write_review_btn').attr("href", $(this).val())

        });
        $(".rating_star").click(function () {
            var sim = $(".rating_star:checked").val();
            $(".myratings_count").text(sim)


        });

    });
    function validate_fbk()
    {
        var letters = /^[A-Za-z ]+$/;
        var filter = /^[0-9-+]+$/;
        var fname = $("#fbk_fname").val();
        var lname = $("#fbk_lname").val();
        var country_code = $("#fbk_countrycode").val();
        var mobile = $("#fbk_mobileno").val();
        var email = $("#fbk_emailid").val();
        var fbk_topic = $("#fbk_topic").val();
        var message = $("#fbk_review").val();
        var rating = $(".rating_star:checked").val();

        if (fname == '')
        {
            $("#fbk_fname").focus();
            $(".fbk_fname_error").text("Please enter First Name!");
            return false;
        } else if (!(fname.match(letters))) {
            $("#fbk_fname").focus();
            $(".fbk_fname_error").text("Please enter valid Name.Numbers not allowed!");
            return false;
        } else {
            $(".fbk_fname_error").text('');
        }
        //mobile
        if (!filter.test(mobile)) {
            $('.fbk_mobileno_error').text('Please enter valid Number!');
            $('#fbk_mobileno').focus();
            return false;
        } else if (mobile.length > 10 || mobile.length < 10) {
            $(".fbk_mobileno_error").text('Please enter valid Number of 10 digit');
            $('#fbk_mobileno').focus();
            return false;
        } else {
            $('.fbk_mobileno_error').text('');
        }
        //email
        var atposition = email.indexOf("@");
        var dotposition = email.lastIndexOf(".");
        if (email == '') {
            $("#fbk_emailid").focus();
            $(".fbk_emailid_error").text("Please enter email Id!");
            return false;
        } else if (atposition < 1 || dotposition < atposition + 2 || dotposition + 2 >= email.length) {
            $("#fbk_emailid").focus();
            $(".fbk_emailid_error").text("Please enter valid email Id!");
            return false;
        } else {
            $(".fbk_emailid_error").text('');

        }
        // feedback topic
        if (fbk_topic == '') {
            $("#fbk_topic").focus();
            $(".fbk_topic_error").text("Please enter your topic!");
            return false;
        } else {
            $(".fbk_topic_error").text('');
        }
        //rating  
        if (rating == '') {
            $("#rating_star").focus();
            $(".rating_error").text("Please choose your rating!");
            return false;
        } else {
            $(".rating_error").text('');
        }
        //review
        if (message != '') {
            $(".text_error").text('');
        } else {
            $("#fbk_review").focus();
            $(".text_error").text("Please enter you review upto 150 chars!");
            return false;
        }


        $.ajax({
            url: "<?php echo site_url('home/submit_internal_feedback'); ?>",
            type: 'post',
            data: {fname: fname, lname: lname, country_code: country_code, mobile: mobile, email: email, fbk_topic: fbk_topic, message: message, rating: rating},
            success: function (response) {
                if (response.status == 1)
                {
                    $('#modal-feedback').modal('hide');
                    $('#feedback-OTP').modal('show');
                    $('#feed_student_id').val(response.id);
                    $('#feedbackTopic').val(response.feedbackTopic);
                    $('#ratingPoint').val(response.ratingPoint);
                    $('#feedbackReview').val(response.feedbackReview);

                } else if (response.status == 2)
                {
                    $('#sec1').addClass('hide');
                    $('#sec2').removeClass('hide');
                    $('#dis_success_err').removeClass('hide');
                    $('#dis_success_err_text').html(response.msg);

                } else {
                    $('#sec1').addClass('hide');
                    $('#sec2').removeClass('hide');
                    $('#dis_fail_err').removeClass('hide');
                    $('#dis_fail_err_text').html(response.msg);

                }
            },
            beforeSend: function () {

                $('#fbk_sub_review_btn').attr("disabled", true);


            },
        });

    }
    
    function Verify_fbk_opt() {
        var fbk_otp = $("#fbk_otp").val();
        var student_id = $("#feed_student_id").val();
        if (fbk_otp !== '') {
            $(".fbk_reg_otp_err").text('');
            $('#subsreg_opt_danger').addClass('hide');
        } else {
            $("#fbk_otp").focus();
            $('#otp_fbk_error_info').removeClass('hide');
            $('#opt_fbk_error_info_text').html("Please Enter OTP");
            return false;
        }
        $.ajax({
            url: "<?php echo site_url('Complaints/verify_student_otp'); ?>",
            type: 'post',
            data: {otp: fbk_otp, student_id: student_id},
            success: function (response) {
                if (response.status == 'true')
                {
                    $('#feedback-OTP').modal('hide');
                    $('#modal_feedback_success').modal('show');
                } else
                {
                    $('#fbk_otp').val('');
                    $('#otp_fbk_success_info').addClass('hide');
                    $('#otp_fbk_error_info').removeClass('hide');
                    $('#opt_fbk_error_info_text').html(response.msg);
                }
            }
        });
    }

    function Verify_fbk_opt___()
    {
        var reg_otp = $("#fbk_otp").val();
        var feed_student_id = $('#feed_student_id').val();
        var feedbackTopic = $('#feedbackTopic').val();
        var ratingPoint = $('#ratingPoint').val();
        var feedbackReview = $('#feedbackReview').val();
        if (reg_otp != '')
        {
            $(".fbk_reg_otp_err").text('');
            $('#subsreg_opt_danger').addClass('hide');
        } else {
            $("#fbk_otp").focus();
            $('#otp_fbk_error_info').removeClass('hide');
            $('#opt_fbk_error_info_text').html("Please Enter OTP");
            return false;
        }


        $.ajax({
            url: "<?php echo site_url('home/verify_internal_feedback'); ?>",
            type: 'post',
            data: {otp: reg_otp, feed_student_id: feed_student_id, feedbackTopic: feedbackTopic, ratingPoint: ratingPoint, feedbackReview: feedbackReview},
            success: function (response) {
                // alert(response)       
                //alert( JSON.stringify(response))
                // return false;
                if (response.status == 'true')
                {
                    $('#fbk_otp').val('');

                    $('#optmain_sec').addClass('hide');
                    $('#otp_fbk_error_info').addClass('hide');
                    $('#otp_fbk_success_info').removeClass('hide');
                    $('#opt_fbk_success_info_text').html(response.msg);
                } else
                {
                    $('#fbk_otp').val('');
                    $('#otp_fbk_success_info').addClass('hide');
                    $('#otp_fbk_error_info').removeClass('hide');
                    $('#opt_fbk_error_info_text').html(response.msg);

                }
            }

        });

    }
    
    $(document).ready(function() {
        var uri = "<?php echo site_url('Products/index'); ?>";
        globalAjaxCall(uri, 'get').done(function (response) {
            var rows = JSON.parse(response);
            var selectBox = '';
            if (rows.length) {
                $.each(rows, function (index, row) {
                    selectBox += '<option value="' + row['id'] + '" data-division="' + row['division_id'] + '">' + row['name'] + '</option>';
                });
            }
            $('.feedback_product_id#feed_product_id').html(selectBox);
            $('.feedback_product_id#feed_product_id').selectpicker('refresh');
        });
    });
    
    

    $(document).on('change', '.feedback_product_id#feed_product_id', function () {
        var division_id = $('.feedback_product_id#feed_product_id > option:selected').attr('data-division');
        var _id = $('.feedback_product_id#feed_product_id > option:selected').val();
        if (_id && division_id !== undefined) {
            $('#feed_division_id').val(division_id);
            var p2 = division_id === '<?php echo VISA_DIVISION_PKID; ?>' ? 50 : 48;
            $('#feed_purpose_level_two').val(p2);
            var uri = "<?php echo site_url('Products/feedback_subjects'); ?>/" + _id;
            globalAjaxCall(uri, 'get').done(function (response) {
                var rows = JSON.parse(response);
                var selectBox = '';
                if (rows.length) {
                    $.each(rows, function (index, row) {
                        selectBox += '<option value="' + row['id'] + '">' + row['topic'] + '</option>';
                    });
                }
                $('.feedback_subject_id#feed_feedback_subject').html(selectBox);
                $('.feedback_subject_id#feed_feedback_subject').selectpicker('refresh');
            });
        } else {
            $('#feed_division_id').val('');
            $('.feedback_subject_id#feed_feedback_subject').html('');
            $('.feedback_subject_id#feed_feedback_subject').selectpicker('refresh');
        }
    });
    
    $(document).on('click', '#btn-feedback', function () {
        if(validateWosaAdminForm('save_feedback_form')) {
            var form = document.getElementById('save_feedback_form');
            var formdata = new FormData(form);
                $.ajax({
                    url: "<?php echo site_url('home/submit_internal_feedback'); ?>",
                    type: 'post', 
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (response)
                    {
                        if (response.status == 'true')
                        {
                            if(response.data.is_otp_verified === '0') {
                                $('#modal-feedback').modal('hide');
                                $('#feedback-OTP').modal('show');
                            } else {
                                $('#modal-feedback').modal('hide');
                                $('#modal_feedback_success').modal('show');
                            }
                        } else
                        {
//                            $('.complaintBtnDiv_pro').hide();
//                            $('.msg_comp').html(response.msg);
//                            $('.otpform').hide();
                        }
                    }
                });
        }
    });
    
    $(document).on('keyup', '#feed_mobile', function () {
        var country_code = $('#feed_country_code').val();
        var mobile = $('#feed_mobile').val();
        if(country_code !== '' && mobile.length === 10){
            var uri = "<?php echo site_url('Products/get_student_id'); ?>";
            globalAjaxCall(uri, 'post', {country_code: country_code, mobile: mobile}).done(function (response) {
                var rows = JSON.parse(response);
                $('#feed_student_id').val(rows);
            });
        }
    });

getMobilePhoneLimit();
function getMobilePhoneLimit() {
    var country_code = $('#feed_country_code > option:selected').attr('data-iso');
    $.ajax({
        url: "<?php echo site_url('purpose/ajax_getPhoneLimit'); ?>",
        async: true,
        type: 'post',
        data: {country_code:country_code},
        dataType: 'json',
        success: function(data) {
            for (i = 0; i < data.length; i++) {
                if(data[i]['min_phoneNo_limit']>0) {
                    $("#feed_mobile").attr('minlength',  data[i]['min_phoneNo_limit']);
                } else {
                    $("#feed_mobile").attr('minlength',  10);
                }

                if(data[i]['phoneNo_limit']>0) {
                    $("#feed_mobile").attr('maxlength',  data[i]['phoneNo_limit']);
                } else {
                    $("#feed_mobile").attr('maxlength',  10);
                }
                $('#feed_mobile').val('');
            }
        }
    });
}

    $('#modal-feedback').on('show.bs.modal', function() {
        $('#save_feedback_form').trigger('reset');
        $('.feedback_subject_id#feed_feedback_subject').html('');
        $('.selectpicker').selectpicker('refresh');
    });
</script>