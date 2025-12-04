<?php

class Phd_results_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    } 
	
    function getStudentSubjectMarks($var,$exam_month,$exam_year, $exam_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $where=" WHERE 1=1 ";
        // echo $stud_id;exit;
        $sem = $var['semester'];
        $stream_id = $var['admission-branch'];
        
        if(!empty($var)){
            $where.=" AND sas.semester='".$sem."' and sas.stream_id='$stream_id' and sas.exam_id='".$exam_id."' and sas.allow_for_exam='Y'";
        }
        
        $sql="SELECT sas.stud_id,sas.semester, vw.stream_name, vw.school_short_name, vw.stream_short_name, sas.enrollment_no, sas.subject_id, sm.subject_code1, subject_name, sm.subject_short_name,s.first_name, s.middle_name, s.last_name FROM `phd_exam_applied_subjects` as sas
		left join subject_master sm on sm.sub_id=sas.subject_id
		left join student_master s on s.stud_id=sas.stud_id
        left join vw_stream_details as vw on vw.stream_id = sas.stream_id
		$where";
		$sql.=" order by sas.stud_id ";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
    }

    function fetch_result_data($result_data) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[2];
        $exam_month =$res_data[3];
        $exam_year =$res_data[4];
		$exam_id =$res_data[5];
        $where=" where sas.semester='".$semester."' AND sas.exam_month='$exam_month' AND sas.exam_year='$exam_year'and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' and sas.allow_for_exam='Y'";

        $sql="SELECT sas.subject_id FROM `phd_exam_applied_subjects` as sas
        $where";
        $sql.=" group by sas.subject_id";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function fetch_theory_marks($subjectId, $stream, $semester, $exam_month, $exam_year)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT m.*, s.subject_code1 FROM phd_marks_entry m left join subject_master s on s.sub_id=m.subject_id where m.subject_id='" . $subjectId . "' AND m.exam_month='" . $exam_month . "' AND m.exam_year='" . $exam_year . "' AND m.stream_id ='" . $stream . "' AND m.semester ='" . $semester . "'";           
        $sql .= " AND marks_type='TH'";
 
        $query = $DB1->query($sql);        
       // echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
    function fetch_cia_marks($sub_id, $stream, $semester, $exam_month, $exam_year)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM phd_marks_entry_cia where subject_id='".$sub_id."' AND exam_month='" . $exam_month . "' AND exam_year='" . $exam_year . "' AND stream_id ='" . $stream . "' AND semester ='" . $semester . "'";
    
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
    function check_for_duplicate_marks($stud_id,$subject_id, $stream, $semester, $exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM phd_exam_result_data where student_id ='$stud_id' and subject_id='".$subject_id."' AND exam_id='" . $exam_id . "' AND stream_id ='".$stream."' AND semester ='".$semester."'";
    
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        
        return $query->result_array();
    }
    function check_for_duplicate_result($stream, $semester, $exam_month, $exam_year,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM phd_exam_result_details where stream_id ='".$stream."' AND semester ='".$semester."' and exam_id='".$exam_id."'";
    
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function get_result_stream_data($stream_id,$exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);
        $role_id = $this->session->userdata('role_id');
        $emp_id = $this->session->userdata("name");       
        $sql = "SELECT ed.stream_id, vw.stream_short_name, ed.semester,ed.ready_for_result, ed.result_regenerated, ed.result_generated,ed.is_verified,ed.res_detail_id FROM `phd_exam_result_details` as ed left join vw_stream_details vw on vw.stream_id = ed.stream_id where ed.stream_id='".$stream_id."' AND ed.exam_id='".$exam_id."' ORDER BY ed.`semester` ASC ";        
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
    function fetch_result_data_for_grade($result_data) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[5];
        $exam_month =$res_data[2];
        $exam_year =$res_data[3];
		$exam_id =$res_data[4];
		
        $where=" where sas.semester='".$semester."' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id'";

        $sql="SELECT distinct sas.student_id FROM `phd_exam_result_data` as sas
        $where ";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }     
    function fetch_gread_rule($stream_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT grade_rule,grade_id FROM `stream_grade_criteria` where stream_id='$stream_id'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }   

    function fetch_grade($stud_f_mrks,$grd_rule) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `grade_policy_details` where $stud_f_mrks between min_range and max_range and rule='$grd_rule'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    function fetch_grade_pharma($stud_f_mrks,$grd_rule) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `grade_policy_details_pharma` where $stud_f_mrks between min_range and max_range and rule='$grd_rule'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    function update_reslt_grade($subject,$semester,$stream,$exam_id,$stud_id, $data){
        $DB1 = $this->load->database('umsdb', TRUE);
        
        $where = "subject_id='$subject' and semester='$semester' and stream_id='$stream' and exam_id='$exam_id' AND student_id='$stud_id'";
        $DB1->where($where);        
        $DB1->update('phd_exam_result_data', $data);
        //echo $DB1->last_query();echo "<br>break";
        return true;
    }
    function fetch_reslt_subjects($result_data, $student_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[5];
        $exam_month =$res_data[2];
        $exam_year =$res_data[3];
		$exam_id =$res_data[4];

        $sql="SELECT subject_id, final_garde_marks,subject_code,cia_marks,exam_marks,result_grade,final_grade FROM `phd_exam_result_data` where semester='".$semester."' AND exam_id='$exam_id' and stream_id='$stream_id' and student_id='$student_id'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    // subject max marks  
    function fetch_subject_marks($subject_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);
        $sql="SELECT sub_max, theory_max FROM `subject_master` where sub_id='$subject_id'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    // chech for duplicate 
    function check_for_duplicate_result_entry($stud_id, $stream, $semester, $exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM phd_exam_result_master where student_id ='$stud_id' AND exam_id='".$exam_id."' AND stream_id ='".$stream."' AND semester ='".$semester."'";
    
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;
        
        return $query->result_array();
    }
    // fetch subjects of semester
    function fetch_subjects_exam_semester($result_data,$arr_students) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);
		
		$arr_stud = implode(', ', $arr_students);
		
        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[5];
        $exam_month =$res_data[2];
        $exam_year =$res_data[3];
		$exam_id =$res_data[4];
		$academic_year=2019;
		
		/*if($stream_id !='71'){
			if($semester=='1' || $semester=='2'){
				$batch = $academic_year;
			}else if($semester=='3' || $semester=='4'){
				$batch = $academic_year-1;
			}else if($semester=='5' || $semester=='6'){
				$batch = $academic_year-2;
			}else if($semester=='7' || $semester=='8'){
				$batch = $academic_year-3;
			}
		}else{
			if($semester=='1'){
				$batch = $academic_year;
			}else if($semester=='2'){
				$batch = $academic_year-1;
			}else if($semester=='3'){
				$batch = $academic_year-2;
			}else if($semester=='4'){
				$batch = $academic_year-3;
			}
			
		}*/

        $sql="SELECT distinct e.subject_id, s.subject_code1,s.subject_code,s.subject_component,s.subject_name,s.subject_short_name,s.practical_min_for_pass,s.theory_max,s.theory_min_for_pass,s.internal_max,s.internal_min_for_pass,s.sub_min,s.sub_max,s.credits FROM `phd_exam_result_data` e left join subject_master s on e.subject_id= s.sub_id where e.semester='".$semester."' and e.exam_id='$exam_id' AND e.stream_id='$stream_id' ";//and s.batch='$batch'
		
		if(!empty($arr_stud)){
			$sql .=" and e.student_id in($arr_stud)";
		}
		$sql .="  order by s.subject_order asc";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    // fetch student result data
    function fetch_studen_result_data($result_data,$batch) {
//echo $batch;
        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);
        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[5];
        $exam_month =$res_data[2];
        $exam_year =$res_data[3];
		$exam_id =$res_data[4];
		
        $where=" where sas.semester='".$semester."' AND  sas.stream_id='$stream_id' and sas.exam_id='$exam_id' "; //and s.admission_session='$batch' for batch wise condition
		
        /*if($batch=='2019'){
			if($stream_id =='71' && $semester =='1'){
				$where .=" and s.admission_session='2019'";
			}else{
				$where .=" and s.current_year=1 ";//and s.admission_session='$batch'
			}
			
		}elseif($batch=='2018'){
			if($stream_id =='71' && $semester =='2'){
				$where .=" and s.admission_session='2018'";
			}else{
				$where .=" and s.current_year=2";
			}
		}elseif($batch=='2017'){
			if($stream_id =='71' && $semester =='3'){
				$where .=" and s.admission_session='2017'";
			}else{
				if($stream_id =='26' && $batch =='2017' && $semester =='3'){
				$where .=" and s.current_year=2 and s.admission_session='2017'";
				}else{
				$where .=" and s.current_year=3";
				}
			}
		}else{
			$where .=" and s.current_year=4";
		}*/
		//$where .=" and s.current_year=$batch";
        $sql="SELECT sas.*,s.first_name, s.middle_name, s.last_name,s.admission_session,s.current_semester,rm.sgpa,rm.grade_points_avg FROM `phd_exam_result_data` as sas 
		left join phd_exam_result_master rm on rm.student_id=sas.student_id and rm.exam_id=sas.exam_id and rm.semester =sas.semester
		left join student_master s on s.stud_id=sas.student_id
        $where group by sas.student_id";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
    // fetch students subject marks
    function fetch_stud_sub_marks($student_id, $subject_id, $exam_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        // $res_data = explode('~', $result_data);

        // $school_code  =$res_data[0];
        // $stream_id =$res_data[1];
        // $semester =$res_data[4];
        // $exam_month =$res_data[2];
        // $exam_year =$res_data[3];

        $sql="SELECT subject_id,practical_marks,cia_garde_marks,final_garde_marks,subject_code,cia_marks,exam_marks,result_grade,final_grade FROM `phd_exam_result_data` where student_id='".$student_id."' AND subject_id='$subject_id' AND exam_id='$exam_id'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
    // fetch subject details
    function fetch_subject_details($subject_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        //$res_data = explode('~', $result_data);
        $sql="SELECT * FROM `subject_master` where sub_id='$subject_id' and is_active='Y'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    
    // fetch students from exam applied
    function fetch_students_from_exam_applied($result_data) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[2];
        $exam_month =$res_data[3];
        $exam_year =$res_data[4];
		$exam_id =$res_data[5];

        $where=" where sas.semester='".$semester."' AND sas.stream_id='$stream_id' and sas.exam_id='".$exam_id."' and sas.allow_for_exam='Y'";

        $sql="SELECT sas.stud_id FROM `phd_exam_applied_subjects` as sas
        $where";
        $sql.=" group by sas.stud_id";
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;
        return $query->result_array();
    }
    // fetch exam appled student subjects
    function fetch_stud_exam_applied_subjects($result_data, $student_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[2];
        $exam_month =$res_data[3];
        $exam_year =$res_data[4];
		$exam_id =$res_data[5];
		
        $where=" where semester='".$semester."' AND exam_month='$exam_month' AND exam_year='$exam_year'and stream_id='$stream_id' and exam_id='$exam_id' and stud_id='$student_id' and allow_for_exam='Y'";

        $sql="SELECT subject_id FROM `phd_exam_applied_subjects`
        $where";
        
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }  
    // fetch theory marks for result generation
    function fetch_theory_marks_for_result($student_id, $subjectId, $stream, $semester, $exam_month, $exam_year)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT m.*, s.subject_code as subject_code1 FROM phd_marks_entry m left join subject_master s on s.sub_id=m.subject_id where m.subject_id='" . $subjectId . "' AND m.exam_month='" . $exam_month . "' AND m.exam_year='" . $exam_year . "' AND m.stream_id ='" . $stream . "' AND m.semester ='" . $semester . "' and stud_id='$student_id'";           
        //$sql .= " AND marks_type='TH'";
 
        $query = $DB1->query($sql);        
        
        return $query->result_array();
        
    }
    // fetch cia marks for result generation
    function fetch_cia_marks_for_result($student_id,$sub_id, $stream, $semester, $exam_month, $exam_year)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM phd_marks_entry_cia where subject_id='".$sub_id."' AND exam_month='" . $exam_month . "' AND exam_year='" . $exam_year . "' AND stream_id ='" . $stream . "' AND semester ='" . $semester . "' and stud_id='$student_id'";
    
        $query = $DB1->query($sql);
        return $query->result_array();
        
    } 
    // update result grades
    function update_resltsubject_grace($subject,$semester,$stream,$exam_id,$stud_id, $data){
        $DB1 = $this->load->database('umsdb', TRUE);
        
        $where = "subject_id='$subject' and semester='$semester' and stream_id='$stream' and exam_id='$exam_id' AND student_id='$stud_id'";
        $DB1->where($where);        
        $DB1->update('phd_exam_result_data', $data);
        return true;
    } 
    // update forworded marks
    function update_mrks_forwarded($subject,$semester,$stream,$exam_month,$exam_year,$stud_id, $data){
        $DB1 = $this->load->database('umsdb', TRUE);
        $where = "subject_id='$subject' and semester='$semester' and stream_id='$stream' and exam_month='$exam_month' and exam_year='$exam_year' AND student_id='$stud_id'";
        $DB1->where($where);        
        $DB1->update('phd_exam_result_data', $data);
		//echo $DB1->last_query();exit;
        return true;
    } 
	//getresltSchools
	 function getresltSchools(){
        $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT erm.school_code, vw.school_short_name FROM phd_exam_details erm left join vw_stream_details vw on vw.stream_id = erm.stream_id";	
		$query = $DB1->query($sql);
		return $query->result_array();
    } 
	// fetch exam streams
	function load_resultstreams($course_id, $exam_session){
		$DB1 = $this->load->database('umsdb', TRUE);
		$exam = explode('-', $exam_session);
		$exam_id= $exam[2];
		$sql = "select distinct ed.stream_id, vsd.stream_name, vsd.stream_short_name from phd_exam_result_master ed left join vw_stream_details as vsd on ed.stream_id = vsd.stream_id where vsd.course_id='".$course_id."' and ed.exam_id='$exam_id'";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	// fetch result strams
	function load_resultsemesters($stream_id, $exam_session){
		$DB1 = $this->load->database('umsdb', TRUE);
		$exam = explode('-', $exam_session);
		$exam_id= $exam[2];
		$sql = "select distinct semester from phd_exam_result_master  where stream_id='".$stream_id."' and exam_id='$exam_id' order by semester asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	// fetch result student
		function list_result_students($var,$exam_month, $exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$stream_id = $var['admission-branch'];
		$semester = $var['semester'];
		$batch = $var['regulation'];
		$sql = "select distinct erm.student_id as stud_id,s.enrollment_no,UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as stud_name,e.semester from phd_exam_details e  
		inner join student_master s on s.stud_id = e.stud_id
		inner join phd_exam_result_data as erm on e.stud_id = erm.student_id and e.exam_id=erm.exam_id
		where e.stream_id='".$stream_id."' and e.exam_id='".$exam_id."' and e.semester ='".$semester."' group by e.stud_id order by e.stud_id asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	
	//added by jugal
	function fetch_student_grades($stud,$exam_id)
	{
	$DB1 = $this->load->database('umsdb', TRUE);
	$DB1->select('*');
    $DB1->from('phd_exam_result_master');
     $DB1->where('student_id',$stud);
    $DB1->where('exam_id',$exam_id);
    
       $DB1->order_by('semester');
    	$query=$DB1->get();
		$result=$query->result_array();
	foreach($result as $result1)
	{
	    $sem = $result1['semester'];
	   $arr[$sem]= $result1;
	}

		return $arr;

	}
	
	//
	//fetch_student_grade_details
	function fetch_student_unique_result_semester($stud,$exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct semester from phd_exam_result_data where exam_id <='".$exam_id."' AND student_id='".$stud."' and is_deleted='N'";
		$query = $DB1->query($sql);
		$res = $query->result_array();
		return $res;
	}
function fetch_student_subject_completion($stud_id,$semester_post=''){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$academic_year=$this->config->item('academic_current_year');
		$role_id = $this->session->userdata('role_id');
if($semester_post!=''){
	$sem=" and sas.semester<='$semester_post'";
}else{
	$sem="";
}		
		$sql="SELECT sas.stud_id as student_id, sm.subject_name, sm.sub_id, sm.subject_code,sm.semester,sm.credits,sm.batch FROM student_applied_subject sas 
		inner join `subject_master` as sm on sm.sub_id = sas.subject_id
		WHERE sas.is_active='Y' and sas.stud_id='$stud_id' $sem AND sm.is_active='Y' and sm.credits!=0 and subject_id not in(select distinct subject_id from exam_result_data where student_id='".$stud_id."' and is_deleted ='N')";//(sas.academic_year !='$academic_year')
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}	
	
	function fetch_student_grade_details($stud, $stream_id,$semester,$exam_id)
	{
	   // $this->fetch_student_grades($stud,$exam_id);
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct(s.enrollment_no),s.stud_id, UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as stud_name, s.gender,s.dob,s.admission_session,s.admission_stream,s.current_semester,s.mother_name,s.middle_name,vw.stream_name, vw.stream_short_name,vw.school_name,vw.specialization,vw.gradesheet_name, erd.attendance_grade, erd.exam_month,erd.exam_year,    erd.semester,erd.stream_id,erd.exam_id,sm.subject_code,sm.sub_id,sm.subject_component,sm.credits,sm.subject_category,sm.subject_name,erm.credits_registered,erm.credits_earned,erm.grade_points_earned,erm.grade_points_avg, erm.cumulative_credits,cumulative_gpa,erm.sgpa,erm.markscard_issued, erd.final_grade, erd.cia_marks, erd.exam_marks, erd.final_garde_marks 
		from phd_exam_result_data as erd 
		left join student_master as s on s.stud_id =erd.student_id
		left join subject_master sm on sm.sub_id =erd.subject_id
		left join phd_exam_result_master erm on erm.student_id =erd.student_id and erd.exam_id= erm.exam_id	AND erm.semester=erd.semester
		left join vw_stream_details vw on vw.stream_id =erd.stream_id
		where erd.exam_id='".$exam_id."' AND erd.student_id='".$stud."' and erd.is_deleted='N' ";
		if($stream_id =='106' || $stream_id =='105'){
		
		}else{
			$sql .= " AND erd.stream_id='".$stream_id."' ";
		}
		//{fn TRUNCATE(erm.cumulative_gpa,2)} as cumulative_gpa
		$sql .= " order by s.enrollment_no,erd.semester, sm.subject_order asc";
	//	where erd.stream_id='".$stream_id."' AND erd.semester='".$semester."' AND erd.exam_id='".$exam_id."' AND erd.student_id='".$stud."' order by s.enrollment_no, sm.subject_order asc";
	
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		
	$stream_details[0]['grades']= $this->fetch_student_grades($stud,$exam_id);
		return $stream_details;
	}
	//
		//fetch_student_exam_unique_id
	function fetch_student_exam_unique_id($stud, $stream_id,$semester,$exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT `exam_master_id`,enrollment_no FROM `phd_exam_details` WHERE `stud_id`='".$stud."' and `stream_id`='".$stream_id."' and `semester`='".$semester."' and `exam_id`='".$exam_id."'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	// fetch exam details streams
	function load_edstreams($course_id, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct ed.stream_id, vsd.stream_name, vsd.stream_short_name from phd_exam_details ed left join vw_stream_details as vsd on ed.stream_id = vsd.stream_id where vsd.course_id='".$course_id."'  and ed.exam_id='$exam_id' ";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	// fetch exam details semester
	function load_edsemesters($stream_id, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct semester from phd_exam_details  where stream_id='".$stream_id."' and exam_id='$exam_id' order by semester asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	// fetch exam details course
	function get_edcourses($school_code, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select v.course_id, v.course_name, v.course_short_name from (select DISTINCT stream_id from phd_exam_details where exam_id='$exam_id') as e left join vw_stream_details as v on v.stream_id= e.stream_id  where v.school_code='$school_code' group by v.course_id  order by v.course_name asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	// fetching for comparing TH/PR max marks while grade generation
	function fetch_max_marks_thpr($stream,$exam_id,$semester,$subject)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT max_marks FROM `phd_marks_entry_master` where subject_id='".$subject."' and semester='".$semester."' and exam_id='".$exam_id."' and marks_type in('PR','TH') ";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
	// fetching for comparing cia max marks while grade generation 
    function fetch_max_marks_cia($stream,$exam_id,$semester,$subject)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT max_marks FROM `phd_marks_entry_master` where subject_id='".$subject."' and semester='".$semester."' and marks_type ='CIA' ORDER BY me_id DESC LIMIT 0,1";// and exam_id='".$exam_id."'
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
	//fetch_subject_marks_status
    function fetch_subject_marks_status($stream,$exam_id,$semester,$stud_id)
    {      
        $DB1 = $this->load->database('umsdb', TRUE);
        $where = " WHERE sb.is_active='Y'";
        $where .= " AND s.stream_id='" . $stream . "' AND s.exam_id ='$exam_id' AND s.semester='$semester' and s.stud_id='$stud_id' and s.allow_for_exam='Y'";   
        $sql = "SELECT s.subject_id, CASE WHEN sb.theory_max=0 THEN 'N' ELSE 'Y' END AS th_status, CASE WHEN sb.internal_max=0 THEN 'N' ELSE 'Y' END AS cia_status, CASE WHEN sb.practical_max=0 THEN 'N' ELSE 'Y' END AS pr_status, sb.internal_max, sb.theory_max, sb.practical_max FROM phd_exam_applied_subjects as s LEFT JOIN subject_master sb ON sb.sub_id= s.subject_id $where group by s.subject_id";     
        $query = $DB1->query($sql);   
       // echo $DB1->last_query();exit;   
        return $query->result_array();
        
    } 	
    function get_cia_and_thmarks_details($stud_id, $sub_id, $stream, $semester, $exam_id)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        
        $sql = "SELECT s.enrollment_no,s.stream_id,s.semester,s.subject_id,s.subject_code ,c.cia_marks,c.attendance_marks,m.marks,s.stud_id,s.exam_month,s.exam_year,
sb.theory_max,sb.theory_min_for_pass,sb.internal_max,sb.internal_min_for_pass,sb.sub_min,sb.sub_max,sb.practical_min_for_pass,sb.practical_max
FROM phd_exam_applied_subjects  s 
LEFT JOIN phd_marks_entry_cia c ON c.stud_id=s.stud_id AND s.subject_id=c.subject_id AND c.exam_id=s.exam_id
LEFT JOIN phd_marks_entry m ON m.stud_id=s.stud_id AND s.subject_id=m.subject_id AND s.exam_id=m.exam_id
LEFT JOIN subject_master sb ON sb.sub_id=s.subject_id
WHERE s.exam_id='$exam_id' AND s.stream_id='$stream' AND s.semester='$semester' and s.subject_id='$sub_id' and s.stud_id='$stud_id'";
        
        $query = $DB1->query($sql);
        
        //echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
    
    function get_result_program_analysis($row){
    
       $DB1 = $this->load->database('umsdb', TRUE);
      
       if($row['school_code']!="0"){
           $where.=" where  a.school_code='".$row['school_code']."'";
       }
       if($row['course_id']!="0"){
           $where.=" and a.course_id='".$row['course_id']."'";
       }
       $sql="
	            SELECT a.exam_name,a.school_code,a.course_id,a.stream_short_name,a.semester,COUNT(a.student_id)AS appeared,
                SUM(CASE WHEN a.fail=1 THEN 1 ELSE 0 END)AS sub1,
                SUM(CASE WHEN a.fail=2 THEN 1 ELSE 0 END)AS sub2,
                SUM(CASE WHEN a.fail=3 THEN 1 ELSE 0 END)AS sub3,
                SUM(CASE WHEN a.fail=4 THEN 1 ELSE 0 END)AS sub4,
                SUM(CASE WHEN a.fail=5 THEN 1 ELSE 0 END)AS sub5,
                SUM(CASE WHEN a.fail=6 THEN 1 ELSE 0 END)AS sub6,
                SUM(CASE WHEN a.fail=7 THEN 1 ELSE 0 END)AS sub7,
                SUM(CASE WHEN a.fail=8 THEN 1 ELSE 0 END)AS sub8,
                SUM(CASE WHEN a.fail=9 THEN 1 ELSE 0 END)AS sub9,
                SUM(CASE WHEN a.fail=10 THEN 1 ELSE 0 END)AS sub10,
                SUM(CASE WHEN a.fail=11 THEN 1 ELSE 0 END)AS sub11,
                SUM(CASE WHEN a.withheald=0 THEN 0 ELSE 1 END)AS with_heald,
                SUM(CASE WHEN a.not_done=0 THEN 0 ELSE 1 END)AS not_done,
                SUM(CASE WHEN a.pass=a.sub_total THEN 1 ELSE 0 END)AS all_clear
                FROM (
                SELECT e.exam_name,st.stream_short_name,st.course_id,st.school_code,s.semester,s.student_id,COUNT( s.student_id)AS sub_total,
                SUM(s.is_fail)AS fail,SUM(s.is_withHeld)AS withheald,SUM(s.is_clear)AS pass,SUM(s.is_not_done)AS not_done
                 FROM (
                SELECT student_id,exam_id,stream_id,semester,subject_id,final_grade,
                CASE WHEN final_grade='U' THEN 1 ELSE 0 END AS is_fail,
                CASE WHEN malpractice='Y' THEN 1 ELSE 0 END AS is_withHeld,
                CASE WHEN final_grade NOT IN ('WH','U') THEN 1 ELSE 0 END AS is_clear,
                CASE WHEN final_grade IS NULL THEN 1 ELSE 0 END AS is_not_done
                FROM phd_exam_result_data WHERE exam_id='".$row['exam_session']."' 
                ) s 
                LEFT JOIN vw_stream_details st ON st.stream_id=s.stream_id
                LEFT JOIN phd_exam_session e ON s.exam_id=e.exam_id
                GROUP BY st.stream_short_name,s.semester,s.student_id
                ) a  $where GROUP BY a.stream_short_name,a.semester
                ORDER BY a.semester,a.stream_short_name";
              //  echo $sql ;exit();
	         $query =	$DB1->query($sql);
               $result=$query->result_array();  
            //	echo $DB1->last_query(); exit();
             return $result;
}
    function get_result_course_analysis($row){
    
       $DB1 = $this->load->database('umsdb', TRUE);
      
       if($row['school_code']!="0"){
           $where.=" where  st.school_code='".$row['school_code']."'";
       }
       if($row['course_id']!="0"){
           $where.=" and st.course_id='".$row['course_id']."'";
       }
       $sql="
	            
                SELECT e.exam_name,st.stream_short_name,st.course_id,st.school_code,s.semester,s.subject_id,sb.subject_code,sb.subject_name,sb.subject_order,COUNT( s.student_id)AS sub_total,
                SUM(s.is_fail)AS fail,SUM(s.is_withHeld)AS withheald,SUM(s.is_clear)AS pass,SUM(s.is_not_done)AS not_done
                 FROM (
                SELECT student_id,exam_id,stream_id,semester,subject_id,final_grade,
                CASE WHEN final_grade='U' THEN 1 ELSE 0 END AS is_fail,
                CASE WHEN malpractice='Y' THEN 1 ELSE 0 END AS is_withHeld,
                CASE WHEN final_grade NOT IN ('WH','U') THEN 1 ELSE 0 END AS is_clear,
                CASE WHEN final_grade IS NULL THEN 1 ELSE 0 END AS is_not_done
                FROM phd_exam_result_data WHERE exam_id='".$row['exam_session']."' 
                ) s 
                 LEFT JOIN vw_stream_details st ON st.stream_id=s.stream_id
            LEFT JOIN phd_exam_session e ON s.exam_id=e.exam_id
            LEFT JOIN subject_master sb ON sb.sub_id=s.subject_id
            $where
            GROUP BY st.stream_short_name,s.semester,s.subject_id
           
            ORDER BY st.stream_short_name,s.semester,s.subject_id,sb.subject_order ";
              //echo $sql ;exit();
	         $query =	$DB1->query($sql);
               $result=$query->result_array();  
            //	echo $DB1->last_query(); exit();
             return $result;
}
	// fetch grade details    
    function list_grade_details($rule)
    {       
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT distinct `grade_letter`,grade_point,performance FROM `grade_policy_details` where rule='$rule' order by policy_id";     
        $query = $DB1->query($sql);    
        //echo $DB1->last_query();exit;       
        return $query->result_array();
        
    }
	function list_grade_pharma_details($rule)
    {       
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT distinct `grade_letter`,grade_point,performance FROM `grade_policy_details_pharma` where rule='$rule' order by policy_id";     
        $query = $DB1->query($sql);    
        //echo $DB1->last_query();exit;       
        return $query->result_array();
        
    }
   // student backlog subject list
    function getStudbacklogSubject($stud_id){
        $DB1 = $this->load->database('umsdb', TRUE);  
        $where=" WHERE 1=1 ";  
        
        if($stud_id!=""){
            $where.=" AND erd.student_id='".$stud_id."' AND erd.passed ='N'";
        }       
        $sql="SELECT erd.student_id, sm.subject_name, sm.sub_id, sm.subject_code,sm.semester,erd.exam_id FROM `phd_exam_student_subject` as erd left join subject_master sm on sm.sub_id=erd.subject_id $where";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }  

    // get_arrear_subject_list 
    function get_arrear_subject_list($stream_id,$batch, $exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);       
        $sql="SELECT distinct d.subject_id,ess.semester,sm.subject_name, sm.sub_id,sm.batch, sm.subject_code FROM phd_exam_details ess 
left join `phd_exam_student_subject` as d on d.semester=ess.semester and d.stream_id=ess.stream_id and ess.stud_id=d.student_id
inner join student_master s on s.stud_id=ess.stud_id and s.cancelled_admission='N'
left join subject_master sm on sm.sub_id=d.subject_id
WHERE ess.`stream_id` = '$stream_id' AND d.`passed` = 'N'";  //and ess.exam_id='$exam_id' //d.exam_id=ess.exam_id and
		if($batch!="0"){
            $sql.=" AND sm.batch='".$batch."'";
        }  
		 $sql.=" ORDER BY ess.semester,sm.subject_order";
        $query = $DB1->query($sql);
       //echo $DB1->last_query();exit;
        return $query->result_array();
    }
    // student backlog subject list
    function stud_arrear_sub_applied_list($stream_id,$subject_id, $exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);       
        $sql="SELECT distinct ess.`student_id`, ess.enrollment_no, ess.`semester` FROM `phd_exam_student_subject` as ess 
        left join phd_exam_details d on d.stud_id=ess.student_id and d.semester=ess.semester and d.stream_id=ess.stream_id
        WHERE ess.`stream_id` = '$stream_id' AND ess.`passed` = 'N' and ess.subject_id='$subject_id' ORDER BY ess.`enrollment_no` asc"; //d.exam_id=ess.exam_id and
        $query = $DB1->query($sql);
       //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    // get_arrear_student_list 
    function get_arrear_student_list($stream_id,$batch,$exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);       
        $sql="SELECT distinct ess.student_id,s.enrollment_no,UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as stud_name FROM `phd_exam_student_subject` as ess 
		left join phd_exam_details d on d.exam_id=ess.exam_id and d.stud_id=ess.student_id and d.semester=ess.semester and d.stream_id=ess.stream_id 
		left join student_master s on s.stud_id=ess.student_id 
		left join subject_master sm on sm.sub_id=ess.subject_id
		WHERE ess.`passed` = 'N' and s.cancelled_admission='N' ";//and d.exam_id='$exam_id' 
		if($stream_id !=0){
            $sql .=" and ess.stream_id='$stream_id'";
        } 
		if($batch!="0"){
            $sql.=" AND sm.batch='".$batch."'";
        }  		
        $sql .=" ORDER BY s.enrollment_no"; 
        $query = $DB1->query($sql);
       //echo $DB1->last_query();exit;
        return $query->result_array();
    }
    // student backlog subject list
    function stud_arrear_subject_list($stream_id,$student_id,$batch,$exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);       
        $sql="SELECT DISTINCT d.subject_id,ess.semester,s.subject_name, s.sub_id, s.subject_code, 
s.subject_component,s.sub_min,s.practical_min_for_pass,s.theory_min_for_pass,s.internal_min_for_pass,ed.practical_marks,ed.cia_garde_marks,ed.final_garde_marks,ed.subject_code,ed.cia_marks,ed.exam_marks,ed.result_grade,ed.final_grade
FROM phd_exam_details ess 
LEFT JOIN `phd_exam_student_subject` AS d ON d.semester=ess.semester AND d.stream_id=ess.stream_id AND ess.stud_id=d.student_id
INNER JOIN student_master sm ON sm.stud_id=ess.stud_id AND sm.cancelled_admission='N'
LEFT JOIN subject_master s ON s.sub_id=d.subject_id
LEFT JOIN phd_exam_result_data ed ON ed.student_id=d.student_id AND ed.exam_id=d.exam_id AND ed.subject_id=d.subject_id
WHERE d.`passed` = 'N' and ess.stud_id='$student_id' ";//and ess.exam_id='$exam_id'd.exam_id=ess.exam_id and 
		if($stream_id !=0){
            $sql .=" and ess.stream_id='$stream_id'";
        }  
		if($batch!="0"){
            $sql.=" AND s.batch='".$batch."'";
        }  
		
        $sql .=" ORDER BY ess.semester,s.subject_order"; 
        $query = $DB1->query($sql);
       //echo $DB1->last_query();exit;
        return $query->result_array();
    }
	// get_arrear_stream_list 
    function get_arrear_stream_list($school_code,$course_id,$stream_id, $exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);  
        $sql="SELECT distinct d.stream_id, v.stream_name FROM phd_exam_details ess left join `phd_exam_student_subject` as d on d.exam_id=ess.exam_id and d.semester=ess.semester and d.stream_id=ess.stream_id and ess.stud_id=d.student_id LEFT JOIN vw_stream_details v on v.stream_id=ess.stream_id WHERE d.`passed` = 'N'"; // and ess.exam_id='$exam_id'
		if($school_code !=0){
            $sql .=" and ess.school_code='$school_code'";
        }		
		if($course_id !=0){
            $sql .=" and ess.course_id='$course_id'";
        } 
        if($stream_id !=0){
            $sql .=" and ess.stream_id='$stream_id'";
        }  
        $sql .=" ORDER BY v.stream_name";     
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
//fetch_arrear_students
    function fetch_arrear_students($stream_id, $subject_id, $exam_id){
		//echo $subject_id;
        $DB1 = $this->load->database('umsdb', TRUE);       
        $sql="SELECT DISTINCT ess.student_id,ess.semester,s.enrollment_no,UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as stud_name,
erd.cia_garde_marks,erd.final_garde_marks,erd.subject_code,erd.cia_marks,erd.exam_marks,erd.result_grade,
erd.final_grade,sm.sub_id,sm.subject_component,sm.sub_min,sm.practical_min_for_pass,sm.theory_min_for_pass,sm.internal_min_for_pass,erd.practical_marks 
FROM `phd_exam_student_subject` AS ess 
LEFT JOIN phd_exam_details d ON d.exam_id=ess.exam_id AND d.stud_id=ess.student_id 
left join subject_master sm on sm.sub_id=ess.subject_id
LEFT JOIN phd_exam_result_data erd ON erd.exam_id=ess.exam_id AND erd.student_id=ess.student_id  AND erd.subject_id=ess.subject_id
LEFT JOIN student_master s ON s.stud_id=ess.student_id WHERE ess.`subject_id` = '$subject_id' AND ess.`passed` = 'N' and s.cancelled_admission='N' ";// and d.exam_id='$exam_id' 
		if($stream_id !=0){
            $sql .=" and ess.stream_id='$stream_id'";
        }  
        $sql .=" ORDER BY s.enrollment_no"; 
        $query = $DB1->query($sql);
      // echo $DB1->last_query();exit;
        return $query->result_array();
    }
	//save_gradesheet_log
	function save_gradesheet_log($gd_log){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$DB1->insert('gradesheet_log', $gd_log);
		//echo $DB1->last_query();exit;
		return true;
	}
	//marks card allocation starts
	function list_result_students_for_markcards($var,$exam_month, $exam_year,$exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);
        $stream_id = $var['admission-branch'];
        $semester = $var['semester'];
        $sql = "SELECT DISTINCT 
erm.stud_id AS student_id, 
s.enrollment_no, 
UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as stud_name, 
erm.semester, 
m.markscard_no 
FROM   phd_exam_details AS erm
       left JOIN phd_exam_result_data r ON r.`student_id`=erm.stud_id AND r.exam_id=erm.exam_id AND r.semester=erm.semester
       INNER JOIN student_master s 
              ON s.stud_id = erm.stud_id 
       LEFT JOIN  (SELECT student_id, markscard_no FROM phd_exam_markscard_details where is_active='Y' and exam_id='".$exam_id."') m ON m.student_id = erm.stud_id 
        where erm.stream_id='".$stream_id."' and erm.semester ='".$semester."' and erm.exam_id ='".$exam_id."' order by erm.stud_id asc";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
	function CheckStudIn($stud_id,$exam_id, $stream, $semester)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select student_id from phd_exam_markscard_details  where student_id ='".$stud_id."' and exam_id='".$exam_id."' and semester='".$semester."' and stream_id='".$stream."'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $res = $query->result_array();
        return $res;
    }

    function updateMarksCardsNo($stud,$exam_id, $stream, $semester,$markscardno ='')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $where = "semester='$semester' and stream_id='$stream' and exam_id='$exam_id' AND student_id='$stud'";
        $DB1->where($where);   
        $data =array(
            "is_active" => 'N',
            "modified_by" => $this->session->userdata("uid"),
            "modified_ip" => $_SERVER['REMOTE_ADDR'],
            "modified_on" => date("Y-m-d H:i:s")
        );    
        $DB1->update('phd_exam_markscard_details', $data);
        //echo $DB1->last_query();exit;
        return true;
    }  
    //
    function list_result_students_for_dispatch($stream_id, $semester,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select s.enrollment_no,UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as stud_name,e.markscard_no  from phd_exam_markscard_details e 
        left join student_master s on s.stud_id = e.student_id
        where e.exam_id='".$exam_id."' and e.semester='".$semester."' and e.stream_id='".$stream_id."' and e.is_active='Y' group by e.student_id";

        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $res = $query->result_array();
        return $res;
    }		
		
	///////////////////////////////////////////////////////////////
	function fetch_thobtained_marks($result_data, $student_id,$subject_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[5];
        $exam_month =$res_data[2];
        $exam_year =$res_data[3];
		$exam_id =$res_data[4];

        $sql="SELECT subject_id, marks FROM `phd_marks_entry` where semester='".$semester."' AND exam_id='$exam_id' AND stream_id='$stream_id' and stud_id='$student_id' and marks_type='PR' and subject_id='$subject_id'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function fetch_probtained_marks($result_data, $student_id,$subject_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[5];
        $exam_month =$res_data[2];
        $exam_year =$res_data[3];
		$exam_id =$res_data[4];

        $sql="SELECT subject_id, marks FROM `phd_marks_entry` where semester='".$semester."' AND exam_id='$exam_id' and stream_id='$stream_id' and stud_id='$student_id' and marks_type='TH' and subject_id='$subject_id'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function fetch_ciaobtained_marks($result_data, $student_id,$subject_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[5];
        $exam_month =$res_data[2];
        $exam_year =$res_data[3];
		$exam_id =$res_data[4];

        $sql="SELECT subject_id, cia_marks,attendance_marks FROM `phd_marks_entry_cia` where semester='".$semester."' AND exam_id='$exam_id' and stream_id='$stream_id' and stud_id='$student_id' and subject_id='$subject_id'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function fetch_max_marks_theory($stream,$exam_id,$semester,$subject)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT max_marks FROM `phd_marks_entry_master` where subject_id='".$subject."' and semester='".$semester."' and marks_type in('TH') ORDER BY me_id DESC LIMIT 0,1";// and exam_id='".$exam_id."'
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
	function fetch_max_marks_practcal($stream,$exam_id,$semester,$subject)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT max_marks FROM `phd_marks_entry_master` where subject_id='".$subject."' and semester='".$semester."' and marks_type in('PR') ORDER BY me_id DESC LIMIT 0,1";// and exam_id='".$exam_id."'
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
	// fetching result session
	function fetch_result_exam_session()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('phd_exam_session');
		$DB1->where("active_for_result", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	// fetching with-held results
	function fetch_withheld_result($exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT e.enrollment_no,e.with_held,UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as stud_name,v.stream_name,e.semester FROM `phd_exam_result_data` e
		left join student_master s on s.stud_id = e.student_id 
		LEFT JOIN vw_stream_details v on v.stream_id=e.stream_id 
		where e.exam_id ='$exam_id' and e.with_held='Y' group by e.enrollment_no order by e.stream_id,e.semester ";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
	}
//
    function update_withheld_result($data,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$str_prn = implode(',', $data['chk_stud']);
		//print_r($data);
		//echo $str_prn;exit;
		$exam_id=$data['exam_id'];
		$sql = "UPDATE `phd_exam_result_data` SET final_grade=result_grade,with_held='N' WHERE exam_id ='$exam_id' and enrollment_no IN($str_prn)";
        $query = $DB1->query($sql);
        return true;
    }
/////////////////////////////////////////////////	
	function update_failed_sub_type($stud, $subject_id,$exam_id,$res_fail)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
        $where = "subject_id='$subject_id' and exam_id='$exam_id' AND student_id='$stud'";
        $DB1->where($where);   
        $data =array(
            "failed_sub_type" => $res_fail,
            "modify_by" => $this->session->userdata("uid"),
            "modify_on" => date("Y-m-d H:i:s")
        );    
        $DB1->update('phd_exam_student_subject', $data);
        //echo $DB1->last_query();exit;
        return true;
	}
	//	
	function get_failed_sub_type1($stud, $subject_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT failed_sub_type, grade FROM `phd_exam_student_subject` where subject_id='$subject_id' and exam_id='9' AND student_id='$stud'";
        $query = $DB1->query($sql);
       //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    } 
    // subject max marks  
    function fetchsubject_details($subject_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT sub_max, theory_max,theory_min_for_pass,internal_max,internal_min_for_pass,practical_max,practical_min_for_pass,sub_min FROM `subject_master` where sub_id='$subject_id' and is_active='Y'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
	function fetch_with_held_exam_session($exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		
		$sql="SELECT e.exam_month,e.exam_year,e.exam_id,e.exam_type FROM `phd_exam_result_data`es LEFT JOIN phd_exam_session e ON es.exam_id=e.exam_id WHERE es.with_held='Y' AND es.final_grade='WH' GROUP BY es.exam_id";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit
		
		 return $query->result_array();
	}	
	function fetch_backlog_semesters($prn, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		
		$sql="SELECT semester from phd_exam_student_subject WHERE passed='N' and enrollment_no='$prn' AND  exam_id <='$exam_id'  group by semester";
		$sql .=" UNION ";
		$sql .="SELECT semester FROM phd_exam_result_data WHERE (final_grade='U' OR final_grade='F') AND enrollment_no='$prn' AND exam_id =$exam_id  GROUP BY semester";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit; 
		 return $query->result_array();
	}
	function fetch_student_result_dpharma($stud, $stream_id, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		
		$sql="SELECT semester,stream_id,student_id from phd_exam_result_data WHERE student_id='$stud'"; 
		if($exam_id==7 || $exam_id==8){
			$sql .=" and semester=1";
		}
		$sql .=" group by semester";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
		return $res = $query->result_array();
		
	}
	function fetchDpharmaresult_details($stud, $stream_id,$semester, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		
		$sql="SELECT s.theory_max,s.internal_max,e.*  FROM phd_exam_result_data e
LEFT JOIN subject_master s ON s.sub_id=e.subject_id
 WHERE e.student_id='$stud' AND e.semester='$semester' and e.stream_id='$stream_id'";
		if($exam_id){
			$sql .=" and e.exam_id <= $exam_id";
		}
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
		return $res = $query->result_array();		
	}
	function fetchDpharmaresult_grades($stud, $stream_id,$semester, $exam_id){
		//echo $exam_id;exit;
		$DB1 = $this->load->database('umsdb', TRUE);	
		if($semester==1 && $exam_id=='8'){
			 $sql="SELECT grade as final_grade  FROM phd_exam_student_subject e WHERE e.student_id='$stud' AND e.semester='$semester' and e.stream_id='$stream_id' and passed='N' and exam_id='$exam_id' ";
		}else{
			 $sql="SELECT final_grade  FROM phd_exam_result_data e WHERE e.student_id='$stud' AND e.semester='$semester' and e.stream_id='$stream_id' and exam_id='$exam_id' ";
		}
		//exit;
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
		$res = $query->result_array();
		foreach($res as $rs){
			$f_grade[] = $rs['final_grade'];
		}
		return	$f_grade;	
	}
	
	// fetch defarma no of attempt
	function fetchDpharma_no_of_attempt($stud, $stream_id,$semester,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql="SELECT enrollment_no,subject_id,exam_id,COUNT(subject_id) AS no_of_attempt FROM phd_exam_result_data e WHERE e.student_id='$stud' AND e.semester='$semester' and e.stream_id='$stream_id' and exam_id <='$exam_id' GROUP BY enrollment_no,subject_id HAVING COUNT(subject_id) >1";
		//exit;
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
		$res = $query->result_array();
		return	$res;	
	}
	// fetch defarma no of backlogs
	function fetchDpharma_no_of_bklogs($stud, $stream_id,$semester,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql="SELECT enrollment_no,subject_id FROM phd_exam_result_data WHERE stream_id='$stream_id' AND semester='$semester' AND final_grade='U' and student_id='$stud' and exam_id <='$exam_id'  GROUP BY enrollment_no,subject_id ";
		//exit;
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
		$res = $query->result_array();
		return	$res;	
	}
	///////////////////////////Attendance grade updation/////////////////////////////////////////
	   function get_examresult_data($exam_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT  e.enrollment_no,e.result_id,e.subject_code,e.subject_id, c.attendance_marks,e.attendance_grade 
FROM phd_marks_entry_cia c
LEFT JOIN phd_exam_result_data e ON e.subject_id=c.subject_id AND e.semester=c.semester AND e.enrollment_no=c.enrollment_no and e.exam_id=c.exam_id
WHERE e.exam_id='$exam_id' GROUP BY c.enrollment_no, c.subject_id 
";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    function update_attendance_grade($stud,$exam_id)
    {
    	//print_r($stud);
		if($stud['attendance_marks'] >= 95){
			$att_grade='O';
		}
		if($stud['attendance_marks'] >= 85 && $stud['attendance_marks'] < 95){
			$att_grade='M';
		}
		if($stud['attendance_marks'] < 85){
			$att_grade='S';
		}
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql2="update `phd_exam_result_data` set attendance_grade='$att_grade' WHERE `result_id` ='".$stud['result_id']."' and exam_id='$exam_id' and subject_id='".$stud['subject_id']."'";
        $query2 = $DB1->query($sql2);
       // unset();
        return true;
    }	
	/////////////////////////////////////////////////////////////////////////////////////
	
	 function graphs_new(){
		$DB1 = $this->load->database('umsdb', TRUE);
		 /*$sql2="SELECT 
sm.subject_name,sm.subject_code AS subject_code_master,
COUNT(ex.student_id) AS Total_student,SUM(CASE WHEN ex.grade='U' 
 THEN 1 ELSE 0 END) AS failed, COUNT(ex.student_id) - SUM(CASE WHEN ex.grade='U' 
 THEN 1 ELSE 0 END) AS Pass FROM phd_exam_student_subject AS ex
 LEFT JOIN subject_master AS sm ON ex.subject_id=sm.sub_id
 GROUP BY ex.subject_code
 ORDER BY sm.subject_order ASC";*/
 $sql2="SELECT COUNT(b.failed) AS newd,b.failed FROM 

(SELECT student_id,(SUM(CASE WHEN grade='U' THEN 1 ELSE 0 END)) AS failed FROM phd_exam_student_subject 

GROUP BY student_id 
HAVING failed!=0
ORDER BY failed DESC) AS b GROUP BY b.failed";
 //exit;
   $query = $DB1->query($sql2);
   $r1=$query->result_array();
   $DB2 = $this->load->database('umsdb', TRUE);
		 $sql3="SELECT enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec FROM phd_exam_student_subject GROUP BY student_id";
 //exit;
   $query3 = $DB2->query($sql3);
   $r2=$query3->result_array();
   
     return array($r1,$r2);
       
	}	
	///////////////////////////////////////////////////////////////////////////////////////////////
function calculate_sgpa($examid,$semester,$stream_id)
{
  
 //$names = array(10804);
//$DB1->where_in('ers.enrollment_no', $names);
    $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select("ers.*,sgc.grade_rule");
        $DB1->from('phd_exam_result_master as ers');
        $DB1->join('student_master as sm','ers.student_id = sm.stud_id','left'); 
    $DB1->join('stream_grade_criteria as sgc','sm.admission_stream = sgc.stream_id','left');
    $DB1->where("ers.exam_id",$examid); 
    if($semester !=''){
        $DB1->where("ers.semester",$semester); 
    }
    if($stream_id !=""){
        $DB1->where("ers.stream_id",$stream_id);
    }
    $streamids = array('116', '119');
    $DB1->where_not_in('ers.stream_id', $streamids);
    //$school_arr = array('1002');//'1002', '1004','1009','1010' 
    //$DB1->where_in('ers.school_id', $school_arr);
            //$DB1->where("ers.semester!=",'U');
    // $DB1->where_in('ers.student_id', $names);
        $query=$DB1->get();
    //echo $DB1->last_query();exit();
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
		//$DB1->join('grade_policy_details as gpd','erd.result_grade = gpd.grade_letter','left');
		$DB1->where("erd.student_id",$mydata['student_id']); 
		$DB1->where('gpd.rule', $mydata['grade_rule']); 
		if($semester !=''){
			$DB1->where("erd.semester",$semester); 
		}    
			 $DB1->where("erd.exam_id <=",$examid); 
			
				$DB1->where("erd.final_grade!=",'U');
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
		$DB1->where('student_id', $result1['student_id']);
		$DB1->where('exam_id', $examid);
		if($semester !=''){
			$DB1->where("semester",$semester); 
		}    
		$DB1->update('phd_exam_result_master',$dataupdate);            
				
		//echo $DB1->last_query();

	}
   
}
public function calculate_cgpa($examid, $stream_id)
{
	//$names = array(10804);
	//$DB1->where_in('ers.enrollment_no', $names);

    $DB1 = $this->load->database('umsdb', TRUE);
	$DB1->select("ers.*,sgc.grade_rule");
	$DB1->from('phd_exam_result_master as ers');
	$DB1->join('student_master as sm','ers.student_id = sm.stud_id','left'); 
	$DB1->join('stream_grade_criteria as sgc','sm.admission_stream = sgc.stream_id','left');
	$DB1->where("ers.exam_id",$examid);
	if($stream_id !=""){
		$DB1->where("ers.stream_id",$stream_id);
	}	
	$streamids = array('116', '119');
	$DB1->where_not_in('ers.stream_id', $streamids);
	//$school_arr = array('1002');
	//$DB1->where_in('ers.school_id', $school_arr);
	//$DB1->where_in('ers.student_id', $names);
	 	//$DB1->where("ers.st",$examid); 
		$query=$DB1->get();
		
			$result=$query->result_array();	
//echo $DB1->last_query();
//exit();
	foreach($result as $mydata)
	{

	$DB1->select("erd.enrollment_no,erd.student_id,erd.exam_id,erd.final_grade,erd.subject_id,erd.subject_code,sm.credits,gpd.grade_point,sum(sm.credits) as total_credits,
	sum(gpd.grade_point) as total_grade,sum(sm.credits*gpd.grade_point) as sumcredit,sum(case when gpd.grade_point=0 then 0 else sm.credits end ) as credit_earned,
	");
		$DB1->from('phd_exam_result_data as erd');
		$DB1->join('subject_master as sm','erd.subject_id = sm.sub_id','left'); 
	$DB1->join('grade_policy_details as gpd','erd.final_grade = gpd.grade_letter','left');
	//$DB1->join('grade_policy_details as gpd','erd.result_grade = gpd.grade_letter','left');
	$DB1->where("erd.student_id",$mydata['student_id']); 
	$DB1->where('gpd.rule', $mydata['grade_rule']); 
	$DB1->where("erd.exam_id<=",$examid); 
	
			$DB1->where("erd.final_grade!=",'U');
		$query2=$DB1->get();

	$result2=$query2->row_array();

	if($result2['credit_earned']==0)	
	{
		$tcgpa=0;
	}
	else
	{
	 $tcgpa = bcdiv($result2['sumcredit'],$result2['credit_earned'], 4); 	
	}	  
	
	$dupdate['cumulative_credits']=$result2['sumcredit'];
	$dupdate['cumulative_gpa']=$tcgpa;

    $DB1->where('student_id', $result2['student_id']);
    $DB1->where('exam_id', $examid);
	$DB1->update('phd_exam_result_master',$dupdate);   

	}  
}
public function calculate_gpa($examid,$semester, $stream_id='')
{
     //$names = array(10804);
//$DB1->where_in('ers.enrollment_no', $names);
 //$names = array('170101092107',170101082038);
   $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("ers.*,sgc.grade_rule");
		$DB1->from('phd_exam_result_master as ers');
		$DB1->join('student_master as sm','ers.student_id = sm.stud_id','left'); 
	$DB1->join('stream_grade_criteria as sgc','sm.admission_stream = sgc.stream_id','left');
	$DB1->where("ers.exam_id",$examid); 
	$streamids = array('116', '119');
	$DB1->where_not_in('ers.stream_id', $streamids);
	//$school_arr = array('1002');
	//$DB1->where_in('ers.school_id', $school_arr);
	//$DB1->where_in('ers.student_id', $names);
	if($stream_id !=""){
		$DB1->where("ers.stream_id",$stream_id);
	}
	if($semester !=""){
		$DB1->where("ers.semester",$semester);
	}
	 	 
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
	//$DB1->join('grade_policy_details as gpd','erd.result_grade = gpd.grade_letter','left');
	$DB1->where("erd.student_id",$mydata['student_id']); 
	$DB1->where('gpd.rule', $mydata['grade_rule']); 
	if($semester !=""){
		$DB1->where("erd.semester",$semester);
	}

	if($stream_id !=""){
		$DB1->where("erd.stream_id",$stream_id);
	}
	$DB1->where("erd.exam_id",$examid); 		

			//$DB1->where("erd.result_grade!=",'U');
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

	$dupdate['credits_registered']=$result1['total_credits'];
		  $dupdate['credits_earned']=$result1['credit_earned'];
		 $dupdate['grade_points_earned']=$result1['total_grade'];
		 $dupdate['grade_points_avg']=$cgpa;

			$DB1->where('student_id', $result1['student_id']);
			  $DB1->where('exam_id', $examid);
			  if($semester !=""){
					$DB1->where("semester",$semester);
				}
	$DB1->update('phd_exam_result_master',$dupdate);   

		}
	}
    function fetch_exam_allsession()
    {       
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM phd_exam_session where deleted ='N'";     
        $query = $DB1->query($sql);    
        //echo $DB1->last_query();exit;       
        return $query->result_array();
        
    } 
	function fetch_credits_earned($enrollment_no, $exam_id){
		
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select  sum(credits_earned) as credits_earned  from phd_exam_result_master WHERE `student_id` = '$enrollment_no' and exam_id <= $exam_id";     
        $query = $DB1->query($sql);    
        //echo $DB1->last_query();exit;       
        return $query->result_array();
	}	
	function fetch_student_backlog_grade_details($stud,$exam_id){
		//echo $exam_id;exit;
		$DB1 = $this->load->database('umsdb', TRUE);	
		
		$sql="SELECT distinct grade as final_grade  FROM phd_exam_student_subject e WHERE e.student_id='$stud' and passed='N' and exam_id <='$exam_id'";
		//exit;
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
		$res = $query->result_array();
		foreach($res as $rs){
			$f_grade[] = $rs['final_grade'];
		}
		return	$f_grade;	
	}
	function fetch_student_backlog_grade_from_result_data($stud,$exam_id){
		//echo $exam_id;exit;
		$DB1 = $this->load->database('umsdb', TRUE);	
		$f_grade1 =array();
		$sql="SELECT subject_id
FROM `phd_exam_result_data`
WHERE `student_id` = '$stud' and exam_id <='$exam_id' group by subject_id";
		//exit;
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
		$res = $query->result_array();
		foreach($res as $rs){
			$subid=$rs['subject_id'];
			$sql1="SELECT final_grade,semester,subject_id
FROM `phd_exam_result_data`
WHERE `student_id` = '$stud' and exam_id <='$exam_id' and subject_id='$subid' order by result_id desc limit 0,1";
		$query1 = $DB1->query($sql1);
		$res1[] = $query1->result_array();
			/*foreach($res1 as $rs11){
			$f_grade1[] = $rs11['final_grade'];
			$f_sem1[] = $rs11['semester'];
		}*/
		
		}	
		//echo '<pre>';print_r($f_grade1);exit;
		return	$res1;
	}
	//Delete Result 
	function deleteResult($stream_id,$semester,$exam_id){
		$DB1 = $this->load->database('erpdel', TRUE);	
		$sql="DELETE FROM phd_exam_result_details WHERE semester='$semester' and stream_id='$stream_id' and exam_id ='$exam_id'";
        $query = $DB1->query($sql);
		$sql1="DELETE FROM phd_exam_result_data WHERE semester='$semester' and stream_id='$stream_id' and exam_id ='$exam_id'";
        $query1 = $DB1->query($sql1);
		$sql2="DELETE FROM phd_exam_result_master WHERE semester='$semester' and stream_id='$stream_id' and exam_id ='$exam_id'";
        $query2 = $DB1->query($sql2);
        //echo $DB1->last_query();exit;
	}

     function list_result_students_for_degree($var,$exam_month, $exam_year,$exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);
        $stream_id = $var['admission-branch'];
        $semester = $var['semester'];
        $batch = $var['regulation'];
        $sql = "select distinct e.student_id as stud_id,s.enrollment_no,UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as stud_name,e.semester,pd.student_id as certificate_dispatch,certificate_dispatch as dispatch_no from 
        phd_exam_result_master e  
        inner join student_master s on s.stud_id = e.student_id
        #inner join phd_exam_result_data as erm on e.student_id = erm.student_id and e.exam_id=erm.exam_id
		left join phd_degreecertficate_assgin_details pd on pd.student_id=e.student_id
        where e.stream_id='".$stream_id."' and e.exam_id='".$exam_id."'  group by e.student_id order by e.student_id asc";
        //and e.semester ='".$semester."'
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
	
	public function fetch_student_ce_earnd_semester($stdid,$semester,$exam_id)
    {

        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select sum(credits_earned) as credit_earned from phd_exam_result_master  where semester='".$semester."' and student_id='$stdid' and exam_id <= '$exam_id'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->row();
        return $stream_details;
    }

    public function fetch_student_ce_registerd_semester($stud_id,$semester)
    {
          
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select distinct(subject_id)  from phd_exam_result_data  where semester='".$semester."' and student_id='$stud_id'";
        $query = $DB1->query($sql);
         //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();

        $su_id = array();
        foreach($stream_details as $stream_detail){
          $su_id[] = $stream_detail['subject_id'];
           
        }
        $ids = implode(',', $su_id);
        if($ids != ''){
        $sql1 = "select sum(credits) as credits_registered  from subject_master  where sub_id in($ids)";
        $query1 = $DB1->query($sql1);
        //echo $DB1->last_query();exit;
        $stream_details1 = $query1->row();
        return $stream_details1;
      }
}

 function fetch_student_exam_unique_id_for_degree($stud, $stream_id,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT res_master_id as exam_master_id,enrollment_no FROM `phd_exam_result_master` WHERE `student_id`='".$stud."' and `stream_id`='".$stream_id."' and `exam_id`='".$exam_id."'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    } 
	//////////////code by siddesh for phd dispatch report/////////////////
	public function insert_markscard_data($sdata,$post)
	{
	      $DB1 = $this->load->database('umsdb', TRUE);
		 $exam_session = explode('~', $post['exam_session']);
		 $exam_id =$exam_session[2]; 
		 $exam_ses =$exam_session[0].''.$exam_session[1];
	  	 $dupdate['student_id']=$sdata['stud'];
	  	 $dupdate['enrollment_no']=$sdata['enrollment_no'];
		 $dupdate['exam_id']=$exam_session[2]; 
		 $dupdate['exam_month']=$exam_session[0]; 
		 $dupdate['exam_year']=$exam_session[1]; 
		 $dupdate['school_id']=$post['school'];
		 $dupdate['stream_id']=$post['stream_id'];
		 $dupdate['semester']=$post['semester'];
		 $dupdate['certificate_dispatch']='';
		 $dupdate['thesis_name']=$post['thesis'];
		 $dupdate['faculty_name']=$post['faculty'];
		 $dupdate['issued_date']=$post['mrk_cer_date'];
		 $dupdate['entry_by'] = $this->session->userdata("uid");
		 $dupdate['entry_on'] = date('Y-m-d H:i:s');

	     $DB1->insert('phd_degreecertficate_assgin_details',$dupdate);   
  }      
  public function fetch_phd_degree_cert_assgn_det($gc_id='')
  {

	        $this->load->database();
           $DB1 = $this->load->database('umsdb', TRUE);          
           $DB1->select('p.*,em.res_master_id as exam_master_id');
           $DB1->select('v.stream_name');
           $DB1->select('v.school_name');
           $DB1->select('sm.first_name,sm.middle_name,sm.last_name');
           $DB1->from('phd_degreecertficate_assgin_details p');
           $DB1->join('student_master sm','sm.stud_id=p.student_id');
           $DB1->join('phd_exam_result_master em','em.student_id=p.student_id and em.exam_id=p.exam_id');
           $DB1->join('vw_stream_details v','v.stream_id=p.stream_id','left');
		   if($gc_id!=''){
		   $DB1->where('p.gc_id',$gc_id);
		   }
           $DB1->order_by('p.gc_id','DESC');
           $query=$DB1->get();
		   // echo $DB1->last_query();exit;
          return $query->result_array(); 
  }
  public function update_phd_cert_assign_det($vdata)
  {
 	  $this->load->database();
      $DB1 = $this->load->database('umsdb', TRUE); 
	  $DB1->select('*');
	  $DB1->from('phd_degreecertficate_assgin_details');
	  $DB1->where('gc_id', $vdata['gc_id']);
	  $query=$DB1->get();
	  $log_data=$query->result_array();
	  $log_data[0]['inserted_by']=$this->session->userdata("uid");
	  $log_data[0]['inserted_on'] = date('Y-m-d H:i:s');
	  foreach($log_data as $logdata){
	  $log=$DB1->insert('log_phd_degreecertficate_assgin_details',$logdata);
	  }
       if($log!=''){
	  $sdata['certificate_dispatch']=$vdata['cert_disp'];
	  $sdata['thesis_name']=$vdata['thesis_name'];
	  $sdata['faculty_name']=$vdata['fac_name'];
	  $sdata['issued_date']=$vdata['issue_date'];
	  $sdata['modified_by'] = $this->session->userdata("uid");
	  $sdata['modified_on'] = date('Y-m-d H:i:s');
	  $sdata['modified_ip'] = $_SERVER['REMOTE_ADDR'];
	  $DB1->where('gc_id', $vdata['gc_id']);
	  $DB1->update('phd_degreecertficate_assgin_details',$sdata);   
	   }
  } 
  public function fetch_dispatch_enroll($var)
  {
	  $stream_id = $var['admission-branch'];
       
           $this->load->database();
      $DB1 = $this->load->database('umsdb', TRUE); 
         /* $DB1->select('enrollment_no');
          $DB1->from('phd_degreecertficate_assgin_details');
          $query=$DB1->get();
          echo $DB1->last_query();exit; */
          $sql="SET SESSION group_concat_max_len = 1000000";
           $query=$DB1->query($sql);
      $sql1="SELECT GROUP_CONCAT(enrollment_no) AS enr FROM phd_degreecertficate_assgin_details where stream_id=$stream_id";
      $query1=$DB1->query($sql1);
          return $query1->row();
  }
}
?>