<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Package_transaction extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}        
        $this->load->model('Student_model');
        $this->load->model('Test_module_model');
        $this->load->model('Programe_master_model');
        $this->load->model('Package_master_model');
        $this->load->model('User_model');
    } 
    
    function index($test_module_id=0)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        $UserFunctionalBranch = $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }
        $data['all_testModule'] = $this->Package_master_model->get_all_testModule_tran();
        $data['title'] = 'Transaction';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/package_transaction/index/'.$test_module_id.'?');
        $config['total_rows'] = $this->Package_master_model->get_all_transaction_count($_SESSION['roleName'],$userBranch,$test_module_id);
        $this->pagination->initialize($config);        
        $data['transaction'] = $this->Package_master_model->get_all_package_history_admin($_SESSION['roleName'],$userBranch,$params,$test_module_id);
       
        $data['_view'] = 'package_transaction/index';
        $this->load->view('layouts/main',$data);
    }   

    function all_package_payment()
    {
        //access control start
        $cn = $this->router->fetch_class() . '' . '.php';
        $mn = $this->router->fetch_method();
        if (!$this->_has_access($cn, $mn)) {
            redirect('adminController/error_cl/index');
        } 
        $data['title'] = 'All Package Payment';
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            $params['payment_status']=$this->input->post('payment_status');
            $params['payment_date']=$this->input->post('payment_date');
            $this->load->library('pagination');
            $params['limit'] = RECORDS_PER_PAGE; 
            $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
            $config = $this->config->item('pagination');
            $config['base_url'] = site_url('adminController/package_transaction/all_package_payment/?');  
            $this->pagination->initialize($config);            
            $config['total_rows'] = $this->Package_master_model->get_all_package_payment_count($params);           
            $data['transaction'] = $this->Package_master_model->get_all_package_payment($params);
        }
        else {
            $this->load->library('pagination');
            $params['limit'] = RECORDS_PER_PAGE; 
            $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
            $config = $this->config->item('pagination');
            $config['base_url'] = site_url('adminController/package_transaction/all_package_payment/?');  
            $this->pagination->initialize($config); 
            $config['total_rows'] = $this->Package_master_model->get_all_package_payment_count($params);  
            $data['transaction'] = $this->Package_master_model->get_all_package_payment();
        }        
        $data['package_payment_status'] = $this->Package_master_model->get_package_payment_status();            
        $data['_view'] = 'package_transaction/view_all_package_payment';
        $this->load->view('layouts/main', $data);
    }

    function success_package_payment()
    {
        //access control start
        $cn = $this->router->fetch_class() . '' . '.php';
        $mn = $this->router->fetch_method();
        if (!$this->_has_access($cn, $mn)) {
            redirect('adminController/error_cl/index');
        }
        
        //access control ends      
        $data['title'] = 'Success Package Payment';
        $data['transaction'] = $this->Package_master_model->get_success_package_payment();      
        $data['_view'] = 'package_transaction/view_success_package_payment';
        $this->load->view('layouts/main', $data);


    }

    function failed_fourmodule_data()
    {
        //access control start
        $cn = $this->router->fetch_class() . '' . '.php';
        $mn = $this->router->fetch_method();
        if (!$this->_has_access($cn, $mn)) {
            redirect('adminController/error_cl/index');
        }        
        //access control ends  
        $data['title'] = 'Failed Fourmodule Data';
        $data['transaction'] = $this->Package_master_model->get_failed_fourmodule_data();
        $data['_view'] = 'package_transaction/failed_fourmodule_data';
        $this->load->view('layouts/main', $data);
    }

    function update_fourmodulestatus()
    {
         //access control start
        $cn = $this->router->fetch_class() . '' . '.php';
        $mn = $this->router->fetch_method();
        if (!$this->_has_access($cn, $mn)) {
        redirect('adminController/error_cl/index');
        }        
        //access control ends  
        $headers_fourmodule = array(
            'Authorization:'.FOURMODULE_KEY,                                      
            );
        $spid=$this->input->post('id');
        $params_fourmodule=json_decode($this->input->post('jsondata'));

        $response_fourmodule=$this->_curPostData_fourmodules(FOURMODULE_URL, $headers_fourmodule, $params_fourmodule);
       
        $response_fourmodule_p=json_decode($response_fourmodule);
        $response_fourmodule_success_status=$response_fourmodule_p->success;
        $params_fourmodule = array(       
            "fourmodule_status"=>$response_fourmodule_success_status,                 
            "fourmodule_response"=>$response_fourmodule,                
            );
       
         $this->Student_model->updateFourmoduleStatus($spid,$params_fourmodule);  
       /*  $params=array(
        'fourmodule_staus'=>1,
        'fourmodule_response' =>'Manually Updated',
        );
        $data['transaction'] = $this->Package_master_model->get_failed_fourmodule_data(); */ 
    }
    function get_CSV()
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $data['title'] = 'Failed Fourmodule Data' ;         
        $this->load->library("excel");
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);
        $table_columns = array("Student Name", "Mobile No.", "Email", "Package Detail", 'Fourmodule API Call',"Fourmodule API Status ","Fourmodule API Response");
        $column = 0;
        foreach($table_columns as $field)
        {
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
        }
           
        $data['get_lead_CSV'] = $this->Package_master_model->get_failed_fourmodule_data();
          $excel_row = 2;
          foreach($data['get_lead_CSV'] as $row)
          {
            $date_st=date_create($row['subscribed_on']);
            $date_st=date_format($date_st,"d-m-Y");
            $date_end=date_create($row['expired_on']);
            $date_end=date_format($date_end,"d-m-Y");
            $pp=$row['package_name'].' - '.$row['test_module_name'].' - '.$row['programe_name'].' - '.$row['package_duration'].' - '.$row['batch_name'].' - Start: '.$date_st.' - Expired: '.$date_end;
            if($row['fourmodule_api_called'] == 1){ 
                $ap_called="Enrollment API";
             } else if($row['fourmodule_api_called'] == 2){
                $ap_called= "Re-Enrollment API";
            } else { 
                $ap_called="Add-program API";
            }                        
           $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['fname'].' '.$row['lname'].'('.$row['UID'].')');
           $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['country_code'].'-'.$row['mobile']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['email']);      
           $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $pp);      
           $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $ap_called);      
           $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['fourmodule_status']);      
           $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['fourmodule_response']);     
           $excel_row++;
          }
          $fileVame='Failed-Fourmodule-Data'.'.xls';
          $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename='.$fileVame);
          $object_writer->save('php://output');
    }

    function success_fourmodule_data()
    {
        //access control start
        $cn = $this->router->fetch_class() . '' . '.php';
        $mn = $this->router->fetch_method();
        if (!$this->_has_access($cn, $mn)) {
            redirect('adminController/error_cl/index');
        }        
        //access control ends  
        $data['title'] = 'Success Fourmodule Data';
        $data['transaction'] = $this->Package_master_model->get_success_fourmodule_data();
        $data['_view'] = 'package_transaction/success_fourmodule_data';
        $this->load->view('layouts/main', $data);
    }
    function alltransationsbreakdown($pageno=1)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}        
        //access control ends        
        $data['title'] = 'Transaction Break Down';
        $this->load->library('pagination');
        $config = $this->config->item('pagination');
        $config['per_page'] = RECORDS_PER_PAGE;
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['search'] = [];
        if($this->input->post())
        {
            $params['search'] = $this->input->post();
        }  
        $data['userlist'] = $this->Package_master_model->get_distinctusers();
        $data['course'] = $this->Package_master_model->get_distinctcourse();        
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;         
        $config['base_url'] = site_url('adminController/package_transaction/alltransationsbreakdown/');
        $config['total_rows'] = $this->Package_master_model->get_transaction_history_count($params);
        $this->pagination->initialize($config);        
        $data['transaction'] = $this->Package_master_model->get_transaction_history($params);
        $data['page_urls'] = $this->pagination->create_links();
        // pr($data['page_urls'],1);
        $data['_view'] = 'package_transaction/transaction_breakdown';
        $this->load->view('layouts/main',$data);
    }
    function ajax_filtertransaction()
    {
        $params['filtertype'] = $this->input->post('filtertype',true);
        $params['search'] = array('search_text'=>$this->input->post('srchtext'),'paymentdate'=>$this->input->post('srchpaymentdate')) ;
        $this->load->library('pagination');
        $config = $this->config->item('pagination');
        $config['per_page'] = RECORDS_PER_PAGE;
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;         
        $config['base_url'] = site_url('adminController/package_transaction/alltransationsbreakdown/');
        $config['total_rows'] = $this->Package_master_model->get_transaction_history_count($params);
        $this->pagination->initialize($config);        
        $data['transaction'] = $this->Package_master_model->get_transaction_history($params);
        $data['page_urls'] = $this->pagination->create_links();;
        return $this->load->view('package_transaction/transaction_breakdown_ajax',$data);
    }

    
}
