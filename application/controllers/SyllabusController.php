<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SyllabusController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Syllabus_model');
        $this->load->library('upload');
        $this->load->library('excel');
    }
    public function index($subject_id = null,$campus_id = null) {
		$this->load->view('header',$this->data);
		if (!$subject_id) {
			show_error("Subject ID is required", 400);
		}
		$data['subject_id'] = $subject_id;
		$data['campus_id'] = $campus_id;
		$data['subject'] = $this->Syllabus_model->getSubjectById($subject_id,$campus_id); // fetch subject name/code
		//print_r($data['subject']);exit;
        $data['topics'] = $this->Syllabus_model->getTopicsWithSubtopics($subject_id,$campus_id);
        $this->load->view('Syllabus/index', $data);
		$this->load->view('footer');
    }

    public function add_topic() {
        if ($_POST) {
            $this->Syllabus_model->insertTopic($this->input->post());
            redirect('SyllabusController');
        }
		$this->load->view('header',$this->data);   
        $this->load->view('Syllabus/add_topic');
		$this->load->view('footer');
    }

    public function edit_topic($id) {
        $data['topic'] = $this->Syllabus_model->getTopic($id);
        if ($_POST) {
            $this->Syllabus_model->updateTopic($id, $this->input->post());
            redirect('SyllabusController');
        }
		$this->load->view('header',$this->data);   
        $this->load->view('Syllabus/edit_topic', $data);
		$this->load->view('footer');
    }

    public function delete_topic($id) {
        $this->Syllabus_model->deleteTopic($id);
        redirect('SyllabusController');
    }

    public function add_subtopic($topic_id) {
        if ($_POST) {
            $data = $this->input->post();
            $data['topic_id'] = $topic_id;
            $this->Syllabus_model->insertSubtopic($data);
            redirect('SyllabusController');
        }
        $this->load->view('syllabus/add_subtopic', ['topic_id' => $topic_id]);
    }

    public function edit_subtopic($id,$subject_id,$campus_id) {
		$this->load->view('header',$this->data);   
		$data['subject_id'] = $subject_id;
		$data['campus_id'] = $campus_id;
        $data['subtopic'] = $this->Syllabus_model->getSubtopic($id);
        if ($_POST) {
            $this->Syllabus_model->updateSubtopic($id, $this->input->post());
           redirect('SyllabusController/index/' . $subject_id.'/'.$campus_id);
        }
        $this->load->view('Syllabus/edit_subtopic', $data);
		$this->load->view('footer');
    }

    public function delete_subtopic($id,$subject_id,$campus_id) {
        $this->Syllabus_model->deleteSubtopic($id,$subject_id,$campus_id);
        redirect('SyllabusController/index/' . $subject_id.'/'.$campus_id);
    }
	public function deletesubjectsyllabus($subject_id,$campus_id) {
        $this->Syllabus_model->deleteSyllabusBySubjectId($subject_id,$campus_id);
        redirect('SyllabusController/index/' . $subject_id.'/'.$campus_id);
    }
	public function import_excel() {
		$subject_id = $this->input->post('subject_id');
		$campus_id = $this->input->post('campus_id');
		if (!$subject_id) {
			$this->session->set_flashdata('message', 'Subject ID is required.');
			redirect('SyllabusController/index/' . $subject_id.'/'.$campus_id);
		}
		$this->load->library('excel');
		$DB3 = $this->load->database('obe', TRUE);
		if (!empty($_FILES['excel_file']['name'])) {
			$allowed = ['xls', 'xlsx'];
			$ext = pathinfo($_FILES['excel_file']['name'], PATHINFO_EXTENSION);

			if (!in_array($ext, $allowed)) {
				$this->session->set_flashdata('message', 'Invalid file type. Only .xls or .xlsx allowed.');
				redirect('SyllabusController/index/' . $subject_id.'/'.$campus_id);
			}

			$path = $_FILES['excel_file']['tmp_name'];
			$object = PHPExcel_IOFactory::load($path);
			$topic_id = 0;

			foreach ($object->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();

				for ($row = 2; $row <= $highestRow; $row++) {
					$sr_no         = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
					$topic         = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
					$order_no      = trim($worksheet->getCellByColumnAndRow(2, $row)->getValue());
					$co            = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue());
					$hours         = (int) $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$minutes       = (int) $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$is_main_topic = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue()); // Last column

					if ($is_main_topic == "1") {
						// Insert into syllabus_topics
						$DB3->insert('syllabus_topics', [
							'topic_title' => $topic,
							'campus_id'  => $campus_id,
							'subject_id'  => $subject_id,
							'topic_order' => $order_no,
							'tcos'             => $co,
							'thours'          => $hours,
							'tminutes'        => $minutes,
							'inserted_on' => date('Y-m-d H:i:s')
						]);
						 $topic_id = $DB3->insert_id(); // Save for subtopics
						//echo 1; $DB3->last_query();exit;
					} elseif ($is_main_topic == "0" && $topic_id) {
						// Insert into syllabus_subtopics
						$DB3->insert('syllabus_subtopics', [
							'topic_id'        => $topic_id,
							'srno'            => $sr_no,
							'campus_id'  => $campus_id,
							'subject_id'  => $subject_id,
							'subtopic_title'  => $topic,
							'subtopic_order'  => $order_no,
							'cos'             => $co,
							'shours'          => $hours,
							'sminutes'        => $minutes,
							'status'          => 1,
							'inserted_on'     => date('Y-m-d H:i:s'),
							'inserted_by'     => 'admin'
						]);
					}
				}
			}

			$this->session->set_flashdata('message', 'Excel imported successfully!');
    } else {
        $this->session->set_flashdata('message', 'No file selected.');
    }

    redirect('SyllabusController/index/' . $subject_id.'/'.$campus_id);
		
}



    public function references($subtopic_id) {
        if ($_POST) {
            $this->Syllabus_model->addReference($subtopic_id, $this->input->post());
            redirect('SyllabusController');
        }
        $data['references'] = $this->Syllabus_model->getReferences($subtopic_id);
        $data['subtopic_id'] = $subtopic_id;
        $this->load->view('syllabus/references', $data);
    }
	public function download_pdf($subject_id, $campus_id) {
        // Get subject details and topics/subtopics
		$data['subject_id'] = $subject_id;
		$data['campus_id'] = $campus_id;
        $data['subject'] = $this->Syllabus_model->getSubjectById($subject_id, $campus_id);
        $data['topics'] = $this->Syllabus_model->getTopicsWithSubtopics($subject_id, $campus_id);

        // Load view as HTML
        $html = $this->load->view('Syllabus/syllabus_pdf_template', $data, TRUE);

        // Load mPDF
		$this->load->library('m_pdf');
        $mpdf = new Mpdf(['format' => 'A4-L']);
        $mpdf->WriteHTML($html);
        $mpdf->Output("syllabus_" . $subject_id . ".pdf", "D"); // Force download
    }
public function download_syllabus_sample() {
    $this->load->library('excel'); // Load PHPExcel

    $objPHPExcel = new PHPExcel();
    $sheet = $objPHPExcel->getActiveSheet();

    // Headers
    $headers = [
        'Sr. No.',
        'Topic',
        'Order No.',
        'Course Outcome',
        'Hours',
        'Minutes',
        'Is Main Topic'
    ];

    // Add header row with bold style and yellow fill
    $col = 0;
    foreach ($headers as $header) {
        $sheet->setCellValueByColumnAndRow($col, 1, $header);
        $sheet->getStyleByColumnAndRow($col, 1)->getFont()->setBold(true);
        $sheet->getStyleByColumnAndRow($col, 1)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
              ->getStartColor()->setRGB('FFFF00');
        $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        $col++;
    }

    // Row 2: Main Topic
    $sheet->setCellValueExplicit("A2", '1', PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicit("B2", 'Linear Data Structure Using Sequential Organization', PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicit("C2", '1', PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicit("D2", '', PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValue("E2", '');
    $sheet->setCellValue("F2", '');
    $sheet->setCellValue("G2", '1');

    // Row 3: Subtopic
    $sheet->setCellValueExplicit("A3", '1.1', PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicit("B3", 'Storage Representation and their Address Calculation: Row major and Column Major', PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicit("C3", '1', PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicit("D3", 'CO1', PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValue("E3", 1);
    $sheet->setCellValue("F3", 0);
    $sheet->setCellValue("G3", '0');

    // Output file
    $filename = 'syllabus_sample_format.xls';
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}
	
	
}

