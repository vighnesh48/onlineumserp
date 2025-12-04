<?php
class Faculty_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
	
   	function add_nem_employee($data,$doc,$temp){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$arr['emp_id']=(stripcslashes($data['FacultyID'])); 
		$arr['fname']=(stripcslashes($data['fname']));
		$arr['mname']=(stripcslashes($data['mname']));
		$arr['lname']=(stripcslashes($data['lname']));
		
		$arr['date_of_birth']=(stripcslashes(date('Y-m-d',strtotime($data['date_of_birth']))));
		$arr['gender']=(stripcslashes($data['gender']));
		$arr['blood_gr']=(stripcslashes($data['blood_gr']));
		$arr['staff_type']=(stripcslashes($data['staff_type']));
		$arr['adhar_no']=(stripcslashes($data['adhar_no']));
		$arr['pan_card_no']=(stripcslashes($data['pan_no']));
		$arr['emp_school']=(stripcslashes($data['emp_school']));
		$arr['designation']=(stripcslashes($data['designation']));
		$arr['department']=(stripcslashes($data['department']));
		$arr['mobile_no']=stripslashes(($data['mobile'])); 
		$arr['email_id']=stripslashes(($data['email_id'])); 
		$arr['profile_photo']=stripslashes(($doc['profile_pic'])); 
		$arr['category']=(stripcslashes($data['category']));
		$arr['cast']=(stripcslashes($data['cast']));
		$arr['sub-cast']=(stripcslashes($data['sub-cast']));
		$arr['punching_applicable']=(stripcslashes($data['punching_applicable']));
		$arr['is_payable']=(stripcslashes($data['is_payable']));
		
		$arr['pay_type']=(stripcslashes($data['pay_type']));
		$arr['no_of_lectures']=(stripcslashes($data['no_of_lectures']));
		$arr['amount_payable']=(stripcslashes($data['amount_payable']));
		if($arr['pay_type']=='hourly'){
			$arr['amount_per_hour']=(stripcslashes($data['amount_per_hour']));			
		}else{
			$arr['amount_per_hour']=null;		
	
		}
        $arr['ta_applicable']=(stripcslashes($data['ta_applicable']));
        $arr['ta_amount']=(stripcslashes($data['ta_amount'])); 
         $arr['ta_tot_days']=(stripcslashes($data['ta_tot_days']));		
		$arr['inserted_by']=$this->session->userdata("uid");
		$arr['inserted_datetime']=date("Y-m-d H:i:s");
		$arr['emp_status']='Y';
		/////////Account Details 
        $arr['bank_acc_no']=(stripcslashes($data['bank_acc_no']));
		$arr['bank_id']=(stripcslashes($data['bank_name']));
		$arr['acc_holder_name']=(stripcslashes($data['acc_holder_name']));
		$arr['branch_name']=(stripcslashes($data['branch_name']));
		$arr['ifsc_code']=(stripcslashes($data['ifsc_code']));
		///////////////////////
		$DB1->insert('faculty_master',$arr);
		$insert_id1 = $DB1->insert_id();
		
		//user master 
		$temp['roles_id']='13';
		$temp['inserted_by']=$this->session->userdata("uid");
		$temp['inserted_datetime']=date("Y-m-d H:i:s");
		$this->db->insert('user_master',$temp);

		//local address
		$address['adds_of']='FACULTY'; 
		$address['address_type']='CORS'; 
		$address['address']=stripslashes(($data['laddress'])); 
	//	$address['street']=stripslashes(($data['bill_B'])); 
		$address['city']=stripslashes(($data['lcity'])); 
		$address['state_id']=stripslashes(($data['lstate_id'])); 
		$address['district_id']=stripslashes(($data['ldistrict_id'])); 
		$address['pincode']=stripslashes(($data['lpincode']));
		$address['student_id']=$arr['emp_id'];
		$address['created_by']=$this->session->userdata("uid");
		$address['created_on']=date("Y-m-d H:i:s");		
		
		$DB1->insert('address_details',$address);
		$insert_id2 = $DB1->insert_id();
		return $insert_id2;
	}
	function checkEmployeeIDAvailable($id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql ="select * from faculty_master where emp_id='".$id."'";	   
		$query = $DB1->query($sql);		
		$result=$query->result_array();
		return $result;	
		
	}
	function getFacultynewId(){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql ="SELECT MAX(CAST(emp_id AS UNSIGNED)) + 1 AS emp_id
FROM `faculty_master`
WHERE emp_id != '' AND emp_id REGEXP '^[0-9]+$' ";	   
		$query = $DB1->query($sql);		
		$result=$query->result_array();
		return $result;	
		
	}
	function update_faculty($data,$doc){
		
		$DB1 = $this->load->database('umsdb', TRUE); 
		$arr['emp_id']=(stripcslashes($data['FacultyID'])); 
		$arr['fname']=(stripcslashes($data['fname']));
		$arr['mname']=(stripcslashes($data['mname']));
		$arr['lname']=(stripcslashes($data['lname']));
		
		$arr['date_of_birth']=(stripcslashes(date('Y-m-d',strtotime($data['date_of_birth']))));
		$arr['gender']=(stripcslashes($data['gender']));
		$arr['blood_gr']=(stripcslashes($data['blood_gr']));
		$arr['staff_type']=(stripcslashes($data['staff_type']));
		$arr['adhar_no']=(stripcslashes($data['adhar_no']));
		$arr['pan_card_no']=(stripcslashes($data['pan_no']));
		$arr['emp_school']=(stripcslashes($data['emp_school']));
		$arr['designation']=(stripcslashes($data['designation']));
		$arr['department']=(stripcslashes($data['department']));
		$arr['mobile_no']=stripslashes(($data['mobile']));
		$arr['category']=(stripcslashes($data['category']));
		$arr['cast']=(stripcslashes($data['cast']));
		$arr['sub-cast']=(stripcslashes($data['sub-cast']));		
		$arr['email_id']=stripslashes(($data['email_id'])); 
		if(!empty($doc['profile_pic'])){
			$arr['profile_photo']=stripslashes(($doc['profile_pic'])); 
		}
		$arr['punching_applicable']=(stripcslashes($data['punching_applicable']));
		$arr['is_payable']=(stripcslashes($data['is_payable']));
		
		$arr['pay_type']=(stripcslashes($data['pay_type']));
		$arr['no_of_lectures']=(stripcslashes($data['no_of_lectures']));
		$arr['amount_payable']=(stripcslashes($data['amount_payable']));
		if($arr['pay_type']=='hourly'){
			$arr['amount_per_hour']=(stripcslashes($data['amount_per_hour']));			
		}else{
			$arr['amount_per_hour']=null;		
	
		}
		$arr['ta_applicable']=(stripcslashes($data['ta_applicable']));
        $arr['ta_amount']=(stripcslashes($data['ta_amount']));
		$arr['ta_tot_days']=(stripcslashes($data['ta_tot_days']));
		/////////Account Details 
        $arr['bank_acc_no']=(stripcslashes($data['bank_acc_no']));
		$arr['bank_id']=(stripcslashes($data['bank_name']));
		$arr['acc_holder_name']=(stripcslashes($data['acc_holder_name']));
		$arr['branch_name']=(stripcslashes($data['branch_name']));
		$arr['ifsc_code']=(stripcslashes($data['ifsc_code']));
		///////////////////////
		$arr['updated_by']=$this->session->userdata("uid");
		$arr['updated_datetime']=date("Y-m-d H:i:s");
		$DB1->where('emp_id',$arr['emp_id']);
		$DB1->update('faculty_master',$arr);
		
		//local address
		$address['adds_of']='FACULTY'; 
		$address['address_type']='CORS'; 
		$address['address']=stripslashes(($data['laddress'])); 
	//	$address['street']=stripslashes(($data['bill_B'])); 
		$address['city']=stripslashes(($data['lcity'])); 
		$address['state_id']=stripslashes(($data['lstate_id'])); 
		$address['district_id']=stripslashes(($data['ldistrict_id'])); 
		$address['pincode']=stripslashes(($data['lpincode']));
		
		$DB1->where('student_id',$arr['emp_id']);
		$DB1->update('address_details',$address);
		//echo $DB1->last_query(); exit;
		return true;
	}
	// fetch faculty list
	function getFacultyList($offSet=0,$limit=1){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql ="select * from sandipun_ums.vw_faculty";
		//$sql ="select * from sandipun_erp.employee_master where staff_type =3 UNION select * from sandipun_ums.faculty_master";
		$sql .=" order by emp_id asc";
		//$this->db->limit($limit, $offSet);
		//$DB1->order_by("f.emp_id", "asc");
	   
		$query = $DB1->query($sql);
		 //echo $DB1->last_query();
		 /* die();   */  
		$result=$query->result_array();
		return $result;
	}
	//
	function getFacultyById($id,$flg){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql= "select e.*,st.emp_cat_name,s.college_name,ds.designation_name,de.department_name from faculty_master as e 
		left join sandipun_erp.employee_category as st ON st.emp_cat_id = e.staff_type
		left join sandipun_erp.college_master as s ON s.college_id = e.emp_school
		left join sandipun_erp.designation_master as ds ON ds.designation_id = e.designation
		left join sandipun_erp.department_master as de ON de.department_id = e.department
		where e.emp_id= '$id'";
		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();
		//die();   
		$result= $query->result_array();
		return $result;
	}
	
	function getFacultyAddr($id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql= "select a.*,st.state_name,d.district_name,t.taluka_name from address_details as a 
		left join states as st ON st.state_id = a.state_id
		left join district_name as d ON d.district_id = a.district_id
		left join taluka_master as t ON t.taluka_id = a.city
		where a.student_id= '$id'";		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();
		//die();   
		$result= $query->result_array();
		return $result;
	}
	   // added on 250917
	function getEmployeeById($id,$flg){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select e.*,e.joiningDate as jd,d.district_name,ad.pincode,state.state_name,t.taluka_name,e.emp_id as eid,e.referenceID as rid,ot.*,d.*,st.emp_cat_name,ds.designation_name, de.department_name,s.college_name,ad.address,u.password from faculty_master as e
		left join sandipun_erp.employe_other_details as ot on ot.emp_id = e.emp_id 
		left join sandipun_erp.employee_document_master as d on d.emp_id = e.emp_id
		left join sandipun_erp.designation_master as ds on ds.designation_id = e.designation
		left join sandipun_erp.employee_category as st on st.emp_cat_id = e.staff_type
		left join sandipun_erp.department_master as de on de.department_id = e.department
		left join sandipun_erp.college_master as s on s.college_id = e.emp_school
		left join address_details as ad ON ad.student_id = e.emp_id
		left join district_name as d ON d.district_id = ad.district_id
		left join taluka_master as t ON t.taluka_id = ad.city
		left join states as state ON state.state_id = ad.state_id
		left join sandipun_erp.user_master as u ON u.username = e.emp_id
		where e.emp_id ='$id' AND e.emp_status ='$flg'";
		
		//echo $sql;exit;
		$query = $DB1->query($sql);
		$result=$query->result_array();
		return $result;
	}
	// enable / disable employee status
	 function changeEmployeeStatus($id,$flg){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->query("SET SQL_SAFE_UPDATES=0;");
		
		if($flg=='Y'){
			$DB1->set('emp_status','N');
		  }elseif($flg=='R'){
			$DB1->set('emp_resign','Y');	
		}elseif($flg=='N'){	
		$DB1->set('emp_status','Y');
		}
		$DB1->where('emp_id',$id);
	    $DB1->update('faculty_master');
	    
		
	    return ($DB1->affected_rows() != 1) ? false : true;
		
	}
	
	// fetch Visiting faculty list
	function getVisitorFacultyList(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("uid");
		$sql ="select * from faculty_master Where 1 ";	//where emp_status='Y' 	
		$rl_id =array(1,6,48,33);
		if(!in_array($role_id,$rl_id)){
			//echo "inside";
			$sql .="and inserted_by='$emp_id'";
		}
		$sql .="order by emp_id desc";
		$query = $DB1->query($sql);
		// echo $sql;exit;
		$result=$query->result_array();
		return $result;
	}
	function getcategorylist(){
		$sql="select caste_code,caste_name from caste_master where status='y'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	// fetch faculty list from lecture timetable
	function getFacultyList_from_lt($data){
		$DB1 = $this->load->database('umsdb', TRUE);
		$emp_name = trim($data['emp_name']);
		$academic_year = $data['academic_year'];
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		if($emp_name==''){
		$sql ="select f.*,t.semester,v.stream_name,t.faculty_code from lecture_time_table t 
		left join vw_faculty f on t.faculty_code=f.emp_id
		left join vw_stream_details v on v.stream_id = t.stream_id
		";
		
		$stream_id = $data['stream_id'];
		$semester= $data['semester'];
		
        $where=" WHERE t.stream_id='$stream_id' AND t.semester='".$semester."'  and t.academic_year='$acd_yr[0]' AND t.academic_session='$cur_ses' and t.faculty_code is not null";
		$sql .=" $where group by t.faculty_code order by faculty_code asc";
		}else{
			$sql ="select f.*,t.semester,v.stream_name,t.faculty_code from lecture_time_table t 
		left join vw_faculty f on t.faculty_code=f.emp_id
		left join vw_stream_details v on v.stream_id = t.stream_id
		";
		 $where=" WHERE t.academic_year='$acd_yr[0]' AND t.academic_session='$cur_ses' and (`fname` LIKE '%$emp_name%' || `mname` LIKE '%$emp_name%' || `lname` LIKE '%$emp_name%') and t.faculty_code is not null";
		$sql .=" $where group by t.faculty_code,t.stream_id,semester order by faculty_code asc";
		}
		$query = $DB1->query($sql);
		// echo $DB1->last_query();
		$result=$query->result_array();
		return $result;
	}

     function getFacultyList_from_qp($straeam, $academicyear){
		$DB1 = $this->load->database('umsdb', TRUE);
		//$academic_year = $data['academic_year'];
		$acd_yr = explode('~',$academicyear);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$sql ="select f.*,t.semester,v.stream_name,t.faculty_code from lecture_time_table t 
		left join vw_faculty f on t.faculty_code=f.emp_id
		left join vw_stream_details v on v.stream_id = t.stream_id
		";
		 $where=" WHERE t.academic_year='$acd_yr[0]' AND t.academic_session='$cur_ses'  and t.stream_id = '$straeam' and t.faculty_code is not null and f.fname is not null";
		 $sql .=" $where group by t.faculty_code order by faculty_code asc";
		//}
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;
	}	
	
	     public function getAllBank() {
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->select("*");
			$DB1->where('active', 'Y');
			$query = $DB1->get('bank_master'); 
			return $query->result_array(); // Returns a single row
		}
		
		
		///////////////Visiting SALARY
		 function getAcademic_year(){
			$this->load->database();
				$DB1 = $this->load->database('umsdb', TRUE);    
				$DB1->select("academic_year");
				$DB1->from('academic_year');    
				$DB1->where('currently_active', 'Y');     
				$query = $DB1->get();
			 $res=$query->result_array();
			 return $res;	 
		   }
		   
		    function getAcademic_session(){
			$this->load->database();
				$DB1 = $this->load->database('umsdb', TRUE);    
				$DB1->select("academic_session");
				$DB1->from('academic_session');    
				$DB1->where('currently_active', 'Y');     
				$query = $DB1->get();
			 $res=$query->result_array();
			 return $res;	 
		   }
		   
		function getVisitingEmployees(){
			$this->load->database();
				$DB1 = $this->load->database('umsdb', TRUE);    
				$DB1->select("e.emp_id, CONCAT(e.fname, ' ', e.mname, ' ', e.lname) AS fullname", FALSE);
				$DB1->from('faculty_master as e');    
				$DB1->where('e.emp_status', 'Y');     
				$DB1->order_by("CONCAT(e.fname, ' ', e.mname, ' ', e.lname)", "ASC", FALSE);    
				$query = $DB1->get();
			 $res=$query->result_array();
			 return $res;	 
		   }  

		/* public function insert_faculty_sub_approval_det($data)
	  {
		$DB1 = $this->load->database('umsdb', TRUE);
		$sd = $DB1->get_where('faculty_subject_approval_details', ['sub_id' => $data['sub_id'],'academic_year' => $data['academic_year'],'academic_session' => $data['academic_session'],'faculty_code' => $data['faculty_id']])->row_array();

		if (empty($sd)) {
			// Convert object to an array and add the inserted_on field
              $indata['sub_id']=$data['sub_id'];
              $indata['faculty_code']=$data['faculty_id'];
              $indata['pay_type']=$data['pay_type'];
              $indata['th_amount']=$data['th_amount'];
              $indata['pr_amount']=$data['pr_amount'];
              $indata['no_of_lectures']=$data['no_of_lectures'];
              $indata['amount_payable']=$data['amount_payable'];
              $indata['academic_year']=$data['academic_year'];
              $indata['academic_session']=$data['academic_session'];
              $indata['inserted_by']=$this->session->userdata("uid");
              $indata['inserted_on']=date('Y-m-d H:i:s');
			  $DB1->insert('faculty_subject_approval_details', $indata);
			  $id=$DB1->insert_id() ;
			if($id>0){
            echo json_encode(["status" => "success", "message" => "New Details Added Successfully!"]);
				} else {
					echo json_encode(["status" => "error", "message" => "No changes were made."]);
				}
		   } else {
				echo json_encode(["status" => "error", "message" => "Already inserted."]);
			}
	    } */
		
				public function insert_faculty_sub_approval_det($data)
{
    $DB1 = $this->load->database('umsdb', TRUE);

    $sd = $DB1->get_where('faculty_subject_approval_details', [
        'sub_id' => $data['sub_id'],
        'academic_year' => $data['academic_year'],
        'academic_session' => $data['academic_session'],
        'faculty_code' => $data['faculty_id']
    ])->row_array();

    $updateData = [
        'sub_id' => $data['sub_id'],
        'faculty_code' => $data['faculty_id'],
        'pay_type' => $data['pay_type'],
        'th_amount' => $data['th_amount'],
        'pr_amount' => $data['pr_amount'],
        'no_of_lectures' => $data['no_of_lectures'],
        'amount_payable' => $data['amount_payable'],
        'academic_year' => $data['academic_year'],
        'academic_session' => $data['academic_session'],
    ];

    if (empty($sd)) {
        $updateData['inserted_by'] = $this->session->userdata("uid");
        $updateData['inserted_on'] = date('Y-m-d H:i:s');

        $DB1->insert('faculty_subject_approval_details', $updateData);
        $id = $DB1->insert_id();

        if ($id > 0) {
            echo json_encode(["status" => "success", "message" => "New Details Added Successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Insert failed."]);
        }
    } else {
        $updateData['updated_by'] = $this->session->userdata("uid");
        $updateData['updated_on'] = date('Y-m-d H:i:s');
        $DB1->where('sub_id', $data['sub_id']);
        $DB1->where('academic_year', $data['academic_year']);
        $DB1->where('academic_session', $data['academic_session']);
        $DB1->where('faculty_code', $data['faculty_id']);

        $updated = $DB1->update('faculty_subject_approval_details', $updateData);

        if ($updated) {
            echo json_encode(["status" => "success", "message" => "Details Updated Successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "No changes were made during update."]);
        }
    }
}
		   function fetch_faculty_allocated_subjectlist($curr_session, $academic_year,$emp_id){
                $DB1 = $this->load->database('umsdb', TRUE);
                $arr_faq = array();
        
                if($curr_session!=''){
					if ($curr_session == 'WINTER') {
							$cursession = "WIN";
					} else {
							$cursession = "SUM";
					}
                }
                $sql = "SELECT DISTINCT 
                                        t.subject_code AS subject_id,
                                        t.subject_type,
                                        t.batch_no AS batch,
                                        t.division,
                                        s.subject_code AS sub_code,
                                        s.subject_short_name,
                                        s.subject_name,
                                        vw.stream_short_name,
                                        t.semester,
                                        t.stream_id,t.academic_session,t.academic_year, 
										t.faculty_code,fa.pay_type,fa.no_of_lectures,fa.amount_payable,fa.th_amount,fa.pr_amount
                                FROM lecture_time_table AS t 
                                LEFT JOIN subject_master s ON s.sub_id = t.subject_code AND s.is_active='Y' 
                                LEFT JOIN vw_stream_details vw ON vw.stream_id = t.stream_id
                                LEFT JOIN faculty_subject_approval_details fa ON fa.sub_id = t.subject_code and fa.faculty_code = t.faculty_code
                                WHERE t.faculty_code='".$emp_id."' 
                                AND t.is_active='Y' 
                                AND t.academic_session IN ('".$cursession."') 
                                AND t.academic_year='".$academic_year."'
							    group by  t.subject_code";
							 
                $query = $DB1->query($sql);
                return $query->result_array();
	   }
	   
	   
	   public function fetch_visiting_faculty_lecture_att($ddate='')
         { 
			$acad_year=ACADEMIC_YEAR;
		    list($year, $month) = explode('-', $ddate);

			$totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$monthName = date("F", mktime(0, 0, 0, $month, 1));

			$startDate = "$year-$month-01";
			$endDate = "$year-$month-$totalDays";
			
			$attnd= "AND l.attendance_date BETWEEN '$startDate' AND '$endDate'";
				
			$DB1 = $this->load->database('umsdb', TRUE); 
			$sql="SELECT DISTINCT l.attendance_date,l.subject_id,l.semester, l.slot, sm.from_time, sm.to_time, sm.slot_am_pm, sm.duration AS no_of_hours,  s.subject_code, s.subject_name,COALESCE(lt.subject_type, alt.subject_type) AS subject_component,l.division,  l.batch, v.stream_name, f.fname, f.mname, f.lname, f.emp_id,f.college_code,fa.ta_tot_days,fd.no_of_lectures as total_approval_lectures,fd.amount_payable,
            CASE WHEN pb.status = 'Present' THEN 'Present'  ELSE 'Absent' END AS present_status,l.academic_year,l.academic_session			
			FROM sandipun_ums.lecture_attendance l
			LEFT JOIN sandipun_ums.subject_master s ON s.sub_id = l.subject_id
			LEFT JOIN sandipun_ums.lecture_slot sm ON sm.lect_slot_id = l.slot
			LEFT JOIN sandipun_ums.vw_stream_details v ON v.stream_id = l.stream_id
			LEFT JOIN sandipun_ums.vw_faculty f ON f.emp_id = l.faculty_code
			LEFT JOIN sandipun_ums.faculty_master fa ON fa.emp_id = l.faculty_code
			LEFT JOIN sandipun_ums.faculty_subject_approval_details fd ON fd.faculty_code = l.faculty_code and fd.sub_id=l.subject_id 
			LEFT JOIN sandipun_erp.punching_backup pb ON pb.UserId = l.faculty_code AND DATE(pb.Intime) = STR_TO_DATE(l.attendance_date, '%Y-%m-%d')
			LEFT JOIN sandipun_ums.lecture_time_table AS lt ON lt.subject_code = l.subject_id AND lt.wday = DAYNAME(l.attendance_date)
			LEFT JOIN sandipun_ums.alternet_lecture_time_table AS alt ON alt.subject_code = l.subject_id AND alt.dt_date = l.attendance_date
			WHERE l.academic_year = '$acad_year'  AND (l.is_nt_c IS NULL OR l.is_nt_c != 1 OR l.is_nt_c = '' OR l.is_nt_c = 0) 
			$attnd
			AND l.faculty_code IN (select emp_id FROM faculty_master WHERE is_payable='Y' AND emp_status='Y' AND emp_resign='N')
			group by l.faculty_code,l.attendance_date,l.slot
			ORDER BY 
			l.attendance_date,
			sm.lect_slot_id, 
			l.subject_id, 
			l.faculty_code";
			// echo $sql;exit; //AND l.faculty_code IN (662716)
			//echo $sql;exit;('662639','662649','662657','662658','662660','662663','662671','662696','662697','662698','662699','662700','662396','662623','662654','662656','662665','662666','662668','662701','662703','662704','662705','662707','662673','662709','662710','662711','662641','662712','662713','662714','662715')
			$query=$DB1->query($sql);
			return $query->result_array();
        }
		
			public function update_final_status_visiting($data){
				$DB1 = $this->load->database('umsdb', TRUE);
				$val2['is_final_status']='Y';	
				$val2['updated_on']=date('Y-m-d H:i:s');
				$val2['updated_by']=$this->session->userdata("uid");
				$DB1->where('for_month_year',$data['sdate']);	
				return $DB1->update('visiting_monthly_lecturewise_details',$val2);
		
			}
			public function check_visiting_monthly_lecturewisesalary_details($sal_monyr) {
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->select("COUNT(*) as total");
			$DB1->where('for_month_year', $sal_monyr);
			$DB1->where('is_final_status', 'Y');
			$query = $DB1->get('visiting_monthly_lecturewise_details'); 
			//echo $DB1->last_query();exit;
			return $query->row_array(); // Returns a single row
		}
		public function getVisitingSalForMonth($for_month='')
		{
			$acad_year=ACADEMIC_YEAR; 
			$DB1 = $this->load->database('umsdb', TRUE);
			/* $sql="SELECT v.emp_code,v.total_payable,v.tot_th_count,v.tot_pr_count,v.ta_days_count,fd.pay_type,fd.no_of_lectures,fd.th_amount,fd.pr_amount, fd.amount_payable,concat(vw.fname,' ',vw.mname,' ',vw.lname) as fullname,vw.college_code,fa.bank_acc_no,fa.acc_holder_name,fa.bank_id,ba.bank_name,fa.ifsc_code as bank_ifsc,fa.branch_name,fa.ta_amount as rate_of_ta			
			FROM visiting_overall_sal_details v
			LEFT JOIN faculty_subject_approval_details fd ON fd.faculty_code = v.emp_code
			LEFT JOIN vw_faculty vw ON vw.emp_id = v.emp_code
			LEFT JOIN faculty_master fa ON fa.emp_id = v.emp_code
			LEFT JOIN bank_master ba ON ba.bank_id = fa.bank_id
			WHERE 
			v.for_month_year ='$for_month' AND fd.academic_year='$acad_year'
			AND v.emp_code IN (select emp_id FROM faculty_master WHERE is_payable='Y' AND emp_status='Y' AND emp_resign='N')
			group by v.emp_code"; */ 
            $sql="SELECT 
						v.emp_code,
						CONCAT(vw.fname,' ',vw.mname,' ',vw.lname) AS fullname,
						vw.college_code,

						-- overall summary from visiting_overall_sal_details
						v.total_payable,
						v.tot_th_count,
						v.tot_pr_count,
						v.ta_days_count,

						-- total subjectwise amount (pre-aggregated subquery)
						sub.subject_total_amount,

						-- bank details
						fa.bank_acc_no,
						fa.acc_holder_name,
						fa.bank_id,
						ba.bank_name,
						fa.ifsc_code AS bank_ifsc,
						fa.branch_name,
						fa.ta_amount AS rate_of_ta

					FROM visiting_overall_sal_details v
					JOIN (
						SELECT 
							vld.emp_code,
							SUM((vld.th_count * fd.th_amount) + (vld.pr_count * fd.pr_amount)) AS subject_total_amount
						FROM faculty_subject_approval_details fd
						JOIN visiting_monthly_lecturewise_details vld 
							ON fd.sub_id = vld.sub_id
						   AND fd.faculty_code = vld.emp_code
						   AND fd.academic_year = vld.academic_year
						   AND fd.academic_session = vld.academic_session
						WHERE vld.for_month_year = '$for_month'
						  AND fd.academic_year = '$acad_year'
						GROUP BY vld.emp_code
					) sub ON sub.emp_code = v.emp_code
					JOIN vw_faculty vw ON vw.emp_id = v.emp_code
					JOIN faculty_master fa ON fa.emp_id = v.emp_code
					JOIN bank_master ba ON ba.bank_id = fa.bank_id

					WHERE 
						v.for_month_year = '$for_month'
						AND v.emp_code IN (
							SELECT emp_id 
							FROM faculty_master 
							WHERE is_payable='Y' AND emp_status='Y' AND emp_resign='N'
						)

					ORDER BY v.emp_code"; 
			$query=$DB1->query($sql);
			//echo $DB1->last_query();exit;
			return $query->result_array();
		}
		public function insert_visiting_monthly_salary_data($data)
		{
			$DB1 = $this->load->database('umsdb', TRUE);
		   return $DB1->insert('visiting_monthly_salary_details', $data);
		}
		
       public function check_generated_monthly_VisitingSal_data($saldate) {
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->select("COUNT(*) as total");
			$DB1->where('month_of_sal', $saldate);
			$query = $DB1->get('visiting_monthly_salary_details'); 
			///echo $DB1->last_query();exit;
			return $query->row_array(); // Returns a single row
		} 
		
	/* 	public function get_generated_monthly_VisitingSal_data($saldate) {
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->select("*");
			$DB1->where('month_of_sal', $saldate);
			$query = $DB1->get('visiting_monthly_salary_details'); 
			return $query->result_array(); // Returns a single row
		} */
		
			public function get_generated_monthly_VisitingSal_data($saldate) {
			$DB1 = $this->load->database('umsdb', TRUE);

			$DB1->select('vmsd.*, fm.pan_card_no');
			$DB1->from('visiting_monthly_salary_details vmsd');
			$DB1->join('faculty_master fm', 'fm.emp_id = vmsd.emp_code', 'left');
			$DB1->where('vmsd.month_of_sal', $saldate);

			$query = $DB1->get();
			return $query->result_array();
		}
		//////////////////////////////
}