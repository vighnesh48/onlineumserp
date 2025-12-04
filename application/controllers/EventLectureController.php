<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EventLectureController extends CI_Controller {


    var $currentModule="";
    var $title="";
    var $table_name="";
    var $model_name="Eventlecturemodel";
    var $model;
    var $view_dir='Swap_timetable/';
    var $data=array();

    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        ini_set('memory_limit','-1');
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

        $this->load->model('Eventlecturemodel');
    }	

    public function index() {
        $this->load->view('header',$this->data); 
        $filters = $this->input->post();
		$this->load->model('Timetable_model');
        $this->data['academic_years']= $this->Timetable_model->fetch_Allacademic_session(); 
        //$this->data['academic_years'] = $this->Eventlecturemodel->get_academic_years();
        $this->data['school_details'] = $this->Eventlecturemodel->getSchools();
      //  $this->data['time_slots'] = $this->EventLectureModel->get_time_slots();
        $this->data['events'] = $this->Eventlecturemodel->get_events($filters);
        
        $this->load->view('Swap_timetable/event_lecture_view', $this->data);
        $this->load->view('footer');
    }
    public function get_time_slots_ajax() {
        $academic_year = $this->input->post('academic_year');
        $course_id = $this->input->post('course_id');
        $stream_id = $this->input->post('stream_id');
        $semester = $this->input->post('semester');
        $division = $this->input->post('division');
    
        $time_slots = $this->Eventlecturemodel->get_time_slots($academic_year, $course_id, $stream_id, $semester, $division);
    
        echo json_encode($time_slots);
    }
    
     public function insert_event() {
        $data = $this->input->post();
    
        // Handle special case for stream_id = 9
        if (isset($data['stream_id']) && $data['stream_id'] == 9) {
            $stream_ids = [5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279];
        } else {
            $stream_ids = [$data['stream_id']];
        }
    
        // Check if multiple slots are selected
        if (!empty($data['time_slot'])) {
            $slot_ids = explode(',', $data['time_slot']);
            unset($data['time_slot']); // Remove time_slot from original array
    
            foreach ($stream_ids as $stream_id) {
                foreach ($slot_ids as $slot_id) {
                    $data['stream_id'] = $stream_id;
                    $data['time_slot'] = $slot_id;
                    $this->Eventlecturemodel->insert_event($data);
                }
            }
        } else {
            // No slots selected
            foreach ($stream_ids as $stream_id) {
                $data['stream_id'] = $stream_id;
				//print_r($data);exit;
                $this->Eventlecturemodel->insert_event($data);
            }
        }
    
        echo json_encode(["status" => "success"]);
    }
    
    public function get_event($id) {
        echo json_encode($this->Eventlecturemodel->get_event_by_id($id));
    }

    public function update_event($id) {
        $this->data = $this->input->post();
    
        $update = $this->Eventlecturemodel->update_event($id, $this->data);
    
        if ($update) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed."]);
        }
    }

    public function toggle_status($id, $status) {
        $this->Eventlecturemodel->toggle_status($id, $status);
        redirect('EventLectureController');
    }

    public function delete_event($id) {
        $this->Eventlecturemodel->delete_event($id);
        redirect('EventLectureController');
    }
}
