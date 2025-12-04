<?php
class Phd_subject_allocation_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		$DB1 = $this->load->database('umsdb', TRUE);
    }
    
	
	// fetch student list
	function  get_stud_list($stream_id='', $semester='',$acyear='',$admission_cycle='')
    {

        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";         
		$where.=" AND sm.admission_stream='".$stream_id."'";		
        $where.=" AND sm.cancelled_admission ='N' AND sm.is_detained ='N' and sm.current_semester='".$semester."' ";
		$sql="SELECT sm.*, std.stream_name FROM `student_master` as sm left join stream_master std on std.stream_id=sm.admission_stream $where AND sm.admission_cycle='".$admission_cycle."'";
		$sql.=" order by sm.enrollment_no";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	// fetch subject list
	function  get_sub_list($stream_id='', $semester='', $batch='')
    {
		
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE is_active ='Y' and batch ='$batch'";  
        
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
	function assign_subToStudent($data){
		$DB1 = $this->load->database('umsdb', TRUE);   
		$DB1->insert('student_applied_subject', $data);
		//echo $DB1->last_query();exit;
		return true;
	}
	function getStudAllocatedSubject($stud_id, $sem_id=''){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE sas.is_active='Y' ";  
        
        if($stud_id!="")
        {
            $where.=" AND sas.stud_id='".$stud_id."'";
        }	
		if($sem_id!="")
        {
            $where.=" AND sm.semester='".$sem_id."'";
        }
		$sql="SELECT sas.stud_id, sm.subject_name, sas.sub_applied_id, sm.subject_code,sm.semester,sm.batch FROM `student_applied_subject` as sas left join subject_master sm on sm.sub_id=sas.subject_id $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	// fetch subject list
	function  get_stream_mapping_tot_subject($stream_id, $semester, $batch)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        
        if($stream_id!="")
        {
            $where.=" AND stream_id='".$stream_id."'";
        }        
		if($semester!="")
        {
            $where.=" AND semester='".$semester."' AND batch='".$batch."'";
        }
        $sql="SELECT * FROM `stream_mapping` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	//
	function chk_dupsubToStudent($data){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sem = $data['semester'];
		$sub = $data['subject_id'];
		$stud_id = $data['stud_id'];
		$academic_year = $data['academic_year'];
		$sql="SELECT * FROM `student_applied_subject` where subject_id='$sub' and stud_id ='$stud_id' and semester='$sem'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		return true;
	}
	function delete_dupsubToStudent($data){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sem = $data['semester'];
		$sub = $data['subject_id'];
		$stream_id = $data['stream_id'];
		$stud_id = $data['stud_id'];
		$academic_year = $data['academic_year'];
		$sql="DELETE FROM `student_applied_subject` where stud_id ='$stud_id' and stream_id='$stream_id' and semester='$sem' and academic_year ='$academic_year'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return true;
	}
	
	// de-allocate batch student added on 25/09/17
	function delete_studFromBatchAllocation($data){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sem = $data['semester'];
		$stream_id = $data['stream_id'];
		$stud_id = $data['stud_id'];
		$academic_year = $data['academic_year'];
		$sql="DELETE FROM `student_batch_allocation` where studentId ='$stud_id' and stream_id='$stream_id' and semester='$sem' and academic_year ='$academic_year'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return true;
	}	
	// remove subject
	 function removeSubject($sub_id)
	 {
		$DB1 = $this->load->database('erpdel', TRUE);  
		$DB1->where('sub_applied_id', $sub_id);
		$DB1->delete('student_applied_subject'); 
		//echo $DB1->last_query();exit;
		return true;
	 } 
	 	// removeall subject
	 function removeAllSubjects($studId, $sem,$stream)
	 {
		$DB1 = $this->load->database('erpdel', TRUE);  
		$DB1->where('stud_id', $studId);
		$DB1->where('semester', $sem);
		//$DB1->where('stream_id', $stream);
		$DB1->delete('student_applied_subject'); 
		//echo $DB1->last_query();exit;
		return true;
	 } 
	 // get unique student list of allocated subject
	function get_allcated_studlist($stream_id, $semester, $academic_year, $batch){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE 1=1 ";  
        
        if($semester!="")
        {
            $where.=" AND sas.stream_id='".$stream_id."' and sas.semester = '".$semester."' ";//and sm.batch='".$batch."' ////and sas.academic_year='$academic_year' 
        }	
		
		$sql="SELECT distinct sas.stud_id FROM `student_applied_subject` as sas left join subject_master sm on sm.sub_id=sas.subject_id $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	//fetch student semesters
	function fetch_student_semester($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sql="SELECT distinct semester FROM `student_applied_subject` WHERE `stud_id` ='".$stud_id."' order by semester DESC";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	
	function load_streams_student_list()
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
        //$acd_yr =explode('-', $_POST['academic_year']);
		$sql="SELECT vw.stream_id,vw.stream_name,vw.stream_short_name FROM student_master s left join vw_stream_details vw on s.admission_stream=vw.stream_id where s.admission_cycle='".$_POST['admission_cycle']."' and vw.course_id='".$_POST['course_id']."'  and s.cancelled_admission ='N'";
		
		if(!empty($_POST['school_code'])){
			$sql .=" AND vw.school_code ='".$_POST['school_code']."'";
		}
        
        if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND vw.school_code = $sccode";
			}
		$sql .=" group by s.admission_stream";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $stream_details =  $query->result_array();  
    } 
	function load_semester_subjects()
    {
        $DB1 = $this->load->database('umsdb', TRUE);    
        //$acd_yr =explode('-', $_POST['academic_year']);
		$sql="SELECT s.current_semester as semester FROM student_master s  where s.admission_cycle='".$_POST['admission_cycle']."' and s.admission_stream='".$_POST['stream_id']."' and s.cancelled_admission ='N' group by s.current_semester";
        
        $query = $DB1->query($sql);
		//echo $DB1->last_query();
		return $stream_details =  $query->result_array();  
    }
	////////////
}