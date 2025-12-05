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
    public function admin_list11() {
        $data['sessions'] = $this->Live_session_model->list_all();        
		$this->load->view('header',$this->data); 
		$this->load->view('live_sessions/admin_list', $data);
		$this->load->view('footer');
    }
	public function admin_list()
{
    // optional: require admin or faculty login
    if (!$this->session->userdata('name') && !$this->session->userdata('is_admin')) {
        $this->session->set_flashdata('error', 'Please login as faculty/admin to view sessions.');
        redirect('auth/login');
        return;
    }

    $this->load->model('Live_session_model');

    // If you want faculty-specific listing, pass faculty_id: otherwise admin sees all
    $faculty_id = $this->session->userdata('name') ?: null;
    // If admin and you want to see all, pass null; otherwise pass $faculty_id
    if ($this->session->userdata('is_admin')) {
        $data['sessions'] = $this->Live_session_model->list_all(null); // admin: all sessions
    } else {
        $data['sessions'] = $this->Live_session_model->list_all($faculty_id); // faculty: only own sessions
    }
	$this->load->view('header',$this->data); 
    $this->load->view('live_sessions/admin_list', $data);
	$this->load->view('footer');
}

   /**
 * Student-facing list of upcoming sessions (simple list + Join).
 */
public function student_list()
{
    // Try common session keys for student id
    $student_id = $this->session->userdata('sname') 
               ?: $this->session->userdata('stud_id')
               ?: $this->session->userdata('sname'); // fallback if you used sname earlier

    if (empty($student_id)) {
        $this->session->set_flashdata('error', 'Please login to view your sessions.');
        redirect('auth/login'); // adjust to your login route
        return;
    }

    // Load model (umsdb based model)
    $this->load->model('Live_session_model');

    // Optional: limit list to upcoming month by default
    $from = date('Y-m-d');
    $to = date('Y-m-d', strtotime('+30 days'));

    // Get sessions for this student (model does filtering)
    $data['sessions'] = $this->Live_session_model->get_sessions_for_student($student_id, $from, $to);

    // pass student id to view (used by JS)
    $data['student_id'] = $student_id;
	$this->load->view('header',$this->data); 
    $this->load->view('live_sessions/student_list', $data);
	$this->load->view('footer');
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
	
	/**
 * Show form (GET) with faculty's assigned subjects and create Meet link for selected subject (POST).
 */
public function create_with_subject()
{
    // Load subject model which queries the second DB (umsdb)
    $this->load->model('Subject_master_model');

    // Determine faculty identifier from session
	//$emp_id = $this->session->userdata("name");
    $faculty_code = $this->session->userdata('name'); // e.g. 'FAC001' (string)
    $faculty_id   = $this->session->userdata('name');   // numeric id if available

    // If POST -> process creation
    if ($this->input->method() === 'post') {

        // get POST data
        $title      = trim($this->input->post('title')) ?: 'Live Class';
        $subject_id = $this->input->post('subject_id'); // expects subject_master.sub_id
        $start      = $this->input->post('start') ?: date('Y-m-d H:i:s');
        $end        = $this->input->post('end')   ?: date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Basic validation
        if (empty($subject_id) || !is_numeric($subject_id)) {
            $this->session->set_flashdata('error', 'Please select a valid subject.');
            redirect('live_session/create_with_subject');
        }

        // Load selected subject (from umsdb via Subject_master_model)
        $subject = $this->Subject_master_model->get($subject_id);
        if (!$subject) {
            $this->session->set_flashdata('error', 'Selected subject not found.');
            redirect('live_session/create_with_subject');
        }

        // pick Google tokens from default DB (the account used to create events)
        $tokenRow = $this->db->order_by('id','ASC')->get('google_tokens')->row();
        if (!$tokenRow) {
            $this->session->set_flashdata('error', 'No Google integration found. Please connect Google (google_auth/login).');
            redirect('live_session/create_with_subject');
        }
        $google_user_email = $tokenRow->user_email;

        // Build a descriptive event summary
        $eventSummary = $title . ' - ' . trim($subject->subject_name ?: $subject->subject_short_name);
        if (!empty($subject->subject_code)) {
            $eventSummary .= ' (' . $subject->subject_code . ')';
        }

        // Optional: include faculty info in summary when available
        if (!empty($faculty_code)) {
            $eventSummary .= ' - Faculty: ' . $faculty_code;
        } elseif (!empty($faculty_id)) {
            $eventSummary .= ' - FacultyID: ' . $faculty_id;
        }

        // Create Google client and Calendar service
        try {
            $client = $this->google_api->getClient($google_user_email);
            $calendarService = new \Google\Service\Calendar($client);

            // Prepare event with Meet conference
            $event = new \Google\Service\Calendar\Event([
                'summary' => $eventSummary,
                'start' => ['dateTime' => date('c', strtotime($start))],
                'end'   => ['dateTime' => date('c', strtotime($end))],
                'conferenceData' => [
                    'createRequest' => [
                        'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                        'requestId' => uniqid('meet_')
                    ]
                ],
            ]);

            // Insert event (conferenceDataVersion=1 required to create Meet link)
            $createdEvent = $calendarService->events->insert(
                'primary',
                $event,
                ['conferenceDataVersion' => 1]
            );

            $meet_link = $createdEvent->getHangoutLink();

            // Save session in your default DB live_sessions (store subject_id, faculty_id)
            $session_data = [
                'faculty_id' => $faculty_id ? $faculty_id : 0,    // store numeric id if available
                'subject_id' => $subject->sub_id,                 // subject_master.sub_id
                'title'      => $title,
                'meet_link'  => $meet_link,
                'start_time' => date('Y-m-d H:i:s', strtotime($start)),
                'end_time'   => date('Y-m-d H:i:s', strtotime($end)),
            ];

            $session_id = $this->Live_session_model->create($session_data);

            $this->session->set_flashdata('message', 'Session created for subject <strong>'.htmlspecialchars($subject->subject_name).'</strong>. Meet link: '.$meet_link);
            redirect('live_session/admin_list');

        } catch (\Google\Service\Exception $e) {
            log_message('error','Google API error creating event: '.$e->getMessage());
            $this->session->set_flashdata('error','Google API error: '.$e->getMessage());
            redirect('live_session/create_with_subject');
        } catch (\Exception $ex) {
            log_message('error','General error creating event: '.$ex->getMessage());
            $this->session->set_flashdata('error','Error: '.$ex->getMessage());
            redirect('live_session/create_with_subject');
        }
    }

    // GET -> show form with only subjects assigned to this faculty
    if (!empty($faculty_code)) {
        $data['subjects'] = $this->Subject_master_model->get_by_faculty($faculty_code);
    } elseif (!empty($faculty_id)) {
        $data['subjects'] = $this->Subject_master_model->get_by_faculty($faculty_id);
    } else {
        // No faculty identifier found in session
        $data['subjects'] = [];
        $this->session->set_flashdata('error', 'No faculty identifier in session. Please login as faculty.');
    }

    // load view (use the view you already have or create one named below)
	$this->load->view('header',$this->data); 
    $this->load->view('live_sessions/create_with_subject', $data);
	 $this->load->view('footer');
}
/**
 * Show student calendar page (FullCalendar).
 * Requires application/views/live_sessions/student_calendar.php view (provided earlier).
 */
public function student_calendar()
{
    // Ensure student logged in
    $student_id = $this->session->userdata('sname');
    if (empty($student_id)) {
        // redirect to login or show message - adjust as per your auth flow
        $this->session->set_flashdata('error', 'Please login to view your timetable.');
        redirect('auth/login'); // change to your login controller/route
        return;
    }

    // Load view (JS inside view will call /student/calendar/events)
    $this->load->view('live_sessions/student_calendar');
}

/**
 * JSON events feed for FullCalendar.
 * FullCalendar passes "start" and "end" query params (ISO dates) — we forward them to model.
 * Returns array of events: { id, title, start, end, url, extendedProps }
 */
public function student_calendar_events()
{
    $this->output->set_content_type('application/json');

    $student_id = $this->session->userdata('sname');
    if (empty($student_id)) {
        // Return empty array so calendar shows nothing
        echo json_encode([]);
        return;
    }

    // accept FullCalendar range params (optional)
    $from = $this->input->get('start'); // ISO date string
    $to   = $this->input->get('end');

    // load model
    $this->load->model('Live_session_model');

    // model: get_sessions_for_student($student_id, $from=null, $to=null)
    $events = $this->Live_session_model->get_sessions_for_student($student_id, $from, $to);

    $out = [];
    foreach ($events as $e) {
        // compute deterministic color using subject_code or subject_id
        $seed = !empty($e->subject_code) ? $e->subject_code : ($e->subject_id ?? $e->id);
        $hex = substr(md5($seed), 0, 6);
        $bgColor = '#' . $hex;

        // darken for border
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
        $factor = 0.78;
        $br = max(0, min(255, (int)($r * $factor)));
        $bg = max(0, min(255, (int)($g * $factor)));
        $bb = max(0, min(255, (int)($b * $factor)));
        $borderColor = sprintf("#%02x%02x%02x", $br, $bg, $bb);

        // determine status: prefer passed status property else compute from end_time
        $status = isset($e->status) ? $e->status : null;
        $end_time_raw = isset($e->end) ? $e->end : (isset($e->end_time) ? $e->end_time : null);
        if (empty($status)) {
            if ($end_time_raw && strtotime($end_time_raw) < time()) {
                $status = 'completed';
            } else {
                $status = 'scheduled';
            }
        }

        $title = (!empty($e->subject_code) ? $e->subject_code . ' - ' : '') . $e->title;

        $out[] = [
            'id' => $e->id,
            'title' => $title,
            'start' => $e->start,
            'end' => $e->end,
            'backgroundColor' => $bgColor,
            'borderColor' => $borderColor,
            'textColor' => '#ffffff',
            'url' => $e->meet_link ?: null,
            'extendedProps' => [
                'meet_link' => $e->meet_link,
                'subject_name' => $e->subject_name ?? null,
                'subject_code' => $e->subject_code ?? null,
                'status' => $status,
                'end_time' => $end_time_raw
            ],
        ];
    }

    echo json_encode($out);
}
	public function finalize_sessions($grace_seconds = 0)
	{
		// allow CLI or admin only
		if (!$this->input->is_cli_request() && !$this->session->userdata('is_admin')) {
			show_error('Forbidden', 403);
		}

		$grace_seconds = (int)$grace_seconds;
		$cutoff = date('Y-m-d H:i:s', time() - $grace_seconds);

		// Update sessions: scheduled -> completed where end_time <= cutoff
		$this->db->where('status', 'scheduled');
		$this->db->where('end_time <=', $cutoff);
		$this->db->update('live_sessions', ['status' => 'completed']);

		$affected = $this->db->affected_rows();

		// Also finalize any open attendances related to those sessions (optional)
		$this->load->model('Live_attendance_model');
		// finalize attendance where session ended earlier than last_ping
		// you can call the model's finalize_expired if implemented

		if ($this->input->is_cli_request()) {
			echo "Finalized sessions: {$affected}\n";
		} else {
			$this->session->set_flashdata('message', "Finalized sessions: {$affected}");
			redirect('live_session/admin_list');
		}
	}
	
	public function join_ajax($session_id = null)
{
    $this->output->set_content_type('application/json');

    // basic validation
    if (empty($session_id) || !is_numeric($session_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid session ID.']);
        return;
    }

    // require student to be logged in
    $student_id = $this->session->userdata('sname');
    if (empty($student_id)) {
        echo json_encode(['status' => 'unauth', 'message' => 'Please login to join.']);
        return;
    }

    // load models (assumes these models exist and work with your DB)
    $this->load->model('Live_session_model');      // should provide get($id)
    $this->load->model('Live_attendance_model');   // should provide mark_join()

    // load session row
    $session = $this->Live_session_model->get($session_id);
    if (!$session) {
        echo json_encode(['status' => 'error', 'message' => 'Session not found.']);
        return;
    }

    // --- server-side expiry/status checks ---
    // Grace period in seconds after end_time (adjust as needed)
    $grace_seconds = 60;

    // resolve end time (session->end_time expected in DB)
    $end_ts = 0;
    if (!empty($session->end_time)) {
        $end_ts = strtotime($session->end_time);
    }

    // If status column present and marked completed -> forbid join
    if (isset($session->status) && $session->status === 'completed') {
        echo json_encode(['status' => 'expired', 'message' => 'This session has been completed — joining is disabled.']);
        return;
    }

    // If end_time exists and now > end_time + grace -> forbid join and optionally mark completed
    if ($end_ts && (time() > ($end_ts + $grace_seconds))) {
        // mark session completed in DB (best-effort)
        if (isset($session->id)) {
            $this->load->database(); // make sure DB lib loaded
            $this->db->where('id', $session->id)->update('live_sessions', ['status' => 'completed']);
        }
        echo json_encode(['status' => 'expired', 'message' => 'Session time is over — joining is disabled.']);
        return;
    }

    // everything ok -> mark attendance (model handles duplicates)
    $attendance_id = $this->Live_attendance_model->mark_join($session_id, $student_id);

    // return meet link and attendance id
    echo json_encode([
        'status' => 'ok',
        'message' => 'Attendance recorded',
        'attendance_id' => $attendance_id,
        'meet_link' => isset($session->meet_link) ? $session->meet_link : null,
        'session_id' => $session_id
    ]);
}
public function attendance_leave()
{
    // Respond JSON
    $this->output->set_content_type('application/json');

    // Accept POST form data OR raw input (for beacon/fetch)
    $attendance_id = $this->input->post('attendance_id');
    if (empty($attendance_id)) {
        // Try reading raw input (application/x-www-form-urlencoded or JSON)
        $raw = file_get_contents('php://input');
        if ($raw) {
            // try parse form-encoded
            parse_str($raw, $parsed);
            if (!empty($parsed['attendance_id'])) {
                $attendance_id = $parsed['attendance_id'];
            } else {
                // try JSON
                $json = json_decode($raw, true);
                if (!empty($json['attendance_id'])) {
                    $attendance_id = $json['attendance_id'];
                }
            }
        }
    }

    if (empty($attendance_id)) {
        // log for debug
        log_message('error', "attendance_leave called without attendance_id. raw_input=" . substr(file_get_contents('php://input'),0,200));
        echo json_encode(['status'=>'error','message'=>'Missing attendance_id']);
        return;
    }

    // ensure numeric
    $attendance_id = (int)$attendance_id;
    if ($attendance_id <= 0) {
        log_message('error',"attendance_leave invalid attendance_id: ".print_r($attendance_id, true));
        echo json_encode(['status'=>'error','message'=>'Invalid attendance_id']);
        return;
    }

    // load model and attempt leave
    $this->load->model('Live_attendance_model');

    try {
        $ok = $this->Live_attendance_model->mark_leave($attendance_id);
    } catch (Exception $ex) {
        log_message('error', 'attendance_leave exception: '.$ex->getMessage());
        echo json_encode(['status'=>'error','message'=>'Server error']);
        return;
    }

    if ($ok) {
        echo json_encode(['status'=>'ok']);
    } else {
        // not updated — give diagnostic
        $row = $this->Live_attendance_model->get_by_id_for_debug($attendance_id);
        log_message('warning', 'attendance_leave did not update for id='.$attendance_id . ' row='.json_encode($row));
        echo json_encode(['status'=>'error','message'=>'Unable to mark leave (maybe already left or not found).', 'debug' => $row]);
    }
}
/**
 * Return attendance summary for the logged-in student for a session.
 * GET /live_session/attendance_summary/{session_id}
 * Response: { status: 'ok', attendance: { joined_at, left_at, duration_seconds } } or { status:'no' }
 */
public function attendance_summary($session_id = null)
{
    $this->output->set_content_type('application/json');

    $student_id = $this->session->userdata('student_id');
    if (empty($student_id)) {
        echo json_encode(['status' => 'unauth']);
        return;
    }

    if (empty($session_id) || !is_numeric($session_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing session id']);
        return;
    }

    $this->load->model('Live_attendance_model');

    $row = $this->Live_attendance_model->get_latest_for_student_session((int)$session_id, (int)$student_id);

    if (!$row) {
        echo json_encode(['status' => 'no']);
        return;
    }

    echo json_encode([
        'status' => 'ok',
        'attendance' => [
            'id' => (int)$row->id,
            'joined_at' => $row->joined_at ? date('c', strtotime($row->joined_at)) : null,
            'left_at' => $row->left_at ? date('c', strtotime($row->left_at)) : null,
            'duration_seconds' => $row->duration_seconds !== null ? (int)$row->duration_seconds : null,
            'last_ping_at' => $row->last_ping_at ? date('c', strtotime($row->last_ping_at)) : null
        ]
    ]);
}
public function find_and_attach_recording($session_id = null)
{
    if (empty($session_id) || !is_numeric($session_id)) {
        echo "Missing session id\n"; return;
    }

    // load session via your model (ensure this returns session with start,end and faculty info)
    $this->load->model('Live_session_model');
    $session = $this->Live_session_model->get($session_id);
    if (!$session) {
        echo "Session not found\n"; return;
    }

    // need host faculty email (assumes session has faculty_email or mapping faculty_id -> email)
    $faculty_email = $session->faculty_email ?? null;
    if (empty($faculty_email)) {
        echo "No faculty email found for session\n"; return;
    }

    // get Google client for faculty (must have Drive scope)
    $client = $this->google_api->getClient($faculty_email);
    if (!$client || !$client->getAccessToken()) {
        echo "No Google client/token for faculty: {$faculty_email}\n"; return;
    }

    // create Drive service
    $drive = new Google_Service_Drive($client);

    // Build search query:
    // - recordings are mp4 (mimeType contains 'video')
    // - not trashed
    // - name probably contains session title OR createdTime near session start.
    // We'll search by modifiedTime/createdTime window around the meeting.
    $start = isset($session->start_time) ? date('c', strtotime($session->start_time)) : null;
    $end = isset($session->end_time) ? date('c', strtotime($session->end_time)) : null;

    // Example query pieces
    $qParts = ["trashed = false", "mimeType contains 'video'"]; // mp4 usually

    // If you have session title, try name contains
    if (!empty($session->title)) {
        // sanitize single quotes
        $name = str_replace("'", "\\'", $session->title);
        $qParts[] = "name contains '{$name}'";
    }

    // add createdTime window +/- 30 minutes (adjust if needed)
    if ($start) {
        $start_ts = strtotime($start);
        $from = date('c', $start_ts - 60*30); // 30 min before
        $to   = date('c', ($end ? strtotime($end) : $start_ts + 60*60) + 60*30); // 30 min after event end or +30m
        $qParts[] = "createdTime >= '{$from}' and createdTime <= '{$to}'";
    }

    $q = implode(' and ', $qParts);

    // list files
    $optParams = [
        'q' => $q,
        'fields' => 'files(id,name, mimeType, size, createdTime, webViewLink)',
        'orderBy' => 'createdTime desc',
        'pageSize' => 10
    ];

    try {
        $resp = $drive->files->listFiles($optParams);
    } catch (Exception $ex) {
        log_message('error', 'Drive files.list error: '.$ex->getMessage());
        echo "Drive API error\n"; return;
    }

    $files = $resp->getFiles();
    if (empty($files)) {
        echo "No recording file found for session {$session_id}\n";
        return;
    }

    // Take the top candidate (or show UI to choose)
    $file = $files[0];
    $fileId = $file->getId();
    $webView = $file->getWebViewLink();
    $fileName = $file->getName();

    // Save to DB (example: live_recordings table)
    $this->load->database('umsdb', TRUE); // if using second DB
    $umsdb = $this->umsdb ?? $this->load->database('umsdb', TRUE);

    $umsdb->insert('live_recordings', [
        'session_id' => $session_id,
        'drive_file_id' => $fileId,
        'drive_web_view_link' => $webView,
        'file_name' => $fileName,
        'size_bytes' => $file->getSize() ?? null,
        'added_by' => 'system'
    ]);

    // Optionally update live_sessions.recording_link
    $umsdb->where('id', $session_id)->update('live_sessions', ['recording_file_id' => $fileId, 'recording_link' => $webView]);

    echo "Recording attached: {$fileName} ({$fileId})\n";
}

}
