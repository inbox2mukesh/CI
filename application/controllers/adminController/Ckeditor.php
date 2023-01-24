<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
defined('BASEPATH') OR exit('No direct script access allowed');

class Ckeditor extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->_is_logged_in()) {
            redirect('adminController/login');
        }
    }
    function walk_dir($path) {
        $retval = array();
        if ($dir = opendir($path)) {
            while (false !== ($file = readdir($dir))) {
                if ($file[0] == ".")
                    continue;
                if (is_dir($path . "/" . $file))
                    $retval = array_merge($retval, $this->walk_dir($path . "/" . $file));
                else if (is_file($path . "/" . $file))
                    $retval[] = $path . "/" . $file;
            }
            closedir($dir);
        }
        return $retval;
    }
    function CheckImgExt($filename) {
        $img_exts = array("gif", "jpg", "jpeg", "png");
        $ext = @end(explode(".", strtolower($filename)));
        foreach ($img_exts as $this_ext) {
            if (in_array($ext, $img_exts)) {
                return TRUE;
            }
        }
        return FALSE;
    }
###################################################################################
# process uploaded files
###################################################################################
    function browse() {
        $files = array();
        $d = @explode("&", $_SERVER['QUERY_STRING']);
        
        switch ($d[1]) {
            case 'CKEditor=paragraph_Reading':
                $dir = $this->config->item('READING_PARAGRAPH_BASE_DIR');
                $url = $this->config->item('READING_PARAGRAPH_URL_DIR');
                break;
            case 'CKEditor=paragraph_Writing':
                $dir = $this->config->item('WRITING_PARAGRAPH_BASE_DIR');
                $url = $this->config->item('WRITING_PARAGRAPH_URL_DIR');
                break;
            case 'CKEditor=paragraph_Speaking':
                $dir = $this->config->item('SPEAKING_PARAGRAPH_BASE_DIR');
                $url = $this->config->item('SPEAKING_PARAGRAPH_URL_DIR');
                break;
            case 'CKEditor=paragraph_Listening':
                $dir = $this->config->item('LISTENING_PARAGRAPH_BASE_DIR');
                $url = $this->config->item('LISTENING_PARAGRAPH_URL_DIR');
                break;
            case (strstr($d[1], 'question') && strstr($d[1], '_Reading')):
                $dir = $this->config->item('READING_QUESTION_BASE_DIR');
                $url = $this->config->item('READING_QUESTION_URL_DIR');
                break;
            case (strstr($d[1], 'question') && strstr($d[1], '_Writing')):
                $dir = $this->config->item('WRITING_QUESTION_BASE_DIR');
                $url = $this->config->item('WRITING_QUESTION_URL_DIR');
                break;
            case (strstr($d[1], 'question') && strstr($d[1], '_Listening')):
                $dir = $this->config->item('LISTENING_QUESTION_BASE_DIR');
                $url = $this->config->item('LISTENING_QUESTION_URL_DIR');
                break;
            case (strstr($d[1], 'question') && strstr($d[1], '_Speaking')):
                $dir = $this->config->item('SPEAKING_QUESTION_BASE_DIR');
                $url = $this->config->item('SPEAKING_QUESTION_URL_DIR');
                break;
        }
        foreach ($this->walk_dir($dir) as $file) {
            $file = preg_replace("#//+#", '/', $file);
            $file = preg_replace("#" . $dir . "#", '', $file);
            if ($this->CheckImgExt($file)) {
                $files[] = $file;    //adding filenames to array
            }
        }
        sort($files);    //sorting array
        array_unique($files);
        // generating $html_img_lst
        $html_img_lst = "<link rel=\"stylesheet\" href=\"" . $this->config->item('base_url') . "/css/bower_components/bootstrap/dist/css/bootstrap.min.css\">"
                . "<link rel=\"stylesheet\" href=\"" . $this->config->item('base_url') . "/css/custom.css\">"
                . "<div class=\"row\">";
        foreach ($files as $file) {
            $html_img_lst .= ""
                    . "<div class=\"col-masterprep\" style=\"margin-bottom:10px\"> <img class=\"img-responsive img-thumbnail\" onclick=\"javascript&#058;getImage('" . $this->config->item('base_url') . $url . $file . "','" . $d[1] . "');\" style=\"cursor:pointer\"  src='" . $this->config->item('base_url') . $url . $file . "' /> 
                      ";
            echo $html_img_lst .= "<a href=\"javascript&#058;getImage('" . $this->config->item('base_url') . $url . $file . "','" . $d[1] . "');\">Click here</a><br>\n</div>";
        }
        $html_img_lst .= "</div>";
        echo $html_img_lst;
        echo "<script>\n";
        echo 'function getImage(fileUrl,previewtype,width)
                {
                    var ln=window.opener.document.getElementsByClassName("cke_dialog_ui_input_text");
                    var ln2=window.opener.document.getElementsByClassName("ImagePreviewLoader");
                    for(var i=0;i<ln.length;i++){
                        ln[i].value = fileUrl;
                    }
                   // ln[1].value = fileUrl;
                   // ln[0].innerHTML="<img src=\'" + fileUrl + "\' id=\'PreviewImage\'  style=\"height:100px; width:100px\" />";
                    window.close();
                }' . "\n";
        echo '</script>' . "\n";
    }

}
