$(document).ready(function(){
	setInterval(function(){
	    refresh_access();
	},
	10000);

    function refresh_access(){
	    $.ajax({
	        url: WOSA_ADMIN_URL + 'cron_tab/cronJob_is_correct_logged_in',
	        type: 'post',
	        success: function(response){
	            if(response==1){
	            }else{
	            	alertMsg(response,'error');
	            	setTimeout(function(){
        				refresh_finally(response);
   					},2000);//delay is in milliseconds

	            }
	        },
	        beforeSend: function(){
	        }
	    });
    }

    function refresh_finally(response){
    	sessionStorage.clear();
    	window.location.href = WOSA_ADMIN_URL + 'login/logout/' + response;
    }
});
$(document).ready(function(){
	setInterval(function(){
	    refresh_live_time();
	},
	60000);
    function refresh_live_time(){
	    $.ajax({
	        url: WOSA_ADMIN_URL + 'user/ajax_refresh_live_time',
	        type: 'post',
	        success: function(response){
	            $('#LiveTime').html(response)
	        },
	        beforeSend: function(){
	        }
	    });
    }
});
//for replace all textarea to ckeditor
// CKEDITOR.replaceAll( 'myckeditor', {
// 	removeButtons: 'Source',
//     // The rest of options...
// } );
//CKEDITOR.replaceAll('myckeditor');
$(".textarea").wysihtml5();
//config.allowedContent = true;
function check_timeslot_duplicacy(type) {
	var time_slot_id = $('#time_slot_id_hidden').val();
	var time_slot = $('#time_slot').val();
	if (time_slot == '') {
		$('.time_slot_err').text('Please type time slot');
		$('#time_slot').focus();
		$('.sbm').prop('disabled', true);
		return false;
	} else {
		$('.time_slot_err').text('');
		$('.sbm').prop('disabled', false);
	}
	if (type == '') {
		$('.type_err').text('Please select type');
		$('#type').focus();
		$('.sbm').prop('disabled', true);
		return false;
	} else {
		$('.type_err').text('');
		$('.sbm').prop('disabled', false);
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'time_slot_master/ajax_check_timeslot_duplicacy',
		async: false,
		type: 'post',
		data: { time_slot: time_slot, time_slot_id: time_slot_id, type: type },
		dataType: 'json',
		success: function (response) {
			if (response > 0) {
				$('.time_slot_err').text('Please type unique name.' + time_slot + ' already exist');
				$('#time_slot').val('');
				$('#time_slot').focus();
				$('.sbm').prop('disabled', true);
				return false;
			} else {
				$('.time_slot_err').text('');
				$('.sbm').prop('disabled', false);
			}
		}
	});
}
function check_document_type_duplicacy(document_type_name) {
	var document_type_id = $('#document_type_id_hidden').val();
	if (document_type_name == '') {
		$('.document_type_name_err').text('Please type type');
		$('#document_type_name').focus();
		$('.sbm').prop('disabled', true);
		return false;
	} else {
		$('.document_type_name_err').text('');
		$('.sbm').prop('disabled', false);
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'document_type/ajax_check_doc_type_duplicacy',
		async: false,
		type: 'post',
		data: { document_type_name: document_type_name, document_type_id: document_type_id },
		dataType: 'json',
		success: function (response) {
			if (response > 0) {
				$('.document_type_name_err').text('Please type unique name.' + document_type_name + ' already exist');
				$('#document_type_name').val('');
				$('#document_type_name').focus();
				$('.sbm').prop('disabled', true);
				return false;
			} else {
				$('.document_type_name_err').text('');
				$('.sbm').prop('disabled', false);
			}
		}
	});
}
function check_source_duplicacy(source_name) {
	var source_id = $('#source_id_hidden').val();
	if (source_name == '') {
		$('.source_name_err').text('Please type source');
		$('#source_name').focus();
		$('.sbm').prop('disabled', true);
		return false;
	} else {
		$('.source_name_err').text('');
		$('.sbm').prop('disabled', false);
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'source_master/ajax_check_source_duplicacy',
		async: false,
		type: 'post',
		data: { source_name: source_name, source_id: source_id },
		dataType: 'json',
		success: function (response) {
			if (response > 0) {
				$('.source_name_err').text('Please type unique name.' + source_name + ' already exist');
				$('#source_name').val('');
				$('#source_name').focus();
				$('.sbm').prop('disabled', true);
				return false;
			} else {
				$('.source_name_err').text('');
				$('.sbm').prop('disabled', false);
			}
		}
	});
}
function check_designation_duplicacy(designation_name) {
	var designation_id = $('#designation_id_hidden').val();
	if (designation_name == '') {
		$('.designation_name_err').text('Please type designation');
		$('#designation_name').focus();
		$('.sbm').prop('disabled', true);
		return false;
	} else {
		$('.designation_name_err').text('');
		$('.sbm').prop('disabled', false);
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'designation_master/ajax_check_check_designation_duplicacy',
		async: false,
		type: 'post',
		data: { designation_name: designation_name, designation_id: designation_id },
		dataType: 'json',
		success: function (response) {
			if (response > 0) {
				$('.designation_name_err').text('Please type unique name.' + designation_name + ' already exist');
				$('#designation_name').val('');
				$('#designation_name').focus();
				$('.sbm').prop('disabled', true);
				return false;
			} else {
				$('.designation_name_err').text('');
				$('.sbm').prop('disabled', false);
			}
		}
	});
}
function check_qualification_duplicacy(qualification_name) {
	var qualification_id = $('#qualification_id_hidden').val();
	if (qualification_name == '') {
		$('.qualification_name_err').text('Please type qualification');
		$('#qualification_name').focus();
		$('.sbm').prop('disabled', true);
		return false;
	} else {
		$('.qualification_name_err').text('');
		$('.sbm').prop('disabled', false);
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'qualification_master/ajax_check_qualification_name_duplicacy',
		async: false,
		type: 'post',
		data: { qualification_name: qualification_name, qualification_id: qualification_id },
		dataType: 'json',
		success: function (response) {
			if (response > 0) {
				$('.qualification_name_err').text('Please type unique name.' + qualification_name + ' already exist');
				$('#qualification_name').val('');
				$('#qualification_name').focus();
				$('.sbm').prop('disabled', true);
				return false;
			} else {
				$('.qualification_name_err').text('');
				$('.sbm').prop('disabled', false);
			}
		}
	});
}
function check_batch_duplicacy(batch_name) {
	var batch_id = $('#batch_id_hidden').val();
	if (batch_name == '') {
		$('.batch_name_err').text('Please type batch name');
		$('#batch_name').focus();
		$('.sbm').prop('disabled', true);
		return false;
	} else {
		$('.batch_name_err').text('');
		$('.sbm').prop('disabled', false);
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'batch_master/ajax_check_batch_duplicacy',
		async: false,
		type: 'post',
		data: { batch_name: batch_name, batch_id: batch_id },
		dataType: 'json',
		success: function (response) {
			if (response > 0) {
				$('.batch_name_err').text('Please type unique name.' + batch_name + ' already exist');
				$('#batch_name').val('');
				$('#batch_name').focus();
				$('.sbm').prop('disabled', true);
				return false;
			} else {
				$('.batch_name_err').text('');
				$('.sbm').prop('disabled', false);
			}
		}
	});
}
function check_programe_duplicacy(programe_name) {
	var programe_id = $('#programe_id_hidden').val();
	if (programe_name == '') {
		$('.programe_name_err').text('Please type programe name');
		$('#programe_name').focus();
		$('.sbm').prop('disabled', true);
		return false;
	} else {
		$('.programe_name_err').text('');
		$('.sbm').prop('disabled', false);
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'programe_master/ajax_check_programe_duplicacy',
		async: false,
		type: 'post',
		data: { programe_name: programe_name, programe_id: programe_id },
		dataType: 'json',
		success: function (response) {
			if (response > 0) {
				$('.programe_name_err').text('Please type unique name.' + programe_name + ' already exist');
				$('#programe_name').val('');
				$('#programe_name').focus();
				$('.sbm').prop('disabled', true);
				return false;
			} else {
				$('.programe_name_err').text('');
				$('.sbm').prop('disabled', false);
			}
		}
	});
}
function check_freeresourcetopic_duplicacy(topic) {
	var topic_id = $('#topic_id_hidden').val();
	if (topic == '') {
		$('.topic_err').text('Please type topic');
		$('#topic').focus();
		$('.sbm').prop('disabled', true);
		return false;
	} else {
		$('.topic_err').text('');
		$('.sbm').prop('disabled', false);
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'free_resources_topic/ajax_check_freeresourcetopic_duplicacy',
		async: false,
		type: 'post',
		data: { topic: topic, topic_id: topic_id },
		dataType: 'json',
		success: function (response) {
			if (response > 0) {
				$('.topic_err').text('Please type unique name.' + topic + ' already exist');
				$('#topic_name').val('');
				$('#topic_name').focus();
				$('.sbm').prop('disabled', true);
				return false;
			} else {
				$('.topic_err').text('');
				$('.sbm').prop('disabled', false);
			}
		}
	});
}
function check_course_name_duplicacy(test_module_name) {
	var test_module_id = $('#test_module_id_hidden').val();
	if (test_module_name == '') {
		$('.test_module_name_err').text('Please type course name');
		$('#test_module_name').focus();
		$('.sbm').prop('disabled', true);
		return false;
	} else {
		$('.test_module_name_err').text('');
		$('.sbm').prop('disabled', false);
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'test_module/ajax_check_course_name_duplicacy',
		async: false,
		type: 'post',
		data: { test_module_name: test_module_name, test_module_id: test_module_id },
		dataType: 'json',
		success: function (response) {
			if (response > 0) {
				$('.test_module_name_err').text('Please type unique course name.' + test_module_name + ' already exist');
				$('#test_module_name').val('');
				$('#test_module_name').focus();
				$('.sbm').prop('disabled', true);
				return false;
			} else {
				$('.test_module_name_err').text('');
				$('.uspp').prop('disabled', false);
			}
		}
	});
}
function validate_classroom_name(classroom_name) {
	var classroom_id = $('#classroom_id_hidden').val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'classroom/ajax_validate_classroom_name',
		async: false,
		type: 'post',
		data: { classroom_name: classroom_name, classroom_id: classroom_id },
		dataType: 'json',
		success: function (response) {
			if (response > 0) {
				$('.classroom_name_err').text('Please type unique name.' + classroom_name + ' already exist');
				$('#classroom_name').val('');
				$('#classroom_name').focus();
				$('.sbm').prop('disabled', true);
				return false;
			} else {
				$('.classroom_name_err').text('');
				$('.sbm').prop('disabled', false);
			}
		}
	});
}
function enableBtn_packPayment() {
	var add_payment = $("#add_payment_pe").val();
	var expired_on = $("#expired_on").val();
	if ($("#use_wallet_pe").prop('checked') == true) {
		useWallet = 1;
	} else {
		useWallet = 0;
	}
	if (useWallet == 0) {
		if (add_payment > 0) {
			$('.uspp').prop('disabled', false);
			$('.add_payment_pe_err').text('');
		} else {
			$('.uspp').prop('disabled', true);
			$('.add_payment_pe_err').text('Please enter valid amount');
			document.getElementById('add_payment_pe').focus();
		}
		if (expired_on == '') {
			$('.uspp').prop('disabled', true);
			$('.expired_on_err').text('Please enter extended expiry date');
		} else {
			$('.uspp').prop('disabled', false);
			$('.expired_on_err').text('');
		}
	} else if (useWallet == 1) {
		if (add_payment == '') {
			$('.uspp').prop('disabled', true);
			$('.add_payment_pe_err').text('Please enter valid amount');
			document.getElementById('add_payment_pe').focus();
		} else {
			$('.uspp').prop('disabled', false);
			$('.add_payment_pe_err').text('');
		}
		if (expired_on == '') {
			$('.uspp').prop('disabled', true);
			$('.expired_on_err').text('Please enter extended expiry date');
		} else {
			$('.uspp').prop('disabled', false);
			$('.expired_on_err').text('');
		}
	} else {
		$('.uspp').prop('disabled', false);
	}
}
function enableBtn_packPayment_due_commitment(data){
	var add_payment=$('#add_payment').val();
	//alert(add_payment)
	if(add_payment == "")
	{
		$('.uspp').prop('disabled', true);	
	}
	else if( data =="")
	{
		$('.uspp').prop('disabled', true);
	}
	else {
		$('.uspp').prop('disabled', false);
		$('.dcdn').text('');
	}
	// if(add_payment=="" && data !="")
	// {
	// 	$('.uspp').prop('disabled', true);		
	// 	$('.dcdn').text('');		
	// }
	// else if(add_payment=="" && data !="")
	// {
	// 	$('.uspp').prop('disabled', true);		
	// 	$('.dcdn').text('');		
	// }
	// else {
	// 	//$('.uspp').prop('disabled', true);
	// 	$('.dcdn').text('');
	// }
}
function enableBtn_packPayment2() {
	$('.uspp').prop('disabled', false);
}
function diableBtn_packPayment() {
	$('.uspp').prop('disabled', true);
}
function enableBtn_packPayment3() {
	$('.uspp').prop('disabled', false);
}
function diableBtn_packPayment3() {
	$('.uspp').prop('disabled', true);
}
function enableBtn_packPayment4() {
	$('.uspp').prop('disabled', false);
}
function diableBtn_packPayment4() {
	$('.uspp').prop('disabled', true);
}

function displayRelevantFields(payment_mode) {
	var exam_booking_price = $('#exam_booking_price').val();
	if (payment_mode == 'cash') {
		$('.cash').show();
		$('.online').hide();
		$('.waiverField').hide();
		$('.discountField').hide();
		$('.walletDiv').show();
	} else if (payment_mode == 'Online') {
		$('#use_wallet_pbf').prop('checked', false);
		$('#use_wallet_pbf').prop('disabled', true);
		$('#discount_type_pbf').prop('selectedIndex', '');
		$('#discount_type_pbf').selectpicker('refresh');
		$('.walletDiv').hide();
		$('#balanceLeft').text(exam_booking_price);
		exam_booking_price = exam_booking_price.replace(/\,/g, '');
		exam_booking_price = parseInt(exam_booking_price);
		$('#amount_paid_pbf').val(exam_booking_price);
		$('.cash').hide();
		$('.online').show();
		$('.waiverField').hide();
		$('.discountField').hide();
	} else {
		$('.cash').hide();
		$('.online').hide();
		$('.waiverField').hide();
		$('.discountField').hide();
		$('.walletDiv').show();
	}
}
function showDiscountTypeFields(discount_type) {
	var exam_booking_price = $("#exam_booking_price").val();
	exam_booking_price = exam_booking_price.replace(/\,/g, '');
	exam_booking_price = parseInt(exam_booking_price);
	var method = $("#method_pbf").val();
	if (discount_type == 'Waiver') {
		$('.waiverField').show();
		$('.discountField').hide();
		var waiver = $("#waiver_pbf").val();
		var balanceLeft = exam_booking_price - waiver;
		if (waiver >= exam_booking_price) {
			$('#walletDiv').hide();
		} else {
			$('#walletDiv').show();
		}
		if (method == 'cash' && waiver < exam_booking_price) {
			$('#use_wallet_pbf').prop('disabled', false);
			$('#use_wallet_pbf').prop('checked', false);
		} else {
			$('#use_wallet_pbf').prop('checked', false);
			$('#use_wallet_pbf').prop('disabled', true);
		}
	} else if (discount_type == 'Discount') {
		$('.waiverField').hide();
		$('.discountField').show();
		var other_discount = $("#other_discount_pbf").val();
		var balanceLeft = exam_booking_price - other_discount;
		if (other_discount >= exam_booking_price) {
			$('#walletDiv').hide();
		} else {
			$('#walletDiv').show();
		}
		if (method == 'cash' && other_discount < exam_booking_price) {
			$('#use_wallet_pbf').prop('disabled', false);
			$('#use_wallet_pbf').prop('checked', false);
		} else {
			$('#use_wallet_pbf').prop('checked', false);
			$('#use_wallet_pbf').prop('disabled', true);
		}
	} else if (discount_type == 'None') {
		$('.waiverField').hide();
		$('.discountField').hide();
		var waiver = 0;
		var other_discount = 0;
		var balanceLeft = exam_booking_price;
		if (method == 'cash') {
			$('#use_wallet_pbf').prop('disabled', false);
			$('#use_wallet_pbf').prop('checked', false);
		} else {
			$('#use_wallet_pbf').prop('checked', false);
			$('#use_wallet_pbf').prop('disabled', true);
		}
	} else {
		$('.waiverField').hide();
		$('.discountField').hide();
		var waiver = 0;
		var other_discount = 0;
		var balanceLeft = exam_booking_price;
		$('#use_wallet_pbf').prop('checked', false);
		$('#use_wallet_pbf').prop('disabled', true);
	}
	$('#balanceLeft').text(balanceLeft);
	$('#amount_paid_pbf').val(balanceLeft);
}
function showDiscountTypeFields_offline(discount_type) {
	calculatedDiscount = 0;
	$('#other_discount_off').val(calculatedDiscount);
	if (discount_type == 'Waiver') {
		$('.waiverField_off').show();
		$('.discountField_off').hide();
	} else if (discount_type == 'Discount') {
		$('.waiverField_off').hide();
		$('.discountField_off').show();
	} else if (discount_type == 'None') {
		$('.waiverField_off').hide();
		$('.discountField_off').hide();
	} else {
		$('.waiverField_off').hide();
		$('.discountField_off').hide();
	}
	$("#amount_paid_off").val('');
}
function showDiscountTypeFields_online(discount_type) {
	calculatedDiscount = 0;
	$('#other_discount').val(calculatedDiscount);
	if (discount_type == 'Waiver') {
		$('.waiverField_online').show();
		$('.discountField_online').hide();
	} else if (discount_type == 'Discount') {
		$('.waiverField_online').hide();
		$('.discountField_online').show();
	} else if (discount_type == 'None') {
		$('.waiverField_online').hide();
		$('.discountField_online').hide();
	} else {
		$('.waiverField_online').hide();
		$('.discountField_online').hide();
	}
		// if(discount_type == 'Waiver') {
		// 	let waiveramt = parseFloat($('#waiver').val());
		// 	if(waiveramt > 0 && waiveramt != '')
		// 	{
		// 		let payableamt = parseFloat($('#amount_payable').val());
		// 		//let waiveredpayablemat = payableamt - waiveramt;
		// 		//$('#amount_payable').val(waiveredpayablemat);
		// 		//$('#waiver_amt').val(waiveramt);
		// 		let waiveredpackprice = parseFloat($('#packPrice').val()) -waiveramt;
		// 		$('#packPrice').val(waiveredpackprice);
		// 		//$('#myTable #tbpackprice').html(waiveredpackprice);
		// 	}
		// }
	$("#amount_paid").val('');
}
function showDiscountTypeFields_pp(discount_type) {
	calculatedDiscount = 0;
	$('#other_discount_pp').val(calculatedDiscount);
	if (discount_type == 'Waiver') {
		$('.waiverField_pp').show();
		$('.discountField_pp').hide();
	} else if (discount_type == 'Discount') {
		$('.waiverField_pp').hide();
		$('.discountField_pp').show();
	} else if (discount_type == 'None') {
		$('.waiverField_pp').hide();
		$('.discountField_pp').hide();
	} else {
		$('.waiverField_pp').hide();
		$('.discountField_pp').hide();
	}
	// if(discount_type == 'Waiver') {
	// 	let waiveramt = parseFloat($('#waiver').val()).toFixed(2);
	// 	if(waiveramt > 0 && waiveramt != '')
	// 	{
	// 		let payableamt = parseFloat($('#amount_payable_pp').val());
	// 		let waiveredpayablemat = payableamt - waiveramt;
	// 		$('#amount_payable_pp').val(waiveredpayablemat);
	// 		$('#waiver_amt').val(waiveramt);
	// 		let waiveredpackprice = parseFloat($('#packPrice').val()) -waiveramt;
	// 		$('#packPrice').val(waiveredpackprice);
	// 		$('#myTable #tbpackprice').html(waiveredpackprice);
	// 	}
	// }
	$("#amount_paid_pp").val('');
}
function doBlankVenue() {
	$('#venue_name_eb').val('');
	$('#venue_address_eb').val('')
}
function doBlankVenue_peb() {
	$('#venue_name_peb').val('');
	$('#venue_address_peb').val('')
}
function doBlankVenue_rs() {
	$('#rsVenueName').val('');
	$('#rsVenueAddress').val('')
}
function loadClassroom() {
	var html = '';
	var test_module_id = $("#test_module_id").val();
	var programe_id = $("#programe_id").val();
	//var category_id     = $("#category_id").val();
	var category_id = [];
	var batch_id = $("#batch_id").val();
	var center_id = $("#center_id").val();
	$('#category_id :selected').each(function (i, selected) {
		category_id[i] = $(selected).val();
	});
	$.ajax({
		url: WOSA_ADMIN_URL + 'classroom/ajax_loadClassroom',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id, category_id: category_id, batch_id: batch_id, center_id: center_id },
		dataType: 'json',
		success: function (data) {
			html = '';
			html = '<option data-subtext="" value="">Select classroom</option>';
			for (i = 0; i < data.length; i++) {
				var groupName = data[i]['classroom_name'] + ' / ' + data[i]['test_module_name'] + '-' + data[i]['programe_name'] + '-' + data[i]['Category']['category_name'] + '-' + data[i]['batch_name'] + '-' + data[i]['center_name'];
				html += '<option value=' + data[i]['id'] + ' >' + groupName + '</option>';
			}
			html += '</select>';
			$('#classroom_id').html(html);
			$('#classroom_id').selectpicker('refresh');
		}
	});
}
function loadClassroom2() {
	var html = '';
	var test_module_id = $("#test_module_id").val();
	var programe_id = $("#programe_id").val();
	var category_id = [];
	var batch_id = $("#batch_id").val();
	var center_id = $("#center_id").val();
	$('#category_id :selected').each(function (i, selected) {
		category_id[i] = $(selected).val();
	});
	//alert(category_id)
	$.ajax({
		url: WOSA_ADMIN_URL + 'classroom/ajax_loadClassroom2',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id, category_id: category_id, batch_id: batch_id, center_id: center_id },
		dataType: 'json',
		success: function (data) {
			html = '';
			zero = 0; one = 1; table = 'classroom'; pk = 'id';
			sr = 0;
			for (i = 0; i < data.length; i++) {
				sr++;
				idd = data[i]['id'];
				baseUrl = WOSA_ADMIN_URL + '';
				online_class_schedule_Url = baseUrl + 'online_class_schedule/index/' + idd;
				classroom_students_Url = baseUrl + 'classroom/classroom_students_/' + idd;
				classroom_docs_Url = baseUrl + 'classroom/classroom_docs_/' + idd;
				classroom_lecture_Url = baseUrl + 'classroom/classroom_lecture_/' + idd;
				classroom_announcements_Url = baseUrl + 'classroom/classroom_announcements_/' + idd;
				classroom_post_Url = baseUrl + 'classroom/classroom_post_/' + idd;
				add_online_class_schedule_Url = baseUrl + 'online_class_schedule/add/' + idd;
				add_shared_doc_Url = baseUrl + 'shared_doc/add/' + idd;
				add_live_lecture_Url = baseUrl + 'live_lecture/add/' + idd;
				add_announcements_Url = baseUrl + 'classroom_announcement/add/' + idd;
				classroom_edit_Url = baseUrl + 'classroom/edit/' + idd;
				classroom_remove_Url = baseUrl + 'classroom/remove/' + idd;
				if (data[i]['active'] == 1) {
					rowColor = '#B4F8AE';
				} else {
					rowColor = '#F8BBAE';
				}
				/*if(data[i]['category_name']){
					category_name = data[i]['category_name'];
				}else{
					category_name = 'ALL';
				}*/
				if (data[i]['active'] == 1) {
					active = '<span class="text-success"><a href="javascript:void(0);" id=' + data[i]['id'] + ' data-toggle="tooltip" title="Click to De-activate" onclick=activate_deactivete(' + data[i]['id'] + ',' + zero + ',' + table + ',' + pk + ') ><span class="text-success"><i class="fa fa-check"></i></span></a></span>';
				} else {
					active = '<span class="text-success"><a href="javascript:void(0);" id=' + data[i]['id'] + ' data-toggle="tooltip" title="Click to De-activate" onclick=activate_deactivete(' + data[i]['id'] + ',' + one + ',' + table + ',' + pk + ') ><span class="text-danger"><i class="fa fa-close"></i></span></a></span>';
				}
				html += '<tr style="background-color: ' + rowColor + ' ">';
				html += '<td>' + sr + '</td>';
				html += '<td>' + data[i]['classroom_name'] + '</td>';
				html += '<td>' + data[i]['test_module_name'] + '</td>';
				html += '<td>' + data[i]['programe_name'] + '</td>';
				html += '<td>' + data[i]['Category']['category_name'] + '</td>';
				html += '<td>' + data[i]['batch_name'] + '</td>';
				html += '<td>' + data[i]['center_name'] + '</td>';
				html += '<td>' + active + '</td>';
				html += '<td><a href=" ' + online_class_schedule_Url + ' " class="btn btn-info btn-xs" data-toggle="tooltip" title="View class schedule"><span class="fa fa-calendar"></span> </a> <a href=" ' + classroom_students_Url + ' " class="btn btn-success btn-xs" data-toggle="tooltip" title="View classroom students"><span class="fa fa-users"></span> </a> <a href=" ' + classroom_docs_Url + ' " class="btn btn-danger btn-xs" data-toggle="tooltip" title="View Classroom Shared Docs"><span class="fa fa-file"></span> </a> <a href=" ' + classroom_lecture_Url + ' " class="btn btn-warning btn-xs" data-toggle="tooltip" title="View Classroom Recorded lectures"><span class="fa fa-video-camera"></span> </a> <a href=" ' + classroom_announcements_Url + ' " class="btn btn-danger btn-xs" data-toggle="tooltip" title="View Classroom Announcement"><span class="fa fa-bullhorn"></span> </a> <a href=" ' + classroom_post_Url + ' " class="btn btn-success btn-xs" data-toggle="tooltip" title="View Classroom Posts"><span class="fa fa-comments"></span> </a></td>';
				if (data[i]['active'] == 1) {
				html += '<td><a href=" ' + add_online_class_schedule_Url + ' " class="btn btn-info btn-xs" data-toggle="tooltip" title="Add New Schedule"><span class="fa fa-plus"></span> <span class="fa fa-calendar"></span> </a> <a href=" ' + add_shared_doc_Url + ' " class="btn btn-danger btn-xs" data-toggle="tooltip" title="Add New Docs"><span class="fa fa-plus"></span> <span class="fa fa-file"></span> </a> <a href=" ' + add_live_lecture_Url + ' " class="btn btn-warning btn-xs" data-toggle="tooltip" title="Add New Lectures"><span class="fa fa-plus"> <span class="fa fa-video-camera"></span> </a> <a href=" ' + add_announcements_Url + ' " class="btn btn-danger btn-xs" data-toggle="tooltip" title="Add New Announcement"><span class="fa fa-plus"></span> <span class="fa fa-bullhorn"></span> </a></td>';
				}
				else {
					html += '<td></td>';
				}
				html += '<td><a href=" ' + classroom_edit_Url + ' " class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> </td>';
			}
			html += '</tr>';
			$('.resp').html(html);
			$('.pagination').hide();
		}
	});
}
function loadStudents(classroom_id) {
	var html = '';
	$.ajax({
		url: WOSA_ADMIN_URL + 'student_attendance/ajax_loadStudents',
		async: true,
		type: 'post',
		data: { classroom_id: classroom_id },
		dataType: 'json',
		success: function (data) {
			html = '';
			var allStudent = [];
			zero = 0; one = 1; table = 'students'; pk = 'id';
			sr = 0;
			for (i = 0; i < data.length; i++) {
				sr++;
				allStudent.push(data[i]['id']);
				var date = '';
				id = 'ID' + data[i]['id'];
				if (data[i]['morning'] == 1) {
					morning = 'p';
				} else if (data[i]['morning'] == 0) {
					morning = 'ab';
				} else {
					morning = 'NA';
				}
				if (data[i]['evening'] == 1) {
					evening = 'p';
				} else if (data[i]['evening'] == 0) {
					evening = 'ab';
				} else {
					evening = 'NA';
				}
				html += '<tr>';
				html += '<td>' + sr + '</td>';
				html += '<td>' + data[i]['attendance_id'] + '</td>';
				html += '<td>' + data[i]['UID'] + '</td>';
				html += '<td>' + data[i]['fname'] + ' ' + data[i]['lname'] + '</td>';
				html += '<td>' + data[i]['center_name'] + '</td>';
				html += '<td>' + data[i]['classroom_name'] + '</td>';
				html += '<td>' + morning + '</td>';
				html += '<td>' + evening + '</td>';
				html += '<td>' + data[i]['date'] + '</td>';
				html += '<td>' + data[i]['time'] + '</td>';
				html += '<td><input type="checkbox" class="attCb checkbox-btn-ui" name="attendance_cb[]" id="' + id + '" value="' + data[i]['id'] + '"></td>';
				html += '<td><input type="hidden" name="attendance_id[]" id="' + data[i]['attendance_id'] + '" value="' + data[i]['attendance_id'] + '"></td>';
				html += '<td><input type="hidden" name="allStudent" id="allStudent" value="' + allStudent + '"></td>';
			}
			html += '</tr>';
			$('.resp').html(html);
		}
	});
}
function get_state_list(country_id) {
	if ($("#is_overseas").length > 0) {
		if (country_id == INDIA_ID) {
			$("#is_overseas").val(0);
			if($('.isOverseasHidden').length > 0) {
				$('.isOverseasHidden').val(0);
			}
		}
		else {
			$("#is_overseas").val(1);
			if($('.isOverseasHidden').length > 0) {
				$('.isOverseasHidden').val(1);
			}
		}
	}
	var html = '';
	$.ajax({
		url: WOSA_ADMIN_URL + 'city/ajax_get_state_list',
		async: true,
		type: 'post',
		data: { country_id: country_id },
		dataType: 'json',
		success: function (data) {
			html = '';
			html = '<option data-subtext="" value="">Select state</option>';
			for (i = 0; i < data.length; i++) {
				html += '<option data-subtext=' + data[i]['state_name'] + ' value=' + data[i]['state_id'] + ' >' + data[i]['state_name'] + '</option>';
			}
			html += '</select>';
			$('#state_id').html(html);
			$('#state_id').selectpicker('refresh');
		}
	});
}
function get_city_list(state_id) {
	var html = '';
	$.ajax({
		url: WOSA_ADMIN_URL + 'city/ajax_get_city_list',
		async: true,
		type: 'post',
		data: { state_id: state_id },
		dataType: 'json',
		success: function (data) {
			html = '';
			html = '<option data-subtext="" value="">Select city</option>';
			for (i = 0; i < data.length; i++) {
				html += '<option data-subtext=' + data[i]['city_name'] + ' value=' + data[i]['city_id'] + ' >' + data[i]['city_name'] + '</option>';
			}
			html += '</select>';
			$('#city_id').html(html);
			$('#city_id').selectpicker('refresh');
		}
	});
}
function get_category_list(test_seriese_id) {
	var html = '';
	$.ajax({
		url: WOSA_ADMIN_URL + 'category_master/get_category_list',
		async: true,
		type: 'post',
		data: { test_seriese_id: test_seriese_id },
		dataType: 'json',
		success: function (data) {
			html = '';
			html = '<option data-subtext="" value="">Select category</option>';
			for (i = 0; i < data.length; i++) {
				html += '<option data-subtext=' + data[i]['category_id'] + ' value=' + data[i]['category_id'] + ' >' + data[i]['programe_name'] + ' | ' + data[i]['category_name'] + '</option>';
			}
			html += '</select>';
			$('#category_id').html(html);
			$('#category_id').selectpicker('refresh');
		}
	});
}
//activate/deactivate for all
function activate_deactivete(id, active, table, pk) {
	//alert('mmmm')
	var idd = '#' + id;
	$.ajax({
		url: WOSA_ADMIN_URL + 'gallery/activate_deactivete_',
		async: true,
		type: 'post',
		data: { id: id, active: active, table: table, pk: pk },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				window.location.href = window.location.href
			} else {
				$(idd).html('');
			}
		}
	});
}
//activate/deactivate all
function activate_deactivete_enq(id, active, table, pk) {
	var idd = '#' + id;
	$.ajax({
		url: WOSA_ADMIN_URL + 'gallery/activate_deactivete_enq_',
		async: true,
		type: 'post',
		data: { id: id, active: active, table: table, pk: pk },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				//alert(response)
				window.location.href = window.location.href
			} else {
				$(idd).html('');
			}
		}
	});
}
function activate_deactivete_hasVISA(id, active, table, pk) {
	var idd = '#' + id;
	$.ajax({
		url: WOSA_ADMIN_URL + 'gallery/activate_deactivete_hasVISA_',
		async: true,
		type: 'post',
		data: { id: id, active: active, table: table, pk: pk },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				//alert(response)
				window.location.href = window.location.href
			} else {
				$(idd).html('');
			}
		}
	});
}
function activate_deactivete_hasAcademy(id, active, table, pk) {
	var idd = '#' + id;
	$.ajax({
		url: WOSA_ADMIN_URL + 'gallery/activate_deactivete_hasAcademy_',
		async: true,
		type: 'post',
		data: { id: id, active: active, table: table, pk: pk },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				//alert(response)
				window.location.href = window.location.href
			} else {
				$(idd).html('');
			}
		}
	});
}
function activate_deactivete_is_team(id, active, table, pk) {
	var idd = '#' + id;
	$.ajax({
		url: WOSA_ADMIN_URL + 'gallery/activate_deactivete_is_team_',
		async: true,
		type: 'post',
		data: { id: id, active: active, table: table, pk: pk },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				//alert(response)
				window.location.href = window.location.href
			} else {
				$(idd).html('');
			}
		}
	});
}
function check_employeeCode_availibility(employeeCode) {
	if (employeeCode != '') {
		if (employeeCode.length > 6 || employeeCode.length < 6) {
			$(".employeeCode_err").text('Please enter 6 digit code only');
			$("#employeeCode").focus();
			return false;
		} else {
			$(".employeeCode_err").text('');
		}
		$.ajax({
			url: WOSA_ADMIN_URL + 'user/ajax_check_employeeCode_availibility',
			type: 'post',
			data: { employeeCode: employeeCode },
			success: function (response) {
				if (response.status == 'true') {
					$('.employeeCode_err').html(response.msg)
				} else {
					$('.employeeCode_err').html(response.msg)
					$('#employeeCode').val('')
				}
			}
		});
	} else {
		$(".employeeCode_err").text("Please enter employee code!");
		return false;
	}
}
function check_employeeCode_availibility_edit(employeeCode) {
	var user_id = $('#userId_hidden').val()
	if (employeeCode != '') {
		if (employeeCode.length > 6 || employeeCode.length < 6) {
			$(".employeeCode_err").text('Please enter 6 digit code only');
			$("#employeeCode").focus();
			return false;
		} else {
			$(".employeeCode_err").text('');
		}
		$.ajax({
			url: WOSA_ADMIN_URL + 'user/ajax_check_employeeCode_availibility_edit',
			type: 'post',
			data: { employeeCode: employeeCode, user_id: user_id },
			success: function (response) {
				if (response.status == 'true') {
					$('.employeeCode_err').html(response.msg)
				} else {
					$('.employeeCode_err').html(response.msg)
					$('#employeeCode').val('')
				}
			}
		});
	} else {
		$(".employeeCode_err").text("Please enter employee code!");
		return false;
	}
}
function check_personal_email_availibility(email, page) {
	var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
	if (email.match(mailformat)) {
		$(".email_err_p").text('');
		$(':input[type="submit"]').prop('disabled', false);
		$.ajax({
			url: WOSA_ADMIN_URL + 'user/ajax_check_personal_email_availibility',
			type: 'post',
			data: { email: email, page: page },
			success: function (response) {
				if (response.status == 'true') {
					$('.email_err_p').html(response.msg)
				} else {
					$('.email_err_p').html(response.msg)
					$('#personal_email').val('')
				}
			}
		});
	} else {
		$(".email_err_p").text("Please enter valid Email Id!");
		$(':input[type="submit"]').prop('disabled', true);
		return false;
	}
}
function check_official_email_availibility(email) {
	var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
	var user_id = $('#userId_hidden').val();
	if (email.match(mailformat)) {
		$(".email_err_o").text('');
		//$(':input[type="submit"]').prop('disabled', false);
		$.ajax({
			url: WOSA_ADMIN_URL + 'user/ajax_check_official_email_availibility',
			type: 'post',
			data: { email: email, user_id: user_id },
			success: function (response) {
				if (response.status == 'true') {
					$('.email_err_o').html(response.msg)
				} else {
					$('.email_err_o').html(response.msg)
					$('#email').val('')
				}
			}
		});
	} else {
		$(".email_err_o").text("Please enter valid Email Id!");
		//$(':input[type="submit"]').prop('disabled', true);
		return false;
	}
}
function check_personal_mobile_availibility(personal_contact) {
	if (personal_contact != '') {
		$(".personal_contact_err").text('');
		$.ajax({
			url: WOSA_ADMIN_URL + 'user/ajax_check_personal_mobile_availibility',
			type: 'post',
			data: { personal_contact: personal_contact },
			success: function (response) {
				if (response.status == 'true') {
					$('.personal_contact_err').html(response.msg)
				} else {
					$('.personal_contact_err').html(response.msg)
					$('#personal_contact').val('')
				}
			}
		});
	} else {
		$(".personal_contact_err").text("Please enter personal contact no!");
		return false;
	}
}
function check_personal_mobile_availibility_edit(personal_contact) {
	var user_id = $('#userId_hidden').val()
	if (personal_contact != '') {
		$(".personal_contact_err").text('');
		$.ajax({
			url: WOSA_ADMIN_URL + 'user/ajax_check_personal_mobile_availibility_edit',
			type: 'post',
			data: { personal_contact: personal_contact, user_id: user_id },
			success: function (response) {
				if (response.status == 'true') {
					$('.personal_contact_err').html(response.msg)
				} else {
					$('.personal_contact_err').html(response.msg)
					$('#personal_contact').val('')
				}
			}
		});
	} else {
		$(".personal_contact_err").text("Please enter personal contact no!");
		return false;
	}
}
//student
function check_std_email_availibility(email) {
	var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	if (email.match(mailformat)) {
		$(".val_err").text('');
		$.ajax({
			url: WOSA_ADMIN_URL + 'student/check_std_email_availibility',
			type: 'post',
			data: { email: email },
			success: function (response) {
				if (response.status == 'true') {
					$('.val_err').html(response.msg)
				} else {
					$('.val_err').html(response.msg)
					$('#email').val('')
				}
				$('.add_std_pack').prop('disabled', false);
			}
		});
		//return true;
	}
	else {
		$(".val_err").text("Please enter valid email Id!");
		return false;
	}
}
//student
function check_std_mobile_availibility(mobile) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'student/check_std_mobile_availibility',
		type: 'post',
		data: { mobile: mobile },
		success: function (response) {
			if (response.status == 'true') {
				$('.mobile_err').html(response.msg)
			} else {
				$('.mobile_err').html(response.msg)
				$('#mobile').val('')
			}
		}
	});
}
function validate_email(email) {
	//var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
	if (email.match(mailformat)) {
		$(".email_err").text('');
		$(':input[type="submit"]').prop('disabled', false);
		$('.enqBtnv').prop('disabled', false);
		$('.send_email_otp').prop('disabled', false);
		return true;
	} else {
		$(".email_err").text("Please enter valid email Id!");
		$('#email').focus();
		$(':input[type="submit"]').prop('disabled', true);
		$('.enqBtnv').prop('disabled', true);
		$('.send_email_otp').prop('disabled', true);
		return false;
	}
}
function validate_phone(myval) {
	var filter = /^[0-9-+]+$/;
	/*if (!filter.test(myval)) {
		$('.mobile_err').text('Please enter valid Number!');
		$('#mobile').focus();
		$('.send_mobile_otp').prop('disabled', true);
		return false;
	} else {
		$('.mobile_err').text('');
		$('.send_mobile_otp').prop('disabled', false);
	}*/
	if (myval.length > 10 || myval.length < 10) {
		$(".mobile_err").text('Please enter valid Number of 10 digit');
		$('.send_mobile_otp').prop('disabled', true);
		return false;
	} else {
		$(".mobile_err").text('');
		$('.send_mobile_otp').prop('disabled', false);
		return true;
	}
}
$("#mail_sent").change(function () {
	var val = $("#mail_sent:checked").val();
	if (val == 1) {
		var email = $("#email").val();
		if (email == '') {
			$('.val_err').text('Please enter valid Email!');
			$('#email').focus();
			$('.add_std_pack').prop('disabled', true);
		} else {
			$('.val_err').text('');
			$('.add_std_pack').prop('disabled', false);
		}
	} else {
		$('.val_err').text('');
		$('.add_std_pack').prop('disabled', false);
	}
});
$(".rsTypeClass").change(function () {
	var html = '';
	var val = $(".rsTypeClass:checked").val();
	if (val == 'Existing') {
		$('.existingClass').show();
		$('.commonRsField').show();
		$('.newClass').hide();
	} else if (val == 'New') {
		$('.existingClass').hide();
		$('.newClass').show();
		$('.commonRsField').show();
	} else {
		$('.existingClass').hide();
		$('.newClass').hide();
		$('.commonRsField').hide();
	}
});
//radio button ppp change
$(".ppp").change(function () {
	var html = '';
	$("#packPrice").val('');
	var val = $(".ppp:checked").val();
	if (val == 'offline') {
		$('#packbox_offline').show(); $('#packbox_online').hide(); $('#packbox_pp').hide();
		$('#packbox_ws').hide(); $('#packbox_eb').hide(); $('#packbox_rt').hide();
		//selected service
		var sel = document.getElementById('service_id');
		var sv = sel.options[sel.selectedIndex].value;
		//auto select service
		if (sv == WAIVED_OFF_SERVICE_ID) { /* ..do nothing ..*/ } else {
			$("#service_id option[value='"+ENROLL_SERVICE_ID+"']").attr("selected", "selected");
			$('#service_id').selectpicker('refresh');
		}
		//branch forced strat
		$('#center_id').prop('disabled', false); $('#center_id').selectpicker('refresh');
		//branch forced end
		var test_module_id = $("#test_module_id").val();
		var programe_id = $("#programe_id").val();
		var center_id = $("#center_id").val();
		$.ajax({
			url: WOSA_ADMIN_URL + 'package_master/ajax_get_offline_package_list',
			async: true,
			type: 'post',
			data: { test_module_id: test_module_id, programe_id: programe_id, center_id: center_id },
			dataType: 'json',
			success: function (data) {
				html = '<option data-subtext="" value="">Select package</option>';
				for (i = 0; i < data.length; i++) {
					if (data[i]['discounted_amount'] === data[i]['amount'] || data[i]['discounted_amount'] == null) {
						html += '<option value=' + data[i]['package_id'] + ' >' + data[i]['package_name'] + ' | ' + data[i]['discounted_amount'] + ' | ' + data[i]['duration'] + ' ' + data[i]['duration_type'] + '</option>';
					} else {
						html += '<option value=' + data[i]['package_id'] + ' >' + data[i]['package_name'] + ' | ' + data[i]['discounted_amount'] + '/' + data[i]['amount'] + ' | ' + data[i]['duration'] + ' ' + data[i]['duration_type'] + '</option>';
					}
				}
				html += '</select>';
				$('#package_id_off').html(html);
				$('#package_id_off').selectpicker('refresh');
			}
		});
		$('#service_id').selectpicker('refresh');
	} else if (val == 'online') {
		$('#packbox_online').show(); $('#packbox_offline').hide(); $('#packbox_pp').hide();
		$('#packbox_ws').hide(); $('#packbox_eb').hide(); $('#packbox_rt').hide();
		//selected service
		var sel = document.getElementById('service_id');
		var sv = sel.options[sel.selectedIndex].value;
		//auto select service
		if (sv == WAIVED_OFF_SERVICE_ID) { /* ..do nothing ..*/ } else {
			$("#service_id option[value='" + ENROLL_SERVICE_ID + "']").attr("selected", "selected");
			$('#service_id').selectpicker('refresh');
		}
		//branch forced strat
		$("#center_id option[value='" + ONLINE_BRANCH_ID + "']").attr("selected", "selected");
		$('#center_id').prop('disabled', true); $('#center_id').selectpicker('refresh');
		//branch forced end
		var test_module_id = $("#test_module_id").val();
		var programe_id = $("#programe_id").val();
		$.ajax({
			url: WOSA_ADMIN_URL + 'package_master/ajax_get_online_package_list',
			async: true,
			type: 'post',
			data: { test_module_id: test_module_id, programe_id: programe_id },
			dataType: 'json',
			success: function (data) {
				html = '<option data-subtext="" value="">Select package</option>';
				for (i = 0; i < data.length; i++) {
					if (data[i]['discounted_amount'] === data[i]['amount'] || data[i]['discounted_amount'] == null) {
						html += '<option value=' + data[i]['package_id'] + ' data-dur='+data[i]['duration']+' '+data[i]['duration_type']+'   >' + data[i]['package_name'] + ' | ' + data[i]['discounted_amount'] + ' | ' + data[i]['duration'] + ' ' + data[i]['duration_type'] + '</option>';
					} else {
						html += '<option value=' + data[i]['package_id'] + ' data-dur='+data[i]['duration']+' '+data[i]['duration_type']+'   >' + data[i]['package_name'] + ' | ' + data[i]['discounted_amount'] + '/' + data[i]['amount'] + ' | ' + data[i]['duration'] + ' ' + data[i]['duration_type'] + '</option>';
					}
				}
				html += '</select>';
				$('#package_id').html(html);
				$('#package_id').selectpicker('refresh');
			}
		});
		$('#service_id').selectpicker('refresh');
	} else if (val == 'pp') {
		$('#packbox_pp').show(); $('#packbox_online').hide(); $('#packbox_offline').hide();
		$('#packbox_ws').hide(); $('#packbox_eb').hide(); $('#packbox_rt').hide();
		//refresh service
		$("#service_id option[value='" + ACADEMY_SERVICE_REGISTRATION_ID + "']").attr("selected", "selected");
		$('#service_id').selectpicker('refresh');
		//branch forced strat
		$("#center_id option[value='" + ONLINE_BRANCH_ID + "']").attr("selected", "selected");
		$('#center_id').prop('disabled', true); $('#center_id').selectpicker('refresh');
		//branch forced end
		var test_module_id = $("#test_module_id").val();
		var programe_id = $("#programe_id").val();
		$.ajax({
			url: WOSA_ADMIN_URL + 'practice_packages/ajax_get_package_list',
			async: true,
			type: 'post',
			data: { test_module_id: test_module_id, programe_id: programe_id },
			dataType: 'json',
			success: function (data) {
				html = '';
				html = '<option data-subtext="" value="">Select package</option>';
				for (i = 0; i < data.length; i++) {
					if (data[i]['discounted_amount'] === data[i]['amount'] || data[i]['discounted_amount'] == null) {
						html += '<option value=' + data[i]['package_id'] + ' >' + data[i]['package_name'] + ' | ' + data[i]['discounted_amount'] + ' | ' + data[i]['duration'] +' '+ data[i]['duration_type'] + '</option>';
					} else {
						html += '<option value=' + data[i]['package_id'] + ' >' + data[i]['package_name'] + ' | ' + data[i]['discounted_amount'] + '/' + data[i]['amount'] + ' | ' + data[i]['duration'] +' '+ data[i]['duration_type'] + '</option>';
					}
				}
				html += '</select>';
				$('#package_id_pp').html(html);
				$('#package_id_pp').selectpicker('refresh');
			}
		});
		$('#service_id').selectpicker('refresh');
	} else if (val == 'ws') {
		//Code Add By Neelu
		$('#packbox_offline').hide(); $('#packbox_online').hide(); $('#packbox_pp').hide();
		$('#packbox_rt').hide(); $('#packbox_eb').hide(); $('#packbox_ws').show();
		//refresh service
		$("#service_id option[value='" + ACADEMY_SERVICE_REGISTRATION_ID + "']").attr("selected", "selected");
		$('#service_id').selectpicker('refresh');
		//branch forced strat
		$('#center_id').prop('disabled', false); $('#center_id').selectpicker('refresh');
		//branch forced end
		$.ajax({
			url: WOSA_ADMIN_URL + 'events/ajax_get_event_list_',
			async: true,
			type: 'post',
			data: {},
			dataType: 'json',
			success: function (data) {
				html = '<option value="">Select Event </option>';
				html_division = '<option value="">Select Division</option>';
				for (i = 0; i < data.event.length; i++) {
					html += '<option value=' + data.event[i]['id'] + ' >' + data.event[i]['eventId'] + ' | ' + data.event[i]['eventTitle'] + '</option>';
				}
				$.each(data.division, function (key, value) {
					html_division += '<option value=' + key + ' >' + value + '</option>';
				});
				$('#bevent_id').html(html);
				$('#bevent_id').selectpicker('refresh');
				$('#bdivision_id').html(html_division);
				$('#bdivision_id').selectpicker('refresh');
			}
		});
		$('#service_id').selectpicker('refresh');
		//Code Add By Neelu End
	} else if (val == 'rt') {
		$('#packbox_offline').hide(); $('#packbox_online').hide(); $('#packbox_pp').hide();
		$('#packbox_ws').hide(); $('#packbox_eb').hide(); $('#packbox_rt').show();
		//refresh service
		$("#service_id option[value='14']").attr("selected", "selected");
		$('#service_id').selectpicker('refresh');
		//branch forced strat
		$('#center_id').prop('disabled', false); $('#center_id').selectpicker('refresh');
		//branch forced end
		$.ajax({
			url: WOSA_ADMIN_URL + 'realty_test/ajax_get_realityTest_list',
			async: true,
			type: 'post',
			data: {},
			dataType: 'json',
			success: function (data) {
				html = '<option data-subtext="" value="">Select Reality Test</option>';
				for (i = 0; i < data.length; i++) {
					html += '<option value=' + data[i]['id'] + ' >' + data[i]['title'] + ' | ' + data[i]['date'] + ' | ' + data[i]['amount'] + '</option>';
				}
				html += '</select>';
				$('#reality_test_id_dd').html(html);
				$('#reality_test_id_dd').selectpicker('refresh');
			}
		});
		$('#service_id').selectpicker('refresh');
	} else if (val == 'eb') {
		$('#packbox_offline').hide(); $('#packbox_online').hide(); $('#packbox_pp').hide();
		$('#packbox_ws').hide(); $('#packbox_rt').hide(); $('#packbox_eb').show();
		//refresh service
		$("#service_id option[value='" + ACADEMY_SERVICE_REGISTRATION_ID + "']").attr("selected", "selected");
		$('#service_id').selectpicker('refresh');
	}
	else {
		$('#packbox_pp').hide()
		$('#packbox_online').hide()
		$('#packbox_offline').hide()
		$('.batchClass').show()
		$('.batchClass_offline').hide()
		$('.batchClass_online').hide()
		$('#packbox_ws').hide()
		$('#packbox_rt').hide()
		$('#packbox_eb').hide()
		$('#service_id').selectpicker('refresh');
		$('#center_id').prop('disabled', false);
		$('#center_id').selectpicker('refresh');
	}
});
function get_online_package_list() {
	var html = '';
	var test_module_id = $("#test_module_id").val();
	var programe_id = $("#programe_id").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'package_master/ajax_get_online_package_list',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id, batch_id: batch_id },
		dataType: 'json',
		success: function (data) {
			html = '';
			html = '<option data-subtext="" value="">Select Package</option>';
			for (i = 0; i < data.length; i++) {
				if (data[i]['discounted_amount'] === data[i]['amount'] || data[i]['discounted_amount'] == null) {
					html += '<option value=' + data[i]['package_id'] + ' >' + data[i]['package_name'] + ' | ' + data[i]['discounted_amount'] + ' | ' + data[i]['duration'] + '</option>';
				} else {
					html += '<option value=' + data[i]['package_id'] + ' >' + data[i]['package_name'] + ' | ' + data[i]['discounted_amount'] + '/' + data[i]['amount'] + ' | ' + data[i]['duration'] + '</option>';
				}
			}
			html += '</select>';
			$('#package_id').html(html);
			$('#package_id').selectpicker('refresh');
		}
	});
}
function get_offline_package_list(batch_id) {
	var html = '';
	var test_module_id = $("#test_module_id").val();
	var programe_id = $("#programe_id").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'package_master/ajax_get_offline_package_list',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id, batch_id: batch_id },
		dataType: 'json',
		success: function (data) {
			html = '';
			html = '<option data-subtext="" value="">Select package</option>';
			for (i = 0; i < data.length; i++) {
				if (data[i]['discounted_amount'] === data[i]['amount'] || data[i]['discounted_amount'] == null) {
					html += '<option value=' + data[i]['package_id'] + ' >' + data[i]['package_name'] + ' | ' + data[i]['discounted_amount'] + ' | ' + data[i]['duration'] + '</option>';
				} else {
					html += '<option value=' + data[i]['package_id'] + ' >' + data[i]['package_name'] + ' | ' + data[i]['discounted_amount'] + '/' + data[i]['amount'] + ' | ' + data[i]['duration'] + '</option>';
				}
			}
			html += '</select>';
			$('#package_id_off').html(html);
			$('#package_id_off').selectpicker('refresh');
		}
	});
}
function get_package_list_pp(programe_id) {
	var html = '';
	var test_module_id = $("#test_module_id").val();
	var programe_id = $("#programe_id").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'practice_packages/ajax_get_package_list',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id },
		dataType: 'json',
		success: function (data) {
			html = '';
			html = '<option data-subtext="" value="">Select package</option>';
			for (i = 0; i < data.length; i++) {
				if (data[i]['discounted_amount'] === data[i]['amount'] || data[i]['discounted_amount'] == null) {
					html += '<option value=' + data[i]['package_id'] + ' >' + data[i]['package_name'] + ' | ' + data[i]['discounted_amount'] + ' | ' + data[i]['duration'] + '</option>';
				} else {
					html += '<option value=' + data[i]['package_id'] + ' >' + data[i]['package_name'] + ' | ' + data[i]['discounted_amount'] + '/' + data[i]['amount'] + ' | ' + data[i]['duration'] + '</option>';
				}
			}
			html += '</select>';
			$('#package_id_pp').html(html);
			$('#package_id_pp').selectpicker('refresh');
		}
	});
}
//online class packs
/*function get_online_package_list_load(){
	var html='';
	var test_module_id  = $( "#test_module_id" ).val();
	var programe_id     = $( "#programe_id" ).val();
	var batch_id        = $( "#batch_id" ).val();
	$.ajax({
		url: WOSA_ADMIN_URL+'package_master/get_package_list_online',
		async : true,
		type: 'post',
		data: {test_module_id: test_module_id, programe_id: programe_id, batch_id: batch_id},
		dataType: 'json',
		success: function(data){
			html = '';
			html='<option data-subtext="" value="">Select package</option>';
			for(i=0; i<data.length; i++){
				if(data[i]['discounted_amount']===data[i]['amount'] || data[i]['discounted_amount']==null){
					html += '<option value='+ data[i]['package_id'] +' >'+ data[i]['package_name'] +' | '+ data[i]['discounted_amount'] + ' | '+ data[i]['duration'] + '</option>';
				}else{
					html += '<option value='+ data[i]['package_id'] +' >'+ data[i]['package_name'] +' | '+ data[i]['discounted_amount'] + '/'+ data[i]['amount'] + ' | '+ data[i]['duration'] + '</option>';
				}
			}
			html += '</select>';
			//alert(html)
			$('#package_id').html(html);
			$('#package_id').selectpicker('refresh');
		}
	});
}*/
//online class packs
/*function get_offline_package_list_load(){
	var html='';
	var test_module_id  = $( "#test_module_id" ).val();
	var programe_id     = $( "#programe_id" ).val();
	var batch_id        = $( "#batch_id" ).val();
	$.ajax({
		url: WOSA_ADMIN_URL+'package_master/get_package_list_offline',
		async : true,
		type: 'post',
		data: {test_module_id: test_module_id, programe_id: programe_id, batch_id: batch_id},
		dataType: 'json',
		success: function(data){
			html = '';
			html='<option data-subtext="" value="">Select package</option>';
			for(i=0; i<data.length; i++){
				if(data[i]['discounted_amount']===data[i]['amount'] || data[i]['discounted_amount']==null){
					html += '<option value='+ data[i]['package_id'] +' >'+ data[i]['package_name'] +' | '+ data[i]['discounted_amount'] + ' | '+ data[i]['duration'] + '</option>';
				}else{
					html += '<option value='+ data[i]['package_id'] +' >'+ data[i]['package_name'] +' | '+ data[i]['discounted_amount'] + '/'+ data[i]['amount'] + ' | '+ data[i]['duration'] + ' </option>';
				}
			}
			html += '</select>';
			$('#package_id_off').html(html);
			$('#package_id_off').selectpicker('refresh');
		}
	});
}*/
//online class packs
/*function get_pp_package_list_load(){
	var html='';
	var test_module_id  = $( "#test_module_id" ).val();
	var programe_id     = $( "#programe_id" ).val();
	$.ajax({
		url: WOSA_ADMIN_URL+'practice_packages/ajax_get_package_list',
		async : true,
		type: 'post',
		data: {test_module_id: test_module_id, programe_id: programe_id},
		dataType: 'json',
		success: function(data){
			html = '';
			html='<option data-subtext="" value="">Select package</option>';
			for(i=0; i<data.length; i++){
				if(data[i]['discounted_amount']===data[i]['amount'] || data[i]['discounted_amount']==null){
					html += '<option value='+ data[i]['package_id'] +' >'+ data[i]['package_name'] +' | '+ data[i]['discounted_amount'] + ' | '+ data[i]['duration'] + '</option>';
				}else{
					html += '<option value='+ data[i]['package_id'] +' >'+ data[i]['package_name'] +' | '+ data[i]['discounted_amount'] + '/'+ data[i]['amount'] + ' | '+ data[i]['duration'] + '</option>';
				}
			}
			html += '</select>';
			$('#package_id_pp').html(html);
			$('#package_id_pp').selectpicker('refresh');
		}
	});
}*/
function check_payment(amount_entered, walletBalance, page) {
	//alert(walletBalance)
	var payment_type = $("#payment_type").val();
	var due_commitment_date_next = $("#due_commitment_date_next").val();
	var amount_entered = amount_entered.replace(/-/g, '');	
	if(page=='online_offline'){
		if ($("#use_wallet").prop('checked') == true) {
			useWallet = 1;
		} else {
			useWallet = 0;
		}
	}else if(page=='pp'){
		if ($("#use_wallet_pe").prop('checked') == true) {
			useWallet = 1;
		} else {
			useWallet = 0;
		}
	}else{
		useWallet = 0;
	}	
	$('#due_commitment_date_next').prop('disabled', false);
	var amount_due = $('#amount_due').val();
	amount_due = amount_due.replace(/\,/g, '');
	amount_due = parseInt(amount_due);	
	if (payment_type == 'Add payment') {
		if (useWallet == 0) {
			if (amount_entered > amount_due) {
				$('.ad').html('<span class="text-danger">Invalid! Amount can not greater than dues.Please Retry</span>');
				document.getElementById('add_payment').focus();
				document.getElementById('add_payment').value = '';
				$('.uspp').prop('disabled', true);
			}
			else if (amount_entered == amount_due) {
				$('#due_commitment_date_next').prop('disabled', true);
				$('#due_commitment_date_next').val('');
				$('.dcdn').html('');
				$('.uspp').prop('disabled', false);
			}
			else if (amount_entered < amount_due && due_commitment_date_next == '') {
				$('.ad').html('<span class="text-danger"></span>');
				$('.dcdn').html('<span class="text-danger">Please enter next due committment date!</span>');
				document.getElementById('due_commitment_date_next').focus();
				$('.uspp').prop('disabled', true);
			} 	else if (isNaN(amount_entered)) {
				$('.ad').html('<span class="text-danger">Invalid ! Please enter numeric value</span>');
				document.getElementById('add_payment').focus();
				document.getElementById('add_payment').value = '';
				$('.uspp').prop('disabled', true);
			} 
			else if (amount_entered == "" || amount_entered == 0) {
				$('.ad').html('<span class="text-danger">Invalid value!</span>');
				document.getElementById('add_payment').focus();
				document.getElementById('add_payment').value = '';
				$('.uspp').prop('disabled', true);
			} 		
			else {
				$('.ad').html('');
				$('.dcdn').html('');
				$('.uspp').prop('disabled', false);
			}
		} else {
			//alert('p')
			if (walletBalance >= amount_due) {
				amount_entered = amount_due;
				finalWalletAmount = walletBalance - amount_due;
			} else {
				amount_entered = amount_entered + walletBalance;
				finalWalletAmount = 0;
			}
			if (amount_entered > amount_due) {
				$('.ad').html('<span class="text-danger">Invalid! Amount can not greater than dues.Please Retry</span>');
				document.getElementById('add_payment').focus();
				document.getElementById('add_payment').value = '';
				$('.uspp').prop('disabled', true);
			} else if (amount_entered < amount_due && due_commitment_date_next == '') {
				$('.dcdn').html('<span class="text-danger">Please enter next due committment date!</span>');
				document.getElementById('due_commitment_date_next').focus();
				$('.uspp').prop('disabled', true);
			} else if (isNaN(amount_entered)) {
				$('.ad').html('<span class="text-danger">Invalid! Please enter numeric value</span>');
				document.getElementById('add_payment').focus();
				document.getElementById('add_payment').value = '';
				$('.uspp').prop('disabled', true);
			} 
			else if (amount_entered == "" || amount_entered == 0) {
				$('.ad').html('<span class="text-danger">Invalid value!</span>');
				document.getElementById('add_payment').focus();
				document.getElementById('add_payment').value = '';
				$('.uspp').prop('disabled', true);
			} 
			else {
				$('.ad').html('');
				$('.dcdn').html('');
				$('.uspp').prop('disabled', false);
			}
		}
	} else if (payment_type == 'Partial Refund' || payment_type == 'Full Refund') {
		var amount_paid = $('#amount').val();
		amount_paid = amount_paid.replace(/\,/g, '');
		amount_paid = parseInt(amount_paid);
		if (amount_entered > amount_paid) {
			$('.ad').html('<span class="text-danger">Invalid! Amount can not greater than amount paid.Please Retry</span>');
			document.getElementById('add_payment').focus();
			document.getElementById('add_payment').value = '';
		} else if (isNaN(amount_entered)) {
			$('.ad').html('<span class="text-danger">Invalid! Please enter numeric value</span>');
			document.getElementById('add_payment').focus();
			document.getElementById('add_payment').value = '';
		} else {
			$('.ad').html('');
		}
	} else { }
}
function validate_discounted_amount(discounted_amount) {
	var org_amount = $("#amount").val();
	if (discounted_amount <= 0) {
		$('.da').html('<span class="text-danger">Invalid! Real price</span>');
		//document.getElementById('discounted_amount').focus();
		document.getElementById('discounted_amount').value = '';
		$(':input[type="submit"]').prop('disabled', true);
	} else if (parseInt(discounted_amount) > parseInt(org_amount)) {
		$('.da').html('<span class="text-danger">Invalid! Real price cant greater than Fake price</span>');
		//document.getElementById('discounted_amount').focus();
		document.getElementById('discounted_amount').value = '';
		$(':input[type="submit"]').prop('disabled', true);
	} else {
		$('.da').html('');
		$(':input[type="submit"]').prop('disabled', false);
	}
}
function validate_f_amount(discounted_amount) {
	var org_amount = $("#discounted_amount").val();
	if (discounted_amount <= 0) {
		$('.fake_amount_err').html('<span class="text-danger">Invalid! Fake price</span>');
		//document.getElementById('amount').focus();
		document.getElementById('amount').value = '';
		$(':input[type="submit"]').prop('disabled', true);
	} else if (parseInt(discounted_amount) < parseInt(org_amount)) {
		$('.fake_amount_err').html('<span class="text-danger">Invalid! Fake price  cant Less than Real price</span>');
		//document.getElementById('amount').focus();
		document.getElementById('amount').value = '';
		$(':input[type="submit"]').prop('disabled', true);
	} else {
		$('.fake_amount_err').html('');
		$(':input[type="submit"]').prop('disabled', false);
	}
}
function validate_fake_amount(fake_amount) {
	var org_amount = $("#amount").val();
	if (fake_amount <= 0) {
		$('.fake_amount_err').html('<span class="text-danger">Invalid! Fake price</span>');
		document.getElementById('fake_amount').focus();
		document.getElementById('fake_amount').value = '';
		$(':input[type="submit"]').prop('disabled', true);
	} else if (parseInt(fake_amount) > parseInt(org_amount)) {
		$('.fake_amount_err').html('<span class="text-danger">Invalid! Fake price cant greater than Original price</span>');
		document.getElementById('fake_amount').focus();
		document.getElementById('fake_amount').value = '';
		$(':input[type="submit"]').prop('disabled', true);
	} else {
		$('.fake_amount_err').html('');
		$(':input[type="submit"]').prop('disabled', false);
	}
}
function validate_fname(myval) {
	var letters = /^[A-Za-z ]+$/;
	if (myval.match(letters)) {
		$(".fname_err").text('');
		$('.add_std_pack').prop('disabled', false);
	} else {
		$("#fname").focus();
		$(".fname_err").text("Please enter valid Name. Numbers not allowed!");
		$('.add_std_pack').prop('disabled', true);
		return false;
	}
}
function validate_lname(myval) {
	var l = myval.length;
	var letters = /^[A-Za-z ]+$/;
	if (l > 0) {
		if (myval.match(letters)) {
			$(".lname_err").text('');
			$('.add_std_pack').prop('disabled', false);
		} else {
			$("#lname").focus();
			$(".lname_err").text("Please enter valid Name. Numbers not allowed!");
			$('.add_std_pack').prop('disabled', true);
			return false;
		}
	} else {
		$(".lname_err").text('');
		$('.add_std_pack').prop('disabled', false);
	}
}
function validate_fatname(myval) {
	var l = myval.length;
	var letters = /^[A-Za-z ]+$/;
	if (l > 0) {
		if (myval.match(letters)) {
			$(".father_name_err").text('');
			$('.add_std_pack').prop('disabled', false);
		} else {
			$("#father_name").focus();
			$(".father_name_err").text("Please enter valid Name. Numbers not allowed!");
			$('.add_std_pack').prop('disabled', true);
			return false;
		}
	} else {
		$(".father_name_err").text('');
		$('.add_std_pack').prop('disabled', false);
	}
}
function validate_motname(myval) {
	var l = myval.length;
	var letters = /^[A-Za-z ]+$/;
	if (l > 0) {
		if (myval.match(letters)) {
			$(".mother_name_err").text('');
			$('.add_std_pack').prop('disabled', false);
		} else {
			$("#mother_name").focus();
			$(".mother_name_err").text("Please enter valid Name. Numbers not allowed!");
			$('.add_std_pack').prop('disabled', true);
			return false;
		}
	} else {
		$(".mother_name_err").text('');
		$('.add_std_pack').prop('disabled', false);
	}
}
function validate_amount(myval) {
	var filter = /^[0-9-+]+$/;
	if (!filter.test(myval) || myval <= 0) {
		$('.amount_err').text('Please enter valid Price!');
		$('#amount').focus();
		$(':input[type="submit"]').prop('disabled', true);
		return false;
	} else {
		$('.amount_err').text('');
		$(':input[type="submit"]').prop('disabled', false);
	}
}
function validate_booking_amount(myval) {
	var filter = /^[0-9-+]+$/;
	if (!filter.test(myval) || myval <= 0) {
		$('.amount_err').text('Please enter valid Booking Price!');
		$('#amount').focus();
		$('.add_rt').prop('disabled', true);
		return false;
	} else {
		$('.amount_err').text('');
		$('.add_rt').prop('disabled', false);
	}
}
function validate_duration(myval) {
	var filter = /^[0-9-+]+$/;
	if (!filter.test(myval) || myval <= 0) {
		$('.duration_err').text('Please enter valid duration!');
		$('#duration').focus();
		return false;
	} else {
		$('.duration_err').text('');
	}
}
/*function validate_testcount(myval){
  var filter = /^[0-9-+]+$/;
  if (!filter.test(myval)){
   $('.test_paper_limit_err').text('Please enter valid paper count!');
   $('#test_paper_limit').focus();
   return false;
  }else{
	$('.test_paper_limit_err').text('');
  }
}*/
function validate_amount_paid_pp(myval) {
	var val = $(".ppp:checked").val();	
	var packPrice = '';
	myval = parseFloat(myval);
	packPrice = $("#packPrice").val();
	walletBalance = $("#walletBalance").val();		
	if (myval < 0) {
		$('.add_std_pack').prop('disabled', true);
		$('.amount_paid_err').text('Negative Amount not allowed!');
		$('#amount_paid').focus();
		return false;
	} 
	/* else if($("#use_wallet_pp").is(':checked') && zeroaccepted ==0)
	{
		$('#amount_paid_pp').val('');
		$('.add_std_pack').prop('disabled', true);
		$('.amount_paid_err').text("Amount must be greater than 0");
		$('#amount_paid_pp').focus();
		return false;
	} */
	/* else if($("#use_wallet_pp").prop('checked') == false)
	{
		$('#amount_paid_pp').val('');
		$('.add_std_pack').prop('disabled', true);
		$('.amount_paid_err').text("Amount must be greater than 0");
		$('#amount_paid_pp').focus();
		return false;
	} */
	else {
		if (myval >= 0 && myval <= packPrice && val != 'pp') {
			$("#service_id option[value='3']").attr("selected", "selected");
			$('#service_id').selectpicker('refresh');
			$('.amount_paid_err').text('');
			$('.add_std_pack').prop('disabled', false);
		} else if (myval >= 0 && myval <= packPrice && val != 'pp') {
			$("#service_id option[value='3']").attr("selected", "selected");
			$('#service_id').selectpicker('refresh');
			$('.amount_paid_err').text('');
			$('.add_std_pack').prop('disabled', false);
		} else if (val == 'pp' && myval <= packPrice) {
			$("#service_id option[value='14']").attr("selected", "selected");
			$('#service_id').selectpicker('refresh');
			$('.amount_paid_err').text('');
			$('.add_std_pack').prop('disabled', false);
		} else {
			$('.add_std_pack').prop('disabled', true);
			$('.amount_paid_err').text('Please enter valid Amount!');
			$('#amount_paid').focus();
			return false;
		}
		if (myval == packPrice) {
			$('#due_commitment_date_pp').prop('disabled', true);
			$('#due_commitment_date_pp').val('');
		}
		else {
			$('#due_commitment_date_pp').prop('disabled', false);
			$('#due_commitment_date_pp').val('');
		}
	}
	// $('#myTable #tbpackprice').html(currency+' '+myval);
}
function validate_amount_paid(myval) {
	var val = $(".ppp:checked").val();
	var packPrice = '';
	myval = parseFloat(myval);
	packPrice = $("#packPrice").val();
	if (myval < 0) {
		$('.add_std_pack').prop('disabled', true);
		$('.amount_paid_err').text('Negative Amount not allowed!');
		$('#amount_paid').focus();
		return false;
	} 
	/* else if($("#use_wallet_on").is(':checked') && myval ==0)
	{
		$('#amount_paid').val('');
		$('.add_std_pack').prop('disabled', true);
		$('.amount_paid_err').text("Amount must be greater than 0");
		$('#amount_paid').focus();
		return false;
	}	 */
	else {
		if (myval >= 0 && myval <= packPrice && val != 'pp') {
			$("#service_id option[value='3']").attr("selected", "selected");
			$('#service_id').selectpicker('refresh');
			$('.amount_paid_err').text('');
			$('.add_std_pack').prop('disabled', false);
		} else if (myval >= 0 && myval <= packPrice && val != 'pp') {
			$("#service_id option[value='3']").attr("selected", "selected");
			$('#service_id').selectpicker('refresh');
			$('.amount_paid_err').text('');
			$('.add_std_pack').prop('disabled', false);
		} else if (val == 'pp' && myval <= packPrice) {
			$("#service_id option[value='14']").attr("selected", "selected");
			$('#service_id').selectpicker('refresh');
			$('.amount_paid_err').text('');
			$('.add_std_pack').prop('disabled', false);
		} else {
			$('.add_std_pack').prop('disabled', true);
			$('.amount_paid_err').text('Please enter valid Amount!');
			$('#amount_paid').focus();
			return false;
		}
		if (myval == packPrice) {
			$('#due_commitment_date').prop('disabled', true);
			$('#due_commitment_date').val('');
		}
		else {
			$('#due_commitment_date').prop('required', true);
			$('#due_commitment_date').prop('disabled', false);
			$('#due_commitment_date').val('');
		}
	}
	// $('#myTable #tbpackprice').html(currency+' '+myval);
}
function validate_form() {
	var type = $('input[name=pack_cb]:checked').val();
	var filter = /^[0-9-+]+$/;
	var payment_type = $('#payment_type').val();
	//for exam page
	var test_module_id = $("#test_module_id_eb").val();
	if (payment_type == 'Pre-Booking') {
		var passport_no = $("#passport_no_pbf").val();
		if (passport_no == '' || passport_no.length < 8 || passport_no.length > 8) {
			$('.passport_no_pbf_err').text('Please enter valid passport no.');
			$('#passport_no_pbf').focus();
			return false;
		} else {
			$('.passport_no_pbf_err').text('');
		}
		var passport_expiry = $("#passport_expiry_pbf").val();
		if (passport_expiry == '' || passport_expiry.length < 10 || passport_expiry.length > 10) {
			$('.passport_expiry_pbf_err').text('Please enter valid expiry');
			$('#passport_expiry_pbf').focus();
			return false;
		} else {
			$('.passport_expiry_pbf_err').text('');
		}
		if ($('#document_file_front_pbf').is(':disabled')) {
			$('.document_file_front_pbf_err').text('');
			//return true;
		} else {
			if ($("#document_file_front_pbf").val() == "") {
				$('.document_file_front_pbf_err').text('Please upload passport front page');
				return false;
			} else {
				$('.document_file_front_pbf_err').text('');
			}
		}
		if ($('#document_file_back_pbf').is(':disabled')) {
			$('.document_file_back_pbf_err').text('');
		} else {
			if ($("#document_file_back_pbf").val() == "") {
				$('.document_file_back_pbf_err').text('Please upload passport back page');
				//return false;
			} else {
				$('.document_file_back_pbf_err').text('');
			}
		}
		if (test_module_id == 1) {
			var exam_date = $("#exam_date_eb").val();
			if (exam_date == '') {
				$('.exam_date_eb_err').text('Please enter exam date');
				return false;
			} else {
				$('.exam_date_eb_err').text('');
			}
		} else {
			var exam_date = $("#exam_date_eb2").val();
			if (exam_date == '') {
				$('.exam_date_eb2_err').text('Please enter exam date');
				return false;
			} else {
				$('.exam_date_eb2_err').text('');
			}
		}
		var city = $("#city_eb").val();
		if (city == '') {
			$('.city_eb_err').text('Please select city');
			return false;
		} else {
			$('.city_eb_err').text('');
		}
		var method = $("#method_pbf").val();
		/*if(method==''){
			$('.method_pbf_err').text('Please select payment mode');
			return false;
		}else{
			$('.method_pbf_err').text('');
		}*/
		if (method == 'cash') {
			var discount_type_pbf = $("#discount_type_pbf").val();
			if (discount_type_pbf == '') {
				$('.discount_type_pbf_err').text('Please select discount type');
				return false;
			} else {
				$('.discount_type_pbf_err').text('');
			}
			var amount_paid = $("#amount_paid_pbf").val();
			var balanceLeft = $('#balanceLeft').text();
			balanceLeft = balanceLeft.replace(/\,/g, '');
			balanceLeft = parseInt(balanceLeft);
			if (amount_paid == 0) {
				$('.amount_paid_pbf_err').text('');
			} else if (amount_paid > 0) {
				if (amount_paid != balanceLeft) {
					$('.amount_paid_pbf_err').text('please enter valid amount');
					return false;
				} else {
					$('.amount_paid_pbf_err').text('');
				}
			} else {
				$('.amount_paid_pbf_err').text('');
			}
		} else {
		}
	} else if (payment_type == 'Post-Booking') {
		if (test_module_id == 1) {
			var exam_date = $("#exam_date_peb").val();
			if (exam_date == '') {
				$('.exam_date_peb_err').text('Please enter exam date');
				return false;
			} else {
				$('.exam_date_peb_err').text('');
			}
		} else {
			var exam_date = $("#exam_date_peb2").val();
			if (exam_date == '') {
				$('.exam_date_peb2_err').text('Please enter exam date');
				return false;
			} else {
				$('.exam_date_peb2_err').text('');
			}
		}
		var city = $("#city_peb").val();
		if (city == '') {
			$('.city_peb_err').text('Please select city');
			return false;
		} else {
			$('.city_peb_err').text('');
		}
		var speaking_date = $("#speaking_date_peb").val();
		if (speaking_date == '') {
			$('.speaking_date_peb_err').text('Please select speaking date');
			return false;
		} else {
			$('.speaking_date_peb_err').text('');
		}
		var speaking_time_slot = $("#speaking_time_slot_peb").val();
		if (speaking_time_slot == '') {
			$('.speaking_time_slot_peb_err').text('Please select speaking time slot');
			return false;
		} else {
			$('.speaking_time_slot_peb_err').text('');
		}
		var result_date = $("#result_date_peb").val();
		if (result_date == '') {
			$('.result_date_peb_err').text('Please enter result date');
			return false;
		} else {
			$('.result_date_peb_err').text('');
		}
		var student_id = $("#student_id_peb").val();
		if (student_id == '') {
			$('.student_id_peb_err').text('Please enter student ID');
			return false;
		} else {
			$('.student_id_peb_err').text('');
		}
		var student_password = $("#student_password_peb").val();
		if (student_password == '') {
			$('.student_password_peb_err').text('Please enter password');
			return false;
		} else {
			$('.student_password_peb_err').text('');
		}
	} else if (payment_type == 'Reschedule') {
		var test_module_id = $("#test_module_id_eb").val();
		var rsType = $(".rsTypeClass:checked").val();
		if (rsType == 'Existing') {
			if (test_module_id == 1) {
				var exam_date = $("#rsExamdate").val();
				if (exam_date == '') {
					$('.rsExamdate_err').text('Please enter LRW date');
					return false;
				} else {
					$('.rsExamdate_err').text('');
				}
			} else {
				var exam_date = $("#rsExamdate2").val();
				if (exam_date == '') {
					$('.rsExamdate2_err').text('Please enter LRW date');
					return false;
				} else {
					$('.rsExamdate2_err').text('');
				}
			}
			var city = $("#rsCity").val();
			if (city == '') {
				$('.rsCity_err').text('Please select city');
				return false;
			} else {
				$('.rsCity_err').text('');
			}
			var rsVenueName = $("#rsVenueName").val();
			if (rsVenueName == '') {
				$('.rsVenueName_err').text('Please select venue');
				return false;
			} else {
				$('.rsVenueName_err').text('');
			}
			var rsVenueAddress = $("#rsVenueAddress").val();
			if (rsVenueAddress == '') {
				$('.rsVenueAddress_err').text('Please select venue address');
				return false;
			} else {
				$('.rsVenueAddress_err').text('');
			}
		} else if (rsType == 'New') {
			var exam_date = $("#rsLRW_date").val();
			if (exam_date == '') {
				$('.rsLRW_date_err').text('Please enter LRW date');
				return false;
			} else {
				$('.rsLRW_date_err').text('');
			}
			var city = $("#rsCity1").val();
			if (city == '') {
				$('.rsCity1_err').text('Please select city');
				return false;
			} else {
				$('.rsCity1_err').text('');
			}
			var rsVenueName = $("#rsVenueName1").val();
			if (rsVenueName == '') {
				$('.rsVenueName1_err').text('Please select venue');
				return false;
			} else {
				$('.rsVenueName1_err').text('');
			}
			var rsVenueAddress = $("#rsVenueAddress1").val();
			if (rsVenueAddress == '') {
				$('.rsVenueAddress1_err').text('Please select venue address');
				return false;
			} else {
				$('.rsVenueAddress1_err').text('');
			}
		} else {
		}
		var speaking_date = $("#rsSpeakingDate").val();
		if (speaking_date == '') {
			$('.rsSpeakingDate_err').text('Please select speaking date');
			return false;
		} else {
			$('.rsSpeakingDate_err').text('');
		}
		var speaking_time_slot = $("#rsTimeSlot").val();
		if (speaking_time_slot == '') {
			$('.rsTimeSlot_err').text('Please select speaking time slot');
			return false;
		} else {
			$('.rsTimeSlot_err').text('');
		}
		var rsMethod = $("#rsMethod").val();
		if (rsMethod == '') {
			$('.rsMethod_err').text('Please select payment mode');
			return false;
		} else {
			$('.rsMethod_err').text('');
		}
		var rsAmount = $("#rsAmount").val();
		if (rsAmount == '') {
			$('.rsAmount_err').text('Please enter reschedule charges');
			return false;
		} else {
			$('.rsAmount_err').text('');
		}
	} else if (payment_type == 'Result') {
		var actualResultdate = $("#actualResultdate").val();
		if (actualResultdate == '') {
			$('.actualResultdate_err').text('Please enter result date');
			return false;
		} else {
			$('.actualResultdate_err').text('');
		}
		var listening = $("#listening").val();
		if (listening == '') {
			$('.listening_err').text('Please enter listening score');
			return false;
		} else {
			$('.listening_err').text('');
		}
		var reading = $("#reading").val();
		if (reading == '') {
			$('.reading_err').text('Please enter reading score');
			return false;
		} else {
			$('.reading_err').text('');
		}
		var writing = $("#writing").val();
		if (writing == '') {
			$('.writing_err').text('Please enter writing score');
			return false;
		} else {
			$('.writing_err').text('');
		}
		var speaking = $("#speaking").val();
		if (speaking == '') {
			$('.speaking_err').text('Please enter speaking score');
			return false;
		} else {
			$('.speaking_err').text('');
		}
	} else if (payment_type == 'Re-evaluation') {
		var reEvaluationMethod = $("#reEvaluationMethod").val();
		if (reEvaluationMethod == '') {
			$('.reEvaluationMethod_err').text('Please enter payment mode');
			return false;
		} else {
			$('.reEvaluationMethod_err').text('');
		}
		var amount_paid_reEvaluation = $("#amount_paid_reEvaluation").val();
		if (amount_paid_reEvaluation == '') {
			$('.amount_paid_reEvaluation_err').text('Please enter amount');
			return false;
		} else {
			$('.amount_paid_reEvaluation_err').text('');
		}
	} else if (payment_type == 'Cancel-Booking') {
		var cancelRemarks = $("#cancelRemarks").val();
		if (cancelRemarks == '') {
			$('.cancelRemarks_err').text('Please enter remarks');
			return false;
		} else {
			$('.cancelRemarks_err').text('');
		}
	} else if (payment_type == 'Full Refund') {
	} else {
	}
	//exam page validation end
	if (type == 'offline') {
		var inhousePackCount = 0;
		var package_id = $("#package_id_off");
		var method = $("#method_off");
		var amount_paid = $("#amount_paid_off");
		var start_date = $("#start_date_off");
		var batch_id = $('#batch_id_off');
		//for due committment date: start
		var due_commitment_date = $('#due_commitment_date_off').val();
		var student_id = $('#student_id').val();
		var packPrice = $('#packPrice').val();
		var waiver = parseInt($('#waiver_off').val());
		var other_discount = parseInt($('#other_discount_off').val());
		if ($("#use_wallet_off").prop('checked') == true) {
			useWallet = 1;
		} else {
			useWallet = 0;
		}
		if (useWallet == 1) {
			var walletBalance = $('#walletBalance').val();
			if (walletBalance >= packPrice) {
				$('.due_commitment_date_off_err').text('');
			} else if (walletBalance < packPrice) {
				totalAmountPaid = parseInt(waiver + other_discount + amount_paid.val() + walletBalance);
				if (totalAmountPaid < packPrice && due_commitment_date == '') {
					$('.due_commitment_date_off_err').text('Please enter due committment date!');
					$('#due_commitment_date_off').focus();
					return false;
				} else {
					$('.due_commitment_date_off_err').text('');
				}
			} else {
				$('.due_commitment_date_off_err').text('');
			}
		} else {
			totalAmountPaid = parseInt(waiver + other_discount + amount_paid.val());
			if (totalAmountPaid < packPrice && due_commitment_date == '') {
				$('.due_commitment_date_off_err').text('Please enter due committment date!');
				$('#due_commitment_date_off').focus();
				return false;
			} else if (totalAmountPaid == packPrice) {
				$('.due_commitment_date_off_err').text('');
			} else {
				$('.due_commitment_date_off_err').text('');
			}
		}
		//for due committment date ends
		if (package_id.val() == "") {
			$('.package_id_off_err').text('Please select package!');
			$('#package_id_off').focus();
			return false;
		} else if (method.val() == "") {
			$('.method_off_err').text('Please select payment method!');
			$('#method_off').focus();
			return false;
		} else if (!filter.test(amount_paid.val())) {
			$('.amount_paid_off_err').text('Please enter valid Amount!');
			$('#amount_paid_off').focus();
			return false;
		} else if (start_date.val() == "") {
			$('.start_date_off_err').text('Please enter Pack starting date!');
			$('#start_date_off').focus();
			return false;
		} else if (batch_id.val() == "") {
			$('.batch_id_off_err').text('Please select batch!');
			$('#batch_id_off').focus();
			return false;
		} else {
			$('.package_id_off_err').text('');
			$('.method_off_err').text('');
			$('.amount_paid_off_err').text('');
			$('.start_date_off_err').text('');
			$('.batch_id_off_err').text('');
		}
	} else if (type == 'online') {
		var package_id = $("#package_id");
		var method = $("#method");
		var amount_paid = $("#amount_paid");
		var start_date = $("#start_date");
		var batch_id = $('#batch_id');
		//for due committment date: start
		var due_commitment_date = $('#due_commitment_date').val();
		var student_id = $('#student_id').val();
		var packPrice = $('#packPrice').val();
		var waiver = parseInt($('#waiver').val());
		var other_discount = parseInt($('#other_discount').val());
		var totalAmountPaid = 0;
		if ($("#use_wallet_on").prop('checked') == true) {
			useWallet = 1;
		} else {
			useWallet = 0;
		}
		if (useWallet == 1) {
			var walletBalance = $('#walletBalance').val();
			if (walletBalance >= packPrice) {
				$('.due_commitment_date_err').text('');
			} else if (walletBalance < packPrice) {
				totalAmountPaid = parseInt(waiver + other_discount + amount_paid.val() + walletBalance);
				if (totalAmountPaid < packPrice && due_commitment_date == '') {
					$('.due_commitment_date_err').text('Please enter due committment date!');
					$('#due_commitment_date').focus();
					return false;
				} else {
					$('.due_commitment_date_err').text('');
				}
			} else {
				$('.due_commitment_date_err').text('');
			}
		} else {
			totalAmountPaid = parseInt(waiver + other_discount + amount_paid.val());
			if (totalAmountPaid < packPrice && due_commitment_date == '') {
				$('.due_commitment_date_err').text('Please enter due committment date!');
				$('#due_commitment_date').focus();
				return false;
			} else if (totalAmountPaid == packPrice) {
				$('.due_commitment_date_err').text('');
			} else {
				$('.due_commitment_date_err').text('');
			}
		}
		//for due committment date ends
		if (package_id.val() == "") {
			$('.package_id_err').text('Please select package!');
			$('#package_id').focus();
			return false;
		} else if (method.val() == "") {
			$('.method_err').text('Please select payment method!');
			$('#method').focus();
			return false;
		} else if (!filter.test(amount_paid.val())) {
			$('.amount_paid_err').text('Please enter valid Amount!');
			$('#amount_paid').focus();
			return false;
		} else if (start_date.val() == "") {
			$('.start_date_err').text('Please enter Pack starting date!');
			$('#start_date').focus();
			return false;
		} else if (batch_id.val() == "") {
			$('.batch_id_err').text('Please select batch!');
			$('#batch_id').focus();
			return false;
		} else {
			$('.package_id_err').text('');
			$('.method_err').text('');
			$('.amount_paid_err').text('');
			$('.start_date_err').text('');
			$('.batch_id_err').text('');
		}
	} else if (type == 'pp') {
		var package_id = $("#package_id_pp");
		var method = $("#method_pp");
		var amount_paid = $("#amount_paid_pp");
		var start_date = $("#start_date_pp");
		//for due committment date: start
		var due_commitment_date = $('#due_commitment_date_pp').val();
		var student_id = $('#student_id').val();
		var packPrice = $('#packPrice').val();
		var waiver = parseInt($('#waiver_pp').val());
		var other_discount = parseInt($('#other_discount_pp').val());
		if ($("#use_wallet_pp").prop('checked') == true) {
			useWallet = 1;
		} else {
			useWallet = 0;
		}
		if (useWallet == 1) {
			var walletBalance = $('#walletBalance').val();
			if (walletBalance >= packPrice) {
				$('.due_commitment_date_pp_err').text('');
			} else if (walletBalance < packPrice) {
				totalAmountPaid = parseInt(waiver + other_discount + amount_paid.val() + walletBalance);
				if (totalAmountPaid < packPrice && due_commitment_date == '') {
					$('.due_commitment_date_pp_err').text('Please enter due committment date!');
					$('#due_commitment_date_pp').focus();
					return false;
				} else {
					$('.due_commitment_date_pp_err').text('');
				}
			} else {
				$('.due_commitment_date_pp_err').text('');
			}
		} else {
			totalAmountPaid = parseInt(waiver + other_discount + amount_paid.val());
			if (totalAmountPaid < packPrice && due_commitment_date == '') {
				$('.due_commitment_date_pp_err').text('Please enter due committment date!');
				$('#due_commitment_date_pp').focus();
				return false;
			} else if (totalAmountPaid == packPrice) {
				$('.due_commitment_date_pp_err').text('');
			} else {
				$('.due_commitment_date_pp_err').text('');
			}
		}
		//for due committment date ends
		if (package_id.val() == "") {
			$('.package_id_pp_err').text('Please select package!');
			$('#package_id_pp').focus();
			return false;
		} else if (method.val() == "") {
			$('.method_pp_err').text('Please select payment method!');
			$('#method_pp').focus();
			return false;
		} else if (!filter.test(amount_paid.val())) {
			$('.amount_paid_pp_err').text('Please enter valid Amount!');
			$('#amount_paid_pp').focus();
			return false;
		} else if (start_date.val() == "") {
			$('.start_date_pp_err').text('Please enter Pack starting date!');
			$('#start_date_pp').focus();
			return false;
		} else {
			$('.package_id_pp_err').text('');
			$('.method_pp_err').text('');
			$('.amount_paid_pp_err').text('');
			$('.start_date_pp_err').text('');
		}
	} else if (type == 'ws') {
		//validation of workshop/event form goes here
		//add Code By Neelu
		var event_id = $("#bevent_id").val();
		var event_location_id = $("#bevent-location-id").val();
		myArray = event_location_id.split("-");
		division_name = myArray[3];
		var event_location_course_id = $("#event_location_course_id").val();
		var event_booking_date = $("#event_booking_date").val();
		var event_booking_date_time = $("#event_booking_date_time").val();
		var amount_paid_ws = $("#amount_paid_ws").val();
		var event_location_course_countries = $("#event_location_course_countries").val();
		var method_ws = $("#method_ws").val();
		//alert(event_location_countries_id);
		$('.event_ws_err').text('');
		$('.event_location_id_ws_err').text('');
		$('.event_location_course_countries_err').text('');
		$('.event_location_event_booking_date_time_err').text('');
		$('.method_ws_err').text('');
		$('.amount_paid_ws_err').text('');
		var isNotValidate = false;
		if (event_id == '') {
			$('.event_ws_err').text('Please select event!');
			$('#bevent_id').focus();
			isNotValidate = true;
			//end Code By Neelu
		} else if (event_location_id == '') {
			$('.event_location_id_ws_err').text('Please select location!');
			$('#bevent-location-id').focus();
			isNotValidate = true;
		}
		else if (event_location_course_countries == '') {
			if (division_name == 'visa') {
				$('.event_location_course_countries_err').text('Please select countries!');
				$('#event_location_countries_id').focus();
			} else {
				$('.event_location_course_countries_err').text('Please select course!');
				$('#event_location_course_id').focus();
			}
			isNotValidate = true;
		} else if (event_booking_date == '') {
			$('.event_location_event_booking_date_err').text('Please select date!');
			isNotValidate = true;
		} else if (event_booking_date_time == '') {
			$('.event_location_event_booking_date_time_err').text('Please select time!');
			isNotValidate = true;
		} else if (method_ws == '') {
			$('.method_ws_err').text('Please select payment mode!');
			isNotValidate = true;
		} else if (amount_paid_ws == '') {
			alert(amount_paid_ws);
			$('.amount_paid_ws_err').text('Please enter amount paid!');
			isNotValidate = true;
		}
		if (isNotValidate) {
			return false;
		}
	} else if (type == 'rt') {
		var reality_test_id = $("#reality_test_id_dd");
		var time_slots = $("#time_slots_rt");
		var center_id = $("#center_id_rt");
		var programe_id = $("#programe_id_rt");
		var method = $("#method_rt");
		var amount_paid = $("#amount_paid_rt");
		//for due committment date: start
		var due_commitment_date = $('#due_commitment_date_rt').val();
		var student_id = $('#student_id').val();
		var packPrice = $('#packPrice').val();
		var waiver = parseInt($('#waiver_rt').val());
		var other_discount = parseInt($('#other_discount_rt').val());
		//var totalAmountPaid = 0;
		if ($("#use_wallet_rt").prop('checked') == true) {
			useWallet = 1;
		} else {
			useWallet = 0;
		}
		if (useWallet == 1) {
			var walletBalance = $('#walletBalance').val();
			if (walletBalance >= packPrice) {
				$('.due_commitment_date_rt_err').text('');
			} else if (walletBalance < packPrice) {
				totalAmountPaid = parseInt(waiver + other_discount + amount_paid.val() + walletBalance);
				if (totalAmountPaid < packPrice && due_commitment_date == '') {
					$('.due_commitment_date_rt_err').text('Please enter due committment date!');
					$('#due_commitment_date_rt').focus();
					return false;
				} else {
					$('.due_commitment_date_rt_err').text('');
				}
			} else {
				$('.due_commitment_date_rt_err').text('');
			}
		} else {
			totalAmountPaid = parseInt(waiver + other_discount + amount_paid.val());
			if (totalAmountPaid < packPrice && due_commitment_date == '') {
				$('.due_commitment_date_rt_err').text('Please enter due committment date!');
				$('#due_commitment_date_rt').focus();
				return false;
			} else if (totalAmountPaid == packPrice) {
				$('.due_commitment_date_rt_err').text('');
			} else {
				$('.due_commitment_date_rt_err').text('');
			}
		}
		//for due committment date ends
		if (reality_test_id.val()) {
			var test_module_id = $('#rt_test');
			if (test_module_id == 1) {
				$('.center_id_rt_err').text('');
			} else {
				if (center_id.val() == "") {
					$('.center_id_rt_err').text('Please select branch!');
					$('#center_id_rt').focus();
					return false;
				} else {
					$('.center_id_rt_err').text('');
				}
			}
		} else {
			$('.center_id_rt_err').text('');
			test_module_id = '';
		}
		if (reality_test_id.val() == "") {
			$('.reality_test_id_dd_err').text('Please select test!');
			$('#reality_test_id_dd').focus();
			return false;
		} else if ($('input[name="time_slots_rt"]:checked').length == 0) {
			$('.time_slots_rt_err').text('Please select time slot!');
			return false;
		} else if (programe_id.val() == "") {
			$('.programe_id_rt_err').text('Please select programe!');
			$('#programe_id_rt').focus();
			return false;
		} else if (method.val() == "") {
			$('.method_rt_err').text('Please select payment method!');
			$('#method_rt').focus();
			return false;
		} else if (!filter.test(amount_paid.val())) {
			$('.amount_paid_rt_err').text('Please enter valid Amount!');
			$('#amount_paid_rt').focus();
			return false;
		} else {
			$('.reality_test_id_dd_err').text('');
			$('.time_slots_rt_err').text('');
			$('.method_rt_err').text('');
			$('.amount_paid_err').text('');
			$('.programe_id_rt_err').text('');
		}
	} else if (type == 'eb') {
		var test_module_id = $("#test_module_id_eb");
		var programe_id = $("#programe_id_eb");
		var exam_date = $("#exam_date_eb");
		var city = $('#city_eb');
		var first_language = $('#first_language_eb');
		var special_case = $('#special_case_eb');
		var minor = $('#minor_eb');
		if (test_module_id.val() == "") {
			$('.test_module_id_eb_err').text('Please select course!');
			$('#test_module_id_eb').focus();
			return false;
		} else {
			$('.test_module_id_eb_err').text('');
		}
		if (programe_id.val() == "") {
			$('.programe_id_eb_err').text('Please select programe!');
			$('#programe_id_eb').focus();
			return false;
		} else {
			$('.programe_id_eb_err').text('');
		}
		if (exam_date.val() == "") {
			$('.exam_date_eb_err').text('Please select exam date!');
			$('#exam_date_eb').focus();
			return false;
		} else {
			$('.exam_date_eb_err').text('');
		}
		/*if(test_module_id.val() == 1){
			if(exam_date.val() == ""){
				$('.exam_date_eb_err1').text('Please select exam date!');
				$('#exam_date_eb1').focus();
				return false;
			}else{
				$('.exam_date_eb_err1').text('');
			}
		}else{
			if(exam_date.val() == ""){
				$('.exam_date_eb_err2').text('Please enter exam date!');
				$('#exam_date_eb2').focus();
				return false;
			}else{
				$('.exam_date_eb_err2').text('');
			}
		}*/
		/*if(test_module_id.val() == 3){
			if(city.val() == ""){
				$('.city_eb_err2').text('Please select city!');
				$('#city_eb2').focus();
				return false;
			}else{
				$('.city_eb_err2').text('');
			}
		}else{
			$('.city_eb_err2').text('');
		}*/
		if (city.val() == "") {
			$('.city_eb_err').text('Please select city!');
			$('#city_eb').focus();
			return false;
		} else {
			$('.city_eb_err').text('');
		}
		if (first_language.val() == "") {
			$('.first_language_eb_err').text('Please select language!');
			$('#first_language_eb').focus();
			return false;
		} else {
			$('.first_language_eb_err').text('');
		}
		if (special_case.val() == "") {
			$('.special_case_eb_err').text('Please select case!');
			$('#special_case_eb').focus();
			return false;
		} else {
			$('.special_case_eb_err').text('');
		}
		if (minor.val() == "") {
			$('.minor_eb_err').text('Please select minor!');
			$('#minor_eb').focus();
			return false;
		} else {
			$('.minor_eb_err').text('');
		}
	} else {
	}
}
function validate_filter_first() {
	if ($('#test_module_id').val() == '') {
		$('.test_module_id_err').text('Please select course first');
		return false;
	} else {
		$('.test_module_id_err').text('');
	}
	if ($('#programe_id').val() == '') {
		$('.programe_id_err').text('Please select programe first');
		return false;
	} else {
		$('.programe_id_err').text('');
	}
}
function validateDateDD() {
	var test_module_id = $("#test_module_id_eb");
	if (test_module_id.val() == 1) {
		$('.dateControl').hide();
		$('.date_dd').show();
	} else {
		$('.dateControl').show();
		$('.date_dd').hide();
	}
}
//gallery link copy
function copy_link(id) {
	var copyText = document.getElementById(id);
	copyText.select();
	copyText.setSelectionRange(0, 999);
	document.execCommand("copy");
	alert("Copied the LINK: " + copyText.value);
}
//print student_answer result
function printx() {
	var prtContent = document.getElementById("printid");
	var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
	WinPrint.document.write(prtContent.innerHTML);
	WinPrint.document.close();
	WinPrint.focus();
	WinPrint.print();
	WinPrint.close();
}
//print table data
function printDiv(divName) {
	$('.noPrint').hide();
	var printContents = document.getElementById(divName).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = originalContents;
}
function get_category_forPack(programe_id) {
	var test_module_id = $("#test_module_id").val();
	var classsroomPage = $("#classsroomPage").val();
	var html = '';
	$.ajax({
		url: WOSA_ADMIN_URL + 'category_master/ajax_get_category_forPack',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id },
		dataType: 'json',
		success: function (data) {
			html = '';
			if (classsroomPage == 'classsroomPage') {
				html = '<option value="" disabled="disabled">Select Category</option>';
			} else {
				html = '<option value="" disabled="disabled">Select Category</option>';
			}
			for (i = 0; i < data.length; i++) {
				html += '<option  value=' + data[i]['category_id'] + ' >  ' + data[i]['test_module_name'] + ' | ' + data[i]['programe_name'] + ' | ' + data[i]['category_name'] + ' </option>';
			}
			html += '</select>';
			$('#category_id').html(html);
			$('#category_id').selectpicker('refresh');
		}
	});
}
function get_category_forPackMulti(programe_id) {
	var test_module_id = [];
	var test_module_id = $("#test_module_id").val();
	var html = '';
	$.ajax({
		url: WOSA_ADMIN_URL + 'category_master/ajax_get_category_forPackMulti',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id },
		dataType: 'json',
		success: function (data) {
			html = '';
			html = '<option value="" disabled="disabled">Select Category</option>';
			for (i = 0; i < data.length; i++) {
				html += '<option data-subtext=' + data[i]['category_id'] + ' value=' + data[i]['category_id'] + ' >  ' + data[i]['test_module_name'] + ' | ' + data[i]['programe_name'] + ' | ' + data[i]['category_name'] + ' </option>';
			}
			html += '</select>';
			$('#category_id').html(html);
			$('#category_id').selectpicker('refresh');
		}
	});
}
function get_otp() {
	var mobile = $("#mobile").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'student/ajax_get_otp',
		type: 'post',
		data: { mobile: mobile },
		success: function (response) {
			if (response.status == 'true') {
				$('.otp_err').text(response.msg);
				$('#otp').val(response.otp);
				//document.getElementById("otp").disabled = true;
			} else {
				$('.mobile_err').text(response.msg);
				$('#otp').val('');
			}
		}
	});
}
function send_mobile_otp() {
	var mobile = $("#mobile").val();
	var country_code = $("#country_code").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'student/ajax_send_mobile_otp',
		type: 'post',
		data: { mobile: mobile,country_code:country_code },
		success: function (response) {
			
			if (response.status == 'true') {
				//$('#mobileOTP').val(response.otp);
				$('.mobile_otp_err').text(response.msg);
			} else {
				$('#mobileOTP').val('');
				$('.mobile_otp_err').text(response.msg);
			}
		}
	});
}
function send_email_otp() {
	var email = $("#email").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'student/ajax_send_email_otp',
		type: 'post',
		data: { email: email },
		success: function (response) {
			
			if (response.status == 'true') {
				//$('#emailOTP').val(response.otp);
				$('.email_otp_err').text(response.msg);
			} else {
				//$('#emailOTP').val('');
				$('.email_otp_err').text(response.msg);
			}
		}
	});
}

function get_otp_walkin() {
	var mobile = $("#mobile").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'walkin/ajax_get_otp_walkin',
		type: 'post',
		data: { mobile: mobile },
		success: function (response) {
			if (response.status == 'true') {
				$('.otp_err').text(response.msg);
				$('#otp').val(response.otp);
				//document.getElementById("otp").disabled = true;
			} else {
				$('.mobile_err').text(response.msg);
				$('#otp').val('');
			}
		}
	});
}
function reflectPgmBatch(test_module_id, page) {
	var student_programe_id=$('#student_programe_id').val();	
	var student_test_module_id=$('#student_test_module_id').val();	
	var disables_option="";
	$.ajax({
		url: WOSA_ADMIN_URL + 'programe_master/ajax_getPrograme',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id },
		dataType: 'json',
		success: function (response) {
			html = '';
			if(page == 'online_pack' || page == 'mock_test' || page == 'studentPage' || page == 'pp_pack' || page == 'classroom'){
				html = '<option value="">Select Program</option>';
			}else{
				html = '<option value="" disabled="disabled">Select Program</option>';
			}		
			for (i = 0; i < response.msg.length; i++) {
				if(student_test_module_id == test_module_id && response.msg[i]['programe_id'] == student_programe_id)
				{
					disables_option="disabled";
				}else{
					disables_option="";
				}
				html += '<option value=' + response.msg[i]['programe_id'] + ' '+disables_option+' >' + response.msg[i]['programe_name'] + '</option>';
			}
			html += '</select>';
			$('#programe_id').html(html);
			$('#programe_id').selectpicker('refresh');
		}
	});
	$('#category_id').prop('selectedIndex', '');
		$('#category_id').selectpicker('refresh');
	if (page == 'studentPage') {
		$('#programe_id').prop('selectedIndex', '');
		$('#programe_id').selectpicker('refresh');
		$('.ppp').prop('checked', false);
		$('#packbox_offline').hide()
		$('#packbox_online').hide()
		$('#packbox_pp').hide()
		$('#packbox_ws').hide()
		$('#packbox_rt').hide()
		$('#packbox_eb').hide()
	} else {
		$('#programe_id').prop('selectedIndex', '');
		$('#programe_id').selectpicker('refresh');
	}
}
function reflectPgmBatch_eb() {
	/*var test_module_id = $('#test_module_id_eb').val();
	if(test_module_id==3){
		$('#programe_id_eb').prop('selectedIndex',1);
		$('#programe_id_eb').selectpicker('refresh');
	}else{
		$('#programe_id_eb').prop('selectedIndex','');
		$('#programe_id_eb').selectpicker('refresh');
	}*/
	$('#programe_id_eb').prop('selectedIndex', '');
	$('#programe_id_eb').selectpicker('refresh');
	$('#exam_fee_eb').val('');
	$('#city_eb').prop('selectedIndex', '');
	$('#city_eb').selectpicker('refresh');
	$('#exam_date_eb').prop('selectedIndex', '');
	$('#exam_date_eb').selectpicker('refresh');
	$('#venue_name_eb').val('');
	$('#venue_address_eb').val('');
}
function unsetPackRadio() {
	$('.ppp').prop('checked', false);
	$('#packbox_offline').hide()
	$('#packbox_online').hide()
	$('#packbox_pp').hide()
	$('#packbox_ws').hide()
	$('#packbox_rt').hide()
}
function getWaiver_cb(page) {
	if (page == 'add') {
		if ($("#waiver_power").prop('checked') == true) {
			$('.waiver_upto_field').show();
		}
		if ($("#waiver_power").prop('checked') == false) {
			$('.waiver_upto_field').hide();
			$('#waiver_upto').val('')
		}
	} else if (page == 'edit') {
		if ($("#waiver_power").prop('checked') == true) {
			$('.waiver_upto_field').show();
		}
		if ($("#waiver_power").prop('checked') == false) {
			$('.waiver_upto_field').hide();
			//$('#waiver_upto').val('')
		}
	} else {
	}
}
function approve_reject_waiver(wid, type) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'Waiver/approve_reject_waiver_',
		async: true,
		type: 'post',
		data: { id: wid, type: type },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				//alert(response)
				window.location.href = window.location.href
			} else {
				//$(idd).html('');
			}
		}
	});
}
function disApprove_waiver(wid) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'waiver/disApprove_waiver_',
		async: true,
		type: 'post',
		data: { id: wid },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				window.location.href = window.location.href
			} else {
			}
		}
	});
}
function doExpire_waiver(wid) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'Waiver/doExpire_waiver_',
		async: true,
		type: 'post',
		data: { id: wid },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				//alert(response)
				window.location.href = window.location.href
			} else {
				//$(idd).html('');
			}
		}
	});
}
function approve_reject_refund(wid, type) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'Refund/approve_reject_refund_',
		async: true,
		type: 'post',
		data: { id: wid, type: type },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				window.location.href = window.location.href
			} else {
			}
		}
	});
}
function disApprove_refund(wid) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'Refund/disApprove_refund_',
		async: true,
		type: 'post',
		data: { id: wid },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				//alert(response)
				window.location.href = window.location.href
			} else {
				//$(idd).html('');
			}
		}
	});
}
function doExpire_refund(wid) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'Refund/doExpire_refund_',
		async: true,
		type: 'post',
		data: { id: wid },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				//alert(response)
				window.location.href = window.location.href
			} else {
				//$(idd).html('');
			}
		}
	});
}
function GetService(val) {
	if (val == 2 || val == 3 || val == 6 || val == 7 || val == 9 || val == 14) {
		$('.radiCourse').show();
		if (val == 7) {
			$('#amount_paid').val(0);
			$('#amount_paid_off').val(0);
			$('#amount_paid_pp').val(0);
			$('#amount_paid_rt').val(0);
			$('#amount_paid').prop('readonly', true);
			$('#amount_paid_off').prop('readonly', true);
			$('#amount_paid_pp').prop('readonly', true);
			$('#amount_paid_rt').prop('readonly', true);
			$('#use_wallet_on').prop('disabled', true);
			$('#use_wallet_off').prop('disabled', true);
			$('#use_wallet_pp').prop('disabled', true);
			$('#use_wallet_rt').prop('disabled', true);
		} else {
			$('#amount_paid').val('');
			$('#amount_paid_off').val('');
			$('#amount_paid_pp').val('');
			$('#amount_paid_rt').val('');
			$('#amount_paid').prop('readonly', false);
			$('#amount_paid_off').prop('readonly', false);
			$('#amount_paid_pp').prop('readonly', false);
			$('#amount_paid_rt').prop('readonly', false);
			$('#use_wallet_on').prop('disabled', false);
			$('#use_wallet_off').prop('disabled', false);
			$('#use_wallet_pp').prop('disabled', false);
			$('#use_wallet_rt').prop('disabled', false);
		}
	} else {
		$('.radiCourse').hide();
		$('#amount_paid').val('');
		$('#amount_paid_off').val('');
		$('#amount_paid_pp').val('');
		$('#amount_paid_rt').val('');
		$('#amount_paid').prop('readonly', false);
		$('#amount_paid_off').prop('readonly', false);
		$('#amount_paid_pp').prop('readonly', false);
		$('#amount_paid_rt').prop('readonly', false);
		$('#use_wallet_on').prop('disabled', false);
		$('#use_wallet_off').prop('disabled', false);
		$('#use_wallet_pp').prop('disabled', false);
		$('#use_wallet_rt').prop('disabled', false);
	}
}
function GetService2(val) {
	if (val == 2 || val == 3 || val == 6 || val == 7 || val == 14) {
		$('.radiCourse').show();
		if (val == 7) {
			$('#amount_paid').val(0);
			$('#amount_paid_off').val(0);
			$('#amount_paid_pp').val(0);
			$('#amount_paid_rt').val(0);
			$('#amount_paid').prop('readonly', true);
			$('#amount_paid_off').prop('readonly', true);
			$('#amount_paid_pp').prop('readonly', true);
			$('#amount_paid_rt').prop('readonly', true);
			$('#use_wallet_on').prop('disabled', true);
			$('#use_wallet_off').prop('disabled', true);
			$('#use_wallet_pp').prop('disabled', true);
			$('#use_wallet_rt').prop('disabled', true);
		} else {
			$('#amount_paid').val('');
			$('#amount_paid_off').val('');
			$('#amount_paid_pp').val('');
			$('#amount_paid_rt').val('');
			$('#amount_paid').prop('readonly', false);
			$('#amount_paid_off').prop('readonly', false);
			$('#amount_paid_pp').prop('readonly', false);
			$('#amount_paid_rt').prop('readonly', false);
			$('#use_wallet_on').prop('disabled', false);
			$('#use_wallet_off').prop('disabled', false);
			$('#use_wallet_pp').prop('disabled', false);
			$('#use_wallet_rt').prop('disabled', false);
		}
	}
	else {
		$('.radiCourse').hide();
		$('#amount_paid').val('');
		$('#amount_paid_off').val('');
		$('#amount_paid_pp').val('');
		$('#amount_paid_rt').val('');
		$('#amount_paid').prop('readonly', false);
		$('#amount_paid_off').prop('readonly', false);
		$('#amount_paid_pp').prop('readonly', false);
		$('#amount_paid_rt').prop('readonly', false);
		$('#use_wallet_on').prop('disabled', false);
		$('#use_wallet_off').prop('disabled', false);
		$('#use_wallet_pp').prop('disabled', false);
		$('#use_wallet_rt').prop('disabled', false);
	}
}
function deleteUserCountry(country_id, user_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'User/delete_User_Country_',
		async: true,
		type: 'post',
		data: { country_id: country_id, user_id: user_id },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				//alert(response)
				window.location.href = window.location.href
			} else {
				//$(idd).html('');
			}
		}
	});
}
function deleteUserBranch(center_id, user_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'User/delete_User_Branch_',
		async: true,
		type: 'post',
		data: { center_id: center_id, user_id: user_id },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				window.location.href = window.location.href
			} else {
				//$(idd).html('');
			}
		}
	});
}
function deleteUserTest(test_module_id, user_id, btnId) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'User/delete_User_Test_',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, user_id: user_id },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				//window.location.href=window.location.href
				$('#' + btnId).hide();
			} else {
				//$(idd).html('');
			}
		}
	});
}
function deleteUserPrograme(programe_id, user_id, btnId) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'User/delete_User_Programe_',
		async: true,
		type: 'post',
		data: { programe_id: programe_id, user_id: user_id },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				//window.location.href=window.location.href
				$('#' + btnId).hide();
			} else {
				//$(idd).html('');
			}
		}
	});
}
function deleteUserBatch(batch_id, user_id, btnId) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'User/delete_User_Batch_',
		async: true,
		type: 'post',
		data: { batch_id: batch_id, user_id: user_id },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				$('#' + btnId).hide();
				//window.location.href=window.location.href
			} else {
				//$(idd).html('');
			}
		}
	});
}
function deleteUserCategory(category_id, user_id, btnId) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'User/delete_User_Category_',
		async: true,
		type: 'post',
		data: { category_id: category_id, user_id: user_id },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				$('#' + btnId).hide();
				//window.location.href=window.location.href
			} else {
				//$(idd).html('');
			}
		}
	});
}
///update pack paymemt
function display_form(val) {
	$('.uspp').show();
	if (val == 'Add payment') {
		$(".manage_start_date_form").hide();
		$('.rp').hide();		
		$('.ap').show();
		$('.pf').show();
		$(".wv_table").hide();
		$(".rf_table").hide();
		$(".waiver_msg_failed").hide();
		$(".refund_msg_failed").hide();
		$(".pack_extension_form").hide();
		$(".branch_switch_form").hide();
		$(".course_switch_form").hide();
		$(".pack_onhold_form").hide();
		$(".batch_update_form").hide();
		$(".terminate_pack_form").hide();
		$(".unhold_pack_form").hide();
		$(".reactivate_pack_form").hide();
		$(".due_commitment_form").hide();
		$('#add_payment').val('');
		$('#add_payment').prop('readonly', false);
		$('.uspp').show();
	} else if (val == 'Partial Refund' || val == 'Full Refund') {
		$(".manage_start_date_form").hide();
		$('.rp').hide();
		$('.ap').hide();
		$('.pf').hide();
		$(".wv_table").hide();
		$(".waiver_msg_failed").hide();
		$(".pack_extension_form").hide();
		$(".branch_switch_form").hide();
		$(".course_switch_form").hide();
		$(".pack_onhold_form").hide();
		$(".batch_update_form").hide();
		$(".terminate_pack_form").hide();
		$(".unhold_pack_form").hide();
		$(".reactivate_pack_form").hide();
		$(".due_commitment_form").hide();
		if (val == 'Full Refund') {
		} else {
		}
		$('.uspp').hide();
		var student_id = $("#student_id").val();
		var by_user = $("#by_user").val();
		$.ajax({
			url: WOSA_ADMIN_URL + 'student/ajax_show_refund',
			type: 'post',
			data: { student_id: student_id, by_user: by_user, type: val },
			success: function (response) {
				if (response.status == 'true') {
					$(".rf_table").show();
					$('#r-amount').html(response.amount);
					$('#r-remarks').html(response.remarks);
					$('#r-approver').html(response.name);
					$('#r-wid').html(response.wid);
					$('#r-type').html(response.type);
					if (response.type == 'Full Refund') {
						$('.packCbDiv').hide();
					} else {
						$('.packCbDiv').show();
					}
				} else {
					$('.refund_msg_failed').text(response.msg)
					$('.refund_msg_failed').show()
					$(".rf_table").hide();
					$('#r-amount').html('');
					$('#r-remarks').html('');
					$('#r-approver').html('');
					$('#r-wid').html('');
					$('#r-type').html('');
				}
			}
		});
	} else if (val == 'Waiver') {
		$(".manage_start_date_form").hide();
		$('.rp').hide();
		$('.ap').hide();
		$('.pf').hide();
		$(".wv_table").hide();
		$(".rf_table").hide();
		$(".refund_msg_failed").hide();
		$(".pack_extension_form").hide();
		$(".branch_switch_form").hide();
		$(".course_switch_form").hide();
		$(".pack_onhold_form").hide();
		$(".batch_update_form").hide();
		$(".terminate_pack_form").hide();
		$(".unhold_pack_form").hide();
		$(".reactivate_pack_form").hide();
		$(".due_commitment_form").hide();
		var student_id = $("#student_id").val();
		var by_user = $("#by_user").val();
		$.ajax({
			url: WOSA_ADMIN_URL + 'student/ajax_show_waiver',
			type: 'post',
			data: { student_id: student_id, by_user: by_user },
			success: function (response) {
				if (response.status == 'true') {
					$(".wv_table").show();
					$('#wamount').html(response.amount);
					$('#wremarks').html(response.remarks);
					$('#wapprover').html(response.name);
					$('#wid').html(response.wid);
				} else {
					$('.waiver_msg_failed').text(response.msg)
					$('.waiver_msg_failed').show()
					$(".wv_table").hide();
					$('#wamount').html('');
					$('#wremarks').html('');
					$('#wapprover').html('');
					$('#wid').html('');
				}
			}
		});
	} else if (val == 'Adjustment-PE') {
		$(".manage_start_date_form").hide();
		$('.ap').hide();
		$('.rp').hide();
		$('.pf').hide();
		$(".wv_table").hide();
		$(".rf_table").hide();
		$(".refund_msg_failed").hide();
		$(".waiver_msg_failed").hide();
		$(".branch_switch_form").hide();
		$(".pack_extension_form").show();
		$(".course_switch_form").hide();
		$(".pack_onhold_form").hide();
		$(".batch_update_form").hide();
		$(".terminate_pack_form").hide();
		$(".unhold_pack_form").hide();
		$(".reactivate_pack_form").hide();
		$(".due_commitment_form").hide();
	} else if (val == 'Adjustment-BS') {
		$(".manage_start_date_form").hide();
		$(".branch_switch_form").show();
		$('.ap').hide();
		$('.rp').hide();
		$('.pf').hide();
		$(".refund_msg_failed").hide();
		$(".wv_table").hide();
		$(".rf_table").hide();
		$(".waiver_msg_failed").hide();
		$(".pack_extension_form").hide();
		$(".course_switch_form").hide();
		$(".pack_onhold_form").hide();
		$(".batch_update_form").hide();
		$(".terminate_pack_form").hide();
		$(".unhold_pack_form").hide();
		$(".reactivate_pack_form").hide();
		$(".due_commitment_form").hide();
	} else if (val == 'Adjustment-CS') {
		$(".manage_start_date_form").hide();
		$(".course_switch_form").show();
		$(".branch_switch_form").hide();
		$('.ap').hide();
		$('.rp').hide();
		$('.pf').hide();
		$(".refund_msg_failed").hide();
		$(".wv_table").hide();
		$(".rf_table").hide();
		$(".waiver_msg_failed").hide();
		$(".pack_extension_form").hide();
		$(".pack_onhold_form").hide();
		$(".batch_update_form").hide();
		$(".terminate_pack_form").hide();
		$(".unhold_pack_form").hide();
		$(".reactivate_pack_form").hide();
		$(".due_commitment_form").hide();
	} else if (val == 'Pack on Hold') {
		$(".manage_start_date_form").hide();
		$(".pack_onhold_form").show()
		$(".course_switch_form").hide();
		$(".branch_switch_form").hide();
		$('.ap').hide();
		$('.rp').hide();
		$('.pf').hide();
		$(".refund_msg_failed").hide();
		$(".wv_table").hide();
		$(".rf_table").hide();
		$(".waiver_msg_failed").hide();
		$(".pack_extension_form").hide();
		$(".batch_update_form").hide();
		$(".terminate_pack_form").hide();
		$(".unhold_pack_form").hide();
		$(".reactivate_pack_form").hide();
		$(".due_commitment_form").hide();
	} else if (val == 'Batch Update') {
		$(".manage_start_date_form").hide();
		$(".batch_update_form").show();
		$(".pack_onhold_form").hide()
		$(".course_switch_form").hide();
		$(".branch_switch_form").hide();
		$('.ap').hide();
		$('.rp').hide();
		$('.pf').hide();
		$(".refund_msg_failed").hide();
		$(".wv_table").hide();
		$(".rf_table").hide();
		$(".waiver_msg_failed").hide();
		$(".pack_extension_form").hide();
		$(".terminate_pack_form").hide();
		$(".unhold_pack_form").hide();
		$(".reactivate_pack_form").hide();
		$(".due_commitment_form").hide();
	} else if (val == 'Terminate-Pack') {
		$(".manage_start_date_form").hide();
		$(".terminate_pack_form").show();
		$(".batch_update_form").hide();
		$(".pack_onhold_form").hide()
		$(".course_switch_form").hide();
		$(".branch_switch_form").hide();
		$('.ap').hide();
		$('.rp').hide();
		$('.pf').hide();
		$(".refund_msg_failed").hide();
		$(".wv_table").hide();
		$(".rf_table").hide();
		$(".waiver_msg_failed").hide();
		$(".pack_extension_form").hide();
		$(".unhold_pack_form").hide();
		$(".reactivate_pack_form").hide();
		$(".due_commitment_form").hide();
	} else if (val == 'Unhold-Pack') {
		$(".manage_start_date_form").hide();
		$(".terminate_pack_form").hide();
		$(".batch_update_form").hide();
		$(".pack_onhold_form").hide()
		$(".course_switch_form").hide();
		$(".branch_switch_form").hide();
		$('.ap').hide();
		$('.rp').hide();
		$('.pf').hide();
		$(".refund_msg_failed").hide();
		$(".wv_table").hide();
		$(".rf_table").hide();
		$(".waiver_msg_failed").hide();
		$(".pack_extension_form").hide();
		$(".unhold_pack_form").show();
		$(".reactivate_pack_form").hide();
		$(".due_commitment_form").hide();
		$('.uspp').prop('disabled', false);
	} else if (val == 'Reactivate-Pack') {
		$(".manage_start_date_form").hide();
		$(".terminate_pack_form").hide();
		$(".batch_update_form").hide();
		$(".pack_onhold_form").hide()
		$(".course_switch_form").hide();
		$(".branch_switch_form").hide();
		$('.ap').hide();
		$('.rp').hide();
		$('.pf').hide();
		$(".refund_msg_failed").hide();
		$(".wv_table").hide();
		$(".rf_table").hide();
		$(".waiver_msg_failed").hide();
		$(".pack_extension_form").hide();
		$(".unhold_pack_form").hide();
		$(".reactivate_pack_form").show();
		$(".due_commitment_form").hide();
		$('.uspp').prop('disabled', false);
	} else if (val == 'Change DCD') {
		$(".manage_start_date_form").hide();
		$(".due_commitment_form").show();
		$('.ap').hide();
		$('.rp').hide();
		$('.pf').hide();
		$(".wv_table").hide();
		$(".rf_table").hide();
		$(".refund_msg_failed").hide();
		$(".waiver_msg_failed").hide();
		$(".pack_extension_form").hide();
		$(".branch_switch_form").hide();
		$(".course_switch_form").hide();
		$(".pack_onhold_form").hide();
		$(".batch_update_form").hide();
		$(".terminate_pack_form").hide();
		$(".unhold_pack_form").hide();
		$(".reactivate_pack_form").hide();
		$('.uspp').prop('disabled', false);
	} else if (val == 'Reactivate-Pack-Against-PR') {
		$(".manage_start_date_form").hide();		
		$('.uspp').prop('disabled', false);
	}
	else if (val == 'Manage start date') {	
		$(".manage_start_date_form").show();
		$(".due_commitment_form").hide();
		$('.ap').hide();
		$('.rp').hide();
		$('.pf').hide();
		$(".wv_table").hide();
		$(".rf_table").hide();
		$(".refund_msg_failed").hide();
		$(".waiver_msg_failed").hide();
		$(".pack_extension_form").hide();
		$(".branch_switch_form").hide();
		$(".course_switch_form").hide();
		$(".pack_onhold_form").hide();
		$(".batch_update_form").hide();
		$(".terminate_pack_form").hide();
		$(".unhold_pack_form").hide();
		$(".reactivate_pack_form").hide();
		$('.uspp').prop('disabled', false);
	}
	
	else {
		$('.ap').hide();
		$('.rp').hide();
		$('.pf').hide();
		$(".wv_table").hide();
		$(".rf_table").hide();
		$(".refund_msg_failed").hide();
		$(".waiver_msg_failed").hide();
		$(".pack_extension_form").hide();
		$(".branch_switch_form").hide();
		$(".course_switch_form").hide();
		$(".pack_onhold_form").hide();
		$(".batch_update_form").hide();
		$(".terminate_pack_form").hide();
		$(".unhold_pack_form").hide();
		$(".reactivate_pack_form").hide();
		$(".due_commitment_form").hide();
		$('.uspp').prop('disabled', true);
	}
}
///update pack paymemt
function display_exam_form(val) {
	if (val == 'Pre-Booking') {
		$(".pre_booking_form").show();
		$(".post_booking_form").hide();
		$(".rs_booking_form").hide();
		$(".add_result_form").hide();
		$(".reEvaluation_form").hide();
		$(".cancellation_form").hide();
	} else if (val == 'Post-Booking') {
		$(".pre_booking_form").hide();
		$(".post_booking_form").show();
		$(".rs_booking_form").hide();
		$(".add_result_form").hide();
		$(".reEvaluation_form").hide();
		$(".cancellation_form").hide();
	} else if (val == 'Reschedule') {
		$(".pre_booking_form").hide();
		$(".post_booking_form").hide();
		$(".rs_booking_form").show();
		$(".add_result_form").hide();
		$(".reEvaluation_form").hide();
		$(".cancellation_form").hide();
	} else if (val == 'Result') {
		$(".add_result_form").show();
		$(".pre_booking_form").hide();
		$(".post_booking_form").hide();
		$(".rs_booking_form").hide();
		$(".reEvaluation_form").hide();
		$(".cancellation_form").hide();
	} else if (val == 'Re-evaluation') {
		$(".add_result_form").hide();
		$(".pre_booking_form").hide();
		$(".post_booking_form").hide();
		$(".rs_booking_form").hide();
		$(".reEvaluation_form").show();
		$(".cancellation_form").hide();
	} else if (val == 'Full Refund') {
		$(".add_result_form").hide();
		$(".pre_booking_form").hide();
		$(".post_booking_form").hide();
		$(".rs_booking_form").hide();
		$(".reEvaluation_form").hide();
		$(".cancellation_form").hide();
		var student_id = $("#student_id").val();
		var by_user = $("#by_user").val();
		$.ajax({
			url: WOSA_ADMIN_URL + 'student/ajax_show_refund',
			type: 'post',
			data: { student_id: student_id, by_user: by_user, type: val },
			success: function (response) {
				if (response.status == 'true') {
					$(".rf_table").show();
					$('#r-amount').html(response.amount);
					$('#r-remarks').html(response.remarks);
					$('#r-approver').html(response.name);
					$('#r-wid').html(response.wid);
					$('#r-type').html(response.type);
					if (response.type == 'Full Refund') {
						$('.packCbDiv').hide();
					} else {
						$('.packCbDiv').show();
					}
				} else {
					$('.refund_msg_failed').text(response.msg)
					$('.refund_msg_failed').show()
					$(".rf_table").hide();
					$('#r-amount').html('');
					$('#r-remarks').html('');
					$('#r-approver').html('');
					$('#r-wid').html('');
					$('#r-type').html('');
				}
			}
		});
	} else if (val == 'Cancel-Booking') {
		$(".cancellation_form").show();
		$(".add_result_form").hide();
		$(".pre_booking_form").hide();
		$(".post_booking_form").hide();
		$(".rs_booking_form").hide();
		$(".reEvaluation_form").hide();
	} else {
		$(".add_result_form").hide();
		$(".pre_booking_form").hide();
		$(".post_booking_form").hide();
		$(".rs_booking_form").hide();
		$(".reEvaluation_form").hide();
		$(".cancellation_form").hide();
		$('.uspp').prop('disabled', true);
	}
}
function remburse_waiver() {
	var wid = $("#wid").html();
	var waiver = $("#wamount").html();
	var waiver_by = $("#wapprover").html();
	var student_package_id = $("#student_package_id").val();
	var student_id = $("#student_id").val();
	var by_user = $("#by_user").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'student/remburse_waiver_',
		type: 'post',
		data: { wid: wid, waiver: waiver, waiver_by: waiver_by, student_package_id: student_package_id, student_id: student_id, by_user: by_user },
		success: function (response) {
			if (response.status == 'true') {
				Swal.fire({
					title: 'Waiver Reimbursed',
					text: response.msg,
					icon: 'success',					
				  }).then((result) => {
					if (result.isConfirmed) {					
						window.location.href = window.location.href;
						$('#waiver_btn').hide();
					}
				  });
				
			} else {
				// $('.waiver_msg_failed').text(response.msg)
				// $('#waiver_btn').show();
				Swal.fire({
					title: 'Waiver Reimbursement',
					text: response.msg,
					icon: 'success',					
				  }).then((result) => {
					if (result.isConfirmed) {					
						window.location.href = window.location.href;
						$('#waiver_btn').show();
					}
				  });
			}
		}
	});
}
function remburse_refund(pack_cb) {
	var wid = $("#r-wid").html();
	var refund = $("#r-amount").html();
	var refund_by = $("#r-approver").html();
	var student_package_id = $("#student_package_id").val();
	var student_id = $("#student_id").val();
	var by_user = $("#by_user").val();
	var type = $("#r-type").html();
	if ($("#packStatusOnRefund").prop('checked') == true) {
		var pack_status_pr = 1;
	} else {
		var pack_status_pr = 0;
	}
	if(pack_status_pr ==1)
	{
		var title_status="will remains ACTIVE.";
	}
	else {
		var title_status="will be CLOSED.";
	}
	var con = confirm("Warning: Once partial refund is successful then the pack status "+title_status+" Do you want to continue?");
	if (con == false) {		
		return false;
	} else {		
	if (type == 'Full Refund') {
		var pack_status_pr = 0;
	}
	//alert(pack_cb)
	$.ajax({
		url: WOSA_ADMIN_URL + 'student/remburse_refund_',
		type: 'post',
		data: { wid: wid, refund: refund, refund_by: refund_by, student_package_id: student_package_id, student_id: student_id, by_user: by_user, pack_status_pr: pack_status_pr, type: type, pack_cb: pack_cb },
		success: function (response) {
			if (response.status == 'true') {
				$('.refund_msg_success').text(response.msg)
				$('#refund_btn').hide();
				window.location.href = window.location.href
			} else {
				$('.refund_msg_failed').text(response.msg)
				$('#refund_btn').show();
			}
		}
	});
	return true;
	}
}
///update pack payment
function display_time_slot_rt(id) {
	var html = '';
	$.ajax({
		url: WOSA_ADMIN_URL + 'Realty_test/ajax_get_time_slot',
		async: true,
		type: 'post',
		data: { id: id },
		dataType: 'json',
		success: function (data) {
			html = '<label for="time_slots_rt" class="control-label"><span class="text-danger">*</span>Choose Time slot:</label><br/>';
			if (data.time_slot1) {
				html += '<input type="radio" class="radio-btn-ui" name="time_slots_rt" id="time_slot_rt1" value="' + data.time_slot1 + '" /> <label for="time_slot_rt1">' + data.time_slot1 + '</label> ';
			}
			if (data.time_slot2) {
				html += '<input type="radio" class="radio-btn-ui" name="time_slots_rt" id="time_slott_rt2" value="' + data.time_slot2 + '" /> <label for="time_slott_rt2">' + data.time_slot2 + '</label> ';
			}
			if (data.time_slot3) {
				html += '<input type="radio" class="radio-btn-ui" name="time_slots_rt" id="time_slott_rt3" value="' + data.time_slot3 + '" /> <label for="time_slott_rt3">' + data.time_slot3 + '</label> ';
			}
			html += '<span class="text-danger time_slots_rt_err">'+FORM_ERROR_TIME_SLOTS_RT+'</span>';
			$('.time_slots_div_rt').html(html);
			$('#amount_paid_rt').val(data.amount);
		}
	});
}
function display_branch_rt(id) {
	var html = '';
	$.ajax({
		url: WOSA_ADMIN_URL + 'Realty_test/ajax_get_branch_rt',
		async: true,
		type: 'post',
		data: { id: id },
		dataType: 'json',
		success: function (data) {
			if (data.length > 0) {
				html = '';
				$('.branch_div_rt').show();
				html = '<option value="">Select Branch</option>';
				for (i = 0; i < data.length; i++) {
					html += '<option value=' + data[i]['center_id'] + ' >' + data[i]['center_name'] + ' </option>';
				}
				html += '</select>';
				$('#center_id_rt').html(html);
				$('#center_id_rt').selectpicker('refresh');
			} else {
				html = '';
				$('#center_id_rt').html(html);
				$('#center_id_rt').selectpicker('refresh');
				$('.branch_div_rt').hide();
			}
		}
	});
}
function GetBranchAddress(center_id) {
	//alert(center_id)
	$.ajax({
		url: WOSA_ADMIN_URL + 'Center_location/ajax_GetBranchAddress',
		async: true,
		type: 'post',
		data: { center_id: center_id },
		dataType: 'json',
		success: function (data) {
			$('#venue').text(data.address_line_1);
		}
	});
}
function transfer(id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'student/transfer',
		type: 'post',
		data: { id: id },
		success: function (response) {
			if (response.status == 'true') {
				$('.msg').html(response.msg);
				window.location.href = window.location.href
			} else {
				$('.msg').html(response.msg);
			}
		}
	});
}
function mark_rf(id, val, table, pk) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'gallery/mark_fresh_or_revisit_',
		type: 'post',
		data: { id: id, fresh: val, table: table, pk: pk },
		success: function (response) {
			if (response.status == 'true') {
				$('.msg').html(response.msg);
				window.location.href = window.location.href
			} else {
				$('.msg').html(response.msg);
			}
		}
	});
}
function getRTTest(reality_test_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'realty_test/ajax_getRTTest',
		type: 'post',
		data: { reality_test_id: reality_test_id },
		success: function (response) {
			var obj = JSON.parse(response);
			var test_module_id = obj.test_module_id
			if (response.status == 'false') {
				$('.msg').html(response.msg);
				$('#rt_test').val('');
			} else {
				//alert(response)
				$('#rt_test').val(test_module_id);
			}
		}
	});
}
function getPackageSchedule(batch_id){
	var package_id = $("#package_id_off").val();
	//alert(batch_id);alert(package_id);
	$.ajax({
		url: WOSA_ADMIN_URL + 'package_master/ajax_getPackageSchedule',
		async: true,
		type: 'post',
		data: { package_id: package_id, batch_id: batch_id },
		dataType: 'json',
		success: function (response){
			if(response.status == 'false') {
				$('.packScheduleInfo_off').html(response.msg);
			}else{
				$('.packScheduleInfo_off').html(response.msg);
			}
		}
	});
}
function getPackageSchedule_online(batch_id){
	var package_id = $("#package_id").val();
	//alert(batch_id);alert(package_id);
	$.ajax({
		url: WOSA_ADMIN_URL + 'package_master/ajax_getPackageSchedule',
		async: true,
		type: 'post',
		data: { package_id: package_id, batch_id: batch_id },
		dataType: 'json',
		success: function (response){
			if(response.status == 'false') {
				$('.packScheduleInfo').html(response.msg);
			}else{
				$('.packScheduleInfo').html(response.msg);
			}
		}
	});
}
function hidepackinfo_()
{
	$('.packInfo').empty();
}
function getOnlineOfflinePackInfo(amount=null) {
	var type = $('input[name=pack_cb]:checked').val();
	var totalamt = $('#estimatetax').val();
	
	if (type == 'offline' || type == 'online'){
		var package_id = $('#package_id').find(":selected").val();
		var amntpaying = $('#amount_paid').val();
		var waiveramt = parseFloat($('#waiver').val());
		var discounttype = $('#discount_type').find(":selected").val();
		$.ajax({
			url: WOSA_ADMIN_URL + 'package_master/ajax_getOnlineOfflinePackInfo',
			async: true,
			type: 'post',
			data: { paidamount:amount,package_id: package_id,waiveramt:waiveramt,discounttype:discounttype },
			dataType: 'json',
			success: function (response) {
				if (response.status == 'false') {
					$('.packInfo').html(response.msg);
				} else {
					// var payableamount = 0;
					if(totalamt != response.amountpayable && amntpaying == '')
					{
						payableamount = parseFloat(response.amountpayable).toFixed(2);
						//$('#amount_payable_pp').val(parseFloat(response.amountpayable).toFixed(2));
					}
					else if(amntpaying == ''){
						payableamount = parseFloat(totalamt).toFixed(2);
					}
					$('#amount_payable').val(payableamount);
					$('#packPrice').val(response.packamount);
					$('.packInfo').html(response.packinfo);
				}
			}
		});
	} else if (type == 'pp') {
		var package_id = $('#package_id_pp').find(":selected").val();
		var amntpaying = $('#amount_paid_pp').val();
		var waiveramt = parseFloat($('#waiver_pp').val());
		var discounttype = $('#discount_type_pp').find(":selected").val();
		$.ajax({
			url: WOSA_ADMIN_URL + 'package_master/ajax_getPracticePackInfo',
			async: true,
			type: 'post',
			data: { paidamount:amount,package_id: package_id,waiveramt:waiveramt,discounttype:discounttype },
			dataType: 'json',
			success: function (response) {
				if (response.status == 'false') {
					$('.packInfo').html(response.msg);
				} else {
					// var payableamount = 0;
					if(totalamt != response.amountpayable && amntpaying == '')
					{
						payableamount = parseFloat(response.amountpayable).toFixed(2);
						//$('#amount_payable_pp').val(parseFloat(response.amountpayable).toFixed(2));
					}
					else if(amntpaying == ''){
						payableamount = parseFloat(totalamt).toFixed(2);
					}
					$('#amount_payable_pp').val(payableamount);
					$('.packInfo').html(response.packinfo);
					$('#packPrice').val(response.packamount);
				}
			}
		});
	} else {
	}
}

function calculatepayableamnt(type=null,payingamt=null)
{
	var id='';
	if(type == 'onlinepack')
	{
		id ='amount_payable';
	}
	else{
		id ='amount_payable_pp';
	}
	var packpr = parseFloat($('#packPrice').val());
	let waiveramt = parseFloat($('#waiver').val());	
	if(discounttype == 'Waiver')
	{
		payingamt = packpr - waiveramt;
	}
	var tobepaid = parseFloat($('#estimatetax').val());
	
	if(payingamt != ''){
			var cgst = $('#cgsttax').val();
			var sgst = $('#sgsttax').val();
			var cgst_tax = parseFloat((payingamt * cgst)/100);
			var sgst_tax = parseFloat((payingamt * sgst)/100);
			var totalprice = parseFloat(payingamt) + parseFloat(cgst_tax) + parseFloat(sgst_tax) ;
			var discounttype = $('#discount_type').find(":selected").val();		
			if(totalprice > tobepaid)
			{
				$('#'+id).val(parseFloat(tobepaid).toFixed(2));
				$('#myTable #amountpaid').html(currency+' '+parseFloat(tobepaid).toFixed(2));
			}
			else{
				// console.log({tobepaid});
				$('#'+id).val(parseFloat(totalprice).toFixed(2));
				// $('#amountpaid').html(parseFloat(totalprice).toFixed(2));
				$('#myTable #amountpaid').html(currency+''+parseFloat(totalprice).toFixed(2));
			}
			// if(tobepaid < totalprice)
			// {
			// 	// payablemt_ = totalprice;
			// 	console.log({tobepaid});
			// 	$('#'+id).val(tobepaid);
			// }
			// else{
			// 	console.log({totalprice});
			// 	$('#'+id).val(totalprice);
			// }
			//console.log({payablemt_});
			// $('#'+id).val(payablemt_);
		}
		else{
			$('#'+id).val(tobepaid);
		}	
}
function getPackBatch(package_id, pack_type) {
	if (pack_type == 'package_id') {
		id = 'batch_id';
		id_err = 'batch_id_err';
		ddClass = 'packBatch';
	} else if (pack_type == 'package_id_off') {
		id = 'batch_id_off';
		id_err = 'batch_id_off_err';
		ddClass = 'packBatch_off';
	} else {
		id = '';
		id_err = '';
		ddClass = '';
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'package_master/ajax_getPackBatch',
		async: true,
		type: 'post',
		data: { package_id: package_id },
		dataType: 'json',
		success: function (response) {
			if (response.length > 0) {
				html = '';
				if (pack_type == 'package_id_off') {
					html = '<select name=' + id + ' id=' + id + ' class="form-control selectpicker selectpicker-ui-100" data-live-search="true" onchange="getPackageSchedule(this.value);"><option value="">Select Batch</option>';
				}else{
					html = '<select name=' + id + ' id=' + id + ' class="form-control selectpicker selectpicker-ui-100" data-live-search="true" onchange="getPackageSchedule_online(this.value);"><option value="">Select Batch</option>';
				}
				for (i = 0; i < response.length; i++) {
					html += '<option value=' + response[i]['batch_id'] + ' >' + response[i]['batch_name'] + '</option>';
				}
				html += '</select><span class="text-danger ' + id_err + '"></span>';
				$('.' + ddClass).html(html);
				$('#' + id).selectpicker('refresh');
			} else {
				$('.' + ddClass).html('');
			}
		}
	});
}
function getPackPrice(package_id) {
	
	var type = $('input[name=pack_cb]:checked').val();
	$('#packPrice').val('');
	
	
	if (type == 'offline' || type == 'online') {
		$('#amount_paid').val('');
		$.ajax({
			url: WOSA_ADMIN_URL + 'package_master/ajax_getPackPrice_new',
			type: 'post',
			data: { package_id: package_id },
			success: function (response) {
				var obj = JSON.parse(response);
				var discounted_amount = obj.packprice.discounted_amount;
				let cgst_tax_amt = 0;
				let sgst_tax_amt = 0;
				// alert(obj.cgst.tax_per);
				if(obj.cgst == null)
				{
					alert('CGST Tax is not available. Please add CGST if want to include the CGST');
				}
				else{cgst_tax_amt = parseFloat(obj.cgst.tax_per).toFixed(2);}
				if(obj.sgst == null)
				{
					alert('SGST Tax is not available. Please add SGST if want to include the SGST');
				}
				else{sgst_tax_amt = parseFloat(obj.sgst.tax_per).toFixed(2);}				
				var cgst_tax = (discounted_amount * cgst_tax_amt)/100;
				var sgst_tax = (discounted_amount * sgst_tax_amt)/100;
				var totalprice = parseFloat(discounted_amount) + parseFloat(cgst_tax) + parseFloat(sgst_tax) ;
				if (response.status == 'false') {
					$('.msg').html(response.msg);
					$('#packPrice').val('');
				} else {
					$('#amount_payable_pp').val(parseFloat(totalprice).toFixed(2));
					$('#estimatetax').val(parseFloat(totalprice).toFixed(2));
					$('#packPrice').val(discounted_amount);
				}
			}
		});
	} else if (type == 'pp') {
		$('#amount_paid_pp').val('');
		$.ajax({
			url: WOSA_ADMIN_URL + 'practice_packages/ajax_getPackPrice_new',
			type: 'post',
			data: { package_id: package_id },
			success: function (response) {
				var obj = JSON.parse(response);
				var discounted_amount = obj.packprice.discounted_amount;
				let cgst_tax_amt = 0;
				let sgst_tax_amt = 0;
				// alert(obj.cgst.tax_per);
				if(obj.cgst == null)
				{
					alert('CGST Tax is not available. Please add CGST if want to include the CGST');
				}
				else{cgst_tax_amt = obj.cgst.tax_per;}
				if(obj.sgst == null)
				{
					alert('SGST Tax is not available. Please add SGST if want to include the SGST');
				}
				else{sgst_tax_amt = obj.sgst.tax_per;}
				var cgst_tax = (discounted_amount * cgst_tax_amt)/100;
				var sgst_tax = (discounted_amount * sgst_tax_amt)/100;
				//var totalprice = discounted_amount + cgst_tax + sgst_tax ;
				var totalprice = parseFloat(discounted_amount) + parseFloat(cgst_tax) + parseFloat(sgst_tax) ;
				if (response.status == 'false') {
					$('.msg').html(response.msg);
					$('#packPrice').val('');
				} else {
					$('#amount_payable_pp').val(parseFloat(totalprice).toFixed(2));
					$('#estimatetax').val(parseFloat(totalprice).toFixed(2));
					$('#packPrice').val(discounted_amount);
				}
			}
		});
	} else if (type == 'rt') {
		$.ajax({
			url: WOSA_ADMIN_URL + 'realty_test/ajax_getPackPrice',
			type: 'post',
			data: { reality_test_id: package_id },
			success: function (response) {
				var obj = JSON.parse(response);
				var amount = obj.amount
				if (response.status == 'false') {
					$('.msg').html(response.msg);
					$('#packPrice').val('');
				} else {
					//alert(response)
					$('#packPrice').val(amount);
				}
			}
		});
	} else {
		$('#packPrice').val('');
	}
}
function reactivate_rt_booking_ajax(booking_id, student_id, student_package_id, amount_paid, amount_paid_by_wallet) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'realty_test/reactivate_rt_booking_ajax',
		type: 'post',
		data: { booking_id: booking_id, student_id: student_id, student_package_id: student_package_id, amount_paid: amount_paid, amount_paid_by_wallet: amount_paid_by_wallet },
		success: function (response) {
			$('.cancelBookingMsg_rt').text(response.msg);
			window.location.href = window.location.href
		}
	});
}
function display_trainerCourse(role_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'role/ajax_getRoleName',
		type: 'post',
		data: { role_id: role_id },
		success: function (response) {
			if (response.roleName.indexOf(TRAINER) > -1) {
				$('.testPgmBatchDiv').show();
			} else {
				$('.testPgmBatchDiv').hide();
			}
		}
	});
}
function checkRoleNameValidity(roleName) {
	if (roleName == 'Super Admin') {
		document.getElementById('name').value = '';
		$('.role_name_err').text('Please enter valid name! Super Admin not allowed');
		$('#name').focus();
	} else {
		$('.role_name_err').text('');
		$('#name').focus();
	}
}
function displayBranch(page) {
	if (page == 'add') {
		if ($("#is_offline").prop('checked') == true) {
			$('.br').show();
		}
		if ($("#is_offline").prop('checked') == false) {
			$('.br').hide();
		}
	} else if (page == 'edit') {
		if ($("#is_offline").prop('checked') == true) {
			$('.br').show();
		}
		if ($("#is_offline").prop('checked') == false) {
			$('.br').hide();
		}
	} else {
	}
}
function setRealityTestLocationTypeForm(location_type) {
	if (location_type == 'Outhouse') {
		$('.branchSeatsField').hide();
		$('.venueSeatsField').show();
		$(".Outhouse_unlimitedSeats").prop("disabled",false);
		$(".Branch_unlimitedSeats").prop("disabled",true);
	} else if (location_type == 'Branch') {
		$('.branchSeatsField').show();
		$('.venueSeatsField').hide();
		$(".Branch_unlimitedSeats").prop("disabled",false);
		$(".Outhouse_unlimitedSeats").prop("disabled",true);
	} else {
		$('.branchSeatsField').hide();
		$('.venueSeatsField').hide();
		$(".Branch_unlimitedSeats").prop("disabled",true);
		$(".Outhouse_unlimitedSeats").prop("disabled",true);
	}
}
function displayTimeSlotFields(count) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'time_slot_master/ajax_loadTimeSlot',
		async: true,
		type: 'post',
		data: { count: count },
		//dataType: 'json',
		success: function (data) {
			$('.tsBox').html(data);
			for (i = 0; i <= count; i++) {
				var time_slot = '#' + 'time_slot' + i;
				$(time_slot).selectpicker('refresh');
			}
		}
	});
}
//for reference dd in waiver add form
function reflectRefFields(waiver_type) {
	//alert(waiver_type)
	if (waiver_type == 'General') {
		$('.refBox').hide()
	} else if (waiver_type == 'Special') {
		$('.refBox').show()
	} else if (waiver_type == 'Pack Adjustment') {
		$('.refBox').hide()
	} else {
		$('.refBox').hide()
	}
}
function refresh_page() {
	window.location.href = window.location.href
}
function validateDocExpiryField(docTypeid){
	//alert(docTypeid)
	$.ajax({
		url: WOSA_ADMIN_URL + 'student/ajax_validateDocExpiryField',
		async: true,
		type: 'post',
		data: { docTypeid: docTypeid },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true' && response.msg=='Y') {
				$('.docField').show();
			} else {
				$('.docField').hide();
			}
		}
	});
}
//submit doc for add doc starts
$(document).ready(function () {
	$('#submit_doc').submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: WOSA_ADMIN_URL + 'student/ajax_do_upload_doc_image',
			type: "post",
			data: new FormData(this),
			processData: false,
			contentType: false,
			cache: false,
			async: false,
			before: function () {
				$('#doc_image_msg').text('Processing..please wait!');
			},
			success: function (data) {
				document.getElementById("image_id").value = data;
				var img_val = document.getElementById("image_id").value;
				if (img_val != '') {
					document.getElementById("submit_doc").reset();
					$('#doc_image_msg').html(FILE_SUCCESS_MSG);					
				} else {
					document.getElementById("submit_doc").reset();
					$('#doc_image_msg').html(FILE_FAILED_MSG);
				}
			}
		});
	});
});
//submit doc for doc ends
//submit menu icon
$(document).ready(function () {
	$('#submit_icon').submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: WOSA_ADMIN_URL + 'role/ajax_do_upload_menu_icon_image',
			type: "post",
			data: new FormData(this),
			processData: false,
			contentType: false,
			cache: false,
			async: false,
			before: function () {
				$('#menu_icon_msg').text('Processing..please wait!');
			},
			success: function (data) {
				document.getElementById("image_id_icon").value = data;
				var img_val = document.getElementById("image_id_icon").value;
				if(img_val != ''){
					document.getElementById("submit_icon").reset();
					$('#menu_icon_msg').html(FILE_SUCCESS_MSG);
				}else{
					document.getElementById("submit_icon").reset();
					$('#menu_icon_msg').html(FILE_FAILED_MSG);
				}
			}
		});
	});
});
//submit menu icon ends
//submit doc for submit_withdrawl starts
$(document).ready(function () {
	$('#submit_withdrawl').submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: WOSA_ADMIN_URL + 'student/ajax_do_upload_withdrawl_image',
			type: "post",
			data: new FormData(this),
			processData: false,
			contentType: false,
			cache: false,
			async: false,
			before: function () {
				$('#withdrawl_image_msg').text('Processing..please wait!');
			},
			success: function (data) {
				document.getElementById("withdrawl_image_id").value = data;
				var img_val = document.getElementById("withdrawl_image_id").value;
				if (img_val != '') {
					document.getElementById("submit_withdrawl").reset();
					$('#withdrawl_image_msg').html(FILE_SUCCESS_MSG);
				} else {
					document.getElementById("submit_withdrawl").reset();
					$('#withdrawl_image_msg').html(FILE_FAILED_MSG);
				}
			}
		});
	});
});
//submit doc for submit_withdrawl ends
function sendWithdrawl() {
	var flag=1;
	var withdrawl_image_id = document.getElementById("withdrawl_image_id").value;
	var withdrawl_method = document.getElementById("withdrawl_method").value;
	var withdrawl_tran_id = document.getElementById("withdrawl_tran_id").value;
	var withdrawl_amount = document.getElementById("withdrawl_amount").value;
	var student_withdrawl_remarks = document.getElementById("student_withdrawl_remarks").value;
	var student_id = document.getElementById("student_id").value;
	if (withdrawl_amount<=0) {
		$('.withdrawl_amount_err').text('Please enter withdrawal amount');
		//$('#withdrawl_amount').focus();
		$('#withdrawl_amount').val('');
		flag=0;	
	} else {$('.withdrawl_amount_err').text('');}
	if(withdrawl_method =="")
	{
		$('.withdrawl_method_err').text('Please select payment mode');
		flag=0;
	} else{ $('.withdrawl_method_err').text('');} 
	if(student_withdrawl_remarks =="")
	{
		$('.student_withdrawl_remarks_err').text('Please enter remarks');
		flag=0;
	} else{ $('.student_withdrawl_remarks_err').text('');} 

	if(flag == 0)
	{
		return false;
	} 
	$.ajax({
		url: WOSA_ADMIN_URL + 'student/add_withdrawl_',
		async: true,
		type: 'post',
		data: { student_id: student_id, withdrawl_method: withdrawl_method, withdrawl_image_id: withdrawl_image_id, withdrawl_amount: withdrawl_amount, withdrawl_tran_id: withdrawl_tran_id, student_withdrawl_remarks: student_withdrawl_remarks },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.msg_withdrawl').html(response.msg);
			} else {
				$('.msg_withdrawl').html(response.msg);
			}
		}
	});
}
function getWaiverHistory(student_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'student/getWaiverHistory_',
		async: true,
		type: 'post',
		data: { student_id: student_id },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.waiver_history').html(response.msg);
			} else {
				$('.waiver_history').html(response.msg);
			}
		}
	});
}
function senddatatomodal_refund(wid, sid, type) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'Refund/ajax_displayRefundHistory',
		async: true,
		type: 'post',
		data: { student_id: sid },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.msg').html(response.data);
			} else {
				$('.msg').html(response.data);
			}
		}
	});
	if (type == 'A') {
		$('.makeBtn').html('<a href="javascript:void(0);" class="btn btn-success btn-xs" data-toggle="tooltip" title="Approve" onclick=approve_reject_refund(' + wid + ',"A")>Approve</span></a>');
	} else {
		$('.makeBtn').html('<a href="javascript:void(0);" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Reject" onclick=approve_reject_refund(' + wid + ',"R")>Reject</span> </a>');
	}
}
function getRefundHistory(student_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'student/getRefundHistory_',
		async: true,
		type: 'post',
		data: { student_id: student_id },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.refund_history').html(response.msg);
			} else {
				$('.refund_history').html(response.msg);
			}
		}
	});
}
function senddatatomodal(wid, sid, type) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'Waiver/ajax_displayWaiverHistory',
		async: true,
		type: 'post',
		data: { student_id: sid },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.msg').html(response.data);
			} else {
				$('.msg').html(response.data);
			}
		}
	});
	if (type == 'A') {
		$('.makeBtn').html('<a href="javascript:void(0);" class="btn btn-success btn-xs" data-toggle="tooltip" title="Approve" onclick=approve_reject_waiver(' + wid + ',"A")>Approve</span></a>');
	} else {
		$('.makeBtn').html('<a href="javascript:void(0);" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Reject" onclick=approve_reject_waiver(' + wid + ',"R")>Reject</span> </a>');
	}
}
function getWalletTransactionHistory(student_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'student/getWalletTransactionHistory_',
		async: true,
		type: 'post',
		data: { student_id: student_id },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.wallet_tran_history').html(response.msg);
			} else {
				$('.wallet_tran_history').html(response.msg);
			}
		}
	});
}
function getAttendanceHistory(student_id, pack_type) {
	var classroom_id=$('#classroom_id').val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'student_attendance/ajax_getAttendanceHistory',
		async: true,
		type: 'post',
		data: { student_id: student_id, pack_type: pack_type ,classroom_id:classroom_id},
		dataType: 'json',
		success: function (response) {			
			$('.attendance_tran_history').html(response.msg);			
		}
	});
}
function getAttendanceHistoryByMonth(student_id, pack_type, date) {
	var classroom_id=$('#classroom_id').val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'student_attendance/ajax_getAttendanceHistoryByMonth',
		async: true,
		type: 'post',
		data: { student_id: student_id, pack_type: pack_type, date: date ,classroom_id:classroom_id},
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.attendance_tran_history').html(response.msg);
			} else {
				$('.attendance_tran_history').html(response.msg);
			}
		}
	});
}
function getAttendanceHistoryByPresenseDay(student_id, pack_type, date) {
	var classroom_id=$('#classroom_id').val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'student_attendance/ajax_getAttendanceHistoryByPresenseDay',
		async: true,
		type: 'post',
		data: { student_id: student_id, pack_type: pack_type, date: date,classroom_id:classroom_id },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.attendance_tran_history').html(response.msg);
			} else {
				$('.attendance_tran_history').html(response.msg);
			}
		}
	});
}
function Update_Special_Access() {
	var portal_access = document.getElementById("portal_access").value;
	var waiver_power = document.getElementById("waiver_power").value;
	var waiver_upto = document.getElementById("waiver_upto").value;
	var refund_power = document.getElementById("refund_power").value;
	var user_id = document.getElementById("user_id_spl_acc").value;
	var role_id = document.getElementById("role_id").value;
	var portal_access_hidden = document.getElementById("portal_access_hidden").value;
	var role_id_hidden = document.getElementById("role_id_hidden").value;
	var test_module_id = [];
	$("#test_module_id :selected").each(function () {
		test_module_id.push($(this).val());
	});
	var programe_id = [];
	$("#programe_id :selected").each(function () {
		programe_id.push($(this).val());
	});
	var batch_id = [];
	$("#batch_id :selected").each(function () {
		batch_id.push($(this).val());
	});
	var category_id = [];
	$("#category_id :selected").each(function () {
		category_id.push($(this).val());
	});
	//alert(test_module_id);alert(programe_id);alert(batch_id);alert(category_id);
	if (role_id == "") {
		$('.role_id_err').text('Please select role');
		$('#role_id').focus();
		return false;
	} else {
		$('.role_id_err').text('');
	}
	if (waiver_power == 0) {
		waiver_upto = 0;
	}
	if ($("#sendMail_pa").prop('checked') == true) {
		sendMail_pa = 1;
	} else {
		sendMail_pa = 0;
	}
	if (portal_access == "") {
		$('.portal_access_err').text('Please select portal access as Yes/No');
		$('#portal_access').focus();
		return false;
	} else {
		$('.portal_access_err').text('');
	}
	if (waiver_power == "") {
		$('.waiver_power_err').text('Please select waiver power as Yes/No');
		$('#waiver_power').focus();
		return false;
	} else {
		$('.waiver_power_err').text('');
	}
	if (refund_power == "") {
		$('.refund_power_err').text('Please select refund power as Yes/No');
		$('#refund_power').focus();
		return false;
	} else {
		$('.refund_power_err').text('');
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'user/Update_Special_Access_',
		async: true,
		type: 'post',
		data: { portal_access: portal_access, waiver_power: waiver_power, waiver_upto: waiver_upto, refund_power: refund_power, user_id: user_id, sendMail_pa: sendMail_pa, role_id: role_id, test_module_id: test_module_id, programe_id: programe_id, batch_id: batch_id, category_id: category_id,portal_access_hidden:portal_access_hidden,role_id_hidden:role_id_hidden },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.spl_acc_response').html(response.msg);
			} else {
				$('.spl_acc_response').html(response.msg);
			}
		}
	});
}
//add new doc
function sendDoc() {
	var active = document.getElementById("activeDoc").value;
	var image_id = document.getElementById("image_id").value;
	var document_type = document.getElementById("document_typeDoc").value;
	var document_no = document.getElementById("document_no").value;
	var document_expiry = document.getElementById("document_expiry").value;
	var student_id = document.getElementById("student_id").value;
	var flag=1;
	if(document_type == "")
		{			
			$(".document_typeDoc_err").html('The Document Type is required.');
			flag=0;
		} else { $(".document_typeDoc_err").html(''); }
		if(document_no == "")
		{			
			$(".document_no_err").html('The Document Number is required.');
			flag=0;
		} else { $(".document_no_err").html(''); }
		if(image_id == "")
		{			
			$("#doc_image_msg").html('The Upload Documents is required.');
			flag=0;
		} else { $("#doc_image_msg").html(''); }
		if(flag == 0)
		{
			return false;
		} 
	$.ajax({
		url: WOSA_ADMIN_URL + 'student/add_document_',
		async: true,
		type: 'post',
		data: { student_id: student_id, document_type: document_type, document_no: document_no, document_expiry: document_expiry, image_id: image_id, active: active },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.msg').html(response.msg);
			} else {
				$('.msg').html(response.msg);
			}
		}
	});
}
//add new status
function saveSessionStatus() {
	var session_booking_remarks = document.getElementById("session_booking_remarks").value;
	var session_booking_id = document.getElementById("session_booking_id").value;
	if ($("#is_attended").prop('checked') == true) {
		is_attended = 1;
	} else {
		is_attended = 0;
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'student/add_session_status_',
		async: true,
		type: 'post',
		data: { session_booking_id: session_booking_id, session_booking_remarks: session_booking_remarks, is_attended: is_attended },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.msg_session').html(response.msg);
			} else {
				$('.msg_session').html(response.msg);
			}
		}
	});
}
function reflect_fields(purpose) {
	if (purpose == 1) {
		$('.test').show();
		$('.pgm').show();
		$('.demo').show();
		$('.br').hide();
		$('.cnt').hide();
		$('.sub_events').hide();
	} else if (purpose == 2) {
		$('.test').show();
		$('.pgm').show();
		$('.demo').hide();
		$('.br').hide();
		$('.cnt').hide();
		$('.sub_events').hide();
	} else if (purpose == 3) {
		$('.test').show();
		$('.pgm').show();
		$('.demo').hide();
		$('.br').show();
		$('.cnt').hide();
		$('.sub_events').hide();
	} else if (purpose == 4) {
		$('.test').hide();
		$('.pgm').hide();
		$('.demo').hide();
		$('.br').hide();
		$('.cnt').show();
		$('.sub_events').hide();
	} else if (purpose == 5) {
		$('.test').hide();
		$('.pgm').hide();
		$('.demo').hide();
		$('.br').hide();
		$('.cnt').hide();
		$('.sub_events').show();
	} else {
		$('.test').hide();
		$('.pgm').hide();
		$('.demo').hide();
		$('.br').hide();
		$('.cnt').hide();
		$('.sub_events').hide();
	}
}
function displayWaiverHistory(student_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'waiver/ajax_displayWaiverHistory',
		async: true,
		type: 'post',
		data: { student_id: student_id },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.msg').html(response.data);
			} else {
				$('.msg').html(response.data);
			}
		}
	});
}
function displayRefundHistory(student_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'refund/ajax_displayRefundHistory',
		async: true,
		type: 'post',
		data: { student_id: student_id },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.msg').html(response.data);
			} else {
				$('.msg').html(response.data);
			}
		}
	});
}
function getWordCount_tr(wordString) {
	var words = wordString.split(" ");
	words = words.filter(function (words) {
		return words.length > 0
	}).length;
	if (words >= 50) {
		$(".termination_reason").text("");
		$('.uspp').prop('disabled', false);
	} else {
		$(".termination_reason").text("Please enter atleast 50 words!");
		$('.uspp').prop('disabled', true);
		return false;
	}
}
function checkbal(withdrawl_amount) {
	bal = parseInt(document.getElementById("bal").value);
	if (withdrawl_amount > bal) {
		$(".withdrawl_amount_err").text("Please enter valid amount.Insufficient wallet balance!");
		$("#withdrawl_amount").val('');
	}else if(withdrawl_amount<=0){
		$(".withdrawl_amount_err").text("Please enter valid amount! Zero is not allowed!");
		$("#withdrawl_amount").val('');
	}else{
		$(".withdrawl_amount_err").text("");
	}
}
function selectAlL() {
	var ele = document.getElementsByClassName('attCb');
	for (var i = 0; i < ele.length; i++) {
		if (ele[i].type == 'checkbox')
			ele[i].checked = true;
	}
}
function deSelectAll() {
	var ele = document.getElementsByClassName('attCb');
	for (var i = 0; i < ele.length; i++) {
		if (ele[i].type == 'checkbox')
			ele[i].checked = false;
	}
}
/*function enableDisableFilterBox(val) {
	if (val == 'Morning' || val == 'Evening') {
		$('.filterBox').show();
		$('.responseDiv').show();
	} else {
		$('.filterBox').hide();
		$('.responseDiv').hide();
	}
}*/
function resetB2AttendanceFilterForm(className) {
	if (className == 'b1') {
		$('#UID').val('');
		$('.b1').prop('disabled', false);
		$(".b2 option:selected").removeAttr("selected");
		$('.b2').selectpicker('refresh');
		$('.b2').prop('disabled', true);
	} else if (className == 'b2') {
		$('#UID').val('');
		$('.b1').prop('disabled', true);
		$(".b2 option:selected").removeAttr("selected");
		$('.b2').prop('disabled', false);
		$('.b2').selectpicker('refresh');
		$('#byMonth1').val('');
	} else {
		$('#UID').val('');
		$('.b1').prop('disabled', false);
		$(".b2 option:selected").removeAttr("selected");
		$('.b2').selectpicker('refresh');
		$('.b2').prop('disabled', false);
	}
}
function attendanceFilterformEligibility(id) {
	var classNamepattern1 = /form-control b1/;
	var classNamepattern2 = /form-control selectpicker b2/;
	var classNamepattern3 = /form-control b2/;
	var className = document.getElementById(id).className;
	if (classNamepattern1.test(className)) {
		var val = $('#UID').val();
		if (val != '') {
			$('#byMonth2').prop('disabled', false);
			$('.b2').prop('disabled', true);
			$('#classroom_id').selectpicker('refresh');
		} else {
			$('#byMonth2').prop('disabled', true);
			$('.b2').prop('disabled', false);
			$('#classroom_id').selectpicker('refresh');
		}
	}  else if (classNamepattern2.test(className) || classNamepattern3.test(className)) {
		$('.b1').prop('disabled', true);
		var byMonth1 = document.getElementById('byMonth1').value;
		var allPresent1 = document.getElementById('allPresent1').value;
		if (byMonth1) {
			$("#allPresent1 option:selected").removeAttr("selected");
			$('#allPresent1').prop('disabled', true);
			$('#allPresent1').selectpicker('refresh');
			$('#classroom_id').selectpicker('refresh');
		} else if (allPresent1) {
			$('#byMonth1').val('');
			$('#byMonth1').prop('disabled', true);
			$('#classroom_id').selectpicker('refresh');
		} else {
			$('#allPresent1').prop('disabled', false);
			$('#byMonth1').prop('disabled', false);
			$('#classroom_id').selectpicker('refresh');
		}
		$('#byMonth2').val('');
	} else {
		$('.b1').prop('disabled', false);
		$('.b2').prop('disabled', false);
		$('#classroom_id').selectpicker('refresh');
	}
}
function filterEnquiryByDate(dateVal) {
	var baseUrl = WOSA_ADMIN_URL + 'student_enquiry/ajax_filterEnquiryByDate/';
	window.location = baseUrl + dateVal;
}
function filterWalkinByDate(dateVal) {
	var baseUrl = WOSA_ADMIN_URL + 'walkin/filter_WalkinByDate_/';
	window.location = WOSA_ADMIN_URL + 'walkin/filter_WalkinByDate_/' + dateVal;
}
function updateMenuPriority(val, id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'role/updateMenuPriority_',
		async: true,
		type: 'post',
		data: { val: val, id: id },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.msg').html(response.msg);
			} else {
				$('.msg').html(response.msg);
			}
		}
	});
}
function resetMenuPriority() {
	$.ajax({
		url: WOSA_ADMIN_URL + 'role/resetMenuPriority_',
		async: true,
		type: 'post',
		data: {},
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.msg').html(response.msg);
				window.location.href = window.location.href
			} else {
				$('.msg').html(response.msg);
			}
		}
	});
}
function disableDate(val) {
	if (val == 1) {
		$('.exam_date_field').show();
	} else {
		$('.exam_date_field').hide();
	}
}
function showExamFeeDate(programe_id) {
	var test_module_id = $("#test_module_id_eb").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'exam_master/ajax_showExamFeeDate',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('#exam_fee_eb').val(response.exam_fee);
				$('.date_dd').html(response.date_dd);
				$('#exam_date_eb').selectpicker('refresh');
				$('.city_dd').html(response.city_dd);
				$('#city_eb').selectpicker('refresh');
			} else {
				$('#exam_fee_eb').val(response.exam_fee);
				$('.date_dd').html(response.date_dd);
				$('#exam_date_eb').selectpicker('refresh');
				$('.city_dd').html(response.city_dd);
				$('#city_eb').selectpicker('refresh');
			}
		}
	});
}
function showExamVenue_pte(city) {
	var test_module_id = $("#test_module_id_eb").val();
	var programe_id = $("#programe_id_eb").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'exam_master/ajax_showExamVenue_pte',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id, city: city },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('#venue_name_eb').val(response.venue_name);
				$('#venue_address_eb').val(response.venue_address);
			} else {
				$('#venue_name_eb').val(response.venue_name);
				$('#venue_address_eb').val(response.venue_address);
			}
		}
	});
}
function showCity(exam_date) {
	var test_module_id = $("#test_module_id_eb").val();
	var programe_id = $("#programe_id_eb").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'exam_master/ajax_showCity',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id, exam_date: exam_date },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.city_dd').html(response.city_dd);
			} else {
				$('.city_dd').html(response.city_dd);
			}
		}
	});
}
function showCity_peb(exam_date) {
	var test_module_id = $("#test_module_id_eb").val();
	var programe_id = $("#programe_id_eb").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'exam_master/ajax_showCity_peb',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id, exam_date: exam_date },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.city_dd_peb').html(response.city_dd_peb);
			} else {
				$('.city_dd_peb').html(response.city_dd_peb);
			}
		}
	});
}
function showCity_rs(exam_date) {
	var test_module_id = $("#test_module_id_eb").val();
	var programe_id = $("#programe_id_eb").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'exam_master/ajax_showCity_rs',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id, exam_date: exam_date },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.city_dd_rs').html(response.city_dd_rs);
			} else {
				$('.city_dd_rs').html(response.city_dd_rs);
			}
		}
	});
}
function fillVenue(city_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'outhouse_locations/ajax_fillVenue',
		async: true,
		type: 'post',
		data: { city_id: city_id },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.venue_name_dd').html(response.venue_name);
			} else {
				$('.venue_name_dd').html(response.venue_name);
			}
			$(".selectpicker").selectpicker("refresh");
		}
	});
}
function fillVenueAddress(venue_name) {
	var city_id = $('select#city option:selected').val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'outhouse_locations/ajax_fillVenueAddress',
		async: true,
		type: 'post',
		data: { city_id: city_id, venue_name: venue_name },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('#venue_address').val(response.venue_address);
			} else {
				$('#venue_address').val(response.venue_address);
			}
		}
	});
}
function showVenue(city) {
	var test_module_id = $("#test_module_id_eb").val();
	var programe_id = $("#programe_id_eb").val();
	var exam_date = $("#exam_date_eb").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'exam_master/ajax_showVenue',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id, exam_date: exam_date, city: city },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('#venue_name_eb_1').hide();
				$('.venue_dd').html(response.venue_name);
			} else {
				('#venue_name_eb_1').show();
				$('.venue_dd').html(response.venue_name);
			}
		}
	});
}
function showVenue_peb(city) {
	var test_module_id = $("#test_module_id_eb").val();
	var programe_id = $("#programe_id_eb").val();
	var exam_date = $("#exam_date_peb").val();
	//alert(test_module_id);alert(programe_id);alert(exam_date);alert(city);
	$.ajax({
		url: WOSA_ADMIN_URL + 'exam_master/ajax_showVenue_peb',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id, exam_date: exam_date, city: city },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.venue_dd_peb').html(response.venue_name);
			} else {
				$('.venue_dd_peb').html(response.venue_name);
			}
		}
	});
}
function showVenue_address(venue_name) {
	var test_module_id = $("#test_module_id_eb").val();
	var programe_id = $("#programe_id_eb").val();
	var exam_date = $("#exam_date_eb").val();
	var city = $("#city_eb").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'exam_master/ajax_showVenue_address',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id, exam_date: exam_date, city: city, venue_name: venue_name },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('#venue_address_eb').val(response.venue_address);
				$('#venue_address_peb').val(response.venue_address);
				$('#rsVenueAddress').val(response.venue_address);
			} else {
				$('#venue_address_eb').val(response.venue_address);
				$('#venue_address_peb').val(response.venue_address);
				$('#rsVenueAddress').val(response.venue_address);
			}
		}
	});
}
function showVenue_address_peb(venue_name) {
	var test_module_id = $("#test_module_id_eb").val();
	var programe_id = $("#programe_id_eb").val();
	var exam_date = $("#exam_date_peb").val();
	var city = $("#city_peb").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'exam_master/ajax_showVenue_address',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id, exam_date: exam_date, city: city, venue_name: venue_name },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('#venue_address_peb').val(response.venue_address);
			} else {
				$('#venue_address_peb').val(response.venue_address);
			}
		}
	});
}
function showVenue_address_rs(venue_name) {
	var test_module_id = $("#test_module_id_eb").val();
	var programe_id = $("#programe_id_eb").val();
	var exam_date = $("#rsExamdate").val();
	var city = $("#rsCity").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'exam_master/ajax_showVenue_address',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id, exam_date: exam_date, city: city, venue_name: venue_name },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('#rsVenueAddress').val(response.venue_address);
			} else {
				$('#rsVenueAddress').val(response.venue_address);
			}
		}
	});
}
function showVenue_rs(city) {
	var test_module_id = $("#test_module_id_eb").val();
	var programe_id = $("#programe_id_eb").val();
	var exam_date = $("#rsExamdate").val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'exam_master/ajax_showVenue_rs',
		async: true,
		type: 'post',
		data: { test_module_id: test_module_id, programe_id: programe_id, exam_date: exam_date, city: city },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.rsVenueName_dd').html(response.venue_name);
				//$('#rsVenueAddress').val(response.venue_address);
			} else {
				$('.rsVenueName_dd').html(response.venue_name);
				//$('#rsVenueAddress').val(response.venue_address);
			}
		}
	});
}
//by prabhat
///Start Discount code
$(document).ready(function () {
	//alert("sdf");
	var url = window.location.href;
	$('.sidebar-menu ul li').each(function () {
		var href = $(this).find('a').attr('href');
		//alert(url+'--'+href);
		if (url == href) {
			$(this).addClass('active');
			$(this).parents("ul").css("display", "block");
		}
	});
});
function CopyToClipboard(value, showNotification, notificationText) {
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val(value).select();
	document.execCommand("copy");
	$temp.remove();
	if (typeof showNotification === 'undefined') {
		showNotification = true;
	}
	if (typeof notificationText === 'undefined') {
		notificationText = "Copied to clipboard";
	}
	var notificationTag = $("div.copy-notification");
	if (showNotification && notificationTag.length == 0) {
		notificationTag = $("<div/>", { "class": "copy-notification", text: notificationText });
		$("body").append(notificationTag);
		notificationTag.fadeIn("slow", function () {
			setTimeout(function () {
				notificationTag.fadeOut("slow", function () {
					notificationTag.remove();
				});
			}, 1000);
		});
	}
}
$(document).on('blur', '#txtSearch', function () {
	if ($(this).val() != "") {
		$(".disbled").attr("disabled", true);
	} else {
		$(".disbled").attr("disabled", false);
	}
});
$(document).on('click', '#clearSel', function () {
	$(".disbled").attr("disabled", false);
	//alert($(".disbled").val());
	$(".disbled").val("");
	//$(".selectpicker").selectpicker('deselectAll');
	$(".selectpicker").val('default');
	$(".selectpicker").selectpicker("refresh");
	$("#txtSearch").attr("disabled", false);
	$("#txtSearch").val("");
});
$(document).on('change', '.disbled', function () {
	if ($(this).val() != "") {
		$("#txtSearch").attr("disabled", true);
	} else {
		$("#txtSearch").attr("disabled", false);
	}
});
function validate_number_codes(myval) {
	var myval = $("#no_of_codes").val();
	var filter = /^[0-9-+]+$/;
	if (!filter.test(myval) || myval < 0) {
		$('.no_of_codes_err').text('Please enter number of codes!');
		$('#no_of_codes').focus();
		$('.btnCodeAdd').prop('disabled', true);
		return false;
	} else {
		$('.no_of_codes_err').text('');
		$('.btnCodeAdd').prop('disabled', false);
	}
}
$(document).on('click', '.btnCodeAdd', function () {
	var myval = $("#no_of_codes").val();
	var filter = /^[0-9-+]+$/;
	if (!filter.test(myval) || myval < 0) {
		$('.no_of_codes_err').text('Please enter number of codes!');
		$('#no_of_codes').focus();
		$('.btnCodeAdd').prop('disabled', true);
		return false;
	} else {
		$('.btnCodeAdd').prop('disabled', false);
		$('.no_of_codes_err').hide();
		$.ajax({
			url: WOSA_ADMIN_URL + 'discount/ajax_add_bulk_code',
			async: true,
			type: 'post',
			data: { no_of_codes: $("#no_of_codes").val(), discount_id: $("#discount_id").val() },
			dataType: 'json',
			success: function (data) {
				$("#smsg").html("Successfully data saved !!");
				$("#smsg").show();
				setTimeout(function () { $(".close").trigger("click"); }, 3000);
			}
		});
	}
});
/*$(document).on('blur', '.disbled', function() {
if($(this).val()!="") {
$("#txtSearch").attr("disabled",true);
} else {
$("#txtSearch").attr("disabled",false);
}
});*/
$(document).on('blur', '#bemail, #phoneNumber', function () {
	if ($("#phoneNumber").val() != "" || $("#bemail").val() != "") {
		$("#phoneemail").val(1);
	} else {
		$("#phoneemail").val("");
	}
});
//alert(RoundTo(543.55, 5));
function isNumber(evt, element) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (
		(charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
		(charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
		(charCode < 48 || charCode > 57))
		return false;
	return true;
}
$(document).ready(function () {
	$('.chknum').keypress(function (event) {
		return isNumber(event, this)
	});
});
$(document).on("input", ".chknum1", function () {
	this.value = this.value.replace(/\D/g, '');
});
$(document).on("click", ".btnchckval", function () {
	var btnchk = 0;
	btnchk = $(this).attr("data-val");
	$('#btnCheck').val(btnchk);
});
var rowIdx = 0;
// jQuery button click event to add a row
$(document).on('click', '#addBtn', function () {
	// Adding a row inside the tbody.
	$('#tbody').append('<div class="col-md-12"><div class="col-md-3"><div class="form-group has-feedback"> <span class="currFront">From</span><input type="text" name="range_from[]" value="" class="form-control chkRange chkFrom chknum1" id="range_from" style="padding-left: 75px;" maxlength="5" /><span class="currBack">AUD</span> </div></div><div class="col-md-3"><div class="form-group has-feedback"><span class="currFront">To</span><input type="text" name="range_to[]" value="" class="form-control chkRange chkTo chknum1" id="range_to"  style="padding-left: 75px;" maxlength="5" /><span class="currBack">AUD</span>  </div></div><div class="col-md-3"><div class="form-group has-feedback"> <span class="currFront">Discount</span><input type="text" name="range_discount[]" value="" class="form-control chkRange chkDisc chknum1 input-ui-100" id="range_discount"  style="padding-left: 75px;" maxlength="5"/><span class="currBack curBD">AUD</span>  </div></div><div class="col-md-3"><button class="btn btn-danger remove" data-del="1" type="button">X</button></div></div>');
	var disType = $("#discount_type").val();
	if (disType == "Percentage") {
		var ccode = $('.curF').html();
		$('.currBack').html(ccode);
		//$('.curBD').show();
		$('.currBack').show();
		$('.curBD').html("%");
	}
	if (disType == "Amount") {
		$('.curBD').show();
		$('.curF').show();
		$('.currBack').show();
		var ccode = $('.curF').html();
		$('.curBD').html(ccode);
	}
});
$('#tbody').on('click', '.remove', function () {
	// Getting all the rows next to the row
	// containing the clicked button
	var child = $(this).closest('div.col-md-12').nextAll();
	// Iterating across all the rows
	// obtained to change the index
	child.each(function () {
		// Getting <tr> id.
		var id = $(this).attr('id');
		// Getting the <p> inside the .row-index class.
		var idx = $(this).children('.row-index').children('p');
		// Gets the row number from <tr> id.
		var dig = parseInt(id.substring(1));
		// Modifying row index.
		idx.html(`Row ${dig - 1}`);
		// Modifying row id.
		$(this).attr('id', `R${dig - 1}`);
	});
	// Removing the current row.
	$(this).closest('div.col-md-12').remove();
	// Decreasing total number of rows by 1.
	rowIdx--;
	//alert(totalper);
});
/*$(document).on('change', '#max_discount, #not_exceeding, #min_purchase_value', function() {
if($("#max_discount").val()!="" && $("#not_exceeding").val()!="" && $("#min_purchase_value").val()!="") {
$(".chkRange").attr("disabled",false);
$(".chkAdd").show();
}
}); */
$('#OpenOUpload').click(function () {
	$('#upfile').trigger('click');
});
$('#upfile').change(function (evt) {
	if (document.getElementById("upfile").value.toLowerCase().lastIndexOf(".csv") == -1) {
		alert("Please upload a file with .csv extension.");
		return false;
	} else {
		$('#sel').show();
		$("#bemail").attr('disabled', 'disabled');
		$("#phoneNumber").attr('disabled', 'disabled');
		$("#country_code").attr('disabled', 'disabled');
	}
});
$(document).on('click', '#resetid', function () {
	$('#sel').hide();
	$("#bemail").attr('disabled', false);
	$("#phoneNumber").attr('disabled', false);
	$("#country_code").attr('disabled', false);
	$("#upfile").val('');
});
/*$(document).on('blur', '.chkRange', function() {
if($(this).val()!="") {
$(this).parents(".col-md-3").next().find('input').attr("disabled",false);
}
});
*/
//activate/deactivate all
function activate_deactivete_schedule(id, active, table, pk) {
	//alert(id)
	var idd = '#' + id;
	$.ajax({
		url: WOSA_ADMIN_URL + 'discount/ajax_activate_deactivete_schedule',
		async: true,
		type: 'post',
		data: { id: id, active: active, table: table, pk: pk },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				//alert(response)
				window.location.href = window.location.href
			} else {
				$(idd).html('');
			}
		}
	});
}
$(document).on('blur', '.chkRange', function () {
	var flag = 0;
	$('.chkRange').each(function () {
		if ($(this).val() == "") {
			flag = 1;
		}
	});
	if (parseInt(flag) == 1) {
		$("#rangeempty").show();
		$("#rangeempty").html("Range: From, To and Discount required or Leave all empty");
		//$(this).focus();
		$(".btndis").attr('disabled', 'disabled');
		return false;
	} else {
		$("#rangeempty").hide();
		$("#rangeempty").html("");
		$(".btndis").attr('disabled', false);
	}
});
$(document).on('blur', '.chkMin', function () {
	var flag = 0;
	$('.chkMin').each(function () {
		if (parseInt($("#min_purchase_value").val()) > parseInt($(this).val())) {
			flag = 1;
		}
	});
	if (flag == 1) {
		$("#rangeid").show();
		$("#rangeid").html("Range: From, To must be greater than Minimum purchase value");
		//$(this).focus();
		$(".btndis").attr('disabled', 'disabled');
		return false;
	} else {
		$("#rangeid").hide();
		$("#rangeid").html("");
		$(".btndis").attr('disabled', false);
	}
});
$(document).on('blur', '.chkDisc', function () {
	if (parseInt($(this).val()) > parseInt($("#max_discount").val())) {
		$(".btndis").attr('disabled', 'disabled');
		$("#rangedisc").show();
		$("#rangedisc").html("Discount must be less than max discount");
		//$(this).focus();
	} else {
		$("#rangedisc").hide();
		$("#rangedisc").html("");
		$(".btndis").attr('disabled', false);
	}
	//$(".chkRange").trigger("blur");
});
$(document).on('blur', '#min_purchase_value', function () {
	$(".chkMin").trigger("blur");
});
$(document).on('blur', '#max_discount', function () {
	//if(parseInt($("#max_discount").val())>parseInt($(this).val())) {
	$(".chkDisc").trigger("blur");
	//}
});
$(document).on('change', '#type_of_discount', function () {
	var distype = $(this).val();
	if (distype == "General") {
		$(".bindto").hide();
		$(".ncodes").hide();
		$(".nmanual").show();
		$(".specialid").hide();
		$(".gencode").show();
	}
	if (distype == "Special") {
		$(".ncodes").hide();
		$(".nmanual").hide();
		$(".bindto").show();
		$(".specialid").show();
		$(".gencode").hide();
	}
	if (distype == "Bulk") {
		$(".ncodes").show();
		$(".bindto").hide();
		$(".nmanual").hide();
		$(".specialid").hide();
		$(".gencode").show();
	}
	if (distype == "Template") {
		$(".templateId").show();
		$(".bindto").hide();
		$(".ncodes").hide();
		$(".nmanual").hide();
		$(".specialid").hide();
		$(".gencode").show();
	}
});
$("#isAuto").change(function () {
	if (this.checked) {
		$(this).val(1);
		$("#disc_manual").attr('disabled', 'disabled');
		/* $("#disCharacter").attr('disabled','disabled');
		 $("#disPrefix").attr('disabled','disabled');
		 $("#disSuffix").attr('disabled','disabled');*/
	} else {
		$(this).val(0);
		$("#disc_manual").attr('disabled', false);
		/*$("#disCharacter").attr('disabled',false);
		  $("#disPrefix").attr('disabled',false);
		  $("#disSuffix").attr('disabled',false);*/
	}
});
$(document).on('blur', '#disc_manual', function () {
	if ($(this).val()) {
		$("#disCharacter").attr('disabled', 'disabled');
		$("#disPrefix").attr('disabled', 'disabled');
		$("#disSuffix").attr('disabled', 'disabled');
		$("#isAuto").attr('disabled', 'disabled');
	} else {
		$("#disCharacter").attr('disabled', false);
		$("#disPrefix").attr('disabled', false);
		$("#disSuffix").attr('disabled', false);
		$("#isAuto").attr('disabled', false);
	}
});
$(document).on('blur', '#phoneNumber', function () {
	if ($(this).val()) {
		$("#bemail").attr('disabled', 'disabled');
		$(".upcsv").hide();
	} else {
		$("#bemail").attr('disabled', false);
		$(".btndis").attr('disabled', false);
		$(".upcsv").show();
	}
	var phoneNumber = $(this).val();
	var cur = $(this);
	$.ajax({
		url: WOSA_ADMIN_URL + 'discount/ajax_check_phonenumber',
		async: true,
		type: 'post',
		data: { phoneNumber: phoneNumber },
		dataType: 'json',
		success: function (data) {
			console.log(data);
			if (data == 0 && cur.val() != "") {
				$(".chkphone").html("");
				$(".chkphone").html("Phone number not exist");
				$(".chkphone").show();
				$(".btndis").attr('disabled', 'disabled');
			} else {
				$(".chkphone").html("");
				$(".chkphone").hide();
				$(".btndis").attr('disabled', false);
			}
		}
	});
});
$(document).on('blur', '#bemail', function () {
	if ($(this).val()) {
		$("#phoneNumber").attr('disabled', 'disabled');
		$(".upcsv").hide();
	} else {
		$("#phoneNumber").attr('disabled', false);
		$(".btndis").attr('disabled', false);
		$(".upcsv").show();
	}
	var bemail = $(this).val();
	var cur = $(this);
	$.ajax({
		url: WOSA_ADMIN_URL + 'discount/ajax_check_email',
		async: true,
		type: 'post',
		data: { bemail: bemail },
		dataType: 'json',
		success: function (data) {
			console.log(data);
			if (data == 0 && cur.val() != "") {
				$(".chkemail").html("");
				$(".chkemail").html("Email not exist");
				$(".chkemail").show();
				$(".btndis").attr('disabled', 'disabled');
			} else {
				$(".chkemail").html("");
				$(".chkemail").hide();
				$(".btndis").attr('disabled', false);
			}
		}
	});
});
$(document).on('change', '#discount_type', function () {
	var disType = $(this).val();
	if (disType == "Percentage") {
		$('.curBD').html("%");
		$(".chkAdd").show();
		$('#not_exceeding').attr("disabled", false);
	}
	if (disType == "Amount") {
		var ccode = $('.curF').html();
		$('.curBD').html(ccode);
		$('#not_exceeding').attr("disabled", true);
		$(".chkAdd").show();
	}
});
$(document).on('change', '#appliedTestType1', function () {
	var products = $("#appliedProducts1").val();
	var branches = $("#appliedBranches1").val();
	var min_purchase_value = $("#min_purchase_value").val();
	var testtype = $(this).val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'discount/ajax_get_testype_by_packandbranch',
		async: true,
		type: 'post',
		data: { testtype: testtype, branches: branches, products: products, min_purchase_value: min_purchase_value },
		dataType: 'json',
		success: function (data) {
			console.log(data);
			// html = '';
			var packids = $('#packageids').val();
			var packidsarr = [];
			if (packids != "") {
				packidsarr = packids.split(",");
			} else {
				packidsarr = [];
			}
			// alert(packidsarr[0]);
			if (data.result == 1) {
				$('#appliedPackages1').prop('disabled', true);
			} else if (data.result == 2) {
				if (data.package.length > 0) {
					html = '<option data-subtext="" disabled value="">Select package</option>';
					for (i = 0; i < data.package.length; i++) {
						if (data.package[i]['discounted_amount'] === data.package[i]['amount'] || data.package[i]['discounted_amount'] == null) {
							if (packidsarr.includes(data.package[i]['package_id'])) {
								html += '<option value=' + data.package[i]['package_id'] + ' selected>' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + ' | ' + data.package[i]['duration'] + '</option>';
							} else {
								html += '<option value=' + data.package[i]['package_id'] + ' >' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + ' | ' + data.package[i]['duration'] + '</option>';
							}
						} else {
							if (packidsarr.includes(data.package[i]['package_id'])) {
								html += '<option value=' + data.package[i]['package_id'] + ' selected>' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + '/' + data.package[i]['amount'] + ' | ' + data.package[i]['duration'] + '</option>';
							} else {
								html += '<option value=' + data.package[i]['package_id'] + ' >' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + '/' + data.package[i]['amount'] + ' | ' + data.package[i]['duration'] + '</option>';
							}
						}
					}
					html += '</select>';
					$('#appliedPackages1').html(html);
					$('#appliedPackages1').selectpicker('refresh');
				} else {
					html = '';
					$('#appliedPackages1').html(html);
					$('#appliedPackages1').selectpicker('refresh');
					// $('.branch_div_rt').hide();
				}
			} else if (data.result == 3) {
				if (data.package.length > 0) {
					html = '<option data-subtext="" value="" disabled>Select package</option>';
					for (i = 0; i < data.package.length; i++) {
						if (data.package[i]['category_name']) { var cat = data.package[i]['category_name']; } else { var cat = 'ALL'; }
						if (data.package[i]['discounted_amount'] === data.package[i]['amount'] || data.package[i]['discounted_amount'] == null) {
							if (packidsarr.includes(data.package[i]['package_id'])) {
								html += '<option value=' + data.package[i]['package_id'] + ' selected>' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + ' | ' + data.package[i]['duration'] + '</option>';
							} else {
								html += '<option value=' + data.package[i]['package_id'] + ' >' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + ' | ' + data.package[i]['duration'] + '</option>';
							}
						} else {
							if (packidsarr.includes(data.package[i]['package_id'])) {
								html += '<option value=' + data.package[i]['package_id'] + ' selected>' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + '/' + data.package[i]['amount'] + ' | ' + data.package[i]['duration'] + '</option>';
							} else {
								html += '<option value=' + data.package[i]['package_id'] + ' >' + data.package[i]['package_name'] + ' | ' + data.package[i]['discounted_amount'] + '/' + data.package[i]['amount'] + ' | ' + data.package[i]['duration'] + '</option>';
							}
						}
					}
					html += '</select>';
					$('#appliedPackages1').html(html);
					$('#appliedPackages1').selectpicker('refresh');
					/* html='<option value="">Select Package</option>';
						for(i=0; i<data.package.length; i++){
							html += '<option value='+ data.package[i]['package_id'] +' >'+ data.package[i]['package_name'] +' </option>';
						}
						html += '</select>';
						$('#appliedPackages1').html(html);
						$('#appliedPackages1').selectpicker('refresh');*/
				} else {
					html = '';
					$('#appliedPackages1').html(html);
					$('#appliedPackages1').selectpicker('refresh');
					// $('.branch_div_rt').hide();
				}
			} else {
				$('#appliedPackages1').prop('disabled', false);
				html = '';
				$('#appliedPackages1').html(html);
				$('#appliedPackages1').selectpicker('refresh');
			}
		}
	});
});
function getDiscountDetails(discount_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'discount/ajax_getDiscountDetailView',
		async: true,
		type: 'post',
		data: { discount_id: discount_id },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.discount_details').html(response.msg);
			} else {
				$('.discount_details').html(response.msg);
			}
		}
	});
}
function editDiscountDates(discount_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'discount/ajax_editDiscountDates',
		async: true,
		type: 'post',
		data: { discount_id: discount_id },
		dataType: 'json',
		crossDomain: true,
		success: function (response) {
			if (response.status == 'true') {
				$('.discount_dates').html(response.msg);
			} else {
				$('.discount_dates').html(response.msg);
			}
		}
	});
}
function getAddMoreCode(discount_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'discount/ajax_getAddMoreCode',
		async: true,
		type: 'post',
		data: { discount_id: discount_id },
		dataType: 'json',
		success: function (response) {
			if (response.status == 'true') {
				$('.discount_add').html(response.msg);
			} else {
				$('.discount_add').html(response.msg);
			}
		}
	});
}
///End Discount code
//Code Add By Neelu stary heirarchy module
function deleteUserCenterHead(center_id, user_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'Center_location/ajax_delete_user_center_head',
		async: true,
		type: 'post',
		data: { center_id: center_id, user_id: user_id },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				window.location.href = window.location.href
			}
		}
	});
}
function deleteUserCenterVisaManagements(center_id, user_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'Center_location/ajax_delete_user_center_visa_managements',
		async: true,
		type: 'post',
		data: { center_id: center_id, user_id: user_id },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				window.location.href = window.location.href
			}
		}
	});
}
function deleteUserCenterAcademyManagements(center_id, user_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'Center_location/ajax_delete_user_center_academy_managements',
		async: true,
		type: 'post',
		data: { center_id: center_id, user_id: user_id },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				window.location.href = window.location.href
			}
		}
	});
}
function deleteUserDivision(division_id, user_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'User/delete_user_division_',
		async: true,
		type: 'post',
		data: { division_id: division_id, user_id: user_id },
		dataType: 'json',
		success: function (response) {
			if (response == 1) {
				//alert(response)
				window.location.href = window.location.href
			} else {
				//$(idd).html('');
			}
		}
	})
}
// code by neelu end
function loadFuntionalBranchListByDivision() {
	var division_ids = $('#division_id').val();
	$.ajax({
		url: WOSA_ADMIN_URL + 'center_location/ajax_loadFuntionalBranchListByDivision',
		async: true,
		type: 'post',
		data: { division_ids: division_ids },
		dataType: 'json',
		success: function (response) {
			$('.FuncBr').html(response);
			$('#center_id').selectpicker('refresh');
		}
	});
}
function getApplicablePromocode(student_id) {
	$('.OnapplyPromocodeMSG').html('');
	var selectedPackType = $('input[name="pack_cb"]:checked').val();
	var package_id = '';
	if (!selectedPackType) {
		selectedPackType = 'eb';
	}
	if (selectedPackType == 'offline') {
		package_id = $("#package_id_off").val();
	} else if (selectedPackType == 'online') {
		package_id = $("#package_id").val();
	} else if (selectedPackType == 'pp') {
		package_id = $("#package_id_pp").val();
	} else if (selectedPackType == 'rt') {
		package_id = $("#reality_test_id_dd").val();
	} else if (selectedPackType == 'eb') {
		student_package_id = $('#student_package_id').val();
		$.ajax({
			url: WOSA_ADMIN_URL + 'student/ajax_getExamPackageId',
			async: true,
			type: 'post',
			data: { student_package_id: student_package_id },
			dataType: 'json',
			success: function (response) {
				package_id = response.package_id
				$.ajax({
					url: WOSA_ADMIN_URL + 'discount/ajax_getApplicablePromocode',
					async: true,
					type: 'post',
					data: { student_id: student_id, selectedPackType: selectedPackType, package_id: package_id },
					dataType: 'json',
					success: function (response) {
						//alert(response.promocode)
						$('.promocode_response').html(response.promocode);
						$('.special_promocode_response').html(response.special_promocode);
					}
				});
			}
		});
	} else {
		package_id = 0;
	}
	if (selectedPackType != 'eb') {
		$.ajax({
			url: WOSA_ADMIN_URL + 'discount/ajax_getApplicablePromocode',
			async: true,
			type: 'post',
			data: { student_id: student_id, selectedPackType: selectedPackType, package_id: package_id },
			dataType: 'json',
			success: function (response) {
				//alert(response.promocode)
				$('.promocode_response').html(response.promocode);
				$('.special_promocode_response').html(response.special_promocode);
			}
		});
	}
}
//bulk
function applyBulkPromocode() {
	$('.OnapplyPromocodeMSG').html('');
	var bulk_promocode = $('#bulk_promocode').val();
	var selectedPackType = $('input[name="pack_cb"]:checked').val();
	var student_id = $('#student_id').val();
	var package_id = '';
	//////////////////////////////////////////////////////////
	if (!selectedPackType) {
		selectedPackType = 'eb';
	}
	if (selectedPackType == 'offline') {
		package_id = $("#package_id_off").val();
	} else if (selectedPackType == 'online') {
		package_id = $("#package_id").val();
	} else if (selectedPackType == 'pp') {
		package_id = $("#package_id_pp").val();
	} else if (selectedPackType == 'rt') {
		package_id = $("#reality_test_id_dd").val();
	} else if (selectedPackType == 'ws') {
		//pending
	} else if (selectedPackType == 'eb') {
		student_package_id = $('#student_package_id').val();
		$.ajax({
			url: WOSA_ADMIN_URL + 'student/ajax_getExamPackageId',
			async: true,
			type: 'post',
			data: { student_package_id: student_package_id },
			dataType: 'json',
			success: function (response) {
				package_id = response.package_id
				$.ajax({
					url: WOSA_ADMIN_URL + 'discount/ajax_isApplicableBulkPromocode',
					async: true,
					type: 'post',
					data: { student_id: student_id, selectedPackType: selectedPackType, package_id: package_id, bulk_promocode: bulk_promocode },
					dataType: 'json',
					success: function (response) {
						//alert(response.promocode)
						if (response.promocode > 0) {
							//Get bulk promocode id start
							$.ajax({
								url: WOSA_ADMIN_URL + 'discount/ajax_getBulkPromocodeId',
								async: true,
								type: 'post',
								data: { bulk_promocode: bulk_promocode, selectedPackType: selectedPackType },
								dataType: 'json',
								success: function (response) {
									if (response.discount_id == 0) {
										$(".bulk_promocode_response").html('<span class="text-danger">Invalid bulk code!</span>');
									} else {
										$(".bulk_promocode_response").html('');
										promoCodeId = response.discount_id
										bulk_id = response.bulk_id
										//////////////////33333//////////////////
										if (selectedPackType == 'offline') {
											discountField = 'other_discount_off';
										} else if (selectedPackType == 'online') {
											discountField = 'other_discount';
										} else if (selectedPackType == 'pp') {
											discountField = 'other_discount_pp';
										} else if (selectedPackType == 'rt') {
											discountField = 'other_discount_rt';
										} else if (selectedPackType == 'ws') {
											//pending
										} else if (selectedPackType == 'eb') {
											discountField = 'other_discount_pbf';
										} else {
											discountField = '';
										}
										$.ajax({
											url: WOSA_ADMIN_URL + 'discount/ajax_getPromoCodeDetails',
											async: true,
											type: 'post',
											data: { promoCodeId: promoCodeId },
											dataType: 'json',
											success: function (response) {
												uses_per_user = 1;
												currency = response.promoCodeDetails.currency_code;
												//alert(currency)
												//1-check student-promocode validity start
												$.ajax({
													url: WOSA_ADMIN_URL + 'discount/ajax_studentBulkPromocodeValidity',
													async: true,
													type: 'post',
													data: { promoCodeId: promoCodeId, student_id: student_id, bulk_id: bulk_id },
													dataType: 'json',
													success: function (response1) {
														promocodeUsedCounts = response1.promocodeUsedCounts;
														if (promocodeUsedCounts < uses_per_user) {
															//2-check range exist or not start
															$.ajax({
																url: WOSA_ADMIN_URL + 'discount/ajax_checkrangeCount',
																async: true,
																type: 'post',
																data: { promoCodeId: promoCodeId },
																dataType: 'json',
																success: function (response2) {
																	rangeCount = response2.rangeCount;
																	var calculatedDiscount = 0;
																	if (rangeCount > 0) {
																		//alert('Have discount ranges');
																		//3- get final range discount start
																		if (selectedPackType != 'eb') {
																			packPrice = $("#packPrice").val();
																		} else {
																			packPrice = $("#exam_booking_price").val();
																			packPrice = packPrice.replace(/\,/g, '');
																			packPrice = parseInt(packPrice);
																		}
																		$.ajax({
																			url: WOSA_ADMIN_URL + 'discount/ajax_getFinalRangeDiscount',
																			async: true,
																			type: 'post',
																			data: { promoCodeId: promoCodeId, packPrice: packPrice },
																			dataType: 'json',
																			success: function (response3) {
																				discount_type = response.promoCodeDetails.discount_type;
																				if (discount_type == 'Percentage') {
																					not_exceeding = response.promoCodeDetails.not_exceeding;
																					max_discount = response3.finalDiscount;
																					if (!max_discount || max_discount == 'null') {
																						max_discount = response.promoCodeDetails.max_discount;
																					}
																					calculatedDiscount = (packPrice * max_discount) / 100;
																					if (calculatedDiscount > not_exceeding) {
																						calculatedDiscount = not_exceeding;
																					}
																					calculatedDiscount = Math.round(calculatedDiscount);
																					restAmount = packPrice - calculatedDiscount;
																					text = discountField;
																					amount_paid_field = text.replace("other_discount", "amount_paid");
																					$('#' + amount_paid_field).val(restAmount);
																					$('#' + discountField).val(calculatedDiscount);
																					$('#balanceLeft').text(restAmount);
																					$('.OnapplyPromocodeMSG').html('<span class="text-success">Great! Promocode applied successfully.You recieved ' + calculatedDiscount + ' ' + currency + ' discount </span>');
																					$('#bulk_promoCodeId_val').val(promoCodeId);
																					$('#bulk_id').val(bulk_id);
																				} else if (discount_type == 'Amount') {
																					not_exceeding = '';
																					max_discount = response3.finalDiscount;
																					calculatedDiscount = max_discount;
																					calculatedDiscount = Math.round(calculatedDiscount);
																					restAmount = packPrice - calculatedDiscount;
																					text = discountField;
																					amount_paid_field = text.replace("other_discount", "amount_paid");
																					$('#' + amount_paid_field).val(restAmount);
																					$('#' + discountField).val(calculatedDiscount);
																					$('#balanceLeft').text(restAmount);
																					$('.OnapplyPromocodeMSG').html('<span class="text-success">Great! Promocode applied successfully..You recieved ' + calculatedDiscount + '  ' + currency + ' discount</span>');
																					$('#bulk_promoCodeId_val').val(promoCodeId);
																					$('#bulk_id').val(bulk_id);
																				} else {
																					not_exceeding = '';
																					max_discount = '';
																					calculatedDiscount = 0;
																					$('#' + discountField).val(calculatedDiscount);
																					$('.OnapplyPromocodeMSG').html('<span class="text-success">Error! Something wrong. please refresh page and try again.</span>');
																					$('#bulk_promoCodeId_val').val('');
																					$('#bulk_id').val('');
																				}
																			}
																		});
																		//3- get final range discount end
																	} else {
																		//alert('No discount range');
																		if (selectedPackType != 'eb') {
																			packPrice = $("#packPrice").val();
																		} else {
																			packPrice = $("#exam_booking_price").val();
																			packPrice = packPrice.replace(/\,/g, '');
																			packPrice = parseInt(packPrice);
																		}
																		discount_type = response.promoCodeDetails.discount_type;
																		if (discount_type == 'Percentage') {
																			not_exceeding = response.promoCodeDetails.not_exceeding;
																			max_discount = response.promoCodeDetails.max_discount;
																			calculatedDiscount = (packPrice * max_discount) / 100;
																			if (calculatedDiscount > not_exceeding) {
																				calculatedDiscount = not_exceeding;
																			}
																			calculatedDiscount = Math.round(calculatedDiscount);
																			restAmount = packPrice - calculatedDiscount;
																			text = discountField;
																			amount_paid_field = text.replace("other_discount", "amount_paid");
																			$('#' + amount_paid_field).val(restAmount);
																			$('#' + discountField).val(calculatedDiscount);
																			$('#balanceLeft').text(restAmount);
																			$('.OnapplyPromocodeMSG').html('<span class="text-success">Great! Promocode applied successfully.You recieved ' + calculatedDiscount + '  ' + currency + ' discount </span>');
																			$('#bulk_promoCodeId_val').val(promoCodeId);
																			$('#bulk_id').val(bulk_id);
																		} else if (discount_type == 'Amount') {
																			not_exceeding = '';
																			max_discount = response.promoCodeDetails.max_discount;
																			calculatedDiscount = max_discount;
																			calculatedDiscount = Math.round(calculatedDiscount);
																			restAmount = packPrice - calculatedDiscount;
																			text = discountField;
																			amount_paid_field = text.replace("other_discount", "amount_paid");
																			$('#' + amount_paid_field).val(restAmount);
																			$('#' + discountField).val(calculatedDiscount);
																			$('#balanceLeft').text(restAmount);
																			$('.OnapplyPromocodeMSG').html('<span class="text-success">Great! Promocode applied successfully..You recieved ' + calculatedDiscount + '  ' + currency + ' discount</span>');
																			$('#bulk_promoCodeId_val').val(promoCodeId);
																			$('#bulk_id').val(bulk_id);
																		} else {
																			not_exceeding = '';
																			max_discount = '';
																			calculatedDiscount = 0;
																			$('#' + discountField).val(calculatedDiscount);
																			$('.OnapplyPromocodeMSG').html('<span class="text-success">Error! Something wrong. please refresh page and try again.</span>');
																			$('#bulk_promoCodeId_val').val();
																			$('#bulk_id').val();
																		}
																		remaining_uses = response.promoCodeDetails.remaining_uses;
																	}
																}
															});
															//2-check range exist or not end
														} else {
															$('#' + discountField).val(0);
															$('.OnapplyPromocodeMSG').html('<span class="text-danger">Invalid! Already used all limts.</span>');
															$('#bulk_promoCodeId_val').val();
															$('#bulk_id').val();
														}
													}
												});
												//1-check student-promocode validity end
											}
										});
										///////////////////333333////////////////
									}
								}
							});
							//Get bulk promocode id end
						} else {
							$(".bulk_promocode_response").html('<span class="text-danger">Not applicable code!</span>');
						}
					}
				});
			}
		});
	} else {
		package_id = 0;
	}
	if (selectedPackType != 'eb') {
		$.ajax({
			url: WOSA_ADMIN_URL + 'discount/ajax_isApplicableBulkPromocode',
			async: true,
			type: 'post',
			data: { student_id: student_id, selectedPackType: selectedPackType, package_id: package_id, bulk_promocode: bulk_promocode },
			dataType: 'json',
			success: function (response) {
				//alert(response.promocode)
				if (response.promocode > 0) {
					//Get bulk promocode id start
					$.ajax({
						url: WOSA_ADMIN_URL + 'discount/ajax_getBulkPromocodeId',
						async: true,
						type: 'post',
						data: { bulk_promocode: bulk_promocode, selectedPackType: selectedPackType },
						dataType: 'json',
						success: function (response) {
							if (response.discount_id == 0) {
								$(".bulk_promocode_response").html('<span class="text-danger">Invalid bulk code!</span>');
							} else {
								$(".bulk_promocode_response").html('');
								promoCodeId = response.discount_id
								bulk_id = response.bulk_id
								//////////////////3333333//////////////////
								if (selectedPackType == 'offline') {
									discountField = 'other_discount_off';
								} else if (selectedPackType == 'online') {
									discountField = 'other_discount';
								} else if (selectedPackType == 'pp') {
									discountField = 'other_discount_pp';
								} else if (selectedPackType == 'rt') {
									discountField = 'other_discount_rt';
								} else if (selectedPackType == 'ws') {
									//pending
								} else if (selectedPackType == 'eb') {
									discountField = 'other_discount_pbf';
								} else {
									discountField = '';
								}
								$.ajax({
									url: WOSA_ADMIN_URL + 'discount/ajax_getPromoCodeDetails',
									async: true,
									type: 'post',
									data: { promoCodeId: promoCodeId },
									dataType: 'json',
									success: function (response) {
										uses_per_user = 1;
										currency = response.promoCodeDetails.currency_code;
										//alert(currency)
										//1-check student-promocode validity start
										$.ajax({
											url: WOSA_ADMIN_URL + 'discount/ajax_studentBulkPromocodeValidity',
											async: true,
											type: 'post',
											data: { promoCodeId: promoCodeId, student_id: student_id, bulk_id: bulk_id },
											dataType: 'json',
											success: function (response1) {
												promocodeUsedCounts = response1.promocodeUsedCounts;
												if (promocodeUsedCounts < uses_per_user) {
													//2-check range exist or not start
													$.ajax({
														url: WOSA_ADMIN_URL + 'discount/ajax_checkrangeCount',
														async: true,
														type: 'post',
														data: { promoCodeId: promoCodeId },
														dataType: 'json',
														success: function (response2) {
															rangeCount = response2.rangeCount;
															var calculatedDiscount = 0;
															if (rangeCount > 0) {
																//alert('Have discount ranges');
																//3- get final range discount start
																if (selectedPackType != 'eb') {
																	packPrice = $("#packPrice").val();
																} else {
																	packPrice = $("#exam_booking_price").val();
																	packPrice = packPrice.replace(/\,/g, '');
																	packPrice = parseInt(packPrice);
																}
																$.ajax({
																	url: WOSA_ADMIN_URL + 'discount/ajax_getFinalRangeDiscount',
																	async: true,
																	type: 'post',
																	data: { promoCodeId: promoCodeId, packPrice: packPrice },
																	dataType: 'json',
																	success: function (response3) {
																		discount_type = response.promoCodeDetails.discount_type;
																		if (discount_type == 'Percentage') {
																			not_exceeding = response.promoCodeDetails.not_exceeding;
																			max_discount = response3.finalDiscount;
																			if (!max_discount || max_discount == 'null') {
																				max_discount = response.promoCodeDetails.max_discount;
																			}
																			calculatedDiscount = (packPrice * max_discount) / 100;
																			if (calculatedDiscount > not_exceeding) {
																				calculatedDiscount = not_exceeding;
																			}
																			calculatedDiscount = Math.round(calculatedDiscount);
																			restAmount = packPrice - calculatedDiscount;
																			text = discountField;
																			amount_paid_field = text.replace("other_discount", "amount_paid");
																			$('#' + amount_paid_field).val(restAmount);
																			$('#' + discountField).val(calculatedDiscount);
																			$('#balanceLeft').text(restAmount);
																			$('.OnapplyPromocodeMSG').html('<span class="text-success">Great! Promocode applied successfully.You recieved ' + calculatedDiscount + ' ' + currency + ' discount </span>');
																			$('#bulk_promoCodeId_val').val(promoCodeId);
																			$('#bulk_id').val(bulk_id);
																		} else if (discount_type == 'Amount') {
																			not_exceeding = '';
																			max_discount = response3.finalDiscount;
																			calculatedDiscount = max_discount;
																			calculatedDiscount = Math.round(calculatedDiscount);
																			restAmount = packPrice - calculatedDiscount;
																			text = discountField;
																			amount_paid_field = text.replace("other_discount", "amount_paid");
																			$('#' + amount_paid_field).val(restAmount);
																			$('#' + discountField).val(calculatedDiscount);
																			$('#balanceLeft').text(restAmount);
																			$('.OnapplyPromocodeMSG').html('<span class="text-success">Great! Promocode applied successfully..You recieved ' + calculatedDiscount + '  ' + currency + ' discount</span>');
																			$('#bulk_promoCodeId_val').val(promoCodeId);
																			$('#bulk_id').val(bulk_id);
																		} else {
																			not_exceeding = '';
																			max_discount = '';
																			calculatedDiscount = 0;
																			$('#' + discountField).val(calculatedDiscount);
																			$('.OnapplyPromocodeMSG').html('<span class="text-success">Error! Something wrong. please refresh page and try again.</span>');
																			$('#bulk_promoCodeId_val').val('');
																			$('#bulk_id').val('');
																		}
																	}
																});
																//3- get final range discount end
															} else {
																//alert('No discount range');
																if (selectedPackType != 'eb') {
																	packPrice = $("#packPrice").val();
																} else {
																	packPrice = $("#exam_booking_price").val();
																	packPrice = packPrice.replace(/\,/g, '');
																	packPrice = parseInt(packPrice);
																}
																discount_type = response.promoCodeDetails.discount_type;
																if (discount_type == 'Percentage') {
																	not_exceeding = response.promoCodeDetails.not_exceeding;
																	max_discount = response.promoCodeDetails.max_discount;
																	calculatedDiscount = (packPrice * max_discount) / 100;
																	if (calculatedDiscount > not_exceeding) {
																		calculatedDiscount = not_exceeding;
																	}
																	calculatedDiscount = Math.round(calculatedDiscount);
																	restAmount = packPrice - calculatedDiscount;
																	text = discountField;
																	amount_paid_field = text.replace("other_discount", "amount_paid");
																	$('#' + amount_paid_field).val(restAmount);
																	$('#' + discountField).val(calculatedDiscount);
																	$('#balanceLeft').text(restAmount);
																	$('.OnapplyPromocodeMSG').html('<span class="text-success">Great! Promocode applied successfully.You recieved ' + calculatedDiscount + '  ' + currency + ' discount </span>');
																	$('#bulk_promoCodeId_val').val(promoCodeId);
																	$('#bulk_id').val(bulk_id);
																} else if (discount_type == 'Amount') {
																	not_exceeding = '';
																	max_discount = response.promoCodeDetails.max_discount;
																	calculatedDiscount = max_discount;
																	calculatedDiscount = Math.round(calculatedDiscount);
																	restAmount = packPrice - calculatedDiscount;
																	text = discountField;
																	amount_paid_field = text.replace("other_discount", "amount_paid");
																	$('#' + amount_paid_field).val(restAmount);
																	$('#' + discountField).val(calculatedDiscount);
																	$('#balanceLeft').text(restAmount);
																	$('.OnapplyPromocodeMSG').html('<span class="text-success">Great! Promocode applied successfully..You recieved ' + calculatedDiscount + '  ' + currency + ' discount</span>');
																	$('#bulk_promoCodeId_val').val(promoCodeId);
																	$('#bulk_id').val(bulk_id);
																} else {
																	not_exceeding = '';
																	max_discount = '';
																	calculatedDiscount = 0;
																	$('#' + discountField).val(calculatedDiscount);
																	$('.OnapplyPromocodeMSG').html('<span class="text-success">Error! Something wrong. please refresh page and try again.</span>');
																	$('#bulk_promoCodeId_val').val();
																	$('#bulk_id').val();
																}
																remaining_uses = response.promoCodeDetails.remaining_uses;
															}
														}
													});
													//2-check range exist or not end
												} else {
													$('#' + discountField).val(0);
													$('.OnapplyPromocodeMSG').html('<span class="text-danger">Invalid! Already used all limts.</span>');
													$('#bulk_promoCodeId_val').val();
													$('#bulk_id').val();
												}
											}
										});
										//1-check student-promocode validity end
									}
								});
								///////////////////333333////////////////
							}
						}
					});
					//Get bulk promocode id end
				} else {
					$(".bulk_promocode_response").html('<span class="text-danger">Not applicable code!</span>');
				}
			}
		});
	}
	/////////////////////////////////////////////////////
}
function showRange(id) {
	//alert(id);
	$.ajax({
		url: WOSA_ADMIN_URL + 'discount/ajax_showRange',
		async: true,
		type: 'post',
		data: { id: id },
		dataType: 'json',
		success: function (response) {
			//alert(response.range)
			$('.range_response').html(response.range);
		}
	});
}
function removePromocode(discountField) {
	var field = '#' + discountField
	$(field).val(0);
	text = discountField;
	amount_paid_field = text.replace("other_discount", "amount_paid");
	$('#' + amount_paid_field).val('');
}
function applyPromoCode(promoCodeId, discountField, student_id) {
	if (discountField == 'other_discount_off') {
		selectedPackType = 'offline';
	} else if (discountField == 'other_discount') {
		selectedPackType = 'online';
	} else if (discountField == 'other_discount_pp') {
		selectedPackType = 'pp';
	} else if (discountField == 'other_discount_rt') {
		selectedPackType = 'rt';
	} else if (discountField == 'workshop_id_dd') {
		selectedPackType = 'ws';
	} else if (discountField == 'other_discount_pbf') {
		selectedPackType = 'eb';
	} else {
		selectedPackType = '';
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'discount/ajax_getPromoCodeDetails',
		async: true,
		type: 'post',
		data: { promoCodeId: promoCodeId },
		dataType: 'json',
		success: function (response) {
			uses_per_user = response.promoCodeDetails.uses_per_user;
			currency = response.promoCodeDetails.currency_code;
			//alert(currency)
			//1-check student-promocode validity start
			$.ajax({
				url: WOSA_ADMIN_URL + 'discount/ajax_studentPromocodeValidity',
				async: true,
				type: 'post',
				data: { promoCodeId: promoCodeId, student_id: student_id },
				dataType: 'json',
				success: function (response1) {
					promocodeUsedCounts = response1.promocodeUsedCounts;
					if (promocodeUsedCounts < uses_per_user) {
						//2-check range exist or not start
						$.ajax({
							url: WOSA_ADMIN_URL + 'discount/ajax_checkrangeCount',
							async: true,
							type: 'post',
							data: { promoCodeId: promoCodeId },
							dataType: 'json',
							success: function (response2) {
								rangeCount = response2.rangeCount;
								var calculatedDiscount = 0;
								if (rangeCount > 0) {
									//alert('Have discount ranges');
									//3- get final range discount start
									if (selectedPackType != 'eb') {
										packPrice = $("#packPrice").val();
									} else {
										packPrice = $("#exam_booking_price").val();
										packPrice = packPrice.replace(/\,/g, '');
										packPrice = parseInt(packPrice);
									}
									$.ajax({
										url: WOSA_ADMIN_URL + 'discount/ajax_getFinalRangeDiscount',
										async: true,
										type: 'post',
										data: { promoCodeId: promoCodeId, packPrice: packPrice },
										dataType: 'json',
										success: function (response3) {
											discount_type = response.promoCodeDetails.discount_type;
											if (discount_type == 'Percentage') {
												not_exceeding = response.promoCodeDetails.not_exceeding;
												max_discount = response3.finalDiscount;
												if (!max_discount || max_discount == 'null') {
													max_discount = response.promoCodeDetails.max_discount;
												}
												calculatedDiscount = (packPrice * max_discount) / 100;
												if (calculatedDiscount > not_exceeding) {
													calculatedDiscount = not_exceeding;
												}
												calculatedDiscount = Math.round(calculatedDiscount);
												restAmount = packPrice - calculatedDiscount;
												text = discountField;
												amount_paid_field = text.replace("other_discount", "amount_paid");
												$('#' + amount_paid_field).val(restAmount);
												$('#' + discountField).val(calculatedDiscount);
												$('#balanceLeft').text(restAmount);
												$('.OnapplyPromocodeMSG').html('<span class="text-success">Great! Promocode applied successfully.You recieved ' + calculatedDiscount + ' ' + currency + ' discount </span>');
												$('#promoCodeId_val').val(promoCodeId);
											} else if (discount_type == 'Amount') {
												not_exceeding = '';
												max_discount = response3.finalDiscount;
												calculatedDiscount = max_discount;
												calculatedDiscount = Math.round(calculatedDiscount);
												restAmount = packPrice - calculatedDiscount;
												text = discountField;
												amount_paid_field = text.replace("other_discount", "amount_paid");
												$('#' + amount_paid_field).val(restAmount);
												$('#' + discountField).val(calculatedDiscount);
												$('#balanceLeft').text(restAmount);
												$('.OnapplyPromocodeMSG').html('<span class="text-success">Great! Promocode applied successfully..You recieved ' + calculatedDiscount + '  ' + currency + ' discount</span>');
												$('#promoCodeId_val').val(promoCodeId);
											} else {
												not_exceeding = '';
												max_discount = '';
												calculatedDiscount = 0;
												$('#' + discountField).val(calculatedDiscount);
												$('.OnapplyPromocodeMSG').html('<span class="text-success">Error! Something wrong. please refresh page and try again.</span>');
												$('#promoCodeId_val').val('');
											}
										}
									});
									//3- get final range discount end
								} else {
									//alert('No discount range');
									if (selectedPackType != 'eb') {
										packPrice = $("#packPrice").val();
									} else {
										packPrice = $("#exam_booking_price").val();
										packPrice = packPrice.replace(/\,/g, '');
										packPrice = parseInt(packPrice);
									}
									discount_type = response.promoCodeDetails.discount_type;
									if (discount_type == 'Percentage') {
										not_exceeding = response.promoCodeDetails.not_exceeding;
										max_discount = response.promoCodeDetails.max_discount;
										calculatedDiscount = (packPrice * max_discount) / 100;
										if (calculatedDiscount > not_exceeding) {
											calculatedDiscount = not_exceeding;
										}
										calculatedDiscount = Math.round(calculatedDiscount);
										restAmount = packPrice - calculatedDiscount;
										text = discountField;
										amount_paid_field = text.replace("other_discount", "amount_paid");
										$('#' + amount_paid_field).val(restAmount);
										$('#' + discountField).val(calculatedDiscount);
										$('#balanceLeft').text(restAmount);
										$('.OnapplyPromocodeMSG').html('<span class="text-success">Great! Promocode applied successfully.You recieved ' + calculatedDiscount + '  ' + currency + ' discount </span>');
										$('#promoCodeId_val').val(promoCodeId);
									} else if (discount_type == 'Amount') {
										not_exceeding = '';
										max_discount = response.promoCodeDetails.max_discount;
										calculatedDiscount = max_discount;
										calculatedDiscount = Math.round(calculatedDiscount);
										restAmount = packPrice - calculatedDiscount;
										text = discountField;
										amount_paid_field = text.replace("other_discount", "amount_paid");
										$('#' + amount_paid_field).val(restAmount);
										$('#' + discountField).val(calculatedDiscount);
										$('#balanceLeft').text(restAmount);
										$('.OnapplyPromocodeMSG').html('<span class="text-success">Great! Promocode applied successfully..You recieved ' + calculatedDiscount + '  ' + currency + ' discount</span>');
										$('#promoCodeId_val').val(promoCodeId);
									} else {
										not_exceeding = '';
										max_discount = '';
										calculatedDiscount = 0;
										$('#' + discountField).val(calculatedDiscount);
										$('.OnapplyPromocodeMSG').html('<span class="text-success">Error! Something wrong. please refresh page and try again.</span>');
										$('#promoCodeId_val').val();
									}
									remaining_uses = response.promoCodeDetails.remaining_uses;
								}
							}
						});
						//2-check range exist or not end
					} else {
						$('#' + discountField).val(0);
						$('.OnapplyPromocodeMSG').html('<span class="text-danger">Invalid! Already used all limts.</span>');
						$('#promoCodeId_val').val();
					}
				}
			});
			//1-check student-promocode validity end
		}
	});
}
//Start Code Add By Neelu Free resources  module
var today = new Date();
$('#session_date').daterangepicker(
	{
		locale: {
			format: 'YYYY-MM-DD'
		},
		minDate: today
	},
	function (start, end, label) {
		//alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	});
$('#offer_date').daterangepicker(
	{
		locale: {
			format: 'DD-MM-YYYY'
		},
		minDate: today
	},
	function (start, end, label) {
		//alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	});
$('#marketing_date').daterangepicker(
	{
		locale: {
			format: 'DD-MM-YYYY'
		},
		minDate: today
	},
	function (start, end, label) {
		//alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	});
updateResourcesSectionCkEditer();
function updateResourcesSectionCkEditer() {
	var i = 1;
	$("#EmployeeTierId .employeeTierDiv").each(function () {
		type = $(this).find('.section_type').val();
		if (type == 'text') {
			// CKEDITOR.replace('free_resources_section' + i);
			checkWordCountCkEditor('free_resources_section'+i);
		}
		i++;
	});
}
updateClassroomDocumentsCkEditer();
function updateClassroomDocumentsCkEditer() {
	var i = 1;
	$("#EmployeeTierId .ClassroomDocumentsDiv").each(function () {
		type = $(this).find('.section_type').val();
		if (type == 'text') {
			// CKEDITOR.replace('classroom_documents_section' + i);
			checkWordCountCkEditor('classroom_documents_section'+i);
		}
		i++;
	});
}
//End Add By Neelu Free resources  module
function fillsessionBookingId(booking_id) {
	//alert(booking_id)
	$("#session_booking_id").val(booking_id)
}
function check_counselling_form_validation() {
	$("#session_type option[value='']").attr("selected", "selected");
	$('#session_type').selectpicker('refresh');
	$("#test_module_id option[value='']").attr("selected", "selected");
	$('#test_module_id').selectpicker('refresh');
	$("#center_id option[value='']").attr("selected", "selected");
	$('#center_id').selectpicker('refresh');
	$('#date_from').val('');
	$('#date_to').val('');
	$("#is_attended option[value='']").attr("selected", "selected");
	$('#is_attended').selectpicker('refresh');
	$('.STclass').prop('disabled', true);
}
function reset_counselling_form() {
	$('.STclass').prop('disabled', false);
	$('.UIDclass').prop('disabled', false);
}
function show_classroom_desc(classroomname, classroom_id,student_id) {
	$.ajax({
		url: WOSA_ADMIN_URL + 'classroom/ajax_show_classroom_desc',
		async: false,
		type: 'post',
		data: { classroomname: classroomname, classroom_id: classroom_id },
		success: function (response) {	
		$("#showdata_"+student_id).attr("title", response)		
		}
	});
}
function getUserSpecialAccess(user_id, role_id, role_name) {
	$('#user_id_spl_acc').val(user_id);
	$('#role_id_hidden').val(role_id);
	$.ajax({
		url: WOSA_ADMIN_URL + 'user/ajax_getUserSpecialAccess',
		async: false,
		type: 'post',
		data: { user_id: user_id, role_id: role_id },
		success: function (response) {
			if (response.roldDD) {
				role_dd = response.roldDD;
			} else {
			}
			$('.ri').html(role_dd);
			$('#role_id').selectpicker('refresh');
			if (response.user_test_module) {
				$('.user_test_module').html(response.user_test_module);
			}
			if (response.user_programe) {
				$('.user_programe').html(response.user_programe);
			}
			if (response.user_batch) {
				$('.user_batch').html(response.user_batch);
			}
			if (response.user_category) {
				$('.user_category').html(response.user_category);
			}
			$('#portal_access_hidden').val(response.portal_access);
			if (response.portal_access == 1) {
				portal_access = '<select name="portal_access" id="portal_access" class="form-control" onchange="sendMailOnPortalAccess(this.value)"><option value="">Select</option><option value="1" selected="selected">Yes</option><option value="0">No</option></select><span class="text-danger portal_access_err"></span>';
			} else {
				portal_access = '<select name="portal_access" id="portal_access" class="form-control" onchange="sendMailOnPortalAccess(this.value)"><option value="">Select</option><option value="1">Yes</option><option value="0" selected="selected">No</option></select><span class="text-danger portal_access_err"></span>';
			}
			$('.pa').html(portal_access);
			if (response.waiver_power == 1) {
				waiver_power = '<select name="waiver_power" id="waiver_power" class="form-control" onchange="reflectWaiverUpto(this.value)"><option value="">Select</option><option value="1" selected="selected">Yes</option><option value="0">No</option></select><span class="text-danger waiver_power_err"></span>';
			} else {
				waiver_power = '<select name="waiver_power" id="waiver_power" class="form-control" onchange="reflectWaiverUpto(this.value)"><option value="">Select</option><option value="1">Yes</option><option value="0" selected="selected">No</option></select><span class="text-danger waiver_power_err"></span>';
			}
			$('.wp').html(waiver_power);
			if (response.waiver_upto > 0) {
				waiver_upto_field = '<input type="text" name="waiver_upto" id="waiver_upto" value=' + response.waiver_upto + ' class="form-control chknum1"><span class="text-danger waiver_upto_err"></span>';
			} else {
				var waiver_upto_val = 0;
				waiver_upto_field = '<input type="text" name="waiver_upto" id="waiver_upto" value=' + waiver_upto_val + ' class="form-control chknum1"><span class="text-danger waiver_upto_err"></span>';
			}
			$('.wut').html(waiver_upto_field);
			if (response.refund_power == 1) {
				refund_power = '<select name="refund_power" id="refund_power" class="form-control"><option value="">Select</option><option value="1" selected="selected">Yes</option><option value="0">No</option></select><span class="text-danger refund_power_err"></span>';
			} else {
				refund_power = '<select name="refund_power" id="refund_power" class="form-control"><option value="">Select</option><option value="1">Yes</option><option value="0" selected="selected">No</option></select><span class="text-danger refund_power_err"></span>';
			}
			$('.rp').html(refund_power);
		}
	});
}
function sendMailOnPortalAccess(portal_access) {
	//alert(portal_access)
	if (portal_access == 1) {
		$('.sendMail_pa_class').show();
	} else {
		$('.sendMail_pa_class').hide();
	}
}
function reflectWaiverUpto(val) {
	if (val == 1) {
		$('#waiver_upto').prop('disabled', false)
	} else {
		$('#waiver_upto').prop('disabled', true)
	}
}
$('.datepicker').datepicker({
	format: 'yyyy-mm-dd'
});
function validate_employee_form() {
	var page = $("#page").val();
	if ($("#employeeCode").val() == "") {
		$('.employeeCode_err').text('Please enter employeeCode');
		$('#employeeCode').focus();
		return false;
	} else {
		$('.employeeCode_err').text('');
	}
	var media_file = $("#image").val();
	if (media_file != '') {
		var ext = $('#image').val().split('.').pop().toLowerCase();
		if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
			$('.image_err').text('Please upload valid file format');
			$('#image').focus();
			return false;
		} else {
			$('.image_err').text('');
		}
	} else {
		$('.image_err').text('');
	}
	if ($("#fname").val() == "") {
		$('.fname_err').text('Please enter first name');
		$('#fname').focus();
		return false;
	} else {
		$('.fname_err').text('');
	}
	if ($("#gender_name").val() == "") {
		$('.gender_name_err').text('Please select gender');
		$('#gender_name').focus();
		return false;
	} else {
		$('.gender_name_err').text('');
	}
	var dob = $("#dob").val();
	if (dob == "") {
		$('.dob_err').text('Please enter DOB');
		//$('#dob').focus();
		return false;
	} else {
		$('.dob_err').text('');
	}
	var d1 = new Date(); //today
	var d2 = new Date(dob); //dob
	var diff = d1.getTime() - d2.getTime();
	var dob_daydiff = diff / (1000 * 60 * 60 * 24);
	if (dob_daydiff <= 6570) {
		$('.dob_err').text('Employee age must be 18 Years or greater');
		return false;
	} else {
		$('.dob_err').text('');
	}
	var doj = $("#DOJ").val();
	if ($("#DOJ").val() == "") {
		$('.DOJ_err').text('Please enter employee joining date');
		$('#DOJ').focus();
		return false;
	} else {
		$('.DOJ_err').text('');
	}
	var d3 = new Date(doj);
	var diff = d1.getTime() - d3.getTime();
	var doj_daydiff = diff / (2500 * 60 * 60 * 24);
	doj_daydiff = Math.abs(doj_daydiff)
	if (doj_daydiff > 1000) {
		$('.DOJ_err').text('Employee joining date must within 2500 days of range');
		return false;
	} else {
		$('.DOJ_err').text('');
	}
	if (page == 'edit') {
		var doe = $("#DOE").val();
		if (doe != '') {
			var d4 = new Date(doe); //dee
			var diff = d4.getTime() - d3.getTime();
			var doe_daydiff = diff / (1000 * 60 * 60 * 24);
			doe_daydiff = Math.abs(doe_daydiff)
			if (doe_daydiff <= 0) {
				$('.DOE_err').text('Employee exit date must greater than joining date');
				return false;
			} else {
				$('.DOE_err').text('');
			}
		} else {
		}
	}
	if ($("#personal_email").val() == "") {
		$('.email_err_p').text('Please enter employee persoanl email');
		$('#personal_email').focus();
		return false;
	} else {
		$('.email_err_p').text('');
	}
	if ($("#country_code_pers").val() == "") {
		$('.country_code_pers_err').text('Please select country code');
		$('#country_code_pers').focus();
		return false;
	} else {
		$('.country_code_pers_err').text('');
	}
	if ($("#personal_contact").val() == "") {
		$('.personal_contact_err').text('Please enter contact no.');
		$('#personal_contact').focus();
		return false;
	} else {
		$('.personal_contact_err').text('');
	}
	if ($("#center_id_home").val() == "") {
		$('.center_id_home_err').text('Please select home branch where he/she joined');
		$('#center_id_home').focus();
		return false;
	} else {
		$('.center_id_home_err').text('');
	}
	if ($("#emp_designation").val() == "") {
		$('.emp_designation_err').text('Please select designation');
		$('#emp_designation').focus();
		return false;
	} else {
		$('.emp_designation_err').text('');
	}
if($("#active").is(':checked'))
{
	var check_st=1
}
else {
	var check_st=0
}
	if($('#DOE').val() == "" && check_st ==0)
	{
		$('.DOE_err').text('Please enter employee exit date');
		$('#DOE').focus();
		$("#active").prop("checked", false);
		return false;
	}
	else{
		if(new Date($('#DOE').val()) <= new Date())
		{
			$("#active").prop("checked", false);
		}
		else {
			$("#active").prop("checked", true);
		}
	}
	if (page == "add") {
		if ($("#division_id").val() == "") {
			$('.division_id_err').text('Please select division');
			$('#division_id').focus();
			return false;
		} else {
			$('.division_id_err').text('');
		}
		if ($("#center_id").val() == "") {
			$('.center_id_err').text('Please select functional branch');
			$('#center_id').focus();
			return false;
		} else {
			$('.center_id_err').text('');
		}
	}
	var user_id = $("#userId_hidden").val();
	if (page == "edit") {
		$.ajax({
			url: WOSA_ADMIN_URL + 'user/ajax_check_user_division_count',
			async: false,
			type: 'post',
			data: { user_id: user_id },
			dataType: 'json',
			success: function (response) {
				if (response == 0) {
					if ($("#division_id").val() == "") {
						$('.division_id_err').text('Please select division');
						//$('#division_id').focus();
						$('.sbm').prop('disabled', true);
						return false;
					} else {
						$('.division_id_err').text('');
						$('.sbm').prop('disabled', false);
					}
				} else {
					$('.division_id_err').text('');
					$('.sbm').prop('disabled', false);
				}
			}
		});
	}
	/*if(page == "edit"){
		$.ajax({
			url: WOSA_ADMIN_URL+'user/ajax_check_user_functional_branch_count',
			async : false,
			type: 'post',
			data: {user_id: user_id},
			dataType: 'json',
			success: function(response){
				if(response==0){
					if($("#center_id").val() == ""){
						$('.center_id_err').text('Please select functional branch');
						$('#center_id').focus();
						$('.sbm').prop('disabled', true);
						return false;
					}else{
						$('.center_id_err').text('');
						$('.sbm').prop('disabled', false);
					}
				}else{
					$('.center_id_err').text('');
					$('.sbm').prop('disabled', false);
				}
			}
		});
	}*/
	if ($("#country_id2").val() == "") {
		$('.country_id2_err').text('Please select employee country as address');
		$('#country_id2').focus();
		return false;
	} else {
		$('.country_id2_err').text('');
	}
	if ($("#state_id").val() == "") {
		$('.state_id_err').text('Please select employee state');
		$('#state_id').focus();
		return false;
	} else {
		$('.state_id_err').text('');
	}
	if ($("#city_id").val() == "") {
		$('.city_id_err').text('Please select employee city');
		$('#city_id').focus();
		return false;
	} else {
		$('.city_id_err').text('');
	}
	if ($("#residential_address").val() == "") {
		$('.residential_address_err').text('Please enter residential address');
		$('#residential_address').focus();
		return false;
	} else {
		$('.residential_address_err').text('');
	}
}
function validate_file_type_stdWithdrawl(id) {
	var ext = $('#' + id).val().split('.').pop().toLowerCase();
	var id_err = id + '_err';
	if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'pdf']) == -1) {
		$('.' + id_err).text('Please upload valid file format');
		$('#' + id).val('');
		$('#' + id).focus();
		return false;
	} else {
		$('.' + id_err).text('');
	}
}
function validate_file_type_stdDoc(id) {
	var ext = $('#' + id).val().split('.').pop().toLowerCase();
	var id_err = id + '_err';
	if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'pdf']) == -1) {
		$('.' + id_err).text('Please upload valid file format');
		$('#' + id).val('');
		$('#' + id).focus();
		return false;
	} else {
		$('.' + id_err).text('');
	}
}
function validate_file_type_gallary(id) {
	//alert('k')
	var ext = $('#' + id).val().split('.').pop().toLowerCase();
	var id_err = id + '_err';
	if ($.inArray(ext, ['gif','png', 'jpg', 'jpeg', 'webp','svg','ico','mp4','mp3']) == -1) {
		$('.' + id_err).text('Please upload valid file format');
		$('#' + id).val('');
		$('#' + id).focus();
		return false;
	} else {
		rungallerycode();
		$('.' + id_err).text('');
		
	}
}
function validate_file_type_paymentSlip(id) {
	var ext = $('#' + id).val().split('.').pop().toLowerCase();
	var id_err = id + '_err';
	if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'pdf']) == -1) {
		$('.' + id_err).text('Please upload valid file format');
		$('#' + id).val('');
		$('#' + id).focus();
		return false;
	} else {
		$('.' + id_err).text('');
	}
}
function validate_file_type_paymentSlip_pp(id) {
	var ext = $('#' + id).val().split('.').pop().toLowerCase();
	var id_err = id + '_err';
	if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'pdf']) == -1) {
		$('.' + id_err).text('Please upload valid file format');
		$('#' + id).val('');
		$('#' + id).focus();
		return false;
	} else {
		$('.' + id_err).text('');
	}
}
function validate_file_type_packHold(id) {
	var ext = $('#' + id).val().split('.').pop().toLowerCase();
	var id_err = id + '_err';
	if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'pdf']) == -1) {
		$('.' + id_err).text('Please upload valid file format');
		$('#' + id).val('');
		$('.checkfile').html('Choose a file...');		
		$('#' + id).focus();
		return false;
	} else {
		$('.' + id_err).text('');
	}
}
function validate_file_type_Webp(id) {
	var ext = $('#' + id).val().split('.').pop().toLowerCase();
	var id_err = id + '_err';
	if ($.inArray(ext, ['webp']) == -1) {
		$('.' + id_err).text('Please upload valid file format');
		$('#' + id).val('');
		$('.checkfile').html('Choose a file...');		
		$('#' + id).focus();
		return false;
	} else {
		$('.' + id_err).text('');
	}
}
function validate_file_type_PJW(id) {
	var ext = $('#' + id).val().split('.').pop().toLowerCase();
	var id_err = id + '_err';
	if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'webp']) == -1) {
		$('.' + id_err).text('Please upload valid file format');
		$('#' + id).val('');
		$('.checkfile').html('Choose a file...');		
		$('#' + id).focus();
		return false;
	} else {
		$('.' + id_err).text('');
	}
}
function ValidURL(str,id) 
{
	var messcl=id+'_err';
	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
	if(!regexp.test(str))
	{
	$('.'+messcl).text("Please enter valid url");
	$('#video_url').val("");
	}
	else {
		$('.'+messcl).text("");
	}
}
function validate_file_type(id) {
	var ext = $('#' + id).val().split('.').pop().toLowerCase();
	var id_err = id + '_err';
	if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
		$('.' + id_err).text('Please upload valid file format');
		$('#' + id).val('');
		$('#' + id).focus();
		return false;
	} else {
		$('.' + id_err).text('');
	}
}
function validate_file_type_svg(id) {
	var ext = $('#' + id).val().split('.').pop().toLowerCase();
	var id_err = id + '_err';
	if ($.inArray(ext, ['svg']) == -1) {
		$('.' + id_err).text('Please upload valid file format');
		$('#' + id).val('');
		$('#' + id).focus();
		return false;
	} else {
		$('.' + id_err).text('');
	}
}
function validate_video_url_mp4(id) {
	if($('#' + id).val() !="")
	{
		var ext = $('#' + id).val().split('.').pop().toLowerCase();
		var id_err = id + '_err';
		if ($.inArray(ext, ['mp4']) == -1) {
			$('.' + id_err).text('Invalid url only MP4 is allowed');
			$('#' + id).val('');
			$('#' + id).focus();
			return false;
		} else {
			$('.' + id_err).text('');
		}
	}
}
function student_profile_pic_validation() {
	var ext = $('#profile_pic').val().split('.').pop().toLowerCase();
	if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
		$('.profile_pic_err').text('Please upload valid file format');
		$('#profile_pic').val('');
		$('#profile_pic').focus();
		return false;
	} else {
		$('.profile_pic_err').text('');
	}
}
function validate_gallery_form() {
	var media_type = $("#media_type").val();
	if ($("#media_type").val() == "") {
		$('.media_type_err').text('Please select media type');
		$('#media_type').focus();
		return false;
	} else {
		$('.media_type_err').text('');
	}
	file_hidden = $('#file_hidden').val();
	if (file_hidden == '') {
		if ($("#image").val() == "") {
			$('.image_err').text('Please select media file');
			$('#image').focus();
			return false;
		} else {
			$('.image_err').text('');
		}
	}
	if (file_hidden == '') {
		var ext = $('#image').val().split('.').pop().toLowerCase();
		if (media_type == 'Image') {
			if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'svg','webp']) == -1) {
				$('.image_err').text('Please upload valid file format');
				$('#image').focus();
				return false;
			} else {
				$('.image_err').text('');
			}
		} else if (media_type == 'Audio') {
			if ($.inArray(ext, ['mp3']) == -1) {
				$('.image_err').text('Please upload valid file format');
				$('#image').focus();
				return false;
			} else {
				$('.image_err').text('');
			}
		} else if (media_type == 'Video') {
			if ($.inArray(ext, ['mp4']) == -1) {
				$('.image_err').text('Please upload valid file format');
				$('#image').focus();
				return false;
			} else {
				$('.image_err').text('');
			}
		} else {
			return false;
		}
	} else {
		$('.image_err').text('');
	}
	if ($("#title").val() == "") {
		$('.title_err').text('Please enter media title');
		$('#title').focus();
		return false;
	} else {
		$('.title_err').text('');
	}
}
function validate_offer_form() {
	if ($("#subject").val() == "") {
		$('.subject_err').text('Please enter subject');
		$('#subject').focus();
		return false;
	} else {
		$('.subject_err').text('');
	}
	var media_file = $("#media_file").val();
	if (media_file != '') {
		var ext = $('#media_file').val().split('.').pop().toLowerCase();
		if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
			$('.media_file_err').text('Please upload valid file format');
			$('#media_file').focus();
			return false;
		} else {
			$('.media_file_err').text('');
		}
	} else {
		$('.media_file_err').text('');
	}
	if ($("#offer_date").val() == "") {
		$('.offer_date_err').text('Please enter offer date range');
		$('#offer_date').focus();
		return false;
	} else {
		$('.offer_date_err').text('');
	}
	var wordString = $("#body").val();
	var words = wordString.split(" ");
	wl = words.length;
	words = words.filter(function (words) {
		return words.length > 0
	}).length;
	if (words > 200 || words < 10) {
		$(".body_err").text("Please enter max 200 words and minimun 10 words!");
		return false;
	} else {
		$(".body_err").text("");
	}
}
function validate_branch_form() {
	var independent_body = $("#independent_body").val();
	if ($("#center_name").val() == "") {
		$('.center_name_err').text('Please enter Branch name');
		$('#center_name').focus();
		return false;
	}else{
		$('.center_name_err').text('');
	}
	if ($("#center_name").val().length < 4 || $("#center_name").val().length > 25) {
		$('.center_name_err').text('Please enter Branch name between 4-25 chars');
		$('#center_name').focus();
		return false;
	}else{
		$('.center_name_err').text('');
	}
	if ($("#center_code").val() == "") {
		$('.center_code_err').text('Please enter Branch code');
		$('#center_code').focus();
		return false;
	} else {
		$('.center_code_err').text('');
	}
	if ($("#center_code").val().length > 3) {
		$('.center_code_err').text('Please enter Branch code with Max. 3 chars');
		$('#center_code').focus();
		return false;
	} else {
		$('.center_code_err').text('');
	}
	if (independent_body == 0) {
		if ($("#physical_branch").val() == "") {
			$('.physical_branch_err').text('Please select option');
			$('#physical_branch').focus();
			return false;
		} else {
			$('.physical_branch_err').text('');
		}
		if ($("#is_overseas").val() == null) {
			$('.is_overseas_err').text('Please select option');
			$('#is_overseas').focus();
			return false;
		} else {
			$('.is_overseas_err').text('');
		}
		if ($("#contact").val() == "") {
			$('.contact_err').text('Please enter branch contact details');
			$('#contact').focus();
			return false;
		} else {
			$('.contact_err').text('');
		}
		if ($("#email").val() == "") {
			$('.email_err').text('Please enter branch email details');
			$('#email').focus();
			return false;
		} else {
			$('.email_err').text('');
		}
		if ($("#physical_branch").val() == 1) {
			if ($("#country_id").val() == "") {
				$('.country_id_err').text('Please select country');
				$('#country_id').focus();
				return false;
			} else {
				$('.country_id_err').text('');
			}
			if ($("#state_id").val() == "") {
				$('.state_id_err').text('Please select state');
				$('#state_id').focus();
				return false;
			} else {
				$('.state_id_err').text('');
			}
			if ($("#city_id").val() == "") {
				$('.city_id_err').text('Please select city/district');
				$('#city_id').focus();
				return false;
			} else {
				$('.city_id_err').text('');
			}
			var wordString = $("#address_line_1").val();
			var words = wordString.split(" ");
			words = words.filter(function (words) {
				return words.length > 0
			}).length;
			if (words > 100 || words < 3) {
				$(".address_line_1_err").text("Please enter max 100 words and min 3 words!");
				return false;
			} else {
				$(".address_line_1_err").text("");
			}
		}
	}
	if ($('input[name^=branch_divisions]:checked').length <= 0) {
		$('.branch_divisions_err').text('Please select atleast one division');
		//$('#center_code').focus();
		return false;
	} else {
		$('.branch_divisions_err').text('');
	}
}
function validate_recent_result_form() {
	if ($("#test_module_id").val() == "") {
		$('.test_module_id_err').text('Please select course');
		$('#test_module_id').focus();
		return false;
	} else {
		$('.test_module_id_err').text('');
	}
	var page = $("#page").val();
	if (page == 'edit') {
		var image_hidden = $("#image_hidden").val();
		if (image_hidden) {
			$('.image_err').text('');
		} else {
			var media_file = $("#image").val();
			var ext = $('#image').val().split('.').pop().toLowerCase();
			if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
				$('.image_err').text('Please upload valid file format');
				$('#image').focus();
				return false;
			} else {
				$('.image_err').text('');
			}
		}
	} else {
		var media_file = $("#image").val();
		var ext = $('#image').val().split('.').pop().toLowerCase();
		if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
			$('.image_err').text('Please upload valid file format');
			$('#image').focus();
			return false;
		} else {
			$('.image_err').text('');
		}
	}
	if ($("#title").val() == "") {
		$('.title_err').text('Please enter result title');
		$('#title').focus();
		return false;
	} else {
		$('.title_err').text('');
	}
}
function validate_marketing_popup_form() {
	var page = $("#fake").val();
	if ($("#marketing_date").val() == "") {
		$('.marketing_date_err').text('Please enter date range');
		$('#marketing_date').focus();
		return false;
	} else {
		$('.marketing_date_err').text('');
	}
	if (page == 'add') {
		if ($("#image").val() == "") {
			$('.image_err').text('Please select media file');
			$('#image').focus();
			return false;
		} else {
			$('.image_err').text('');
		}
		var media_file = $("#image").val();
		if (media_file != '') {
			var ext = $('#image').val().split('.').pop().toLowerCase();
			if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
				$('.image_err').text('Please upload valid file format');
				$('#image').val('');
				$('#image').focus();
				return false;
			} else {
				$('.image_err').text('');
			}
		} else {
			$('.image_err').text('');
		}
	}
	if (page == 'edit') {
		var media_file = $("#image").val();
		if (media_file != '') {
			var ext = $('#image').val().split('.').pop().toLowerCase();
			if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
				$('.image_err').text('Please upload valid file format');
				$('#image').val('');
				$('#image').focus();
				return false;
			} else {
				$('.image_err').text('');
			}
		} else {
			$('.image_err').text('');
		}
	}
	if ($("#title").val() == "") {
		$('.title_err').text('Please enter title/heading');
		$('#title').focus();
		return false;
	} else {
		$('.title_err').text('');
	}
	if ($("#link").val() == "") {
		$('.link_err').text('Please enter URL/Link');
		$('#link').focus();
		return false;
	} else {
		$('.link_err').text('');
	}
	var str = $("#link").val();
	var regex = /(?:https?):\/\/(\w+:?\w*)?(\S+)(:\d+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
	if (!regex.test(str)) {
		alert("Please enter valid URL.");
		return false;
	} else {
		return true;
	}
}
function valid_url_classroom() {
	var conf_URL = $("#conf_URL").val();
	if (conf_URL) {
		var regex = /(?:https?):\/\/(\w+:?\w*)?(\S+)(:\d+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
		if (!regex.test(conf_URL)) {
			$('.conf_URL_err').text('Please enter valid URL');
			$('#conf_URL').focus();
			return false;
		} else {
			$('.conf_URL_err').text('');
		}
	} else {
		$('.conf_URL_err').text('');
	}
}
function validate_textual_testimonial_form() {
	if ($("#for_page").val() == "") {
		$('.for_page_err').text('Please select page');
		$('#for_page').focus();
		return false;
	} else {
		$('.for_page_err').text('');
	}
	if ($("#name").val() == "") {
		$('.name_err').text('Please enter name');
		$('#name').focus();
		return false;
	} else {
		$('.name_err').text('');
	}
	if ($("#tsmt_date").val() == "") {
		$('.tsmt_date_err').text('Please enter date');
		$('#tsmt_date').focus();
		return false;
	} else {
		$('.tsmt_date_err').text('');
	}
	var image = $("#image").val();
	if (image != '') {
		var ext = $('#image').val().split('.').pop().toLowerCase();
		if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
			$('.image_err').text('Please upload valid file format');
			$('#image').focus();
			return false;
		} else {
			$('.image_err').text('');
		}
	} else {
		$('.image_err').text('');
	}
	if ($("#url").val() == "") {
		$('.url_err').text('Please enter valid URL');
		$('#url').focus();
		return false;
	} else {
		$('.url_err').text('');
	}
	if ($("#testimonial_text").val() == "") {
		$('.testimonial_text_err').text('Please enter text');
		$('#testimonial_text').focus();
		return false;
	} else {
		$('.testimonial_text_err').text('');
	}
	var wordString = $("#testimonial_text").val();
	var words = wordString.split(" ");
	words = words.filter(function (words) {
		return words.length > 0
	}).length;
	if (words > 80 || words < 10) {
		$(".testimonial_text_err").text("Please enter max 80 words and min 10 words!");
		return false;
	} else {
		$(".testimonial_text_err").text("");
	}
}
function validate_video_testimonial_form() {
	if ($("#file_source").val() == "") {
		$('.file_source_err').text('Please select source');
		$('#file_source').focus();
		return false;
	} else {
		$('.file_source_err').text('');
	}
	if ($("#for_page").val() == "") {
		$('.for_page_err').text('Please select page');
		$('#for_page').focus();
		return false;
	} else {
		$('.for_page_err').text('');
	}
	if ($("#title").val() == "") {
		$('.title_err').text('Please enter title');
		$('#title').focus();
		return false;
	} else {
		$('.title_err').text('');
	}
	if ($("#test_module_id").val() == "") {
		$('.test_module_id_err').text('Please select related course');
		$('#test_module_id').focus();
		return false;
	} else {
		$('.test_module_id_err').text('');
	}
	var screenshot_hidden = $("#screenshot_hidden").val();
	if (screenshot_hidden == '') {
		var screenshot = $("#screenshot").val();
		if (screenshot == "") {
			$('.screenshot_err').text('Please upload screen image');
			$('#screenshot').focus();
			return false;
		} else {
			$('.screenshot_err').text('');
		}
		if (screenshot != '') {
			var ext = $('#screenshot').val().split('.').pop().toLowerCase();
			if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
				$('.screenshot_err').text('Please upload valid file format');
				$('#screenshot').focus();
				return false;
			} else {
				$('.screenshot_err').text('');
			}
		} else {
			$('.screenshot_err').text('');
		}
	} else {
		$('.screenshot_err').text('');
	}
	if ($("#url").val() == "") {
		$('.url_err').text('Please enter valid URL/YTD code');
		$('#url').focus();
		return false;
	} else {
		$('.url_err').text('');
	}
	if ($("#url").val() != "" && $("#file_source").val() == "WOSA Gallery") {
		var str = $("#url").val();
		var regex = /(?:https?):\/\/(\w+:?\w*)?(\S+)(:\d+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
		if (!regex.test(str)) {
			$('.url_err').text('Please enter valid URL');
			$('#url').focus();
			return false;
		} else {
			return true;
		}
	} else if ($("#url").val() != "" && $("#file_source").val() == "Youtube") {
		if ($("#url").val().length > 15) {
			$('.url_err').text('Please enter upto 15 character code');
			$('#url').focus();
			return false;
		} else {
			$('.url_err').text('');
		}
	} else {
	}
}
function validate_realityTest_form() {
	if ($("#title").val() == "") {
		$('.title_err').text('Please enter title');
		$('#title').focus();
		return false;
	} else {
		$('.title_err').text('');
	}
	if ($("#test_module_id").val() == "") {
		$('.test_module_id_err').text('Please select course');
		$('#test_module_id').focus();
		return false;
	} else {
		$('.test_module_id_err').text('');
	}
	if ($("#date").val() == "") {
		$('.date_err').text('Please select test date');
		$('#date').focus();
		return false;
	} else {
		$('.date_err').text('');
	}
	if ($("#time_slot1").val() == "") {
		$('.time_slot1_err').text('Please select first time slot');
		$('#time_slot1').focus();
		return false;
	} else {
		$('.time_slot1_err').text('');
	}
	if ($("#amount").val() == "" || $("#amount").val() == 0) {
		$('.amount_err').text('Please enter price value');
		$('#amount').focus();
		return false;
	} else {
		$('.amount_err').text('');
	}
	if ($("#location_type").val() == "") {
		$('.location_type_err').text('Please select location type');
		$('#location_type').focus();
		return false;
	} else {
		$('.location_type_err').text('');
	}
	if ($("#location_type").val() == 'Outhouse') {
		if ($("#location_id").val() == "") {
			$('.location_id_err').text('Please select location');
			$('#location_id').focus();
			return false;
		} else {
			$('.location_id_err').text('');
		}
		if (($("#seats").val() == "" || $("#seats").val() == 0) && $(".Outhouse_unlimitedSeats:checked").val() != -1) {
			$('.seats_err').text('Please select seats value');
			$('#seats').focus();
			return false;
		} else {
			$('.seats_err').text('');
		}
	} else if ($("#location_type").val() == 'Branch') {
		var returnVal = true;
		$('[name$="[seats]"]').each(function(){
			if($(this).prev().is(":checked") && $(this).val().trim() == "" && $(this).prop("disabled") == false) {
				$(this).parent().next().text('Please select seats value');
				returnVal = false;
			}
		})
		if(returnVal == false) {
			return false;
		}
		// var brSeats = $('[name$="[seats]]"]');
		// var length = brSeats.length;
		// var arr = 0;
		// for (i = 0; i < length; i++) {
		// 	if (brSeats[i].value != '') {
		// 		arr = arr + parseInt(brSeats[i].value);
		// 	}
		// }
		// //alert(arr);return false;
		// if (arr == '' || arr == 0) {
		// 	$('.branch_seats_error').text('Please select seats value');
		// 	return false;
		// }
	} else {
		$('.location_type_err').text('Please select location type');
		$('#location_type').focus();
		return false;
	}
}
function activate_deactivete_productcard(id, active, table, pk) {
	var idd = '#' + id;
	$.ajax({
		url: WOSA_ADMIN_URL + 'Product_card/ajax_activate_deactivete_productcard',
		async: true,
		type: 'post',
		data: { id: id, active: active, table: table, pk: pk },
		dataType: 'json',
		success: function (response) {
			if (response >= 1) {
				window.location.href = window.location.href
			} else {
				$(idd).html('');
			}
		}
	});
}
function activate_deactivete_usptext(id, active, table, pk) {
	var idd = '#' + id;
	$.ajax({
		url: WOSA_ADMIN_URL + 'usp/ajax_activate_deactivete_usptext',
		async: true,
		type: 'post',
		data: { id: id, active: active, table: table, pk: pk },
		dataType: 'json',
		success: function (response) {
			//alert(response)
			if (response >= 1) {
				window.location.href = window.location.href
			} else {
				$(idd).html('');
			}
		}
	});
}
/*-----function used to validate image/video/audio size----*/
$(".validateCheckFileSize").change(function () {
	var id = this.id;
	var type = this.getAttribute('data-type')
	var file = this.files[0];
	//var upload_type=$('#upload_type').val();
	checkFileSize(file, id, type);
});
function checkFileSize(files, id, type) {
	//alert(files.type)
	var reader = new FileReader();
	var img = new Image();
	if (type == 1) //1=image
	{
		var maxfilesize = MEDIUM_CATEGORY_IMAGE_SIZE.replace('MB', '');
		var maxfilesize_title = MEDIUM_CATEGORY_IMAGE_SIZE;
	}
	else if (type == 2)//2=video
	{
		var maxfilesize = MEDIUM_CATEGORY_VIDEO_SIZE.replace('MB', '');
		var maxfilesize_title = MEDIUM_CATEGORY_VIDEO_SIZE;
	}
	else { //3=audio
		var maxfilesize = MEDIUM_CATEGORY_AUDIO_SIZE.replace('MB', '');
		var maxfilesize_title = MEDIUM_CATEGORY_AUDIO_SIZE;
	}
	reader.onload = function (e) {
		img.src = e.target.result;
		medium_file_size = maxfilesize * 1024 * 1024; // ....convert in bytes
		var id_err = id + '_err'; //create class for message display
		if (files.size > medium_file_size) {
			$('.' + id_err).text("File size is not greater than " + maxfilesize_title);
			$('#' + id).val('');
			$('#' + id).focus();
			return false;
		}
		else {
			$('.' + id_err).text("");
		}
		/*img.onload = function () {
		   // alert("width=" + this.width + " height=" + this.height);
			$('#preview').append('<img src="' + e.target.result + '"/>');
		};*/
	};
	reader.readAsDataURL(files);
}
/*-----ENDS------function used to validate uploaded image/video size----*/
function check_general_assistance_subjects_duplicacy(subject) {
	var subject_id = $('#subject_id_hidden').val();
	if (subject == '') {
		$('.subject_err').text('Please type subject');
		$('#subject').focus();
		$('.sbm').prop('disabled', true);
		return false;
	} else {
		$('.subject_err').text('');
		$('.sbm').prop('disabled', false);
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'general_assistance_subjects/ajax_check_subject_duplicacy_',
		async: false,
		type: 'post',
		data: { subject: subject, subject_id: subject_id },
		dataType: 'json',
		success: function (response) {
			if (response > 0) {
				$('.subject_err').text('Please type unique name.' + subject + ' already exist');
				$('#subject').val('');
				$('#subject').focus();
				$('.sbm').prop('disabled', true);
				return false;
			} else {
				$('.subject_err').text('');
				$('.sbm').prop('disabled', false);
			}
		}
	});
}
//Allow Number and Decimal Number Only
$(".allow_numeric").on("input", function (evt) {
	var self = $(this);
	self.val(self.val().replace(/\D/g, ""));
	if ((evt.which < 48 || evt.which > 57)) {
		evt.preventDefault();
	}
});
$(".allow_alphabets").on("input", function (evt) {
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
$(".allow_decimal").on("input", function(evt) {
	var self = $(this);
	self.val(self.val().replace(/[^0-9\.]/g, ''));
	if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57))
	{
	  evt.preventDefault();
	}
});
$(".allow_url_slug").on("input", function(evt) {
	var self = $(this);
	self.val(self.val().replace(/[^a-zA-Z0-9_-]/, ""));
});
//word count limit
$('.validatewordcount').keyup(function() {
    var id			= $(this).attr('id');
    var id_err 		= id+'_err'; //create class for message display
    var count		= $(this).data('count');
    var entervword	= $(this).val();
    wordlenght		= entervword.length;
    //alert(wordlenght)
    $("."+id_err).text('Entered Word : '+wordlenght);
    if(wordlenght>count) {
        $("."+id_err).text('Maximum length should '+ count +' words ');
        return false;
    }
});
$(".numeric_without_zero").on("blur", function (evt) {
	var self = $(this);
	var data=$(this).val();
	var id=$(this).attr('id');
	self.val(self.val().replace(/\D/g, ""));
	if (data!='' && data<=0) {
	$(this).val('');
	$('.'+id+'_err').text('Zero is not allowed!');
	} 
	else {
		$('.'+id+'_err').text('');
	}
});
//restrict input type word count limit
$('.maxlenghtrestrict').keyup(function(e) {
    var max			= $(this).data('count');
    var entervword	= $(this).val();
    wordlenght		= entervword.length;
    if(wordlenght>max) {
      this.value = this.value.substring(0, max);
    }
});
$('.noBackFutureDate').datepicker({
	startDate: new Date(),
	endDate: new Date(),
});
	$('.noBackDate').datepicker({
		startDate: new Date(),
		autoclose:true,
    });
	var currentDate = new Date();
    $('.noFutureDate').datepicker({
		endDate: "currentDate",
		maxDate: currentDate,
		autoclose:true,
    });
    $(document).ready(function(){
	  $(".timeDD").change(function(e){
	      var id = $(this).attr("id");
	      var value = this.value;
	      $(".timeDD option").each(function(){
	        var idParent = $(this).parent().attr("id");
	        if (id != idParent){
	          if (this.value == value){
	            this.remove();
	          }
	        }
	    });
	    $('.timeDD').selectpicker('refresh');
	  });
	});
	function setSeats(global_seat){
		$('.global_seat_data').val(global_seat)
	}
	function manage_seats_cb(cb_id){
		if($("#"+cb_id).prop('checked') == true){
			var global_seats2 = $('#global_seats').val();
	        $('#brSeats'+cb_id).val(global_seats2);
	        $('#brSeats'+cb_id).prop('disabled', false);
	    }else{
	        $('#brSeats'+cb_id).val(0);
	        $('#brSeats'+cb_id).prop('disabled', true);
	    }
	}
function showPwd(field1,field2) {
  var x = document.getElementById(field1);
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
  var y = document.getElementById(field2);
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }
}
  function check_old_pwd(old_pwd){
          $.ajax({
               url: "<?php echo site_url('adminController/user/ajax_check_old_pwd');?>",
                async : true,
                type: 'post',
                data: {old_pwd: old_pwd},
                dataType: 'json',
                success: function(response){
                    if(response.status=='true'){
                        $('.msg').html(response.msg);
                        $('#op_err').text('');
                    }else{
                        $('.msg').html(response.msg);
                        $('#op').text('');
                        $('#op_err').text('Please enter correct previous password !');
                        $('#op').focus();
                        return false;
                    }
                }
            });
  }
function validate_cp(){
  var op = document.getElementById("op").value;
  var np = document.getElementById("np").value;
  var rnp = document.getElementById("rnp").value;
  if(op==''){
    $('#op_err').text('Please enter previous password !');
    $('#op').focus();
    return false;
  }else{
    $('#op_err').text('');
  }
  if(np==''){
    $('.np_err').text('Please enter new password !');
    $('#np').focus();
    return false;
  }else{
    $('.np_err').text('');
  }
  if(rnp==''){
    $('.rnp_err').text('Please re-enter new password !');
    $('#rnp').focus();
    return false;
  }else{
    $('.rnp_err').text('');
  }
  if(np!='' && rnp!=''){
    if(np!=rnp){
       $('.rnp_err').text('Password mismatched! new password and confirm password do not match!');
       $('#rnp').focus();
       return false;
    }else{
      $('.rnp_err').text('');
      return true;
    }
  }
}
//Get currency code by country id.
function getCountryCurrencyCodeByCountryId(countryId="") {
	if(countryId) {
		var currencyCode = '';
		$.ajax({
			url		: WOSA_ADMIN_URL + 'discount/ajax_get_country_code',
			async	: false,
			type	: 'post',
			data	: { country_id: countryId },
			dataType: 'json',
			success	: function (data) {
				currencyCode = data;
			}
		})
		return currencyCode;
	}
}
function alertMsg(title,icon){
	var colorName='red';
	if(icon=='success'){
		var colorName='green';
	}
	Swal.fire({
		//toast: true,
		//position: 'top-end',
		icon: icon,
		title:title,
		showConfirmButton: true,
		confirmButtonColor: colorName,
		timer: 3000,
    });
}
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
/**
 * This function will be used to save tables columns show/hide features.
 *
 * @returns {undefined}
 */
function saveSettings() {
    $.ajax({
        type: 'post',
        url: WOSA_ADMIN_URL + 'leads/ajax_save_table_settings',
        data: $('#table_settings_form').serialize(),
        success: function (res) {
            window.location.reload();
        },
        error: function (err) {
            console.log(err);
        }
    });
}
function selectAllSettingCal(){
	if ($("#columns-setting-all").is(':checked')) {
        $(".setting-cal-name").prop('checked',true);
    }else{
		$(".setting-cal-name").prop('checked',false);
	}
}
$(document).on('change', '.setting-cal-name', function () {
    var totalRows = $('.setting-cal-name').length;
    var selectedRows = $('.setting-cal-name:checked').length;
    if (totalRows === selectedRows) {
        $('#columns-setting-all').prop('checked', true);
    } else {
        $('#columns-setting-all').prop('checked', false);
    }
});
/**
 * This function is used to open modal for tables settings.
 *
 * @returns {undefined}
 */
function openSettingsModal() {
    $('#settingsModal').modal('show');
}
/**
 * This code is used to check/uncheck checkboxes.
 */
$(document).on('change', '#allRows', function () {
    if ($(this).is(':checked')) {
        $('.leads_rows').prop('checked', true);
    } else {
        $('.leads_rows').prop('checked', false);
    }
});
/**
 * This code is used to check/uncheck all checkboxes of a table.
 */
$(document).on('change', '.leads_rows', function () {
    var totalRows = $('.leads_rows').length;
    var selectedRows = $('.leads_rows:checked').length;
    if (totalRows === selectedRows) {
        $('#allRows').prop('checked', true);
    } else {
        $('#allRows').prop('checked', false);
    }
});
/**
 *
 * @param {array} json_data
 * @param {array} params
 * @returns {undefined}
 */
function prepareSelectBox(json_data, params) {
    var rows = JSON.parse(json_data);
    var selectBox = '<option value="">Select</option>';
    if (rows.length) {
        $.each(rows, function (index, row) {
            selectBox += '<option value="' + row[params['option_id']] + '">' + row[params['option_name']] + '</option>';
        });
    }
    $('#' + params['select_id']).html(selectBox);
    $('#' + params['select_id']).selectpicker('refresh');
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
            $('.' + key + '_err').html(message + ' is mandatory');
            checks.push(false);
        }else if(input_type=='email' && !value.match(validRegexEmail) && value !=''){
                            $('.' + key + '_err').html('Invalid email address!');
                            checks.push(false);
                    }
                    else {
            $('.' + key + '_err').html('');
        }
        if (min_length !== undefined && input_length < min_length) {
            $('.' + key + '_err').html(message + '  must be minimun ' + min_length + ' characters');
            checks.push(false);
        }
        if (max_length !== undefined && input_length > max_length) {
            $('.' + key + '_err').html(message + '  can not be more than ' + max_length + ' characters');
            checks.push(false);
        }
    }
    return checks.includes(false) ? false : true;
}
/**
 *
 * @param {type} element_array
 * @returns {Boolean}
 */
function validateFormElements(element_array) {
    var checks = [];
    $.each(element_array, function(key, value) {
        var is_element_input = $('#' + value).is("select");
        if(is_element_input === false) {
            var element_value = $('#' + value).val();
        } else {
            var element_value = $('#' + value + ' > option:selected').val();
        }
        var title = $('#' + value).attr('title');
        var message = (title !== undefined) ? title : 'This field ';
        if (element_value === '' && element_value !== undefined) {
            $('.' + value + '_err').html(message + ' is mandatory');
            checks.push(false);
        } else {
            $('.' + value + '_err').html('');
        }
    });
    return checks.includes(false) ? false : true;
}
function openAssignLeadModal()
{
	$('#assignLeadModal').modal('show');
}
function openReAssignLeadModal()
{
	$('#reAssignLeadModal').modal('show');
}
function openTransferParallelAssigningModal()
{
	$('#transferParallelAssigningModal').modal('show');
}
function openTemporaryAssigningModal()
{
	$('#temporaryAssigningModal').modal('show');
}
function openUnassignLeadModal()
{
	$('#unassignLeadModal').modal('show');
}
function openMergeLeadsModal()
{
	$('#mergeLeadsModal').modal('show');
}
function openGroupLeadsListsModal()
{
	$('#groupLeadsListsModal').modal('show');
}
function openDownloadCSVModal(url) {
	Swal.fire({
	  title: 'Are you sure?',
	  text: "You want to export CSV!",
	  icon: 'question',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes, export it!'
	}).then((result) => {
	  if (result.isConfirmed) {
		window.open(url, "_blank");
	  }
	});
}
function getSlugStatus()
{
	var url_slug		=$('#url_slug').val();
	var table_id		=$('#table_id').val(); // denotes campaign_id or event_id
	var type			=$('#type').val(); // denotes campaign or event
	$.ajax({
		url: WOSA_ADMIN_URL+'campaign/ajax_getSlugStatus',
		async : true,
		type: 'post',
		data: {url_slug:url_slug,table_id:table_id,type:type},
		dataType: 'json',                
		success: function (response) {
			if (response > 0) {
				$('#url_slug_err').text('Please type unique URL Slug. ' + url_slug + '  already exist');
				$('#url_slug').val('');
				$('#url_slug').focus();
				$('.sbm').prop('disabled', true);
				return false;
			} else {
				$('#url_slug_err').text('');
				$('.sbm').prop('disabled', false);
			}
		}
	});
}
function check_course_type_duplicacy(batch_name) {
	var course_id = $('#course_type_id_hidden').val();
	if (batch_name == '') {
		$('.course_name_err').text('Please type batch name');
		$('#course_timing').focus();
		$('.sbm').prop('disabled', true);
		return false;
	} else {
		$('.course_name_err').text('');
		$('.sbm').prop('disabled', false);
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'course_type/ajax_check_course_type_duplicacy',
		async: false,
		type: 'post',
		data: { batch_name: batch_name, course_id: course_id },
		dataType: 'json',
		success: function (response) {
			if (response > 0) {
				$('.course_name_err').text('Please type unique name.' + batch_name + ' already exist');
				$('#course_timing').val('');
				$('#course_timing').focus();
				$('.sbm').prop('disabled', true);
				return false;
			} else {
				$('.course_name_err').text('');
				$('.sbm').prop('disabled', false);
			}
		}
	});
}
// put waiver amount in hidden
$(document).on('change', '#waiver_amount', function () {	
	var amt=$(this).find(':selected').data('id')
	$('#user_waiver_amt').val(amt);
});
// validate waiver amount
$(document).on('change', '.entered_waiver_amt', function () {
	var val=$(this).val();
	val = parseInt(val);
	var thisg=$(this);	
	var user_waiver_amt=parseInt($('#user_waiver_amt').val());
	if(user_waiver_amt == 0)
	{
		var val=$('.amount_wa_error').text('Please select Waiver Admin');
		thisg.focus();
		thisg.val('');
		return false;
	}
	else if(val == 0 || val == "")
	{
		var val=$('.amount_wa_error').text('Invalid amount entered. Please Enter amount less then equal to '+ user_waiver_amt);
		thisg.focus();
		thisg.val('');
		//lert(val)
	}
	else if(val>user_waiver_amt)
	{
		var val=$('.amount_wa_error').text('Invalid amount entered. Please Enter amount less then equal to '+ user_waiver_amt);
		thisg.focus();
		thisg.val('');
		//lert(val)
	}
	else {
		var val=$('.amount_wa_error').text('');
	}
});
$('.select_removeerrmessagep').on('show.bs.select', function() {
	var id = $(this).attr('id')	
	var id_err = id + '_err';
	$("." + id_err).html("");
});
$(document).on('click', '.removeerrmessage', function() {
	var id = $(this).attr('id');
	var id_err = id + '_err';
	$("." + id_err).html("");
});
function validate_duration(val,id)
{
	if(val ==0)
	{
		$('.'+id+'_err').text('Invalid Duration');
		$('#'+id).focus();	
		$('#'+id).val('');	
	}
	else if(val > 240)
	{
		$('.'+id+'_err').text('Duration should not be greater than 240 Minutes');
		$('#'+id).focus();	
		$('#'+id).val('');			
	}
	else {
		$('.'+id+'_err').text('');
	}
}
function enableBtn_packPayment_add_payment_cs(data)
{
	if( $('#add_payment_cs').val() == "")
	{
		$('.uspp').prop('disabled', true);
	}
	else if($('#test_module_id').val() == "" || $('#programe_id').val() == "")
	{
		$('.uspp').prop('disabled', true);
	}
	else{
		$('.uspp').prop('disabled', false);
	}
}
function validate_adjustment_forms(){
	var adjustment_form = $('#payment_type').val();
	//alert(adjustment_form)
	if(adjustment_form=='Pack on Hold'){
		var holdDateFrom = $('#holdDateFrom').val();
		var holdDateTo = $('#holdDateTo').val();
		var application_file = $('#application_file').val();
		if(holdDateFrom==''){
			$('.holdDateFrom_err').text('Please enter valid fromhold date!');
			$('#holdDateFrom').val('');
			$('#holdDateFrom').focus();
			return false;
		}else{
			$('.holdDateFrom_err').text('');
		}
		if(holdDateTo==''){
			$('.holdDateTo_err').text('Please enter valid to hold date!');
			$('#holdDateTo').val('');
			$('#holdDateTo').focus();
			return false;
		}else{
			$('.holdDateFrom_err').text('');
		}
		if(application_file==''){
			$('.application_file_err').text('Please attach application file');
			$('#application_file').val('');	
			return false;
		}else{
			$('.application_file_err').text('');
		}	
	}else if(adjustment_form=='Adjustment-PE'){
		var add_payment_pe = $('#add_payment_pe').val();
		var expired_on = $('#expired_on').val();
		if(add_payment_pe==''){
			$('.add_payment_pe_err').text('Please enter pack extension charge!');
			$('#add_payment_pe').val('');
			$('#add_payment_pe').focus();
			return false;
		}else{
			$('.add_payment_pe_err').text('');
		}
		if(expired_on==''){
			$('.expired_on_err').text('Please enter date!');
			$('#expired_on').val('');
			$('#expired_on').focus();
			return false;
		}else{
			$('.expired_on_err').text('');
		}
	}else if(adjustment_form=='Adjustment-CS'){
		var test_module_id = $('#test_module_id').val();
		var programe_id = $('#programe_id').val();
		var add_payment_cs = $('#add_payment_cs').val();
		if(test_module_id==''){
			$('.test_module_id_err').text('Please select course!');
			return false;
		}else{
			$('.test_module_id_err').text('');
		}
		if(programe_id==''){
			$('.programe_id_err').text('Please select programe!');
			return false;
		}else{
			$('.programe_id_err').text('');
		}
		if(add_payment_cs==''){
			$('.add_payment_cs_err').text('Please enter switching charge');
			$('#add_payment_cs').val('');	
			$('#add_payment_cs').focus();
			return false;
		}else{
			$('.add_payment_cs_err').text('');
		}
	}else if(adjustment_form=='Batch Update'){
		var batch_id = $('#batch_id_adj').val();
		if(batch_id==''){
			$('.batch_id_adj_err').text('Please select batch!');
			return false;
		}else{
			$('.batch_id_adj_err').text('');
		}
	}else if(adjustment_form=='Terminate-Pack'){
		var termination_reason = $('#termination_reason').val();
		if(termination_reason==''){
			$('.termination_reason_err').text('Please write reason');
			return false;
		}else{
			$('.termination_reason_err').text('');
		}
	}else if(adjustment_form=='Change DCD'){
		var new_due_committment_date = $('#new_due_committment_date').val();
		if(new_due_committment_date==''){
			$('.new_due_committment_date_err').text('Please enter due date');
			return false;
		}else{
			$('.new_due_committment_date_err').text('');
		}
	}
	else if(adjustment_form=='Manage start date'){
		var new_start_date = $('#new_start_date').val();
		if(new_start_date==''){
			$('.new_start_date_err').text('Please enter new date');
			return false;
		}else{
			$('.new_start_date_err').text('');
		}
	}
	else{
	}
	//return false;
}
function delete_media_file(e,id)
{
	var con = confirm("Confirm Delete?");
	if (con == false) {	return false;} else {
	var file=e.getAttribute("data-image");	
	$.ajax({
		url: WOSA_ADMIN_URL + 'classroom_announcement/ajax_delete_media_file',
		async: false,
		type: 'post',
		data: { id: id,file:file},		
		success: function (response) {			
			if (response > 0) {				
				$('#mediafileshow').html('No File');				
			} else {//$('#mediafileshow').removeClass('hide');   
			} 
		}
	});
}
}
setTimeout(() => {
	$(".date_range").val('');
}, 1);
$('.date_range').daterangepicker(
{
    locale: {
      format: 'YYYY-MM-DD'
    },
	minDate:null,
	defaultShow :false
},
);
function validateMockTestScore(val,fieldId) {
	class_err = '.' + fieldId + '_err';
	if(val=='NA' || val=='AB' || val.match(/^-?\d*(\.\d+)?$/)){
		$(class_err).text('');
		$('.sbm').prop('disabled', false);
	}else {
		$('.sbm').prop('disabled', true);		
		$(class_err).text('Please enter valid value! Only numbers,NA and AB are allowed');
		return false;
	}	
}
function validateToeflMockTestScore(val,fieldId) {
	class_err = '.' + fieldId + '_err';
	if(val=='NA' || val=='AB' || val.match(/^-?\d*(\.\d+)?$/)){
		$(class_err).text('');
		$('.sbm').prop('disabled', false);
	}else {
		$('.sbm').prop('disabled', true);		
		$(class_err).text('Please enter valid value! Only numbers,NA and AB are allowed');
		return false;
	}	
}



function get_lead_detail(id)
{ 
    $.ajax({
    url: WOSA_ADMIN_URL + 'lead_management/get_lead_detail_',
    async : true,
    type: 'post',
    data: {lead_id: id},
    success: function(response)
    {       
        $('#lead_status option[value="'+response+'"]').attr("selected", "selected");
        if(response == 2)
        {
             $('#followup_status').prop('disabled',true);
        }
        $('#modal-session').modal();
        $('#hid_leadId').val(id);
    }
    });
}
function update_followup()
{  
   $('#update_followup').prop('disabled',true);
   $('#plzwait').html('Please wait...');
    var lead_status=$('#lead_status').val();
    var followup_status=$('#followup_status').val();
    var followup_remark=$('#followup_remark').val();
    var next_followupdatetime=$('#next_followupdatetime').val();
    var hid_leadId= $('#hid_leadId').val();
    if(followup_remark !="")
    {
        if(followup_status =="")
        {
            $('#followstatus').text('Please select followup status');
            return false;
        }
    }
    $('#followstatus').text('');
    $.ajax({  
	url: WOSA_ADMIN_URL + 'lead_management/ajax_update_followup',
    async : true,
    type: 'post',
    data: {lead_id: hid_leadId,lead_status:lead_status,followup_status:followup_status,followup_remark:followup_remark,next_followupdatetime:next_followupdatetime},
    success: function(response)
    {
        //alert(response)
       // return false;
        var dt=response.trim();
        if(dt >0 && dt !="")
        {
            $('#msg_lead').html('followup save Successfully');
             $('#msg_lead').css('color','green');
        }
        else {
             $('#msg_lead').html('Error. Try again!');
             $('#msg_lead').css('color','red');
             $('#update_followup').prop('disabled',false);
             $('#plzwait').html('');
        }
        window.setTimeout(function() {
    refresh_page();
}, 3000);
        /*$('#lead_status option[value="'+response+'"]').attr("selected", "selected");
        $('#modal-session').modal();
        $('#hid_leadId').val(id);
        //window.location = '<?php echo site_url('adminController/counseling_session/counselling_booking_list');?>';*/
    }
    });
}
function view_followup(id)
{
    $('#modal_viewfollowup').modal();
    $.ajax({
    url: WOSA_ADMIN_URL + 'lead_management/view_followup_',
    async : true,
    type: 'post',
    data: {lead_id: id},
    success: function(response)
    {
       //alert(response)
        $('#content_viewfollowup').html(response);
    }
    });
}

function fire_change_event()
{
	$(".ppp").trigger("change");

}
function noNumbers(e) {
	var code = ('charCode' in e) ? e.charCode : e.keyCode;
	//alert(code);
	if (!(code == 32) && // space
		!(code > 47 && code < 58) && // numeric (0-9)
		!(code > 64 && code < 91) && // upper alpha (A-Z)
		!(code > 96 && code < 123) && // lower alpha (a-z)
		!(code == 45)) { //  under score(-)
		e.preventDefault();
	}
}
function checkUrl(type,id) {
	edit_id = $('#hid_id').val();
	//eventUrlDisplayTitle = '<?php echo $eventData["eventUrlDisplayTitle"] ?>';
	$('.'+id+'_err').text('');
	reg = /(?=.*[a-zA-Z])[0-9a-zA-Z- ]/
	var url = $("#"+id).val();	
	if (url != '') {

		if (url.match(reg)) {
			$.ajax({
				url: WOSA_ADMIN_URL + 'Url_slug/ajax_check_url_',
				async: true,
				type: 'post',
				data: {
					'url': url,'type':type,edit_id:edit_id					
				},				
				success: function(response) {
					//alert(response)
					if (response == 0) {
						$('.submit_btn').prop('disabled', false);
						return true;
					}
					else {
						$('.'+id+'_err').text('this url is already taken');
						$('#'+id).focus();
						$('.submit_btn').prop('disabled', true);
						return false;
					}
					//return false;
					
				}
			});
		} else {
			$('.event_url_display_title_error').text('Url must contain at least one alphabet character.');
			return false;
		}
	} else {
		return false;
		/*if(type=='submit'){
			$("#event_form").submit();
		}*/
	}
}
$(document).on('blur', '.validate_url', function () {
	var data=$(this).val();
	var id=$(this).attr('id');
	var regex = /(?:https?):\/\/(\w+:?\w*)?(\S+)(:\d+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
	if (!regex.test(data)) {
	$("."+id+'_err').text('Invalid Link');
	$(this).val('');
	return false;
	} else {
	$("."+id+'_err').text('');
	return true;
	}
});
function validate_package_max_duration(value,maxDuration)
{
	var duration_type=$('#duration_type').val();
	if(duration_type !="" && value!="" && maxDuration !="")
	{	//alert(duration_type)
	if(duration_type == 1) /* Day */
	{
		var duration =parseInt(value);
	}
	else if(duration_type == 2)/* Week */
	{
		var duration =parseInt(value*7);
	}
	else if(duration_type == 3)/* Month */
	{
		var duration =parseInt(value*30);

	}	
	if(duration>parseInt(maxDuration))
	{
		$('.duration_err').text('Package max duration is '+maxDuration+' days');
		$('#duration').val('');
		$('#duration').focus();
	}
	else {
		$('.duration_err').text('');
		//('#duration').val('');
		//$('#duration').focus();
	}
	}	
}
$(document).on('change', '.reset_duration_field', function () {
	$('#duration').val('');
	$('.duration_err').text('');

});

// -------------------------------- File Upload progress bar-------------------------//
function _(el) {
	return document.getElementById(el);
}
function commonReadImageFile(idofUpload, file, filewidth, fileheight, fileType) {
	var reader = new FileReader();
	var flag = false;
	console.log("idofUpload", idofUpload);
	return new Promise((resolve, reject) => {
		reader.onload = function (e) {
			if(fileType =='video'){
				$("#previewVideo_"+idofUpload).attr("src", reader.result);
				resolve(true) 
			}else if(fileType == 'audio'){
				console.log("reader.result", reader.result)
				$("#previewAudio_"+idofUpload).attr("src", reader.result);
				resolve(true) 
			}

			var img = new Image();
			img.src = e.target.result;
		
			img.onload = function () {
				
				var w = this.width;
				var h = this.height;
				console.log("reader.result", w,filewidth, h, fileheight, reader.result );
				if ((w == filewidth && h == fileheight) || (filewidth == 0 && fileheight == 0 )) {
					console.log("case1");
					$(idofUpload).removeClass('file-empty');
					$('.correct-accept').addClass('active');
					$(".correct-accept").addClass("text-green");
					$(".correct-accept").removeClass("text-red");
					$("#previewImg_"+idofUpload).attr("src", reader.result);
				flag = true;
				} else {
					console.log("case2");
					// $(idofUpload).val('');
					// $(idofUpload).next().removeClass('active');
					// $(idofUpload).next().html('Choose a file ...');
					// $(idofUpload).addClass('file-empty');
					$("#"+idofUpload).val('');
					$("#"+idofUpload).next().removeClass('active');
					$("#"+idofUpload).next().html('Choose a file ...');
					$("#"+idofUpload).addClass('file-empty');
					$(".correct-accept").removeClass("text-blue");
					$(".correct-accept").removeClass("text-green")
					$(".correct-accept").addClass("text-red");
					$('#posts_section'+idofUpload).val('');
					$("#previewImg_"+idofUpload).attr("src",'');
					console.log("case3");
				flag = false;
				}
				resolve(flag) 
			}	
		};
		reader.readAsDataURL(file);
	})
}
 async function fileSizeCheck(idofUpload,files, type, fileWidth, fileHeight) {
	var maxfilesize = ''
	var maxfilesize_title = '' 
	console.log("idofUpload",idofUpload);
	if (type == 'image') //1=image
	{
		 maxfilesize = MEDIUM_CATEGORY_IMAGE_SIZE.replace('MB', '');
		 maxfilesize_title = MEDIUM_CATEGORY_IMAGE_SIZE;
	}
	else if (type == 'video')//2=video
	{
		 maxfilesize = MEDIUM_CATEGORY_VIDEO_SIZE.replace('MB', '');
		 maxfilesize_title = MEDIUM_CATEGORY_VIDEO_SIZE;
	}
	else { //3=audio
		 maxfilesize = MEDIUM_CATEGORY_AUDIO_SIZE.replace('MB', '');
		 maxfilesize_title = MEDIUM_CATEGORY_AUDIO_SIZE;
	}
	medium_file_size = maxfilesize * 1024 * 1024; // ....convert in bytes
	console.log("medium_file_size", medium_file_size, files.size);
	var errorClass = idofUpload+'_err';
	if (files.size > medium_file_size) {
		console.log("case1");
		$('.' + errorClass).text("File size is not greater than " + maxfilesize_title);
		$('#' + idofUpload).focus();
		$('#' + idofUpload).val();
	    return false
	} else {
		$('.' + errorClass).text('')
			return await commonReadImageFile(idofUpload, files, fileWidth, fileHeight, type) 
		
		
	}
}

 async function uploadFile(idofUpload, fileType,  fileWidth, fileHeight) {
	var file = _(idofUpload).files[0];
	$('#'+idofUpload+"_status").text('')
	$('#'+idofUpload+"_progressBar").val('')
	$('#'+idofUpload+"_loaded_n_total").text('')
	$('#'+idofUpload+"_hidden").val('')
	var fileValidation = await fileSizeCheck(idofUpload, file, fileType, fileWidth, fileHeight)
	if(!fileValidation){
		return false;
	} else {
	$('#'+idofUpload+"_progressBar").show('')
	var formdata = new FormData();
	formdata.append("upload_file", file);
	// formdata.append("controllerName", controllerName);
	formdata.append("fileType", fileType);

	var ajax = new XMLHttpRequest();
	ajax.upload.uploadedId=idofUpload;
	ajax.upload.addEventListener("progress", progressHandler, false);

	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);

	ajax.open("POST", WOSA_ADMIN_URL +'common/auto_common_file_upload')
	ajax.send(formdata);
	
	}
  }
  
  function progressHandler(event) {
	var uploadedId =event.target.uploadedId
	_(uploadedId+"_loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
	var percent = (event.loaded / event.total) * 100;
	_(uploadedId+"_progressBar").value = Math.round(percent);
	_(uploadedId+"_status").innerHTML = Math.round(percent) + "% uploaded... please wait";
  }
  
  function completeHandler(event) {
	var uploadedId = event.target.upload.uploadedId
	var msg = event.target.responseText == ''? 'somthing went worng' : 'file uploaded successfully';
	// Swal.fire({
	// 	position: 'top-end',
	// 	icon: event.target.responseText != ''?'success': 'error',
	// 	title: msg,
	// 	showConfirmButton: false,
	// 	timer: 2500
	//   })
	_(uploadedId+"_status").innerHTML = '';
	_(uploadedId+"_hidden").value= event.target.responseText
	// _(uploadedId+"_progressBar").style.display="none" //wil clear progress bar after successful upload
	_(uploadedId+"_loaded_n_total").innerHTML= ''
  }
  
  function errorHandler(event) {
	var uploadedId = event.target.upload.uploadedId
	_(uploadedId+"_progressBar").style.display="none"
	_(uploadedId+"_loaded_n_total").innerHTML= ''
	// _(uploadedId+"_status").innerHTML = "Upload Failed";
  }
  
  function abortHandler(event) {
	var uploadedId = event.target.upload.uploadedId
	_(uploadedId+"_progressBar").style.display="none"
	_(uploadedId+"_loaded_n_total").innerHTML= ''
	// _(uploadedId+"_status").innerHTML = "Upload Aborted";
  }

  function check_test_preparation_duplicacy(topic) {
	var topic_id = $('#topic_id_hidden').val();
	if (topic == '') {
		$('.topic_err').text('Please type topic');
		$('#topic').focus();
		$('.sbm').prop('disabled', true);
		return false;
	} else {
		$('.topic_err').text('');
		$('.sbm').prop('disabled', false);
	}
	$.ajax({
		url: WOSA_ADMIN_URL + 'test_preparation_material_topic/ajax_check_freeresourcetopic_duplicacy',
		async: false,
		type: 'post',
		data: { topic: topic, topic_id: topic_id },
		dataType: 'json',
		success: function (response) {
			if (response > 0) {
				$('.topic_err').text('Please type unique name.' + topic + ' already exist');
				$('#topic_name').val('');
				$('#topic_name').focus();
				$('.sbm').prop('disabled', true);
				return false;
			} else {
				$('.topic_err').text('');
				$('.sbm').prop('disabled', false);
			}
		}
	});
}

$(document).on('click', '#hcancel_upload', function () {
	$('#submit_btn').prop('disabled', false);
	document.getElementById('filelist').innerHTML = '';

});
//word count limit
$('.validatewordcount').keyup(function () {
	var id = $(this).attr('id');
	var id_err = id + '_err'; //create class for message display
	// var maxCount = $(this).data('count');
	var minCount = $(this).data('min-count');
	var entervword = $(this).val();
	var words = entervword.split(" ");
	charlenght = entervword.length;
	// word length
	words = words.filter(function (words) {
		return words.length > 0
	}).length;
	// $("#msg_despChar").text('')
	$("." + id_err).text('Entered Characters : ' + charlenght);
	if (charlenght < minCount) {
		$("." + id_err).text('Minimum length should ' + minCount + ' characters ' + '     Entered Characters : ' + charlenght + '  Entered Words : ' + words);
		// $("#msg_despChar").text('')
		return false;
	} else {
		$("." + id_err).text('Entered Characters : ' + charlenght + '  Entered Words : ' + words)
		// $("#msg_despChar").text('Entered Characters : ' + charlenght + '  Entered Words : ' + words);
		return false;
	}
});

//----------------ck editor----------------------
function checkWordCountCkEditor(id) {
	var editornew = CKEDITOR.replace(id, {
		toolbar: [{
				name: 'document',
				groups: ['mode', 'document', 'doctools'],
				items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']
			},
			//{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
			//{ name: 'editing', groups: [ 'find', 'selection' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
			//{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
			'/',
			{
				name: 'basicstyles',
				groups: ['basicstyles', 'cleanup'],
				items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat']
			},
			{
				name: 'paragraph',
				groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
				items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']
			},
			{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
			//{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
			{ name: 'insert', items: [ 'Table' ] },
			'/',
			{
				name: 'styles',
				items: ['Format', 'Font', 'FontSize']
			},
			{
				name: 'colors',
				items: ['TextColor', 'BGColor']
			},
			{
				name: 'tools',
				items: ['Maximize', 'ShowBlocks']
			},
			{
				name: 'others',
				items: ['-']
			},
			//{ name: 'about', items: [ 'About' ] }
		],
		toolbarGroups: [{
				name: 'document',
				groups: ['mode', 'document', 'doctools']
			},
			//{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
			//{ name: 'editing', groups: [ 'find', 'selection' ] },
			//{ name: 'forms' },
			'/',
			{
				name: 'basicstyles',
				groups: ['basicstyles', 'cleanup']
			},
			{
				name: 'paragraph',
				groups: ['list', 'indent', 'blocks', 'align', 'bidi']
			},
			{ name: 'links' },
			//{ name: 'insert' },
			'/',
			{
				name: 'styles'
			},
			{
				name: 'colors'
			},
			{
				name: 'tools'
			},
			{
				name: 'others'
			},
			//{ name: 'about' }
		],
		removeButtons: 'Source',
		/*extraPlugins: 'wordcount',
		wordcount: {
			showWordCount: true,
			maxWordCount: 3 
		}
		/*wordcount: {
			showWordCount: true, 
			showCharCount: false,
			maxWordCount: 3,
			//maxCharCount: 10,
			paragraphsCountGreaterThanMaxLengthEvent: function (currentLength, maxLength) {
				$("#informationparagraphs").css("background-color", "crimson").css("color", "white").text(currentLength + "/" + maxLength + " - paragraphs").show();
			},
			wordCountGreaterThanMaxLengthEvent: function (currentLength, maxLength) {
				$("#informationword").css("background-color", "crimson").css("color", "white").text(currentLength + "/" + maxLength + " - word").show();
			},
			charCountGreaterThanMaxLengthEvent: function (currentLength, maxLength) {
				$("#informationchar").css("background-color", "crimson").css("color", "white").text(currentLength + "/" + maxLength + " - char").show();
			},
			charCountLessThanMaxLengthEvent: function (currentLength, maxLength) {
				$("#informationchar").css("background-color", "white").css("color", "black").hide();
			},
			paragraphsCountLessThanMaxLengthEvent: function (currentLength, maxLength) {
				$("#informationparagraphs").css("background-color", "white").css("color", "black").hide();
			},
			wordCountLessThanMaxLengthEvent: function (currentLength, maxLength) {
				$("#informationword").css("background-color", "white").css("color", "black").hide();
			}
		}*/
	});
	editornew.on('key', function(evt) {
		var MaxLengthWord = parseInt('2000');
		var minLengthWord = parseInt('300');
		setTimeout(function() {
			var chtml = CKEDITOR.instances[id].getData();
			var str = CKEDITOR.instances[id].getData().replace(/<[^>]*>/gi, '');
			str = str.replace(/\&nbsp;/g, '').trim();
			var strWord = 0;
			$("." + id + '_err').html('');
			if (str.length > 0) {
				strWord = str.split(' ').length;
			} else {
				$("." + id + '_err').html('Enter Message');
			}
			if(id=='description'){
				$("." + id + '_err').html('You must write minimum 30 Words');
			}else if(id=='body'){
				$("." + id + '_err').html('You must write minimum 5 Words');
			}else if (strWord > 1 && strWord < minLengthWord) {
				$("." + id + '_err').html('You must write minimum ' + minLengthWord + ' Words');
			}
			if (strWord > 1 && strWord > MaxLengthWord) {
				$("." + id + '_err').html('Allowed Maximum ' + MaxLengthWord + ' Words');
			}
			if (strWord > MaxLengthWord) {
				var xxx = strWord - MaxLengthWord;
				var strext = str.split(' ').slice(parseInt(-xxx)).join(' ');
				chtml = chtml.split(" ").slice(0, parseInt(-xxx)).join(" ");
				CKEDITOR.instances[id].setData(chtml);
				strWord = MaxLengthWord;
			}
			$("#" + id + "_counter_label").html('Entered Word :' + strWord);
			$("#" + id).val(str);
		}, 10);
	});
}

$(document).on("input", ".allow_alphabets", function(evt) {
	var self = $(this);
	self.val(self.val().replace(/[^a-zA-Z ]/, ""));
	if ((evt.which < 65 || evt.which > 90)) {
		evt.preventDefault();
	}
});
$(document).on("input", ".allow_decimal", function(evt) {
	var self = $(this);
	self.val(self.val().replace(/[^0-9\.]/g, ''));
	if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
		evt.preventDefault();
	}
});

function percentage_validation(field) {
	var field_id = $(field).attr('id');
	var regex =  /^([0-9]{1,2}\.[0-9]{1,2})$/;
	var x = $(field).val();
	$('.' + field_id + '_err').html('');
	var x = parseFloat(x).toFixed(1);
	if (isNaN(x)) {
		$(field).val('');
		$('.' + field_id + '_err').html('Enter valid percentage');
	} else if (x >= 100) {
		$(field).val('');
		$('.' + field_id + '_err').html('Enter valid percentage');
	}
	else if(!regex.test($(field).val()))
	{
		var splitval = x.split('.');
		if(splitval[0] > 0)
		{
			$(field).val(parseFloat(splitval[0]).toFixed(1));
		}
		else{
			$(field).val('');
			$('.' + field_id + '_err').html('Enter valid percentage');

		}
		
	}
	return true;
}

function calculate_tax(summerdivid=null,price)
{
	// alert(price);
	let cgst_per = 0;
	let sgst_per = 0;
	var prc = parseFloat(price).toFixed(2);
	$.ajax({
		url: WOSA_ADMIN_URL + 'student/ajax_gettax_detail',
		dataType:'json',
		async: false,
		success: function(data){
			cgst_per = parseFloat(data.cgst_per);
			sgst_per = parseFloat(data.sgst_per);
		}
	});
	var  cgst_tax = (price * cgst_per)/100;
	var  sgst_tax = (price * sgst_per)/100;
	var cgst_amt = parseFloat(cgst_tax).toFixed(2);
	var sgst_amt = parseFloat(sgst_tax).toFixed(2)
	var total = parseFloat(prc) + parseFloat(cgst_amt) + parseFloat(sgst_amt);
	$('#'+summerdivid+' #orignalprice').html(currency+'&nbsp;'+prc);
	$('#'+summerdivid+' #cgst_tax_new').html(currency+'&nbsp;'+cgst_amt);
	$('#'+summerdivid+' #sgst_tax_new').html(currency+'&nbsp;'+sgst_amt);
	$('#'+summerdivid+' #totalamount').html(currency+'&nbsp;'+ parseFloat(total).toFixed(2));
	$('#'+summerdivid+' #totalpayableamt').val(parseFloat(total).toFixed(2));
	//$('#'+summerdivid).show();
	if(price)
	{
		$('#'+summerdivid).show();
	}
	
}
