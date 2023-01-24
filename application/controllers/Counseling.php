<?php

/**
 * @package         WOSA front
 * @subpackage      ..........
 * @author          Navjeet
 *
 **/
class Counseling extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Counseling_session_model');
        $this->load->model('Enquiry_purpose_model');
        $this->load->model('News_model');
        $current_DateTime = date("d-m-Y G:i:0");
        $current_DateTimeStr = strtotime($current_DateTime);
        //$current_DateTimeStr_after = $current_DateTimeStr + 3600; #1 Hr
        $current_DateTimeStr_after = $current_DateTimeStr;
        $this->Counseling_session_model->deactivate_shedule($current_DateTimeStr_after);
        require_once('application/libraries/stripe-php/init.php');
    }
    function index()
    {
        if (isset($_SESSION['sessionBookingId'])) {
            unset($_SESSION['sessionBookingId']);
        }
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
        );
        $data['title'] = 'Counseling';
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
        $data['generalInfo'] = $this->Counseling_session_model->get_general_info();
        $data['serviceDataAll'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_All_URL), $headers));
        /* $data['GET_SESSION_TYPE_URL'] = json_decode($this->_curlGetData(base_url(GET_SESSION_TYPE_URL), $headers));
        if(empty($data['GET_SESSION_TYPE_URL']->error_message->data)) {
            redirect('/');
            die();
        }  */
        $data['sessionDates'] = json_decode($this->_curlGetData(base_url(GET_SESSION_DATES_URL), $headers));
        //echo "<pre>";
        // print_r($data['session_date']);
        $data['countryCode'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $this->load->view('aa-front-end/includes/header', $data);
        $this->load->view('aa-front-end/counseling_session', $data);
        //$this->load->view('aa-front-end/booking_counselling_html');
        $this->load->view('aa-front-end/includes/footer');
    }
    function old()
    {
        if (isset($_SESSION['sessionBookingId'])) {
            unset($_SESSION['sessionBookingId']);
        }
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
        );
        $data['title'] = 'Counseling';
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
        $data['generalInfo'] = $this->Counseling_session_model->get_general_info();
        $data['serviceDataAll'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_All_URL), $headers));
        $data['GET_SESSION_TYPE_URL'] = json_decode($this->_curlGetData(base_url(GET_SESSION_TYPE_URL), $headers));
        if (empty($data['GET_SESSION_TYPE_URL']->error_message->data)) {
            redirect('/');
            die();
        }
        $data['countryCode'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $current_DateTime = date("d-m-Y G:i:0");
        $current_DateTimeStr = strtotime($current_DateTime);
        //$current_DateTimeStr_after = $current_DateTimeStr + 3600; #1 Hr
        $current_DateTimeStr_after = $current_DateTimeStr;
        $this->Counseling_session_model->deactivate_shedule($current_DateTimeStr_after);
        $this->load->view('aa-front-end/includes/header', $data);
        $this->load->view('aa-front-end/counseling_session_old', $data);
        $this->load->view('aa-front-end/includes/footer');
    }
    /*--get session time slot data via ajax*/
    function getSessionTimeSlot()
    {
        $session_type = $this->input->post('sessionType');
        $sessionDates = $this->input->post('sessionDates');
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'SESSION-TYPE:' . $session_type,
            'DATE-ID:' . $sessionDates,
        );
        $data['SESSION_TIMESLOT_URL'] = json_decode($this->_curlGetData(base_url(GET_SESSION_TIMESLOT_URL), $headers));
        // print_r( $data['SESSION_TIMESLOT_URL']); 
        $this->load->view('aa-front-end/counseling_session_timeslot_ajax', $data);
    }
    /*--ends----*/
    /*--get session date data via ajax*/
    function getSessionDates()
    {
        $session_type = $this->input->post('session_type');
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'SESSION-TYPE:' . $session_type
        );
        $response = json_decode($this->_curlGetData(base_url(GET_SESSION_DATES_URL), $headers));
        //print_r($response);
        //die();
        end($response->error_message->data);
        $lastkey = key($response->error_message->data);
        $session_date_from = $response->error_message->data[0]->session_date;
        $session_date_to = $response->error_message->data[$lastkey]->session_date;
        foreach ($response->error_message->data as $val) {
            $min_date = date_create($val->session_date);
            $datap[] = date_format($min_date, "d-m-Y");
        }
        $session_date_from = date_create($session_date_from);
        $session_date_from = date_format($session_date_from, "d-m-Y");
        $session_date_to = date_create($session_date_to);
        $session_date_to = date_format($session_date_to, "d-m-Y");
        $data['min_date'] = $session_date_from;
        $data['max_date'] = $session_date_to;
        $pp = json_encode($datap);
        $data['dt_range'] = json_decode($pp);
        echo json_encode($data);
    }
    /*--ends----*/
    /*--get start end date ----*/
    function GetStartEndDate($session_type, $arr)
    {
        $this->db->select('session_date_from,session_date_to');
        $this->db->from('counseling_sessions_group');
        $this->db->where(array('session_type' => $session_type, 'active' => 1));
        $this->db->where_in('id', $arr);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }
    /*--ends----*/
    /*--get final session id w.r.t all input selected ----*/
    function getFinalSession()
    {
        $session_type = $this->input->post('sessionType');
        $sessionDates = $this->input->post('sessionDates');
        $sessionTimeSlot = $this->input->post('sessionTimeSlot');
        $sessionDates = date_create($sessionDates);
        $sessionDates = date_format($sessionDates, "Y-m-d");
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'SESSION-TYPE:' . $session_type,
            'DATE-ID:' . $sessionDates,
            'TIME-SLOT:' . $sessionTimeSlot,
        );
        $data['FINAL_SESSION_URL'] = json_decode($this->_curlGetData(base_url(GET_FINAL_SESSION_URL), $headers));
        header('Content-Type: application/json');
        foreach ($data['FINAL_SESSION_URL']->error_message->data as $p) {
            header('Content-Type: application/json');
            $response = ['counseling_sessions_group_id' => $p->id, 'zoom_link' => $p->zoom_link, 'id' => $p->id];
            echo json_encode($response);
        }
    }
    /*--ends----*/
    /*--save data in db and create session ----*/
    function book_session()
    {
        $headers = array('API-KEY:' . WOSA_API_KEY);
        if (isset($_SESSION['checkout_token_no'])) {
            unset($_SESSION['checkout_token_no']);
        }
        $_SESSION['checkout_token_no'] = 'CTCC_' . $this->_getorderTokens('12');
        $stepindexcount = $this->input->post('stepindexcount', true);
        /* ---checkout page tracking ---------- */
        $params_checkout_tracking = array(
            'checkout_token_no' => $_SESSION['checkout_token_no'],
            'page' => "step_" . $stepindexcount,
            'active' => 1,
            'created' => date("d-m-Y h:i:s"),
            'modified' => date("d-m-Y h:i:s"),
        );
        $response = json_decode($this->_curPostData(base_url(CHECKOUT_TRACKING_URL_COUNSELLING), $headers, $params_checkout_tracking));
        /* ----ends---- */
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cs_fname', 'First name', 'required|trim');
        $this->form_validation->set_rules('cs_email', 'Email', 'required|trim');
        $this->form_validation->set_rules('cs_country_code', 'Country Code', 'required|trim');
        $this->form_validation->set_rules('cs_phoneno', 'Mobile Number', 'required|trim');
        $this->form_validation->set_rules('cs_session_type', 'Session Type', 'required|trim');
        $this->form_validation->set_rules('cs_bookingdate', 'Booking Date', 'required|trim');
        $this->form_validation->set_rules('cs_timeslot', 'Timeslot', 'required|trim');
        $this->form_validation->set_rules('service_id', 'Service', 'required|trim');
        $this->form_validation->set_rules('message', 'Message', 'required|trim');
        if ($this->form_validation->run()) {
            $bookid = $this->input->post('bookid', true);
            $bData = $this->Counseling_session_model->Get_session_detail($bookid);
            $bookingdatestring = strtotime($this->input->post('cs_bookingdate', true));
            $params = array(
                'fname' => $this->input->post('cs_fname', true),
                'email'    => $this->input->post('cs_email', true),
                'country_code' => $this->input->post('cs_country_code', true),
                'mobile' => $this->input->post('cs_phoneno', true),
                'session_id' => $this->input->post('sessiongroupid', true),
                'session_type' => $this->input->post('cs_session_type', true),
                'booking_date' => $this->input->post('cs_bookingdate', true),
                'booking_date_str' => $bookingdatestring,
                'booking_time_slot' => $this->input->post('cs_timeslot', true),
                'bookid' => $this->input->post('bookid', true),
                'service_id' => $this->input->post('service_id', true),
                'message' => $this->input->post('message', true),
                'amount' => $bData['amount'],
                'checkout_token_no' => $_SESSION['checkout_token_no'],
                'active' => 0,
                'payment_status' =>'failed',
            );
            $response = json_decode($this->_curPostData(base_url(CREATE_SESSION), $headers, $params));
            if ($response->error_message->success == 1) {
                //unset($_SESSION['sessionBookingId']);
                $_SESSION['sessionBookingId'] = $response->error_message->id;
                // gateway api call
                ini_set('display_errors', 1);
                // create a new stripe payment instance object
                $stripe = new \Stripe\StripeClient($this->config->item('stripe_secret_cc'));
                //payment method create object:Instead of creating a PaymentMethod directly, we recommend using the PaymentIntents API to accept a payment immediately or the SetupIntent API to collect payment method details ahead of a future payment
                try {
                    $paymentMethods_create = $stripe->paymentMethods->create([
                        'type' => 'card',
                        'card' => [
                            'number' => $this->input->post('number', TRUE),
                            'exp_month' => $this->input->post('exp_month', TRUE),
                            'exp_year' => $this->input->post('exp_year', TRUE),
                            'cvc' => $this->input->post('card_cvc', TRUE),
                        ],
                    ]);
                } catch (Exception $e) {
                    // Fail due tp exception error occur, update the pack status and other necessary fields , active=>2---handle for fail order pack status                   
                    $params = array(
                        "active" => 2,
                        "payment_status" => 'failed',
                        "response" => json_encode($e->getMessage()),
                        "email_send_flag" => 1,
                    );
                    $update_pack = $this->update_pack($params);
                    if ($update_pack) {
                        $this->session->set_flashdata('exception_msg', $e->getMessage());
                        redirect('counseling/pp_fail');
                    }
                } // Exception ends:$stripe->paymentMethods->create();
                try {
                    // create payment:After the PaymentIntent is created, attach a payment method and confirm to continue the payment.            
                    //.Metadata is useful for storing additional, structured information on an object.International payments for services:Every international //payment for services is required to have the buyer’s name, billing address and a description of the service being exported.
                    $res_create = $stripe->paymentIntents->create(
                        ['amount' => $this->input->post('payable_amount') * 100, 'currency' => $this->input->post('currency_code'), 'payment_method_types' => ['card'], 'return_url' => site_url(PAYMENT_STATUS_URL_CC), 'confirm' => true, 'payment_method' => $paymentMethods_create, 'description' => 'Counselling Session', 'receipt_email' => $this->input->post('cs_email', true), 'metadata' => [
                            'sess_id' => $response->error_message->sessid,
                            'sess_phone' => $this->input->post('cs_country_code', true) . ' ' . $this->input->post('cs_phoneno', true), 'sess_email' => $this->input->post('cs_email', true),
                            'sess_order_id' => $_SESSION['sessionBookingId'],
                            'sess_type' => $this->input->post('cs_session_type', true),
                            'sess_booking_date' => $this->input->post('cs_bookingdate', true),
                            'sess_booking_timeslot' => $this->input->post('booking_time_slot', true),
                        ]]
                    );
                } catch (Exception $e) {
                    //Fail due tp exception error occur, update the pack status and other necessary fields active=>2---handle for fail order pack status           
                    if (isset($res_create->last_payment_error)) {
                        $this->session->set_flashdata('exception_msg', $res_create->last_payment_error['message']);
                    }
                    $params = array(
                        "active" => 2,
                        "payment_id" => $res_create->id,
                        "payment_status" => $res_create->status,
                        "response" => json_encode($e->getMessage()),
                        "email_send_flag" => 1,
                    );
                    $update_pack = $this->update_pack($params);
                    if ($update_pack) {
                        redirect('counseling/pp_fail');
                    }
                } // Exception ends:$stripe->paymentIntents->create()
                if ($res_create->status == "succeeded") {
                    // ---update the pack status and other necessary fields    
                    $params = array(
                        "active" => 1,
                        "payment_status" => $res_create['status'],
                        "captured" => $res_create['captured'],
                        "method" => $res_create->payment_method_types[0],
                        "payment_id" => $res_create->id,
                        "response" => json_encode($res_create),
                        "email_send_flag" => 1
                    );
                    $update_pack = $this->update_pack($params);
                    if ($update_pack) {
                        redirect('counseling/pp_success');
                    }
                }
                // payment is created but status is pendind and need next action ex:opt enter form
                else if ($res_create->status == "requires_action") {
                    //Next action required, STATUS:requires_action=Customer did not complete the checkout                       
                    $params = array(
                        "payment_id" => $res_create->id,
                        "payment_status" => $res_create->status,
                        "active" => 2,
                        "email_send_flag" => 0,
                    );
                    $this->update_pack($params);
                    // check if next action key is set then open next action url 
                    if (isset($res_create->next_action)) {
                        // ---checkout page tracking ---------- 
                        $params_checkout_tracking = array(
                            'checkout_token_no' => $_SESSION['checkout_token_no'],
                            'page' => "stripe_opt_form",
                            'modified' => date("d-m-Y h:i:s"),
                            'session_id' => $_SESSION['sessionBookingId'],
                        );
                        $response = json_decode($this->_curPostData(base_url(CHECKOUT_TRACKING_URL_COUNSELLING), $headers, $params_checkout_tracking));
                        // ----ends----      
                        //redirect to stripe action page i.e opt popup page
                        redirect($res_create->next_action->redirect_to_url->url);
                    } else {
                        //do some thing here: next action is not set
                        if (isset($res_create->last_payment_error)) {
                            $this->session->set_flashdata('exception_msg', $res_create->last_payment_error['message']);
                        }
                        $custom_fail_status = $res_create->status;
                        if ($custom_fail_status == "") {
                            $custom_fail_status = "fail"; //custom fail status added
                        }
                        //update the pack status and other necessary fields active=>2---handle for fail order pack status
                        $params = array(
                            "active" => 2,
                            "payment_id" => $res_create->id,
                            "payment_status" => $custom_fail_status,
                            "response" => json_encode($res_create),
                            "email_send_flag" => 1,
                        );
                        $update_pack = $this->update_pack($params);
                        if ($update_pack) {
                            redirect('counseling/pp_fail');
                        }
                    }
                } else if ($res_create->status == "requires_payment_method") {
                    //fail payment STATUS:requires_payment_method=Customer’s payment failed on your checkout page
                    //update the pack status and other necessary fields active=>2---handle for fail order pack status
                    if (isset($res_create->last_payment_error)) {
                        $this->session->set_flashdata('exception_msg', $res_create->last_payment_error['message']);
                    }
                    $params = array(
                        "active" => 2,
                        "payment_id" => $res_create->id,
                        "payment_status" => $res_create->status,
                        "response" => json_encode($res_create),
                        "email_send_flag" => 1,
                    );
                    $update_pack = $this->update_pack($params);
                    if ($update_pack) {
                        redirect('counseling/pp_fail');
                    }
                } else {
                    // Handle unsuccessful, processing, or canceled payments and API errors here
                    if (isset($res_create->last_payment_error)) {
                        $this->session->set_flashdata('exception_msg', $res_create->last_payment_error['message']);
                    }
                    $params = array(
                        "active" => 2,
                        "payment_id" => $res_create->id,
                        "payment_status" => $res_create->status,
                        "response" => json_encode($res_create),
                        "email_send_flag" => 1,
                    );
                    $update_pack = $this->update_pack($params);
                    if ($update_pack) {
                        redirect('counseling/pp_fail');
                    }
                }
            } else {
                header('Content-Type: application/json');
                $this->session->set_flashdata('flsh_msg',  $msg);
                redirect('counseling');
            }
        }
    }
    /*--ends----*/
    /*--------update pack status as per paramater passed------- */
    function update_pack($params)
    {
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-SESSION-ID:' . $_SESSION['sessionBookingId'],
        );
        //return $this->_curPostData(base_url(UPDATE_SESSION_URL), $headers, $params);           
        $response = json_decode($this->_curPostData(base_url(UPDATE_SESSION_URL), $headers, $params));
        return $response->error_message->success;
    }
    function payment_status()
    {
        //When completing a payment on the client now inspect the returned PaymentIntent to determine its current status
        $stripe = new \Stripe\StripeClient($this->config->item('stripe_secret_cc'));
        try {
            //Check PaymentIntent status on the client
            $res_retrieve = $stripe->paymentIntents->retrieve(
                $_GET['payment_intent']
            );
        } catch (Exception $e) {
            // Handle unsuccessful, processing, or canceled payments and API errors here
            if (isset($res_create->last_payment_error)) {
                $this->session->set_flashdata('exception_msg', $res_create->last_payment_error['message']);
            }
            $params = array(
                "active" => 2,
                "payment_id" => $res_create->id,
                "payment_status" => "failed",
                "response" => json_encode($e->getMessage()),
                "email_send_flag" => 1,
            );
            $update_pack = $this->update_pack($params);
            if ($update_pack) {
                redirect('counseling/pp_fail');
            }
        }
        if ($res_retrieve->status == 'succeeded') {
            //success payment STATUS:succeeded=Customer completed payment on your checkout page
            //call api to get student pack start end date    
            // ---update the pack status and other necessary fields    
            $params = array(
                "active" => 1,
                "payment_status" => $res_retrieve->status,
                "captured" => $res_retrieve->captured,
                "method" => $res_retrieve->payment_method_types[0],
                "payment_id" => $res_retrieve->id,
                "response" => json_encode($res_retrieve),
                "email_send_flag" => 1
            );
            $update_pack = $this->update_pack($params);
            if ($update_pack) {
                redirect('counseling/pp_success');
            }
        } else {
            $res_retrieve->last_payment_error['message'];
            $e = $res_retrieve->last_payment_error;
            // Handle unsuccessful, processing, or canceled payments and API errors here  
            switch ($e->code) {
                case "payment_intent_authentication_failure":
                    $this->session->set_flashdata('exception_msg', "A payment error occurred: Your order has been cancelled");
                    break;
                case "card_declined":
                    $this->session->set_flashdata('exception_msg', "The card has been declined.");
                    break;
                case "expired_card":
                    $this->session->set_flashdata('exception_msg', "The card has expired. Check the expiration date or use a different card.");
                    break;
                case "incorrect_cvc":
                    $this->session->set_flashdata('exception_msg', "The card’s security code is incorrect. Check the card’s security code or use a different card.");
                    break;
                case "invalid_expiry_month":
                    $this->session->set_flashdata('exception_msg', "The card’s expiration month is incorrect. Check the expiration date or use a different card.");
                    break;
                    break;
                case "invalid_expiry_year":
                    $this->session->set_flashdata('exception_msg', "The card’s expiration year is incorrect. Check the expiration date or use a different card.");
                    break;
                case "incorrect_number":
                    $this->session->set_flashdata('exception_msg', "The card number is incorrect. Check the card’s number or use a different card.");
                    break;
                default:
                    $this->session->set_flashdata('exception_msg', "Booking failed due to some Error. Please Try again.");
            }
            /* ---update the pack status and other necessary fields 
             active=>2---handle for fail order pack status
            */
            $params = array(
                "active" => 2,
                "payment_status" => "failed",
                "payment_id" => $res_retrieve->id,
                "response" => json_encode($res_retrieve),
                "email_send_flag" => 1,
            );
            $update_pack = $this->update_pack($params);
            if ($update_pack) {
                redirect('counseling/pp_fail');
            }
        }
    }
    /*---payement success page----*/
    function pp_success()
    {
        if (!isset($_SESSION['sessionBookingId'])) {
            redirect('/');
            die();
        }
        // ---checkout page tracking ----------
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
        );
        $params_checkout_tracking = array(
            'session_id' => $_SESSION['sessionBookingId'],
            'checkout_token_no' => $_SESSION['checkout_token_no'],
            'page' => "success",
            'modified' => date("d-m-Y h:i:s"),
        );
        $response = json_decode($this->_curPostData(base_url(CHECKOUT_TRACKING_URL_COUNSELLING), $headers, $params_checkout_tracking));
        // ----ends---- */ 
        $data['title'] = 'Booking Success';
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));;
        $data['serviceDataAll'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_All_URL), $headers));
        $data['countryCode'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $this->load->view('aa-front-end/includes/header', $data);
        $this->load->view('aa-front-end/counseling_session_success');
        $this->load->view('aa-front-end/includes/footer', $data);
        unset($_SESSION['sessionBookingId']);
        unset($_SESSION['checkout_token_no']);
    }
    /*--ends----*/
    /*---payment fail page----*/
    function pp_fail()
    {
        if (!isset($_SESSION['sessionBookingId'])) {
            redirect('/');
            die();
        }
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
        );
        //---checkout page tracking ----------
        $params_checkout_tracking = array(
            'session_id' => $_SESSION['sessionBookingId'],
            'checkout_token_no' => $_SESSION['checkout_token_no'],
            'page' => "fail",
            'modified' => date("d-m-Y h:i:s"),
        );
        $response = json_decode($this->_curPostData(base_url(CHECKOUT_TRACKING_URL_COUNSELLING), $headers, $params_checkout_tracking));
        // ----ends----        
        $data['title'] = 'Booking Fail';
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));;
        $data['serviceDataAll'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_All_URL), $headers));
        $data['countryCode'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $data['exception_msg'] = $this->session->flashdata('exception_msg');
        $this->load->view('aa-front-end/includes/header', $data);
        $this->load->view('aa-front-end/counseling_session_fail');
        $this->load->view('aa-front-end/includes/footer', $data);
        unset($_SESSION['sessionBookingId']);
        unset($_SESSION['checkout_token_no']);
    }
    /*----ends----*/
    /*--verify otp*/
    function verify_sessotp()
    {
        if (!isset($_SESSION['sessionBookingId'])) {
            redirect('/');
            die();
        }
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
        );
        $params = array(
            'otp' => $this->input->post('session_otp', true),
            'id' =>  $_SESSION['sessionBookingId'],
        );
        $response = json_decode($this->_curPostData(base_url(VERIFY_SESSION_URL), $headers, $params));
        if ($response->error_message->success == 1) {
            header('Content-Type: application/json');
            $response = ['msg' => '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' . $response->error_message->message . '<a href="#" class="alert-link"></a>.</div>', 'status' => 1, 'payamount' => $response->error_message->payamount];
            echo json_encode($response);
        } else {
            header('Content-Type: application/json');
            $response = ['msg' => $response->error_message->message, 'status' => 0];
            echo json_encode($response);
        }
    }
    /*---ends----*/
    /*----contine page before goto gateway----*/
    function continue_pay()
    {
        if (!isset($_SESSION['sessionBookingId'])) {
            redirect('/');
            die();
        }
        $session_data = $this->Counseling_session_model->get_student_session($_SESSION['sessionBookingId']);
        $params['params'] = array(
            'business' => PP_BUSINESS,
            'item_name' => $session_data['session_type'],
            'item_number' => 1,
            'amount' => $session_data['amount'],
            'cmd' => PP_CMD,
            'currency_code' => PP_CURRENCY_CODE,
            'rm' => PP_RM,
            'sessBookingNo' => $session_data['sessBookingNo'],
            'return' => site_url('counseling/pp_success'),
            'cancel_return' => site_url('counseling/pp_fail'),
        );
        $this->load->view('aa-front-end/counseling_session_gateway', $params);
    }
    /*---ends----*/
    /*--otp entered page view----*/
    function session_otp()
    {
        if (!isset($_SESSION['sessionBookingId'])) {
            redirect('/');
            die();
        }
        $data['title'] = 'Booking';
        $data['generalInfo'] = $this->Counseling_session_model->get_general_info();
        $data['sessionInfo'] = $this->Counseling_session_model->get_student_session($_SESSION['sessionBookingId']);
        $data['serviceData'] = $this->Enquiry_purpose_model->get_all_enquiry_purpose_active();
        $this->load->view('aa-front-end/includes/header', $data);
        $this->load->view('aa-front-end/counseling_session_otp');
        $this->load->view('aa-front-end/includes/footer', $data);
    }
    /*--ends---*/
    function booking_design()
    {
        $this->load->view('aa-front-end/includes/header', $data);
        $this->load->view('aa-front-end/booking_counselling_html');
        $this->load->view('aa-front-end/includes/footer', $data);
    }
}
