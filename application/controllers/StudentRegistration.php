<?php
//ini_set("display_errors", "On");
//error_reporting(1);
class StudentRegistration extends CI_Controller
{
	public function __construct()
	{
		global $menudata;
		parent::__construct();
		$this->load->helper("url");
		$this->load->library('form_validation');
		$menu_name = $this->uri->segment(1);
		$this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
		date_default_timezone_set("Asia/Kolkata");
		if (empty($this->session->userdata('uid'))) {
			$this->session->set_flashdata('flash_data', 'Invalid Username / E-mail OR Incorrect Password ');
			redirect('login');
		}
		$this->load->model('Enquiry_model1');
		$this->load->model('Comman_function_model');
		$this->load->model('Students_model');
		$this->load->model('Prospectus_fee_details_model');
	}

	//ValidFunction
	public function New_Enquiry()
	{
		$csid = '';
		$mobile = '';
		$mobile = $_REQUEST['mobile'];
		$csid = $_REQUEST['csid'];
		$year = '';
		// $year = $_REQUEST['year']; print_r($year);exit;
		$year = ADMISSION_SESSION_YEAR;

		$enquiry_id = $this->uri->segment(3);
		$enquiry_no = $this->uri->segment(4);
		$enquiry_mobile = $this->uri->segment(5);
		$this->load->view('header', $this->data);
		if ($enquiry_no != '') {
			$this->data['enquiryparamer'] = $enquiry_no;
			$this->data['enquiryid'] = $enquiry_id;
		}

		if (empty($year)) {
			$year = $this->config->item('admission_year');
		}
		$this->data['year'] = $year;
		$this->data['mobile_from'] = $mobile;
		$this->data['counsellorid'] = $csid;
		$this->data['states'] = $this->Enquiry_model1->fetch_states(101);
		$this->data['check_id_in_ic'] = $this->Enquiry_model1->check_id_in_ic();
		$this->data['countries_list'] = $this->Enquiry_model1->get_all_countries();
		$this->load->view('Enquiry1/prospectus_details', $this->data);
		$this->load->view('footer');
	}


	////new added by hk//////////////

	function Get_CampusType()
	{
		$Campus = $_REQUEST['Campus'];

		$Campus_City = $_REQUEST['Campus_City'];
		$school = $_REQUEST['school'];
		$year = $_REQUEST['year'];
		//$Qualification = $_REQUEST['Qualification'];
		// $school_name = $_REQUEST['school_name'];
		$city_details = $this->Enquiry_model1->Get_CampusType($Campus, $Campus_City, $year);

		echo  $city = "<select name='CoursesType' id='CoursesType' class='form-control'>";?>
		<option value="">Select <?php if ($Campus == 'SF') {
									echo "Institute";
								} else {
									echo "School";
								}
								?>
		</option>
		<?php
		$sall = '';
		foreach ($city_details as $cityy) {
			if (isset($school)) {
				if ($cityy['school_id'] == $school) {
					$sal = 'selected="selected"';
				} else {
					$sal = '';
				}
			}
			echo '<option value="' . $cityy['school_id'] . '"' . $sal . '>' . $cityy['school_name'] . '</option>';
		}
		echo '</select>';
	}

	/****************************************/
	//ValidFunction
	function Get_CoursesType()
	{
		echo
		$session = $this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid = $session['uid'];
		$name = $session['name'];
		$campusid = $session['campusid'];

		$school_name = $_REQUEST['school_name'];
		$Campus_City = $_REQUEST['Campus_City'];
		$Campus = $_REQUEST['Campus'];
		$CoursesType = $_REQUEST['CoursesType'];
		$Qualification = $_REQUEST['Qualification'];
		$year = $_REQUEST['year'];
		$city_details = $this->Enquiry_model1->Get_CoursesType($school_name, $Campus, $Campus_City, $Qualification, $year);
		// print_r($city_details);
		echo  $city = '<select name="CoursesType" id="CoursesType" class="form-control">';
		?>
		<option value="" data-icon="glyphicon glyphicon-eye-open" data-subtext="petrification">Select</option>
		<?php
		foreach ($city_details as $city) {

			if (isset($CoursesType)) {
				if ($city['course_type'] == $CoursesType) {
					$sal = 'selected="selected"';
				} else {
					$sal = '';
				}
			}
			echo '<option value="' . $city['course_type'] . '"' . $sal . '>' . $city['course_type'] . '</option>';
		}
		echo '</select>';
	}
	//ValidFunction
	function Get_Courses()
	{
		$session = $this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid = $session['uid'];
		$name = $session['name'];
		$campusid = $session['campusid'];
		$Campus_City = $_REQUEST['Campus_City'];
		$school_name = $_REQUEST['school_name'];
		$Campus = $_REQUEST['Campus'];
		$CoursesType = $_REQUEST['CoursesType'];
		$year = $_REQUEST['year'];
		$currentcourse = $_REQUEST['currentcourse'];
		$course_id = $_REQUEST['course_id'];

		$city_details = $this->Enquiry_model1->Get_Courses($CoursesType, $school_name, $Campus, $Campus_City, $year);
		// print_r($city_details);
		echo  $city = '<select name="courses" id="courses" class="form-control">';
		?>
		<option value="" data-icon="glyphicon glyphicon-eye-open" data-subtext="petrification">Select</option>
		<?php
		foreach ($city_details as $city) {

			if (isset($course_id)) {
				if ($city['course_id'] == $course_id) {
					$sal = 'selected="selected"';
				} else {
					$sal = '';
				}
			}
			echo '<option value="' . $city['course_id'] . '"' . $sal . '>' . $city['course_short_name'] . '</option>';
		}
		echo '</select>';
	}
//ValidFunction
	function Get_stream()
	{
		$session = $this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid = $session['uid'];
		$name = $session['name'];
		$campusid = $session['campusid'];
		$Campus_City = $_REQUEST['Campus_City'];
		$school_name = $_REQUEST['school_name'];
		$Campus = $_REQUEST['Campus'];
		$CoursesType = $_REQUEST['CoursesType'];
		$year = $_REQUEST['year'];
		$currentcourse = $_REQUEST['currentcourse'];
		$stream_id = $_REQUEST['stream_id'];
		$Courses = $_REQUEST['Courses'];
		$city_details = $this->Enquiry_model1->Get_stream($CoursesType, $school_name, $Campus, $Campus_City, $Courses, $year);
	
		echo  $city = '<select name="stream_id" id="stream_id" class="form-control">';
		?>
		<option value="" data-icon="glyphicon glyphicon-eye-open" data-subtext="petrification">Select</option>
<?php
		foreach ($city_details as $city) {

			if (isset($stream_id)) {
				if ($city['stream_id'] == $stream_id) {
					$sal = 'selected="selected"';
				} else {
					$sal = '';
				}
			}
			echo '<option value="' . $city['stream_id'] . '"' . $sal . '>' . $city['stream_name'] . '</option>';
		}
		echo '</select>';
	}
	/****************************************/

	public function Enquiry_list($date_par = '', $type_param = '')
	{
		$this->load->view('header', $this->data);
		if ($date_par != '' && $date_par != 0) {
			$this->data['date'] = date("Y-m-d");
		}
		if ($type_param != '') {
			$this->data['type_param'] = $type_param;
		}
		//	$this->data['Enquiry_list'] =$this->Enquiry_model1->Enquiry_list();
		$this->load->view('StudentRegistration/Enquiry_list', $this->data);
		$this->load->view('footer');
	}
//ValidFunction
	public function ajax_list()
	{
		$date = $_POST['date'];
		$type_param = $_POST['type_param'];
		$list = $this->Enquiry_model1->get_datatables($date, $type_param);
		//print_r($list);exit();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '<a href="' . base_url() . 'StudentRegistration/New_Enquiry/' . $customers->enquiry_id . '/' . $customers->enquiry_no . '">' . $customers->enquiry_no . '</a>';
			$row[] = $customers->provisional_no;
			$row[] = $customers->first_name . ' ' . $customers->middle_name . ' ' . $customers->last_name;
			$row[] = $customers->mobile;
			$row[] = $customers->altarnet_mobile;
			/*$row[] = $customers->email_id;*/
			$row[] = $customers->vstream_name;
			$row[] = $customers->form_taken;
			$row[] = $customers->scholarship_allowed;
			$row[] = $customers->scholarship_status;


			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Enquiry_model1->count_all(),
			"recordsFiltered" => $this->Enquiry_model1->count_filtered($date, $type_param),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

//ValidFunction
	public function Enquiry_insert()
	{
		// print_r($_POST);exit;
		$status = $this->Enquiry_model1->Enquiry_insert_for_consultant($_POST);
		//redirect("Enquiry1/New_Enquiry/".$status);////
		$this->session->set_flashdata('message1', 'Your details are saved successfully');
		$url = base_url("StudentRegistration/New_Enquiry/") . "/" . $status . "/" . $_POST['acyear'];
		$year = $_POST['acyear'];
		$url = base_url("StudentRegistration/Student_list_added_by_student");
		echo '<script>window.location.href = "' . $url . '";</script>';
	}

/***************************************************************************************/

public function Student_list_added_by_student($id="") {
       
	 $this->load->model('college_model');
	 
	 $this->data['academic_year']=$this->Comman_function_model->get_academic_year();
	 $userID = $this->session->userdata('uid');
	 $role_id = $this->session->userdata('role_id');
	$this->data['current_academic_year']= $this->data['year']=$year=base64_encode($this->config->item('current_year'));
	$checkIdInIc = $this->Enquiry_model1->check_id_in_ic();
	// print_r($checkIdInIc);exit;
	
	 if($id !=""){
		 
		 $this->data['smd'] = $this->Students_model->fetch_student_meetdetails_staff($id,$checkIdInIc);
	 }
	 else{
		
	 $this->data['smd'] = $this->Students_model->fetch_student_meetdetails_staff($id = null,$checkIdInIc);
	 }

	  $this->data['id'] =$id;
	 //$total = $this->students_model->fetch_cnt_student_meetdetails($_POST);
	 $this->data['fdata']=$_POST;
	 $this->load->view('header', $this->data);
	 $this->load->view('Enquiry1/view_by_student', $this->data);
	 $this->load->view('footer');
 
 }

/***************************************************************************************/

	public function Updated()
	{
		//print_r($_POST);exit;
		$this->session->set_flashdata('message1', 'Your details are updated successfully');
		$status = $this->Enquiry_model1->Enquiry_Updated_consultant($_POST);
		//redirect("StudentRegistration/New_Enquiry/".$status);
		//$url=base_url("StudentRegistration/New_Enquiry/")."/".$status;
		$c = "";
		if (!empty($_POST['acyear'])) {
			$c = "/" . $_POST['acyear'];
		}

		$url = base_url("StudentRegistration/Student_list_added_by_student$c");
		echo '<script>window.location.href = "' . $url . '";</script>';
	}

	// check duplicate mobile no exist
	public function Serach_details()
	{
		$mobile_no = trim($_REQUEST['mobile_no']);
		$Enquiry_search = trim($_REQUEST['Enquiry_search']);
		$adhar_search = trim($_REQUEST['adhar_search']);
		$year = trim($_REQUEST['year']);
		$year = explode('-',  $year);
		$year = $year[0];

		$mob = $this->Enquiry_model1->chek_mob_exist($mobile_no, $Enquiry_search, $adhar_search, $year);
		//$this->data['ic']  = $this->Sujee_model->get_ic_name();
		//print_r($mob);exit;
		$cnt_mob   = count($mob);
		//echo $mob[0]['sujee_apperaed'];
		if ($cnt_mob > 0) {

			echo json_encode($mob);
		} else {
			echo "no";
		}
	}

	public function getStatewiseDistrict()
	{
		$state = $_REQUEST['state_id'];
		$stt = $_REQUEST['stt'];
		//echo $state;
		$dist = $this->Enquiry_model1->getStatewiseDistrict($state);
		//print_r($dist);exit;
		if (!empty($dist)) {
			echo "<option value=''>Select District</option>";
			foreach ($dist as $key => $val) {
				if ($dist[$key]['district_id'] == $stt) {
					$sel = 'selected';
				} else {
					$sel = '';
				}
				echo "<option value='" . $dist[$key]['district_id'] . "' $sel>" . $dist[$key]['district_name'] . "</option>";
			}
		}
	}

	public function getStateDwiseCity()
	{
		$state_id = $_REQUEST['state_id'];
		$dist_id = $_REQUEST['district_id'];
		$stt = $_REQUEST['stt'];
		//echo $state;
		$city = $this->Enquiry_model1->getStateDwiseCity($state_id, $dist_id);
		//print_r($city);exit;
		if (!empty($city)) {
			echo "<option value=''>Select City</option>";
			foreach ($city as $key => $val) {
				if ($city[$key]['taluka_id'] == $stt) {
					$sel = 'selected';
				} else {
					$sel = '';
				}

				echo "<option value='" . $city[$key]['taluka_id'] . "' $sel>" . $city[$key]['taluka_name'] . "</option>";
			}
		}
	}

	function fetch_school()
	{
		$data = $this->Enquiry_model1->list_schools_data($_POST['val'], $_POST['schoola']);
		$schoola = $_POST['schoola'];
		$str = ' <option value="">Select School</option>';
		if (!empty($data)) {
			foreach ($data as $schools) {
				if ($schools['school_id'] == $schoola) {
					$sel = 'selected';
				} else {
					$sel = '';
				}
				$str .= '<option value="' . $schools['school_id'] . '"' . $sel . '>' . $schools['school_name'] . '</option>';
			}
			echo $str;
		}
	}

	public function load_courses()
	{
		// global $model;	
		$schoola = $_POST['schoola'];
		$course_details =  $this->Enquiry_model1->getschool_course($_POST['school'], $_POST['highest_qualification'], $_POST['Campus']);
		$opt = '<option value="">Select Course</option>';
		foreach ($course_details as $course) {
			if ($course['course_id'] == $schoola) {
				$sel = 'selected';
			} else {
				$sel = '';
			}
			$opt .= '<option value="' . $course['course_id'] . '" ' . $sel . '>' . $course['course_short_name'] . '</option>';
		}
		echo $opt;
	}

	public function get_course_streams_yearwise()
	{
		$this->data['campus_details'] = $this->Enquiry_model1->get_course_streams_yearwise($_POST);
	}

	public function fetch_academic_fees_for_stream_year()
	{

		$strm_id = $_REQUEST['strm_id'];
		$acyear = $_REQUEST['acyear'];
		$year = $_REQUEST['admission_type'];
		$fess = $this->Enquiry_model1->fetch_academic_fees_for_stream_year($strm_id, $acyear, $year);

		echo json_encode($fess);
	}


	public function From()
	{
		$id = $this->uri->segment(3);

		$this->load->view('header', $this->data);
		$this->load->view('Enquiry1/Enquiry_from', $this->data);
		$this->load->view('footer');
	}
	////////////////////////////////////////////////////////////////////////////////////


	// check mobile exist
	public function chek_dupmobno_exist()
	{

		$mobile_no = $_REQUEST['mobile_no'];

		//echo $state;
		$mob = $this->Enquiry_model1->chek_mob_exist($mobile_no);
		$cnt_mob = count($mob);
		if ($cnt_mob > 0) {
			echo "Duplicate~" . json_encode($mob);
		} else {
			echo "regular~1";
		}
	}
	// check duplicate form no exist
	public function chek_formno_exist()
	{

		$formno = $_REQUEST['newforno'];
		//echo $state;
		$mob = $this->Enquiry_model1->chek_formno_exist($formno);
		$cnt_mob = count($mob);
		if ($cnt_mob > 0) {
			echo "Duplicate~" . json_encode($mob);
		} else {
			echo "regular~1";
		}
	}
	// check duplicate form no approve status exist
	public function chek_formno_exist_withapprove()
	{

		$formno = $_REQUEST['newforno'];

		//echo $state;
		$mob = $this->Enquiry_model1->chek_formno_exist_withapprove($formno);
		//print_r($mob);
		//exit();
		$cnt_mob = count($mob);
		if ($cnt_mob > 0) {
			echo "regular~1" . json_encode($mob);
		} else {
			echo "duplicate";
		}
	}

	public function pay_money()
	{
		$id = $this->uri->segment(4); 
		$this->data['enquery_no'] = $id;
		$this->load->view('header', $this->data);
		// $this->data['facility_details']=$this->Enquiry_model1->get_facility_types();
		$this->data['depositedto_details'] = $this->Enquiry_model1->get_depositedto();
		//$this->data['academic_details']=$this->Enquiry_model1->get_academic_details();
		$this->data['bank_details'] = $this->Enquiry_model1->getbanks();
		$this->load->view('Enquiry1/add_fees_challan_details_new', $this->data);
		$this->load->view('footer');
	}

	public function students_data()
	{
		$std_details = $this->Enquiry_model1->students_data($_POST);
		//var_dump($std_details);
		echo json_encode(array("std_details" => $std_details));
	}

	public function get_fee_details_new()
	{
		//    error_reporting(E_ALL);
		//ini_set('display_errors', 1);

		$academic = $_REQUEST['academic'];
		$facility = $_REQUEST['facility'];
		$enroll = $_REQUEST['enroll'];
		$stud = $_REQUEST['stud'];
		$curr_yr = $_REQUEST['curr_yr'];
		$admission_session = $_REQUEST['admission_session'];
		$stream_id = $_REQUEST['stream_id'];

		//$check_current=$this->Challan_model->check_current($_POST);
		//if($check_current[0]['Total']==0){
		$fee_details = $this->Enquiry_model1->get_fee_details($_POST);
		//exit();
		//}else{
		$fee_details_new = $this->Enquiry_model1->fee_details($_POST);
		if (empty($fee_details_new)) {
			$details_new = array('fees_id' => '');
		} else {
			$details_new = $fee_details_new;
		}
		//}
		//exit;

		//exit;
		//$fee_details = $this->Challan_model->get_fee_details($_POST);
		//$fee=array_push($fee_details,$fee_details_new);
		$artists = array();
		array_push($artists, $fee_details, $details_new);
		//print_r($artists);
		//print_r($artists);
		//exit;

		echo json_encode($artists);
	}
	//////////////////////////////////////////////////////////////////////////////////	

	public function Checkaadhar()
	{
		$stateID = $this->input->post('stateID');
		$mobile = $this->input->post('mobile');
		$year = $this->input->post('year');
		$fee_details_new = $this->Enquiry_model1->Checkaadhar($stateID, $mobile, $year);
		echo json_encode($fee_details_new);
	}

	public function check_is_exists_in_main_erp()
	{
		$aadhar = $this->input->post('aadhar');
		$year = $this->input->post('year');
		//$mobile=$this->input->post('mobile');
		echo $fee_details_new = $this->Enquiry_model1->check_is_exists_in_main_erp($aadhar, $year);
	}

	public function checkmobileinerpcheckmobileinerp()
	{
		$mobile = $this->input->post('mobile');
		$year = $this->input->post('year');
		$fee_details_new = $this->Enquiry_model1->checkmobileinerpcheckmobileinerp($mobile, $year);
		echo json_encode($fee_details_new);
	}

	public function checkmobileinerpcheckemailinerp()
	{
		$email = $this->input->post('email');
		$year = $this->input->post('year');
		//$mobile=$this->input->post('mobile');
		$fee_details_new = $this->Enquiry_model1->checkmobileinerpcheckemailinerp($email, $year);
		echo json_encode($fee_details_new);
	}

	public function checkadharinerpcheckemailinerp()
	{
		$adhar_no = $this->input->post('adhar_no');
		$year = $this->input->post('year');
		$fee_details_new = $this->Enquiry_model1->checkadharnerpcheckemailinerp($adhar_no, $year);
		echo json_encode($fee_details_new);
	}

	public function checkadharinerpcheckemailinerp_update()
	{
		$adhar_no = $this->input->post('adhar_no');

		$fee_details_new = $this->Enquiry_model1->checkadharinerpcheckemailinerp_update($adhar_no);
		echo json_encode($fee_details_new);
	}

	public function check_for_entries_in_all_dbs()
	{

		$mobile_no = trim($_REQUEST['mobile_no']);
		$Enquiry_search = trim($_REQUEST['Enquiry_search']);
		$adhar_search = trim($_REQUEST['adhar_search']);
		$year = trim($_REQUEST['year']);
		if ($mobile_no != '' || $adhar_search != '') {
			$mob = $this->Enquiry_model1->check_for_entries_in_all_dbs($mobile_no, $adhar_search, $year);
		}
		$cnt_mob   = count($mob);
		if ($cnt_mob > 0) {

			echo json_encode($mob);
		} else {
			echo "no";
		}
		
		
		
	}

	public function add_fees_challan_submit()
	{
		//print_r($_POST);

		$data = $this->Enquiry_model1->check_fees_challan_submit($_POST);
		////////////////////////////////////////////////////////////////////////////////////////
		//print_r($data);

	}

	public function download_admission_form($stud_id = '')
	{
		$id = $this->uri->segment(3);
		$this->data['Enquiry_data'] = $this->Enquiry_model1->enquiry_by_id($id);
		/*$this->data['per'] = $this->Home_model->fetch_pd($stud_id);
		$this->data['qua'] = $this->Home_model->fetch_qualification_list($stud_id);
		$this->data['qualfg'] = $this->Home_model->fetch_qualification($stud_id);
		$this->data['course'] = $this->Home_model->fetch_course_list($stud_id);
		$this->data['pay'] = $this->Home_model->fetch_payment_for_verification($stud_id);
		$this->data['photo'] = $this->Home_model->fetch_profile_photo($stud_id);*/
		$this->load->view('Enquiry1/print_admission_form_view1', $this->data);
		// $this->load->view('Enquiry/pdf_generate', $this->data);
		// $this->load->view('Enquiry/pdf_generate', $this->data);
	}

	public function testing() {}

	public function checkcitizenshipid()
	{
		$citizen_id = $this->input->post('citizen_id');
		//$mobile=$this->input->post('mobile');
		$citizen_data = $this->Enquiry_model1->checkcitizenshipid($citizen_id);
		echo json_encode($citizen_data);
	}
	/*************************************************** */
	function fetch_course_details() {
		 
		$select_course=$_REQUEST['select_course'];
	   if (isset($_POST["coursetype"]) && !empty($_POST["coursetype"])) {
		   //Get all city data
		   $course = $this->Prospectus_fee_details_model->get_course_details($_POST["coursetype"]);

		   //Count total number of rows
		   $rowCount = count($course);
		 
		   //Display course list
		   if ($rowCount > 0) {
			   echo '<option value="">Select Course</option>';
			   foreach ($course as $value) {
				   if($select_course==$value['course_id']){ $sel='selected="selected"';}else{$sel='';}
				   echo '<option value="' . $value['course_id'] . '"'.$sel.'>' . $value['course'] . '</option>';
			   }
		   } else {
			   echo '<option value="">Course not available</option>';
		   }
	   }
	   echo '<script>
	   $("#coursen").select2
	   ({
			 placeholder: "Select ",
			 allowClear: true
	   });</script>';
   }
   //
}
?>