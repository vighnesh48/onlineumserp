<?php header("Access-Control-Allow-Origin: *");
defined('BASEPATH') OR exit('No direct script access allowed');

class Userprofile extends CI_Controller 
{

    var $currentModule="";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Ums_admission_model";
    var $model;
    var $view_dir='Admission/';
    
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
        $this->load->model("Admission_model");
        $this->load->library('Message_api');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
	
	public function view_studentFormDetails($stud_id){
  
         $prn=$this->input->post('prnn');
        $id= $this->Ums_admission_model->get_student_id_by_prn($prn);

         $stud_id=$id['stud_id'];
		 
		 //exit();
       // $this->load->view('header',$this->data);     
  
        $this->data['emp']= $this->Ums_admission_model->fetch_personal_details($stud_id);
		$this->data['laddr']= $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');
        $this->data['paddr']= $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','PERMNT');
		$this->data['gaddr']= $this->Ums_admission_model->fetch_address_details($stud_id,'PARENT','PERMNT');
        $this->data['qual']= $this->Ums_admission_model->fetch_qualification_details($stud_id);		
		$this->data['admdetails']= $this->Ums_admission_model->admission_details($stud_id);
		$this->data['entrance']= $this->Ums_admission_model->student_entrance_exam($stud_id);
		$this->data['ref']= $this->Ums_admission_model->student_references($stud_id, 'REF');
		$this->data['uniemp']= $this->Ums_admission_model->student_references($stud_id, 'UNIEMP');
		$this->data['unialu']= $this->Ums_admission_model->student_references($stud_id, 'UNIALU');
		$this->data['unistud']= $this->Ums_admission_model->student_references($stud_id, 'UNISTUD');
		$this->data['fromref']= $this->Ums_admission_model->student_references($stud_id, 'FROMREF');
		$this->data['docs']= $this->Ums_admission_model->fetch_document_details($stud_id);
	    $this->data['doc_list']= $this->Ums_admission_model->userdoc_list($stud_id);
		$this->data['parent_details']= $this->Ums_admission_model->fetch_parent_details($stud_id);
		$this->data['get_feedetails']= $this->Ums_admission_model->get_feedetails($stud_id);
		$this->data['get_examfeedetails']= $this->Ums_admission_model->get_examfeedetails($stud_id);
		$this->load->model('pdc_model');
		 $this->data['pdc_details']=$this->pdc_model->get_pdc_studentdetails($stud_id);  
		
		$this->data['get_refunds']= $this->Ums_admission_model->get_refundetails($stud_id);
		$this->data['tot_refunds']= $this->Ums_admission_model->get_tot_refunds($stud_id);
		$this->data['get_bankdetails']= $this->Ums_admission_model->get_bankdetails($stud_id);
		$this->data['bank_details']= $this->Ums_admission_model->getbanks();
	//	$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id);
		$this->data['admission_detail']= $this->Ums_admission_model->fetch_admission_details_all($stud_id,$acyear); 
		
		$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id,$acyear); 
	
		$this->data['totfeepaid']= $this->Ums_admission_model->fetch_total_fee_paid($stud_id);
		
		$this->data['stud_id']=$stud_id;
       // $this->load->view($this->view_dir.'view_student_form_details',$this->data);
		//$this->load->view('footer');
        //$this->load->view('footer');
		$alldata=array($this->data['emp'],$this->data['totfeepaid'],$this->data['admission_detail']);
		echo json_encode($alldata);
    } 
	
	
	
	
}

?>