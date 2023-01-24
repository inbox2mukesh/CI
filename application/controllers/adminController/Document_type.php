<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Document_type extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Document_type_model');       
    }

    function ajax_check_doc_type_duplicacy(){

        $document_type_name = $this->input->post('document_type_name'); 
        $document_type_id = $this->input->post('document_type_id');  
        if($document_type_id and $document_type_name) {
            echo $response= $this->Document_type_model->check_doc_type_duplicacy2($document_type_name,$document_type_id);
        }else{
            echo $response=$this->Document_type_model->check_doc_type_duplicacy($document_type_name); 
        }
    }
    
    function index()
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
        $config['base_url'] = site_url('adminController/document_type/index?');
        $config['total_rows'] = $this->Document_type_model->get_all_document_type_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Document Type';
        $data['document_type'] = $this->Document_type_model->get_all_document_type($params);
        $data['_view'] = 'document_type/index';
        $this->load->view('layouts/main',$data);
    }
    
    function add()
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $data['title'] = 'Add Document Type';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('document_type_name','document_type','required|trim|is_unique[document_type_masters.document_type_name]');
        $this->form_validation->set_rules('have_expiry_date','Have expiry date','trim|required');		
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'document_type_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('document_type_name')))),
                'have_expiry_date' => $this->input->post('have_expiry_date'),
                'by_user' => $by_user,
            );            
            $idd = $this->Document_type_model->add_document_type($params);
            if($idd==1){
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                if($this->Role_model->_has_access_('document_type','index')){
                    redirect('adminController/document_type/index');
                }else{
                    redirect('adminController/document_type/add');
                }
                
            }elseif($idd==2){
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/document_type/add');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/document_type/add');
            }            
        }
        else
        {      
            $data['_view'] = 'document_type/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    
    function edit($id){  

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $data['title'] = 'Edit Document Type';
        $data['document_type'] = $this->Document_type_model->get_document_type($id);
        if(isset($data['document_type']['id']))
        {
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('document_type_name','document_type name','required|trim');
            $this->form_validation->set_rules('have_expiry_date','Have expiry date','trim|required');
			if($this->form_validation->run())
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(
					'active' => $this->input->post('active') ? $this->input->post('active') : 0,
					'document_type_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('document_type_name')))),
                    'have_expiry_date' => $this->input->post('have_expiry_date'),
                    'by_user' => $by_user,
                );
                $idd = $this->Document_type_model->update_document_type($id,$params,$data['document_type']['document_type_name']);
                if($idd==1){
                    //activity update start              
                        $activity_name= DOCUMENT_MASTER_UPDATED;
                        unset($data['document_type']['id'],$data['document_type']['created'],$data['document_type']['modified']);//unset extras from array
                        $uaID = 'document_type'.$id;
                        $diff1 =  json_encode(array_diff($data['document_type'], $params));//old
                        $diff2 =  json_encode(array_diff($params,$data['document_type']));//new
                        $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                        $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                        if($diff1!=$diff2){
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        }                        
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/document_type/index');
                }elseif($idd==2){
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);
                    redirect('adminController/document_type/edit/'.$id);
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/document_type/edit/'.$id);
                }
            }
            else
            {                
                $data['_view'] = 'document_type/edit';
                $this->load->view('layouts/main',$data);                
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
    
    
    /*function remove($id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $document_type = $this->Document_type_model->get_document_type($id);
        if(isset($document_type['id']))
        {
            $this->Document_type_model->delete_document_type($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/document_type/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/   
    
}
