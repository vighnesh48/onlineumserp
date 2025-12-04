<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assignment_question_bank extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Assignment_question_bank_model');
        $this->load->model('Lecture_plan_model');
        $this->load->model('Syllabus_model');
        $this->load->helper(['form', 'url']);
        $this->load->library('upload');
    }

    public function index($subject_id,$campus_id) {
		$subject_id = decrypt_id($subject_id);
        if (!$subject_id || !is_numeric($subject_id)) {
            show_error("Invalid request", 403);
        }
		$data['subject_id'] = $subject_id;
        $data['campus_id'] = $campus_id;
		$data['questions'] = $this->Assignment_question_bank_model->get_all_questions($subject_id, $campus_id);
		$data['subject'] = $this->Syllabus_model->getSubjectById($subject_id,$campus_id); // fetch subject name/code
		$this->load->view('header',$data);
		$this->load->view('Assignment_question_bank/list', $data);
		$this->load->view('footer');

    }

    public function add($subject_id,$campus_id) {
		$data['subject_id'] = $subject_id;
        $data['campus_id'] = $campus_id;
		$data['blooms_levels'] = $this->Assignment_question_bank_model->get_blooms_levels('blooms_levels');
		$data['topics'] = $this->Lecture_plan_model->get_topics_by_subject($subject_id,$campus_id);
		$this->load->view('header',$data);
        $this->load->view('Assignment_question_bank/create');
		$this->load->view('footer');
    }

    public function insert() {
        $config['upload_path'] = 'uploads/assignment_questions/';
        $config['allowed_types'] = 'pdf|jpg|png|jpeg|doc|docx';
        $config['max_size'] = 2048;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        $this->upload->initialize($config);
        $file_name = null;

        if ($this->upload->do_upload('question_file')) {
            $file_data = $this->upload->data();
            $file_name = $file_data['file_name'];
        }
		$subject_id=$this->input->post('subject_id');
        $campus_id=$this->input->post('campus_id');
        $data = [
            'campus_id' => $this->input->post('campus_id'),
            'subject_id' => $this->input->post('subject_id'),
            'topic_id' => $this->input->post('topic_id'),
            'subtopic_id' => $this->input->post('subtopic_id') ?: null,
            'question_text' => $this->input->post('question_text'),
            'question_file' => $file_name,
            'marks' => $this->input->post('marks'),
            'course_outcome' => $this->input->post('course_outcome'),
            'blooms_level' => $this->input->post('blooms_level_id'),
            'source_exam' => $this->input->post('source_exam'),
            'added_by' => 1, // change with session
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->Assignment_question_bank_model->insert($data);
        redirect('assignment_question_bank/index/'.encrypt_id($subject_id).'/'.$campus_id);
    }

    public function delete($id,$subject_id,$campus_id) {
        $this->Assignment_question_bank_model->delete($id);
        redirect('assignment_question_bank/index/'.encrypt_id($subject_id).'/'.$campus_id);
    }
	public function edit($id) {
		$this->load->model('Assignment_question_bank_model');
		$data['question'] = $this->Assignment_question_bank_model->get_by_id($id);

		if (!$data['question']) {
			show_404();
		}

		$data['campus_id'] = $data['question']->campus_id;
		$data['subject_id'] = $data['question']->subject_id;

		// Fetch topics and blooms levels
		$data['topics'] = $this->Lecture_plan_model->get_topics_by_subject($data['subject_id'], $data['campus_id']);
		$data['blooms_levels'] = $this->Assignment_question_bank_model->get_blooms_levels('blooms_levels');
		$this->load->view('header',$data);
		$this->load->view('Assignment_question_bank/edit', $data);
		$this->load->view('footer');
	}

	public function update($id) {
		$this->load->model('Assignment_question_bank_model');
		 
		$data = [
			'topic_id' => $this->input->post('topic_id'),
			'subtopic_id' => $this->input->post('subtopic_id'),
			'question_text' => $this->input->post('question_text'),
			'marks' => $this->input->post('marks'),
			'course_outcome' => $this->input->post('course_outcome'),
			'blooms_level' => $this->input->post('blooms_level'),
			'source_exam' => $this->input->post('source_exam'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		$subject_id=$this->input->post('subject_id');
        $campus_id=$this->input->post('campus_id');
		// Handle file upload
		if (!empty($_FILES['question_file']['name'])) {
			 $config['upload_path'] = 'uploads/assignment_questions/';
			$config['allowed_types'] = 'pdf|jpg|png|jpeg|doc|docx';
			$config['max_size'] = 2048;
			
			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'], 0777, true);
			}
			$this->upload->initialize($config);
			//$this->load->library('upload', $config);

			if ($this->upload->do_upload('question_file')) {
				$fileData = $this->upload->data();
				$data['question_file'] = $fileData['file_name'];
			} else {
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('error', $error);
				//echo $error;exit;
			}
		}

		$this->Assignment_question_bank_model->update($id, $data);
		$this->session->set_flashdata('success', 'Question updated successfully');
		redirect('assignment_question_bank/index/'.encrypt_id($subject_id).'/'.$campus_id);
	}


}
