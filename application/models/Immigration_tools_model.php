<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
  *
 **/ 
class Immigration_tools_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all_crs_score_count_bydate($start_date,$end_date)
	{
		 $this->db->from('student_crs_score');  
		 if(($start_date!=NULL) && ($end_date!=NULL))
         {
            $this->db->where('`created` BETWEEN "'.$start_date.'" and "'.$end_date.'"');
		 }
      	 return $this->db->count_all_results();
	}

	function get_all_crs_score_bydate($start_date,$end_date,$params)
	{
		if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        } 
		 $this->db->from('student_crs_score'); 
         if(($start_date!=NULL) && ($end_date!=NULL))
         {
            $this->db->where('`created` BETWEEN "'.$start_date.'" and "'.$end_date.'"');
		 }		 
		 $this->db->order_by('`id` DESC');     
         return $this->db->get('')->result_array();
		
	}

	function get_all_crs_score_count()
	{
		 $this->db->from('student_crs_score');        
        return $this->db->count_all_results();
		
	}

	function get_all_crs_score($params)
	{
		
		if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        } 
		 $this->db->from('student_crs_score');        
		 $this->db->order_by('`id` DESC');     
         return $this->db->get('')->result_array();
		
	}

	function get_crs_score($id)
	{
		$this->db->select('student_crs_score.fname,student_crs_score.lname,student_crs_score.email,student_crs_score.phone,student_crs_score.fname,student_crs_score.country_code,student_crs_score.grand_total_crs,student_crs_score.created,cal_marital_status.marital_title,cal_age_matser.age,cal_age_matser.points as age_point,cal_candidate_education_level.education_title,cal_candidate_education_level.points as e_point,listening.Listening_title,listening.Listening_points,reading.Reading_title,reading.Reading_points,writing.writing_title,writing.writing_points,speaking.speaking_title,speaking.speaking_points,french_listening.Listening_title as f_Listening_title,french_listening.Listening_points as f_Listening_points,french_reading.Reading_title as f_Reading_title,french_reading.Reading_points as f_Reading_points,french_writing.writing_title as f_writing_title,french_writing.writing_points as f_writing_points,french_speaking.speaking_title as f_speaking_title,french_speaking.speaking_points as f_speaking_points,cal_spouse_education_level.title as spouse_edu_title, cal_spouse_education_level.points as spouse_edu_points,cal_spouse_work_experience.title as spouse_exp_title,cal_spouse_work_experience.points as spouse_exp_points,spouse_listing.Listening_title as spouse_Listening_title,spouse_listing.Listening_points as spouse_Listening_points,spouse_reading.Reading_title as spouse_Reading_title,spouse_reading.Reading_points as spouse_Reading_points,spouse_writing.writing_title as spouse_writing_title,spouse_writing.writing_points as spouse_writing_points,spouse_speaking.speaking_title as spouse_speaking_title,spouse_speaking.speaking_points as spouse_speaking_points,cal_exprience_level.title as exp_title,cal_exprience_level.points as exp_points,cal_foreign_work_experience.title as foreign_experience_title,cal_foreign_work_experience.points as foreign_experience_points,cal_canadian_trade_certificat.title as trade_certificat_title,totallanguage_education_score,totaleducation_canadianexperience,totallanguage_foreignexperience,totalcanadianforeignexperience,totaltradeCertificate,provincial_nomination_text,provincial_nomination_ponits,arranged_employment_text,arranged_employment_points,education_in_canada_text,education_in_canada_points,relative_in_canada_text,relative_in_canada_points,totalFrench_score');
		$this->db->from('student_crs_score');
		$this->db->join('cal_marital_status','cal_marital_status.cal_marital_status_id=student_crs_score.cal_marital_status_id', 'inner');    
		$this->db->join('cal_age_matser','cal_age_matser.age_matser_id=student_crs_score.age_matser_id', 'inner');   
		$this->db->join('cal_languages as listening','listening.languages_id=student_crs_score.eng_listening_id', 'inner');   
		$this->db->join('cal_languages as reading','reading.languages_id=student_crs_score.eng_reading_id', 'inner');   
		$this->db->join('cal_languages as writing','writing.languages_id=student_crs_score.eng_writing_id', 'inner');   
		$this->db->join('cal_languages as speaking','speaking.languages_id=student_crs_score.eng_speaking_id', 'inner');  
		$this->db->join('cal_languages as french_listening','french_listening.languages_id=student_crs_score.french_listing_id', 'left');	
		$this->db->join('cal_languages as french_reading','french_reading.languages_id=student_crs_score.french_reading_id', 'left');	
		$this->db->join('cal_languages as french_writing','french_writing.languages_id=student_crs_score.french_writing_id', 'left');	
		$this->db->join('cal_languages as french_speaking','french_speaking.languages_id=student_crs_score.french_speaking_id', 'left');	
		$this->db->join('cal_candidate_education_level','cal_candidate_education_level.education_level_id=student_crs_score.education_level_id', 'inner'); 

		$this->db->join('cal_spouse_education_level','cal_spouse_education_level.education_level_id=student_crs_score.spouse_edu_level', 'left'); 
		$this->db->join('cal_spouse_work_experience','cal_spouse_work_experience.id=student_crs_score.spouse_workexp', 'left'); 
		$this->db->join('cal_spouse_languages as spouse_listing','spouse_listing.languages_id=student_crs_score.spouse_listing_points', 'left'); 
		$this->db->join('cal_spouse_languages as spouse_reading','spouse_reading.languages_id=student_crs_score.spouse_reading_points', 'left'); 
		$this->db->join('cal_spouse_languages as spouse_writing','spouse_writing.languages_id=student_crs_score.spouse_writing_points', 'left'); 
		$this->db->join('cal_spouse_languages as spouse_speaking','spouse_speaking.languages_id=student_crs_score.spouse_speaking_points', 'left'); 	
		$this->db->join('cal_exprience_level','cal_exprience_level.candi_exprience_level_id=student_crs_score.cand_exp', 'left'); 
		$this->db->join('cal_foreign_work_experience','cal_foreign_work_experience.id=student_crs_score.cand_foreign_exp', 'left'); 
		$this->db->join('cal_canadian_trade_certificat','cal_canadian_trade_certificat.id=student_crs_score.trade_certificate', 'left');	
		$this->db->order_by('student_crs_score.`id` DESC');     
		$this->db->where(array('student_crs_score.id'=>$id)); 
		return $this->db->get('')->result_array();
	}

	/*--fetch crs lead data from assessment tool wesbite and insert in our table and maintain in lead table ----*/
    function cron_get_all_crs_score()
	{
		date_default_timezone_set('Asia/Calcutta');
		$tDate=date('Y-m-d');
		/* fetch crs data from assessment tool : other server*/
		$otherdb = $this->load->database('asstool_db', TRUE); //		
		$otherdb->from('student_crs_score');  
		$otherdb->where('created', $tDate);  
		$server_data= $otherdb->get()->result_array();	
		/*---------ends---------*/
		if(!empty($server_data))
		{
			/* fetch crs data from current server*/
			$this->db->from('student_crs_score');
			$this->db->where('created', $tDate);   
			$current_data=$this->db->get()->result_array();
			/*--ends----*/

			/*check difference in data*/        
			$final_data_to_insert = $this->array_diff_checker($server_data, $current_data);
			//print_r($final_data_to_insert);
			
			/*--ends----*/
	        if(count($final_data_to_insert) >0 AND $final_data_to_insert !=0)
	        {
	        	
		        foreach($final_data_to_insert as $res)
		         {
		           	/*--Check data in lead */
					$today = date('d-m-Y');
		            $params_lead=array(
		                'todayDate'=>$today,
		                'fname' => $res['fname'],
		                'lname' =>$res['lname'],
		                'email'    => $res['email'],
		                'country_code' => $res['country_code'],
		                'mobile' =>  $res['phone'],
		                'lead_via'=> "crs tool",
		                'active'=> 1,               
		            ); 
		            $this->auto_check_lead($params_lead);
		            /*---ends---*/ 
		         }
		        /*--insert data in crs table :current server*/	        
	              $insert = $this->db->insert_batch('student_crs_score', $final_data_to_insert);
	            /*---ends---*/ 
	        }  
        }     		
	}    
}