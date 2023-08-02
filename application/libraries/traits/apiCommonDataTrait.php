<?php

/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Neelu Sharma
 *
 * */
trait apiCommonDataTrait
{
    /*
    type : country_code,we_deal,
    is_api is fasle call from Web & $is_api true call From Api
    */
    public function auto_getCountryList(array $params = [], $is_api = false)
    {
        $this->load->model('Country_model');
        $responce = [];
        if (isset($params['type']) && $params['type'] == 'country_code') {
            $responce = $this->Country_model->getAllCountryCode();
        } else if (isset($params['type']) && $params['type'] == 'we_deal') {
            $responce = $this->Country_model->get_all_active_and_we_deal_countries_list_frontend();
        } else if (isset($params['type']) && $params['type'] == 'purpose_we_deal' && isset($params['purpose_level_two'])) {

            $this->load->model('Purposes_master_model');
            $purpose_level_2=$params['purpose_level_two'];
            $product_id=isset(WOSA_VISA_PURPOSE_LAVEL_TWO_PRODUCT_ID[$purpose_level_2]) ? WOSA_VISA_PURPOSE_LAVEL_TWO_PRODUCT_ID[$purpose_level_2]:'';
            if ($product_id == 7)  #Visa Event
            {
                $responce = $this->Country_model->getAllCountryNameAPI_deal();
            } else {
                $responce = $this->Purposes_master_model->getVisaServiceCountriesByProductId($product_id);
            }
        }
        return $this->auto_setResponceFormat($responce, $is_api);
    }
    public function auto_getTimezoneList(array $params = [], $is_api = false)
    {
        $this->load->model('Timezone_model');
        $responce = [];
        if (isset($params['country_id']) && !empty($params['country_id'])) {
            $responce = $this->Timezone_model->getActiveTimeZoneList($params['country_id']);
        } else {
            $responce = $this->Timezone_model->getActiveTimeZoneList();
        }
        return $this->auto_setResponceFormat($responce, $is_api);
    }
    public function auto_getReferenceSourceList(array $params = [],$is_active=1,$is_api = false)
    {
        $this->load->model('Source_master_model');
        $responce = [];
        $responce = $this->Source_master_model->getReferenceSourceActive($params,$is_active);
        return $this->auto_setResponceFormat($responce, $is_api);
    }
    public function auto_getBranchList(array $params = [], $is_api = false)
    {
        $this->load->model('Center_location_model');
        $responce = [];
        if (isset($params['type']) && $params['type'] == 'feedback_branch') {
            $responce = $this->Center_location_model->Get_feedback_branch_link();
        } elseif (isset($params['type']) && $params['type'] == 'physical_branch' && isset($params['IS-OVERSEAS'])) {
            $responce = $this->Center_location_model->get_all_physical_branches_frontend($params['IS-OVERSEAS']);
        } else if (isset($params['type']) && $params['type'] == 'inhouse_branch') {
            $this->load->model('Purposes_master_model');
            $responce = $this->Purposes_master_model->getAllInhouseCoachingBranchActive();
        }
        return $this->auto_setResponceFormat($responce, $is_api);
    }
    public function auto_getPurposeByOmsList(array $params = [], $is_api = false)
    {
        $this->load->model(['Purposes_master_model']);
        $responce = [];
        if (isset($params['origin_type']) && !empty($params['origin_type']) && isset($params['origin']) && !empty($params['origin']) && isset($params['medium']) && !empty($params['medium'])) {
            $responce = $this->Purposes_master_model->getMediumPurpose($params['origin_type'], $params['origin'], $params['medium']);
        }
        return $this->auto_setResponceFormat($responce, $is_api);
    }
    public function auto_getPurposeLevelTwo(array $params = [], $is_api = false)
    {
        $this->load->model(['Purposes_master_model']);
        $responce = [];
        if (isset($params['purpose_level_1']) && !empty($params['purpose_level_1'])) {
            $responce = $this->Purposes_master_model->getPurposeChildren($params['purpose_level_1']);
        }
        return $this->auto_setResponceFormat($responce, $is_api);
    }
    public function auto_getCourse(array $params = [], $is_api = false)
    {
        $this->load->model(['Test_module_model']);
        $responce = [];
        if (isset($params['type']) && $params['type'] == 'purpose_course' && isset($params['product_id']) && !empty($params['product_id'])) {
            $responce = $this->Test_module_model->getTestModuleForPurposeByProductId($params['product_id']);
        }
        return $this->auto_setResponceFormat($responce, $is_api);
    }
    public function auto_getProgram(array $params = [], $is_api = false)
    {
        $this->load->model(['Purposes_master_model']);
        $responce = [];
        if (isset($params['type']) && $params['type'] == 'program' && isset($params['course']) && !empty($params['course'])) {
            $responce = $this->Purposes_master_model->getTestPrograme($params['course']);
        } else if (isset($params['type']) && $params['type'] == 'online_coaching_program' && isset($params['course']) && !empty($params['course'])) {
            $responce = $this->Purposes_master_model->getOnlineCoachingProgram($params['course']);
        }
        return $this->auto_setResponceFormat($responce, $is_api);
    }
    public function auto_getSubjectByProductId(array $params = [], $is_api = false)
    {
        $this->load->model(['Purposes_master_model']);
        $responce = [];
        if (isset($params['type']) && $params['type'] == 'complaint' && isset($params['product_id']) && !empty($params['product_id'])) {
            $responce = $this->Purposes_master_model->getComplaintSubjectByProductId($params['product_id']);
        } else if (isset($params['type']) && $params['type'] == 'feedback' && isset($params['product_id']) && !empty($params['product_id'])) {
            $responce = $this->Purposes_master_model->getFeedbackSubjectByProductId($params['product_id']);
        } else if (isset($params['type']) && $params['type'] == 'request' && isset($params['product_id']) && !empty($params['product_id'])) {
            $responce = $this->Purposes_master_model->getRequestSubjectByProductId($params['product_id']);
        }
        return $this->auto_setResponceFormat($responce, $is_api);
    }
    function auto_getEventTypeList($params = [], $is_api = false)
    {    $response=[];
        if (isset($params['division_id']) && $params['division_id']) {
            $this->load->model("Purposes_master_model");
            $response =  $this->Purposes_master_model->getAllActiveEventTypeByDivisionId($params['division_id']);
        }
        return $this->auto_setResponceFormat($response, $is_api);
    }
    public function auto_getStudentInfobyId(array $params = [])
    {
        $this->load->model(['Student_model']);
        $responce = [];
        if (isset($params['student_id']) && !empty($params['student_id'])) {
            $responce = $this->Student_model->get_studentfull_profile($params['student_id']);
        }
        return $responce;
    }
    public function auto_getMarquee(array $params = [], $is_api = false)
    {
        $params['LIMIT']  = isset($params['LIMIT']) && $params['LIMIT'] ? $params['LIMIT'] : FRONTEND_RECORDS_PER_PAGE;
        $responce = [];
        if (isset($params['type']) && $params['type'] == 'post') {
            $this->load->model('Posts_model');
            $responce = $this->Posts_model->postMarqueeFrontend($params);
        } elseif (isset($params['type']) && $params['type'] == 'news') {
            $this->load->model('News_model');
            $responce = $this->News_model->getNewssMarqueeFrontend($params);
        } elseif (isset($params['type']) && $params['type'] == 'update') {
            $this->load->model('Offers_model');
            $responce = $this->Offers_model->getOfferMarqueeFrontend($params);
        } elseif (isset($params['type']) && $params['type'] == 'test_prep_material') {
            $this->load->model('Test_prep_materials_model');
            $responce = $this->Test_prep_materials_model->getMarqueeFrontend($params);
        }
        return $this->auto_setResponceFormat($responce, $is_api);
    }
    public function auto_getFrontendSectionData(array $params = [], $is_api = false)
    {
        $pageType   = isset($params['pagetype']) && $params['pagetype'] ? $params['pagetype'] : '';
        $countryId  = isset($params['country_id']) && $params['country_id'] ? $params['country_id'] : '';
        $type       = isset($params['type']) && $params['type'] ? $params['type'] : '';
        $visaProductCountryId  = isset($params['visa_product_country_id']) && $params['visa_product_country_id'] ? $params['visa_product_country_id'] : "";
        $response   = [];
        if ($pageType && $type == "web_banners") {
            $WebBannerModelId = '';
            $this->load->model('Web_banner_model');
            if ($pageType == "visa_products") {
                $WebBannerModelId = $visaProductCountryId;
            } else if ($pageType == "course_pages") {
                $testModuleId  = isset($params['test_module_id']) && $params['test_module_id'] ? $params['test_module_id'] : "";
                $WebBannerModelId = $testModuleId;
            } else if ($pageType == "branch") {
                $centerId  = isset($params['center_id']) && $params['center_id'] ? $params['center_id'] : "";
                $WebBannerModelId = $centerId;
            }
            $response = $this->Web_banner_model->get_all_active_web_banners_frontend($pageType, $WebBannerModelId);
        } elseif ($pageType && $type == "usp_counts") {
            $this->load->model("Usp_count_model");
            $response = $this->Usp_count_model->get_all_active_usp_count_frontend($pageType, $visaProductCountryId);
        } elseif ($pageType && $type == "usp_texts") {
            $this->load->model("Usp_text_model");
            $response = $this->Usp_text_model->get_all_active_usp_text_frontend($pageType,  $visaProductCountryId);
        } elseif ($pageType && $type == "page_text") {
            $this->load->model("Page_text_model");
            $response = $this->Page_text_model->get_all_active_page_text_frontend($pageType);
        } elseif ($pageType && $type == "usp_text_description") {
            $this->load->model("Usp_text_description_model");
            $response = $this->Usp_text_description_model->getUspTextDescriptionByPageType_frontend($pageType);
        } elseif ($type == "posts_latest") {
            $this->load->model("Posts_model");
            $params['count']  = isset($params['count']) && $params['count'] ? 1 : 0;
            $params['offset'] = isset($params['offset']) && $params['offset'] ? $params['offset'] : 0;
            $params['limit']  = isset($params['limit']) && $params['limit'] ? $params['limit'] : FRONTEND_RECORDS_PER_PAGE;
            $params['slug']   = isset($params['slug']) && $params['slug'] ? $params['slug'] : '';
            if ($params['slug']) {
                $postId = $this->Posts_model->getPostIdBySlug($params['slug']);
                $params['post_id'] = $postId;
                if (!$postId) {
                    return $this->auto_setResponceFormat($response, $is_api);
                }
            }
            $response = $this->Posts_model->get_posts_listing($params, $params['count']);
        } elseif ($type == "test_prep_latest") {
            $this->load->model("Test_prep_materials_model");
            $params['count']  = isset($params['count']) && $params['count'] ? 1 : 0;
            $params['offset'] = isset($params['offset']) && $params['offset'] ? $params['offset'] : 0;
            $params['limit']  = isset($params['limit']) && $params['limit'] ? $params['limit'] : FRONTEND_RECORDS_PER_PAGE;
            $params['slug']   = isset($params['slug']) && $params['slug'] ? $params['slug'] : '';
            if ($params['slug']) {
                $testPrepMaterialId = $this->Test_prep_materials_model->getTestPrepMaterialIdBySlug($params['slug']);
                $params['tpm_id'] = $testPrepMaterialId;
                if (!$testPrepMaterialId) {
                    return $this->auto_setResponceFormat($response, $is_api);
                }
            }
            $response = $this->Test_prep_materials_model->get_test_prep_materials_listing($params, $params['count']);
        } elseif ($type == "news_latest") {
            $this->load->model("News_model");
            $params['count']  = isset($params['count']) && $params['count'] ? 1 : 0;
            $params['offset'] = isset($params['offset']) && $params['offset'] ? $params['offset'] : 0;
            $params['limit']  = isset($params['limit']) && $params['limit'] ? $params['limit'] : FRONTEND_RECORDS_PER_PAGE;
            $params['slug']   = isset($params['slug']) && $params['slug'] ? $params['slug'] : '';
            if ($params['slug']) {
                $newsId = $this->News_model->getNewsIdBySlug($params['slug']);
                $params['news_id'] = $newsId;
                if (!$newsId) {
                    return $this->auto_setResponceFormat($response, $is_api);
                }
            }
            $response = $this->News_model->get_news_listing($params, $params['count']);
        } elseif ($type == "testimonials") {
            $this->load->model('Student_testimonials_model');
            $count      = isset($params['count']) && $params['count'] ? 1 : 0;
            if (!$pageType) { //Frontend Testimonial Page
                $response   = $this->Student_testimonials_model->get_student_testimonials_listing_frontend('', $count);
            } else {
                $response   = $this->Student_testimonials_model->get_textual_testimonial_short_frontend($pageType, $visaProductCountryId);
            }
        } elseif ($type == "ajax_load_more") {
            $controller       = isset($params['controller']) && $params['controller'] ? $params['controller'] : '';
            $params["offset"] = isset($params['offset']) && $params['offset'] ? $params['offset'] : 0;
            $params["countryId"] = $countryId;
            $params["limit"]  = isset($params['limit']) && $params['limit'] ? $params['limit'] : FRONTEND_RECORDS_PER_PAGE;
            $count            = isset($params['count']) && $params['count'] ? 1 : 0;
            if (isset($params["params"]) && $params["params"]) {
                $params["params"] = (object) $params["params"];
            }
            $modelName    = $controller . "_model";
            $functionName = "get_" . $controller . "_listing_frontend";
            $this->load->model($modelName);
            $response = $this->$modelName->$functionName($params, $count);
            
        } elseif ($pageType && $type == "accolades_and_associations") {
            $this->load->model("Accolades_and_associations_model");
            $response = $this->Accolades_and_associations_model->get_all_accolades_and_associations_short_active_frontend($pageType, $visaProductCountryId);
        } elseif ($pageType && $type == "our_products") {
            $this->load->model("Our_products_model");
            $response = $this->Our_products_model->get_all_our_products_short_active_frontend($pageType, $visaProductCountryId);
        } elseif ($pageType && $type == "tv_shows") {
            $this->load->model("Tv_shows_model");
            $response = $this->Tv_shows_model->get_all_tv_shows_short_active_frontend($pageType);
        } elseif ($pageType && $type == "marketing_popup") {
            $this->load->model(['Marketing_popups_model', 'Application_settings_model']);
            $startingDate = isset($params['starting_date']) && $params['starting_date'] ? $params['starting_date'] : "";
            $response['marketing_popup'] = $this->Marketing_popups_model->getMarketingPopupAPI($pageType, $startingDate);
            $response['application_settings'] = $this->Application_settings_model->getSetting('marketing_popups');
            $response['currentPage'] = $pageType;
        } elseif ($type == "events") {
            $this->load->model("Event_model");
            $count = isset($params['count']) && $params['count'] ? 1 : 0;
            $params['countryId'] = $countryId;
            $response = $this->Event_model->getEventListForFrontendBooking($params, $count);
        } elseif ($pageType && $type == "web_media") {
            $mediaType  = isset($params['media_type']) && $params['media_type'] ? $params['media_type'] : "";
            $uploadTime = isset($params['upload_time']) && $params['upload_time'] ? $params['upload_time'] : "";
            $searchText = isset($params['search_text']) && $params['search_text'] ? $params['search_text'] : "";
            $this->load->model("Web_media_model");
            $response = $this->Web_media_model->get_all_web_media($mediaType, $pageType, $uploadTime, $searchText, $visaProductCountryId);
        } elseif ($pageType && $type == "university_logos") {
            $this->load->model("University_logos_model");
            $response = $this->University_logos_model->get_all_university_logos_short_active_frontend($pageType, $visaProductCountryId);
        } elseif ($pageType && $type == "page_tab_contents") {
            $this->load->model("Page_tab_contents_modal");
            $centerId = '';
            if ($pageType == "visa_products") {
                $centerId = $visaProductCountryId;
            } elseif ($pageType == "branch") {
                $centerId = isset($params['center_id']) && $params['center_id'] ? $params['center_id'] : "";
            } elseif ($pageType == "course_pages") {
                $centerId = isset($params['test_module_id']) && $params['test_module_id'] ? $params['test_module_id'] : "";
            }
            if ($centerId) {
                $response = $this->Page_tab_contents_modal->getAllPageTabsAndSectionContentByPageType_frontend($pageType, $centerId);
            } else {
                $response = $this->Page_tab_contents_modal->getAllPageTabsAndSectionContentByPageType_frontend($pageType);
            }
        } elseif ($pageType && $type == "related_content") {
            $this->load->model("Related_content_model");
            $relatedContentModelId = '';
            if ($pageType == "visa_products") {
                $relatedContentModelId = $visaProductCountryId;
            } else if ($pageType == "course_pages") {
                $testModuleId  = isset($params['test_module_id']) && $params['test_module_id'] ? $params['test_module_id'] : "";
                $relatedContentModelId = $testModuleId;
            }
            $response = $this->Related_content_model->getRelatedContent($pageType, $relatedContentModelId);
        } elseif ($pageType && $type == "test_module") {
            $this->load->model("Test_module_model");
            $response = $this->Test_module_model->getAllCourse();
        } elseif ($type == "visa_servcies") {
            $this->load->model("Visa_service_master_model");
            $visaTypeId  = isset($params['visa_type_id']) && $params['visa_type_id'] ? $params['visa_type_id'] : "";
            $response = $this->Visa_service_master_model->getAllVisaAndCountries($visaTypeId);
        }
        return $this->auto_setResponceFormat($response, $is_api);
    }

    function auto_getContactsList($params = [], $is_api = false)
    {
        if (isset($params['module_id']) && $params['module_id']) {
            $this->load->model("Contacts_model");
            $response = $this->Contacts_model->getContactsDetailsByModuleId($params['module_id']);
        }
        return $this->auto_setResponceFormat($response, $is_api);
    }

    function auto_getFrontendBranchsAndContacts($params = [], $is_api = false)
    {
        $countryId = INDIA_ID;
        if (isset($params["country_id"]) && $params["country_id"]) {
            $countryId = $params["country_id"];
        }
        $this->load->model("Center_location_model");
        $response = $this->Center_location_model->getPhysicalBranchesAndContacts($countryId);
        return $this->auto_setResponceFormat($response, $is_api);
    }

    function auto_getQuickContacts($params = [], $is_api = false)
    {
        $this->load->model("Contacts_model");
        $response = $this->Contacts_model->getQuickContacts();
        return $this->auto_setResponceFormat($response, $is_api);
    }

    function auto_getLeadProductIdByLeadPurpose($params)
    {
        $product_id = NULL;
        $this->load->helper(['lead_info']);
        $this->load->model('Purposes_master_model');
        $purpose_level_one = isset($params['purpose_level_1']) ? $params['purpose_level_1'] : '';
        $purpose_level_two = isset($params['purpose_level_2']) ? $params['purpose_level_2'] : '';
        if (empty($purpose_level_one) && !empty($purpose_level_two)) {
            $purposeseData = $this->Purposes_master_model->getPurposeDetails($purpose_level_two);
            $purpose_level_one = !empty($purposeseData) && isset($purposeseData->p_id) ? $purposeseData->p_id : '';
        }
        $purpose_level_one_sale_ids = getSaleablePurposes();
        $product_ids = array_merge(array_column(WOSA_PRODUCTS_LIST[ACADEMY_DIVISION_PKID], 'id'), array_column(WOSA_PRODUCTS_LIST[VISA_DIVISION_PKID], 'id'));
        if (in_array($purpose_level_one, $purpose_level_one_sale_ids)) {
            switch ($purpose_level_one) {   #Test Coaching & Preparation
                case '1':
                    switch ($purpose_level_two) {
                        case '2':          #Online Coaching
                            $product_id = 2; #Online Pack
                            break;
                        case '5':          #Inhouse Coaching
                            $product_id = 1; #Inhouse Pack
                            break;
                        case '9':         #Practice Packs
                            $product_id = 3; #Practice Pack
                            break;
                        default:
                            break;
                    }
                    break;
                case '12':   #Visa Services
                    switch ($purpose_level_two) {
                        case '13':    #Study Visa
                            $product_id = 8;
                            break;
                        case '16':     #Visitor Visa
                            $product_id = 9;
                            break;
                        case '18':    #Work Visa
                            $product_id = 10;
                            break;
                        case '22':   #Dependent Visa
                            $product_id = 11;
                            break;
                        default:
                            break;
                    }
                    break;
                case '32':   #Events
                    switch ($purpose_level_two) {
                        case '33':   #Academy Events
                            $product_id = 6;
                            break;
                        case '36':    #Visa Events
                            $product_id = 7;
                            break;
                        default:
                            break;
                    }
                    break;
                case '24':   #Reality Test
                    $product_id = 4;
                    break;
                case '27':   #Exam Booking
                    $product_id = 5;
                    break;
                default:
                    # code...
                    break;
            }
        }
        if (!empty($product_id) && !in_array($product_id, $product_ids)) {
            $product_id = null;
        }
        return $product_id;
    }

    function auto_getSerachCity($params = [], $is_api = false)
    {

        $response = [];
        if (isset($params['city_name']) && !empty($params['city_name']) && !empty($params['country_id']) && !empty($params['country_id'])) {
            $params['city_name'] = removeExtraSpaces($params['city_name']);
            $this->load->model("City_model");
            $response = $this->City_model->city_filter($params['city_name'], $params['country_id'], $params['state_id']);
        }
        return $this->auto_setResponceFormat($response, $is_api);
    }
    public function auto_setResponceFormat($responce, $is_api)
    {
        if ($is_api) {
            return $responce;
        }
        $message = !empty($responce) ? 'success' : 'No data found!';
        $responce = !empty($responce) ? $responce : '';
        $responceData['error_message'] = ["success" => 1, "message" => $message, "data" => $responce];
        $responce = json_decode(json_encode($responceData), FALSE);
        return $responce;
    }
}
