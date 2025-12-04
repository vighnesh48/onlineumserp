<?php
exit;
//ini_set("display_errors", "On");
//error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Authentication_model";
  //   var $model_name1="Account_model";
    var $model;
    var $view_dir='Authentication/';
    var $data=array();
    
    public function __construct() 
    {
        // error_reporting(E_ALL);
//ini_set('display_errors', 1);
       
        global $menudata;
    //    exit();
   parent:: __construct();
          
  
     
        $this->load->helper("url");		
        $this->load->library('form_validation');
        
           $this->load->library('Message_api');
           
     
     //$this->load->library('Mylibrary');
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
           $title=$this->master_arr['index'];
        $this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
     //   $this->load->model("Account_model");
        $menu_name=$this->uri->segment(1);        
       // $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }

public function test()
{
   $this->Authentication_model->test_sms(); 
       
}
        
        public function index()
    {
      
       // $this->load->view('header',$this->data);    
        $this->load->view('Authentication/forgot_password_staff.php',$this->data);
  //      $this->load->view('footer');
    }
    
           
        public function student()
    {
        $this->data['type'] = $this->uri->segment(2);
       $this->load->view('Authentication/forgot_password.php',$this->data);
       // $this->load->view('header',$this->data);    
     //   $this->load->view('Authentication/forgot_password.php',$this->data);
  //      $this->load->view('footer');
    }
    
           public function parent()
    {
      $this->data['type'] = $this->uri->segment(2);
     //   exit();
      
       // $this->load->view('header',$this->data);    
        $this->load->view('Authentication/forgot_password.php',$this->data);
  //      $this->load->view('footer');
    }
    
      public function verify_credentials_student()
    {
    //           error_reporting(E_ALL);
//ini_set('display_errors', 1);
         
   $this->Authentication_model->verify_credentials_student(); 
     

    }
    
    
         public function verify_credentials_staff()
    {
         
   $this->Authentication_model->verify_credentials_staff(); 
     

    }
    
   
   public function send_login_credentials()
   {
  //       error_reporting(E_ALL);
//ini_set('display_errors', 1);
    $this->Authentication_model->send_login_credentials();      
   }
   
   
      public function send_login_credentials_staff()
   {
  //       error_reporting(E_ALL);
//ini_set('display_errors', 1);
    $this->Authentication_model->send_login_credentials_staff();      
   }
   
   
    
}
?>