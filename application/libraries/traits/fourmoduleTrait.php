<?php

/**
 * @package         WOSA
 * @subpackage      Four Module APIs
 * @author          Harpreet Rattu
 *
 * */

trait fourmoduleTrait
{
    function _identify_fourmoduleapi($headers=null,$params=null)
    {
        // return json_decode($this->_curlGetData(base_url(IDENTIFY_FOURMODULE_API), $headers));
        $response = json_decode($this->_curPostData_fourmodules(FOURMODULE_URL, $this->headers_fourmodule, $headers));
        $responseval = 0;
        $packlist = [];
        $ieltsidrange = [336,337,338,339];
        $data = $response->data[0]->packs;
        if(!empty($data))
        {
                      
            foreach($data as $packs)
            {
                $packlist[] = $packs->pack_id;
            }            
        }
        
        if($response->success == 0)
        {
            $responseval = 1;
        }
        else{
            if(in_array($params['pack_id'],$packlist) || in_array($params['pack_id'],$ieltsidrange))
                {                   
                    $responseval = 2;// 're-enroll'
                }
                else{                    
                    $responseval = 3;//'add program'
                }           
        }
        return $responseval;
    }

    function _fourmoduleapi__bind_params()
    {
        return array(
            "api" => "enrolment",  
            "centre_id"=>FOURMODULE_ONL_BRANCH_ID, 
            "domain_id"=>FOURMODULE_DOMAIN_ID,                                        
            ); 
    }
    

    function __setFourmoduleapi($apiID=null,$parms =[])
    {
        $params = [];
        switch($apiID)
        {
            case 1://new enrollment               
                $params = [
                "action"=>'enrol_student',      
                "pack_id"=>$parms['pack_id'],                                     
                "name"=>$parms['name'],                                        
                "token"=>$parms['token'],                                        
                "start_date"=>$parms['start_date'],                                        
                "end_date"=>$parms['end_date'], 
                "username"=>$parms['username'],
                "password"=>$parms['password'],                                        
                ];
                break;
            case 2: //re-enrolment
                    $params = [
                        "action"=>'Re_enrolment',      
                        "pack_id"=>$parms['pack_id'],                                     
                        "name"=>$parms['name'],                                        
                        "token"=>$parms['token'],                                        
                        "start_date"=>$parms['start_date'],                                        
                        "end_date"=>$parms['end_date'],                                        
                    ];
                    break;
            case 3: //add program
                $params = [
                    "action"=>'Add_program',      
                    "pack_id"=>$parms['pack_id'],                                     
                    "name"=>$parms['name'],                                        
                    "token"=>$parms['token'],                                        
                    "start_date"=>$parms['start_date'],                                        
                    "end_date"=>$parms['end_date'],                                        
                ];
                break;
            default: 
                break;  
                
            
        }        
        $param_base = $this->_fourmoduleapi__bind_params();
        return array_merge($param_base,$params);

    }

    function __checkuserExists($headers=null)
    {
        $response = json_decode($this->_curPostData_fourmodule(FOURMODULE_URL, $this->headers_fourmodule, $headers));
        $userexits = 1;
        if($response->success == 0)
        {
            $userexits = 0;
        }
        return $userexits;

    }
    public function _curPostData_fourmodule($url, $headers, $params)
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