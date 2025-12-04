<?php
class Institutes_vision extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Institutes_vision_model');
        $this->load->helper(['form', 'url']);
    }

    public function index() {
        $data['visions'] = $this->Institutes_vision_model->get_all();
		$this->load->view('header',$this->data);
        $this->load->view('institutes_vision/list', $data);
		$this->load->view('footer');
    }

    public function create($campus_id=null) {
        $data['institutes'] = $this->Institutes_vision_model->get_institutes($campus_id=1);
		//print_r($data['institutes']);
		$this->load->view('header',$this->data);
        $this->load->view('institutes_vision/create', $data);
		$this->load->view('footer');
    }

    public function store() {
		//echo 11;exit;
        $data = [
            'institutes_id' => $this->input->post('institutes_id'),
            'vision'        => $this->input->post('vision'),
            'mission'       => $this->input->post('mission'),
            'academic_year' => $this->input->post('academic_year'),
            'status'        => $this->input->post('status'),
        ];
        $this->Institutes_vision_model->insert($data);
        redirect('institutes_vision');
    }

    public function edit($id,$campus_id=1) {
        $data['vision']     = $this->Institutes_vision_model->get_by_id($id);
        $data['institutes'] = $this->Institutes_vision_model->get_institutes($campus_id=1);
		$this->load->view('header',$this->data);
        $this->load->view('institutes_vision/edit', $data);
		$this->load->view('footer');
    }

    public function update($id) {
        $data = [
            'institutes_id' => $this->input->post('institutes_id'),
            'vision'        => $this->input->post('vision'),
            'mission'       => $this->input->post('mission'),
            'academic_year' => $this->input->post('academic_year'),
            'status'        => $this->input->post('status'),
        ];
        $this->Institutes_vision_model->update($id, $data);
        redirect('institutes_vision');
    }

    public function delete($id) {
        $this->Institutes_vision_model->delete($id);
        redirect('institutes_vision');
    }
}
