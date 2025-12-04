<?php
class Lessonplan_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$DB1 = $this->load->database('umsdb', TRUE);
	}
	// fetch subject timetable for date calculation
	function fetch_subject_timetable($subject_id,$emp_id, $academic_year,$academic_session,$stream_id,$semester,$division)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		if($academic_session=='SUMMER'){
			$ses = 'SUM';
		}else{
			$ses = 'WIN';
		}
        $sql="SELECT wday FROM `lecture_time_table` WHERE `academic_year`='$academic_year' AND `academic_session`='$ses' AND subject_code='$subject_id' AND stream_id='$stream_id' AND semester='$semester' AND division='$division' and faculty_code='$emp_id' AND subject_type !='PR'
GROUP BY wday";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	//faculty subjects for plan
	function getFacultySubjects_for_markattendance($emp_id, $curr_session,$academic_year){
        $DB1 = $this->load->database('umsdb', TRUE);
		if($curr_session=='WINTER'){
			$cursession ='WIN';
		}else{
			$cursession ='SUM';
		}
		$empStreamid =$this->getFacultyStream($emp_id);
        $sql = "select distinct t.subject_code as subject_id, t.batch_no as batch,t.division, s.subject_code as sub_code,s.subject_short_name,vw.stream_short_name,s.semester,t.stream_id from lecture_time_table as t 
        left join subject_master s on s.sub_id = t.subject_code 
		left join vw_stream_details vw on vw.stream_id = t.stream_id
		where t.faculty_code='".$emp_id."' and s.is_active='Y' and t.subject_type !='PR'";
		if(!empty($empStreamid) && $empStreamid!='71'){
				$sql .=" AND t.academic_session='".$cursession."' AND t.academic_year='".$academic_year."'";
			}
			$sql .=" order by t.division,t.batch_no";
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();exit;
		return $sub_details;
    }
	// fetch Faculty Stream
	function getFacultyStream($emp_id){
		$DB1 = $this->load->database('umsdb', TRUE);	
        $sql = "SELECT distinct stream_id FROM `lecture_time_table` WHERE `faculty_code` = '".$emp_id."'";		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res[0]['stream_id'];
	}

	function load_subtopics($data)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $subject_id = $data['subject_id'];
		$subdet = explode('.', $data['topic_no']);
		$unit_no = $subdet[0];
		$topic_no = $subdet[1];
		$sql="SELECT unit_no,topic_no,subtopic_no,topic_contents FROM `subject_syllabus` WHERE `subject_id` = '".$subject_id."'  and unit_no='".$unit_no."' and topic_no='".$topic_no."' and subtopic_no !=0 group by subtopic_no order by subtopic_no asc";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $stream_details =  $query->result_array();  
    } 
	function add_lplan($data){


		
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sub = explode('~', $data['sub_details']);
		$subject_id= $sub[0];
		$stream_id= $sub[1];
		$semester= $sub[2];
		$division= $sub[3];
		$batch= $sub[4];


		$academic_year = explode('~', $data['academic_year']);
		

		$faculty_id = $this->session->userdata("name");
		$emp_id = $this->session->userdata("uid");

		if($academic_year[1]=='WINTER'){
			$academic_session='WIN';
		}else{
			$academic_session='SUM';
		}

	/*	if(!in_array('Other', $data['subtopic_no'])){
			$insert_arr['is_from_syllabus'] ='Y';
			$insert_arr['covered_topics'] =$covered_topics;
			$insert_arr['subtopic_no'] =$covered_topics;
		}else{
			$insert_arr['is_from_syllabus'] ='N';
			$insert_arr['covered_topics'] =$data['topic_contents'];
			$insert_arr['subtopic_no'] =$data['topic_contents'];
		}*/

		$data_topics =explode('.',$data['topic_no']);
		$topicname = $data_topics[2];
		//$covered_topicsarray=array();
		//$subtopic_noarray=array();

		//print_r($data['subtopic_no']);
		if(count($data['subtopic_no'])>0)
		{

				for($i=0;$i<=count($data['subtopic_no']);$i++)
				{


					

                   if($i==0){
					   
					   
                     	$parents=0;
						$subtopic=0;
					//$exdata=explode("_",$data['subtopic_no'][$i]);
					$unit_no=$data_topics[0];
					$topic=$data_topics[1];
					//$subtopic=$exdata[2];
                     }else{
					$exdata=explode("_",$data['subtopic_no'][$i-1]);
					$unit_no=$exdata[0];
					$topic=$exdata[1];
					$subtopic=$exdata[2];
						 
                     	$parents=$topic;
						$subtopic=$subtopic;
						
						
                     }
					$insert_arr = array(
					'subject_id'=> $subject_id,
					'academic_year'=> $academic_year[0],
					'lecture_no'=> $data['lecture_no'],
					'planned_date'=> $data['planned_date'],
					'faculty_id'=> $faculty_id,
					
					'unit_no'=> $unit_no,
					'topic_no'=> $topic,
					'subtopic_id'=>$subtopic,
					'parents'=>$parents,

					'topic_name'=>$topicname,
					'sun'=> $data['sun'],
					'gate'=> $data['gate'],
					'umpsc'=> $data['umpsc'],
					'pedagogical'=> $data['pedagogical'],
					'ex_wgt_other'=> $data['ex_wgt_other'],
					'rm'=> $data['rm'],
					'us'=> $data['us'],
					'ay'=> $data['ay'],
					'an'=> $data['an'],
					'academic_session'=> $academic_session,
					'stream_id'=> $stream_id,
					'semester'=> $semester,
					'division'=> $division,
					'batch'=> $batch,	
					'entry_by'=> $emp_id,
					'entry_on'=> date('Y-m-d H:i:s'),
					'remark'=> $data['remark'],
					'is_active'=>'Y'
					);
		
					$DB1->insert('lecture_plan_details', $insert_arr);
				}

		}
	
	
		unset($data);
		return true;
		//echo $DB1->last_query();exit;
	}
	// fetch subject lesson plan
	function fetch_subject_lessonplan($subject_id='',$academic_year='')
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$faculty_id = $this->session->userdata("name");
		$sql="SELECT lpd.*,ss.topic_contents,ss.subtopic_no FROM `lecture_plan_details` as lpd

         
        inner join subject_syllabus as ss ON ss.subject_id=lpd.subject_id 
		AND ss.unit_no=lpd.unit_no and ss.topic_no=lpd.topic_no and ss.subtopic_no=lpd.subtopic_id 
    
    inner join (select planned_date from lecture_plan_details group by planned_date) as pldate on pldate.planned_date=lpd.planned_date
		 WHERE lpd.`subject_id` = '".$subject_id."' and lpd.faculty_id='".$faculty_id."' and lpd.academic_year='".$academic_year."'

		  group by lpd.entry_on, lpd.unit_no, lpd.topic_no,lpd.subtopic_id,lpd.planned_date ";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();  
    }
    // fetch Faculty Stream
	function fetch_subject_syllabus($subject_id){
		$DB1 = $this->load->database('umsdb', TRUE);	
        $sql = "SELECT unit_no,topic_name,topic_no FROM `subject_syllabus` WHERE `subject_id` = '".$subject_id."' group by unit_no,topic_no order by unit_no,topic_no asc";		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}
    // fetch subject lesson plan
	function fetch_subject_lessonplan123($subject_id,$academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$faculty_id = $this->session->userdata("name");
		$sql="SELECT lpd.*,ss.topic_name, GROUP_CONCAT(ss.topic_contents SEPARATOR '^') as subtopic FROM `lecture_plan_details` as lpd join subject_syllabus as ss on ss.subject_id=lpd.subject_id and ss.unit_no=lpd.unit_no and ss.topic_no=lpd.topic_no   WHERE `lpd.subject_id` = '".$subject_id."' and lpd.faculty_id='".$faculty_id."' and lpd.academic_year='".$academic_year."' order by lpd.unit_no,planned_date asc";
        $query = $DB1->query($sql);
		echo $DB1->last_query();exit;
		return $query->result_array();  
    }
    function delete_lecture_plan_details($id)
    {
    	 $DB1 = $this->load->database('umsdb', TRUE); 
    	 $DB1->where('lecture_plan_id', $id);
    	$DB1->delete('lecture_plan_details');

    }

   /* // fetch lessionplan details
	function  get_lession_details($subject_id){
		 $DB1 = $this->load->database('umsdb', TRUE); 
		$faculty_id = $this->session->userdata("name");
		$sql="SELECT * FROM `lecture_plan_details` WHERE `subject_id` = '".$subject_id."' and faculty_id='".$faculty_id."' order by unit_no asc";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array(); 
	}*/
	///////////////////////////////////////////////////////////////////////////////////////
	
	public function Syllabus_Covered_view($academicyear,$semesterNo,$streamID,$sub_code,$division,$batch_no,$faculty_code){
		$academic_year = explode('~', $academicyear);
		if($academic_year[1]=='WINTER'){
			$insert_arr='WIN';
		}else{
			$insert_arr='SUM';
		}
		
		 $DB1 = $this->load->database('umsdb', TRUE); 
		$faculty_id = $this->session->userdata("name");
		$sql="SELECT GROUP_CONCAT(lpd.topic_covered) AS coverd,ss.*,lpd.* FROM lecture_syllabus_covered as lpd  
		left join subject_syllabus as ss ON ss.syllabus_id=lpd.topic_covered  
		WHERE 
		lpd.academic_year = '".$academic_year[0]."' AND lpd.academic_session='".$insert_arr."' AND lpd.stream_id='".$streamID."'
	AND	lpd.semester = '".$semesterNo."' AND lpd.division='".$division."' AND lpd.batch='".$batch_no."' 
	AND lpd.subject_id='".$sub_code."'
	AND lpd.faculty_id='".$faculty_code."'
	GROUP BY lpd.unit_no,lpd.topic_no,lpd.attendance_date

	order by lpd.id asc";
        $query = $DB1->query($sql);
	//	echo $DB1->last_query();exit;
		return $query->result_array();  
	}
	public function maintopicshow($subject_id,$unit_no,$topic_no,$coverd){
		
		
		  
		 $DB1 = $this->load->database('umsdb', TRUE); 
		 $coverd=explode(',',$coverd);
		// $acount=count($coverd);//2
		 $i=0;
		 foreach($coverd as $co){
			 if(!empty($co)){
			//if($i<$acount)	 
			 $new[]="'".$co."'";
			 }
		 }
     $news=  implode(',',$new);	   
	  // print_r($news);exit;
		$faculty_id = $this->session->userdata("name");
		$sql="SELECT news.topic_name,topic_contents FROM subject_syllabus as ss  
		LEFT JOIN (SELECT sk.syllabus_id,sk.topic_name,sk.topic_no FROM subject_syllabus AS sk WHERE sk.subject_id = '".$subject_id."'
AND sk.unit_no='".$unit_no."' AND sk.topic_no='".$topic_no."' AND sk.subtopic_no='0' ) AS news ON news.topic_no=ss.topic_no
		WHERE 
		ss.subject_id = '".$subject_id."' AND ss.unit_no='".$unit_no."' AND ss.topic_no='".$topic_no."' AND 
		 ss.syllabus_id IN ($news);

		";//AND ss.subtopic_no='0'
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();  
	}


}