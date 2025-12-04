<?php
class Enquiry_model1 extends CI_Model
{
	var $table = 'enquiry_student_master';
	var $column_order = array(null, 'eq.enquiry_id', 'eq.created_on', 'eq.payment_date', 'eq.date_enter'); //set column field database for datatable orderable
	var $column_search = array('eq.enquiry_no', 'eq.provisional_no', 'eq.first_name', 'eq.middle_name', 'eq.last_name', 'eq.email_id', 'eq.mobile', 'eq.altarnet_mobile', 'eq.form_no', 'vw.stream_name'); //set column field database for datatable searchable 
	var $order = array('eq.enquiry_id' => 'DESC'); // default order 


	var $table_online = 'student_master';
	var $column_order_online = array(null, 'eq.stud_id', 'eq.created_on'); //set column field database for datatable orderable
	var $column_search_online = array('eq.stud_id', 'eq.enrollment_no_new', 'eq.enrollment_no', 'eq.first_name', 'eq.middle_name', 'eq.last_name', 'eq.mobile', 'eq.form_number'); //set column field database for datatable searchable 
	var $order_online = array('op.payment_id' => 'DESC'); // default order 

	var $table_all = 'student_master';
	var $column_order_all = array(null, 'eq.stud_id', 'eq.created_on'); //set column field database for datatable orderable
	var $column_search_all = array('eq.stud_id', 'eq.enrollment_no_new', 'eq.enrollment_no', 'eq.first_name', 'eq.mobile', 'eq.form_number'); //set column field database for datatable searchable 
	var $order_all = array('eq.stud_id' => 'DESC'); // default order 



	function __construct()
	{
		parent::__construct();
		//$DBU=$this->load->database('umsdb', TRUE);
		//$this->load->database();
	}

	public function get_facility_types()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from("sf_facility_types");
		$DB1->where('status', 'Y');
		$query = $DB1->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	public function get_academic_details()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select * From sf_academic_year";
		$query = $DB1->query($sql);
		return  $query->result_array();
	}
	public function get_depositedto()
	{
		$DB1 = $this->load->database('erpdb', TRUE);
		$DB1->select("*");
		$DB1->from("bank_master");
		$DB1->where('status', 'Y');
		//$this->db->where('account_for',$data['faci_type']);
		$query = $DB1->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	function getbanks()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('bank_master');
		$DB1->where("active", "Y");
		$query = $DB1->get();
		/*  echo $this->db->last_query();
			die();  */
		$result = $query->result_array();
		return $result;
	}

	//ValidFunction
	function chek_mob_exist($mobile_no, $Enquiry_search, $adhar_search = '', $year = '')
	{ //$mobile_no,$Enquiry_search,$adhar_search //($mobile_no,$Enquiry_search,$search='')

		$DBU = $this->load->database('umsdb', TRUE);
		$updated_by = $this->session->userdata('uid');

		if (empty($year)) {
			$year =  ADMISSION_YEAR;
		}

		if (!empty($adhar_search)) {
			$sql = "select esm.* FROM sandipun_ums.enquiry_student_master as esm
	 
	  WHERE esm.status='Y' AND (esm.aadhar_card='$adhar_search' or  esm.citizenship_id='$adhar_search') and admission_session='$year'";
		} else {
			$sql = "select esm.* FROM sandipun_ums.enquiry_student_master as esm
	 
	  WHERE esm.status='Y' AND esm.enquiry_no='$Enquiry_search' and admission_session='$year'";
		}
		//  $Enquiry_search = $var['Enquiry_search'];
		//  $adhar_search = $var['adhar_search'];
		/*if(!empty($Enquiry_search)){csd.`csd_id`,csd.`Creamy_Layer`,csd.`Photo`,csd.`Nationality`,csd.`Domicile`,csd.`Cast`,csd.`SSC`,csd.`HSC`,
	 csd.`CET`,csd.`validity_certificate`,csd.`vc_recepit` LEFT JOIN sandipun_ic_erp22.consultant_student_document as csd ON csd.enquiry_no=esm.enquiry_no
		   $sql="select esm.*,csd.`csd_id`,csd.`Creamy_Layer`,csd.`Photo`,csd.`Nationality`,csd.`Domicile`,csd.`Cast`,csd.`SSC`,csd.`HSC`,
		   csd.`CET`,csd.`validity_certificate`,csd.`vc_recepit` FROM enquiry_student_master as esm
		   LEFT JOIN consultant_student_document as csd ON csd.enquiry_no=esm.enquiry_no
		   WHERE esm.enquiry_no='$Enquiry_search' AND esm.status='Y'";	
	  }else{
	  if(!empty($mobile_no)){
		$sql="select esm.*,csd.`csd_id`,csd.`Creamy_Layer`,csd.`Photo`,csd.`Nationality`,csd.`Domicile`,csd.`Cast`,csd.`SSC`,csd.`HSC`,csd.`CET`,csd.`validity_certificate`,csd.`vc_recepit` FROM enquiry_student_master as esm
		 LEFT JOIN consultant_student_document as csd ON csd.enquiry_no=esm.enquiry_no
		 WHERE esm.status='Y' AND (esm.mobile='$mobile_no' OR esm.altarnet_mobile='$mobile_no')";
	  }else if(!empty($search)){
     $sql="select esm.*,csd.`csd_id`,csd.`Creamy_Layer`,csd.`Photo`,csd.`Nationality`,csd.`Domicile`,csd.`Cast`,csd.`SSC`,csd.`HSC`,csd.`CET`,csd.`validity_certificate`,csd.`vc_recepit` FROM enquiry_student_master as esm
	  LEFT JOIN consultant_student_document as csd ON csd.enquiry_no=esm.enquiry_no
	  WHERE esm.status='Y' AND esm.aadhar_card='$search'";
	  }	  
	  else{
	  $sql="select esm.*,csd.`csd_id`,csd.`Photo`,csd.`Nationality`,csd.`Domicile`,csd.`Cast`,csd.`SSC`,csd.`HSC`,csd.`CET`,csd.`validity_certificate`,csd.`vc_recepit`FROM enquiry_student_master as esm
	   LEFT JOIN consultant_student_document as csd ON csd.enquiry_id=esm.enquiry_id
	   WHERE esm.enquiry_no='$Enquiry_search' AND esm.status='Y'";	  
	  }
	  }*/
		// echo $sql;
		//  exit;
		$query = $DBU->query($sql);
		//$query = $this->db->get();
		$result = $query->result_array();
		// echo $DBU->last_query();exit;
		return $result;
	}
//ValidFunction
	function get_all_countries()
	{
		$DB1 = $this->load->database('icdb', TRUE);
		$sql = "select * from countries where 1 ";
		$query  =  $DB1->query($sql);
		$result = $query->result_array();
		//echo $this->db->last_query();exit;
		return $result;
	}

//ValidFunction
	function check_id_in_ic()
	{
		$DB1 = $this->load->database('icdb', TRUE);
		
		$username = $_SESSION['name'];
		$emp_name = $_SESSION['emp_name'];
		$sname = $_SESSION['aname'];

		$sql = "select um.um_id from inhouse_staff_details s join user_master as um on s.staff_id=um.username and um.roles_id=33  where 1 ";

		$params = [];

		// Conditionally append WHERE clauses
		if (!empty($username)) {
			$sql .= " AND s.staff_id = ?";
			$params[] = $username;
		}


		if (!empty($sname)) {
			$sql .= " AND s.student_id = ?";
			$params[] = $sname;
		}

		$query = $DB1->query($sql, $params);
		//echo $DB1->last_query();exit;
		$data = $query->result_array();

		if (empty($data)) {
			
			$data1['staff_name'] = $emp_name;
			$data1['staff_id'] = $username;
			$data1['student_id'] = $sname;
			$data1['is_student'] = 1;
			$data1['created_on'] = date('Y-m-d H:i:s');
			$inserted = $DB1->insert('inhouse_staff_details', $data1);
			// echo $DB1->last_query();exit;
			$last_id = $DB1->insert_id();
			if ($inserted) {
				$data2['username'] = $username;
				$data2['staff_id'] = $last_id;
				$data2['password'] = random_int(0, 999999);
				$data2['roles_id'] = 33;
				$data2['inserted_datetime'] = date('Y-m-d H:i:s');
				$inserted = $DB1->insert('user_master', $data2);
				

				if ($inserted) {
					$last_id = $DB1->insert_id(); // Retrieves the ID of the inserted row
					return $last_id;
				} else {
					return false; // Insertion failed
				}



			} else {
				return false;  // Insert failed
			}
		} else {
			return ($data[0]['um_id']);
		}
		
	}


//ValidFunction
	function fetch_states($is_country_id = '')
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$con = '';
		if (!empty($is_country_id)) {
			$con = " and country_id=$is_country_id";
		}
		$sql = "SELECT * from states where 1 $con order by state_name";
		$query = $DB1->query($sql);
		return $query->result_array();
	}

	//ValidFunction
	public function getStatewiseDistrict($stateid)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select district_id, district_name from district_name where state_id='$stateid' order by district_name";
		$query = $DB1->query($sql);
		$res = $query->result_array();
		echo $DB1->last_query();
		return $res;
	}

	//ValidFunction
	public function getStateDwiseCity($stateid, $district_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select taluka_id, taluka_name from taluka_master where state_id='$stateid' and district_id='$district_id' order by taluka_name";
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();
		return $res;
	}

	//ValidFunction
	function list_schools_data($id, $campus = '')
	{
		/*sandipun_univerdb.`school_programs_new`.`min_qualification`='$id'*/
		if ($campus == 1) {
			$campus_city = 'NASHIK';
		} else {
			$campus_city = 'SIJOUL';
		}
		if ($id == 'PG') {
			$id = 'UG';
		}
		$data = $this->db->query("SELECT * FROM 
	sandipun_ums.common_vw_stream_details 
	WHERE campus='$campus_city' and FIND_IN_SET ('$id', minimum_qk_required)
	GROUP BY school_id")->result_array();
		//echo $this->db->last_query();
		return $data;
	}

	//ValidFunction
	function getschool_course($school = '', $hq = '', $Campus)
	{
		//echo $school;
		if ($Campus == 1) {
			$campus_city = 'NASHIK';
		} else {
			$campus_city = 'SIJOUL';
		}

		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT DISTINCT(sandipun_ums.common_vw_stream_details.course_id),sandipun_ums.common_vw_stream_details.course_name,
		 sandipun_ums.common_vw_stream_details.course_short_name FROM sandipun_ums.common_vw_stream_details
		 WHERE FIND_IN_SET ('$hq', minimum_qk_required) AND campus='$campus_city'"; //

		if ($school != '') {
			$sql .= " and sandipun_ums.common_vw_stream_details.school_id = $school";
		}
		$query = $DB1->query($sql);
		//echo $DB1->last_query();
		//exit();
		return $query->result_array();
	}

	//ValidFunction
	function  get_course_streams_yearwise()
	{
		if ($_POST['Campus'] == 1) {
			$campus_city = 'NASHIK';
		} else {
			$campus_city = 'SIJOUL';
		}
		$DB1 = $this->load->database('umsdb', TRUE);
		$highest_qualification = $_POST['highest_qualification'];
		$DB1->select("vd.stream_id,vd.stream_name,vd.stream_short_name");
		$DB1->from('common_vw_stream_details vd');
		$DB1->join('academic_fees as af', 'af.stream_id = vd.stream_id', 'left');
		$DB1->where("vd.course_id", $_POST['course']);
		$DB1->where("vd.school_id", $_POST['school_id']);
		$DB1->where("vd.active_for_year", '2022'); //2021
		$DB1->where("af.academic_year", '2022-23');
		$DB1->where("vd.campus", $campus_city);
		$where = "FIND_IN_SET ('$highest_qualification', vd.minimum_qk_required)";
		$DB1->where($where);
		$DB1->group_by("vd.stream_id");
		//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');highest_qualification
		//	$DB1->where("certificate_name", $certtype);
		$query = $DB1->get();
		//echo $DB1->last_query();exit;
		$stream_details =  $query->result_array();

		$streams_id = $_POST['schoola'];

		$sel = '';
		echo '<option value="">Select Stream</option>';
		foreach ($stream_details as $course) {
			if ($course['stream_id'] == $streams_id) {
				$sel = 'selected="selected"';
			} else {
				$sel = '';
			}
			echo '<option value="' . $course['stream_id'] . '" ' . $sel . '>' . $course['stream_name'] . '</option>';
		}
	}

//ValidFunction
	function fetch_academic_fees_for_stream_year($strm_id, $acyear, $year8 = '')
	{
		//   echo $acyear;
		$acy =  substr($acyear, -2);
		$ny = $acy + 1;
		$year = $acyear . "-" . $ny;
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('academic_fees');
		$DB1->where('stream_id', $strm_id);
		$DB1->where('academic_year', $year);
		if ($year8 != '') {


			$DB1->where('year', $year8);
		}
		$query = $DB1->get();
		$result = $query->result_array();

		//echo $DB1->last_query();
		//exit(0);
		//	var_dump($result);
		return $result;
	}

	//ValidFunction
	function Scholarship_type()
	{

		$DB1 = $this->load->database('umsdb', TRUE);

		$DB1->select("*");
		$DB1->from("schlorship_type");
		$DB1->where("status", "Y");
		$DB1->group_by("type");

		$query = $DB1->get();

		$result = $query->result_array();
		return $result;
	}

	//ValidFunction
	function Scholarship_typee()
	{

		$DB1 = $this->load->database('umsdb', TRUE);

		$DB1->select("*");
		$DB1->from("schlorship_type");
		$DB1->where("status", "Y");
		//$DB1->group_by("type");

		$query = $DB1->get();

		$result = $query->result_array();
		return $result;
	}



	//check mobile
	function chek_formno_exist($formno)
	{
		$ICDB = $this->load->database('icdb', TRUE);

		$ICDB->select('adm_form_no');
		$ICDB->from('provisional_admission_details');
		$ICDB->where('adm_form_no', $formno);
		$query = $ICDB->get();
		$result = $query->result_array();
		///echo $ICDB->last_query();//exit;
		return $result;
	}

	//ValidFunction
	function chek_formno_exist_withapprove($formno)
	{
		$ICDB = $this->load->database('icdb', TRUE);
		$DB1 = $this->load->database('umsdb', TRUE);
		$formno = trim($formno);
		$ICDB->select('pros_serial_no');
		$ICDB->from('material_distribution_details');
		$ICDB->where('pros_serial_no', $formno);
		$ICDB->where('status', '1');
		$query = $ICDB->get();
		$result = $query->result_array();
		// echo $ICDB->last_query();exit;
		//print_r($result);
		return $result;
	}
	function create_Form($countt)
	{
		exit();
		$ICDB = $this->load->database('icdb', TRUE);

		for ($i = 2000; $i < $countt; $i++) {
			$form_no = '20R01000' . $i;  //20R010001999 //20R010002000
			echo $sql = "INSERT INTO `material_distribution_details` (`id`, `mat_req_id`, `pros_serial_no`, `status`, `distributed_to`, `ic_code`, `ic_name`, `distributed_material`, `distributed_to_mobile`, `department`, `campus_name`, `dispatch_type`, `dispatch_date`, `dispatch_type_ref_no`, `created_by`, `created_date`) VALUES (NULL, '51', '$form_no', '1', 'D D Shinde Sir ', '0', '0', 'SU Prospec', '9445453228', 'ADMISSION', 'Nashik', '0', '2020-03-11', '0', '0', '2020-03-11 13:22:15')";
			echo '<br>';
			$ICDB->query($sql);
		}
	}
	//check serial no
	function chek_duplicate_serial_no($serial_no)
	{
		$ICDB = $this->load->database('icdb', TRUE);

		$ICDB->select('pros_serial_no');
		$ICDB->from('material_distribution_details');
		$ICDB->where('pros_serial_no', $serial_no);
		$query = $ICDB->get();
		$result = $query->result_array();
		///echo $ICDB->last_query();//exit;
		return $result;
	}

	function get_schollership_by_id($id)
	{
		$DB = $this->load->database('umsdb', TRUE);
		$DB->select('type,schlorship_name');
		$DB->from('schlorship_type');
		$DB->where('s_id', $id);
		$query = $DB->get();
		$result = $query->result_array();
		///echo $this->db->last_query();//exit;
		return $result;
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	function Enquiry_insert($values)
	{
		/*ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);*/

		function getUserIpAddr()
		{
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				//ip from share internet
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				//ip pass from proxy
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}
		function Enquiry_no($DB1)
		{

			//$num = 1;
			//printf("%04d", $num);
			//print_r($DB1);
			//$DB=$this->load->database('umsdb',TRUE);
			$DB1->select('enquiry_id,form_no,provisional_no');
			$DB1->from('enquiry_student_master');
			$DB1->order_by('enquiry_id', 'DESC');
			$DB1->limit('1');
			$query = $DB1->get();
			$result = $query->result_array();
			return $result[0]['enquiry_id'] + (1);
		}

		$DB = $this->load->database('umsdb', TRUE);
		//print_r($values);
		$Enquiry_no = Enquiry_no($DB);
		//printf("%04d", $Enquiry_no);
		$num_str = sprintf("%06d", $Enquiry_no);
		//exit();
		$updated_by = $this->session->userdata('uid');
		$ic_code = $this->session->userdata('ic_code');
		$year =  $this->config->item('current_year');
		$current_year = $current_year[0];
		$current_year = substr($current_year, -2);
		$enquiry_newno = $current_year . 'EN' . $num_str;


		$Enquiry['enquiry_no'] = $enquiry_newno;

		$Enquiry['first_name'] = strtoupper($values['first_name']);
		$Enquiry['middle_name'] = strtoupper($values['middle_name']);
		$Enquiry['last_name'] = strtoupper($values['last_name']);
		$Enquiry['email_id'] = ($values['email_id']);
		$Enquiry['mobile'] = $values['mobile'];

		$Enquiry['altarnet_mobile'] = $values['altarnet_mobile'];

		$Enquiry['state_id'] = $values['state_id'];
		//$Enquiry['state_name']=$values['state_name'];
		$Enquiry['district_id'] = $values['district_id'];
		//$Enquiry['district_name']=$values['district_name'];
		$Enquiry['city_id'] = $values['city_id'];
		//$Enquiry['city_name']=$values['city_name'];
		/////////////////////////////////////////////////////////////////////////////////////////////
		$Enquiry['pincode'] = $values['pincode'];
		$Enquiry['admission_type'] = $values['admission_type'];
		$Enquiry['gender'] = $values['gender'];
		$Enquiry['aadhar_card'] = $values['aadhar_card'];
		$Enquiry['category'] = $values['category'];
		$Enquiry['last_qualification'] = $values['last_qualification'];
		$Enquiry['qualification_percentage'] = $values['qualification_percentage'];

		$Enquiry['school_id'] = $values['school_id'];
		//	$Enquiry['school_name']=$values['school_name'];
		$Enquiry['course_id'] = $values['course_id'];
		//	$Enquiry['course_name']=$values['course_name'];
		$Enquiry['stream_id'] = $values['stream_id'];
		//	$Enquiry['stream_name']=$values['stream_name'];
		/////////////////////////////////////////////////////////////////////////////////////////////
		$Enquiry['actual_fee'] = $values['actual_fee'];
		$Enquiry['tution_fees'] = $values['tution_fees'];
		$Enquiry['form_taken'] = $values['form_taken'];
		$Enquiry['form_no'] = $values['form_no'];
		$Enquiry['form_amount'] = $values['form_amount'];
		$Enquiry['payment_mode'] = $values['payment_mode'];
		$Enquiry['payment_date'] = date('Y-m-d');
		$Enquiry['recepit_no'] = $values['TransactionNo'];
		//////////////////////////////////////////////////////////////////
		$Enquiry['hostel_allowed'] = $values['hostel_allowed'];
		///////////////////////////////////////////////////////////////////
		$Enquiry['scholarship_allowed'] = $values['scholarship_allowed'];

		if ($values['scholarship_allowed'] == "YES") {

			$Enquiry['other_scholarship'] = $values['Other_Scholarship_selected'];
			$Enquiry['sports_scholarship'] = $values['Sports_Scholarship_selecet'];
			$Enquiry['merit_state'] = $values['Scholarship_state'];
			$Enquiry['merit_scholarship'] = $values['Merit_Scholarship_selected'];
			//////////////////////////////////////////////////////////////////////////////////
			$scholarship_id = '';
			if ($values['Other_Scholarship_selected'] == 23) {
			} else {
				$scholarship_id = $values['Other_Scholarship_selected'];
			}
			if ($values['Sports_Scholarship_selecet'] == 24) {
			} else {
				$scholarship_id = $values['Sports_Scholarship_selecet'];
			}
			if (($values['Merit_Scholarship_selected'] == 25) || ($values['Merit_Scholarship_selected'] == 26)) {
				// $scholarship_id=$values['Merit_Scholarship_selected'];
			} else {
				$scholarship_id = $values['Merit_Scholarship_selected'];
			}


			$Enquiry['scholarship_id'] = $scholarship_id;
			$scholar_name = $this->get_schollership_by_id($scholarship_id);
			$Enquiry['scholarship_type'] = $scholar_name[0]['type'];
			$Enquiry['scholarship_name'] = $scholar_name[0]['schlorship_name'];
			//////////////////////////////////////////////////////////////////////////////////
			$Enquiry['scholarship_amount'] = $values['Scholarship_Amount'];
			//$Enquiry['without_scholarship']=$values['without_scholarship'];//$values['mpfees'];
			$Enquiry['with_scholarship'] = $values['Paid'];
			if ($values['scholarship_allowed'] == "Y") {
				$Enquiry['scholarship_status'] = 'Pending';
			}

			$Enquiry['final_Pay'] = $values['final_Pay'];
		} else { //////////////////////////////////////////////////scholarship_allowed NO
			$Enquiry['other_scholarship'] = '';
			$Enquiry['sports_scholarship'] = '';
			$Enquiry['merit_state'] = '';
			$Enquiry['merit_scholarship'] = '';
			$Enquiry['scholarship_id'] = '';
			$Enquiry['scholarship_type'] = '';
			$Enquiry['scholarship_name'] = '';
			//////////////////////////////////////////////////////////////////////////////////
			$Enquiry['scholarship_amount'] = '';
			//$Enquiry['without_scholarship']='';
			$Enquiry['with_scholarship'] = '';
			$Enquiry['scholarship_status'] = 'None';
			$Enquiry['final_Pay'] = '';
		}

		$Enquiry['without_scholarship'] = $values['without_scholarship'];
		////////////////////////////////////////////////////////////////////////////////////
		$Enquiry['hostel_allowed'] = $values['hostel_allowed'];
		$Enquiry['applicable'] = $values['applicable'];

		$Enquiry['reference'] = $values['reference'];
		$Enquiry['other_reference'] = $values['Reference_other'];

		$Enquiry['enquiry_taken'] = $values['enquiry_taken'];
		$Enquiry['enquiry_mobile'] = $values['enquiry_mobile'];
		$Enquiry['staff_id'] = $values['staff_id'];
		//////////////////////////////////////////////////////////////////
		$year =  $this->config->item('current_year');
		$current_year = explode('-',  $year);
		$current_year = $current_year[0];
		$Enquiry['academic_year'] = $current_year;
		$Enquiry['current_year'] = $values['admission_type'];
		$Enquiry['admission_session'] = $current_year;
		$Enquiry['admission_year'] = $current_year;
		/////////////////////////////////////////////////////////
		$Enquiry['date_enter'] = date('Y-m-d');
		$Enquiry['academic_year'] = date('Y');
		$Enquiry['ic_code'] = $ic_code;
		$Enquiry['created_on'] = date('Y-m-d H:i:s');
		$Enquiry['created_by'] = $updated_by;
		$Enquiry['updated_on'] = '';
		$Enquiry['updated_by'] = $updated_by;
		$Enquiry['ip_address'] = getUserIpAddr();

		$current_status = '';
		//if(empty($values['form_no'])){
		$current_status = 'enquiry';
		//}else{
		//$current_status='Form Taken';
		//}
		$Enquiry['enquiry_status'] = $current_status;


		$ICDB = $this->load->database('icdb', TRUE);


		$ICDB->trans_begin();
		$result = $DB->insert('enquiry_student_master', $Enquiry);

		//print_r($result);
		//exit();
		$ICDB->trans_complete();
		if ($ICDB->trans_status() === FALSE) {
			$ICDB->trans_rollback();
			$enquiry_id = $ICDB->insert_id();
			return $enquiry_id . '/' . $enquiry_newno;
		} else {
			$ICDB->trans_commit();
			$enquiry_id = $ICDB->insert_id();
			return $enquiry_id . '/' . $enquiry_newno; //$ICDB->insert_id();
		}
		/*if($result)
	{
		echo '1';
	}else{
		echo '2';
	}*/
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ValidFunction
	function check_if_exists($enquiry_no, $enquiry_id, $student_id)
	{


		$DB5 = $this->load->database('umsdb', TRUE);
		$DB5->select("count(*) as ucount");
		$DB5->from('consultant_student_document');
		//$DB5->where($cname1,$cvalue1);
		$DB5->where('enquiry_no', $enquiry_no);
		//	$DB1->join('address_details as ad','sm.stud_id = ad.student_id','left');
		//	$DB1->where("adds_of", "STUDENT");
		//	$DB1->where("address_type", "CORS");d.district_name,c.taluka_name,s.state_name
		$query = $DB5->get();
		$cn = $query->row_array();
		return $cn['ucount'];
	}
//ValidFunction
	function check_aadhar_card_exist($adhar_card, $year = '')
	{
		$DB1 = $this->load->database('icdb', TRUE);
		if (empty($year)) {
			$year =  $this->config->item('current_year');
		}
		$current_year = explode('-',  $year);
		$current_year = $current_year[0];
		$smd = $DB1->query("select adhar_no from  student_meet_details where adhar_no='$adhar_card' and academic_year='$year'")->row();
		$smd1 = $DB1->query("select add_no from aadhar_car_updation  where aadhar_car_updation.add_no='$adhar_card' and academic_year='$year'")->row();
		$DB = $this->load->database('umsdb', TRUE);
		$eqd = $DB->query("select aadhar_card from  enquiry_student_master where aadhar_card='$adhar_card' and admission_session='$current_year'
	
		")->row();
		$eqd1 = $DB->query("select aadhar_card from  sandipun_ums_sijoul.enquiry_student_master where aadhar_card='$adhar_card' and admission_session='$current_year'")->row();
		$main = $DB->query("select adhar_card_no from  student_master where adhar_card_no='$adhar_card' and 
		admission_session='$current_year' and cancelled_admission='N' and enrollment_no IS NOT NULL  and enrollment_no !=''
		UNION 
		select sandipun_ums_sijoul.student_master.adhar_card_no from  sandipun_ums_sijoul.student_master where sandipun_ums_sijoul.student_master.adhar_card_no='$adhar_card' and
		sandipun_ums_sijoul.student_master.admission_session='$current_year' and cancelled_admission='N' and enrollment_no IS NOT NULL  and enrollment_no !=''")->row();
		if (!empty($eqd1) || !empty($eqd) || !empty($main) || !empty($smd1)) {

			$this->session->set_flashdata('message_name', 'Entry already exists/Admission already taken');
			//$data['validation_errors']="Entry already exists/Admission already taken";
			$url = base_url("StudentRegistration/New_Enquiry/$year");
			redirect($url);

			//echo '<script>window.location.href = "'.$url.'";<script>';
		}
	}


//ValidFunction
	function check_cship_exist($citisenshipno, $year = '')
	{
		$ICDB = $this->load->database('icdb', TRUE);

		if (empty($year)) {
			$year =  $this->config->item('current_year');
		}
		$current_year = explode('-',  $year);
		$current_year = $current_year[0];
		$smd = $ICDB->query("select citisenshipno from  student_meet_details where citisenshipno='$citisenshipno' and academic_year='$year'")->row();


		$smd1 = $ICDB->query("select citizenship_no from citizenshipdetails  where citizenshipdetails.citizenship_no='$citisenshipno' and academic_year='$year'")->row();



		$DB = $this->load->database('umsdb', TRUE);
		$eqd = $DB->query("select citizenship_id from  enquiry_student_master where citizenship_id='$citisenshipno' and admission_session='$current_year'
	
	")->row();
		//$eqd1=$DB->query("select aadhar_card from  sandipun_ums_sijoul.enquiry_student_master where aadhar_card='$adhar_card' and admission_session='$current_year'")->row();
		$main = $DB->query("select citizenship from  student_master where citizenship='$citisenshipno' and 
	admission_session='$current_year' and cancelled_admission='N' and enrollment_no IS NOT NULL  and enrollment_no !=''
	UNION 
	select sandipun_ums_sijoul.student_master.citizenship from  sandipun_ums_sijoul.student_master where sandipun_ums_sijoul.student_master.citizenship='$citisenshipno' and
	sandipun_ums_sijoul.student_master.admission_session='$current_year' and cancelled_admission='N' and enrollment_no IS NOT NULL  and enrollment_no !=''
	
	")->row();
		if (!empty($eqd1) || !empty($eqd) || !empty($main) || !empty($smd1)) {
			//echo "dd";
			//exit;
			$this->session->set_flashdata('message_name', 'Entry already exists/Admission already taken');
			//$data['validation_errors']="Entry already exists/Admission already taken";
			$url = base_url("Enquiry1/New_Enquiry/$year");
			redirect($url);

			//echo '<script>window.location.href = "'.$url.'";<script>';
		}
	}

	function getUserIpAddrIp()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			//ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			//ip pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	//ValidFunction
	function Enquiry_insert_for_consultant($values)
	{
	//	print_r($values);exit;

		if ($values['aadhar_card'] == '789897979797') {
			$values['aadhar_card'] = '';
		}
		if (!empty($values['aadhar_card'])) {
			$this->check_aadhar_card_exist($values['aadhar_card'], $values['acyear']);
		}

		function getUserIpAddr11()
		{
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				//ip from share internet
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				//ip pass from proxy
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}

//ValidFunction
		function Enquiry_no1($DB1)
		{

			//$num = 1;
			//printf("%04d", $num);
			//print_r($DB1);
			//$DB=$this->load->database('umsdb',TRUE);
			$DB1->select('enquiry_id');
			$DB1->from('enquiry_student_master');
			$DB1->order_by('enquiry_id', 'DESC');
			$DB1->limit('1');
			$query = $DB1->get();
			$result = $query->result_array();
			//echo $DB1->last_query();
			return $result[0]['enquiry_id'] + (1);
		}


		$DB = $this->load->database('umsdb', TRUE);
		$Enquiry_no = Enquiry_no1($DB);

		$num_str = sprintf("%06d", $Enquiry_no);
		$updated_by = $this->session->userdata('uid');
		$ic_code = $this->session->userdata('ic_code');
		if (empty($values['acyear'])) {

			$year =  $this->config->item('current_year');
		} else {
			$year =  $values['acyear'];
		}
		$current_year = explode('-',  $year);
		//
		$current_year1 = $current_year = $current_year[0];
		$current_year = substr($current_year, -2);
		$enquiry_newno = $current_year . 'EN' . $num_str;


		$Enquiry['enquiry_no'] = $enquiry_newno;
		$Enquiry['first_name'] = strtoupper($values['first_name']);
		$Enquiry['middle_name'] = strtoupper($values['middle_name']);
		$Enquiry['last_name'] = strtoupper($values['last_name']);
		$Enquiry['email_id'] = ($values['email_id']);
		$Enquiry['mobile'] = $values['mobile'];

		$Enquiry['altarnet_mobile'] = $values['altarnet_mobile'];
		if ($values['nationality'] == 1) {
			$Enquiry['state_id'] = $values['state_id'];
			$Enquiry['district_id'] = $values['district_id'];
			$Enquiry['city_id'] = $values['city_id'];
			$Enquiry['int_country_id'] = 0;
			$Enquiry['int_state'] = 0;
			$Enquiry['int_city'] = 0;
		}
		if ($values['nationality'] == 2) {


			$Enquiry['state_id'] = 0;
			$Enquiry['district_id'] = 0;
			$Enquiry['city_id'] = 0;
			$Enquiry['int_country_id'] = $values['int_country_id'];
			$Enquiry['int_state'] = $values['int_state'];
			$Enquiry['int_city'] = $values['int_city'];
			$Enquiry['citizenship_id'] = $values['citizen_id'];

			if (!empty($values['citizen_id'])) {
				$this->check_cship_exist($values['citizen_id'], $values['acyear']);
			}
		}

		$Enquiry['pincode'] = $values['pincode'];
		$Enquiry['admission_type'] = $values['admission_type'];
		$Enquiry['gender'] = $values['gender'];
		$Enquiry['aadhar_card'] = $values['aadhar_card'];
		$Enquiry['category'] = $values['category'];
		$Enquiry['last_qualification'] = $values['last_qualification'];
		$Enquiry['qualification_percentage'] = $values['qualification_percentage'];
		$Enquiry['renumeration_amount'] = $values['renumeration_amount'];
		$Enquiry['nationality'] = $values['nationality'];

		$data_array['Textb6'] = '';
		$data_array['Textb7'] = '';
		$Enquiry['school_id'] = $values['school_name'];
		$Enquiry['course_id'] = $values['Courses'];
		$Enquiry['stream_id'] = $values['stream_id'];
		$Enquiry['course_type'] = $values['CoursesType'];
		$Enquiry['Campus'] = $values['Campus'];
		$Enquiry['Campus_City'] = $values['Campus_City'];
		$Enquiry['is_from_consultant'] = 1;
		//	$Enquiry['stream_name']=$values['stream_name'];
		/////////////////////////////////////////////////////////////////////////////////////////////
		$Enquiry['actual_fee'] = $values['actual_fee'];
		$Enquiry['tution_fees'] = $values['tution_fees'];

		$Enquiry['academic_year'] = $year;
		$Enquiry['current_year'] = $values['admission_type'];
		$Enquiry['admission_session'] = $current_year1;
		$Enquiry['admission_year'] = $current_year1;
		/////////////////////////////////////////////////////////
		$Enquiry['date_enter'] = date('Y-m-d');
		$Enquiry['academic_year'] = $current_year1;
		$Enquiry['ic_code'] = $ic_code;
		$Enquiry['created_on'] = date('Y-m-d H:i:s');
		$Enquiry['created_by'] =  $values['user_id'];
		$Enquiry['updated_on'] = '';
		$Enquiry['updated_by'] =  $values['user_id'];
		$Enquiry['ip_address'] = getUserIpAddr11();


		///print_r($Enquiry);
		//exit();
		$DB->trans_begin();
		/*
	
	if( $values['user_id']==4178){
		echo "ff";
		exit;
	}*/


		if (
			!empty($Enquiry['stream_id']) && !empty($Enquiry['first_name']) && !empty($Enquiry['mobile'])
			&& ((!empty($Enquiry['aadhar_card']) && $values['nationality'] == 1) || ($values['nationality'] == 2))
		) { 

			$result = $DB->insert('enquiry_student_master', $Enquiry);

			$data_array['email'] = $values['email_id'];
			$data_array['mobile'] = $values['mobile'];
			$data_array['first_name'] = $values['first_name'] . ' ' . $values['middle_name'] . ' ' . $values['last_name'];


			//$this->api_integration($data_array);
			
			

			//print_r($result);
			//exit();
			/*
	$csd['enquiry_no']= $enquiry_newno;
	//$csd['enquiry_id']= $enquiry_id;
	$csd['Photo']=$values['Candidate_Photo'];
	$csd['Nationality']=$values['Nationality'];
	$csd['Domicile']=$values['Domicile'];
	$csd['Cast']=$values['CAST'];
	$csd['SSC']=$values['SSC'];
	$csd['HSC']=$values['HSC'];
	$csd['Creamy_Layer']=$values['Creamy_Layer'];
	
	$csd['CET']=$values['CET_Scorecard'];
	$csd['validity_certificate']=$values['Validity_Certificate'];
	$csd['vc_recepit']=$values['Certificate_Recepit'];
	
	$csd['create_on']=date('Y-m-d H:i:s');
	$csd['create_by']= $values['user_id'];
	$csd['modify_on']=date('Y-m-d H:i:s');
	$csd['modify_by']= $values['user_id'];
	
	$resulttd=$DB->insert('consultant_student_document',$csd);
	
	*/

			$DB->trans_complete();

			if ($DB->trans_status() === FALSE) {  //echo "false";exit;
				$DB->trans_rollback();
				$enquiry_id = $DB->insert_id();
				return $enquiry_id . '/' . $enquiry_newno;
			} else {
				$DB->trans_commit();

				$Enquiry_insert['mobile1'] = $values['mobile'];
				$Enquiry_insert['student_name'] = strtoupper($values['first_name']) . "" . strtoupper($values['middle_name']) . "" . strtoupper($values['last_name']);
				$Enquiry_insert['adhar_no'] = $values['aadhar_card'];
				$Enquiry_insert['citizen_id'] = $values['citizen_id'];
				$Enquiry_insert['stream_id'] = $values['stream_id'];
				$Enquiry_insert['email'] = $values['email_id'];
				$Enquiry_insert['created_date'] = date('Y-m-d H:i:s');
				$Enquiry_insert['updated_date'] = date('Y-m-d H:i:s');
				$Enquiry_insert['created_by'] =  $values['user_id'];
				$Enquiry_insert['updated_by'] =  $values['user_id'];
				$Enquiry_insert['ic_code_consultant'] =  $values['user_id'];
				$Enquiry_insert['academic_year'] = $year;
				$Enquiry_insert['ic_code'] = 'REF/1';
				$Enquiry_insert['event_code'] = 'REF/1';
				$Enquiry_insert['programme_year'] = $eid;
				$this->update_entry($values['mobile'], $Enquiry_insert);
				//echo $enquiry_id . '/' . $enquiry_newno; exit;
				return $enquiry_id . '/' . $enquiry_newno; //$DB->insert_id();  
			}
		} else {
			$this->session->set_flashdata('message_name', 'Something went wrong');
			//$data['validation_errors']="Entry already exists/Admission already taken";
			$url = base_url("StudentRegistration/New_Enquiry/$year");
			redirect($url);
		}

		/*if($result)
	{
		echo '1';
	}else{
		echo '2';
	}*/
	}


//ValidFunction
	function update_entry($mobile, $data)
	{
		/*if($data['citizen_id']=999987654){
	print_r($data);
	exit;
	}*/
		$DB1 = $this->load->database('icdb', TRUE);
		$year = $data['academic_year'];
		
		$check_entry = $DB1->query("select id from student_meet_details where (mobile1='$mobile' or whatsappno='$mobile' or pmobile_no='$mobile' or pwhatsapp_no='$mobile') and academic_year='$year'")->row();
		
		
		$ad_no = $data['adhar_no'];

		if (!empty($check_entry)) {
		$gessc['student_id'] = $check_entry->id;
			$gessc['utm_source'] = 'Consultant';
			$gessc['stream_id'] = $data['stream_id'];
			$gessc['academic_year'] = $year;
			$gessc['created_date'] = date('Y-m-d H:i:s');
			$gessc['created_by'] = $data['created_by'];
			$DB1->insert('get_secondary_sources', $gessc);

			if (!empty($data['adhar_no'])) {
				$check_entry_in_aadhar = $DB1->query("select * from aadhar_car_updation where add_no='$ad_no' and academic_year='$year' and add_no!='' ")->row();
				
				
				if (empty($check_entry_in_aadhar)) {
					$data1['updated_date'] = $data['updated_date'];
					$data1['updated_by'] = $data['updated_by'];
					$data1['adhar_no'] = $data['adhar_no'];
					$data1['programme_year'] = $data['programme_year'];
					$data1['ic_code_consultant'] = $data['updated_by'];
					$DB1->where('id', $check_entry->id);
					$result = $DB1->update('student_meet_details', $data1);
					$std_id = $check_entry->id;
					$adhar_card['add_no'] = $data['adhar_no'];
					$adhar_card['academic_year'] = $year;
					$adhar_card['student_id'] = $check_entry->id;
					$adhar_card['is_insert'] = 1;
					$adhar_card['created_by'] =  $data['created_by'];
					$adhar_card['date_time'] = date('Y-m-d H:i:s');
					$adhar_card['ip_address'] = $this->getUserIpAddrIp();
					$DB1->insert('aadhar_car_updation', $adhar_card);
				}
			}
			if (!empty($data['citizen_id'])) {

				$check_entry_in_cn = $DB1->query("select * from citizenshipdetails where citizenship_no='" . $data['citizen_id'] . "' and academic_year='$year' and citizenship_no!='' ")->row();


				if (empty($check_entry_in_cn)) {



					$data1['updated_date'] = $data['updated_date'];
					$data1['updated_by'] = $data['updated_by'];
					$data1['citisenshipno'] = $data['citizen_id'];
					$data1['programme_year'] = $data['programme_year'];
					$data1['ic_code_consultant'] = $data['updated_by'];
					$DB1->where('id', $check_entry->id);
					$result = $DB1->update('student_meet_details', $data1);

					$std_id = $check_entry->id;
					$cno['citizenship_no'] = $data['citizen_id'];
					$cno['academic_year'] = $year;
					$cno['student_id'] = $check_entry->id;
					$cno['is_insert'] = 1;
					$cno['created_by'] =  $data['created_by'];
					$cno['date_time'] = date('Y-m-d H:i:s');
					$cno['ip_address'] = $this->getUserIpAddrIp();
					$DB1->insert('citizenshipdetails', $cno);
				}
			}
		} else {

			$data['programme_id'] = $data['stream_id'];
			$ciz = $data['citizen_id'];
			unset($data['stream_id']);
			unset($data['citizen_id']);
			$data['ic_code_consultant'] = $data['updated_by'];
			$DB1->insert('student_meet_details', $data);
			$insert_id = $DB1->insert_id();
			


			if (!empty($data['adhar_no'])) {

				$adhar_card['add_no'] = $data['adhar_no'];
				$adhar_card['student_id'] = $insert_id;
				$adhar_card['is_insert'] = 1;
				$adhar_card['academic_year'] = $year;
				$adhar_card['created_by'] =  $data['created_by'];
				$adhar_card['date_time'] = date('Y-m-d H:i:s');
				$adhar_card['ip_address'] = $this->getUserIpAddrIp();
				$DB1->insert('aadhar_car_updation', $adhar_card);
			
			}
			if (!empty($ciz)) {

				$cno['citizenship_no'] = $ciz;
				$cno['student_id'] = $insert_id;
				$cno['is_insert'] = 1;
				$cno['academic_year'] = $year;
				$cno['created_by'] =  $data['created_by'];
				$cno['date_time'] = date('Y-m-d H:i:s');
				$cno['ip_address'] = $this->getUserIpAddrIp();
				$DB1->insert('citizenshipdetails', $cno);
			}
		}

		//$values['aadhar_card']
	}

	function check_aadhar_card_exist_update($adhar_card, $nquiry_id)
	{
		$ICDB = $this->load->database('icdb', TRUE);

		$year =  $this->config->item('current_year');
		$current_year = explode('-',  $year);
		$current_year = $current_year[0];
		$smd = $ICDB->query("select adhar_no from  student_meet_details where adhar_no='$adhar_card'")->row();
		$DB = $this->load->database('umsdb', TRUE);
		$eqd = $DB->query("select aadhar_card from  enquiry_student_master where aadhar_card='$adhar_card' and admission_session='$current_year'")->row();
		$mqd = $DB->query("select aadhar_card from  sandipun_ums_sijoul.enquiry_student_master where aadhar_card='$adhar_card' and admission_session='$current_year'")->row();
		$main = $DB->query("select adhar_card_no from  student_master where adhar_card_no='$adhar_card' and admission_session='$current_year'
			and cancelled_admission='N'
			UNION 
			select sandipun_ums_sijoul.student_master.adhar_card_no from  sandipun_ums_sijoul.student_master
				and sandipun_ums_sijoul.student_master.admission_session='$current_year'
			and sandipun_ums_sijoul.student_master.cancelled_admission='N'
			where sandipun_ums_sijoul.student_master.adhar_card_no='$adhar_card' ")->row();
		if (!empty($smd) || !empty($eqd) || !empty($main) || !empty($mqd)) {
			//echo "dd";
			//exit;
			$this->session->set_flashdata('message_name', 'Entry already exists/Admission already taken');
			//$data['validation_errors']="Entry already exists/Admission already taken";
			$url = base_url("StudentRegistration/New_Enquiry/");
			redirect($url);
			//echo '<script>window.location.href = "'.$url.'";<script>';
		}
	}


	function Enquiry_Updated_consultant($values)
	{

				function getUserIpAddr1()
				{
					if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
						//ip from share internet
						$ip = $_SERVER['HTTP_CLIENT_IP'];
					} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
						//ip pass from proxy
						$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
					} else {
						$ip = $_SERVER['REMOTE_ADDR'];
					}
					return $ip;
				}


				$DB = $this->load->database('umsdb', TRUE);


				$updated_by = $values['user_id'];
				$ic_code = $this->session->userdata('ic_code');

				$enquiry_id = trim($values['enquiry_id']);
				$entry_details = $DB->get_where('enquiry_student_master', array('enquiry_id' => $enquiry_id))->row();
				if (!empty($values['acyear'])) {
					$year = $values['acyear'];
				}
				if ($entry_details->aadhar_card != $values['aadhar_card']) {
					$this->check_aadhar_card_exist($values['aadhar_card'], $values['acyear']);
					$Enquiry_insert['mobile1'] = $values['mobile'];
					$Enquiry_insert['student_name'] = strtoupper($values['first_name']) . "" . strtoupper($values['middle_name']) . "" . strtoupper($values['last_name']);
					$year = $this->config->item('current_year');

					$Enquiry_insert['adhar_no'] = $values['aadhar_card'];
					$Enquiry_insert['email'] = $values['email_id'];
					$Enquiry_insert['created_date'] = date('Y-m-d H:i:s');
					$Enquiry_insert['updated_date'] = date('Y-m-d H:i:s');
					$Enquiry_insert['created_by'] = $updated_by;
					$Enquiry_insert['updated_by'] = $updated_by;
					$Enquiry_insert['ic_code_consultant'] = $updated_by;
					$Enquiry_insert['academic_year'] = $year;
					$Enquiry_insert['ic_code'] = 'REF/1';
					$Enquiry_insert['event_code'] = 'REF/1';
					//$Enquiry_insert['programme_year']=$eid;
					$Enquiry_insert['programme_id'] = $values['stream_id'];
					$this->update_entry($values['mobile'], $Enquiry_insert);
				}

				$Enquiry['first_name'] = strtoupper($values['first_name']);
				$Enquiry['middle_name'] = strtoupper($values['middle_name']);
				$Enquiry['last_name'] = strtoupper($values['last_name']);
				$Enquiry['email_id'] = ($values['email_id']);
				$Enquiry['mobile'] = $values['mobile'];
				$Enquiry['altarnet_mobile'] = $values['altarnet_mobile'];

				$Enquiry['pincode'] = $values['pincode'];
				$Enquiry['admission_type'] = $values['admission_type'];
				$Enquiry['gender'] = $values['gender'];
				$Enquiry['aadhar_card'] = $values['aadhar_card'];
				$Enquiry['category'] = $values['category'];
				$Enquiry['last_qualification'] = $values['last_qualification'];
				$Enquiry['qualification_percentage'] = $values['qualification_percentage'];
				$Enquiry['renumeration_amount'] = $values['renumeration_amount'];
				$Enquiry['is_online'] = 'N';

				$Enquiry['nationality'] = $values['nationality'];

				if ($values['nationality'] == 1) {
					$Enquiry['state_id'] = $values['state_id'];
					$Enquiry['district_id'] = $values['district_id'];
					$Enquiry['city_id'] = $values['city_id'];
					$Enquiry['int_country_id'] = 0;
					$Enquiry['int_state'] = 0;
					$Enquiry['int_city'] = 0;
				}
				if ($values['nationality'] == 2) {
					$Enquiry['state_id'] = 0;
					$Enquiry['district_id'] = 0;
					$Enquiry['city_id'] = 0;
					$Enquiry['int_country_id'] = $values['int_country_id'];
					$Enquiry['int_state'] = $values['int_state'];
					$Enquiry['int_city'] = $values['int_city'];
					if (!empty($values['citizen_id'])) {


						if ($entry_details->citizenship_id != $values['citizen_id']) {

							$this->check_cship_exist($values['citizen_id'], $values['acyear']);
						}
					}
				}

				//if(($values['Campus_City']==1)&&($values['Campus']=="SUN")){

				//$Enquiry['school_id']=$values['school_id'];
				//$Enquiry['course_id']=$values['course_id'];
				//$Enquiry['stream_id']=$values['stream_id'];	
				//}else{

				$Enquiry['school_id'] = $values['school_name'];
				$Enquiry['course_type'] = $values['CoursesType'];
				$Enquiry['course_id'] = $values['Courses'];
				$Enquiry['stream_id'] = $values['stream_id'];
				$Enquiry['Campus'] = $values['Campus'];
				$Enquiry['Campus_City'] = $values['Campus_City'];
				$Enquiry['is_from_consultant'] = 1;
				$Enquiry['actual_fee'] = $values['actual_fee'];
				$Enquiry['tution_fees'] = $values['tution_fees'];

				$current_year = explode('-',  $year);
				$current_year = $current_year[0];
				$Enquiry['academic_year'] = $current_year;
				$Enquiry['current_year'] = $values['admission_type'];
				$Enquiry['admission_session'] = $current_year;
				$Enquiry['admission_year'] = $current_year;
				$Enquiry['ic_code'] = $ic_code;
				$Enquiry['updated_on'] = date('Y-m-d H:i:s');
				$Enquiry['updated_by'] = $updated_by;
				$Enquiry['ip_address'] = getUserIpAddr1();
				$ICDB = $this->load->database('icdb', TRUE);

				$ICDB ->trans_begin();

				$DB->where('enquiry_id', $enquiry_id);


				// print_r($Enquiry);
				//exit();

				$result = $DB->update('enquiry_student_master', $Enquiry);

				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//$rcnt = $this->check_if_exists($values['enquiry_no'],'','');

					/*
				//$csd['enquiry_no']= $enquiry_newno;
				//$csd['enquiry_no']= $values['enquiry_newno'];
				$csd['enquiry_id']= $enquiry_id;
				$csd['enquiry_no']= $values['enquiry_no'];
				$csd['Photo']=$values['Candidate_Photo'];
				$csd['Nationality']=$values['Nationality'];
				$csd['Domicile']=$values['Domicile'];
				$csd['Cast']=$values['CAST'];
				$csd['SSC']=$values['SSC'];
				$csd['HSC']=$values['HSC'];
				$csd['Creamy_Layer']=$values['Creamy_Layer'];
				$csd['CET']=$values['CET_Scorecard'];
				$csd['validity_certificate']=$values['Validity_Certificate'];
				$csd['vc_recepit']=$values['Certificate_Recepit'];

				
				if($rcnt<1)
					{
					
					$csd['create_on']=date('Y-m-d h:i:s');
					$csd['create_by']=$updated_by;
					$csd['modify_on']=date('Y-m-d h:i:s');
					$csd['modify_by']=$updated_by;
					$resulttd=$DB->insert('consultant_student_document',$csd);
				
					}else{
				$csd['modify_on']=date('Y-m-d h:i:s');
				$csd['modify_by']=$updated_by;
				$DB->where('enquiry_no', $values['enquiry_no']);
				$resulttd=$DB->update('consultant_student_document',$csd);
					}
				*/


			$ICDB ->trans_complete();
			if ($ICDB ->trans_status() === FALSE) {
				$ICDB ->trans_rollback();
				return $enquiry_id . '/' . $values['enquiry_no'];
			} else {
				$ICDB ->trans_commit();

				$Enquiry['mobile1'] = $values['mobile'];
				$Enquiry['student_name'] = strtoupper($values['first_name']) . "" . strtoupper($values['middle_name']) . "" . strtoupper($values['last_name']);
				$Enquiry['adhar_no'] = $values['aadhar_card'];
				$Enquiry['citizen_id'] = $values['citizen_id'];
				$Enquiry['stream_id'] = $values['stream_id'];
				$Enquiry['email'] = $values['email_id'];
				$Enquiry['updated_date'] = date('Y-m-d H:i:s');
				$Enquiry['updated_by'] = $updated_by;
				$Enquiry['ic_code_consultant'] = $updated_by;
				$Enquiry['academic_year'] = $year;
				$Enquiry['ic_code'] = 'REF/1';
				$Enquiry['event_code'] = 'REF/1';
				$Enquiry['programme_year'] = $eid;
				$this->update_entry($values['mobile'], $Enquiry);

				return $enquiry_id . '/' . $enquiry_newno;











			return $enquiry_id . '/' . $values['enquiry_no'];
		}
				/*if($result)
			{
				echo '1';
			}else{
				echo '2';
			}*/
	}
	function insert_scolership($data = array(), $stud_id = '')
	{

		$updated_by = $this->session->userdata('uid');
		$DB1 = $this->load->database('umsdb', TRUE);
		$scholarship = array();
		if (!empty($data) && $stud_id != '') {
			$DB1->select("*");
			$DB1->from('fees_consession_details');
			$DB1->where('student_id', $stud_id);
			$DB1->where('academic_year', '2020');

			$check_whether_entry_exists = $DB1->get()->row();

			$scholarship['concession_type'] = 'Schlorship';
			$scholarship['student_id'] = $stud_id;
			$scholarship['enrollement_no'] = $data['enrollment_no'];
			$scholarship['academic_year'] = 2020;

			$scholarship['actual_fees'] = $data['actual_fee'];

			$scholarship['exepmted_fees'] = $data['scholarship_amount'];
			$paid_required = $data['actual_fee'] - $data['scholarship_amount'];
			$scholarship['fees_paid_required'] = $paid_required;
			$scholarship['concession_remark'] = $data['concession_remark'];
			$scholarship['allowed_by'] = 'Admin';

			$scholarship['modified_by'] = $updated_by;
			$scholarship['modified_on'] = date('Y-m-d h:i:s');
			$scholarship['remark'] = $data['remark'];

			if (empty($check_whether_entry_exists)) {

				$DB1->insert('fees_consession_details', $scholarship);
				return $DB1->insert_id();
			} else {
				$DB1->update('fees_consession_details', $scholarship, array('id' => $check_whether_entry_exists->id));
				return $check_whether_entry_exists->id;
			}
		} else {
			return 0;
		}
	}





	function insert_data_in_admission_details($data = array(), $stud_id = '')
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$data_array = array();
		if (!empty($data) && $stud_id != '') {
			$DB1->select("*");
			$DB1->from('admission_details');
			$DB1->where('student_id', $stud_id);
			//$DB1->where('school_code',$data['school_id']);
			//$DB1->where('stream_id',$data['stream_id']);
			//$DB1->where('year',$data['admission_type']);
			$DB1->where('academic_year', '2020');
			$check_whether_entry_exists = $DB1->get()->row();

			$data_array['student_id'] = $stud_id;
			$data_array['form_number'] = $data['form_number'];
			$data_array['enrollment_no'] = $data['enrollment_no'];

			$data_array['school_code'] = $data['school_code'];
			$data_array['stream_id'] = $data['stream_id'];
			$data_array['year'] = $data['year'];
			$data_array['academic_year'] = $data['academic_year'];

			$data_array['actual_fee'] = $data['actual_fee'];
			$data_array['applicable_fee'] = $data['applicable_fee'];

			$data_array['fees_consession_allowed'] = $data['fees_consession_allowed'];
			$data_array['concession_type'] = $data['concession_type'];

			$data_array['modified_by'] = $data['modified_by'];

			$data_array['modified_on'] = $data['modified_on'];

			if (empty($check_whether_entry_exists)) {

				$DB1->insert('admission_details', $data_array);
				return $DB1->insert_id();
			} else {
				$DB1->update('admission_details', $data_array, array('adm_id' => $check_whether_entry_exists->adm_id));
				return $check_whether_entry_exists->adm_id;
			}
		} else {
			return 0;
		}
	}




	function insert_data_in_address($data = array(), $stud_id = '')
	{

		$DB1 = $this->load->database('umsdb', TRUE);
		$data_array = array();
		if (!empty($data) && $stud_id != '') {
			$DB1->select("*");
			$DB1->from('address_details');
			$DB1->where('student_id', $stud_id);
			$DB1->where('adds_of', 'STUDENT');
			$DB1->where('address_type', 'CORS');
			$check_whether_entry_exists = $DB1->get()->row();
			$data_array['student_id'] = $stud_id;
			$data_array['adds_of'] = 'STUDENT';

			$data_array['state_id'] = $data['state_id'];
			$data_array['district_id'] = $data['district_id'];
			$data_array['city'] = $data['city_id'];
			$data_array['pincode'] = $data['pincode'];

			if (empty($check_whether_entry_exists)) {

				$DB1->insert('address_details', $data_array);
				return $DB1->insert_id();
			} else {
				$DB1->update('address_details', $data_array, array('add_id' => $check_whether_entry_exists->add_id));
				return $check_whether_entry_exists->add_id;
			}
		} else {
			return 0;
		}
	}


	function Enquiry_Updated($values)
	{


		//print_r($values);
		//exit();
		function getUserIpAddr()
		{
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				//ip from share internet
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				//ip pass from proxy
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}
		function Enquiry_no($DB1)
		{
			//$num = 1;
			//printf("%04d", $num);
			//print_r($DB1);
			//$DB=$this->load->database('umsdb',TRUE);
			$DB1->select('enquiry_id,version');
			$DB1->from('enquiry_student_master');
			$DB1->order_by('enquiry_id', 'DESC');
			$DB1->limit('0', '1');
			$query = $DB1->get();
			$result = $query->result_array();
			return $result[0]['enquiry_id'];
		}

		$DB = $this->load->database('umsdb', TRUE);
		//print_r($values);
		//$Enquiry_no=Enquiry_no($DB);
		//printf("%04d", $Enquiry_no);
		//$num_str = sprintf("%06d", $Enquiry_no);
		//exit();
		$updated_by = $this->session->userdata('uid');
		$role_id = $this->session->userdata('role_id');
		$ic_code = $this->session->userdata('ic_code');

		//$Enquiry['enquiry_no']='20ENQ'.$num_str;
		$enquiry_id = trim($values['enquiry_id']);
		$Enquiry['first_name'] = strtoupper($values['first_name']);
		$Enquiry['middle_name'] = strtoupper($values['middle_name']);
		$Enquiry['last_name'] = strtoupper($values['last_name']);
		$Enquiry['email_id'] = ($values['email_id']);
		$Enquiry['mobile'] = $values['mobile'];
		$Enquiry['altarnet_mobile'] = $values['altarnet_mobile'];
		$Enquiry['state_id'] = $values['state_id'];
		//$Enquiry['state_name']=$values['state_name'];
		$Enquiry['district_id'] = $values['district_id'];
		//$Enquiry['district_name']=$values['district_name'];
		$Enquiry['city_id'] = $values['city_id'];
		//$Enquiry['city_name']=$values['city_name'];
		/////////////////////////////////////////////////////////////////////////////////////////////
		$Enquiry['pincode'] = $values['pincode'];
		$Enquiry['admission_type'] = $values['admission_type'];
		$Enquiry['gender'] = $values['gender'];
		$Enquiry['aadhar_card'] = $values['aadhar_card'];
		$Enquiry['category'] = $values['category'];
		$Enquiry['last_qualification'] = $values['last_qualification'];
		$Enquiry['qualification_percentage'] = $values['qualification_percentage'];
		$Enquiry['school_id'] = $values['school_id'];
		//	$Enquiry['school_name']=$values['school_name'];
		$Enquiry['course_id'] = $values['course_id'];
		//	$Enquiry['course_name']=$values['course_name'];
		$Enquiry['stream_id'] = $values['stream_id'];
		//	$Enquiry['stream_name']=$values['stream_name'];
		/////////////////////////////////////////////////////////////////////////////////////////////
		$Enquiry['actual_fee'] = $values['actual_fee'];
		$Enquiry['tution_fees'] = $values['tution_fees'];
		$Enquiry['form_taken'] = $values['form_taken'];
		$Enquiry['form_no'] = $values['form_no'];
		$Enquiry['form_amount'] = $values['form_amount'];
		$Enquiry['payment_mode'] = $values['payment_mode'];
		$Enquiry['payment_date'] = date('Y-m-d');
		$Enquiry['recepit_no'] = $values['TransactionNo'];
		//////////////////////////////////////////////////////////////////
		$Enquiry['hostel_allowed'] = $values['hostel_allowed'];
		$Enquiry['applicable'] = $values['applicable'];

		$Enquiry['reference'] = $values['reference'];
		$Enquiry['other_reference'] = $values['Reference_other'];

		$Enquiry['enquiry_taken'] = $values['enquiry_taken'];
		$Enquiry['enquiry_mobile'] = $values['enquiry_mobile'];
		$Enquiry['staff_id'] = $values['staff_id'];
		$Enquiry['is_online'] = 'N';
		////////////////////////////////////////////////////////////

		$Enquiry['scholarship_allowed'] = $values['scholarship_allowed'];
		if ($values['scholarship_allowed'] == "YES") {

			$Enquiry['other_scholarship'] = $values['Other_Scholarship_selected'];
			$Enquiry['sports_scholarship'] = $values['Sports_Scholarship_selecet'];
			$Enquiry['merit_scholarship'] = $values['Merit_Scholarship_selected'];

			$values['Other_Scholarship_selected'];
			$scholarship_id = '';

			if (!empty($values['Other_Scholarship_selected'])) {
				if ($values['Other_Scholarship_selected'] == 23) {
				} else {
					$scholarship_id = $values['Other_Scholarship_selected'];
				}
			}
			if (!empty($values['Sports_Scholarship_selecet'])) {
				if ($values['Sports_Scholarship_selecet'] == 24) {
				} else {
					$scholarship_id = $values['Sports_Scholarship_selecet'];
				}
			}
			if (!empty($values['Merit_Scholarship_selected'])) {
				if (($values['Merit_Scholarship_selected'] == 25) || ($values['Merit_Scholarship_selected'] == 26)) {
					// $scholarship_id=$values['Merit_Scholarship_selected'];
				} else {
					$scholarship_id = $values['Merit_Scholarship_selected'];
				}
			}
			//echo $scholarship_id;// $values['Merit_Scholarship_selected'].'--'.$scholarship_id;
			//exit();

			$Enquiry['scholarship_id'] = $scholarship_id;
			//echo $scholarship_id;
			$scholar_name = $this->get_schollership_by_id($scholarship_id);
			//print_r($scholar_name);exit;
			$Enquiry['scholarship_type'] = $scholar_name[0]['type'];
			$Enquiry['scholarship_name'] = $scholar_name[0]['schlorship_name'];
			$Enquiry['scholarship_amount'] = $values['scholarship_amount'];
			$Enquiry['with_scholarship'] = $values['with_scholarship'];
			$Enquiry['scholarship_status'] = $values['scholarship_status'];
			$Enquiry['final_Pay'] = $values['final_Pay'];
		} else {    //////////////NO

			$Enquiry['other_scholarship'] = '';
			$Enquiry['sports_scholarship'] = '';
			$Enquiry['merit_state'] = '';
			$Enquiry['merit_scholarship'] = '';
			$Enquiry['scholarship_id'] = '';
			$Enquiry['scholarship_type'] = '';
			$Enquiry['scholarship_name'] = '';
			//////////////////////////////////////////////////////////////////////////////////
			$Enquiry['scholarship_amount'] = '';

			$Enquiry['with_scholarship'] = '';
			$Enquiry['scholarship_status'] = 'None';
			$Enquiry['final_Pay'] = '';
		}

		$Enquiry['without_scholarship'] = $values['without_scholarship'];





		//////////////////////////////////////////////////////////////////


		//////////////////////////////////////////////////////////////////
		//$Enquiry['academic_year']=2020;
		$year =  $this->config->item('current_year');
		$current_year = explode('-',  $year);
		$current_year = $current_year[0];
		$Enquiry['academic_year'] = $current_year;
		$Enquiry['current_year'] = $values['admission_type'];
		$Enquiry['admission_session'] = $current_year;
		$Enquiry['admission_year'] = $current_year;
		/////////////////////////////////////////////////////////
		$Enquiry['ic_code'] = $ic_code;
		//$Enquiry['created_on']=date('Y-m-d h:i:s');
		//$Enquiry['created_by']=$updated_by;
		$Enquiry['updated_on'] = '';
		$Enquiry['updated_by'] = $updated_by;
		$Enquiry['ip_address'] = getUserIpAddr();

		$Enquiry['version'] = $result[0]['version'] + 1;

		//$current_status='';
		if ((!empty($values['form_no'])) && (empty($values['stud_id']))) {
			$current_status = 'Form&nbsp;Taken';
		} else {
			$current_status = 'Provisional';
		}

		$Enquiry['enquiry_status'] = $current_status;
		$ICDB = $this->load->database('icdb', TRUE);

		$ICDB->trans_begin();

		$DB->where('enquiry_id', $enquiry_id);

		//print_r($Enquiry);
		//exit();

		if (($values['stud_id'] != 0) && ($role_id == 24)) {

			$DB3 = $this->load->database('umsdb', TRUE);
			$st_master['first_name'] = strtoupper($values['first_name']) . ' ' . strtoupper($values['middle_name']) . ' ' . strtoupper($values['last_name']);
			$st_master['gender'] = $values['gender'];
			$st_master['email'] = ($values['email_id']);
			$st_master['mobile'] = $values['mobile'];
			$st_master['category'] = $values['category'];
			$st_master['adhar_card_no'] = $values['aadhar_card'];

			$st_master['lateral_entry'] = ($values['admission_type'] == 1) ? "N" : "Y";
			$st_master['current_semester'] = ($values['admission_type'] == 1) ? 1 : 3;
			$st_master['admission_semester'] = ($values['admission_type'] == 1) ? 1 : 3;
			$st_master['admission_year'] = ($values['admission_type'] == 1) ? 1 : 2;
			$st_master['current_year'] = ($values['admission_type'] == 1) ? 1 : 2;

			$st_master['admission_school'] = $values['school_id'];
			$st_master['admission_stream'] = $values['stream_id'];

			$DB3->update('student_master', $st_master, array('stud_id' => $values['stud_id']));
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$adm['student_id'] = $values['stud_id'];
			$adm['form_number'] = $values['form_no'];
			$adm['enrollment_no'] = $values['enrollment_no'];

			$adm['school_code'] = $values['school_id'];
			$adm['stream_id'] = $values['stream_id'];
			$adm['year'] = $values['admission_type'] == 1 ? 1 : 2;
			$adm['academic_year'] = '2020';

			$adm['actual_fee'] = $values['actual_fee'];


			if ($values['scholarship_allowed'] == "YES") {
				$adm['applicable_fee'] = ($values['actual_fee'] - $values['scholarship_amount']);
				$adm['concession_type'] = $values['scholarship_name'];
				$adm['fees_consession_allowed'] = 'Y';
			} else {
				$adm['applicable_fee'] = ($values['actual_fee']);
				$adm['concession_type'] = '';
				$adm['fees_consession_allowed'] = 'N';
			}

			$adm['modified_by'] = $updated_by;
			$adm['modified_on'] = date('Y-m-d h:i:s');

			$add = $this->insert_data_in_admission_details($adm, $values['stud_id']);

			$scholarship['enrollment_no'] = $values['enrollment_no'];
			$scholarship['actual_fee'] = $values['actual_fee'];
			$scholarship['scholarship_amount'] = $values['scholarship_amount'];
			$scholarship['concession_remark'] = $scholar_name[0]['type'];
			$scholarship['remark'] = $scholar_name[0]['schlorship_name'];
			if ($values['scholarship_allowed'] == "YES") {
				$add = $this->insert_scolership($scholarship, $values['stud_id']);
			}
			///////////////////////////////////////////////////////////////////////////////////////////////////////////

			$in_address['state_id'] = $values['state_id'];
			$in_address['district_id'] = $values['district_id'];
			$in_address['city_id'] = $values['city_id'];
			$in_address['pincode'] = $values['pincode'];
			$add = $this->insert_data_in_address($in_address, $values['stud_id']);
		}
		//exit();



		$result = $DB->update('enquiry_student_master', $Enquiry);
		$ICDB->trans_complete();
		if ($ICDB->trans_status() === FALSE) {
			$ICDB->trans_rollback();
			return $enquiry_id . '/' . $values['enquiry_no'];
		} else {
			$ICDB->trans_commit();
			return $enquiry_id . '/' . $values['enquiry_no'];
		}
		/*if($result)
	{
		echo '1';
	}else{
		echo '2';
	}*/
	}

	public function scholarship_status_update($value, $id)
	{
		$DB = $this->load->database('umsdb', TRUE);
		$updated_by = $this->session->userdata('uid');
		$ic_code = $this->session->userdata('ic_code');



		$Enquiry['scholarship_status'] = $value;
		//$Enquiry['updated_on']='';
		$Enquiry['updated_by'] = $updated_by;

		$DB->where('enquiry_id', $id);
		$result = $DB->update('enquiry_student_master', $Enquiry);

		return $value;
	}


	private function _Enquiry_list($DB)
	{
		//$DB=$this->load->database('umsdb',TRUE);
		//	print_r($DB);
		//add custom filter here
		/*if($this->input->post('country'))
		{
			$this->db->where('country', $this->input->post('country'));
		}
		if($this->input->post('FirstName'))
		{
			$this->db->like('FirstName', $this->input->post('FirstName'));
		}
		if($this->input->post('LastName'))
		{
			$this->db->like('LastName', $this->input->post('LastName'));
		}
		if($this->input->post('address'))
		{
			$this->db->like('address', $this->input->post('address'));
		}*/

		//echo $this->table;
		$DB->select('vw.stream_name as vstream_name,eq.*');
		$DB->from('enquiry_student_master as eq');
		$DB->join('vw_stream_details as vw', 'vw.stream_id=eq.stream_id', 'left');
		$i = 0;

		foreach ($this->column_search as $item) // loop column 
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					$DB->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$DB->like($item, $_POST['search']['value']);
				} else {
					$DB->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i) //last loop
					$DB->group_end(); //close bracket
			}
			$i++;
		}


		if (isset($_POST['order'])) // here order processing
		{
			$DB->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$DB->order_by(key($order), $order[key($order)]);
		}
		$DB->where('status', 'Y');
	}

	public function get_datatables($date = '', $type_param = '')
	{
		$role_id = $this->session->userdata('uid');

		$DB1 = $this->load->database('umsdb', TRUE);
		$this->_Enquiry_list1($DB1, $date, $type_param);
		//$this->_Enquiry_list($DB1);
		if ($_POST['length'] != -1)
			$DB1->limit($_POST['length'], $_POST['start']);
		$query = $DB1->get();
		if ($role_id == 1911) {
			//	echo $DB1->last_query(); exit();
			//print_r($this->session->userdata());exit();
		}
		//echo $DB1->last_query(); exit();
		return $query->result();
	}

	private function _Enquiry_list1($DB, $date = '', $type_param = '')
	{

		$updated_by = $this->session->userdata('uid');
		$role_id = $this->session->userdata('role_id');

		$DB->select('vw.school_name,vw.school_short_name,vw.course_short_name,vw.stream_name as vstream_name,st.state_name,dt.district_name,tm.taluka_name,eq.*');
		$DB->from('enquiry_student_master as eq');

		$DB->join('vw_stream_details as vw', 'vw.stream_id=eq.stream_id', 'left');
		$DB->join('states as st', 'st.state_id=eq.state_id', 'left');
		$DB->join('district_name as dt', 'dt.district_id=eq.district_id', 'left');
		$DB->join('taluka_master as tm', 'tm.taluka_id=eq.city_id', 'left');

		if ($type_param != '') {
			if ($type_param == 1) {
				$DB->where("eq.form_taken='Y'");
			} else if ($type_param == 2) {
				$DB->join('student_master as sm', 'sm.enquiry_id=eq.enquiry_id AND sm.academic_year="2020" AND sm.admission_session="2020"', 'INNER');
				//	$DB->where("eq.provisional_no !='-' AND eq.enquiry_status='Provisional' AND eq.is_online='N'  and eq.provisional_no IS NOT NULL");

			} else if ($type_param == 3) {
				$DB->join('student_master as sm', 'sm.enquiry_id=eq.enquiry_id AND sm.admission_confirm="Y" AND sm.academic_year="2020" AND sm.admission_session="2020"', 'INNER');
				//	$DB->where("eq.stude_id!='0' and eq.provisional_no IS NOT NULL");

			}
		}

		if ($date != '') {
			$DB->where("STR_TO_DATE(eq.created_on,'%Y-%m-%d') ='$date'");
		}

		$DB->where("eq.admission_session='2020'");
		$DB->where('eq.status', 'Y');
		$DB->where('eq.is_online', 'N');
		if (($role_id == 1) || ($role_id == 24)) {
		} else {
			$DB->where("eq.created_by='" . $updated_by . "'");
		}
		$i = 0;

		foreach ($this->column_search as $item) // loop column 
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					$DB->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$DB->like($item, $_POST['search']['value']);
				} else {
					$DB->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i) //last loop
					$DB->group_end(); //close bracket
			}
			$i++;
		}


		if (isset($_POST['order'])) // here order processing
		{
			$DB->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$DB->order_by(key($order), $order[key($order)]);
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	public function get_datatables_Online($date = '', $type_param = '')
	{

		$DB1 = $this->load->database('umsdb', TRUE);
		//	 echo $type_param;
		//  exit();
		$this->_Online_list1($DB1, $date, $type_param);

		//$this->_Enquiry_list($DB1);
		if ($_POST['length'] != -1)
			$DB1->limit($_POST['length'], $_POST['start']);
		$query = $DB1->get();
		//echo $DB1->last_query();
		return $query->result();
	}

	private function _Online_list1($DB, $date = '', $type_param = '')
	{

		$updated_by = $this->session->userdata('uid');
		$role_id = $this->session->userdata('role_id');


		if ($type_param != '') {
			if ($type_param == 1) {
				//$order_online = array('eq.stud_id' => 'DESC'); // default order  
				$DB->select('`vw`.`school_name`, `vw`.`school_short_name`, `vw`.`course_short_name`, `vw`.`stream_name` as `vstream_name`, 
 `op`.`amount` as `pay_amount`, `eq`.*,`ad`.`applicable_fee`,`op`.payment_date,st.state_name,dt.district_name,tm.taluka_name');
				$DB->from('online_payment as op');
				$DB->join('student_master as eq', 'eq.stud_id=op.student_id', 'inner');
				$DB->join('admission_details as ad', 'ad.student_id=op.student_id', 'left');
				$DB->join('vw_stream_details as vw', 'vw.stream_id=eq.admission_stream', 'left');

				$DB->join('address_details as add', 'add.student_id=eq.stud_id AND add.address_type="CORS"', 'left');

				$DB->join('states as st', 'st.state_id=add.state_id', 'left');
				$DB->join('district_name as dt', 'dt.district_id=add.district_id', 'left');
				$DB->join('taluka_master as tm', 'tm.taluka_id=add.city', 'left');

				if ($date != '') {
					$DB->where("STR_TO_DATE(eq.admission_date,'%Y-%m-%d') ='$date'");
				}

				$DB->where("op.academic_year='2020'");
				$DB->where("eq.academic_year='2020'");
				$DB->where("eq.cancelled_admission='N'");
				$DB->where("eq.enquiry_id='0'");
				$DB->where('op.productinfo', 'New_Admission');
				$DB->where('op.payment_status', 'success');
			} else if ($type_param == 2) {
				// $order_online = array('eq.enquiry_id' => 'DESC'); // default order 
				$DB->select('`vw`.`school_name`, `vw`.`school_short_name`, `vw`.`course_short_name`, `vw`.`stream_name` as `vstream_name`, 
 `op`.`amount` as `pay_amount`,eq.first_name,eq.middle_name,eq.last_name, eq.form_no as form_number,`op`.registration_no as enrollment_no,eq.mobile,`eq`.actual_fee as `applicable_fee`,`op`.payment_date,eq.admission_type as admission_year,st.state_name,dt.district_name,tm.taluka_name');
				$DB->from('online_payment as op');
				$DB->join('enquiry_student_master as eq', 'eq.enquiry_id=op.student_id', 'left');
				//$DB->join('admission_details as ad','ad.student_id=op.student_id','left');
				$DB->join('vw_stream_details as vw', 'vw.stream_id=eq.stream_id', 'left');

				$DB->join('states as st', 'st.state_id=eq.state_id', 'left');
				$DB->join('district_name as dt', 'dt.district_id=eq.district_id', 'left');
				$DB->join('taluka_master as tm', 'tm.taluka_id=eq.city_id', 'left');

				if ($date != '') {
					$DB->where("STR_TO_DATE(eq.created_on,'%Y-%m-%d') ='$date'");
				}

				$DB->where("op.academic_year='2020'");
				$DB->where("eq.admission_year='2020'");


				$DB->where('op.productinfo', 'Online_Admission_Form');
				$DB->where('op.payment_status', 'success');
				$DB->where('op.amount', '1000');
			} else if ($type_param == 3) {
				$date = date('Y-m-d');
				$DB->select('`vw`.`school_name`, `vw`.`school_short_name`, `vw`.`course_short_name`, `vw`.`stream_name` as `vstream_name`, 
 `op`.`amount` as `pay_amount`, `eq`.*,`ad`.`applicable_fee`,`op`.payment_date,st.state_name,dt.district_name,tm.taluka_name');
				$DB->from('online_payment as op');
				$DB->join('student_master as eq', 'eq.stud_id=op.student_id', 'INNER');
				$DB->join('admission_details as ad', 'ad.student_id=op.student_id', 'left');
				$DB->join('vw_stream_details as vw', 'vw.stream_id=eq.admission_stream', 'left');

				$DB->join('address_details as add', 'ad.student_id=eq.stud_id AND add.address_type="CORS"', 'left');

				$DB->join('states as st', 'st.state_id=add.state_id', 'left');
				$DB->join('district_name as dt', 'dt.district_id=add.district_id', 'left');
				$DB->join('taluka_master as tm', 'tm.taluka_id=add.city', 'left');
				//	if($date !=''){
				$DB->where("STR_TO_DATE(op.added_on,'%Y-%m-%d') ='$date'");
				//}

				$DB->where("op.academic_year='2020'");
				$DB->where("eq.academic_year='2020'");
				$DB->where("eq.cancelled_admission='N'");
				$DB->where("eq.enquiry_id='0'");
				$DB->where('op.productinfo', 'New_Admission');
				$DB->where('op.payment_status', 'success');
				//$DB->where('op.added_on', $date);			
			} else if ($type_param == 4) {
				$date = date('Y-m-d');
				// $order_online = array('eq.enquiry_id' => 'DESC'); // default order 
				$DB->select('`vw`.`school_name`, `vw`.`school_short_name`, `vw`.`course_short_name`, `vw`.`stream_name` as `vstream_name`, 
 `op`.`amount` as `pay_amount`,eq.first_name,eq.middle_name,eq.last_name, eq.form_no as form_number,`op`.registration_no as enrollment_no,eq.mobile,`eq`.actual_fee as `applicable_fee`,`op`.payment_date,eq.admission_type as admission_year,st.state_name,dt.district_name,tm.taluka_name');
				$DB->from('online_payment as op');
				$DB->join('enquiry_student_master as eq', 'eq.enquiry_id=op.student_id', 'left');
				//$DB->join('admission_details as ad','ad.student_id=op.student_id','left');
				$DB->join('vw_stream_details as vw', 'vw.stream_id=eq.stream_id', 'left');

				$DB->join('states as st', 'st.state_id=eq.state_id', 'left');
				$DB->join('district_name as dt', 'dt.district_id=eq.district_id', 'left');
				$DB->join('taluka_master as tm', 'tm.taluka_id=eq.city_id', 'left');


				//if($date !=''){
				$DB->where("STR_TO_DATE(eq.created_on,'%Y-%m-%d') ='$date'");
				//}

				$DB->where("op.academic_year='2020'");
				$DB->where("eq.admission_year='2020'");


				$DB->where('op.productinfo', 'Online_Admission_Form');
				$DB->where('op.payment_status', 'success');
				$DB->where('op.amount', '1000');
			}
		}
		#$DB->where('eq.cancelled_admission', 'N');

		//exit();
		/*if($role_id!=24){
	    $DB->where("eq.created_by='".$updated_by."'");	
		}*/
		$i = 0;

		if ($type_param == 1) {
			$search_filter = $this->column_search_online;
			$order_filter = $this->order_online;
			$column_order_filter = $this->column_order;
		} else if ($type_param == 2) {

			$search_filter = $this->column_search;
			$order_filter = $this->order;
			$column_order_filter = $this->column_order;
		} else if ($type_param == 3) {
			$search_filter = $this->column_search_online;
			$order_filter = $this->order_online;
		} else if ($type_param == 4) {
			$search_filter = $this->column_search_online;
			$order_filter = $this->order_online;
		}


		foreach ($search_filter as $item) // loop column  //
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					$DB->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$DB->like($item, $_POST['search']['value']);
				} else {
					$DB->or_like($item, $_POST['search']['value']);
				}

				if (count($search_filter) - 1 == $i) //last loop ///
					$DB->group_end(); //close bracket
			}
			$i++;
		}


		if (isset($_POST['order'])) // here order processing
		{
			$DB->order_by($column_order_filter[$_POST['order']['0']['column']], $_POST['order']['0']['dir']); //
		} else if (isset($order_filter)) //
		{
			$order = $order_filter; //
			$DB->order_by(key($order), $order[key($order)]);
		}
	}


	public function count_filtered_online($date = '', $type_param = '')
	{
		$DB2 = $this->load->database('umsdb', TRUE);
		$this->_Online_list1($DB2, $date, $type_param);
		$query = $DB2->get();
		return $query->num_rows();
	}

	public function count_all_online()
	{
		$DB3 = $this->load->database('umsdb', TRUE);
		$DB3->from('student_master');
		$DB3->where('academic_year', '2020');
		$DB3->where('admission_session', '2020');
		$DB3->where('cancelled_admission', 'N');
		return $DB3->count_all_results();
	}


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




	public function count_filtered($date = '', $type_param = '')
	{
		$DB2 = $this->load->database('umsdb', TRUE);
		$this->_Enquiry_list1($DB2, $date, $type_param);
		$query = $DB2->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$DB3 = $this->load->database('umsdb', TRUE);
		$DB3->from('enquiry_student_master');
		$DB3->where('status', 'Y');
		return $DB3->count_all_results();
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	public function get_datatables_All($date = '', $type_param = '')
	{

		$DB1 = $this->load->database('umsdb', TRUE);
		//	 echo $type_param;
		//  exit();
		$this->_All_list1($DB1, $date, $type_param);

		//$this->_Enquiry_list($DB1);
		if ($_POST['length'] != -1)
			$DB1->limit($_POST['length'], $_POST['start']);
		$query = $DB1->get();
		//echo $DB1->last_query();
		//exit();
		return $query->result();
	}

	private function _All_list1($DB, $date = '', $type_param = '')
	{

		$updated_by = $this->session->userdata('uid');
		$role_id = $this->session->userdata('role_id');

		//exit();
		if ($type_param != '') {
			if ($type_param == 1) {
				//$order_online = array('eq.stud_id' => 'DESC'); // default order  
				$DB->select('`vw`.`school_name`, `vw`.`school_short_name`, `vw`.`course_short_name`, `vw`.`stream_name` as `vstream_name`, 
  `eq`.*,`ad`.`applicable_fee`,st.state_name,dt.district_name,tm.taluka_name');
				$DB->from('student_master as eq');
				//$DB->join('student_master as eq','eq.stud_id=op.student_id','left');
				$DB->join('admission_details as ad', 'ad.student_id=eq.stud_id', 'INNER');
				$DB->join('vw_stream_details as vw', 'vw.stream_id=eq.admission_stream', 'left');

				$DB->join('address_details as add', 'add.student_id=eq.stud_id AND add.address_type="CORS"', 'left');

				$DB->join('states as st', 'st.state_id=add.state_id', 'left');
				$DB->join('district_name as dt', 'dt.district_id=add.district_id', 'left');
				$DB->join('taluka_master as tm', 'tm.taluka_id=add.city', 'left');

				//if($date !=''){
				//$DB->where("STR_TO_DATE(eq.created_on,'%Y-%m-%d') ='$date'");
				//}

				//$DB->where("op.academic_year='2020'");
				$DB->where("eq.academic_year='2020'");
				$DB->where("eq.admission_session='2020'");
				$DB->where("eq.admission_confirm='Y'");
				$DB->where('eq.cancelled_admission', 'N');
				$where = " eq.enrollment_no!= ''  AND  (eq.nationality IS NULL OR eq.nationality!='International' ) "; //eq.nationality IS NULL OR
				$DB->where($where);
				//$DB->where('op.productinfo', 'New_Admission');
				// $DB->where('op.payment_status', 'success');	
			}
			if ($type_param == 2) {
				$date = date("Y-m-d");
				//$order_online = array('eq.stud_id' => 'DESC'); // default order  
				$DB->select('`vw`.`school_name`, `vw`.`school_short_name`, `vw`.`course_short_name`, `vw`.`stream_name` as `vstream_name`, 
  `eq`.*,`ad`.`applicable_fee`,st.state_name,dt.district_name,tm.taluka_name');
				$DB->from('student_master as eq');
				//$DB->join('student_master as eq','eq.stud_id=op.student_id','left');
				$DB->join('admission_details as ad', 'ad.student_id=eq.stud_id', 'INNER');
				$DB->join('vw_stream_details as vw', 'vw.stream_id=eq.admission_stream', 'left');

				$DB->join('address_details as add', 'add.student_id=eq.stud_id AND add.address_type="CORS"', 'left');

				$DB->join('states as st', 'st.state_id=add.state_id', 'left');
				$DB->join('district_name as dt', 'dt.district_id=add.district_id', 'left');
				$DB->join('taluka_master as tm', 'tm.taluka_id=add.city', 'left');

				//if($date !=''){

				$DB->where("STR_TO_DATE(eq.admission_date,'%Y-%m-%d') ='$date'");
				//}

				//$DB->where("op.academic_year='2020'");
				$DB->where("eq.academic_year='2020'");
				$DB->where("eq.admission_session='2020'");
				$DB->where("eq.admission_confirm='Y'");
				$DB->where('eq.cancelled_admission', 'N');
				$where = " eq.enrollment_no!= ''  AND  (eq.nationality IS NULL OR eq.nationality!='International' ) "; //eq.nationality IS NULL OR
				$DB->where($where);
				//$DB->where('op.productinfo', 'New_Admission');
				// $DB->where('op.payment_status', 'success');	
			}
		} else {
			$DB->select('`vw`.`school_name`, `vw`.`school_short_name`, `vw`.`course_short_name`, `vw`.`stream_name` as `vstream_name`, 
  `eq`.*,`ad`.`applicable_fee`,st.state_name,dt.district_name,tm.taluka_name');
			$DB->from('student_master as eq');
			//$DB->join('student_master as eq','eq.stud_id=op.student_id','left');
			$DB->join('admission_details as ad', 'ad.student_id=eq.stud_id', 'INNER');
			$DB->join('vw_stream_details as vw', 'vw.stream_id=eq.admission_stream', 'left');

			$DB->join('address_details as add', 'add.student_id=eq.stud_id AND add.address_type="CORS"', 'left');

			$DB->join('states as st', 'st.state_id=add.state_id', 'left');
			$DB->join('district_name as dt', 'dt.district_id=add.district_id', 'left');
			$DB->join('taluka_master as tm', 'tm.taluka_id=add.city', 'left');

			//if($date !=''){
			//$DB->where("STR_TO_DATE(eq.created_on,'%Y-%m-%d') ='$date'");
			//}

			//$DB->where("op.academic_year='2020'");
			$DB->where("eq.academic_year='2020'");
			$DB->where("eq.admission_session='2020'");

			$DB->where('eq.cancelled_admission', 'N');
			$where = " eq.enrollment_no!= ''  AND  (eq.nationality IS NULL OR eq.nationality!='International' ) "; //eq.nationality IS NULL OR
			$DB->where($where);
		}
		#$DB->where('eq.cancelled_admission', 'N');

		//exit();
		/*if($role_id!=24){
	    $DB->where("eq.created_by='".$updated_by."'");	
		}*/
		$i = 0;

		foreach ($this->column_search_all as $item) // loop column 
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					$DB->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$DB->like($item, $_POST['search']['value']);
				} else {
					$DB->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search_all) - 1 == $i) //last loop
					$DB->group_end(); //close bracket
			}
			$i++;
		}


		if (isset($_POST['order'])) // here order processing
		{
			$DB->order_by($this->column_order_all[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order_all)) {
			$order = $this->order_all;
			$DB->order_by(key($order), $order[key($order)]);
		}
	}


	public function count_filtered_All_list($date = '', $type_param = '')
	{
		$DB2 = $this->load->database('umsdb', TRUE);
		$this->_All_list1($DB2, $date, $type_param);
		$query = $DB2->get();
		return $query->num_rows();
	}

	public function count_All_list()
	{
		$DB3 = $this->load->database('umsdb', TRUE);
		$DB3->from('student_master');
		$DB3->where('academic_year', '2020');
		$DB3->where('admission_session', '2020');
		$DB3->where('cancelled_admission', 'N');
		$where = "enrollment_no` != ''";
		$DB3->where($where);
		return $DB3->count_all_results();
	}


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function students_data($data)
	{
		$ICDB = $this->load->database('icdb', TRUE);

		$ICDB->select("sm.current_year,sm.mobile,sm.admission_session,sm.first_name,sm.middle_name,sm.last_name,sm.academic_year,sm.enquiry_no as enrollment_no,sm.stude_id as stud_id,
		sm.stream_id as admission_stream,vw.stream_short_name as stream_name,vw.course_short_name as course_name, vw.school_short_name as school_name,");
		$ICDB->from("sandipun_ums.enquiry_student_master sm");

		$ICDB->join("sandipun_ums.vw_stream_details vw", "sm.stream_id = vw.stream_id");
		$ICDB->where('sm.enquiry_no', $data['enrollment_no']);
		$ICDB->where('status', 'Y');
		//$ICDB->or_where('sm.enrollment_no_new', $data['enrollment_no']);
		// $ICDB->where("sm.admission_cycle IS NULL");
		$query1 = $ICDB->get();
		//echo $ICDB->last_query();
		return $query1->row_array();
	}

	public function get_fee_details($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$session = $this->session->userdata('logged_in');

		/* $sql="select fd.amount_p as amount_paid,ad.applicable_fee,ad.actual_fee,ad.opening_balance,
		af.academic_fees,af.tution_fees,af.development,af.caution_money,af.admission_form,af.Gymkhana,af.disaster_management,af.accommodation,
		af.student_safety_insurance,af.internet,af.library,af.registration,af.eligibility,af.educational_industrial_visit,
		af.seminar_training,af.exam_fees,af.student_activity,af.lab,af.computerization,af.nss
		FROM `admission_details` as `ad`
		 left JOIN (SELECT SUM(amount) AS amount_p,student_id,academic_year,chq_cancelled,is_deleted FROM fees_details WHERE
 academic_year='".$data['academic']."' AND chq_cancelled='N' AND is_deleted='N'  AND type_id= '2' AND `student_id` = '".$data['stud']."') as `fd`
  ON `ad`.`student_id` = `fd`.`student_id` And ad.academic_year=fd.academic_year 
		 
		LEFT JOIN academic_fees af ON  ad.stream_id=af.stream_id AND af.academic_year='".$new_year."' AND af.admission_year='".$data['admission_session']."' 
		AND af.year='".$curr_yr."' AND af.`is_active`='Y'
		WHERE  `ad`.`student_id` = '".$data['stud']."'
		
		AND ad.academic_year =  '".$data['academic']."'
		AND `ad`.`cancelled_admission` = 'N' GROUP BY fd.student_id";*/
		$sql = "SELECT em.*,ad.* FROM  academic_fees as ad 
		 INNER JOIN enquiry_student_master as em ON em.stream_id=ad.stream_id AND em.current_year=ad.year AND em.admission_year=ad.admission_year
		 WHERE ad.stream_id='" . $data['stream_id'] . "' AND ad.year='" . $data['curr_yr'] . "' AND ad.admission_year='2020' AND em.enquiry_no='" . $data['enroll'] . "'";
		$query = $DB1->query($sql);
		if ($this->session->userdata("uid") == 2) {
			//echo  $DB1->last_query(); //af.admission_year=ad.academic_year AND
			//print_r($query->row_array());
		}
		return $query->row_array();
	}


	public function fee_details($data)
	{

		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT *,type_id AS ntype_id FROM fees_challan WHERE academic_year ='" . $data['academic'] . "' AND student_id = '" . $data['stud'] . "'
			AND type_id= '" . $data['facility'] . "' AND enrollment_no='" . $data['enroll'] . "' AND challan_status !='CL' AND type_id='2'
			ORDER BY fees_id DESC limit 0,1";
		$query = $DB1->query($sql);
		if ($this->session->userdata("uid") == 2) {
			// echo  $DB1->last_query();
		}
		return $query->row_array();
	}

	///////////////////////////////////////////check_fees_challan_submit Details///////////////////////////////////////////

	public function check_fees_challan_submit($data)
	{
		$DB = $this->load->database('umsdb', TRUE);
		//print_r($_POST);
		//exit();

		function getUserIpAddr()
		{
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				//ip from share internet
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				//ip pass from proxy
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}

		$sql = "SELECT em.*,ad.* FROM  academic_fees as ad 
		 INNER JOIN enquiry_student_master as em ON em.stream_id=ad.stream_id AND em.current_year=ad.year AND em.admission_year=ad.admission_year
		 WHERE ad.stream_id='" . $data['stream_id'] . "' AND ad.year='" . $data['curr_yr'] . "' AND ad.admission_year='2020' AND em.enquiry_no='" . $data['enroll'] . "'";
		$query = $DB->query($sql);
		$result = $query->row_array();
		print_r($result);
		echo '<br>'; //exit();ech
		foreach ($result as $val) {
			echo $val['enquiry_no'];
		} {
			echo $list['enquiry_no'];
			$st_master['form_number'] = $list['enquiry_no'];

			//$st_master['enrollment_no_new']=$list[''];
			//$st_master['enrollment_no']=$list[''];

			$st_master['first_name'] = $list['first_name'] . ' ' . $list['middle_name'] . ' ' . $list['last_name'];
			//$st_master['middle_name']=$list['middle_name'];
			//$st_master['last_name']=$list['last_name'];
			$st_master['gender'] = $list['gender'];
			$st_master['email'] = $list['email_id'];
			$st_master['mobile'] = $list['mobile'];
			$st_master['category'] = $list['category'];
			$st_master['adhar_card_no'] = $list['aadhar_card'];


			$st_master['lateral_entry'] = ($list['admission_type'] == 1) ? "N" : "Y";
			$st_master['current_semester'] = ($list['admission_type'] == 1) ? 1 : 3;
			$st_master['admission_semester'] = ($list['admission_type'] == 1) ? 1 : 3;
			$st_master['admission_year'] = ($list['admission_type'] == 1) ? 1 : 2;
			$st_master['current_year'] = ($list['admission_type'] == 1) ? 1 : 2;

			$st_master['academic_year'] = $list['academic_year'];
			$st_master['admission_session'] = $list['admission_session'];
			$st_master['admission_school'] = $list['school_id'];
			$st_master['admission_stream'] = $list['stream_id'];


			$st_master['is_detained'] = 'N';
			$st_master['cancelled_admission'] = 'N';
			$st_master['admission_date'] = date('Y-m-d');
			$st_master['entry_from_ip'] = getUserIpAddr();
			$st_master['created_by'] = $list[''];
			$st_master['created_on'] = date('Y-m-d h:i:s');
			$st_master['modified_by'] = $list[''];
			$st_master['modified_on'] = date('Y-m-d h:i:s');

			$st_master['enquiry_id'] = $list['enquiry_id'];
		} //Loop
		//print_r($st_master);
		///exit();
		$DB->trans_begin();
		$result = $DB->insert('temp_student_master', $st_master);
		$DB->trans_complete();
		if ($DB->trans_status() === FALSE) {
			$DB->trans_rollback();
			$student_id = 0;
			//return $enquiry_id.'/'.$enquiry_newno;
		} else {
			$DB->trans_commit();
			$student_id = $DB->insert_id();
			// return $enquiry_id.'/'.$enquiry_newno;//$this->db->insert_id();
		}

		if ($student_id != 0) {
			$generateprovisional = generateprovisional($student_id);
			exit();
			///////////////////////////////////////////Admission Details///////////////////////////////////////////
			if ($generateprovisional != '') {

				$adm['student_id'] = $student_id;
				$adm['form_number'] = $list['form_no'];
				$adm['enrollment_no'] = $generateprovisional;

				$adm['school_code'] = $list['school_id'];
				$adm['stream_id'] = $list['stream_id'];
				$adm['year'] = $list['admission_type'] == 1 ? 1 : 2;
				$adm['academic_year'] = $list['acyear'];
				$adm['actual_fee'] = $list['actual_fee'];
				$adm['applicable_fee'] = $list['actual_fee'];
				if (!empty($adm) && $enquiry_id != '') {
					$DB1->select("*");
					$DB1->from('admission_details');
					//$DB1->where('school_code',$data['admission-school']);
					//$DB1->where('stream_id',$data['admission-branch']);
					//$DB1->where('academic_year',$data['acyear']);
					$DB1->where('student_id', $student_id);
					$check_whether_entry_exists = $DB1->get()->row();

					if (empty($check_whether_entry_exists)) {
						//   $DB1->insert('admission_details',$adm);
						return	$DB1->insert_id();
					} else {
						// $DB1->update('admission_details',$adm,array('adm_id'=>$check_whether_entry_exists->adm_id));
						return $check_whether_entry_exists->adm_id;
					}
				} else { //if($generateprovisional!='')
					return 0;
				}
			}
		} //if($student_id!=0){



		//exit();


		/////////////////////////////////////////////////////////////////////////////////////	
		if ($list['scholarship_allowed'] == "YES") {
			$scholarship['concession_type'] = $list['scholarship_type'];
			$scholarship['student_id'] = $student_id;
			$scholarship['enrollement_no'] = $generateprovisional;
			$scholarship['academic_year'] = 2020;

			$scholarship['actual_fees'] = $list['actual_fee'];
			$scholarship['exepmted_fees'] = $list['scholarship_amount'];
			$scholarship['fees_paid_required'] = $list['actual_fee'] - $list['scholarship_amount'];
			$scholarship['concession_remark'] = '';
			$scholarship['allowed_by'] = 'Admin';

			$scholarship['created_by'] = $list['gender'];
			$scholarship['created_on'] = $list['gender'];
			$scholarship['modified_by'] = $list['gender'];
			$scholarship['modified_on'] = $list['gender'];
			$scholarship['remark'] = $list['gender'];
			$DB1->insert('fees_consession_details', $scholarship);
			return	$DB1->insert_id();
		}
		/////////////////////////////////////////////////////////////////////////////////////////////	
		//}//Loop

		////////////////////////////////////////// Challan Start/////////////////////////////////////	

		$challan_digits = 4;
		if ($_POST['fees_date'] == '')
			$fdate = date("Y-m-d");
		else
			$fdate = date("Y-m-d", strtotime($_POST['fees_date']));
		//echo '<pre>';	print_r($_POST);

		//	exit;

		$enroll = $generateprovisional;
		$student_id = $student_id;

		$academic = $_POST['academic'];
		$facilty = $_POST['facilty'];

		//$_POST['depositto'];
		//$_POST['category'];

		$Balance_Amount = $_POST['Balance_Amount'];
		$tutf = $_POST['tutf'];
		$devf = $_POST['devf'];
		$cauf = $_POST['cauf'];
		$admf = $_POST['admf'];
		$exmf = $_POST['exmf'];
		$unirf = $_POST['unirf'];

		$_POST['amt'];
		$refund_paid = $_POST['amth'];
		$Excess_Fees = $_POST['Excess'];

		//$_POST['epayment_type'];
		//$_POST['receipt_number'];
		//$_POST['bank'];
		//$_POST['branch'];
		//echo $fdate; exit();
		//////////////////////////////////////////////////////////////////////////////////////////////

		$Backlog_Exam = $_POST['Backlog_Exam'];
		$Photocopy_Fees = $_POST['Photocopy_Fees'];
		$Revaluation_Fees = $_POST['Revaluation_Fees'];
		$Late_Fees = $_POST['Late_Fees'];

		$OtherFINE_Brekage = $_POST['OtherFINE_Brekage'];
		$Other_Registration = $_POST['Other_Registration'];
		$Other_Late = $_POST['Other_Late'];
		$Other_fees = $_POST['Other_fees'];
		//////////////////////////////////////////////////////////////////////////////////////////////
		$Balance_org = $_POST['Balance_org'];
		$Tuition_org = $_POST['Tuition_org'];
		$development_org = $_POST['development_org'];
		$caution_org = $_POST['caution_org'];
		$admission_org = $_POST['admission_org'];
		$exam_org = $_POST['exam_org'];
		$University_org = $_POST['University_org'];
		//////////////////////////////////////////////////////////////
		$currnt = array('stud' => $student_id, 'enroll' => $generateprovisional, 'facility' => $facilty, 'academic' => $academic);
		$Check_challan = $this->Challan_model->Check_challan($currnt);
		//	print_r($Check_challan);
		//echo '<br>';
		//echo 'fees_id'.$Check_challan[0]['fees_id'];
		//echo '<br>';
		if (empty($Check_challan[0]['fees_id'])) {
			$Balance_pending = $Balance_org - $Balance_Amount;
			$Tuition_pending = $Tuition_org - $tutf;

			$development_pending = $development_org - $devf;
			if ($this->session->userdata("uid") == 2) {
				//echo $development_org;echo ' development_org<br>';
				//echo $devf;echo '<br>';
				//echo $development_pending;echo '<br>';
				//exit;
			}

			$caution_pending = $caution_org - $cauf;
			$admission_pending = $admission_org - $admf;
			$exam_pending = $exam_org - $exmf;
			$University_pending = $University_org - $unirf;

			if ($Balance_pending == 0) {
				$Balance_Amount_status = 'Y';
			} else {
				$Balance_Amount_status = 'N';
			}


			if ($Tuition_pending == 0) {
				$tution_status = 'Y';
			} else {
				$tution_status = 'N';
			}

			if ($development_pending == 0) {
				$development_status = 'Y';
			} else {
				$development_status = 'N';
			}

			if ($caution_pending == 0) {
				$caution_status = 'Y';
			} else {
				$caution_status = 'N';
			}

			if ($admission_pending == 0) {
				$admission_status = 'Y';
			} else {
				$admission_status = 'N';
			}

			if ($exam_pending == 0) {
				$exam_status = 'Y';
			} else {
				$exam_status = 'N';
			}

			if ($University_pending == 0) {
				$university_status = 'Y';
			} else {
				$university_status = 'N';
			}
		} else {

			if ($Check_challan[0]['Balance_Amount_status'] == "N") {
				$Balance_pending = $Check_challan[0]['Balance_Pending'] - $Balance_Amount;
			} else {
				$Balance_pending = $Check_challan[0]['Balance_Pending'];
			}


			if ($Check_challan[0]['tution_status'] == "N") {
				$Tuition_pending = $Check_challan[0]['tution_pending'] - $tutf;
			} else {
				$Tuition_pending = $Check_challan[0]['tution_pending'];
			}

			if ($Check_challan[0]['development_status'] == "N") {
				$development_pending = $Check_challan[0]['development_pending'] - $devf;
			} else {
				$development_pending = $Check_challan[0]['development_pending'];
			}

			if ($this->session->userdata("uid") == 2) {
				//echo $Check_challan[0]['development_pending'];echo ' Check_challan<br>';
				//echo $devf;echo '<br>';
				//echo $development_pending;echo '<br>';
				//exit;
			}


			if ($Check_challan[0]['caution_status'] == "N") {
				$caution_pending = $Check_challan[0]['caution_pending'] -  $cauf;
			} else {
				$caution_pending = $Check_challan[0]['caution_pending'];
			}
			if ($Check_challan[0]['admission_status'] == "N") {
				$admission_pending = $Check_challan[0]['admission_pending'] - $admf;
			} else {
				$admission_pending = $Check_challan[0]['admission_pending'];
			}
			if ($Check_challan[0]['exam_status'] == "N") {
				$exam_pending = $Check_challan[0]['exam_pending'] -  $exmf;
			} else {
				$exam_pending = $Check_challan[0]['exam_pending'];
			}
			if ($Check_challan[0]['university_status'] == "N") {
				$University_pending = $Check_challan[0]['university_pending'] - $unirf;
			} else {
				$University_pending = $Check_challan[0]['university_pending'];
			}



			if ($Balance_pending == 0) {
				$Balance_Amount_status = 'Y';
			} else {
				$Balance_Amount_status = 'N';
			}

			if ($Tuition_pending == 0) {
				$tution_status = 'Y';
			} else {
				$tution_status = 'N';
			}

			if ($development_pending == 0) {
				$development_status = 'Y';
			} else {
				$development_status = 'N';
			}

			if ($caution_pending == 0) {
				$caution_status = 'Y';
			} else {
				$caution_status = 'N';
			}

			if ($admission_pending == 0) {
				$admission_status = 'Y';
			} else {
				$admission_status = 'N';
			}

			if ($exam_pending == 0) {
				$exam_status = 'Y';
			} else {
				$exam_status = 'N';
			}

			if ($University_pending == 0) {
				$university_status = 'Y';
			} else {
				$university_status = 'N';
			}
		}
		$fdate;
		$epayment_type = $_POST['epayment_type'];
		$receipt_number = $_POST['receipt_number'];
		//$TransactionNo=$_POST['TransactionNo'];
		//$TransactionDate=$_POST['TransactionDate'];
		/*if(isset($_POST['Balance_Amount_check'])){
			$Balance_c="Y";
		}else{
			$Balance_c="N";
		}*/
		///echo $Balance_c;
		//exit;$enroll=$generateprovisional;
		//$student_id=$student_id;
		//Remark
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		if ($_POST['facilty'] == 2) {
			$insert_array = array(
				"enrollment_no" => $generateprovisional,
				"student_id" => $student_id,
				"academic_year" => $_POST['academic'],
				"type_id" => $_POST['facilty'],
				"bank_account_id" => $_POST['depositto'],
				"college_receiptno" => $_POST['category'],
				"tution_fees" => $_POST['tutf'],
				"development_fees" => $_POST['devf'],
				"caution_money" => $_POST['cauf'],
				"admission_form" => $_POST['admf'],
				"exam_fees" => $_POST['exmf'],
				"university_fees" => $_POST['unirf'],
				"amount" => $_POST['amt'],
				"fees_paid_type" => $_POST['epayment_type'],
				"TransactionNo" => $receipt_number,
				"TransactionDate" => $fdate,
				"receipt_no" => $receipt_number,
				"fees_date" => $fdate,
				"bank_id" => $_POST['bank'],
				"bank_city" => $_POST['branch'],
				"entry_from_ip" => $_SERVER['REMOTE_ADDR'],
				"created_by" => $this->session->userdata("uid"),
				"created_on" => date("Y-m-d H:i:s"),
				"refund_pay" => $refund_paid,
				"Excess_Fees" => $refund_paid,
				"tution_pending" => $Tuition_pending,
				"tution_status" => $tution_status,
				"development_pending" => $development_pending,
				"development_status" => $development_status,
				"caution_pending" => $caution_pending,
				"caution_status" => $caution_status,
				"admission_pending" => $admission_pending,
				"admission_status" => $admission_status,
				"exam_pending" => $exam_pending,
				"exam_status" => $exam_status,
				"university_pending" => $University_pending,
				"university_status" => $university_status,
				"Balance_Amount" => $_POST['Balance_Amount'],
				"Balance_Pending" => $Balance_pending,
				"Balance_Amount_status" => $Balance_Amount_status,
				"remark" => $_POST['Remark']
			);
			if ($this->session->userdata("uid") == 2) {
				//print_r($insert_array);
				//exit;
			}
		} elseif (($_POST['facilty'] == 5) || ($_POST['facilty'] == 7) || ($_POST['facilty'] == 8) || ($_POST['facilty'] == 9)) {
			$exam_mon = $_POST['exam_monthyear'];
			$arr_exammon = explode(':', $exam_mon);

			$insert_array = array(
				"enrollment_no" => $_POST['enroll'],
				"student_id" => $_POST['student_id'],
				"academic_year" => $_POST['academic'],
				"type_id" => $_POST['facilty'],
				"bank_account_id" => $_POST['depositto'],
				"college_receiptno" => $_POST['category'],
				"Backlog_fees" => $_POST['Backlog_Exam'],
				"Photocopy_fees" => $_POST['Photocopy_Fees'],
				"Revaluation_Fees" => $_POST['Revaluation_Fees'],
				"Exam_LateFees" => $_POST['Late_Fees'],
				"amount" => $_POST['amt'],
				"Balance_Amount" => $_POST['Balance_Amount'],
				"Balance_Amount_status" => $Balance_c,
				"exam_monthyear" => $arr_exammon[0],
				"exam_id" => $arr_exammon[1],
				"fees_paid_type" => $_POST['epayment_type'],
				"TransactionNo" => $receipt_number,
				"TransactionDate" => $fdate,
				"receipt_no" => $receipt_number,
				"fees_date" => $fdate,
				"bank_id" => $_POST['bank'],
				"bank_city" => $_POST['branch'],
				"entry_from_ip" => $_SERVER['REMOTE_ADDR'],
				"created_by" => $this->session->userdata("uid"),
				"remark" => $_POST['Remark'],
				"created_on" => date("Y-m-d H:i:s")
			);
		} elseif ($_POST['facilty'] == 10) {
			$insert_array = array(
				"enrollment_no" => $_POST['enroll'],
				"student_id" => $_POST['student_id'],
				"academic_year" => $_POST['academic'],
				"type_id" => $_POST['facilty'],
				"bank_account_id" => $_POST['depositto'],
				"college_receiptno" => $_POST['category'],
				"OtherFINE_Brekage" => $_POST['OtherFINE_Brekage'],
				"Other_Registration" => $_POST['Other_Registration'],
				"Other_Late" => $_POST['Other_Late'],
				"Other_fees" => $_POST['Other_fees'],
				"amount" => $_POST['amt'],
				"Balance_Amount" => $_POST['Balance_Amount'],
				"Balance_Amount_status" => $Balance_c,
				"fees_paid_type" => $_POST['epayment_type'],
				"TransactionNo" => $receipt_number,
				"TransactionDate" => $fdate,
				"receipt_no" => $receipt_number,
				"fees_date" => $fdate,
				"bank_id" => $_POST['bank'],
				"bank_city" => $_POST['branch'],
				"remark" => $_POST['Remark'],
				"entry_from_ip" => $_SERVER['REMOTE_ADDR'],
				"created_by" => $this->session->userdata("uid"),
				"created_on" => date("Y-m-d H:i:s")
			);
		}
		//echo '<pre>';print_r($insert_array);
		//exit;
		$last_inserted_id = $this->Challan_model->add_fees_challan_submit($insert_array);
		//echo 'last_inserted_id==='.$last_inserted_id;exit();
		if ($last_inserted_id) {
			if ($last_inserted_id > 9999) {
				$challan_digits = strlen($last_inserted_id);
			}


			if ($_POST['curr_yr'] == "1") {
				$addmision_type = 'A';
			} else {
				$addmision_type = 'R';
			}

			$current_month = date('m');

			//if($current_month<=5){
			//	$month_session="2";
			//}else{
			$month_session = "1";
			//}

			$ayear = substr($_POST['academic'], -2);  //explode("-",$_POST['academic']);$ayear.
			$challan_no = '20SUN' . $addmision_type . $month_session . str_pad($last_inserted_id, $challan_digits, "0", STR_PAD_LEFT);

			$update_array = array("exam_session" => $challan_no);
			$last_inserted_id = $this->Challan_model->update_challan_no($last_inserted_id, $update_array);
			$this->session->set_flashdata('message1', 'Fees Challan Generated Successfully.');
		} else
			$this->session->set_flashdata('message2', 'Fees Challan Not Generated Successfully.');

		// redirect('Challan');

		////////////////////////////////////////// Challan Start/////////////////////////////////////	



	}



	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	


	function insert_in_admission_details($data = array(), $stud_id = '')
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$data_array = array();
		$data_array['student_id'] = $stud_id;
		$data_array['school_code'] = $data['admission-school'];
		$data_array['stream_id'] = $data['admission-branch'];
		$data_array['year'] = $data['admission_type'] == 1 ? 1 : 2;
		$data_array['academic_year'] = $data['acyear'];
		$data_array['actual_fee'] = $data['actual_fee'];
		$data_array['applicable_fee'] = $data['actual_fee'];
		if (!empty($data) && $stud_id != '') {
			$DB1->select("*");
			$DB1->from('admission_details');
			//$DB1->where('school_code',$data['admission-school']);
			//$DB1->where('stream_id',$data['admission-branch']);
			//$DB1->where('academic_year',$data['acyear']);
			$DB1->where('student_id', $stud_id);
			$check_whether_entry_exists = $DB1->get()->row();

			if (empty($check_whether_entry_exists)) {
				$DB1->insert('admission_details', $data_array);
				return	$DB1->insert_id();
			} else {
				$DB1->update('admission_details', $data_array, array('adm_id' => $check_whether_entry_exists->adm_id));
				return $check_whether_entry_exists->adm_id;
			}
		} else {
			return 0;
		}
	}

	function generateprovisional($student_id = '')
	{     //$DB = $this->load->database('umsdb', TRUE);
		$finalprn = '';
		$DB1 = $this->load->database('umsdb', TRUE);
		$student_data = $DB1->get_where('student_master', array('stud_id' => $student_id))->row();
		if (!empty($student_data)) {
			$stream_id = $student_data->admission_stream;
			$academic_year = $student_data->academic_year;
			$admission_year = $student_data->admission_session;

			$stmdet = $DB1->query("select * from temp_student_master where academic_year=$academic_year and admission_session=$admission_year and enrollment_no_new IS NOT NULL and enrollment_no_new  !='' order by enrollment_no_new desc LIMIT 1")->row();


			if (!empty($stmdet)) {
				$auto = $stmdet->enrollment_no_new;
			} else {
				$auto = substr($student_data->academic_year, -2) . "SUN0000";
			}

			$var1 = substr($auto, -4);
			$var1 = ++$var1;
			$prn =  sprintf("%04d", $var1);
			$finalprn  = substr($student_data->academic_year, -2) . "SUN" . $prn;
			$DB1->update('temp_student_master', array('enrollment_no_new' => $finalprn, 'enrollment_no' => $finalprn), array('stud_id' => $student_id));
		}
		return $finalprn;
	}

//ValidFunction
	function enquiry_by_id($id)
	{
		$DB = $this->load->database('umsdb', TRUE);

		$sql = "SELECT vw.`school_name`,vw.`course_short_name`,vw.`stream_name`,st.state_name,dt.`district_name`,tm.`taluka_name`,em.*,ad.* FROM academic_fees AS ad 
INNER JOIN enquiry_student_master AS em ON em.stream_id=ad.stream_id AND em.current_year=ad.year AND em.admission_year=ad.admission_year 
LEFT JOIN `vw_stream_details` AS vw ON vw.stream_id=em.stream_id

LEFT JOIN `states` AS st ON st.state_id=em.state_id
LEFT JOIN `district_name` AS dt ON dt.`district_id`=em.district_id
LEFT JOIN `taluka_master` AS tm ON tm.`taluka_id`=em.city_id

WHERE em.enquiry_id='$id'";

		$query = $DB->query($sql);
		$result = $query->row_array();
		return $result;
		//print_r($result); echo '<br>'; //
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////	

	public function adhar_check($value)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('count(enquiry_id) as total');
		$DB1->from('enquiry_student_master');
		$DB1->where('aadhar_card', $value);
		//  $DB1->limit('1');
		$query = $DB1->get();
		$result = $query->result_array();
		return $result[0]['total'];
	}

	public function Searchby_name($data)
	{

		$DB1 = $this->load->database('umsdb', TRUE);

		if (!empty($_POST["keyword"])) {

			$sql = "SELECT * FROM enquiry_student_master WHERE first_name like '" . $data["keyword"] . "%' OR middle_name like '" . $data["keyword"] . "%' OR last_name like '" . $data["keyword"] . "%'  ORDER BY first_name LIMIT 0,6";

			$query = $DB1->query($sql);
			$result = $query->result_array();
			return $result;
		}
	}
	//$result = $db_handle->runQuery($query);
	//////////////////////////////////////////////////////////////////////////////////////////////////////

	function Update_scholarship($id)
	{
		$current_date = date('Y-m-d h:i:s');
		$DB = $this->load->database('umsdb', TRUE);
		$sql = "SELECT af.`academic_fees`,af.`tution_fees`,af.`total_fees`,st.stud_id,st.enrollment_no,st.academic_year,st.admission_school,st.admission_stream,st.admission_year FROM student_master AS st

LEFT JOIN `academic_fees` AS af ON af.stream_id=st.`admission_stream` AND af.year=st.`admission_year` AND af.admission_year=st.`academic_year`

WHERE st.stud_id='$id'";

		$query = $DB->query($sql);
		$result = $query->result_array();
		//print_r($result); echo '<br>'; //exit();ech
		foreach ($result as $val) {
			//echo $val['tution_fees']; echo '<br>';
			$stud_id = $val['stud_id'];
			$enrollment_no = $val['enrollment_no'];
			$total_fees = $val['total_fees'];
			$scloership = (($val['tution_fees']) * 10 / 100);
			$year = $val['admission_year'];
			echo $val['tution_fees'] . '---' . round($scloership);
			echo '<br>';

			$scloership = round($scloership);

			$fees_paid_required = ($val['total_fees'] - round($scloership));

			$DB1 = $this->load->database('umsdb', TRUE);



			/*$sql2 ="INSERT INTO `fees_consession_details`  VALUES (NULL, 'Other_Scholarship', '$stud_id', '$enrollment_no', '2020', '$total_fees', '$scloership', '$fees_paid_required', 'covid 10%', NULL, NULL, NULL, NULL, '$current_date', NULL)"; 
		
		 $query = $DB1->query($sql2);*/


			$created_on = date('Y-m-d H:i:s');
			$fees_con['concession_type'] = 'Other_Scholarship';
			$fees_con['student_id'] = $stud_id;
			$fees_con['enrollement_no'] = $enrollment_no;
			$fees_con['academic_year'] = '2020';
			$fees_con['actual_fees'] = $total_fees;
			$fees_con['exepmted_fees'] = $scloership;
			$fees_con['fees_paid_required'] = $fees_paid_required;
			$fees_con['concession_remark'] = 'covid 10%';
			// $fees_con['allowed_by'] = $var['stream_id'];
			//$fees_con['created_by'] = $var['stream_id'];
			$fees_con['created_on'] = $created_on;
			// $fees_con['modified_by'] = $var['stream_id'];
			// $fees_con['modified_on'] = $var['stream_id'];
			//$fees_con['remark'] = $var['stream_id'];

			$DB1->insert('fees_consession_details', $fees_con);



			$DB3 = $this->load->database('umsdb', TRUE);
			$sql3 = "UPDATE `sandipun_ums`.`admission_details` SET enrollment_no='$enrollment_no',`applicable_fee` = '$fees_paid_required' , `fees_consession_allowed` = 'Y',`concession_type` = 'other_type',`concession_remark` = 'covid 10%'
   WHERE `student_id` = '$stud_id' AND academic_year='2020' AND year='$year'";
			$query = $DB3->query($sql3);
		}
	}
	
//ValidFunction
	public function Checkaadhar($stateID, $mobile, $year = '')
	{
		$ICDB = $this->load->database('icdb', TRUE);

		if (empty($year)) {
			$year =  $this->config->item('current_year');
		}
		$current_year = explode('-',  $year);
		$current_year = $current_year[0];
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('created_by,enquiry_id,1 as froms');
		$DB1->from('enquiry_student_master');
		$DB1->where('aadhar_card', $stateID);
		$DB1->where('admission_session', $current_year);
		$query = $DB1->get();

		$result = $query->row();
		if (empty($result)) {

			$ICDB->select('created_by,student_id,2 as froms');
			$ICDB->from('aadhar_car_updation');
			$ICDB->where('aadhar_car_updation.add_no', $stateID);
			$ICDB->where('academic_year', $year);
			$query = $ICDB->get();
			$result = $query->row();
			if (!empty($result)) {
				return $result;
			} else {

				$DB1 = $this->load->database('ums_sijoul', TRUE);
				$DB1->select('created_by,enquiry_id,3 as froms');
				$DB1->from('enquiry_student_master');
				$DB1->where('aadhar_card', $stateID);
				$DB1->where('academic_year', $current_year);
				$query = $DB1->get();
				$result = $query->row();
				if (!empty($result)) {

					return array('created_by' => 1);
				} else {
					return array('created_by' => 0);
				}
			}
		} else {
			return $result;
		}
	}
//ValidFunction
	public function check_is_exists_in_main_erp($aadhar, $year = '')
	{
		if (empty($year)) {
			$year =  $this->config->item('current_year');
		}

		$current_year = explode('-',  $year);
		$current_year = $current_year[0];
		$DB1 = $this->load->database('umsdb', TRUE);
		$result = $DB1->query("select (stud_id) as id  from student_master where adhar_card_no='$aadhar' and enrollment_no !=''  and admission_session='$current_year' and cancelled_admission='N'
UNION 
select (sm.stud_id)  as id from sandipun_ums_sijoul.student_master as sm where sm.adhar_card_no='$aadhar' and sm.enrollment_no !='' 
and sm.admission_session='$current_year' and cancelled_admission='N'
UNION 
select (sm.enquiry_id)  as id from sandipun_ums_sijoul.enquiry_student_master
 as sm where sm.aadhar_card='$aadhar' 
and sm.academic_year='$current_year' 
UNION 
select (sm.id)  as id from sandipun_ic_erp22.aadhar_car_updation as sm where sm.add_no='$aadhar' 
and sm.academic_year='$year' 
")->result_array();
		if (!empty($result)) {
			return 1;
		} else {

			return 0;
		}
	}
//ValidFunction
	public function checkmobileinerp($mobile)  
	{

		$year =  $this->config->item('current_year');
		$current_year = explode('-',  $year);
		$current_year = $current_year[0];
		$DB1 = $this->load->database('umsdb', TRUE);
		$result = $DB1->query("select (stud_id) as id  from student_master where mobile='$mobile' and enrollment_no !=''  and admission_session='$current_year' and cancelled_admission='N'
UNION 
select (sm.stud_id)  as id from sandipun_ums_sijoul.student_master as sm where sm.mobile='$mobile' and sm.enrollment_no !='' 
and sm.admission_session='$current_year' and cancelled_admission='N'

")->result_array();
		if (!empty($result)) {
			return 1;
		} else {

			return 0;
		}
	}


	function api_integration($array = array())
	{
		exit;
		$updated_by = $this->session->userdata('uid');
		$ICDB = $this->load->database('icdb', TRUE);

		$get_consultant_details = $ICDB->query("select  COALESCE((select ic_user_master.fname from ic_user_master join user_master u on ic_user_master.employee_code=u.employee_code  where u.um_id=consultants_call_details.consultant_head),0)
 as consultant_head,
COALESCE((select ic_user_master.fname from ic_user_master join user_master u on ic_user_master.employee_code=u.employee_code  where u.um_id=consultants_call_details.co_reff_by),0)
 as admission_cordinators,
consultants_call_details.contact_person from consultants_call_details join user_master on consultants_call_details.id=user_master.con_id 
where user_master.um_id =$updated_by")->row();


		$data = array('AuthToken' => 'SANDIPUNIVERSITY-17-07-2021');
		$data['Source'] = "sandipuniversity";
		$data['FirstName'] = $array['first_name'];
		$data['MobileNumber'] = $array['mobile'];
		$data['Email'] = $array['email'];
		$data['LeadSource'] = 'ERP Consultant Lead';
		$data['LeadType'] = "Online";
		$data['LeadName'] = 'ERP Consultant Lead';
		$data['Remarks'] = "ERP Consultant Lead";
		$data['Textb3'] = $get_consultant_details->consultant_head;
		$data['Textb4'] = $get_consultant_details->admission_cordinators;
		$data['Textb5'] = $get_consultant_details->contact_person;
		$data['Textb6'] = $array['Textb6'];
		$data['Textb7'] = $array['Textb7'];

		$data_string = json_encode($data);
		$url = 'https://thirdpartyapi.extraaedge.com/api/SaveRequest';
		$username = "your_api_key";
		$password = "xxxxxx";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_USERPWD, $api_key.':'.$password);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
		curl_setopt(
			$ch,
			CURLOPT_HTTPHEADER,
			array(
				'Accept: application/json'
			)
		);
		//,'Content-Type: application/json'



		$result = curl_exec($ch);;
	}

	function check_for_entries_in_all_dbs($mobile_no, $adhar_search, $year = '')
	{
		///echo "ddfrf";
		//exit;
		$DBU = $this->load->database('umsdb', TRUE);
		$updated_by = $this->session->userdata('uid');

		if (empty($year)) {
			$year =  $this->config->item('admission_year');
		}
		$current_year = explode('-',  $year);
		$current_year = $current_year[0];

		if ($adhar_search != '' && $mobile_no != '') {

			 $sql = "select stud_id as id,1 as admission,created_by  from sandipun_ums.student_master sm where (mobile='$mobile_no' or contact_no  ='$mobile_no' or adhar_card_no='$adhar_search')  and admission_session='$current_year' and sm.cancelled_admission='N' and sm.enrollment_no !='' and sm.enrollment_no IS NOT NULL	
		UNION 
		select sm.stud_id as id,1 as admission,sm.created_by from sandipun_ums_sijoul.student_master as sm where (sm.mobile='$mobile_no'  or sm.contact_no  ='$mobile_no' or sm.adhar_card_no='$adhar_search') and sm.admission_session='$current_year' and sm.cancelled_admission='N' and sm.enrollment_no !='' and sm.enrollment_no IS NOT NULL
        UNION
         
		select sm.enquiry_id as id,0 as admission,sm.created_by from sandipun_ums.enquiry_student_master as sm where ( sm.aadhar_card='$adhar_search' or  citizenship_id='$adhar_search' or mobile='$mobile_no'  ) and sm.academic_year='$current_year' and sm.admission_session='$current_year'    	

        UNION 
		select sm.enquiry_id as id,0 as admission,sm.created_by from sandipun_ums_sijoul.enquiry_student_master as sm where ( sm.aadhar_card='$adhar_search' or mobile='$mobile_no' ) and sm.academic_year='$current_year'  		
		
		UNION 
		select (id) as id,0 as admission,aadhar_car_updation.created_by from 
		sandipun_ic_erp22.aadhar_car_updation 
		where 
		 ( sandipun_ic_erp22.aadhar_car_updation .add_no='$adhar_search')  and sandipun_ic_erp22.aadhar_car_updation.academic_year='$year'  
		 
		UNION
         select (student_id) as id,0 as admission,sandipun_ic_erp22.citizenshipdetails.created_by from 
		sandipun_ic_erp22.citizenshipdetails
		where 
		 ( sandipun_ic_erp22.citizenshipdetails .citizenship_no='$adhar_search')  and sandipun_ic_erp22.citizenshipdetails.academic_year='$year'  
		 UNION 
		select (id) as id,0 as admission,sm.created_by from sandipun_ic_erp22.student_meet_details as sm where 
		 (sm.mobile1 ='$mobile_no' or sm.whatsappno  ='$mobile_no')  and academic_year='$year' 
		 
		";
		
		
		} else if ($adhar_search == '' && $mobile_no != '') {
			$sql = "select stud_id as id,1 as admission,created_by  from sandipun_ums.student_master where (mobile='$mobile_no' or contact_no  ='$mobile_no' )  and admission_session='$current_year' and cancelled_admission='N' and sm.enrollment_no !='' and sm.enrollment_no IS NOT NULL	
		UNION 
		select sm.stud_id as id,1 as admission,sm.created_by from sandipun_ums_sijoul.student_master as sm where (sm.mobile='$mobile_no'  or sm.contact_no  ='$mobile_no' ) and sm.admission_session='$current_year' and cancelled_admission='N' and sm.enrollment_no !='' and sm.enrollment_no IS NOT NULL	
		UNION 
		select (sm.id) as id,0 as admission,sm.created_by from sandipun_ic_erp22.student_meet_details as sm where 
		 (sm.mobile1 ='$mobile_no' or sm.whatsappno  ='$mobile_no')  and academic_year='$year'  
		";
		} else if ($adhar_search != '' && $mobile_no == '') 
		
		{
			$sql = "select stud_id as id,1 as admission,created_by  from student_master sm where ( adhar_card_no='$adhar_search' or citizenship='$adhar_search' )  and admission_session='$current_year' and cancelled_admission='N' and enrollment_no !='' and enrollment_no IS NOT NULL	
		UNION 
		select sm.stud_id as id,1 as admission,sm.created_by from sandipun_ums_sijoul.student_master as sm where ( sm.adhar_card_no='$adhar_search' or citizenship='$adhar_search') and sm.admission_session='$current_year'  and cancelled_admission='N'	 and sm.enrollment_no !='' and sm.enrollment_no IS NOT NULL	
		UNION 
		select sm.enquiry_id as id,0 as admission,sm.created_by from sandipun_ums_sijoul.enquiry_student_master as sm where ( sm.aadhar_card='$adhar_search' ) and sm.academic_year='$current_year'  
		UNION 
		select sm.enquiry_id as id,0 as admission,sm.created_by from sandipun_ums.enquiry_student_master as sm where ( sm.aadhar_card='$adhar_search' or  citizenship_id='$adhar_search') and sm.academic_year='$current_year' and sm.admission_session='$current_year'  
		 UNION 
		select (student_id) as id,0 as admission,sandipun_ic_erp22.aadhar_car_updation.created_by from 
		sandipun_ic_erp22.aadhar_car_updation
		where 
		 ( sandipun_ic_erp22.aadhar_car_updation .add_no='$adhar_search')  and sandipun_ic_erp22.aadhar_car_updation.academic_year='$year' UNION
         select (student_id) as id,0 as admission,sandipun_ic_erp22.citizenshipdetails.created_by from 
		sandipun_ic_erp22.citizenshipdetails
		where 
		 ( sandipun_ic_erp22.citizenshipdetails .citizenship_no='$adhar_search')  and sandipun_ic_erp22.citizenshipdetails.academic_year='$year'";
		 
		 
		 
		}




		$query = $DBU->query($sql);
		//$query = $this->db->get();
		$result = $query->result_array();

		//echo $DBU->last_query();exit;
		return $result;
	}





	public function checkmobileinerpcheckmobileinerp($mobile, $year = '')
	{
		if (empty($year)) {
			$year =  $this->config->item('current_year');
		}
		$current_year = explode('-',  $year);
		$current_year = $current_year[0];
		$DB1 = $this->load->database('umsdb', TRUE);
		$result = $DB1->query("select (stud_id) as id,1 as admission,'Nashik' as admission_center,created_by  from student_master where (mobile='$mobile' or contact_no='$mobile') and enrollment_no !=''  and admission_session='$current_year' and cancelled_admission='N'
UNION 
select (sm.stud_id)  as id,1 as admission,'Sijoul' as admission_center,sm.created_by from sandipun_ums_sijoul.student_master as sm where (sm.mobile='$mobile' or sm.contact_no='$mobile') and sm.enrollment_no !='' and cancelled_admission='N'
and sm.admission_session='$current_year'
UNION 
		select (sm.id) as id,0 as admission,'--' as admission_center,sm.created_by from sandipun_ic_erp22.student_meet_details as sm where 
		 (sm.mobile1 ='$mobile'  or  sm.whatsappno  ='$mobile')  and academic_year='$year'

")->result_array();



		if (!empty($result)) {
			return ($result);
		} else {

			return array();
		}
	}



	public function checkmobileinerpcheckemailinerp($email, $year = '')
	{
		if (empty($year)) {
			$year =  $this->config->item('current_year');
		}


		$current_year = explode('-',  $year);
		$current_year = $current_year[0];
		$DB1 = $this->load->database('umsdb', TRUE);
		$result = $DB1->query("select (stud_id) as id,1 as admission,'Nashik' as admission_center,created_by  from student_master where (email='$email' ) and enrollment_no !=''  and admission_session='$current_year'
		UNION 
		select (sm.stud_id)  as id,1 as admission,'Sijoul' as admission_center,sm.created_by from sandipun_ums_sijoul.student_master as sm where (sm.email='$email') and sm.enrollment_no !='' 
		and sm.admission_session='$current_year'
		UNION 
		select (sm.id) as id,0 as admission,'--' as admission_center,sm.created_by from " . currentdb . ".student_meet_details as sm where 
		 (sm.email ='$email')  and academic_year='$year'
	")->result_array();

		if (!empty($result)) {
			return ($result);
		} else {

			return array();
		}
	}

	public function checkadharnerpcheckemailinerp($email = '', $year = '')
	{

		if (empty($year)) {
			$year =  $this->config->item('current_year');
		}
		$current_year = explode('-',  $year);
		$current_year = $current_year[0];
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB2 = $this->load->database('ums_sijoul', TRUE);

		/*echo "select (stud_id) as id,1 as admission,'Nashik' as admission_center,created_by  from student_master where (adhar_card_no='$email' ) and enrollment_no !=''  and admission_session='$current_year' and  cancelled_admission='N'
UNION 
select (sm.stud_id)  as id,1 as admission,'Sijoul' as admission_center,sm.created_by from sandipun_ums_sijoul.student_master as sm where (sm.adhar_card_no='$email') and sm.enrollment_no !='' 
and sm.admission_session='$current_year' and  sm.cancelled_admission='N'

		 UNION 
		select (sm.id) as id,0 as admission,'--' as admission_center,sm.created_by from 
		".currentdb.".aadhar_car_updation ag  where 
		 (ag.add_no ='$email')  and ag.academic_year='$year'
UNION 		 
select (sm.enquiry_id)  as id,0 as admission,'--' as admission_center,sm.created_by from enquiry_student_master as sm where (sm.aadhar_card='$email') 
and sm.admission_session='$current_year'		 
";
exit;*/
		/*
echo "select (stud_id) as id,1 as admission,'Nashik' as admission_center,created_by  from student_master where (adhar_card_no='$email' ) and enrollment_no !=''  and admission_session='$current_year' and  cancelled_admission='N'
UNION 
select (sm.stud_id)  as id,1 as admission,'Sijoul' as admission_center,sm.created_by from sandipun_ums_sijoul.student_master as sm where (sm.adhar_card_no='$email') and sm.enrollment_no !='' 
and sm.admission_session='$current_year' and  sm.cancelled_admission='N'

		 UNION 
		select (ag.student_id) as id,0 as admission,'--' as admission_center,sm.created_by from 
		".currentdb.".aadhar_car_updation ag  where 
		 (ag.add_no ='$email')  and ag.academic_year='$year'
UNION 		 
select (sm.enquiry_id)  as id,0 as admission,'--' as admission_center,sm.created_by from enquiry_student_master as sm where (sm.aadhar_card='$email') 
and sm.admission_session='$current_year'		 
";
exit;
*/

		$sql = "select (stud_id) as id,1 as admission,'Nashik' as admission_center,created_by  from " . $DB1->database . ".student_master as  student_master where (adhar_card_no='$email' ) and enrollment_no !=''  and admission_session='$current_year' and  cancelled_admission='N'
UNION 
select (sm.stud_id)  as id,1 as admission,'Sijoul' as admission_center,sm.created_by from sandipun_ums_sijoul.student_master as sm where (sm.adhar_card_no='$email') and sm.enrollment_no !='' 
and sm.admission_session='$current_year' and  sm.cancelled_admission='N'

		 UNION 
		select (ag.student_id) as id,0 as admission,'--' as admission_center,created_by from 
		" . currentdb . ".aadhar_car_updation ag  where 
		 (ag.add_no ='$email')  and ag.academic_year='$year'
UNION 		 
select (sm.enquiry_id)  as id,0 as admission,'--' as admission_center,sm.created_by from " . $DB1->database . ".enquiry_student_master as sm where (sm.aadhar_card='$email') 
and sm.admission_session='$current_year'

UNION 		 
select (sm.enquiry_id)  as id,0 as admission,'--' as admission_center,sm.created_by from " . $DB2->database . ".enquiry_student_master as sm where (sm.aadhar_card='$email') 
and sm.admission_session='$current_year'		 
";

		$sql = str_replace("sandipun_ic_erp22.", "", $sql);

		$ICDB = $this->load->database('icdb', TRUE);


		$result = $ICDB->query($sql)->result_array();


		if (!empty($result)) {
			return ($result);
		} else {

			return array();
		}
	}



	public function checkadharinerpcheckemailinerp_update($email)
	{

		$year =  $this->config->item('current_year');
		$current_year = explode('-',  $year);
		$current_year = $current_year[0];
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB2 = $this->load->database('ums_sijoul', TRUE);

		$updated_by = $this->session->userdata('uid');


		$sql = "select (stud_id) as id,1 as admission,'Nashik' as admission_center,created_by  from " . $DB1->database . ".student_master as  student_master where (adhar_card_no='$email' ) and enrollment_no !=''  and admission_session='$current_year' and  cancelled_admission='N'
UNION 
select (sm.stud_id)  as id,1 as admission,'Sijoul' as admission_center,sm.created_by from sandipun_ums_sijoul.student_master as sm where (sm.adhar_card_no='$email') and sm.enrollment_no !='' 
and sm.admission_session='$current_year' and  sm.cancelled_admission='N'

		 UNION 
		select (ag.student_id) as id,0 as admission,'--' as admission_center,created_by from 
		" . currentdb . ".aadhar_car_updation ag  where 
		 (ag.add_no ='$email')  and ag.academic_year='$year' and ag.created_by !='$updated_by'
UNION 		 
select (sm.enquiry_id)  as id,0 as admission,'--' as admission_center,sm.created_by from " . $DB1->database . ".enquiry_student_master as sm where (sm.aadhar_card='$email') 
and sm.admission_session='$current_year'

UNION 		 
select (sm.enquiry_id)  as id,0 as admission,'--' as admission_center,sm.created_by from " . $DB2->database . ".enquiry_student_master as sm where (sm.aadhar_card='$email') 
and sm.admission_session='$current_year'		 
";

		$sql = str_replace("sandipun_ic_erp22.", "", $sql);


		$ICDB = $this->load->database('icdb', TRUE);

		$result = $ICDB->query($sql)->result_array();


		if (!empty($result)) {
			return ($result);
		} else {

			return array();
		}
	}



/*************************///////////Hk///////////************************ */

	function checkcitizenshipid($citizen_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$ICDB = $this->load->database('icdb', TRUE);
		$year = ACYEAR;
		$DB1->select('created_by,enquiry_id');
		$DB1->from('enquiry_student_master');
		$DB1->where('citizenship_id', $citizen_id);
		$DB1->where('academic_year', $year);
		$query = $DB1->get();
		$result = $query->result_array();
		if (!empty($result)) {
			return ($result);
		} else {
			$ICDB->select('created_by,id');
			$ICDB->from('citizenshipdetails');
			$ICDB->where('citizenship_no', $citizen_id);
			$ICDB->where('academic_year', ACADEMIC_YEAR);
			$query = $ICDB->get();
			$result = $query->result_array();
			if (!empty($result)) {
				return ($result);
			} else {
				return array();
			}
		}
	}
	
	public function Get_CampusType($Campus, $Campus_City, $year = '')
	{

				if(empty($year)){
				$year=$this->config->item('cyear');
				}
				else{
				$year = explode('-',  $year);
				$year =$year[0];
				}
		//$icreaddb = $this->load->database('icreaddb', TRUE);
		if ($Campus_City == 1) {
			$Campus_s = "Nashik";
		} else {
			$Campus_s = "sijoul";
		}
		// $sql="select * From school_course  WHERE  Campus='$Campus'  AND status='Yes' AND campus_city='$Campus_City' GROUP By school_name";

		if ($Campus == "SUN") { // echo $year;exit;
			// $sql="select * From sandipun_ums.common_vw_stream_details  WHERE  Campus='$Campus_s'  AND is_active='Y' AND active_for_year='$year' GROUP By school_name";
			$sql = "select * From sandipun_ums.common_vw_stream_details  WHERE  Campus='$Campus_s'  AND is_active='Y' AND active_for_year='$year' GROUP By school_name";

			 //echo $sql; 
              //  die(); 
			//	echo $sql;exit;
		} else {

			if ($Campus == "SF") {
				$year = $this->config->item('cyear');
			}

			// $sql="select * From `sandipun_ic_erp22`.`vw_stream_details`  WHERE  Campus='$Campus_s' 
			// AND is_active='Y' AND active_for_year='$year' GROUP By school_name";	
			$sql = "select * From `sandipun_ic_erp22`.`vw_stream_details`  WHERE  Campus='$Campus_s' 
		AND is_active='Y' AND active_for_year='2025' GROUP By school_name";
		}
		$ICDB = $this->load->database('icdb', TRUE);

		$query = $ICDB->query($sql);
		//}
		//else{
		//  $sql="select * From admission_Counsellor_details Where  Campus='$Campus'";
		/* echo $sql;
                die(); */
		// $query = $this->db->query($sql);
		//}
		return $query->result_array();
	}

	/**************************************************************** */


	function Get_CoursesType($school_name, $Campus, $Campus_City, $Qualification, $year = '')
	{
		if ($Campus_City == 1) {
			$Campus_s = "Nashik";
		} else {
			$Campus_s = "sijoul";
		}
		if ($Campus == "SUN") {
			$query = $this->db->query("SELECT course_type FROM sandipun_ums.common_vw_stream_details WHERE  school_id='$school_name' AND campus='$Campus_s' AND 
	 is_active='Y' AND FIND_IN_SET('" . $Qualification . "',minimum_qk_required)  Group by course_type"); //AND campus_city='$Campus_City'
		} else {
			$query = $this->db->query("SELECT course_type FROM `sandipun_ic_erp22`.`vw_stream_details` WHERE  school_id='$school_name' AND campus='$Campus_s' AND 
	 is_active='Y' AND FIND_IN_SET('" . $Qualification . "',minimum_qk_required)  Group by course_type"); //AND campus_city='$Campus_City'
		}
		$query = $query->result_array();
		echo  $this->db->last_query();
		//exit;

		return $query;
	}



	function Get_Courses($CoursesType, $school_name, $Campus, $Campus_City, $cyear = '')
	{
		if (empty($cyear)) {
			$cyear = $this->config->item('cyear');
		} else {
			$cyear = explode('-',  $cyear);
			$cyear = $cyear[0];
		}
		//$icreaddb = $this->load->database('icreaddb', TRUE);
		/* $query =$this->db->query("SELECT * FROM school_course WHERE course_type='$CoursesType' AND school_id='$school_name' AND
	  campus='$Campus' AND status='Yes' AND campus_city='$Campus_City'");*/
		if ($Campus_City == 1) {
			$Campus_s = "Nashik";
		} else {
			$Campus_s = "sijoul";
		}
		if ($Campus == "SUN") {
			// 	$query = $this->db->query("SELECT * FROM sandipun_ums.common_vw_stream_details WHERE course_type='$CoursesType' AND school_id='$school_name' AND
			//   campus='$Campus_s' AND is_active='Y' And active_for_year='$cyear'  group by course_short_name");
			$query = $this->db->query("SELECT * FROM sandipun_ums.common_vw_stream_details WHERE course_type='$CoursesType' AND school_id='$school_name' AND
	  campus='$Campus_s' AND is_active='Y' And active_for_year='$cyear'  group by course_short_name");
		} else {
			if ($Campus == "SF") {
				$cyear = $this->config->item('admission_year');
			}

			// 	$query = $this->db->query("SELECT * FROM `sandipun_ic_erp22`.`vw_stream_details` WHERE course_type='$CoursesType' AND school_id='$school_name' AND
			//   campus='$Campus_s' AND is_active='Y' And active_for_year='$cyear' group by course_short_name");
			$query = $this->db->query("SELECT * FROM `sandipun_ic_erp22`.`vw_stream_details` WHERE course_type='$CoursesType' AND school_id='$school_name' AND
	  campus='$Campus_s' AND is_active='Y' And active_for_year='$cyear' group by course_short_name");
		}

		$query = $query->result_array();
		echo  $this->db->last_query();
		//exit;
		return $query;
	}



	function Get_stream($CoursesType, $school_name, $Campus, $Campus_City, $Courses, $cyear)
	{
		if (empty($cyear)) {
			$cyear = $this->config->item('cyear');
		} else {
			$cyear = explode('-',  $cyear);
			$cyear = $cyear[0];
		}
		if ($Campus_City == 1) {
			$Campus_s = "Nashik";
		} else {
			$Campus_s = "sijoul";
		}
		if ($Campus == "SUN") {
			// 	$query = $this->db->query("SELECT * FROM sandipun_ums.common_vw_stream_details WHERE course_type='$CoursesType' AND school_id='$school_name' AND
			//   campus='$Campus_s' AND is_active='Y' and course_id='$Courses' And active_for_year='$cyear' group by stream_id");
			$query = $this->db->query("SELECT * FROM sandipun_ums.common_vw_stream_details WHERE course_type='$CoursesType' AND school_id='$school_name' AND
	  campus='$Campus_s' AND is_active='Y' and course_id='$Courses' And active_for_year='$cyear' group by stream_id");
		} else {
			if ($Campus == "SF") {
				$cyear = $this->config->item('admission_year');
			}
       
			// 	$query = $this->db->query("SELECT * FROM `sandipun_ic_erp22`.`vw_stream_details` WHERE course_type='$CoursesType' AND school_id='$school_name' AND
			//   campus='$Campus_s' AND is_active='Y' and course_id='$Courses' And active_for_year='$cyear' group by stream_id");
			$query = $this->db->query("SELECT * FROM `sandipun_ic_erp22`.`vw_stream_details` WHERE course_type='$CoursesType' AND school_id='$school_name' AND
	  campus='$Campus_s' AND is_active='Y' and course_id='$Courses' And active_for_year='$cyear' group by stream_id");
		}
		// echo $this->db->last_query();
		// echo $this->db->last_query();
		//exit;
		$query = $query->result_array();

		return $query;
	}
	
		
	
	
	
	/**************************************************************** */

	////////////////////////////////////////////////////////////////
}
