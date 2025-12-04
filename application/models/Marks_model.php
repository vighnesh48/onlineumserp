<?php

class Marks_model extends CI_Model 

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

		

        $sql="SELECT sba.sub_applied_id,sba.roll_no,sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.enrollment_no_new,sm.mobile FROM `student_batch_allocation` as sba left join student_applied_subject sas on sas.sub_applied_id=sba.sub_applied_id and sas.is_active='Y' left join student_master sm on sm.stud_id=sas.stud_id $where";

		$sql .=" GROUP BY sm.enrollment_no_new order by sm.enrollment_no_new";

        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

    }	

	function getFacultySubjects($emp_id) {

        $DB1 = $this->load->database('umsdb', TRUE);

        $sql = "select distinct t.subject_code as subject_id,t.division, vw.stream_code, t.batch_no,s.subject_code as sub_code,s.subject_short_name,s.semester from lecture_time_table as t left join subject_master s on s.sub_id = t.subject_code 

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
		$branch= $data['admission-course'];
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
		/*if($branch==5 && $sem==1 || $sem==2){
			$where.=" AND sm.stream_id='234'";
		}else if($branch==4 && $sem==1 || $sem==2){
			$where.=" AND sm.stream_id='235'";
		}else if($branch==43 && $sem==1 || $sem==2){
			$where.=" AND sm.stream_id='239'";
		}else if($branch==74 && $sem==1 || $sem==2){
			$where.=" AND sm.stream_id='248'";
		}else{
			$where.=" AND eas.stream_id='".$stream."'";
		}*/
		
		if($data['reval']!=''){
			$where.=" AND eas.reval_appeared='Y'";
		}
		$sql="SELECT sm.* FROM `exam_applied_subjects` as eas
		left join subject_master sm on sm.sub_id=eas.subject_id $where group by eas.subject_id";

        $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
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
		$sql="SELECT sm.* FROM `exam_applied_subjects` as eas
		left join subject_master sm on sm.sub_id=eas.subject_id $where group by eas.subject_id";

        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();

	}

	//getStreamShortName

	function getStreamShortName($stream_id){

        $DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT stream_short_name,stream_code,stream_name,school_short_name,school_name FROM vw_stream_details where stream_id='".$stream_id."'";	

        $query = $DB1->query($sql);

        return $query->result_array();

    }

	

	// fetch marksdetails

	function getMarksEntry($subjectId, $exam_id,$marks_type, $stream, $semester,$reval)

	{

		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT * FROM marks_entry_master where subject_id='".$subjectId."' AND exam_id='".$exam_id."' AND stream_id ='".$stream."' ";	

		if($reval ==''){

			$sql .=" AND semester ='".$semester."'";

		}

		if($marks_type !='CIA'){

			$sql .=" AND marks_type='".$marks_type."'";

		}

        $query = $DB1->query($sql);

	// echo $DB1->last_query();exit;

        return $query->result_array();

	}
	function getPr_MarksEntry($subjectId, $exam_id,$marks_type, $stream, $semester,$reval)

	{

		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT * FROM marks_entry_master where subject_id='".$subjectId."' AND exam_id='".$exam_id."'  ";	//AND stream_id ='".$stream."'

		if($reval ==''){

			$sql .=" AND semester ='".$semester."'";

		}

		if($marks_type !='CIA'){

			$sql .=" AND marks_type='".$marks_type."'";

		}
		$sql .=" limit 0, 1";
        $query = $DB1->query($sql);

		// echo $DB1->last_query();exit;

        return $query->result_array();

	}


	// fetch master entry

	function fetch_me_details($me_id)

	{

		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT * FROM marks_entry_master where me_id='".$me_id."'";	

        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

	}

	

	// fetch master entry

	function get_marks_details($me_id, $exam_id,$subdetails)
	{	
		$DB1 = $this->load->database('umsdb', TRUE); 
		$academic_year = ACADEMIC_YEAR;
		$sub_id  =$subdetails[0];
		$stream_id= $subdetails[3];
		$semester  =$subdetails[4];
		$marks_type  =$subdetails[6];
		$division= $subdetails[7];
		$batch= $subdetails[8];
		$bundle_no = $subdetails[9];
		$is_backlog= $subdetails[10];
		$academic_current_year =$this->config->item('academic_current_year');
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
		
		if($sub_id !='1640'){
        $where=" cancelled_admission ='N' and is_detained ='N' AND sas.subject_id='$sub_id' AND sas.stream_id='$stream_id'
		AND sba.semester='".$semester."' and sba.division='$division'";  
       	if($batch !=0){
			$where .=" and sba.batch='$batch' ";
		}	
		}else{
			$where=" cancelled_admission ='N' AND is_detained ='N' AND sas.subject_id='$sub_id' 
			AND sas.stream_id='$stream_id' AND sba.semester='".$semester."'";
		}
		
		
		//print_r($subdetails);exit;
		if($marks_type !='PR'){
		$sql="SELECT m.m_id,me_id, e.enrollment_no,e.stud_id,e.subject_id,e.stream_id,e.semester,e.exam_id,
		      e.exam_month,e.exam_year,m.marks_type,m.marks,m.reval_marks,m.division,m.batch_no,s.first_name,s.last_name, s.middle_name,
			  eb.exam_attendance_status as is_absent,eb.ans_bklet_no,e.barcode 
			  FROM exam_applied_subjects e

			left join marks_entry m on m.exam_id=e.exam_id and m.stud_id=e.stud_id and m.subject_id=e.subject_id and m.marks_type='TH'
			left join student_master s on s.enrollment_no=m.enrollment_no 
			left join exam_ans_booklet_attendance eb on eb.student_id=e.stud_id and eb.exam_id=e.exam_id and eb.subject_id=e.subject_id
			where e.subject_id='$sub_id' and e.exam_id='$exam_id' and e.stream_id='$stream_id' and e.bundle_no = '$bundle_no' order by e.enrollment_no";	
		}else{
			if($subdetails[10] == 'N'){
		$sql="SELECT sba.roll_no,sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,sm.admission_stream,m.m_id,me_id,m.marks_type,m.marks,m.reval_marks,m.division,m.batch_no 
				FROM `student_batch_allocation` as sba 
				LEFT JOIN marks_entry m ON m.stud_id=sba.student_id AND m.subject_id='$sub_id' AND m.marks_type='PR' AND m.division = sba.division AND m.batch_no = sba.batch and is_deleted = 'N'
				LEFT JOIN student_applied_subject sas on sas.stud_id=sba.student_id and sas.stream_id=sba.stream_id and sas.is_active='Y'
				#INNER join exam_applied_subjects es on es.stud_id=sba.student_id and es.exam_id='$exam_id' and sas.subject_id=es.subject_id
				LEFT join student_master sm on sm.stud_id=sas.stud_id 
				Where sba.academic_year='$academic_year' and $where";
				/*	$sql .=" GROUP BY sm.enrollment_no order by sm.admission_stream,sba.roll_no, sm.enrollment_no";*/

		$sql .=" GROUP BY sm.enrollment_no 
		order by sm.admission_stream,sm.enrollment_no";
			}else{
				$sql="SELECT sba.roll_no,sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,sm.admission_stream,m.m_id,me_id,m.marks_type,m.marks,m.reval_marks,m.division,m.batch_no 
				FROM `student_batch_allocation` as sba 
				LEFT JOIN marks_entry m ON m.stud_id=sba.student_id AND m.subject_id='$sub_id' and m.exam_id='$exam_id' AND m.marks_type='PR' AND m.division = sba.division AND m.batch_no = sba.batch and is_deleted = 'N'
				LEFT JOIN student_applied_subject sas on sas.stud_id=sba.student_id and sas.stream_id=sba.stream_id and sas.is_active='Y'
				INNER join exam_applied_subjects es on es.stud_id=sba.student_id and es.exam_id='$exam_id' and sas.subject_id=es.subject_id
				LEFT join student_master sm on sm.stud_id=sas.stud_id 
				WHERE $where";
				/*	$sql .=" GROUP BY sm.enrollment_no order by sm.admission_stream,sba.roll_no, sm.enrollment_no";*/

		$sql .=" GROUP BY sm.enrollment_no 
		order by sm.admission_stream,sm.enrollment_no";
			}
	}

        $query = $DB1->query($sql);
		// echo '<pre>';
		// echo $DB1->last_query();exit;

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
		$sql="SELECT m.*,es.barcode, s.first_name,s.last_name, s.middle_name,eb.exam_attendance_status as is_absent,eb.ans_bklet_no FROM marks_entry m left join student_master s on s.enrollment_no=m.enrollment_no
        left join exam_ans_booklet_attendance eb on eb.student_id=m.stud_id and eb.exam_id=m.exam_id and eb.subject_id=m.subject_id
        left join exam_applied_subjects es on es.stud_id=m.stud_id and es.exam_id=m.exam_id and es.subject_id=m.subject_id
		where m.me_id='".$me_id."' and m.exam_id='$exam_id' order by m.enrollment_no";
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
		$sql="SELECT m.*, s.first_name,s.last_name, s.middle_name FROM marks_entry m left join student_master s on s.enrollment_no=m.enrollment_no where m.subject_id='".$sub_id."' and m.exam_id='$exam_id' and marks_type='$marks_type' order by m.enrollment_no";	
        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

	}
	function get_pract_marks_details($me_id,$stream_id,$semester,$division,$batch_no, $exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$roleid= $this->session->userdata('role_id');
		if($roleid !='15'){
		$sql="SELECT m.*, s.first_name,s.last_name, s.middle_name 
		FROM marks_entry m left join student_master s on s.enrollment_no=m.enrollment_no
		where  m.me_id='".$me_id."' and m.exam_id='$exam_id' and m.semester='$semester' and m.division='$division'  and  m.batch_no='$batch_no' and m.is_deleted = 'N' order by m.enrollment_no";// and m.stream_id='$stream_id' and  m.batch_no='$batch_no'	
		}else{
			$sql="SELECT m.*, s.first_name,s.last_name, s.middle_name 
			FROM marks_entry m left join student_master s on s.enrollment_no=m.enrollment_no
		where  m.subject_id='".$me_id."' and m.exam_id='$exam_id'  and m.semester='$semester' and m.is_deleted = 'N' order by m.enrollment_no ";//and m.stream_id='$stream_id'
		}
        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

	}
	function get_cia_marks_details($me_id,$exam_id='')
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$roleid= $this->session->userdata('role_id');
		
		$sql="SELECT c.*, s.first_name,s.last_name, s.middle_name FROM marks_entry_cia c
		left join student_master s on s.enrollment_no=c.enrollment_no
		where ";	
		if($roleid!=15){
			$sql .=" me_id='".$me_id."'";
		}else{
			$sql .=" c.subject_id='".$me_id."'";
		}
		if($exam_id!=''){
			$sql .=" and c.exam_id='".$exam_id."'";
		}
        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

	}	

	// marks details

	function updateMarkDetails_03032025($data, $m_id,$testId) {
/* 	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
		ini_set("memory_limit", "-1");
		$DB1 = $this->load->database('umsdb', TRUE); 
		$subdetails =explode('~',$testId);
		$sub_id  =$subdetails[0];
		$stream_id= $subdetails[3];
		$semester  =$subdetails[4];
		$marks_type= $subdetails[6];
		$division= $subdetails[7];
		if(!empty($subdetails[8])){
		$batch= $subdetails[8];
		}else{
			$batch='';
		}
		if($subdetails[12] == 4 || $subdetails[12] ==5){
		   $batch_no =0;
		}
		$exss = str_replace('/', '_', $subdetails[5]);
		$exam = explode('-', $exss);
		$exam_id = $exam[2];
		//echo "<pre>";print_r($subdetails);exit;
        $count = count($data['stud_id']);

        //echo $count;

        for ($i = 0; $i < $count; $i++) {
			$mrk_id = $data['mrk_id'][$i];
			$stud_mrks = $this->get_studmarks($mrk_id, $m_id);
        	if($stud_mrks != $data['marks_obtained'][$i]){
				$sql ="INSERT INTO marks_entry_log (`m_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `marks_type`, `marks`, `exam_id`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted`)
				SELECT `m_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `marks_type`, `marks`, `exam_id`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted` FROM marks_entry where m_id='$mrk_id' and me_id='$m_id'";
				$query = $DB1->query($sql);
			}
			if(is_null($mrk_id) || $mrk_id==""){
				$insert_array=array(
					"me_id"=>$m_id,
					"stud_id"=>$data['stud_id'][$i],
					"enrollment_no"=>$data['enrollement_no'][$i],
					"marks"=>$data['marks_obtained'][$i],
					"stream_id"=>$stream_id,
					"specialization_id"=>0,
					"semester"=>$semester,
					"division"=>$division,
					"batch_no"=>$batch,
					"subject_id"=>$sub_id,
					"marks_type" => $marks_type,
					"exam_month"=>$exam[0],
					"exam_year"=>$exam[1],
					"exam_id" =>$exam[2],
					"entry_ip" => $this->input->ip_address(),
					"entry_by" => $this->session->userdata("uid"),
					"entry_on" => date("Y-m-d H:i:s")
					); 
				//echo "<pre>";print_r($insert_array);//exit;
				$DB1->insert("marks_entry", $insert_array); 
				//echo $DB1->last_query();exit;
			}
            $spk['stud_id'] = $data['stud_id'][$i];
            $spk['enrollment_no'] = $data['enrollement_no'][$i];
            

			$spk['marks'] = $data['marks_obtained'][$i];
            //$name = $spk['spk_name'];
            //$contactno = $spk['contact_no'];
            //$event_spk_id = $spk['event_spk_id'];
                //echo"in update";

			$spk['modified_by'] = $this->session->userdata("uid");
			$spk['modified_on'] = date('Y-m-d H:i:s');
							//echo "<pre>";print_r($spk);//exit;
			if($marks_type=='TH'){
				$DB1->where('me_id', $m_id);
			}
			$DB1->where('m_id', $mrk_id);
			$DB1->update('marks_entry', $spk);
            //echo $DB1->last_query();exit;
            unset($mrk_id);
			unset($sql);

        }

         return true;

    }
	// checking student marks
	
	public function updateMarkDetails($data, $m_id, $testId)
{
    $DB1 = $this->load->database('umsdb', TRUE);
    
    $subdetails = explode('~', $testId);
    $sub_id = $subdetails[0] ?? null;
    $stream_id = $subdetails[3] ?? null;
    $semester = $subdetails[4] ?? null;
    $marks_type = $subdetails[6] ?? null;
    $division = $subdetails[7] ?? null;
    $batch = $subdetails[8] ?? '';
    $exam = explode('-', str_replace('/', '_', $subdetails[5] ?? ''));
    $exam_id = $exam[2] ?? null;
    
    $count = count($data['stud_id']);
    $updateData = [];

    for ($i = 0; $i < $count; $i++) {
        $mrk_id = $data['mrk_id'][$i];
        $new_marks = $data['marks_obtained'][$i];

        // Fetch existing marks to log changes
        $existing_marks = $this->get_studmarks($mrk_id, $m_id);

        // Log changes before updating
        if ($existing_marks !== $new_marks) {
            $log_sql = "INSERT INTO marks_entry_log (`m_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `marks_type`, `marks`, `exam_id`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted`)
            SELECT `m_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `marks_type`, `marks`, `exam_id`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted`
            FROM marks_entry WHERE m_id = ? AND me_id = ?";
            $DB1->query($log_sql, [$mrk_id, $m_id]);
        }

        if (empty($mrk_id)) {
            // Insert new marks entry
            $insert_array = [
                "me_id" => $m_id,
                "stud_id" => $data['stud_id'][$i],
                "enrollment_no" => $data['enrollement_no'][$i],
                "marks" => $new_marks,
                "stream_id" => $stream_id,
                "specialization_id" => 0,
                "semester" => $semester,
                "division" => $division,
                "batch_no" => $batch,
                "subject_id" => $sub_id,
                "marks_type" => $marks_type,
                "exam_month" => $exam[0] ?? null,
                "exam_year" => $exam[1] ?? null,
                "exam_id" => $exam_id,
                "entry_ip" => $this->input->ip_address(),
                "entry_by" => $this->session->userdata("uid"),
                "entry_on" => date("Y-m-d H:i:s")
            ];
            $DB1->insert("marks_entry", $insert_array);
        } else {
            // Prepare batch update data
            $updateData[] = [
                'm_id' => $mrk_id,
                'me_id' => $m_id,
                'marks' => $new_marks,
                'modified_by' => $this->session->userdata("uid"),
                'modified_on' => date('Y-m-d H:i:s')
            ];
        }
    }

    // Batch update marks for efficiency
    if (!empty($updateData)) {
        $DB1->update_batch('marks_entry', $updateData, 'm_id');
    }

    return true;
}

	function get_studmarks($mrk_id, $m_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT `marks` FROM marks_entry where m_id='$mrk_id' and me_id='$m_id'";	
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
        return $res[0]['marks'];
	}
	
	// fetch CIA marksdetails

	function getCIAMarksEntry($subjectId, $exam_id, $marks_type, $stream, $semester)

	{

		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT * FROM marks_entry_master where subject_id='".$subjectId."' AND exam_id='".$exam_id."' AND semester ='".$semester."'";	//AND stream_id ='".$stream."' 

		

		if($marks_type =='CIA'){

			$sql .=" AND marks_type='".$marks_type."'";

		}

        $query = $DB1->query($sql);

		//echo $DB1->last_query();//exit;

        return $query->result_array();

	}

	

	// fetch master entry

	function get_ciamarks_details($me_id,$exam_id,$subdetails,$academicyear='')

	{

		$DB1 = $this->load->database('umsdb', TRUE); 
		
		//print_r($subdetails);
		$sub_id  =$subdetails[0];
		$stream_id= $subdetails[3];
		$semester  =$subdetails[4];
		$subbtch =explode('-',$subdetails[7]); 
		$division= $subbtch[1];
		$batch= $subbtch[2];
		if($batch !=0){
			$where =" and sba.batch='$batch' ";
		}else{
			$where ="";
		}	
		//$sql="SELECT m.*, s.first_name,s.last_name, s.middle_name FROM marks_entry_cia m left join student_master s on s.stud_id=m.stud_id where me_id='".$me_id."' order by enrollment_no";	
		$sql="SELECT m.cia_id,me_id,s.enrollment_no,sas.stud_id,sas.subject_id,sas.stream_id,sas.semester,e.exam_id,e.exam_month,e.exam_year,m.cia_marks,m.attendance_marks,m.division,m.batch_no,
 s.first_name,s.last_name, s.middle_name FROM student_batch_allocation sba 
 left join student_applied_subject sas on sas.stud_id=sba.student_id  and sas.is_active='Y'
left join exam_applied_subjects e on e.stud_id=sba.student_id and e.subject_id=sas.subject_id and e.semester=sas.semester and e.exam_id='$exam_id'  
left join marks_entry_cia m on sas.subject_id=m.subject_id and sas.stud_id=m.stud_id 
left join student_master s on s.stud_id=sas.stud_id 
where  sas.subject_id='$sub_id' $where and sba.division='$division' and sba.academic_year='$academicyear' and s.cancelled_admission='N'
group by sba.student_id order by sba.student_id ";

        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

	}
		function get_ciamarks_details_modified($me_id,$exam_id,$subdetails)

	{

		$DB1 = $this->load->database('umsdb', TRUE); 
		//print_r($subdetails);
		$sub_id  =$subdetails[0];
		$stream_id= $subdetails[3];
		$semester  =$subdetails[4];
		$subbtch =explode('-',$subdetails[7]); 
		$division= $subbtch[1];
		$batch= $subbtch[2];
		if($batch !=0){
			$where =" and sba.batch='$batch' ";
		}else{
			$where ="";
		}	
		//$sql="SELECT m.*, s.first_name,s.last_name, s.middle_name FROM marks_entry_cia m left join student_master s on s.stud_id=m.stud_id where me_id='".$me_id."' order by enrollment_no";	
		$sql="SELECT m.cia_id,me_id,e.enrollment_no,e.stud_id,e.subject_id,e.stream_id,e.semester,e.exam_id,e.exam_month,e.exam_year,m.cia_marks,m.attendance_marks,m.division,m.batch_no, s.first_name,s.last_name, s.middle_name FROM exam_applied_subjects  e 
left join marks_entry_cia m on e.subject_id=m.subject_id and e.exam_id=m.exam_id and e.stud_id=m.stud_id
left join student_batch_allocation sba on e.stud_id=sba.student_id and e.stream_id=sba.stream_id 
left join student_master s on s.enrollment_no=e.enrollment_no 
where  e.subject_id='$sub_id' and e.exam_id='$exam_id' $where and sba.division='$division'
group by m.enrollment_no order by m.enrollment_no";

        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

	}
	function get_ciamarks_details_coe($sub_id, $stream,$exam_id)

	{

		$DB1 = $this->load->database('umsdb', TRUE); 
		//print_r($subdetails);

		//$sql="SELECT m.*, s.first_name,s.last_name, s.middle_name FROM marks_entry_cia m left join student_master s on s.stud_id=m.stud_id where me_id='".$me_id."' order by enrollment_no";	
		$sql="SELECT m.cia_id,me_id,e.enrollment_no,e.stud_id,e.subject_id,e.stream_id,e.semester,e.exam_id,e.exam_month,e.exam_year,m.cia_marks,m.attendance_marks,m.division,m.batch_no, s.first_name,s.last_name, s.middle_name FROM exam_applied_subjects  e 
left join marks_entry_cia m on e.subject_id=m.subject_id and e.exam_id=m.exam_id and e.stud_id=m.stud_id
left join student_master s on s.enrollment_no=e.enrollment_no 
where  e.subject_id='$sub_id' and e.exam_id='$exam_id'
group by e.enrollment_no order by m.enrollment_no";

        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();

	}
	// marks details

	function updateCIAMarkDetails($data, $m_id,$testId) {
		$max_marks = $data['max_marks'];
		$DB1 = $this->load->database('umsdb', TRUE); 
		
		$subdetails =explode('~',$testId);
		$sub_id  =$subdetails[0];
		$stream_id= $subdetails[3];
		$semester  =$subdetails[4];
		$subbtch =explode('-',$subdetails[7]); 
		$division= $subbtch[1];
		$batch= $subbtch[2];
		$exss = str_replace('/', '_', $subdetails[5]);
		$exam = explode('-', $exss);
		$exam_id = $exam[2];
		
        $count = count($data['stud_id']);
        //echo $count;
        for ($i = 0; $i < $count; $i++) {
			$mrk_id = $data['mrk_id'][$i];
			//inserting cia log
        	$stud_ciamrks = $this->get_studCIAmarks($mrk_id, $m_id);
        	if($stud_ciamrks != $data['marks_obtained'][$i]){
				$sql ="INSERT INTO marks_entry_cia_log (`cia_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `cia_marks`,`attendance_marks`, `exam_id`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted`)
				SELECT `cia_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `cia_marks`,`attendance_marks`, `exam_id`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted` FROM marks_entry_cia where cia_id='$mrk_id' and me_id='$m_id'";
				$query = $DB1->query($sql);
			}
			if(is_null($mrk_id) || $mrk_id==""){
				$insert_array=array(
					"me_id"=>$m_id,
					"stud_id"=>$data['stud_id'][$i],
					"enrollment_no"=>$data['enrollement_no'][$i],
					"cia_marks"=>$data['marks_obtained'][$i],
					"attendance_marks"=>$data['attdance_marks'][$i],
					"stream_id"=>$stream_id,
					"specialization_id"=>0,
					"semester"=>$semester,
					"division"=>$division,
					"batch_no"=>$batch,
					"subject_id"=>$sub_id,
					"exam_month"=>$exam[0],
					"exam_year"=>$exam[1],
					"exam_id" =>$exam[2],
					"entry_ip" => $this->input->ip_address(),
					"entry_by" => $this->session->userdata("uid"),
					"entry_on" => date("Y-m-d H:i:s")
					); 
				//echo "<pre>";print_r($insert_array);exit;
				$DB1->insert("marks_entry_cia", $insert_array); 
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
			//$DB1->where('me_id', $m_id);
			$DB1->where('cia_id', $mrk_id);
			$DB1->update('marks_entry_cia', $spk);
            //echo $DB1->last_query();exit;
            unset($mrk_id);
			unset($sql);
        }
		if($max_marks !=''){
			$DB1->where('me_id', $m_id);
			$max['max_marks'] = $max_marks;
			$DB1->update('marks_entry_master', $max);			
		}

         return true;

    }
	// checking student cia marks for log
	function get_studCIAmarks($mrk_id, $m_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT `cia_marks` FROM marks_entry_cia where cia_id='$mrk_id' ";
		if($m_id !=''){
			$sql .="and me_id='$m_id'";
		}
			
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
   
        $sql = "SELECT sm.* FROM `exam_applied_subjects` as eas
		left join subject_master sm on sm.sub_id=eas.subject_id $where group by eas.subject_id";
        
        $query = $DB1->query($sql);
        
        //echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
    // get theory marks entry status 
    function getTHMarksEntryStatus($subjectId, $exam_month, $exam_year, $marks_type, $stream, $semester)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM marks_entry_master where subject_id='" . $subjectId . "' AND exam_month='" . $exam_month . "' AND exam_year='" . $exam_year . "' AND stream_id ='" . $stream . "' AND semester ='" . $semester . "'";           
        $sql .= " AND marks_type in('TH','PR')";
 
        $query = $DB1->query($sql);        
       // echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
    // get CIA marks entry status 
    function getCIAMarksEntryStatus($subjectId, $exam_month, $exam_year, $marks_type, $stream, $semester)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM marks_entry_master where subject_id='" . $subjectId . "' AND exam_month='" . $exam_month . "' AND exam_year='" . $exam_year . "' AND stream_id ='" . $stream . "' AND semester ='" . $semester . "'";
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
		
        $stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279); 
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
        
			$sql = "SELECT distinct erd.student_id, sm.first_name,sm.last_name,erd.semester,sm.stud_id,sm.enrollment_no,ed.is_verified FROM exam_result_data erd 
			left join exam_result_details ed on ed.stream_id=erd.stream_id and ed.exam_id=erd.exam_id and ed.semester='erd.semester'
			left join student_master sm on sm.stud_id = erd.student_id
			where erd.exam_id='".$exam_id."' AND erd.stream_id ='".$stream."' AND erd.semester ='".$sem."' "; 
			if($regulation=='2017'){
				//$sql .="  and sm.admission_session in('2017','2018','2019')";
			}else{
				$sql .=" and sm.admission_session ='2016'";
			}
			if($grade_updtype=='Malpractice'){
				$sql .=" and erd.malpractice ='Y'";
			}

		 //$sql .=" and erd.malpractice ='Y'";
        $query = $DB1->query($sql);
        
       // echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
	// check grade present or not in grade table
    function fetch_examGrades($var, $exam_id)
    {       
       // print_r($var);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM exam_result_data where stream_id ='".$var['admission-branch']."' AND semester ='".$var['semester']."' and exam_id='".$exam_id."'";        
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;   
        return $query->result_array();       
    } 
	//list_examAppliedstud_subjects
    function list_examAppliedstud_subjects($var, $exam_month, $exam_year,$exam_id)
    {       
       // print_r($var);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT distinct erd.subject_id, sm.subject_code,sm.subject_name,sm.sub_id FROM exam_result_data erd 
		left join subject_master sm on sm.sub_id = erd.subject_id
		where erd.exam_month='".$exam_month."' AND erd.exam_year='".$exam_year."' and erd.exam_id='".$exam_id."' AND erd.stream_id ='".$var['admission-branch']."' AND erd.semester ='".$var['semester']."'";    
		if($var['grade_updtype']=='Malpractice'){
			$sql .= " and erd.malpractice='Y'";
		}
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;   
        return $query->result_array();       
    } 	
	// fetch studen subject grades
    function fetchstudentsubgrade($stud_id,$sub_id,$exam_id)
    {       
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT result_grade,final_grade,result_id,attendance_grade FROM exam_result_data where exam_id='$exam_id' and student_id='".$stud_id."' and subject_id='".$sub_id."'";     
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
        $sql = "SELECT * FROM exam_session where deleted ='N' order by exam_id  desc";     
        $query = $DB1->query($sql);    
       // echo $DB1->last_query();exit;       
        return $query->result_array();
        
    } 
	function fetch_exam_session_single_markssheet()
    {       
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM exam_session where deleted ='N' and exam_id >=35";     
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
	function getFaqExam_applied_subjects($emp_id, $curr_session,$exam_id,$academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE eas.exam_id='$exam_id' and eas.allow_for_exam='Y' and (s.internal_max!=0 OR s.internal_max!='') ";  
		if($curr_session=='WINTER'){
			$cursession ='WIN';
		}else{
			$cursession ='SUM';
		}
        if($emp_id!="")
        {
            $where.=" AND faculty_code='".$emp_id."'";
        }
		/* if($emp_id=='662606' || $emp_id=='210527' || $emp_id=='210859' || $emp_id=='662607'){
			$cursession ='WIN';
		} */
		// fetch stream of faculty
		$fac_stream = $this->fetch_faculty_stream($emp_id);
		$arr_fstream=array();
		foreach($fac_stream as $fstream){
			$arr_fstream[] =$fstream['stream_id'];
		}
		//print_r($arr_fstream);
        $fac_stream_id = $fac_stream[0]['stream_id'];
		
        if(!in_array(71, $arr_fstream)){
        	$where.=" AND t.academic_session ='".$cursession."' and t.academic_year='$academic_year'";
        }			
        $sql="SELECT distinct t.subject_code, s.subject_code as sub_code,s.subject_short_name,s.subject_name,s.sub_id,eas.semester,s.credits,s.subject_component, eas.stream_id, f.fname,f.mname,f.lname, vw.stream_short_name,s.internal_max FROM 
		`exam_applied_subjects` as eas left join `lecture_time_table` t on t.subject_code = eas.subject_id
		left join subject_master s on s.sub_id = t.subject_code 
		left join vw_stream_details vw on vw.stream_id=eas.stream_id
		left join vw_faculty f on f.emp_id = t.faculty_code 
		$where group by t.subject_code";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	
	//  fetch batch allocated student list 
	function  get_studbatch_allot_list($batch_code,$th_batch,$subId,$streamId, $semester,$exam_id,$academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 AND sm.cancelled_admission ='N' AND sas.is_active='Y' AND sas.subject_id='$subId' AND sba.semester='".$semester."' AND sba.academic_year='$academic_year' ";  //AND sm.is_detained='N'
        $th_bt = explode('-', $batch_code);
		$division = $th_bt[1];
		$batch = $th_bt[2];
        if($batch_code!="" && $th_batch !=0)
        {
            $where.=" AND sba.division ='".$division."' AND sba.batch ='".$batch."'";
        }else{
			
			$where.=" AND sba.division ='".$division."'";
		}
		$stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279); 
		$stream_arr1 = array(27,28,26,70,126,150,157,164,172,184,185,186,199,200,201,202,203,214,215); 
		//$stream_arr2 = array(23,24,148,149,154,155,182,183,204,206,207); //222,205,211
		$stream_arr3 = array(178,180,181); 
		//$stream_arr4 = array(22,113,196,260,261); 
		$stream_arr5 = array(43,44,45,46,47,66,67,103,104,117,167,193,194,210); 
		$stream_arr6 = array(23,24,148,149,154,155,182,183,204,205,206,207,222);	
		if($semester==1 || $semester==2){
			if (in_array($streamId,  $stream_arr)){
				$where.=" AND sas.stream_id =9";	
			}else if (in_array($streamId,  $stream_arr1)){
				$where.=" AND sas.stream_id =234";	
				//$where.=" AND sas.stream_id ='".$streamId."'";	
			}else if (in_array($streamId,  $stream_arr2)){
				//$where.=" AND sas.stream_id =235";	
				//$where.=" AND sas.stream_id ='".$streamId."'";	
			}else if (in_array($streamId,  $stream_arr3)){
				//$where.=" AND sas.stream_id =239";	
				$where.=" AND sas.stream_id ='".$streamId."'";	
			}else if (in_array($streamId,  $stream_arr4)){ 
				//$where.=" AND sas.stream_id =236";	
				//$where.=" AND sas.stream_id ='".$streamId."'";	
			}/*else if (in_array($streamId,  $stream_arr5)){
				$where.=" AND sas.stream_id =103";	
			}*/
			else{
			
				$where.=" AND sas.stream_id='".$streamId."'";

			}
		}/* else if($semester==3 && in_array($streamId,  $stream_arr6)){
			$where.=" AND sas.stream_id =23";	
		} */
		else{
			$where.=" AND sas.stream_id='".$streamId."'";
		}
		
        $sql="SELECT  sba.roll_no,sm.stud_id,sm.is_detained,sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,sm.admission_stream FROM `student_batch_allocation` as sba 
		left join student_applied_subject sas on sas.stud_id=sba.student_id and sas.is_active='Y'
		#inner join exam_applied_subjects es on es.stud_id=sba.student_id and es.exam_id='$exam_id' and sas.subject_id=es.subject_id
		left join student_master sm on sm.stud_id=sas.stud_id $where";
		
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

		$sql="SELECT mem.division, mem.batch_no, m.* FROM marks_entry_master m left join marks_entry_cia mem on m.me_id =mem.me_id 
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
		//$sql = "SELECT distinct c.`stream_id`, vw.stream_name,vw.stream_short_name FROM `marks_entry_cia` c left join vw_stream_details vw on vw.stream_id=c.stream_id where vw.course_id='".$course_id."' ";
		$sql = "SELECT distinct `stream_id`, vw.stream_name,vw.stream_short_name FROM vw_stream_details vw where vw.course_id='".$course_id."' ";
		
		if(isset($role_id) && $role_id==20){
			 $empsch = $this->Subject_model->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 if($emp_id !=110074){
			 $sql .=" and school_code = $schid";
			 }
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
		$where=" WHERE c.is_backlog='N' and sm.is_active='Y' and c.exam_id='$exam_id' and (sm.internal_max !=0 OR internal_max!='')";  
		/*if($data['marks_type'] !='CIA'){
			$where .="  AND sm.subject_component='".$data['marks_type']."' ";  
		}	*/

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

		$sql="SELECT c.is_backlog,sm.subject_code, sm.subject_name,sm.subject_short_name,sm.subject_component, c.subject_id,c.stream_id FROM `exam_applied_subjects` as c
		 join subject_master sm on sm.sub_id=c.subject_id $where group by c.subject_id";
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

		//$sql = "SELECT c.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no, subject_id FROM `marks_entry_cia` as c left join student_master sm on sm.stud_id=c.stud_id where sm.actice_status='Y' AND sm.cancelled_admission='N' AND c.stream_id='".$stream."' AND c.semester='".$sem."' group by c.stud_id";
	$sql = "SELECT c.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no, subject_id FROM `marks_entry_cia` as c left join student_master sm on sm.stud_id=c.stud_id where  c.stream_id='".$stream."' AND c.semester='".$sem."' and c.exam_id='$exam_id' group by c.stud_id";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}

	// fetch studen subject cia/attendance marks
    function fetchstudentsubCIAmarks($stud_id,$sub_id,$exam_month,$exam_year, $exam_id)
    {    
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT cia_id,cia_marks,attendance_marks FROM marks_entry_cia where stud_id='".$stud_id."' and subject_id='".$sub_id."' and exam_id='".$exam_id."'";     
        $query = $DB1->query($sql);  
/* if($stud_id==18717 && $sub_id==16738){
 //echo $DB1->last_query();exit;
} */	
        //echo $DB1->last_query();exit;
        return $query->result_array();        
    }
	// fetch faculty stream 
	function fetch_faculty_stream($emp_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT stream_id FROM `lecture_time_table` WHERE `faculty_code`='$emp_id' group by stream_id";
        $query = $DB1->query($sql);
        return $query->result_array();
	}
    
	//get_cia_examsemester
	function get_cia_examsemester($stream_id, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct semester from marks_entry_cia  where stream_id='".$stream_id."' and exam_id ='$exam_id' order by semester asc";
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

        $sql="SELECT distinct e.subject_id, s.subject_code1,s.subject_code,s.subject_name,s.subject_short_name,s.theory_max,s.theory_min_for_pass,s.internal_max,s.internal_min_for_pass,s.sub_min,s.sub_max FROM `exam_applied_subjects` e left join subject_master s on e.subject_id= s.sub_id where e.semester='".$semester."' and e.exam_id='$exam_id' AND e.exam_month='$exam_month' AND e.exam_year='$exam_year'and e.stream_id='$stream_id' and e.allow_for_exam='Y' order by s.subject_order ASC";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    // get theory marks entry status 
    function fetch_stud_sub_marks_thpr($studentid, $subjectId, $exam_id, $stream, $semester)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM marks_entry where stud_id ='".$studentid."' and subject_id='" . $subjectId . "' AND exam_id='" . $exam_id . "' AND stream_id ='" . $stream . "' AND semester ='" . $semester . "'";           
        $sql .= " AND marks_type in('TH','PR')";
 
        $query = $DB1->query($sql);        
       // echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
    // get CIA marks entry status 
    function fetch_stud_sub_marks_cia($studentid,$subjectId, $exam_id, $stream, $semester)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM marks_entry_cia where stud_id ='".$studentid."' and subject_id='" . $subjectId . "' AND exam_id='" . $exam_id . "' AND stream_id ='" . $stream . "' AND semester ='" . $semester . "'";
        
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

        $sql="SELECT sas.*,s.first_name, s.middle_name, s.last_name FROM `exam_applied_subjects` as sas left join student_master s on s.stud_id=sas.stud_id
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
FROM exam_applied_subjects  s 
LEFT JOIN marks_entry_cia c ON c.stud_id=s.stud_id AND s.subject_id=c.subject_id AND c.exam_id=s.exam_id
LEFT JOIN marks_entry m ON m.stud_id=s.stud_id AND s.subject_id=m.subject_id AND s.exam_id=m.exam_id
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
FROM exam_applied_subjects  s 
LEFT JOIN marks_entry_cia c ON c.stud_id=s.stud_id AND s.subject_id=c.subject_id AND c.exam_id=s.exam_id
LEFT JOIN marks_entry m ON m.stud_id=s.stud_id AND s.subject_id=m.subject_id AND s.exam_id=m.exam_id
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
		
		/* $sql="SELECT sas.stud_id, sas.enrollment_no, sas.subject_id,s.first_name, s.middle_name, s.last_name,sas.is_absent,m.marks,m.reval_marks,m.m_id,m.me_id FROM `exam_applied_subjects` as sas 
		left join subject_master sm on sm.sub_id=sas.subject_id 
		left join student_master s on s.stud_id=sas.stud_id 
		left join marks_entry m on m.stud_id=sas.stud_id and m.exam_id=sas.exam_id and m.subject_id=sas.subject_id
		where sas.subject_id='".$subject_id."' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' and sm.is_active='Y' and sas.reval_appeared='Y' and m.marks_type='TH'"; */
		
		$sql="SELECT sas.stud_id, sas.enrollment_no, sas.subject_id,s.first_name, s.middle_name, s.last_name,sas.is_absent,m.marks,m.reval_marks,m.m_id,m.me_id,f.amount,sas.exam_id   
		FROM `exam_applied_subjects` as sas 
		left join subject_master sm on sm.sub_id=sas.subject_id 
		left join student_master s on s.stud_id=sas.stud_id 
		left join exam_details ed on  ed.stud_id = s.stud_id
        left join fees_details f on f.student_id = ed.stud_id and f.exam_session=ed.exam_id and f.type_id='8' 
		left join marks_entry m on m.stud_id=sas.stud_id and m.exam_id=sas.exam_id and m.subject_id=sas.subject_id
		where sas.subject_id='".$subject_id."' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' and sm.is_active='Y' and sas.reval_appeared='Y' and m.marks_type='TH' and f.amount !=''";
		
		
		$sql.=" group by sas.stud_id order by sas.enrollment_no asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
// update reval marks details
	function updateMarkDetails_reval($data, $m_id) {

		$DB1 = $this->load->database('umsdb', TRUE); 

        $count = count($data['stud_id']);
		
		// print_r($data);exit;
		
        //echo $count;

        for ($i = 0; $i < $count; $i++) {
			$mrk_id = $data['mrk_id'][$i];
			$subject_id = $data['subject_id'][$i];
			$exam_id = $data['exam_id'][$i];
			$stud_mrks = $this->get_studmarks($mrk_id, $m_id);
        	if($stud_mrks != $data['marks_obtained'][$i]){
				$sql ="INSERT INTO marks_entry_log (`m_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `marks_type`, `marks`, `exam_id`,reval_marks, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted`)
				SELECT `m_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `marks_type`, `marks`,reval_marks, `exam_id`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted` FROM marks_entry where m_id='$mrk_id' and me_id='$m_id'";
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
			
			// $DB1->where('me_id', $m_id);
			$DB1->where('subject_id', $subject_id);
			$DB1->where('exam_id', $exam_id);
			$DB1->where('m_id', $mrk_id);
			$DB1->update('marks_entry', $spk);
          // echo $DB1->last_query();
            unset($mrk_id);
			unset($sql);

        }
         return true;
    }
	
	
	
	/************** Practical faculty Assign *****************/
		function  get_subdetails($subject_id,$stream_id,$semester,$exam_id, $division, $batch_no)
		{
			$DB1 = $this->load->database('umsdb', TRUE); 
			
		   /* $sql="SELECT sm.subject_type,eas.stream_id,eas.semester, sm.subject_name,sm.subject_code as sub_code,eas.subject_id,sm.course_id, sm.subject_component, em.fname,em.mname,em.lname,sd.stream_name FROM `exam_applied_subjects` as eas 
			left join (select subject_id,semester,stream_id,faculty_code from exam_practical_subjects_faculty_assign where is_active='Y') f on f.subject_id = eas.subject_id and f.semester=eas.semester and f.stream_id=eas.stream_id 
			left join subject_master sm on sm.sub_id = eas.subject_id 
			left join vw_faculty em on em.emp_id = f.faculty_code 
			left join vw_stream_details sd on sd.stream_id = eas.stream_id 
			WHERE eas.stream_id='".$stream_id."' AND eas.semester='".$semester."' AND eas.subject_id='".$subject_id."' AND eas.exam_id='".$exam_id."'  
			group by eas.subject_id";*/
			
			
			$sql="SELECT sm.subject_type,sm.batch,t.batch_no, t.division,sm.stream_id,sm.semester, sm.subject_name,sm.subject_code as sub_code,sm.sub_id as subject_id,
		sm.course_id, sm.subject_component, em.fname,em.mname,em.lname,em.designation_name,ldsm.designation_name as lab_designation_name,eml.fname as lab_fname,
		eml.mname as lab_mname ,eml.lname as lab_lname ,dsm.designation_name as peon_designation_name,hem.fname as peon_fname,
		hem.mname as peon_mname ,hem.lname as peon_lname ,sd.stream_name,sd.school_short_name, 
		ext.ext_fac_name,ext.ext_fac_designation,ext.ext_fac_mobile,ext.ext_fac_email,ext.ext_fac_institute,ext.ext_faculty_code,
		f.exam_pract_fact_id, f.exam_date,f.exam_from_time,f.exam_to_time,f.time_format,f.capacity,f.verified_flag,f.lab_name,f.hall_no,f.subject_category,f.lab_assistant,f.peon,f.lab_id,f.faculty_code
		FROM `lecture_time_table` as t 
		left join (select exam_pract_fact_id,subject_id,semester,stream_id,faculty_code,ext_faculty_code,lab_assistant,peon, exam_date,exam_from_time,exam_to_time,lab_id,
					subject_category,time_format,hm.capacity,hm.lab_name,hm.hall_no,subject_type,verified_flag
					from exam_practical_subjects_faculty_assign
					left join hall_master hm on hm.id = exam_practical_subjects_faculty_assign.lab_id
					where is_active='Y' and division='".$division."' and batch_no ='".$batch_no."' AND subject_id='".$subject_id."'
					AND exam_id='".$exam_id."') f on f.subject_id = t.subject_code
		left join subject_master sm on sm.sub_id = t.subject_code
		left join vw_faculty em on em.emp_id = f.faculty_code
		LEFT JOIN hrms.employee_master eml ON eml.emp_id = f.lab_assistant
		LEFT JOIN hrms.designation_master ldsm ON ldsm.designation_id = eml.designation
		left join hrms.employee_master hem on hem.emp_id = f.peon
		LEFT JOIN hrms.designation_master dsm ON dsm.designation_id = hem.designation
		left join exam_external_faculty_master ext on ext.ext_faculty_code = f.ext_faculty_code
		left join vw_stream_details sd on sd.stream_id = t.stream_id 
		WHERE t.stream_id='".$stream_id."' AND t.semester='".$semester."' AND t.subject_code='".$subject_id."' and t.division='".$division."' and t.batch_no ='".$batch_no."' 
		group by sm.sub_id";
			
			$query = $DB1->query($sql);
			// echo '<pre>';
			// echo $DB1->last_query();// exit;
			return $query->result_array();
		}	
	
	
	
	
	
	function  get_subdetails_bklog($subject_id,$stream_id,$semester,$exam_id, $division, $batch_no,$sub_batch)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$stream = $stream_id;
		if ($stream == 9) {
			$where .= " t.stream_id in (5,6,7,8,9,10,11,12,96,97,107,108,109,151,158,159,162)";
		}elseif($stream == 235){
			$where .= " t.stream_id in (23,183,24,149,154,155,182,211,222,258,276)";
		}else {
			$where .= " t.stream_id='" . $stream . "'";
		}
		
		$sql="SELECT sm.subject_type,sm.batch,sm.stream_id,sm.semester, sm.subject_name,sm.subject_code as sub_code,sm.sub_id as subject_id,sm.course_id, sm.subject_component,
					em.fname,em.mname,em.lname,em.designation_name,ldsm.designation_name as lab_designation_name,eml.fname as lab_fname,
					eml.mname as lab_mname ,eml.lname as lab_lname ,dsm.designation_name as peon_designation_name,hem.fname as peon_fname,
					hem.mname as peon_mname ,hem.lname as peon_lname ,sd.stream_name,sd.school_short_name, 
					ext.ext_fac_name,ext.ext_fac_designation,ext.ext_fac_mobile,ext.ext_fac_email,ext.ext_fac_institute,ext.ext_faculty_code,
					f.exam_pract_fact_id, f.exam_date,f.exam_from_time,f.exam_to_time,f.time_format,f.verified_flag,f.capacity,f.lab_name,f.hall_no,f.subject_category  
				FROM `exam_student_subject` as t 
				LEFT JOIN (select exam_pract_fact_id,subject_id,semester,stream_id,faculty_code,ext_faculty_code,lab_assistant,peon, exam_date,exam_from_time,exam_to_time,
					subject_category,time_format,hm.capacity,hm.lab_name,hm.hall_no,verified_flag
					from exam_practical_subjects_faculty_assign
					LEFT JOIN hall_master hm on hm.id = exam_practical_subjects_faculty_assign.lab_id
					where is_active='Y' and division='".$division."' and batch_no ='".$batch_no."' and exam_id='$exam_id' AND subject_id='".$subject_id."' ) f on f.subject_id = t.subject_id
					LEFT JOIN subject_master sm on sm.sub_id = t.subject_id
					LEFT JOIN vw_faculty em on em.emp_id = f.faculty_code 
					LEFT JOIN hrms.employee_master eml ON eml.emp_id = f.lab_assistant
					LEFT JOIN hrms.designation_master ldsm ON ldsm.designation_id = eml.designation
					LEFT JOIN hrms.employee_master hem on hem.emp_id = f.peon
					LEFT JOIN hrms.designation_master dsm ON dsm.designation_id = hem.designation
					LEFT JOIN exam_external_faculty_master ext on ext.ext_faculty_code = f.ext_faculty_code
					LEFT JOIN vw_stream_details sd on sd.stream_id = t.stream_id 
				WHERE $where AND t.semester='" . $semester . "' AND t.subject_id='" . $subject_id . "'  
				and sm.batch='$sub_batch'  group by sm.sub_id";
		
        $query = $DB1->query($sql);
		// echo '<pre>';
		// echo $DB1->last_query();exit;
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
		// echo "<pre>";
		// print_r($var);exit;
		$DB1 = $this->load->database('umsdb', TRUE);  
		$facultyId = explode(',', $var['faculty']);
		$faculty_code = $facultyId[0];
		$labfacultyId = explode(',', $var['lab_assist']);
		$peonId = explode(',', $var['peon']);
		$labId = explode(',', $var['lab']);
		$faculty_code = $facultyId[0];
		$lab_faculty_code = $labfacultyId[0];
		$peon = $peonId[0];
		$lab = $labId[0];
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
		$data['faculty_code'] = ($faculty_code != '')?$faculty_code:$var['int_faculty_code'];
		$data['lab_assistant'] = ($lab_faculty_code != '')?$lab_faculty_code:$var['lab_assistant'];
		$data['peon'] = ($peon != '')?$peon:$var['peon_id'];
		$data['lab_id'] = ($lab != '')?$lab:$var['lab_id'];
		$data['subject_category'] =$var['subject_category'];
		
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
	    // print_r($data);exit;
		$DB1->insert('exam_practical_subjects_faculty_assign', $data);
		
		// echo $DB1->last_query();exit;
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
        $sql="UPDATE exam_practical_subjects_faculty_assign SET is_active='N',modified_by='$modified_by', modified_on='$modified_on' WHERE stream_id='".$stream_id."'
		AND semester='".$semester."' AND exam_id='".$exam_id."' AND subject_id='".$subject_code."'
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
		if($stream==71){
			$cur_ses="WIN";
		}
		$sql="SELECT t.subject_code as sub_id,t.semester,t.division, t.batch_no, s.subject_name, s.subject_code,t.stream_id,t.semester,v.school_short_name,v.stream_name  
		FROM `lecture_time_table` as t 
		left join subject_master s on s.sub_id = t.subject_code 
		left join vw_stream_details v on v.stream_id = t.stream_id 
		WHERE t.`academic_session` = '$cur_ses' AND t.semester='".$sem."' AND t.stream_id='".$stream."' AND t.`subject_type` = 'PR' 
		and t.academic_year='$acd_yr[0]' and s.batch='".$batch."' and s.is_active='Y' AND s.`practical_max` !=0
		group by t.subject_code, t.division, t.batch_no order by t.subject_code, t.division, t.batch_no";



        $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
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
		// echo $DB1->last_query();exit;
        return $query->result_array();
	}
function list_facultywise_pract_exam_subjects($exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$empid = $this->session->userdata("name");
		$sql="SELECT s.*,p.exam_id,p.division,p.batch_no,p.is_backlog,p.exam_date,vw.stream_short_name FROM exam_practical_subjects_faculty_assign p 
		left join `subject_master` as s on p.subject_id=s.sub_id 
		left join vw_stream_details vw on s.stream_id =vw.stream_id
		where p.faculty_code = '".$empid."' and p.exam_id='$exam_id' and p.is_active='Y' group by sub_id, p.division,p.batch_no";	
        $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
        return $query->result_array();
	}
	function getPractMarksEntry($subjectId, $exam_id,$stream, $semester,$is_backlog)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT * FROM marks_entry_master where subject_id='".$subjectId."' AND exam_id='".$exam_id."' AND stream_id ='".$stream."' AND is_backlog ='".$is_backlog."' ";	

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
		if($batch_no==0){
			//$batch_no=1;
		}

		$sql="SELECT * FROM marks_entry_master where subject_id='".$subjectId."' AND exam_id='".$exam_id."' AND stream_id ='".$stream."' AND division ='".$division."' AND batch_no ='".$batch_no."' "; //AND batch_no ='".$batch_no."'	

		if($semester !=''){

			$sql .=" AND semester ='".$semester."' AND marks_type='PR'";

		}
        $query = $DB1->query($sql);

		// echo $DB1->last_query();exit;

        return $query->result_array();
	}
	function getSubAppStudentList11($subject_id,$stream_id, $semester,$exam_id, $division,$batch_no){
		$DB1 = $this->load->database('umsdb', TRUE);  
		
		$sql="SELECT sas.stud_id, s.enrollment_no, sas.subject_id,s.first_name, s.middle_name, s.last_name FROM `student_applied_subject` as sas 
		left join subject_master sm on sm.sub_id=sas.subject_id 
		left join student_master s on s.stud_id=sas.stud_id 
		where sas.subject_id='".$subject_id."' and sas.stream_id='$stream_id' and sas.semester='$semester' and sas.academic_year='2025-26' and sm.is_active='Y'";
		$sql.=" group by sas.stud_id order by s.enrollment_no";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// fetch batch allocated student list
	function getSubAppStudentList($subId,$streamId, $semester,$division, $batch,$exam_id,$academic_year)
    {  


	$academic_year=ACADEMIC_YEAR;


		//$academic_year='2021-22';
        $DB1 = $this->load->database('umsdb', TRUE); 
		if($subId !='1640'){
        $where=" WHERE cancelled_admission ='N' and is_detained ='N' AND sas.subject_id='$subId' AND sas.stream_id='$streamId'
		AND sba.semester='".$semester."' and sba.division='$division' and sba.academic_year='$academic_year'";  
       	if($batch !=0){
			$where .=" and sba.batch='$batch' ";
		}	
		}else{
			$where=" WHERE cancelled_admission ='N' AND is_detained ='N' AND sas.subject_id='$subId' 
			AND sas.stream_id='$streamId' AND sba.semester='".$semester."' and sba.academic_year='$academic_year'";
		}
		
		
		
         $sql="SELECT sba.roll_no,sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,sm.admission_stream 
				FROM `student_batch_allocation` as sba 
				LEFT join student_applied_subject sas on sas.stud_id=sba.student_id and sas.stream_id=sba.stream_id and sas.is_active='Y'
				# INNER join exam_applied_subjects es on es.stud_id=sba.student_id and es.exam_id='$exam_id' and sas.subject_id=es.subject_id
				LEFT join student_master sm on sm.stud_id=sas.stud_id  $where";
		/*	$sql .=" GROUP BY sm.enrollment_no order by sm.admission_stream,sba.roll_no, sm.enrollment_no";*/

		$sql .=" GROUP BY sm.enrollment_no order by sm.admission_stream,sm.enrollment_no";
    
		
		$query = $DB1->query($sql);
		
		// echo $DB1->last_query();exit;
		
        return $query->result_array();
    }
	function list_backlogsubjects($data,$exam_id=''){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sem= $data['semester'];
		$sub_batch= $data['batch'];
		$stream= $data['admission-branch'];
		if($sem ==1 || $sem ==2){
			
			if($stream==9){
				$where.=" es.stream_id in (5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279)";	
			}elseif($stream ==239){
				$where.=" es.stream_id in(178,180,181)";	
			}elseif($stream ==236){
				$where.=" es.stream_id in(22,113,196,22,260,261)";	
			}elseif($stream ==234){
				$where.=" es.stream_id in(184,185,26,27,28)";	
			}elseif($stream ==235){
				$where.=" es.stream_id in(154,155,182,183,23)";	
			}elseif($stream ==237){
				$where.=" es.stream_id in(38,39,40)";	
			}else{
				$where.=" es.stream_id='".$stream."'";
			}
			/*else if(in_array($stream,  $stream_arr1)){
				$where.=" AND sm.stream_id =103";
			}*/
		}else{
			$where.=" es.stream_id='".$stream."'";
		}
		$sql="select * from ((SELECT sm.subject_name, sm.sub_id, sm.subject_code,sm.`subject_component`,es.stream_id,es.semester,es.subject_id FROM `exam_student_subject` as es left join subject_master sm on sm.sub_id=es.subject_id 
		WHERE es.passed ='N' AND $where and es.semester='".$sem."' and sm.batch='$sub_batch' AND sm.`subject_component` in ('PR','EM') and sm.is_active='Y'  group by es.subject_id)
		UNION
		(SELECT sm.subject_name, sm.sub_id, sm.subject_code,sm.`subject_component`,es.stream_id,es.semester,es.subject_id 
from exam_applied_subjects es 
join subject_master sm on sm.sub_id=es.subject_id 
WHERE es.exam_id='$exam_id' AND $where   
AND sm.`subject_component` in ('PR','EM') and sm.is_active='Y' and es.is_backlog='Y' and sm.batch='$sub_batch' and es.semester='".$sem."'
group by es.subject_id)) as a order by a.semester";
		// and es.semester='".$sem."' and sm.batch='$sub_batch'
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();

	}
	function  get_backlogsubdetails($subject_id,$stream_id,$semester,$exam_id, $division, $batch_no)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT sm.subject_type,sm.batch,sm.stream_id,sm.semester, sm.subject_name,sm.subject_code as sub_code,sm.sub_id as subject_id,sm.course_id, sm.subject_component,
		em.fname,em.mname,em.lname,em.designation_name,eml.designation_name as lab_designation_name,eml.fname as lab_fname,
		eml.mname as lab_mname ,eml.lname as lab_lname ,dsm.designation_name as peon_designation_name,hem.fname as peon_fname,
		hem.mname as peon_mname ,hem.lname as peon_lname ,sd.stream_name,sd.school_short_name, 
		ext.ext_fac_name,ext.ext_fac_designation,ext.ext_fac_mobile,ext.ext_fac_email,ext.ext_fac_institute,ext.ext_faculty_code,
		f.exam_pract_fact_id, f.exam_date,f.exam_from_time,f.exam_to_time,f.time_format,f.capacity,f.lab_name,f.hall_no,f.subject_category 
		FROM `exam_student_subject` as es 
		left join (select exam_pract_fact_id,subject_id,semester,stream_id,faculty_code,ext_faculty_code,lab_assistant,peon, exam_date,exam_from_time,exam_to_time,
					subject_category,time_format,hm.capacity,hm.lab_name,hm.hall_no
					from exam_practical_subjects_faculty_assign
					left join hall_master hm on hm.id = exam_practical_subjects_faculty_assign.lab_id
					where is_active='Y' and division='".$division."' and batch_no ='".$batch_no."' and exam_id='$exam_id') f on f.subject_id = es.subject_id
		left join subject_master sm on sm.sub_id = es.subject_id
		left join vw_faculty em on em.emp_id = f.faculty_code 
		left join vw_faculty eml on eml.emp_id = f.lab_assistant
		left join hrms.employee_master hem on hem.emp_id = f.peon
		LEFT JOIN hrms.designation_master dsm ON dsm.designation_id = hem.designation
		left join exam_external_faculty_master ext on ext.ext_faculty_code = f.ext_faculty_code
		left join vw_stream_details sd on sd.stream_id = es.stream_id 
		WHERE es.stream_id='".$stream_id."' AND es.semester='".$semester."' AND es.subject_id='".$subject_id."' group by sm.sub_id 
		UNION 
(SELECT sm.subject_type,sm.batch,es.stream_id,sm.semester, sm.subject_name,sm.subject_code as sub_code,sm.sub_id as subject_id,sm.course_id, sm.subject_component,
 em.fname,em.mname,em.lname,em.designation_name,eml.designation_name as lab_designation_name,eml.fname as lab_fname,
		eml.mname as lab_mname ,eml.lname as lab_lname ,dsm.designation_name as peon_designation_name,hem.fname as peon_fname,
		hem.mname as peon_mname ,hem.lname as peon_lname ,sd.stream_name,sd.school_short_name, 
		ext.ext_fac_name,ext.ext_fac_designation,ext.ext_fac_mobile,ext.ext_fac_email,ext.ext_fac_institute,ext.ext_faculty_code,
		f.exam_pract_fact_id, f.exam_date,f.exam_from_time,f.exam_to_time,f.time_format,f.capacity,f.lab_name,f.hall_no,f.subject_category 
 from exam_applied_subjects es 
join exam_details e on e.exam_id=es.exam_id and e.stud_id=es.stud_id and e.semester!=es.semester
left join (select exam_pract_fact_id,subject_id,semester,stream_id,faculty_code,ext_faculty_code,lab_assistant,peon, exam_date,exam_from_time,exam_to_time,
			subject_category,time_format,hm.capacity,hm.lab_name,hm.hall_no
			from exam_practical_subjects_faculty_assign 
			left join hall_master hm on hm.id = exam_practical_subjects_faculty_assign.lab_id
			where is_active='Y' and division='A' and batch_no ='1' and exam_id='$exam_id') f on f.subject_id = es.subject_id 
left join vw_faculty em on em.emp_id = f.faculty_code 
		left join vw_faculty eml on eml.emp_id = f.lab_assistant
		left join hrms.employee_master hem on hem.emp_id = f.peon
		LEFT JOIN hrms.designation_master dsm ON dsm.designation_id = hem.designation
		left join exam_external_faculty_master ext on ext.ext_faculty_code = f.ext_faculty_code
left join vw_stream_details sd on sd.stream_id = es.stream_id
join subject_master sm on sm.sub_id=es.subject_id 
WHERE es.exam_id='".$exam_id."' AND es.stream_id='".$stream_id."' AND sm.`subject_component` in ('PR','EM') and sm.is_active='Y' and es.semester='".$semester."' AND es.subject_id='".$subject_id."'
group by es.subject_id) ";
        $query = $DB1->query($sql);
		// echo '<pre>';
		// echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function getbacklogSubjectStudts($subject_id,$stream_id,$semester,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE ";  
        
		if($subject_id!=""){
			$where.=" e.subject_id='".$subject_id."' AND e.semester='".$semester."' and sm.cancelled_admission ='N' and e.is_backlog='Y'";// 
			
			/* if($stream_id=='103'){
				$where.=" AND e.stream_id in (43,44,45,46,47) ";
			}else if($stream_id=='9'){
				$where.=" AND e.stream_id in ('5','6','7','8','9','10','11','96','97','107','108','109','158','159','162') ";
			}else if($stream_id=='236'){
				$where.=" AND e.stream_id in (22,113,196,260,261) ";
			}else{
				$where.=" AND e.stream_id ='$stream_id' ";
			} */
			
		}		
		/*$sql="SELECT sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,sm.admission_stream FROM `exam_student_subject` as es 
		join exam_applied_subjects e on e.stud_id=es.student_id and e.subject_id=es.subject_id and e.exam_id=$exam_id 
		left join student_master sm on sm.stud_id=es.student_id $where";*/
		
		$sql="SELECT sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,sm.admission_stream 
		FROM  exam_applied_subjects e 
		left join `exam_student_subject` as es  on e.stud_id=es.student_id and e.subject_id=es.subject_id and e.exam_id=$exam_id AND es.passed ='N' 
		left join student_master sm on sm.stud_id=e.stud_id $where and e.exam_id=$exam_id ";
		$query = $DB1->query($sql);
		//	echo '<pre>';
		// echo $DB1->last_query();exit;
		return $query->result_array();
	}	
	// get faculty list
	function get_faculty_list($stream_id,$semester) {

		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select em.emp_reg_id,f.emp_id, CONCAT(f.fname, ' ', f.mname, ' ', f.lname) AS fac_name,f.department_name,f.designation_name 
		from sandipun_erp.employee_master em 
		LEFT JOIN sandipun_erp.department_master dept ON dept.department_id = em.department
		LEFT JOIN sandipun_erp.designation_master dm ON dm.designation_id = em.designation
		right JOIN vw_faculty f ON f.emp_id = em.emp_id
		# where em.emp_status = 'Y' 
		group by f.emp_id 
		order by f.fname";//where  t.stream_id='".$stream_id."' and t.subject_type='PR'
		$query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
    }	
	function get_peon_list($stream_id,$semester) {

		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT f.emp_reg_id,f.emp_id, CONCAT(f.fname, ' ', f.mname, ' ', f.lname) AS fac_name,dept.department_name,dm.designation_name,f.designation,f.emp_school
				FROM hrms.employee_master f 
				LEFT JOIN hrms.department_master dept ON dept.department_id = f.department
				LEFT JOIN hrms.designation_master dm ON dm.designation_id = f.designation
				WHERE f.designation = 64 AND f.emp_status = 'Y' AND f.campus_id = 1 # and f.emp_school = 39
				GROUP BY f.emp_id 
				ORDER BY f.fname";//where  t.stream_id='".$stream_id."' and t.subject_type='PR'
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
    }	
	function get_lab_faculty_list($stream_id,$semester) {

		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT f.emp_reg_id,f.emp_id, CONCAT(f.fname, ' ', f.mname, ' ', f.lname) AS fac_name,dept.department_name,dm.designation_name,f.designation,f.emp_school
				FROM hrms.employee_master f 
				LEFT JOIN hrms.department_master dept ON dept.department_id = f.department
				LEFT JOIN hrms.designation_master dm ON dm.designation_id = f.designation
				where f.emp_status = 'Y' AND f.campus_id = 1 and f.designation in (24,17,191,80) 
				group by f.emp_id 
				order by f.fname";//where  t.stream_id='".$stream_id."' and t.subject_type='PR'
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
    function fetch_student_strength($subId='',$streamId='', $semester='',$division='', $batch='',$academicyear='')
    {
		//$academic_year ='2019-20';
		// echo $academicyear;exit;
		$academic_year = explode('~',$academicyear);
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE cancelled_admission ='N' AND sas.subject_id='$subId' AND sas.stream_id='$streamId' AND sba.semester='".$semester."'
		and sba.division='$division' and sba.academic_year='$academic_year[0]'";  
       	if($batch !=0){
			$where .=" and sba.batch='$batch' ";
		}	
        $sql="SELECT sba.roll_no,sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile FROM `student_batch_allocation` as sba 
				left join student_applied_subject sas on sas.stud_id=sba.student_id and sas.stream_id=sba.stream_id and sas.is_active='Y'
				left join student_master sm on sm.stud_id=sas.stud_id  $where";
		$sql .=" GROUP BY sm.enrollment_no order by sm.admission_stream,sba.roll_no, sm.enrollment_no";
        $query = $DB1->query($sql);
			// echo $DB1->last_query(); echo "<br>";exit;
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
		$sql="SELECT t.subject_code as sub_id,t.semester,t.division, t.batch_no, s.subject_name, s.subject_code,s.batch,t.stream_id,t.academic_year,academic_session,v.stream_name  FROM `lecture_time_table` as t 
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
				$where.=" es.stream_id in (5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279)";	
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
		// print_r($var);exit;
		$extfacultycode =explode(',',$var['change_exfaculty']);
		$facultyId = explode(',', $var['faculty']);
		$faculty_code = $facultyId[0];
		$labfacultyId = explode(',', $var['lab_assist']);
		$peonId = explode(',', $var['peon']);
		$labId = explode(',', $var['lab']);
		$faculty_code = $facultyId[0];
		$lab_faculty_code = $labfacultyId[0];
		$peon = $peonId[0];
		$lab = $labId[0];
		$lab_detail = ($lab != '')?$lab:$var['lab_id'];
		$ext_faculty_code =$extfacultycode[0];
		$lab_faculty = ($lab_faculty_code != '')?$lab_faculty_code:$var['lab_assistant'];
		$peon_id = ($peon != '')?$peon:$var['peon_id'];
		$peon =$peonID[0];
		$set ='';
		
		if(!empty($var['change_exfaculty'])){
			$set .= "ext_faculty_code='$ext_faculty_code',";
		}		
		if(!empty($var['change_lab_id'])){
			$set .= "lab_id='$lab_detail',";
		}		
		if(!empty($var['subject_category'])){
			$set .= "subject_category='$subject_category',";
		}		
		if(!empty($var['lab_assist'])){
			$set .= "lab_assistant='$lab_faculty',";
		}
		if(!empty($var['peon'])){
			$set .= "peon='$peon_id',";
		}

    	$tbl_id = $var['exam_pract_fact_id'];
		
		$exam_date =$var['exam_date'];
		$exam_from_time =$var['exam_from_time'];
		$exam_to_time =$var['exam_to_time'];
		$time_format =$var['time_format'];
		$modified_on = date('Y-m-d H:i:s');	
		$modified_by = $this->session->userdata("uid");
		
        $DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="UPDATE exam_practical_subjects_faculty_assign SET $set modified_by='$modified_by', modified_on='$modified_on', exam_date='$exam_date', 
		exam_from_time='$exam_from_time', exam_to_time='$exam_to_time', time_format='$time_format' WHERE exam_pract_fact_id='".$tbl_id."'";
		
        $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
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
		$sql="SELECT distinct sub_id, subject_code,subject_name,stream_id,semester,batch
		FROM `subject_master` WHERE `subject_name` LIKE '%English Communication Skill%' and subject_component='PR' and is_active='Y' and semester in (1) order by batch,semester";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}	
	 function testfetch_student_strength($subId,$streamId, $semester)
    {
		$academic_year ='2025-26';
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE cancelled_admission ='N' AND sas.subject_id='$subId' AND sas.stream_id='$streamId' AND sas.semester='".$semester."' and sas.academic_year='$academic_year' and sas.is_active='Y'";
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
	function fetch_pract_marks_entry_status($var,$exam_id)
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
		
        $sql="SELECT distinct me_id  FROM `marks_entry` WHERE subject_id='$sub_id' AND semester='".$semester."' and division='$division' and batch_no='$batch_no' and exam_id='$exam_id' and marks_type='PR'";
		if($stream_id==9){
				$sql.=" AND stream_id in (5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279)";
			}else if($stream_id==235){
				$sql.=" AND stream_id in (23,24,148,149,154,155,182,183,204,206,207)";
			}else if($stream_id==236){
				$sql.=" AND stream_id in (22,113,196,260,261)";				
			}else if($stream_id==234){
				$sql.=" AND stream_id in (27,28,26,70,126,150,157,164,172,184,185,186,199,200,201,202,203,214,215)";
			}else{
				$sql.=" AND stream_id='".$stream_id."'";
				
			}
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
        if($role_id!=15)
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
		s.internal_max FROM `exam_applied_subjects` as eas 
		left join subject_master s on s.sub_id = eas.subject_id 
		left join vw_stream_details vw on vw.stream_id=eas.stream_id
	
		$where group by s.sub_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}	
function coe_getSubAppStudentList($subId,$streamId, $semester,$division, $batch,$exam_id)
    {
		$academic_year ='2025-26';
        $DB1 = $this->load->database('umsdb', TRUE); 

		$where=" WHERE cancelled_admission ='N' AND sas.subject_id='$subId' AND sas.stream_id='$streamId' AND sas.semester='".$semester."' and sas.academic_year='$academic_year' and sas.is_active='Y'";

        $sql="SELECT sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,sm.admission_stream 
		FROM `student_applied_subject` as sas 
		left join student_master sm on sm.stud_id=sas.stud_id and sas.stream_id=sm.admission_stream $where";
	/*	$sql .=" GROUP BY sm.enrollment_no order by sm.admission_stream,sba.roll_no, sm.enrollment_no";*/
		$sql .=" GROUP BY sm.enrollment_no order by sm.admission_stream,sm.enrollment_no";
        $query = $DB1->query($sql);
		
		// echo $DB1->last_query();exit;
		
        return $query->result_array();
		
    }
	function coe_getPractMarksEntry1($subjectId, $exam_id,$stream, $semester,$is_backlog,$division, $batch_no)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT * FROM marks_entry_master where subject_id='".$subjectId."' AND exam_id='".$exam_id."' AND stream_id ='".$stream."' ";	

		if($semester !=''){

			$sql .=" AND semester ='".$semester."' AND marks_type='PR'";

		}
        $query = $DB1->query($sql);

		//echo $DB1->last_query();exit;

        return $query->result_array();
	}
		///// updating cia marks of failed students
	function get_failed_studentlist($exam_id,$exam_month,$exam_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `exam_applied_subjects` WHERE  exam_id='$exam_id' and allow_for_exam='Y' ";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function get_failedstudciamarks($stud,$exam_id,$exam_month,$exam_year)
    {
    	//print_r($stud);
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql9="SELECT * FROM `marks_entry_cia` WHERE  `subject_id` ='".$stud['subject_id']."'  AND `stud_id` ='".$stud['stud_id']."' AND `semester` ='".$stud['semester']."' and exam_id='$exam_id' ORDER BY cia_id DESC LIMIT 0, 1";
		$query9 = $DB1->query($sql9);
        $res9 = $query9->result_array();
		//print_r($res9[0]);exit;
		if(empty($res9[0])){
        $sql="SELECT * FROM `marks_entry_cia` WHERE  `subject_id` ='".$stud['subject_id']."'  AND `stud_id` ='".$stud['stud_id']."' AND `semester` ='".$stud['semester']."' ORDER BY cia_id DESC LIMIT 0, 1";//`stream_id` ='".$stud['stream_id']."' AND
        $query = $DB1->query($sql);
        $res = $query->result_array();
        $sql1 ="INSERT INTO marks_entry_cia (`me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `cia_marks`, `attendance_marks`, `exam_id`, `exam_month`, `exam_year`, `division`, `batch_no`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted`)
				SELECT `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `cia_marks`, `attendance_marks`, `exam_id`, `exam_month`, `exam_year`, `division`, `batch_no`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted` FROM marks_entry_cia where cia_id='".$res[0]['cia_id']."'";
				$query1 = $DB1->query($sql1);
				
		//echo $DB1->last_query();exit;
        //$res1=$query1->result_array();
        $insert_id = $DB1->insert_id(); 
        $inserted_on = date('Y-m-d H:i:s');	
		$inserted_by = $this->session->userdata("uid");
        $sql2="update `marks_entry_cia` set exam_id='$exam_id',entry_on='$inserted_on',entry_by='$inserted_by',modified_on='$inserted_on',modified_by='$inserted_by', exam_month='$exam_month',exam_year='$exam_year'  WHERE `cia_id` ='".$insert_id."'";
        $query2 = $DB1->query($sql2);
		//exit;
       // unset();
		}
        return true;
    }
    //for updating stream in marks entry script
	function get_mrkstudent_list()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT m.stud_id,m.stream_id,m.exam_id,s.admission_stream,m.semester FROM `marks_entry` m 
		left join student_master s on s.stud_id=m.stud_id where m.exam_id='9' AND m.stream_id='9'";
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
        $sql2="update `marks_entry` set stream_id='".$stud_stream."'  WHERE `stud_id` ='".$stud_id."' and exam_id=9 and marks_type='PR' and stream_id=9 and semester='$semester'";
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

left join exam_applied_subjects e on f.subject_id= e.subject_id and f.semester=e.semester and e.stud_id=f.student_id and f.stream_id !=e.stream_id 

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
        $sql2="update `exam_applied_subjects` set stream_id='".$stud_stream."'  WHERE `exam_subject_id` ='".$exam_subject_id."' and exam_id=9";
        $query2 = $DB1->query($sql2);
		 return true;
    }
//////
	function get_bklog_streamstud_list_marksentry()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT e.m_id,e.exam_id,e.stud_id,e.subject_id,e.stream_id,e.semester,f.stream_id as bklog_stream FROM exam_student_subject f left join marks_entry e on f.subject_id= e.subject_id and f.semester=e.semester and e.stud_id=f.student_id and f.stream_id !=e.stream_id where e.exam_id=9 and f.passed='N' and f.stream_id=49";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function update_bklog_streamstud_marksentry($stud)
    {
		$stud_stream=$stud['bklog_stream'];
		$m_id=$stud['m_id'];
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql2="update `marks_entry` set stream_id='".$stud_stream."'  WHERE `m_id` ='".$m_id."' and exam_id=9";
        $query2 = $DB1->query($sql2);
		 return true;
    }
/////
	function get_bklog_streamstud_list_cia_marks()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT e.cia_id,e.exam_id,e.stud_id,e.subject_id,e.stream_id,e.semester,f.stream_id as bklog_stream FROM exam_student_subject f left join marks_entry_cia e on f.subject_id= e.subject_id and f.semester=e.semester and e.stud_id=f.student_id and f.stream_id !=e.stream_id where e.exam_id=9 and f.passed='N' and f.stream_id=49 ";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function update_bklog_streamstud_cia_marks($stud)
    {
		$stud_stream=$stud['bklog_stream'];
		$cia_id=$stud['cia_id'];
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql2="update `marks_entry_cia` set stream_id='".$stud_stream."'  WHERE `cia_id` ='".$cia_id."' and exam_id=9";
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
        $sql="SELECT e.enrollment_no,e.subject_id,c.attendance_marks FROM `exam_result_data` e left join marks_entry_cia c on e.exam_id=c.exam_id and e.subject_id=c.subject_id and e.enrollment_no=c.enrollment_no where e.exam_id='".$exam_id."' group by e.enrollment_no,c.subject_id";
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
		$sql="update exam_result_data set attendance_grade= '$attendance_grade' where exam_id='$exam_id' and enrollment_no='$enrollement_no' and subject_id='$subject_id'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return true;
    }
	///
	function fetch_streamwisetopper_list30123($stream)
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
	function fetch_stream_division_list301223($vr)
    {
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT (semester-1) AS semester,division,stream_id FROM student_batch_allocation WHERE stream_id='".$vr."' AND academic_year='2019-20' GROUP BY semester,division";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
	
	
	function fetch_streamwisetopper_list($stream)
    {
		$DB1 = $this->load->database('umsdb', TRUE);
		/*$sql="SELECT e.enrollment_no,e.cumulative_gpa,e.exam_id,e.stream_id,e.semester, s.first_name,s.middle_name,s.last_name,v.stream_name,s.admission_year,s.admission_session FROM `exam_result_master` e
		left join student_master s on e.student_id=s.stud_id
		left join vw_stream_details v on e.stream_id=v.stream_id
		where s.admission_session='2017' and s.admission_year='1' and e.stream_id ='$stream' and exam_id=7 and e.semester=2 and student_id not in (SELECT student_id FROM `exam_student_subject` where passed ='N' and semester in(1,2)) ORDER BY cumulative_gpa DESC limit 0,3";*/
		
		/*$sql="SELECT s.enrollment_no,s.stud_id,e.cumulative_gpa,e.exam_id,e.stream_id,e.semester, s.first_name,s.middle_name,s.last_name,v.school_short_name,v.stream_name,s.admission_year,s.admission_session 
FROM `exam_result_master` e
LEFT JOIN student_master s ON e.student_id=s.stud_id
LEFT JOIN vw_stream_details v ON e.stream_id=v.stream_id
WHERE e.stream_id ='".$stream['stream_id']."' and exam_id in ('24,25,26,27') AND e.semester='".$stream['semester']."' and e.student_id NOT IN (SELECT student_id FROM `exam_result_data` WHERE `result_grade` = 'U') GROUP BY e.student_id,stream_id,semester ORDER BY v.school_code,v.course_id,stream_id, cumulative_gpa DESC LIMIT 0,3";
*/
$sql="SELECT s.enrollment_no,s.stud_id,e.cumulative_gpa,e.exam_id,e.stream_id,e.semester,e.exam_month,e.exam_year, s.first_name,s.middle_name,s.last_name,v.school_short_name,v.stream_name,s.admission_year,s.admission_session 
FROM `exam_result_master` e LEFT JOIN student_master s ON e.student_id=s.stud_id
LEFT JOIN vw_stream_details v ON e.stream_id=v.stream_id 
WHERE e.exam_id IN (24,25,26,27) and e.stream_id = '".$stream['stream_id']."' and e.semester ='".$stream['semester']."'  and e.student_id NOT IN (SELECT student_id FROM `exam_result_data` WHERE `final_grade` = 'U')GROUP BY e.student_id,e.stream_id,e.school_id ORDER BY cumulative_gpa desc LIMIT 0,3;";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $res= $query->result_array();
    }


	function fetch_stream_division_list($vr)
    {
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT  semester,stream_id FROM exam_result_master WHERE stream_id='".$vr."' AND exam_id in(24,25,26,27)  AND (semester % 2) = 0 
        
        GROUP BY semester,stream_id";
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
	function get_examappliedsubjects($exam_id,$exam_month,$exam_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `exam_applied_subjects` WHERE  exam_id='$exam_id' AND allow_for_exam='Y' and stream_id!=118 GROUP BY subject_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function update_marks_master_cia($stud,$exam_id,$exam_month,$exam_year)
    {
    	//print_r($stud);
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql9="SELECT * FROM `marks_entry_master` WHERE  `subject_id` ='".$stud['subject_id']."' AND marks_type='CIA' and `semester` ='".$stud['semester']."' and exam_id='$exam_id' ORDER BY me_id DESC LIMIT 0,1";
		$query9 = $DB1->query($sql9);
        $res9 = $query9->result_array();
		
		if(empty($res9[0])){
			//echo 'inside';
        $sql="SELECT * FROM marks_entry_master WHERE marks_type='CIA' AND semester='".$stud['semester']."' AND `subject_id` ='".$stud['subject_id']."' ORDER BY me_id DESC LIMIT 0,1";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		if(!empty($res[0])){
        $sql1 ="INSERT INTO `marks_entry_master` (`exam_id`, `subject_id`, `stream_id`, `semester`, `division`, `batch_no`, `marks_type`, `max_marks`, `marks_entry_date`, `exam_month`, `exam_year`, `specializaion_id`, `subject_code`, `is_backlog`, `entry_by`, `entry_on`, `verified_by`, `verified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `approved_by`, `approved_on`, `entry_status`)
				SELECT `exam_id`, `subject_id`, `stream_id`, `semester`, `division`, `batch_no`, `marks_type`, `max_marks`, `marks_entry_date`, `exam_month`, `exam_year`, `specializaion_id`, `subject_code`, `is_backlog`, `entry_by`, `entry_on`, `verified_by`, `verified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `approved_by`, `approved_on`, `entry_status` FROM marks_entry_master where me_id='".$res[0]['me_id']."'";
				$query1 = $DB1->query($sql1);
				
		//echo $DB1->last_query();exit;
        //$res1=$query1->result_array();
        $insert_id = $DB1->insert_id(); 
        $inserted_on = date('Y-m-d H:i:s');	
		$inserted_by = $this->session->userdata("uid");
        $sql2="update `marks_entry_master` set exam_id='$exam_id',entry_on='$inserted_on',entry_by='$inserted_by',verified_on='$inserted_on',verified_by='$inserted_by', exam_month='$exam_month',exam_year='$exam_year'  WHERE `me_id` ='".$insert_id."'";
        $query2 = $DB1->query($sql2);
		}
       // unset();
		}
		//echo 'outside';exit;
        return true;
    }
	
	function get_examappliedPrsubjects($exam_id='')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        /*$sql="SELECT e.* FROM `exam_applied_subjects` e  
LEFT JOIN subject_master s ON s.sub_id=e.subject_id
WHERE e.exam_id=12 AND s.subject_component='EM' AND e.enrollment_no NOT IN ('180101061039','180105118045','180105131003','170101092010','170101092016','170101092019','170101092039','170101092040','170101092048','170101092050','170101092053','170101092058','170101092061','170101092075','170101092090','170101092091','170101092104','170101092108','170101092110','170101091029','180101092021','180101092023','180101092028','180101092043','180101092045','170101081004','170101081008','180101082004','180101082005','180101082017','170101081003','170101081004','170101081008','170101081002','170101081004','170101081010','180101082001','170101081002','170101081010','170101081011','180101082018','180101082019','170101082008','170101082030','170101082045','170101082002','170101082003','170101082013','170101082045')
";*/
		$sql ="SELECT e.* FROM exam_applied_subjects e LEFT JOIN subject_master s ON e.subject_id=s.sub_id 
WHERE e.exam_id='$exam_id' AND s.subject_component='EM' AND s.is_active='Y' AND e.allow_for_exam='Y' ";

        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function get_examresultPrsubjects($exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM exam_result_data  e
LEFT JOIN subject_master s ON s.sub_id=e.subject_id
WHERE e.exam_id=$exam_id AND s.subject_component='EM'  AND practical_marks IS NULL";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	
	function check_marks_entered_practical($stud,$exm_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT stud_id FROM marks_entry WHERE exam_id=$exm_id AND marks_type='PR' AND `subject_id` ='".$stud['subject_id']."' and enrollment_no='".$stud['enrollment_no']."' limit 0, 1";//exit;
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function check_marks_entered_EMPR($stud,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT stud_id FROM marks_entry WHERE exam_id=$exam_id AND marks_type='PR' AND `subject_id` ='".$stud['subject_id']."' and stud_id='".$stud['stud_id']."' limit 0, 1";//exit;
        $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function check_marks_entered_EMTH($stud,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT stud_id FROM marks_entry WHERE exam_id=$exam_id AND marks_type='TH' AND `subject_id` ='".$stud['subject_id']."' and stud_id='".$stud['stud_id']."' limit 0, 1";//exit;
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function check_marks_entered_theory($stud,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT stud_id FROM marks_entry WHERE exam_id=$exam_id AND marks_type='TH' AND `subject_id` ='".$stud['subject_id']."' and enrollment_no='".$stud['enrollment_no']."' limit 0, 1";//exit;
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function check_marks_entered_cia($stud,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT stud_id FROM marks_entry_cia WHERE exam_id=$exam_id AND `subject_id` ='".$stud['subject_id']."' and stud_id='".$stud['stud_id']."' limit 0, 1";//exit;
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function check_marks_entered_ciam($stud,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT me_id FROM marks_entry_master WHERE exam_id=$exam_id AND `subject_id` ='".$stud['subject_id']."' and marks_type='CIA' limit 0, 1";//exit;
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function update_marks_master_practical($stud,$exam_id,$exam_month,$exam_year)
    {
    	//print_r($stud);
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT * FROM marks_entry WHERE marks_type='PR' AND `subject_id` ='".$stud['subject_id']."' and enrollment_no='".$stud['enrollment_no']."' ORDER BY `m_id` DESC limit 0, 1";//exit;
        $query = $DB1->query($sql);
        $res = $query->result_array();
        $sql1 ="INSERT INTO `marks_entry` (`me_id`, `stud_id`, `enrollment_no`, `exam_id`, `stream_id`, `semester`, `specialization_id`, `division`, `batch_no`, `subject_id`, `subject_code`, `marks_type`, `marks`, `reval_marks`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `is_deleted`)
				SELECT `me_id`, `stud_id`, `enrollment_no`, `exam_id`, `stream_id`, `semester`, `specialization_id`, `division`, `batch_no`, `subject_id`, `subject_code`, `marks_type`, `marks`, `reval_marks`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `is_deleted` FROM marks_entry where m_id='".$res[0]['m_id']."'";
				$query1 = $DB1->query($sql1);				
		//echo $DB1->last_query();exit;
        //$res1=$query1->result_array();
        $insert_id = $DB1->insert_id(); 
        $inserted_on = date('Y-m-d H:i:s');	
		$inserted_by = $this->session->userdata("uid");
        $sql2="update `marks_entry` set exam_id=$exam_id,entry_on='$inserted_on',entry_by='$inserted_by',modified_on='$inserted_on',modified_by='$inserted_by', exam_month='$exam_month',exam_year='$exam_year'  WHERE `m_id` ='".$insert_id."'";
        $query2 = $DB1->query($sql2);
       // unset();
        return true;
    }
/*************************** script for mapping backlog Cia marks Start*************************************/
//for regular exam
	function get_backlog_studentsubjects($exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT e.semester AS cur_sem,eas.semester,eas.subject_id,eas.stud_id,eas.stream_id FROM exam_details e 
LEFT JOIN exam_applied_subjects eas ON eas.exam_id=e.exam_id AND e.enrollment_no = eas.enrollment_no 
WHERE e.exam_id='".$exam_id."' AND e.semester !=eas.semester and eas.allow_for_exam='Y'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function updateBklogCiamarks($stud,$exam_id,$exam_month,$exam_year)  // for regular exam
    {
    	//print_r($stud);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `marks_entry_cia` WHERE  `subject_id` ='".$stud['subject_id']."'  AND `stud_id` ='".$stud['stud_id']."' AND `semester` ='".$stud['semester']."' ORDER BY cia_id DESC LIMIT 0, 1";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        $sql1 ="INSERT INTO marks_entry_cia (`me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `cia_marks`, `attendance_marks`, `exam_id`, `exam_month`, `exam_year`, `division`, `batch_no`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted`)
				SELECT `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `cia_marks`, `attendance_marks`, `exam_id`, `exam_month`, `exam_year`, `division`, `batch_no`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted` FROM marks_entry_cia where cia_id='".$res[0]['cia_id']."'";
				$query1 = $DB1->query($sql1);
				
		//echo $DB1->last_query();exit;
        //$res1=$query1->result_array();
        $insert_id = $DB1->insert_id(); 
        $inserted_on = date('Y-m-d H:i:s');	
		$inserted_by = $this->session->userdata("uid");
        $sql2="update `marks_entry_cia` set exam_id='".$exam_id."',entry_on='$inserted_on',entry_by='$inserted_by',modified_on='$inserted_on',modified_by='$inserted_by', exam_month='".$exam_month."',exam_year='".$exam_year."'  WHERE `cia_id` ='".$insert_id."'";
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
        $sql="SELECT e.semester AS cur_sem,eas.semester,eas.subject_id,eas.stream_id FROM exam_details e 
LEFT JOIN exam_applied_subjects eas ON eas.exam_id=e.exam_id AND e.enrollment_no = eas.enrollment_no AND e.stream_id=eas.stream_id
WHERE e.exam_id='".$exam_id."' AND e.semester !=eas.semester GROUP BY subject_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function updateBklogCiaMaster($stud,$exam_id,$exam_month,$exam_year)
    {
    	//print_r($stud);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM marks_entry_master WHERE marks_type='CIA'  AND semester='".$stud['semester']."' AND subject_id='".$stud['subject_id']."' ORDER BY me_id DESC LIMIT 0,1";//AND stream_id='".$stud['stream_id']."'
        $query = $DB1->query($sql);
        $res = $query->result_array();
        $sql1 ="INSERT INTO `sandipun_ums`.`marks_entry_master` (`exam_id`, `subject_id`, `stream_id`, `semester`, `division`, `batch_no`, `marks_type`, `max_marks`, `marks_entry_date`, `exam_month`, `exam_year`, `specializaion_id`, `subject_code`, `is_backlog`, `entry_by`, `entry_on`, `verified_by`, `verified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `approved_by`, `approved_on`, `entry_status`)
				SELECT `exam_id`, `subject_id`, `stream_id`, `semester`, `division`, `batch_no`, `marks_type`, `max_marks`, `marks_entry_date`, `exam_month`, `exam_year`, `specializaion_id`, `subject_code`, `is_backlog`, `entry_by`, `entry_on`, `verified_by`, `verified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `approved_by`, `approved_on`, `entry_status` FROM marks_entry_master where me_id='".$res[0]['me_id']."'";
				$query1 = $DB1->query($sql1);
				
		//echo $DB1->last_query();exit;
        //$res1=$query1->result_array();
        $insert_id = $DB1->insert_id(); 
        $inserted_on = date('Y-m-d H:i:s');	
		$inserted_by = $this->session->userdata("uid");
        $sql2="update `marks_entry_master` set exam_id='".$exam_id."',entry_on='$inserted_on',entry_by='$inserted_by',exam_month='".$exam_month."',exam_year='".$exam_year."' WHERE `me_id` ='".$insert_id."'";
        $query2 = $DB1->query($sql2); 
		//echo $DB1->last_query();exit;
		//exit;
       // unset(); 
        return true;
    }
	function get_backlog_EMPR_studentsubjects($exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        //$sql="SELECT * FROM marks_entry WHERE marks_type='PR' AND subject_id='1642' AND exam_id=10 AND enrollment_no IN('180105171005','180105171001')";
$sql="SELECT e.semester AS cur_sem,eas.semester,eas.subject_id,eas.stud_id,eas.stream_id FROM exam_details e 
LEFT JOIN exam_applied_subjects eas ON eas.exam_id=e.exam_id AND e.enrollment_no = eas.enrollment_no AND e.stream_id=eas.stream_id
INNER JOIN subject_master s ON s.sub_id=eas.subject_id AND s.`subject_component`='EM'
WHERE e.exam_id='".$exam_id."' AND e.semester !=eas.semester AND eas.allow_for_exam='Y'";
        $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
	function updateBklog_EMPR_marks($stud,$exam_id,$exam_month,$exam_year)
    {
    	//print_r($stud);
        $DB1 = $this->load->database('umsdb', TRUE);
        //$sql="SELECT * FROM `marks_entry` WHERE `stream_id` ='".$stud['stream_id']."' AND `subject_id` ='".$stud['subject_id']."'  AND `stud_id` ='".$stud['stud_id']."' AND `semester` ='".$stud['semester']."' and exam_id='9' limit 0, 1";
		$sql="SELECT * FROM marks_entry WHERE marks_type='PR' AND `subject_id` ='".$stud['subject_id']."' and stud_id='".$stud['stud_id']."' AND `semester` ='".$stud['semester']."' ORDER BY m_id DESC LIMIT 0,1";
        $query = $DB1->query($sql);//exit;
        $res = $query->result_array();
        $sql1 ="INSERT INTO `marks_entry` (`me_id`, `stud_id`, `enrollment_no`, `exam_id`, `stream_id`, `semester`, `specialization_id`, `division`, `batch_no`, `subject_id`, `subject_code`, `marks_type`, `marks`, `reval_marks`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `is_deleted`)
				SELECT `me_id`, `stud_id`, `enrollment_no`, `exam_id`, `stream_id`, `semester`, `specialization_id`, `division`, `batch_no`, `subject_id`, `subject_code`, `marks_type`, `marks`, `reval_marks`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `is_deleted` FROM marks_entry where m_id='".$res[0]['m_id']."'";
				$query1 = $DB1->query($sql1);
				
		//echo $DB1->last_query();exit;
        //$res1=$query1->result_array();
        $insert_id = $DB1->insert_id(); 
        $inserted_on = date('Y-m-d H:i:s');	
		$inserted_by = $this->session->userdata("uid");
        $sql2="update `marks_entry` set exam_id='".$exam_id."',entry_on='$inserted_on',entry_by='$inserted_by',modified_on='$inserted_on',modified_by='$inserted_by', exam_month='".$exam_month."',exam_year='".$exam_year."'  WHERE `m_id` ='".$insert_id."'";
        $query2 = $DB1->query($sql2); 
		
		//exit;
       // unset();
        return true;
    }
	function updateBklog_EMTH_marks($stud,$exam_id,$exam_month,$exam_year)
    {
    	//print_r($stud);
        $DB1 = $this->load->database('umsdb', TRUE);
        //$sql="SELECT * FROM `marks_entry` WHERE `stream_id` ='".$stud['stream_id']."' AND `subject_id` ='".$stud['subject_id']."'  AND `stud_id` ='".$stud['stud_id']."' AND `semester` ='".$stud['semester']."' and exam_id='9' limit 0, 1";
		$sql="SELECT * FROM marks_entry WHERE marks_type='TH' AND `subject_id` ='".$stud['subject_id']."' and stud_id='".$stud['stud_id']."' AND `semester` ='".$stud['semester']."' ORDER BY m_id DESC LIMIT 0,1";
        $query = $DB1->query($sql);//exit;
        $res = $query->result_array();
        $sql1 ="INSERT INTO `marks_entry` (`me_id`, `stud_id`, `enrollment_no`, `exam_id`, `stream_id`, `semester`, `specialization_id`, `division`, `batch_no`, `subject_id`, `subject_code`, `marks_type`, `marks`, `reval_marks`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `is_deleted`)
				SELECT `me_id`, `stud_id`, `enrollment_no`, `exam_id`, `stream_id`, `semester`, `specialization_id`, `division`, `batch_no`, `subject_id`, `subject_code`, `marks_type`, `marks`, `reval_marks`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `is_deleted` FROM marks_entry where m_id='".$res[0]['m_id']."'";
				$query1 = $DB1->query($sql1);
				
		//echo $DB1->last_query();exit;
        //$res1=$query1->result_array();
        $insert_id = $DB1->insert_id(); 
        $inserted_on = date('Y-m-d H:i:s');	
		$inserted_by = $this->session->userdata("uid");
        $sql2="update `marks_entry` set exam_id='".$exam_id."',entry_on='$inserted_on',entry_by='$inserted_by',modified_on='$inserted_on',modified_by='$inserted_by', exam_month='".$exam_month."',exam_year='".$exam_year."'  WHERE `m_id` ='".$insert_id."'";
        $query2 = $DB1->query($sql2); 
		
		//exit;
       // unset();
        return true;
    }	
	function get_backlog_masterEMPRsubjects($exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT e.semester AS cur_sem,eas.semester,eas.subject_id,eas.stud_id,eas.stream_id FROM exam_details e 
LEFT JOIN exam_applied_subjects eas ON eas.exam_id=e.exam_id AND e.enrollment_no = eas.enrollment_no AND e.stream_id=eas.stream_id
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
        $sql="SELECT * FROM marks_entry_master WHERE marks_type='PR' AND stream_id='".$stud['stream_id']."' AND semester='".$stud['semester']."' AND subject_id='".$stud['subject_id']."' ORDER BY me_id DESC LIMIT 0,1";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        $sql1 ="INSERT INTO `sandipun_ums`.`marks_entry_master` (`exam_id`, `subject_id`, `stream_id`, `semester`, `division`, `batch_no`, `marks_type`, `max_marks`, `marks_entry_date`, `exam_month`, `exam_year`, `specializaion_id`, `subject_code`, `is_backlog`, `entry_by`, `entry_on`, `verified_by`, `verified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `approved_by`, `approved_on`, `entry_status`)
				SELECT `exam_id`, `subject_id`, `stream_id`, `semester`, `division`, `batch_no`, `marks_type`, `max_marks`, `marks_entry_date`, `exam_month`, `exam_year`, `specializaion_id`, `subject_code`, `is_backlog`, `entry_by`, `entry_on`, `verified_by`, `verified_on`, `reval_entry_by`, `reval_entry_on`, `reval_entry_ip`, `approved_by`, `approved_on`, `entry_status` FROM marks_entry_master where me_id='".$res[0]['me_id']."'";
				$query1 = $DB1->query($sql1);
				
		//echo $DB1->last_query();exit;
        //$res1=$query1->result_array();
        $insert_id = $DB1->insert_id();  
        $inserted_on = date('Y-m-d H:i:s');	
		$inserted_by = $this->session->userdata("uid");
        $sql2="update `marks_entry_master` set exam_id='".$exam_id."',entry_on='$inserted_on',entry_by='$inserted_by',exam_month='".$exam_month."',exam_year='".$exam_year."' WHERE `me_id` ='".$insert_id."'";
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
        //$sql="SELECT * FROM marks_entry WHERE marks_type='PR' AND subject_id='1642' AND exam_id=10 AND enrollment_no IN('180105171005','180105171001')";
$sql="SELECT e.enrollment_no,e.stud_id,s.first_name,s.middle_name,e.exam_id,s.last_name,ed.cumulative_gpa,e.stud_id,e.stream_id,
e.semester,v.stream_name FROM exam_details e
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
		$sql="SELECT enrollment_no,student_id,stream_id,semester,final_grade,subject_id FROM exam_result_data WHERE exam_id='".$strm['exam_id']."' and stream_id='".$strm['stream_id']."' and semester='".$strm['semester']."'  and student_id='".$strm['stud_id']."'";
        $query = $DB1->query($sql);

        return $query->result_array();
    }
	function fetch_student_strength_backlog($sub_id,$semester,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		//$sql="SELECT SUM(cnt) as cnt from (SELECT count(*) as cnt FROM exam_student_subject WHERE semester='".$semester."'  and subject_id='".$sub_id."' and passed='N' UNION ALL SELECT count(*)  FROM exam_applied_subjects WHERE semester='".$semester."'  and subject_id='".$sub_id."' and exam_id='$exam_id') as b";
		$sql="SELECT * 
			FROM exam_applied_subjects 
			WHERE semester='".$semester."' and subject_id='".$sub_id."' and exam_id = '".$exam_id."' and is_backlog='Y' ";
        $query = $DB1->query($sql);
        return $query->result_array();
	}
	
	
	function Marks_submission_date($exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `marks_entery_date` WHERE exam_id='$exam_id' AND status='Y'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	
		function updatearrears($exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT student_id,enrollment_no,subject_id,reval_grade, final_grade FROM exam_result_data WHERE exam_id=13 AND reval_grade IS NOT NULL ";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
	function updatearrearstest($grade,$student_id,$subject_id)
    {
    	//print_r($stud);
        $DB1 = $this->load->database('umsdb', TRUE);
   
        $sql2="update `exam_student_subject` set passed='Y',grade='$grade' WHERE student_id ='".$student_id."' and exam_id=13 and subject_id=$subject_id";//exit;
        $query2 = $DB1->query($sql2); 
		//echo $DB1->last_query();exit;
		//exit;
       // unset();
        return true;
    }
	///////////////////////////////////////////////////
	function get_examappliedsubjectsjune20()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `marks_entry_cia` c left join subject_master s on s.sub_id=c.subject_id WHERE  c.exam_id=15 and c.stud_id in(2373)  and (s.subject_component='TH' OR s.subject_component='PR' OR s.subject_component='EM')";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function insert_marks_master_cia_june20($stud)
    {
    	
    $DB1 = $this->load->database('umsdb', TRUE);		
	$data['stud_id']=$stud['stud_id'];
	$data['enrollment_no']=$stud['enrollment_no'];
	$data['exam_id']=$stud['exam_id'];
	$data['stream_id']=$stud['stream_id'];
	$data['semester']=$stud['semester'];
	$data['specialization_id']=$stud['specialization_id'];
	$data['division']=$stud['division'];
	$data['batch_no']=$stud['batch_no'];
	$data['subject_id']=$stud['subject_id'];
	$data['subject_code']=$stud['subject_code'];
	$data['marks_type']='TH';
	$data['marks']=$stud['cia_marks']*2;
	$data['reval_marks']=$stud['reval_marks'];
	$data['exam_month']=$stud['exam_month'];
	$data['exam_year']=$stud['exam_year'];
	$data['entry_ip']=$stud['entry_ip'];
	$data['entry_by']=2;
	$data['entry_on']=date('Y-m-d H:i:s');
	//echo "<pre>";print_r($data);exit;
	$DB1->insert('marks_entry', $data);
	//echo $DB1->last_query();
	//exit;
        return true;
    }
	function get_examappliedsubjects_masterjune20()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT c.*,s.theory_max FROM `marks_entry_cia` c left join subject_master s on s.sub_id=c.subject_id WHERE  c.exam_id=15 and c.stud_id in(2373) and (s.subject_component='PR' OR s.subject_component='TH' OR s.subject_component='EM') group by c.subject_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit; 
        return $query->result_array();
    }
    function insert_marks_master_june20($stud)
    {
    	
    $DB1 = $this->load->database('umsdb', TRUE);		
	//$data['enrollment_no']=$stud['enrollment_no'];
	$data['exam_id']=$stud['exam_id'];
	$data['stream_id']=$stud['stream_id'];
	$data['semester']=$stud['semester'];
	$data['marks_entry_date']=date('Y-m-d');
	$data['division']=$stud['division'];
	$data['batch_no']=$stud['batch_no'];
	$data['subject_id']=$stud['subject_id'];
	$data['subject_code']=$stud['subject_code'];
	$data['marks_type']='TH';
	$data['max_marks']=$stud['theory_max'];
	//$data['reval_marks']=$stud['reval_marks'];
	$data['exam_month']=$stud['exam_month'];
	$data['exam_year']=$stud['exam_year'];
	//$data['entry_ip']=$stud['entry_ip'];
	$data['entry_by']=2;
	$data['entry_on']=date('Y-m-d H:i:s');
	//echo "<pre>";print_r($data);exit;
	$DB1->insert('marks_entry_master', $data);
	//echo $DB1->last_query();
	//exit;
        return true;
    }
	function check_marks_entered_theory_master($subject_id,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT me_id FROM marks_entry_master WHERE exam_id=$exam_id AND marks_type='TH' AND `subject_id` ='".$subject_id."' limit 0, 1";//exit;
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function check_marks_entered_practical_master($subject_id,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT me_id FROM marks_entry_master WHERE exam_id=$exam_id AND marks_type='PR' AND `subject_id` ='".$subject_id."' limit 0, 1";//exit;
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function check_marks_entered_pract_1($subject_id,$exam_id,$enrollment_no)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT stud_id FROM marks_entry WHERE exam_id=$exam_id AND marks_type='PR' AND `subject_id` ='".$subject_id."' and enrollment_no='".$enrollment_no."' limit 0, 1";//exit;
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function upload_exceldata_for_marks_entry($data){
		//print_r($data);exit;
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->insert('marks_entry',$data);
		//echo $DB1->last_query();exit;
		return true;
	}	
	function get_studsubjectdetails($subject_code, $prn,$ex_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `exam_applied_subjects` WHERE  exam_id='$ex_id' and enrollment_no='$prn' and subject_code='$subject_code'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit; 
        return $query->result_array();
    }
		function check_marks_entered_theory_1($subject_id,$exam_id,$enrollment_no)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT stud_id FROM marks_entry WHERE exam_id=$exam_id AND marks_type='TH' AND `subject_id` ='".$subject_id."' and enrollment_no='".$enrollment_no."' limit 0, 1";//exit;
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function deletmrksentrytheory($exam_id,$me_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="DELETE FROM marks_entry WHERE exam_id=$exam_id AND me_id='$me_id' and marks_type='TH'";//exit;
        $query = $DB1->query($sql);
		$sql1="DELETE FROM marks_entry_master WHERE exam_id=$exam_id AND me_id='$me_id' and marks_type='TH'";//exit;
        $query = $DB1->query($sql1);
		return true;
	}
	///////////////////////
	function subject_allocation_manually_student_list()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT enrollment_no,stud_id,admission_stream,current_semester,academic_year from student_master where enrollment_no in(180101061048)";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit; 
        return $query->result_array();
    }
	function check_duplicate_subject_allocation($stud,$subject_id)
    {
		$stud_id=$stud['stud_id'];
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT subject_id FROM student_applied_subject WHERE stud_id=$stud_id AND `subject_id` ='".$subject_id."' limit 0, 1";//exit;
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function insert_subject_allocation_manually($stud,$subject_id)
    {
    	
    $DB1 = $this->load->database('umsdb', TRUE);		
	//$data['enrollment_no']=$stud['enrollment_no'];
	$data['stud_id']=$stud['stud_id'];
	$data['stream_id']=9;//$stud['admission_stream'];
	$data['semester']=1;
	$data['academic_year']=$stud['academic_year'].'-21';
	$data['subject_id']=$subject_id;
	//$data['subject_code']=$stud['subject_code'];

	//$data['entry_ip']=$stud['entry_ip'];
	$data['entry_by']=2;
	$data['entry_on']=date('Y-m-d H:i:s');
	//echo "<pre>";print_r($data);exit;
	$DB1->insert('student_applied_subject', $data);
	//echo $DB1->last_query();
	//exit;
        return true;
    }
	
	
	 function fetch_ist_streams(){

 
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT distinct(stream_id) FROM exam_result_data WHERE exam_id in (24,25,26,27)";//exit;
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function check_marks_enteredmaster_th($subject_id,$exam_id,$stream_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT me_id FROM marks_entry_master WHERE exam_id=$exam_id AND marks_type='TH' and stream_id='".$stream_id."' AND `subject_id` ='".$subject_id."' limit 0, 1";//exit;
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
	function check_bundle_marks_enteredmaster_th($subject_id,$exam_id,$stream_id, $bundle_no)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT me_id FROM marks_entry_master WHERE exam_id=$exam_id AND marks_type='TH' and stream_id='".$stream_id."' AND `subject_id` ='".$subject_id."' AND bundle_no = '".$bundle_no."' limit 0, 1";//exit;
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
	function check_marks_enteredmaster_pr($subject_id,$marks_type,$exam_id,$batch_no,$division)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT me_id FROM marks_entry_master WHERE exam_id=$exam_id AND marks_type='PR' AND `subject_id` ='".$subject_id."'  AND `division` ='".$division."' AND `batch_no` ='".$batch_no."' limit 0, 1";//exit;
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
	function fetch_exam_allsession_for_topper()
    {       
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM exam_session where exam_year = 2022 and exam_type = 'Regular'  and deleted ='N'";     
        $query = $DB1->query($sql);    
        //echo $DB1->last_query();exit;       
        return $query->result_array();
        
    }
	public function get_marks_entry($subject_id, $exam_id, $marks_type,$streamId) {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->where('subject_id', $subject_id);
        $DB1->where('exam_id', $exam_id);
        $DB1->where('stream_id', $streamId);
		 $DB1->where('marks_type', $marks_type);
        $query = $DB1->get('marks_entry_master');
		
		// echo $DB1->last_query();exit;
        return $query->row_array();
    }
	
		public function getBundleNumbers($subjectId, $exam_id, $stream, $semester)
	{
		$DB1 = $this->load->database('umsdb', TRUE);

		$DB1->select('bundle_no');
		$DB1->from('exam_applied_subjects');
		$DB1->where('subject_id', $subjectId);
		$DB1->where('exam_id', $exam_id);
		$DB1->where('semester', $semester);
		$DB1->where('stream_id', $stream);
		
		$DB1->where('bundle_no IS NOT NULL', null, false);
		$DB1->where('bundle_no !=', '');
		$DB1->distinct();
		$query = $DB1->get();
		//	echo $DB1->last_query();exit;
		return $query->result_array();
	}
	public function checkEntryExists($bundle_no)
	{
		$DB1 = $this->load->database('umsdb', TRUE);

		$DB1->select('*');
		$DB1->where('bundle_no', $bundle_no);
		$query = $DB1->get('marks_entry_master');

		//	echo $DB1->last_query();exit;
		// Check if the record exists
		if ($query->num_rows() > 0) {
			return $query->row_array(); // Return the row with me_id
		} else {
			return null; // Return null if not found
		}
	}
	function getSubjectStudentList($bundle_no, $subject_id, $stream_id, $exam_month, $exam_year, $exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);

		$sql = "SELECT sas.stud_id,s.is_detained, sas.enrollment_no, sas.subject_id,UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as stud_name,
				s.admission_stream,eb.exam_attendance_status as is_absent,sas.malpractice,eb.ans_bklet_no,sas.barcode
		FROM `exam_applied_subjects` as sas 
		left join exam_details ed on ed.exam_id=sas.exam_id and ed.enrollment_no=sas.enrollment_no
		left join subject_master sm on sm.sub_id=sas.subject_id 
		left join student_master s on s.stud_id=sas.stud_id 
		left join exam_ans_booklet_attendance eb on eb.student_id=sas.stud_id and eb.exam_id=sas.exam_id and eb.subject_id=sas.subject_id
		where sas.bundle_no='" . $bundle_no . "' and sas.subject_id='" . $subject_id . "' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' and sm.is_active='Y' and sas.allow_for_exam='Y'  ";
		$sql .= " group by sas.stud_id order by sas.enrollment_no";
		$query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function download_marks_details_all($me_id = '', $exam_id, $subdetails)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$sub_id = $subdetails[0];
		$stream_id = $subdetails[3];
		$semester = $subdetails[4];
		$marks_type = $subdetails[6];
		$division = $subdetails[7];
		$batch = $subdetails[8];

		// print_r($subdetails);;exit;
		if($stream_id !=''){
			$where = " and m.stream_id='$stream_id' ";
		}else{
			$where = "";
		}

		if($semester !=''){
			$where .= " and m.semester='$semester' ";
		}
		if($marks_type !=''){
			$where .= " and m.marks_type='$marks_type' ";
		}
		if($me_id != 'none'){
			$where .= " and m.me_id='" . $me_id . "'";
		}
		//print_r($subdetails);exit;
		$sql = "SELECT m.*, s.first_name,s.last_name, s.middle_name,eb.exam_attendance_status as is_absent,eb.ans_bklet_no,eas.barcode,eas.bundle_no
		FROM marks_entry m 
		left join student_master s on s.enrollment_no=m.enrollment_no
        left join exam_ans_booklet_attendance eb on eb.student_id=m.stud_id and eb.exam_id=m.exam_id and eb.subject_id=m.subject_id
		left join exam_applied_subjects eas on eas.enrollment_no = m.enrollment_no and eas.stud_id = m.stud_id and eas.subject_id = m.subject_id and eas.exam_id = m.exam_id
		where  m.exam_id='$exam_id' and m.subject_id = '$sub_id' $where  order by m.enrollment_no";
		$query = $DB1->query($sql);

		// echo $DB1->last_query();exit;

		return $query->result_array();

	}	
	
	function get_marks_entry_status_for_subject($subject_id,$semester,$stream_id,$exam_id)
	{
		$exam = explode('-', $exam_id);
        $exam_month = $exam[0];
        $exam_year = $exam[1];
        $exam_id = $exam[2];
			
		$DB1 = $this->load->database('umsdb', TRUE);
		
		$DB1->select("
			SUM(CASE WHEN entry_status IN ('Entered', 'Verified') THEN 1 ELSE 0 END) AS completed_count,
			SUM(CASE WHEN entry_status NOT IN ('Entered', 'Verified') OR entry_status IS NULL THEN 1 ELSE 0 END) AS pending_count
		");
		$DB1->from('marks_entry_master');
		$DB1->where('subject_id', $subject_id);
		$DB1->where('semester', $semester);
		$DB1->where('stream_id', $stream_id);
		$DB1->where('exam_id', $exam_id);
		$DB1->where('marks_type', 'TH');
		
		$query = $DB1->get();
		// echo $DB1->last_query(); echo '<br>';
		$result = $query->row_array();
		
		// Get distinct bundle count from exam_applied_subjects
		$DB1->select('COUNT(DISTINCT bundle_no) AS total_bundles');
		$DB1->from('exam_applied_subjects');
		$DB1->where('subject_id', $subject_id);
		$DB1->where('semester', $semester);
		$DB1->where('stream_id', $stream_id);
		$DB1->where('exam_id', $exam_id);
		$query1 = $DB1->get();
		// echo $DB1->last_query();
		$bundle_result = $query1->row_array();
		// Combine both results
		return array_merge($result, $bundle_result);
		
	}
	function get_all_labs()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("h.id, h.lab_name, h.capacity, h.hall_no, b.building_name");
		$DB1->from("hall_master h");
		$DB1->join("building_master b", "b.id = h.building_id", "left");
		$DB1->where("h.hall_type", "lab");
		$query = $DB1->get();
		$result = $query->result_array();
		// echo $DB1->last_query();
		return $result;
	}
	
	public function get_all_schools() {
		$DB1 = $this->load->database('umsdb', TRUE);
        return $DB1->where('active_for_year', '2026')
					->group_by('school_id')
					->get('vw_stream_details')
					->result_array();
    }

    public function get_courses_by_school($school_code) {
		$DB1 = $this->load->database('umsdb', TRUE);
        return $DB1->where('school_code', $school_code)
				   ->where('is_active', 'Y')
				   ->where('active_for_year', '2026')
				   ->group_by('course_id')
				   ->get('vw_stream_details')
				   ->result_array();
    }

    public function get_all_remunerations() {
		$DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select('r.*, v.school_short_name, v.course_name');
        $DB1->from('pr_remuneration_master r');
        $DB1->join('vw_stream_details v', 'r.course_id = v.course_id AND r.school_code = v.school_code', 'left');
        $DB1->group_by('r.course_id');
        $query = $DB1->get();
		// echo $DB1->last_query();exit;
		return $query->result_array();
    }

    public function insert_remuneration($data) {
		$DB1 = $this->load->database('umsdb', TRUE);
        unset($data['id']);
        $DB1->insert('pr_remuneration_master', $data);
    }

    public function update_remuneration($id, $data) {
		$DB1 = $this->load->database('umsdb', TRUE);
        unset($data['id']);
        $DB1->where('id', $id)->update('pr_remuneration_master', $data);
    }

    public function get_remuneration($id) {
		$DB1 = $this->load->database('umsdb', TRUE);
        return $DB1->where('id', $id)->get('pr_remuneration_master')->row_array();
    }

	 public function get_unique_external_faculty($school,$exam)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		
        $exam_sess = explode('-', $exam);
        $exam_month = $exam_sess[0];
        $exam_year = $exam_sess[1];
        $exam_id = $exam_sess[2];
		
		$DB1->select('
            ext.ext_faculty_code,
            ext.ext_fac_name,
            ext.ext_fac_designation,
            ext.ext_fac_mobile,
            ext.ext_fac_email,
            ext.ext_fac_institute,
            a.exam_id,
            ext.letter_verified,
            ext.letter_sent
        ');
        $DB1->from('exam_practical_subjects_faculty_assign a');
        $DB1->join('exam_external_faculty_master ext', 'ext.ext_faculty_code = a.ext_faculty_code', 'left');
        $DB1->join('vw_stream_details v', 'v.stream_id = a.stream_id', 'inner');
        $DB1->where('a.is_active', 'Y');
        $DB1->where('v.school_code', $school);
        $DB1->where('a.exam_id', $exam_id);
        
        $DB1->where("ext.ext_faculty_code != ''");
        $DB1->group_by('ext.ext_faculty_code');
        $DB1->order_by('ext.ext_fac_name', 'ASC');
        
        $q = $DB1->get();
		// echo '<pre>';
		// echo $DB1->last_query(); exit;
		return $q->result_array();
	}


    // mark verified flag and record who/when
    public function mark_letter_verified($exam_pract_fact_id, $user_id) {
		$DB1 = $this->load->database('umsdb', TRUE);
		
        $data = [
            'letter_verified' => 'Y',
            'verified_by' => $user_id,
            'verified_on' => date('Y-m-d H:i:s')
        ];
        $DB1->where('ext_faculty_code', $exam_pract_fact_id);
        return $DB1->update('exam_external_faculty_master', $data);
    }

    // mark sent flag
    public function mark_letter_sent($exam_pract_fact_id, $user_id) {
		$DB1 = $this->load->database('umsdb', TRUE);
		
        $data = [
            'letter_sent' => 'Y',
            'sent_by' => $user_id,
            'sent_on' => date('Y-m-d H:i:s')
        ];
        $DB1->where('ext_faculty_code', $exam_pract_fact_id);
        return $DB1->update('exam_external_faculty_master', $data);
    }

	public function get_assignment($exam_pract_fact_id,$exam_id) {
		$DB1 = $this->load->database('umsdb', TRUE);

		$DB1->select("
			a.*, 
			ext.ext_fac_name, 
			ext.ext_fac_designation, 
			ext.ext_fac_mobile, 
			ext.ext_fac_email,
			ext.letter_verified,
			ext.ext_fac_institute, 
			hm.lab_name, 
			hm.hall_no, 
			hm.capacity,
			v.stream_short_name,
			sm.subject_name,

			-- regular strength
			(SELECT COUNT(DISTINCT sm.enrollment_no) 
				FROM student_batch_allocation sba
				LEFT JOIN student_applied_subject sas 
					ON sas.stud_id = sba.student_id AND sas.stream_id = sba.stream_id
				LEFT JOIN student_master sm 
					ON sm.stud_id = sas.stud_id
				WHERE sm.cancelled_admission = 'N'
				  AND sas.subject_id = a.subject_id
				  AND sas.stream_id = a.stream_id
				  AND sba.semester = a.semester
				  AND sba.division = a.division
				  AND sba.batch = a.batch_no
				  AND sba.academic_year = '".ACADEMIC_YEAR."'
			) AS regular_strength
		");

		$DB1->from('exam_practical_subjects_faculty_assign a');
		$DB1->join('exam_external_faculty_master ext', 'ext.ext_faculty_code = a.ext_faculty_code', 'left');
		$DB1->join('hall_master hm', 'hm.id = a.lab_id', 'left');
		$DB1->join('subject_master sm', 'sm.sub_id = a.subject_id', 'left');
		$DB1->join('vw_stream_details v', 'v.stream_id = a.stream_id', 'inner');
		$DB1->where('a.ext_faculty_code', $exam_pract_fact_id);
		$DB1->where('a.exam_id', $exam_id);
		$DB1->where('a.is_active', 'Y');
		$DB1->group_by('a.ext_faculty_code,a.subject_id,a.division,a.batch_no');
		$DB1->order_by('a.exam_date,a.inserted_on');
		
		
		$q = $DB1->get();
		// echo $DB1->last_query(); exit;
		return $q->result_array();
	}

	
	public function generate_order_no($ext_faculty_code,$school)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$month = date('M');
		$year  = date('Y');

		// Get current order_serial for this faculty
		$DB1->select('order_serial');
		$DB1->from('exam_external_faculty_master');
		$DB1->order_by('order_serial', 'DESC');
		$DB1->limit('1');
		$row = $DB1->get()->row_array();

		$next_serial = isset($row['order_serial']) && $row['order_serial'] ? ($row['order_serial'] + 1) : 1;

		// Update the same record with the new serial
		$DB1->where('ext_faculty_code', $ext_faculty_code);
		$DB1->update('exam_external_faculty_master', ['order_serial' => $next_serial]);

		// Build formatted order number
		return "SUN/COE/PRACTICALS/{$month}{$year}/{$school}/" . str_pad($next_serial, 3, '0', STR_PAD_LEFT);
	}

	public function fetch_user_contact($user_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);

		// Get current order_serial for this faculty
		$DB1->select('mobile_no');
		$DB1->from('sandipun_erp.user_master');
		$DB1->where('username', $user_id);
		$DB1->where('status', 'Y');
		$query = $DB1->get();
		// echo $DB1->last_query(); exit;
		$row = $query->row_array();
		
		return $row;
	}

	public function get_claim_details($subject_id, $stream_id, $semester, $division, $batch_no, $exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);

		$sql = "
		SELECT sm.subject_type, sm.batch, t.batch_no, t.division, sm.stream_id, sm.semester, 
			   sm.subject_name, sm.subject_code AS subject_code, sm.sub_id AS subject_id,
			   sm.course_id, sm.subject_component, 
			   em.fname, em.mname, em.lname, em.designation_name,
			   ldsm.designation_name AS lab_designation_name, eml.fname AS lab_fname,
			   eml.mname AS lab_mname, eml.lname AS lab_lname,
			   dsm.designation_name AS peon_designation_name,
			   hem.fname AS peon_fname, hem.mname AS peon_mname, hem.lname AS peon_lname,
			   sd.stream_name, sd.school_short_name, 
			   ext.ext_fac_name, ext.ext_fac_designation, ext.ext_fac_institute,ext.distance_km as distance,
			   f.exam_pract_fact_id, f.exam_date, f.exam_from_time, f.exam_to_time, f.time_format,
			   f.capacity, f.lab_name, f.hall_no, f.subject_category,f.ext_faculty_code
		FROM lecture_time_table t
		LEFT JOIN (
			SELECT exam_pract_fact_id, subject_id, semester, stream_id, faculty_code, ext_faculty_code, 
				   lab_assistant, peon, exam_date, exam_from_time, exam_to_time, lab_id, subject_category, 
				   time_format, hm.capacity, hm.lab_name, hm.hall_no, subject_type
			FROM exam_practical_subjects_faculty_assign
			LEFT JOIN hall_master hm ON hm.id = exam_practical_subjects_faculty_assign.lab_id
			WHERE is_active='Y'
			  AND division = '$division' 
			  AND batch_no = '$batch_no' 
			  AND subject_id = '$subject_id'
			  AND exam_id = '$exam_id'
		) f ON f.subject_id = t.subject_code
		LEFT JOIN subject_master sm ON sm.sub_id = t.subject_code
		LEFT JOIN vw_faculty em ON em.emp_id = f.faculty_code
		LEFT JOIN hrms.employee_master eml ON eml.emp_id = f.lab_assistant
		LEFT JOIN hrms.designation_master ldsm ON ldsm.designation_id = eml.designation
		LEFT JOIN hrms.employee_master hem ON hem.emp_id = f.peon
		LEFT JOIN hrms.designation_master dsm ON dsm.designation_id = hem.designation
		LEFT JOIN exam_external_faculty_master ext ON ext.ext_faculty_code = f.ext_faculty_code
		LEFT JOIN vw_stream_details sd ON sd.stream_id = t.stream_id
		WHERE t.stream_id = '$stream_id' 
		  AND t.semester = '$semester'
		  AND t.subject_code = '$subject_id'
		  AND t.division = '$division'
		  AND t.batch_no = '$batch_no'
		GROUP BY sm.sub_id
		";

		$query = $DB1->query($sql);
		// echo '<pre>';
		// echo $DB1->last_query();exit;
		return $query->row_array();
	}
	function fetch_marks_entry_details($subId = '', $streamId = '', $semester = '', $division = '', $batch = '', $exam_id = '')
	{
		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql = "
			SELECT 
				COUNT(*) AS total_strength,
				SUM(CASE WHEN TRIM(UPPER(sba.marks)) = 'AB' THEN 1 ELSE 0 END) AS absent_count,
				SUM(CASE WHEN TRIM(UPPER(sba.marks)) != 'AB' 
						 AND sba.marks IS NOT NULL 
						 AND sba.marks != '' THEN 1 ELSE 0 END) AS present_count
			FROM marks_entry AS sba
			# LEFT JOIN student_applied_subject sas  ON sas.stud_id = sba.stud_id  AND sas.stream_id = sba.stream_id  AND sas.is_active = 'Y'
			# LEFT JOIN student_master sm ON sm.stud_id = sas.stud_id
			WHERE  sba.subject_id = '$subId'
			  AND sba.stream_id = '$streamId'
			  AND sba.semester = '$semester'
			  AND sba.division = '$division'
			  AND sba.batch_no = '$batch'
			  AND sba.exam_id = '$exam_id'
		";

		$query = $DB1->query($sql);
		// echo $DB1->last_query(); exit; // Uncomment for debugging
		return $query->row_array(); // returns one row with total, absent, present
	}
	function fetch_renum_rates($streamId = '',$subject_category = '')
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		 if($subject_category == 'viva'){
			 $subject_category = 'viva_voce';
		 } 
		$sql = "
			SELECT 
				prm.$subject_category as factor , prm.*
			FROM pr_remuneration_master AS prm
			LEFT JOIN vw_stream_details vw ON vw.course_id = prm.course_id and vw.school_code = prm.school_code
			WHERE 
			   vw.stream_id = '$streamId'
		";

		$query = $DB1->query($sql);
		// echo $DB1->last_query(); exit; // Uncomment for debugging
		return $query->row_array(); // returns one row with total, absent, present
	}

	public function get_ta_da_status1($ext_code, $exam_id)
	{

		$DB1 = $this->load->database('umsdb', TRUE);

		$sql = "SELECT exam_pract_fact_id, exam_date
				FROM exam_practical_subjects_faculty_assign
				WHERE ext_faculty_code = ?
				  AND exam_id = ?
				  AND is_active = 'Y'
				ORDER BY exam_date,inserted_on ASC";

		$rows = $DB1->query($sql, [$ext_code, $exam_id])->result_array();
		//print_r($rows);exit;
		if (empty($rows)) {
			return [];
		}

		$result = [];
		$previous_date = null;
		
		foreach ($rows as $r) {

			// Handle empty dates safely
			if (empty($r['exam_date'])) {
				continue;
			}

			$parts = explode('/', $r['exam_date']);
				if (count($parts) == 3) {
					$current_date = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
				} else {
					continue;
				}
			$fact_id      = $r['exam_pract_fact_id'];
			

			
			// ----------- CHECK CONTINUITY OF DATES (TA LOGIC) ----------
			if ($previous_date === null) {

				// FIRST DATE → ALWAYS TA
				$is_ta = true;

			} else {

				// difference in days
				$diff = (strtotime($current_date) - strtotime($previous_date)) / 86400;
			// echo $previous_date;
			// echo '<br>';
			// echo '%'.$current_date;exit;
				// If date difference > 1 → Not continuous → TA again
				$is_ta = ($diff > 1);
			}

			// Store result
			$result[$fact_id] = [
				'exam_date' => $current_date,
				'allow_ta'  => $is_ta,
				'allow_da'  => true  // DA is always allowed per date
			];
			
			// Update previous date
			$previous_date = $current_date;

		}
		// print_r($result);exit;
		return $result;
	}
public function get_ta_da_status($ext_code, $exam_id)
{
    $DB1 = $this->load->database('umsdb', TRUE);

    $sql = "SELECT exam_pract_fact_id, exam_date
            FROM exam_practical_subjects_faculty_assign
            WHERE ext_faculty_code = ?
              AND exam_id = ?
              AND is_active = 'Y'
            ORDER BY STR_TO_DATE(exam_date, '%d/%m/%Y'),inserted_on ASC";

    $rows = $DB1->query($sql, [$ext_code, $exam_id])->result_array();

    if (empty($rows)) return [];

    $result = [];
    $previous_date = null;
    $used_da_dates = []; // store which dates already have DA

    foreach ($rows as $r) {

        if (empty($r['exam_date'])) continue;

        // Convert DD/MM/YYYY → YYYY-MM-DD
        $parts = explode('/', $r['exam_date']);
        if (count($parts) != 3) continue;

        $current_date = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        $fact_id = $r['exam_pract_fact_id'];

        // ---------------- TA LOGIC ----------------
        if ($previous_date === null) {
            $is_ta = true; // first date always gets TA
        } else {
            $diff = (strtotime($current_date) - strtotime($previous_date)) / 86400;
            $is_ta = ($diff > 1); // if gap > 1 day OR new cluster → TA again
        }

        // ---------------- DA LOGIC ----------------
        if (!isset($used_da_dates[$current_date])) {
            // First entry of this date → DA allowed
            $is_da = true;
            $used_da_dates[$current_date] = true;
        } else {
            // This date already used → DA not allowed
            $is_da = false;
        }

        // Save result
        $result[$fact_id] = [
            'exam_date' => $current_date,
            'allow_ta'  => $is_ta,
            'allow_da'  => $is_da
        ];

        // Update last date
        $previous_date = $current_date;
    }

    return $result;
}


}
?>