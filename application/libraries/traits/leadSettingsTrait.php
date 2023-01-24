<?php

/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Ashok Kumar
 *
 * */
trait leadSettingsTrait {

    /**
     * 
     * @param int $days
     * @param int $hours
     * @param int $minutes
     * @return string
     */
    public function auto_calculateMinutesOfDaysHours(int $days = 0, int $hours = 0, int $minutes = 0) {
        $dayMinutes = $days ? $days * (1440) : 0;
        $hoursMinutes = $hours ? $hours * (60) : 0;
        return ($dayMinutes + $hoursMinutes + $minutes);
    }

    /**
     * 
     * @param array $params
     * @return array
     */
    public function auto_filterFunnelAcademySettingsParams(array $params) {
        $data_pack = [];
        $keys = ['lead_origin_type', 'origin', 'medium', 'purpose_level_one', 'purpose_level_two', 'purpose_level_three', 'center_id', 'int_country_id', 'division_id', 'tag_id', 'priority_id', 'init_contact_time', 'lead_convert_time', 'channel_id', 'department_id', 'employee_id', 'by_user', 'setting_center_id', 'setting_for', 'active'];
        foreach ($keys as $key) {
            if (isset($params[$key])) {
                $data_pack[$key] = $params[$key];
            }
        }
        return $data_pack;
    }

    /**
     * 
     * @param int $minutes
     * @return string
     */
    public function auto_calculateDaysHoursByMinutes(int $minutes) {
        $d = floor($minutes / 1440);
        $h = floor(($minutes - $d * 1440) / 60);
        $m = $minutes - ($d * 1440) - ($h * 60);
        return "{$d} Days, {$h} Hours, {$m} Minutes";
    }

    /**
     * 
     * @param string $field_key
     */
    public function auto_getLevelThreeSelectBoxList(string $field_key) {
        $this->load->model(['Center_location_model', 'Country_model']);
        switch ($field_key) {
            case "center_id":
                $centers = [];
                $branches = $this->Center_location_model->get_all_center_location_active();
                foreach ($branches as $branch) {
                    $centers[] = ['id' => $branch['center_id'], 'name' => $branch['center_name'], 'field_key' => $field_key];
                }
                return $centers;
            case "int_country_id":
                $countries = [];
                $list = $this->Country_model->getAllCountryNameAPI_deal();
                foreach ($list as $li) {
                    $countries[] = ['id' => $li['country_id'], 'name' => $li['name'], 'field_key' => $field_key];
                }
                return $countries;
            default:
                break;
        }
    }

    /**
     * 
     * @param type $purpose_levels
     * @return array
     */
    public function auto_getAllLevels($purpose_levels) {
        $this->load->model(['Lead_settings_model']);
        $pl_array = [];
        $index = 0;
        foreach ($purpose_levels as $level_one) {
            $pl_array['level_one'][$index] = $level_one;
            if ($level_one['is_primary'] == '0') {
                $level_two_array = $this->Lead_settings_model->getPurposeChildren($level_one['id']);
                foreach ($level_two_array as $in => $level_two) {
                    $pl_array['level_one'][$index]['children'][] = $level_two;
                    if ($level_two['is_primary'] == '0') {
                        $level_three_array = $this->Lead_settings_model->getPurposeChildren($level_two['id']);
                        foreach ($level_three_array as $in2 => $level_three) {
                            if ($level_three['is_primary'] == '1') {
                                $pl_array['level_one'][$index]['children'][$in]['child'] = $level_three;
                                $pl_array['level_one'][$index]['children'][$in]['child']['list'][] = [];
                                if (in_array($level_three['field_name'], ACA_VISA_L3_KEYS)) {
                                    $pl_array['level_one'][$index]['children'][$in]['child']['list'] = $this->auto_getLevelThreeSelectBoxList($level_three['field_name']);
                                }
                            }
                        }
                    }
                }
            } else {
                $pl_array['level_one'][$index]['children'][] = [];
            }
            $index++;
        }
        return $pl_array;
    }

}
