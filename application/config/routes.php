<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$route['default_controller'] = 'login';
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

$route['make-stripe-payment'] = "booking";
$route['handlePayment']['post'] = "booking/handlePayment";
$route['why_australia'] = 'why_canada';









