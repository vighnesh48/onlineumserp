<?php
class Challan_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		 $this->load->database();
       
    }
	public function checkChallanNumber_for_callback($prefix){
	
		$academic_year = ACADEMIC_YEAR;
		$year_start = substr($academic_year, 0, 4);
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('exam_session');
		$DB1->from('fees_challan');
		$DB1->where('academic_year', $year_start);
		$DB1->like('exam_session', $prefix, 'after'); // Matches 'SFO2425%'
		$DB1->order_by('exam_session', 'DESC');
		$DB1->limit(1);
		$query = $DB1->get();
		// echo $DB1->last_query();exit;
		$result= $query->row_array();

		return $result;
		
		
	}
	public function checkChallanNumber_unique($prefix,$new_number){
		//Recursion 
		$formatted_number = str_pad($new_number, 7, '0', STR_PAD_LEFT);
		// $formatted_number = 1176991;
		$academic_year = ACADEMIC_YEAR;
		$year_start = substr($academic_year, 0, 4);
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('exam_session');
		$DB1->from('fees_challan');
		$DB1->where('academic_year', $year_start);
		$DB1->where('exam_session', $prefix.$formatted_number); // Matches 'SFO2425%'
		$DB1->order_by('exam_session', 'DESC');
		$DB1->limit(1);
		$query = $DB1->get();
		// echo $DB1->last_query();exit;
		$result= $query->row_array();
		// print_r($result);exit;
		if (!empty($result)) {
			return $this->checkChallanNumber_unique($prefix, $new_number+1);
		}else{
			return $prefix.$formatted_number;
		}
		
	}
	
	public function fees_challan_list($data=array())
	{
		 $roleid=$this->session->userdata('role_id');
		$this->db->select("sandipun_ums.fees_type.fees_name, sandipun_ums.fees_challan.*,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,");
		$this->db->from("sandipun_ums.fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_ums.fees_challan.enrollment_no OR sandipun_ums.student_master.enrollment_no_new=sandipun_ums.fees_challan.enrollment_no ",'left');
		$this->db->join("sandipun_ums.fees_type","sandipun_ums.fees_type.type_id=sandipun_ums.fees_challan.type_id",'left');
		
		/*if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.fees_date >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('sandipun_ums.fees_challan.fees_date <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		
		if(isset($data['odate']) && $data['odate']!='')
		
		{
			$this->db->where('sandipun_ums.fees_challan.fees_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));

		}*/
		//$this->db->where('sandipun_ums.fees_challan.fees_date', date("Y-m-d"));
		
		//$this->db->where('sandipun_ums.fees_challan.fees_date >=','2019-01-01');
      //  $this->db->where('sandipun_ums.fees_challan.fees_date <=', date("Y-m-d"));
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.challan_status', $data['status']);
		}else{
			$this->db->where('sandipun_ums.fees_challan.challan_status', 'PD');
		}
		if($roleid==15 || $roleid==14){
			$this->db->where('sandipun_ums.fees_type.related_to', 'exam');
		}
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		
		$this->db->where('sandipun_ums.fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_ums.fees_challan.exam_session !=', '20SUNR000000');
		$this->db->order_by("sandipun_ums.fees_challan.fees_id", "DESC");
		//$this->db->order_by("sandipun_ums.fees_challan.fees_id", "DESC");
		$this->db->limit(100);  
		//$query1 = $this->db->get_compiled_select();
		
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
		$query = $this->db->get();
		//$query = $this->db->query($query1);//." UNION ".$query2
		//echo $this->db->last_query(); exit();
		return $query->result_array();
	}


	public function fees_challan_internationlist($data)
	{
		$this->db->select("sandipun_ums.fees_challan_internationl.*,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,");
		$this->db->from("sandipun_ums.fees_challan_internationl");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_ums.fees_challan_internationl.enrollment_no",'left');
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('sandipun_ums.fees_challan_internationl.fees_date >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('sandipun_ums.fees_challan_internationl.fees_date <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		if(isset($data['odate']) && $data['odate']!='')
		
		{
			$this->db->where('sandipun_ums.fees_challan_internationl.fees_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));

		}
		
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_ums.fees_challan_internationl.challan_status', $data['status']);
		}
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_ums.fees_challan_internationl.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		$this->db->where('sandipun_ums.fees_challan_internationl.is_deleted', 'N');
		$this->db->order_by("sandipun_ums.fees_challan_internationl.fees_id", "DESC");

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
		$this->load->database();
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

	public function get_academic_feesdetails($data)
	{
		$DB2 = $this->load->database('umsdb', TRUE);
		$DB2->select("*");
		$DB2->from("academic_fees");
		
		//$this->db->join("sandipun_ums.vw_stream_details vw", "sm.admission_stream = vw.stream_id");
		$DB2->where('stream_id', $data['admission_stream']);
        $DB2->where("admission_year",$data['academic']);
        $DB2->where("year",$data['curr_yr']);
		$query1 = $DB2->get();
		//echo $DB2->last_query();
		//die;
		return $query1->row_array();
	}
	
	public function get_examsession(){
		$DB2 = $this->load->database('umsdb', TRUE);
		$sql="select * From exam_session where active_for_challan='Y'";
		$query = $DB2->query($sql);
		return  $query->result_array();
	}
	
	public function get_examsession_phd(){
		$DB2 = $this->load->database('umsdb', TRUE);
		$sql="select * From phd_exam_session where active_for_exam='Y'";
		$query = $DB2->query($sql);
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
		$this->db->select("sm.current_year,sm.admission_cycle,sm.mobile,sm.admission_session,sm.first_name,sm.middle_name,sm.last_name,sm.academic_year,sm.enrollment_no,sm.stud_id,
		sm.admission_stream,vw.stream_short_name as stream_name,vw.course_short_name as course_name, vw.school_short_name as school_name,");
		$this->db->from("sandipun_ums.student_master sm");//sm.admission_cycle
	
		$this->db->join("sandipun_ums.vw_stream_details vw", "sm.admission_stream = vw.stream_id");
		$this->db->where('sm.enrollment_no', $data['enrollment_no']);
		$this->db->or_where('sm.enrollment_no_new', $data['enrollment_no']);
        $this->db->where("sm.admission_cycle IS NULL");
		$query1 = $this->db->get();
		//echo $this->db->last_query();
			return $query1->row_array();
	
		
		
	}

	function students_data_international($data)
	{
		$this->db->select("sm.current_year,sm.mobile,sm.admission_session,sm.first_name,sm.middle_name,sm.last_name,sm.academic_year,sm.enrollment_no,sm.stud_id,
		sm.admission_stream,vw.stream_short_name as stream_name,vw.course_short_name as course_name, vw.school_short_name as school_name,");
		$this->db->from("sandipun_ums.student_master sm");
		
		$this->db->join("sandipun_ums.vw_stream_details vw", "sm.admission_stream = vw.stream_id");
		$this->db->where('sm.enrollment_no', $data['enrollment_no']);
		$this->db->or_where('sm.enrollment_no_new', $data['enrollment_no']);
        $this->db->where("sm.admission_cycle IS NULL");
         $this->db->where('sm.nationality', 'NIGERIA');

		$query1 = $this->db->get();
		//echo $this->db->last_query();
			return $query1->row_array();
	
		
		
	}

	public function examfees_challan_list($data,$examid)
	{


		$this->db->select("sandipun_ums.fees_challan.*,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,");
		$this->db->from("sandipun_ums.fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_ums.fees_challan.enrollment_no",'inner');
	
		$this->db->where('sandipun_ums.fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_ums.fees_challan.type_id', '5');
		$this->db->where('sandipun_ums.fees_challan.exam_id', $examid);
		$query = $this->db->get();
		/*echo $this->db->last_query(); 
		exit();*/
		return $query->result_array();
	}
	
	public function fees_challan_list_byid($id)
	{
		
		$this->db->select("fee.*,ad.year as current_year,sm.mobile,sm.first_name,sm.middle_name,sm.last_name,sm.academic_year as sacademic_year,sm.enrollment_no,sm.stud_id,
		sm.admission_stream,sm.enquiry_no,vw.stream_name as stream_name,vw.course_short_name as course_name, vw.school_short_name as school_name,
		sandipun_erp.bank_master.bank_id, 
		sandipun_erp.bank_master.bank_name, 
		sandipun_erp.bank_master.account_name,
		sandipun_erp.bank_master.bank_account_no as account_no,
		sandipun_erp.bank_master.clinet_id,
		sandipun_erp.bank_master.branch_name,
		sandipun_erp.bank_master.bank_code,
		sandipun_ums.bank_master.bank_id as ubank_id,
		sandipun_ums.bank_master.bank_name as ubank_name,
		sandipun_erp.user_master.display_name
		");
		$this->db->from("sandipun_ums.fees_challan fee");
		
		$this->db->join("sandipun_ums.student_master sm","sm.enrollment_no=fee.enrollment_no OR sm.enrollment_no_new=fee.enrollment_no",'LEFT');
		$this->db->join("sandipun_ums.admission_details ad","ad.student_id=fee.student_id and  ad.academic_year=fee.academic_year",'LEFT');
		$this->db->join("sandipun_ums.vw_stream_details vw", "sm.admission_stream = vw.stream_id",'LEFT');
		$this->db->join("sandipun_erp.bank_master","sandipun_erp.bank_master.bank_id = fee.bank_account_id",'LEFT');
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = fee.bank_id",'LEFT');
		$this->db->join("sandipun_erp.user_master","sandipun_erp.user_master.um_id = fee.created_by",'LEFT');
		//$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = fee.bank_account_id");
		$this->db->where('fee.is_deleted', 'N');
		$this->db->where('fee.fees_id', $id);

		$query1 = $this->db->get();
		if($this->session->userdata("uid")==2){
		
		}
		//echo $this->db->last_query(); exit();
			return $query1->row_array();
	}


   	


		public function fees_internationalchallan_list_byid($id)
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
		sandipun_ums.bank_master.bank_id as ubank_id,
		sandipun_ums.bank_master.bank_name as ubank_name
		");
		$this->db->from("sandipun_ums.fees_challan_internationl fee");
		
		$this->db->join("sandipun_ums.student_master sm","sm.enrollment_no=fee.enrollment_no",'LEFT');
		$this->db->join("sandipun_ums.vw_stream_details vw", "sm.admission_stream = vw.stream_id",'LEFT');
		$this->db->join("sandipun_erp.bank_master","sandipun_erp.bank_master.bank_id = fee.bank_account_id",'LEFT');
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = fee.bank_id",'LEFT');
		//$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = fee.bank_account_id");
		$this->db->where('fee.is_deleted', 'N');
		$this->db->where('fee.fees_id', $id);

		$query1 = $this->db->get();
		if($this->session->userdata("uid")==2){
		//echo $this->db->last_query(); //exit();
		}
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
			
			if(($data['admission_session']==2025)&&($data['curr_yr']<=2))
			{
				$curr_yr=$data['curr_yr'];	
			}
			if(($data['admission_session']==2025))
			{
				$curr_yr=$data['curr_yr'];	
			}
			else{
				$curr_yr=0;
			}
			
			/*if($new==0){
			$curr_yr=$data['curr_yr'];	
			}else{
            $curr_yr=0;
			}*/
			
			
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

//if($this->session->userdata("uid")==2)
//{
$nos=array(/*'24','391','512','556','591','948','959','986','998','1028','1054','1063','1086',
'1092','1107','1120','1124','1126','1143','1156','1159','1168','1195','1214','1215','1294','1300','1309',
'1324','1325','1326','1332','1360','1380'*/); //'958'

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
$amount_paid='';
 $sql="select sum(fd.amount) as amount_paid
		FROM `admission_details` as `ad`
		 left JOIN `fees_details` as `fd` ON `ad`.`student_id` = `fd`.`student_id`  
		 And ad.academic_year=fd.academic_year And fd.type_id= '".$data['facility']."' AND `fd`.`chq_cancelled`!= 'Y'
		 
		LEFT JOIN academic_fees af ON  ad.stream_id=af.stream_id AND af.academic_year='".$new_year."' AND af.admission_year='".$data['admission_session']."' 
		AND af.year='".$curr_yr."'
		WHERE  `ad`.`student_id` = '".$data['stud']."'
		
		AND ad.academic_year =  '".$data['academic']."' AND `ad`.`cancelled_admission` = 'N'";
		$query = $DB1->query($sql);
		if($this->session->userdata("uid")==2){
		//echo  $DB1->last_query(); //af.admission_year=ad.academic_year AND
		//print_r($query->row_array());
		}
		$result=$query->row_array();
		//foreach()
		$amount_paid=$result['amount_paid'];
		 $newaa=array('amount_paid' =>$amount_paid,'applicable_fee' =>'105000','actual_fee' => '105000' ,'opening_balance' =>'0',
		 'academic_fees' =>'99675' ,'tution_fees' =>'90614', 'development' =>'9061', 'caution_money' =>'0', 'admission_form' =>'0',
		 'Gymkhana' =>'325',
		 'disaster_management' => '0' ,'student_safety_insurance' => '0','internet' =>'0','library' =>'0','registration' =>'0', 
		 'eligibility' => '0', 'educational_industrial_visit' => '0', 'seminar_training' =>'0', 'exam_fees' =>'5000',
		 'student_activity' =>'0','lab' => '0', 'computerization' => '0', 'nss' => '0'); 
		
		return $newaa;
		
  }else{
 $sql="select fd.amount_p as amount_paid,ad.applicable_fee,ad.actual_fee,ad.opening_balance,
		af.academic_fees,af.tution_fees,af.development,af.caution_money,af.admission_form,af.Gymkhana,af.disaster_management,af.accommodation,
		af.student_safety_insurance,af.internet,af.library,af.registration,af.eligibility,af.educational_industrial_visit,
		af.seminar_training,af.exam_fees,af.student_activity,af.lab,af.computerization,af.nss,fcd.exepmted_fees
		FROM `admission_details` as `ad`
		 left JOIN (SELECT SUM(amount) AS amount_p,student_id,academic_year,chq_cancelled,is_deleted FROM fees_details WHERE
 academic_year='".$data['academic']."' AND chq_cancelled='N' AND is_deleted='N'  AND type_id= '2' AND `student_id` = '".$data['stud']."') as `fd`
  ON `ad`.`student_id` = `fd`.`student_id` And ad.academic_year=fd.academic_year 
		 LEFT join fees_consession_details as fcd ON fcd.student_id=ad.student_id AND fcd.academic_year='".$data['admission_session']."'
		LEFT JOIN academic_fees af ON  ad.stream_id=af.stream_id AND af.academic_year='".$new_year."' AND af.admission_year='".$data['admission_session']."' 
		AND af.year='".$curr_yr."' AND af.`is_active`='Y'
		WHERE  `ad`.`student_id` = '".$data['stud']."'
		
		AND ad.academic_year =  '".$data['academic']."'
		 GROUP BY fd.student_id";
		
		$query = $DB1->query($sql);
		//if($this->session->userdata("uid")==2){
		if($data['stud']==14782){	 
		// echo  $DB1->last_query(); exit(); //af.admission_year=ad.academic_year AND
		//print_r($query->row_array());
		}
		return $query->row_array();
  }
 /* }
  
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
}*/
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
			AND type_id= '".$data['facility']."'  AND challan_status !='CL' AND type_id='2' 
			ORDER BY fees_id DESC limit 0,1";//AND enrollment_no='".$data['enroll']."'
			$query = $DB1->query($sql);
			if($this->session->userdata("uid")==2){
		 // echo  $DB1->last_query();
			}
		    return $query->row_array();
			
	}

	public function fee_details_international($data){
		
			$DB1 = $this->load->database('umsdb', TRUE);
			$sql="SELECT *,type_id AS ntype_id FROM fees_challan_internationl WHERE academic_year ='".$data['academic']."' AND student_id = '".$data['stud']."'
			AND type_id= '".$data['facility']."' AND challan_status !='CL' AND type_id='2'
			ORDER BY fees_id DESC limit 0,1";//AND enrollment_no='".$data['enroll']."'
			$query = $DB1->query($sql);
			if($this->session->userdata("uid")==2){
		 // echo  $DB1->last_query();
			}
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
	public function add_fees_challan_international_submit($data)
	{
		$DB2 = $this->load->database('umsdb', TRUE);
		$DB2->insert("fees_challan_internationl", $data); 
		//echo $DB2->last_query();exit();
		$last_inserted_id=$DB2->insert_id();                
		return $last_inserted_id;
	}


	
	
	public function add_into_fees_details($data)
	{   
	    $DB3=$this->load->database('umsdb',TRUE);
		$DB3->where('student_id', $data['student_id']);
		$DB3->where('college_receiptno', $data['college_receiptno']);
		$DB3->where('amount', $data['amount']);
		$DB3->from('fees_details');
		//$where="admission_session='2020' AND academic_year='2020' AND enrollment_no!='' AND cancelled_admission='N' AND admission_confirm='$m'";
		//$DB3->where($where);	
		$count= $DB3->count_all_results();
	
	
	     if($count==0){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->insert("fees_details", $data); 
		//echo $DB1->last_query();
		$last_inserted_id=$DB1->insert_id();                
		return $last_inserted_id;}else{
			return 0;
		}
	}
	
	public function update_challan_no($id,$data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->where('fees_id', $id);
		$DB1->update("fees_challan", $data);
		//echo $this->db->last_query();exit();
		return $DB1->affected_rows();
	}
	public function update_challan_no_international($id,$data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->where('fees_id', $id);
		$DB1->update("fees_challan_internationl", $data);
		//echo $this->db->last_query();exit();
		return $DB1->affected_rows();
	}

	 


	  public function update_fees_challan_internation_details($data)
	  {
	  		/*ini_set('display_errors', 1); 
			ini_set('display_startup_errors', 1); 
			error_reporting(E_ALL);*/
	  		$DB1 = $this->load->database('umsdb', TRUE);

			$chall_fee['is_deleted']='Y';
			//$chall_fee['balance_fees']=((int)$tfee - (int)$data['epaidfee']);
			$chall_fee['challan_status']='CL'; 
			$chall_fee['modify_from_ip']=$_SERVER['REMOTE_ADDR'];
			$chall_fee['modified_on']= date('Y-m-d h:i:s');
			$chall_fee['modified_by']= $_SESSION['uid'];
			$DB1->where('exam_session', $data['challan_no']);
			$DB1->where('student_id', $data['student_id']);
			$DB1->update('fees_challan_internationl',$chall_fee);
			///////////////////////////////challan details amount update////////
			/*echo $DB1->last_query();
			exit();*/


			//$DB1 = $this->load->database('umsdb', TRUE);   
	 		$DB1->select("tution_fees,
						development_fees,
						caution_money,
						admission_form,
						exam_fees,
						university_fees");
			$DB1->from('fees_challan_internationl');
			$DB1->where('exam_session', $data['challan_no']);
			$DB1->where('student_id', $data['student_id']);
			$query=$DB1->get();
			$result2=$query->row_array();
	
		
		
			$tution_fees=$result2['tution_fees'];

			$development_fees=$result2['development_fees'];
			$caution_money=$result2['caution_money'];
			$admission_form=$result2['admission_form'];
			$exam_fees=$result2['exam_fees'];
			$university_fees=$result2['university_fees'];

			/////// get top entry of the table
			$ignore=$data['challan_no'];

			$DB1->select("*");
			$DB1->from('fees_challan_internationl');
			$DB1->where('student_id', $data['student_id']);
			$DB1->where_not_in('exam_session', $ignore);
			$query=$DB1->get();
		
			$rowcountt=$query->result_array();
			if(count($rowcountt)>1)
			{
				
				$DB1->select("*");
				$DB1->from('fees_challan_internationl');
				$DB1->where('student_id', $data['student_id']);
				$DB1->where_not_in('exam_session', $ignore);
				$DB1->limit(1);
				$DB1->order_by('fees_id',"DESC");
				$query=$DB1->get();
				//echo $DB1->last_query();
				//die;
				$feechallan_detials=$query->row_array();


				if(!empty($feechallan_detials))
				{

					//get individual value
					$update_fees_challan['tution_pending']=$feechallan_detials['tution_pending']+$tution_fees;
					$update_fees_challan['development_pending']=$feechallan_detials['development_pending']+$development_fees;
					$update_fees_challan['caution_pending']=$feechallan_detials['caution_pending']+$caution_money;
					$update_fees_challan['admission_pending']=$feechallan_detials['admission_pending']+$admission_form;
					$update_fees_challan['exam_pending']=$feechallan_detials['exam_pending']+$exam_fees;
					$update_fees_challan['university_pending']=$feechallan_detials['university_pending']+$university_fees;
					$update_fees_challan['tution_status']='N';
					$update_fees_challan['development_status']='N';
					$update_fees_challan['caution_status']='N';
					$update_fees_challan['admission_status']='N';
					$update_fees_challan['exam_status']='N';
					$update_fees_challan['university_status']='N';

					$DB1->where('fees_id', $feechallan_detials['fees_id']);
					$DB1->update('fees_challan_internationl',$update_fees_challan);

				}

			}
			
		

	  }


	  ///erp///

    public function update_fees_details($data,$update_array_f){
	  	$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->where('college_receiptno', $data['challan_no']);
		$DB1->where('student_id', $data['student_id']);
		$DB1->update("fees_details", $update_array_f);
		//echo $this->db->last_query();exit();
		return $DB1->affected_rows();
	  }
	  
	  
	  public function update_online_payment($receipt_number,$student_id,$amt){
		$DB1 = $this->load->database('umsdb', TRUE);
		$update_array_f['verification_status']='Y';
		$update_array_f['verified_by']=$_SESSION['uid'];
		$update_array_f['verified_on']=date('Y-m-d h:i:s');
		//$DB1->where('student_id', $student_id);
		$DB1->where('amount', $amt);
		$DB1->where('bank_ref_num', $receipt_number);
		$DB1->update("online_payment", $update_array_f);
		//echo $this->db->last_query();exit();
		return $DB1->affected_rows();
	  }
	  
	  function get_opening_balnce($academic,$enroll,$student_id){
		  	$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT * FROM admission_details WHERE  academic_year='".$academic."' AND student_id='".$student_id."'"; //AND enrollment_no='".$enroll."' 
		$query = $DB1->query($sql);
		 $DB1->last_query();
		return $query->result_array();
		  
	  }
	 function update_opening($academic,$enroll,$student_id,$update_opening){
		 $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->where('academic_year', $academic);
		$DB1->where('student_id', $student_id);
		//$DB1->where('enrollment_no', $enroll);
		$DB1->update("admission_details", $update_opening);
		//echo $this->db->last_query();exit();
		return $DB1->affected_rows();
	 }
	  
	  
	   public function update_fees_challan_details($data)
	  {
	  		/*ini_set('display_errors', 1); 
			ini_set('display_startup_errors', 1); 
			error_reporting(E_ALL);*/
	  		$DB1 = $this->load->database('umsdb', TRUE);

			$chall_fee['is_deleted']='Y';
			//$chall_fee['balance_fees']=((int)$tfee - (int)$data['epaidfee']);
			$chall_fee['challan_status']='CL'; 
			$chall_fee['modify_from_ip']=$_SERVER['REMOTE_ADDR'];
			$chall_fee['modified_on']= date('Y-m-d h:i:s');
			$chall_fee['modified_by']= $_SESSION['uid'];
			$DB1->where('exam_session', $data['challan_no']);
			$DB1->where('student_id', $data['student_id']);
			$DB1->update('fees_challan',$chall_fee);
			///////////////////////////////challan details amount update////////
			/*echo $DB1->last_query();
			exit();*/


			//$DB1 = $this->load->database('umsdb', TRUE);   
	 		$DB1->select("tution_fees,
						development_fees,
						caution_money,
						admission_form,
						exam_fees,
						university_fees");
			$DB1->from('fees_challan');
			$DB1->where('exam_session', $data['challan_no']);
			$DB1->where('student_id', $data['student_id']);
			$query=$DB1->get();
			$result2=$query->row_array();
	
		
		
			$tution_fees=$result2['tution_fees'];

			$development_fees=$result2['development_fees'];
			$caution_money=$result2['caution_money'];
			$admission_form=$result2['admission_form'];
			$exam_fees=$result2['exam_fees'];
			$university_fees=$result2['university_fees'];

			/////// get top entry of the table
			$ignore=$data['challan_no'];

			$DB1->select("*");
			$DB1->from('fees_challan');
			$DB1->where('student_id', $data['student_id']);
			$DB1->where_not_in('exam_session', $ignore);
			$query=$DB1->get();
		
			$rowcountt=$query->result_array();
			if(count($rowcountt)>1)
			{
				
				$DB1->select("*");
				$DB1->from('fees_challan');
				$DB1->where('student_id', $data['student_id']);
				$DB1->where_not_in('exam_session', $ignore);
				$DB1->limit(1);
				$DB1->order_by('fees_id',"DESC");
				$query=$DB1->get();
				//echo $DB1->last_query();
				//die;
				$feechallan_detials=$query->row_array();


				if(!empty($feechallan_detials))
				{

					//get individual value
					$update_fees_challan['tution_pending']=$feechallan_detials['tution_pending']+$tution_fees;
					$update_fees_challan['development_pending']=$feechallan_detials['development_pending']+$development_fees;
					$update_fees_challan['caution_pending']=$feechallan_detials['caution_pending']+$caution_money;
					$update_fees_challan['admission_pending']=$feechallan_detials['admission_pending']+$admission_form;
					$update_fees_challan['exam_pending']=$feechallan_detials['exam_pending']+$exam_fees;
					$update_fees_challan['university_pending']=$feechallan_detials['university_pending']+$university_fees;
					$update_fees_challan['tution_status']='N';
					$update_fees_challan['development_status']='N';
					$update_fees_challan['caution_status']='N';
					$update_fees_challan['admission_status']='N';
					$update_fees_challan['exam_status']='N';
					$update_fees_challan['university_status']='N';

					$DB1->where('fees_id', $feechallan_detials['fees_id']);
					$DB1->update('fees_challan',$update_fees_challan);

				}

			}
			
		

	  }
	
	
	
	public function check_current($data){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT count(paid_id) as Total FROM paid_fees WHERE  student_id='".$data['stud']."' AND facility='".$data['facility']."' AND curr_yr='".$data['curr_yr']."' AND academic_year='".$data['academic']."'"; //AND (enrollment_no='".$data['enroll']."' OR enrollment_no_new='".$data['enroll']."')
		$query = $DB1->query($sql);
		 $DB1->last_query();
		return $query->result_array();
	}
	
	public function get_paid_details($data){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT * FROM paid_fees WHERE  student_id='".$data['stud']."' AND facility='".$data['facility']."' AND curr_yr='".$data['curr_yr']."' AND academic_year='".$data['academic']."'
		";//AND (enrollment_no='".$data['enroll']."' OR enrollment_no_new='".$data['enroll']."')
		$query = $DB1->query($sql);
		 $DB1->last_query();
		return $query->result_array();
	}
	
		
	
	public function Check_challan($data){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT * FROM fees_challan WHERE  student_id='".$data['stud']."'   AND 
		type_id='".$data['facility']."' AND academic_year='".$data['academic']."'  AND challan_status !='CL' AND type_id='2' ORDER BY fees_id DESC limit 0,1";
		//AND (enrollment_no='".$data['enroll']."' OR enrollment_no_new='".$data['enroll']."')
		$query = $DB1->query($sql);
		 $DB1->last_query();
		return $query->result_array();
	}
		public function Check_challan_international($data){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT * FROM fees_challan_internationl WHERE  student_id='".$data['stud']."'  AND 
		type_id='".$data['facility']."' AND academic_year='".$data['academic']."'  AND challan_status !='CL' AND type_id='2'  ORDER BY fees_id DESC limit 0,1";
		$query = $DB1->query($sql);
		//AND (enrollment_no='".$data['enroll']."' OR enrollment_no_new='".$data['enroll']."')
		 $DB1->last_query();
		return $query->result_array();
	}



	function challan_rec_list(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT fees_paid_type FROM receipt GROUP BY fees_paid_type";
		$query = $DB1->query($sql);
		return  $query->result_array();
	}
	
	
 function get_recpt_list($data){
$DB1 = $this->load->database('umsdb', TRUE);
if($data['pst']!=''){
	$rwh=' and r.fees_paid_type="'.$data['pst'].'"';
}
if($data['styp']=='day'){
$dwh=" and DATE(r.created_on)='".date('Y-m-d',strtotime($data['sdt']))."' ";
	}elseif($data['styp']=='dur'){
$dwh =" and DATE(r.created_on) BETWEEN '".date('Y-m-d',strtotime($data['dfrm']))."' AND '".date('Y-m-d',strtotime($data['dto']))."' ";
	}
		 $sql="SELECT bm.bank_name as su_bank_name,r.curr_year,r.student_name,r.amount,r.cousre_name,r.fees_paid_type,r.receipt_no,r.challan_status,r.fees_date,r.exam_session,r.bank_id,b.bank_name as student_bank,r.TransactionNo,r.TransactionDate,r.created_on, 
		 fd.student_id as fstudent_id,fd.prov_reg_no,sm.enrollment_no
		 FROM receipt r 
		 left join fees_details fd on fd.college_receiptno=r.exam_session 
		 left join student_master sm on sm.stud_id=fd.student_id
		 left join bank_master b on r.bank_id=b.bank_id  
		 left join sandipun_erp.bank_master bm on r.bank_account_id=bm.bank_id 
		 where 1 $rwh $dwh ";
		$query = $DB1->query($sql);
		return  $query->result_array();

 }
 
 
 public function Search($Recepit, $Mobile,$TransactionNo,$academic_year='', $school_id='', $challan_type='')
	{
		$roleid= $this->session->userdata('role_id');
		$this->db->select("sandipun_ums.fees_type.fees_name, sandipun_ums.fees_challan.*,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,");
		$this->db->from("sandipun_ums.fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.stud_id=sandipun_ums.fees_challan.student_id",'left');
		$this->db->join("sandipun_ums.fees_type","sandipun_ums.fees_type.type_id=sandipun_ums.fees_challan.type_id",'left');
		
		
		
		
		
		
		
			//$this->db->where('sandipun_ums.fees_challan.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		if(!empty($Recepit)){
		$this->db->where('sandipun_ums.fees_challan.exam_session', $Recepit);
		}
		if(!empty($Mobile)){
		$this->db->where('sandipun_ums.fees_challan.enrollment_no', $Mobile);
		}
		if(!empty($TransactionNo)){
		$this->db->where('sandipun_ums.fees_challan.TransactionNo', $TransactionNo);
		}
		if(!empty($academic_year)){
			$this->db->where('sandipun_ums.fees_challan.academic_year', $academic_year);
		}
		if(!empty($challan_type)){
			$this->db->where('sandipun_ums.fees_challan.type_id', $challan_type);
		}		
		if(!empty($school_id)){
			$this->db->where('sandipun_ums.student_master.admission_school', $school_id);
		}
		$this->db->where('sandipun_ums.fees_challan.is_deleted', 'N');
		$this->db->order_by("sandipun_ums.fees_challan.fees_id", "DESC");
		if($roleid==15 || $roleid==14){
			$this->db->where('sandipun_ums.fees_type.related_to', 'exam');
		}
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
		//echo $this->db->last_query(); exit();
		return $query->result_array();
	}
	
	/* code by vighnesh */
	
	
	public function fees_challan_list_details($fees_paid_type='',$type='',$sub_type='',$date='',$comparison_parameter="")
	{
	  $challan_master='fees_challan';
	  if($sub_type==3){
	  $challan_master='fees_challan_phd';
	  }
		
		$this->db->select("sandipun_ums.".$challan_master.".*,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name");
		$this->db->from("sandipun_ums.$challan_master");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_ums.$challan_master.enrollment_no",'left');
		
		if($date!='' && $comparison_parameter !=''  && $comparison_parameter !=0)
		{
		   if($comparison_parameter==1){
			$this->db->where('sandipun_ums.'.$challan_master.'.fees_date =', $date);
		   }
		   else{
			$this->db->where('DATE(sandipun_ums.'.$challan_master.'.modified_on) =', $date);   
		   }
			
		}
		if($fees_paid_type!='' && $fees_paid_type!='0' )
		{
			
		  if($fees_paid_typ=='OTHER'){
			$this->db->where('sandipun_ums.'.$challan_master.'.fees_paid_type =', '');  
		  }
		  else{
		  $this->db->where('sandipun_ums.'.$challan_master.'.fees_paid_type =', $fees_paid_type);
		  }
			
		}
		if($type!='' && $type!=0 )
		{
			
		  if($type !=5)	{
		  $this->db->where('sandipun_ums.'.$challan_master.'.type_id =', $type);
		  }
		  else{
			  $array=array(5,7,8,9);
			$this->db->where_in('sandipun_ums.'.$challan_master.'.type_id',  $array);  
		  }
			
		}
		if($sub_type!=''  && $sub_type!=0   )
		{
		  if($sub_type==1){
			  $where = "sandipun_ums.student_master.academic_year=sandipun_ums.student_master.admission_session and sandipun_ums.student_master.admission_cycle IS NULL";
              $this->db->where($where);
			 
		  }
		  elseif($sub_type==2){
			  $where = "sandipun_ums.student_master.academic_year !=sandipun_ums.student_master.admission_session and sandipun_ums.student_master.admission_cycle IS NULL";
              $this->db->where($where);
		  }
		  elseif($sub_type==3){
			  $where = "sandipun_ums.student_master.admission_cycle IS NOT NULL";
              $this->db->where($where);
		  }
		  
		 
			
		}

		
		$this->db->where('sandipun_ums.'.$challan_master.'.is_deleted', 'N');
		$this->db->where('sandipun_ums.'.$challan_master.'.challan_status', 'VR');
		$this->db->order_by("sandipun_ums.".$challan_master.".fees_id", "DESC");
		$query1 = $this->db->get_compiled_select();
		
		
		
		
		$query = $this->db->query($query1);//." UNION ".$query2
		//echo $this->db->last_query(); exit();
		return $query->result_array();
	}
	function check_exits($challan_no,$payment_mode,$fees_date){
		$DB1 = $this->load->database('umsdb', TRUE);
		$data=array();
		$sql="SELECT count(fees_id) as Total FROM fees_details WHERE college_receiptno='$challan_no'";
		if($payment_mode!='GATEWAY-ONLINE'){
			$sql .=" and fees_date='$fees_date' and fees_paid_type='$payment_mode'";
		}
		$query=$DB1->query($sql);
		$data=$query->result_array();

		return $data[0]['Total'];

	}
	public function check_existing_facility_fees($enrollment_no, $academic, $receipt_no,$payment_mode,$fees_date)
    {
		$DB1 = $this->load->database('umsdb', TRUE);
        $DB1->where('receipt_no', $receipt_no);
		if($payment_mode!='GATEWAY-ONLINE'){
			$DB1->where('fees_date', $fees_date);
			$DB1->where('fees_paid_type', $payment_mode);
			//$sql .=" and fees_date='$fees_date' and fees_paid_type='$payment_mode'";
		}
        //$this->db->where('enrollment_no', $enrollment_no);
        //$this->db->where('academic_year', $academic);
        $query = $DB1->get('fees_details'); 
              // echo $DB1->last_query();exit;
        return $query->row_array();
    }
	public function check_existing_record_challan($enrollment_no, $academic, $receipt_no,$epayment_type)
    {
		$DB1 = $this->load->database('umsdb', TRUE);
        $DB1->where('receipt_no', $receipt_no);
        $DB1->where('fees_paid_type', $epayment_type);
		$DB1->where('academic_year', $academic);
        $query = $DB1->get('fees_challan'); 
        //        echo $this->db->last_query();exit;
        return $query->row_array();
    }	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
 
}