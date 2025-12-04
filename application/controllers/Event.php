<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Event extends CI_Controller
{
    var $currentModule = "";
    var $title = "";
    var $table_name = "event_master";
    var $model_name = "Event_model";
    var $model;
    var $view_dir = 'Event/';
    var $data = array();
    public function __construct()
    {
        global $menudata;
        parent::__construct();

        $this->load->helper("url");
        $this->load->library('form_validation');
        date_default_timezone_set('Asia/Kolkata');

        if ($this->uri->segment(2) != "" && $this->uri->segment(2) != "submit" && !in_array($this->uri->segment(2), $this->skipActions))
            $title = $this->uri->segment(2);
        else
            $title = $this->master_arr['index'];


        $this->currentModule = $this->uri->segment(1);
        $this->data['currentModule'] = $this->currentModule;
        $this->data['model_name'] = $this->model_name;

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);

        $menu_name = $this->uri->segment(1);
        $this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
    }

    public function index()
    {
        $this->load->library('pagination');

        $search = $this->input->get('search');
        $limit = $this->input->get('limit') ? (int)$this->input->get('limit') : 10;
        $offset = $this->uri->segment(3) ? (int)$this->uri->segment(3) : 0;

        $config['base_url'] = base_url('Event/index');
        $config['total_rows'] = $this->Event_model->count_events($search);
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $this->data['events'] = $this->Event_model->get_events($limit, $offset, $search);
        $this->data['pagination_links'] = $this->pagination->create_links();
        $this->data['search'] = $search;
        $this->data['limit'] = $limit;

        $this->load->view('header', $this->data);

        $this->load->view($this->view_dir . 'view', $this->data);
        $this->load->view('footer');
    }


    public function add_event()
    {
        $this->load->view('header', $this->data);
        $this->data['schools'] = $this->Event_model->get_schools();
        $this->data['academic_years'] = $this->Event_model->get_academic_years();
        $this->data['school_details'] = $this->Event_model->getSchools();

        $this->load->view($this->view_dir . 'add_event', $this->data);
        $this->load->view('footer');
    }

    public function save_event()
    {
        $this->load->helper('security');
        $event_name = $this->input->post('event_name', TRUE);
        $organised_by = $this->input->post('organised_by', TRUE);
        $start_date = $this->input->post('start_date', TRUE);
        $end_date = $this->input->post('end_date', TRUE);
        $start_time = $this->input->post('start_time', TRUE);
        $end_time = $this->input->post('end_time', TRUE);
        $school_id = $this->input->post('school_id', TRUE);
        $course_id = $this->input->post('course_id', TRUE);
        $stream_id = $this->input->post('stream_id', TRUE);
        $academic_year = $this->input->post('academic_year', TRUE);
        $event_address = $this->input->post('event_address', TRUE);
        $event_description = $this->input->post('event_description', TRUE);

        $this->form_validation->set_rules('event_name', 'Event Name', 'required|trim|alpha_numeric_spaces|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('organised_by', 'Organised By', 'required|trim|alpha_numeric_spaces|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|trim|callback_validate_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|trim|callback_validate_date|callback_validate_end_date');
        $this->form_validation->set_rules('start_time', 'Start Time', 'required|trim|callback_validate_time');
        $this->form_validation->set_rules('end_time', 'End Time', 'required|trim|callback_validate_time|callback_validate_end_time');
        $this->form_validation->set_rules('school_id', 'School', 'required');
        $this->form_validation->set_rules('course_id', 'Course', 'required');
        $this->form_validation->set_rules('stream_id', 'Stream', 'required');
        $this->form_validation->set_rules('academic_year', 'Stream', 'required');

        $this->form_validation->set_rules('event_address', 'Event Address', 'required|trim|min_length[5]|max_length[255]|htmlspecialchars');
        $this->form_validation->set_rules('event_description', 'Event Description', 'required|trim|min_length[2]|max_length[500]|htmlspecialchars');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message_event_error', 'Event Not Added. Please Provide Proper Input');
            $this->load->view('header', $this->data);
            $this->load->view($this->view_dir . 'add_event', $this->data);
            $this->load->view('footer');
        } else {
            $insert_array = [
                'event_name' => $event_name,
                'organised_by' => $organised_by,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'school_id' => $school_id,
                'course_id' => $course_id,
                'stream_id' => $stream_id,
                'academic_year' => $academic_year,
                'event_address' => $event_address,
                'event_description' => $event_description,
                'created_by' => $this->session->userdata('uid'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->Event_model->insert_event($insert_array);


            if ($result) {
                $this->session->set_flashdata('message_event_success', 'Event Added Successfully.');
                redirect(base_url($this->view_dir . '/'));
            } else {
                $this->session->set_flashdata('message_event_error', 'Event Not Added Successfully.');
                redirect(base_url($this->view_dir . 'add_event'));
            }
        }
    }

    public function validate_date($date)
    {
        if (DateTime::createFromFormat('Y-m-d', $date) !== FALSE) {
            return TRUE;
        } else {
            $this->form_validation->set_message('validate_date', 'The {field} must be in YYYY-MM-DD format.');
            return FALSE;
        }
    }

    public function validate_end_date($end_date)
    {
        $start_date = $this->input->post('start_date');
        if (strtotime($end_date) >= strtotime($start_date)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('validate_end_date', 'The End Date must be after the Start Date.');
            return FALSE;
        }
    }

    public function validate_time($time)
    {
        if (preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $time)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('validate_time', 'The {field} must be in HH:MM (24-hour) format.');
            return FALSE;
        }
    }

    public function validate_end_time($end_time)
    {
        $start_time = $this->input->post('start_time');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        if ($start_date == $end_date && strtotime($end_time) <= strtotime($start_time)) {
            $this->form_validation->set_message('validate_end_time', 'The End Time must be after the Start Time when both dates are the same.');
            return FALSE;
        }
        return TRUE;
    }

    public function upload_event_photos()
    {
        $this->load->view('header', $this->data);
        $this->data['event_id'] = base64_decode($this->uri->segment(3));
        $this->data['event'] = $this->Event_model->get_event($this->data['event_id']);
        $this->load->view($this->view_dir . 'upload_event_photos', $this->data);
        $this->load->view('footer');
    }


    public function save_event_images()
    {
        $event_id = $this->input->post('event_id', TRUE);

        if (!empty($_FILES['event_pdf']['name'])) {
            $this->Event_model->save_event_pdf($event_id, $_FILES['event_pdf']);
        }

        $this->session->set_flashdata('message_event_success', 'Event PDF uploaded successfully.');
        redirect(base_url($this->view_dir . '/'));
    }


    function load_courses()
    {
        if ($_POST["school_code"] != '') {

            $stream = $this->Event_model->get_courses($_POST["school_code"]);

            echo $rowCount = count($stream);

            echo '<option value="">Select Course</option>';
            echo '<option value="0">All Course</option>';
            foreach ($stream as $value) {
                echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
            }
        }
    }

    function load_streams()
    {
        if ($_POST["course_id"] != '') {
            $stream = $this->Event_model->get_streams($_POST["course_id"], $_POST["school_code"]);

            $rowCount = count($stream);

            echo '<option value="">Select Stream</option>';
            echo '<option value="0">All Stream</option>';
            foreach ($stream as $value) {
                echo '<option value="' . $value['stream_id'] . '" >' . $value['stream_name'] . '</option>';
            }
        }
    }

    public function event_allocation($event_id)
    {



        $this->load->view('header', $this->data);

        $event_id = base64_decode($event_id);
        $event_data = $this->Event_model->get_event_detail_by_id($event_id);

        $this->data['event_data'] = $event_data;
        // $this->data['academic_years'] = $this->Event_model->get_academic_years();
        // $this->data['school_details'] = $this->Event_model->getSchools();
        $this->load->view($this->view_dir . 'event_allocation_view', $this->data);
        $this->load->view('footer');
    }

    public function get_time_slots_ajax()
    {
        $academic_year = $this->input->post('academic_year');
        $course_id = $this->input->post('course_id');
        $stream_id = $this->input->post('stream_id');
        $semester = $this->input->post('semester');
        $division = $this->input->post('division');

        $time_slots = $this->Event_model->get_time_slots($academic_year, $course_id, $stream_id, $semester, $division);

        echo json_encode($time_slots);
    }
    public function insert_event_allocation()
    {
        $this->data = $this->input->post();

        if (!isset($this->data['division']) || !is_array($this->data['division'])) {
            $this->session->set_flashdata('message_event', 'No divisions selected.');
            redirect(base_url($this->view_dir . '/'));
            return;
        }

        $this->data['division'] = array_filter($this->data['division'], function ($division) {
            return $division !== 'all' && !empty($division);
        });

        $this->data['division'] = array_values($this->data['division']);

        $insert_data = [];
        $duplicates = [];
        
        foreach ($this->data['division'] as $division) {
            $check_exists = $this->Event_model->check_duplicate_event_allocation([
                'event_id'      => intval($this->data['event_id']),
                'academic_year' => $this->data['academic_year'],
                'school_id'     => intval($this->data['school_id']),
                'course_id'     => intval($this->data['course_id']),
                'stream_id'     => intval($this->data['stream_id']),
                'semester'      => $this->data['semester'],
                'division'      => trim($division),
            ]);
        
            if ($check_exists) {
                $duplicates[] = $division;
                continue; // Skip this one
            }
        
            $insert_data[] = [
                'event_id'      => intval($this->data['event_id']),
                'academic_year' => $this->data['academic_year'],
                'school_id'     => intval($this->data['school_id']),
                'course_id'     => intval($this->data['course_id']),
                'stream_id'     => intval($this->data['stream_id']),
                'semester'      => $this->data['semester'],
                'division'      => trim($division),
                'event_venue'   => $this->data['event_venue'],
                   // 'from_date'     => date('Y-m-d', strtotime($this->data['from_date'])),
                // 'to_date'       => date('Y-m-d', strtotime($this->data['to_date'])),
                // 'time_slot'     => isset($this->data['time_slot']) ? implode(',', (array) $this->data['time_slot']) : null,
                'status'        => 'Active',
                'created_at'    => date('Y-m-d H:i:s')
            ];
        }
        
        if (!empty($duplicates)) {
            $this->session->set_flashdata('message_event_error', 'The following divisions are already allocated: ' . implode(', ', $duplicates));
            redirect(base_url('Event/event_allocation/' . base64_encode($this->data['event_id'])));
            return;
        }
        
        if (!empty($insert_data)) {
            if ($this->Event_model->insert_event_allocation($insert_data)) {
                $this->session->set_flashdata('message_event_success', 'Event allocated successfully.');
            } else {
                $this->session->set_flashdata('message_event_error', 'Database insertion failed.');
            }
        } else {
            $this->session->set_flashdata('message_event_error', 'No valid event allocation data.');
        }
        
        redirect(base_url($this->view_dir . '/'));
    }


    public function event_allocation_list($event_id = null)
    {
        $this->load->library('pagination');
        $this->load->view('header', $this->data);

        if ($this->input->post('event_id')) {
            $event_id = base64_decode($this->input->post('event_id'));
        } elseif ($event_id !== null) {
            $event_id = base64_decode($event_id);
        } else {
            show_error("Missing event ID.", 400);
            return;
        }

        $limit = $this->input->get('limit') ? intval($this->input->get('limit')) : 10;
        $search = $this->input->get('search') ? $this->input->get('search') : '';
        $offset = $this->uri->segment(3, 0);

        $total_rows = $this->Event_model->count_event_allocations($event_id, $search);

        $config['base_url'] = base_url('Event/event_allocation_list/' . base64_encode($event_id));
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $event_allocation_list = $this->Event_model->get_event_allocation_list_by_id($event_id, $limit, $offset, $search);
        $this->data['event_allocation_list'] = $event_allocation_list;
       // echo "<pre>"; print_r($this->data['event_allocation_list']);exit;

        $this->data['pagination_links'] = $this->pagination->create_links();
        $this->data['limit'] = $limit;
        $this->data['search'] = $search;

        $this->load->view($this->view_dir . 'event_allocation_list', $this->data);
        $this->load->view('footer');
    }


    public function upload_attendance($event_allocation_id)
    {
      
        $this->load->view('header', $this->data);

        $event_allocation_id = base64_decode($event_allocation_id); //echo $event_allocation_id;exit;
        $event_allocation_data = $this->Event_model->get_event_by_allocation_id($event_allocation_id);

        if (empty($event_allocation_data)) {
            $this->session->set_flashdata('message_event_error', 'Event allocation not found.');
            redirect(base_url($this->view_dir . '/'));
        }

        $this->data['event_allocation_data'] = $event_allocation_data;
        $stream_id = $event_allocation_data[0]['stream_id'] ?? '';
        $semester = $event_allocation_data[0]['semester'] ?? '';
        $division = $event_allocation_data[0]['division'] ?? '';

        $attendance_date = $this->input->post('attendance_date') ?? '';

        $allocateStudents = [];
        $markedStudentIds = [];
        $attendanceExists = false;

        if (!empty($attendance_date)) {

            $allocateStudents = $this->Event_model->get_allocate_students($stream_id, $semester, $division);

            $markedAttendance = $this->Event_model->get_marked_attendance($event_allocation_id, $attendance_date);

            $markedStudentIds = array_column($markedAttendance, 'student_id');

            $attendanceExists = !empty($markedAttendance);
        }

        $this->data['allocateStudents'] = $allocateStudents;
        $this->data['markedStudentIds'] = $markedStudentIds;
        $this->data['attendance_date'] = $attendance_date;
        $this->data['attendanceExists'] = $attendanceExists;

        $this->load->view($this->view_dir . 'upload_event_attendance_view', $this->data);
        $this->load->view('footer');
    }

    public function view_uploaded_attendance($event_allocation_id)
    {
        $this->load->view('header', $this->data);

        $event_allocation_id = base64_decode($event_allocation_id);
        $event_allocation_data = $this->Event_model->get_event_by_allocation_id($event_allocation_id);

        if (empty($event_allocation_data)) {
            $this->session->set_flashdata('message_event_error', 'Event allocation not found.');
            redirect(base_url($this->view_dir . '/'));
        }

        $this->data['event_allocation_data'] = $event_allocation_data;
        $stream_id = $event_allocation_data[0]['stream_id'] ?? '';
        $semester = $event_allocation_data[0]['semester'] ?? '';
        $division = $event_allocation_data[0]['division'] ?? '';

        $attendance_date = $this->input->post('attendance_date') ?? '';

        $allocateStudents = [];
        $markedStudentIds = [];
        $attendanceExists = false;

        if (!empty($attendance_date)) {

            $allocateStudents = $this->Event_model->get_allocate_students($stream_id, $semester, $division);

            $markedAttendance = $this->Event_model->get_marked_attendance($event_allocation_id, $attendance_date);

            $markedStudentIds = array_column($markedAttendance, 'student_id');

            $attendanceExists = !empty($markedAttendance);
        }

        $this->data['allocateStudents'] = $allocateStudents;
        $this->data['markedStudentIds'] = $markedStudentIds;
        $this->data['attendance_date'] = $attendance_date;
        $this->data['attendanceExists'] = $attendanceExists;

        $this->load->view($this->view_dir . 'view_event_student_attendance', $this->data);
        $this->load->view('footer');
    }


    public function view_attendance($event_allocation_id)
    {
        $this->load->view('header', $this->data);

        $event_allocation_id = base64_decode($event_allocation_id);
        $event_allocation_data = $this->Event_model->get_event_by_allocation_id($event_allocation_id);

        if (empty($event_allocation_data)) {
            $this->session->set_flashdata('message_event_error', 'Event allocation not found.');
            redirect(base_url($this->view_dir . '/'));
        }

        $this->data['event_allocation_data'] = $event_allocation_data;

        $attendance_date = $this->input->post('attendance_date') ?? '';

        $markedAttendance = [];
        if (!empty($attendance_date)) {
            $markedAttendance = $this->Event_model->get_marked_attendance_students($event_allocation_id, $attendance_date);
        }

        $this->data['markedAttendance'] = $markedAttendance;
        $this->data['attendance_date'] = $attendance_date;

        $this->load->view($this->view_dir . 'view_event_attendance', $this->data);
        $this->load->view('footer');
    }


    public function upload_attendance_process()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $event_allocation_id = $this->input->post('event_allocation_id');
        $event_id = $this->input->post('event_id');
        $selected_students = $this->input->post('attendance');

        if (!empty($selected_students)) {
            $attendance_data = [];

            foreach ($selected_students as $student_id) {
                $attendance_data[] = [
                    'event_allocation_id' => $event_allocation_id,
                    'student_id' => $student_id,
                    'school_id' => $this->input->post('school_id') ?? NULL,
                    'course_id' => $this->input->post('course_id') ?? NULL,
                    'stream_id' => $this->input->post('stream_id') ?? NULL,
                    'semester' => $this->input->post('semester') ?? NULL,
                    'division' => $this->input->post('division') ?? NULL,
                    'attendance_date' => $this->input->post('attendance_date') ?? NULL,
                    'created_by' => $this->session->userdata('user_id') ?? NULL,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }

            $DB1->insert_batch('event_student_attendance', $attendance_data);

            $this->session->set_flashdata('message_event_success', 'Attendance uploaded successfully.');
        } else {
            $this->session->set_flashdata('message_event_error', 'No students selected for attendance.');
        }

        redirect(base_url('Event/event_allocation_list/' . base64_encode($event_id)));
    }

    public function google_captcha()
    {
        $this->load->view('header', $this->data);
        $this->load->view($this->view_dir . 'google_captcha', $this->data);
        $this->load->view('footer');
    }

    public function validate_captcha()
    
    {
        $recaptchaResponse = $this->input->post('g-recaptcha-response');
      
        if (!$recaptchaResponse) {
            $this->session->set_flashdata('message_event_error', 'Please verify that you are not a robot.');
            redirect(base_url('Event/google_captcha'));
            return;
        }
      
        $secretKey = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe"; 
        $verifyUrl = "https://www.google.com/recaptcha/api/siteverify";

        $response = file_get_contents($verifyUrl . "?secret={$secretKey}&response={$recaptchaResponse}");
        $responseData = json_decode($response);
        
        if ($responseData->success) {
          
            $name = $this->input->post('name');

            $this->session->set_userdata('submitted_name', $name);

            $this->session->set_flashdata('message_event_success', 'Verification successful! Hello, ' . htmlspecialchars($name));
            redirect(base_url('Event/google_captcha'));
        } else {
           
            $this->session->set_flashdata('message_event_error', 'reCAPTCHA verification failed. Try again.');
            redirect(base_url('Event/google_captcha'));
        }
    }

    public function toggle_event_status($encoded_id, $new_status)
    {
    
        $event_id = base64_decode($encoded_id);
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->where('id', $event_id);
        $updated = $DB1->update('events', ['status' => $new_status]);

        if ($updated) {
            $this->session->set_flashdata('message_event_success', "Event status updated Successfully");
        } else {
            $this->session->set_flashdata('message_event_error', "Failed to update event status.");
        }

        redirect(base_url($this->view_dir));
    }

}
