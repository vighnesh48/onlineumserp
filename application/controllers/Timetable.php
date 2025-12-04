<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Timetable extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="subject_master";
    var $model_name="Timetable_model";
    var $model;
    var $view_dir='Timetable/';
    var $data=array();
	
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        ini_set('memory_limit','-1');
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
		//error_reporting(E_ALL);
		$this->load->model('Subject_model');
        $this->load->view('header',$this->data);        
        $this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['school_details']= $this->Timetable_model->getSchools();
		$this->data['slot']= $this->Timetable_model->getSlots_old();
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session(); 
		$this->data['cur_session']= $this->Timetable_model->fetch_Curracademic_session();
		$this->data['faculty_list']=$this->Timetable_model->get_faculty_list();

		//print_r($this->data['cur_session']);exit;
		$this->data['batches']= $this->Timetable_model->fetch_subject_batches();
		if(!empty($this->session->userdata('Tcourse_id'))){
			
			$course_id = $this->session->userdata('Tcourse_id');
			$stream_id = $this->session->userdata('Tstream_id');
			$sem = $this->session->userdata('Tsemester');
			$division = $this->session->userdata('Tdivision');
			$academicyear = $this->session->userdata('Tacdyr');
			$sub_type = $this->session->userdata('Tsub_type');

			$this->data['Tfaculty'] = $this->session->userdata('Tfaculty');
			$this->data['Tsub_type'] = $this->session->userdata('Tsub_type');
			$this->data['Tbatch_no'] = $this->session->userdata('Tbatch_no');
			$this->data['Tsubject'] = $this->session->userdata('Tsubject');
			$this->data['Tacdyr'] = $this->session->userdata('Tacdyr');
            $this->data['Tbatch'] = $this->session->userdata('Tbatch');
			
			$this->data['courseId'] = $course_id;
			$this->data['streamId'] = $stream_id;
			$this->data['semesterNo'] = $sem;
			$this->data['division'] = $division;
			$this->data['academicyear'] =$academicyear;
			$this->data['sub_type'] =$sub_type;

			
			$this->data['tt_details']=$this->Timetable_model->get_tt_details($sub_id='',$course_id,$stream_id,$sem, $division, $academicyear);       	                                        
		}		
        $this->load->view($this->view_dir.'add_timetable',$this->data);
        $this->load->view('footer');
    }
	public function ttlist()
    {
		//error_reporting(E_ALL);
		$Tarray_items = array('Tfaculty','Tbatch_no','Tsub_type','Tcourse_id','Tstream_id','Tsemester','Tdivision','Tsubject');
        $this->session->unset_userdata($Tarray_items);
		if($this->session->userdata("role_id")==20 ||  $this->session->userdata("role_id")==10 ||  $this->session->userdata("role_id")==44 ||  $this->session->userdata("role_id")==6){
		}else{
			redirect('home');
		}
		$this->load->model('Subject_model');
        $this->load->view('header',$this->data); 
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
		
		if($_POST['course_id'] !=''){
			$course_id = $_POST['course_id'];
			$stream_id = $_POST['stream_id'];
			$sem = $_POST['semester'];
			$division = $_POST['division'];
			$academicyear = $_POST['academic_year'];
			$this->data['courseId'] = $_POST['course_id'];
			$this->data['streamId'] = $_POST['stream_id'];
			$this->data['semesterNo'] = $_POST['semester'];
			$this->data['division'] = $_POST['division'];
			$this->data['academicyear'] =$_POST['academic_year'];
			//put values in session
			$this->session->set_userdata('TScourse_id',$_POST['course_id']);
			$this->session->set_userdata('TSstream_id',$_POST['stream_id']);
			$this->session->set_userdata('TSsemester',$_POST['semester']);
			$this->session->set_userdata('TSdivision',$_POST['division']);
			$this->session->set_userdata('TSacdyr',$_POST['academic_year']);
			$this->session->set_userdata('Tbatch_no',$_POST['batch_no']);
			$this->data['tt_details']=$this->Timetable_model->get_tt_details($sub_id='',$course_id,$stream_id,$sem, $division, $academicyear);
			//$uId=$this->session->userdata('uid');

	
			       	                                        
		}elseif(!empty($this->session->userdata('TScourse_id'))){

			$course_id = $this->session->userdata('TScourse_id');
			$stream_id = $this->session->userdata('TSstream_id');
			$sem = $this->session->userdata('TSsemester');
			$division = $this->session->userdata('TSdivision');
			$academicyear = $this->session->userdata('TSacdyr');

			$this->data['courseId'] = $this->session->userdata('TScourse_id');
			$this->data['streamId'] = $this->session->userdata('TSstream_id');
			$this->data['semesterNo'] = $this->session->userdata('TSsemester');
			$this->data['division'] = $this->session->userdata('TSdivision');
			$this->data['academicyear'] = $this->session->userdata('TSacdyr');
			
			$this->data['tt_details']=$this->Timetable_model->get_tt_details($sub_id='',$course_id,$stream_id,$sem, $division, $academicyear);
		}			
        //$this->data['tt_details']=$this->Timetable_model->get_tt_details();       	                                        
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    // load streams
	public function load_streams()
	{
    	global $model;	    
	    $this->data['campus_details']= $this->Timetable_model->get_course_streams($_POST);     	    
	}
	
    // load subject
	public function load_subject(){
		$streamId = $_POST['streamId'];
		$course_id = $_POST['course'];
		$semesterId = $_POST['semesterId'];
		$batch = $_POST['batch'];
		$this->data['emp']= $this->Timetable_model->load_subject($course_id, $streamId, $semesterId,$batch);
	}
    // load subject type
	public function load_subject_type(){
		$subject_id = $_POST['subject'];
		$subtype= $this->Timetable_model->load_subject_type($subject_id);
		//print_r($subtype[0]['subject_component']);exit;
		 $rowCount = count($subtype);
			//Display cities list
			if($subtype[0]['subject_component'] !=''){
				echo '<option value="">Select Lecture Type</option>';
				if($subtype[0]['subject_component']=='EM'){
					echo '<option value="TH">Theory</option>';
					echo '<option value="PR">Practical</option>';
				}else{
					foreach($subtype as $value){
						
						if($value['subject_component']=='TH'){
								$scname="Theory";
						}else{
							$scname="Practical";
						}
						if($value['sub_id']=="3734"){
							$scnamee="Theory";
							echo '<option value="TH">'.$scnamee.'</option>';
						}
						
						echo '<option value="'.$value['subject_component'].'">'.$scname.'</option>';
					}
				}
			} else{
				echo '<option value="">Select Lecture Type</option>';
				echo '<option value="TH">Theory</option>';
				echo '<option value="PR">Practical</option>';
			}
	}	
    // load Department
	public function load_department(){
		$school_id = $_POST['school_id'];
		$course_id = $_POST['course'];
		$semesterId = $_POST['semesterId'];
		$this->data['emp']= $this->Timetable_model->load_department($school_id);
	}	
    // load Faculty
	public function load_faculty(){
		$school_id = $_POST['school_id'];
		$dept_id = $_POST['dept_id'];
		$faculty_type = $_POST['faculty_type'];
		
		if($faculty_type=='per'){
			$this->data['emp']= $this->Timetable_model->load_faculty($school_id, $dept_id);
		}else{
			$this->data['emp']= $this->Timetable_model->load_temp_faculty($school_id, $dept_id);
		}
	}	
	// insert to timetable
	public function insert_timetable(){
		// duplicate entry check in timetable
		$check_school = $this->Timetable_model->fetchschool_bystream($_POST['stream_id']);
		
		if($check_school[0]['school_id'] !=9){
			$chk_duplicate = $this->Timetable_model->checkDuplicateTt($_POST);
			$chk_duplicate =count($chk_duplicate);
		}else{			
			$chk_duplicate=0;	
		}
		//$chk_duplicate1 = $this->Timetable_model->checkDuplicateLectSloat($_POST);
		//$chk_duplicate2 = $this->Timetable_model->checkDuplicateLect($_POST);
		//echo "1".count($chk_duplicate1);echo "<br>";
		//echo "2".count($chk_duplicate1);
		//exit;
		/*
		if(count($chk_duplicate1) > 0){
			$this->session->set_flashdata('dup_msg', 'This Slot is already assigned.');
			redirect(base_url($this->view_dir));
		}elseif(count($chk_duplicate2) > 0){
			$this->session->set_flashdata('dup_msg', 'This subject is already assigned in Timetable');
			redirect(base_url($this->view_dir));
		}else
			*/
		
		if($chk_duplicate > 0){
			$this->session->set_flashdata('dup_msg', 'This subject is already assigned in Timetable');
			redirect(base_url($this->view_dir));
		}else{
			
			$last_inserted_id = $this->Timetable_model->insert_timetable($_POST);
			if($last_inserted_id)
			{
				$this->session->set_flashdata('Tmessage', 'Time table entry inserted successfully.');
				redirect(base_url($this->view_dir));
			}
			else
			{
				redirect(base_url($this->view_dir));
			}
		}
	}
	// edit view
	public function edit($tt_id){
		if($this->session->userdata("role_id")==20 ||  $this->session->userdata("role_id")==10 ||  $this->session->userdata("role_id")==44 ||  $this->session->userdata("role_id")==6){
		}else{
			redirect('home');
		}
		$this->load->model('Subject_model');  
		$this->load->view('header',$this->data);   
		$this->data['batches']= $this->Timetable_model->fetch_subject_batches();
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session(); 		
        $this->data['ttdet']=$this->Timetable_model->get_tt_details($tt_id);     
		$this->data['f_name']=$this->Timetable_model->get_faculty_name($this->data['ttdet'][0]['faculty_code']);
		$this->data['faculty_list']=$this->Timetable_model->get_faculty_list();
        $this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['school_details']= $this->Timetable_model->getSchools();
		$this->data['slot']= $this->Timetable_model->getSlots_old();		
        $this->load->view($this->view_dir.'add_timetable',$this->data);
        $this->load->view('footer');
	}
	// Update Time table
	public function update_timetable(){
		$last_inserted_id = $this->Timetable_model->update_timetable($_POST);
		if($last_inserted_id)
		{
			$this->session->set_flashdata('Tmessage', 'Time table entry updated successfully.');
			redirect(base_url($this->view_dir."ttlist"));
		}
		else
		{
			redirect(base_url($this->view_dir.'ttlist'));
		}
	}
	// view time table generic 
	public function viewTtable_old($tt_id=''){
		$role_id = $this->session->userdata('role_id');
		$this->load->model('Subject_model');  
		$this->load->view('header',$this->data); 
		$this->data['academic_year']= $this->Timetable_model->fetch_Curracademic_session(); 		
        //$this->data['tt_details']=$this->Timetable_model->get_tt_details();

      /* $uId=$this->session->userdata('uid');
		if($uId=='2')
		{
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
			die;
		}  */      	                                        
        $this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['school_details']= $this->Timetable_model->getSchools();


		if ($role_id != '' && !in_array($role_id, [6, 53, 58])) {
			$this->data['emp_sem'] = $this->Timetable_model->getemp_sem();
			$this->data['emp_div'] = $this->Timetable_model->getemp_div();
		}
		$this->data['ttsub'] = array();
		
		$course_id = $_POST['course_id'];

		$this->data['courseId']=$_POST['course_id'];
		$this->data['division']=$_POST['division'];
		$this->data['semesterNo']=$_POST['semester'];
		$this->data['streamId']=$_POST['stream_id'];
		$this->data['academicyear']=$_POST['academic_year'];
		$this->data['faculty_id']=$_POST['faculty_id'];
		if($_POST){
		$this->data['slot_time']= $this->Timetable_model->getSlots($_POST);
		}
		/* $uId=$this->session->userdata('uid');
		if($uId=='2')
		{
			echo "<pre>";
			print_r($this->data['slot_time']);
			echo "</pre>";
			die;
		}   
		*/

		$slots=$this->data['slot_time'];
		$wday = array('Monday','Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		
		if(isset($course_id) && $course_id==3){ // for M.TECH Sunday is added
		array_push($wday, "Sunday");
		}
		
		$this->data['wday'] = $wday;
		if(!empty($_POST)){
			for($i=0;$i<count($wday);$i++){
				$this->data['ttsub'][]= $this->Timetable_model->fetchTimeTable($slots,$wday[$i],$_POST);
            }
			// echo'<pre>';
			// print_r($this->data['ttsub']);exit;
		}

		//$this->data['tt']= $this->Timetable_model->fetchTimeTable();		
        $this->load->view($this->view_dir.'view_timetable_n',$this->data);
        $this->load->view('footer');
	}
	public function fetchFaculty()
	{
		$academic_year = $this->input->post('academic_year');
		$campus = $this->input->post('campus');

	
		if (!empty($academic_year)) {

			$faculties = $this->Timetable_model->getFacultyByStream($academic_year,$campus);

			echo json_encode($faculties);

		} else {
			echo json_encode([]); // Return empty array if no data
		}
	}

	public function studTimeTable12121($tt_id=''){
		//error_reporting(E_ALL); ini_set('display_errors', '1');
		$stud_enroll_no = $this->session->userdata("name");
		$this->load->model('Subject_model');  
		$this->load->view('header',$this->data);        
        //$this->data['tt_details']=$this->Timetable_model->get_tt_details();      	                                               
		//$this->data['school_details']= $this->Timetable_model->getSchools();
		$stud_det= $this->Timetable_model->fetch_stud_details($stud_enroll_no);
		$acdyr= $this->Timetable_model->fetch_Curracademic_session();
		$var =array();
		$var['academic_year'] = $acdyr[0]['academic_year'].'~'.$acdyr[0]['academic_session'];
		//$var['stream_id'] =$stud_det[0]['admission_stream'];
		$first_year = array(5,6,7,8,9,10,11,96,97);
		
		if (in_array($stud_det[0]['stream_id'], $first_year) && $stud_det[0]['current_year']==1)
	    {
			$var['stream_id'] =9;
	    }
	    else
	    {
	      $var['stream_id'] =$stud_det[0]['stream_id'];
	    }
		
		$var['semester'] = $stud_det[0]['current_semester'];
		
		$division = $stud_det[0]['division'];
		if($division !=''){
			$var['division'] = $division;
		}else{
			$var['division'] = 'A';			
		}
			$this->data['course_id']= $stud_det[0]['course_id'];
		$this->data['course_short_name']= $stud_det[0]['stream_short_name'];
		$this->data['semester']= $stud_det[0]['current_semester'];
		if($stud_det[0]['batch'] !=0){
		$this->data['batch']= $division.''.$stud_det[0]['batch'];
		}elseif($division !=''){
			$this->data['batch']= $division;	
		}else{
			$this->data['batch']= 'A';	
		}
		
		$this->data['ttsub'] = array();
		$this->data['slot_time']= $this->Timetable_model->getSlotsforStud($var);
		$slots=$this->data['slot_time'];
		$wday = array('Monday','Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		$this->data['wday'] = $wday;

		for($i=0;$i<count($wday);$i++){
			$this->data['ttsub'][]= $this->Timetable_model->fetchTimeTable($slots,$wday[$i],$var);
		}
		//print_r($this->data['ttsub']);
		//$this->data['tt']= $this->Timetable_model->fetchTimeTable();		
        $this->load->view($this->view_dir.'view_timetable_17',$this->data);
        $this->load->view('footer');
	}
	// aaded on 20/09/17
	public function removeTimetableEntry($tt_id)
	{
        $this->load->view('header',$this->data); 
		if($this->Timetable_model->removeTimetableEntry($tt_id))
		{
			redirect('timetable/ttlist/');
		}
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
	function load_ttcources(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["academic_year"]) && !empty($_POST["academic_year"])){
			//Get all streams
			$stream = $this->Timetable_model->load_ttcources($_POST["academic_year"]);
            
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
    function load_ttsemesters(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			//Get all streams
			$stream = $this->Timetable_model->load_ttsemesters($_POST["stream_id"], $_POST["academic_year"]);
            
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
	function load_ttdivision(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			//Get all streams
			$stream = $this->Timetable_model->load_ttdivision($_POST["stream_id"], $_POST["academic_year"], $_POST["semester"]);
            
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
	
	function load_faculty_data(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			//Get all streams
			$stream = $this->Timetable_model->load_faculty_data($_POST["stream_id"], $_POST["academic_year"], $_POST["semester"],$_POST["division"]);
            echo $stream;
		}
	}
	
	
	
	//faculty allocation
	public function assign_faculty($streamId='', $semester='', $division='',$academic_year='', $course_id='',$school_code='',$reporttype='')
    {
		/*error_reporting(E_ALL); ini_set('display_errors', '1'); */
		$this->load->model('Subject_model');
		$this->load->model('Exam_timetable_model');
        $this->load->view('header',$this->data); 
         $this->data['schools']= $this->Exam_timetable_model->getSchools();
		$this->data['course_details']= $this->Subject_model->getCollegeCourse();
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session(); 
		if($_POST['course_id'] !=''){

			$course_id = $_POST['course_id'];
			$stream_id = $_POST['stream_id'];
			$sem = $_POST['semester'];
			$division = $_POST['division'];
			$this->data['school_code'] = $_POST['school_code'];
			$this->data['courseId'] = $_POST['course_id'];
			$this->data['streamId'] = $_POST['stream_id'];
			$this->data['semesterNo'] = $_POST['semester'];
			  $this->data['reporttype'] = $_POST['reporttype'];
			$this->data['academicyear'] = $_POST['academic_year'];
			$this->data['division'] = $division;
			
			$this->data['tt_details']=$this->Timetable_model->get_tt_subdetailsindividual($sub_id='',$course_id,$stream_id,$sem, $division,$_POST['academic_year'],$_POST['school_code']);
			$this->data['class_faculty_list']=$this->Timetable_model->get_class_faculty_listindividual($stream_id,$sem, $division,$_POST['academic_year'],$_POST['school_code']);  
			$i=0;
			/*foreach ($this->data['tt_details'] as $value) {
			 	$this->data['tt_details'][$i]['facultyname']=$this->Timetable_model->fetch_faculty($stream_id,$sem, $division,$_POST['academic_year'],$value['subject_code']);
			 	$i++; 
			 } */
			     	                                        
		}
		elseif($streamId !=''){
			$course_id = $course_id;
			$stream_id = $streamId;
			$sem = $semester;
			$division = $division;
			$this->data['school_code'] =$school_code;
			$this->data['courseId'] = $course_id;
			$this->data['streamId'] = $stream_id;
			$this->data['semesterNo'] = $sem ;
			$this->data['reporttype'] =$reporttype;
			$this->data['academicyear'] =$academic_year;
			$this->data['division'] =  $division;
			$this->data['tt_details']=$this->Timetable_model->get_tt_subdetailsindividual($sub_id='',$course_id,$stream_id,$sem, $division,$academic_year,$school_code);
			$this->data['class_faculty_list']=$this->Timetable_model->get_class_faculty_listindividual($stream_id,$sem, $division,$academic_year,$school_code);   
			$i=0;
			/*foreach ($this->data['tt_details'] as $value) {

			 	$this->data['tt_details'][$i]['facultyname']=$this->Timetable_model->fetch_faculty($streamId,$semester, $division,$academic_year,$value['subject_code']);
			 	$i++; 
			 } */  
		}
		else{


			$course_id = $_POST['course_id'];
			$stream_id = $_POST['stream_id'];
			$sem = $_POST['semester'];
			$division = $_POST['division'];
			$this->data['school_code'] = $_POST['school_code'];
			$this->data['courseId'] = $_POST['course_id'];
			$this->data['streamId'] = $_POST['stream_id'];
			$this->data['semesterNo'] = $_POST['semester'];
			$this->data['reporttype'] = $_POST['reporttype'];
			$this->data['academicyear'] = $_POST['academic_year'];
			$this->data['division'] = $division;
			
			$this->data['tt_details']=$this->Timetable_model->get_tt_subdetailsindividual($sub_id='',$course_id,$stream_id,$sem, $division,$_POST['academic_year'],$_POST['school_code']);
			$this->data['class_faculty_list']=$this->Timetable_model->get_class_faculty_listindividual($stream_id,$sem, $division,$_POST['academic_year'],$_POST['school_code']);  
		}		
        //$this->data['tt_details']=$this->Timetable_model->get_tt_details();       	                                        
        $this->load->view($this->view_dir.'faculty_allocation_view',$this->data);
        $this->load->view('footer');
    }
    //add view
	public function add_subject_faculty($subject_id,$stream_id,$semester,$division,$batch,$course_id,$academicyear,$school_code,$reporttype=''){
		//error_reporting(E);
		ini_set('memory_limit','-1');
		$this->load->model('Subject_model');  
		$this->load->view('header',$this->data); 
		$this->data['academicyear']=$academicyear;
		$this->data['school_code']=$school_code;
		$this->data['reporttype']=$reporttype;
        $this->data['ttdet']=$this->Timetable_model->get_tt_details($tt_id);     
		$this->data['sub']=$this->Timetable_model->get_subdetails($subject_id,$stream_id,$semester,$division,$batch,$academicyear);
		$this->data['fac']=$this->Timetable_model->fetch_faculty($stream_id,$semester, $division,$academicyear,$subject_id);
		$this->data['faculty_list']=$this->Timetable_model->get_faculty_list(); 		
        $this->load->view($this->view_dir.'add_faculty_subject',$this->data);
        $this->load->view('footer');
	}

	// insert to timetable
	public function insert_subject_faculty(){
		//error_reporting(E_ALL); ini_set('display_errors', 1);	
		$chk_duplicate = $this->Timetable_model->checkDuplicate_faculty($_POST);

		if(count($chk_duplicate) > 0){			
			$this->Timetable_model->update_subject_faculty($_POST);
		}
		
		if($this->Timetable_model->insert_subject_faculty($_POST))
		{
			$this->Timetable_model->update_subject_faculty_intimetable($_POST);
			$this->session->set_flashdata('Tmessage', 'Faculty allocated successfully.');
			if(!empty($_POST['academic_session']) && $_POST['academic_session']=='WIN'){
				$ses = "WINTER";
			}else{
				$ses = "SUMMER";
			}
			redirect(base_url($this->view_dir.'assign_faculty/'.$_POST['stream_id'].'/'.$_POST['semester'].'/'.$_POST['division'].'/'.$_POST['academic_year'].'~'.$ses.'/'.$_POST['course_id'].'/'.$_POST['school_code'].'/'.$_POST['reporttype']));
		}
		else
		{
			redirect(base_url($this->view_dir.'assign_faculty'));
		}
	}
	// Update class details
	public function update_class_details(){	     
		if($this->Timetable_model->update_class_details($_POST)){
			echo "SUCCESS";
		}else{
			echo "Problem";
		}   

	}
// attendance mailing functionality 
	public function timetable_schoolwise_mail(){
		//error_reporting(E_ALL);
		date_default_timezone_set("Asia/Kolkata");
		$todaysdate = '2018-10-22';	   
		$day = date('l', strtotime($todaysdate));
		$academic= $this->Timetable_model->fetch_Curracademic_session(); 
		$academic_year =$academic[0]['academic_year'];
		$academic_session =$academic[0]['academic_session'];
		if($academic_session=='WINTER'){
			$ses= "WIN";
		}else{
			$ses= "SUM";
		}
		$html ='';
		$schools = $this->Timetable_model->fetch_schools($todaysdate,$day,$academic_year,$ses);
		foreach ($schools as $val) {
			$school_code = $val['school_code'];
			$school_name = $val['school_name'];
			$html .='<table width="100%" border="1" cellspacing="0" cellpadding="5">
			<tr bgcolor="#0550c0">
			<td colspan="9" style="font-weight: bold;text-align:center; text-transform:uppercase;font-size: 17px;color:#fff;">Daily Attendence Report</td>
			</tr>
			  <tr bgcolor="#e6e6e6">
				<td colspan="5" width="50%"><strong>Day :</strong> '.$day.'</td>
				<td colspan="4"><strong>Date : </strong>'.$todaysdate.'</td>
			  </tr bgcolor="#CCCCCC">
			  <tr bgcolor="#e6e6e6">
				<td colspan="9"><strong>School Name : </strong> '.$school_name.'</td>
			  </tr>';
			$streams = $this->Timetable_model->fetch_streams($school_code,$day, $academic_year,$ses);
			foreach ($streams as $value) {
				$stream_id = $value['stream_id'];
				$stream_name = $value['stream_name'];
				$division = $value['division'];
				$semester = $value['semester'];
				$html .='<tr bgcolor="#e6e6e6">
				<td colspan="3" width="33%"><strong>Class : </strong> '.$stream_name.'</td>
				<td colspan="3"><strong>Sem :</strong> '.$semester.'</td>
				<td colspan="3"><strong>Div :</strong> '.$division.'</td>
			  </tr>';
							
							$html .='<tr bgcolor="#317def">
				 <th style="color:#fff;" width="5%">Sr No.</th>
				<th style="color:#fff;" width="30%">Subject Name</th>
				<th style="color:#fff;" width="5%">Type</th>
				<th style="color:#fff;" width="10%">Slot</th>
				<th style="color:#fff;" width="30%">Faculty Name</th>
				<th style="color:#fff;" width="5%">P</th>
				<th style="color:#fff;" width="5%">A</th>
				<th style="color:#fff;" width="5%">T</th>
				<th style="color:#fff;">%</th>
			  </tr>';
			$mdata = $this->Timetable_model->fetch_mailing_details($todaysdate,$day, $school_code, $stream_id,$semester, $division, $academic_year,$ses);
			$i=1;
			if(!empty($mdata)){
				foreach ($mdata as $mld) {
					$subject_name = $mld['subject_name'];
					$sub_code = $mld['sub_code'];
					$subject_type = $mld['subject_type'];
					$slot = $mld['from_time'].'-'.$mld['to_time'].' '.$mld['slot_am_pm'];
					$facname = strtoupper($mld['fname'][0].'. '.$mld['mname'][0].'. '.$mld['lname']);;
					$att_percentage = number_format($mld['att_percentage'], 2, '.', '');
					$tot_students = $mld['tot_students'];
					$totPersent = $mld['totPersent'];
					$totAbsent=$tot_students - $totPersent;
					$html .='<tr>
					<td align="center">'.$i.'</td>
					<td>'.$sub_code.'-'.$subject_name.'</td>
					<td align="center">'.$subject_type.'</td>
					<td align="left">'.$slot.'</td>
					<td>'.$facname.'</td>
					<td align="center">'.$totPersent.'</td>
					<td align="center">'.$totAbsent.'</td>
					<td align="center">'.$tot_students.'</td>
					<td align="center">'.$att_percentage.'%</td>
				  </tr>';
				  $i++;
				}
				
		}else{
			$html .='<tr>
				<td align="center" colspan=9>No Data Found</td>
			  </tr>';
		}

	}
		$email_id ='pramod.karole@sandipuniversity.edu.in';
		$subj ='Attendance Report';
		$this->send_leave_mail($email_id, $subj, $html);
		//$html .='</table><br><br>';
		unset($school_code);
		unset($stream_id);
		unset($semester);
		unset($html);
		}
		//echo $html;
		//echo "<pre>";
		//print_r($data);
	}
// mailing function
public function send_leave_mail($addres,$sub,$body){
	 $this->load->library('smtp');
	 $this->load->library('phpmailer');
	 $mail = new PHPMailer;

	//$mail->isSMTP();                            // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                     // Enable SMTP authentication
	$mail->Username = 'developers@sandipuniversity.com';          // SMTP username
	$mail->Password = 'university@24'; // SMTP password
	$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                          // TCP port to connect to

	$mail->setFrom('admindept@sandipuniversity.edu.in', 'Admin Department');
	$mail->addAddress($addres);

	//$mail->addReplyTo('admindept@sandipuniversity.in', 'Admin Department');
	$mail->addCC('balasaheb.lengare@carrottech.in');
	$mail->isHTML(true);  // Set email format to HTML
	$mail->Subject = $sub;
	 //$body .= "<span style='color:red;'>Note:This is an autogenerated mail,Please dont reply for this mail.</span>";

	$mail->Body    = $body;

		if(!$mail->send()) {
			return $mail->ErrorInfo;
		}else{
			return '1';
		}
	}	
	function load_tt_streams() {
        if (isset($_POST["course_id"]) && !empty($_POST["course_id"])) {
            //Get all city data
            $stream = $this->Timetable_model->load_tt_streams($_POST["course_id"], $_POST["academic_year"]);
            
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

     function downloadpdf()
    {
    	/*ini_set('display_errors', 1); 
    	ini_set('display_startup_errors', 1);
    	 error_reporting(E_ALL);*/
		$role_id = $this->session->userdata('role_id');
		$this->data['academic_year']= $this->Timetable_model->fetch_Curracademic_session(); 		
       // $this->data['tt_details']=$this->Timetable_model->get_tt_details();     	                                        
        //$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id='');	
      //print_r($this->data['course_details']);
     
		$this->data['school_details']= $this->Timetable_model->getSchools();
		if($role_id !='' && $role_id==3){
			$this->data['emp_sem']= $this->Timetable_model->getemp_sem();
			$this->data['emp_div']= $this->Timetable_model->getemp_div();
		}

		//$this->data['ttsub'] = array();
		
		$course_id = $_POST['course_id'];
		
		$this->data['courseId']=$_POST['course_id'];
		$this->data['division']=$_POST['division'];
		$this->data['semesterNo']=$_POST['semester'];
		$this->data['streamId']=$_POST['stream_id'];
		$this->data['academicyear']=$_POST['academic_year'];
		$this->data['faculty_id']=$_POST['faculty_id'];

		if($_POST){
		$this->data['slot_time']= $this->Timetable_model->getSlots($_POST);
		}
		$slots=$this->data['slot_time'];
		$wday = array('Monday','Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		
		if(isset($course_id) && $course_id==3){ // for M.TECH Sunday is added
		array_push($wday, "Sunday");
		}
		
		$this->data['wday'] = $wday;
		if(!empty($_POST)){
			for($i=0;$i<count($wday);$i++){
				$this->data['ttsub'][]= $this->Timetable_model->fetchTimeTable($slots,$wday[$i],$_POST);
            }
		}
		
		//$this->data['tt']= $this->Timetable_model->fetchTimeTable();		


		$this->load->library('M_pdf');
 		$mpdf=new mPDF('utf-8','A4', 0, '', 20, 20, 10, 10, 9, 9, 'L');

       	$html=$this->load->view($this->view_dir.'getpdfdata',$this->data,true);
       	$pdfFilePath ="timetable_report-".time()."-download.pdf";
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath, "D");
        //$mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/uploads/payment/' . $pdfFilePath . '.pdf', 'F');
                      
    }

public function facultyviewtable($tt_id=''){
    		/*ini_set('display_errors', 1); 
    	ini_set('display_startup_errors', 1);
    	 error_reporting(E_ALL);*/
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$this->load->model('Test_Attendance');
		$this->load->model('Test_model');
		$curr_session= $this->Test_Attendance->getCurrentSession();
		$this->load->model('Subject_model');  
		$this->load->view('header',$this->data); 
		$academic_year_one= $this->Test_model->fetch_Curracademic_session();
		$academic_year= $academic_year_one[0]['academic_year'].'~'.$academic_year_one[0]['academic_session'];
		$this->data['sb']= $this->Test_Attendance->getFacultySubjects_for_markattendance_new($emp_id, $curr_session[0]['academic_session'], $curr_session[0]['academic_year']);
				
       // $this->data['tt_details']=$this->Test_model->get_tt_details();

      /* $uId=$this->session->userdata('uid');
		if($uId=='2')
		{
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
			die;
		}  */      	                                        
        $this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['school_details']= $this->Test_model->getSchools();
		if($role_id !='' && $role_id==3){
			$this->data['emp_sem']= $this->Test_model->getemp_sem();
			$this->data['emp_div']= $this->Test_model->getemp_div();
		}
		$this->data['ttsub'] = array();
		

		//$this->data['sub_details'] = $_POST['subject'];
	
		//$this->data['academicyear']=$_POST['academic_year'];
		$this->data['slot_time']= $this->Test_model->getSlots_indivi_faculty($academic_year);
		/* $uId=$this->session->userdata('uid');
		if($uId=='2')
		{
			echo "<pre>";
			print_r($this->data['slot_time']);
			echo "</pre>";
			die;
		}   
		*/
		$course_id=explode('-',$_POST['subject']);

		$slots=$this->data['slot_time'];
		$wday = array('Monday','Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		
		if(isset($course_id[0]) && $course_id[0]==3){ // for M.TECH Sunday is added
		array_push($wday, "Sunday");
		}
		
		$this->data['wday'] = $wday;
		//if(!empty($_POST)){
			for($i=0;$i<count($wday);$i++){
				$this->data['ttsub'][]= $this->Test_model->fetchTimeTable_individiual($slots,$wday[$i],$academic_year);
            }
	//	}

		//$this->data['tt']= $this->Test_model->fetchTimeTable();		
        $this->load->view($this->view_dir.'faculty_view_timetable',$this->data);
        $this->load->view('footer');
	}

    public function facultyviewtable_old($tt_id=''){
    		/*ini_set('display_errors', 1); 
    	ini_set('display_startup_errors', 1);
    	 error_reporting(E_ALL);*/
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$this->load->model('Attendance_model');
		$curr_session= $this->Attendance_model->getCurrentSession();
		$this->load->model('Subject_model');  
		$this->load->view('header',$this->data); 
		$this->data['academic_year']= $this->Timetable_model->fetch_Curracademic_session();
		 
			$this->data['sb']= $this->Attendance_model->getFacultySubjects_for_markattendance_new($emp_id, $curr_session[0]['academic_session'], $curr_session[0]['academic_year']);
				
        //$this->data['tt_details']=$this->Timetable_model->get_tt_details();

      /* $uId=$this->session->userdata('uid');
		if($uId=='2')
		{
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
			die;
		}  */      	                                        
        $this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['school_details']= $this->Timetable_model->getSchools();
		if($role_id !='' && $role_id==3){
			$this->data['emp_sem']= $this->Timetable_model->getemp_sem();
			$this->data['emp_div']= $this->Timetable_model->getemp_div();
		}
		$this->data['ttsub'] = array();
		

		$this->data['sub_details'] = $_POST['subject'];
	
		$this->data['academicyear']=$_POST['academic_year'];
		$this->data['slot_time']= $this->Timetable_model->getSlots_indivi_faculty($_POST);
		/* $uId=$this->session->userdata('uid');
		if($uId=='2')
		{
			echo "<pre>";
			print_r($this->data['slot_time']);
			echo "</pre>";
			die;
		}   
		*/
		$course_id=explode('-',$_POST['subject']);

		$slots=$this->data['slot_time'];
		$wday = array('Monday','Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		
		if(isset($course_id[0]) && $course_id[0]==3){ // for M.TECH Sunday is added
		array_push($wday, "Sunday");
		}
		
		$this->data['wday'] = $wday;
		if(!empty($_POST)){
			for($i=0;$i<count($wday);$i++){
				$this->data['ttsub'][]= $this->Timetable_model->fetchTimeTable_individiual($slots,$wday[$i],$_POST);
            }
		}

		//$this->data['tt']= $this->Timetable_model->fetchTimeTable();		
        $this->load->view($this->view_dir.'faculty_view_timetable',$this->data);
        $this->load->view('footer');
	}
	
	
	
	
function downloadpdffaculty()
    {
    	
		/*ini_set('display_errors', 1); 
    	ini_set('display_startup_errors', 1);
    	 error_reporting(E_ALL);*/
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$this->load->model('Test_Attendance');
		$this->load->model('Test_model');
		$curr_session= $this->Test_Attendance->getCurrentSession();
		$this->load->model('Subject_model');  
		//$this->load->view('header',$this->data); 
		$academic_year_one= $this->Test_model->fetch_Curracademic_session();
		$academic_year= $academic_year_one[0]['academic_year'].'~'.$academic_year_one[0]['academic_session'];
		$this->data['sb']= $this->Test_Attendance->getFacultySubjects_for_markattendance_new($emp_id, $curr_session[0]['academic_session'], $curr_session[0]['academic_year']);
				
				
		$this->data['curr_session']=$curr_session;
        //$this->data['tt_details']=$this->Test_model->get_tt_details();

      /* $uId=$this->session->userdata('uid');
		if($uId=='2')
		{
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
			die;
		}  */      	                                        
        $this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['school_details']= $this->Test_model->getSchools();
		if($role_id !='' && $role_id==3){
			$this->data['emp_sem']= $this->Test_model->getemp_sem();
			$this->data['emp_div']= $this->Test_model->getemp_div();
		}
		$this->data['ttsub'] = array();
		

		//$this->data['sub_details'] = $_POST['subject'];
	
		//$this->data['academicyear']=$_POST['academic_year'];
		$this->data['slot_time']= $this->Test_model->getSlots_indivi_faculty($academic_year);
		/* $uId=$this->session->userdata('uid');
		if($uId=='2')
		{
			echo "<pre>";
			print_r($this->data['slot_time']);
			echo "</pre>";
			die;
		}   
		*/
		$course_id=explode('-',$_POST['subject']);

		$slots=$this->data['slot_time'];
		$wday = array('Monday','Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		
		if(isset($course_id[0]) && $course_id[0]==3){ // for M.TECH Sunday is added
		array_push($wday, "Sunday");
		}
		
		$this->data['wday'] = $wday;
		//if(!empty($_POST)){
			for($i=0;$i<count($wday);$i++){
				$this->data['ttsub'][]= $this->Test_model->fetchTimeTable_individiual($slots,$wday[$i],$academic_year);
            }
	//	}

		///////////////////////////////////////////////////////////////////////////////////
		$this->load->library('M_pdf');
 		$mpdf=new mPDF('utf-8','A4', 0, '', 10, 10, 10, 10, 10, 10, 'L');
       	$html=$this->load->view($this->view_dir.'Timetable_pdf',$this->data,true);
       	$pdfFilePath ="timetable_report-".time()."-download.pdf";
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath, "D");
        //$mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/uploads/payment/' . $pdfFilePath . '.pdf', 'F');
                      
    }
	function downloadpdffaculty_old()
    {
    	/*ini_set('display_errors', 1); 
    	ini_set('display_startup_errors', 1);
    	 error_reporting(E_ALL);*/
		$role_id = $this->session->userdata('role_id');
		$this->data['academic_year']= $this->Timetable_model->fetch_Curracademic_session(); 		
       // $this->data['tt_details']=$this->Timetable_model->get_tt_details();     	                                        
        //$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id='');	
      //print_r($this->data['course_details']);
     
		$this->data['school_details']= $this->Timetable_model->getSchools();
		if($role_id !='' && $role_id==3){
			$this->data['emp_sem']= $this->Timetable_model->getemp_sem();
			$this->data['emp_div']= $this->Timetable_model->getemp_div();
		}

		//$this->data['ttsub'] = array();
		
		$course_id=explode('-',$_POST['subject']);
		
		$this->data['courseId']=$_POST['course_id'];
		$this->data['division']=$_POST['division'];
		$this->data['semesterNo']=$_POST['semester'];
		$this->data['streamId']=$_POST['stream_id'];
		$this->data['academicyear']=$_POST['academic_year'];
		$this->data['slot_time']= $this->Timetable_model->getSlots_indivi_faculty($_POST);
		$slots=$this->data['slot_time'];
		$wday = array('Monday','Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		$this->data['course_id']=$course_id[0];
		
		if(isset($course_id[0]) && $course_id[0]==3){ // for M.TECH Sunday is added
		array_push($wday, "Sunday");
		}
		
		$this->data['wday'] = $wday;
		if(!empty($_POST)){
			for($i=0;$i<count($wday);$i++){
				$this->data['ttsub'][]= $this->Timetable_model->fetchTimeTable_individiual($slots,$wday[$i],$_POST);
            }
		}
		
		//$this->data['tt']= $this->Timetable_model->fetchTimeTable();		


		$this->load->library('M_pdf');
 		$mpdf=new mPDF('utf-8','A4', 0, '', 20, 20, 10, 10, 9, 9, 'L');
       	$html=$this->load->view($this->view_dir.'getpdfdataforfaculty',$this->data,true);
       	$pdfFilePath ="timetable_report-".time()."-download.pdf";
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath, "D");
        //$mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/uploads/payment/' . $pdfFilePath . '.pdf', 'F');
                      
    }
	////////////////////////////////////
	public function viewTtable_faculty_old($tt_id=''){
		$role_id = $this->session->userdata('role_id');
		$this->load->model('Subject_model');  
		$this->load->view('header',$this->data);
        //$this->data['tt_details']=$this->Timetable_model->get_tt_details();

       $uId=$this->session->userdata('name');

	 //  echo "<pre>";
	 //  print_r($uId);exit;
	   	                                        

		if($role_id !='' && $role_id==3){
			$this->data['emp_sem']= $this->Timetable_model->getemp_sem();
			$this->data['emp_div']= $this->Timetable_model->getemp_div();
		}
		$this->data['ttsub'] = array();
		$this->data['slot_time']= $this->Timetable_model->getSlots_faculty($uId);
	//	$a = $this->data['slot_time'];
		// i want to store maxmum index of array $a
	//	foreach($a as $key => $value){
	//		$index[] = $key;
	//	}
	//	$index = max($index);
	//	for($i=0;$i<=$index;$i++){
	//		if($a[$i]['from_time'] == $a[$i++]['from_time']){
	//			print_r($a[$i]['from_time']);
	//		}
	//		if($a[$i]['to_time'] == $a[$i++]['to_time']){
	//			print_r($a[$i]['to_time']);
	//		}
	//	}
	//	 echo'<pre>';
	//	 print_r($this->data['slot_time']);exit;

		$slots=$this->data['slot_time'];
		$wday = array('Monday','Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
		
		$this->data['wday'] = $wday;

			for($i=0;$i<count($wday);$i++){
				$this->data['ttsub'][]= $this->Timetable_model->fetchTimeTable_faculty($slots,$wday[$i],$uId);
            }
		//	echo'<pre>';
		//	print_r($this->data['ttsub']);exit;

		//$this->data['tt']= $this->Timetable_model->fetchTimeTable();		
        $this->load->view($this->view_dir.'view_timetable_f',$this->data);
        $this->load->view('footer');
	}





	function downloadFacultypdf()
	{
		$role_id = $this->session->userdata('role_id');
		$this->load->model('Subject_model');  
	
		$uId = $this->session->userdata('name');
	
		if ($role_id != '' && $role_id == 3) {
			$this->data['emp_sem'] = $this->Timetable_model->getemp_sem();
			$this->data['emp_div'] = $this->Timetable_model->getemp_div();
		}
		$this->data['ttsub'] = array();
		$this->data['slot_time'] = $this->Timetable_model->getSlots_faculty($uId);
	
		$slots = $this->data['slot_time'];
		$wday = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
		
		$this->data['wday'] = $wday;
	
		for ($i = 0; $i < count($wday); $i++) {
			$this->data['ttsub'][] = $this->Timetable_model->fetchTimeTable_faculty($slots, $wday[$i], $uId);
		}
	
		$this->load->library('M_pdf');
		$mpdf = new mPDF('utf-8', 'A4', 0, 'L', 2, 2, 35, 5, 0, 2, 'L');
	
		// Define header content
		$headerHTML = '
		<table style="width: 100%; border: none; font-size: 12px;">
		   <tr>
			   <td style="width: 20%; text-align: center;">
				   <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 90px; height: auto;">
			   </td>
			   <td style="width: 60%; text-align: center;">
				   <div style="font-size: 20px; font-weight: bold;">Sandip University</div>
				   <div>Mahiravani, Trimbak Road, Nashik - 422 213</div>
				   <div style="font-size: 14px; font-weight: bold;" >Faculty: Prof. ' . $this->session->userdata('emp_name') . '</div>
			   </td>
			   <td style="width: 20%; text-align: center;">
				   <div style="font-size: 14px; font-weight: bold;">Lecture Time Table</div>
			   </td>
		   </tr>
		</table>';
	
		// Define footer content with page number and current date-time
		$footerHTML = '
		<table style="width: 100%; font-size: 10px; border-top: 1px solid #000;">
			<tr>
				<td style="text-align: left;">Generated on: ' . date("Y-m-d H:i:s") . '</td>
				<td style="text-align: right;">Page {PAGENO} of {nbpg}</td>
			</tr>
		</table>';
	
		$mpdf->SetHTMLHeader($headerHTML); // Set header
		$mpdf->SetHTMLFooter($footerHTML); // Set footer
	
		$html = $this->load->view($this->view_dir . 'getFacultypdfdata', $this->data, true);
		$pdfFilePath = "timetable_report-" . time() . "-download.pdf";
		
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$mpdf->WriteHTML($html);
		$mpdf->Output($pdfFilePath, "I");
	}
	public function add_new_vap_subject_title()
   {
	   $chek=$this->Timetable_model->insert_vap_subject_title($_POST);
	   return $chek;
   }
   
  // load subject type
	public function load_subject_type_title(){
		$subject_id = $_POST['subject'];
		$subtype= $this->Timetable_model->load_subject_type_title($subject_id);

		 $rowCount = count($subtype);
			//Display cities list
			if($subtype[0]['subject_title'] !=''){
				echo '<option value="">Select Subject Title</option>';

					foreach($subtype as $value){

						echo '<option value="'.$value['tid'].'">'.$value['subject_title'].'</option>';
					}
			} else{
				echo '<option value="">Select Subject Title</option>';
			}
	}
	
		function load_ttdivisionMutliselect(){
	
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
	
			$stream = $this->Timetable_model->load_ttdivision($_POST["stream_id"], $_POST["academic_year"], $_POST["semester"]);
            
			$rowCount = count($stream);

			if($rowCount > 0){
				echo '<option value="">Select Division</option>';
				echo '<option value="all">All</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['division'] . '">' . $value['division'] . '</option>';
				}
			} else{
				echo '<option value="">Division not available</option>';
			}
		}
	}
	public function studTimeTable($tt_id = '')
	{
		$this->load->model('Timetable_model');
		$this->load->view('header', $this->data);

		$stud_enroll_no = $this->session->userdata("name");
		
		// You may fetch student info like course_id, stream_id, semester, etc.
		$studentData = $this->Timetable_model->getStudentDetails($stud_enroll_no);

		if (!$studentData) {
			$this->data['error'] = 'Student data not found.';
			$this->load->view('student/timetable_view', $this->data);
			return;
		}
		//echo '<pre>';print_r($studentData[0]);//exit;
		$filters = [
			'stream_id' => $studentData[0]->admission_stream,
			'semester'  => $studentData[0]->current_semester,
			'division'  => $studentData[0]->division,
			'course_short_name'  => $studentData[0]->course_short_name,
			'stream_name'  => $studentData[0]->stream_name,
		];
		$this->data['filters']=$filters;
		// Fetch all lecture slots (time periods)
		$this->data['slots'] = $this->Timetable_model->getLectureSlots($filters);

		// Get timetable data grouped by weekday and slot
		$this->data['timetable'] = $this->Timetable_model->getStudentTimetableGrouped($filters);

		$this->load->view($this->view_dir.'view_timetable', $this->data);
		$this->load->view('footer');
	}
		public function weekly_timetable_11() {
		//echo 1;exit;
		$DB1 = $this->load->database('umsdb', TRUE); 
        /* $course_id  = $this->input->get('course_id');
        $stream_id  = $this->input->get('stream_id');
        $semester   = $this->input->get('semester');
        $division   = $this->input->get('division'); */
		
		$course_id  = 2;
        $stream_id  = 5;
        $semester   = 3;
        $division   = 'A';

        // 1. Get all slots (10AM–5PM range or full master)
        $slots = $DB1->where('is_active', 'Y')
                          ->order_by('from_time', 'asc')
                          ->get('lecture_slot_test')
                          ->result_array();
		//print_r($slots);exit;
        // 2. Get timetable data for given course/stream/sem/div
        $DB1->select("lt.*, ls.from_time, ls.to_time");
        $DB1->from("lecture_time_table lt");
        $DB1->join("lecture_slot_test ls", "ls.lect_slot_id = lt.lecture_slot", "left");
        $DB1->where([
            "lt.course_id"  => $course_id,
            "lt.stream_id"  => $stream_id,
            "lt.semester"   => $semester,
            "lt.division"   => $division,
            "lt.is_active"  => 'Y',
            "lt.academic_year"  => '2025-26',
            "lt.academic_session"  => 'WIN'
        ]);
        $records = $DB1->get()->result_array();

        // 3. Re-arrange data as [day][slot] = lecture info
        $timetable = [];
        foreach ($records as $row) {
            $day = $row['wday'];   // e.g., Monday, Tuesday
            $slot = $row['lecture_slot'];

            $timetable[$day][$slot] = [
                'subject_code'  => $row['subject_code'],
                'subject_type'  => $row['subject_type'],
                'faculty_code'  => $row['faculty_code'],
                'room_no'       => $row['room_no']
            ];
        }

        $data['slots'] = $slots;
        $data['timetable'] = $timetable;
        $this->load->view("Timetable/weekly_timetable_view", $data);
    }
	public function weekly_timetable13() {
		$DB1 = $this->load->database('umsdb', TRUE); 
        $course_id  = 2;
        $stream_id  = 5;
        $semester   = 3;
        $division   = 'A';

        // Step 1: Define fixed hourly slots (10AM–5PM)
        $hours = [
            ['start' => '10:00:00', 'end' => '11:00:00'],
            ['start' => '11:00:00', 'end' => '12:00:00'],
            ['start' => '12:00:00', 'end' => '13:00:00'],
            ['start' => '13:00:00', 'end' => '14:00:00'],
            ['start' => '14:00:00', 'end' => '15:00:00'],
            ['start' => '15:00:00', 'end' => '16:00:00'],
            ['start' => '16:00:00', 'end' => '17:00:00'],
        ];

        // Step 2: Get timetable data for given course/stream/sem/div
        $DB1->select("lt.*, ls.from_time, ls.to_time,s.subject_name");
        $DB1->from("lecture_time_table lt");
        $DB1->join("lecture_slot ls", "ls.lect_slot_id = lt.lecture_slot", "left");
        $DB1->join("subject_master s", "s.sub_id = lt.subject_code", "left");
        $DB1->where([
            "lt.course_id"  => $course_id,
            "lt.stream_id"  => $stream_id,
            "lt.semester"   => $semester,
            "lt.division"   => $division,
            "lt.is_active"  => 'Y',
            "lt.academic_year"  => '2025-26',
            "lt.academic_session"  => 'WIN'
        ]);
        $records = $DB1->get()->result_array();

        // Step 3: Arrange timetable into [day][hour_slot]
        $timetable = [];
        foreach ($records as $row) {
            $day = $row['wday'];
            $lecStart = $row['from_time'];
            $lecEnd   = $row['to_time'];

            foreach ($hours as $i => $h) {
                if (!isset($timetable[$day][$i])) {
                    $timetable[$day][$i] = null;
                }
                // Check overlap: if slot hour lies within lecture
                if ($lecStart < $h['end'] && $lecEnd > $h['start']) {
                    $timetable[$day][$i] = [
                        'subject_code'  => $row['subject_name'],
                        'subject_type'  => $row['subject_type'],
                        'faculty_code'  => $row['faculty_code'],
                        'room_no'       => $row['room_no']
                    ];
                }
            }
        }

        $data['hours'] = $hours;
        $data['timetable'] = $timetable;
        $this->load->view("Timetable/weekly_timetable_view", $data);
    }
public function weekly_timetable2() {
       $DB1 = $this->load->database('umsdb', TRUE); 
        $course_id  = 2;
        $stream_id  = 5;
        $semester   = 3;
        $division   = 'A';
        // Fixed hourly slots
        $hours = [
            ['start' => '10:00:00', 'end' => '11:00:00'],
            ['start' => '11:00:00', 'end' => '12:00:00'],
            ['start' => '12:00:00', 'end' => '13:00:00'],
            ['start' => '13:00:00', 'end' => '14:00:00'],
            ['start' => '14:00:00', 'end' => '15:00:00'],
            ['start' => '15:00:00', 'end' => '16:00:00'],
            ['start' => '16:00:00', 'end' => '17:00:00'],
        ];

        // Fetch lectures for given course/stream/sem/div
        $DB1->select("lt.*, ls.from_time, ls.to_time,s.subject_name");
        $DB1->from("lecture_time_table lt");
        $DB1->join("lecture_slot ls", "ls.lect_slot_id = lt.lecture_slot", "left");
		$DB1->join("subject_master s", "s.sub_id = lt.subject_code", "left");
        $DB1->where([
            "lt.course_id"  => $course_id,
            "lt.stream_id"  => $stream_id,
            "lt.semester"   => $semester,
            "lt.division"   => $division,
            "lt.is_active"  => 'Y',
            "lt.academic_year"  => '2025-26',
            "lt.academic_session"  => 'WIN'
        ]);
        $records = $DB1->get()->result_array();

        // Arrange timetable: [day][hour_slot] = array of lectures
        // Arrange timetable: [day][hour_slot] = array of lectures
$timetable = [];
foreach ($records as $row) {
    $day = $row['wday'];
    $lecStart = strtotime($row['from_time']); // lecture start time

    foreach ($hours as $i => $h) {
        $slotStart = strtotime($h['start']);
        $slotEnd   = strtotime($h['end']);

        // Assign lecture to the slot where its start time falls
        if ($lecStart >= $slotStart && $lecStart < $slotEnd) {
            if (!isset($timetable[$day][$i])) {
                $timetable[$day][$i] = [];
            }

            // Avoid duplicate lecture
            $lectureInfo = $row['subject_code']."|".$row['faculty_code']."|".$row['room_no'];
            $exists = array_filter($timetable[$day][$i], function($l) use ($lectureInfo) {
                return $l['subject_code']."|".$l['faculty_code']."|".$l['room_no'] == $lectureInfo;
            });

            if (empty($exists)) {
                $timetable[$day][$i][] = [
                    'subject_code'  => $row['subject_code'],
                    'subject_type'  => $row['subject_type'],
                    'faculty_code'  => $row['faculty_code'],
                    'room_no'       => $row['room_no']
                ];
            }
            break; // stop checking other slots
        }
    }
}


        $data['hours'] = $hours;
        $data['timetable'] = $timetable;
        $this->load->view("Timetable/weekly_timetable_view", $data);
    }
	public function weekly_timetable() {

		$this->load->model('Subject_model');
		$data['course_details']= $this->Subject_model->getCollegeCourse($college_id);
		$data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
		if($_POST){
			$DB1 = $this->load->database('umsdb', TRUE); 
			$course_id  = $_POST['course_id'];
			$stream_id  = $_POST['stream_id'];
			$semester   = $_POST['semester'];
			$division   =  $_POST['division'];
			$data['courseId'] = $_POST['course_id'];
			$data['streamId'] = $_POST['stream_id'];
			$data['semesterNo'] = $_POST['semester'];
			$data['division'] = $_POST['division'];
			if(!empty($_POST['academic_year'])){
				$data['academicyear'] =$_POST['academic_year'];
				$acd_yr = explode('~',$_POST['academic_year']);
				if($acd_yr[1]=='WINTER'){
					$cur_ses="WIN";
				}else{
					$cur_ses="SUM";
				}
				$academicyear =$acd_yr[0];
			}else{
				$academicyear =ACADEMIC_YEAR;
				$cur_ses =CURRENT_SESS;
				if($cur_ses=='WIN'){
					$data['academicyear'] =ACADEMIC_YEAR.'~WINTER';
				}else{
					$data['academicyear'] =ACADEMIC_YEAR.'~SUMMER';
				}
			}
			// Fixed hourly slots
			$hours = [
			['start' => '08:00:00', 'end' => '09:00:00'],
				['start' => '09:00:00', 'end' => '10:00:00'],
				['start' => '10:00:00', 'end' => '11:00:00'],
				['start' => '11:00:00', 'end' => '12:00:00'],
				['start' => '12:00:00', 'end' => '13:00:00'],
				['start' => '13:00:00', 'end' => '14:00:00'],
				['start' => '14:00:00', 'end' => '15:00:00'],
				['start' => '15:00:00', 'end' => '16:00:00'],
				['start' => '16:00:00', 'end' => '17:00:00'],
				['start' => '17:00:00', 'end' => '18:00:00'],
				['start' => '18:00:00', 'end' => '19:00:00'],
			];

			// Fetch lectures
			$DB1->select("lt.*, ls.from_time, ls.to_time, s.subject_code as subcode,s.subject_name, em.fname,em.lname,sd.stream_name,sd.course_short_name");
			$DB1->from("lecture_time_table lt");
			$DB1->join("lecture_slot ls", "ls.lect_slot_id = lt.lecture_slot", "left");
			$DB1->join("subject_master s", "s.sub_id = lt.subject_code", "left");
			$DB1->join("vw_faculty em", "em.emp_id = lt.faculty_code", "left");
			$DB1->join("vw_stream_details sd", "sd.stream_id = lt.stream_id", "left");
			$DB1->where([
				"lt.course_id"      => $course_id,
				"lt.stream_id"      => $stream_id,
				"lt.semester"       => $semester,
				"lt.division"       => $division,
				"lt.is_active"      => 'Y',
				"lt.academic_year"  => $academicyear,
				"lt.academic_session" => $cur_ses
			]);
			$records = $DB1->get()->result_array();
			$data['courseName'] =$records[0]['course_short_name'];
			$data['streamName'] =$records[0]['stream_name'];
			//echo $DB1->last_query();
			//echo '<pre>';print_r($records);exit;
			// Arrange timetable: [day][hour_slot] = array of lectures
			$timetable = [];
			// for single lecture slots
			/* foreach ($records as $row) {
				$day = $row['wday'];
				$lecStart = strtotime($row['from_time']);

				foreach ($hours as $i => $h) {
					$slotStart = strtotime($h['start']);
					$slotEnd   = strtotime($h['end']);

					if ($lecStart >= $slotStart && $lecStart < $slotEnd) {
						if (!isset($timetable[$day][$i])) $timetable[$day][$i] = [];
							 $row['faculty_name']=$row['fname'].' '.$row['lname'];
						$lectureInfo = $row['subject_code']."|".$row['faculty_code']."|".$row['room_no']."|".$row['faculty_name'];
						$exists = array_filter($timetable[$day][$i], function($l) use ($lectureInfo) {
							return $l['subject_code']."|".$l['faculty_code']."|".$l['room_no']."|".$l['faculty_name'] == $lectureInfo;
						});

						if (empty($exists)) {
							$timetable[$day][$i][] = [
								'subject_code'  => $row['subject_name'],
								'subcode'  => $row['subcode'],
								'subject_type'  => $row['subject_type'],
								'faculty_code'  => $row['faculty_code'],
								'faculty_name'  => $row['faculty_name'],
								'division'  => $row['division'],
								'batch_no'  => $row['batch_no'],
								'floor_no'  => $row['floor_no'],
								'buliding_name'  => $row['buliding_name'],
								'from_time'  => $row['from_time'],
								'to_time'  => $row['to_time'],
								'room_no'       => $row['room_no']
							];
						}
						break;
					}
				}
			} */
			// for overlap lecture slots
			foreach ($records as $row) {
				$day = $row['wday'];
				$lecStart = strtotime($row['from_time']);
				$hour = substr($row['to_time'], 0, 2);
				// Rebuild the time as hour only
				$cleanTime = $hour . ":00:00";
				
				$lecEnd   = strtotime($cleanTime);
				

				foreach ($hours as $i => $h) {
					$slotStart = strtotime($h['start']);
					$slotEnd   = strtotime($h['end']);

					// ✅ Check overlap: lecture intersects with this slot
					if ($lecStart < $slotEnd && $lecEnd > $slotStart) {
						if (!isset($timetable[$day][$i])) {
							$timetable[$day][$i] = [];
						}

						$row['faculty_name'] = $row['fname'].' '.$row['lname'];
						$lectureInfo = $row['subject_code']."|".$row['faculty_code']."|".$row['room_no']."|".$row['faculty_name'];

						$exists = array_filter($timetable[$day][$i], function($l) use ($lectureInfo) {
							return $l['subject_code']."|".$l['faculty_code']."|".$l['room_no']."|".$l['faculty_name'] == $lectureInfo;
						});

						if (empty($exists)) {
							$timetable[$day][$i][] = [
								'subject_code'  => $row['subject_name'],
								'subcode'       => $row['subcode'],
								'subject_type'  => $row['subject_type'],
								'faculty_code'  => $row['faculty_code'],
								'faculty_name'  => $row['faculty_name'],
								'division'      => $row['division'],
								'batch_no'      => $row['batch_no'],
								'floor_no'      => $row['floor_no'],
								'buliding_name' => $row['buliding_name'],
								'from_time'     => $row['from_time'],
								'to_time'       => $row['to_time'],
								'course_short_name'       => $row['course_short_name'],
								'stream_name'       => $row['stream_name'],
								'semester'       => $row['semester'],
								'room_no'       => $row['room_no']
							];
						}
					}
				}
			}
			///loop end
			$colors = ["#FFCDD2","#C8E6C9","#BBDEFB","#FFE0B2","#D1C4E9","#FFF9C4","#B2DFDB","#F0F4C3","#F8BBD0"];
        $data['colors'] = $colors;

        $data['hours'] = $hours;
        $data['timetable'] = $timetable;
			// ✅ If user clicks PDF download
			if ($this->input->post('download_pdf')) {
				$html = $this->load->view("Timetable/weekly_timetable_pdf", $data, true);
				//$this->load->library('M_pdf');  // Or load manually if not auto-loaded
				//$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L']); // Landscape
				$this->load->library('M_pdf');
				$mpdf = new mPDF('utf-8', 'A2-L', 0, 'L', 2, 2, 10, 5, 0, 2, 'L');
				$mpdf->WriteHTML($html);
				$mpdf->Output("Weekly_Timetable.pdf", "D");
				exit;
			}
		}
        // Color palette for lectures
        
		$this->load->view('header',$this->data); 
        $this->load->view("Timetable/weekly_timetable_view", $data);
		$this->load->view('footer');
	
    }
public function viewTtable() {

		$this->load->model('Subject_model');
		//$data['course_details']= $this->Subject_model->getCollegeCourse($college_id);
		$data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
		if($_POST){
			if($_POST["campus"]==3){
				$DB1 = $this->load->database('sfumsdb', TRUE); 
			}elseif($_POST["campus"]==2){
				$DB1 = $this->load->database('sjumsdb', TRUE); 
			}else{
				$DB1 = $this->load->database('umsdb', TRUE); 
			}
		
			$faculty_id  = $_POST['faculty_id'];
			//$faculty_id  = 110145;
			/* $course_id  = $_POST['course_id'];
			$stream_id  = $_POST['stream_id'];
			$semester   = $_POST['semester'];
			$division   =  $_POST['division'];
			$data['courseId'] = $_POST['course_id'];
			$data['streamId'] = $_POST['stream_id'];
			$data['semesterNo'] = $_POST['semester'];
			$data['division'] = $_POST['division']; */
			$data['courseId'] = $_POST['course_id'];//exit;

			$data['faculty_id'] =$_POST['faculty_id'];
			if(!empty($_POST['academic_year'])){
				$data['academicyear'] =$_POST['academic_year'];
				$acd_yr = explode('~',$_POST['academic_year']);
				if($acd_yr[1]=='WINTER'){
					$cur_ses="WIN";
				}else{
					$cur_ses="SUM";
				}
				$academicyear =$acd_yr[0];
			}else{
				$academicyear =ACADEMIC_YEAR;
				$cur_ses =CURRENT_SESS;
				if($cur_ses=='WIN'){
					$data['academicyear'] =ACADEMIC_YEAR.'~WINTER';
				}else{
					$data['academicyear'] =ACADEMIC_YEAR.'~SUMMER';
				}
			}
			//print_r($data);exit;
			// Fixed hourly slots
			$hours = [
			['start' => '08:00:00', 'end' => '09:00:00'],
				['start' => '09:00:00', 'end' => '10:00:00'],
				['start' => '10:00:00', 'end' => '11:00:00'],
				['start' => '11:00:00', 'end' => '12:00:00'],
				['start' => '12:00:00', 'end' => '13:00:00'],
				['start' => '13:00:00', 'end' => '14:00:00'],
				['start' => '14:00:00', 'end' => '15:00:00'],
				['start' => '15:00:00', 'end' => '16:00:00'],
				['start' => '16:00:00', 'end' => '17:00:00'],
				['start' => '17:00:00', 'end' => '18:00:00'],
				['start' => '18:00:00', 'end' => '19:00:00'],
			];

			// Fetch lectures
			$DB1->select("lt.*, ls.from_time, ls.to_time, s.subject_code as subcode,s.subject_name, em.fname,em.lname,sd.stream_name,sd.course_short_name");
			$DB1->from("lecture_time_table lt");
			$DB1->join("lecture_slot ls", "ls.lect_slot_id = lt.lecture_slot", "left");
			$DB1->join("subject_master s", "s.sub_id = lt.subject_code", "left");
			$DB1->join("vw_faculty em", "em.emp_id = lt.faculty_code", "left");
			$DB1->join("vw_stream_details sd", "sd.stream_id = lt.stream_id", "left");
			$DB1->where([
				"lt.faculty_code"      => $faculty_id,
				"lt.is_active"      => 'Y',
				"lt.academic_year"  => $academicyear,
				"lt.academic_session" => $cur_ses
			]);
			$records = $DB1->get()->result_array();
			$data['courseName'] =$records[0]['course_short_name'];
			$data['streamName'] =$records[0]['stream_name'];
			$data['faculty_name'] =$records[0]['fname'].' '.$records[0]['lname'];
			$data['faculty_id'] =$records[0]['faculty_code'];
			//echo $DB1->last_query();
			//echo '<pre>';print_r($records);exit;
			// Arrange timetable: [day][hour_slot] = array of lectures
			$timetable = [];

			// for overlap lecture slots
			foreach ($records as $row) {
				$day = $row['wday'];
				$lecStart = strtotime($row['from_time']);
				$hour = substr($row['to_time'], 0, 2);
				// Rebuild the time as hour only
				$cleanTime = $hour . ":00:00";
				
				$lecEnd   = strtotime($cleanTime);
				

				foreach ($hours as $i => $h) {
					$slotStart = strtotime($h['start']);
					$slotEnd   = strtotime($h['end']);

					// ✅ Check overlap: lecture intersects with this slot
					if ($lecStart < $slotEnd && $lecEnd > $slotStart) {
						if (!isset($timetable[$day][$i])) {
							$timetable[$day][$i] = [];
						}

						$row['faculty_name'] = $row['fname'].' '.$row['lname'];
						$lectureInfo = $row['subject_code']."|".$row['faculty_code']."|".$row['room_no']."|".$row['faculty_name'];

						$exists = array_filter($timetable[$day][$i], function($l) use ($lectureInfo) {
							return $l['subject_code']."|".$l['faculty_code']."|".$l['room_no']."|".$l['faculty_name'] == $lectureInfo;
						});

						if (empty($exists)) {
							$timetable[$day][$i][] = [
								'subject_code'  => $row['subject_name'],
								'subcode'       => $row['subcode'],
								'subject_type'  => $row['subject_type'],
								'faculty_code'  => $row['faculty_code'],
								'faculty_name'  => $row['faculty_name'],
								'division'      => $row['division'],
								'batch_no'      => $row['batch_no'],
								'floor_no'      => $row['floor_no'],
								'buliding_name' => $row['buliding_name'],
								'from_time'     => $row['from_time'],
								'to_time'       => $row['to_time'],
								'course_short_name'       => $row['course_short_name'],
								'stream_name'       => $row['stream_name'],
								'semester'       => $row['semester'],
								'room_no'       => $row['room_no']
							];
						}
					}
				}
			}
			///loop end
			$colors = ["#FFCDD2","#C8E6C9","#BBDEFB","#FFE0B2","#D1C4E9","#FFF9C4","#B2DFDB","#F0F4C3","#F8BBD0"];
        $data['colors'] = $colors;

        $data['hours'] = $hours;
        $data['timetable'] = $timetable;
			// ✅ If user clicks PDF download
			if ($this->input->post('download_pdf')) {
				$html = $this->load->view("Timetable/weekly_timetable_pdf", $data, true);
				//$this->load->library('M_pdf');  // Or load manually if not auto-loaded
				//$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L']); // Landscape
				$this->load->library('M_pdf');
				$mpdf = new mPDF('utf-8', 'A2-L', 0, 'L', 2, 2, 10, 5, 0, 2, 'L');
				$mpdf->WriteHTML($html);
				$mpdf->Output("Weekly_Timetable.pdf", "D");
				exit;
			}
		}
        // Color palette for lectures
        
		$this->load->view('header',$this->data); 
        $this->load->view("Timetable/weekly_timetable_view_faculty", $data);
		$this->load->view('footer');
	
    }
	
	public function viewTtable_faculty() {

		$this->load->model('Subject_model');
		//if($_POST){
			$DB1 = $this->load->database('umsdb', TRUE); 
			$faculty_id  = $this->session->userdata('name');
			$data['courseId'] = $_POST['course_id'];//exit;
			
			if(!empty($_POST['academic_year'])){
				$data['academicyear'] =$_POST['academic_year'];
				$acd_yr = explode('~',$_POST['academic_year']);
				if($acd_yr[1]=='WINTER'){
					$cur_ses="WIN";
				}else{
					$cur_ses="SUM";
				}
				$academicyear =$acd_yr[0];
			}else{

				$academicyear =ACADEMIC_YEAR;
				$cur_ses =CURRENT_SESS;
				if($cur_ses=='WIN'){
					$data['academicyear'] =ACADEMIC_YEAR.'~WINTER';
				}else{
					$data['academicyear'] =ACADEMIC_YEAR.'~SUMMER';
				}
			}
			
			$data['faculty_id'] =$_POST['faculty_id'];

			//print_r($data);exit;
			// Fixed hourly slots
			$hours = [
				['start' => '08:00:00', 'end' => '09:00:00'],
				['start' => '09:00:00', 'end' => '10:00:00'],
				['start' => '10:00:00', 'end' => '11:00:00'],
				['start' => '11:00:00', 'end' => '12:00:00'],
				['start' => '12:00:00', 'end' => '13:00:00'],
				['start' => '13:00:00', 'end' => '14:00:00'],
				['start' => '14:00:00', 'end' => '15:00:00'],
				['start' => '15:00:00', 'end' => '16:00:00'],
				['start' => '16:00:00', 'end' => '17:00:00'],
				['start' => '17:00:00', 'end' => '18:00:00'],
				['start' => '18:00:00', 'end' => '19:00:00'],
			];

			// Fetch lectures
			$DB1->select("lt.*, ls.from_time, ls.to_time, s.subject_code as subcode,s.subject_name, em.fname,em.lname,sd.stream_name,sd.course_short_name");
			$DB1->from("lecture_time_table lt");
			$DB1->join("lecture_slot ls", "ls.lect_slot_id = lt.lecture_slot", "left");
			$DB1->join("subject_master s", "s.sub_id = lt.subject_code", "left");
			$DB1->join("vw_faculty em", "em.emp_id = lt.faculty_code", "left");
			$DB1->join("vw_stream_details sd", "sd.stream_id = lt.stream_id", "left");
			$DB1->where([
				"lt.faculty_code"      => $faculty_id,
				"lt.is_active"      => 'Y',
				"lt.academic_year"  => $academicyear,
				"lt.academic_session" => $cur_ses
			]);
			$records = $DB1->get()->result_array();
			$data['courseName'] =$records[0]['course_short_name'];
			$data['streamName'] =$records[0]['stream_name'];
			$data['faculty_name'] =$records[0]['fname'].' '.$records[0]['lname'];
			$data['faculty_id'] =$records[0]['faculty_code'];
			//echo $DB1->last_query();
			//echo '<pre>';print_r($records);exit;
			// Arrange timetable: [day][hour_slot] = array of lectures
			$timetable = [];

			// for overlap lecture slots
			foreach ($records as $row) {
				$day = $row['wday'];
				$lecStart = strtotime($row['from_time']);
				$hour = substr($row['to_time'], 0, 2);
				// Rebuild the time as hour only
				$cleanTime = $hour . ":00:00";
				
				$lecEnd   = strtotime($cleanTime);
				

				foreach ($hours as $i => $h) {
					$slotStart = strtotime($h['start']);
					$slotEnd   = strtotime($h['end']);

					// ✅ Check overlap: lecture intersects with this slot
					if ($lecStart < $slotEnd && $lecEnd > $slotStart) {
						if (!isset($timetable[$day][$i])) {
							$timetable[$day][$i] = [];
						}

						$row['faculty_name'] = $row['fname'].' '.$row['lname'];
						$lectureInfo = $row['subject_code']."|".$row['faculty_code']."|".$row['room_no']."|".$row['faculty_name'];

						$exists = array_filter($timetable[$day][$i], function($l) use ($lectureInfo) {
							return $l['subject_code']."|".$l['faculty_code']."|".$l['room_no']."|".$l['faculty_name'] == $lectureInfo;
						});

						if (empty($exists)) {
							$timetable[$day][$i][] = [
								'subject_code'  => $row['subject_name'],
								'subcode'       => $row['subcode'],
								'subject_type'  => $row['subject_type'],
								'faculty_code'  => $row['faculty_code'],
								'faculty_name'  => $row['faculty_name'],
								'division'      => $row['division'],
								'batch_no'      => $row['batch_no'],
								'floor_no'      => $row['floor_no'],
								'buliding_name' => $row['buliding_name'],
								'from_time'     => $row['from_time'],
								'to_time'       => $row['to_time'],
								'course_short_name'       => $row['course_short_name'],
								'stream_name'       => $row['stream_name'],
								'semester'       => $row['semester'],
								'room_no'       => $row['room_no']
							];
						}
					}
				}
			}
			///loop end
			$colors = ["#FFCDD2","#C8E6C9","#BBDEFB","#FFE0B2","#D1C4E9","#FFF9C4","#B2DFDB","#F0F4C3","#F8BBD0"];
        $data['colors'] = $colors;

        $data['hours'] = $hours;
        $data['timetable'] = $timetable;
			// ✅ If user clicks PDF download
			if ($this->input->post('download_pdf')) {
				$html = $this->load->view("Timetable/weekly_timetable_pdf", $data, true);
				//$this->load->library('M_pdf');  // Or load manually if not auto-loaded
				//$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L']); // Landscape
				$this->load->library('M_pdf');
				$mpdf = new mPDF('utf-8', 'A2-L', 0, 'L', 2, 2, 10, 5, 0, 2, 'L');
				$mpdf->WriteHTML($html);
				$mpdf->Output("Weekly_Timetable.pdf", "D");
				exit;
			}
		//}
        // Color palette for lectures
        
		$this->load->view('header',$this->data); 
        $this->load->view("Timetable/weekly_timetable_view_faculty", $data);
		$this->load->view('footer');
	
    }
	
}
?>