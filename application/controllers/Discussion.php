<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussion extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Discussion_model', 'discussion');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);

        // Set default chat mode for UI switching
        if (!$this->session->userdata('chat_mode')) {
            $this->session->set_userdata('chat_mode','whatsapp');
        }

        // TODO: Add your own role authentication
        // if(!$this->session->userdata('logged_in')) redirect('login');
    }

    /** UNIVERSAL RENDER FUNCTION **/
    private function render($view, $data = [])
    {
        $this->load->view('header');
        $this->load->view($view, $data);
        $this->load->view('footer');
    }

    /* ========== STUDENT SIDE ========== */

    // List of tickets for logged-in student
    
public function index()
{
    $stud_id = $this->session->userdata('name');
    $data['tickets'] = $this->discussion->get_tickets_by_student($stud_id);
    $data['page_title'] = 'My Discussion Requests';

    $this->render('discussion/student_list', $data);
}


    // Show create form
public function create()
{
    $stud_id = $this->session->userdata('name');
    $data['subjects'] = $this->discussion->get_student_subjects($stud_id);
    $data['page_title'] = 'New Discussion Request';

    $this->render('discussion/student_form', $data);
}


    // AJAX: get topics based on subject
    public function get_topics($subject_id)
    {
        $topics = $this->discussion->get_topics_by_subject($subject_id);
        echo json_encode($topics);
    }

    // Store new ticket (AJAX)
    public function store()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('No direct script access allowed');
        }

        $this->form_validation->set_rules('discussion_type', 'Discussion Type', 'required|in_list[DIRECT,ONLINE_MEET]');
        $this->form_validation->set_rules('subject_id', 'Subject', 'required|integer');
        $this->form_validation->set_rules('topic_id', 'Topic', 'required|integer');
        $this->form_validation->set_rules('student_remark', 'Remark', 'required|min_length[10]');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array(
                'status' => 'error',
                'errors' => $this->form_validation->error_array()
            ));
            return;
        }

        $stud_id       = $this->session->userdata('name');
        $discussion_type = $this->input->post('discussion_type');
        $subject_id    = (int)$this->input->post('subject_id');
        $topic_id      = (int)$this->input->post('topic_id');
        $student_remark = $this->input->post('student_remark', TRUE);
        $preferred_datetime = $this->input->post('preferred_datetime', TRUE); // for online meet

        // Fetch subject, topic, student-applied row for context
        $subject_row = $this->discussion->get_student_subject_row($stud_id, $subject_id);
        $topic_row   = $this->discussion->get_topic_row($topic_id);

        if (!$subject_row || !$topic_row) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Invalid subject/topic selection.'
            ));
            return;
        }

        // print_r($subject_row);exit;
        // Find faculty from lecture_time_table

        $faculty_code = $this->discussion->get_faculty_for_subject(
            $subject_row->stream_id,
            $subject_row->stream_code,
            $subject_row->subject_id,
            $subject_row->semester,
            $subject_row->academic_year
        );

        $ticket_data = array(
            'ticket_no'            => $this->discussion->generate_ticket_no(),
            'stud_id'              => $stud_id,
            'faculty_code'         => $faculty_code,
            'stream_id'            => $subject_row->stream_id,
            'stream_code'          => $subject_row->stream_code,
            'subject_id'           => $subject_id,
            'subject_code'         => $subject_row->subject_id,
            'semester'             => $subject_row->semester,
            'academic_year'        => $subject_row->academic_year,
            'topic_id'             => $topic_id,
            'topic_title_snapshot' => $topic_row->topic_title,
            'discussion_type'      => $discussion_type,
            'student_remark'       => $student_remark,
            'status'               => 'OPEN',
            'campus_id'            => $subject_row->campus_id ?? null,
            'created_by'           => $stud_id
        );

        if ($discussion_type === 'ONLINE_MEET' && !empty($preferred_datetime)) {
            $ticket_data['meet_start_datetime'] = date('Y-m-d H:i:s', strtotime($preferred_datetime));
        }
        // Upload attachment (if any)
        $upload = $this->_do_attachment_upload('attachment');
        if ($upload['error']) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'File upload error: ' . $upload['error']
            ));
            return;
        }

        $attachment_path = $upload['file_path'];

        $ticket_id = $this->discussion->create_ticket($ticket_data);

        if ($ticket_id) {
            // Create first message entry as student remark
            $this->discussion->add_message(array(
                'ticket_id'   => $ticket_id,
                'sender_type' => 'STUDENT',
                'sender_id'   => $stud_id,
                'message_text'=> $student_remark,
                'attachment_path' => $attachment_path
            ));

            echo json_encode(array(
                'status'   => 'success',
                'message'  => 'Discussion request submitted successfully.',
                'ticket_id'=> $ticket_id
            ));
        } else {
            echo json_encode(array(
                'status'  => 'error',
                'message' => 'Unable to submit request. Please try again.'
            ));
        }
    }

    // Student view ticket + messages
public function view($ticket_id)
{
    $stud_id = $this->session->userdata('name');
    $data['ticket']   = $this->discussion->get_ticket_for_student($ticket_id, $stud_id);
    if (!$data['ticket']) show_404();

    $data['messages'] = $this->discussion->get_messages_by_ticket($ticket_id);
    $data['page_title'] = 'View Discussion Ticket';

    $this->render('discussion/student_view', $data);
}


    // Student reply (AJAX)

    public function student_reply()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $ticket_id = (int)$this->input->post('ticket_id');
        $message   = $this->input->post('message_text', TRUE);
        $stud_id   = $this->session->userdata('name');

        if (empty($message) && empty($_FILES['attachment']['name'])) {
            echo json_encode(array('status' => 'error', 'message' => 'Message or attachment is required.'));
            return;
        }

        $ticket = $this->discussion->get_ticket_for_student($ticket_id, $stud_id);
        if (!$ticket) {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid ticket.'));
            return;
        }

        // file upload
        $upload = $this->_do_attachment_upload('attachment');
        if ($upload['error']) {
            echo json_encode(array('status' => 'error', 'message' => 'File upload error: ' . $upload['error']));
            return;
        }

        $this->discussion->add_message(array(
            'ticket_id'       => $ticket_id,
            'sender_type'     => 'STUDENT',
            'sender_id'       => $stud_id,
            'message_text'    => $message,
            'attachment_path' => $upload['file_path']
        ));

        $this->discussion->update_ticket_status($ticket_id, 'STUDENT_REPLIED');

        echo json_encode(array('status' => 'success'));
    }


    /* ========== STAFF SIDE ========== */

    // List tickets for faculty
public function staff()
{
    $faculty_code = $this->session->userdata('name');
    $data['tickets'] = $this->discussion->get_tickets_by_faculty($faculty_code);
    $data['page_title'] = 'Student Discussion Requests';

    $this->render('discussion/staff_list', $data);
}

    public function staff_ajax_list()
    {
        $faculty = $this->session->userdata('name');

        $filters = array(
            'status'      => $this->input->post('filter_status'),
            'type'        => $this->input->post('filter_type'),
            'from_date'   => $this->input->post('from_date'),
            'to_date'     => $this->input->post('to_date')
        );

        $data = $this->discussion->filter_tickets($faculty, $filters);
        echo json_encode($data);
    }

public function close_ticket()
{
    $id = $this->input->post('ticket_id');
    $this->discussion->update_ticket($id, ['status'=>'CLOSED']);
    echo json_encode(['status'=>'success']);
}

    // Staff view ticket
public function staff_view($ticket_id)
{
    $faculty_code = $this->session->userdata('name');
    $data['ticket'] = $this->discussion->get_ticket_for_faculty($ticket_id, $faculty_code);
    if (!$data['ticket']) show_404();

    $data['messages'] = $this->discussion->get_messages_by_ticket($ticket_id);
    $data['page_title'] = 'Handle Discussion Request';

    $this->render('discussion/staff_view', $data);
}


    // Staff reply or add meet link (AJAX)
    public function staff_reply()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $ticket_id     = (int)$this->input->post('ticket_id');
        $message       = $this->input->post('message_text', TRUE);
        $meet_link     = $this->input->post('meet_link', TRUE);
        $meet_datetime = $this->input->post('meet_datetime', TRUE);
        $faculty_code  = $this->session->userdata('name');

        $ticket = $this->discussion->get_ticket_for_faculty($ticket_id, $faculty_code);
        if (!$ticket) {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid ticket.'));
            return;
        }

        if (empty($message) && empty($meet_link) && empty($_FILES['attachment']['name'])) {
            echo json_encode(array('status' => 'error', 'message' => 'Message, meet link or attachment required.'));
            return;
        }

        // upload file if any
        $upload = $this->_do_attachment_upload('attachment');
        if ($upload['error']) {
            echo json_encode(array('status' => 'error', 'message' => 'File upload error: ' . $upload['error']));
            return;
        }

        // echo '<pre>';print_r($upload['file_path']);exit;
        if (!empty($message) || $upload['file_path']) {
            $this->discussion->add_message(array(
                'ticket_id'       => $ticket_id,
                'sender_type'     => 'FACULTY',
                'sender_id'       => $faculty_code,
                'message_text'    => $message,
                'attachment_path' => $upload['file_path']
            ));
        }

        $update = array();

        if (!empty($meet_link)) {
            $update['meet_link'] = $meet_link;
            if (!empty($meet_datetime)) {
                $update['meet_start_datetime'] = date('Y-m-d H:i:s', strtotime($meet_datetime));
            }
            $update['status'] = 'MEET_SCHEDULED';
        } else {
            $update['status'] = 'FACULTY_REPLIED';
        }

        $update['faculty_remark_latest'] = $message;
        $update['updated_by'] = $faculty_code;

        $this->discussion->update_ticket($ticket_id, $update);

        echo json_encode(array('status' => 'success'));
    }

    public function _do_attachment_upload($field_name = 'attachment')
    {
        if (empty($_FILES[$field_name]['name'])) {
            return array('status' => false, 'file_path' => null, 'error' => null);
        }

        $upload_path = FCPATH . 'uploads/discussion/'; // create this folder, writable 0777 or 0755

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|ppt|pptx|jpg|jpeg|png|gif|txt';
        $config['max_size']      = 5120; // 5MB
        $config['encrypt_name']  = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($field_name)) {
            return array('status' => false, 'file_path' => null, 'error' => $this->upload->display_errors('', ''));
        } else {
            $data = $this->upload->data();
            // Save relative path for linking later
            $relative_path = 'uploads/discussion/' . $data['file_name'];
            return array('status' => true, 'file_path' => $relative_path, 'error' => null);
        }
    }

}
