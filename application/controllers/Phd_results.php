<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Phd_results extends CI_Controller
{
	
    var $currentModule = "";   
    var $title = "";   
    var $table_name = "";    
    var $model_name = "Phd_results_model";   
    var $model;  
    var $view_dir = 'Phd_results/';
 
    public function __construct()
    {     
//error_reporting(E_ALL);exit();	
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
        $this->load->model('phd_marks_model');
		if(($this->session->userdata("role_id")==15)||($this->session->userdata("role_id")==6)||($this->session->userdata("role_id")==64)
			||($this->session->userdata("role_id")==14)){}else{
			redirect('home');
			}
		$this->load->library('Awssdk');
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
	
    public function search()
    {
		//error_reporting(E_ALL);exit();
      $this->load->model('Phd_exam_timetable_model');
      if($_POST)
      {
		//  echo "<pre>";
		//  print_r($_POST);//exit;
        $this->load->view('header',$this->data);        
		$this->data['school_code'] =$_POST['school_code'];
		$this->data['admissioncourse'] =$_POST['admission-course'];
		$this->data['stream'] =$_POST['admission-branch'];
		$this->data['semester'] =$_POST['semester'];
		$this->data['exam'] =$_POST['exam_session'];
		$this->data['marks_type'] =$_POST['marks_type'];
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$this->data['stud_list']= $this->Phd_results_model->getStudentSubjectMarks($_POST,$exam_month,$exam_year, $exam_id);

		$this->load->view($this->view_dir.'search_result_data',$this->data);
		
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
        $this->load->view($this->view_dir.'search_result_data',$this->data);
        $this->load->view('footer');
      
      }
 
        
    }  
    public function forword_result_org($result_data1='')
    {        

       // $this->load->view('header', $this->data);
        $result_data = $_POST['res_data']; 
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);
		$subdetails = explode('~', $result_data);

		$school_code  =$subdetails[0];
		$stream =$subdetails[1];
		$semester =$subdetails[2];
		$exam_month =$subdetails[3];
		$exam_year =$subdetails[4];

		$res_details['school_id'] = $school_code;
		$res_details['stream_id'] = $stream;
		$res_details['semester'] = $semester;
		$res_details['exam_month'] = $exam_month;
		$res_details['exam_year'] = $exam_year;
		$res_details['ready_for_result'] = 'Y';
		$res_details['result_date'] = date('Y-m-d');
		$res_details['entry_by'] = $this->session->userdata("uid");
		$res_details['entry_on'] = date('Y-m-d H:i:s');
		$res_details['entry_ip'] = $this->input->ip_address();
		$grace =array('1','2','3'); //grace marks array
		$chk1 = $this->Phd_results_model->check_for_duplicate_result($stream, $semester, $exam_month, $exam_year);
		if(count($chk1) <= 0)
		{
			$DB1->insert("phd_exam_result_details", $res_details);
		}
 
		$result_info = $this->Phd_results_model->fetch_result_data($result_data);

		foreach ($result_info as $res) {
			$sub_id = $res['subject_id'];
			$th_marks = $this->Phd_results_model->fetch_theory_marks($sub_id, $stream, $semester, $exam_month, $exam_year);

			$cia_marks = $this->Phd_results_model->fetch_cia_marks($sub_id, $stream, $semester, $exam_month, $exam_year);

			$subdet = $this->Phd_results_model->fetch_subject_details($sub_id);
			$cia_max_mrks = $subdet[0]['internal_max'];
			echo $th_min_mrks = $subdet[0]['theory_min_for_pass'];

			for($i=0;$i< count($th_marks); $i++){
				$data['student_id']= $th_marks[$i]['stud_id'];
				$data['enrollment_no']= $th_marks[$i]['enrollment_no'];
				$data['exam_id']= $th_marks[$i]['exam_id'];
				$data['exam_month']= $th_marks[$i]['exam_month'];
				$data['exam_year']= $th_marks[$i]['exam_year'];
				$data['school_id']= $school_code;
				$data['stream_id']= $th_marks[$i]['stream_id'];
				$data['semester']= $th_marks[$i]['semester'];
				$data['subject_id']= $th_marks[$i]['subject_id'];
				$data['subject_code']= $th_marks[$i]['subject_code1'];
				$data['exam_marks']= $th_marks[$i]['marks'];
				$data['cia_marks']= $cia_marks[$i]['cia_marks'];
				$data['entry_on'] = date('Y-m-d H:i:s');

				// cia grade conversion to 50% 
				if($cia_max_mrks < 50){
					// if less than 50
					$cia_garde_marks = (50*$cia_marks[$i]['cia_marks'])/$cia_max_mrks;
				}else if($cia_max_mrks > 50 && $cia_max_mrks < 100){
					// if gratter than 50
					$cia_garde_marks = (50*$cia_marks[$i]['cia_marks'])/$cia_max_mrks;
				}elseif($cia_max_mrks == 50){
					// equal to 50
					$cia_garde_marks = ($cia_marks[$i]['cia_marks'] * 100)/100;
				}else{

				}


				$exam_grade_marks = ($th_marks[$i]['marks'] * 50)/100;            // conversion to 50 % of theory marks
				
				$data['cia_garde_marks']= $cia_garde_marks;
				$data['exam_grade_marks']= $exam_grade_marks;
				echo "th".$th_marks[$i]['marks'];
				// check for gress marks
				if($th_marks[$i]['marks'] < $th_min_mrks){                    // checking obtained marks with theory min marks
					echo $mrk_diff = $th_min_mrks - $th_marks[$i]['marks'];        // calculating difference 
					if(in_array($mrk_diff, $grace)){
						$exam_grade_marks = $exam_grade_marks + $mrk_diff;             // if difference is between grace array then applying grace of 1 marks
						$data['garce_marks'] = $mrk_diff;
					}else{
						$exam_grade_marks = $exam_grade_marks;				  // else as it is 
						$data['garce_marks'] = '';
					}
				}else{
					$exam_grade_marks = $exam_grade_marks;
					$data['garce_marks'] = '';
				}
				//exit;
				$data['final_garde_marks']= round($exam_grade_marks + $cia_garde_marks);  // addition of theory + cia marks 

				$data['entry_by'] = $this->session->userdata("uid");
				$data['entry_ip'] = $this->input->ip_address();

				//echo "<pre>";
				//print_r($data);//exit;
				$chk = $this->Phd_results_model->check_for_duplicate_marks($th_marks[$i]['stud_id'],$th_marks[$i]['subject_id'], $stream, $semester, $exam_id);
				//print_r($chk); echo count($chk);exit;
				if(count($chk) <= 0)
				{
					$DB1->insert("phd_exam_result_data", $data); 

				}
				//echo $DB1->last_query();exit;
			}
			//echo "inserted successfully!";
			//exit;
		}

        echo "success";
    }  
public function forword_result($result_data1='')
    {        

       // $this->load->view('header', $this->data);
        $result_data = $_POST['res_data']; 
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);
		$subdetails = explode('~', $result_data);

		$school_code  =$subdetails[0];
		$stream =$subdetails[1];
		$semester =$subdetails[2];
		$exam_month =$subdetails[3];
		$exam_year =$subdetails[4];
		$exam_id =$subdetails[5];

		$res_details['school_id'] = $school_code;
		$res_details['stream_id'] = $stream;
		$res_details['semester'] = $semester;
		$res_details['exam_id'] = $exam_id;
		$res_details['exam_month'] = $exam_month;
		$res_details['exam_year'] = $exam_year;
		$res_details['ready_for_result'] = 'Y';
		$res_details['result_date'] = date('Y-m-d');
		$res_details['entry_by'] = $this->session->userdata("uid");
		$res_details['entry_on'] = date('Y-m-d H:i:s');
		$res_details['entry_ip'] = $this->input->ip_address();
		$grace =array('1','2','3'); //grace marks array
		$chk1 = $this->Phd_results_model->check_for_duplicate_result($stream, $semester, $exam_month, $exam_year,$exam_id);
		if(count($chk1) <= 0)
		{ //echo 'inside';
			$DB1->insert("phd_exam_result_details", $res_details);
			//echo $DB1->last_query();exit;
		}
 //exit;
		$result_info = $this->Phd_results_model->fetch_students_from_exam_applied($result_data);

		foreach ($result_info as $res) {
			$stud_id = $res['stud_id'];
			//$ex_app_sub = $this->Phd_results_model->fetch_stud_exam_applied_subjects($result_data,$stud_id);
			$ex_app_sub = $this->Phd_results_model->fetch_subject_marks_status($stream,$exam_id,$semester,$stud_id);
			//echo 
			foreach ($ex_app_sub as $sb) {
				$th_status = $sb['th_status'];				
				$cia_status = $sb['cia_status'];
				$pr_status = $sb['pr_status'];

				if($th_status =='Y' || $cia_status =='Y' || $pr_status=='Y'){
					$sub_id = $sb['subject_id'];

					$th_marks = $this->Phd_results_model->get_cia_and_thmarks_details($stud_id, $sub_id, $stream, $semester, $exam_id);

					//$cia_marks = $this->Phd_results_model->fetch_cia_marks_for_result($stud_id, $sub_id, $stream, $semester, $exam_month, $exam_year);

					$subdet = $this->Phd_results_model->fetch_subject_details($sub_id); // fetching subject details from subject master
					//$thprmax = $this->Phd_results_model->fetch_max_marks_thpr($stream,$exam_id,$semester,$sub_id); // fetching subject max_marks from marks_entry
					//$ciamax = $this->Phd_results_model->fetch_max_marks_cia($stream,$exam_id,$semester,$sub_id);

					$cia_max_mrks = $sb['internal_max'];				
					$theory_max = $sb['theory_max'];
					$practica_max = $sb['practical_max'];
					
					
					//for($i=0;$i< count($th_marks); $i++){
						

						$theory_obt_marks = $th_marks[0]['marks'];
						
						$cia_obt_marks = $th_marks[0]['cia_marks'];
						
						
						if($theory_max >0 || $practica_max >0){
							$theory_obt_marks= $theory_obt_marks;
						}else{					
							$theory_obt_marks=NULL;					
						}if($cia_max_mrks >0 ){
							$cia_obt_marks = $th_marks[0]['cia_marks'];					
						}else{	
							$cia_obt_marks=NULL;
						}
						
						$data['student_id']= $th_marks[0]['stud_id'];
						$data['enrollment_no']= $th_marks[0]['enrollment_no'];
						$data['exam_id']= $exam_id;
						$data['exam_month']= $th_marks[0]['exam_month'];
						$data['exam_year']= $th_marks[0]['exam_year'];
						$data['school_id']= $school_code;
						$data['stream_id']= $th_marks[0]['stream_id'];
						$data['semester']= $th_marks[0]['semester'];
						$data['subject_id']= $th_marks[0]['subject_id'];
						$data['subject_code']= $th_marks[0]['subject_code'];
						$data['exam_marks']= $theory_obt_marks;
						$data['cia_marks']= $cia_obt_marks;
						$data['entry_on'] = date('Y-m-d H:i:s');
		
						$data['entry_by'] = $this->session->userdata("uid");
						$data['entry_ip'] = $this->input->ip_address();
						/*if($th_marks[0]['subject_id']==3210){
							
						echo "<pre>";
						print_r($data);exit;
						}*/
						$chk = $this->Phd_results_model->check_for_duplicate_marks($th_marks[0]['stud_id'],$th_marks[0]['subject_id'], $stream, $semester, $exam_id);
						//print_r($chk); echo count($chk);exit;
						if(count($chk) <= 0)
						{
							$DB1->insert("phd_exam_result_data", $data); 
							//echo $DB1->last_query();exit;

						}else{
							$data_update['exam_marks']= $th_marks[0]['marks'];
							$data_update['cia_marks']= $cia_marks[0]['cia_marks'];
							$data_update['modified_by'] = $this->session->userdata("uid");
							$data_update['modified_ip'] = $this->input->ip_address();
							$data_update['modified_on'] = date('Y-m-d H:i:s');
							$this->Phd_results_model->update_mrks_forwarded($th_marks[0]['subject_id'],$semester,$stream,$exam_month,$exam_year,$th_marks[0]['stud_id'], $data_update);
						}
						//echo $DB1->last_query();exit;
					//}
				}//end skiping subjects end
			} //end subject for loop

			
			//echo "inserted successfully!";
			//exit;
		}

        echo "success";
    }  
    //
    public function generate()
    {
		if($this->session->userdata("role_id")==15){
		}else{
			redirect('home');
		}
	//	error_reporting(E_ALL);
      $this->load->model('Phd_exam_timetable_model');
      $this->load->model('Phd_results_model');
      if($_POST)
      {

        $this->load->view('header',$this->data);        
		$this->data['school_code'] =$_POST['school_code'];
		$this->data['admissioncourse'] =$_POST['admission-course'];
		$this->data['stream'] =$_POST['admission-branch'];
		$this->data['exam'] =$_POST['exam_session'];
		//$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$this->data['exam_session']= $this->Phd_results_model->fetch_exam_allsession();
		$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
		$exam= explode('-', $_POST['exam_session']);

		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$this->data['exam_month'] =$exam_month;
		$this->data['exam_year'] =$exam_year;
		$this->data['exam_id'] =$exam_id;
		$this->data['stream_list']= $this->Phd_results_model->get_result_stream_data($_POST['admission-branch'],$exam_id);

		$this->load->view($this->view_dir.'generate_result_view',$this->data);
		
        $this->load->view('footer');    
      }
      else
      {
      
       $this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
	
		$this->data['exam_session']= $this->Phd_results_model->fetch_exam_allsession();
		$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
        $this->load->view($this->view_dir.'generate_result_view',$this->data);
        $this->load->view('footer');
      
      }
 
        
    } 
    // grade generation

    public function grade_generation()
    {        
//error_reporting(E_ALL);exit();
        $result_data = $_POST['res_data']; 
        $res_detail_id = $_POST['res_detail_id'];
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);
		$subdetails = explode('~', $result_data);

		$school_code  =$subdetails[0];
		$stream =$subdetails[1];
		$exam_month =$subdetails[2];
		$exam_year =$subdetails[3];
		$exam_id =$subdetails[4];
		$semester =$subdetails[5];

		$res_data['school_id'] = $school_code;
		$res_data['stream_id'] = $stream;
		$res_data['semester'] = $semester;
		$res_data['exam_id'] = $exam_id;
		$res_data['exam_month'] = $exam_month;
		$res_data['exam_year'] = $exam_year;
		$res_data['entry_by'] = $this->session->userdata("uid");
		$res_data['entry_on'] = date('Y-m-d H:i:s');
		$res_data['entry_ip'] = $this->input->ip_address();

		$result_info = $this->Phd_results_model->fetch_result_data_for_grade($result_data);
		//echo count($result_info);
		$grade_rule = $this->Phd_results_model->fetch_gread_rule($stream);
		$grd_rule = $grade_rule[0]['grade_rule'];
		
		$student_subjets=array();
		$grace =array('1'); //grace marks array
		$moderate_marks = array('1','2','3'); //moderate marks array
		foreach ($result_info as $res) {


			$stud_id = $res['student_id'];


			$sub = $this->Phd_results_model->fetch_reslt_subjects($result_data,$stud_id);
			//print_r($sub);	
			foreach ($sub as $key => $val) {

				$subject = $val['subject_id'];
				$subdet = $this->Phd_results_model->fetch_subject_details($subject); // fetching subject details from subject master
				
				$cia_max_mrks = $subdet[0]['internal_max'];
				$internal_min_for_pass = $subdet[0]['internal_min_for_pass'];
				$theory_max = $subdet[0]['theory_max'];
				$th_min_mrks = $subdet[0]['theory_min_for_pass'];
				$sub_max = $subdet[0]['sub_max'];
				$sub_min = $subdet[0]['sub_min'];
				
				$practical_max = $subdet[0]['practical_max'];
				$practical_min_for_pass = $subdet[0]['practical_min_for_pass'];
				
				if($subdet[0]['subject_component']=='EM'){
					$ciamax = $this->Phd_results_model->fetch_max_marks_cia($stream,$exam_id,$semester,$subject);
					$thmax = $this->Phd_results_model->fetch_max_marks_theory($stream,$exam_id,$semester,$subject);
					$prmax = $this->Phd_results_model->fetch_max_marks_practcal($stream,$exam_id,$semester,$subject);
					
					$thobtmrk = $this->Phd_results_model->fetch_thobtained_marks($result_data,$stud_id,$subject);
					$probtmrk = $this->Phd_results_model->fetch_probtained_marks($result_data,$stud_id,$subject);
					$ciaobtmrk = $this->Phd_results_model->fetch_ciaobtained_marks($result_data,$stud_id,$subject);
					
					$theory_obt_marks= $thobtmrk[0]['marks'];
					$pract_obt_marks= $probtmrk[0]['marks'];
					$cia_obt_marks= $ciaobtmrk[0]['cia_marks'];
					
					$data['exam_marks']= $pract_obt_marks;
					$data['cia_marks']= $cia_obt_marks;
					$data['practical_marks']= $theory_obt_marks;
					//echo 'subjectid-'.$subject.', ';
					if($cia_max_mrks >0 && $theory_max >0 && $practical_max >0){
							//for theory
							$exam_grade_marks =(100 * ($theory_obt_marks / $prmax[0]['max_marks'])) /2;
							$exam_min_marks=100 * ($practical_min_for_pass/ $practical_max);
							$exam_grade_marks1 =(100 * ($theory_obt_marks / $prmax[0]['max_marks']));
							//for CIA
							$cia_garde_marks = 50 * ($cia_obt_marks / $ciamax[0]['max_marks']);	
							$cia_min_marks = 50 * ($internal_min_for_pass/ $cia_max_mrks);
							//for practical
							$pr_garde_marks = 50 * ($pract_obt_marks / $thmax[0]['max_marks']);	
							$pr_min_marks = 50 * ($th_min_mrks/ $theory_max);									
					}
					/*if($subject=='1415' && $stud_id=='109'){
						echo 'th-obt-'.$pract_obt_marks;
					echo 'cia-obt-'. $cia_obt_marks;
					echo 'pr-obt-'. $theory_obt_marks;
						echo 'exgd-'.$exam_grade_marks1 =(100 * ($theory_obt_marks / $prmax[0]['max_marks']));
						echo 'exmin-'.$exam_min_marks=100 * ($practical_min_for_pass/ $practical_max);
						echo 'prgd- '.$pr_garde_marks = 50 * ($pract_obt_marks / $thmax[0]['max_marks']);	
							echo 'prmin-'.$pr_min_marks = 50 * ($th_min_mrks/ $theory_max);
					echo 'th-max'.$thmax[0]['max_marks'].', '.'cia-max'.$ciamax[0]['max_marks'].', PR-max'.$prmax[0]['max_marks'];
					echo 'cia-min-'.$cia_min_marks.', '.'pr-min-'.$pr_min_marks;echo '<br>';exit;*/
					
					$cia_th_grade_marks = ($cia_garde_marks+$pr_garde_marks)/2;//exit;
					$data['cia_garde_marks']= $cia_th_grade_marks;
					$data['exam_grade_marks']= $exam_grade_marks;
						
					$data['final_garde_marks']= round($exam_grade_marks + $cia_th_grade_marks);  // addition of theory + cia marks 

					$sub_max_marks[] = $subdet[0]['sub_max'];          // exam result master
					$sub_final_marks[] = $theory_obt_marks+$cia_obt_marks+$pract_obt_marks;
					$final_garde_marks = $data['final_garde_marks'];
					
					if(($cia_garde_marks < $cia_min_marks) && $cia_obt_marks !=NULL){  
//echo 'inside1';
					$finalgrade = 'U';
					$data['final_grade'] = 'U';
					$data['result_grade'] = 'U';
					$th_garce_required = '0';
					$sub_garce_required = '0';
					$data['garce_marks'] = '';

				}elseif(($pr_garde_marks < $pr_min_marks) && $pract_obt_marks !=NULL){
//echo 'inside2';
					$finalgrade = 'U';
					$data['final_grade'] = 'U';
					$data['result_grade'] = 'U';
					$th_garce_required = '0';
					$sub_garce_required = '0';
					$data['garce_marks'] = '';

				}elseif(($exam_grade_marks1 < $exam_min_marks) && $theory_obt_marks !=NULL){
//echo 'inside3';
					$finalgrade = 'U';
					$data['final_grade'] = 'U';
					$data['result_grade'] = 'U';
					$th_garce_required = '0';
					$sub_garce_required = '0';
					$data['garce_marks'] = '';

				}elseif($final_garde_marks < $sub_min){
				 // echo 'inside4';  
						$sub_mrk_diff = $sub_min - $final_garde_marks;        // calculating difference 
						
						if(in_array($sub_mrk_diff, $grace)){
							$final_garde_marks = $final_garde_marks;             // if difference is between grace array then applying grace of 1 marks
							$data['garce_marks'] = 1;
							$sub_garce_required = '1';
							$grade = $this->Phd_results_model->fetch_grade($final_garde_marks+1,$grd_rule);
							$data['result_grade'] = $grade[0]['grade_letter'];
							$data['final_grade'] = $grade[0]['grade_letter'];
							$finalgrade = $grade[0]['grade_letter'];
						}else{
						    
						    if(in_array($sub_mrk_diff, $moderate_marks)){         // condition for moderate marks
        					    $data['moderate_marks'] = $sub_mrk_diff;
        				    }
						    
							$finalgrade = 'U';
							$data['final_grade'] = 'U';
							$data['result_grade'] = 'U';
							$th_garce_required = '0';
							$sub_garce_required = '0';
							$data['garce_marks'] = '';
							
						}
				
				}else{
				    if($stream==71){
				    	if($final_garde_marks >=40){
				    		$grade[0]['grade_letter'] ='P';	
				    	}else{
				    		$grade[0]['grade_letter'] ='U';	
				    	}
				    	
				    }else if($stream=='116' || $stream=='119'){
						$grade = $this->Phd_results_model->fetch_grade_pharma($final_garde_marks,$grd_rule);
					}else{
						$grade = $this->Phd_results_model->fetch_grade($final_garde_marks,$grd_rule);
					}
					//$grade = $this->Phd_results_model->fetch_grade($final_garde_marks,$grd_rule);
					$data['result_grade'] = $grade[0]['grade_letter'];
					$data['final_grade'] = $grade[0]['grade_letter'];
					$finalgrade = $grade[0]['grade_letter'];
					$data['garce_marks'] = '';
					$th_garce_required = '0';

				}
					
				/*echo '<pre>';print_r($data);exit;	
					}*/	
				}else{
				$thprmax = $this->Phd_results_model->fetch_max_marks_thpr($stream,$exam_id,$semester,$subject); // fetching subject max_marks from marks_entry
				$ciamax = $this->Phd_results_model->fetch_max_marks_cia($stream,$exam_id,$semester,$subject);
				// fetching obtained marks 
				$theory_obt_marks= $val['exam_marks'];
				$cia_obt_marks= $val['cia_marks'];
				
				if($subdet[0]['subject_component']=='TH'){
					$theory_max = $subdet[0]['theory_max'];
					$th_min_mrks=$th_min_mrks;
				}else{
					$theory_max = $subdet[0]['practical_max'];
					$th_min_mrks =$subdet[0]['practical_min_for_pass'];
				}	
				/*if($cia_max_mrks < 50){
					// if less than 50
					$cia_garde_marks = (50*$cia_obt_marks)/$cia_max_mrks;
				}else if($cia_max_mrks > 50 && $cia_max_mrks <= 100){
					// if gratter than 50
					$cia_garde_marks = (50*$cia_obt_marks)/$cia_max_mrks;
				}elseif($cia_max_mrks == 50){
					// equal to 50
					$cia_garde_marks = ($cia_obt_marks * 100)/100;
				}else{

				}

				if($theory_max < 50){
					// if less than 50
					$exam_grade_marks = (50*$theory_obt_marks)/$theory_max;
				}else if($theory_max > 50 && $theory_max <= 100){
					// if gratter than 50
					$exam_grade_marks = (50*$theory_obt_marks)/100;
				}elseif($theory_max == 50){
					// equal to 50
					$exam_grade_marks = ($theory_obt_marks * 100)/100;
				}else{

				}*/
				//$exam_grade_marks = ($theory_obt_marks * 50)/100;            // conversion to 50 % of theory marks
				
				////////////////// Conversion////////////
				
				if($stream==71){      // for D-Pharma results 80-20 pattern
					$exam_grade_marks =80 * ($theory_obt_marks / $thprmax[0]['max_marks']);
					$exam_min_marks=80 * ($th_min_mrks / $theory_max);
					$cia_garde_marks = 20 * ($cia_obt_marks / $ciamax[0]['max_marks']);	
					$cia_min_marks = 20 * ($internal_min_for_pass/ $cia_max_mrks);	
					$exam_grade_marks1 =(80 * ($theory_obt_marks / $thprmax[0]['max_marks']));
				    	
				 }elseif($stream=='116' || $stream=='119'){
					 if($cia_max_mrks >0 && $theory_max >0){
						$exam_grade_marks =$theory_obt_marks;
						$exam_min_marks=$th_min_mrks;
						$cia_garde_marks = $cia_obt_marks;	
						$cia_min_marks = $internal_min_for_pass;	
						$exam_grade_marks1 =$theory_obt_marks;
							
					}elseif($cia_max_mrks ==0 && $theory_max >0){					
						$exam_grade_marks = $theory_obt_marks;
						$exam_min_marks=$th_min_mrks;
						$exam_grade_marks1 =$theory_obt_marks;
						$cia_garde_marks=NULL;					
					}elseif($cia_max_mrks >0 && $theory_max ==0){
						$cia_garde_marks = $cia_obt_marks;	
						$cia_min_marks = $internal_min_for_pass;			
						$exam_grade_marks=NULL;	
					}else{		
					}
				 }else{
					
					if($cia_max_mrks >0 && $theory_max >0){
						$exam_grade_marks =(100 * ($theory_obt_marks / $thprmax[0]['max_marks'])) /2;
						$exam_min_marks=100 * ($th_min_mrks / $theory_max);
						$cia_garde_marks = 50 * ($cia_obt_marks / $ciamax[0]['max_marks']);	
						$cia_min_marks = 50 * ($internal_min_for_pass/ $cia_max_mrks);	
						$exam_grade_marks1 =(100 * ($theory_obt_marks / $thprmax[0]['max_marks']));
							
					}elseif($cia_max_mrks ==0 && $theory_max >0){					
						$exam_grade_marks = (100 * ($theory_obt_marks / $thprmax[0]['max_marks']));
						$exam_min_marks=100 * ($th_min_mrks / $theory_max);
						$exam_grade_marks1 =(100 * ($theory_obt_marks / $thprmax[0]['max_marks']));
						$cia_garde_marks=NULL;					
					}elseif($cia_max_mrks >0 && $theory_max ==0){
						$cia_garde_marks = (50 * ($cia_obt_marks / $ciamax[0]['max_marks'])) *2;	
						$cia_min_marks = 50 * ($internal_min_for_pass/ $cia_max_mrks);			
						$exam_grade_marks=NULL;	
					}else{		
					}
				}
				////////////////////////
				$data['cia_garde_marks']= $cia_garde_marks;
				$data['exam_grade_marks']= $exam_grade_marks;
				if($stream=='116' || $stream=='119'){
					$data['final_garde_marks'] = 100 * (round($exam_grade_marks + $cia_garde_marks)/$subdet[0]['sub_max']);
					
					/*if($subdet[0]['sub_min'] >=50){
						$sub_min = (50 * (50/$subdet[0]['sub_min']));
					}else{
						$sub_min = (100 * ($subdet[0]['sub_min'])/50);
					}*/
					$sub_min = (100 * ($subdet[0]['sub_min'])/$subdet[0]['sub_max']);
				}else{
					$data['final_garde_marks']= round($exam_grade_marks + $cia_garde_marks);  // addition of theory + cia marks 
				}
				$sub_max_marks[] = $subdet[0]['sub_max'];          // exam result master
				$sub_final_marks[] = $val['final_garde_marks'];				
				$final_garde_marks = $data['final_garde_marks'];
				
				///////////////////////////////////
				/*if($theory_max != $thprmax[0]['max_marks']){
					$theory_obt_marks1 = $theory_max * ($theory_obt_marks/$thprmax[0]['max_marks']);
				}else{
					$theory_obt_marks1 = $theory_obt_marks;
				}

				if($cia_max_mrks != $ciamax[0]['max_marks']){
					$cia_obt_marks1 = $cia_max_mrks * ($cia_obt_marks/$ciamax[0]['max_marks']);
			
				}else{
					$cia_obt_marks1 =$cia_obt_marks; 
				}
				/////////////////
				*/
				/*if($subject=='3087'){
				echo "Student id:".$stud_id." Subject id:".$subject."-Th Obt:".$theory_obt_marks1."-TH Max". $thprmax[0]['max_marks']."- TH_grade marks:".$exam_grade_marks." th min:".$exam_min_marks."-CIA obt:".$cia_obt_marks." CIA MAX:".$ciamax[0]['max_marks']."  CIA grade ".$cia_garde_marks ." cia min:".$cia_min_marks."--Total:".$final_garde_marks."<br>";//exit;
				}*/

				if(($cia_garde_marks < $cia_min_marks) && $cia_obt_marks !=NULL){  
					if($stream=='116' || $stream=='119'){
						$finalgrade = 'F';
						$data['final_grade'] = 'F';
						$data['result_grade'] = 'F';
						$th_garce_required = '0';
						$sub_garce_required = '0';
						$data['garce_marks'] = '';

					}else{
						$finalgrade = 'U';
						$data['final_grade'] = 'U';
						$data['result_grade'] = 'U';
						$th_garce_required = '0';
						$sub_garce_required = '0';
						$data['garce_marks'] = '';
					}

				}elseif(($exam_grade_marks1 < $exam_min_marks) && $theory_obt_marks !=NULL){
					//echo "Inside1";
					if($stream=='116' || $stream=='119'){
						$finalgrade = 'F';
						$data['final_grade'] = 'F';
						$data['result_grade'] = 'F';
						$th_garce_required = '0';
						$sub_garce_required = '0';
						$data['garce_marks'] = '';

					}else{
						$finalgrade = 'U';
						$data['final_grade'] = 'U';
						$data['result_grade'] = 'U';
						$th_garce_required = '0';
						$sub_garce_required = '0';
						$data['garce_marks'] = '';
					}
				
				}elseif($final_garde_marks < $sub_min){
					echo "Inside2";
						$sub_mrk_diff = $sub_min - $final_garde_marks;        // calculating difference 
						if(in_array($sub_mrk_diff, $grace)){

							$final_garde_marks = $final_garde_marks;      // if difference is between grace array then applying grace of 1 marks
							$data['garce_marks'] = 1;
							$sub_garce_required = '1';
							if($stream=='116' || $stream=='119'){
								echo "fn-".$final_garde_marks+1;
								$grade = $this->Phd_results_model->fetch_grade_pharma($final_garde_marks+1,$grd_rule);
							}else{
								$grade = $this->Phd_results_model->fetch_grade($final_garde_marks+1,$grd_rule);
							}
							$data['result_grade'] = $grade[0]['grade_letter'];
							$data['final_grade'] = $grade[0]['grade_letter'];
							$finalgrade = $grade[0]['grade_letter'];
						}else{
						    
						    if(in_array($sub_mrk_diff, $moderate_marks)){         // condition for moderate marks
        					    $data['moderate_marks'] = $sub_mrk_diff;
        				    }
						    if($stream=='116' || $stream=='119'){
								$finalgrade = 'F';
								$data['final_grade'] = 'F';
								$data['result_grade'] = 'F';
								$th_garce_required = '0';
								$sub_garce_required = '0';
								$data['garce_marks'] = '';
							}else{
								$finalgrade = 'U';
								$data['final_grade'] = 'U';
								$data['result_grade'] = 'U';
								$th_garce_required = '0';
								$sub_garce_required = '0';
								$data['garce_marks'] = '';
							}
							
						}

				}else{
					
				    if($stream==71){
				    	if($final_garde_marks >=40){
				    		$grade[0]['grade_letter'] ='P';	
				    	}else{
				    		$grade[0]['grade_letter'] ='U';	
				    	}
				    	
				    }else if($stream=='116' || $stream=='119'){
						$grade = $this->Phd_results_model->fetch_grade_pharma($final_garde_marks,$grd_rule);
					}else{
						$grade = $this->Phd_results_model->fetch_grade($final_garde_marks,$grd_rule);
					}
					//$grade = $this->Phd_results_model->fetch_grade($final_garde_marks,$grd_rule);
					$data['result_grade'] = $grade[0]['grade_letter'];
					$data['final_grade'] = $grade[0]['grade_letter'];
					$finalgrade = $grade[0]['grade_letter'];
					$data['garce_marks'] = '';
					$th_garce_required = '0';
					// echo $grade[0]['grade_letter'];exit;
				}
			  }
			  
			    //echo "<pre>";print_r($data);echo "<br>";
				
				array_push($student_subjets, array(
					'student_id' => $stud_id,
					'subject_id' => $subject,
					'internal_max' => $cia_max_mrks,
					'internal_min_for_pass' => $internal_min_for_pass,
					'theory_max' => $theory_max,
					'th_min_mrks' => $th_min_mrks,
					'sub_max' => $sub_max,
					'sub_min' => $sub_min,
					'theory_obt_marks' => $theory_obt_marks,
					'cia_obt_marks' => $cia_obt_marks,
					'theory_obt_marks' => $theory_obt_marks,
					'cia_garde_marks' => $cia_garde_marks,
					'exam_grade_marks' => $exam_grade_marks,
					'final_garde_marks' => $final_garde_marks,
					'final_grade' => $finalgrade,
					'th_garce_required' => $th_garce_required,
					'sub_garce_required' => $sub_garce_required,
				));

				$this->Phd_results_model->update_reslt_grade($subject,$semester,$stream,$exam_id,$stud_id, $data);
				unset($data);
				
				//echo "<pre> unset";print_r($data);
				
			}
			
			// echo "<pre>"; 
			//print_r($student_subjets);
			foreach ($student_subjets as $key => $value) {
				//echo $value['th_garce_required'];exit;
				if($value['th_garce_required']=='1'){
				$gracemrk['garce_marks'] =1;
				$this->Phd_results_model->update_resltsubject_grace($value['subject_id'],$semester,$stream,$exam_id,$value['student_id'], $gracemrk);
				break;
				}
			}
			//exit;
			//$sem_obt_marks =array_sum($sub_final_marks);
			//$sem_tot_marks = array_sum($sub_max_marks);

			$res_data['student_id'] = $stud_id;
			$res_data['enrollment_no'] = $res['enrollment_no'];
			//$res_data['sem_marks'] = $sem_obt_marks;
			//$res_data['sem_total'] = $sem_tot_marks;
			//echo "<pre>";
			//print_r($res_data);
			$chk_dup = $this->Phd_results_model->check_for_duplicate_result_entry($stud_id, $stream, $semester, $exam_id);

			if(count($chk_dup) <= 0)
			{
				$DB1->insert("phd_exam_result_master", $res_data); 

			}

			unset($sub_final_marks);
			unset($sub_max_marks);
			//echo "=".$sem_obt_marks;
		}
		if($res_detail_id !=''){
			$update_res_data['result_generated'] = 'Y';
			$DB1->where('res_detail_id', $res_detail_id);
			$DB1->update("phd_exam_result_details", $update_res_data); 
		}

        echo "success";
    }

    public function excel_resultReport($result_data, $batch){
    	//$result_data = $_POST['res_data']; 
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);
		//ini_set('memory_limit', '2048M');
		$subdetails = explode('~', $result_data);

		$school_code  =$subdetails[0];
		$stream =$subdetails[1];
		$semester =$subdetails[5];
		$exam_month =$subdetails[2];
		$exam_year =$subdetails[3];
		$exam_id =$subdetails[4];
		$this->data['exam_id'] = $exam_id;
		$this->data['exam_month'] = $exam_month;
		$this->data['exam_year'] = $exam_year;
		
		$res_data['school_id'] = $school_code;
		$res_data['stream_id'] = $stream;
		$res_data['semester'] = $semester;
		$res_data['exam_month'] = $exam_month;
		$res_data['exam_year'] = $exam_year;
		
		$res_data['entry_by'] = $this->session->userdata("uid");
		$res_data['entry_on'] = date('Y-m-d H:i:s');
		$res_data['entry_ip'] = $this->input->ip_address();
		$this->data['semester'] =$semester;
		$this->data['result_info'] = $this->Phd_results_model->fetch_studen_result_data($result_data, $batch);
		//echo count($result_info);
		$grade_rule = $this->Phd_results_model->fetch_gread_rule($stream);
		$grd_rule = $grade_rule[0]['grade_rule'];
		$this->load->model('Phd_exam_timetable_model');
		//$this->data['exam_sess']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$this->load->model('phd_examination_model');
		$this->data['StreamShortName'] =$this->phd_examination_model->getStreamShortName($stream);
		$this->data['sem_subjects'] = $this->Phd_results_model->fetch_subjects_exam_semester($result_data, $batch);
		//print_r($this->data['sem_subjects']);exit;
		$i=0;
		foreach ($this->data['result_info'] as $res) {

			$stud_id = $res['student_id'];
			$this->data['result_info'][$i]['sub'] = $this->Phd_results_model->fetch_reslt_subjects($result_data,$stud_id);
			$i++;
		}
		//echo '<pre>';
//print_r($this->data['result_info']);exit;
        $this->load->view($this->view_dir.'result_marksheet_excel',$this->data);
    }

    // for pdf 
    public function pdf_resultReport($result_data,$batch){
     	//error_reporting(E_ALL);
// ini_set('display_errors', 1);
		ini_set('memory_limit', '2048M');
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);
		$subdetails = explode('~', $result_data);

		$school_code  =$subdetails[0];
		$stream =$subdetails[1];
		$semester =$subdetails[5];
		$exam_month =$subdetails[2];
		$exam_year =$subdetails[3];
		$exam_id =$subdetails[4];
		$this->data['exam_id'] = $exam_id;
		$this->data['dpharma'] = $subdetails[7];
		if(!empty($subdetails[8])){
			$this->data['gdview'] = $subdetails[8];
		}
		
		$res_data['school_id'] = $school_code;
		$res_data['stream_id'] = $stream;
		$res_data['semester'] = $semester;
		$res_data['exam_month'] = $exam_month;
		$res_data['exam_year'] = $exam_year;
		$res_data['entry_by'] = $this->session->userdata("uid");
		$res_data['entry_on'] = date('Y-m-d H:i:s');
		$res_data['entry_ip'] = $this->input->ip_address();
		$this->data['semester'] =$semester;
		$this->data['stream_id'] =$stream;
		$this->data['result_info'] = $this->Phd_results_model->fetch_studen_result_data($result_data,$batch);
	
		$arr_students = array_values(array_column($this->data['result_info'], 'student_id'));
		if(!empty($arr_students)){
		//print_r($arr_students);exit;
		//echo count($result_info);
		$grade_rule = $this->Phd_results_model->fetch_gread_rule($stream);
		$grd_rule = $grade_rule[0]['grade_rule'];
		$this->load->model('Phd_exam_timetable_model');
		$exam_sess= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$this->load->model('phd_examination_model');
		$StreamShortName =$this->phd_examination_model->getStreamShortName($stream);
		$this->data['sem_subjects'] = $this->Phd_results_model->fetch_subjects_exam_semester($result_data,$arr_students);
		//$sem_subjects = $this->data['sem_subjects'];
       // $this->load->view($this->view_dir.'result_gradegeneration_pdf',$this->data);
        $this->load->library('m_pdf', $param);
	    $this->m_pdf->pdf=new mPDF('utf-8', 'A4-L', '15', '15', '15', '15', '50', '20');
	    $stream_name = $StreamShortName[0]['stream_short_name'];
	    //$exam_year = $exam_sess[0]['exam_year'];
	    //$exam_month = $exam_sess[0]['exam_month'];
		if($stream==71){
			$semest = "Year";
			$iname='Result_Gradesheet';
		}else{
			$semest = "Semester";
			$iname='Result';
		}
	    $header ='<table align="center" width="100%"> 
			<tbody>  
				<tr>
					<td valign="top" height="30">
						<table cellpadding="3" cellspacing="0" border="0" align="center" width="100%" style="margin-top:15px;">
							<tr>
							<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="https://erp.sandipuniversity.com/assets/images/logo-7.jpg" alt="" width="50" border="0"></td>
							<td style="font-weight:normal;text-align:center;">
								<h1 style="font-size:30px;">Sandip University</h1>
								<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

							</td>
							<td width="120" align="right" valign="middle" style="text-align:center;padding-top:10px;"></td>
						</tr>
							<tr>
								<td></td>
								<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:12px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>END SEMESTER EXAMINATION RESULTS - <u>'.$exam_month.' '.$exam_year.'</u></h3></td>
								<td></td>
							</tr>
            				<tr>
								<td colspan="3">&nbsp;</td>
								
							</tr>
						</table>
					</td>
				</tr>
            
			            </tbody>
            
				</table>
						<table class="content-table" width="100%" cellpadding="3" cellspacing="3" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;padding-bottom: 10px">
							<tr>
								<td width="100" height="30"><strong>Batch :</strong> '.$batch.', <strong>Stream : </strong>
								'.$stream_name.'</td>
								<td width="100" height="30"><strong>'.$semest.' :</strong> '.$semester.'</td>					
							</tr>
							

						</table>';

						/*<table width="100%" border="1" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<th rowspan="2">Sr.N.</th>
								<th rowspan="2">PRN</th>
								<th rowspan="2">Name of the Candidate</th>';
								foreach($this->data['sem_subjects'] as $subj) {
									$sub_name =$subj['subject_code1'];
									
								$header .='<th colspan="4">'.$sub_name.'</th></tr>';
								 }

							$header .='<tr>';
							foreach($this->data['sem_subjects'] as $subj) {
    $header .='<th align="center">INT</th>
    <th align="center">EXT</th>
    <th align="center">TOT</th>
    <th align="center">GRD</th></tr>';
    }
$header .='</thead>';*/
        /*$footer ='<table class="content-table" width="100%" border="1" cellspacing="0" cellpadding="2" align="center" style="margin-bottom:20px;"><tr>';
		foreach($this->data['sem_subjects'] as $subj) {
		    $sub_code =$subj['subject_code1'];
			$sub_name =$subj['subject_short_name'];
			$theory_max =$subj['theory_max'];
			$theory_min_for_pass =$subj['theory_min_for_pass'];
			$internal_max =$subj['internal_max'];
			$internal_min_for_pass =$subj['internal_min_for_pass'];
			$sub_min =$subj['sub_min'];
			$sub_max =$subj['sub_max'];
							
		    $footer .='<td style="font-size:10px;">'.$sub_code.'-'.$sub_name.'<br> INT: '.$internal_max.', EXT: '.$theory_max.'</td>';
		}
					
		$footer .='</tr></table>';*/
		$dattime = date('d-m-Y H:i:s');
		$footer ='<table width="100%" border="0" cellspacing="3" cellpadding="3" align="center" style="margin-bottom:20px;"><tr><td style="float:right"> Printed on: '.$dattime.'</td></tr></table>';
				
	    $content = $this->load->view($this->view_dir.'result_marksheet_pdf', $this->data, true);
	    $header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
	    $this->m_pdf->pdf->SetHTMLHeader($header1);
		$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->AddPage();
		$this->m_pdf->pdf->WriteHTML($content);	
        $this->m_pdf->pdf->SetHTMLFooter($footer);
        $fname= $batch.'_'.$stream_name.'_'.$semester.'_'.$exam_month.'_'.$exam_year;
	    $pdfFilePath = $iname.'_'.$fname.".pdf";

	    //download it.
	    $this->m_pdf->pdf->Output($pdfFilePath, "D");
		}else{
			echo "No data found.";
			
		}
    }
    // grdaesheet

    public function gradesheet_excelreport($result_data){
    	//$result_data = $_POST['res_data']; 
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);
		//ini_set('memory_limit', '2048M');
		$subdetails = explode('~', $result_data);

		$school_code  =$subdetails[0];
		$stream =$subdetails[1];
		$semester =$subdetails[5];
		$exam_month =$subdetails[2];
		$exam_year =$subdetails[3];
		$exam_id =$subdetails[4];
		$this->data['exam_id'] = $exam_id;

		$res_data['school_id'] = $school_code;
		$res_data['stream_id'] = $stream;
		$res_data['semester'] = $semester;
		$res_data['exam_month'] = $exam_month;
		$res_data['exam_year'] = $exam_year;
		$res_data['entry_by'] = $this->session->userdata("uid");
		$res_data['entry_on'] = date('Y-m-d H:i:s');
		$res_data['entry_ip'] = $this->input->ip_address();
		$this->data['semester'] =$semester;
		$this->data['result_info'] = $this->Phd_results_model->fetch_studen_result_data($result_data);
		//echo count($result_info);
		$grade_rule = $this->Phd_results_model->fetch_gread_rule($stream);
		$grd_rule = $grade_rule[0]['grade_rule'];
		$this->load->model('Phd_exam_timetable_model');
		$this->data['exam_sess']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$this->load->model('phd_examination_model');
		$this->data['StreamShortName'] =$this->phd_examination_model->getStreamShortName($stream);
		$this->data['sem_subjects'] = $this->Phd_results_model->fetch_subjects_exam_semester($result_data);
		//print_r($this->data['sem_subjects']);exit;
		$i=0;
		foreach ($this->data['result_info'] as $res) {

			$stud_id = $res['student_id'];
			$this->data['result_info'][$i]['sub'] = $this->Phd_results_model->fetch_reslt_subjects($result_data,$stud_id);
			$i++;
		}
		//echo '<pre>';
//print_r($this->data['result_info']);exit;
        $this->load->view($this->view_dir.'result_gradesheet_excel',$this->data);
    } 
    
     public function gradesheet_pdfreport($result_data, $batch){
    	//     	error_reporting(E_ALL);
// ini_set('display_errors', 1);
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);
		ini_set('memory_limit', '2048M');
		$subdetails = explode('~', $result_data);

		$school_code  =$subdetails[0];
		$stream =$subdetails[1];
		$semester =$subdetails[5];
		$exam_month =$subdetails[2];
		$exam_year =$subdetails[3];
		$exam_id =$subdetails[4];
		$this->data['exam_id'] = $exam_id;
		
		$res_data['school_id'] = $school_code;
		$res_data['stream_id'] = $stream;
		$res_data['semester'] = $semester;
		$res_data['exam_month'] = $exam_month;
		$res_data['exam_year'] = $exam_year;
		$res_data['entry_by'] = $this->session->userdata("uid");
		$res_data['entry_on'] = date('Y-m-d H:i:s');
		$res_data['entry_ip'] = $this->input->ip_address();
		$this->data['semester'] =$semester;
		$this->data['stream_id'] =$stream;
		$this->data['result_info'] = $this->Phd_results_model->fetch_studen_result_data($result_data, $batch);
		$arr_students = array_values(array_column($this->data['result_info'], 'student_id'));
		//echo count($result_info);
		$grade_rule = $this->Phd_results_model->fetch_gread_rule($stream);
		$grd_rule = $grade_rule[0]['grade_rule'];
		$this->load->model('Phd_exam_timetable_model');
		$this->data['exam_sess']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$this->load->model('phd_examination_model');
		$this->data['StreamShortName'] =$this->phd_examination_model->getStreamShortName($stream);
		$this->data['sem_subjects'] = $this->Phd_results_model->fetch_subjects_exam_semester($result_data,$arr_students);
		//print_r($this->data['sem_subjects']);exit;
		if($stream=='116' || $stream=='119'){
			$this->data['grade_details']= $this->Phd_results_model->list_grade_pharma_details($grd_rule);
		}else{
			$this->data['grade_details']= $this->Phd_results_model->list_grade_details($grd_rule);
		}
		if($stream==71){
			$semest = "Year";
		}else{
			$semest = "Semester";
		}
		$i=0;
		foreach ($this->data['result_info'] as $res) {

			$stud_id = $res['student_id'];
			$this->data['result_info'][$i]['sub'] = $this->Phd_results_model->fetch_reslt_subjects($result_data,$stud_id);
			$i++;
		}
		//echo '<pre>';
//print_r($this->data['result_info']);exit;

        $this->load->library('m_pdf', $param);
	    $this->m_pdf->pdf=new mPDF('utf-8', 'A4-L', '15', '15', '15', '15', '47', '35');
	    $stream_name = $this->data['StreamShortName'][0]['stream_short_name'];
	   
	    
	    $header ='<table align="center" width="100%"> 
			<tbody>  
				<tr>
					<td valign="top" height="40">
						<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin-top:15px;">
							<tr>
							<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="https://erp.sandipuniversity.com/assets/images/logo-7.jpg" alt="" width="50" border="0"></td>
							<td style="font-weight:normal;text-align:center;">
								<h1 style="font-size:30px;">Sandip University</h1>
								<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

							</td>
							<td width="120" align="right" valign="middle" style="text-align:center;padding-top:10px;"></td>
						</tr>
							<tr>
								<td></td>
								<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:12px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>END SEMESTER EXAMINATION RESULTS - <u>'.$exam_month.' '.$exam_year.'</u></h3></td>
								<td></td>
							</tr>
            				<tr>
								<td colspan="3">&nbsp;</td>
								
							</tr>
						</table>
					</td>
				</tr>
            
			            </tbody>
            
				</table>
						<table class="content-table" width="100%" cellpadding="3" cellspacing="3" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;padding-bottom: 10px">
							<tr>
								<td width="100" height="30"><strong>Stream : </strong>
								'.$stream_name.'</td>
								<td width="100" height="30"><strong>'.$semest.' :</strong> '.$semester.'</td>	
								<td width="100" height="30"><strong>Regulation:</strong> 2017</td>	
							</tr>
							

						</table>';
	    
	    $content = $this->load->view($this->view_dir.'result_gradesheet_pdf', $this->data, true);
	    $dattime = date('d-m-Y H:i:s');
		$footer ='<table width="100%" border="0" cellspacing="3" cellpadding="5" align="center" style="margin-bottom:40px;"><tr><td width="30%" style="float:right"><b>Office Seal</b></td><td width="40%"><b>COE Sign</b></td><td width="40%" style="float:right"> Printed on: '.$dattime.'</td><td width="10%" style="float:right"> <b>{PAGENO}</b></td></tr></table>';
		
		/*$this->m_pdf->pdf->PageNumSubstitutions[] = [
					'from' => 1, 
					'reset' => 0, 
					'type' => 'I', 
					'suppress' => 'off'
				];*/
	    $header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
	    $this->m_pdf->pdf->SetHTMLHeader($header1);
		$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
		//$this->m_pdf->pdf->setFooter('{PAGENO}');
		$this->m_pdf->pdf->SetHTMLFooter($footer);
		$this->m_pdf->pdf->AddPage();
		$this->m_pdf->pdf->WriteHTML($content);	
        
        $fname= $stream_name.'_'.$semester.'_'.$exam_month.'_'.$exam_year;
	    $pdfFilePath = 'Result_Gradesheet_'.$fname.".pdf";

	    //download it.
	    $this->m_pdf->pdf->Output($pdfFilePath, "D");
    } 
    // previous exam grades entry
    public function markscard()
	{
	   // error_reporting(E_ALL);exit();
	    $this->load->model('Exam_timetable_model');
		$this->load->model('Marks_model');
		$this->load->model('Phd_results_model');
		$this->data['regulatn']= $this->Exam_timetable_model->getRegulation();
	    if($_POST)
	    {
	          //echo "<pre>";
	         // print_r($_POST);exit;
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission-course'];
	        $this->data['stream'] =$_POST['admission-branch'];
	        $this->data['semester'] =$_POST['semester'];
	        $this->data['exam'] =$_POST['exam_session'];
	        $this->data['marks_type'] =$_POST['marks_type'];
	        $this->data['exam_session']= $this->Phd_results_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Phd_results_model->getresltSchools();
	        $exam= explode('-', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
		    $this->data['stud_list']= $this->Phd_results_model->list_result_students($_POST,$exam_month, $exam_year,$exam_id);	   				     
		    $this->load->view($this->view_dir.'markscard_view',$this->data);

	        $this->load->view('footer');
	    }
	    else
	    {
	        
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] ='';
	        $this->data['admissioncourse'] = '';
	        $this->data['stream'] = '';
	        $this->data['semester'] = '';
	        
	        $this->data['exam_session']= $this->Phd_results_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Phd_results_model->getresltSchools();
	        $this->load->view($this->view_dir.'markscard_view',$this->data);
	        $this->load->view('footer');
	        
	    }
	    
	    
	}

	// fetch result streams
	function load_resultstreams(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["course_id"]) && !empty($_POST["course_id"])){
			//Get all streams
			$stream = $this->Phd_results_model->load_resultstreams($_POST["course_id"], $_POST["exam_session"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Stream</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['stream_id'] . '">' . $value['stream_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">stream not available</option>';
			}
		}
	}
	function load_resultsemesters(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			//Get all streams
			$stream = $this->Phd_results_model->load_resultsemesters($_POST["stream_id"], $_POST["exam_session"]);
            
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
	function load_edschools(){

		if($_POST["school_code"] !=''){
			$ex_se = explode('-', $_POST["ex_ses"]);
			//Get all city data
			$stream = $this->Phd_results_model->get_edcourses($_POST["school_code"], $ex_se[2]);
            
			//Count total number of rows
			echo $rowCount = count($stream);

			//Display cities list
			//if($rowCount > 0){
				echo '<option value="">Select Course</option>';
				echo '<option value="0">All Course</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
				}
			/*} else{
				echo '<option value="">Course not available</option>';
			}*/
		}
	}	
	// fetch ed streams
	function load_edstreams(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["course_id"]) && !empty($_POST["course_id"])){
			$ex_se = explode('-', $_POST["ex_ses"]);
			//Get all streams
			$stream = $this->Phd_results_model->load_edstreams($_POST["course_id"], $ex_se[2]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Stream</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['stream_id'] . '">' . $value['stream_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">stream not available</option>';
			}
		}
	}
	function load_edsemesters(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			$ex_se = explode('-', $_POST["ex_ses"]);
			//Get all streams
			$stream = $this->Phd_results_model->load_edsemesters($_POST["stream_id"], $ex_se[2]);
            
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
	// generate markscard pdf
		function generate_markscard(){
		 ob_start();
		//error_reporting(E_ALL); ini_set('display_errors', 1); 
		 //echo "<pre>";
		// echo $chk_stud= $chk_checked; $semester=$sem;$admission_stream=$stream;$exam_session=$exam_session;
	     //print_r($_POST);exit;
		 //$this->Phd_results_model->fetch_student_grade_details($_POST);
		 $student=array();
		 if($_POST['stream_id'] !='71'){
			 
			 $student = $_POST['chk_stud'];
			 $exam_session = explode('~', $_POST['exam_session']);
			 $certf_dat = str_replace('/', '-', $_POST['mrk_cer_date']);
			 
			 if(!empty($_POST['mrk_cer_date'])){
			 $certf_date = date('d M, Y', strtotime($certf_dat));
			 }else{
				$certf_date =''; 
			 }
			 
			 
			 $stream_id = $_POST['stream_id'];
			 $semester = $_POST['semester'];
			 $this->data['semester_post']=$_POST['semester'];
			 $exam_id =$exam_session[2]; 
			 $exam_ses =$exam_session[0].''.$exam_session[1];
			 $today_date = date('d-m-Y');
			 $gd_log['exam_id'] = $exam_id;	
			 $gd_log['generated_by'] = $this->session->userdata("uid");
			 $gd_log['generated_on'] = date('Y-m-d H:i:s');
			 $gd_log['generated_ip'] = $this->input->ip_address();
			$res_bklogsems =array();
			$resgrade=array();
			
			//print_r($student);
			//exit();
			/*$this->load->library('m_pdf');
				$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '30', '10', '10', '10', '5');*/
				$this->load->library('m_pdf');
			
			 foreach($student as $stud){
				 $mpdf=new mPDF();
			$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '15', '30', '10', '10', '10', '5');
				 $exam_unique_id  = $this->Phd_results_model->fetch_student_exam_unique_id($stud, $stream_id,$semester,$exam_id);
				 $this->data['stud_data'][] = $this->Phd_results_model->fetch_student_grade_details($stud, $stream_id,$semester,$exam_id);
				// $this->data['res_sem'] = $this->Phd_results_model->fetch_student_result_semester($stud,$exam_id);
				 //$this->data['backlog_grades'] = $this->Phd_results_model->fetch_student_backlog_grade_details($stud);
				// $this->data['backlog_kiran'] = $this->Phd_results_model->fetch_student_backlog_grade_details_kiran($stud);
				// $resultsgrade = $this->Phd_results_model->fetch_student_backlog_grade_from_result_data($stud,$exam_id);
				 //echo '<pre>';print_r($resultsgrade); //exit;
				/* foreach($resultsgrade as $rs11){
					$resgrade[] = $rs11[0]['final_grade'];
					if($rs11[0]['final_grade']=='U' || $rs11[0]['final_grade']=='F'){
						$res_bklogsems[] = $rs11[0]['semester'];
					}
				}*/
				$this->data['resultsgrade_f'] = $resultsgrade;
				
				//$this->data['resultsgrade'] = $resgrade;
				//$this->data['res_bklogsems'] = array_unique($res_bklogsems);
				
				//print_r($res_bklogsems);exit;
			 // echo "<pre>";
			//	 print_r($this->data['stud_data']);
			//	  echo "</pre>";exit;
			

				
				 $this->data['exam_master_id'][] = $exam_unique_id[0]['exam_master_id'];

	  //$this->data['stud_data'][][]=$this->Phd_results_model->fetch_student_grades($stud,$exam_id);
				 ///////////////////
				$tempDir = 'uploads/gradesheet/phd/'.$exam_ses.'/QRCode/';
				$fileName = 'qrcode_'.$exam_unique_id[0]['exam_master_id'].'.png';	
				
				$chkfileName = $tempDir.$fileName;	
				if(file_exists($chkfileName)) {
					//echo "The file $chkfileName exists";exit;
				}else{
					
				include_once "phpqrcode/qrlib.php";
				//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
				//The name of the directory that we need to create.
				$tempDir = 'uploads/gradesheet/phd/'.$exam_ses.'/QRCode/';
				//Check if the directory already exists.
				if(!is_dir($tempDir)){
					//Directory does not exist, so lets create it.
					mkdir($tempDir, 0755, true);
				}
				
				//$po_id = $p_row[0]['ord_no'];
				$siteurl="https://sandipuniversity.com/student/";
				$codeContents = $siteurl.'index.php?type=cert&id='.$exam_unique_id[0]['exam_master_id'];
				
				// we need to generate filename somehow, 
				// with md5 or with database ID used to obtains $codeContents...
				$fileName = 'qrcode_'.$exam_unique_id[0]['exam_master_id'].'.png';		
				$pngAbsoluteFilePath = $tempDir.$fileName;
				$urlRelativeFilePath = $pngAbsoluteFilePath;
				
				// generating
				//if (!file_exists($pngAbsoluteFilePath)) {
				QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 2, 2);	
				if (file_exists($pngAbsoluteFilePath)) {
					$src_file = $pngAbsoluteFilePath;
					$bucket_name = 'erp-asset';
					echo $filepath = $pngAbsoluteFilePath;
					$result = $this->awssdk->uploadFile($bucket_name, $filepath, $src_file);
					unlink($filepath);
				}
				}
				//////////////////
				//log start
				$gd_log['student_id'] = $stud;
				$gd_log['enrollment_no'] = $exam_unique_id[0]['enrollment_no'];	
				$this->Phd_results_model->save_gradesheet_log($gd_log);
			
			// } // foreach($student as $stud){
			 
			 $strmname = $this->data['stud_data'][0][0]['stream_short_name'];
			/* echo "<pre>";
				 print_r($this->data['stud_data']);
				  echo "</pre>";
				 die;*/
			//$this->load->view($this->view_dir.'marsk_card_pdf',$this->data);
			 $report_type= $_POST['report_type'];
			 if($report_type=='pdf')
			 {

				
				/*print_r($this->data);
				die;*/
				//$this->load->view($this->view_dir.'marsk_card_pdf',$this->data);
				
				$html = $this->load->view($this->view_dir.'marsk_card_pdf',$this->data, true);
				//echo $html;
				//exit();
				
				$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
				//$header='';
				$mpdf=new mPDF();

				//$signature='Sign COE 01.png';
				$signature='Sign COE 01_parimala.png';
				
				$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:25px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"><img src="'.base_url().'assets/images/'.$signature.'" height="50" width="200"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" class="signature" style="margin-left:155px;margin-top:8px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left" height="50" class="signature" valign="top"><strong>'; $footer .=$certf_date.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:#CDCACA;">'.$today_date.'</small></td>
	</tr>
	</table>';
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLFooter($footer);
			
			$this->m_pdf->pdf->useFixedNormalLineHeight = false;
            $this->m_pdf->pdf->useFixedTextBaseline = false;
            $this->m_pdf->pdf->normalLineheight = 2.7;
            $this->m_pdf->pdf->adjustFontDescLineheight = 2.7;
		    //$this->m_pdf->pdf->SetDefaultBodyCSS('line-height', 5.2);
			$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1,
								'reset' => 0,
								'type' => 'I',
								'suppress' => 'off'
							];
				$this->m_pdf->pdf->AddPage();
				$this->m_pdf->pdf->WriteHTML($html);	
				ob_clean();
				//download it.
				$pdfFilePath1 =$strmname.'_'.$semester."_Markscard.pdf";
				//$this->m_pdf->pdf->Output($tempDir.'/'.$pdfFilePath1, "F");
				$this->m_pdf->pdf->Output($pdfFilePath1, "D");
				//unset($res_bklogsems);
				//unset($resgrade);
				
			 }else{
				//$this->load->view($this->view_dir.'marsk_card_excel',$this->data); 
			 }
			 unset($f_grade);
			 unset($resgrade);
			 unset($res_bklogsems);
			 }
			 
		}else{  //if($_POST['stream_id'] !='71'){
			
			// for dpharma
			 $student = $_POST['chk_stud'];
			 $exam_session = explode('~', $_POST['exam_session']);
			 $certf_dat = str_replace('/', '-', $_POST['mrk_cer_date']);
			 $certf_date = date('d M, Y', strtotime($certf_dat));
			 $stream_id = $_POST['stream_id'];
			 $semester = $_POST['semester'];
			 $exam_id =$exam_session[2]; 
			 $this->data['exam_df_id'] = $exam_id;
			 $this->data['stream_df_id'] = $stream_id;
			 $exam_ses =$exam_session[0].''.$exam_session[1];
			 $today_date = date('d-m-Y');
			 $gd_log['exam_id'] = $exam_id;	
			 $gd_log['generated_by'] = $this->session->userdata("uid");
			 $gd_log['generated_on'] = date('Y-m-d H:i:s');
			 $gd_log['generated_ip'] = $this->input->ip_address();

			 foreach($student as $stud){
				 $exam_unique_id  = $this->Phd_results_model->fetch_student_exam_unique_id($stud, $stream_id,$semester,$exam_id);
				 $this->data['stud_data'][] = $this->Phd_results_model->fetch_student_grade_details($stud, $stream_id,$semester,$exam_id);
				// $this->data['stud_year'] = $this->Phd_results_model->fetch_student_result_dpharma($stud, $stream_id,$exam_id);
				 
				 //print_r($this->data['stud_year']);
				// echo $stud;exit;
				 $this->data['exam_master_id'][] = $exam_unique_id[0]['exam_master_id'];
	  //$this->data['stud_data'][][]=$this->Phd_results_model->fetch_student_grades($stud,$exam_id);
				 ///////////////////
				$tempDir = 'uploads/gradesheet/phd/'.$exam_ses.'/QRCode/';
				$fileName = 'qrcode_'.$exam_unique_id[0]['exam_master_id'].'.png';	
				
				$chkfileName = $tempDir.$fileName;	
				if(file_exists($chkfileName)) {
					//echo "The file $chkfileName exists";exit;
				}else{
					
				include_once "phpqrcode/qrlib.php";
				//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
				//The name of the directory that we need to create.
				//$tempDir = 'uploads/gradesheet/'.$exam_ses.'/QRCode/';
				//Check if the directory already exists.
				if(!is_dir($tempDir)){
					//Directory does not exist, so lets create it.
					mkdir($tempDir, 0755, true);
				}
				
				//$po_id = $p_row[0]['ord_no'];
				$siteurl="https://sandipuniversity.com/student/";
				$codeContents = $siteurl.'index.php?type=cert&id='.$exam_unique_id[0]['exam_master_id'];
				
				// we need to generate filename somehow, 
				// with md5 or with database ID used to obtains $codeContents...
				//$fileName = 'qrcode_'.$exam_unique_id[0]['exam_master_id'].'.png';		
				$pngAbsoluteFilePath = $tempDir.$fileName;
				$urlRelativeFilePath = $pngAbsoluteFilePath;
				
				// generating
				//if (!file_exists($pngAbsoluteFilePath)) {
				QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 2, 2);	
				if (file_exists($pngAbsoluteFilePath)) {
					$src_file = $pngAbsoluteFilePath;
					$bucket_name = 'erp-asset';
					echo $filepath = $pngAbsoluteFilePath;
					$result = $this->awssdk->uploadFile($bucket_name, $filepath, $src_file);
					unlink($filepath);
				}
				}
				//////////////////
				//log start
				$gd_log['student_id'] = $stud;
				$gd_log['enrollment_no'] = $exam_unique_id[0]['enrollment_no'];	
				$this->Phd_results_model->save_gradesheet_log($gd_log);
			 }
			 //exit;
			 $strmname = $this->data['stud_data'][0][0]['stream_short_name'];
			 //print_r($this->data['stud_data']);exit;
			 $report_type= $_POST['report_type'];
			 if($report_type=='pdf')
			 {
				$this->load->library('m_pdf');
				$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '20', '10', '10', '10', '10');
				$html = $this->load->view($this->view_dir.'dpharma_marsk_card_pdf',$this->data, true);
		//		echo $html;
			//	exit();
				$pdfFilePath1 =$strmname.'_'.$semester."_Markscard.pdf";
				$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
				//$header='';
				$mpdf=new mPDF();
				$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:75px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"><img src="'.base_url().'assets/images/Sign COE 01.png" height="50" width="200"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" class="signature" style="margin-left:160px;margin-top:1px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left" height="50" class="signature" valign="top"><strong>'; $footer .=$certf_date.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:#CDCACA;"></small></td>
	</tr>
	</table>';
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLFooter($footer);
				$this->m_pdf->pdf->AddPage();
				$this->m_pdf->pdf->WriteHTML($html);	
				
				//download it.
				$this->m_pdf->pdf->Output($pdfFilePath1, "D");
			 }else{
				//$this->load->view($this->view_dir.'marsk_card_excel',$this->data); 
			 }
		// ob_clean();
		 }
		 
		
		// ob_end_flush();
	}
	// generate markscard excel
	function generate_markscard_excel(){
		 //echo "<pre>";
		// echo $chk_stud= $chk_checked; $semester=$sem;$admission_stream=$stream;$exam_session=$exam_session;
	     //print_r($_POST);exit;
		 //$this->Phd_results_model->fetch_student_grade_details($_POST);
		 $student = $_POST['chk_stud'];
		 $exam_session = explode('~', $_POST['exam_session']);;
		 $stream_id = $_POST['stream_id'];
		 $semester = $_POST['semester'];
		 $exam_id =$exam_session[2]; 
		 foreach($student as $stud){			
			 $this->data['stud_data'][] = $this->Phd_results_model->fetch_student_grade_details($stud, $stream_id,$semester,$exam_id);
		 }
		 $strmname = $this->data['stud_data'][0][0]['stream_short_name'];
		 //print_r($this->data['stud_data']);exit;
		$this->load->view($this->view_dir.'marsk_card_excel',$this->data); 

	}	
	
	public function updateResultStatus()
    {       
        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);

		$result_id = $_POST['result_id'];	
		$update_array['is_verified'] = 'Y';
		$update_array['modified_on'] = date('Y-m-d H:i:s');
		$update_array['modified_by'] = $this->session->userdata("uid");
		$update_array['modified_ip'] = $this->input->ip_address();
		$where=array("res_detail_id"=>$result_id);
		$DB1->where($where);                
		$DB1->update('phd_exam_result_details', $update_array);
		echo "SUCCESS";
		//echo $DB1->last_query();exit;
	} 
	
	public function analysis(){
	  $this->load->model('Phd_exam_timetable_model');
	  if($_POST)
      {
          
          $row=array(
              'exam_session'=>$_POST['exam_session'],
               'school_code'=>$_POST['school_code'],
                'course_id'=>$_POST['course_code'],
                 'report_type'=>$_POST['report_type']
              );
             $this->data['rpt']=$row;
       
             
                if($_POST['report_type']=="1"){
                  
                     $this->data['result']= $this->Phd_results_model->get_result_program_analysis($row);
                    echo  $this->load->view($this->view_dir.'analysis_html',$this->data); 
                     
                }
                else{
                     $this->data['result']= $this->Phd_results_model->get_result_course_analysis($row);
                     $this->load->view($this->view_dir.'analysis_html',$this->data); 
                }
    
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
        $this->load->view($this->view_dir.'analysis',$this->data);
        $this->load->view('footer');
          
      }
	}
	public function analysis_excel(){
	
	
          $row=array(
              'exam_session'=>$_POST['exam_session'],
               'school_code'=>$_POST['school_code'],
                'course_id'=>$_POST['admission-course'],
                 'report_type'=>$_POST['report_type']
              );
             $this->data['rpt']=$row;
             //print_r($row);exit();
       
               if($_POST['report_type']=="1"){
                 
                     $this->data['result']= $this->Phd_results_model->get_result_program_analysis($row);
                     //print_r($this->data['result']);exit();
                     $this->load->view($this->view_dir.'analysis_excel',$this->data); 
                     
                }
                else{
                    
                     $this->data['result']= $this->Phd_results_model->get_result_course_analysis($row);
                      // print_r($this->data['result']);exit();
                     $this->load->view($this->view_dir.'analysis_excel',$this->data); 
                }          
	}
	
	// calculate sgpa
	function calculate_sgpa()
	{
		$examid= $_POST['exam_id'];
		$semester= $_POST['semester'];
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("ers.*,sgc.grade_rule");
		$DB1->from('phd_exam_result_master as ers');
		$DB1->join('student_master as sm','ers.student_id = sm.stud_id','left'); 
		$DB1->join('stream_grade_criteria as sgc','sm.admission_stream = sgc.stream_id','left');
		$DB1->where("ers.exam_id",$examid); 
		$DB1->where("ers.semester",$semester); 
		 
		$query=$DB1->get();
		//	echo $DB1->last_query();
			
		$result=$query->result_array();	
	  
	  
		foreach($result as $mydata)
		{
			//$rule =;
			$DB1->select("erd.enrollment_no,erd.student_id,erd.exam_id,erd.final_grade,erd.subject_id,erd.subject_code,sm.credits,gpd.grade_point,sum(sm.credits) as total_credits,
		sum(gpd.grade_point) as total_grade,sum(sm.credits*gpd.grade_point) as sumcredit,sum(case when gpd.grade_point=0 then 0 else sm.credits end ) as credit_earned,
		");
			$DB1->from('phd_exam_result_data as erd');
			$DB1->join('subject_master as sm','erd.subject_id = sm.sub_id','left'); 
			$DB1->join('grade_policy_details as gpd','erd.final_grade = gpd.grade_letter','left');
			$DB1->where("erd.student_id",$mydata['student_id']); 
			$DB1->where('gpd.rule', $mydata['grade_rule']); 
			$DB1->where('erd.semester', $semester); 	
			$DB1->where("erd.exam_id <=",$examid); 
			$query1=$DB1->get();
			//echo $DB1->last_query();
			$result1=$query1->row_array();
		  
			if($result1['credit_earned']==0)	
			{
				$tcgpa=0;
			}
			else
			{
			 $tcgpa1 = bcdiv($result1['sumcredit'],$result1['credit_earned'],2); 	
			 $tcgpa = number_format((float)$tcgpa1, 2, '.', '');  
			}	  
		  
			$dataupdate['sgpa']=$tcgpa;
			$dataupdate['modified_by'] = $this->session->userdata("uid");
			$dataupdate['modified_on'] = date('Y-m-d H:i:s');
			$dataupdate['modified_ip'] = $this->input->ip_address();

			$DB1->where('student_id', $result1['student_id']);
			$DB1->where('exam_id', $examid);
			$DB1->where('semester', $semester);
			$DB1->update('phd_exam_result_master',$dataupdate);   		  
			
			//echo $DB1->last_query();

		}  
		echo "SUCCESS";
	}
	// calculate gpa
	public function calculate_gpa($examid)
	{
		$examid= $_POST['exam_id'];
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("ers.*,sgc.grade_rule");
		$DB1->from('phd_exam_result_master as ers');
		$DB1->join('student_master as sm','ers.student_id = sm.stud_id','left'); 
		$DB1->join('stream_grade_criteria as sgc','sm.admission_stream = sgc.stream_id','left');
		$DB1->where("ers.exam_id",$examid); 
		 
		$query=$DB1->get();
		$result=$query->result_array();	

		foreach($result as $mydata)
		{
		    //$rule =;
			$DB1->select("erd.enrollment_no,erd.student_id,erd.exam_id,erd.final_grade,erd.subject_id,erd.subject_code,sm.credits,gpd.grade_point,sum(sm.credits) as total_credits,
		sum(gpd.grade_point) as total_grade,sum(sm.credits*gpd.grade_point) as sumcredit,sum(case when gpd.grade_point=0 then 0 else sm.credits end ) as credit_earned,
		");
			$DB1->from('phd_exam_result_data as erd');
			$DB1->join('subject_master as sm','erd.subject_id = sm.sub_id','left'); 
			$DB1->join('grade_policy_details as gpd','erd.final_grade = gpd.grade_letter','left');
			$DB1->where("erd.student_id",$mydata['student_id']); 
			$DB1->where('gpd.rule', $mydata['grade_rule']); 

			$DB1->where("erd.exam_id",$examid); 		

			$query1=$DB1->get();

			$result1=$query1->row_array();		  
			if($result1['credit_earned']==0)	
			{
				$cgpa=0;
			}
			else
			{
			 $cgpa = bcdiv($result1['sumcredit'],$result1['credit_earned'], 4); 	
			}


		    $dupdate['grade_points_avg']=$cgpa;
		    $dupdate['credits_registered']=$result1['total_credits'];
	  		$dupdate['credits_earned']=$result1['credit_earned'];
	 		$dupdate['grade_points_earned']=$result1['total_grade'];
		    $dupdate['modified_by'] = $this->session->userdata("uid");
			$dupdate['modified_on'] = date('Y-m-d H:i:s');
			$dupdate['modified_ip'] = $this->input->ip_address();

	        $DB1->where('student_id', $result1['student_id']);
	        $DB1->where('exam_id', $examid);
			$DB1->update('phd_exam_result_master',$dupdate);   

		}
			//$DB1->join('student_master as sm','um.username = sm.enrollment_no','left');
		echo "SUCCESS";  
	}
	// arrear_report
	public function arrear_report()
    {
		//error_reporting(E_ALL); ini_set('display_errors', 1);
      $this->load->model('Phd_exam_timetable_model');
	  $this->load->model('Subject_model');
	  $this->data['batches']= $this->Subject_model->getRegulation1();
      if($_POST)
      {

        $this->load->view('header',$this->data);        
		$this->data['school_code'] =$_POST['school_code'];
		$this->data['admissioncourse'] =$_POST['admission-course'];
		$this->data['stream'] =$_POST['admission-branch'];
		$this->data['report_type'] =$_POST['report_type'];
		//$this->data['exam'] =$_POST['exam_session'];
		
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
		/*$exam= explode('-', $_POST['exam_session']);

		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$this->data['exam_month'] =$exam_month;
		$this->data['exam_year'] =$exam_year;
		$this->data['exam_id'] =$exam_id;*/
		$course_id = $_POST['admission-course']; 
		$school_code = $_POST['school_code']; 
		$stream = $_POST['admission-branch']; 		
		$batch = $_POST['batch']; 
		$this->load->model('Subject_model');
		$this->data['batch']= $batch;
		$this->data['StreamSrtName']= '';
		
		if($_POST['report_type']=='subjectwise'){
			$this->data['stream_list']= $this->Phd_results_model->get_arrear_stream_list($school_code,$course_id, $stream, $exam_id='');
			$i=0;
			foreach ($this->data['stream_list'] as $value) {
				$stream_id=  $value['stream_id'];
				$this->data['stream_list'][$i]['subject_list']= $this->Phd_results_model->get_arrear_subject_list($stream_id,$batch,$exam_id='');			
				$i++;
			}
			/*foreach ($this->data['subject_list'] as $value) {
				$subject_id=  $value['subject_id'];
				$this->data['subject_list'][$i]['stud_sub_applied']= $this->Phd_results_model->stud_arrear_sub_applied_list($stream_id,$subject_id,$exam_id);
				$i++;
			}*/
			$this->load->view($this->view_dir.'arrear_report_view',$this->data);
			$this->load->view('footer');

		}elseif($_POST['report_type']=='studentwise'){
			//echo "inside";
			$this->data['stream_list']= $this->Phd_results_model->get_arrear_stream_list($school_code,$course_id, $stream, $exam_id='');
			$i=0;
			foreach ($this->data['stream_list'] as $value) {
				$stream_id=  $value['stream_id'];
				$this->data['stream_list'][$i]['student_list']= $this->Phd_results_model->get_arrear_student_list($stream_id,$batch,$exam_id='');			
				$i++;
			}
			/*$this->data['student_list']= $this->Phd_results_model->get_arrear_student_list($stream,$exam_id);
			$i=0;
			foreach ($this->data['student_list'] as $value) {
				$student_id=  $value['student_id'];
				$this->data['student_list'][$i]['stud_sub_applied']= $this->Phd_results_model->stud_arrear_subject_list($stream,$student_id,$exam_id);
				$i++;
			}*/
			$this->load->view($this->view_dir.'arrear_report_view',$this->data);
			$this->load->view('footer');
		}else{
			echo "Something is wrong!!";
		}
 
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
        $this->load->view($this->view_dir.'arrear_report_view',$this->data);
        $this->load->view('footer');
      
      }   
    } 
	// arrear_report
	public function download_arrear_report($school_code,$course_id, $stream_id, $batch, $report_type)
    {
		//	error_reporting(E_ALL);
		$this->load->model('Phd_exam_timetable_model');
		$this->load->view('header',$this->data);        

		$this->data['batch']=$batch;
		$exam_id ='';
		$this->load->model('Subject_model');
		$this->data['report_type'] =$report_type;
		$this->data['StreamSrtName']= $this->Subject_model->get_stream_details($stream_id);
		
		if($report_type=='subjectwise'){

			$this->data['stream_list']= $this->Phd_results_model->get_arrear_stream_list($school_code,$course_id, $stream_id, $exam_id);
			$i=0;
			foreach ($this->data['stream_list'] as $value) {
				$stream_id=  $value['stream_id'];
				$this->data['stream_list'][$i]['subject_list']= $this->Phd_results_model->get_arrear_subject_list($stream_id,$batch, $exam_id);			
				$i++;
			}

			$this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'pdf_subjectwise_arrear_report',$this->data, true);
			$pdfFilePath1 ="Subjectwise_arrear_report.pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			$mpdf=new mPDF();
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '30', '10', '10', '10', '5');
			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");

		}elseif($report_type=='studentwise'){
			$this->data['stream_list']= $this->Phd_results_model->get_arrear_stream_list($school_code,$course_id, $stream_id, $exam_id);
			$i=0;
			foreach ($this->data['stream_list'] as $value) {
				$stream_id=  $value['stream_id'];
				$this->data['stream_list'][$i]['student_list']= $this->Phd_results_model->get_arrear_student_list($stream_id,$batch,$exam_id);			
				$i++;
			}

			$this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'pdf_studentwise_arrear_report',$this->data, true);
			$pdfFilePath1 ="Studentwise_arrear_report.pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			$mpdf=new mPDF();
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '30', '10', '10', '10', '5');
			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
		}else{
			echo "Something is wrong!!";
		} 
	} 	
	// arrear_report
	public function download_excel_arrear_report($school_code,$course_id, $stream_id, $batch, $report_type)
    {
		//	error_reporting(E_ALL);
		$this->load->model('Phd_exam_timetable_model');

		$exam_id ='';
		$this->load->model('Subject_model');
		$this->data['report_type'] =$report_type;
		$this->data['StreamSrtName']= $this->Subject_model->get_stream_details($stream_id);
		$this->data['batch']=$batch;
		if($report_type=='subjectwise'){

			$this->data['stream_list']= $this->Phd_results_model->get_arrear_stream_list($school_code,$course_id, $stream_id, $exam_id);
			$i=0;
			foreach ($this->data['stream_list'] as $value) {
				$stream_id=  $value['stream_id'];
				$this->data['stream_list'][$i]['subject_list']= $this->Phd_results_model->get_arrear_subject_list($stream_id,$batch, $exam_id);			
				$i++;
			} 

			$this->load->view($this->view_dir.'excel_subjectwise_arrears_report',$this->data);
			

		}elseif($report_type=='studentwise'){
			//error_reporting(E_ALL); ini_set('display_errors', 1);
			$this->data['stream_list']= $this->Phd_results_model->get_arrear_stream_list($school_code,$course_id, $stream_id, $exam_id);
			$i=0;
			foreach ($this->data['stream_list'] as $value) {
				$stream_i=  $value['stream_id'];
				$this->data['stream_list'][$i]['student_list']= $this->Phd_results_model->get_arrear_student_list($stream_i,$batch,$exam_id);			
				$i++;
			}
			$this->load->view($this->view_dir.'excel_studentwise_arrears_report',$this->data);
			
		}else{
			echo "Something is wrong!!";
		} 
	} 
	// assign markscard no 
	public function markscardno($regulation='', $examsession='', $school='',$course='',$stream='',$semester='')
	{
	   // error_reporting(E_ALL);exit();
	    $this->load->model('Exam_timetable_model');
		$this->load->model('Phd_results_model');
		$this->data['regulatn']= $this->Exam_timetable_model->getRegulation();
	    if(!empty($_POST) || $regulation !='')
	    {
	        //echo "<pre>";
	        // print_r($_POST);exit;
	        $this->load->view('header',$this->data);
	        if($regulation ==''){
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission-course'];
	        $this->data['stream'] =$_POST['admission-branch'];
	        $this->data['semester'] =$_POST['semester'];
	        $this->data['exam'] =$_POST['exam_session'];
	        $this->data['regulation'] =$_POST['regulation'];
	        $this->data['marks_type'] =$_POST['marks_type'];
	        $exam= explode('-', $_POST['exam_session']);
	        $var['admission-branch']=$_POST['admission-branch'];
	        $var['semester'] =$_POST['semester'];
			$exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];

	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
		    $this->data['stud_list']= $this->Phd_results_model->list_result_students_for_markcards($var,$exam_month, $exam_year,$exam_id);
	    }elseif($regulation !=''){
	    	$this->data['school_code'] =$school;
	        $this->data['admissioncourse'] =$course;
	        $this->data['stream'] =$stream;
	        $this->data['semester'] =$semester;
	        $this->data['exam'] =$examsession;
	        $this->data['regulation'] =$regulation;	
	        $exam= explode('-', $examsession); 
	        $var['admission-branch']=$stream;
	        $var['semester'] =$semester;
			$exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];

	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
		    $this->data['stud_list']= $this->Phd_results_model->list_result_students_for_markcards($var,$exam_month, $exam_year,$exam_id);
	    }else{
			
		}
	        $this->data['exam_session']= $this->Phd_results_model->fetch_exam_allsession();
	        $this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        $this->data['schools']= $this->Phd_results_model->getresltSchools();
	   				     
		    $this->load->view($this->view_dir.'markscard_no_assign_view',$this->data);

	        $this->load->view('footer');
	    }
	    else
	    {
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] ='';
	        $this->data['admissioncourse'] = '';
	        $this->data['stream'] = '';
	        $this->data['semester'] = '';
	        
	        $this->data['exam_session']= $this->Phd_results_model->fetch_exam_allsession();
	        $this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        $this->data['schools']= $this->Phd_results_model->getresltSchools();
	        $this->load->view($this->view_dir.'markscard_no_assign_view',$this->data);
	        $this->load->view('footer');
	    }   
	}
	// insert markscard no data
	function insert_markscard_data()
	{
		$this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$checked_stud = $_POST['chk_stud'];
		$school  = $_POST['school'];
		$stream = $_POST['stream_id'];
		$semester = $_POST['semester'];
		$examsession = $_POST['exam_session'];
		$regulation =$_POST['regulation'];
		$course = $_POST['course'];
		$exam = explode('-',$examsession);
		// print_r($exam);exit;
		$exam_id = $exam[2];
		$markscardno = $_POST['markscardno'];
		$stud_prn = $_POST['stud_prn'];
		$i=0;
		foreach($checked_stud as $stud){
			
			$stud_cnt = $this->Phd_results_model->CheckStudIn($stud,$exam_id, $stream, $semester);
			if(count($stud_cnt) > 0){				
				$this->Phd_results_model->updateMarksCardsNo($stud,$exam_id, $stream, $semester);
			}
	
			$insert_markscard_array=array(
					"student_id"=>$stud,
					"stream_id"=>$stream,
					"semester"=>$semester,
					"exam_month"=>$exam[0],
					"exam_year"=>$exam[1],
					"exam_id"=>$exam_id,
					"enrollment_no" => $stud_prn[$i],
					"markscard_no" => $markscardno[$i], 
					"school_id" => $school,	
					"is_active" => 'Y',
					"entry_by" => $this->session->userdata("uid"),
					"entry_on" => date("Y-m-d H:i:s"),
					"entry_ip" => $this->input->ip_address()
					);
			$DB1->insert("phd_exam_markscard_details", $insert_markscard_array); 
			$last_inserted_id_master =$DB1->insert_id();
			unset($stud_prn[$i]);
			$i++;
		}
		unset($markscardno);
		unset($stud_prn);
		$this->session->set_flashdata('mskrd', 'Gradesheet no assigned successfully.');
		redirect(base_url('Phd_results/markscardno/'.$regulation.'/'.$examsession.'/'.$school.'/'.$course.'/'.$stream.'/'.$semester));
	}
	// dispatch report for markscard no
	function download_mrksno_dispatch_report($mrknodetails)
	{
		$mrknodet =explode('~',$mrknodetails);
		//print_r($mrknodet);exit;
		$stream_id  =$mrknodet[0];
		$semester  =$mrknodet[1];
		$exam_month  =$mrknodet[2];
		$exam_year  =$mrknodet[3];
		$exam_id  =$mrknodet[4];
		$this->data['exam_month'] = $exam_month;
		$this->data['exam_year'] = $exam_year;
		$this->data['semester'] = $semester;
		$this->load->model('Marks_model');
		$this->data['stud_list']= $this->Phd_results_model->list_result_students_for_dispatch($stream_id, $semester,$exam_id);
		$strmname = $this->Marks_model->getStreamShortName($stream_id);
		$this->data['strmname'] = $strmname;
		$this->load->library('m_pdf');
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '10', '10', '15', '10', '10', '35');
		$html = $this->load->view($this->view_dir.'marsk_card_dispatch_pdf',$this->data, true);
		
		$pdfFilePath1 =$strmname[0]['stream_code'].'_'.$semester."_gradesheet_dispatch.pdf";
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$dattime = date('d-m-Y H:i:s');
		$mpdf=new mPDF();
		$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:5px">
		  <tr>
		    <td align="right" height="40" class="signature" style="text-align:right"><strong>Dispatched By :</strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
		    <td align="center" height="40" width="100" class="signature"><strong></strong></td>
		    <td align="right" height="40" class="signature" style="text-align:right"><strong>Handed Over To :</strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
		   
		  </tr>
		  
		  <tr>
		    <td align="right" height="40" class="signature" style="text-align:right"><strong>Sign & Date :</strong></td>
		    <td align="center" height="40" width="100" class="signature"><strong></strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
		    <td align="right" height="40" class="signature" style="text-align:right"><strong>Sign & Date :</strong></td>
			<td align="center" height="40" class="signature"><strong></strong></td>
			<td align="center" height="40" class="signature"><strong></strong></td>
		   
		  </tr>
		  <tr>
		    <td align="right" colspan="3" class="signature"><small><i>Printed on: '.$dattime.'</i></small></td>
		  </tr>
		</table>';
		$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->SetHTMLFooter($footer);
		$this->m_pdf->pdf->AddPage();
		$this->m_pdf->pdf->WriteHTML($html);	
		
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath1, "D");
	}
//
	public function with_held(){    
	    $this->load->view('header',$this->data);        
		$this->data['exam_session']= $this->Phd_results_model->fetch_with_held_exam_session();
		//$exam_id =$this->data['exam_session'][0]['exam_id'];
		if(!empty($_POST)){
			$exam_id= $_POST['exam_ses'];
			$this->data['exam_id'] = $exam_id;
			$this->data['whresults']= $this->Phd_results_model->fetch_withheld_result($exam_id);
		}
        $this->load->view($this->view_dir.'with_held_students_list',$this->data);
        $this->load->view('footer');
	}	
	public function updateWithheld(){    
		$this->Phd_results_model->update_withheld_result($_POST,$exam_id);
		echo "success";
	}	
	/**********************************Attendance Grade updation start***************************************************/
    function update_attendance_grade(){
    	$exam_id='9'; 
    	$liststud = $this->Phd_results_model->get_examresult_data($exam_id);
		//print_r($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Phd_results_model->update_attendance_grade($stud,$exam_id);
			//exit;
			$i++;
    	}
    	echo  $i."records Successfully Updated";
    }
	/*********************************Attendance Grade updation end****************************************************/
	public function php_info(){    
		phpinfo();
	}
	
	public function Arrear_graph(){
		//$this->data['TEst']='';
		 $this->load->view('header',$this->data); 
		 $graph= $this->Phd_results_model->graphs_new();
		// print_r($graph);
		  $this->data['graph']=$graph;
		 $this->load->view($this->view_dir.'Arrear_graph',$this->data);
	        $this->load->view('footer');
	}
	public function gpa_generation()
	{
		$stream_id = $this->input->post('stream_id');
		$exam_id = $this->input->post('exam_id');
		$semester = $this->input->post('semester');

		$this->Phd_results_model->calculate_sgpa($exam_id,$semester, $stream_id); //echo 'Done'; 
		$this->Phd_results_model->calculate_cgpa($exam_id, $stream_id); //echo 'Done'; 
		$this->Phd_results_model->calculate_gpa($exam_id,$semester, $stream_id); 
		
		echo json_encode(['status' => 'success', 'message' => 'GPA updated successfully']);
		
	}
	public function deleteResult()
    {        
		//error_reporting(E_ALL);exit();
        $result_data = $_POST['res_data']; 
        $res_detail_id = $_POST['res_detail_id'];
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);
		$subdetails = explode('~', $result_data);
		//print_r($subdetails);exit;
		$school_code  =$subdetails[0];
		$stream =$subdetails[1];
		$exam_month =$subdetails[2];
		$exam_year =$subdetails[3];
		$exam_id =$subdetails[4];
		$semester =$subdetails[5];
		
		$result_info = $this->Phd_results_model->deleteResult($stream,$semester,$exam_id);
		return true;
	}

    function generate_degree_certificate_pdf(){
		 ob_start();
		//error_reporting(E_ALL); ini_set('display_errors', 1); 
		 //echo "<pre>";
		// echo $chk_stud= $chk_checked; $semester=$sem;$admission_stream=$stream;$exam_session=$exam_session;
		 //$exam_session = explode('~', $_POST['exam_session']);
	     //print_r($_POST);exit;
		 //$this->Phd_results_model->fetch_student_grade_details($_POST);
		 $student=array();
		 if($_POST['stream_id'] !='71'){
			 
			 $student = $_POST['chk_stud'];
			 $exam_session = explode('~', $_POST['exam_session']);
			 //$certf_dat = str_replace('/', '-', $_POST['mrk_cer_date']);
			 
			 if(!empty($_POST['mrk_cer_date'])){
			 //$certf_date = date('d M, Y', strtotime($certf_dat));
			 }else{
				//$certf_date =''; 
			 }
			 
			 
			 $stream_id = $_POST['stream_id'];
			 $semester = $_POST['semester'];
			 $this->data['semester_post']=$_POST['semester'];
			 $exam_id =$exam_session[2]; 
			 $exam_ses =$exam_session[0].''.$exam_session[1];
			 $today_date = date('d-m-Y');
			 $gd_log['exam_id'] = $exam_id;	
			 $gd_log['generated_by'] = $this->session->userdata("uid");
			 $gd_log['generated_on'] = date('Y-m-d H:i:s');
			 $gd_log['generated_ip'] = $this->input->ip_address();
			$res_bklogsems =array();
			$resgrade=array();
			
			//print_r($student);
			//exit();
			/*$this->load->library('m_pdf');
				$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '30', '10', '10', '10', '5');*/
				$this->load->library('m_pdf');
			
			 foreach($student as $stud){
				 $mpdf=new mPDF();
				 $mpdf->SetFont('monotypecorsiva');
				$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '15', '30', '10', '10', '30', '5');
				 $exam_unique_id  = $this->Phd_results_model->fetch_student_exam_unique_id_for_degree($stud, $stream_id,$exam_id);
				 $this->data['stud_data'][] = $this->Phd_results_model->fetch_student_grade_details($stud, $stream_id,$semester,$exam_id);
				  $sdata=array();
				   $sdata['stud']=$stud;
				   $sdata['enrollment_no'] = $exam_unique_id[0]['enrollment_no'];
				   if($_POST['gc_id']==''){
				 $this->Phd_results_model->insert_markscard_data($sdata,$_POST);
				 }
				// $this->data['res_sem'] = $this->Phd_results_model->fetch_student_result_semester($stud,$exam_id);
				 //$this->data['backlog_grades'] = $this->Phd_results_model->fetch_student_backlog_grade_details($stud);
				// $this->data['backlog_kiran'] = $this->Phd_results_model->fetch_student_backlog_grade_details_kiran($stud);
				// $resultsgrade = $this->Phd_results_model->fetch_student_backlog_grade_from_result_data($stud,$exam_id);
				 //echo '<pre>';print_r($resultsgrade); //exit;
				/* foreach($resultsgrade as $rs11){
					$resgrade[] = $rs11[0]['final_grade'];
					if($rs11[0]['final_grade']=='U' || $rs11[0]['final_grade']=='F'){
						$res_bklogsems[] = $rs11[0]['semester'];
					}
				}*/
				$this->data['resultsgrade_f'] = $resultsgrade;
				
				//$this->data['resultsgrade'] = $resgrade;
				//$this->data['res_bklogsems'] = array_unique($res_bklogsems);
				
				//print_r($res_bklogsems);exit;
			/*	  echo "<pre>";
				 print_r($this->data['stud_data']);
				  echo "</pre>";
			*/

				
				 $this->data['exam_master_id'][] = $exam_unique_id[0]['exam_master_id'];

	  //$this->data['stud_data'][][]=$this->Phd_results_model->fetch_student_grades($stud,$exam_id);
				 ///////////////////
				$tempDir = 'uploads/phd/degree/'.$exam_ses.'/QRCode/';
				$fileName = 'qrcode_'.$exam_unique_id[0]['exam_master_id'].'.png';	
				
				$chkfileName = $tempDir.$fileName;	
				if(file_exists($chkfileName)) {
					//echo "The file $chkfileName exists";exit;
				}else{
					
				include_once "phpqrcode/qrlib.php";
				//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
				//The name of the directory that we need to create.
				//$tempDir = 'uploads/phd/degree/'.$exam_ses.'/QRCode/';
				//Check if the directory already exists.
				if(!is_dir($tempDir)){
					//Directory does not exist, so lets create it.
					mkdir($tempDir, 0755, true);
				}
				
				//$po_id = $p_row[0]['ord_no'];
				$siteurl="https://erp.sandipuniversity.com/";
				$codeContents = $siteurl.'qrphddegree.php?type=cert&id='.base64_encode($exam_unique_id[0]['enrollment_no']);
				
				// we need to generate filename somehow, 
				// with md5 or with database ID used to obtains $codeContents...
				$fileName = 'qrcode_'.$exam_unique_id[0]['exam_master_id'].'.png';		
				$pngAbsoluteFilePath = $tempDir.$fileName;
				$urlRelativeFilePath = $pngAbsoluteFilePath;
				
				// generating
				//if (!file_exists($pngAbsoluteFilePath)) {
				QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 2, 2);
					if (file_exists($pngAbsoluteFilePath)) {
						$src_file = $pngAbsoluteFilePath;
						$bucket_name = 'erp-asset';
						$filepath = $pngAbsoluteFilePath;
						$result = $this->awssdk->uploadFile($bucket_name, $filepath, $src_file);
						unlink($filepath);
					}

				}
				//////////////////
				//log start
				$gd_log['student_id'] = $stud;
				$gd_log['enrollment_no'] = $exam_unique_id[0]['enrollment_no'];	
				$this->Phd_results_model->save_gradesheet_log($gd_log);
			
			// } // foreach($student as $stud){
			 
			 $strmname = $this->data['stud_data'][0][0]['stream_short_name'];
			 $uniqid=$exam_unique_id[0]['exam_master_id'];
			/* echo "<pre>";
				 print_r($this->data['stud_data']);
				  echo "</pre>";
				 die;*/
			//$this->load->view($this->view_dir.'marsk_card_pdf',$this->data);
			 $report_type= $_POST['report_type'];
			 if($report_type=='pdf')
			 {

				//echo '<pre>';
				//print_r($this->data);
				//die;
				$this->data['exam_ses'] = $exam_ses;
				$this->data['exam_session'] = $exam_session;
				$this->data['thesis'] = $_POST['thesis'];
				$this->data['faculty'] =$_POST['faculty'];
				$this->data['mrk_cer_date'] =$_POST['mrk_cer_date'];
				//$this->load->view($this->view_dir.'marsk_card_pdf',$this->data);

				$html = $this->load->view($this->view_dir.'degree_certificate_pdf',$this->data,true);
				//echo $html;
				//exit();
				
				$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
				//$header='';
				$mpdf=new mPDF();

				$signature='Sign COE 01.png';
				
				$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:120px;font-size: 18px;font-family:Monotype Corsiva!important;">

				
				 <tr>
					<td align="left" height="50" width="15%" class="signazture" style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left" height="50" class="signature" valign="top"><strong>'; 
					$footer .='</strong></td>
					
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:#CDCACA;">'.$today_date.'</small></td>
	</tr>
	</table>';
				$this->m_pdf->pdf->Setfont($footer);
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLFooter($footer);
			
			$this->m_pdf->pdf->useFixedNormalLineHeight = false;
            $this->m_pdf->pdf->useFixedTextBaseline = false;
            $this->m_pdf->pdf->normalLineheight = 2.7;
            $this->m_pdf->pdf->adjustFontDescLineheight = 2.7;
		    //$this->m_pdf->pdf->SetDefaultBodyCSS('line-height', 5.2);
			$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1,
								'reset' => 0,
								'type' => 'I',
								'suppress' => 'off'
							];
				$this->m_pdf->pdf->AddPage();
				$this->m_pdf->pdf->WriteHTML($html);	
				ob_clean();
				//download it.
				$pdfFilePath1 =$strmname.'_'.$uniqid."_degree_certificate.pdf";
				//$this->m_pdf->pdf->Output($tempDir.'/'.$pdfFilePath1, "F");
				$this->m_pdf->pdf->Output($pdfFilePath1, "D");
				//unset($res_bklogsems);
				//unset($resgrade);
				
			 }else{
				//$this->load->view($this->view_dir.'marsk_card_excel',$this->data); 
			 }
			 unset($f_grade);
			 unset($resgrade);
			 unset($res_bklogsems);
			 }
			 
		}
		 
		
		// ob_end_flush();
	}


    	// previous exam grades entry
    public function degree_certificate()
	{
	   // error_reporting(E_ALL);exit();
	    $this->load->model('Exam_timetable_model');
		$this->load->model('Marks_model');
		$this->load->model('Phd_results_model');
		$this->data['regulatn']= $this->Exam_timetable_model->getRegulation();
	    if($_POST)
	    {
	          //echo "<pre>";
	         // print_r($_POST);exit;
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission-course'];
	        $this->data['stream'] =$_POST['admission-branch'];
	        $this->data['semester'] =$_POST['semester'];
	        $this->data['exam'] =$_POST['exam_session'];
	        $this->data['marks_type'] =$_POST['marks_type'];
	        $this->data['exam_session']= $this->Phd_results_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Phd_results_model->getresltSchools();
	        $exam= explode('-', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
		    $this->data['stud_list']= $this->Phd_results_model->list_result_students_for_degree($_POST,$exam_month, $exam_year,$exam_id);
			//$this->data['dispatch_list']=$this->Phd_results_model->fetch_dispatch_enroll($_POST);
			
		    $this->load->view($this->view_dir.'degree_certificate',$this->data);

	        $this->load->view('footer');
	    }
	    else
	    {
	    	$_POST=array();
	        
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] ='';
	        $this->data['admissioncourse'] = '';
	        $this->data['stream'] = '';
	        $this->data['semester'] = '';
	        
	        $this->data['exam_session']= $this->Phd_results_model->fetch_exam_allsession();
			//$this->data['dispatch_list']=$this->Phd_results_model->fetch_dispatch_enroll($_POST);

	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Phd_results_model->getresltSchools();
	        $this->load->view($this->view_dir.'degree_certificate',$this->data);
	        $this->load->view('footer');
	        
	    }
	    
	    
	}	
		 /////////////////code by sid///////////////
	 public function phd_degree_cert_assign_list()
	 {
		 $this->load->view('header',$this->data);
		 $this->data['stud_details']=$this->Phd_results_model->fetch_phd_degree_cert_assgn_det();
		 $this->load->view($this->view_dir.'phd_degree_cert_list',$this->data);
		 $this->load->view('footer');
	 }
	   public function phd_cert_edit()
	 {
		 $this->load->view('header',$this->data);
		 $gc_id=$this->uri->segment(3);
		 $this->data['stud_details']=$this->Phd_results_model->fetch_phd_degree_cert_assgn_det($gc_id);   
		 $this->load->view($this->view_dir.'phd_degree_cert_edit',$this->data);
		 $this->load->view('footer'); 
	 } 
	 
	 public function phd_cert_edit_submit()
	 {
		
		 $this->load->view('header',$this->data);
	     $this->Phd_results_model->update_phd_cert_assign_det($_POST); 
		 $this->data['stud_details']=$this->Phd_results_model->fetch_phd_degree_cert_assgn_det();
		 $this->load->view($this->view_dir.'phd_degree_cert_list',$this->data);
		 $this->load->view('footer');
	 }
	 function generate_degree_certificate_dispatch_pdf($gc_id=''){

		 ob_start();
          $gc_id=base64_decode($gc_id);
		  $dis_data=$this->Phd_results_model->fetch_phd_degree_cert_assgn_det($gc_id);
         // echo'<pre>';
		 // print_r($dis_data);exit;
		 $student=array();
		 if($dis_data[0]['stream_id'] !='71'){
	 
			 $stud = $dis_data[0]['student_id'];
			 //$exam_session = explode('~', $_POST['exam_session']);
			 $stream_id = $dis_data[0]['stream_id'];
			 $semester = $dis_data[0]['semester'];
			 $this->data['semester_post']=$dis_data[0]['semester'];
			 $exam_id =$dis_data[0]['exam_id']; 
			 $exam_ses =$dis_data[0]['exam_month'].''.$dis_data[0]['exam_year'];
			 $today_date = date('d-m-Y');
			 $res_bklogsems =array();
			 $resgrade=array();
			 
			/*$this->load->library('m_pdf');
				$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '30', '10', '10', '10', '5');*/
				$this->load->library('m_pdf');

				 $mpdf=new mPDF();
				 $mpdf->SetFont('monotypecorsiva');
				$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '15', '30', '10', '10', '30', '5');

				 $exam_unique_id  = $this->Phd_results_model->fetch_student_exam_unique_id_for_degree($stud, $stream_id,$exam_id);
				 $this->data['stud_data'][] = $this->Phd_results_model->fetch_student_grade_details($stud, $stream_id,$semester,$exam_id);
				 $this->data['resultsgrade_f'] = $resultsgrade;
				 $this->data['exam_master_id'][] = $exam_unique_id[0]['exam_master_id'];
				 ///////////////////
				$tempDir = 'uploads/phd/degree/'.$exam_ses.'/QRCode/';
				$fileName = 'qrcode_'.$exam_unique_id[0]['exam_master_id'].'.png';	
				
				$chkfileName = $tempDir.$fileName;	

			    $strmname = $this->data['stud_data'][0][0]['stream_short_name'];
			    $uniqid=$exam_unique_id[0]['exam_master_id'];

				$this->data['exam_ses'] = $exam_ses;
				//$this->data['exam_session'] = $exam_session;
				$this->data['thesis'] =$dis_data[0]['thesis_name'];
				$this->data['faculty'] =$dis_data[0]['faculty_name'];
			    $this->data['mrk_cer_date'] =$dis_data[0]['issued_date'];
				//$this->load->view($this->view_dir.'marsk_card_pdf',$this->data);
				$html = $this->load->view($this->view_dir.'degree_certificate_pdf',$this->data,true);
				//echo $html;
				//exit();
				
				$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
				//$header='';
				$mpdf=new mPDF();

				$signature='Sign COE 01.png';
				
				$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:120px;font-size: 18px;font-family:Monotype Corsiva!important;">

				
				 <tr>
					<td align="left" height="50" width="15%" class="signazture" style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left" height="50" class="signature" valign="top"><strong>'; 
					$footer .='</strong></td>
					
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:#CDCACA;">'.$today_date.'</small></td>
	</tr>
	</table>';
				$this->m_pdf->pdf->Setfont($footer);
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLFooter($footer);
			
			$this->m_pdf->pdf->useFixedNormalLineHeight = false;
            $this->m_pdf->pdf->useFixedTextBaseline = false;
            $this->m_pdf->pdf->normalLineheight = 2.7;
            $this->m_pdf->pdf->adjustFontDescLineheight = 2.7;
		    //$this->m_pdf->pdf->SetDefaultBodyCSS('line-height', 5.2);
			$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1,
								'reset' => 0,
								'type' => 'I',
								'suppress' => 'off'
							];
				$this->m_pdf->pdf->AddPage();
				$this->m_pdf->pdf->WriteHTML($html);	
				ob_clean();
				//download it.
				$pdfFilePath1 =$strmname.'_'.$uniqid."_degree_certificate.pdf";
				//$this->m_pdf->pdf->Output($tempDir.'/'.$pdfFilePath1, "F");
				$this->m_pdf->pdf->Output($pdfFilePath1, "D");

			 unset($f_grade);
			 unset($resgrade);
			 unset($res_bklogsems);
			
			 
		}		
		// ob_end_flush();
	}
}
  ?>