<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Student_dashboard extends CI_Controller 
{
    var $data=array(); 
    function __construct()
    {        
            
   //  error_reporting(E_ALL);
//ini_set('display_errors', 1);
        parent::__construct();                
        $this->load->helper("url");       
        $array=$this->session->all_userdata();
          $this->load->model('login_model');
		  $this->load->model('Responsibilities_model');
//print_r($array);		
        if(!$this->session->has_userdata('uid'))
        redirect('login');     
    }
    public function index()
    {
		// echo "hii";exit;
		$rid=$this->session->userdata('role_id');
        $this->load->view('header',  $this->data);   
       
		if($rid==4 || $rid==9){
			$rid='Students';
		}else{
			$rid='';
		}
		// print_r($this->data);exit;
        
			
			  $this->load->view('student_dashboard', $this->data);  
     
        $this->load->view('footer');
    }


      public function courseware_semester()
    {
		$rid=$this->session->userdata('role_id');
        $this->load->view('header',  $this->data);          	
		$this->load->view('Courseware/courseware_semester', $this->data);  
     
        $this->load->view('footer');
    }

    
      public function subject_assessment()
    {
		$rid=$this->session->userdata('role_id');
        $this->load->view('header',  $this->data);          	
		$this->load->view('Courseware/subject_assessment', $this->data);  
     
        $this->load->view('footer');
    }

    public function subject_assessment_chapter()
    {
		$rid=$this->session->userdata('role_id');
        $this->load->view('header',  $this->data);          	
		$this->load->view('Courseware/subject_assessment_chapter', $this->data);  
     
        $this->load->view('footer');
    } 


  public function subject_class_chapter()
    {
		$rid=$this->session->userdata('role_id');
        $this->load->view('header',  $this->data);          	
		$this->load->view('Courseware/subject_class_chapter', $this->data);  
     
        $this->load->view('footer');
    } 

 public function subject_assignment_view()
    {
		$rid=$this->session->userdata('role_id');
        $this->load->view('header',  $this->data);          	
		$this->load->view('Courseware/subject_assignment_view', $this->data);  
     
        $this->load->view('footer');
    } 



   public function assignments_guidelines_view()
    {
		$rid=$this->session->userdata('role_id');
        $this->load->view('header',  $this->data);          	
		$this->load->view('Courseware/assignments_guidelines_view', $this->data);  
     
        $this->load->view('footer');
    } 

    
   public function solve_assignments()
    {
		$rid=$this->session->userdata('role_id');
        $this->load->view('header',  $this->data);          	
		$this->load->view('Courseware/solve_assignments', $this->data);  
     
        $this->load->view('footer');
    } 








      public function e_library()
    {
		$rid=$this->session->userdata('role_id');
        $this->load->view('header',  $this->data);          	
		$this->load->view('Students_template/e_library', $this->data);  
     
        $this->load->view('footer');
    }


     public function academic_calender()
    {
		$rid=$this->session->userdata('role_id');
        $this->load->view('header',  $this->data);          	
		$this->load->view('Students_template/academic_calender', $this->data);  
     
        $this->load->view('footer');
    }


      public function ticket_form()
    {
		$rid=$this->session->userdata('role_id');
        $this->load->view('header',  $this->data);          	
		$this->load->view('Students_template/ticket_form', $this->data);  
     
        $this->load->view('footer');
    }

     public function support_ticket()
    {
		$rid=$this->session->userdata('role_id');
        $this->load->view('header',  $this->data);          	
		$this->load->view('Students_template/support_ticket', $this->data);  
     
        $this->load->view('footer');
    }

       public function course_fee_details()
    {
		$rid=$this->session->userdata('role_id');
        $this->load->view('header',  $this->data);          	
		$this->load->view('course_details/course_fee_details', $this->data);  
     
        $this->load->view('footer');
    }
}
