<?php

defined('BASEPATH') OR exit('No direct script access allowed');
if(!function_exists('marketing_popup_data'))
{
    function marketing_popup_data()
    {
        $todayTimeStamp = time();
        $marketingPopupsData = array();
        $ci = &get_instance();
        $ci->load->model('Marketing_popups_model');
        $marketingPopUp = get_cookie('MarketingPopUp');
        if($marketingPopUp==''){
            set_cookie('MarketingPopUp','yes','86400');
            $marketingPopupsData = $ci->Marketing_popups_model->get_all_marketing_popups_active_frontend();
                if($marketingPopupsData['startDateStr']<=$todayTimeStamp && $marketingPopupsData['endDateStr']>$todayTimeStamp){
                    return $marketingPopupsData;
            }
            
        }

    }
}