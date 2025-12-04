<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_model extends CI_Model {

    public function get_quiz($quiz_id)
    {
        return $this->db->get_where('quiz', ['id' => $quiz_id, 'status' => 1])->row_array();
    }

    public function get_questions($quiz_id)
    {
        return $this->db->get_where('quiz_questions', [
            'quiz_id' => $quiz_id,
            'status'  => 1
        ])->result_array();
    }

    public function insert_question($data)
    {
        $this->db->insert('quiz_questions', $data);
        return $this->db->insert_id();
    }

    public function has_attempted($student_id, $quiz_id)
    {
        return $this->db->where([
            'student_id' => $student_id,
            'quiz_id'    => $quiz_id
        ])->count_all_results('quiz_attempts') > 0;
    }

    public function save_attempt($data)
    {
        return $this->db->insert('quiz_attempts', $data);
    }

    public function get_attempt($student_id, $quiz_id)
    {
        return $this->db->get_where('quiz_attempts', [
            'student_id' => $student_id,
            'quiz_id'    => $quiz_id
        ])->row_array();
    }
}
