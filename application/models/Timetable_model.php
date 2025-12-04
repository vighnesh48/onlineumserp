<?php
class Timetable_model extends CI_Model 
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
		echo '<option value="18153">Experiential Learning</option>';
		echo '<option value="18154">Swayam Prabha Session</option>';
		echo '<option value="18155">Spoken Tutorial</option>';
		echo '<option value="18156">Faculty Advisor Meet</option>';
		echo '<option value="18151">Evaluation</option>';
		echo '<option value="18150">Soft Skill</option>';
		echo '<option value="18152">Basic Aptitude Training</option>';
		echo '<option value="18148">Advanced Aptitude Training</option>';
		echo '<option value="18147">Value Added Course</option>';
		echo '<option value="18149">Certificate Course</option>';
		echo '<option value="18157">Value Added Programe</option>';
		echo '<option value="20745">Value Added Programe-Advanced Excel</option>';
        echo '</select></div>';
    }
	function load_subject_type($subject_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select subject_component,sub_id from subject_master where sub_id='".$subject_id."'";
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
        $sql = "SELECT 
  lect_slot_id,
  from_time,
  to_time,
  slot_am_pm,
  duration,
  is_active,
  CONCAT(DATE_FORMAT(from_time, '%H:%i'), ' - ', DATE_FORMAT(to_time, '%H:%i')) AS slot_label
FROM lecture_slot where is_active='Y'
ORDER BY from_time ASC, to_time ASC";
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
		$faculty_id = $var['faculty_id'];
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$role_id = $this->session->userdata('role_id');
		 if ($role_id != '' && in_array($role_id, [6, 53, 58])) {
			$and = "AND ltt.faculty_code = $faculty_id";
		}
		if($role_id == 20){
			$and = "AND ltt.stream_id = $strem_id AND ltt.semester = $semester AND ltt.division = '".$division."'";
		}
		$where ="WHERE ltt.academic_year='".$acd_yr[0]."' AND academic_session='".$cur_ses."' $and";
        $sql = "SELECT  distinct lt.from_time, ltt.lecture_slot, lt.to_time,lt.slot_am_pm, ltt.subject_type,lt.lect_slot_id FROM lecture_time_table as ltt left join lecture_slot lt on lt.lect_slot_id=ltt.lecture_slot $where group by ltt.lecture_slot order by lt.from_time";
        $query = $DB1->query($sql);
       
		// echo $DB1->last_query();exit;
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
	
	
	function load_faculty_data($stream_id, $academic_year,$semester) {
         $academic_year= (explode("~",$academic_year));

		 $this->db->select("e.emp_id,s.division,e.emp_reg_id,CONCAT(e.fname,' ',e.mname, ' ',e.lname) AS fac_name", FALSE);
				$this->db->from('onlineadmission_ums.lecture_time_table s');
				$this->db->join('onlineerp.employee_master e', 's.faculty_code = e.emp_id');
				$this->db->where('s.stream_id',$stream_id);
				$this->db->where('s.semester',$semester);
				$this->db->where('e.emp_status','Y');
				$this->db->where('s.academic_year',$academic_year[0]);
				$this->db->where_in('s.division',$division);
				$this->db->group_by('e.emp_id');
                $query = $this->db->get();
		
        $sub_details = $query->result_array();
        $str='';
       $str.="<option value=''>Select Faculty</option>";

        foreach ($sub_details as $sub) {

           $str.='<option value="' . $sub['emp_id'] . '/'.$sub['fac_name'].'"' .$sel . '>' . $sub['fac_name'] . '</option>';
        }
       echo $str;
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
		$data['buliding_name'] = $var['buliding_name'];
		$data['floor_no'] = $var['floor_no'];
		$data['division'] = $var['division'];
		if($var['sub_type']=='TH'){
			$data['batch_no'] = '0';
		}else{
			$data['batch_no'] = $var['batch_no'];
		}
		$data['sub_title_id'] = $var['sub_title_id'];
		/* if(!empty($var['tdate'])){
			$data['tdate'] = $var['tdate'];
		}else{
			$data['tdate'] = '';
		} */
		//$data['faculty_code'] =$facultyId[0];
		$data['lecture_slot'] = $var['lecture_slot'];
		$data['subject_code'] = $var['subject'];
		$data['wday'] = $var['wday'];
		
		$emp_id = $this->session->userdata("uid");		
		$emp_id = $this->session->userdata("name");		
		$ex =explode("_",$emp_id);
		$sccode = $ex[1];
		
		$data['inserted_by'] =$emp_id;
		$data['inserted_on'] = date('Y-m-d H:i:s');

		// keep values in session
		$this->session->set_userdata('Tcourse_id',$var['course_id']);
		$this->session->set_userdata('Tstream_id',$var['stream_id']);
		$this->session->set_userdata('Tsemester',$var['semester']);
		$this->session->set_userdata('Tdivision',$var['division']);
		$this->session->set_userdata('Tsub_type',$var['sub_type']);
		$this->session->set_userdata('Tbatch_no',$var['batch_no']);
		$this->session->set_userdata('Tbatch',$var['batch']);
		$this->session->set_userdata('Tsubject',$var['subject']);
		$this->session->set_userdata('Tacdyr',$var['academic_year']);
		if($sccode=='1009'){
			$from_date=$var['fdate'];
			$to_date=$var['tdate'];
			if(!empty($var['faculty'])){
			$facultyId = explode(',', $var['faculty']);
			if(!empty($facultyId[0])){
				$faculty_code = $facultyId[0];
				$data['faculty_code'] = $faculty_code;
			}
		}
			//Convert 'from' and 'to' dates to DateTime objects
			$start_date = new DateTime($from_date);
			$end_date = new DateTime($to_date);

			while ($start_date <= $end_date) {
				//Format the date in the required format for insertion
				$current_date = $start_date->format('Y-m-d');
				//Get the weekday name
				$weekday_name = $start_date->format('l');   
	 
				$data['tdate'] = $current_date;
				$data['wday'] = $weekday_name;
				$DB1->insert('lecture_time_table', $data);
				//Move to the next date
				$start_date->modify('+1 day');
			}
		}else{
			$DB1->insert('lecture_time_table', $data);
		}
		//echo $DB1->last_query();exit;
		return true;
	}
	
	// fetch subject and other details for timetable
	function  get_tt_details($time_table_id='', $course_id='', $stream_id='', $sem='', $div='',$academic_year='')
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
		if($time_table_id!="" || $stream_id!=""){		
				$sql="SELECT tt.*,tt.tdate,tt.room_no,case tt.wday
		  when 'Monday' then 1
		  when 'Tuesday' then 2
		  when 'Wednesday' then 3
		  when 'Thursday' then 4
		  when 'Friday' then 5
		  when 'Saturday' then 6
		  when 'Sunday' then 7
		end as day_nr,vp.subject_title, sm.subject_name,sm.subject_code as sub_code,sm.batch,sm.subject_component, ls.from_time,ls.to_time, ls.slot_am_pm, em.fname,em.mname,em.lname,sd.stream_name FROM `lecture_time_table` as tt 
				left join subject_master sm on sm.sub_id = tt.subject_code 
				left join lecture_slot ls on ls.lect_slot_id = tt.lecture_slot
				left join vw_faculty em on em.emp_id = tt.faculty_code
				left join vw_stream_details sd on sd.stream_id = tt.stream_id
				left join vap_subject_title vp on vp.tid = tt.sub_title_id
				$where order by day_nr,ls.from_time ASC";
				
				$query = $DB1->query($sql);
				//echo $DB1->last_query();exit;
				$uId=$this->session->userdata('uid');
				if($uId=='2')
				{
						//echo $DB1->last_query();
						//die;
				}
		return $query->result_array();
		}else{
			return false;
		}
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
		$data['subject_code'] = $var['subject'];
		if(!empty($var['faculty'])){
			$facultyId = explode(',', $var['faculty']);
			if(!empty($facultyId[0])){
				$faculty_code = $facultyId[0];
				$data['faculty_code'] = $faculty_code;
			}
		}
		
		
		$data['buliding_name'] = $var['buliding_name'];
		$data['floor_no'] = $var['floor_no'];
		$data['room_no'] = $var['room_no'];
		$data['subject_type'] = $var['sub_type'];
		if($var['batch_no'] =='TH'){
			$data['batch_no'] = 0;
		}else{
			$data['batch_no'] = $var['batch_no'];
		}
		$data['lecture_slot'] = $var['lecture_slot'];
		if(!empty($var['tdate'])){
			$data['tdate'] = $var['tdate'];
		}else{
			$data['tdate'] = '';
		}
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
		$faculty_id = $var['faculty_id'];
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$role_id = $this->session->userdata('role_id');

		 if ($role_id != '' && in_array($role_id, [6, 53, 58])) {
			$and = "AND tt.faculty_code = $faculty_id";
		}
		if($role_id == 20 || $role_id == 44 || $role_id == 4 || $role_id == 9){
			$and = "AND tt.stream_id = $strem_id AND tt.semester = $semester AND tt.division = '".$division."'";
		}
		$where ="WHERE tt.wday='".$wday."'  and tt.academic_year='".$acd_yr[0]."' and tt.academic_session='".$cur_ses."' $and";

		$sql1="SELECT tt.*, sm.subject_name,sm.subject_code as sub_code, sm.subject_short_name, ls.lect_slot_id, ls.from_time,ls.to_time, ls.slot_am_pm, em.fname, em.mname, em.lname,sd.stream_short_name,sd.course_short_name 
		FROM `lecture_time_table` as tt 
		left join subject_master sm on sm.sub_id = tt.subject_code 
		left join lecture_slot ls on ls.lect_slot_id = tt.lecture_slot
		left join vw_faculty em on em.emp_id = tt.faculty_code
		left join vw_stream_details sd on sd.stream_id = tt.stream_id
		$where order by ls.from_time, tt.batch_no asc ";
		
		$query1 = $DB1->query($sql1);
		// echo $DB1->last_query();echo "</br>";echo "</br>";exit;
		
		$result[]= $query1->result_array();
		return $result;
    }
function  getFacultyByStream($academic_year, $campus='')
    {
        if($campus==2){
			$DB1 = $this->load->database('sjumsdb', TRUE); 
		}elseif($campus==3){
			$DB1 = $this->load->database('sfumsdb', TRUE); 
		}else{
			$DB1 = $this->load->database('umsdb', TRUE); 
		}
		
		$acd_yr = explode('~',$academic_year);
		$where ="WHERE tt.academic_year='".$acd_yr[0]."' AND tt.faculty_code IS NOT NULL
    AND tt.faculty_code != ''
    AND tt.faculty_code REGEXP '^[0-9]+$'";

		$sql1="SELECT tt.faculty_code, CONCAT(em.fname, ' ', em.mname, ' ', em.lname) AS faculty_name
		FROM `lecture_time_table` as tt 
		left join vw_faculty em on em.emp_id = tt.faculty_code $where
		group by tt.faculty_code order by tt.faculty_code";

		$query1 = $DB1->query($sql1);
	//	echo $DB1->last_query();exit;

		$result = $query1->result_array();
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
	
	function fetchschool_bystream($stream_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('vw_stream_details');
		$DB1->where('stream_id', $stream_id);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
	function fetch_stud_details($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name, stm.course_name,stm.course_short_name,stm.stream_short_name, s.stream_id as strmId, stm.stream_id, sba.batch,sba.division,stm.course_id");
		$DB1->from('student_master as sm');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('student_applied_subject as sas','sas.stud_id = sm.stud_id and sas.semester=sm.current_semester' ,'left');
		$DB1->join('subject_master as s','s.sub_id = sas.subject_id','left');
		$DB1->join('student_batch_allocation as sba','sba.student_id = sas.stud_id and sas.semester=sba.semester','left');
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
		$DB1 = $this->load->database('erpdel', TRUE);
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
		$this->load->model('Subject_model');
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$sql = "select distinct vw.course_id,vw.course_short_name from lecture_time_table t left join vw_stream_details vw on vw.stream_id = t.stream_id where t.academic_year ='$acd_yr[0]' and t.academic_session='$cur_ses' and vw.course_name is not null ";
		
		if(isset($role_id) && $role_id==20){
			 $empsch = $this->Subject_model->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $dept= $empsch[0]['department'];
			 $sql .=" AND vw.stream_id in(select ums_stream_id from onlineerp.department_ums_stream_mapping where department_id='$dept')";
		 }else if(isset($role_id) && $role_id==44){
			 $empsch = $this->Subject_model->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $sql .=" AND vw.school_code = $schid";
		 }else if(isset($role_id) && $role_id==10){
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
		$emp_id = $this->session->userdata("name");
        //print_r($emp_id);exit;
		$sql = "select academic_year,academic_session from academic_session ";		
		if(isset($role_id) && ($role_id==15 || $role_id==6 || $emp_id=='admin_1010') ){
			$sql .=" Order by academic_year desc limit 0,2";
		}elseif($emp_id == 'research_admin'){
			$sql .=" Order by academic_year desc limit 0,4";
			
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
		$this->load->model('Subject_model');
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		//$acd_yr[0]='2022-23';
		$sql = "select distinct vw.stream_id,vw.stream_name from lecture_time_table t left join vw_stream_details vw on vw.stream_id = t.stream_id where t.academic_year ='$acd_yr[0]' and t.academic_session='$cur_ses' and t.course_id='$course_id' and vw.course_name is not null";
		
		if(isset($role_id) && $role_id==20){
			 $empsch = $this->Subject_model->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $dept= $empsch[0]['department'];
			 $sql .=" AND vw.stream_id in(select ums_stream_id from onlineerp.department_ums_stream_mapping where department_id='$dept')";
		 }else if(isset($role_id) && $role_id==44){
			 $empsch = $this->Subject_model->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $sql .=" AND vw.school_code = $schid";
		 }else if(isset($role_id) && $role_id==10){
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
		$arbreak=explode('-',$var['subject']);
		$strem_id = $arbreak[4];
		$semester = $arbreak[3];
		$division = $arbreak[1];
		$academic_year = $var['academic_year'];
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$where ="WHERE ltt.faculty_code='".$emp_id."' and ltt.academic_year='".$acd_yr[0]."' AND ltt.academic_session='".$cur_ses."'";
        $sql = "SELECT  distinct lt.from_time, ltt.lecture_slot, lt.to_time,lt.slot_am_pm, ltt.subject_type FROM lecture_time_table as ltt left join lecture_slot lt on lt.lect_slot_id=ltt.lecture_slot $where order by lt.from_time";
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

   function get_class_faculty_listindividual($stream_id='',$sem='', $division='',$academic_year,$school_code) {

		$DB1 = $this->load->database('umsdb', TRUE);
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		if($stream_id!='')
		{
			$whe="and l.stream_id='".$stream_id."'";
		}
		if($sem!='')
		{
			$whe="and l.semester='".$sem."'";
		}
		if($division!='')
		{
			$whe="and l.division='".$division."'";
		}
		if($stream_id!='' && $sem!='' )
		{
			$whe="and l.stream_id='".$stream_id."' and l.semester='".$sem."' ";
		}
		if($stream_id!='' && $division!='')
		{
			$whe="and l.stream_id='".$stream_id."' and l.division='".$division."' ";
		}
		if($sem!='' &&  $division!='')
		{
			$whe=" and l.semester='".$sem."' and l.division='".$division."'";

		}
		if($stream_id!='' && $sem!='' &&  $division!='')
		{
			$whe=" and l.stream_id='".$stream_id."' and l.semester='".$sem."' and l.division='".$division."'";

		}
		if($stream_id=='' && $sem=='' &&  $division=='')
		{
			$whe="";

		}
		if($school_code!='' && $school_code!='0')
		{
			$sch="vmsw.school_code='".$school_code."' and ";
		}

		if($school_code=='' || $school_code=='0')
		{
			$sch="";
		}
		


		//$whe="l.stream_id='".$stream_id."' and l.division='".$division."' and l.semester= '".$sem."'";
		$sql = "select distinct faculty_code, CONCAT(fname, ' ', mname, ' ', lname) AS fac_name from lecture_faculty_assign l 
		left join vw_faculty em on em.emp_id = l.faculty_code
		left join vw_stream_details vmsw on vmsw.stream_id = l.stream_id 
		where $sch  l.academic_year ='".$acd_yr[0]."' and l.academic_session='".$cur_ses."' and l.is_active='Y' $whe";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
    } 
    function  get_tt_subdetailsindividual($time_table_id='', $course_id='', $stream_id='', $sem='', $div='',$academic_year='',$school_code)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}

		if($stream_id!='')
		{
			$whe="and stream_id='".$stream_id."'";
			$whe1="and tt.stream_id='".$stream_id."'";
		}
		if($sem!='')
		{
			$whe="and semester='".$sem."'";
			$whe1="and tt.semester='".$sem."'";
		}
		if($div!='')
		{
			$whe="and division='".$div."'";
			$whe1="and tt.division='".$div."'";
		}
		if($stream_id!='' && $sem!='' )
		{
			$whe=" and stream_id='".$stream_id."' and semester='".$sem."' ";
			$whe1=" and tt.stream_id='".$stream_id."' AND tt.semester='".$sem."'";
		}
		if($stream_id!='' && $div!='')
		{
			$whe=" and stream_id='".$stream_id."' and division='".$div."' ";
			$whe1="and tt.stream_id='".$stream_id."' AND tt.division='".$div."'";
		}
		if($sem!='' &&  $div!='')
		{
			$whe="and semester='".$sem."' and division='".$div."'";
			$whe1=" and tt.semester='".$sem."' AND tt.division='".$div."'";

		}
		if($stream_id!='' && $sem!='' &&  $div!='')
		{
			$whe=" and stream_id='".$stream_id."' and semester='".$sem."' and division='".$div."'";
			$whe1=" and tt.stream_id='".$stream_id."' AND tt.semester='".$sem."' AND tt.division='".$div."'";


		}
		if($stream_id=='' && $sem=='' &&  $div=='')
		{
			$whe="";
			$whe1="";

		}

		if($school_code!='' && $school_code!='0')
		{
			$sch="sd.school_code='".$school_code."' and";
		}

		if($school_code=='' || $school_code=='0')
		{
			$sch="";
		}
		
        $sql="SELECT tt.subject_code,tt.time_table_id, tt.division,tt.batch_no,tt.course_id, sm.subject_type,tt.stream_id,tt.semester, sm.subject_name,sm.subject_code as sub_code, sm.subject_component,tt.subject_type as subtype, em.fname,em.mname,em.lname,sd.stream_name, f.faculty_code FROM `lecture_time_table` as tt 
left join (select subject_code,division,semester,stream_id,batch_no,faculty_code from lecture_faculty_assign where is_active='Y' AND academic_year='".$acd_yr[0]."' and academic_session='".$cur_ses."' $whe  ) f on f.subject_code = tt.subject_code and f.division=tt.division and f.semester=tt.semester and f.stream_id=tt.stream_id and f.batch_no = tt.batch_no
left join subject_master sm on sm.sub_id = tt.subject_code 
left join vw_faculty em on em.emp_id = f.faculty_code 
left join vw_stream_details sd on sd.stream_id = tt.stream_id 
WHERE $sch  tt.academic_year='".$acd_yr[0]."' and tt.academic_session='".$cur_ses."' and sm.subject_code!='' $whe1  group by tt.subject_code,sm.subject_component, tt.division,tt.batch_no";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
	  function  get_tt_subdetails_qp($course_id='', $stream_id='', $type='', $sem='',$academic_year='')
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		if($type == 'bklg'){
        $sql="SELECT tt.subject_code,tt.time_table_id, tt.division,tt.batch_no,tt.course_id, sm.subject_type,sm.batch,tt.stream_id,tt.semester, sm.sub_id,sm.subject_name,sm.subject_code as sub_code, sm.subject_component,tt.subject_type as subtype,sd.stream_name FROM `lecture_time_table` as tt 
left join (select subject_code,division,semester,stream_id,batch_no,faculty_code from lecture_faculty_assign where is_active='Y' and stream_id='".$stream_id."') f on f.subject_code = tt.subject_code and f.division=tt.division and f.semester=tt.semester and f.stream_id=tt.stream_id and f.batch_no = tt.batch_no
left join subject_master sm on sm.sub_id = tt.subject_code 
left join vw_stream_details sd on sd.stream_id = tt.stream_id
left join exam_student_subject ess on sm.sub_id = ess.subject_id  
WHERE ess.passed = 'N' and tt.subject_code is not null AND tt.stream_id='".$stream_id."'
 #AND tt.semester='".$sem."'  
 and tt.subject_type != 'PR' and sm.is_active = 'Y' group by tt.subject_code,sm.sub_id order by tt.semester";
}else{

	$sql="SELECT tt.subject_code,tt.time_table_id, tt.division,tt.batch_no,tt.course_id, sm.subject_type,tt.stream_id,tt.semester, sm.batch,sm.sub_id,sm.subject_name,sm.subject_code as sub_code, sm.subject_component,tt.subject_type as subtype, sd.stream_name  FROM `lecture_time_table` as tt 

left join subject_master sm on sm.sub_id = tt.subject_code  
left join vw_stream_details sd on sd.stream_id = tt.stream_id 
WHERE tt.subject_code is not null AND tt.stream_id='".$stream_id."' 
#AND tt.semester='".$sem."'   
AND  tt.academic_year='".$acd_yr[0]."' and tt.academic_session='".$cur_ses."' and tt.subject_type != 'PR' and sm.is_active = 'Y' group by tt.subject_code,sm.sub_id order by tt.semester";


}
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
function  fetchTimeTable_faculty($sloats, $wday,$uId)
    {

        $DB1 = $this->load->database('umsdb', TRUE); 	
		$academic_year = ACADEMIC_YEAR;
		$obj = New Consts();
		$curr_sess = $obj->fetchCurrSession();
		$where ="WHERE tt.wday='".$wday."' and tt.academic_year='".$academic_year."' and tt.faculty_code = '".$uId."' AND tt.academic_session='".$curr_sess."'";

		$sql1="SELECT tt.*, sm.subject_name,sm.subject_code as sub_code, sm.subject_short_name, ls.lect_slot_id, ls.from_time,ls.to_time, ls.slot_am_pm, em.fname, em.mname, em.lname,sd.stream_name FROM `lecture_time_table` as tt 
		left join subject_master sm on sm.sub_id = tt.subject_code 
		left join lecture_slot ls on ls.lect_slot_id = tt.lecture_slot
		left join vw_faculty em on em.emp_id = tt.faculty_code
		left join vw_stream_details sd on sd.stream_id = tt.stream_id
		$where order by ls.from_time, tt.batch_no asc ";
		
		$query1 = $DB1->query($sql1);
	//	echo $DB1->last_query();echo "</br>";echo "</br>";exit;
		
		$result[]= $query1->result_array();
		return $result;
    }




	function getSlots_faculty($uId) {
		$DB1 = $this->load->database('umsdb', TRUE);
		$academic_year = ACADEMIC_YEAR;
		$obj = New Consts();
		$curr_sess = $obj->fetchCurrSession();
		$where ="WHERE ltt.academic_year='".$academic_year."' AND ltt.faculty_code='".$uId."' AND ltt.academic_session='".$curr_sess."'";
        $sql = "SELECT  distinct lt.from_time, ltt.lecture_slot, lt.to_time,lt.slot_am_pm, ltt.subject_type,lt.lect_slot_id FROM lecture_time_table as ltt left join lecture_slot lt on lt.lect_slot_id=ltt.lecture_slot $where group by ltt.lecture_slot order by lt.from_time";
        $query = $DB1->query($sql);
       
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	function load_subject_type_title($subject_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select tid,subject_title from vap_subject_title where subject_code='".$subject_id."' and is_active='Y'";
        $query = $DB1->query($sql);
        return $query->result_array();
       }
	   
	   
	public function insert_vap_subject_title($data)
	{
		//print_r($data);exit;
		$DB1 = $this->load->database('umsdb', TRUE);

		// Fetch the existing record
		$sd = $DB1->get_where('vap_subject_title', ['subject_code' => $data['subject'],'subject_title' => $data['sub_title']])->row_array();

		if (empty($sd)) {
			// Convert object to an array and add the inserted_on field
              $indata['subject_code']=$data['subject'];
              $indata['subject_title']=$data['sub_title'];
              $indata['inserted_by']=$this->session->userdata("uid");
              $indata['inserted_on']=date('Y-m-d H:i:s');
			  $DB1->insert('vap_subject_title', $indata);
			  $id=$DB1->insert_id() ;
			if($id>0){
            echo json_encode(["status" => "success", "message" => "New Subject Title Added Successfully!"]);
				} else {
					echo json_encode(["status" => "error", "message" => "No changes were made."]);
				}
		   } else {
				echo json_encode(["status" => "error", "message" => "Already inserted."]);
			}
	    }
		///
public function getLectureSlots($filters)
{
    $DB1 = $this->load->database('umsdb', TRUE);

    $DB1->select('ls.*')
        ->from('lecture_slot ls')
        ->join('lecture_time_table ltt', 'ltt.lecture_slot = ls.lect_slot_id')
        ->where([
            'ltt.stream_id' => $filters['stream_id'],
            'ltt.semester' => $filters['semester'],
            'ltt.division' => $filters['division'],
            'ltt.academic_year' => '2025-26',
            'ltt.academic_session' => 'WIN',
            'ltt.is_active' => 'Y',
        ])
        ->group_by('ls.lect_slot_id')
        ->order_by('ls.from_time,ls.to_time', 'ASC');

    return $DB1->get()->result();
}


public function getStudentDetails($enrollment_no)
{
	$DB1 = $this->load->database('umsdb', TRUE);
	$DB1->select('sba.division,v.course_short_name,v.stream_name,s.*')
        ->from('student_master s')
        ->join('student_batch_allocation sba', 's.stud_id = sba.student_id and s.current_semester = sba.semester','left')
        ->join('vw_stream_details v', 's.admission_stream = v.stream_id','left')
		->where('s.enrollment_no',$enrollment_no);
     return $DB1->get()->result();
	//echo $DB1->last_query();exit;
}

public function getStudentTimetableGrouped($filters)
{
    $DB1 = $this->load->database('umsdb', TRUE);

    $DB1->select('
        ltt.wday, 
        ltt.lecture_slot, 
        ltt.subject_code, 
        ltt.subject_type, 
        ltt.faculty_code, 
        ltt.room_no, 
		ltt.division,
        ltt.batch_no,
        ltt.buliding_name, 
        ltt.floor_no,
        sm.subject_name, 
        sm.subject_code as sub_code, 
        sm.subject_short_name, 
        em.fname, 
        em.mname, 
        em.lname, 
        sd.stream_short_name, 
        sd.course_short_name
    ');
    $DB1->from('lecture_time_table ltt');
    $DB1->join('subject_master sm', 'sm.sub_id = ltt.subject_code', 'left');
    $DB1->join('vw_faculty em', 'em.emp_id = ltt.faculty_code', 'left');
    $DB1->join('vw_stream_details sd', 'sd.stream_id = ltt.stream_id', 'left');
    $DB1->where([
        'ltt.stream_id' => $filters['stream_id'],
        'ltt.semester' => $filters['semester'],
        'ltt.division' => $filters['division'],
        'ltt.academic_year' => '2025-26',
        'ltt.academic_session' => 'WIN',
        'ltt.is_active' => 'Y',
    ]);

    $query = $DB1->get();
    $result = $query->result();

    $grouped = [];
    foreach ($result as $row) {
        $grouped[$row->wday][$row->lecture_slot][] = $row;
    }

    return $grouped;
}



}