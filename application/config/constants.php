<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
global $customJS;
define('JS_CSS_VERSION', '0.0.1');
define('ADMIN', 'Super Admin');
define('BASEURL', 'http://localhost/ca/');
///////////////////////////////////settings start///////////////////////////////////////
define('WOSA_ONLINE_DOMAIN', 0);
define('INDIA_ID', 101);
define('DEFAULT_COUNTRY', '38');//canada
//define('DEFAULT_COUNTRY', '13');//Australia
//define('DEFAULT_COUNTRY', '101');//india

if(DEFAULT_COUNTRY==38){

	if(ENVIRONMENT=='development'){
		define('SESSION_VAR', 'admin_login_data_ca_development');
		define('COOKIE_USERNAME', 'wosa_username_ca_development');
		define('COOKIE_PWD', 'wosa_pwd_ca_development');
	}else if(ENVIRONMENT=='testing'){
		define('SESSION_VAR', 'admin_login_data_ca_testing');
		define('COOKIE_USERNAME', 'wosa_username_ca_testing');
		define('COOKIE_PWD', 'wosa_pwd_ca_testing');
	}else if(ENVIRONMENT=='staging'){
		define('SESSION_VAR', 'admin_login_data_ca_staging');
		define('COOKIE_USERNAME', 'wosa_username_ca_staging');
		define('COOKIE_PWD', 'wosa_pwd_ca_staging');
	}else if(ENVIRONMENT=='production_testing'){
		define('SESSION_VAR', 'admin_login_data_ca_production_testing');
		define('COOKIE_USERNAME', 'wosa_username_ca_production_testing');
		define('COOKIE_PWD', 'wosa_pwd_ca_production_testing');
	}else if(ENVIRONMENT=='production'){
		define('SESSION_VAR', 'admin_login_data_ca_production');
		define('COOKIE_USERNAME', 'wosa_username_ca_production');
		define('COOKIE_PWD', 'wosa_pwd_ca_deproduction');
	}else{
		define('SESSION_VAR', '');
	}
	
	define('STAMP', 'resources-f/images/mock_test_reprt_images/Canada-Stamp.png');
	define('LOGO', 'resources-f/images/logo-sm.webp');
	define('MAIL_LOGO', 'resources-f/images/can_logo.png');
	define('CURRENCY', 'CAD');
	define('TIME_ZONE', 'America/Toronto');

	define('LOGO_IELTS', 'resources-f/images/mock_test_reprt_images/logo-sm.png');//ielts,cd-ielts
	define('LOGO_PTE', 'resources-f/images/mock_test_reprt_images/mock_test_logo.png');
	define('LOGO_TOEFL', 'resources-f/images/mock_test_reprt_images/can_logo_white.png');

	define('CU_PHONE', '+1 (902) 537-1344');
	define('CU_EMAIL', 'info@westernoverseas.ca');
	define('CU_EMAIL2', 'ankit@westernoverseas.ca');
	define('ADMIN_NAME', 'Mr. Ankit Kumar');
	define('Licence_No', '<span class="text-red">Licence No.</span> R706700');

	define('WOSA', 'Team Western Overseas Immigration');
	define('COMPANY', 'Western Overseas Immigration');
	define('COMPANY_URL', 'https://westernoverseas.ca/');
	define('COMPANY_ADDRESS', "Unit 260, 7025 Tomken Rd, Mississauga, Ontario");
	define('SUPPORT_CONTACT','+1 (902) 537-1344');
	define('PAN_ACCOUNT_NUMBER', '1010101010');
	define('GST_NUMBER', '1111122222');

	define('ADMIN_EMAIL','info@westernoverseas.ca');
	define('ADMISSION_EMAIL', 'info@westernoverseas.ca');
	define('FROM_NAME','Western Overseas Immigration');

	define('TESTINGURL', 'https://westernoverseas.ca/canada-production-testing/adminController/dashboard');
	define('LIVEURL', 'https://westernoverseas.ca/adminController/dashboard');

}else if(DEFAULT_COUNTRY==13){

	if(ENVIRONMENT=='development'){
		define('SESSION_VAR', 'admin_login_data_au_development');
		define('COOKIE_USERNAME', 'wosa_username_au_development');
		define('COOKIE_PWD', 'wosa_pwd_au_development');
	}else if(ENVIRONMENT=='testing'){
		define('SESSION_VAR', 'admin_login_data_au_testing');
		define('COOKIE_USERNAME', 'wosa_username_au_testing');
		define('COOKIE_PWD', 'wosa_pwd_au_testing');
	}else if(ENVIRONMENT=='staging'){
		define('SESSION_VAR', 'admin_login_data_au_staging');
		define('COOKIE_USERNAME', 'wosa_username_au_staging');
		define('COOKIE_PWD', 'wosa_pwd_au_staging');
	}else if(ENVIRONMENT=='production_testing'){
		define('SESSION_VAR', 'admin_login_data_au_production_testing');
		define('COOKIE_USERNAME', 'wosa_username_au_production_testing');
		define('COOKIE_PWD', 'wosa_pwd_au_production_testing');
	}else if(ENVIRONMENT=='production'){
		define('SESSION_VAR', 'admin_login_data_au_production');
		define('COOKIE_USERNAME', 'wosa_username_au_production');
		define('COOKIE_PWD', 'wosa_pwd_au_deproduction');
	}else{
		define('SESSION_VAR', '');
	}
	define('STAMP', 'resources-f/images/mock_test_reprt_images/Australia-Stamp.png');
	define('LOGO', 'resources-f/images/logo-sm-aus.png');
	define('MAIL_LOGO', 'resources-f/images/logo-sm-aus.png');
	define('CURRENCY', 'AUD');
	define('TIME_ZONE', 'Australia/Adelaide');	

	define('LOGO_IELTS', 'resources-f/images/mock_test_reprt_images/logo-sm-aus.png');//ielts,cd-ielts
	define('LOGO_PTE', 'resources-f/images/mock_test_reprt_images/logo-sm-aus.png');
	define('LOGO_TOEFL', 'resources-f/images/mock_test_reprt_images/logo-sm-aus.png');

	define('CU_PHONE', '+61-430-439-035');
	define('CU_EMAIL', 'info@westernoverseas.com.au');
	define('CU_EMAIL2', 'anil@westernoverseas.com.au');
	define('ADMIN_NAME', 'Mr. Anil Kumar');
	define('Licence_No', '<span class="text-red">Licence No.</span> xxxxxxx');

	define('WOSA', 'Team Western Overseas Study & Immigration');
	define('COMPANY', 'Western Overseas Study & Immigration');
	define('COMPANY_URL', 'https://westernoverseas.com.au/');
	define('COMPANY_ADDRESS', "Level 1, Suit 102, 2Queen St, Melbourne CBD 3000");
	define('SUPPORT_CONTACT','+61-430-439-035');
	define('PAN_ACCOUNT_NUMBER', '1010101010');
	define('GST_NUMBER', '1111122222');

	define('ADMIN_EMAIL','info@westernoverseas.ca');
	define('ADMISSION_EMAIL', 'info@westernoverseas.ca');
	define('FROM_NAME','Western Overseas Immigration');

	define('TESTINGURL', 'https://westernoverseas.com.au/au-production-testing/adminController/dashboard');
	define('LIVEURL', 'https://westernoverseas.com.au/adminController/dashboard');

}else if(DEFAULT_COUNTRY==101){

	if(ENVIRONMENT=='development'){
		define('SESSION_VAR', 'admin_login_data_in_development');
		define('COOKIE_USERNAME', 'wosa_username_in_development');
		define('COOKIE_PWD', 'wosa_pwd_in_development');
	}else if(ENVIRONMENT=='testing'){
		define('SESSION_VAR', 'admin_login_data_in_testing');
		define('COOKIE_USERNAME', 'wosa_username_in_testing');
		define('COOKIE_PWD', 'wosa_pwd_in_testing');
	}else if(ENVIRONMENT=='staging'){
		define('SESSION_VAR', 'admin_login_data_in_staging');
		define('COOKIE_USERNAME', 'wosa_username_in_staging');
		define('COOKIE_PWD', 'wosa_pwd_in_staging');
	}else if(ENVIRONMENT=='production_testing'){
		define('SESSION_VAR', 'admin_login_data_in_production_testing');
		define('COOKIE_USERNAME', 'wosa_username_in_production_testing');
		define('COOKIE_PWD', 'wosa_pwd_in_production_testing');
	}else if(ENVIRONMENT=='production'){
		define('SESSION_VAR', 'admin_login_data_in_production');
		define('COOKIE_USERNAME', 'wosa_username_in_production');
		define('COOKIE_PWD', 'wosa_pwd_in_deproduction');
	}else{
		define('SESSION_VAR', '');
	}
	define('STAMP', 'resources-f/images/mock_test_reprt_images/India-Online-Stamp.png');
	define('LOGO', 'resources-f/images/logo-sm.webp');
	define('MAIL_LOGO', 'resources-f/images/can_logo.png');
	define('CURRENCY', 'INR');
	define('TIME_ZONE', 'Asia/Kolkata');

	define('LOGO_IELTS', 'resources-f/images/mock_test_reprt_images/logo-sm.png');//ielts,cd-ielts
	define('LOGO_PTE', 'resources-f/images/mock_test_reprt_images/mock_test_logo.png');
	define('LOGO_TOEFL', 'resources-f/images/mock_test_reprt_images/can_logo_white.png');

	define('CU_PHONE', '+1 (902) 537-1344');
	define('CU_EMAIL', 'info@westernoverseas.ca');
	define('CU_EMAIL2', 'ankit@westernoverseas.ca');
	define('ADMIN_NAME', 'Mr. Pradeep Balyan');
	define('Licence_No', '<span class="text-red">Licence No.</span> xxxxxxx');

	define('WOSA', 'Team Western Overseas Study Abroad');
	define('COMPANY', 'Western Overseas Study Abroad');
	define('COMPANY_URL', 'https://www.westernoverseas.online/');

	define('COMPANY_ADDRESS', "");
	define('SUPPORT_CONTACT','');
	define('PAN_ACCOUNT_NUMBER', '1010101010');
	define('GST_NUMBER', '1111122222');

	define('ADMIN_EMAIL','info@westernoverseas.ca');
	define('ADMISSION_EMAIL', 'info@westernoverseas.ca');
	define('FROM_NAME','Western Overseas Immigration');

	define('TESTINGURL', 'https://www.westernoverseas.online/wosa_online-production-testing/adminController/dashboard');
	define('LIVEURL', 'https://www.westernoverseas.online/adminController/dashboard');
}else{

}
define('THANKS', 'Thanks and Regards');
define('MOCK_TEST_SIGNATURE', 'resources-f/images/mock_test_reprt_images/sign.png');
define('MALE', 'resources-f/images/mock_test_reprt_images/male.png');
define('FEMALE', 'resources-f/images/mock_test_reprt_images/female.png');
define('WATER_MARK', 'resources-f/images/mock_test_reprt_images/water-mark.png');

define('ONLINE_BRANCH_ID', 10);
define('GMT_TIME', 'GMT-5');//live

define('ACD_ID', 1);
define('GT_ID', 2);
define('NONE', 3);

define('IELTS_ID', 1);
define('PTE_ID', 2);
define('IELTS_CD_ID', 3);
define('TOEFL_ID', 4);
define('FRENCH_ID', 5);
define('GERMAN_ID', 6);
define('CAEL_ID', 7);
define('UKVI_CD_IELTS', 0);

define('ACADEMY_DIVISION_PKID', 1);
define('VISA_DIVISION_PKID', 2);

if(ENVIRONMENT == 'development' or ENVIRONMENT == 'testing'){
	define('WOSA_API_KEY', 'wosa');
}else{
	define('WOSA_API_KEY', 'fc5354654529b02a569394jfrdca55d28baad15eba');
}
define('PLAIN_PWD', 'wosa@699');// 7f1f4376ae77615de2f68908cb83c3b8

define('PP_URL', 'https://www.paypal.com/cgi-bin/webscr');//live
define('PP_BUSINESS', 'Ankit@westernoverseas.ca');//live
define('PP_CMD', '_xclick');
define('PP_RM', '2');
define('PP_CURRENCY_CODE', 'USD');
///////////////////////////// settings closed////////////////////////////////////////////

define('CACHE_ENGINE', 'memcached');
//define('CACHE_ENGINE', 'redis');
define('BACKEND_DIR', 'adminController');
define('WOSA_API_DIR', 'WOSA-API-V1');
define('DESIGN_VERSION', 'resources');
define('DESIGN_VERSION_F', 'resources-f');

define('TRAINER', 'Trainer');
//Roles
//define('EMPLOYEE_ROLE_ID', 18);
define('REGISTRATION_COACHING', 2);
define('ENROLL_SERVICE_ID', 3);
define('WAIVED_OFF_SERVICE_ID', 7);
define('ACADEMY_SERVICE_REGISTRATION_ID', 14);
define('ONLINE_SIGNUP', 15);
define('TERMINATION_ID', 17);
define('DROPPED', 4);
define('UNREGISTERED_SERVICE_ID', 13);

//Tests all
define('IELTS', 'IELTS');
define('IELTS_CD', 'CD-IELTS');
define('PTE', 'PTE');
define('TOEFL', 'TOEFL');
//category names IELTS
define('READING',  'Reading');
define('LISTENING','Listening');
define('WRITING',  'Writing');
define('SPEAKING', 'Speaking');

//Programs
define('ACD','Academic');
define('GT','General Training');
define('ACD_GT', 'Academic and General Training');

//Paginations
define('RECORDS_PER_PAGE', 10);
define('COOKIE_EXPIRY', 86400);
define('PWD_LEN', 6);

define('INHOUSE', 'Inhouse');
define('ONLINE', 'Online');

//Units
define('PAPER_DURATION_UNIT', 'Min.');
define('PERCENT','%');
define('CLASS_DURATION', 30);

//master API
define('GET_CONTENTS', 'WOSA-API-V1/Get_contents');
define('GET_ALL_SOURCE_URL', 'WOSA-API-V1/Get_all_source');
define('GET_ALL_TIMESLOTS_URL', 'WOSA-API-V1/Get_all_timeSlots');
define('GET_ALL_GND_URL', 'WOSA-API-V1/Get_all_gender');
define('GET_ALL_QUA_URL', 'WOSA-API-V1/Get_all_qualification');
define('GET_ALL_DOC_TYPE_URL', 'WOSA-API-V1/Get_all_document_type');
define('GET_PASSPORT_DOC_TYPE_URL', 'WOSA-API-V1/Get_passport_document_type');
define('GET_ALL_TEST_URL', 'WOSA-API-V1/Test_module');
define('GET_ALL_PGM_URL', 'WOSA-API-V1/Programe');
define('GET_ALL_CNT_URL', 'WOSA-API-V1/Get_country');
define('GET_ALL_DEAL_CNT_URL', 'WOSA-API-V1/Get_deal_country');
define('GET_ALL_CNT_CODE_URL', 'WOSA-API-V1/Get_country_code');
define('GET_ENQ_PURPOSE_URL', 'WOSA-API-V1/Get_enquiry_purpose');
define('GET_ENQ_BRANCH_URL', 'WOSA-API-V1/Get_enqBranch');
define('GET_NON_OVERSEAS_BRANCH_URL', 'WOSA-API-V1/Get_non_overseas_branch');
define('GET_LONG_BRANCH_URL', 'WOSA-API-V1/contact_us/Get_long_branch');
define('GET_LONG_BRANCH_OVERSEAS_URL', 'WOSA-API-V1/contact_us/Get_long_branchoverseas');
define('GET_SHORT_BRANCH_URL', 'WOSA-API-V1/Get_branch');
define('SEND_CLASS_ATTENDANCE', 'WOSA-API-V1/attendance/Class_attendance');
define('GET_ALL_STATE_URL', 'WOSA-API-V1/Get_state');
define('GET_ALL_CITY_URL', 'WOSA-API-V1/Get_city');
define('GET_CLASS_SCH_URL_LONG_FILTER', 'WOSA-API-V1/student/Get_class_schedule_long_filter');

//Free resource
define('FREE_RESOURCE_CONTENT_FEATURED','WOSA-API-V1/free_resource/Free_resource_contents_featured');
define('FREE_RESOURCE_CONTENT', 'WOSA-API-V1/free_resource/Free_resource_contents');
define('FREE_RESOURCE_SECTION', 'WOSA-API-V1/free_resource/Free_resource_section');
define('GET_FREE_RESOURCE_COURSE', 'WOSA-API-V1/free_resource/Get_free_resource_course');
define('GET_FREE_RESOURCE_CONTENT_TYPE', 'WOSA-API-V1/free_resource/Get_free_resource_content_type');
define('FREE_RESOURCE_CONTENT_FILTER', 'WOSA-API-V1/free_resource/Free_resource_contents_filter');
define('FREE_RESOURCE_CONTENT_SHORT', 'WOSA-API-V1/free_resource/Free_resource_contents_short');
define('CHECK_FREE_RESOURCE', 'WOSA-API-V1/free_resource/Free_resource_check');

//enquiry
define('SUBMIT_ENQUIRY_URL', 'WOSA-API-V1/enquiry/Submit_enquiry');

//STUDENT POST
define('GET_STD_POST_URL', 'WOSA-API-V1/student/Get_student_post');
define('SUBMIT_STD_POST_URL', 'WOSA-API-V1/student/Submit_student_post');
define('SUBMIT_STD_POST_COMMENT_URL', 'WOSA-API-V1/student/Submit_student_post_comment');

//practice pack
define('GET_ALL_PRACTICE_TEST_MODULE_URL','WOSA-API-V1/practice_packs/Get_all_practice_test_module');
//short
define('GET_CD_IELTS_PP_PACK_URL', 'WOSA-API-V1/practice_packs/Get_cd_ielts_pp_pack_short');
define('GET_IELTS_PP_PACK_URL', 'WOSA-API-V1/practice_packs/Get_ielts_pp_pack_short');
define('GET_PTE_PP_PACK_URL', 'WOSA-API-V1/practice_packs/Get_pte_pp_pack_short');
define('GET_SE_PP_PACK_URL', 'WOSA-API-V1/practice_packs/Get_se_pp_pack_short');
define('GET_ALL_PP_PACK_URL', 'WOSA-API-V1/practice_packs/Get_all_pp_pack_short');
//long
define('GET_CD_IELTS_PP_PACK_URL_LONG', 'WOSA-API-V1/practice_packs/Get_cd_ielts_pp_pack_long');
define('GET_IELTS_PP_PACK_URL_LONG', 'WOSA-API-V1/practice_packs/Get_ielts_pp_pack_long');
define('GET_PTE_PP_PACK_URL_LONG', 'WOSA-API-V1/practice_packs/Get_pte_pp_pack_long');
define('GET_SE_PP_PACK_URL_LONG', 'WOSA-API-V1/practice_packs/Get_se_pp_pack_long');
define('GET_ALL_PP_PACK_URL_LONG', 'WOSA-API-V1/practice_packs/Get_all_pp_pack_long');

//classroom
define('GET_CLASSROOM_NAME', 'WOSA-API-V1/classroom/Get_classroom_data');

//offline courses
define('GET_OFF_BRANCH', 'WOSA-API-V1/offline_courses/Get_offlineCourse_branch');
define('GET_OFF_COURSE', 'WOSA-API-V1/offline_courses/Get_offlineCourse_TestModule');
define('GET_OFF_PGM', 'WOSA-API-V1/offline_courses/Get_offlineCourse_programe');
define('GET_OFF_COURSE_DURATION', 'WOSA-API-V1/offline_courses/Get_offlineCourse_duration');
define('GET_OFF_COURSE_MODULE', 'WOSA-API-V1/offline_courses/Get_offlineCourse_category');
define('GET_OFFLINE_PACK', 'WOSA-API-V1/offline_courses/Get_offline_pack');

//online course
define('GET_ONN_COURSE', 'WOSA-API-V1/online_courses/Get_onlineCourse_TestModule');
define('GET_ONN_PGM', 'WOSA-API-V1/online_courses/Get_onlineCourse_programe');
define('GET_ONN_COURSE_DURATION', 'WOSA-API-V1/online_courses/Get_onlineCourse_duration');
define('GET_ONN_COURSE_MODULE', 'WOSA-API-V1/online_courses/Get_onlineCourse_category');
define('GET_ONLINE_PACK', 'WOSA-API-V1/online_courses/Get_online_pack');
define('GET_PACK_DETAILS_URL', 'WOSA-API-V1/Get_pack_details');

//Student
define('SUBMIT_STD_URL', 'WOSA-API-V1/student/Submit_student_reg');
define('VERIFY_STD_URL', 'WOSA-API-V1/student/Verify_student');
define('LOGIN_STD_URL', 'WOSA-API-V1/student/Student_login');
define('FP_STD_URL', 'WOSA-API-V1/student/Forgot_password');
define('UPDATE_STD_URL', 'WOSA-API-V1/student/Update_profile');
define('UPDATE_LOGOUT_STD_URL', 'WOSA-API-V1/student/Update_profile_logout');
define('CHANGE_PWD_URL', 'WOSA-API-V1/student/Change_password');
define('GET_STD_INFO_URL', 'WOSA-API-V1/student/Get_student_info');
define('GET_CUR_PACK_URL', 'WOSA-API-V1/student/Cur_pack');
define('GET_ALL_ORDER_URL', 'WOSA-API-V1/student/AllOrder');
define('GET_CLASS_SCH_URL_SHORT', 'WOSA-API-V1/student/Get_class_schedule_short');
define('GET_CLASS_SCH_URL_LONG', 'WOSA-API-V1/student/Get_class_schedule_long');
define('GET_STD_WALLET_HISTORY', 'WOSA-API-V1/student/Get_student_wallet_history');
define('GET_SPECIAL_PROMOCODES', 'WOSA-API-V1/student/Get_special_promocodes');
define('DOC_STATUS', 'WOSA-API-V1/student/Get_document_status');
define('GET_WALLET', 'WOSA-API-V1/student/Get_wallet_amount');
define('GET_ALL_ORDER_DATE_URL', 'WOSA-API-V1/student/AllOrderDate');
define('UPDATE_OTP', 'WOSA-API-V1/student/Update_otp');
define('STU_PACK_START_DATE', 'WOSA-API-V1/student/Get_student_pack_date');
define('GET_CLASS_SCH_URL_LONG_COUNT', 'WOSA-API-V1/student/Get_class_schedule_long_count');

//announcements
define('GET_ANNOUNCEMENTS_URL', 'WOSA-API-V1/student/Get_announcement');
define('GET_ALL_ANNOUNCEMENTS_URL', 'WOSA-API-V1/student/Get_all_announcement');

//live lecture
define('GET_REC_LEC_URL', 'WOSA-API-V1/recorded_lectures/Get_recorded_lectures');
define('GET_REC_LEC_CONTENT_TYPE_URL', 'WOSA-API-V1/recorded_lectures/Get_recorded_lecture_content_type');

//shared docs
define('GET_SHARED_DOCS_URL', 'WOSA-API-V1/shared_doc/Get_shared_doc');
define('GET_SHARED_DOCS_DESC_URL', 'WOSA-API-V1/shared_doc/Get_shared_doc_desc');
define('GET_SHARED_DOCS_CONTENT_TYPE_URL', 'WOSA-API-V1/shared_doc/Get_shared_doc_content_type');
define('GET_SHARED_DOCS_URL_FILTER', 'WOSA-API-V1/shared_doc/Get_shared_doc_filter');

//REALITY TEST REPORTS
define('GET_RT_REPORTS_URL', 'WOSA-API-V1/reality_test_report/Get_all_rt_report');
define('GET_RT_REPORT_DATA_URL', 'WOSA-API-V1/reality_test_report/Get_rt_report_data');

//Mock test reports
define('GET_MOCK_REPORTS_URL', 'WOSA-API-V1/mock_test_report/Get_all_mock_report');
define('GET_MOCK_REPORT_DATA_URL', 'WOSA-API-V1/mock_test_report/Get_mock_report_data');

//Reciept
define('GET_RECIEPT_URL', 'WOSA-API-V1/reciept/Get_reciept');

//FAQ
define('GET_ALL_FAQ_URL', 'WOSA-API-V1/faqs/Get_all_faq');
define('GET_ALL_FAQ_URL_FILTER', 'WOSA-API-V1/faqs/Get_all_faq_filter');

//booking
define('BUY_PACK', 'WOSA-API-V1/bookings/Buy_pack');
define('BOOK_SESSION', 'WOSA-API-V1/counseling_session/Book_session');
define('CREATE_SESSION', 'WOSA-API-V1/counseling_session/Create_session');
define('VERIFY_SESSION_URL', 'WOSA-API-V1/counseling_session/Verify_session');
define('UPDATE_SESSION_URL', 'WOSA-API-V1/counseling_session/Update_session');
//counseling_session
define('GET_SESSION_TYPE_URL', 'WOSA-API-V1/counseling_session/Get_session_type');
define('GET_SESSION_COURSE_URL', 'WOSA-API-V1/counseling_session/Get_session_course');
define('GET_SESSION_BRANCH_URL', 'WOSA-API-V1/counseling_session/Get_session_branch');
define('GET_SESSION_DATES_URL', 'WOSA-API-V1/counseling_session/Get_session_dates');
define('GET_SESSION_TIMESLOT_URL', 'WOSA-API-V1/counseling_session/Get_session_timeSlot');
define('GET_FINAL_SESSION_URL', 'WOSA-API-V1/counseling_session/Get_final_session');
define('GET_STUDENT_SESSION_URL', 'WOSA-API-V1/counseling_session/Get_session_booking');

define('GET_REC_LEC_URL_FILTER', 'WOSA-API-V1/recorded_lectures/Get_recorded_lectures_filter');

define('GET_STUDENT_EXISTENCE_URL', 'WOSA-API-V1/Check_student_existence');
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);
/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                       OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                 OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')   OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); 
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); 
defined('FOPEN_WRITE_CREATE')               OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')          OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')        OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')   OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0);// no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1);// generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3);// configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4);// file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5);// unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6);// unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7);// invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8);// database error
defined('EXIT__AUTO_MIN') 	   OR define('EXIT__AUTO_MIN', 9);//lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

//file paths
define('TEMP_PATH', './uploads/temp/');
define('POST_REPLY_IMAGE_PATH', './uploads/student_post_reply/');
define('STUDENT_POST_PIC_FILE_PATH', './uploads/student_post/');
define('EMP_IMAGE_PATH', './uploads/employees/');
define('LIVE_LECTURE_IMAGE_PATH', './uploads/live_lecture/');
define('GALLERY_IMAGE_PATH', './uploads/gallery/');
define('PROFILE_PIC_FILE_PATH', './uploads/profile_pic/');
define('ANNOUNCEMENT_FILE_PATH', './uploads/classroom_announcements/');
define('CLASSPOST_FILE_PATH', './uploads/classroom_post/');
define('PAYMENT_SCREENSHOT_FILE_PATH_INHOUSE', './uploads/payment_file_inhouse/');
define('PAYMENT_SCREENSHOT_FILE_PATH_ONLINE', './uploads/payment_file_online/');
define('PAYMENT_SCREENSHOT_FILE_PATH_PP', './uploads/payment_file_pp/');
define('PACK_HOLD_FILE_PATH', './uploads/packOnHold_app_file/');
define('STD_DOC_FILE_PATH', './uploads/student_document/');
define('STD_WITHDRAWL_FILE_PATH', './uploads/student_withdrawl/');
define('FREE_RESOURCES_IMAGE_PATH', './uploads/free_resources/image/');
define('FREE_RESOURCES_VIDEO_PATH', './uploads/free_resources/video/');
define('FREE_RESOURCES_AUDIO_PATH', './uploads/free_resources/audio/');
define('CLASSROOM_DOCUMENTS_IMAGE_PATH', './uploads/classroom_documents/image/');
define('CLASSROOM_DOCUMENTS_VIDEO_PATH', './uploads/classroom_documents/video/');
define('CLASSROOM_DOCUMENTS_AUDIO_PATH', './uploads/classroom_documents/audio/');
define('PACKAGE_FILE_PATH', './uploads/package_file/');

//allowed file types
define('STUDENT_POST_ALLOWED_TYPES', 'jpg|png|jpeg|pdf');
define('ANNOUNCEMENT_ALLOWED_TYPES', 'jpg|png|jpeg|webp');
define('CLASSPOST_ALLOWED_TYPES', 'gif|jpg|png|jpeg');
define('GALLERY_ALLOWED_TYPES', 'gif|jpg|png|jpeg|mp4|mp3|svg|ico|webp');
define('EMP_ALLOWED_TYPES', 'jpg|png|jpeg');
define('LIVE_LECTURE_ALLOWED_TYPES', 'gif|jpg|png|jpeg');
define('PAYMENT_SCREENSHOT_TYPES', 'pdf|jpg|png|jpeg');
define('PACK_HOLD_TYPES', 'pdf|jpg|png|jpeg');
define('STD_DOC_TYPES', 'pdf|jpg|png|jpeg');
define('STD_WITHDRAWL_TYPES', 'pdf|jpg|png|jpeg');
define('FREE_RESOURCES_IMAGE_TYPES','jpg|png|jpeg');
define('FREE_RESOURCES_VIDEO_TYPES','mp4|webm|ogg');
define('FREE_RESOURCES_AUDIO_TYPES','mp3|wav|ogg|mpeg');
define('CLASSROOM_DOCUMENTS_IMAGE_TYPES','jpg|png|jpeg|pptx|ppt');
define('CLASSROOM_DOCUMENTS_VIDEO_TYPES','mp4|webm|ogg');
define('CLASSROOM_DOCUMENTS_AUDIO_TYPES','mp3');
define('CLASSROOM_DOCUMENTS_TYPES','mp3|wav|ogg|mpeg');
define('PACKAGE_FILE_TYPES', 'jpg|png|jpeg|webp');
define('WEBP_FILE_TYPES', 'webp');
define('WEBP_ALLOWED_TYPES_LABEL', '<span class="text-info"> [  <i><b>Allowed:</b> webp </i>  ] </span>');
define('DOCUMENT_ALLOWED_LABEL', '<span class="text-info"> [ <i><b>Allowed:</b>  jpg, png, jpeg, pdf</i> ] </span>');
define('POST_REPLY_ALLOWED_TYPES_LABEL', '<span class="text-info"> [  <i><b>Allowed:</b>  jpg, png, jpeg, pdf</i>  ] </span>');
define('PAYMENT_SCREENSHOT_ALLOWED_LABEL', '<span class="text-info"> [  <i><b>Allowed:</b>  jpg, png, jpeg, pdf</i>  ] </span>');
define('GALLERY_ALLOWED_TYPES_LABEL', '<span class="text-info"> [  <i><b>Allowed File:</b>  gif, jpg, png, jpeg, mp4, mp3, svg, webp, ico </i>  ] </span>');
define('EMP_ALLOWED_TYPES_LABEL', '<span class="text-info"> [  <i><b>Allowed:</b>  jpg, png, jpeg </i>  ] </span>');
define('LIVE_LECTURE_ALLOWED_TYPES_LABEL', '<span class="text-info"> [  <i><b>Allowed:</b>  gif, jpg, png, jpeg </i>  ] </span>');
define('DATE_FORMAT_LABEL', '<span class="text-info"> [  <i><b>Format:</b>  e.g. DD-MM-YYYY</i>  ] </span>');
define('ANNOUNCEMENTS_ALLOWED_TYPES_LABEL', '<span class="text-info"> [  <i><b>Allowed:</b>  jpg, png, jpeg, webp </i>  ] </span>');
define('CLASSPOST_ALLOWED_TYPES_LABEL', '<span class="text-info"> [  <i><b>Allowed:</b>  gif, jpg, png, jpeg </i>  ] </span>');
define('PACKAGE_ALLOWED_TYPES_LABEL', '<span class="text-info"> [  <i><b>Allowed:</b> jpg, png, jpeg, webp </i>  ] </span>');
define('PROFILE_PIC_ALLOWED_TYPES_LABEL', '<span class="text-info"> [  <i><b>Allowed:</b> jpg, png, jpeg </i>  ] </span>');
define('PACK_HOLD_ALLOWED_TYPES_LABEL', '<span class="text-info"> [  <i><b>Allowed:</b>jpg, png, jpeg, pdf </i>  ] </span>');
define('NEWS_ALLOWED_TYPES_LABEL', '<span class="text-info"> [  <i><b>Allowed File:</b>  gif, jpg, png, jpeg </i>  ] </span>');


define('GALLERY_URL_LABEL','Add');
define('GALLERY_URL_LABEL_LIST','List');

define('UNAUTHORIZED', 'Not Authorized OR Token is missing');
define('UNAUTHORIZED_LOGIN', 'Invalid Login Details!');
define('DELETE_CONFIRM', 'Are you sure you want to delete this item?');
define('SUBMISSION_CONFIRM', 'Are you sure you want to submit this item?');
//dates
$today=date('d-m-Y');
define('TODAY', $today);
$cyear  = date("y");
$year  = date("Y");
define('YY', $year);
$cmonth = date("M");

//$packStartingDate=date('d-m-Y');
//define('PACK_STARTING_DATE', $packStartingDate);

//Prefixes
//define('PREFIX_IELTS', 'IELTS-'.$cmonth.$cyear.'-');
//define('PREFIX_PTE', 'PTE-'.$cmonth.$cyear.'-');
//define('PREFIX_SE', 'SE-'.$cmonth.$cyear.'-');
//define('RT_PREFIX', 'RT-');
//seperator
define('SEP', '<span class="text-warning"> | </span>');


//login/reg
define('INVALID_LOGIN', 'Invalid Login Details!');
define('VALID_LOGIN', 'Loggedin Successfully.');
define('CREDS_NOTES', 'Auto email for Credential details and Pack taken details would be sent to this user if Send Mail field checked.');
define('ROLE_RULES', 'If you are creating/editing role for trainer please keep Trainer word in Role name.');

//Link targets
define('TARGET_B', '_blank');
define('TARGET_S', '_self');

//Labels
define('STATUS', '<span class="text-dark" title="Status"><i class="fa fa-check"></i></span>');
define('ACTION', 'Action');
define('SR',     'Sr.');
define('TS_EE','Test');
define('BG', 'bg-gray');

define('ITEM_NOT_EXIST', 'The item you are trying for does not exist.');
define('OPEN_FILE', 'Open File');
define('NO_FILE',   '<span class="text-info">No File</span>');
define('NO_ICON',   '<span class="text-info">No Icon</span>');
define('NA',        '<span class="text-info">N/A</span>');
define('NILL',      '<span class="text-info">NILL</span>');
define('PENDING',      '<span class="text-info">Pending</span>');

define('YES',      '<span class="text-success">Yes</span>');
define('NO',      '<span class="text-info">No</span>');

define('ACTIVE', '<span class="text-success"><i class="fa fa-check"></i></span>');
define('DEACTIVE', '<span class="text-red"><i class="fa fa-close cls-bg"></i></span>');
define('OPEN', '<span class="text-danger"><i class="fa fa-folder-open"></i></span>');
define('CLOSED', '<span class="text-warning"><i class="fa fa-folder"></i></span>');

//COMMOM MSG
define('TRAN_FAILED_MSG', '<div class="alert alert-warning alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>WARNING:</strong> Transaction failed? Try again!.<a href="#" class="alert-link"></a>.
                </div>');

define('PWD_CHANGE_SUCCESS_MSG', '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> Your password changed successfully.<a href="#" class="alert-link"></a>.
                </div>');

define('PWD_CHANGE_FAILED_MSG', '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>FAILED:</strong> Your password change failed? Try again!.<a href="#" class="alert-link"></a>.
                </div>');

define('SUCCESS_MSG','<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> Saved successfully.<a href="#" class="alert-link"></a>.
                </div>');

define('SEARCH_MSG', '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> Data fetched successfully.<a href="#" class="alert-link"></a>
                </div>');

define('SEARCH_MSG_404', '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    No search data !<a href="#" class="alert-link"></a>
                </div>');

define('ADMIN_LOGIN_ERR_MSG','<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>ERROR:</strong> username or password is wrong! Please try again!<a href="#" class="alert-link"></a>.
                </div>');

define('ADMIN_FP_ERR_MSG','<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>ERROR:</strong> username does not exist. Please try with correct username!<a href="#" class="alert-link"></a>.
                </div>');

define('ADMIN_FP_SUC_MSG','<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> Hi, Your password sent on mail. please check<a href="#" class="alert-link"></a>.
                </div>');

define('ADMIN_LOGIN_SUC_MSG','<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> Redirecting ! Please wait!<a href="#" class="alert-link"></a>.
                </div>');

define('UPDATE_MSG','<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> Updated successfully.<a href="#" class="alert-link"></a>.
                </div>');

define('UPDATE_FAILED_MSG','<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>UPDATION FAILED:</strong> Failed to update! Try again.<a href="#" class="alert-link"></a>.
                </div>');

define('FAILED_MSG','<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>FAILED:</strong> Failed to save! Try again.<a href="#" class="alert-link"></a>.
                </div>');

define('DEL_MSG','<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> Deleted successfully<a href="#" class="alert-link"></a>
                    </div>');

define('DEL_MSG_FAILED','<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> Delete FAILED<a href="#" class="alert-link"></a>
                    </div>');

define('DUP_MSG','<div class="alert alert-warning alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>DUPLICATE:</strong> Already exist, please try different!<a href="#" class="alert-link"></a>.
                </div>');

define('NEW_STD_MSG','<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>NEW CLIENT:</strong> Please add this client here.<a href="#" class="alert-link"></a>.
                </div>');

define('OLD_STD_MSG','<div class="alert alert-warning alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>EXISTING CLIENT:</strong> Please manage this student here.<a href="#" class="alert-link"></a>.
                </div>');

define('AUTHENTIC_MSD','<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Forbidden:</strong> You are doing wrong! please be carefull your activity logged.<a href="#" class="alert-link"></a>.
                </div>');

define('FILE_SUCCESS_MSG', '<h5 class="text-success"><strong><i>File uploaded successfully</strong></i></h5>');
define('FILE_FAILED_MSG', '<h5 class="text-warning"><strong><i>File upload failed! please try again</strong></i></h5>');



//SMS
define('API_ID', 'APIYhEf5Fey45904');
define('API_PASSWORD', 'nkqBGXLM');
define('API_SENDER', 'WSTERN');
define('API_URL', 'https://www.bulksmsplans.com/api/send_sms');

//enquiry
define('ENQ_SUC', 'Thanks! Your query sent successfully to Western Overseas Admin. We will get back to you soon.');
define('ENQ_FLD', 'Oops! Your query submission failed! Please try again.');

//social medias
define('FB',  'https://www.facebook.com/westernoverseas172');
define('YTD', 'https://www.youtube.com/channel/UCqvHFSJIuOlBQw7LPUTPHaw');
define('INST','https://www.instagram.com/accounts/login/');
define('TWT', 'https://twitter.com/westernoverseaa');
define('LI',  'https://www.linkedin.com/in/westernoverseas/');
define('PNT', 'https://in.pinterest.com/overseaswestern/');
define('GP',  'https://plus.google.com/u/0/+WesternOverseas');
define('TTK', 'https://vm.tiktok.com/ZMLAHMv6E/');
//Buttons
define('SAVE_LABEL', 'Submit');
define('UPDATE_LABEL', 'Update');
define('UPDATE_STUDENT_LABEL', 'Update Student details');
define('UPDATE_SAVE_LABEL', 'Save & Update');
define('SEARCH_LABEL', 'Search');

define('DWN_LABEL', 'Download');
define('ATTENDANCE_LABEL', 'Submit Attendance');
define('INHOUSE_LABEL', 'Submit Inhouse Pack');
define('ONLINE_LABEL', 'Submit Online Pack');
define('PP_LABEL', 'Submit Practice Pack');

define('PP_MOCK_DESC', ' Full Length Mock Test');
define('PP_L_DESC', ' Sectional Listening Test');
define('PP_R_DESC',  ' Sectional Reading Test');
define('PP_W_DESC', ' Sectional Writing Test');
define('PP_S_DESC', ' Sectional Speaking Test');

define('PAYMENT_OPTIONS', 	'<option value="">Select payment mode</option>
								<option value="cash" selected="selected">By cash</option>
								<option value="wallet">By Wallet</option>
								<option value="GooglePay">By Google Pay</option>
								<option value="paytm">By Paytm</option>
								<option value="card">By Card (Debit/Credit)</option>
								<option value="Net Banking">By Net Banking</option>
								<option value="Other">Other</option>');

define('PAYMENT_OPTIONS_WALLET', 	'<option value="">Select payment mode</option>
								<option value="cash" selected="selected">By cash</option>
								<option value="GooglePay">By Google Pay</option>
								<option value="paytm">By Paytm</option>
								<option value="card">By Card (Debit/Credit)</option>
								<option value="Net Banking">By Net Banking</option>
								<option value="Other">Other</option>');


define('AUTO', 'auto');
define('FILTER_BOX_COLOR', '#CDF4F6');

define('PACK_SUBSCRIPTION_SMS', 'Hi, thanks for purchasing a package with us. Package details are sent on your email. For more info login to westernoverseas.online Regards Western Overseas');

// By prabhat
define('GENERATE_SEND_LABEL', 'Generate Code & Send Now');
define('GENERATE_LABEL', 'Generate Code');
define('GENERATE_SCHEDULE_LABEL', 'Generate Code & Schedule');
// By Prabhat end

//By Neelu
#print array
function pr($array,$fl=0){
	
	echo "<pre>";
	print_r($array);
	echo "</pre>";
	if($fl){
		die('stop-debug');
	}
}
function getSessionType(){
    $array=array(
        'online'=>'Online',
        'In-Person'=>'In-Person'
    );
    return $array;
}
//By neelu end

    #Add Code On Line number 676---------------------
	/*function getEventFormType(){
		$array=array(
			'single-day-event'=>'Single Day Event',
			'single-event-on-multiple-days'=>'Single Event on Multiple Days',
			'cluster-event'=>'Cluster Event',
		);
		return $array;
	}
	function getEventLocationType(){
		$array=array(
			'inhouse'=>'Inhouse',
			'outhouse'=>'Outhouse',
			'online'=>'Online',
			'online-in-house'=>'Online & In-house'
		);
		return $array;
	}
	function getEventCapacity(){
		$array=array(
			'capped'=>'Capped',
			'uncapped'=>'Uncapped',
		);
		return $array;
	}	
	function getEventCharges(){
		$array=array(
			'Free'=>'Free',
			'paid'=>'Paid',
		);
		return $array;
	}
	function getEventPaymentType(){
		$array=array(
			'standard'=>'Standard',
			'location-varied'=>'Location Varied',
			'time-varied'=>'Time Varied',
		);
		return $array;
	}
	function getEventDuration(){
		$array=array(
			'time-slot'=>'Time Slot',
			'all-day'=>'All Day',
		);
		return $array;
	}

	function genEventId($id,$type='event'){
			if($type=='event_location'){
				$event_id='EVENTLOCATION';
			}else{
				
				$event_id='EVENT';
			}
			
			if($id <= 9){
				
				$event_id=$event_id.'00'.$id;  
			}else if($id <= 99){
				
				$event_id=$event_id.'0'.$id;
			}else{
				$event_id=$event_id.$id;
			}
			return $event_id;
	}
	
	function getEventStatus(){
			$array=array(
			
				'1'=>'In-Draft',
				'2'=>'Upcoming',
				'3'=>'In-Progress',
				'4'=>'Completed',
				'5'=>'Cancelled',
			);
			return $array;
	}

	function getOutHouseLocationType(){
		$array=array(
			'1'=>'Reality Test',
			'2'=>'Exam Booking',
			'3'=>'Event',
		);
		return $array;
    }
*/
define('TR_OFFLINE', '<th>Action</th>
<th>Status</th>
<th>Pack</th>
<th>Price/Duration</th>
<th>Classroom</th>
<th>Paid(Total)</th>
<th>Paid By Wallet</th>
<th>Ext. Amount</th>
<th>Waiver</th>
<th>Waiver By</th>
<th>other_discount</th>
<th>Dues</th>
<th>Irr. Dues</th>
<th>Due Commitment Date</th>
<th>Pack Hold Date</th>
<th>Wallet Refund</th>
<th>Pack Start Date</th>
<th>Expiry</th>
<th>Created</th>');

if(WOSA_ONLINE_DOMAIN==1){
	define('TR_ONLINE_OFFLINE', '<th>Action</th>
	<th>Status</th>
	<th>Pack</th>
	<th>Course/Program</th>
	<th>Price/Duration</th>
	<th>Classroom</th>
	<th>Paid(Total)</th>
	<th>Paid By Wallet</th>
	<th>Ext. Amount</th>
	<th>Waiver</th>
	<th>Waiver By</th>
	<th>Dues</th>
	<th>Irr. Dues</th>
	<th>Due Commitment Date</th>
	<th>Wallet Refund</th>
	<th>Pack Start Date</th>
	<th>Pack Hold Date</th>
	<th>Expiry</th>
	<th>Created</th>
	');
}else{
	define('TR_ONLINE_OFFLINE', '<th>Action</th>
	<th>Status</th>
	<th>Pack</th>
	<th>Course/Program</th>
	<th>Price/Duration</th>
	<th>Classroom</th>
	<th>Paid(Total)</th>
	<th>Paid By Wallet</th>
	<th>Ext. Amount</th>
	<th>Dues</th>
	<th>Irr. Dues</th>
	<th>Due Commitment Date</th>
	<th>Wallet Refund</th>
	<th>Pack Start Date</th>
	<th>Pack Hold Date</th>
	<th>Expiry</th>
	<th>Created</th>
	');
}

if(WOSA_ONLINE_DOMAIN==1){
	define('TR_PRACTICE_PACK', '<th>Action</th>
	<th>Status</th>
	<th>Pack</th>
	<th>Course/Program</th>
	<th>Price/Duration</th>
	<th>Paid(Total)</th>
	<th>Paid By Wallet</th>
	<th>Ext. Amount</th>
	<th>Waiver</th>
	<th>Waiver By</th>
	<th>Dues</th>
	<th>Irr. Dues</th>
	<th>Due Commitment Date</th>
	<th>Wallet Refund</th>
	<th>Pack Start Date</th>
	<th>Pack Hold Date</th>
	<th>Expiry</th>
	<th>Created</th>
	');
}else{
	define('TR_PRACTICE_PACK', '<th>Action</th>
	<th>Status</th>
	<th>Pack</th>
	<th>Course/Program</th>
	<th>Price/Duration</th>
	<th>Paid(Total)</th>
	<th>Paid By Wallet</th>
	<th>Ext. Amount</th>
	<th>Dues</th>
	<th>Irr. Dues</th>
	<th>Due Commitment Date</th>
	<th>Wallet Refund</th>
	<th>Pack Start Date</th>
	<th>Pack Hold Date</th>
	<th>Expiry</th>
	<th>Created</th>
	');
}

define('TR_SESSION', '<th>Session</th>
<th>Course</th>
<th>Branch</th>	
<th>Date/Time</th>
<th>Link</th>			                        
<th>Created</th>
<th>Has attended?</th>
th>remarks</th>
<th>Action</th>
');

define('UA_FIND', array('{', '}',':','"',',','\r\n','\u00a0'));
define('UA_REPLACE', array('', '',' => ','',', ','',''));
define('UA_SEP', '<br/><b class="text-danger"><i>&nbsp;EDITED TO&nbsp;</i></b><br/>');

define('SIGNIN', 'Sign In');
define('SIGNOUT', 'Sign Out');

define('SOLD_INHOUSE_PACK', 'Sold Inhouse pack');
define('SOLD_ONLINE_PACK', 'Sold Online pack');
define('SOLD_PRACTICE_PACK', 'Sold practice pack');
//define('SOLD_REALITY_TEST', 'Sold reality test');

define('DUE_DATE_EXTENSION', 'Due committment date extended');
define('PAYMENT_ADDED', 'Payment recieved');
define('PARTIAL_REFUND', 'Partial refund to wallet');
define('FULL_REFUND', 'FULL refund to wallet');
define('PACK_EXTENSION', 'Pack Extension');
define('BRANCH_SWITCH', 'Branch switch');
define('COURSE_SWITCH', 'Course switch');
define('BATCH_UPDATE', 'Batch update');
define('PACK_HOLD', 'Pack hold');
define('PACK_UNHOLD', 'Pack unhold');
define('PACK_TERMINATION', 'Pack Termination');
define('PACK_REACTIVATION', 'Pack Reactivation');
define('WAIVER_REMBURSE', 'Waiver Remburse');

define('DOC_ADDED', 'Document file uploaded');
define('WALLET_WITHDRAWL', 'Withdrawl from wallet');  
define('COUNSELLING_SESSION_STAUS', 'Counselling session status');

define('NEW_EMPLOYEE_REG', 'New employee registartion');
define('EMPLOYEE_REMOVAL', 'Employee removed from ERP');
define('EMPLOYEE_PROFILE_UPDATE', 'Employee profile update');
define('EMPLOYEE_PASSWORD_CHANGE', 'Employee password change');
define('EMPLOYEE_BRANCH_REMOVAL', 'Employee branch removed');
define('EMPLOYEE_COUNTRY_REMOVAL', 'Employee functional country removed');
define('EMPLOYEE_DIVISION_REMOVAL', 'Employee division removed');

define('WAIVER_APPROVAL', 'Waiver request approved');
define('WAIVER_DISAPPROVAL', 'Waiver request dis-Approved');
define('WAIVER_EXPIERD', 'Waiver request made expired');
define('WAIVER_REQUEST_REVERSAL', 'Waiver request reversed');
define('WAIVER_REQUEST_REMOVAL', 'Waiver request deleted');
define('WAIVER_REQUEST', 'New waiver request created');

define('REFUND_APPROVAL', 'Refund request approved');
define('REFUND_DISAPPROVAL', 'Refund request dis-Approved');
define('REFUND_EXPIERD', 'Refund made expired');
define('REFUND_REQUEST_REVERSAL', 'Refund request reversed');
define('REFUND_REQUEST_REMOVAL', 'Refund request deleted');
define('REFUND_REQUEST', 'New refund request created');

define('BRANCH_ADD', 'New branch added');
define('BRANCH_UPDATE', 'Branch updated');

define('BATCH_ADD', 'New Batch added');
define('BATCH_MASTER_UPDATE', 'Batch updated');
define('BATCH_MASTER_DELETE', 'Batch deleted');

define('DIVISION_ADD', 'New division added');
define('DIVISION_MASTER_UPDATE', 'Division name updated');
define('DIVISION_MASTER_DELETE', 'Division deleted');

define('COURSE_ADD', 'New course added');
define('COURSE_UPDATE', 'Course name updated');
define('COURSE_DELETE', 'Course deleted');

define('PROGRAME_ADD', 'New programe added');
define('PROGRAME_UPDATE', 'Programe name updated');
define('PROGRAME_DELETE', 'Programe deleted');

define('CATEGORY_ADD', 'New category added');
define('CATEGORY_UPDATE', 'Category name updated');
define('CATEGORY_DELETE', 'Category deleted');

define('ROLE_ADD', 'New role added');
define('ROLE_UPDATE', 'Role name updated');
define('ROLE_DELETE', 'Role deleted');
define('ROLE_REFRESH', 'All module refreshed');

define('ACTIVATION', 'Activate/Opened');
define('DEACTIVATION', 'DE-Activate/Closed');

define('ONLINE_PACKAGE_ADD', 'New online pack added');
define('ONLINE_PACKAGE_UPDATE', 'Online pack updated');
define('OFFLINE_PACKAGE_ADD', 'New offline pack added');
define('OFFLINE_PACKAGE_UPDATE', 'Offline pack updated');
define('PRACTICE_PACKAGE_ADD', 'New practice pack added');
define('PRACTICE_PACKAGE_UPDATE', 'practice pack updated');

define('MARKED_INHOUSE_ATTENDANCE', 'Inhouse attendance marked');

define('ENQUIRY_ADD', 'New enquiry added');
define('ENQUIRY_REPLY', 'Enquiry reply sent');

define('CLASSROOM_ADD', 'New classroom added');
define('CLASSROOM_UPDATE', 'Classroom updated');

define('QUALIFICATION_ADD', 'New qualification added');
define('QUALIFICATION_UPDATE', 'Qualification updated');
define('QUALIFICATION_DELETE', 'Qualification deleted');

define('GALLAEY_ADD', 'New gallery added');
define('GALLAEY_UPDATE', 'Gallery updated');

define('COUNTRY_ADD', 'New country added');
define('COUNTRY_UPDATE', 'Country updated');

define('STATE_ADD', 'New satate added');
define('STATE_UPDATE', 'State updated');

define('CITY_ADD', 'New city added');
define('CIYY_UPDATE', 'City updated');

define('UPDATE_SPECIAL_ACCESS', 'Special access updated');

define('CLASSROOM_ANNOUNCEMENT_ADD', 'New announcement for classroom added');
define('CLASSROOM_ANNOUNCEMENT_UPDATE', 'Announcement for classroom updated');

define('CONTENT_TYPE_ADD', 'New content type added');
define('CONTENT_TYPE_UPDATE', 'Content type updated');

define('METHOD_DESCRIPTION_UPDATE', 'Method description updated');
define('MODULE_DESCRIPTION_UPDATE', 'Module description updated');

define('COUNSELLING_SESSION_ADD', 'New counselling session added');
//define('COUNSELLING_SESSION_UPDATE', 'Counselling session updated');

define('EMPLOYEE_COURSE_DELETE', 'Employee course access removed');
define('EMPLOYEE_PROGRAME_DELETE', 'Employee course-programe access removed');
define('EMPLOYEE_BATCH_DELETE', 'Employee batch access removed');
define('EMPLOYEE_CATEGORY_DELETE', 'Employee course category access removed');

define('TRAINER_ACCESS_ADDED', 'Trainer access added');
define('TRAINER_ACCESS_UPDATED', 'Trainer access updated');
define('TRAINER_ACCESS_REMOVED', 'Trainer access removed');

define('DESIGNATION_MASTER_UPDATED', 'Dessignation upated');
define('DOCUMENT_MASTER_UPDATED', 'Document type upated');
define('FORGOT_PASSWORD', 'Password recovery by forgot password');
define('TIME_SLOT_UPDATE', 'Time slot update');
define('DEFAULT_PARENT_MENU_ICON', '<i class="fa fa-list"></i>');
define('DEFAULT_CHILD_MENU_ICON', '<i class="fa fa-arrow-right"></i>');

define('MDL', 'Logged out - Multiple device/browser login');
define('PAR', 'Logged out - Portal access revoked');
define('STO', 'Logged out - Session time out');
define('RC', 'Logged out - Role changed');
define('RL', 'Logged out - Regular');

define('SOURCE_ADD', 'New source added');
define('SOURCE_MASTER_UPDATE', 'Source name updated');
define('SOURCE_MASTER_DELETE', 'Source deleted');

/*****************Code Add By Neelu*******/
 include_once(FCPATH.'application/config/neelu-constants.php');
 include_once(FCPATH.'application/config/ashok-constants.php');
 include_once(FCPATH.'application/config/vikrant-constants.php');
 include_once(FCPATH.'application/config/navjeet-constants.php');
 include_once(FCPATH.'application/config/rajan-constants.php');
 include_once(FCPATH.'application/config/vikram-constants.php');
/*****************Code End By Neelu*******/

define('SERVICE_IMAGE_ALLOWED_TYPES', 'jpg|png|jpeg|webp');
define('SERVICE_IMAGE_ALLOWED_TYPES_LABEL', '<span class="text-info"> [  <i><b>Allowed File:</b>  jpg, png, jpeg </i>  ] </span>');
define('SERVICE_IMAGE_PATH', './uploads/service_image/');
define('IMMIGRATION_FILE_PATH', './uploads/immigration_tools/');
define('PROVINCES_FILE_PATH', './uploads/provinces/');

define('NEWS_FILE_PATH', './uploads/news/');
define('PHOTO_IMAGE_PATH', './uploads/photo/');
define('VIDEO_IMAGE_PATH', './uploads/video/');

define('IIMMIGRATION_ALLOWED_TYPES', 'gif|jpg|png|jpeg|webp');
define('PROVINCES_ALLOWED_TYPES', 'gif|jpg|png|jpeg|webp');
define('PROVINCES_IMAGE_ALLOWED_TYPES_LABEL', '<span class="text-info"> [  <i><b>Allowed File:</b>  gif, jpg, png, jpeg </i>  ] </span>');
define('VIDEO_ALLOWED_TYPES', 'mp4');
define('NEWS_ALLOWED_TYPES', 'gif|jpg|png|jpeg|webp');
define('PHOTO_ALLOWED_TYPES', 'gif|jpg|png|jpeg|webp');
define('AUTO_ENIT_ERP_SOFT', 'ERP Initiated(Soft)');
define('AUTO_ENIT_ERP_HARD', 'ERP Initiated(Hard)');

