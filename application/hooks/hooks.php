<?php

/*$hook['pre_controller'] = array(
        'class'    => 'MY_Controller',
        'function' => '_is_logged_in',
        'filename' => 'MY_Controller.php',
        'filepath' => 'hooks',
        'params'   => array()
);*/

$hook['post_controller'] = array(
        'class'    => 'MY_Controller',
        'function' => '_is_logged_in',
        'filename' => 'MY_Controller.php',
        'filepath' => 'hooks',
        'params'   => array()
);

?>