<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helpdesk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Helpdesk_model', 'helpdesk');
        $this->load->library(['form_validation']);
        $this->load->helper(['url', 'form']);
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
        // TODO: add your auth check here
    }
    private function render($view, $data = [])
    {
        $this->load->view('header', $this->data);
        $this->load->view($view, $data);
        $this->load->view('footer');
    }
    /* ==================== STUDENT SIDE ==================== */

public function index()
{
    $student_id = $this->session->userdata('name');
    $this->data['page_title'] = 'My Helpdesk Tickets';
    $this->data['tickets'] = $this->helpdesk->get_student_tickets($student_id);

    $this->render('helpdesk/student_list', $this->data);
}


public function create()
{
    $data['page_title'] = 'New Helpdesk Ticket';
    $data['categories'] = $this->helpdesk->get_active_categories();

    $this->render('helpdesk/student_create', $data);
}


    private function _do_attachment_upload($field_name = 'attachment')
    {
        if (empty($_FILES[$field_name]['name'])) {
            return ['status' => false, 'file_path' => null, 'error' => null];
        }

        $upload_path = FCPATH . 'uploads/helpdesk/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|ppt|pptx|jpg|jpeg|png|gif';
        $config['max_size']      = 5120;
        $config['encrypt_name']  = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($field_name)) {
            return ['status' => false, 'file_path' => null, 'error' => $this->upload->display_errors('', '')];
        }

        $data = $this->upload->data();
        $relative_path = 'uploads/helpdesk/' . $data['file_name'];
        return ['status' => true, 'file_path' => $relative_path, 'error' => null];
    }

    public function store()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $student_id = $this->session->userdata('name');

        $this->form_validation->set_rules('category_id', 'Category', 'required|integer');
        $this->form_validation->set_rules('title', 'Title', 'required|min_length[5]');
        $this->form_validation->set_rules('description', 'Description', 'required|min_length[10]');
        $this->form_validation->set_rules('priority', 'Priority', 'required|in_list[LOW,MEDIUM,HIGH,CRITICAL]');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => 'error',
                'errors' => $this->form_validation->error_array()
            ]);
            return;
        }

        $category_id = (int)$this->input->post('category_id');
        $cat = $this->helpdesk->get_category($category_id);
        if (!$cat) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid category selected.']);
            return;
        }

        $is_anonymous = $this->input->post('is_anonymous') ? 1 : 0;

        $ticket_no = $this->helpdesk->generate_ticket_no();
        $now = date('Y-m-d H:i:s');
        $sla_due = date('Y-m-d H:i:s', strtotime("+{$cat->sla_hours} hours"));

        // upload file
        $upload = $this->_do_attachment_upload('attachment');
        if ($upload['error']) {
            echo json_encode(['status' => 'error', 'message' => 'File upload error: '.$upload['error']]);
            return;
        }

        $ticket_data = [
            'ticket_no'       => $ticket_no,
            'student_id'      => $student_id,
            'category_id'     => $category_id,
            'title'           => $this->input->post('title', TRUE),
            'description'     => $this->input->post('description', TRUE),
            'priority'        => $this->input->post('priority', TRUE),
            'status'          => 'OPEN',
            'is_anonymous'    => $is_anonymous,
            'created_on'      => $now,
            'updated_on'      => $now,
            'sla_due_on'      => $sla_due
        ];

        $first_message = [
            'sender_type'   => 'STUDENT',
            'sender_id'     => $student_id,
            'message_text'  => $this->input->post('description', TRUE),
            'attachment_path' => $upload['file_path'],
            'is_internal'   => 0,
            'created_on'    => $now
        ];

        $ticket_id = $this->helpdesk->create_ticket($ticket_data, $first_message);

        if (!$ticket_id) {
            echo json_encode(['status' => 'error', 'message' => 'Could not create ticket. Try again.']);
            return;
        }

        echo json_encode([
            'status'    => 'success',
            'message'   => 'Ticket created successfully.',
            'ticket_id' => $ticket_id,
            'ticket_no' => $ticket_no
        ]);
    }

public function view($ticket_id)
{
    $student_id = $this->session->userdata('name');
    $ticket = $this->helpdesk->get_ticket_for_student($ticket_id, $student_id);
    if (!$ticket) show_404();

    $data['page_title'] = 'Ticket Details - '.$ticket->ticket_no;
    $data['ticket'] = $ticket;
    $data['messages'] = $this->helpdesk->get_messages($ticket_id, false);
    $data['feedback'] = $this->helpdesk->get_feedback($ticket_id);

    $this->render('helpdesk/student_view', $data);
}


    public function reply_student()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $ticket_id = (int)$this->input->post('ticket_id');
        $message   = $this->input->post('message_text', TRUE);
        $student_id = $this->session->userdata('name');

        $ticket = $this->helpdesk->get_ticket_for_student($ticket_id, $student_id);
        if (!$ticket) {
            echo json_encode(['status'=>'error','message'=>'Invalid ticket.']);
            return;
        }

        if (empty($message) && empty($_FILES['attachment']['name'])) {
            echo json_encode(['status'=>'error','message'=>'Message or attachment required.']);
            return;
        }

        $upload = $this->_do_attachment_upload('attachment');
        if ($upload['error']) {
            echo json_encode(['status'=>'error','message'=>'File upload error: '.$upload['error']]);
            return;
        }

        $msg_data = [
            'ticket_id'       => $ticket_id,
            'sender_type'     => 'STUDENT',
            'sender_id'       => $student_id,
            'message_text'    => $message,
            'attachment_path' => $upload['file_path'],
            'is_internal'     => 0,
            'created_on'      => date('Y-m-d H:i:s')
        ];
        $this->helpdesk->add_message($msg_data);

        // update status (reopened or in_progress → student_replied)
        $this->helpdesk->update_ticket($ticket_id, [
            'status'     => $ticket->status == 'RESOLVED' ? 'REOPENED' : 'IN_PROGRESS',
            'updated_on' => date('Y-m-d H:i:s')
        ]);

        echo json_encode(['status'=>'success']);
    }

    public function save_feedback()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $ticket_id = (int)$this->input->post('ticket_id');
        $rating    = (int)$this->input->post('rating');
        $comment   = $this->input->post('comment', TRUE);
        $student_id= $this->session->userdata('name');

        if ($rating < 1 || $rating > 5) {
            echo json_encode(['status'=>'error','message'=>'Invalid rating.']);
            return;
        }

        $ticket = $this->helpdesk->get_ticket_for_student($ticket_id, $student_id);
        if (!$ticket) {
            echo json_encode(['status'=>'error','message'=>'Invalid ticket.']);
            return;
        }

        $data = [
            'ticket_id'   => $ticket_id,
            'student_id'  => $student_id,
            'rating'      => $rating,
            'comment'     => $comment,
            'submitted_on'=> date('Y-m-d H:i:s')
        ];

        $this->helpdesk->save_feedback($data);

        echo json_encode(['status'=>'success','message'=>'Thank you for your feedback!']);
    }

    /* ==================== ADMIN / MENTOR SIDE ==================== */

public function admin()
{
    $data['page_title'] = 'Helpdesk Admin Dashboard';
    $data['categories'] = $this->helpdesk->get_active_categories();

    $this->render('helpdesk/admin_list', $data);
}


    public function admin_ajax_list()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $filters = [
            'status'      => $this->input->post('status'),
            'category_id' => $this->input->post('category_id'),
            'priority'    => $this->input->post('priority'),
            'from_date'   => $this->input->post('from_date'),
            'to_date'     => $this->input->post('to_date')
        ];

        $tickets = $this->helpdesk->get_admin_tickets($filters);
        echo json_encode($tickets);
    }

public function admin_view($ticket_id)
{
    $ticket = $this->helpdesk->get_ticket_for_admin($ticket_id);
    if (!$ticket) show_404();

    $data['page_title'] = 'Handle Ticket - '.$ticket->ticket_no;
    $data['ticket'] = $ticket;
    $data['messages'] = $this->helpdesk->get_messages($ticket_id, true);
    $data['feedback'] = $this->helpdesk->get_feedback($ticket_id);

    $this->render('helpdesk/admin_view', $data);
}


    public function admin_reply()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $ticket_id  = (int)$this->input->post('ticket_id');
        $message    = $this->input->post('message_text', TRUE);
        $status     = $this->input->post('status'); // optional new status from admin
        $is_internal= $this->input->post('is_internal') ? 1 : 0;
        $admin_id   = $this->session->userdata('name'); // staff id

        $ticket = $this->helpdesk->get_ticket_for_admin($ticket_id);
        if (!$ticket) {
            echo json_encode(['status'=>'error','message'=>'Invalid ticket.']);
            return;
        }

        if (empty($message) && empty($_FILES['attachment']['name'])) {
            echo json_encode(['status'=>'error','message'=>'Message or attachment required.']);
            return;
        }

        $upload = $this->_do_attachment_upload('attachment');
        if ($upload['error']) {
            echo json_encode(['status'=>'error','message'=>'File upload error: '.$upload['error']]);
            return;
        }

        $msg_data = [
            'ticket_id'       => $ticket_id,
            'sender_type'     => 'ADMIN',
            'sender_id'       => $admin_id,
            'message_text'    => $message,
            'attachment_path' => $upload['file_path'],
            'is_internal'     => $is_internal,
            'created_on'      => date('Y-m-d H:i:s')
        ];
        $this->helpdesk->add_message($msg_data);

        $update = [
            'updated_on'      => date('Y-m-d H:i:s'),
            'assigned_user_id'=> $admin_id
        ];

        if ($status && in_array($status, ['OPEN','IN_PROGRESS','ON_HOLD','RESOLVED','CLOSED','REOPENED'])) {
            $update['status'] = $status;
        } else {
            // default to in progress on reply
            if ($ticket->status == 'OPEN') {
                $update['status'] = 'IN_PROGRESS';
            }
        }

        $this->helpdesk->update_ticket($ticket_id, $update);

        echo json_encode(['status'=>'success']);
    }

    public function change_status()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $ticket_id = (int)$this->input->post('ticket_id');
        $status    = $this->input->post('status');

        if (!in_array($status, ['OPEN','IN_PROGRESS','ON_HOLD','RESOLVED','CLOSED','REOPENED'])) {
            echo json_encode(['status'=>'error','message'=>'Invalid status']);
            return;
        }

        $ticket = $this->helpdesk->get_ticket_for_admin($ticket_id);
        if (!$ticket) {
            echo json_encode(['status'=>'error','message'=>'Invalid ticket']);
            return;
        }

        $this->helpdesk->update_ticket($ticket_id, [
            'status'     => $status,
            'updated_on' => date('Y-m-d H:i:s')
        ]);

        echo json_encode(['status'=>'success']);
    }
    public function set_chat_mode(){
        $mode = $this->input->post('mode');
        $this->session->set_userdata('chat_mode',$mode);
    }
    
}
