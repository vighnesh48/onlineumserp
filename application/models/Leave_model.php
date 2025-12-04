<?php
class Leave_model extends CI_Model {
	
	var $table = 'work_form_home';
	var $column_order = array(null, 'w_id','created_on','UserId','Intime'); //set column field database for datatable orderable
	var $column_search = array('w_id','UserId','Intime','Outtime','status','reason','leave_type','late_mark','remark','approve_status'); //set column field database for datatable searchable 
	var $order = array('w_id' => 'DESC'); // default order 
	
    function __construct()
    {
        parent::__construct();
			date_default_timezone_set('Asia/Kolkata');
    }
    
    function  get_leave_details($leave_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($leave_id!="")
        {
            $where.=" AND leave_id='".$leave_id."'";
        }
        
        $sql="select leave_id,ltype,lstatus From leave_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }  
    function get_employee_leave_allocation_bycode_type($empcode,$typ,$year){
        
      $this->db->select('*');
		$this->db->where('employee_id',$empcode);	
			$this->db->where('academic_year',$year);
			$this->db->where('leave_type',$typ);
		$this->db->from('employee_leave_allocation');
	
		$query=$this->db->get();
		$result=$query->result_array();
	//echo $this->db->last_query();
	//exit;
		return $result;
   }
    function add_employee_leave($data){
	   //print_r($data);exit;
	   $cnt = $this->get_employee_leave_allocation_bycode_type($data['staffid'],$data['leave_type'],$data['year']);
        if(count($cnt)<1){
        	//echo count($cnt); exit;
	   $arr['employee_id']=(stripcslashes($data['staffid']));
	   $arr['leave_type']=(stripcslashes($data['leave_type']));
	   $arr['leaves_allocated']=(stripcslashes($data['no_leave_allocate']));
	   $arr['academic_year']=(stripcslashes($data['year']));
	   $arr['remark']=(stripcslashes($data['remark']));
	  
	  $arr['entry_by']=$this->session->userdata("uid");
		$arr['entry_on']=date("Y-m-d H:i:s");
       $insert_id = $this->db->insert('employee_leave_allocation',$arr);
     $ins_id=$this->db->insert_id();
     // return $ins_id;
        }else{
			$ins_id = 'err';
		}
		return $ins_id;
	   
   }
    function add_employee_leave_allocation($data){
    	foreach($data['empid'] as $emp){
        $cnt = $this->get_employee_leave_allocation_bycode_type($emp,$data['leave_type'],$data['year']);
        if(count($cnt)<1){
	   $arr['employee_id']=(stripcslashes($emp));
	   $arr['leave_type']=(stripcslashes($data['leave_type']));
	   $arr['leaves_allocated']=(stripcslashes($data['no_leave_allocate']));
	   $arr['academic_year']=(stripcslashes($data['year']));
	   $arr['remark']=(stripcslashes($data['remark']));
	  
	  $arr['entry_by']=$this->session->userdata("uid");
		$arr['entry_on']=date("Y-m-d H:i:s");
       $insert_id = $this->db->insert('employee_leave_allocation',$arr);
     $ins_id=$this->db->insert_id();
      
     // return $ins_id;
        }else{
  $lv = $this->get_emp_leaves($emp,$data['leave_type'],$data['year']);
		$t_lv = $data['no_leave_allocate']+$lv[0]['leaves_allocated'];
		
		 $this->db->where('employee_id',$emp) ; 
		 $this->db->where('id',$lv[0]['id']) ; 
		  $this->db->where('leave_type',$data['leave_type']) ; 
	  $this->db->set('leaves_allocated',$t_lv);
	  $this->db->set('remark',$data['remark']);
        $this->db->set('modify_by',$this->session->userdata("uid"));
$this->db->set('modify_on',date("Y-m-d H:i:s"));		
	 $this->db->update('employee_leave_allocation');
        $ins_id= $this->db->affected_rows();	 


		  // return $ins_id;
        }
		}
		return $ins_id;
       
       
	// echo $this->db->last_query();
	 //exit;
   }	
   function get_employee_leave_allocation($yer=''){
	   $this->db->select('*');
	if(!empty($yer)){
		$this->db->where('academic_year',$yer);
	   }else{
		   $yer =  date('Y',strtotime('-1 year'))."-".date('y');
		 $this->db->where('academic_year',$yer);  
	   }		
		//$this->db->where('status','Y');
		
		$this->db->where('employee_id NOT IN (SELECT emp_id from employee_resignation where status="Y")', NULL, FALSE);
		$this->db->from('employee_leave_allocation');
		$this->db->group_by('employee_id'); 
		$query=$this->db->get();
		$result=$query->result_array();
		
		//echo $this->db->last_query();
		//exit;
		
		return $result;
   }
   function get_employee_code($txt){
   	if($txt !=''){
   		$st ="and ( em.emp_id like '%".$txt."%' OR em.fname like '%".$txt."%' OR em.lname like '%".$txt."%' )";
   	}
	  $sql="select em.emp_id,em.fname,em.lname,em.gender,em.emp_reg,cm.college_code,cm.college_name,dpm.department_name,dsm.designation_name from employee_master as em
	    inner join college_master as cm on cm.college_id = em.emp_school
		inner join designation_master as dsm on dsm.designation_id = em.designation
		inner join department_master as dpm on dpm.department_id = em.department	   
	   where em.emp_reg='N' $st order by emp_id ASC";
	$query = $this->db->query($sql);
      return  $res=$query->result_array();
   }
   function get_emp_leaves($empid,$lev,$y=''){
	   $this->db->select('*');
		$this->db->where('employee_id',$empid);		
		$this->db->where('leave_type',$lev);
		$this->db->from('employee_leave_allocation');
		//$this->db->group_by('employee_id'); 
		if(!empty($y)){
			$this->db->where('academic_year',$y);
		}else{
			//echo "kk";
			$cyer = $this->config->item('current_year');
			$this->db->where('academic_year',$cyer);
		}
		$query=$this->db->get();
		$result=$query->result_array();
		//echo $this->db->last_query();exit;
		return $result;
   }
   function get_employee_leave_allocation_byid($id,$yer=''){
	    $this->db->select('*');
		$this->db->where('employee_id',$id);
		if($yer!=''){
		$this->db->where('academic_year',$yer);	
		}	
		$this->db->from('employee_leave_allocation');
		$this->db->group_by('employee_id'); 
		$query=$this->db->get();
		$result=$query->result_array();
		//echo $this->db->last_query();
		return $result;
   }
   function get_employee_leave_type($id,$yer=''){

$cyer = $this->config->item('current_year2');
	    $this->db->select('*');
		$this->db->where('employee_id',$id);
		$this->db->where('status','Y');
		if($yer != ''){
		$this->db->where('academic_year',$yer);
		}else{
		$this->db->where('academic_year', $cyer);
			}
		$this->db->from('employee_leave_allocation');
		
		$query=$this->db->get();
		$result=$query->result_array();
		//echo $this->db->last_query();exit;
		return $result;
   }
   
   
   function update_employee_leave_allocation($data){
	   $empid = $data['staffid'];
	   $ltyp = $this->get_employee_leave_type($empid,$data['year']);
	   
	   foreach($ltyp as $val){
	   $lev_allocated=(stripcslashes($data['no_leave_allocate_'.$val['leave_type']]));	  
	   $rem =(stripcslashes($data['remark_'.$val['leave_type']]));
	  
	  $modify_by=$this->session->userdata("uid");
		$modify_on=date("Y-m-d H:i:s");
		
		$this->db->where('academic_year',$data['year']) ;	
		 $this->db->where('employee_id',$empid) ; 
		  $this->db->where('leave_type',$val['leave_type']) ; 
	  $this->db->set('leaves_allocated',$lev_allocated);
	  $this->db->set('remark',$rem);
        $this->db->set('modify_by',$modify_by);
$this->db->set('modify_on',$modify_on);		
	 $this->db->update('employee_leave_allocation');
        $i= $this->db->affected_rows();	 
    
	   }
	// echo $this->db->last_query();
	 //exit;
   }
   function fetchEmployeeData($id){
		$this->db->select("e.*,ot.*,d.*,st.emp_cat_name,s.college_name,ds.designation_name,de.department_name,sh.shift_name,bk.bank_name,lv.*");
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
		$this->db->where('e.emp_id',$id);
		$this->db->where('e.emp_status','Y');
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
	function check_leave_bydate($empid,$fdate,$tdate){

	  
		//SELECT * FROM leave_applicant_list WHERE emp_id='234232' AND ( `applied_from_date` BETWEEN '2017-09-15' AND '2017-09-17') OR ( `applied_to_date` BETWEEN '2017-09-15' AND '2017-09-17')
	//	$sql= "SELECT * FROM leave_applicant_list                
       //        WHERE emp_id='$empid'  AND (applied_from_date BETWEEN '$date' AND '$date1' ) OR (applied_to_date BETWEEN '$date' AND '$date1')  ";
//echo $sql;
//exit;
		$ldate =array();
$sql = "SELECT * FROM leave_applicant_list WHERE emp_id='$empid' and ( fstatus != 'Rejected' AND fstatus != 'Cancel' )  ";

			   $query=$this->db->query($sql);
		$result=$query->result_array();

foreach ($result as $key => $value) {
	  
        $begin = new DateTime($value['applied_from_date']);
      
        $end = new DateTime($value['applied_to_date'].' +1 day');
    
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
    	return $cnt = '1';
    }else{
    	$cnt = '0';
    }
}



		//echo count($result);

		//echo $this->last_query();
		//exit;
		return $cnt;		
	}
		function check_leave_bytype($empid,$date,$lt){
	   // echo "kkk".$date;
	   // echo "ppp".$date1;
	   $tdate = date('Y-m-t',strtotime($date));
	   $fdate = date('Y-m-1',strtotime($date));
		$sql= "SELECT sum(no_days) as nod FROM leave_applicant_list                
               WHERE emp_id='$empid' AND (fstatus != 'Rejected' && fstatus != 'Cancel') AND leave_type = '$lt' AND (applied_from_date BETWEEN '$fdate' AND  '$tdate' )";

			   $query=$this->db->query($sql);
		$result=$query->result_array();
	//	echo $this->last_query();
	//	exit;
		return $result[0]['nod'];		
	}
	function addtask_to_employee($data){
		date_default_timezone_set('Asia/Kolkata');
		$app_type = $data['apply_leave_type'];
		$fdate = date('Y-m-d',strtotime($data['leave_applied_from_date']));
		$tdate = date('Y-m-d',strtotime($data['leave_applied_to_date']));
		$app_type = $data['apply_leave_type'];
		$academic_year = explode('~', $data['academic_year']);
		$leave['from_date']=$fdate;
		$leave['to_date']=$tdate;
		$diff = abs(strtotime($fdate) - strtotime($tdate));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		$leave['no_days']=$days !=0 ? $days : 1;
		$leave['academic_year']=$academic_year[0];
		$leave['stream_id']=$data['stream_id'];	
		$leave['semester']=$data['semester'];
		$leave['duration']=$data['leave_duration'];	
		$leave['reason']=$data['reason'];
		$leave['inserted_by']=$this->session->userdata("uid");
		$leave['assigned_by']=$this->session->userdata("uid");
		$leave['inserted_datetime']=date("Y-m-d H:i:s");		
		$leave['applied_on_date']=date("Y-m-d");
		$leave['other_task']=$data['other_task'];
		if($data['other_task']==1 || $data['other_task']==3)
			{ // if iv and all
				$division =$data['division']; 	
				$this->db->select("e.emp_id,s.division");
				$this->db->from('sandipun_ums.lecture_time_table s');
				$this->db->join('sandipun_erp.employee_master e', 's.faculty_code = e.emp_id');
				$this->db->where('s.stream_id',$data['stream_id']);
				$this->db->where('s.semester',$data['semester']);
				$this->db->where('e.emp_status','Y');
				$this->db->where('s.academic_year',$academic_year[0]);
				$this->db->where_in('s.division',$division);
				$this->db->group_by('e.emp_id');
				$fd = $this->db->get()->result();
				if(!empty($fd))	{
					foreach($fd as $row){
						$leave['emp_id']=$row->emp_id;
						$leave['divison']=$row->division;
						$this->db->insert('emp_other_task_list',$leave);
					}
					return 1;
				}
			}
			else{
					$leave['emp_id']= $data['emp_id'];
					$leave['divison']=$data['division'][0];
					
					if(isset($data['emp']['ch'])){
					$leave['replaced_employee_id']=$data['emp']['ch'][0];	
					}
					
					$this->db->insert('emp_other_task_list',$leave);
					return 1;
			}
		}
	
	function addEmpLeave($data){
		//"kk".print_r($data);
		//echo "kkk";
		//exit;
		if($data['vl_leave']=='vl'){
			$info = $this->get_vid_emp_allocation($data['leave_type']);
$data['leave_applied_from_date']  = $info[0]['from_date'];
$data['leave_applied_to_date'] = $info[0]['to_date'];
			
		}
		date_default_timezone_set('Asia/Kolkata');
	 $app_type = $data['apply_leave_type'];
		if($app_type == 'OD'){
			
			if($data['od_duration']=='full-day'){
				 $fdate = date('Y-m-d',strtotime($data['applied_from_date']));
	    $tdate = date('Y-m-d',strtotime($data['od_applied_to_date']));
			 
		}elseif($data['od_duration']=='hrs'){
			 $fdate=date('Y-m-d',strtotime($data['applied_from_date']));
			 $tdate=date('Y-m-d',strtotime($data['applied_from_date']));
		}			
		}
		if($app_type == 'leave'){
	  $fdate = date('Y-m-d',strtotime($data['leave_applied_from_date']));
	    $tdate = date('Y-m-d',strtotime($data['leave_applied_to_date']));
		}
 $cnt = $this->check_leave_bydate($data['emp_id'],$fdate,$tdate);
		 
	//exit;
	if($cnt<1){
	   
		$app_type = $data['apply_leave_type'];
	if($app_type == 'leave'){
	    //echo "leave";exit;
		//seperating array for leave and alternative for leave
		$leave['emp_id']=$data['emp_id'];
	//	$leave['ename']=$data['ename'];
	$fdate = date('Y-m-d',strtotime($data['leave_applied_from_date']));
		$leave['applied_from_date']=$fdate;	
		
		
		if($data['leave_duration']=='half-day'){
			$leave['applied_to_date']=$leave['applied_from_date'];
		}else{
		    	$tdate = date('Y-m-d',strtotime($data['leave_applied_to_date']));
			  $leave['applied_to_date']=$tdate;    
		}
       	$leave['no_days']=$data['no_days'];	
      // 	if($data['leave_type']=='lwp'){
//$leave['leave_type']= '9';
     //  	}else{
       	$leave['leave_type']=$data['leave_type'];
       //	}	
       	$leave['leave_duration']=$data['leave_duration'];	
       	$leave['medical_certificate']=$data['medical_cert'];
		
//$leave['designation']=$data['designation'];	
 //      	$leave['department']=$data['department'];	
 //      	$leave['school']=$data['school'];	
       	$leave['reason']=$data['reason'];	
       	$leave['gate_pass']=$data['gate_pass'];	
      //	$leave['reporting_school']=$data['reporting_school'];	
      // 	$leave['reporting_dept']=$data['reporting_dept'];	
     //  	$leave['reporting_dept']=$data['reporting_dept'];	
       	$leave['leave_contct_address']=$data['leave_contct_address'];	
       	$leave['leave_contct_no']=$data['leave_contct_no'];       
		$data['applied_on_date']=date("Y-m-d");
		$leave['applied_on_date']=$data['applied_on_date'];	
		//$leave['ro_forward']='Y';	//forwarded to ro set flag true...
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
//echo $data['leave_type'];
       $empr = $this->get_reporting_person($data['emp_id'],$data['leave_type']);
		//print_r($emp);
	//	exit;
		$leave['emp1_reporting_person']=$empr[0]['report_person1'];
		$leave['leave_apply_type']='Leave';
		$leave['fstatus']='Pending';
		
		$leave['emp2_reporting_person']=$empr[0]['report_person2'];	
		
		$leave['emp3_reporting_person']=$empr[0]['report_person3'];	
		$leave['emp4_reporting_person']=$empr[0]['report_person4'];	
//print_r($leave);
//exit;	
       $ltyp = $this->getLeaveTypeById($data['leave_type']);
   
 if($ltyp == 'CL' || $ltyp =='Leave'){
       $cl_cnt = $this->check_leave_bytype($data['emp_id'],$leave['applied_from_date'],$leave['leave_type']);
        $tcl_cnt = $cl_cnt + $data['no_days'];
        //exit;
        if($tcl_cnt > 3 ){
            return 'lexd';
        }
            
        }
		$ins=$this->db->insert('leave_applicant_list',$leave);
		$ins_id=$this->db->insert_id();
//		echo $this->db->last_query();
//		exit;
		if(!empty($ins_id)&&$ins_id>0){
$ltyps = $this->getLeaveTypeById($data['leave_type']);
if($ltyps =='ML'){
	$mlarr['leave_id'] = $ins_id;
	$mlarr['inserted_by'] = $this->session->userdata("uid");
	$mlarr['inserted_date'] = date("Y-m-d H:i:s");
	$insml=$this->db->insert('ml_approve_list',$mlarr);
}

			//add leave alternative details if available
		for($i=0;$i<count($alter);$i++){
			//$this->db->insert('leave_alternative_details');
			$fdate = date('Y-m-d',strtotime($alter[$i][4]));
			$tdate = date('Y-m-d',strtotime($alter[$i][5]));
			$sql="insert into leave_alternative_details set 
			lid ='".$ins_id."',
			lv_for_empid='".$alter[$i][0]."',
			school_id='".$alter[$i][1]."',
			depart_id='".$alter[$i][2]."',
			alter_staff_id='".$alter[$i][3]."',
			from_dt='".$fdate."',
			to_dt='".$tdate."',
			no_of_days='".$alter[$i][6]."'
			";
			$query=$this->db->query($sql);				
			}				
			return $ins_id;
		}
		}elseif($app_type == 'OD'){
		     //print_r($data);
		    // 0exit();
			$od['emp_id']=$data['emp_id'];
		//$od['ename']=$data['ename'];
		$od['applied_from_date']=date('Y-m-d',strtotime($data['applied_from_date']));
		if($data['od_duration']=='half-day'){
			$od['applied_to_date']=date('Y-m-d',strtotime($od['applied_from_date']));
		}elseif($data['od_duration']=='full-day'){
			  $od['applied_to_date']=date('Y-m-d',strtotime($data['od_applied_to_date']));    
		}elseif($data['od_duration']=='hrs'){
			 $od['applied_from_date']=date('Y-m-d',strtotime($data['applied_from_date']));
			 $od['applied_to_date']=date('Y-m-d',strtotime($data['applied_from_date']));
		}		
		//echo $data['od_departure_time'];
		//echo $data['od_arrival_time'];
		$od['no_days']=$data['no_days_forod'];
		$dtime = $od['applied_from_date']." ".$data['od_departure_time'];
		$atime = $od['applied_from_date']." ".$data['od_arrival_time'];
		$od['departure_time']=date('Y-m-d G:i:s',strtotime($dtime));
		$od['arrival_time']=date('Y-m-d G:i:s',strtotime($atime));//$data['od_arrival_time'];
		$od['no_hrs']=$data['no_hrs_forod'];

		//echo $od['departure_time'];
         // echo $od['arrival_time'];
        //  exit;
	///	$od['designation']=$data['designation'];
	//$od['department']=$data['department'];
	//	$od['school']=$data['school'];
		$od['leave_type']=$data['od_type'];
		$od['leave_duration']=$data['od_duration'];
		$od['gate_pass']=$data['gate_pass'];
		$od['reason']=$data['reason_od'];		
		$od['leave_contct_address']=$data['location_od'];
		$od['l_od_state']=$data['state'];
		$od['l_od_city']=$data['city'];
		$od['leave_contct_no']=$data['od_contct_no'];
		$od['applied_on_date']=date('Y-m-d h:i:s');
		$od['od_document']=$data['od_cert_new'];
		//$od['staff_along_od']=$data['facilty_with'];
		$od['inserted_by']=$this->session->userdata("uid");
		$od['inserted_datetime']=date("Y-m-d H:i:s");
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
		$emp = $this->get_reporting_person($data['emp_id'],'OD');
		//$emp_stf_type = $this->fetchEmployeeData($data['emp_id']);
		//if($data['emp_id'] != $data['officer_id'] && $emp_stf_type[0]['staff_type'] == '3'){
		//$rep_arr = array();
		//for($i=1;$i<=4;$i++){
		//	if($emp[0]['report_person'.$i]!=''){
		//	$rep_arr[] =  $emp[0]['report_person'.$i];
		//	}
		//}
		//echo $data['emp_id'];
		//print_r($rep_arr);
		//echo $data['officer_id'];
		//$ser = array_search($data['officer_id'],$rep_arr);
		//echo $ser;
		//if (($key = array_search($data['officer_id'], $rep_arr)) !== false) {
  //  unset($rep_arr[$key]);
//}
  // array_unshift($rep_arr,$data['officer_id']);
		
		//$od['emp1_reporting_person']=$rep_arr[0];
		//$od['leave_apply_type']='OD';
	//	$od['fstatus']='Pending';	
	//	$od['emp2_reporting_person']=$rep_arr[1];			
	//	$od['emp3_reporting_person']=$rep_arr[2];	
	//	$od['emp4_reporting_person']=$rep_arr[3];	
		//print_r($od);
		//exit();
	//	}else{
		$od['emp1_reporting_person']=$emp[0]['report_person1'];
		$od['leave_apply_type']='OD';
		$od['fstatus']='Pending';	
		if(($emp[0]['report_person1']==110096)){
		//$od['emp2_reporting_person']=110003;	
		}else{
		$od['emp2_reporting_person']=$emp[0]['report_person2'];		
		}
		$od['emp3_reporting_person']=$emp[0]['report_person3'];
		$od['emp4_reporting_person']=$emp[0]['report_person4'];
	//	}
				if($_POST['emp_id']=="210510"){
		//print_r($data);
		//echo'<br>';
		// print_r($od);
		 // exit();
			}
		$ins=$this->db->insert('leave_applicant_list',$od);
		$ins_id=$this->db->insert_id();
		//echo $this->db->last_query();
		//exit;
		if(!empty($ins_id)&&$ins_id>0){
			//add OD alternative details if available
			
				for($i=0;$i<count($od_alter);$i++){
					$fdate = date('Y-m-d',strtotime($od_alter[$i][4]));
			$tdate = date('Y-m-d',strtotime($od_alter[$i][5]));
			//$this->db->insert('leave_alternative_details');
			$sql="insert into leave_alternative_details set 
			lid ='".$ins_id."',
			lv_for_empid='".$od_alter[$i][0]."',
			school_id='".$od_alter[$i][1]."',
			depart_id='".$od_alter[$i][2]."',
			alter_staff_id='".$od_alter[$i][3]."',
			from_dt='".$fdate."',
			to_dt='".$tdate."',
			no_of_days='".$od_alter[$i][6]."',
				alter_for_duration='".$od_alter[$i][7]."'
			";
			$query=$this->db->query($sql);				
			}		
		
			return $ins_id;
		}	
	
		}
	}else{
	    return 'lAD';
	}
		
	}
	
	function get_leave_route($lt){
		$this->db->select('*');
		$this->db->from('leave_master');
		$this->db->where('ltype',$lt);
		$this->db->where('lstatus','Y');
		$query=$this->db->get();
		//	echo $this->db->last_query();
	//	exit;
		$result=$query->result_array();
		return $result;
	}
	function get_reporting_person($emp,$lt){
		//echo $lt;
		//exit;
	if($lt!='OD'){
		//if()
		$lr = $this->getLeaveTypeById($lt);
	}else{
	    $lr = $lt;
	}
//print_r($lr);
			
	//	print_r($lty);
//echo $emp;
		if($lt =='lwp' || $lt == 'LWP' || $lt == 'WFH'){
           $lr = '1';
		}else{
			$lty = $this->get_leave_route($lr);	
		$lr =	$lty[0]['route'];
		}
		$this->db->select('*');
		$this->db->from('employee_reporting_master');
		$this->db->where('emp_code',$emp);
		$this->db->where('status','Y');
		$this->db->where('route',$lr);
		$query=$this->db->get();
		//echo $this->db->last_query();
		//exit;
		$result=$query->result_array();
		
		return $result;
	}
	function getLeaveDetailById($id){
		$sql= "SELECT l.*,e.* FROM leave_applicant_list as l 
               inner join employee_master as e on e.emp_id=l.emp_id
               WHERE l.lid='$id' ";
			   $query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;	
  }
  function getLeaveAlternativeDetailById($id){
		$sql= "SELECT * FROM leave_alternative_details 
             
               WHERE lid='$id' ";
			   $query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;	
  }
  	function remove_leave_application($id){
		 //$sql="update leave_applicant_list set vstatus='N',updated_by='".$this->session->userdata("uid")."' where lid='$id'";
         $this->db->where('lid',$id);       
         $this->db->set('vstatus','N');       
         $this->db->set('updated_by',$this->session->userdata("uid"));       
          $this->db->update('leave_applicant_list');
	//   $this->db->query($sql);	 
/* echo $this->db->last_query($query);
		die();	 */	
	  return ($this->db->affected_rows() != 1) ? false : true;
	}
  
  function getLeaveTypeById($id){
			$this->db->select('leave_type');
		$this->db->from('employee_leave_allocation');
		$this->db->where('id',$id);
		$query=$this->db->get();
		$res=$query->result_array();
		//echo $this->db->last_query();
		return $res[0]['leave_type'];
	}
	function getLeaveTypeById1($id){
			$this->db->select('ltype');
		$this->db->from('leave_master');
		$this->db->where('leave_id',$id);
		$query=$this->db->get();
		$res=$query->result_array();
		//echo $this->db->last_query();
		return $res[0]['ltype'];
	}
	
	function update_used_leaves($eid,$lty,$status,$nod,$ld,$yer=''){
//echo $eid."kk";
//echo $lty;
 $lty1 = $this->getLeaveTypeById($lty);
//exit;
	    $this->db->select('*');
		$this->db->from('employee_leave_allocation');
		$this->db->where('employee_id',$eid);
if($yer != ''){
		$this->db->where('academic_year',$yer);
		}else{
		$this->db->where('academic_year', $this->config->item('current_year2'));	
		}
		if($lty1 == 'VL'){
		$this->db->where('id',$lty);
	}else{
		$this->db->where('leave_type',$lty1);

	}
		$query=$this->db->get();
		$res=$query->result_array();
		$ul = $res[0]['leave_used'];
		//print_r($res);exit;
		if($status == 'Pending'){
			if($ld == 'half-day'){
				$ul = $ul + 0.5;
			}else{
		$ul = $ul+$nod;
			}
		 $this->db->where('id',$res[0]['id']);
	  $this->db->where('employee_id',$eid);
      	$this->db->set('leave_used',$ul);  
	$upid= $this->db->update('employee_leave_allocation');
		}elseif($status == 'Rejected'){
			if($ld == 'half-day'){
				$ul = $ul - 0.5;
			}else{
	if($lty1 == 'VL'){
					$ul  = 0;
				}else{
	$ul = $ul-$nod;
			}
			}
		 $this->db->where('id',$res[0]['id']);
	  $this->db->where('employee_id',$eid);
      	$this->db->set('leave_used',$ul);  
	$upid= $this->db->update('employee_leave_allocation');
		}
	return $upid;
	    
	}
	
	function update_leave_applicationDetails($data){
		
		
		
		if($data['status'] == 'Cancel'){
			
	  $this->db->where('lid',$data['lid']) ;
	  $this->db->where('emp_id',$data['emp_id']); 
	  $this->db->set('adm_comment',$data['remark']);
	  $this->db->set('adm_comment_date',date("Y-m-d H:i:s"));
	  $this->db->set('fstatus',$data['status']);
	  
	  $upid= $this->db->update('leave_applicant_list');
		
		if($data['leave_type'] != 'OD'){//official	
	  $lst = $this->update_used_leaves($data['emp_id'],$data['leave_type'],'Rejected',$data['no_days'],$data['leave_duration']);
		}
	//echo $data['applied_from_date'];
//echo $data['applied_to_date'];
	 
//exit;
	if($upid!=0 && !empty($upid)){
		 return true;
		 }  
			
		}else{
if($data['leave_type']=='OD'){//official
			$date = new DateTime($data['applied_from_date']);
		}else{
$date = new DateTime($data['applied_to_date']);
		}
		
$now = new DateTime();
if($data['status'] == 'Approved'){	
	
if($date < $now) {
	
	if(!empty($data['applied_to_date'])){
	$begin1 = new DateTime($data['applied_from_date']);
      
        $end1 = new DateTime($data['applied_to_date'].' +1 day');
    
$daterange1 = new DatePeriod($begin1, new DateInterval('P1D'), $end1);
//print_r($daterange1);
//exit;
foreach($daterange1 as $date){
	//echo $date->format("d-m-Y");
	if($data['leave_duration']=='full-day' ){
		 $nod = '1';
	}else{
		$nod = $data['no_days'];
	}
	$sql="update punching_backup set status='leave',leave_type='".$data['leave_name']."',leave_duration = '".$nod."',remark='".$data['leave_duration']."' where UserId='".$data['emp_id']."' and day(Intime) = '".$date->format('d')."' and month(Intime) = '".$date->format('m')."' and year(Intime) = '".$date->format('Y')."'";
    	// exit();
		 $upid= $this->db->query($sql);	  
}		 
}else{
	if($data['leave_duration']=='full-day' ){
		 $nod = '1';
	}else{
		$nod = $data['no_days'];
	}
	$sql="update punching_backup set status='leave',leave_type='".$data['leave_name']."',leave_duration = '".$nod."',remark='".$data['leave_duration']."' where UserId='".$data['emp_id']."' and day(Intime) = '".date('d',strtotime($data['applied_from_date']))."' and month(Intime) = '".date('m',strtotime($data['applied_from_date']))."' and year(Intime) = '".date('Y',strtotime($data['applied_from_date']))."'";
    	// exit();
		 $upid= $this->db->query($sql);	  
}
}


}
	
//}		
		$emp = $data['emp_lev'];

if($emp == 'emp1_reporting_person'){
	
	 $this->db->where('lid',$data['lid']);
	  $this->db->where('emp_id',$data['emp_id']); 
	   $this->db->set('emp1_reporting_status',$data['status']);
	  // if($data['status'] == 'Approved'){
		 $this->db->set('fstatus',$data['status']);
	//}
	  $this->db->set('emp1_reporting_remark',$data['ro_recommendation']);
	  $this->db->set('emp1_reporting_date',date("Y-m-d H:i:s"));
	  $upid= $this->db->update('leave_applicant_list');
}elseif($emp == 'emp2_reporting_person'){
	 $this->db->where('lid',$data['lid']) ;
	  $this->db->where('emp_id',$data['emp_id']); 
	   $this->db->set('emp2_reporting_status',$data['status']);
	  $this->db->set('emp2_reporting_remark',$data['ro_recommendation']);
	 //  if($data['status'] == 'Approved'){
		 $this->db->set('fstatus',$data['status']);
//	}
	  $this->db->set('emp2_reporting_date',date("Y-m-d H:i:s"));
	  $upid= $this->db->update('leave_applicant_list');
	
}elseif($emp == 'emp3_reporting_person'){
	
	$this->db->where('lid',$data['lid']) ;
	  $this->db->where('emp_id',$data['emp_id']); 
	   $this->db->set('emp3_reporting_status',$data['status']);
	  $this->db->set('emp3_reporting_remark',$data['ro_recommendation']);
	 //  if($data['status'] == 'Approved'){
		 $this->db->set('fstatus',$data['status']);
//	}
	  $this->db->set('emp3_reporting_date',date("Y-m-d H:i:s"));
	  $upid= $this->db->update('leave_applicant_list');
}elseif($emp == 'emp4_reporting_person'){
	
	$this->db->where('lid',$data['lid']) ;
	  $this->db->where('emp_id',$data['emp_id']); 
	   $this->db->set('emp4_reporting_status',$data['status']);
	  $this->db->set('emp4_reporting_remark',$data['ro_recommendation']);
	 //  if($data['status'] == 'Approved'){
		 $this->db->set('fstatus',$data['status']);
//	}
	  $this->db->set('emp4_reporting_date',date("Y-m-d H:i:s"));
	  $upid= $this->db->update('leave_applicant_list');
}
if($data['status'] == 'Rejected' || $data['status'] == 'Cancel'){
  $lst = $this->update_used_leaves($data['emp_id'],$data['leave_type'],'Rejected',$data['no_days'],$data['leave_duration']);
}
     if($upid!=0 && !empty($upid)){
		 return true;
		 }   	   
	  }
  }
  /////////////////////////////////////////////////////////////////////////////////////////////////////
  function update_leave_applicationDetails_group($data){
		
		
		//echo $data[0]['leave_name'];
		//exit;
		if($data[0]['status'] == 'Cancel'){
			
	  $this->db->where('lid',$data[0]['lid']) ;
	  $this->db->where('emp_id',$data[0]['emp_id']); 
	  $this->db->set('adm_comment',$data[0]['remark']);
	  $this->db->set('adm_comment_date',date("Y-m-d H:i:s"));
	  $this->db->set('fstatus',$data[0]['status']);
	  
	  $upid= $this->db->update('leave_applicant_list');
		
		if($data[0]['leave_type'] != 'OD'){	//official
	  $lst = $this->update_used_leaves($data[0]['emp_id'],$data[0]['leave_type'],'Rejected',$data[0]['no_days'],$data[0]['leave_duration']);
		}
	//echo $data['applied_from_date'];
//echo $data['applied_to_date'];
	 
//exit;
	if($upid!=0 && !empty($upid)){
		 return true;
		 }  
			
		}else{
if($data[0]['leave_type']=='OD'){ //official
			$date = new DateTime($data[0]['applied_from_date']);
		}else{
$date = new DateTime($data[0]['applied_to_date']);
		}
		
$now = new DateTime();
if($data[0]['status'] == 'Approved'){	
	
if($date < $now) {
	
	if(!empty($data[0]['applied_to_date'])){
	$begin1 = new DateTime($data[0]['applied_from_date']);
      
        $end1 = new DateTime($data[0]['applied_to_date'].' +1 day');
    
$daterange1 = new DatePeriod($begin1, new DateInterval('P1D'), $end1);
//print_r($daterange1);
//exit;
foreach($daterange1 as $date){
	//echo $date->format("d-m-Y");
	if($data[0]['leave_duration']=='full-day' ){
		 $nod = '1';
	}else{
		$nod = $data[0]['no_days'];
	}
	 $sql="update punching_backup set status='leave',leave_type='".$data[0]['leave_name']."',leave_duration = '".$nod."',remark='".$data[0]['leave_duration']."' where UserId='".$data[0]['emp_id']."' and day(Intime) = '".$date->format('d')."' and month(Intime) = '".$date->format('m')."' and year(Intime) = '".$date->format('Y')."'";
    	// exit();
		 $upid= $this->db->query($sql);	  
}		 
}else{
	if($data[0]['leave_duration']=='full-day' ){
		 $nod = '1';
	}else{
		$nod = $data[0]['no_days'];
	}
	$sql="update punching_backup set status='leave',leave_type='".$data[0]['leave_name']."',leave_duration = '".$nod."',remark='".$data[0]['leave_duration']."' where UserId='".$data[0]['emp_id']."' and day(Intime) = '".date('d',strtotime($data[0]['applied_from_date']))."' and month(Intime) = '".date('m',strtotime($data[0]['applied_from_date']))."' and year(Intime) = '".date('Y',strtotime($data[0]['applied_from_date']))."'";
    	// exit();
		 $upid= $this->db->query($sql);	  
}
}


}
	
//}		
		$emp = $data[0]['emp_lev'];

if($emp == 'emp1_reporting_person'){
	
	 $this->db->where('lid',$data[0]['lid']);
	  $this->db->where('emp_id',$data[0]['emp_id']); 
	   $this->db->set('emp1_reporting_status',$data[0]['status']);
	  // if($data['status'] == 'Approved'){
		 $this->db->set('fstatus',$data[0]['status']);
	//}
	  $this->db->set('emp1_reporting_remark',$data[0]['ro_recommendation']);
	  $this->db->set('emp1_reporting_date',date("Y-m-d H:i:s"));
	  $upid= $this->db->update('leave_applicant_list');
}elseif($emp == 'emp2_reporting_person'){
	 $this->db->where('lid',$data[0]['lid']) ;
	  $this->db->where('emp_id',$data[0]['emp_id']); 
	   $this->db->set('emp2_reporting_status',$data[0]['status']);
	  $this->db->set('emp2_reporting_remark',$data[0]['ro_recommendation']);
	 //  if($data['status'] == 'Approved'){
		 $this->db->set('fstatus',$data[0]['status']);
//	}
	  $this->db->set('emp2_reporting_date',date("Y-m-d H:i:s"));
	  $upid= $this->db->update('leave_applicant_list');
	
}elseif($emp == 'emp3_reporting_person'){
	
	$this->db->where('lid',$data[0]['lid']) ;
	  $this->db->where('emp_id',$data[0]['emp_id']); 
	   $this->db->set('emp3_reporting_status',$data[0]['status']);
	  $this->db->set('emp3_reporting_remark',$data[0]['ro_recommendation']);
	 //  if($data['status'] == 'Approved'){
		 $this->db->set('fstatus',$data[0]['status']);
//	}
	  $this->db->set('emp3_reporting_date',date("Y-m-d H:i:s"));
	  $upid= $this->db->update('leave_applicant_list');
}elseif($emp == 'emp4_reporting_person'){
	
	$this->db->where('lid',$data[0]['lid']) ;
	  $this->db->where('emp_id',$data[0]['emp_id']); 
	   $this->db->set('emp4_reporting_status',$data[0]['status']);
	  $this->db->set('emp4_reporting_remark',$data[0]['ro_recommendation']);
	 //  if($data['status'] == 'Approved'){
		 $this->db->set('fstatus',$data[0]['status']);
//	}
	  $this->db->set('emp4_reporting_date',date("Y-m-d H:i:s"));
	  $upid= $this->db->update('leave_applicant_list');
}
if($data[0]['status'] == 'Rejected' || $data[0]['status'] == 'Cancel'){
  $lst = $this->update_used_leaves($data[0]['emp_id'],$data['leave_type'],'Rejected',$data[0]['no_days'],$data[0]['leave_duration']);
}
     if($upid!=0 && !empty($upid)){
		 return true;
		 }   	   
	  }
  }
  
 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
  
  
	function getAllLeaveApplicantList($ty,$mon=''){ //For Admin
		if(!empty($mon)){
			 $mon_ex = explode('-',$mon);
			 $mon_sql = 'and month(applied_from_date)="'.$mon_ex[0].'" and year(applied_from_date)="'.$mon_ex[1].'" ';
		 }else{
			 $mon_sql = 'and month(applied_from_date)="'.date('m').'" and year(applied_from_date)="'.date('Y').'" ';
		 
		 }
		 
		  $uid=$this->session->userdata("name");
		 $check_employee=$this->check_employee($uid);
		 $rname=$this->session->userdata("name");
		 
		 
				$staff_nature=$check_employee[0]['staff_nature'];
				if($staff_nature=="V"){
				//$empx = explode("_",$rname);
				$rname = 'v_'.$rname;
				}else{
				$rname = $rname;
				}
            $cond="";
			
			if($this->session->userdata("role_id")!=1 && $this->session->userdata("role_id")!=58){
			
			 $cond=" AND (l.emp1_reporting_person='$rname' || l.emp2_reporting_person='$rname' || l.emp3_reporting_person='$rname' ||  l.emp4_reporting_person='$rname')";
			}
		
		   $sql= "SELECT l.*,e.reporting_person,e.fname,e.lname,e.gender,cm.college_code,dpm.department_name,emf.`manual_attendance`,emf.`is_final` 
		       FROM leave_applicant_list as l 
               inner join employee_master as e on e.emp_id=l.emp_id
               inner join college_master as cm on cm.college_id = e.emp_school
		       inner join department_master as dpm on dpm.department_id = e.department
			   left join employee_monthly_final_attendance as emf on emf.UserId=l.emp_id AND month(emf.for_month_year)='".$mon_ex[0]."' and year(emf.for_month_year)='".$mon_ex[1]."' 
               WHERE  leave_apply_type = '$ty' ".$mon_sql." $cond order by l.lid DESC";
			   
			   
			   $query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
	function getLeaveApplicantList($role,$rname,$ty,$mon=''){  //for RO or Registrar
	      
		 if(!empty($mon)){
			 $mon_ex = explode('-',$mon);
			 $mon_sql = 'and month(applied_from_date)="'.$mon_ex[0].'" and year(applied_from_date)="'.$mon_ex[1].'" ';
		 }else{
			$mon_ex =date('Y-m-d');
		 $mon_sql = 'and month(applied_from_date)="'.date('m').'" and year(applied_from_date)="'.date('Y').'" ';
		 
		 }
		 $uid=$this->session->userdata("name");
		 $check_employee=$this->check_employee($uid);
		 
	     $staff_nature=$check_employee[0]['staff_nature'];
		//exit();
		  if($staff_nature=="V"){
    //$empx = explode("_",$rname);
	$rname = 'v_'.$rname;
		 }else{
	$rname = $rname;
		 }
		  $sql= "SELECT l.*,e.reporting_person,e.fname,e.lname,e.gender,cm.college_code,dpm.department_name,emf.`manual_attendance`,emf.`is_final`
		  FROM leave_applicant_list as l 
         inner join employee_master as e on e.emp_id=l.emp_id
         inner join college_master as cm on cm.college_id = e.emp_school
		inner join department_master as dpm on dpm.department_id = e.department	
	    left join employee_monthly_final_attendance as emf on emf.UserId=l.emp_id AND month(emf.for_month_year)='".$mon_ex[0]."' and year(emf.for_month_year)='".$mon_ex[1]."' 

               WHERE leave_apply_type = '$ty' AND (l.emp1_reporting_person='$rname' || l.emp2_reporting_person='$rname' || l.emp3_reporting_person='$rname' ||  l.emp4_reporting_person='$rname') and l.vstatus='Y' ".$mon_sql." order by lid DESC";
			   
			   
			   $query=$this->db->query($sql);
		$result=$query->result_array();
       //echo $this->last_query(); 
	//echo $this->db->last_query();exit();
		return $result;
		
	}
	
	function getMyAllLeave($id,$ty,$mon=''){
		//$sql="select * from leave_applicant_list where emp_id='$id'";
		$this->db->select('*');
		$this->db->from('leave_applicant_list');
		$this->db->where('emp_id',$id);
		$this->db->where('vstatus','Y');
		if($ty!=''){
		$this->db->where('leave_apply_type',$ty);
	}
	if($mon != ''){
			 $mon_ex = explode('-',$mon);
			 $this->db->where('month(applied_from_date)',$mon_ex[0]);
			 $this->db->where('year(applied_from_date)',$mon_ex[1]);
		 }else{
			  $this->db->where('month(applied_from_date)',date('m'));
			 $this->db->where('year(applied_from_date)',date('Y'));
		 }
		$this->db->order_by('applied_from_date','DESC');
		$query=$this->db->get();
		$res=$query->result_array();
		return $res;
	}
		function getPassDataforLeave($data){
		$sql="select e.emp_id,e.fname,e.mname,e.lname,ds.designation_name,de.department_name,lv.* from employee_master as e
		     left join designation_master as ds on ds.designation_id = e.designation
      		 left join department_master as de  on de.department_id = e.department
			 left join leave_applicant_list as lv on lv.emp_id=e.emp_id
			 where lv.lid='".$data['lv_id']."' and lv.emp_id='".$data['emp_id']."'";
			 $query=$this->db->query($sql);
		     return $query->result_array();
	}
	function getlastreporting($lid){
		$emp = $this->getLeaveDetailById($lid);
		$r_arr = array();
		if(!empty($emp[0]['emp1_reporting_person'])){
			$r_arr['emp1_reporting_person'] = $emp[0]['emp1_reporting_person'];
		}
		if(!empty($emp[0]['emp2_reporting_person'])){
			$r_arr['emp2_reporting_person'] = $emp[0]['emp2_reporting_person'];
		}
		if(!empty($emp[0]['emp3_reporting_person'])){
			$r_arr['emp3_reporting_person'] = $emp[0]['emp3_reporting_person'];
		}
		if(!empty($emp[0]['emp4_reporting_person'])){
			$r_arr['emp4_reporting_person'] = $emp[0]['emp4_reporting_person'];
		}
		return end($r_arr);
		
	}
	function getallreporting($lid){
		$emp = $this->getLeaveDetailById($lid);
		
		$r_arr = array();
		if(!empty($emp[0]['emp1_reporting_person'])){
			$r_arr[]= $emp[0]['emp1_reporting_person'];
		}
		if(!empty($emp[0]['emp2_reporting_person'])){
			$r_arr[]= $emp[0]['emp2_reporting_person'];
		}
		if(!empty($emp[0]['emp3_reporting_person'])){
			$r_arr[]= $emp[0]['emp3_reporting_person'];
		}
		if(!empty($emp[0]['emp4_reporting_person'])){
			$r_arr[]= $emp[0]['emp4_reporting_person'];
		}
		return $r_arr;
		
	}
	
	function getcountreporting($lid){
		$emp = $this->getLeaveDetailById($lid);
		$r_arr = array();
		if(!empty($emp[0]['emp1_reporting_person'])){
			$r_arr['emp1_reporting_person'] = $emp[0]['emp1_reporting_person'];
		}
		if(!empty($emp[0]['emp2_reporting_person'])){
			$r_arr['emp2_reporting_person'] = $emp[0]['emp2_reporting_person'];
		}
		if(!empty($emp[0]['emp3_reporting_person'])){
			$r_arr['emp3_reporting_person'] = $emp[0]['emp3_reporting_person'];
		}
		if(!empty($emp[0]['emp4_reporting_person'])){
			$r_arr['emp4_reporting_person'] = $emp[0]['emp4_reporting_person'];
		}
		return count($r_arr);
		
	}
	function get_punching_emp_bydate($emp,$date){
		 $cff_cnt = $this->check_coff_ondate($emp,$date);
		$str = '<div class="form-group">
	 <label class="col-md-3">Status</label>
	  <div class="col-md-6" >
	  <select class="form-control " name="status"  type="text">
													<option value="">Select</option>												
													<option  value="Cancel">Cancel</option>
													<option  value="Credited">Credited</option>													
												</select> </div>                                       
                                    </div>		 
	 <div class="form-group">
								<label class="col-md-3">Remark</label>
                                             <div class="col-md-6" >
	 <textarea name="remark" class="form-control"></textarea>
                                       </div>
                                  </div>	';
		if($cff_cnt <= 0){
	/*	 $sql="select TIME(Intime) as Intime,TIME(Outtime) as Outtime,status,DATE(Intime) as pdate from punching_backup
			 where date(Intime)='".date('Y-m-d',strtotime($date))."' and UserId='".$emp."'";
			 */
	 $sql="select TIME(Intime) as Intime,TIME(Outtime) as Outtime,status,DATE(Intime) as pdate from punching_backup
			 where date(Intime)='".date('Y-m-d',strtotime($date))."' and UserId='".$emp."'";		 
			 $query=$this->db->query($sql);
			 $qry = $query->result_array();
		$cnt = count($qry);
			
			if($cnt > 0){
				echo '<table class="table table-bordered"><thead><th>Date</th><th>Day</th><th>Intime</th><th>Out Time</th>
	  <th>Duration</th><th>Type</th><th>Status</th></thead>';
			 if($qry[0]['Intime']!='00:00:00'){
				$tcnt = $this->get_time_difference(date('H:i:s',strtotime($qry[0]['Intime'])),date('H:i:s',strtotime($qry[0]['Outtime'])));
	  }     
				if(strtotime($tcnt) >= strtotime('7:00')){
					//echo "kk";
					$qry[0]['lev']='p';
					echo "<tr>";
		echo "<td>".date('d-m-Y',strtotime($qry[0]['pdate']))."</td>";	
		echo "<td>".date('D',strtotime($qry[0]['pdate']))."</td>";	
		//echo "<td>".date('h:i:s',strtotime($qry[0]['Intime']))."</td>"; 
	//	echo "<td>".date('h:i:s',strtotime($qry[0]['Outtime']))."</td>";
	//added by jugal
echo "<td>".$qry[0]['Intime']."</td>";
	echo "<td>".date('H:i:s',strtotime($qry[0]['Outtime']))."</td>";
	
	//jugal ends
		echo "<td>";
		$hr = $this->get_time_difference(date('H:i:s',strtotime($qry[0]['Intime'])),date('H:i:s',strtotime($qry[0]['Outtime'])));
	          // echo $hr." hrs1";
	          echo date("g:i", strtotime("$hr"));
	          //	echo $this->get_time_difference(date('h:i:s',strtotime($qry[0]['Intime'])),date('h:i:s',strtotime($qry[0]['Outtime'])));
	         //  echo $hr." hrs";
		
		 echo "</td>";
		 echo "<td>Punching</td>";
		echo "<td>".$qry[0]['status']."</td>";
		echo "</tr>";
		echo "<table/>";
		echo "<input type='hidden' name='credited_by' value='Punching' />";
					echo $str;   
					
					//return ;
				}else{
					//echo "kk";
					echo "<tr>";
		echo "<td>".date('d-m-Y',strtotime($qry[0]['pdate']))."</td>";	
		echo "<td>".date('D',strtotime($qry[0]['pdate']))."</td>";	
		echo "<td>";
		if($qry[0]['Intime']!='00:00:00'){ echo date('h:i:s',strtotime($qry[0]['Intime'])); }else{ echo "00:00"; }
		echo "</td>";
		echo "<td>";
		if($qry[0]['Outtime']!='00:00:00'){ echo date('h:i:s',strtotime($qry[0]['Outtime'])); }else{ echo "00:00"; }
	//date('h:i:s',strtotime($qry[0]['Outtime']))
	echo "</td>";
		echo "<td>";
		if($qry[0]['Intime']!='00:00:00'){
		$hr = $this->get_time_difference(date('H:i:s',strtotime($qry[0]['Intime'])),date('H:i:s',strtotime($qry[0]['Outtime'])));
		}else{
			$hr = '0';
		}       echo $hr." hrs";
		
		 echo "</td>";
		 echo "<td>Punching</td>";
		echo "<td>".$qry[0]['status']."</td>";
		echo "</tr>";
					$res = $this->get_emp_od($emp,date('Y-m-d',strtotime($date)));
					if(count($res)>0){
						if($res[0]['leave_duration'] =='hrs'){
						//echo $ex_t = $this->get_time_difference($tcnt,'7:00:00');
						
					 $od_t = $res[0]['no_hrs'];
						$ex = explode(":",$tcnt);
						$tcnt = $ex[0].".".$ex[1];						
						 $tot = $tcnt + $od_t;
						
					//	 echo number_format((float)$tot, 2, '.', '');
						if($tot >= '07.00'){
							echo "<tr>";
		echo "<td>".date('d-m-Y',strtotime($res[0]['departure_time']))."</td>";	
		echo "<td>".date('D',strtotime($res[0]['departure_time']))."</td>";	
		echo "<td>".date('h:i:s',strtotime($res[0]['departure_time']))."</td>";
		echo "<td>".date('h:i:s',strtotime($res[0]['arrival_time']))."</td>";
		echo "<td>";
		$hr = $this->get_time_difference(date('H:i:s',strtotime($res[0]['departure_time'])),date('H:i:s',strtotime($res[0]['arrival_time'])));
	           echo $hr." hrs";
		
		 echo "</td>";
		 echo "<td>OD</td>";
		echo "<td>".$res[0]['fstatus']."</td>";
		echo "</tr>";
		echo "<table/>";
		echo "<input type='hidden' name='credited_by' value='Both' />";
		if($res[0]['fstatus']=="Approved"){
		echo $str; 
		}
						}else{
							
								echo "<tr>";
		echo "<td>".date('d-m-Y',strtotime($res[0]['departure_time']))."</td>";	
		echo "<td>".date('D',strtotime($res[0]['departure_time']))."</td>";	
		echo "<td>";
		if($res[0]['departure_time1']=='00:00:00'){echo '00:00'; }else { echo date('h:i:s',strtotime($res[0]['departure_time1'])) ; } echo "</td>";
		echo "<td>";
		if($res[0]['arrival_time1']=='00:00:00'){echo '00:00'; }else { echo date('h:i:s',strtotime($res[0]['arrival_time1'])) ; } echo "</td>";
		
		
		echo "<td>";
		if($res[0]['departure_time1']=='00:00:00'){
			echo '0 hrs';
		}else{
		$hr = $this->get_time_difference(date('H:i:s',strtotime($res[0]['departure_time'])),date('H:i:s',strtotime($res[0]['arrival_time'])));
	           echo $hr." hrs";
		}
		 echo "</td>";
		 echo "<td>OD</td>";
		echo "<td>".$res[0]['fstatus']."</td>";
		echo "</tr>";
		echo "<table/>";
		echo "<input type='hidden' name='credited_by' value='Both' />";
		echo "<script>$('#sid').attr('display','none');</script>";
							//return 'not1';
						}
						}elseif($res[0]['leave_duration'] =='full-day'){
							echo "<tr>";
		echo "<td>".date('d-m-Y',strtotime($res[0]['departure_time']))."</td>";	
		echo "<td>".date('D',strtotime($res[0]['departure_time']))."</td>";	
		echo "<td>";
		if($res[0]['departure_time1']=='00:00:00'){echo '00:00'; }else { echo date('h:i:s',strtotime($res[0]['departure_time1'])) ; } echo "</td>";
		
		echo "<td>";

if($res[0]['arrival_time1']=='00:00:00'){echo '00:00'; }else { echo date('h:i:s',strtotime($res[0]['arrival_time1'])) ; } echo "</td>";
		echo "<td>";
		if($res[0]['departure_time1']=='00:00:00'){
			echo '0 hrs';
		}else{
		$hr = $this->get_time_difference(date('H:i:s',strtotime($res[0]['departure_time'])),date('H:i:s',strtotime($res[0]['arrival_time'])));
	           echo $hr." hrs";
		}
		 echo "</td>";
		 echo "<td>OD</td>";
		echo "<td>".$res[0]['fstatus']."</td>";
		echo "</tr>";
		echo "<table/>";
		echo "<input type='hidden' name='credited_by' value='Both' />";
		if($res[0]['fstatus']=="Approved"){
		echo $str;  
                              }
						}
					}else{
						//if(!empty($dec)){
echo '<div class="form-group">
	 <label class="col-md-3">Special Case</label>
	  <div class="col-md-6" ><input type="hidden" id="nota" name="nota" value="1" /><input type="checkbox" value="Y" name="special_case" /></div></div>';
	  echo '<div class="form-group">
	 <label class="col-md-3">Upload File</label>
	  <div class="col-md-6" ><input type="file"  name="upload_file" /></div></div>';
//	}
						echo $str;
						echo '<span style="color:red;">Employee is Not applicable for C-OFF</span>';

					}
				}
				
			}else{
				$res = $this->get_emp_od($emp,date('Y-m-d',strtotime($date)));
				
				if(count($res)>0){
					echo '<table class="table table-bordered"><thead><th>Date</th><th>Day</th><th>Intime</th><th>Out Time</th>
	  <th>Duration</th><th>Type</th><th>Status</th></thead>';
						echo "<tr>";
					if($res[0]['leave_duration']=='hrs'){
						
						$od_t = $res[0]['no_hrs'];
												
					//	 echo number_format((float)$tot, 2, '.', '');
						if($od_t >= '07.00'){
							echo "<tr>";
		echo "<td>".date('d-m-Y',strtotime($res[0]['departure_time']))."</td>";	
		echo "<td>".date('D',strtotime($res[0]['departure_time']))."</td>";	
		echo "<td>";
		if($res[0]['departure_time1']=='00:00:00'){echo '00:00'; }else { echo date('h:i:s',strtotime($res[0]['departure_time1'])) ; } echo "</td>";
		
		echo "<td>";
		if($res[0]['arrival_time1']=='00:00:00'){echo '00:00'; }else { echo date('h:i:s',strtotime($res[0]['arrival_time'])); } echo "</td>";
		echo "<td>";
		if($res[0]['departure_time1']=='00:00:00'){
			echo '0 hrs';
		}else{
		$hr = $this->get_time_difference(date('H:i:s',strtotime($res[0]['departure_time'])),date('H:i:s',strtotime($res[0]['arrival_time'])));
	           echo $hr." hrs";
		}
		 echo "</td>";
		 echo "<td>OD</td>";
		echo "<td>".$res[0]['fstatus']."</td>";
		echo "</tr>";
		echo "<table/>";
		echo "<input type='hidden' name='credited_by' value='OD' />";
		if($res[0]['fstatus']=="Approved"){
		echo $str ;   
		}
						}else{
							
							echo "<tr>";
		echo "<td>".date('d-m-Y',strtotime($res[0]['departure_time']))."</td>";	
		echo "<td>";
		if($res[0]['departure_time1']=='00:00:00'){echo '00:00'; }else { echo date('h:i:s',strtotime($res[0]['departure_time1'])) ; } echo "</td>";
		
		echo "<td>";

if($res[0]['arrival_time1']=='00:00:00'){echo '00:00'; }else { echo date('h:i:s',strtotime($res[0]['arrival_time1'])) ; } echo "</td>";
		
		echo "<td>";
		$hr = $this->get_time_difference(date('H:i:s',strtotime($res[0]['departure_time'])),date('H:i:s',strtotime($res[0]['arrival_time'])));
	           echo $hr." hrs";
		
		 echo "</td>";
		 echo "<td>OD</td>";
		echo "<td>".$res[0]['fstatus']."</td>";
		echo "</tr>";
		echo "<table/>";
		
							
						}
						
						
						
						
						
					}else{
					
		echo "<td>".date('d-m-Y',strtotime($res[0]['departure_time']))."</td>";	
		echo "<td>".date('D',strtotime($res[0]['departure_time']))."</td>";
		echo "<td>";
		if($res[0]['departure_time1']=='00:00:00'){echo '00:00'; }else { echo date('h:i:s',strtotime($res[0]['departure_time1'])) ; } echo "</td>";
		echo "<td>";

if($res[0]['arrival_time1']=='00:00:00'){echo '00:00'; }else { echo date('h:i:s',strtotime($res[0]['arrival_time1'])) ; } echo "</td>";
	
		echo "<td>";
		$hr = $this->get_time_difference(date('h:i:s',strtotime($res[0]['departure_time'])),date('h:i:s',strtotime($res[0]['arrival_time'])));
	           echo $hr." hrs";
		
		 echo "</td>";
		 echo "<td>OD</td>";
		echo "<td>".$res[0]['fstatus']."</td>";
		echo "</tr>";
		echo "<table/>";
		echo "<input type='hidden' name='credited_by' value='OD' />";
		if($res[0]['fstatus']=="Approved"){
					echo $str;
		}								  
					}}else{			
						echo '<div class="form-group">
	 <label class="col-md-3">Special Case</label>
	  <div class="col-md-6" ><input type="hidden" id="nota" name="nota" value="1" /><input type="checkbox" value="Y" name="special_case" /></div></div>';
	  echo '<div class="form-group">
	 <label class="col-md-3">Upload File</label>
	  <div class="col-md-6" ><input type="file"  name="upload_file" /></div></div>';
						echo $str;
						echo '<span style="color:red;">Employee is Not applicable for C-OFF</span>';
				
					}
			}	
			
		}else{
			return 'Employee has All ready applied C-OFF on this date';
		}
		  
	}
	function get_emp_od($emp,$date){
		 $sql=" select *,TIME(departure_time) as departure_time1,TIME(arrival_time) as arrival_time1 from leave_applicant_list where leave_apply_type = 'OD' and emp_id = '".$emp."' and vstatus = 'Y'  and applied_from_date <= '".$date."' and applied_to_date >= '".$date."' ";
		//exit;
		 $query=$this->db->query($sql);
			 $qry = $query->result_array();
		return $qry;
	}
	function check_coff_ondate($emp,$date){
		 $sql=" select * from coff_applicant_list where status = 'Credited' and emp_id = '".$emp."'  and date = '".date('Y-m-d',strtotime($date))."'  ";
		//exit;
		 $query=$this->db->query($sql);
			 $qry = $query->result_array();
		return count($qry);
	}
	function get_time_difference($dtime, $atime) {
		//echo $dtime;
		//echo $atime;
   $nextDay=$dtime>$atime?1:0;
 $dep=EXPLODE(':',$dtime);
 $arr=EXPLODE(':',$atime);
 $diff=ABS(MKTIME($dep[0],$dep[1],0,DATE('n'),DATE('j'),DATE('y'))-MKTIME($arr[0],$arr[1],0,DATE('n'),DATE('j')+$nextDay,DATE('y')));
 $hours=FLOOR($diff/(60*60));
 $mins=FLOOR(($diff-($hours*60*60))/(60));
 $secs=FLOOR(($diff-(($hours*60*60)+($mins*60))));
 IF(STRLEN($hours)<2){$hours="0".$hours;}
 IF(STRLEN($mins)<2){$mins="0".$mins;}
 IF(STRLEN($secs)<2){$secs="0".$secs;}
	//echo $diff;
	//die();
    return $hours.'.'.$mins;
}
function add_coff($data){
	//print_r($data);
	$arr=array();
	$arr['emp_id']=$data['staffid'];
	 $arr['date']=date('Y-m-d',strtotime($data['date']));
	$arr['remark']=$data['remark'];
	$arr['status']=$data['status'];
//echo $data['special_case'];
//exit;
	if($data['special_case'] == 'Y'){
		//echo "hh";
	$arr['credited_by']='Punching';
	}else{
		//echo "hh33";
	$arr['credited_by']=$data['credited_by'];
	}
//	$arr['credited_by']=$data['credited_by'];
	$arr['inserted_by']=$this->session->userdata("uid");
	$arr['inserted_datetime']=date("Y-m-d H:i:s");
	
	 $ins1=$this->db->insert('coff_applicant_list',$arr);
	 //echo $this->db->last_query();
	 //exit;
	 if($data['status'] == 'Credited'){
		 $d =  $this->config->item('current_year2');
		 //exit;
		  $cnt = $this->get_employee_leave_allocation_bycode_type($data['staffid'],'C-OFF',$d);
  
	  if(count($cnt)<1){
	   $arr1['employee_id']=(stripcslashes($data['staffid']));
	   $arr1['leave_type']=(stripcslashes('C-OFF'));
	   $arr1['leaves_allocated']=(stripcslashes('1'));
	   $arr1['academic_year']=(stripcslashes($d));
	   $arr1['remark']=(stripcslashes($data['remark']));
	  
	  $arr1['entry_by']=$this->session->userdata("uid");
		$arr1['entry_on']=date("Y-m-d H:i:s");
		//print_r($arr);
       $insert_id = $this->db->insert('employee_leave_allocation',$arr1);
	   //echo $this->db->last_query();
    $ins_id=$this->db->insert_id();
	 
		}else{
			$modify_by=$this->session->userdata("uid");
		$modify_on=date("Y-m-d H:i:s");		
		 $this->db->where('employee_id',$data['staffid']) ; 
		 $this->db->where('academic_year',$d) ; 
		  $this->db->where('leave_type','C-OFF') ; 
	  $this->db->set('leaves_allocated',$cnt[0]['leaves_allocated']+1);
	  
        $this->db->set('modify_by',$modify_by);
$this->db->set('modify_on',$modify_on);		
	 $this->db->update('employee_leave_allocation');
		}
	 }
	 
	return $ins1;
}
function update_coff($data){
		if($data['status'] == 'Cancel'){			
			 $d = $this->config->item('current_year');
		 //exit;
		  $cnt = $this->get_employee_leave_allocation_bycode_type($data['staffid'],'C-OFF',$d);
  $modify_by=$this->session->userdata("uid");
		$modify_on=date("Y-m-d H:i:s");		
		$this->db->where('academic_year',$d) ;
		 $this->db->where('employee_id',$data['staffid']) ; 
		  $this->db->where('leave_type','C-OFF') ; 
	  $this->db->set('leaves_allocated',$cnt[0]['leaves_allocated']-1);
	  
        $this->db->set('modify_by',$modify_by);
$this->db->set('modify_on',$modify_on);		
	 $this->db->update('employee_leave_allocation');
	 
		}
	$this->db->where('id',$data['id']) ;
	  
	   $this->db->set('status',$data['status']);
	  $this->db->set('remark',$data['remark']);
	 $this->db->set('modify_by',$this->session->userdata("uid"));
	  $this->db->set('modify_datetime',date("Y-m-d H:i:s"));
	return  $upid= $this->db->update('coff_applicant_list');
	
}
function getMyAllcoffLeave($mon=''){
	 $id=$this->session->userdata('role_id');
	if($id =='1' || $id =='6' || $id =='7' || $id=='11'){
	$where = '';	
	}else{
		$eid=$this->session->userdata('name');
	$where = " and cl.emp_id = '".$eid."' ";
	}
	if($mon != ''){
			 $mon_ex = explode('-',$mon);
			 $mon_sql = ' and month(cl.date)="'.$mon_ex[0].'" and year(cl.date)="'.$mon_ex[1].'" ';
		 }else{
			 $mon_sql = ' and month(cl.date)="'.date('m').'" and year(cl.date)="'.date('Y').'" ';
		 
		 }
	 $sql=" select cl.*,em.emp_id,em.fname,em.lname,em.mname,em.department,em.emp_school,em.designation,cl.inserted_datetime as inserted_datetime1 from coff_applicant_list as cl INNER JOIN employee_master as em ON em.emp_id = cl.emp_id where cl.status = 'Credited' $mon_sql $where ";
		//exit;
		 $query=$this->db->query($sql);
			 $qry = $query->result_array();
	return $qry;
}
function getcoff_byid($id){
	$sql=" select * from coff_applicant_list as cl INNER JOIN employee_master as em ON em.emp_id = cl.emp_id where cl.id = '".$id."' ";
		//exit;
		 $query=$this->db->query($sql);
			 $qry = $query->result_array();
		return $qry;
}
function get_emp_od_cnt($eid){
	$cyer = $this->config->item('cyear');
    	$sql=" select sum(no_days) as odcnt from leave_applicant_list  where leave_apply_type = 'OD' and fstatus = 'Approved' and year(applied_from_date) = '".$cyer."' and emp_id = '".$eid."' ";
		//exit;
		 $query=$this->db->query($sql);
			 $qry = $query->result_array();
		return $qry[0]['odcnt'];
}
function get_count_coff_leaves($emp){
	    $this->db->select('*');
		$this->db->where('emp_id',$emp);		
		$this->db->where('status','Credited');
		$this->db->from('coff_applicant_list');
		//$this->db->group_by('employee_id'); 
		$query=$this->db->get();
		$result=$query->result_array();
		return count($result);
   }
    function get_next_reporting($emp,$lid){
	    $this->db->select($emp);
		$this->db->where('lid',$lid);		
		//$this->db->where('status','Credited');
		$this->db->from('leave_applicant_list');
		//$this->db->group_by('employee_id'); 
		$query=$this->db->get();
		$result=$query->result_array();
		return $result[0][$emp];
   }
   function fetch_leaves_approved(){
   	  $sql=" select * from leave_applicant_list  where fstatus = 'Approved' limit 1";
		//exit;
		 $query=$this->db->query($sql);
			 $qry = $query->result_array();
		return $qry;
   }
    function fetchEmployeeData1($id){
		$this->db->select("e.*,ot.*");
		$this->db->from('employee_master as e');
		$this->db->join('employe_other_details as ot','ot.emp_id = e.emp_id','inner');		
		$this->db->where('e.emp_id',$id);
		$this->db->where('e.emp_status','Y');
		$query=$this->db->get();
		 // echo $this->db->last_query();
		//die();   
		$result=$query->result_array();
		//$result[0]['emp_id']=$id;
		return $result;
		
	}
	function get_punching_emp_leave_bydate($emp,$date){
		 		
		 $sql="select TIME(Intime) as Intime,TIME(Outtime) as Outtime,status,leave_type from punching_backup
			 where day(Intime)='".date('d',strtotime($date))."' and month(Intime)='".date('m',strtotime($date))."' and year(Intime)='".date('Y',strtotime($date))."' and UserId='".$emp."'";
			 
			 $query=$this->db->query($sql);
			 $qry = $query->result_array();
		 echo '<table class="table table-bordered"><thead><th>Date</th><th>Day</th><th>Intime</th><th>Out Time</th>
	  <th>Duration</th><th>Type</th><th>Status</th></thead>';
				
					echo "<tr>";
		echo "<td>".date('d-m-Y',strtotime($date))."</td>";	
		echo "<td>".date('D',strtotime($qry[0]['Intime']))."</td>";	
		echo "<td>";
		//if($qry[0]['Intime']==''){ echo '--'; }else{ echo date('h:i',strtotime($qry[0]['Intime']));  jugal}
		if($qry[0]['Intime']==''){ echo '--'; }else{ echo $qry[0]['Intime'];}
		echo "</td>";
		echo "<td>";
		//if($qry[0]['Outtime']==''){ echo '--'; }else{ echo date('h:i',strtotime($qry[0]['Outtime'])); jugal} 
		if($qry[0]['Outtime']==''){ echo '--'; }else{ echo $qry[0]['Outtime'];} 
		echo "</td>";
		echo "<td>";
	//echo	$start = explode(':',$qry[0]['Intime']);
//echo $end   = explode(':',$qry[0]['Outtime']);
 //echo $diff  = $end[0] - $start[0];
//echo $dmin = $end[1]-$start[1];

		$hr = $this->get_time_difference($qry[0]['Intime'],$qry[0]['Outtime']);
	          echo $hr." hrs";
		        // echo date("g:i", strtotime("$hr"));
		         
		         
		 echo "</td>";
		 if($qry[0]['status']=='leave'){
			  echo "<td>".$qry[0]['leave_type']."</td>";
		 }else{
		 echo "<td>--</td>";
		 }
		echo "<td>".$qry[0]['status']."</td>";
		echo "</tr>";
		//echo "<table/>";
			
					$res = $this->get_emp_od($emp,date('Y-m-d',strtotime($date)));
					if(count($res)>0){
						if($res[0]['leave_duration'] =='hrs'){
						
							echo "<tr>";
		echo "<td>".date('d-m-Y',strtotime($res[0]['departure_time']))."</td>";	
		echo "<td>".date('D',strtotime($res[0]['departure_time']))."</td>";	
		echo "<td>".date('h:i:s',strtotime($res[0]['departure_time']))."</td>";
		echo "<td>".date('h:i:s',strtotime($res[0]['arrival_time']))."</td>";
		echo "<td>";
		$hr = $this->get_time_difference(date('h:i:s',strtotime($res[0]['departure_time'])),date('h:i:s',strtotime($res[0]['arrival_time'])));
	           echo $hr." hrs";
		
		 echo "</td>";
		 echo "<td>OD</td>";
		echo "<td>".$res[0]['fstatus']."</td>";
		echo "</tr>";
		echo "<table/>";			
		
						}elseif($res[0]['leave_duration'] =='full-day'){
							echo "<tr>";
		echo "<td>".date('d-m-Y',strtotime($res[0]['departure_time']))."</td>";	
		echo "<td>".date('D',strtotime($res[0]['departure_time']))."</td>";	
		echo "<td>";
		if($res[0]['departure_time1']=='00:00:00'){echo '00:00'; }else { echo date('h:i:s',strtotime($res[0]['departure_time1'])) ; } echo "</td>";
		
		echo "<td>";

if($res[0]['arrival_time1']=='00:00:00'){echo '00:00'; }else { echo date('h:i:s',strtotime($res[0]['arrival_time1'])) ; } echo "</td>";
		echo "<td>";
		if($res[0]['departure_time1']=='00:00:00'){
			echo '0 hrs';
		}else{
		$hr = $this->get_time_difference(date('h:i:s',strtotime($res[0]['departure_time'])),date('h:i:s',strtotime($res[0]['arrival_time'])));
	           echo $hr." hrs";
		}
		 echo "</td>";
		 echo "<td>OD</td>";
		echo "<td>".$res[0]['fstatus']."</td>";
		echo "</tr>";
		echo "<table/>";			
						}				
			}
		  
	}
	function add_emp_leave_deduction($data){
//echo "<pre>";
//print_r($data['lev_dect']);
// print_r($data);
// die;
  $lev['emp_id'] = $data['staffid'];
  $lev['leave_apply_type']='Leave';
  $lev['applied_from_date']=date('Y-m-d',strtotime($data['date']));
  $lev['applied_to_date']=date('Y-m-d',strtotime($data['date']));
  $ld = $data['lev_dur'];
		if($ld == 'half-day'){
			$lev['no_days']=0.5;
		}else{
  $lev['no_days']=1;
		}
		$lev['reason']=$data['remark'];

  // if($data['lev_dect']=='CL'){
  // $lev['leave_type']=$data['CL'];
		// }elseif($data['lev_dect']=='Leave'){
  // $lev['leave_type']=$data['Leave'];
		// }else{
		// $lev['leave_type']='LWP';	
		// }
		//echo $data['lev_dect'];
		//echo "pp".$data[$data['lev_dect']];
if($data['lev_dect']=='LWP'){
$lev['leave_type']='LWP';
}else{
	$lev['leave_type']=$data[$data['lev_dect']];
	//$lev['leave_type']=$data['lev_dect'];
}
/*echo "<pre>";print_r($lev['leave_type']);
die;*/
//exit();
  $lev['leave_duration']=$data['lev_dur'];
  $lev['applied_on_date']=date("Y-m-d H:i:s");
  $lev['inserted_by']=$this->session->userdata("uid");
  $lev['inserted_datetime']=date("Y-m-d H:i:s");
  $lev['emp1_reporting_person']=$data['approv_id'];
  $lev['emp1_reporting_status']='Approved';
  $lev['emp1_reporting_remark']=$data['remark'];
  $lev['emp1_reporting_date']=date("Y-m-d H:i:s");
  $lev['fstatus']='Approved';
  $lev['adm_flag']='Y';
   $insert_id = $this->db->insert('leave_applicant_list',$lev);	   
//echo $this->db->last_query();
  // exit();
   
   $sql="update punching_backup set status='leave',leave_type='".$data['lev_dect']."',leave_duration = '".$lev['no_days']."',remark='".$data['lev_dur']."' where UserId='".$data['staffid']."' and day(Intime) = '".date('d',strtotime($data['date']))."' and month(Intime) = '".date('m',strtotime($data['date']))."' and year(Intime) = '".date('Y',strtotime($data['date']))."'";
    	// exit();
		 $upid= $this->db->query($sql);	  
		  if($data['lev_dect']!='LWP'){
		  $this->db->select('*');
		$this->db->from('employee_leave_allocation');
		$this->db->where('employee_id',$data['staffid']);
		$this->db->where('leave_type',$data['lev_dect']);
		$this->db->where('status','Y');
		$this->db->where('academic_year',$this->config->item('current_year')) ;
		$query=$this->db->get();
		$res=$query->result_array();
		$ul = $res[0]['leave_used'];
		$ld = $data['lev_dur'];
		if($ld == 'half-day'){
				$ul = $ul + 0.5;
			}else{
		$ul = $ul+1;
			}
			
      	$this->db->set('leave_used',$ul); 
      	$this->db->set('modify_on',date("Y-m-d H:i:s")); 
      	$this->db->set('modify_by',$this->session->userdata("uid")); 
      	$this->db->where('academic_year',$this->config->item('current_year')) ;
			 $this->db->where('id',$res[0]['id']);
	  $this->db->where('employee_id',$data['staffid']);
	$upid= $this->db->update('employee_leave_allocation');
	//echo $this->db->last_query();
	//echo $upid; exit;
}
   return 1;
	}
	function add_emp_leaves_deductions($data){
//echo "<pre>";
//print_r($data['lev_dect']);
//print_r($data['noofleaves']);
//print_r($data);
//print_r($data['month']);
//die;

foreach($data as $key => $item) {
	//echo "<pre>"; print_r($item);
	//print_r($item['CL_bal_deduct']);
	if($key == 'CL_bal_deduct') {
		//print_r($item);
		$leave_arr['CL_bal_deduct'] = ($item['CL_bal_deduct']) ? $item['CL_bal_deduct'] : $item;
		//print_r($leave_arr['CL_bal_deduct']);
	}
	//print_r($leave_arr['CL_bal_deduct']);
	if($key == 'EL_bal_deduct') {
		$leave_arr['EL_bal_deduct'] = ($item['EL_bal_deduct']) ? $item['EL_bal_deduct'] : $item;
	}
	
	if($key == 'ML_bal_deduct') {
		$leave_arr['ML_bal_deduct'] = ($item['ML_bal_deduct']) ? $item['ML_bal_deduct'] : $item;
	}
	
	if($key == 'VL_bal_deduct') {
		$leave_arr['VL_bal_deduct'] = ($item['VL_bal_deduct']) ? $item['VL_bal_deduct'] : $item;
	}
}
//print_r($leave_arr);
//echo "end";
//die;
foreach($leave_arr as $key => $item) {

if(!empty($item)) {

  $lev['emp_id'] = $data['staffid'];
  $lev['leave_apply_type']='Leave';
  $lev['applied_from_date']=date('Y-m-d',strtotime($data['date']));
  $lev['applied_to_date']=date('Y-m-d',strtotime($data['date']));
  $ld = $data['lev_dur'];
		if($ld == 'half-day'){
			$lev['no_days']=0.5;
		}else{
  $lev['no_days']=1;
		}
		$lev['reason']=$data['remark'];

  // if($data['lev_dect']=='CL'){
  // $lev['leave_type']=$data['CL'];
		// }elseif($data['lev_dect']=='Leave'){
  // $lev['leave_type']=$data['Leave'];
		// }else{
		// $lev['leave_type']='LWP';	
		// }
		//echo $data['lev_dect'];
		//echo "pp".$data[$data['lev_dect']];
if($data['lev_dect']=='LWP'){
$lev['leave_type']='LWP';
}else{
	$lev['leave_type']=$data[$data['lev_dect']];
	//$lev['leave_type']=$data['lev_dect'];
}

if($key == 'CL_bal_deduct') {
	$leaveDeduct = $lev['no_days'] = ($item['CL_bal_deduct']) ? $item['CL_bal_deduct'] : $item;
	$data['lev_dect'] = $lev['leave_type']= 'CL';
	//print_r($item);die;
}

if($key == 'EL_bal_deduct') {
	$leaveDeduct = $lev['no_days']= ($item['EL_bal_deduct']) ? $item['EL_bal_deduct'] : $item;
	$data['lev_dect'] = $lev['leave_type']= 'EL';
}

if($key == 'ML_bal_deduct') {
	$leaveDeduct = $lev['no_days']= ($item['ML_bal_deduct']) ? $item['ML_bal_deduct'] : $item;
	$data['lev_dect'] = $lev['leave_type']= 'ML';
}

if($key == 'VL_bal_deduct') {
	$leaveDeduct = $lev['no_days']= ($item['VL_bal_deduct']) ? $item['VL_bal_deduct'] : $item;
	$data['lev_dect'] = $lev['leave_type']= 'VL';
}
//echo "sun shine";
//die;

/*echo "<pre>";print_r($lev['leave_type']);
die;*/
//exit();
	if($leaveDeduct > 1) {
		$data['lev_dur'] = 'full-day';
	} else {
		$data['lev_dur'] = 'half-day';
	}
  $lev['leave_duration']=$data['lev_dur'];
  $lev['applied_on_date']=date("Y-m-d H:i:s");
  $lev['inserted_by']=$this->session->userdata("uid");
  $lev['inserted_datetime']=date("Y-m-d H:i:s");
  $lev['emp1_reporting_person']=$data['approv_id'];
  $lev['emp1_reporting_status']='Approved';
  $lev['emp1_reporting_remark']=$data['remark'];
  $lev['emp1_reporting_date']=date("Y-m-d H:i:s");
  $lev['fstatus']='Approved';
  $lev['adm_flag']='Y';
   //$insert_id = $this->db->insert('leave_applicant_list',$lev);	   
//echo $this->db->last_query();
  // exit();
   
  // $sql="update punching_backup set status='leave',leave_type='".$data['lev_dect']."',leave_duration = '".$lev['no_days']."',remark='".$data['lev_dur']."' where UserId='".$data['staffid']."' and day(Intime) = '".date('d',strtotime($data['date']))."' and month(Intime) = '".date('m',strtotime($data['date']))."' and year(Intime) = '".date('Y',strtotime($data['date']))."'";
    	// exit();
		// $upid= $this->db->query($sql);	  
		  if($data['lev_dect']!='LWP'){
		  $this->db->select('*');
		$this->db->from('employee_leave_allocation');
		$this->db->where('employee_id',$data['staffid']);
		$this->db->where('leave_type',$data['lev_dect']);
		$this->db->where('status','Y');
		$this->db->where('academic_year',$this->config->item('current_year')) ;
		$query=$this->db->get();
		$res=$query->result_array();
		$ul = $res[0]['leave_used'];
		$ld = $data['lev_dur'];
		/*if($ld == 'half-day'){
				$ul = $ul + 0.5;
			}else{
		$ul = $ul+1;
			}*/
		$ul = $ul + $leaveDeduct;
		//print_r($ul);
		//print_r($leaveDeduct);
		//die;	
      	$this->db->set('leave_used',$ul); 
      	$this->db->set('modify_on',date("Y-m-d H:i:s")); 
      	$this->db->set('modify_by',$this->session->userdata("uid")); 
      	$this->db->where('academic_year',$this->config->item('current_year')) ;
			 $this->db->where('id',$res[0]['id']);
	  $this->db->where('employee_id',$data['staffid']);
	  $upid= $this->db->update('employee_leave_allocation');

	  $oladata['ela_id'] = $res[0]['id'];
	  $oladata['leaves_deducted'] = $leaveDeduct;
	  $oladata['other_remark'] = $data['remark'];
	  $oladata['month'] = $data['month'];
	  $oladata['created_date'] = date("Y-m-d H:i:s");
	  $oladata['updated_date'] = date("Y-m-d H:i:s");
	  $oladata_insert_id = $this->db->insert('other_leave_deduction', $oladata);

	//echo $this->db->last_query();
	//echo $upid; exit;
}
}
}
   return 1;
	}
	function get_leave_deduction_list($mon=''){
		if($mon != ''){
			 $mon_ex = explode('-',$mon);
			 $mon_sql = 'and month(el.applied_from_date)="'.$mon_ex[0].'" and year(applied_from_date)="'.$mon_ex[1].'" ';
		 }else{
			 $mon_sql = 'and month(el.applied_from_date)="'.date('m').'" and year(applied_from_date)="'.date('Y').'" ';
		  }
		$sql="SELECT e.fname,e.mname,e.gender,e.lname,el.*,cm.college_code,dpm.department_name from leave_applicant_list as el
        INNER JOIN employee_master as e ON e.emp_id = el.emp_id
        inner join college_master as cm on cm.college_id = e.emp_school
		inner join department_master as dpm on dpm.department_id = e.department	   

		WHERE el.adm_flag = 'Y' $mon_sql order by el.emp_id DESC ";
		 
		$query1=$this->db->query($sql);
        $res1=$query1->result_array();
		
		return $res1;
	}

	function get_leaves_deductions_lists($mon='') {
		/*if($mon != ''){
			 $mon_ex = explode('-',$mon);
			 $mon_sql = ' month(el.modify_on)="'.$mon_ex[0].'" and year(el.modify_on)="'.$mon_ex[1].'" ';
		 }else{
			 $mon_sql = ' month(el.modify_on)="'.date('m').'" and year(el.modify_on)="'.date('Y').'" ';
		  }*/
		  if($mon != ''){
			 $mon_ex = explode('-',$mon);
			 $mon_sql = ' month = "'.$mon.'" ';
		 }else{
			 $mon_sql = ' month = "'.date('m-Y').'" ';
		  }
		$sql = "SELECT e.fname,
		               e.mname,
		               e.gender,
		               e.lname,
		               el.*,
		               cm.college_code,
		               dpm.department_name,
		               old.leaves_deducted,
		               old.month,
		               old.other_remark,
		               old.created_date
		        FROM employee_leave_allocation as el
        		INNER JOIN employee_master as e ON e.emp_id = el.employee_id
        		INNER JOIN college_master as cm on cm.college_id = e.emp_school
				INNER JOIN department_master as dpm on dpm.department_id = e.department	   
				INNER JOIN other_leave_deduction as old on el.id = old.ela_id
			    WHERE $mon_sql
			    ORDER by el.employee_id DESC ";

		$query1 = $this->db->query($sql);
        $res1 = $query1->result_array();

		return $res1;
	}

	function get_vacation_leave_list($yer='',$vid=''){
		
		$this->db->select("*");
		$this->db->from('vacation_master');		
		$this->db->where('status','Y');
		if($yer !=''){
		$this->db->where('academic_year',$yer);
		}
		if(!empty($vid)){
			$this->db->where('vid',$vid);
		}
		$query=$this->db->get();		  
		$result=$query->result_array();		
		return $result;
	}
	public function check_vl_bytype($vt,$vs,$yer){
	   $this->db->select("*");
		$this->db->from('vacation_master');		
		$this->db->where('status','Y');		
		$this->db->where('academic_year',$yer);
		$this->db->where('slot_type',$vs);
		$this->db->where('vacation_type',$vt);
		$query=$this->db->get();
		$result=$query->result_array();
		$cnt = count($result);
		if($cnt >= '1'){
			return 1;
		}else{
return 0;
		}
   }
   function add_vacation_leaves($data){
		$arr['academic_year']=(stripcslashes($data['academic_year']));
	   $arr['vacation_type']=(stripcslashes($data['vacation_type']));
	   $arr['slot_type']=(stripcslashes($data['slot_type']));
	   $arr['from_date']=(stripcslashes(date('Y-m-d',strtotime($data['from_date']))));
	   $arr['to_date']=(stripcslashes(date('Y-m-d',strtotime($data['to_date']))));
	  $arr['no_days']=(stripcslashes($data['no_days']));
	  
	  $arr['inserted_by']=$this->session->userdata("uid");
		$arr['inserted_date']=date("Y-m-d H:i:s");
       $insert_id = $this->db->insert('vacation_master',$arr);
	}

	function edit_vacation_leaves($data){
		 $this->db->set('vacation_type',$data['vacation_type']);
	  $this->db->set('slot_type',$data['slot_type']);
	  $this->db->set('from_date',date('Y-m-d',strtotime($data['from_date'])));
	  $this->db->set('to_date',date('Y-m-d',strtotime($data['to_date'])));
	  $this->db->set('no_days',$data['no_days']);
	
	 $this->db->set('updated_by',$this->session->userdata("uid"));
	  $this->db->set('updated_date',date("Y-m-d H:i:s"));
	  $this->db->where('vid',$data['vid']);
	  $upid1= $this->db->update('vacation_master');
	
	 $this->db->set('leaves_allocated',$data['no_days']);	   
	 $this->db->set('modify_by',$this->session->userdata("uid"));
	  $this->db->set('modify_on',date("Y-m-d H:i:s"));
	  $this->db->where('vl_id',$data['vid']);
	 $upid = $this->db->update('employee_leave_allocation');
  return $upid1;
	}
	function del_vacation_leaves($vid){
		 $this->db->set('status','N');
		 $this->db->where('vid',$vid);
	      return $this->db->update('vacation_master');
	}

	function getEmpForAllSchool($vl='',$sch='',$dep=''){
	   if(!empty($dep)){
		  $depsql = ' and dept.department_id ='.$dep;
	   }
	   if(!empty($sch)){
	   $schsql = ' and e.emp_school='.$sch;
	   }
	    if(!empty($vl)){
	   $vlsql = ' and vm.vacation_type = "'.$vl.'"' ;
		}
		$yer = $this->config->item('current_year');
	  // $sql="SELECT DISTINCT e.emp_id ,e.fname,e.mname,e.lname,dept.department_name,sc.college_code FROM employee_master as e
       //          LEFT JOIN department_master as dept ON dept.department_id = e.department
		//        LEFT JOIN college_master as sc ON sc.college_id = e.emp_school
		//		where e.emp_reg='N' and emp_id NOT IN (select ela.employee_id from employee_leave_allocation as ela, vacation_master as vm where ela.vl_id = vm.vid  and ela.academic_year = '".$yer."' and ela.leave_type = 'VL' and ela.status ='y' ".$vlsql." ) $schsql $depsql ORDER BY e.emp_id ASC";

//echo $sql;
// removed condition of more than one slotallocation to employee 22-09-2018
$sql= "SELECT DISTINCT e.emp_id ,e.fname,e.mname,e.lname,dept.department_name,sc.college_code FROM employee_master as e
                 LEFT JOIN department_master as dept ON dept.department_id = e.department
		        LEFT JOIN college_master as sc ON sc.college_id = e.emp_school
				where e.emp_reg='N' $schsql $depsql ORDER BY e.emp_id ASC";
		$query = $this->db->query($sql);
		return $query->result_array(); 
		
   }
   public function get_vacation_leave_nodays($yer,$vt,$sl,$id=''){
	   $this->db->select("*");
		$this->db->from('vacation_master');		
		$this->db->where('status','Y');		
		$this->db->where('academic_year',$yer);
		$this->db->where('slot_type',$sl);
		if(!empty($id)){
			$this->db->where('vid',$id);
		}
	$this->db->where('vacation_type',$vt);		
		$query=$this->db->get();
// $this->db->last_query();		
		return $result=$query->result_array();	
   }
    public function add_vacation_slot($data){
		//print_r($data);
		//exit;
		foreach($data['emp'] as $val){
		$arr['employee_id']= $val;
	   $arr['academic_year']= $data['academic_year'];
	   $arr['leave_type']= 'VL';
	   
	   $nod = $this->get_vacation_leave_nodays($data['academic_year'],$data['vacation_type'],$data['slot_type']);
	  // print_r($nod);
	   $arr['leaves_allocated']= $nod[0]['no_days'];
	   $arr['vl_id']= $nod[0]['vid'];
	   
	  $arr['entry_by']=$this->session->userdata("uid");
		$arr['entry_on']=date("Y-m-d H:i:s");
       $insert_id = $this->db->insert('employee_leave_allocation',$arr);
		//echo $this->db->last_query();
		//exit;
		}
		return $insert_id;
   }
   public function get_vl_slot_emp_list($id='',$yer=''){
	   $this->db->select("ela.id,ela.employee_id,ela.academic_year,ela.leave_type,ela.vl_id,ela.status as ela_status,vm.vid,vm.vacation_type,vm.slot_type,vm.no_days,vm.from_date,vm.to_date,em.fname,em.lname,em.gender,dm.department_name,cm.college_code");
		$this->db->from('employee_leave_allocation as ela');		
		$this->db->where('ela.status','Y');		
		if(!empty($yer)){
		$this->db->where('ela.academic_year',$yer);
		}
		if(!empty($id)){
		$this->db->where('ela.id',$id);
		}
		$this->db->where('ela.leave_type','VL');
$this->db->join('vacation_master as vm','vm.vid=ela.vl_id','inner');
$this->db->join('employee_master as em','em.emp_id=ela.employee_id','left');
$this->db->join('department_master as dm','dm.department_id=em.department','left');	
$this->db->join('college_master as cm','cm.college_id = em.emp_school','left');	
		$query=$this->db->get();
//echo $this->db->last_query(); exit;		
		return $result=$query->result_array();	
   }
   public function update_vl_assign_emp($data){
	   //print_r($data);
	   $this->db->set('leaves_allocated',$data['no_days']);
$this->db->set('vl_id',$data['vid']);	   
	 $this->db->set('modify_by',$this->session->userdata("uid"));
	  $this->db->set('modify_on',date("Y-m-d H:i:s"));
	  $this->db->where('id',$data['id']);
	return  $upid= $this->db->update('employee_leave_allocation');
   }
   public function check_emp_slot($yer,$empid,$st){
	     $sql = "select * from employee_leave_allocation as ela, vacation_master as vm where ela.vl_id=vid and ela.academic_year = '".$yer."' and ela.leave_type = 'VL' and ela.status ='y' and ela.employee_id = '".$empid."' and vm.slot_type = '".$st."' ";
    $query=$this->db->query($sql);
		$result=$query->result_array();
		return count($result);
   }
   public function check_vl_dates($fdate,$tdate){
	   $sql = "SELECT * FROM vacation_master WHERE status = 'Y' ";
			   $query=$this->db->query($sql);
		$result=$query->result_array();
$ldate =array();
foreach ($result as $key => $value) {
	     $begin = new DateTime(date('d-m-Y',strtotime($value['from_date'])));      
        $end = new DateTime(date('d-m-Y',strtotime($value['to_date'].' +1 day')));    
$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
//echo "<pre>";
//print_r($daterange);
foreach($daterange as $date){
    $ldate[] = $date->format("d-m-Y");
}
   }   
   
   $begin1 = new DateTime(date('d-m-Y',strtotime($fdate)));      
        $end1 = new DateTime(date('d-m-Y',strtotime($tdate)).' +1 day');    
$daterange1 = new DatePeriod($begin1, new DateInterval('P1D'), $end1);

foreach($daterange1 as $date1){
		
    if(in_array($date1->format("d-m-Y"),$ldate)){
		    	return $cnt = 1;
    }else{
		    	 $cnt = 0;
    }
}	
return $cnt ;

   }
   
   public function get_vid_emp_allocation($lid){
	  $sql = "select vl_id from employee_leave_allocation where  leave_type = 'VL' and status ='y' and id = '".$lid."' ";
    $query=$this->db->query($sql);
		$result=$query->result_array();		
	return	$vl = $this->get_vacation_leave_list('',$result[0]['vl_id']);
		
   }
   
   function get_vacation_leave_slot($yer='',$vt='',$st=''){
		$this->db->select("*");
		$this->db->from('vacation_master');		
		$this->db->where('status','Y');
		if($yer != ''){
		$this->db->where('academic_year',$yer);
		}
		if(!empty($vt)){
			$this->db->where('vacation_type',$vt);
		}
		if(!empty($st)){
			$this->db->where('slot_type',$st);
		}
		$query=$this->db->get();		  
		$result=$query->result_array();		
		return $result;
	}
	function check_applyed_leaves($lid){
//echo $lid;
//exit;
		$this->db->select('*');
		$this->db->from('leave_applicant_list');
		$this->db->where('leave_type',$lid);
		$query=$this->db->get();
      return $res=$query->result_array();
	}
	function get_emp_leave_list_bymonth($data){
		//print_r($data);
		if(!empty($data['attend_date'])){
			 $mon_ex = explode('-',$data['attend_date']);
			 $mon_sql = 'and month(el.applied_from_date)="'.$mon_ex[1].'" and year(applied_from_date)="'.$mon_ex[0].'" ';
		 }else{
			 $mon_sql = ' and month(el.applied_from_date)="'.date('m').'" and year(applied_from_date)="'.date('Y').'" ';
		  }
		  if(!empty($data['leave_typ'])){
			  $lev_typ = " and el.leave_apply_type = '".$data['leave_typ']."' ";
		  }
		   if(!empty($data['emp_school'])){
             $sch = " and e.emp_school='".$data['emp_school']."'";
         }
         if(!empty($data['department'])){
             $dep = " and e.department='".$data['department']."' ";
         }
		$sql="SELECT e.fname,e.gender,e.lname,el.*,cm.college_code,dpm.department_name from leave_applicant_list as el
        INNER JOIN employee_master as e ON e.emp_id = el.emp_id
        inner join college_master as cm on cm.college_id = e.emp_school
		inner join department_master as dpm on dpm.department_id = e.department	   

		WHERE el.fstatus = 'Approved'  $mon_sql $lev_typ $sch $dep order by el.emp_id DESC ";
		
		$query1=$this->db->query($sql);
        $res1=$query1->result_array();
		
		//exit;
		return $res1;
	}
	/*By Arvind  on 9th March 18*/
	function get_pending_leave_by_id($r){
	    $cond="emp".$r."_reporting_person='".$lid."' and emp".$r."_reporting_status is null";
		$this->db->select('lid,applied_to_date,emp_id');
		$this->db->from('leave_applicant_list');
		$this->db->where($cond);
		$query=$this->db->get();
     	$this->db->last_query();exit();
    	return	$res=$query->result_array();
	}
	/*By Arvind  on 9th March 18*/
	  function check_leave_approval($lid){
		 $res=get_pending_leave_by_id(1);
		 if(count($res)==0){
		   $res=$this->get_pending_leave_by_id(2);  
		 }
		  else if(count($res)==0){
		   $res=$this->get_pending_leave_by_id(3);  
		 }
		 else if(count($res)==0){
		   $res=$this->get_pending_leave_by_id(4);  
		 }
	 return $res;
	}
	function get_leave_report_list($post){
		//print_r($post);
		if(empty($post['attend_date'])){
			$d = explode("-",date('Y-m'));
		}else{
		$d = explode("-",$post['attend_date']);
		}
		if(!empty($post['department'])){
		  $depsql = ' and dpm.department_id ='.$post['department'];
	   }
	   if(!empty($post['emp_school'])){
	   $schsql = ' and e.emp_school='.$post['emp_school'];
	   }
	   if(!empty($post['leavetyp'])){
	   $levsql = ' and l.leave_apply_type= "'.$post['leavetyp'].'"';
	   }
	   if(!empty($post['empsid'])){
			$estr='';
			$cnt = count($post['empsid']);
			$i=1;
			foreach($post['empsid'] as $val){
				$estr .= $val;
				if($cnt != $i){
				$estr .= "','";	
				}
				$i=$i+1;
			}
			$sub1 .= "e.emp_id IN ('".$estr."') AND ";
		}
		 $sql="SELECT l.*,e.fname,e.lname,e.gender,cm.college_code,dpm.department_name FROM leave_applicant_list as l 
               inner join employee_master as e on e.emp_id=l.emp_id
              inner join college_master as cm on cm.college_id = e.emp_school
		inner join department_master as dpm on dpm.department_id = e.department where $sub1 year(applied_from_date) = '".$d[0]."' and month(applied_from_date) = '".$d[1]."' $schsql $depsql $levsql ORDER BY e.emp_id ASC ";		
		
		$query = $this->db->query($sql);
		$qry = $query->result_array();
//exit;
		return $qry;
	}
	function get_username($id){
		 $sql = "select * from user_master where  um_id = '".$id."' ";
    $query=$this->db->query($sql);
		return $result=$query->result_array();	
	}
	function get_vacation_leave_slot_list($yer='',$vt=''){
		
		$this->db->select("*");
		$this->db->from('vacation_master');		
		$this->db->where('status','Y');
		if(!empty($yer)){
		$this->db->where('academic_year',$yer);
		}
		if(!empty($vt)){
			$this->db->where('vacation_type',$vt);
		}
		$this->db->order_by('slot_type','ASC');
		$query=$this->db->get();		  
		$result=$query->result_array();		
		return $result;
	}
	function get_emp_sch_dep($dt,$sch='',$dep=''){
	if($dep != ''){
		$dp = "and e.department='".$dep."'";
	}
	if($sch != ''){
		$sc = "and e.emp_school='".$sch."'";
	}
	if($dt != ''){
		$dts = "and month(pb.Intime) ='".date('m',strtotime($dt))."' and day(pb.Intime) = '".date('d',strtotime($dt))."' and year(pb.Intime)='".date('Y',strtotime($dt))."' ";
	}
	 $sql="SELECT pb.Intime,pb.Outtime,e.emp_id,e.fname,e.mname ,e.lname,d.designation_name,dept.department_name,sc.college_name from employee_master as e
        LEFT JOIN designation_master as d ON d.designation_id = e.designation
		LEFT JOIN department_master as dept ON dept.department_id = e.department
		LEFT JOIN college_master as sc ON sc.college_id = e.emp_school
		LEFT JOIN punching_backup as pb on pb.UserId = e.emp_id		
		WHERE  e.emp_status = 'Y' and e.emp_reg = 'N' $dp $sc $dts	
		ORDER BY e.emp_id ASC "; 
		$query1=$this->db->query($sql);
		$res1=$query1->result_array();
		return $res1;
}
public function add_leave_adjustment_emp($data){
	foreach($data['empsid'] as $val){
	$arr['adjust_type'] = $data['adjfor'];
	$arr['punch_typ']=$data['punch_typ'];
	$arr['emp_id'] = $val;
	$arr['adjust_date'] = date('Y-m-d',strtotime($data['sdate']));
	$arr['remark'] = $data['remark'];
	$arr['inserted_by'] = $this->session->userdata("uid");
	$arr['inserted_datetime'] = date("Y-m-d H:i:s");
	$arr['status'] = $data['status'];
	$arr['fstatus'] = $data['status'];
	$arr['leave_application'] = $data['upfile'];
	$arr['approved_by'] = $data['app_by'];
	 $insert_id = $this->db->insert('leave_adjustment_list',$arr);
	 //echo $this->db->last_query();exit;
	 if($data['status']=='Approved'){
		 
		  $sql="update punching_backup set status='present',late_mark='',special_case='".$data['adjfor']."' where UserId='".$val."' and day(Intime) = '".date('d',strtotime($data['sdate']))."' and month(Intime) = '".date('m',strtotime($data['sdate']))."' and year(Intime) = '".date('Y',strtotime($data['sdate']))."'";
    	// exit();
		 $upid= $this->db->query($sql);	  
	 }
	}
	return $insert_id;
}
public function get_emp_adjustment_leaves($mon=''){
	 $sql="SELECT la.*,em.gender,em.fname,em.lname,dept.department_name,sc.college_code from leave_adjustment_list as la 
	 left JOIN employee_master as em ON la.emp_id = em.emp_id	 
	 LEFT JOIN department_master as dept ON dept.department_id = em.department
		LEFT JOIN college_master as sc ON sc.college_id = em.emp_school
       	
		WHERE  month(la.adjust_date) = '".date('m',strtotime("01-".$mon))."' and year(la.adjust_date) = '".date('Y',strtotime("01-".$mon))."'
		 "; 
		$query1=$this->db->query($sql);
		$res1=$query1->result_array();
		return $res1;
}
public function update_extra_cl_leave_emp($data){

  $lv = $this->get_emp_leaves($data['staffid'],'CL',$this->config->item('current_year'));
		$t_lv = $data['ecl']+$lv[0]['leaves_allocated'];
		
		 $this->db->where('employee_id',$data['staffid']) ; 
		  $this->db->where('leave_type','CL') ; 
		   $this->db->where('academic_year',$this->config->item('current_year')) ; 
	  $this->db->set('leaves_allocated',$t_lv);
	 // $this->db->set('remark',$data['remark']);
        $this->db->set('modify_by',$this->session->userdata("uid"));
$this->db->set('modify_on',date("Y-m-d H:i:s"));		
	 $this->db->update('employee_leave_allocation');
        $ins_id= $this->db->affected_rows();
		   return $ins_id;
}
public function get_ml_list($mon){
	if($mon != ''){
			 $mon_ex = explode('-',$mon);
			 $mon_sql = 'and month(el.applied_from_date)="'.$mon_ex[0].'" and year(applied_from_date)="'.$mon_ex[1].'" ';
		 }else{
			 $mon_sql = 'and month(el.applied_from_date)="'.date('m').'" and year(applied_from_date)="'.date('Y').'" ';
		  }
		 $sql="SELECT e.fname,e.mname,e.gender,e.lname,el.*,cm.college_code,dpm.department_name,ml.ml_id,ml.leave_id,ml.status from ml_approve_list as ml 
		 left join leave_applicant_list as el on el.lid = ml.leave_id
        INNER JOIN employee_master as e ON e.emp_id = el.emp_id
        inner join college_master as cm on cm.college_id = e.emp_school
		inner join department_master as dpm on dpm.department_id = e.department	
		WHERE 1 $mon_sql order by el.emp_id DESC ";
		 
		$query1=$this->db->query($sql);
        $res1=$query1->result_array();
		
		return $res1;
}
public function update_ml_leave($data){
	$this->db->set('status',$data['status']);	
	$this->db->set('remark',$data['remark']);	
	 $this->db->set('updated_by',$this->session->userdata("uid"));
	  $this->db->set('updated_date',date("Y-m-d H:i:s"));
	  $this->db->where('leave_id',$data['lid']);
	 $upid = $this->db->update('ml_approve_list');
	 //echo $this->db->last_query();exit;
  return $upid;
}
public function check_ml_status($lid){
	  $sql="SELECT status from ml_approve_list WHERE leave_id = '".$lid."' "; 
		$query1=$this->db->query($sql);
		$res1=$query1->result_array();
		
		if($res1[0]['status']=='Approved'){
return 'true';
		}else{
		return 'false';
	}
}
public function get_emp_leave_list($data){
	if(!empty($data['emp_school'])){
			$sc =" AND e.emp_school='".$data['emp_school']."' ";
		}
		if(!empty($data['department'])){
			$dp =" AND e.department='".$data['department']."' ";
		}
		if(!empty($data['attend_date'])){
			if($data['select_dur']=='monthly'){
		$mon_sql = 'and month(el.applied_from_date)="'.date('m',strtotime('01-'.$data['attend_date'])).'" and year(el.applied_from_date)="'.date('Y',strtotime('01-'.$data['attend_date'])).'" ';
$jd = "and e.joiningDate <= '".date('Y-m-d',strtotime('01-'.$data['attend_date']))."'";
}elseif($data['select_dur']=='yer'){
	$mon_sql = 'and year(el.applied_from_date)="'.$data['attend_datey'].'" ';
$jd = "and year(e.joiningDate) <= '".$data['attend_datey']."'";
}
}
if(!empty($data['empsid'])){
			$estr='';
			$cnt = count($data['empsid']);
			$i=1;
			foreach($data['empsid'] as $val){
				$estr .= $val;
				if($cnt != $i){
				$estr .= "','";	
				}
				$i=$i+1;
			}
			$emp = " AND e.emp_id IN ('".$estr."') ";
		}
	 $sql=" select e.*,dm.department_name,cm.college_name,dg.designation_name from employee_master as e 
	inner join leave_applicant_list as el on el.emp_id = e.emp_id
		inner join department_master as dm ON dm.department_id = e.department
		inner join designation_master as dg ON dg.designation_id = e.designation
inner join college_master as cm ON cm.college_id = e.emp_school where e.emp_reg = 'N' $jd $sc $dp $mon_sql $emp group by el.emp_id";
$query1=$this->db->query($sql); 
		return $res1=$query1->result_array();

}


//updated by kishor on 21st june,2019
//get empplyee list on the basis of academic_year 
public function get_emp_leave_list_new($data){

	if(!empty($data['emp_school'])){
			$sc =" AND e.emp_school='".$data['emp_school']."' ";
		}
		if(!empty($data['department'])){
			$dp =" AND e.department='".$data['department']."' ";
		}
		if(!empty($data['attend_date']) || !empty($data['frm_attend_datey'])){
			if($data['select_dur']=='monthly'){
		//$mon_sql = 'and month(el.applied_from_date)="'.date('m',strtotime('01-'.$data['attend_date'])).'" and year(el.applied_from_date)="'.date('Y',strtotime('01-'.$data['attend_date'])).'" ';
$jd = "and e.joiningDate <= '".date('Y-m-d',strtotime('31-'.$data['attend_date']))."'";
}elseif($data['select_dur']=='yer'){
	//$mon_sql = 'and (el.applied_from_date BETWEEN "'.date('Y-m-d',strtotime('01-'.$data['frm_attend_datey'])).'" AND "'.date('Y-m-d',strtotime('31-'.$data['to_attend_datey'])).'")';
$jd = "and e.joiningDate <= '".date('Y-m-d',strtotime('31-'.$data['to_attend_datey']))."'";
	/*$mon_sql = 'and year(el.applied_from_date)="'.$data['attend_datey'].'" ';
$jd = "and year(e.joiningDate) <= '".$data['attend_datey']."'";*/
}
}
if(!empty($data['empsid'])){
			$estr='';
			$cnt = count($data['empsid']);
			$i=1;
			foreach($data['empsid'] as $val){
				$estr .= $val;
				if($cnt != $i){
				$estr .= "','";	
				}
				$i=$i+1;
			}
			$emp = " AND e.emp_id IN ('".$estr."') ";
		}
	 $sql=" select e.*,dm.department_name,cm.college_name,dg.designation_name from employee_master as e 
	/* left join leave_applicant_list as el on  e.emp_id = el.emp_id */
		left join department_master as dm ON e.department=dm.department_id 
		left join designation_master as dg ON e.designation=dg.designation_id 
left join college_master as cm ON e.emp_school=cm.college_id  where e.emp_reg IN ('N','Y') $jd $sc $dp $mon_sql $emp group by e.emp_id";
//exit;
$query1=$this->db->query($sql); 
		return $res1=$query1->result_array();

}

function getMyAllLeave_typ($id,$ty,$mon='',$styp){
		//$sql="select * from leave_applicant_list where emp_id='$id'";
		$this->db->select('*');
		$this->db->from('leave_applicant_list');
		$this->db->where('emp_id',$id);
		$this->db->where('fstatus','Approved');
		if($ty!=''){
		$this->db->where('leave_type',$ty);
	}
	if($mon != ''){
		if($styp=='monthly'){
			$mon_ex = explode('-',$mon);
			 if($mon_ex[0]!='00'){
			 $this->db->where('month(applied_from_date)',$mon_ex[0]);
			}
			 $this->db->where('year(applied_from_date)',$mon_ex[1]);
		}elseif($styp='yer'){
			$yerarry=explode("-",$mon);
			$myarray = array_filter(array_map('trim', $yerarry));
			//$mon_ex = explode('-',$mon);
			if($myarray[0]!='00'){
				//$this->db->where('month(applied_from_date)',$mon_ex[0]);
				//date('Y-m-d',strtotime('01-'.$data['frm_attend_datey'])).'"
				//$this->db->where('applied_from_date >=', date('Y-m-d',strtotime('01-'.$myarray[0].'-'.$myarray[1])));
				//$this->db->where('applied_to_date <=', date('Y-m-d',strtotime('31-'.$myarray[2].'-'.$myarray[3])));
			$this->db->where('applied_to_date BETWEEN "'.date('Y-m-d',strtotime('01-'.$myarray[0].'-'.$myarray[1])).'" and "'.date('Y-m-d',strtotime('31-'.$myarray[2].'-'.$myarray[3])).'"');
			}
		}
	}else{
		$this->db->where('month(applied_from_date)',date('m'));
		$this->db->where('year(applied_from_date)',date('Y'));
	}
		$this->db->order_by('applied_from_date','DESC');
		$query=$this->db->get();
		//echo $this->db->last_query(); 
		//exit
		$res=$query->result_array();
		
		return $res;
	}

	function get_approved_reporting_leave($lid){
		$sql=" SELECT j.*,e.fname,e.lname from employee_master as e join  ( SELECT 
case when emp1_reporting_status = 'Approved' then emp1_reporting_person
when emp2_reporting_status = 'Approved' then emp2_reporting_person
when emp3_reporting_status = 'Approved' then emp3_reporting_person
when emp4_reporting_status = 'Approved' then emp4_reporting_person  end as empidl,
case when emp1_reporting_status = 'Approved' then emp1_reporting_date
when emp2_reporting_status = 'Approved' then emp2_reporting_date
when emp3_reporting_status = 'Approved' then emp3_reporting_date 
when emp4_reporting_status = 'Approved' then emp4_reporting_date end as empidd
FROM leave_applicant_list WHERE lid = '".$lid."' ) as j on e.emp_id = j.empidl";
$query1=$this->db->query($sql);
		return $res1=$query1->result_array();
	}
	function get_employee_crry_list($txt){
   	if($txt !=''){
   		$st ="and ( em.emp_id like '%".$txt['post_data']."%' OR em.fname like '%".$txt['post_data']."%' OR em.lname like '%".$txt['post_data']."%' )";
   	}
	  $sql="select em.emp_id,em.fname,em.lname,em.gender,cm.college_code,cm.college_name,dpm.department_name,dsm.designation_name,la.employee_id,la.`academic_year`,la.`leave_type`,la.`leaves_allocated`,la.`leave_used`,(la.leaves_allocated-la.leave_used) AS bal from employee_master as em
	    INNER JOIN employee_leave_allocation AS la ON la.employee_id=em.emp_id
	    inner join college_master as cm on cm.college_id = em.emp_school
		inner join designation_master as dsm on dsm.designation_id = em.designation
		inner join department_master as dpm on dpm.department_id = em.department	   
	   where em.emp_reg='N' $st AND la.academic_year='".$txt['acd_year']."' AND la.leave_type='".$txt['leave_typ']."' order by emp_id ASC";
	$query = $this->db->query($sql);
      return  $res=$query->result_array();
   }

   function carry_employee_leave_allocation($data){
   	//print_r($data);
   	$data['year']=$this->config->item('current_year2');
    	foreach($data['emp_id'] as $emp){
        $cnt = $this->get_employee_leave_allocation_bycode_type($emp,$data['leave_type'],$data['year']);
    //   exit;
        if(count($cnt)<1){
	   $arr['employee_id']=(stripcslashes($emp));
	   $arr['leave_type']=(stripcslashes($data['leave_type']));
	   $l = $emp."_".$data['leave_type'];
	   $arr['leaves_allocated']=(stripcslashes($data[$l]));
	   $arr['academic_year']=(stripcslashes($data['year']));
	//   $arr['remark']=(stripcslashes($data['remark']));
	  
	  $arr['entry_by']=$this->session->userdata("uid");
		$arr['entry_on']=date("Y-m-d H:i:s");
       $insert_id = $this->db->insert('employee_leave_allocation',$arr);
     $ins_id=$this->db->insert_id();
      
     // return $ins_id;
        }else{
  $lv = $this->get_emp_leaves($emp,$data['leave_type'],$data['year']);
	   $l = $emp."_".$data['leave_type'];

		$t_lv = $data[$l]+$lv[0]['leaves_allocated'];
		
		 $this->db->where('employee_id',$emp) ; 
		  $this->db->where('leave_type',$data['leave_type']) ; 
	  $this->db->set('leaves_allocated',$t_lv);
	 // $this->db->set('remark',$data['remark']);
        $this->db->set('modify_by',$this->session->userdata("uid"));
$this->db->set('modify_on',date("Y-m-d H:i:s"));		
	 $this->db->update('employee_leave_allocation');
        $ins_id= $this->db->affected_rows();	 


		  // return $ins_id;
        }
		}
		// echo $this->db->last_query();
	// exit;
		return $ins_id;
       
       
	
   }	
   
   function other_tsk_list($mon='',$uid=''){  //for RO or Registrar
	      
		 if(!empty($mon)){
			 $mon_ex = explode('-',$mon);
			 $mon_sql = '
			 and ( month(from_date)="'.$mon_ex[0].'" || month(to_date)="'.$mon_ex[0].'" )and year(from_date)="'.$mon_ex[1].'"';
		 }else{
			 $mon_sql = 'and ( month(from_date)="'.date('m').'" || month(to_date)="'.date('m').'" )and year(from_date)="'.date('Y').'"  ';
		 
		 }
		 $cond=''; 
		 if($uid!=""){
			 $cond.= ' and e.assigned_by='.$uid;
		  }
		  $sql= "SELECT l.*,e.fname,e.lname,e.gender,cm.college_code,dpm.department_name FROM emp_other_task_list as l 
               inner join employee_master as e on e.emp_id=l.emp_id
                inner join college_master as cm on cm.college_id = e.emp_school
		        inner join department_master as dpm on dpm.department_id = e.department	
               WHERE  l.status IN ('Y','N') ".$mon_sql.$cond." order by emp_id DESC";
			   $query=$this->db->query($sql);
		$result=$query->result_array();
       
		return $result;
		
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function add_work_from_home($emp_id,$leave_applied_from_date,$leave_applied_to_date,$reason){
		
		$add['UserId']=$emp_id;
		$add['Intime']=$leave_applied_from_date;
		$add['Outtime']=$leave_applied_to_date;
		$add['status']="leave";
		$add['reason']=$reason;
		$add['leave_type']="WFH";
		$add['remark']=$reason;
		$add['approve_status']="N";
		$add['create_by']=$emp_id;
		$add['create_on']=date('Y-m-d h:i:s');
		
		
		 $upid = $this->db->insert('work_form_home',$add);
		 
		/* $sqli="insert into work_form_home values
							   ('','','','".$empid."','".$leave_applied_from_date."','".$leave_applied_to_date."','leave','".$reason."','WFH','','','','')";
				echo "<br/>";
				if (mysqli_query($connsj,$sqli)) {
						echo "New record created successfully " .$empid; 
					} else {
						//echo "Error: " . $sql1 . "<br>" . mysqli_error($connsj);
					} */
	}
	
	
	public function get_datatables($date='',$emp_id='')
	{  
	
	    $DB1=$this->load->database('s_erp',TRUE);
		$this->_Enquiry_list1($DB1,$date,$emp_id);
		//$this->_Enquiry_list($DB1);
		if($_POST['length'] != -1)
		$DB1->limit($_POST['length'], $_POST['start']);
		$query = $DB1->get();
	//	echo $DB1->last_query(); exit();
		return $query->result();
	}
	
	private function _Enquiry_list1($DB,$date='',$emp_id=''){
		
		
		
		
        $DB->select('*');
		$DB->from('work_form_home');
		
		//$DB->join('vw_stream_details as vw','vw.stream_id=eq.stream_id','left');
		if($date !=''){
		//$DB->where("STR_TO_DATE(eq.created_on,'%Y-%m-%d') ='$date'");
		}
		
		/*if($type_param !=''){
			if($type_param==1){
					$DB->where("eq.form_taken='Y'");
				
			}
			else if($type_param==2){
					$DB->where("eq.provisional_no !='-'  and eq.provisional_no IS NOT NULL");
				
			}
		
		}*/
		if($emp_id !=''){
		$DB->where("Userid='$emp_id'");	
		}
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$DB->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$DB->like($item, $_POST['search']['value']);
				}
				else
				{
					$DB->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$DB->group_end(); //close bracket
			}
			$i++;
		}
		
		
		if(isset($_POST['order'])) // here order processing
		{
			$DB->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$DB->order_by(key($order), $order[key($order)]);
		}
	}
	
	
	

	public function count_filtered($date='',$type_param='')
	{   $DB2=$this->load->database('s_erp',TRUE);
		$this->_Enquiry_list1($DB2,$date,$type_param);
		$query = $DB2->get();
		return $query->num_rows();
	}

	public function count_all($type_param='')
	{  
	    $DB3=$this->load->database('s_erp',TRUE);
		$DB3->from('work_form_home');
		if($type_param !=''){
		$DB3->where('Userid',$type_param);
		}
		//$DB3->where('is_online','N');
		return $DB3->count_all_results();
	}
	
	
	
	function check_employee($uid){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('*');
		$DB1->from('vw_faculty');
		$DB1->where('emp_id',$uid);
		$query=$DB1->get();
     	//$this->db->last_query(); //exit();
    	return	$res=$query->result_array();
	}
	
	
	     public function getLeaveTimeByType()
        {
                return $this->db->get_where('admin_setting', [
                        
                        'status' => 'Y'
                ])->result_array();
        }
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
}