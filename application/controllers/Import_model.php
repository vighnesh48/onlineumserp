<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Import_model extends CI_Model {

    private $_batchImport;

    public function setBatchImport($batchImport) {
        $this->_batchImport = $batchImport;
    }

    // save data
    public function importData() {
        $data = $this->_batchImport;
        $this->db->insert_batch('import', $data);
    }
    // get employee list
    public function employeeList() {
        $this->db->select(array('e.id', 'e.first_name', 'e.last_name', 'e.email', 'e.dob', 'e.contact_no'));
        $this->db->from('import as e');
        $query = $this->db->get();
        return $query->result_array();
    }
	
	
	public function getstudentid($enrollment_no){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		//$DB1->select("sm.*,stm.stream_name,cm.course_name");
		$DB1->select("sm.*");
		$DB1->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
		//$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
			//$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		
		if($enrollment_no!='')
		{
			$DB1->where("sm.enrollment_no",trim($enrollment_no));	   
				$DB1->or_where("sm.enrollment_no_new",trim($enrollment_no));	    
    	}
    	
		//$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
	//  echo $DB1->last_query();
	//	exit(0);
	
	//$query = $this->db->get();
	$result = $query->row();
	return $result->stud_id;

		$result=$query->result_array();
		//echo $this->db->last_query();
		
		 /* die();   */  
	//	$result=$query->result_array();
		//return $result;
	}
	
	
	function pay_Installment($data){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		//print_r($data);
		//echo $payfile;exit;
		$feedet['student_id']=$data['student_id'];
		$feedet['amount']=$data['amount'];
		$feedet['type_id']=2;
		$feedet['fees_paid_type']=$data['fees_paid_type'];
		$feedet['academic_year']= $data['academic_year'];

		$feedet['receipt_no']=$data['trans_no'];
		$feedet['fees_date']=$data['trans_date']; 
		$feedet['bank_id']=$data['Student_bank_name'];
		$feedet['bank_city']=$data['Student_bank_branch'];
		$feedet['remark']='MANUAL';
		$feedet['college_receiptno']='NULL';
		$feedet['is_provisional']='N';
		$feedet['canc_charges']='0';
		$feedet['exam_fee_fine']='0';
		$feedet['academic_fee_fine']='0';
		
		
		//$feedet['academic_fee_fine']=$data['late_fees'];		


		$feedet['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		if($data['fees_payment_date']!=''){
			$feedet['created_on']=  $data['fees_payment_date'];
		}else{
			$feedet['created_on']= date('Y-m-d h:i:s');
		}
		$feedet['created_by']= $_SESSION['uid'];


		$feedet['college_receiptno']=$data['manual_receipt_no'];

		//print_r($feedet);exit;
		$DB1->insert('fees_details',$feedet);   
		$insert_feid1 = $DB1->insert_id();

		$fidetails['student_id']=$data['student_id'];
		$fidetails['enrollment_no']=$data['enrollment_no'];
		$fidetails['actual_fees']=$data['actfee'];
		$fidetails['fees_id']=$insert_feid1;
		$fidetails['academic_year']= '2019'; //date('Y');
		
		//$noofinst= $this->fetch_no_of_installment($data['student_id']);
		//$minbalance= $this->fetch_last_balance($data['student_id']);
		//$totfeepaid= $this->fetch_total_fee_paid($data['student_id']);
		
		$fidetails['no_of_installment']=1+$data['noofinst'];
		$fidetails['balance_fees']=((int)$data['minbalance'] - (int)$data['amount']);
		$fidetails['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		if($data['fees_payment_date']!=''){
			$fidetails['created_on']= $data['fees_payment_date'];
		}else{
			$fidetails['created_on']= date('Y-m-d h:i:s');
		}
		//$fidetails['next_payment_date']= $data['npdate'];
		$fidetails['created_by']= $_SESSION['uid'];
		//print_r($fidetails);exit;
		$DB1->insert('fees_installment_details',$fidetails);
		//echo $DB1->last_query();exit;
		return true;
		
	}
	
	
	// fetch no fo installments
	function fetch_no_of_installment($studId){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT max(`no_of_installment`) as max_no_installment FROM `fees_installment_details` WHERE `student_id`=$studId";
		$query = $DB1->query($sql);
		$result=$query->result_array(); 
		//echo $DB1->last_query();exit;
		return $result;	
	}
	
	// fetch last min balance
	function fetch_last_balance($studId){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT min(`balance_fees`) as min_balance FROM `fees_installment_details` WHERE `student_id`=$studId and chq_cancelled='N' and is_deleted='N'";
		$query = $DB1->query($sql);
		$result=$query->result_array(); 
		if($result[0]['min_balance']=='')
		{
		    
		    	$sql="SELECT applicable_fee as min_balance FROM `admission_details` WHERE `student_id`=$studId";
		$query = $DB1->query($sql);
		$result=$query->result_array(); 
		//  $result[0]['min_balance']  
		}
		//echo $DB1->last_query();exit;
		return $result;	
	}
	
	// fetch total fee paid
	function fetch_total_fee_paid($studId,$acyear=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT sum(`amount`) as tot_fee_paid FROM `fees_details` WHERE `student_id`='$studId' and chq_cancelled='N' and is_deleted='N' and type_id='2'";
		if($acyear !='')
		{
		    $sql .=" and academic_year=$acyear ";
		}
		$query = $DB1->query($sql);
		$result=$query->result_array(); 
	
	//	echo $DB1->last_query();exit;
		return $result;	
	}
	
	function fetch_admission_details($stud_id,$acyear=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('admission_details');
		//$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->where('student_id', $stud_id);
		if($acyear !='')
		{
		   	$DB1->where('academic_year', $acyear); 
		}
		$DB1->order_by("adm_id", "desc");
	$DB1->limit(1,0);

		$query=$DB1->get();
		$result=$query->result_array();
//	echo $DB1->last_query();
		return $result;
	}
	
	
	function fees_exist($receipt)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->where('college_receiptno',$receipt);
		$query = $DB1->get('fees_details');
		if ($query->num_rows() > 0){
			return false;
		}
		else{
			return true;
		}
	}
	
	function get_manual_fees($academic_year,$fees_paid_type=""){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('fees_details');
		$DB1->where('academic_year',$academic_year);
		$DB1->where('type_id','2');
		$DB1->where('chq_cancelled','N');
		$DB1->where('is_deleted','N');
		$DB1->where('college_receiptno !=','');
		$DB1->where('amount !=','0');
		if($fees_paid_type!=""){
			$DB1->where('fees_paid_type',$fees_paid_type);
		}
		//$DB1->not_like('college_receiptno','R19SUNA1', 'after');
		$DB1->not_like('college_receiptno','19SUNR1', 'after');
		$query=$DB1->get();
		$result=$query->result_array();
	//echo $DB1->last_query();
		return $result;
	}

	
	function get_fees_challan($academic_year,$fees_paid_type="",$stud_ids=""){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('fees_challan');
		$DB1->where('academic_year',$academic_year);
		$DB1->where('type_id','2');
		$DB1->where('challan_status','VR');
		$DB1->where('is_deleted','N');
		$DB1->where('exam_session !=','');
		$DB1->where('amount !=','0');
		if($fees_paid_type!=""){
			$DB1->where('fees_paid_type',$fees_paid_type);
		}
		
		if($stud_ids!=""){
			$DB1->where_in('student_id ',array_map('stripslashes',$stud_ids));
		}
		//$DB1->like('exam_session','R19SUNA1', 'after');
		$DB1->like('exam_session','19SUNR1', 'after');
		$query=$DB1->get();
		$result=$query->result_array();
	//echo $DB1->last_query();exit;
		return $result;
	}
	
	function get_fees_receipt($academic_year,$fees_paid_type=""){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('receipt');
		$DB1->where('academic_year',$academic_year);
		$DB1->where('type_id','2');
		$DB1->where('challan_status','VR');
		$DB1->where('is_deleted','N');
		$DB1->where('exam_session !=','');
		$DB1->where('amount !=','0');
		if($fees_paid_type!=""){
			$DB1->where('fees_paid_type',$fees_paid_type);
		}
		$DB1->like('exam_session','R19SUNA1', 'after');
		//$DB1->like('exam_session','19SUNR1', 'after');
		$query=$DB1->get();
		$result=$query->result_array();
	//echo $DB1->last_query();
		return $result;
	}
	
	function fetch_student_details($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('student_master');
		//$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->where('stud_id', $stud_id);
		
		$DB1->limit(1,0);

		$query=$DB1->get();
		$result=$query->result_array();
//	echo $DB1->last_query();
		return $result;
	}
	
	
	function fetch_academic_fees_for_rereg($strm_id,$acyear,$adm_session,$current_year){
      //   echo $acyear;
      $acy =  substr($acyear,-2);
  $ny = $acy+1;
      $year = $acyear."-".$ny;
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('academic_fees ');
		$DB1->where('stream_id', $strm_id);
		$DB1->where('academic_year', $year);
		$DB1->where('admission_year', $adm_session);
		$DB1->where('year', $current_year);
		$query=$DB1->get();
		$result=$query->result_array();
	//	echo $DB1->last_query();
	//	exit(0);
//	var_dump($result);
		return $result;
	}
	
	
	function get_stud_latest_challan($academic_year,$fees_paid_type="",$stud_id=""){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		
		$DB1->from('fees_challan');
		$DB1->where('academic_year',$academic_year);
		$DB1->where('type_id','2');
		$DB1->where('challan_status','VR');
		$DB1->where('is_deleted','N');
		$DB1->where('exam_session !=','');
		$DB1->where('amount !=','0');
		
		
		
		if($stud_id!=""){
			$DB1->where('student_id ',$stud_id);
		}
		$DB1->order_by('fees_id','DESC');
		$DB1->limit(1);
		//$DB1->like('exam_session','R19SUNA1', 'after');
		//$DB1->like('exam_session','19SUNR1', 'after');
		$query=$DB1->get();
		$result=$query->result_array();
	//echo $DB1->last_query();exit;
		return $result;
	}
	
	function get_previous_balance($academic_year, $stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("opening_balance");
		
		$DB1->from('admission_details');
		$DB1->where('academic_year',$academic_year);
		if($stud_id!=""){
			$DB1->where('student_id ',$stud_id);
		}
		
		$DB1->limit(1);
		$query=$DB1->get();
		$result=$query->row();
	//echo $DB1->last_query();exit;
		return $result->opening_balance;
	}
	
	function get_opening_balance($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(opening_balance) as opaning_bal");
		$DB1->from('admission_details');
			$DB1->where('academic_year',$year);
			$DB1->where('cancelled_admission','N');
		$query=$DB1->get();
	//	echo $DB1->last_query();
	$result=$query->row_array();
		return $result['opaning_bal'];
}

function get_admission_details($enrollment_no,$acyear=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('admission_details');
		//$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->where('enrollment_no', $enrollment_no);
		if($acyear !='')
		{
		   	$DB1->where('academic_year', $acyear); 
		}
		$DB1->order_by("adm_id", "desc");
	$DB1->limit(1,0);

		$query=$DB1->get();
		$result=$query->result_array();
	//echo $DB1->last_query(); exit;
		return $result;
	}
	
	 
}

?>