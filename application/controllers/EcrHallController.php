<?php

class EcrHallController extends CI_Controller {

    /////////////////////////////////////////////////// code by JP ////////////////////////////////////////////////


    public function __construct() {
        parent::__construct();
        $this->load->model('EcrHallModel'); // Load the model
        $menu_name = $this->uri->segment(1);
        $this->load->library('form_validation');
        $this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==25){
		}else{
			redirect('home');
		}
    }

    // Load View with all records
public function index() {
    $filter_data = $this->input->get(); // Assuming you are using GET for filters
    $data['build_id']= $filter_data['building_filter'];
    $data['exam_centers'] = $this->EcrHallModel->getExamCenters();
    $data['floors'] = $this->EcrHallModel->getFloors();
    $data['buildings'] = $this->EcrHallModel->getBuildings();
    $data['halls'] = $this->EcrHallModel->getAllHalls($filter_data); // Assuming method to fetch all halls

  //  print_r($data['halls']);exit;

    $this->load->view('header', $this->data);
    $this->load->view('Ecr/ecr_hall_list', $data); // Adjusted for the list view
    $this->load->view('footer', $this->data);
}


    
    public function addHall() {

        $data['exam_centers'] = $this->EcrHallModel->getExamCenters();
        $data['floors'] = $this->EcrHallModel->getFloors();
        $data['buildings'] = $this->EcrHallModel->getBuildings();
        $this->load->view('header', $this->data); // Assuming you have a header view
        $this->load->view('Ecr/ecr_add_hall', $data); // Load the main view
        $this->load->view('footer', $this->data); // Assuming you have a footer view
    }

    public function saveHall() {
        
        $building_id = $this->input->post('building_id');
        $floor_id = $this->input->post('floor_id');
        $hall_no = $this->input->post('hall_no');
        $hall_type = $this->input->post('hall_type');
        $lab_name = $this->input->post('lab_name');
        $matrix_row = $this->input->post('row_no');
        $matrix_col = $this->input->post('col_no');
        $matrix_extra = $this->input->post('extra_no');
        $capacity = $this->input->post('capacity');
        $created_at = date('Y-m-d H:i:s');
        $created_by = $this->session->userdata('uid');
    
        $this->load->helper('security');
    
        // Validation Rules
        $this->form_validation->set_rules('building_id', 'Building', 'trim|required');
        $this->form_validation->set_rules('floor_id', 'Floor', 'trim|required');
        $this->form_validation->set_rules('hall_no', 'Hall No', 'trim|required');
        $this->form_validation->set_rules('row_no', 'Row No', 'trim|required|numeric|less_than_equal_to[30]');
        $this->form_validation->set_rules('col_no', 'Column No', 'trim|required|numeric|less_than_equal_to[30]');
        $this->form_validation->set_rules('extra_no', 'Extra No', 'trim|required|numeric|less_than_equal_to[30]');
        $this->form_validation->set_rules('capacity', 'Capacity', 'trim|required|numeric');
    
        $data = [
            'building_id' => $building_id,
            'floor' => $floor_id,
            'hall_type' => $hall_type,
            'hall_no' => $hall_no,
            'lab_name' => $lab_name,
            'matrix_rows' => $matrix_row,
            'matrix_columns' => $matrix_col,
            'matrix_extra' => $matrix_extra,
            'capacity' => $capacity,
            'created_at' => $created_at,
            'created_by' => $created_by
        ];
    
        if ($this->form_validation->run() == FALSE) {
            $this->data['input_data'] = $data;  // Pass previously entered data back to the form
            $this->load->view('header', $this->data);
            $this->load->view('Ecr/ecr_add_hall', $this->data);  // Load form with error messages
            $this->load->view('footer', $this->data);
        } else {
            $result = $this->EcrHallModel->saveHall($data);
            if ($result) {
                $this->session->set_flashdata('success', 'Hall Added Successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to Add Hall');
            }
            redirect(base_url('EcrHallController/index'));
        }
    }
    public function getHallDetails($hallId)
{
    $hall = $this->EcrHallModel->getHallById($hallId); // Fetch hall details by ID
    if ($hall) {
        echo json_encode($hall);
    } else {
        echo json_encode(null);
    }
}
public function updateHall($hallId)
{
    // Load required model
    $this->load->model('EcrHallModel');

    // Get input data
    $data = [
        'building_id' => $this->input->post('building_id'),
        'floor' => $this->input->post('floor_id'),
        'hall_no' => $this->input->post('hall_no'),
        'hall_type' => $this->input->post('hall_type'),
        'lab_name' => $this->input->post('lab_name'),
        'matrix_rows' => $this->input->post('row_no'),
        'matrix_columns' => $this->input->post('col_no'),
        'matrix_extra' => $this->input->post('extra_no'),
        'capacity' => $this->input->post('capacity'),
    ];

    // Validate data (optional: add your validation logic here)

    // Update hall in the database
    $updateResult = $this->EcrHallModel->updateHallById($hallId, $data);

    // Check the result and redirect with appropriate message
    if ($updateResult) {
        $this->session->set_flashdata('success', 'Hall details updated successfully!');
    } else {
        $this->session->set_flashdata('error', 'Failed to update hall details.');
    }

    // Redirect back to the hall listing page
    redirect('EcrHallController?building_filter='.$this->input->post('building_id'));
}

    public function examCenterBuilding() {
       
        $data['exam_sessions'] = $this->EcrHallModel->getExamSessions();
        $data['exam_centers'] = $this->EcrHallModel->getExamCenters();
        $data['buildings'] = $this->EcrHallModel->getBuildings();

        // print_r($data['exam_sessions']); die;

        $this->load->view('header', $this->data); // Assuming you have a header view 
        $this->load->view('Ecr/exam_center_building', $data);  // Load the main view  
        $this->load->view('footer', $this->data); // Assuming you have a footer view 
    }

    public function saveExamCenterBuilding() {
        $loggeduserId = $this->session->userdata('uid');
      
        $center_id = $this->input->post('center_id');
        $session_id = $this->input->post('session_id');
        $building_id = $this->input->post('building_id');

        $this->form_validation->set_rules('center_id', 'Exam Center', 'trim|required');
        $this->form_validation->set_rules('session_id', 'Session', 'trim|required');
        $this->form_validation->set_rules('building_id', 'Building', 'trim|required');

        $data = [
            'center_id' => $center_id,
            'exam_id' => $session_id,
            'building_id' => $building_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $loggeduserId
        ];

       

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header', $this->data); 
            $this->load->view('Ecr/exam_center_building', $data); 
            $this->load->view('footer', $this->data); 
        } else {            
            $result = $this->EcrHallModel->saveExamCenterBuilding($data);
            if ($result) {
                $this->session->set_flashdata('success', ' Added Successfully');
                redirect(base_url('EcrHallController/examCenterBuilding'));
            } else {
                $this->session->set_flashdata('error', 'Failed to Add ');
                redirect(base_url('EcrHallController/examCenterBuilding'));
            }
        }
    }


   
    
        /////////////////////////////////////////////////// end ////////////////////////////////////////////////

}
