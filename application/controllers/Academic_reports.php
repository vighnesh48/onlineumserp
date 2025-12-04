<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Academic_reports extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="subject_master";
    var $model_name="Academic_reports_model";
    var $model;
    var $view_dir='Academic/';
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

	// Facultywise load report
	public function timetable_entry()
    {
		//error_reporting(E_ALL);
		$emp_id = $this->session->userdata("name");
       
		$this->load->model('Attendance_model');
		$this->data['all_session']= $this->Attendance_model->getallSession();	
		if(!empty($_POST['academic_year'])){
			$this->data['academic_year'] = $_POST['academic_year'];
			$this->data['ttentry'] = $this->Academic_reports_model->fetch_timetable_entry($_POST);
		}
		//exit;
		$this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'timetable_entry_report',$this->data);
        $this->load->view('footer');

	}
    public function timetable_entry123()
    {
        //error_reporting(E_ALL);
        $emp_id = $this->session->userdata("name");
        echo $emp_id ;
        die;
        $this->load->model('Attendance_model');
        $this->data['all_session']= $this->Attendance_model->getallSession();   
        if(!empty($_POST['academic_year'])){
            $this->data['academic_year'] = $_POST['academic_year'];
            $this->data['ttentry'] = $this->Academic_reports_model->fetch_timetable_entry($_POST);
        }
        //exit;
        $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'timetable_entry_report',$this->data);
        $this->load->view('footer');

    }

	//export excel
	public function load_export_excel($academic_year, $department_id, $school_id, $from_date, $to_date)
    {
		//error_reporting(E_ALL);
		$emp_id = $this->session->userdata("name");
		$this->data['schools']= $this->Attendance_model->get_faculty_schools();	
		$this->data['all_session']= $this->Attendance_model->getallSession();	
		if(!empty($school_id)){
			//echo "<pre>";print_r($_POST);exit;
			$POST['department_id'] = $department_id;
			$POST['school_id'] = $school_id;
			$POST['from_date'] = $from_date;
			$POST['to_date'] = $to_date;
			$POST['academic_year'] = $academic_year;
			$this->data['academic_year'] = $academic_year;
			$this->data['attendance_data'] = $this->Attendance_model->facultywise_attendance($POST);
            $acd_session = explode('~',  $academic_year);
            $academic_year =$acd_session[0];
            $academic_session =$acd_session[1];
            $i=0;
            foreach ($this->data['attendance_data'] as $value) {

                $faculty_code = $value['faculty_code'];
                $this->data['attendance_data'][$i]['subject']= $this->Attendance_model->getFaqSubjects($faculty_code, $academic_session, $academic_year);
                $j=0;
                foreach ($this->data['attendance_data'][$i]['subject'] as $val) {
                    $subId = $val['subject_code'];
                    $division = $val['division'];
                    $batch_no = $val['batch_no'];
                    $this->data['attendance_data'][$i]['subject'][$j]['cntLect']= $this->Attendance_model->getNoOfLectureTaken($faculty_code, $subId, $from_date, $to_date, $division,$batch_no, $academic_session, $academic_year);
                    
                    $this->data['attendance_data'][$i]['subject'][$j]['AvgLectPer']= $this->Attendance_model->avgPerOfSubject($faculty_code, $subId, $from_date, $to_date,$division,$batch_no, $academic_session, $academic_year);
                    $j++;
                }
                $i++;
            }

		}
		
        $this->load->view($this->view_dir.'faculty_load_excel',$this->data);
	}


     public function subject_notallocted()
    {
        //error_reporting(E_ALL);
        $emp_id = $this->session->userdata("name");
       
        $this->load->model('Attendance_model');
        $this->data['all_session']= $this->Attendance_model->getallSession();   
        if(!empty($_POST['academic_year'])){
            $this->data['academic_year'] = $_POST['academic_year'];
            $this->data['ttentry'] = $this->Academic_reports_model->subjectnotallocated_to_student($_POST);
        }
        //exit;
        $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'subject_Not_allocated',$this->data);
        $this->load->view('footer');

    }

     public function Reports()
    {
        //error_reporting(E_ALL);
		$this->load->model('Exam_timetable_model');
        $emp_id = $this->session->userdata("name");
       $this->data['schools']= $this->Exam_timetable_model->getSchools();
        $this->load->model('Attendance_model');
        $this->data['all_session']= $this->Attendance_model->getallSession();   
        if(!empty($_POST['academic_year'])){
            $this->data['academic_year'] = $_POST['academic_year'];
			$this->data['school_code'] = $_POST['school_code'];
			$this->data['school_name'] = 'SUN';
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
            $this->data['reporttype'] = $_POST['reporttype'];
            $acd_yr = explode('~',$_POST['academic_year']);
            $this->data['acd_yr']=$acd_yr[0];
            if($_POST['reporttype']=='1')
            {   
				$this->data['title'] = 'Time table Entry Not Done List';
                $this->data['ttentry'] = $this->Academic_reports_model->fetch_timetable_entry($_POST);
                $this->data['reporttype']=$_POST['reporttype'];
				$this->load->view('header',$this->data); 
				$this->load->view($this->view_dir.'subject_Not_allocated1',$this->data);
				$this->load->view('footer');

            }else if($_POST['reporttype']=='2')
            {
				$this->data['title'] = 'Subject Allocation Not Done List';
                $this->data['ttentry'] = $this->Academic_reports_model->subjectnotallocated_to_student($_POST);
                $this->data['reporttype']=$_POST['reporttype'];
				$this->load->view('header',$this->data); 
				$this->load->view($this->view_dir.'subject_Not_allocated1',$this->data);
				$this->load->view('footer');

            }
            else if($_POST['reporttype']=='3')
            {
				//$today =date('Y-m-d');
				$today =$_POST['att_date'];
				//$this->load->model('Student_attendance_model');
				$hldy = $this->Academic_reports_model->check_holidays($today,$typ=1);
				
				if($hldy =='false'){
					$this->data['ttentry'] = $this->Academic_reports_model->fetch_consolated_lecture_details($_POST);
					$i=0;
					foreach($this->data['ttentry'] as $value){
						 $stream_id =$value['stream_id']; 
						 $semester =$value['semester']; 
						 $this->data['ttentry'][$i]['lecttaken'] = $this->Academic_reports_model->fetch_lecture_taken_details($stream_id,$semester,$acd_yr,$today);
						 $i++;
					}
				}
                $this->data['reporttype']=$_POST['reporttype'];
				$this->data['holiday']=$hldy;
				$this->load->view('header',$this->data); 
				$this->load->view($this->view_dir.'consolated_lecture_details.php',$this->data);
				$this->load->view('footer');
				
            }
			else if($_POST['reporttype']=='4')
            {
				$this->data['title'] = 'Re-registartion Not Done List';
				$this->data['stud_list'] = $this->Academic_reports_model->get_student_not_registered_list($_POST,$acd_yr);				
                $this->data['reporttype']=$_POST['reporttype'];
				$this->data['holiday']=$hldy;
				$this->load->view('header',$this->data); 
				$this->load->view($this->view_dir.'subject_Not_allocated1.php',$this->data);
				$this->load->view('footer');
				
            }else if($_POST['reporttype']=='6')
            {
				$this->data['title'] = 'Subject Syllabus Not Done List';			
				$this->data['subjects'] = $this->Academic_reports_model->get_subjects_without_syllabus($_POST,$acd_yr);			
                $this->data['reporttype']=$_POST['reporttype'];
				$this->load->view('header',$this->data); 
				$this->load->view($this->view_dir.'subject_Not_allocated1.php',$this->data);
				$this->load->view('footer');
				
            }else if($_POST['reporttype']=='7')
            {
				$this->data['title'] = 'Lecture Plan Not Done List';				
				$this->data['subjects'] = $this->Academic_reports_model->get_subjects_without_lecture_plan($_POST,$acd_yr);			
                $this->data['reporttype']=$_POST['reporttype'];
				$this->load->view('header',$this->data); 
				$this->load->view($this->view_dir.'subject_Not_allocated1.php',$this->data);
				$this->load->view('footer');
				
            }else if($_POST['reporttype']=='8')
            {
				$this->data['title'] = 'Question Bank Not Done List';		
				$this->data['subjects'] = $this->Academic_reports_model->get_subjects_without_assignment_question_bank($_POST,$acd_yr);			
                $this->data['reporttype']=$_POST['reporttype'];
				$this->load->view('header',$this->data); 
				$this->load->view($this->view_dir.'subject_Not_allocated1.php',$this->data);
				$this->load->view('footer');
				
            }else if($_POST['reporttype']=='9')
            {
				$this->data['title'] = 'Faculty Load Report';		
				$this->data['faculty_load_report'] = $this->Academic_reports_model->get_faculty_load_report($_POST,$acd_yr);			
                $this->data['reporttype']=$_POST['reporttype'];
				$this->load->view('header',$this->data); 
				$this->load->view($this->view_dir.'subject_Not_allocated1.php',$this->data);
				$this->load->view('footer');
				
            }else if($_POST['reporttype']=='10')
            {
				$this->data['title'] = 'Program/semester/batch wise students count Report';		
				$this->data['faculty_load_report'] = $this->Academic_reports_model->get_program_batch_report('2025-26', 'WIN');			
                $this->data['reporttype']=$_POST['reporttype'];
				$this->load->view('header',$this->data); 
				$this->load->view($this->view_dir.'subject_Not_allocated1.php',$this->data);
				$this->load->view('footer');
				
            }else if($_POST['reporttype']=='11')
            {
				$this->data['title'] = 'Overlapping Timetable report';		
				$this->data['faculty_load_report'] = $this->Academic_reports_model->get_overlapping_timetable_report($_POST,$acd_yr);			
                $this->data['reporttype']=$_POST['reporttype'];
				$this->load->view('header',$this->data); 
				$this->load->view($this->view_dir.'subject_Not_allocated1.php',$this->data);
				$this->load->view('footer');
				
            }
            
        }else{
        //exit;
			$this->load->view('header',$this->data); 
			$this->load->view($this->view_dir.'subject_Not_allocated1',$this->data);
			$this->load->view('footer');
		}

    }
	public function load_courses_for_studentlist()
	{    
	   $course_details =  $this->Academic_reports_model->load_courses_for_studentlist($_POST['academic_year'],$_POST['school_code']);  
	   $opt ='<option value="">Select All</option>';
	   foreach ($course_details as $course) {

			$opt .= '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
		}
			echo $opt;
	}
	public function load_streams_student_list()
	{    
		$stream_details= $this->Academic_reports_model->load_streams_student_list($_POST);
		$opt ='<option value="">Select All</option>';
	   foreach ($stream_details as $str) {

			$opt .= '<option value="' . $str['stream_id'] . '"' . $sel . '>' . $str['stream_name'] . '</option>';
		}
		echo $opt;		
	}
	public function load_studsemesters()
	{    
		$stream_details= $this->Academic_reports_model->load_studsemesters($_POST);
		$opt ='<option value="">Select All</option>';
		
	   foreach ($stream_details as $str) {

			$opt .= '<option value="' . $str['semester'] . '"' . $sel . '>' . $str['semester'] . '</option>';
		}
		echo $opt;		
	}	
}
?>