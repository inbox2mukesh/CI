<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Vikrant
 **/
class Tax_master extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {
            redirect('adminController/login');
        }
        $this->load->model('Tax_master_model');
    }
    
    function index()
    {
        //access control start
        $cn = $this->router->fetch_class() . '' . '.php';
        $mn = $this->router->fetch_method();
        if (!$this->_has_access($cn, $mn)) {
            redirect('adminController/error_cl/index');
        }
        $data['si'] = 1;
        //access control ends
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE;
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/tax_master/index?');
        $config['total_rows'] = $this->Tax_master_model->get_all_tax_master_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Tax Master';
        $data['tax_master'] = $this->Tax_master_model->get_all_tax_master($params);
        $data['_view'] = 'tax_master/index';
        $this->load->view('layouts/main', $data);
    }
    
    function add()
    {
        //access control start
        $cn = $this->router->fetch_class() . '' . '.php';
        $mn = $this->router->fetch_method();
        if (!$this->_has_access($cn, $mn)) {
            redirect('adminController/error_cl/index');
        }
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Add Tax Master';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tax_name', 'Tax Name', 'required|trim');
        $this->form_validation->set_rules('tax_per', 'Tax percentage', 'required|trim'); 
        if ($this->form_validation->run()) {
            $user = $this->session->userdata('admin_login_data');
            foreach ($user as $d) {
                $by_user = $d->id;
            }
            $params = array(
                'active'             => $this->input->post('active'),
                'tax_name'             => $this->input->post('tax_name'),
                'tax_per'             => $this->input->post('tax_per'),
                'by_user'             => $by_user
            );
            $dup = $this->Tax_master_model->dupliacte_tax_master(0, $params);
            if ($dup == 'DUPLICATE') {
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/tax_master/add');
            } else {
                $id = $this->Tax_master_model->add_tax_master($params);
                if ($id) {
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/tax_master/index');
                } else {
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/tax_master/add');
                }
            }
        } else {
            $data['_view'] = 'tax_master/add';
            $this->load->view('layouts/main', $data);
        }
    }
    /*
     * Editing  
     */
    function edit($DocId)
    {
        //access control start
        $cn = $this->router->fetch_class() . '' . '.php';
        $mn = $this->router->fetch_method();
        if (!$this->_has_access($cn, $mn)) {
            redirect('adminController/error_cl/index');
        }
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Edit Tax Master';
        $data['Tax'] = $this->Tax_master_model->get_tax_master($DocId);
        if (isset($data['Tax']['id'])) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('tax_name', 'Tax Name', 'required|trim');
            $this->form_validation->set_rules('tax_per', 'Tax percentage', 'required|trim'); 
            if ($this->form_validation->run()) {
                
                $user = $this->session->userdata('admin_login_data');
                foreach ($user as $d) {
                    $by_user = $d->id;
                }
                $params = array(
                    'active'             => $this->input->post('active'),
                    'tax_name'             => $this->input->post('tax_name'),
                    'tax_per'             => $this->input->post('tax_per'),
                    'by_user'             => $by_user,
                    'modified'            => date('Y-m-d H:i:s'),
                );
                $dup = $this->Tax_master_model->dupliacte_tax_master($DocId, $params);
                if ($dup == 'DUPLICATE') {
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);
                    redirect('adminController/tax_master/edit/' . $DocId);
                } else {
                    $id = $this->Tax_master_model->update_tax_master($DocId, $params);
                    if ($id) {
                        $this->session->set_flashdata('flsh_msg', UPDATE_MSG);
                        redirect('adminController/tax_master/index');
                    } else {
                        $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);
                        redirect('adminController/tax_master/edit/' . $DocId);
                    }
                }
            } else {
                $data['_view'] = 'tax_master/edit';
                $this->load->view('layouts/main', $data);
            }
        } else
            show_error(ITEM_NOT_EXIST);
    }
}
