<?php
class Subject_allocation_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		$DB1 = $this->load->database('umsdb', TRUE);
    }
    
	
	// fetch student list
	function  get_stud_list($stream_id, $semester,$acyear)
    {

        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        if($semester=='1' || $semester=='2'){
	        if($stream_id ==9){
				$where.=" AND sm.admission_stream in(5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279)";	
			}elseif($stream_id ==239){
				$where.=" AND sm.admission_stream in(178,180,181)";	
			}elseif($stream_id ==236){
				$where.=" AND sm.admission_stream in(22,113,196,22,260,261)";	
			}elseif($stream_id ==234){
				$where.=" AND sm.admission_stream in(184,185,26,27,28)";	
			}elseif($stream_id ==235){
				$where.=" AND sm.admission_stream in(154,155,182,183,23)";	
			}elseif($stream_id ==237){
				$where.=" AND sm.admission_stream in(38,39,40)";	
			}elseif($stream_id ==103){
				$where.=" AND sm.admission_stream in(43,44,45,46,47,66,67,103,104,117,167,193,194,210)";	
			}else{
				$where.=" AND sm.admission_stream='".$stream_id."'";
			}
			/*else if($stream_id ==103 || $stream_id ==104){
				$where.=" AND sm.admission_stream in(43,44,45,46,47)";
			}*/
		}/* else if(($semester=='3' || $semester=='4') ){
				$where.=" AND sm.admission_stream in(23,24,148,149,154,155,182,183,204,205,206,207,222)";	
		} */else{
			$where.=" AND sm.admission_stream='".$stream_id."'";
		}
       
	   
	   $where.=" AND sm.cancelled_admission ='N' and sm.enrollment_no !='' AND sm.is_detained ='N' and sm.academic_year ='".$acyear."' ";
		
		if($stream_id=="71")
        {
            $where.="  and sm.current_year='".$semester."'  ";
        }elseif(!empty($semester))
        {
            $where.="  and sm.current_semester='".$semester."'  ";
            //$where.=" AND sm.cancelled_admission ='N' and sm.enrollment_no !='' AND sm.is_detained ='N' and sm.current_semesterorg='".$semester."' and sm.academic_year_temp ='".$acyear."' ";
        }
		
        $sql="SELECT sm.*, std.stream_name FROM `student_master` as sm  join admission_details a on a.student_id=sm.stud_id and sm.academic_year= a.academic_year 
		left join stream_master std on std.stream_id=sm.admission_stream $where";
		$sql.=" order by sm.enrollment_no";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit; 
        return $query->result_array();
    }
	
	
	// fetch subject list
	function  get_sub_list($stream_id, $semester, $batch)
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
		$where=" WHERE sas.is_active='Y' and sm.is_active='Y'";  
        
        if($stud_id!="")
        {
            $where.=" AND sas.stud_id='".$stud_id."'";
        }	
		if($sem_id!="")
        {
            $where.=" AND sm.semester='".$sem_id."'";
        }
		$sql="SELECT sas.stud_id, sas.subject_id,sm.subject_name,sm.credits, sas.sub_applied_id,sm.subject_component,sm.subject_type, sm.subject_code,sm.semester,sm.batch,'' as res_subject_id 
		FROM `student_applied_subject` as sas 
		left join subject_master sm on sm.sub_id=sas.subject_id 
		#left join (SELECT subject_id FROM exam_result_data WHERE student_id='$stud_id' GROUP BY subject_id) as e on e.subject_id=sas.subject_id 
		$where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	function getsubject_cia_marks($stud_id,$sub_id){
		$DB1 = $this->load->database('umsdb', TRUE);  		
		$sql="SELECT cia_marks from exam_result_data where subject_id='$sub_id' and student_id='$stud_id' order by result_id desc limit 1";
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
		$sql="SELECT * FROM `student_applied_subject` where subject_id='$sub' and stud_id ='$stud_id' and semester='$sem' and academic_year ='$academic_year'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		return true;
	}
	function delete_dupsubToStudent($data){
		$DB1 = $this->load->database('erpdel', TRUE);  
		$sem = $data['semester'];
		$sub = $data['subject_id'];
		$stream_id = $data['stream_id'];
		$stud_id = $data['stud_id'];
		$academic_year = $data['academic_year'];
		$sql="DELETE FROM `student_applied_subject` where stud_id ='$stud_id'  and semester='$sem' and academic_year ='$academic_year'";//and stream_id='$stream_id'
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return true;
	}
	
	// de-allocate batch student added on 25/09/17
	function delete_studFromBatchAllocation($data){
		$DB1 = $this->load->database('erpdel', TRUE);  
		$sem = $data['semester'];
		$stream_id = $data['stream_id'];
		$stud_id = $data['stud_id'];
		$academic_year = $data['academic_year'];
		$sql="DELETE FROM `student_batch_allocation` where studentId ='$stud_id'  and semester='$sem' and academic_year ='$academic_year'";//and stream_id='$stream_id'
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
            $where.=" AND sas.stream_id='".$stream_id."' and sas.semester = '".$semester."' and sas.academic_year='$academic_year' ";//and sm.batch='".$batch."'
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
        $acd_yr =explode('-', $_POST['academic_year']);
		$sql="SELECT vw.stream_id,vw.stream_name,vw.stream_short_name FROM student_master s left join vw_stream_details vw on s.admission_stream=vw.stream_id where s.academic_year='".$acd_yr[0]."' and vw.course_id='".$_POST['course_id']."'  and s.cancelled_admission ='N'";
		
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
		//echo $sql;exit;
		//echo $DB1->last_query();exit;
		return $stream_details =  $query->result_array();  
    } 
	function load_semester_subjects()
    {
		/* $cond='and admission_cycle IS NULL';
		if(isset($_POST['phd']) && $_POST['phd'] ==1){
		$cond='';	
		} */
        $DB1 = $this->load->database('umsdb', TRUE);    
        $acd_yr =explode('-', $_POST['academic_year']);
		$sql="SELECT s.current_semester as semester FROM student_master s  where s.academic_year='".$acd_yr[0]."' and s.admission_stream='".$_POST['stream_id']."' and s.cancelled_admission ='N' and s.is_detained='N' group by s.current_semester";
        
        $query = $DB1->query($sql);
		//echo $DB1->last_query();
		//exit;
		return $stream_details =  $query->result_array();  
    }
	////////////
}