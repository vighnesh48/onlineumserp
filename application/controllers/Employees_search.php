<?php
ini_set("display_errors", "On");
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
define("MODEL_NM","course_model");
class Employees_search extends CI_Controller 
{
    var $currentModule="Change_password";
    var $title="";
    var $table_name="employee_master";
    var $model_name="Admin_model";
    var $model;
    var $view_dir='Course/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        $this->load->helper("url");		
        $this->load->library('form_validation');
        $this->load->library('session');
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
           $title=$this->master_arr['index'];
       
        
        $this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
        
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    
    public function index()
    {
        $this->load->view('header',$this->data);    
      //  $this->data['course_details']= $this->course_model->get_course_details();  
	  if(!empty($_POST)){
	$this->data['search_res'] = $this->Admin_model->employee_search($_POST);
	
		  }
        $this->load->view('employee_search',$this->data);
        $this->load->view('footer');
    }
     public function Allempdetails(){
        $this->load->view('header',$this->data);    
        $this->load->model('Admin_model');
        $this->data['search_res1']= $this->Admin_model->getEmployees1('Y');
         $this->load->view('employee_search',$this->data);
        $this->load->view('footer');
    }
    public function change_user_password()
    {
        $this->load->view('header',$this->data); 
	
          $_POST['uid'] = $this->session->userdata('uid');
        		 $this->data['change_status']= $this->Login_model->change_user_password($_POST); 
				
        $this->load->view('change_password',$this->data);
        $this->load->view('footer');
    }
    
    public function user(){
         $this->load->view('header',$this->data); 
         $this->load->view('Search/user',$this->data);
         $this->load->view('footer');
        
    }
    
}
?>