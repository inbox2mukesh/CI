<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Navjeet 
 *
 **/
class Agent extends MY_Controller{
    
    function __construct(){
        
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}        
        $this->load->model('Student_enquiry_model');
        $this->load->model('Country_model');
        $this->load->model('Enquiry_purpose_model');
        $this->load->model('User_model'); 
		$this->load->model('Become_agent_model'); 
    } 
	
	 function index($enquiry_purpose_id=0)
	 {

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}

        $data['title'] = 'Enquiry By Students';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/student_enquiry/enquiry/'.$enquiry_purpose_id.'?');       
        $config['total_rows'] = $this->Become_agent_model->get_all_agent_count();
        $this->pagination->initialize($config);       
        $data['enquiry'] = $this->Become_agent_model->get_all_agent($params);
        $data['_view'] = 'agent/enquiry'; 
        $this->load->view('layouts/main',$data);
    }

    function filter_booking(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $data['title'] = 'Filter Enquiry lead';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('date','Event date','required');
        
        if($this->form_validation->run())     
        {   
            $date = $this->input->post('date');
            $_SESSION['date']=$date;
            $this->load->library('pagination');
            $params['limit'] = RECORDS_PER_PAGE; 
            $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
            $config = $this->config->item('pagination');
            $config['base_url']=site_url('adminController/student_enquiry/filter_booking/'.$date.'?');        
            $config['total_rows']=$this->Student_enquiry_model->get_all_booking_count_byDate($date);
            $this->pagination->initialize($config);
            $data['title'] = 'All lead of '.$date;
            $data['enquiry'] = $this->Student_enquiry_model->get_all_booking_byDate($date,$params);
            $data['_view'] = 'student_enquiry/enquiry';
            $this->load->view('layouts/main',$data);

        }else{
           $data['_view'] = 'student_enquiry/enquiry';
           $this->load->view('layouts/main',$data);
        }
    }

    function get_CSV(){            
        
        $data['title'] = 'Agent CSV Data' ;         
        $this->load->library("excel");
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);
        $params =[];
        $table_columns = array("Name","Email-ID", "Mobile-No", "City", "Country", "Organization Name",'Message','Date');
        $column = 0;
          foreach($table_columns as $field)
          {
           $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
           $column++;
          }
          
        //  $data['get_lead_CSV'] = $this->Student_enquiry_model->get_lead_CSV();
          $data['get_lead_CSV'] = $this->Become_agent_model->get_all_agent($params);
          
          $excel_row = 2;

          foreach($data['get_lead_CSV'] as $row)
          {      
			$date=date_create($row['created']);
			$created = date_format($date,"M d, Y");			
           $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['fname'].' '.$row['lname']);           
           $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['email']);        
           $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['country_code'].'-'.$row['mobile']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['city']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['country']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['org_name']);           
           $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['address']);           
           $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,$created );         
           $excel_row++;
          }
          $fileVame='Agent-CSV-data'.'.xls';
          $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename='.$fileVame);
          $object_writer->save('php://output');
    }

    function get_lead_CSV_date(){ 

        if(isset($_SESSION['date'])){
            $date = $_SESSION['date'];
        }else{
            $date='';
        }       
        
        $data['title'] = 'Lead CSV Data' ;         
        $this->load->library("excel");
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);

        $table_columns = array("Student-Name", "Date", "Email-ID", "Mobile-No", "Message", "Service", "Status");
        $column = 0;
          foreach($table_columns as $field)
          {
           $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
           $column++;
          }
          if(isset($_SESSION['date'])){
            $data['get_lead_CSV_date'] = $this->Student_enquiry_model->get_lead_CSV_date($date);
          }else{
            $data['get_lead_CSV_date'] = $this->Student_enquiry_model->get_lead_CSV();
          }
          
          $excel_row = 2;

          foreach($data['get_lead_CSV_date'] as $row)
          {
            if($row['status']==1){
                $status='Active';
            }else{
                $status='Cancelled';
            }           
           $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['fname'].' '.$row['lname']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['booked_on']);
           
           $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['email']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['country_code'].'-'.$row['mobile']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['message']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['service']);           
           $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $status);
           $excel_row++;
          }
          $fileVame='Lead-CSV-data'.'.xls';
          $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename='.$fileVame);
          $object_writer->save('php://output');
          unset($_SESSION['date']);
    }

    function add_new_enquiry(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $otp = rand(1000,10000); 
        if(base_url()!=BASEURL){ 
            $otp = 1234;
        }
        $data['title'] = 'Add new enquiry';
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('fname','First name','required');
        if($this->form_validation->run())
        {   
            
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
            'OTP'=> $otp,
            'is_otp_verified'=>0,
        );     
        $enquiry_id = $this->Student_enquiry_model->add_enquiry($params);
        if($enquiry_id){

            // $subject = 'Hi! your enquiry sent successfully';
            // $email_message = 'Hi! your enquiry sent successfully at our Enquiry team. We will get back to soon.';
            $enquiry_content = enquiry_email();
            $subject = $enquiry_content['subject'];
            $email_message = $enquiry_content['content'];
            $mailData['fname']          = $params['fname'];                
            $mailData['email']          = $params['email'];
            $mailData['email_message']  = $email_message;
            $mailData['thanks']         = THANKS;
            $mailData['team']           = WOSA;
                
            $message1='Thank you for getting in touch with us, we will contact you regarding your query shortly.Regards Western Overseas';
            $message2 ='Hi, we would like to thank you for choosing Western Overseas. Kindly share your feedback <https://western-overseas.com/awosa-admin/> Regards Western Overseas';
            if(base_url()!=BASEURL){ 
                //$this->_call_smaGateway($params['mobile'],$message1);
                //$this->_call_smaGateway($params['mobile'],$message2);
            }
            if(base_url()!=BASEURL){
                $this->sendEmail_enquiry_($subject,$mailData);
            }       
        
            $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/student_enquiry/enquiry');
        }else{
            $this->session->set_flashdata('flsh_msg', FAILED_MSG);
            redirect('adminController/student_enquiry/add_new_enquiry');
        }   
    }
    else
    {  
       
        $data['all_country_code'] = $this->Country_model->get_all_country_active();        
        $data['all_purpose'] = $this->Enquiry_purpose_model->get_all_enquiry_purpose_active();
        $data['_view'] = 'student_enquiry/add_new_enquiry';
        $this->load->view('layouts/main',$data);
    }

} 


    function enquiry($enquiry_purpose_id=0){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}

        $data['all_purpose'] = $this->Student_enquiry_model->get_all_purpose();
        $data['all_enquiryDates'] = $this->Student_enquiry_model->get_all_enquiryDates();
        $data['title'] = 'Enquiry By Students';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/student_enquiry/enquiry/'.$enquiry_purpose_id.'?');
        $config['total_rows'] = $this->Student_enquiry_model->get_all_enquiry_count($enquiry_purpose_id);
        $this->pagination->initialize($config);        
        $data['enquiry'] = $this->Student_enquiry_model->get_all_enquiry($enquiry_purpose_id,$params);
        $data['_view'] = 'student_enquiry/enquiry'; 
        $this->load->view('layouts/main',$data);
    }

    function filterEnquiryByDate($filterDate){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }

        $data['all_purpose'] = $this->Student_enquiry_model->get_all_purpose();
        $data['all_enquiryDates'] = $this->Student_enquiry_model->get_all_enquiryDates();
        $data['title'] = 'Enquiry By Date';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/student_enquiry/enquiry/'.$filterDate.'?');
        $config['total_rows'] = $this->Student_enquiry_model->get_all_enquiry_count_filterDate($filterDate);
        $this->pagination->initialize($config);        
        $data['enquiry'] = $this->Student_enquiry_model->get_all_enquiry_filterDate($filterDate,$params);
        $data['_view'] = 'student_enquiry/enquiry';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Listing of all enquiry not replied
     */
    function enquiry_not_replied(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }
        
        $data['all_purpose'] = $this->Student_enquiry_model->get_all_purpose();
        $data['all_enquiryDates'] = $this->Student_enquiry_model->get_all_enquiryDates();

        $data['title'] = 'Enquiry By Students';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('student_enquiry/enquiry_not_replied?');
        $config['total_rows'] = $this->Student_enquiry_model->get_all_no_enquiry_count();
        $this->pagination->initialize($config);
        
        $data['enquiry'] = $this->Student_enquiry_model->get_all_enquiry_not_replied($params);
        $data['_view'] = 'student_enquiry/enquiry';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new student
     */
    function reply_to_student_enquiry($enquiry_id)
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Reply to enquiry';
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('admin_reply','Reply','required|trim');
        
        if($this->form_validation->run())     
        {   
            
            $params = array(                
                'enquiry_id' => $enquiry_id,
                'admin_reply' => $this->input->post('admin_reply'),
                'by_user' => $_SESSION['UserId'],
            );
            $id = $this->Student_enquiry_model->add_reply($params);
            if($id){

                $params2= array('isReplied' => 1);
                $this->db->where('enquiry_id',$enquiry_id);
                $this->db->update('students_enquiry',$params2);
                $stdInfo = $this->Student_enquiry_model->get_enquiry($enquiry_id);
                $test_module_name = $stdInfo['test_module_name'];
                $email = $stdInfo['email'];
                $mobile = $stdInfo['mobile'];
                $fname = $stdInfo['fname'];  
                $enquiry_no = $stdInfo['enquiry_no'];
                $admin_reply = $this->input->post('admin_reply');
                $enquiry_content =admin_enquiry_reply_email($enquiry_no,$admin_reply);
                $subject = $enquiry_content['subject'];
                $email_message = $enquiry_content['content']; 
                $email_footer_content = $enquiry_content['email_footer_content'];             
                // $subject='Hi! Your Enquiry response from- Western Overseas Immigration'; 
                // $email_message='Dear '.$fname.':<br/>'.$this->input->post('admin_reply').' ';
                    $mailData=[];                    
                    $mailData['fname']          = $fname;                
                    $mailData['email']          = $email;
                    $mailData['email_message']  = $email_message;
                    $mailData['thanks']         = THANKS;
                    $mailData['team']           = WOSA;
                    if(base_url()!=BASEURL){               
                        $this->sendEmailTostd_enqReply_($subject,$mailData);
                    }
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/student_enquiry/enquiry');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/student_enquiry/reply_to_student_enquiry/'.$enquiry_id);
            }            
        }
        else
        {            
            $data['enquiryData'] =$this->Student_enquiry_model->get_enquiry($enquiry_id);
            $data['preReplies'] = $this->Student_enquiry_model->get_preReplies($enquiry_id);
            $data['_view'] = 'student_enquiry/reply_to_student_enquiry';
            $this->load->view('layouts/main',$data);
        }
    }   
    
    
}
