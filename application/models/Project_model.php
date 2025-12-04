<?php
class Project_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
         $this->load->model('Subject_model');
        $this->load->library('Awssdk');
        // $this->bucket_name = 'humanresourcemanagement';
        $this->bucket_name =  'erp-asset';
        date_default_timezone_set('Asia/Kolkata');
		$this->db= $this->load->database('umsdb', TRUE);
		
    }
	
	public function get_all_schools()
{
	
	$role=$this->session->userdata("role_id") ;
	$sccode='';
	if($role==10){
    $emp_id = $this->session->userdata("name");
	$ex =explode("_",$emp_id);
	$sccode = $ex[1];
	}
	elseif($role==20){
		$emp_id=$this->session->userdata("aname");
		$get_details_of_school=$this->Subject_model->loadempschool($emp_id);
		if(!empty($get_details_of_school)){
			$sccode =$get_details_of_school[0]['school_code'];
		}
	
	}
	
    $this->db->select('school_code, school_short_name');
    $this->db->from('school_master'); // adjust table name if different
	$this->db->where('is_active', 'Y');
	if($role!=1 and $role!=53){
		$this->db->where('school_code',$sccode);
	}
	$this->db->where('erp_mapp_school_id !=', '');
    $this->db->order_by('school_short_name', 'ASC');
    return $this->db->get()->result_array();
}


public function get_departments($sccode)
{
    if (empty($sccode)) {
        return [];
    }

    return $this->db->select('DISTINCT stream_id ,stream_name, stream_short_name,', false)
                    ->from('vw_stream_details')
                    ->where('school_code', $sccode)
                    ->order_by('stream_name', 'ASC')
                    ->get()
                    ->result_array();
}

//get_departments

   public function get_projects($limit, $offset, $search = null, $acad = '', $school='', $stream_id='')
{
    // 1) Normalize inputs
    $limit  = (int) $limit;
    $offset = (int) $offset;
    if (empty($acad)) {
        $acad = ACADEMIC_YEAR; // your constant
    }

    // 2) Pre-aggregate student counts once, then left-join
    $psdSub = $this->db->select('project_details_id, COUNT(DISTINCT student_id) AS student_count', false)
                       ->from('project_student_details')
                       ->group_by('project_details_id')
                       ->get_compiled_select();

    // 3) Base SELECT
    $this->db->select("
        pd.*,
        CONCAT(vf.fname, ' ', vf.mname, ' ', vf.lname) AS fac_name,
        COALESCE(psdc.student_count, 0) AS student_count,
        sm.school_short_name,strm.stream_name
    ", false);

    $this->db->from('project_details AS pd');

    // faculty (view) – keep as-is
    $this->db->join('sandipun_ums.vw_faculty AS vf', 'pd.faculty_id = vf.emp_id', 'left');

    // pre-aggregated student counts
    $this->db->join("($psdSub) AS psdc", 'psdc.project_details_id = pd.id', 'left', false);

    // replace vw_stream_details with a narrow, indexed dim table for school name
    // (adjust table/column names if yours differ)
    $this->db->join('sandipun_ums.school_master AS sm', 'sm.school_code = pd.school', 'inner');
	 $this->db->join('sandipun_ums.stream_master AS strm', 'strm.stream_id = pd.stream_id', 'left');

    // 4) Role-based visibility
    $rid = (string) $this->session->userdata('role_id');

    if ($rid === '20') {
        $uid = (int) $this->session->userdata('uid');
        $this->db->group_start()
                 ->where('pd.faculty_id', $this->session->userdata('name'))
                 ->or_where('pd.created_by', $uid)
                 ->group_end();
    } elseif ($rid === '10') {
        $emp_id = (string) $this->session->userdata('name'); // e.g. ABC_XXXX
        $ex = explode('_', $emp_id);
        $sccode = $ex[1] ?? null;
        if ($sccode) {
            $this->db->where('pd.school', $sccode);
        }
    } elseif (!in_array($rid, ['1','58','10','20','53'], true)) {
        $this->db->where('pd.faculty_id', $this->session->userdata('name'));
    }

    // 5) Filters
    $this->db->where('pd.academic_year', $acad);
	 $this->db->where('pd.status', 'Y');
	
	if (!empty($school)) {
        $this->db->where('pd.school', $school);
    }
	if (!empty($stream_id)) {
        $this->db->where('pd.stream_id', $stream_id);
    }

    if (!empty($search)) {
        $this->db->group_start()
                 ->like('pd.project_title', $search)
                 ->or_like('pd.faculty_id', $search)
                 ->or_like('pd.academic_year', $search)
                 ->or_like('pd.industry_sponsored', $search)
                 ->or_like('pd.domain', $search)
                 ->or_like('pd.Bl_level', $search)
                 ->or_like('pd.programminglanguage', $search)
                 ->or_like('vf.fname', $search)
                 ->or_like('vf.mname', $search)
                 ->or_like('vf.lname', $search)
                 ->group_end();
    }

    // 6) Ordering: academic_year is fixed by WHERE, so order by faculty_id, id to use a composite index
    $this->db->order_by('pd.faculty_id', 'asc');
    $this->db->order_by('pd.id', 'asc');

    // 7) Pagination
    $this->db->limit($limit, $offset);

    $query = $this->db->get();
	
	//echo $this->db->last_query();
	//exit;
    return $query->result_array();
}



public function get_projects_summary($limit, $offset, $search = null, $acad = '', $school='', $stream_id='')
{
    $limit  = (int) $limit;
    $offset = (int) $offset;
    if (empty($acad)) $acad = ACADEMIC_YEAR;

    // 🔹 Base query as before
    $this->db->select("
    pd.*,
    CONCAT(vf.fname, ' ', vf.mname, ' ', vf.lname) AS fac_name,
    sm.school_short_name,
    strm.stream_name
", false);
    $this->db->from('project_details AS pd');
    $this->db->join('sandipun_ums.vw_faculty AS vf', 'pd.faculty_id = vf.emp_id', 'left');
    $this->db->join('sandipun_ums.school_master AS sm', 'sm.school_code = pd.school', 'inner');
    $this->db->join('sandipun_ums.stream_master AS strm', 'strm.stream_id = pd.stream_id', 'left');
    $this->db->where('pd.academic_year', $acad);
    $this->db->where('pd.status', 'Y');

    if (!empty($school))     $this->db->where('pd.school', $school);
    if (!empty($stream_id))  $this->db->where('pd.stream_id', $stream_id);
    if (!empty($search)) {
        $this->db->group_start()
                 ->like('pd.project_title', $search)
                 ->or_like('vf.fname', $search)
                 ->or_like('vf.lname', $search)
                 ->group_end();
    }

    $this->db->order_by('pd.faculty_id', 'asc');
    $this->db->order_by('pd.id', 'asc');
    if ($limit) $this->db->limit($limit, $offset);

    $projects = $this->db->get()->result_array();

    // 🔹 Fetch student details for all projects at once
    $ids = array_column($projects, 'id');
    $students = [];
    if (!empty($ids)) {
        $this->db->select('psd.project_details_id, sm.enrollment_no, CONCAT(sm.first_name," ",sm.last_name) as student_name', false);
        $this->db->from('project_student_details psd');
        $this->db->join('sandipun_ums.student_master sm', 'sm.stud_id = psd.student_id', 'left');
        $this->db->where_in('psd.project_details_id', $ids);
        $rows = $this->db->get()->result_array();
        foreach ($rows as $r) {
            $students[$r['project_details_id']][] = [
                'prn'  => $r['enrollment_no'],
                'name' => $r['student_name']
            ];
        }
    }

    // 🔹 Attach students array to each project
    foreach ($projects as &$p) {
        $p['students'] = $students[$p['id']] ?? [];
        $p['student_count'] = count($p['students']);
    }

    return $projects;
}


    public function get_projectsdd($limit, $offset, $search = null,$acad='')
    {
        if(empty($acad)){
			$acad=ACADEMIC_YEAR;
		}
		
		
		$this->db->select("
        project_details.*,
        CONCAT(vf.fname, ' ', vf.mname, ' ', vf.lname) AS fac_name,
        COUNT(DISTINCT psd.student_id) AS student_count,vw.school_short_name
    ", false);

$this->db->from('project_details');
$this->db->join('sandipun_ums.vw_faculty as vf', 'project_details.faculty_id = vf.emp_id', 'left');
$this->db->join('project_student_details as psd', 'psd.project_details_id = project_details.id', 'left');
$this->db->join('vw_stream_details as vw', 'project_details.school = vw.school_code');
        $rid = (string)$this->session->userdata('role_id');

if ($rid === '20') {
    $uid = (int)$this->session->userdata('uid');
	    $this->db->group_start()
         ->where('project_details.faculty_id',$this->session->userdata('name'))
        ->or_where('project_details.created_by', $uid)
    ->group_end();
} elseif ($rid === '10') {
    $emp_id = $this->session->userdata('name');
    $ex = explode('_', $emp_id);
    $sccode = $ex[1] ?? null;
    if ($sccode) {
        $this->db->where('project_details.school', $sccode);
    }
} elseif (!in_array($rid, ['1','58','10','20','53'], true)) {
    $this->db->where('project_details.faculty_id', $this->session->userdata('name'));
}
		
		
		$this->db->where('project_details.academic_year',$acad);
		
        $this->db->order_by('project_details.academic_year', 'desc');

        if (!empty($search)) {
			 $this->db->group_start()
            ->like('project_details.project_title', $search)
            ->or_like('project_details.faculty_id', $search)
            ->or_like('project_details.academic_year', $search)
            ->or_like('project_details.industry_sponsored', $search)
            ->or_like('project_details.domain', $search)
            ->or_like('project_details.Bl_level', $search)
            ->or_like('project_details.programminglanguage', $search)
            ->or_like('vf.fname', $search)
            ->or_like('vf.mname', $search)
            ->or_like('vf.lname', $search)
        ->group_end();
        }
		$this->db->group_by('project_details.id');
		$this->db->order_by('project_details.academic_year', 'desc');
		$this->db->order_by('project_details.faculty_id', 'asc');
        //$this->db->order_by('project_details.faculty_id');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();

        //echo $this->db->last_query();exit;

return $query->result_array();
    }

    public function get_projects_dropdown($school_code='')
    {
        
        $this->db->select('*');
        $this->db->from('project_details');
        if($this->session->userdata('role_id') != '1' && $this->session->userdata('role_id') != '58' && $this->session->userdata('role_id') != '20' && $this->session->userdata('role_id') != '53' && $this->session->userdata('role_id') != '10'){
            $this->db->where('faculty_id', $this->session->userdata('name'));
        }
		if (!empty($school_code)) {
        $this->db->where('school', $school_code);
       }
        $this->db->where('academic_year', ACADEMIC_YEAR);
		
		if ($rid === '20') {

	    $this->db->group_start()
         ->where('project_details.faculty_id',$this->session->userdata('name'))
        ->or_where('project_details.created_by', $uid)
		->or_where('project_details.school', $school_code)
    ->group_end();
} elseif ($rid === '10') {
   
        $this->db->where('project_details.school', $school_code);
    }


        $query = $this->db->get();
	

        return $query->result_array();
    }

    public function get_projects_of_faculty() {
        $this->db->select('*');
        $this->db->from('project_details');
        $this->db->where('faculty_id', $this->session->userdata('name'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_projects($search = null, $acad = '', $school = '', $stream_id = '')
    {
        $this->db->from('project_details');
    if (!empty($acad)) {
        $this->db->where('academic_year', $acad);
    }
    if (!empty($school)) {
        $this->db->where('school', $school);
    }
	 if (!empty($stream_id)) {
        $this->db->where('stream_id', $stream_id);
    }
        if (!empty($search)) {
            $this->db->like('project_title', $search);
            $this->db->or_like('faculty_id', $search);
            $this->db->or_like('academic_year', $search);
        }
		
		


        return $this->db->count_all_results();
    }

    public function get_acadamic_years()
	{
		$sql="select * From academic_year order by academic_year desc";
		$query = $this->db->query($sql);
		return  $query->result_array();
	}

    public function get_student_id($enrollment_no){
        $this->DB1 = $this->load->database('umsdb', TRUE);

        $this->DB1->select("stud_id");
        $this->DB1->from('student_master');
        $this->DB1->where("enrollment_no", $enrollment_no);
        $this->DB1->or_where("enrollment_no_new", $enrollment_no);
        $query=$this->DB1->get();
        $result=$query->row_array();
        return $result['stud_id'];
    }

    public function get_project_details($project_id) {
        $this->db->select("project_details.*, CONCAT(vf.fname, ' ', vf.mname, ' ', vf.lname) AS fac_name", FALSE);
        $this->db->from('project_details');
		$this->db->join('vw_faculty as vf', 'project_details.faculty_id = vf.emp_id', 'left');
        $this->db->where('project_details.id', $project_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_students_with_faculty($faculty_id) {
        $this->db->select('student_id');
        $this->db->where('faculty_id', $faculty_id);
        $query = $this->db->get('project_student_details');

        return array_column($query->result_array(), 'student_id'); // Extracting student_id values
    }

    function get_students_with_project($project_id){
        $this->db->select('student_id');
        $this->db->where('project_details_id', $project_id);
        $query = $this->db->get('project_student_details');

        return array_column($query->result_array(), 'student_id'); // Extracting student_id values
    }
    
    public function get_project_students($project_id = '', $faculty_code = '', $academic_year = '') {
        $students = [];
        // Fetch students based on faculty or project
        if (!empty($faculty_code)) {
            $students = $this->get_students_with_faculty($faculty_code);
        } 
        
        if (!empty($project_id)) {
            $students = array_merge($students, $this->get_students_with_project($project_id));
        }
    
        // Remove duplicates if a student appears in both lists
        $students = array_unique($students);
    
        // If no students found, return empty array
        if (empty($students)) {
            return [];
        }
    
        // Load the secondary database
        $this->DB1 = $this->load->database('umsdb', TRUE);
        
        // Fetch student details
        $this->DB1->select('sm.stud_id, sm.first_name, sm.middle_name, sm.last_name, sm.enrollment_no, sm.enrollment_no_new, pd.project_title, pd.id as project_details_id');
        $this->DB1->from('student_master sm');
        $this->DB1->join('project_student_details psd', 'psd.student_id = sm.stud_id');
        $this->DB1->join('project_details pd', 'pd.id = psd.project_details_id');
        $this->DB1->where_in('sm.stud_id', $students); // Ensure table alias for consistency
        if (!empty($project_id)) {
            $this->DB1->where('pd.id', $project_id);
        }
        if(!empty($academic_year)){
            $this->DB1->where('pd.academic_year', $academic_year);
        }
		$this->DB1->group_by('psd.student_id');
		
        $query = $this->DB1->get();
    
        // Debugging (Uncomment if needed)
        // echo $this->DB1->last_query(); exit;
    
        return $query->result_array();
    }
    

    function getSlots() {
		$DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "SELECT * FROM project_slot WHERE is_active='Y' ";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	

    function getCurrentSession(){
		$DB1 = $this->load->database('umsdb', TRUE);	
        $sql = "SELECT * FROM `academic_session` WHERE `currently_active` ='Y' order by id desc limit 0, 1";		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}

    function check_dup_attendance($today, $project_id, $emp_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 

        $where.="WHERE attendance_date ='".$today."' AND project_details_id='".$project_id."' AND faculty_code='".$emp_id."'";
		
        $sql="SELECT * from project_attendance $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }

    function markAttendance($data){
		
		$DB1 = $this->load->database('umsdb', TRUE);   
		$DB1->insert('project_attendance', $data);

		return true;
	}

    function fetchFacAttDates($emp_id='', $academic_year='', $project_details_id='') {
		
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT distinct l.`attendance_date`, l.slot, sm.from_time, sm.to_time, l.report, l.report_desc FROM `project_attendance` l 
        left join project_slot sm on sm.proj_slot_id = l.slot 
        WHERE l.academic_year ='".$academic_year."' and faculty_code='".$emp_id."' and project_details_id='".$project_details_id."'
        order by l.attendance_date, sm.proj_slot_id asc";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		// echo $DB1->last_query();exit;
        //print_r($sql); die;
		return $res;
    }

    	//fetchFacAttPresent
	function fetchFacAttPresent($attendance_date,$project_details_id,$emp_id,$slot,$academic_year) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT count(*) as present  FROM `project_attendance` WHERE attendance_date ='".$attendance_date."' and `project_details_id` ='".$project_details_id."' and faculty_code='".$emp_id."' AND slot='".$slot."' and academic_year ='".$academic_year."' and is_present='Y' order by attendance_date asc";
        $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;

        $res = $query->result_array();
		return $res;
    }
	//fetchFacAttAbsent
	function fetchFacAttAbsent($attendance_date,$project_details_id,$emp_id,$slot,$academic_year) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT count(*) as absent FROM `project_attendance` WHERE attendance_date ='".$attendance_date."' and `project_details_id` ='".$project_details_id."' and faculty_code='".$emp_id."' AND slot='".$slot."' and academic_year ='".$academic_year."' and is_present='N' order by attendance_date asc";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
    }

    function fetchDateSlotwiseAttDetails($att_date,$project_details_id,$slot,$emp_id, $academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 AND sm.cancelled_admission='N' and sba.active='Y' ";  
        
        if($att_date!="")
        {
            $where.=" AND pa.project_details_id ='".$project_details_id."' and pa.attendance_date='".$att_date."' AND pa.slot='".$slot."' AND pa.faculty_code='".$emp_id."' AND pa.academic_year ='".$academic_year."'";
        }

        $sql="SELECT Distinct sba.roll_no, sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,pa.is_present, pa.remark FROM `project_attendance` as pa  
		left join student_master sm on sm.stud_id=pa.stud_id 
		left join student_batch_allocation sba on sba.student_id=pa.stud_id $where";
		$sql.=" group by sm.stud_id order by sba.roll_no, sm.enrollment_no ";
        $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
        return $query->result_array();
    }

    function get_faculties_for_mark_attendence(){

        $academic_year = ACADEMIC_YEAR;

        $sql = "SELECT DISTINCT pd.faculty_id as faculty_code, em.fname, em.mname, em.lname FROM project_details pd JOIN sandipun_erp.employee_master em ON em.emp_id=pd.faculty_id WHERE academic_year='".$academic_year."'";
        
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    
  function get_school_list(){
        $DB1 = $this->load->database('umsdb', TRUE);
        $role_id = $this->session->userdata('role_id');
        $emp_id = $this->session->userdata("name");
        $this->load->model('Subject_model');
       $sql = "SELECT s.school_code,s.school_name,s.school_short_name from school_master s left join vw_stream_details v on v.school_code=s.school_code where s.is_active='Y' "; 
       
       
       if(isset($role_id) && $role_id==20 || $role_id==21){
            $empsch = $this->Subject_model->loadempschool($emp_id);
            $schid= $empsch[0]['school_code'];
            $sql .=" AND s.school_code = $schid";
        }else if(isset($role_id) && $role_id==44){
            $empsch = $this->Subject_model->loadempschool($emp_id);
            $schid= $empsch[0]['school_code'];
            if($emp_id=='662496'){
                $sql .=" AND s.school_code in(1002,1005,1009,1004)";
            }else{			 
            $sql .=" AND s.school_code = $schid";
            }
        }else if(isset($role_id) && $role_id==10){
               $ex =explode("_",$emp_id);
               $sccode = $ex[1];
               $sql .=" AND s.school_code = $sccode";
       }
       $sql .=" group by s.school_code";
             $query=$DB1->query($sql);
             
        $result=$query->result_array();
   
       return $result;
   }
   
    function get_course_list($sch){
        $DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "SELECT distinct c.course_id,c.course_name,c.course_short_name from vw_stream_details v inner join course_master c on c.course_id= v.course_id where  v.school_code='".$sch."' and v.is_active='Y' "; 
        $query=$DB1->query($sql);
        $result=$query->result_array();

        return $result;
    }
  
   function get_stream_list($cr_id,$sch_id){
            $DB1 = $this->load->database('umsdb', TRUE); 
            $sql = "SELECT stream_name,stream_short_name,stream_id,stream_name from vw_stream_details v join student_master m on m.admission_stream=v.stream_id                 
                        where v.is_active='Y' and v.course_id='".$cr_id."' and v.school_code='".$sch_id."' and m.academic_year='".$this->config->item('cyear')."' group by m.admission_stream order by stream_name ASC "; 
        $query=$DB1->query($sql);
        $result=$query->result_array();
    
        return $result;
    }
   
   
    public function get_attendance_data($academic_year, $school_code, $course_id = '', $stream_id = '', $from_date, $to_date){
        $sql = "SELECT DISTINCT
                    pa.attendance_date,
                    smu.stud_id,
                    psd.faculty_id,
                    CONCAT(em.fname, ' ', TRIM(COALESCE(em.mname, '')), ' ', em.lname) AS faculty_name,
                    CONCAT(smu.first_name, ' ', TRIM(COALESCE(smu.middle_name, '')), ' ', smu.last_name) AS student_name,
                    smu.enrollment_no,
                    pa.is_present,
                    pa.remark,pd.project_title,
                    vw.school_short_name,
                    vw.course_short_name,
                    vw.stream_name
                FROM sandipun_ums.student_master smu
                JOIN project_student_details psd ON smu.stud_id = psd.student_id
                JOIN project_details pd ON psd.project_details_id = pd.id
                JOIN employee_master em ON em.emp_id = psd.faculty_id
                JOIN sandipun_ums.project_attendance pa 
                    ON pa.stud_id = smu.stud_id 
                    AND pa.attendance_date >= ? AND pa.attendance_date <= ?
                JOIN sandipun_ums.vw_stream_details vw ON vw.stream_id = smu.admission_stream
                WHERE pd.academic_year = ?
                
                
             ";

        // Array to store query parameters
        $params = [$from_date, $to_date, $academic_year];
    
        // Conditionally add course_id if provided
        if ($course_id > 0) {
            $sql .= " AND vw.course_id = ?";
            $params[] = $course_id;
        }
    
        // Conditionally add stream_id if provided
        if ($stream_id > 0) {
            $sql .= " AND vw.stream_id = ?";
            $params[] = $stream_id;
        }
    
	 // Conditionally add stream_id if provided
        if ($school_code > 0) {
            $sql .= " AND vw.school_code = ?";
            $params[] = $school_code;
        }
	  
        // Append ORDER BY clause and group by clause
        $sql .= " GROUP by smu.stud_id,pa.attendance_date
                  ORDER BY pa.attendance_date, psd.faculty_id;";
    
        // Execute query with dynamic parameters
        $query = $this->db->query($sql, $params);
        $result = $query->result_array();
		
		
		//echo $this->db->last_query();
		//exit;
		
        return $result;
    }

 public function get_attendance_data_revised($academic_year, $school_code, $course_id = '', $stream_id = '', $from_date, $to_date) {
    // Original SQL query with the date filter condition added
    $sql = "SELECT DISTINCT
                pa.attendance_date,
                smu.stud_id,
                psd.faculty_id,
                CONCAT(em.fname, ' ', TRIM(COALESCE(em.mname, '')), ' ', em.lname) AS faculty_name,
                CONCAT(smu.first_name, ' ', TRIM(COALESCE(smu.middle_name, '')), ' ', smu.last_name) AS student_name,
                smu.enrollment_no,
                pa.is_present,
                pa.remark,
                pd.project_title,
                vw.school_short_name,
                vw.course_short_name,
                vw.stream_name,pa.report
            FROM sandipun_ums.student_master smu
            JOIN project_student_details psd ON smu.stud_id = psd.student_id
            JOIN project_details pd ON psd.project_details_id = pd.id
            JOIN employee_master em ON em.emp_id = psd.faculty_id
            JOIN sandipun_ums.project_attendance pa 
                ON pa.stud_id = smu.stud_id
            JOIN sandipun_ums.vw_stream_details vw ON vw.stream_id = smu.admission_stream
            WHERE pd.academic_year = ?
            AND pa.attendance_date >= ? 
            AND pa.attendance_date <= ?
    ";

    // Array to store query parameters
    $params = [$academic_year, $from_date, $to_date];
    
    // Conditionally add course_id if provided
    if ($course_id > 0) {
        $sql .= " AND vw.course_id = ?";
        $params[] = $course_id;
    }

    // Conditionally add stream_id if provided
    if ($stream_id > 0) {
        $sql .= " AND vw.stream_id = ?";
        $params[] = $stream_id;
    }

    // Conditionally add school_code if provided
    if ($school_code > 0) {
        $sql .= " AND vw.school_code = ?";
        $params[] = $school_code;
    }

    // Append ORDER BY clause and group by clause to group by date
    $sql .= " ORDER BY pa.attendance_date, psd.faculty_id, smu.stud_id;";

    // Execute query with dynamic parameters
    $query = $this->db->query($sql, $params);
    $result = $query->result_array();

    // Return the result
    return $result;
}  

public function getProjectById($project_id)
{
    return $this->db
        ->where('id', $project_id)
        ->get('project_details')
        ->row_array();
}


public function get_allcated_studlist($academic_year, $project_id='')
{
    $sql = "SELECT DISTINCT ps.student_id AS stud_id 
            FROM project_student_details AS ps 
            LEFT JOIN project_details AS p ON ps.project_details_id = p.id 
            WHERE 1=1";

    $params = [];

    if (!empty($project_id)) {
        $sql .= " AND p.id = ?";
        $params[] = $project_id;
    }

    if (!empty($academic_year)) {
        $sql .= " AND ps.academic_year = ? AND p.academic_year = ?";
        $params[] = $academic_year;
        $params[] = $academic_year;
    }

    $query = $this->db->query($sql, $params);

    if (!$query) {
        // Debugging the actual DB error
        $db_error = $this->db->error();
      
        return [];
    }

    return $query->result_array();
}
  
public function get_enrollment_by_studid($stud_id)
{
    $DB1 = $this->load->database('umsdb', TRUE);
    $q = $DB1->get_where('student_master', ['stud_id' => $stud_id]);
    if ($q->num_rows() > 0) {
        return $q->row()->enrollment_no;
    }
    return null;
}


public function get_assigned_project_ids($academic_year)
{
    $this->db->select('DISTINCT(project_details_id)');
    $this->db->from('project_student_details');
    $this->db->where('academic_year', $academic_year);
    $query = $this->db->get();
    
    return array_column($query->result_array(), 'project_details_id');
}


public function get_project_assignment_counts($academic_year)
{
    $sql = "SELECT project_details_id AS project_id, COUNT(*) AS cnt
            FROM project_student_details
            WHERE academic_year = ?
            GROUP BY project_details_id";
    $rows = $this->db->query($sql, [$academic_year])->result_array();
    $out = [];
    foreach ($rows as $r) { $out[(int)$r['project_id']] = (int)$r['cnt']; }
    return $out;
}


public function get_projects_for_dropdown($acad = '')
{
    if (empty($acad)) { $acad = ACADEMIC_YEAR; }

    $this->db->select('project_details.id, project_details.project_title, project_details.domain');
    $this->db->from('project_details');

    $role_id = $this->session->userdata('role_id');
    if ($role_id != '1' && $role_id != '58' && $role_id != '10' && $role_id != '20'  && $role_id != '53') {
        $this->db->where('project_details.faculty_id', $this->session->userdata('name'));
    } elseif ($role_id == '10') {
        $emp_id = $this->session->userdata('name');
        $ex     = explode('_', $emp_id);
        $sccode = $ex[1] ?? '';
        $this->db->where('project_details.school', $sccode);
    }
	elseif ($role_id === '20') {
    $uid = (int)$this->session->userdata('uid');
	    $this->db->group_start()
         ->where('project_details.faculty_id',$this->session->userdata('name'))
        ->or_where('project_details.created_by', $uid)
    ->group_end();
}

    $this->db->where('project_details.academic_year', $acad);
    $this->db->order_by('project_details.project_title', 'asc');
	
	

    return $this->db->get()->result_array();
}

public function get_projects_by_stream(int $stream_id, $academic_year = null)
{
    $this->db->select('id, project_title, domain');
    $this->db->from('project_details');
    $this->db->where('stream_id', $stream_id);
    if (!empty($academic_year)) {
        $this->db->where('academic_year', $academic_year);
    }
    $this->db->order_by('project_title', 'ASC');
    return $this->db->get()->result_array();
}
 public function list_timetable($filters = [])
    {
        $this->db->select('pt.*, pd.project_title, pd.domain, ts.from_time, ts.to_time,"" as slot_am_pm');
        $this->db->from('project_timetable pt');
        $this->db->join('project_details pd', 'pd.id = pt.project_id', 'left');
        $this->db->join('project_slot ts', 'ts.proj_slot_id = pt.proj_slot_id', 'left');

        if (!empty($filters['academic_year'])) $this->db->where('pt.academic_year', $filters['academic_year']);
        if (!empty($filters['project_id']))    $this->db->where('pt.project_id',    $filters['project_id']);
		
		$role_id = $this->session->userdata('role_id');
		 if ($role_id != '1' && $role_id != '58' && $role_id != '20' && $role_id != '10' && $role_id != '53' ) {
        $this->db->where('pd.faculty_id', $this->session->userdata('name'));
    }
	elseif ($role_id === '20') {
		$emp_id=$this->session->userdata("aname");
		$get_details_of_school=$this->Subject_model->loadempschool($emp_id);
		if(!empty($get_details_of_school)){
		$sccode =$get_details_of_school[0]['school_code'];
		}	
		
    $uid = (int)$this->session->userdata('uid');
	    $this->db->group_start()
         ->where('pd.faculty_id',$this->session->userdata('name'))
        ->or_where('pd.school', $sccode)
    ->group_end();
}
elseif ($role_id === '10') {
    $emp_id = $this->session->userdata("name");
	$ex =explode("_",$emp_id);
	$sccode = $ex[1];
		$this->db->where('pd.school', $sccode);
		
}

        $this->db->order_by('FIELD(pt.wday,"Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday")', null, false);
        $this->db->order_by('pt.proj_slot_id','ASC');

        $query = $this->db->get();
		
		//echo $this->db->last_query(); // Show the SQL it tried to run
    //echo $this->db->error()['message']; // Show the error message
    //exit;
		
if (!$query) {
    //echo $this->db->last_query(); // Show the SQL it tried to run
    //echo $this->db->error()['message']; // Show the error message
    //exit;
}
return $query->result_array();
    }
	
	
	public function get_row($id)
{
    return $this->db->get_where('project_timetable', ['id' => (int)$id])->row_array();
}


public function get_faculties_by_year($academic_year)
{
	
    $role = $this->session->userdata("role_id");

$this->db->select("DISTINCT vf.emp_id, CONCAT(vf.fname,' ',vf.mname,' ',vf.lname) AS fac_name", false)
    ->from('project_details pd')
    ->join('sandipun_ums.vw_faculty vf', 'vf.emp_id = pd.faculty_id', 'left')
    ->where('pd.academic_year', $academic_year);

if (in_array($role, [21, 44])) {
    $this->db->where('vf.emp_id', $this->session->userdata("aname"));
}

return $this->db->order_by('fac_name', 'ASC')
    ->get()
    ->result_array();
		
		
}

public function get_faculty_daywise_report($academic_year, $faculty_id)
{
    $this->db->select('
        pt.id,
        pt.wday,
        pt.proj_slot_id,
        pt.building_name,
        pt.floor_no,
        pt.room_no,
        pd.project_title,
        pd.domain,
        ps.from_time,
        ps.to_time
    ');
    $this->db->from('project_timetable pt');
    $this->db->join('project_details pd', 'pd.id = pt.project_id', 'inner');
    $this->db->join('project_slot ps', 'ps.proj_slot_id = pt.proj_slot_id', 'left'); // adjust table name if different
    $this->db->where('pd.academic_year', $academic_year);
    $this->db->where('pd.faculty_id', $faculty_id);
    // If you use soft delete:
    if ($this->db->field_exists('status', 'project_timetable')) {
        $this->db->where('pt.status', 'Y');
    }

    // Order by weekday then time
    $this->db->order_by("CASE pt.wday
        WHEN 'Monday' THEN 1
        WHEN 'Tuesday' THEN 2
        WHEN 'Wednesday' THEN 3
        WHEN 'Thursday' THEN 4
        WHEN 'Friday' THEN 5
        WHEN 'Saturday' THEN 6
        WHEN 'Sunday' THEN 7
        ELSE 8 END", '', false);
    $this->db->order_by('ps.from_time', 'ASC');

    $q = $this->db->get();
	
	
    return $q ? $q->result_array() : [];
}

  
}

?>