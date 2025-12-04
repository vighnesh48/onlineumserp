<?php
class Lecture_plan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Lecture_plan_model');
		$this->load->helper('form');
    }

    public function index($subject_id, $faculty_id, $campus_id,$subdetails) {
		
        $data['plans'] = $this->Lecture_plan_model->get_all($subject_id, $faculty_id, $campus_id,$subdetails);
		$data['has_attendance'] = $this->Lecture_plan_model->hasAttendanceWithPlan($subject_id, $campus_id);
		//print_r($data['plans']);exit;
        $data['subject_id'] = $subject_id;
        $data['faculty_id'] = $faculty_id;
        $data['campus_id'] = $campus_id;
        $data['subdetails'] = $subdetails;
		$this->load->view('header',$data);
        $this->load->view('lecture_plan/list', $data);
		$this->load->view('footer');
    }

	   public function add($subject_id, $faculty_id, $campus_id,$subdetails) {
		$data['subject_id'] = $subject_id;
		$data['faculty_id'] = $faculty_id;
		$data['campus_id'] = $campus_id;
		$data['subdetails'] = $subdetails;

		$data['topics'] = $this->Lecture_plan_model->get_topics_by_subject($subject_id,$campus_id);
		$data['faculty_name'] = $this->Lecture_plan_model->get_faculty_name($faculty_id,$campus_id);
		$data['subject_name'] = $this->Lecture_plan_model->get_subject_name($subject_id,$campus_id);
		$this->load->view('header',$data);
		$this->load->view('lecture_plan/create', $data);
		$this->load->view('footer');
	}
	public function store() {
	$this->load->helper('form');
    $this->load->library('form_validation');
    $this->load->model('Lecture_plan_model');

    // Set validation rules
    $this->form_validation->set_rules('faculty_id', 'Faculty', 'required');
    $this->form_validation->set_rules('subject_id', 'Subject', 'required');
    $this->form_validation->set_rules('campus_id', 'Campus', 'required');
    $this->form_validation->set_rules('topic_id', 'Topic', 'required');
   // $this->form_validation->set_rules('subtopic_id', 'Subtopic', 'required');
    $this->form_validation->set_rules('planned_date', 'Planned Date', 'required');
    $this->form_validation->set_rules('planned_duration_hours', 'Duration Hours', 'required|numeric');
    $this->form_validation->set_rules('planned_duration_minutes', 'Duration Minutes', 'required|numeric');
    $this->form_validation->set_rules('lecture_mode', 'Lecture Mode', 'required');
    $this->form_validation->set_rules('course_outcome', 'Course Outcome', 'required');
    #$this->form_validation->set_rules('learning_outcome', 'Learning Outcome', 'required');

    if ($this->form_validation->run() == FALSE) {
        // Reload form view with existing data
        $subject_id = $this->input->post('subject_id');
        $faculty_id = $this->input->post('faculty_id');
        $campus_id = $this->input->post('campus_id');
        $subdetails = $this->input->post('subdetails');

        $data['faculty_id'] = $faculty_id;
        $data['subject_id'] = $subject_id;
        $data['campus_id'] = $campus_id;
		$data['subdetails'] = $subdetails;
        $data['topics'] = $this->Lecture_plan_model->get_topics_by_subject($subject_id,$campus_id);
        $data['faculty_name'] = $this->Lecture_plan_model->get_faculty_name($faculty_id,$campus_id);
        $data['subject_name'] = $this->Lecture_plan_model->get_subject_name($subject_id,$campus_id);

        if ($this->input->post('plan_id')) {
            $data['plan'] = $this->Lecture_plan_model->get_by_id($this->input->post('plan_id'));
        }
		$this->load->view('header',$data);
        $this->load->view('lecture_plan/create', $data);
		$this->load->view('footer');
        return;
    }
	$subdetails = $this->input->post('subdetails');
	$sub = base64_decode($subdetails);
		
		$division = '';
		$batch = '';

		if (!empty($sub)) {
			$sub_parts = explode('~', $sub);
			$stream_id = isset($sub_parts[0]) ? $sub_parts[0] : '';
			$semester = isset($sub_parts[1]) ? $sub_parts[1] : '';
			$division = isset($sub_parts[2]) ? $sub_parts[2] : '';
			$batch = isset($sub_parts[3]) ? $sub_parts[3] : '';
		}
    // Process and save
    $data = [
        'faculty_id' => $this->input->post('faculty_id'),
        'subject_id' => $this->input->post('subject_id'),
        'campus_id' => $this->input->post('campus_id'),
        'topic_id' => $this->input->post('topic_id'),
        'subtopic_id' => $this->input->post('subtopic_id'),
        'planned_date' => $this->input->post('planned_date'),
        'planned_duration_hours' => $this->input->post('planned_duration_hours'),
        'planned_duration_minutes' => $this->input->post('planned_duration_minutes'),
        'lecture_mode' => $this->input->post('lecture_mode'),
        'course_outcome' => $this->input->post('course_outcome'),
        #'learning_outcome' => $this->input->post('learning_outcome'),
        'teaching_methodology' => $this->input->post('teaching_methodology'),
        'remarks' => $this->input->post('remarks'),
        'stream_id' => $stream_id,
        'semester' => $semester,
        'division' => $division,
        'batch' => $batch,
        'status' => $this->input->post('status'),
    ];
//print_r($data);exit;
    if ($this->input->post('plan_id')) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->Lecture_plan_model->update($this->input->post('plan_id'), $data);
        $msg = 'Lecture plan updated successfully.';
    } else {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->Lecture_plan_model->insert($data);
        $msg = 'Lecture plan added successfully.';
    }
//echo $subdetails;exit;
    $this->session->set_flashdata('success', $msg);
    redirect("lecture_plan/index/{$data['subject_id']}/{$data['faculty_id']}/{$data['campus_id']}/{$subdetails}");
}


   public function edit($plan_id,$subdetails='') {
    $this->load->model('Lecture_plan_model');

    $plan = $this->Lecture_plan_model->get_by_id($plan_id);
    if (!$plan) {
        show_404();
    }

    $data['plan'] = $plan;
    $data['subject_id'] = $plan->subject_id;
    $data['faculty_id'] = $plan->faculty_id;
    $data['campus_id'] = $plan->campus_id;
	$data['subdetails'] = $subdetails;
    $data['topics'] = $this->Lecture_plan_model->get_topics_by_subject($plan->subject_id,$plan->campus_id);
    $data['faculty_name'] = $this->Lecture_plan_model->get_faculty_name($plan->faculty_id,$plan->campus_id);
    $data['subject_name'] = $this->Lecture_plan_model->get_subject_name($plan->subject_id,$plan->campus_id);
    $data['form_action'] = site_url('lecture_plan/store'); // same store
	
	$this->load->view('header',$data);
    $this->load->view('lecture_plan/create', $data);
	$this->load->view('footer');
}


    public function delete($plan_id) {
        $plan = $this->Lecture_plan_model->get_by_id($plan_id);
        $this->Lecture_plan_model->delete($plan_id);
        redirect("lecture_plan/index/{$plan->subject_id}/{$plan->faculty_id}/{$plan->campus_id}");
    }
	public function get_subtopics_ajax($topic_id) {
    $this->load->model('Lecture_plan_model');
    $subtopics = $this->Lecture_plan_model->get_subtopics_by_topic($topic_id);
    echo json_encode($subtopics);
	}
	
	public function import_lesson_plan($faculty_id, $subject_id, $campus_id,$subdetails) {
		
    $this->load->library('excel'); // PHPExcel
    $DB3 = $this->load->database('obe', TRUE);
    $path = $_FILES['excel_file']['tmp_name'];

    $objPHPExcel = PHPExcel_IOFactory::load($path);
    $sheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

    $insertData = [];
    $skippedCount = 0;
	
	$sub = base64_decode($subdetails);
		
		$division = '';
		$batch = '';

		if (!empty($sub)) {
			$sub_parts = explode('~', $sub);
			$stream_id = isset($sub_parts[0]) ? $sub_parts[0] : '';
			$semester = isset($sub_parts[1]) ? $sub_parts[1] : '';
			$division = isset($sub_parts[2]) ? $sub_parts[2] : '';
			$batch = isset($sub_parts[3]) ? $sub_parts[3] : '';
		}
		//print_r($sheet);exit;
    foreach ($sheet as $key => $row) {
        if ($key == 1) continue; // Skip header

        $planned_date = date('Y-m-d', strtotime(trim($row['A'])));
        $topic_order = trim($row['B']);
        $topic_title = trim($row['C']);
        $srno = trim($row['D']);
        $subtopic_title = trim($row['E']);

        // Get topic ID
        $topic = $DB3->where('subject_id', $subject_id)
                     ->where('topic_title', $topic_title)
                     ->where('topic_order', $topic_order)
                     ->get('syllabus_topics')
                     ->row();
//echo $DB3->last_query();exit;
        if (!$topic) continue;

        $topic_id = $topic->topic_id;
        $subtopic_id = null;

        // Subtopic if present
        if (!empty($subtopic_title)) {
            $sub = $DB3->where('topic_id', $topic_id)
                       ->where('srno', $srno)
                       ->where('subtopic_title', $subtopic_title)
                       ->get('syllabus_subtopics')
                       ->row();

            if ($sub) {
                $subtopic_id = $sub->subtopic_id;
            }
        }
		
		
        // Check for duplicate
        $DB3->where([
            'faculty_id' => $faculty_id,
            'subject_id' => $subject_id,
            'division' => $division,
            'batch' => $batch,
            'topic_id' => $topic_id,
            'subtopic_id' => $subtopic_id,
            'planned_date' => $planned_date,
            'campus_id' => $campus_id
        ]);
        $exists = $DB3->get('lecture_plan')->row();
//echo $DB3->last_query();exit;
        if ($exists) {
            $skippedCount++;
            continue;// echo  'Duplicate found, skip';exit;
        }

        $insertData[] = [
            'faculty_id' => $faculty_id,
            'subject_id' => $subject_id,
            'topic_id' => $topic_id,
            'subtopic_id' => $subtopic_id,
            'stream_id' => $stream_id,
            'semester' => $semester,
            'division' => $division,
            'batch' => $batch,
            'planned_date' => $planned_date,
            'planned_duration_hours' => (int) $row['F'],
            'planned_duration_minutes' => (int) $row['G'],
            'lecture_mode' => trim($row['H']),
            'course_outcome' => trim($row['I']),
            'learning_outcome' => trim($row['J']),
            'teaching_methodology' => trim($row['K']),
            'remarks' => trim($row['L']),
            'campus_id' => $campus_id,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ];
    }
	//print_r($insertData);exit;
    if (!empty($insertData)) {
        $DB3->insert_batch('lecture_plan', $insertData);
        $this->session->set_flashdata('success', 'Lesson plan imported. Inserted: ' . count($insertData) . ', Skipped (duplicates): ' . $skippedCount);
    } else {
        $this->session->set_flashdata('error', 'No new records imported. All were duplicates or invalid.');
    }

    redirect('lecture_plan/index/' . $subject_id.'/'.$faculty_id.'/'.$campus_id.'/'.$subdetails);
}


	private function getTopicId($subject_id, $topic_title) {
		$DB3 = $this->load->database('obe', TRUE);
		$row = $DB3->where('subject_id', $subject_id)
						->where('topic_title', $topic_title)
						->get('syllabus_topics')
						->row();
						//echo $DB3->last_query();
		return $row ? $row->topic_id : null;
	}

	private function getSubtopicId($topic_id, $subtopic_title) {
		$DB3 = $this->load->database('obe', TRUE);
		if (!$topic_id) return null;
		$row = $DB3->where('topic_id', $topic_id)
						->where('subtopic_title', $subtopic_title)
						->get('syllabus_subtopics')
						->row();
		return $row ? $row->subtopic_id : null;
	}

	public function download_sample_format_old($subject_id) {
    $DB3 = $this->load->database('obe', TRUE);
    $this->load->library('excel'); // Load PHPExcel
    $objPHPExcel = new PHPExcel();
    $sheet = $objPHPExcel->getActiveSheet();

    // Updated Headers
    $headers = [
        'Planned Date',
        'Topic Order', 'Topic Title',
        'Sr. No.', 'Subtopic Title (Optional)',
        'Planned Duration (Hrs)', 'Planned Duration (Min)',
        'Lecture Mode', 'Course Outcome', 'Learning Outcome',
        'Teaching Methodology', 'Remarks'
    ];

    // Add header row
    $col = 0;
    foreach ($headers as $header) {
        $sheet->setCellValueByColumnAndRow($col++, 1, $header);
    }

    // Get topics and subtopics from DB
    $topics = $DB3->where('subject_id', $subject_id)
                  ->order_by('topic_order', 'ASC')
                  ->get('syllabus_topics')
                  ->result_array();

    $row = 2;

    foreach ($topics as $topic) {
        $subtopics = $DB3->where('topic_id', $topic['topic_id'])
                         ->order_by('srno', 'ASC')
                         ->get('syllabus_subtopics')
                         ->result_array();

        if (!empty($subtopics)) {
            foreach ($subtopics as $sub) {
                $sheet->setCellValue("B$row", $topic['topic_order']);
                $sheet->setCellValue("C$row", $topic['topic_title']);
                $sheet->setCellValue("D$row", $sub['srno']);
                $sheet->setCellValue("E$row", $sub['subtopic_title']);
                $row++;
            }
        } else {
            $sheet->setCellValue("B$row", $topic['topic_order']);
            $sheet->setCellValue("C$row", $topic['topic_title']);
            $row++;
        }
    }

    // Output Excel file
    $filename = 'lesson_plan_sample_subject_' . $subject_id . '.xls';
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}
	
public function download_sample_format($subject_id) {
    $DB3 = $this->load->database('obe', TRUE);
    $this->load->library('excel'); // Load PHPExcel

    $objPHPExcel = new PHPExcel();
    $sheet = $objPHPExcel->getActiveSheet();

    // Updated Headers
    $headers = [
        'Planned Date',
        'Topic Order', 'Topic Title',
        'Sr. No.', 'Subtopic Title (Optional)',
        'Planned Duration (Hrs)', 'Planned Duration (Min)',
        'Lecture Mode', 'Course Outcome', 'Learning Outcome',
        'Teaching Methodology', 'Remarks'
    ];

    // Add header row with bold style
    $col = 0;
    foreach ($headers as $header) {
        $sheet->setCellValueByColumnAndRow($col, 1, $header);
        $sheet->getStyleByColumnAndRow($col, 1)->getFont()->setBold(true);
        $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        $col++;
    }

    // Get topics
    $topics = $DB3->where('subject_id', $subject_id)
                  ->order_by('topic_order', 'ASC')
                  ->get('syllabus_topics')
                  ->result_array();

    $row = 2;

    foreach ($topics as $topic) {
        // Get subtopics
        $subtopics = $DB3->where('topic_id', $topic['topic_id'])
                         ->get('syllabus_subtopics')
                         ->result_array();

        // Apply natural sorting on srno
        usort($subtopics, function($a, $b) {
            return strnatcmp($a['srno'], $b['srno']);
        });

        if (!empty($subtopics)) {
            foreach ($subtopics as $sub) {
                $sheet->setCellValueExplicit("A$row", '', PHPExcel_Cell_DataType::TYPE_STRING); // Planned Date blank
                $sheet->setCellValueExplicit("B$row", $topic['topic_order'], PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit("C$row", $topic['topic_title'], PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit("D$row", $sub['srno'], PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit("E$row", $sub['subtopic_title'], PHPExcel_Cell_DataType::TYPE_STRING);
                $row++;
            }
        } else {
            $sheet->setCellValueExplicit("A$row", '', PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("B$row", $topic['topic_order'], PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C$row", $topic['topic_title'], PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D$row", '', PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("E$row", '', PHPExcel_Cell_DataType::TYPE_STRING);
            $row++;
        }
    }

    // Optional: Add sample values
    for ($r = 2; $r < $row; $r++) {
        $sheet->setCellValue("F$r", 1);   // Planned Duration (Hrs)
        $sheet->setCellValue("G$r", 0);  // Planned Duration (Min)
        $sheet->setCellValue("H$r", 'Offline');
		if($r == 2){
			$sheet->setCellValue("I$r", 'CO1');
		}else{
			$sheet->setCellValue("I$r", '');
		}
        $sheet->setCellValue("J$r", '');
		if($r == 2){
			$sheet->setCellValue("K$r", 'PPT/Chalkboard/Discussion');
		}else{
			$sheet->setCellValue("K$r", '');
		}
        
        $sheet->setCellValue("L$r", '');
    }

    // Output Excel file
    $filename = 'lesson_plan_sample_subject_' . $subject_id . '.xls';
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}
	public function delete_course_plan($subject_id,$faculty_id,$campus_id,$subdetails) {
        $this->Lecture_plan_model->delete_course_plan($subject_id,$faculty_id,$campus_id,$subdetails);
        redirect('lecture_plan/index/' . $subject_id.'/'.$faculty_id.'/'.$campus_id.'/'.$subdetails);
    }
	public function download_lecture_plan_pdf($faculty_id, $subject_id, $campus_id,$subdetails) {
		
		$DB3 = $this->load->database('obe', TRUE);
		//echo $campus_id;exit;
		if($campus_id==1){
			$DB2 = $this->load->database('umsdb', TRUE);
		}elseif($campus_id==2){
			$DB2 = $this->load->database('sjumsdb', TRUE);
		}else{
			$DB2 = $this->load->database('sfumsdb', TRUE);
		}
		// Load mPDF
		$sub = base64_decode($subdetails);
		
		$division = '';
		$batch = '';

		if (!empty($sub)) {
			$sub_parts = explode('~', $sub);
			$stream_id = isset($sub_parts[0]) ? $sub_parts[0] : '';
			$semester = isset($sub_parts[1]) ? $sub_parts[1] : '';
			$division = isset($sub_parts[2]) ? $sub_parts[2] : '';
			$batch = isset($sub_parts[3]) ? $sub_parts[3] : '';
		}
		// Fetch subject name
		$subject = $DB2->where('sub_id', $subject_id)->get('subject_master')->row();
		//print_r($subject);exit;
		$data['faculty_name'] = $this->Lecture_plan_model->get_faculty_name($faculty_id,$campus_id);
		// Fetch lecture plans
		//$DB2 = $this->load->database('umsdb', TRUE); // Adjust DB group
		$vw_db = $DB2->database;

		$DB3->select('lecture_plan.*, vw.stream_name')
			 ->from('lecture_plan')
			 ->join("$vw_db.vw_stream_details as vw", 'vw.stream_id = lecture_plan.stream_id', 'left')
			 ->where('lecture_plan.faculty_id', $faculty_id)
			 ->where('lecture_plan.subject_id', $subject_id)
			 ->where('lecture_plan.campus_id', $campus_id)
			 ->order_by('lecture_plan.planned_date', 'ASC');

		$plans = $DB3->get()->result();
		//echo $DB3->last_query();exit;

			foreach ($plans as &$plan) {
				// Add topic_title
				$topic = $DB3->where('topic_id', $plan->topic_id)->get('syllabus_topics')->row();
				$plan->topic_title = $topic ? $topic->topic_title : '';
				$plan->topic_order = $topic ? $topic->topic_order : '';

				// Add subtopic_title
				if (!empty($plan->subtopic_id)) {
					$sub = $DB3->where('subtopic_id', $plan->subtopic_id)->get('syllabus_subtopics')->row();
					$plan->subtopic_title = $sub ? $sub->subtopic_title : '';
					$plan->srno = $sub ? $sub->srno : '';
				} else {
					$plan->subtopic_title = '';
					$plan->srno = '';
				}
			}

		// Load the view into a variable
		$data['plans'] = $plans;
		$data['subject'] = $subject;
		$data['division'] = $division;
		$data['semester'] = $semester;
		$data['batch'] = $batch;
		$data['campus_id'] = $campus_id;
		$html = $this->load->view('lecture_plan/pdf_template', $data, true);

		$this->load->library('m_pdf');
        $mpdf = new Mpdf(['format' => 'A4-L']);
		$mpdf->SetHTMLFooter('
    <div style="width:100%; font-size:10px; text-align: right;">
        
        Page {PAGENO} of {nb}
    </div>
');
		$mpdf->WriteHTML($html);
		

		$mpdf->Output("Lecture_Plan_{$subject->subject_name}.pdf", "D"); // Download
	}
	function get_topic_title($topic_id) {
		$CI =& get_instance();
		$DB3 = $CI->load->database('obe', TRUE);
		$row = $DB3->where('topic_id', $topic_id)->get('syllabus_topics')->row();
		return $row ? $row->topic_title : '';
	}

	function get_subtopic_title($subtopic_id) {
		if (!$subtopic_id) return '';
		$CI =& get_instance();
		$DB3 = $CI->load->database('obe', TRUE);
		$row = $DB3->where('subtopic_id', $subtopic_id)->get('syllabus_subtopics')->row();
		return $row ? $row->subtopic_title : '';
	}


}
