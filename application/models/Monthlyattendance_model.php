<?php
class Monthlyattendance_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
$DB1 = $this->load->database('otherdb', TRUE); 
    }
    //get courses offered by college
 
	function checkAvailableAttendance($dt){
		$DB1 = $this->load->database('otherdb', TRUE); 
	//echo cal_days_in_month(CAL_GREGORIAN, date("m",strtotime($dt)), date("Y",strtotime($dt)));
//exit;
  $no_month = cal_days_in_month(CAL_GREGORIAN, date("m",strtotime($dt)), date("Y",strtotime($dt)));
		$time_array = array();
		for($i=1;$i<=$no_month;$i++){
		//	echo $i;
		 $dt1 = $dt.'-'.$i;
		//echo "<br/>";
		 $today= date("Y-m-d",strtotime($dt1));
		 $month = date("m",strtotime($dt1));
		 $year = date("Y",strtotime($dt1));
		 $date = date("d",strtotime($dt1));
		//echo "<br/>";
		 //$sql="SELECT UserId,min(LogDate) as punch_intime,IF(min(LogDate)!=max(LogDate),max(LogDate),'0000-00-00 00:00:00') as punch_outtime,status from essl_logs where date(LogDate)='$today' and UserId ='".$this->session->userdata("name")."'";
		  $sql = "select Intime as punch_intime,Outtime as punch_outtime,status,leave_type,leave_duration,remark,late_mark,early_mark from punching_backup where month(Intime)='$month' and year(Intime)='$year' and  day(Intime)='$date' and UserId ='".$this->session->userdata("name")."'";
		// $sql = "select el.UserId,min(el.LogDate) as punch_intime,IF(min(el.LogDate)!=max(el.LogDate),max(el.LogDate),'0000-00-00 00:00:00') as punch_outtime from  sandipun_attendance.essl_logs as el where month(el.LogDate)='$month' and year(el.LogDate)='$year' and  day(el.LogDate)='$date'  and el.UserId ='".$this->session->userdata("name")."'";
		
		$query = $this->db->query($sql);
		$qry = $query->result_array();
		//echo "kk".count($qry);
//exit;
		if(count($qry)>0){
		foreach($qry as $val){
			
				$str = $val['punch_intime'];
			
				$str .= ",".$val['punch_outtime'];
		
             $str .= ",".$val['status'];
		
		if(trim($val['remark'])=='full-day'){
			$str .= ",".$val['leave_type']."(F)";
		}elseif(trim($val['remark'])=='hrs'){

$str .= ",".$val['leave_type']."(Hrs)";
		}else{

			if($val['leave_type']!=''){
			$str .= ",".$val['leave_type']."(H)";
			}else{
				$str .= ',';
			}
		}
		if($val['leave_duration'] !== ' '){
		$str .= ",".$val['leave_type']."/".$val['leave_duration']."/".$val['remark'];
		}else{
			$str .= ',';
		}
		
		
		$str .= ",".$val['late_mark'];
	
	
		$str .= ",".$val['early_mark'];
	
			 $time_array[$i] = $str;
				 
		}
		}
		}
        
       
		return $time_array;
		
	}
	function get_all_application_list($post){
		//print_r($post);
		$d = explode("-",$post['attend_date']);
		$sql="SELECT * FROM leave_applicant_list where year(applied_from_date) = '".$d[0]."' and month(applied_from_date) = '".$d[1]."' ";		
		
		$query = $this->db->query($sql);
		$qry = $query->result_array();
		
		return $qry;
	}
	function getROId($id){
		$sql="SELECT reporting_person FROM employee_master where emp_id = ".$id;		
		$query = $this->db->query($sql);
		$qry = $query->result_array();
		$sql1="SELECT um_id,username FROM user_master where username = '".$qry[0]['reporting_person']."'";		
		$query1 = $this->db->query($sql1);
		$qry1 = $query1->result_array();
		return $qry1;
	}
	function getRoLeaveDateTime($rid,$lid){
		$sql="select * from leave_process_log where leave_id='".$lid."' and updated_by = '".$rid."' order by lp_id DESC";
		$query = $this->db->query($sql);
		return $qry = $query->result_array();
	}
	function getLeaveTypeById($id){
		$this->db->select('leave_name');
		$this->db->from('leave_master');
		$this->db->where('leave_id',$id);
		$query=$this->db->get();
		$res=$query->result_array();
		return $res[0]['leave_name'];
	}
	function check_punching_record($emp,$today){
		$m = date("m",strtotime($today));
	$d = date("d",strtotime($today));
	 $y = date("Y",strtotime($today));
	$this->db->select('*');
		$this->db->from('punching_backup');
		$this->db->where('UserId',$emp);
		$this->db->where('month(Intime)',$m);
		$this->db->where('day(Intime)',$d);
		$this->db->where('year(Intime)',$y);
		$query=$this->db->get();
		$res=$query->result_array();
	//echo $this->db->last_query();
	return $res;
}
}
?>