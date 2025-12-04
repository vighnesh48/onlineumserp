<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Remuneration extends CI_Controller
{
	
    var $currentModule = "";   
    var $title = "";   
    var $table_name = "";    
    var $model_name = "Remuneration_model";   
    var $model;  
    var $view_dir = 'Remuneration/';
 
    public function __construct()
    {     
        //error_reporting(E_ALL); ini_set('display_errors', 1);
        global $menudata;      
        parent::__construct();       
        $this->load->helper("url");     
        $this->load->library('form_validation');        
        if ($this->uri->segment(2) != "" && $this->uri->segment(2) != "submit" && !in_array($this->uri->segment(2), $this->skipActions))
            $title = $this->uri->segment(2); //Second segment of uri for action,In case of edit,view,add etc.       
        else
            $title = $this->master_arr['index'];
        $this->currentModule = $this->uri->segment(1);    
        $this->data['currentModule'] = $this->currentModule;       
        $this->data['model_name'] = $this->model_name;             
        $this->load->library('form_validation');       
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
       
        $model = $this->load->model($this->model_name);
        $menu_name = $this->uri->segment(1);
        
        $this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
        $this->load->model('Marks_model');
    }

	/************** Practical faculty Assign *****************/
	public function faculty_subject($subject_id ='',$stream_id ='',$semester = '',$exam_id='',$school='', $division='', $batch='', $bkflag=''){
	   //error_reporting(E_ALL);
		$this->load->model('Timetable_model');  
		$this->load->view('header',$this->data); 
		$this->data['academicyear']=$academicyear;   
		$this->data['exam_id']=$exam_id;
		$this->data['stream_id_bsc']= $stream_id;
		
		if($bkflag==''){
			$this->data['sub']=$this->Marks_model->get_subdetails($subject_id,$stream_id,$semester,$exam_id, $division, $batch);
		}else{
			$this->data['sub']=$this->Marks_model->get_backlogsubdetails($subject_id,$stream_id,$semester,$exam_id, $division, $batch);
		}
		$this->data['labs'] = $this->Marks_model->get_all_labs(); 
		$this->data['faculty_list']=$this->Marks_model->get_faculty_list($stream_id,$semester); 	
		$this->data['peon_list']=$this->Marks_model->get_peon_list($stream_id,$semester); 	
		$this->data['lab_assist_list']=$this->Marks_model->get_lab_faculty_list($stream_id,$semester); 	
		$this->data['exfaculty_list']=$this->Marks_model->get_exfaculty_list(); 		
        $this->load->view($this->view_dir.'pract_exam_faculty_subject',$this->data);
        $this->load->view('footer');
	}
}
?>