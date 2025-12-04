<?php
class Challan_hostel_report_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
       
    }
	public function fees_challan_list($data)
{
    $uid = $this->session->userdata("uid");
    $ids = array('1', '4');
    $exp = explode("_", $_SESSION['name']);
	
	if($data['is_daily_report']!=1){

		// ---------- Date filters (as DATETIME) ----------
		$fromDate = !empty($data['fdate']) ? date("Y-m-d 00:00:00", strtotime(str_replace('/', '-', $data['fdate']))) : null;
		$toDate   = !empty($data['tdate']) ? date("Y-m-d 23:59:59", strtotime(str_replace('/', '-', $data['tdate']))) : null;
		$oneDate  = !empty($data['odate']) ? date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))) : null;

		// ---------- 1️⃣ Base Challan Query (Unique by fees_id) ----------
		$this->db->select("
			fc.fees_id,
			fc.enrollment_no,
			fc.academic_year,
			fc.fees_paid_type,
			fc.amount,
			fc.bank_id,
			fc.bank_account_id,
			fc.student_id,
			fc.fees_date,
			fc.receipt_no,
			fc.created_on,
			fc.exam_session,
			fc.challan_status
		", false);
		$this->db->from("sandipun_erp.sf_fees_challan fc");

		// --- Base Filters
		$this->db->where_in('fc.type_id', $ids);
		$this->db->where('fc.is_deleted', 'N');
		$this->db->where('fc.created_by', $uid);

		// --- Date Filters (Datetime aware)
		if ($fromDate && $toDate) {
			$this->db->where('fc.created_on >=', $fromDate);
			$this->db->where('fc.created_on <=', $toDate);
		} elseif ($oneDate) {
			$this->db->where('DATE(fc.created_on)', $oneDate);
		}

		// --- Additional Filters
		if (!empty($data['status'])) {
			$this->db->where('fc.fees_paid_type', $data['status']);
		}
		if (!empty($data['acyear'])) {
			$this->db->where('fc.academic_year', $data['acyear']);
		}
		if (!empty($data['search'])) {
			$this->db->like('fc.enrollment_no', $data['search'], 'after');
		}

		// Compile Base Query
		$baseSql = $this->db->get_compiled_select();
		$this->db->reset_query();

		// ---------- 2️⃣ Deduped Student Facilities ----------
		$sfDedup = $this->db->select('enrollment_no, MAX(organisation) AS organisation', false)
			->from('sandipun_erp.sf_student_facilities')
			->group_by('enrollment_no')
			->get_compiled_select();
		$this->db->reset_query();

		// ---------- 3️⃣ Final Merged Query ----------
		$this->db->select("
			b.fees_id,
			b.enrollment_no,
			b.academic_year,
			b.fees_paid_type,
			b.amount,
			b.fees_date,
			b.receipt_no,
			b.created_on,
			b.exam_session,b.challan_status,

			COALESCE(ums_det.school_short_name, sf_sm.instute_name) AS school_name,
			COALESCE(ums_sm.gender, sf_sm.gender) AS gender,
			COALESCE(ums_sm.first_name, sf_sm.first_name) AS first_name,
			COALESCE(ums_sm.middle_name, sf_sm.middle_name) AS middle_name,
			COALESCE(ums_sm.last_name, sf_sm.last_name) AS last_name,
			COALESCE(ums_det.stream_name, sf_sm.course) AS stream_name,

			bad.bank_name,
			bad.branch_name,
			bm.bank_name AS stud_bankname,
			bad.account_name,
			bad.account_no,
			sff.organisation
		", false);
		$this->db->from("($baseSql) AS b");

		// --- Prefer UMS data when available
		$this->db->join(
			'sandipun_ums.student_master ums_sm',
			'ums_sm.enrollment_no = b.enrollment_no AND ums_sm.stud_id = b.student_id',
			'left'
		);
		$this->db->join(
			'sandipun_ums.vw_stream_details ums_det',
			'ums_det.stream_id = ums_sm.admission_stream',
			'left'
		);

		// --- Fallback: SF student data
		$this->db->join(
			'sandipun_erp.sf_student_master sf_sm',
			'sf_sm.enrollment_no = b.enrollment_no AND sf_sm.student_id = b.student_id',
			'left'
		);

		// --- Bank info
		$this->db->join('sandipun_erp.sf_bank_account_details bad', 'bad.bank_account_id = b.bank_account_id', 'left');
		$this->db->join('sandipun_ums.bank_master bm', 'bm.bank_id = b.bank_id', 'left');

		// --- Deduped student facility
		$this->db->join("($sfDedup) sff", 'sff.enrollment_no = b.enrollment_no', 'left');

		// --- Campus specific filter
		if (isset($exp[1]) && $exp[1] === "sijoul") {
			$this->db->where('sf_sm.organization', 'SF-SIJOUL');
		}

		// --- Order by latest
		$this->db->order_by('b.created_on', 'DESC');

		// Execute
		$query = $this->db->get();
		return $query->result_array();
	}else{
				// ---------- Date filters (as DATETIME) ----------
		$fromDate = !empty($data['fdate']) 
    ? date("Y-m-d 17:00:00", strtotime('-1 day', strtotime(str_replace('/', '-', $data['fdate'])))) 
    : null;
		$toDate   = !empty($data['tdate']) ? date("Y-m-d 23:59:59", strtotime(str_replace('/', '-', $data['tdate']))) : null;
		$oneDateto = !empty($data['odate']) 
    ? date("Y-m-d 17:00:00", strtotime(str_replace('/', '-', $data['odate']))) 
    : null;
		$odatefrom = !empty($data['odate']) 
    ? date("Y-m-d 17:00:00", strtotime('-1 day', strtotime(str_replace('/', '-', $data['odate'])))) 
    : null;

		// ---------- 1️⃣ Base Challan Query (Unique by fees_id) ----------
		$this->db->select("
			fc.fees_id,
			fc.enrollment_no,
			fc.academic_year,
			fc.fees_paid_type,
			fc.amount,
			fc.bank_id,
			fc.student_id,
			fc.fees_date,
			fc.receipt_no,
			fc.created_on,
			fc.exam_session
		", false);
		$this->db->from("sandipun_erp.sf_fees_details fc");

		// --- Base Filters
		$this->db->where_in('fc.type_id', $ids);
		$this->db->where('fc.is_deleted', 'N');
		$this->db->where('fc.created_by', $uid);

		// --- Date Filters (Datetime aware)
		if ($fromDate && $toDate) {
			$this->db->where('fc.created_on >=', $fromDate);
			$this->db->where('fc.created_on <=', $toDate);
		} elseif ($oneDateto) {
			//$this->db->where('DATE(fc.created_on)', $oneDate);
			$this->db->where('fc.created_on >=', $odatefrom);
			$this->db->where('fc.created_on <=', $oneDateto);
		}

		// --- Additional Filters
		if (!empty($data['status'])) {
			$this->db->where('fc.fees_paid_type', $data['status']);
		}
		if (!empty($data['acyear'])) {
			$this->db->where('fc.academic_year', $data['acyear']);
		}
		if (!empty($data['search'])) {
			$this->db->like('fc.enrollment_no', $data['search'], 'after');
		}

		// Compile Base Query
		$baseSql = $this->db->get_compiled_select();
		$this->db->reset_query();

		// ---------- 2️⃣ Deduped Student Facilities ----------
		$sfDedup = $this->db->select('enrollment_no, MAX(organisation) AS organisation', false)
			->from('sandipun_erp.sf_student_facilities')
			->group_by('enrollment_no')
			->get_compiled_select();
		$this->db->reset_query();

		// ---------- 3️⃣ Final Merged Query ----------
		$this->db->select("
			b.fees_id,
			b.enrollment_no,
			b.academic_year,
			b.fees_paid_type,
			b.amount,
			b.fees_date,
			b.receipt_no,
			b.created_on,
			b.exam_session,

			COALESCE(ums_det.school_short_name, sf_sm.instute_name) AS school_name,
			COALESCE(ums_sm.gender, sf_sm.gender) AS gender,
			COALESCE(ums_sm.first_name, sf_sm.first_name) AS first_name,
			COALESCE(ums_sm.middle_name, sf_sm.middle_name) AS middle_name,
			COALESCE(ums_sm.last_name, sf_sm.last_name) AS last_name,
			COALESCE(ums_det.stream_name, sf_sm.course) AS stream_name,

			bad.bank_name,
			bad.branch_name,
			bm.bank_name AS stud_bankname,
			bad.account_name,
			bad.account_no,
			sff.organisation
		", false);
		$this->db->from("($baseSql) AS b");

		// --- Prefer UMS data when available
		$this->db->join(
			'sandipun_ums.student_master ums_sm',
			'ums_sm.enrollment_no = b.enrollment_no AND ums_sm.stud_id = b.student_id',
			'left'
		);
		$this->db->join(
			'sandipun_ums.vw_stream_details ums_det',
			'ums_det.stream_id = ums_sm.admission_stream',
			'left'
		);

		// --- Fallback: SF student data
		$this->db->join(
			'sandipun_erp.sf_student_master sf_sm',
			'sf_sm.enrollment_no = b.enrollment_no AND sf_sm.student_id = b.student_id',
			'left'
		);

		// --- Bank info
		$this->db->join('sandipun_erp.sf_bank_account_details bad', 'bad.bank_account_id = b.bank_id', 'left');
		$this->db->join('sandipun_ums.bank_master bm', 'bm.bank_id = b.bank_id', 'left');

		// --- Deduped student facility
		$this->db->join("($sfDedup) sff", 'sff.enrollment_no = b.enrollment_no', 'left');

		// --- Campus specific filter
		if (isset($exp[1]) && $exp[1] === "sijoul") {
			$this->db->where('sf_sm.organization', 'SF-SIJOUL');
		}

		// --- Order by latest
		$this->db->order_by('b.created_on', 'DESC');
		
		// Execute
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();

	}
}




	///daily list


	public function fees_challan_list_daily($data)
	{
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_ums.student_master.first_name,
			sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,
			sandipun_ums.stream_master.stream_name,sandipun_ums.student_master.current_year,
			sandipun_ums.student_master.academic_year,sandipun_ums.bank_master.bank_name as student_bank,sandipun_erp.bank_master.bank_name as su_bank_name,sandipun_ums.stream_master.stream_short_name");
		$this->db->from("sandipun_erp.sf_fees_challan");
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_ums.fees_challan.enrollment_no OR sandipun_ums.student_master.enrollment_no_new=sandipun_ums.fees_challan.enrollment_no",'left');
	
		//$this->db->join("sandipun_ums.admission_details","sandipun_ums.admission_details.student_id=sandipun_ums.student_master.stud_id",'inner');
		$this->db->join("sandipun_ums.stream_master","sandipun_ums.stream_master.stream_id=sandipun_ums.student_master.admission_stream",'left');
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.fees_challan.bank_id=sandipun_ums.bank_master.bank_id",'left');
		$this->db->join("sandipun_erp.bank_master","sandipun_ums.fees_challan.bank_account_id=sandipun_erp.bank_master.bank_id",'left');
		
		
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('DATE(sandipun_ums.fees_challan.created_on) >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('DATE(sandipun_ums.fees_challan.created_on) <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		if(isset($data['odate']) && $data['odate']!='')
		
		{
			$this->db->where('DATE(sandipun_ums.fees_challan.created_on)',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));

		}
		
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.fees_paid_type', $data['status']);
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
		/*echo $this->db->last_query(); 
		exit();*/
		return $query->result_array();
	}//end of

	public function fees_challan_list_pdf($data)
	{
		$uid=$this->session->userdata("uid");
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.vw_stream_details.stream_name,`sandipun_erp`.`sf_bank_account_details`.`bank_name`,`sandipun_erp`.`sf_bank_account_details`.branch_name,sandipun_ums.bank_master.bank_name as stud_bankname, sandipun_erp.sf_bank_account_details.account_name,sandipun_erp.sf_bank_account_details.account_no,sandipun_ums.student_master.current_year,sandipun_erp.sf_student_facilities.organisation,");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no_new=sandipun_erp.sf_fees_challan.enrollment_no 
		OR `sandipun_ums`.`student_master`.`enrollment_no`=`sandipun_erp`.`sf_fees_challan`.`enrollment_no` 
		AND sandipun_ums.student_master.stud_id=sandipun_erp.sf_fees_challan.student_id","INNER");
		$this->db->join("sandipun_erp.sf_student_facilities","sandipun_erp.sf_student_facilities.enrollment_no = sandipun_erp.sf_fees_challan.enrollment_no");
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = sandipun_erp.sf_fees_challan.bank_id",'left');		
		$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = sandipun_erp.sf_fees_challan.bank_account_id");
		$this->db->join("sandipun_ums.vw_stream_details","sandipun_ums.vw_stream_details.stream_id = sandipun_ums.student_master.admission_stream",'left');

		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_erp.sf_fees_challan.type_id', '1');
		$this->db->where('sandipun_erp.sf_fees_challan.created_by', $uid);
        $this->db->where('sandipun_ums.student_master.actice_status', 'Y');
		$this->db->where('DATE(sandipun_erp.sf_fees_challan.created_on)=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['selectdate']))));

		
	  //  $this->db->order_by("sandipun_erp.sf_fees_challan.fees_id", "ASC");




		$query1 = $this->db->get_compiled_select();
		
		
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_erp.sf_student_master.instute_name as school_name,sandipun_erp.sf_student_master.enrollment_no,sandipun_erp.sf_student_master.first_name,sandipun_erp.sf_student_master.middle_name,sandipun_erp.sf_student_master.last_name,sandipun_erp.sf_student_master.course as stream_name,`sandipun_erp`.`sf_bank_account_details`.`bank_name`,`sandipun_erp`.`sf_bank_account_details`.branch_name,sandipun_ums.bank_master.bank_name as stud_bankname, sandipun_erp.sf_bank_account_details.account_name,sandipun_erp.sf_bank_account_details.account_no,sandipun_erp.sf_student_master.current_year,sandipun_erp.sf_student_facilities.organisation,");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_erp.sf_student_master","sandipun_erp.sf_student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no AND sandipun_erp.sf_student_master.student_id=sandipun_erp.sf_fees_challan.student_id","INNER");
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = sandipun_erp.sf_fees_challan.bank_id",'left');
		$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = sandipun_erp.sf_fees_challan.bank_account_id");
		$this->db->join("sandipun_erp.sf_student_facilities","sandipun_erp.sf_student_facilities.enrollment_no = sandipun_erp.sf_fees_challan.enrollment_no");
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_erp.sf_fees_challan.type_id', '1');
		$this->db->where('sandipun_erp.sf_fees_challan.created_by', $uid);
		$this->db->where('sandipun_erp.sf_student_master.isactive', 'Y');
		$this->db->where('DATE(sandipun_erp.sf_fees_challan.created_on)=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['selectdate']))));

		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
        $this->db->where('sandipun_erp.sf_student_master.organization', 'SF-SIJOUL');
        }
		
		//$this->db->order_by("sandipun_erp.sf_fees_challan.fees_id", "ASC");
		
		$query2 = $this->db->get_compiled_select();
		
	   //$this->db->order_by("sandipun_erp.sf_fees_challan.fees_id", "DESC");
		
		if($exp[1]=="sijoul")
        {
              $query = $this->db->query($query2);
        }else{			
		$query = $this->db->query($query1." UNION ".$query2);
		}
		
		//echo $this->db->last_query(); 
		//exit();
		return $query->result_array();
	}



	public function fees_challan_list_today($data)
	{
			$this->db->select("sum(amount) as amt,fees_paid_type");
			$this->db->from('sf_fees_challan');
			$this->db->where('type_id', 1);
			$this->db->where('DATE(sf_fees_challan.created_on)=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['selectdate']))));
			$this->db->group_by('fees_paid_type');
			$query=$this->db->get();
			/*  echo $this->db->last_query();
			die();  */ 
			$result=$query->result_array();
			return $result;
		
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
		AND `ad`.`cancelled_admission` = 'N'";//AND ad.academic_year =  '".$data['academic']."'
	
		$query = $DB1->query($sql);
		if($this->session->userdata("uid")==2){
		//echo $DB1->last_query(); //af.admission_year=ad.academic_year AND
		}
		return $query->row_array();
	}
		
	function challan_rec_list(){
		//$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT fees_paid_type FROM sf_fees_challan where fees_paid_type !='' and type_id=1 GROUP BY fees_paid_type";
		$query = $this->db->query($sql);
		return  $query->result_array();
	}
	
	
	
	
 
}