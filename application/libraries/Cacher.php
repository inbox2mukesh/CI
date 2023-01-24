<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cacher{
  protected $CI;
  public function __construct(){
    $this->CI =& get_instance();
    $this->initiate_cache($cacheEngine);
  }
  public function initiate_cache($cacheEngine){
    $this->CI->load->driver('cache', array('adapter' => $cacheEngine, 'backup' => 'file'));
  }
}
?>