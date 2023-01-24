<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class Time_slot_master extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Time_slot_model');       
    }

    function ajax_check_timeslot_duplicacy(){

        $time_slot = $this->input->post('time_slot'); 
        $time_slot_id = $this->input->post('time_slot_id'); 
        $type = $this->input->post('type'); 

        if($time_slot_id and $time_slot) {
            echo $response= $this->Time_slot_model->check_timeslot_duplicacy2($time_slot,$time_slot_id,$type);
        }else{
            echo $response=$this->Time_slot_model->check_timeslot_duplicacy($time_slot,$type); 
        }
    }

    function ajax_loadTimeSlot(){

        $count = $this->input->post('count');
        $slotData = $this->Time_slot_model->get_all_time_slots();
        for($i=1;$i<=$count;$i++){

            $x = '<div class="col-md-4">
                    <label for="time_slot'.$i.'" class="control-label">Time Slot '.$i.' </label>
                    <div class="form-group">
                        <select name="time_slot'.$i.'" id="time_slot'.$i.'" class="form-control selectpicker Select2" data-show-subtext="true" data-live-search="true">
                            <option value="">Time Slot '.$i.'</option>';

            foreach($slotData as $b){

                $t = $b['time_slot'].' '.$b['type'];            
                $y .= 'echo "<option value="'.$t.'">'.$t.'</option>";';
            }

            $z = '</select>
                        <span class="text-danger"><?php echo form_error("time_slot'.$i.'");?></span>
                    </div>
                </div>';
            $res.= $x.$y.$z;    
        }        
        echo $res;        
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
        $config['base_url'] = site_url('adminController/time_slot_master/index?');
        $config['total_rows'] = $this->Time_slot_model->get_all_time_slots_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Time slots';
        $data['time_slot_master'] = $this->Time_slot_model->get_all_time_slotss($params);
        $data['_view'] = 'time_slot_master/index';
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
        $data['title'] = 'Add Time slot';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('time_slot','Time slot','required|trim|min_length[5]|max_length[5]');
        $this->form_validation->set_rules('type','Time slot type','required');		
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				'time_slot' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('time_slot')))),
                'type' => $this->input->post('type'),
                'by_user' => $by_user,
            );            
            $id = $this->Time_slot_model->add_time_slot($params);
            if($id){
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                if($this->Role_model->_has_access_('time_slot_master','index')){
                    redirect('adminController/time_slot_master/index');
                }else{
                    redirect('adminController/time_slot_master/add');
                }
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/time_slot_master/add');
            }  
        }
        else
        {            
            $data['_view'] = 'time_slot_master/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a programe
     */
    function edit($id)
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Edit Time slot';
        $data['time_slot_master'] = $this->Time_slot_model->get_time_slot($id);
        
        if(isset($data['time_slot_master']['id']))
        {
            $this->load->library('form_validation');
			$this->form_validation->set_rules('time_slot','Time Slot','required|trim|min_length[5]|max_length[5]');	
            $this->form_validation->set_rules('type','Time slot type','required');	
			if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(
					'active' => $this->input->post('active') ? $this->input->post('active') : 0,
					'time_slot' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('time_slot')))),
                    'type' => $this->input->post('type'),
                    'by_user' => $by_user,
                );
                $id = $this->Time_slot_model->update_time_slot($id,$params);
                if($id){
                    //activity update start             
                        $activity_name= TIME_SLOT_UPDATE;
                        unset($data['time_slot_master']['id'],$data['time_slot_master']['created'],$data['time_slot_master']['modified']);//unset extras from array
                        $uaID = 'time_slot_master'.$id;
                        $diff1 =  json_encode(array_diff($data['time_slot_master'], $params));//old
                        $diff2 =  json_encode(array_diff($params,$data['time_slot_master']));//new
                        $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                        $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                        if($diff1!=$diff2){
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        }                        
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/time_slot_master/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/time_slot_master/edit/'.$id);
                }  

            }
            else
            {
                $data['_view'] = 'time_slot_master/edit';
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

        $time_slot_master = $this->Time_slot_model->get_time_slot($id);
        if(isset($time_slot_master['id']))
        {
            $del = $this->Time_slot_model->delete_time_slot($id);
            if($del){
                $this->session->set_flashdata('flsh_msg', DEL_MSG);
                redirect('adminController/time_slot_master/index');
            }else{
                $this->session->set_flashdata('flsh_msg', DEL_MSG_FAILED);
                redirect('adminController/time_slot_master/index');
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/
    
}
