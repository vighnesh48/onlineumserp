<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Facilities extends CI_Controller 
{

    var $currentModule="";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Facility_model";
    var $model;
    var $view_dir='Facilities/';
    
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
     //   echo $_SERVER['REMOTE_ADDR'];
 // var_dump($_SESSION);
// error_reporting(E_ALL);
//ini_set('display_errors', 1);
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
        global $model;
        $this->load->view('header',$this->data);    
        $this->data['student_list']= $this->Facility_model->get_hstudent_list();                        
        $this->load->view($this->view_dir.'hostel_student_list',$this->data);
        $this->load->view('footer');
    }
    
    function search_hostel_students()
    {
            $this->load->view('header',$this->data);    
      //  $this->data['student_list']= $this->Facility_model->get_hstudent_list();                        
        $this->load->view($this->view_dir.'search_students',$this->data);
        $this->load->view('footer');
    }
    
    
        function load_hostel_students()
    {
        //    $this->load->view('header',$this->data);    
        $this->Facility_model->load_hostel_students();                        
      //  $this->load->view($this->view_dir.'search_students',$this->data);
        //$this->load->view('footer');
    }
    
    function test()
    {
        $this->Facility_model->test();                        

    }
    
}
	
	?>