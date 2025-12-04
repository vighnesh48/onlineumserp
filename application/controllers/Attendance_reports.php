<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Attendance_reports extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="subject_master";
    var $model_name="Attendance_model";
    var $model;
    var $view_dir='Attendance/';
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
	public function facultywise()
    {
		//error_reporting(E_ALL);
		$emp_id = $this->session->userdata("name");
		$this->data['schools']= $this->Attendance_model->get_faculty_schools();	
		$this->data['all_session']= $this->Attendance_model->getallSession();	
		if(!empty($_POST['school_id'])){
			//echo "<pre>";print_r($_POST);exit;
			$this->data['department_id'] = $_POST['department_id'];
			$this->data['school_id'] = $_POST['school_id'];
			$this->data['from_date'] = $_POST['from_date'];
			$this->data['to_date'] = $_POST['to_date'];
			$this->data['academic_year'] = $_POST['academic_year'];
			$this->data['attendance_data'] = $this->Attendance_model->facultywise_attendance($_POST);
            $acd_session = explode('~',  $_POST['academic_year']);
            $academic_year =$acd_session[0];
            $academic_session =$acd_session[1];
            $i=0;
			$from_date = $_POST['from_date'];
			$to_date = $_POST['to_date'];
            foreach ($this->data['attendance_data'] as $value) {

                $faculty_code = $value['faculty_code'];
                $this->data['attendance_data'][$i]['subject']= $this->Attendance_model->getFaqSubjects($faculty_code, $academic_session, $academic_year);
				$this->data['attendance_data'][$i]['leaves']= $this->Attendance_model->check_leave($faculty_code, $from_date, $to_date);
                $j=0;
                foreach ($this->data['attendance_data'][$i]['subject'] as $val) {
                    $subId = $val['subject_code'];
                    $division = $val['division'];
                    $stream_id = $val['stream_id'];
					$semester = $val['semester'];
					$batch_no = $val['batch_no'];
					
                    $this->data['attendance_data'][$i]['subject'][$j]['cntLect']= $this->Attendance_model->getNoOfLectureTaken($faculty_code, $subId, $from_date, $to_date, $division,$batch_no, $academic_session, $academic_year);
					
                    $this->data['attendance_data'][$i]['subject'][$j]['cntStud']= $this->Attendance_model->getNoOfstudts($subId, $division,$batch_no, $stream_id,$semester, $academic_year);
					
                    $this->data['attendance_data'][$i]['subject'][$j]['AvgLectPer']= $this->Attendance_model->avgPerOfSubject($faculty_code, $subId, $from_date, $to_date,$division,$batch_no, $academic_session, $academic_year);
                    $j++;
                }
                $i++;
            }

		}
		//exit;
		$this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'facultywise_attendance_report',$this->data);
        $this->load->view('footer');

	}
	// load_departments
	public function load_departments()
	{
		$school_id = $_POST['school_id'];
		$dept = $this->Attendance_model->load_faculty_departments($school_id);
		$rowCount = count($dept);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Department</option>';
                echo '<option value="0">All Department</option>';
                foreach ($dept as $dp) {
					
					echo '<option value="'.$dp['department'].'">'.$dp['department_name'].'</option>';
				}
            } else {
                echo '<option value="">Department not available</option>';
            }
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
			$this->data['from_date'] = $from_date;
			$this->data['to_date'] = $to_date;
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
				$this->data['attendance_data'][$i]['leaves']= $this->Attendance_model->check_leave($faculty_code, $from_date, $to_date);
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
}
?>