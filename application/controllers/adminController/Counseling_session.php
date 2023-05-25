<?php
/**
 * @package         WOSA
 * @subpackage      -------
 * @author          Navjeet
 *
 **/
class Counseling_session extends MY_Controller{
	
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}	
         $this->load->model('Counseling_session_model');	
           $this->load->model('Enquiry_purpose_model'); 
    }

    function counselling_booking_list()
    {    	
    	
    	//access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
       
		$this->load->library('pagination');
        $userBranch="";
        $data['title'] = 'All Counselling Session Booking list';
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/counseling_session/counselling_booking_list?');       
        //Filter form data
        if($this->input->server('REQUEST_METHOD') === 'POST')
    	{    
    		$session_type = $this->input->post('session_type');
    		$session_otp = $this->input->post('session_otp');
    		$session_paymentStatus = $this->input->post('session_paymentStatus');
    		$session_date = $this->input->post('session_datew');
			$session_pdate = $this->input->post('session_pdate',true);
			$service_id = $this->input->post('service_id',true);
			$payment_type = $this->input->post('payment_type',true);
			$booking_pdate = $this->input->post('booking_pdate',true);
			//$ser_event_title = $this->input->post('ser_event_title');	
			$config['total_rows'] = $this->Counseling_session_model->get_all_booked_counselling_list_count($_SESSION['roleName'],$userBranch);
			$this->pagination->initialize($config); 
            $data['counselling_booking_list'] = $this->Counseling_session_model->get_all_booked_counselling_list($session_type,$session_paymentStatus,$session_date,$session_pdate,$service_id,$booking_pdate,$payment_type,$params);

    	}
    	else {
    		$session_type="";
    		$session_otp="";
    		$session_paymentStatus="";
    		$session_date="";
    		$session_pdate="";
    		$service_id="";
    		$payment_type="";
    		$booking_pdate="";
			$config['total_rows'] = $this->Counseling_session_model->get_all_booked_counselling_list_count($_SESSION['roleName'],$userBranch);
			$this->pagination->initialize($config); 
    		 $data['counselling_booking_list'] = $this->Counseling_session_model->get_all_booked_counselling_list($session_type,$session_paymentStatus,$session_date,$session_pdate,$service_id,$booking_pdate,$payment_type,$params);
    	}   	
        $data['payment_status'] = $this->Counseling_session_model->get_all_payment_status();
        $data['serviceData'] = $this->Enquiry_purpose_model->get_enquiry_purpose_based_on_session_booking();
        $data['_view'] = 'counseling_session/counselling_booking_list';
        $this->load->view('layouts/main',$data);        
    }
    function counselling_booking_completed_list()
    {
    	//access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}        
        //access control ends       
		$this->load->library('pagination');
        $userBranch="";
        $data['title'] = 'Success Counselling Session Booking list';
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/counseling_session/counselling_booking_completed_list?');
        $config['total_rows'] = $this->Counseling_session_model->get_all_booked_counselling_list_completed_count($_SESSION['roleName'],$userBranch);
        $this->pagination->initialize($config);    

        //Filter form data
        if($this->input->server('REQUEST_METHOD') === 'POST')
    	{
    		$session_type = $this->input->post('session_type');
    		$session_otp = $this->input->post('session_otp');
    		$session_paymentStatus = $this->input->post('session_paymentStatus');
    		$session_date = $this->input->post('session_datew');
			$session_pdate = $this->input->post('session_pdate',true);
			$service_id = $this->input->post('service_id',true);
			$booking_pdate = $this->input->post('booking_pdate',true);
			$payment_type = $this->input->post('payment_type',true);
			//$ser_event_title = $this->input->post('ser_event_title');	
          /*  $data['counselling_booking_list'] = $this->Counseling_session_model->get_all_booked_counselling_list_completed($session_type,$session_otp,$session_paymentStatus,$session_date,$session_pdate,$service_id);*/

             $data['counselling_booking_list'] = $this->Counseling_session_model->get_all_booked_counselling_list_completed($session_type,$session_paymentStatus,$session_date,$session_pdate,$service_id,$booking_pdate,$payment_type,$params);

    	}
    	else {
    		$session_type="";
    		$session_otp="";
    		$session_paymentStatus="";
    		$session_date="";
    		$session_pdate="";
    		$service_id="";
    		$payment_type="";
    		$booking_pdate="";
    		$data['counselling_booking_list'] = $this->Counseling_session_model->get_all_booked_counselling_list_completed($session_type,$session_paymentStatus,$session_date,$session_pdate,$service_id,$booking_pdate,$payment_type,$params);
    	}
       
        $data['payment_status'] = $this->Counseling_session_model->get_all_payment_status();
        $data['serviceData'] = $this->Enquiry_purpose_model->get_enquiry_purpose_based_on_session_booking();
        $data['_view'] = 'counseling_session/counselling_booking_complete_list';
        $this->load->view('layouts/main',$data);
        
    }

    
    function index($action=null)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
		$this->load->model('Counseling_session_model');		
        $this->load->library('pagination');
		
		$current_DateTime = date("d-m-Y G:i:0");
        $current_DateTimeStr = strtotime($current_DateTime);
        //$current_DateTimeStr_after = $current_DateTimeStr + 3600; #1 Hr
		$current_DateTimeStr_after=$current_DateTimeStr;
		$this->Counseling_session_model->deactivate_shedule($current_DateTimeStr_after);		
		$time = strtotime(date("Y-m-d"));
        $lastDate = date("Y-m-d", strtotime("+1 month", $time));
	    $session_date=date('Y-m-d').' - '.$lastDate;	
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
		if($action=='search'){
            $config['base_url'] = site_url('adminController/counseling_session/index/search/?');
		}else{
			 $config['base_url'] = site_url('adminController/counseling_session/index?');
		}
        $config['total_rows'] = $this->Counseling_session_model->get_all_counseling_sessions_group_count($params);
        $this->pagination->initialize($config);
        $data['title'] = 'Counseling Session';
        $data['counseling_session'] = $this->Counseling_session_model->get_all_counseling_session_group($params);		
		
        $data['_view'] = 'counseling_session/index';
        $this->load->view('layouts/main',$data);
		
    }
	
    function add()
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
		
		$this->load->model('Counseling_session_model');
		$this->load->model('Time_slot_model');
					
		$current_DateTime = date("d-m-Y G:i:0");
        $current_DateTimeStr = strtotime($current_DateTime);
        $current_DateTimeStr_after=$current_DateTimeStr;
		// $this->Counseling_session_model->deactivate_shedule($current_DateTimeStr_after);
		
        $data['title'] = 'Add Counseling Session';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('session_title','session title','required|trim');
        if($this->input->post('session_title') == 'online')	
        {
        	$this->form_validation->set_rules('meeting_link','meeting link','required|trim');	
        }
		$this->form_validation->set_rules('session_date','session date','required|trim');	
		$this->form_validation->set_rules('duration','Duration','required|trim');	
		//$this->form_validation->set_rules('paypal_link','paypal link','required|trim');	 
		$this->form_validation->set_rules('counseling_session_time_requerd','select at least one time slot','required|trim');
		if($this->form_validation->run())     
        {   
	        $by_user=$_SESSION['UserId'];
			
			$session_date=$this->input->post('session_date');
			$total_time_slot=$this->input->post('total_time_slot');
			$session_date_array=explode(' - ',$session_date);
			$session_date_from=trim($session_date_array[0]);
			$session_date_to=trim($session_date_array[1]);
			$Diff = strtotime($session_date_to)-strtotime($session_date_from);
            $dayDiff=$Diff/86400;
						
			$add_data=false;
				
			$params = array(
				'active' =>1,
				'session_type' => $this->input->post('session_title'),
				'amount' => $this->input->post('amount'),				
				'by_user' => $by_user,
				'session_from_to_date' => $session_date,
				'zoom_link' => $this->input->post('meeting_link'),
				'duration' => $this->input->post('duration'),
				//'paypal_link' => $this->input->post('paypal_link'),
				'session_date_from'=>$session_date_from,
				'session_date_to'=>$session_date_to,
            );
			
			$counseling_sessions_group_id=$this->Counseling_session_model->_add_counseling_sessions_group($params);
			if(!empty($counseling_sessions_group_id)){
				for($i=0; $i<=$dayDiff; $i++){
					
					$session_date_new=date('Y-m-d', strtotime($session_date_from.' +'.$i.' day'));
					$nameOfDay = date('D', strtotime($session_date_new));
					
					if($total_time_slot > 0){
						
						for($j=1; $j<=$total_time_slot; $j++){
							
							$time_slot=$this->input->post('counseling_session_time_slots'.$j);
							$session_date_time_str=strtotime($session_date_new.' '.$time_slot);
							$session_date_time=date('Y-m-d H:i:0',$session_date_time_str);
							
							$params = array(
							'active' =>1,
							'session_type' => $this->input->post('session_title'),
				            'amount' => $this->input->post('amount'),
							'by_user' => $by_user,
							'session_date' => $session_date_new,
							'zoom_link' => $this->input->post('meeting_link'),
							//'paypal_link' => $this->input->post('paypal_link'),
							'duration' => $this->input->post('duration'),
							'session_date_time'=>$session_date_time,
							'session_date_time_str'=>$session_date_time_str,
							'dayname'=>$nameOfDay,
							'time_slot'=>$time_slot,
							'counseling_sessions_group_id'=>$counseling_sessions_group_id
							);
							$id = $this->Counseling_session_model->add_c_session($params);						
						}
						
					}
				}
				
				$session_end_date_time_str=$this->Counseling_session_model->getMaxSessionDateTimeStrBYSessionGroupID($counseling_sessions_group_id);
				$params=array(
					'session_end_date_time_str' =>$session_end_date_time_str
				);
				$count=$this->Counseling_session_model->get_all_counseling_session_active_count($counseling_sessions_group_id);
			    if($count > 0){
					
					$params['active']=1;
					
				}else{
					
					$params['active']=0;
				}
				
				$this->Counseling_session_model->update_counseling_session_group($counseling_sessions_group_id,$params);				
				
			    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/counseling_session/index');
				
			}else{
				$this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/counseling_session/add');
			}			
        }
        else
        {   
	        $dateBranchTimeSlotList=$this->Counseling_session_model->ChekTimeSlotList();
	     $data['dateBranchTimeSlotList']=$dateBranchTimeSlotList;
			$data['time_slots'] = $this->Time_slot_model->get_all_time_slots();
            $data['_view'] = 'counseling_session/add';
            $this->load->view('layouts/main',$data);
			
        }
    }
	
	function addTimeSlotSingleDate_($counseling_sessions_group_id=null)
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
		
        //access control ends
		
		$this->load->model('Counseling_session_model');
		$this->load->model('Time_slot_model');		
		
		$data['counseling_session_group'] = $this->Counseling_session_model->get_counseling_sessions_group($counseling_sessions_group_id);
		//pr($data['counseling_session_group']);
		
		if(!isset($data['counseling_session_group']['id'])){
			
			redirect('adminController/error_cl/index');
		}
        $data['title'] = 'Add Counseling Session';
        $this->load->library('form_validation');
		echo $this->input->post('session_title');
		
        $this->form_validation->set_rules('session_date','session date','required|trim');
		$this->form_validation->set_rules('session_title','session title','required|trim');
		if($this->input->post('session_title') == 'online')	
        {
        	//$this->form_validation->set_rules('meeting_link','meeting link','required|trim');	
			$this->form_validation->set_rules('zoom_link','meeting link','required|trim');
        }
		
		$this->form_validation->set_rules('amount','amount','required|trim');	
		$this->form_validation->set_rules('counseling_session_time_requerd','select at least one time slot','required|trim');
		if($this->form_validation->run())     
        {   
	        $by_user=$_SESSION['UserId'];
			
			$session_date=$this->input->post('session_date');
			$total_time_slot=$this->input->post('total_time_slot');
			$session_date_array=explode(' - ',$session_date);
			$session_date_from=trim($session_date_array[0]);
			$session_date_to=trim($session_date_array[1]);
			$Diff = strtotime($session_date_to)-strtotime($session_date_from);
            $dayDiff=$Diff/86400;
			$session_type=$data['counseling_session_group']['session_type'];			
			$zoom_link=$this->input->post('zoom_link');
			$paypal_link=$this->input->post('paypal_link');
		    
			
			$add_data=false;
			if(!empty($counseling_sessions_group_id)){
				
				for($i=0; $i<=$dayDiff; $i++){
					
					$session_date_new=date('Y-m-d', strtotime($session_date_from.' +'.$i.' day'));
					$nameOfDay = date('D', strtotime($session_date_new));
					
					if($total_time_slot > 0){
						
						for($j=1; $j<=$total_time_slot; $j++){
							
							$time_slot=$this->input->post('counseling_session_time_slots'.$j);
							$session_date_time_str=strtotime($session_date_new.' '.$time_slot);
							$session_date_time=date('Y-m-d H:i:0',$session_date_time_str);
							
							$params = array(
							'active' =>$this->input->post('active') ? $this->input->post('active') : 0,
							'session_type' =>$session_type,
							'amount' =>$this->input->post('amount'),
							'by_user' => $by_user,
							'session_date' => $session_date_new,
							'zoom_link' => $zoom_link,
							'paypal_link' => $paypal_link,
							'session_date_time'=>$session_date_time,
							'session_date_time_str'=>$session_date_time_str,
							'dayname'=>$nameOfDay,
							'time_slot'=>$time_slot,
							'counseling_sessions_group_id'=>$counseling_sessions_group_id,
							'duration' => $this->input->post('duration'),
							//'session_date_to'=>$session_date_to
							);
							$id = $this->Counseling_session_model->add_c_session($params);
							
							$add_data=true;
							
						}
						
					}
				}
				$session_end_date_time_str=$this->Counseling_session_model->getMaxSessionDateTimeStrBYSessionGroupID($counseling_sessions_group_id);
				$params=array(
					'session_end_date_time_str' =>$session_end_date_time_str
				);
				$count=$this->Counseling_session_model->get_all_counseling_session_active_count($counseling_sessions_group_id);
			    if($count > 0){
					
					$params['active']=1;
					
				}else{
					
					$params['active']=0;
				}
				
				$this->Counseling_session_model->update_counseling_session_group($counseling_sessions_group_id,$params);
				
				if($add_data){
			        $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/counseling_session/view_details_/'.$counseling_sessions_group_id);
				}else{
					
					$this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/counseling_session/addTimeSlotSingleDate_/'.$counseling_sessions_group_id);
				}
				
			}else{
				$this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/counseling_session/addTimeSlotSingleDate_/'.$counseling_sessions_group_id);
			}			
        }
        else
        {   
	       $dateBranchTimeSlotList=$this->Counseling_session_model->ChekTimeSlotList();	  
		$data['dateBranchTimeSlotList']=$dateBranchTimeSlotList;
			$data['time_slots'] = $this->Time_slot_model->get_all_time_slots();
            $data['_view'] = 'counseling_session/add_time_slot_single_date';
            $this->load->view('layouts/main',$data);
			
        }
    }
	
    function edit($id=null)
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
		$this->load->model('Counseling_session_model');
			$this->load->model('Time_slot_model');
        $data['title'] = 'Edit Counseling Session';
        $data['counseling_session'] = $this->Counseling_session_model->get_counseling_session($id);
        if(isset($data['counseling_session']['id']))
        { 
       		$this->load->library('form_validation');
			$this->form_validation->set_rules('session_title','Session title','required|trim');
			$this->form_validation->set_rules('session_date','session date','required|trim');
			$this->form_validation->set_rules('counseling_session_time_slot','time slot','required|trim');	
				
			if($this->input->post('session_title') =="online")
			{
				$this->form_validation->set_rules('zoom_link','zoom link','required|trim');
			}
			
			$this->form_validation->set_rules('duration','Duration','required|trim');	
			//$this->form_validation->set_rules('paypal_link','paypal link','required|trim');
			$this->form_validation->set_rules('amount','amount','required|trim');	
				
			$counseling_sessions_group_id= $data['counseling_session']['counseling_sessions_group_id'];
			
			if($this->form_validation->run())
            {  
				
	
                $by_user=$_SESSION['UserId'];
				$session_date=$this->input->post('session_date');			
			    $session_date=date('Y-m-d',strtotime($session_date));
				$zoom_link='';
			    $session_title=$data['counseling_session']['session_type'];				
			    $zoom_link=$this->input->post('zoom_link');	
			    $paypal_link=$this->input->post('paypal_link');		        
				$time_slot=$this->input->post('counseling_session_time_slot');
				$session_date_time_str=strtotime($session_date.' '.$time_slot);
				$session_date_time=date('Y-m-d H:i:0',$session_date_time_str);
				$nameOfDay = date('D', strtotime($session_date));				
				$params = array(
						'active' => $this->input->post('active') ? $this->input->post('active') : 0,
						'amount' => $this->input->post('amount'),
						'session_type' =>$session_title,
						'by_user' => $by_user,
						'session_date' => $session_date,
						'zoom_link' => $zoom_link,
						//'paypal_link' => $paypal_link,
						'session_date_time'=>$session_date_time,
						'duration'=> $this->input->post('duration'),
						'session_date_time_str'=>$session_date_time_str,
						'dayname'=>$nameOfDay,
						'time_slot'=>$time_slot,
						'counseling_sessions_group_id'=>$counseling_sessions_group_id
                );
				
				$counseling_session_id=$id;
                $id = $this->Counseling_session_model->update_counseling_session($id,$params);
				
                if($id)
                {
					$created=$modified=date('Y-m-d H:i:s');					
					$session_end_date_time_str=$this->Counseling_session_model->getMaxSessionDateTimeStrBYSessionGroupID($counseling_sessions_group_id);
					$params=array(
						'session_end_date_time_str' =>$session_end_date_time_str
					);
					$count=$this->Counseling_session_model->get_all_counseling_session_active_count($counseling_sessions_group_id);
					if($count > 0){
						
						$params['active']=1;
						
					}else{
						
						$params['active']=0;
					}
					$this->Counseling_session_model->update_counseling_session_group($counseling_sessions_group_id,$params);				
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/counseling_session/view_details_/'.$counseling_sessions_group_id);
					
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/counseling_session/edit/'.$id);
                }
            }
            else
            {   
				$dateBranchTimeSlotList=$this->Counseling_session_model->ChekTimeSlotList();
				$data['dateBranchTimeSlotList']=$dateBranchTimeSlotList;
				$data['time_slots'] = $this->Time_slot_model->get_all_time_slots();
				//print_r($data['time_slots'] );
				$data['_view'] = 'counseling_session/edit';
				$this->load->view('layouts/main',$data);
				
            }
        }
        else
           show_error(ITEM_NOT_EXIST);
    }
	function view_details_($id,$action='null'){
		
		//access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
		if(empty($id)){redirect('adminController/error_cl/index');}
		
		$this->load->model('Counseling_session_model');
		
		$current_DateTime = date("d-m-Y G:i:0");
        $current_DateTimeStr = strtotime($current_DateTime);
        //$current_DateTimeStr_after = $current_DateTimeStr + 3600; #1 Hr
		$current_DateTimeStr_after=$current_DateTimeStr;
		// $this->Counseling_session_model->deactivate_shedule($current_DateTimeStr_after);
		
		$data['title'] ='Counseling Session Details';
		$data['counseling_session_group'] = $this->Counseling_session_model->get_counseling_sessions_group($id);
		
		if(!isset($data['counseling_session_group']['id'])){
			
			redirect('adminController/error_cl/index');
		}
		
		$data['time_slots'] = $this->Counseling_session_model->getCounselingSessionsGroupTimeSlotBySessionsGroupId($id);
		
	    
		$session_date=$data['counseling_session_group']['session_from_to_date'];
		
		$counselingSessionSearch=array('counseling_session_course'=>array(),'counseling_session_centers'=>array(),'session_date'=>$session_date,'counseling_session_time_slot'=>'');
		
		/*if($this->input->server('REQUEST_METHOD') === 'POST'){
			
			$action=$this->input->post('action');
			if($action=='search'){
				
				$counselingSessionSearch['counseling_session_course']=isset($_POST['counseling_session_course']) ?  $_POST['counseling_session_course']:array();
				$counselingSessionSearch['counseling_session_centers']=isset($_POST['counseling_session_centers']) ?  $_POST['counseling_session_centers']:array();
				$counselingSessionSearch['session_date']=isset($_POST['session_date']) ?  $_POST['session_date']:'';
				$counselingSessionSearch['counseling_session_time_slot']=isset($_POST['counseling_session_time_slot']) ?  $_POST['counseling_session_time_slot']:'';
				
				
			}
		}else{
			
			if($action=='search'){
				
				$counselingSessionSearch['counseling_session_course']=$_SESSION['counselingSessionViewSearch']['counseling_session_course'];
				$counselingSessionSearch['counseling_session_centers']=$_SESSION['counselingSessionViewSearch']['counseling_session_centers'];
				$counselingSessionSearch['session_date']=$_SESSION['counselingSessionViewSearch']['session_date'];
				$counselingSessionSearch['counseling_session_time_slot']=$_SESSION['counselingSessionViewSearch']['counseling_session_time_slot'];
				 
				if(empty($counselingSessionSearch['session_date'])){
					$counselingSessionSearch['session_date']=$session_date;
				}
			}
			
		}
		$_SESSION['counselingSessionViewSearch']=$counselingSessionSearch;
		$params['counselingSessionSearch']=$counselingSessionSearch;*/
		
		//$data['counseling_session_course_list'] = $this->Counseling_session_model->getCourseByCounselingSessionsGroupId($id);
        //$data['counseling_session_center_list'] = $this->Counseling_session_model->getCenterByCounselingSessionsGroupId($id);
		
		//pr($data['counseling_session_center_list']);
		//pr($data['counseling_session_course_list']);
		
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
		
        $config = $this->config->item('pagination');
		if($action=='search'){
			
			$config['base_url'] = site_url('adminController/counseling_session/view_details_/'.$id.'/search/?');
		}else{
			$config['base_url'] = site_url('adminController/counseling_session/view_details_/'.$id.'?');
		}
        $config['total_rows'] = $this->Counseling_session_model->get_all_counseling_session_count($id,$params);
        $this->pagination->initialize($config);
        $data['counseling_session'] = $this->Counseling_session_model->get_all_counseling_session($id,$params);
		
		/*foreach($data['counseling_session']  as $key=>$counseling_session){
			
	        $counseling_session['counseling_session_course_list']=$this->Counseling_session_model->getCourseByCounselingSessionId($counseling_session['id']);
			
			$counseling_session['counseling_session_center_list']=$this->Counseling_session_model->getCenterByCounselingSessionId($counseling_session['id']);
			$data['counseling_session'][$key]=$counseling_session;
		}*/
		$data['_view'] = 'counseling_session/view';
		$this->load->view('layouts/main',$data);
		
		
	}
	/*function remove_sessions_group($id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();       
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
		$this->load->model('Counseling_session_model');
        $counseling_session = $this->Counseling_session_model->get_counseling_sessions_group($id);
        if(isset($counseling_session['id']))
        {
            $this->Counseling_session_model->delete_counseling_session_group($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/counseling_session/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
	
    function remove($id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();       
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
		$this->load->model('Counseling_session_model');
        $counseling_session = $this->Counseling_session_model->get_counseling_session($id);
		$counseling_sessions_group_id=$counseling_session['counseling_sessions_group_id'];
        if(isset($counseling_session['id']))
        {
            $this->Counseling_session_model->delete_counseling_session($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
			$count=$this->Counseling_session_model->get_all_counseling_session_count($counseling_sessions_group_id);
			if($count > 0){
				
                redirect('adminController/counseling_session/view/'.$counseling_sessions_group_id);
			}else{
				$this->Counseling_session_model->delete_counseling_session_group($counseling_sessions_group_id);
				redirect('adminController/counseling_session/index');
			}
			
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/

	function activate_deactivete_()
    {    
	   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $this->load->model('Counseling_session_model');
        $id = $this->input->post('id', true);
        $active = $this->input->post('active', true);
        $table = $this->input->post('table', true);		
		if($table=='counseling_sessions_group')
		{			
			if($active==1){				
				$params=array(
			        'active' =>1
		        );
				$this->Counseling_session_model->update_counseling_session_group($id,$params);
				$this->db->where('counseling_sessions_group_id',$id);
				$this->db->update('counseling_sessions',$params);				
			}else{				
				$params=array(
			        'active' =>0
		        );
				$this->Counseling_session_model->update_counseling_session_group($id,$params);
				$this->db->where('counseling_sessions_group_id',$id);
				$this->db->update('counseling_sessions',$params);				
			}			
		}else if($table=='counseling_sessions')
		{			
			$counseling_sessions_group_id = $this->input->post('counseling_sessions_group_id', true);
			if($active==1){				
				$params=array(
			        'active' =>1
		        );
				$this->Counseling_session_model->update_counseling_session($id,$params);
			}else{
				$params=array(
			        'active' =>0
		        );
				$this->Counseling_session_model->update_counseling_session($id,$params);
			}
			$count=$this->Counseling_session_model->get_all_counseling_session_active_count($counseling_sessions_group_id);
			$this->Counseling_session_model->update_counseling_session_group($counseling_sessions_group_id,$params);
			if($count > 0){
				
				$params['active']=1;
			}else{
				$params['active']=0;
			}
			$this->Counseling_session_model->update_counseling_session_group($counseling_sessions_group_id,$params);
		}
        echo 1;
		
    }

    function ajax_delete_counseling_session_course(){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

		$this->load->model('Counseling_session_model');
        $counseling_session_id = $this->input->post('counseling_session_id', true);
        $course_id = $this->input->post('course_id', true);
        if($course_id!=''){
			
            $del = $this->Counseling_session_model->delete_counseling_session_course($counseling_session_id,$course_id);
            if($del){  
                header('Content-Type: application/json');
                $response = 1;
                echo json_encode($response);
            }else{ 
                header('Content-Type: application/json');
                $response = 0;
                echo json_encode($response);
            }
        }else{
            header('Content-Type: application/json');
            $response = 0;
            echo json_encode($response);
        }         
    }

	function ajax_delete_counseling_session_center(){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

		$this->load->model('Counseling_session_model');
        $counseling_session_id = $this->input->post('counseling_session_id', true);
        $center_id = $this->input->post('center_id', true);
		
        if($center_id!=''){
			
            $del = $this->Counseling_session_model->delete_counseling_session_centers($counseling_session_id,$center_id);
            if($del){  
                header('Content-Type: application/json');
                $response = 1;
                echo json_encode($response);
            }else{  
                header('Content-Type: application/json');
                $response = 0;
                echo json_encode($response);
            } 

        }else{
            header('Content-Type: application/json');
            $response = 0;
            echo json_encode($response);
        }         
    }

    function add_session_status_()
    {
	 	$id = $this->input->post('session_booking_id', true);
	     $params=array(
    		'remark' => $this->input->post('session_booking_remarks', true),
    		'attended' => $this->input->post('is_attended', true)        
    	);
		$t=$this->Counseling_session_model->update_student_session($id,$params);		
		if($t)
		{echo 1;}
		else {echo 0;}
    }
    function get_counselinglead_CSV($session_type=NULL,$booking_pdate=NULL,$session_datew=NULL,$service_id=NULL,$session_pdate=NULL,$payment_type=NULL)
	{
        $data['title'] = 'Lead CSV Data' ;         
        $this->load->library("excel");
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);
       $table_columns = array("Student", "Mobile", "Email-ID", "Session type", "Service", "Booking DateTime", "Session DateTime","Message","Payment Date","Payment Type","Payment Status","Txn id","Remark",'Has-attended?');
        $column = 0;
          foreach($table_columns as $field)
          {
           $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
           $column++;
          }
          if(($session_type !=0 || $session_type !='' ) || ($booking_pdate !=0 || $booking_pdate !='' ) || ($session_datew !=0 || $session_datew !='') || ($service_id !=0 || $service_id !='') || ($session_pdate!=0 || $session_pdate!='' ) || ($payment_type !=0 || $payment_type !=''))
    	 	{    		
				if($booking_pdate !=0)
				{
					$booking_pdate=str_replace("%20"," ",$booking_pdate);
				}
				if($session_datew !=0)
				{
					$session_datew=str_replace("%20"," ",$session_datew);
				}
				if($session_pdate !=0)
				{
					$session_pdate=str_replace("%20"," ",$session_pdate);
				}			
				$data['get_lead_CSV'] = $this->Counseling_session_model->get_all_booked_counselling_list_completed_csv($session_type,$booking_pdate,$session_datew,$service_id,$session_pdate,$payment_type);
			}
			else {				
				$data['get_lead_CSV']= $this->Counseling_session_model->get_all_booked_counselling_list_completed_csv();
			}
          $excel_row = 2;
          foreach($data['get_lead_CSV'] as $row)
          {
            
			$tt= date_create($row['created']); 
			$dt= date_format($tt,'d-m-Y');     
			if($row['payment_date'] == "")
			{
			$p_date="N/A";
			} else 
			{
			$p=str_replace("T"," ",$row['payment_date']);
			$p_date= str_replace("Z","",$p); 
			}
			if($row['attended'] == 0)
			{
			$attended="No";
			}
			else {
			$attended="Yes";
			}
			if($row['txn_id'] == "")
			{
			$txn_id="N/A";
			}
			else {
			$txn_id=$row['txn_id'];
			}
			
	$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['fname']);
	$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['country_code'].'-'.$row['mobile']);
	$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['email']);
	$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['session_type'].'-'.$row['mobile']);
	$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['service_name']);
	$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $tt);           
	$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['booking_date'].' '.$row['booking_time_slot']);
	$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['message']);
	$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $p_date);
	$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row['payment_type']);
	$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row['payment_status']);
	
	$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $txn_id);
	$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row['remark']);
	$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $attended);
           $excel_row++;
          }
          //print_r($object);
          //die();
          $fileVame='Session-Booking-Lead-CSV-data'.'.xls';
          $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename='.$fileVame);
          $object_writer->save('php://output');
    }



    function general()
    {
    	//access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $params =[];
        //access control ends
        $data['title'] = 'Counseling Session general info';
        $data['generalInfo'] = $this->Counseling_session_model->get_general_info($params);	
        $data['_view'] = 'counseling_session/general_index';
        $this->load->view('layouts/main',$data);
    }

    function general_edit($id)
    {    	   	
    	//access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        $data['title'] = 'Counseling Session general info';
        $data['generalInfo'] = $this->Counseling_session_model->get_general_info_byid($id);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('description','description','required|trim');	
		if($this->form_validation->run())     
		{ 
			$params = array(                
			'description' => $this->input->post('description'),
		);
		$id = $this->Counseling_session_model->update_general_info_byid($id,$params);
		if($id){
		$this->session->set_flashdata('flsh_msg', UPDATE_MSG);
		redirect('adminController/counseling_session/general');
		}else{
		$this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
		redirect('adminController/counseling_session/general_edit/'.$id);
		}                
		}
		else
		{ 
		$data['_view'] = 'counseling_session/general_edit';
		$this->load->view('layouts/main',$data);
		}     
    }
     function update_session_status_()
    {
    	$booking_id= $this->input->post('session_booking_id');



    

      $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );
       
        //$responseq=json_encode($_POST);
        $params=array(
        'payment_status' => "completed",
        'custom'=>$booking_id,
        'payment_type' => "email",

        ); 

        $response= json_decode($this->_curPostData(base_url(UPDATE_SESSION_URL), $headers, $params));

             //$this->Counseling_session_model->update_student_session($booking_id,$params);
    }
}
