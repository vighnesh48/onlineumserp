<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Test extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="subject_master";
    var $model_name="Test_model";
    var $model;
    var $view_dir='Test/';
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
        
       /* $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
        
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);*/
    }	
    //view
    public function index()
    {
		//error_reporting(E_ALL);
		$this->load->model('Subject_model');
        $this->load->view('header',$this->data);        
        $this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['school_details']= $this->Test_model->getSchools();
		$this->data['slot']= $this->Test_model->getSlots_old();
		$this->data['academic_year']= $this->Test_model->fetch_Allacademic_session(); 
		$this->data['batches']= $this->Test_model->fetch_subject_batches();
		if(!empty($this->session->userdata('Tcourse_id'))){
			
			$course_id = $this->session->userdata('Tcourse_id');
			$stream_id = $this->session->userdata('Tstream_id');
			$sem = $this->session->userdata('Tsemester');
			$division = $this->session->userdata('Tdivision');
			$academicyear = $this->session->userdata('Tacdyr');

			$this->data['Tfaculty'] = $this->session->userdata('Tfaculty');
			$this->data['Tsub_type'] = $this->session->userdata('Tsub_type');
			$this->data['Tbatch_no'] = $this->session->userdata('Tsub_type');
			$this->data['Tsubject'] = $this->session->userdata('Tsubject');
			$this->data['Tacdyr'] = $this->session->userdata('Tacdyr');

			$this->data['courseId'] = $course_id;
			$this->data['streamId'] = $stream_id;
			$this->data['semesterNo'] = $sem;
			$this->data['division'] = $division;
			$this->data['academicyear'] =$academicyear;

			
			$this->data['tt_details']=$this->Test_model->get_tt_details($sub_id='',$course_id,$stream_id,$sem, $division, $academicyear);       	                                        
		}		
        $this->load->view($this->view_dir.'add_timetable',$this->data);
        $this->load->view('footer');
    }
	public function ttlist()
    {
		$Tarray_items = array('Tfaculty','Tsub_type','Tsub_type','Tcourse_id','Tstream_id','Tsemester','Tdivision','Tsubject');
        $this->session->unset_userdata($Tarray_items);
		
		$this->load->model('Subject_model');
        $this->load->view('header',$this->data); 
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);
		$this->data['academic_year']= $this->Test_model->fetch_Allacademic_session();
		
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
			
			$this->data['tt_details']=$this->Test_model->get_tt_details($sub_id='',$course_id,$stream_id,$sem, $division, $academicyear);       	                                        
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
			
			$this->data['tt_details']=$this->Test_model->get_tt_details($sub_id='',$course_id,$stream_id,$sem, $division, $academicyear);
		}			
        //$this->data['tt_details']=$this->Test_model->get_tt_details();       	                                        
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    // load streams
	public function load_streams()
	{
    	global $model;	    
	    $this->data['campus_details']= $this->Test_model->get_course_streams($_POST);     	    
	}
	
    // load subject
	public function load_subject(){
		$streamId = $_POST['streamId'];
		$course_id = $_POST['course'];
		$semesterId = $_POST['semesterId'];
		$batch = $_POST['batch'];
		$this->data['emp']= $this->Test_model->load_subject($course_id, $streamId, $semesterId,$batch);
	}
    // load subject type
	public function load_subject_type(){
		$subject_id = $_POST['subject'];
		$subtype= $this->Test_model->load_subject_type($subject_id);
		$rowCount = count($subtype);
			//Display cities list
			if($rowCount > 0){
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
		$this->data['emp']= $this->Test_model->load_department($school_id);
	}	
    // load Faculty
	public function load_faculty(){
		$school_id = $_POST['school_id'];
		$dept_id = $_POST['dept_id'];
		$faculty_type = $_POST['faculty_type'];
		
		if($faculty_type=='per'){
			$this->data['emp']= $this->Test_model->load_faculty($school_id, $dept_id);
		}else{
			$this->data['emp']= $this->Test_model->load_temp_faculty($school_id, $dept_id);
		}
	}	
	// insert to timetable
	public function insert_timetable(){
		// duplicate entry check in timetable
		$chk_duplicate = $this->Test_model->checkDuplicateTt($_POST);
		//$chk_duplicate1 = $this->Test_model->checkDuplicateLectSloat($_POST);
		//$chk_duplicate2 = $this->Test_model->checkDuplicateLect($_POST);
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
		if(count($chk_duplicate) > 0){
			$this->session->set_flashdata('dup_msg', 'This subject is already assigned in Timetable');
			redirect(base_url($this->view_dir));
		}else{
			$last_inserted_id = $this->Test_model->insert_timetable($_POST);
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
		$this->load->model('Subject_model');  
		$this->load->view('header',$this->data);   
		$this->data['batches']= $this->Test_model->fetch_subject_batches();
		$this->data['academic_year']= $this->Test_model->fetch_Allacademic_session(); 		
        $this->data['ttdet']=$this->Test_model->get_tt_details($tt_id);     
		$this->data['f_name']=$this->Test_model->get_faculty_name($this->data['ttdet'][0]['faculty_code']);
		$this->data['faculty_list']=$this->Test_model->get_faculty_list();
        $this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['school_details']= $this->Test_model->getSchools();
		$this->data['slot']= $this->Test_model->getSlots_old();		
        $this->load->view($this->view_dir.'add_timetable',$this->data);
        $this->load->view('footer');
	}
	// Update Time table
	public function update_timetable(){
		$last_inserted_id = $this->Test_model->update_timetable($_POST);
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
	public function viewTtable($tt_id=''){
		$role_id = $this->session->userdata('role_id');
		$this->load->model('Subject_model');  
		$this->load->view('header',$this->data); 
		$this->data['academic_year']= $this->Test_model->fetch_Curracademic_session(); 		
        $this->data['tt_details']=$this->Test_model->get_tt_details();

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
		
		$course_id = $_POST['course_id'];

		$this->data['courseId']=$_POST['course_id'];
		$this->data['division']=$_POST['division'];
		$this->data['semesterNo']=$_POST['semester'];
		$this->data['streamId']=$_POST['stream_id'];
		$this->data['academicyear']=$_POST['academic_year'];
		$this->data['slot_time']= $this->Test_model->getSlots($_POST);
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
				$this->data['ttsub'][]= $this->Test_model->fetchTimeTable($slots,$wday[$i],$_POST);
            }
		}

		//$this->data['tt']= $this->Test_model->fetchTimeTable();		
        $this->load->view($this->view_dir.'view_timetable',$this->data);
        $this->load->view('footer');
	}
	public function studTimeTable($tt_id=''){
		//error_reporting(E_ALL); ini_set('display_errors', '1');
		$stud_enroll_no = $this->session->userdata("name");
		$this->load->model('Subject_model');  
		$this->load->view('header',$this->data);        
        $this->data['tt_details']=$this->Test_model->get_tt_details();      	                                               
		$this->data['school_details']= $this->Test_model->getSchools();
		$stud_det= $this->Test_model->fetch_stud_details($stud_enroll_no);
		$acdyr= $this->Test_model->fetch_Curracademic_session();
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
		$this->data['slot_time']= $this->Test_model->getSlotsforStud($var);
		$slots=$this->data['slot_time'];
		$wday = array('Monday','Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		$this->data['wday'] = $wday;

		for($i=0;$i<count($wday);$i++){
			$this->data['ttsub'][]= $this->Test_model->fetchTimeTable($slots,$wday[$i],$var);
		}
		//print_r($this->data['ttsub']);
		//$this->data['tt']= $this->Test_model->fetchTimeTable();		
        $this->load->view($this->view_dir.'view_timetable',$this->data);
        $this->load->view('footer');
	}
	// aaded on 20/09/17
	public function removeTimetableEntry($tt_id)
	{
        $this->load->view('header',$this->data); 
		if($this->Test_model->removeTimetableEntry($tt_id))
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
			$stream = $this->Test_model->load_ttcources($_POST["academic_year"]);
            
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
			$stream = $this->Test_model->load_ttsemesters($_POST["stream_id"], $_POST["academic_year"]);
            
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
			$stream = $this->Test_model->load_ttdivision($_POST["stream_id"], $_POST["academic_year"], $_POST["semester"]);
            
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
	//faculty allocation
	public function assign_faculty($streamId='', $semester='', $division='',$academic_year, $course_id)
    {
		//error_reporting(E_ALL); ini_set('display_errors', '1'); 
		$this->load->model('Subject_model');
        $this->load->view('header',$this->data); 
		$this->data['course_details']= $this->Subject_model->getCollegeCourse();
		$this->data['academic_year']= $this->Test_model->fetch_Allacademic_session(); 
		if($_POST['course_id'] !=''){
			$course_id = $_POST['course_id'];
			$stream_id = $_POST['stream_id'];
			$sem = $_POST['semester'];
			$division = $_POST['division'];
			
			$this->data['courseId'] = $_POST['course_id'];
			$this->data['streamId'] = $_POST['stream_id'];
			$this->data['semesterNo'] = $_POST['semester'];
			$this->data['academicyear'] = $_POST['academic_year'];
			$this->data['division'] = $division;
			
			$this->data['tt_details']=$this->Test_model->get_tt_subdetails($sub_id='',$course_id,$stream_id,$sem, $division,$_POST['academic_year']);
			$this->data['class_faculty_list']=$this->Test_model->get_class_faculty_list($stream_id,$sem, $division,$_POST['academic_year']);  
			$i=0;
			/*foreach ($this->data['tt_details'] as $value) {
			 	$this->data['tt_details'][$i]['facultyname']=$this->Test_model->fetch_faculty($stream_id,$sem, $division,$_POST['academic_year'],$value['subject_code']);
			 	$i++; 
			 } */
			     	                                        
		}elseif($streamId !=''){
			//echo "fddf";exit;
			$this->data['courseId'] = $course_id;
			$this->data['streamId'] = $streamId;
			$this->data['semesterNo'] = $semester;
			$this->data['division'] = $division;
			$this->data['academicyear'] = $academic_year;
			
			$this->data['tt_details']=$this->Test_model->get_tt_subdetails($sub_id='',$course_id,$streamId,$semester, $division,$academic_year);
			$this->data['class_faculty_list']=$this->Test_model->get_class_faculty_list($streamId,$semester, $division,$academic_year);  
			$i=0;
			/*foreach ($this->data['tt_details'] as $value) {

			 	$this->data['tt_details'][$i]['facultyname']=$this->Test_model->fetch_faculty($streamId,$semester, $division,$academic_year,$value['subject_code']);
			 	$i++; 
			 } */  
		}		
        //$this->data['tt_details']=$this->Test_model->get_tt_details();       	                                        
        $this->load->view($this->view_dir.'faculty_allocation_view',$this->data);
        $this->load->view('footer');
    }
    //add view
	public function add_subject_faculty($subject_id,$stream_id,$semester,$division,$batch,$course_id,$academicyear){
		$this->load->model('Subject_model');  
		$this->load->view('header',$this->data); 
		$this->data['academicyear']=$academicyear;
        $this->data['ttdet']=$this->Test_model->get_tt_details($tt_id);     
		$this->data['sub']=$this->Test_model->get_subdetails($subject_id,$stream_id,$semester,$division,$batch,$academicyear);
		$this->data['fac']=$this->Test_model->fetch_faculty($stream_id,$semester, $division,$academicyear,$subject_id);
		$this->data['faculty_list']=$this->Test_model->get_faculty_list(); 		
        $this->load->view($this->view_dir.'add_faculty_subject',$this->data);
        $this->load->view('footer');
	}

	// insert to timetable
	public function insert_subject_faculty(){
		//error_reporting(E_ALL); ini_set('display_errors', 1);	
		$chk_duplicate = $this->Test_model->checkDuplicate_faculty($_POST);

		if(count($chk_duplicate) > 0){			
			$this->Test_model->update_subject_faculty($_POST);
		}
		
		if($this->Test_model->insert_subject_faculty($_POST))
		{
			$this->Test_model->update_subject_faculty_intimetable($_POST);
			$this->session->set_flashdata('Tmessage', 'Faculty allocated successfully.');
			if(!empty($_POST['academic_session']) && $_POST['academic_session']=='WIN'){
				$ses = "WINTER";
			}else{
				$ses = "SUMMER";
			}
			redirect(base_url($this->view_dir.'assign_faculty/'.$_POST['stream_id'].'/'.$_POST['semester'].'/'.$_POST['division'].'/'.$_POST['academic_year'].'~'.$ses.'/'.$_POST['course_id']));
		}
		else
		{
			redirect(base_url($this->view_dir.'assign_faculty'));
		}
	}
	// Update class details
	public function update_class_details(){	     
		if($this->Test_model->update_class_details($_POST)){
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
		$academic= $this->Test_model->fetch_Curracademic_session(); 
		$academic_year =$academic[0]['academic_year'];
		$academic_session =$academic[0]['academic_session'];
		if($academic_session=='WINTER'){
			$ses= "WIN";
		}else{
			$ses= "SUM";
		}
		$html ='';
		$schools = $this->Test_model->fetch_schools($todaysdate,$day,$academic_year,$ses);
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
			$streams = $this->Test_model->fetch_streams($school_code,$day, $academic_year,$ses);
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
			$mdata = $this->Test_model->fetch_mailing_details($todaysdate,$day, $school_code, $stream_id,$semester, $division, $academic_year,$ses);
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
            $stream = $this->Test_model->load_tt_streams($_POST["course_id"], $_POST["academic_year"]);
            
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
		$this->data['academic_year']= $this->Test_model->fetch_Curracademic_session(); 		
        $this->data['tt_details']=$this->Test_model->get_tt_details();     	                                        
        //$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id='');	
      //print_r($this->data['course_details']);
     
		$this->data['school_details']= $this->Test_model->getSchools();
		if($role_id !='' && $role_id==3){
			$this->data['emp_sem']= $this->Test_model->getemp_sem();
			$this->data['emp_div']= $this->Test_model->getemp_div();
		}

		//$this->data['ttsub'] = array();
		
		$course_id = $_POST['course_id'];
		
		$this->data['courseId']=$_POST['course_id'];
		$this->data['division']=$_POST['division'];
		$this->data['semesterNo']=$_POST['semester'];
		$this->data['streamId']=$_POST['stream_id'];
		$this->data['academicyear']=$_POST['academic_year'];
		$this->data['slot_time']= $this->Test_model->getSlots($_POST);
		$slots=$this->data['slot_time'];
		$wday = array('Monday','Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		
		if(isset($course_id) && $course_id==3){ // for M.TECH Sunday is added
		array_push($wday, "Sunday");
		}
		
		$this->data['wday'] = $wday;
		if(!empty($_POST)){
			for($i=0;$i<count($wday);$i++){
				$this->data['ttsub'][]= $this->Test_model->fetchTimeTable($slots,$wday[$i],$_POST);
            }
		}
		
		//$this->data['tt']= $this->Test_model->fetchTimeTable();		


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
		$curr_session= $this->Test_Attendance->getCurrentSession();
		$this->load->model('Subject_model');  
		$this->load->view('header',$this->data); 
		$academic_year_one= $this->Test_model->fetch_Curracademic_session();
		$academic_year= $academic_year_one[0]['academic_year'].'~'.$academic_year_one[0]['academic_session'];
		$this->data['sb']= $this->Test_Attendance->getFacultySubjects_for_markattendance_new($emp_id, $curr_session[0]['academic_session'], $curr_session[0]['academic_year']);
				
        $this->data['tt_details']=$this->Test_model->get_tt_details();

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
	function downloadpdffaculty()
    {
    	
		/*ini_set('display_errors', 1); 
    	ini_set('display_startup_errors', 1);
    	 error_reporting(E_ALL);*/
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$this->load->model('Test_Attendance');
		$curr_session= $this->Test_Attendance->getCurrentSession();
		$this->load->model('Subject_model');  
		//$this->load->view('header',$this->data); 
		$academic_year_one= $this->Test_model->fetch_Curracademic_session();
		$academic_year= $academic_year_one[0]['academic_year'].'~'.$academic_year_one[0]['academic_session'];
		$this->data['sb']= $this->Test_Attendance->getFacultySubjects_for_markattendance_new($emp_id, $curr_session[0]['academic_session'], $curr_session[0]['academic_year']);
				
				
		$this->data['curr_session']=$curr_session;
        $this->data['tt_details']=$this->Test_model->get_tt_details();

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
	
	public function create_cia_marks(){
		exit();
		 $DB1 = $this->load->database('umsdb', TRUE);
		$sql1="SELECT stud_id,enrollment_no FROM student_master WHERE 
enrollment_no IN('190102081005','190105011003','190105011004','190105011005','190105011006','190105011007','190105011008','190105011009','190105011011','190105011012','190105011013','190105011014','190105011015','190105011016','190105011017','190105011018','190105011019','190105011020','190105011021','190105011022','190105011024','190105011025','190105011026','190105011027','190105011028','190105011029','190105011031','190105011032','190105011033','190105011034','190105011035','190105011036','190105011037','190105011038','190105011039','190105011040','190105011041','190105011042',
'190105011043','190105011046')";

  $query = $DB1->query($sql1);
 // $query=$DB1->query($sql);
	  $result=$query->result_array();
	  //print_r($result);
	
	foreach($result as $list){
		
		
$data['me_id']='34';
$data['stud_id']=$list['stud_id'];	
$data['enrollment_no']	=$list['enrollment_no'];
$data['stream_id']	='38';
$data['semester']='1';	
$data['exam_id']	='13';
$data['subject_id']='3405';
$data['exam_month']='DEC';
$data['exam_year']='2019';	
$data['is_deleted']	='N';
$DB1->insert("marks_entry_cia", $data);
		
		
	}
	
	}
	
	function insert_consession(){
		 $DB1 = $this->load->database('umsdb', TRUE);
		/* $sql1="SELECT ad.actual_fee as main_fees,td.* FROM `temp_add_list`  AS td
		 LEFT JOIN admission_details AS ad ON ad.student_id =td.student_id
		 WHERE STATUS IS NULL";*/
		 exit();
		 $sql="select * FROM admission_details where academic_year='2019' 
		 AND student_id in('4127','3699','3721','3732','3468','4692','3466','3617','4008','5244','3459','3460')";
		  $query = $DB1->query($sql);
   // $query=$DB1->query($sql);
	  $result=$query->result_array();
	//  print_r($result);
	//exit();
	foreach($result as $list){
		
$data['concession_type']='Schlorship';
$data['student_id']=$list['student_id'];
$data['enrollement_no']=$list['enrollment_no'];
$data['academic_year']='2019';
$data['actual_fees']=$list['actual_fee'];
$data['exepmted_fees']=0;
$data['fees_paid_required']=$list['actual_fee'];
$data['concession_remark']='';
$data['allowed_by']='Admin';
$data['created_by']='1';
$data['created_on']='';
$data['modified_by']='1';
$data['modified_on']='';
$data['remark']='by execel';
$DB1->insert("fees_consession_details", $data);

	}
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function Update_fee(){
		exit();
	$this->Test_model->Update_fee();
	}
	
	public function delete_record(){
		//$k=array(6531,6532);
		//exit();
		//$k='';
		$this->Test_model->delete_record($k);
	}
	
	 public function  Update_scholarship_check(){
	 // exit();
	  echo $this->Test_model->Update_scholarship('6449');
	  
  }
  
  function manually_register_student(){
	 echo  $stud_id='2953';
	  $data = $this->Test_model->fetch_payment_details_data($stud_id);
	  array_shift($data);
	  
	  print_r($data);
	  echo($data[0]['amount']);
	 // echo $data[0]['txtid'];
	  exit();
	    // $this->data["key"] =$_REQUEST['key'];
	    // $this->data["hash"] =$_REQUEST['hash'];
	     $this->data["txnid"] =$data[0]['txtid'];
	     $this->data["udf1"] = $data[0]['receipt_no'];
	   //  $this->data["udf2"] =$data[0]['udf2'];
	   //  $this->data["udf3"] =$data[0]['udf3'];
	     $this->data["udf4"] =$data[0]['phone'];
	   //  $this->data["udf5"] =$data[0]['udf5'];//utype//$_REQUEST['student_type'];
	     $this->data["firstname"] = $data[0]['firstname'];
	     $this->data["email"] =$data[0]['email'];
	     $this->data["productinfo"] =$data[0]['productinfo'];
	     $this->data["amount"] =$data[0]['amount'];
	     $this->data['addedon']=$data[0]['added_on'];
	     $this->data['status']=$data[0]['status'];
	     $this->data['error']=$data[0]['error'];
	     $this->data['PG_TYPE']=$data[0]['PG_TYPE'];
	     $this->data['mode']=$data[0]['mode'];
	     $this->data['bank_ref_num']=$data[0]['bank_ref_num'];
	     $this->data['error_Message']=$data[0]['error_Message'];
	  
	   $this->load->view('header',$this->data);                         
       $this->load->view('Online_fee/payment_success_manually',$this->data,true);
	   
       $this->load->view('Online_fee/thankyou',$this->data);
       $this->load->view('footer'); 
	  
  }
  
  
  
	function manually_sms(){
		
		
		$stud_id='2953';
		
		
	   $this->data['per'] = $this->Home_model->fetch_basic_details_from_student_master_all_details($stud_id);
		
		$this->data['course'] = $this->Home_model->fetch_course_list_data($stud_id);
		
		$this->data['qua'] = $this->Home_model->fetch_stud_qualifications($stud_id);
         
		$this->data['pay'] = $this->Home_model->fetch_payment_details_data($stud_id);
		
		
		print_r($this->data['per']);
		echo '<br>';echo '<br>';echo '<br>per';
		print_r($this->data['course']);
		echo '<br>';echo '<br>';echo '<br>course';
		print_r($this->data['qua']);
		echo '<br>';echo '<br>';echo '<br>qua';
		print_r($this->data['pay']);
		echo '<br>';
		
		
		     $info=$this->data['pay'];
		echo $txtid= $info[0]->txtid;echo '<br>';
		echo $Receipt= $info[0]->receipt_no;echo '<br>';
		echo $phone=$info[0]->phone;echo '<br>';
		echo $amount=$info[0]->amount;echo '<br>';
		echo $prn=$info[0]->registration_no;echo '<br>';
	    exit();
		
       //  $this->Home_model->update_online_admissiondetails($this->data);
		 //$this->Home_model->Update_scholarship($stud_id);
		 //echo "dd";
		 //exit;
		 //////////////////////////////////////////////////////////////////////
		$amount=$amount;
		$txnid= $txtid;
		$udf4= $Receipt;
		$udf3= $phone;
		
		  $user_mobile = $udf3;//$udf4//9545453488,9545453087,8850633088;
	   $sms_message=urlencode("Dear Student
Your payment of Rs $amount is duly received and tranction no -:$txnid. Your Receipt Number is $udf4 .Your Provisional PRN No is $prn.
Thanks
Sandip University");
 $sms=$sms_message;
 $ch = curl_init();
   
    $query="?username=u4282&msg_token=j8eAyq&sender_id=SCHOOL&message=$sms&mobile=$user_mobile";
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL,'http://103.255.100.77/api/send_transactional_sms.php' . $query); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $res = trim(curl_exec($ch));
    curl_close($ch);
	/////////////////////////////////////////////////////////////////////////
		
		
		
		 $this->load->view('admission/payment_success_manually',$this->data,true);
               
		// exit();
		// $this->load->view('admission/payment_success',$this->data,true); 
		$this->session->unset_userdata('student_id');
	    $this->load->view('admission/print_admission_form_view1_manually', $this->data,true);
        $this->load->view('admission/print_admission_form_view_provisional_form_manually', $this->data,true);
		
	     $this->load->view('admission/payu_success_manually',$this->data);
		}
  
  function success()
	{
	    
	    //$post[]="";
	//   var_dump($_REQUEST);
//	   exit();
//	   error_reporting(E_ALL);
  //  ini_set('display_errors', 1);
	    
	     
	     $this->data["key"] =$_REQUEST['key'];
	     $this->data["hash"] =$_REQUEST['hash'];
	     $this->data["txnid"] =$_REQUEST['txnid'];
	     $this->data["udf1"] = $_REQUEST['udf1'];
	     $this->data["udf2"] =$_REQUEST['udf2'];
	     $this->data["udf3"] =$_REQUEST['udf3'];
	     $this->data["udf4"] =$_REQUEST['udf4'];
	     $this->data["udf5"] =$_REQUEST['udf5'];//utype//$_REQUEST['student_type'];
		// $this->data["udf6"] =$_REQUEST['udf6'];
	     $this->data["firstname"] = $_REQUEST['firstname'];
	     $this->data["email"] =$_REQUEST['email'];
	     $this->data["productinfo"] =$_REQUEST['productinfo'];
	     $this->data["amount"] =$_REQUEST['amount'];
	     $this->data['addedon']=$_REQUEST['addedon'];
	     $this->data['status']=$_REQUEST['status'];
	     $this->data['error']=$_REQUEST['error'];
	     $this->data['PG_TYPE']=$_REQUEST['PG_TYPE'];
	     $this->data['mode']=$_REQUEST['mode'];
	     $this->data['bank_ref_num']=$_REQUEST['bank_ref_num'];
	     $this->data['error_Message']=$_REQUEST['error_Message'];
	     
	     
	     
	     
	     /*$this->data["key"] ="soe5Fh";//$_REQUEST['key'];
	      $this->data["hash"] ="soe5Fh45ere";//$_REQUEST['hash'];
	       $this->data["txnid"] ="soe5Fh343se";//$_REQUEST['txnid'];
	        $this->data["udf1"] ="soe5Fh343fdfd";//$receipt//$_REQUEST['udf1'];
	           $this->data["udf2"] ="2017";//academic year//$_REQUEST['udf2'];
	         $this->data["udf3"] ="170401001";//enrollment_no//$_REQUEST['udf3'];
	           $this->data["udf4"] ="2323232";//mobile//$_REQUEST['udf4'];
	            $this->data["udf5"] ="R";//utype//$_REQUEST['student_type'];
	             $this->data["firstname"] ="balasaheb";//$_REQUEST['firstname'];
	           $this->data["email"] ="test@gmail.com";//$_REQUEST['email'];
	            $this->data["productinfo"] ="2";//$_REQUEST['feetype'];
	             $this->data["amount"] ="1200";////$_REQUEST['amount'];
	             
	                $this->data['addedon']="HDFC";////$_REQUEST['addedon'];
	            $this->data['status']="HDFC";//$_REQUEST['status'];
	            $this->data['error']="HDFC";//$_REQUEST['error_code'];
	            $this->data['PG_TYPE']="HDFC";//$_REQUEST['PG_TYPE'];
	            $this->data['mode']="CC";//$_REQUEST['mode'];
	            $this->data['bank_ref_num']="wewe2322we2324";//$_REQUEST['bank_ref_num'];
	            $this->data['error_Message']="error";//$_REQUEST['error_Message']
	            */
	            

     
       $this->Online_feemodel->add_online_feedetails($this->data);
       //var_dump($this->Online_feemodel->getFeesdata());
       //$data['session_details']= $this->Online_feemodel->fetch_studentdata(); 
	    $user_mobile = $udf4;//$udf4//7030942420,8850633088,9545453488,9545453087;
	   $sms_message=urlencode("Dear Student
Your payment of Rs $amount is duly received and tranction no -:$txnid. Your Receipt Number is $udf1
Thanks
Sandip University");
 $ch = curl_init();
    $sms=$sms_message;
    $query="?username=u4282&msg_token=j8eAyq&sender_id=SANDIP&message=$sms&mobile=$user_mobile";
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL,'http://103.255.100.77/api/send_transactional_sms.php' . $query);  //http://103.255.100.77/api/send_transactional_sms.php
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $res = trim(curl_exec($ch));
    curl_close($ch);
	   
	   
	   
	   $this->load->view('header',$this->data);                         
       $this->load->view($this->view_dir.'payment_success',$this->data,true);
	   
       $this->load->view($this->view_dir.'thankyou',$this->data);
       $this->load->view('footer'); 
	   // redirect('Thankyou');   
	}
  function check_balanace(){
   $DB2 = $this->load->database('umsdb', TRUE);
			 $DB2->select("amount,student_id,registration_no,academic_year,productinfo,payment_status");
			 $DB2->from('online_payment');
			 $DB2->where("academic_year",'2020');
			 $DB2->where("student_id",'2016');
			 $DB2->where("productinfo",'Re-Registration');
			 $DB2->where("payment_status",'success');
			 $query2=$DB2->get();
			 $result2=$query2->row_array();
			 if($result2['amount']>3000){
			echo '<b style="color:#000000">Re-Registration Fee already Pay</b>';
			 }
  }
//////////////////////////////////////////////////////////////	


function create_login(){
		//error_reporting(E_ALL);
//ini_set('display_errors', 1);
		
		// $prn=$this->input->post('enrollment_no');
		
		$DB6 = $this->load->database('umsdb', TRUE);
		
		$DB6->select("sm.*,stm.stream_name,cm.course_name");
		$DB6->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left'); 
		$DB6->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB6->join('course_master as cm','cm.course_id = stm.course_id','left');
		$DB6->where("sm.cancelled_admission",'N');
		$DB6->where("sm.admission_session",'2021');	
		//$DB6->where("sm.admission_stream",'23');	
		$DB6->where("sm.academic_year",'2021');
		$DB6->where("sm.is_detained",'N');
		$DB6->where("sm.admission_confirm",'Y');
		//$DB6->where("sm.admission_cycle",'');
		//$DB6->where("sm.admission_cycle",'JAN-19');
		//$DB1->where("length(sm.enrollment_no)",'202101476011');
		$where=" sm.enrollment_no !='' AND (sm.admission_cycle is null OR sm.admission_cycle='')";
		 $DB6->where($where);
		//$DB1->order_by("sm.enrollment_no", "asc");
		//$DB6->limit(1, 0);
		$query=$DB6->get();
	     //echo $DB6->last_query();
		//exit(0);
		$dat=$query->result_array();
		echo count($dat);echo '<br>';
		//exit();
		  foreach($dat as $sdata)
         {
		echo $sdata['enrollment_no']; echo '<br>';
		echo $id=$this->Test_model->create_student_login_by_prn($sdata['enrollment_no']); echo '<br>';
		
	}
		
		
	}

 public function  Update_scholarship_All(){
	  //exit();
	  $DB6 = $this->load->database('umsdb', TRUE);
	    $sql = "SELECT ad.* FROM student_master AS sm
INNER JOIN admission_details AS ad ON ad.`student_id`=sm.`stud_id` WHERE ad.academic_year='2020' AND ad.year IN('1','2') AND 
sm.`cancelled_admission`='N' AND sm.`admission_confirm`='Y' AND ad.`cancelled_admission`='N' AND sm.`admission_session`='2020' AND sm.academic_year='2020'
AND ad.`stream_id` NOT IN ('116','71','194')
HAVING ad.actual_fee=ad.`applicable_fee`";

        $query = $DB6->query($sql);
		$dat=$query->result_array();
	    foreach($dat as $sdata)
    {
		echo $sdata['student_id'];
	//  echo $this->Home_model->Update_scholarship($sdata['student_id']);
	}
  }

	public function search_for_convocation(){
		$this->load->view('header',$this->data);        
		$this->load->view($this->view_dir.'search_for_convocation_entry',$this->data);
		$this->load->view('footer');
       
	}
	public function student_conv_entry_list(){	

		$this->load->model('Test_model');
		$prn=trim($_POST['prn']);
		$this->data['summary_list']= $this->Test_model->student_conv_entry_details($prn);
			
        $this->load->view($this->view_dir.'total_students_conv_data.php',$this->data);		
		
	}
	public function updatecanteenstatus($enrollment_no){	  
		$DB1 = $this->load->database('umsdb', TRUE);
		$dupdate['allow_for_canteen']='Y';
		$DB1->where('enrollment_no', $enrollment_no);
		$DB1->update('convocation_registration',$dupdate);
		//echo $DB1->last_query();exit;
		redirect('test/search_for_convocation/'.$enrollment_no);
	}
	public function updateconvcationstatus($enrollment_no){	  
		$DB1 = $this->load->database('umsdb', TRUE);
		$dupdate['allow_for_convocation_hall']='Y';
		$DB1->where('enrollment_no', $enrollment_no);
		$DB1->update('convocation_registration',$dupdate);
		//echo $DB1->last_query();exit;
		redirect('test/search_for_convocation/'.$enrollment_no);
	}
///////////////////////////////////////////////////////////////////////////////
}
?>