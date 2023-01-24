<?php

/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Ashok Kumar
 *
 * */
define('LEADS_MAIN_BUCKET_SETTING', 'main_bucket');
define('LEADS_MY_LEAD_SETTING', 'my_leads');
define('SEND_OTP', 'Send OTP');
define('SUBMIT', 'Submit');
define('LEAD_COMPLAINT_EMAIL_SUBJECT', 'Hi, Your Complaint added by Team WOSA');
define('ADD_INFO', 'Add Information');
define('FEEDBACK_ADD', 'New feedback added');
define('FEEDBACK_REPLY', 'Feedback reply sent');
define('VERIFY', 'Verify');
define('RESEND_OTP', 'Resend OTP');
define('LEADS_HISTORY_BUCKET_SETTING', 'history_bucket');
define('LEADS_NQL_BUCKET_SETTING', 'nql_bucket');
define('LEADS_WALKIN_ENQ_BUCKET_SETTING', 'walkin_enq');
define('LEADS_IN_CALL_ENQ_BUCKET_SETTING', 'in_call_enq');
define('LEADS_WALKIN_LOGS_BUCKET_SETTING', 'walkin_log');
define('LEADS_IN_CALL_LOGS_BUCKET_SETTING', 'in_call_log');
define('ACA_VISA_L3_KEYS', ['center_id', 'int_country_id']);
define('LEADS_WALKIN_ENQ_HISTORY_BUCKET_SETTING', 'walkin_enq_his');
define('LEADS_IN_CALL_ENQ_HISTORY_BUCKET_SETTING', 'in_call_enq_his');
define('LEADS_NQL_HISTORY_BUCKET_SETTING', 'nql_bucket_his');
define('LEADS_ASSIGNED_BUCKET_SETTING', 'assign_lead');
define('LEADS_ASSIGNED_HISTORY_BUCKET_SETTING', 'assign_lead_his');
define('LEADS_ASSIGNED_WALKIN_BUCKET_SETTING', 'ass_walk_lead');
define('LEADS_ASSIGNED_WALKIN_HISTORY_BUCKET_SETTING', 'ass_walk_lead_his');
define('LEADS_ASSIGNED_IN_CALL_BUCKET_SETTING', 'ass_in_call_lead');
define('LEADS_ASSIGNED_IN_CALL_HISTORY_BUCKET_SETTING', 'ass_in_call_his');
define('LEADS_ATT_BRANCH_BUCKET_SETTING', 'att_branch');
define('LEADS_ATT_BRANCH_HISTORY_BUCKET_SETTING', 'att_branch_his');
define('LEADS_ATT_DEPT_BUCKET_SETTING', 'att_dept');
define('LEADS_ATT_DEPT_HISTORY_BUCKET_SETTING', 'att_dept_his');
define('LEADS_ATT_IN_BODY_BUCKET_SETTING', 'att_in_body');
define('LEADS_ATT_IN_BODY_HISTORY_BUCKET_SETTING', 'att_in_body_his');
define('CAMP_BOOKING_BUCKET_SETTING', 'camp_book');
define('CAMP_BOOKING_HISTORY_BUCKET_SETTING', 'camp_book_his');


define('GET_STUDENT_ID_BY_MOBILE', 'WOSA-API-V1/student/Get_student_id_by_mobile');
define('STORE_LEAD_COMPLAINTS', 'WOSA-API-V1/complaints/Store_complaints');

define('ACADEMY_FUNNEL_ADD', 'New Academy funnel setting added');
define('VISA_FUNNEL_ADD', 'New VISA funnel setting added');

function campaignBookingTableColumns() {
    return [
        'sr' => 'Sr.', 'campaign_uid' => 'Campaign UID', 'campaign_title' => 'Campaign Title', 'booking_no' => 'Booking No.', 'UID' => 'UID', 'name' => 'Name', 'phone' => 'Phone', 'email' => 'Email', 'origin_type' => 'Origin Type', 'origin' => 'Origin', 'medium' => 'Medium', 'medium_source' => 'Medium Source', 'division' => 'Division', 'original_purpose' => 'Original Purpose', 'campaign_type' => 'Campaign Type', 'campaign_category' => 'Campaign Category', 'lead_created_on' => 'Booking Created On', 'lead_updated_on' => 'Booking Updated On', 'action' => 'Action'
    ];
}

function nqlLeadsTableColumns() {
    return [
        'sr' => 'Sr.', 'UID' => 'UID', 'name' => 'Name', 'phone' => 'Phone', 'email' => 'Email', 'origin_type' => 'Origin Type', 'origin' => 'Origin', 'medium' => 'Medium', 'medium_source' => 'Medium Source', 'division' => 'Division', 'original_purpose' => 'Original Purpose', 'lead_created_on' => 'Lead Created On', 'lead_updated_on' => 'Lead Updated On', 'assigned_by' => 'Assigned By', 'assigned_to' => 'Assigned To', 'assigned_on' => 'Assigned On', 'type' => 'Type', 'action' => 'Action'
    ];
}

function leadsLogsTableColumns() {
    return [
        'sr' => 'Sr.', 'lead_created_on' => 'Walkin On', 'UID' => 'UID', 'name' => 'Name', 'phone' => 'Phone', 'email' => 'Email', 'medium' => 'Walkin Reason', 'original_purpose' => 'Original Purpose', 'branch' => 'Branch', 'division' => 'Division', 'assigned_by' => 'Attended By', 'type' => 'Type', 'action' => 'Action'
    ];
}

function p($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function leadComplaintEmailMessage(string $complaint_id) {
    return 'Your comlaints added successfully & Our team will shortly get in touch with you. Your complaint Id is: ' . $complaint_id;
}

function leadsInformationTabs() {
    return [
        'overview' => 'Overview',
        'education' => 'Education',
        'proficiency' => 'Proficiency',
        'work_history' => 'Work History',
        'visa_history' => 'Visa History',
        'relative_details' => 'Relative Details',
        'social_media' => 'Social Media',
        'eligibility' => 'Eligibility',
        'notes' => 'Notes',
        'journey' => 'Journey',
        'followups' => 'Followups',
        'action' => 'Action',
    ];
}

function productList() {
    /* return [
      '1' => ['name' => 'Inhouse Pack', 'division_id' => ACADEMY_DIVISION_PKID],
      '2' => ['name' => 'Online Pack', 'division_id' => ACADEMY_DIVISION_PKID],
      '3' => ['name' => 'Practice Pack', 'division_id' => ACADEMY_DIVISION_PKID],
      '4' => ['name' => 'Reality Test', 'division_id' => ACADEMY_DIVISION_PKID],
      '5' => ['name' => 'Exam Booking', 'division_id' => ACADEMY_DIVISION_PKID]
      ]; */
    return [
        ACADEMY_DIVISION_PKID => [
            ['id' => 1, 'name' => 'Inhouse Pack'],
            ['id' => 2, 'name' => 'Online Pack'],
            ['id' => 3, 'name' => 'Practice Pack'],
            ['id' => 4, 'name' => 'Reality Test'],
            ['id' => 5, 'name' => 'Exam Booking'],
            ['id' => 6, 'name' => 'Academy Events'],
        ],
        VISA_DIVISION_PKID => [
            ['id' => 7, 'name' => 'Visa Events'],
            ['id' => 8, 'name' => 'Study Visa'],
            ['id' => 9, 'name' => 'Visitor Visa'],
            ['id' => 10, 'name' => 'Work Visa'],
            ['id' => 11, 'name' => 'Dependent Visa']
        ]
    ];
}

function branchOrDepartment() {
    return [
        'branch' => 'Branch',
        'department' => 'Central Department',
        'in_body' => 'Independent Body'
    ];
}

function getRelationList() {
    return [
        'father' => 'Father',
        'mother' => 'Mother',
        'brother' => 'Brother',
        'sister' => 'Sister',
        'husband' => 'Husband',
        'wife' => 'Wife',
        'uncle' => 'Uncle',
        'aunt' => 'Aunt',
        'friend' => 'Friend'
    ];
}

/**
 * 
 * @param string $text
 * @return string
 */
function showPurposeChildLabel(string $text = NULL) {
    return '<span aria-hidden="true">&rarr;</span> ' . $text;
}

/**
 * 
 * @param string $text
 * @return string
 */
function showPurposeChildLabelCSV(string $text = NULL) {
    return ' -> ' . $text;
}

/**
 * 
 * @param int $division_id
 * @param int $product_id
 * @return string
 */
function filterProductList(int $division_id, int $product_id) {
    foreach (productList()[$division_id] as $product) {
        if ($product['id'] == $product_id) {
            return $product['name'];
        }
    }
    return '';
}

/**
 * 
 * @return array
 */
function yesNoLabels() {
    return ['0' => 'No', '1' => 'Yes'];
}

/**
 * 
 * @return array
 */
function tablePages() {
    return [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 200, 400, 600, 800, 1000];
}

/**
 * 
 * @return array
 */
function prioritiesPack() {
    return ['1' => 'Normal', '2' => 'Medium', '3' => 'High'];
}

/**
 * 
 * @return array
 */
function distributionChannels() {
    return ['1' => 'Auto', '2' => 'Mannual', '3' => 'Direct'];
}

/**
 * 
 * @param int $minutes
 * @param bool $is_html
 * @return string|array
 */
function calculateDaysHoursByMinutes(int $minutes, bool $is_html = TRUE) {
    $d = floor($minutes / 1440);
    $h = floor(($minutes - $d * 1440) / 60);
    $m = $minutes - ($d * 1440) - ($h * 60);
    if ($is_html == TRUE) {
        return "<span class='label label-info'>{$d} Day(s)</span> <span class='label label-primary'>{$h} Hour(s)</span> <span class='label label-success'>{$m} Minute(s)</span>";
    } else {
        return ['day' => $d, 'hour' => $h, 'minute' => $m];
    }
}

/**
 * 
 * @param array $sources
 * @return array
 */
function filterSourceNameFromArray(array $sources) {
    $pack = [];
    if ($sources) {
        foreach ($sources as $source) {
            $pack[] = $source['source_name'];
        }
    }
    return $pack;
}

/**
 * 
 * @param string $divisionId
 * @return array
 */
function getSearchFilterParameters(string $divisionId) {
    return [
        'lead_title' => '', 'dob' => '', 'origin_type' => '', 'origin' => '', 'medium' => '', 'medium_source' => '', 'calcification' => '', 'division_id' => $divisionId, 'distribution_channel' => '', 'priority_level' => '', 'pipeline_stage' => '', 'list' => '', 'tags' => '', 'lead_treatment' => '', 'lead_status' => '', 'branch' => '', 'assigned_by' => '', 'assigned_to' => '', 'purpose' => '', 'course' => '', 'interested_country' => '', 'lead_created' => '', 'program' => '', 'assigned_on' => ''
    ];
}

/**
 * 
 * @param string $divisionId
 * @return array
 */
function getSearchFilterFilledParameters(array $post, string $divisionId) {
    return [
        'lead_title' => isset($post['lead_title']) ? $post['lead_title'] : '',
        'dob' => isset($post['dob']) ? $post['dob'] : '',
        'origin_type' => isset($post['origin_type']) ? $post['origin_type'] : '',
        'origin' => isset($post['origin']) ? $post['origin'] : '',
        'medium' => isset($post['medium']) ? $post['medium'] : '',
        'medium_source' => isset($post['medium_source']) ? $post['medium_source'] : '',
        'calcification' => isset($post['calcification']) ? $post['calcification'] : '',
        'division_id' => isset($post['division_id']) ? $post['division_id'] : $divisionId,
        'distribution_channel' => isset($post['distribution_channel']) ? $post['distribution_channel'] : '',
        'priority_level' => isset($post['priority_level']) ? $post['priority_level'] : '',
        'pipeline_stage' => isset($post['pipeline_stage']) ? $post['pipeline_stage'] : '',
        'list' => isset($post['list']) ? $post['list'] : '',
        'tags' => isset($post['tags']) ? $post['tags'] : '',
        'lead_treatment' => isset($post['lead_treatment']) ? $post['lead_treatment'] : '',
        'lead_status' => isset($post['lead_status']) ? $post['lead_status'] : '',
        'branch' => isset($post['branch']) ? $post['branch'] : '',
        'assigned_by' => isset($post['assigned_by']) ? $post['assigned_by'] : '',
        'assigned_to' => isset($post['assigned_to']) ? $post['assigned_to'] : '',
        'purpose' => isset($post['purpose']) ? $post['purpose'] : '',
        'course' => isset($post['course']) ? $post['course'] : '',
        'interested_country' => isset($post['interested_country']) ? $post['interested_country'] : '',
        'lead_created' => isset($post['lead_created']) ? $post['lead_created'] : '',
        'program' => isset($post['program']) ? $post['program'] : '',
        'assigned_on' => isset($post['assigned_on']) ? $post['assigned_on'] : ''
    ];
}

/**
 * 
 * @return string
 */
function get_back_btn() {
    return $_SESSION['back_btn'];
}

/**
 * 
 * @param string $action
 * @param string $url
 * @return string
 */
function getPaginationSearchUrl($action, string $url) {
    if ($action == 'search') {
        return site_url("adminController/{$url}/search/?");
    } else {
        return site_url("adminController/{$url}?");
    }
}

function leadsQlHistoryTableColumns() {
    return [
        'sr' => 'Sr.','origin_type' => 'Origin Type', 'origin' => 'Origin', 'medium' => 'Medium', 'medium_source' => 'Medium Source', 'division' => 'Division', 'original_purpose' => 'Original Purpose', 'current_purpose' => 'Current Purpose', 'is_qualified' => 'Is Verified', 'lead_created_on' => 'Lead Created On', 'lead_updated_on' => 'Lead Updated On','type' => 'Type', 'action' => 'Action'
    ];
}
