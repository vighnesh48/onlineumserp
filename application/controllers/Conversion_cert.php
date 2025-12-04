<?php // echo 'hii';exit;
defined('BASEPATH') OR exit('No direct script access allowed');

class Conversion_cert extends CI_Controller {

    private $view_dir;
	public function __construct(){        
		global $menudata;      
		parent::__construct();       
		$this->load->helper("url");     
		$this->load->library('form_validation');        
		if($this->uri->segment(2) != "" && $this->uri->segment(2) != "submit" && !in_array($this->uri->segment(2), $this->skipActions))
		$title = $this->uri->segment(2); //Second segment of uri for action,In case of edit,view,add etc.       
		else
		$title = $this->master_arr['index'];
		$this->currentModule = $this->uri->segment(1);    
		$this->data['currentModule'] = $this->currentModule;       
		$this->data['model_name'] = $this->model_name;             
		$this->load->library('form_validation');       
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->load->model('Results_model');
		$model = $this->load->model($this->model_name);
		$menu_name = $this->uri->segment(1);
        //15
		 $this->session->userdata("role_id");
		if(($this->session->userdata("role_id")==15)||($this->session->userdata("role_id")==14)
			||($this->session->userdata("role_id")==6) ||($this->session->userdata("role_id")==66)){}else{
			redirect('home');
			}
		$this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
        $this->load->library('Awssdk');
		$this->load->model('Exam_timetable_model');
        $this->load->model('Marks_model');
        $this->load->model('Results_model');
        $this->load->model('Conversion_cert_model');
		    $this->load->library('m_pdf'); // avoid old wrapper

	}

    public function index()
    {
        // Fetch regulations
        $this->data['regulatn'] = $this->Exam_timetable_model->getRegulation();

        if ($this->input->post()) {
            // When form is submitted
            $this->data['school_code']      = $this->input->post('school_code');
            $this->data['admissioncourse']  = $this->input->post('admission-course');
            $this->data['stream']           = $this->input->post('admission-branch');
            $this->data['semester']         = $this->input->post('semester');
            $this->data['exam']             = $this->input->post('exam_session');
            $this->data['marks_type']       = $this->input->post('marks_type');
            $this->data['exam_session']     = $this->Marks_model->fetch_exam_allsession();

            // Split exam session into month, year, id
            $exam        = explode('-', $this->input->post('exam_session'));
            $exam_month  = $exam[0] ?? '';
            $exam_year   = $exam[1] ?? '';
            $exam_id     = $exam[2] ?? '';

            $this->data['exam_month'] = $exam_month;
            $this->data['exam_year']  = $exam_year;
            $this->data['exam_id']    = $exam_id;

            // Fetch students list for marksheet
            $this->data['stud_list'] = $this->Results_model->list_result_students_for_marksheets(
                $this->input->post(),
                $exam_month,
                $exam_year,
                $exam_id
            );

            // Load views
            $this->load->view('header', $this->data);
            $this->load->view($this->view_dir . 'Conversion_cert/conversion_cert_view', $this->data);
            $this->load->view('footer');

        } else {
            // Default page load
            $this->data['school_code']     = '';
            $this->data['admissioncourse'] = '';
            $this->data['stream']          = '';
            $this->data['semester']        = '';
            $this->data['exam_session']    = $this->Marks_model->fetch_exam_allsession();

            $this->load->view('header', $this->data);
            $this->load->view($this->view_dir . 'Conversion_cert/conversion_cert_view', $this->data);
            $this->load->view('footer');
        }
    }
    public function generate_conversion_pdf()
    {
		$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '0', '0', '5', '5', '10', '35');

        $enrollment_param = $this->input->get('enrollments');
        if (!$enrollment_param) {
            show_error("No enrollments selected.");
        }

        $enrollments = explode(",", $enrollment_param);

        // Get raw data from model
        $raw_results = $this->Conversion_cert_model->get_latest_exam_results_by_enrollments($enrollments);

        if (empty($raw_results)) {
            show_error("No exam records found for selected students.");
        }

        // ✅ Group and structure results by enrollment
        $final_results = [];

        foreach ($raw_results as $row) {
            if ((int)$row['semester'] === 0) {
                continue; // ❌ Skip semester 0
            }
            $enrollment = $row['enrollment_no'];

            if (!isset($final_results[$enrollment])) {
                $final_results[$enrollment] = [
                    'enrollment_no' => $row['enrollment_no'],
                    'first_name' => $row['first_name'],
                    'academic_year' => $row['academic_year'],
                    'stream_name' => $row['stream_short_name'],
                    'degree_specialization' => $row['degree_specialization'],
                    'exam_name' => $row['exam_name'],
                    'results' => []
                ];
            }

            $final_results[$enrollment]['results'][] = [
                'semester' => $row['semester'],
                'sgpa' => $row['sgpa']
            ];
        }

        // ✅ Reset array keys
        $data['exam_results'] = array_values($final_results);
        $data['exam_session'] = $_GET['exam_session'];
		
	//	print_r($_GET);exit;
		// $signature_path = FCPATH . 'assets/images/Sign-COE-011.png';
		$signature_path ='';

        // Render the HTML view to string
        $html = $this->load->view('Conversion_cert/conversion_cert_pdf_view', $data, true);

			$footer = '
			  <table width="100%" style="font-size:10pt;">
				<tr style="">
				  <td width="25%" style="text-align:left;">
					<h4><br><br>
						Prepared By
					</h4>
				  </td>
				  <td width="30%" style="text-align:center;">					
					<h4><br><br>
						Office Seal 
					</h4>
				  </td>
				  <td width="15%"></td>
				  <td width="30%" style="text-align:center; vertical-align:bottom; padding: 0 20px 10px 0">
					<!--<img src="' . $signature_path . '" style="height:10mm; width:30mm;" />--><br>
					<h4>
					Controller of Examinations<br>
					Sandip University,Nashik
					</h4>
				  </td>
				</tr>
			  </table>
			';
			$this->m_pdf->pdf->SetHTMLFooter($footer);
        // Generate PDF with mPDF
        $mpdf = new mPDF();
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output('conversion_certificate.pdf', 'D');
    }

    public function generate_transcript_pdf()
    {
		$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '0', '0', '5', '5', '10', '35');

        $enrollment_param = $this->input->get('enrollments');
        if (!$enrollment_param) {
            show_error("No enrollments selected.");
        }

        $enrollments = explode(",", $enrollment_param);

        // Load the model if not already loaded
        $this->load->model('Conversion_cert_model');

        // Fetch data from the model
        $raw_results = $this->Conversion_cert_model->get_transcript_data_by_enrollments($enrollments);

        if (empty($raw_results)) {
            show_error("No transcript records found for selected students.");
        }

        // Group data by enrollment_no and semesters
        $grouped_results = [];

        foreach ($raw_results as $row) {
            $enrollment = $row['enrollment_no'];

            if (!isset($grouped_results[$enrollment])) {
                $grouped_results[$enrollment] = [
                    'enrollment_no' => $enrollment,
                    'first_name' => $row['first_name'],
                    'stream_name' => $row['stream_name'],
                    'semesters' => []
                ];
            }

            // Add semester info (skip if semester is empty or zero)
            if (!empty($row['semester']) && (int)$row['semester'] !== 0) {
                $grouped_results[$enrollment]['semesters'][] = [
                    'semester' => $row['semester'],
                    'total_marks_out_of' => $row['total_marks_out_of'],
                    'obtain_marks' => $row['obtain_marks'] ?? 0,
                    'exam_name' => $row['exam_name']
                ];
            }
        }

        // Reset array keys
        $data['transcript_data'] = array_values($grouped_results);
        // dd ($data); exit;
		// $signature_path = FCPATH . 'assets/images/Sign-COE-011.png';
		$signature_path ='';
			
			$footer = '
			  <table width="100%" style="font-size:10pt;">
				<tr style="">
				  <td width="25%" style="text-align:left;">
					<h4><br><br>
					</h4>
				  </td>
				  <td width="30%" style="text-align:center;">					
					<h4><br><br>
						Office Seal 
					</h4>
				  </td>
				  <td width="15%"></td>
				  <td width="30%" style="text-align:center; vertical-align:bottom; padding: 0 20px 10px 0">
					<!--<img src="' . $signature_path . '" style="height:10mm; width:30mm;" />--><br>
					<h4>
					Controller of Examinations<br>
					Sandip University,Nashik
					</h4>
				  </td>
				</tr>
			  </table>
			';
			$this->m_pdf->pdf->SetHTMLFooter($footer);
        // Load view to generate HTML
        $html = $this->load->view('Conversion_cert/transscript_cert_pdf_view', $data, true);
		
		$this->m_pdf->pdf->WriteHTML($html);
        // Output PDF to browser as download
        $this->m_pdf->pdf->Output('transcript.pdf', 'D');
    }

	public function generate_degree_certificate()
{
    // DEV ONLY: remove / turn off on prod
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED); // still log deprecations, but suppress display if needed
    // ini_set('memory_limit', '1024M');
    // set_time_limit(0);

    $enrollment_param = $this->input->get('enrollments');
    if (!$enrollment_param) {
        show_error("No enrollments selected.");
    }

    $this->load->model('Conversion_cert_model');
    $this->load->library('m_pdf'); // avoid old wrapper

    // sanitize enrollments
    $enrollments = array_filter(array_map('trim', explode(',', $enrollment_param)));
    if (empty($enrollments)) {
        show_error("No valid enrollments provided.");
    }

    $stream_id = (int)$this->input->get('stream_id');
    $exam_id_raw = (string)$this->input->get('exam_id');
    // support "-" or "~" delimiters
    $parts = preg_split('/[-~]/', $exam_id_raw);
    $exam_id = isset($parts[2]) ? (int)$parts[2] : (int)$exam_id_raw;

    if (empty($enrollments) || $stream_id === 0 || $exam_id === 0) {
        show_error('Missing selection. Please select student(s), stream and exam.');
    }
	
	$this->m_pdf->pdf = new mPDF('utf-8', 'A5-L', '', '', 14, 17, 45, 0, 0, 11, 'L');
	// $mpdf=new mPDF();
    // if you want a background watermark image use filesystem path
    // $this->m_pdf->pdf->SetWatermarkImage(FCPATH . 'assets/images/passing_cert_blank.png', 1.0, [210,148], [0,0], true);
    // $this->m_pdf->pdf->showWatermarkImage = true;
    // $this->m_pdf->pdf->watermarkImgBehind = true;

    // footer: use filesystem image path for the signature
  //  $signature_path = FCPATH . 'assets/images/Sign-COE-011.png';
  $signature_path ='';
    $footer = '
    <div style="height:26mm;" >
      <table width="100%" style="font-size:10pt; padding: 100px 0 0 0; height:26mm; table-layout:fixed;">
        <colgroup>
          <col style="width:5%;">
          <col style="width:100%;">
          <col style="width:35%;">
        </colgroup>
        <tr style="height:26mm;">
          
           <td style="text-align:left;padding-top: 5mm; padding-left:50px;">' . date('d-m-Y') . '</td>

          <td style="text-align:right; vertical-align:bottom; padding: 0 20px 10px 0">
            <!--<img src="' . $signature_path . '" style="height:10mm; width:30mm;" />-->
          </td>
        </tr>
      </table>
    </div>';
    $this->m_pdf->pdf->SetHTMLFooter($footer);

    log_message('debug', 'POST chk_stud ids=' . json_encode($enrollments));

    // iterate students
    foreach ($enrollments as $sid_raw) {
        $sid = (int)$sid_raw;
        if ($sid <= 0) continue;

        $student = $this->Conversion_cert_model->fetch_degree_cert_by_student($exam_id, $sid, $stream_id);
        if (!$student) {
            log_message('debug', "No row for stud_id={$sid}, exam_id={$exam_id}, stream_id={$stream_id}");
            continue;
        }

        // classification (same logic)
        $gpa = (float)($student['cumulative_gpa'] ?? 0);
		if      ($gpa >= 7.75) $student['classification'] = 'First Class With Distinction';
		elseif  ($gpa >= 6.75) $student['classification'] = 'First Class';
		elseif  ($gpa >= 6.25) $student['classification'] = 'Higher Second Class';
		elseif  ($gpa >= 5.50) $student['classification'] = 'Second Class';
		elseif  ($gpa >= 4.00) $student['classification'] = 'Pass';
		else                   $student['classification'] = '';


        $html = $this->load->view('Conversion_cert/degree_card_only', [
            'student'   => $student,
            'exam_name' => $exam_id
        ], true);

        // add a page only if not the very first page
        // mPDF includes the first page automatically, so avoid an extra blank first page:
        static $first = true;
        if ($first) {
            $first = false;
        } else {
            $this->m_pdf->pdf->AddPage('L');
        }

        $this->m_pdf->pdf->WriteHTML($html);
    }

    // clear buffers to avoid corrupt pdf
    if (ob_get_length()) {
        @ob_end_clean();
    }

    $filename = 'passing_certificates_' . date('Ymd_His') . '.pdf';
    $this->m_pdf->pdf->Output($filename, 'I');
    exit;
}
}
