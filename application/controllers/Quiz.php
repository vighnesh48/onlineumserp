<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Quiz_model');
        $this->load->library('session');
        $this->load->helper(['url','form']);
    }

    // FACULTY: Add MCQ Questions to quiz
    public function add_question($quiz_id)
    {
        if ($this->input->post())
        {
            $data = [
                'quiz_id'       => $quiz_id,
                'question_text' => $this->input->post('question_text'),
                'option_a'      => $this->input->post('option_a'),
                'option_b'      => $this->input->post('option_b'),
                'option_c'      => $this->input->post('option_c'),
                'option_d'      => $this->input->post('option_d'),
                'correct_option'=> $this->input->post('correct_option'),
                'marks'         => $this->input->post('marks'),
                'status'        => 1
            ];

            $this->Quiz_model->insert_question($data);
            $this->session->set_flashdata('msg', 'Question Added Successfully');
            redirect('quiz/add_question/'.$quiz_id);
        }

        $data['quiz'] = $this->Quiz_model->get_quiz($quiz_id);
        $data['questions'] = $this->Quiz_model->get_questions($quiz_id);

        $this->load->view('quiz/faculty_add_question', $data);
    }

    // STUDENT: Take Quiz
    public function take_quiz($quiz_id)
    {
        $student_id = $this->session->userdata('student_id');

        if ($this->Quiz_model->has_attempted($student_id, $quiz_id))
        {
            $data['attempt'] = $this->Quiz_model->get_attempt($student_id, $quiz_id);
            $this->load->view('quiz/already_attempted', $data);
            return;
        }

        $data['quiz'] = $this->Quiz_model->get_quiz($quiz_id);
        $data['questions'] = $this->Quiz_model->get_questions($quiz_id);

        $this->load->view('quiz/take_quiz', $data);
    }

    // SUBMIT QUIZ
    public function submit_quiz($quiz_id)
    {
        $student_id = $this->session->userdata('student_id');

        if ($this->Quiz_model->has_attempted($student_id, $quiz_id)) {
            redirect('quiz/take_quiz/'.$quiz_id);
        }

        $questions = $this->Quiz_model->get_questions($quiz_id);
        $total = 0; $obtained = 0;

        foreach ($questions as $q) {
            $total += $q['marks'];
            $answer = $this->input->post("q_".$q['id']);
            if ($answer == $q['correct_option']) {
                $obtained += $q['marks'];
            }
        }

        $this->Quiz_model->save_attempt([
            'student_id'     => $student_id,
            'quiz_id'        => $quiz_id,
            'total_marks'    => $total,
            'obtained_marks' => $obtained
        ]);

        $data['total'] = $total;
        $data['obtained'] = $obtained;

        $this->load->view('quiz/quiz_result', $data);
    }
}
