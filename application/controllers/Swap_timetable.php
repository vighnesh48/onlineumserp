<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Swap_timetable extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="subject_master";
    var $model_name="Swap_timetable_model";
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
    }	
    //view
    public function index()
    {
		//error_reporting(E_ALL);
		$Tarray_items = array('Tfaculty','Tbatch_no','Tsub_type','Tcourse_id','Tstream_id','Tsemester','Tdivision','Tsubject');
        $this->session->unset_userdata($Tarray_items);
		
		$this->load->model('Subject_model');
        $this->load->view('header',$this->data); 
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);
		$this->data['academic_year']= $this->Swap_timetable_model->fetch_Allacademic_session();
		/////////////////
		$this->data['faculty'] = $this->Swap_timetable_model->fetch_faculties();
		// $this->data['subjects'] = $this->Swap_timetable_model->fetch_subjects();


		if($_POST['faculty'] !=''){

			// $this->data['faculty'] = $this->Swap_timetable_model->fetch_faculties();

			$academicyear = $_POST['academic_year'];

			/////////////////////
			$faculty = $_POST['faculty'];
			$date = $_POST['date'];


			$this->data['academicyear'] =$_POST['academic_year'];
			$this->data['faculty_id'] =$_POST['faculty'];
			$this->data['ddate'] = $_POST['date'];

			//put values in session
			$this->session->set_userdata('TScourse_id',$_POST['course_id']);
			$this->session->set_userdata('TSstream_id',$_POST['stream_id']);
			$this->session->set_userdata('TSsemester',$_POST['semester']);
			$this->session->set_userdata('TSdivision',$_POST['division']);
			$this->session->set_userdata('TSacdyr',$_POST['academic_year']);
			$this->session->set_userdata('Tbatch_no',$_POST['batch_no']);
			$this->session->set_userdata('Tfaculty', $_POST['faculty']);

			/*if($faculty == 'ALL'){

				$this->data['tt_details']=$this->Swap_timetable_model->get_tt_details($academicyear);

			}
			else
			*/
			
			{
				$this->data['tt_details']=$this->Swap_timetable_model->get_data_by_faculty($faculty, $academicyear, $date);
			}
        }
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }


	public function fetch_faculty_swap() {
		header('Content-Type: application/json');
	
		// Load database connection (assuming CodeIgniter 3)
		$DB1 = $this->load->database('umsdb', TRUE);
	
		// Get POST parameters
		$timetable_id = $this->input->post('timetable_id');
		$faculty_id = $this->input->post('faculty_id');
		$subject_code = $this->input->post('subject_code');
		$division = $this->input->post('division');
		$batch = $this->input->post('batch');
		$academic_year = $this->input->post('academic_year');
		$course_id = $this->input->post('course_id');
		$stream_id = $this->input->post('stream_id');
		$semester = $this->input->post('semester');
		$date = $this->input->post('date');
		$academic_ssn = $this->input->post('academic_ssn');
	
		// Fetch faculties based on course, stream, and semester criteria
		$query1 = "SELECT f.* 
			FROM lecture_time_table tt
			LEFT JOIN vw_faculty f ON tt.faculty_code = f.emp_id
			WHERE tt.faculty_code is not null and tt.academic_year='$academic_year' and academic_session='$academic_ssn' and tt.course_id = ? 
			#AND tt.stream_id = ? 
			#AND tt.semester = ? 
			GROUP BY tt.faculty_code
			ORDER BY tt.faculty_code ASC";
	
		$facultyResult = $DB1->query($query1, [$course_id, $stream_id, $semester])->result_array();
	
		// Fetch subjects based on division, batch, academic year, course, stream, and semester
		$query2 = "SELECT DISTINCT s.sub_id, s.subject_name 
			FROM lecture_time_table tt
			LEFT JOIN subject_master s ON tt.subject_code = s.sub_id
			WHERE tt.faculty_code is not null and tt.academic_year='$academic_year' and academic_session='$academic_ssn' and tt.division = ? 
			AND tt.batch_no = ? 
			AND tt.academic_year = ? 
			AND tt.course_id = ? 
			AND tt.stream_id = ? 
			AND tt.semester = ?
			ORDER BY s.subject_name ASC";
	
		$subjectResult = $DB1->query($query2, [$division, $batch, $academic_year, $course_id, $stream_id, $semester])->result_array();
	
		// Debugging output - Check the generated query (Remove this in production)
		// echo $DB1->last_query(); exit;
	
		// Check if results are found and return JSON response
		if (!empty($facultyResult) || !empty($subjectResult)) {
			echo json_encode([
				"success" => true,
				"faculty" => $facultyResult,
				"subjects" => $subjectResult
			]);
		} else {
			echo json_encode([
				"success" => false,
				"message" => "No data found."
			]);
		}
	}
	

    public function swap_faculty_subjects() {
        header('Content-Type: application/json');
    
        // Get POST data
        $var = $_POST;
        
        $timetable_id = $var['timetable_id'];
        $faculty_id = $var['faculty_id'];
        $subject = $var['subject'];
        $div = $var['division'];
        $btch = $var['batch'];
        $academic_yr = $var['academic_year'];
        $academic_ssn = $var['academic_session'];
        $cours = $var['course'];
        $strid = $var['stream_id'];
        $sem = $var['semester'];
        $sub_type = $var['sub_type'];
        $sub_code = $var['sub_code'];
        $lect_slot = $var['lect_slot'];
        $ddate = $var['date'];
    
        $day_of_week = date('l', strtotime($ddate));
      //  print_r($timetable_id);exit;
        // Load Database Connection
        $DB1 = $this->load->database('umsdb', TRUE);
    
        // Start a transaction
        $DB1->trans_start();
    
        // Check if an alternate lecture record already exists
        $DB1->where([
            'lect_time_table_id' => $timetable_id,
            'division' => $div,
            'batch_no' => $btch,
            'academic_year' => $academic_yr,
            'academic_session' => $academic_ssn,
            'course_id' => $cours,
            'stream_id' => $strid,
            'semester' => $sem,
            'subject_type' => $sub_type,
            'lecture_slot' => $lect_slot,
            'wday' => $day_of_week
        ]);
        $existingRecord = $DB1->get('alternet_lecture_time_table')->row_array();
    
        if ($existingRecord) {
            // If record exists, update it
            $updateData = [
                'dt_date' => $ddate,
                'faculty_code' => $faculty_id,
                'subject_code' => $subject,
                'updated_by' => $this->session->userdata('uid'),
                'updated_on' => date('Y-m-d H:i:s')
            ];
    
            $DB1->where('lect_time_table_id', $timetable_id);
            $DB1->update('alternet_lecture_time_table', $updateData);
    
        } else {
            // Insert new alternate lecture
            $insertData = [
                'lect_time_table_id' => $timetable_id,
                'faculty_code' => $faculty_id,
                'division' => $div,
                'batch_no' => $btch,
                'academic_year' => $academic_yr,
                'academic_session' => $academic_ssn,
                'course_id' => $cours,
                'stream_id' => $strid,
                'semester' => $sem,
                'subject_type' => $sub_type,
                'subject_code' => $subject,
                'lecture_slot' => $lect_slot,
                'dt_date' => $ddate,
                'wday' => $day_of_week,
                'inserted_by' => $this->session->userdata('uid'),
                'inserted_on' => date('Y-m-d H:i:s')
            ];
    
            $DB1->insert('alternet_lecture_time_table', $insertData);
        }
    
        // Ensure `time_table_id` is correctly referenced in `lecture_time_table`
        
        $DB1->where([
            'time_table_id' => $timetable_id
        ]);
        $DB1->update('lecture_time_table', ['is_swap' => 'Y']);
    
        // echo $DB1->last_query();exit; 
        // Commit transaction
        $DB1->trans_complete();
    
        if ($DB1->trans_status() === FALSE) {
            // If transaction failed, rollback and return error
            echo json_encode([
                'success' => false,
                'message' => 'Error swapping faculty and subject.'
            ]);
        } else {
            // Transaction successful
            echo json_encode([
                'success' => true,
                'message' => 'Faculty and Subject swapped successfully.'
            ]);
        }
    }
	
	
	public function generate_pdf()
    {
        $faculty = $this->input->get('faculty');
        $academic_year = $this->input->get('academic_year');
        $date = $this->input->get('date');
    
        if (empty($faculty) || empty($academic_year) || empty($date)) {
            show_error('Invalid input parameters', 400);
            return;
        }
    
        $this->load->model('Swap_timetable_model');
        $this->load->library('m_pdf');
    
        // Fetch data for swapped timetable
        $tt_details = $this->Swap_timetable_model->get_swap_data($faculty, $academic_year, $date);
    
        if (empty($tt_details)) {
            show_error('No swapped records found', 404);
            return;
        }
    
        $headerHTML = '
        <table style="width: 100%; border: none; font-size: 12px;">
            <tr>
                <td style="width: 20%; text-align: center; border: none;">
                    <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">
                </td>
                <td style="width: 60%; text-align: center; border: none;">
                    <div style="font-size: 24px; font-weight: bold;color: red;">Sandip University</div>
                    <div style="font-size: 12px; color: #242424;">Mahiravani, Trimbak Road, Nashik - 422 213</div>
                    <div style="font-weight: bold; font-size: 14px;">Swapped Timetable Report</div>
                </td>
                <td style="width: 20%; text-align: center; border: none;">
                    <div style="font-size: 30px; font-weight: bold;"></div>
                </td>
            </tr>
        </table>
        <hr>';
    
        $footerHTML = '
        <div style="text-align: center; font-size: 10px;">
            Page {PAGENO} of {nbpg}
        </div>';
    
        // Load the view and generate PDF content
        $pdfContent = $this->load->view($this->view_dir . 'swap_timetable_pdf', ['tt_details' => $tt_details], true);
    
        // Initialize mPDF
        $mpdf = new mPDF('L', 'A4-L', '', '', 5, 5, 35, 15, 5, 5);
        $mpdf->SetHTMLHeader($headerHTML);
        $mpdf->SetHTMLFooter($footerHTML);
        $mpdf->WriteHTML($pdfContent);
    
        // Output PDF directly in the browser without saving
        $mpdf->Output("Swapped_Timetable.pdf", "I");
    }



    

}
?>