<?php
class Admin_model extends CI_Model 
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
    function getcategorylist(){
		$sql="select caste_code,caste_name from caste_master where status='y'";
		$query=$this->db->query($sql);
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
	
	 function loadempschool($emp_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT v.school_code,f.department,erp_mapp_school_id from vw_faculty f 
		LEFT JOIN sandipun_erp.employee_master e  ON e.emp_id=f.emp_id
		INNER JOIN school_master c  ON c.erp_mapp_school_id=f.emp_school
		LEFT JOIN vw_stream_details v ON v.school_id=c.school_id where f.emp_id='$emp_id' group by v.school_code
		";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
 }
	
	function getAllschool(){
	$role_id = $this->session->userdata('role_id');
	$emp_id = $this->session->userdata("name");	
	
	$sql="select college_id,campus_id,college_code,college_name,college_city from college_master where status='Y'";
	
	if(isset($role_id) && ($role_id==20 || $role_id==44))
	{
         $empsch = $this->loadempschool($emp_id);
		 //print_r($empsch);
		 //exit;
		 $schid= $empsch[0]['erp_mapp_school_id'];
		 $sql .=" AND college_id = $schid ";
	}
//echo $sql;
//exit;
     $query=$this->db->query($sql);
	 return $query->result_array();
	 	 
	 
	}
	function getdepartmentByschool($id){
	$sql="select department_id,department_name from department_master where school_college_id='$id' and status='Y'";
     $query=$this->db->query($sql);
	 return $query->result_array();
	}
	function getshifttime($id){
	$sql="select shift_start_time,shift_end_time,shift_name from shift_master where shift_id='$id' and  status='Y'";
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
	function getAllEmpCategoryById($id){
		$sql="SELECT emp_cat_id,emp_cat_name  FROM employee_category WHERE status='Y' and emp_cat_id = $id";
        $query = $this->db->query($sql);
        return $query->result_array();
	}
	function getOrganizationById($id){
	$sql="SELECT organisation_id,org_name FROM organization_master WHERE organisation_id='$id' and status='Y'";
        $query = $this->db->query($sql);
        return $query->result_array();	
	}
	function getSchoolById($id){
		$sql="select college_id,college_name,college_code from college_master where college_id='$id' and status='Y'";
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
	
	function getEmployees($limit=0, $id=0,$status=''){
		$role_id = $this->session->userdata('role_id');
	    $emp_id = $this->session->userdata("name");	
		
		$this->db->select("e.*,ot.mobileNumber,d.profile_pic");
		$this->db->from('employee_master as e');
		$this->db->join('employe_other_details as ot','ot.emp_id = e.emp_id','left');
		$this->db->join('employee_document_master as d','d.emp_id = e.emp_id','left');
		//$this->db->where('e.emp_reg','N');
		
		if(!empty($status)){
				if($status=="NY")
				{
				$this->db->where('e.emp_reg','N'); 
				}
				else{
				$this->db->where('e.emp_status',$status);
				$this->db->where('e.emp_reg',$status);
				}
		}
		else{
		$this->db->where('e.emp_status','Y');
		}
		
		$or_where='or e.emp_id iN (select COALESCE(access_emp_id,0) as emp_id from attendance_access where emp_id='.$emp_id.')';
		
		
		if(isset($role_id) && ($role_id==20 || $role_id==44))
	{
         $empsch = $this->loadempschool($emp_id);
		 //print_r($empsch);
		 //exit;
		 $schid= $empsch[0]['erp_mapp_school_id'];
		 $this->db->where("(e.emp_school=$schid $or_where)");
		 
		 //'e.emp_school',$schid
		// $sql .=" AND college_id = $schid ";
	}
	
		if(isset($role_id) && ($role_id==3 ))
		{
			
			//print_r($_SESSION);
			//exit;
        // $this->db->where('e.emp_id',$emp_id);
          $this->db->where("(e.emp_id=$emp_id $or_where)");		
		}
	
	
	    //$this->db->where("(1=1 $or_where)"); 
	
		$this->db->order_by("e.emp_id", "asc");	 
		$this->db->group_by("e.emp_id");	 
		
		$query=$this->db->get();
		//	echo $this->db->last_query();
		//exit;	
        return $query->result_array();
	}
	
		public function changemultiEmpStatus($empsid, $flg)
		{
		if (!empty($empsid) && !empty($flg)) {
		$statusUpdate = ($flg == "D") ? 'N' : (($flg == "E") ? 'Y' : null);
		$isDisabled = ($flg == "D") ? 'Y' : (($flg == "E") ? 'N' : null);

		foreach ($empsid as $emp_id) {
		if ($isDisabled !== null) {
		$this->db->set('is_disabled', $isDisabled);
		} else {
		$this->db->set('emp_status', $flg);
		}
		$this->db->where('emp_id', $emp_id);
		$this->db->update('employee_master');

		if ($statusUpdate !== null) {
		$this->db->set('status', $statusUpdate);
		$this->db->where('username', $emp_id);
		$this->db->update('user_master');
		}
		}
		}
		return ($this->db->affected_rows() != 1) ? false : true;
		}


	
	function getEmployeesManual(){
		$this->db->select("e.*,ot.mobileNumber,d.profile_pic");
		$this->db->from('employee_master as e');
		$this->db->join('employe_other_details as ot','ot.emp_id = e.emp_id','left');
		$this->db->join('employee_document_master as d','d.emp_id = e.emp_id','left');
		$this->db->where('e.emp_reg','N');
		$this->db->order_by("e.emp_id", "asc");	 
		
		$query=$this->db->get();
				
        return $query->result_array();
	}
	
function getEmployees1_old($st){
		$this->db->select("e.*,ot.*,ot.mobileNumber,d.profile_pic");
		$this->db->from('employee_master as e');
		$this->db->join('employe_other_details as ot','e.emp_id = ot.emp_id','left');
		$this->db->join('employee_document_master as d','e.emp_id = d.emp_id','left');
		$this->db->where('e.emp_status',$st);
		$this->db->where('e.emp_reg','N');
		//$this->db->where('e.emp_id','110523');
		$this->db->order_by("e.emp_id", "asc");	 
		$this->db->group_by("e.emp_id");	 
		$query=$this->db->get();
			//echo $this->db->last_query();
//exit;			
        return $query->result_array();
	}
	function getEmployees3($st){
		$uid=$this->session->userdata("uid");
		$role_id=$this->session->userdata("role_id");
		$name=$this->session->userdata("name");
		$this->db->select("e.*,ot.*,ot.mobileNumber,d.profile_pic");
		$this->db->from('employee_master as e');
		$this->db->join('employe_other_details as ot','e.emp_id = ot.emp_id','left');
		$this->db->join('employee_document_master as d','e.emp_id = d.emp_id','left');
		$this->db->where('e.emp_status',$st);
		if($name !='110002'){
			$this->db->where('e.emp_id',$name);
		}
		$this->db->where('e.emp_reg','N');
		$this->db->order_by("e.emp_id", "asc");	 
		$this->db->group_by("e.emp_id");	 
		$query=$this->db->get();
				
        return $query->result_array();
	}
	//this function will return All Active/Inactive/Resigned Employees // updated by kishor on 21st june,2019
	function getEmployees2(){
		$this->db->select("e.*,ot.*,ot.mobileNumber,d.profile_pic");
		$this->db->from('employee_master as e');
		$this->db->join('employe_other_details as ot','e.emp_id=ot.emp_id ','left');
		$this->db->join('employee_document_master as d','e.emp_id=d.emp_id','left');
		//$this->db->where('e.emp_status',$st);
		//$this->db->where('e.emp_reg','N');
		$this->db->order_by("e.emp_id", "asc");	 
		
		$query=$this->db->get();
				//echo $this->db->last_query();
        return $query->result_array();
	}
	function getRegEmployees_old(){
		$this->db->select("e.*,ot.*,d.profile_pic,er.resign_date");
		$this->db->from('employee_master as e');
		$this->db->join('employe_other_details as ot','ot.emp_id = e.emp_id','left');
		$this->db->join('employee_document_master as d','d.emp_id = e.emp_id','left');
		$this->db->join('employee_resignation as er','er.emp_id = e.emp_id','left');
		$this->db->where('e.emp_reg','Y');
		$this->db->order_by("e.emp_id", "asc");	 
		
		$query=$this->db->get();
				
        return $query->result_array();
	}
	function getEmployeesexp1($st){
		$this->db->select("e.*,ot.*,ot.mobileNumber,d.profile_pic,es.pay_band_min as pay_band_min1,es.pay_band_max as pay_band_max1,es.pay_band_gt as pay_band_gt1");
		$this->db->from('employee_master as e');
		$this->db->join('employe_other_details as ot','ot.emp_id = e.emp_id','left');
		$this->db->join('employee_document_master as d','d.emp_id = e.emp_id','left');
		$this->db->join('employee_salary_structure as es','es.emp_id = e.emp_id','left');
		$this->db->where('e.emp_status',$st);
		$this->db->where('e.emp_reg','N');
		$this->db->where('es.active_status','Y');
		$this->db->order_by("e.emp_id", "asc");	 
		
		$query=$this->db->get();
				//echo $this->db->last_query();
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
	
	
	function getEmployeeById($id,$flg=''){
		$this->db->select("e.*,e.joiningDate as jd,e.emp_id as eid,e.referenceID as rid,ot.*,d.*,st.emp_cat_name,s.college_name,ds.designation_name,de.department_name,sh.shift_name,bk.bank_name,em.gross_salary,bk.bank_id,em.special_allowance,lv.*,sal.*");
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
		$this->db->join('employee_salary_structure as em','em.emp_id = e.emp_id','left');
		
		
		$this->db->where('e.emp_id',$id);
		if(!empty($flg)){
		$this->db->where('e.emp_status',$flg);
	}
	
	
		$query=$this->db->get();
		
		
		
		
		  //echo $this->db->last_query();
		//die();   
		$result=$query->result_array();
		return $result;
	}
	function getEmployeeById1($id){
		$this->db->select("e.*,e.joiningDate as jd,e.emp_id as eid,e.referenceID as rid,ot.*,d.*,s.college_name,ds.designation_name,de.department_name");
		$this->db->from('employee_master as e');
		$this->db->join('employe_other_details as ot','ot.emp_id = e.emp_id','left');
		$this->db->join('employee_document_master as d','d.emp_id = e.emp_id','left');
		//$this->db->join('employee_category as st','st.emp_cat_id = e.staff_type','left');
		$this->db->join('college_master as s','s.college_id = e.emp_school','left');
		$this->db->join('designation_master as ds','ds.designation_id = e.designation','left');
		$this->db->join('department_master as de','de.department_id = e.department','left');
		//$this->db->join('shift_master as sh','sh.shift_id = e.shift','left');
		//$this->db->join('bank_master as bk','bk.bank_id = ot.bank_name','left');
		//$this->db->join('employee_leave_track as lv','lv.emp_id = e.emp_id','left');
		//$this->db->join('employee_basic_salary_details as sal','sal.emp_id = e.emp_id','left');
		$this->db->where('e.emp_id',$id);
		//$this->db->where('e.emp_status',$flg);
		$query=$this->db->get();
		//  echo $this->db->last_query();
	//	die();   
		$result=$query->result_array();
		return $result;
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
	    //$this->db->update('user_master');
		  /* echo $this->db->last_query();
		die();   */ 
	    return ($this->db->affected_rows() != 1) ? false : true;
		
	}
 function disableEmployeeStatus($id,$flg){
	 $this->db->where('emp_id',$id);
		if($flg=='Y'){
			$this->db->set('is_disabled','N');
		  }else{
		$this->db->set('is_disabled','Y');	
		}		
	    $this->db->update('employee_master');
	    $this->db->where('username',$id);
		if($flg=='N'){
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
		$arr['break_month']=(stripcslashes($data['break_month']));
		$arr['category']=(stripcslashes($data['category']));
		$arr['cast']=(stripcslashes($data['cast']));
		$arr['sub-cast']=(stripcslashes($data['sub-cast']));
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
		$arr['gratuity_status']=(stripcslashes($data['gratuity_status']));
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
		$arr['knowledge_status'] = (stripcslashes($data['kp']));
		$arr['knowledge_code'] = (stripcslashes($data['knowplist']));
		$arr['previous_details'] = (stripcslashes($data['pre_det_f']));
		if($data['pre_det_f']=='Y'){
		$cont = count($data['joindes']);
for($i=0;$i<$cont;$i++) {
	
	$prejd['emp_id'] = (stripcslashes($data['employeeID'])); 
		$prejd['joining_date']= date('Y-m-d',strtotime($data['joind'][$i]));
		$prejd['joining_salary']= $data['joins'][$i];
		$prejd['joining_organisation']= $data['joindes'][$i];
		
	$this->db->insert('employee_previous_joining_details', $prejd);
}
}
		//contact details
		$detail['emp_id']=(stripcslashes($data['employeeID'])); 
		$detail['landline_std']=(stripcslashes($data['landline_std']));
		$detail['landline_no']=(stripcslashes($data['landline_no']));		
		$detail['mobileNumber']=(stripcslashes($data['mobileNumber']));
		$detail['alternateno']=(stripcslashes($data['alternateno']));


		
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
		$detail['ifsc_code']=(stripcslashes($data['ifsc_code']));
		$detail['inserted_by']=$this->session->userdata("uid");
		$detail['inserted_datetime']=date("Y-m-d H:i:s");
		
		
         
		
		
		//Employee Login data
		$temp['roles_id']=$data['emp_role'];
		//$temp['roles_id']= 3;
		$temp['inserted_by']=$this->session->userdata("uid");
		$temp['inserted_datetime']=date("Y-m-d H:i:s");
		//"inserted_by"=>$this->session->userdata("uid"),"inserted_datetime"=>date("Y-m-d H:i:s")
		
		//******first part****/
		$insert_id =$this->db->insert('employee_master',$arr);
		$fetch_id=$this->db->insert_id();
			$aid=$this->db->insert('user_master',$temp);
			$a_ins=$this->db->insert_id();
			
		$arr1 = array();
		$arr1['emp_id']=(stripcslashes($data['employeeID']));
		//$arr1['emp_code']=(stripcslashes($data['employeeID']));
		$arr1['week_off']=(stripcslashes($data['week_off']));
		$arr1['shift_id']=(stripcslashes($data['shift']));
		
		$time1=strtotime((stripcslashes($data['intime'])));
		$arr1['in_time']=date("H:i:s",$time1);		
		$time2=strtotime((stripcslashes($data['outtime'])));
		$arr1['out_time']=date("H:i:s",$time2);
       $arr1['active_from'] = date("Y-m-d");
       $arr1['status'] = 'Y';
		$arr1['created_by']=$this->session->userdata("uid");
		$arr1['created_on']=date("Y-m-d H:i:s");
			$insert_id2 =$this->db->insert('employee_shift_time',$arr1);
		
	//	echo $this->db->last_query();
	//	exit();
		/****Second Part**///
		$insert_id1 =$this->db->insert('employe_other_details',$detail);
		$fetch_id=$this->db->insert_id();
		//echo $this->db->last_query();	
		
		
		//scan documents of employee
		if(!empty($insert_id)&& $insert_id!=0){
			$doc['emp_tbl_reg_id']=$fetch_id;
			$doc['emp_id']=$arr['emp_id'];
			$fid=$this->db->insert('employee_document_master',$doc);
		//echo $this->db->last_query();
			//die();
			$fdid=$this->db->insert_id();
        // for employee Login
            /* print_r($temp);
exit;		 */	
}
	        
			
		$detail1 = array();
		$detail1['emp_id']= (stripcslashes($data['employeeID']));
		$detail1['scaletype']=(stripcslashes($data['scaletype']));
		$detail1['basic_sal']=(stripcslashes($data['basic_sal']));
		$detail1['allowance']=(stripcslashes($data['allowance']));
		$detail1['pay_band_min']=(stripcslashes($data['pay_band_min']));
		$detail1['pay_band_max']=(stripcslashes($data['pay_band_max']));
		$detail1['pay_band_gt']=(stripcslashes($data['pay_band_gt']));
		$detail1['other_pay']=(stripcslashes($data['other_pay']));
		$detail1['created_by']=$this->session->userdata("uid");
		$detail1['created_on']=date("Y-m-d H:i:s");
		$detail1['active_status']='Y';
		
		$aid_d=$this->db->insert('employee_salary_structure',$detail1);
			$a_ins_s = $this->db->insert_id();
		//die();

$begin = new DateTime(date('Y-m-d',strtotime($data['joiningDate'])));      
        $end = new DateTime(date('Y-m-d').' +1 day');    
$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
//print_r($daterange);
$i=1;
foreach($daterange as $date){
   $jdate = $date->format("d-m-Y");
// if($jdate == "'".date('d-m-Y',strtotime($data['joiningDate']."'"))){
// 	 $sql11="SELECT DeviceId,UserId,min(LogDate) as punch_intime,max(LogDate) as punch_outtime from punching_log where date(LogDate)='".date('Y-m-d',strtotime($jdate))."' and UserId ='".$data['employeeID']."'";
// 	$query11 = $this->db->query($sql11);
//         $res=$query11->result_array();
// 		if($res[0]['DeviceId']==''){
// 			$res[0]['DeviceId']='0';
// 		}else{
// 			$res[0]['DeviceId']=$res[0]['DeviceId'];
// 		}
// 		$pin['DeviceId'] = $res[0]['DeviceId'];
// 		$pin['UserId']= $data['employeeID'];
// 		$pin['Intime']= $res[0]['punch_intime'];
// 		$pin['Outtime'] = $res[0]['punch_outtime'];
// 		$pin['updated_date']= date("Y-m-d H:i:s");
// 		$pin['status']= 'present';
	
//          $insert_id = $this->db->insert('punching_backup',$pin);	
// 	//echo $this->db->last_query();
// }else{
		
$dt=$jdate;//$_POST['ename']
$empid=$data['employeeID'];//$_POST['email']
$ch.$i = curl_init();
    curl_setopt($ch.$i, CURLOPT_URL,"http://sandipuniversity.com/erp_cron/erp_cron_new.php?empid=".$empid."&dt=".$dt);
    curl_setopt($ch.$i, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch.$i, CURLOPT_SSL_VERIFYPEER, false);
curl_exec($ch.$i);
//exit;
curl_close($ch.$i);		
//}	
$i++;
}	

		if(!empty($fetch_id)&&!empty($fdid)&&!empty($a_ins)){
			return $fdid;
		}
		
		
	}
	function addHoliday($data){
	   /*  $s = date('d',strtotime($data['frm_date']));
		$e = date('d',strtotime($data['to_date']));
		for($i=$s; $i<=$e;$i++){
			$fd1 = date('Y-m',strtotime(stripcslashes($data['frm_date'])));
			$fd = $fd1.'-'.$i ;
				$arr['academic_year']=(stripcslashes($data['academic_year']));
		$arr['order_ref_no']=(stripcslashes($data['order_ref_no']));
		$arr['order_date']=(stripcslashes($data['order_date']));
	    $arr['hdate']= $fd; 
		$arr['to_date']=(stripcslashes($data['to_date']));
		$arr['is_relax_day']=(stripcslashes($data['rday']));
		$arr['approved_by']=(stripcslashes($data['approved_by']));
		$arr['applicable_for']=(stripcslashes($data['applicable_for']));
		$arr['occasion']=(stripcslashes($data['occasion']));
		$day= date('l', strtotime($arr['hdate']));
		$arr['hday']=($day);

		$arr['inserted_by']=$this->session->userdata("uid");
		$arr['inserted_datetime']=date("Y-m-d H:i:s");
        $insert_id = $this->db->insert('holiday_list_master',$arr);	
		
		} */

      $period = new DatePeriod(
				new DateTime($data['frm_date']),
				new DateInterval('P1D'),
				(new DateTime($data['to_date']))->modify('+1 day') // Include end date
			  );
           
			foreach ($period as $date) {
				$arr = [];
				$arr['academic_year'] = stripcslashes($data['academic_year']);
				$arr['order_ref_no'] = stripcslashes($data['order_ref_no']);
				$arr['order_date'] = stripcslashes($data['order_date']);
				$arr['hdate'] = $date->format('Y-m-d');
				$arr['to_date'] = stripcslashes($data['to_date']);
				$arr['is_relax_day'] = stripcslashes($data['rday']);
				$arr['approved_by'] = stripcslashes($data['approved_by']);
				$arr['applicable_for'] = stripcslashes($data['applicable_for']);
				$arr['occasion'] = stripcslashes($data['occasion']);
				$arr['hday'] = $date->format('l'); // Day of the week
				$arr['inserted_by'] = $this->session->userdata("uid");
				$arr['inserted_datetime'] = date("Y-m-d H:i:s");
			    $insert_id=$this->db->insert('holiday_list_master', $arr);
			}		
       if(!empty($insert_id)){
			return $insert_id;
		}	
	}
	function getHolidayListMonthWise($mnth,$yr){
		$this->db->select('*');
		$this->db->where('academic_year',$yr);
		//$this->db->where('Year(hdate)',$yr);
		$this->db->where('MONTHNAME(hdate)',$mnth);
		$this->db->where('status','Y');
		$this->db->from('holiday_list_master');
		//$this->db->group_by('order_ref_no'); 
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
	function getDayofHolidays1($hid){
		$this->db->select('hday');
		$this->db->where('hid',$hid);		
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
	  //  print_r($data);
	   // print_r($doc);exit;
	   date_default_timezone_set('Asia/Kolkata');
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
		$arr['break_month']=(stripcslashes($data['break_month']));
		
		$arr['joiningDate']=(stripcslashes(date('Y-m-d',strtotime($data['joiningDate']))));
		$arr['emp_school']=(stripcslashes($data['emp_school']));
		$arr['designation']=(stripcslashes($data['designation']));
		$arr['department']=(stripcslashes($data['department']));
		$arr['staff_grade']=(stripcslashes($data['staff_grade']));
		$arr['hiring_type']=(stripcslashes($data['hiring_type']));
		$arr['qualifiaction']=(stripcslashes($data['qualifiaction']));
		$arr['phy_status']=(stripcslashes($data['phy_status']));
		$arr['pf_status']=(stripcslashes($data['pf_status']));
		$arr['gratuity_status']=(stripcslashes($data['gratuity_status']));
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
		$arr['updated_datetime']=date("Y-m-d H:i:s");
		$arr['knowledge_status'] = (stripcslashes($data['kp']));
		$arr['knowledge_code'] = (stripcslashes($data['knowplist']));
		$arr['previous_details'] = (stripcslashes($data['pre_det_f']));
		 /* echo"<pre>";
		 print_r($arr);
		
		echo"</pre>"; 
		echo"******************************";
		die();   */ 
		
		//contact details
		//echo $data['pre_det_f'];
		if($data['pre_det_f']=='N'){
			 $sql = "Delete from employee_previous_joining_details where emp_id='".$data['employeeID']."' ";
		//exit;
		$this->db->query($sql);	
		}else{
		$cont = count($data['joindes']);
		if($cont != '0' ){
			$sql = "Delete from employee_previous_joining_details where emp_id='".$data['employeeID']."' ";
		$this->db->query($sql);	
		}
     for($i=0;$i<$cont;$i++) {
	
	    $prejd['emp_id'] = (stripcslashes($data['employeeID'])); 
		$prejd['joining_date']= date('Y-m-d',strtotime($data['joind'][$i]));
		$prejd['joining_salary']= $data['joins'][$i];
		$prejd['joining_organisation']= $data['joindes'][$i];
		
	    $this->db->insert('employee_previous_joining_details', $prejd);
            }
		 }
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
		/*********** Opened on 13-05-2020 for salary updation for admin *************************/
		$detail['basic_sal']=(stripcslashes($data['basic_sal']));
		$detail['allowance']=(stripcslashes($data['allowance']));
		$detail['pay_band_min']=(stripcslashes($data['pay_band_min']));
		$detail['pay_band_max']=(stripcslashes($data['pay_band_max']));
		$detail['pay_band_gt']=(stripcslashes($data['pay_band_gt']));
		$detail['other_pay']=(stripcslashes($data['other_pay']));
		/*******************************END*****************************************************/
		$detail['bank_acc_no']=(stripcslashes($data['bank_acc_no']));
		$detail['bank_name']=(stripcslashes($data['bank_name']));
		$detail['pf_no']=(stripcslashes($data['pf_no']));
		$detail['pan_no']=(stripcslashes($data['pan_no']));
		$detail['ifsc_code']=(stripcslashes($data['ifsc_code']));
		
	    $detail['updated_by']=$this->session->userdata("uid");
		
		/************************ Added on 18052020********************************************************/
		$detail11['scaletype']=(stripcslashes($data['scaletype']));
		$detail11['basic_sal']=(stripcslashes($data['basic_sal']));
		$detail11['allowance']=(stripcslashes($data['allowance']));
		$detail11['pay_band_min']=(stripcslashes($data['pay_band_min']));
		$detail11['pay_band_max']=(stripcslashes($data['pay_band_max']));
		$detail11['pay_band_gt']=(stripcslashes($data['pay_band_gt']));
		$detail11['other_pay']=(stripcslashes($data['other_pay']));
		$detail11['modified_by']=$this->session->userdata("uid");
		$detail11['modified_on']=date("Y-m-d H:i:s");
		/**********************************END**********************************************/
		
		//for employee table update 
	     $this->db->where('emp_id',$arr['emp_id']);
		 $res1=$this->db->update('employee_master',$arr);
	//	echo $this->db->last_query();
	//	exit;		 
		if($res1==true){
			  $this->db->where('emp_id',$arr['emp_id']);
		     $res2=$this->db->update('employe_other_details',$detail);
		    //echo $this->db->last_query();
			$sql_sal="select emp_id from employee_salary_structure where emp_id='".$arr['emp_id']."'";//exit;
			$query_sal = $this->db->query($sql_sal);
			$res_sal = $query_sal->result_array();
			if(!empty($res_sal)){
				//echo "inside";
			$this->db->where('emp_id',$arr['emp_id']);
			$res3=$this->db->update('employee_salary_structure',$detail11);
			}else{
				$detail11['emp_id']=$arr['emp_id'];
				$detail11['created_by']=$this->session->userdata("uid");
				date_default_timezone_set('Asia/Kolkata');
				$detail11['created_on']=date("Y-m-d H:i:s");
				$this->db->insert('employee_salary_structure',$detail11);
				// echo $this->db->last_query();exit;
			}
		}
		 //echo $res1;
		// print_r($doc);
		 if($res1==true){
		 	if(!empty($doc)){
		 	$sql="select emp_id from employee_document_master where emp_id='".$arr['emp_id']."'";
			$query = $this->db->query($sql);
			$res = $query->result_array();
        if(count($res)>0){
	 	 foreach($doc as $key=>$val){
				 if($val!=''){
        	 $this->db->set($key, $val);
				$this->db->where('emp_id',$arr['emp_id']);
				$res2=$this->db->update('employee_document_master'); 
				}
}
		//echo $this->db->last_query();
			//	 die();  
        }else{
			$sql1="select emp_reg_id from employee_master where emp_id='".$arr['emp_id']."'";
			$query1 = $this->db->query($sql1);
			$res1 = $query1->result_array();

			$doc['emp_tbl_reg_id']=$res1[0]['emp_reg_id'];
			$doc['emp_id']=$arr['emp_id'];
			$fid=$this->db->insert('employee_document_master',$doc);

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
		$sql="select * from punching_backup where month(Intime)='$msearch' and year(Intime)='$ysearch' ";
        
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
		 $sql="SELECT e.fname,e.mname ,e.lname,e.gender,el.* from punching_backup as el
        INNER JOIN employee_master as e ON e.emp_id = el.UserId
		INNER JOIN department_master as dept ON dept.department_id = e.department
		INNER JOIN college_master as sc ON sc.college_id = e.emp_school
		WHERE day(el.Intime) = '$dsearch' and
		month(el.Intime) ='$msearch'  AND
		year(el.Intime) = '$ysearch' ".$whr."
    
		group by el.UserId ";
		 
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
          if($val['gender']=='male'){
			  $ms = 'Mr.';
		  }else{
			  $ms = 'Mrs.';
		  }
           $data[] =  $val['UserId'].','.$ms." ".$val['fname']." ".$val['mname']." ".$val['lname'].','.$pt;
        }
       // echo "<pre>";
     // print_r($data);exit;
		return $data;
		
	}
	function getAttendance_byid($uid,$dsearch,$msearch,$ysearch){ // for displaying todya's attendance of all employee bydefault.....
	   
	//$DB1 = $this->load->database('otherdb', TRUE); 
	 $sql="SELECT Intime as punch_intime , Outtime as punch_outtime FROM `punching_backup` where day(Intime) = '$dsearch' and
		month(Intime) ='$msearch'  AND	year(Intime) = '$ysearch' AND UserId ='$uid' ";
			   
		$query = $this->db->query($sql);
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
 
if(!empty($data['empsid'])){
	$empid='';
	$cnt = count($data['empsid']);
		  $i=1;
		  foreach($data['empsid'] as $val){
			  $empid .= $val;
			  if($i!=$cnt){
				  $empid .= ',';
			  }
			  $i=$i+1;
		  }
	$sql = 'e.emp_id IN ('.$empid.') AND ';
}
$mc='';
if(!empty($data['staff_type'])){
	$mc=" and e.staff_type=".$data['staff_type'];
}
$mc1=' 1=1';
if(!empty($data['emp_school'])  && !empty($data['department'])){
	$mc1="emp_school ='".$data['emp_school']."' and department ='".$data['department']."'";
}


			  $sql="SELECT DISTINCT e.emp_id ,e.fname,e.mname,e.lname,d.designation_name,dept.department_name,sc.college_name FROM `employee_master` as e
                LEFT JOIN `designation_master` as `d` ON `d`.`designation_id` = `e`.`designation`
		        LEFT JOIN `department_master` as `dept` ON `dept`.`department_id` = `e`.`department`
		        LEFT JOIN `college_master` as `sc` ON `sc`.`college_id` = `e`.`emp_school`

			WHERE e.emp_status='Y' and ".$sql."  $mc $mc1 ";
		//exit();
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
		month(p.Intime) ='$msearch'  AND
		year(p.Intime) = '$ysearch' and
		e.emp_status = 'Y' AND
		p.UserId='".$e['emp_id']."'
		ORDER BY `p`.`UserId` ";
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
		FUNCTION get_time_difference($dtime,$atime){
 
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
 RETURN $hours.':'.$mins;
}

	function get_time_difference1($time1, $time2) {
		
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
		 if(count($value)==0){$flag="false";}else{ 
		 	if($value[0]['is_relax_day']=='Y'){
$flag="false";
		 	}else{
		 	$flag="true";
		 }
		 } 
		 return $flag;		 
   }
 function checkHoliday_new($holiday,$type){
	  $staff_type="";
	 if($type==1){
		 $staff_type="Teaching+Technical";
	 }elseif($type==2){
		 $staff_type="Non-Teaching";
	 }elseif($type==3){
		 $staff_type="Teaching+Technical+Non-Teaching";
	 }elseif($type==4){
		 $staff_type="IC-Staff";
	 }
	 
	    $sql="SELECT * FROM holiday_list_master WHERE hdate = '$holiday' AND (`applicable_for`='ALL' OR `applicable_for`='$staff_type')";
	   	 //#Non-Teaching#Teaching+Technical
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
   
    function checkwo($date,$empid){
		
		$sql = "SELECT week_off from employee_shift_time where emp_id= '".$empid."' and active_from <= '".date('Y-m-d',strtotime($date))."' 
and status='Y'  and del_status='N'
order by active_from DESC limit 1";
 return $query=$this->db->query($sql)->row();	
		//print_r($holiday);
		//print_r($empid);
		//exit;
	  /*$staff_type="";
	 if($type==1){
		 $staff_type="Teaching+Technical";
	 }elseif($type==2){
		 $staff_type="Non-Teaching";
	 }elseif($type==3){
		 $staff_type="Teaching+Technical+Non-Teaching";
	 }elseif($type==4){
		 $staff_type="IC-Staff";
	 }
	 
	    $sql="SELECT * FROM holiday_list_master WHERE hdate = '$holiday' AND (`applicable_for`='ALL' OR `applicable_for`='$staff_type')";
	   	 //#Non-Teaching#Teaching+Technical
        $query=$this->db->query($sql);	
         $value=$query->result_array();
		 if(count($value)==0){$flag="false";}else{ 
		 	if($value[0]['is_relax_day']=='Y'){
$flag="false";
		 	}else{
		 	$flag="true";
		 }
		 } 
		 return $flag;	*/	 
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
			//echo $sql;exit;
	   $query=$this->db->query($sql);
	   $value=$query->result_array();
	     return $value;
   }
   function getAllTotalAttendance1($data){
	  
	   // print_r($data);
		//exit(); 
		$time=strtotime($data['attend_date']);
		$d = date_parse_from_format("Y-m-d", $data['attend_date']);
//echo $d["month"];
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($data['attend_date']));
        $nod = cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch); 
        $data['attend_date'] = $data['attend_date'].'-'.$nod;
		if(!empty($data['emp_school'])){
			$sub1="e.emp_school='".$data['emp_school']."' AND";
		if(!empty($data['department'])){
			$sub1.=" e.department='".$data['department']."'AND ";
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
			$sub1 .= " e.emp_id IN ('".$estr."') AND ";
		}
		//print_r($data['empsid']);
		foreach($data['UserId'] as $vall){
			$UserId[]= $vall;
		}
		
		$cntt = count($data['UserId']); //$data['UserId']
		//print_r($UserId);
		if($cntt==1){
		$UserIdd=$data['UserId'][0];
			}else{
		 $UserIdd=implode(',',$UserId);
		}
		
		//echo $UserIdd;
		//exit();
		
		//  SUM(CASE WHEN p.status NOT LIKE 'abscent' THEN 1 ELSE 0 END) AS total_present, 
		// SUM(CASE WHEN p.status  LIKE 'present' THEN 1 ELSE 0 END) AS total_present,
		$curremnt_date=date('Y-m-d',strtotime($data['attend_date']));
	   $sql="SELECT            		
            e.emp_id,e.fname,e.mname,e.lname,e.gender,c.college_id,e.joiningDate,e.manual_attendance_flag,c.college_name,d.department_id,d.department_name,ec.category_type			
            FROM employee_master as e
			 left join employee_resignation as er on er.emp_id = e.emp_id
            left join college_master as c on c.college_id=e.emp_school
			 left join employee_category as ec on ec.emp_cat_id=e.staff_type
			left join department_master as d on d.department_id=e.department
			where $sub1 e.emp_status='Y' AND ((STR_TO_DATE(resign_date,'%Y-%m-%d') <='$curremnt_date'  and er.status='N')
 OR er.resign_date IS NUll and  e.joiningDate <= '".date('Y-m-d',strtotime($data['attend_date']))."')  
  GROUP by e.emp_id order by e.emp_id ASC";
			//echo $sql;//exit;
			
	   $query=$this->db->query($sql);
	   $value=$query->result_array();
	   //print_r($value);
	   //exit;
	     return $value;
   }
   function getPresentCountByEmp($empid,$dt){
	   $d = date_parse_from_format("Y-m-d", $dt);
//echo $d["month"];
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($dt));
	   $sql="SELECT count(p.Intime) as total_present, p.status,e.emp_id			
            FROM punching_backup as p 
			left join employee_master as e on e.emp_id=p.UserId
            where p.UserId = '$empid' AND month(p.Intime)='$msearch' AND e.emp_reg = 'N' AND p.status='present' AND year(p.Intime)='$ysearch' 
			group by DAY(p.Intime),p.UserId order by p.UserId ASC";
		//	echo $sql;
		//	exit;
	   $query=$this->db->query($sql);
	   $value=$query->result_array();
	     return $value;
   }
   function getremainingAllLeaveCountByEmp1($id,$dt){
	  	  $emp=$id;		  
		$d = date_parse_from_format("Y-m-d",$dt);
        $msearch=$d["month"];
		$ysearch=$d["year"];
		
		$leave_typ = array('CL','ML','EL','C-OFF','SL','VL','Leave','LWP','WFH');
		$lev_cnt =array();
		foreach($leave_typ as $val){
		  //echo $emp;
		/*$sql2="SELECT UserId as nday
from punching_backup where leave_type  like '$val%' AND remark != 'hrs' AND month(Intime)='$msearch' and 
year(Intime)='$ysearch' and UserId='$emp' group by DATE(Intime),UserId";*/
$sql2="SELECT SUM(nday) AS nday FROM (SELECT (leave_duration) AS nday
FROM punching_backup WHERE leave_type  LIKE '$val%' AND remark != 'hrs' AND MONTH(Intime)='$msearch' AND YEAR(Intime)='$ysearch' 
AND UserId='$emp'

  

 GROUP BY UserId ,DATE(Intime)) AS a";

/* echo $sql2;
exit; */
$query2=$this->db->query($sql2);
	   $value2=$query2->result_array();
	   
		$lev_cnt[$val] =($value2[0]['nday']);
		   
		}
		/*$sql3="SELECT SUM(leave_duration) as nday
from punching_backup where leave_type  like '%*' AND remark != 'hrs' AND month(Intime)='$msearch' and 
year(Intime)='$ysearch' and UserId='$emp' group by DATE(Intime), UserId";*/
$sql3="SELECT SUM(nday) AS nday FROM (SELECT (leave_duration) AS nday
FROM punching_backup WHERE leave_type  LIKE '%*' AND remark != 'hrs' AND MONTH(Intime)='$msearch' AND YEAR(Intime)='$ysearch' 
AND UserId='$emp'    GROUP BY UserId ,DATE(Intime)) AS a";
 //echo $sql3;
//exit; 
       $query3=$this->db->query($sql3);
	   $value3=$query3->result_array();
	   
	   if(count($value3) > 0){
		$lev_cnt['LWP'] = $lev_cnt['LWP']+$value3[0]['nday'];
}
	  return $lev_cnt;
   }
   function getremainingAllODCountByEmp1($id,$dt){
	  	  $emp=$id;		  
		$d = date_parse_from_format("Y-m-d",$dt);
        $msearch=$d["month"];
		$ysearch=$d["year"];
		
		$leave_typ = array('OD');
		$lev_cnt =array();
		foreach($leave_typ as $val){
		  //echo $emp;
		$sql2="SELECT COUNT(DISTINCT(DATE(Intime))) as nday
from punching_backup where (leave_type = '$val' OR leave_type = 'official')  
AND remark = 'full-day' AND month(Intime)='$msearch' and year(Intime)='$ysearch' 


 and UserId='$emp' ";
/* echo $sql2;
exit; */

$query2=$this->db->query($sql2);
	   $value2=$query2->result_array();

$lev_cnt1 = $value2[0]['nday'];
 $sql3="SELECT COUNT(DISTINCT(DATE(Intime))) as nday
from punching_backup where (leave_type = '$val' OR leave_type = 'official')  
AND remark = 'hrs' AND month(Intime)='$msearch' and year(Intime)='$ysearch' and UserId='$emp'  ";

$query3=$this->db->query($sql3);
$value3=$query3->result_array();
//OD*
 $sql4="SELECT COUNT(DISTINCT(DATE(Intime))) as nday
from punching_backup where (leave_type = 'OD*' or leave_type = 'official*')  
AND remark = 'half-day' AND month(Intime)='$msearch' and year(Intime)='$ysearch' and UserId='$emp'  ";

$query4=$this->db->query($sql4);
$value4=$query4->result_array();

$lev_cnt4 = $value4[0]['nday']/2;
$lev_cnt2 = $value3[0]['nday']/2;

	   $lev_cnt = $lev_cnt1+$lev_cnt2+$lev_cnt4;
		}
	  return $lev_cnt;
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
		//$sql1="select * from employee_monthly_final_attendance where manual_attendance = 'N' and month(for_month_year)='$msearch' and year(for_month_year)='$ysearch' and UserId='$userid'";
		// echo $sql1;
		//die(); 
		$sql1="select * from employee_monthly_final_attendance where  month(for_month_year)='$msearch' and year(for_month_year)='$ysearch' and UserId='$userid' ";
		
		$query1=$this->db->query($sql1);
		$res1=$query1->result_array();
		if(empty($res1)){
			return 'not';//not already available employee monthly salary
		}elseif(!empty($res1)){
			//if($res1[0]['manual_attendance'] == 'Y'){
//return '1';
			//}else{
			return 'available';	//already available	employee monthly salary
			//}	
		}
   }
   
  function add_update_final_monthly_attendance($data,$dt){
  	//echo "<pre>";
	//print_r($data);
	//echo 'kk';
	//exit;
	//$data = array($data);
	  $d = date_parse_from_format("Y-m-d", $dt);
        $msearch=$d["month"];
        $ysearch=$d["year"];
      $nod =  cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);
	  // add first monthly generated attendance in table for monthly attendance....
				/*First check Monthly attendance already available in table or not for searched date & month/year*/
       
       // echo count($data);
//echo "<pre>";
//print_r($data);
       // exit;
			 $dcant = count($data); 
//echo "<br/>";
//print_r($data);

				//exit;
          for($i=0;$i<=$dcant;$i++){
			  echo $i;
			  echo "</br>";
			 // foreach($data as $key=>$val){
			$total_final_workday=0;
			//echo "<br>";
			// print_r($data[0]['UserId']);
	  //exit;
	    if($data[$i]['sbtnv']=='2'){

		  $data1[$i]['UserId']=$data[$i]['emp_id'];
		  $data1[$i]['working_days']=$data[$i]['working_days'];
	   $data1[$i]['total_present']=$data[$i]['total_present'];
	   $data1[$i]['total_outduty']=$data[$i]['total_outduty'];
	   $data1[$i]['CL']=$data[$i]['total_CL'];
	   $data1[$i]['ML']=$data[$i]['total_ML'];
	   $data1[$i]['EL']=$data[$i]['total_EL'];
	   $data1[$i]['C-Off']=$data[$i]['total_Coff'];
	   $data1[$i]['SL']=$data[$i]['total_SL'];
	   $data1[$i]['VL']=$data[$i]['total_VL'];
	   $data1[$i]['Leaves']=$data[$i]['total_leave'];
	   $data1[$i]['sunday']=$data[$i]['sunday'];
	   $data1[$i]['holiday']=$data[$i]['holiday'];
	   $data1[$i]['LWP']=$data[$i]['total_LWP'];
	    $data1[$i]['WFH']=$data[$i]['total_WFH'];
	   $data1[$i]['Total']=	$data[$i]['totalp'];
	    $data1[$i]['updated_by']=$this->session->userdata("uid");
       $data1[$i]['updated_date']=date('Y-m-d h:m:i');	
	  }else{
		
		  
	   $data1[$i]['UserId']=$data[$i]['emp_id'];
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
	   $data1[$i]['WFH']=$data[$i]['total_WFH'];
	   $data1[$i]['Total']=	$data[$i]['totalp'];
       $data1[$i]['for_month_year']=$ysearch.'-'.$msearch.'-'.$nod;
       $data1[$i]['inserted_by']=$this->session->userdata("uid");
       $data1[$i]['inserted_date']=date('Y-m-d h:m:i');	
      // echo $data[$i]['total_present1'];
      }//if($data[$i]['sbtnv']=='2')
  


	   if($data[$i]['totalp'] != 0){
	   	//echo $i; echo $d;
	   	//echo $data[$i]['emp_id'];echo "</br>";
	       $check1=$this->check_monthly_attendance($dt,$data[$i]['emp_id']);
		
		//exit();
		 
		  if($check1=="not"){ //not already available employee monthly salary
			//echo '1';			 
					//data not already available so insert into table
					if(!empty($data[$i]['emp_id'])){
					$add_month[$i]=$this->Add_final_monthly_attendance($data1[$i],$dt);
						}
					//echo "ooo".$add_month[$i];exit;
		  }elseif($check1=="available"){	
		 // echo '2';				
					//data already available then update it from table
					if(!empty($data[$i]['emp_id'])){
				$update_month[$i]=$this->Update_final_monthly_attendance($data1[$i],$dt);	
					}
		   }
		   
			   }else{
				   
				 $check12=$this->check_monthly_attendance($dt,$data[$i]['emp_id']);
		
		// exit();
		 
		  if($check12=="not"){ //not already available employee monthly salary
			//echo '21';			 
					//data not already available so insert into table
					if(!empty($data[$i]['emp_id'])){
					$add_month[$i]=$this->Add_final_monthly_attendance($data1[$i],$dt);
					}
					//echo "ooo".$add_month[$i];exit;
		  }elseif($check1=="available"){	
		 // echo '22';				
					//data already available then update it from table
					if(!empty($data[$i]['emp_id'])){
				$update_month[$i]=$this->Update_final_monthly_attendance($data1[$i],$dt);	
					}
		   }   
				   
				   
				   
			//echo '3';		   
		 //$update_month[$i]=$this->Update_final_monthly_attendance($data1[$i],$dt);
				   
			   }
			// echo $add_month[$i];
			 //echo  $update_month[$i]; 
		   }
		   
		  // exit;
//echo $i;
		 // exit;
       if(!empty($update_month)|| !empty($add_month)){
		   return true;
	   }		   
  }   
   
   function Add_final_monthly_attendance($data,$dt){
	//  echo 'ADD';
	  
		 $inserted=$this->db->insert('employee_monthly_final_attendance',$data);   
	  
	 if(!empty($inserted)&& $inserted!=0){
		  return $inserted;		 
	 }	   
   }
   function Update_final_monthly_attendance($data,$dt){
	//   echo 'UPDATE';
	 //  echo '<pre>';
	//  print_r($data);
	//   exit();
	         $d = date_parse_from_format("Y-m-d", $dt);
            $msearch=$d["month"];
			$ysearch=$d["year"];
			$this->db->where('UserId',$data['UserId']);
			$this->db->where('month(for_month_year)',$msearch);
			$this->db->where('year(for_month_year)',$ysearch);
			//$this->db->where('month_days',7);
	    $updated=$this->db->update('employee_monthly_final_attendance',$data); 
		//  $this->db->last_query(); echo '<br>';
		// exit();
	   if(!empty($updated)&& $updated!=0){
		  return updated;		 
	 }	 
   }
   
   function fetch_employee_monthly($data){
   	$time=strtotime($data['attend_date']);
		$d = date_parse_from_format("Y-m-d", $data['attend_date']);
//echo $d["month"];
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($data['attend_date']));
		
		if(!empty($data['emp_school'])){
			$sch = $this->getEmpForAllSchool($data['emp_school']);			
			$estr='';
			$cnt = count($sch);
			$i=1;
			foreach($sch as $val){
				$estr .= $val['emp_id'];
				if($cnt != $i){
				$estr .= "','";	
				}
				$i=$i+1;
			}
			$sub1 .= "UserId IN ('".$estr."') AND ";	
		}
		if(!empty($data['department'])){
			$dpt = $this->getDepartmentWiseEmployeeList($data['department']);
			$estr='';
			$cnt = count($dpt);
			$i=1;
			foreach($dpt as $val){
				$estr .= $val['emp_id'];
				if($cnt != $i){
				$estr .= "','";	
				}
				$i=$i+1;
			}
			$sub1 .= "UserId IN ('".$estr."') AND ";
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
			$sub1 .= "UserId IN ('".$estr."') AND ";
		}
		//  SUM(CASE WHEN p.status NOT LIKE 'abscent' THEN 1 ELSE 0 END) AS total_present, 
		// SUM(CASE WHEN p.status  LIKE 'present' THEN 1 ELSE 0 END) AS total_present,
	  //$sql1="SELECT employee_monthly_final_attendance.*,employee_master. FROM employee_monthly_final_attendance join employee_master
//on 	employee_monthly_final_attendance.UserId=employee_master.emp_id
		//	where $sub1 month(for_month_year)='$msearch' AND year(for_month_year)='$ysearch'
			//group by UserId order by UserId ASC";
	 $sql ="SELECT mf.*,CONCAT(em.fname,' ',em.mname,' ',em.lname) as empname FROM employee_monthly_final_attendance as mf  left join employee_master as em on em.emp_id = mf.UserId  		
			where $sub1 month(mf.for_month_year)='$msearch' AND year(mf.for_month_year)='$ysearch' 
			group by mf.UserId order by mf.UserId ASC";
		//	echo $sql;
			
	   $query=$this->db->query($sql);
	  return $value=$query->result_array();
	/* $d = date_parse_from_format("Y-m-d", $dt['attend_date']);
        $msearch=$d["month"];
        $ysearch=$d["year"];
		$sql1="select * from employee_monthly_final_attendance where month(for_month_year)='$msearch' and year(for_month_year)='$ysearch'";
		/* echo $sql1;
		die(); */
	/*	$query1=$this->db->query($sql1);
		$res1=$query1->result_array();
        return $res1;	*/	
   }
   
   function getSchoolDepartmentWiseEmployeeList($sid,$did,$id='',$cat=''){
	 $this->db->select('e.emp_id,e.fname,e.mname,e.lname');
     $this->db->from('employee_master as e');
	 $this->db->where('e.emp_school',$sid);
	 $this->db->where('e.department',$did);
	 $this->db->where('e.emp_status','Y');
	 $this->db->where('e.emp_reg','N');
	 if(!empty($id)){
		 $id = array($id);
$this->db->where_not_in('e.emp_id', $id);
	 }
	 
	 
	 if(!empty($cat)){
		
 $this->db->where('e.staff_type',$cat);
	 }
	 $query=$this->db->get();
	 $res=$query->result_array();
	 return $res;	 
	   
   }
   
   //this function will return Active/Inactive/Resigned Employees by School and department //updated by kishor on 21/06/2019
   function getSchoolDepartmentWiseAllTypeEmployeeList($sid,$did,$id=''){
	 $this->db->select('e.emp_id,e.fname,e.mname,e.lname');
     $this->db->from('employee_master as e');
	 $this->db->where('e.emp_school',$sid);
	 $this->db->where('e.department',$did);
	 //$this->db->where('e.emp_status','Y');
	 //$this->db->where('e.emp_reg','N');
	 if(!empty($id)){
		 $id = array($id);
$this->db->where_not_in('e.emp_id', $id);
	 }
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
   function get_Marked_Emp_Manual($mon){
   	$d = date_parse_from_format("Y-m-d",$mon);      
        $msearch=$d["month"];
        $ysearch=$d["year"];
   	$totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);
	  $this->db->select('e.emp_id,e.fname,e.mname,e.lname');
     $this->db->from('employee_master as e');
     // $this->db->join('employee_monthly_final_attendance as em','em.UserId = e.emp_id','right');
	 if(!empty($sid)){
     $this->db->where('e.emp_school',$sid); 
	 }
	 if(!empty($did)){
	 $this->db->where('e.department',$did);	 
	 }	
	 $this->db->where('e.emp_reg','N');
	 $this->db->where('e.manual_attendance_flag','Y');
	 $this->db->order_by('e.emp_id','ASC');

	 //$this->db->where('month(em.for_month_year)',date('m',strtotime($mon.'-'.$totaldays)));
	 //	 $this->db->where('year(em.for_month_year)',date('Y',strtotime($mon.'-'.$totaldays)));
	 $query=$this->db->get();
	//echo $this->db->last_query();
	//exit;
	 $res=$query->result_array();
	 return $res; 
   }
   function checkDateForLeaveOfEmployee($dt,$emp_id){
	       $sql="SELECT * FROM leave_applicant_list 		              
		   WHERE applied_from_date<='$dt' AND applied_to_date>='$dt' AND emp_id='$emp_id'";
		   $query=$this->db->query($sql);
		   $val=$query->result_array();
		    return $val[0]['leave_type'];
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
   function getEmpForAllSchool($sch='',$dt=''){
	   
	   
	   
	   if(!empty($_POST['empsid'])){
		   $emp_id=($_POST['empsid']);
		    $ids = implode(',', $emp_id);
		   //exit;
	   }
	    $idsc='';
	   if(!empty($ids)){
		  $idsc=" and e.emp_id IN ($ids) "; 
	   }
	   $school_wise=array();
	   $sql="SELECT DISTINCT e.emp_id ,e.fname,e.mname,e.lname,d.designation_name,dept.department_name,sc.college_name FROM `employee_master` as e
                LEFT JOIN `designation_master` as `d` ON `d`.`designation_id` = `e`.`designation`
		        LEFT JOIN `department_master` as `dept` ON `dept`.`department_id` = `e`.`department`
		        LEFT JOIN `college_master` as `sc` ON `sc`.`college_id` = `e`.`emp_school`
				where e.emp_reg='N' AND e.emp_status='Y' and e.emp_school='".$sch."'  $idsc ORDER BY e.emp_id ASC";
				//echo $sql;	exit;			
		$query = $this->db->query($sql);
		return $query->result_array(); 
		
   }
   //get attendance of all employee
   function getAttendanceForAllSchool($emp,$dt){
	       $monthly=array();
		  $d = date_parse_from_format("Y-m-d",$dt);
      
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($dt));
		$fetch_monthly="SELECT e.fname,e.mname ,e.lname,d.designation_name,dept.department_name,sc.college_name, p.* from punching_backup as p
        LEFT JOIN employee_master as e ON e.emp_id = p.UserId
		LEFT JOIN designation_master as d ON d.designation_id = e.designation
		LEFT JOIN department_master as dept ON dept.department_id = e.department
		LEFT JOIN college_master as sc ON sc.college_id = e.emp_school
		WHERE e.emp_reg = 'N' AND
		month(p.Intime) ='$msearch'  AND
		year(p.Intime) = '$ysearch'  and

		p.UserId='".$emp."'
		ORDER BY p.UserId ";
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
				where e.emp_status = 'Y' and e.emp_school='".$sch."' ORDER BY `e`.`emp_id` ASC";
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
	//exit;
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
		  $chk="select * from employee_monthly_final_attendance where UserId='".$id."' and month(for_month_year)='$msearch' and year(for_month_year)='$ysearch'  ";
	
	$query=$this->db->query($chk);
	   $res=$query->result_array();
	   return $res;
   }

  function add_upd_Emp_Manual_Attendance($data,$dt){
	//print_r($data);exit;
	   $d = date_parse_from_format("Y-m-d",$dt);      
        $msearch=$d["month"];
        $ysearch=$d["year"];
         $totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);
          
		//print_r($data);//exit;
for($i=0;$i<count($data);$i++){
	//first check the employee
	$chk="select * from employee_monthly_final_attendance where UserId='".$data[$i]['eid']."' and 
	month(for_month_year)='".$msearch."' and year(for_month_year)='".$ysearch."'";
	//echo $chk;
	//exit;
	$query=$this->db->query($chk);
	   $res=$query->result_array();
	   //print_r($res); echo $dt; exit;
	   if(empty($res)&&!empty($data[$i]['eid'])){
		//   echo"in insert";
		 //  exit;
	   	 $d = date_parse_from_format("Y-m-d",$dt);      
        $msearch=$d["month"];
        $ysearch=$d["year"];
         $totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);
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
	   $data1['total_outduty']=$data[$i]['OD'];
	   $data1['CL']=$data[$i]['CL'];
	   $data1['ML']=$data[$i]['ML'];
	   $data1['EL']=$data[$i]['EL'];
	   $data1['C-Off']=$data[$i]['C-Off'];
	   $data1['SL']=$data[$i]['SL'];
	   $data1['VL']=$data[$i]['VL'];
	   $data1['Leaves']=$data[$i]['Leaves'];
	   $data1['LWP']=$data[$i]['LWP'];
	    $data1['WFH']=$data[$i]['WFH'];
	   //$data1['STL']=$data[$i]['STL'];
	   $data1['manual_attendance']='Y';
	   /* $total_final_workday=($data[$i]['total_present']+$data[$i]['total_outduty']+
                      $data[$i]['CL']+$data[$i]['ML']+$data[$i]['EL']
					  +$data[$i]['C-Off']+$data[$i]['SL']+$data[$i]['VL']
					  +$data[$i]['Leaves']+$data[$i]['LWP']+$data[$i]['STL']);
	   
	   $data1['Total']=$total_final_workday; */
	   $data1['Total']=$data[$i]['Total'];
	   //if($msearch<=9){
		//   $msearch='0'.$msearch;
	   //}
       $data1['for_month_year']= $ysearch.'-'.$msearch.'-'.$totaldays;
	 /*  echo"<pre>";  print_r($data1);
			exit; */
	   $data1['inserted_by']=$this->session->userdata("uid");
	   $data1['inserted_date']=date('Y-m-d h:m:i');
	   
          $ins[$i]=$this->db->insert('employee_monthly_final_attendance',$data1);  
          //echo $this->db->last_query(); 
	   }elseif(!empty($res)){
		 /* echo"in update";
		 exit; */
			 $sql1="select fname,lname from employee_master where emp_id='".$data['eid']."'";
	   $query1=$this->db->query($sql1);
	   $res1=$query1->result_array();
	   $name=$res1[0]['fname'].' '.$res1[0]['lname'];
	   $data['ename']=$name;
	   $data['for_month_year']=$ysearch.'-'.$msearch.'-'.$totaldays;
         /* print_r($data);
	   exit;  */
	   $data1['UserId']=$data[$i]['eid'];
	   $data1['ename']=$data[$i]['ename'];
	   $data1['month_days']=$data[$i]['month_days'];
	   $data1['working_days']=$data[$i]['working_days'];
	   $data1['total_present']=$data[$i]['present_days'];
	   $data1['sunday']=$data[$i]['sunday'];
	   $data1['holiday']=$data[$i]['holiday'];
	   $data1['total_outduty']=$data[$i]['OD'];
	   $data1['CL']=$data[$i]['CL'];
	   $data1['ML']=$data[$i]['ML'];
	   $data1['EL']=$data[$i]['EL'];
	   $data1['C-Off']=$data[$i]['C-Off'];
	   $data1['SL']=$data[$i]['SL'];
	   $data1['VL']=$data[$i]['VL'];
	   $data1['Leaves']=$data[$i]['Leaves'];
	   $data1['LWP']=$data[$i]['LWP'];
	   $data1['WFH']=$data[$i]['WFH'];
	  // $data1['STL']=$data[$i]['STL'];
	  // $total_final_workday=($data[$i]['present_days']+$data[$i]['OD']+
                     // $data[$i]['CL']+$data[$i]['ML']+$data[$i]['EL']
					 // +$data[$i]['C-Off']+$data[$i]['SL']+$data[$i]['VL']
					  //+$data[$i]['Leaves']+$data[$i]['LWP']+$data[$i]['STL']);
	   //print_r($data1);exit;
	   $data1['Total']=$data[$i]['Total'];
	   $data1['for_month_year']=$ysearch.'-'.$msearch.'-'.$totaldays;
	   $data1['updated_by']=$this->session->userdata("uid");
	   $data1['manual_attendance']='Y';
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
	 $this->db->select('e.emp_id,e.fname,e.mname,e.lname,e.date_of_birth,e.gender,e.joiningDate,d.mobileNumber,d.pemail,d.oemail,
lflatno,larea_name,ltaluka,lpincode,lcountry,pflatno,parea_name,ptaluka,p_pincode,dg.designation_name,dt.department_name,c.college_name,
c.college_code,ct.emp_cat_name,dc.profile_pic,e.reporting_dept,e.emp_reg');
	   $this->db->from('employee_master e');
	   $this->db->join ('employe_other_details d','e.emp_id=d.emp_id','inner');
	   $this->db->join ('designation_master dg','e.designation=dg.designation_id','inner');
	   $this->db->join ('department_master dt','dt.department_id=e.department','inner');
	   $this->db->join ('college_master c','c.college_id=e.emp_school','inner');
	   $this->db->join ('employee_category ct','ct.emp_cat_id=e.staff_type','inner');
	   $this->db->join ('employee_document_master dc','dc.emp_id=e.emp_id','inner');
	   $this->db->or_where('e.emp_id',$data['serch_val']);
	   $this->db->or_like('fname',$data['serch_val']);
	   $this->db->or_like('lname',$data['serch_val']);
	  $query=$this->db->get();
	 //echo $this->db->last_query();exit();
	 $res=$query->result_array();
	 return $res;	 
   }
   function checkFinalAttendance($data){
	   	  
		$time=strtotime($data['attend_date']);
		$d = date_parse_from_format("Y-m-d", $data['attend_date']);
//echo $d["month"];
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($data['attend_date']));
		
		if(!empty($data['emp_school'])){
			$sch = $this->getEmpForAllSchool($data['emp_school']);			
			$estr='';
			$cnt = count($sch);
			$i=1;
			foreach($sch as $val){
				$estr .= $val['emp_id'];
				if($cnt != $i){
				$estr .= "','";	
				}
				$i=$i+1;
			}
			$sub1 .= "UserId IN ('".$estr."') AND ";	
		}
		if(!empty($data['department'])){
			$dpt = $this->getDepartmentWiseEmployeeList($data['department']);
			$estr='';
			$cnt = count($dpt);
			$i=1;
			foreach($dpt as $val){
				$estr .= $val['emp_id'];
				if($cnt != $i){
				$estr .= "','";	
				}
				$i=$i+1;
			}
			$sub1 .= "UserId IN ('".$estr."') AND ";
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
			$sub1 .= "UserId IN ('".$estr."') AND ";
		}
		//  SUM(CASE WHEN p.status NOT LIKE 'abscent' THEN 1 ELSE 0 END) AS total_present, 
		// SUM(CASE WHEN p.status  LIKE 'present' THEN 1 ELSE 0 END) AS total_present,
	   $sql="SELECT e.* FROM employee_monthly_final_attendance  e
                join employee_master as em on e.USerId=em.emp_id
	   
			where $sub1 month(for_month_year)='$msearch' AND year(for_month_year)='$ysearch'
			and manual_attendance = 'N' and is_final = 'Y'  and em.emp_status='Y' group by UserId";
		//exit;	
	   $query=$this->db->query($sql);
	   $value=$query->result_array();
	     return $value;
	   
   }
   function getAllLeaveHalfDayCountByEmpID($id,$dt){
	     $emp=$id;		  
		$d = date_parse_from_format("Y-m-d",$dt);
        $msearch=$d["month"];
		$ysearch=$d["year"];
		$sql2="SELECT SUM(leave_duration) as nday
from punching_backup where status='leave' AND leave_duration='0.5' AND leave_type NOT LIKE '%*' AND remark='half-day' AND month(Intime)='$msearch' and year(Intime)='$ysearch' and UserId='$emp'  ";
 
$query2=$this->db->query($sql2);
	   $value2=$query2->result_array();
	   $sql3="SELECT count(leave_duration) as nday
from punching_backup where status='leave' AND leave_type NOT LIKE '%*' AND remark='hrs' AND month(Intime)='$msearch' and year(Intime)='$ysearch' and UserId='$emp'  ";
/* echo $sql2;
exit; */
$query3=$this->db->query($sql3);
	   $value3=$query3->result_array();
$value4 = $value3[0]['nday']/2 ;

		return $lev_cnt = $value2[0]['nday']+$value4;
   }
    function getDepartmentWiseEmployeeList($did){
	 $this->db->select('e.emp_id,e.fname,e.mname,e.lname');
     $this->db->from('employee_master as e');
	 //$this->db->where('e.emp_school',$sid);
	 $this->db->where('e.department',$did);
	 $this->db->where('e.emp_status','Y');
	 $this->db->where('e.emp_reg','N');
	 $query=$this->db->get();
	 $res=$query->result_array();
	 return $res;	 
	   
   }
   function getHolidayListMonthWiseFromPunching($id,$dt){
	  	  $emp=$id;		  
		$d = date_parse_from_format("Y-m-d",$dt);
        $msearch=$d["month"];
		$ysearch=$d["year"];
		
		$leave_typ = array('holiday','sunday');
		$lev_cnt =array();
		foreach($leave_typ as $val){
		  //echo $emp;
		  $sql2="SELECT COUNT(DISTINCT(DATE(Intime))) as nday
from punching_backup where status = '$val' AND month(Intime)='$msearch' and year(Intime)='$ysearch' and UserId='$emp' and is_not_consider !=1


 ";
 //echo $sql2;

$query2=$this->db->query($sql2);
	   $value2=$query2->result_array();
		$lev_cnt[$val] = $value2[0]['nday'];
	   
		}
	  return $lev_cnt;
   }
   function get_emp_data_transfer($data){
	   $empd = $this->getEmployeeById($data['staffid']);
	  
		$arr['emp_id']=(stripcslashes($data['new_empid'])); 
		$arr['fname']=(stripcslashes($empd[0]['fname']));
		$arr['mname']=(stripcslashes($empd[0]['mname']));
		$arr['lname']=(stripcslashes($empd[0]['lname']));
		$arr['referenceID']=(stripcslashes($empd[0]['referenceID']));
		$arr['date_of_birth']=(stripcslashes(date('Y-m-d',strtotime($empd[0]['date_of_birth']))));
		$arr['gender']=(stripcslashes($empd[0]['gender']));
		$arr['blood_gr']=(stripcslashes($empd[0]['blood_gr']));
		$arr['staff_type']=(stripcslashes($empd[0]['staff_type']));
		$arr['adhar_no']=(stripcslashes($empd[0]['adhar_no']));
		$arr['joiningDate']=(stripcslashes(date('Y-m-d',strtotime($data['new_jdate']))));
		$arr['emp_school']=(stripcslashes($empd[0]['emp_school']));
		$arr['designation']=(stripcslashes($empd[0]['designation']));
		$arr['department']=(stripcslashes($empd[0]['department']));
		$arr['staff_grade']=(stripcslashes($empd[0]['staff_grade']));
		$arr['hiring_type']=(stripcslashes($empd[0]['hiring_type']));
		$arr['qualifiaction']=(stripcslashes($empd[0]['qualifiaction']));
		$arr['phy_status']=(stripcslashes($empd[0]['phy_status']));
		$arr['pf_status']=(stripcslashes($empd[0]['pf_status']));		
		$arr['ro_flag']=(stripcslashes($empd[0]['ro_flag']));		
		$arr['inserted_by']=$this->session->userdata("uid");
		$arr['inserted_datetime']=date("Y-m-d H:i:s");
		$arr['old_emp_id'] = $data['staffid'];
		
		//contact details
		$detail['emp_id']=(stripcslashes($data['new_empid'])); 
		$detail['landline_std']=(stripcslashes($empd[0]['landline_std']));
		$detail['landline_no']=(stripcslashes($empd[0]['landline_no']));		
		$detail['mobileNumber']=(stripcslashes($empd[0]['mobileNumber']));
		$detail['pemail']=(stripcslashes($empd[0]['pemail']));
		$detail['oemail']=(stripcslashes($empd[0]['oemail']));
		//local address
		$detail['lflatno']=(stripcslashes($empd[0]['lflatno']));
		$detail['larea_name']=(stripcslashes($empd[0]['larea_name']));
		$detail['ltaluka']=(stripcslashes($empd[0]['ltaluka']));
		$detail['ldist']=(stripcslashes($empd[0]['ldist']));
		$detail['lpincode']=(stripcslashes($empd[0]['lpincode']));
		$detail['lstate']=(stripcslashes($empd[0]['lstate']));
		$detail['lcountry']=(stripcslashes($empd[0]['lcountry']));
		$detail['bank_name']=(stripcslashes($empd[0]['bank_id']));
         $detail['ifsc_code']=(stripcslashes($empd[0]['ifsc_code']));
		//premanent address
		$detail['pflatno']=(stripcslashes($empd[0]['pflatno']));
		$detail['parea_name']=(stripcslashes($empd[0]['parea_name']));
		$detail['ptaluka']=(stripcslashes($empd[0]['ptaluka']));
		$detail['pdist']=(stripcslashes($empd[0]['pdist']));
		$detail['p_pincode']=(stripcslashes($empd[0]['p_pincode']));
		$detail['pstate']=(stripcslashes($empd[0]['pstate']));
		$detail['pcountry']=(stripcslashes($empd[0]['pcountry']));
		//for both address same checking
		$detail['same']=(stripcslashes($empd[0]['same']));
		//experience details
		$detail['aexp_yr']=(stripcslashes($empd[0]['aexp_yr']));
		$detail['aexp_mnth']=(stripcslashes($empd[0]['aexp_mnth']));
		$detail['inexp_yr']=(stripcslashes($empd[0]['inexp_yr']));
		$detail['inexp_mnth']=(stripcslashes($empd[0]['inexp_mnth']));
		$detail['rexp_yr']=(stripcslashes($empd[0]['rexp_yr']));
		$detail['rexp_mnth']=(stripcslashes($empd[0]['rexp_mnth']));
		$detail['texp_yr']=(stripcslashes($empd[0]['texp_yr']));
		$detail['texp_mnth']=(stripcslashes($empd[0]['texp_mnth']));
		//salary details
		$detail['scaletype']=(stripcslashes($empd[0]['scaletype']));
		$detail['basic_sal']=(stripcslashes($empd[0]['basic_sal']));
		$detail['allowance']=(stripcslashes($empd[0]['allowance']));
		$detail['pay_band_min']=(stripcslashes($empd[0]['pay_band_min']));
		$detail['pay_band_max']=(stripcslashes($empd[0]['pay_band_max']));
		$detail['pay_band_gt']=(stripcslashes($empd[0]['pay_band_gt']));
		$detail['other_pay']=(stripcslashes($empd[0]['other_pay']));
		
		$detail['bank_acc_no']=(stripcslashes($empd[0]['bank_acc_no']));
		$detail['pf_no']=(stripcslashes($empd[0]['pf_no']));
		$detail['pan_no']=(stripcslashes($empd[0]['pan_no']));
		

		$detail['inserted_by']=$this->session->userdata("uid");
		$detail['inserted_datetime']=date("Y-m-d H:i:s");
		
		$insert_id =$this->db->insert('employee_master',$arr);
		$fetch_id=$this->db->insert_id();
		//insert sift time to reporting time table
		$sql = "select * from reporting_time where emp_id = '".$empd[0]['emp_reg_id']."' and emp_code = '".$empd[0]['emp_code']."' ";
		$query=$this->db->query($sql);
	   $rt =$query->result_array();
	   
		$arr1 = array();
		$arr1['emp_id']=(stripcslashes($fetch_id));
		$arr1['emp_code']=(stripcslashes($data['new_empid']));
		$arr1['week_off']=(stripcslashes($rt[0]['week_off']));
		$arr1['shift']=(stripcslashes($rt[0]['shift']));
		$arr1['intime']=(stripcslashes($rt[0]['intime']));
		$time1=strtotime($rt[0]['intime']);
		$arr1['intime']=date("H:i:s",$time1);
		$arr1['outtime']=(stripcslashes($rt[0]['outtime']));
		$time2=strtotime($rt[0]['outtime']);
		$arr1['outtime']=date("H:i:s",$time2);
		$arr1['inserted_by']=$this->session->userdata("uid");
		$arr1['inserted_date']=date("Y-m-d H:i:s");
			$insert_id2 =$this->db->insert('reporting_time',$arr1);
	
		$insert_id1 =$this->db->insert('employe_other_details',$detail);
		$fetch_id1=$this->db->insert_id();	
		if(!empty($fetch_id)&& $fetch_id!=0){					
			
			$doc['emp_tbl_reg_id']=$fetch_id;
			$doc['emp_id']=$data['new_empid'];
			$doc['profile_pic']=$empd[0]['profile_pic'];
			$doc['resume']=$empd[0]['resume'];
			$doc['offer_letter']=$empd[0]['offer_letter'];
			$doc['Joining_Letter']=$empd[0]['Joining_Letter'];
			$doc['ID_Proof']= $empd[0]['ID_Proof'];
			$fid=$this->db->insert('employee_document_master',$doc);
		
			$fdid=$this->db->insert_id();
        
$temp['username']=$data['new_empid'];
         $temp['password']=strtoUpper($empd[0]['fname']).strtoUpper($empd[0]['lname']).$data['new_empid'];
           
		$temp['roles_id']=3;
		$temp['inserted_by']=$this->session->userdata("uid");
		$temp['inserted_datetime']=date("Y-m-d H:i:s");
	        $aid=$this->db->insert('user_master',$temp);
			$a_ins=$this->db->insert_id();
		}

		$sqlr = "select * from employee_reporting_master where  status = 'Y' and emp_code = '".$data['staffid']."' ";
		$queryr=$this->db->query($sqlr);
	   $rm =$queryr->result_array();
foreach ($rm as $val) {
	$rtm['emp_code']=$data['new_empid'];
	//$rtm['weekly_off']=$val['weekly_off'];
	//$rtm['shift']=$val['shift'];
	//$rtm['in_time']=$val['in_time'];
	//$rtm['out_time']=$val['out_time'];
	//$rtm['report_school']=$val['report_school'];
	//$rtm['report_department']=$val['report_department'];
	$rtm['route']=$val['route'];
	$rtm['report_person1']=$val['report_person1'];
	$rtm['report_person2']=$val['report_person2'];
	$rtm['report_person3']=$val['report_person3'];
	$rtm['report_person4']=$val['report_person4'];
	$rtm['status']='Y';
	$rtm['inserted_by']=$this->session->userdata("uid");
	$rtm['inserted_datetime']=date("Y-m-d H:i:s");
	 $rtd=$this->db->insert('employee_reporting_master',$rtm);
			//$a_ins=$this->db->insert_id();
}


		$detail1 = array();
		$detail1['emp_id']= (stripcslashes($data['new_empid']));
		$detail1['scaletype']=(stripcslashes($empd[0]['scaletype']));
		$detail1['basic_sal']=(stripcslashes($empd[0]['basic_sal']));
		$detail1['allowance']=(stripcslashes($empd[0]['allowance']));
		$detail1['pay_band_min']=(stripcslashes($empd[0]['pay_band_min']));
		$detail1['pay_band_max']=(stripcslashes($empd[0]['pay_band_max']));
		$detail1['pay_band_gt']=(stripcslashes($empd[0]['pay_band_gt']));
		$detail1['other_pay']=(stripcslashes($empd[0]['other_pay']));
		$detail1['created_by']=$this->session->userdata("uid");
		$detail1['created_on']=date("Y-m-d H:i:s");
		$detail1['active_status']='Y';
		$detail1['special_allowance']=(stripcslashes($empd[0]['special_allowance']));
        $detail1['gross_salary']=(stripcslashes($empd[0]['gross_salary']));
		
		$aid_d=$this->db->insert('employee_salary_structure',$detail1);
			$a_ins_s = $this->db->insert_id();
		
		if(!empty($fetch_id)&&!empty($fdid)&&!empty($a_ins)){
			return $fdid;
		}
   }
   function getEmployeesDataTransfer(){
		$sql = "select e.*,dm.department_name,cm.college_name from employee_master as e 
		inner join department_master as dm ON dm.department_id = e.department
inner join college_master as cm ON cm.college_id = e.emp_school
		where e.old_emp_id IS NOT NULL AND e.old_emp_id != '0'";
		$query=$this->db->query($sql);
	   $rt =$query->result_array();
	   
        return $rt;
	}
	function get_emp_roles(){
	$sql = "select * from roles_master where status = 'Y' and roles_id NOT IN (4,6,8,9,13)";
	$query1=$this->db->query($sql);
		$res1=$query1->result_array();
		return $res1;
}
function get_emp_roles_adm(){
	$sql = "select * from roles_master where status = 'Y' and roles_id  IN (20,21,12,3)";
	$query1=$this->db->query($sql);
		$res1=$query1->result_array();
		return $res1;
}
function getSchoolDepartmentWiseEmployeeList1($data=array()){
	//print_r($data);
	 $this->db->select('e.emp_id,e.fname,e.mname,e.lname,dg.designation_name,dt.department_name,c.college_name');
     $this->db->from('employee_master as e');
	  $this->db->join ('designation_master dg','e.designation=dg.designation_id','inner');
	   $this->db->join ('department_master dt','dt.department_id=e.department','inner');
	   $this->db->join ('college_master c','c.college_id=e.emp_school','inner');
	 if(!empty($data['emp_school'])){
	 $this->db->where('e.emp_school',$data['emp_school']);
	 }
	 if(!empty($data['department'])){
	 $this->db->where('e.department',$data['department']);
	 }
	 //$this->db->where('e.emp_status','Y');
	 $this->db->where('e.emp_reg','N');
	 if(!empty($data['empsid'])){
		 $id = $data['empsid'];
$this->db->where_in('e.emp_id', $id);
	 }
	 $this->db->order_by('e.emp_id','ASC');
	 $query=$this->db->get();
	 $res=$query->result_array();
	 return $res;	 
	   
   }
   
   function run_cron_attendance($data){
	  // print_r($data);
	   foreach($data['datelist'] as $dt){
		   $i=1;
		   foreach($data['emp'] as $emp){
	   $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://sandipuniversity.com/erp_cron/erp_cron_new.php?empid=".$emp."&dt=".$dt);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
   //curl_setopt($ch.$i, CURLOPT_SSL_VERIFYPEER, false);
 curl_exec($ch);
if($errno = curl_errno($ch)) {
    $error_message = curl_strerror($errno);
    $ch = "cURL error ({$errno}):\n {$error_message}";
    $ch = 'err';
}
//echo $ch;
curl_close($ch);
$i++; 
	   }		
	   }
return $ch;
   }
   public function get_emp_punchin_month($mon,$emp){
   	$sql11="SELECT DISTINCT(LogDate),DeviceId,UserId,LogDate from punching_log where month(LogDate)='".date('m-d',strtotime($mon.'-01'))."' and UserId ='".$emp."' order by LogDate ASC";
	$query11 = $this->db->query($sql11);
      return  $res=$query11->result_array();
   }
   public function get_emp_bystafftype($st){
	   
	   $bt='';
	    if($st == 'Teaching+Technical'){
		   $bt .= "and staff_type IN('1','3')";
	   }elseif($st == 'Non-Technical'){
		    $bt .= "and staff_type = '2' ";
	   }elseif($st == 'Teaching+Technical+Non-Teaching'){
		    $bt .= "and staff_type IN('1','2','3') ";
	   }elseif($st == 'IC-Staff-HO'){
		    $bt .= "and staff_type IN('4') ";
	   }elseif($st == 'All'){
		    $bt .= "and staff_type IN('1','2','3','4') ";
	   }
	   
	   
   $sql11="SELECT emp_id,fname,mname,lname from employee_master where emp_reg = 'N' $bt order by emp_id ASC";
	$query11 = $this->db->query($sql11);
				
        return $query11->result_array();
	}
	function getVisitingEmployees1($st){
	   $this->load->database();
		$DB1 = $this->load->database('umsdb', TRUE);		
	 $DB1->select('e.emp_id,e.fname,e.mname,e.lname');
     $DB1->from('faculty_master as e');	
	 $DB1->where('e.emp_status',$st);	
//$DB1->where('e.is_payable','Y');	 	 
	 $query=$DB1->get();
	 $res=$query->result_array();
	// print_r($res);
	 return $res;	 
   }
    function get_visiting_attendance($date,$emp){
	    
		  $d = date_parse_from_format("Y-m-d",$date);
      
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($date."-01"));
		 $fetch_monthly="SELECT f.fname,f.mname,f.lname,d.designation_name,dept.department_name,sc.college_name, p.* from punching_backup as p
        LEFT JOIN sandipun_ums.faculty_master as f ON f.emp_id = p.UserId
		LEFT JOIN designation_master as d ON d.designation_id = f.designation
		LEFT JOIN department_master as dept ON dept.department_id = f.department
		LEFT JOIN college_master as sc ON sc.college_id = f.emp_school
		WHERE 
		month(p.Intime) ='$msearch'  AND
		year(p.Intime) = '$ysearch' and
		p.UserId = '".$emp."'
		ORDER BY p.Intime ASC";
	    $query1=$this->db->query($fetch_monthly);
		//print_r($query1->result_array());exit;
	return $query1->result_array();
	   
   }
    function getVisitingEmployeeDetails($id){
	 	
	 $fetch_monthly="SELECT f.fname,f.mname,f.lname,d.designation_name,dept.department_name,sc.college_name from sandipun_ums.faculty_master as f 
		LEFT JOIN designation_master as d ON d.designation_id = f.designation
		LEFT JOIN department_master as dept ON dept.department_id = f.department
		LEFT JOIN college_master as sc ON sc.college_id = f.emp_school
		WHERE 	
		f.emp_id = '".$id."'		";
	    $query=$this->db->query($fetch_monthly);
	 $res=$query->result_array();
	// print_r($res);
	 return $res;	 
	   
   }
   function checkMonthAttendance($data){
	   	  
		$time=strtotime($data['attend_date']);
		$d = date_parse_from_format("Y-m-d", $data['attend_date']);
//echo $d["month"];
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($data['attend_date']));
		
		if(!empty($data['emp_school'])){
			$sch = $this->getEmpForAllSchool($data['emp_school']);			
			$estr='';
			$cnt = count($sch);
			$i=1;
			foreach($sch as $val){
				$estr .= $val['emp_id'];
				if($cnt != $i){
				$estr .= "','";	
				}
				$i=$i+1;
			}
			$sub1 .= "UserId IN ('".$estr."') AND ";	
		}
		if(!empty($data['department'])){
			$dpt = $this->getDepartmentWiseEmployeeList($data['department']);
			$estr='';
			$cnt = count($dpt);
			$i=1;
			foreach($dpt as $val){
				$estr .= $val['emp_id'];
				if($cnt != $i){
				$estr .= "','";	
				}
				$i=$i+1;
			}
			$sub1 .= "UserId IN ('".$estr."') AND ";
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
			$sub1 .= "fm.UserId IN ('".$estr."') AND ";
		}
		//  SUM(CASE WHEN p.status NOT LIKE 'abscent' THEN 1 ELSE 0 END) AS total_present, 
		// SUM(CASE WHEN p.status  LIKE 'present' THEN 1 ELSE 0 END) AS total_present,
	    $sql="SELECT fm.*,em.emp_reg,em.emp_id FROM employee_monthly_final_attendance as fm left join employee_master as em on em.emp_id = fm.UserId			
			where $sub1 month(fm.for_month_year)='$msearch' AND year(fm.for_month_year)='$ysearch'
			and  fm.is_final = 'N' and fm.manual_attendance = 'N'    group by fm.UserId";
			
			
	//$sql1 = "SELECT fm.*,em.emp_reg,em.emp_id FROM employee_master as em left join employee_monthly_final_attendance	as fm on fm.UserId = em.emp_id		
		//	where $sub1 month(fm.for_month_year)='$msearch'  AND year(fm.for_month_year)='$ysearch'
		//	and fm.is_final = 'N' group by fm.UserId ";
	   $query=$this->db->query($sql);
	   $value=$query->result_array();
	     return $value;
	   
   }
   function checkMonthAttendance1($data){
	   	  
		$time=strtotime($data['attend_date']);
		$d = date_parse_from_format("Y-m-d", $data['attend_date']);
//echo $d["month"];
        $msearch=$d["month"];
        $ysearch=date("Y",strtotime($data['attend_date']));
		
		if(!empty($data['emp_school'])){
			$sch = $this->getEmpForAllSchool($data['emp_school']);			
			$estr='';
			$cnt = count($sch);
			$i=1;
			foreach($sch as $val){
				$estr .= $val['emp_id'];
				if($cnt != $i){
				$estr .= "','";	
				}
				$i=$i+1;
			}
			$sub1 .= "UserId IN ('".$estr."') AND ";	
		}
		if(!empty($data['department'])){
			$dpt = $this->getDepartmentWiseEmployeeList($data['department']);
			$estr='';
			$cnt = count($dpt);
			$i=1;
			foreach($dpt as $val){
				$estr .= $val['emp_id'];
				if($cnt != $i){
				$estr .= "','";	
				}
				$i=$i+1;
			}
			$sub1 .= "UserId IN ('".$estr."') AND ";
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
			$sub1 .= "fm.UserId IN ('".$estr."') AND ";
		}
		//  SUM(CASE WHEN p.status NOT LIKE 'abscent' THEN 1 ELSE 0 END) AS total_present, 
		// SUM(CASE WHEN p.status  LIKE 'present' THEN 1 ELSE 0 END) AS total_present,
	  $sql="SELECT fm.*,em.emp_reg,em.emp_id FROM employee_monthly_final_attendance as fm left join employee_master as em on em.emp_id = fm.UserId			
			where $sub1 month(fm.for_month_year)='$msearch' AND year(fm.for_month_year)='$ysearch'
			and  fm.is_final = 'N'   group by fm.UserId";
			
	//$sql1 = "SELECT fm.*,em.emp_reg,em.emp_id FROM employee_master as em left join employee_monthly_final_attendance	as fm on fm.UserId = em.emp_id		
		//	where $sub1 month(fm.for_month_year)='$msearch'  AND year(fm.for_month_year)='$ysearch'
		//	and fm.is_final = 'N' group by fm.UserId ";
	   $query=$this->db->query($sql);
	  // echo $this->db->last_query; //exit();
	   $value=$query->result_array();
	     return $value;
	   
   }
   function Add_final_status_attendance($data){
	   
	    $d = date_parse_from_format("Y-m-d", $data['attend_date']);
        $msearch=$d["month"];
        $ysearch=$d["year"];
	             //$this->db->where('UserId',$data['UserId']);
		$this->db->where('month(for_month_year)',$msearch);
		$this->db->where('year(for_month_year)',$ysearch);
		//$this->db->where('month_days',7);
		$this->db->set('is_final','Y');
	    $updated=$this->db->update('employee_monthly_final_attendance'); 
	
		 //echo  $updated;
		// exit;
	   if(!empty($updated)&& $updated!=0){
		  return 'updated';		 
	 }	 
	   
   }
    function get_knowledge_partner_list(){
	    $this->load->database();
		$DB1 = $this->load->database('umsdb', TRUE);		
	 $DB1->select('partnership_code');
     $DB1->from('partnership_instutute_details');	
	 	 	 
	 $query=$DB1->get();
	 $res=$query->result_array();
	// print_r($res);
	 return $res;	 
   }
   function getEmployeePrejobDetails($id){
	   $sql = "select * from employee_previous_joining_details where emp_id = '".$id."' ";
	$query1=$this->db->query($sql);
		$res1=$query1->result_array();
		return $res1;
   }
    function check_monthly_manual_Emp_attendance($dt){
	   $d = date_parse_from_format("Y-m-d",$dt);      
        $msearch=$d["month"];
        $ysearch=$d["year"];
		 $chk="select ef.*,e.emp_id,e.fname,e.mname,e.lname from employee_monthly_final_attendance as ef left join employee_master as e on e.emp_id = ef.UserId where ef.manual_attendance = 'Y' and month(ef.for_month_year)='$msearch' and year(ef.for_month_year)='$ysearch'";
		
	$query=$this->db->query($chk);
	   $res=$query->result_array();
	   return $res;
   }
function get_visiting_list(){
	$fetch_monthly="SELECT f.fname,f.mname,f.lname,f.emp_id from sandipun_ums.faculty_master as f 		
		WHERE f.emp_status = 'Y'";
	    $query=$this->db->query($fetch_monthly);
	 $res=$query->result_array();
	// print_r($res);
	 return $res;
	
}

function getAlltask(){
	
     $query=$this->db->get_where('other_task',array('is_active'=>'Y'));
	 return $query->result();
	}
	
	
	function get_employee_list_of_specific_stream_semester($stream_id, $academic_year,$semester,$division) {
        $academic_year= (explode("~",$academic_year));
		$this->db->select("e.emp_id,s.division,e.emp_reg_id,CONCAT(e.fname, ' ', e.mname, ' ', e.lname) as fac_name", FALSE);
				$this->db->from('sandipun_ums.lecture_time_table s');
				$this->db->join('sandipun_erp.employee_master e', 's.faculty_code = e.emp_id');
				$this->db->where('s.stream_id',$stream_id);
				$this->db->where('s.semester',$semester);
				$this->db->where('e.emp_status','Y');
				$this->db->where('s.academic_year',$academic_year[0]);
				$this->db->where_in('s.division',$division);
				$this->db->group_by('e.emp_id');
                $query = $this->db->get();      
        $sub_details = $query->result_array();
         return $sub_details;
    }
	
	
	function add_update_datewise_attendance($data){
		$uid=$this->session->userdata("uid");
		$role_id=$this->session->userdata("role_id");
		$name=$this->session->userdata("name");
		$Attendance=array();
		
		//print_r($data['Attendance']);
		
		/*$int['school']=$data['empschool'];
		$int['department']=$data['dept'];
		$int['date_attendance']=$data['rdate'];
		$Attendance=$data['Attendance'];*/
		
		$count=count($data['Attendance']);$i=0;
		foreach($data['Attendance'] as $key=>$value){
			
			
	 $sqlcheck="SELECT count(attendance_id) as Total FROM empolyee_datwise_manual_attendance where school='".$data['empschool']."' AND department='".$data['dept']."' AND date_attendance='".$data['rdate']."' AND emp_id='".$key."'";
		$querycheck=$this->db->query($sqlcheck);	
			$res=$querycheck->result_array();
			if($res[0]['Total']==0){
			
		$sql="INSERT INTO empolyee_datwise_manual_attendance values(NULL,'".$data['empschool']."','".$data['dept']."','".$data['rdate']."','".$key."','".$value."','".$name."','Y','".$uid."','".date("Y-m-d H:i:s")."','','')";
			}
		 $query=$this->db->query($sql);
		//array_push($int['emp_id']=$key);
		//$int['emp_id']=$key;
		//array_push($int['attendance_mark']=$value);
		$i++;
		}
		
		if($count==$i){
			return 1;
		}
		//echo $sql;
		/*$int['attendance_by']=$name;
		$int['status']='Y';
		$int['inserted_by']=$uid;
		$int['inserted_datetime']=date("Y-m-d H:i:s");*/
		//print_r($int);
		//$int['updated_by']=$data
		//$int['updated_datetime']=$data
		
	}
	
	function check_Attendance_report($emp_school,$attend_date,$department){
		$sql="SELECT CONCAT(em.fname,' ',em.mname,' ',em.lname)AS NAME,a.* FROM empolyee_datwise_manual_attendance AS a LEFT JOIN employee_master AS em ON em.emp_id=a.emp_id
 WHERE a.school='$emp_school' AND a.department='$department' AND date_attendance='$attend_date'";
	    $query=$this->db->query($sql);
	 $res=$query->result_array();
	// print_r($res);
	 return $res;
	}
	
	
	function insert_Montly_Attendance($UserId,$Username,$month_days,$working_days,$total_present,$sunday,$holiday,$total_outduty,$CL,$ML,$EL,$C_Off,
	$SL,$VL,$Leaves,$LWP,$WFH,$STL,$Total,$for_month_year,$manual_attendance,$is_final){
			
			
			$data['UserId']=$UserId;
			$data['ename']=$Username;
			$data['month_days']=$month_days;
			$data['working_days']=$working_days;
			$data['total_present']=$total_present;
			$data['sunday']=$sunday;
			$data['holiday']=$holiday;
			$data['total_outduty']=$total_outduty;
			$data['CL']=$CL;
			$data['ML']=$ML;
			$data['EL']=$EL;
			$data['C-Off']=$C_Off;
			$data['SL']=$SL;
			$data['VL']=$VL;
			$data['Leaves']=$Leaves;
			$data['LWP']=$LWP;
			$data['WFH']=$WFH;
			$data['STL']=$STL;
			$data['Total']=$Total;
			$data['for_month_year']=$for_month_year;
			$data['manual_attendance']=$manual_attendance;
			$data['is_final']=$is_final;
			//print_r($data);
			//exit();
			$d = date_parse_from_format("Y-m-d",$for_month_year);
             $msearch=$d["month"];//month number
             $ysearch=date("Y",strtotime($for_month_year));
			$SQL="SELECT COUNT(aid) AS total from employee_monthly_inout where UserId='".$UserId."' AND month(for_month_year)='".$msearch."' AND year(for_month_year)='".$ysearch."'";
			  $query=$this->db->query($SQL);
	           $res=$query->result_array();
			   echo'Check-- '.($res[0]['total']);
			   if($res[0]['total']==0){
				$inserted=$this->db->insert('employee_monthly_inout',$data);  
			   }else{
				   $this->db->where('UserId',$UserId);
				   $where=" month(for_month_year)='".$msearch."' AND year(for_month_year)='".$ysearch."'";
				   $this->db->where($where);
				   $inserted=$this->db->update('employee_monthly_inout',$data);
			   }
				
				

	}
	
	///////////////////////////
	///////////model-Admin_model///////////////////
function fetch_student_grade_data_old()
	{
	 $sql="SELECT res_master_id,sm.stud_id, 'Sandip University' as ORG_NAME,'' as ORG_NAME_L,v.stream_short_name as ACADEMIC_COURSE_ID,v.course_name,'' as COURSE_NAME_L ,v.stream_name,'' as STREAM_L, v.programme_code,sm.admission_session as SESSION,sm.enrollment_no as REGN_NO,sm.enrollment_no as RROLL,UPPER(CONCAT(COALESCE(sm.first_name,''), ' ',COALESCE(sm.middle_name,''),' ',COALESCE(sm.last_name,''))) AS CNAME,sm.gender,sm.dob, sm.father_fname as FNAME,sm.mother_name as MNAME,'' as PHOTO,'' as MRKS_REC_STATUS,e.cumulative_gpa as RESULT,e.exam_year as YEAR, e.exam_month as MONTH, sm.current_semester AS semester,sba.division,gp.grade_point as gp,sm.abc_no 
	FROM sandipun_ums.exam_result_master e 
	LEFT JOIN sandipun_ums.stream_grade_criteria st ON st.stream_id=e.stream_id 
	LEFT JOIN sandipun_ums.grade_policy_details gp ON gp.rule=st.grade_rule 
	LEFT JOIN sandipun_ums.student_master sm ON sm.stud_id=e.student_id AND sm.enrollment_no!='' 
	LEFT JOIN sandipun_ums.student_batch_allocation sba ON sm.stud_id=sba.student_id and sba.semester=1 
	LEFT JOIN sandipun_ums.vw_stream_details v ON v.stream_id=sm.admission_stream where e.exam_id=25 and e.semester=1   
    and res_master_id >=52346 and res_master_id <= 53260
	order by res_master_id asc";
//exit;
		 $query=$this->db->query($sql);
	     $res=$query->result_array();
	     return $res;				
	}
	
	function fetch_subject_data_old($enrollment_no)
	{
	  $sql="select s.subject_code, s.subject_name, s.theory_max, s.theory_min_for_pass,s.practical_max,s.sub_max,s.sub_min,e.cia_marks as optd_cia_marks,e.exam_marks as optd_th_marks,e.practical_marks as optd_pr_marks,e.final_garde_marks ,e.final_grade,s.credits as subj_credits,gp.grade_point, s.credits * gp.grade_point as subgradepoints   from sandipun_ums.exam_result_data e 
     join sandipun_ums.subject_master s on s.sub_id=e.subject_id
	 LEFT JOIN sandipun_ums.stream_grade_criteria st ON st.stream_id=e.stream_id 
	 LEFT JOIN sandipun_ums.grade_policy_details gp ON gp.rule=st.grade_rule and e.final_grade=gp.grade_letter
      where  exam_id=25 and e.semester=1 and enrollment_no='$enrollment_no'";
	  $query=$this->db->query($sql);
	  return $query->result_array();

	}


  public function fetch_earlygo_latemark($date)
	{		
	   $d = date_parse_from_format("Y-m-d",$date);      
        $msearch=$d["month"];
		$ysearch=date("Y",strtotime($date."-01"));
		 $sql="select p.*,e.in_time as shift_in,e.out_time as shift_out  from punching_backup p left join employee_shift_time e on p.UserId=e.emp_id where month(p.Intime) ='$msearch' AND year(p.Intime) = '$ysearch' AND (p.late_mark=1 OR p.early_mark='Y') AND e.status='Y' ORDER BY p.Intime ASC ";
	  $query=$this->db->query($sql);
	  return $query->result_array();
	}
	
	public function fetch_inoutmissing_report($date)
	{		
	    $d = date_parse_from_format("Y-m-d",$date);      
        $msearch=$d["month"];
		$ysearch=date("Y",strtotime($date."-01"));
		   $sql="select p.*,e.in_time as shift_in,e.out_time as shift_out from punching_backup p left join employee_shift_time e on p.UserId=e.emp_id where month(p.Intime) ='$msearch' AND year(p.Intime) = '$ysearch' AND p.status!='sunday' AND p.leave_type='LWP' AND (p.Intime like'%00:00:00%' OR p.Outtime like'%00:00:00%') AND e.status='Y'  ORDER BY p.Intime ASC ";
	   $query=$this->db->query($sql);
	   return $query->result_array();
	}
	public function fetch_admission_report($course_id='')
	{         
		 $this->load->database();
		 $DB1 = $this->load->database('umsdb', TRUE);	
         $DB1->select('ad.academic_year,COUNT(ad.student_id) AS totstud,"'.$course_id.'" as course_id');
         $DB1->select("COUNT(ad.student_id) AS totstud, SUM(CASE WHEN ad.cancelled_admission='Y' THEN 1
		             ELSE 0 END) AS cancel_adm");
         $DB1->select('SUM(CASE WHEN ad.academic_year=sm.admission_session and ad.cancelled_admission="N" and ad.academic_year < 2020 THEN 1
		WHEN ad.academic_year=sm.admission_session and ad.cancelled_admission="N" and ad.academic_year >=2020 and sm.admission_confirm="Y"  THEN 1
		              ELSE 0 END) AS new_adm');
         $DB1->select('SUM(CASE WHEN ad.academic_year!=sm.admission_session and ad.cancelled_admission="N" and ad.academic_year < 2020 THEN 1
                      WHEN ad.academic_year!=sm.admission_session and ad.cancelled_admission="N" and ad.academic_year >=2020 and sm.admission_confirm="Y" THEN 1
		              ELSE 0 END) AS rr_adm,
					   SUM(CASE 
            WHEN sm.current_year = v.course_duration 
                 AND sm.academic_year = ad.academic_year
                 AND (
                        (ad.academic_year >= 2020 AND sm.admission_confirm = "Y" AND ad.cancelled_admission = "N")
                        OR (ad.academic_year < 2020 AND ad.cancelled_admission = "N")
                     )
            THEN 1 ELSE 0 
        END) AS final_year_student,
					 SUM(CASE WHEN ad.year=v.course_duration and sm.degree_completed="Y" then 1
		             ELSE 0 END) AS passout_student');
		 $DB1->from('admission_details as ad');
		 $DB1->join('vw_stream_details as v','v.stream_id=ad.stream_id');
		 $DB1->join('student_master as sm','sm.stud_id=ad.student_id and   
                   `sm`.`enrollment_no` != ""','left');
		 if($course_id =='14'){
			$DB1->where('v.course_id !=',15);  
			  
		 }else if($course_id=='15'){
         $DB1->where('v.course_id ='.$course_id.'');	
		 }
		 else if($course_id=='16'){
         //$DB1->where('v.course_id not in ('.$course_id.')');	
         $DB1->where('v.course_id !=15');	
         $DB1->where('v.course_id !=16');	
		 }
		 else
		 {}
	
         //$DB1->where('ad.cancelled_admission', 'N');		 
         $DB1->group_by('ad.academic_year');
         $result=$DB1->get();
		 //echo $DB1->last_query();exit;
         return $result->result_array();      	
	}
	public function fetch_admission_report_naac($course_id='')
	{         
		 $this->load->database();
		 $DB1 = $this->load->database('umsdb', TRUE);	
         $DB1->select('ad.academic_year,COUNT(ad.student_id) AS totstud,"'.$course_id.'" as course_id');
         $DB1->select("COUNT(ad.student_id) AS totstud, SUM(CASE WHEN ad.cancelled_admission='Y' THEN 1
		             ELSE 0 END) AS cancel_adm");
         $DB1->select('SUM(CASE WHEN ad.academic_year=sm.admission_session and ad.cancelled_admission="N" and ad.academic_year < 2020 and ad.year=1 THEN 1
		WHEN ad.academic_year=sm.admission_session and ad.cancelled_admission="N" and ad.academic_year >=2020 and sm.admission_confirm="Y"  THEN 1
		              ELSE 0 END) AS new_adm');
         $DB1->select('SUM(CASE WHEN ad.academic_year!=sm.admission_session and ad.cancelled_admission="N" and ad.academic_year < 2020 THEN 1
                      WHEN ad.academic_year!=sm.admission_session and ad.cancelled_admission="N" and ad.academic_year >=2020 and sm.admission_confirm="Y" THEN 1
		              ELSE 0 END) AS rr_adm,SUM(CASE WHEN ad.year=v.course_duration THEN 1
		             ELSE 0 END) AS final_year_student,SUM(CASE WHEN ad.year=v.course_duration and sm.degree_completed="Y" then 1
		             ELSE 0 END) AS passout_student');
		 $DB1->from('admission_details as ad');
		 $DB1->join('vw_stream_details as v','v.stream_id=ad.stream_id and is_for_naac="Y"');
		 $DB1->join('student_master as sm','sm.stud_id=ad.student_id and   
                   `sm`.`enrollment_no` != ""','left');
		 
         $DB1->where('v.course_id !=15');	
         $DB1->where('v.course_id !=16');	
		 
	
         //$DB1->where('ad.cancelled_admission', 'N');		 
         $DB1->group_by('ad.academic_year');
         $result=$DB1->get();
		 //echo $DB1->last_query();exit;
         return $result->result_array();      	
	}
	public function fetch_admission_report_phd($course_id='')
	{         
		 $this->load->database();
		 $DB1 = $this->load->database('umsdb', TRUE);	
         $DB1->select('ad.academic_year,COUNT(ad.student_id) AS totstud,"'.$course_id.'" as course_id');
         $DB1->select("COUNT(ad.student_id) AS totstud, SUM(CASE WHEN ad.cancelled_admission='Y' THEN 1
		             ELSE 0 END) AS cancel_adm");
         $DB1->select('SUM(CASE WHEN ad.academic_year=sm.admission_session and ad.cancelled_admission="N"  THEN 1
		WHEN ad.academic_year=sm.admission_session and ad.cancelled_admission="N"   THEN 1
		              ELSE 0 END) AS new_adm');
         $DB1->select('SUM(CASE WHEN ad.academic_year!=sm.admission_session and ad.cancelled_admission="N"  THEN 1
                      WHEN ad.academic_year!=sm.admission_session and ad.cancelled_admission="N"  THEN 1
		              ELSE 0 END) AS rr_adm');
		 $DB1->from('admission_details as ad');
		 $DB1->join('vw_stream_details as v','v.stream_id=ad.stream_id');
		 $DB1->join('student_master as sm','sm.stud_id=ad.student_id and   
                   `sm`.`enrollment_no` != ""','left');
		 if($course_id =='14'){
			$DB1->where('v.course_id !=',15);  
			  
		 }else if($course_id=='15'){
         $DB1->where('v.course_id ='.$course_id.'');	
		 }
		 else if($course_id=='16'){
         //$DB1->where('v.course_id not in ('.$course_id.')');	
         $DB1->where('v.course_id !=15');	
         $DB1->where('v.course_id !=16');	
		 }
		 else
		 {}
	
         //$DB1->where('ad.cancelled_admission', 'N');		 
         $DB1->group_by('ad.academic_year');
         $result=$DB1->get();
		 //echo $DB1->last_query();exit;
         return $result->result_array();      	
	}
	public function fetch_school_coursewise_report($acad_year='',$course_id='')
	 { 
		  $this->load->database();
		  $DB1 = $this->load->database('umsdb', TRUE);
		  if(empty($acad_year) && $acad_year=='')
		  {
			  $acad_year=explode('-',ACADEMIC_YEAR);
			  $acad_year=$acad_year[0];
		  }

		 $DB1->select('ad.academic_year,v.school_short_name, v.course_short_name, v.stream_name,v.stream_id,"'.$course_id.'" as course_id');
		 //$DB1->select('SUM(CASE WHEN ad.academic_year=sm.admission_session and ad.cancelled_admission="N" and sm.admission_confirm="Y" THEN 1 ELSE 0 END) AS new_adm');
		 $DB1->select('SUM(CASE WHEN ad.academic_year=sm.admission_session and ad.cancelled_admission="N" and ad.academic_year < 2020 THEN 1
		WHEN ad.academic_year=sm.admission_session and ad.cancelled_admission="N" and ad.academic_year >=2020 and sm.admission_confirm="Y"  THEN 1
		              ELSE 0 END) AS new_adm');
		// $DB1->select('SUM(CASE WHEN ad.academic_year!=sm.admission_session and ad.cancelled_admission="N" and sm.admission_confirm="Y" THEN 1 ELSE 0 END) AS rr_adm');
		 $DB1->select('SUM(CASE WHEN ad.academic_year!=sm.admission_session and ad.cancelled_admission="N" and ad.academic_year < 2020 THEN 1
                      WHEN ad.academic_year!=sm.admission_session and ad.cancelled_admission="N" and ad.academic_year >=2020 and sm.admission_confirm="Y" THEN 1
		              ELSE 0 END) AS rr_adm');
		 $DB1->from('admission_details as ad');
		 $DB1->join('vw_stream_details as v','v.stream_id=ad.stream_id');
		 $DB1->join('student_master as sm','sm.stud_id=ad.student_id and sm.enrollment_no!=""','left');
		 $DB1->where('ad.academic_year',$acad_year);
		 if($course_id =='14'){
	      $DB1->where('v.course_id !=',15);  
			  
		 }else if($course_id=='15'){
         $DB1->where('v.course_id ='.$course_id.'');	
		 }
		 else if($course_id=='16'){
         //$DB1->where('v.course_id not in ('.$course_id.')');	
         $DB1->where('v.course_id !=15');	
         $DB1->where('v.course_id !=16');	
		 }
		 else
		 {}
		 $DB1->group_by('ad.academic_year,v.school_short_name,v.course_short_name,v.stream_name');
		 $DB1->order_by('ad.academic_year,v.school_short_name,v.course_short_name,v.stream_name');
		 $query=$DB1->get();
         //echo $DB1->last_query();exit;		 
		 return $query->result_array();
		 
	 }
	  public function fetch_school_coursewise_report_phd($acad_year='',$course_id='')
	 { 
		  $this->load->database();
		  $DB1 = $this->load->database('umsdb', TRUE);
		  if(empty($acad_year) && $acad_year=='')
		  {
			  $acad_year=explode('-',ACADEMIC_YEAR);
			  $acad_year=$acad_year[0];
		  }

		 $DB1->select('ad.academic_year,v.school_short_name, v.course_short_name, v.stream_name,v.stream_id,"'.$course_id.'" as course_id');
		 //$DB1->select('SUM(CASE WHEN ad.academic_year=sm.admission_session and ad.cancelled_admission="N" and sm.admission_confirm="Y" THEN 1 ELSE 0 END) AS new_adm');
		 $DB1->select('SUM(CASE WHEN ad.academic_year=sm.admission_session and ad.cancelled_admission="N" THEN 1
		              ELSE 0 END) AS new_adm');
		// $DB1->select('SUM(CASE WHEN ad.academic_year!=sm.admission_session and ad.cancelled_admission="N" and sm.admission_confirm="Y" THEN 1 ELSE 0 END) AS rr_adm');
		 $DB1->select('SUM(CASE WHEN ad.academic_year!=sm.admission_session and ad.cancelled_admission="N"  THEN 1
                      WHEN ad.academic_year!=sm.admission_session and ad.cancelled_admission="N" THEN 1
		              ELSE 0 END) AS rr_adm');
		 $DB1->from('admission_details as ad');
		 $DB1->join('vw_stream_details as v','v.stream_id=ad.stream_id');
		 $DB1->join('student_master as sm','sm.stud_id=ad.student_id and sm.enrollment_no!=""','left');
		 $DB1->where('ad.academic_year',$acad_year);
		 if($course_id =='14'){
	      $DB1->where('v.course_id !=',15);  
			  
		 }else if($course_id=='15'){
         $DB1->where('v.course_id ='.$course_id.'');	
		 }
		 else if($course_id=='16'){
         //$DB1->where('v.course_id not in ('.$course_id.')');	
         $DB1->where('v.course_id !=15');	
         $DB1->where('v.course_id !=16');	
		 }
		 else
		 {}
		 $DB1->group_by('ad.academic_year,v.school_short_name,v.course_short_name,v.stream_name');
		 $DB1->order_by('ad.academic_year,v.school_short_name,v.course_short_name,v.stream_name');
		 $query=$DB1->get();
         //echo $DB1->last_query();exit;		 
		 return $query->result_array();
		 
	 }
	  public function fetch_student_details($acad_year='',$course_id='',$stream_id='',$adm_flg='')
	 {  
		 $this->load->database();
		 $DB1 = $this->load->database('umsdb', TRUE);
		 $acd='';
		 if($acad_year >=2020 && $course_id!='15'){
			$acd ="and sm.admission_confirm='Y'";
		  }

		 	 if($course_id =='14'){
	      $corsid='and v.course_id !=15';  
			  
		 }else if($course_id=='15'){
         $corsid='and v.course_id ='.$course_id.'';	
		 }
		 else if($course_id=='16'){
         $corsid='and v.course_id !=15 and v.course_id !=16';		
		 }
		 else
		 { $corsid=''; }
         $cond="And ad.cancelled_admission= 'N' $acd";
    if(!empty($adm_flg) && $adm_flg!=''){		 
		 if($adm_flg=='N')
         {			 
		 $cond="And ad.cancelled_admission= 'N' $acd and ad.academic_year=sm.admission_session";
		 }
		 elseif($adm_flg=='R')
		 {
		  $cond="And ad.cancelled_admission= 'N' $acd and ad.academic_year!=sm.admission_session";	 
		 }elseif($adm_flg=='P')
		 {
		  $cond="And ad.cancelled_admission= 'N' $acd and ad.year=v.course_duration and sm.academic_year=ad.academic_year";	 
		 }elseif($adm_flg=='DC')
		 {
		  $cond="And ad.cancelled_admission= 'N' $acd and ad.year=v.course_duration and sm.degree_completed='Y'";	 
		 }
		 else
		 {
			$cond="And ad.`cancelled_admission` = 'Y' "; 
		 }	 
        }
		
		if(!empty($stream_id) && $stream_id!=''){

				$strcond="and ad.stream_id='$stream_id'";
			}
            else
			{
				$strcond="";
			}	
		
		 $sql="SELECT adk.cumulative_gpa,sm.degree_completed_year,sm.enrollment_no,sm.religion,sm.admission_cycle,UPPER(CONCAT(COALESCE(sm.first_name,''), ' ',COALESCE(sm.middle_name,''),' ',COALESCE(sm.last_name,''))) AS student_name, ad.academic_year,sm.academic_year as curr_academic_year,sm.lateral_entry, sm.father_fname,sm.gender,sm.category,sm.degree_completed,v.school_short_name,v.course_short_name,v.stream_name,v.course_type,v.programme_code,v.`course_pattern`,v.course_duration,sm.current_semester AS semester,sm.mobile,sm.email,st.state_name,sm.nationality,cc.name AS countryname,sm.admission_session,admission_year,sm.`current_year`,ad.year,sm.`admission_confirm`,sm.`cancelled_admission`,(CASE 
        WHEN ad.year = v.course_duration THEN 'PP' 
        WHEN sm.admission_session = ad.academic_year AND ad.year = 1 THEN 'FE'
        WHEN sm.admission_session = ad.academic_year AND ad.year = 2 THEN 'DSE'
        ELSE 'RR' 
     END) AS admission_flag
		from admission_details ad 
		left join student_master sm on sm.stud_id=ad.student_id AND sm.enrollment_no!='' 
		left join vw_stream_details v on v.stream_id=ad.stream_id 
		LEFT JOIN address_details ads ON ads.student_id=ad.student_id AND ads.adds_of='STUDENT' AND ads.address_type='PERMNT' 
		LEFT JOIN states AS st ON st.state_id=ads.state_id 
		LEFT JOIN district_name AS dt ON dt.district_id=ads.district_id 
		LEFT JOIN taluka_master AS tm ON tm.taluka_id=ads.city 
		LEFT JOIN countries AS cc ON cc.id=ads.country_id 
		left JOIN (select enrollment_no,cumulative_gpa from exam_result_master  where res_master_id IN (   SELECT max(res_master_id) FROM sandipun_ums.exam_result_master
        group by student_id)) as adk on adk.enrollment_no=sm.enrollment_no

		where ad.academic_year='$acad_year' and  sm.`enrollment_no` != ''  $corsid $strcond $cond order by v.school_short_name,v.course_short_name,v.stream_name,ad.year asc";//exit;
     $query=$DB1->query($sql);
	 // echo $DB1->last_query();exit;
	  return $query->result_array();
	   
	 }

 public function fetch_student_details_naac($acad_year='',$course_id='',$stream_id='',$adm_flg='')
	 {  
		 $this->load->database();
		 $DB1 = $this->load->database('umsdb', TRUE);
		 $acd='';
		 if($acad_year >=2020 && $course_id!='15'){
			$acd ="and sm.admission_confirm='Y'";
		  }

		 	 if($course_id =='14'){
	      $corsid='and v.course_id !=15';  
			  
		 }else if($course_id=='15'){
         $corsid='and v.course_id ='.$course_id.'';	
		 }
		 else if($course_id=='16'){
         $corsid='and v.course_id !=15 and v.course_id !=16';		
		 }
		 else
		 { $corsid=''; }
         $cond="And ad.cancelled_admission= 'N' $acd";
    if(!empty($adm_flg) && $adm_flg!=''){		 
		 if($adm_flg=='N')
         {			 
		 $cond="And ad.cancelled_admission= 'N' $acd and ad.academic_year=sm.admission_session";
		 }
		 elseif($adm_flg=='R')
		 {
		  $cond="And ad.cancelled_admission= 'N' $acd and ad.academic_year!=sm.admission_session";	 
		 }elseif($adm_flg=='P')
		 {
		  $cond="And ad.cancelled_admission= 'N' $acd and ad.year=v.course_duration";	 
		 }elseif($adm_flg=='DC')
		 {
		  $cond="And ad.cancelled_admission= 'N' $acd and ad.year=v.course_duration and sm.degree_completed='Y'";	 
		 }
		 else
		 {
			$cond="And ad.`cancelled_admission` = 'Y' "; 
		 }	 
        }
		
		if(!empty($stream_id) && $stream_id!=''){

				$strcond="and ad.stream_id='$stream_id'";
			}
            else
			{
				$strcond="";
			}	
		
		 $sql="SELECT adk.cumulative_gpa,sm.enrollment_no,sm.admission_cycle,UPPER(CONCAT(COALESCE(sm.first_name,''), ' ',COALESCE(sm.middle_name,''),' ',COALESCE(sm.last_name,''))) AS student_name, ad.academic_year,sm.academic_year as curr_academic_year,sm.lateral_entry, sm.father_fname,sm.gender,sm.category,sm.degree_completed,v.school_short_name,v.course_short_name,v.stream_name,v.course_type,v.programme_code,v.`course_pattern`,v.course_duration,sm.current_semester AS semester,sm.mobile,sm.email,st.state_name,sm.nationality,cc.name AS countryname,sm.admission_session,admission_year,sm.`current_year`,ad.year,sm.`admission_confirm`,sm.`cancelled_admission`
		from admission_details ad 
		left join student_master sm on sm.stud_id=ad.student_id AND sm.enrollment_no!='' 
		left join vw_stream_details v on v.stream_id=ad.stream_id and is_for_naac='Y' 
		LEFT JOIN address_details ads ON ads.student_id=ad.student_id AND ads.adds_of='STUDENT' AND ads.address_type='PERMNT' 
		LEFT JOIN states AS st ON st.state_id=ads.state_id 
		LEFT JOIN district_name AS dt ON dt.district_id=ads.district_id 
		LEFT JOIN taluka_master AS tm ON tm.taluka_id=ads.city 
		LEFT JOIN countries AS cc ON cc.id=ads.country_id 
		left JOIN (select enrollment_no,cumulative_gpa from exam_result_master  where res_master_id IN (   SELECT max(res_master_id) FROM sandipun_ums.exam_result_master
        group by student_id)) as adk on adk.enrollment_no=sm.enrollment_no

		where ad.academic_year='$acad_year'  AND (sm.admission_session !='$acad_year' OR ad.year = 1) and  sm.`enrollment_no` != ''  $corsid $strcond $cond order by v.school_short_name,v.course_short_name,v.stream_name,ad.year asc";//exit;
      $query=$DB1->query($sql);
	  //echo $DB1->last_query();exit;
	  return $query->result_array();
	   
	 }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
function get_Marked_Emp_attendance_manual($dt){
	    $d = date_parse_from_format("Y-m-d",$dt);      
        $msearch=$d["month"];
        $ysearch=$d["year"];
		   $chk="select e.fname,e.mname,e.lname,e.gender,a.* from employee_monthly_final_attendance a left join employee_master e on e.emp_id=a.UserId where  month(for_month_year)='$msearch' and year(for_month_year)='$ysearch' and a.month_days!=24";
	
	$query=$this->db->query($chk);
	   $res=$query->result_array();
	   return $res;
   }
   	function updateattendacneDetails($data, $month) {

		$DB1 = $this->load->database('umsdb', TRUE); 
	
		//echo "<pre>";print_r($data);
        $count = count($data['UserId']);
        //echo $count;
        for ($i = 0; $i < $count; $i++) {
			$emp_id = $data['UserId'][$i];	
			$stud_att = $this->get_employee_attendance($emp_id, $month);			
			if(empty($stud_att)){
				$insert_array=array(
					"UserId"=>$data['UserId'][$i],
					"total_present"=>$data['pday'][$i],
					"total"=>$data['pday'][$i],					
					"for_month_year"=>$month.'-01',					
					"inserted_by" => $this->session->userdata("uid"),
					"inserted_date" => date("Y-m-d H:i:s")
					); 
				//echo "<pre>";print_r($insert_array);//exit;
				$this->db->insert("employee_monthly_final_attendance ", $insert_array); 
				//echo$this->db->last_query();exit;
			}
			
            $UserId = $data['UserId'][$i];
			$spk['total_present'] = $data['pday'][$i];
			$spk['total'] = $data['pday'][$i];
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
  function Add_final_status_attendance_manual($data){
	  // print_r($data);
	    $d = date_parse_from_format("Y-m-d", $data['attend_date']);
        $msearch=$d["month"];
        $ysearch=$d["year"];
	             //$this->db->where('UserId',$data['UserId']);
				 $this->db->where('month(for_month_year)',$msearch);
				 $this->db->where('year(for_month_year)',$ysearch);			 
				 $this->db->set('is_final','Y');
	    $updated=$this->db->update('employee_monthly_final_attendance'); 
		// echo $this->db->last_query();exit;
	   if(!empty($updated)&& $updated!=0){
		  return updated;		 
	 }	 
	   
   }


  function update_attendance_sun($day,$emp_id,$attend_date){
	 // $d=date("Y-m-$day",strtotime($attend_date['Intime']));
	  //  $sql="update punching_backup set is_not_consider=1 where USerId=$emp_id and STR_TO_DATE(Intime,'%Y-%m-%d')='$d'";
	 //  $query=$this->db->query( $sql);
	   
	   
	   
	 // echo "<pre>";
	  //print_r($attend_date);
	// echo "</br>";
  }  
  
  function update_employee_att($emp_id,$data){
	  
	   // $msearch=$d["month"];
      //  $ysearch=$d["year"];
		//$data['inserted_by']=$this->session->userdata("uid");
       // $data['inserted_date']=date('Y-m-d H:m:i');	
		$is_data=$this->db->get_where('employee_monthly_final_attendance',array('UserId'=>$data['UserId'],'for_month_year'=>$data['for_month_year'],'is_manual'=>0))->row();
		//echo $this->db->last_query();
		if(empty($is_data)){
			$data['inserted_by']=$this->session->userdata("uid");
            $data['inserted_date']=date('Y-m-d H:m:i');
			$this->db->insert('employee_monthly_final_attendance',$data);
		}
		else{
			$data['updated_by']=$this->session->userdata("uid");
            $data['updated_date']=date('Y-m-d H:m:i');
			$this->db->where('aid',$is_data->aid);
			//$this->db->where('aid',$is_data->aid);
			$this->db->where('is_freezed','N');
	        $updated=$this->db->update('employee_monthly_final_attendance',$data); 
			//$this->db->where('for_month_year',$msearch);
			
		}
		//echo $this->db->last_query();
		//exit;
    //echo "<pre>";
	//print_r($data);
	//echo $emp_id;
	//exit;
  }


  function update_employee_dta_for_working_hours($dt){
	  
			/*$id=$dt['DeviceLogId'];
			$UserId=$dt['UserId'];
			$datte=$dt['datte'];			
			$sql="UPDATE punching_backup 
			SET extra_working_hours = '".$dt['extra_working_hours']."' 
			WHERE Intime LIKE '%$datte%' and UserId='$UserId'";
			$this->db->query($sql);
			
			*/
			
		
		
		
  }

  
 public function getEmployees1All($search_term = '')
	{
		$this->db->select("e.emp_id, e.staff_type, d.profile_pic, e.fname, e.mname, e.lname, e.date_of_birth, e.department, e.designation, e.hiring_type, e.joiningDate, e.emp_status, e.is_disabled, ot.mobileNumber,ot.pemail,ot.oemail");
		$this->db->from('employee_master as e');
		$this->db->join('employe_other_details as ot', 'e.emp_id = ot.emp_id', 'left');
		$this->db->join('employee_document_master as d', 'e.emp_id = d.emp_id', 'left');
		$this->db->where('e.emp_status', 'Y');
		$this->db->where('e.emp_reg', 'N');	
		// Apply search filter if search term is provided
		if (!empty($search_term)) {
			$this->db->group_start();
			$this->db->like('e.emp_id', $search_term);
			$this->db->or_like('CONCAT(e.fname, " ", e.mname, " ", e.lname)', $search_term);
			$this->db->group_end();
		}
	
		$this->db->order_by("e.emp_id", "asc");	
		$query = $this->db->get();		
		return $query->result_array();
		
	}
	

			public function getEmployees1($limit=0, $offset=0, $search_term = '', $department_id = null, $designation_id = null, $staff_type = null)
{
    $this->db->select("e.emp_id, e.staff_type, d.profile_pic, e.fname, e.mname, e.lname, e.date_of_birth,e.department,e.designation,e.emp_school,ot.pemail,ot.oemail,
 dm.department_name, dgm.designation_name, e.hiring_type, e.joiningDate, e.emp_status, e.is_disabled, ot.mobileNumber,e.mail_sent_on");
    $this->db->from('employee_master as e');
    $this->db->join('employe_other_details as ot', 'e.emp_id = ot.emp_id', 'left');
    $this->db->join('employee_document_master as d', 'e.emp_id = d.emp_id', 'left');
    $this->db->join('department_master as dm', 'e.department = dm.department_id', 'left');
    $this->db->join('designation_master as dgm', 'e.designation = dgm.designation_id', 'left');
    $this->db->where('e.emp_status', 'Y');
    $this->db->where('e.emp_reg', 'N');
    $this->db->group_by("e.emp_id");

    if (!empty($department_id)) {
        $this->db->where('e.department', $department_id);
    }

    if (!empty($designation_id)) {
        $this->db->where('e.designation', $designation_id);
    }
	if (!empty($staff_type)) {
        $this->db->where('e.staff_type', $staff_type);
    }

    if (!empty($search_term)) {
        $this->db->group_start();
        $this->db->like('e.emp_id', $search_term);
        $this->db->or_like('CONCAT(e.fname, " ", e.mname, " ", e.lname)', $search_term);
        $this->db->or_like('ot.mobileNumber', $search_term);
        $this->db->or_like('dm.department_name', $search_term);
        $this->db->or_like('dgm.designation_name', $search_term);
        $this->db->or_like('e.hiring_type', $search_term);
        $this->db->group_end();
    }

    if ($limit == -1) {
        $query = $this->db->get();
    } else {
        $this->db->order_by("e.emp_id", "asc");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
    }

    return $query->result_array();
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	function getRegEmployeesxl($department_id = null, $designation_id = null, $search_term = '', $staff_type = null){
		//$this->db->select("e.emp_id, e.fname, dm.department_name, ds.designation_name, e.mname, e.lname, e.date_of_birth, e.department, e.designation, e.hiring_type, e.joiningDate, e.emp_status, e.is_disabled, ot.mobileNumber, er.resign_date , er.reason");
	$this->db->select("e.*,ot.*,sm.state_name, es.pay_band_min as pay_band_min1,es.pay_band_max as pay_band_max1,es.pay_band_gt as pay_band_gt1, bm.bank_ifsc, ctm.city_name as ldist, pctm.city_name as pdist, psm.state_name as pstatename, cm.college_code,dm.department_name, ds.designation_name, er.resign_date");
		$this->db->from('employee_master as e');
		$this->db->join('employe_other_details as ot','ot.emp_id = e.emp_id','left');
		$this->db->join('employee_resignation as er','er.emp_id = e.emp_id','left');
	//	$this->db->join('employee_document_master as d','d.emp_id = e.emp_id','left');
		$this->db->join('department_master as dm', 'e.department = dm.department_id', 'left');
		$this->db->join('designation_master as ds', 'e.designation = ds.designation_id', 'left');
		$this->db->join('state_master as sm', 'ot.lstate = sm.state_id', 'left');
		$this->db->join('state_master as psm', 'ot.pstate = sm.state_id', 'left');
		$this->db->join('college_master as cm', 'e.emp_school = cm.college_id', 'left');
		$this->db->join('city_master as ctm', 'ot.ldist = ctm.city_id', 'left');
		$this->db->join('city_master as pctm', 'ot.pdist = pctm.city_id', 'left');
		$this->db->join('bank_master as bm', 'ot.bank_name = bm.bank_id', 'left');
		$this->db->join('employee_salary_structure as es','es.emp_id = e.emp_id','left');
		$this->db->where('e.emp_reg','Y');
		$this->db->order_by("e.emp_id", "asc");
		$this->db->group_by("e.emp_id");
		//echo $this->db->last_query();exit;
	if (!empty($department_id)) {
        $this->db->where('e.department', $department_id);
    }
    if (!empty($designation_id)) {
        $this->db->where('e.designation', $designation_id);
    }
    if (!empty($staff_type)) {
        $this->db->where('e.staff_type', $staff_type);
    }

    if (!empty($search_term)) {
        $this->db->group_start();
        $this->db->like('e.emp_id', $search_term);
        $this->db->or_like('CONCAT(e.fname, " ", e.mname, " ", e.lname)', $search_term);
        $this->db->or_like('ot.mobileNumber', $search_term);
        $this->db->or_like('dm.department_name', $search_term);
        $this->db->or_like('ds.designation_name', $search_term);
        $this->db->or_like('e.hiring_type', $search_term);
        $this->db->group_end();
    }

    $query = $this->db->get();
    return $query->result_array();
}
//////////////////////////////////////////////////


public function getEmployeesInactXl($department_id = null, $designation_id = null, $search_term = '', $staff_type = null)
{
   // $this->db->select("e.*,ot.*,ot.mobileNumber");
	//$this->db->select("e.*.ot.*,sm.state_name,ctm.city_name as ldist ,pctm.city_name as pdist,psm.state_name as pstatename,cm.college_code,dm.department_name,ds.designation_name,ot.mobileNumber");
	$this->db->select("e.*, ot.*, sm.state_name, es.pay_band_min as pay_band_min1,es.pay_band_max as pay_band_max1,es.pay_band_gt as pay_band_gt1 , bm.bank_ifsc, ctm.city_name as ldist, pctm.city_name as pdist, psm.state_name as pstatename, cm.college_code, dm.department_name, ds.designation_name, ot.mobileNumber");

    $this->db->from('employee_master as e');
    $this->db->join('employe_other_details as ot', 'e.emp_id = ot.emp_id', 'left');
	$this->db->join('department_master as dm', 'e.department = dm.department_id', 'left');
	$this->db->join('designation_master as ds', 'e.designation = ds.designation_id', 'left');
	$this->db->join('state_master as sm', 'ot.lstate = sm.state_id', 'left');
	$this->db->join('state_master as psm', 'ot.pstate = sm.state_id', 'left');
	$this->db->join('college_master as cm', 'e.emp_school = cm.college_id', 'left');
	$this->db->join('city_master as ctm', 'ot.ldist = ctm.city_id', 'left');
	$this->db->join('city_master as pctm', 'ot.pdist = pctm.city_id', 'left');
	$this->db->join('bank_master as bm', 'ot.bank_name = bm.bank_id', 'left');
	$this->db->join('employee_salary_structure as es','es.emp_id = e.emp_id','left');
    $this->db->where('e.emp_status', 'N');
    $this->db->where('e.emp_reg', 'N');
    $this->db->order_by("e.emp_id", "asc");
	$this->db->group_by("e.emp_id");
	//echo $this->db->last_query();exit;
	if (!empty($department_id)) {
        $this->db->where('e.department', $department_id);
    }
    if (!empty($designation_id)) {
        $this->db->where('e.designation', $designation_id);
    }
    if (!empty($staff_type)) {
        $this->db->where('e.staff_type', $staff_type);
    }

    if (!empty($search_term)) {
        $this->db->group_start();
        $this->db->like('e.emp_id', $search_term);
        $this->db->or_like('CONCAT(e.fname, " ", e.mname, " ", e.lname)', $search_term);
        $this->db->or_like('ot.mobileNumber', $search_term);
        $this->db->or_like('dm.department_name', $search_term);
        $this->db->or_like('ds.designation_name', $search_term);
        $this->db->or_like('e.hiring_type', $search_term);
        $this->db->group_end();
    }

    $query = $this->db->get();
    return $query->result_array();
}
/////////////////////////////////////////////////////


public function getEmployeesxl($department_id = null, $designation_id = null, $search_term = '', $staff_type = null)
{
    $this->db->select("e.*, ot.*, sm.state_name, es.pay_band_min as pay_band_min1, es.pay_band_max as pay_band_max1, es.pay_band_gt as pay_band_gt1, bm.bank_ifsc, ctm.city_name as ldist, pctm.city_name as pdist, psm.state_name as pstatename, cm.college_code, ot.mobileNumber, dm.department_name, ds.designation_name");
    $this->db->from('employee_master as e');
    $this->db->join('employe_other_details as ot', 'e.emp_id = ot.emp_id', 'left');
    $this->db->join('department_master as dm', 'e.department = dm.department_id', 'left');
    $this->db->join('designation_master as ds', 'e.designation = ds.designation_id', 'left');
    $this->db->join('state_master as sm', 'ot.lstate = sm.state_id', 'left');
    $this->db->join('state_master as psm', 'ot.pstate = psm.state_id', 'left');
    $this->db->join('college_master as cm', 'e.emp_school = cm.college_id', 'left');
    $this->db->join('city_master as ctm', 'ot.ldist = ctm.city_id', 'left');
    $this->db->join('city_master as pctm', 'ot.pdist = pctm.city_id', 'left');
	$this->db->join('bank_master as bm', 'ot.bank_name = bm.bank_id', 'left');
	$this->db->join('employee_salary_structure as es','es.emp_id = e.emp_id','left');
    $this->db->where('e.emp_status', 'Y');
    $this->db->where('e.emp_reg', 'N');
    $this->db->order_by("e.emp_id", "asc");
    $this->db->group_by("e.emp_id");

    if (!empty($department_id)) {
        $this->db->where('e.department', $department_id);
    }
    if (!empty($designation_id)) {
        $this->db->where('e.designation', $designation_id);
    }
    if (!empty($staff_type)) {
        $this->db->where('e.staff_type', $staff_type);
    }

    if (!empty($search_term)) {
        $this->db->group_start();
        $this->db->like('e.emp_id', $search_term);
        $this->db->or_like('CONCAT(e.fname, " ", e.mname, " ", e.lname)', $search_term);
        $this->db->or_like('ot.mobileNumber', $search_term);
        $this->db->or_like('dm.department_name', $search_term);
        $this->db->or_like('ds.designation_name', $search_term);
        $this->db->or_like('e.hiring_type', $search_term);
        $this->db->group_end();
    }

    $query = $this->db->get();
    return $query->result_array();
}



public function getEmployeesNAll($search_term = '')
{
    $this->db->select("e.emp_id,  e.staff_type, d.profile_pic, e.fname, e.mname, e.lname, e.date_of_birth, e.department, e.designation, e.hiring_type, e.joiningDate, e.emp_status, e.is_disabled, ot.mobileNumber");
    $this->db->from('employee_master as e');
    $this->db->join('employe_other_details as ot', 'e.emp_id = ot.emp_id', 'left');
    $this->db->join('employee_document_master as d', 'e.emp_id = d.emp_id', 'left');
    $this->db->join('department_master as dm', 'e.department = dm.department_id', 'left');
    $this->db->join('designation_master as ds', 'e.designation = ds.designation_id', 'left');
    $this->db->where('e.emp_status', 'N');
    $this->db->where('e.emp_reg', 'N');

    // Apply search filter if search term is provided
    if (!empty($search_term)) {
        $this->db->group_start();
        $this->db->like('e.emp_id', $search_term);
        $this->db->or_like('CONCAT(e.fname, " ", e.mname, " ", e.lname)', $search_term);
        // Add additional fields for search if needed
        // Example: $this->db->or_like('ot.mobileNumber', $search_term);
        $this->db->group_end();
    }

    $this->db->order_by("e.emp_id", "asc");

    $query = $this->db->get();
    
    return $query->result_array();
}

public function getEmployeesN($limit, $offset, $search_term = '', $department_id = null, $designation_id = null, $staff_type = null)
{
    $this->db->select("e.emp_id, e.staff_type, d.profile_pic, e.fname, e.mname, e.lname, e.date_of_birth, dm.department_name, dgm.designation_name, e.hiring_type, e.joiningDate, e.emp_status, e.is_disabled, ot.mobileNumber");
    $this->db->from('employee_master as e');
    $this->db->join('employe_other_details as ot', 'e.emp_id = ot.emp_id', 'left');
    $this->db->join('employee_document_master as d', 'e.emp_id = d.emp_id', 'left');
    $this->db->join('department_master as dm', 'e.department = dm.department_id', 'left');
    $this->db->join('designation_master as dgm', 'e.designation = dgm.designation_id', 'left');
    $this->db->where('e.emp_status', 'N');
    $this->db->where('e.emp_reg', 'N');
	$this->db->group_by("e.emp_id");

    if (!empty($department_id)) {
        $this->db->where('e.department', $department_id);
    }

    if (!empty($designation_id)) {
        $this->db->where('e.designation', $designation_id);
    }

    if (!empty($staff_type)) {
        $this->db->where('e.staff_type', $staff_type);
    }

    if (!empty($search_term)) {
        $this->db->group_start();
        $this->db->like('e.emp_id', $search_term);
        $this->db->or_like('CONCAT(e.fname, " ", e.mname, " ", e.lname)', $search_term);
        $this->db->or_like('ot.mobileNumber', $search_term);
        $this->db->or_like('dm.department_name', $search_term);
        $this->db->or_like('dgm.designation_name', $search_term);
        $this->db->or_like('e.hiring_type', $search_term);
        $this->db->group_end();
    }

    
    if ($limit == -1) {
        $query = $this->db->get();
    } else {
        $this->db->order_by("e.emp_id", "asc");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
    }
  
    if ($query) {
        return $query->result_array();
    } else {
       
        return array();
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



/////////////////////
public function getRegEmployeesAll($search_term = '')
{
    $this->db->select("e.emp_id, e.staff_type, e.fname, d.profile_pic, e.mname, e.lname, e.date_of_birth, e.department, e.designation, e.hiring_type, e.joiningDate, e.emp_status, e.is_disabled, ot.mobileNumber, er.resign_date , er.reason");
    $this->db->from('employee_master as e');
    $this->db->join('employe_other_details as ot','ot.emp_id = e.emp_id','left');
    $this->db->join('employee_resignation as er','er.emp_id = e.emp_id','left');
    $this->db->join('employee_document_master as d','d.emp_id = e.emp_id','left');
    $this->db->where('e.emp_reg','Y');

  
    if (!empty($search_term)) {
        $this->db->group_start();
        $this->db->like('e.emp_id', $search_term);
        $this->db->or_like('CONCAT(e.fname, " ", e.mname, " ", e.lname)', $search_term);
        $this->db->group_end();
    }

    $this->db->order_by("e.emp_id", "asc");

    $query = $this->db->get();
    return $query->result_array();
}



public function getRegEmployees($limit, $offset, $search_term = '', $department_id = null, $designation_id = null, $staff_type = null)
{
    $this->db->select("e.emp_id, e.staff_type, d.profile_pic, e.fname, e.mname, e.lname, e.date_of_birth, dm.department_name, dgm.designation_name, e.hiring_type, e.joiningDate, e.emp_status, e.is_disabled, ot.mobileNumber, er.resign_date ,er.reason");
    $this->db->from('employee_master as e');
    $this->db->join('department_master as dm', 'e.department = dm.department_id', 'left');
    $this->db->join('designation_master as dgm', 'e.designation = dgm.designation_id', 'left');
    $this->db->join('employe_other_details as ot', 'ot.emp_id = e.emp_id', 'left');
    $this->db->join('employee_resignation as er', 'er.emp_id = e.emp_id', 'left');
    $this->db->join('employee_document_master as d', 'd.emp_id = e.emp_id', 'left');
    $this->db->where('e.emp_reg', 'Y');
	$this->db->group_by("e.emp_id");

    if (!empty($department_id)) {
        $this->db->where('e.department', $department_id);
    }

    if (!empty($designation_id)) {
        $this->db->where('e.designation', $designation_id);
    }

    if (!empty($staff_type)) {
        $this->db->where('e.staff_type', $staff_type);
    }

    if (!empty($search_term)) {
        $this->db->group_start();
        $this->db->like('e.emp_id', $search_term);
        $this->db->or_like('CONCAT(e.fname, " ", e.mname, " ", e.lname)', $search_term);
        $this->db->or_like('ot.mobileNumber', $search_term);
        $this->db->or_like('dm.department_name', $search_term);
        $this->db->or_like('dgm.designation_name', $search_term);
        $this->db->or_like('e.hiring_type', $search_term);
        $this->db->group_end();
    }

    if ($limit == -1) {
        $query = $this->db->get();
    } else {
        $this->db->order_by("e.emp_id", "asc");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
    }
  
    if ($query) {
        return $query->result_array();
    } else {
       
        return array();
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	
	function countAllEmployees() {
		$this->db->from('employee_master');
		$this->db->where('emp_status', 'Y'); 
		return $this->db->count_all_results();
	}
	
	
	
	public function getDepartments() {
		$this->db->order_by('department_name', 'asc'); // Replace 'column_name' with the actual column you want to order by
        $query = $this->db->get('department_master');
        return $query->result_array();
    }

	public function getDesignations() {
		$this->db->order_by('designation_name', 'asc'); // Replace 'column_name' with the actual column you want to order by
		$query = $this->db->get('designation_master');
		return $query->result_array();
	}

	public function getEmpType() {
		$this->db->order_by('emp_cat_name', 'asc');
	
        $query = $this->db->get('employee_category');
        return $query->result_array();
    }

	////////////////////////NAD report data/////////
	 function fetch_stud_curr_exam_ecr(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("e.exam_month,e.exam_year,e.exam_id,e.exam_type");
		$DB1->from('exam_session e');
		//$DB1->join('marks_entery_date as m','m.exam_id = e.exam_id','left');
		//$DB1->where("e.active_for_exam", 'Y');
		$DB1->order_by("e.exam_id", 'desc');
		$query=$DB1->get();
		$result=$query->result_array();
		return $result;
	}
	
	
		function fetch_student_grade_data($data = '')
{
    $exam_session = $data['exam_session'];
    $stream_id = $data['admission-branch'];
    $semester = $data['semester'];
    $exam_sess = explode('-', $exam_session);	
    $exam_id = $exam_sess[2];
    $lim = '';

    if ($data['lstart'] != '') {
        $lim = "LIMIT " . $data['lstart'];
    }
	if($stream_id=='116' || $stream_id=='119' || $stream_id=='170'){
		$tbl="grade_policy_details_pharma";
	}else{
		$tbl="grade_policy_details";
	}
    $sql = "SELECT
    e.stream_id,
    e.res_master_id,
    sm.stud_id,
    'Sandip University' AS ORG_NAME,
    v.stream_short_name AS ACADEMIC_COURSE_ID,
    v.course_name,
    v.stream_name,
    v.programme_code,
    sm.enrollment_no AS REGN_NO,
    sm.enrollment_no AS RROLL,
    UPPER(CONCAT_WS(' ', sm.first_name, sm.middle_name, sm.last_name)) AS CNAME,
    sm.gender,
    sm.dob,
    sm.father_fname AS FNAME,
    sm.mother_name AS MNAME,
    e.credits_earned,
    e.cumulative_gpa AS RESULT,
    e.sgpa,
    e.exam_year AS YEAR,
    e.exam_month AS MONTH,
    sm.current_semester AS semester,
    sm.abc_no,
    sm.belongs_to,
    es.exam_type
FROM
    sandipun_ums.exam_result_master e
LEFT JOIN sandipun_ums.student_master sm
    ON sm.stud_id = e.student_id
LEFT JOIN sandipun_ums.exam_session es
    ON e.exam_id = es.exam_id
LEFT JOIN sandipun_ums.vw_stream_details v
    ON v.stream_id = sm.admission_stream
	#LEFT JOIN sandipun_ums.stream_grade_criteria st ON st.stream_id = e.stream_id 
	#LEFT JOIN sandipun_ums.$tbl gp ON gp.rule = st.grade_rule  
    
	WHERE e.exam_id = ? ";// gp.grade_point AS gp,

    $params = array($exam_id);	

    if ($stream_id != '') {
        $sql .= "AND e.stream_id = ? ";
        $params[] = $stream_id;
    }

    if ($semester != '') {
        $sql .= "AND e.semester = ? ";
        $params[] = $semester;
    }

    $sql .= $lim;

    $query = $this->db->query($sql, $params);
	//echo $this->db->last_query();exit;
    $res = $query->result_array();
    return $res;
}



	 function fetch_subject_data($enrollment_no,$sem='',$exam_id='',$stream_id='')
	{
		if($stream_id=='116' || $stream_id=='119' || $stream_id=='170'){
		$tbl="grade_policy_details_pharma";
		}else{
			$tbl="grade_policy_details";
		}
	  $sql="select s.subject_code, s.subject_name, s.theory_max, s.theory_min_for_pass,s.practical_max,s.sub_max,s.sub_min,e.cia_marks as optd_cia_marks,e.exam_marks as optd_th_marks,e.practical_marks as optd_pr_marks,e.final_garde_marks ,e.final_grade,s.credits as subj_credits,gp.grade_point, s.credits * gp.grade_point as subgradepoints  from sandipun_ums.exam_result_data e 
     join sandipun_ums.subject_master s on s.sub_id=e.subject_id 
	 LEFT JOIN sandipun_ums.stream_grade_criteria st ON st.stream_id=e.stream_id 
	 LEFT JOIN sandipun_ums.$tbl gp ON gp.rule=st.grade_rule and e.final_grade=gp.grade_letter
     where  exam_id='$exam_id' and e.semester='$sem' and enrollment_no='$enrollment_no'";
	 $query=$this->db->query($sql);
	 return $query->result_array();
	}
	
	  function fetch_credit_data($enrollment_no,$sem='',$exam_id='',$stream_id='')
	{
		if($stream_id=='116' || $stream_id=='119' || $stream_id=='170'){
		$tbl="grade_policy_details_pharma";
		}else{
			$tbl="grade_policy_details";
		}
	  $sql="select s.credits as subj_credits,sum(s.credits) as subj_tot_credits,gp.grade_point, s.credits * gp.grade_point as subgradepoints, sum(s.credits * gp.grade_point)as subj_tot_credit_points from sandipun_ums.exam_result_data e 	
     join sandipun_ums.subject_master s on s.sub_id=e.subject_id 	
	 LEFT JOIN sandipun_ums.stream_grade_criteria st ON st.stream_id=e.stream_id 
	 LEFT JOIN sandipun_ums.$tbl gp ON gp.rule=st.grade_rule and e.final_grade=gp.grade_letter
     where exam_id='$exam_id' and e.semester='$sem' and enrollment_no='$enrollment_no'";
	 $query=$this->db->query($sql);
	 return $query->result_array();
	} 
	
	
	function fetch_employee_data_for_transfer($data=''){
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
			$sub1 .= "emp_id IN ('".$estr."') ";
		}

	  $sql ="Select emp_id,CONCAT(fname,' ',mname,' ',lname) as empname FROM employee_master where $sub1 group by emp_id";	
	  $query=$this->db->query($sql);
	  return $value=$query->result_array();	
   }
   
   
   public function updatemultiEmpresigndet($empsid, $res_date,$reason)
   {	
    if (!empty($empsid) && !empty($res_date) && !empty($reason)) {
 
        foreach ($empsid as $emp_id) {
            $data['emp_id']=$emp_id;
			$data['resign_date']=$res_date;
			$data['reason']=$reason;
			$data['entry_by ']=$this->session->userdata("uid");
			$data['entry_on ']=date("Y-m-d H:i:s");
			$this->db->insert('employee_resignation', $data);
			$id=$this->db->insert_id() ;
			if($id>0){
        
        	 $this->db->where('username',$emp_id);       
             $this->db->set('status','N');       		
             $this->db->set('updated_by',$this->session->userdata("uid"));    
             $this->db->set('updated_datetime',date("Y-m-d H:i:s"));		 
             $id = $this->db->update('user_master');
             
             $this->db->where('emp_id',$emp_id);       
             $this->db->set('emp_reg','Y');       		
             $this->db->set('updated_by',$this->session->userdata("uid"));    
             $this->db->set('updated_datetime',date("Y-m-d H:i:s"));		 
             $id1 = $this->db->update('employee_master');
           }
        }
    }
    return ($this->db->affected_rows() != 1) ? false : true;
  }

public function fetch_visiting_faculty_lecture_att($ddate='')
  { 
    $acad_year=ACADEMIC_YEAR;

	  if($ddate=='')
	  {
		$ddate = date('Y-m');
	  }else{
		 $ddate = date('Y-m', strtotime('01-' . $ddate));
	  }
      $this->load->model('Subject_model');
      $role_id = $this->session->userdata('role_id');
	  $emp_id = $this->session->userdata("name");
	  if(isset($role_id) && $role_id==44){
			  $empsch = $this->Subject_model->loadempschool($emp_id);
			  $schid= $empsch[0]['school_code'];
			  $sch=" AND v.school_code = $schid";
		 }
	  $DB1 = $this->load->database('umsdb', TRUE);
			  $sql="SELECT DISTINCT l.attendance_date, l.slot, sm.from_time, sm.to_time, sm.slot_am_pm, sm.duration AS no_of_hours,  s.subject_code, 
    s.subject_name, s.subject_component,l.division,  l.batch, v.stream_name, f.fname, f.mname, f.lname, f.emp_id,l.is_nt_c as consideration_status,s.sub_id,l.stream_id, 
	l.academic_year 
	FROM lecture_attendance l
	JOIN subject_master s ON s.sub_id = l.subject_id
	LEFT JOIN lecture_slot sm ON sm.lect_slot_id = l.slot
	LEFT JOIN vw_stream_details v ON v.stream_id = l.stream_id
	LEFT JOIN vw_faculty f ON f.emp_id = l.faculty_code
	WHERE l.academic_year = '$acad_year' 
    AND l.attendance_date like '%$ddate%'
    AND l.faculty_code IN (
        SELECT emp_id 
        FROM faculty_master 
        WHERE emp_status = 'Y'
    ) $sch
    ORDER BY 
    l.attendance_date, 
    sm.lect_slot_id, 
    l.subject_id, 
    l.faculty_code";//exit;
//echo $sql;exit;
	$query=$DB1->query($sql);
	 return $query->result_array();
  }
  

  
}