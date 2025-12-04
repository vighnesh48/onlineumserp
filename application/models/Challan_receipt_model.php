<?php
class Challan_receipt_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
       
    }
	public function fees_challan_list($data)
	{
		$this->db->select("sandipun_ums.fees_challan.*,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,");
		$this->db->from("sandipun_ums.fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_ums.fees_challan.enrollment_no",'left');
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.fees_date >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('sandipun_ums.fees_challan.fees_date <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		if(isset($data['odate']) && $data['odate']!='')
		
		{
			$this->db->where('sandipun_ums.fees_challan.fees_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));

		}
		
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.challan_status', $data['status']);
		}
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		$this->db->where('sandipun_ums.fees_challan.is_deleted', 'N');
		$this->db->order_by("sandipun_ums.fees_challan.fees_id", "DESC");

		$query1 = $this->db->get_compiled_select();
		
		/*$this->db->select("sandipun_ums.fees_challan.*,sandipun_erp.sf_student_master.first_name,sandipun_erp.sf_student_master.middle_name,sandipun_erp.sf_student_master.last_name,");
		$this->db->from("sandipun_ums.fees_challan");
		
		$this->db->join("sandipun_erp.sf_student_master","sandipun_erp.sf_student_master.enrollment_no=sandipun_ums.fees_challan.enrollment_no");
		
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.fees_date >=', date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('sandipun_ums.fees_challan.fees_date <=', date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		if(isset($data['odate']) && $data['odate']!='')
		
		{
			$this->db->where('sandipun_ums.fees_challan.fees_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));

		}
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.challan_status', $data['status']);
		}
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		$this->db->where('sandipun_ums.fees_challan.is_deleted', 'N');
		//$this->db->order_by("sandipun_ums.fees_challan.fees_id", "DESC");

		$query2 = $this->db->get_compiled_select();*/
		
		$query = $this->db->query($query1);//." UNION ".$query2
		//echo $this->db->last_query(); //exit();
		return $query->result_array();
	}
	
	public function get_facility_types()
	{
		$this->db->select("*");
		$this->db->from("sf_facility_types");
		$this->db->where('status', 'Y');
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
		public function get_academic_details()
	{
		$sql="select * From sf_academic_year";
		$query = $this->db->query($sql);
		return  $query->result_array();
	}
	function getbanks()
	{
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->select("*");
			$DB1->from('bank_master');
			$DB1->where("active", "Y");
			$query=$DB1->get();
			/*  echo $this->db->last_query();
			die();  */ 
			$result=$query->result_array();
			return $result;
	}
	
	function students_data($data)
	{
		$this->db->select("sm.current_year,sm.mobile,sm.admission_session,sm.first_name,sm.middle_name,sm.last_name,sm.academic_year,sm.enrollment_no,sm.stud_id,
		sm.admission_stream,vw.stream_short_name as stream_name,vw.course_short_name as course_name, vw.school_short_name as school_name,");
		$this->db->from("sandipun_ums.student_master sm");
		
		$this->db->join("sandipun_ums.vw_stream_details vw", "sm.admission_stream = vw.stream_id");
		$this->db->where('sm.enrollment_no', $data['enrollment_no']);

		$query1 = $this->db->get();
			return $query1->row_array();
	
		
		
	}
	
	public function fees_challan_list_byid($id)
	{
		
		$this->db->select("fee.*,sm.current_year,sm.mobile,sm.first_name,sm.middle_name,sm.last_name,sm.academic_year as sacademic_year,sm.enrollment_no,sm.stud_id,
		sm.admission_stream,vw.stream_name as stream_name,vw.course_short_name as course_name, vw.school_short_name as school_name,
		sandipun_erp.bank_master.bank_id, 
		sandipun_erp.bank_master.bank_name, 
		sandipun_erp.bank_master.account_name,
		sandipun_erp.bank_master.bank_account_no as account_no,
		sandipun_erp.bank_master.clinet_id,
		sandipun_erp.bank_master.branch_name,
		sandipun_erp.bank_master.bank_code,
		sandipun_ums.bank_master.bank_name as ubank_name
		");
		$this->db->from("sandipun_ums.fees_challan fee");
		
		$this->db->join("sandipun_ums.student_master sm","sm.enrollment_no=fee.enrollment_no",'left');
		$this->db->join("sandipun_ums.vw_stream_details vw", "sm.admission_stream = vw.stream_id",'left');
		$this->db->join("sandipun_erp.bank_master","sandipun_erp.bank_master.bank_id = fee.bank_account_id",'left');
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = fee.bank_id",'left');
		//$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = fee.bank_account_id");
		$this->db->where('fee.is_deleted', 'N');
		$this->db->where('fee.fees_id', $id);

		$query1 = $this->db->get();
		//echo $this->db->last_query(); //exit();
			return $query1->row_array();
	}
	
	public function get_depositedto()
	{
		$this->db->select("*");
		$this->db->from("bank_master");
		$this->db->where('status','Y');
		//$this->db->where('account_for',$data['faci_type']);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
		
	public function get_fee_details($data)
	{
		$session=$this->session->userdata('logged_in');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		
		//#AND fd.type_id= '".$data['facility']."'
			$DB1 = $this->load->database('umsdb', TRUE);
			$current=date('Y');
			$admission_session=$data['admission_session'];
			$new=$current - $data['admission_session'];
			
			if($new==0){
			$curr_yr=$data['curr_yr'];	
			}else{
            $curr_yr=0;
			}
				if(($data['stud']=="2646")){
				$curr_yr=0;
			}		
			$admi_seesion=$data['admission_session'];
			$datt=date('Y', strtotime('+1 year'));
			$year_new=substr($data['academic'],2);
			$newadd=$year_new + 1;
			$new_year=$data['academic'].'-'.$newadd; //$datt[2].$datt[3];
            /*if(($data['stud']=="2646")&&($new_year=="2019-20")){
				$curr_yr=0;
			}*/

if($this->session->userdata("uid")==2){
$nos=array('24','391','512','556','591','948','958','959','986','998','1028','1054','1063','1086','1092','1107','1120','1124','1126','1143','1156','1159','1168','1195','1214','1215','1294','1300','1309','1324','1325','1326','1332','1360','1380');

if (in_array($data['stud'], $nos))
  {
	 /* SET @tution = 90614;
SET @develo = 9061;
SET @caution = 0;
SET @admission = 0;
SET @exam=5325;*/
  /*$sqll=
SET @tution = 90614,
SET @develo = 9061,
SET @caution = 0,
SET @admission = 0,
SET @exam=5325;
$DB1->query($sqll);*/

  //$sql=" ;
/*$queryy  =   "SET @tution := 90614,
SET @develo := 9061,
SET @caution := 0,
SET @admission := 0,
SET @exam :=5325";
$this->db->query($queryy);*/
 $sql="select sum(fd.amount) as amount_paid,ad.applicable_fee,ad.actual_fee,ad.opening_balance,
		af.academic_fees,@tution as tution_fees, @develo as development,@caution as caution_money,
		@admission as admission_form,af.Gymkhana,af.disaster_management,
		af.student_safety_insurance,af.internet,af.library,af.registration,af.eligibility,af.educational_industrial_visit,
		af.seminar_training, @exam as exam_fees,af.student_activity,af.lab,af.computerization,af.nss
		FROM `admission_details` as `ad`
		 left JOIN `fees_details` as `fd` ON `ad`.`student_id` = `fd`.`student_id`  
		 And ad.academic_year=fd.academic_year And fd.type_id= '".$data['facility']."' 
		 
		LEFT JOIN academic_fees af ON  ad.stream_id=af.stream_id AND af.academic_year='".$new_year."' AND af.admission_year='".$data['admission_session']."' 
		AND af.year='".$curr_yr."'
		WHERE  `ad`.`student_id` = '".$data['stud']."'
		
		AND ad.academic_year =  '".$data['academic']."'
		AND `ad`.`cancelled_admission` = 'N'";
		
		 $newaa=array('amount_paid' =>'','applicable_fee' =>'105000','actual_fee' => '105750' ,'opening_balance' =>'0',
		 'academic_fees' =>'99675' ,'tution_fees' =>'90614', 'development' =>'9061', 'caution_money' =>'0', 'admission_form' =>'0',
		 'Gymkhana' =>'325',
		 'disaster_management' => '0' ,'student_safety_insurance' => '0','internet' =>'0','library' =>'0','registration' =>'0', 
		 'eligibility' => '0', 'educational_industrial_visit' => '0', 'seminar_training' =>'0', 'exam_fees' =>'5000',
		 'student_activity' =>'0','lab' => '0', 'computerization' => '0', 'nss' => '0'); 
		
		return $newaa;
		
  }
else
  {
 $sql="select sum(fd.amount) as amount_paid,ad.applicable_fee,ad.actual_fee,ad.opening_balance,
		af.academic_fees,af.tution_fees,af.development,af.caution_money,af.admission_form,af.Gymkhana,af.disaster_management,
		af.student_safety_insurance,af.internet,af.library,af.registration,af.eligibility,af.educational_industrial_visit,
		af.seminar_training,af.exam_fees,af.student_activity,af.lab,af.computerization,af.nss
		FROM `admission_details` as `ad`
		 left JOIN `fees_details` as `fd` ON `ad`.`student_id` = `fd`.`student_id`  
		 And ad.academic_year=fd.academic_year And fd.type_id= '".$data['facility']."' 
		 
		LEFT JOIN academic_fees af ON  ad.stream_id=af.stream_id AND af.academic_year='".$new_year."' AND af.admission_year='".$data['admission_session']."' 
		AND af.year='".$curr_yr."'
		WHERE  `ad`.`student_id` = '".$data['stud']."'
		
		AND ad.academic_year =  '".$data['academic']."'
		AND `ad`.`cancelled_admission` = 'N'";
		$query = $DB1->query($sql);
		if($this->session->userdata("uid")==2){
		 $DB1->last_query(); //af.admission_year=ad.academic_year AND
		//print_r($query->row_array());
		}
		return $query->row_array();
  }
}else{
	 $sql="select sum(fd.amount) as amount_paid,ad.applicable_fee,ad.actual_fee,ad.opening_balance,
		af.academic_fees,af.tution_fees,af.development,af.caution_money,af.admission_form,af.Gymkhana,af.disaster_management,
		af.student_safety_insurance,af.internet,af.library,af.registration,af.eligibility,af.educational_industrial_visit,
		af.seminar_training,af.exam_fees,af.student_activity,af.lab,af.computerization,af.nss
		FROM `admission_details` as `ad`
		 left JOIN `fees_details` as `fd` ON `ad`.`student_id` = `fd`.`student_id`  
		 And ad.academic_year=fd.academic_year And fd.type_id= '".$data['facility']."' 
		 
		LEFT JOIN academic_fees af ON  ad.stream_id=af.stream_id AND af.academic_year='".$new_year."' AND af.admission_year='".$data['admission_session']."' 
		AND af.year='".$curr_yr."'
		WHERE  `ad`.`student_id` = '".$data['stud']."'
		
		AND ad.academic_year =  '".$data['academic']."'
		AND `ad`.`cancelled_admission` = 'N'";
		$query = $DB1->query($sql);
		if($this->session->userdata("uid")==2){
		 $DB1->last_query(); //af.admission_year=ad.academic_year AND
		//print_r($query->row_array());
		}
		return $query->row_array();
}
	//AND ad.academic_year =  '".$data['academic']."'
	
		/*$query = $DB1->query($sql);
		if($this->session->userdata("uid")==2){
		 $DB1->last_query(); //af.admission_year=ad.academic_year AND
		//print_r($query->row_array());
		}
		return $query->row_array();*/
	}
	

	public function fee_details($data){
		
			$DB1 = $this->load->database('umsdb', TRUE);
			$sql="SELECT *,type_id AS ntype_id FROM fees_challan WHERE academic_year ='".$data['academic']."' AND student_id = '".$data['stud']."'
			AND type_id= '".$data['facility']."' AND enrollment_no='".$data['enroll']."' AND challan_status!='CL'  ORDER BY fees_id DESC limit 0,1";
			$query = $DB1->query($sql);
		    $DB1->last_query();
		    return $query->row_array();
			
	}
	
	
		public function add_fees_challan_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->insert("fees_challan", $data); 
		//echo $DB1->last_query();exit();kamlesh@k
		$last_inserted_id=$DB1->insert_id();                
		return $last_inserted_id;
	}
	
	public function add_into_fees_details($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->insert("fees_details", $data); 
		//echo $DB1->last_query();exit();
		$last_inserted_id=$DB1->insert_id();                
		return $last_inserted_id;
	}
	
	public function update_challan_no($id,$data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->where('fees_id', $id);
		$DB1->update("fees_challan", $data);
		//echo $this->db->last_query();exit();
		return $DB1->affected_rows();
	}
	
	
	public function check_current($data){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT count(paid_id) as Total FROM paid_fees WHERE  student_id='".$data['stud']."' AND enroll_no='".$data['enroll']."' AND facility='".$data['facility']."' AND curr_yr='".$data['curr_yr']."' AND academic_year='".$data['academic']."'";
		$query = $DB1->query($sql);
		 $DB1->last_query();
		return $query->result_array();
	}
	
	public function get_paid_details($data){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT * FROM paid_fees WHERE  student_id='".$data['stud']."' AND enroll_no='".$data['enroll']."' AND facility='".$data['facility']."' AND curr_yr='".$data['curr_yr']."' AND academic_year='".$data['academic']."'";
		$query = $DB1->query($sql);
		 $DB1->last_query();
		return $query->result_array();
	}
	
		
	
	public function Check_challan($data){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT * FROM fees_challan WHERE  student_id='".$data['stud']."' AND enrollment_no='".$data['enroll']."' AND 
		type_id='".$data['facility']."' AND academic_year='".$data['academic']."' ORDER BY fees_id DESC limit 0,1";
		$query = $DB1->query($sql);
		 $DB1->last_query();
		return $query->result_array();
	}

	public function examfees_challan_list($data)
	{
		$this->db->select("sandipun_ums.fees_challan.*,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,");
		$this->db->from("sandipun_ums.fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_ums.fees_challan.enrollment_no",'inner');
	
	
		$this->db->where('sandipun_ums.fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_ums.fees_challan.type_id', '5');
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("sandipun_ums.fees_challan.*,sandipun_erp.sf_student_master.first_name,sandipun_erp.sf_student_master.middle_name,sandipun_erp.sf_student_master.last_name,");
		$this->db->from("sandipun_ums.fees_challan");
		
		$this->db->join("sandipun_erp.sf_student_master","sandipun_erp.sf_student_master.enrollment_no=sandipun_ums.fees_challan.enrollment_no",'inner');
		
		$this->db->where('sandipun_ums.fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_ums.fees_challan.type_id', '5');
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1." UNION ".$query2);
		//echo $this->db->last_query(); //exit();
		return $query->result_array();
	}
	
	//kajal
	function challan_rec_list(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT fees_paid_type FROM receipt GROUP BY fees_paid_type";
		$query = $DB1->query($sql);
		return  $query->result_array();
	}
 function get_recpt_list($data){
$DB1 = $this->load->database('umsdb', TRUE);
if($data['pst']!=''){
	$rwh=' and fees_paid_type="'.$data['pst'].'"';
}
if($data['styp']=='day'){
$dwh=" and DATE(fees_date)='".date('Y-m-d',strtotime($data['sdt']))."' ";
	}elseif($data['styp']=='dur'){
$dwh =" and DATE(fees_date) BETWEEN '".date('Y-m-d',strtotime($data['dfrm']))."' AND '".date('Y-m-d',strtotime($data['dto']))."' ";
	}
		$sql="SELECT student_name,amount,cousre_name,fees_paid_type,receipt_no,challan_status,fees_date FROM receipt where 1 $rwh $dwh ";
		$query = $DB1->query($sql);
		return  $query->result_array();

 }
}