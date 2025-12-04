<?php
class Test_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		$DB1 = $this->load->database('umsdb', TRUE);
    }
    
	function get_course_streams() {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select stream_id,stream_name from vw_stream_details where course_id='" . $_POST['course'] . "' ";
        $query = $DB1->query($sql);
        $stream_details = $query->result_array();
        echo '<option value="">--Select--</option>';
        foreach ($stream_details as $course) {

            echo '<option value="' . $course['stream_id'] . '"' . $sel . '>' . $course['stream_name'] . '</option>';
        }

    }    
	
	function load_subject($course_id, $streamId, $semesterId, $batch) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select sub_id,subject_name,subject_code,semester from subject_master where stream_id='" .$streamId. "' and semester='" .$semesterId. "' and batch='".$batch."' and is_active='Y'";
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();


        echo '<select name="subject" class="form-control" id="subject" required>
									<option value="">Select Subject</option>';

        foreach ($sub_details as $sub) {

            echo '<option value="' . $sub['sub_id'] . '"' . $sel . '>' . $sub['subject_code'].' - '.$sub['subject_name'] . '</option>';
        }
		echo '<option value="OFF">OFF Lecture</option>';
		echo '<option value="Library">Library</option>';
		echo '<option value="Tutorial">Tutorial</option>';
		echo '<option value="Tutor">Tutor</option>';
		echo '<option value="IS">Internet Slot</option>';
		echo '<option value="RC">Remedial Class</option>';
		echo '<option value="EL">Experiential Learning</option>';
		echo '<option value="SPS">Swayam Prabha Session</option>';
		echo '<option value="ST">Spoken Tutorial</option>';
		echo '<option value="FAM">Faculty Advisor Meet</option>';
        echo '</select></div>';
    }
	function load_subject_type($subject_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select subject_component from subject_master where sub_id='".$subject_id."'";
        $query = $DB1->query($sql);
        return $query->result_array();
    }	
	function getSchools() {
        $sql = "SELECT college_id,college_name FROM college_master";
        $query = $this->db->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function fetch_subject_batches() {
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT distinct batch FROM subject_master order by batch desc";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
		function getSlots_old() {
		$DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "SELECT * FROM lecture_slot";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function getSlots($var) {
		$DB1 = $this->load->database('umsdb', TRUE);
		$strem_id = $var['stream_id'];
		$semester = $var['semester'];
		$division = $var['division'];
		$academic_year = $var['academic_year'];
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$where ="WHERE ltt.stream_id='".$strem_id."' AND ltt.semester='".$semester."' AND ltt.division='".$division."' and ltt.academic_year='".$acd_yr[0]."' AND academic_session='".$cur_ses."'";
        $sql = "SELECT  distinct lt.from_time, ltt.lecture_slot, lt.to_time,lt.slot_am_pm, ltt.subject_type FROM lecture_time_table as ltt left join lecture_slot lt on lt.lect_slot_id=ltt.lecture_slot $where order by lt.from_time";
        $query = $DB1->query($sql);
       
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	function load_department($school_id) {
       
        $sql = "select department_id,department_name,school_college_id from department_master where school_college_id='" .$school_id. "'";
        $query = $this->db->query($sql);
        $sub_details = $query->result_array();

        echo '<select name="dept_id" class="form-control" id="dept_id" required>
									<option value="">Select Department</option>';

        foreach ($sub_details as $sub) {

            echo '<option value="' . $sub['department_id'] . '"' . $sel . '>' . $sub['department_name'] . '</option>';
        }
        echo '</select></div>';
    }
	
	function load_faculty($school_id, $dept_id) {

        $sql = "select emp_reg_id,emp_id, CONCAT(fname, ' ', mname, ' ', lname) AS fac_name from employee_master where emp_school='" .$school_id. "' and department='" .$dept_id. "' and emp_status='Y'";
		//echo $sql;
        $query = $this->db->query($sql);
        $sub_details = $query->result_array();

        echo '<select name="emp_id" class="form-control" id="emp_id" required>
									<option value="">Select Faculty</option>';

        foreach ($sub_details as $sub) {

            echo '<option value="' . $sub['emp_id'] . '/'.$sub['fac_name'].'"' .$sel . '>' . $sub['fac_name'] . '</option>';
        }
        echo '</select></div>';
    }
	
	function insert_timetable($var){
		// load library function for session
		
		$DB1 = $this->load->database('umsdb', TRUE);  
		$academic = explode('~', $var['academic_year']);
		if($academic[1]=='WINTER'){
			$curr_sess='WIN';
		}else{
			$curr_sess='SUM';
		}
		$data['course_id'] = $var['course_id'];
		$data['stream_id'] = $var['stream_id'];
		$data['academic_year'] = $academic[0];
		$data['academic_session'] = $curr_sess;
		$data['semester'] = $var['semester'];
		$data['subject_type'] = $var['sub_type'];
		$data['room_no'] = $var['room_no'];
		$data['division'] = $var['division'];
		if($var['sub_type']=='TH'){
			$data['batch_no'] = '0';
		}else{
			$data['batch_no'] = $var['batch_no'];
		}
		//$data['faculty_code'] =$facultyId[0];
		$data['lecture_slot'] = $var['lecture_slot'];
		$data['subject_code'] = $var['subject'];
		$data['wday'] = $var['wday'];
		
		$emp_id = $this->session->userdata("uid");		
		$data['inserted_by'] =$emp_id;
		$data['inserted_on'] = date('Y-m-d H:i:s');

		// keep values in session
		$this->session->set_userdata('Tcourse_id',$var['course_id']);
		$this->session->set_userdata('Tstream_id',$var['stream_id']);
		$this->session->set_userdata('Tsemester',$var['semester']);
		$this->session->set_userdata('Tdivision',$var['division']);
		$this->session->set_userdata('Tsub_type',$var['sub_type']);
		$this->session->set_userdata('Tbatch_no',$var['batch_no']);
		$this->session->set_userdata('Tsubject',$var['subject']);
		$this->session->set_userdata('Tacdyr',$var['academic_year']);
		
		$DB1->insert('lecture_time_table', $data);
		//echo $DB1->last_query();exit;
		return true;
	}
	
	// fetch subject and other details for timetable
	function  get_tt_details($time_table_id='', $course_id='', $stream_id='', $sem='', $div='',$academic_year ='')
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $academic_year =explode('~', $academic_year);
        $where=" WHERE 1=1 ";          
        if($time_table_id!="")
        {
            $where.=" AND tt.time_table_id='".$time_table_id."'";
        } 
		if($stream_id!="")
        {
            $where.=" AND tt.stream_id='".$stream_id."' AND tt.semester='".$sem."' AND tt.division='".$div."' and tt.academic_year='".$academic_year[0]."'";
        }		
        $sql="SELECT tt.*,case tt.wday
  when 'Monday' then 1
  when 'Tuesday' then 2
  when 'Wednesday' then 3
  when 'Thursday' then 4
  when 'Friday' then 5
  when 'Saturday' then 6
  when 'Sunday' then 7
end as day_nr, sm.subject_name,sm.subject_code as sub_code,sm.batch, ls.from_time,ls.to_time, ls.slot_am_pm, em.fname,em.mname,em.lname,sd.stream_name FROM `lecture_time_table` as tt 
		left join subject_master sm on sm.sub_id = tt.subject_code 
		left join lecture_slot ls on ls.lect_slot_id = tt.lecture_slot
		left join vw_faculty em on em.emp_id = tt.faculty_code
		left join vw_stream_details sd on sd.stream_id = tt.stream_id
		$where order by day_nr,ls.from_time ASC";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	// update timetable
	function update_timetable($var){
		$DB1 = $this->load->database('umsdb', TRUE);  
		/*$academic = explode('~', $var['academic_year']);
		if($academic[1]=='WINTER'){
			$curr_sess='WIN';
		}else{
			$curr_sess='SUM';
		}
		$data['course_id'] = $var['course_id'];
		$data['stream_id'] = $var['stream_id'];
		$data['academic_year'] = $academic[0];
		$data['academic_session'] = $curr_sess;
		$data['semester'] = $var['semester'];
		$data['division'] = $var['division'];
		$data['subject_code'] = $var['subject'];
		*/
		if(!empty($var['faculty'])){
			$facultyId = explode(',', $var['faculty']);
			if(!empty($facultyId[0])){
				$faculty_code = $facultyId[0];
				$data['faculty_code'] = $faculty_code;
			}
		}
		
		
		$data['room_no'] = $var['room_no'];
		$data['subject_type'] = $var['sub_type'];
		if($var['batch_no'] =='TH'){
			$data['batch_no'] = 0;
		}else{
			$data['batch_no'] = $var['batch_no'];
		}
		$data['lecture_slot'] = $var['lecture_slot'];
		
		$data['wday'] = $var['wday'];
		$emp_id = $this->session->userdata("uid");		
		$data['updated_by'] =$emp_id;
		$data['updated_on'] = date('Y-m-d H:i:s');

		$DB1->where('time_table_id', $var['time_table_id']);
		$DB1->update('lecture_time_table', $data);
		
		//echo $DB1->last_query();exit;
		return true;
	}
	//load faculty from umsdb faculty master
	function load_temp_faculty($school_id, $dept_id) {
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select emp_reg_id,emp_id, CONCAT(fname, ' ', mname, ' ', lname) AS fac_name from faculty_master where emp_school='" .$school_id. "' and department='" .$dept_id. "' and emp_status='Y'";
		//echo $sql;
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();

        echo '<select name="emp_id" class="form-control" id="emp_id" required>
									<option value="">Select Faculty</option>';

        foreach ($sub_details as $sub) {

            echo '<option value="' . $sub['emp_id'] . '/'.$sub['fac_name'].'"' . $sel . '>' . $sub['fac_name'] . '</option>';
        }
        echo '</select></div>';
    }
	
	// fetch time table for display 
	function  fetchTimeTable($sloats, $wday, $var)
    {

        $DB1 = $this->load->database('umsdb', TRUE); 
		$strem_id = $var['stream_id'];
		$semester = $var['semester'];
		$division = $var['division'];		
		$sloat_id = $slt['from_time'];	
		$academic_year = $var['academic_year'];
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$where ="WHERE tt.wday='".$wday."' AND tt.stream_id='".$strem_id."' AND tt.semester='".$semester."' AND tt.division='".$division."' and tt.academic_year='".$acd_yr[0]."' and tt.academic_session='".$cur_ses."'";

		$sql1="SELECT tt.*, sm.subject_name,sm.subject_code as sub_code, sm.subject_short_name, ls.lect_slot_id, ls.from_time,ls.to_time, ls.slot_am_pm, em.fname, em.mname, em.lname,sd.stream_name FROM `lecture_time_table` as tt 
		left join subject_master sm on sm.sub_id = tt.subject_code 
		left join lecture_slot ls on ls.lect_slot_id = tt.lecture_slot
		left join vw_faculty em on em.emp_id = tt.faculty_code
		left join vw_stream_details sd on sd.stream_id = tt.stream_id
		$where order by ls.from_time, tt.batch_no asc ";
		
		$query1 = $DB1->query($sql1);
		//echo $DB1->last_query();echo "</br>";echo "</br>";
		
		$result[]= $query1->result_array();
		return $result;
    }

	// duplicate entry check in timetable
		function checkDuplicateTt($var){
		$academic = explode('~', $var['academic_year']);
		if($academic[1]=='WINTER'){
			$curr_sess='WIN';
		}else{
			$curr_sess='SUM';
		}
		$DB1 = $this->load->database('umsdb', TRUE);  
		$data['course_id'] = $var['course_id'];

		$stream_id = $var['stream_id'];
		$academic_year = $academic[0];
		$semester = $var['semester'];
		$subject_type = $var['sub_type'];
		$data['room_no'] = $var['room_no'];
		$division = $var['division'];
		$lecture_slot = $var['lecture_slot'];
		$subject_code = $var['subject'];
		$wday = $var['wday'];
		$batch_no = $var['batch_no'];
		$faculty = $var['faculty'];
		$sql ="select * from lecture_time_table where stream_id='".$stream_id."' AND academic_year='".$academic_year."' AND academic_session='".$curr_sess."' AND semester='".$semester."' AND lecture_slot='".$lecture_slot."' 
		AND subject_code='".$subject_code."' AND wday='".$wday."'  AND subject_type='".$subject_type."' AND division='".$division."' AND batch_no='".$batch_no."'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result = $query->result_array();
		return $result;
	}
	function checkDuplicateLectSloat($var){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$facultyId = explode('/', $var['faculty']);
		$stream_id = $var['stream_id'];
		$academic_year = ACADEMIC_YEAR;
		$semester = $var['semester'];
		$division = $var['division'];
		$lecture_slot = $var['lecture_slot'];
		$subject_code = $var['subject'];
		$wday = $var['wday'];
		$batch_no = $var['batch_no'];
		$faculty = $facultyId[0];
		$sql ="select * from lecture_time_table where stream_id='".$stream_id."' AND academic_year='".$academic_year."' AND semester='".$semester."' AND lecture_slot='".$lecture_slot."' AND wday='".$wday."' AND batch_no='".$batch_no."' AND division='".$division."'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result = $query->result_array();
		return $result;
	}
	function checkDuplicateLect($var){
		
		$DB1 = $this->load->database('umsdb', TRUE);  
		$facultyId = explode('/', $var['faculty']);
		$stream_id = $var['stream_id'];
		$academic_year = ACADEMIC_YEAR;
		$semester = $var['semester'];
		$division = $var['division'];
		$lecture_slot = $var['lecture_slot'];
		$subject_code = $var['subject'];
		$wday = $var['wday'];
		$sub_type = $var['sub_type'];
		$batch_no = $var['batch_no'];
		$faculty = $facultyId[0];
		$sql ="select * from lecture_time_table where stream_id='".$stream_id."' AND academic_year='".$academic_year."' AND semester='".$semester."' AND faculty_code='".$faculty."' AND lecture_slot='".$lecture_slot."' AND wday='".$wday."' ";
		if($sub_type =='PR'){
			$sql.="AND batch_no='".$batch_no."' AND division='".$division."'"; 
		}
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result = $query->result_array();
		return $result;
	}
	
	function fetch_stud_details($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name, stm.course_name,stm.course_short_name,stm.stream_short_name, s.stream_id as strmId, stm.stream_id, sba.batch,sba.division,stm.course_id");
		$DB1->from('student_master as sm');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('student_applied_subject as sas','sas.stud_id = sm.stud_id and sas.semester=sm.current_semester' ,'left');
		$DB1->join('subject_master as s','s.sub_id = sas.subject_id','left');
		$DB1->join('student_batch_allocation as sba','sba.batch_id = sas.sub_applied_id and sas.semester=sba.semester','left');
		$DB1->where('enrollment_no', $stud_id);
		$DB1->group_by("s.stream_id");
		$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
	
	function getSlotsforStud($var) {
		$DB1 = $this->load->database('umsdb', TRUE);
		$strem_id = $var['stream_id'];
		$semester = $var['semester'];
		$division = $var['division'];
		$academic_year = $var['academic_year'];
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$where ="WHERE ltt.stream_id='".$strem_id."' AND ltt.semester='".$semester."' AND ltt.division='".$division."' and ltt.academic_year='".$acd_yr[0]."' and ltt.academic_session='".$cur_ses."'";
        $sql = "SELECT  distinct lt.from_time, ltt.lecture_slot, lt.to_time,lt.slot_am_pm, ltt.subject_type FROM lecture_time_table as ltt left join lecture_slot lt on lt.lect_slot_id=ltt.lecture_slot $where order by lt.from_time";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
		// get emp semester
	function getemp_sem($var){
		$obj = New Consts();
		$curr_sess = $obj->fetchCurrSession();
		
		$empId = $this->session->userdata("name");
		$empStreamid =$this->getFacultyStream($empId);
		$DB1 = $this->load->database('umsdb', TRUE);  
		$faculty = $var['faculty'];
		$sql ="select distinct semester from lecture_time_table where faculty_code='".$empId."'";
		if(!empty($empStreamid) && $empStreamid!='71'){
			$sql .=" AND academic_session='".$curr_sess."'";
		}
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result = $query->result_array();
		return $result;
	}
	// get emp semester
	function getemp_div($var){
		$obj = New Consts();
		$curr_sess = $obj->fetchCurrSession();
		
		$empId = $this->session->userdata("name");
		$empStreamid =$this->getFacultyStream($empId);
		$DB1 = $this->load->database('umsdb', TRUE);  
		$faculty = $var['faculty'];
		$sql ="select distinct division from lecture_time_table where faculty_code='".$empId."'";
		if(!empty($empStreamid) && $empStreamid!='71'){
			$sql .=" AND academic_session='".$curr_sess."'";
		}
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result = $query->result_array();
		return $result;
	}
	// get facurty name
	function get_faculty_name($fid){
		$empId = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);  
		$faculty = $var['faculty'];
		$sql ="select fname, mname,lname,emp_id from vw_faculty where emp_id='".$fid."'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result = $query->result_array();
		return $result;
	}	
	// aaded on 20/09/17
	function removeTimetableEntry($tt_id)
	 {
		$DB1 = $this->load->database('umsdb', TRUE);
		$row  = $this->fetch_row_details($tt_id);
		if(!empty($row)){
			$academic_year = $row[0]['academic_year'];
			$academic_session = $row[0]['academic_session'];
			$stream_id = $row[0]['stream_id'];
			$semester = $row[0]['semester'];
			$division = $row[0]['division'];
			$batch_no = $row[0]['batch_no'];
			$subject_code = $row[0]['subject_code'];
			$warray =array('academic_year' => $academic_year,'academic_session' => $academic_session,'stream_id' => $stream_id,'semester' => $semester,'subject_code' => $subject_code,'division' => $division,'batch_no' => $batch_no);
			$DB1->where($warray);
			//$DB1->delete('lecture_faculty_assign1212'); 
			//echo $DB1->last_query();exit;
		}
		$DB1->where('time_table_id', $tt_id);
		$DB1->delete('lecture_time_table'); 
		//echo $DB1->last_query();exit;
		return true;
	 }
	function fetch_row_details($tid){
		$empId = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sql ="select academic_year, academic_session,stream_id,semester,subject_code,subject_type,division,batch_no,faculty_code from lecture_time_table where time_table_id='".$tid."'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result = $query->result_array();
		return $result;
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
	///////////////////////////////////////////
	// fetch subject details of timetable for faculty allocation.
	function  get_tt_subdetails($time_table_id='', $course_id='', $stream_id='', $sem='', $div='',$academic_year='')
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
        $sql="SELECT tt.subject_code,tt.time_table_id, tt.division,tt.batch_no,tt.course_id, sm.subject_type,tt.stream_id,tt.semester, sm.subject_name,sm.subject_code as sub_code, sm.subject_component,tt.subject_type as subtype, em.fname,em.mname,em.lname,sd.stream_name, f.faculty_code FROM `lecture_time_table` as tt 
left join (select subject_code,division,semester,stream_id,batch_no,faculty_code from lecture_faculty_assign where is_active='Y' and stream_id='".$stream_id."' AND semester='".$sem."' AND division='".$div."' AND academic_year='".$acd_yr[0]."' and academic_session='".$cur_ses."' ) f on f.subject_code = tt.subject_code and f.division=tt.division and f.semester=tt.semester and f.stream_id=tt.stream_id and f.batch_no = tt.batch_no
left join subject_master sm on sm.sub_id = tt.subject_code 
left join vw_faculty em on em.emp_id = f.faculty_code 
left join vw_stream_details sd on sd.stream_id = tt.stream_id 
WHERE tt.stream_id='".$stream_id."' AND tt.semester='".$sem."' AND tt.division='".$div."' AND tt.academic_year='".$acd_yr[0]."' and tt.academic_session='".$cur_ses."' group by tt.subject_code,sm.subject_component, tt.division,tt.batch_no";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    // fetch exam strams
	function load_ttcources($academic_year){
		$DB1 = $this->load->database('umsdb', TRUE);
		
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$sql = "select distinct vw.course_id,vw.course_short_name from lecture_time_table t left join vw_stream_details vw on vw.stream_id = t.stream_id where t.academic_year ='$acd_yr[0]' and t.academic_session='$cur_ses' and vw.course_name is not null ";
		if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND vw.school_code = $sccode";
			}
		$sql .=" order by vw.course_id asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	function load_ttsemesters($stream_id,$academic_year){
		$DB1 = $this->load->database('umsdb', TRUE);
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$sql = "select distinct semester from lecture_time_table  where stream_id='".$stream_id."' and academic_year ='$acd_yr[0]' and academic_session='$cur_ses' order by semester asc";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	    // fetch exam strams
	function load_ttdivision($stream_id,$academic_year, $semester){
		$DB1 = $this->load->database('umsdb', TRUE);
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$sql = "select distinct division from lecture_time_table  where stream_id='".$stream_id."' and academic_year ='$acd_yr[0]' and academic_session='$cur_ses' and semester='$semester' order by division asc";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	// get faculty list
	function get_faculty_list() {

		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select emp_reg_id,emp_id, CONCAT(fname, ' ', mname, ' ', lname) AS fac_name,department_name,designation_name from vw_faculty order by fname";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
    }
    	// fetch subject details of timetable for faculty allocation.
	function  get_subdetails($subject_id,$stream_id,$semester,$division,$batch,$academicyear)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$acd_yr = explode('~',$academicyear);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}		
        $sql="SELECT tt.subject_code,tt.time_table_id, tt.division,tt.batch_no,tt.course_id, sm.subject_type,tt.stream_id,tt.semester,tt.academic_year,tt.academic_session, sm.subject_name,sm.subject_code as sub_code, sm.subject_component, em.fname,em.mname,em.lname,sd.stream_name FROM `lecture_time_table` as tt 
left join lecture_faculty_assign f on f.subject_code = tt.subject_code and f.division=tt.division and f.semester=tt.semester and f.stream_id=tt.stream_id and f.batch_no = tt.batch_no
left join subject_master sm on sm.sub_id = tt.subject_code 
left join vw_faculty em on em.emp_id = f.faculty_code 
left join vw_stream_details sd on sd.stream_id = tt.stream_id 
WHERE tt.stream_id='".$stream_id."' AND tt.semester='".$semester."' AND tt.division='".$division."' AND tt.batch_no='".$batch."' AND tt.subject_code='".$subject_id."' AND tt.academic_year='".$acd_yr[0]."' and tt.academic_session='".$cur_ses."' group by tt.subject_code,sm.subject_component";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function insert_subject_faculty($var){
		// load library function for session

		//echo  $var['faculty'];exit;
		$DB1 = $this->load->database('umsdb', TRUE);  
		$facultyId = explode(',', $var['faculty']);
		$faculty_code = $facultyId[0];

		$data['stream_id'] = $var['stream_id'];
		$data['academic_year'] = $var['academic_year'];
		$data['academic_session'] = $var['academic_session'];
		$data['semester'] = $var['semester'];
		$data['subject_type'] = $var['subject_component'];
		$data['subject_code'] = $var['subject_id'];
		$data['division'] = $var['division'];
		if($var['subject_component']=='TH'){
			$data['batch_no'] = '0';
		}else{
			$data['batch_no'] = $var['batch_no'];
		}
		$data['faculty_code'] =$faculty_code;
		$data['is_active'] = 'Y';	
		$data['inserted_on'] = date('Y-m-d H:i:s');	

		$DB1->insert('lecture_faculty_assign', $data);
		//echo $DB1->last_query();exit;
		return true;
	}

	function  checkDuplicate_faculty($var)
    {
    	$stream_id = $var['stream_id'];
		$academic_year = $var['academic_year'];
		$academic_session = $var['academic_session'];
		$semester = $var['semester'];
		$subject_type = $var['subject_component'];
		$subject_code = $var['subject_id'];
		$division = $var['division'];
        $DB1 = $this->load->database('umsdb', TRUE);
	
        $sql="SELECT stream_id from  lecture_faculty_assign WHERE stream_id='".$stream_id."' AND semester='".$semester."' AND division='".$division."' AND subject_code='".$subject_code."' and is_active='Y' AND academic_year='".$academic_year."' AND academic_session='".$academic_session."' ";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    function  update_subject_faculty($var)
    {
    	$stream_id = $var['stream_id'];
		$academic_year = $var['academic_year'];
		$academic_session = $var['academic_session'];
		$semester = $var['semester'];
		$subject_type = $var['subject_component'];
		$subject_code = $var['subject_id'];
		$division = $var['division'];
		$batch_no = $var['batch_no'];
        $DB1 = $this->load->database('umsdb', TRUE);
			
        $sql="UPDATE lecture_faculty_assign SET is_active='N' WHERE stream_id='".$stream_id."' AND semester='".$semester."' AND division='".$division."' AND subject_code='".$subject_code."' and batch_no='$batch_no' AND academic_year='".$academic_year."' AND academic_session='".$academic_session."'";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return true;
    }
    // fetch exam strams
	function fetch_faculty($stream_id,$sem, $division,$academic_year,$subject_code){
		$DB1 = $this->load->database('umsdb', TRUE);
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		
		$sql = "select distinct faculty_code, em.fname,em.mname,em.lname,l.hod_code,
		em1.fname as fname1,em1.lname as lname1,
		em2.fname as fname2,em2.lname as lname2,
		em3.fname as fname3,em3.lname as lname3,
		em4.fname as fname4,em4.lname as lname4,
		l.class_teacher,l.tutor1_code,l.tutor2_code,l.tutur3_code from lecture_faculty_assign l 
		left join vw_faculty em on em.emp_id = l.faculty_code
		left join vw_faculty em1 on em1.emp_id = l.class_teacher 
		left join vw_faculty em2 on em2.emp_id = l.tutor1_code 
		left join vw_faculty em3 on em3.emp_id = l.tutor2_code
		left join vw_faculty em4 on em4.emp_id = l.tutur3_code
		where l.stream_id='".$stream_id."' and l.academic_year ='".$acd_yr[0]."' and l.academic_session='".$cur_ses."' and l.division='$division' and l.semester='$sem' and l.subject_code='$subject_code' and is_active='Y'";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$res = $query->result_array();
		return $res;
	} 
	// update faculty of timetable subject
	function  update_subject_faculty_intimetable($var)
    {
    	$stream_id = $var['stream_id'];
		$academic_year = $var['academic_year'];
		$academic_session = $var['academic_session'];
		$semester = $var['semester'];
		$subject_type = $var['subject_component'];
		$subject_code = $var['subject_id'];
		$division = $var['division'];
		$batch_no = $var['batch_no'];
		$facultyId = explode(',', $var['faculty']);
		$faculty_code = $facultyId[0];

        $DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="UPDATE lecture_time_table SET faculty_code='$faculty_code' WHERE stream_id='".$stream_id."' AND semester='".$semester."' AND division='".$division."' AND subject_code='".$subject_code."' and batch_no='$batch_no' AND academic_year='".$academic_year."' AND academic_session='".$academic_session."'";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return true;
    }  
    	// get faculty list
	function get_class_faculty_list($stream_id,$sem, $division,$academic_year) {

		$DB1 = $this->load->database('umsdb', TRUE);
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$sql = "select distinct faculty_code, CONCAT(fname, ' ', mname, ' ', lname) AS fac_name from lecture_faculty_assign l 
		left join vw_faculty em on em.emp_id = l.faculty_code 
		where l.stream_id='".$stream_id."' and l.academic_year ='".$acd_yr[0]."' and l.academic_session='".$cur_ses."' and l.division='$division' and l.semester='$sem' and l.division='$division' and is_active='Y'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
    } 
    // update faculty of timetable subject
	function update_class_details($var)
    {
    	$stream_id = $var['stream_id'];
		$academic_year = $var['academic_year'];
		$acd_yr = explode('~',$var['academic_year']);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$semester = $var['semester'];
		$division = $var['division'];
		$class_teacher = explode(',', $var['class_teacher']);
		$class_teacher = $class_teacher[0];

		$tutor_1 = explode(',', $var['tutor_1']);
		$tutor_1 = $tutor_1[0];

		$tutor_2 = explode(',', $var['tutor_2']);
		$tutor_2 = $tutor_2[0];

		$tutor_3 = explode(',', $var['tutor_3']);
		$tutor_3 = $tutor_3[0];
        $DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="UPDATE lecture_faculty_assign SET class_teacher='$class_teacher',tutor1_code='$tutor_1',tutor2_code='$tutor_2',tutur3_code='$tutor_3' WHERE stream_id='".$stream_id."' AND semester='".$semester."' AND division='".$division."' AND academic_year='".$acd_yr[0]."' AND academic_session='".$cur_ses."'";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return true;
    }

	function fetch_Curracademic_session(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select academic_year,academic_session from academic_session where currently_active='Y'";
		$query = $DB1->query($sql);
		$res = $query->result_array();
		return $res;
	}
	function fetch_Allacademic_session(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$sql = "select academic_year,academic_session from academic_session ";		
		if(isset($role_id) && ($role_id==15 || $role_id==6)){
			$sql .=" Order by id desc limit 0,2";
		}else{
			$sql .="  where currently_active='Y'";
		}
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$res = $query->result_array();
		return $res;
	}
	/// mailing Attandance report 
		function fetch_schools($todaysdate,$day,$academic_year,$ses){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct vw.school_code,vw.school_name from lecture_time_table t
left join vw_stream_details vw on vw.stream_id =t.stream_id where t.academic_year='".$academic_year."' and t.academic_session='".$ses."' and wday='".$day."' and school_code is not null";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$res = $query->result_array();
		return $res;
	}
	function fetch_streams($school_code, $day,$academic_year,$ses){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct t.stream_id, vw.stream_name,t.division,t.semester from lecture_time_table t
left join vw_stream_details vw on vw.stream_id =t.stream_id where t.academic_year='".$academic_year."' and t.academic_session='".$ses."' and wday='".$day."' and vw.school_code='".$school_code."'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$res = $query->result_array();
		return $res;
	}

	function fetch_mailing_details($todaysdate,$day, $school_code, $stream_id,$sem,$division, $academic_year,$ses){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select t.faculty_code,t.subject_code,s.subject_name,s.subject_code as sub_code, t.subject_type,lecture_slot,wday,slt.from_time,slt.to_time,slt.slot_am_pm, f.fname,f.mname,f.lname,vw.school_name, vw.stream_name,la.att_percentage,la.tot_students,la.totPersent from lecture_time_table t 
left join lecture_slot slt on slt.lect_slot_id = t.`lecture_slot` 
left join vw_faculty f on f.emp_id = t.faculty_code 
left join vw_stream_details vw on vw.stream_id =t.stream_id 
left join subject_master s on s.sub_id = t.subject_code
left join (SELECT faculty_code,subject_id,attendance_date,slot, count(*) as tot_students, sum(case when is_present='Y' then 1 else 0 end) as totPersent, (sum(case when is_present='Y' then 1 else 0 end)/count(*)) *100 as att_percentage FROM `lecture_attendance` WHERE `academic_year` = '$academic_year' and academic_session='$ses' and attendance_date='$todaysdate' GROUP BY faculty_code,subject_id,attendance_date,slot) as la on la.faculty_code=t.faculty_code and t.subject_code=la.subject_id 

where t.academic_year='".$academic_year."' and t.academic_session='".$ses."' and t.wday='".$day."' and vw.school_code='".$school_code."' and t.stream_id='".$stream_id."' and t.semester='".$sem."' and t.division='".$division."' and t.faculty_code IS NOT NULL order by vw.school_code,t.stream_id,t.semester asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();echo "<br>";echo "<br>";//exit;
		$res = $query->result_array();
		return $res;
	}
	function load_tt_streams($course_id, $academic_year){
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$sql = "select distinct vw.stream_id,vw.stream_name from lecture_time_table t left join vw_stream_details vw on vw.stream_id = t.stream_id where t.academic_year ='$acd_yr[0]' and t.academic_session='$cur_ses' and t.course_id='$course_id' and vw.course_name is not null";
		if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND vw.school_code = $sccode";
			}
		$sql .=" order by vw.course_id asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}


		function getSlots_indivi_faculty($var) {
		$DB1 = $this->load->database('umsdb', TRUE);
		$emp_id = $this->session->userdata("name");
		/*$arbreak=explode('-',$var['subject']);
		$strem_id = $arbreak[4];
		$semester = $arbreak[3];
		$division = $arbreak[1];*/
		$academic_year = $var;
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$where ="WHERE ltt.faculty_code='".$emp_id."' and ltt.academic_year='".$acd_yr[0]."' AND ltt.academic_session='".$cur_ses."'";
        $sql = "SELECT  distinct lt.from_time, ltt.lecture_slot, lt.to_time,lt.slot_am_pm, ltt.subject_type
		 FROM lecture_time_table as ltt left join lecture_slot lt on lt.lect_slot_id=ltt.lecture_slot 
		 $where order by lt.from_time";
        $query = $DB1->query($sql);
       
		/*echo $DB1->last_query();exit;*/
        return $query->result_array();
    }
    //fetch time for individiual faculty
    function  fetchTimeTable_individiual($sloats, $wday, $var)
    {

        $DB1 = $this->load->database('umsdb', TRUE); 
        $emp_id = $this->session->userdata("name");
		$arbreak=explode('-',$var['subject']);
		$strem_id = $arbreak[4];
		$semester = $arbreak[3];
		$division = $arbreak[1];		
		$sloat_id = $slt['from_time'];	
		$academic_year = $var;
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$emp_id = $this->session->userdata("name");
		/*$where ="WHERE tt.wday='".$wday."' AND tt.stream_id='".$strem_id."' AND tt.semester='".$semester."' 
		AND tt.division='".$division."' and tt.academic_year='".$acd_yr[0]."' and tt.academic_session='".$cur_ses."'";*/
		
		$where ="WHERE  
		 tt.faculty_code='".$emp_id."' and tt.academic_year='".$acd_yr[0]."' and tt.academic_session='".$cur_ses."'";

		$sql1="SELECT  tt.*, sm.subject_name,sm.subject_code as sub_code, sm.subject_short_name,
		 ls.lect_slot_id, ls.from_time,ls.to_time, ls.slot_am_pm, em.fname, em.mname, 
		 em.lname,sd.stream_name FROM `lecture_time_table` as tt 
		INNER join subject_master sm on sm.sub_id = tt.subject_code 
		left join lecture_slot ls on ls.lect_slot_id = tt.lecture_slot
		left join vw_faculty em on em.emp_id = tt.faculty_code
		left join vw_stream_details sd on sd.stream_id = tt.stream_id
		$where order by ls.from_time, tt.batch_no asc ";
		
		$query1 = $DB1->query($sql1);
		//echo $DB1->last_query();
		//exit;
		//echo "</br>";echo "</br>";
		
		$result[]= $query1->result_array();
		return $result;
    }	





public function Update_fee(){
	 $DB1 = $this->load->database('umsdb', TRUE);
		/* $sql1="SELECT ad.actual_fee as main_fees,td.* FROM `temp_add_list`  AS td
		 LEFT JOIN admission_details AS ad ON ad.student_id =td.student_id
		 WHERE STATUS IS NULL";*/
		// exit();
		 
		/* $sql=" SELECT sm.stud_id,sm.enrollment_no,sm.`lateral_entry`,ad.* FROM `admission_details` AS ad
LEFT JOIN student_master AS sm ON sm.stud_id=ad.`student_id` AND sm.`enrollment_no`=ad.`enrollment_no`
 WHERE ad.`academic_year`='2019'  AND sm.`admission_session`='2018' AND ad.year='3'";*/
 
/* $sql="SELECT sm.stud_id,sm.enrollment_no,sm.`lateral_entry`,ad.* FROM `admission_details` AS ad
LEFT JOIN student_master AS sm ON sm.stud_id=ad.`student_id` AND sm.`enrollment_no`=ad.`enrollment_no`
 WHERE sm.stud_id IN ('3116','3125','3133','3149','3171','3184','3190','3198','3199','3204','3222','3279','3337','3353','3374','3375','3386','3387','3391','3395','3396','3397','3399','3403','3478','3494','3543','3549','3554','3557','3558','3571','3575','3577','3578','3605','3614','3616','3628','3635','3650','3653','3659','3678','3682','3689','3691','3693','3694','3704','3705','3711','3712','3713','3719','3724','3727','3730','3733','3735','3739','3746','3747','3752','3761','3768','3769','3774','3779','3786','3808','3809','3811','3814','3816','3822','3827','3830','3841','3852','3853','3858','3869','3876','3877','3879','3885','3886','3887','3889','3893','3896','3902','3905','3908','3910','3911','3913','3926','3927','3929','3931','3937','3956','3957','4033','4077','4109','4167','4182','4183','4201','4204','4208','4216','4217','4218','4226','4227','4240','4273','4313','4319','4343','4347','4362','4380','4420','4426','4451','4462','4467','4503','4504','4531','4541','4549','4607','4619','4678','4684','4696','4697','4699','4705','4706','4708','4720','4732','4733','4740','4741','4747','4761','4765','4768','4777','4782','4784','4807','4811','4815','4823','4826','4829','4830','4834','4835','4838','4841','4843','4845','4851','4852','4854','4908','4918','4921','4922','4924','4925','4931','4933','4936','4944','4965','4967','4970','4981','4996','4998','5000','5009','5011','5018','5020','5022','5035','5038','5044','5051','5056','5058','5072','5077','5078','5098','5100','5102','5103','5106','5110','5122','5123','5130','5134','5198','5200','5234','5236')";*/
		 $sql="SELECT * FROM  `admission_details` WHERE `enrollment_no` IN  ('180105041028','180105041030','180105041031','180107021002','180107021006','180105171007','180105181052','180101061048','180104051024','180103011025','180102011131','180107021003','180107021004')";
		 /*'190105082003','190105082004','190105082005','190105082006','190105122001','190105122002','190105122003','190105122005','190105122006','190105122009','190105122010','190105131024','190105132002','190105132003','190105132004','190105132005','190105132006','190105132007','190105132009','190105132010','190105132014','190105132017','190105132018','190105132021','190105132022','190105132023','190105132024','190105132026','190105132028','190105132032','190105132039','190105132041','190105172001','190105172003','190105182001','190105182005','190105182006','190105182010','190105182013','190105182017','190105012001','190105052001','190105052004','190101052001','190101052003','190101052005','190101052008','190101052009','190101052011','190101062001','190101062004','190101062006','190101062009','190101062010','190101062012','190101062017','190101062018','190101062022','190101062023','190101062024','190101062027','190101062031','190101062036','190101062037','190101062045','190101062046','190101062047','190101062048','190101062049','190101062054','190101062055','190101062056','190101062057','190101062059','190101062065','190101062066','190101062071','190101062072','190101062073','190101062076','190101062077','190101062080','190101062081','190101062082','190101062086','190101062088','190101062097','190101062098','190101062100','190101062101','190101062102','190101062103','190101062106','190101062110','190101082001','190101082002','190101082004','190101082008','190101082013','190101082016','190101082020','190101092003','190101092008','190101092009','190101092017','190101092019','190101092022','190101092023','190101092024','190101092027','190101092031','190101092034','190101092037','190101092038','190101092040','190101092042','190101092045','190101092047','190101092048','190101092051','190101092054','190101092055','190101092056','190101092058','190101092060','190101092061','190101092063','190101092068','190101092070','190101382004','190101082005','190101092004','190109032001','190109032002','190109032003','190109032004','190104052001','190102012003','190110021021','190110022003')";*/
		 
		  $query = $DB1->query($sql);
		  $result=$query->result_array();
		  foreach($result as $list){
			  
			echo  $adm_id =$list['adm_id'];echo '<br>';
			echo $student_id =$list['student_id'];echo '<br>';
			echo  $academic_year =$list['academic_year'];echo '<br>';
			echo $year =$list['year'];echo '<br>';
			echo  $applicable_fee=$list['applicable_fee']; echo '<br>';
			echo  $actual_fee=$list['actual_fee']; echo '<br>';
			echo $new_actual=($actual_fee + 1000);
			echo $new_fee=($applicable_fee + 1000);
			echo '<br>';
			$DB2 = $this->load->database('umsdb', TRUE);
			echo $sqlUPDATE="UPDATE admission_details SET actual_fee='".$new_actual."', applicable_fee='".$new_fee."'
				 WHERE adm_id='".$adm_id."' AND student_id='".$student_id."' AND academic_year='2019'";
				  
			  $queryUPDATE = $DB2->query($sqlUPDATE);
			  
		  }
	}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*$data_array['first_name']=$data['firstname'].' '.$data['smname'].' '.$data['slname'];
		//print_r($data['admission_type']);
		//exit;
            $data_array['lateral_entry']= ($data['admission_type']==1) ? "N":"Y";
			$data_array['current_semester']= ($data['admission_type']==1) ? 1:3;
			$data_array['admission_semester']= ($data['admission_type']==1) ? 1:3;
			$data_array['admission_year']= ($data['admission_type']==1) ? 1:2;
			$data_array['current_year']= ($data['admission_type']==1) ? 1:2;
			$data_array['email']=$data['email'];
			$data_array['adhar_card_no']=$data['aadhar'];
			
			$data_array['category']=$data['optradio'];
			$data_array['mobile']=$data['smobile'];
			$data_array['admission_stream']=$data['admission-branch'];
			$data_array['admission_school']=$data['admission-school'];
			$data_array['current_semesterorg']='';
			$data_array['prn_2018']='';
			$data_array['punching_prn']='';
			$data_array['enrollment_no_2019']='';
			$data_array['admission_session']=$data['acyear'];
			$data_array['academic_year']=$data['acyear'];*/
function delete_record($k){
	//exit();
	 $DB1 = $this->load->database('umsdb', TRUE);
	 echo $sql="SELECT * FROM student_master WHERE  stud_id='$k'";
	 #admission_session='2020' AND `academic_year`='2020' AND AND (enrollment_no='' OR enrollment_no IS NULL)";
	  $query = $DB1->query($sql);
	$result=$query->result_array();
		  //foreach($result as $list){
	 /*foreach($k as $student_id){
		 echo $student_id.'<br>';
	 }*/
	 print_r($result);
	//exit();
	 
	 foreach($result as $list){
		  echo $student_id=$list['stud_id']; echo '<br>';//.'<br>';
	echo $sql="insert into temp_student_master(enrollment_no_new,enrollment_no,first_name,lateral_entry,current_semester,admission_semester,admission_year,current_year,email,adhar_card_no,category,mobile,admission_stream,admission_school,admission_session,academic_year,created_on,enquiry_id,enquiry_no,studentid) select enrollment_no_new,enrollment_no,first_name,lateral_entry,current_semester,admission_semester,admission_year,current_year,email,adhar_card_no,category,mobile,admission_stream,admission_school,admission_session,academic_year,created_on,enquiry_id,enquiry_no,stud_id from student_master where stud_id='$student_id'";
	 $query = $DB1->query($sql);
	 
	 
	 $DB2 = $this->load->database('umsdb', TRUE);
	 $sql1="DELETE FROM `admission_details` WHERE `student_id`='$student_id'";
	 $query1 = $DB2->query($sql1);
    
	  
     $sql2="DELETE FROM `address_details` WHERE `student_id`='$student_id'";
	 $query2 = $DB2->query($sql2);
	 
	// $DB4 = $this->load->database('umsdb', TRUE);
     $sql3="DELETE FROM `student_qualification_details` WHERE `student_id`='$student_id'";
     $query3 = $DB2->query($sql3);
   
    // $DB5 = $this->load->database('umsdb', TRUE);
     $sql4="DELETE FROM student_master WHERE stud_id='$student_id'";
     $query4 = $DB2->query($sql4);
	  echo 'Done';
	  
	 }
	 /*address_details
	 admission_details
	 student_qualification_details
	 fees_consession_details*/
	
}



/*public function Update_scholarship($sm_is){
	
	$current_date=date('Y-m-d h:i:s');
	
	$DBs = $this->load->database('umsdb', TRUE);
	$sqls ="SELECT af.`academic_fees`,af.`tution_fees`,af.`total_fees`,st.stud_id,st.enrollment_no,st.academic_year,st.admission_school,st.admission_stream,st.admission_year FROM student_master AS st

LEFT JOIN `academic_fees` AS af ON af.stream_id=st.`admission_stream` AND af.year=st.`admission_year` AND af.admission_year=st.`academic_year`

WHERE st.stud_id='$sm_is'";
	
	   $querys = $DBs->query($sqls);
		$results= $querys->result_array();
		//print_r($result); echo '<br>'; //exit();ech
		foreach($results as $val){
		//echo $val['tution_fees']; echo '<br>';
		$stud_id=$val['stud_id'];
		$enrollment_no=$val['enrollment_no'];
		$total_fees=$val['total_fees'];
		
		$scloership=(($val['tution_fees']) * 10 / 100);
		$year=$val['admission_year'];
		$val['tution_fees'].'---'.round($scloership); //echo '<br>';
		$fees_paid_required=($val['total_fees']-round($scloership));
			
			$scloership=round($scloership);
			
			//$DBE = $this->load->database('umsdb', TRUE);
		 //  echo $sqlE ="INSERT INTO `fees_consession_details`  VALUES (NULL, 'Other_Scholarship', '$stud_id', '$enrollment_no', '2020', '$total_fees', '$scloership', '$fees_paid_required', 'covid 10%', NULL, NULL, NULL, NULL, '$current_date', NULL)"; 
	      //  $queryE = $DBs->query($sqlE);
		$created_on=date('Y-m-d H:i:s');
		$fees_con['concession_type'] = 'Other_Scholarship';
        $fees_con['student_id'] = $stud_id;
        $fees_con['enrollement_no'] = $enrollment_no;
        $fees_con['academic_year'] = '2020';
        $fees_con['actual_fees'] = $total_fees;
        $fees_con['exepmted_fees'] = $scloership;
        $fees_con['fees_paid_required'] = $fees_paid_required;
        $fees_con['concession_remark'] = 'covid 10%';
       // $fees_con['allowed_by'] = $var['stream_id'];
        //$fees_con['created_by'] = $var['stream_id'];
        $fees_con['created_on'] = $created_on;
       // $fees_con['modified_by'] = $var['stream_id'];
       // $fees_con['modified_on'] = $var['stream_id'];
        //$fees_con['remark'] = $var['stream_id'];
			
	   $DBs->insert('fees_consession_details', $fees_con);
		 
  // $DBd = $this->load->database('umsdb', TRUE);
   $sqld ="UPDATE `sandipun_ums`.`admission_details` SET enrollment_no='$enrollment_no',`applicable_fee` = '$fees_paid_required' , `fees_consession_allowed` = 'Y',`concession_type` = 'other_type',`concession_remark` = 'covid 10%'
   WHERE `student_id` = '$stud_id' AND academic_year='2020' AND year='$year'"; 
   $queryd = $DBs->query($sqld);
   

		}
		
		//return 1;
		
}
*/
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	function fetch_payment_details_data($student_id='')
	{
		$DB6 = $this->load->database('umsdb', TRUE); 
		//return $student_data=$DB1->get_where('online_payment',array('student_id'=>$student_id,'payment_status'=>'success'))->result_array();
		$DB6->select("*");
		$DB6->from('online_payment');
		$DB6->where("student_id",$student_id);
		$DB6->where("payment_status",'success');
		$DB6->order_by('payment_id','DESC');
		//$DB6->limit(1);
		$query=$DB6->get();
		/*  echo $DB1->last_query();
		exit(0);*/
		return $result=$query->result_array();
	}
	function fetch_payment_details_data_payid($payid='')
	{
		$DB6 = $this->load->database('umsdb', TRUE); 
		//return $student_data=$DB1->get_where('online_payment',array('student_id'=>$student_id,'payment_status'=>'success'))->result_array();
		$DB6->select("*");
		$DB6->from('online_payment');
		$DB6->where("payment_id",$payid);
		$DB6->where("payment_status",'success');
		$DB6->order_by('payment_id','DESC');
		//$DB6->limit(1);
		$query=$DB6->get();
		/*  echo $DB1->last_query();
		exit(0);*/
		return $result=$query->result_array();
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function searchjlist_new_by_prn($sid){
		    $DB6 = $this->load->database('umsdb', TRUE);
		    /*$stid=array('190101221944','190101221945','190101221946','190101221947','190102201001','190102201002','190102201003','190102201004','190102201005','190102201006','190102201007');*/
			/*$stid=array('200109041005','200101191005','200109061001','200114021003','200105261001','200101181008','200101181009','200104151003','200109041006','200116281004','200109031004','200101051034','200105011013','200105181004','200105121014','200102011002','200104141001','200102261005','200104061008','200105181005','200101051035','200105131003','200101181010','200105011014','200101191006','200102161011','200101171008','200106111014','200101051036','200101201003','200101381004','200102261006','200101051037','200102251003','200101191007');*/
		    //die;
		   
		$DB6->select("sm.*,stm.stream_name,cm.course_name");
		$DB6->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left'); 
		$DB6->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB6->join('course_master as cm','cm.course_id = stm.course_id','left');
		$DB6->where("sm.cancelled_admission",'N');
		//$DB6->where("sm.admission_session",'2020');	
		//$DB6->where("sm.academic_year",'2020');
		$DB6->where("sm.is_detained",'N');
		//$DB1->where("sm.admission_cycle");
		//$DB1->where("length(sm.enrollment_no)",'9');
		$DB6->where("sm.enrollment_no",$sid);
		//$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB6->get();
		/*  echo $DB1->last_query();
		exit(0);*/
		$result=$query->result_array();
		//echo $this->db->last_query();
		
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
	function check_if_exists($table,$cname1,$cvalue1,$cname2,$cvalue2)
{
    
   
        $DB5 = $this->load->database('umsdb', TRUE);
		$DB5->select("count(*) as ucount");
		$DB5->from($table);
		$DB5->where($cname1,$cvalue1);
		$DB5->where($cname2,$cvalue2);
	//	$DB1->join('address_details as ad','sm.stud_id = ad.student_id','left');
	//	$DB1->where("adds_of", "STUDENT");
		//	$DB1->where("address_type", "CORS");d.district_name,c.taluka_name,s.state_name
		$query=$DB5->get(); 
		$cn = $query->row_array();
		return $cn['ucount'];
    
}
	
function create_student_login_by_prn($sid)
{
    $DB3 = $this->load->database('umsdb', TRUE);
	//echo $sid;
    $dat  = $this->searchjlist_new_by_prn($sid);
	$return='';
 //exit;  
//print_r($dat);
//exit();
  foreach($dat as $sdata)
    {
        
       $rcnt = $this->check_if_exists('user_master','username',$sdata['enrollment_no'],'roles_id','9');
        
		if($rcnt<1)
        {
        $par['username'] = $sdata['enrollment_no'];    
        $par['password'] = rand(4999,999999);
         $par['inserted_by'] = '';
          $par['inserted_datetime'] = date('Y-m-d h:i:s');
           $par['status'] ='Y';
            $par['roles_id'] = 9;
      $DB3->insert('user_master',$par);
        }

      $rcnt3 = $this->check_if_exists('user_master','username',$sdata['enrollment_no'],'roles_id','4');
        if($rcnt3<1)
        {
			//echo 'zz';
			//error_reporting(E_ALL);
        $par2['username'] = $sdata['enrollment_no'];    
        $par2['password'] = rand(4999,999999);
        $par2['inserted_by'] = '';//$_SESSION['uid'];
        $par2['inserted_datetime'] = date('Y-m-d h:i:s');
        $par2['status'] ='Y';
        $par2['roles_id'] = 4;
		
        $DB3->insert('user_master',$par2);
		 
	    $return= $par2['password'];
        }else{
			$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from("user_master");
			//$DB1->like('username', "19", 'after');
		$DB1->where("username",$sid);
		$DB1->where("roles_id",4);
		$DB1->where("status",'Y');
		//$DB1->order_by("um_id", "asc");
		$query=$DB1->get(); 
		/*echo $DB1->last_query();
		exit(0);
		die;*/
		
		$result = $query->result_array();
		 $return= $result[0]['password'];
		} 
    }
	
	
	//echo $return;
	//exit(0);
	
	 $mobile= $dat[0]['mobile'];
	
	if($mobile!=''){
		$username = $dat[0]['enrollment_no'];
$password = $return;
$sms_message ="Dear Student
To get your academic information and regular updates kindly logon to
https://sandipuniversity.com/erp/login/index/student/

Username: $username
Password: $password

Thank you
Sandip University.
";

//echo "<br>stu".$mobile.">>".$sms_message;exit;

 
	$sms=urlencode($sms_message);

	$smsGatewayUrl = "http://bulksms.bulkfactory.in/api/v2/sms/send?access_token=b5bb44175fe4aafb9b7e3b7c482d4b8e&message=$sms&sender=SANDIP&to=$mobile&service=T";  
	$smsgatewaydata = $smsGatewayUrl;
	$url = $smsgatewaydata;
	$ch = curl_init();                       // initialize CURL
	curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);         
        
 // $s++;
  //exit;
  //echo 1;
}else{
	//echo 2;
     }
	
	
	$email=$dat[0]['email'];
	
	$body = "Dear Student
To get your academic information and regular updates kindly logon to
https://sandipuniversity.com/erp/login/index/student/ <br>

Username: $username <br>
Password: $password

<br>
Thanks
Sandip University
";
$subject="PRN Number With Login Details erp";
//$file=$_SERVER['DOCUMENT_ROOT'] . 'payment/chpdf/receipt_'.$user_id.'.pdf';

        $path=$_SERVER["DOCUMENT_ROOT"].'/erp/application/third_party/';
        require_once($path.'PHPMailer/class.phpmailer.php');
        date_default_timezone_set('Asia/Kolkata');
        require_once(APPPATH."third_party/PHPMailer/PHPMailerAutoload.php");
        
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        //$mail->SMTPDebug = 4;
        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 465;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        //Username to use for SMTP authentication
        $mail->Username = 'noreply@sandipuniversity.com';
        //Password to use for SMTP authentication
        //$mail->Password = '123Indi@';
        $mail->Password = 'kiran234!';
        //Set who the message is to be sent from
        $mail->setFrom('noreply@sandipuniversity.com', 'Sandip University');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to pramod.karole@sandipuniversity.edu.in
    // $mail->addAddress('pramod.karole@sandipuniversity.edu.in', 'Pramod Karole');
	   
	    $mail->AddAddress($email);
		
	   //$mail->AddAddress('balasaheb.lengare@carrottech.in');
	  //$mail->AddAddress('vighnesh.sukum@carrottech.in');
	  // $mail->AddAddress('kamlesh.kasar@sandipuniversity.edu.in');
	  // $mail->AddAddress('pramod.thasal@carrottech.in');
      //$mail->AddAddress('ar@sandipuniversity.edu.in');
     //  $mail->AddAddress('kiran.valimbe@sandipuniversity.edu.in');
        //Set the subject line
        $mail->Subject = $subject;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
        //Replace the plain text body with one created manually

        $mail->Body = $body;


        $mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        
        $mail->AddAttachment($file);
		//$mail->AddAttachment($provcertificate);
        //send the message, check for errors
       
	   
	   if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message sent!';
			////header("location:thankyou");
		
        }
	
	
    return $return;
    
	
	
}	


public function Update_scholarship($sm_is){
	
	$current_date=date('Y-m-d h:i:s');
	
	$DBs = $this->load->database('umsdb', TRUE);
	$sqls ="SELECT af.`academic_fees`,af.`tution_fees`,af.`total_fees`,st.stud_id,st.enrollment_no,st.academic_year,st.admission_school,st.admission_stream,st.admission_year FROM student_master AS st

LEFT JOIN `academic_fees` AS af ON af.stream_id=st.`admission_stream` AND af.year=st.`admission_year` AND af.admission_year=st.`academic_year`

WHERE st.stud_id='$sm_is'";
	
	   $querys = $DBs->query($sqls);
		$results= $querys->result_array();
		//print_r($result); echo '<br>'; //exit();ech
		foreach($results as $val){
		//echo $val['tution_fees']; echo '<br>';
		$stud_id=$val['stud_id'];
		$enrollment_no=$val['enrollment_no'];
		$total_fees=$val['total_fees'];
		
		$scloership=(($val['tution_fees']) * 10 / 100);
		$year=$val['admission_year'];
		$val['tution_fees'].'---'.round($scloership); //echo '<br>';
		$fees_paid_required=($val['total_fees']-round($scloership));
			
			$scloership=round($scloership);
			
		$created_on=date('Y-m-d H:i:s');
		$fees_con['concession_type'] = 'Other_Scholarship';
        $fees_con['student_id'] = $stud_id;
        $fees_con['enrollement_no'] = $enrollment_no;
        $fees_con['academic_year'] = '2020';
        $fees_con['actual_fees'] = $total_fees;
        $fees_con['exepmted_fees'] = $scloership;
        $fees_con['fees_paid_required'] = $fees_paid_required;
        $fees_con['concession_remark'] = 'covid 10%';
       // $fees_con['allowed_by'] = $var['stream_id'];
        //$fees_con['created_by'] = $var['stream_id'];
        $fees_con['created_on'] = $created_on;
       // $fees_con['modified_by'] = $var['stream_id'];
       // $fees_con['modified_on'] = $var['stream_id'];
        //$fees_con['remark'] = $var['stream_id'];
			
	   $DBs->insert('fees_consession_details', $fees_con);
			
			
			
			//$DBE = $this->load->database('umsdb', TRUE);
		    /*$sqlE ="INSERT INTO `fees_consession_details`  VALUES (NULL, 'Other_Scholarship', '$stud_id', '$enrollment_no', '2020', '$total_fees', '$scloership', '$fees_paid_required', 'covid 10%', NULL, NULL, NULL, NULL, '$current_date', NULL)"; 
	        $queryE = $DBs->query($sqlE);*/
		 
		 
  // $DBd = $this->load->database('umsdb', TRUE);
   $sqld ="UPDATE `sandipun_ums`.`admission_details` SET enrollment_no='$enrollment_no',`applicable_fee` = '$fees_paid_required' , `fees_consession_allowed` = 'Y',`concession_type` = 'other_type',`concession_remark` = 'covid 10%'
   WHERE `student_id` = '$stud_id' AND academic_year='2020' AND year='$year'"; 
   $queryd = $DBs->query($sqld);
   

		}
		
		return 1;
		
}
public function student_conv_entry_details($prn)
	  {

		   $this->load->database();
		   $DB1 = $this->load->database('umsdb', TRUE);		   
		   $DB1->select('c.*');
		   $DB1->select('s.stream_name,s.course_short_name,s.school_short_name');
		   $DB1->select('sm.first_name,sm.middle_name,sm.last_name');
		   $DB1->from('convocation_registration c');
		   $DB1->join('student_master sm','sm.stud_id=c.student_id');
		   $DB1->join('vw_stream_details s','s.stream_id=c.stream_id');
		   $DB1->where('c.enrollment_no',$prn);
		   
		   $query=$DB1->get();
		   //echo $DB1->last_query();
		  return $query->result_array();
	  }	
	
	
	
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
}