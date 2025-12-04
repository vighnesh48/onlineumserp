<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;

class Live_session extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('Google_api');
        $this->load->model('Live_session_model');
        $this->load->model('Live_attendance_model');
        $this->load->helper('url');
        $this->load->database();
    }

    /**
     * Admin view to create a session.
     * For demo, we create event immediately for the primary calendar associated
     * with the saved Google account (first token row). In production, select user.
     */
    public function create_demo() {
        // Minimal form processing; in real app you would validate inputs
        $title = $this->input->post('title') ?? 'Live Class';
        $start = $this->input->post('start') ?? date('Y-m-d H:i:s');
        $end = $this->input->post('end') ?? date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Get token's user email — pick the first token (or choose specific account)
        $tokenRow = $this->db->order_by('id','ASC')->get('google_tokens')->row();
        if (!$tokenRow) {
            show_error('No Google tokens found. Please connect Google from admin (google_auth/login).');
        }
        $google_user_email = $tokenRow->user_email;

        $client = $this->google_api->getClient($google_user_email);
        $calendarService = new Calendar($client);

        // Prepare event with conference (Meet)
        $event = new Event([
            'summary' => $title,
            'start' => ['dateTime' => date('c', strtotime($start))],
            'end' => ['dateTime' => date('c', strtotime($end))],
            'conferenceData' => [
                'createRequest' => [
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                    'requestId' => uniqid('meet_')
                ]
            ],
        ]);

        // Insert event
        $createdEvent = $calendarService->events->insert(
            'primary',
            $event,
            ['conferenceDataVersion' => 1]
        );

        // The Meet link can be in $createdEvent->getHangoutLink()
        $meet_link = $createdEvent->getHangoutLink();

        // Save session in DB
        $session_data = [
            'faculty_id' => $this->session->userdata('faculty_id') ?? 1,
            'subject_id' => null,
            'title' => $title,
            'meet_link' => $meet_link,
            'start_time' => date('Y-m-d H:i:s', strtotime($start)),
            'end_time' => date('Y-m-d H:i:s', strtotime($end)),
        ];
        $session_id = $this->Live_session_model->create($session_data);

        $this->session->set_flashdata('message', 'Session created with Meet link: ' . $meet_link);
        redirect('live_session/admin_list');
    }

    // Show admin list of sessions (simple view)
    public function admin_list() {
        $data['sessions'] = $this->Live_session_model->list_all();
        $this->load->view('live_sessions/admin_list', $data);
    }

    // Student-facing list of sessions with Join button
    public function student_list() {
        $data['sessions'] = $this->Live_session_model->list_all();
        $this->load->view('live_sessions/student_list', $data);
    }

    // Student clicks Join -> mark attendance and redirect to meet
    public function join($session_id) {
        // ensure student logged in or set student id for demo
        $student_id = $this->session->userdata('student_id');
        if (!$student_id) {
            // For demo purposes, set a student id if not present
            $student_id = 123;
            $this->session->set_userdata('student_id', $student_id);
        }

        $session = $this->Live_session_model->get($session_id);
        if (!$session) {
            show_error('Session not found.');
        }

        // mark attendance
        $this->Live_attendance_model->mark($session_id, $student_id);

        // redirect to meet link
        redirect($session->meet_link);
    }
}
