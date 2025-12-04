<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Phd_exam_timetable extends CI_Controller
{

    var $currentModule = "";   
    var $title = "";   
    var $table_name = "unittest_master";    
    var $model_name = "Phd_exam_timetable_model";   
    var $model;  
    var $view_dir = 'Phd_examination/';
 
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
       // print_r($_POST);exit();
    }
    
    
    
    public function index($student_prn='')
    {   		
		if($student_prn !=''){
			$stud_prn = base64_decode($student_prn);
		}else{
			$stud_prn = $this->session->userdata('name');
		}
        $id= $this->Phd_exam_timetable_model->get_student_id_by_prn($stud_prn);
        $stud_id=$id['stud_id'];
		if($stud_id !=''){
			//$this->data['fee']= $this->Phd_exam_timetable_model->fetch_stud_fee_exam($stud_id);
			//if(!empty($this->data['fee'])){
			//	redirect('Examination/view_form');
			//}else{       
				$this->data['exam']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
				$this->data['bank']= $this->Phd_exam_timetable_model->fetch_banks();
				$this->data['fee']= $this->Phd_exam_timetable_model->fetch_stud_fee_exam($stud_id);
				$this->data['emp']= $this->Phd_exam_timetable_model->fetch_personal_details($stud_id);
				$this->data['sublist']= $this->Phd_exam_timetable_model->getStudAllocatedSubject($stud_id);	
			//}
		
		$this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
		}else{
			redirect('home');
		}
        
    }
    
    
    public function add()
    {  
	//print_r($_POST);exit();
     // error_reporting(E_ALL);
	  $this->load->model('Subject_model');
	  //$this->data['regulatn']= $this->Phd_exam_timetable_model->getRegulation();
	  $this->data['batches']= $this->Subject_model->getRegulation1();
	  	//  echo "<pre>";
		//  print_r($_POST);exit();
      if($_POST)
      {
	
        $this->load->view('header',$this->data);        
		$this->data['school_code'] =$_POST['school_code'];
		$this->data['admissioncourse'] =$_POST['admission-course'];
		$this->data['stream'] =$_POST['admission-branch'];
		$this->data['semester'] =$_POST['semester'];
		$this->data['batch'] =$_POST['regulation'];
		$this->data['exam_type'] =$_POST['exam_type'];
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$this->data['exam_id'] = $exam_id;
		$this->data['exam_month'] = $exam_month;
		$this->data['exam_year'] = $exam_year;
		
		$this->data['ex_dt']= $this->Phd_exam_timetable_model->fetch_examTimetable($_POST, $exam_id);
		$updsateData = $this->data['ex_dt'];
		//print_r($updsateData);exit;
		//$updsateData=array();
		if(!empty($updsateData)){
			//echo 1;exit;
			$this->load->view($this->view_dir.'update_exam_timetable',$this->data);
		}else{
			//echo 2;exit;
		    if($_POST['exam_type']=='bklg'){
		        $this->data['sub_list']= $this->Phd_exam_timetable_model->list_backlog_subjects($_POST);
		    }else{
			    $this->data['sub_list']= $this->Phd_exam_timetable_model->list_exam_subjects($_POST);		
		    }
			$this->load->view($this->view_dir.'add_exam_timetable',$this->data);
		}
		
        $this->load->view('footer');    
      }
      else
      {
      
       $this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
	
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
        $this->load->view($this->view_dir.'add_exam_timetable',$this->data);
        $this->load->view('footer');
      
      }
 
        
    }
	public function insert_exam_timetable()
    {
      $subject_id = $_POST['subject_id'];
	  $subject_code = $_POST['subject_code'];
	  $exam_date = $_POST['exam_date'];
	  $from_time = $_POST['from_time'];
	  $to_time = $_POST['to_time'];
	  $semester = $_POST['adm_semester'];
	  $stream_id = $_POST['stream_id'];
	  $exam_date = $_POST['exam_date'];
	  $display_on_hallticket = $_POST['display_on_hallticket'];
	  $exam_id = $_POST['exam_id'];
	  $batch = $_POST['batch'];
	  $exam_month = $_POST['exam_month'];
	  $exam_year = $_POST['exam_year'];
	  $examtype = $_POST['examtype'];
	 //echo $exam_date =date('Y-m-d', strtotime($exam_date1));
	 
	$DB1 = $this->load->database('umsdb', TRUE);  
     
	$exam= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
	//echo "<pre>";  
    // print_r($_POST);exit; 
	for($i=0;$i<count($subject_id);$i++){
		// for checkbox
		if(in_array($subject_id[$i], $display_on_hallticket)){
			$display_on_ht ='Y';
		}else{
			$display_on_ht ='N';
		}
		//for date
		if(!empty($exam_date[$i])){
			$examdate1 = str_replace('/', '-', $exam_date[$i]);
			$examdate = date('Y-m-d', strtotime($examdate1));
		}else{
			$examdate ='';
		}
		
		$insert_details =array(
			"exam_month"=>$exam_month,
			"exam_year"=>$exam_year,
			"subject_id"=>$subject_id[$i],
			"subject_code"=>$subject_code[$i],
			"stream_id"=>$stream_id,
			"semester" => $semester,
			"date" => $examdate,
			"exam_id" => $exam_id,
			"batch" => $batch,
			"from_time" => $from_time[$i],
			"to_time" => $to_time[$i],
			"display_on_hallticket" => $display_on_ht,
			"created_by" => $this->session->userdata("uid"),
			"created_on" => date("Y-m-d H:i:s"),
			"is_active" => 'Y',
		);
		if($examtype=='bklg'){
		    $insert_details['is_backlog'] = 'Y';
		}
		//echo "<pre>";
	//print_r($insert_details);exit;
		$DB1->insert("phd_exam_time_table", $insert_details); 
		//echo $DB1->last_query();exit;
		$exam_master_id=$DB1->insert_id(); 
		unset($insert_details);
	}
	redirect('Phd_exam_timetable/add');
	//echo "submitted successfully";
        
    }
    // insert and update
    public function update_exam_timetable()
    {    
		//echo "<pre>";
		//print_r($_POST);exit;
		$DB1 = $this->load->database('umsdb', TRUE);  
		$exam_id = $_POST['exam_id'];
	 
		if(!empty($_POST['exam_date'])){
			$examdate1 = str_replace('/', '-', $_POST['exam_date']);
			$exam_date = date('Y-m-d', strtotime($examdate1));
		}else{
			$exam_date ='';
		}
		$display_on_ht =$_POST['ht'];
		$time_table_id =$_POST['time_table_id'];
		
		$update_details =array(
			"from_time"=>$this->input->post('from_time'),
			"to_time"=>$this->input->post('to_time'),
			"date"=>$exam_date,
			"display_on_hallticket" => $display_on_ht,
			"modified_by" => $this->session->userdata("uid"),
			"modified_on" => date("Y-m-d H:i:s")
		); 	
		//echo "<pre>";
		//print_r($update_details);	exit;
		$DB1->where('time_table_id', $time_table_id);
		$DB1->where('exam_id', $exam_id);		
		$DB1->update("phd_exam_time_table", $update_details); 
		//echo $DB1->last_query();exit;
		/*$stud_subjects = $this->Phd_exam_timetable_model->update_exam_timetable($stud,$exam_month, $exam_year);
							
		
		//$emp_list =array();	
		$emp_list = $this->Phd_exam_timetable_model->list_exam_allstudents($_POST);
		$exam= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();	
		//$allstd = array();
		$allstd['ss'] = $emp_list;

		$str_output = json_encode($allstd);
		echo $str_output;*/

    } 
	function load_schools() {
        if (isset($_POST["school_code"]) && !empty($_POST["school_code"])) {
            //Get all city data
            $stream = $this->Phd_exam_timetable_model->get_courses($_POST["school_code"]);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Course</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
                }
            } else {
                echo '<option value="">Course not available</option>';
            }
        }
    }	
	
	function load_streams() {
		//echo $_POST["course_id"];exit;
        if (isset($_POST["course_id"]) && !empty($_POST["course_id"])) {
            //Get all streams
            $stream = $this->Phd_exam_timetable_model->get_streams($_POST["course_id"]);
            
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
    // approve_students 
    public function approve_students()
    {    
		$checked_stud = $_POST['chk_stud'];
		$exam= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$exam_month =$exam[0]['exam_month'];
		$exam_year =$exam[0]['exam_year'];
		//print_r($checked_stud);exit;
		foreach ($checked_stud as $stud) {
				$stud_subjects = $this->Phd_exam_timetable_model->UpdateApproveStatus($stud,$exam_month, $exam_year);
							
		}
		
		$emp_list = $this->Phd_exam_timetable_model->list_exam_allstudents($_POST);
		$exam= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		for($i=0;$i<count($emp_list);$i++){
	         $student_id =$emp_list[$i]['stud_id'];
			 $exam_month =$exam[0]['exam_month'];
			 $exam_year =$exam[0]['exam_year'];
	         $emp_list[$i]['fees']=$this->Phd_exam_timetable_model->getFeedetails($student_id);
	         $emp_list[$i]['isPresent']=$this->Phd_exam_timetable_model->getExamformStatus($student_id,$exam_month,$exam_year);
	
          } 			

		$allstd = array();
		$allstd['ss'] = $emp_list;
		$str_output = json_encode($allstd);
		echo $str_output;

    } 
	
	function generetPdf($school, $course_id,$admissionbranch, $semester,$exam_id){
			$this->load->model('Examination_model');
			//error_reporting(E_ALL);
			$this->data['strms']= $this->Phd_exam_timetable_model->fetch_examTimetablestreams($school, $course_id,$admissionbranch, $semester,$exam_id);
			$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_exam_session($exam_id);
			$i=0;
			
			foreach($this->data['strms'] as $stm){
				$stream_id =$stm['stream_id'];
				$this->data['strms'][$i]['batches']= $this->Phd_exam_timetable_model->fetch_examTimetable_batches($stream_id,$exam_id, $semester);
				$this->data['strms'][$i]['slots']= $this->Phd_exam_timetable_model->fetch_examTimetable_slots($stream_id,$exam_id, $semester);
				
				$this->data['strms'][$i]['subjects']= $this->Phd_exam_timetable_model->fetch_examTimetable_details($stream_id,$exam_id, $semester);
				$i++;
				unset($stream_id);
			}
			//echo "<pre>";
			//print_r($this->data['strms']);exit;
			$this->load->library('m_pdf');
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '35', '35');
			$header = $this->load->view($this->view_dir.'exam_timetable_pdf_header', $this->data, true);
			$html = $this->load->view($this->view_dir.'exam_timetable_pdf', $this->data, true);
			//echo $html;exit;
			$pdfFilePath = "Timetable-".$this->data['exam_session'][0]['exam_month'].'-'.$this->data['exam_session'][0]['exam_year'].		".pdf";
			$header = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
			$footer ='<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  
  <tr>
    <td align="center" class="signature" height="50" >&nbsp;</td>
    <td align="center" class="signature">&nbsp;</td>
    <td align="center" class="signature">&nbsp;</td>
   
  </tr>
  <tr>
    <td align="left" height="50" class="signature"><strong>Printed On :'.date('Y-m-d H:i:s').'</strong></td>
    <td align="center" height="50" class="signature"><strong>&nbsp;</strong></td>
    <td align="right" height="50" class="signature"><strong>COE Signature</strong></td>
   
  </tr>
</table>';
			$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
			$this->m_pdf->pdf->SetHTMLHeader($header);
			$this->m_pdf->pdf->SetHTMLFooter($footer);
			$this->m_pdf->pdf->AddPage();			
			$this->m_pdf->pdf->WriteHTML($html);
			$this->m_pdf->pdf->Output($pdfFilePath, "D");    
			
			
		}
	// view time-table
    public function viewTimetable()
    {
      //error_reporting(E_ALL);
	  $this->load->model('Examination_model');
	  $this->load->model('Subject_model');
	  //$this->data['regulatn']= $this->Phd_exam_timetable_model->getRegulation();
	  $this->data['batches']= $this->Subject_model->getRegulation1();
      if($_POST)
      {
		  //echo "<pre>";
		  //print_r($_POST);exit;
        $this->load->view('header',$this->data);        
		$this->data['school_code'] =$_POST['school_code'];
		$this->data['admissioncourse'] =$_POST['admission-course'];
		$this->data['stream'] =$_POST['admission-branch'];
		$this->data['semester'] =$_POST['semester'];
		
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_curr_exam_session();
		$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
		$exam_id =$_POST['exam_session'];
		$school=$_POST['school_code'];
		$course_id=$_POST['admission-course'];
		$admissionbranch=$_POST['admission-branch'];
		$semester=$_POST['semester'];
		$this->data['exam_id'] = $exam_id;
		
		$this->data['strms']= $this->Phd_exam_timetable_model->fetch_examTimetablestreams($school, $course_id,$admissionbranch, $semester,$exam_id);
			$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_exam_session($exam_id);
			$i=0;
			
			foreach($this->data['strms'] as $stm){
				$stream_id =$stm['stream_id'];
				$this->data['strms'][$i]['batches']= $this->Phd_exam_timetable_model->fetch_examTimetable_batches($stream_id,$exam_id, $semester);
				$this->data['strms'][$i]['slots']= $this->Phd_exam_timetable_model->fetch_examTimetable_slots($stream_id,$exam_id, $semester);
				
				$this->data['strms'][$i]['subjects']= $this->Phd_exam_timetable_model->fetch_examTimetable_details($stream_id,$exam_id, $semester);
				$i++;
			}
		//print_r($updsateData);//exit;
		$this->load->view($this->view_dir.'view_exam_timetable',$this->data);
        $this->load->view('footer');    
      }
      else
      {
      
       $this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
	
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_curr_exam_session();
		$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
        $this->load->view($this->view_dir.'view_exam_timetable',$this->data);
        $this->load->view('footer');
      
      }   
    }	
//
function load_examttschools() {
        if (isset($_POST["exam_id"]) && !empty($_POST["exam_id"])) {
            //Get all city data
            $stream = $this->Phd_exam_timetable_model->get_examttschools($_POST["exam_id"]);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select School</option>';	
				echo '<option value="0">ALL</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['school_code'] . '">' . $value['school_short_name'] . '</option>';
                }
            } else {
                echo '<option value="">school not available</option>';
            }
        }
    }	
function load_examttcourses() {
        if (isset($_POST["exam_id"]) && !empty($_POST["exam_id"])) {
            //Get all city data
			if($_POST["school_code"] !=0){
            $stream = $this->Phd_exam_timetable_model->get_examttcourses($_POST["exam_id"],$_POST["school_code"]);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Course</option>';
				echo '<option value="0">ALL</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
                }
            } else {
                echo '<option value="">Course not available</option>';
            }
			}else{
				echo '<option value="">Select Course</option>';
				echo '<option value="0">ALL</option>';
			}
        }
    }	
	function load_examttstreams() {
		//echo $_POST["course_id"];exit;
            //Get all streams
			//echo $_POST["course_id"];exit;
			if(!empty($_POST["course_id"])){
				
            $stream = $this->Phd_exam_timetable_model->get_examttstreams($_POST["exam_id"],$_POST["school_code"],$_POST["course_id"]);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Stream</option>';
				echo '<option value="0">ALL</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['stream_id'] . '">' . $value['stream_short_name'] . '</option>';
                }
            } else {
                echo '<option value="">stream not available</option>';
            }
			}else{
				echo '<option value="">Select Stream</option>';
				echo '<option value="0">ALL</option>';
			}
 
    }	
		function load_examttsemester() {
		//echo $_POST["course_id"];exit;
        if (isset($_POST["stream_id"]) && !empty($_POST["stream_id"])) {
            //Get all streams
            $stream = $this->Phd_exam_timetable_model->get_examttsemester($_POST["exam_id"],$_POST["stream_id"]);
            $rowCount = count($stream);
            if ($rowCount > 0) {
                echo '<option value="">Select Semester</option>';
				echo '<option value="0">ALL</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
                }
            } else {
                echo '<option value="">Semester not available</option>';
            }
        }else{
			echo '<option value="0">ALL</option>';
		}
    }
}
?>