<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Leave_application_list extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="employee_category";
    var $model_name="MonthlyAttendance_model";
    var $model;
    var $view_dir='Admin/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        $this->load->helper("url");		
        $this->load->library('form_validation');
        
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
        $this->data['app_data']= $this->MonthlyAttendance_model->get_all_application_list($_POST);   
//print_r($_POST);	
	$this->data['attend_date']= $_POST['attend_date'];
        $this->load->view($this->view_dir.'application_list',$this->data);
        $this->load->view('footer');
    }
    
   
}
?>