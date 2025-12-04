<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Program_educational_objectives extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="program_educational_objectives";
    var $model_name="Program_educational_objectives_model";
    var $model;
    var $view_dir='Program_educational_objectives/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        $this->load->helper("url");		
        $this->load->library('form_validation');
        
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
           $title=$this->master_arr['index'];
       
        $this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        
        $model = $this->load->model($this->model_name);
        
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);        
    }
    
    public function index()
    {
        $this->data['stream_id'] = $stream_id = $this->uri->segment(3);
        $this->data['campus_id'] = $campus_id = $this->uri->segment(4);

        $this->data['peo_list'] = $this->Program_educational_objectives_model->get_program_edu_obj_details('', $stream_id, $campus_id);
        $this->load->view('header', $this->data);            
        $this->load->view($this->view_dir . 'view', $this->data);
        $this->load->view('footer');
    }

    public function add()
    {
        $this->data['stream_id'] = $stream_id = $this->uri->segment(3);
        $this->data['campus_id'] = $campus_id = $this->uri->segment(4);

        $this->load->view('header', $this->data);
        $this->load->view($this->view_dir . 'add', $this->data);
        $this->load->view('footer');
    }

    public function edit()
    {
        $id = $this->uri->segment(3);
        $this->data['peo'] = $this->Program_educational_objectives_model->get_program_edu_obj_details($id);

        if (!empty($this->data['peo'])) {
            $this->data['stream_id'] = $this->data['peo']['program_id'];
            $this->data['campus_id'] = $this->data['peo']['campus_id'];
        } else {
            $this->data['stream_id'] = '';
            $this->data['campus_id'] = '';
        }

        $this->load->view('header', $this->data);
        $this->load->view($this->view_dir . 'add', $this->data);
        $this->load->view('footer');
    }

    public function submit($id = null)
    {
		
		$DB = $this->load->database('obe', TRUE);
        $this->form_validation->set_rules('program_id', 'Program', 'required');
        $this->form_validation->set_rules('campus_id', 'Campus', 'required');
        $this->form_validation->set_rules('peo_number', 'PEO Number', 'required|max_length[10]');
        $this->form_validation->set_rules('peo_description', 'PEO Description', 'required');

        $stream_id = $this->input->post('program_id');
        $campus_id = $this->input->post('campus_id');

        if ($this->form_validation->run() === FALSE) {
            if ($id) $this->edit($id);
            else $this->add();
            return;
        }

        $data = [
            'program_id' => $stream_id,
            'campus_id' => $campus_id,
            'peo_number' => $this->input->post('peo_number'),
            'peo_description' => $this->input->post('peo_description'),
            'status' => 1
        ];

        if ($id) {
            $DB->where('peo_id', $id)->update($this->table_name, $data);
            $this->session->set_flashdata('success', 'PEO updated successfully.');
        } else {
            $DB->insert($this->table_name, $data);
            $this->session->set_flashdata('success', 'PEO added successfully.');
        }

        redirect($this->currentModule . '/index/' . $stream_id . '/' . $campus_id);
    }

    public function disable($id)
    {
		$DB = $this->load->database('obe', TRUE);
        $peo = $this->Program_educational_objectives_model->get_program_edu_obj_details($id);
        if ($peo) {
            $DB->where('peo_id', $id)->update($this->table_name, ['status' => 0]);
            $this->session->set_flashdata('success', 'PEO disabled.');
            redirect($this->currentModule . '/index/' . $peo['program_id'] . '/' . $peo['campus_id']);
        }
    }

    public function enable($id)
    {
		$DB = $this->load->database('obe', TRUE);
        $peo = $this->Program_educational_objectives_model->get_program_edu_obj_details($id);
        if ($peo) {
            $DB->where('peo_id', $id)->update($this->table_name, ['status' => 1]);
            $this->session->set_flashdata('success', 'PEO enabled.');
            redirect($this->currentModule . '/index/' . $peo['program_id'] . '/' . $peo['campus_id']);
        }
    }
	
}
?>