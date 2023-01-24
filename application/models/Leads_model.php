<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Ashok Kumar
 *
 * */
class Leads_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * This function will be used add or edit rows in lms_table_settings table
     * 
     * @param int $user_id
     * @param string $settingType
     * @param string $settings
     * @param int $records
     * @return type
     */
    public function saveUpdateTableSettings(int $user_id, string $settingType, string $settings, int $records = RECORDS_PER_PAGE) {
        $row = $this->getTableSettings($user_id, $settingType);
        if ($row) {
            $this->db->where(['user_id' => $user_id, 'setting_type' => $settingType]);
            return $this->db->update('lms_table_settings', ['settings' => $settings, 'record_per_page' => $records]);
        } else {
            return $this->db->insert('lms_table_settings', ['user_id' => $user_id, 'setting_type' => $settingType, 'settings' => $settings, 'record_per_page' => $records]);
        }
    }

    /**
     * 
     * @param int $user_id
     * @param string $settingType
     * @return type
     */
    public function getTableSettings(int $user_id, string $settingType) {
        return $this->db->select('*')->from('lms_table_settings')
                        ->where(['user_id' => $user_id, 'setting_type' => $settingType])->get()->row();
    }

    /**
     * This function will be used add rows in lms_leads_notes table
     * 
     * @param array $params
     * @return type
     */
    public function storeLeadNotes(array $params) {
        return $this->db->insert('lms_leads_notes', $params);
    }

    /**
     * This function will be used add rows in lms_leads table
     * 
     * @param array $params
     * @return type
     */
    public function storeLead(array $params) {
        $this->db->insert('lms_leads', $params);
        return $this->db->insert_id();
    }

    /**
     * This function will be used add rows in lms_lead_history table
     * 
     * @param array $params
     * @return type
     */
    public function storeLeadHistory(array $params) {
        $this->db->insert('lms_lead_history', $params);
        return $this->db->insert_id();
    }

    /**
     * 
     * @param array $checks
     * @return type
     */
    public function checkLeadExistance(array $checks) {
        return $this->db->select('*')->from('lms_leads')
                        ->where($checks)->get()->row();
    }

    /**
     * 
     * @param array $params
     * @return array
     */
    public function getLeadsList(array $params = []) {
        if (isset($params['limit']) && !empty($params['limit'])) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $search_params = $params['search_params'];
        if ((isset($search_params['lead_title']) && $search_params['lead_title'] != '') || (isset($search_params['dob']) && $search_params['dob'] != '')) {
            if (isset($search_params['lead_title']) && $search_params['lead_title'] != '') {
                $this->db->group_start();
                $this->db->like('s.UID', $search_params['lead_title']);
                $this->db->or_like('s.fname', $search_params['lead_title']);
                $this->db->or_like('s.lname', $search_params['lead_title']);
                $this->db->or_like('s.email', $search_params['lead_title']);
                $this->db->or_like('s.mobile', $search_params['lead_title']);
                $this->db->or_like('s.passport_number', $search_params['lead_title']);
                $this->db->group_end();
            }
            if (isset($search_params['dob']) && $search_params['dob'] != '') {
                $dob = explode("-", $search_params['dob']);
                $start_date = str_replace('/', '-', trim($dob[0]));
                $end_date = str_replace('/', '-', trim($dob[1]));
                $this->db->where('DATE(s.dob) BETWEEN DATE("' . date('d-m-Y', strtotime($start_date)) . '") AND DATE("' . date('d-m-Y', strtotime($end_date)) . '")');
            }
        }
        if (isset($search_params['lead_created']) && $search_params['lead_created'] != '') {
            $lead_created = explode("-", $search_params['lead_created']);
            $start_date = str_replace('/', '-', trim($lead_created[0]));
            $end_date = str_replace('/', '-', trim($lead_created[1]));
            $this->db->where('DATE(l.created) BETWEEN "' . date('Y-m-d', strtotime($start_date)) . '" AND "' . date('Y-m-d', strtotime($end_date)) . '"');
        }
        if (isset($search_params['origin_type']) && $search_params['origin_type'] != '') {
            $this->db->where('l.lead_origin_type', $search_params['origin_type']);
        }
        if (isset($search_params['origin']) && $search_params['origin'] != '') {
            $this->db->where('l.origin', $search_params['origin']);
        }
        if (isset($search_params['medium']) && $search_params['medium'] != '') {
            $this->db->where('l.medium', $search_params['medium']);
        }
        if (isset($search_params['medium_source']) && $search_params['medium_source'] != '') {
            $this->db->where('l.source_id', $search_params['medium_source']);
        }
        if (isset($search_params['division_id']) && $search_params['division_id'] != '') {
            $this->db->where('l.division_id', $search_params['division_id']);
        }
        if (isset($search_params['branch']) && $search_params['branch'] != '') {
            $this->db->where('l.center_id', $search_params['branch']);
        }
        if (isset($search_params['program']) && $search_params['program'] != '') {
            $this->db->where('l.programe_id', $search_params['program']);
        }
        if (isset($search_params['center_id']) && $search_params['center_id'] != '') {
            $this->db->where('l.center_id', $search_params['center_id']);
        }
        if (isset($search_params['assigned_on']) && $search_params['assigned_on'] != '') {
            $assigned_on = explode("-", $search_params['assigned_on']);
            $start_date_ao = str_replace('/', '-', trim($assigned_on[0]));
            $end_date_ao = str_replace('/', '-', trim($assigned_on[1]));
            $this->db->where('DATE(lla.modified) BETWEEN "' . date('Y-m-d', strtotime($start_date_ao)) . '" AND "' . date('Y-m-d', strtotime($end_date_ao)) . '"');
        }
        if (isset($search_params['tags']) && $search_params['tags'] != '') {
            $this->db->where('lla.tag_id', $search_params['tags']);
        }
        if (isset($search_params['assigned_by']) && $search_params['assigned_by'] != '') {
            $this->db->where('lla.by_user', $search_params['assigned_by']);
        }
        if (isset($search_params['assigned_to']) && $search_params['assigned_to'] != '') {
            $this->db->where('lla.assign_to_employee_id', $search_params['assigned_to']);
        }
        if (isset($search_params['distribution_channel']) && $search_params['distribution_channel'] != '') {
            $this->db->where('lla.channel_id', $search_params['distribution_channel']);
        }
        if (isset($search_params['priority_level']) && $search_params['priority_level'] != '') {
            $this->db->where('lla.priority_id', $search_params['priority_level']);
        }
        return $this->db->select('l.*, s.is_otp_verified, s.fname, s.lname, s.email, s.country_code, s.mobile, s.UID, dm.division_name, sm.source_name, lmp1.name as level_one, lmp2.name as level_two, lmp3.name as level_three, cs.subject complaint_subject, ft.topic feedback_topic, gas.subject gas_subject, tm.test_module_name, pm.programe_name, cl.center_name, qm.qualification_name, cm.name int_country_name, wem.work_experience, itm.industry_type, etm.eventTypeTitle,pkg.package_name,ppkg.package_name as practice_pack_name,rt.title as reality_test_name,ol.location_name as exam_location_name,evt.eventTitle, lla.modified assigned_on, CONCAT(u.fname, " ", u.lname) assigned_by, CONCAT(u1.fname, " ", u1.lname) assigned_to, cl1.center_name assigned_to_branch, dm1.department_name assigned_to_department, lla.priority_id priority, ltm.tag, lla.channel_id channel')
                        ->from('lms_leads l')
                        ->join('students s', 's.id = l.student_id', 'LEFT')
                        ->join('division_masters dm', 'dm.id = l.division_id', 'LEFT')
                        ->join('source_masters sm', 'sm.id = l.source_id', 'LEFT')
                        ->join('complaint_subject cs', 'cs.id = l.complain_subject', 'LEFT')
                        ->join('feedback_topic ft', 'ft.id = l.feedback_subject', 'LEFT')
                        ->join('general_assistance_subjects gas', 'gas.id = l.ga_subject', 'LEFT')
                        ->join('lms_purposes_master lmp1', 'lmp1.id = l.purpose_level_one', 'LEFT')
                        ->join('lms_purposes_master lmp2', 'lmp2.id = l.purpose_level_two', 'LEFT')
                        ->join('lms_purposes_master lmp3', 'lmp3.id = l.purpose_level_three', 'LEFT')
                        ->join('center_location cl', 'cl.center_id = l.center_id', 'LEFT')
                        ->join('test_module tm', 'tm.test_module_id = l.test_module_id', 'LEFT')
                        ->join('programe_masters pm', 'pm.programe_id = l.programe_id', 'LEFT')
                        ->join('qualification_masters qm', 'qm.id = l.qualification_id', 'LEFT')
                        ->join('country cm', 'cm.country_id = l.int_country_id', 'LEFT')
                        ->join('work_experience_master wem', 'wem.id = l.work_experience_years', 'LEFT')
                        ->join('industry_type_master itm', 'itm.id = l.industry', 'LEFT')
                        ->join('event_type_master etm', 'etm.id = l.event_type', 'LEFT')
                        ->join('package_masters pkg', 'pkg.package_id = l.package_id', 'LEFT')
                        ->join('practice_package_masters ppkg', 'ppkg.package_id = l.practice_package_id', 'LEFT')
                        ->join('real_test_dates rt', 'rt.id = l.reality_test_id', 'LEFT')
                        ->join('outhouse_locations ol', 'ol.id = l.exam_location_id', 'LEFT')
                        ->join('events evt', 'evt.id = l.event_id', 'LEFT')
                        ->join('lms_lead_assignments lla', 'lla.lead_id = l.id', 'LEFT')
                        ->join('user u', 'u.id = lla.by_user', 'LEFT')
                        ->join('user u1', 'u1.id = lla.assign_to_employee_id', 'LEFT')
                        ->join('center_location cl1', 'cl1.center_id = lla.assign_to_functional_branch_id', 'LEFT')
                        ->join('department_masters dm1', 'dm1.id = lla.assign_to_department_id', 'LEFT')
                        ->join('lms_tags_master ltm', 'ltm.id = lla.tag_id', 'LEFT')
                        ->order_by('l.id', 'DESC')->get()->result_array();
    }

    /**
     * 
     * @param int $id
     * @return array
     */
    public function getLeadById(int $id) {
        return $this->db->select('l.*, s.is_otp_verified, s.fname, s.lname, s.email, s.country_code, s.mobile, s.UID, dm.division_name, sm.source_name, lmp1.name as level_one, lmp2.name as level_two, lmp3.name as level_three, cs.subject complaint_subject, ft.topic feedback_topic, gas.subject gas_subject, tm.test_module_name, pm.programe_name, cl.center_name, qm.qualification_name, cm.name int_country_name, wem.work_experience, itm.industry_type, etm.eventTypeTitle,pkg.package_name,ppkg.package_name as practice_pack_name,rt.title as reality_test_name,ol.location_name as exam_location_name,evt.eventTitle')
                        ->from('lms_lead_history l')
                        ->join('students s', 's.id = l.student_id', 'LEFT')
                        ->join('division_masters dm', 'dm.id = l.division_id', 'LEFT')
                        ->join('source_masters sm', 'sm.id = l.source_id', 'LEFT')
                        ->join('complaint_subject cs', 'cs.id = l.complain_subject', 'LEFT')
                        ->join('feedback_topic ft', 'ft.id = l.feedback_subject', 'LEFT')
                        ->join('general_assistance_subjects gas', 'gas.id = l.ga_subject', 'LEFT')
                        ->join('lms_purposes_master lmp1', 'lmp1.id = l.purpose_level_one', 'LEFT')
                        ->join('lms_purposes_master lmp2', 'lmp2.id = l.purpose_level_two', 'LEFT')
                        ->join('lms_purposes_master lmp3', 'lmp3.id = l.purpose_level_three', 'LEFT')
                        ->join('center_location cl', 'cl.center_id = l.center_id', 'LEFT')
                        ->join('test_module tm', 'tm.test_module_id = l.test_module_id', 'LEFT')
                        ->join('programe_masters pm', 'pm.programe_id = l.programe_id', 'LEFT')
                        ->join('qualification_masters qm', 'qm.id = l.qualification_id', 'LEFT')
                        ->join('country cm', 'cm.country_id = l.int_country_id', 'LEFT')
                        ->join('work_experience_master wem', 'wem.id = l.work_experience_years', 'LEFT')
                        ->join('industry_type_master itm', 'itm.id = l.industry', 'LEFT')
                        ->join('event_type_master etm', 'etm.id = l.event_type', 'LEFT')
						->join('package_masters pkg', 'pkg.package_id = l.package_id', 'LEFT')
						->join('practice_package_masters ppkg', 'ppkg.package_id = l.practice_package_id', 'LEFT')
						->join('real_test_dates rt', 'rt.id = l.reality_test_id', 'LEFT')
						->join('outhouse_locations ol', 'ol.id = l.exam_location_id', 'LEFT')
						->join('events evt', 'evt.id = l.event_id', 'LEFT')
                        ->where('l.lms_lead_id', $id)->order_by('l.id', 'DESC')->limit(1)
                        ->get()->row_array();
    }

    /**
     * 
     * @param int $id
     * @return int
     */
    public function getLeadsByCount(int $id) {
        $this->db->where('lms_lead_id', $id);
        $this->db->from('lms_lead_history');
        return $this->db->count_all_results();
    }

    /**
     * 
     * @param array $params
     * @return int
     */
    public function getLeadsCount(array $params = []) {
        $search_params = $params['search_params'];
        if ((isset($search_params['lead_title']) && $search_params['lead_title'] != '') || (isset($search_params['dob']) && $search_params['dob'] != '')) {
            $this->db->join('students', 'students.id = lms_leads.student_id');
            if (isset($search_params['lead_title']) && $search_params['lead_title'] != '') {
                $this->db->group_start();
                $this->db->like('students.UID', $search_params['lead_title']);
                $this->db->or_like('students.fname', $search_params['lead_title']);
                $this->db->or_like('students.lname', $search_params['lead_title']);
                $this->db->or_like('students.email', $search_params['lead_title']);
                $this->db->or_like('students.mobile', $search_params['lead_title']);
                $this->db->or_like('students.passport_number', $search_params['lead_title']);
                $this->db->group_end();
            }
            if (isset($search_params['dob']) && $search_params['dob'] != '') {
                $dob = explode("-", $search_params['dob']);
                $start_date = str_replace('/', '-', trim($dob[0]));
                $end_date = str_replace('/', '-', trim($dob[1]));
                $this->db->where('students.dob BETWEEN DATE("' . date('d-m-Y', strtotime($start_date)) . '") AND DATE("' . date('d-m-Y', strtotime($end_date)) . '")');
            }
        }
        if (isset($search_params['lead_created']) && $search_params['lead_created'] != '') {
            $lead_created = explode("-", $search_params['lead_created']);
            $start_date = str_replace('/', '-', trim($lead_created[0]));
            $end_date = str_replace('/', '-', trim($lead_created[1]));
            $this->db->where('lms_leads.created BETWEEN "' . date('Y-m-d', strtotime($start_date)) . '" AND "' . date('Y-m-d', strtotime($end_date)) . '"');
        }
        if (isset($search_params['origin_type']) && $search_params['origin_type'] != '') {
            $this->db->where('lms_leads.lead_origin_type', $search_params['origin_type']);
        }
        if (isset($search_params['origin']) && $search_params['origin'] != '') {
            $this->db->where('lms_leads.origin', $search_params['origin']);
        }
        if (isset($search_params['medium']) && $search_params['medium'] != '') {
            $this->db->where('lms_leads.medium', $search_params['medium']);
        }
        if (isset($search_params['medium_source']) && $search_params['medium_source'] != '') {
            $this->db->where('lms_leads.source_id', $search_params['medium_source']);
        }
        if (isset($search_params['division_id']) && $search_params['division_id'] != '') {
            $this->db->where('lms_leads.division_id', $search_params['division_id']);
        }
        if (isset($search_params['branch']) && $search_params['branch'] != '') {
            $this->db->where('lms_leads.center_id', $search_params['branch']);
        }
        if (isset($search_params['program']) && $search_params['program'] != '') {
            $this->db->where('lms_leads.programe_id', $search_params['program']);
        }
        if (isset($search_params['center_id']) && $search_params['center_id'] != '') {
            $this->db->where('lms_leads.center_id', $search_params['center_id']);
        }
        if (isset($search_params['assigned_on']) && $search_params['assigned_on'] != '') {
        $this->db->join('lms_lead_assignments lla', 'lla.lead_id = lms_leads.id');
            $assigned_on = explode("-", $search_params['assigned_on']);
            $start_date_ao = str_replace('/', '-', trim($assigned_on[0]));
            $end_date_ao = str_replace('/', '-', trim($assigned_on[1]));
            $this->db->where('DATE(lla.modified) BETWEEN "' . date('Y-m-d', strtotime($start_date_ao)) . '" AND "' . date('Y-m-d', strtotime($end_date_ao)) . '"');
        }
        if (isset($search_params['tags']) && $search_params['tags'] != '') {
        $this->db->join('lms_lead_assignments lla', 'lla.lead_id = lms_leads.id');
            $this->db->where('lla.tag_id', $search_params['tags']);
        }
        if (isset($search_params['assigned_by']) && $search_params['assigned_by'] != '') {
        $this->db->join('lms_lead_assignments lla', 'lla.lead_id = lms_leads.id');
            $this->db->where('lla.by_user', $search_params['assigned_by']);
        }
        if (isset($search_params['assigned_to']) && $search_params['assigned_to'] != '') {
        $this->db->join('lms_lead_assignments lla', 'lla.lead_id = lms_leads.id');
            $this->db->where('lla.assign_to_employee_id', $search_params['assigned_to']);
        }
        if (isset($search_params['distribution_channel']) && $search_params['distribution_channel'] != '') {
        $this->db->join('lms_lead_assignments lla', 'lla.lead_id = lms_leads.id');
            $this->db->where('lla.channel_id', $search_params['distribution_channel']);
        }
        if (isset($search_params['priority_level']) && $search_params['priority_level'] != '') {
        $this->db->join('lms_lead_assignments lla', 'lla.lead_id = lms_leads.id');
            $this->db->where('lla.priority_id', $search_params['priority_level']);
        }
        $this->db->from('lms_leads');
        return $this->db->count_all_results();
    }

    /**
     * 
     * @param array $params
     * @param int $is_assinged
     * @return int
     */
    public function getLeadsUnassignedCount(array $params = []) {
        $search_params = $params['search_params'];
        if ((isset($search_params['lead_title']) && $search_params['lead_title'] != '') || (isset($search_params['dob']) && $search_params['dob'] != '')) {
            $this->db->join('students', 'students.id = lms_leads.student_id');
            if (isset($search_params['lead_title']) && $search_params['lead_title'] != '') {
                $this->db->group_start();
                $this->db->like('students.UID', $search_params['lead_title']);
                $this->db->or_like('students.fname', $search_params['lead_title']);
                $this->db->or_like('students.lname', $search_params['lead_title']);
                $this->db->or_like('students.email', $search_params['lead_title']);
                $this->db->or_like('students.mobile', $search_params['lead_title']);
                $this->db->or_like('students.passport_number', $search_params['lead_title']);
                $this->db->group_end();
            }
            if (isset($search_params['dob']) && $search_params['dob'] != '') {
                $dob = explode("-", $search_params['dob']);
                $start_date = str_replace('/', '-', trim($dob[0]));
                $end_date = str_replace('/', '-', trim($dob[1]));
                $this->db->where('students.dob BETWEEN DATE("' . date('d-m-Y', strtotime($start_date)) . '") AND DATE("' . date('d-m-Y', strtotime($end_date)) . '")');
            }
        }
        if (isset($search_params['lead_created']) && $search_params['lead_created'] != '') {
            $lead_created = explode("-", $search_params['lead_created']);
            $start_date = str_replace('/', '-', trim($lead_created[0]));
            $end_date = str_replace('/', '-', trim($lead_created[1]));
            $this->db->where('lms_leads.created BETWEEN "' . date('Y-m-d', strtotime($start_date)) . '" AND "' . date('Y-m-d', strtotime($end_date)) . '"');
        }
        if (isset($search_params['origin_type']) && $search_params['origin_type'] != '') {
            $this->db->where('lms_leads.lead_origin_type', $search_params['origin_type']);
        }
        if (isset($search_params['origin']) && $search_params['origin'] != '') {
            $this->db->where('lms_leads.origin', $search_params['origin']);
        }
        if (isset($search_params['medium']) && $search_params['medium'] != '') {
            $this->db->where('lms_leads.medium', $search_params['medium']);
        }
        if (isset($search_params['medium_source']) && $search_params['medium_source'] != '') {
            $this->db->where('lms_leads.source_id', $search_params['medium_source']);
        }
        if (isset($search_params['division_id']) && $search_params['division_id'] != '') {
            $this->db->where('lms_leads.division_id', $search_params['division_id']);
        }
        if (isset($search_params['branch']) && $search_params['branch'] != '') {
            $this->db->where('lms_leads.center_id', $search_params['branch']);
        }
        if (isset($search_params['program']) && $search_params['program'] != '') {
            $this->db->where('lms_leads.programe_id', $search_params['program']);
        }
        if (isset($search_params['center_id']) && $search_params['center_id'] != '') {
            $this->db->where('lms_leads.center_id', $search_params['center_id']);
        }
        $this->db->where('lms_leads.is_assigned', 0);
        $this->db->from('lms_leads');
        return $this->db->count_all_results();
    }

    public function getLeadsHistoryList(int $lead_id, array $params = []) {
        if (isset($params['limit']) && !empty($params['limit'])) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->select('l.*, s.is_otp_verified, s.fname, s.lname, s.email, s.country_code, s.mobile, s.UID, dm.division_name, sm.source_name, lmp1.name as level_one, lmp2.name as level_two, lmp3.name as level_three, cs.subject complaint_subject, ft.topic feedback_topic, gas.subject gas_subject, tm.test_module_name, pm.programe_name, cl.center_name, qm.qualification_name, cm.name int_country_name, wem.work_experience, itm.industry_type, etm.eventTypeTitle,pkg.package_name,ppkg.package_name as practice_pack_name,rt.title as reality_test_name,ol.location_name as exam_location_name,evt.eventTitle')
                        ->from('lms_lead_history l')
                        ->join('students s', 's.id = l.student_id', 'LEFT')
                        ->join('division_masters dm', 'dm.id = l.division_id', 'LEFT')
                        ->join('source_masters sm', 'sm.id = l.source_id', 'LEFT')
                        ->join('complaint_subject cs', 'cs.id = l.complain_subject', 'LEFT')
                        ->join('feedback_topic ft', 'ft.id = l.feedback_subject', 'LEFT')
                        ->join('general_assistance_subjects gas', 'gas.id = l.ga_subject', 'LEFT')
                        ->join('lms_purposes_master lmp1', 'lmp1.id = l.purpose_level_one', 'LEFT')
                        ->join('lms_purposes_master lmp2', 'lmp2.id = l.purpose_level_two', 'LEFT')
                        ->join('lms_purposes_master lmp3', 'lmp3.id = l.purpose_level_three', 'LEFT')
                        ->join('center_location cl', 'cl.center_id = l.center_id', 'LEFT')
                        ->join('test_module tm', 'tm.test_module_id = l.test_module_id', 'LEFT')
                        ->join('programe_masters pm', 'pm.programe_id = l.programe_id', 'LEFT')
                        ->join('qualification_masters qm', 'qm.id = l.qualification_id', 'LEFT')
                        ->join('country cm', 'cm.country_id = l.int_country_id', 'LEFT')
                        ->join('work_experience_master wem', 'wem.id = l.work_experience_years', 'LEFT')
                        ->join('industry_type_master itm', 'itm.id = l.industry', 'LEFT')
                        ->join('event_type_master etm', 'etm.id = l.event_type', 'LEFT')
						->join('package_masters pkg', 'pkg.package_id = l.package_id', 'LEFT')
						->join('practice_package_masters ppkg', 'ppkg.package_id = l.practice_package_id', 'LEFT')
						->join('real_test_dates rt', 'rt.id = l.reality_test_id', 'LEFT')
						->join('outhouse_locations ol', 'ol.id = l.exam_location_id', 'LEFT')
						->join('events evt', 'evt.id = l.event_id', 'LEFT')
                        ->where('l.lms_lead_id', $lead_id)
                        ->get()->result_array();
    }

    /**
     * 
     * @param int $lead_id
     * @return int
     */
    public function getLeadsHistoryCount(int $lead_id) {
        $this->db->from('lms_lead_history')->where('lms_lead_id', $lead_id);
        return $this->db->count_all_results();
    }

    /**
     * 
     * @param int $lead_id
     * @return int
     */
    public function getLeadNoteInfoById(int $lead_id) {
        return $this->db->select('note')->from('lms_lead_history')->where('id', $lead_id)->limit(1)->get()->row_array();
    }
	public function storeCampaignBooking(array $params)
    {
        $this->db->insert('lms_campaign_booking', $params);
        return $this->db->insert_id();
    }
	function auto_clean_leads()
    {
        $this->db->truncate('lms_complaints ');
        $this->db->truncate('lms_complaints_history');
        $this->db->truncate('lms_feedbacks');
        $this->db->truncate('lms_feedbacks_history');
        $this->db->truncate('lms_general_assistances');
        $this->db->truncate('lms_general_assistances_history');
        $this->db->truncate('lms_leads');
        $this->db->truncate('lms_leads_nql');
		$this->db->truncate('lms_lead_assignments');
		$this->db->truncate('lms_lead_assignments_history');
		$this->db->truncate('lms_lead_history');
		$this->db->truncate('lms_lead_history');
		 	 
		 
 		
    } 

}
