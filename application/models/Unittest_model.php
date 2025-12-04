<?php
class Unittest_model extends CI_Model 
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
		
        $sql="SELECT sba.sub_applied_id,sba.roll_no,sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.enrollment_no_new,sm.mobile FROM `student_batch_allocation` as sba left join student_applied_subject sas on sas.sub_applied_id=sba.sub_applied_id left join student_master sm on sm.stud_id=sas.stud_id $where";
		$sql .=" GROUP BY sm.enrollment_no_new order by sm.enrollment_no_new";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	function getFacultySubjects($emp_id) {
		// load library function for session
		$obj = New Consts();
		$curr_sess = $obj->fetchCurrSession();
		
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select distinct t.subject_code as subject_id,t.division, vw.stream_code, t.batch_no,s.subject_code as sub_code,s.subject_short_name,s.semester from lecture_time_table as t left join subject_master s on s.sub_id = t.subject_code 
		left join vw_stream_details vw on vw.stream_id =s.stream_id
		where t.faculty_code='".$emp_id."' AND t.academic_session='".$curr_sess."'";
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
}
?>