<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class m_pdf {
    
    function __construct()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }

    /*function m_pdf()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }*/
 
    function load($param=NULL)
    {
        include_once APPPATH.'/third_party/vendor/autoload.php';
         
        /*if ($params == NULL)
        {
            //$param = '"en-GB-x","A4","","",10,10,10,10,6,3'; 
            $param = "'utf-8','A4'";            		
        }*/
         
        return new \Mpdf\Mpdf();
        //return new mPDF();
    }
}