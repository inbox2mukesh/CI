<?php ob_start(); ?>
<script>
$(function() {
    $("body").delegate(".bookingMonth", "focusin", function(){
        $('#exam_booking_month').datepicker({
   			format: "MM, yyyy",
    		viewMode: "months",
    		minViewMode: "months",
			autoclose: true,
    	});
    });
});

$(document).ready(function() {

    $(".allow_numeric").on("input", function(evt) {
        var self = $(this);
        self.val(self.val().replace(/\D/g, ""));
        if ((evt.which < 48 || evt.which > 57)) {
            evt.preventDefault();
        }
    });

    $(".allow_alphabets").on("input", function(evt) {
        var self = $(this);
        self.val(self.val().replace(/[^a-zA-Z ]/, ""));
        if ((evt.which < 65 || evt.which > 90)) {
            evt.preventDefault();
        }
    });

    $(".allow_email").on("input", function(evt) {
        var self = $(this);
        self.val(self.val().replace(/[^a-zA-Z0-9@._-]/, ""));

    });

});

function checkfname() {
    var x = $('#camp_fname').val();
    var regex = /^[a-zA-Z]+$/;
    if (!x.match(regex)) {
        $("#camp_fname_error").text('Please enter alphabates only');
        $('#camp_fname').val('');
        $('#camp_fname').focus();
        return false;
    }
}

function checklname() {
    var x = $('#camp_lname').val();
    var regex = /^[a-zA-Z]+$/;
    if (!x.match(regex)) {
        $("#camp_lname_error").text('Please enter alphabates only');
        $('#camp_lname').val('');
        $('#camp_lname').focus();
        return false;
    }
}

$('#camp_fname').keyup(function() {

    var fname = $('#camp_fname').val();

    if (fname == "") {
        $("#camp_fname_error").text('Please enter First Name');
        $('#camp_fname').focus();
        return false;
    } else if (fname.length < 2) {
        $("#camp_fname").focus();
        $("#camp_fname_error").text('Please enter minimum 2 characters');
        return false;
    } else {
        $("#camp_fname_error").text('');
    }
});

$('#camp_lname').keyup(function() {

    var lname = $('#camp_lname').val();

    if (lname == "") {
        $("#camp_lname_error").text('Please enter Last Name');
        $('#camp_lname').focus();
        return false;
    } else if (lname.length < 2) {
        $("#camp_lname").focus();
        $("#camp_lname_error").text('Please enter minimum 2 characters');
        return false;
    } else {
        $("#camp_lname_error").text('');
    }
});



$('#camp_phone').keyup(function() {

    var phone = $('#camp_phone').val();
    var phone_lenght = 0;
	var max_length = $('#camp_phone').attr('maxlength');
	var min_length = $('#camp_phone').attr('minlength');
	
	phone_lenght = phone.length;

    $("#phone_digit").text('Entered Digits : ' + phone_lenght);

    if (phone_lenght > max_length || phone_lenght < min_length) {
        $("#camp_phone").focus();
        $("#camp_phone_error").text('Please enter valid Phone Number between '+min_length+' - '+max_length+' digits');
        return false;
    } else {
        $("#camp_phone_error").text('');
    }
});

$('#camp_email').keyup(function() {

    var email = $('#camp_email').val();

    if (echeck(email) == false) {
        $('#camp_email_error').html('Please enter valid email address');
        $("#camp_email").focus();
        return false;
    } else {
        $("#camp_email_error").html('');
    }
});

function echeck(str) {

    var at = "@"
    var dot = "."
    var lat = str.indexOf(at)
    var lstr = str.length
    var ldot = str.indexOf(dot)
    if (str.indexOf(at) == -1) {
        return false
    }

    if (str.indexOf(at) == -1 || str.indexOf(at) == 0 || str.indexOf(at) == lstr) {
        return false
    }

    if (str.indexOf(dot) == -1 || str.indexOf(dot) == 0 || str.indexOf(dot) == lstr) {
        return false
    }

    if (str.indexOf(at, (lat + 1)) != -1) {
        return false
    }

    if (str.substring(lat - 1, lat) == dot || str.substring(lat + 1, lat + 2) == dot) {
        return false
    }

    if (str.indexOf(dot, (lat + 2)) == -1) {
        return false
    }

    if (str.indexOf(" ") != -1) {
        return false
    }

    return true
}
</script>
<script>
/*------------------------- Start Purpose JS------------------------- */
<?php
	if ($getOnlineCoachingProgram) {
		echo "getOnlineCoachingProgram()";
	}
	if ($getOnlinePackage) {
		echo "getOnlinePackage()";
	}
	if ($getInhouseCoachingCourse) {
		echo "getInhouseCoachingCourse()";
	}
	if ($getInhouseCoachingProgram) {
		echo "getInhouseCoachingProgram()";
	}
	if ($getInhousePackage) {
		echo "getInhousePackage()";
	}
	if ($getPracticePackProgram) {
		echo "getPracticePackProgram()";
	}
	if ($getPracticePackPackage) {
		echo "getPracticePackPackage()";
	}
	if ($getProgram) {
		echo "getProgram()";
	}
	if ($getRealityTest) {
		echo "getRealityTest()";
	}
	
	if ($getCourseOrCountry) {
		echo "getCourseOrCountry()";
	}
	if ($getEventListByCourse) {
		echo "getEventListByCourse()";
	}
	if ($getEventListByCountry) {
		echo "getEventListByCountry()";
	}
	?>
	getPhoneLimit();
function getPhoneLimit()
{
	//var country_code = $('#camp_country_code').val();
	var country_code = $('#camp_country_code > option:selected').attr('data-iso');
    $.ajax({
			  url: "<?php echo site_url('purpose/ajax_getPhoneLimit'); ?>",
			  async: true,
			  type: 'post',
			  data: {country_code:country_code},
			  dataType: 'json',
			  success: function(data) {
				  html = '';
				  for (i = 0; i < data.length; i++) {
					  if(data[i]['min_phoneNo_limit']>0)
					  {
					  	$("#camp_phone").attr('minlength',  data[i]['min_phoneNo_limit']);
					  }
					  else
					  {
						  $("#camp_phone").attr('minlength',  10);
					  }
					  
					  if(data[i]['phoneNo_limit']>0)
					  {
					  	$("#camp_phone").attr('maxlength',  data[i]['phoneNo_limit']);
					  }
					  else
					  {
						  $("#camp_phone").attr('maxlength',  10);
					  }
					  $('#camp_phone').val('');
				  }
				}
		  });
}

function getPurposeLevel2() {
    var purpose_level_1 = $('#purpose_level_1').val();
    var is_primary = $('#purpose_level_1 option:selected').data('is-primary');
    var html = '';
    if (purpose_level_1 > 0) {
        $("#div_pur_lev_1").addClass("hide");
        $("#div_reality_test").addClass("hide");
        $("#div_event").addClass("hide");
        $("#div_exam_booking").addClass("hide");
        $("#div_visa_services").addClass("hide");
        $("#div_test_coaching").addClass("hide");
        $("#div_complaints").addClass("hide");
        $("#div_feedback").addClass("hide");
		
		$("#online_coaching_course,#online_coaching_program,#online_coaching_package").attr('required', false);
        $("#inhouse_coaching_branch,#inhouse_coaching_course,#inhouse_coaching_program,#inhouse_coaching_package").attr('required', false);
        $("#practice_pack_course,#practice_pack_program,#practice_pack_package").attr('required', false);
        $("#dep_visa_int_country").attr('required', false);
        $("#qualification,#study_visa_int_country").attr('required', false);
		$("#visitor_visa_int_country").attr('required',false);
		$("#work_experience,#work_visa_industry,#work_visa_int_country").attr('required', false);
		$("#event_type").attr('required', false);
		$("#event_course,#event_list").attr('required', false);
		$("#event_int_country,#event_list").attr('required', false);
		$("#exam_booking_course,#exam_booking_program,#exam_booking_city,#exam_booking_month,#exam_list").attr('required', false);
		$("#reality_test_course,#reality_test_program,#reality_test").attr('required', false);
		
        if (is_primary) {

            $('#purpose_level_2').attr('required', false);
        } else {
            $('#purpose_level_2').attr('required', true);

        }
        if (purpose_level_1 == 24) // 24 = Reality Test then Course and Program
        {
			<?php
			if($eventList->error_message->data->campaign->is_show_reality_test ==1) {
			?>
			$("#reality_test_course,#reality_test_program,#reality_test").attr('required', true);
			$("#div_rt").removeClass("hide"); 
			<?php
			}else { ?>
			$("#reality_test_course,#reality_test_program").attr('required', true);
			$("#div_rt").addClass("hide");
			<?php } ?>
			
            $("#div_reality_test").removeClass("hide");
            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getCourse'); ?>",
                async: true,
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html = '<option data-subtext="" value=""  selected="selected">Select Course</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['test_module_id'] + ' >' + data[i][
                            'test_module_name'
                        ] + '</option>';
                    }
                    html += '</select>';
                    $('#reality_test_course').html(html);
                    $('#reality_test_course').selectpicker('refresh');
                }
            });
        } else if (purpose_level_1 == 27) // 27 = Exam Booking then Course , Program , Exam City and Booking Month
        {
			$("#exam_booking_course,#exam_booking_program").attr('required', true);
            $("#div_exam_booking").removeClass("hide");
            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getCourse'); ?>",
                async: true,
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html = '<option data-subtext="" value=""  selected="selected">Select Course</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['test_module_id'] + ' >' + data[i][
                            'test_module_name'
                        ] + '</option>';
                    }
                    html += '</select>';
                    $('#exam_booking_course').html(html);
                    $('#exam_booking_course').selectpicker('refresh');
                }
            });
        } else {
            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getPurposeLevel_2'); ?>",
                async: true,
                type: 'post',
                data: {
                    purpose_level_1: purpose_level_1
                },
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html =
                        '<option data-subtext="" value=""  selected="selected" data-is-primary="">Select Purpose Level 2</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['id'] + ' data-is-primary=' + data[i][
                            'is_primary'
                        ] + '>' + data[i]['name'] + '</option>';
                    }
                    $("#div_pur_lev_1").removeClass("hide");
                    $("#div_reality_test").addClass("hide");
                    html += '</select>';
                    $('#purpose_level_2').html(html);
                    $('#purpose_level_2').selectpicker('refresh');
                }
            });

        }

    } else {
        html = '';
        html = '<option data-subtext="" value=""  selected="selected">Select Purpose Level 2</option>';
        $('#purpose_level_2').html(html);
        $('#purpose_level_2').selectpicker('refresh');
        $('#purpose_level_2').attr('required', false);
        $("#div_pur_lev_1").addClass("hide");
        $("#div_reality_test").addClass("hide");
        $("#div_event").addClass("hide");
        $("#div_exam_booking").addClass("hide");
        $("#div_visa_services").addClass("hide");
        $("#div_test_coaching").addClass("hide");
        $("#div_complaints").addClass("hide");
        $("#div_feedback").addClass("hide");
    }
}

function getPurposeLevel3() {
    var purpose_level_2 = $('#purpose_level_2').val();
    var is_primary = $('#purpose_level_2 option:selected').data('is-primary');
    var html = '';
    if (purpose_level_2 > 0) {
        $("#div_event").addClass("hide");
        $("#div_visa_services").addClass("hide");
        $("#div_test_coaching").addClass("hide");
        $("#div_complaints").addClass("hide");
        $("#div_feedback").addClass("hide");
        $("#div_general_assistance").addClass("hide");
        
        $("#online_coaching_course,#online_coaching_program,#online_coaching_package").attr('required', false);
        $("#inhouse_coaching_branch,#inhouse_coaching_course,#inhouse_coaching_program,#inhouse_coaching_package").attr('required', false);
        $("#practice_pack_course,#practice_pack_program,#practice_pack_package").attr('required', false);
        $("#dep_visa_int_country").attr('required', false);
        $("#study_visa_int_country").attr('required', false);
		$("#visitor_visa_int_country").attr('required',false);
		$("#work_visa_int_country").attr('required', false);
		$("#event_type").attr('required', false);
		$("#event_course,#event_list").attr('required', false);
		$("#event_int_country,#event_list").attr('required', false);
		
        if (purpose_level_2 == 2) //  Online Coaching
        {
			<?php
			if($eventList->error_message->data->campaign->is_show_package ==1) {
			?>
            $("#online_coaching_course,#online_coaching_program,#online_coaching_package").attr('required', true);
			$("#div_online_coaching_package").removeClass("hide");
			<?php
			}else{ ?>
			$("#online_coaching_course,#online_coaching_program").attr('required', true);
			$("#div_online_coaching_package").addClass("hide");
			<?php } ?>
			
            $("#div_test_coaching").removeClass("hide");
            $("#div_online_coaching_course").removeClass("hide");
            $("#div_online_coaching_program").removeClass("hide");
            

            $("#div_practice_pack_course").addClass("hide");
            $("#div_practice_pack_program").addClass("hide");
            $("#div_practice_pack_package").addClass("hide");

            $("#div_inhouse_coaching_branch").addClass("hide");
            $("#div_inhouse_coaching_course").addClass("hide");
            $("#div_inhouse_coaching_program").addClass("hide");
            $("#div_inhouse_coaching_package").addClass("hide");
            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getCourse'); ?>",
                async: true,
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html = '<option data-subtext="" value=""  selected="selected">Select Course</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['test_module_id'] + ' >' + data[i][
                            'test_module_name'
                        ] + '</option>';
                    }
                    html += '</select>';
                    $('#online_coaching_course').html(html);
                    $('#online_coaching_course').selectpicker('refresh');
                }
            });
        } else if (purpose_level_2 == 5) // Inhouse Coaching
        {
            
			<?php
			if($eventList->error_message->data->campaign->is_show_package ==1) {
			?>
            $("#inhouse_coaching_branch,#inhouse_coaching_course,#inhouse_coaching_program,#inhouse_coaching_package").attr('required', true);
			$("#div_inhouse_coaching_package").removeClass("hide");
			<?php
			}else{ ?>
			$("#inhouse_coaching_branch,#inhouse_coaching_course,#inhouse_coaching_program").attr('required', true);
			$("#div_inhouse_coaching_package").addClass("hide");
			<?php } ?>
			
            $("#div_test_coaching").removeClass("hide");
            $("#div_online_coaching_course").addClass("hide");
            $("#div_online_coaching_program").addClass("hide");
            $("#div_online_coaching_package").addClass("hide");

            $("#div_inhouse_coaching_branch").removeClass("hide");
            $("#div_inhouse_coaching_course").removeClass("hide");
            $("#div_inhouse_coaching_program").removeClass("hide");
            

            $("#div_practice_pack_course").addClass("hide");
            $("#div_practice_pack_program").addClass("hide");
            $("#div_practice_pack_package").addClass("hide");

            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getInhouseBranch'); ?>",
                async: true,
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html = '<option data-subtext="" value=""  selected="selected">Select Branch</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['center_id'] + ' >' + data[i]['center_name'] +
                            '</option>';
                    }
                    html += '</select>';
                    $("#inhouse_coaching_branch").attr('required', true);
                    $('#inhouse_coaching_branch').html(html);
                    $('#inhouse_coaching_branch').selectpicker('refresh');
                }
            });

            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getCourse'); ?>",
                async: true,
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html = '<option data-subtext="" value=""  selected="selected">Select Course</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['test_module_id'] + ' >' + data[i][
                            'test_module_name'
                        ] + '</option>';
                    }
                    html += '</select>';
                    $('#inhouse_coaching_course').html(html);
                    $('#inhouse_coaching_course').selectpicker('refresh');
                }
            });
        } else if (purpose_level_2 == 9) // Practice Packs
        {
            <?php
			if($eventList->error_message->data->campaign->is_show_package ==1) {
			?>
            $("#practice_pack_course,#practice_pack_program,#practice_pack_package").attr('required', true);
			$("#div_practice_pack_package").removeClass("hide");
			<?php
			}else{ ?>
			$("#practice_pack_course,#practice_pack_program").attr('required', true);
			$("#div_practice_pack_package").addClass("hide");
			<?php } ?>
			
            $("#div_test_coaching").removeClass("hide");
            $("#div_practice_pack_course").removeClass("hide");
            $("#div_practice_pack_program").removeClass("hide");
            
            $("#div_online_coaching_course").addClass("hide");
            $("#div_online_coaching_program").addClass("hide");
            $("#div_online_coaching_package").addClass("hide");

            $("#div_inhouse_coaching_branch").addClass("hide");
            $("#div_inhouse_coaching_course").addClass("hide");
            $("#div_inhouse_coaching_program").addClass("hide");
            $("#div_inhouse_coaching_package").addClass("hide");
            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getCourse'); ?>",
                async: true,
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html = '<option data-subtext="" value=""  selected="selected">Select Course</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['test_module_id'] + ' >' + data[i][
                            'test_module_name'
                        ] + '</option>';
                    }
                    html += '</select>';
                    $('#practice_pack_course').html(html);
                    $('#practice_pack_course').selectpicker('refresh');
                }
            });
        } else if (purpose_level_2 == 22) // Dependent Visa
        {
            $("#dep_visa_int_country").attr('required', true);

            $("#div_visa_services").removeClass("hide");
            $("#div_dep_visa_int_country").removeClass("hide");

            $("#div_study_visa_int_country").addClass("hide");
            $("#div_work_visa_int_country").addClass("hide");
            $("#div_visitor_visa_int_country").addClass("hide");

            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getIntCountry'); ?>",
                async: true,
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html =
                        '<option data-subtext="" value=""  selected="selected">Select Interested Country</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['country_id'] + ' >' + data[i]['name'] +
                            '</option>';
                    }
                    html += '</select>';
                    $("#dep_visa_int_country").attr('required', true);
                    $('#dep_visa_int_country').html(html);
                    $('#dep_visa_int_country').selectpicker('refresh');
                }
            });
        } else if (purpose_level_2 == 13) // Study Visa
        {
            $("#study_visa_int_country").attr('required', true);

            $("#div_visa_services").removeClass("hide");
            $("#div_study_visa_int_country").removeClass("hide");

            $("#div_work_visa_int_country").addClass("hide");
            $("#div_visitor_visa_int_country").addClass("hide");
            $("#div_dep_visa_int_country").addClass("hide");

            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getQualification'); ?>",
                async: true,
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html =
                        '<option data-subtext="" value=""  selected="selected">Select Current Qualification</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['id'] + ' >' + data[i]['qualification_name'] +
                            '</option>';
                    }
                    html += '</select>';
                    $('#qualification').html(html);
                    $('#qualification').selectpicker('refresh');
                }
            });

            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getIntCountry'); ?>",
                async: true,
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html =
                        '<option data-subtext="" value=""  selected="selected">Select Interested Country</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['country_id'] + ' >' + data[i]['name'] +
                            '</option>';
                    }
                    html += '</select>';
                    $("#study_visa_int_country").attr('required', true);
                    $('#study_visa_int_country').html(html);
                    $('#study_visa_int_country').selectpicker('refresh');
                }
            });
        } else if (purpose_level_2 == 16) // Visitor Visa
        {
            $("#visitor_visa_int_country").attr('required',true);

            $("#div_visa_services").removeClass("hide");
            $("#div_visitor_visa_int_country").removeClass("hide");

            $("#div_vs_qualification").addClass("hide");
            $("#div_study_visa_int_country").addClass("hide");
            $("#div_work_experience").addClass("hide");
            $("#div_work_visa_industry").addClass("hide");
            $("#div_work_visa_int_country").addClass("hide");
            $("#div_dep_visa_int_country").addClass("hide");

            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getIntCountry'); ?>",
                async: true,
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html =
                        '<option data-subtext="" value=""  selected="selected">Select Interested Country</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['country_id'] + ' >' + data[i]['name'] +
                            '</option>';
                    }
                    html += '</select>';
                    $("#visitor_visa_int_country").attr('required', true);
                    $('#visitor_visa_int_country').html(html);
                    $('#visitor_visa_int_country').selectpicker('refresh');
                }
            });
        } else if (purpose_level_2 == 18) // Work Visa
        {
			$("#work_visa_int_country").attr('required', true);
			$("#div_visa_services").removeClass("hide");
            $("#div_work_experience").removeClass("hide");
            $("#div_work_visa_industry").removeClass("hide");
            $("#div_work_visa_int_country").removeClass("hide");

            $("#div_visitor_visa_int_country").addClass("hide");
            $("#div_vs_qualification").addClass("hide");
            $("#div_study_visa_int_country").addClass("hide");
            $("#div_dep_visa_int_country").addClass("hide");

            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getWorkExperience'); ?>",
                async: true,
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html =
                        '<option data-subtext="" value=""  selected="selected">Select Work Experience</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['id'] + ' >' + data[i]['work_experience'] +
                            '</option>';
                    }
                    html += '</select>';
                    $('#work_experience').html(html);
                    $('#work_experience').selectpicker('refresh');
                }
            });

            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getIndustryType'); ?>",
                async: true,
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html = '<option data-subtext="" value=""  selected="selected">Select Industry</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['id'] + ' >' + data[i]['industry_type'] +
                            '</option>';
                    }
                    html += '</select>';
                    $('#work_visa_industry').html(html);
                    $('#work_visa_industry').selectpicker('refresh');
                }
            });

            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getIntCountry'); ?>",
                async: true,
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html =
                        '<option data-subtext="" value=""  selected="selected">Select Interested Country</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['country_id'] + ' >' + data[i]['name'] +
                            '</option>';
                    }
                    html += '</select>';
                    $("#work_visa_int_country").attr('required', true);
                    $('#work_visa_int_country').html(html);
                    $('#work_visa_int_country').selectpicker('refresh');
                }
            });
        } else if ((purpose_level_2 == 33) || (purpose_level_2 == 36)) // Event
        {
			$("#event_type").attr('required', true);
            $("#div_event").removeClass("hide");
            $("#div_event_course").addClass("hide");
            $("#div_event_int_country").addClass("hide");
            $("#div_event_list").addClass("hide");
            $("#div_visa_services").addClass("hide");
            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getEventType'); ?>",
                async: true,
                type: 'post',
                data: {purpose_level_2: purpose_level_2},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html =
                        '<option data-subtext="" value=""  selected="selected">Select Event Type</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['id'] + ' >' + data[i]['eventTypeTitle'] +
                            '</option>';
                    }
                    html += '</select>';
                    $('#event_type').html(html);
                    $('#event_type').selectpicker('refresh');
                }
            });
        } else if ((purpose_level_2 == 43) || (purpose_level_2 == 45)) // Complaints
        {
            $("#div_complaints").removeClass("hide");
            $("#div_complaint_product").removeClass("hide");
            $("#div_complaint_subject").removeClass("hide");
            $("#div_complaint_branch_dept").removeClass("hide");
            $('#complaint_product').attr('required', true);
            $('#complaint_product').html('<option value=""  selected="selected">Select Product</option>');
            $('#complaint_product').selectpicker('refresh');
            $('#complaint_subject').html('<option value=""  selected="selected">Select Complaint Subject</option>');
            $('#complaint_subject').selectpicker('refresh');
            $('#complaint_subject').attr('required', true);
            if (purpose_level_2 != '') {

                var division_id = '';
                if (purpose_level_2 == '43') {
                    division_id = '<?php echo ACADEMY_DIVISION_PKID ?>';
                } else if (purpose_level_2 == '45') {

                    division_id = '<?php echo VISA_DIVISION_PKID ?>';
                }
                var productHtml = '<option value=""  selected="selected">Select Product</option>';
                $.each(AllProductList[division_id], function(index, row) {

                    productHtml += '<option value="' + row['id'] + '">' + row['name'] + '</option>';
                });
                $('#complaint_product').html(productHtml);
                $('#complaint_product').selectpicker('refresh');
            }
        } else if ((purpose_level_2 == 48) || (purpose_level_2 == 50)) // Feedback
        {
            $("#div_feedback").removeClass("hide");
            $("#div_feedback_product").removeClass("hide");
            $("#div_feedback_subject").removeClass("hide");
            $("#div_feedback_branch_dept").removeClass("hide");
            $('#feedback_product').attr('required', true);
            $('#feedback_product').html('<option value=""  selected="selected">Select Product</option>');
            $('#feedback_product').selectpicker('refresh');
            $('#feedback_subject').html('<option value=""  selected="selected">Select Feedback Subject</option>');
            $('#feedback_subject').selectpicker('refresh');
            $('#feedback_subject').attr('required', true);
            if (purpose_level_2 != '') {

                var division_id = '';
                if (purpose_level_2 == '48') {
                    division_id = '<?php echo ACADEMY_DIVISION_PKID ?>';
                } else if (purpose_level_2 == '50') {

                    division_id = '<?php echo VISA_DIVISION_PKID ?>';
                }
                var productHtml = '<option value=""  selected="selected">Select Product</option>';
                $.each(AllProductList[division_id], function(index, row) {

                    productHtml += '<option value="' + row['id'] + '">' + row['name'] + '</option>';
                });
                $('#feedback_product').html(productHtml);
                $('#feedback_product').selectpicker('refresh');
            }
        } else if ((purpose_level_2 == 60) || (purpose_level_2 == 61)) //General Assistance
        {
            $("#div_general_assistance").removeClass("hide");
            $("#div_general_assistance_product").removeClass("hide");
            $("#div_general_assistance_subject").removeClass("hide");
            $('#general_assistance_product').attr('required', true);
            $('#general_assistance_product').html('<option value=""  selected="selected">Select Product</option>');
            $('#general_assistance_product').selectpicker('refresh');
            $('#ga_subject').html('<option value=""  selected="selected">Select Complaint Subject</option>');
            $('#ga_subject').selectpicker('refresh');
            $('#ga_subject').attr('required', true);
            if (purpose_level_2 != '') {

                var division_id = '';
                if (purpose_level_2 == '60') {

                    division_id = '<?php echo ACADEMY_DIVISION_PKID ?>';
                } else if (purpose_level_2 == '61') {

                    division_id = '<?php echo VISA_DIVISION_PKID ?>';
                }
                var productHtml = '<option value=""  selected="selected">Select Product</option>';
                $.each(AllProductList[division_id], function(index, row) {

                    productHtml += '<option value="' + row['id'] + '">' + row['name'] + '</option>';
                });
                $('#general_assistance_product').html(productHtml);
                $('#general_assistance_product').selectpicker('refresh');
            }
        }

    } else {
        $("#div_event").addClass("hide");
        $("#div_visa_services").addClass("hide");
        $("#div_test_coaching").addClass("hide");
        $("#div_complaints").addClass("hide");
        $("#div_feedback").addClass("hide");
        $("#div_general_assistance").addClass("hide");

    }
}

function getPracticePackProgram() {
    var practice_pack_course = $('#practice_pack_course').val();
    if (practice_pack_course > 0) {
        $("#div_practice_pack_program").removeClass("hide");
		<?php
		if($eventList->error_message->data->campaign->is_show_package ==1) {
		?>
        $("#div_practice_pack_package").removeClass("hide");
		<?php
		}else { ?>
		$("#div_practice_pack_package").addClass("hide");
		<?php } ?>
        $.ajax({
            url: "<?php echo site_url('purpose/ajax_getOnlineCoachingProgram'); ?>",
            async: true,
            type: 'post',
            data: {
                course: practice_pack_course
            },
            dataType: 'json',
            success: function(data) {
                html = '';
                html = '<option data-subtext="" value=""  selected="selected">Select Program</option>';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i]['programe_id'] + ' >' + data[i]['programe_name'] +
                        '</option>';
                }

                $('#practice_pack_program').html(html);
                $('#practice_pack_program').selectpicker('refresh');
            }
        });
    } else {
        $("#div_practice_pack_program").addClass("hide");
        $("#div_practice_pack_package").addClass("hide");
    }
}

function getPracticePackPackage() {
    var practice_pack_course = $('#practice_pack_course').val();
    var practice_pack_program = $('#practice_pack_program').val();
    if (practice_pack_program > 0) {
        <?php
		if($eventList->error_message->data->campaign->is_show_package ==1) {
		?>
        $("#div_practice_pack_package").removeClass("hide");
		<?php
		}else { ?>
		$("#div_practice_pack_package").addClass("hide");
		<?php } ?>
        $.ajax({
            url: "<?php echo site_url('purpose/ajax_getPracticePackPackage'); ?>",
            async: true,
            type: 'post',
            data: {
                course: practice_pack_course,
                program: practice_pack_program
            },
            dataType: 'json',
            success: function(data) {
                html = '';
                html = '<option data-subtext="" value=""  selected="selected">Select Packege</option>';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i]['package_id'] + ' >' + data[i]['package_name'] +
                        '</option>';
                }

                $('#practice_pack_package').html(html);
                $('#practice_pack_package').selectpicker('refresh');
            }
        });
    } else {
        $("#div_practice_pack_package").addClass("hide");
    }
}

function getInhouseCoachingCourse() {
    var inhouse_coaching_branch = $('#inhouse_coaching_branch').val();
    if (inhouse_coaching_branch > 0) {
        $("#div_inhouse_coaching_course").removeClass("hide");
        $("#div_inhouse_coaching_program").removeClass("hide");
        $("#div_inhouse_coaching_package").removeClass("hide");
		<?php
		if($eventList->error_message->data->campaign->is_show_package ==1) {
		?>
        $("#div_inhouse_coaching_package").removeClass("hide"); 
		<?php
		}else { ?>
		$("#div_inhouse_coaching_package").addClass("hide");
		<?php } ?>
    } else {
        $("#div_inhouse_coaching_course").addClass("hide");
        $("#div_inhouse_coaching_program").addClass("hide");
        $("#div_inhouse_coaching_package").addClass("hide");
	}
}

function getInhouseCoachingProgram() {
    var inhouse_coaching_course = $('#inhouse_coaching_course').val();
    if (inhouse_coaching_course > 0) {
        $("#div_inhouse_coaching_program").removeClass("hide");
		<?php
		if($eventList->error_message->data->campaign->is_show_package ==1) {
		?>
        $("#div_inhouse_coaching_package").removeClass("hide");
		<?php
		}else { ?>
		$("#div_inhouse_coaching_package").addClass("hide");
		<?php } ?>
        $.ajax({
            url: "<?php echo site_url('purpose/ajax_getOnlineCoachingProgram'); ?>",
            async: true,
            type: 'post',
            data: {
                course: inhouse_coaching_course
            },
            dataType: 'json',
            success: function(data) {
                html = '';
                html = '<option data-subtext="" value=""  selected="selected">Select Program</option>';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i]['programe_id'] + ' >' + data[i]['programe_name'] +
                        '</option>';
                }

                $('#inhouse_coaching_program').html(html);
                $('#inhouse_coaching_program').selectpicker('refresh');
            }
        });
    } else {
        $("#div_inhouse_coaching_program").addClass("hide");
        $("#div_inhouse_coaching_package").addClass("hide");
    }
}

function getInhousePackage() {
    var inhouse_coaching_branch = $('#inhouse_coaching_branch').val();
    var inhouse_coaching_course = $('#inhouse_coaching_course').val();
    var inhouse_coaching_program = $('#inhouse_coaching_program').val();
    if (inhouse_coaching_program > 0) {
         
		<?php
		if($eventList->error_message->data->campaign->is_show_package ==1) {
		?>
        $("#div_inhouse_coaching_package").removeClass("hide"); 
		<?php
		}else { ?>
		$("#div_inhouse_coaching_package").addClass("hide");
		<?php } ?>
        $.ajax({
            url: "<?php echo site_url('purpose/ajax_getInhousePackage'); ?>",
            async: true,
            type: 'post',
            data: {
                course: inhouse_coaching_course,
                program: inhouse_coaching_program,
                branch: inhouse_coaching_branch
            },
            dataType: 'json',
            success: function(data) {
                html = '';
                html = '<option data-subtext="" value=""  selected="selected">Select Packege</option>';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i]['package_id'] + ' >' + data[i]['package_name'] +
                        '</option>';
                }

                $('#inhouse_coaching_package').html(html);
                $('#inhouse_coaching_package').selectpicker('refresh');
            }
        });
    } else {
        $("#div_inhouse_coaching_package").addClass("hide");
    }
}

function getOnlinePackage() {
    var online_coaching_course = $('#online_coaching_course').val();
    var online_coaching_program = $('#online_coaching_program').val();
    if (online_coaching_program > 0) {
        <?php
		if($eventList->error_message->data->campaign->is_show_package ==1) {
		?>
        $("#div_online_coaching_package").removeClass("hide"); 
		<?php
		}else { ?>
		$("#div_online_coaching_package").addClass("hide");
		<?php } ?>
        $.ajax({
            url: "<?php echo site_url('purpose/ajax_getOnlinePackage'); ?>",
            async: true,
            type: 'post',
            data: {
                course: online_coaching_course,
                program: online_coaching_program
            },
            dataType: 'json',
            success: function(data) {
                html = '';
                html = '<option data-subtext="" value=""  selected="selected">Select Packege</option>';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i]['package_id'] + ' >' + data[i]['package_name'] +
                        '</option>';
                }

                $('#online_coaching_package').html(html);
                $('#online_coaching_package').selectpicker('refresh');
            }
        });
    } else {
        $("#div_online_coaching_package").addClass("hide");
    }
}

function getOnlineCoachingProgram() {
    var online_coaching_course = $('#online_coaching_course').val();
    if (online_coaching_course > 0) {
        $("#div_online_coaching_program").removeClass("hide");
		<?php
		if($eventList->error_message->data->campaign->is_show_package ==1) {
		?>
        $("#div_online_coaching_package").removeClass("hide");
		<?php
		}else { ?>
		$("#div_online_coaching_package").addClass("hide");
		<?php } ?>
         
        $.ajax({
            url: "<?php echo site_url('purpose/ajax_getOnlineCoachingProgram'); ?>",
            async: true,
            type: 'post',
            data: {
                course: online_coaching_course
            },
            dataType: 'json',
            success: function(data) {
                html = '';
                html = '<option data-subtext="" value=""  selected="selected">Select Program</option>';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i]['programe_id'] + ' >' + data[i]['programe_name'] +
                        '</option>';
                }

                $('#online_coaching_program').html(html);
                $('#online_coaching_program').selectpicker('refresh');
            }
        });
    } else {
        $("#div_online_coaching_program").addClass("hide");
        $("#div_online_coaching_package").addClass("hide");
    }
}

function getRealityTest() {
    var reality_test_course = $('#reality_test_course').val();
    var reality_test_program = $('#reality_test_program').val();
    if (reality_test_program > 0) {
        <?php
		if($eventList->error_message->data->campaign->is_show_reality_test ==1) {
		?>
		$("#div_rt").removeClass("hide"); 
		<?php
		}else { ?>
		$("#div_rt").addClass("hide");
		<?php } ?>
        $.ajax({
            url: "<?php echo site_url('purpose/ajax_getRealityTest'); ?>",
            async: true,
            type: 'post',
            data: {
                reality_test_course: reality_test_course,
                reality_test_program: reality_test_program
            },
            dataType: 'json',
            success: function(data) {
                html = '';
                html = '<option data-subtext="" value=""  selected="selected">Select Reality Test</option>';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i]['id'] + ' >' + data[i]['title'] + ' | ' + data[i][
                        'date'
                    ] + ' | ' + data[i]['amount'] + '</option>';
                }
                $('#reality_test').html(html);
                $('#reality_test').selectpicker('refresh');
            }
        });
    } else {
        $("#div_rt").addClass("hide");
    }
}


function getExamBookingProgram() {
    var exam_booking_course = $('#exam_booking_course').val();
    if (exam_booking_course > 0) {
        $("#div_eb_prog").removeClass("hide");
        $.ajax({
            url: "<?php echo site_url('purpose/ajax_getProgram'); ?>",
            async: true,
            type: 'post',
            data: {
                reality_test_course: exam_booking_course
            },
            dataType: 'json',
            success: function(data) {
                html = '';
                html = '<option data-subtext="" value=""  selected="selected">Select Program</option>';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i]['programe_id'] + ' >' + data[i]['programe_name'] +
                        '</option>';
                }

                $('#exam_booking_program').html(html);
                $('#exam_booking_program').selectpicker('refresh');
            }
        });
    } else {
        $("#div_eb_prog").addClass("hide");
    }
}

function getProgram() {
    var reality_test_course = $('#reality_test_course').val();
    if (reality_test_course > 0) {
        $("#div_rt_prog").removeClass("hide");
        <?php
		if($eventList->error_message->data->campaign->is_show_reality_test ==1) {
		?>
		$("#div_rt").removeClass("hide"); 
		<?php
		}else { ?>
		$("#div_rt").addClass("hide");
		<?php } ?>
        $.ajax({
            url: "<?php echo site_url('purpose/ajax_getProgram'); ?>",
            async: true,
            type: 'post',
            data: {
                reality_test_course: reality_test_course
            },
            dataType: 'json',
            success: function(data) {
                html = '';
                html = '<option data-subtext="" value=""  selected="selected">Select Program</option>';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i]['programe_id'] + ' >' + data[i]['programe_name'] +
                        '</option>';
                }

                $('#reality_test_program').html(html);
                $('#reality_test_program').selectpicker('refresh');
            }
        });
    } else {
        $("#div_rt_prog").addClass("hide");
        $("#div_rt").addClass("hide");
    }
}

function getCourseOrCountry() {
    var purpose_level_2 = $('#purpose_level_2').val();
    var event_type = $('#event_type').val();
	$("#event_course,#event_list").attr('required', false);
	$("#event_int_country,#event_list").attr('required', false);
	
    if (event_type > 0) {
        if (purpose_level_2 == 33) // Academy Event
        {
			$("#event_course,#event_list").attr('required', true);
            $("#div_event_course").removeClass("hide");
            $("#div_event_int_country").addClass("hide");

            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getCourse'); ?>",
                async: true,
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html = '<option data-subtext="" value=""  selected="selected">Select Course</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['test_module_id'] + ' >' + data[i][
                            'test_module_name'
                        ] + '</option>';
                    }
                    html += '</select>';
                    $('#event_course').html(html);
                    $('#event_course').selectpicker('refresh');
                }
            });
        } else if (purpose_level_2 == 36) // Visa Event 
        {
			$("#event_int_country,#event_list").attr('required', true);
            $("#div_event_course").addClass("hide");
            $("#div_event_int_country").removeClass("hide");

            $.ajax({
                url: "<?php echo site_url('purpose/ajax_getIntCountry'); ?>",
                async: true,
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(data) {
                    html = '';
                    html =
                        '<option data-subtext="" value=""  selected="selected">Select Interested Country</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i]['country_id'] + ' >' + data[i]['name'] +
                            '</option>';
                    }
                    html += '</select>';
                    $('#event_int_country').html(html);
                    $('#event_int_country').selectpicker('refresh');
                }
            });
        }
    } else {
        $("#div_event_course").addClass("hide");
        $("#div_event_int_country").addClass("hide");
        $("#div_event_list").addClass("hide");
    }
}

function getEventListByCourse() {
    var purpose_level_2 = $('#purpose_level_2').val();
    var event_type = $('#event_type').val();
    var event_course = $('#event_course').val();

    if (event_course > 0) {
        
        $("#div_event_int_country").addClass("hide");
		<?php
		if($eventList->error_message->data->campaign->is_show_event ==1) {
		?>
		$("#div_event_list").removeClass("hide");
		<?php
		}else { ?>
		$("#div_event_list").addClass("hide");
		<?php } ?>

        $.ajax({
            url: "<?php echo site_url('purpose/ajax_getAcademyEvent'); ?>",
            async: true,
            type: 'post',
            data: {
                purpose_level_2: purpose_level_2,
                event_type: event_type,
                event_course: event_course
            },
            dataType: 'json',
            success: function(data) {
                html = '';
                html = '<option data-subtext="" value=""  selected="selected">Select Event</option>';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i]['id'] + ' >' + data[i]['eventTitle'] + '</option>';
                }

                $('#event_list').html(html);
                $('#event_list').selectpicker('refresh');
            }
        });
    } else {
        $("#div_event_int_country").addClass("hide");
        $("#div_event_list").addClass("hide");
    }
}

function getEventListByCountry() {
    var purpose_level_2 = $('#purpose_level_2').val();
    var event_type = $('#event_type').val();
    var event_int_country = $('#event_int_country').val();

    if (event_int_country > 0) {
         
        $("#div_event_course").addClass("hide");
		<?php
		if($eventList->error_message->data->campaign->is_show_event ==1) {
		?>
		$("#div_event_list").removeClass("hide");
		<?php
		}else { ?>
		$("#div_event_list").addClass("hide");
		<?php } ?>

        $.ajax({
            url: "<?php echo site_url('purpose/ajax_getVisaEvent'); ?>",
            async: true,
            type: 'post',
            data: {
                purpose_level_2: purpose_level_2,
                event_type: event_type,
                event_int_country: event_int_country
            },
            dataType: 'json',
            success: function(data) {
                html = '';
                html = '<option data-subtext="" value=""  selected="selected">Select Event</option>';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i]['id'] + ' >' + data[i]['eventTitle'] + '</option>';
                }

                $('#event_list').html(html);
                $('#event_list').selectpicker('refresh');
            }
        });
    } else {
        $("#div_event_course").addClass("hide");
        $("#div_event_list").addClass("hide");
    }
}

function validateFormElements(element_array) {
    var checks = [];
    $.each(element_array, function(key, value) {
        var is_element_input = $('#' + value).is("select");
        if (is_element_input === false) {
            var element_value = $('#' + value).val();
        } else {
            var element_value = $('#' + value + ' > option:selected').val();
        }
        var title = $('#' + value).attr('title');
        var message = (title !== undefined) ? title : 'This field ';
        if (element_value === '' && element_value !== undefined) {
            $('#' + value + '_error').html(message + ' is mandatory');
            checks.push(false);
        } else {
            $('#' + value + '_error').html('');
        }
    });
    return checks.includes(false) ? false : true;
}

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
        //alert(key+is_required);
        var message = (title !== undefined) ? title : 'This field ';
        var input_length = value.length;
        if (value === '' && is_required !== undefined) {
            $('#' + key + '_error').html(message + ' is mandatory');
            checks.push(false);
        } else if (input_type == 'email' && !value.match(validRegexEmail) && value != '') {

            $('#' + key + '_error').html('Invalid email address!');
            checks.push(false);
        } else {
            $('#' + key + '_error').html('');
        }
        if (min_length !== undefined && input_length < min_length) {
            $('#' + key + '_error').html(message + '  must be minimun ' + min_length + ' characters');
            checks.push(false);
        }
        if (max_length !== undefined && input_length > max_length) {

            $('#' + key + '_error').html(message + '  can not be more than ' + max_length + ' characters');
            checks.push(false);
        }
    }
    return checks.includes(false) ? false : true;
}

function globalAjaxCall(uri, req_type = 'post', params = '') {
    return $.ajax({
        url: uri,
        type: req_type,
        data: params
    });
}
$(document).on('click', '#btn_submit', function(e) {
	
    //$('#campaign_form').submit();
	var form_id = 'campaign_form';
    if (validateWosaAdminForm(form_id)) {
        var uri = '<?php echo site_url('book_campaign/ajax_store_lead') ?>';
        var params = $('#' +form_id).serialize() + '&country_code=' + encodeURIComponent($(
            '#camp_country_code').val()) + '&mobile=' + $('#camp_phone').val();
        globalAjaxCall(uri, 'post', params).done(function(res) { 
		   	var response = JSON.parse(res);
			if (response.status == 'success') {
                if (response.is_otp_verified === '0') {
                    $('#student_id').val(response.id);
                    sendOtp(form_id);
                } else {
                    //window.location.reload();
                }
            } else {
                alert(response.msg, 'error');
            }
        });
    } else {
        alert('Not validated', 'error');
    }
});

document.addEventListener('invalid', (function() {
    return function(e) {
        e.preventDefault();
        //document.getElementById("name").focus();
    };
})(), true);

function sendOtp(form_id, resend = false) {
   $('#otp_success_message').html('');
    var student_id = $('#student_id').val();
    var uri = '<?php echo site_url('book_campaign/ajax_send_otp_lead') ?>/' + student_id;
    //alert(student_id);
    if (student_id && validateWosaAdminForm(form_id)) {
        globalAjaxCall(uri).done(function(response) {
            $('#otp_success_message').html('Otp sent to registered mobile number.');
            if (resend === false) {
                $('#otpModal').modal('show');
            }
        });
    }
}

function verifyOtp() {
    $('#otp_success_message, .otp_err').html('');
    var student_id = $('#student_id').val();
    var otp = $('#otp').val();
    if (student_id && otp) {
        var uri = '<?php echo site_url('book_campaign/ajax_verify_otp_lead') ?>/' + student_id + '/' +
            otp;
        globalAjaxCall(uri).done(function(response) {
            if (response === 'true') {
                $('#otpModal').modal('hide');
                setTimeout(function() {
                    $('.submit_form_button').click();
                    $('#ajax_res').html(
                        '<div class="alert alert-success alert-dismissible" role="alert"><strong>Record added successfully.</strong></div>'
                    );
                }, 1000);
            } else {
                $('.otp_err').html('Invalid OTP');
            }
        });
    } else {
        $('.otp_err').html('Please enter OTP to proceed');
    }
}
</script>
<?php
global $customJs;
$customJs = ob_get_clean();
?>