<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Course_outcomes extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="Course_outcomes";
    var $model_name="Course_outcomes_model";
    var $model;
    var $view_dir='Course_outcomes/';
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
		$this->load->model('Syllabus_model');
        $sub_id = $this->data['sub_id'] = $this->uri->segment(3);
        $campus_id = $this->data['campus_id'] = $this->uri->segment(4);
		$this->data['subject_id'] = $sub_id;
		$this->data['campus_id'] = $campus_id;
		$this->data['subject'] = $this->Syllabus_model->getSubjectById($sub_id,$campus_id); // fetch subject name/code
		//print_r($data['subject']);
        $this->data['course_outcome_det'] = $this->Course_outcomes_model->get_course_outcomes_details('', $sub_id, $campus_id);
        $this->load->view('header', $this->data);
        $this->load->view($this->view_dir . 'view', $this->data);
        $this->load->view('footer');
    }

    public function add()
    {
        $this->data['sub_id'] = $sub_id = $this->uri->segment(3);
        $this->data['campus_id'] = $campus_id = $this->uri->segment(4);
        $this->load->view('header', $this->data);
        $this->load->view($this->view_dir . 'add', $this->data);
        $this->load->view('footer');
    }

    public function edit()
    {
        $id = $this->uri->segment(3);
        $this->data['co'] = $this->Course_outcomes_model->get_course_outcomes_details($id);

        if (!empty($this->data['co'])) {
            $this->data['sub_id'] = $this->data['co']['subject_id'];
            $this->data['campus_id'] = $this->data['co']['campus_id'];
        } else {
            $this->data['sub_id'] = '';
            $this->data['campus_id'] = '';
        }

        $this->load->view('header', $this->data);
        $this->load->view($this->view_dir . 'add', $this->data);
        $this->load->view('footer');
    }

    public function submit($id = null)
    {
		
		$DB = $this->load->database('obe', TRUE); 
        $this->form_validation->set_rules('co_number', 'CO Number', 'required|max_length[10]');
        $this->form_validation->set_rules('co_description', 'CO Description', 'required');
        $this->form_validation->set_rules('subject_id', 'Subject ID', 'required');
        $this->form_validation->set_rules('campus_id', 'Campus ID', 'required');

        $sub_id = $this->input->post('subject_id');
        $campus_id = $this->input->post('campus_id');

        if ($this->form_validation->run() === FALSE) {
            if ($id) $this->edit($id);
            else $this->add();
            return;
        }

        $subject_details = $this->Course_outcomes_model->get_subjects_details($sub_id, $campus_id);
        $subject_code = $subject_details ? $subject_details->subject_code : '';

        $data = [
            'subject_id' => $sub_id,
            'subject_code' => $subject_code,
            'campus_id' => $campus_id,
            'co_number' => $this->input->post('co_number'),
            'co_description' => $this->input->post('co_description')
        ];

        if ($id) {
            $DB->where('id', $id)->update('course_outcomes', $data);
            $this->session->set_flashdata('success', 'Course Outcome updated successfully.');
        } else {
            $DB->insert('course_outcomes', $data);
            $this->session->set_flashdata('success', 'Course Outcome added successfully.');
        }

        redirect($this->currentModule . '/index/' . $sub_id . '/' . $campus_id);
    }

    public function disable($id)
    {
		$DB = $this->load->database('obe', TRUE);
        $co = $this->Course_outcomes_model->get_course_outcomes_details($id);
        if ($co) {
            $DB->where('id', $id)->update('course_outcomes', ['status' => 0]);
            $this->session->set_flashdata('success', 'Course Outcome disabled.');
            redirect($this->currentModule . '/index/' . $co['subject_id'] . '/' . $co['campus_id']);
        }
    }

    public function enable($id)
    {
		$DB = $this->load->database('obe', TRUE);
        $co = $this->Course_outcomes_model->get_course_outcomes_details($id);
        if ($co) {
            $DB->where('id', $id)->update('course_outcomes', ['status' => 1]);
            $this->session->set_flashdata('success', 'Course Outcome enabled.');
            redirect($this->currentModule . '/index/' . $co['subject_id'] . '/' . $co['campus_id']);
        }
    }
	public function import_excel() {
		 $subject_id = $this->input->post('subject_id');
		$campus_id = $this->input->post('campus_id');
		if (!$subject_id) {
			$this->session->set_flashdata('message', 'Subject ID is required.');
			redirect('course_outcomes/index/' . $subject_id.'/'.$campus_id);
		}
		$this->load->library('excel');
		$DB3 = $this->load->database('obe', TRUE);
		if (!empty($_FILES['excel_file']['name'])) {
			//echo 11;exit;
			$allowed = ['xls', 'xlsx'];
			$ext = pathinfo($_FILES['excel_file']['name'], PATHINFO_EXTENSION);

			if (!in_array($ext, $allowed)) {
				$this->session->set_flashdata('message', 'Invalid file type. Only .xls or .xlsx allowed.');
				redirect('course_outcomes/index/' . $subject_id.'/'.$campus_id);
			}

			$path = $_FILES['excel_file']['tmp_name'];
			$object = PHPExcel_IOFactory::load($path);
			$topic_id = 0;

			foreach ($object->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();

				for ($row = 2; $row <= $highestRow; $row++) {
					$co_number         = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
					$co_description         = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
					
						$DB3->insert('course_outcomes', [
							
							'campus_id'  => $campus_id,
							'subject_id'  => $subject_id,
							'co_number' => $co_number,
							'co_description' => $co_description,
							//'inserted_on' => date('Y-m-d H:i:s')
						]);
						 //$DB3->insert_id(); // Save for subtopics
						//echo 1; echo $DB3->last_query();exit;
				}
			}

			$this->session->set_flashdata('message', 'Excel imported successfully!');
    } else {
        $this->session->set_flashdata('message', 'No file selected.');
    }

    redirect('course_outcomes/index/' . $subject_id.'/'.$campus_id);
		
}
	public function deletesubjectcos($subject_id,$campus_id) {
        $this->Course_outcomes_model->deletesubjectcos($subject_id,$campus_id);
        redirect('Course_outcomes/index/' . $subject_id.'/'.$campus_id);
    }
}
?>