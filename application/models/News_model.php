<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 
class News_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getSearchedNews($searchText){

        $this->db->select('
            id, 
            title,
            news_date,           
            body,
            media_file,
            card_image,
            is_pinned,
            URLslug,
        ');
        $this->db->from('`news`'); 
        $this->db->where('`active`',1); 
        $this->db->where('URLslug IS NOT NULL');
        $this->db->like('title', $searchText);
        $this->db->or_like('body', $searchText);
        $this->db->order_by('`created` DESC');     
        return $this->db->get('')->result_array();
    }
    function get_newsid($id)
    {
        return $this->db->get_where('news',array('id'=>$id))->row_array();
    }
    
    function get_news($id)
    {
        return $this->db->get_where('news',array('URLslug'=>$id))->row_array();
    }

    function get_all_news_count($tags){
      
        if($tags){           
            $this->db->from('`news` n');
            $this->db->join('news_tags nt', 'n.id = nt.news_id');
            $this->db->where('nt.tags',$tags); 
            $this->db->where('URLslug IS NOT NULL');  
           // $this->db->limit(30); 
        }else {
            $this->db->from('news'); 
            return $this->db->count_all_results();
        }      
        
    }

    function get_all_news_count_backend(){
      
       $this->db->from('news');
       $this->db->where('URLslug IS NOT NULL');
        return $this->db->count_all_results();      
        
    }

    function get_all_news($params = array()){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            id, 
            title,
            news_date,
            body,
            media_file,
            card_image,
            active,
            is_pinned,
            URLslug,
        ');
        $this->db->from('`news`'); 
        $this->db->order_by('`created` DESC');     
        $this->db->where('URLslug IS NOT NULL');
        return $this->db->get('')->result_array();
    } 

    function get_all_news_acive_limit(){
        
        $this->db->select('
            id, 
            title,
            news_date,
            body,
            media_file,
            card_image,
             URLslug,
        ');
        $this->db->from('`news`'); 
        $this->db->where('active',1);
        $this->db->where('URLslug IS NOT NULL');
        $this->db->order_by('`created` DESC'); 
        
        $this->db->limit(4);       
        return $this->db->get('')->result_array();
    } 

    function get_allNews($tags,$limit=null,$offset=null){
        if(isset($limit))
        {
            $this->db->limit($limit, $offset);
        }

        if($tags){

            $this->db->select('
                n.id, 
                n.title,
                n.news_date,
                n.body,
                n.media_file,
                n.is_pinned,
                n.card_image,
                n.URLslug,
            ');
            $this->db->from('`news` n');
            $this->db->join('news_tags nt', 'n.id = nt.news_id');
            $this->db->where('nt.tags',$tags);
            $this->db->where('URLslug IS NOT NULL');
            $this->db->order_by('`created` DESC');
           // $this->db->limit(30); 
        }else{
            $this->db->select('
                id, 
                title,
                news_date,
                body,
                media_file,
                is_pinned,
                card_image,
                URLslug,
            ');
            $this->db->from('`news`'); 
            $this->db->where('active',1);
            $this->db->where('URLslug IS NOT NULL');
            $this->db->order_by('`created` DESC');
            //$this->db->limit(30); 
        }        
        return $this->db->get('')->result_array();
       //  print_r($this->db->last_query());exit;
    }

    function get_allNews_pinned(){
        
        $this->db->select('
            id, 
            title,
            news_date,
            URLslug,
            is_pinned
        ');
        $this->db->from('`news`'); 
        $this->db->where(array('active'=>1, 'is_pinned'=>1));
        $this->db->where('URLslug IS NOT NULL');
        $this->db->order_by('`created` DESC');
        $this->db->limit(15);
        return $this->db->get('')->result_array();
    }  

    function getNewsTags($id){

        //$this->db->distinct('');
        $this->db->select('tags');
        $this->db->from('`news_tags`'); 
        $this->db->where(array('news_id'=>$id));
        return $this->db->get('')->result_array();
    } 

    function getNewsTagsUnique(){

        $this->db->distinct('');
        $this->db->select('tags');
        $this->db->from('`news_tags`');
        $this->db->join('news n', 'n.id = news_tags.news_id','left'); 
        $this->db->where(array('tags!='=>''));
        $this->db->where('URLslug IS NOT NULL');
        $this->db->order_by('`news_tags.id` DESC');
        $this->db->limit(30);
        return $this->db->get('')->result_array();

    }
        
    
    function add_news($params)
    {
        $this->db->insert('news',$params);
        return $this->db->insert_id();
    }

    function add_news_tags($params)
    {
        $this->db->insert('news_tags',$params);
        return $this->db->insert_id();
    }
    
    
    function update_news($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('news',$params);
    }
    
   
    function delete_news($id)
    {
        return $this->db->delete('news',array('id'=>$id));
    }

    function delete_news_tags($id){

        return $this->db->delete('news_tags',array('news_id'=>$id));
    }

   
}
