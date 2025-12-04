<?php
class Erp_cron_attendance_model extends CI_Model 
{
    function __construct()
    {        
        parent::__construct();     
       // $this->currentModule=$this->uri->segment(1);        
    } 
    
    
    
   //to get session
    function getsession()
    {
         $DB1 = $this->load->database('umsdb', TRUE);
         $sql ="SELECT academic_year,academic_session FROM academic_session where currently_active='Y'";
         $query=$DB1->query($sql);
         $result=$query->result_array();
    
        return $result;
    }
    function get_school_list(){
         $DB1 = $this->load->database('umsdb', TRUE);
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		 $this->load->model('Subject_model');
        $sql = "SELECT s.school_code,s.school_name,s.school_short_name from school_master s left join vw_stream_details v on v.school_code=s.school_code where s.is_active='Y' "; 
		
		
			if(isset($role_id) && $role_id==20 || $role_id==21 || $role_id==3){
			 $empsch = $this->Subject_model->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 if(!empty($schid)){
			 $sql .=" AND s.school_code = $schid";
			 }
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND s.school_code = $sccode";
		}
		$sql .=" group by s.school_code";
		//echo $sql;
              $query=$DB1->query($sql);
         $result=$query->result_array();
    
        return $result;
    }
    function get_course_list_byschool($schid){
    $DB1 = $this->load->database('umsdb', TRUE);
    $sql = "SELECT distinct c.course_id,c.course_name,c.course_short_name from vw_stream_details v inner join course_master c on c.course_id= v.course_id where  v.school_code='".$schid."' and v.is_active='Y' "; 
                $query=$DB1->query($sql);
         $result=$query->result_array();
    
        return $result;
                
}
function get_stream_list($cr_id,$sch_cod){
     $DB1 = $this->load->database('umsdb', TRUE);
    $sql = "SELECT stream_name,stream_short_name,stream_id from vw_stream_details where is_active='Y' and course_id='".$cr_id."' AND school_code='".$sch_cod."' order by stream_name ASC "; 
                $query=$DB1->query($sql);
         $result=$query->result_array();
    
        return $result;            
}
function get_semister($strm,$ayear,$cur_ses){
   $DB1 = $this->load->database('umsdb', TRUE);
     $sql = "SELECT distinct semester from lecture_time_table where stream_id='".$strm."' and academic_year ='".$ayear."' and academic_session='".$cur_ses."' order by semester asc";
       $query=$DB1->query($sql);
         $result=$query->result_array();    
        return $result;         
}
function get_division($strm,$semester,$ayear,$cur_ses){
 $DB1 = $this->load->database('umsdb', TRUE);
 $sql = "select distinct division from lecture_time_table  where stream_id='".$strm."' and academic_year ='".$ayear."' and academic_session='".$cur_ses."' and semester='".$semester."' order by division asc";
 $query=$DB1->query($sql);
         $result=$query->result_array();    
        return $result; 
}
function get_student_faculty_data($ayear,$cur_ses,$day,$strmval,$semval,$divval){
    $DB1 = $this->load->database('umsdb', TRUE);
 $sql = "select t.faculty_code,t.subject_code,s.subject_name,s.subject_code as sub_code, t.division,t.batch_no, t.subject_type,lecture_slot,wday,slt.from_time,slt.to_time,slt.slot_am_pm, f.fname,f.mname,f.lname,f.mobile_no, t.faculty_code,vw.school_name, vw.stream_name from lecture_time_table t 
left join lecture_slot slt on slt.lect_slot_id = t.lecture_slot 
left join vw_faculty f on f.emp_id = t.faculty_code 
left join vw_stream_details vw on vw.stream_id =t.stream_id 
left join subject_master s on s.sub_id = t.subject_code
where  t.academic_year='".$ayear."' and t.academic_session='".$cur_ses."' and t.wday='".$day."' and t.stream_id='".$strmval."' and t.semester='".$semval."' and t.division='".$divval."'  order by slt.from_time asc,t.batch_no asc";

$query=$DB1->query($sql);
         $result=$query->result_array();    
        return $result; 

}

function get_student_attendance_data($ayear,$cur_ses,$day,$strmval,$semval,$divval,$slot){
   $DB1 = $this->load->database('umsdb', TRUE);
  $sql =  "SELECT l.faculty_code,l.subject_id,l.attendance_date,l.slot,l.is_present,sba.roll_no,f.fname,f.mname,f.mobile_no,f.staff_type,f.photo_path,f.lname,sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,vw.stream_name FROM `lecture_attendance` l 
        left join student_batch_allocation sba on sba.student_id = l.student_id and sba.academic_year = l.academic_year 
        left join vw_faculty f on f.emp_id = l.faculty_code
        LEFT JOIN student_master sm on sm.stud_id = l.student_id
        LEFT JOIN vw_stream_details vw on vw.stream_id =l.stream_id
where l.academic_year='".$ayear."' and l.academic_session='".$cur_ses."' and attendance_date='".$day."' and l.stream_id='".$strmval."' and l.semester='".$semval."' and l.division='".$divval."' and l.slot='".$slot."'";
   
$query=$DB1->query($sql);
         $result=$query->result_array();    
        return $result; 
}
function get_student_attendance_data_pre($ayear,$cur_ses,$day,$strmval,$semval,$divval,$slot){
   $DB1 = $this->load->database('umsdb', TRUE);
   $sql =  "SELECT SUM(CASE WHEN l.is_present='Y' THEN 1 ELSE 0 END) AS tpresent,
SUM(CASE WHEN l.is_present='N' THEN 1 ELSE 0 END) AS tapsent,
ROUND(((SUM(CASE WHEN l.is_present='Y' THEN 1 ELSE 0 END)/(SUM(CASE WHEN l.is_present='Y' THEN 1 ELSE 0 END)+SUM(CASE WHEN l.is_present='N' THEN 1 ELSE 0 END)))*100),2) AS percen_lecturs,l.faculty_code,l.subject_id,l.attendance_date,l.slot,l.is_present,f.fname,f.mname,f.lname FROM lecture_attendance l 
        inner join vw_faculty f on f.emp_id = l.faculty_code
where l.academic_year='".$ayear."' and l.academic_session='".$cur_ses."' and attendance_date='".$day."' and l.stream_id='".$strmval."' and l.semester='".$semval."' and l.division='".$divval."' and l.slot='".$slot."' having tpresent is not null";
   
$query=$DB1->query($sql);
         //echo $query->num_rows(); exit;
        // if($query->num_rows()>0){
            $result = $query->result_array();  
         //}else{
         //   $result='0';
         //}
        return $result; 
}
function get_student_faculty_data_f($ayear,$cur_ses,$day,$strmval,$semval,$divval){
    $DB1 = $this->load->database('umsdb', TRUE);
 $sql = "select t.faculty_code,t.subject_code,s.subject_name,s.subject_code as sub_code, t.division,t.batch_no, t.subject_type,lecture_slot,wday,slt.from_time,slt.to_time,slt.slot_am_pm, f.fname,f.mname,f.lname,f.mobile_no, t.faculty_code,vw.school_name, vw.stream_name from lecture_time_table t 
left join lecture_slot slt on slt.lect_slot_id = t.lecture_slot 
left join vw_faculty f on f.emp_id = t.faculty_code 
left join vw_stream_details vw on vw.stream_id =t.stream_id 
left join subject_master s on s.sub_id = t.subject_code
where t.faculty_code is not null  and t.academic_year='".$ayear."' and t.academic_session='".$cur_ses."' and t.wday='".$day."' and t.stream_id='".$strmval."' and t.semester='".$semval."' and t.division='".$divval."'  order by slt.from_time asc,t.batch_no asc";
echo "</br>";
$query=$DB1->query($sql);
         $result=$query->result_array();    
        return $result; 

}
	//to get all school details
     function getsschool_details()
    {
         $DB1 = $this->load->database('umsdb', TRUE);
         $sql ="SELECT school_code,school_name,umas.email,GROUP_CONCAT(stream_id) AS stream FROM vw_stream_details INNER JOIN  (SELECT roles_id,email, SUBSTRING(username,7) AS b FROM  user_master ) AS umas  ON umas.b=vw_stream_details.school_code WHERE umas.roles_id='10' GROUP BY school_code";
         $query=$DB1->query($sql);
         $result=$query->result_array();
    
        return $result;
    }



    function TimetableEntryReport($student_academicy,$acadyear,$get_session)
    {
            $DB1 = $this->load->database('umsdb', TRUE);
            $sql ="SELECT a.*,t.stream_id,t.semester,v.stream_name,v.school_code,
            (CASE WHEN t.stream_id=admission_stream THEN 'Done' ELSE 'Not done' END) AS entry_status 
            FROM (SELECT DISTINCT admission_stream,current_semester FROM student_master 
            WHERE `cancelled_admission`='N' AND academic_year='".$student_academicy."' ORDER BY admission_stream,current_semester) as a 
            LEFT JOIN (SELECT DISTINCT stream_id,semester FROM `lecture_time_table` WHERE `academic_year`='".$acadyear."' AND `academic_session`='".$get_session."' ) as t 
            ON t.`stream_id`=a.admission_stream
            AND t.semester=a.current_semester 
            LEFT JOIN vw_stream_details v ON v.stream_id=a.admission_stream 
            HAVING entry_status = 'Not done' ORDER BY v.stream_name,a.current_semester";
            $query=$DB1->query($sql);
            $result=$query->result_array();
            return $result;
    }
    function get_dates($Date1,$Date2){
        

// Declare two dates 
//$Date1 = '01-10-2010'; 
//$Date2 = '05-10-2010'; 

// Declare an empty array 
$array = array(); 

// Use strtotime function 
$Variable1 = strtotime($Date1); 
$Variable2 = strtotime($Date2); 

// Use for loop to store dates into array 
// 86400 sec = 24 hrs = 60*60*24 = 1 day 
for ($currentDate = $Variable1; $currentDate <= $Variable2; 
                                $currentDate += (86400)) { 
                                    
$Store = date('Y-m-d', $currentDate); 
$array[] = $Store; 
} 

// Display the dates in array format 
return $array; 


    }
      function get_faculty_lecture_list($data){
        //print_r($data);
        $DB1 = $this->load->database('umsdb', TRUE);
        if($data['sch_id']!=''){
 $sch = " AND vw.school_code='".$data['sch_id']."' ";
}
if($data['curs']!=''){
 $crs = " AND l.course_id='".$data['curs']."' ";
}
if($data['strm']!=''){
 $strm = " AND l.stream_id='".$data['strm']."' ";
}
if($data['fctl']!=''){
 $fac = " AND l.faculty_code='".$data['fctl']."' ";
}
if($data['divis']!=''){
 $div = " AND l.division='".$data['divis']."' ";
}
if($data['fdt']!='' && $data['tdt']!=''){
    //echo $data['fdt']; echo $data['tdt'];
    $darr = $this->get_dates($data['fdt'],$data['tdt']);
//print_r($darr);
foreach($darr as $val){
    $dday = date('l',strtotime($val));
$wd[] = "'".$dday."'";
}
$wd= implode(',',$wd);
$wd = ' AND l.wday IN('.$wd.')';
}
    $sql="select l.`course_id`,l.`stream_id`,l.`semester`,l.`division`,l.lecture_slot,l.faculty_code,vf.fname,vf.lname,l.`wday` from lecture_time_table l 
  inner join vw_faculty vf on l.faculty_code=vf.emp_id 
inner JOIN vw_stream_details vw ON vw.stream_id =l.stream_id 
 where l.is_active='Y' and l.academic_year='".$this->config->item('current_year')."' and l.academic_session='".$this->config->item('current_sess')."' $sch  $crs  $strm $wd $fac group by l.faculty_code ORDER BY l.faculty_code,l.`course_id`,l.`stream_id`,l.`semester`,l.`division`,FIELD(l.wday, 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY') ASC 
    ";

   $query=$DB1->query($sql);
         $result=$query->result_array();
    
        return $result;

    }

    function get_faculty_lecturs_fact_code($faculty_code,$fdt,$tdt){
$DB1 = $this->load->database('umsdb', TRUE);
if($fdt!='' && $tdt!=''){
    //echo $data['fdt']; echo $data['tdt'];
    $darr = $this->get_dates($fdt,$tdt);
//print_r($darr);
foreach($darr as $val){
    $dday = date('l',strtotime($val));
$wd[] = "'".$dday."'";
}
$wd= implode(',',$wd);
$wd = ' AND l.wday IN('.$wd.')';
}
  $sql="SELECT l.`course_id`,l.`stream_id`,l.`semester`,l.`division`,vf.staff_type,vw.school_name,vw.school_short_name,vw.course_name,vw.stream_name,s.subject_code as sub_code,s.subject_name,s.subject_short_name,l.lecture_slot,l.subject_code,l.faculty_code,vf.fname,vf.lname,ls.from_time,ls.to_time,ls.slot_am_pm,l.wday,l.subject_type,s.subject_short_name FROM lecture_time_table l 
INNER JOIN lecture_slot ls ON l.lecture_slot=ls.lect_slot_id 
INNER JOIN vw_faculty vf ON l.faculty_code=vf.emp_id 
INNER JOIN vw_stream_details vw ON l.stream_id=vw.stream_id 
inner JOIN subject_master s ON l.subject_code=s.sub_id 
WHERE l.`academic_session`='WIN' AND l.`academic_year`='2019-20' AND l.is_active='Y' And l.faculty_code='$faculty_code' $wd ORDER BY FIELD(l.wday, 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'),l.`course_id`,l.`stream_id`,l.`semester`,l.`division`,ls.`from_time` DESC";
$query=$DB1->query($sql);
         $result=$query->result_array();
    
        return $result;

    }
   function check_leave($fact,$dt){
$sql="select lid,emp_id,applied_from_date,applied_to_date,leave_duration,CASE WHEN l.leave_type ='official' THEN 'OD' ELSE CASE WHEN l.leave_type ='LWP' THEN 'LWP' ELSE ea.leave_type END  END AS leave_name FROM leave_applicant_list l LEFT JOIN employee_leave_allocation ea ON l.`leave_type`=ea.`id` WHERE emp_id='".$fact."' and fstatus = 'Approved' and month(applied_from_date)='".date('m',strtotime($dt))."' and YEAR(applied_from_date)='".date('Y',strtotime($dt))."' ";
$query=$this->db->query($sql);
         $result=$query->result_array();
         $ldate=[];
         $cnt = count($result);
         if($cnt>0){
    foreach ($result as $key => $value) {
        if($value['leave_duration']=='full-day'){
            $s='Full Day';
        }else{
            $s='Half Day';
        }
        if(date('Y-m-d',strtotime($value['applied_from_date']))!=date('Y-m-d',strtotime($value['applied_to_date']))){
        $darr = $this->get_dates($value['applied_from_date'],$data['applied_to_date']);

        $l= $value['leave_name']."(".$s.")";
        foreach($darr as $dv){
         $ldate[$l][]  = date('Y-m-d',strtotime($dv));
        }
        }else{
            $l= $value['leave_name']."(".$s.")";
 $ldate[$l][]  = date('Y-m-d',strtotime($value['applied_from_date'])); 


        }
    }
//print_r($ldate);
    foreach ($ldate as $key1 => $value1) {
        
        if(in_array(date('Y-m-d',strtotime($dt)), $value1)){
            return $lev = $key1;
        }else{
            $lev= 'N';
        }
        
    }
}else{
    $lev = 'N';
}
     return $lev;
    }
    function check_holidays($date,$typ){
    
       $d = date('d',strtotime($date));
       $m = date('m',strtotime($date));
       $y = date('Y',strtotime($date));
        if($typ=='1' || $typ=='3'){
           $ap = ' and (applicable_for = "Teaching+Technical" OR applicable_for = "All")';
       }elseif($typ=='2'){
            $ap = ' and (applicable_for = "Non-Teaching" OR applicable_for = "All")';
       }else{
           $ap = '';
       }
        $sql="SELECT * FROM holiday_list_master WHERE status='Y' and day(hdate) = '$d' and month(hdate)='$m' and year(hdate)='$y' ".$ap;     
       $query=$this->db->query($sql);
         $value=$query->result_array();
       
         if(count($value)==0){$flag="false";}else{
             if($value['is_relax_day']=='Y'){
                 $flag = 'RD';
             }else{
             $flag="true";
             }
         } 
         return $flag;      
}
/////////////////////////////////
 function get_attendance_list($acad_year='',$cur_sess='',$day='',$sch_id='',$rtyp=''){

$wd='';$ayw='';$sch='';	
$ayw=" and t.academic_year='".$acad_year."' AND t.academic_session='".$cur_sess."' ";
$sch = " AND vw.school_code='".$sch_id."' ";
$wd = " AND t.wday IN('".$day."')";

if($rtyp=='m'){
	$f = " and t.faculty_code is not null and  t.faculty_code !=''";
}
$DB1 = $this->load->database('umsdb', TRUE);
 $sql="SELECT vw.school_name,vw.course_name,t.semester,t.faculty_code,t.subject_code,s.subject_code as sub_code, s.subject_name,t.division,t.batch_no, t.subject_type,lecture_slot,wday,slt.from_time,slt.to_time,slt.slot_am_pm, f.fname, f.mname,f.lname,f.mobile_no, t.faculty_code,f.staff_type,vw.school_name, vw.stream_name,t.stream_id FROM lecture_time_table t 
LEFT JOIN lecture_slot slt ON slt.lect_slot_id = t.lecture_slot 
LEFT JOIN vw_faculty f ON f.emp_id = t.faculty_code 
LEFT JOIN vw_stream_details vw ON vw.stream_id =t.stream_id 
LEFT JOIN subject_master s ON s.sub_id = t.subject_code
WHERE t.is_active='Y' $ayw $sch $wd $f and t.subject_code !='Library' order by vw.course_id,vw.stream_id,t.semester,t.division,FIELD(t.wday, 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'),slt.from_time ASC";
//echo $sql;exit;
 $query=$DB1->query($sql);
 $result=$query->result_array();    
return $result; 
}

  function get_faculty_lecture_list1($acad_year='',$cur_sess='',$day='',$sch_id=''){

$DB1 = $this->load->database('umsdb', TRUE);
$wd='';$ayw='';$sch='';	
$ayw=" and l.academic_year='".$acad_year."' AND l.academic_session='".$cur_sess."' ";
$sch = " AND vw.school_code='".$sch_id."' ";
$wd = " AND l.wday IN('".$day."')";
     $sql="select l.`course_id`,l.`stream_id`,l.`semester`,l.`division`,l.lecture_slot,l.faculty_code, vf.fname, vf.lname,l.`wday`, vw.school_name from lecture_time_table l inner join vw_faculty vf on l.faculty_code=vf.emp_id 
inner JOIN vw_stream_details vw ON vw.stream_id =l.stream_id where l.is_active='Y' $ayw $sch $wd  group by l.faculty_code ORDER BY l.faculty_code,l.`course_id`,l.`stream_id`,l.`semester`,l.`division`,l.wday ASC ";

    $query=$DB1->query($sql);
	$result=$query->result_array();
	return $result;
    
}

/**
     * $report_date: 'YYYY-MM-DD'
     * $acad_year_sched: e.g. '2025-26'   (lecture_time_table / attendance_master)
     * $acad_year_students: e.g. 2025     (student_master)
     * $campus_id: optional, pass null to include all; else filter timetable by campus
     */
   public function get_attendance_summary($report_date, $acad_year_sched, $acad_year_students, $campus = null)
{
    // ✅ Map campus codes to DB connection names
    $campusDbMap = [
        1 => 'umsdb',
        2 => 'sjumsdb',
        3 => 'sfumsdb',
        4 => 'puneumsdb',
        // add more campuses here
    ];

    // ✅ Choose DB based on campus, fallback to umsdb
    $dbGroup = isset($campusDbMap[$campus]) ? $campusDbMap[$campus] : 'umsdb';
    $DB1 = $this->load->database($dbGroup, TRUE);
	//log_message('error', "Using DB group: " . $dbGroup . " for campus " . $campus);
    $sql = "
SELECT
    v.school_short_name   AS School,
    v.course_short_name   AS Course,
    v.stream_name         AS Stream,
    l.semester            AS Year,
    st.Strength,
    COUNT(DISTINCT l.time_table_id) AS No_of_lecture_assigned,
    COUNT(DISTINCT CASE WHEN a.attendance_id IS NOT NULL THEN l.time_table_id END) AS No_of_lecture_taken,
    ROUND((SUM(IFNULL(a.present_count,0)) / NULLIF(SUM(IFNULL(a.total_students,0)),0)) * 100, 2) AS PresentPercentage,
    ROUND((SUM(IFNULL(a.absent_count,0))  / NULLIF(SUM(IFNULL(a.total_students,0)),0)) * 100, 2) AS AbsentPercentage
FROM lecture_time_table l
JOIN vw_stream_details v
    ON v.stream_id = l.stream_id
LEFT JOIN (
    SELECT
        CASE
            WHEN s.current_semester IN (1,2)
             AND s.admission_stream IN (5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279) THEN 9
            WHEN s.current_semester IN (1,2)
             AND s.admission_stream IN (184,185,26,27,28) THEN 234
            ELSE s.admission_stream
        END AS mapped_stream_id,
        s.current_semester AS semester,
        COUNT(*) AS Strength
    FROM student_master s
    WHERE s.academic_year = ?
      AND s.enrollment_no <> ''
      AND s.cancelled_admission = 'N'
    GROUP BY mapped_stream_id, s.current_semester
) st
    ON st.mapped_stream_id = l.stream_id
   AND st.semester        = l.semester
LEFT JOIN attendance_master a
    ON a.stream_id     = l.stream_id
   AND a.semester      = l.semester
   AND a.division      = l.division
   AND a.batch         = l.batch_no
   AND a.slot          = l.lecture_slot
   AND a.subject_id    = l.subject_code
   AND a.academic_year = ?
   AND a.attendance_date = ?
WHERE l.academic_year = ?
  AND l.wday = DAYNAME(?)
GROUP BY v.school_short_name, v.course_short_name, v.stream_name, l.semester, st.Strength
ORDER BY v.school_short_name, v.course_short_name, v.stream_name,l.semester asc;
    ";

    $finalParams = [
        $acad_year_students,    // for strength subquery
        $acad_year_sched,       // attendance join AY
        $report_date,           // attendance join date
        $acad_year_sched,       // outer WHERE timetable AY
        $report_date            // outer WHERE DAYNAME
    ];

    $query = $DB1->query($sql, $finalParams);
	//echo $DB1->last_query();exit;
    return $query->result_array();
}

}