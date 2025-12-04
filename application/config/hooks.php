<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'][] = [
    'class'    => '',
    'function' => 'throttle_requests',
    'filename' => 'Throttle.php',
    'filepath' => 'hooks',
];
$hook['post_controller'] = array(  
    'class' => 'ForcefulPasswordChange',  
    'function' => 'enforcePassword',  
    'filename' => 'ForcefulPasswordChange.php',  
    'filepath' => 'hooks',  
    'params' => array()  
);
/*$hook['pre_system'][] = [
    'class' => 'SecurityCheck',
    'function' => 'monitor_activity',
    'filename' => 'pre_system.php',
    'filepath' => 'hooks'
];/