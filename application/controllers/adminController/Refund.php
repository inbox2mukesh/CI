<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon1
 *
 **/
class Refund extends MY_Controller{

    function __construct()
    {
        parent::__construct();
        if(!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Student_model');
        $this->load->model('User_model');
        $this->load->model('Refund_model');

        $today = date('d-m-Y');
        $todayStr = strtotime($today);
        $this->Refund_model->deactivateApprovedRefundNotUsedAfterTwoDays($todayStr);
    }

    function approve_reject_refund_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $id = $this->input->post('id', true);
        $type = $this->input->post('type', true);
        $one=1;$two=2;
        if($type=='A')
            $a = $this->Refund_model->approve_reject_refund($id,$one);
        else
            $a = $this->Refund_model->approve_reject_refund($id,$two);
            $get_byUser = $this->Refund_model->get_byUser($id);
            $by_user1 = $get_byUser['by_user'];

            $mobileEmail = $this->User_model->get_mobileEmail($by_user1);
            $email = $mobileEmail['email'];
            $mobile = $mobileEmail['mobile'];

            $getStudentId = $this->Refund_model->getStudentId($id);
            $student_id = $getStudentId['student_id'];
            $amount = CURRENCY.' '.$getStudentId['amount'];
            $get_UID = $this->Student_model->get_UID($student_id);
            $UID = $get_UID['UID'];

            //activity update start
            if($type=='A'){
                $activity_name= REFUND_APPROVAL;
                $description= 'Refund approved worth '.$amount.' for student '.$UID.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            }else{
                $activity_name= REFUND_DISAPPROVAL;
                $description= 'Refund Dis-Approved(Rejected) worth '.$amount.' for student '.$UID.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            }
            //activity update end
            //$message = 'Hi! Action taken on your requested refund. please login to view details.';
            //$this->call_smaGateway($mobile,$message);
            echo $a;
    }

    function disApprove_refund_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $id = $this->input->post('id', true);
        $params = array('active'=>1,'approve'=>0, 'approvedOn'=>NULL);
        $a = $this->Refund_model->update_refund_request($id,$params);

        $getStudentId = $this->Refund_model->getStudentId($id);
        $student_id = $getStudentId['student_id'];
        $amount = CURRENCY.' '.$getStudentId['amount'];
        $get_UID = $this->Student_model->get_UID($student_id);
        $UID = $get_UID['UID'];
            //activity update start
                $activity_name= REFUND_REQUEST_REVERSAL;
                $description= 'Refund made as reversed worth '.$amount.' for student '.$UID.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
        echo $a;
    }

    function doExpire_refund_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $id = $this->input->post('id', true);
        $params = array('active'=>0,'approve'=>3, 'approvedOn'=>NULL);
        $a = $this->Refund_model->update_refund_request($id,$params);

        $getStudentId = $this->Refund_model->getStudentId($id);
        $student_id = $getStudentId['student_id'];
        $amount = CURRENCY.' '.$getStudentId['amount'];
        $get_UID = $this->Student_model->get_UID($student_id);
        $UID = $get_UID['UID'];
            //activity update start
                $activity_name= REFUND_EXPIERD;
                $description= 'Refund made as expired worth '.$amount.' for student '.$UID.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
        echo $a;
    }

    function index(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}        
        //access control ends

        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE;
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/refund/index?');
        $config['total_rows'] = $this->Refund_model->get_all_refund_request_count();
        $this->pagination->initialize($config);
        $data['refund'] = $this->Refund_model->get_all_refund_request($params);
        $data['title'] = 'Refund Request- List';
        $data['_view'] = 'refund/index';
        $this->load->view('layouts/main',$data);
    }

    function ajax_displayRefundHistory(){

        $student_id = $this->input->post('student_id', true);
        $refund = $this->Refund_model->get_std_refund_request($student_id);

        $x = '  <div class="table-ui-scroller"><div class="table-responsive table-hr-scroller table-cb-none mheight200">
        <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th>Sr.</th>
                        <th>Refund for</th>
                        <th>Refund Requested to</th>
                        <th>Refund Requested From</th>
                        <th>Ref. By</th>
                        <th>Requested refund Amount</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>'.STATUS.'</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">';
        $sr=0;foreach($refund as $c){
        $zero=0;$one=1;$pk='id'; $table='refund_request';$sr++;
        if($c["active"]==1 and $c["approve"]==1){
            $status = '<span class="text-success"><a href="javascript:void(0);" id='.$c["wid"].' data-toggle="tooltip" title="Active to use">'.ACTIVE.'</a></span>';
        }else if($c["active"]==0 and $c["approve"]==1){
            $status ='<span class="text-danger"><a href="javascript:void(0);" id='.$c["wid"].' data-toggle="tooltip" title="Already Used">'.DEACTIVE.'</a></span>';
        }else{
            $status ='<span class="text-info"><a href="javascript:void(0);" id='.$c["wid"].' data-toggle="tooltip" title="Can not use">'.DEACTIVE.'</a></span>';
        }

                            if($c['active']==1 and $c['approve']==1){
                                $status2 = '<span class="text-success">Active to use</span>';
                            }else if($c['active']==0 and $c['approve']==1){
                                $status2 = '<span class="text-info">Already Used</span>';
                            }else if($c['active']==0 and $c['approve']==3){

                                $status2 = '<span class="text-danger">Expired</span>';
                            }
                            else{
                                $status2 = '<span class="text-warning">Pending for approval- Can not use</span>';
                            }

        $y .='<tr>
                        <td>'.$sr.'</td>
                        <td>'.$c["UID"].' | '.$c["sfname"].' '.$c["slname"].'</td>
                        <td>'.$c["to_fname"].' '.$c["to_lname"].'-'.$c["to_mobile"].'</td>
                        <td>'.$c["from_fname"].' '.$c["from_lname"].'-'.$c["from_mobile"].'</td>
                        <td>'. $c["ref_fname"].' '.$c["ref_lname"].'-'.$c["ref_mobile"].'</td>
                        <td>'. $c["amount"].'</td>
                        <td>'. $c["remarks"].'</td>
                        <td>'. $c["created"].'</td>
                        <td>'. $status2.'</td>
                        <td>'. $status.'</td>
                    </tr>';
                }

        $z = '</table></div></div>';
        $a = $x.$y.$z;
        if(!empty($refund)){
            header('Content-Type: application/json');
            $response = ['msg'=>SUCCESS_MSG, 'status'=>'true','data'=>$a];
            echo json_encode($response);
        }else{
            $a='';
            header('Content-Type: application/json');
            $response = ['msg'=>FAILED_MSG, 'status'=>'false','data'=>$a];
            echo json_encode($response);
        }
    }

    function add(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $UserFunctionalBranch = $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }

        $data['title'] = 'Raise Refund Request';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('student_id','Student','required');
		$this->form_validation->set_rules('user_id','refund User','required');
        $this->form_validation->set_rules('amount','amount','required|trim');
        $this->form_validation->set_rules('remarks','Remarks','required|trim');

		if($this->form_validation->run())
        {
            $by_user=$_SESSION['UserId'];
            $params = array(
				'student_id' => $this->input->post('student_id'),//for who
				'user_id' => $this->input->post('user_id'),  //to whom
                'amount' => $this->input->post('amount'),
                'remarks' => $this->input->post('remarks'),
                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'by_user' => $by_user, // who requested
                'ref_user_id'=>$this->input->post('ref_user_id'), // refered by
            );

            $id = $this->Refund_model->add_refund_request($params);
            if($id and $id!='duplicate'){
                //SMS here
                $mobileEmail = $this->User_model->get_mobileEmail($params['user_id']);
                $email = $mobileEmail['email'];
                $mobile = $mobileEmail['mobile'];

                $student_id = $params['student_id'];
                $amount = CURRENCY.' '.$params['amount'];
                $get_UID = $this->Student_model->get_UID($student_id);
                $UID = $get_UID['UID'];
                //activity update start
                    $activity_name= REFUND_REQUEST;
                    $description= 'New Refund request created worth '.$amount.' for student '.$UID.'';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end

                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                if($this->Role_model->_has_access_('refund','index')){
                    redirect('adminController/refund/index');
                }else{
                    redirect('adminController/refund/add');
                }

            }elseif($id=='duplicate'){
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/refund/add');
            }
            else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/refund/add');
            }

        }else{
            $data['all_student'] = $this->Student_model->get_all_student_refund($_SESSION['roleName'],$userBranch);
			$data['all_user'] = $this->User_model->get_all_user_refund();
            $data['all_refUser'] = $this->User_model->get_all_user_forReference();
            $data['_view'] = 'refund/add';
            $this->load->view('layouts/main',$data);
        }
    }

    function remove($id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $refund = $this->Refund_model->get_refund($id);
        if(isset($refund['id']))
        {
            $getStudentId = $this->Refund_model->getStudentId($id);
            $student_id = $getStudentId['student_id'];
            $amount = CURRENCY.' '.$getStudentId['amount'];
            $get_UID = $this->Student_model->get_UID($student_id);
            $UID = $get_UID['UID'];

            $del = $this->Refund_model->delete_refund_request($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            if($del){
                //activity update start
                    $activity_name= REFUND_REQUEST_REMOVAL;
                    $description='Refund request ID '.$id.' deleted worth '.$amount.' for student '.$UID.'';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                redirect('adminController/refund/index');
            }else{
                redirect('adminController/refund/index');
            }

        }
        else
            show_error(ITEM_NOT_EXIST);
    }

}
