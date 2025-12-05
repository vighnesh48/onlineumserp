<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class QuizMaster extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Quizmaster_model'); 
        $this->load->model('Common_model');
        $this->load->library('session');
        $this->load->helper(['url','form']);
        $this->umsdb = $this->load->database('umsdb', TRUE);

        if(!$this->session->has_userdata('uid')){
            redirect('login');
        }
    }

    // MAIN VIEW PAGE
    public function index(){
        $this->data['subjects'] = $this->Common_model->get_subjects();
        $this->data['questions'] = [];

        $this->load->view('header',  $this->data);
        $this->load->view('quiz/create_quiz', $this->data);
        $this->load->view('footer');
    }

    // SAVE QUIZ & MULTIPLE QUESTIONS
    public function save_multiple_questions(){

        $subject_id  = $this->input->post('subject_id');
        $unit_id     = $this->input->post('unit_id');
        $description = $this->input->post('description');

						
		$quizData = [
		'subject_id'      => $subject_id,
		'unit_id'         => $unit_id,
		'description'     => $description,
		'quiz_time'       => $this->input->post('quiz_time'),
		'negative_marks'  => $this->input->post('negative_marks'),
		'status'          => 1,
		'created_at'      => date('Y-m-d H:i:s')
		];

		$this->umsdb->insert('quiz', $quizData);
		$quiz_id = $this->umsdb->insert_id();

		

	
        // Insert Questions
        $questions = $this->input->post('question_text');
        $option_a  = $this->input->post('option_a');
        $option_b  = $this->input->post('option_b');
        $option_c  = $this->input->post('option_c');
        $option_d  = $this->input->post('option_d');
        $correct   = $this->input->post('correct_option');
        $marks     = $this->input->post('marks');

        foreach ($questions as $index => $q) {
            if(trim($q) != ""){
                $insertData = [
                    'quiz_id'        => $quiz_id,
                    'question_text'  => $q,
                    'option_a'       => $option_a[$index],
                    'option_b'       => $option_b[$index],
                    'option_c'       => $option_c[$index],
                    'option_d'       => $option_d[$index],
                    'correct_option' => $correct[$index],
                    'marks'          => $marks[$index],
                    'status'         => 1,
                    'created_at'     => date('Y-m-d H:i:s')
                ];
                $this->Quizmaster_model->insert_question($insertData);
            }
        }

       $this->session->set_flashdata('msg','Quiz & Questions Saved Successfully');
       redirect('QuizMaster/quiz_list');   // redirect to listing page
    }

    // OPEN QUIZ + ALL QUESTIONS VIEW
    public function create($quiz_id){
        $this->data['subjects']  = $this->Common_model->get_subjects();
        $this->data['quiz_id']   = $quiz_id;
        $this->data['questions'] = $this->Quizmaster_model->get_questions($quiz_id);

        $this->load->view('header', $this->data);
        $this->load->view('quiz/create_quiz', $this->data);
        $this->load->view('footer');
    }

    // AJAX LOAD UNITS
    public function get_units(){
        $subject_id = $this->input->post('subject_id');
        echo json_encode($this->Common_model->get_units_by_subject($subject_id));
    }
	
	
	public function import_excel()
{
    $subject_id = $this->input->post('subject_id');
    $unit_id    = $this->input->post('unit_id');
    $description = $this->input->post('description');

   $this->umsdb->insert('quiz', [
    'subject_id'      => $subject_id,
    'unit_id'         => $unit_id,
    'description'     => $description,
    'quiz_time'       => $this->input->post('quiz_time'),
    'negative_marks'  => $this->input->post('negative_marks'),
    'status'          => 1,
    'created_at'      => date('Y-m-d H:i:s')
]);

$quiz_id = $this->umsdb->insert_id();

    // Excel file uploaded?
    if (!empty($_FILES['excel_file']['name'])) {

        require_once APPPATH.'third_party/PHPExcel.php';

        $path = $_FILES["excel_file"]["tmp_name"];
        $objReader = PHPExcel_IOFactory::createReaderForFile($path);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($path);

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();

        for ($row = 2; $row <= $highestRow; $row++) {
            $data = [
                'quiz_id'        => $quiz_id,
                'question_text'  => $sheet->getCell("A".$row)->getValue(),
                'option_a'       => $sheet->getCell("B".$row)->getValue(),
                'option_b'       => $sheet->getCell("C".$row)->getValue(),
                'option_c'       => $sheet->getCell("D".$row)->getValue(),
                'option_d'       => $sheet->getCell("E".$row)->getValue(),
                'correct_option' => $sheet->getCell("F".$row)->getValue(),
                'marks'          => $sheet->getCell("G".$row)->getValue(),
                'status'         => 1,
                'created_at'     => date('Y-m-d H:i:s')
            ];

            if(trim($data['question_text']) != ""){
                $this->Quizmaster_model->insert_question($data);
            }
        }
    }

    $this->session->set_flashdata('msg', 'Excel Imported Successfully');
    redirect('QuizMaster/quiz_list');
}

public function quiz_list()
{
    $this->data['quizzes'] = $this->Quizmaster_model->get_all_quizzes();

    $this->load->view('header', $this->data);
    $this->load->view('quiz/quiz_list', $this->data);
    $this->load->view('footer');
}

public function questions($quiz_id)
{
    $this->data['quiz']      = $this->Quizmaster_model->get_quiz($quiz_id);
    $this->data['questions'] = $this->Quizmaster_model->get_questions($quiz_id);

    if (!$this->data['quiz']) {
        show_404();
    }

    $this->load->view('header', $this->data);
    $this->load->view('quiz/questions_list', $this->data);
    $this->load->view('footer');
}

public function preview_question($id)
{
    $data['question'] = $this->umsdb->get_where('quiz_questions', ['id' => $id])->row_array();
    $this->load->view('quiz/preview_question', $data);
}

public function edit_question($id)
{
   $this->load->view('header', $this->data);
   $this->data['question'] = $this->umsdb->get_where('quiz_questions',['id'=>$id])->row_array();
   $this->data['quiz'] = $this->umsdb->get_where('quiz',['id'=>$data['question']['quiz_id']])->row_array();
    $this->load->view('quiz/edit_question', $this->data);
	$this->load->view('footer');
}

public function update_question()
{
    $id = $this->input->post('id');

    $data = [
        'question_text' => $this->input->post('question_text'),
        'option_a' => $this->input->post('option_a'),
        'option_b' => $this->input->post('option_b'),
        'option_c' => $this->input->post('option_c'),
        'option_d' => $this->input->post('option_d'),
        'correct_option' => $this->input->post('correct_option'),
        'marks' => $this->input->post('marks')
    ];

    $this->umsdb->where('id', $id)->update('quiz_questions', $data);

    $this->session->set_flashdata('success','Question updated successfully!');
    redirect('QuizMaster/questions/'.$this->input->post('quiz_id'));
}


public function delete_question($id)
{
   $this->umsdb->where('id', $id)->update('quiz_questions', [
        'deleted_at' => date('Y-m-d H:i:s')
    ]);

    $this->session->set_flashdata('msg', 'Question removed successfully!');
    redirect($_SERVER['HTTP_REFERER']);
}

public function deleted_questions($quiz_id)
{
	$this->load->view('header', $this->data);
    
    $this->data['quiz_id'] = $quiz_id;
     $this->data['questions'] = $this->Quizmaster_model->get_deleted_questions($quiz_id);

    $this->load->view('quiz/deleted_questions', $this->data);
	$this->load->view('footer');
}

public function restore_question($id,$quiz_id='')
{
    $this->umsdb->where('id', $id)->update('quiz_questions', ['deleted_at' => NULL]);
    $this->session->set_flashdata('msg', 'Question restored successfully!');
    redirect('QuizMaster/questions/'.$quiz_id);
}

public function delete_quiz($id)
{
    $this->umsdb->where('id', $id)->update('quiz', [
        'deleted_at' => date('Y-m-d H:i:s')
    ]);

    $this->session->set_flashdata('msg', 'Quiz moved to Recycle Bin');
    redirect('QuizMaster/quiz_list');
}


public function student_quiz_list()
{
     $student_id = $this->session->userdata('uid');

    $this->data['quizzes'] = $this->Quizmaster_model->get_student_quizzes($student_id);

    $this->load->view('header', $this->data);
    $this->load->view('quiz/student_quiz_list', $this->data);
    $this->load->view('footer');
}


public function start_quiz($quiz_id)
{
    $student_id = $this->session->userdata('uid');

    // 1. Check mapping
    $assigned = $this->Quizmaster_model->is_assigned($quiz_id, $student_id);
    if (!$assigned) {
        $this->session->set_flashdata('error', 'You are not assigned this quiz.');
        redirect('QuizMaster/student_quiz_list');
    }

    $quiz = $this->Quizmaster_model->get_quiz($quiz_id);
    $questions = $this->Quizmaster_model->get_questions($quiz_id);

    if (!$quiz || empty($questions)) {
        show_404();
    }

    // 2. Check if an in_progress attempt exists
    $attempt = $this->Quizmaster_model->get_open_attempt($student_id, $quiz_id);

    if (!$attempt) {
        $start_time = date('Y-m-d H:i:s');
        $end_time   = date('Y-m-d H:i:s', strtotime("+{$quiz['quiz_time']} minutes"));

        $attempt_id = $this->Quizmaster_model->create_attempt([
            'student_id'       => $student_id,
            'quiz_id'          => $quiz_id,
            'total_marks'      => 0,
            'obtained_marks'   => 0,
            'percentage'       => 0,
            'start_time'       => $start_time,
            'end_time'         => $end_time,
            'student_ip'       => $this->input->ip_address(),
            'user_agent'       => $this->input->user_agent(),
            'tab_switch_count' => 0,
            'status'           => 'in_progress'
        ]);

        $attempt = $this->Quizmaster_model->get_attempt_by_id($attempt_id);
        $this->Quizmaster_model->update_assignment_attempt($quiz_id, $student_id, $attempt_id, 'in_progress');
    }

    // Remaining time in seconds
    $now = time();
    $remaining_seconds = max(0, strtotime($attempt['end_time']) - $now);

    $this->data['quiz']              = $quiz;
    $this->data['questions']         = $questions;
    $this->data['attempt']           = $attempt;
    $this->data['remaining_seconds'] = $remaining_seconds;

    $this->load->view('header', $this->data);
    $this->load->view('quiz/quiz_attempt', $this->data);
    $this->load->view('footer');
}

public function save_answer()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $attempt_id      = $this->input->post('attempt_id');
    $question_id     = $this->input->post('question_id');
    $selected_option = $this->input->post('selected_option');

    $student_id = $this->session->userdata('uid');

    $attempt = $this->Quizmaster_model->get_attempt_by_id($attempt_id);
    if (!$attempt || $attempt['student_id'] != $student_id || $attempt['status'] != 'in_progress') {
        echo json_encode(['status' => false, 'msg' => 'Invalid attempt']);
        return;
    }

    $this->Quizmaster_model->upsert_answer($attempt_id, $question_id, $selected_option);
    $this->Quizmaster_model->log_event($attempt_id, 'answer_saved', "QID: $question_id, Ans: $selected_option");

    echo json_encode(['status' => true]);
}

public function update_tab_count()
{
    if (!$this->input->is_ajax_request()) show_404();

    $attempt_id = $this->input->post('attempt_id');
    $count      = (int)$this->input->post('tab_count');

    $this->umsdb->where('id', $attempt_id)
        ->update('quiz_attempts', ['tab_switch_count' => $count]);

    $this->Quizmaster_model->log_event($attempt_id, 'tab_switch', "Tab switch count: $count");

    echo json_encode(['status' => true]);
}



public function submit_attempt()
{
    if (!$this->input->is_ajax_request()) show_404();

    $attempt_id = $this->input->post('attempt_id');
    $reason     = $this->input->post('reason'); // student | timeout | violation
    $student_id = $this->session->userdata('uid');

    $attempt = $this->Quizmaster_model->get_attempt_by_id($attempt_id);
    if (!$attempt || $attempt['student_id'] != $student_id) {
        echo json_encode(['status' => false, 'msg' => 'Invalid attempt']);
        return;
    }

    if (in_array($attempt['status'], ['submitted', 'auto_submitted'])) {
        echo json_encode([
            'status'   => true,
            'redirect' => site_url('QuizMaster/attempt_result/'.$attempt_id)
        ]);
        return;
    }

    $quiz      = $this->Quizmaster_model->get_quiz($attempt['quiz_id']);
    $questions = $this->Quizmaster_model->get_questions($attempt['quiz_id']);
    $answers   = $this->Quizmaster_model->get_attempt_answers($attempt_id);

    $negative  = (float)$quiz['negative_marks'];
    $total_marks = 0;
    $obtained    = 0;

    // Map question marks & correct_option
    $questionMap = [];
    foreach ($questions as $q) {
        $questionMap[$q['id']] = [
            'marks'          => $q['marks'],
            'correct_option' => $q['correct_option']
        ];
        $total_marks += $q['marks'];
    }

    $this->umsdb->trans_start();

    foreach ($answers as $ans) {
        $qid = $ans['question_id'];

        if (!isset($questionMap[$qid])) continue;

        $correct_option = $questionMap[$qid]['correct_option'];
        $marks_for_q    = $questionMap[$qid]['marks'];

        $marks_obtained = 0;

        if ($ans['selected_option']) {
            if ($ans['selected_option'] == $correct_option) {
                $marks_obtained = $marks_for_q;
            } else {
                $marks_obtained = -$negative;
            }
        }

        $obtained += $marks_obtained;

        $this->Quizmaster_model->update_answer_marks(
            $ans['id'],
            $marks_obtained,
            $correct_option
        );
    }

    $percentage = ($total_marks > 0) ? (($obtained / $total_marks) * 100) : 0;

    $status = ($reason == 'student') ? 'submitted' : 'auto_submitted';

    $this->Quizmaster_model->finalize_attempt($attempt_id, [
        'status'         => $status,
        'total_marks'    => $total_marks,
        'obtained_marks' => $obtained,
        'percentage'     => $percentage,
        'ended_by'       => $reason,
        'end_time'       => date('Y-m-d H:i:s')
    ]);

    $this->Quizmaster_model->update_assignment_attempt(
        $attempt['quiz_id'],
        $student_id,
        $attempt_id,
        'attempted'
    );

    $this->Quizmaster_model->log_event(
        $attempt_id,
        'submit_'.$reason,
        "Quiz submitted by $reason. Score: $obtained / $total_marks (".round($percentage,2)."%)"
    );

    $this->umsdb->trans_complete();

    echo json_encode([
        'status'   => true,
        'redirect' => site_url('QuizMaster/attempt_result/'.$attempt_id)
    ]);
}


public function attempt_result($attempt_id)
{
    // Get attempt info
    $this->data['attempt'] = $this->Quizmaster_model->get_attempt_by_id($attempt_id);

    if(!$this->data['attempt']){
        show_404();
    }

    // Get quiz info
    $this->data['quiz'] = $this->Quizmaster_model->get_quiz($this->data['attempt']['quiz_id']);

    // Get all questions & responses for review screen
    $this->data['questions'] = $this->Quizmaster_model->get_attempt_questions($attempt_id);

    $this->load->view('header', $this->data);
    $this->load->view('quiz/attempt_result', $this->data);  // Create this view file
    $this->load->view('footer');
}

public function download_result_pdf($attempt_id)
{
    ini_set('memory_limit', '4096M');
    ini_set("pcre.backtrack_limit", "1000000");

    $data['attempt']   = $this->Quizmaster_model->get_attempt_details($attempt_id);
    $data['quiz']      = $this->Quizmaster_model->get_quiz_details($data['attempt']['quiz_id']);
    $data['questions'] = $this->Quizmaster_model->get_attempt_questions($attempt_id);

    $filename = "QuizResult-".$data['quiz']['description'].".pdf";

    $html = $this->load->view('quiz/quiz_result_pdf', $data, true);

    $param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
    $this->load->library('m_pdf', $param);

    $this->m_pdf->pdf = new mPDF('utf-8', 'A4', '15', '15', '15', '15');
    $this->m_pdf->pdf->AddPage('P');

    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
    $this->m_pdf->pdf->WriteHTML($html);
    $this->m_pdf->pdf->Output($filename, "D");
}

}
?>
