<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quizmaster_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->umsdb = $this->load->database('umsdb', TRUE);
    }

    /* ================= QUIZ ================= */

    public function get_quiz($quiz_id){
        return $this->umsdb->get_where('quiz', [
            'id'     => $quiz_id,
            'status' => 1
        ])->row_array();
    }

    public function get_quiz_by_subject_unit($subject_id, $unit_id){
        return $this->umsdb->get_where('quiz', [
            'subject_id' => $subject_id,
            'unit_id'    => $unit_id,
            'status'     => 1
        ])->row_array();
    }

    /* ================= QUESTIONS ================= */

    public function get_questions($quiz_id){
        $this->umsdb->where('deleted_at IS NULL', NULL, FALSE);
        return  $questions = $this->umsdb->get_where('quiz_questions', ['quiz_id' => $quiz_id])->result_array();
    }

    public function insert_question($data){
        $this->umsdb->insert('quiz_questions', $data);
        return $this->umsdb->insert_id();
    }

    /* ================= ATTEMPTS ================= */

    public function has_attempted($student_id, $quiz_id){
        return $this->umsdb->where([
                'student_id' => $student_id,
                'quiz_id'    => $quiz_id
            ])
            ->count_all_results('quiz_attempts') > 0;
    }

    public function save_attempt($data){
        $this->umsdb->insert('quiz_attempts', $data);
        return $this->umsdb->insert_id();
    }

    public function get_attempt($student_id, $quiz_id){
        return $this->umsdb->get_where('quiz_attempts', [
            'student_id' => $student_id,
            'quiz_id'    => $quiz_id
        ])->row_array();
    }
	
public function get_all_quizzes()
{
    return $this->umsdb
        ->select("quiz.*, 
                  subject_master.subject_name,
                  syllabus_topics.topic_title,
                  COUNT(quiz_questions.id) AS total_questions")
        ->from("quiz")
        ->join("subject_master","subject_master.sub_id = quiz.subject_id","left")
        ->join("syllabus_topics","syllabus_topics.topic_id = quiz.unit_id","left")
        ->join("quiz_questions","quiz_questions.quiz_id = quiz.id AND quiz_questions.status = 1","left")
        ->where("quiz.status", 1)
        ->where("quiz.deleted_at", '')   // Corrected
        ->group_by("quiz.id")
        ->order_by("quiz.id", "DESC")
        ->get()
        ->result_array();
}

public function get_deleted_questions($quiz_id)
    {
        $this->umsdb->where('quiz_id', $quiz_id);
        $this->umsdb->where('deleted_at IS NOT NULL', NULL, FALSE);
        return $this->umsdb->get('quiz_questions')->result_array();
    }

public function get_student_quizzes($student_id)
{
    return $this->umsdb
    ->select("quiz.*, 
              subject_master.subject_name,
              quiz_student_map.status AS attempt_status,
              quiz_attempts.obtained_marks,
              quiz_attempts.total_marks,
              quiz_attempts.percentage,
              quiz_attempts.id AS attempt_id")
    ->from("quiz_student_map")
    ->join("quiz", "quiz.id = quiz_student_map.quiz_id")
    ->join("subject_master", "subject_master.sub_id = quiz.subject_id", "left")
    ->join("quiz_attempts", "quiz_attempts.id = quiz_student_map.attempt_id", "left")
    ->where("quiz.deleted_at","")
    ->where("quiz.status", 1)
    ->where("quiz_student_map.student_id", $student_id)
    ->order_by("quiz.id", "DESC")
    ->get()
    ->result_array();
}




// Get open attempt (in_progress) for this quiz + student
public function get_open_attempt($student_id, $quiz_id)
{
    return $this->umsdb
        ->get_where('quiz_attempts', [
            'student_id' => $student_id,
            'quiz_id'    => $quiz_id,
            'status'     => 'in_progress'
        ])->row_array();
}

public function create_attempt($data)
{
    $this->umsdb->insert('quiz_attempts', $data);
    return $this->umsdb->insert_id();
}

public function get_attempt_by_id($attempt_id)
{
    return $this->umsdb->get_where('quiz_attempts', ['id' => $attempt_id])->row_array();
}

public function update_assignment_attempt($quiz_id, $student_id, $attempt_id, $status)
{
    // quiz_student_map: link attempt + status
    $this->umsdb->where([
        'quiz_id'    => $quiz_id,
        'student_id' => $student_id
    ])->update('quiz_student_map', [
        'attempt_id' => $attempt_id,
        'status'     => $status
    ]);
}

public function get_question($id)
{
    return $this->umsdb->get_where('quiz_questions', ['id' => $id])->row_array();
}

// Insert / update answer each time
public function upsert_answer($attempt_id, $question_id, $selected_option)
{
    $row = $this->umsdb->get_where('quiz_attempt_answers', [
        'attempt_id'  => $attempt_id,
        'question_id' => $question_id
    ])->row_array();

    if ($row) {
        $this->umsdb->where('id', $row['id'])
            ->update('quiz_attempt_answers', [
                'selected_option' => $selected_option
            ]);
    } else {
        $this->umsdb->insert('quiz_attempt_answers', [
            'attempt_id'      => $attempt_id,
            'question_id'     => $question_id,
            'selected_option' => $selected_option
        ]);
    }
}

public function get_attempt_answers($attempt_id)
{
    return $this->umsdb
        ->get_where('quiz_attempt_answers', ['attempt_id' => $attempt_id])
        ->result_array();
}

public function update_answer_marks($answer_id, $marks_obtained, $correct_option)
{
    $this->umsdb->where('id', $answer_id)
        ->update('quiz_attempt_answers', [
            'marks_obtained' => $marks_obtained,
            'correct_option' => $correct_option
        ]);
}

public function finalize_attempt($attempt_id, $data)
{
	
	
    $this->umsdb->where('id', $attempt_id)->update('quiz_attempts', $data);
	
}

public function log_event($attempt_id, $event_type, $message)
{
    $this->umsdb->insert('quiz_attempt_logs', [
        'attempt_id' => $attempt_id,
        'event_type' => $event_type,
        'message'    => $message
    ]);
}


public function is_assigned($quiz_id, $student_id)
    {
        return $this->umsdb
            ->get_where('quiz_student_map', [
                'quiz_id'    => $quiz_id,
                'student_id' => $student_id
            ])
            ->row_array();
    }
	
	


public function get_attempt_questions($attempt_id)
{
    return $this->umsdb
        ->select("quiz_questions.*, quiz_attempt_answers.selected_option, quiz_attempt_answers.marks_obtained")
        ->from("quiz_attempt_answers")
        ->join("quiz_questions","quiz_questions.id = quiz_attempt_answers.question_id")
        ->where("quiz_attempt_answers.attempt_id", $attempt_id)
        ->get()
        ->result_array();
}

public function get_attempt_details($attempt_id)
{
    return $this->umsdb->get_where('quiz_attempts', ['id' => $attempt_id])->row_array();
}

public function get_quiz_details($quiz_id)
{
    return $this->umsdb->get_where('quiz', ['id' => $quiz_id])->row_array();
}


}
?>
