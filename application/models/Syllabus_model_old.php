<?php
class Syllabus_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$DB1 = $this->load->database('umsdb', TRUE);
	}
    
	
	// fetch subject details
	function  get_subject_details($sub_id='',$course_id,$stream_id,$sem,$regulation, $batch){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where=" WHERE sm.is_active='Y' ";  
        
		if($sub_id!=""){
			$where.=" AND sm.sub_id='".$sub_id."'";
		}
		if($course_id!=""){
			$where.=" AND sm.course_id='".$course_id."' AND sm.stream_id='".$stream_id."' AND sm.semester='".$sem."' and sm.regulation='$regulation' and sm.batch='$batch'";
		}
        
		$sql="SELECT sm.*,vw.stream_name,st.type_name FROM `subject_master` as sm left join vw_stream_details as vw on vw.stream_id= sm.stream_id  left join subject_type as st on st.sub_type_id= sm.subject_type $where order by sm.subject_order asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function update_syllabus($data){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$emp_id = $this->session->userdata("uid");
		//echo '<pre>';
	   // print_r($data);exit;
		$syllabus_id = $data['syllabus_id'];
		unset($data['topic_type']);
		$data['modified_by'] =$emp_id;
		$data['modified_on'] = date('Y-m-d H:i:s');
		$DB1->where('syllabus_id', $syllabus_id);		
		$DB1->update('subject_syllabus', $data);
		echo $DB1->last_query();exit;
		return true;
	}
	// fetch subject type
	function  get_sub_type(){
		$DB1 = $this->load->database('umsdb', TRUE);         
		$sql="SELECT * FROM `subject_type`";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// fetch subject type
	function  get_subject_component(){
		$DB1 = $this->load->database('umsdb', TRUE);         
		$sql="SELECT * FROM `subject_component_type` where is_active='Y'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// fetch stream
	function  get_stream(){
		$DB1 = $this->load->database('umsdb', TRUE);         
		$sql="SELECT * FROM `stream_master`";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function insert_subject($data){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$emp_id = $this->session->userdata("uid");		
		$data['created_by'] =$emp_id;
		$data['created_on'] = date('Y-m-d H:i:s');		
		$DB1->insert('subject_master', $data);
		//echo $DB1->last_query();exit;
		return true;
	}
	function getCollegeCourse($col_id = 1){
		$obj = New Consts();
		$curr_sess = $obj->fetchCurrSession();
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$empStreamid =$this->getFacultyStream($emp_id);	
		if($role_id==3){
			$sql = "SELECT distinct l.course_id, v.course_name,v.course_short_name  FROM `lecture_time_table` as l left join vw_stream_details as v on v.course_id=l.course_id WHERE l.`faculty_code` ='".$emp_id."'";
			if(!empty($empStreamid) && $empStreamid!='71'){
				$sql .=" AND l.academic_session='".$curr_sess."'";
			}
		}else{
			$sql = "SELECT DISTINCT(course_id),course_name,course_short_name FROM vw_stream_details";
			if(isset($_SESSION['role_id']) && $_SESSION['role_id']==10){
				$ex =explode("_",$_SESSION['name']);
				$sccode = $ex[1];
				$sql .=" where school_code = $sccode";
			}
		}
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	
	function get_course_streams(){
		$DB1 = $this->load->database('umsdb', TRUE);
		
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		if($role_id==3){
			$sql = "SELECT distinct l.stream_id, v.stream_name FROM `lecture_time_table` as l left join vw_stream_details as v on v.stream_id=l.stream_id WHERE l.`faculty_code` ='".$emp_id."' and v.course_id='" . $_POST['course'] . "'";
		}else{
			$sql = "select stream_id,stream_name from vw_stream_details where course_id='" . $_POST['course'] . "' ";
			if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND school_code = $sccode";
			}
		}
		//echo $sql;       
		$query = $DB1->query($sql);
		$stream_details = $query->result_array();


		echo '<select name="stream_id" class="form-control" id="stream_id" required>
		<option value="">Select Stream</option>';

		foreach($stream_details as $course){

			echo '<option value="' . $course['stream_id'] . '"' . $sel . '>' . $course['stream_name'] . '</option>';
		}
		echo '</select></div>';
	}
    
	function update_subject($data, $sub_id,$syllabus_uploaded){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$emp_id = $this->session->userdata("uid");
		//echo $syllabus_uploaded;
		if($syllabus_uploaded=='Y'){
			$data['syllabus_uploaded'] ='Y';
		}		
		
		$data['modify_by'] =$emp_id;
		$data['modifiy_on'] = date('Y-m-d H:i:s');
		$DB1->where('sub_id', $sub_id);		
		$DB1->update('subject_master', $data);
		//echo $DB1->last_query();exit;
		return true;
	}
	// check_dup_subject
	function  check_dup_subject($var){
		$subject_component = $var['subject_component'];
		$stream_id = $var['stream_id'];
		$subject_code = $var['subject_code'];
		$semester = $var['semester'];
		$regulation = $var['regulation'];
		$batch = $var['batch'];
        
		$DB1 = $this->load->database('umsdb', TRUE);         
		$sql="SELECT * FROM `subject_master` where is_active='Y' and stream_id='$stream_id' and subject_code = '$subject_code' and semester='$semester' and subject_component='$subject_component' and regulation='$regulation' and batch='$batch'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// fetch course details
	function  get_course_details($course_id){
		$DB1 = $this->load->database('umsdb', TRUE);         
		$sql="SELECT course_name,course_short_name,stream_name,stream_code FROM `vw_stream_details` where course_id='".$course_id."'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function  get_stream_details($stream_id){
		$DB1 = $this->load->database('umsdb', TRUE);         
		$sql="SELECT course_name,course_short_name,stream_name,stream_code FROM `vw_stream_details` where stream_id='".$stream_id."'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// fetch Faculty Stream
	function getFacultyStream($emp_id){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql = "SELECT distinct stream_id FROM `lecture_time_table` WHERE `faculty_code` = '".$emp_id."'";		
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res[0]['stream_id'];
	}  
	// remove Subject
	function removeSubject($sub_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$emp_id = $this->session->userdata("uid");
		$data['is_active'] ='N';		
		$data['modify_by'] =$emp_id;
		$data['modifiy_on'] = date('Y-m-d H:i:s'); 
		$DB1->where('sub_id', $sub_id);
		$DB1->update('subject_master', $data); 
		//echo $DB1->last_query();exit;
		return true;
	}   
	// fetch Faculty Stream
	function getRegulation(){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql = "SELECT distinct regulation FROM `subject_master` WHERE `is_active` = 'Y' order by regulation desc";		
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}
	function getRegulation1(){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql = "SELECT distinct batch FROM `subject_master` WHERE `is_active` = 'Y' order by batch desc";		
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}
	function getAcademicYear(){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql = "SELECT academic_year,start_month,last_month,session FROM `academic_year` order by academic_year desc";		
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}
	//	
	function  update_stream_mapping($var)
    {
    	$stream_id = $var['stream_id'];
		$batch = $var['batch'];
		$total_subject = $var['total_subject'];
		$semester = $var['semester'];
		$group_subject = $var['group_subject'];
		$elective = $var['elective'];
		$compulsary = $var['compulsary'];
        $DB1 = $this->load->database('umsdb', TRUE); 

        $chk_cnt = $this->chek_stream_mapping($var);
        if(count($chk_cnt) <=0){
        	$DB1->insert('stream_mapping', $var);
        }else{
        	$sql="UPDATE stream_mapping SET total_subject='$total_subject', group_subject='$group_subject', elective='$elective', compulsary='$compulsary' WHERE stream_id='".$stream_id."' AND semester='".$semester."' AND batch='".$batch."'";
        	$query = $DB1->query($sql);
        }        
		//echo $DB1->last_query();exit;
        return true;
    }
    function chek_stream_mapping($var)
    {
    	$stream_id = $var['stream_id'];
		$batch = $var['batch'];
		$total_subject = $var['total_subject'];
		$semester = $var['semester'];
		$group_subject = $var['group_subject'];
		$elective = $var['elective'];
        $DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT stream_map_id FROM stream_mapping WHERE stream_id='".$stream_id."' AND semester='".$semester."' AND batch='".$batch."'";
		
        $query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
    } 
    //fetch_stream_mapping   	
    function fetch_stream_mapping($stream_id, $semester, $batch)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT * FROM stream_mapping WHERE stream_id='".$stream_id."' AND semester='".$semester."' AND batch='".$batch."'";		
        $query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
    }  
    //
    function update_lock_subjects($var)
    {
    	$stream_id = $var['stream_id'];
		$batch = $var['batch'];
		$semester = $var['semester'];

        $DB1 = $this->load->database('umsdb', TRUE); 
        $sql="UPDATE subject_master SET is_final='Y' WHERE stream_id='".$stream_id."' AND semester='".$semester."' AND regulation='".$batch."'";
        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;
        return true;
    }
    function update_unlock_subjects($var)
    {
    	$stream_id = $var['stream_id'];
		$batch = $var['batch'];
		$semester = $var['semester'];

        $DB1 = $this->load->database('umsdb', TRUE); 
        $sql="UPDATE subject_master SET is_final='N' WHERE stream_id='".$stream_id."' AND semester='".$semester."' AND regulation='".$batch."'";
        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;
        return true;
    }
	// fetch Faculty Stream
	function getbatches(){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql = "SELECT distinct batch FROM `subject_master` WHERE `is_active` = 'Y'";		
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}
	
	function  get_subjects($course_id,$stream_id,$sem,$batch){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where=" WHERE sm.is_active='Y' ";  
        
		if($sub_id!=""){
			$where.=" AND sm.sub_id='".$sub_id."'";
		}
		if($course_id!=""){
			$where.=" AND sm.course_id='".$course_id."' AND sm.stream_id='".$stream_id."' AND sm.semester='".$sem."' and sm.batch='$batch'";
		}       
		$sql="SELECT sm.*,vw.stream_name,st.type_name FROM `subject_master` as sm left join vw_stream_details as vw on vw.stream_id= sm.stream_id  left join subject_type as st on st.sub_type_id= sm.subject_type $where order by sm.subject_order asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// check_dup_subject topics
	function  check_dup_subject_topic_no($var){
		$subject_id = $var['subject_id'];
		$topic_no = $var['topic_no'];
        $unit_no = $var['unit_no'];
        $subtopic_no = $var['subtopic_no'];
        $DB1 = $this->load->database('umsdb', TRUE);   
        if($subtopic_no=='0')
        {
        	$sql="SELECT * FROM `subject_syllabus` where is_active='Y' and subject_id='$subject_id' and topic_no = '$topic_no' and unit_no = '$unit_no' and subtopic_no = '0'";
        	$query = $DB1->query($sql);
			//echo $DB1->last_query();exit;
			$dd= $query->result_array();
			if(!empty($dd))
			{
				return 'topic';
			}

        }
        else
        {
        	$sql="SELECT * FROM `subject_syllabus` where is_active='Y' and subject_id='$subject_id' and topic_no = '$topic_no' and unit_no = '$unit_no' and subtopic_no = '$subtopic_no'";
        	$query = $DB1->query($sql);
			//echo $DB1->last_query();exit;
			$dd= $query->result_array();
			if(!empty($dd))
			{
				return 'subtopic';
			}
        }

		     	
	}

		//vikas  check_dup_subject topics at the time of updation
	function  check_dup_subject_topic_no_update($var){
		$subject_id = $var['subject_id'];
		$syllabus_id = $var['syllabus_id'];
		$topic_no = $var['topic_no'];
        $unit_no = $var['unit_no'];
        $subtopic_no = $var['subtopic_no'];
        $DB1 = $this->load->database('umsdb', TRUE);   
        if($subtopic_no=='0')
        {

        	$sql="SELECT * FROM `subject_syllabus` where is_active='Y' and subject_id='$subject_id' and topic_no = '$topic_no' and unit_no = '$unit_no' and subtopic_no = '0' and syllabus_id!='$syllabus_id' ";
        	$query = $DB1->query($sql);
			//echo $DB1->last_query();exit;
			$dd= $query->result_array();
			if(!empty($dd))
			{
				return 'topic';
			}

        }
        else
        {
        	$sql="SELECT * FROM `subject_syllabus` where is_active='Y' and subject_id='$subject_id' and topic_no = '$topic_no' and unit_no = '$unit_no' and subtopic_no = '$subtopic_no' and syllabus_id!='$syllabus_id'";
        	$query = $DB1->query($sql);
			//echo $DB1->last_query();exit;
			$dd= $query->result_array();
			if(!empty($dd))
			{
				return 'subtopic';
			}
        }

		     	
	}
	function insert_syllabus($data){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$uid = $this->session->userdata("uid");	
		unset($data['topic_type']);
		$data['created_by'] =$uid;
		$data['created_on'] = date('Y-m-d H:i:s');		
		$DB1->insert('subject_syllabus', $data);
		//echo $DB1->last_query();exit;
		return true;
	}
	// fetch subject details
	function  get_topic_details($subject_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where=" WHERE t.is_active='Y'";  
        
		if($subject_id!=""){
			$where.=" AND t.subject_id='".$subject_id."'";
		}        
		$sql="SELECT  distinct unit_no,t.topic_name,t.subject_id FROM `subject_syllabus` as t $where  group by t.unit_no order by t.unit_no asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	//get_uniquesubtopics
	function  get_uniquesubtopics($subject_id,$unit_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where=" WHERE t.is_active='Y' and topic_name is not null ";  
        
		if($subject_id!=""){
			$where.=" AND t.subject_id='".$subject_id."' AND t.unit_no='".$unit_id."'";
		}        
		$sql="SELECT  distinct t.topic_name,t.topic_no,syllabus_id FROM `subject_syllabus` as t $where  order by t.syllabus_id asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// fetch subject details
	function  fetch_subject_details($sub_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where=" WHERE sm.is_active='Y' ";  
        
		if($sub_id!=""){
			$where.=" AND sm.sub_id='".$sub_id."'";
		}
        
		$sql="SELECT sm.sub_id,sm.subject_code, sm.subject_name,sm.semester,sm.batch, vw.stream_name,vw.stream_short_name,st.type_name FROM `subject_master` as sm left join vw_stream_details as vw on vw.stream_id= sm.stream_id  left join subject_type as st on st.sub_type_id= sm.subject_type $where ";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	/********************** Sub topic starts**************************/
		// check_dup_subject topics
	function  check_dup_subject_subtopic_no($var){
		$subject_id = $var['subject_id'];
		$topic_no = $var['topic_id'];
        $sub_topic_no = $var['sub_topic_no'];
		$DB1 = $this->load->database('umsdb', TRUE);         
		$sql="SELECT * FROM `subject_subtopics` where is_active='Y' and subject_id='$subject_id' and topic_id = '$topic_no' and sub_topic_no='$sub_topic_no'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function insert_subject_subtopic($data){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$uid = $this->session->userdata("uid");		
		$data['created_by'] =$uid;
		$data['created_on'] = date('Y-m-d H:i:s');		
		$DB1->insert('subject_subtopics', $data);
		//echo $DB1->last_query();exit;
		return true;
	}
	// fetch subject details
	function  get_subtopic_details($subject_id, $unit_no, $topic_no){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where=" WHERE t.is_active='Y' and t.subtopic_no !=0";  
        
		if($subject_id!=""){
			$where.=" AND t.subject_id='".$subject_id."' and t.unit_no ='".$unit_no."' and t.topic_no ='".$topic_no."'";
		}        
		$sql="SELECT t.topic_no,t.unit_no,t.topic_contents,t.subject_id,t.subtopic_no,t.syllabus_id FROM `subject_syllabus` as t  $where order by t.topic_no asc,t.subtopic_no asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// get syllabus by id
	function  get_syllbus_by_id($syllabus_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where=" WHERE is_active='Y' AND syllabus_id='".$syllabus_id."'";  
		$sql="SELECT * FROM `subject_syllabus` $where ";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function  load_streams_student_list()
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
        
		$sql="SELECT vw.stream_id,vw.stream_name,vw.stream_short_name FROM subject_master s left join vw_stream_details vw on s.stream_id=vw.stream_id where s.batch='".$_POST['batch']."' and vw.course_id='".$_POST['course_id']."' ";
        
        if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND vw.school_code = $sccode";
			}
		$sql .=" group by s.stream_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $stream_details =  $query->result_array();  
    } 
	function load_semester_subjects()
    {
        $DB1 = $this->load->database('umsdb', TRUE);         
		$sql="SELECT s.semester FROM subject_master s  where s.batch='".$_POST['batch']."' and s.stream_id='".$_POST['stream_id']."' and s.is_active='Y' group by s.semester";
        
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $stream_details =  $query->result_array();  
    }
	
	function get_subdetails_for_faculty($course_id, $stream_id, $academic_year,$batch, $semester)
	{
		$DB1 = $this->load->database('umsdb', TRUE);         
		$sql="SELECT s.sub_id, s.subject_code,s.batch,s.semester,s.stream_id, s.subject_name,s.subject_component,s.credits,s.theory_max,s.internal_max FROM subject_master s 		
		where s.stream_id='".$stream_id."' and s.batch='".$batch."' and s.semester='".$semester."' group by s.sub_id order by s.semester, s.batch";
        
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $stream_details =  $query->result_array();
	}
	function get_division_from_timetable($course_id, $stream_id, $academic_year,$semester)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$academic_year = $academic_year;
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}        
		$sql="SELECT distinct division FROM lecture_time_table  		
		where stream_id='".$stream_id."' and academic_year='".$acd_yr[0]."' and academic_session='".$cur_ses."' and semester='".$semester."' order by division asc";
        
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $stream_details =  $query->result_array();
	}
	function getSubFacDetails($subjectid, $stream_id, $semester, $division)
	{
		$DB1 = $this->load->database('umsdb', TRUE);         
		$sql="SELECT t.subject_code,t.batch_no,t.division, t.semester, t.stream_id, t.faculty_code,f.fname,f.mname,f.lname,f.mobile_no,  vw.school_name, vw.stream_name FROM lecture_time_table t 		
		left join vw_faculty f on f.emp_id = t.faculty_code 
		left join vw_stream_details vw on vw.stream_id =t.stream_id  		
		where t.stream_id='".$stream_id."' and t.subject_code='".$subjectid."' AND t.division='$division' and t.semester='$semester'";
        
        $query = $DB1->query($sql);
		//echo $DB1->last_query();echo "<br>";exit;
		return $stream_details =  $query->result_array();
	}
	
	function sectionwise_strength($subject_id, $stream_id, $academic_year, $semester)
    {

        $DB1 = $this->load->database('umsdb', TRUE); 
		$acd_yr = explode('~',$academic_year);	
        $sql="SELECT b.division,count(a.stud_id) as stud_cnt FROM `student_applied_subject` a left join student_batch_allocation b on b.student_id =a.stud_id AND a.stream_id=b.stream_id AND a.semester=b.semester and a.academic_year=b.academic_year where a.academic_year='".$acd_yr[0]."' and a.semester='".$semester."' and a.subject_id='$subject_id'";
		
		if($semester=='1' || $semester=='2'){
	        if($stream_id ==9){
				$sql.=" AND a.stream_id in(5,6,7,8,9,10,11,96,97)";	
			}else if($stream_id ==103 || $stream_id ==104){
				$sql.=" AND a.stream_id in(43,44,45,46,47)";
			}else{
				$sql.=" AND a.stream_id='".$stream_id."'";
			}
		}else{
			$sql.=" AND a.stream_id='".$stream_id."'";
		}

		$sql .=" group by b.division";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
	function class_adv_info($dv, $stream_id, $academicyear, $semester)
    {

        $DB1 = $this->load->database('umsdb', TRUE); 
		$acd_yr = explode('~',$academicyear);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
        $sql="SELECT f.fname,f.mname,f.lname,f.mobile_no,f.designation_name, a.class_teacher, vw.school_name, vw.stream_short_name FROM lecture_faculty_assign a 
		left join vw_faculty f on f.emp_id = a.class_teacher 
		left join vw_stream_details vw on vw.stream_id =a.stream_id 
		where a.academic_year='".$acd_yr[0]."' and a.academic_session='".$cur_ses."' and a.semester='".$semester."' and a.division='".$dv."'";
		
		if($semester=='1' || $semester=='2'){
	        if($stream_id ==9){
				$sql.=" AND a.stream_id in(5,6,7,8,9,10,11,96,97)";	
			}else if($stream_id ==103 || $stream_id ==104){
				$sql.=" AND a.stream_id in(43,44,45,46,47)";
			}else{
				$sql.=" AND a.stream_id='".$stream_id."'";
			}
		}else{
			$sql.=" AND a.stream_id='".$stream_id."'";
		}

		$sql .=" group by a.division";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function admission_strength($stream_id, $academic_year, $semester){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$acd_yr = explode('~',$academic_year);
		$academicyear = explode('-',$acd_yr[0]);
        $sql="SELECT count(a.student_id) as stud_streangth FROM `admission_details` a 
		LEFT JOIN student_master s on s.stud_id=a.student_id
		
		where a.academic_year='".$academicyear[0]."' and s.current_semester='".$semester."' ";
		
		if($semester=='1' || $semester=='2'){
	        if($stream_id ==9){
				$sql.=" AND a.stream_id in(5,6,7,8,9,10,11,96,97)";	
			}else if($stream_id ==103 || $stream_id ==104){
				$sql.=" AND a.stream_id in(43,44,45,46,47)";
			}else{
				$sql.=" AND a.stream_id='".$stream_id."'";
			}
			
		}else{
			$sql.=" AND a.stream_id='".$stream_id."'";
		}
		/*if($semester=='1' || $semester=='2'){
			$year =1;
		}elseif($semester=='3' || $semester=='4'){
			$year =2;
		}elseif($semester=='5' || $semester=='6'){
			$year =3;
		}elseif($semester=='7' || $semester=='8'){
			$year =4;
		}*/
		//$sql.=" AND a.year='".$year."'";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	function get_subjetc_wise_academic_studentinfo($subject_id, $stream_id, $academic_year, $semester, $division)
    {

        $DB1 = $this->load->database('umsdb', TRUE); 
		$acd_yr = explode('~',$academic_year);	
        $sql="SELECT b.division,count(a.stud_id) as stud_cnt,sm.enrollment_no,sm.mobile,sm.first_name,sm.middle_name,sm.last_name,sm.gender, vw.stream_name,s.subject_code, s.subject_name,a.semester FROM `student_applied_subject` a 
		left join student_master sm on sm.stud_id = a.stud_id
		left join student_batch_allocation b on b.student_id =a.stud_id AND a.stream_id=b.stream_id AND a.semester=b.semester and a.academic_year=b.academic_year 
		left join vw_stream_details vw on vw.stream_id =a.stream_id
		left join subject_master s on s.sub_id =a.subject_id
		where a.academic_year='".$acd_yr[0]."' and a.semester='".$semester."' and a.subject_id='$subject_id' and b.division='$division'";
		
		if($semester=='1' || $semester=='2'){
	        if($stream_id ==9){
				$sql.=" AND a.stream_id in(5,6,7,8,9,10,11,96,97)";	
			}else if($stream_id ==103 || $stream_id ==104){
				$sql.=" AND a.stream_id in(43,44,45,46,47)";
			}else{
				$sql.=" AND a.stream_id='".$stream_id."'";
			}
		}else{
			$sql.=" AND a.stream_id='".$stream_id."'";
		}

		$sql .=" group by sm.stud_id order by sm.enrollment_no";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }

	/////////////////////////////////////////////////////////
	public function getAllTopics() {
        return $this->db->get('syllabus_topics')->result_array();
    }

    public function insertTopic($data) {
        $this->db->insert('syllabus_topics', $data);
        return $this->db->insert_id();
    }

    public function insertSubtopic($data) {
        return $this->db->insert('syllabus_subtopics', $data);
    }
}