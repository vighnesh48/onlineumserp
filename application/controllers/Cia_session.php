<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Cia_session extends CI_Controller
{

	var $currentModule = "";
	var $title = "";
	var $table_name = "unittest_master";
	var $model_name = "Cia_marks_model";
	var $model;
	var $view_dir = 'Cia_exam_session/';

	public function __construct()
	{

		//error_reporting(E_ALL); ini_set('display_errors', 1);
		global $menudata;
		parent::__construct();
		$this->load->helper("url");
		$this->load->library('form_validation');
		$this->load->library('excel');
		if ($this->uri->segment(2) != "" && $this->uri->segment(2) != "submit" && !in_array($this->uri->segment(2), $this->skipActions))
			$title = $this->uri->segment(2); //Second segment of uri for action,In case of edit,view,add etc.       
		else
			$title = $this->master_arr['index'];
		$this->currentModule = $this->uri->segment(1);
		$this->data['currentModule'] = $this->currentModule;
		$this->data['model_name'] = $this->model_name;
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$model = $this->load->model($this->model_name);
		$menu_name = $this->uri->segment(1);

		$this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
		$this->load->model('Cia_marks_model');
		if (
			($this->session->userdata("role_id") == 15) || ($this->session->userdata("role_id") == 3) || ($this->session->userdata("role_id") == 21) || ($this->session->userdata("role_id") == 13)
			|| ($this->session->userdata("role_id") == 14) || ($this->session->userdata("role_id") == 20) || ($this->session->userdata("role_id") == 44) || ($this->session->userdata("role_id") == 10) || ($this->session->userdata("role_id") == 37)

			|| ($this->session->userdata("role_id") == 26) || ($this->session->userdata("role_id") == 36)
		) {


		} else {
			redirect('home');
		}
	}



	public function index($subje_id = '')
	{
		global $model;
		$this->load->view('header', $this->data);
		$emp_id = $this->session->userdata("name");
		$this->load->model('Attendance_model');
		$this->data['sb'] = $this->Unittest_model->getFacultySubjects($emp_id);
		if (!empty($_POST)) {
			$subje_id = $_POST['subject'];
			$subjectdetails = explode('-', $subje_id);
			$this->data['sub_Code'] = $_POST['subject'];
		} else {
			$subjectdetails = explode('-', base64_decode($subje_id));
			$this->data['sub_Code'] = base64_decode($subje_id);
		}

		if (!empty($subjectdetails[0])) {
			$subject_id = $subjectdetails[0];
			$division = $subjectdetails[2];
			$semester = $subjectdetails[4];
			$academic_year = ACADEMIC_YEAR;
			$batch_code = $subjectdetails[1] . '-' . $subjectdetails[2] . '-' . $subjectdetails[3];
			$this->data['unittest'] = $this->Unittest_model->get_unittest_bySubject($subject_id, $semester, $batch_code, $division, $academic_year);
			$i = 0;
			foreach ($this->data['unittest'] as $ut) {
				$ut_id = $ut['unit_test_id'];
				$this->data['unittest'][$i]['td'] = $this->Unittest_model->get_numrows_testdetails($ut_id);
				$i++;
			}
		}
		$this->load->view($this->view_dir . 'view', $this->data);
		$this->load->view('footer');

	}

	public function add()
	{
		//error_reporting(E_ALL);exit();
		$this->load->model('Exam_timetable_model');
		if ($_POST) {
			//  echo "<pre>";
			// print_r($_POST);//exit;
			$this->load->view('header', $this->data);
			$this->data['school_code'] = $_POST['school_code'];
			$this->data['admissioncourse'] = $_POST['admission-course'];
			$this->data['stream'] = $_POST['admission-branch'];
			$this->data['semester'] = $_POST['semester'];
			$this->data['exam'] = $_POST['exam_session'];
			$this->data['marks_type'] = $_POST['marks_type'];
			$this->data['reval'] = $_POST['reval'];
			$this->data['exam_session'] = $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
			$this->data['course_details'] = $this->Exam_timetable_model->getCollegeCourse();
			$this->data['schools'] = $this->Exam_timetable_model->getSchools();
			$exam = explode('-', $_POST['exam_session']);
			$exam_month = $exam[0];
			$exam_year = $exam[1];
			$exam_id = $exam[2];
			if ($_POST['marks_type'] == 'TH') {
				$this->data['sub_list'] = $this->Cia_marks_model->list_exam_subjects($_POST, $exam_id);
				for ($i = 0; $i < count($this->data['sub_list']); $i++) {
					$subjectId = $this->data['sub_list'][$i]['sub_id'];
					$this->data['sub_list'][$i]['mrk'] = $this->Cia_marks_model->getMarksEntry($subjectId, $exam_id, $_POST['marks_type'], $_POST['admission-branch'], $_POST['semester'], $_POST['reval']);
				}
			} else {
				$this->data['sub_list'] = $this->Cia_marks_model->list_exam_pr_subjects($_POST, $exam_id);
				for ($i = 0; $i < count($this->data['sub_list']); $i++) {
					$subjectId = $this->data['sub_list'][$i]['sub_id'];
					$this->data['sub_list'][$i]['mrk'] = $this->Cia_marks_model->getPr_MarksEntry($subjectId, $exam_id, $_POST['marks_type'], $_POST['admission-branch'], $_POST['semester'], $_POST['reval']);
				}
			}


			$this->load->view($this->view_dir . 'add_marks', $this->data);

			$this->load->view('footer');
		} else {

			$this->load->view('header', $this->data);
			$this->data['school_code'] = '';
			$this->data['admissioncourse'] = '';
			$this->data['stream'] = '';
			$this->data['semester'] = '';

			$this->data['exam_session'] = $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
			$this->data['course_details'] = $this->Exam_timetable_model->getCollegeCourse();
			$this->data['schools'] = $this->Exam_timetable_model->getSchools();
			$this->load->view($this->view_dir . 'add_marks', $this->data);
			$this->load->view('footer');

		}


	}
	public function edit()
	{
		$this->load->view('header', $this->data);
		$id = $this->uri->segment(3);
		$this->load->model('Attendance_model');
		$emp_id = $this->session->userdata("name");
		$this->data['classRoom'] = $this->Attendance_model->getclassRoom($emp_id);
		$this->data['ut'] = $this->Unittest_model->get_unittest_details($id);
		$this->load->view($this->view_dir . 'edit', $this->data);
		$this->load->view('footer');
	}

	public function marksdetails($testId)
	{
		//error_reporting(E_ALL);
		$testId = base64_decode($testId);
		$this->load->model('Examination_model');
		//echo $subdetails =$this->uri->segment(4);
		//exit;
		$this->data['sub_details'] = $testId;
		$subdetails = explode('~', $testId);
		$sub_id = $subdetails[0];
		$this->data['stream'] = $subdetails[3];
		$this->data['semester'] = $subdetails[4];
		$this->data['examsession'] = $subdetails[5];
		$this->data['exam_type'] = $subdetails[6];
		$stream_id = $subdetails[3];
		$exam = explode('-', $this->data['examsession']);
		$this->data['allbatchStudent'] = $this->Examination_model->getSubjectStudentList($sub_id, $stream_id, $exam[0], $exam[1], $exam[2]);
		$this->data['ut'] = $this->Cia_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Cia_marks_model->getStreamShortName($subdetails[3]);
		//echo "<pre>";
		//print_r($this->data['ut']);exit;
		$this->load->view('header', $this->data);
		$this->load->view($this->view_dir . 'add_markdetails', $this->data);
		$this->load->view('footer');
	}
	public function submitMarkDetails()
	{
		ini_set("memory_limit", "-1");
		set_time_limit(0);
		$this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$stud_id = $_POST['stud_id'];
		$marks_obtained = $_POST['marks_obtained'];
		$enrollement_no = $_POST['enrollement_no'];
		$adm_stream_id = $_POST['adm_stream'];
		$markentrydate = $this->input->post('markentrydate');
		$max_marks = $this->input->post('max_marks');
		if ($markentrydate != '') {
			$markentrydate = str_replace('/', '-', $markentrydate);
			$markentrydate1 = date('Y-m-d', strtotime($markentrydate));
		} else {
			$markentrydate1 = '0000-00-00';
		}
		$stream_arr = array(5, 6, 7, 8, 9, 10, 11, 96, 97, 107, 108, 109, 158, 159, 162, 266);
		$stream_arr1 = array(43, 44, 45, 46, 47);

		$subdetails = explode('~', $_POST['sub_details']);

		//echo '<pre>';
		//print_r($subdetails);exit;
		$subject_id = $subdetails[0];
		$stream = $subdetails[3];
		$semester = $subdetails[4];
		$examsession = $subdetails[5];
		$marks_type = $subdetails[6];
		if (!empty($subdetails[10])) {
			$is_backlog = $subdetails[10];
		} else {
			$is_backlog = 'N';
		}
		if ($marks_type == 'PR') {
			if (empty($subdetails[8])) {
				$batch_no = 1;
			} else {
				$batch_no = $subdetails[8];
			}

			if (empty($subdetails[7])) {
				$division = 'A';
			} else {
				$division = $subdetails[7];
			}


		} else {
			$division = '';
			$batch_no = '';
		}
		if ($subdetails[12] == 4 || $subdetails[12] == 5 || $subdetails[12] == 43) {
			$batch_no = 0;
		}
		$exam = explode('-', $examsession);

		if (in_array($stream, $stream_arr)) {
			$specialization_id = 9;
		} else if (in_array($stream, $stream_arr1)) {
			$specialization_id = 103;
		} else {
			$specialization_id = 0;
		}

		//insert in master
		$insert_master_array = array(
			"stream_id" => $stream,
			"specializaion_id" => $specialization_id,
			"semester" => $semester,
			"division" => $division,
			"batch_no" => $batch_no,
			"subject_id" => $subject_id,
			"exam_month" => $exam[0],
			"exam_year" => $exam[1],
			"exam_id" => $exam[2],
			"marks_entry_date" => $markentrydate1,
			"marks_type" => $marks_type,
			"max_marks" => $max_marks,
			"is_backlog" => $is_backlog,
			"entry_by" => $this->session->userdata("uid"),
			"entry_on" => date("Y-m-d H:i:s"),
			"entry_status" => 'Entered'
		);

		//echo "<pre>";
		//print_r($insert_master_array);exit;
		if ($marks_type == 'TH') {
			$chkstud = $this->Cia_marks_model->check_marks_enteredmaster_th($subject_id, $exam[2], $stream);
		} else {
			$chkstud = $this->Cia_marks_model->check_marks_enteredmaster_pr($subject_id, $marks_type, $exam[2], $batch_no, $division);
		}
		if ($this->session->userdata("uid") == 4389) {
			//print_r($chkstud);
			//print_r($insert_master_array);
			//exit;
		}
		//$chkstud =array();
		if (empty($chkstud)) {

			$DB1->insert("marks_entry_master", $insert_master_array);
			$last_inserted_id_master = $DB1->insert_id();
			//echo $DB1->last_query();
			//echo "<pre>";
			//print_r($insert_master_array);exit;
			for ($i = 0; $i < count($stud_id); $i++) {
				$insert_array = array(
					"me_id" => $last_inserted_id_master,
					"stud_id" => $stud_id[$i],
					"enrollment_no" => $enrollement_no[$i],
					"marks" => $marks_obtained[$i],
					"stream_id" => $adm_stream_id[$i],
					"specialization_id" => $specialization_id,
					"semester" => $semester,
					"division" => $division,
					"batch_no" => $batch_no,
					"subject_id" => $subject_id,
					"marks_type" => $marks_type,
					"exam_month" => $exam[0],
					"exam_year" => $exam[1],
					"exam_id" => $exam[2],
					"entry_ip" => $this->input->ip_address(),
					"entry_by" => $this->session->userdata("uid"),
					"entry_on" => date("Y-m-d H:i:s")
				);

				$DB1->insert("marks_entry", $insert_array);
				//echo $DB1->last_query();exit;
				//echo "<pre>";
				//print_r($insert_array);exit;
				$last_inserted_id = $DB1->insert_id();

			}
			if ($last_inserted_id) {

				if ($marks_type == 'PR') {
					$this->session->set_flashdata('prdupentry', 'Marks entry successfuly done.');
					redirect(base_url('Marks/pract_marks_entry'));
				} else {
					redirect(base_url('Marks/add'));
				}
			}
		} else {

			if ($marks_type == 'PR') {
				$this->session->set_flashdata('prdupentry', 'Marks entry already done.');
				redirect(base_url('Marks/pract_marks_entry/prdupentry'));
			} else {
				redirect(base_url('Marks/add'));
			}
		}
	}
	public function editMarksDetails($testId, $me_id)
	{

		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);
		//echo $testId;
		$this->data['me_id'] = $me_id;
		$this->data['sub_details'] = $testId;
		$subdetails = explode('~', $testId);
		//echo '<pre>';print_r($testId);exit;
		$sub_id = $subdetails[0];
		$stream_id = $subdetails[3];
		$exss = str_replace('/', '_', $subdetails[5]);
		$exam = explode('-', $exss);
		$exam_id = $exam[2];
		//echo '<pre>';print_r($sub_id);exit;

		if ($subdetails[6] == 'PR') {
			$this->data['reval'] = $subdetails[9];//exit;
		} else {
			$this->data['reval'] = $subdetails[7];//exit;
		}
		$this->data['ut'] = $this->Cia_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Cia_marks_model->getStreamShortName($subdetails[3]);
		$this->data['me'] = $this->Cia_marks_model->fetch_me_details($me_id);
		if ($subdetails[7] != 'reval') {

			$this->data['mrks'] = $this->Cia_marks_model->get_marks_details($me_id, $exam_id, $subdetails);
			//	print_r($this->data['mrks']);exit;

		} else {
			//echo 1;exit;
			$this->data['mrks'] = $this->Cia_marks_model->getSubjectStudentList_reval($sub_id, $stream_id, $exam_id);
		}

		$this->load->view('header', $this->data);
		$this->load->view($this->view_dir . 'edit_cia_markdetails', $this->data);
		$this->load->view('footer');
	}
	//update marks
	public function updateStudMarks()
	{
		$this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$m_id = $_POST['m_id'];//exit;
		$subdetls = $_POST['sub_details'];
		$testId = base64_encode($_POST['sub_details']);
		$reval = $_POST['reval'];
		foreach ($_POST['stud_id'] as $spk) {
			$spk_details['stud_id'][] = $spk;
		}
		foreach ($_POST['enrollement_no'] as $spk1) {
			$spk_details['enrollement_no'][] = $spk1;
		}
		foreach ($_POST['mrk_id'] as $spk2) {
			$spk_details['mrk_id'][] = $spk2;
		}
		foreach ($_POST['marks_obtained'] as $spk3) {
			$spk_details['marks_obtained'][] = $spk3;
		}

		if (!empty($spk_details) && $reval != 'reval') {
			$speakerupdate = $this->Cia_marks_model->updateMarkDetails($spk_details, $m_id, $subdetls); //edit marks detail
		} else {
			$speakerupdate = $this->Cia_marks_model->updateMarkDetails_reval($spk_details, $m_id); //edit reval marks detail
		}

		//redirect(base_url('Marks/editMarksDetails/'.$testId.'/'.base64_encode($m_id)));

		//echo $DB1->last_query();exit;
	}

	// Load necessary libraries

	public function downloadExcel($testId)
	{

		$this->load->library('PHPExcel');

		// $students = $this->Cia_marks_model->getStudentXl();
		$testId = base64_decode($testId);
		$this->load->model('Examination_model');
		$roll_id = $this->session->userdata("role_id");
		$emp_id = $this->session->userdata("name");
		$this->load->model('Attendance_model');
		$curr_session = $this->Attendance_model->getCurrentSession();
		//echo $subdetails =$this->uri->segment(4);
		//exit;
		$this->data['sub_details'] = $testId;
		$subdetails = explode('~', $testId);
		$sub_id = $subdetails[0];
		$this->data['stream'] = $subdetails[3];
		$this->data['semester'] = $subdetails[4];
		$this->data['examsession'] = $subdetails[5];
		$this->data['exam_type'] = $subdetails[6];
		$this->data['batch_details'] = $subdetails[7];

		$stream_id = $subdetails[3];
		$batch_details = $subdetails[7];
		$batch_code = explode('-', $batch_details);
		$th_batch = $batch_code[2]; //echo $subdetails[5];exit;
		$exam = explode('-', $subdetails[5]);
		// print_r($subdetails);exit;

		$division = $subdetails[16];
		$batch = $subdetails[17];
		// $this->data['allbatchStudent'] = $this->Cia_marks_model->get_studbatch_allot_list($batch_details,$th_batch,$sub_id,$stream_id, $subdetails[4],$exam[2],$curr_session[0]['academic_year']);
		$students = $this->Cia_marks_model->getSubjectStudentList($sub_id, $stream_id, $exam[0], $exam[1], $exam[2], $division, $batch);

		$this->data['ut'] = $this->Cia_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Cia_marks_model->getStreamShortName($subdetails[3]);
		// echo '<pre>';
		// print_r($this->data['allexamStudent']);exit;
		$cia_exam_type = $subdetails[9];
		$sub_code = $subdetails[10];
		//print_r($subdetails);exit;
		$objPHPExcel = new PHPExcel();

		if ($cia_exam_type != 'attendance') {
			$markstype = 'Marks';
		} else {
			$markstype = 'Attendance';
		}
		$objPHPExcel->getProperties()->setCreator("Your Name")
			->setTitle("Students Marks Entry Data");

		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'Sr. No.')
			->setCellValue('B1', 'Subject')
			->setCellValue('C1', 'CIA Exam Type')
			->setCellValue('D1', 'Student_id')
			->setCellValue('E1', 'Enrollement Number')
			->setCellValue('F1', $markstype);
		//	->setCellValue('G1', 'Attendance');


		$row = 2;
		$i = 1;
		foreach ($students as $student) {
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $i++);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $sub_id . '-' . $sub_code);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $cia_exam_type);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $student['stud_id']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $student['enrollment_no']);
			if ($cia_exam_type != 'attendance') {
				$objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $student['cia_marks']);
			} else {
				$objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $student['attendance_marks']);
			}
			$row++;
		}

		$objPHPExcel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Student_CIA_marks_data.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		exit;
	}





public function uploadExcelData()
	{
		$this->load->library('PHPExcel');
		$this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$subdetails = json_decode($this->input->post('sub_details'), true);
	
		$stud_id = $_POST['stud_id'];
		$stream_id = $_POST['stream_id'];
		$marks_obtained = $_POST['marks_obtained'];
		$attdance_marks = $_POST['attdance_marks'];
		$enrollement_no = $_POST['enrollement_no'];
	
		$markentrydate1 = date('Y-m-d');
		$subject_id = $subdetails[0][0];
		$streamId = $subdetails[0][1];
		$semester = $subdetails[0][2];
		$examsession = $subdetails[0][3];
		$marks_type = $subdetails[0][4];
		$cia_exam_id = $subdetails[0][6];
		$cia_exam_type = $subdetails[0][7];
		$max_marks = $subdetails[0][8];
		$sub_component = $subdetails[0][9];
		$ac_session = $subdetails[0][10];
		$division = $subdetails[0][11];
		$batch = $subdetails[0][12];
	
		$specialization_id = ($semester <= 2 && in_array($streamId, [5, 6, 7, 8, 9, 10, 11, 96, 97, 107, 108, 109, 158, 159, 162, 266])) ? 9 : 0;
	
		$insert_master_array = array(
			"stream_id" => $streamId,
			"specializaion_id" => $specialization_id,
			"semester" => $semester,
			"division" => $division,
			"batch_no" => $batch,
			"subject_id" => $subject_id,
			"exam_id" => explode('-', $examsession)[2],
			"cia_exam_id" => $cia_exam_id,
			"cia_exam_type" => $cia_exam_type,
			"marks_entry_date" => $markentrydate1,
			"marks_type" => $marks_type,
			"max_marks" => $max_marks,
			"entry_by" => $this->session->userdata("uid"),
			"entry_on" => date("Y-m-d H:i:s"),
			"entry_status" => 'Entered'
		);
		$DB1->insert("marks_entry_master", $insert_master_array);
		$last_inserted_id_master = $DB1->insert_id();
	
		if ($_FILES['file']['name']) {
			$inputFileName = $_FILES['file']['tmp_name'];
			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
			$sheet = $objPHPExcel->getActiveSheet();
	
			$isFirstRow = true;
			foreach ($sheet->getRowIterator() as $row) {
				if ($isFirstRow) {
					$isFirstRow = false;
					continue;
				}
	
				$enrollement_no = $sheet->getCell('E' . $row->getRowIndex())->getValue();
				$cia_marks = $sheet->getCell('F' . $row->getRowIndex())->getValue();
				$cia_marks = ($cia_marks === 'AB') ? 0 : $cia_marks;
	
				$existing_data = $this->Cia_marks_model->get_cia_marks_entry($subject_id, $enrollement_no);
	
				if (empty($existing_data)) {
					// Insert a new record
					$data = array(
						'cia_exam_id' => $cia_exam_id,
						'me_id' => $last_inserted_id_master,
						'subject_id' => $subject_id,
						'subject_component' => $sub_component,
						'stud_id' => $sheet->getCell('D' . $row->getRowIndex())->getValue(),
						'enrollment_no' => $enrollement_no,
						'stream_id' => $streamId,
						'semester' => $semester,
						'division' => $division,
						'batch_no' => $batch,
						"$cia_exam_type" => $cia_marks,
						"ac_session" => $ac_session,
						'entry_by' => $this->session->userdata("uid"),
						'entry_on' => date("Y-m-d H:i:s"),
						'modified_by' => $this->session->userdata("uid"),
						'modified_on' => date("Y-m-d H:i:s"),
						'is_deleted' => 0
					);
					$DB1->insert('marks_entry_cia', $data);
				} else {
					// Update the existing record
					if ($cia_exam_type == "attendance") {
						$total_cia4 = $existing_data['behavioural_attitude'] + $cia_marks;
						$cia1 = round($existing_data['CIA1'] * 0.1 * 10, 2);
						$cia2 = round($existing_data['CIA2'] * 0.2 * 2, 2);
						$cia3 = round($existing_data['CIA3'] * 0.1 * 10, 2);
						$final_cia_marks = ($sub_component == 'TH')
							? ($cia1 + $cia2 + $cia3 + $total_cia4)
							: ($existing_data['lab_pr_works'] + $existing_data['viva'] + $total_cia4);
	
						$update_data = array(
							'me_id' => $last_inserted_id_master,
							$cia_exam_type => $cia_marks,
							'cia_marks' => $final_cia_marks,
							'cia_exam_id' => $cia_exam_id,
							'modified_by' => $this->session->userdata("uid"),
							'modified_on' => date("Y-m-d H:i:s")
						);
						$this->Cia_marks_model->update_cia_marks_entry($update_data, $existing_data['cia_id']);
					} else {
						$update_data = array(
							$cia_exam_type => $cia_marks,
							'modified_by' => $this->session->userdata("uid"),
							'modified_on' => date("Y-m-d H:i:s")
						);
						$this->Cia_marks_model->update_cia_marks_entry($update_data, $existing_data['cia_id']);
					}
				}
			}
	
			$this->session->set_flashdata('success', 'Data uploaded successfully.');
			redirect('cia_session/cia');
		} else {
			echo 'No file uploaded!';
		}
	}


	public function uploadExcelData_pr()
{
    $this->load->library('PHPExcel');
    $this->load->helper('security');
    $DB1 = $this->load->database('umsdb', TRUE);

    // Get submitted details
    $subdetails = json_decode($this->input->post('sub_details_pr'), true);
    if (empty($subdetails)) {
        $this->session->set_flashdata('error', 'Invalid subject details.');
        redirect('cia_session/cia');
    }

    $stud_id = $_POST['stud_id'] ?? [];
    $stream_id = $_POST['stream_id'] ?? [];
    $marks_obtained = $_POST['marks_obtained'] ?? [];
    $attdance_marks = $_POST['attdance_marks'] ?? [];
    $enrollement_no = $_POST['enrollement_no'] ?? [];

    $markentrydate1 = date('Y-m-d');
    $subject_id = $subdetails[0][0];
    $streamId = $subdetails[0][1];
    $semester = $subdetails[0][2];
    $examsession = $subdetails[0][3];
    $marks_type = $subdetails[0][4];
    $cia_exam_id = $subdetails[0][6];
    $cia_exam_type = $subdetails[0][7];
    $max_marks = $subdetails[0][8];
    $sub_component = $subdetails[0][9];
    $ac_session = $subdetails[0][10];
    $division = $subdetails[0][11];
    $batch = $subdetails[0][12];

    $exam = explode('-', $examsession);
    $specialization_id = ($semester <= 2 && in_array($streamId, [5, 6, 7, 8, 9, 10, 11, 96, 97, 107, 108, 109, 158, 159, 162, 266])) ? 9 : 0;

    // Insert into master table
    $insert_master_array = array(
        "stream_id" => $streamId,
        "specializaion_id" => $specialization_id,
        "semester" => $semester,
        "division" => $division,
        "batch_no" => $batch,
        "subject_id" => $subject_id,
        "exam_id" => $exam[2],
        "cia_exam_id" => $cia_exam_id,
        "cia_exam_type" => $cia_exam_type,
        "marks_entry_date" => $markentrydate1,
        "marks_type" => $marks_type,
        "max_marks" => $max_marks,
        "entry_by" => $this->session->userdata("uid"),
        "entry_on" => date("Y-m-d H:i:s"),
        "entry_status" => 'Entered'
    );
    $DB1->insert("marks_entry_master", $insert_master_array);
    $last_inserted_id_master = $DB1->insert_id();

    // Check if a file was uploaded
    if (!isset($_FILES['file']['name']) || empty($_FILES['file']['name'])) {
        $this->session->set_flashdata('error', 'No file uploaded!');
        redirect('cia_session/cia');
    }

    // Load the uploaded file
    $inputFileName = $_FILES['file']['tmp_name'];
    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
    $sheet = $objPHPExcel->getActiveSheet();

    $isFirstRow = true;
    foreach ($sheet->getRowIterator() as $row) {
        if ($isFirstRow) {
            $isFirstRow = false;
            continue;
        }

        $cia_marks = $sheet->getCell('F' . $row->getRowIndex())->getValue();
        $attendance = $sheet->getCell('G' . $row->getRowIndex())->getValue();
        $enrollment_no = $sheet->getCell('E' . $row->getRowIndex())->getValue();
        $stud_id_row = $sheet->getCell('D' . $row->getRowIndex())->getValue();

        // Convert 'AB' to 0
        if ($attendance == 'AB' || $cia_marks == 'AB') {
            $cia_marks = 0;
        }

        // Validate marks range
        if ($cia_exam_type == 'attendance' && ($cia_marks < 0 || $cia_marks > 100)) {
            $this->session->set_flashdata('error', 'Attendance out of range. Please check the data.');
            redirect('cia_session/cia');
        } elseif ($cia_exam_type != 'attendance' && ($cia_marks < 0 || $cia_marks > $max_marks)) {
            $this->session->set_flashdata('error', 'Marks out of range. Please check the data.');
            redirect('cia_session/cia');
        }

        // Process attendance
        if ($cia_exam_type === "attendance") {
            if ($cia_marks >= 80 && $cia_marks <= 84) {
                $cia_marks = 3;
            } elseif ($cia_marks >= 85 && $cia_marks <= 89) {
                $cia_marks = 4;
            } elseif ($cia_marks >= 90 && $cia_marks <= 100) {
                $cia_marks = 5;
            } else {
                $cia_marks = 0;
            }
        }

        $existing_data = $this->Cia_marks_model->get_cia_marks_entry($subject_id, $enrollment_no);

        if (!empty($existing_data)) {
            // Update existing record
            $cia4 = $existing_data['behavioural_attitude'] + ($cia_exam_type === "attendance" ? $cia_marks : 0);
            $final_cia_marks = $existing_data['lab_pr_works'] + $existing_data['viva'] + $cia4;

            $update_data = array(
                $cia_exam_type => $cia_marks,
                'cia_exam_id' => $cia_exam_id,
                'me_id' => $last_inserted_id_master,
                'cia_marks' => $final_cia_marks,
                'modified_by' => $this->session->userdata("uid"),
                'modified_on' => date("Y-m-d H:i:s")
            );
            $this->Cia_marks_model->update_cia_marks_entry($update_data, $existing_data['cia_id']);
        } else {
            // Insert new record
            $insert_data = array(
                'stud_id' => $stud_id_row,
                'enrollment_no' => $enrollment_no,
                'subject_id' => $subject_id,
                'stream_id' => $streamId,
                'semester' => $semester,
                'division' => $division,
                'batch_no' => $batch,
                'cia_exam_id' => $cia_exam_id,
                "$cia_exam_type" => $cia_marks,
                'subject_component' => $sub_component,
                'ac_session' => $ac_session,
                'me_id' => $last_inserted_id_master,
                'entry_by' => $this->session->userdata("uid"),
                'entry_on' => date("Y-m-d H:i:s")
            );
            $DB1->insert('marks_entry_cia', $insert_data);
        }
    }

    $this->session->set_flashdata('success', 'Data uploaded successfully.');
    redirect('cia_session/cia');
}
public function getCiaMarksData($testId = '', $me_id = '')
	{
		// Load necessary libraries
		$this->load->model('Cia_marks_model');

		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);

		$this->data['me_id'] = $me_id;
		$this->data['sub_details'] = $testId;
		$subdetails = explode('~', $testId);
		//$division = $subdetails[13];
		//$batch = $subdetails[14];

		// echo "<pre>";
		// print_r($subdetails);exit;

		$sub_id = $subdetails[0];
		$subject_component= $subdetails[11];
		$this->data['ut'] = $this->Cia_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Cia_marks_model->getStreamShortName($subdetails[3]);

		// Get CIA marks data from the model

		$this->data['cia_marks_data'] = $this->Cia_marks_model->getCiaMarksData($sub_id,$subject_component);

		// print_r($cia_marks_data);exit;

		// Load the view with the processed data and subjects

		$this->load->view('header', $this->data);
		$this->load->view($this->view_dir . 'view_cia_marks', $this->data);
		$this->load->view('footer');
	}

	public function downloadCIApdf($testId, $me_id)
	{
		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);

		$this->data['me_id'] = $me_id;
		$this->data['sub_details'] = $testId;
		$subdetails = explode('~', $testId);
		// echo "<pre>";
		// print_r($subdetails);exit;
		$sub_id = $subdetails[0];
		$exam = $subdetails[5];
		//$division = $subdetails[13];
		//$batch = $subdetails[14];

		$examses = explode('-', $exam);
		$exam_id = $examses[2];
		$this->data['streamId'] = $subdetails[3];
		$this->data['ut'] = $this->Cia_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Cia_marks_model->getStreamShortName($subdetails[3]);
		$this->data['me'] = $this->Cia_marks_model->fetch_me_details($me_id);

		if ($this->session->userdata("role_id") != 15) {
			$this->data['mrks'] = $this->Cia_marks_model->get_cia_marks_details($sub_id);
		} else {
			$this->data['mrks'] = $this->Cia_marks_model->get_cia_marks_details($sub_id, $exam_id);
		}

		// echo "<pre>";		
		// print_r($this->data['mrks']);exit;

		$this->load->library('m_pdf');
		$html = $this->load->view($this->view_dir . 'pdf_cia_markdetails', $this->data, true);
		$header = $this->load->view($this->view_dir . 'cia_pdf_header', $this->data, true);
		$pdfFilePath1 = $this->data['ut'][0]['subject_code'] . "_CIA_Marks.pdf";
		//$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

		$mpdf = new mPDF();

		$this->m_pdf->pdf = new mPDF('L', 'A4', '', '5', '15', 15, 60, 37, 5, 5);
		$dattime = date('d-m-Y H:i:s');
		$footer = '
			    <table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:12px;">
				<tr>
			    <td align="left" colspan="3" class="signature"><i><b>Declaration:</b>  I hereby declare that the above details are correct and verified to the best of my knowledge.
			 </i></td>
			  </tr>
			  <tr>
			    <td align="left" colspan="3" class="signature">&nbsp;</td>
			  </tr>
			  <tr>
			    <td align="left" height="50" class="signature"><strong>Signature of Class Coordinator </strong></td>
			    <td align="center" height="50" class="signature">&nbsp;</td>
			    <td align="right" height="50" class="signature"><strong>Signature of HoD/Dean</strong></td>

			  </tr>
			  <tr>
			    <td align="center" colspan="3" class="signature" style="font-size:10px;"><i>Printed on: ' . $dattime . '</i></td>
			  </tr>
			</table>';
		$header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
		$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->SetHTMLHeader($header1);
		$this->m_pdf->pdf->SetHTMLFooter($footer);
		//$this->m_pdf->pdf->setFooter('{PAGENO}');
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->AddPage();

		$this->m_pdf->pdf->WriteHTML($html);

		//download it.

		$this->m_pdf->pdf->Output($pdfFilePath1, "D");

	}
	// Veryfies Status
	function veryfyStatus($testId, $me_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);
		$userId = $this->session->userdata("uid");

		$update_array = array("verified_by" => $userId, "entry_status" => 'verified', "verified_on" => date('Y-m-d H:i:s'));
		$where = array("me_id" => $me_id);
		$DB1->where($where);

		if ($DB1->update('marks_entry_master', $update_array)) {
			//echo $DB1->last_query();exit;
			$this->session->set_flashdata('msg', 'Verified Successfully');
			redirect(base_url('Marks/editMarksDetails/' . base64_encode($testId) . '/' . base64_encode($me_id)));
		} else {
			$this->session->set_flashdata('msg', 'Problem while Verifying');
			redirect(base_url('Marks/editMarksDetails/' . base64_encode($testId) . '/' . base64_encode($m_id)));
		}
	}
	// Approve Status
	// Veryfies Status
	function approveStatus($testId, $me_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);
		$userId = $this->session->userdata("uid");

		$update_array = array("approved_by" => $userId, "entry_status" => 'approved', "approved_on" => date('Y-m-d H:i:s'));
		$where = array("me_id" => $me_id);
		$DB1->where($where);

		if ($DB1->update('marks_entry_master', $update_array)) {
			//echo $DB1->last_query();exit;
			$this->session->set_flashdata('msg', 'Verified Successfully');
			redirect(base_url('Marks/editMarksDetails/' . base64_encode($testId) . '/' . base64_encode($me_id)));
		} else {
			$this->session->set_flashdata('msg', 'Problem while Verifying');
			redirect(base_url('Marks/editMarksDetails/' . base64_encode($testId) . '/' . base64_encode($m_id)));
		}
	}
	/////////////////////////////////////////////////////
	// for CIA
	public function cia()
	{
		//error_reporting(E_ALL); ini_set('display_errors', 1);
		$this->load->model('Exam_timetable_model');
		$this->load->view('header', $this->data);
		$roll_id = $this->session->userdata("role_id");
		$emp_id = $this->session->userdata("name");
		if ($roll_id == 6 || $roll_id == 15) {
			$curr_session = $this->Cia_marks_model->getCurrentSession_for_marks_entry();

			$this->data['school_code'] = $_POST['school_code'];
			$this->data['admissioncourse'] = $_POST['admission-course'];
			$this->data['stream'] = $_POST['admission-branch'];
			$this->data['semester'] = $_POST['semester'];
			$this->data['exam'] = $_POST['exam_session'];
			$this->data['marks_type'] = $_POST['marks_type'];
			$this->data['reval'] = $_POST['reval'];
			$this->data['course_details'] = $this->Cia_marks_model->getCollegeCourse();
			$this->data['schools'] = $this->Cia_marks_model->getSchools();
			$this->data['exam_session'] = $this->Cia_marks_model->fetch_exam_session_for_marks_entry();
			if ($_POST) {

				$exam_id = $this->data['exam_session'][0]['cia_exam_id'];
				// print_r($exam_id);exit;
				$this->data['Marks_submission_date'] = $this->Cia_marks_model->Marks_submission_date($exam_id);

				$this->data['exam'] = $exam_id;
				$this->data['sub_list'] = $this->Cia_marks_model->list_coewise_cia_exam_subjects($emp_id, $curr_session[0]['academic_session'], $exam_id, $curr_session[0]['academic_year'], $_POST);

				for ($i = 0; $i < count($this->data['sub_list']); $i++) {
					$subjectId = $this->data['sub_list'][$i]['sub_id'];
					$stream = $this->data['sub_list'][$i]['stream_id'];
					$semester = $this->data['sub_list'][$i]['semester'];
					$this->data['sub_list'][$i]['mrk'] = $this->Cia_marks_model->getCIAMarksEntry($subjectId, $exam_id, 'CIA', $stream, $semester);

				}
			}
			$this->load->view($this->view_dir . 'add_cia_marks', $this->data);

			/* }
				   else
				   {		         
					 $this->data['school_code'] ='';
					 $this->data['admissioncourse'] = '';
					 $this->data['stream'] = '';
					 $this->data['semester'] = '';
				 
					 $this->data['exam_session']= $this->Exam_timetable_model->fetch_curr_exam_session();
					 $this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
					 $this->data['schools']= $this->Exam_timetable_model->getSchools();
					 $this->load->view($this->view_dir.'add_cia_marks',$this->data);
				   }*/
		} else {
			// for faculty
			// $this->load->model('Attendance_model');
			$curr_session = $this->Cia_marks_model->getCurrentSession_for_marks_entry();
			// $this->data['exam_session']= $this->Cia_marks_model->fetch_exam_session_for_marks_entry();
			$this->data['cia_exam_id'] = $this->Cia_marks_model->fetch_cia_exam_details();
			// $exam_id=$this->data['exam_session'][0]['exam_id'];
			$cia_exam_id = $this->data['cia_exam_id'][0]['cia_exam_id'];
			$cia_exam_type = $this->data['cia_exam_id'][0]['cia_exam_type'];
			$subject_component_cia = $this->data['cia_exam_id'][0]['subject_component'];
			$this->data['Marks_submission_date_th'] = $this->Cia_marks_model->Marks_submission_date_th($cia_exam_id);
			$this->data['Marks_submission_date_pr'] = $this->Cia_marks_model->Marks_submission_date_pr($cia_exam_id);
			$this->data['Th_subject'] = $this->Cia_marks_model->getFaqExam_applied_subjects_Th($emp_id, $curr_session[0]['academic_session'], $curr_session[0]['academic_year'], $subject_component_cia);
			$this->data['Pr_subject'] = $this->Cia_marks_model->getFaqExam_applied_subjects_Pr($emp_id, $curr_session[0]['academic_session'], $curr_session[0]['academic_year'], $subject_component_cia);

			// echo '<pre>';
			// print_r($this->data['subject']);exit;
			/*	for($j=0;$j<count($this->data['subject']);$j++){
					   
					   $subId = $this->data['subject'][$j]['subject_code'];
					   $semester = $this->data['subject'][$j]['semester'];
					   $stream_id = $this->data['subject'][$j]['stream_id'];
					   $subject_component = $this->data['subject'][$j]['subject_component'];
					   $this->data['subject'][$j]['batches']= $this->Cia_marks_model->getFaqSubjectBatches($emp_id, $subId, $subject_component);//function name changed for 2019 getFaqSubjectBatches
					   
					   $this->data['subject'][$j]['mrk']= $this->Cia_marks_model->getCIAMarksEntry($subId,$cia_exam_type, $stream_id, $semester);

					   // for($i=0;$i<count($this->data['batches']);$i++){
					   // 	$batch_code =  $this->data['batches'][$i]['batch_code'];
					   // 	$this->data['subject'][$j]['cntLect'][$i]= $this->Attendance_model->getNoOfLecture($emp_id, $subId, $from_date, $to_date, $batch_code);
					   // 	$this->data['subject'][$j]['AvgLectPer'][$i]= $this->Attendance_model->avgPerOfSubject($emp_id, $subId, $from_date, $to_date, $batch_code);
					   // }
				   }*/
			// print_r($this->data['subject']);exit;

			$this->load->view($this->view_dir . 'tw_cia_faculty_sub', $this->data);
		}
		$this->load->view('footer');

	}
	//
	public function ciamarksdetails($testId)
	{
		//error_reporting(E_ALL); ini_set('display_errors', 1);
		$testId = base64_decode($testId);
		$this->load->model('Examination_model');
		$roll_id = $this->session->userdata("role_id");
		$emp_id = $this->session->userdata("name");
		$this->load->model('Attendance_model');
		$curr_session = $this->Attendance_model->getCurrentSession();
		//echo $subdetails =$this->uri->segment(4);
		//exit;
		$this->data['sub_details'] = $testId;
		$subdetails = explode('~', $testId);
		$sub_id = $subdetails[0];
		$this->data['stream'] = $subdetails[3];
		$this->data['semester'] = $subdetails[4];
		$this->data['examsession'] = $subdetails[5];
		$this->data['exam_type'] = $subdetails[6];
		$this->data['batch_details'] = $subdetails[7];
		$this->data['cia_exam_type'] = $subdetails[9];
		$this->data['max_marks'] = $subdetails[10];
		$stream_id = $subdetails[3];
		$batch_details = $subdetails[7];
		$division = $subdetails[13];
		$batch = $subdetails[14];

		$batch_code = explode('-', $batch_details);
		$th_batch = $batch_code[2]; //echo $subdetails[5];exit;
		$exam = explode('-', $subdetails[5]);
		// print_r($this->data['cia_exam_type']);exit;
		if ($roll_id == 6 || $roll_id == 15) {
			$this->data['allexamStudent'] = $this->Cia_marks_model->getSubjectStudentList($sub_id, $stream_id, $exam[0], $exam[1], $exam[2] ,$division, $batch);
		} else {
			// $this->data['allbatchStudent'] = $this->Cia_marks_model->get_studbatch_allot_list($batch_details,$th_batch,$sub_id,$stream_id, $subdetails[4],$exam[2],$curr_session[0]['academic_year']);
			$this->data['allexamStudent'] = $this->Cia_marks_model->getSubjectStudentList($sub_id, $stream_id, $exam[0], $exam[1], $exam[2] ,$division, $batch);
		}
		$this->data['ut'] = $this->Cia_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Cia_marks_model->getStreamShortName($subdetails[3]);
		// echo "<pre>";
		// print_r($this->data['ut']);exit;
		// print_r($this->data['allexamStudent']);exit;
		$this->load->view('header', $this->data);
		$this->load->view($this->view_dir . 'add_cia_markdetails', $this->data);
		$this->load->view('footer');
	}
	// add CIA marks details
public function submitCIAMarkDetails()
	{
		$this->load->model('Cia_marks_model');
		$this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
	
		$stud_id = $_POST['stud_id'];
		$stream_id = $_POST['stream_id'];
		$marks_obtained = $_POST['marks_obtained'];
		$attdance_marks = $_POST['attdance_marks'];
		$enrollement_no = $_POST['enrollement_no'];
		$division = $_POST['division'] ?? '';
		$batch = $_POST['batch'] ?? '';
	
		$markentrydate = $this->input->post('markentrydate');
		$max_marks = $this->input->post('max_marks');
		$markentrydate1 = $markentrydate ? date('Y-m-d', strtotime(str_replace('/', '-', $markentrydate))) : '0000-00-00';
	
		$subdetails = explode('~', $_POST['sub_details']);
		$subject_id = $subdetails[0];
		$streamId = $subdetails[3];
		$semester = $subdetails[4];
		$examsession = $subdetails[5];
		$marks_type = $subdetails[6];
		$cia_exam_id = $subdetails[8];
		$cia_exam_type = $subdetails[9];
		$subject_component = $subdetails[11];
		$ac_session = $subdetails[12];
		$division = $subdetails[13];
		$batch = $subdetails[14];
		print_r($subdetails);
		$specialization_id = ($semester <= 2 && in_array($streamId, [5, 6, 7, 8, 9, 10, 11, 96, 97, 107, 108, 109, 158, 159, 162, 266])) ? 9 : 0;
	
		// Inserting or updating marks_entry_master only once
		$insert_master_array = array(
			"stream_id" => $streamId,
			"specializaion_id" => $specialization_id,
			"semester" => $semester,
			"division" => $division,
			"batch_no" => $batch,
			"subject_id" => $subject_id,
			"exam_id" => explode('-', $examsession)[2],
			"cia_exam_id" => $cia_exam_id,
			"cia_exam_type" => $cia_exam_type,
			"marks_entry_date" => $markentrydate1,
			"marks_type" => 'CIA',
			"max_marks" => $max_marks,
			"entry_by" => $this->session->userdata("uid"),
			"entry_on" => date("Y-m-d H:i:s"),
			"entry_status" => 'Entered'
		);
		$DB1->insert("marks_entry_master", $insert_master_array);
		$last_inserted_id_master = $DB1->insert_id();
	
		for ($i = 0; $i < count($stud_id); $i++) {
			$existing_data = $this->Cia_marks_model->get_cia_marks_entry($subject_id, $enrollement_no[$i]);
	
			if (empty($existing_data)) {
				// Insert entry for CIA1, CIA2, or CIA3 if no existing record
				if (in_array($cia_exam_type, ["CIA1", "CIA2", "CIA3", "lab_pr_works"])) {
					$data = array(
						'cia_exam_id' => $cia_exam_id,
						'me_id' => $last_inserted_id_master,
						'subject_id' => $subject_id,
						'subject_component' => $subject_component,
						'stud_id' => $stud_id[$i],
						'enrollment_no' => $enrollement_no[$i],
						'stream_id' => $stream_id[$i],
						'semester' => $semester,
						'division' => $division,
						"batch_no" => $batch,
						"$cia_exam_type" => $marks_obtained[$i],
						"ac_session" => $ac_session,
						'entry_by' => $this->session->userdata("uid"),
						'entry_on' => date("Y-m-d H:i:s"),
						'modified_by' => $this->session->userdata("uid"),
						'modified_on' => date("Y-m-d H:i:s"),
						'is_deleted' => 0
					);
					$DB1->insert('marks_entry_cia', $data);
					//echo $DB1->last_query();exit;
				}
			} else {
				// Update the existing record with new marks
				if ($cia_exam_type == "attendance") {
					$total_cia4 = $existing_data['behavioural_attitude'] + $attdance_marks[$i];
					$cia1 = round($existing_data['CIA1'] * 0.1 * 10, 2);
					$cia2 = round($existing_data['CIA2'] * 0.2 * 2, 2);
					$cia3 = round($existing_data['CIA3'] * 0.1 * 10, 2);
					$cia4 = $total_cia4;
					$final_cia_marks = $subject_component == 'TH' ? ($cia1 + $cia2 + $cia3 + $cia4) : ($existing_data['lab_pr_works'] + $existing_data['viva'] + $cia4);
		
					$update_data = array(
						'me_id' => $last_inserted_id_master,
						$cia_exam_type => $attdance_marks[$i], // Assuming marks_obtained contains marks for this subject
						'cia_marks' => $final_cia_marks,
						'cia_exam_id' => $cia_exam_id,
						'division' => $division,
						"batch_no" => $batch,
						'modified_by' => $this->session->userdata("uid"),
						'modified_on' => date("Y-m-d H:i:s")
					);
					$this->Cia_marks_model->update_cia_marks_entry($update_data, $existing_data['cia_id']);
				}
				else{
					$update_data = array(
						$cia_exam_type => $marks_obtained[$i],
						'modified_by' => $this->session->userdata("uid"),
						'division' => $division,
						"batch_no" => $batch,
						'modified_on' => date("Y-m-d H:i:s")
					);
					$this->Cia_marks_model->update_cia_marks_entry($update_data, $existing_data['cia_id']);
				}
			}
		}
	
		redirect('cia_session/cia');
	}
	public function submitCIAMarkDetails_old()
	{
		$this->load->model('Cia_marks_model');

		$this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$stud_id = $_POST['stud_id'];
		// print_r($stud_id);exit;
		$stream_id = $_POST['stream_id'];
		$marks_obtained = $_POST['marks_obtained'];
		$attdance_marks = $_POST['attdance_marks'];
		// print_r($attdance_marks);exit;

		$enrollement_no = $_POST['enrollement_no'];
		if (!empty($_POST['division']) && $_POST['division'] != '') {
			$division = $_POST['division'];
		} else {
			$division = '';
		}
		if (!empty($_POST['batch']) && $_POST['batch'] != '') {
			$batch = $_POST['batch'];
		} else {
			$batch = '';
		}

		$markentrydate = $this->input->post('markentrydate');
		$max_marks = $this->input->post('max_marks');
		if ($markentrydate != '') {
			$markentrydate = str_replace('/', '-', $markentrydate);
			$markentrydate1 = date('Y-m-d', strtotime($markentrydate));
		} else {
			$markentrydate1 = '0000-00-00';
		}
		$stream_arr = array(5, 6, 7, 8, 9, 10, 11, 96, 97, 107, 108, 109, 158, 159, 162, 266);
		//$stream_arr1 = array(43,44,45,46,47);

		$subdetails = explode('~', $_POST['sub_details']);
		//	print_r($subdetails);exit;
		$subject_id = $subdetails[0];
		$streamId = $subdetails[3];
		$semester = $subdetails[4];
		$examsession = $subdetails[5];
		$marks_type = $subdetails[6];
		$cia_exam_id = $subdetails[8];
		$cia_exam_type = $subdetails[9];
		$subject_component = $subdetails[11];
		$ac_session = $subdetails[12];
		$exam = explode('-', $examsession);
		if ($semester == 1 || $semester == 2) {
			if (in_array($streamId, $stream_arr)) {
				$specialization_id = 9;
			} else {
				$specialization_id = 0;
			}
		} else {
			$specialization_id = 0;
		}

		$insert_master_array = array(
			"stream_id" => $streamId,
			"specializaion_id" => $specialization_id,
			"semester" => $semester,
			"division" => $division,
			"batch_no" => $batch,
			"subject_id" => $subject_id,
			"exam_id" => $exam[2],
			"cia_exam_id" => $cia_exam_id,
			"cia_exam_type" => $cia_exam_type,
			"marks_entry_date" => $markentrydate1,
			"marks_type" => 'CIA',
			"max_marks" => $max_marks,
			"entry_by" => $this->session->userdata("uid"),
			"entry_on" => date("Y-m-d H:i:s"),
			"entry_status" => 'Entered'
		);
		$DB1->insert("marks_entry_master", $insert_master_array);
		$last_inserted_id_master = $DB1->insert_id();
//echo $DB1->last_query();exit;
		//	print_r($last_inserted_id_master);exit;
		//	$exam_type = array("HA1", "HA2", "HA3", "HA4", "HA5", "CIA2", "CIA3", "behavioural_attitude", "attendance");

		for ($i = 0; $i < count($stud_id); $i++) {

			if ($specialization_id == 0) {
				$stream = $streamId;
			} else {
				$stream = $stream_id[$i];
			}
			// print_r($cia_exam_type);exit;

			// Inserting for the first entry (HA1)
			if ($cia_exam_type === "CIA1" || $cia_exam_type == 'lab_pr_works') {
				// Insert data for HA1
				$data = array(
					'cia_exam_id' => $cia_exam_id,
					'me_id' => $last_inserted_id_master,
					'subject_id' => $subject_id,
					'subject_component' => $subject_component,
					'stud_id' => $stud_id[$i],
					'enrollment_no' => $enrollement_no[$i],
					'stream_id' => $stream_id[$i],
					'semester' => $semester,
					'division' => $division,
					"$cia_exam_type" => $marks_obtained[$i], // Assuming marks_obtained contains HA1 marks
					"ac_session" => $ac_session,
					'entry_by' => $this->session->userdata("uid"),
					'entry_on' => date("Y-m-d H:i:s"),
					'modified_by' => $this->session->userdata("uid"),
					'modified_on' => date("Y-m-d H:i:s"),
					'is_deleted' => 0
				);

				// print_r($data);exit;
				$DB1->insert('marks_entry_cia', $data);

					//echo $DB1->last_query();exit;

				//	$this->Cia_marks_model->insert_cia_marks_entry($data);

			} else {
				// Updating values for other components
				// Fetch existing record for the subject and student
				// echo $cia_exam_id;
				// echo "___";
				// echo $last_inserted_id_master;
				// echo "___";
				// echo $subject_id;
				// echo "___";
				// print_r($enrollement_no);
				//exit;
				if ($cia_exam_type === "attendance") {

					$existing_data = $this->Cia_marks_model->get_cia_marks_entry($subject_id, $enrollement_no[$i]);

					/*	if($attdance_marks[$i] < 60){
										$attdance_marks[$i] = 0;
									}
									elseif($attdance_marks[$i] >= 80 && $attdance_marks[$i] <= 100){
										$attdance_marks[$i] = 5;
									}*/
					//	$total_ha = ($existing_data['HA1']+$existing_data['HA2']+$existing_data['HA3']+$existing_data['HA4']+$existing_data['HA5']);
					$total_cia4 = $existing_data['behavioural_attitude'] + $attdance_marks[$i];

					if($subject_component == 'TH'){
					$cia1 = round($existing_data['CIA1'] * 0.1 * 10, 2);

					$cia2 = round($existing_data['CIA2'] * 0.2 * 2, 2);

					$cia3 = round($existing_data['CIA3'] * 0.1 * 10, 2);

					$total_cia4 = $existing_data['behavioural_attitude'] + $attdance_marks[$i];

					$cia4 = round(($total_cia4) * 0.1 * 10, 2);

					$final_cia_marks = $cia1 + $cia2 + $cia3 + $cia4;
					}
					else{
						$cia4 = $total_cia4;
						$final_cia_marks = $existing_data['lab_pr_works'] + $existing_data['viva'] + $cia4;
					}
					//	print_r($final_cia_marks);exit;

					if (!empty($existing_data)) {
						// Update the existing record with new marks
						$update_data = array(
							'me_id' => $last_inserted_id_master,
							$cia_exam_type => $attdance_marks[$i], // Assuming marks_obtained contains marks for this subject
							'cia_marks' => $final_cia_marks,
							'cia_exam_id' => $cia_exam_id,
							'modified_by' => $this->session->userdata("uid"),
							'modified_on' => date("Y-m-d H:i:s")
						);

						//	print_r($attdance_marks[$i]);exit;

						$this->Cia_marks_model->update_cia_marks_entry($update_data, $existing_data['cia_id']);
					}
				} else {

					$existing_data = $this->Cia_marks_model->get_cia_marks_entry($subject_id, $enrollement_no[$i]);

					// print_r($existing_data);exit;

					if (!empty($existing_data)) {
						// Update the existing record with new marks
						$update_data = array(
							$cia_exam_type => $marks_obtained[$i], // Assuming marks_obtained contains marks for this subject
							'modified_by' => $this->session->userdata("uid"),
							'modified_on' => date("Y-m-d H:i:s")
						);

						//	print_r($update_data);exit;

						$this->Cia_marks_model->update_cia_marks_entry($update_data, $existing_data['cia_id']);
					}
				}
			}
		}
		// Redirect to appropriate page
		redirect('cia_session/cia');
	}

	//edit CIA Marks

	public function editCIAMarksDetails($testId, $me_id)
	{
		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);

			//print_r($testId);print_r($me_id);exit;

		$this->data['me_id'] = $me_id;
		$this->data['sub_details'] = $testId;
		$subdetails = explode('~', $testId);
		$division = $subdetails[13];
		$batch = $subdetails[14];

	//	print_r($subdetails);exit;

		$sub_id = $subdetails[0];
		$cia_exam_id = $subdetails[8];
		$curr_session = $this->Cia_marks_model->getCurrentSession();

		// print_r($curr_session[0]['academic_year']);exit;

		$exam = explode('-', $subdetails[5]);
		$exam_id = $exam[2];
		$this->data['ut'] = $this->Cia_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Cia_marks_model->getStreamShortName($subdetails[3]);
		$this->data['me'] = $this->Cia_marks_model->fetch_me_details($me_id);
		$roll_id = $this->session->userdata("role_id");
		if ($roll_id == 6 || $roll_id == 15) {
			$this->data['mrks'] = $this->Cia_marks_model->get_ciamarks_details_coe($sub_id, $subdetails[3], $exam_id);
		} else {
			$this->data['mrks'] = $this->Cia_marks_model->get_ciamarks_details($me_id, $exam_id, $subdetails, $curr_session[0]['academic_year'], $cia_exam_id ,$division, $batch);

			// echo'<pre>';
			//   print_r($this->data['mrks']);exit;

		}
		$this->load->view('header', $this->data);
		$this->load->view($this->view_dir . 'edit_cia_markdetails', $this->data);
		$this->load->view('footer');
	}

	//update CIA marks
	public function updateCIAStudMarks()
	{
		$this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$m_id = $_POST['m_id'];
		$spk_details['max_marks'] = $_POST['max_marks'];
		$testId = base64_encode($_POST['sub_details']);
		$testId2 = $_POST['sub_details'];
		// print_r($m_id);exit;
		foreach ($_POST['stud_id'] as $spk) {
			$spk_details['stud_id'][] = $spk;
		}
		foreach ($_POST['enrollement_no'] as $spk1) {
			$spk_details['enrollement_no'][] = $spk1;
		}
		foreach ($_POST['mrk_id'] as $spk2) {
			$spk_details['mrk_id'][] = $spk2;
		}
		foreach ($_POST['marks_obtained'] as $spk3) {
			$spk_details['marks_obtained'][] = $spk3;
		}
		foreach ($_POST['attdance_marks'] as $spk3) {
			$spk_details['attdance_marks'][] = $spk3;
		}
		if (!empty($spk_details)) {
			// print_r($spk_details);exit;
			$this->Cia_marks_model->updateCIAMarkDetails($spk_details, $m_id, $testId2); //edit marks detail
		}

		redirect(base_url('Cia_session/editCIAMarksDetails/' . $testId . '/' . base64_encode($m_id)));

		//echo $DB1->last_query();exit;
	}

	// Veryfies Status
	function veryfyCIAStatus($testId, $me_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);
		$userId = $this->session->userdata("uid");

		$update_array = array("verified_by" => $userId, "entry_status" => 'verified', "verified_on" => date('Y-m-d H:i:s'));
		$where = array("me_id" => $me_id);
		$DB1->where($where);

		if ($DB1->update('marks_entry_master', $update_array)) {
			//echo $DB1->last_query();exit;
			$this->session->set_flashdata('msg', 'Verified Successfully');
			redirect(base_url('Cia_session/editCIAMarksDetails/' . base64_encode($testId) . '/' . base64_encode($me_id)));
		} else {
			$this->session->set_flashdata('msg', 'Problem while Verifying');
			redirect(base_url('Cia_session/editCIAMarksDetails/' . base64_encode($testId) . '/' . base64_encode($me_id)));
		}
	}
	// Approve Status
	function approveCIAStatus($testId, $me_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);
		$userId = $this->session->userdata("uid");

		$update_array = array("approved_by" => $userId, "entry_status" => 'approved', "approved_on" => date('Y-m-d H:i:s'));
		$where = array("me_id" => $me_id);
		$DB1->where($where);

		if ($DB1->update('marks_entry_master', $update_array)) {
			//echo $DB1->last_query();exit;
			$this->session->set_flashdata('msg', 'Verified Successfully');
			redirect(base_url('Cia_session/editCIAMarksDetails/' . base64_encode($testId) . '/' . base64_encode($me_id)));
		} else {
			$this->session->set_flashdata('msg', 'Problem while Verifying');
			redirect(base_url('Cia_session/editCIAMarksDetails/' . base64_encode($testId) . '/' . base64_encode($me_id)));
		}
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	// for CIA
	public function cia_report()
	{
		//error_reporting(E_ALL); ini_set('display_errors', 1);
		$this->load->model('Exam_timetable_model');
		$this->load->view('header', $this->data);
		$roll_id = $this->session->userdata("role_id");
		$emp_id = $this->session->userdata("name");

		if ($_POST) {
			// echo "<pre>";
			// print_r($_POST);exit;

			$this->data['school_code'] = $_POST['school_code'];
			$this->data['admissioncourse'] = $_POST['admission-course'];
			$this->data['stream'] = $_POST['admission-branch'];
			$this->data['semester'] = $_POST['semester'];
			// $this->data['exam'] =$_POST['exam_session'];
			$this->data['marks_type'] = $_POST['marks_type'];
			// $this->data['exam_session']= $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
			$this->data['exam_sessions'] = $this->Cia_marks_model->fetch_cia_exam_details();
			$this->data['course_details'] = $this->Exam_timetable_model->getCollegeCourse();
			$this->data['schools'] = $this->Exam_timetable_model->getSchools();

			//	$exam= explode('-', $_POST['exam_session']);
			//	$exam_month = $exam[0];
			//	$exam_year = $exam[1];
			//	print_r($this->data['exam_sessions'][0]['cia_exam_id']);exit;
			//	$this->data['exam_month'] = $exam[0];
			//	$this->data['exam_year'] = $exam[1];
			//	$this->data['exam_sess_id'] = $exam[2];

			$cia_exam_id = $this->data['exam_sessions'][0]['cia_exam_id'];
			// echo $cia_exam_id;exit;

			$this->data['sub_list'] = $this->Cia_marks_model->list_cia_subjects($_POST);
			$this->data['stud_list'] = $this->Cia_marks_model->list_cia_students_of_stream($_POST, $cia_exam_id);

			if ($roll_id == 15) {
				$this->load->view($this->view_dir . 'cia_consolidated_report_coe', $this->data);
			} else {
				$this->load->view($this->view_dir . 'cia_consolidated_report', $this->data);
			}

		} else {
			$this->data['school_code'] = '';
			$this->data['admissioncourse'] = '';
			$this->data['stream'] = '';
			$this->data['semester'] = '';

			$this->data['exam_session'] = $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
			$this->data['course_details'] = $this->Exam_timetable_model->getCollegeCourse();
			$this->data['schools'] = $this->Exam_timetable_model->getSchools();
			$this->load->view($this->view_dir . 'cia_consolidated_report', $this->data);
		}

		$this->load->view('footer');

	}
	function load_schools()
	{

		// print_r($_POST["school_code"]);exit;
		$school_code = $_POST["school_code"];
		//Get all city data
		$stream = $this->Cia_marks_model->get_courses($school_code);

		//Count total number of rows
		echo $rowCount = count($stream);

		//Display cities list
		//if($rowCount > 0){
		echo '<option value="">Select Course</option>';
		echo '<option value="0">All Course</option>';
		foreach ($stream as $value) {
			echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
		}
		/*} else{
					 echo '<option value="">Course not available</option>';
				 }*/

	}
	// load cia stream

	function load_cia_streams()
	{
		// echo $_POST["course_id"];exit;
		if ($_POST["course_id"] != '') {
			//Get all streams
			$stream = $this->Cia_marks_model->load_cia_streams($_POST["course_id"]);

			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			//if($rowCount > 0){
			echo '<option value="">Select Stream</option>';
			echo '<option value="0">All Stream</option>';
			foreach ($stream as $value) {
				echo '<option value="' . $value['stream_id'] . '">' . $value['stream_short_name'] . '</option>';
			}
			/*} else{
						 echo '<option value="">stream not available</option>';
					 }*/
		}
	}

	public function report_pdf($testId = '', $me_id = '')
	{
		$this->load->model('Cia_marks_model');

		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);

		$this->data['me_id'] = $me_id;
		$this->data['sub_details'] = $testId;
		$subdetails = explode('~', $testId);
		//print_r($subdetails);
		$sub_id = $subdetails[0];
		$subcomnt = $subdetails[11];
		$this->data['ut'] = $this->Cia_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Cia_marks_model->getStreamShortName($subdetails[3]);

		// Get CIA marks data from the model
		$this->data['cia_marks_data'] = $this->Cia_marks_model->getCiaMarksData($sub_id,$subcomnt);

		// Load mPDF library
		$this->load->library('m_pdf');

		// Load mPDF configuration
		$pdf = new mPDF('utf-8', 'A4', 0, '');

		$stream_name = $this->data['StreamSrtName'][0]['stream_name'];
		$school = $this->data['StreamSrtName'][0]['school_name'];

		// Set Footer
		$footer = '
			<table width="100%" border="0" align="center" style="margin-bottom:5px;">
				<tr>
					<td align="left" width="30%"><b>HOD</b><br><br>Signature:</span><br></td>
					<td align="left" width="40%"><b>DEAN</b><br><br>Signature:</span><br></td>
					<td align="left" width="30%"><b>Controller of Examination</b><br><br>Signature:</span><br></td>
				</tr>
			</table>
			<table cellpadding="0" cellspacing="0" border="0" width="800" style="margin-bottom:5px;">
				<tr>
					<td><small><b>{PAGENO}</b></small></td>
					<td style="font-size:9px;float:right;text-align:right;">
						<b style="font-size:9px;float:right;text-align:right;">Printed On: ' . date('d-m-Y H:i:s') . '</b>
					</td>
				</tr>
			</table>';

		// Set PDF settings
		$pdf->SetHTMLFooter($footer);

		// Load view into variable
		$content = $this->load->view($this->view_dir . 'report_pdf', $this->data, true);

		// Add content to PDF
		$pdf->AddPage();
		$pdf->WriteHTML($content);

		// Output PDF
		$pdfFilePath = 'cia_consolidated_report_' . date('YmdHis') . '.pdf';
		$pdf->Output($pdfFilePath, 'D');
	}


	function load_cia_semester()
	{
		// echo $_POST["stream_id"];exit;
		if (isset($_POST["stream_id"]) && !empty($_POST["stream_id"])) {
			//Get all streams

			$stream = $this->Cia_marks_model->get_cia_examsemester($_POST["stream_id"]);

			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if ($rowCount > 0) {
				echo '<option value="">Select Semester</option>';
				foreach ($stream as $value) {
					echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
				}
			} else {
				echo '<option value="">Semester not available</option>';

			}
		}
	}



	//add view
	public function add_subject_faculty($subject_id = '', $stream_id = '', $semester = '', $exam_id = '', $school = '', $division = '', $batch = '', $bkflag = '')
	{
		//error_reporting(E_ALL);
		$this->load->model('Timetable_model');
		$this->load->view('header', $this->data);
		$this->data['academicyear'] = $academicyear;
		$this->data['exam_id'] = $exam_id;
		$this->data['stream_id_bsc'] = $stream_id;
		if ($bkflag == '') {
			$this->data['sub'] = $this->Cia_marks_model->get_subdetails($subject_id, $stream_id, $semester, $exam_id, $division, $batch);
		} else {
			$this->data['sub'] = $this->Cia_marks_model->get_backlogsubdetails($subject_id, $stream_id, $semester, $exam_id, $division, $batch);
		}
		$this->data['faculty_list'] = $this->Cia_marks_model->get_faculty_list($stream_id, $semester);
		$this->data['exfaculty_list'] = $this->Cia_marks_model->get_exfaculty_list();
		$this->load->view($this->view_dir . 'add_pract_exam_faculty_subject', $this->data);
		$this->load->view('footer');
	}
	function load_subject_coures()
	{
		//echo $_POST["course_id"];exit;
		if (isset($_POST["school_code"]) && !empty($_POST["school_code"])) {
			$stream = $this->Cia_marks_model->load_subject_coures($_POST["school_code"], $_POST["batch"]);
			$rowCount = count($stream);

			//Display cities list
			if ($rowCount > 0) {
				echo '<option value="">Select Course</option>';
				foreach ($stream as $value) {
					echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
				}
			} else {
				echo '<option value="">Course not available</option>';

			}
		}
	}

}
?>