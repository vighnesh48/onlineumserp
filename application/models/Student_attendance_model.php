<?php
class Student_attendance_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		$DB1 = $this->load->database('umsdb', TRUE);
    }
    
	function get_session_date($data){
		 $DB1 = $this->load->database('umsdb', TRUE); 	
		 
		 $sql="SELECT MAX(attendance_date) AS max_date,MIN(attendance_date) AS min_date FROM lecture_attendance WHERE academic_year='".$data['academic_year']."'  AND academic_session='".$data['acd_sess']."' AND attendance_date !='0000-00-00' ";
	  $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();

	}
	// fetch student list
	function get_student_list($data)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		//$empStreamid =$this->getFacultyStream($emp_id);
		//$divw='';
		if($data['strm']!=''){
			$stw=' and la.stream_id="'.$data['strm'].'"';
		}
		if($data['acd_yer']!=''){
			$acd_yr = explode('~',$data['acd_yer']);
			$ayw=' and la.academic_year="'.$acd_yr[0].'" and la.academic_session="'.substr($acd_yr[1], 0,3).'"';//and sba.academic_session="'.substr($acd_yr[1], 0,3).'"

		}
		if($data['sem']!=''){
			$semw=' AND la.semester="'.$data['sem'].'"';
		}
		if($data['divis']!=''){
			$divw=' AND la.division="'.$data['divis'].'"';
		}
		if($data['curs']!=''){
			$crsw=' AND stm.course_id="'.$data['curs'].'"';
		}
		if($data['schid']!=''){
			$schw=' AND stm.school_code="'.$data['schid'].'"';
		}
		if($data['frmper'] !='' && $data['toper'] !=''){
			$ph = ' HAVING percen_lecturs between "'.$data['frmper'].'" and "'.$data['toper'].'" ';
		}
		if($data['fdt']!='' && $data['tdt']!=''){
$dw= " and DATE(la.attendance_date) between '".date('Y-m-d',strtotime($data['fdt']))."' and '".date('Y-m-d',strtotime($data['tdt']))."' ";
}
		$sql1 = "SELECT sm.first_name,sm.enrollment_no,sm.mobile,sm.last_name,sba.academic_year,sba.academic_session,sba.semester,sba.division,v.course_id,sba.stream_id,sba.student_id,v.stream_short_name from student_batch_allocation as sba 
        left join student_master sm on sba.student_id = sm.stud_id
        left join vw_stream_details v on sba.stream_id=v.stream_id 
        where 1 $stw $ayw $semw $divw $crsw group by la.student_id";
			 $sql="SELECT SUM(CASE WHEN la.is_present='Y' THEN 1 ELSE 0 END) AS tpresent,
SUM(CASE WHEN la.is_present='N' THEN 1 ELSE 0 END) AS tapsent,
ROUND(((SUM(CASE WHEN la.is_present='Y' THEN 1 ELSE 0 END)/(SUM(CASE WHEN la.is_present='Y' THEN 1 ELSE 0 END)+SUM(CASE WHEN la.is_present='N' THEN 1 ELSE 0 END)))*100),2) AS percen_lecturs,
la.student_id,la.semester,la.academic_year,la.academic_session,sm.enrollment_no,sm.mobile,la.division,la.batch,la.stream_id,sm.first_name,sm.last_name,stm.stream_short_name
FROM lecture_attendance la 
 #inner join lecture_attendance la ON sba.student_id=la.student_id 
 inner join student_master sm on la.student_id=sm.stud_id
inner join vw_stream_details stm on la.stream_id=stm.stream_id
WHERE  1 $stw $ayw $semw $divw $crsw $dw $schw GROUP BY la.student_id $ph ORDER BY la.stream_id,la.division,percen_lecturs ASC ";

		      $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	// fetch student list
	
	
	function get_student_total_attendance_count($data){
 $DB1 = $this->load->database('umsdb', TRUE); 
 //print_r($data);
 if($data['fdate']=='' && $data['fdate']=='')
{
	$data1['academic_year']=$data['acd_year'];
	$data1['acd_sess']=$data['acd_sess'];
$ay = $this->get_session_date($data1);
$data['fdate']= date('Y-m-d',strtotime($ay[0]['min_date']));
$data['tdate']=date('Y-m-d',strtotime($ay[0]['max_date']));
}
if($data['fdate']!='' && $data['tdate']!=''){
$dw= " and DATE(sba.`attendance_date`) between '".date('Y-m-d',strtotime($data['fdate']))."' and '".date('Y-m-d',strtotime($data['tdate']))."' ";
}
		$sql="SELECT SUM(CASE WHEN sba.`is_present`='Y' THEN 1 ELSE 0 END) AS present_tot,SUM(CASE WHEN sba.`is_present`='N' THEN 1 ELSE 0 END) AS apsent_tot
FROM lecture_attendance AS sba
WHERE  sba.student_id='".$data['stdid']."' and sba.academic_year='".$data['acd_year']."' AND sba.academic_session='".$data['acd_sess']."'  $dw  GROUP BY sba.`student_id` ";
	
  $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();

	}
    	
    	function get_total_lecture($data){
$DB1 = $this->load->database('umsdb', TRUE); 
//print_r($data); //exit();
if($data['fdate']=='' && $data['tdate']=='')
{
$data1['academic_year']=$data['acd_year'];
	$data1['acd_sess']=$data['acd_sess'];
$ay = $this->get_session_date($data1);
$data['fdate']= date('Y-m-d',strtotime($ay[0]['min_date']));
$data['tdate']=date('Y-m-d',strtotime($ay[0]['max_date']));
}
//echo $data['fdate']; echo $data['tdate']; exit;
$darr = $this->get_dates($data['fdate'],$data['tdate']);

foreach($darr as $val){
	$dday = date('l',strtotime($val));
	$ckh= $this->checkHoliday(date('Y-m-d',strtotime($val)));
	//if($dday!='Sunday'){
		if($ckh!='true'){
   		$sql="SELECT count(time_table_id) as total_lec  FROM lecture_time_table 
    		WHERE is_active='Y' and academic_session='".$data['acd_sess']."' AND division='".$data['divs']."' AND academic_year='".$data['acd_year']."' AND wday='".$dday."' AND stream_id='".$data['strm_id']."' AND semester='".$data['sem']."' group by lecture_slot";
    	//echo "<br/>";
 $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
 //$scnt = $query->result_array();
        $cnt[] = $query->num_rows();
    }
//}
    }
return array_sum($cnt);
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
	function featch_absent_student_list(){
		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT SUM(CASE WHEN la.is_present='Y' THEN 1 ELSE 0 END) AS tpresent,
SUM(CASE WHEN la.is_present='N' THEN 1 ELSE 0 END) AS tapsent,
ROUND(((SUM(CASE WHEN la.is_present='Y' THEN 1 ELSE 0 END)/(SUM(CASE WHEN la.is_present='Y' THEN 1 ELSE 0 END)+SUM(CASE WHEN la.is_present='N' THEN 1 ELSE 0 END)))*100),2) AS percen_lecturs,
la.student_id,la.semester,la.academic_year,la.academic_session,sm.enrollment_no,la.division,la.batch,la.stream_id,sm.first_name,sm.last_name,stm.stream_short_name
FROM lecture_attendance la left join student_master sm on la.student_id=sm.stud_id
left join vw_stream_details stm on la.stream_id=stm.stream_id
WHERE  la.academic_session='".$this->config->item('current_sess')."' AND la.academic_year='".$this->config->item('current_year')."' GROUP BY la.student_id   HAVING percen_lecturs < '50.00' ORDER BY la.stream_id,la.division,percen_lecturs ASC ";
	
  $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	 function checkHoliday($holiday){
	    $sql="SELECT * FROM holiday_list_master WHERE hdate = '$holiday' ";	 
        $query=$this->db->query($sql);	
         $value=$query->result_array();
		 if(count($value)==0){$flag="false";}else{ 
		 	if($value[0]['is_relax_day']=='Y'){
$flag="false";
		 	}else{
		 	$flag="true";
		 }
		 } 
		 return $flag;		 
   }
   function fetch_stud_details($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name, stm.course_name,stm.course_short_name,stm.stream_short_name, s.stream_id as strmId, sba.batch,sba.division,stm.course_id");
		$DB1->from('student_master as sm');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('student_applied_subject as sas','sas.stud_id = sm.stud_id','left');
		$DB1->join('subject_master as s','s.sub_id = sas.subject_id','left');
		$DB1->join('student_batch_allocation as sba','sba.batch_id = sas.sub_applied_id','left');
		$DB1->where('enrollment_no', $stud_id);
		$DB1->where('cancelled_admission', 'N');
		$DB1->group_by("s.stream_id");
		$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query(); //exit;
		return $result;
	}	

	function fetchStudAttDates1($enrollment_no,$current_semester,$data) {

        $DB1 = $this->load->database('umsdb', TRUE);
        if($data['fdate']!='' && $data['tdate']!='')
{

$dw=" and l.attendance_date between '".DATE('Y-m-d',strtotime($data['fdate']))."' and '".DATE('Y-m-d',strtotime($data['tdate']))."' ";
}
        $sql = "SELECT distinct l.`attendance_date`, s.stud_id FROM `lecture_attendance` l 
        left join lecture_slot sm on sm.lect_slot_id = l.slot 
        left join student_master s on s.stud_id=l.student_id 
        WHERE s.enrollment_no='".$enrollment_no."' and l.semester='".$current_semester."' $dw order by attendance_date asc";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();//exit;
		return $res;
    }
    function get_course_list($sch){
    	$DB1 = $this->load->database('umsdb', TRUE); 
    	 $sql = "SELECT distinct c.course_id,c.course_name,c.course_short_name from vw_stream_details v inner join course_master c on c.course_id= v.course_id where  v.school_code='".$sch."' and v.is_active='Y' "; 
                $query=$DB1->query($sql);
         $result=$query->result_array();
    
        return $result;
    }

    function get_stream_list($cr_id,$sch_id){
    	$DB1 = $this->load->database('umsdb', TRUE); 
    	$sql = "SELECT stream_name,stream_short_name,stream_id,stream_name from vw_stream_details v join student_master m on m.admission_stream=v.stream_id 		
		where v.is_active='Y' and v.course_id='".$cr_id."' and v.school_code='".$sch_id."' and m.academic_year='".$this->config->item('cyear')."' group by m.admission_stream order by stream_name ASC "; 
           $query=$DB1->query($sql);
         $result=$query->result_array();
    
        return $result;
    }
    function get_semister($strm){
   $DB1 = $this->load->database('umsdb', TRUE);
     $sql = "SELECT distinct semester from lecture_time_table where stream_id='".$strm."' and academic_year ='".$this->config->item('current_year')."' and academic_session='".$this->config->item('current_sess')."' order by semester asc";
       $query=$DB1->query($sql);
         $result=$query->result_array();    
        return $result;         
}
function get_division($sem,$strm){
	$DB1 = $this->load->database('umsdb', TRUE);
 $sql = "select distinct division from lecture_time_table  where stream_id='".$strm."' and academic_year ='".$this->config->item('current_year')."' and academic_session='".$this->config->item('current_sess')."' and semester='".$sem."' order by division asc";
 $query=$DB1->query($sql);
         $result=$query->result_array();    
        return $result; 
}

function get_attendance_list($data){

if($data['acd_yer']!=''){
			$acd_yr = explode('~',$data['acd_yer']);
			
			$ayw=" and t.academic_year='".$acd_yr[0]."' AND t.academic_session='".substr($acd_yr[1], 0,3)."' ";

		}
if($data['sch_id']!=''){
 $sch = " AND vw.school_code='".$data['sch_id']."' ";
}
if($data['curs']!=''){
 $crs = " AND vw.course_id='".$data['curs']."' ";
}
if($data['strm']!=''){
 $strm = " AND vw.stream_id='".$data['strm']."' ";
}
if($data['sem']!=''){
 $sem = " AND t.semester='".$data['sem']."' ";
}
if($data['divis']!=''){
 $div = " AND t.division='".$data['divis']."' ";
}
if($data['fdt']!='' && $data['tdt']!=''){
	//echo $data['fdt']; echo $data['tdt'];
	$darr = $this->get_dates($data['fdt'],$data['tdt']);

foreach($darr as $val){
	$dday = date('l',strtotime($val));
$wd[] = "'".$dday."'";
}
$wd= implode(',',$wd);
$wd = ' AND t.wday IN('.$wd.')';
}
if($data['rtyp']=='m'){
	$f = " and t.faculty_code is not null and  t.faculty_code !=''";
}
$DB1 = $this->load->database('umsdb', TRUE);
 $sql="SELECT vw.school_name,vw.course_name,t.semester,t.faculty_code,t.subject_code,s.subject_code as sub_code,s.subject_name,t.division,t.batch_no, t.subject_type,lecture_slot,wday,slt.from_time,slt.to_time,slt.slot_am_pm, f.fname,f.mname,f.lname,f.mobile_no, t.faculty_code,f.staff_type,vw.school_name, vw.stream_name,t.stream_id FROM lecture_time_table t 
LEFT JOIN lecture_slot slt ON slt.lect_slot_id = t.lecture_slot 
LEFT JOIN vw_faculty f ON f.emp_id = t.faculty_code 
LEFT JOIN vw_stream_details vw ON vw.stream_id =t.stream_id 
LEFT JOIN subject_master s ON s.sub_id = t.subject_code
WHERE t.is_active='Y' $ayw $sch $crs $strm $sem $div $wd $f and t.subject_code !='Library' order by vw.course_id,vw.stream_id,t.semester,t.division,FIELD(t.wday, 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'),slt.from_time ASC";
//echo $sql;exit;
 $query=$DB1->query($sql);
         $result=$query->result_array();    
        return $result; 
}
function get_student_attendance_data($day,$strmval,$semval,$divval,$slot,$faculty_id,$batch_no=''){
   $DB1 = $this->load->database('umsdb', TRUE);
  $sql =  "SELECT l.attendance_date,l.slot,l.is_present FROM `lecture_attendance` l 
        left join student_batch_allocation sba on sba.student_id = l.student_id and sba.academic_year = l.academic_year 
        left join vw_faculty f on f.emp_id = l.faculty_code
        LEFT JOIN student_master sm on sm.stud_id = l.student_id
        LEFT JOIN vw_stream_details vw on vw.stream_id =l.stream_id
where l.academic_year='".$this->config->item('current_year')."' and l.academic_session='".$this->config->item('current_sess')."' and attendance_date='".$day."' and l.stream_id='".$strmval."' and l.semester='".$semval."' and l.division='".$divval."' and l.slot='".$slot."' and l.faculty_code='".$faculty_id."'";
//if($batch_no!=0){
	$sql .=" and l.batch='".$batch_no."'";
//}
   //echo $sql;echo "<br>";exit; 
$query=$DB1->query($sql);
         $result=$query->result_array();    
        return $result; 
}
function get_student_attendance_data_pre($ay='',$cses='',$day='',$strmval='',$semval='',$divval='',$slot='',$faculty_id='',$batch_no=''){
   $DB1 = $this->load->database('umsdb', TRUE);
   
  $sql =  "SELECT SUM(CASE WHEN l.is_present='Y' THEN 1 ELSE 0 END) AS tpresent,
SUM(CASE WHEN l.is_present='N' THEN 1 ELSE 0 END) AS tapsent,
ROUND(((SUM(CASE WHEN l.is_present='Y' THEN 1 ELSE 0 END)/(SUM(CASE WHEN l.is_present='Y' THEN 1 ELSE 0 END)+SUM(CASE WHEN l.is_present='N' THEN 1 ELSE 0 END)))*100),2) AS percen_lecturs,l.faculty_code,l.subject_id,l.attendance_date,l.slot,l.is_present,f.fname,f.mname,f.lname FROM lecture_attendance l 
        inner join vw_faculty f on f.emp_id = l.faculty_code
where l.academic_year='".$ay."' and l.academic_session='".$cses."' and attendance_date='".$day."' and l.stream_id='".$strmval."' and l.semester='".$semval."' and l.division='".$divval."' and l.slot='".$slot."' and l.faculty_code='".$faculty_id."' ";//exit;
//if($batch_no!=0){
	$sql .=" and l.batch='".$batch_no."'";
//}
 $sql .=" having tpresent is not null";  
$query=$DB1->query($sql);
         //echo $query->num_rows(); exit;
        // if($query->num_rows()>0){
            $result = $query->result_array();  
         //}else{
         //   $result='0';
         //}
        return $result; 
}
function get_student_attendance_data_duck($ay,$cses,$day,$strmval,$semval,$divval,$slot,$faculty_id,$batch_no=''){
   $DB1 = $this->load->database('umsdb', TRUE);
   $sql =  "SELECT SUM(CASE WHEN l.is_present='Y' THEN 1 ELSE 0 END) AS tpresent,
SUM(CASE WHEN l.is_present='N' THEN 1 ELSE 0 END) AS tapsent,
ROUND(((SUM(CASE WHEN l.is_present='Y' THEN 1 ELSE 0 END)/(SUM(CASE WHEN l.is_present='Y' THEN 1 ELSE 0 END)+SUM(CASE WHEN l.is_present='N' THEN 1 ELSE 0 END)))*100),2) AS percen_lecturs,l.faculty_code,l.subject_id,l.attendance_date,l.slot,l.is_present,f.fname,f.mname,f.lname FROM lecture_attendance l 
        inner join vw_faculty f on f.emp_id = l.faculty_code
where l.academic_year='".$ay."' and l.academic_session='".$cses."' and attendance_date='".$day."' and l.stream_id='".$strmval."' and l.semester='".$semval."' and l.division='".$divval."' and l.slot='".$slot."'";
$sql .=" and l.batch='".$batch_no."'";
$sql .=" having tpresent is not null"; //echo $sql; exit;
   
$query=$DB1->query($sql);
         //echo $query->num_rows(); exit;
        // if($query->num_rows()>0){
            $result = $query->result_array();  
         //}else{
         //   $result='0';
         //}
        return $result; 
}
function get_school_list(){
         $DB1 = $this->load->database('umsdb', TRUE);
		 $role_id = $this->session->userdata('role_id');
	     $emp_id = $this->session->userdata("name");
		 $this->load->model('Subject_model');
        $sql = "SELECT s.school_code,s.school_name,s.school_short_name from school_master s left join vw_stream_details v on v.school_code=s.school_code where s.is_active='Y' "; 
		
		
		if(isset($role_id) && $role_id==20 || $role_id==21){
			 $empsch = $this->Subject_model->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $sql .=" AND s.school_code = $schid";
		 }else if(isset($role_id) && $role_id==44){
			 $empsch = $this->Subject_model->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 if($emp_id=='662496'){
				 $sql .=" AND s.school_code in(1002,1005,1009,1004)";
			 }else{			 
			 $sql .=" AND s.school_code = $schid";
			 }
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND s.school_code = $sccode";
		}
		$sql .=" group by s.school_code";
              $query=$DB1->query($sql);
			  
         $result=$query->result_array();
    
        return $result;
    }
function get_school_list_for_duck_report(){
         $DB1 = $this->load->database('umsdb', TRUE);
		 $role_id = $this->session->userdata('role_id');
	     $emp_id = $this->session->userdata("name");
		 $this->load->model('Subject_model');
        $sql = "SELECT s.school_id,s.school_code,s.school_name,s.school_short_name from school_master s left join vw_stream_details v on v.school_code=s.school_code where s.is_active='Y'  ";
		
		$sql .=" group by s.school_id";
         $query=$DB1->query($sql);
			  
         $result=$query->result_array();
    
        return $result;
    }	
    function load_lecture_cources($academic_year,$sch_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$acd_yr = explode('~',$academic_year);
		$acdyr = explode('-',$acd_yr[0]);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$sql="select course_id,course_short_name from vw_stream_details where stream_id in(select distinct admission_stream from student_master where academic_year ='$acdyr[0]') and course_name is not null and school_code='".$sch_id."'";
		//$sql = "select distinct vw.course_id,vw.course_short_name from lecture_attendance t left join vw_stream_details vw on vw.stream_id = t.stream_id where t.academic_year ='$acd_yr[0]' and t.academic_session='$cur_ses' and vw.course_name is not null ";
		if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND school_code = $sccode";
			}
		$sql .=" group by course_id order by course_id asc";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();
		$stream_details = $query->result_array();
		return $stream_details;
	}
		function get_attendance_streams($course_id, $academic_year,$sch_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$acd_yr = explode('~',$academic_year);
		$acdyr = explode('-',$acd_yr[0]);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		//and 
		$sql="select stream_id,stream_code,stream_short_name,stream_name from vw_stream_details where course_id ='$course_id' and stream_id in(select distinct admission_stream from student_master where academic_year ='$acdyr[0]' ) 
		and stream_short_name is not null and school_code='".$sch_id."' 
		";
        //$sql="SELECT distinct l.stream_id, vw.stream_code, vw.stream_short_name, vw.course_short_name, vw.stream_name FROM `lecture_attendance` l inner join vw_stream_details vw on vw.stream_id =l.stream_id and vw.course_id ='$course_id' AND l.academic_session='$cur_ses' and l.academic_year='".$acd_yr[0]."'";
        if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND school_code = $sccode";
			}
			$sql .=" group by stream_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function get_lec_details($dt,$sb,$std){
 $DB1 = $this->load->database('umsdb', TRUE);
    	 $sql="select l.slot,l.faculty_code,vf.fname,vf.lname,ls.from_time,ls.to_time,ls.slot_am_pm  from lecture_attendance l inner join lecture_slot ls on l.slot=ls.lect_slot_id inner join vw_faculty vf on l.faculty_code=vf.emp_id where 
l.attendance_date ='".date('Y-m-d',strtotime($dt))."' AND l.subject_id ='".$sb."' AND l.student_id='".$std."'    	";

   $query=$DB1->query($sql);
         $result=$query->result_array();
    
        return $result;
    }
     function get_faculty_lecture_list($data){
     	//print_r($data);
     	$DB1 = $this->load->database('umsdb', TRUE);
     	if($data['acd_yer']!=''){
			$acd_yr = explode('~',$data['acd_yer']);
			$ayw=' and l.academic_year="'.$acd_yr[0].'" and l.academic_session="'.substr($acd_yr[1], 0,3).'" ';

		}
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
     $sql="select l.`course_id`,l.`stream_id`,l.`semester`,l.`division`,l.lecture_slot,l.faculty_code,vf.fname,vf.lname,l.`wday`,vw.school_name from lecture_time_table l 
  inner join vw_faculty vf on l.faculty_code=vf.emp_id 
inner JOIN vw_stream_details vw ON vw.stream_id =l.stream_id 
 where l.is_active='Y' $ayw $sch  $crs  $strm $wd $fac group by l.faculty_code ORDER BY l.faculty_code,l.`course_id`,l.`stream_id`,l.`semester`,l.`division`,l.wday ASC 
  	";
//exit;
   $query=$DB1->query($sql);
   //echo $DB1->last_query();
  // exit;
         $result=$query->result_array();
    
        return $result;

    }

    function get_faculty_lecturs_fact_code($acdy,$csess,$faculty_code,$fdt,$tdt){
    	//echo $fdt; echo "kk".$tdt;exit;
$DB1 = $this->load->database('umsdb', TRUE);
if($fdt!='' && $tdt!=''){
	
	$darr = $this->get_dates($fdt,$tdt);
//print_r($darr);
foreach($darr as $val){
	$dday = date('l',strtotime($val));
$wd[] = "'".$dday."'";
}
$wd= implode(',',$wd);
$wd = ' AND l.wday IN('.$wd.')';
}
    $sql="SELECT l.`course_id`,l.`stream_id`,l.`semester`,l.`division`,l.batch_no as batch,vf.staff_type,vw.school_name,vw.school_short_name,vw.course_name,vw.stream_name,s.subject_code as sub_code,s.subject_name,l.lecture_slot,l.subject_code,l.faculty_code,vf.fname,vf.lname,ls.from_time,ls.to_time,ls.slot_am_pm,l.wday,l.subject_type,s.subject_short_name FROM lecture_time_table l 
INNER JOIN lecture_slot ls ON l.lecture_slot=ls.lect_slot_id 
INNER JOIN vw_faculty vf ON l.faculty_code=vf.emp_id 
INNER JOIN vw_stream_details vw ON l.stream_id=vw.stream_id 
inner JOIN subject_master s ON l.subject_code=s.sub_id 
WHERE l.`academic_session`='".$csess."' AND l.`academic_year`='".$acdy."' AND l.is_active='Y' And l.faculty_code='$faculty_code' $wd ORDER BY FIELD(l.wday, 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'),l.`course_id`,l.`stream_id`,l.`semester`,l.`division`,ls.`from_time` DESC";
$query=$DB1->query($sql);
         $result=$query->result_array();
    
        return $result;

    }
    function check_leave($fact,$dt){
$sql="select lid,emp_id,applied_from_date,applied_to_date,leave_duration,CASE WHEN l.leave_type ='official' THEN 'OD' ELSE ea.leave_type END AS leave_name FROM leave_applicant_list l LEFT JOIN employee_leave_allocation ea ON l.`leave_type`=ea.`id` WHERE emp_id='".$fact."' and fstatus = 'Approved' and month(applied_from_date)='".date('m',strtotime($dt))."' and YEAR(applied_from_date)='".date('Y',strtotime($dt))."' ";
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
       
		 if(count($value)==0){
			 $flag="false";
		}else{
		 	 if($value['is_relax_day']=='Y'){
				 $flag = 'RD';
			 }else{
				$flag="true";
			 }
		 } 
		 return $flag;		
}

function check_other_duty($fact,$dt,$semester=""){
$cond="and emp_other_task_list.status='Y'";
if($semester !=''){
	$cond="";
$cond.="and emp_other_task_list.semester='$semester'";	
}
$sql="select * from emp_other_task_list join other_task on emp_other_task_list.other_task=other_task.id where emp_id=$fact  and '$dt' between from_date and to_date $cond ";
$query=$this->db->query($sql)->row();
	return $query;
    }

function get_commu_attendance_list($data){
if($data['acd_yer']!=''){
			$acd_yr = explode('~',$data['acd_yer']);
			
			$ayw=" and t.academic_year='".$acd_yr[0]."' AND t.academic_session='".substr($acd_yr[1], 0,3)."' ";
			$ayb=" B.academic_year='".$acd_yr[0]."' AND B.academic_session='".substr($acd_yr[1], 0,3)."' ";

		}
if($data['sch_id']!=''){
 $sch = " AND vw.school_code='".$data['sch_id']."' ";
}
if($data['curs']!=''){
 $crs = " AND vw.course_id='".$data['curs']."' ";
}
if($data['strm']!=''){
 $strm = " AND vw.stream_id='".$data['strm']."' ";
}
if($data['sem']!=''){
 $sem = " AND t.semester='".$data['sem']."' ";
}
if($data['divis']!=''){
 $div = " AND t.division='".$data['divis']."' ";
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
$wd = ' AND t.wday IN('.$wd.')';
}
if($data['rtyp']=='m'){
	$f = " and t.faculty_code is not null and  t.faculty_code !=''";
}
$attendace_date= $data['attendance_date'];
$day = date('l', strtotime($attendace_date)); 
$DB1 = $this->load->database('umsdb', TRUE);
 /*echo $sql="SELECT vw.school_name,vw.course_name,t.semester,t.faculty_code,t.subject_code,s.subject_code as sub_code,s.subject_name,t.division,t.batch_no, t.subject_type,lecture_slot,wday,slt.from_time,slt.to_time,slt.slot_am_pm, f.fname,f.mname,f.lname,f.mobile_no, t.faculty_code,f.staff_type,vw.school_name, vw.stream_name,t.stream_id FROM lecture_time_table t 
LEFT JOIN lecture_slot slt ON slt.lect_slot_id = t.lecture_slot 
LEFT JOIN vw_faculty f ON f.emp_id = t.faculty_code 
LEFT JOIN vw_stream_details vw ON vw.stream_id =t.stream_id 
LEFT JOIN subject_master s ON s.sub_id = t.subject_code
WHERE 1 $ayw $sch $crs $strm $sem $div $wd $f order by vw.course_id,vw.stream_id,t.semester,t.division,FIELD(t.wday, 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'),slt.from_time ASC";exit;*/
$sql="SELECT vw.school_name,vw.school_short_name,vw.course_short_name,vw.stream_name,t.academic_year,t.academic_session,t.stream_id,count(*) as no_of_lectures,
(select count(A.stream_id) from (SELECT distinct stream_id,semester,division,batch,slot,faculty_code,academic_year FROM lecture_attendance B WHERE  $ayb AND B.attendance_date='$attendace_date') A where A.stream_id = t.stream_id and A.academic_year=t.academic_year) AS no_lecture_taken, 
(SELECT count(stud_id) FROM student_master s WHERE  s.admission_stream=t.stream_id and academic_year='".$this->config->item('cyear')."' and cancelled_admission='N' and admission_confirm='Y' group by admission_stream) as 
no_of_reregistered
FROM lecture_time_table t 
LEFT JOIN vw_stream_details vw ON vw.stream_id =t.stream_id 
WHERE 1 $ayw and t.is_active='Y' AND t.wday IN('$day') 
group by vw.school_name,vw.course_name,vw.stream_name
order by vw.school_name,vw.course_name,vw.stream_name,FIELD(t.wday, 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY')";
 $query=$DB1->query($sql);
         $result=$query->result_array();    
        return $result; 
}	
	
  function get_attendance_mark_report_list($data){ 
		$fdate='';$tdate='';$sub='';$subtp='';
		if($data['acd_yer']!=''){
					$acd_yr = explode('~',$data['acd_yer']);
					
					$ayw=" and t.academic_year='".$acd_yr[0]."' AND t.academic_session='".substr($acd_yr[1], 0,3)."' ";
					$ayb=" B.academic_year='".$acd_yr[0]."' AND B.academic_session='".substr($acd_yr[1], 0,3)."' ";

				}
		if($data['sch_id']!=''){
		 $sch = " AND vw.school_code='".$data['sch_id']."' ";
		}
		if($data['curs']!=''){
		 $crs = " AND vw.course_id='".$data['curs']."' ";
		}
		if($data['strm']!=''){
		 $strm = " AND vw.stream_id='".$data['strm']."' ";
		}
		if($data['sem']!=''){
		 $sem = " AND t.semester='".$data['sem']."' ";
		}
		if($data['divis']!=''){
		 $div = " AND t.division='".$data['divis']."' ";
		}
		if($data['sub_type']!=''){
			$sub= "and t.subject_type='".$data['sub_type']."'";
			$subtp= "and subtype='".$data['sub_type']."'";
		}
		if($data['fdt']!='' && $data['tdt']!=''){
			//echo $data['fdt']; echo $data['tdt'];
			$fdate=$data['fdt'];
			$tdate=$data['tdt'];
			$darr = $this->get_dates($data['fdt'],$data['tdt']);
		//print_r($darr);
		foreach($darr as $val){
			$dday = date('l',strtotime($val));
		$wd[] = "'".$dday."'";
		}
		$wd= implode(',',$wd);
		$wd = ' AND t.wday IN('.$wd.')';
		}
		if($data['rtyp']=='m'){
			$f = " and t.faculty_code is not null and  t.faculty_code !=''";
		}
		$attendace_date= $data['attendance_date'];
		$day = date('l', strtotime($attendace_date)); 
		$DB1 = $this->load->database('umsdb', TRUE);
		 $sql="SELECT vw.school_name,vw.school_short_name,vw.course_short_name,vw.stream_name,t.academic_year,t.subject_type,t.academic_session,t.semester,t.stream_id,count(*) as no_of_lectures,
		(select count(A.stream_id) from (SELECT distinct stream_id,semester,division,batch,slot,faculty_code,academic_year FROM lecture_attendance B WHERE  $ayb $subtp AND B.attendance_date >= '$fdate' and B.attendance_date <= '$tdate') A where A.stream_id = t.stream_id and A.academic_year=t.academic_year  AND A.semester = t.semester) AS no_lecture_taken, 
		(SELECT count(stud_id) FROM student_master s WHERE  s.admission_stream=t.stream_id and academic_year='".$this->config->item('cyear')."' and cancelled_admission='N' and admission_confirm='Y' group by admission_stream) as 
		no_of_reregistered
		FROM lecture_time_table t 
		LEFT JOIN vw_stream_details vw ON vw.stream_id =t.stream_id 
		WHERE 1 $ayw and t.is_active='Y' $wd $sub
		group by vw.school_name,vw.course_name,vw.stream_name,t.semester
		order by vw.school_code,vw.course_name,vw.stream_name,FIELD(t.wday, 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'),t.semester";
		//echo $sql;exit;
		 $query=$DB1->query($sql);

        $result=$query->result_array();    
        return $result; 
} 
function get_attendance_percentage($stream_id,$acd_yer, $acd_sess, $sdate){
	$DB1 = $this->load->database('umsdb', TRUE);
	$sql="select stream_id,academic_year,count(C.student_id) as total_students,SUM(case when C.is_present='Y' THEN 1 else 0 end) as no_p,(SUM(case when C.is_present='Y' THEN 1 else 0 end)/count(C.student_id)*100) p_per, 
SUM(case when C.is_present='N' THEN 1 else 0 end) as no_a,(SUM(case when C.is_present='N' THEN 1 else 0 end)/count(C.student_id) *100) a_per from lecture_attendance C  
where C.stream_id =$stream_id  AND C.attendance_date='$sdate' and C.academic_year='$acd_yer' AND C.academic_session='$acd_sess'";//exit;
	$query=$DB1->query($sql);
    $result=$query->result_array();    
    return $result; 	
}
function get_attendance_percentage_for_mark_report($stream_id,$acd_yer,$acd_sess, $fdate,$tdate,$semester=''){
	$DB1 = $this->load->database('umsdb', TRUE);
	$sql="select stream_id,academic_year,count(C.student_id) as total_students,SUM(case when C.is_present='Y' THEN 1 else 0 end) as no_p,(SUM(case when C.is_present='Y' THEN 1 else 0 end)/count(C.student_id)*100) p_per, 
SUM(case when C.is_present='N' THEN 1 else 0 end) as no_a,(SUM(case when C.is_present='N' THEN 1 else 0 end)/count(C.student_id) *100) a_per from lecture_attendance C  
where C.semester =$semester and C.stream_id =$stream_id AND C.attendance_date >='$fdate' and  C.attendance_date <= '$tdate' and C.academic_year='$acd_yer' AND C.academic_session='$acd_sess'";//exit;
	$query=$DB1->query($sql);
    $result=$query->result_array();    
    return $result; 	
}
function get_totstudentcount($stream_id,$acd_yer,$acd_sess, $semester=''){
	$DB1 = $this->load->database('umsdb', TRUE);
	$cyear=$this->config->item('cyear');
	
	        if($stream_id ==9){
				if($semester=='1' || $semester=='2'){
				$strem=" AND C.admission_stream in(5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279)";	
				}
			}else{
				$strem="and C.admission_stream =$stream_id";
			}
	 $sql="select count(*) as no_of_students from student_master C  
where C.current_semester =$semester $strem AND C.academic_year='$cyear' AND C.cancelled_admission='N' and admission_cycle is null AND enrollment_no!=''";//AND C.admission_confirm='Y' exit;
	$query=$DB1->query($sql);
    $result=$query->result_array();    
    return $result; 	
}
function getStreamCode($stream_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        		
        $sql="SELECT stream_code,stream_name FROM `vw_stream_details` WHERE `stream_id` = '".$stream_id."' ORDER BY `stream_code` ASC";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
		function  getStudinoutpunchingList($stream_id='',$semester='',$division='',$academic_year='',$log_date='')
    {     
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE sba.stream_id='$stream_id' AND sba.semester='$semester' and sba.division='$division' and sba.academic_year='$academic_year' AND sm.cancelled_admission='N' and sba.active='Y' and  STR_TO_DATE(pg.LogDate,'%Y-%m-%d')='$log_date'
		
		
		
		";
        $sql="SELECT sm.punching_prn,sm.stud_id, sba.roll_no,CONCAT(sm.first_name,' ',sm.middle_name,' ',sm.last_name) as student_name, sm.enrollment_no,sm.mobile,sm.email,sm.transefercase, sba.division,sba.batch,sba.stream_id, sba.semester,min(pg.LogDate)as logmin,max(pg.LogDate)as logmax FROM sandipun_ums.student_batch_allocation as sba left join sandipun_ums.student_master sm on sm.stud_id=sba.student_id left join (
		SELECT UserId,LogDate FROM sandipun_erp.punching_log WHERE DeviceId IN (SELECT machine_id FROM
         sandipun_erp.student_punching_machines
		
		
		)) pg on pg.UserId=sm.punching_prn $where";
		$sql .= "group by sm.enrollment_no order by sba.roll_no";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function fetch_Allacademic_session(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
        //print_r($emp_id);exit;
		$sql = "select academic_year,academic_session from academic_session ";		
		if(isset($role_id) && ($role_id==15 || $role_id==6)){
			$sql .=" Order by academic_year desc limit 0,2";
		}elseif($emp_id == 'research_admin'){
			$sql .=" Order by academic_year desc limit 0,4";
			
		}else{
			$sql .="  where currently_active='Y'";
			
		}
	}
	public function fetch_lecture_attendance_data()
   {
	   $obj = New Consts();
		$curr_sess = $obj->fetchCurrSession();
	   $academic_year=ACADEMIC_YEAR;
	   $att_date=date('Y-m-d');
	   $DB1 = $this->load->database('umsdb', TRUE); 
       $sql="SELECT la.stream_id, vw.school_short_name as school,vw.course_short_name,vw.stream_name, la.academic_year, la.academic_session, la.semester,
			   la.stud_count, la.present_count,
			   ROUND((la.present_count / la.stud_count) * 100, 2) AS present_percentage
		FROM (
			SELECT stream_id, academic_year, academic_session, semester,
				   COUNT(DISTINCT student_id) AS stud_count,
				   COUNT(DISTINCT CASE WHEN is_present = 'Y' THEN student_id ELSE NULL END) AS present_count
			FROM lecture_attendance
			WHERE academic_year = '$academic_year' AND academic_session = '$curr_sess' and attendance_date='$att_date'
			GROUP BY stream_id, semester
		) AS la
		INNER JOIN vw_stream_details AS vw ON la.stream_id = vw.stream_id order by vw.school_short_name,vw.course_short_name,vw.stream_name";
		$query=$DB1->query($sql);
		
		return $query->result_array();
		
   }
   public function fetch_lecture_attendance_reregister_data($stream_id='',$semester='')
   {
     $academic_year = C_RE_REG_YEAR;
     $current_session = ADMISSION_SESSION;

    $DB1 = $this->load->database('umsdb', TRUE);
	$sem_stm='';$last_sem='';
	if($semester!=''){
		if($semester==1){
		$sem_stm="and s.current_semester='$semester'";
		}ELSE
		{
			$last_sem=$semester-1;
		  $sem_stm="and s.current_semester IN ($last_sem, $semester)";
		}
	}

    $sql = "SELECT COUNT(s.stud_id) AS rereg_stud_count FROM student_master s LEFT JOIN vw_stream_details v ON v.stream_id = s.admission_stream WHERE s.cancelled_admission = 'N' AND s.is_detained = 'N' AND s.admission_session != '$current_session' 
AND s.academic_year = '$academic_year' AND s.admission_confirm = 'Y' AND v.course_id != 15 AND s.admission_stream = '$stream_id' $sem_stm ";//AND ((v.course_pattern = 'SEMESTER' AND s.current_year != v.course_duration) OR (v.course_pattern != 'SEMESTER' AND s.current_year != v.course_duration))
    $query = $DB1->query($sql);
    return $query->row_array();
   }
function insert_duck_report($faculty_code,$fdate,$acd_yer,$acd_sess,$t_duck){ 
		//echo "<pre>";
		//print_r($var);exit;
		$DB1 = $this->load->database('umsdb', TRUE);  
		$data['todays_date'] = $fdate;
		$data['academcyr'] = $acd_yer;
		$data['acdsess'] = $acd_sess;
		$data['no_of_ducks'] =$t_duck;		
		$data['facultycode'] =$faculty_code;
		//$existing_entry = $this->Student_attendance_model->get_faculty_duck_entry($faculty_code,$fdate,$acd_yer,$acd_sess);

	//	if(!empty($existing_entry)){
	//		$data['total_duck'] =$t_duck;
	//	}else{
			$data['inserted_on'] = date('Y-m-d H:i:s');	
			//$data['inserted_by'] = $this->session->userdata("uid");
			$DB1->insert('facultywise_datewise_duck_report', $data);
		//}
		
		//echo $DB1->last_query();exit;
		return true;
	}
	function faculty_monthly_attendance_insert($insertDataArr){
	  $DB1 = $this->load->database('sfumsdb', TRUE);
	  $DB1->insert('cummulative_faculty_monthly_attendance_reports', $insertDataArr);
	// echo $DB1->last_query(); die;
	}	
	public function getReRegistrationReport()
{
    $DB1 = $this->load->database('umsdb', TRUE); // or default

    $sql = "SELECT 
    v.school_short_name,
    v.course_short_name,
    v.stream_name,
    COUNT(*) AS total_students_2024,
    
    -- Total re-registered students
    SUM(CASE 
            WHEN s2025.enrollment_no IS NOT NULL THEN 1 
            ELSE 0 
        END) AS re_registered_count,

    -- Today's re-registered students
    SUM(CASE 
            WHEN s2025.enrollment_no IS NOT NULL 
                 AND DATE(s2025.modified_on) = CURRENT_DATE THEN 1 
            ELSE 0 
        END) AS today_re_registered_count,

    -- Students pending re-registration
    (COUNT(*) - SUM(CASE WHEN s2025.enrollment_no IS NOT NULL THEN 1 ELSE 0 END)) AS pending_count

FROM admission_details ad 
INNER JOIN student_master s2024 
    ON ad.student_id = s2024.stud_id AND ad.academic_year = 2024

LEFT JOIN student_master s2025 
    ON s2024.enrollment_no = s2025.enrollment_no AND s2025.academic_year = 2025 

LEFT JOIN vw_stream_details v 
    ON v.stream_id = ad.stream_id

WHERE s2024.cancelled_admission = 'N' 
  AND s2024.is_detained = 'N' 
  AND s2024.admission_session != 2025
  AND ad.academic_year = 2024
  AND s2024.admission_confirm = 'Y' 
  AND v.course_id != 15
  AND (
        (v.course_pattern = 'SEMESTER' AND ad.year != v.course_duration) OR
        (v.course_pattern != 'SEMESTER' AND ad.year != v.course_duration)
      )

GROUP BY v.school_short_name, v.course_short_name, v.stream_name;";

    return $DB1->query($sql)->result_array();
}

}
?>