<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assignment extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Assignment_model');
        $this->load->helper(['form','url','encryption_helper']);
    }

    # ---------- FACULTY ----------
    public function create(){
        $faculty_id = $this->session->userdata('faculty_id');
       // $subject_id = $this->input->get('subject_id');
        $subject_id = 21083;
        $campus_id  = 1;

        $data['subject_id'] = $subject_id;
        $data['campus_id']  = $campus_id;
        $data['plans']      = $this->Assignment_model->lecture_plans($subject_id=21083,$faculty_id=110194,$campus_id=1);
        $data['questions']  = []; // loaded via AJAX by topic/subtopic
        $this->load->view('assignment/create_fast', $data);
    }

    public function ajax_questions(){
        $plan_id = $this->input->post('plan_id');
        $rows = $this->Assignment_model->get_questions_for_plan($plan_id);
        echo json_encode($rows);
    }

    public function store(){
        $faculty_id = $this->session->userdata('name');

        $payload = [
            'campus_id'       => $this->input->post('campus_id'),
            'subject_id'      => $this->input->post('subject_id'),
            'faculty_id'      => $faculty_id,
            'lecture_plan_id' => $this->input->post('lecture_plan_id'),
            'topic_id'        => $this->input->post('topic_id'),
            'subtopic_id'     => $this->input->post('subtopic_id'),
            'title'           => $this->input->post('title'),
            'description'     => $this->input->post('description'),
            'due_date'        => $this->input->post('due_date'),
            'max_marks'       => $this->input->post('max_marks'),
            'question_ids'    => $this->input->post('question_ids') ?: [],
            'student_ids'     => $this->input->post('student_ids') ?: []
        ];

        $id = $this->Assignment_model->create_assignment($payload);
        if (!$id) $this->session->set_flashdata('error','Failed to create assignment.');
        else      $this->session->set_flashdata('success','Assignment created.');
        redirect('assignment/my');
    }

   public function my($subject_id, $campus_id)
	{
		$subject_id = decrypt_id($subject_id);
		if (!$subject_id || !is_numeric($subject_id)) {
			show_error("Invalid request", 403);
		}
		$faculty_id = $this->session->userdata('name');
		$data['list'] = $this->Assignment_model->faculty_assignments($faculty_id, $subject_id, $campus_id);

		$this->load->view('header', $data);
		$this->load->view('assignment/faculty_list', $data);
		$this->load->view('footer', $data);
	}


    public function evaluate(){
        $assignment_id = $this->input->post('assignment_id');
        $student_id    = $this->input->post('student_id');
        $marks         = $this->input->post('marks_obtained');
        $feedback      = $this->input->post('feedback');
        $ok = $this->Assignment_model->evaluate($assignment_id, $student_id, $marks, $feedback, $this->session->userdata('name'));
        echo $ok ? 'OK' : 'ERR';
    }

    # ---------- STUDENT ----------
    public function student11(){
        $student_id = $this->session->userdata('student_id');
        $data['list'] = $this->Assignment_model->student_assignments($student_id=28689);
        $this->load->view('assignment/student_list_fast', $data);
    }
	public function student()
	{
		$student_id = $this->session->userdata('student_id');

		// flat list (subject_id, subject_name included)
		$rows = $this->Assignment_model->get_student_assignments($student_id=12041);

		// group by subject
		$grouped = [];           // [ "<subject_id>|<subject_name>" => [rows...] ]
		$subjectCounts = [];     // subject => count
		foreach ($rows as $r) {
			$key = $r->subject_id . '|' . $r->subject_name;
			if (!isset($grouped[$key])) $grouped[$key] = [];
			$grouped[$key][] = $r;
			$subjectCounts[$key] = ($subjectCounts[$key] ?? 0) + 1;
		}

		$data['grouped'] = $grouped;
		$data['subjectCounts'] = $subjectCounts;

		// You can keep your old fast view; this is the new tabs view:
		$this->load->view('assignment/student_list_subject_tabs', $data);
	}
	// View assignment with questions
    public function student_view($assignment_id) {
        $student_id = $this->session->userdata('student_id');
        $data['assignment'] = $this->Assignment_model->get_assignment_details($assignment_id, $student_id=12041);
        $data['questions']  = $this->Assignment_model->get_assignment_questions($assignment_id);
        $this->load->view('assignment/student_view', $data);
    }
    // Submit assignment
    public function student_submit() {
        $assignment_id = $this->input->post('assignment_id');
        $student_id    = $this->session->userdata('student_id');
        $student_id    = 12041;

        $answer = [
            'answer_text' => $this->input->post('answer_text'),
            'submitted_at' => date('Y-m-d H:i:s'),
            'status' => 'Submitted'
        ];

        if (!empty($_FILES['answer_file']['name'])) {
            $config = [
                'upload_path'   => './uploads/assignment_submissions/',
                'allowed_types' => 'pdf|doc|docx|zip|png|jpg|jpeg',
                'max_size'      => 5120
            ];
            if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, true);
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('answer_file')) {
                $u = $this->upload->data();
                $answer['answer_file'] = $u['file_name'];
            }
        }

        $this->Assignment_model->submit_answer($assignment_id, $student_id, $answer);
        redirect('assignment/student');
    }
	public function view($id)
	{
		$id = decrypt_id($id);
        if (!$id || !is_numeric($id)) {
            show_error("Invalid request", 403);
        }
		// make sure this route is faculty-only in your auth layer
		$data['assignment'] = $this->Assignment_model->assignment_detail($id);
		if (!$data['assignment']) { show_404(); }

		// questions mapped to this assignment
		$data['questions']  = $this->Assignment_model->assignment_questions($id);

		// students mapped (with names)
		$data['students']   = $this->Assignment_model->assignment_students_with_names($id);

		// pretty context from lecture plan (topic/subtopic names)
		$data['context']    = $this->Assignment_model->assignment_context($data['assignment']);
		$this->load->view('header',$data);
        $this->load->view('assignment/faculty_view', $data);
		$this->load->view('footer',$data);
		
	}
	public function close_assignment($id)
	{
		$assignment_id = decrypt_id($id);
		$faculty_id = $this->session->userdata('name');

		// Verify assignment ownership
		$assignment = $this->Assignment_model->getAssignmentById($assignment_id);
		if (!$assignment || $assignment->faculty_id != $faculty_id) {
			show_error('Unauthorized access', 403);
		}

		// Close assignment
		$this->Assignment_model->closeAssignment($assignment_id);

		$this->session->set_flashdata('success', 'Assignment closed successfully!');
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function reopen_assignment($id)
	{
		$assignment_id = decrypt_id($id);
		$faculty_id = $this->session->userdata('name');

		// Verify assignment ownership
		$assignment = $this->Assignment_model->getAssignmentById($assignment_id);
		if (!$assignment || $assignment->faculty_id != $faculty_id) {
			show_error('Unauthorized access', 403);
		}

		// Reopen assignment
		$this->Assignment_model->reopenAssignment($assignment_id);

		$this->session->set_flashdata('success', 'Assignment reopened successfully!');
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function update_cia1($subject_id, $campus_id)
	{
		$subject_id = decrypt_id($subject_id);

		if (!$subject_id || !is_numeric($subject_id)) {
			show_error("Invalid subject ID", 403);
		}

		$this->load->model('Assignment_model');

		$this->Assignment_model->calculate_cia1_marks($subject_id, $campus_id);

		$this->session->set_flashdata('success', 'CIA-1 marks calculated and updated successfully.');
		redirect('assignment/my/' . encrypt_id($subject_id) . '/' . $campus_id);
	}

	public function download_cia_report($subject_id, $campus_id)
{
    // ==== 1️⃣ Campus-wise DB selection ====
    $this->obe = $this->load->database('obe', TRUE);
    $campusDB = null;
    if ($campus_id == 3) {
        $campusDB = $this->load->database('sfumsdb', TRUE); // SF Nashik
    } elseif ($campus_id == 2) {
        $campusDB = $this->load->database('sjumsdb', TRUE); // Sijoul
    } elseif ($campus_id == 1) {
        $campusDB = $this->load->database('umsdb', TRUE); // Nashik
    }
    $subject_id = decrypt_id($subject_id);

    // ==== 2️⃣ Fetch subject details ====
    $subject = $campusDB->select('subject_name, semester, subject_code')
                        ->from('subject_master')
                        ->where('sub_id', $subject_id)
                        ->get()
                        ->row();
    if (!$subject) show_error("Subject not found for this campus", 404);

    // ==== 3️⃣ Fetch CIA Data ====
    $this->obe->select('sia.student_id, sia.cia_marks_outof10, sia.cia_number');
    $this->obe->from('student_internal_assessment sia');
    $this->obe->where('sia.subject_id', $subject_id);
    $this->obe->where('sia.campus_id', $campus_id);
    $this->obe->where('sia.cia_number', 1); // CIA-1
    $studentsCia = $this->obe->get()->result_array();
    if (empty($studentsCia)) show_error("No CIA data found for this subject.", 404);

    // ==== 4️⃣ Get student details ====
    $studentIds = array_column($studentsCia, 'student_id');
    $studentsInfo = $campusDB->select('stud_id, enrollment_no, first_name as full_name')
                             ->from('student_master')
                             ->where_in('stud_id', $studentIds)
                             ->get()
                             ->result_array();
    $infoMap = [];
    foreach ($studentsInfo as $s) $infoMap[$s['stud_id']] = $s;

    // ==== 5️⃣ Prepare report data ====
    $reportData = [];
    foreach ($studentsCia as $row) {
        $sid = $row['student_id'];
        $reportData[] = [
            'enrollment_no' => $infoMap[$sid]['enrollment_no'] ?? '-',
            'full_name'     => $infoMap[$sid]['full_name'] ?? '-',
            'cia_marks'     => number_format($row['cia_marks_outof10'], 2)
        ];
    }

    // ==== 6️⃣ Generate compact PDF ====
    $this->load->library('m_pdf');
    $html = '
    <html>
    <head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 10px; }
        .header img { height: 65px; }
        .uni-title { font-size: 18px; font-weight: bold; color:#000; margin-top: 5px; }
        .report-title { font-size: 14px; font-weight: bold; margin: 3px 0 8px; }
        .subinfo { font-size: 12px; color: #333; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; }
        th { background-color: #f3f4f8; font-weight: 700; text-align:center; }
        td { text-align: center; }
        tr:nth-child(even) { background-color: #fafafa; }
        .footer { margin-top: 30px; }
        .footer td { border: none; text-align: center; padding-top: 40px; font-size: 12px; }
        .sign-line { border-top: 1px solid #000; width: 150px; margin: auto; }
        .timestamp { font-size: 10px; color: #666; text-align:right; margin-top:10px; }
    </style>
    </head>
    <body>

    <div class="header">
        <img src="https://www.sandipuniversity.edu.in/images/logo-dark.png" width="30%"><br>
        <div class="uni-title">SANDIP UNIVERSITY</div>
        <div class="report-title">Continuous Internal Assessment Report (CIA - 1)</div>
        <div class="subinfo">
            <strong>Subject:</strong> '.htmlspecialchars($subject->subject_name).' ('.$subject->subject_code.')<br>
            <strong>Semester:</strong> '.htmlspecialchars($subject->semester).'
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Enrollment No</th>
                <th>Student Name</th>
                <th>CIA Marks (Out of 10)</th>
            </tr>
        </thead>
        <tbody>';
        $i = 1;
        foreach ($reportData as $r) {
            $html .= '
            <tr>
                <td>'.$i++.'</td>
                <td>'.htmlspecialchars($r['enrollment_no']).'</td>
                <td style="text-align:left;">'.htmlspecialchars($r['full_name']).'</td>
                <td>'.$r['cia_marks'].'</td>
            </tr>';
        }
        $html .= '
        </tbody>
    </table>

    <div class="footer">
        <table width="100%">
            <tr>
                <td><div class="sign-line"></div><b>Faculty Signature</b></td>
                <td><div class="sign-line"></div><b></b></td>
                <td><div class="sign-line"></div><b></b></td>
            </tr>
        </table>
        <div class="timestamp"><i>Generated on '.date('d-m-Y H:i').'</i></div>
    </div>

    </body>
    </html>';

    // ==== 7️⃣ Output PDF ====
    $pdfFilePath = 'CIA1_Report_'.$subject->subject_name.'_'.date('Ymd').'.pdf';
    $mpdf = new mPDF('utf-8', 'A4', '10', '10', '10', '5', '5', '5');
    $mpdf->autoScriptToLang = true;
    $mpdf->baseScript = 1;
    $mpdf->autoVietnamese = true;
    $mpdf->SetDisplayMode('fullpage');

    // ✅ Page number footer
    $mpdf->SetHTMLFooter('
        <div style="text-align: right; font-size: 10px; color: #555;">
            Page {PAGENO} of {nb}
        </div>
    ');

    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
    $mpdf->WriteHTML($html);
    $mpdf->Output($pdfFilePath, "D");
}




}
