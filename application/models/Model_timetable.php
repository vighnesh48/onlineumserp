<?php
class Model_timetable extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    //get courses offered by college
    function getCollegeCourse($col_id=1){
		$sql="SELECT DISTINCT(cc.course_id),course_code,course_name FROM course_master cm,college_course_branch_reln cc WHERE cc.college_id=$col_id AND cc.course_id=cm.course_id ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	//get admission year for courses offered by college
	function getCourseYRClg($col_id=1){
		$arr = array(1=>array('FE','SE','ME-I','Phd-I'));
		return $arr[$col_id];
    }
	//get Quota
	function getAllOrganizations(){
	$sql="select organisation_id,org_name from organization_master where status='Y'";
     $query=$this->db->query($sql);
	 return $query->result_array();
	}
	function getAllschool(){
	$sql="select college_id,campus_id,college_code,college_name,college_city from college_master where status='Y'";
     $query=$this->db->query($sql);
	 return $query->result_array();
	}
	function getdepartmentByschool($id){
	$sql="select department_id,department_name from department_master where school_college_id='$id' and status='Y'";
     $query=$this->db->query($sql);
	 return $query->result_array();
	}
	function getshifttime($id){
	$sql="select shift_start_time,shift_end_time from shift_master where shift_id='$id' and  status='Y'";
     $query=$this->db->query($sql);
	 return $query->result_array();
	}
	function getAllBank(){
	 $sql="select bank_id,branch_name,account_name,bank_code,bank_name from bank_master where status='Y'";
     $query=$this->db->query($sql);
	 return $query->result_array();	
	}
	function getAllState(){
	 $sql="select state_id,state_code,state_name from state_master where status='Y'";
     $query=$this->db->query($sql);
	 return $query->result_array();	
	}
	function getStateCity($id){
		$sql="SELECT city_id,city_name FROM city_master WHERE state_id='$id' and status='Y'";
        $query = $this->db->query($sql);
        return $query->result_array();
		
	}
	function getCurrentQuarterNo(){
		$today=date('Y-m-d');
		$sql="SELECT QUARTER('$today') as qno";
		$query=$this->db->query($sql);
		$res=$query->result_array();
		return $res[0]['qno'];
	}
	function getCityBystatewiseId($id){
		$sql="SELECT city_id,city_name FROM city_master WHERE state_id='$id' and status='Y'";
        $query = $this->db->query($sql);
        return $query->result_array();
	}
	function getAllShift(){
	 $sql="select shift_id,shift_name from shift_master where status='Y'";
     $query=$this->db->query($sql);
	 return $query->result_array();	
	}
	function getAllDepartments(){
		$sql="SELECT department_id,department_name FROM department_master WHERE status='Y'";
        $query = $this->db->query($sql);
        return $query->result_array();
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
	function getDepartmentListById($id){
		$sql="SELECT department_id,department_name FROM department_master WHERE school_college_id='$id' and status='Y'";
        $query = $this->db->query($sql);
        return $query->result_array();	
	}
	function getAllDesignations(){
		$sql="SELECT designation_id,designation_code,designation_name FROM designation_master WHERE status='Y'";
        $query = $this->db->query($sql);
        return $query->result_array();
	}
	function getAllEmpCategory(){
		$sql="SELECT emp_cat_id,emp_cat_name  FROM employee_category WHERE status='Y'";
        $query = $this->db->query($sql);
        return $query->result_array();
	}
	function getOrganizationById($id){
	$sql="SELECT organisation_id,org_name FROM organization_master WHERE organisation_id='$id' and status='Y'";
        $query = $this->db->query($sql);
        return $query->result_array();	
	}
	function getSchoolById($id){
		$sql="select college_id,college_name from college_master where college_id='$id' and status='Y'";
     $query=$this->db->query($sql);
	 return $query->result_array();
    }
	function getDepartmentById($id){
		$sql="SELECT department_id,department_name FROM department_master WHERE department_id='$id' and status='Y'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	function getDesignationById($id){
		$sql="SELECT designation_id,designation_code,designation_name FROM designation_master WHERE designation_id='$id' and status='Y'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	function getReportingPersonNameById($id){
		$sql="SELECT emp_id,fname,mname,lname FROM employee_master WHERE emp_id='$id' and emp_status='Y'";
		$query = $this->db->query($sql);
		/* print_r($query->result_array());
		die(); */
        return $query->result_array();
    }
	function getAllLeaveType(){
		$this->db->select('leave_id,ltype');
		$this->db->from('leave_master');
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;		
	}
	function getLeaveTypeById($id){
		$this->db->select('ltype');
		$this->db->from('leave_master');
		$this->db->where('leave_id',$id);
		$query=$this->db->get();
		$res=$query->result_array();
		return $res[0]['ltype'];
	}
	function getAllEmployee(){
		$this->db->select("e.*,d.profile_pic");
		$this->db->from('employee_master as e');
		$this->db->join('employee_document_master as d','d.emp_id = e.emp_id','left');
		$this->db->order_by("e.emp_id", "asc");
		$query=$this->db->get();
		/*  echo $this->db->last_query();
		die();  */ 
		$result=$query->result_array();
		$cnt=count($result);
		return $cnt;
	}
	function getEmployees($limit, $id=0){
		$this->db->select("e.*,ot.mobileNumber,d.profile_pic");
		$this->db->from('employee_master as e');
		$this->db->join('employe_other_details as ot','ot.emp_id = e.emp_id','left');
		$this->db->join('employee_document_master as d','d.emp_id = e.emp_id','left');
		$this->db->limit($limit,$id);
		$this->db->order_by("e.emp_id", "asc");	 
		
		$query=$this->db->get();
				
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
	function getEmployeeById($id,$flg){
		$this->db->select("e.*,e.joiningDate as jd,e.emp_id as eid,e.referenceID as rid,ot.*,d.*,st.emp_cat_name,s.college_name,ds.designation_name,de.department_name,sh.shift_name,bk.bank_name,lv.*,sal.*");
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
		$this->db->join('employee_basic_salary_details as sal','sal.emp_id = e.emp_id','left');
		$this->db->where('e.emp_id',$id);
		$this->db->where('e.emp_status',$flg);
		$query=$this->db->get();
		//  echo $this->db->last_query();
	//	die();   
		$result=$query->result_array();
		return $result;
	}
	function getstaffReoprtingData(){
		
	}
 function changeEmployeeStatus($id,$flg){
	 $this->db->where('emp_id',$id);
		if($flg=='Y'){
			$this->db->set('emp_status','N');
		  }else{
		$this->db->set('emp_status','Y');	
		}		
	    $this->db->update('employee_master');
	    $this->db->where('username',$id);
		if($flg=='Y'){
			$this->db->set('status','N');
		  }else{
		$this->db->set('status','Y');	
		}		
	    $this->db->update('user_master');
		  /* echo $this->db->last_query();
		die();   */ 
	    return ($this->db->affected_rows() != 1) ? false : true;
		
	}
	function checkEmployeeIDAvailable($id){
		$this->db->select('*');
		$this->db->from('employee_master');
		$this->db->where('emp_id',$id);
		$query=$this->db->get();
		$res=$query->result_array();
		return $res;
		
	}
	function add_nem_employee($data,$doc,$temp){
		
		
		$arr['emp_id']=(stripcslashes($data['employeeID'])); 
		$arr['fname']=(stripcslashes($data['fname']));
		$arr['mname']=(stripcslashes($data['mname']));
		$arr['lname']=(stripcslashes($data['lname']));
		$arr['referenceID']=(stripcslashes($data['referenceID']));
		$arr['date_of_birth']=(stripcslashes(date('Y-m-d',strtotime($data['date_of_birth']))));
		$arr['gender']=(stripcslashes($data['gender']));
		$arr['blood_gr']=(stripcslashes($data['blood_gr']));
		$arr['staff_type']=(stripcslashes($data['staff_type']));
		$arr['adhar_no']=(stripcslashes($data['adhar_no']));
		$arr['joiningDate']=(stripcslashes(date('Y-m-d',strtotime($data['joiningDate']))));
		$arr['emp_school']=(stripcslashes($data['emp_school']));
		$arr['designation']=(stripcslashes($data['designation']));
		$arr['department']=(stripcslashes($data['department']));
		$arr['staff_grade']=(stripcslashes($data['staff_grade']));
		$arr['hiring_type']=(stripcslashes($data['hiring_type']));
		$arr['qualifiaction']=(stripcslashes($data['qualifiaction']));
		$arr['phy_status']=(stripcslashes($data['phy_status']));
		$arr['pf_status']=(stripcslashes($data['pf_status']));
	//	$arr['week_off']=(stripcslashes($data['week_off']));
	//	$arr['shift']=(stripcslashes($data['shift']));
	//	$arr['intime']=(stripcslashes($data['intime']));
//		$time1=strtotime($arr['intime']);
//		$arr['intime']=date("H:i:s",$time1);
//		$arr['outtime']=(stripcslashes($data['outtime']));
//		$time2=strtotime($arr['outtime']);
//		$arr['outtime']=date("H:i:s",$time2);
		$arr['reporting_school']=(stripcslashes($data['reporting_school']));
		$arr['reporting_dept']=(stripcslashes($data['reporting_dept']));
		$arr['reporting_person']=(stripcslashes($data['reporting_person']));
		$arr['ro_flag']=(stripcslashes($data['ro_flag']));
		
		$arr['inserted_by']=$this->session->userdata("uid");
		$arr['inserted_datetime']=date("Y-m-d H:i:s");
		
		
		//contact details
		$detail['emp_id']=(stripcslashes($data['employeeID'])); 
		$detail['landline_std']=(stripcslashes($data['landline_std']));
		$detail['landline_no']=(stripcslashes($data['landline_no']));		
		$detail['mobileNumber']=(stripcslashes($data['mobileNumber']));
		$detail['pemail']=(stripcslashes($data['pemail']));
		$detail['oemail']=(stripcslashes($data['oemail']));
		//local address
		$detail['lflatno']=(stripcslashes($data['bill_A']));
		$detail['larea_name']=(stripcslashes($data['bill_B']));
		$detail['ltaluka']=(stripcslashes($data['bill_T']));
		$detail['ldist']=(stripcslashes($data['bill_C']));
		$detail['lpincode']=(stripcslashes($data['bill_pc']));
		$detail['lstate']=(stripcslashes($data['bill_D']));
		$detail['lcountry']=(stripcslashes($data['bill_country']));
		//premanent address
		$detail['pflatno']=(stripcslashes($data['shipping_A']));
		$detail['parea_name']=(stripcslashes($data['shipping_B']));
		$detail['ptaluka']=(stripcslashes($data['shipping_T']));
		$detail['pdist']=(stripcslashes($data['shipping_C']));
		$detail['p_pincode']=(stripcslashes($data['shipping_pc']));
		$detail['pstate']=(stripcslashes($data['shipping_D']));
		$detail['pcountry']=(stripcslashes($data['shipping_country']));
		//for both address same checking
		$detail['same']=(stripcslashes($data['same']));
		//experience details
		$detail['aexp_yr']=(stripcslashes($data['aexp_yr']));
		$detail['aexp_mnth']=(stripcslashes($data['aexp_mnth']));
		$detail['inexp_yr']=(stripcslashes($data['inexp_yr']));
		$detail['inexp_mnth']=(stripcslashes($data['inexp_mnth']));
		$detail['rexp_yr']=(stripcslashes($data['rexp_yr']));
		$detail['rexp_mnth']=(stripcslashes($data['rexp_mnth']));
		$detail['texp_yr']=(stripcslashes($data['texp_yr']));
		$detail['texp_mnth']=(stripcslashes($data['texp_mnth']));
		//salary details
		$detail['scaletype']=(stripcslashes($data['scaletype']));
		$detail['basic_sal']=(stripcslashes($data['basic_sal']));
		$detail['allowance']=(stripcslashes($data['allowance']));
		$detail['pay_band_min']=(stripcslashes($data['pay_band_min']));
		$detail['pay_band_max']=(stripcslashes($data['pay_band_max']));
		$detail['pay_band_gt']=(stripcslashes($data['pay_band_gt']));
		$detail['other_pay']=(stripcslashes($data['other_pay']));
		
		$detail['bank_acc_no']=(stripcslashes($data['bank_acc_no']));
		$detail['bank_name']=(stripcslashes($data['bank_name']));
		$detail['pf_no']=(stripcslashes($data['pf_no']));
		$detail['pan_no']=(stripcslashes($data['pan_no']));
		
		$detail['inserted_by']=$this->session->userdata("uid");
		$detail['inserted_datetime']=date("Y-m-d H:i:s");
		
		
         
		  /* echo"<pre>";
		print_r($arr);
		print_r($detail);
		print_r($leave);
		echo"</pre>";  
		die();  */
		
		
		//Employee Login data
		$temp['roles_id']=3;
		$temp['inserted_by']=$this->session->userdata("uid");
		$temp['inserted_datetime']=date("Y-m-d H:i:s");
		//"inserted_by"=>$this->session->userdata("uid"),"inserted_datetime"=>date("Y-m-d H:i:s")
		
		//******first part****/
		$insert_id =$this->db->insert('employee_master',$arr);
		$fetch_id=$this->db->insert_id();
		//insert sift time to reporting time table
		$arr1 = array();
		$arr1['emp_id']=(stripcslashes($fetch_id));
		$arr1['emp_code']=(stripcslashes($data['employeeID']));
		$arr1['week_off']=(stripcslashes($data['week_off']));
		$arr1['shift']=(stripcslashes($data['shift']));
		$arr1['intime']=(stripcslashes($data['intime']));
		$time1=strtotime($arr1['intime']);
		$arr1['intime']=date("H:i:s",$time1);
		$arr1['outtime']=(stripcslashes($data['outtime']));
		$time2=strtotime($arr1['outtime']);
		$arr1['outtime']=date("H:i:s",$time2);
		$arr1['inserted_by']=$this->session->userdata("uid");
		$arr1['inserted_date']=date("Y-m-d H:i:s");
			$insert_id2 =$this->db->insert('reporting_time',$arr1);
		
	//	echo $this->db->last_query();
	//	exit();
		/****Second Part**///
		$insert_id1 =$this->db->insert('employe_other_details',$detail);
		$fetch_id1=$this->db->insert_id();
		//echo $this->db->last_query();	
		
		
		//scan documents of employee
		if(!empty($fetch_id)&& $fetch_id!=0){
			$doc['emp_tbl_reg_id']=$fetch_id;
			$doc['emp_id']=$arr['emp_id'];
			$fid=$this->db->insert('employee_document_master',$doc);
		//echo $this->db->last_query();
			//die();
			$fdid=$this->db->insert_id();
        // for employee Login
            /* print_r($temp);
exit;		 */	
	        $aid=$this->db->insert('user_master',$temp);
			$a_ins=$this->db->insert_id();
		}
		//die();
		if(!empty($fetch_id)&&!empty($fdid)&&!empty($a_ins)){
			return $fdid;
		}
		
		
	}
	function addHoliday($data){
	    $s = date('d',strtotime($data['frm_date']));
		$e = date('d',strtotime($data['to_date']));
		for($i=$s; $i<=$e;$i++){
			$fd1 = date('Y-m',strtotime(stripcslashes($data['frm_date'])));
			$fd = $fd1.'-'.$i ;
				$arr['academic_year']=(stripcslashes($data['academic_year']));
		$arr['order_ref_no']=(stripcslashes($data['order_ref_no']));
		$arr['order_date']=(stripcslashes($data['order_date']));
	    $arr['hdate']= $fd; 
		$arr['to_date']=(stripcslashes($data['to_date']));
		$arr['approved_by']=(stripcslashes($data['approved_by']));
		$arr['occasion']=(stripcslashes($data['occasion']));
		$day= date('l', strtotime($arr['hdate']));
		$arr['hday']=($day);
		$arr['inserted_by']=$this->session->userdata("uid");
		$arr['inserted_datetime']=date("Y-m-d H:i:s");
        $insert_id = $this->db->insert('holiday_list_master',$arr);	
		}	
if(!empty($insert_id)){
			return $insert_id;
		}
// query for moth wise holiday selection 
//SELECT * FROM holiday_list_master WHERE Year(hdate) = '2016' and MONTHNAME(hdate) = 'Octomber' 		
	}
	function getHolidayListMonthWise($mnth,$yr){
		$this->db->select('*');
		$this->db->where('academic_year',$yr);
		//$this->db->where('Year(hdate)',$yr);
		$this->db->where('MONTHNAME(hdate)',$mnth);
		$this->db->where('status','Y');
		$this->db->from('holiday_list_master');
		$this->db->group_by('order_ref_no'); 
		$this->db->order_by('day(hdate)', 'ASC');

		$query=$this->db->get();
	//	echo $this->db->last_query();
	//	die();
		$result=$query->result_array();
		return $result;
		
	}
	function getTotalHoliday($m,$y){
		$sql="select count(hdate) as no_hol from holiday_list_master where month(hdate)='$m' and year(hdate)='$y'";
		$query = $this->db->query($sql);
        $res=$query->result_array();
		return $res[0]['no_hol'];
	}
	function getDayofHolidays($rno){
		$this->db->select('hday');
		$this->db->where('order_ref_no',$rno);		
		$this->db->from('holiday_list_master'); 
		$this->db->order_by('day(hdate)', 'ASC'); 
		$query=$this->db->get();
		//echo $this->db->last_query();
		//die();
		$result=$query->result_array();
		return $result;
	}
/*	function del_Holiday($id){
		 $this->db->where('hid', $id);
        $res=$this->db->delete('holiday_list_master'); 
		return ($this->db->affected_rows() != 1) ? false : true;
	} */
	function del_Holiday($id){
		
		$this->db->where('hid',$id) ; 
	  $this->db->set('status','N');	  
	 $this->db->update('holiday_list_master');		
		$i= $this->db->affected_rows();	 
		return ($i >= 1) ? true : false;
	}
	function del_Holiday_byoid($id){		
       $this->db->where('order_ref_no',$id) ; 
	  $this->db->set('status','N');	  
	 $this->db->update('holiday_list_master');
        $i= $this->db->affected_rows();	 
		return ($i >= 1) ? true : false;
	}
	function getAllLeaveApplicantList(){ //For Admin
		 $this->db->select('l.*');
		 $this->db->where('l.vstatus','Y');
		$this->db->from('leave_applicant_list as l');
		$query=$this->db->get(); 
		$result=$query->result_array();
		return $result;
	}
	function getLeaveApplicantList($role,$rname){  //for RO or Registrar
	       //check the user role type
		   //for RO
		   if($role==3){ //for employee and type is RO
		$sql= "SELECT l.*,e.reporting_person FROM leave_applicant_list as l 
               left join employee_master as e on e.emp_id=l.emp_id
               WHERE e.reporting_person='$rname' and l.vstatus='Y'";
		   }elseif($role==7){  //for type is registrar
             $sql= "SELECT * from leave_applicant_list WHERE reg_forward='Y' and vstatus='Y'";			   
		   }
			   $query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
		
	}
	function getAllODApplicantList(){  //For Admin
		 $this->db->select('o.*');
		 $this->db->where('o.vstatus','Y');
		$this->db->from('od_application_list as o');
		$query=$this->db->get(); 
		$result=$query->result_array();
		return $result;
	}
	function getODApplicantList($role,$rname){ //for RO
		$sql= "SELECT o.*,e.reporting_person FROM od_application_list as o 
               left join employee_master as e on e.emp_id=o.emp_id
               WHERE e.reporting_person='$rname' and o.vstatus='Y'";
			   $query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
		
	}
  function getLeaveDetailById($id){
	$this->db->select('*');
    $this->db->where('lid',$id);
    $this->db->where('vstatus','Y');
    $this->db->from('leave_applicant_list');
    $query=$this->db->get();
		/*  echo $this->db->last_query();
		die();   */
		$result=$query->result_array();
		return $result;	
  }
  function getODDetailById($id){
	$this->db->select('*');
    $this->db->where('oid',$id);
    $this->db->where('vstatus','Y');
    $this->db->from('od_application_list');
    $query=$this->db->get();
		/*  echo $this->db->last_query();
		die();   */
		$result=$query->result_array();
		return $result;	
  }
  
  //Leave Application Updated by RO
  function update_leave_applicationDetails($data){

if(isset($data['afsubmit'])){
	//if RO approve and forward the leave to registrar following update will occur..
		/*   echo "in approve";
		   print_r($_POST); */
		   //exit; 
		   //$data['updated_by']=$this->session->userdata("uid");
	  $this->db->where('lid',$data['lid']) ;
	  $this->db->where('emp_id',$data['emp_id']); 
	  $this->db->set('reg_forward','Y');
	  $this->db->set('ro_approval_status',$data['status']);
	  $this->db->set('ro_recommend',$data['ro_recommendation']);
	$upid= $this->db->update('leave_applicant_list');
    if($upid==1){ //if leave get procedded at any point its log will be maintained in following table
	$log['leave_id']=$data['lid'];
	$log['updated_by']=$this->session->userdata("uid");
	$log['updated_status']=$data['status'];
	$insid=$this->db->insert('leave_process_log',$log);
		
	}		   
	   }elseif(isset($data['resubmit'])){
		   //if RO  reject the leave application
		   /* echo "in reject";
		   print_r($_POST); */
		  // exit;  
		   $this->db->where('lid',$data['lid']) ;
	  $this->db->where('emp_id',$data['emp_id']); 
	  $this->db->set('reg_forward','N');
	  $this->db->set('ro_approval_status',$data['status']);
	  $this->db->set('ro_rej_reason',$data['ro_rejection']);
	  $upid= $this->db->update('leave_applicant_list');	   
		if($upid==1){ //if leave get procedded at any point its log will be maintained in following table
	$log['leave_id']=$data['lid'];
	$log['updated_by']=$this->session->userdata("uid");
	$log['updated_status']=$data['status'];
	$insid=$this->db->insert('leave_process_log',$log);
		
	}	  
	   } 
     if($upid!=0 && !empty($upid)){
		 return true;
		 }   	   
	  
  }
  
  //Leave application Updated by Registrar
  function update_leave_applicationByRegistrar($data){
	  //echo"<pre>";print_r($data);die();
	  
	  $this->db->where('lid',$data['lid']) ;
	  $this->db->where('emp_id',$data['emp_id']); 
	  $this->db->set('reg_approval_status',$data['reg_approval_status']);
	  $this->db->set('status',$data['reg_approval_status']);
	  $this->db->set('reg_comment',$data['reg_comment']);
	  $upid= $this->db->update('leave_applicant_list');	
    if($upid==1){ //if leave get procedded at any point its log will be maintained in following table
	$log['leave_id']=$data['lid'];
	$log['updated_by']=$this->session->userdata("uid");
	$log['updated_status']=$data['reg_approval_status'];
	$insid=$this->db->insert('leave_process_log',$log);
		
	}
    $x='';
	  $x=($this->db->affected_rows() != 1) ? false : true;
	  $ret['ures']=$x;
	  $ret['emp_id']=$data['emp_id'];
	  $ret['leave_type']=$data['leave_type'];
	  $ret['no_days']=$data['no_days'];
	  $ret['lstatus']=$data['reg_approval_status'];
/*  echo $x;
	echo"<pre>";print_r($ret);
	 die(); */ 
	 //exit;
	  return $ret;
 	
  }
  
  function deductLeaveCount($data){
	  $sql1="select ltype from leave_master where leave_id='".$data['leave_type']."'";	
	  $query1=$this->db->query($sql1);
	  $res1=$query1->result_array();
	 
	  $sql2="select cnt_".strtolower($res1[0]['ltype'])." from employee_leave_track where emp_id='".$data['emp_id']."'";	 
	  $query2=$this->db->query($sql2);
	  $res2=$query2->result_array();
	  $lcnt=$res2[0]['cnt_'.strtolower($res1[0]['ltype']).''];
	// echo $lcnt;
	  if($lcnt>=$data['no_days']){
		$ucnt= $lcnt-$data['no_days']; 
	  }
	  //echo $ucnt;
	  //exit;
	  $sql3="update employee_leave_track set cnt_".strtolower($res1[0]['ltype'])."='$ucnt' where emp_id='".$data['emp_id']."'";
	 // echo $sql3;
	  
	  $query3=$this->db->query($sql3);
	  $x=($this->db->affected_rows() != 1) ? false : true;
	  // echo $x;
	 // exit; 
	 return $x;
  }
  function update_od_applicationDetails($data){
	  $data['updated_by']=$this->session->userdata("uid");
	  $this->db->where('oid',$data['oid']) ;
	  $this->db->where('emp_id',$data['emp_id']); 
	  $this->db->update('od_application_list',$data);
	  return ($this->db->affected_rows() != 1) ? false : true;
  }
  function remove_leave_application($id){
	    $sql="update leave_applicant_list set vstatus='N',updated_by='".$this->session->userdata("uid")."' where lid='$id'";
        $this->db->query($sql);	   
	  return ($this->db->affected_rows() != 1) ? false : true;
  }
  function remove_od_application($id){
	  $sql="update od_application_list set vstatus='N',updated_by='".$this->session->userdata("uid")."' where oid='$id'";
        $this->db->query($sql);	
	  return ($this->db->affected_rows() != 1) ? false : true;
  }
   
	function update_employee($data,$doc){
	    
        $arr['emp_id']=(stripcslashes($data['employeeID'])); 
		$arr['fname']=(stripcslashes($data['fname']));
		$arr['mname']=(stripcslashes($data['mname']));
		$arr['lname']=(stripcslashes($data['lname']));
		$arr['referenceID']=(stripcslashes($data['referenceID']));
		$arr['date_of_birth']=(stripcslashes(date('Y-m-d',strtotime($data['date_of_birth']))));
		$arr['gender']=(stripcslashes($data['gender']));
		$arr['blood_gr']=(stripcslashes($data['blood_gr']));
		$arr['staff_type']=(stripcslashes($data['staff_type']));
		$arr['adhar_no']=(stripcslashes($data['adhar_no']));
		$arr['category']=(stripcslashes($data['category']));
		$arr['cast']=(stripcslashes($data['cast']));
		$arr['sub-cast']=(stripcslashes($data['sub-cast']));
		
		$arr['joiningDate']=(stripcslashes(date('Y-m-d',strtotime($data['joiningDate']))));
		$arr['emp_school']=(stripcslashes($data['emp_school']));
		$arr['designation']=(stripcslashes($data['designation']));
		$arr['department']=(stripcslashes($data['department']));
		$arr['staff_grade']=(stripcslashes($data['staff_grade']));
		$arr['hiring_type']=(stripcslashes($data['hiring_type']));
		$arr['qualifiaction']=(stripcslashes($data['qualifiaction']));
		$arr['phy_status']=(stripcslashes($data['phy_status']));
		$arr['pf_status']=(stripcslashes($data['pf_status']));
	//	$arr['week_off']=(stripcslashes($data['week_off']));
	//	$arr['shift']=(stripcslashes($data['shift']));
	//	$arr['intime']=(stripcslashes($data['intime']));
	//	$time1=strtotime($arr['intime']);
	//	$arr['intime']=date("H:i:s",$time1);
	//	$arr['outtime']=(stripcslashes($data['outtime']));
	//	$time2=strtotime($arr['outtime']);
	//	$arr['outtime']=date("H:i:s",$time2);
		
		$arr['reporting_school']=(stripcslashes($data['reporting_school']));
		$arr['reporting_dept']=(stripcslashes($data['reporting_dept']));
		$arr['reporting_person']=(stripcslashes($data['reporting_person']));
		$arr['ro_flag']=(stripcslashes($data['ro_flag']));
		$arr['updated_by']=$this->session->userdata("uid");
		
		 /* echo"<pre>";
		 print_r($arr);
		
		echo"</pre>"; 
		echo"******************************";
		die();   */ 
		
		//contact details
		$detail['emp_id']=(stripcslashes($data['employeeID'])); 
		$detail['alternateno']=(stripcslashes($data['alternateno']));
		$detail['landline_std']=(stripcslashes($data['landline_std']));
		$detail['landline_no']=(stripcslashes($data['landline_no']));		
		$detail['mobileNumber']=(stripcslashes($data['mobileNumber']));
		$detail['pemail']=(stripcslashes($data['pemail']));
		$detail['oemail']=(stripcslashes($data['oemail']));
		//local address
		$detail['lflatno']=(stripcslashes($data['bill_A']));
		$detail['larea_name']=(stripcslashes($data['bill_B']));
		$detail['ltaluka']=(stripcslashes($data['bill_T']));
		$detail['ldist']=(stripcslashes($data['bill_C']));
		$detail['lpincode']=(stripcslashes($data['bill_pc']));
		$detail['lstate']=(stripcslashes($data['bill_D']));
		$detail['lcountry']=(stripcslashes($data['bill_country']));
		//premanent address
		$detail['pflatno']=(stripcslashes($data['shipping_A']));
		$detail['parea_name']=(stripcslashes($data['shipping_B']));
		$detail['ptaluka']=(stripcslashes($data['shipping_T']));
		$detail['pdist']=(stripcslashes($data['shipping_C']));
		$detail['p_pincode']=(stripcslashes($data['shipping_pc']));
		$detail['pstate']=(stripcslashes($data['shipping_D']));
		$detail['pcountry']=(stripcslashes($data['shipping_country']));
		//for both address same checking
		$detail['same']=(stripcslashes($data['same']));
		//experience details
		$detail['aexp_yr']=(stripcslashes($data['aexp_yr']));
		$detail['aexp_mnth']=(stripcslashes($data['aexp_mnth']));
		$detail['inexp_yr']=(stripcslashes($data['inexp_yr']));
		$detail['inexp_mnth']=(stripcslashes($data['inexp_mnth']));
		$detail['rexp_yr']=(stripcslashes($data['rexp_yr']));
		$detail['rexp_mnth']=(stripcslashes($data['rexp_mnth']));
		$detail['texp_yr']=(stripcslashes($data['texp_yr']));
		$detail['texp_mnth']=(stripcslashes($data['texp_mnth']));
		//salary details
		$detail['scaletype']=(stripcslashes($data['scaletype']));
		$detail['basic_sal']=(stripcslashes($data['basic_sal']));
		$detail['allowance']=(stripcslashes($data['allowance']));
		$detail['pay_band_min']=(stripcslashes($data['pay_band_min']));
		$detail['pay_band_max']=(stripcslashes($data['pay_band_max']));
		$detail['pay_band_gt']=(stripcslashes($data['pay_band_gt']));
		$detail['other_pay']=(stripcslashes($data['other_pay']));
		
		$detail['bank_acc_no']=(stripcslashes($data['bank_acc_no']));
		$detail['bank_name']=(stripcslashes($data['bank_name']));
		$detail['pf_no']=(stripcslashes($data['pf_no']));
		$detail['pan_no']=(stripcslashes($data['pan_no']));
				
	    $detail['updated_by']=$this->session->userdata("uid");
		
		
		//for employee table update 
	     $this->db->where('emp_id',$arr['emp_id']);
		 $res1=$this->db->update('employee_master',$arr);
	//	echo $this->db->last_query();
	//	exit;		 
		  if($res1==true){
			  $this->db->where('emp_id',$arr['emp_id']);
		 $res2=$this->db->update('employe_other_details',$detail);
		// echo $this->db->last_query();
		
		 
		 if($res2==true){
			 foreach($doc as $key=>$val){
				 if($val!=''){
				 $this->db->set($key, $val);
				$this->db->where('emp_id',$arr['emp_id']);
				$res2=$this->db->update('employee_document_master'); 
		//echo $this->db->last_query();
				 //die();  
				 }
			   }
			 }			 
		 }		 
		 if($res1==true){
			return true; 
		 }		 
	}
	//*****Attendance Related Function
	function check_todays(){
		$today=date("Y-m-d");
		$sql="select * from punching_backup where date(Intime)='$today'";
		 /* echo $sql;
		die();  */ 
		$query = $this->db->query($sql);
        $res = $query->result_array();
		return $res;
	}
	function backupDeviceLogDaily(){
		// inserting todays data(intime) in the punching  table from devicelogs table
	$today=date("Y-m-d");
	//$today='2017-01-31'; //yyyy-mm-dd
//$today = '2017-03-31';
		//$sql="SELECT DeviceId,UserId,min(`LogDate`) as punch_intime,IF(min(`LogDate`)!=max(`LogDate`),max(`LogDate`),'0000-00-00 00:00:00') as punch_outtime FROM `devicelogs_11_2015` where month(`LogDate`)='12' group by UserId ORDER BY UserId DESC";
		$sql="SELECT DeviceId,UserId,min(LogDate) as punch_intime,IF(min(`LogDate`)!=max(`LogDate`),max(`LogDate`),'0000-00-00 00:00:00') as punch_outtime from devicelogs_11_2015 where date(LogDate)='$today' group by UserId order by UserId asc";
		//  echo $sql;
		//die();    
		$query = $this->db->query($sql);
        $res = $query->result_array();
		 
     foreach($res as $org)
     {
	//echo $org['DeviceId'];
    $sql="insert into punching_backup(DeviceId,UserId,Intime,Outtime,updated_date)values(".$org['DeviceId'].",".$org['UserId'].",'".$org['punch_intime']."','".$org['punch_outtime']."','$today')";
	//echo $sql;
	$query = $this->db->query($sql);
    }	

//Inserting previous days out time in punching table from devicelogs table
$yesterday=date("Y-m-d",strtotime("-1 days"));
$sql1="SELECT DeviceId,UserId,IF(min(`LogDate`)!=max(`LogDate`),max(`LogDate`),'0000-00-00 00:00:00') as punch_outtime FROM `devicelogs_11_2015` 
       where date(`LogDate`)='$yesterday' group by UserId ORDER BY UserId DESC";
$query1=$this->db->query($sql1);
$res1=$query1->result_array();
//print_r($res1);
	
     foreach($res1 as $org1)
{
	//echo $org1['punch_outtime'];
    $upsql="update punching_backup set Outtime ='".$org1['punch_outtime']."' where UserId='".$org1['UserId']."' and DeviceId='".$org1['DeviceId']."' 
	         and date(`Intime`)='$yesterday'";
	//echo $upsql;
	$query = $this->db->query($upsql);
}	
	//die(); 
	
	}
	function checkAvailableAttendance($dt){
		$d = date_parse_from_format("Y-m-d", $dt);
      
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($dt));
		$sql="select * from punching_backup where month(Intime)='$msearch' and year(Intime)='$ysearch'";
		/* echo $sql;
		die(); */
		$query1=$this->db->query($sql);
        $res1=$query1->result_array();
		return $res1;
		
	}
	function checkAvailableAttendanceDate($dt,$sh,$dp){
	    
	$DB1 = $this->load->database('otherdb', TRUE); 
	    	
		$d = date_parse_from_format("Y-m-d", $dt);
      
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($dt));
         $dsearch=date("d",strtotime($dt));
         $whr = '';
         if(!empty($sh)){
             $whr .= "and e.emp_school='".$sh."'";
         }
         if(!empty($dp)){
             $whr .= "and e.department='".$dp."' ";
         }
		$sql="SELECT e.fname,e.mname ,e.lname,el.* from sandipun_attendance.essl_logs as el
        INNER JOIN sandipun_erp.employee_master as e ON e.emp_id = el.UserId
		INNER JOIN sandipun_erp.department_master as dept ON dept.department_id = e.department
		INNER JOIN sandipun_erp.college_master as sc ON sc.college_id = e.emp_school
		WHERE day(el.LogDate) = '$dsearch' and
		month(el.LogDate) ='$msearch'  AND
		year(el.LogDate) = '$ysearch' ".$whr."   group by el.UserId ";
		 
		$query1=$this->db->query($sql);
        $res1=$query1->result_array();
        $data = array();
       // echo count($res1);
        foreach($res1 as $val){
         
          //$data['emp_name'][] = $val['fname']." ".$val['mname']." ".$val['lname'];
          //if(!empty($val['fname'])){
          $em = $this->getAttendance_byid($val['UserId'],$dsearch,$msearch,$ysearch);
          $pt = "";
          foreach($em as $val1){
              $pt = $val1['punch_intime'].','.$val1['punch_outtime'];
              
          }
          //}
           $data[] =  $val['UserId'].','.$val['fname']." ".$val['mname']." ".$val['lname'].','.$pt;
        }
       // echo "<pre>";
     // print_r($data);exit;
		return $data;
		
	}
	function getAttendance_byid($uid,$dsearch,$msearch,$ysearch){ // for displaying todya's attendance of all employee bydefault.....
	   
	$DB1 = $this->load->database('otherdb', TRUE); 
		$sql="SELECT min(`LogDate`) as punch_intime , IF(min(`LogDate`)!=max(`LogDate`),max(`LogDate`),'0000-00-00 00:00:00') as punch_outtime FROM `essl_logs` where day(LogDate) = '$dsearch' and
		month(LogDate) ='$msearch'  AND	year(LogDate) = '$ysearch' AND UserId ='$uid' ";
		   
		$query = $DB1->query($sql);
        return $query->result_array();
}
	function getAttendance_AllDefault1(){ // for displaying todya's attendance of all employee bydefault.....
	    $today=date("Y-m-d");
	
		$sql="SELECT UserId,min(`LogDate`) as punch_intime , IF(min(`LogDate`)!=max(`LogDate`),max(`LogDate`),'0000-00-00 00:00:00') as punch_outtime ,date(`LogDate`) as punch_date,YEAR(`LogDate`) as year,MONTH(`LogDate`)as month FROM `devicelogs_11_2015` where date(`LogDate`)='$today' group by UserId ,punch_date ORDER BY UserId,punch_date DESC";
		 /* echo $sql;
		die();   */  
		$query = $this->db->query($sql);
        return $query->result_array();
}
     function getAttendance_AllDefault($offSet=0,$limit=1){
	$today=date("Y-m-d");
//echo $today;		
		$sql="SELECT UserId,min(`LogDate`) as punch_intime , IF(min(`LogDate`)!=max(`LogDate`),max(`LogDate`),'0000-00-00 00:00:00') as punch_outtime ,date(`LogDate`) as punch_date,YEAR(`LogDate`) as year,MONTH(`LogDate`)as month FROM `devicelogs_11_2015` where date(`LogDate`)='$today' group by UserId ,punch_date ORDER BY UserId,punch_date DESC Limit $offSet,$limit";
		 // echo $sql;
		//die();  */   
		$query = $this->db->query($sql);
        return $query->result_array();
}
function getAttendance_All1($data){    // count for all employee under searched school and department 
           /*   print_r($data);
die();			 */ 
			$sql="SELECT DISTINCT e.emp_id ,e.fname,e.mname,e.lname,d.designation_name,dept.department_name,sc.college_name FROM `employee_master` as e
                LEFT JOIN `designation_master` as `d` ON `d`.`designation_id` = `e`.`designation`
		        LEFT JOIN `department_master` as `dept` ON `dept`.`department_id` = `e`.`department`
		        LEFT JOIN `college_master` as `sc` ON `sc`.`college_id` = `e`.`emp_school`

			WHERE emp_school ='".$data['emp_school']."' and department ='".$data['department']."' ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getAttendance_All($data,$emp,$offSet=0,$limit=1){// fetch all employees monthly attendance with serched school and department    		
		  $monthly=array();
		  $time=strtotime($data['attend_date']);
		  $d = date_parse_from_format("Y-m-d", $data['attend_date']);
      
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($data['attend_date']));
		
		foreach($emp as $e){   //fetch all employees monthly attendance with serched school and department   
		$user=$e['emp_id'];
		$fetch_monthly="SELECT `e`.`fname`,`e`.`mname` ,`e`.`lname`,d.designation_name,dept.department_name,sc.college_name, p.* from punching_backup as p
        LEFT JOIN `employee_master` as `e` ON `e`.`emp_id` = `p`.`UserId`
		LEFT JOIN `designation_master` as `d` ON `d`.`designation_id` = `e`.`designation`
		LEFT JOIN `department_master` as `dept` ON `dept`.`department_id` = `e`.`department`
		LEFT JOIN `college_master` as `sc` ON `sc`.`college_id` = `e`.`emp_school`
		WHERE `e`.`emp_school`='".$data['emp_school']."' and
		`e`.`department`='".$data['department']."' and
		month(p.updated_date) ='$msearch'  AND
		year(p.updated_date) = '$ysearch' and
		p.UserId='".$e['emp_id']."'
		ORDER BY `p`.`Intime` ";
	     /* echo $fetch_monthly;
		die();  */
        $query1=$this->db->query($fetch_monthly);
		$monthly[$user]=$query1->result_array();
	}
	 
	return $monthly;
	}
	function getAttendanceForSearchID($data){
	//print_r($data);
		$time=strtotime($data['attend_date']);
		$d = date_parse_from_format("Y-m-d", $data['attend_date']);
//echo $d["month"];
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($data['attend_date']));
		
		$this->db->select('e.emp_id,e.fname,e.lname,e.emp_school,e.department,d.profile_pic,p.DeviceLogId,p.Intime,p.Outtime,p.status');
		$this->db->from('employee_master as e');
		$this->db->join('employee_document_master as d','d.emp_id= e.emp_id','left');
		$this->db->join('punching_backup as p','p.UserId= e.emp_id','left');
		$this->db->where('e.emp_id',$data['emp_id']);
		$this->db->where('e.emp_school',$data['emp_school']);
		$this->db->where('e.department',$data['department']);
		$this->db->where('month(p.Intime)',$msearch);
		$this->db->where('year(p.Intime)',$ysearch);
		$this->db->order_by('p.Intime','desc');
		//$this->db->or_where('month(p.Outtime)',$msearch);
		//$this->db->where('year(p.Outtime)',$ysearch);
		
		$query=$this->db->get();
		/* echo $this->db->last_query($query);
		die();   */
		return $query->result_array();
	}
	
	//for total present day of month for date and Employee Id
	function getTotalPresentByID($data){
		
		$time=strtotime($data['attend_date']);
		//$msearch=date("M",$time);
		
		$d = date_parse_from_format("Y-m-d", $data['attend_date']);
//echo $d["month"];
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($data['attend_date']));
		
		$sql="SELECT count(status) as total FROM `punching_backup` WHERE `UserId`=".$data['emp_id']." and month(`Intime`)=".$msearch." and year(`Intime`)=".$ysearch." and status='present' ";
		$query = $this->db->query($sql);
		 /* echo $this->db->last_query($query);
		die();  */
        return $query->result_array();
		
	}
	//for total Abscent day of month for date and Employee Id
	function getTotalAbscentByID($data){
		$time=strtotime($data['attend_date']);
		//$msearch=date("M",$time);
		
		$d = date_parse_from_format("Y-m-d", $data['attend_date']);
//echo $d["month"];
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($data['attend_date']));
		
		$sql="SELECT count(status) as total FROM `punching_backup` WHERE `UserId`=".$data['emp_id']." and month(`Intime`)=".$msearch." and year(`Intime`)=".$ysearch." and status='abscent' ";
		$query = $this->db->query($sql);
		/* echo $this->db->last_query($query);
		die(); */
        return $query->result_array();
		
	}
	//for total OutDuty OD day of month for date and Employee Id
	function getTotalOuterDutyByID($data){
		$time=strtotime($data['attend_date']);
		//$msearch=date("M",$time);
		
		$d = date_parse_from_format("Y-m-d", $data['attend_date']);
//echo $d["month"];
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($data['attend_date']));
		
		$sql="SELECT count(status) as total FROM `punching_backup` WHERE `UserId`=".$data['emp_id']." and month(`Intime`)=".$msearch." and year(`Intime`)=".$ysearch." and status='outduty' ";
		$query = $this->db->query($sql);
		/* echo $this->db->last_query($query);
		die(); */
        return $query->result_array();
		
	}
	//for total overtime OT day of month for date and Employee Id
	function getTotalOverTimeByID($data){
		$time=strtotime($data['attend_date']);
		//$msearch=date("M",$time);
		
		$d = date_parse_from_format("Y-m-d", $data['attend_date']);
//echo $d["month"];
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($data['attend_date']));
		
		$sql="SELECT count(status) as total FROM `punching_backup` WHERE `UserId`=".$data['emp_id']." and month(`Intime`)=".$msearch." and year(`Intime`)=".$ysearch." and status='overtime' ";
		$query = $this->db->query($sql);
		/*  echo $this->db->last_query($query);
		die(); */ 
        return $query->result_array();
		
	}
	//for total Late Mark LT day of month for date and Employee Id
	function getTotalLatemarkByID($data){
		$time=strtotime($data['attend_date']);
		//$msearch=date("M",$time);
		
		$d = date_parse_from_format("Y-m-d", $data['attend_date']);
//echo $d["month"];
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($data['attend_date']));
		
		$sql="SELECT count(status) as total FROM `punching_backup` WHERE `UserId`=".$data['emp_id']." and month(`Intime`)=".$msearch." and year(`Intime`)=".$ysearch." and status='latemark' ";
		$query = $this->db->query($sql);
		/* echo $this->db->last_query($query);
		die(); */
        return $query->result_array();
		
	}
	//for total Leave  day of month for date and Employee Id
	function getTotalLeaveByID($data){
		$time=strtotime($data['attend_date']);
		//$msearch=date("M",$time);
		
		$d = date_parse_from_format("Y-m-d", $data['attend_date']);
//echo $d["month"];
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($data['attend_date']));
		
		$sql="SELECT count(status) as total FROM `punching_backup` WHERE `UserId`=".$data['emp_id']." and month(`Intime`)=".$msearch." and year(`Intime`)=".$ysearch." and status='leave' ";
		$query = $this->db->query($sql);
		/* echo $this->db->last_query($query);
		die(); */
        return $query->result_array();
		
	}
	function updateEmpAttendance($data){
		 	 
		$dt=date("Y-m-d",strtotime($data['adate']));
		$entry=$dt." ".$data['intime'];
		$exit=$dt." ".$data['outtime'];
		//echo $dt;
		//die(); 
		$this->db->where('UserId',$data['emp_id']);
		$this->db->where('date(Intime)',$dt);
		$this->db->set('Intime',$entry);	
		$this->db->set('Outtime',$exit);	
		$this->db->set('status',$data['status']);	
		$this->db->set('reason',$data['reason']);	
		$this->db->set('updated_by',$this->session->userdata("uid"));	
		$this->db->update('punching_backup');
	//echo $this->db->last_query($query);
		 $res=$this->db->affected_rows();
	  /* echo $res; 
	die();      */ 
	    return ($this->db->affected_rows() != 1) ? false : true;
		
	}
	
	function get_time_difference($time1, $time2) {
		
   if($time1!='00:00:00') $time1 = strtotime("1980-01-01 $time1");else $time1=0;
   if($time2!='00:00:00') $time2 = strtotime("1980-01-01 $time2");else $time2=0;
   
    if ($time2 < $time1) {
        $time2 += 86400;
    }
    $diff=date("H:i", strtotime("1980-01-01 00:00:00") + ($time2 - $time1));
	//echo $diff;
	//die();
    return $diff;
}
   function checkHoliday($holiday){
	    $sql="SELECT * FROM holiday_list_master WHERE hdate = '$holiday' ";	 
        $query=$this->db->query($sql);	
         $value=$query->result_array();
		 if(count($value)==0){$flag="false";}else{$flag="true";} 
		 return $flag;		 
   }

   
   //get all attendance with all its total P,AB,OD,CL,PL Count
   function getAllTotalAttendance($data){
	   // print_r($data);
			  
		$time=strtotime($data['attend_date']);
		$d = date_parse_from_format("Y-m-d", $data['attend_date']);
//echo $d["month"];
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($data['attend_date']));
		if(!empty($data['emp_school'])){
			$sub1="e.emp_school='".$data['emp_school']."' AND";
		if(!empty($data['department'])){
			$sub1.=" e.department='".$data['department']."'AND ";
		}
		}
		//  SUM(CASE WHEN p.status NOT LIKE 'abscent' THEN 1 ELSE 0 END) AS total_present, 
		// SUM(CASE WHEN p.status  LIKE 'present' THEN 1 ELSE 0 END) AS total_present,
	  $sql="SELECT distinct p.UserId,
            SUM(CASE WHEN p.status  Not In('abscent','leave','outduty') THEN 1 ELSE 0 END) AS total_present, 
            SUM(CASE WHEN p.status LIKE 'outduty' THEN 1 ELSE 0 END) AS total_outduty,				
            e.emp_id,e.fname,e.lname,c.college_id,c.college_name,d.department_id,d.department_name			
            FROM punching_backup as p 
			left join employee_master as e on e.emp_id=p.UserId
            left join college_master as c on c.college_id=e.emp_school
			left join department_master as d on d.department_id=e.department
			where $sub1 month(p.updated_date)='$msearch' AND year(p.updated_date)='$ysearch'
			group by p.UserId ORDER BY `c`.`college_id` ASC";
			//echo $sql;
	   $query=$this->db->query($sql);
	   $value=$query->result_array();
	     return $value;
   }
   function getremainingAllLeaveCountByEmp($id,$dt){
	  	  $emp=$id;		  
		$d = date_parse_from_format("Y-m-d",$dt);
        $msearch=$d["month"];
		$ysearch=$d["year"];
		  //echo $emp;
		  $sql2="SELECT 
SUM(CASE WHEN l.leave_type='1' THEN 1 ELSE 0 END) AS total_CL,
SUM(CASE WHEN l.leave_type='2' THEN 1 ELSE 0 END) AS total_ML,
SUM(CASE WHEN l.leave_type='3' THEN 1 ELSE 0 END) AS total_EL,
SUM(CASE WHEN l.leave_type='4' THEN 1 ELSE 0 END) AS total_Coff,
SUM(CASE WHEN l.leave_type='5' THEN 1 ELSE 0 END) AS total_SL,
SUM(CASE WHEN l.leave_type='6' THEN 1 ELSE 0 END) AS total_VL,
SUM(CASE WHEN l.leave_type='7' THEN 1 ELSE 0 END) AS total_leave,
SUM(CASE WHEN l.leave_type='9' THEN 1 ELSE 0 END) AS total_LWP,
SUM(CASE WHEN l.leave_type='11' THEN 1 ELSE 0 END) AS total_STL

from leave_applicant_list as l where l.status='Approved' AND month(applied_from_date)='$msearch' and year(applied_from_date)='$ysearch' and l.emp_id='$emp' group by l.emp_id";
/* echo $sql2;
exit; */
$query2=$this->db->query($sql2);
	   $value2=$query2->result_array();
	   /*  */
	  return $value2[0];
   }
   
   function check_monthly_attendance($dt,$userid){	   
		$d = date_parse_from_format("Y-m-d", $dt);
        $msearch=$d["month"];
        $ysearch=$d["year"];
		$sql1="select * from employee_monthly_final_attendance where month(for_month_year)='$msearch' and year(for_month_year)='$ysearch' and UserId='$userid'";
		// echo $sql1;
		//die(); 
		$query1=$this->db->query($sql1);
		$res1=$query1->result_array();
		if(empty($res1)){
			return 'not';//not already available employee monthly salary
		}elseif(!empty($res1)){
			return 'available';	//already available	employee monthly salary	
		}
   }
   
  function add_update_final_monthly_attendance($data,$dt){
	  $d = date_parse_from_format("Y-m-d", $dt);
        $msearch=$d["month"];
        $ysearch=$d["year"];
	  // add first monthly generated attendance in table for monthly attendance....
				/*First check Monthly attendance already available in table or not for searched date & month/year*/
           for($i=0;$i<count($data);$i++){
			$total_final_workday=0;
	   $data1[$i]['UserId']=$data[$i]['UserId'];
	   $data1[$i]['ename']=$data[$i]['fname'].' '.$data[$i]['lname'];
	   $data1[$i]['month_days']=$data[$i]['month_days'];
	   $data1[$i]['working_days']=$data[$i]['working_days'];
	   $data1[$i]['sunday']=$data[$i]['sunday'];
	   $data1[$i]['holiday']=$data[$i]['holiday'];
	   $data1[$i]['total_present']=$data[$i]['total_present'];
	   $data1[$i]['total_outduty']=$data[$i]['total_outduty'];
	   $data1[$i]['CL']=$data[$i]['total_CL'];
	   $data1[$i]['ML']=$data[$i]['total_ML'];
	   $data1[$i]['EL']=$data[$i]['total_EL'];
	   $data1[$i]['C-Off']=$data[$i]['total_Coff'];
	   $data1[$i]['SL']=$data[$i]['total_SL'];
	   $data1[$i]['VL']=$data[$i]['total_VL'];
	   $data1[$i]['Leaves']=$data[$i]['total_leave'];
	   $data1[$i]['LWP']=$data[$i]['total_LWP'];
	   $data1[$i]['STL']=$data[$i]['total_STL'];
	   $total_final_workday=($data[$i]['total_present']+$data[$i]['total_outduty']+
                      $data[$i]['total_CL']+$data[$i]['total_ML']+$data[$i]['total_EL']
					  +$data[$i]['total_Coff']+$data[$i]['total_SL']+$data[$i]['total_VL']
					  +$data[$i]['total_leave']+$data[$i]['total_STL']+$data[$i]['total_LWP']);
	   $data1[$i]['Total']=	$total_final_workday;
       $data1[$i]['for_month_year']=$ysearch.'-'.$msearch.'-'."28";
       $data1[$i]['inserted_by']=$this->session->userdata("uid");
       $data1[$i]['inserted_date']=date('Y-m-d h:m:i');	
	   
	      $check1=$this->check_monthly_attendance($dt, $data1[$i]['UserId']);
		  if($check1=='not'){ //not already available employee monthly salary
					 
					//data not already available so insert into table
					$add_month[$i]=$this->Add_final_monthly_attendance($data1[$i],$dt);
		  }elseif($check1=='available'){					
					//data already available then update it from table
				$update_month[$i]=$this->Update_final_monthly_attendance($data1[$i],$dt);	
					
				}
			   
		   }
       if(!empty($update_month)|| !empty($add_month)){
		   return true;
	   }		   
  }   
   
   function Add_final_monthly_attendance($data,$dt){
	    
		 $inserted=$this->db->insert('employee_monthly_final_attendance',$data);   
	  // echo $this->db->last_query;
	 if(!empty($inserted)&& $inserted!=0){
		  return $inserted;		 
	 }	   
   }
   function Update_final_monthly_attendance($data,$dt){
	   $d = date_parse_from_format("Y-m-d", $dt);
        $msearch=$d["month"];
        $ysearch=$d["year"];
	             $this->db->where('UserId',$data['UserId']);
				 $this->db->where('month(for_month_year)',$msearch);
				 $this->db->where('year(for_month_year)',$ysearch);
	    $updated=$this->db->update('employee_monthly_final_attendance',$data); 
		// echo $this->db->last_query;
	   if(!empty($updated)&& $updated!=0){
		  return updated;		 
	 }	 
   }
   
   function fetch_employee_monthly($dt){
	 $d = date_parse_from_format("Y-m-d", $dt);
        $msearch=$d["month"];
        $ysearch=$d["year"];
		$sql1="select * from employee_monthly_final_attendance where month(for_month_year)='$msearch' and year(for_month_year)='$ysearch'";
		/* echo $sql1;
		die(); */
		$query1=$this->db->query($sql1);
		$res1=$query1->result_array();
        return $res1;		
   }
   
   function getSchoolDepartmentWiseEmployeeList($sid,$did){
	 $this->db->select('e.emp_id,e.fname,e.mname,e.lname');
     $this->db->from('employee_master as e');
	 $this->db->where('e.emp_school',$sid);
	 $this->db->where('e.department',$did);
	 $this->db->where('e.emp_status','Y');
	 $query=$this->db->get();
	 $res=$query->result_array();
	 return $res;	 
	   
   }
   function getEmployeeListForLeaveAllocation($sid,$did){
	 $this->db->select('e.emp_id,e.fname,e.mname,e.lname');
     $this->db->from('employee_master as e');
	 $this->db->where('e.emp_school',$sid);
	 $this->db->where('e.department',$did);
	 $this->db->where('e.leave_allocation','N');
	 $query=$this->db->get();
	// echo $this->db->last_query();
	 $res=$query->result_array();
	 return $res;	 
	   
   }
   function get_Marked_Emp_Manual($sid,$did){
	  $this->db->select('e.emp_id,e.fname,e.mname,e.lname');
     $this->db->from('employee_master as e');
	 if(!empty($sid)){
     $this->db->where('e.emp_school',$sid); 
	 }
	 if(!empty($did)){
	 $this->db->where('e.department',$did);	 
	 }	
	 $this->db->where('e.manual_attendance_flag','Y');
	 $query=$this->db->get();
	//echo $this->db->last_query();
	 $res=$query->result_array();
	 return $res; 
   }
   function checkDateForLeaveOfEmployee($dt,$emp_id){
	      $sql="SELECT l.ltype FROM leave_applicant_list as la
		   left join leave_master as l on l.leave_id=la.leave_type           
		   WHERE applied_from_date<='$dt' AND applied_to_date>='$dt' AND emp_id='$emp_id'";
		   $query=$this->db->query($sql);
		   $val=$query->result_array();
		    return $val[0]['ltype'];
   }
   
   //get  all school 
   function getAllDistinctSchool(){
	 //  $sql="select DISTINCT e.emp_school from employee_master as e order_by e.emp_school asc";
	   $sql="select DISTINCT e.emp_school from employee_master as e ORDER BY `e`.`emp_school` ASC";
	   $query=$this->db->query($sql);
	   $res=$query->result_array();
	   return $res;
   }
    //get all employee under school
   function getEmpForAllSchool($sch,$dt){
	   $school_wise=array();
	   $sql="SELECT DISTINCT e.emp_id ,e.fname,e.mname,e.lname,d.designation_name,dept.department_name,sc.college_name FROM `employee_master` as e
                LEFT JOIN `designation_master` as `d` ON `d`.`designation_id` = `e`.`designation`
		        LEFT JOIN `department_master` as `dept` ON `dept`.`department_id` = `e`.`department`
		        LEFT JOIN `college_master` as `sc` ON `sc`.`college_id` = `e`.`emp_school`
				where e.emp_school='".$sch."'";
				//echo $sql;				
		$query = $this->db->query($sql);
		return $query->result_array(); 
		
   }
   //get attendance of all employee
   function getAttendanceForAllSchool($emp,$dt){
	       $monthly=array();
		  $d = date_parse_from_format("Y-m-d",$dt);
      
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($dt));
		$fetch_monthly="SELECT `e`.`fname`,`e`.`mname` ,`e`.`lname`,d.designation_name,dept.department_name,sc.college_name, p.* from punching_backup as p
        LEFT JOIN `employee_master` as `e` ON `e`.`emp_id` = `p`.`UserId`
		LEFT JOIN `designation_master` as `d` ON `d`.`designation_id` = `e`.`designation`
		LEFT JOIN `department_master` as `dept` ON `dept`.`department_id` = `e`.`department`
		LEFT JOIN `college_master` as `sc` ON `sc`.`college_id` = `e`.`emp_school`
		WHERE 
		month(p.Intime) ='$msearch'  AND
		year(p.Intime) = '$ysearch' and
		p.UserId='".$emp."'
		ORDER BY `p`.`Intime` ";
	    $query1=$this->db->query($fetch_monthly);
		
	return $query1->result_array();
   }
   //get employee under perticular school
   function getAllEmployeeUnderSchool($sch,$dt){
	   $monthly=array();
		  $d = date_parse_from_format("Y-m-d",$dt);
      
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($dt));
		$fetch_monthly="SELECT DISTINCT e.emp_id ,e.fname,e.mname,e.lname,d.designation_name,dept.department_name,sc.college_name FROM `employee_master` as e
                LEFT JOIN `designation_master` as `d` ON `d`.`designation_id` = `e`.`designation`
		        LEFT JOIN `department_master` as `dept` ON `dept`.`department_id` = `e`.`department`
		        LEFT JOIN `college_master` as `sc` ON `sc`.`college_id` = `e`.`emp_school`
				where e.emp_school='".$sch."' ORDER BY `e`.`emp_id` ASC";
		/*  echo $fetch_monthly;
		die();  */
	    $query1=$this->db->query($fetch_monthly);
		
	  return $query1->result_array();
	   
	   
   }
   
   function mark_Employee_manually($data){
	   if(!empty($data['ch'])){
	   for($i=0;$i<count($data['ch']);$i++){
		   $this->db->where('emp_id',$data['ch'][$i]);
		   $this->db->set('manual_attendance_flag','Y');
		$updated[$i]=$this->db->update('employee_master');
/* echo $this->db->last_query();
exit; */		   
	   }
	   $str=implode(',',$data['ch']);
	   //echo $str;
	   $sql1="select emp_id from employee_master where emp_id not in($str)";
	  /*  echo $sql1;
	   exit; */
	   $query1=$this->db->query($sql1);
	   $res1=$query1->result_array();
	  /*  print_r($res1);
	   exit; */
	   for($i=0;$i<count($res1);$i++){
		$this->db->where('emp_id',$res1[$i]['emp_id']);
        $this->db->set('manual_attendance_flag','N');
        $updated1[$i]=$this->db->update('employee_master');	
/* echo $this->db->last_query();
exit;	 */	
	   }
	   if(!empty($updated) && !empty($updated1))
		   return true;
	   
	   } 
   }
   
   /*Staff Leaves*/
   function fetchAllEmpLeaves(){
	   $this->db->select('e.emp_id,e.fname,e.lname,s.college_name,ds.designation_name,de.department_name,lv.*');
	   $this->db->from('employee_master as e');
	   $this->db->join('college_master as s','s.college_id = e.emp_school','left');
		$this->db->join('designation_master as ds','ds.designation_id = e.designation','left');
		$this->db->join('department_master as de','de.department_id = e.department','left');
	   $this->db->join('employee_leave_track as lv','lv.emp_id=e.emp_id','right');
	   $query=$this->db->get();
	   $res=$query->result_array();
	   return $res;
   }
   
   function allocateStaffLeave($data){
	   /*for leave allocation of Employee*/
	  /* print_r($data);
			 exit; 	 */		 
		$leave['emp_id']=(stripcslashes($data['employee']));
		$leave['dt_join']=(stripcslashes(date('Y-m-d',strtotime($data['joiningDate']))));
		$leave['school_id']=(stripcslashes($data['emp_school'])); 
		$leave['department_id']=(stripcslashes($data['department'])); 
		$leave['vslot1']=(stripcslashes($data['vslot1'])); // for Slot I vacation
		$leave['vslot2']=(stripcslashes($data['vslot2'])); // for Slot II vacation
		$leave['vslot3']=(stripcslashes($data['vslot3'])); // for Slot III vacation
		$leave['vslot4']=(stripcslashes($data['vslot4'])); // for Slot IV vacation
		$leave['cnt_cl']=(stripcslashes($data['cnt_cl']));//for CL
		$leave['cnt_coff']=(stripcslashes($data['cnt_coff'])); //for C-OFF
		$leave['cnt_el']=(stripcslashes($data['cnt_el'])); //for EL
		$leave['cnt_ml']=(stripcslashes($data['cnt_ml'])); //for ML
		$leave['cnt_vl']=(stripcslashes($data['cnt_vl'])); //for MTL
		$leave['cnt_sl']=(stripcslashes($data['cnt_sl'])); //for SL
		$leave['cnt_leave']=(stripcslashes($data['cnt_leave'])); //for Leave
		$leave['cnt_lwp']=(stripcslashes($data['cnt_lwp'])); //for LWP
		$leave['cnt_stl']=(stripcslashes($data['cnt_stl'])); //for STL
		$leave['inserted_by']=$this->session->userdata("uid");
		$leave['inserted_date']=date("Y-m-d H:i:s");
		/****Third Part for Leave**///
		$insert_id2 =$this->db->insert('employee_leave_track',$leave);
		$fetch_id22=$this->db->insert_id();
		if(!empty($fetch_id22)&& $fetch_id22!==0){
			$sql="update employee_master set leave_allocation='Y' where emp_id='".$leave['emp_id']."'";
			$query=$this->db->query($sql);
			return true;
			
		}		
        /*end for LEAVE*/
   }
   function update_allocated_StaffLeave($data){
	   //$leave['emp_id']=(stripcslashes($data['employee']));
		$leave['dt_join']=(stripcslashes(date('Y-m-d',strtotime($data['joiningDate']))));
		$leave['school_id']=(stripcslashes($data['emp_school'])); 
		$leave['department_id']=(stripcslashes($data['department'])); 
		$leave['vslot1']=(stripcslashes($data['vslot1'])); // for Slot I vacation
		$leave['vslot2']=(stripcslashes($data['vslot2'])); // for Slot II vacation
		$leave['vslot3']=(stripcslashes($data['vslot3'])); // for Slot III vacation
		$leave['vslot4']=(stripcslashes($data['vslot4'])); // for Slot IV vacation
		$leave['cnt_cl']=(stripcslashes($data['cnt_cl']));//for CL
		$leave['cnt_coff']=(stripcslashes($data['cnt_coff'])); //for C-OFF
		$leave['cnt_el']=(stripcslashes($data['cnt_el'])); //for EL
		$leave['cnt_ml']=(stripcslashes($data['cnt_ml'])); //for ML
		$leave['cnt_vl']=(stripcslashes($data['cnt_vl'])); //for MTL
		$leave['cnt_sl']=(stripcslashes($data['cnt_sl'])); //for SL
		$leave['cnt_leave']=(stripcslashes($data['cnt_leave'])); //for Leave
		$leave['cnt_lwp']=(stripcslashes($data['cnt_lwp'])); //for LWP
        $leave['cnt_stl']=(stripcslashes($data['cnt_stl'])); //for STL		
	    $leave['updated_by']=$this->session->userdata("uid");
		//for leave allocation of employee
			$this->db->where('emp_id',$data['employee']);
		 $res3=$this->db->update('employee_leave_track',$leave);
		 /* echo $this->db->last_query();
		 exit; */
		 if(!empty($res3)&& $res3!==0){
			return true;			
		}	
   }
   
   function getEmpleave_track($id){
	   $this->db->select('*');
	   $this->db->where('el_id',$id);
	   $this->db->from('employee_leave_track');
	   $query=$this->db->get();
	   $res=$query->result_array();
	   return $res;	   
   }
   function getEmpJoiningdt($id){
	  // echo $id;
	   $this->db->select('joiningDate');
	   $this->db->where('emp_id',$id);
	   $this->db->from('employee_master');
	  $query=$this->db->get();	 
	  $res=$query->result_array();	  
	   return $res[0]['joiningDate'];
   }
   function checkpunchingBackup_for_manualattend($dt){
	   $d = date_parse_from_format("Y-m-d",$dt);      
        $msearch=$d["month"];
        $ysearch=$d["year"];
		
		$sql1="select * from punching_backup where month(intime)='$msearch' and year(intime)='$ysearch' or month(outtime)='$msearch' and year(outtime)='$ysearch' ";
	//echo $sql1;		
		$query=$this->db->query($sql1);
		$res=$query->result_array();
		
		if(!empty($res)){
			return true;
		}elseif(empty($res)){
			return false;
		}	
   }
   
  function get_Marked_Emp_attendance($id,$dt){
	   $d = date_parse_from_format("Y-m-d",$dt);      
        $msearch=$d["month"];
        $ysearch=$d["year"];
		$chk="select * from employee_monthly_final_attendance where UserId='".$id."' and month(for_month_year)='$msearch' and year(for_month_year)='$ysearch'";
	$query=$this->db->query($chk);
	   $res=$query->result_array();
	   return $res;
   }

  function add_upd_Emp_Manual_Attendance($data,$dt){
	 
	   $d = date_parse_from_format("Y-m-d",$dt);      
        $msearch=$d["month"];
        $ysearch=$d["year"];
		//echo count($data);//exit;
for($i=0;$i<count($data);$i++){
	//first check the employee
	$chk="select * from employee_monthly_final_attendance where UserId='".$data[$i]['eid']."' and 
	month(for_month_year)='".$msearch."' and year(for_month_year)='".$ysearch."'";
	//echo $chk;
	//exit;
	$query=$this->db->query($chk);
	   $res=$query->result_array();
	   
	   if(empty($res)&&!empty($data[$i]['eid'])){
		//   echo"in insert";
		 //  exit;
			 $sql1="select fname,lname from employee_master where emp_id='".$data[$i]['eid']."'";
	   $query1=$this->db->query($sql1);
	   $res1=$query1->result_array();
	   $name=$res1[0]['fname'].' '.$res1[0]['lname'];
	   $data['ename']=$name;
	   $data['for_month_year']=$data['for_month_year'].'-30';
         /* print_r($data);
	   exit;  */
	   $data1['UserId']=$data[$i]['eid'];
	   $data1['ename']=$data[$i]['ename'];
	   $data1['month_days']=$data[$i]['month_days'];
	   $data1['working_days']=$data[$i]['working_days'];
	   $data1['total_present']=$data[$i]['present_days'];
	   $data1['sunday']=$data[$i]['sunday'];
	   $data1['holiday']=$data[$i]['holiday'];
	   $data1['total_outduty']=$data[$i]['total_outduty'];
	   $data1['CL']=$data[$i]['CL'];
	   $data1['ML']=$data[$i]['ML'];
	   $data1['EL']=$data[$i]['EL'];
	   $data1['C-Off']=$data[$i]['C-Off'];
	   $data1['SL']=$data[$i]['SL'];
	   $data1['VL']=$data[$i]['VL'];
	   $data1['Leaves']=$data[$i]['Leaves'];
	   $data1['LWP']=$data[$i]['LWP'];
	   $data1['STL']=$data[$i]['STL'];
	   /* $total_final_workday=($data[$i]['total_present']+$data[$i]['total_outduty']+
                      $data[$i]['CL']+$data[$i]['ML']+$data[$i]['EL']
					  +$data[$i]['C-Off']+$data[$i]['SL']+$data[$i]['VL']
					  +$data[$i]['Leaves']+$data[$i]['LWP']+$data[$i]['STL']);
	   
	   $data1['Total']=$total_final_workday; */
	   $data1['Total']=$data[$i]['Total'];
	   if($msearch<=9){
		   $msearch='0'.$msearch;
	   }
       $data1['for_month_year']=$ysearch.'-'.$msearch.'-'."28";
	 /*  echo"<pre>";  print_r($data1);
			exit; */
	   $data1['inserted_by']=$this->session->userdata("uid");
	   $data1['inserted_date']=date('Y-m-d h:m:i');
	   
          $ins[$i]=$this->db->insert('employee_monthly_final_attendance',$data1);   
	   }elseif(!empty($res)){
		 /* echo"in update";
		 exit; */
			 $sql1="select fname,lname from employee_master where emp_id='".$data['eid']."'";
	   $query1=$this->db->query($sql1);
	   $res1=$query1->result_array();
	   $name=$res1[0]['fname'].' '.$res1[0]['lname'];
	   $data['ename']=$name;
	   $data['for_month_year']=$data['for_month_year'].'-30';
         /* print_r($data);
	   exit;  */
	   $data1['UserId']=$data['eid'];
	   $data1['ename']=$data['ename'];
	   $data1['month_days']=$data['month_days'];
	   $data1['working_days']=$data['working_days'];
	   $data1['total_present']=$data['total_present'];
	   $data1['sunday']=$data['sunday'];
	   $data1['holiday']=$data['holiday'];
	   $data1['total_outduty']=$data['total_outduty'];
	   $data1['CL']=$data['CL'];
	   $data1['ML']=$data['ML'];
	   $data1['EL']=$data['EL'];
	   $data1['C-Off']=$data['C-Off'];
	   $data1['SL']=$data['SL'];
	   $data1['VL']=$data['VL'];
	   $data1['Leaves']=$data['Leaves'];
	   $data1['LWP']=$data['LWP'];
	   $data1['STL']=$data['STL'];
	   $total_final_workday=($data['total_present']+$data['total_outduty']+
                      $data['CL']+$data['ML']+$data['EL']
					  +$data['C-Off']+$data['SL']+$data['VL']
					  +$data['Leaves']+$data['LWP']+$data['STL']);
	   
	   $data1['Total']=$total_final_workday;
	   $data1['for_month_year']=$data['for_month_year'];
	   $data1['updated_by']=$this->session->userdata("uid");
	      $this->db->where('UserId',$data1['UserId']);
          $updated[$i]=$this->db->update('employee_monthly_final_attendance',$data1);   
	 }  	   
}
//exit;	  
if(!empty($ins)|| !empty($updated)){
		   return true;
		   } 
	  	   
   }
public function employee_search($data){
	 $sql="select * from employee_master as em inner join employe_other_details as eod on em.emp_id = eod.emp_id 
	 inner join designation_master as dm on dm.designation_id = em.designation
inner join department_master as dpm on dpm.department_id = em.department
inner join college_master as cm on cm.college_id = em.reporting_school
inner join employee_category as ec on ec.emp_cat_id = em.staff_type	
inner join employee_document_master as edm on edm.emp_id = em.emp_id	 
	 where em.".$data['stype']." like '".$data['serch_val']."%'";	
	
	 $query=$this->db->query($sql);
	return  $res=$query->result_array();
   }
}