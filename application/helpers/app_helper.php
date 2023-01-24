<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('successResponse')) {

    function successResponse(string $message, $data) {
        $ci =& get_instance();
        return $ci->output
                        ->set_content_type('application/json')
                        ->set_status_header(200)
                        ->set_output(json_encode(array(
                            'message' => $message,
                            'data' => $data
        )));
    }

}

if (!function_exists('failureResponse')) {

    function failureResponse(string $message) {
        $ci =& get_instance();
        return $ci->output
                        ->set_content_type('application/json')
                        ->set_status_header(201)
                        ->set_output(json_encode(array(
                            'message' => $message,
                            'data' => []
        )));
    }

}

if (!function_exists('aPrint')) {

    function aPrint($data) {
        echo "<pre>"; print_r($data); echo "</pre>";
    }

}