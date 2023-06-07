<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class News extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login'); }
        $this->load->model('News_model');
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
        $config['base_url'] = site_url('adminController/news/index/?');
        $config['total_rows'] = $this->News_model->get_all_news_count_backend();
        $this->pagination->initialize($config);
        $data['title'] = 'Immigration News';
        $data['news'] = $this->News_model->get_all_news($params);
        $data['_view'] = 'news/index';
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

        $data['title'] = 'Add Immigration News';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('title','News Title','required|trim');
        $this->form_validation->set_rules('body','News Body','required|trim');
        $this->form_validation->set_rules('news_date','News Date','required|trim');
        $this->form_validation->set_rules('URLslug', 'URL ', 'required|max_length[140]');
        $this->form_validation->set_rules('keywords', 'SEO Keywords ', 'required');
        $this->form_validation->set_rules('seo_title', 'SEO Title ', 'required');
        $this->form_validation->set_rules('seo_desc', 'SEO Description', 'required|max_length[200]');
        if (empty($_FILES['card_image']['name']))
        {
        $this->form_validation->set_rules('card_image', 'Document', 'required');
        }
        if (empty($_FILES['media_file']['name']))
        {
            $this->form_validation->set_rules('media_file','Media file','required');
        }
       if($this->form_validation->run())
        {   
            if(!file_exists(NEWS_FILE_PATH)){
                mkdir(NEWS_FILE_PATH, 0777, true);
            }
            $by_user=$_SESSION['UserId'];            
            $config['upload_path']      = NEWS_FILE_PATH;
            $config['allowed_types']    = WEBP_FILE_TYPES;
            $config['encrypt_name']     = FALSE;         
            $this->load->library('upload',$config);

                if($this->upload->do_upload("media_file")){
                    $data = array('upload_data' => $this->upload->data());
                    $image= $data['upload_data']['file_name'];                     
                }else{                          
                       $image=NULL; 
                }
                
                $configp['upload_path']      = NEWS_FILE_PATH;
                $configp['allowed_types']    = WEBP_FILE_TYPES;
                $configp['encrypt_name']     = FALSE;  
            $this->upload->initialize($configp);  
                 $this->load->library('upload',$configp);

                if($this->upload->do_upload("card_image")){
                    $data_card_image = array('upload_data' => $this->upload->data());
                    $card_image= $data_card_image['upload_data']['file_name'];                     
                }else{                          
                       $card_image=NULL; 
                    $this->upload->display_errors();
                }
                $params = array( 
                            'title' => $this->input->post('title'),
                            'body' => $this->input->post('body',false),                    
                            'media_file' => $image,
                             'card_image' => $card_image,
                            'news_date'=>$this->input->post('news_date'), 
                            'URLslug'=>$this->input->post('URLslug'), 
                            'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                            'is_pinned' => $this->input->post('is_pinned') ? $this->input->post('is_pinned') : 0,
                            'by_user' => $by_user,
                            'seo_keywords'=>$this->input->post('keywords'),
                            'seo_title'=>$this->input->post('seo_title'),
                            'seo_desc'=>$this->input->post('seo_desc'),
                        );
                        $id = $this->News_model->add_news($params);
                        $tags= $this->input->post('tags');
                        $tagArr = explode(',', $tags);
                        foreach ($tagArr as $t) {
                            $params2 = array('news_id'=>$id, 'tags'=>trim($t));
                            $this->News_model->add_news_tags($params2);
                        }                        
                    
                    if($id){
                        //activity update start              
                        $activity_name= "News Added";
                        $description= ''.json_encode($params).'';
                        $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                        //activity update end
                        $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                        redirect('adminController/news/index');
                    }else{
                        $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                        redirect('adminController/news/add');
                    }            
                
        }else{

            $data['_view'] = 'news/add';
            $this->load->view('layouts/main',$data);
        }
    }

    function edit($id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends       

        $data['title'] = 'Edit Immigration News';
        $data['news'] = $this->News_model->get_newsid($id);
        $bookingData=$data['news'];        
        foreach ($bookingData as $key => $c) {
            $mData = $this->News_model->getNewsTags($data['news']['id']);
            foreach ($mData as $key2 => $m) {                
                $bookingData['TagData'][$key2]=$m;                       
            }               
        }
        $data['news']=$bookingData;
      
        if(isset($data['news']['id']))
        {
           
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title','News Title','required|trim');
            $this->form_validation->set_rules('body','News Body','required|trim');
            $this->form_validation->set_rules('news_date','News Date','required|trim');	
            $this->form_validation->set_rules('URLslug', 'URL ', 'required|max_length[140]');
            $this->form_validation->set_rules('keywords', 'SEO Keywords ', 'required');
            $this->form_validation->set_rules('seo_title', 'SEO Title ', 'required');
            $this->form_validation->set_rules('seo_desc', 'SEO Description', 'required|max_length[200]');	
            if($this->input->post('hid_card_image') == "" && empty($_FILES['card_image']['name']))
            {
                $this->form_validation->set_rules('card_image','Card image','required');
            }
            if($this->input->post('hid_media_file') == "" && empty($_FILES['media_file']['name']))
            {
                $this->form_validation->set_rules('media_file','Media file','required');
            }
            $flag_mediaFile=0;
            $flag_cardFile=0;
            
			if($this->form_validation->run())     
            {   
                // pr('asdfads',1);
                $by_user=$_SESSION['UserId'];
                if(!file_exists(NEWS_FILE_PATH)){
                    mkdir(NEWS_FILE_PATH, 0777, true);
                }

                $config['upload_path']  = NEWS_FILE_PATH;
                $config['allowed_types']= WEBP_FILE_TYPES;
                $config['encrypt_name'] = FALSE;       
                $this->load->library('upload',$config);

                if($this->upload->do_upload("media_file")){
                    $flag_mediaFile=1;
                    $data = array('upload_data' => $this->upload->data());
                    $image= $data['upload_data']['file_name'];

                    $params = array( 
                    'title' => $this->input->post('title'),
                    'body' => $this->input->post('body',false),                    
                    'media_file' => $image,
                    'news_date'=>$this->input->post('news_date'), 
                    'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                    'is_pinned' => $this->input->post('is_pinned') ? $this->input->post('is_pinned') : 0,
                    'by_user' => $by_user,
                    'URLslug'=>$this->input->post('URLslug'), 
                    'seo_keywords'=>$this->input->post('keywords'),
                    'seo_title'=>$this->input->post('seo_title'),
                    'seo_desc'=>$this->input->post('seo_desc'),
                );
                unlink(NEWS_FILE_PATH.$this->input->post('hid_media_file')); 

                }else{
                    
                    $params = array( 
                        'title' => $this->input->post('title'),
                        'body' => $this->input->post('body',false),                    
                        //'media_file' => $image,
                        'news_date'=>$this->input->post('news_date'), 
                        'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                        'is_pinned' => $this->input->post('is_pinned') ? $this->input->post('is_pinned') : 0,
                        'by_user' => $by_user,
                        'URLslug'=>$this->input->post('URLslug'), 
                        'seo_keywords'=>$this->input->post('keywords'),
                        'seo_title'=>$this->input->post('seo_title'),
                        'seo_desc'=>$this->input->post('seo_desc'),
                    );
                }
                        
                        $params = array(
                            'title' => $this->input->post('title'),
                            'body' => $this->input->post('body',false),                    
                            'media_file' => $image,
                            'news_date'=>$this->input->post('news_date'), 
                            'URLslug'=>$this->input->post('URLslug'), 
                            'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                            'is_pinned' => $this->input->post('is_pinned') ? $this->input->post('is_pinned') : 0,
                            'by_user' => $by_user,
                            'seo_keywords'=>$this->input->post('keywords'),
                            'seo_title'=>$this->input->post('seo_title'),
                            'seo_desc'=>$this->input->post('seo_desc'),
                        );


                       

                    $configp['upload_path']      = NEWS_FILE_PATH;
                    $configp['allowed_types']    = WEBP_FILE_TYPES;
                    $configp['encrypt_name']     = FALSE;  
                    $this->upload->initialize($configp);  
                    $this->load->library('upload',$configp);
                    if($this->upload->do_upload("card_image")){
                        $flag_cardFile=1;
                    $data_card_image = array('upload_data' => $this->upload->data());
                    $card_image= $data_card_image['upload_data']['file_name']; 
                    $params['card_image']=$card_image;  
                    unlink(NEWS_FILE_PATH.$this->input->post('hid_card_image'));          
                    }else{                          
                    $card_image=NULL; 
                  //$this->upload->display_errors();
                    }


                    // pr($params,1);
                $idd = $this->News_model->update_news($id,$params);
                $del = $this->News_model->delete_news_tags($id);
                $tags= $this->input->post('tags');
                        $tagArr = explode(',', $tags);
                        foreach ($tagArr as $t) {
                            $params2 = array('news_id'=>$id, 'tags'=>trim($t));
                            $this->News_model->add_news_tags($params2);
                        } 
                if($id){
                //activity update start                            
                $activity_name= "News Updated";
                unset($data['news'] ['id'],$data['news']['created'],$data['news']['modified']);//unset extras from array
                if($flag_mediaFile==0)
                {
                    unset($data['news'] ['media_file']);
                }
                if($flag_cardFile==0)
                {
                    unset($data['news'] ['card_image']);
                }
                $uaID = 'news'.$id;
                $diff1 =  json_encode(array_diff($data['news'], $params));//old
                $diff2 =  json_encode(array_diff($params,$data['news']));//new
                $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                if($diff1!=$diff2){
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                }                        
                //activity update end

                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/news/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/news/edit/'.$id);
                }
                
            }
            else
            {
                 
                $data['_view'] = 'news/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
    

    function remove($id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $news = $this->News_model->get_newsid($id);
        if(isset($news['id']))
        {
            $del1 = $this->News_model->delete_news($id);
            $del2 = $this->News_model->delete_news_tags($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            if($del1 && $del2){
                redirect('adminController/news/index');
            }else{
                redirect('adminController/news/index');
            }
            
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
    
}
