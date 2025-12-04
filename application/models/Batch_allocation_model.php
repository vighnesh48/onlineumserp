<?php
class Batch_allocation_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		$DB1 = $this->load->database('umsdb', TRUE);
    }
    
	
	// fetch student list
	function  get_stud_list($stream_id, $semester, $subject_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        
        /*if($stream_id!="")
        {
            $where.=" AND sm.admission_stream='".$stream_id."'";
        }*/
        if($subject_id!="")
        {
            $where.=" AND sas.subject_id='".$subject_id."'";
        }
		if($semester!="")
        {
            $where.=" AND sas.semester='".$semester."'";
        }
		
        $sql="SELECT sm.*, sas.sub_applied_id FROM `student_master` as sm left join student_applied_subject sas on sas.stud_id=sm.stud_id $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	// fetch subject list
	function  get_sub_list($stream_id, $semester)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        
        if($stream_id!="")
        {
            $where.=" AND stream_id='".$stream_id."'";
        }
        
		if($semester!="")
        {
            $where.=" AND semester='".$semester."'";
        }
		
        
        $sql="SELECT * FROM `subject_master` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	//
	function assign_batchToStudent($data){
		$DB1 = $this->load->database('umsdb', TRUE);   
		$DB1->insert('student_batch_allocation', $data);
		//echo $DB1->last_query();exit;
		return true;
	}
	// check duplicate student 
	function chk_dupbatchToStudent($data){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sem = $data['semester'];
		$batch_code = $data['batch_code'];
		$sub_applied_id = $data['sub_applied_id'];
		$academic_year = $data['academic_year'];
		$sql="SELECT * FROM `student_batch_allocation` where sub_applied_id='$sub_applied_id' and batch_code ='$batch_code' and semester='$sem' and academic_year ='$academic_year'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		return true;
	}
	//
	 function removeStudent($studId)
	 {
		$DB1 = $this->load->database('umsdb', TRUE);  
		$DB1->where('sub_applied_id', $studId);
		$DB1->delete('student_batch_allocation'); 
		//echo $DB1->last_query();exit;
		return true;
	 } 
	 function get_course_streams($course_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$this->load->model('Subject_model');
		if($role_id==3){
			$sql = "SELECT distinct l.stream_id, v.stream_name FROM `lecture_time_table` as l left join vw_stream_details as v on v.stream_id=l.stream_id WHERE l.`faculty_code` ='".$emp_id."' and v.course_id='" .$course_id. "'";
		}else{
			$sql = "select stream_id,stream_name from vw_stream_details vw where vw.course_id='".$course_id."' ";
			if(isset($role_id) && $role_id==20){
				 $empsch = $this->Subject_model->loadempschool($emp_id);
				 $schid= $empsch[0]['school_code'];
				 $dept= $empsch[0]['department'];
				 $sql .=" AND vw.stream_id in(select ums_stream_id from sandipun_erp.department_ums_stream_mapping where department_id='$dept')";
			 }else if(isset($role_id) && $role_id==44){
				 $empsch = $this->Subject_model->loadempschool($emp_id);
				 $schid= $empsch[0]['school_code'];
				 $sql .=" AND vw.school_code = $schid";
			 }else if(isset($role_id) && $role_id==10){
					$ex =explode("_",$emp_id);
					$sccode = $ex[1];
					$sql .=" AND vw.school_code = $sccode";
			}
		}
        $query = $DB1->query($sql);
        $stream_details = $query->result_array();
		return $stream_details;
    }
	 function get_course_streams_faculty_allocation($course_id,$school_code) {
        $DB1 = $this->load->database('umsdb', TRUE);
		$this->load->model('Subject_model');
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		if($role_id==3){
			$sql = "SELECT distinct l.stream_id, v.stream_name FROM `lecture_time_table` as l left join vw_stream_details as v on v.stream_id=l.stream_id WHERE l.`faculty_code` ='".$emp_id."' and v.course_id='" .$course_id. "'";
		}else{
			$sql = "select stream_id,stream_name from vw_stream_details vw where vw.course_id='".$course_id."' and vw.school_code='".$school_code."'";
			if(isset($role_id) && $role_id==20){
				 $empsch = $this->Subject_model->loadempschool($emp_id);
				 $schid= $empsch[0]['school_code'];
				 $dept= $empsch[0]['department'];
				 $sql .=" AND vw.stream_id in(select ums_stream_id from sandipun_erp.department_ums_stream_mapping where department_id='$dept')";
			 }else if(isset($role_id) && $role_id==44){
				 $empsch = $this->Subject_model->loadempschool($emp_id);
				 $schid= $empsch[0]['school_code'];
				 $sql .=" AND vw.school_code = $schid";
			 }else if(isset($role_id) && $role_id==10){
					$ex =explode("_",$emp_id);
					$sccode = $ex[1];
					$sql .=" AND vw.school_code = $sccode";
			}
		}
		//echo $sql;exit;
        $query = $DB1->query($sql);
		
        $stream_details = $query->result_array();
		return $stream_details;
    }	
	function load_subject($course_id, $streamId, $semesterId,$division) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select distinct lt.subject_code,lt.room_no,lt.division, lt.batch_no, vw.stream_code,sm.subject_code as sub_code,sm.subject_type,sm.subject_short_name from lecture_time_table lt LEFT JOIN stream_master vw on vw.stream_id = lt.stream_id LEFT JOIN subject_master sm on sm.sub_id = lt.subject_code where lt.course_id='" .$course_id. "' and lt.stream_id='" .$streamId. "' and lt.semester='" .$semesterId. "' AND lt.division='".$division."'";
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();


        echo '<select name="subject" class="form-control" id="subject" required>
									<option value="">Select Subject</option>';

        foreach ($sub_details as $sub) {
			if($sub['subject_code'] !='OFF'){
				if($sub['batch_no'] ==0){
							$batch = "";
						}else{
							$batch =$sub['batch_no'];
						}

				echo '<option value="'.$sub['subject_code'].'-'.$sub['stream_code'].'-'.$sub['division'].'-'.$sub['batch_no'].'"' . $sel . '>'.$sub['subject_short_name'].'('.$sub['sub_code'].')-'.$sub['division'].''.$batch.'</option>';	
			}
        }
        echo '</select></div>';
    }
	// fetch batch allocated student list
	function  get_studbatch_allot_list($batch_code)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        
        if($batch_code!="")
        {
            $where.=" AND sba.batch_code ='".$batch_code."'";
        }
		
        $sql="SELECT sba.sub_applied_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no FROM `student_batch_allocation` as sba left join student_applied_subject sas on sas.sub_applied_id=sba.sub_applied_id left join student_master sm on sm.stud_id=sas.stud_id $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	//load division
	function load_division($room_no, $semesterId) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select distinct division from lecture_time_table where stream_id='" .$room_no. "' and semester='" .$semesterId. "' order by division";
		//AND t.faculty_code='".$emp_id."'
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();
		return $sub_details;
    }	
}