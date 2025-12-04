<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class subject_allocation_phd extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="subject_master";
    var $model_name="Phd_subject_allocation_model";
    var $model;
    var $view_dir='Phd_subject/';
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
        $this->load->view('header',$this->data);        
        $this->data['subj_details']=$this->phd_subject_model->get_subject_details();       	                                        
        $this->load->view($this->view_dir.'view_allocated_subject',$this->data);
        $this->load->view('footer');
    }
    // add
    public function allocate_subject()
    {
        $this->load->view('header',$this->data); 
		$this->load->model('phd_subject_model');
		$this->data['course_details']= $this->phd_subject_model->getCollegeCourse($college_id);	
		$this->data['academic_year']= $this->phd_subject_model->getAcademicYear(); 
		$this->data['cycle']= $this->phd_subject_model->admission_cycle();
		//$this->data['regulation']= $this->phd_subject_model->getRegulation();
		$this->data['batches']= $this->phd_subject_model->getRegulation1();
		if(!empty($this->session->userdata('SAstream_id'))){	

			$course_id = $this->session->userdata('SAcourseId');
			$stream_id = $this->session->userdata('SAstream_id');
			$semester = $this->session->userdata('SAsemester');
			$academic_year = $this->session->userdata('SAacademic_year');
			$admission_cycle = $this->session->userdata('admission_cycle');
			//$regulation = $this->session->userdata('SAregulation');
			$batch = $this->session->userdata('SAbatch');
			$academicyear = explode('-',$academic_year);
			$acdemicyear =$academicyear[0];
			$this->data['courseId'] = $this->session->userdata('SAcourseId');
			$this->data['streamId'] = $this->session->userdata('SAstream_id');
			$this->data['semesterNo'] = $this->session->userdata('SAsemester');
			$this->data['SAacademic_year'] = $this->session->userdata('SAacademic_year');
			//$this->data['SAregulation'] = $this->session->userdata('SAregulation');
			$this->data['batch'] = $this->session->userdata('SAbatch');
			$this->data['admission_cycle'] = $this->session->userdata('admission_cycle');
			$this->data['studlist']= $this->Phd_subject_allocation_model->get_stud_list($stream_id, $semester,$acdemicyear);	   
			$this->data['allcated_studlist']= $this->Phd_subject_allocation_model->get_allcated_studlist($stream_id, $semester,$academic_year, $batch);
			$this->data['sublist']= $this->Phd_subject_allocation_model->get_sub_list($stream_id, $semester, $batch);
			$this->data['strmsub']= $this->Phd_subject_allocation_model->get_stream_mapping_tot_subject($stream_id, $semester, $batch);
		}
        $this->load->view($this->view_dir.'allocate_subject',$this->data);
        $this->load->view('footer');
    }

    //edit
    public function search_subAndStudent()
    {
		$this->load->model('phd_subject_model');
        $this->load->view('header',$this->data);                
        $stream_id = $_POST['stream_id'];
		$academic_year = explode('-',$_POST['academic_year']);
		$academic_year =$academic_year[0];
		$semester = $_POST['semester'];
		$admission_cycle = $_POST['admission_cycle'];
		//$regulation = $_POST['regulation'];
		//$batch = $_POST['batch'];
		//$batch = $this->getBatch($academic_year,$semester, $stream_id);
		$batch=$admission_cycle;
		//print_r($_POST);exit;
		$this->data['courseId'] = $_POST['course_id'];
		$this->data['streamId'] = $_POST['stream_id'];
		$this->data['semesterNo'] = $_POST['semester'];
		$this->data['admission_cycle'] = $_POST['admission_cycle'];
		//$this->data['SAregulation'] = $_POST['regulation'];
		$this->data['SAacademic_year'] = $_POST['academic_year'];
		$this->data['batch'] = $batch;
		// added session values
		$this->session->set_userdata('SAcourseId', $_POST['course_id']);
		$this->session->set_userdata('SAstream_id', $_POST['stream_id']);
		$this->session->set_userdata('SAacademic_year', $_POST['academic_year']);
		$this->session->set_userdata('SAsemester', $_POST['semester']);
		$this->session->set_userdata('Sadmission_cycle', $_POST['admission_cycle']);
		//$this->session->set_userdata('SAregulation', $_POST['regulation']);
		$this->session->set_userdata('SAbatch', $batch);
		
		if(!empty($stream_id) && !empty($semester)){
			$this->data['studlist']= $this->Phd_subject_allocation_model->get_stud_list($stream_id, $semester,$academic_year,$admission_cycle);	   
			$this->data['allcated_studlist']= $this->Phd_subject_allocation_model->get_allcated_studlist($stream_id, $semester,$_POST['academic_year'], $batch);
			$this->data['sublist']= $this->Phd_subject_allocation_model->get_sub_list($stream_id, $semester, $batch);
			$this->data['strmsub']= $this->Phd_subject_allocation_model->get_stream_mapping_tot_subject($stream_id, $semester, $batch);
		}
		
		$this->data['course_details']= $this->phd_subject_model->getCollegeCourse($college_id);		   
		$this->data['academic_year']= $this->phd_subject_model->getAcademicYear(); 
		$this->data['regulation']= $this->phd_subject_model->getRegulation();
		$this->data['batches']= $this->phd_subject_model->getRegulation1();
		$this->data['cycle']= $this->phd_subject_model->admission_cycle();

        $this->load->view($this->view_dir.'allocate_subject',$this->data);
        $this->load->view('footer');
    } 


      public function search_subAndStudentdetails($course_id='',$stream_id='',$semester='',$academic_yearr='')
    {
		$this->load->model('phd_subject_model');
        $this->load->view('header',$this->data);                
        $stream_id = $stream_id;
		$academic_year = explode('-',$academic_yearr);
		$academic_year =$academic_year[0];
		$semester = $semester;
		//$regulation = $_POST['regulation'];
		//$batch = $_POST['batch'];
		$batch = $this->getBatch($academic_year,$semester, $stream_id);
		//print_r($_POST);exit;
		$this->data['courseId'] = $course_id;
		$this->data['streamId'] = $stream_id;
		$this->data['semesterNo'] = $semester;
		//$this->data['SAregulation'] = $_POST['regulation'];
		$this->data['SAacademic_year'] = $academic_yearr;
		$this->data['batch'] = $batch;
		// added session values
		$this->session->set_userdata('SAcourseId', $course_id);
		$this->session->set_userdata('SAstream_id', $stream_id);
		$this->session->set_userdata('SAacademic_year', $academic_yearr);
		$this->session->set_userdata('SAsemester', $semester);
		//$this->session->set_userdata('SAregulation', $_POST['regulation']);
		$this->session->set_userdata('SAbatch', $batch);
		
		if(!empty($stream_id) && !empty($semester)){
			$this->data['studlist']= $this->Phd_subject_allocation_model->get_stud_list($stream_id, $semester,$academic_year);	   
			$this->data['allcated_studlist']= $this->Phd_subject_allocation_model->get_allcated_studlist($stream_id, $semester,$academic_yearr, $batch);
			$this->data['sublist']= $this->Phd_subject_allocation_model->get_sub_list($stream_id, $semester, $batch);
			$this->data['strmsub']= $this->Phd_subject_allocation_model->get_stream_mapping_tot_subject($stream_id, $semester, $batch);
		}
		
		$this->data['course_details']= $this->phd_subject_model->getCollegeCourse($college_id);		   
		$this->data['academic_year']= $this->phd_subject_model->getAcademicYear(); 
		$this->data['regulation']= $this->phd_subject_model->getRegulation();
		$this->data['batches']= $this->phd_subject_model->getRegulation1();

        $this->load->view($this->view_dir.'allocate_subjectview',$this->data);
        $this->load->view('footer');
    }   
	function getBatch($academic_year,$semester, $stream_id){
		if($stream_id !='71'){
			if($semester=='1' || $semester=='2'){
				$batch = $academic_year;
			}else if($semester=='3' || $semester=='4'){
				$batch = $academic_year-1;
			}else if($semester=='5' || $semester=='6'){
				$batch = $academic_year-2;
			}else if($semester=='7' || $semester=='8'){
				$batch = $academic_year-3;
			}
		}else{
			if($semester=='1'){
				$batch = $academic_year;
			}else if($semester=='2'){
				$batch = $academic_year-1;
			}else if($semester=='3'){
				$batch = $academic_year-2;
			}else if($semester=='4'){
				$batch = $academic_year-3;
			}
			
		}
		return $batch;
	}
    // insert and update
    public function assign_subToStudent()
    {    
		$checked_sub = $_POST['chk_sub'];
		$checked_stud = $_POST['chk_stud'];
		$sem_id = $_POST['sem_id'];
		$sub_stream = $_POST['sub_stream'];
		$batch = $_POST['batch'];
		
		$data2['stud_id'] = $stud;
		$data2['semester'] = $sem_id;
		//$data2['academic_year'] = $_POST['acad_year'];
		$data2['stream_id'] = $sub_stream;
		$edit_status=$_POST['edit_status'];
		
		$this->session->set_userdata('SAstream_id', $sub_stream);
		$this->session->set_userdata('SAsemester', $sem_id);
		$this->session->set_userdata('admission_cycle', $batch);
		$this->session->set_userdata('SAbatch', $batch);
		//print_r($_POST);
		//exit();
		//if($_POST['edit_status']!="Y"){
			
			$i=0;
		foreach ($checked_stud as $stud) {
			
			if($edit_status[$i]=="N"){
				
			$data2['stud_id'] = $stud;
			//$this->Phd_subject_allocation_model->delete_dupsubToStudent($data2); // delete all student subject
			//$this->Phd_subject_allocation_model->delete_studFromBatchAllocation($data2); // De-allocate batch of student
			
			foreach ($checked_sub as $sub) {
				$data['subject_id'] = $sub;
				$data['stud_id'] = $stud;
				$data['stream_id'] = $sub_stream;
				$data['semester'] = $sem_id;
				//$data['academic_year'] = $_POST['acad_year'];
				//$data['admission_cycle'] = $_POST['batch'];
				$data['entry_on'] = date('Y-m-d H:i:s');
				$data['entry_by'] = $_SESSION['uid'];
				$dup_exist1 = $this->Phd_subject_allocation_model->chk_dupsubToStudent($data);
				//$dup_exist1 =array();
				$dup_exist =count($dup_exist1);
				if($dup_exist < 1){
					$this->Phd_subject_allocation_model->assign_subToStudent($data); //insert all subject for student
				}else{
					//echo "dup";echo "<br>";
				}
			}
			}else{ //if($edit_status[$i]=="N")
				
				foreach ($checked_sub as $sub) {
				$data['subject_id'] = $sub;
				$data['stud_id'] = $stud;
				$data['stream_id'] = $sub_stream;
				$data['semester'] = $sem_id;
				//$data['academic_year'] = $_POST['acad_year'];
				//$data['admission_cycle'] = $_POST['batch'];
				$data['entry_on'] = date('Y-m-d H:i:s');
				$data['entry_by'] = $_SESSION['uid'];
				$dup_exist1 = $this->Phd_subject_allocation_model->chk_dupsubToStudent($data);
				$dup_exist =count($dup_exist1);
				if($dup_exist < 1){
					$this->Phd_subject_allocation_model->assign_subToStudent($data); //insert all subject for student
				}else{
					//echo "dup";echo "<br>";
				}
			}
			}
			$i++;
		}
		
		
		//}
		$this->session->set_flashdata('Smessage', 'Subject assigned successfully.');
		redirect('Subject_allocation_phd/allocate_subject');
    }
    // view_studSubject
    public function view_studSubject($stud_id)
    {
		//echo "hi";exit;
		$this->load->model('Ums_admission_model');
		$roll_id = $this->session->userdata('role_id');
		if($roll_id ==4 || $roll_id==9){      
         $id= $this->Ums_admission_model->get_student_id_by_prn($this->session->userdata('name'));
         $stud_id=$id['stud_id'];
       }
       else
       {
        $this->session->set_userdata('studId', $stud_id);
       }
       
	
        if($stud_id!=''){
		$this->data['emp']= $this->Ums_admission_model->fetch_personal_details($stud_id);
		$this->data['sems']= $this->Phd_subject_allocation_model->fetch_student_semester($stud_id);	
		}
		
		
		$this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'view_allocated_subject',$this->data);
        $this->load->view('footer');
    }
	public function removeSubject($sub_id, $studId)
	{
        $this->load->view('header',$this->data); 
		if($this->Phd_subject_allocation_model->removeSubject($sub_id))
		{
			redirect('Subject_allocation_phd/view_studSubject/'.$studId);
		}
	}

	public function removeAllSubjects($studId, $sem,$stream)
	{
        $this->load->view('header',$this->data); 
		if($this->Phd_subject_allocation_model->removeAllSubjects($studId, $sem,$stream))
		{
			redirect('Subject_allocation_phd/view_studSubject/'.$studId);
		}
	}	
		function load_streams() {
        if (isset($_POST["course_id"]) && !empty($_POST["course_id"])) {
            //Get all city data
            $stream = $this->Phd_subject_allocation_model->load_streams_student_list($_POST);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Stream</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['stream_id'] . '">' . $value['stream_name'] . '</option>';
                }
				if($_POST["course_id"]=='2'){
					echo '<option value="9">B.Tech First Year</option>';
				}elseif($_POST["course_id"]=='9'){
					echo '<option value="103">B.Sc First Year</option>';
				}
            } else {
                echo '<option value="">stream not available</option>';
            }
        }
    }
	    // load streams
	function load_semester() {
        if (!empty($_POST)) {
            //Get all city data
            $stream = $this->Phd_subject_allocation_model->load_semester_subjects($_POST);
            if($_POST["course_id"]=='2' || $_POST["course_id"]=='9'){
				//unset($stream[0]['semester']);
			}
			//print_r($stream);
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Semester</option>';
				
                foreach ($stream as $value) {	
					if($_POST["course_id"]=='2'){ // || $_POST["course_id"]=='9'
						if($value['semester']==1 || $value['semester']==2){
							
						}else{
							echo '<option value="'.$value['semester'].'">'.$value['semester'].'</option>';	
						}
				
					}else{
						echo '<option value="'.$value['semester'].'">'.$value['semester'].'</option>';	
					}
				}					
            }else{               
				if($_POST["stream_id"]=='9'){ // || $_POST["stream_id"]=='103'
					echo '<option value="">Select Semester</option>';
					echo '<option value="1">1</option>';
					echo '<option value="2">2</option>';
				}else{
					echo '<option value="">semester not available</option>';
				}
				
            }
			unset($_POST);
        }
    }	
	////
	function load_streams_sballoc() {
        if (isset($_POST["course_id"]) && !empty($_POST["course_id"])) {
            //Get all city data
            $stream = $this->Phd_subject_allocation_model->load_streams_student_list_sballoc($_POST);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Stream</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['stream_id'] . '">' . $value['stream_name'] . '</option>';
                }
				if($_POST["course_id"]=='2'){
					echo '<option value="9">B.Tech First Year</option>';
				}elseif($_POST["course_id"]=='9'){
					echo '<option value="103">B.Sc First Year</option>';
				}
            } else {
                echo '<option value="">stream not available</option>';
            }
        }
    }
	    // load streams
	function load_semester_sballoc() {
        if (!empty($_POST)) {
            //Get all city data
            $stream = $this->Phd_subject_allocation_model->load_semester_subjects_sballoc($_POST);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Semester</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
                }
            } else {
                echo '<option value="">semester not available</option>';
            }
        }
    }	
}
?>