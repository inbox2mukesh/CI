<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$route['default_controller'] = 'login';
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

$route['make-stripe-payment'] = "booking";
$route['handlePayment']['post'] = "booking/handlePayment";
//$route['Second-event/(:any)'] = "Second-event/$1";// dynamic rewritting
$route['news-article/(:any)'] = "news_article/index/$1";// dynamic rewritting
$route['latest-news/(:any)'] = "latest_news/index/$1";// dynamic rewritting
$route['visa-service-details/(:any)'] = "visa_service_details/index/$1";// dynamic rewritting
$route['free_resource_post/(:any)'] = "free_resource_post/$1";// dynamic rewritting
$route['free-resources'] = "free_resources";
$route['latest-news'] = "latest_news";
$route['visa-services'] = "visa_services";
$route['online-courses'] = "online_courses";
$route['practice-packs'] = "practice_packs";
$route['why-canada'] = "why_canada";
$route['contact-us'] = "contact_us";
$route['become-agent'] = "become_agent";
$route['term-condition'] = "term_condition";