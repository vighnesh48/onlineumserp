<?php
class Staff_payment_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
	public function fetchEmpList($typ=''){
		if($typ!=''){
						$whr = ' and e.staff_type IN ('.$typ.')';
		}
		 $sql="select e.emp_id,e.staff_type from employee_master as e where  emp_reg = 'N' ".$whr." order by e.emp_id ASC ";
		 $query=$this->db->query($sql);
		$res=$query->result_array();
		return $res;
	}
	public function fetchEmpListforSalary($msearch,$ysearch,$typ){
		if($typ!=''){
						$whr = ' and em.staff_type IN ('.$typ.')';
		}
		  $sql= " select  CASE WHEN em.staff_type = '3' THEN '3' ELSE 1 END AS staff_type, em.emp_id,em.staff_type as t1 from employee_monthwise_earning as eme join employee_master as em on em.emp_id = eme.emp_id  where em.emp_status = 'Y' and month(eme.for_month)='$msearch' and year(eme.for_month)='$ysearch' ".$whr." order by em.staff_type <> '3', em.emp_id ";
	 $query=$this->db->query($sql);
		$res=$query->result_array();
		return $res;
	}
	public function fetchEmpListforSalary_report($msearch,$ysearch,$typ){
		if($typ!=''){
						$whr = ' and em.staff_type IN ('.$typ.')';
		}
		  $sql= " select  CASE WHEN em.staff_type = '3' THEN '3' ELSE 1 END AS staff_type, em.emp_id,em.staff_type as t1 from employee_monthwise_earning as eme join employee_master as em on em.emp_id = eme.emp_id  where  month(eme.for_month)='$msearch' and year(eme.for_month)='$ysearch' ".$whr." order by em.staff_type <> '3', em.emp_id ";
	 $query=$this->db->query($sql);
		$res=$query->result_array();
		return $res;
	}
	public Function fetchEmpListForAddingIncome($mon,$y){
		$mon1 = $y."-".$mon."-01";
		 $sql="select e.emp_id,e.fname,e.mname,e.lname,e.gender,e.joiningDate from employee_master as e where e.emp_status = 'Y' and e.emp_reg = 'N' and e.joiningDate < '$mon1'  order by e.emp_id ASC ";
		$query=$this->db->query($sql);
		$res=$query->result_array();
		return $res;
	}
	public Function fetchEmpListForAddingIncome1($mon,$y){
		
		  $sql="select e.emp_id,e.fname,e.mname,e.lname,e.gender,e.joiningDate from employee_monthly_final_attendance as ea 
		  join employee_master as e on e.emp_id = ea.UserId and e.emp_status='Y' where month(ea.for_month_year)='".$mon."' and year(ea.for_month_year)='".$y."' order by e.emp_id ASC ";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;
	}
public function get_income_details($yer,$mon){
	$sql="select i.DA,i.HRA,i.TA,i.Incom_Diff,i.otherinc,i.DP,e.emp_id,e.fname,e.mname,e.lname,e.gender from employee_income_detail as i
		inner join employee_master as e on e.emp_id=i.emp_id
	where e.emp_reg = 'N' and month(i.inserted_date)='".$mon."' and year(i.inserted_date)='".$yer."'	";	
			
		$query=$this->db->query($sql);
		return $result=$query->result_array();	
}
	public function getEmpList($yer,$mon){
		$sql="select i.DA,i.HRA,i.TA,i.Incom_Diff,i.otherinc,i.DP,e.emp_id,e.fname,e.mname,e.lname,e.gender from employee_income_detail as i
		left join employee_master as e on e.emp_id=i.emp_id
	where e.emp_reg = 'N' and month(i.inserted_date)='".$mon."' and year(i.inserted_date)='".$yer."'		
		";
		//if(!empty($data['school'])&&!empty($data['dept'])){
		//	$sql.=" where emp_school='".$data['school']."' and department='".$data['dept']."'";
		//}
		//echo $sql;
		
		$query=$this->db->query($sql);
		$result=$query->result_array();
		/* echo "<pre>"; print_R($result);"</pre>"; 
		die();  */
		return $result;
	}
	public function add_income_details($data){
		$inscnt=0;$updcnt=0;
	//echo "<pre>"; print_R($data['ins']);"</pre>";
	//exit;
	
		 $temp=$data['ins'];
		
			 for($i=0;$i<count($temp);$i++){
				 
			      // print_r($temp[$i]);
					$temp[$i]['inserted_date']=$data['for_month_year']." 10:00:11";
					$temp[$i]['inserted_by']=$this->session->userdata('uid');
					 //first check the income is already available for selected month and year
					 $sql1="select * from employee_income_detail where emp_id='".$temp[$i]['emp_id']."' and date(inserted_date)='".$data['for_month_year']."'";
				      // $sql1="select * from employee_income_detail where emp_id='".$temp[$i]['emp_id']."'";
					 //echo $sql1;
					
					  $query1=$this->db->query($sql1);
					  $res1=$query1->result_array();
					  if(empty($res1)){
						  // print_r($temp[$i]);						    
						 $this->db->insert('employee_income_detail',$temp[$i]); 
						/* echo $this->db->last_query();
						 exit; */
                      $inscnt++;						 
					  }else{	
                      //   $val['emp_id']=$temp[$i]['emp_id'];					  
                      //   $val['ename']=$temp[$i]['ename'];					  
                         $val['DA']=$temp[$i]['DA'];					  
                         $val['HRA']=$temp[$i]['HRA'];					  
                         $val['TA']=$temp[$i]['TA'];					  
                         $val['Incom_Diff']=$temp[$i]['Incom_Diff'];					  
                         $val['otherinc']=$temp[$i]['otherinc'];	
$val['DP']=$temp[$i]['DP'];							 
                         $val['updated_by']=$this->session->userdata('uid');				  
                        $this->db->where('emp_id',$temp[$i]['emp_id']);					  
                        $this->db->where('month(inserted_date)',date('m',strtotime($data['for_month_year'])));					  
					    $this->db->where('year(inserted_date)',date('Y',strtotime($data['for_month_year'])));		
					$this->db->update('employee_income_detail',$val);
					//echo $this->db->last_query();
                       /* exit;  */						
                       $updcnt++;						
					  }	
					  
			   }	 
	
		 /* echo $updcnt;
		 echo $inscnt;
		exit; */
		return true;		
	}
	
	public function getEmpListForDeductions($data){
			/* echo "<pre>"; print_R($data);"</pre>";
		exit; */
	//echo array_count_values($data);
 $sql="select e.emp_id,e.emp_reg,e.fname,e.mname,e.lname,e.gender,dd.*  from employee_transaction_details  as dd
		 join employee_master as e on e.emp_id=dd.emp_id and e.emp_status='Y'	
where dd.is_final_status ='Y' and month(dd.month_of) ='".$data['mn']."' and year(dd.month_of)='".$data['dt']."'  order by e.emp_id ASC";
		
	$query=$this->db->query($sql);
	$res=$query->result_array();
      /* print_R($res);
     die();	  */ 
	 return $res;
	}
	
	public function add_staff_deductions_details($data){
	//echo "<pre>";	
	// print_r($data);
	// echo "<pre>";
		//echo count($data['ins']);
	// print_r($data['ins']);
	//exit; 
	$inscnt=0;$updcnt=0;
	$temp=$data['ins'];
		
			 for($i=0;$i<count($temp);$i++){
			 /* $temp[$i]['inserted_date']=$data['for_month_year']." 10:00:11";
			  $temp[$i]['inserted_by']=$this->session->userdata('uid');	 
			   $sql1="select * from employee_monthwise_deduction where emp_id='".$temp[$i]['emp_id']."' and date(inserted_date)='".$data['for_month_year']."'";	 
                $query=$this->db->query($sql1);
                $res=$query->result_array();
              if(empty($res)){
				$this->db->insert('employee_monthwise_deduction',$temp[$i]);
                $inscnt++;				
			  }else{	
                         $val['emp_id']=$temp[$i]['emp_id'];					  
                         $val['ename']=$temp[$i]['ename'];					  
                         $val['TDS']=$temp[$i]['TDS'];					  
                         $val['Mobile_Bill']=$temp[$i]['Mobile_Bill'];					  
                         $val['Off_Adv']=$temp[$i]['Off_Adv'];                        		  
                         $val['Society_Charg']=$temp[$i]['Society_Charg'];					  
                         $val['Other_Deduct']=$temp[$i]['Other_Deduct'];
						$val['Difference']=$temp[$i]['Difference'];					  
                         $val['Arrears']=$temp[$i]['Arrears'];							 
                         $val['updated_by']=$this->session->userdata('uid');				  
                        $this->db->where('emp_id',$temp[$i]['emp_id']);					  
                        $this->db->where('date(inserted_date)',$data['for_month_year']);					  
						$this->db->update('employee_monthwise_deduction',$val); */
				//	echo $this->db->last_query();
                       /* exit;  */						
                     /*  $updcnt++;						
					  }	*/
//for transaction details
$fld_array= array('TDS','Mobile_Bill','Bus-fare','Off_Adv','Society_Charg','Other_Deduct','Difference','Arrears');
foreach($fld_array as $val){
if($temp[$i][$val]!=''){
	
$sql1="select * from employee_transaction_details where emp_id='".$temp[$i]['emp_id']."' and  trans_of ='".$val."'   and date(month_of)='".$data['for_month_year']."'";	 
                $query=$this->db->query($sql1);
                $res=$query->result_array();
				
				$val1=array();
				$val2=array();
if(count($res) == '0'){
	//insert
	$val1['emp_id']=$temp[$i]['emp_id'];
	if($val == 'Difference' || $val == 'Arrears'){
		$val1['trans_type']='DC';
	}else{
	$val1['trans_type']='CR';
	}
	$val1['trans_of']=$val;
	$val1['amount']=$temp[$i][$val];
	$val1['month_of']=$data['for_month_year'];
	$val1['deducted_on']=date('Y-m-d');
	$val1['deducted_by']=$this->session->userdata('uid');
	$this->db->insert('employee_transaction_details',$val1);
              
	
}else{
	//update
//echo "kk";	
	$val2['amount']=$temp[$i][$val];	
	$val2['updated_on']=date('Y-m-d');
	$val2['updated_by']=$this->session->userdata('uid');
	$this->db->where('tran_id',$res[0]['tran_id']);			
	 $this->db->update('employee_transaction_details',$val2);
	//echo $this->db->last_query();
	//exit;
	$updcnt++;
}
}
}
					  
			}
			return true;
		
	}
	
	public function getEmpSalForMonth($data,$emp){
		//print_r($emp);
		for($i=0;$i<count($emp);$i++){
			//echo $emp[$i]['emp_id']."-";
			//first get all income details and deductions
		/* $sql="select e.emp_id,e.fname,e.mname,e.lname,c.college_name,d.department_name,count(p.status), i.DA,i.HRA,i.TA,i.Incom_Diff,i.otherinc,i.DP, dd.TDS,dd.Mobile_Bill,dd.Off_Adv,dd.Society_Charg,dd.Other_Deduct from employee_master as e 
left join employee_income_detail as i on i.emp_id=e.emp_id 
left join employee_monthwise_deduction as dd on dd.emp_id=e.emp_id 
left join college_master as c on c.college_id=e.emp_school 
left join punching_backup as p on p.UserId=e.emp_id
left join department_master as d on d.department_id=e.department 
where month(dd.inserted_date)='".$data['mn']."' and year(dd.inserted_date)='".$data['dt']."' and year(i.inserted_date)='".$data['dt']."' and p.status IN('present', 'outduty') and  e.emp_id='".$emp[$i]['emp_id']."' and month(p.updated_date)='1' and year(p.updated_date)='2017'"; */
		//echo $sql;
		//exit;
		$sql1="select e.emp_id,e.epf_apply,e.pf_status,e.gratuity_status,e.fname,e.mname,e.lname,e.gender,eo.allowance,es.basic_sal as basic_salary,es.da,es.dp,es.hra,es.ta,es.difference,es.other_allowance,es.allowance,es.special_allowance,es.scaletype from employee_master as e 
inner join employe_other_details as eo on eo.emp_id=e.emp_id 
inner join employee_salary_structure as es on es.emp_id=e.emp_id 
where   es.active_status='Y' and e.emp_id='".$emp[$i]['UserId']."' order by e.emp_id ASC";
		$query1=$this->db->query($sql1);
		$res1=$query1->result_array();
       if(!empty($res1)){
		$final[$i]=$res1[0];   
	   }		
				
	}
	if(!empty($final)){
	return $final;	
	}
	
	}
	public function get_salary_status_report($data,$emp){
		$ct = count($emp);
		for($i=0;$i<$ct;$i++){
			
		  $sql1="select e.emp_id,e.fname,e.mname,e.lname,e.department,e.date_of_birth,e.emp_school,ss.basic_sal as basic_salary,e.gender,e.designation,ss.pay_band_min,ss.pay_band_max,ss.pay_band_gt,ss.basic_sal,ss.allowance,eo.pan_no,eo.pf_no,eo.bank_acc_no,me.da,me.dp,me.hra,me.ta,me.difference,me.other_allowance,me.special_allowance,me.special_allowance,md.*,ms.* from employee_master as e 
 inner join employe_other_details as eo on eo.emp_id=e.emp_id 
inner join employee_monthly_salary as ms on ms.emp_id=e.emp_id 
inner join employee_salary_structure as ss on ss.emp_id=e.emp_id 
inner join employee_monthwise_deduction as md on md.emp_id=e.emp_id
inner join employee_monthwise_earning as me on me.emp_id=e.emp_id
where e.emp_status='Y' and month(ms.for_month_year)='".$data['mn']."' and year(ms.for_month_year)='".$data['dt']."' and  e.emp_id='".$emp[$i]['emp_id']."' ";
	//exit;
	$query1=$this->db->query($sql1);
		$res1=$query1->result_array();
       if(!empty($res1)){
		$final[$i]=$res1[0];   
	   }		
				
	}
	if(!empty($final)){
	return $final;	
	}
	}
	public function getEmpSalForMonth_final($data, $emp,$reptype='') {
    $cnt = count($emp);
    $final = [];
    
    for ($i = 0; $i < $cnt; $i++) {
         $sql1 = "SELECT CASE WHEN e.staff_type = '3' THEN '3' ELSE 1 END AS staff_type, e.emp_id, e.fname, e.mname, e.lname, e.department, e.emp_school, ss.basic_sal AS basic_salary, e.gender, e.designation, ss.pay_band_min, ss.pay_band_max, ss.pay_band_gt, ss.basic_sal, ss.allowance, eo.pan_no, eo.pf_no, eo.bank_acc_no, me.da, me.dp, me.hra, me.ta, me.difference,e.date_of_birth, me.other_allowance, me.special_allowance,md.*, ms.* 
                FROM employee_master AS e 
                INNER JOIN employe_other_details AS eo ON eo.emp_id = e.emp_id 
                INNER JOIN employee_monthly_salary AS ms ON ms.emp_id = e.emp_id 
                INNER JOIN employee_monthwise_deduction AS md ON md.emp_id = e.emp_id 
                INNER JOIN employee_monthwise_earning AS me ON me.emp_id = e.emp_id 
                INNER JOIN employee_salary_structure AS ss ON ss.emp_id = e.emp_id 
                WHERE e.emp_status = 'Y' 
                AND ss.active_status = 'Y' 
                AND month(md.for_month) = '".$data['mn']."' 
                AND year(md.for_month) = '".$data['dt']."' 
                AND month(me.for_month) = '".$data['mn']."' 
                AND year(me.for_month) = '".$data['dt']."' 
                AND month(ms.for_month_year) = '".$data['mn']."' 
                AND year(ms.for_month_year) = '".$data['dt']."' 
                AND e.emp_id = '".$emp[$i]['emp_id']."'";

        $query1 = $this->db->query($sql1);
        $res1 = $query1->result_array();
        if (!empty($res1)) {
            $final[] = $res1[0];   
        }        
    }

    if (!empty($final)) {
        // Sort the $final array by 'total_deduct' in descending order
		if($reptype=='salary_tds'){
			usort($final, function($a, $b) {
				return $b['TDS'] - $a['TDS'];
			});
		}else if($reptype=='salary_ptax'){
			usort($final, function($a, $b) {
				return $b['ptax'] - $a['ptax'];
			});
		}else if($reptype=='salary_soc'){
			usort($final, function($a, $b) {
				return $b['co_op_society'] - $a['co_op_society'];
			});
		}else if($reptype=='salary_epf'){
			usort($final, function($a, $b) {
				return $b['epf'] - $a['epf'];
			});
		}
        return $final;   
    }
}
public function getEmpSalForMonth_final_report($data, $emp,$reptype='') {
    $cnt = count($emp);
    $final = [];
    
    for ($i = 0; $i < $cnt; $i++) {
         $sql1 = "SELECT CASE WHEN e.staff_type = '3' THEN '3' ELSE 1 END AS staff_type,e.date_of_birth, e.emp_id, e.fname, e.mname, e.lname, e.department, e.emp_school, ss.basic_sal AS basic_salary, e.gender, e.designation, ss.pay_band_min, ss.pay_band_max, ss.pay_band_gt, ss.basic_sal, ss.allowance, eo.pan_no, eo.pf_no, eo.bank_acc_no, me.da, me.dp, me.hra, me.ta, me.difference, me.other_allowance, me.special_allowance,md.*, ms.* 
                FROM employee_master AS e 
                INNER JOIN employe_other_details AS eo ON eo.emp_id = e.emp_id 
                INNER JOIN employee_monthly_salary AS ms ON ms.emp_id = e.emp_id 
                INNER JOIN employee_monthwise_deduction AS md ON md.emp_id = e.emp_id 
                INNER JOIN employee_monthwise_earning AS me ON me.emp_id = e.emp_id 
                INNER JOIN employee_salary_structure AS ss ON ss.emp_id = e.emp_id 
                WHERE  month(md.for_month) = '".$data['mn']."' 
                AND year(md.for_month) = '".$data['dt']."' 
                AND month(me.for_month) = '".$data['mn']."' 
                AND year(me.for_month) = '".$data['dt']."' 
                AND month(ms.for_month_year) = '".$data['mn']."' 
                AND year(ms.for_month_year) = '".$data['dt']."' 
                AND e.emp_id = '".$emp[$i]['emp_id']."'";

        $query1 = $this->db->query($sql1);
        $res1 = $query1->result_array();
        if (!empty($res1)) {
            $final[] = $res1[0];   
        }        
    }

    if (!empty($final)) {
        // Sort the $final array by 'total_deduct' in descending order
		if($reptype=='salary_tds'){
			usort($final, function($a, $b) {
				return $b['TDS'] - $a['TDS'];
			});
		}else if($reptype=='salary_ptax'){
			usort($final, function($a, $b) {
				return $b['ptax'] - $a['ptax'];
			});
		}else if($reptype=='salary_soc'){
			usort($final, function($a, $b) {
				return $b['co_op_society'] - $a['co_op_society'];
			});
		}else if($reptype=='salary_epf'){
			usort($final, function($a, $b) {
				return $b['epf'] - $a['epf'];
			});
		}
        return $final;   
    }
}
	function getDesignationById($id){
		$sql="SELECT designation_id,designation_code,designation_name FROM designation_master WHERE designation_id='$id' and status='Y'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	public function getAttendance($eid,$mn,$yr){
	$sql="SELECT total as pdays FROM employee_monthly_final_attendance WHERE UserId='$eid' and month(for_month_year)='$mn' and year(for_month_year)='$yr' ";
		$query1=$this->db->query($sql);
		$res1=$query1->result_array();
		return $res1[0]['pdays'];
	}
public function check_final_monthly_attendance($mon,$yer){
	/* $sql="SELECT * FROM employee_monthly_final_attendance WHERE is_final = 'Y' and month(for_month_year)='$mon' and year(for_month_year)='$yer' and Total!=0 group by UserId order by UserId ASC "; */
	$sql="SELECT * FROM employee_monthly_final_attendance f join employee_master e on e.emp_id=f.UserId WHERE  f.is_final = 'Y' and month(f.for_month_year)='$mon' and year(f.for_month_year)='$yer' and f.Total!=0 and e.emp_status='Y' group by f.UserId order by f.UserId ASC ";
		$query1=$this->db->query($sql);
		$res1=$query1->result_array();
		return $res1;
}
 public function addEmp_monthly_sal($temp){
	 //print_r($temp);
	 //exit;
	   for($i=0;$i<count($temp);$i++){
		   //first check available in employee_monthly_salary
		   $d = date_parse_from_format("Y-m-d", $temp[$i]['for_month_year']);     
           $msearch=$d["month"];
		   //echo "month".$msearch;
           $ysearch=$d["year"];
		   //echo "year".$ysearch;
		   $sql1="select * from employee_monthly_salary where emp_id='".$temp[$i]['emp_id']."' and month(for_month_year)='$msearch' and year(for_month_year)='$ysearch'";
           //echo $sql1;	
		  $query1=$this->db->query($sql1);
		   $res1=$query1->result_array();
		   if(empty($res1)){
			  // echo"in insert";
			  $temp[$i]['inserted_date']=date('Y-m-d h:m:i');
		$temp[$i]['inserted_by']=$this->session->userdata("uid");
			
			  $inserted[$i]=$this->db->insert('employee_monthly_salary',$temp[$i]);  
//echo $this->db->last_query();	
//exit;		   
		   }elseif(!empty($res1)){
			  // echo"in update";
			  $temp[$i]['updated_date']=date('Y-m-d h:m:i');
		$temp[$i]['updated_by']=$this->session->userdata("uid");
			
			    $this->db->where('emp_id',$temp[$i]['emp_id']);					  
                $updated[$i]=$this->db->update('employee_monthly_salary',$temp[$i]);
			   //echo $this->db->last_query();
		   }		 
	   }
	  /* print_R($inserted);echo"<br>";print_R($updated);
	  exit;  */
	  if(!empty($inserted)||!empty($updated)){
		  return true;
	  }
	   
   }

function addEmp_monthly_sal_earnings($temp){
	
	 for($i=0;$i<count($temp);$i++){
		   //first check available in employee_monthly_salary
		   $d = date_parse_from_format("Y-m-d", $temp[$i]['for_month']);     
           $msearch=$d["month"];
		   //echo "month".$msearch;
           $ysearch=$d["year"];
		   //echo "year".$ysearch;
		   $sql1="select * from employee_monthwise_earning where emp_id='".$temp[$i]['emp_id']."' and month(for_month)='$msearch' and year(for_month)='$ysearch'";
          // echo $sql1;		  
		  $query1=$this->db->query($sql1);
		   $res1=$query1->result_array();
		   if(empty($res1)){
			  // echo"in insert";
			  $temp[$i]['inserted_date']=date('Y-m-d h:m:i');
		$temp[$i]['inserted_by']=$this->session->userdata("uid");
			  $inserted[$i]=$this->db->insert('employee_monthwise_earning',$temp[$i]);  
          // echo $this->db->last_query();			  
		   }elseif(!empty($res1)){
			  // echo"in update";
			  unset($temp[$i]['epf']);
			  $temp[$i]['updated_date']=date('Y-m-d h:m:i');
		$temp[$i]['updated_by']=$this->session->userdata("uid");
			    $this->db->where('ded_id',$res1[0]['ded_id']);					  
                $updated[$i]=$this->db->update('employee_monthwise_earning',$temp[$i]);
			   //echo $this->db->last_query();
		   }
		 
	   }
	  /* print_R($inserted);echo"<br>";print_R($updated);
	  exit;  */
	  if(!empty($inserted)||!empty($updated)){
		  return true;
	  }
	   
}
function addEmp_monthly_sal_deduction($temp){
	 for($i=0;$i<count($temp);$i++){
		   //first check available in employee_monthly_salary
		   $d = date_parse_from_format("Y-m-d", $temp[$i]['for_month']);     
           $msearch=$d["month"];
		   //echo "month".$msearch;
           $ysearch=$d["year"];
		   //echo "year".$ysearch;
		   $sql1="select * from employee_monthwise_deduction where emp_id='".$temp[$i]['emp_id']."' and month(for_month)='$msearch' and year(for_month)='$ysearch'";
          // echo $sql1;		  
		  $query1=$this->db->query($sql1);
		   $res1=$query1->result_array();
		   if(empty($res1)){
			  // echo"in insert";
			   $temp[$i]['inserted_date']=date('Y-m-d h:m:i');
		$temp[$i]['inserted_by']=$this->session->userdata("uid");
			  $inserted[$i]=$this->db->insert('employee_monthwise_deduction',$temp[$i]);  
				//echo $this->db->last_query();exit;
		   
		   }elseif(!empty($res1)){
			  // echo"in update";
			  $temp[$i]['updated_date']=date('Y-m-d h:m:i');
		$temp[$i]['updated_by']=$this->session->userdata("uid");
			
			    $this->db->where('ded_id',$res1[0]['ded_id']);					  
                $updated[$i]=$this->db->update('employee_monthwise_deduction',$temp[$i]);
			  // echo $this->db->last_query();
		   }
		 
	   }
	  /* print_R($inserted);echo"<br>";print_R($updated);
	  exit;  */
	  if(!empty($inserted)||!empty($updated)){
		  return true;
	  }
	   
}
 //basic salary section
   function fetchAllEmpBasicSal(){
	    $this->db->select('e.emp_id as em_emp_id,e.emp_reg,e.fname,e.lname,e.gender,eo.bank_acc_no,eo.pan_no,e.joiningDate,s.college_code,de.department_name,ds.designation_name,
		e.staff_type,bs.scaletype as scaletype1,bs.*');
	   $this->db->from('employee_master as e');
	   $this->db->join('college_master as s','s.college_id = e.emp_school','left');
		$this->db->join('designation_master as ds','ds.designation_id = e.designation','left');
		$this->db->join('department_master as de','de.department_id = e.department','left');
	   $this->db->join('employee_salary_structure as bs','bs.emp_id=e.emp_id AND bs.active_status="Y"','left');
	    $this->db->join('employe_other_details as eo','e.emp_id=eo.emp_id','left');
	     // $this->db->where('bs.active_status','Y');
		   $this->db->where('e.emp_status','Y');
		   $this->db->where('e.emp_reg','N');
		 $this->db->order_by('bs.emp_id','asc');
	   $query=$this->db->get();
	   $res=$query->result_array();
	  //echo $this->db->last_query(); exit;
	   return $res;
   }
   function fetchEmpBasicSalByempid($empid,$s=''){
	    $this->db->select('*');
	   $this->db->from('employee_salary_structure');	  
		  $this->db->where('emp_id',$empid);
if($s != ''){
		 $this->db->where('active_status',$s);	
		 }	
		 $this->db->order_by('sal_structure_id','DESC');
	   $query=$this->db->get();
	   $res=$query->result_array();
	   return $res;
   }
   function getEmpBasic_Sal($id){
	   $this->db->select('e.emp_id as em_emp_id,e.fname,e.lname,e.gender,s.college_name,e.joiningDate,ds.designation_name,de.department_name,ss.*');
	 
	   $this->db->from('employee_master as e');	   
	      $this->db->join('employee_salary_structure as ss','e.emp_id=ss.emp_id','left');
	   $this->db->join('college_master as s','s.college_id = e.emp_school','left');
		$this->db->join('designation_master as ds','ds.designation_id = e.designation','left');
		$this->db->join('department_master as de','de.department_id = e.department','left');
		//$this->db->where('ss.sal_structure_id',$id);
		$this->db->where('ss.active_status','Y');
		$this->db->where('e.emp_id',$id);
	   $query=$this->db->get();
	   $res=$query->result_array();
	   return $res;	  
	   
   }
   
   function addStaffBasicSalary($data){
	  // print_r($_POST);exit;
	   /*staff other sal details*/
        $income['emp_id']=(stripcslashes($data['employee']));	
       // $income['ename']=(stripcslashes($data['fname']))." ".(stripcslashes($data['mname']))." ".(stripcslashes($data['lname']));
		$income['joiningDate']=(stripcslashes($data['joiningDate']));
		$income['school_id']=(stripcslashes($data['emp_school'])); 
		$income['department_id']=(stripcslashes($data['department'])); 
		$income['DA']=(stripcslashes($data['staff_da']));
		$income['HRA']=(stripcslashes($data['staff_hra']));
		$income['TA']=(stripcslashes($data['staff_ta']));
		$income['Incom_Diff']=(stripcslashes($data['staff_indiff']));
		$income['otherinc']=(stripcslashes($data['staff_otherincm']));
		$income['DP']=(stripcslashes($data['staff_dp']));
		$income['for_month_year']=(stripcslashes($data['for_month_year']))."-01"."-01";
		$income['inserted_by']=$this->session->userdata('uid');
		$income['inserted_date']=date('Y-m-d h:i:s');
		/*end other sal details */
		//print_r($income);exit;
		/****Fourth Part for other sal info**///
		$insert_id33 =$this->db->insert('employee_basic_salary_details',$income);
		$fetch_id33=$this->db->insert_id();
		/* echo $this->db->last_query();
	echo $fetch_id33;
	exit; */
	if(!empty($fetch_id33)&&$fetch_id33!=0){
		$sql="update employee_master set basic_sal_allocation='Y' where emp_id='".$income['emp_id']."'";
			$query=$this->db->query($sql);
		return true;
	}
   }
 function updateStaffBasicSalary($data){
//print_r($data);
	//exit;
		 /*satff other sal details*/
if($data['act_type']=='up'){		 
		$income['da']=(stripcslashes($data['staff_da']));
		$income['hra']=(stripcslashes($data['staff_hra']));
		$income['ta']=(stripcslashes($data['staff_ta']));
		$income['difference']=(stripcslashes($data['staff_indiff']));
		$income['other_allowance']=(stripcslashes($data['staff_otherincm']));
		$income['dp']=(stripcslashes($data['staff_dp']));

		$income['scaletype']=(stripcslashes($data['scaletype']));	
   $income['basic_sal']=(stripcslashes($data['basic_sal']));	
    $income['allowance']=(stripcslashes($data['special_allowance']));	
    $income['pay_band_min']=(stripcslashes($data['pay_min']));	
    $income['pay_band_max']=(stripcslashes($data['pay_max']));	
  $income['pay_band_gt']=(stripcslashes($data['pay_band_gt']));	
  $income['other_pay']=(stripcslashes($data['other_pay']));	
  $income['gross_salary']=(stripcslashes($data['gross_salary']));	
  $income['special_allowance']=(stripcslashes($data['special_allowance']));	
}
		$income['modified_by']=$this->session->userdata('uid');
		$income['modified_on']=date('Y-m-d H:i:s');
		if($data['act_type']=='iup'){
		$income['active_status']='N';
			
		}else{
		$income['active_status']='Y';
		}
		//echo '<pre>';print_r($income);exit;
		/*end other sal details */
		//for other sal info of employee
		 $this->db->where('sal_structure_id',$data['sal_structure_id']);
		 $res4=$this->db->update('employee_salary_structure',$income);
		/*  echo $this->db->last_query();
		 exit; */
		 
		 if($data['act_type']=='iup'){
			 $income['emp_id']=(stripcslashes($data['emp_id']));	
    $income['scaletype']=(stripcslashes($data['scaletype']));	
   $income['basic_sal']=(stripcslashes($data['basic_sal']));	
    $income['allowance']=(stripcslashes($data['special_allowance']));	
    $income['pay_band_min']=(stripcslashes($data['pay_min']));	
    $income['pay_band_max']=(stripcslashes($data['pay_max']));	
  $income['pay_band_gt']=(stripcslashes($data['pay_band_gt']));	
  $income['other_pay']=(stripcslashes($data['other_pay']));	
  $income['gross_salary']=(stripcslashes($data['gross_salary']));	
  $income['special_allowance']=(stripcslashes($data['special_allowance']));	
  
			 $income['da']=(stripcslashes($data['staff_da']));
		$income['hra']=(stripcslashes($data['staff_hra']));
		$income['ta']=(stripcslashes($data['staff_ta']));
		$income['difference']=(stripcslashes($data['staff_indiff']));
		$income['other_allowance']=(stripcslashes($data['staff_otherincm']));
		$income['dp']=(stripcslashes($data['staff_dp']));
       $income['created_by']=$this->session->userdata('uid');
		$income['created_on']=date('Y-m-d h:i:s');
		$income['active_status']='Y';
		/*end other sal details */
		//print_r($income);exit;
		/****Fourth Part for other sal info**///
		$insert_id33 =$this->db->insert('employee_salary_structure',$income);
		 $this->db->last_query();
		 $fetch_id33=$this->db->insert_id();
		//exit;
		 }
	 if(!empty($res4)&&$res4!=0){	 
		 
		return true;
	}
 }
 function getEmployeeListForBasicSalary($sid,$did){
	 $this->db->select('e.emp_id,e.fname,e.mname,e.lname');
     $this->db->from('employee_master as e');
	 $this->db->where('e.emp_school',$sid);
	 $this->db->where('e.department',$did);
	 $this->db->where('e.basic_sal_allocation','N');
	 $query=$this->db->get();
	// echo $this->db->last_query();
	 $res=$query->result_array();
	 return $res;	 
	   
   }  
	function check_emp_deduction_bydate($empid,$typ,$dof,$fdate,$tdate){

		$ldate =array();
$sql = "SELECT * FROM employee_transaction_auto WHERE emp_id='$empid' AND `trans_type` = '$typ' AND `trans_of` = '$dof' and active = 'Y' ";
		$query=$this->db->query($sql);
		$result=$query->result_array();

foreach ($result as $key => $value) {
	  
        $begin = new DateTime($value['valid_from']);      
        $end = new DateTime($value['valid_to'].' +1 day');    
$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

foreach($daterange as $date){
    $ldate[] = $date->format("d-m-Y");
}

}
$begin1 = new DateTime($fdate);      
        $end1 = new DateTime($tdate.' +1 day');    
$daterange1 = new DatePeriod($begin1, new DateInterval('P1D'), $end1);

foreach($daterange1 as $date1){
    if(in_array($date1->format("d-m-Y"),$ldate)){
    	return $cnt = '1';
    }else{
    	$cnt = '0';
    }
}
		return $cnt;		
	}
function add_monthly_deduction_auto($data){
//	print_r($data);
	//exit;
	date_default_timezone_set('Asia/Kolkata');
	
		foreach($data['emp_chk'] as $key=>$val){
		$data['emp_id'] = $val;
		
		//echo $key; echo $val;
		//exit;
        	$data['deduct_amt'] = 	$data['emp_amt_'.$val];
			if($data['frequency']=='1'){
				$data['valide_from'] = date('Y-m-d',strtotime($data['vfyear']."-".$data['vfmonth']."-01"));
			$data['valide_to'] = date('Y-m-d',strtotime($data['vfyear']."-".$data['vfmonth']."-01"));
	
			}else{
			$data['valide_from'] = date('Y-m-d',strtotime($data['vfyear']."-".$data['vfmonth']."-01"));
			$data['valide_to'] = date('Y-m-d',strtotime($data['vtyear']."-".$data['vtmonth']."-01"));
		}
	$income['trans_type']=(stripcslashes($data['type_of']));
		$income['trans_of']=(stripcslashes($data['deduct_of']));
		$income['emp_id']=(stripcslashes($data['emp_id']));
		$income['amount']=(stripcslashes($data['deduct_amt']));
		$income['frequency']=(stripcslashes($data['frequency']));
		$income['valid_from']=(stripcslashes($data['valide_from']));
		$income['valid_to']=(stripcslashes($data['valide_to']));
      
	   $income['created_by']=$this->session->userdata('uid');
		$income['created_on']=date('Y-m-d h:i:s');
		$income['active']='Y';
		/*end other sal details */
		//print_r($income);exit;
		/****Fourth Part for other sal info**///
		 $cnt = $this->check_emp_deduction_bydate($data['emp_id'],$income['trans_type'],$income['trans_of'],$data['valide_from'],$data['valide_to']);
		//exit;
		if($cnt==0){
		$insert_id33 =$this->db->insert('employee_transaction_auto',$income);
		//$this->db->last_query();
		 $res4=$this->db->insert_id();
		}else{
			$res4 = 'ard';
		}
			
	}	
	//echo $res4;
	// if(!empty($res4)&&$res4!=0){			 
		return $res4;
	//}
}
function update_monthly_deduction_auto($data){
	//print_r($data);
///exit;
	$val['active']='N';	
		 $this->db->where('trans_id',$data['deduct_id']);					  
         $updated=$this->db->update('employee_transaction_auto',$val);
			if($data['frequency']=='1'){  
			$data['valide_from'] = date('Y-m-d',strtotime($data['vfyear']."-".$data['vfmonth']."-01"));
	$data['valide_to'] = date('Y-m-d',strtotime($data['vfyear']."-".$data['vfmonth']."-01"));
	
			}else{
	$data['valide_from'] = date('Y-m-d',strtotime($data['vfyear']."-".$data['vfmonth']."-01"));
	$data['valide_to'] = date('Y-m-d',strtotime($data['vtyear']."-".$data['vtmonth']."-01"));
			}
	$income['trans_type']=(stripcslashes($data['deduct_typ']));
		$income['trans_of']=(stripcslashes($data['deduct_of']));
		$income['emp_id']=(stripcslashes($data['emp_id']));
		$income['amount']=(stripcslashes($data['deduct_amt']));
		$income['frequency']=(stripcslashes($data['frequency']));
		$income['valid_from']=(stripcslashes($data['valide_from']));
		$income['valid_to']=(stripcslashes($data['valide_to']));
     if($data['dis_status']=='Y'){
		 $income['active']='N';
	 }else{
		 $income['active']='Y';
	 }
	  if(!empty($data['dis_status'])){
	 $income['cancel_status']=(stripcslashes($data['dis_status']));
      }
	   $income['created_by']=$this->session->userdata('uid');
		$income['created_on']=date('Y-m-d h:i:s');
		
		/*end other sal details */
		//print_r($income);exit;
		/****Fourth Part for other sal info**///
		$insert_id33 =$this->db->insert('employee_transaction_auto',$income);
		 //echo $this->db->last_query();
//exit;
		 $res4=$this->db->insert_id();
	//	exit;

	 if(!empty($res4)&&$res4!=0){			 
		return true;
	}
}
    function get_employee(){
		 $this->db->select('e.emp_id,e.emp_reg,e.fname,e.mname,e.lname,e.gender,e.joiningDate,s.college_code,de.department_name');
     $this->db->from('employee_master as e');
	 $this->db->join('college_master as s','s.college_id = e.emp_school','inner');		
		$this->db->join('department_master as de','de.department_id = e.department','inner');
		
	 //$this->db->where('e.joiningDate <=',date('Y-m-d'));	
$this->db->where('e.emp_reg','N');	
$this->db->order_by('e.emp_id','ASC');	 
	 $query=$this->db->get();
	// echo $this->db->last_query();
	 $res=$query->result_array();
	 return $res;
	}
	function fetchAllEmpdeductionlist($mon=''){
		$tid ='';
		//echo $mon;
		if(!empty($mon)){
			$this->db->select('*');
			$this->db->from('employee_transaction_auto');
			 $this->db->where('active','Y');	
	 $this->db->where('cancel_status != ','Y');	

		$query=$this->db->get();
		//echo $this->db->last_query();
		$res=$query->result_array();

		//print_r($res);
		foreach($res as $val){
			 $fdt = date('d-m-Y',strtotime($val['valid_from']));
			 $tdt = date('d-m-Y',strtotime($val['valid_to']));
			//echo "</br>";
			$begin1 = new DateTime($fdt);      
        $end1 = new DateTime($tdt.' +1 day');    
$daterange1 = new DatePeriod($begin1, new DateInterval('P1M'), $end1);
//print_r($daterange1);
foreach($daterange1 as $date1){
	$dt = $date1->format('m-Y');
	//echo "mm".date('m-Y',strtotime('1-'.$mon));
	if($dt == date('m-Y',strtotime('1-'.$mon))){
		$tid .= $val['trans_id'];
		$tid .=",";
	}
}		
		}
		
		}
		//print_r($tid);
		$tid = substr($tid,0,-1);
		$this->db->select('e.fname,e.lname,e.gender,ed.*');
     $this->db->from('employee_transaction_auto as ed');
	  $this->db->join('employee_master as e','e.emp_id=ed.emp_id','inner');
	 $this->db->where('ed.active','Y');	
	 $this->db->where('ed.cancel_status','N');
//if(!empty($mon)){
	 $t_tid = trim($tid,"'");
	$ex_tid = explode(",", $t_tid);
	$tids = array_map('intval', $ex_tid);
	$this->db->where_in('ed.trans_id',$tids);
//}	 
 $this->db->order_by('emp_id','ASC');	 
	 $query=$this->db->get();
	 //echo $this->db->last_query();
	 //exit;
	 $res=$query->result_array();
	 return $res;
	}
	function fetchEmpDeductionDetails($did){
		$this->db->select('e.fname,e.lname,e.gender,ed.*');
     $this->db->from('employee_transaction_auto as ed');
	  $this->db->join('employee_master as e','e.emp_id=ed.emp_id','left');
	 $this->db->where('ed.active','Y');	 
	 $this->db->where('ed.trans_id',$did);
	 $query=$this->db->get();
	// echo $this->db->last_query();
	 $res=$query->result_array();
	 return $res;
	}
	function fetchEmpDeductionByempid($empid,$transof){
		$this->db->select('*');
     $this->db->from('employee_transaction_auto');	 
	 $this->db->where('emp_id',$empid);
	 $this->db->where('trans_of',$transof);
	 $this->db->order_by('trans_id','desc');
	 $query=$this->db->get();
	// echo $this->db->last_query();
	 $res=$query->result_array();
	 return $res;
	}
	
	function get_deduction_amount($empid,$typ_of,$mon){
		if($typ_of=='Mobile_Bill'){
		$this->db->select('sum(deduction_amount) as deduction_amount');
     $this->db->from('employee_mobile_bill');	 
	 $this->db->where('emp_id',$empid);
	 $this->db->where('for_month',date('Y-m-d',strtotime($mon)));
	$this->db->where('is_deleted','N');	
		  $this->db->where('active','Y');
		  $this->db->group_by('emp_id');
		$query1=$this->db->get();
	//echo $this->db->last_query();exit;
	 $res1=$query1->result_array();
	return $res_amt = $res1[0]['deduction_amount'];
		}elseif($typ_of=='TDS'){
			$this->db->select('*');
     $this->db->from('employee_tds_list');	 
	 $this->db->where('emp_id',$empid);
	 $this->db->where('for_month',date('Y-m-d',strtotime($mon."-01")));
	$this->db->where('is_deleted','N');	
		//  $this->db->where('active','Y');
		$query1=$this->db->get();
	//echo $this->db->last_query();
	 $res1=$query1->result_array();
	return $res_amt = $res1[0]['tds_amount'];
		}elseif($typ_of=='Bus-fare'){
			$this->db->select('*');
     $this->db->from('employee_bus_list');	 
	 $this->db->where('emp_id',$empid);
	 $this->db->where('active_from <=',date('Y-m-d',strtotime($mon."-01")));
	$this->db->where('is_deleted','N');	
		  $this->db->where('active','Y');
		$query1=$this->db->get();
	//echo $this->db->last_query();
	 $res1=$query1->result_array();
	return $res_amt = $res1[0]['bus_fare'];
		}elseif($typ_of=='Arrears'){
			$this->db->select('*');
			$this->db->from('employee_arrears_details');	 
			$this->db->where('emp_id',$empid);
			$this->db->where('for_month',date('Y-m-d',strtotime($mon."-01")));
			$this->db->where('is_deleted','N');	
			$query1=$this->db->get();
			$res1=$query1->result_array();
	      return $res_amt = $res1[0]['arr_amount'];
		}elseif($typ_of=='Society_Charg'){
			$this->db->select('*');
     $this->db->from('employee_society_details');	 
	 $this->db->where('emp_id',$empid);
	 $this->db->where('active_from <=',date('Y-m-d',strtotime($mon."-01")));
	$this->db->where('is_deleted','N');	
		  $this->db->where('active','Y');
		   $this->db->where('is_deleted','N');
		$query1=$this->db->get();
	//echo $this->db->last_query();
	 $res1=$query1->result_array();

     $soc_ch = $res1[0]['soc_amount'];

$this->db->select('*');
     $this->db->from('employee_society_loan');	 
	 $this->db->where('emp_id',$empid);
	 $this->db->where('from_month <=',date('Y-m-d',strtotime($mon."-01")));
$this->db->where('to_month >=',date('Y-m-d',strtotime($mon."-01")));
$this->db->where('active','Y');
		   $this->db->where('is_deleted','N');
		   $query2=$this->db->get();
	//echo $this->db->last_query();
	 $res2=$query2->result_array();

	return $res_amt = $res1[0]['soc_amount']+$res2[0]['monthly_deduction'];
		}else{
	  $this->db->select('*');
     $this->db->from('employee_transaction_details');	 
	 $this->db->where('emp_id',$empid);
	 $this->db->where('trans_of',$typ_of);
		 $this->db->where('month_of',$mon);
		  $this->db->where('status','Y');
		$query1=$this->db->get();
	//echo $this->db->last_query();
	 $res1=$query1->result_array();
	 $res_amt = $res1[0]['amount'];
//	 print_r($res1[0]['amount']);
	 if(empty($res_amt)){
	   $d = $this->check_emp_deduction_bymon($empid,$typ_of,$mon);
		//exit;
		$this->db->select('*');
     $this->db->from('employee_transaction_auto');	 
	 $this->db->where('emp_id',$empid);
	 $this->db->where('trans_of',$typ_of);
	 $this->db->where('trans_id',$d);
	  $this->db->where('cancel_status','N');
	   $this->db->where('active','Y');
	 $query=$this->db->get();
	//echo $this->db->last_query();
	 $res=$query->result_array();
$res_amt = $res[0]['amount'];
	 }
	}
	 return $res_amt;
		
	}
	function check_emp_deduction_bymon($empid,$dof,$date){
		//echo $date;
$y = date('Y',strtotime($date));
		$ldate =array();
 $sql = "SELECT * FROM employee_transaction_auto WHERE emp_id='$empid' AND trans_of = '$dof' and ( year(valid_from) = '$y' OR year(valid_to) = '$y') and active = 'Y' ";
		$query=$this->db->query($sql);
		$result=$query->result_array();
//echo $this->db->last_query();
foreach ($result as $key => $value) {
	 // echo $value['valid_from'];
        $begin = new DateTime($value['valid_from']);      
        $end = new DateTime($value['valid_to'].' +1 day');    
$daterange = new DatePeriod($begin, new DateInterval('P1M'), $end);

foreach($daterange as $date1){
    $ldate[$value['trans_id']][] = $date1->format("m-Y");
}

}


foreach($ldate as $key=>$date2){
	foreach($date2 as $date1){
    if(date("m-Y",strtotime($date))==$date1){
		//$id = array_search(date("m-Y",strtotime($date)),$date1,true);
    	return $cnt = $key;
    }else{
    	$cnt = '0';
    }
}
}
		return $cnt;		
	}
	
	function get_transaction_detail_amount($empid,$typ_of,$mon){
		//echo $empid;
		//exit;
		$this->db->select('amount');
     $this->db->from('employee_transaction_details');	 
	 $this->db->where('emp_id',$empid);
	 $this->db->where('trans_of',$typ_of);
	 $this->db->where('month_of',$mon);
	 $query=$this->db->get();
	//echo $this->db->last_query();
	 $res=$query->result_array();
	 return $res[0]['amount'];
	}
	function check_monthly_earning_deduction($mon,$yer){
	$sql1="select * from employee_master as e  
inner join employee_monthwise_deduction as md on md.emp_id=e.emp_id
inner join employee_monthwise_earning as me on me.emp_id=e.emp_id
where  month(md.for_month)='".$mon."' and year(md.for_month)='".$yer."' and month(me.for_month)='".$mon."' and year(me.for_month)='".$yer."'  ";
	//exit;
	$query1=$this->db->query($sql1);
		return $res1=$query1->result_array();
	}
	
	function get_monthly_earning_deduction($mon,$yer){
	$sql1="select e.emp_id,e.fname,e.mname,e.lname,e.gender,e.designation,ss.pay_band_min,ss.pay_band_max,ss.pay_band_gt,ss.basic_sal as basic_salary,ss.allowance,me.da,me.dp,me.hra,me.ta,me.difference,me.other_allowance,me.special_allowance,me.special_allowance,ems.*,md.*,me.*,ss.scaletype from employee_master as e  
RIGHT join employee_monthwise_deduction as md on md.emp_id=e.emp_id
RIGHT  join employee_monthwise_earning as me on me.emp_id=e.emp_id
RIGHT  join employee_salary_structure as ss on ss.emp_id=e.emp_id 
RIGHT  join employee_monthly_salary as ems on ems.emp_id = e.emp_id and month(ems.for_month_year)='".$mon."' and year(ems.for_month_year)='".$yer."' 
RIGHT  join employee_monthly_final_attendance as efa on efa.UserId = e.emp_id

where ss.active_status='Y' and month(md.for_month)='".$mon."' and year(md.for_month)='".$yer."' and month(me.for_month)='".$mon."' and year(me.for_month)='".$yer."' group by e.emp_id order by e.emp_id ASC ";
	//exit;
	$query1=$this->db->query($sql1);
		return $res1=$query1->result_array();
	}
	function update_salary_status($data){
		//print_r($data);
		foreach($data['chk_emp'] as $val){
		$exp = explode("_",$val);
$val2['salary_ref_no']=$data['ref_no'];
		$val2['salary_paid_by']=$data['paid_by'];	
		$val2['remark']=$data['remark'];	
	$val2['updated_by']=$this->session->userdata('uid');
	$val2['updated_date']=date('Y-m-d h:i:s');
	$this->db->where('sid',$exp[1]);			
	 $uid = $this->db->update('employee_monthly_salary',$val2);
		}
		return $uid;
	}
	function insert_mobile_limit($data){
		//print_r($data);
		 $sql = "select * from employee_mobile_list where mobile = '".$data['mobile_no']."' and is_deleted = 'N' and  active = 'Y' ";
			$query = $this->db->query($sql);
        $scnt = $query->result_array();

        // $sql1 = "select * from employee_mobile_list where emp_id = '".$data['staffid']."' and is_deleted = 'N' and  active = 'Y' ";
		//	$query1 = $this->db->query($sql1);
       // $scnt1 = $query1->result_array();

			if(count($scnt)>0){
				return 're';
			}else{
			$mobbill['emp_id']=$data['staffid'];	
			$mobbill['mobile']=$data['mobile_no'];
			$mobbill['mobile_limit']=$data['amt_limt'];	
			$mobbill['allow_for_Deduct']=$data['dect_req'];	
			$mobbill['remark']=$data['remark'];	
			$mobbill['inserted_by']=$this->session->userdata("uid");
			$mobbill['inserted_on']=date("Y-m-d H:i:s");		
			$mobbill['active']='Y';
			$ins=$this->db->insert('employee_mobile_list',$mobbill);
			//echo $this->db->last_query();
			//exit;
		return $ins;	
			}		
	}
	function getAllMobileList($id=''){
			
	   $this->db->select('ml.*,em.fname,em.lname,em.gender,em.emp_school,em.department,em.designation');
		$this->db->from('employee_mobile_list as ml');
		$this->db->join('employee_master as em','em.emp_id = ml.emp_id','inner');
		$this->db->where('ml.active','Y');
		$this->db->where('is_deleted','N');
		$this->db->where('ml.allow_for_Deduct','Y');
		$this->db->order_by("em.emp_id", "asc");
if(!empty($id)){
	$this->db->where('mob_id',$id);
}		
		$query=$this->db->get();
//echo $this->db->last_query();
		return $result=$query->result_array();	
	}
	function getAllMobileList_dect(){
			
	   $this->db->select('ml.*,em.fname,em.lname,em.gender,em.emp_school,em.department,em.designation');
		$this->db->from('employee_mobile_list as ml');
		$this->db->join('employee_master as em','em.emp_id = ml.emp_id','LEFT');
		$this->db->where('ml.active','Y');
		$this->db->where('ml.allow_for_Deduct','Y');
		$this->db->where('is_deleted','N');
		$this->db->order_by("em.emp_id", "asc");
	
		$query=$this->db->get();
//echo $this->db->last_query();
		return $result=$query->result_array();	
	}
	function update_mobile_limit($data){
		//print_r($data);
		 $sql = "select * from employee_mobile_list where mobile = '".$data['mobile_no']."' and is_deleted = 'N' and mob_id != '".$data['mobile_id']."' and active = 'Y' ";
			$query = $this->db->query($sql);
        $scnt = $query->result_array();
			if(count($scnt)>0){
				return 're';
			}else{
			
			$mobbill['mobile']=$data['mobile_no'];
			$mobbill['mobile_limit']=$data['amt_limt'];	
			$mobbill['allow_for_Deduct']=$data['dect_req'];				
			$mobbill['modified_by']=$this->session->userdata("uid");
			$mobbill['modified_on']=date("Y-m-d H:i:s");			
			$this->db->where('mob_id',$data['mobile_id']);			
	 $up = $this->db->update('employee_mobile_list',$mobbill);
		//echo $this->db->last_query();
		//exit;
		return $up;	
			}		
	}
	function delete_mobile_limit($id){
		$this->db->set('is_deleted','Y');
			 $this->db->where('mob_id',$id);
          return  $this->db->update('employee_mobile_list');	
	}
	function get_mobile_limit_amount($mobno){
		$this->db->select('mobile_limit');
     $this->db->from('employee_mobile_list');	 
	 $this->db->where('mobile',$mobno);
	 $this->db->where('is_deleted','N');
	 $this->db->where('active','Y');
	 $query=$this->db->get();
	
	 $res=$query->result_array();
	// echo $this->db->last_query();
	 //exit;
	 return $res[0]['mobile_limit'];
		
	}
	function add_mobile_bill($data){
		//echo "<pre>";print_r($data);exit;
		foreach($data['mobileno'] as $val){
			$sql = "select * from employee_mobile_bill where mobile = '".$val."' and active = 'Y' and for_month = '".date('Y-m',strtotime($data['month']))."-01' ";
			$query = $this->db->query($sql);
        $scnt = $query->result_array();
			if(count($scnt)>0){
				foreach($scnt as $val1){
				if($data['amt_'.$val]>0 && $val1['bill_amount']>0){
				$mobbill['active'] = 'N';
				$mobbill['modified_by']=$this->session->userdata("uid");		
				$mobbill['modified_on']=date("Y-m-d H:i:s");			
			$this->db->where('mobile',$val);	
      $this->db->where('for_month',$data['month']."-01");				
	 $ins1 = $this->db->update('employee_mobile_bill',$mobbill);
$arr['emp_id'] = $data['empid_'.$val];
            $arr['mobile'] = $val;
//$arr['bill_amount'] = $data['amt_'.$val];
$arr['bill_amount'] = $data['currentcharges_'.$val];
$arr['deduction_amount'] = $data['det_'.$val];

$arr['monthly_charges'] = $data['monthlycharges_'.$val];
$arr['local'] = $data['local_'.$val];
$arr['std'] = $data['std_'.$val];
$arr['isd'] = $data['isd_'.$val];
$arr['gprs'] = $data['gprs_'.$val];
$arr['downloads'] = $data['downloads_'.$val];
$arr['conference_call_charges'] = $data['conferenceecallcharges_'.$val];
$arr['sms'] = $data['messagingcharges_'.$val];
$arr['grand_total'] = $data['grandtotal_'.$val];
$arr['roaming_charges'] = $data['roamingcharges_'.$val];
$arr['discount'] = $data['discount_'.$val];
$arr['other_credit_charges'] = $data['othercreditcharges_'.$val];
$arr['current_charges'] = $data['currentcharges_'.$val];
$arr['sgst'] = $data['sgst_'.$val];
$arr['cgst'] = $data['cgst_'.$val];
$arr['previous_balance'] = $data['previousbalance_'.$val];
$arr['for_month'] = $data['month']."-01";
$arr['inserted_by']= $this->session->userdata("uid");
$arr['inserted_on'] =	date("Y-m-d H:i:s");	
$ins = $this->db->insert('employee_mobile_bill',$arr);		

	}else{
		$mobbill['active'] = 'Y';
		$mobbill['bill_amount'] = $data['amt_'.$val];
		$mobbill['deduction_amount'] = $data['det_'.$val];
				$mobbill['modified_by']=$this->session->userdata("uid");		
				$mobbill['modified_on']=date("Y-m-d H:i:s");			
			$this->db->where('mobile',$val);	
      $this->db->where('for_month',$data['month']."-01");				
	 $ins = $this->db->update('employee_mobile_bill',$mobbill);
	}
}
			}else{
			$arr['emp_id'] = $data['empid_'.$val];
            $arr['mobile'] = $val;
$arr['bill_amount'] = $data['amt_'.$val];
$arr['deduction_amount'] = $data['det_'.$val];

$arr['monthly_charges'] = $data['monthlycharges_'.$val];
$arr['local'] = $data['local_'.$val];
$arr['std'] = $data['std_'.$val];
$arr['isd'] = $data['isd_'.$val];
$arr['gprs'] = $data['gprs_'.$val];
$arr['downloads'] = $data['downloads_'.$val];
$arr['conference_call_charges'] = $data['conferenceecallcharges_'.$val];
$arr['sms'] = $data['messagingcharges_'.$val];
$arr['grand_total'] = $data['grandtotal_'.$val];
$arr['roaming_charges'] = $data['roamingcharges_'.$val];
$arr['discount'] = $data['discount_'.$val];
$arr['other_credit_charges'] = $data['othercreditcharges_'.$val];
$arr['current_charges'] = $data['currentcharges_'.$val];
$arr['sgst'] = $data['sgst_'.$val];
$arr['cgst'] = $data['cgst_'.$val];
$arr['previous_balance'] = $data['previousbalance_'.$val];
$arr['for_month'] = $data['month']."-01";
$arr['inserted_by']= $this->session->userdata("uid");
$arr['inserted_on'] =	date("Y-m-d H:i:s");	
$ins = $this->db->insert('employee_mobile_bill',$arr);		
			}
}
   
		return $ins;
	}
	
	
	function update_mob_bill_update($data){
//print_r($data);exit;

foreach ($data['empmob'] as  $value) {
	$sql = "select * from employee_mobile_bill where mob_bill_id = '".$value."'  ";
			$query = $this->db->query($sql);
        $scnt = $query->result_array();

		$mobbill['active'] = 'N';
				$mobbill['modified_by']=$this->session->userdata("uid");		
				$mobbill['modified_on']=date("Y-m-d H:i:s");			
			$this->db->where('mob_bill_id',$value);	
      //$this->db->where('for_month',$data['month']."-01");				
	 $up = $this->db->update('employee_mobile_bill',$mobbill);

$arr['emp_id'] = $scnt[0]['emp_id'];
            $arr['mobile'] = $scnt[0]['mobile'];
$arr['bill_amount'] = $data['billamt_'.$value];
$arr['deduction_amount'] = $data['detamt_'.$value];

$arr['monthly_charges'] = $data['monthlycharges_'.$val];
$arr['local'] = $data['local_'.$val];
$arr['std'] = $data['std_'.$val];
$arr['isd'] = $data['isd_'.$val];
$arr['gprs'] = $data['gprs_'.$val];
$arr['downloads'] = $data['downloads_'.$val];
$arr['messaging_charges'] = $data['messagingcharges_'.$val];
$arr['conference_call_charges'] = $data['conferenceecallcharges_'.$val];
$arr['roaming_charges'] = $data['roamingcharges_'.$val];
$arr['discount'] = $data['discount_'.$val];
$arr['other_credit_charges'] = $data['othercreditcharges_'.$val];
$arr['current_charges'] = $data['currentcharges_'.$val];
$arr['tax'] = $data['tax_'.$val];
$arr['total_amount_due'] = $data['totalamountdue_'.$val];

$arr['for_month'] = $scnt[0]['for_month'];
$arr['inserted_by']= $this->session->userdata("uid");
$arr['inserted_on'] =	date("Y-m-d H:i:s");	
$ins = $this->db->insert('employee_mobile_bill',$arr);		

	}
	return $ins;
	}
	function getAllMobileBill($mon){
		$this->db->select('ml.mobile_limit,mb.*,em.fname,em.lname,em.gender,em.emp_school,em.department,em.designation');
		$this->db->from('employee_mobile_bill as mb');
		$this->db->join('employee_master as em','em.emp_id = mb.emp_id','left');
		$this->db->join('employee_mobile_list as ml','ml.mobile = mb.mobile','left');
		$this->db->where('ml.is_deleted','N');
		$this->db->where('mb.active','Y');
		$this->db->where('ml.active','Y');
		$this->db->group_by("mb.mobile");
		$this->db->order_by("em.emp_id", "asc");
if(!empty($mon)){
	$this->db->where('mb.for_month',$mon.'-01');
}		
		$query=$this->db->get();
//echo $this->db->last_query();
		return $result=$query->result_array();	
	}
	function add_bus_fare($data){
		//print_r($data);
$sql = "select * from employee_bus_list where active = 'Y' and is_deleted ='N' ";
			$query = $this->db->query($sql);
        $scnt = $query->result_array();
        $scnt1 = $query->num_rows();

        if($scnt1 >= 0){
		//$query->num_rows();
		$busfare['emp_id']=$data['staffid'];	
			$busfare['boarding_point']=$data['boarding_point'];
			$busfare['bus_fare']=$data['amt'];	
            $busfare['active_from']=$data['active_form']."-01";			
			$busfare['inserted_by']=$this->session->userdata("uid");
			$busfare['inserted_on']=date("Y-m-d H:i:s");		
			$busfare['active']='Y';
			$ins=$this->db->insert('employee_bus_list',$busfare);
			//echo $this->db->last_query();
			//exit;
		return $ins;
	}else{
		return 'ex';
	}
	}
	function getBusFareList(){
		$this->db->select('bl.*,em.fname,em.lname,em.gender,em.emp_school,em.department,em.designation');
		$this->db->from('employee_bus_list as bl');
		$this->db->join('employee_master as em','em.emp_id = bl.emp_id','inner');
		$this->db->where('bl.is_deleted','N');
		$this->db->order_by("em.emp_id", "asc");	
		$query=$this->db->get();
//echo $this->db->last_query();
		return $result=$query->result_array();	
	}
	function getBusfareByID($id){
		$this->db->select('bl.*,em.fname,em.lname,em.gender,em.emp_school,em.department,em.designation');
		$this->db->from('employee_bus_list as bl');
		$this->db->join('employee_master as em','em.emp_id = bl.emp_id','inner');
		$this->db->where('bl.bus_id',$id);		
		$query=$this->db->get();
//echo $this->db->last_query();
		return $result=$query->result_array();	
	}
	function updatebusfare($data){

			$busfare['active']	= 'N';
			$busfare['is_deleted']='Y';	
			$busfare['modified_by']=$this->session->userdata("uid");		
				$busfare['modified_on']=date("Y-m-d H:i:s");
			$this->db->where('bus_id',$data['bus_id']);	
    				
	 $up = $this->db->update('employee_bus_list',$busfare);


	 	$busfare1['emp_id']=$data['staffid'];	
			$busfare1['boarding_point']=$data['boarding_point'];
			$busfare1['bus_fare']=$data['amt'];	
            $busfare1['active_from']=$data['active_form']."-01";			
			$busfare1['inserted_by']=$this->session->userdata("uid");
			$busfare1['inserted_on']=date("Y-m-d H:i:s");		
			$busfare1['active']='Y';
			$ins=$this->db->insert('employee_bus_list',$busfare1);

	 return $ins;
	}
	function delete_busfare($bid){
			$busfare['is_deleted']='Y';	
$busfare['modified_by']=$this->session->userdata("uid");		
				$busfare['modified_on']=date("Y-m-d H:i:s");				
			$this->db->where('bus_id',$bid);	
    				
	 $ins = $this->db->update('employee_bus_list',$busfare);
	 return $ins;
	}
	function add_society($data){
		//print_r($data);exit;
		foreach ($data['staffid'] as $value) {
			# code...
		
		$sql = "select * from employee_society_details where emp_id= '".$value."'  and active = 'Y' and is_deleted ='N' ";
			$query = $this->db->query($sql);
        $scnt = $query->result_array();
        $scnt1 = $query->num_rows();
 if($scnt1 > 0){
 //return 'ex';
 	$ins = 'e';
 }else{

 	$sql1 = "select * from employee_society_details where emp_id= '".$value."'  and active = 'Y' and is_deleted ='N' ";
			$query1 = $this->db->query($sql1);
        $scnt1 = $query1->result_array();
        $scnt12 = $query1->num_rows();
if($scnt12 > 0){
$ins = 'e';
}else{
		$society['emp_id']=$value;			
			$society['soc_amount']=$data['amt'];	
            $society['active_from']=$data['active_form']."-01";			
			$society['inserted_by']=$this->session->userdata("uid");
			$society['inserted_on']=date("Y-m-d H:i:s");		
			$society['active']='Y';
			$ins=$this->db->insert('employee_society_details',$society);
			//echo $this->db->last_query();
			//exit;
		}
	}
}


return $ins;
	}
	function getSocietyList(){
		$this->db->select('sd.*,em.fname,em.lname,em.gender,em.emp_school,em.department,em.designation');
		$this->db->from('employee_society_details as sd');
		$this->db->join('employee_master as em','em.emp_id = sd.emp_id','inner');
		$this->db->where('sd.is_deleted','N');
		//$this->db->where('sd.active','Y');
		$this->db->order_by("em.emp_id", "asc");	
		$query=$this->db->get();
//echo $this->db->last_query();
		return $result=$query->result_array();	
	}
	function getSocietyByID($id){
		$this->db->select('sd.*,em.fname,em.lname,em.gender,em.emp_school,em.department,em.designation');
		$this->db->from('employee_society_details as sd');
		$this->db->join('employee_master as em','em.emp_id = sd.emp_id','inner');
		$this->db->where('sd.soc_id',$id);		
		$query=$this->db->get();
//echo $this->db->last_query();
		return $result=$query->result_array();	
	}
	function updatesoiety($data){			
			$society['soc_amount']=$data['amt'];	
            $society['active_from']=$data['active_form']."-01";			
				$society['modified_by']=$this->session->userdata("uid");		
				$society['modified_on']=date("Y-m-d H:i:s");			
			$this->db->where('soc_id',$data['soc_id']);	    				
	 $ins = $this->db->update('employee_society_details',$society);
	 return $ins;
	}
	function delete_society($id){
			$busfare['is_deleted']='Y';	
$busfare['modified_by']=$this->session->userdata("uid");		
				$busfare['modified_on']=date("Y-m-d H:i:s");				
			$this->db->where('soc_id',$id);	
    				
	 $ins = $this->db->update('employee_society_details',$busfare);
	 return $ins;
	}
	function add_society_loan($data){
		$chk = $this->check_society_bydate($data['staffid'],$data['active_form']."-01",$data['active_to']."-01");
		if($chk =='0'){
		$society['emp_id']=$data['staffid'];			
			$society['loan_amount']=$data['loan_amt'];
$society['monthly_deduction']=$data['mon_dec'];
$society['from_month']=$data['active_form']."-01";			
            $society['to_month']=$data['active_to']."-01";			
			$society['inserted_by']=$this->session->userdata("uid");
			$society['inserted_on']=date("Y-m-d H:i:s");		
			$society['active']='Y';
			$ins=$this->db->insert('employee_society_loan',$society);
			//echo $this->db->last_query();
			//exit;
		return $ins;
		}else{
		return 'ext';
	}
	}
	function getSocietyLoanList(){
		$this->db->select('sd.*,em.fname,em.lname,em.gender,em.emp_school,em.department,em.designation');
		$this->db->from('employee_society_loan as sd');
		$this->db->join('employee_master as em','em.emp_id = sd.emp_id','inner');
		$this->db->where('sd.is_deleted','N');
		//$this->db->where('sd.active','Y');
		$this->db->order_by("em.emp_id", "asc");	
		$query=$this->db->get();
//echo $this->db->last_query();
		return $result=$query->result_array();	
	}
	function getSocietyLoanByID($id){
		$this->db->select('sd.*,em.fname,em.lname,em.gender,em.emp_school,em.department,em.designation');
		$this->db->from('employee_society_loan as sd');
		$this->db->join('employee_master as em','em.emp_id = sd.emp_id','inner');
		$this->db->where('sd.soc_id',$id);		
		$query=$this->db->get();
//echo $this->db->last_query();
		return $result=$query->result_array();	
	}
	function updatesoietyloan($data){			
			$society['loan_amount']=$data['loan_amt'];
$society['monthly_deduction']=$data['mon_dec'];
$society['from_month']=$data['active_form']."-01";			
            $society['to_month']=$data['active_to']."-01";				
				$society['modified_by']=$this->session->userdata("uid");		
				$society['modified_on']=date("Y-m-d H:i:s");			
			$this->db->where('soc_id',$data['soc_id']);	    				
	 $ins = $this->db->update('employee_society_loan',$society);
	 return $ins;
	}
	function delete_society_loan($id){
			$busfare['is_deleted']='Y';	
$busfare['modified_by']=$this->session->userdata("uid");		
				$busfare['modified_on']=date("Y-m-d H:i:s");				
			$this->db->where('soc_id',$id);	   				
	 $ins = $this->db->update('employee_society_loan',$busfare);
	 return $ins;
	}
	function check_society_bydate($empid,$fdate,$tdate){
	  
		$ldate =array();
$sql = "SELECT * FROM employee_society_loan WHERE emp_id='$empid' and is_deleted = 'N'";
			   $query=$this->db->query($sql);
		$result=$query->result_array();
foreach ($result as $key => $value) {	  
        $begin = new DateTime($value['from_month']);      
        $end = new DateTime($value['to_month'].' +1 day');    
$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
foreach($daterange as $date){
    $ldate[] = $date->format("d-m-Y");
}
}
//print_r($ldate);
//exit;
$begin1 = new DateTime($fdate);      
        $end1 = new DateTime($tdate.' +1 day');    
$daterange1 = new DatePeriod($begin1, new DateInterval('P1D'), $end1);

foreach($daterange1 as $date1){
    if(in_array($date1->format("d-m-Y"),$ldate)){
    	 $cnt = '1';
    }else{
    	$cnt = '0';
    }
}

		return $cnt;		
	}

	function add_tds_bill($data){
		//print_r($data);
		foreach($data['empid'] as $val){
			$sql = "select * from employee_tds_list where emp_id = '".$val."' and for_month = '".$data['month']."-01' and is_deleted = 'N' ";
			$query1=$this->db->query($sql);
		 $res1=$query1->result_array();
		 $cnt = count($res1);
		 if($cnt == '0'){
		$tds['emp_id']=$val;
		if(empty($data['tds_'.$val])){
			$tds['tds_amount']= 0;
		}else{
		$tds['tds_amount']=$data['tds_'.$val];
		}
		$tds['for_month']=$data['month']."-01";
		$tds['inserted_by']= $this->session->userdata("uid");
		$tds['inserted_on']= date("Y-m-d H:i:s");
$ins=$this->db->insert('employee_tds_list',$tds);
//echo $this->db->last_query();
//exit;
}else{
			foreach($res1 as $val1){
				if($data['tds_'.$val] > 0){
				if($val1['tds_amount'] == '0' && $data['tds_'.$val] > 0 ){
			
		$tdss['tds_amount']=$data['tds_'.$val];
			
		$tdss['modified_by']= $this->session->userdata("uid");
		$tdss['modified_on']= date("Y-m-d H:i:s");			
			$this->db->where('tds_id',$val1['tds_id']);	    				
	 $up = $this->db->update('employee_tds_list',$tdss);
	}else{
		$tdsu['is_deleted']='Y';
        $tdsu['modified_by']= $this->session->userdata("uid");
		$tdsu['modified_on']= date("Y-m-d H:i:s");			
			$this->db->where('tds_id',$val1['tds_id']);	    				
	 $up = $this->db->update('employee_tds_list',$tdsu);

        $tdsi['emp_id']=$val;
		if(empty($data['tds_'.$val])){
			$tdsi['tds_amount']= 0;
		}else{
		$tdsi['tds_amount']=$data['tds_'.$val];
		}
		$tdsi['for_month']=$data['month']."-01";
		$tdsi['inserted_by']= $this->session->userdata("uid");
		$tdsi['inserted_on']= date("Y-m-d H:i:s");
$ins = $this->db->insert('employee_tds_list',$tdsi);
}
	}
			}
		}

		}		
		return $ins;
	}
	function getTdsList($mon){
		$this->db->select('td.*,em.fname,em.lname,em.gender,em.emp_school,em.department,em.designation,cm.college_code,dm.department_name');
		$this->db->from('employee_tds_list as td');
		$this->db->join('employee_master as em','em.emp_id = td.emp_id','inner');
		$this->db->join('college_master as cm','cm.college_id = em.emp_school','left');
		$this->db->join('department_master as dm','dm.department_id = em.department','left');
		$this->db->where('td.is_deleted','N');
		$this->db->where('td.for_month',$mon.'-01');
		$this->db->order_by("em.emp_id", "asc");	
		$query=$this->db->get();
//echo $this->db->last_query();
		return $result=$query->result_array();	
	}
	function getTdsId($id)
	{
				$this->db->select('sd.*,em.fname,em.lname,em.gender,em.emp_school,em.department,em.designation');
		$this->db->from('employee_tds_list as sd');
		$this->db->join('employee_master as em','em.emp_id = sd.emp_id','inner');
		$this->db->where('sd.tds_id',$id);		
		$query=$this->db->get();
//echo $this->db->last_query();
		return $result=$query->result_array();	
	}
	function updateTds($data){

$sql = "select * from employee_tds_list where tds_id ='".$data['tds_id']."' ";
			$query1=$this->db->query($sql);
		 $res1=$query1->result_array();

		$tds['is_deleted']='Y'; 		
		$tds['modified_by']= $this->session->userdata("uid");
		$tds['modified_on']= date("Y-m-d H:i:s");			
			$this->db->where('tds_id',$data['tds_id']);	    				
	 $up = $this->db->update('employee_tds_list',$tds);

$tdsi['emp_id']=$res1[0]['emp_id'];		
		$tdsi['tds_amount']=$data['tds_amt'];		
		$tdsi['for_month']=$res1[0]['for_month'];
		$tdsi['inserted_by']= $this->session->userdata("uid");
		$tdsi['inserted_on']= date("Y-m-d H:i:s");
$ins=$this->db->insert('employee_tds_list',$tdsi);

	 return $up;
	}
	function updateTdsList($data){
		//print_r($data);exit;
		foreach($data['empids'] as $emp){

$sql = "select * from employee_tds_list where tds_id ='".$data['tdsid_'.$emp]."' ";
			$query1=$this->db->query($sql);
		 $res1=$query1->result_array();

		$tds['is_deleted']='Y'; 		
		$tds['modified_by']= $this->session->userdata("uid");
		$tds['modified_on']= date("Y-m-d H:i:s");			
			$this->db->where('tds_id',$data['tdsid_'.$emp]);	    				
	 $up = $this->db->update('employee_tds_list',$tds);

$tdsis['emp_id']=$emp;		
		$tdsis['tds_amount']=$data['amt_'.$emp];		
		$tdsis['for_month']=$data['cmon']."-01";
		$tdsis['inserted_by']= $this->session->userdata("uid");
		$tdsis['inserted_on']= date("Y-m-d H:i:s");
$ins=$this->db->insert('employee_tds_list',$tdsis);

		}
		//exit;
		return $up;
	}
	function get_salary_sheet($mon){
		 $data = explode('-',$mon);		
		 $sql="select e.emp_id,e.fname,e.mname,e.lname,e.gender,e.department,e.emp_school,ms.* from employee_master as e 
inner join employee_monthly_salary as ms on ms.emp_id=e.emp_id 
where  month(ms.for_month_year)='".$data[1]."' and year(ms.for_month_year)='".$data[0]."' order by e.emp_id ";
$query1=$this->db->query($sql);
		return $res1=$query1->result_array();
	}
	function insert_staff_relese_status($data){
		
	//	print_r($data);exit;
		$odj = new Message_api();
		 $this->load->library('smtp');
    $this->load->library('phpmailer');
    $mail = new PHPMailer;
    $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                     // Enable SMTP authentication
$mail->Username = 'developers@sandipuniversity.com';          // SMTP username
$mail->Password = 'university@24'; // SMTP password
$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                          // TCP port to connect to

$mail->setFrom('admindept@sandipuniversity.edu.in', 'Admin Department');
//$mail->addCC('admindept@sandipuniversity.edu.in');
$mail->isHTML(true);  // Set email format to HTML
$mail->Subject = 'Salary of the '.$data['smonth'].' is '.ucfirst($data['sact']);
$mail->addAddress('kajal.sonavane@carrottech.in');



		if($data['sact']=='deposit'){
		
		if($data['styp']=='a'){
			foreach($data['mon_sal'] as $val){	
		$sal['rel_status']='Release';	
$sal['salary_paid_by']= 'ACC';
		$sal['updated_by']=$this->session->userdata("uid");		
				$sal['updated_date']=date("Y-m-d H:i:s");
				$this->db->where('sid',$val);	   				
	  $ins = $this->db->update('employee_monthly_salary',$sal);
	 // echo $this->db->last_query();
	 // exit;
	  $empd = $this->getEmployeeById1($data['empid_'.$val]);
	 // print_r($empd);exit;
	  $mobile = '8169767169';
	  $sms_message = "Hi,
Your salary of this month is transfer to bank.

Thank you
Sandip University
";

           
     $odj->send_sms($mobile,$sms_message);	
    //echo "kk";	
//exit;
 $body = "Dear ".$empd[0]['fname']." ".$empd[0]['lname']."";
$body .= "<br/>Your Salary for the month of <b>".$data['smonth']."</b> calculate as net salary Rs:- ".$data['enetsa_'.$val]." /- and sent on ".date('d F Y')." to the bank for deposite to your account.";
$mail->Body    = $body;
//echo $body;
$mail->send();

			}
		}elseif($data['styp']=='c'){
		foreach($data['uid'] as $val){			
$sal['updated_by']=$this->session->userdata("uid");		
				$sal['updated_date']=date("Y-m-d H:i:s");
$sal['salary_paid_by']= 'CHQ';
$sal['salary_ref_no']= $data['emp_'.$val];
$sal['rel_status']='Release';						
			$this->db->where('sid',$val);	   				
	  $ins = $this->db->update('employee_monthly_salary',$sal);	
	   $empd = $this->getEmployeeById1($data['empid_'.$val]);
	   $mobile = '8169767169';
	  $sms_message ="Hi,
Your salary of this month is transfer to bank.

Thank you
Sandip University
";
//$odj = new Message_api();
           
     $odj->send_sms($mobile,$sms_message);	
     $body = "Dear ".$empd[0]['fname']." ".$empd[0]['lname']."";
$body .= "<br/>Your Salary for the month of <b>".$data['smonth']."</b> calculate as net salary Rs:- ".$data['enets_'.$val]." /- and sent on ".date('d F Y')." to the bank for deposite to your account.";
$mail->Body    = $body;
//echo $body;
$mail->send();
		}		
		}
		
		
		
		
		}elseif($data['sact']=='hold'){
			foreach($data['uid'] as $val){			
$sal['updated_by']=$this->session->userdata("uid");		
				$sal['updated_date']=date("Y-m-d H:i:s");
$sal['rel_status']='Hold';	
			$sal['salary_hold_reason']=$data['emp_'.$val];
			$sal['salary_hold']='Y';						
			$this->db->where('sid',$val);	   				
	  $ins = $this->db->update('employee_monthly_salary',$sal);	
		}		
			
		}
		
		
		 return $ins;
	}
	function getEmployeeById1($id){
		$this->db->select("e.*,ot.*");
		$this->db->from('employee_master as e');
		$this->db->join('employe_other_details as ot','ot.emp_id = e.emp_id','left');
	
		$this->db->where('e.emp_id',$id);
		//$this->db->where('e.emp_status',$flg);
		$query=$this->db->get();
		//  echo $this->db->last_query();
	//	die();   
		$result=$query->result_array();
		return $result;
	}
	public function get_final_monthly_attendance($mon,$yer,$ty){
		if($ty!=''){
						$whr = ' and em.staff_type IN ('.$ty.')';
		}
	$sql="SELECT ef.*,em.emp_id,em.gender,em.fname,em.mname,em.lname,em.emp_school,em.department FROM employee_monthly_final_attendance as ef inner join employee_master as em on em.emp_id = ef.UserId  WHERE em.emp_status='Y' and month(ef.for_month_year)='$mon' and year(ef.for_month_year)='$yer' ".$whr." order by em.emp_id ASC";
		$query1=$this->db->query($sql);
		$res1=$query1->result_array();
		return $res1;
}
public function getEmpListForDeductions1($data){
			/* echo "<pre>"; print_R($data);"</pre>";
		exit; */
	//echo array_count_values($data);
  $sql="select e.emp_id,e.emp_reg,e.fname,e.mname,e.lname,e.gender,dd.*  from employee_transaction_details  as dd
		inner join employee_master as e on e.emp_id=dd.emp_id	
where e.emp_status='Y' and dd.is_final_status ='N' and month(dd.month_of) ='".$data['mn']."' and year(dd.month_of)='".$data['dt']."'  group by e.emp_id order by e.emp_id ASC";
		
	$query=$this->db->query($sql);
	$res=$query->result_array();
      /* print_R($res);
     die();	  */ 
	 return $res;
	}
	public function update_final_status_staff_deduction($data){
	//print_r($data);exit;
	$val2['is_final_status']='Y';	
	$val2['updated_on']=date('Y-m-d');
	$val2['updated_by']=$this->session->userdata('uid');
	 $this->db->where('month_of',$data['sdate']);	
	return $this->db->update('employee_transaction_details',$val2);
	
}
function get_employee_epf(){
		 $this->db->select('e.emp_id,e.emp_reg,e.fname,e.mname,e.lname,e.gender,e.joiningDate,s.college_code,de.department_name,e.epf_apply');
     $this->db->from('employee_master as e');
	 $this->db->join('college_master as s','s.college_id = e.emp_school','inner');		
		$this->db->join('department_master as de','de.department_id = e.department','inner');
		
	 //$this->db->where('e.joiningDate <=',date('Y-m-d'));	
$this->db->where('e.emp_reg','N');	
$this->db->order_by('e.emp_id','ASC');	 
	 $query=$this->db->get();
	// echo $this->db->last_query();
	 $res=$query->result_array();
	 return $res;
	}

	function update_epf_emp($data){
		$empl = $this->get_employee_epf();
		foreach($empl as $val){
			//echo $val['emp_id'];
			//echo "<br/>";
			$chk = in_array($val['emp_id'], $data['mon_sal']); 
			//echo "<br/>";
			if($chk=='1'){
			$epf['epf_apply']='N';	
			}else{
$epf['epf_apply']='Y';	
			}					
			$this->db->where('emp_id',$val['emp_id']);	   				
	  $ins = $this->db->update('employee_master',$epf);	

		}
		return $ins;
	}
	/////////////////////////////////////////
	function updateattendacneDetails($data, $month) {

		$DB1 = $this->load->database('umsdb', TRUE); 
	
		//echo "<pre>";print_r($data);
        $count = count($data['emp_id']);
        //echo $count;
        for ($i = 0; $i < $count; $i++) {
			$emp_id = $data['emp_id'][$i];	
			$stud_att = $this->get_employee_attendance($emp_id, $month);			
			if(empty($stud_att)){
				$insert_array=array(
					"UserId"=>$data['emp_id'][$i],
					"ename"=>$data['staff_name'][$i],
					"month_days"=>date('t'),
					"total_present"=>$data['present_days'][$i],
					"total"=>$data['present_days'][$i],					
					"for_month_year"=>$month.'-01',					
					"inserted_by" => $this->session->userdata("uid"),
					"inserted_date" => date("Y-m-d H:i:s")
					); 
				//echo "<pre>";print_r($insert_array);//exit;
				$this->db->insert("employee_monthly_final_attendance ", $insert_array); 
				//echo$this->db->last_query();exit;
			}
			
            $UserId = $data['emp_id'][$i];
            $spk['ename'] = $data['staff_name'][$i];
			$spk['month_days'] = date('t');
			$spk['total_present'] = $data['present_days'][$i];
			$spk['total'] = $data['present_days'][$i];
                //echo"in update";
			$spk['updated_by'] = $this->session->userdata("uid");
			$spk['updated_date'] = date('Y-m-d H:i:s');
							//echo "<pre>";print_r($spk);//exit;
			
			$this->db->where('UserId', $UserId);
			$this->db->like('for_month_year', $month);
			$this->db->update('employee_monthly_final_attendance', $spk);
            //echo $this->db->last_query();exit;
            unset($mrk_id);
			unset($sql);

        }

         return true;

    }
	function get_employee_attendance($emp_id, $month)
		{
			$DB1 = $this->load->database('umsdb', TRUE); 
			$sql="SELECT `for_month_year` FROM employee_monthly_final_attendance where UserId='$emp_id' and for_month_year like '%$month%'";	
			$query = $this->db->query($sql);
			$res = $query->result_array();
			//echo $DB1->last_query();exit;
			return $res[0]['for_month_year'];
		}	
	public function getEmpSalForMonth_final_indu($data,$emp_id){
		//print_r($data);
		//exit;

			
		  $sql1="select e.emp_id,e.fname,e.mname,e.lname,e.department,e.emp_school,ss.basic_sal as basic_salary,e.gender,e.designation,ss.pay_band_min,ss.pay_band_max,ss.pay_band_gt,ss.basic_sal,ss.allowance,eo.pan_no,eo.pf_no,eo.bank_acc_no,me.da,me.dp,me.hra,me.ta,me.difference,me.other_allowance,me.special_allowance,me.special_allowance,md.*,ms.* from employee_master as e 
 inner join employe_other_details as eo on eo.emp_id=e.emp_id 
inner join employee_monthly_salary as ms on ms.emp_id=e.emp_id 
inner join employee_monthwise_deduction as md on md.emp_id=e.emp_id
 inner join employee_monthwise_earning as me on me.emp_id=e.emp_id
inner join employee_salary_structure as ss on ss.emp_id=e.emp_id 
where ss.active_status='Y' and month(md.for_month)='".$data['mn']."' and year(md.for_month)='".$data['dt']."' and month(me.for_month)='".$data['mn']."' and year(me.for_month)='".$data['dt']."' and month(ms.for_month_year)='".$data['mn']."' and year(ms.for_month_year)='".$data['dt']."' and  e.emp_id='".$emp_id."' ";
	//exit;
	$query1=$this->db->query($sql1);
		$res1=$query1->result_array();
       if(!empty($res1)){
		$final[$i]=$res1[0];   
	   }		
				
	
	if(!empty($final)){
	return $final;	
	}
	
	}
	
	
	public function insert_staff_salary_increment_det($data)
	{
		$data['created_by']=$this->session->userdata('uid');
		$data['created_on']=date('Y-m-d h:m:s');
		$query=$this->db->insert('staff_salary_increment_details',$data);
		if(!empty($query))
		{
		 $sd=$this->db->get_where('employee_salary_structure',array('emp_id'=>$data['emp_id'],'active_status'=>'Y'))->row();
         $sd->inserted_on=date('Y-m-d h:m:s');
		 
		 $in_query=$this->db->insert('employee_salary_structure_log',$sd);
		 
	     $incr_val=($sd->special_allowance+$data['amount']);
		 
		
$gross_val=($sd->gross_salary+$data['amount']);
		 
		 $this->db->where('emp_id',$data['emp_id']);
		 $val=$this->db->update('employee_salary_structure',array('special_allowance'=>$incr_val,'gross_salary'=>$gross_val));
		 
		 $this->db->where('emp_id',$data['emp_id']);
		 $val=$this->db->update('employe_other_details',array('allowance'=>$incr_val));


		}
	    return $query;
	} 
     public function get_active_emp(){
		$this->db->select("emp_id,fname,mname,lname");
		$this->db->from('employee_master');
		$this->db->where('emp_status','Y');
		$this->db->where('emp_reg','N');
		//$this->db->order_by("emp_id", "asc");	 
		$this->db->order_by("fname", "asc");	 
		$this->db->group_by("emp_id");	 
		$query=$this->db->get();	
        return $query->result_array();
	}
	
	
	  public function getEmployeeslastdate(){
		$this->db->select("el.*");
		$this->db->select("em.fname,em.mname,em.lname");
		$this->db->from('emp_last_date as el');
		$this->db->join('employee_master as em','em.emp_id=el.emp_id','left');
		//$this->db->where('el.status','Y');
		$this->db->order_by("el.eid", "desc");	  
		$query=$this->db->get();	
        return $query->result_array();
	}
	
	   public function change_emp_last_date_status($eid,$status)
   {
	   print_r($status);
	   $sts='Y';
	   if($status=='Y')
	   {
		   $sts='N';		   
	   }
       
   	 $sdata=array(
	 'status'=>$sts,
	 );
	 $this->db->where('eid',$eid);	
	 $query=$this->db->update('emp_last_date',$sdata);
	 echo $this->db->last_query();exit;
	 return $query;
   }
   
   
   public function fetch_staff_increment_search_data($academic_year='',$from_date='',$to_date='')
	{
		$this->db->select("st.*");
		$this->db->select("e.emp_id,e.fname,e.mname,e.lname");
		$this->db->from('staff_salary_increment_details as st');
		$this->db->join('employee_master as e','st.emp_id=e.emp_id','left');
		if($academic_year!=''){
		$this->db->where('st.academic_year',$academic_year);
		}
			if($from_date!=''){
		$this->db->where("st.from_month >=",$from_date);
        }
		if($to_date!=''){
		$this->db->where("st.from_month <=",$to_date);
        }
		$this->db->order_by('st.id','desc');
		
		$query=$this->db->get();	
        return $query->result_array();
	}
   public function get_emp_increment_det($id='')
  {
	  $this->db->select('*');
	  $this->db->from('staff_salary_increment_details');
	  $this->db->where('id',$id);
      $query=$this->db->get();	
      return $query->result_array();	  
  }
  public function update_staff_salary_increment_det($data)
  {  
        $ind=$this->db->get_where('staff_salary_increment_details',array('id'=>$data['eid']))->row();
	    $data['updated_by']=$this->session->userdata('uid');
		$data['updated_on']=date('Y-m-d h:m:s');
		$this->db->where('id',$data['eid']);
		unset($data['eid']);
		$query=$this->db->update('staff_salary_increment_details',$data);

		if(!empty($query))
		{

		 $sd=$this->db->get_where('employee_salary_structure',array('emp_id'=>$data['emp_id'],'active_status'=>'Y'))->row();
         $sd->inserted_on=date('Y-m-d h:m:s');
		 
		 $in_query=$this->db->insert('employee_salary_structure_log',$sd);
		 if($data['amount'] > $ind->amount)
		 {                    
			$famount=($data['amount']- $ind->amount);
			$incr_val=($sd->special_allowance+$famount);
            $gross_val=($sd->gross_salary+$famount);
		 }
		 else
		 {
			$famount=($ind->amount-$data['amount']);
			$incr_val=($sd->special_allowance-$famount);
            $gross_val=($sd->gross_salary-$famount);
		 }

		 $this->db->where('emp_id',$data['emp_id']);
		 $val=$this->db->update('employee_salary_structure',array('special_allowance'=>$incr_val,'gross_salary'=>$gross_val));

		 $this->db->where('emp_id',$data['emp_id']);
		 $val=$this->db->update('employe_other_details',array('allowance'=>$incr_val));

		}
	    return $query; 
  }
  
   ////////////////////Arrears/////////////////////////////
  function getArrearsList($mon){

		$this->db->select('ar.*,em.fname,em.lname,em.gender,em.emp_school,em.department,em.designation,cm.college_code,dm.department_name');
		$this->db->from('employee_arrears_details as ar');
		$this->db->join('employee_master as em','em.emp_id = ar.emp_id','inner');
		$this->db->join('college_master as cm','cm.college_id = em.emp_school','left');
		$this->db->join('department_master as dm','dm.department_id = em.department','left');
		$this->db->where('ar.is_deleted','N');
		$this->db->where('ar.for_month',$mon.'-01');
		$this->db->order_by("em.emp_id", "asc");	
		$query=$this->db->get();
		
		return $result=$query->result_array();	
	}
	
	function add_arrears($data){
	
		foreach($data['empid'] as $val){
			$sql = "select * from employee_arrears_details where emp_id = '".$val."' and for_month = '".$data['month']."-01' and is_deleted = 'N' ";
		
		 $query1=$this->db->query($sql);
		 $res1=$query1->result_array();
		 $cnt = count($res1);
        
		 if($cnt == '0'){
		$arr['emp_id']=$val;
		if(empty($data['arr_'.$val])){
			$arr['arr_amount']= 0;
		}else{
		$arr['arr_amount']=$data['arr_'.$val];
		}
		$arr['for_month']=$data['month']."-01";
		$arr['inserted_by']= $this->session->userdata("uid");
		$arr['inserted_on']= date("Y-m-d H:i:s");
		if($arr['arr_amount']!=0){
	      $ins=$this->db->insert('employee_arrears_details',$arr);
		}
         
	} else{
		
				foreach($res1 as $val1){
					if($data['arr_'.$val] > 0){
					if($val1['arr_amount'] != '0' && $data['arr_'.$val] > 0 ){
				
			$arrs['arr_amount']=$data['arr_'.$val];
				
			$arrs['modified_by']= $this->session->userdata("uid");
			$arrs['modified_on']= date("Y-m-d H:i:s");			
				$this->db->where('arr_id',$val1['arr_id']);	    				
		 $up = $this->db->update('employee_arrears_details',$arrs);
		}
	      }
	    }
	  } 
	}		
	return $ins;
}
	
	function updateArrearsList($data){

		foreach($data['empids'] as $emp){
			
        $sql = "select * from employee_arrears_details where arr_id ='".$data['arrid_'.$emp]."' ";
		$query1=$this->db->query($sql);
		$res1=$query1->result_array();		
		$arr['modified_by']= $this->session->userdata("uid");
		$arr['modified_on']= date("Y-m-d H:i:s");
        $arr['arr_amount']=$data['amt_'.$emp];		
		$this->db->where('arr_id',$data['arrid_'.$emp]);	    				
	    $up = $this->db->update('employee_arrears_details',$arr);
		}
		return $up;
	}
	
	function updateArrears($data){		
		$arr['modified_by']= $this->session->userdata("uid");
		$arr['modified_on']= date("Y-m-d H:i:s");
        $arr['arr_amount']=$data['arr_amt'];		
		$this->db->where('arr_id',$data['arr_id']);	    				
	    $up = $this->db->update('employee_arrears_details',$arr);
	 return $up;
	}
	
	function getArrearsId($id)
	{
		$this->db->select('arr.*,em.fname,em.lname,em.gender,em.emp_school,em.department,em.designation');
		$this->db->from('employee_arrears_details as arr');
		$this->db->join('employee_master as em','em.emp_id = arr.emp_id','inner');
		$this->db->where('arr.arr_id',$id);		
		$query=$this->db->get();
		return $result=$query->result_array();	
	}
  

}