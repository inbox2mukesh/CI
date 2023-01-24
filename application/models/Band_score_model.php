<?php
/**
 * @package         MasterPrep
 * @subpackage      Test Series
 * @author          Mohammad Haroon
 *
 **/

 
class Band_score_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    } 
    
    function getBandScores($test_module_id)
    {  
        $this->db->select('`band_score`');
        $this->db->from('`band_scores`');        
        $this->db->where(array('test_module_id'=>$test_module_id));        
        $this->db->order_by('`band_score` ASC');
        return $this->db->get('')->result_array();
    }   
    
}
