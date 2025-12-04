<?php

class Phd_marks_model extends CI_Model 

{

    function __construct()

    {

        parent::__construct();

    } 
	
    function get_unittest_details($id = '') {
        $DB1 = $this->load->database('umsdb', TRUE);  
		if($id!=''){
			$DB1->where('unit_test_id', $id);  
		}
		$DB1->from('student_test_master');
		$DB1->order_by("unit_test_id", "desc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }

	function get_unittest_bySubject($sub_id, $semester, $batch_code, $division,$academic_year) {

        $DB1 = $this->load->database('umsdb', TRUE);  

		if($sub_id!=''){

			$DB1->where('subject_id', $sub_id);  

			$DB1->where('semester', $semester);

			$DB1->where('division', $division);

			$DB1->where('batch_code', $batch_code);

			$DB1->where('academic_year', $academic_year); 

		}

		$DB1->from('student_test_master');

		$DB1->order_by("test_no", "asc");

		$query = $DB1->get();

		//echo $DB1->last_query();exit;

        return $query->result_array();

    }

    function fetch_unittest_details($id = '') {

        $DB1 = $this->load->database('umsdb', TRUE);  

		if($id!=''){

			$DB1->where('unit_test_id', $id);  

		}

		$DB1->select('student_test_master.*');

		$DB1->select('subject_master.subject_short_name');

		$DB1->select('vw_stream_details.stream_short_name');

		$DB1->from('student_test_master');

		$DB1->join('vw_stream_details', 'vw_stream_details.stream_id = student_test_master.stream_id', 'left');

		$DB1->join('subject_master', 'subject_master.sub_id = student_test_master.subject_id', 'left');

		$DB1->order_by("unit_test_id", "desc");

		$query = $DB1->get();

		//echo $DB1->last_query();exit;

        return $query->result_array();

    }	

	//

    function get_test_details($id = '') {

        $DB1 = $this->load->database('umsdb', TRUE);  

		if($id!=''){

			$DB1->where('unit_test_id', $id);  

		}

		$DB1->select('student_test_details.*');

		$DB1->select('student_master.first_name, student_master.last_name,student_master.enrollment_no_new');

		$DB1->from('student_test_details');

		$DB1->join('student_master', 'student_master.stud_id = student_test_details.stud_id', 'left');

		$DB1->order_by("student_master.enrollment_no_new", "asc");

		$query = $DB1->get();

		//echo $DB1->last_query();exit;

        return $query->result_array();

    }	

	    

	function get_numrows_testdetails($id = '') {

        $DB1 = $this->load->database('umsdb', TRUE);  

		$query =$DB1->query('select * from student_test_details where unit_test_id ="'.$id.'"');

		//echo $DB1->last_query();exit;

		return $query->num_rows();

    }

//

	function  get_studListByDivision($batch_code,$th_batch, $semester)

    {

        $DB1 = $this->load->database('umsdb', TRUE); 

		$where=" WHERE 1=1 AND cancelled_admission ='N' AND sba.semester='".$semester."' ";  

        

        if($batch_code!="" && $th_batch !=0)

        {

            $where.=" AND sba.batch_code ='".$batch_code."'";

        }else{

			$th_bt = explode('-', $batch_code);

			$th_batchCode = $th_bt[0].'-'.$th_bt[1];

			$where.=" AND sba.batch_code LIKE '%".$th_batchCode."%'";

		}

		

        $sql="SELECT sba.sub_applied_id,sba.roll_no,sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.enrollment_no_new,sm.mobile 
		FROM `student_batch_allocation` as sba 
		left join student_applied_subject sas on sas.sub_applied_id=sba.sub_applied_id 
		left join student_master sm on sm.stud_id=sas.stud_id $where";

		$sql .=" GROUP BY sm.enrollment_no_new order by sm.enrollment_no_new";

        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

    }	

	function getFacultySubjects($emp_id) {

        $DB1 = $this->load->database('umsdb', TRUE);

        $sql = "select distinct t.subject_code as subject_id,t.division, vw.stream_code, t.batch_no,s.subject_code as sub_code,
		s.subject_short_name,s.semester from lecture_time_table as t 
		left join subject_master s on s.sub_id = t.subject_code 

		left join vw_stream_details vw on vw.stream_id =s.stream_id

		where t.faculty_code='".$emp_id."'";

        $query = $DB1->query($sql);

        $sub_details = $query->result_array();

		//echo $DB1->last_query();exit;

		return $sub_details;

    }	

	//

	function fetch_marks($testId, $subject_id) {

        $DB1 = $this->load->database('umsdb', TRUE);  

		if($testId!=''){

			$DB1->where('unit_test_id', $testId);  

			$DB1->where('stud_id', $subject_id);  

		}

		$DB1->from('student_test_details');

		$query = $DB1->get();

		//echo $DB1->last_query();exit;

        return $query->result_array();

    }

	//get subject details

	function getsubdetails($subId){

		$DB1 = $this->load->database('umsdb', TRUE);

        $sql = "select * from subject_master where sub_id='" .$subId. "'";

		//AND t.faculty_code='".$emp_id."'

        $query = $DB1->query($sql);

        $sub_details = $query->result_array();

		//echo $DB1->last_query();

		return $sub_details;

	}

	function chk_dupcia($subject, $cia) {

        $DB1 = $this->load->database('umsdb', TRUE);  

		$query =$DB1->query('select * from student_test_master where test_no ="'.$cia.'" AND subject_id ="'.$subject.'"');

		//echo $DB1->last_query();exit;

		return $query->num_rows();

    }

	

	function list_exam_subjects($data,$exam_id){

		$DB1 = $this->load->database('umsdb', TRUE); 
		$sem= $data['semester'];
		$stream= $data['admission-branch'];
		//$sem= $data['semester'];
		$where=" WHERE sm.is_active='Y' AND eas.exam_id='$exam_id'";  
		if($data['marks_type'] !='CIA'){
			$where .="  AND (sm.subject_component='TH' OR sm.subject_component='EM')";  
		}
       // $stream_arr = array(5,6,7,8,9,10,11,96,97);

		//$stream_arr1 = array(43,44,45,46,47);

        if($sem!="" && $data['reval']=='')
        {
            $where.=" AND eas.semester='".$sem."'";
        }

	

		/*if (in_array($stream,  $stream_arr)){

			$where.=" AND eas.stream_id =9";	

		}else if(in_array($stream,  $stream_arr1)){

			$where.=" AND eas.stream_id =103";

		}else{*/

			$where.=" AND eas.stream_id='".$stream."'";

		//}	
		if($data['reval']!=''){
			$where.=" AND eas.reval_appeared='Y'";
		}
		$sql="SELECT sm.* FROM `phd_exam_applied_subjects` as eas
		left join subject_master sm on sm.sub_id=eas.subject_id $where group by eas.subject_id";

        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();

	}



	//getStreamShortName

	function getStreamShortName($stream_id){

        $DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT stream_short_name,stream_code,stream_name,school_short_name,school_name FROM 
		vw_stream_details where stream_id='".$stream_id."'";	

        $query = $DB1->query($sql);

        return $query->result_array();

    }

	

	// fetch marksdetails

	function getMarksEntry($subjectId ='', $exam_id='',$marks_type='', $stream='', $semester='',$reval='')

	{

		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT * FROM phd_marks_entry_master where subject_id='".$subjectId."' AND exam_id='".$exam_id."'  AND stream_id ='".$stream."' ";	

		if($reval ==''){

			$sql .=" AND semester ='".$semester."'";

		}

		if($marks_type !='CIA'){

			$sql .=" AND marks_type='".$marks_type."'";

		}

        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

	}



	// fetch master entry

	function fetch_me_details($me_id)

	{

		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT * FROM phd_marks_entry_master where me_id='".$me_id."'";	

        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

	}

	

	// fetch master entry

	function get_marks_details($me_id, $exam_id,$subdetails)
	{
		//print_r($subdetails);
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sub_id  =$subdetails[0];
		$stream_id= $subdetails[3];
		$semester  =$subdetails[4];
		$marks_type  =$subdetails[6];
		$division= $subdetails[7];
		$batch= $subdetails[8];
		$is_backlog= $subdetails[10];
		
		if($batch !=0){
			$where =" and sba.batch='$batch' ";
		}else{
			$where ="";
		}
		
		if($is_backlog=='N'){
		if($division !=''){
			$div =" and sba.division='$division' ";
		}else{
			$div ="";
		}
		}else{
			$where ="";
			$div ="";
		}
		//print_r($subdetails);exit;
		if($marks_type !='PR'){
		$sql="SELECT m.m_id,me_id, e.enrollment_no,e.stud_id,e.subject_id,e.stream_id,e.semester,e.exam_id,e.exam_month,e.exam_year,m.marks_type,m.marks,m.reval_marks,m.division,m.batch_no,s.first_name,s.last_name, s.middle_name FROM phd_exam_applied_subjects e

left join phd_marks_entry m on m.exam_id=e.exam_id and m.stud_id=e.stud_id and m.subject_id=e.subject_id and m.marks_type='TH'
left join student_master s on s.enrollment_no=m.enrollment_no 
where e.subject_id='$sub_id' and e.exam_id='$exam_id' order by e.enrollment_no";	
		}else{
		$sql="SELECT m.m_id,me_id,e.enrollment_no,e.stud_id,e.subject_id,e.stream_id,e.semester,e.exam_id,e.exam_month,e.exam_year,m.marks_type,m.marks,m.reval_marks,m.division,m.batch_no, s.first_name,s.last_name, s.middle_name FROM phd_exam_applied_subjects  e 
left join phd_marks_entry m on e.subject_id=m.subject_id and e.exam_id=m.exam_id and e.stud_id=m.stud_id and m.marks_type !='TH'
left join student_batch_allocation sba on e.stud_id=sba.student_id and e.stream_id=sba.stream_id 
left join student_master s on s.enrollment_no=e.enrollment_no 
where  e.subject_id='$sub_id' and e.exam_id='$exam_id' $where $div
group by e.enrollment_no order by e.enrollment_no"; 
	}

        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();
	}
	function get_pract_marks_details($me_id,$stream_id,$semester,$division,$batch_no, $exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$roleid= $this->session->userdata('role_id');
		if($roleid !='15'){
		$sql="SELECT m.*, s.first_name,s.last_name, s.middle_name FROM phd_marks_entry m left join student_master s on s.enrollment_no=m.enrollment_no
		where  m.me_id='".$me_id."' and m.exam_id='$exam_id' and m.stream_id='$stream_id' and m.semester='$semester' and m.division='$division' and m.batch_no='$batch_no' order by m.enrollment_no";	
		}else{
			$sql="SELECT m.*, s.first_name,s.last_name, s.middle_name FROM phd_marks_entry m left join student_master s on s.enrollment_no=m.enrollment_no
		where  m.subject_id='".$me_id."' and m.exam_id='$exam_id' and m.stream_id='$stream_id' and m.semester='$semester' order by m.enrollment_no";
		}
        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

	}
	function get_cia_marks_details($me_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT c.*, s.first_name,s.last_name, s.middle_name FROM phd_marks_entry_cia c
		left join student_master s on s.enrollment_no=c.enrollment_no
		where me_id='".$me_id."'";	
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();

	}	

	// marks details

	function updateMarkDetails($data, $m_id) {

		$DB1 = $this->load->database('umsdb', TRUE); 

        $count = count($data['stud_id']);

        //echo $count;

        for ($i = 0; $i < $count; $i++) {
			$mrk_id = $data['mrk_id'][$i];
			$stud_mrks = $this->get_studmarks($mrk_id, $m_id);
        	if($stud_mrks != $data['marks_obtained'][$i]){
				$sql ="INSERT INTO phd_marks_entry_log (`m_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `marks_type`, `marks`, `exam_id`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted`)
				SELECT `m_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `marks_type`, `marks`, `exam_id`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted` FROM phd_marks_entry where m_id='$mrk_id' and me_id='$m_id'";
				$query = $DB1->query($sql);
			}
            $spk['stud_id'] = $data['stud_id'][$i];
            $spk['enrollment_no'] = $data['enrollement_no'][$i];
            

			$spk['marks'] = $data['marks_obtained'][$i];
            $name = $spk['spk_name'];
            $contactno = $spk['contact_no'];
            $event_spk_id = $spk['event_spk_id'];
                //echo"in update";

			$spk['modified_by'] = $this->session->userdata("uid");
			$spk['modified_on'] = date('Y-m-d H:i:s');
			
			$DB1->where('me_id', $m_id);
			$DB1->where('m_id', $mrk_id);
			$DB1->update('phd_marks_entry', $spk);
            //echo $this->db->last_query();exit;
            unset($mrk_id);
			unset($sql);

        }

         return true;

    }
	// checking student marks
	function get_studmarks($mrk_id, $m_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT `marks` FROM phd_marks_entry where m_id='$mrk_id' and me_id='$m_id'";	
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
        return $res[0]['marks'];
	}
	
	// fetch CIA marksdetails
function getFaqExam_applied_subjects($emp_id, $curr_session,$exam_id,$academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE eas.exam_id='$exam_id' and eas.allow_for_exam='Y'";  
		if($curr_session=='WINTER'){
			$cursession ='WIN';
		}else{
			$cursession ='SUM';
		}
        if($emp_id!="")
        {
            $where.=" AND faculty_code='".$emp_id."'";
        }
		// fetch stream of faculty
		$fac_stream = $this->fetch_faculty_stream($emp_id);
        $fac_stream_id = $fac_stream[0]['stream_id'];
		
        if($fac_stream_id !='71'){
			//if($emp_id==110352){}else{
        	//$where.=" AND t.academic_session ='".$cursession."' and t.academic_year='$academic_year'";
			//}
        }			
        $sql="SELECT distinct t.subject_code, s.subject_code as sub_code,s.subject_short_name,s.subject_name,s.sub_id,
		eas.semester,s.credits,s.subject_component, eas.stream_id, f.fname,f.mname,f.lname, vw.stream_short_name,
		s.internal_max FROM `phd_exam_applied_subjects` as eas 
		left join `lecture_time_table` t on t.subject_code = eas.subject_id
		left join subject_master s on s.sub_id = t.subject_code 
		left join vw_stream_details vw on vw.stream_id=eas.stream_id
		left join vw_faculty f on f.emp_id = t.faculty_code 
		$where group by t.subject_code";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	
		// fetch CIA marksdetails
function getFaqExam_applied_subjects_one($emp_id, $curr_session,$exam_id,$academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE eas.exam_id='$exam_id' and eas.allow_for_exam='Y'";  
		if($curr_session=='WINTER'){
			$cursession ='WIN';
		}else{
			$cursession ='SUM';
		}
        if($emp_id!=110078)
        {
            $where.=" AND faculty_code='".$emp_id."'";
        }
		// fetch stream of faculty
		$fac_stream = $this->fetch_faculty_stream($emp_id);
        $fac_stream_id = $fac_stream[0]['stream_id'];
		//exit();
        if($fac_stream_id !='71'){
        //	$where.=" AND t.academic_session ='".$cursession."' and t.academic_year='$academic_year'";//t.subject_code
        }			
        $sql="SELECT distinct t.subject_code, s.subject_code as sub_code,s.subject_short_name,s.subject_name,s.sub_id,
		eas.semester,s.credits,s.subject_component, eas.stream_id,
		
		  vw.stream_short_name,
		s.internal_max FROM `phd_exam_applied_subjects` as eas 
		left join `lecture_time_table` t on t.subject_code = eas.subject_id
		left join subject_master s on s.sub_id = t.subject_code 
		left join vw_stream_details vw on vw.stream_id=eas.stream_id
	
		$where group by t.subject_code";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	
	
		function getCIAMarksEntry($subjectId, $exam_id, $marks_type, $stream, $semester)

	{

		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT * FROM phd_marks_entry_master where subject_id='".$subjectId."' AND exam_id='".$exam_id."' AND stream_id ='".$stream."' AND semester ='".$semester."'";	

		

		if($marks_type =='CIA'){

			$sql .=" AND marks_type='".$marks_type."'";

		}

        $query = $DB1->query($sql);

		//echo $DB1->last_query();//exit;

        return $query->result_array();

	}

	

	// fetch master entry

	function get_ciamarks_details($me_id)

	{

		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT m.*, s.first_name,s.last_name, s.middle_name FROM phd_marks_entry_cia m left join student_master s on s.stud_id=m.stud_id where me_id='".$me_id."' order by enrollment_no";	

        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

	}
	function get_ciamarks_details_coe($subject, $stream,$exam_id)

	{

		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT * FROM phd_marks_entry_cia where subject_id='".$subject."' and stream_id='$stream' and exam_id ='$exam_id' order by enrollment_no";	

        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

	}
	// marks details

	function updateCIAMarkDetails($data, $m_id) {
		$max_marks = $data['max_marks'];
		$DB1 = $this->load->database('umsdb', TRUE); 
        $count = count($data['stud_id']);
        //echo $count;
        for ($i = 0; $i < $count; $i++) {
			$mrk_id = $data['mrk_id'][$i];
			//inserting cia log
        	$stud_ciamrks = $this->get_studCIAmarks($mrk_id, $m_id);
        	if($stud_ciamrks != $data['marks_obtained'][$i]){
				$sql ="INSERT INTO phd_marks_entry_cia_log (`cia_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `cia_marks`,`attendance_marks`, `exam_id`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted`)
				SELECT `cia_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `cia_marks`,`attendance_marks`, `exam_id`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted` FROM phd_marks_entry_cia where cia_id='$mrk_id' and me_id='$m_id'";
				$query = $DB1->query($sql);
			}
			//end log
            $spk['stud_id'] = $data['stud_id'][$i];
            $spk['enrollment_no'] = $data['enrollement_no'][$i];
            
			$spk['cia_marks'] = $data['marks_obtained'][$i];
			$spk['attendance_marks'] = $data['attdance_marks'][$i];
            $name = $spk['spk_name'];
            $contactno = $spk['contact_no'];
            $event_spk_id = $spk['event_spk_id'];
              //echo"in update";
			$spk['modified_by'] = $this->session->userdata("uid");
			$spk['modified_on'] = date('Y-m-d H:i:s');
			$DB1->where('me_id', $m_id);
			$DB1->where('cia_id', $mrk_id);
			$DB1->update('phd_marks_entry_cia', $spk);
            //echo $DB1->last_query();exit;
            unset($mrk_id);
			unset($sql);
        }
		if($max_marks !=''){
			$DB1->where('me_id', $m_id);
			$max['max_marks'] = $max_marks;
			$DB1->update('phd_marks_entry_master', $max);			
		}

         return true;

    }
	// checking student cia marks for log
	function get_studCIAmarks($mrk_id, $m_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT `cia_marks` FROM phd_marks_entry_cia where cia_id='$mrk_id' and me_id='$m_id'";	
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
        return $res[0]['cia_marks'];
	} 	
    // exam subject list for status
    function list_exam_subjects_for_status($data, $exam_id)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        
        $sem = $data['semester'];        
        $stream = $data['admission-branch'];
        $where = " WHERE sm.is_active='Y'";
        
        if ($sem != "") {            
            $where .= " AND eas.semester='" . $sem . "'";           
        }
          
        $where .= " AND eas.stream_id='" . $stream . "' AND eas.exam_id ='$exam_id' and eas.allow_for_exam='Y'";
   
        $sql = "SELECT sm.* FROM `phd_exam_applied_subjects` as eas
		left join subject_master sm on sm.sub_id=eas.subject_id $where group by eas.subject_id";
        
        $query = $DB1->query($sql);
        
        //echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
    // get theory marks entry status 
    function getTHMarksEntryStatus($subjectId, $exam_month, $exam_year, $marks_type, $stream, $semester)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM phd_marks_entry_master where subject_id='" . $subjectId . "' AND exam_month='" . $exam_month . "' AND exam_year='" . $exam_year . "' AND stream_id ='" . $stream . "' AND semester ='" . $semester . "'";           
        $sql .= " AND marks_type in('TH','PR')";
 
        $query = $DB1->query($sql);        
       // echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
    // get CIA marks entry status 
    function getCIAMarksEntryStatus($subjectId, $exam_month, $exam_year, $marks_type, $stream, $semester)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM phd_marks_entry_master where subject_id='" . $subjectId . "' AND exam_month='" . $exam_month . "' AND exam_year='" . $exam_year . "' AND stream_id ='" . $stream . "' AND semester ='" . $semester . "'";
        $sql .= " AND marks_type='CIA'";
        
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
	
    // prev exam students subjects
    function list_prev_exam_stud_subjects($data)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        
        $sem = $data['semester'];        
        $stream = $data['admission-branch'];
		$regulation = $data['regulation'];
        $where = " WHERE sm.is_active='Y' and sm.regulation='$regulation'";
        
        if ($sem != "") {            
            $where .= " AND sm.semester='" . $sem . "'";           
        }
		
        $stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,158,159,162); 
		$stream_arr1 = array(43,44,45,46,47);
		if (in_array($stream,  $stream_arr)){

			$where.=" AND sm.stream_id =9";	

		}else if(in_array($stream,  $stream_arr1)){

			$where.=" AND sm.stream_id =103";

		}else{

			$where.=" AND sm.stream_id='".$stream."'";

		}
        //$where .= " AND sm.stream_id='" . $stream . "'";
   
        $sql = "SELECT sm.* FROM subject_master sm  $where order by sm.subject_code";
        
        $query = $DB1->query($sql);
        
       // echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
    // prev exam grade entry
    function list_prev_exam_students($data, $exam_sess_acdyer)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        
        $sem = $data['semester'];        
        $stream = $data['admission-branch'];
		$regulation = $data['regulation'];
        $where = " WHERE sm.actice_status='Y' and sm.cancelled_admission='N' and ad.academic_year='$exam_sess_acdyer' and sm.admission_session='$regulation'";
        
        if ($sem != "") {  
			if($sem==1 || $sem==2){
				$year=1;
			}elseif($sem==3 || $sem==4){
				$year=2;
			}elseif($sem==5 || $sem==6){
				$year=3;
			}else{
				$year=4;
			}
            $where .= " AND ad.year='" . $year . "'";           
        }
          
        $where .= " AND ad.stream_id='" . $stream . "'";
        $sql = "SELECT * FROM admission_details as ad left join student_master sm on sm.stud_id= ad.student_id $where order by sm.enrollment_no";
        
        $query = $DB1->query($sql);
        

        //echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    } 
	//
	function list_examresult_students_for_grade($data,$exam_id)
    {

        $DB1 = $this->load->database('umsdb', TRUE);      
        $sem = $data['semester'];        
        $stream = $data['admission-branch'];
		$regulation = $data['regulation'];
        $grade_updtype = $data['grade_updtype'];
        
			$sql = "SELECT distinct erd.student_id, sm.first_name,sm.last_name,erd.semester,sm.stud_id,sm.enrollment_no,ed.is_verified FROM phd_exam_result_data erd 
			left join exam_result_details ed on ed.stream_id=erd.stream_id and ed.exam_id=erd.exam_id and ed.semester='erd.semester'
			left join student_master sm on sm.stud_id = erd.student_id
			where erd.exam_id='".$exam_id."' AND erd.stream_id ='".$stream."' AND erd.semester ='".$sem."' "; 
			if($regulation=='2017'){
				$sql .=" and sm.admission_session in('2017','2018')";
			}else{
				$sql .=" and sm.admission_session ='2016'";
			}
			if($grade_updtype=='Malpractice'){
				$sql .=" and erd.malpractice ='Y'";
			}

		 //$sql .=" and erd.malpractice ='Y'";
        $query = $DB1->query($sql);
        
        //echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
	// check grade present or not in grade table
    function fetch_examGrades($var, $exam_id)
    {       
       // print_r($var);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM phd_exam_result_data where stream_id ='".$var['admission-branch']."' AND semester ='".$var['semester']."' and exam_id='".$exam_id."'";        
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;   
        return $query->result_array();       
    } 
	//list_examAppliedstud_subjects
    function list_examAppliedstud_subjects($var, $exam_month, $exam_year)
    {       
       // print_r($var);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT distinct erd.subject_id, sm.subject_code,sm.subject_name,sm.sub_id FROM phd_exam_result_data erd 
		left join subject_master sm on sm.sub_id = erd.subject_id
		where erd.exam_month='".$exam_month."' AND erd.exam_year='".$exam_year."' AND erd.stream_id ='".$var['admission-branch']."' AND erd.semester ='".$var['semester']."'";        
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;   
        return $query->result_array();       
    } 	
	// fetch studen subject grades
    function fetchstudentsubgrade($stud_id,$sub_id,$exam_id)
    {       
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT result_grade,result_id FROM phd_exam_result_data where exam_id='$exam_id' and student_id='".$stud_id."' and subject_id='".$sub_id."'";     
        $query = $DB1->query($sql);    
        //echo $DB1->last_query();exit;       
        return $query->result_array();
        
    } 
	// fetch grade letters    
    function list_grade_letter()
    {       
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT distinct `grade_letter` FROM `grade_policy_details`";     
        $query = $DB1->query($sql);    
        //echo $DB1->last_query();exit;       
        return $query->result_array();
        
    }  
    function fetch_exam_allsession()
    {       
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM exam_session where deleted ='N'";     
        $query = $DB1->query($sql);    
        //echo $DB1->last_query();exit;       
        return $query->result_array();
        
    } 	
	function fetch_credits_earned($enrollment_no, $exam_id){
		
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select  sum(credits_earned) as credits_earned  from exam_result_master WHERE `student_id` = '$enrollment_no' and exam_id <= $exam_id";     
        $query = $DB1->query($sql);    
        //echo $DB1->last_query();exit;       
        return $query->result_array();
	}
// for faculty exam applied subjects
	function getFaqphd_exam_applied_subjects($emp_id, $curr_session,$exam_id,$academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE eas.exam_id='$exam_id' and eas.allow_for_exam='Y'";  
		if($curr_session=='WINTER'){
			$cursession ='WIN';
		}else{
			$cursession ='SUM';
		}
        if($emp_id!="")
        {
            $where.=" AND faculty_code='".$emp_id."'";
        }
		// fetch stream of faculty
		$fac_stream = $this->fetch_faculty_stream($emp_id);
        $fac_stream_id = $fac_stream[0]['stream_id'];
		
        if($fac_stream_id !='71'){
        	$where.=" AND t.academic_session ='".$cursession."' and t.academic_year='$academic_year'";
        }			
        $sql="SELECT distinct t.subject_code, s.subject_code as sub_code,s.subject_short_name,s.subject_name,s.sub_id,eas.semester,s.credits,s.subject_component, eas.stream_id, f.fname,f.mname,f.lname, vw.stream_short_name,s.internal_max FROM 
		`phd_exam_applied_subjects` as eas left join `lecture_time_table` t on t.subject_code = eas.subject_id
		left join subject_master s on s.sub_id = t.subject_code 
		left join vw_stream_details vw on vw.stream_id=eas.stream_id
		left join vw_faculty f on f.emp_id = t.faculty_code 
		$where group by t.subject_code";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	
	//  fetch batch allocated student list 
	function  get_studbatch_allot_list($batch_code,$th_batch,$subId,$streamId, $semester)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 AND sm.cancelled_admission ='N' AND sas.is_active='Y'
		 AND sas.subject_id='$subId' AND sba.semester='".$semester."' ";  //AND sba.academic_year='2019-20' AND sm.is_detained='N'
        $th_bt = explode('-', $batch_code);
		$division = $th_bt[1];
		$batch = $th_bt[2];
        if($batch_code!="" && $th_batch !=0)
        {
            $where.=" AND sba.division ='".$division."' AND sba.batch ='".$batch."'";
        }else{
			
			$where.=" AND sba.division ='".$division."'";
		}
		$stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,158,159,162); 

		if($semester==1 || $semester==2){
			if (in_array($streamId,  $stream_arr)){

				$where.=" AND sas.stream_id =9";	

			}else{

				$where.=" AND sas.stream_id='".$streamId."'";

			}
		}else{
			$where.=" AND sas.stream_id='".$streamId."'";
		}
		
        $sql="SELECT  sba.roll_no,sm.stud_id,sm.is_detained,sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,sm.admission_stream FROM `student_batch_allocation` as sba left join student_applied_subject sas on sas.stud_id=sba.student_id left join student_master sm on sm.stud_id=sas.stud_id $where";
		
		$sql .=" GROUP BY sm.enrollment_no order by sm.enrollment_no, sba.roll_no";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	//
	function fetchDivBatchEntryDetails($sub_id, $stream_id, $semester,$division, $batch, $exam_month, $exam_year)
    {
    			$DB1 = $this->load->database('umsdb', TRUE); 
		// $batch_code;exit;

		$sql="SELECT mem.division, mem.batch_no, m.* FROM phd_marks_entry_master m left join phd_marks_entry_cia mem on m.me_id =mem.me_id 
		where m.subject_id='".$sub_id."' AND m.exam_month='".$exam_month."' AND m.exam_year='".$exam_year."' AND m.stream_id ='".$stream_id."' AND m.semester ='".$semester."' and mem.division='$division' and mem.batch_no ='$batch' group by me_id";	

        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();
    }
    //
    function load_cia_streams($course_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$this->load->model('Subject_model');
		$sql = "SELECT distinct c.`stream_id`, vw.stream_name,vw.stream_short_name FROM `phd_marks_entry_cia` c left join vw_stream_details vw on vw.stream_id=c.stream_id where vw.course_id='".$course_id."' ";
		
		if(isset($role_id) && $role_id==20){
			 $empsch = $this->Subject_model->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $sql .=" and school_code = $schid";
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" and school_code = $sccode";
		}
		$query = $DB1->query($sql);
		//echo $DB1->last_query();
		$stream_details = $query->result_array();
		return $stream_details;
	}
	// list cia subjects streamwise

	function list_cia_subjects($data){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam= explode('-', $data['exam_session']);
		$exam_id = $exam[2];
		$sem= $data['semester'];
		$stream= $data['admission-branch'];
		$data['marks_type']='CIA';
		$where=" WHERE sm.is_active='Y' and c.exam_id='$exam_id' ";  
		if($data['marks_type'] !='CIA'){
			$where .="  AND sm.subject_component='".$data['marks_type']."' ";  
		}	

       // $stream_arr = array(5,6,7,8,9,10,11,96,97);
	   //$stream_arr1 = array(43,44,45,46,47);

        if($sem!="")
        {
            $where.=" AND c.semester='".$sem."'";
        }
		/*if (in_array($stream,  $stream_arr)){
			$where.=" AND eas.stream_id =9";	
		}else if(in_array($stream,  $stream_arr1)){
			$where.=" AND eas.stream_id =103";
		}else{*/
			$where.=" AND c.stream_id='".$stream."'";
		//}	

		$sql="SELECT sm.subject_code, sm.subject_name,sm.subject_short_name,sm.subject_component, c.subject_id,c.stream_id FROM `phd_marks_entry_cia` as c
		left join subject_master sm on sm.sub_id=c.subject_id $where group by c.subject_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();

	}
	// list_cia_students_of_stream
	function list_cia_students_of_stream($var, $exam_id){
		//print_r($var);
		$DB1 = $this->load->database('umsdb', TRUE);
		$sem= $var['semester'];
		$stream= $var['admission-branch'];

		//$sql = "SELECT c.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no, subject_id FROM `phd_marks_entry_cia` as c left join student_master sm on sm.stud_id=c.stud_id where sm.actice_status='Y' AND sm.cancelled_admission='N' AND c.stream_id='".$stream."' AND c.semester='".$sem."' group by c.stud_id";
	$sql = "SELECT c.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no, subject_id FROM `phd_marks_entry_cia` as c left join student_master sm on sm.stud_id=c.stud_id where  c.stream_id='".$stream."' AND c.semester='".$sem."' and c.exam_id='$exam_id' group by c.stud_id";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}

	// fetch studen subject cia/attendance marks
    function fetchstudentsubCIAmarks($stud_id,$sub_id,$exam_month,$exam_year, $exam_id)
    {    
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT cia_marks,attendance_marks FROM phd_marks_entry_cia where exam_month='$exam_month' and  exam_year='$exam_year' and stud_id='".$stud_id."' and subject_id='".$sub_id."' and exam_id='".$exam_id."'";     
        $query = $DB1->query($sql);    
        //echo $DB1->last_query();exit;
        return $query->result_array();        
    }
	// fetch faculty stream 
	function fetch_faculty_stream($emp_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT stream_id FROM `lecture_time_table` WHERE `faculty_code`='$emp_id'";
        $query = $DB1->query($sql);
        return $query->result_array();
	}
    
	//get_cia_examsemester
	function get_cia_examsemester($stream_id, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct semester from phd_marks_entry_cia  where stream_id='".$stream_id."' and exam_id ='$exam_id' order by semester asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();
		$stream_details = $query->result_array();
		return $stream_details;
	}
	// semester subjects
    function fetch_subjects_exam_semester($result_data) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[2];
        $exam_month =$res_data[3];
        $exam_year =$res_data[4];
        $exam_id =$res_data[5];

        $sql="SELECT distinct e.subject_id, s.subject_code1,s.subject_code,s.subject_name,s.subject_short_name,s.theory_max,s.theory_min_for_pass,s.internal_max,s.internal_min_for_pass,s.sub_min,s.sub_max FROM `phd_exam_applied_subjects` e left join subject_master s on e.subject_id= s.sub_id where e.semester='".$semester."' and e.exam_id='$exam_id' AND e.exam_month='$exam_month' AND e.exam_year='$exam_year'and e.stream_id='$stream_id' and e.allow_for_exam='Y' order by s.subject_order ASC";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    // get theory marks entry status 
    function fetch_stud_sub_marks_thpr($studentid, $subjectId, $exam_id, $stream, $semester)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM phd_marks_entry where stud_id ='".$studentid."' and subject_id='" . $subjectId . "' AND exam_id='" . $exam_id . "' AND stream_id ='" . $stream . "' AND semester ='" . $semester . "'";           
        $sql .= " AND marks_type in('TH','PR')";
 
        $query = $DB1->query($sql);        
       // echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
    // get CIA marks entry status 
    function fetch_stud_sub_marks_cia($studentid,$subjectId, $exam_id, $stream, $semester)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM phd_marks_entry_cia where stud_id ='".$studentid."' and subject_id='" . $subjectId . "' AND exam_id='" . $exam_id . "' AND stream_id ='" . $stream . "' AND semester ='" . $semester . "'";
        
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
   // fetch student result data
    function fetch_student_result_data($result_data) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[2];
        $exam_month =$res_data[3];
        $exam_year =$res_data[4];
        $exam_id =$res_data[5];

        $where=" where sas.semester='".$semester."' AND sas.exam_month='$exam_month' AND sas.exam_year='$exam_year'and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' and sas.allow_for_exam='Y'";

        $sql="SELECT sas.*,s.first_name, s.middle_name, s.last_name FROM `phd_exam_applied_subjects` as sas left join student_master s on s.stud_id=sas.stud_id
        $where group by sas.stud_id";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
    // exam subject applied status
    function list_exam_subjects_for_status_applied($data, $exam_id)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        
        $sem = $data['semester'];        
        $stream = $data['admission-branch'];
        $where = " WHERE sb.is_active='Y'";
        
        //if ($sem != "") {            
            $where .= " AND s.semester='" . $sem . "'";           
        //}
          
        $where .= " AND s.stream_id='" . $stream . "' AND s.exam_id ='$exam_id' and s.allow_for_exam='Y'";
   
        $sql = "SELECT s.stream_id,s.semester,s.subject_id,sb.subject_code,sb.subject_name,c.me_id as c_me_id, m.me_id as m_me_id,
CASE WHEN sb.theory_max=0 THEN 'N' ELSE 'Y' END AS th_status,
CASE WHEN sb.internal_max=0 THEN 'N' ELSE 'Y' END AS cia_status,
CASE WHEN sb.practical_max=0 THEN 'N' ELSE 'Y' END AS pr_status,
COUNT(s.stud_id)AS stud_count,
SUM( CASE WHEN m.marks IS NULL THEN 0 ELSE 1 END)AS th_entry,
SUM( CASE WHEN c.cia_marks IS NULL THEN 0 ELSE 1 END)AS cia_entry,
SUM( CASE WHEN m.marks IS NULL THEN 0 ELSE 1 END)AS pr_entry
FROM phd_exam_applied_subjects  s 
LEFT JOIN phd_marks_entry_cia c ON c.stud_id=s.stud_id AND s.subject_id=c.subject_id AND c.exam_id=s.exam_id
LEFT JOIN phd_marks_entry m ON m.stud_id=s.stud_id AND s.subject_id=m.subject_id AND s.exam_id=m.exam_id
LEFT JOIN subject_master sb ON sb.sub_id=s.subject_id
$where group by s.subject_id";//exit;
        
        $query = $DB1->query($sql);
        
        //echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
 // exam subject applied status
    function get_cia_and_thmarks_details($sub_id, $stream, $semester,$exam_id)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        
        $sql = "SELECT s.enrollment_no,s.stream_id,s.semester,s.subject_id,s.subject_code ,c.cia_marks,c.attendance_marks,m.marks,
sb.theory_max,sb.theory_min_for_pass,sb.internal_max,sb.internal_min_for_pass,sb.sub_min,sb.sub_max
FROM phd_exam_applied_subjects  s 
LEFT JOIN phd_marks_entry_cia c ON c.stud_id=s.stud_id AND s.subject_id=c.subject_id AND c.exam_id=s.exam_id
LEFT JOIN phd_marks_entry m ON m.stud_id=s.stud_id AND s.subject_id=m.subject_id AND s.exam_id=m.exam_id
LEFT JOIN subject_master sb ON sb.sub_id=s.subject_id
WHERE s.exam_id='$exam_id' AND s.stream_id='$stream' AND s.semester='$semester' and s.subject_id='$sub_id' and s.allow_for_exam='Y' order by s.enrollment_no";
        
        $query = $DB1->query($sql);
        
        //echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
	function getSubjectStudentList_reval($subject_id,$stream_id, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);  
		//$ex_session = $this->fetch_stud_curr_exam();
		//$exam_id =$ex_session[0]['exam_id']; 
		
		$sql="SELECT sas.stud_id, sas.enrollment_no, sas.subject_id,s.first_name, s.middle_name, s.last_name,
		sas.is_absent,m.marks,m.reval_marks,m.m_id,m.me_id FROM `phd_exam_applied_subjects` as sas 
		left join subject_master sm on sm.sub_id=sas.subject_id 
		left join student_master s on s.stud_id=sas.stud_id 
		left join phd_marks_entry m on m.stud_id=sas.stud_id and m.exam_id=sas.exam_id and m.subject_id=sas.subject_id
		where sas.subject_id='".$subject_id."' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' and sm.is_active='Y' and sas.reval_appeared='Y'";
		$sql.=" group by sas.stud_id order by sas.enrollment_no";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
// update reval marks details
	function updateMarkDetails_reval($data, $m_id) {

		$DB1 = $this->load->database('umsdb', TRUE); 

        $count = count($data['stud_id']);

        //echo $count;

        for ($i = 0; $i < $count; $i++) {
			$mrk_id = $data['mrk_id'][$i];
			$stud_mrks = $this->get_studmarks($mrk_id, $m_id);
        	if($stud_mrks != $data['marks_obtained'][$i]){
				$sql ="INSERT INTO phd_marks_entry_log (`m_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `marks_type`, `marks`, `exam_id`,reval_marks, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted`)
				SELECT `m_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `marks_type`, `marks`,reval_marks, `exam_id`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted` FROM phd_marks_entry where m_id='$mrk_id' and me_id='$m_id'";
				$query = $DB1->query($sql);
			}
            $spk['stud_id'] = $data['stud_id'][$i];
            $spk['enrollment_no'] = $data['enrollement_no'][$i];
            

			$spk['reval_marks'] = $data['marks_obtained'][$i];
            $name = $spk['spk_name'];
            //echo"in update";

			$spk['reval_entry_by'] = $this->session->userdata("uid");
			$spk['reval_entry_on'] = date('Y-m-d H:i:s');
			$spk['reval_entry_ip'] = $this->input->ip_address();
			
			$DB1->where('me_id', $m_id);
			$DB1->where('m_id', $mrk_id);
			$DB1->update('phd_marks_entry', $spk);
            //echo $DB1->last_query();exit;
            unset($mrk_id);
			unset($sql);

        }
         return true;
    }
/************** Practical faculty Assign *****************/
	function  get_subdetails($subject_id,$stream_id,$semester,$exam_id, $division, $batch_no)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		
       /* $sql="SELECT sm.subject_type,eas.stream_id,eas.semester, sm.subject_name,sm.subject_code as sub_code,eas.subject_id,sm.course_id, sm.subject_component, em.fname,em.mname,em.lname,sd.stream_name FROM `phd_exam_applied_subjects` as eas 
		left join (select subject_id,semester,stream_id,faculty_code from exam_practical_subjects_faculty_assign where is_active='Y') f on f.subject_id = eas.subject_id and f.semester=eas.semester and f.stream_id=eas.stream_id 
		left join subject_master sm on sm.sub_id = eas.subject_id 
		left join vw_faculty em on em.emp_id = f.faculty_code 
		left join vw_stream_details sd on sd.stream_id = eas.stream_id 
		WHERE eas.stream_id='".$stream_id."' AND eas.semester='".$semester."' AND eas.subject_id='".$subject_id."' AND eas.exam_id='".$exam_id."'  group by eas.subject_id";*/
		$sql="SELECT sm.subject_type,sm.batch,t.batch_no, t.division,sm.stream_id,sm.semester, sm.subject_name,sm.subject_code as sub_code,sm.sub_id as subject_id,sm.course_id, sm.subject_component, em.fname,em.mname,em.lname,sd.stream_name, ext.ext_fac_name,ext.ext_fac_designation,ext.ext_fac_mobile,ext.ext_fac_email,ext.ext_fac_institute,ext.ext_faculty_code,
		f.exam_pract_fact_id, f.exam_date,f.exam_from_time,f.exam_to_time,f.time_format FROM `lecture_time_table` as t 
		left join (select exam_pract_fact_id,subject_id,semester,stream_id,faculty_code,ext_faculty_code, exam_date,exam_from_time,exam_to_time,time_format  from exam_practical_subjects_faculty_assign where is_active='Y' and division='".$division."' and batch_no ='".$batch_no."' AND subject_id='".$subject_id."' AND exam_id='".$exam_id."') f on f.subject_id = t.subject_code
		left join subject_master sm on sm.sub_id = t.subject_code
		left join vw_faculty em on em.emp_id = f.faculty_code
		left join exam_external_faculty_master ext on ext.ext_faculty_code = f.ext_faculty_code
		left join vw_stream_details sd on sd.stream_id = t.stream_id 
		WHERE t.stream_id='".$stream_id."' AND t.semester='".$semester."' AND t.subject_code='".$subject_id."' and t.division='".$division."' and t.batch_no ='".$batch_no."'  group by sm.sub_id";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	function  get_subdetails_bklog($subject_id,$stream_id,$semester,$exam_id, $division, $batch_no,$sub_batch)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT sm.subject_type,sm.batch,t.batch_no, t.division,sm.stream_id,sm.semester, sm.subject_name,sm.subject_code as sub_code,sm.sub_id as subject_id,sm.course_id, sm.subject_component, em.fname,em.mname,em.lname,sd.stream_name, ext.ext_fac_name,ext.ext_fac_designation,ext.ext_fac_mobile,ext.ext_fac_email,ext.ext_fac_institute,ext.ext_faculty_code,
		f.exam_pract_fact_id, f.exam_date,f.exam_from_time,f.exam_to_time,f.time_format FROM `lecture_time_table` as t 
		left join (select exam_pract_fact_id,subject_id,semester,stream_id,faculty_code,ext_faculty_code, exam_date,exam_from_time,exam_to_time,time_format  from exam_practical_subjects_faculty_assign where is_active='Y' and division='".$division."' and batch_no ='".$batch_no."' AND subject_id='".$subject_id."' AND exam_id='".$exam_id."' and batch='$sub_batch') f on f.subject_id = t.subject_code
		left join subject_master sm on sm.sub_id = t.subject_code
		left join vw_faculty em on em.emp_id = f.faculty_code
		left join exam_external_faculty_master ext on ext.ext_faculty_code = f.ext_faculty_code
		left join vw_stream_details sd on sd.stream_id = t.stream_id 
		WHERE t.stream_id='".$stream_id."' AND t.semester='".$semester."' AND t.subject_code='".$subject_id."'  and sm.batch='$sub_batch'  group by sm.sub_id";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	
	// check duplicates
	function  checkDuplicate_pract_faculty($var)
    {
    	$stream_id = $var['stream_id'];
		$semester = $var['semester'];
		$subject_type = $var['subject_component'];
		$subject_id = $var['subject_id'];
		$exam_id = $var['exam_id'];
		$division = $var['division'];
		$batch_no = $var['batch_no'];
		$sub_batch= $var['batch'];
		$facultyId = explode(',', $var['faculty']);
		$faculty_code = $facultyId[0];
        $DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT stream_id from  exam_practical_subjects_faculty_assign WHERE stream_id='".$stream_id."' AND semester='".$semester."' AND exam_id='".$exam_id."' AND subject_id='".$subject_id."' AND division='".$division."' AND batch_no='".$batch_no."' AND batch='".$sub_batch."' and is_active='Y'";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function insert_pract_subject_faculty($var){
		//echo "<pre>";
		//print_r($var);exit;
		$DB1 = $this->load->database('umsdb', TRUE);  
		$facultyId = explode(',', $var['faculty']);
		$faculty_code = $facultyId[0];
        //$ext_faculty = $this->auto_ext_faculty();
		$data['exam_id'] = $var['exam_id'];
		$data['course_id'] = $var['course_id'];
		$data['stream_id'] = $var['stream_id'];
		$data['semester'] = $var['semester'];
		$data['batch'] = $var['batch'];
		$data['division'] = $var['division'];
		$data['batch_no'] = $var['batch_no'];		
		$data['subject_type'] = $var['subject_component'];
		$data['subject_id'] = $var['subject_id'];
		$data['faculty_code'] =$faculty_code;
		
		$data['exam_date'] =$var['exam_date'];
		$data['exam_from_time'] =$var['exam_from_time'];
		$data['exam_to_time'] =$var['exam_to_time'];
		$data['time_format'] =$var['time_format'];
		
		$data['is_active'] = 'Y';	
		if(!empty($var['is_backlog']) && $var['is_backlog']=='Y'){
			$data['is_backlog'] = 'Y';
		}
		$ext_faculty_code =$var['ext_faculty_code'];
		/*if(empty($ext_faculty_code)){
			if(empty($var['exfaculty'])){
				$data['ext_faculty_code'] ='PREX_'.$ext_faculty;
				$data_ext['ext_faculty_code'] ='PREX_'.$ext_faculty;
				$data_ext['ext_fac_name'] =$var['ext_fac_name'];
				$data_ext['ext_fac_mobile'] =$var['ext_fac_mobile'];
				$data_ext['ext_fac_email'] =$var['ext_fac_email'];
				$data_ext['ext_fac_designation'] =$var['ext_fac_designation'];
				$data_ext['ext_fac_institute'] =$var['ext_fac_institute'];		
				$data_ext['inserted_on'] = date('Y-m-d H:i:s');	
				$data_ext['inserted_by'] = $this->session->userdata("uid");
				$DB1->insert('exam_external_faculty_master', $data_ext);
			}else{
				$extfacultycode =explode(',',$var['exfaculty']);
				$data['ext_faculty_code'] =$extfacultycode[0];	
			}
    	}else{
    		$data['ext_faculty_code'] =$ext_faculty_code;	
		}*/
		if(!empty($var['exfaculty'])){
			$extfacultycode1 =explode(',',$var['exfaculty']);
			$data['ext_faculty_code'] =$extfacultycode1[0];
		}else{
			if(!empty($var['change_exfaculty'])){
				$extfacultycode =explode(',',$var['change_exfaculty']);
				$data['ext_faculty_code'] =$extfacultycode[0];		
			}else{
				$data['ext_faculty_code'] =$var['ext_faculty_code'];
			}
		}
		
		$data['inserted_on'] = date('Y-m-d H:i:s');	
		$data['inserted_by'] = $this->session->userdata("uid");
		$DB1->insert('exam_practical_subjects_faculty_assign', $data);
		
		//echo $DB1->last_query();exit;
		return true;
	}
    function  update_pract_subject_faculty($var)
    {
    	$stream_id = $var['stream_id'];
		$semester = $var['semester'];
		$subject_type = $var['subject_component'];
		$subject_code = $var['subject_id'];
		$exam_id = $var['exam_id'];
		$batch_no = $var['batch_no'];
		$batch = $var['batch'];
		$division = $var['division'];

		$modified_on = date('Y-m-d H:i:s');	
		$modified_by = $this->session->userdata("uid");

        $DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="UPDATE exam_practical_subjects_faculty_assign SET is_active='N',modified_by='$modified_by', modified_on='$modified_on' WHERE stream_id='".$stream_id."' AND semester='".$semester."' AND exam_id='".$exam_id."' AND subject_id='".$subject_code."'
		 AND batch_no='".$batch_no."' AND batch='".$batch."' AND division='".$division."'
		";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return true;
    }  
	function load_subject_coures($school_id, $batch){
        $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT vw.course_id,vw.course_short_name FROM `subject_master` as s left join vw_stream_details vw on s.stream_id =vw.stream_id  where s.batch = '".$batch."' and vw.school_code='".$school_id."' group by vw.course_id";	
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function list_practsubjects($data,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sem= $data['semester'];
		$stream= $data['admission-branch'];
		$batch= $data['batch'];



		$acd_yr = explode('~',$data['academic_year']);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$acd_yr[0]='2019-20';

		$sql="SELECT t.subject_code as sub_id,t.semester,t.division, t.batch_no, s.subject_name, s.subject_code,t.stream_id,t.semester  FROM `lecture_time_table` as t 
		left join subject_master s on s.sub_id = t.subject_code 
		WHERE t.semester='".$sem."' AND t.stream_id='".$stream."' AND t.`subject_type` = 'PR' and t.academic_year='$acd_yr[0]' and s.batch='".$batch."' and s.is_active='Y' AND s.`practical_max` !=0 group by t.subject_code, t.division, t.batch_no order by t.subject_code, t.division, t.batch_no";



        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();

	}
	/**************************** Practical Faculty END ********************************************************/
function list_fac_pract_exam_subjects(){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$empid = $this->session->userdata("name");
		$sql="SELECT s.*,p.exam_id,p.division,p.batch_no,p.is_backlog,p.exam_date,vw.stream_short_name FROM exam_practical_subjects_faculty_assign p 
		left join `subject_master` as s on p.subject_id=s.sub_id 
		left join vw_stream_details vw on s.stream_id =vw.stream_id
		where p.faculty_code = '".$empid."' and p.is_active='Y' group by sub_id";	
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
function list_facultywise_pract_exam_subjects($exam_id){
	
	
	$uid = $this->session->userdata("uid");
	$cond='';
	
	//if(p.faculty_code =  )
		$DB1 = $this->load->database('umsdb', TRUE); 
		$empid = $this->session->userdata("name");
		if($uid!=95){
	    $cond.=" and p.faculty_code ='".$empid."'";	
	    }
		$sql="SELECT s.*,p.exam_id,p.division,p.batch_no,p.is_backlog,p.exam_date,vw.stream_short_name FROM exam_practical_subjects_faculty_assign p 
		left join `subject_master` as s on p.subject_id=s.sub_id 
		left join vw_stream_details vw on s.stream_id =vw.stream_id
		where  p.exam_id='$exam_id' and p.is_active='Y' $cond group by sub_id, p.division,p.batch_no";	
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	
	
	function list_facultywise_pract_exam_all_subjects(){

	
	    $uid = $this->session->userdata("uid");
	    $cond='';

		$DB1 = $this->load->database('umsdb', TRUE); 
		$empid = $this->session->userdata("name");
		$academic_year=$DB1->get_where('academic_year',array('currently_active'=>'Y'))->row()->academic_year;
		$sql="SELECT t.subject_code as sub_id,t.semester,t.division, t.batch_no, s.subject_name, s.subject_code,s.batch,t.stream_id,academic_year,academic_session,v.stream_name  FROM `lecture_time_table` as t 
        left join subject_master s on s.sub_id = t.subject_code 
        left join vw_stream_details v on v.stream_id = t.stream_id 
        WHERE  t.`subject_type` = 'PR' and t.academic_year='$academic_year' and s.is_active='Y' group by t.subject_code order by t.subject_code";
		/*$sql="SELECT s.*,p.exam_id,p.division,p.batch_no,p.is_backlog,p.exam_date,vw.stream_short_name FROM lecture_time_table p 
		left join `subject_master` as s on p.subject_code=s.sub_id 
		left join vw_stream_details vw on s.stream_id =vw.stream_id
		where  p.exam_id='$exam_id' and p.is_active='Y' $cond group by sub_id, p.division,p.batch_no";	*/
        $query = $DB1->query($sql);
		
        return $query->result_array();
	}
	
	function getPractMarksEntry($subjectId, $exam_id,$stream, $semester,$is_backlog)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT * FROM phd_marks_entry_master where subject_id='".$subjectId."' AND exam_id='".$exam_id."' AND stream_id ='".$stream."' AND is_backlog ='".$is_backlog."' ";	

		if($semester ==''){

			$sql .=" AND semester ='".$semester."' AND marks_type='PR'";

		}
        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();
	}
	function getPractMarksEntry1($subjectId, $exam_id,$stream, $semester,$is_backlog,$division, $batch_no)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT * FROM phd_marks_entry_master where subject_id='".$subjectId."' AND exam_id='".$exam_id."' AND stream_id ='".$stream."' AND division ='".$division."' AND batch_no ='".$batch_no."'";	

		if($semester !=''){

			$sql .=" AND semester ='".$semester."' AND marks_type='PR'";

		}
        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();
	}
	function getSubAppStudentList11($subject_id,$stream_id, $semester,$exam_id, $division,$batch_no){
		$DB1 = $this->load->database('umsdb', TRUE);  
		
		$sql="SELECT sas.stud_id, s.enrollment_no, sas.subject_id,s.first_name, s.middle_name, s.last_name FROM `student_applied_subject` as sas 
		left join subject_master sm on sm.sub_id=sas.subject_id 
		left join student_master s on s.stud_id=sas.stud_id 
		where sas.subject_id='".$subject_id."' and sas.stream_id='$stream_id' and sas.semester='$semester' and sas.academic_year='2019-20' and sm.is_active='Y'";
		$sql.=" group by sas.stud_id order by s.enrollment_no";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// fetch batch allocated student list
	function getSubAppStudentList($subId,$streamId, $semester,$division, $batch,$exam_id,$academic_year)
    {
		$academic_year ='2019-20'; 
        $DB1 = $this->load->database('umsdb', TRUE); 
		if($subId !='1640'){
        $where=" WHERE cancelled_admission ='N' and is_detained ='N' AND sas.subject_id='$subId' AND sas.stream_id='$streamId' AND sba.semester='".$semester."' and sba.division='$division'";  // and sba.academic_year='$academic_year'
       	if($batch !=0){
			$where .=" and sba.batch='$batch' ";
		}	
		}else{
			$where=" WHERE cancelled_admission ='N' AND is_detained ='N' AND sas.subject_id='$subId' AND sas.stream_id='$streamId' AND sba.semester='".$semester."' ";//and sba.academic_year='$academic_year'
		}
        $sql="SELECT sba.roll_no,sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile FROM `student_batch_allocation` as sba 
left join student_applied_subject sas on sas.stud_id=sba.student_id and sas.stream_id=sba.stream_id 
inner join phd_exam_applied_subjects es on es.stud_id=sba.student_id and es.exam_id='$exam_id' and sas.subject_id=es.subject_id
left join student_master sm on sm.stud_id=sas.stud_id  $where";
	/*	$sql .=" GROUP BY sm.enrollment_no order by sm.admission_stream,sba.roll_no, sm.enrollment_no";*/
		$sql .=" GROUP BY sm.enrollment_no order by sm.admission_stream,sm.enrollment_no";
        $query = $DB1->query($sql);
			//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function list_backlogsubjects($data){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sem= $data['semester'];
		$sub_batch= $data['batch'];
		$stream= $data['admission-branch'];
		if($sem ==1 || $sem ==2){
			
			if($stream==9){
				$where.=" es.stream_id in ('5','6','7','8','9','10','11','96','97','107','108','109')";	
			}else{
				$where.=" es.stream_id='".$stream."'";
			}
			/*else if(in_array($stream,  $stream_arr1)){
				$where.=" AND sm.stream_id =103";
			}*/
		}else{
			$where.=" es.stream_id='".$stream."'";
		}
		$sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code,sm.semester,sm.`subject_component`,es.stream_id,es.semester,es.subject_id FROM `phd_exam_student_subject` as es left join subject_master sm on sm.sub_id=es.subject_id 
		WHERE es.passed ='N' AND $where and es.semester='".$sem."' and sm.batch='$sub_batch' AND sm.`subject_component` in ('PR') and sm.is_active='Y'  group by es.subject_id order by es.semester";
		// and es.semester='".$sem."' and sm.batch='$sub_batch'
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();

	}
	function  get_backlogsubdetails($subject_id,$stream_id,$semester,$exam_id, $division, $batch_no)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT sm.subject_type,sm.batch,sm.stream_id,sm.semester, sm.subject_name,sm.subject_code as sub_code,sm.sub_id as subject_id,sm.course_id, sm.subject_component, em.fname,em.mname,em.lname,sd.stream_name FROM `exam_student_subject` as es 
		left join (select subject_id,semester,stream_id,faculty_code from exam_practical_subjects_faculty_assign where is_active='Y' and division='".$division."' and batch_no ='".$batch_no."' and exam_id='$exam_id') f on f.subject_id = es.subject_id
		left join subject_master sm on sm.sub_id = es.subject_id
		left join vw_faculty em on em.emp_id = f.faculty_code 
		left join vw_stream_details sd on sd.stream_id = es.stream_id 
		WHERE es.stream_id='".$stream_id."' AND es.semester='".$semester."' AND es.subject_id='".$subject_id."' group by sm.sub_id";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function getbacklogSubjectStudts($subject_id,$stream_id,$semester){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE 1=1 ";  
        
		if($subject_id!=""){
			$where.=" AND es.subject_id='".$subject_id."' AND es.semester='".$semester."' AND es.passed ='N' and sm.cancelled_admission ='N'";
			
			if($stream_id=='103'){
				$where.=" AND es.stream_id in (43,44,45,46,47) ";
			}else if($stream_id=='9'){
				$where.=" AND es.stream_id in ('5','6','7','8','9','10','11','96','97','107','108','109','158','159','162') ";
			}else{
				$where.=" AND es.stream_id ='$stream_id' ";
			}
			
		}		
		$sql="SELECT sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile FROM `phd_exam_student_subject` as es left join student_master sm on sm.stud_id=es.student_id $where";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}	
	// get faculty list
	function get_faculty_list($stream_id,$semester) {

		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select f.emp_reg_id,f.emp_id, CONCAT(f.fname, ' ', f.mname, ' ', f.lname) AS fac_name,f.department_name,f.designation_name from lecture_time_table t left join vw_faculty as f on f.emp_id = t.faculty_code  group by f.emp_id order by f.fname";//where  t.stream_id='".$stream_id."' and t.subject_type='PR'
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
    }
    function auto_ext_faculty() {
		$DB1 = $this->load->database('umsdb', TRUE);
        $quer = $DB1->query("SHOW TABLE STATUS WHERE `Name` = 'exam_external_faculty_master'");
        $quer = $quer->result_array();
        return $quer[0]['Auto_increment'];
    }
    function fetch_student_strength($subId,$streamId, $semester,$division, $batch,$academicyear)
    {
		//$academic_year ='2019-20';
		//echo $academicyear;exit;
		$academic_year = explode('~',$academicyear);
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE cancelled_admission ='N' AND sas.subject_id='$subId' AND sas.stream_id='$streamId' AND sba.semester='".$semester."' and sba.division='$division' and sba.academic_year='$academic_year[0]'";  
       	if($batch !=0){
			$where .=" and sba.batch='$batch' ";
		}	
        $sql="SELECT sba.roll_no,sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile FROM `student_batch_allocation` as sba 
left join student_applied_subject sas on sas.stud_id=sba.student_id and sas.stream_id=sba.stream_id 
left join student_master sm on sm.stud_id=sas.stud_id  $where";
		$sql .=" GROUP BY sm.enrollment_no order by sba.roll_no, sm.enrollment_no";
        $query = $DB1->query($sql);
			//echo $DB1->last_query(); echo "<br>";exit;
        return $query->result_array();
    }
	//pdf reports
	function list_practsubjects_pdf($data,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sem= $data['semester'];
		$stream= $data['admission-branch'];
		$batch= $data['batch'];
		$acd_yr = explode('~',$data['academic_year']);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$sql="SELECT t.subject_code as sub_id,t.semester,t.division, t.batch_no, s.subject_name, s.subject_code,s.batch,t.stream_id,academic_year,academic_session,v.stream_name  FROM `lecture_time_table` as t 
		left join subject_master s on s.sub_id = t.subject_code 
		left join vw_stream_details v on v.stream_id = t.stream_id 
		WHERE t.`academic_session` = '$cur_ses' AND t.semester='".$sem."' AND t.stream_id='".$stream."' AND t.`subject_type` = 'PR' and t.academic_year='$acd_yr[0]' and s.batch='".$batch."' and s.is_active='Y' group by t.subject_code order by t.subject_code";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	function fetch_sub_batch_details($subject_id,$stream,$sem,$batch,$academic_year,$cur_ses){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT t.subject_code as sub_id,t.semester,t.division, t.batch_no, s.subject_name, s.subject_code,t.stream_id,t.academic_year,t.academic_session  FROM `lecture_time_table` as t 
		left join subject_master s on s.sub_id = t.subject_code 
		WHERE t.`academic_session` = '$cur_ses' AND t.semester='".$sem."' AND t.stream_id='".$stream."' AND t.`subject_type` = 'PR' and t.academic_year='$academic_year' and s.batch='".$batch."' and t.subject_code='".$subject_id."' and s.is_active='Y' group by t.subject_code, t.division, t.batch_no order by t.subject_code, t.division, t.batch_no";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	//
	function list_backlogsubjects_pdf($data,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sem= $data['semester'];
		$stream= $data['admission-branch'];
		$where='';
		if($sem ==1 || $sem ==2){
			
			if($stream==9){
				$where.=" es.stream_id in ('5','6','7','8','9','10','11','96','97','107','108','109','158','159','162')";	
			}else{
				$where.=" es.stream_id='".$stream."'";
			}
			/*else if(in_array($stream,  $stream_arr1)){
				$where.=" AND sm.stream_id =103";
			}*/
		}else{
			$where.=" es.stream_id='".$stream."'";
		}
		$sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code,sm.semester,sm.`subject_component`,es.stream_id FROM `exam_student_subject` as es left join subject_master sm on sm.sub_id=es.subject_id 
		WHERE es.passed ='N' and es.semester='".$sem."' AND $where AND sm.`subject_component` in ('PR') and sm.is_active='Y' group by es.subject_id order by es.subject_id";

        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
//
	function fetch_bklogsub_details($subject_id,$stream,$sem){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT e.enrollment_no, s.subject_component FROM `exam_student_subject` e left join subject_master s on s.sub_id=e.subject_id WHERE e.passed='N' and s.subject_component='PR' and e.semester='".$sem."' AND e.stream_id='".$stream."' AND e.subject_id='".$subject_id."' group by e.enrollment_no order by e.enrollment_no";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	//
	function fetch_pract_timetable($subId,$streamId, $semester,$division, $batch)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE is_active ='Y' AND subject_id='$subId' AND stream_id='$streamId' AND semester='".$semester."' and division='$division' and batch_no='$batch'";  
        $sql="SELECT faculty_code,ext_faculty_code,exam_date,exam_from_time,exam_to_time,time_format,exam_date FROM `exam_practical_subjects_faculty_assign` $where";
        $query = $DB1->query($sql);
			//echo $DB1->last_query();echo "<br>";//exit;
        return $query->result_array();
    }
	// get external faculty list
	function get_exfaculty_list() {
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select f.ext_fac_name,f.ext_faculty_code,f.ext_fac_mobile,f.ext_fac_designation,f.ext_fac_institute from exam_external_faculty_master f group by f.ext_faculty_code order by f.ext_faculty_code";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
    }
    function update_extpract_subject_faculty($var)
    {
		$extfacultycode =explode(',',$var['change_exfaculty']);
		$ext_faculty_code =$extfacultycode[0];
		$set ='';
		if(!empty($var['change_exfaculty'])){
			$set .= "ext_faculty_code='$ext_faculty_code',";
		}

    	$tbl_id = $var['exam_pract_fact_id'];
		
		$exam_date =$var['exam_date'];
		$exam_from_time =$var['exam_from_time'];
		$exam_to_time =$var['exam_to_time'];
		$time_format =$var['time_format'];
		$modified_on = date('Y-m-d H:i:s');	
		$modified_by = $this->session->userdata("uid");
		
        $DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="UPDATE exam_practical_subjects_faculty_assign SET $set modified_by='$modified_by', modified_on='$modified_on', exam_date='$exam_date', exam_from_time='$exam_from_time', exam_to_time='$exam_to_time', time_format='$time_format' WHERE exam_pract_fact_id='".$tbl_id."'";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return true;
    } 
	function fetch_bklgstudent_strength($subId,$streamId, $semester,$division, $batch)
    {

        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE passed ='N' AND b.subject_id='$subId' AND b.stream_id='$streamId' AND b.semester='".$semester."'";  	
        $sql="SELECT sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile FROM `exam_student_subject` as b 
left join student_master sm on sm.stud_id=b.student_id  $where";
		$sql .=" GROUP BY sm.enrollment_no order by sm.enrollment_no";
        $query = $DB1->query($sql);
			//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function fetch_bklgpract_timetable($subId,$streamId, $semester,$division, $batch)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE is_active ='Y' AND is_backlog='Y' AND subject_id='$subId' AND stream_id='$streamId' AND semester='".$semester."' and division='$division' and batch_no='$batch'";  
        $sql="SELECT faculty_code,ext_faculty_code,exam_date,exam_from_time,exam_to_time,time_format,exam_date FROM `exam_practical_subjects_faculty_assign` $where";
        $query = $DB1->query($sql);
			//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
	function test_list_practsubjects_pdf(){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT distinct sub_id, subject_code,subject_name,stream_id,semester,batch FROM `subject_master` WHERE `subject_name` LIKE '%English Communication Skill%' and subject_component='PR' and is_active='Y' and semester in (1) order by batch,semester";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}	
	 function testfetch_student_strength($subId,$streamId, $semester)
    {
		$academic_year ='2019-20';
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE cancelled_admission ='N' AND sas.subject_id='$subId' AND sas.stream_id='$streamId' AND sas.semester='".$semester."' and sas.academic_year='$academic_year'";
        $sql="SELECT sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile FROM  student_applied_subject sas 
left join student_master sm on sm.stud_id=sas.stud_id  $where";
		$sql .=" GROUP BY sm.enrollment_no order by sm.enrollment_no";
        $query = $DB1->query($sql);
			//echo $DB1->last_query(); echo "<br>";exit;
        return $query->result_array();
    }
	//////////////////////
	function load_prmrentrycourses($school_id){
        $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT vw.course_id,vw.course_short_name FROM `exam_practical_subjects_faculty_assign` as p left join vw_stream_details vw on p.stream_id =vw.stream_id  where vw.school_code='".$school_id."' and p.is_active='Y' group by vw.course_id";	
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function  load_prmrentrystreams()
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        
		$sql="SELECT vw.stream_id,vw.stream_name,vw.stream_short_name FROM exam_practical_subjects_faculty_assign p left join vw_stream_details vw on p.stream_id=vw.stream_id where p.course_id='".$_POST['course_id']."' and p.is_active='Y' ";
		$sql .=" group by p.stream_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $stream_details =  $query->result_array();  
    } 
	function load_prmrentrysemester()
    {
        $DB1 = $this->load->database('umsdb', TRUE);         
		$sql="SELECT p.semester FROM exam_practical_subjects_faculty_assign p  where p.stream_id='".$_POST['stream_id']."' and p.is_active='Y' group by p.semester";
        
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $stream_details =  $query->result_array();  
    }
	function fetch_pract_phd_marks_entry_status($var,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);		
		$sem= $var['semester'];
		$stream= $var['admission-branch'];
		$exam_date= $var['exam_date'];
		$school_code =$var['school_code'];
		$admissioncourse =$var['admission-course'];
		
        $sql="SELECT p.subject_id,p.faculty_code,p.ext_faculty_code,p.exam_date,p.exam_from_time,p.exam_to_time, p.stream_id,p.semester,p.division,p.batch_no, p.time_format,s.subject_name,s.subject_code, em.fname,em.mname,em.lname  FROM `exam_practical_subjects_faculty_assign` p 
		LEFT join subject_master s on p.subject_id=s.sub_id
		left join vw_faculty em on em.emp_id = p.faculty_code 
		left join vw_stream_details vw on vw.stream_id = p.stream_id
		WHERE  p.is_active='Y' and p.exam_id='$exam_id' ";//p.`exam_date` LIKE '%$exam_date%' and
		
		if($school_code !=0){
			$sql .=" AND vw.school_code='$school_code'";
		}
		if($admissioncourse !=0){
			$sql .=" AND vw.course_id='$admissioncourse'";
		}
		if($stream !=0){
		    
		    if($stream==9){
				$sql.=" AND p.stream_id in ('5','6','7','8','9','10','11','96','97','107','108','109','158','159','162')";
			}else{
				$sql.=" AND p.stream_id='".$stream."'";
			}
		    
		}
		if($sem !=0){
			$sql .=" AND p.semester='$sem'";
		}
		$sql .=" order by p.stream_id, p.semester,p.division,p.batch_no";
        $query = $DB1->query($sql);
		//echo $DB1->last_query(); echo "<br>";exit;
        return $query->result_array();
    }
	function fetch_prexmrkstatus($sub_id,$stream_id,$semester,$division,$batch_no,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);		
		
        $sql="SELECT distinct me_id  FROM `phd_marks_entry` WHERE subject_id='$sub_id' AND stream_id='$stream_id' AND semester='".$semester."' and division='$division' and batch_no='$batch_no' and exam_id='$exam_id' and marks_type='PR'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit; 
		return $query->result_array();
    }
	function list_coewise_pract_exam_subjects(){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$empid = $this->session->userdata("name");
		//$sql="SELECT s.*,vw.stream_short_name, vw.stream_name from `subject_master` as s left join vw_stream_details vw on s.stream_id =vw.stream_id where (s.`subject_name` LIKE '%German II%' OR s.`subject_name` LIKE '%French II%') and s.is_active='Y' and subject_component='PR' group by s.sub_id";
$sql="SELECT s.*,vw.stream_short_name, vw.stream_name from exam_student_subject e left join `subject_master` as s on e.subject_id=s.sub_id left join vw_stream_details vw on s.stream_id =vw.stream_id where (s.`subject_name` LIKE '%French%' OR s.`subject_name` LIKE '%German%') and s.is_active='Y' and e.passed='N' and subject_component='PR' group by s.sub_id";			
        $query = $DB1->query($sql);
		//echo $DB1->last_query();//exit; 
        return $query->result_array();
	}
	function list_coewise_cia_exam_subjects($emp_id, $curr_session,$exam_id,$academic_year,$var){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$role_id = $this->session->userdata('role_id');
		$stream_id= $var['admission-branch'];
		$semester= $var['semester'];
		
        $where=" WHERE eas.exam_id='$exam_id' and eas.allow_for_exam='Y'";  
		if($stream_id !=''){
			$where .=" and eas.stream_id='$stream_id'";
		}
		if($semester !=''){
			$where .=" and eas.semester='$semester'";
		}
		if($curr_session=='WINTER'){
			$cursession ='WIN';
		}else{
			$cursession ='SUM';
		}
        if($role_id!=15 && $role_id!=23)
        {
            $where.=" AND faculty_code='".$emp_id."'";
        }
		// fetch stream of faculty
		$fac_stream = $this->fetch_faculty_stream($emp_id);
        $fac_stream_id = $fac_stream[0]['stream_id'];
		//exit();
        if($fac_stream_id !='71'){
        //	$where.=" AND t.academic_session ='".$cursession."' and t.academic_year='$academic_year'";//t.subject_code
        }			
        $sql="SELECT distinct s.sub_id, s.subject_code,s.subject_short_name,s.subject_name,
		eas.semester,s.credits,s.subject_component, eas.stream_id,
		
		 vw.stream_short_name AS short_name,vw.stream_name AS stream_short_name,
		s.internal_max FROM `phd_exam_applied_subjects` as eas 
		left join subject_master s on s.sub_id = eas.subject_id 
		left join vw_stream_details vw on vw.stream_id=eas.stream_id
	
		$where group by s.sub_id";
        $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
        return $query->result_array();
	}		
function coe_getSubAppStudentList($subId,$streamId, $semester,$division, $batch)
    {
		$academic_year ='2019-20';
        $DB1 = $this->load->database('umsdb', TRUE); 

		$where=" WHERE cancelled_admission ='N' AND sas.subject_id='$subId' AND sas.stream_id='$streamId' AND sas.semester='".$semester."' and sas.academic_year='$academic_year'";

        $sql="SELECT sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile FROM `student_applied_subject` as sas 
left join student_master sm on sm.stud_id=sas.stud_id and sas.stream_id=sm.admission_stream $where";
	/*	$sql .=" GROUP BY sm.enrollment_no order by sm.admission_stream,sba.roll_no, sm.enrollment_no";*/
		$sql .=" GROUP BY sm.enrollment_no order by sm.admission_stream,sm.enrollment_no";
        $query = $DB1->query($sql);
			//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function coe_getPractMarksEntry1($subjectId, $exam_id,$stream, $semester,$is_backlog,$division, $batch_no)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT * FROM phd_marks_entry_master where subject_id='".$subjectId."' AND exam_id='".$exam_id."' AND stream_id ='".$stream."' ";	

		if($semester !=''){

			$sql .=" AND semester ='".$semester."' AND marks_type='PR'";

		}
        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();
	}
		///// updating cia marks of failed students
	function get_failed_studentlist()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `phd_exam_applied_subjects` WHERE  exam_id=12 and allow_for_exam='Y'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function get_failedstudciamarks($stud)
    {
    	//print_r($stud);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `phd_marks_entry_cia` WHERE `stream_id` ='".$stud['stream_id']."' AND `subject_id` ='".$stud['subject_id']."'  AND `stud_id` ='".$stud['stud_id']."' and exam_id='11' limit 0, 1";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        $sql1 ="INSERT INTO phd_marks_entry_cia (`me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `cia_marks`, `attendance_marks`, `exam_id`, `exam_month`, `exam_year`, `division`, `batch_no`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted`)
				SELECT `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `cia_marks`, `attendance_marks`, `exam_id`, `exam_month`, `exam_year`, `division`, `batch_no`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted` FROM phd_marks_entry_cia where cia_id='".$res[0]['cia_id']."'";
				$query1 = $DB1->query($sql1);
				
		//echo $DB1->last_query();exit;
        //$res1=$query1->result_array();
        $insert_id = $DB1->insert_id(); 
        $inserted_on = date('Y-m-d H:i:s');	
		$inserted_by = $this->session->userdata("uid");
        $sql2="update `phd_marks_entry_cia` set exam_id=12,entry_on='$inserted_on',entry_by='$inserted_by',modified_on='$inserted_on',modified_by='$inserted_by', exam_month='AUG',exam_year='2019'  WHERE `cia_id` ='".$insert_id."'";
        $query2 = $DB1->query($sql2);
		//exit;
       // unset();
        return true;
    }
    //for updating stream in marks entry script
	function get_mrkstudent_list()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT m.stud_id,m.stream_id,m.exam_id,s.admission_stream,m.semester FROM `phd_marks_entry` m left join student_master s on s.stud_id=m.stud_id where m.exam_id='9' AND m.stream_id='9'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
	function Marks_submission_date($exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `phd_marks_entery_date` WHERE exam_id='$exam_id' AND status='Y'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	function update_mrkstream($stud)
    {
		$stud_stream=$stud['admission_stream'];
		$stud_id=$stud['stud_id'];
		$semester=$stud['semester'];
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql2="update `phd_marks_entry` set stream_id='".$stud_stream."'  WHERE `stud_id` ='".$stud_id."' and exam_id=9 and marks_type='PR' and stream_id=9 and semester='$semester'";
        $query2 = $DB1->query($sql2);
		 return true;
    }
/*
*script for updation backlog students stream dated 
*13-02-2019 by bala	
*/
	function get_bklog_streamstud_list()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT e.exam_subject_id,e.exam_id,e.stud_id,e.subject_id,e.stream_id,e.semester,f.stream_id as bklog_stream  FROM  exam_student_subject f 

left join phd_exam_applied_subjects e on f.subject_id= e.subject_id and f.semester=e.semester and e.stud_id=f.student_id and f.stream_id !=e.stream_id 

where e.exam_id=9 and f.passed='N' and f.stream_id=49";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function update_bklog_streamstud($stud)
    {
		$stud_stream=$stud['bklog_stream'];
		$exam_subject_id=$stud['exam_subject_id'];
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql2="update `phd_exam_applied_subjects` set stream_id='".$stud_stream."'  WHERE `exam_subject_id` ='".$exam_subject_id."' and exam_id=9";
        $query2 = $DB1->query($sql2);
		 return true;
    }
//////
	function get_bklog_streamstud_list_marksentry()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT e.m_id,e.exam_id,e.stud_id,e.subject_id,e.stream_id,e.semester,f.stream_id as bklog_stream FROM exam_student_subject f left join phd_marks_entry e on f.subject_id= e.subject_id and f.semester=e.semester and e.stud_id=f.student_id and f.stream_id !=e.stream_id where e.exam_id=9 and f.passed='N' and f.stream_id=49";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function update_bklog_streamstud_marksentry($stud)
    {
		$stud_stream=$stud['bklog_stream'];
		$m_id=$stud['m_id'];
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql2="update `phd_marks_entry` set stream_id='".$stud_stream."'  WHERE `m_id` ='".$m_id."' and exam_id=9";
        $query2 = $DB1->query($sql2);
		 return true;
    }
/////
	function get_bklog_streamstud_list_cia_marks()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT e.cia_id,e.exam_id,e.stud_id,e.subject_id,e.stream_id,e.semester,f.stream_id as bklog_stream FROM exam_student_subject f left join phd_marks_entry_cia e on f.subject_id= e.subject_id and f.semester=e.semester and e.stud_id=f.student_id and f.stream_id !=e.stream_id where e.exam_id=9 and f.passed='N' and f.stream_id=49 ";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function update_bklog_streamstud_cia_marks($stud)
    {
		$stud_stream=$stud['bklog_stream'];
		$cia_id=$stud['cia_id'];
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql2="update `phd_marks_entry_cia` set stream_id='".$stud_stream."'  WHERE `cia_id` ='".$cia_id."' and exam_id=9";
        $query2 = $DB1->query($sql2);
		 return true;
    }
	/*
	*update stream for backlog students end here.
	*/
	function update_insertttdprm($data)
    {
		$DB1 = $this->load->database('umsdb', TRUE);
		unset($data['time_table_id']);
		unset($data['academic_session']);
		unset($data['inserted_on']);
		$data['academic_session']='SUM';
		$data['inserted_on']= date('Y-m-d h:i:s');
        $DB1->insert('lecture_time_table', $data);
		//echo $DB1->last_query();exit;
        return true;
    }
	
	function get_insertttdprm_list()
    {
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `lecture_time_table` WHERE `academic_year` LIKE '2019-20' AND `academic_session` = 'WIN' AND `stream_id` LIKE '71'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	function get_attendancegrade($exam_id)
    {
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT e.enrollment_no,e.subject_id,c.attendance_marks FROM `phd_exam_result_data` e left join phd_marks_entry_cia c on e.exam_id=c.exam_id and e.subject_id=c.subject_id and e.enrollment_no=c.enrollment_no where e.exam_id='".$exam_id."' group by e.enrollment_no,c.subject_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function update_attendancegrade($data,$exam_id)
    {
		$DB1 = $this->load->database('umsdb', TRUE);
		$enrollement_no =$data['enrollment_no'];
		$subject_id = $data['subject_id'];
		if($data['attendance_marks'] >=95){
			$attendance_grade='O';
		}elseif($data['attendance_marks'] >=85 && $data['attendance_marks'] <95){
			$attendance_grade='M';
		}else{
			$attendance_grade='S';
		}
		$sql="update phd_exam_result_data set attendance_grade= '$attendance_grade' where exam_id='$exam_id' and enrollment_no='$enrollement_no' and subject_id='$subject_id'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return true;
    }
	///
	function fetch_streamwisetopper_list($stream)
    {
		$DB1 = $this->load->database('umsdb', TRUE);
		/*$sql="SELECT e.enrollment_no,e.cumulative_gpa,e.exam_id,e.stream_id,e.semester, s.first_name,s.middle_name,s.last_name,v.stream_name,s.admission_year,s.admission_session FROM `exam_result_master` e
		left join student_master s on e.student_id=s.stud_id
		left join vw_stream_details v on e.stream_id=v.stream_id
		where s.admission_session='2017' and s.admission_year='1' and e.stream_id ='$stream' and exam_id=7 and e.semester=2 and student_id not in (SELECT student_id FROM `exam_student_subject` where passed ='N' and semester in(1,2)) ORDER BY cumulative_gpa DESC limit 0,3";*/
		
		$sql="SELECT s.enrollment_no,b.division,s.stud_id,e.cumulative_gpa,e.exam_id,e.stream_id,e.semester, s.first_name,s.middle_name,s.last_name,v.school_short_name,v.stream_name,s.admission_year,s.admission_session 
FROM `exam_result_master` e
LEFT JOIN student_master s ON e.student_id=s.stud_id
LEFT JOIN `student_batch_allocation` b ON b.`student_id`=e.student_id AND b.`academic_year`='2019-20'
LEFT JOIN vw_stream_details v ON e.stream_id=v.stream_id
WHERE e.stream_id ='".$stream['stream_id']."' and exam_id=11 AND e.semester='".$stream['semester']."' and b.division='".$stream['division']."' AND e.student_id NOT IN (SELECT student_id FROM `exam_student_subject` WHERE `no_of_attempt` >1) GROUP BY e.student_id,stream_id,semester ORDER BY v.school_code,v.course_id,stream_id, cumulative_gpa DESC LIMIT 0,3";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $res= $query->result_array();
    }
	function fetch_stream_division_list($vr)
    {
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT (semester-1) AS semester,division,stream_id FROM student_batch_allocation WHERE stream_id='".$vr."' AND academic_year='2019-20' GROUP BY semester,division";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function get_visfaculty_list()
    {
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT emp_id FROM `faculty_master` where emp_id like '66%' ORDER BY `faculty_master`.`emp_id` ASC";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	//
	function update_visitingfaculty($data)
    {
		$DB1 = $this->load->database('umsdb', TRUE);
		$fac_org = substr($data['emp_id'], 2);
		$facid = $data['emp_id'];
        $sql="update `feedback_student` set faculty_code='$facid' WHERE academic_year='2019-20' AND academic_type='SUM' and faculty_code='$fac_org'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return true;
    }
	/////////////////////////////////////////////////////////
	///// exam applied subjects
	function get_examappliedsubjects()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `phd_exam_applied_subjects` WHERE  exam_id=12 AND allow_for_exam='Y' GROUP BY subject_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function update_marks_master_cia($stud)
    {
    	//print_r($stud);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM phd_marks_entry_master WHERE exam_id=11 AND marks_type='CIA' and `stream_id` ='".$stud['stream_id']."' AND `subject_id` ='".$stud['subject_id']."' limit 0, 1";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        $sql1 ="INSERT INTO `phd_marks_entry_master` (`exam_id`, `subject_id`, `stream_id`, `semester`, `division`, `batch_no`, `marks_type`, `max_marks`, `phd_marks_entry_date`, `exam_month`, `exam_year`, `specializaion_id`, `subject_code`, `is_backlog`, `entry_by`, `entry_on`, `verified_by`, `verified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `approved_by`, `approved_on`, `entry_status`)
				SELECT `exam_id`, `subject_id`, `stream_id`, `semester`, `division`, `batch_no`, `marks_type`, `max_marks`, `phd_marks_entry_date`, `exam_month`, `exam_year`, `specializaion_id`, `subject_code`, `is_backlog`, `entry_by`, `entry_on`, `verified_by`, `verified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `approved_by`, `approved_on`, `entry_status` FROM phd_marks_entry_master where me_id='".$res[0]['me_id']."'";
				$query1 = $DB1->query($sql1);
				
		//echo $DB1->last_query();exit;
        //$res1=$query1->result_array();
        $insert_id = $DB1->insert_id(); 
        $inserted_on = date('Y-m-d H:i:s');	
		$inserted_by = $this->session->userdata("uid");
        $sql2="update `phd_marks_entry_master` set exam_id=12,entry_on='$inserted_on',entry_by='$inserted_by',verified_on='$inserted_on',verified_by='$inserted_by', exam_month='AUG',exam_year='2019'  WHERE `me_id` ='".$insert_id."'";
        $query2 = $DB1->query($sql2);
       // unset();
        return true;
    }
	
	function get_examappliedPrsubjects()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        /*$sql="SELECT e.* FROM `phd_exam_applied_subjects` e  
LEFT JOIN subject_master s ON s.sub_id=e.subject_id
WHERE e.exam_id=12 AND s.subject_component='EM' AND e.enrollment_no NOT IN ('180101061039','180105118045','180105131003','170101092010','170101092016','170101092019','170101092039','170101092040','170101092048','170101092050','170101092053','170101092058','170101092061','170101092075','170101092090','170101092091','170101092104','170101092108','170101092110','170101091029','180101092021','180101092023','180101092028','180101092043','180101092045','170101081004','170101081008','180101082004','180101082005','180101082017','170101081003','170101081004','170101081008','170101081002','170101081004','170101081010','180101082001','170101081002','170101081010','170101081011','180101082018','180101082019','170101082008','170101082030','170101082045','170101082002','170101082003','170101082013','170101082045')
";*/
		$sql ="SELECT e.* FROM phd_exam_applied_subjects e LEFT JOIN subject_master s ON e.subject_id=s.sub_id 
WHERE e.exam_id='12' AND s.subject_component='EM' AND s.is_active='Y' AND e.allow_for_exam='Y' 
AND e.semester=2";

        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function get_examresultPrsubjects()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM phd_exam_result_data  e
LEFT JOIN subject_master s ON s.sub_id=e.subject_id
WHERE e.exam_id=10 AND e.stream_id=10 AND e.semester=5 AND s.subject_component='EM' AND practical_marks IS NULL";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
    function update_marks_master_practical($stud)
    {
    	//print_r($stud);
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT * FROM phd_marks_entry WHERE exam_id=11 AND marks_type='PR' and `stream_id` ='".$stud['stream_id']."' AND `subject_id` ='".$stud['subject_id']."' and enrollment_no='".$stud['enrollment_no']."' limit 0, 1";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        $sql1 ="INSERT INTO `phd_marks_entry` (`me_id`, `stud_id`, `enrollment_no`, `exam_id`, `stream_id`, `semester`, `specialization_id`, `division`, `batch_no`, `subject_id`, `subject_code`, `marks_type`, `marks`, `reval_marks`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `is_deleted`)
				SELECT `me_id`, `stud_id`, `enrollment_no`, `exam_id`, `stream_id`, `semester`, `specialization_id`, `division`, `batch_no`, `subject_id`, `subject_code`, `marks_type`, `marks`, `reval_marks`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `is_deleted` FROM phd_marks_entry where m_id='".$res[0]['m_id']."'";
				$query1 = $DB1->query($sql1);				
		//echo $DB1->last_query();exit;
        //$res1=$query1->result_array();
        $insert_id = $DB1->insert_id(); 
        $inserted_on = date('Y-m-d H:i:s');	
		$inserted_by = $this->session->userdata("uid");
        $sql2="update `phd_marks_entry` set exam_id=12,entry_on='$inserted_on',entry_by='$inserted_by',modified_on='$inserted_on',modified_by='$inserted_by', exam_month='AUG',exam_year='2019'  WHERE `m_id` ='".$insert_id."'";
        $query2 = $DB1->query($sql2);
       // unset();
        return true;
    }
/*************************** script for mapping backlog Cia marks Start*************************************/
//for regular exam
	function get_backlog_studentsubjects($exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT e.semester AS cur_sem,eas.semester,eas.subject_id,eas.stud_id,eas.stream_id FROM phd_exam_details e 
LEFT JOIN phd_exam_applied_subjects eas ON eas.exam_id=e.exam_id AND e.enrollment_no = eas.enrollment_no AND e.stream_id=eas.stream_id
WHERE e.exam_id='".$exam_id."' AND e.semester !=eas.semester and eas.allow_for_exam='Y'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function updateBklogCiamarks($stud,$exam_id,$exam_month,$exam_year)  // for regular exam
    {
    	//print_r($stud);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `phd_marks_entry_cia` WHERE `stream_id` ='".$stud['stream_id']."' AND `subject_id` ='".$stud['subject_id']."'  AND `stud_id` ='".$stud['stud_id']."' AND `semester` ='".$stud['semester']."' ORDER BY cia_id DESC LIMIT 0, 1";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        $sql1 ="INSERT INTO phd_marks_entry_cia (`me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `cia_marks`, `attendance_marks`, `exam_id`, `exam_month`, `exam_year`, `division`, `batch_no`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted`)
				SELECT `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `cia_marks`, `attendance_marks`, `exam_id`, `exam_month`, `exam_year`, `division`, `batch_no`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted` FROM phd_marks_entry_cia where cia_id='".$res[0]['cia_id']."'";
				$query1 = $DB1->query($sql1);
				
		//echo $DB1->last_query();exit;
        //$res1=$query1->result_array();
        $insert_id = $DB1->insert_id(); 
        $inserted_on = date('Y-m-d H:i:s');	
		$inserted_by = $this->session->userdata("uid");
        $sql2="update `phd_marks_entry_cia` set exam_id='".$exam_id."',entry_on='$inserted_on',entry_by='$inserted_by',modified_on='$inserted_on',modified_by='$inserted_by', exam_month='".$exam_month."',exam_year='".$exam_year."'  WHERE `cia_id` ='".$insert_id."'";
        $query2 = $DB1->query($sql2); 
		//echo $DB1->last_query();
		//exit; 
       // unset();
        return true;
    }
	//// master updation
	function get_backlog_masterCiasubjects($exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT e.semester AS cur_sem,eas.semester,eas.subject_id,eas.stream_id FROM phd_exam_details e 
LEFT JOIN phd_exam_applied_subjects eas ON eas.exam_id=e.exam_id AND e.enrollment_no = eas.enrollment_no AND e.stream_id=eas.stream_id
WHERE e.exam_id='".$exam_id."' AND e.semester !=eas.semester GROUP BY subject_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function updateBklogCiaMaster($stud,$exam_id,$exam_month,$exam_year)
    {
    	//print_r($stud);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM phd_marks_entry_master WHERE marks_type='CIA' AND stream_id='".$stud['stream_id']."' AND semester='".$stud['semester']."' AND subject_id='".$stud['subject_id']."' ORDER BY me_id DESC LIMIT 0,1";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        $sql1 ="INSERT INTO `sandipun_ums`.`phd_marks_entry_master` (`exam_id`, `subject_id`, `stream_id`, `semester`, `division`, `batch_no`, `marks_type`, `max_marks`, `phd_marks_entry_date`, `exam_month`, `exam_year`, `specializaion_id`, `subject_code`, `is_backlog`, `entry_by`, `entry_on`, `verified_by`, `verified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `approved_by`, `approved_on`, `entry_status`)
				SELECT `exam_id`, `subject_id`, `stream_id`, `semester`, `division`, `batch_no`, `marks_type`, `max_marks`, `phd_marks_entry_date`, `exam_month`, `exam_year`, `specializaion_id`, `subject_code`, `is_backlog`, `entry_by`, `entry_on`, `verified_by`, `verified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `approved_by`, `approved_on`, `entry_status` FROM phd_marks_entry_master where me_id='".$res[0]['me_id']."'";
				$query1 = $DB1->query($sql1);
				
		//echo $DB1->last_query();exit;
        //$res1=$query1->result_array();
        $insert_id = $DB1->insert_id(); 
        $inserted_on = date('Y-m-d H:i:s');	
		$inserted_by = $this->session->userdata("uid");
        $sql2="update `phd_marks_entry_master` set exam_id='".$exam_id."',entry_on='$inserted_on',entry_by='$inserted_by',exam_month='".$exam_month."',exam_year='".$exam_year."' WHERE `me_id` ='".$insert_id."'";
        $query2 = $DB1->query($sql2); 
		//echo $DB1->last_query();exit;
		//exit;
       // unset();
        return true;
    }
	function get_backlog_EMPR_studentsubjects($exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        //$sql="SELECT * FROM phd_marks_entry WHERE marks_type='PR' AND subject_id='1642' AND exam_id=10 AND enrollment_no IN('180105171005','180105171001')";
$sql="SELECT e.semester AS cur_sem,eas.semester,eas.subject_id,eas.stud_id,eas.stream_id FROM phd_exam_details e 
LEFT JOIN phd_exam_applied_subjects eas ON eas.exam_id=e.exam_id AND e.enrollment_no = eas.enrollment_no AND e.stream_id=eas.stream_id
INNER JOIN subject_master s ON s.sub_id=eas.subject_id AND s.`subject_component`='EM'
WHERE e.exam_id='".$exam_id."' AND e.semester !=eas.semester AND eas.allow_for_exam='Y'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
	function updateBklog_EMPR_marks($stud,$exam_id,$exam_month,$exam_year)
    {
    	//print_r($stud);
        $DB1 = $this->load->database('umsdb', TRUE);
        //$sql="SELECT * FROM `phd_marks_entry` WHERE `stream_id` ='".$stud['stream_id']."' AND `subject_id` ='".$stud['subject_id']."'  AND `stud_id` ='".$stud['stud_id']."' AND `semester` ='".$stud['semester']."' and exam_id='9' limit 0, 1";
		$sql="SELECT * FROM phd_marks_entry WHERE marks_type='PR' AND `subject_id` ='".$stud['subject_id']."' and stud_id='".$stud['stud_id']."' AND `semester` ='".$stud['semester']."' ORDER BY m_id DESC LIMIT 0,1";
        $query = $DB1->query($sql);//exit;
        $res = $query->result_array();
        $sql1 ="INSERT INTO `phd_marks_entry` (`me_id`, `stud_id`, `enrollment_no`, `exam_id`, `stream_id`, `semester`, `specialization_id`, `division`, `batch_no`, `subject_id`, `subject_code`, `marks_type`, `marks`, `reval_marks`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `is_deleted`)
				SELECT `me_id`, `stud_id`, `enrollment_no`, `exam_id`, `stream_id`, `semester`, `specialization_id`, `division`, `batch_no`, `subject_id`, `subject_code`, `marks_type`, `marks`, `reval_marks`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `is_deleted` FROM phd_marks_entry where m_id='".$res[0]['m_id']."'";
				$query1 = $DB1->query($sql1);
				
		//echo $DB1->last_query();exit;
        //$res1=$query1->result_array();
        $insert_id = $DB1->insert_id(); 
        $inserted_on = date('Y-m-d H:i:s');	
		$inserted_by = $this->session->userdata("uid");
        $sql2="update `phd_marks_entry` set exam_id='".$exam_id."',entry_on='$inserted_on',entry_by='$inserted_by',modified_on='$inserted_on',modified_by='$inserted_by', exam_month='".$exam_month."',exam_year='".$exam_year."'  WHERE `m_id` ='".$insert_id."'";
        $query2 = $DB1->query($sql2); 
		
		//exit;
       // unset();
        return true;
    }
	
	function get_backlog_masterEMPRsubjects($exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT e.semester AS cur_sem,eas.semester,eas.subject_id,eas.stud_id,eas.stream_id FROM phd_exam_details e 
LEFT JOIN phd_exam_applied_subjects eas ON eas.exam_id=e.exam_id AND e.enrollment_no = eas.enrollment_no AND e.stream_id=eas.stream_id
INNER JOIN subject_master s ON s.sub_id=eas.subject_id AND s.`subject_component`='EM'
WHERE e.exam_id='".$exam_id."' AND e.semester !=eas.semester AND eas.allow_for_exam='Y' GROUP BY eas.subject_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function updateBklogEMPRMaster($stud,$exam_id,$exam_month,$exam_year)
    {
    	//print_r($stud);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM phd_marks_entry_master WHERE marks_type='PR' AND stream_id='".$stud['stream_id']."' AND semester='".$stud['semester']."' AND subject_id='".$stud['subject_id']."' ORDER BY me_id DESC LIMIT 0,1";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        $sql1 ="INSERT INTO `sandipun_ums`.`phd_marks_entry_master` (`exam_id`, `subject_id`, `stream_id`, `semester`, `division`, `batch_no`, `marks_type`, `max_marks`, `phd_marks_entry_date`, `exam_month`, `exam_year`, `specializaion_id`, `subject_code`, `is_backlog`, `entry_by`, `entry_on`, `verified_by`, `verified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `approved_by`, `approved_on`, `entry_status`)
				SELECT `exam_id`, `subject_id`, `stream_id`, `semester`, `division`, `batch_no`, `marks_type`, `max_marks`, `phd_marks_entry_date`, `exam_month`, `exam_year`, `specializaion_id`, `subject_code`, `is_backlog`, `entry_by`, `entry_on`, `verified_by`, `verified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `approved_by`, `approved_on`, `entry_status` FROM phd_marks_entry_master where me_id='".$res[0]['me_id']."'";
				$query1 = $DB1->query($sql1);
				
		//echo $DB1->last_query();exit;
        //$res1=$query1->result_array();
        $insert_id = $DB1->insert_id(); 
        $inserted_on = date('Y-m-d H:i:s');	
		$inserted_by = $this->session->userdata("uid");
        $sql2="update `phd_marks_entry_master` set exam_id='".$exam_id."',entry_on='$inserted_on',entry_by='$inserted_by',exam_month='".$exam_month."',exam_year='".$exam_year."' WHERE `me_id` ='".$insert_id."'";
        $query2 = $DB1->query($sql2); 
		//echo $DB1->last_query();exit;
		//exit;
       // unset();
        return true;
    }	
/*************************** script for mapping backlog Cia marks END*************************************/	

	function fetch_studexam_list($exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        //$sql="SELECT * FROM phd_marks_entry WHERE marks_type='PR' AND subject_id='1642' AND exam_id=10 AND enrollment_no IN('180105171005','180105171001')";
$sql="SELECT e.enrollment_no,e.stud_id,s.first_name,s.middle_name,e.exam_id,s.last_name,ed.cumulative_gpa,e.stud_id,e.stream_id,
e.semester,v.stream_name FROM phd_exam_details e
INNER JOIN `student_master` s ON s.stud_id=e.stud_id
INNER JOIN vw_stream_details v ON v.stream_id=e.stream_id
INNER JOIN exam_result_master ed ON ed.student_id=e.stud_id AND e.exam_id=ed.exam_id AND e.semester=ed.semester AND e.stream_id=ed.stream_id 
WHERE e.exam_id=11 GROUP BY e.enrollment_no,e.stream_id,e.semester order by v.school_id,e.enrollment_no,e.stream_id,e.semester";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function fetch_streamwisepass_list($strm)
    {
		//print_r($strm);exit;
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT enrollment_no,student_id,stream_id,semester,final_grade,subject_id FROM phd_exam_result_data WHERE exam_id='".$strm['exam_id']."' and stream_id='".$strm['stream_id']."' and semester='".$strm['semester']."'  and student_id='".$strm['stud_id']."'";
        $query = $DB1->query($sql);

        return $query->result_array();
    }
	function fetch_student_strength_backlog($sub_id,$semester){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT count(*) as cnt FROM phd_exam_student_subject WHERE semester='".$semester."'  and subject_id='".$sub_id."' and passed='N'";
        $query = $DB1->query($sql);

        return $query->result_array();
	}
	
	 function fetch_student_strengthdata($subId,$streamId, $semester,$division, $batch,$academicyear)
    {
		//$academic_year ='2019-20';
		//echo $academicyear;exit;
		$academic_year = explode('~',$academicyear);
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE cancelled_admission ='N' AND sas.subject_id='$subId' AND sas.stream_id='$streamId' AND sba.semester='".$semester."' and sba.division='$division' and sba.academic_year='$academic_year[0]'";  
       	if($batch !=0){
			$where .=" and sba.batch='$batch' ";
		}	
        $sql="SELECT sba.roll_no,sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile FROM `student_batch_allocation` as sba 
left join phd_exam_applied_subjects sas on sas.stud_id=sba.student_id and sas.stream_id=sba.stream_id 
left join student_master sm on sm.stud_id=sas.stud_id  $where";
		$sql .=" GROUP BY sm.enrollment_no order by sba.roll_no, sm.enrollment_no";
        $query = $DB1->query($sql);
			//echo $DB1->last_query(); echo "<br>";exit;
        return $query->result_array();
    }
	
	function download_marks_details($me_id, $exam_id,$subdetails)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sub_id  =$subdetails[0];
		$stream_id= $subdetails[3];
		$semester  =$subdetails[4];
		$marks_type  =$subdetails[6];
		$division= $subdetails[7];
		$batch= $subdetails[8];
		if($batch !=0){
			$where =" and sba.batch='$batch' ";
		}else{
			$where ="";
		}
		if($division !=''){
			$div =" and sba.batch='$division' ";
		}else{
			$div ="";
		}
		//print_r($subdetails);exit;
		$sql="SELECT m.*, s.first_name,s.last_name, s.middle_name FROM phd_marks_entry m left join student_master s on s.enrollment_no=m.enrollment_no where m.me_id='".$me_id."' and m.exam_id='$exam_id' order by m.enrollment_no";	
        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

	}	
	function download_pr_marks_details($me_id, $exam_id,$subdetails)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sub_id  =$subdetails[0];
		$stream_id= $subdetails[3];
		$semester  =$subdetails[4];
		$marks_type  =$subdetails[6];
		$division= $subdetails[7];
		$batch= $subdetails[8];
		if($batch !=0){
			$where =" and sba.batch='$batch' ";
		}else{
			$where ="";
		}
		if($division !=''){
			$div =" and sba.batch='$division' ";
		}else{
			$div ="";
		}
		//print_r($subdetails);exit;
		$sql="SELECT m.*, s.first_name,s.last_name, s.middle_name FROM phd_marks_entry m left join student_master s on s.enrollment_no=m.enrollment_no where m.subject_id='".$sub_id."' and m.exam_id='$exam_id' and marks_type='$marks_type' order by m.enrollment_no";	
        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

	}
	function list_exam_pr_subjects($data,$exam_id){

		$DB1 = $this->load->database('umsdb', TRUE); 
		$sem= $data['semester'];
		$stream= $data['admission-branch'];
		//$sem= $data['semester'];
		$where=" WHERE sm.is_active='Y' AND eas.exam_id='$exam_id'";  
		if($data['marks_type'] =='PR'){
			$where .="  AND (sm.subject_component='PR' OR sm.subject_component='EM')";  
		}
       // $stream_arr = array(5,6,7,8,9,10,11,96,97);

		//$stream_arr1 = array(43,44,45,46,47);

        if($sem!="" && $data['reval']=='')
        {
            $where.=" AND eas.semester='".$sem."'";
        }
			$where.=" AND eas.stream_id='".$stream."'";

		//}	
		if($data['reval']!=''){
			$where.=" AND eas.reval_appeared='Y'";
		}
		$sql="SELECT sm.* FROM `phd_exam_applied_subjects` as eas
		left join subject_master sm on sm.sub_id=eas.subject_id $where group by eas.subject_id";

        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();

	}
	function getPr_MarksEntry($subjectId, $exam_id,$marks_type, $stream, $semester,$reval)
	{

		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT * FROM phd_marks_entry where subject_id='".$subjectId."' AND exam_id='".$exam_id."' AND stream_id ='".$stream."' ";	

		if($reval ==''){

			$sql .=" AND semester ='".$semester."'";

		}

		if($marks_type !='CIA'){

			$sql .=" AND marks_type='".$marks_type."'";

		}
		$sql .=" limit 0, 1";
        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

	}	
}
?>