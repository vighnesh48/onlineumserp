<?php
class Seating extends CI_Controller
{
	
	var $currentModule = "";
	var $title = "";
	var $table_name = "unittest_master";
	var $model_name = "Seating_model";
	var $model;
	var $view_dir = 'Seating/'; 

	public function __construct()
	{

		// error_reporting(E_ALL); ini_set('display_errors', 1);
		global $menudata;
		parent::__construct();
		$this->load->helper("url");
		$this->load->library('form_validation');
		$this->load->library('excel');
		if ($this->uri->segment(2) != "" && $this->uri->segment(2) != "submit" && !in_array($this->uri->segment(2), $this->skipActions))
			$title = $this->uri->segment(2); //Second segment of uri for action,In case of edit,view,add etc.       
		else
			$title = $this->master_arr['index'];
		$this->currentModule = $this->uri->segment(1);
		$this->data['currentModule'] = $this->currentModule;
		$this->data['model_name'] = $this->model_name;
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$model = $this->load->model($this->model_name);
		$menu_name = $this->uri->segment(1);
        $this->load->model('EcrEmpRegModel');
		$this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
		$this->load->model('Seating_model');
		        $user_name = $this->session->userdata('name'); // this should be email
        // echo $user_name;
    
        // Store center_id in session if matching active entry exists

        $centerData = $this->EcrEmpRegModel->getCenterIdIfUserExists($user_name);

        if (!empty($centerData)) {
            $center_ids = array_column($centerData, 'center_id'); // extract only center_id values
            $this->session->set_userdata('center_ids', $center_ids);
        }
        $center_ids = $this->session->userdata('center_ids');

	}

    public function index()
    {
		//error_reporting(1);
        $this->load->view('header', $this->data);
        $this->load->model('Seating_model');

        // Handle AJAX requests
        $building_id = $this->input->get('building_id');
        $floor_id = $this->input->get('floor_id');

        if ($building_id) {
            $floors = $this->Seating_model->get_floors($building_id);
            echo json_encode(['floors' => $floors]);
            return;
        }

        if ($floor_id) {
            $halls = $this->Seating_model->get_halls($floor_id, $building_id);
            echo json_encode(['halls' => $halls]);
            return;
        }

        // Handle form submission
        $exam_id = $this->input->post('exam_id') ?: $this->input->get('exam_id');
        $date = $this->input->post('date') ?: $this->input->get('date');
        $building_id = $this->input->post('building_id') ?: $this->input->get('building_id');
        $floor_id = $this->input->post('floor_id') ?: $this->input->get('floor_id');
        $hall_ids = $this->input->post('hall_ids') ?: $this->input->get('hall_ids');
        $subject_codes = $this->input->post('subject_ids') ?: $this->input->get('subject_ids');
		$subject_id_list = [];
        $stream_id_list = [];

        if (is_array($subject_codes)) {
            foreach ($subject_codes as $pair) {
                [$sub_id, $stream_id] = explode('~', $pair);
                $subject_id_list[] = $sub_id;
                $stream_id_list[] = $stream_id;
            }
        }
        $session = $this->input->post('session') ?: $this->input->get('session');
        $seating_type = $this->input->post('seating_type') ?: $this->input->get('seating_type');
		
        $hall_id_json = implode(',', $hall_ids);

        //  print_r($session);exit;

        $sub_id_count = count($subject_id_list);

        //  print_r($sub_id_count);exit;

        if (!is_array($subject_codes)) {
            $subject_codes = [];
        }
		// print_r($subject_codes);exit;
		$students = array();
		if(!empty($subject_codes)){
			$students = $this->Seating_model->get_students($exam_id, $subject_codes, $date, $session);
		}
        //
		//echo'11212212';exit;
        if ($hall_ids) {
            $halls = $this->Seating_model->get_selected_halls($floor_id, $building_id, $hall_ids);
        }

        if($exam_id != ''){

            $this->data = [
                'seatingArrangement' => $this->Seating_model->create_seating($students, $halls, $floor_id, $sub_id_count, $seating_type),
                'exams' => $this->Seating_model->get_all_exams(),
                'subjects' => $this->Seating_model->get_all_subjects($exam_id, $date, $session),
                'buildings' => $this->Seating_model->get_buildings(),
                'floors' => $this->Seating_model->get_floors($building_id),
                'halls' => $this->Seating_model->get_halls($floor_id, $building_id, $exam_id, $date, $session),
                'selected_exam' => $exam_id,
                'selected_date' => $date,
                'selected_session' => $session,
                'selected_building' => $building_id,
                'selected_floor' => $floor_id,
                'selected_halls' => $hall_id_json,
                'selected_subjects' => $subject_codes,
                'selected_seating_type' => $seating_type,
            ];
        }
        else{
            $this->data = [
                'seatingArrangement' => [],
                'exams' => $this->Seating_model->get_all_exams(),
                'subjects' => [],
                'buildings' => $this->Seating_model->get_buildings(),
                'floors' => [],
                'halls' => [],
                'selected_exam' => '',
                'selected_date' => '',
                'selected_session' => '',
                'selected_building' => '',
                'selected_floor' => '',
                'selected_halls' => '',
                'selected_subjects' => '',
                'selected_seating_type' => '',
            ];
        }
        //  echo '<pre>';
        //  print_r($data['seatingArrangement']);exit;

       $this->load->view('Seating/seating_chart', $this->data);
        $this->load->view('footer');
    }
    public function get_subjects()
    {
        $this->load->model('Seating_model');
        $exam_id = $this->input->post('exam_id');
        $date = $this->input->post('date');
        $session = $this->input->post('session');

        if ($exam_id && $date) {
            $subjects = $this->Seating_model->get_all_subjects($exam_id, $date, $session);
            echo json_encode(['subjects' => $subjects]);
        } else {
            echo json_encode(['subjects' => []]);
        }
    }
    public function get_students_by_subject()
    {
        $subject_id = $this->input->post('subject_id');
		$subject_id_list = [];
        $stream_id_list = [];

        if (is_array($subject_id)) {
            foreach ($subject_id as $pair) {
                [$sub_id, $stream_id] = explode('~', $pair);
                $subject_id_list[] = $sub_id;
                $stream_id_list[] = $stream_id;
            }
        }					  
		
        $exam_id = $this->input->post('exam_id');
        $date = $this->input->post('date');
        $session = $this->input->post('session');
        $students = $this->Seating_model->get_students($exam_id, $subject_id, $date, $session); // Adjust with your model and method
       // print_r($students);exit;
        echo json_encode(['students' => $students]);
    }

    public function get_floors()
    {
        $building_id = $this->input->get('building_id');
        $floors = $this->Seating_model->get_floors($building_id);
        echo json_encode(['floors' => $floors]);
    }
    public function get_halls()
    {
        $floor_id = $this->input->get('floor_id');
        $building_id = $this->input->get('building_id');
        $exam_id = $this->input->get('exam_id');
        $date = $this->input->get('exam_date');
        $session = $this->input->get('session');
        $halls = $this->Seating_model->get_halls($floor_id, $building_id, $exam_id, $date, $session);
        echo json_encode(['halls' => $halls]);
    }

    public function saveSeatingArrangement()
    {

        // Get RAW JSON data from request body
        $jsonData = file_get_contents("php://input");
        $decodedData = json_decode($jsonData, true);

        $seatingData = $decodedData['seating_data'];
       //   print_r( $seatingData);exit;
        if (!$decodedData || empty($decodedData['seating_data'])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data']);
            return;
        }

        $insertedRecords = 0;
        $existingEntries = 0;


        foreach ($seatingData as $hallEntry) {

            // Check if the entry already exists in the database
            $exists = $this->Seating_model->checkExistingEntry(
                $hallEntry['exam_id'],
                $hallEntry['exam_date'],
                $hallEntry['session'],
                $hallEntry['building'],
                $hallEntry['floor'],
                $hallEntry['hall']
            );

            if ($exists) {
                $existingEntries++;
                continue; // Skip inserting this record
            }

            $data = [
                'exam_id' => $hallEntry['exam_id'],
                'exam_date' => $hallEntry['exam_date'],
                'session' => $hallEntry['session'], 
                'building' => $hallEntry['building'],
                'floor' => $hallEntry['floor'],
                'hall' => $hallEntry['hall'],
                'seating_arrangement' => json_encode($hallEntry['seating_arrangement']),
                'inserted_at' => date('Y-m-d H:i:s'),
                'inserted_by' => $this->session->userdata('uid')
            ];

            $result = $this->Seating_model->saveSeatingArrangement($data);
            if ($result) {
                $insertedRecords++;
            }
        }

    // Return response JSON
    $response = [
        'status' => $insertedRecords > 0 ? 'success' : 'error',
        'message' => $insertedRecords > 0 
            ? "$insertedRecords hall seating arrangements saved successfully" 
            : ($existingEntries > 0 
                ? "$existingEntries hall seating arrangements already exist" 
                : "Failed to save seating arrangements")
    ];

    echo json_encode($response);

    redirect('Seating/index');

    }


  /*  public function seating_update() {
        // Load dropdown options for exam sessions, dates, and sessions
        $data['exam_sessions'] = $this->SeatingModel->get_exam_sessions();
        $data['exam_dates'] = $this->SeatingModel->get_exam_dates();
        $data['sessions'] = ['FN' => 'Forenoon', 'AN' => 'Afternoon'];
        
        $this->load->view('seating_arrangement_view', $data);
    }

    public function fetchSeatingData() {
        $exam_id = $this->input->post('exam_id');
        $exam_date = $this->input->post('exam_date');
        $session = $this->input->post('session');

        if (!$exam_id || !$exam_date || !$session) {
            echo json_encode(['status' => 'error', 'message' => 'Please select all filters.']);
            return;
        }

        $data = $this->SeatingModel->get_seating_data($exam_id, $exam_date, $session);

        if ($data) {
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No data found for the selected criteria.']);
        }
    } */




}
