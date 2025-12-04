<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Program_outcomes extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="program_outcomes";
    var $model_name="Program_outcomes_model";
    var $model;
    var $view_dir='Program_outcomes/';
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
		
        $this->data['stream_id'] = $stream_id = $this->uri->segment(3);
        $this->data['campus_id'] = $campus_id = $this->uri->segment(4);
		$this->data['subject_id'] = $this->uri->segment(3);
		$this->data['campus_id'] = $this->uri->segment(4);
		$this->data['subject'] = $this->Syllabus_model->getProgramById($stream_id,$campus_id); 

        $this->data['program_outcome_det'] = $this->Program_outcomes_model->get_program_outcomes_details('', $stream_id, $campus_id);

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
        $this->data['po'] = $this->Program_outcomes_model->get_program_outcomes_details($id);

        if (!empty($this->data['po'])) {
            $this->data['stream_id'] = $this->data['po']['program_id'];
            $this->data['campus_id'] = $this->data['po']['campus_id'];
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
        $this->form_validation->set_rules('po_number', 'PO Number', 'required|max_length[10]');
        $this->form_validation->set_rules('po_description', 'PO Description', 'required');
        $this->form_validation->set_rules('campus_id', 'Campus ID', 'required');
        $this->form_validation->set_rules('program_id', 'Program ID', 'required');

        $stream_id = $this->input->post('program_id');
        $campus_id = $this->input->post('campus_id');

        if ($this->form_validation->run() === FALSE) {
            if ($id) $this->edit($id);
            else $this->add();
            return;
        }

        $data = [
            'po_number' => $this->input->post('po_number'),
            'po_description' => $this->input->post('po_description'),
            'campus_id' => $campus_id,
            'program_id' => $stream_id
        ];

        if ($id) {
            $DB->where('id', $id)->update($this->table_name, $data);
            $this->session->set_flashdata('success', 'Program Outcome updated successfully.');
        } else {
            $DB->insert($this->table_name, $data);
            $this->session->set_flashdata('success', 'Program Outcome added successfully.');
        }

        redirect($this->currentModule . '/index/' . $stream_id . '/' . $campus_id);
    }

    public function disable($id)
    {
		$DB = $this->load->database('obe', TRUE);
        $po = $this->Program_outcomes_model->get_program_outcomes_details($id);
        if ($po) {
            $DB->where('id', $id)->update($this->table_name, ['status' => 0]);
            $this->session->set_flashdata('success', 'Program Outcome disabled.');
            redirect($this->currentModule . '/index/' . $po['program_id'] . '/' . $po['campus_id']);
        }
    }

    public function enable($id)
    {
		$DB = $this->load->database('obe', TRUE);
        $po = $this->Program_outcomes_model->get_program_outcomes_details($id);
        if ($po) {
            $DB->where('id', $id)->update($this->table_name, ['status' => 1]);
            $this->session->set_flashdata('success', 'Program Outcome enabled.');
            redirect($this->currentModule . '/index/' . $po['program_id'] . '/' . $po['campus_id']);
        }
    }
	public function import_excel() {
		 $subject_id = $this->input->post('subject_id');
		$campus_id = $this->input->post('campus_id');
		if (!$subject_id) {
			$this->session->set_flashdata('message', 'Program ID is required.');
			redirect('program_outcomes/index/' . $subject_id.'/'.$campus_id);
		}
		$this->load->library('excel');
		$DB3 = $this->load->database('obe', TRUE);
		if (!empty($_FILES['excel_file']['name'])) {
			//echo 11;exit;
			$allowed = ['xls', 'xlsx'];
			$ext = pathinfo($_FILES['excel_file']['name'], PATHINFO_EXTENSION);

			if (!in_array($ext, $allowed)) {
				$this->session->set_flashdata('message', 'Invalid file type. Only .xls or .xlsx allowed.');
				redirect('program_outcomes/index/' . $subject_id.'/'.$campus_id);
			}

			$path = $_FILES['excel_file']['tmp_name'];
			$object = PHPExcel_IOFactory::load($path);
			$topic_id = 0;

			foreach ($object->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();

				for ($row = 2; $row <= $highestRow; $row++) {
					$co_number         = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
					$co_description         = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
					
						$DB3->insert('program_outcomes', [
							
							'campus_id'  => $campus_id,
							'program_id'  => $subject_id,
							'po_number' => $co_number,
							'po_description' => $co_description,
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

    redirect('program_outcomes/index/' . $subject_id.'/'.$campus_id);
		
}
	
}
?>