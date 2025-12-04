<?php
class Employee_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
	function getStateByID($id){
		$sql="SELECT state_name FROM state_master WHERE state_id='$id' and status='Y'";
        $query = $this->db->query($sql);
		$res=$query->result_array();
        return $res[0]['state_name'];
	}
	function getCityByID($id){
		$sql="SELECT city_name FROM city_master WHERE city_id='$id' and status='Y'";
		$query = $this->db->query($sql);
		$res=$query->result_array();
        return $res[0]['city_name'];
	}
	
	function fetchEmployeeData($id){
		$this->db->select("e.*,ot.*,d.*,st.emp_cat_name,s.college_name,ds.designation_name,de.department_name,sh.shift_name,bk.bank_name,lv.*,rt.week_off as weekoff, rt.shift as rtshift,rt.intime as rtintime,rt.outtime as rtouttime,stm.state_name as lstate,stm1.state_name as pstate,ctm.city_name as ldist,ctm1.city_name as pdist");
		$this->db->from('employee_master as e');
		$this->db->join('employe_other_details as ot','ot.emp_id = e.emp_id','left');
		$this->db->join('employee_document_master as d','d.emp_id = e.emp_id','left');
		$this->db->join('employee_category as st','st.emp_cat_id = e.staff_type','left');
		$this->db->join('college_master as s','s.college_id = e.emp_school','left');
		$this->db->join('designation_master as ds','ds.designation_id = e.designation','left');
		$this->db->join('department_master as de','de.department_id = e.department','left');
		$this->db->join('shift_master as sh','sh.shift_id = e.shift','left');
		$this->db->join('bank_master as bk','bk.bank_id = ot.bank_name','left');
		$this->db->join('employee_leave_track as lv','lv.emp_id = e.emp_id','left');
		$this->db->join('reporting_time as rt','rt.emp_id = e.emp_reg_id','left');
		$this->db->join('state_master as stm','stm.state_id = ot.lstate','left');
		$this->db->join('state_master as stm1','stm1.state_id = ot.pstate','left');
		$this->db->join('city_master as ctm','ctm.city_id = ot.ldist','left');
		$this->db->join('city_master as ctm1','ctm1.city_id = ot.pdist','left');
		$this->db->where('e.emp_id',$id);
		$this->db->where('e.emp_status','Y');
		$query=$this->db->get();
		 /* echo $this->db->last_query();
		die();    */
		$result=$query->result_array();
		$result[0]['emp_id']=$id;
		return $result;
		
	}
	function fetchEmployeeData1($id){
		$this->db->select("e.*,ot.*,d.*,st.emp_cat_name,s.college_name,ds.designation_name,de.department_name,sh.shift_name,bk.bank_name,lv.*,rt.week_off as weekoff, rt.shift as rtshift,rt.intime as rtintime,rt.outtime as rtouttime,stm.state_name as lstate,stm1.state_name as pstate,ctm.city_name as ldist,ctm1.city_name as pdist");
		$this->db->from('employee_master as e');
		$this->db->join('employe_other_details as ot','ot.emp_id = e.emp_id','left');
		$this->db->join('employee_document_master as d','d.emp_id = e.emp_id','left');
		$this->db->join('employee_category as st','st.emp_cat_id = e.staff_type','left');
		$this->db->join('college_master as s','s.college_id = e.emp_school','left');
		$this->db->join('designation_master as ds','ds.designation_id = e.designation','left');
		$this->db->join('department_master as de','de.department_id = e.department','left');
		$this->db->join('shift_master as sh','sh.shift_id = e.shift','left');
		$this->db->join('bank_master as bk','bk.bank_id = ot.bank_name','left');
		$this->db->join('employee_leave_track as lv','lv.emp_id = e.emp_id','left');
		$this->db->join('reporting_time as rt','rt.emp_id = e.emp_reg_id','left');
		$this->db->join('state_master as stm','stm.state_id = ot.lstate','left');
		$this->db->join('state_master as stm1','stm1.state_id = ot.pstate','left');
		$this->db->join('city_master as ctm','ctm.city_id = ot.ldist','left');
		$this->db->join('city_master as ctm1','ctm1.city_id = ot.pdist','left');
		$this->db->where('e.emp_id',$id);
		$this->db->where('e.emp_reg','N');
		$query=$this->db->get();
		 /* echo $this->db->last_query();
		die();    */
		$result=$query->result_array();
		$result[0]['emp_id']=$id;
		return $result;
		
	}
	function getAllLeaveType(){
		$this->db->select('leave_id,ltype');
		$this->db->from('leave_master');
		$this->db->where('lstatus','Y');
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;		
	}
	function dateDiff ($d1, $d2) {
     // Return the number of days between the two dates:
        $no = round(abs(strtotime($d1)-strtotime($d2))/86400);
	  /* echo $no;
		 die(); */
          return $no + 1; 
       }  // end function dateDiff
	   
	   
	function addEmpLeave($data){
		//echo"<pre>";print_r($data);echo"</pre>";
		//seperating array for leave and alternative for leave
		$leave['emp_id']=$data['emp_id'];
		$leave['ename']=$data['ename'];
		$leave['applied_from_date']=$data['leave_applied_from_date'];		
		if($data['leave_duration']=='half-day'){
			$leave['applied_to_date']=$leave['applied_from_date'];
		}else{
			  $leave['applied_to_date']=$data['leave_applied_to_date'];    
		}
       	$leave['no_days']=$data['no_days'];	
       	$leave['leave_type']=$data['leave_type'];	
       	$leave['leave_duration']=$data['leave_duration'];	
       	$leave['designation']=$data['designation'];	
       	$leave['department']=$data['department'];	
       	$leave['school']=$data['school'];	
       	$leave['reason']=$data['reason'];	
       	$leave['gate_pass']=$data['gate_pass'];	
      // 	$leave['reporting_school']=$data['reporting_school'];	
       //	$leave['reporting_dept']=$data['reporting_dept'];	
       //	$leave['reporting_dept']=$data['reporting_dept'];	
       	$leave['leave_contct_address']=$data['leave_contct_address'];	
       	$leave['leave_contct_no']=$data['leave_contct_no'];       
		$data['applied_on_date']=date("Y-m-d");
		$leave['applied_on_date']=$data['applied_on_date'];	
		$leave['ro_forward']='Y';	//forwarded to ro set flag true...
		$leave['inserted_by']=$this->session->userdata("uid");
		$leave['inserted_datetime']=date("Y-m-d H:i:s");
	//	array_filter($data['fromdt']);
		$data['fromdt'] = array_diff( $data['fromdt'], array( '' ) );
		$t1=0;
		foreach($data['fromdt'] as $k => $item) //for making key values as like $data['ch'] array of emp_id
        {
           $temp1[$t1]=$item;
           unset($data['fromdt'][$k]);
           $t1++;
		}
	    $data['fromdt']=$temp1;
		//array_filter($data['todt']);
		$data['todt'] = array_diff( $data['todt'], array( '' ) );
		$t2=0;
		foreach($data['todt'] as $k => $item) //for making key values as like $data['ch'] array of emp_id
        {
           $temp2[$t2]=$item;
           unset($data['todt'][$k]);
           $t2++;
		}
	    $data['todt']=$temp2;
		//array_filter($data['no_of_alter_days']);
		$data['no_of_alter_days'] = array_diff( $data['no_of_alter_days'], array( '' ) );
		$t3=0;
		foreach($data['no_of_alter_days'] as $k => $item) //for making key values as like $data['ch'] array of emp_id
        {
           $temp3[$t3]=$item;
           unset($data['no_of_alter_days'][$k]);
           $t3++;
		}
	    $data['no_of_alter_days']=$temp3;
		for($i=0;$i<count($data['ch']);$i++){
			$alter[$i]=array($data['emp_id'],$data['reporting_school'],$data['reporting_dept'],$data['ch'][$i],$data['fromdt'][$i],$data['todt'][$i],$data['no_of_alter_days'][$i]);
		}
		
    /* 	echo"<pre>";print_r($data['fromdt']);echo"</pre>";
		echo"********";
		echo"<pre>";print_r($data['todt']);echo"</pre>";
		echo"********";
		echo"<pre>";print_r($data['no_of_alter_days']);echo"</pre>";
		echo"********";
		echo"<pre>";print_r(array_unshift($data['no_of_alter_days']));echo"</pre>";
		echo"********";
		echo"<pre>";print_r($alter);echo"</pre>";
		/* for($i=0;$i<count($data['fromdt']);$i++){
				
			} */ 
		//echo"<pre>";print_r($leave);echo"</pre>";die();
		$ins=$this->db->insert('leave_applicant_list',$leave);
		$ins_id=$this->db->insert_id();
		if(!empty($ins_id)&&$ins_id>0){
			//add leave alternative details if available
		for($i=0;$i<count($alter);$i++){
			//$this->db->insert('leave_alternative_details');
			$sql="insert into leave_alternative_details set 
			lv_for_empid='".$alter[$i][0]."',
			school_id='".$alter[$i][1]."',
			depart_id='".$alter[$i][2]."',
			alter_staff_id='".$alter[$i][3]."',
			from_dt='".$alter[$i][4]."',
			to_dt='".$alter[$i][5]."',
			no_of_days='".$alter[$i][6]."'
			";
			$query=$this->db->query($sql);
				
			}	
			
			return true;
		}
		
	}

	function addEmpOD($data){
		//echo"<pre>";print_r($data);echo"</pre>";die();
		$od['emp_id']=$data['emp_id'];
		$od['ename']=$data['ename'];
		$od['applied_from_date']=$data['applied_from_date'];
		if($data['od_duration']=='half-day'){
			$od['applied_to_date']=$od['applied_from_date'];
		}elseif($data['od_duration']=='full-day'){
			  $od['applied_to_date']=$data['od_applied_to_date'];    
		}elseif($data['od_duration']=='hrs'){
			 $od['applied_from_date']=date('Y-m-d',strtotime($data['od_departure_time']));
			 $od['applied_to_date']=date('Y-m-d',strtotime($data['od_departure_time']));
		}		
		
		$od['no_days']=$data['no_days_forod'];
		$od['departure_time']=date('Y-m-d h:m:s',strtotime($data['od_departure_time']));
		$od['arrival_time']=date('Y-m-d h:m:s',strtotime($data['od_arrival_time']));//$data['od_arrival_time'];
		$od['no_hrs']=$data['no_hrs_forod'];
		$od['designation']=$data['designation'];
		$od['department']=$data['department'];
		$od['school']=$data['school'];
		$od['od_type']=$data['od_type'];
		$od['od_duration']=$data['od_duration'];
		$od['gate_pass']=$data['gate_pass'];
		$od['reason_od']=$data['reason_od'];		
		$od['location_od']=$data['location_od'];
		$od['l_od_state']=$data['state'];
		$od['l_od_city']=$data['city'];
		$od['contact_od']=$data['od_contct_no'];
		$od['od_applied_on_date']=date('Y-m-d h:m:i');
		$od['staff_along_od']=$data['facilty_with'];
		$od['inserted_by']=$this->session->userdata("uid");
		$od['inserted_date']=date("Y-m-d H:i:s");
		/* print_r($od);
		exit; */
		//for making key values as like $data['ch'] array of emp_id
		$data['fromdt'] = array_diff( $data['fromdt'], array( '' ) );
		$data['todt'] = array_diff( $data['todt'], array( '' ) );
		$data['no_of_alter_od_days'] = array_diff( $data['no_of_alter_od_days'], array( '' ) );
		/////////////
		$t1=0;
		foreach($data['fromdt'] as $k => $item) //for making key values as like $data['ch'] array of emp_id
        {
           $temp1[$t1]=$item;
           unset($data['fromdt'][$k]);
           $t1++;
		}
	    $data['fromdt']=$temp1;
		
		$t2=0;
		foreach($data['todt'] as $k => $item) //for making key values as like $data['ch'] array of emp_id
        {
           $temp2[$t2]=$item;
           unset($data['todt'][$k]);
           $t2++;
		}
	    $data['todt']=$temp2;
			
		$t3=0;
		foreach($data['no_of_alter_od_days'] as $k => $item) //for making key values as like $data['ch'] array of emp_id
        {
           $temp3[$t3]=$item;
           unset($data['no_of_alter_od_days'][$k]);
           $t3++;
		}
	    $data['no_of_alter_od_days']=$temp3;
		//////////
		for($i=0;$i<count($data['ch']);$i++){
			$od_alter[$i]=array($data['emp_id'],$data['reporting_school_od'],$data['reporting_dept_od'],$data['ch'][$i],$data['fromdt'][$i],$data['todt'][$i],$data['no_of_alter_od_days'][$i],$data['od_duration']);
		}
		/* echo"<pre>";print_r($data);echo"</pre>";
		echo"******************";
		echo"<pre>";print_r($od);echo"</pre>";
		echo"***************";
		echo"<pre>";print_r($od_alter);echo"</pre>";
		die(); */
		///////
		$ins=$this->db->insert('od_application_list',$od);
		$ins_id=$this->db->insert_id();
		if(!empty($ins_id)&&$ins_id>0){
			//add OD alternative details if available
		for($i=0;$i<count($od_alter);$i++){
		$sql="insert into od_alternative_staff_details set 
			alter_for_emp_id='".$od_alter[$i][0]."',
			alter_staff_school='".$od_alter[$i][1]."',
			alter_staff_dept='".$od_alter[$i][2]."',
			alter_staff_id='".$od_alter[$i][3]."',
			alter_from_dt='".$od_alter[$i][4]."',
			alter_to_dt='".$od_alter[$i][5]."',
			no_of_days='".$od_alter[$i][6]."',
			alter_for_duration='".$od_alter[$i][7]."'
			";
			$query=$this->db->query($sql);
				
			}	
			
			return true;
		}
		
	}
	
	
	function getMyAllOD($id){
		$this->db->select('*');
		$this->db->from('od_application_list');
		$this->db->where('emp_id',$id);
		$this->db->order_by('od_applied_on_date',' DESC');
		$query=$this->db->get();
		$res=$query->result_array();
		return $res;
	}
	function getMyAttendances($id,$info){
		
	    $this->db->select('e.emp_id,e.fname,e.lname,e.emp_school,e.department,d.profile_pic,p.DeviceLogId,p.Intime,p.Outtime,p.status');
		$this->db->from('employee_master as e');
		$this->db->join('employee_document_master as d','d.emp_id= e.emp_id','left');
		$this->db->join('punching_backup as p','p.UserId= e.emp_id','left');
		$this->db->where('e.emp_id',$id);
		$this->db->where('e.emp_school',$info['emp_school']);
		$this->db->where('e.department',$info['department']);
		$this->db->where('month(p.Intime)',$info['mno']);
		$this->db->where('year(p.Intime)',$info['yr']);
		$this->db->order_by('p.Intime','desc');
		//$this->db->or_where('month(p.Outtime)',$msearch);
		//$this->db->where('year(p.Outtime)',$ysearch);
		
		$query=$this->db->get();
		/* echo $this->db->last_query($query);
		die();  */   
		return $query->result_array();	
	}
	//for total present day of month for date and Employee Id
	function  getMyTotalPresentByID($id,$info){
		$sql="SELECT count(status) as total FROM `punching_backup` WHERE `UserId`='".$id."' and month(`Intime`)='".$info['mno']."' and year(`Intime`)='".$info['yr']."' and status='present' ";
		$query = $this->db->query($sql);
        return $query->result_array();
		
	}
	//for total Abscent day of month for date and Employee Id
	function  getMyTotalAbscentByID($id,$info){
		$sql="SELECT count(status) as total FROM `punching_backup` WHERE `UserId`='".$id."' and month(`Intime`)='".$info['mno']."' and year(`Intime`)='".$info['yr']."' and status='abscent' ";
		$query = $this->db->query($sql);
        return $query->result_array();
		
	}
	//for total OutDuty OD day of month for date and Employee Id
	function  getMyTotalOuterDutyByID($id,$info){
		$sql="SELECT count(status) as total FROM `punching_backup` WHERE `UserId`='".$id."' and month(`Intime`)='".$info['mno']."' and year(`Intime`)='".$info['yr']."' and status='outduty' ";
		$query = $this->db->query($sql);
        return $query->result_array();
		
	}
	//for total overtime OT day of month for date and Employee Id
	function  getMyTotalOverTimeByID($id,$info){
		$sql="SELECT count(status) as total FROM `punching_backup` WHERE `UserId`='".$id."' and month(`Intime`)='".$info['mno']."' and year(`Intime`)='".$info['yr']."' and status='overtime' ";
		$query = $this->db->query($sql);
        return $query->result_array();
		
	}
	//for total Late Mark LT day of month for date and Employee Id
	function  getMyTotalLatemarkByID($id,$info){
		$sql="SELECT count(status) as total FROM `punching_backup` WHERE `UserId`='".$id."' and month(`Intime`)='".$info['mno']."' and year(`Intime`)='".$info['yr']."' and status='latemark' ";
		$query = $this->db->query($sql);
        return $query->result_array();
		
	}
	//for total Leave  day of month for date and Employee Id
	function  getMyTotalLeaveByID($id,$info){
		$sql="SELECT count(status) as total FROM `punching_backup` WHERE `UserId`='".$id."' and month(`Intime`)='".$info['mno']."' and year(`Intime`)='".$info['yr']."' and status='leave' ";
		$query = $this->db->query($sql);
        return $query->result_array();
		
	}
	//for getting Email Id of RO to send leave
	function getROforLeave($id){
		$sql="SELECT e.fname,e.lname,r.oemail FROM employee_master as e
              LEFT JOIN employe_other_details as r ON r.emp_id=e.emp_id
			  where  e.emp_id=(select reporting_person from employee_master where emp_id='$id')";
		$query=$this->db->query($sql);
		return $query->result_array();
		
	}
	function getPassData($data){
		$sql="select e.emp_id,e.fname,e.mname,e.lname,ds.designation_name,de.department_name,od.* from employee_master as e
		     left join designation_master as ds on ds.designation_id = e.designation
      		 left join department_master as de  on de.department_id = e.department
			 left join od_application_list as od on od.emp_id=e.emp_id
			 where od.oid='".$data['od_id']."' and od.emp_id='".$data['emp_id']."'";
			 $query=$this->db->query($sql);
		     return $query->result_array();
		
	}

	function get_emp_reporting($r){
		
	$this->db->select("er.*,e.fname,e.lname,e.emp_id");
		$this->db->from('employee_reporting_master as er');		
		$this->db->join('employee_master as e','e.emp_id = er.emp_code','left');
	  //  $this->db->join('shift_master as sh','sh.shift_id = e.shift','inner');
		//$this->db->join('department_master as de','de.department_id = e.report_department','inner');		
		$this->db->where('er.status','Y');
$this->db->where('e.emp_reg','N');
		$this->db->where('er.route',$r);
		$this->db->order_by("er.emp_code", "asc");	 
		$query=$this->db->get();
		//echo $this->db->last_query();
		//
		
		//exit;
		return $result=$query->result_array();		
	}
	function get_my_reporting($r){
		 $id=$this->session->userdata('name');
	$this->db->select("*");
		$this->db->from('employee_reporting_master');		
		
		$this->db->where('route',$r);
		$this->db->where('emp_code',$id);
		$this->db->where('status','Y');
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result_array();		
	}
	function get_emp_reporting_byid($erid){
		$this->db->select('*');
		$this->db->from('employee_reporting_master');
		$this->db->where('er_id',$erid);
		$this->db->where('status','Y');
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result_array();	
		
	}
	
	function update_employee_reporting_submit($post)
	{
	    date_default_timezone_set('Asia/Kolkata');
	    $arr['emp_code'] = $post['staffid'];
		$routes = $post['route'];

	    	$cnt = count($post['ch']);
			foreach($routes as $rout){
			$arr['route'] = $rout;
	    	for($i=1;$i<=$cnt;$i++){
		$arr['report_person'.$i] = $post['report_person'.$i];
		}
		$arr['inserted_datetime']=date("Y-m-d H:i:s");
		$arr['inserted_by']=$this->session->userdata("uid");

	    if(!empty($post['er_id'])){

	     $this->db->where('er_id',$post['er_id']);       
         $this->db->set('status','N');       
         $this->db->set('updated_by',$this->session->userdata("uid"));    
         $this->db->set('updated_datetime',date("Y-m-d H:i:s"));		 
         $this->db->update('employee_reporting_master');
		 $insert_id =$this->db->insert('employee_reporting_master',$arr);
	    }else{

	       // $empcnt = $this->get_emp_reporting_bycode($post['staffid'],$post['route']);
	        $empcnt = $this->get_emp_reporting_bycode($post['staffid'],$arr['route']);
	        $cnt = count($empcnt);
	        if($cnt>0){
            $insert_id = 0;
	    }else{
	        	$insert_id =$this->db->insert('employee_reporting_master',$arr);
	     }
	    }		
	   }
		return $insert_id;	  
	}
	
	
	function get_emp_reporting_bycode($erid,$r){
		
		echo "rajesh";
		
		$this->db->select('*');
		$this->db->from('employee_reporting_master');
		$this->db->where('emp_code',$erid);
		$this->db->where('route',$r);
		$query=$this->db->get();
		return $result=$query->result_array();			
	}
	function get_emp_details($erid){
		if(strpos($erid,'_') !== false){
    $empx = explode("_",$erid);
	$this->db->select('*');
		$this->db->from('sandipun_ums.faculty_master');
		$this->db->where('emp_id',$empx[1]);
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result_array();
}else{
		$this->db->select('*');
		$this->db->from('employee_master');
		$this->db->where('emp_id',$erid);
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result_array();	
		}	
	}

    function get_employee_leave_allocation_byid($id){
	    $this->db->select('*');
		$this->db->where('employee_id',$id);	
		$this->db->from('employee_leave_allocation');
		$this->db->where('status','Y'); 
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
   }
   function getSchoolDepartmentWiseEmployeeList1($sid,$did){
	 $this->db->select('e.emp_id,e.fname,e.mname,e.lname');
     $this->db->from('employee_master as e');
	 $this->db->join('user_master as u','e.emp_id=u.username','left');
	 $this->db->where("e.emp_status='Y' OR u.status='Y'");
	 $this->db->where('e.emp_school',$sid);
	 $this->db->where('e.department',$did);
	 //$this->db->where('e.ro_flag','on');
	 //$this->db->where('e.emp_status','Y');
	 $query=$this->db->get();
	 $res=$query->result_array();
	 //echo $this->db->last_query();die;
	 return $res;	 
	   
   }
   function getAllempShift(){
	  $this->db->select('rt.*,em.gender,em.emp_id,em.fname,em.lname,cm.college_name,dm.department_name');
		$this->db->from('employee_shift_time as rt');
		$this->db->join('employee_master as em','em.emp_id = rt.emp_id','inner');
		$this->db->join('college_master as cm','cm.college_id = em.emp_school','inner');
		$this->db->join('department_master as dm','dm.department_id = em.department','inner');
		$this->db->where('em.emp_reg','N');	
		$this->db->where('rt.status','Y');	
		$this->db->order_by("em.emp_id", "asc");
		$this->db->order_by("em.emp_id", "asc");	 
		$query=$this->db->get();
		//echo $this->db->last_query();
		//exit;
		
		return $result=$query->result_array();	
   }
    function getempShift_id($id){
		  $this->db->select('rt.*,em.fname,em.lname,em.emp_school,em.department,dem.designation_name,cm.college_name,dm.department_name');
		$this->db->from('employee_shift_time as rt');
		$this->db->join('employee_master as em','em.emp_id = rt.emp_id','inner');
		$this->db->join('college_master as cm','cm.college_id=em.emp_school','left');
		$this->db->join('department_master as dm','dm.department_id=em.department','left');
		$this->db->join('designation_master as dem','dem.designation_id=em.designation','left');
		$this->db->where('rt.emp_shift_id',$id);
		//$this->db->where('em.emp_reg','N');
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result_array();
	}
	function update_emp_shifttime($data){
		//print_r($data); exit;
		 $this->db->where('emp_shift_id',$data['id']);       
         //$this->db->set('status','N');
          $this->db->set('week_off',$data['week_off']); 	
        $this->db->set('shift_id',$data['shift']); 	
$this->db->set('in_time',$data['intime']); 
$this->db->set('out_time',$data['outtime']); 		
         $this->db->set('modified_by',$this->session->userdata("uid"));    
        $this->db->set('modified_on',date("Y-m-d H:i:s"));		 
         $id = $this->db->update('employee_shift_time');

        
         //echo $this->db->last_query();
        // exit;
         return $id;
	}
	function update_employee_password($data){
		 $pass= $this->randPass(5);
		 
		// $DB1 = $this->load->database('erpdell', TRUE);
		 
		  $this->db->where('username',$data['staffid']);       
          $this->db->set('password',$pass);       		
          $this->db->set('updated_by',$this->session->userdata("uid"));    
          $this->db->set('updated_datetime',date("Y-m-d H:i:s"));		 
        $id =   $this->db->update('user_master');
		return  $this->db->affected_rows();
		
		
		
		
	}
	function get_user_login($id){
		 $this->db->select('*');
		$this->db->where('username',$id);	
		$this->db->from('user_master');		
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}
	function randPass($length, $strength=8) {
    $vowels = 'aeuy';
    $consonants = 'bdghjmnpqrstvz';
    if ($strength >= 1) {
        $consonants .= 'BDGHJLMNPQRSTVWXZ';
    }
    if ($strength >= 2) {
        $vowels .= "AEUY";
    }
    if ($strength >= 4) {
        $consonants .= '23456789';
    }
    if ($strength >= 8) {
        $consonants .= '@#$%';
    }

    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length; $i++) {
        if ($alt == 1) {
            $password .= $consonants[(rand() % strlen($consonants))];
            $alt = 0;
        } else {
            $password .= $vowels[(rand() % strlen($vowels))];
            $alt = 1;
        }
    }
    return $password;
}

public function get_resign_list()
{
    	$this->db->select("r.emp_id, DATE_FORMAT(r.resign_date,'%d-%m-%Y') as resign_date1 ,r.reason,m.fname,m.mname,m.lname,m.joiningDate,c.college_code,d.department_name,dg.designation_name");
		$this->db->from('employee_resignation as r');
		$this->db->join('employee_master as m','m.emp_id = r.emp_id','left');
		$this->db->join('college_master as c','m.emp_school = c.college_id','left');
		$this->db->join('department_master as d','m.department = d.department_id','left');
		$this->db->join('designation_master as dg','m.designation = dg.designation_id','left');
		$query=$this->db->get();
		return $result=$query->result_array();
    
}

public function save_resign_employee($data){
    $this->db->insert('employee_resignation', $data);
    $id=$this->db->insert_id() ;
    if($id>0){
        
        	 $this->db->where('username',$data['emp_id']);       
             $this->db->set('status','N');       		
             $this->db->set('updated_by',$this->session->userdata("uid"));    
             $this->db->set('updated_datetime',date("Y-m-d H:i:s"));		 
        echo $id = $this->db->update('user_master');
             
             $this->db->where('emp_id',$data['emp_id']);       
             $this->db->set('emp_reg','Y');       		
             $this->db->set('updated_by',$this->session->userdata("uid"));    
             $this->db->set('updated_datetime',date("Y-m-d H:i:s"));		 
             $id1 = $this->db->update('employee_master');
          
      
        
    }

}
   public function change_employee_reporting($data){
	$sql="select * from employee_reporting_master   
			 where status='Y' and  route = '".$data['route']."' and (report_person1='".$data['staffid']."' OR report_person2='".$data['staffid']."' OR report_person3='".$data['staffid']."' OR report_person4='".$data['staffid']."' ) ";
			 $query=$this->db->query($sql);		    
	 $res=$query->result_array();
	// echo $query->num_rows();
	// exit;
	 foreach($res as $val){
		// echo $data['staffid'];
		//echo $data['rstaffid'];
		if($val['emp_code'] != $data['rstaffid']){
		 if($val['report_person1'] == $data['staffid']){
			 //echo "kkk";
			 $this->db->set('status','N');
			 $this->db->where('er_id',$val['er_id']);
              $id1 = $this->db->update('employee_reporting_master');
			 // echo $this->db->last_query();
//echo $this->db->affected_rows();	
		   $arr1['emp_code'] = $val['emp_code'];
		$arr1['route'] = $val['route'];
		$arr1['report_person1'] = $data['rstaffid'];
		$arr1['report_person2'] = $val['report_person2'];
		$arr1['report_person3'] = $val['report_person3'];
		$arr1['report_person4'] = $val['report_person4'];
		$arr1['status']='Y';
		$arr1['inserted_datetime']=date("Y-m-d H:i:s");
		$arr1['inserted_by']=$this->session->userdata("uid");
		 	$insert_id =$this->db->insert('employee_reporting_master',$arr1);
		
		 }elseif($val['report_person2'] == $data['staffid']){
			 $this->db->set('status','N');
			 $this->db->where('er_id',$val['er_id']);
              $id1 = $this->db->update('employee_reporting_master');	
   $arr2['emp_code'] = $val['emp_code'];
		$arr2['route'] = $val['route'];
		$arr2['report_person1'] = $val['report_person1'];
		$arr2['report_person2'] = $data['rstaffid'];
		$arr2['report_person3'] = $val['report_person3'];
		$arr2['report_person4'] = $val['report_person4'];
		$arr2['status']='Y';
		$arr2['inserted_datetime']=date("Y-m-d H:i:s");
		$arr2['inserted_by']=$this->session->userdata("uid");
		 	$insert_id =$this->db->insert('employee_reporting_master',$arr2);
			  
		 }elseif($val['report_person3'] == $data['staffid']){
			 $this->db->set('status','N');
			 $this->db->where('er_id',$val['er_id']);
              $id1 = $this->db->update('employee_reporting_master');
 $arr3['emp_code'] = $val['emp_code'];
		$arr3['route'] = $val['route'];
		$arr3['report_person1'] = $val['report_person1'];
		$arr3['report_person2'] = $val['report_person2'];
		$arr3['report_person3'] = $data['rstaffid'];
		$arr3['report_person4'] = $val['report_person4'];
		$arr3['status']='Y';
		$arr3['inserted_datetime']=date("Y-m-d H:i:s");
		$arr3['inserted_by']=$this->session->userdata("uid");
		 	$insert_id =$this->db->insert('employee_reporting_master',$arr3);			  
		 }elseif($val['report_person4'] == $data['staffid']){
			 $this->db->set('status','N');
			 $this->db->where('er_id',$val['er_id']);
              $id1 = $this->db->update('employee_reporting_master');	
$arr4['emp_code'] = $val['emp_code'];
		$arr4['route'] = $val['route'];
		$arr4['report_person1'] = $val['report_person1'];
		$arr4['report_person2'] = $val['report_person2'];
		$arr4['report_person3'] = $val['report_person3'];
		$arr4['report_person4'] = $data['rstaffid'];
		$arr4['status']='Y';
		$arr4['inserted_datetime']=date("Y-m-d H:i:s");
		$arr4['inserted_by']=$this->session->userdata("uid");
		 	$insert_id =$this->db->insert('employee_reporting_master',$arr4);			  
		 }
	 }
	 }
	// print_r($res);
	// exit;
	 return $id1;
	}
	
	public function insert_emp_shift_time($data){
		foreach($data['emp_chk'] as $val){
			  $sql = "select * from employee_shift_time where emp_id = '".$val."' and del_status = 'N' and active_from = '".$data['activef']."'  and status='Y'";
			 $query = $this->db->query($sql);
			
			
        $scnt = $query->result_array();
		
		
		
		
		
        //echo count($scnt);
        //exit;
			if(count($scnt)!= '0'){
				$ins= 'ex';
			}else{
			$shift['emp_id']=$val;	
			$shift['in_time']=$data['emp_intime'];
			$shift['out_time']=$data['emp_outtime'];			
			$shift['active_from']=$data['activef'];
			$shift['shift_id']=$data['shift_dur'];
			$shift['created_by']=$this->session->userdata("uid");
			$shift['created_on']=date("Y-m-d H:i:s");
			$shift['status']='Y';
			/*if(date('Y-m-d',strtotime($data['activef'])) == date('Y-m-d')){
				$shift['status']='Y';
			}else{
			$shift['status']='N';
			}*/
		$ins= $this->db->insert('employee_shift_time',$shift);		
			}
		}
		return $ins;
	}
	function getAllempShifttime($s){
		
	   $this->db->select('st.*,em.fname,em.lname,em.gender,em.emp_school,em.department');
		$this->db->from('employee_shift_time as st');
		$this->db->join('employee_master as em','em.emp_id = st.emp_id','inner');
	$this->db->where('status',$s);
		$this->db->where('del_status','N');
		$this->db->order_by("em.emp_id", "asc");	 
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result_array();	
   }
   function getAllempShifttimePre(){
		
	    $sql="SELECT st.* ,e.emp_id,e.fname,e.mname ,e.lname,dept.department_name,sc.college_name,sc.college_code 
	    from employee_shift_time as st
        LEFT JOIN employee_master as e ON e.emp_id = st.emp_id
		LEFT JOIN department_master as dept ON dept.department_id = e.department
		LEFT JOIN college_master as sc ON sc.college_id = e.emp_school		
		WHERE  st.status = 'Y' and st.del_status = 'N' and st.active_from > '".date('Y-m-d')."'

		
		ORDER BY e.emp_id ASC "; 
		//echo  $sql;
		//exit;
		
		
		
		$query1=$this->db->query($sql);
		$res1=$query1->result_array();
		return $res1;
   }
   function del_emp_shift_time($id){
	    $this->db->set('del_status','Y');
			 $this->db->where('emp_shift_id',$id);
          return  $this->db->update('employee_shift_time');	
   }  
   function get_reporting_employee($txt){
	 $sql="select * from employee_reporting_master	       
	   where status = 'Y' and ( report_person1 = '".$txt."' OR report_person2 = '".$txt."' OR report_person3 = '".$txt."' ) ";
	   //exit;
	$query = $this->db->query($sql);
      return  $query->num_rows();
   }
   function getShifttime(){		
	   $this->db->select('st.*');
		$this->db->from('shift_master as st');		
		$this->db->where('status','Y');			 
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result_array();	
   }
   function get_shift_duration($id){
	   $this->db->select('st.*');
		$this->db->from('shift_master as st');		
		$this->db->where('status','Y');	
$this->db->where('shift_id',$id);		
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result_array();	
   }
    function get_emp_shift_details($emp){
	    $this->db->select('*');
		$this->db->from('employee_shift_time');		
		$this->db->where('emp_id',$emp);
$this->db->order_by("active_from", "DESC");	 		
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result_array();	
   }
   function get_emp_sch_dep($sch='',$dep=''){
	if($dep != ''){
		$dp = "and e.department='".$dep."'";
	}
	if($sch != ''){
		$sc = "and e.emp_school='".$sch."'";
	}
	 $sql="SELECT rm.roles_name ,e.emp_id,e.fname,e.mname ,e.lname,d.designation_name,dept.department_name,sc.college_name,sc.college_code from employee_master as e
        LEFT JOIN designation_master as d ON d.designation_id = e.designation
		LEFT JOIN department_master as dept ON dept.department_id = e.department
		LEFT JOIN college_master as sc ON sc.college_id = e.emp_school
		left JOIN user_master as um ON um.username = e.emp_id
		left join roles_master as rm ON rm.roles_id = um.roles_id
		WHERE  e.emp_status = 'Y' $dp $sc	
		ORDER BY e.emp_id ASC "; 
		$query1=$this->db->query($sql);
		$res1=$query1->result_array();
		return $res1;
}

function update_role_emp($data){
	foreach($data['empsid'] as $val){
	$this->db->where('username',$val);       
         $this->db->set('roles_id',$data['role_assign']);       		
         $this->db->set('updated_by',$this->session->userdata("uid"));    
        $this->db->set('updated_datetime',date("Y-m-d H:i:s"));		 
        $id = $this->db->update('user_master');
	}
		return $this->db->affected_rows();
}
function get_document_list($empid){
	
		 $sql="SELECT dm.*,sdl.doc_status,sdl.doc_ox,sdl.doc_file_path from staff_document_master as dm 
		left join 
( select doc_master_id,doc_status,doc_ox,doc_file_path from staff_document_master_list where  emp_r_id = '".$empid."'  ) as sdl on sdl.doc_master_id = dm.did
		 where 
		 dm.status='Y' ";
       
		$query1=$this->db->query($sql);
		$res1=$query1->result_array();
		return $res1;
}
function get_emp_details_emprid($erid){
		
		$this->db->select('*');
		$this->db->from('employee_master');
		$this->db->where('emp_reg_id',$erid);
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result_array();		
	}

	function insert_document_emp($data){
		//print_r($data);
		if(!empty($data['doc_id'])){
	foreach($data['doc_id'] as $docv){
		$sql = " select * from staff_document_master_list where emp_r_id = '".$data['er_id']."' and doc_master_id ='".$docv."' ";
		$query1=$this->db->query($sql);
				$res1=$query1->result_array();
				$cnt = count($res1);
				if($cnt > 0){

					$this->db->where('sdm_id',$res1[0]['sdm_id']);       
					 

				  $this->db->set('doc_status',$data['dstatus_'.$docv]);    
				   $this->db->set('doc_ox',$data['ox_'.$docv]);    
				   if(!empty($data['duploadf_'.$docv])){
				  $this->db->set('doc_file_path',$data['duploadf_'.$docv]);    
				  }    		
				 $this->db->set('updated_by',$this->session->userdata("uid"));    
				$this->db->set('updated_date',date("Y-m-d H:i:s"));		 
				$ins = $this->db->update('staff_document_master_list');

				}else{
				$cdoc['emp_r_id']=$data['er_id'];	
					$cdoc['doc_master_id']=$docv;
					$cdoc['doc_status']=$data['dstatus_'.$docv];			
					$cdoc['doc_ox']=$data['ox_'.$docv];
					$cdoc['doc_file_path']=$data['duploadf_'.$docv];
					$cdoc['created_by']=$this->session->userdata("uid");
					$cdoc['created_date']=date("Y-m-d H:i:s");
					
				$ins= $this->db->insert('staff_document_master_list',$cdoc);
				}		
				//echo $this->db->last_query();exit;
			}
		}

		return $ins;
	}
function get_emp_document_list($empid){
	
		 $sql="SELECT dm.*,sdl.* from staff_document_master as dm 
left join staff_document_master_list as sdl on dm.did = sdl.doc_master_id
		 where 
		 dm.status='Y' and  emp_r_id = '".$empid."'  order by sdl.doc_master_id ASC";
       
		$query1=$this->db->query($sql);
		$res1=$query1->result_array();
		return $res1;
}

function getEmployeeDoc($st){
	//print_r($_SESSION);
	$empid = $this->session->userdata("name");
	 $sql1= "select emp_reg_id from employee_master where emp_id = '".$empid."'";
$query11=$this->db->query($sql1);
		$res2=$query11->result_array();
//print_r($res2);
	 $sql="SELECT dm.*,sdl.* from staff_document_master as dm 
left join staff_document_master_list as sdl on dm.did = sdl.doc_master_id
		 where 
		 dm.status='Y' and  emp_r_id = '".$res2[0]['emp_reg_id']."' and sdl.doc_status='".$st."' order by sdl.doc_master_id ASC";
$query1=$this->db->query($sql);
		$res1=$query1->result_array();
		return $res1;
}

}