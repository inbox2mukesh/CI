<?php
global $customJs;

$siteUrl    = (is_https() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/';
$adminUrl   = $siteUrl.'adminController/';
define('WOSA_BASE_URL',$siteUrl);
define('WOSA_ADMIN_URL',$adminUrl);
define('DISCOUNT_MULTIPLE_COUNTRY_CURRENCY','USD');
$countryTypeArray = array('Single','Multiple');
define('COUNTRY_TYPE',$countryTypeArray);

define('PREFIX_ONLINE_PACK_ID','ONP-');
define('PREFIX_INHOUSE_PACK_ID','INP-');
define('PREFIX_PRACTICE_PACK_ID','PP-');
define('PREFIX_REALITY_OFFLINE_TEST_ID','RT-');
define('PREFIX_REALITY_ONLINE_TEST_ID','ONRT-');

define('LIST_RECORD_ACTIONS',array('Active','InActive','Publish','Unpublish'));
define('TIMEZONE_TYPES',array('Base','Native'));
define('TIMEZONE_INDIA_ID','100');
define('TIMEZONE_INDIA_UTC','+05:30');
define('DEFAULT_TIMEZONE_UTC','+05:30');
define('CURRENT_UTC_TIME',gmdate("Y-m-d h:i A"));

$dateObj                    = new \DateTime(CURRENT_UTC_TIME);
$dateObj->setTimeZone(new DateTimeZone(DEFAULT_TIMEZONE_UTC));

$current_DefaultTimeZone_Date                    = $dateObj->format("Y-m-d");
$current_DefaultTimeZone_Time_Timestamp          = $dateObj->format("h:i A");
$current_DefaultTimeZone_DateTime                = $dateObj->format("Y-m-d h:i A");
$current_DefaultTimeZone_DateTime_Timestamp      = strtotime($current_DefaultTimeZone_DateTime);

define('CURRENT_DEFAULT_TIMEZONE_DATE',$current_DefaultTimeZone_Date); //Y-m-d format
define('CURRENT_DEFAULT_TIMEZONE_TIME_TIMESTAMP',$current_DefaultTimeZone_Time_Timestamp); //h:i A format
define('CURRENT_DEFAULT_TIMEZONE_DATETIME',$current_DefaultTimeZone_DateTime); //Y-m-d h:i A format
define('CURRENT_DEFAULT_TIMEZONE_DATETIME_TIMESTAMP',$current_DefaultTimeZone_DateTime_Timestamp); //DateTime strtotime format

define('REALITY_TEST_STATUS',array('1'=>'Upcoming','2'=>'In-Progress','3'=>'Completed'));

function callCommonJSFileVariables() { ?>
    <script>
        var WOSA_BASE_URL                       = '<?php echo WOSA_BASE_URL; ?>';
        var WOSA_ADMIN_URL                      = '<?php echo WOSA_ADMIN_URL; ?>';
        var INDIA_ID                            = '<?php echo INDIA_ID; ?>';
        var WAIVED_OFF_SERVICE_ID               = '<?php echo WAIVED_OFF_SERVICE_ID; ?>';
        var ENROLL_SERVICE_ID                   = '<?php echo ENROLL_SERVICE_ID; ?>';
        var ONLINE_BRANCH_ID                    = '<?php echo ONLINE_BRANCH_ID; ?>';
        var ACADEMY_SERVICE_REGISTRATION_ID     = '<?php echo ACADEMY_SERVICE_REGISTRATION_ID; ?>';
        var TRAINER                             = '<?php echo TRAINER; ?>';
        var FILE_SUCCESS_MSG                    = '<?php echo FILE_SUCCESS_MSG; ?>';
        var FILE_FAILED_MSG                     = '<?php echo FILE_FAILED_MSG; ?>';
        var MEDIUM_CATEGORY_IMAGE_SIZE          = '<?php echo MEDIUM_CATEGORY_IMAGE_SIZE; ?>';
        var MEDIUM_CATEGORY_VIDEO_SIZE          = '<?php echo MEDIUM_CATEGORY_VIDEO_SIZE; ?>';
        var MEDIUM_CATEGORY_AUDIO_SIZE          = '<?php echo MEDIUM_CATEGORY_AUDIO_SIZE; ?>';
        var FORM_ERROR_TIME_SLOTS_RT            = '<?php echo form_error('time_slots_rt'); ?>';
        var DISCOUNT_MULTIPLE_COUNTRY_CURRENCY  = '<?php echo DISCOUNT_MULTIPLE_COUNTRY_CURRENCY; ?>';
    </script>
    <?php
}

function is_https() {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
        return 1;
    }
}

if(DEFAULT_COUNTRY == 38) { //Canada
    define("WORKSHOP_COURSES",['IELTS Academic','IELTS General Training','PTE','French']);
}
elseif(DEFAULT_COUNTRY == 13) { //Australia
    define("WORKSHOP_COURSES",['IELTS Academic','IELTS General Training','PTE']);
}
else {
    define("WORKSHOP_COURSES",['IELTS Academic','IELTS General Training','CD-IELTS Academic','CD-IELTS General Training','CELPIP General','CELPIP General LS','Duolingo','French','German','Italian','OET','PTE Academic','Spanish','Spoken English','TOEFL']);
}
?>