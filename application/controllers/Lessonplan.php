<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(E_ALL);
class Lessonplan extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="subject_master";
    var $model_name="Subject_model";
    var $model;
    var $view_dir='Lessonplan/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        $this->load->helper("url");		
        $this->load->library('form_validation');
        $this->load->model("Lessonplan_model");	
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
		$this->load->view('header',$this->data); 
		$this->load->model('Attendance_model');
		$this->load->model('Lessonplan_model');
		$emp_id = $this->session->userdata("name");
		$curr_session= $this->Attendance_model->getCurrentSession();
		$this->data['sb']= $this->Lessonplan_model->getFacultySubjects_for_markattendance($emp_id, $curr_session[0]['academic_session'], $curr_session[0]['academic_year']);		
		$this->data['academic_year'] = $curr_session[0]['academic_year'];
        $this->load->view($this->view_dir.'view_faculty_subjects',$this->data);
        $this->load->view('footer');

	}
	public function planning($subject_details='')
    {
		$subdetails =base64_decode($subject_details);
		$sub = explode('~', $subdetails);
		$subject_id= $sub[0];
		$stream_id= $sub[1];
		$semester= $sub[2];
		$division= $sub[3];
		$this->data['subdetails']=$subdetails;
		$this->load->view('header',$this->data); 
		$this->load->model('Timetable_model');
		$emp_id = $this->session->userdata("name");
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
		$academic_year =$this->data['academic_year'][0]['academic_year']; 
		$academic_session =$this->data['academic_year'][0]['academic_session']; 
		$this->data['sub']=$this->Subject_model->fetch_subject_details($subject_id);
		$this->data['wdays']=$this->Lessonplan_model->fetch_subject_timetable($subject_id,$emp_id,$academic_year,$academic_session,$stream_id,$semester,$division);
		$this->data['topics']=$this->Lessonplan_model->fetch_subject_syllabus($subject_id);
		$this->data['lessonplan']=$this->Lessonplan_model->fetch_subject_lessonplan($subject_id);		
		$this->data['academicyear'] = $curr_session[0]['academic_year'];
        $this->load->view($this->view_dir.'add_lectplan',$this->data);
        $this->load->view('footer');
	}	
    // load practical mrks streams
	function load_subtopics() {
		$this->load->model('Lessonplan_model');
        $this->data['subtpc'] = $this->Lessonplan_model->load_subtopics($_POST);
		echo $this->load->view($this->view_dir.'subtopic_ajax',$this->data);
    }
	function add() {
		$this->load->model('Lessonplan_model');
        $this->data['subtpc'] = $this->Lessonplan_model->add_lplan($_POST);
		$subdetails = base64_encode($_POST['sub_details']);
		redirect(base_url('lessonplan/planning/'.$subdetails));
    }
	//plan details
	public function plandetails($subject_details)
    {
    	$this->load->model('Attendance_model');
		$this->load->model('Lessonplan_model');
		$this->load->model('Timetable_model');
		
		$subdetails =base64_decode($subject_details);
		$sub = explode('~', $subdetails);
		$subject_id= $sub[0];
		$stream_id= $sub[1];
		$semester= $sub[2];
		$division= $sub[3];
		
		$this->data['subdetails']=$subdetails;
		$this->load->view('header',$this->data); 
		$emp_id = $this->session->userdata("name");
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
		$academic_year =$this->data['academic_year'][0]['academic_year']; 

		$academic_session =$this->data['academic_year'][0]['academic_session']; 
		$this->data['sub']=$this->Subject_model->fetch_subject_details($subject_id);
		$this->data['wdays']=$this->Lessonplan_model->fetch_subject_timetable($subject_id,$emp_id,$academic_year,$academic_session,$stream_id,$semester,$division);
		$this->data['topics']=$this->Lessonplan_model->fetch_subject_syllabus($subject_id);
		$this->data['lessonplan']=$this->Lessonplan_model->fetch_subject_lessonplan($subject_id,$academic_year);
		
		$curr_session= $this->Attendance_model->getCurrentSession();		
		$this->data['academicyear'] = $curr_session[0]['academic_year'];
        $this->load->view($this->view_dir.'lectplan_details',$this->data);
        $this->load->view('footer');
	}
	public function edit($subject_details)
    {
    	 	$this->load->model('Attendance_model');
		$subdetails =base64_decode($subject_details);
		$sub = explode('~', $subdetails);

		$subject_id= $sub[0];
		$stream_id= $sub[1];
		$semester= $sub[2];
		$division= $sub[3];
		$this->data['subdetails']=$subdetails;
		$this->load->view('header',$this->data); 
		$this->load->model('Timetable_model');
		$emp_id = $this->session->userdata("name");
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
		$academic_year =$this->data['academic_year'][0]['academic_year']; 
		$academic_session =$this->data['academic_year'][0]['academic_session']; 
		$this->data['sub']=$this->Subject_model->fetch_subject_details($subject_id);

		$this->data['wdays']=$this->Lessonplan_model->fetch_subject_timetable($subject_id,$emp_id,$academic_year,$academic_session,$stream_id,$semester,$division);
		$this->data['topics']=$this->Lessonplan_model->fetch_subject_syllabus($subject_id);
		$this->data['lessonplan']=$this->Lessonplan_model->fetch_subject_lessonplan($subject_id);
		//$curr_session= $this->Attendance_model->getCurrentSession();		
		$this->data['academicyear'] = $curr_session[0]['academic_year'];
        $this->load->view($this->view_dir.'edit_lectplan',$this->data);
        $this->load->view('footer');
	}
	public function delete($subject_details,$lplanid)
    { 
    	 $this->load->model('Attendance_model');
		//$subdetails =base64_decode($subject_details);
		$lplanidd =base64_decode($lplanid);
		//$sub = explode('~', $subdetails);
		$this->Lessonplan_model->delete_lecture_plan_details($lplanidd);
    	redirect(base_url('Lessonplan/plandetails/'.$subject_details));
	}	

	 public function downloadpdf($subject_details)
    {

    	$subdetails =base64_decode($subject_details);
		$sub = explode('~', $subdetails);
		$subject_id= $sub[0];
		$stream_id= $sub[1];
		$semester= $sub[2];
		$division= $sub[3];
		$Batch= $sub[4];
		$academic_year=$sub[5];
        //error_reporting(E_ALL);
        $this->data['division']=$division;
        $this->data['emp_name']=$this->session->userdata("emp_name");
        $this->data['Batch']=$Batch;
        $this->load->model("Subject_model");	
		$this->data['sub']=$this->Subject_model->fetch_subject_details($subject_id);
		$this->data['lessonplan']=$this->Lessonplan_model->fetch_subject_lessonplan($subject_id='',$academic_year='');
        $sem=$this->data['sub'][0]['semester'];
        $this->load->library('m_pdf');
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '20', '20', '20', '10', '70', '10');
		$header =$this->load->view($this->view_dir.'lessionplan_pdf_header',$this->data, true);
		
		$html = $this->load->view($this->view_dir.'lessionpdf_syllabus',$this->data, true);
		
		$pdfFilePath = $this->data['sub'][0]['stream_short_name'].'_'.$sem.".pdf";
		$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center"><tr>
                        <td align="left" class="signature">-------------------------</td>
                        <td align="right" class="signature">-----------------------</td>
                      </tr>
                    
                      <tr>
                        <td align="left" height="50" class="signature"><strong>Dean Signature</strong></td>
                        <td align="right" height="50" class="signature"><strong>COE Signature</strong></td>
                      </tr></table>';
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		//$header = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->SetHTMLHeader($header);
		$this->m_pdf->pdf->AddPage();
		$this->m_pdf->pdf->WriteHTML($html);	
		$this->m_pdf->pdf->SetHTMLFooter($footer);
	    $this->m_pdf->pdf->list_marker_offset = '5.5pt';
		$this->m_pdf->pdf->list_symbol_size = '3.6pt';
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");      
    }
	
	public function Syllabus_Covered_view($academicyear,$semesterNo,$streamID,$subject_id,$division,$batch_no,$faculty_code){
		
		/*$academic_year = explode('~', $academicyear);
		if($academic_year[1]=='WINTER'){
			$insert_arr='WIN';
		}else{
			$insert_arr='SUM';
		}*/
		
		$academicyear=$academicyear;
		$streamID=$streamID;
		$sub_code=$subject_id;
		$division=$division;
		$batch_no=$batch_no;
		$faculty_code=$faculty_code; 


		$this->data['subdetails']=$sub_code.'_'.$streamID.'_'.$semesterNo.'_'.$division.'_'.$batch_no.'_'.$faculty_code.'_'.$academicyear;
		$this->load->view('header',$this->data); 
		
		
		$this->data['sub']=$this->Subject_model->fetch_subject_details($subject_id);
		
		$this->data['Syllabus_Covered']=$this->Lessonplan_model->Syllabus_Covered_view($academicyear,$semesterNo,$streamID,$subject_id,$division,$batch_no,$faculty_code);

		
		
		
		
        $this->load->view($this->view_dir.'lectplan_covered_details',$this->data);
        $this->load->view('footer');
		
		
		
	}

	public function downloadpdf_coverd($subject_details)
    {

    	$subdetails =base64_decode($subject_details);
		$sub = explode('_', $subdetails);
	
		$sub_code= $sub[0];
		$streamID= $sub[1];
		$semesterNo= $sub[2];
		$division= $sub[3];
		$Batch= $sub[4];
		$faculty_code= $sub[5];
		$academicyear= $sub[6];

	
        //error_reporting(E_ALL);
        $this->data['division']=$division;
        $this->data['emp_name']=$this->session->userdata("emp_name");
        $this->data['Batch']=$Batch;
        $this->load->model("Subject_model");	
		$this->data['sub']=$this->Subject_model->fetch_subject_details($sub_code);

		$this->data['Syllabus_Covered']=$this->Lessonplan_model->Syllabus_Covered_view($academicyear,$semesterNo,$streamID,$sub_code,$division,$Batch,$faculty_code);
		/*print_r($this->data['Syllabus_Covered']);
		die;*/

        $sem=$this->data['sub'][0]['semester'];
        $this->load->library('m_pdf');
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '10', '10', '10', '10', '55', '10');
		$header =$this->load->view($this->view_dir.'lessionplan_pdf_header',$this->data, true);
		$html = $this->load->view($this->view_dir.'lessioncoverdpdf_syllabus',$this->data, true);
		$pdfFilePath = $this->data['sub'][0]['stream_short_name'].'_'.$sem.".pdf";
		$footer = '<table  border="0" cellspacing="0" cellpadding="0" align="center"><tr>
                        <td align="left" class="signature">-------------------------</td>
                        <td align="right" class="signature">-----------------------</td>
                      </tr>
                    
                      <tr>
                        <td align="left" height="50" class="signature"><strong>Dean Signature</strong></td>
                        <td align="right" height="50" class="signature"><strong>COE Signature</strong></td>
                      </tr></table>';
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$header = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->SetHTMLHeader($header);
		$this->m_pdf->pdf->AddPage();
		$this->m_pdf->pdf->WriteHTML($html);	
		$this->m_pdf->pdf->SetHTMLFooter($footer);
	    $this->m_pdf->pdf->list_marker_offset = '5.5pt';
		$this->m_pdf->pdf->list_symbol_size = '3.6pt';
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");      
    }
//faculty plandetails
 //    public function facultity_plandetails($subject_details)
 //    {
 //    	$this->load->model('Attendance_model');
	// 	$this->load->model('Lessonplan_model');
	// 	$this->load->model('Timetable_model');
		

		
	// 	$this->data['subdetails']=$subdetails;
	// 	$this->load->view('header',$this->data); 
	
	// 	$this->data['topics']=$this->Lessonplan_model->fetch_subject_syllabus($subject_id);
	// 	$this->data['lessonplan']=$this->Lessonplan_model->fetch_subject_lessonplan($subject_id,$academic_year);		
	// 	$this->data['academicyear'] = $curr_session[0]['academic_year'];
 //        $this->load->view($this->view_dir.'facultyplan_details',$this->data);
 //        $this->load->view('footer');
	// }
	
}
?>