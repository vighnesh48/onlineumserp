<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Batchallocation extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="subject_master";
    var $model_name="Batchallocation_model";
    var $model;
    var $view_dir='Batch_allocation/';
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
    //view
    public function index()
    {
		if($this->session->userdata("role_id")==20 ||  $this->session->userdata("role_id")==10 ||  $this->session->userdata("role_id")==44 ||  $this->session->userdata("role_id")==6 ||  $this->session->userdata("role_id")==68){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data); 
		$this->load->model('Subject_model');
	
		$this->data['academic_year']= $this->Subject_model->getAcademicYear();
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
        $this->load->view($this->view_dir.'allocatebatch',$this->data);
        $this->load->view('footer');

	}
	public function phd()
    {
		$this->load->view('header',$this->data); 
		$this->load->model('Subject_model');
		$this->data['cycle']= $this->Subject_model->admission_cycle();
		$this->data['admission_cycle']= $this->session->userdata('batch');
		$this->data['academic_year']= $this->Subject_model->getAcademicYear();
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
        $this->load->view($this->view_dir.'allocatebatch_phd',$this->data);
        $this->load->view('footer');

	}
    //search
    public function search_subAndStudent()
    {
		$this->load->model('Subject_model');
		$this->load->model('Attendance_model');
        $this->load->view('header',$this->data);                
        $stream_id = $_POST['stream_id'];
		$semester = $_POST['semester'];
		
		$this->data['courseId'] = $_POST['course_id'];
		$this->data['streamId'] = $_POST['stream_id'];
		$this->data['semesterNo'] = $_POST['semester'];
		$this->data['academicyear'] = $_POST['academic_year'];
		$academic_year =$_POST['academic_year'];

		$strm_code = $this->Batchallocation_model->getStreamCode($stream_id);	
		$this->data['class'] = $strm_code[0]['stream_code'];
		$this->data['academic_year']= $this->Subject_model->getAcademicYear();
		//$batch_code = $subject_id[1].'-'.$subject_id[2];
		//$batch_code = $subject_id[1].'-'.$subject_id[2].'-'.$subject_id[3];
		//$this->data['subdetails']= $this->Attendance_model->getsubdetails($subject_id[0]);
		if(!empty($stream_id) && !empty($semester)){
			//echo "hi";exit;
			$this->data['studlist']= $this->Batchallocation_model->get_stud_list($stream_id, $semester, $academic_year);
			$this->data['studbatch_allot_list1']= $this->Batchallocation_model->getAllocatedStudList($stream_id,$semester, $academic_year);			
		}
		
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);		    

        $this->load->view($this->view_dir.'allocatebatch',$this->data);
        $this->load->view('footer');
    }  
    public function search_subAndStudent_phd()
    {
		$this->load->model('Subject_model');
		$this->load->model('Attendance_model');
        $this->load->view('header',$this->data);                
        $stream_id = $_POST['stream_id'];
		$semester = $_POST['semester'];
		
		$this->data['courseId'] = $_POST['course_id'];
		$this->data['streamId'] = $_POST['stream_id'];
		$this->data['semesterNo'] = $_POST['semester'];
		$this->data['academicyear'] = $_POST['academic_year'];
		$academic_year =$_POST['academic_year'];
		$this->data['admission_cycle'] = $_POST['admission_cycle'];
		$admission_cycle = $_POST['admission_cycle'];

		$strm_code = $this->Batchallocation_model->getStreamCode($stream_id);	
		$this->data['class'] = $strm_code[0]['stream_code'];
		$this->data['academic_year']= $this->Subject_model->getAcademicYear();
		//$batch_code = $subject_id[1].'-'.$subject_id[2];
		//$batch_code = $subject_id[1].'-'.$subject_id[2].'-'.$subject_id[3];
		//$this->data['subdetails']= $this->Attendance_model->getsubdetails($subject_id[0]);
		if(!empty($stream_id) && !empty($semester)){
			//echo "hi";exit;
			$this->data['studlist']= $this->Batchallocation_model->get_stud_list($stream_id, $semester, $academic_year,$admission_cycle);
			$this->data['studbatch_allot_list1']= $this->Batchallocation_model->getAllocatedStudList1($stream_id,$semester, $academic_year,$admission_cycle);			
		}
		
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);		    

        $this->load->view($this->view_dir.'allocatebatch_phd',$this->data);
        $this->load->view('footer');
    }    	
	// load subject
	public function load_subject(){
		$streamId = $_POST['streamId'];
		$course_id = $_POST['course'];
		$semesterId = $_POST['semesterId'];
		$division = $_POST['division'];
		$this->data['emp']= $this->Batchallocation_model->load_subject($course_id, $streamId, $semesterId, $division);
	}
	// load streams

	function load_streams() {
        if (isset($_POST["course_id"]) && !empty($_POST["course_id"])) {
            //Get all city data
            $stream = $this->Batchallocation_model->get_course_streams($_POST["course_id"]);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Stream</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['stream_id'] . '">' . $value['stream_name'] . '</option>';
                }
            } else {
                echo '<option value="">stream not available</option>';
            }
        }
    }
    // insert and update
    public function assign_batchToStudent()
    {    

		$checked_stud = $_POST['chk_stud'];
		$sem_id = $_POST['sem'];
		$stream_id = $_POST['stream'];
		$academic_year = $_POST['academic_year'];

		foreach ($checked_stud as $stud) {

					$data['student_id'] = $stud;
					$data['batch'] = $_POST['batch'];
					$data['division'] = $_POST['division'];
					$data['semester'] = $sem_id;
					$data['stream_id'] = $stream_id;
					$data['academic_year'] = $academic_year;
					$data['entry_on'] = date('Y-m-d H:i:s');
					$data['entry_by'] = $_SESSION['uid'];
					
					$dup_exist1 = $this->Batchallocation_model->chk_dupbatchToStudent($data);
					$dup_exist =count($dup_exist1);
					//print_r($dup_exist);exit;
					if($dup_exist >= 1){
						//echo 'kjdskf';
						$this->Batchallocation_model->delete_batchToStudent($data);
					}
					//exit;
					$this->Batchallocation_model->assign_batchToStudent($data);
				//}
		}
		if(!empty($stream_id) && !empty($sem_id)){
			$all_stud= $this->Batchallocation_model->get_stud_list($stream_id, $sem_id, $academic_year);
			$all_allocated_list= $this->Batchallocation_model->getAllocatedStudList($stream_id, $sem_id, $academic_year, $_POST['division'],$_POST['batch']);
			$allocated_list= $this->Batchallocation_model->get_studbatch_allot_list($stream_id,$sem_id,$_POST['division'],$_POST['batch'], $academic_year);			
		}
		$allstd = array();
		$allstd['ss'] = $all_stud;
		$allstd['allstd'] = $all_allocated_list;
		$allstd['astd'] = $allocated_list;
		
		$str_output = json_encode($allstd);
		echo $str_output;
		//redirect('Batch_allocation/');
    } 
	//remove
	public function removeStudFromBatch($studId='')
	{
        //$this->load->view('header',$this->data); 
		$checked_stud = $_POST['chk_stud'];
		$sem_id = $_POST['sem'];
		$stream_id = $_POST['stream'];
		$academic_year =$_POST['academic_year'];

		foreach ($checked_stud as $stud) {
			//echo $stud; 
			$this->Batchallocation_model->removeStudent($stud,$stream_id,$sem_id,$_POST['division'],$_POST['batch'], $academic_year);
		}
		
		$all_stud= $this->Batchallocation_model->get_stud_list($stream_id, $sem_id, $academic_year);
		$all_allocated_list= $this->Batchallocation_model->getAllocatedStudList($stream_id, $sem_id, $academic_year, $_POST['division'],$_POST['batch']);
		$batch_list= $this->Batchallocation_model->get_studbatch_allot_list($stream_id,$sem_id,$_POST['division'],$_POST['batch'], $academic_year);
		$std = array();
		$std['batchlist'] = $batch_list;
		$std['ss'] = $all_stud;
		$std['allstd'] = $all_allocated_list;
		
		$studlist = json_encode($std);
		echo $studlist;
	}
	public function load_division(){
		
		$room_no = $_POST['room_no'];
		$semesterId = $_POST['semesterId'];
		$sub_details = $this->Batchallocation_model->load_division($room_no, $semesterId);
		$rowCount = count($sub_details);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Division</option>';
                foreach ($sub_details as $sub) {
					
					echo '<option value="'.$sub['division'].'">'.$sub['division'].'</option>';
				}
            } else {
                echo '<option value="">Division not available</option>';
            }
	}	
	
	public function fetchBatchWiseStudent($studId='')
	{
		$sem_id = $_POST['sem'];
		$stream_id = $_POST['stream'];		
		$batch_list= $this->Batchallocation_model->get_studbatch_allot_list($stream_id,$sem_id,$_POST['division'],$_POST['batch'],$_POST['academic_year']);
		$std = array();
		$std['batchlist'] = $batch_list;		
		$studlist = json_encode($std);
		echo $studlist;
	}	
	////////////////////////
	// added on 21/09/17
	//view batch allcated students
    public function viewBatchStudents()
    {
		$this->load->view('header',$this->data); 
		$this->load->model('Subject_model');
		$this->data['academic_year']= $this->Subject_model->getAcademicYear();
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
        $this->load->view($this->view_dir.'viewBatchStudents',$this->data);
        $this->load->view('footer');

	}
	
    //search batch students
    public function searchBatchStudents()
    {
		$this->load->model('Subject_model');
		$this->load->model('Attendance_model');
        $this->load->view('header',$this->data);                
        $stream_id = $_POST['stream_id'];
		$semester = $_POST['semester'];
		$division = $_POST['division'];
		$subject_id = explode('-', $_POST['subject']);
		$this->data['academicyear'] = $_POST['academic_year'];
		$academic_year =$_POST['academic_year'];
		
		$this->data['courseId'] = $_POST['course_id'];
		$this->data['streamId'] = $_POST['stream_id'];
		$this->data['semesterNo'] = $_POST['semester'];
		$this->data['division'] = $_POST['division'];
		
		
		$strm_code = $this->Batchallocation_model->getStreamCode($stream_id);
		$stream_code = $strm_code[0]['stream_code'];
		$this->data['streamName'] = $strm_code[0]['stream_name'];
		//$batch_code = $subject_id[1].'-'.$subject_id[2];
		$batch_code = $stream_code.'-'.$division;
		
		$this->data['subdetails']= $this->Attendance_model->getsubdetails($subject_id[0]);
		if(!empty($stream_id) && !empty($semester)){
			$this->data['batchstudents']= $this->Batchallocation_model->getStudBatchAllotList($stream_id,$semester, $division,$academic_year);			
		}
		
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);		    
		$this->data['academic_year']= $this->Subject_model->getAcademicYear();
        $this->load->view($this->view_dir.'viewBatchStudents',$this->data);
        $this->load->view('footer');
    } 
	
	//	Update student Roll No  added on 220917
	public function updateStudRollNo()
	{
        //$this->load->view('header',$this->data); 
		$studId = $_POST['studId'];
		$rollNo = $_POST['rollNo'];
		
		$sem_id = $_POST['sem'];	

		if($rollNo !=''){
			$chkDup = $this->Batchallocation_model->chkDupStudentRollNo($rollNo, $_POST['streamId'], $sem_id,$_POST['division'],$_POST['batch'],$_POST['academic_year']);
			$cntDup = count($chkDup);
			if($cntDup <=0){
				$this->Batchallocation_model->updateStudentRollNo($studId, $rollNo,$_POST['streamId'], $sem_id,$_POST['division'],$_POST['batch'],$_POST['academic_year']);
				echo 'SUCCESS';
			}else{
				echo "DUP";
			}
		}
	}
	///////////////
		function load_batchcources(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["academic_year"]) && !empty($_POST["academic_year"])){
			//Get all streams
			$stream = $this->Batchallocation_model->load_batchcources($_POST["academic_year"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Course</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
				}
			}else{
				echo '<option value="">Courses not available</option>';
			}
		}
	}
	function load_batch_streams(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["academic_year"]) && !empty($_POST["academic_year"])){
			//Get all streams
			$stream = $this->Batchallocation_model->load_batch_streams($_POST["course_id"],$_POST["academic_year"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Course</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['stream_id'] . '">' . $value['stream_name'] . '</option>';
				}
			}else{
				echo '<option value="">Stream not available</option>';
			}
		}
	}	
    function load_batchsemesters(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			//Get all streams
			$stream = $this->Batchallocation_model->load_batchsemesters($_POST["stream_id"], $_POST["academic_year"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Semester</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
				}
			} else{
				echo '<option value="">Semester not available</option>';
			}
		}
	}
	// load division by stream
	function load_batch_division(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			//Get all streams
			$stream = $this->Batchallocation_model->load_batch_division($_POST["stream_id"], $_POST["academic_year"], $_POST["semester"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Division</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['division'] . '">' . $value['division'] . '</option>';
				}
			} else{
				echo '<option value="">Division not available</option>';
			}
		}
	}
}
?>