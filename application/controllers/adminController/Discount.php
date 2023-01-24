<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Prabhat
 *
 **/
 
class Discount extends MY_Controller{

    function __construct(){

        parent::__construct();
        if(!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Student_model');
        $this->load->model('User_model');
		$this->load->model('Country_model');
        $this->load->model('Discount_model');
		$this->load->model('Test_module_model');
		$this->load->model('Center_location_model');
		$this->load->model('Time_slot_model');  
        $this->load->model('Package_master_model'); 
        $this->load->model('Practice_package_model');
        $this->load->model('Realty_test_model');
        $this->load->model('Country_model');
        $this->load->model('Exam_master_model');
        $this->load->model('Division_master_model');	
    }

 	public function crypto_rand_secure_($min, $max){

        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;

    }
	
    public function getUnicode_($length){

        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure_(0, $max-1)];
        }
        return $token;
    }


   
    function index(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        
        $current_DateTime = date("Y-m-d G:i A");
        $current_DateTimeStr = strtotime($current_DateTime);
        $this->Discount_model->deactivate_discount($current_DateTimeStr);

        $today = date('d-m-Y');
        $todayStr = strtotime($today);
        //$dayAfterTomarrow = date('d-m-Y', strtotime($today. ' + 2 days'));
        //$dayAfterTomarrow_Str = strtotime($dayAfterTomarrow);
       // $this->Waiver_model->deactivateApprovedWaiverNotUsedAfterTwoDays($todayStr);

        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }

        $this->load->library('pagination');
        $params['limit']        = RECORDS_PER_PAGE; 
        $params['offset']       = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config                 = $this->config->item('pagination');
        $config['base_url']     = site_url('adminController/discount/index?');
        $params['dData']        = $this->input->post();
        $config['total_rows']   = $this->Discount_model->get_all_general_discount_count($_SESSION['roleName'],$params);        
        $this->pagination->initialize($config);
        
        $discountData           = $this->Discount_model->get_all_discount_general($_SESSION['roleName'],$params);

        foreach ($discountData as $key => $c) {            
            $productData = $this->Discount_model->get_products($c['appliedProducts']);
            foreach ($productData as $key2 => $pr) {                
                $discountData[$key]['Product'][$key2]=$pr;                       
            }                
            $mData = $this->Discount_model->get_branch($c['appliedBranches']);
            foreach ($mData as $key2 => $m) {                
                $discountData[$key]['Branch'][$key2]=$m;                       
            } 
            $testData = $this->Discount_model->get_testype($c['appliedTestType']);
            foreach ($testData as $key2 => $cnt) {                
                $discountData[$key]['TestType'][$key2]=$cnt;                       
            }                
            $packageData = $this->Discount_model->get_package($c['appliedProducts'],$c['appliedBranches'],$c['appliedTestType'],$c['appliedPackages'],"");

            foreach ($packageData as $key2 => $pkg) {                
                $discountData[$key]['Package'][$key2]=$pkg;                       
            }                                 
        } 
            
        $data['all_country_list']           = $this->Country_model->get_all_country_active();
        $data['all_country_code']           = $this->Country_model->get_all_country_active();
        $data['all_country_currency_code']  = $this->Discount_model->get_all_discount_country();
        $data['all_testtype_list']          = $this->Test_module_model->get_all_test_module_active();
        $data['all_branch']                 = $this->Center_location_model->getFunctionalBranch($_SESSION['roleName'],$userBranch); 
        $data['discount']                   = json_encode($discountData);
        $data['title']                      = 'Discount - General List';
        $data['stitle']                     = 'General Discount';
        $data['_view']                      = 'discount/index';
        $this->load->view('layouts/main',$data);
    } 
    
    
    function special(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        
        $current_DateTime = date("Y-m-d G:i A");
        $current_DateTimeStr = strtotime($current_DateTime);
        $this->Discount_model->deactivate_discount($current_DateTimeStr);

        $today = date('d-m-Y');
        $todayStr = strtotime($today);
        //$dayAfterTomarrow = date('d-m-Y', strtotime($today. ' + 2 days'));
        //$dayAfterTomarrow_Str = strtotime($dayAfterTomarrow);
       // $this->Waiver_model->deactivateApprovedWaiverNotUsedAfterTwoDays($todayStr);

        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }

        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/discount/special?');
        $params['dData'] = $this->input->post();
        $config['total_rows'] = $this->Discount_model->get_all_special_discount_count($_SESSION['roleName'],$params);
        
        $this->pagination->initialize($config);
        
        
        $discountData = $this->Discount_model->get_all_discount_special($_SESSION['roleName'],$params);

             foreach ($discountData as $key => $c) {
            
                $productData = $this->Discount_model->get_products($c['appliedProducts']);

                foreach ($productData as $key2 => $pr) {                
                    $discountData[$key]['Product'][$key2]=$pr;                       
                }
                
                $mData = $this->Discount_model->get_branch($c['appliedBranches']);
                foreach ($mData as $key2 => $m) {                
                    $discountData[$key]['Branch'][$key2]=$m;                       
                } 
                $testData = $this->Discount_model->get_testype($c['appliedTestType']);
                foreach ($testData as $key2 => $cnt) {                
                    $discountData[$key]['TestType'][$key2]=$cnt;                       
                }
                
                $packageData = $this->Discount_model->get_package($c['appliedProducts'],$c['appliedBranches'],$c['appliedTestType'],$c['appliedPackages'],"");
                foreach ($packageData as $key2 => $pkg) {                
                    $discountData[$key]['Package'][$key2]=$pkg;                       
                }
                                 
            } 
            
            $data['all_country_list'] = $this->Country_model->get_all_country_active();
         $data['all_country_code'] = $this->Country_model->get_all_country_active();
        $data['all_country_currency_code'] = $this->Discount_model->get_all_discount_country();
        $data['all_testtype_list'] = $this->Test_module_model->get_all_test_module_active(); 
         
        $data['all_branch'] = $this->Center_location_model->getAcademyBranch($_SESSION['roleName'],$userBranch); 
        $data['discount'] = json_encode($discountData);
        
        
        $data['title'] = 'Discount - Special List';
         $data['stitle'] = 'Special Discount';
        $data['_view'] = 'discount/special';
        $this->load->view('layouts/main',$data);
    } 
    
    function bulk(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        
        $current_DateTime = date("Y-m-d G:i A");
        $current_DateTimeStr = strtotime($current_DateTime);
        $this->Discount_model->deactivate_discount($current_DateTimeStr);

        $today = date('d-m-Y');
        $todayStr = strtotime($today);
        //$dayAfterTomarrow = date('d-m-Y', strtotime($today. ' + 2 days'));
        //$dayAfterTomarrow_Str = strtotime($dayAfterTomarrow);
       // $this->Waiver_model->deactivateApprovedWaiverNotUsedAfterTwoDays($todayStr);

        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }


        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/discount/bulk?');
        $params['dData'] = $this->input->post();
        $config['total_rows'] = $this->Discount_model->get_all_bulk_discount_count($_SESSION['roleName'],$params);
        
        $this->pagination->initialize($config);
        $discountData = $this->Discount_model->get_all_discount_bulk($_SESSION['roleName'],$params);

             foreach ($discountData as $key => $c) {
            
                $productData = $this->Discount_model->get_products($c['appliedProducts']);

                foreach ($productData as $key2 => $pr) {                
                    $discountData[$key]['Product'][$key2]=$pr;                       
                }
                
                $mData = $this->Discount_model->get_branch($c['appliedBranches']);
                foreach ($mData as $key2 => $m) {                
                    $discountData[$key]['Branch'][$key2]=$m;                       
                } 
                $testData = $this->Discount_model->get_testype($c['appliedTestType']);
                foreach ($testData as $key2 => $cnt) {                
                    $discountData[$key]['TestType'][$key2]=$cnt;                       
                }
                
                $packageData = $this->Discount_model->get_package($c['appliedProducts'],$c['appliedBranches'],$c['appliedTestType'],$c['appliedPackages'],"");
                foreach ($packageData as $key2 => $pkg) {                
                    $discountData[$key]['Package'][$key2]=$pkg;                       
                }
                                 
            } 
            
            $data['all_country_list'] = $this->Country_model->get_all_country_active();
         $data['all_country_code'] = $this->Country_model->get_all_country_active();
        $data['all_country_currency_code'] = $this->Discount_model->get_all_discount_country();
        $data['all_testtype_list'] = $this->Test_module_model->get_all_test_module_active(); 
         
        $data['all_branch'] = $this->Center_location_model->getFunctionalBranch($_SESSION['roleName'],$userBranch); 
        $data['discount'] = json_encode($discountData);
        
        $data['title'] = 'Discount - Bulk List';
         $data['stitle'] = 'Bulk Discount';
        $data['_view'] = 'discount/bulk';
        $this->load->view('layouts/main',$data);
    }
   
    function ajax_get_country_code(){ 
   
        $country_id = $this->input->post('country_id');
        if(isset($country_id)){            
            $response =  $this->Discount_model->get_discount_currency_code($country_id);
            echo json_encode($response);
        }else{

        }   
    } 
   
    function ajax_check_phonenumber(){ 
   
    	$phoneNumber = $this->input->post('phoneNumber');
        if(isset($phoneNumber)){            
            $response =  $this->Discount_model->check_phone($phoneNumber);
            echo json_encode($response);
        }  else {
			$response =  0;
            echo json_encode($response);
		}

    }   
   
    function ajax_check_email(){ 
   
    	$bemail = $this->input->post('bemail');
        if(isset($bemail)){            
            $response =  $this->Discount_model->check_email($bemail);
            echo json_encode($response);
         }  else {
			$response =  0;
            echo json_encode($response);
		}
    }
    
    function ajax_check_selected_branch_according_to_country() {
        if(!empty($this->input->post('country_id')) && !empty($this->input->post('branch_id'))) {
            $countryIds = $this->input->post('country_id');

            if(is_array($countryIds)) {
                sort($countryIds);
                $countryIds = join(",",$countryIds);
            }

            $branchIds  = $this->input->post('branch_id');

            $onlineBranchArrayKey = array_search(ONLINE_BRANCH_ID,$branchIds);

            if($onlineBranchArrayKey != Null) {
                unset($branchIds[$onlineBranchArrayKey]);
            }
           
            $branchCountryIds = $this->Center_location_model->get_branch_country_id_by_branch_id($branchIds);
            $branchCountryIds = join(",",$branchCountryIds);

            if($countryIds == $branchCountryIds) {
                echo 1;
            }
        }
    }
   
    function ajax_get_selected_branch(){ 
   
        $products    = $this->input->post('products');
        $country_id  = $this->input->post('country_id');
        $divisionId[]  = $this->input->post('division_id');

        if(isset($products)){            
            $userBranch            = [];
            $response['testtypes'] =  $this->Discount_model->get_all_test_module_active_by_country_product_base($country_id,$products);
            
            if($products == 4 || $products == 5) {
                $response['result']     = 4;
                $response['centers']    = $this->Center_location_model->getBranchesByDivisions($divisionId,true);
                echo json_encode($response);
            /* } else if($products==5) {
                $response['result']     = 2;
                echo json_encode($response); */
            } else if($products==2  || $products==3) {
                $response['result']     = 2;
                $response['centers']    = $this->Center_location_model->getFunctionalBranchByCountry($country_id,$_SESSION['roleName'],$userBranch);
                echo json_encode($response);
            }  else if($products==1) {
                $response['result']     = 3;
                $response['centers']    = $this->Center_location_model->getFunctionalBranchByCountry($country_id,$_SESSION['roleName'],$userBranch);
                echo json_encode($response);
            } else {
                $userBranch=[];
                $response['result']     = 0;
                $response['centers']    = $this->Center_location_model->getFunctionalBranchByCountry($country_id,$_SESSION['roleName'],$userBranch);
                echo json_encode($response);
            }
            
            /* if($products == 1) {
                $response['result'] = 3;
                $response['centers'] = $this->Center_location_model->getFunctionalBranchByCountry($country_id,$_SESSION['roleName'],$userBranch);
                echo json_encode($response);
            }
            else if($products == 2  || $products == 3 || $products == 4 || $products == 5) {
                $response['result']     = 3;
                $response['centers']    = $this->Center_location_model->getFunctionalBranchByCountry($country_id,$_SESSION['roleName'],$userBranch);
                if($response['centers']) {
                    $countCenters                                       = count($response['centers']);
                    $response['centers'][$countCenters]['center_id']    = ONLINE_BRANCH_ID;
                    $response['centers'][$countCenters]['center_name']  = 'Online';
                }
                echo json_encode($response);
            } else {
                $response['result']     = 0;
                $response['centers']    = $this->Center_location_model->getFunctionalBranchByCountry($country_id,$_SESSION['roleName'],$userBranch);
                echo json_encode($response);
            } */	

        }else{
            header('Content-Type: application/json');
            //$response = ['msg'=>'list not available!', 'status'=>'false'];
            $response['result'] = 0;
            echo json_encode($response);
        } 
   
   }   
   
    function ajax_get_testype_by_packandbranch(){ 
   
        $products = $this->input->post('products');
    	$branches = $this->input->post('branches');
    	$testtype = $this->input->post('testtype');
    	$min_purchase_value = $this->input->post('min_purchase_value');
	
	 if(isset($products) && isset($branches) && isset($testtype)){            
            //$response =  $this->Discount_model->get_discount_currency_code($country_id);
			if($products==4) {
			    $response['result'] = 1;
			    echo json_encode($response);
			} else if($products == 5) {
                $response['result'] = 1;
                echo json_encode($response);
            } else if($products==2) {
                $response['result'] = 2;
                $response['package'] = $this->Discount_model->get_online_package_by_testtype($testtype,$min_purchase_value);
			    echo json_encode($response);
			} else if($products==3) {
                $response['result'] = 2;
                $response['package'] = $this->Discount_model->get_package_list_by_testtype($testtype,$min_purchase_value);
			    echo json_encode($response);
			}  else if($products==1) {
                $response['result'] = 3;
                $response['package'] = $this->Discount_model->get_offline_package_by_testtype($testtype,$min_purchase_value,$branches,"");
			    echo json_encode($response);
			} else {
                $userBranch=[];
                $response['result'] = 0;
                $response['package'] = $this->Center_location_model->getFunctionalBranch($_SESSION['roleName'],$userBranch);
			    echo json_encode($response);
			}
			
			
           
        }else{
            header('Content-Type: application/json');
            //$response = ['msg'=>'list not available!', 'status'=>'false'];
			$response['result'] = 0;
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
        
        $current_DateTime = date("Y-m-d G:i A");
        $current_DateTimeStr = strtotime($current_DateTime);
        $this->Discount_model->deactivate_discount($current_DateTimeStr);

        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }

        $data['title'] = 'New Discount Code';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('country_type','Country Type','required');
        $this->form_validation->set_rules('country_id[]','Country','required|numeric');

        if($this->input->post("country_type") == 'single') {
            $this->form_validation->set_rules('country_currency','Country Currency','required');
        }

		$this->form_validation->set_rules('start_date','Start Date','required');
		$this->form_validation->set_rules('start_time','Start Time','required');
		$this->form_validation->set_rules('end_date','End Date','required');
		$this->form_validation->set_rules('end_time','End Time','required');		
        $this->form_validation->set_rules('disc_name','Name','required|trim');
        $this->form_validation->set_rules('type_of_discount','Type of Discount Code','required');
		$this->form_validation->set_rules('discount_type','Discount Type','required');
		$this->form_validation->set_rules('max_discount','Max Discount','required');
		$this->form_validation->set_rules('user_per_code','Uses per Code','required');
		$this->form_validation->set_rules('uses_per_user','Uses per User','required');
        
        $this->form_validation->set_rules('discount_division_id','Division','required');
		$this->form_validation->set_rules('appliedProducts','Applied to Products','required');
		//$this->form_validation->set_rules('appliedBranches[]','Applied to Branches','required');	

		if(!empty($this->input->post('type_of_discount')) && $this->input->post('type_of_discount')=="Special") {
		if($this->input->post('btnCheck')=="1") {
		$this->form_validation->set_rules('schedule_date','Schedule Date','required');
		$this->form_validation->set_rules('schedule_time','Schedule Time','required');
		}
		// && empty($_FILES['upfile'])
		if(empty($this->input->post('phoneNumber')) && empty($this->input->post('bemail'))) {
		$this->form_validation->set_rules('phoneNumber','Phone Number','required');
		//$this->form_validation->set_rules('bemail','Email','required');
		}
		

		}
		
		if(isset($_POST)) {
            // pr($this->input->post('country_id'));
            // exit;
        }
		
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
			
			$discount_code="";
			$uniqueDiscCode="";
			
			if(!empty($this->input->post('isAuto')) && $this->input->post('isAuto')==1) {
					if(!empty($this->input->post('disCharacter'))) {	
					$length=$this->input->post('disCharacter');
					$uniqueDiscCode = $this->getUnicode_($length);						
					} else {
					$uniqueDiscCode = $this->getUnicode_(6);	
					}
			
			} else {
			$uniqueDiscCode = $this->getUnicode_(6);
			}
			
			
				if(!empty($this->input->post('disPrefix'))) {
						$disPrefix=$this->input->post('disPrefix');
						$disPrefix = $disPrefix."-";
					}
					
					
					
					if(!empty($this->input->post('disSuffix'))) {
					
						$disSuffix=$this->input->post('disSuffix');
						$disSuffix= "-".$disSuffix;
					
					}
					

			$discount_code=strtoupper($disPrefix.$uniqueDiscCode.$disSuffix);
				

			
			if(!empty($this->input->post('disc_manual'))){
			$discount_code=strtoupper($this->input->post('disc_manual'));			
			}
			


		if(!empty($this->input->post('type_of_discount')) && $this->input->post('type_of_discount')=="Bulk") {
		$discount_code="";

		}
		
		if(!empty($this->input->post('type_of_discount')) && $this->input->post('type_of_discount')=="Special") {
		$discount_code=$discount_code;
	
		}
		
        if($this->input->post('btnCheck')=="1") {
        $isSchedule=1;
        $active=2;
        } else {
        $isSchedule=0;
        $active=1;
        }

			$products=$this->input->post('appliedProducts');
            $appliedBranches=implode(",",$this->input->post('appliedBranches'));
			
            
 			/* if($products==2) {
			    $package = $this->Discount_model->get_online_package_by_testtype($this->input->post('appliedTestType'),$this->input->post('min_purchase_value'));
			    //$appliedBranches=ONLINE_BRANCH_ID;
                $appliedBranches=implode(",",$this->input->post('appliedBranches'));
			} else if($products==3) {
			    $package = $this->Discount_model->get_package_list_by_testtype($this->input->post('appliedTestType'),$this->input->post('min_purchase_value'));
			    //$appliedBranches=ONLINE_BRANCH_ID;
                $appliedBranches=implode(",",$this->input->post('appliedBranches'));
			}  else if($products==1) {
			    $package = $this->Discount_model->get_offline_package_by_testtype($this->input->post('appliedTestType'),$this->input->post('min_purchase_value'),$this->input->post('appliedBranches'),"");
			    $appliedBranches=implode(",",$this->input->post('appliedBranches'));
			} else {
			    $appliedBranches=implode(",",$this->input->post('appliedBranches'));
			} */
			

            /*$totalPack=count($this->input->post('appliedPackages'));
            if(count($package)==$totalPack) {
            $appliedPackages="";
            } else {*/
            $appliedPackages=implode(",",$this->input->post('appliedPackages'));
            //}

            //$testtypes=$this->Test_module_model->get_all_test_module_active(); 
            //$totaltestype=count($this->input->post('appliedTestType'));

            /*if(count($testtypes)==$totaltestype) {
            $appliedTestType="";
            } else {*/
            $appliedTestType=implode(",",$this->input->post('appliedTestType'));
            //}



            //echo count($package)."--".$totalPack;
		    //die();	
            $params = array(				
				'by_user' => $by_user,//for who
                'division_id' => $this->input->post('discount_division_id'),
                'country_id' => $this->input->post('country_id'),//type
				'start_date' => date('Y-m-d',strtotime($this->input->post('start_date'))),  //to whom              
                'start_time' => $this->input->post('start_time'),
				'strDate' => strtotime($this->input->post('start_date')." ".$this->input->post('start_time')),
                'end_date' => date('Y-m-d',strtotime($this->input->post('end_date'))),
                'end_time' => $this->input->post('end_time'),
				'strEndDate' => strtotime($this->input->post('end_date')." ".$this->input->post('end_time')),
				'disc_name' => $this->input->post('disc_name'),
				'type_of_discount' => $this->input->post('type_of_discount'),
				'discount_type' => $this->input->post('discount_type'),
				'max_discount' => $this->input->post('max_discount'),
				'not_exceeding' => $this->input->post('not_exceeding'),
				'min_purchase_value' => $this->input->post('min_purchase_value'),
				'user_per_code' => $this->input->post('user_per_code'),
				'uses_per_user' => $this->input->post('uses_per_user'),
				'remaining_uses' => $this->input->post('user_per_code'),
				'appliedProducts' => $this->input->post('appliedProducts'),
				'appliedBranches' => $appliedBranches,
				'appliedTestType' => $appliedTestType,
				'appliedPackages' => $appliedPackages,
				'isAuto' => $this->input->post('isAuto'),
				'disCharacter' => $this->input->post('disCharacter'),
				'disPrefix' => $this->input->post('disPrefix'),
				'disSuffix' => $this->input->post('disSuffix'),
				'disc_manual' => $this->input->post('disc_manual'),
				'discount_code' => $discount_code,
				'no_of_codes' => $this->input->post('no_of_codes'),
				'template_description' => $this->input->post('template_description'),
				'country_code' => $this->input->post('country_code'),
				'phoneNumber' => ltrim($this->input->post('phoneNumber'), '0'),
				'email' => $this->input->post('bemail'),
				'is_schedule' => $isSchedule,
				'active' => $active,
				'schedule_date' => date('Y-m-d',strtotime($this->input->post('schedule_date'))),
				'schedule_time' => $this->input->post('schedule_time'),
                'currency_code' => $this->input->post("countryCurrency"),
				'created_on' => date('Y-m-d'),
            );	
			
            $id = $this->Discount_model->add_discount_b($params);
            if($id and $id!='duplicate'){
            $phone=ltrim($this->input->post('phoneNumber'), '0');
            if(!empty($this->input->post('type_of_discount')) && $this->input->post('type_of_discount')=="Special") {
            	if(!empty($phone)) {
                
            //SMS here

                $mobile = $phone;
                $message = 'Hi! Here is your discount code - '.$discount_code;
				if(base_url()!=BASEURL){
               // $this->call_smaGateway($mobile,$message);
                }
                }
                if(!empty($this->input->post('bemail'))) {
                
                 if(base_url()!=BASEURL){
                        
                        $subject = "Hi, Discount Code generated by Team WOSA";
                        $email_message='Your Discount is: '.$discount_code.' ';
                        $mailData=[]; 
                        //$mailData['fname']         = $request_data['fname'];
                        $mailData['email']         = $this->input->post('bemail');
                        $mailData['email_message'] = $email_message;
                        $mailData['thanks']        = THANKS;
                        $mailData['team']          = WOSA;               
                        $this->sendEmailTo_discount($subject,$mailData);
                    }
                
                }
			}
			
			if(!empty($this->input->post('range_from')) && !empty($this->input->post('range_to')) && !empty($this->input->post('range_discount'))) {
			
			$totalRanges = count($this->input->post('range_from'));
			
				for($i=0;$i<=$totalRanges;$i++) {
				if(!empty($this->input->post('range_from')[$i]) && !empty($this->input->post('range_to')[$i]) && !empty($this->input->post('range_discount')[$i])) {
				$paramsR = array(				
                'discount_id' => $id,
				'range_from' => $this->input->post('range_from')[$i],
				'range_to' => $this->input->post('range_to')[$i],
				'range_discount' => $this->input->post('range_discount')[$i]
				
            	);
				$rid = $this->Discount_model->add_range_discount($paramsR);
				
				}
				
				}
			
			
			}
				
			
			
				if(!empty($this->input->post('type_of_discount')) && $this->input->post('type_of_discount')=="Bulk") {
				$discount_code="";
				for($i=1;$i<=intval($this->input->post('no_of_codes'));$i++) {
				if(!empty($this->input->post('isAuto')) && $this->input->post('isAuto')==1) {
						if(!empty($this->input->post('disCharacter'))) {	
						$length=$this->input->post('disCharacter');
						$uniqueDiscCode = $this->getUnicode_($length);						
						} else {
						$uniqueDiscCode = $this->getUnicode_(6);	
						}
				
				} else {
				$uniqueDiscCode = $this->getUnicode_(6);
				}
				
				$disc_bulk = strtoupper($disPrefix.$uniqueDiscCode.$disSuffix);
				
				$params1 = array(				
                'discount_id' => $id,
				'discount_code' => $disc_bulk,
            	);
				
				$bid = $this->Discount_model->add_bulk_discount($params1);
				}	
				}
			
                //activity update start              
                    $activity_name= PROMOCODE_ADD;
                    $description='New promocode named as '.$params['disc_name'].' with code '.$discount_code.' added';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG); 

				if(!empty($this->input->post('type_of_discount')) && $this->input->post('type_of_discount')=="General") {                 
                redirect('adminController/discount/index');
				}
				if(!empty($this->input->post('type_of_discount')) && $this->input->post('type_of_discount')=="Special") {                 
                redirect('adminController/discount/special');
				}
				if(!empty($this->input->post('type_of_discount')) && $this->input->post('type_of_discount')=="Bulk") {                 
                redirect('adminController/discount/bulk');
				}
            }elseif($id=='duplicate'){
                $this->session->set_flashdata('flsh_msg', DUP_MSG);                   
                redirect('adminController/discount/add');
            }
            else{                    
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/discount/add');
            } 
            
        }else{
            $uniqueActiveRealtyTestTypesArray   = array();		
            $allActiveRealtyPackages            = $this->Realty_test_model->searchRealityTest(array('status'=>1));

            if($allActiveRealtyPackages) {
                $uniqueActiveTestTypes = array_unique(array_map(function($elem){
                    return $elem['test_module_id']."|".$elem['test_module_name'];}, $allActiveRealtyPackages)
                );
                
                if($uniqueActiveTestTypes) {
                    $number = 0;
                    foreach($uniqueActiveTestTypes as $value) {
                        $valueArray = explode("|",$value);
                        if(is_array($valueArray) && !empty($valueArray)) {
                            $uniqueActiveRealtyTestTypesArray[$number]["test_module_id"] = $valueArray[0];
                            $uniqueActiveRealtyTestTypesArray[$number]["test_module_name"] = $valueArray[1];
                        }
                        $number++;
                    }
                }
            }
            
            $data['all_realty_active_test_types']   = json_encode($uniqueActiveRealtyTestTypesArray);
            $data['all_division']                   = $this->Division_master_model->get_all_division_active();
    		$data['all_country_code']               = $this->Country_model->get_country_code();
    		$data['all_country_currency_code']      = $this->Discount_model->get_all_discount_country();
            //$data['all_country_currency_code']    = $this->Discount_model->get_all_discount_country_with_active_branches();
    		$data['all_testtype_list']              = $this->Test_module_model->get_all_test_module_active(); 
    		$data['all_time_slots']                 = $this->Time_slot_model->get_all_time_slots();		 
		    $data['all_branch']                     = $this->Center_location_model->getFunctionalBranch($_SESSION['roleName'],$userBranch);                        
            $data['_view']                          = 'discount/add';
            $this->load->view('layouts/main',$data);
        }
    }
	
    function ajax_get_products_according_to_division_id() {
        if(!empty($this->input->post('division_id'))) {
            $divisionId     = $this->input->post('division_id');
            $productsArray  = productList();

            if($productsArray) {
                $divisionProducts = $productsArray[$divisionId];

                $html ='<option value="">Select Product</option>';
                foreach($divisionProducts as $ky=>$kpro) {
                    $html .='<option value="'.($kpro['id']).'">'.$kpro['name'].'</option>';
                }
            }
            echo  json_encode($html);
        }
    }
	
	function ajax_add_bulk_code(){   
	
		if(!empty($this->input->post('no_of_codes'))){
    		$discount_code  = "";
    		$uniqueDiscCode = "";
            $disPrefix      = "";
            $disSuffix      = "";
            $promoCodeId    = $this->input->post('discount_id');

            $getPromocodeDetailedArray  = $this->Discount_model->getPromocode($promoCodeId);
            
            if(isset($getPromocodeDetailedArray['disPrefix']) && !empty($getPromocodeDetailedArray['disPrefix'])) {
                $disPrefix  = $getPromocodeDetailedArray['disPrefix'];
                $disPrefix  = $disPrefix."-";
            }
        
            if(isset($getPromocodeDetailedArray['disSuffix']) && !empty($getPromocodeDetailedArray['disSuffix'])) {
                $disSuffix  = $getPromocodeDetailedArray['disSuffix'];
                $disSuffix  = "-".$disSuffix;
            }
        
    		for($i=1;$i<=intval($this->input->post('no_of_codes'));$i++){		
    		    $uniqueDiscCode = $this->getUnicode_(6);
                $uniqueDiscCode = strtoupper($disPrefix.$uniqueDiscCode.$disSuffix);
    			$params1 = array(				
    				'discount_id'   => $promoCodeId,
    				'discount_code' => strtoupper($uniqueDiscCode),
    				);				
    				$bid = $this->Discount_model->add_bulk_discount($params1);
    		}		
    		echo $bid;		
		}	
	}    
    
    function ajax_edit_dates(){

        $by_user=$_SESSION['UserId'];   
        
        $params1 = array(               
            'start_date' => date('Y-m-d',strtotime($this->input->post('start_date'))),  //to whom              
            'start_time' => $this->input->post('start_time'),
            'strDate' => strtotime($this->input->post('start_date')." ".$this->input->post('start_time')),
            'end_date' => date('Y-m-d',strtotime($this->input->post('end_date'))),
            'end_time' => $this->input->post('end_time'),
            'strEndDate' => strtotime($this->input->post('end_date')." ".$this->input->post('end_time')),
        ); 
        $promoDetals = $this->Discount_model->getDiscountDetails($this->input->post('discount_id'));
        $oldDetais = 'Discount code '.$promoDetals['discount_code'].' having details as '.$promoDetals['start_date'].' '.$promoDetals['start_time'].'-'.$promoDetals['end_date'].' '.$promoDetals['start_time'].' updated to '.$params1['start_date'].' '.$params1['start_time'].'-'.$params1['end_date'].' '.$params1['start_time'].'';

        $bid = $this->Discount_model->edit_dates_discount($this->input->post('discount_id'),$params1);
                
        //activity update start              
            $activity_name= PROMOCODE_DATE_UPDATE;
            $description= ''.$oldDetais.'';
            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
        //activity update end
        echo $bid;
    }
	
	
	function edit($discount_id){  

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Edit Discount';
		
        $data['discount_details'] = $this->Discount_model->get_discount($discount_id);
		$data['discount_range_details'] = $this->Discount_model->get_range_discount($discount_id);
       
        if(isset($data['discount_details']['id']))
        {
            $this->load->library('form_validation');
			//$this->form_validation->set_rules('country_id','Country','required');
		$this->form_validation->set_rules('start_date','Start Date','required');
		$this->form_validation->set_rules('start_time','Start Time','required');
		
		$this->form_validation->set_rules('end_date','End Date','required');
		$this->form_validation->set_rules('end_time','End Time','required');		
        $this->form_validation->set_rules('disc_name','Name','required|trim');
        $this->form_validation->set_rules('type_of_discount','Type of Discount Code','required');
		

		$this->form_validation->set_rules('discount_type','Discount Type','required');
		$this->form_validation->set_rules('max_discount','Max Discount','required');
		

		$this->form_validation->set_rules('user_per_code','Uses per Code','required');
		$this->form_validation->set_rules('uses_per_user','Uses per User','required');
		
		$this->form_validation->set_rules('appliedProducts','Applied to Products','required');
		//$this->form_validation->set_rules('appliedBranches[]','Applied to Branches','required');
		
		
	
		
		//$upfiles = $_FILES['upfile'];
	
		if(!empty($this->input->post('type_of_discount')) && $this->input->post('type_of_discount')=="Special") {
		if($this->input->post('btnCheck')=="1") {
		$this->form_validation->set_rules('schedule_date','Schedule Date','required');
		$this->form_validation->set_rules('schedule_time','Schedule Time','required');
		}
		// && empty($_FILES['upfile'])
		if(empty($this->input->post('phoneNumber')) && empty($this->input->post('bemail'))) {
		$this->form_validation->set_rules('phoneNumber','Phone Number','required');
		//$this->form_validation->set_rules('bemail','Email','required');
		}
		
		
		
		}
		
		/*if(!empty($this->input->post('type_of_discount')) && $this->input->post('type_of_discount')=="Template") {
		$this->form_validation->set_rules('template_description','Template','required|trim');
		}*/
			
			if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
				
				$discount_code="";
				$uniqueDiscCode="";
				
				if(!empty($this->input->post('isAuto')) && $this->input->post('isAuto')==1) {
					if(!empty($this->input->post('disCharacter'))) {	
					$length=$this->input->post('disCharacter');
					$uniqueDiscCode = $this->getUnicode_($length);						
					} else {
					$uniqueDiscCode = $this->getUnicode_(6);	
					}
			
			} else {
			$uniqueDiscCode = $this->getUnicode_(6);
			}
			
					if(!empty($this->input->post('disPrefix'))) {
						$disPrefix=$this->input->post('disPrefix');
						$disPrefix = $disPrefix."-";
					}
				
					if(!empty($this->input->post('disSuffix'))) {
					
						$disSuffix=$this->input->post('disSuffix');
						$disSuffix= "-".$disSuffix;
					
					}
					
				$discount_code=strtoupper($disPrefix.$uniqueDiscCode.$disSuffix);
				
				
			if(!empty($this->input->post('disc_manual'))){
			$discount_code=strtoupper($this->input->post('disc_manual'));			
			}
			


		if(!empty($this->input->post('type_of_discount')) && $this->input->post('type_of_discount')=="Bulk") {
		$discount_code="";
		}
		
		if(!empty($this->input->post('type_of_discount')) && $this->input->post('type_of_discount')=="Special") {
		$discount_code=$discount_code;
	
		}
		
			if($this->input->post('btnCheck')=="1") {
			$isSchedule=1;
			$active=2;
			} else {
			$isSchedule=0;
			$active=1;
			}
				
				
			$params = array(				
				//'user_id' => $by_user,//for who
                'country_id' => $this->input->post('country_id'),//type
				'start_date' => date('Y-m-d',strtotime($this->input->post('start_date'))),  //to whom              
                'start_time' => $this->input->post('start_time'),
                'end_date' => date('Y-m-d',strtotime($this->input->post('end_date'))),
                'end_time' => $this->input->post('end_time'),
				'disc_name' => $this->input->post('disc_name'),
				'type_of_discount' => $this->input->post('type_of_discount'),
				'discount_type' => $this->input->post('discount_type'),
				'max_discount' => $this->input->post('max_discount'),
				'not_exceeding' => $this->input->post('not_exceeding'),
				'min_purchase_value' => $this->input->post('min_purchase_value'),
				'user_per_code' => $this->input->post('user_per_code'),
				'uses_per_user' => $this->input->post('uses_per_user'),
				'appliedProducts' => $this->input->post('appliedProducts'),
				'appliedBranches' => implode(",",$this->input->post('appliedBranches')),
				'appliedTestType' => implode(",",$this->input->post('appliedTestType')),
				'appliedPackages' => implode(",",$this->input->post('appliedPackages')),
				'isAuto' => $this->input->post('isAuto'),
				'disCharacter' => $this->input->post('disCharacter'),
				'disPrefix' => $this->input->post('disPrefix'),
				'disSuffix' => $this->input->post('disSuffix'),
				'disc_manual' => $this->input->post('disc_manual'),
				'discount_code' => $discount_code,
				'no_of_codes' => $this->input->post('no_of_codes'),
				'template_description' => $this->input->post('template_description'),
				'country_code' => $this->input->post('country_code'),
				'phoneNumber' => ltrim($this->input->post('phoneNumber'), '0'),
				'email' => $this->input->post('email'),
				'is_schedule' => $isSchedule,
				'active' => $active,
				'schedule_date' => date('Y-m-d',strtotime($this->input->post('schedule_date'))),
				'schedule_time' => $this->input->post('schedule_time'),
				//'created_on' => date('Y-m-d'),
            );   
			
                $id = $this->Programe_master_model->update_programe_master($programe_id,$params);
				
				
				
                if($id){
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/programe_master/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/programe_master/edit/'.$programe_id);
                }  

            }
            else
            {
			$data['all_country_list'] = $this->Country_model->get_all_country_active();
		 $data['all_country_code'] = $this->Country_model->get_all_country_active();
		$data['all_country_currency_code'] = $this->Discount_model->get_all_discount_country();
		$data['all_testtype_list'] = $this->Test_module_model->get_all_test_module_active(); 
		$data['all_time_slots'] = $this->Time_slot_model->get_all_time_slots();
		 
		$data['all_branch'] = $this->Center_location_model->getFunctionalBranch($_SESSION['roleName'],$userBranch);
		
                $data['_view'] = 'discount/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
	
	
	 function ajax_getDiscountDetailView(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $by_user=$_SESSION['UserId'];    
        //access control ends
        $discount_id    = $this->input->post('discount_id', true);
        $discountData   = $this->Discount_model->getDiscountDetails($discount_id);
        $remainingUses  = $discountData['remaining_uses']; 
        $numberOfCodes  = '';

        $x = '<h3 class="text-danger">'.$discountData['disc_name'].'</h3>
        <div class="box-body table-responsive">';
		if($discountData['type_of_discount']=="Bulk") {
		    $x .= '<div style="float:right"><a href="'.site_url('adminController/discount/ajax_download_csv_bulk/'.$discountData['id']).'" class="btn btn-success btn-sm">Download CSV</a></div>';
            $remainingUses  = $this->Discount_model->getBulkRemainingPromocodeCountByPromocodeId($discount_id);
            $numberOfCodes  = $this->Discount_model->getBulkRemainingPromocodeCountByPromocodeId($discount_id,true);
		}
                $x .= '<table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>                        
                        <th>Created On</th>
                        <th>Discount Type</th>
                        <th>Not Exceeding</th>
                        <th>Min Purchase</th>
                        <th>Uses Per Code</th>
                        <th>Uses Per User</th>
                        <th>Remaining</th>';
						if($discountData['type_of_discount']=="Bulk") {
						$x .= '<th>Number of Codes</th>';
						}
                    $x .= '</tr>
                </thead>
                <tbody id="myTable">';
                    $notExeeding = 'N/A';
                    if($discountData['discount_type'] == 'Percentage') {
                        $notExeeding = $discountData['not_exceeding'].' '.$discountData['currency_code'];
                    }
                    
                    $y .= '<tr>                        
                        <td>'.date('d-m-Y',strtotime($discountData['created_on'])).'</td>     
                        <td>'.$discountData['discount_type'].'</td> 
                        <td>'.$notExeeding.'</td>
                        <td>'.$discountData['min_purchase_value'].' '.$discountData['currency_code'].'</td>
                        <td>'.$discountData['user_per_code'].'</td>
                        <td>'.$discountData['uses_per_user'].'</td>
                        <td>'.$remainingUses.'</td> ';
					if($discountData['type_of_discount']=="Bulk") {
                        $y .= '<td>'.$numberOfCodes.'</td>';
				    }
				   if($discountData['type_of_discount']!="Bulk") {
				   $y .= '<td><a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="CopyToClipboard(\''.$discountData['discount_code'].'\',true,\'Discount code copied\')">Copy Code</a></td>';
					}
                    $y .= '</tr>';
           
                   
                   
        $z = '</tbody></table>';
		if($discountData['type_of_discount']=="Special") {
		 $z.= '<Br><Br>
		<h4 class="text-danger">Assigned to Phone</h3>
		<div>'.$discountData['phoneNumber'].'</div><Br><Br>
		<h4 class="text-danger">Assigned to Email</h3>
		<div>'.$discountData['email'].'</div>';
		}
         $z.= '</div>';

        $resp=$x.$y.$z;
        header('Content-Type: application/json');
        $response = ['msg'=>$resp, 'status'=>'true'];
        echo json_encode($response);
     }
	
	
	function ajax_getAddMoreCode(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $by_user=$_SESSION['UserId'];     
        //access control ends
        $discount_id = $this->input->post('discount_id', true);
        //$discountData = $this->Discount_model->getDiscountDetails($discount_id);

        $x = '<h3 class="text-danger">'.$discountData['disc_name'].'</h3>
        <div class="box-body table-responsive">'.form_open_multipart('adminController/discount/index', array('id' => 'frmBDiscount'));

                $x .= '<div  id="smsg" style="display:none; color:#006600; font-weight:bold; margin:10px; font-size:14px;"></div><input type="hidden" value="'.$discount_id.'" name="discount_id" id="discount_id"  /><div class="box-body"><div class="row clearfix"><div class="col-md-4">
                    <label for="appliedPackages" class="control-label"><span class="text-danger">*</span>Number of Codes</label>
						<div class="form-group has-feedback">

                       
							<input type="text" name="no_of_codes" value="" class="form-control chknum1" id="no_of_codes" onblur="validate_number_codes(this.value);"  maxlength="5" />
                            <span class="text-danger no_of_codes_err"></span>	
   
     
                        </div>
					</div></div><div class="box-footer">
            	<button type="button" class="btn btn-danger btnCodeAdd">
            		<i class="fa fa-check"></i>'.GENERATE_LABEL.'
            	</button>
                </form>
          	</div> ';
						
           
                   
        $z = '';
		
         $z.= '</div>';

        $resp=$x.$y.$z;
        header('Content-Type: application/json');
        $response = ['msg'=>$resp, 'status'=>'true'];
        echo json_encode($response);
     }
	

	function ajax_editDiscountDates(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $by_user=$_SESSION['UserId'];     
        //access control ends
        $discount_id = $this->input->post('discount_id', true);
        $discountData = $this->Discount_model->getDiscountDetails($discount_id);
        
        $all_time_slots = $this->Time_slot_model->get_all_time_slots();

        $x = '
   
<h3 class="text-danger">'.$discountData['disc_name'].'</h3>

        <div class="box-body table-responsive"><form name="frmDDiscount" method="post" id="frmDDiscount">';

                $x .= '<div  id="smsg" style="display:none; color:#006600; font-weight:bold; margin:10px; font-size:14px;"></div><input type="hidden" value="'.$discount_id.'" name="discount_id" id="discount_id"  /><div class="box-body"><div class="row clearfix"><div class="col-md-6">
						<label for="start_date" class="control-label"><span class="text-danger">*</span> Start Date | Time</label>
                       
						<div class="form-group">
                         <div class="col-md-6" style="padding-left:0px;">
							<input type="text" name="start_date1" value="'.date('d-m-Y',strtotime($discountData['start_date'])).'" autocomplete="off" class="noBackDate form-control" id="start_date1" maxlength="10"/>
							<span class="glyphicon form-control-feedback" style="top: -4px;right: 14px;"><i class="fa fa-birthday-cake"></i></span>
                            <span class="text-danger start_date_err" ></span>
                          </div>';
                         
          
                         $x .= '<div class="col-md-6" > 
                           <select name="start_time1" id="start_time1" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                            
								<option value="">Time</option>';
							 
								foreach($all_time_slots as $b)
								{
									$selected = (($b['time_slot'].' '.$b['type']) == $discountData['start_time']) ? ' selected="selected"' : "";
									$x .= '<option value="'.$b['time_slot'].' '.$b['type'].'" '.$selected.'>'.$b['time_slot'].' '.$b['type'].'</option>';
								} 
						
							$x .= '</select>
							<span class="text-danger start_time_err"></span>
                           
					
                          </div>
                          </div>
                           
                           
					</div>	
                    
                    <div class="col-md-6">
						<label for="end_date" class="control-label"><span class="text-danger">*</span> End Date | Time</label>
						<div class="form-group">
                         <div class="col-md-6" style="padding-left:0px;">
							<input type="text" name="end_date1" value="'.date('d-m-Y',strtotime($discountData['end_date'])).'" class="noBackDate form-control" autocomplete="off" id="end_date1" maxlength="10"/>
							<span class="glyphicon form-control-feedback" style="top: -4px;right: 14px;"><i class="fa fa-birthday-cake"></i></span>
                            <span class="text-danger end_date_err" ></span>
                          </div>
                          <div class="col-md-6"> 
                           <select name="end_time1" id="end_time1" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                            
								<option value="">Time</option>';
							
                          
								foreach($all_time_slots as $b)
								{
									$selected = (($b['time_slot'].' '.$b['type']) == $discountData['end_time']) ? ' selected="selected"' : "";
									$x .= '<option value="'.$b['time_slot'].' '.$b['type'].'" '.$selected.'>'.$b['time_slot'].' '.$b['type'].'</option>';
								} 
							
							$x .= '</select>
							<span class="text-danger end_time_err"></span>
                           
					
                          </div>
                          </div>
					</div>	</div>
                    </form>
                    <div class="box-footer">
            	<button type="submit" class="btn btn-danger btnUpdate">
            		<i class="fa fa-check"></i>'.UPDATE_LABEL.'
            	</button>
                </form>
          	</div> ';
						
           
                   
        $z = '';
		
         $z.= '</div>';

        $resp=$x.$y.$z;
        header('Content-Type: application/json');
        $response = ['msg'=>$resp, 'status'=>'true'];
        echo json_encode($response);
     }	

  function ajax_activate_deactivete_schedule()
    {  
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $id = $this->input->post('id', true);
        $active = $this->input->post('active', true);
        $table = $this->input->post('table', true);
        $pk = $this->input->post('pk', true);


            $id = $this->Discount_model->update_one($id, $active, $table, $pk);
       
        echo $id;       
    }  
	
	
	function ajax_get_product_list() {
	
	$country_id = $this->input->post('country_id');
		
		$products=array("Inhouse pack","Online pack","Practice Pack","Reality Test","Exam Booking");
		$not_india=array(1,2,3,4);
		$in_india=array(0,1,2,3,4);
		$html="";
		if(!empty($country_id) && $country_id!=INDIA_ID) {
		$html.='<option value="">Select Product</option>';
		foreach($products as $ky=>$kpro) {
		if(in_array($ky,$not_india)) {
		$html.='<option value="'.($ky+1).'">'.$kpro.'</option>';
		} 
		}
		}
		if(!empty($country_id) && $country_id==INDIA_ID) {
		$html.='<option value="">Select Product</option>';
		foreach($products as $ky=>$kpro) {
		if((!empty($country_id) && $country_id==INDIA_ID) && in_array($ky,$in_india)) {
		$html.='<option value="'.($ky+1).'">'.$kpro.'</option>';
		}
		}
		}
	
		echo json_encode($html);
	}
    
    function schedule_discount() {
    
    $scheduleList = $this->Discount_model->get_all_schedule_discount();
    $curDateTime = time();
   // echo date('d-m-Y H:i',$curDateTime);
    
    foreach($scheduleList  as $ks=>$ksval) {
    $scheduleDateTime = strtotime($ksval['schedule_date']." ".$ksval['schedule_time']);
    
    $endtime=strtotime($ksval['end_date']." ".$ksval['end_time']);
    
    if($curDateTime>=$scheduleDateTime && $endtime>=$curDateTime) {
    // echo date('d-m-Y H:i',$scheduleDateTime)." ----- ".date('d-m-Y H:i',$curDateTime)."<Br />";
    // die("sdfds");
     		$phone=ltrim($this->input->post('phoneNumber'), '0');
            if(!empty($ksval['type_of_discount']) && $ksval['type_of_discount']=="Special") {
            	if(!empty($phone)) {
                
            	//SMS here

                $mobile = $phone;
                $message = 'Hi! Here is your discount code - '.$discount_code;
				if(base_url()!=BASEURL){
              //  $this->call_smaGateway($mobile,$message);
                }
                }
                
                //Email
                if(!empty($ksval['email'])) {
                
                 if(base_url()!=BASEURL){
                        
                        $subject = "Hi, Discount Code generated by Team WOSA";
                        $email_message='Your Discount is: '.$ksval['discount_code'].' ';
                        $mailData=[]; 
                        //$mailData['fname']         = $request_data['fname'];
                        $mailData['email']         = $ksval['email'];
                        $mailData['email_message'] = $email_message;
                        $mailData['thanks']        = THANKS;
                        $mailData['team']          = WOSA;               
                        $ok = $this->sendEmailTo_discount($subject,$mailData);
						/*if($ok) {
							echo "s";
						} else {
							echo "n";
						}*/
                    }
                
                }
			}
     
     }

    }
    
   // print_r($scheduleList);
    
    
    }
    
	
	function ajax_download_csv_bulk($discount_id) {
	
	
	$delimiter = ",";
		//$filename = "members_" . date('Y-m-d') . ".csv";
		
		$bulklist=$this->Discount_model->get_all_discount_bulk_csv($discount_id);
		
		$filename="bulklist";
		$filename = $filename."_".date('m-d-Y') . ".csv";	
		
		//create a file pointer
		$f = fopen('php://memory', 'w');
		
		//set column headers
		$fields = array('Sr No.','Discount Name','Code');
		
		fputcsv($f, $fields, $delimiter);
		$i=1;
		foreach($bulklist as $key => $blkv) {
		
		$lineData = array($i,$blkv['disc_name'], $blkv['discount_code']);
		
        fputcsv($f, $lineData, $delimiter);
		$i++;
		}
		
		fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
	exit;	
	}

	
	function ajax_getApplicablePromocode(){

        $generalPromoCodes=[];
        $speacialPromoCodes=[];
        
        date_default_timezone_set(TIME_ZONE);
        $currentTime = date("h:i");
        $today=date('Y-m-d');
        $currentDateTime = $today." ".$currentTime;
        $currentDateTimeStr = strtotime($currentDateTime);

        $student_id = $this->input->post('student_id', true);
        $selectedPackType = $this->input->post('selectedPackType', true);
        $package_id = $this->input->post('package_id', true);
        
        //get special code start
        $stdInfo=$this->Student_model->get_student_info_forSMS($student_id);
        $email = $stdInfo['email'];
        $mobile = $stdInfo['mobile'];       
        

        if($selectedPackType=='offline' or $selectedPackType=='online'){

            if($selectedPackType=='offline'){
                
                $appliedProducts=1;
                $discountField = 'other_discount_off';
                
                $packInfo = $this->Package_master_model->getPackInfo_forPromocode($package_id);
                $center_id = $packInfo['center_id'];
                if($center_id){
                    $countryData = $this->Country_model->getCountry($center_id); 
                    $country_id = $countryData['country_id'];   
                }else{
                    $country_id = NULL;
                    $center_id = NULL;
                }
                
                $test_module_id = $packInfo['test_module_id'];
                $packPrice = $packInfo['discounted_amount'];
                $active = $packInfo['active'];
                $type_of_discount='Special';

            }else if($selectedPackType=='online'){
                $appliedProducts=2;
                $discountField = 'other_discount';

                $packInfo = $this->Package_master_model->getPackInfo_forPromocode($package_id);
                $center_id = $packInfo['center_id'];
                /*if($center_id){
                    $countryData = $this->Country_model->getCountry($center_id); 
                    $country_id = $countryData['country_id'];   
                }else{
                    $country_id = NULL;
                    $center_id = NULL;
                }*/
                $country_id = $stdInfo['country_id']; 
                
                $test_module_id = $packInfo['test_module_id'];
                $packPrice = $packInfo['discounted_amount'];
                $active = $packInfo['active'];
                $type_of_discount='Special';
            }else{
                $appliedProducts=0;
            }

        }else if($selectedPackType=='pp'){  
            $appliedProducts=3;
            $discountField = 'other_discount_pp';

            $packInfo = $this->Practice_package_model->getPackInfo_forPromocode($package_id);
            $center_id = $packInfo['center_id'];
                /*if($center_id){
                    $countryData = $this->Country_model->getCountry($center_id); 
                    $country_id = $countryData['country_id'];   
                }else{
                    $country_id = NULL;
                    $center_id = NULL;
                }*/
                $country_id = $stdInfo['country_id'];
                
                $test_module_id = $packInfo['test_module_id'];
                $packPrice = $packInfo['discounted_amount'];
                $active = $packInfo['active'];
                $type_of_discount='Special';

        }else if($selectedPackType=='rt'){  
            
            $appliedProducts=4;   
            $discountField = 'other_discount_rt';
            $packInfo = $this->Realty_test_model->getPackInfo_forPromocode($package_id);
            $test_module_id = $packInfo['test_module_id'];
            $packPrice = $packInfo['amount'];
            $active = $packInfo['active'];
            $type_of_discount='Special';

        }else if($selectedPackType=='eb'){  
            
            $appliedProducts=5;   
            $discountField = 'other_discount_pbf';
            $packInfo = $this->Exam_master_model->getPackInfo_forPromocode($package_id);
            $test_module_id = $packInfo['test_module_id'];
            $programe_id = $packInfo['programe_id'];
            $active = $packInfo['active'];
            $examFee = $this->Exam_master_model->getExamFee($test_module_id,$programe_id);
            $packPrice = $examFee['exam_fee'];            
            $type_of_discount='Special';

        }else{  
            $appliedProducts=0;   
            $discountField = 'Nill';          
            $speacialPromoCodes = [];
        }

        if($selectedPackType!='rt' and $selectedPackType!='eb'){
            $speacialPromoCodes=$this->Discount_model->getApplicableSpecialPromocode($package_id,$type_of_discount,$appliedProducts,$center_id,$country_id,$test_module_id,$packPrice,$email,$mobile,$currentDateTimeStr);
        }else if($selectedPackType=='rt'){
            $speacialPromoCodes=$this->Discount_model->getApplicableSpecialPromocode_rt($package_id,$type_of_discount,$appliedProducts,$test_module_id,$packPrice,$email,$mobile,$currentDateTimeStr);
        }else if($selectedPackType=='eb'){
            $speacialPromoCodes=$this->Discount_model->getApplicableSpecialPromocode_eb($type_of_discount,$appliedProducts,$test_module_id,$packPrice,$email,$mobile,$currentDateTimeStr);
        }else{
            $speacialPromoCodes=[];
        }       
        //get special code END

        //get general code start
        if($selectedPackType=='offline' or $selectedPackType=='online'){

            if($selectedPackType=='offline'){
                $appliedProducts=1;
                $discountField = 'other_discount_off';
            }else if($selectedPackType=='online'){
                $appliedProducts=2;
                $discountField = 'other_discount';
            }else{
                $appliedProducts=0;
            }                    
            
            $packInfo = $this->Package_master_model->getPackInfo_forPromocode($package_id);
            $center_id = $packInfo['center_id'];
            $countryData = $this->Country_model->getCountry($center_id); 
            $country_id = $countryData['country_id']; 
            $test_module_id = $packInfo['test_module_id'];
            $packPrice = $packInfo['discounted_amount'];
            $active = $packInfo['active'];
            $type_of_discount='General';
            //get general code
            if(!empty($packInfo) and $active==1 and $selectedPackType=='offline'){
                $generalPromoCodes = $this->Discount_model->getApplicableGeneralPromocode_forOffline($package_id,$type_of_discount,$appliedProducts,$center_id,$country_id,$test_module_id,$packPrice,$currentDateTimeStr);
            }elseif(!empty($packInfo) and $active==1 and $selectedPackType=='online'){
                $country_id = $stdInfo['country_id'];
                $generalPromoCodes = $this->Discount_model->getApplicableGeneralPromocode_forOnline($package_id,$type_of_discount,$appliedProducts,$center_id,$test_module_id,$packPrice,$currentDateTimeStr);
            }
            else{
                $generalPromoCodes = [];
            }

        }else if($selectedPackType=='pp'){        
            
            $packInfo = $this->Practice_package_model->getPackInfo_forPromocode($package_id); 
            $center_id = ONLINE_BRANCH_ID;            
            $test_module_id = $packInfo['test_module_id'];
            $packPrice = $packInfo['discounted_amount'];
            $active = $packInfo['active']; 
            $appliedProducts=3;
            $type_of_discount='General';
            $discountField = 'other_discount_pp';
            //get general code
            if(!empty($packInfo) and $active==1){
                $generalPromoCodes = $this->Discount_model->getApplicableGeneralPromocode_forPracticePack($package_id,$type_of_discount,$appliedProducts,$center_id,$test_module_id,$packPrice,$currentDateTimeStr);
            }else{
                $generalPromoCodes = []; 
            }         

        }else if($selectedPackType=='rt'){        
                   
            $packInfo = $this->Realty_test_model->getPackInfo_forPromocode($package_id);

            $appliedProducts=4;   
            $discountField = 'other_discount_rt';
            $packInfo = $this->Realty_test_model->getPackInfo_forPromocode($package_id);
            $test_module_id = $packInfo['test_module_id'];
            $packPrice = $packInfo['amount'];
            $active = $packInfo['active'];
            $type_of_discount='General';            
            //get general code
            if(!empty($packInfo) and $active==1){
                $generalPromoCodes = $this->Discount_model->getApplicableGeneralPromocode_forRealityTest($appliedProducts,$type_of_discount,$test_module_id,$packPrice,$currentDateTimeStr);
            }else{
                $generalPromoCodes = [];
            } 

        }else if($selectedPackType=='eb'){        
                   
            $appliedProducts=5;   
            $discountField = 'other_discount_pbf';
            $packInfo = $this->Exam_master_model->getPackInfo_forPromocode($package_id);
            $test_module_id = $packInfo['test_module_id'];
            $programe_id = $packInfo['programe_id'];
            $active = $packInfo['active'];
            $ExamFee = $this->Exam_master_model->getExamFee($test_module_id,$programe_id);
            $packPrice = $ExamFee['exam_fee'];            
            $type_of_discount='General'; 

            if(!empty($packInfo) and $active==1){
                $generalPromoCodes = $this->Discount_model->getApplicableGeneralPromocode_exam($appliedProducts,$type_of_discount,$test_module_id,$packPrice,$currentDateTimeStr);
            }else{
                $generalPromoCodes = [];
            } 

        }else{

            $packInfo = [];
            $generalPromoCodes = [];
        } 
        //get general code end       

        $x = '<div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Code</th>
                        <th>Validity</th>                
                        <th>Min. Purchase value</th>
                        <th>Max. Discount</th>
                        <th>Country</th>                       
                        <th>ACTION</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">';
        if(!empty($generalPromoCodes)){

            foreach ($generalPromoCodes as $gpc) {

                $promoCodeId = $gpc['id'];
                $to = '<b> TO </b>';
                $validity = $gpc['start_date'].' '.$gpc['start_time'].$to.$gpc['end_date'].' '.$gpc['end_time'];
                $discount_type = $gpc['discount_type'];
                if($gpc['discount_type']=='Percentage'){
                    $max_discount = $gpc['max_discount'].' %';
                }elseif($gpc['discount_type']=='Amount'){
                    $max_discount = $gpc['max_discount'].' INR';
                }else{
                    $max_discount = NA;
                }
                $min_purchase_value = $gpc['min_purchase_value'].' INR';
                $y .=
                '<tr>
                    <td>'.$gpc['disc_name'].'</td>
                    <td>'.$gpc['type_of_discount'].'</td>                    
                    <td>'.$gpc['discount_code'].'</td>
                    <td>'.$validity.'</td>
                    <td>'.$min_purchase_value.'</td>
                    <td>'.$max_discount.'</td>
                    <td>'.$gpc['name'].'</td>                    
                    <td>
                        <a href="javascript:void(0);" class="btn btn-info btn-xs" data-toggle="tooltip" title="Apply" id='.$promoCodeId.' name='.$discountField.' onclick="applyPromoCode(this.id,this.name,'.$student_id.')">Apply</a>                        

                        <a href="javascript:void(0)" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-Range-PromoCode" id='.$promoCodeId.' title="Promocode" onclick="showRange(this.id)">Range</a>
                    </td>
                </tr>';
            }
            $z = '</tbody>
                </table>
                <div class="pull-right">                                        
                </div>                
            </div>';
            $response_general = $x.$y.$z;

        }else{
            $response_general = '<span class="text-danger">No general promocode available for this category! Please try another.</span>';
        }

        

        if(!empty($speacialPromoCodes)){

            foreach ($speacialPromoCodes as $gpc) {

                $promoCodeId = $gpc['id'];
                $to = '<b> TO </b>';
                $validity = $gpc['start_date'].' '.$gpc['start_time'].$to.$gpc['end_date'].' '.$gpc['end_time'];
                $discount_type = $gpc['discount_type'];
                if($gpc['discount_type']=='Percentage'){
                    $max_discount = $gpc['max_discount'].' %';
                }elseif($gpc['discount_type']=='Amount'){
                    $max_discount = $gpc['max_discount'].' INR';
                }else{
                    $max_discount = NA;
                }
                $min_purchase_value = $gpc['min_purchase_value'].' INR';
                $b .=
                '<tr>
                    <td>'.$gpc['disc_name'].'</td>
                    <td>'.$gpc['type_of_discount'].'</td>
                    <td>'.$gpc['discount_code'].'</td>
                    <td>'.$validity.'</td>
                    <td>'.$min_purchase_value.'</td>
                    <td>'.$max_discount.'</td>  
                    <td>'.$gpc['name'].'</td>                  
                    <td>
                        <a href="javascript:void(0);" class="btn btn-info btn-xs" data-toggle="tooltip" title="Apply" id='.$promoCodeId.' name='.$discountField.' onclick="applyPromoCode(this.id,this.name,'.$student_id.')">Apply</a>

                        <a href="javascript:void(0)" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-Range-PromoCode" id='.$promoCodeId.' title="Promocode" onclick="showRange(this.id)">Range</a>
                    </td>
                </tr>';
            }
            $c = '</tbody>
                </table>
                <div class="pull-right">                                        
                </div>                
            </div>';
            $response_special = $x.$b.$c;

        }else{
            $response_special = '';
        }        
        header('Content-Type: application/json');
        $response = ['msg'=>'success', 'status'=>'true', 'promocode'=>$response_general,'special_promocode'=>$response_special];
        echo json_encode($response);        
    }

    function ajax_isApplicableBulkPromocode(){
        
        date_default_timezone_set(TIME_ZONE);
        $currentTime = date("h:i");
        $today=date('Y-m-d');
        $currentDateTime = $today." ".$currentTime;
        $currentDateTimeStr = strtotime($currentDateTime);

        $student_id = $this->input->post('student_id', true);
        $selectedPackType = $this->input->post('selectedPackType', true);
        $package_id = $this->input->post('package_id', true);
        $bulk_promocode = $this->input->post('bulk_promocode', true);
        //get bulk code start
        if($selectedPackType=='offline' or $selectedPackType=='online'){

            if($selectedPackType=='offline'){
                $appliedProducts=1;
                $discountField = 'other_discount_off';
            }else if($selectedPackType=='online'){
                $appliedProducts=2;
                $discountField = 'other_discount';
            }else{
                $appliedProducts=0;
            }                    
            
            $packInfo = $this->Package_master_model->getPackInfo_forPromocode($package_id);
            $center_id = $packInfo['center_id'];
            $countryData = $this->Country_model->getCountry($center_id); 
            $country_id = $countryData['country_id']; 
            $test_module_id = $packInfo['test_module_id'];
            $packPrice = $packInfo['discounted_amount'];
            $active = $packInfo['active'];
            $type_of_discount='Bulk';
            //get general code
            if(!empty($packInfo) and $active==1 and $selectedPackType=='offline'){
                $bulkPromoCodes = $this->Discount_model->isApplicableBulkPromocode_forOffline($package_id,$type_of_discount,$appliedProducts,$center_id,$country_id,$test_module_id,$packPrice,$currentDateTimeStr,$bulk_promocode);
                $bulkPromoCode = $bulkPromoCodes['id'];
            }elseif(!empty($packInfo) and $active==1 and $selectedPackType=='online'){
                $country_id = $stdInfo['country_id'];
                $bulkPromoCodes = $this->Discount_model->isApplicableBulkPromocode_forOnline($package_id,$type_of_discount,$appliedProducts,$center_id,$test_module_id,$packPrice,$currentDateTimeStr,$bulk_promocode);
                $bulkPromoCode = $bulkPromoCodes['id'];
            }else{
                $bulkPromoCode = 0;
            }

        }else if($selectedPackType=='pp'){        
            
            $packInfo = $this->Practice_package_model->getPackInfo_forPromocode($package_id); 
            $center_id = ONLINE_BRANCH_ID;            
            $test_module_id = $packInfo['test_module_id'];
            $packPrice = $packInfo['discounted_amount'];
            $active = $packInfo['active']; 
            $appliedProducts=3;
            $type_of_discount='Bulk';
            $discountField = 'other_discount_pp';
            //get general code
            if(!empty($packInfo) and $active==1){
                $bulkPromoCodes = $this->Discount_model->getApplicableGeneralPromocode_forPracticePack($package_id,$type_of_discount,$appliedProducts,$center_id,$test_module_id,$packPrice,$currentDateTimeStr,$bulk_promocode);
                $bulkPromoCode = $bulkPromoCodes['id'];
            }else{
                $bulkPromoCode = 0; 
            }         

        }else if($selectedPackType=='rt'){        
                   
            $packInfo=$this->Realty_test_model->getPackInfo_forPromocode($package_id);

            $appliedProducts=4;   
            $discountField = 'other_discount_rt';
            $packInfo = $this->Realty_test_model->getPackInfo_forPromocode($package_id);
            $test_module_id = $packInfo['test_module_id'];
            $packPrice = $packInfo['amount'];
            $active = $packInfo['active'];
            $type_of_discount='Bulk';            
            //get general code
            if(!empty($packInfo) and $active==1){
                $bulkPromoCodes = $this->Discount_model->getApplicableGeneralPromocode_forRealityTest($appliedProducts,$type_of_discount,$test_module_id,$packPrice,$currentDateTimeStr,$bulk_promocode);
                $bulkPromoCode = $bulkPromoCodes['id'];
            }else{
                $bulkPromoCode = 0;
            } 

        }else if($selectedPackType=='eb'){        
                   
            $appliedProducts=5;   
            $discountField = 'other_discount_pbf';
            $packInfo = $this->Exam_master_model->getPackInfo_forPromocode($package_id);
            $test_module_id = $packInfo['test_module_id'];
            $programe_id = $packInfo['programe_id'];
            $active = $packInfo['active'];
            $ExamFee = $this->Exam_master_model->getExamFee($test_module_id,$programe_id);
            $packPrice = $ExamFee['exam_fee'];            
            $type_of_discount='Bulk'; 

            if(!empty($packInfo) and $active==1){
                $bulkPromoCodes = $this->Discount_model->getApplicableGeneralPromocode_exam($appliedProducts,$type_of_discount,$test_module_id,$packPrice,$currentDateTimeStr,$bulk_promocode);
                $bulkPromoCode = $bulkPromoCodes['id'];
            }else{
                $bulkPromoCode = 0;
            } 

        }else{

            $packInfo = [];
            $bulkPromoCode = 0;
        } 
        //get bulk code end
               
        header('Content-Type: application/json');
        $response=['msg'=>'success', 'status'=>'true', 'promocode'=>$bulkPromoCode];
        echo json_encode($response);        
    }

    

   

    function ajax_showRange(){

        $id = $this->input->post('id', true);
        //$discountRanges = [];
        $discountRanges=$this->Discount_model->getDiscountRanges($id);

        $x = '<div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th>Range</th>
                        <th>Max. Discount</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">';
        if(!empty($discountRanges)){

            foreach ($discountRanges as $gpc){
                
                $to = '<b> TO </b>';
                $range = $gpc['range_from'].$to.$gpc['range_to'];
                $y .=
                '<tr>
                    <td>'.$range.'</td>
                    <td>'.$gpc['range_discount'].'</td>
                </tr>';
            }
            $z = '</tbody>
                </table>
                <div class="pull-right">                                        
                </div>                
            </div>';
            $response_range = $x.$y.$z;

        }else{
            $response_range = '<span class="text-danger">No range available for this promocode.</span>';
        }
        header('Content-Type: application/json');
        $response = ['msg'=>'success', 'status'=>'true', 'range'=>$response_range];
        echo json_encode($response); 

    }

    function ajax_getPromoCodeDetails(){

        $promoCodeId = $this->input->post('promoCodeId', true);
        $promoCodeDetails=$this->Discount_model->getDiscountDetailsForApply($promoCodeId);
        if(!empty($promoCodeDetails)){
            header('Content-Type: application/json');
            $response = ['msg'=>'success', 'status'=>'true', 'promoCodeDetails'=>$promoCodeDetails];
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'failed', 'status'=>'false', 'promoCodeDetails'=>[] ];
            echo json_encode($response);
        }
    }    

    function ajax_studentPromocodeValidity(){

        $promoCodeId = $this->input->post('promoCodeId', true);
        $student_id = $this->input->post('student_id', true);
        $promocodeUsedCounts=$this->Discount_model->getStudentPromocodeValidity($promoCodeId,$student_id);  

        header('Content-Type: application/json');
        $response = ['msg'=>'success', 'status'=>'true', 'promocodeUsedCounts'=>$promocodeUsedCounts];
        echo json_encode($response);
    }

    function ajax_studentBulkPromocodeValidity(){

        $promoCodeId = $this->input->post('promoCodeId', true);
        $bulk_id = $this->input->post('bulk_id', true);
        $student_id = $this->input->post('student_id', true);
        $promocodeUsedCounts=$this->Discount_model->getStudentBulkPromocodeValidity($promoCodeId,$bulk_id,$student_id);  

        header('Content-Type: application/json');
        $response = ['msg'=>'success', 'status'=>'true', 'promocodeUsedCounts'=>$promocodeUsedCounts];
        echo json_encode($response);
    }    

    function ajax_checkrangeCount(){

        $promoCodeId = $this->input->post('promoCodeId', true);
        $rangeCount=$this->Discount_model->checkrangeCount($promoCodeId);  

        header('Content-Type: application/json');
        $response = ['msg'=>'success', 'status'=>'true', 'rangeCount'=>$rangeCount];
        echo json_encode($response);
    }     

    function ajax_getFinalRangeDiscount(){

        $promoCodeId = $this->input->post('promoCodeId', true);
        $packPrice = $this->input->post('packPrice', true);
        $finalRangeDiscount=$this->Discount_model->finalRangeDiscount($promoCodeId,$packPrice);  
        $finalDiscount = $finalRangeDiscount['range_discount'];
        header('Content-Type: application/json');
        $response = ['msg'=>'success', 'status'=>'true', 'finalDiscount'=>$finalDiscount];
        echo json_encode($response);
    }    

    //bulk case:
    function ajax_getBulkPromocodeId(){

        $bulk_promocode = $this->input->post('bulk_promocode', true);
        $selectedPackType = $this->input->post('selectedPackType', true);
        $getPromocodeId=$this->Discount_model->getBulkPromocodeId($bulk_promocode);
        if(!empty($getPromocodeId)){
            $discount_id= $getPromocodeId['discount_id'];
            $bulk_id= $getPromocodeId['bulk_id'];
        }else{
            $discount_id= 0;
            $bulk_id= 0;
        }           

        header('Content-Type: application/json');
        $response = ['msg'=>'success', 'status'=>'true', 'bulk_id'=>$bulk_id, 'discount_id'=>$discount_id];
        echo json_encode($response);
    }

      
    
}
