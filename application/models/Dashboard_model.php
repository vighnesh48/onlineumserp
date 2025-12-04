<?php
class Dashboard_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_employees()
    {        
        
        $sql="select emp_id From employee_master where emp_reg = 'N' and manual_attendance_flag = 'N' and DATE(joiningDate) <= '".date('Y-m-d')."' order by emp_id ASC";
        $query = $this->db->query($sql);
		//exit;
		$emp = $query->result_array();
		//print_r($emp);
		foreach($emp as $val){
			$arr[$val['emp_id']] = array();
		for($i=1;$i<=4;$i++){
			
		 $cd = date('Y-m-d',strtotime('-'.$i.' day'));
		//echo "<br/>";
		 $sql1 = 'select intime from punching_backup where UserId = "'.$val['emp_id'].'" and DATE(intime) = "'.$cd.'" and TIME(intime) = "00:00:00" ';
		$query1 = $this->db->query($sql1);
		//exit;
		//echo "</br>";
		$emp1 = $query1->result_array();
		 $pcnt = count($emp1);
		//echo "</br>";
		if($pcnt == '1'){			
			$arr[$val['emp_id']][]=1;
		}
		}
		} 
		//echo "<pre>";
		//print_r($arr);
		foreach($arr as $key=>$val){
			 $fcnt = count($val);
			if($fcnt=='4'){
			$arr1[] = $key;
			}
		}
        return $arr1;
    }  
	
	function get_employee_details_byid($empid){
		 $this->db->select('e.emp_id,e.fname,e.mname,e.lname,dg.designation_name,dt.department_name,c.college_name');
     $this->db->from('employee_master as e');
	  $this->db->join ('designation_master dg','e.designation=dg.designation_id','inner');
	   $this->db->join ('department_master dt','dt.department_id=e.department','inner');
	   $this->db->join ('college_master c','c.college_id=e.emp_school','inner');
	   $this->db->where_in('e.emp_id', $empid);
	 
	 $query=$this->db->get();
	 $res=$query->result_array();
	 return $res;	 
	}
	function check_isformexist($prn)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT * FROM `exam_details` WHERE `exam_id` = 9 AND (`entry_on` >= '2018-11-26 09:52:27' OR modify_on >='2018-11-26 09:52:27') AND enrollment_no='".$prn."'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stud = $query->result_array();
		return $stud;	
	}
	//
	function get_student_details($prn){ 
		$DB1 = $this->load->database('umsdb', TRUE); 
	 $sql="select stud_id,belongs_to,enrollment_no,admission_stream,s.admission_session,s.nationality,s.academic_year,s.current_year,admission_school,v.course_id,s.adhar_card_no,s.current_semester,current_year,admission_cycle,is_detained,v.course_duration,v.course_pattern,v.school_code from student_master s 
	 left join vw_stream_details v on v.stream_id=s.admission_stream
	 where enrollment_no='$prn'";	 
	 $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
		$stud = $query->result_array();
		return $stud;		 
	}
	function check_latest_exam($prn)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT * FROM `exam_details` WHERE enrollment_no='".$prn."' order by exam_master_id desc limit 1";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stud = $query->result_array();
		return $stud;	
	}
	
	function get_student_academic_calendar($academic_year,$course_id,$school_id,$stream_id,$cyear){ 
	 $DB1 = $this->load->database('umsdb', TRUE); 
	 $sql="select  academic_calendar_path from academic_calendar_and_events 
	 where academic_year='$academic_year'";
	 if($school_id == 6 || $school_id == 5 || $school_id == 10 || $school_id == 4 || $school_id == 2 || $school_id == 14 || $school_id == 9){
	 	$sql.= "and school_id = '$school_id'";
	 }elseif($cyear == 1 && $school_id == 1){

	 	    $sql.= "and school_id = '$school_id' and  for_year = 1 ";

	 }else{

	 	$sql.= "and school_id = '$school_id' and  course_id = '$course_id' and stream_id='$stream_id' ";
	 }	 
	 $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stud = $query->result_array();
	   return $stud;		 
	}

	function get_student_academic_event($academic_year,$course_id,$school_id,$stream_id,$cyear){ 
		$DB1 = $this->load->database('umsdb', TRUE); 
	 $sql="select  events_calendar_path from academic_calendar_and_events 
	 where academic_year='$academic_year'";
	 if($school_id == 6 || $school_id == 5 || $school_id == 10 || $school_id == 4 || $school_id == 2 || $school_id == 14 || $school_id == 9){
	 	$sql.= "and school_id = '$school_id'";
	 }elseif($cyear == 1 && $school_id == 1){

	 	    $sql.= "and school_id = '$school_id' and  for_year = 1 ";

	 }else{

	 	$sql.= "and school_id = '$school_id' and  course_id = '$course_id' and stream_id='$stream_id' ";
	 }	 
	 $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stud = $query->result_array();
		return $stud;		 
	}
	///////////
	function fetch_student_data($admission_session)
		{	
			if(!empty($admission_session)){
				$admission_session=$admission_session;
			}else{
				$admission_session=C_RE_REG_YEAR;
			}
			
		$sql="select h.organisation as organisation, h.instute_name as instute_name, count(h.student_id) as std_count, sum(h.actual_fees) as actual_fees,sum(h.fees_paid) as fees_paid from (SELECT s.instute_name,CONCAT(s.first_name, ' ' , s.last_name) as first_name,'',a.fees_paid,fs.* FROM sandipun_erp.sf_student_facilities fs 
		join sandipun_erp.sf_student_master s on s.enrollment_no=fs.enrollment_no and s.student_id=fs.student_id 
		LEFT JOIN (
		SELECT enrollment_no,student_id,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine 
		FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' and academic_year='$admission_session' AND type_id='2' GROUP BY enrollment_no
		) a ON a.enrollment_no=fs.enrollment_no and a.student_id=fs.student_id  AND fs.academic_year=a.academic_year 
		where sffm_id='2' and fs.academic_year='$admission_session' and cancelled_facility='N' and organisation in('SF') #group by f.enrollment_no
		union 
		SELECT p.school_short_name as instute_name,s.first_name,f.actual_fees,a.fees_paid,f.* FROM sandipun_erp.sf_student_facilities f 
		join sandipun_ums.student_master s on (s.enrollment_no=f.enrollment_no or s.enrollment_no_new=f.enrollment_no)  and s.stud_id=f.student_id and f.sffm_id=2
		INNER JOIN sandipun_ums.vw_stream_details p ON s.admission_stream=p.stream_id
		LEFT JOIN (
		SELECT enrollment_no,student_id,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine 
		FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' and academic_year='$admission_session' AND type_id='2' GROUP BY enrollment_no
		) a ON a.enrollment_no=f.enrollment_no and a.student_id=f.student_id  AND f.academic_year=a.academic_year 
		where sffm_id='2' and f.academic_year='$admission_session' and cancelled_facility='N' and organisation in('SU')) as h  GROUP by organisation,instute_name";
		$query = $this->db->query($sql);
        return $query->result_array();		
	}


	function fetch_uniform_data()
	{
		$sql="SELECT 
    o.org_frm, 
    o.institute, 
    COUNT(o.payment_id) AS student_count, 
    SUM(o.amount) AS fees_paid,
    SUM(CASE 
        WHEN t.enrollment_no IS NOT NULL THEN 1 
        ELSE 0 
    END) AS uniform_distributed_count
FROM 
    online_payment_facilities AS o
LEFT JOIN 
    (select enrollment_no from sandipun_ums.transaction group by enrollment_no) AS t 
    ON t.enrollment_no = o.registration_no
WHERE 
    o.productinfo = 'Uniform' 
    AND o.payment_status = 'success' 
    AND o.admission_cancel = 'N'
GROUP BY 
    o.org_frm, 
    o.institute order by o.org_frm";
		$query = $this->db->query($sql);
        return $query->result_array();		
	}
	function fetch_uniform_data_old()
	{
		$sql="select b.*,c.total_admission,c.school_id,case when b.org_frm='SU' then a.pending_count else 0 end as pending_count  from (select org_frm, institute, count(payment_id) as student_count,sum(amount) as fees_paid  from online_payment_facilities 
where productinfo='Uniform' and payment_status='success' and admission_cancel='N'  group by org_frm, institute  ) as b
left join schoolwise_admission_count c on c.school_name=b.institute
left join (select sl.* from (select admission_school,count(*) as pending_count
from sandipun_ums.student_master s
left join sandipun_erp.online_payment_facilities o on o.student_id=s.stud_id and o.productinfo='Uniform' and o.payment_status='success' and o.admission_cancel='N'
left join sandipun_ums.vw_stream_details v on v.stream_id=s.admission_stream
where s.academic_year ='2022' and `cancelled_admission` = 'N' AND `enrollment_no` != '' and v.course_id!=15 and admission_confirm='Y'  and o.registration_no is null
group by admission_school) as sl) as a on a.admission_school=c.school_id
		
		";
		$query = $this->db->query($sql);
        return $query->result_array();		
	}
	function fetch_uniform_pending_data($org,$school_id)
	{
		if($school_id==9){
			$school_id ='9,14';
		}
		$sql="select o.registration_no,s.enrollment_no,UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as student_name,s.mobile,s.email,s.current_semester,s.current_year,v.school_short_name,v.course_name,v.stream_name,CASE
    WHEN o.registration_no is null THEN 'Pending'
    ELSE 'Paid'
END AS Uniform_payment_status,s.belongs_to
from sandipun_ums.student_master s
left join sandipun_erp.online_payment_facilities o on o.student_id=s.stud_id and o.productinfo='Uniform' and o.payment_status='success' and o.admission_cancel='N'
left join sandipun_ums.vw_stream_details v on v.stream_id=s.admission_stream

where s.academic_year ='2022' and `cancelled_admission` = 'N' AND `enrollment_no` != '' and v.course_id!=15 and admission_confirm='Y' and s.admission_school in($school_id) and o.registration_no is null";
		$query = $this->db->query($sql);
        return $query->result_array();		
	}
	function fetch_uniform_pending_data_sf($org,$school_id)
	{

	$sql="select o.registration_no,s.enrollment_no,UPPER(student_name) as student_name,s.MobileNo1 as mobile,s.EmailId as email,s.Class as current_year,s.College as school_short_name,s.Course as course_name,s.Stream as stream_name,CASE
    WHEN o.registration_no is null THEN 'Pending'
    ELSE 'Paid'
END AS Uniform_payment_status
from sf_student_master_2022 s
left join sandipun_erp.online_payment_facilities o on o.registration_no=s.enrollment_no and o.productinfo='Uniform' and o.payment_status='success' and o.admission_cancel='N'

where s.academic_year ='2022-2023' and s.college in('$school_id') and o.registration_no is null";
		$query = $this->db->query($sql);
        return $query->result_array();		
	}
	function fetch_hostel_data($admission_session, $campus = 'NASHIK')
{
    if(empty($admission_session)){
        $admission_session = ADMISSION_SESSION;
    }
    
    if(empty($campus)){
        $campus = 'NASHIK';
    }
    
    $sql = "SELECT b.hostel_name,b.hostel_type, b.campus_name, b.area, b.in_campus, b.hostel_code, b.academic_year, 
            b.capacity, b.capacity, b.actual_capacity, COUNT(b.enrollment_no) AS stud_total, 
            SUM(b.fees_paid) AS fees_paid, SUM(b.fine) AS fine, SUM(b.deposit_fees) AS deposit_fees, 
            SUM(b.actual_fees) AS actual_fees, SUM(b.gym_fees) AS gym_fees, SUM(b.fine_fees) AS fine_fees, 
            SUM(b.opening_balance) AS opening_balance, SUM(b.excemption_fees) AS excemption_fees 
            FROM ( 
                SELECT DISTINCT a.fees_paid, a.fine, f.enrollment_no, h.hostel_name, h.hostel_type, h.area, h.campus_name, 
                h.actual_capacity, h.no_of_beds AS capacity, h.in_campus, r.bed_number, r.hostel_code, r.room_no, 
                f.academic_year, f.deposit_fees, f.actual_fees, f.gym_fees, f.fine_fees, f.opening_balance, 
                f.excemption_fees, f.cancelled_facility 
                FROM sandipun_erp.sf_student_facilities f 
                LEFT JOIN (SELECT enrollment_no, academic_year, SUM(amount) AS fees_paid, 
                SUM(exam_fee_fine) AS fine 
                FROM sandipun_erp.sf_fees_details 
                WHERE chq_cancelled='N' AND is_deleted='N' 
                GROUP BY enrollment_no, academic_year) a 
                ON a.enrollment_no = f.enrollment_no AND f.academic_year = a.academic_year 
                INNER JOIN sandipun_erp.sf_student_facility_allocation s 
                ON s.enrollment_no = f.enrollment_no AND s.academic_year = f.academic_year AND s.is_active = 'Y' AND s.sffm_id=1
                INNER JOIN sandipun_erp.sf_hostel_room_details r 
                ON r.sf_room_id = s.allocated_id 
                INNER JOIN sandipun_erp.sf_hostel_master h 
                ON h.host_id = r.host_id 
                WHERE f.sffm_id = 1) b 
            WHERE b.academic_year = '$admission_session' AND b.campus_name = '$campus' 
            GROUP BY b.hostel_name, b.hostel_type, b.campus_name, b.in_campus, b.hostel_code, b.academic_year";
    
    $query = $this->db->query($sql);
    return $query->result_array();
}


 function getAllAcademicYear()
 {
	$sql="select distinct(academic_year) as academic_year from sandipun_erp.sf_academic_year";
	$query = $this->db->query($sql);
    return $query->result_array();
 }
/////////////////////////////////////////

}