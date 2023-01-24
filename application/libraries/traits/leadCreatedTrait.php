<?php

/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Ashok Kumar
 *
 * */
trait leadCreatedTrait
{

    public function auto_add_lead($params = array())
    {

        $this->load->model(['Leads_model', 'Student_model', 'Country_model', 'Purposes_master_model']);
        //pr($params,1);
        if (empty($params)) {
            $params = $this->input->post();
        }
        $by_user = 0;
        $by_user= $_SESSION['UserId'];

        if (is_object($params)) {
            $params = (array) $params;
        }
        $parameters = $this->auto_filter_parametersNew($params);
        #pr($parameters,1);
        $parameters['by_user'] = $by_user;
        $student_info = array();
        $student_info['status'] = 'error';
        $this->db->trans_start();
        if (!empty($parameters) && !empty($parameters['lead_origin_type']) && !empty($parameters['origin']) && !empty($parameters['medium']) && !empty($parameters['purpose_level_one'])) {

            if(empty($parameters['source_id'])){

                $sourceData=$this->Purposes_master_model->getSourceActive($parameters['lead_origin_type'],$parameters['origin'],$parameters['medium']);
                $parameters['source_id']=$sourceData['0']['id'];
            }
            if ($parameters['student_id'] == 0 || empty($parameters['student_id'])) {

                $student_pack = $this->auto_filter_student_parametersNew($params);
                $data['ContData'] = $this->Country_model->get_country_id($params['country_code']);
                $country_id = $data['ContData']['country_id'];
                $maxid = $this->Student_model->getMax_UID();
                $UID = $this->_calculateUID($maxid);
                $student_pack['country_id'] = $country_id;
                $student_pack['UID'] = $UID;
                $student_pack['fresh'] = 1;
                $student_pack['today'] = strtotime(date('d-m-Y'));
                $student_pack['password'] = md5(PLAIN_PWD);
                $student_pack['username'] = $student_pack['mobile'];
                $student_pack['active'] = 1;
                $student_pack['by_user'] = $by_user;
                $student_id = $this->Student_model->storeStudent($this->security->xss_clean($student_pack));
                if ($student_id) {
                    $parameters['student_id'] = $student_id;
                }
            }
            $parameters['by_user'] = $by_user;
            $purpose_level_one = $parameters['purpose_level_one'];
            if (!empty($parameters['student_id'])) {

                $common_columns = $this->auto_setPrimaryColumns($parameters);
                if (!empty($common_columns)) {

                    $is_exists = $this->auto_check_lead_duplicacyNew($common_columns);
                    $leadParameters = $this->auto_filter_lead_parameters($parameters, $common_columns);
                    //pr($leadParameters,1);
                    if (empty($is_exists)) {
                        $id = $this->Leads_model->storeLead($this->security->xss_clean($leadParameters));
                    } else {
                        $id = $is_exists->id;
                    }
                    $parameters['lead_id'] = $leadParameters['lms_lead_id'] = $id;
                    if ($id) {

                        $history_id = $this->Leads_model->storeLeadHistory($this->security->xss_clean($leadParameters));
                        $this->auto_lead_assignments($parameters);

                        if (!empty($history_id)) {
                            $student_info = $this->Student_model->getStudentFullInfoById($parameters['student_id']);
                            $parameters['division_id'] = $common_columns['division_id'];
                            if ($parameters['lead_origin_type'] == 'rap' && $parameters['origin'] == 'campaign') {  #Store Booking Campaign
                                $campaign_booking_id = $this->auto_store_campaign_booking($parameters);
                                $student_info['campaign_booking_id'] = $campaign_booking_id;
                            } else {
                                $this->auto_store_walkinsNew($parameters);
                            }
                            $student_info['status'] = 'success';
                            $student_info['msg'] = 'Add lead successfully';
                        } else {

                            $student_info['msg'] = 'Lead History Added failed';
                        }
                    } else {
                        $student_info['msg'] = 'Lead Added failed';
                    }
                } else {
                    #nql lead

                }
            } else {
                $student_info['msg'] = 'Student Added failed';
            }
        } else {

            $student_info['msg'] = 'Required Parameter Missing';
        }
        $this->db->trans_complete();
        return $student_info;
    }
    public function auto_filter_student_parametersNew(array $params)
    {
        $row = [];
        if (isset($params['country_code']) && $params['country_code'] != '') {
            $row['country_code'] = $params['country_code'];
        }
        if (isset($params['first_name']) && $params['first_name'] != '') {
            $row['fname'] = $params['first_name'];
        }
        if (isset($params['last_name']) && $params['last_name'] != '') {
            $row['lname'] = $params['last_name'];
        }
        if (isset($params['mobile']) && $params['mobile'] != '') {
            $row['mobile'] = $params['mobile'];
        }
        if (isset($params['email']) && !empty($params['email'])) {
			
		    $row['email'] = $params['email'];
        }
        if (isset($params['dob'])) {

            $row['dob'] = $params['dob'];
        }
        if (isset($params['source_id'])) {

            $row['source_id'] = $params['source_id'];
        }
        return $row;
    }

    public function auto_filter_lead_parameters(array $parameters, array $common_columns)
    {
        
        $leadParametersNew = $parameters;
        $leadParametersNew['purpose_level_one'] = $common_columns['purpose_level_one'];
        $leadParametersNew['purpose_level_two'] = $common_columns['purpose_level_two'];
        $leadParametersNew['purpose_level_three'] = $common_columns['purpose_level_three'];
        $leadParametersNew['division_id'] = $common_columns['division_id'];

        $leadkeys = ['student_id', 'lead_origin_type', 'origin', 'medium', 'purpose_level_one', 'purpose_level_two', 'purpose_level_three', 'center_id', 'test_module_id', 'programe_id', 'int_country_id', 'event_type', 'qualification_id', 'work_experience_years', 'exam_location_id', 'booking_month', 'complain_subject', 'feedback_subject', 'ga_subject', 'session_type', 'industry', 'reality_test_id', 'event_id', 'package_id', 'practice_package_id', 'exam_id', 'demo_counseling_id', 'division_id', 'product_id', 'source_id', 'note'];
        $data_pack = array();
        foreach ($leadkeys as $key) {

            if (isset($leadParametersNew[$key])) {
                $data_pack[$key] = $leadParametersNew[$key];
            }
        }
        return $data_pack;
    }
    public function auto_check_lead_duplicacyNew(array $params)
    {

        return $this->Leads_model->checkLeadExistance($params);
    }
    public function auto_setPrimaryColumns($params = array())
    {

        $this->load->model(['Leads_model', 'Student_model', 'Country_model', 'Purposes_master_model']);
        $common_columns = ['student_id' => $params['student_id'], 'purpose_level_one' => $params['purpose_level_one']];
        $common_columnsNew = array();
        $purpose_level_one = $params['purpose_level_one'];
        $purpose_level_two = isset($params['purpose_level_two']) ? $params['purpose_level_two'] : '';
        $student_id = $params['student_id'];
        $division_id = isset($params['division_id']) ? $params['division_id'] : '';
        $purpose_level_one_data = $this->Purposes_master_model->getPrimaryPurpose($purpose_level_one);
        $isPrimary = FALSE;
        if (!empty($purpose_level_one_data)) {

            $common_columns['purpose_level_one'] = $purpose_level_one_data['id'];
            if ($purpose_level_one_data['is_primary'] == 0) {

                if (!empty($purpose_level_two)) {

                    $purpose_level_two_data = $this->Purposes_master_model->getPrimaryPurpose($purpose_level_two);
                } else {

                    if (!empty($division_id) && in_array($purpose_level_one, array(32, 39, 42, 47, 52, 59))) {  #Events,#Undecided,#Complaints,#Feedback,Demo Counseling,General Assistance

                        $purpose_level_two_data = $this->Purposes_master_model->getPurposeChildrenByDivisionId($purpose_level_one, $division_id);
                    }
                }
                if (!empty($purpose_level_two_data)) {

                    $purpose_level_two = $common_columns['purpose_level_two'] = $purpose_level_two_data['id'];
                    if ($purpose_level_two_data['is_primary'] == 0) {

                        $purpose_level_three_data = $this->Purposes_master_model->getPurposeChildrenIsPrimary($purpose_level_two);
                        if (!empty($purpose_level_three_data)) {

                            if ($purpose_level_three_data['is_primary'] == 1) {

                                $purpose_level_three = $common_columns['purpose_level_three'] = $purpose_level_three_data['id'];
                                $field_name = $purpose_level_three_data['field_name'];
                                $field_value = isset($params[$field_name]) ? $params[$field_name] : '';
                                if (!empty($field_value)) {

                                    $common_columns[$field_name] = $field_value;
                                    $isPrimary = TRUE;
                                    $common_columns['division_id'] = $purpose_level_three_data['division_id'];
                                }
                            }
                        }
                    } else {
                        $isPrimary = TRUE;
                        $common_columns['division_id'] = $purpose_level_two_data['division_id'];
                    }
                }
            } else {
                $isPrimary = TRUE;
                $common_columns['division_id'] = $purpose_level_one_data['division_id'];
            }
        }
        if ($isPrimary) {
            $common_columnsNew = $common_columns;
        }
        return $common_columnsNew;
    }
    #Lead assignments
    function auto_lead_assignments(array $params){

        $lead_id=$params['lead_id'];
    }
    public function auto_store_walkinsNew(array $params)
    {


        if (isset($params['purpose_level_one']) && $params['purpose_level_one'] != '') {

            $row = [
                'lead_origin_type' => $params['lead_origin_type'],
                'origin' => $params['origin'],
                'medium' => $params['medium'],
                'product_id' => $params['product_id'],
                'by_user' => $params['by_user'],
                'student_id' => $params['student_id'],
                'lead_id' => ($params['lead_id']) ? $params['lead_id'] : '',
                'division_id' => $params['division_id'],
                'purpose_level_one' => $params['purpose_level_one']
            ];
            $data = array();
            switch ($params['purpose_level_one']) {

                case "42":  #Complaints
                    $row['subject_id'] = ($params['complain_subject']) ? $params['complain_subject'] : '';
                    $row['complaint_for'] = ($params['complaint_for']) ? $params['complaint_for'] : '';
                    $row['department_id'] = ($params['department_id']) ? $params['department_id'] : '';
                    $row['center_id'] = ($params['complaint_for_center_id']) ? $params['complaint_for_center_id'] : '';
                    $row['employee_id'] = ($params['employee_id']) ? $params['employee_id'] : '';
                    $row['complaint_text'] = $params['note'];
                    $row['today'] = strtotime(date('d-m-Y'));
                    $row['complain_id'] = $this->_getorderTokens(8);
                    $row['attachment_file'] = ($params['attachment_file']) ? $params['attachment_file'] : '';
                    $data = $this->auto_store_complaintNew($row);
                    break;
                case "47": #Feedback
                    $row['subject_id'] = ($params['feedback_subject']) ? $params['feedback_subject'] : '';
                    $row['feedback_for'] = ($params['feedback_for']) ? $params['feedback_for'] : '';
                    $row['department_id'] = ($params['department_id']) ? $params['department_id'] : '';
                    $row['center_id'] = ($params['feedback_for_center_id']) ? $params['feedback_for_center_id'] : '';
                    $row['employee_id'] = ($params['employee_id']) ? $params['employee_id'] : '';
                    $row['feedback_text'] = $params['note'];
                    $row['today'] = strtotime(date('d-m-Y'));
                    $row['feedback_id'] = $this->_getorderTokens(8);
                    $row['attachment_file'] = ($params['attachment_file']) ? $params['attachment_file'] : '';
                    $data = $this->auto_store_feedbackNew($row);
                    break;
                case "59":  #General Assistance
                    $row['subject_id'] = ($params['ga_subject']) ? $params['ga_subject'] : '';
                    $row['description'] = $params['note'];
                    $row['today'] = strtotime(date('d-m-Y'));
                    $row['attachment_file'] = ($params['attachment_file']) ? $params['attachment_file'] : '';
                    $data = $this->auto_store_gaNew($row);
                    break;
            }
            return $data;
        }
    }
    public function auto_filter_parametersNew(array $params = [])
    {
        $data_pack = [];
        #Coman Filed 
        $keys = ['student_id', 'lead_origin_type', 'origin', 'medium', 'purpose_level_one', 'purpose_level_two', 'purpose_level_three', 'center_id', 'test_module_id', 'programe_id', 'int_country_id', 'event_type', 'qualification_id', 'work_experience_years', 'exam_location_id', 'booking_month', 'complain_subject', 'feedback_subject', 'ga_subject', 'session_type', 'industry', 'reality_test_id', 'event_id', 'package_id', 'practice_package_id', 'exam_id', 'demo_counseling_id', 'division_id', 'product_id', 'source_id', 'note', 'complaint_for','complaint_for_center_id','feedback_for','feedback_for_center_id','department_id', 'employee_id', 'campaign_id', 'campaign_type_id', 'campaign_category_id', 'campaign_title', 'social_media_campaign_id'];
		
        foreach ($keys as $key) {
            if (isset($params[$key])) {
                $data_pack[$key] = $params[$key];
            }
        }
        return $data_pack;
    }
    public function auto_get_purpose_levelsNew(array $params)
    {
        $this->load->model(['Purposes_master_model']);
        $purposes1 = $this->Purposes_master_model->getMediumPurpose($params['lead_origin_type'], $params['origin'], $params['medium']);
        $parameters = [];
        if ($purposes1) {
            $parameters['purpose_level_one'] = $purposes1[0]['id'];
            $purposes2 = $this->Purposes_master_model->getMediumPurposeById($purposes1[0]['id'], $params['division_id']);
            if ($purposes2) {
                $parameters['purpose_level_two'] = $purposes2->id;
                $purposes3 = $this->Purposes_master_model->getMediumPurposeById($purposes2->id, $params['division_id']);
                if ($purposes3) {
                    $parameters['purpose_level_three'] = $purposes3->id;
                }
            }
        }
        return $parameters;
    }

    public function auto_store_complaintNew(array $params)
    {
        $this->load->model('Lead_complaints_model');
        $is_exists = $this->auto_check_walkin_duplicacyNew($params, $params['purpose_level_one']);
        $complaint_id = '';
        $data = array();
        if (isset($params['purpose_level_one'])) {
            unset($params['purpose_level_one']);
        }
        if (!$is_exists) {
            $complaint_id = $this->Lead_complaints_model->storeComplaint($params);
        } else {
            $complaint_id = $is_exists->id;
        }
        if ($complaint_id) {

            $params['lms_complaint_id'] = $complaint_id;
            $this->Lead_complaints_model->storeComplaintHistory($params);
            $complaint_data = $this->Lead_complaints_model->getComplaintDetails($complaint_id);
            $description = 'New comlaint with comlaint ID ' . $complaint_id . ' added';
            if($params['by_user']) {
                $this->addUserActivity(COMPLAINT_ADD, $description, 0, $params['by_user']);
            }
            if (base_url() != BASEURL && $params['email']) {
                $mail_pack = [
                    'fname' => $complaint_data['fname'],
                    'email' => $complaint_data['email'],
                    'email_message' => leadComplaintEmailMessage($complaint_data['complain_id']),
                    'thanks' => THANKS,
                    'team' => WOSA,
                ];
                //$this->sendEmailTostd_complaints_(LEAD_COMPLAINT_EMAIL_SUBJECT, $mail_pack);


            }
        }
        $data['complaint_id'] = $complaint_id;
        return $data;
    }

    /**
     * auto_store_feedback will be used to create a new complaint in database and send email to user.
     * 
     * @param array $params
     */
    public function auto_store_feedbackNew(array $params)
    {
        $this->load->model('Lead_feedback_model');
        $feedback_id = '';
        $data = array();
        $is_exists = $this->auto_check_walkin_duplicacyNew($params, $params['purpose_level_one']);
        if (isset($params['purpose_level_one'])) {
            unset($params['purpose_level_one']);
        }
        if (!$is_exists) {
            $feedback_id = $this->Lead_feedback_model->storeFeedback($params);
        } else {
            $feedback_id = $is_exists->id;
        }
        if ($feedback_id) {
            $params['lms_feedback_id'] = $feedback_id;
            $this->Lead_feedback_model->storeFeedbackHistory($params);
            $feedback_data = $this->Lead_feedback_model->getFeedbackDetails($feedback_id);
            $description = 'New feedback with feedback ID ' . $feedback_id . ' added';
            if($params['by_user']) {
                $this->addUserActivity(FEEDBACK_ADD, $description, 0, $params['by_user']);
            }
            if (base_url() != BASEURL && $params['email']) {
                $mail_pack = [
                    'fname' => $feedback_data['fname'],
                    'email' => $feedback_data['email'],
                    'email_message' => '', //leadComplaintEmailMessage($complaint_data['complain_id']),
                    'thanks' => THANKS,
                    'team' => WOSA,
                ];
                //pr($mail_pack);
                #$this->sendEmailTostd_complaints_(LEAD_COMPLAINT_EMAIL_SUBJECT, $mail_pack);
            }
        }
        $data['feedback_id'] = $feedback_id;
        return $data;
    }

    /**
     * auto_store_ga will be used to create a new complaint in database and send email to user.
     * 
     * @param array $params
     */
    public function auto_store_gaNew(array $params)
    {
        $ga_id = '';
        $data = array();
        $this->load->model('Lead_ga_model');
        $is_exists = $this->auto_check_walkin_duplicacyNew($params, $params['purpose_level_one']);
        if (isset($params['purpose_level_one'])) {
            unset($params['purpose_level_one']);
        }
        if (!$is_exists) {
            $ga_id = $this->Lead_ga_model->storeGA($params);
        } else {
            $ga_id = $is_exists->id;
        }
        if ($ga_id) {
            $params['lms_ga_id'] = $ga_id;
            $this->Lead_ga_model->storeGAHistory($params);
            $ga_data = $this->Lead_ga_model->getGADetails($ga_id);
            $description = 'New General Assistance with GA ID ' . $ga_id . ' added';
            $this->addUserActivity(FEEDBACK_ADD, $description, 0, $params['by_user']);
            if (base_url() != BASEURL && $params['email']) {
                $mail_pack = [
                    'fname' => $ga_data['fname'],
                    'email' => $ga_data['email'],
                    'email_message' => '', //leadComplaintEmailMessage($complaint_data['complain_id']),
                    'thanks' => THANKS,
                    'team' => WOSA,
                ];
                //pr($mail_pack);
                #$this->sendEmailTostd_complaints_(LEAD_COMPLAINT_EMAIL_SUBJECT, $mail_pack);
            }
        }
        $data['ga_id'] = $ga_id;
        return $data;
    }
    public function auto_check_walkin_duplicacyNew(array $params, string $purpose_level_one)
    {

        $this->load->model(['Lead_complaints_model', 'Lead_feedback_model', 'Lead_ga_model']);
        $common_columns = ['student_id' => $params['student_id'], 'division_id' => $params['division_id']];
        switch ($purpose_level_one) {

            case "42":  #Complaints
                $complaint_columns = ['product_id' => $params['product_id'], 'subject_id' => $params['subject_id']];
                $all_columns = array_merge($common_columns, $complaint_columns);
                return $this->Lead_complaints_model->checkComplaintExistance($all_columns);
            case "47": #Feedback
                $feedback_columns = ['product_id' => $params['product_id'], 'subject_id' => $params['subject_id']];
                $all_columns = array_merge($common_columns, $feedback_columns);
                return $this->Lead_feedback_model->checkFeedbackExistance($all_columns);
            case "59":  #General Assistance
                $ga_columns = ['product_id' => $params['product_id'], 'subject_id' => $params['subject_id']];
                $all_columns = array_merge($common_columns, $ga_columns);
                return $this->Lead_ga_model->checkGAExistance($all_columns);
            case "product-enquiry-self":
                return [];
            case "product-enquiry-other":
                return [];
        }
    }

    function auto_store_campaign_booking($params = array())
    {

        $this->load->model('Leads_model');
        //$is_exists = $this->auto_check_walkin_duplicacyNew($params, $params['purpose_level_one']);
        $campaign_booking_id = '';
        $data = array();
        $campaign_booking_id = $this->Leads_model->storeCampaignBooking($params);

        /*if(isset($params['purpose_level_one'])){
				unset($params['purpose_level_one']);
			}
			if (!$is_exists){
				$complaint_id = $this->Lead_complaints_model->storeComplaint($params);
			} else {
				$complaint_id = $is_exists->id;
			}*/
        /*if ($campaign_booking_id) {
				
				$params['lms_complaint_id'] = $complaint_id;
				$this->Lead_complaints_model->storeComplaintHistory($params);
				$complaint_data = $this->Lead_complaints_model->getComplaintDetails($complaint_id);
				$description = 'New comlaint with comlaint ID ' . $complaint_id . ' added';
				$this->addUserActivity(COMPLAINT_ADD, $description, 0, $params['by_user']);
				if (base_url() != BASEURL && $params['email']) {
					$mail_pack = [
						'fname' => $complaint_data['fname'],
						'email' => $complaint_data['email'],
						'email_message' => leadComplaintEmailMessage($complaint_data['complain_id']),
						'thanks' => THANKS,
						'team' => WOSA,
					];
					//$this->sendEmailTostd_complaints_(LEAD_COMPLAINT_EMAIL_SUBJECT, $mail_pack);
				}
			}*/
        return $campaign_booking_id;
    }
}