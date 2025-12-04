<?php
class Batchallocation_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		$DB1 = $this->load->database('umsdb', TRUE);
    }
    
	
	// fetch student list
	function  get_stud_list($stream_id='', $semester='', $academic_year='',$admission_cycle='')
    {
        $DB1 = $this->load->database('umsdb', TRUE);  
        $where=" WHERE sm.cancelled_admission='N' and sm.enrollment_no !='' and sm.is_detained ='N'";
        if($admission_cycle!="")
        {
            $where.=" AND sm.admission_cycle='".$admission_cycle."'";
        }
        if($academic_year!="")
        {
            $academicyear = explode('-', $academic_year);
            $where.=" AND sm.academic_year='".$academicyear[0]."'";
            //$where.=" AND sm.academic_year_temp='".$academicyear[0]."'";
        }
        if($semester!="")
        {
            $where.=" AND sm.current_semester='".$semester."'";
            //$where.=" AND sm.current_semesterorg='".$semester."'";
        }
		
		if($semester=='1' || $semester=='2'){
	        if($stream_id ==9){
				$where.=" AND sm.admission_stream in(5,6,7,8,9,10,11,96,97,107,108,109,158,159,162,245,266,275,279)";	
			}elseif($stream_id ==239){
				$where.=" AND sm.admission_stream in(178,180,181)";	
			}elseif($stream_id ==234){
				$where.=" AND sm.admission_stream in(184,185,26,27,28)";	
			}elseif($stream_id ==235){
				$where.=" AND sm.admission_stream in(154,155,182,183,23)";	
			}elseif($stream_id ==236){
				$where.=" AND sm.admission_stream in(22,113,196,260,261)";	
			}elseif($stream_id ==237){
				$where.=" AND sm.admission_stream in(38,39,40)";	
			}elseif($stream_id ==103){
				$where.=" AND sm.admission_stream in(43,44,45,46,47,66,67,103,104,117,167,193,194,210)";	
			}else{
				$where.=" AND sm.admission_stream='".$stream_id."'";
			}
			/*else if($stream_id ==103 || $stream_id ==104){
				$where.=" AND sm.admission_stream in(43,44,45,46,47,117)";
			}*/
		}else if(($semester=='3' || $semester=='4') && $stream_id ==23){
				$where.=" AND sm.admission_stream in(23,24,148,149,154,155,182,183,204,205,206,207,222)";	
		}else{
			$where.=" AND sm.admission_stream='".$stream_id."'";
		}

		
        $sql="SELECT `sm`.stud_id,`sm`.form_number,`sm`.enrollment_no,`sm`.first_name,`sm`.middle_name,sm.current_semester as semester,`sm`.last_name,`sm`.mobile,`sm`.admission_stream  as `strmId`, `stm`.`stream_name`, `stm`.`course_name`, `stm`.`course_short_name` FROM `student_master` as `sm` 
		join admission_details a on a.student_id=sm.stud_id and sm.academic_year= a.academic_year 
        LEFT JOIN `vw_stream_details` as `stm` ON `sm`.`admission_stream` = `stm`.`stream_id` 
        $where";
		$sql .= " group by `sm`.enrollment_no ";
        $query = $DB1->query($sql);
		///echo $DB1->last_query();exit;
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
		$batch = $data['batch'];
        $division = $data['division'];
        $stream_id = $data['stream_id'];
		$student_id = $data['student_id'];
		$academic_year = $data['academic_year'];
		//$sql="SELECT * FROM `student_batch_allocation` where student_id='$student_id' and batch ='$batch' and division='$division' and stream_id='$stream_id' and semester='$sem' and academic_year ='$academic_year'";
		$sql="SELECT * FROM `student_batch_allocation` where student_id='$student_id' and semester='$sem' and academic_year ='$academic_year' ";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	function delete_batchToStudent($data){
		$DB1 = $this->load->database('erpdel', TRUE);  
		$sem = $data['semester'];
		$batch = $data['batch'];
        $division = $data['division'];
        $stream_id = $data['stream_id'];
		$student_id = $data['student_id'];
		$academic_year = $data['academic_year'];
		//$sql="SELECT * FROM `student_batch_allocation` where student_id='$student_id' and batch ='$batch' and division='$division' and stream_id='$stream_id' and semester='$sem' and academic_year ='$academic_year'";
		$sql="Delete FROM `student_batch_allocation` where student_id='$student_id' and semester='$sem' and academic_year ='$academic_year' ";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return true;
	}
	//
	 function removeStudent($studId,$stream_id,$sem_id,$division,$batch, $academic_year)
	 {
		$DB1 = $this->load->database('erpdel', TRUE);   
        $rem_array = array('student_id' => $studId, 'semester' => $sem_id, 'stream_id' => $stream_id,'division' => $division,'batch' => $batch,'academic_year' => $academic_year);
		$DB1->where($rem_array);

		$DB1->delete('student_batch_allocation'); 
		//echo $DB1->last_query();exit;
		return true;
	 } 
	 function get_course_streams($course_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		if($role_id==3){
			$sql = "SELECT distinct l.stream_id, v.stream_name FROM `lecture_time_table` as l left join vw_stream_details as v on v.stream_id=l.stream_id WHERE l.`faculty_code` ='".$emp_id."' and v.course_id='" .$course_id. "'";
		}else{
			$sql = "select stream_id,stream_name from vw_stream_details where course_id='".$course_id."' ";
			if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND school_code = $sccode";
			}
		}
        $query = $DB1->query($sql);
        $stream_details = $query->result_array();
		return $stream_details;
    }
	
	function load_subject($course_id, $streamId, $semesterId,$division) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT distinct `batch_no` FROM `lecture_time_table` WHERE division like '%".$division."%'";
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();


        echo '<select name="subject" class="form-control" id="subject" required>
									<option value="">Select Batch</option>';

        foreach ($sub_details as $sub) {

				if($sub['batch_no'] !='' && $sub['batch_no'] !=0){
					$batch =$sub['batch_no'];
					echo '<option value="'.$batch.'"' . $sel . '>'.$batch.'</option>';	
				}
        }
        echo '</select></div>';
    }
	// fetch batch allocated student list
	function  get_studbatch_allot_list($stream_id,$sem_id,$division,$batch, $academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 

        $where.="WHERE sm.cancelled_admission='N' AND sba.batch ='".$batch."' AND sba.semester = '".$sem_id."' AND sba.stream_id = '".$stream_id."' AND sba.division = '".$division."' AND sba.academic_year='".$academic_year."' and sba.active='Y'";

        $sql="SELECT sba.roll_no,sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no FROM `student_batch_allocation` as sba 
        left join student_master sm on sm.stud_id=sba.student_id $where";
		$sql .= "group by sm.enrollment_no";
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

	// fetch student subject 
	function fetch_student_subjects($stud, $sem_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT `sm`.stud_id,`sm`.enrollment_no,sas.sub_applied_id,sm.current_semester,`s`.`stream_id` as `strmId`, s.subject_code,s.subject_name, s.subject_short_name,s.sub_id FROM `student_master` as `sm` LEFT JOIN `student_applied_subject` as `sas` ON `sas`.`stud_id` = `sm`.`stud_id` LEFT JOIN `subject_master` as `s` ON `s`.`sub_id` = `sas`.`subject_id` WHERE sm.`stud_id` = '".$stud."'  AND s.semester='".$sem_id."' AND sm.cancelled_admission='N' ORDER BY `sm`.`stud_id` DESC";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		
	}
		// fetch batch allocated student list
	function  getAllocatedStudList($stream_id='', $semester='', $academic_year='', $division='', $batch='')
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 AND sm.cancelled_admission='N' and sba.semester='".$semester."' and sba.stream_id='".$stream_id."' and sba.academic_year='".$academic_year."'  and sba.active='Y'";  
        if($batch !=''){
			$where .="	and sba.division='".$division."'";
		}		
		if($division !=''){
			$where .="  and sba.batch='".$batch."'";
		}		
        $sql="SELECT sm.stud_id,sba.roll_no, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no FROM `student_batch_allocation` as sba 
        left join student_master sm on sm.stud_id=sba.student_id $where";
		$sql .= "group by sm.enrollment_no";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function  getAllocatedStudList1($stream_id='', $semester='', $academic_year='', $division='', $batch='')
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 AND sm.cancelled_admission='N' and sba.semester='".$semester."' and sba.stream_id='".$stream_id."' and sba.academic_year='".$academic_year."'  and sba.active='Y' AND sm.admission_cycle='".$admission_cycle."'";  
                
        $sql="SELECT sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no FROM `student_batch_allocation` as sba 
        left join student_master sm on sm.stud_id=sba.student_id $where";
        $sql .= "group by sm.enrollment_no";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
	//
	
	function getStreamCode($stream_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        		
        $sql="SELECT stream_code,stream_name FROM `vw_stream_details` WHERE `stream_id` = '".$stream_id."' ORDER BY `stream_code` ASC";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
// added on 210917
	// fetch batch allocated student list
	function  getStudBatchAllotList($stream_id,$semester, $division,$academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 

            $where=" WHERE sba.stream_id='$stream_id' AND sba.semester='".$semester."' and sba.division='$division' and sba.academic_year='$academic_year' AND sm.cancelled_admission='N' and sba.active='Y'";
        $sql="SELECT sm.stud_id, sba.roll_no, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,sm.email,sm.transefercase, sba.division,sba.batch,sba.stream_id, sba.semester FROM `student_batch_allocation` as sba left join student_master sm on sm.stud_id=sba.student_id $where";
		$sql .= "group by sm.enrollment_no order by sba.roll_no";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
		// update student roll no
	function updateStudentRollNo($studId, $rollNo,$streamId, $sem_id, $division, $batch, $academic_year)
	 {
		$DB1 = $this->load->database('umsdb', TRUE); 
		$DB1->set('roll_no',$rollNo );	
        $wh_array = array('student_id' => $studId, 'semester' => $sem_id, 'stream_id' => $streamId,'division' => $division,'academic_year' => $academic_year);

		$DB1->where($wh_array);
		$DB1->update('student_batch_allocation'); 
		//echo $DB1->last_query();//exit;
		return true;
	 } 
	 
	function  chkDupStudentRollNo($rollNo, $streamId, $sem_id, $division, $batch, $academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="select b.* from student_batch_allocation b
		INNER JOIN student_master s on s.stud_id=b.student_id and s.cancelled_admission='N'
		where b.roll_no ='".$rollNo."' AND b.stream_id ='".$streamId."' AND b.semester ='".$sem_id."' AND b.division ='".$division."' and b.academic_year='".$academic_year."' and b.active='Y'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();
        return $query->result_array();
    }
///////
	function load_batchcources($academic_year){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct vw.course_id,vw.course_short_name from student_batch_allocation sba left join vw_stream_details vw on vw.stream_id = sba.stream_id where sba.academic_year ='".$academic_year."' and vw.course_name is not null order by vw.course_id asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	function load_batch_streams($course_id, $academic_year){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct vw.stream_id,vw.stream_name from student_batch_allocation sba left join vw_stream_details vw on vw.stream_id = sba.stream_id where sba.academic_year ='".$academic_year."' and vw.course_id='$course_id' order by vw.stream_id asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	function load_batchsemesters($stream_id, $academic_year){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct semester from student_batch_allocation where academic_year ='".$academic_year."' and stream_id='$stream_id' order by semester asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	function load_batch_division($stream_id, $academic_year, $semester){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct division from student_batch_allocation where academic_year ='".$academic_year."' and stream_id='$stream_id' and semester='$semester' order by division asc";
		$query = $DB1->query($sql);
		$stream_details = $query->result_array();
		return $stream_details;
	}
}