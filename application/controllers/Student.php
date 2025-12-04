<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Student extends CI_Controller 
{
    var $currentModule="";
    var $title="";

    var $model_name="Ums_admission_model";
    var $model;
    var $view_dir='Student/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        $this->load->helper("url");		  
        $this->load->library('form_validation');
		$this->load->library('zip');
        
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
    //view
    
    public function exam_result()
    {
       
        $this->data['stud']=$this->Ums_admission_model->searchStudentsajax(array('prn'=>$this->session->userdata('name')));
		$stdata = $this->data['stud'][0];
		$this->data['ex_list']= $this->Ums_admission_model->get_stud_exams($stdata['stud_id'],$stdata['admission_cycle']);		
        $this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'result_list',$this->data);
        $this->load->view('footer');
    }
    
    public function fees_challan_list()
    {
        
    }
	
	/* public function createzip(){
		 exit;
       $filename = "backup.zip";
       $this->load->model('Ums_admission_model');
       $student_datas = $this->Ums_admission_model->get_all_studentdata();
       foreach($student_datas as $student_data){
		   
		 rename("'uploads/student_photo/'.$student_data['enrollment_no_new'].'.jpg'","'uploads/student_photo/'.$student_data['enrollment_no'].'.jpg");  
        $path  = 'uploads/student_photo/'.$student_data['enrollment_no'].'.jpg';
        if (file_exists($path)) {
        $filepath = $path ;
         }else{
            $path1  = 'uploads/student_photo/'.$student_data['enrollment_no_new'].'.jpg';
            $filepath = $path1;
        }
       $this->zip->read_file($filepath);
        }

        // Download
        $filename = "student_pic_2022.zip";
        $this->zip->download($filename);

     }
	 */
   
}
?>