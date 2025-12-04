<?php
class Departments_vision extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Departments_vision_model');
        $this->load->helper(['form', 'url']);
    }

    public function index() {
        $data['visions'] = $this->Departments_vision_model->get_all();
		$this->load->view('header',$this->data);
        $this->load->view('departments_vision/list', $data);
		$this->load->view('footer');
    }

    public function create($campus_id=null) {
        $data['institutes'] = $this->Departments_vision_model->get_institutes($campus_id=1);
		//print_r($data['institutes']);
		$this->load->view('header',$this->data);
        $this->load->view('departments_vision/create', $data);
		$this->load->view('footer');
    }

    public function store() {
		//echo 11;exit;
        $data = [
            'institutes_id' => $this->input->post('institutes_id'),
            'department_id' => $this->input->post('department_id'),
            'vision'        => $this->input->post('vision'),
            'mission'       => $this->input->post('mission'),
            'admission_batch' => $this->input->post('academic_year'),
            'status'        => $this->input->post('status'),
        ];
        $this->Departments_vision_model->insert($data);
        redirect('departments_vision');
    }

    public function edit($id,$campus_id=1) {
        $data['vision']     = $this->Departments_vision_model->get_by_id($id);
		$data['institutes_id'] = $data['vision']->institutes_id;
		$data['department_id'] = $data['vision']->department_id;
        $data['institutes'] = $this->Departments_vision_model->get_institutes($campus_id=1);
		$this->load->view('header',$this->data);
        $this->load->view('departments_vision/edit', $data);
		$this->load->view('footer');
    }

    public function update($id) {
        $data = [
            'institutes_id' => $this->input->post('institutes_id'),
            'department_id' => $this->input->post('department_id'),
            'vision'        => $this->input->post('vision'),
            'mission'       => $this->input->post('mission'),
            'admission_batch' => $this->input->post('academic_year'),
            'status'        => $this->input->post('status'),
        ];
        $this->Departments_vision_model->update($id, $data);
        redirect('departments_vision');
    }

    public function delete($id) {
        $this->Departments_vision_model->delete($id);
        redirect('departments_vision');
    }
	function load_courses(){
		
		if(isset($_POST["school_code"]) && !empty($_POST["school_code"])){
			//Get all city data
			$stream = $this->Departments_vision_model->get_courses($_POST["school_code"], $_POST["campus_id"]);
           // print_r($stream);exit;
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Course</option>';
				foreach($stream as $value){
					if(isset($_POST['admission_course']) && ($_POST['admission_course']==$value['course_id']) )
					{
						$seel="selected";

					}
					else
					{
						$seel='';

					}
					echo '<option value="' . $value['course_id'] . '" '.$seel.' >' . $value['course_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">Course not available</option>';
			}
		}
	}
	// fetch exam strams
	function load_streams(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["course_id"]) && !empty($_POST["course_id"])){
			//Get all streams
			$stream = $this->Departments_vision_model->getStreamsBySchoolCourse($_POST["course_id"], $_POST["campus_id"], $_POST["school_code"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Stream</option>';
				foreach($stream as $value){
					if(isset($_POST['stream_id']) && ($_POST['stream_id']==$value['stream_id']))
					{
						$seel="selected";

					}
					else
					{
						$seel='';

					}
					echo '<option value="' . $value['stream_id'] . '" '.$seel.'>' . $value['stream_name'] . '</option>';
				}
			} else{
				echo '<option value="">stream not available</option>';
			}
		}
	}
}
