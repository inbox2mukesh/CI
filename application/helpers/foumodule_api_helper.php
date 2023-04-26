<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function fetch_fourmodule_pack_id($test_module_name,$programe_name,$pack_type)
{
// echo $pack_type;
     if($pack_type == 0)// 0=domestic/inter
     {
         if($test_module_name =="PTE")
         {
             $fourmodule_pack_id=FOURMODULE_PTE_INDIAN;
         }
         else if(($test_module_name =="CD-IELTS" || $test_module_name =="IELTS" ) && $programe_name =="Academic")
         {
             $fourmodule_pack_id=FOURMODULE_IELTS_ACD_INDIAN;
         }
         else if(($test_module_name =="CD-IELTS" || $test_module_name =="IELTS" ) && $programe_name =="General Training")
         {
             $fourmodule_pack_id=FOURMODULE_IELTS_GT_INDIAN;
         }
         else if($test_module_name =="FLIP" )
         {
             $fourmodule_pack_id=FOURMODULE_FLIP_INDIAN;
         }
         else if($test_module_name =="CELPIP" )
         {
             $fourmodule_pack_id=FOURMODULE_CELPIP_INDIAN;
         }
         else if($test_module_name =="TOEFL" )
         {
             $fourmodule_pack_id=FOURMODULE_TOEFL_INDIAN;
         }
             
     }
     else {// 1=international
       //  echo $test_module_name.' '.$programe_name;
         if($test_module_name =="PTE")
         {
             $fourmodule_pack_id=FOURMODULE_PTE_INTERNATIONAL;
         }
         else if(($test_module_name =="CD-IELTS" || $test_module_name =="IELTS" ) && strtolower($programe_name) =="academic")
         {
             $fourmodule_pack_id=FOURMODULE_IELTS_ACD_INTERNATIONAL;
         }
         else if(($test_module_name =="CD-IELTS" || $test_module_name =="IELTS" ) && strtolower($programe_name) =="general training")
         {
             $fourmodule_pack_id=FOURMODULE_IELTS_GT_INTERNATIONAL;
         }
         else if($test_module_name =="FLIP" )
         {
             $fourmodule_pack_id=FOURMODULE_FLIP_INTERNATIONAL;
         }
         else if($test_module_name =="CELPIP" )
         {
             $fourmodule_pack_id=FOURMODULE_CELPIP_INTERNATIONAL;
         }
         else if($test_module_name =="TOEFL" )
         {
             $fourmodule_pack_id=FOURMODULE_TOEFL_INTERNATIONAL;
         }
     }
     
     return $fourmodule_pack_id; 
}


function _curPostData_fourmodules($url, $headers, $params)
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

if(!function_exists('fourmodule_new_password'))
{
    function fourmodule_new_password($uid=null,$password=null)
    {
        $ci = &get_instance();
        $headers_fourmodule= array(
            'authorization:'.FOURMODULE_KEY,                           
            );  
            $params_fourmodule = array(
            "api" => "login", 
            "action"=>'password_change', 
            "centre_id"=>FOURMODULE_ONL_BRANCH_ID, 
            "domain_id"=>FOURMODULE_DOMAIN_ID,        
            "token"=>$uid,
            "password"=>$password,                                        
            );                          
            // Call Enrollment apie
           return _curPostData_fourmodules(FOURMODULE_URL, $headers_fourmodule, $params_fourmodule);

    }

}




?>