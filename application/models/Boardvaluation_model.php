<?php
class Boardvaluation_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  fetch_board()
    {
       $DB1=$this->load->database('umsdb',true);
        
        $sql="select evaluation_board FROM subject_master group by evaluation_board";
        $query = $DB1->query($sql);
        return $query->result_array();
    } 
	
	function list_Boardvaluation($data,$exam_month,$exam_year,$exam_id){
		//print_r($data);  
		$DB1=$this->load->database('umsdb',true);
		$whe='';
		if($data['board_date']!=''){
		$whe="AND DATE(ett.date)='".$data['board_date']."'";
		}
		
		if($data['board_code']=="All"){
			 /*$sql="SELECT sm.`evaluation_board`,sm.`semester`,sm.sub_id,sm.subject_code AS couser_code,sm.`subject_name`,ett.exam_month,ett.exam_id,ett.date,ett.from_time,COALESCE(r.necount, 0) AS Total,COALESCE(eps.ascount, 0) AS aTotal
			  FROM subject_master AS sm
INNER JOIN exam_result_data AS erd ON erd.subject_id=sm.sub_id
INNER JOIN exam_time_table AS ett ON ett.subject_id=sm.sub_id
LEFT JOIN (SELECT COUNT(stud_id) AS ascount,subject_code,subject_id FROM exam_applied_subjects WHERE `exam_id`='".$exam_id."' GROUP BY subject_id ) AS eps
ON eps.subject_id=sm.`sub_id`
LEFT JOIN (SELECT COUNT(student_id) AS necount,subject_code,subject_id FROM exam_result_data WHERE `exam_id`='".$exam_id."' GROUP BY subject_id ) AS r
ON r.subject_id=sm.`sub_id`
WHERE ett.`exam_id`='".$exam_id."'
GROUP BY sm.sub_id,ett.exam_id ORDER BY sm.`evaluation_board`";*/
	 $sql="SELECT sm.`batch`,sm.`evaluation_board`,vw.`stream_short_name`,sm.`semester`,sm.subject_code AS couser_code,sm.`subject_name`,ett.exam_month,ett.exam_id,ett.date,ett.from_time,
COALESCE(r.necount, 0) AS Appear,COALESCE(eps.ascount, 0) AS Applied,eas.subject_id
FROM exam_applied_subjects AS eas
INNER JOIN subject_master AS sm ON sm.`sub_id`=eas.subject_id
INNER JOIN `vw_stream_details` AS vw ON vw.`stream_id`=eas.stream_id

LEFT JOIN exam_result_data AS erd ON erd.subject_id=sm.sub_id AND erd.`exam_id`=eas.exam_id
LEFT JOIN exam_time_table AS ett ON ett.subject_id=sm.sub_id AND ett.`exam_id`=eas.exam_id
#INNER JOIN `exam_applied_subjects` AS eps ON eps.subject_code=sm.subject_code
LEFT JOIN (SELECT COUNT(stud_id) AS ascount,subject_id FROM exam_applied_subjects WHERE `exam_id`='".$exam_id."' GROUP BY subject_id ) AS eps
ON eps.subject_id=sm.`sub_id`
LEFT JOIN (SELECT COUNT(`student_id`) AS necount,subject_id 
FROM `exam_ans_booklet_attendance` WHERE `exam_id`='".$exam_id."' AND `exam_attendance_status`='P'  GROUP BY subject_id ) AS r
ON r.subject_id=sm.`sub_id`
WHERE  eas.`exam_id`='".$exam_id."' AND eas.allow_for_exam!='N'
and sm.subject_component !='PR'
 $whe
GROUP BY sm.sub_id,ett.exam_id order by sm.`batch`,sm.`semester`,sm.`evaluation_board` ASC";	
	
			}else{
		/* $sql="SELECT sm.`evaluation_board`,sm.`semester`,sm.sub_id,sm.subject_code AS couser_code,sm.`subject_name`,ett.exam_month,ett.exam_id,ett.date,ett.from_time,COALESCE(r.necount, 0) AS Total,COALESCE(eps.ascount, 0) AS aTotal
		  FROM subject_master AS sm
INNER JOIN exam_result_data AS erd ON erd.subject_id=sm.sub_id
INNER JOIN exam_time_table AS ett ON ett.subject_id=sm.sub_id
LEFT JOIN (SELECT COUNT(stud_id) AS ascount,subject_code,subject_id FROM exam_applied_subjects WHERE `exam_id`='".$exam_id."' GROUP BY subject_id ) AS eps
ON eps.subject_id=sm.`sub_id`
LEFT JOIN (SELECT COUNT(student_id) AS necount,subject_code,subject_id FROM exam_result_data WHERE `exam_id`='".$exam_id."' GROUP BY subject_id ) AS r
ON r.subject_id=sm.`sub_id`
WHERE sm.`evaluation_board`='".$data['board_code']."' AND ett.`exam_id`='".$exam_id."'
GROUP BY sm.sub_id,ett.exam_id";*/
$sql="SELECT sm.`batch`,sm.`evaluation_board`,vw.`stream_short_name`,sm.`semester`,sm.subject_code AS couser_code,sm.`subject_name`,ett.exam_month,ett.exam_id,ett.date,ett.from_time,
COALESCE(r.necount, 0) AS Appear,COALESCE(eps.ascount, 0) AS Applied,eas.subject_id
FROM exam_applied_subjects AS eas
INNER JOIN subject_master AS sm ON sm.`sub_id`=eas.subject_id
INNER JOIN `vw_stream_details` AS vw ON vw.`stream_id`=eas.stream_id

LEFT JOIN exam_result_data AS erd ON erd.subject_id=sm.sub_id AND erd.`exam_id`=eas.exam_id
LEFT JOIN exam_time_table AS ett ON ett.subject_id=sm.sub_id AND ett.`exam_id`=eas.exam_id
#INNER JOIN `exam_applied_subjects` AS eps ON eps.subject_code=sm.subject_code
LEFT JOIN (SELECT COUNT(stud_id) AS ascount,subject_id,stream_id FROM exam_applied_subjects WHERE `exam_id`='".$exam_id."' GROUP BY subject_id,stream_id  ) AS eps
ON eps.subject_id=sm.`sub_id` and eps.stream_id=eas.stream_id
LEFT JOIN (SELECT COUNT(`student_id`) AS necount,subject_id,stream_id 
FROM `exam_ans_booklet_attendance` WHERE `exam_id`='".$exam_id."' AND `exam_attendance_status`='P'  GROUP BY subject_id,stream_id ) AS r
ON r.subject_id=sm.`sub_id` and r.stream_id=eas.stream_id
WHERE sm.`evaluation_board`='".$data['board_code']."' AND eas.`exam_id`='".$exam_id."' AND eas.allow_for_exam!='N'  $whe and sm.subject_component !='PR'
GROUP BY sm.sub_id,eas.stream_id,ett.exam_id order by sm.`batch`,sm.`semester` ASC";
		}
//echo $sql;exit;
$query = $DB1->query($sql);
//echo $DB->last_query();
//exit();
        return $query->result_array();
	}
	
	function list_Boardvaluation_all($data,$board_date,$exam_month,$exam_year,$exam_id){
		$DB1=$this->load->database('umsdb',true);
		//echo $data.'--'.$board_date;
		$whe='';
		if($board_date!=''){
		 $whe="AND DATE(ett.date)='".$board_date."'";
		}
		//exit();
		/*$sql="SELECT sm.`evaluation_board`,sm.`semester`,sm.sub_id,sm.subject_code AS couser_code,sm.`subject_name`,ett.exam_month,ett.exam_id,ett.date,ett.from_time,COALESCE(r.necount, 0) AS Total,COALESCE(eps.ascount, 0) AS aTotal
		 FROM subject_master AS sm
INNER JOIN exam_result_data AS erd ON erd.subject_id=sm.sub_id
INNER JOIN exam_time_table AS ett ON ett.subject_id=sm.sub_id
LEFT JOIN (SELECT COUNT(stud_id) AS ascount,subject_code,subject_id FROM exam_applied_subjects WHERE `exam_id`='".$exam_id."' GROUP BY subject_id ) AS eps
ON eps.subject_id=sm.`sub_id`
LEFT JOIN (SELECT COUNT(student_id) AS necount,subject_code,subject_id FROM exam_result_data WHERE `exam_id`='".$exam_id."' GROUP BY subject_id ) AS r
ON r.subject_id=sm.`sub_id`
WHERE sm.`evaluation_board`='".$data."' AND ett.`exam_id`='".$exam_id."'
GROUP BY sm.sub_id,ett.exam_id";*/

 $sql="SELECT sm.`batch`,sm.`evaluation_board`,vw.`stream_short_name`,sm.`semester`,sm.subject_code AS couser_code,sm.`subject_name`,ett.exam_month,ett.exam_id,ett.date,ett.from_time,
COALESCE(r.necount, 0) AS Appear,COALESCE(eps.ascount, 0) AS Applied,eas.subject_id
FROM exam_applied_subjects AS eas
INNER JOIN subject_master AS sm ON sm.`sub_id`=eas.subject_id
INNER JOIN `vw_stream_details` AS vw ON vw.`stream_id`=eas.stream_id

LEFT JOIN exam_result_data AS erd ON erd.subject_id=sm.sub_id AND erd.`exam_id`=eas.exam_id
LEFT JOIN exam_time_table AS ett ON ett.subject_id=sm.sub_id AND ett.`exam_id`=eas.exam_id
#INNER JOIN `exam_applied_subjects` AS eps ON eps.subject_code=sm.subject_code
LEFT JOIN (SELECT COUNT(stud_id) AS ascount,subject_id FROM exam_applied_subjects WHERE `exam_id`='".$exam_id."' GROUP BY subject_id ) AS eps
ON eps.subject_id=sm.`sub_id`
LEFT JOIN (SELECT COUNT(`student_id`) AS necount,subject_id 
FROM `exam_ans_booklet_attendance` WHERE `exam_id`='".$exam_id."' AND `exam_attendance_status`='P'  GROUP BY subject_id ) AS r
ON r.subject_id=sm.`sub_id`
WHERE sm.`evaluation_board`='".$data."' AND eas.`exam_id`='".$exam_id."' AND eas.allow_for_exam!='N' $whe
GROUP BY sm.sub_id,ett.exam_id order by sm.`batch`,sm.`semester` ASC";
//echo '<br>';
$query = $DB1->query($sql);
//if($query){
 return $query->result_array();
//}
	}
	
	
	
	
	
	function list_Boardvaluation_group($data,$exam_month,$exam_year,$exam_id){
		$DB1=$this->load->database('umsdb',true);
		$whe='';
		if($data['board_date']!=''){
		 $whe="AND DATE(ett.date)='".$data['board_date']."'";
		}
		//exit();
		/* $sql="SELECT sm.`evaluation_board`,sm.`semester`,sm.subject_code AS couser_code,sm.`subject_name`,ett.exam_month,ett.exam_id,ett.date,ett.from_time,COALESCE(r.necount, 0) AS Total,COALESCE(eps.ascount, 0) AS aTotal 
		 FROM subject_master AS sm
INNER JOIN exam_result_data AS erd ON erd.subject_id=sm.sub_id
INNER JOIN exam_time_table AS ett ON ett.subject_id=sm.sub_id
LEFT JOIN (SELECT COUNT(stud_id) AS ascount,subject_code,subject_id FROM exam_applied_subjects WHERE `exam_id`='".$exam_id."' GROUP BY subject_id ) AS eps
ON eps.subject_id=sm.`sub_id`
LEFT JOIN (SELECT COUNT(student_id) AS necount,subject_code,subject_id FROM exam_result_data WHERE `exam_id`='".$exam_id."' GROUP BY subject_id ) AS r
ON r.subject_id=sm.`sub_id`
WHERE ett.`exam_id`='".$exam_id."'
GROUP BY sm.evaluation_board";*/
		
		$sql="SELECT sm.`batch`,sm.`evaluation_board`,vw.`stream_short_name`,sm.`semester`,sm.subject_code AS couser_code,sm.`subject_name`,ett.exam_month,ett.exam_id,ett.date,ett.from_time,
COALESCE(r.necount, 0) AS Appear,COALESCE(eps.ascount, 0) AS Applied,eas.subject_id
FROM exam_applied_subjects AS eas
INNER JOIN subject_master AS sm ON sm.`sub_id`=eas.subject_id
INNER JOIN `vw_stream_details` AS vw ON vw.`stream_id`=eas.stream_id

LEFT JOIN exam_result_data AS erd ON erd.subject_id=sm.sub_id AND erd.`exam_id`=eas.exam_id
LEFT JOIN exam_time_table AS ett ON ett.subject_id=sm.sub_id AND ett.`exam_id`=eas.exam_id
#INNER JOIN `exam_applied_subjects` AS eps ON eps.subject_code=sm.subject_code
LEFT JOIN (SELECT COUNT(stud_id) AS ascount,subject_id FROM exam_applied_subjects WHERE `exam_id`=".$exam_id." GROUP BY subject_id ) AS eps
ON eps.subject_id=sm.`sub_id`
LEFT JOIN (SELECT COUNT(`student_id`) AS necount,subject_id 
FROM `exam_ans_booklet_attendance` WHERE `exam_id`='".$exam_id."' AND `exam_attendance_status`='P'  GROUP BY subject_id) AS r
ON r.subject_id=sm.`sub_id`
WHERE  eas.`exam_id`=".$exam_id." AND eas.allow_for_exam!='N' $whe
GROUP BY sm.sub_id,ett.exam_id order by sm.`batch`,sm.`semester` ASC";
		
		$query = $DB1->query($sql);
        return $query->result_array();
	}
	
	
	
	
function load_date($board_code,$ex_ses){
	 $exam= explode('-', $ex_ses);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];
	$DB1=$this->load->database('umsdb',true);
	$sql="SELECT  date FROM exam_time_table WHERE exam_id='$exam_id' group by date";
	$query=$DB1->query($sql);
	return $query->result_array();
}
	
function get_faculty_names($subject_id){
	$DB1=$this->load->database('umsdb',true);
	$sql="select f.emp_id,concat(f.fname,' ',f.mname,' ', f.lname) as faculty_name,f.mobile_no,t.subject_code from lecture_time_table t
join vw_faculty f on. f.emp_id=t.faculty_code where subject_code=$subject_id  group by emp_id";
	$query=$DB1->query($sql);
	return $query->result_array();
}	
	
	
///////////////////////////////////////////////////////////////////////////////////////////////
	
}