<?php
/*------navjeet-----------*/
define('LARGE_CATEGORY_IMAGE_SIZE','5MB');
define('MEDIUM_CATEGORY_IMAGE_SIZE','1MB');
define('SMALL_CATEGORY_IMAGE_SIZE','100KB');
define('LARGE_CATEGORY_VIDEO_SIZE','50MB');
define('MEDIUM_CATEGORY_VIDEO_SIZE','25MB');
define('SMALL_CATEGORY_VIDEO_SIZE','10MB');
define('LARGE_CATEGORY_AUDIO_SIZE','10MB');
define('MEDIUM_CATEGORY_AUDIO_SIZE','6MB');
define('SMALL_CATEGORY_AUDIO_SIZE','3MB');
/*---Web banner*/
define('WEB_BANNER_IMAGE_PATH', './uploads/web_banner/image/');
define('WEB_BANNER_VIDEO_PATH', './uploads/web_banner/video/');
define('WEB_BANNER_IMAGE_TYPE','webp');
define('WEB_BANNER_VIDEO_TYPE','mp4|mp3|wav|ogg|mpeg');
/*----ends---*/
/*---product card*/
define('PRODUCT_CARD_IMAGE_PATH', './uploads/product_card/image/');
define('PRODUCT_CARD_VIDEO_PATH', './uploads/product_card/video/');
define('PRODUCT_CARD_IMAGE_TYPE','webp');
define('PRODUCT_CARD_VIDEO_TYPE','mp4|mp3|wav|ogg|mpeg');
define('PROFILE_PIC_FILE_TYPE','jpg|png|jpeg|webp');

/*----ends---*/
/*---USP count*/
define('USP_COUNT_LENGHT', 6);
/*----ends---*/
define('GET_CNT_URL', 'WOSA-API-V1/Get_country');
define('GET_PP_COURSE', 'WOSA-API-V1/practice_packs/Get_PP_TestModule');
//define('GET_PP_PGM', 'WOSA-API-V1/practice_packs/Get_PP_programe');
define('GET_PP_DURATION', 'WOSA-API-V1/practice_packs/Get_pp_duration');
define('GET_PACKPAGE_BATCH', 'WOSA-API-V1/online_courses/Get_package_batch');
define('GET_CLASSROOM_SCHEDULE', 'WOSA-API-V1/online_courses/Get_package_classroom');
define('GET_PP_CATEGORY', 'WOSA-API-V1/practice_packs/Get_pp_category');
define('GET_SERVICE_DATA_URL', 'WOSA-API-V1/Get_service_data');
define('GET_SERVICE_DATA_All_URL', 'WOSA-API-V1/Get_service_data_all');
define('GET_SERVICE_DATA_BY_ID_URL', 'WOSA-API-V1/Get_service_data_by_id');
define('GET_NEWS_DATA_URL', 'WOSA-API-V1/news/Get_news_data');
define('GET_All_NEWS_DATA_URL', 'WOSA-API-V1/news/Get_news_data_all');
define('GET_PINNED_NEWS_DATA_URL', 'WOSA-API-V1/news/Get_pinned_news_data');
define('GET_NEWS_TAGS_DATA_URL', 'WOSA-API-V1/news/Get_news_tag_data');
define('GET_NEWS_DATA_BY_ID_URL', 'WOSA-API-V1/news/Get_news_data_by_id');
define('SUBMIT_PROFILE_PIC_URL', 'WOSA-API-V1/student/Submit_student_profile_pic');
define('UPDATE_PACK', 'WOSA-API-V1/bookings/Update_pack');
define('CHECKOUT_TRACKING_URL', 'WOSA-API-V1/Checkout_tracking');
define('VERIFY_ENQ_OTP_STD_URL', 'WOSA-API-V1/student/Verify_enqopt_student');
define('UPDATE_STUDENT_ADDRESS', 'WOSA-API-V1/student/Update_student_address');
define('GET_PHOTO_GALLERY_DATA_URL', 'WOSA-API-V1/gallery/Get_all_gallery');
define('GET_VIDEO_GALLERY_DATA_URL', 'WOSA-API-V1/video/Get_all_video');
define('GET_FAQ_DATA_URL', 'WOSA-API-V1/faq/Get_all_faq');
define('GET_ANNOUNCEMENTS_COUNT_URL', 'WOSA-API-V1/student/Get_announcement_count');
define('GET_ONN_COURSE_TYPE', 'WOSA-API-V1/online_courses/Get_onlineCourse_type');
define('DEFINE_NIL', 'NIL');
define('CHECKOUT_TRACKING_URL_COUNSELLING', 'WOSA-API-V1/Checkout_tracking_counselling');
define('GET_ONL_PGM', 'WOSA-API-V1/Get_programe');



define('COURSE_TYPE_MASTER_UPDATE', 'Course type updated');
define('COURSE_TYPE_ADD', 'New Course Type added');
define('GET_SHARED_DOCS_COUNT_URL', 'WOSA-API-V1/shared_doc/Get_shared_doc_count');
define('GET_SHARED_DOCS_URL_FILTER_COUNT', 'WOSA-API-V1/shared_doc/Get_shared_doc_filter_count');
define('GET_REC_LEC_URL_COUNT', 'WOSA-API-V1/recorded_lectures/Get_recorded_lectures_count');
define('GET_ALL_CLASSROOM_MATERIAL', 'WOSA-API-V1/student/Get_all_classroom_material');
define('GET_ONLINE_PACK_COUNT', 'WOSA-API-V1/online_courses/Get_online_pack_count');
define('GET_ALL_PP_PACK_URL_LONG_COUNT', 'WOSA-API-V1/practice_packs/Get_all_pp_pack_long_count');
define('LOAD_MORE_LIMIT', 6);
define('LOAD_MORE_LIMIT_8', 8);
define('LOAD_MORE_LIMIT_10', 10);
define('CLASSROOM_ALL_MATERIAL_REFRESH_TIME', 20000);//1000=millisec
define('PACKAGE_MAX_DURATION', 180);//6=month

define('MENU_ICON_FILE_PATH', '/resources/img/user2-160x160.jpg');//live
define('MAX_CLASS_DURATION', 14400);//14400(min)=4h
define('PAYMENT_STATUS_URL', 'booking/payment_status');
define('PAYMENT_STATUS_URL_CC', 'counseling/payment_status');
define('GET_PROVINCES', 'WOSA-API-V1/provinces/Get_provinces');
define('GET_PROVINCES_IMAGES', 'WOSA-API-V1/provinces/Get_provinces_image');
define('GET_PROVINCES_SHORT', 'WOSA-API-V1/provinces/Get_provinces_short');
define('SUBMIT_ENQUIRY_AGENT', 'WOSA-API-V1/become_agent/Submit_enquiry_agent');
define('GET_ACADEMY_SERVICE_URL', 'WOSA-API-V1/Get_service_data_academy');
/* file size validation */
define('COMMON_IMAGE_PATH', './uploads/common/image/');
define('COMMON_VIDEO_PATH', './uploads/common/video/');
define('COMMON_AUDIO_PATH', './uploads/common/audio/');
define('COMMON_IMAGE_TYPE','webp|gif');
define('COMMON_VIDEO_TYPE','mp4|mp3|wav|ogg|mpeg');
define('COMMON_AUDIO_TYPE','mp3|wav|ogg|mpeg');
define('PACK_IMAGE_TYPE_ALLOW','image/webp');
define('PACK_IMAGE_WIDTH','355');
define('PACK_IMAGE_HEIGHT','270');
define('PACK_IMAGE_SIZE_LABEL','Accept img Size '.PACK_IMAGE_WIDTH.'x'.PACK_IMAGE_HEIGHT);
/* ends file size validation */
/*---- Third party used constant ----*/
define('FOURMODULE_DOMAIN_ID', '255');
define('FOURMODULE_ONL_BRANCH_ID', '4765');

define('FOURMODULE_IELTS_ACD_INDIAN', '6');
define('FOURMODULE_IELTS_GT_INDIAN', '7');
define('FOURMODULE_CD_IELTS_ACD_INDIAN', '6');
define('FOURMODULE_CD_IELTS_GT_INDIAN', '7');
define('FOURMODULE_PTE_INDIAN', '65');
define('FOURMODULE_CELPIP_INDIAN', '5');
define('FOURMODULE_FLIP_INDIAN', '187');
define('FOURMODULE_CAEL_INDIAN', '44');
define('FOURMODULE_TOEFL_INDIAN', '');

define('FOURMODULE_IELTS_ACD_INTERNATIONAL', '151');
define('FOURMODULE_IELTS_GT_INTERNATIONAL', '152');
define('FOURMODULE_CD_IELTS_ACD_INTERNATIONAL', '151');
define('FOURMODULE_CD_IELTS_GT_INTERNATIONAL', '152');
define('FOURMODULE_PTE_INTERNATIONAL', '141');
define('FOURMODULE_CELPIP_INTERNATIONAL', '');
define('FOURMODULE_FLIP_INTERNATIONAL', '');
define('FOURMODULE_CAEL_INTERNATIONAL', '');
define('FOURMODULE_TOEFL_INTERNATIONAL', '');

define('FOURMODULE_KEY', 'api_key dWp9c2d4ZX1pYmY/dik6JTgqYCgkNSA5I3AyITQ9 api_secret ZFdwOWMyZDRaWDFwWW1ZL2RpazZKVGdxWUNna05TQTVJM0F5SVRROQ==');
define('FOURMODULE_URL', 'https://api.fourmodules.com/centreapi/api.php');
define('IDENTIFY_FOURMODULE_API', 'WOSA-API-V1/fourmodule/identify_api');
/* ---ends----- */
?>
