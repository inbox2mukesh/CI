<?php
/**
 * @package         WOSA
 * @subpackage      ---------
 * @author          Navjeet
 *
 **/ 
class Lead_management extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Followup_model');  
        $this->load->model('Student_enquiry_model');  
        $this->load->model('User_model');  
        $this->load->model('Country_model');
        $this->load->model('Enquiry_purpose_model');
        $this->load->model('Immigration_tools_model');             
        $this->load->model('Division_master_model');             
        $this->load->model('Student_model'); 
        $this->load->helper('common');             
    }

    function crs_list(){
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        
        if($this->input->post('date') !="")
        {
            if($this->input->post('date'))
            {
                $date1      = explode(' - ',$this->input->post('date'));
                $start_date = $date1[0]; 
                $end_date   = $date1[1]; 
                
                $start_date = date_create($start_date);
                $start_date = date_format($start_date,"Y-m-d");
                
                $end_date   = date_create($end_date);
                $end_date   = date_format($end_date,"Y-m-d");
            }
            else
            {
                $start_date = NULL; 
                $end_date   = NULL; 
            }
             
            $this->load->library('pagination');
            $params['limit'] = RECORDS_PER_PAGE; 
            $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
            $config = $this->config->item('pagination');
            $config['base_url'] = site_url('adminController/immigration_tools/index/?');
            $config['total_rows'] = $this->Immigration_tools_model->get_all_crs_score_count_bydate($start_date,$end_date);
            $this->pagination->initialize($config);
            $data['title'] = 'CRS';
            $data['immigration_tools'] = $this->Immigration_tools_model->get_all_crs_score_bydate($start_date,$end_date,$params);
            $data['_view'] = 'immigration_tools/crs_list';
            $this->load->view('layouts/main',$data);
        }
        else 
        {
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/immigration_tools/index/?');
        $config['total_rows'] = $this->Immigration_tools_model->get_all_crs_score_count();
        $this->pagination->initialize($config);
        $data['title'] = 'CRS';
        $data['immigration_tools'] = $this->Immigration_tools_model->get_all_crs_score($params);
        $data['_view'] = 'immigration_tools/crs_list';
        $this->load->view('layouts/main',$data);            
        }
    } 

    function crs_view($id){

        $data['title'] = 'CRS';
        $data['immigration_tools'] = $this->Immigration_tools_model->get_crs_score($id);
        $data['_view'] = 'immigration_tools/crs_view';
        $this->load->view('layouts/main',$data);
        
    }
    function get_lead_CSV($id=0)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $data['title'] = 'CRS Lead' ;         
        $this->load->library("excel");
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);
        $table_columns = array("Username", "Email-ID", "Mobile No.", "CRS Score", 'OTP status',"Date");
        $column = 0;
        $params = [];
        foreach($table_columns as $field)
        {
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
        }
        
        if($id !="")
        {
             $date1 = $id ;
             $date1=date_create($date1);
             $date=date_format($date1,"Y-m-d");
             $data['get_lead_CSV'] = $this->Immigration_tools_model->get_all_crs_score_bydate($date,$params);   
        }
        else {
            $data['get_lead_CSV'] = $this->Immigration_tools_model->get_all_crs_score($params);   
        }
          
                 
          $excel_row = 2;
          foreach($data['get_lead_CSV'] as $row)
          {
              
              $st="Un-verified";
              if($row['otp_status'] ==1)
              {
                  $st="verified";
              } 
                        
           $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['fname'].' '.$row['lname']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['email']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['country_code'].'-'.$row['phone']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['grand_total_crs']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $st);
           $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['created']);           
           
           $excel_row++;
          }
          $fileVame='CRS-Lead-CSV-data'.'.xls';
          $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename='.$fileVame);
          $object_writer->save('php://output');
    }
    /*----List followup status----*/
    function followup_status_list()
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/lead_management/followup_status_list?');
        $config['total_rows'] = $this->Followup_model->get_all_followup_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Followup status list';
        $data['followup'] = $this->Followup_model->get_all_followup($params);        
        $data['_view'] = 'followup_master/index';
        $this->load->view('layouts/main',$data);
    }
    /*----Add followup status----*/
    function add_followup_status_()
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Add Followup Status';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('title','Title','required|trim');		
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active'),
				'title' => $this->input->post('title'),
                'by_user' => $by_user,
            ); 
           $dup = $this->Followup_model->duplicate_title($this->input->post('title')); 
            if($dup=='DUPLICATE')
            {
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/lead_management/add');
            }
            else
            {
                $id = $this->Followup_model->add_followup($params);
                if($id)
                {
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/lead_management/followup_status_list');
                }
                else
                {
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/lead_management/add');
                }  
            }                     
        }
        else
        {            
            $data['_view'] = 'followup_master/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*----edit followup status----*/
    function edit_followup_status_($id)
    {         
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Edit followup status';
        $data['followup'] = $this->Followup_model->get_followup($id);
        
        if(isset($data['followup']['id']))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title','Title','required|trim');		
			if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(
					'active' => $this->input->post('active'),
					'title' => $this->input->post('title'),
                    'by_user' => $by_user,
                );
                if($data['followup']['title'] !=$this->input->post('title'))
                {
                    $dup = $this->Followup_model->duplicate_title($this->input->post('title'));
                    if($dup=='DUPLICATE')
                    {
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);
                    redirect('adminController/lead_management/edit/'.$id);
                    }
                    else
                    {
                        $idd = $this->Followup_model->update_followup($id,$params); 
                        if($idd)
                        {
                            $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                            redirect('adminController/lead_management/followup_status_list');
                        }
                        else
                        {
                            $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                            redirect('adminController/lead_management/edit/'.$id);
                        } 
                    }
                }
                else 
                {
                  $idd = $this->Followup_model->update_followup($id,$params); 
                    if($idd)
                    {
                        $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                        redirect('adminController/lead_management/followup_status_list');
                    }
                    else
                    {
                        $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                        redirect('adminController/lead_management/edit/'.$id);
                    } 
                }               
            }
            else
            {
                $data['_view'] = 'followup_master/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }    
     /*----remove followup status----*/
    /*function remove($id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $gender = $this->Gender_model->get_gender($id);
        if(isset($gender['id']))
        {
            $this->Gender_model->delete_gender($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/gender/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/

    /* get all leads */   

    function all_Leads()
    {
         //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        $data['all_purpose'] = $this->Student_enquiry_model->get_all_purpose();
        $data['all_enquiryDates'] = $this->Student_enquiry_model->get_all_enquiryDates();
        $data['followup_status'] = $this->Followup_model->get_all_followup_active();
        $data['alluser'] = $this->User_model->get_all_user_forReference();
        $data['title'] = 'All Leads';
        $enquiry_purpose_id =0;
         //Filter form data
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            $enquiry_purpose_id = $this->input->post('enquiry_purpose_id');
            $params['search_text'] = $this->input->post('search_text'); 
            $params['lead_via'] = $this->input->post('lead_via'); 
            $params['active'] = $this->input->post('active'); 
            $params['enquiry_purpose_id'] = $enquiry_purpose_id; 
            $params['option_followup_status'] = $this->input->post('option_followup_status');
            $params['leadCreateddate'] = $this->input->post('leadCreateddate'); 
            $params['nxt_followupdate'] = $this->input->post('nxt_followupdate'); 
            $params['last_followupdate'] = $this->input->post('last_followupdate');
            $params['by_user'] = $this->input->post('by_user');             
              
            $this->load->library('pagination');
            $params['limit'] = RECORDS_PER_PAGE; 
            $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
            $config = $this->config->item('pagination');
            $config['base_url'] = site_url('adminController/student_enquiry/enquiry/'.$enquiry_purpose_id.'?');
            $config['total_rows'] = $this->Followup_model->get_all_leads_count($enquiry_purpose_id,$params);
             $data['total_rows'] =  $this->Followup_model->get_all_leads_count($enquiry_purpose_id,$params);
           // print_r($config['total_rows']);
            $this->pagination->initialize($config);        
            $data['allleads'] = $this->Followup_model->get_all_leads($enquiry_purpose_id,$params);  

        }
        else 
        {
            $this->load->library('pagination');
            $params['limit'] = RECORDS_PER_PAGE; 
            $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
            $config = $this->config->item('pagination');
            $config['base_url'] = site_url('adminController/lead_management/all_Leads/'.$enquiry_purpose_id.'?');
            $config['total_rows'] = $this->Followup_model->get_all_leads_count($enquiry_purpose_id);
           // print_r($config['total_rows']);
            $data['total_rows'] = $this->Followup_model->get_all_leads_count($enquiry_purpose_id);
            $this->pagination->initialize($config);        
            $data['allleads'] = $this->Followup_model->get_all_leads($enquiry_purpose_id,$params);
        }        
      
        $data['_view'] = 'followup_master/leads'; 
        $this->load->view('layouts/main',$data);

    }
    /*---ends-----*/
    /*-----get lead status-------- */
    function get_lead_detail_()
    {
         //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}

       $lead_id= $this->input->post('lead_id');
       $data=$this->Followup_model->getLeadStatusById($lead_id);
         print_r($data['active']);
    }
    /*---ends-----*/

    /*-----update lead status-------- */
    function ajax_update_followup()
    {

        $datad="";
        $lead_id= $this->input->post('lead_id');
        $lead_status= $this->input->post('lead_status');
        $followup_status= $this->input->post('followup_status');
        $followup_remark= $this->input->post('followup_remark');
        $next_followupdatetime= $this->input->post('next_followupdatetime');
        $params_lead = array(
        'active' => $this->input->post('lead_status'),                
        ); 



        $data=$this->Followup_model->update_leads($lead_id,$params_lead);
        if($this->input->post('followup_status') !="" OR  $this->input->post('followup_remark') !="" OR $this->input->post('next_followupdatetime') )
        {
            $lastfollowupdate=date('Y-m-d H:i:s');
            $next_followupdatetime="";
            if($this->input->post('next_followupdatetime') !="")
            {
                 $next_followupdatetime=date_create($this->input->post('next_followupdatetime'));
                 $next_followupdatetime=date_format($next_followupdatetime,"Y-m-d H:i:s");
            }
           
            if($this->input->post('followup_status') =="")
            {
                 $followupdata=$this->Followup_model->getLastFollowupDetail($lead_id);
                 $lastfollowupdate=$followupdata['last_followupdatetime'];
            }

            $paramss = array(
            'flag' => 0,               
            ); 
            $this->Followup_model->update_followupleads($this->input->post('lead_id'),$paramss); 
            $by_user=$_SESSION['UserId'];
            
            $params = array(
            'lead_id' => $this->input->post('lead_id'), 
            'followup_status' => $this->input->post('followup_status'),
            'last_followupdatetime' => $lastfollowupdate, 
            'next_followupdatetime' => $next_followupdatetime, 
            'followup_remark' => $this->input->post('followup_remark'), 
            'flag' => 1,
             'by_user' => $by_user,               
            ); 
            echo $datad=$this->Followup_model->followup_create($params); 
            $leadNo=$this->Followup_model->get_leadNo_Byid($this->input->post('lead_id')); 
            //activity update start              
            $activity_name= "Lead Followup Update for lead (".$leadNo['lead_uid'].')';
            $description= ''.json_encode($params).'';
            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
            //activity update end  

        }
        if($datad =="")
        {
           echo $data;

        }
           

    }

    /*---view followup w.r.t lead---*/
    function view_followup_()
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}      
        $lead_id= $this->input->post('lead_id');
        $data['viewfollowup']=$this->Followup_model->view_followup($lead_id);       
        $this->load->view('followup_master/ajax_view_followup.php',$data);   

    }
    /*---ends*/

    /*---Add new lead (manual lead)*/

    function add_new_lead()
    {    
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        $pack_cb = null;
        //access control ends

        $data['title'] = 'Add new lead';
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('fname','First name','required');
        if($this->form_validation->run())
        {   

           if($this->input->post('division_id')== 1)// academic division
           {            
            $count=$this->Student_model->checkStudentExistenceBoth($this->input->post('mobile'),$this->input->post('email'));                     
            if(count($count) > 0)
            {   
                $DUP_LEAD_MSG= '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Failed:</strong> Student Already Found.<a href="#" class="alert-link"></a>.
                 </div>';       
                $this->session->set_flashdata('flsh_msg', $DUP_LEAD_MSG);
                redirect('adminController/lead_management/add_new_lead');
            }
            else {
                $maxid = $this->Student_model->getMax_UID();
			    $UID = $this->_calculateUID($maxid);
                $service_id =10;// for enquriy
                if(isset($test_module_id)and isset($programe_id) and isset($center_id)){
                    $response = $this->_calculateStatus($service_id,$center_id,$test_module_id,$programe_id,$pack_cb);
                    $student_identity = $response['student_identity'];
                    $details = $response['details'];
                }else{
                     $student_identity = 'WA13-'.ONLINE_BRANCH_ID.'-0';
                }
                if(ENVIRONMENT!='production'){
                    $plain_pwd = PLAIN_PWD;  
                }else{
                    $plain_pwd = $this->_getorderTokens(PWD_LEN);
                } 
               $p=explode("|",$this->input->post('country_code'));
               $countryData =$this->Country_model->get_country_id($p[0]);
               $country_id = $countryData['country_id'];
                $std_params = array( 
                    'UID'   => $UID,
                    'student_identity' => $student_identity, 
                    'fresh'=>1,
                    'service_id' => $service_id,                             
                    'fname' => ucfirst($this->input->post('fname')), 
                    'lname' => ucfirst($this->input->post('lname')),                                 
                    'country_code' =>$p[0],
                    'country_iso3_code' => $p[1],
                    'mobile'=>$this->input->post('mobile'),                    
                    'email' =>$this->input->post('email'),
                    'username' => $this->input->post('email'), 
                    'country_id' => $country_id,             
                    'active' => 0,                
                    'is_otp_verified'=>0,
                    'is_email_verified'=>0,
                    'today' =>date('d-m-Y'), 
                    'loggedIn'=>1,
                    'password' => md5($plain_pwd),
                    'center_id'=>ONLINE_BRANCH_ID,
                    'all_center_id'=>ONLINE_BRANCH_ID,
                    'plain_pwd'=>$plain_pwd,
                );
                
                $last_id = $this->Student_model->add_student($std_params);
                if($last_id)
                {
                    $enquiry_no=$this->_getorderTokens(12);    
                    $params=array(                         
                    'enquiry_purpose_id' =>$this->input->post('enquiry_purpose_id'),            
                    'student_id' => $last_id,            
                    'message' =>$this->input->post('message'),            
                    'todayDate' =>date('d-m-Y'),            
                    'enquiry_no' =>$enquiry_no,            
                    ); 
                    $enquiry_id = $this->Student_enquiry_model->add_enquiry($params); 
                    if($enquiry_id)
                    {
                        $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                        redirect('adminController/lead_management/add_new_lead');
                    }
                    else {
                    $DUP_LEAD_MSG= '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Failed:</strong>Error. Try Again.<a href="#" class="alert-link"></a>.
                    </div>';       
                    $this->session->set_flashdata('flsh_msg', $DUP_LEAD_MSG);
                    redirect('adminController/lead_management/add_new_lead');
                    }
                }
                else {
                    $DUP_LEAD_MSG= '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Failed:</strong>Error. Try Again.<a href="#" class="alert-link"></a>.
                    </div>';       
                    $this->session->set_flashdata('flsh_msg', $DUP_LEAD_MSG);
                    redirect('adminController/lead_management/add_new_lead');
                }
                //$this->session->set_flashdata('flsh_msg', DUP_LEAD_MSG);
               // redirect('adminController/lead_management/add_new_enquiry');
            }
           }
           else {
            $by_user=$_SESSION['UserId'];
            $today = date('d-m-Y');
            $params=array(
            'todayDate'=>$today,
            'fname' => $this->input->post('fname'),
            'lname' => $this->input->post('lname'),
            'email'    => $this->input->post('email'),
            'country_code' => $this->input->post('country_code'),
            'mobile' => $this->input->post('mobile'),             
            'enquiry_purpose_id' => $this->input->post('enquiry_purpose_id'),
            'message' => $this->input->post('message'),
            'active'=> 1,
            'lead_via'=>'manual',
             'by_user' => $by_user,
            /*'OTP'=> $otp,
            'is_otp_verified'=>0,*/
        );  

        $count=$this->Followup_model->check_mobileInLead($params['mobile']);
        if($count == 0)// no lead found then insert it
        {
            $old_booking_no= $this->Followup_model->get_last_leadNo();              
            if($old_booking_no !="")
            {
            $p=explode('N',$old_booking_no);
            //echo $p[1];
            $new_book_no= ++$p[1];
            }
            else 
            {
            $new_book_no= "1111";
            }  
            $order_id="CAN".$new_book_no; 
            $params = array_merge($params, array("lead_uid"=>$order_id));
            $this->Followup_model->insert_lead($params);

            // $subject = 'Hi! your enquiry sent successfully';
            // $email_message = 'Hi! your enquiry sent successfully at our Enquiry team. We will get back to soon.';
            $email_content = enquiry_email();
            $subject = $email_content['subject'];  
            $email_message = $email_content['content']; 
            $mailData['fname']          = $params['fname'];                
            $mailData['email']          = $params['email'];
            $mailData['email_message']  = $email_message;
            $mailData['thanks']         = THANKS;
            $mailData['team']           = WOSA;
                
            $message1='Thank you for getting in touch with us, we will contact you regarding your query shortly.Regards Western Overseas';
            $message2 ='Hi, we would like to thank you for choosing Western Overseas. Kindly share your feedback <https://western-overseas.com/awosa-admin/> Regards Western Overseas';
            if(base_url()!=BASEURL){ 
               // $this->_call_smaGateway($params['mobile'],$message1);
               // $this->_call_smaGateway($params['mobile'],$message2);
            }
            if(base_url()!=BASEURL){
                $this->sendEmail_enquiry_($subject,$mailData);
            }       
        
            $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
            redirect('adminController/lead_management/all_Leads');
        }
        else
        {
             $this->session->set_flashdata('flsh_msg', DUP_LEAD_MSG);
             redirect('adminController/lead_management/add_new_lead');
        }
           }
    }
    else
    {   
        $data['all_division'] = $this->Division_master_model->get_all_division_active();       
        $data['all_country_code'] = $this->Country_model->get_all_country_active();        
        $data['all_purpose'] = $this->Enquiry_purpose_model->get_all_enquiry_purpose_active();
        $data['_view'] = 'followup_master/add_new_enquiry';
        $this->load->view('layouts/main',$data);
    }

}
    /*----ends-----*/

    /*---edit manual enter lead---*/
 function edit_lead_($id)
    {   

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Edit lead';
        $data['leads_dt'] = $this->Student_enquiry_model->get_enquirydatabyid($id);

        $this->load->library('form_validation');        
        $this->form_validation->set_rules('fname','First name','required');
        if($this->form_validation->run())
        {   
            $by_user=$_SESSION['UserId'];
            $today = date('d-m-Y');
            $params=array(
            'todayDate'=>$today,
            'fname' => $this->input->post('fname'),
            'lname' => $this->input->post('lname'),
            'email'    => $this->input->post('email'),
            'country_code' => $this->input->post('country_code'),
            'mobile' => $this->input->post('mobile'),             
            'enquiry_purpose_id' => $this->input->post('enquiry_purpose_id'),
            'message' => $this->input->post('message'),
            'active'=> 1,
            //'lead_via'=>'manual'
            /*'OTP'=> $otp,
            'is_otp_verified'=>0,*/
        );
        if($this->input->post('mobile') == $data['leads_dt']['mobile'])  
        {
            $this->Followup_model->update_leads($id,$params);    
             //activity update start                            
             $activity_name= "Update Lead";
             unset($data['leads_dt']['lead_id'],$data['leads_dt']['lead_uid'],$data['leads_dt']['created'],$data['leads_dt']['modified'],$data['leads_dt']['lead_via']);//unset extras from array               
                       
             $uaID = 'update_lead'.$id;
             $diff1 =  json_encode(array_diff($data['leads_dt'], $params));//old
             $diff2 =  json_encode(array_diff($params,$data['leads_dt']));//new
             
             $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
             $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
             if($diff1!=$diff2){
                 $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
             }                                        
             //activity update end
            
            $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
            redirect('adminController/lead_management/all_Leads');

        }
        else
        {

            $count=$this->Followup_model->check_mobileInLead($params['mobile']);
            if($count == 0)// no lead found then insert it
            {
            $this->Followup_model->update_leads($id,$params);  
            //activity update start                            
            $activity_name= "Update Lead";
            unset($data['leads_dt']['lead_id'],$data['leads_dt']['lead_uid'],$data['leads_dt']['created'],$data['leads_dt']['modified']);//unset extras from array               
                      
            $uaID = 'update_lead'.$id;
            $diff1 =  json_encode(array_diff($data['leads_dt'], $params));//old
            $diff2 =  json_encode(array_diff($params,$data['leads_dt']));//new
            
            $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
            $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
            if($diff1!=$diff2){
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
            }                                        
            //activity update end     
            $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
            redirect('adminController/lead_management/all_Leads');
            }
            else
            {
            $this->session->set_flashdata('flsh_msg', DUP_LEAD_MSG);
            redirect('adminController/lead_management/edit_lead_/'.$id);
            }

        }        
       
  
    }
    else
    {  
       
        $data['all_country_code'] = $this->Country_model->get_all_country_active();        
        $data['all_purpose'] = $this->Enquiry_purpose_model->get_all_enquiry_purpose_active();
        $data['_view'] = 'followup_master/edit_new_enquiry';
        $this->load->view('layouts/main',$data);
    }
 
        

   } 

   /*---ends----*/
   
   function ajax_get_enqpurpose()
   {

    $division_id=$this->input->post('division_id');
    $data= $this->Enquiry_purpose_model->get_all_enquiry_purpose_by_division($division_id);
    
    $catOption = '<option value="">Select Purpose</option>';
   foreach ($data as $p) {

        $catOption .= '<option value=' . $p['id'] . '>' . $p['enquiry_purpose_name'].'</option>';
    } 
    echo $catOption;
   }

}