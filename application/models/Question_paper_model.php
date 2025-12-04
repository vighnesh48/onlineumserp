<?php
class Question_paper_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
	
   	function add_nem_qp($data){

		$DB1 = $this->load->database('umsdb', TRUE); 
		//	print_r($data);
		$DB1->insert('question_paper',$data);
		//echo "stringssss";exit;
		//echo $DB1->last_query(); exit;
		$insert_id = $DB1->insert_id();
		return $insert_id;
	}

	function add_nem_qp_log($data){

		$DB1 = $this->load->database('umsdb', TRUE); 
		//	print_r($data);
		$DB1->insert('question_paper_log',$data);
		//echo "stringssss";exit;
		//echo $DB1->last_query(); exit;
		$insert_id = $DB1->insert_id();
		return $insert_id;
	}

	function add_nem_qp_docs($data){
        //print_r($_FILES['scandoc']['name']);exit;
		$DB1 = $this->load->database('umsdb', TRUE); 
		//	print_r($data);
		$DB1->insert('question_paper_sets',$data);
		//echo "stringssss";exit;
		//echo $DB1->last_query(); exit;
		//$insert_id = $DB1->insert_id();
		//return $insert_id;
	}
	function update_qp_sets_docs($data,$arr1){
		$DB1 = $this->load->database('umsdb', TRUE); 
		

		$qp_id = $data['qp_id'];
		if (count($data['doc_id']) > 0) {

			
            for ($i = 1; $i <= count($data['doc_id']); $i++) {
            	//echo 44;
                if(isset($arr1[$i]) && $arr1[$i] != ''){
            	$data ['qp_id'] = $qp_id;
            	$data ['created_by'] = $qp_id;
            	//$data ['created_by'] = $qp_id;
            	$doc_id = $data['doc_id'][$i];
	                if(!empty($arr1[$i])){
	                	//print_r($data['doc_id']);exit;
						$data1['doc_path'] = str_replace(" ","_",$arr1[$i]);
						$data1['updated_at'] = date("Y-m-d H:i:s");
					}
			     $DB1->where('id', $doc_id);   			
			     $DB1->where('qp_id', $qp_id);   			
				 $DB1->update('question_paper_sets', $data1);
				 //echo $DB1->last_query(); exit;
				}

            }
            $datac['check_list1'] = $data ['check_list1'];
            $datac['check_list2'] = $data ['check_list2'];
            $datac['check_list3'] = $data ['check_list3'];
            $datac['check_list4'] = $data ['check_list4'];
            $datac['check_list5'] = $data ['check_list5'];
            $datac['check_list6'] = $data ['check_list6'];   			
			$DB1->where('id', $qp_id);   			
		    $DB1->update('question_paper', $datac);
		    //echo $DB1->last_query(); exit;

        }
		return true;
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
		$sql ="SELECT max(emp_id)+1 as emp_id FROM `faculty_master` where emp_status='Y'";	   
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
		$DB1->where('emp_id',$id);
		if($flg=='Y'){
			$DB1->set('emp_status','N');
		  }elseif($flg=='R'){
			$DB1->set('emp_resign','Y');	
		}elseif($flg=='N'){	
		$DB1->set('emp_status','Y');
		}
	    $DB1->update('faculty_master');
	    $DB1->where('username',$id);
		
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

	function getFacultyList_from_qpold($data){
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

	function getFacultyList_from_qp($straeam, $academicyear, $semesterId){
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

	function get_faculty_subject_list($fid = ''){

		$DB1 = $this->load->database('umsdb', TRUE);
		
		$sql ="select qp.*, s.*,vf.*  from question_paper qp 
		 join subject_master s on s.sub_id=qp.subject_id
		 join vw_faculty as vf on vf.emp_id = qp.faculty_id 
		 
		";
		if($fid != ''){
		 $where=" WHERE qp.faculty_id = '$fid'";
	     $sql .=" $where  order by qp.id desc";
	 }
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		 $results=$query->result();
		 //echo '<pre>';
         //print_r($results);exit;
         //$mainresult  = array();
		 foreach($results as $row){
		  $row->doc_details = $this->get_qp_data_docs($row->id);
		 // $mainresult = array_merge($result,$mainresult);
		 	//$row['id']=1234;
		 	//$row->id=4444;

	    }
	     //echo '<pre>';

	     $results = json_decode(json_encode($results), true);
         //print_r($results);exit;

		return $results;

	}

	function get_qp_data($qp_id){

		$DB1 = $this->load->database('umsdb', TRUE);
		
		$sql ="select * from question_paper where id = '$qp_id'
		";
		 /*$where=" WHERE qp.faculty_id = '$fid'";
	     $sql .=" $where";*/
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;

	}

	function get_qp_data_docs($qp_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql ="select * from question_paper_sets where qp_id = '$qp_id'
		";
		 /*$where=" WHERE qp.faculty_id = '$fid'";
	     $sql .=" $where";*/
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;
	}

	function update_qp_status($data){
		//print_r($data);exit;
		$DB1 = $this->load->database('umsdb', TRUE); 
		$data1['coe_satatus'] = $data['status']; 			
		$DB1->where('id', $data['qp_id']);
		    			
		$DB1->update('question_paper', $data1);
        
		if($DB1->affected_rows() >=0){
		  return 1; //add your code here
		 }else{
		  return 0; //add your your code here
		}

	}


	function update_qp_comment($data){
		//print_r($data);exit;
		$DB1 = $this->load->database('umsdb', TRUE); 
		$data1['comment'] = $data['comment']; 			
		$DB1->where('id', $data['qp_id']);
		    			
		$DB1->update('question_paper', $data1);
        
		if($DB1->affected_rows() >=0){
		  return 1; //add your code here
		 }else{
		  return 0; //add your your code here
		}

	}

	function update_setter_qp_comment($data){
		//print_r($data);exit;
		$DB1 = $this->load->database('umsdb', TRUE); 
		$data1['setter_comment'] = $data['setter_comment']; 			
		$DB1->where('id', $data['qp_id']);
		    			
		$DB1->update('question_paper', $data1);
        
		if($DB1->affected_rows() >=0){
		  return 1; //add your code here
		 }else{
		  return 0; //add your your code here
		}

	}


	function get_qp_details($order_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
        $sql ="select qp.*,f.*,v.*,sm.*  from  question_paper qp 
		left join vw_faculty f on qp.faculty_id=f.emp_id
		left join subject_master  sm on qp.subject_id=sm.sub_id
		left join vw_stream_details v on v.stream_id = qp.stream_id  where
		 qp.order_id = '$order_id'";
		//$where=" WHERE t.academic_year='$acd_yr[0]' AND t.academic_session='$cur_ses'  and t.stream_id = '$straeam' and t.faculty_code is not null and f.fname is not null";
	//	$sql .=" $where group by t.faculty_code order by faculty_code asc";
		//}
		 
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		//count($result);exit;
		return $result;
	}

	function get_qp_check_list(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql ="select * from qp_checklist_master";
		 /*$where=" WHERE qp.faculty_id = '$fid'";
	     $sql .=" $where";*/
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;
	}

	function get_qp_report_details(){
		$DB1 = $this->load->database('umsdb', TRUE); 
        $sql ="select qp.*,f.*  from  question_paper qp 
		left join vw_faculty f on qp.faculty_id=f.emp_id
	    group by qp.faculty_id

		";
		//$where=" WHERE t.academic_year='$acd_yr[0]' AND t.academic_session='$cur_ses'  and t.stream_id = '$straeam' and t.faculty_code is not null and f.fname is not null";
	//	$sql .=" $where group by t.faculty_code order by faculty_code asc";
		//}
		 
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		//count($result);exit;
		return $result;
	}

	function get_qp_faculy_data($id){
        $DB1 = $this->load->database('umsdb', TRUE); 
        $sql ="select sum(no_of_sets)as count,sum(no_of_sets*price_per_set) as total,course_type from  question_paper qp 
	    where qp.faculty_id = '$id' group by qp.course_type";
		$query = $DB1->query($sql);
		$result=$query->result_array();
		return $result;
	}
	function get_faculty_details($empid){
		 $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="select email_id from vw_faculty where emp_id='$empid'";
		$query = $DB1->query($sql);
		$result=$query->result_array();
		return $result;
	}
}