<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_marks_entry extends CI_Controller {

    	public function __construct(){        
		global $menudata;      
		parent::__construct();       
		$this->load->helper("url");     
		$this->load->library('form_validation');        
		if($this->uri->segment(2) != "" && $this->uri->segment(2) != "submit" && !in_array($this->uri->segment(2), $this->skipActions))
		$title = $this->uri->segment(2); //Second segment of uri for action,In case of edit,view,add etc.       
		else
		$title = $this->master_arr['index'];
		$this->currentModule = $this->uri->segment(1);    
		$this->data['currentModule'] = $this->currentModule;       
		$this->data['model_name'] = $this->model_name;             
		$this->load->library('form_validation');       
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
       
		$model = $this->load->model($this->model_name);
		

		$this->load->model('Exam_marks_model');
		$menu_name = $this->uri->segment(1);
        
		$this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
		$this->load->library('Awssdk');
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==26){
		}else{
			redirect('home');
		}
        
	}

    public function index() {
		
		$this->load->view('header',$this->data); 
        $data['exam_list'] = $this->Exam_marks_model->get_exam_list();

     //  print_r($data['exam_list'][0]);exit;

    //    echo 'hii';
        if (!empty($this->input->post('barcode'))) {

        //    echo 'hii';exit;
            $barcode = $this->input->post('barcode');
            $exam_id = $this->input->post('exam_id');

            // Fetch data based on barcode from the model
            $data['exam_data'] = $this->Exam_marks_model->get_exam_data($barcode , $exam_id);

          //  print_r($data);exit;
            // If exam data found, load the view with exam details
            if ($data['exam_data']) {
                $this->load->view('Marks/exam_view', $data);
            } else {
                $this->session->set_flashdata('error', 'Invalid barcode , No Student Found For This Barcode');
                redirect('exam_marks_entry');
            }
        } 
        else{
            
            $this->load->view('Marks/exam_view' , $data);

        }
		 $this->load->view('footer');
    }

    public function save_marks() {
        $marks = $this->input->post('marks');
    
        // Get the current date
        $current_date = date('Y-m-d');
    
        // Get the exam data from the model
        $exam_data = $this->Exam_marks_model->get_exam_data($this->input->post('barcode'), $this->input->post('exam_id'));
    
        // Check if data is fetched successfully
        if (!empty($exam_data)) {
    
            // Check if the current date is between th_date_start and th_date_end
            if ($current_date >= $exam_data['th_date_start'] && $current_date <= $exam_data['th_date_end']) {
    
                // Check if marks are within range
                if ($marks <= $exam_data['theory_max']) {
                    // Call the model function to insert marks

                    if ($this->Exam_marks_model->is_marks_entry_exists($exam_data['exam_id'], $exam_data['subject_id'], $this->input->post('barcode'))) {

                        // If data already exists, update marks

                      //  $this->Exam_marks_model->update_marks($marks, $exam_data);

                      $this->session->set_flashdata('error', "Marks entry for this barcode ".$exam_data['barcode']." is already exists. Please enter marks for a different barcode.");
                      redirect('exam_marks_entry');
                        
                    } else {

                        // If data doesn't exist, insert marks

                        $this->Exam_marks_model->insert_marks($marks, $exam_data);
						$this->session->set_flashdata('success', "Marks entry successful for barcode ".$exam_data['barcode']." .");

                    }    
                    // Redirect to the same page
                    redirect('exam_marks_entry');
                } else {
                    // If marks are not within range, set error message and redirect
                    $this->session->set_flashdata('error', "Marks should be less than or equal to ".$exam_data['theory_max']);
                    redirect('exam_marks_entry');
                }
            } else {
                // If the current date is not within the range, show error message and redirect
                $this->session->set_flashdata('error', "Marks entry is not allowed for the current date.");
                redirect('exam_marks_entry');
            }
        } else {
            echo "No exam data found.";
        }
    }
    
    
}
?>
