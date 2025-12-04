<?php
class Student_assignments extends CI_Controller {

    
	public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        $this->load->model('Assignment_model');
        $this->load->library(['form_validation','session','encryption']);
        $this->load->helper(['url','form','encryption']);
        
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
		if (($this->session->userdata("role_id") != 4)) {
            redirect('home');
        }
    }

    public function index()
	{
		//echo '<pre>';print_r($_SESSION);exit;
		$student_id = $this->session->userdata('sname');

		// flat list (subject_id, subject_name included)
		$rows = $this->Assignment_model->get_student_assignments($student_id);

		// group by subject
		$grouped = [];           // [ "<subject_id>|<subject_name>" => [rows...] ]
		$subjectCounts = [];     // subject => count
		foreach ($rows as $r) {
			$key = $r->subject_id . '|' . $r->subject_name;
			if (!isset($grouped[$key])) $grouped[$key] = [];
			$grouped[$key][] = $r;
			$subjectCounts[$key] = ($subjectCounts[$key] ?? 0) + 1;
		}

		$this->data['grouped'] = $grouped;
		$this->data['subjectCounts'] = $subjectCounts;

		// You can keep your old fast view; this is the new tabs view:
		$this->load->view('header',$this->data);
		$this->load->view('assignment/student_list_subject_tabs', $this->data);
		$this->load->view('footer',$this->data);
	}

    // View assignment with questions
    public function student_view($assignment_id) {
		$assignment_id = decrypt_id($assignment_id);
        if (!$assignment_id || !is_numeric($assignment_id)) {
            show_error("Invalid request", 403);
        }
        $student_id = $this->session->userdata('sname');
        $this->data['assignment'] = $this->Assignment_model->get_assignment_details($assignment_id, $student_id);
        $this->data['questions']  = $this->Assignment_model->get_assignment_questions($assignment_id);
		$this->load->view('header',$this->data);
        $this->load->view('assignment/student_view', $this->data);
		$this->load->view('footer',$this->data);
    }
    // Submit assignment
    public function student_submit() {
        $assignment_id = (int) $this->input->post('assignment_id', true);
		$student_id    = (int) ($this->session->userdata('student_id') ?: $this->session->userdata('sname'));

		if (!$assignment_id || !$student_id) {
			show_error('Invalid assignment or student.', 400); return;
		}

		$now = date('Y-m-d H:i:s');
		$answer = [
			'answer_text'  => (string) $this->input->post('answer_text', true),
			'submitted_at' => $now,
			'status'       => 'Submitted',
		];

		// --- S3 upload (optional file) ---
		if (!empty($_FILES['answer_file']['name'])) {
			$allowed = ['pdf','doc','docx','zip','png','jpg','jpeg'];
			$origName = $_FILES['answer_file']['name'];
			$tmpPath  = $_FILES['answer_file']['tmp_name'];
			$sizeB    = (int) $_FILES['answer_file']['size'];

			$ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
			if (!in_array($ext, $allowed, true)) {
				show_error('Invalid file type. Allowed: '.implode(', ', $allowed), 415); return;
			}
			if ($sizeB > 5 * 1024 * 1024) { // 5 MB cap
				show_error('File too large. Max size is 5 MB.', 413); return;
			}

			// Detect MIME for S3 ContentType
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mime  = $finfo ? finfo_file($finfo, $tmpPath) : 'application/octet-stream';
			if ($finfo) finfo_close($finfo);

			// Make a neat, collision-resistant key:
			// asg_{aid}_stu_{sid}_{YmdHis}_{base}.{ext}
			$base = pathinfo($origName, PATHINFO_FILENAME);
			$base = preg_replace('~[^A-Za-z0-9\-_. ]~', '', $base);
			$base = trim(preg_replace('~\s+~', '-', $base), '-_');
			if ($base === '') $base = 'file';

			$stamp      = date('Ymd');
			$finalName  = sprintf('%d%d%s_%s.%s', $assignment_id, $student_id, $stamp, $base, $ext);
			$s3Key      = 'uploads/student_assignments/'.$finalName;
			$bucket     = 'erp-asset';

			// Upload to S3 (no local write)
			$ok = $this->awssdk->uploadFile($bucket, $s3Key, $tmpPath, $mime);
			if (!$ok) { show_error('Upload failed. Please try again.', 500); return; }

			// Save either the key or a full URL—keeping key here
			$answer['answer_file'] = $finalName; // or $s3Key if you prefer storing the path
		}

        $this->Assignment_model->submit_answer($assignment_id, $student_id, $answer);
        redirect('Student_assignments');
    }
}
