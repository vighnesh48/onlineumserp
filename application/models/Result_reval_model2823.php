<?php

class Result_reval_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    } 	
	
	
	function exam_result_update($stream='',$semester='',$exam_id)
	{
			if($semester!='')
		{
			$semester="and semester=$semester";
		}
        	if($stream!='')
		{
			$stream="and stream_id=$stream";
		}
        
		$DB1 = $this->load->database('umsdb', TRUE);
		$where = " exam_id='$exam_id' AND reval_marks!='' $semester $stream";
        $DB1->select("stud_id,enrollment_no,exam_id,semester,subject_id,marks,reval_marks,exam_year");
        $DB1->from('marks_entry'); 
        $DB1->where($where); 		
        $query=$DB1->get();
        $result=$query->result_array();
		
		foreach($result as $rows)
		{    
		    $subject_id=$rows['subject_id'];
		    $student_id=$rows['stud_id'];
			$previous_mark=$rows['marks'];
			$reval_marks=$rows['reval_marks'];
			if($previous_mark > $reval_marks)
			{
				$max_marks=$previous_mark;
			}
			else
			{
				$max_marks=$reval_marks;
			}
      
			$diff_marks=abs($previous_mark-$reval_marks);
			$percent_multi= ($max_marks)*(0.25);

             if($diff_marks > $percent_multi )
			 {
				 $final_marks=($previous_mark+$reval_marks)/2;
			 }
             else
			 {
				 $final_marks=$max_marks;
			 }
			 
			  $update_data=array(
			    'reval_marks'=>$final_marks,
			  );
          	$DB1->where('exam_id', $exam_id);
          	$DB1->where('subject_id ', $subject_id);
          	$DB1->where('student_id', $student_id);
		    $up=$DB1->update("exam_result_data", $update_data);
	
		}
		//echo $DB1->last_query();exit;
		return $up;
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
		
        $where=" where sas.semester='".$semester."' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' and reval_marks!='' ";

        $sql="SELECT distinct sas.student_id,sas.enrollment_no FROM `exam_result_data` as sas
        $where ";
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;
        return $query->result_array();
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

        $sql="SELECT subject_id, final_garde_marks,subject_code,cia_marks,reval_marks,exam_marks,result_grade,final_grade FROM `exam_result_data` where semester='".$semester."' AND exam_id='$exam_id' and stream_id='$stream_id' and student_id='$student_id' and reval_marks!='' ";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function fetch_subject_details($subject_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `subject_master` where sub_id='$subject_id' and is_active='Y'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
	function fetch_max_marks_thpr($stream,$exam_id,$semester,$subject)
    {
       $DB1 = $this->load->database('umsdb', TRUE);
		if($semester!='')
		{
			$semester="and semester=$semester";
		}
        
        $sql = "SELECT max_marks FROM `marks_entry_master` where subject_id='".$subject."' $semester  and marks_type in('PR','TH') ORDER BY me_id DESC LIMIT 0,1";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
	// fetching for comparing cia max marks while grade generation 
    function fetch_max_marks_cia($stream,$exam_id,$semester,$subject)
    {	
        $DB1 = $this->load->database('umsdb', TRUE);
		if($semester!='')
		{
			$semester="and semester=$semester";
		}
        $sql = "SELECT max_marks FROM `marks_entry_master` where subject_id='".$subject."' $semester and marks_type ='CIA' ORDER BY me_id DESC LIMIT 0,1";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
	
	  function fetch_grade($stud_f_mrks,$grd_rule) 
	  {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `grade_policy_details` where $stud_f_mrks between min_range and max_range and rule='$grd_rule'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
	    function fetch_grade_pharma($stud_f_mrks,$grd_rule) 
	{
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `grade_policy_details_pharma` where '$stud_f_mrks' between min_range and max_range and rule='$grd_rule'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
	   function update_reslt_grade($subject,$semester,$stream,$exam_id,$stud_id,$data)
	  {
	      $DB1 = $this->load->database('umsdb', TRUE);
		   		   
        $where = "subject_id='$subject' and semester='$semester' and stream_id='$stream' and exam_id='$exam_id' AND student_id='$stud_id'";
        $DB1->where($where);        
        $DB1->update('exam_result_data', $data);
       // echo $DB1->last_query();exit;echo "<br>break";
        return true;
    }
	    function fetch_gread_rule($stream_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT grade_rule,grade_id FROM `stream_grade_criteria` where stream_id='$stream_id'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
	    function update_resltsubject_grace($subject,$semester,$stream,$exam_id,$stud_id, $data){
        $DB1 = $this->load->database('umsdb', TRUE);
        
        $where = "subject_id='$subject' and semester='$semester' and stream_id='$stream' and exam_id='$exam_id' AND student_id='$stud_id'";
        $DB1->where($where);        
        $DB1->update('exam_result_data', $data);
        return true;
    }
	function fetch_result_exam_session()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('exam_session');
		$DB1->where("active_for_result", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}	
	function getCollegeCourse(){
         $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT(course_id),course_name,course_short_name FROM vw_stream_details";
	
        $query = $DB1->query($sql);
        return $query->result_array();
    }	
	function getSchools(){
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$this->load->model('Subject_model');
        $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT(school_code),school_short_name FROM vw_stream_details where school_code IS NOT NULL";
		
		if(isset($role_id) && $role_id==20){
			 $empsch = $this->Subject_model->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $sql .=" and school_code = $schid";
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" and school_code = $sccode";
		}else if(isset($role_id) && $role_id==37){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" and school_code = $sccode";
		}
	
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	function get_courses_reval_results($school_code=''){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_session= fetch_exam_session_for_result();
		//print_r($exam_session);
		$exam_id=$exam_session[0]['exam_id'];
		$sql="SELECT DISTINCT(vw.course_id),course_name,course_short_name FROM vw_stream_details vw join exam_details ed on ed.stream_id=vw.stream_id 
		where vw.school_code='".$school_code."' and ed.exam_id=$exam_id and ed.reval_appeared='Y'";
	
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	function get_streams_for_reval_result($course_id,$school_code=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$exam_session= fetch_exam_session_for_result();
		//print_r($exam_session);
		$exam_id=$exam_session[0]['exam_id'];
		$sql = "select vw.stream_id,stream_name,stream_short_name from vw_stream_details vw join exam_details ed on ed.stream_id=vw.stream_id where vw.course_id='".$course_id."' ";
		if($school_code !=''){
			$sql .= "and vw.school_code='".$school_code."'";
		}
		$sql .=" and ed.exam_id=$exam_id and ed.reval_appeared='Y' group by vw.stream_id";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	
	function get_reval_result_stream_data($stream_id,$exam_id){

        $DB1 = $this->load->database('umsdb', TRUE);
        $role_id = $this->session->userdata('role_id');
        $emp_id = $this->session->userdata("name");       
        $sql = "SELECT ed.*,vw.stream_name FROM `exam_result_data` as ed left join vw_stream_details vw on vw.stream_id = ed.stream_id where ed.stream_id='".$stream_id."' AND ed.exam_id='".$exam_id."' and reval_marks!='' group by ed.semester ORDER BY ed.`semester` ASC ";        
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
	function fetch_student_reval_result_data($result_data,$batch) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);
        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[5];
        $exam_month =$res_data[2];
        $exam_year =$res_data[3];
		$exam_id =$res_data[4];
		
        $where=" where sas.semester='".$semester."' AND  sas.stream_id='$stream_id' and sas.exam_id='$exam_id' and sas.reval_marks!='' "; 
		
        $sql="SELECT sas.*,s.first_name, s.middle_name, s.last_name,s.admission_session,s.current_semester,rm.sgpa,rm.grade_points_avg FROM `exam_result_data` as sas 
		left join exam_result_master rm on rm.student_id=sas.student_id and rm.exam_id=sas.exam_id and rm.semester =sas.semester
		left join student_master s on s.stud_id=sas.student_id
        $where group by sas.student_id";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
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

        $sql="SELECT distinct e.subject_id, s.subject_code1,s.subject_code,s.subject_component,s.subject_name,s.subject_short_name,s.practical_min_for_pass,s.practical_max,s.theory_max,s.theory_min_for_pass,s.internal_max,s.internal_min_for_pass,s.sub_min,s.sub_max,s.credits FROM `exam_result_data` e left join subject_master s on e.subject_id= s.sub_id where e.semester='".$semester."' and e.exam_id='$exam_id' AND e.stream_id='$stream_id' and e.reval_marks!='' ";
		
		if(!empty($arr_stud)){
			$sql .=" and e.student_id in($arr_stud)";
		}
		$sql .="  order by s.subject_order asc";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
	function fetch_stud_sub_marks($student_id, $subject_id, $exam_id) {

        $DB1 = $this->load->database('umsdb', TRUE);

        $sql="SELECT subject_id,reval_marks,reval_grade,reval_grade_mark,practical_marks,cia_garde_marks,final_garde_marks,subject_code,cia_marks,exam_marks,result_grade,final_grade FROM `exam_result_data` where student_id='".$student_id."' AND subject_id='$subject_id' AND exam_id='$exam_id' and reval_marks!='' ";
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;
        return $query->result_array();
	   
    }
        function list_exam_subjects_for_status_applied($data, $exam_id)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        
        $sem = $data['semester'];        
        $stream = $data['admission-branch'];
        $where = " WHERE sb.is_active='Y'";
          
        $where .= " AND s.semester='" . $sem . "'";           
		
        $where .= " AND s.stream_id='" . $stream . "' AND s.exam_id ='$exam_id'  and s.reval_marks!='' ";
   
         $sql = "SELECT s.stream_id,s.semester,s.subject_id,sb.subject_code,sb.subject_name, m.me_id as m_me_id,
		CASE WHEN sb.theory_max=0 THEN 'N' ELSE 'Y' END AS th_status,
		CASE WHEN sb.practical_max=0 THEN 'N' ELSE 'Y' END AS pr_status,
		COUNT(s.student_id)AS stud_count,
		SUM( CASE WHEN m.marks IS NULL THEN 0 ELSE 1 END)AS th_entry,
		SUM( CASE WHEN m.marks IS NULL THEN 0 ELSE 1 END)AS pr_entry
         FROM exam_result_data  s 
         LEFT JOIN marks_entry m ON m.stud_id=s.student_id AND s.subject_id=m.subject_id AND s.exam_id=m.exam_id
         LEFT JOIN subject_master sb ON sb.sub_id=s.subject_id
         $where group by s.subject_id";//exit;
        
        $query = $DB1->query($sql);       
        //echo $DB1->last_query();exit;       
        return $query->result_array();       
    }	

  function get_thmarks_revalmrks_details($sub_id, $stream, $semester,$exam_id)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        
        $sql = "SELECT s.enrollment_no,s.stream_id,s.semester,s.subject_id,s.subject_code ,m.marks,m.reval_marks,sb.theory_max,sb.theory_min_for_pass, sb.internal_max,sb.internal_min_for_pass,sb.sub_min,sb.sub_max
		FROM exam_result_data  s 
		LEFT JOIN marks_entry m ON m.stud_id=s.student_id AND s.subject_id=m.subject_id AND s.exam_id=m.exam_id
		LEFT JOIN subject_master sb ON sb.sub_id=s.subject_id
		WHERE s.exam_id='$exam_id' AND s.stream_id='$stream' AND s.semester='$semester' and s.subject_id='$sub_id' and s.reval_marks!='' order by s.enrollment_no";
        
        $query = $DB1->query($sql);      
       // echo $DB1->last_query();exit;
        return $query->result_array();
    }
    
	function fetch_student_result_data($result_data) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[2];
        $exam_month =$res_data[3];
        $exam_year =$res_data[4];
        $exam_id =$res_data[5];

        $where=" where sas.semester='".$semester."' AND sas.exam_month='$exam_month' AND sas.exam_year='$exam_year'and sas.reval_marks!='' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' ";

        $sql="SELECT sas.*,s.first_name, s.middle_name, s.last_name FROM `exam_result_data` as sas left join student_master s on s.stud_id=sas.student_id
        $where group by sas.student_id";
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;
        return $query->result_array();

    }
 
 function fetch_subjects_reval_exam_semester($result_data) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[2];
        $exam_month =$res_data[3];
        $exam_year =$res_data[4];
        $exam_id =$res_data[5];

        $sql="SELECT distinct e.subject_id, s.subject_code1,s.subject_code,s.subject_name,s.subject_short_name,s.theory_max,s.theory_min_for_pass,s.internal_max,s.internal_min_for_pass,s.sub_min,s.sub_max FROM `exam_result_data` e left join subject_master s on e.subject_id= s.sub_id where e.semester='".$semester."' and e.exam_id='$exam_id' AND e.exam_month='$exam_month' AND e.exam_year='$exam_year'and e.stream_id='$stream_id' and e.reval_marks!=''order by s.subject_order ASC";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    function get_streams_for_result($course_id,$school_code=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$exam_session= fetch_exam_session_for_result();

		$exam_id=$exam_session[0]['exam_id'];
		$sql = "select vw.stream_id,stream_name,stream_short_name from vw_stream_details vw join exam_details ed on ed.stream_id=vw.stream_id where vw.course_id='".$course_id."' ";
		if($school_code !=''){
			$sql .= "and vw.school_code='".$school_code."'";
		}
		$sql .=" and ed.exam_id=$exam_id and ed.reval_appeared='Y' group by vw.stream_id";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
}
