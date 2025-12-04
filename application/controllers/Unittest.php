<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unittest extends CI_Controller
{

    var $currentModule = "";   
    var $title = "";   
    var $table_name = "unittest_master";    
    var $model_name = "Unittest_model";   
    var $model;  
    var $view_dir = 'Unittest/';
 
    public function __construct()
    {        
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
        
    }
    
    
    
    public function index($subje_id='')
    {        
        global $model;
        $this->load->view('header', $this->data);   
		$emp_id = $this->session->userdata("name");
		$this->load->model('Attendance_model');
		$this->data['sb']= $this->Unittest_model->getFacultySubjects($emp_id);
		if(!empty($_POST)){
			$subje_id =  $_POST['subject'];
			$subjectdetails = explode('-', $subje_id);
			$this->data['sub_Code'] = $_POST['subject'];
		}else{
			$subjectdetails = explode('-', base64_decode($subje_id));
			$this->data['sub_Code'] = base64_decode($subje_id);
		}

		if(!empty($subjectdetails[0])){
			$subject_id = $subjectdetails[0];
			$division = $subjectdetails[2];
			$semester = $subjectdetails[4];
			$academic_year = ACADEMIC_YEAR;
			$batch_code = $subjectdetails[1].'-'.$subjectdetails[2].'-'.$subjectdetails[3];
			$this->data['unittest'] = $this->Unittest_model->get_unittest_bySubject($subject_id, $semester, $batch_code, $division, $academic_year);
			$i=0;
			foreach($this->data['unittest'] as $ut){
				$ut_id = $ut['unit_test_id'];
				$this->data['unittest'][$i]['td']=$this->Unittest_model->get_numrows_testdetails($ut_id);
				$i++;
			}		
		}
        $this->load->view($this->view_dir . 'view', $this->data);               
        $this->load->view('footer');
        
    }
	
    public function add()
    {
		$this->load->model('Attendance_model');
		$this->data['classRoom']= $this->Attendance_model->getclassRoom($emp_id);		
        $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }    
     public function edit()
    {
        $this->load->view('header',$this->data);                
        $id=$this->uri->segment(3);
		$this->load->model('Attendance_model');
		$emp_id = $this->session->userdata("name");
		$this->data['classRoom']= $this->Attendance_model->getclassRoom($emp_id);
        $this->data['ut']=$this->Unittest_model->get_unittest_details($id);                            
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
       
    public function submit()
    {       
           
		$DB1 = $this->load->database('umsdb', TRUE);
        $unit_test_id=$this->input->post('unit_test_id');
        
        if($unit_test_id=="")
        {
				$date = str_replace('/', '-', $_POST['test_date']);
                $sub = explode('-',$this->input->post('subject'));
                $insert_array=array(
				    "stream_id"=>$this->input->post('room_no'),
                    "semester"=>$this->input->post('semester'),
                    "division"=>$this->input->post('division'),
                    "subject_id"=>$sub[0],
					"batch_code"=>$sub[1].'-'.$sub[2].'-'.$sub[3],
					"test_no"=>$this->input->post('test_name'),
                    "test_date" => date('Y-m-d', strtotime($date)),
                    "min_for_pass" => $this->input->post("min_for_pass"),
					"max_mark" => $this->input->post("max_marks"),
                    "academic_year" => ACADEMIC_YEAR,
                    "inserted_by" => $this->session->userdata("uid"),
                    "inserted_on" => date("Y-m-d H:i:s"),
                    "active" => 'Y'); 
				$DB1->insert("student_test_master", $insert_array); 
				$last_inserted_id=$DB1->insert_id();
                redirect("Unittest");
            
        }
        else
        {
				$date = str_replace('/', '-', $_POST['test_date']);
                $sub = explode('-',$this->input->post('subject'));
                $update_array=array(
                    "stream_id"=>$this->input->post('room_no'),
                    "semester"=>$this->input->post('semester'),
                    "division"=>$this->input->post('division'),
                    "subject_id"=>$sub[0],
					"batch_code"=>$sub[1].'-'.$sub[2].'-'.$sub[3],
					"test_no"=>$this->input->post('test_name'),
                    "test_date" => date('Y-m-d', strtotime($date)),
                    "min_for_pass" => $this->input->post("min_for_pass"),
					"max_mark" => $this->input->post("max_marks"),
                    "academic_year" => ACADEMIC_YEAR,
                    "modified_by" => $this->session->userdata("uid"),
                    "modifed_on" => date("Y-m-d H:i:s"),
                    "active" => 'Y');                                                                                     
                                
                $where=array("unit_test_id"=>$unit_test_id);
                $DB1->where($where);                
                if($DB1->update('student_test_master', $update_array))
                {      
					//echo $DB1->last_query();exit;
                    redirect(base_url($this->view_dir));
                }
                else
                {  //echo $DB1->last_query();exit;
                    redirect(base_url($this->view_dir));
                }
            
        }
        
         
         
        
    }
    public function testdetails($testId)
    {
		$testId = base64_decode($testId);
		$this->load->model('Attendance_model');
		$this->data['subj_Id']=$this->uri->segment(4);
		$this->data['ut']=$this->Unittest_model->fetch_unittest_details($testId);	
		//$this->data['td']=$this->Unittest_model->get_test_details($testId);	
		$batch_code = explode('-', $this->data['ut'][0]['batch_code']);
		$th_batch = $batch_code[2];
		$this->data['allbatchStudent'] = $this->Unittest_model->get_studListByDivision($this->data['ut'][0]['batch_code'],$th_batch, $this->data['ut'][0]['semester']);		
        $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'add_testdetails',$this->data);
        $this->load->view('footer');
    }
	public function submitTestDetails()
    {       
        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$stud_id = $_POST['stud_id'];
		$marks_obtained = $_POST['marks_obtained'];
		$subject_id = $this->input->post('subject_id');
		$enrollement_no =$this->input->post('enrollement_no');
		//echo "<pre>";
		//print_r($marks);
		for($i=0;$i<count($stud_id);$i++){
			$insert_array=array(
				"unit_test_id"=>$this->input->post('unit_test_id'),
				"stud_id"=>$stud_id[$i],
				"enrollement_no"=>$enrollement_no[$i],
				"marks_obtained"=>$marks_obtained[$i],
				"subject_id"=>$subject_id,
				"academic_year" => ACADEMIC_YEAR,
				"inserted_by" => $this->session->userdata("uid"),
				"inserted_on" => date("Y-m-d H:i:s"),
				"active" => 'Y'); 
			//print_r($insert_array);	exit;
			$DB1->insert("student_test_details", $insert_array); 
			//echo $DB1->last_query();exit;
			
			$last_inserted_id=$DB1->insert_id();               
			
		}
        if($last_inserted_id)
			{
				redirect(base_url($this->view_dir));
			}    
	}
	public function editTestDetails($testId)
    {
		$testId = base64_decode($testId);
		$this->data['subj_Id']=$this->uri->segment(4);
		$this->load->model('Attendance_model');
		$this->data['ut']=$this->Unittest_model->fetch_unittest_details($testId);	
		$this->data['td']=$this->Unittest_model->get_test_details($testId);			
        $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'edit_testdetails',$this->data);
        $this->load->view('footer');
    }
	//update
	public function updateStudMarks()
    {       
        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$stud_id = $_POST['studId'];
		$marks_obtained = $_POST['stud_marks'];
		$subjectId = $this->input->post('subjectId');
		$unit_test_id =$this->input->post('unit_test_id');
		$academic_year =$this->input->post('academic_year');		
		//echo "<pre>";
		//print_r($marks);  
		$update_array['marks_obtained'] = $marks_obtained;
		$where=array("unit_test_id"=>$unit_test_id,"stud_id"=>$stud_id,"subject_id"=>$subjectId,"academic_year"=>$academic_year,"unit_test_id"=>$unit_test_id,);
		$DB1->where($where);                
		$DB1->update('student_test_details', $update_array);
		echo "SUCCESS";
		//echo $DB1->last_query();exit;
	} 
	
	//fetch MarkesDetails
    public function fetchMarkesDetails()
    {    
		if(!empty($_POST['test_id'])){
			$testId = $_POST['test_id'];
		}
		
		$stud_att=$this->Unittest_model->get_test_details($testId);		
		//echo count($CntDup);
		if(!empty($stud_att)){			
			$allstd = array();
			$allstd['ss'] = $stud_att;
			$str4 = json_encode($allstd);
			echo $str4;
		}else{
			echo "dupyes";
		}
    }
	//
	public function consolidated_testdetails($subject_id)
    {

		$subject = base64_decode($subject_id);
		if($subject !=''){
			$subjectdetails = explode('-', $subject);
			$subject_id = $subjectdetails[0];
			$division = $subjectdetails[2];
			$semester = $subjectdetails[4];
			$academic_year = ACADEMIC_YEAR;
			$batch_code = $subjectdetails[1].'-'.$subjectdetails[2].'-'.$subjectdetails[3];
			$this->data['unittest'] = $this->Unittest_model->get_unittest_bySubject($subject_id, $semester, $batch_code, $division, $academic_year);	
			$this->data['subdetails'] = $this->Unittest_model->getsubdetails($subject_id);
			$data['division'] = $subjectdetails[2];
		//echo "<pre>";
		//print_r($this->data['unittest']);
		//$this->data['td']=$this->Unittest_model->get_test_details($testId);	
		$batch_code = $subjectdetails[1].'-'.$subjectdetails[2].'-'.$subjectdetails[3];
		$th_batch = $subjectdetails[3];
		$semester = $subjectdetails[4];
		$this->data['allbatchStudent'] = $this->Unittest_model->get_studListByDivision($batch_code,$th_batch, $semester);
		
		}
		
        $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'consolidated_testdetails',$this->data);
        $this->load->view('footer');
    }
}
?>