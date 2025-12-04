<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bundle_marks_entry extends CI_Controller
{

    var $currentModule = "";
    var $title = "";
    var $table_name = "unittest_master";
    var $model_name = "Unittest_model";
    var $model;
    var $view_dir = 'Bundle_marks_entry/';

    public function __construct()
    {

      //  error_reporting(E_ALL); ini_set('display_errors', 1);
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
        $this->load->model('Marks_model');
        if (
            ($this->session->userdata("role_id") == 15) || ($this->session->userdata("role_id") == 3) || ($this->session->userdata("role_id") == 21) || ($this->session->userdata("role_id") == 13)
            || ($this->session->userdata("role_id") == 14) || ($this->session->userdata("role_id") == 20) || ($this->session->userdata("role_id") == 44) || ($this->session->userdata("role_id") == 10) || ($this->session->userdata("role_id") == 25) || ($this->session->userdata("role_id") == 37) || ($this->session->userdata("role_id") == 26) || ($this->session->userdata("role_id") == 36)
        ) {


        } else {
            redirect('home');
        }
    }



    public function index()
    {

        //	error_reporting(E_ALL);

        $this->load->model('Exam_timetable_model');
        $this->load->model('Marks_model');

        if ($_POST) {

            // Load header

            $this->load->view('header', $this->data);

            // Set form data into variables

            $this->data['school_code'] = $_POST['school_code'];
            $this->data['admissioncourse'] = $_POST['admission-course'];
            $this->data['stream'] = $_POST['admission-branch'];
            $this->data['semester'] = $_POST['semester'];
            $this->data['exam'] = $_POST['exam_session'];
            $this->data['marks_type'] = $_POST['marks_type'];
            $this->data['reval'] = $_POST['reval'];

            // Fetch necessary data

            $this->data['exam_session'] = $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
            $this->data['course_details'] = $this->Exam_timetable_model->getCollegeCourse();
            $this->data['schools'] = $this->Exam_timetable_model->getSchools();

            // Extract exam details

            $exam = explode('-', $_POST['exam_session']);
            $exam_month = $exam[0];
            $exam_year = $exam[1];
            $exam_id = $exam[2];

            // Fetch subjects and marks

            if ($_POST['marks_type'] == 'TH') {
                $this->data['sub_list'] = $this->Marks_model->list_exam_subjects($_POST, $exam_id);
                for ($i = 0; $i < count($this->data['sub_list']); $i++) {
                    $subjectId = $this->data['sub_list'][$i]['sub_id'];
                    $this->data['sub_list'][$i]['mrk'] = $this->Marks_model->getMarksEntry($subjectId, $exam_id, $_POST['marks_type'], $_POST['admission-branch'], $_POST['semester'], $_POST['reval']);
					
                    // Fetch and assign bundle numbers for the subject

                    $this->data['sub_list'][$i]['bundle_numbers'] = $this->Marks_model->getBundleNumbers($subjectId, $exam_id, $this->data['stream'], $this->data['semester']);
                    	//print_r($this->data['sub_list'][$i]['bundle_numbers']);exit;
                }// exit;
            } else {
                $this->data['sub_list'] = $this->Marks_model->list_exam_pr_subjects($_POST, $exam_id);
                for ($i = 0; $i < count($this->data['sub_list']); $i++) {
                    $subjectId = $this->data['sub_list'][$i]['sub_id'];
                    $this->data['sub_list'][$i]['mrk'] = $this->Marks_model->getPr_MarksEntry($subjectId, $exam_id, $_POST['marks_type'], $_POST['admission-branch'], $_POST['semester'], $_POST['reval']);

                    // Fetch and assign bundle numbers for the subject

                    $this->data['sub_list'][$i]['bundle_numbers'] = $this->Marks_model->getBundleNumbers($subjectId, $exam_id);
                }
            }

            // Load the view

            $this->load->view($this->view_dir . 'add_bundle_marks', $this->data);
            $this->load->view('footer');

        } else {

            // Load default view if no POST data

            $this->load->view('header', $this->data);
            $this->data['school_code'] = '';
            $this->data['admissioncourse'] = '';
            $this->data['stream'] = '';
            $this->data['semester'] = '';

            $this->data['exam_session'] = $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
            $this->data['course_details'] = $this->Exam_timetable_model->getCollegeCourse();
            $this->data['schools'] = $this->Exam_timetable_model->getSchools();

            $this->load->view($this->view_dir . 'add_bundle_marks', $this->data);
            $this->load->view('footer');
        }
    }

    public function checkMarksEntryMaster()
    {
        $bundle_no = $this->input->post('bundle_no');
        // Call the model function
        $entry = $this->Marks_model->checkEntryExists($bundle_no);

        //	print_r($entry);
        // Check if the entry exists and include me_id if found
        if ($entry) {
            $response = [
                'exists' => true,
                'me_id' => $entry['me_id'], // Include me_id in the response
                'entry_on' => $entry['entry_on'], // Include me_id in the response
                'verified_on' => $entry['verified_on'] ?? '',
                'approved_on' => $entry['approved_on'] ?? '', // Include me_id in the response
                'status' => $entry['entry_status'] // Include me_id in the response
            ];
        } else {
            $response = [
                'exists' => false,
                'me_id' => null, // Return null for me_id if not found
                'entry_on' => '', // Include me_id in the response
                'verified_on' => '', // Include me_id in the response
                'approved_on' => '', // Include me_id in the response
                'status' => '' // Include me_id in the response
            ];
        }

        echo json_encode($response); // Return the JSON response
    }

    public function marksdetails($testId)
    {
        //error_reporting(E_ALL);
        $testId = urldecode($testId);

        //	$testId = base64_decode($testId);
        $this->load->model('Examination_model');
        //echo $subdetails =$this->uri->segment(4);
        //exit;
        $this->data['sub_details'] = $testId;
        $subdetails = explode('~', $testId);
        //	print_r($subdetails);exit;
        $sub_id = $subdetails[0];
        $this->data['stream'] = $subdetails[3];
        $this->data['semester'] = $subdetails[4];
        $this->data['examsession'] = $subdetails[5];
        $this->data['exam_type'] = $subdetails[6];
        $stream_id = $subdetails[3];
        $bundle_no = $subdetails[9];
        $exam = explode('-', $this->data['examsession']);
        $this->data['allbatchStudent'] = $this->Marks_model->getSubjectStudentList($bundle_no, $sub_id, $stream_id, $exam[0], $exam[1], $exam[2]);
        $this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
        $this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);
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

        //	echo '<pre>';
        //	print_r($subdetails);exit;
        $subject_id = $subdetails[0];
        $stream = $subdetails[3];
        $semester = $subdetails[4];
        $examsession = $subdetails[5];
        $marks_type = $subdetails[6];
        $bundle_no = $subdetails[9];

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
            "bundle_no" => $bundle_no,
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

        //	echo "<pre>";
        //	print_r($insert_master_array);exit;
        if ($marks_type == 'TH') {
            $chkstud = $this->Marks_model->check_bundle_marks_enteredmaster_th($subject_id, $exam[2], $stream, $bundle_no);
        } else {
            $chkstud = $this->Marks_model->check_marks_enteredmaster_pr($subject_id, $marks_type, $exam[2], $batch_no, $division);
        }
        if ($this->session->userdata("uid") == 4389) {
            //print_r($chkstud);
            //print_r($insert_master_array);
            //exit;
        }
        // print_r($chkstud);
        // print_r($insert_master_array);
        // exit;
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
                // echo $DB1->last_query();exit;
                // echo "<pre>";
                // print_r($insert_array);exit;
                $last_inserted_id = $DB1->insert_id();

            }
            if ($last_inserted_id) {

                if ($marks_type == 'PR') {
                    $this->session->set_flashdata('prdupentry', 'Marks entry successfuly done.');
                    redirect(base_url('Marks/pract_marks_entry'));
                } else {
                    redirect(base_url('Bundle_marks_entry/'));
                }
            }
        } else {

            if ($marks_type == 'PR') {
                $this->session->set_flashdata('prdupentry', 'Marks entry already done.');
                redirect(base_url('Marks/pract_marks_entry/prdupentry'));
            } else {
                redirect(base_url('Bundle_marks_entry/'));
            }
        }
    }
    public function editMarksDetails($testId, $me_id)
    {

        //	$me_id = base64_decode($me_id);
        $testId = urldecode($testId);

        // $testId = base64_decode($testId);
        //echo $testId;
        $this->data['me_id'] = $me_id;
        $this->data['sub_details'] = $testId;
        $subdetails = explode('~', $testId);
        //	echo '<pre>';print_r($subdetails);exit;
        $sub_id = $subdetails[0];
        $stream_id = $subdetails[3];
        $exss = str_replace('/', '_', $subdetails[5]);
        $exam = explode('-', $exss);
        $exam_id = $exam[2];
        if ($subdetails[6] == 'PR') {
            $this->data['reval'] = $subdetails[9];//exit;
        } else {
            $this->data['reval'] = $subdetails[7];//exit;
        }
        $this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
        $this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);
        $this->data['me'] = $this->Marks_model->fetch_me_details($me_id);
        if ($subdetails[7] != 'reval') {

            $this->data['mrks'] = $this->Marks_model->get_marks_details($me_id, $exam_id, $subdetails);
        } else {
            //echo 1;exit;
            $this->data['mrks'] = $this->Marks_model->getSubjectStudentList_reval($sub_id, $stream_id, $exam_id);
        }

        $this->load->view('header', $this->data);
        $this->load->view($this->view_dir . 'edit_markdetails', $this->data);
        $this->load->view('footer');
    }
    //update marks
    public function updateStudMarks()
    {
        $this->load->helper('security');
        $DB1 = $this->load->database('umsdb', TRUE);
        $m_id = $_POST['m_id'];//exit;
        $subdetls = $_POST['sub_details'];
        $testId = $_POST['sub_details'];
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
            $speakerupdate = $this->Marks_model->updateMarkDetails($spk_details, $m_id, $subdetls); //edit marks detail
        } else {
            $speakerupdate = $this->Marks_model->updateMarkDetails_reval($spk_details, $m_id); //edit reval marks detail
        }

        redirect(base_url('Bundle_marks_entry/editMarksDetails/' . $testId . '/' . $m_id));

        //echo $DB1->last_query();exit;
    }

    private function numberToWords($number)
    {
        $words = [
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety'
        ];

        if ($number < 21)
            return $words[$number];
        if ($number < 100)
            return $words[floor($number / 10) * 10] . ' ' . $words[$number % 10];

        return $number; // fallback for numbers > 99
    }

    public function download_marks_entry_excel($testId, $me_id)
    {
        $this->load->library('PHPExcel');

        $subdetails = explode('~', $testId);
        $sub_id = $subdetails[0];
        $exam = $subdetails[5];
        $examses = explode('-', $exam);
        $exam_id = $examses[2];

        $bundle_number = $subdetails[9];
        $streamId = $subdetails[3];

        $StreamSrtName = $this->Marks_model->getStreamShortName($streamId);
        $ut = $this->Marks_model->getsubdetails($sub_id);
        $me = $this->Marks_model->fetch_me_details($me_id);

        $marks = ($subdetails[6] != 'PR')
            ? $this->Marks_model->download_marks_details($me_id, $exam_id, $subdetails)
            : $this->Marks_model->download_pr_marks_details($me_id, $exam_id, $subdetails);

        $objPHPExcel = new PHPExcel();
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setTitle('Marksheet');

        // Set column widths
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // University Header
        $sheet->mergeCells('A1:F1')->setCellValue('A1', 'Sandip University');
        $sheet->mergeCells('A2:F2')->setCellValue('A2', 'Mahiravani, Trimbak Road, Nashik – 422 213');
        $sheet->mergeCells('A3:F3')->setCellValue('A3', ($me[0]['marks_type'] == 'TH' ? 'Theory' : 'Laboratory') . ' Mark Entry - ' . $me[0]['exam_month'] . ' ' . $me[0]['exam_year']);

        $sheet->getStyle('A1:A3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER]
        ]);

        // Subject Info Table
        $semname = ($streamId == '71') ? 'Year' : 'Semester';
        $sheet->fromArray([
            ['School Name:', $StreamSrtName[0]['school_name'], '', 'Programme:', $StreamSrtName[0]['stream_name']],
            ['Bundle No.:', strtoupper($bundle_number), '', 'Course Code / Subject Name:', strtoupper($ut[0]['subject_code']).'-'.strtoupper($ut[0]['subject_name'])],
            ['Max Marks:', $me[0]['max_marks'], '', 'Credits:', $ut[0]['credits']],
            ['Entry Date:', ($me[0]['marks_entry_date'] != '0000-00-00') ? date('d/m/Y', strtotime($me[0]['marks_entry_date'])) : '','',$semname . ':', $me[0]['semester']]
        ], null, 'A5');

        $sheet->getStyle('A5:F8')->applyFromArray([
            'font' => ['bold' => true],
            'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]],
        ]);

        // Table Header
        $sheet->fromArray([['Sr.No', 'PRN', 'Barcode', 'ABN', 'MARKS', 'MARKS IN WORDS']], NULL, 'A10');
        $sheet->getStyle('A10:F10')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => ['rgb' => 'D9E1F2']
            ],
            'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]]
        ]);

        // Row Data
        $row = 11;
        $sr = 1;
        $absentCount = 0;
        foreach ($marks as $stud) {
            $mark = $stud['marks'];
            $markText = ($mark === 'AB' || $mark === '00' || $mark === 'BA') ? '-' : $this->numberToWords(floatval($mark));
            if ($mark === 'AB')
                $absentCount++;

            $sheet->fromArray([
                $sr++,
                $stud['enrollment_no'],
                $stud['barcode'],
                $stud['ans_bklet_no'],
                $mark,
                $markText
            ], NULL, 'A' . $row);

            $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray([
                'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]]
            ]);
            $row++;
        }

        // Footer Summary
        $total = count($marks);
        $present = $total - $absentCount;
        $row += 2;
        $sheet->fromArray([['No. of Present:', $present, 'No. of Absent:', $absentCount, 'Total:', $total]], NULL, 'A' . $row);
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->mergeCells('C' . $row . ':D' . $row);
        $sheet->mergeCells('E' . $row . ':F' . $row);
        $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray([
            'font' => ['bold' => true],
            'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]]
        ]);

        // Output Excel
        ob_clean();
        $filename = strtoupper($ut[0]['subject_code']) . '_Marks.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }



    //
    public function download_bundle_wise_pdf($testId, $me_id)
    {
        //	$me_id = base64_decode($me_id);
        //	$testId = base64_decode($testId);
        $this->data['me_id'] = $me_id;
        $this->data['sub_details'] = $testId;
        $subdetails = explode('~', $testId);
        $sub_id = $subdetails[0];
        $exam = $subdetails[5];
        $examses = explode('-', $exam);
        $exam_id = $examses[2];
        $this->data['bundle_number'] = $subdetails[9];
        $this->data['streamId'] = $subdetails[3];
        $this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
        $this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);
        $this->data['me'] = $this->Marks_model->fetch_me_details($me_id);
        //	echo "<pre>";		
        //	print_r($subdetails);exit;
        if ($subdetails[6] != 'PR') {
            $this->data['mrks'] = $this->Marks_model->download_marks_details($me_id, $exam_id, $subdetails);
            //	print_r($this->data['mrks']);exit;
        } else {
            $this->data['mrks'] = $this->Marks_model->download_pr_marks_details($me_id, $exam_id, $subdetails);
        }

        $this->load->library('m_pdf');
        $html = $this->load->view($this->view_dir . 'pdf_markdetails', $this->data, true);
        //echo $html;Exit;
        $this->data['sts'] = "Y";
        $header = $this->load->view($this->view_dir . 'cia_pdf_header', $this->data, true);
        $pdfFilePath1 = $this->data['ut'][0]['subject_code'] . "_Marks.pdf";
        //$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        $mpdf = new mPDF();
        $this->m_pdf->pdf = new mPDF('L', 'A4', '', '5', '15', 15, 60, 37, 5, 5);
        $footer = '
                    <table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:12px;">
                        <tr>
                            <td align="right" height="50" class="signature"><strong>sign:____________________</strong></td> 
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

    public function download_consolidated_pdf($testId, $me_id)
    {
        //	$me_id = base64_decode($me_id);
        //	$testId = base64_decode($testId);
        $this->data['me_id'] = $me_id;
        $this->data['sub_details'] = $testId;
        $subdetails = explode('~', $testId);
        $sub_id = $subdetails[0];
        $exam = $subdetails[5];
        $examses = explode('-', $exam);
        $exam_id = $examses[2];
        $this->data['bundle_number'] = $subdetails[9];
        $this->data['streamId'] = $subdetails[3];
        $this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
        $this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);
        $this->data['me'] = $this->Marks_model->fetch_me_details($me_id);

        $me_id = 'none';
        // print_r($subdetails);exit;
        $this->data['mrks'] = $this->Marks_model->download_marks_details_all($me_id, $exam_id, $subdetails);

        $this->load->library('m_pdf');
        $html = $this->load->view($this->view_dir . 'con_marks_pdf', $this->data, true);
        //echo $html;Exit;
        $this->data['sts'] = "Y";
        $header = $this->load->view($this->view_dir . 'cia_pdf_header', $this->data, true);
        $pdfFilePath1 = $this->data['ut'][0]['subject_code'] . "_Marks.pdf";
        //$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        $mpdf = new mPDF();
        $this->m_pdf->pdf = new mPDF('L', 'A4', '', '5', '15', 15, 60, 37, 5, 5);
        $footer = '
                    <table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:12px;">
                        <tr>
                            <td align="left" colspan="3" class="signature"><i><b>Declaration:</b>  I hereby declare that the above details are correct and verified to the best of my knowledge.</i></td>
                        </tr>
                        <tr>
                            <td align="left" height="50" class="signature"><strong>Entry By:______________________</strong></td>
                            <td align="center" height="50" class="signature"><strong>Veryfied By:___________________</strong></td>
                            <td align="right" height="50" class="signature"><strong>Approved By:_____________________</strong></td>
                        </tr>
                        <tr>
                            <td align="left" height="50" class="signature"><strong>Entry Date:___________________</strong></td>
                            <td align="center" height="50" class="signature"><strong>Veryfied Date:________________</strong></td>
                            <td align="right" height="50" class="signature"><strong>Approved Date:____________________</strong></td> 
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


}
