<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SeatingReport extends CI_Controller {

    var $currentModule = "";
	var $title = "";
	var $table_name = "unittest_master";
	var $model_name = "SeatingReportModel";
	var $model;
	var $view_dir = 'Seating/';

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
		$this->load->model('Seating_model');  
        $this->load->model('SeatingReportModel');
        $this->load->model('EcrEmpRegModel');

        $this->load->library('m_pdf');  

        $user_name = $this->session->userdata('name'); // this should be email

        // echo $user_name;
        $this->load->model('EcrEmpRegModel');
        $centerData = $this->EcrEmpRegModel->getCenterIdIfUserExists($user_name);

        if (!empty($centerData)) {
        
            $center_ids = array_column($centerData, 'center_id'); 
            
            $this->session->set_userdata('center_ids', $center_ids);
        }

        $center_ids = $this->session->userdata('center_ids');

	}

    public function index() {
        $this->load->view('header', $this->data);
        // Load buildings for dropdown
        $this->load->model('Seating_model');  
        $this->load->model('SeatingReportModel');

        $this->data['buildings'] = $this->Seating_model->get_buildings();
        $this->data['exams'] = $this->SeatingReportModel->getExams();
    
        // Check if it's an AJAX request for floors
        $building_id = $this->input->get('building_id');
        if ($building_id) {
            $floors = $this->Seating_model->get_floors($building_id);
            echo json_encode(['floors' => $floors]);
            return;
        }
    
        $this->load->view('Seating/seating_report', $this->data);
        $this->load->view('footer');
    }
    public function get_floors()
    {
        $building_id = $this->input->get('building_id');
        $floors = $this->Seating_model->get_floors($building_id);
        echo json_encode(['floors' => $floors]);
    }
    public function get_halls()
    {
        $floor_id = $this->input->get('floor_id');
        $building_id = $this->input->get('building_id');
        $halls = $this->SeatingReportModel->get_halls($floor_id, $building_id);
        echo json_encode(['halls' => $halls]);
    }


    public function fetchSeatingData() {
        $building_id = $this->input->post('building_id');
        $floor_id = $this->input->post('floor_id');
        $hall_id = $this->input->post('hall_id');
        $exam_id = $this->input->post('exam_id');
        $exam_date = $this->input->post('exam_date');
        $session = $this->input->post('session');
    
        if (!$building_id || !$floor_id || !$hall_id || !$exam_id || !$exam_date || !$session) {
            echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
            return;
        }
    
        // Fetch hall details (rows & columns)
        $hallData = $this->SeatingReportModel->get_hall_details($hall_id, $floor_id, $building_id);
        if (!$hallData) {
            echo json_encode(['status' => 'error', 'message' => 'Hall data not found']);
            return;
        }
    
        // Fetch seating arrangement
        $seatingArrangement = $this->SeatingReportModel->get_seating_arrangement($exam_id, $exam_date, $session, $hall_id, $building_id, $floor_id);
        if (!$seatingArrangement) {
            echo json_encode(['status' => 'error', 'message' => 'No seating data found']);
            return;
        }
    
        // Convert JSON string to array
        $seatingData = json_decode($seatingArrangement['seating_arrangement'], true);
        
        // Fetch subjects
        $subjects = $this->SeatingReportModel->get_all_subjects($exam_id, $exam_date, $session);
    
        // Track allocated students to disable them later
        $allocatedStudents = [];
        foreach ($seatingData as $seat) {
            if (!empty($seat['enrollment_no'])) {
                $allocatedStudents[] = $seat['enrollment_no'];
            }
        }
    
        if (!isset($hallData['matrix_rows']) || $hallData['matrix_rows'] == 0) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid hall data: Rows cannot be zero']);
            return;
        }
        
        $columnLimit = intval($hallData['matrix_rows']);
        
        $html = '<div class="seat-grid">'; // Main grid container

        $rowCount = 0;
       // print_r($seatingData);exit;
        foreach ($seatingData as $seat) {
			
            $seatIndex = htmlspecialchars($seat['seat_no']);
            $selectedSubject = htmlspecialchars($seat['subject_id']);
            $selectedStudent = htmlspecialchars($seat['enrollment_no']);
        
            // Start new row
            if ($rowCount % $columnLimit == 0) {
                if ($rowCount > 0) $html .= '</div>'; // Close previous row if not first
                $html .= '<div class="seat-row d-flex gap-3 mb-3">'; // New row container
            }
        
            // Seat box
            $html .= '<div class="seat-box" data-seat-no="' . $seatIndex . '">
                <div class="fw-bold mb-2" style="font-size:12px">Seat ' . $seatIndex . '</div>
                <div class="mb-2 w-100">
                    <select name="subject[]" class="form-control subject-dropdown subject-' . $seatIndex . '" data-seat-index="' . $seatIndex . '">
                        <option value="">Select Subject</option>';
        
                        foreach ($subjects as $subject) {
                            $isSelected = ($selectedSubject == $subject['sub_id']) ? 'selected' : '';
                            $colorStyle = isset($subject['highlight']) && $subject['highlight'] ? 'style="color: green; font-weight: bold;"' : '';
                            $label = isset($subject['label']) ? $subject['label'] : $subject['subject_name'];
        
                            $html .= '<option value="' . htmlspecialchars($subject['sub_id']) . '" ' . $isSelected . ' ' . $colorStyle . '>' .
                                        htmlspecialchars($label) .
                                      '</option>';
                        }
        
            $html .= '</select>
                </div>
                <div class="w-100">
                    <select name="student[]" class="form-control student-dropdown student-' . $seatIndex . '" data-seat-index="' . $seatIndex . '" data-selected="' . $selectedStudent . '">
                        <option value="">Select Student</option>';
        
                        if (!empty($selectedStudent)) {
                            $html .= '<option value="' . $selectedStudent . '" selected>' . $selectedStudent . '</option>';
                        }
        
            $html .= '</select>
                </div>
            </div>';
        
            $rowCount++;
        }
        
        $html .= '</div></div>'; // Close last row and main grid
        
        
        echo json_encode(['status' => 'success', 'html' => $html, 'allocated_students' => $allocatedStudents]);
    }
    
    

    public function fetchStudentsForSubject() {

        $subject_id = $this->input->post('subject_id');
        $exam_id = $this->input->post('exam_id');
        $exam_date = $this->input->post('date');
        $session = $this->input->post('session');
        $allocated_students = $this->input->post('allocated_students'); // Get allocated students from request

       //  echo $subject_id.','.$exam_id.','.$exam_date.','.$session;exit;
        
        if (!$subject_id || !$exam_id || !$exam_date || !$session) {
            echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
            return;
        }
        
      //  echo $subject_id;exit;
        // Fetch available students for the selected subject
        $students = $this->SeatingReportModel->get_students($exam_id, $exam_date, $session, $subject_id);
       //  print_r($students);exit;
        echo json_encode(['students' => $students]);
        
    }
    
    public function updateSeatingJson()
    {
        $seating_data = $this->input->post('seating_data');
        $parsed = json_decode($seating_data, true);
    
        if (!$parsed) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
            return;
        }
    
        $identifiers = [
            'exam_id'   => $parsed['exam_id'],
            'exam_date' => $parsed['exam_date'],
            'session'   => $parsed['session'],  
            'building'  => $parsed['building'],
            'floor'     => $parsed['floor'],
            'hall'      => $parsed['hall']
        ];
        //   echo '<pre>';
        //   print_r($identifiers);exit;
    
        $update_data = [
            'seating_arrangement' => json_encode($parsed['seats']),
            'updated_at'   => date('Y-m-d H:i:s')
        ];
        $DB1 = $this->load->database('umsdb', TRUE);

        // Assuming table: exam_hall_seating_arrangement with identifying keys as columns
        $DB1->where($identifiers);
        $exists = $DB1->get('exam_hall_seating_arrangement')->row();
    
        if ($exists) {
            $DB1->where($identifiers)->update('exam_hall_seating_arrangement', $update_data);
        } else {
            $DB1->insert('exam_hall_seating_arrangement', array_merge($identifiers, $update_data));
        }
    
        echo json_encode(['status' => 'success']);
    }

    
    public function generateReport() {
        //    echo 'hzsddas';exit;
            $exam_id = $this->input->post('exam_id');
            $exam_date = $this->input->post('exam_date');
            $session = $this->input->post('session');
            $report_type = $this->input->post('report_type');
            $building_id = $this->input->post('building_id');
        
            $center = $this->SeatingReportModel->get_center_by_building($building_id, $exam_id);
			
			$building = $this->SeatingReportModel->get_building_name($building_id);

            // Fetch consolidated seating arrangement data
            $reportData = $this->SeatingReportModel->getConsolidatedSeating($exam_id, $exam_date, $session, $building_id);

           // $this->load->model('EcrEmpRegModel');

          /*  $examDetailsTime = $this->EcrEmpRegModel->getExamDetailsTime($exam_id);

            $sessionTimeMap = [];

            foreach ($examDetailsTime as $row) {
                $session = $row['session']; // 'FN' or 'AN'
            
                if (!empty($row['from_time'])) {
                    $fromTimeRaw = $row['from_time'];
                    $fromTime = date("h:i", strtotime($fromTimeRaw));
                    $toTime   = date("h:i", strtotime($fromTimeRaw . ' +3 hours'));
            
                    $sessionTimeMap[$session] = "$fromTime - $toTime";
                } else {
                    $sessionTimeMap[$session] = "Time Not Available";
                }
            }
            
            $reportData['session_time_map'] = $sessionTimeMap;
            */
            
            // print_r();exit;
        
            // Initialize mPDF
            if ($report_type === 'subjectwise') {
                $mpdf = new mPDF('L', 'Legal', '', '', 5, 5, 35, 35 , 5, 5);
            }
            elseif($report_type === 'doorwise'){
                $mpdf = new mPDF('L', 'A4-L', '', '', 5, 5, 30, 15 , 5, 5); 
            }
            else {
                $mpdf = new mPDF('L', 'A4', '', '', 5, 5, 30, 15 , 5, 5);   
            }

            if ($report_type === 'subjectwise') {
                // Define the header HTML
                $headerHTML = '
                    <table style="width: 100%; border: none; font-size: 12px;">
                        <tr>
                            <td style="width: 20%; text-align: center;">
                                <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 70px; height: auto;">
                            </td>
                            <td style="width: 60%; text-align: center;">
                                <div style="font-size: 20px; font-weight: bold;">Sandip University</div>
                                <div>Mahiravani, Trimbak Road, Nashik - 422 213</div>
                                <div style="font-size: 14px; font-weight: bold;" >End Semester Examination: ' . htmlspecialchars($reportData['exam_name'], ENT_QUOTES, 'UTF-8') . ', '.$center['center_name'].'<br>('.$building['building_name'].')</div>
                                <div style="font-weight: bold; font-size: 14px;">ATTENDANCE SHEET </div>
                            </td>
                            <td style="width: 20%; text-align: center;">
                                <div style="font-size: 30px; font-weight: bold;">COE</div>
                            </td>
                        </tr>
                    </table>
                    <hr>
                ';  
        
                }elseif ($report_type === 'seating') {
                    $exam_ssn = (($session === 'FN') ? 'FORE NOON SESSION(09:30 AM - 12:30 PM)' : 'AFTERNOON SESSION(2:00 PM - 5:00 PM)');
                    
                    $headerHTML = '
                    <table style="width: 100%; border: none; font-size: 12px;">
                        <tr>
                            <td style="width: 20%; text-align: center;">
                                <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 70px; height: auto;">
                            </td>
                            <td style="width: 60%; text-align: center;">
                                <div style="font-size: 20px; font-weight: bold;">Sandip University</div>
                                <div>Mahiravani, Trimbak Road, Nashik - 422 213</div>
                                <div style="font-size: 14px; font-weight: bold;" >SEATING CONSOLIDATE FOR - '.$reportData['exam_name'].' , '.date('d-m-Y', strtotime($exam_date)).'</div>
                                <div style="font-weight: bold; font-size: 14px;">'.$exam_ssn.' '.$reportData['session_time_map'][$session].' ,'.$center['center_name'].'('.$building['building_name'].')</div>
                            </td>
                            <td style="width: 20%; text-align: center;">
                                <div style="font-size: 30px; font-weight: bold;">COE</div>
                            </td>
                        </tr>
                    </table>
                    <hr>
                ';
        
            }elseif ($report_type === 'hallwise') {
                $exam_ssn = (($session === 'FN') ? 'FORE NOON SESSION(10:00 AM - 1:00 PM)' : 'AFTERNOON SESSION(2:00 PM - 5:00 PM)');
                    
                $headerHTML = '
                <table style="width: 100%; border: none; font-size: 12px;">
                    <tr>
                        <td style="width: 20%; text-align: center;">
                            <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 70px; height: auto;">
                        </td>
                        <td style="width: 60%; text-align: center;">
                            <div style="font-size: 20px; font-weight: bold;">Sandip University</div>
                            <div>Mahiravani, Trimbak Road, Nashik - 422 213</div>
                            <div style="font-size: 12px; font-weight: bold;" >HALL SUPRINTENDANT ANSWER BOOKLET SUBMISSION DETAILS</div>
                            <div style="font-weight: bold; font-size: 12px;">'.$reportData['exam_name'].' , '.$exam_date.','.$exam_ssn.','.$center['center_name'].'('.$building['building_name'].')</div>
                        </td>
                        <td style="width: 20%; text-align: center;">
                            <div style="font-size: 30px; font-weight: bold;">COE</div>
                        </td>s
                    </tr>
                </table>
                <hr>
            ';
        }  elseif ($report_type === 'doorwise') {
                // Define the header HTML
                $headerHTML = '
                    <table style="width: 100%; border: none; font-size: 12px;">
                        <tr>
                            <td style="width: 20%; text-align: center;">
                                <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 70px; height: auto;">
                            </td>
                            <td style="width: 60%; text-align: center;">
                                <div style="font-size: 20px; font-weight: bold;">Sandip University</div>
                                <div>Mahiravani, Trimbak Road, Nashik - 422 213</div>
                                <div style="font-size: 14px; font-weight: bold;" >End Semester Examination: ' . htmlspecialchars($reportData['exam_name'], ENT_QUOTES, 'UTF-8') . ', '.$center['center_name'].'('.$building['building_name'].')</div>
                                <div style="font-weight: bold; font-size: 14px;">SEATING PLAN</div>
                            </td>
                            <td style="width: 20%; text-align: center;">
                                <div style="font-size: 30px; font-weight: bold;">COE</div>
                            </td>
                        </tr>
                    </table>
                    <hr>
                ';

        }

                if ($report_type === 'subjectwise') {
            // Define the footer HTML
            $footerHTML = '
                <hr>
                <div style="font-size: 12px;margin-top:0px;">
                    <p>Total Present: _______ &nbsp;&nbsp;&nbsp; Total Absent: _______</p>
                    <p style="font-size: 12px;">Certified that the following particulars have been verified:</p>
                    <ol>
                        <li style="font-size: 10px;">The Register Number in the Attendance Sheet with that in the Hall Ticket</li>
                        <li style="font-size: 10px;">The Identification of the Candidate with the photo given in the Hall Ticket</li>
                        <li style="font-size: 10px;">The Answer Book number entered in the attendance sheet by the candidate with the serial No. on the Answer Book</li>
                    </ol>
                    <table style="width: 100%; font-size: 12px;">
                        <tr>
                            <td style="width: 50%;border:none; text-align: left;">
                                <div>Signature:</div>
                                <div>Name(Hall Superintendent):</div>
                            </td>
                            <td style="width: 50%;border:none;  text-align: left;">
                                <div>Signature:</div>
                                <div>Name(Chief Superintendent):</div>
                            </td>
                        </tr>
                    </table>
                </div>
            ';
        }elseif ($report_type === 'seating' || $report_type === 'doorwise') {

            $footerHTML = '
            <div style="font-size: 12px;margin-top:0px;">
                <div style="text-align: Right;">_______________________________</div>
                <div style="text-align: Right;">Chief Superintendent Signature</div>
            </div>
        ';
    }elseif ($report_type === 'hallwise') {
        $footerHTML = '
        <div style="font-size: 12px;margin-top:0px;">
            <div style="text-align: Right;">_____________________</div>
            <div style="text-align: Right;">Signature of the HS</div>
        </div>
    ';
    }
    // echo $headerHTML;
    // echo $footerHTML;exit;
        // Set the header and footer
        $mpdf->SetHTMLHeader($headerHTML);
        $mpdf->SetHTMLFooter($footerHTML);
    
        // Generate the PDF body content
        if ($report_type === 'seating') {
            // Generate Seating Arrangement Report
            $html = $this->load->view('Seating/seating_pdf', $reportData, true);
        } elseif ($report_type === 'subjectwise') {
            // Generate Subject-wise Student List Report
            $html = $this->load->view('Seating/subjectwise_student_list_pdf', $reportData, true);
        }  elseif ($report_type === 'hallwise') {
            // New hall-wise report
            $html = $this->load->view('Seating/hallwise_pdf', $reportData, true);
        }  elseif ($report_type === 'doorwise') {
            // New hall-wise report
            $html = $this->load->view('Seating/doorwise_pdf', $reportData, true);
        }
    
        // Write content and output PDF
        $mpdf->WriteHTML($html);
        $mpdf->Output('Attendance_Sheet.pdf', 'D'); // Download the PDF
    }
    
    public function softDeleteSeating()
{
    $exam_id = $this->input->post('exam_id');
    $exam_date = $this->input->post('exam_date');
    $session = $this->input->post('session');
    $building = $this->input->post('building');
    $floor = $this->input->post('floor');
    $hall = $this->input->post('hall');

    if (!$exam_id || !$exam_date || !$session || !$building || !$floor || !$hall) {
        echo json_encode(['status' => 'error', 'message' => 'Incomplete data.']);
        return;
    }

    $DB1 = $this->load->database('umsdb', TRUE);

    $DB1->where([
        'exam_id' => $exam_id,
        'exam_date' => $exam_date,
        'session' => $session,
        'building' => $building,
        'floor' => $floor,
        'hall' => $hall
    ]);
    $updated = $DB1->update('exam_hall_seating_arrangement', ['is_active' => 'N']);

    if ($updated) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'DB update failed.']);
    }
}

}
