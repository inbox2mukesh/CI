<?php
/**
 * @package         WOSA front
 * @subpackage      Campaign
 * @author          Rajan Bansal
 **/
require_once APPPATH . '/libraries/traits/apiCommonDataTrait.php';
class Common extends MY_Controller
{
	use apiCommonDataTrait;

	function __construct()
	{
		parent::__construct();
	}
	public function ajax_load_more()
	{
		$this->load->model('Test_preparation_material_model');
		$params		= $this->input->post("params") ? $this->input->post("params") : "";
		$controller = $this->input->post("controller");
		$offset 	= $this->input->post("offset") ? $this->input->post("offset") : 0;
		$limit  	= FRONTEND_RECORDS_PER_PAGE;
		if ($controller || $offset) {
			$data[$controller] = $this->auto_getFrontendSectionData(['type' => 'ajax_load_more', 'params' => isset($params) && $params ? $params : '', 'controller' => $controller, 'offset' => $offset, 'limit' => $limit, 'country_id' => $this->defaultSelectedCountryID]);
			$result["total_records"] = 0;
			$totalRowsResult = $this->auto_getFrontendSectionData(['type' => 'ajax_load_more', 'params' => isset($params) && $params ? $params : '', 'controller' => $controller, 'offset' => $offset, 'limit' => $limit, 'country_id' => $this->defaultSelectedCountryID, 'count' => 1]);
			
			/*$aa = $data[$controller]->error_message->data;
			foreach ($aa  as $key => $c) {
				$data2['c'] = $this->Test_preparation_material_model->getFreeResourceContentsTopic($c->id);
				$bData[$key]['Course']= $data2['c'];         
                     
			  }
			  pr($bData);	 
			  pr($data);*/
			if (isset($totalRowsResult->error_message->data) && $totalRowsResult->error_message->data) {
				$totalRows = $totalRowsResult->error_message->data;
				$result["total_pages"]  = ceil($totalRows / FRONTEND_RECORDS_PER_PAGE);
				$result["total_records"]  = isset($totalRows) ? $totalRows : 0;
			}
			$result["html"] = $this->load->view('aa-front-end/' . $controller . '_load_more', $data, true);
			echo json_encode($result);
		}
	}
	public function isPackageActive()
	{
		$id		=  $this->input->post("col_id") ? $this->input->post("col_id") : "";
		$name		= $this->input->post("col_name") ? $this->input->post("col_name") : "";
		$product_mode = $this->input->post("product_mode") ? $this->input->post("product_mode") : '';
		$headers = array(
			'API-KEY:' . WOSA_API_KEY,
			'TABLE-NAME:' . $product_mode,
			'COL-ID:' . $id,
			'COL-NAME:' . $name,
		);
		$data = json_decode($this->_curlGetData(base_url(COMMON_IS_PACKAGE_ACTIVE), $headers));
		echo json_encode($data);
	}
	// Added by Vikram 6 dec 2022
	/**
	 * Summary of is_student_logged_in
	 * @return void
	 */
	function is_student_logged_in()
	{
		$this->load->model('Student_model');
		$user = $this->session->userdata('student_login_data');
		$verifyAccess = $this->Student_model->verifyAccess($user->id);
		$is_student_active = $verifyAccess['active'];
		$verifyToken = $this->Student_model->verifyToken($user->id);
		$userToken = $verifyToken['token'];
		$status = $verifyToken['status'];
		if (empty($userToken)) {
			echo TRUE;
		} else if ($userToken == $user->token) {
			if (empty($user)) {
				echo $logoutReason = STO;
			} else {
				if ($is_student_active != 1) {
					echo $logoutReason = PAR;
				} else {
					echo TRUE;
				}
			}
		} else {
			echo $logoutReason = MDL;
		}
	}
	function ajax_get_states_by_country_id()
	{
		$countryId = $this->input->post('country_id');
		$headers = array(
			'API-KEY:' . WOSA_API_KEY,
			'COUNTRY-ID:' . $countryId
		);
		$states = json_decode($this->_curlGetData(base_url(GET_STATES_LIST_BY_COUNTRY_ID), $headers));
		if (isset($states->error_message->data) && $states->error_message->data) {
			echo json_encode($states->error_message->data);
		} else {
			echo 0;
		}
	}
	public function cityFilter()
	{
		$city_name = $this->input->post('city_name', true);
		$country_id = $this->input->post('country_id', true); #city_name based on country_id
		$state_id = $this->input->post('state_id', true);  #city_name based on state_id
		$data['error_message'] = ["success" => 0, "message" => 'Required Parameter Missing', "data" => ''];
		if (!empty($city_name)) {
			$params = array(
				'country_id' => $country_id,
				'state_id' => $state_id,
				'city_name' => $city_name
			);
			$data=$this->auto_getSerachCity($params);
		}
		echo json_encode($data);
		exit();
	}
	public function ajax_getTimezonesByCountryId()
	{
		$countryId = $this->input->post('country_id');
		if ($countryId) {
			$headers = array(
				'API-KEY:' . WOSA_API_KEY,
				'COUNTRY-ID:' . $countryId
			);
			$response = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_TIMEZONE), $headers));
			echo isset($response->error_message->data) && $response->error_message->data ? json_encode($response->error_message->data) : 0;
		}
	}
	public function ajax_getCommonModalContent()
	{
		$moduleName = $this->input->post('module_name');
		$rowId = $this->input->post('row_id');
		if ($moduleName && $rowId) {
			$headers = array(
				'API-KEY:' . WOSA_API_KEY,
				'MODEL-NAME:' . $moduleName,
				'ROW-ID:' . $rowId
			);
			$response = json_decode($this->_curlGetData(base_url(GET_COMMON_MODAL_CONTENT), $headers));
			echo isset($response->error_message->data) && $response->error_message->data ? json_encode($response->error_message->data) : 0;
		}
	}
}
