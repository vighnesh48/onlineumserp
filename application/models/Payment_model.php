<?php
class Payment_model extends CI_Model {
 
    function __construct() {
        parent::__construct();
		$db=$this->load->database();
		$this->load->library('session');
		date_default_timezone_set('Asia/Kolkata');
		//var_dump($_SESSION);
    }
	// check login details
	function get_user($user='',$pass='')
    {
        $getCon = $this->db->query("SELECT * FROM login_master WHERE username='".$user."' AND password='".$pass."'");
        $conRes = $getCon->result();
		//echo $this->db->last_query();exit;
        return $conRes;
    }	
	
	function facility_fee_details($fcid,$acyear,$org)
   {
       //$DB1 = $this->load->database('umsdb',TRUE);
    //   echo $org."******";
       if($org=="SU" || $org=="SF")
       {
        $campus="NASHIK";   
       }
       else
       {
     $campus="SIJOUL";    
           
       }
         $acy =  substr($acyear,-2);
      $ny = $acy+1;
      $year = $acyear."-".$ny;
        $this->db->select('sffm.*');
        $this->db->from('sf_facility_fees_master sffm');
         $this->db->join('sf_facility_category sfc','sffm.category_id=sfc.cat_id','left');
        $this->db->where('sffm.facility_type_id',$fcid);
        $this->db->where('sffm.academic_year','2021');
         $this->db->where('sfc.campus_name',$campus);
	     $this->db->where('sffm.status','Y');
       $query =  $this->db->get();
	//echo $this->db->last_query();
       return $query->result_array();
   }
   
   
   
   
   
   function insert_data_in_trans($data=array(),$stud_id='',$txnid='',$amount='',$deposit=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		
		$data_array=array();
		$data_array['txtid'] =$txnid;
		$data_array['student_id']=$stud_id;
		$data_array['firstname'] =$data['firstname'];
		$data_array['registration_no'] =$data['prn_no'];
		$data_array['academic_year'] =$data['hidac_year'];
		if(empty($_POST['email'])){
	    $data_array['email']  ='kiran.valimbe@sandipuniversity.edu.in';
        }else{
	    $data_array['email'] =$data['email'];
        }
		//$data_array['receipt_no'] =$vat;
		
		$data_array['aadhar_card']=$data['adhar_card_no'];
	    $data_array['amount'] =$amount;
		$data_array['deposite_amount'] =$deposit;
		$data_array['facility_id']=$data['fc_id'];
		$data_array['phone']=$data['Mobile'];
		$data_array['productinfo']=$data['productinfo'];
		$data_array['org_frm'] =$data['org_frm'];
		$data_array['added_on'] =date("Y-m-d h:i:s");
		if(!empty($data) && $stud_id!='' && $txnid!=''){
	   
		$this->db->insert('online_payment_facilities',$data_array);
		return $this->db->insert_id(); 
	    }
		else{
			
			return 0;
		}
	}
	function fetch_payment_details_data($id='')
	{
	//	$DB1 = $this->load->database('umsdb', TRUE); 
	    /*$this->db->select('*');
        $this->db->from('online_payment_facilities');
		$this->db->where('payment_id',$id);
		$this->db->where('payment_status','success');
		$query =  $this->db->get();
	//echo $this->db->last_query();
       return $query->result_array();*/
	return $student_data=$this->db->get_where('online_payment_facilities',array('payment_id'=>$id,'payment_status'=>'success'))->result();
	}
	
	
	
	function fetch_payment_details_data_test($id='')
	{
	//	$DB1 = $this->load->database('umsdb', TRUE); 
	    $this->db->select('*');
        $this->db->from('online_payment_facilities');
		$this->db->where('payment_id',$id);
		$this->db->where('payment_status','success');
		
		$query =  $this->db->get();
		$this->db->close();
	//echo $this->db->last_query();
       return $query->result_array();
	  
		//return $student_data=$this->db->get_where('online_payment_facilities',array('payment_id'=>$id,'payment_status'=>'success'))->result();
	}
	
	function update_online_admissiondetails($data)
  {
		//  $DB1 = $this->load->database('umsdb', TRUE);    
		//  print_r($data);
		//	exit();
     $fdet['txtid']=$data['txnid'];
     $fdet['receipt_no']=$data['udf4'];
		// $fdet['registration_no']=$data['registration_no'];
		// $fdet['academic_year']='2021';
		// $fdet['student_id']=$data['udf1'];
		// $fdet['firstname']=$data['firstname'];
		// $fdet['email']=$data['email'];
		// $fdet['phone']=$data['udf3'];
		// $fdet['productinfo']=$data['productinfo'];
		// $fdet['amount']=$data['amount'];
		// $fdet['payment_date']=$data['addedon'];
     $fdet['payment_status']=$data['status'];
     $fdet['error_code']=$data['error'];
     $fdet['pg_type']=$data['PG_TYPE'];
     $fdet['payment_mode']=$data['mode'];
     $fdet['bank_ref_num']=$data['bank_ref_num'];
     $fdet['error_message']=$data['error_Message'];
	 $fdet['verification_status']='N';
		// print_r($fdet);
		// exit();
     $this->db->where('payment_id', $data['udf2']); 
		//$this->db->where('email', $data['email']);
     $this->db->update('online_payment_facilities',$fdet); 
    }
	
	
	
	function update_sf_faclitiy($pay){
		
		 // $check_su=$this->check_su_pnr_new($pay[0]->registration_no,'2021');
		 // print_r($check_su);
		 // if(empty($check_su)){
		 // $this->db->insert("sf_student_master", $student_list); 
		{
	        $stud['student_id']=$pay[0]->student_id;
			$stud['enrollment_no']=$pay[0]->registration_no;
			$stud['aadhar_card']=$pay[0]->aadhar_card;
			$stud['organisation']=$pay[0]->org_frm;
			$stud['year']='1';
		    $stud['academic_year']='2021';
			$stud['sffm_id']=$pay[0]->facility_id;
			// $stud['deposit_fees']=$sub['deposit'];
			// $stud['actual_fees']=$sub['fees'];
			$stud['actual_fees']=$pay[0]->amount;
			// $stud['excemption_fees']='';
			$stud['deposit_fees']=$pay[0]->deposite_amount;
			// $stud['gym_fees']=$_POST['gym_fees'];
			// $stud['fine_fees']=$_POST['pending_balance'];
			// $stud['opening_balance']=$_POST['opening_balance'];
			
			$stud['status']='Y';
			// $stud['created_by']=$_SESSION['uid'];
			$stud['created_on']=date("Y-m-d H:i:s");
			$stud['created_ip']=$_SERVER['REMOTE_ADDR'];
			$stud['online_remark']='Online payment';
			// print_r($stud); exit();
		$this->db->insert('sf_student_facilities',$stud);
					}
	}
	 public function check_su_pnr_new($enrollment_no,$year)
    {
		
        $DB1 = $this->load->database('s_erp', TRUE);
		
        $DB1->select('*');
        $DB1->from('sf_student_facilities');
        $DB1->where('enrollment_no',$enrollment_no);
		$DB1->where('academic_year',$year);
		$DB1->where('status','Y');
		 	$query =  $DB1->get();
			//echo $DB1->last_query();
		//$this->db->close();
	//echo $DB1->last_query();
       return $query->result_array();
        //$this->db->where('op.verification_status','N');
       // $this->db->where('op.is_deleted','N');
        //$this->db->order_by('op.payment_id', 'DESC');
		
        
	  //echo 'one';exit;
      //  return $this->db->count_all_results();
    }
	
	function update_sf_faclitiy_test($pay){
		$DB3 = $this->load->database('s_erp', TRUE);
	       $check_su=$this->check_su_pnr_new($pay[0]['registration_no'],'2021');
		 // print_r($check_su);
		// print_r($pay[0]['registration_no']); exit();
		   if(empty($check_su)){
					//$this->db->insert("sf_student_master", $student_list); 
		//print_r($pay[0]['registration_no']);
	        $stud['student_id']=$pay[0]['student_id'];
			$stud['enrollment_no']=$pay[0]['registration_no'];
			$stud['aadhar_card']=$pay[0]['aadhar_card'];
			$stud['organisation']=$pay[0]['org_frm'];
			$stud['year']='1';
		    $stud['academic_year']='2021';
			$stud['sffm_id']=$pay[0]['facility_id'];
			//$stud['deposit_fees']=$sub['deposit'];
			//$stud['actual_fees']=$sub['fees'];
			$stud['actual_fees']=($pay[0]['amount'] - $pay[0]['deposite_amount']);
			//$stud['excemption_fees']='';
			$stud['deposit_fees']=$pay[0]['deposite_amount'];
			//$stud['gym_fees']=$_POST['gym_fees'];
			//$stud['fine_fees']=$_POST['pending_balance'];
			//$stud['opening_balance']=$_POST['opening_balance'];
			
			$stud['status']='Y';
			//$stud['created_by']=$_SESSION['uid'];
			$stud['created_on']=date("Y-m-d H:i:s");
			$stud['created_ip']=$_SERVER['REMOTE_ADDR'];
			$stud['online_remark']='Online payment';
		// print_r($stud); exit();
	  //$DB3->insert('sf_student_facilities',$stud);
					}
	}
	 
	
 
	
	function fail_payment($udf1){
	  
	   $DB1 = $this->load->database('umsdb', TRUE);
	    $student_id=$udf1;
		
		$sql="insert into temp_student_master(first_name,lateral_entry,current_semester,admission_semester,admission_year,current_year,email,adhar_card_no,category,mobile,admission_stream,admission_school,admission_session,academic_year,created_on,studentid) select first_name,lateral_entry,current_semester,admission_semester,admission_year,current_year,email,adhar_card_no,category,mobile,admission_stream,admission_school,admission_session,academic_year,created_on,stud_id from student_master where stud_id='$student_id'";
	 $query = $DB1->query($sql);
		
		
		
		
		
		
	
	  $DB2 = $this->load->database('umsdb', TRUE);
	  
	 $sql1="DELETE FROM `admission_details` WHERE `student_id`='$student_id'";
	 $query1 = $DB2->query($sql1);
    
	  
     $sql2="DELETE FROM `address_details` WHERE `student_id`='$student_id'";
	 $query2 = $DB2->query($sql2);
	 
	// $DB4 = $this->load->database('umsdb', TRUE);
     $sql3="DELETE FROM `student_qualification_details` WHERE `student_id`='$student_id'";
     $query3 = $DB2->query($sql3);
   
    // $DB5 = $this->load->database('umsdb', TRUE);
     $sql4="DELETE FROM student_master WHERE stud_id='$student_id'";
     $query4 = $DB2->query($sql4);
   }
   
	function getverify_payment_exam($transdate, $exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);

		$DB1->select('op.payment_id, op.txtid');
		$DB1->from('online_payment op');
		$DB1->where('op.productinfo', 'Examination');
		$DB1->where('op.examsession', $exam_id);
		$DB1->where_not_in('op.payment_status', ['success']);
		$DB1->where('op.payment_status !=', 'success');

		// ✅ NOT EXISTS subquery
		$DB1->where("NOT EXISTS (
			SELECT 1 
			FROM exam_details ed 
			WHERE ed.enrollment_no = op.registration_no 
			  AND ed.exam_id = " . $DB1->escape($exam_id) . "
		)", NULL, FALSE);

		// ✅ Optional filter by transaction date (if needed)
		// $DB1->like('op.added_on', $transdate);

		// ✅ Optional: Restrict to specific PRNs if required
		// $prn = [240106271073,230101462003,230101462011];
		// $DB1->where_in('op.registration_no', $prn);

		$query = $DB1->get();
		// echo $DB1->last_query(); exit;

		return $query->result_array();
	}

   
    public function update_api_payment_exam($data,$txtid)
	{
		$DB1 = $this->load->database('umsdb',TRUE);
	
		$where=array("txtid"=>$txtid);
		$DB1->where($where); 

		$DB1->update("online_payment", $data); 
		
		//echo $this->db->last_query();exit();
                
		return true;
	}
	
	public function update_api_payment($data,$txtid)
	{
		$DB1 = $this->load->database('umsdb',TRUE);
	
		$where=array("txtid"=>$txtid);
		$DB1->where($where); 

		$DB1->update("online_payment", $data); 
		
		//echo $this->db->last_query();exit();
                
		return true;
	}
	
	function getverify_payment($transdate,$type)
	{
		$DB1 = $this->load->database('umsdb',TRUE);
	 
		$DB1->select('payment_id,txtid');
		$DB1->from('online_payment');
		$DB1->like('added_on',$transdate);
		$DB1->where('payment_status!=','success');
		$DB1->where('productinfo',$type);
		$query =  $DB1->get();
			//echo $DB1->last_query();exit;
		return $query->result_array();
	}

	
	
}
?>