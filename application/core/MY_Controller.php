<?php

/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'libraries/traits/timezoneTrait.php';
require_once APPPATH . 'libraries/traits/moveFileTrait.php';

class MY_Controller extends CI_Controller
{
    use timezoneTrait;
    use moveFileTrait;
    function __construct(){
        date_default_timezone_set(TIME_ZONE);
        parent::__construct();
        $this->load->helper(array('cookie', 'url'));
        $this->load->model('Role_model');
        $user = $this->session->userdata(SESSION_VAR);
        if (isset($user)) {
            foreach ($user as $d) {
                $role_id = $d->role_id;
                $role_name = $d->role_name;
            }
        } else {
            $role_id = 0;
            $role_name = '';
        }
        
        //$this->auto_set_back_btn();
    }    

    function auto_loadCaching($cacheEngine){
        $this->load->library('Cacher');
        $this->cacher->initiate_cache($cacheEngine); 
        $this->db->cache_on();
    } 

    function auto_cacheUpdate($controller){
        $this->db->cache_delete(BACKEND_DIR,$controller);
        $this->auto_cacheOff();
    }

    function auto_cacheUpdate_front($dir,$controller){
        $this->db->cache_delete($dir,$controller);
        $this->auto_cacheOff();
    }

    function auto_cacheOff(){
        $this->db->cache_off();
    }

    function addUserActivity($activity_name, $description, $student_package_id, $by_user){

        $ip = $this->input->ip_address();
        $isValidIP = $this->input->valid_ip($ip);
        if ($isValidIP) {
            $ipaddress = $ip;
        } else {
            $ipaddress = NA;
        }
        $user_Latitude = get_cookie('user_Latitude');
        $user_Longitude = get_cookie('user_Longitude');
        /*$endpoint = 'http://maps.google.com/maps/api/geocode/json?latlng='.$user_Latitude.','.$user_Longitude.'';
        $headers = array(
            'key:'.'test',  
        );
        $res = json_decode($this->_curlGetData($endpoint, $headers));
        print_r($res);die;*/
        $activityParams = array(
            'student_package_id' => $student_package_id,
            'dateStr' => strtotime(date('d-m-Y')),
            'activity_name' => $activity_name,
            'description' => $description,
            'by_user' => $by_user,
            'country' => '',
            'state' => '',
            'city' => '',
            'zip_code' => '',
            'IP_address' => $ipaddress,
            'latitude' => $user_Latitude,
            'longitude' => $user_Longitude,
            'organization' => '',
            'isProxy' => '',
            'isSuspicious' => '',
        );        
        $this->db->insert('user_activity', $activityParams);
        return $this->db->insert_id();
    }

    function _is_logged_in(){
        if (isset($_SESSION['employeeCode'])) {
        $this->load->model('User_model');
        $verifyAccess = $this->User_model->verifyAccess($_SESSION['employeeCode']);
        $portal_access = $verifyAccess['portal_access'];

        $verifyToken = $this->User_model->verifyToken($_SESSION['employeeCode']);
        $userToken = $verifyToken['token'];
        if($userToken = $_SESSION['token']){
            $ut = TRUE;
        }else{
            $ut = FALSE;
        }
        $user = $this->session->userdata(SESSION_VAR);
        if(!empty($user) and $ut and $portal_access == 1){
            return TRUE;
        }
    }
        return FALSE;
    }

    function _has_access($cn, $mn)
    {

        $user = $this->session->userdata(SESSION_VAR);
        foreach ($user as $d) {
            $role_id = $d->role_id;
            $role_name = $d->role_name;
        }
        if ($role_name != ADMIN) {
            $controller_data = $this->Role_model->check_controller($cn);
            foreach ($controller_data as $c) {
                $controller_id = $c['id'];
            }
            $method_data = $this->Role_model->check_method($mn, $controller_id);
            foreach ($method_data as $m) {
                $method_id = $m['id'];
            }
            $num = $this->Role_model->check_role_acess($role_id, $controller_id, $method_id);
            if ($num <= 0) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }

    function auto_PreventformResubmissionError(){
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
    }

    function _getorderTokens($length){
        $key = '';
        $keys = array_merge(range(0, 9), range('A', 'Z'));
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        return $key;
    }

    /////////////front///////////////////////////////////////////////////

    function _common($headers)
    {
        return json_decode($this->_curlGetData(base_url() . GET_SHORT_BRANCH_URL, $headers));
    }

    function _getURI()
    {
        $directoryURI = $_SERVER['REQUEST_URI'];
        $path = parse_url($directoryURI, PHP_URL_PATH);
        $components = explode('/', $path);
        return @$data['segment'] = $components[2];
    }

    function _getURI2()
    {
        $directoryURI = $_SERVER['REQUEST_URI'];
        $path = parse_url($directoryURI, PHP_URL_PATH);
        $components = explode('/', $path);
        return @$data['segment'] = $components[4];
    }

    function _getURI3()
    {
        $directoryURI = $_SERVER['REQUEST_URI'];
        $path = parse_url($directoryURI, PHP_URL_PATH);
        $components = explode('/', $path);
        return @$data['segment'] = $components[3];
    }

    public function _curlGetData($url, $headers)
    {

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_HEADER, 1);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $headers);
        $buffer = curl_exec($curl_handle);
        $header_size = curl_getinfo($curl_handle, CURLINFO_HEADER_SIZE);
        $body = substr($buffer, $header_size);
        curl_close($curl_handle);
        return $body;
    }

    public function _curPostData($url, $headers, $params)
    {

        $postData = json_encode($params);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => $headers,
        ));
        $response = curl_exec($curl);
       
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    function _call_smaGateway($mobile, $message)
    {

        $curl = curl_init();
        $data = array();
        $data['api_id']   = API_ID;
        $data['api_password'] = API_PASSWORD;
        $data['sms_type'] = "OTP";
        $data['sms_encoding'] = "1";
        $data['sender']  = API_SENDER;
        $data['number']  = $mobile;
        $data['message'] = $message;
        $data_string = json_encode($data);
        $ch = curl_init(API_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        $result = curl_exec($ch);
    }

    function _calculateUID($maxid)
    {

        if ($maxid == '') {
            return $new_uid  = 'A00001';
        }
        $numbers = preg_replace('/[^0-9]/', '', $maxid);
        $letters = preg_replace('/[^a-zA-Z]/', '', $maxid);
        if ($numbers < 99999) {
            $nn = $numbers + 1;
            $letter_count = strlen($letters);
            if ($letter_count == 1) {
                $loop = 5;
                $nn = str_pad($nn, $loop, "0", STR_PAD_LEFT);
                $new_uid = $letters . $nn;
            } elseif ($letter_count > 1) {
                $number_count = strlen($nn);
                $loop = 6 - $letter_count;
                $nn = str_pad($nn, $loop, "0", STR_PAD_LEFT);
                $new_uid = $letters . $nn;
            } else {
                $new_uid = '';
            }
        } elseif ($numbers >= 99999) {

            $letters = ++$letters;
            $nn = 1;
            $loop = 6 - $letter_count;
            $nn = str_pad($nn, $loop, "0", STR_PAD_LEFT);
            $new_uid = $letters . $nn;
        } else {
            $new_uid = '';
        }
        if(DEFAULT_COUNTRY==38)
        {
            $new_uid='CA-'.$new_uid;
        }
        else if(DEFAULT_COUNTRY==13)
        {
            $new_uid='AU-'.$new_uid;
        }
        else {
            $new_uid=$new_uid;
        }
        return $new_uid;
    }

    function _GetTP($pack_cb, $test_module_id, $programe_id)
    {
        if($test_module_id == IELTS_ID){

            if ($pack_cb == 'pp' or $pack_cb == 'practice'){

                $tp = '122' . 'IELTS-Practice-Pack';
            } else {

                if ($programe_id == GT_ID) {
                    $tp = '102' . 'IELTS-GT';
                } elseif ($programe_id == ACD_ID) {
                    $tp = '101' . 'IELTS-ACD';
                } else {
                    $tp = '';
                }
            }
        }elseif ($test_module_id == IELTS_CD_ID) {

            if ($pack_cb == 'pp' or $pack_cb == 'practice'){

                $tp = '122' . 'CD-IELTS-Practice-Pack';
            } else {
                if ($programe_id == GT_ID) {
                    $tp = '104' . 'CD-IELTS-GT';
                } elseif ($programe_id == ACD_ID) {
                    $tp = '103' . 'CD-IELTS-ACD';
                } else {
                    $tp = '';
                }
            }
        }elseif ($test_module_id == UKVI_IELTS_ID) {

            if ($pack_cb == 'pp' or $pack_cb == 'practice'){

                $tp = '122' . 'UKVI-IELTS-Practice-Pack';
            } else {
                if ($programe_id == GT_ID) {
                    $tp = '106' . 'UKVI-IELTS-GT';
                } elseif ($programe_id == ACD_ID) {
                    $tp = '105' . 'UKVI-IELTS-ACD';
                } else {
                    $tp = '';
                }
            }
        }elseif ($test_module_id == PTE_ID) {

            if ($pack_cb == 'pp' or $pack_cb == 'practice'){
                $tp = '121' . 'PTE-Practice-Pack';
            } else {
                $tp = '107' . 'PTE';
            }
        }elseif ($test_module_id == SE_ID) {
            $tp = '110' . 'SPOKEN';
        }elseif ($test_module_id == RT_ID) {
            $tp = '';
        }elseif ($test_module_id == CELPIP_ID) {
            $tp = '108' . 'CELPIP';
        }elseif ($test_module_id == OET_ID) {
            $tp = '109' . 'OET';
        }elseif ($test_module_id == TOEFL_ID) {
            $tp = '111' . 'TOEFL';
        }else{
            $tp = '';
        }
        return $tp;

    }

    function _calculateStatus($service_id, $center_id, $test_module_id, $programe_id, $pack_cb){

        $serviceShortCode = $this->Student_service_masters_model->get_serviceShortCode($service_id);
        $service_name = $serviceShortCode['service_name'];
        $centerCode = $this->Center_location_model->get_center_name($center_id);
        $center_name = $centerCode['center_name'];
        $tp = $this->_GetTP($pack_cb, $test_module_id, $programe_id);
        $numbers = preg_replace('/[^0-9]/', '', $tp);
        $letters = preg_replace('/[^a-zA-Z]/', '', $tp);
        $student_identity = $serviceShortCode['short_code'] . '-' . $center_id . '-' . $numbers;
        $details = $service_name . '-' . $center_name . '-' . $letters;
        $studentStatus = array('student_identity' => $student_identity, 'details' => $details);
        return $studentStatus;
    }

    function sendEmailTostd_creds_($subject, $data){

        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from(ADMISSION_EMAIL, FROM_NAME);
        $this->email->to($data['email']);
        $this->email->subject($subject);
        $body = $this->load->view('emails/welcome-reg-email-student.php', $data, TRUE);
        $this->email->message($body);
        $this->email->send();
    }

    function sendEmailToadm_fp_($subject, $data){

        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from(ADMISSION_EMAIL, FROM_NAME);
        $this->email->to($data['email']);
        $this->email->subject($subject);
        $body = $this->load->view('emails/forgot_pwd.php', $data, TRUE);
        $this->email->message($body);
        $this->email->send();
    }

    function sendEmailTostd_credsPack_($subject, $data){

        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from(ADMISSION_EMAIL, FROM_NAME);
        $this->email->to($data['email']);
        $this->email->subject($subject);
        $body = $this->load->view('emails/package-subscribtion-email.php', $data, TRUE);
        $this->email->message($body);
        $this->email->send();
    }    

    function sendEmailTostd_packsubs_($subject, $data){

        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from(ADMISSION_EMAIL, FROM_NAME);
        $this->email->to($data['email']);
        $this->email->subject($subject);
        $body = $this->load->view('emails/package-subscribtion-email.php', $data, TRUE);
        $this->email->message($body);
        $this->email->send();
    }

    function sendEmail_enquiry_($subject, $data){

        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from(ADMISSION_EMAIL, FROM_NAME);
        $this->email->to($data['email']);
        $this->email->subject($subject);
        $body = $this->load->view('emails/sendEmail_enquiry.php', $data, TRUE);
        $this->email->message($body);
        $this->email->send();
    }

    function sendEmail_toAdminCreds_($subject, $data){

        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from(ADMIN_EMAIL, FROM_NAME);
        $this->email->to($data['email']);
        $this->email->subject($subject);
        $body = $this->load->view('emails/welcome-email-admin.php', $data, TRUE);
        $this->email->message($body);
        $this->email->send();
    }

    function sendEmailTostd_enqReply_($subject, $data){

        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from(ADMIN_EMAIL, FROM_NAME);
        $this->email->to($data['email']);
        $this->email->subject($subject);
        $body = $this->load->view('emails/sendEmailTostd_enqReply.php', $data, TRUE);
        $this->email->message($body);
        $this->email->send();
    }


    function sendEmailTostd_walkinOTP_($subject, $data){

        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from(ADMISSION_EMAIL, FROM_NAME);
        $this->email->to($data['email']);
        $this->email->subject($subject);
        $body = $this->load->view('emails/sendEmailTostd_walkinOTP.php', $data, TRUE);
        $this->email->message($body);
        $this->email->send();
    }
    function sendEmailTostd_manage_start_date($subject, $data){

        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from(ADMISSION_EMAIL, FROM_NAME);
        $this->email->to($data['email']);
        $this->email->subject($subject);
        $body = $this->load->view('emails/manage_start_date_email.php', $data, TRUE);
        $this->email->message($body);
        $this->email->send();
    }

    

    public function _curPostData_fourmodules($url, $headers, $params)
    {
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_HTTPHEADER => $headers,
        ));
        $response = curl_exec($curl);
       
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
    
}