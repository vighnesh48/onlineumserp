<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  
class ForcefulPasswordChange{  
    public function enforcePassword()  
    {  
        $CI =& get_instance();
        $classname =  $CI ->router->class;
        $excluded_class = array('login','home','change_password');
        if (!in_array($classname, $excluded_class)){
            //write your code
            if($_SESSION['is_password_reset'] == 0){
                redirect('change_password');
            }
        }   
    }  
} 

 