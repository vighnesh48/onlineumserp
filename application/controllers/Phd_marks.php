<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phd_marks extends CI_Controller
{
	
    var $currentModule = "";   
    var $title = "";   
    var $table_name = "unittest_master";    
    var $model_name = "Unittest_model";   
    var $model;  
    var $view_dir = 'Phd_marks/';
 
    public function __construct()
    {     
        //error_reporting(E_ALL); ini_set('display_errors', 1);
        global $menudata;      
        parent::__construct();       
        $this->load->helper("url");     
        $this->load->library('form_validation');        
        if ($this->uri->segment(2) != "" && $this->uri->segment(2) != "submit" && !in_array($this->uri->segment(2), $this->skipActions))
            $title = $this->uri->segment(2); //Second segment of uri for action,In case of edit,view,add etc.       
        else
            $title = $this->master_arr['index'];
        $this->currentModule = $this->uri->segment(1);    
        $this->data['currentModule'] = $this->currentModule;       
        $this->data['model_name'] = $this->model_name;             
        $this->load->library('form_validation');       
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
       
        $model = $this->load->model($this->model_name);
        $menu_name = $this->uri->segment(1);
        
        $this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
        $this->load->model('Phd_marks_model');
    }
    
    
    
    public function index($subje_id='')
    {        
        global $model;
        $this->load->view('header', $this->data);   
		$emp_id = $this->session->userdata("name");
		$this->load->model('Attendance_model');
		$this->data['sb']= $this->Unittest_model->getFacultySubjects($emp_id);
		if(!empty($_POST)){
			$subje_id =  $_POST['subject'];
			$subjectdetails = explode('-', $subje_id);
			$this->data['sub_Code'] = $_POST['subject'];
		}else{
			$subjectdetails = explode('-', base64_decode($subje_id));
			$this->data['sub_Code'] = base64_decode($subje_id);
		}

		if(!empty($subjectdetails[0])){
			$subject_id = $subjectdetails[0];
			$division = $subjectdetails[2];
			$semester = $subjectdetails[4];
			$academic_year = ACADEMIC_YEAR;
			$batch_code = $subjectdetails[1].'-'.$subjectdetails[2].'-'.$subjectdetails[3];
			$this->data['unittest'] = $this->Unittest_model->get_unittest_bySubject($subject_id, $semester, $batch_code, $division, $academic_year);
			$i=0;
			foreach($this->data['unittest'] as $ut){
				$ut_id = $ut['unit_test_id'];
				$this->data['unittest'][$i]['td']=$this->Unittest_model->get_numrows_testdetails($ut_id);
				$i++;
			}		
		}
        $this->load->view($this->view_dir . 'view', $this->data);               
        $this->load->view('footer');
        
    }

     public function add()
    {
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==36){
		}else{
			redirect('home');
		}
		//error_reporting(E_ALL);exit();
      $this->load->model('Phd_exam_timetable_model');
      if($_POST)
      {
		//  echo "<pre>";
		 // print_r($_POST);//exit;
        $this->load->view('header',$this->data);        
		$this->data['school_code'] =$_POST['school_code'];
		$this->data['admissioncourse'] =$_POST['admission-course'];
		$this->data['stream'] =$_POST['admission-branch'];
		$this->data['semester'] =$_POST['semester'];
		$this->data['exam'] =$_POST['exam_session'];
		$this->data['marks_type'] =$_POST['marks_type'];
		$this->data['reval'] =$_POST['reval'];
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_exam_session_for_marks_entry();
		$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		if($_POST['marks_type']=='TH'){
		$this->data['sub_list']= $this->Phd_marks_model->list_exam_subjects($_POST, $exam_id);
				for($i=0;$i< count($this->data['sub_list']); $i++){
					$subjectId = $this->data['sub_list'][$i]['sub_id'];
					$this->data['sub_list'][$i]['mrk']= $this->Phd_marks_model->getMarksEntry($subjectId, $exam_id,$_POST['marks_type'],$_POST['admission-branch'], $_POST['semester'],$_POST['reval']);
				}
		}else{
			$this->data['sub_list']= $this->Phd_marks_model->list_exam_pr_subjects($_POST, $exam_id);
			for($i=0;$i< count($this->data['sub_list']); $i++){
				$subjectId = $this->data['sub_list'][$i]['sub_id'];
				$this->data['sub_list'][$i]['mrk']= $this->Phd_marks_model->getPr_MarksEntry($subjectId, $exam_id,$_POST['marks_type'],$_POST['admission-branch'], $_POST['semester'],$_POST['reval']);
			}
		}

		
		$this->load->view($this->view_dir.'add_marks',$this->data);
		
        $this->load->view('footer');    
      }
      else
      {
      
       $this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
	
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_exam_session_for_marks_entry();
		$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
        $this->load->view($this->view_dir.'add_marks',$this->data);
        $this->load->view('footer');
      
      }
 
        
    } 
     public function edit()
    {
        $this->load->view('header',$this->data);                
        $id=$this->uri->segment(3);
		$this->load->model('Attendance_model');
		$emp_id = $this->session->userdata("name");
		$this->data['classRoom']= $this->Attendance_model->getclassRoom($emp_id);
        $this->data['ut']=$this->Unittest_model->get_unittest_details($id);                            
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
       
    public function marksdetails($testId)
    {
		//error_reporting(E_ALL);
		$testId = base64_decode($testId);
		$this->load->model('Phd_examination_model');
		//echo $subdetails =$this->uri->segment(4);
		//exit;
		$this->data['sub_details'] = $testId;
		$subdetails =explode('~',$testId);
		$sub_id  =$subdetails[0];
		$this->data['stream'] =$subdetails[3];
		$this->data['semester'] =$subdetails[4];
		$this->data['examsession'] =$subdetails[5];
		$this->data['exam_type'] =$subdetails[6];
		$stream_id = $subdetails[3];
		$exam =explode('-',$this->data['examsession']);
		$this->data['allbatchStudent'] = $this->Phd_examination_model->getSubjectStudentList($sub_id,$stream_id, $exam[0], $exam[1], $exam[2]);
		$this->data['ut'] = $this->Phd_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Phd_marks_model->getStreamShortName($subdetails[3]);
		//echo "<pre>";
		//print_r($this->data['ut']);exit;
        $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'add_markdetails',$this->data);
        $this->load->view('footer');
    }
	public function submitMarkDetails()
    {       
        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$stud_id = $_POST['stud_id'];
		$marks_obtained = $_POST['marks_obtained'];
		$enrollement_no = $_POST['enrollement_no'];
		$markentrydate =$this->input->post('markentrydate');
		$max_marks =$this->input->post('max_marks');
		if($markentrydate !=''){
			$markentrydate = str_replace('/', '-', $markentrydate);
            $markentrydate1 = date('Y-m-d', strtotime($markentrydate));
			}else{
			 $markentrydate1 = '0000-00-00';	
			}
		$stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,158,159,162);
		$stream_arr1 = array(43,44,45,46,47);
		
		$subdetails =explode('~',$_POST['sub_details']);
		$subject_id  =$subdetails[0];
		$stream =$subdetails[3];
		$semester =$subdetails[4];
		$examsession =$subdetails[5];
		$marks_type =$subdetails[6];
		if(!empty($subdetails[10])){
		    $is_backlog =$subdetails[10];
		}else{
			$is_backlog ='N';
		}
		if($marks_type=='PR'){
			$division =$subdetails[7];
			$batch_no =$subdetails[8];
			if(empty($subdetails[7]) && empty($subdetails[8])){
				$division ='A';
				$batch_no ='1';
			}
		}else{
			$division ='';
			$batch_no ='';
		}
		$exam =explode('-',$examsession);
		
		if (in_array($stream,  $stream_arr)){
			$specialization_id=9;	
		}else if (in_array($stream,  $stream_arr1)){
			$specialization_id=103;	
		}else{
			$specialization_id=0;	
		}
		
		//insert in master
		$insert_master_array=array(
				"stream_id"=>$stream,
				"specializaion_id"=>$specialization_id,
				"semester"=>$semester,
				"division"=>$division,
				"batch_no"=>$batch_no,
				"subject_id"=>$subject_id,
				"exam_month"=>$exam[0],
				"exam_year"=>$exam[1],
				"exam_id" =>$exam[2],
				"marks_entry_date" => $markentrydate1,
				"marks_type" => $marks_type,	
				"max_marks" => $max_marks,
				"is_backlog" => $is_backlog,
				"entry_by" => $this->session->userdata("uid"),
				"entry_on" => date("Y-m-d H:i:s"),
				"entry_status" => 'Entered'
				); 
				$DB1->insert("phd_marks_entry_master", $insert_master_array); 
				$last_inserted_id_master =$DB1->insert_id();
				//echo $DB1->last_query();
		//echo "<pre>";
		//print_r($insert_master_array);exit;
		for($i=0;$i<count($stud_id);$i++){
			$insert_array=array(
				"me_id"=>$last_inserted_id_master,
				"stud_id"=>$stud_id[$i],
				"enrollment_no"=>$enrollement_no[$i],
				"marks"=>$marks_obtained[$i],
				"stream_id"=>$stream,
				"specialization_id"=>$specialization_id,
				"semester"=>$semester,
				"division"=>$division,
				"batch_no"=>$batch_no,
				"subject_id"=>$subject_id,
				"marks_type" => $marks_type,
				"exam_month"=>$exam[0],
				"exam_year"=>$exam[1],
				"exam_id" =>$exam[2],
				"entry_ip" => $this->input->ip_address(),
				"entry_by" => $this->session->userdata("uid"),
				"entry_on" => date("Y-m-d H:i:s")
				); 
			
			$DB1->insert("phd_marks_entry", $insert_array); 
			//echo $DB1->last_query();exit;
			//echo "<pre>";
		//print_r($insert_array);exit;
			$last_inserted_id=$DB1->insert_id();               
			
		}
        if($last_inserted_id)
			{
				if($marks_type=='PR'){
					//redirect(base_url('Phd_marks/pract_marks_entry'));
					redirect(base_url('Phd_marks/add'));
				}else{
					redirect(base_url('Phd_marks/add'));
				}
			}    
	}
	public function editMarksDetails($testId, $me_id)
    {
		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);
		//echo $testId;
		$this->data['me_id']=$me_id;
		$this->data['sub_details'] = $testId;
		$subdetails =explode('~',$testId); 
		//echo '<pre>';print_r($testId);exit;
		$sub_id  =$subdetails[0];
		$stream_id= $subdetails[3];
		$exss = str_replace('/', '_', $subdetails[5]);
		$exam = explode('-', $exss);
		$exam_id = $exam[2];
		$this->data['reval'] =$subdetails[9];//exit;
		$this->data['ut'] = $this->Phd_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Phd_marks_model->getStreamShortName($subdetails[3]);
		$this->data['me']=$this->Phd_marks_model->fetch_me_details($me_id);
		if($subdetails[9] !='reval'){			
			$this->data['mrks']=$this->Phd_marks_model->get_marks_details($me_id, $exam_id,$subdetails);			
		}else{
			$this->data['mrks']=$this->Phd_marks_model->getSubjectStudentList_reval($sub_id,$stream_id, $exam_id);	
		}		
			
        $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'edit_markdetails',$this->data);
        $this->load->view('footer');
    }
	//update marks
	public function updateStudMarks()
    {       
        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$m_id = $_POST['m_id'];
		$testId = base64_encode($_POST['sub_details']);
		$reval = $_POST['reval'];
		foreach ($_POST['stud_id'] as $spk) {
			$spk_details['stud_id'][] = $spk;
		}
		foreach ($_POST['enrollement_no'] as $spk1) {
			$spk_details['enrollement_no'][] = $spk1;
		}
		foreach ($_POST['mrk_id'] as $spk2) {
			$spk_details['mrk_id'][] = $spk2;
		}
		foreach ($_POST['marks_obtained'] as $spk3) {
			$spk_details['marks_obtained'][] = $spk3;
		}
		
		if (!empty($spk_details) && $reval !='reval') {
			$speakerupdate = $this->Phd_marks_model->updateMarkDetails($spk_details, $m_id); //edit marks detail
		}else{
			$speakerupdate = $this->Phd_marks_model->updateMarkDetails_reval($spk_details, $m_id); //edit reval marks detail
		}
		
		redirect(base_url('Phd_marks/editMarksDetails/'.$testId.'/'.base64_encode($m_id)));
		
		//echo $DB1->last_query();exit;
	} 
	
	//
	public function downloadpdf($testId, $me_id)
    {
		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);
		$this->data['me_id']=$me_id;
		$this->data['sub_details'] = $testId;
		$subdetails =explode('~',$testId);
		$sub_id  =$subdetails[0];
		$exam  =$subdetails[5];
		$examses =explode('-',$exam);
		$exam_id = $examses[2];
		$this->data['streamId'] = $subdetails[3];
		$this->data['ut'] = $this->Phd_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Phd_marks_model->getStreamShortName($subdetails[3]);
		$this->data['me']=$this->Phd_marks_model->fetch_me_details($me_id);	
				//echo "<pre>";		
		//print_r($subdetails);exit;
		if($subdetails[6] !='PR'){
			$this->data['mrks']=$this->Phd_marks_model->download_marks_details($me_id, $exam_id,$subdetails);
		}else{
			$this->data['mrks']=$this->Phd_marks_model->download_pr_marks_details($me_id, $exam_id,$subdetails);			
		}		

		$this->load->library('m_pdf');
		$html = $this->load->view($this->view_dir.'pdf_markdetails',$this->data, true);
		$pdfFilePath1 =$this->data['ut'][0]['subject_code']."_Marks.pdf";
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		
		$mpdf=new mPDF();
		
		//$this->m_pdf->pdf=new mPDF('L','A4-L','','5',5,5,5,5,5,5);
		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath1, "D");
        
    }
	public function downloadCIApdf($testId, $me_id)
    {
		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);
		$this->data['me_id']=$me_id;
		$this->data['sub_details'] = $testId;
		$subdetails =explode('~',$testId);
		$sub_id  =$subdetails[0];
		$this->data['streamId'] = $subdetails[3];
		$this->data['ut'] = $this->Phd_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Phd_marks_model->getStreamShortName($subdetails[3]);
		$this->data['me']=$this->Phd_marks_model->fetch_me_details($me_id);	
		$this->data['mrks']=$this->Phd_marks_model->get_cia_marks_details($me_id);	
		//echo "<pre>";		
		//print_r($this->data['mrks']);
		$this->load->library('m_pdf');
		$html = $this->load->view($this->view_dir.'pdf_cia_markdetails',$this->data, true);
		$header = $this->load->view($this->view_dir.'cia_pdf_header',$this->data, true);
		$pdfFilePath1 =$this->data['ut'][0]['subject_code']."_CIA_Marks.pdf";
		//$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		
		$mpdf=new mPDF();
		
		$this->m_pdf->pdf=new mPDF('L','A4','','5','15',15,60,37,5,5);
		$dattime = date('d-m-Y H:i:s');
		$footer ='
    <table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:12px;">
	<tr>
    <td align="left" colspan="3" class="signature"><i><b>Declaration:</b>  I hereby declare that the above details are correct and verified to the best of my knowledge.
 </i></td>
  </tr>
  <tr>
    <td align="left" colspan="3" class="signature">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" height="50" class="signature"><strong>Signature of Class Coordinator </strong></td>
    <td align="center" height="50" class="signature">&nbsp;</td>
    <td align="right" height="50" class="signature"><strong>Signature of HoD/Dean</strong></td>
   
  </tr>
  <tr>
    <td align="center" colspan="3" class="signature" style="font-size:10px;"><i>Printed on: '.$dattime.'</i></td>
  </tr>
</table>';		
		$header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
		$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->SetHTMLHeader($header1);		
		$this->m_pdf->pdf->SetHTMLFooter($footer);
		//$this->m_pdf->pdf->setFooter('{PAGENO}');
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->AddPage();

		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath1, "D");
        
    }   
	// Veryfies Status
	function veryfyStatus($testId, $me_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);
		$userId =$this->session->userdata("uid");
		
        $update_array = array("verified_by" => $userId, "entry_status"=>'verified',"verified_on" => date('Y-m-d H:i:s'));
        $where = array("me_id" => $me_id);
        $DB1->where($where);

        if ($DB1->update('phd_marks_entry_master', $update_array)) {
			//echo $DB1->last_query();exit;
            $this->session->set_flashdata('msg', 'Verified Successfully');
            redirect(base_url('Phd_marks/editMarksDetails/'.base64_encode($testId).'/'.base64_encode($me_id)));
        } else {
            $this->session->set_flashdata('msg', 'Problem while Verifying');
            redirect(base_url('Phd_marks/editMarksDetails/'.base64_encode($testId).'/'.base64_encode($m_id)));
        }
	}
	// Approve Status
	// Veryfies Status
	function approveStatus($testId, $me_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);
		$userId =$this->session->userdata("uid");	
        $update_array = array("approved_by" => $userId,"entry_status"=>'approved', "approved_on" => date('Y-m-d H:i:s'));
        $where = array("me_id" => $me_id);
        $DB1->where($where);
		
        if ($DB1->update('phd_marks_entry_master', $update_array)) {
			//echo $DB1->last_query();exit;
            $this->session->set_flashdata('msg', 'Verified Successfully');
            redirect(base_url('Phd_marks/editMarksDetails/'.base64_encode($testId).'/'.base64_encode($me_id)));
        } else {
            $this->session->set_flashdata('msg', 'Problem while Verifying');
            redirect(base_url('Phd_marks/editMarksDetails/'.base64_encode($testId).'/'.base64_encode($m_id)));
        }
	}
	/////////////////////////////////////////////////////
	// for CIA
	public function cia()
    {
		//error_reporting(E_ALL); ini_set('display_errors', 1);
      $this->load->model('Phd_exam_timetable_model');
	  $this->load->view('header',$this->data); 
	  $roll_id = $this->session->userdata("role_id");	
	   $emp_id = $this->session->userdata("name");	//110078
	   	  	  
	  if($roll_id==6 || $roll_id==15 || $roll_id==23){

			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['exam'] =$_POST['exam_session'];
			$this->data['marks_type'] =$_POST['marks_type'];
			$this->data['reval'] =$_POST['reval'];
			$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
			$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
			$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_exam_session_for_marks_entry();
			if($_POST){
				
				$exam_month =$this->data['exam_session'][0]['exam_month'];
				$exam_year =$this->data['exam_session'][0]['exam_year'];
				$exam_id =$this->data['exam_session'][0]['exam_id'];
				$this->data['Marks_submission_date']= $this->Phd_marks_model->Marks_submission_date($exam_id);
				//echo "kjkljkl";exit;
				$this->data['exam'] =$exam_month.'-'.$exam_year.'-'.$exam_id;
				$this->data['sub_list']= $this->Phd_marks_model->list_coewise_cia_exam_subjects($emp_id, $curr_session[0]['academic_session'],$exam_id, $curr_session[0]['academic_year'],$_POST);

				for($i=0;$i< count($this->data['sub_list']); $i++){
					$subjectId = $this->data['sub_list'][$i]['sub_id'];
					$stream = $this->data['sub_list'][$i]['stream_id'];
					$semester = $this->data['sub_list'][$i]['semester'];
					$this->data['sub_list'][$i]['mrk']= $this->Phd_marks_model->getCIAMarksEntry($subjectId, $exam_id,'CIA',$stream, $semester);

				}
			}
			$this->load->view($this->view_dir.'add_cia_marks',$this->data);
	  }else{
		  // for faculty
		$this->load->model('Attendance_model');
		$curr_session= $this->Attendance_model->getCurrentSession_for_marks_entry();	
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_curr_exam_session();
		$exam_month=$this->data['exam_session'][0]['exam_month'];
		$exam_year=$this->data['exam_session'][0]['exam_year'];
		$exam_id=$this->data['exam_session'][0]['exam_id'];
		$this->data['Marks_submission_date']= $this->Phd_marks_model->Marks_submission_date($exam_id);
		$this->data['subject']= $this->Phd_marks_model->getFaqExam_applied_subjects($emp_id, $curr_session[0]['academic_session'],$exam_id, $curr_session[0]['academic_year']);
		for($j=0;$j<count($this->data['subject']);$j++){
			
			$subId = $this->data['subject'][$j]['subject_code'];
			$semester = $this->data['subject'][$j]['semester'];
			$stream_id = $this->data['subject'][$j]['stream_id'];
			$subject_component = $this->data['subject'][$j]['subject_component'];
			$this->data['subject'][$j]['batches']= $this->Attendance_model->getFaqSubjectBatches($emp_id, $subId, $subject_component);
			
			$this->data['subject'][$j]['mrk']= $this->Phd_marks_model->getCIAMarksEntry($subId, $exam_month, $exam_year,$marks_type='CIA', $stream_id, $semester);

			// for($i=0;$i<count($this->data['batches']);$i++){
			// 	$batch_code =  $this->data['batches'][$i]['batch_code'];
			// 	$this->data['subject'][$j]['cntLect'][$i]= $this->Attendance_model->getNoOfLecture($emp_id, $subId, $from_date, $to_date, $batch_code);
			// 	$this->data['subject'][$j]['AvgLectPer'][$i]= $this->Attendance_model->avgPerOfSubject($emp_id, $subId, $from_date, $to_date, $batch_code);
			// }
		}
		$this->load->view($this->view_dir.'cia_faculty_subjects',$this->data);
	  }	
	  $this->load->view('footer');
        
    }
	//
	public function ciamarksdetails($testId)
    {
		//error_reporting(E_ALL); ini_set('display_errors', 1);
		$testId = base64_decode($testId);
		$this->load->model('Phd_examination_model');
		$roll_id = $this->session->userdata("role_id");	
	    $emp_id = $this->session->userdata("name");	//110078

		//echo $subdetails =$this->uri->segment(4);
		//exit;
		$this->data['sub_details'] = $testId;
		$subdetails =explode('~',$testId);
		$sub_id  =$subdetails[0];
		$this->data['stream'] =$subdetails[3];
		$this->data['semester'] =$subdetails[4];
		$this->data['examsession'] =$subdetails[5];
		$this->data['exam_type'] =$subdetails[6];
		$this->data['batch_details'] =$subdetails[7];
		$stream_id = $subdetails[3];
		$batch_details = $subdetails[7];
		$batch_code = explode('-',$batch_details);
		$th_batch = $batch_code[2]; //echo $subdetails[5];exit;
		$exam =explode('-',$subdetails[5]); 
		//print_r($exam);
		if($roll_id==6 || $roll_id==15|| $roll_id==23){
			$this->data['allbatchStudent'] = $this->Phd_examination_model->getSubjectStudentList($sub_id,$stream_id, $exam[0], $exam[1], $exam[2]);
		}else{
			$this->data['allbatchStudent'] = $this->Phd_marks_model->get_studbatch_allot_list($batch_details,$th_batch,$sub_id,$stream_id, $subdetails[4]);
			$this->data['allexamStudent'] = $this->Phd_examination_model->getSubjectStudentList($sub_id,$stream_id, $exam[0], $exam[1], $exam[2]);
		}
		$this->data['ut'] = $this->Phd_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Phd_marks_model->getStreamShortName($subdetails[3]);
		//echo "<pre>";
		//print_r($this->data['ut']);exit;
        $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'add_cia_markdetails',$this->data);
        $this->load->view('footer');
    }
	// add CIA marks details
	public function submitCIAMarkDetails()
    {       
        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$stud_id = $_POST['stud_id'];
		$stream_id = $_POST['stream_id'];
		$marks_obtained = $_POST['marks_obtained'];
		$attdance_marks = $_POST['attdance_marks'];
		$enrollement_no = $_POST['enrollement_no'];
		if(!empty($_POST['division']) && $_POST['division'] !=''){
			$division = $_POST['division'];
		}else{
			$division = '';
		}
		if(!empty($_POST['batch']) && $_POST['batch'] !=''){
			$batch = $_POST['batch'];
		}else{
			$batch = '';
		}

		$markentrydate =$this->input->post('markentrydate');
		$max_marks =$this->input->post('max_marks');
		if($markentrydate !=''){
			$markentrydate = str_replace('/', '-', $markentrydate);
            $markentrydate1 = date('Y-m-d', strtotime($markentrydate));
			}else{
			 $markentrydate1 = '0000-00-00';	
			}
		$stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,158,159,162);
		//$stream_arr1 = array(43,44,45,46,47);
		
		$subdetails =explode('~',$_POST['sub_details']);
		$subject_id  =$subdetails[0];
		$streamId =$subdetails[3];
		$semester =$subdetails[4];
		$examsession =$subdetails[5];
		$marks_type =$subdetails[6];
		$exam =explode('-',$examsession);
		if($semester==1 || $semester==2){
			if (in_array($streamId,  $stream_arr)){
				$specialization_id=9;	
			}else{
				$specialization_id=0;	
			}
		}else{
			$specialization_id=0;
		}
		/*else if (in_array($stream,  $stream_arr1)){
				$specialization_id=103;	
			}*/
		//insert in master
		$insert_master_array=array(
				"stream_id"=>$streamId,
				"specializaion_id"=>$specialization_id,
				"semester"=>$semester,
				"division"=>$division,
				"batch_no"=>$batch,
				"subject_id"=>$subject_id,
				"exam_month"=>$exam[0],
				"exam_year"=>$exam[1],
				"exam_id"=>$exam[2],
				"marks_entry_date" => $markentrydate1,
				"marks_type" => $marks_type,	
				"max_marks" => $max_marks,
				"entry_by" => $this->session->userdata("uid"),
				"entry_on" => date("Y-m-d H:i:s"),
				"entry_status" => 'Entered'
				); 
				$DB1->insert("phd_marks_entry_master", $insert_master_array); 
				$last_inserted_id_master =$DB1->insert_id();
		//echo "<pre>";
		//print_r($insert_master_array);exit;
		for($i=0;$i<count($stud_id);$i++){
			
			if($specialization_id==0){
				$stream = $streamId;
			}else{
				$stream = $stream_id[$i];
			}
			$insert_array=array(
				"me_id"=>$last_inserted_id_master,
				"stud_id"=>$stud_id[$i],
				"enrollment_no"=>$enrollement_no[$i],
				"cia_marks"=>$marks_obtained[$i],
				"attendance_marks"=>$attdance_marks[$i],
				"stream_id"=>$stream,
				"specialization_id"=>$specialization_id,
				"semester"=>$semester,
				"division"=>$division,
				"batch_no"=>$batch,
				"subject_id"=>$subject_id,
				"exam_month"=>$exam[0],
				"exam_year"=>$exam[1],
				"exam_id"=>$exam[2],
				"entry_ip" => $this->input->ip_address(),
				"entry_by" => $this->session->userdata("uid"),
				"entry_on" => date("Y-m-d H:i:s")
				); 
			
			$DB1->insert("phd_marks_entry_cia", $insert_array); 
			//echo $last_inserted_id=$DB1->insert_id();    exit;           
			
		}
		$path =base_url().'Phd_marks/cia';
        redirect($path);
		//redirect('Marks/cia');
   
	}
	//edit CIA Marks
	public function editCIAMarksDetails($testId, $me_id)
    {
		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);
		$this->data['me_id']=$me_id;
		$this->data['sub_details'] = $testId;
		$subdetails =explode('~',$testId);
		//print_r($subdetails);
		$sub_id  =$subdetails[0];
		
		$exam = explode('-',$subdetails[5]);
		$exam_id  =$exam[2];
		$this->data['ut'] = $this->Phd_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Phd_marks_model->getStreamShortName($subdetails[3]);
		$this->data['me']=$this->Phd_marks_model->fetch_me_details($me_id);	
		$roll_id = $this->session->userdata("role_id");	  	  
	  if($roll_id==6 || $roll_id==15){
		  $this->data['mrks']=$this->Phd_marks_model->get_ciamarks_details_coe($sub_id, $subdetails[3], $exam_id);
		
	  }else{
		  $this->data['mrks']=$this->Phd_marks_model->get_ciamarks_details($me_id);
	  }		
        $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'edit_cia_markdetails',$this->data);
        $this->load->view('footer');
    }

	//update CIA marks
	public function updateCIAStudMarks()
    {       
        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$m_id = $_POST['m_id'];
		$spk_details['max_marks'] = $_POST['max_marks'];
		$testId = base64_encode($_POST['sub_details']);
		
		foreach ($_POST['stud_id'] as $spk) {
			$spk_details['stud_id'][] = $spk;
		}
		foreach ($_POST['enrollement_no'] as $spk1) {
			$spk_details['enrollement_no'][] = $spk1;
		}
		foreach ($_POST['mrk_id'] as $spk2) {
			$spk_details['mrk_id'][] = $spk2;
		}
		foreach ($_POST['marks_obtained'] as $spk3) {
			$spk_details['marks_obtained'][] = $spk3;
		}
		foreach ($_POST['attdance_marks'] as $spk3) {
			$spk_details['attdance_marks'][] = $spk3;
		}		
		if (!empty($spk_details)) {
			$speakerupdate = $this->Phd_marks_model->updateCIAMarkDetails($spk_details, $m_id); //edit marks detail
		}
		
		redirect(base_url('Phd_marks/editCIAMarksDetails/'.$testId.'/'.base64_encode($m_id)));
		
		//echo $DB1->last_query();exit;
	} 	

// Veryfies Status
	function veryfyCIAStatus($testId, $me_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);
		$userId =$this->session->userdata("uid");
		
        $update_array = array("verified_by" => $userId, "entry_status"=>'verified',"verified_on" => date('Y-m-d H:i:s'));
        $where = array("me_id" => $me_id);
        $DB1->where($where);

        if ($DB1->update('phd_marks_entry_master', $update_array)) {
			//echo $DB1->last_query();exit;
            $this->session->set_flashdata('msg', 'Verified Successfully');
            redirect(base_url('Phd_marks/editCIAMarksDetails/'.base64_encode($testId).'/'.base64_encode($me_id)));
        } else {
            $this->session->set_flashdata('msg', 'Problem while Verifying');
            redirect(base_url('Phd_marks/editCIAMarksDetails/'.base64_encode($testId).'/'.base64_encode($m_id)));
        }
	}
	// Approve Status
	function approveCIAStatus($testId, $me_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$me_id = base64_decode($me_id);
		$testId = base64_decode($testId);
		$userId =$this->session->userdata("uid");	

        $update_array = array("approved_by" => $userId,"entry_status"=>'approved', "approved_on" => date('Y-m-d H:i:s'));
        $where = array("me_id" => $me_id);
        $DB1->where($where);
		
        if ($DB1->update('phd_marks_entry_master', $update_array)) {
			//echo $DB1->last_query();exit;
            $this->session->set_flashdata('msg', 'Verified Successfully');
            redirect(base_url('Phd_marks/editCIAMarksDetails/'.base64_encode($testId).'/'.base64_encode($me_id)));
        } else {
            $this->session->set_flashdata('msg', 'Problem while Verifying');
            redirect(base_url('Phd_marks/editCIAMarksDetails/'.base64_encode($testId).'/'.base64_encode($m_id)));
        }
	}
	// marks entry status
	public function entry_status()
	{
		if($this->session->userdata("role_id")==15){
		}else{
			redirect('home');
		}
	    //error_reporting(E_ALL); ini_set('display_errors', 1);
	    $this->load->model('Phd_exam_timetable_model');
	    if($_POST)
	    {
	         // echo "<pre>";
	         // print_r($_POST);exit;
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission-course'];
	        $this->data['stream'] =$_POST['admission-branch'];
	        $this->data['semester'] =$_POST['semester'];
	        $this->data['exam'] =$_POST['exam_session'];
	        $this->data['marks_type'] =$_POST['marks_type'];
	        $this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_curr_exam_session();
	        $this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
	        $this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
	        $exam= explode('-', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
			$this->load->model('Phd_results_model');
			$this->data['chk1'] = $this->Phd_results_model->check_for_duplicate_result($_POST['admission-branch'], $_POST['semester'], $exam_month, $exam_year, $exam_id);
	        $this->data['sub_list']= $this->Phd_marks_model->list_exam_subjects_for_status_applied($_POST, $exam_id);
	        
	        /*for($i=0;$i< count($this->data['sub_list']); $i++){
	            $subjectId = $this->data['sub_list'][$i]['sub_id'];
	            $this->data['sub_list'][$i]['mrk']= $this->Phd_marks_model->getTHMarksEntryStatus($subjectId, $exam_month, $exam_year,$_POST['marks_type'],$_POST['admission-branch'], $_POST['semester']);
	            $this->data['sub_list'][$i]['cia']= $this->Phd_marks_model->getCIAMarksEntryStatus($subjectId, $exam_month, $exam_year,$_POST['marks_type'],$_POST['admission-branch'], $_POST['semester']);
	        }*/
	        
	        $this->load->view($this->view_dir.'marks_entry_status',$this->data);
	        
	        $this->load->view('footer');
	    }
	    else
	    {
	        
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] ='';
	        $this->data['admissioncourse'] = '';
	        $this->data['stream'] = '';
	        $this->data['semester'] = '';
	        
	        $this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_curr_exam_session();
	        $this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
	        $this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
	        $this->load->view($this->view_dir.'marks_entry_status',$this->data);
	        $this->load->view('footer');
	        
	    }
	    
	} 
	// download marks entry status pdf
	public function download_mrkdentrystatus_pdf($testId='', $me_id='', $cia_me_id='')
    {
		$me_id = base64_decode($me_id);
		$cia_me_id = base64_decode($cia_me_id);
		$testId = base64_decode($testId);
		$this->data['me_id']=$me_id;
		$this->data['sub_details'] = $testId;
		$subdetails =explode('~',$testId);

		$sub_id  =$subdetails[0];//exit;
		$stream =$subdetails[3];
		$semester = $subdetails[4];

		$exam= explode('-', $subdetails[5]);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id = $exam[2];
		
        $this->data['exam_month'] = $exam_month;
		$this->data['exam_year'] = $exam_year;
		
		$this->data['ut'] = $this->Phd_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Phd_marks_model->getStreamShortName($subdetails[3]);
		$this->data['me']=$this->Phd_marks_model->fetch_me_details($me_id);	
		$this->data['mrks']=$this->Phd_marks_model->get_cia_and_thmarks_details($sub_id, $stream, $semester,$exam_id);		

		$this->load->library('m_pdf');
		$html = $this->load->view($this->view_dir.'pdf_marksentry',$this->data, true);
		$pdfFilePath1 =$this->data['ut'][0]['subject_short_name']."_marksentry.pdf";
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		
		$mpdf=new mPDF();

		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath1, "D");
        
    }
    // previous exam grades entry
    public function exam_grade_entry()
	{
	    //error_reporting(E_ALL); ini_set('display_errors', 1);
	    $this->load->model('Phd_exam_timetable_model');
	    $grade_letters= $this->Phd_marks_model->list_grade_letter();
		$this->data['regulatn']= $this->Phd_exam_timetable_model->getRegulation();
	    $grdletr='';
	    foreach ($grade_letters as $grl) {
	    	$grdletr .=$grl['grade_letter'].','; 
	    }
	    //echo $grdletr;exit;
	    $this->data['grade_letters'] = $grdletr.'NA,P,B++,D,A++,F,B++';
	    if($_POST)
	    {
	         // echo "<pre>";
	         // print_r($_POST);exit;
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission-course'];
	        $this->data['stream'] =$_POST['admission-branch'];
	        $this->data['semester'] =$_POST['semester'];
	        $this->data['exam'] =$_POST['exam_session'];
	        $this->data['marks_type'] =$_POST['marks_type'];
	        $this->data['exam_session']= $this->Phd_marks_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
	        $exam= explode('-', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
			$exam_id =$exam[2];
			$exam_sess_acdyer =$exam[3];
	        
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;	       

			$this->data['grde_dt']= $this->Phd_marks_model->fetch_examGrades($_POST, $exam_id);
			$updsateData = $this->data['grde_dt'];
			if(!empty($updsateData)){
				$this->data['stud_list']= $this->Phd_marks_model->list_examresult_students_for_grade($_POST,$exam_id);	
				$this->data['sub_list']= $this->Phd_marks_model->list_examAppliedstud_subjects($_POST, $exam_month, $exam_year);
				//$this->data['stud_list']= $this->Phd_marks_model->update_grade_list_students($_POST,$exam_month, $exam_year,$this->data['exam_id']);	  
				$this->load->view($this->view_dir.'update_exam_marks_entry',$this->data);
			}else{	
				$this->data['stud_list']= $this->Phd_marks_model->list_prev_exam_students($_POST,$exam_sess_acdyer);	
				$this->data['sub_list']= $this->Phd_marks_model->list_prev_exam_stud_subjects($_POST);    
		        $this->load->view($this->view_dir.'prev_exam_marks_entry',$this->data);
	        }
	        $this->load->view('footer');
	    }
	    else
	    {
	        
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] ='';
	        $this->data['admissioncourse'] = '';
	        $this->data['stream'] = '';
	        $this->data['semester'] = '';
	        
	        $this->data['exam_session']= $this->Phd_marks_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
	        $this->load->view($this->view_dir.'prev_exam_marks_entry',$this->data);
	        $this->load->view('footer');
	        
	    }
	    
	    
	} 
	// previous grades entry
	public function insert_prev_exam_marks()
	{
		// echo "<pre>";
		// print_r($_POST);
		$DB1 = $this->load->database('umsdb', TRUE);
		$var['semester'] =$_POST['semester'];
		$var['school'] = $_POST['school'];
		$var['admission-branch'] =$_POST['stream_id'];
		
		$exdetails =explode('~', $_POST['examdetails']);

		$sub_list= $this->Phd_marks_model->list_prev_exam_stud_subjects($var);
		
		for($i=0; $i < count($_POST['stud_id']); $i++) {
			
			$stud_id =$_POST['stud_id'][$i]; 
			$stud_prn =$_POST['stud_prn'][$i];
			foreach ($sub_list as $value) {
				$subname = $value['sub_id']; 
				// $sub_int = $subname.'_int';
				// $sub_ext = $subname.'_ext';
				// $sub_tot = $subname.'_tot';
				$sub_grade = $subname.'_grade';

				// $sub_int_mrk =$_POST[$sub_int][$i];
				// $sub_ext_mrk =$_POST[$sub_ext][$i];
				// $sub_tot_mrk =$_POST[$sub_tot][$i];
				$sub_grade_mrk =$_POST[$sub_grade][$i];

				// $exam_grade_marks = ($sub_ext_mrk * 50)/100;
				// $cia_garde_marks = ($sub_int_mrk * 100)/100;

				$data['student_id'] = $stud_id;
				$data['enrollment_no'] = $stud_prn;
				$data['exam_month'] = $exdetails[0];
				$data['exam_year'] = $exdetails[1];
				$data['exam_id'] = $exdetails[2];
				$data['school_id'] = $var['school'];
				$data['stream_id'] = $var['admission-branch'];
				$data['semester'] = $var['semester'];
				$data['subject_id'] = $value['sub_id'];
				$data['subject_code'] = $value['subject_code'];
				// $data['cia_marks'] = $sub_ext_mrk;
				// $data['exam_marks'] = $sub_int_mrk;
				// $data['cia_garde_marks'] = $cia_garde_marks;
				// $data['exam_grade_marks'] = $exam_grade_marks;
				// $data['final_garde_marks'] = round($exam_grade_marks + $cia_garde_marks);
				$data['result_grade'] = strtoupper($sub_grade_mrk);
				$data['final_grade'] = strtoupper($sub_grade_mrk);
				$data['entry_by'] = $this->session->userdata("uid");
				$data['entry_on'] = date('Y-m-d H:i:s');
				$data['entry_ip'] = $this->input->ip_address();
				//echo "insert <br>";if($sub_int_mrk !='' && $sub_ext_mrk !='' && $sub_tot_mrk !='' && $sub_grade_mrk !=''){
				if($sub_grade_mrk !='NA'){
						$DB1->insert("phd_exam_result_data", $data);
				}
				//echo $DB1->last_query();//echo "insert <br>";
				//exit;

			}
			
			//exit();
		}
		//echo "Inserted Successfully!";
		$this->session->set_flashdata('msg', 'Grade Inserted Successfully!');
        redirect(base_url('Phd_marks/prev_exam_grade_entry/'));
	}
	//update grades
	public function updateStudSubjectGrade()
    {       
        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$result_grade = $_POST['result_grade'];
		$result_id = $_POST['result_id'];	
		//echo "<pre>";
		//print_r($marks);  
		/// maintaing log
 		$sql ="INSERT INTO phd_exam_result_data_log (result_id, student_id, enrollment_no,exam_id,exam_month,exam_year,school_id,stream_id,semester,subject_id,subject_code,cia_marks,	exam_marks,	cia_garde_marks,garce_marks,moderate_marks,exam_grade_marks,final_garde_marks,result_grade,reval_grade,final_grade,entry_by,entry_on,entry_ip,modified_by, modified_on,modified_ip,is_deleted)
 			SELECT result_id, student_id, enrollment_no,exam_id,exam_month,exam_year,school_id,stream_id,semester,subject_id,subject_code,cia_marks,	exam_marks,	cia_garde_marks,garce_marks,moderate_marks,exam_grade_marks,final_garde_marks,result_grade,reval_grade,final_grade,entry_by,entry_on,entry_ip,modified_by, modified_on,modified_ip,is_deleted FROM phd_exam_result_data where result_id='$result_id'";
		//$DB1->query->($sql); 
		$query = $DB1->query($sql);
		$update_array['result_grade'] = strtoupper($result_grade);
		$update_array['final_grade'] = strtoupper($result_grade);
		$update_array['modified_on'] = date('Y-m-d H:i:s');
		$update_array['modified_by'] = $this->session->userdata("uid");
		$update_array['modified_ip'] = $this->input->ip_address();
		$where=array("result_id"=>$result_id);
		$DB1->where($where);                
		$DB1->update('phd_exam_result_data', $update_array);
		echo "SUCCESS";
		//echo $DB1->last_query();exit;
	} 
	// for CIA
	public function cia_report()
    {
    	//error_reporting(E_ALL); ini_set('display_errors', 1);
      $this->load->model('Phd_exam_timetable_model');
	  $this->load->view('header',$this->data); 
	  $roll_id = $this->session->userdata("role_id");	
	  $emp_id = $this->session->userdata("name");	  	  

		  if($_POST)
		  {
			 // echo "<pre>";
			 // print_r($_POST);exit;
			    
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['exam'] =$_POST['exam_session'];
			$this->data['marks_type'] =$_POST['marks_type'];
			$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_curr_exam_session();
			$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
			$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
			$exam= explode('-', $_POST['exam_session']);
			$exam_month = $exam[0];
			$exam_year = $exam[1];
			
			$this->data['exam_month'] = $exam[0];
			$this->data['exam_year'] = $exam[1];
			$this->data['exam_sess_id'] = $exam[2];

			$this->data['sub_list']= $this->Phd_marks_model->list_cia_subjects($_POST);
			$this->data['stud_list']= $this->Phd_marks_model->list_cia_students_of_stream($_POST, $exam[2]);

			
			$this->load->view($this->view_dir.'cia_consolidated_report',$this->data);
			
		  }
		  else
		  {		         
			$this->data['school_code'] ='';
			$this->data['admissioncourse'] = '';
			$this->data['stream'] = '';
			$this->data['semester'] = '';
		
			$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_curr_exam_session();
			$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
			$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
			$this->load->view($this->view_dir.'cia_consolidated_report',$this->data);
		  }
	 
	  $this->load->view('footer');
        
    }	
    // load cia stream

    function load_cia_streams(){
		//echo $_POST["course_id"];exit;
		if($_POST["course_id"] !=''){
			//Get all streams
			$stream = $this->Phd_marks_model->load_cia_streams($_POST["course_id"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			//if($rowCount > 0){
				echo '<option value="">Select Stream</option>';
				echo '<option value="0">All Stream</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['stream_id'] . '">' . $value['stream_short_name'] . '</option>';
				}
			/*} else{
				echo '<option value="">stream not available</option>';
			}*/
		}
	}
	//cia excel report
	public function excel_CIAReport($result_data){
    	//print_r($result_data);
    	//error_reporting(E_ALL); ini_set('display_errors', 1);
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);
		//ini_set('memory_limit', '2048M');
		$subdetails = explode('~', $result_data);
		$stream =$subdetails[0];
		$semester =$subdetails[1];
		$exam_month =$subdetails[2];
		$exam_year =$subdetails[3];
		$exam_id =$subdetails[4];
        $this->data['session']= $exam_month.'-'.	$exam_year;
		$res_data['school_id'] = $school_code;
		$res_data['admission-branch'] = $stream;
		$res_data['semester'] = $semester;
		$res_data['exam_month'] = $exam_month;
		$res_data['exam_year'] = $exam_year;
		$res_data['entry_by'] = $this->session->userdata("uid");
		$res_data['entry_on'] = date('Y-m-d H:i:s');
		$res_data['entry_ip'] = $this->input->ip_address();
		$this->data['semester'] =$semester;
		$this->data['result_info'] = $this->Phd_marks_model->list_cia_students_of_stream($res_data,$exam_id);
		//echo count($result_info);
		$this->data['exam_month'] = $exam[0];
		$this->data['exam_year'] = $exam[1];
		$this->data['exam_sess_id'] = $exam[2];
		
		$this->load->model('Phd_exam_timetable_model');
		//$this->data['exam_sess']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$this->load->model('Phd_examination_model');
		$this->data['StreamShortName'] =$this->Phd_examination_model->getStreamShortName($stream);
		$this->data['sem_subjects'] = $this->Phd_marks_model->list_cia_subjects($res_data);
		//print_r($this->data['sem_subjects']);exit;

		//echo '<pre>';
		//print_r($this->data['result_info']);exit;
        $this->load->view($this->view_dir.'cia_marksheet_excel',$this->data);
    }	
	//
	public function pdf_CIAReport1($result_data){
    	//print_r($result_data);
    	//error_reporting(E_ALL); ini_set('display_errors', 1);
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);
		//ini_set('memory_limit', '2048M');
		$subdetails = explode('~', $result_data);
		$stream =$subdetails[0];
		$semester =$subdetails[1];
		$exam_month =$subdetails[2];
		$exam_year =$subdetails[3];
		$exam_id =$subdetails[4];
		$res_data['school_id'] = $school_code;
		$res_data['admission-branch'] = $stream;
		$res_data['semester'] = $semester;
		$res_data['exam_month'] = $exam_month;
		$res_data['exam_year'] = $exam_year;
		$res_data['entry_by'] = $this->session->userdata("uid");
		$res_data['entry_on'] = date('Y-m-d H:i:s');
		$res_data['entry_ip'] = $this->input->ip_address();
		$this->data['semester'] =$semester;
		$this->data['result_info'] = $this->Phd_marks_model->list_cia_students_of_stream($res_data, $exam_id);
		//echo count($result_info);
		$this->load->model('Phd_exam_timetable_model');
		$this->data['exam_sess']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$this->load->model('Examination_model');
		$this->data['StreamShortName'] =$this->Phd_examination_model->getStreamShortName($stream);
		$this->data['sem_subjects'] = $this->Phd_marks_model->list_cia_subjects($res_data);
		//print_r($this->data['sem_subjects']);exit;

		//echo '<pre>';
		//print_r($this->data['result_info']);exit;
        $this->load->view($this->view_dir.'cia_consolidated_report_pdf',$this->data);
    }
//
     public function pdf_CIAReport($result_data){
    	//$result_data = $_POST['res_data']; 
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);
		ini_set('memory_limit', '2048M');
		$result_data=str_replace('_','/',$result_data);
		$subdetails = explode('~', $result_data);
		//echo $result_data;
		//print_r($subdetails);
		$stream =$subdetails[0];
		$semester =$subdetails[1];
		$exam_month =$subdetails[2];
		$exam_year =$subdetails[3];
		$exam_id =$subdetails[4];
		if($stream=='71'){
			$semester_name = 'Year';
		}else{
			$semester_name = 'Semester';
		}
		$res_data['exam_session'] = $subdetails[2].'-'.$subdetails[3].'-'.$subdetails[4];
		$res_data['school_id'] = $school_code;
		$res_data['admission-branch'] = $stream;
		$res_data['semester'] = $semester;
		$res_data['exam_month'] = $exam_month;
		$res_data['exam_year'] = $exam_year;
		$res_data['entry_by'] = $this->session->userdata("uid");
		$res_data['entry_on'] = date('Y-m-d H:i:s');
		$res_data['entry_ip'] = $this->input->ip_address();
		$this->data['semester'] =$semester;
		$this->data['result_info'] = $this->Phd_marks_model->list_cia_students_of_stream($res_data, $exam_id);
		//echo count($result_info);
		$this->load->model('Phd_exam_timetable_model');
		//$this->data['exam_sess']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$this->load->model('Examination_model');
		$this->data['StreamShortName'] =$this->Phd_examination_model->getStreamShortName($stream);
		$this->data['sem_subjects'] = $this->Phd_marks_model->list_cia_subjects($res_data);
		
		$this->data['exam_month'] = $exam_month;
		$this->data['exam_year'] = $exam_year;
		$this->data['exam_id'] = $exam_id;
        $this->load->library('m_pdf', $param);
	    $this->m_pdf->pdf=new mPDF('utf-8', 'A4-L', '5', '5', '15', '15', '37', '30');
	    $stream_name = $this->data['StreamShortName'][0]['stream_short_name'];
		$school = $this->data['StreamShortName'][0]['school_name'];
	    
	    $header ='<table align="center" width="100%"> 
			<tbody>  
				<tr>
					<td valign="top" height="40">
						<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin-top:15px;">
							<tr>
							<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="http://sandipuniversity.com/erp/assets/images/logo-7.jpg" alt="" width="50" border="0"></td>
							<td style="font-weight:normal;text-align:center;">
								<h1 style="font-size:30px;">Sandip University</h1>
								<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

							</td>
							<td width="120" align="right" valign="middle" style="text-align:right;padding-top:10px;"></td>
						</tr>
							<tr>
								<td></td>
								<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:14px;">CIA REPORT - <u>'.$exam_month.' '.$exam_year.'</u></h3></td>
								<td></td>
							</tr>
            				<tr>
								<td colspan="3">&nbsp;</td>
								
							</tr>
						</table>
						
					</td>
					<td align="center" valign="middle" style="text-align:center;padding-top:10px;"><h3 style="font-size:20px;">COE</h3></td>
				</tr>
            
			            </tbody>
            
				</table>
						<table class="content-table" width="100%" cellpadding="2" cellspacing="2" border="1" align="center" style="font-size:12px;height:150px;">
							<tr>
							<td width="100" height="30" valign="middle"><strong>School : </strong>
								'.$school.'</td>
								<td width="100" height="30" valign="middle"><strong>Stream : </strong>
								'.$stream_name.'</td>
								<td width="100" height="30" valign="middle"><strong>'.$semester_name.' :</strong> '.$semester.'</td>	
								
							</tr>
							

						</table>';
	    
	    $content = $this->load->view($this->view_dir.'cia_consolidated_report_pdf', $this->data, true);
	    $dattime = date('d-m-Y H:i:s');
		$footer ='<table width="100%" border="0" cellspacing="5" cellpadding="5" align="center" style="margin-bottom:40px;">
		<tr><td align="left" width="30%"><b>HOD</b><br><br><span style="font-size:11px;">Name: <br><br>Signature:</span><br><br><br><br></td>
		<td align="left" width="40%"><b>DEAN</b><br><br><span style="font-size:11px;">Name: <br><br>Signature:</span><br><br><br><br></td>
		<td align="left" width="30%"><b>Controller of Examination</b><br><br><span style="font-size:11px;">Name: Dr.Parimala M <br><br>Signature:</span><br><br><br></td>
		</tr></table>';
		$footer .='<table cellpadding="0" cellspacing="0" border="0" width="800" style="margin-bottom:15px;">	
			<tr>
			<td><small><b>{PAGENO}</b></small></td>
			
				<td style="font-size:9px;float:right;text-align:right;"><b style="font-size:9px;float:right;text-align:right;">Printed On: '.date('d-m-Y H:i:s').'</b>
				</td>
			</tr>
			</table>';
	    $header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
	    $this->m_pdf->pdf->SetHTMLHeader($header1);
		$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
		$footer1 = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->AddPage();
		$this->m_pdf->pdf->WriteHTML($content);	
		$this->m_pdf->pdf->setFooter('{PAGENO}');
        $this->m_pdf->pdf->SetHTMLFooter($footer1);
        $fname= $stream_name.'_'.$semester.'_'.$exam_month.'_'.$exam_year;
	    $pdfFilePath = 'cia_consolidated_report_'.$fname.".pdf";

	    //download it.
	    $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }
	    // load cia stream

    function load_cia_semester(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			//Get all streams
			$exam = explode('-',$_POST["exam_session"]);
			$exam_id= $exam[2];
			$stream = $this->Phd_marks_model->get_cia_examsemester($_POST["stream_id"], $exam_id);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Semester</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
				}
			} else{
				echo '<option value="">Semester not available</option>';
			
			}
		}
	}
	//cumulative entry status excel
	public function excel_cumMrkEntryStatus($result_data){
		//error_reporting(E_ALL); ini_set('display_errors', 1);
    	//$result_data = $_POST['res_data']; 
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);
		//ini_set('memory_limit', '2048M');
		$subdetails = explode('~', $result_data);

		$school_code  =$subdetails[0];
		$stream =$subdetails[1];
		$semester =$subdetails[2];
		$exam_month =$subdetails[3];
		$exam_year =$subdetails[4];
		$exam_id =$subdetails[5];
		$this->data['exam_id'] = $exam_id;

		$res_data['school_id'] = $school_code;
		$res_data['admission-branch'] = $stream;
		$this->data['stream'] = $stream;
		$res_data['semester'] = $semester;
		$res_data['exam_month'] = $exam_month;
		$res_data['exam_year'] = $exam_year;
		$this->data['semester'] =$semester;
		
		$this->data['result_info'] = $this->Phd_marks_model->fetch_student_result_data($result_data);
		//echo count($result_info);

		$this->load->model('Phd_exam_timetable_model');
		$this->data['exam_sess']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$this->load->model('Examination_model');
		$this->data['StreamShortName'] =$this->Phd_examination_model->getStreamShortName($stream);
		$this->data['sem_subjects'] = $this->Phd_marks_model->fetch_subjects_exam_semester($result_data);
		//print_r($this->data['sem_subjects']);exit;
		$i=0;
		foreach ($this->data['result_info'] as $res) {
			$stud_id = $res['student_id'];
			$this->data['result_info'][$i]['sub'] = $this->Phd_marks_model->list_exam_subjects_for_status($res_data, $exam_id);
			$i++;
		}
		//echo '<pre>';
		//print_r($this->data['result_info']);exit;
        $this->load->view($this->view_dir.'comulative_mark_entry_excel',$this->data);
    }
	/************** Practical faculty Assign *****************/
	//List
    public function assign_prac_faculty($streamId='', $semester='', $course_id, $school_id, $batch, $acd_year)
    {
		
      $this->load->model('Phd_exam_timetable_model');
	  $this->load->model('Subject_model');
	  $this->load->model('Timetable_model');
	  $this->data['batches']= $this->Subject_model->getRegulation1();
	  $this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session(); 
      if($_POST)
      {
        $this->load->view('header',$this->data);        
		$this->data['school_code'] =$_POST['school_code'];
		$this->data['admissioncourse'] =$_POST['admission-course'];
		$this->data['stream'] =$_POST['admission-branch'];
		$this->data['semester'] =$_POST['semester'];
		$this->data['exam'] =$_POST['exam_session'];
		$this->data['academicyear'] =$_POST['academic_year'];
		$this->data['marks_type'] =$_POST['marks_type'];
		$this->data['batch'] =$_POST['batch'];
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_curr_exam_session();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$this->data['exam_id'] =$exam_id;
		$this->data['sub_list']= $this->Phd_marks_model->list_practsubjects($_POST, $exam_id);
		$this->data['bksub_list']= $this->Phd_marks_model->list_backlogsubjects($_POST, $exam_id);
		
		$sub_batch = $_POST['batch'];
		for($i=0;$i< count($this->data['sub_list']); $i++){
			$subjectId = $this->data['sub_list'][$i]['sub_id'];
			$division = $this->data['sub_list'][$i]['division'];
			$batch_no = $this->data['sub_list'][$i]['batch_no'];
			$this->data['sub_list'][$i]['tt_details']= $this->Phd_marks_model->get_subdetails($subjectId, $_POST['admission-branch'], $_POST['semester'],$exam_id, $division, $batch_no);
		}
		
	//	print_r($this->data['sub_list'][$i]['tt_details']);
		//exit;
	
		for($i=0;$i< count($this->data['bksub_list']); $i++){
			$subjectId = $this->data['bksub_list'][$i]['sub_id'];
			$division = 'A';
			$batch_no = '1';
			$this->data['bksub_list'][$i]['tt_details']= $this->Phd_marks_model->get_subdetails_bklog($subjectId, $_POST['admission-branch'], $_POST['semester'],$exam_id, $division, $batch_no,$sub_batch);
		}
		$this->load->view($this->view_dir.'assign_prac_faculty',$this->data);
		
        $this->load->view('footer');    
      }
      else
      {
      
       $this->load->view('header',$this->data);        
		$this->data['school_code'] =$school_id;
		$this->data['admissioncourse'] = $course_id;
		$this->data['stream'] = $streamId;
		$this->data['semester'] =  $semester;
		$this->data['batch'] =  $batch;
		$this->data['academicyear'] =$acd_year;
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_curr_exam_session();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
        $this->load->view($this->view_dir.'assign_prac_faculty',$this->data);
        $this->load->view('footer');
      
      }
 
        
    } 

     //add view
	public function add_subject_faculty($subject_id,$stream_id,$semester,$exam_id,$school, $division, $batch, $bkflag=''){
	   //error_reporting(E_ALL);
		$this->load->model('Timetable_model');  
		$this->load->view('header',$this->data); 
		$this->data['academicyear']=$academicyear;   
		$this->data['exam_id']=$exam_id;
		$this->data['stream_id_bsc']= $stream_id;
		
	
		if($bkflag==''){
			$this->data['sub']=$this->Phd_marks_model->get_subdetails($subject_id,$stream_id,$semester,$exam_id, $division, $batch);
		}else{
			$this->data['sub']=$this->Phd_marks_model->get_backlogsubdetails($subject_id,$stream_id,$semester,$exam_id, $division, $batch);
		}
		$this->data['faculty_list']=$this->Phd_marks_model->get_faculty_list($stream_id,$semester); 	
		$this->data['exfaculty_list']=$this->Phd_marks_model->get_exfaculty_list(); 		
        $this->load->view($this->view_dir.'add_pract_exam_faculty_subject',$this->data);
        $this->load->view('footer');
	}


public function faculty_subject($subject_id,$stream_id,$semester,$exam_id,$school, $division, $batch, $bkflag=''){
	   //error_reporting(E_ALL);
		
		$this->load->view('header',$this->data); 
		//$this->data['academicyear']=$academicyear;   
		$this->data['exam_id']=$exam_id;
		$this->data['stream_id_bsc']= $stream_id;
		if($bkflag==''){
			$this->data['sub']=$this->Phd_marks_model->get_subdetails($subject_id,$stream_id,$semester,$exam_id, $division, $batch);
		}else{
			$this->data['sub']=$this->Phd_marks_model->get_backlogsubdetails($subject_id,$stream_id,$semester,$exam_id, $division, $batch);
		}
		$this->data['faculty_list']=$this->Phd_marks_model->get_faculty_list($stream_id,$semester); 	
		$this->data['exfaculty_list']=$this->Phd_marks_model->get_exfaculty_list(); 		
        $this->load->view($this->view_dir.'pract_exam_faculty_subject',$this->data);
        $this->load->view('footer');
	}
	// insert 
	public function insert_pract_subject_faculty(){
	    //error_reporting(E_ALL);
		$chk_duplicate = $this->Phd_marks_model->checkDuplicate_pract_faculty($_POST);
		if(!empty($_POST['faculty'])){
			if(count($chk_duplicate) > 0){			
				$this->Phd_marks_model->update_pract_subject_faculty($_POST);
			}
			
			if($this->Phd_marks_model->insert_pract_subject_faculty($_POST))
			{
				
				redirect(base_url($this->view_dir.'assign_prac_faculty/'.$_POST['stream_id'].'/'.$_POST['semester'].'/'.$_POST['course_id'].'/'.$_POST['school_code'].'/'.$_POST['batch']));
			}
			else
			{
				redirect(base_url($this->view_dir.'assign_prac_faculty'));
			}
		}else{
		if(!empty($_POST['change_exfaculty']) || !empty($_POST['exam_date']) || !empty($_POST['exam_from_time']) || !empty($_POST['exam_to_time']) || !empty($_POST['time_format'])){
			//echo "outside";exit;
			$this->Phd_marks_model->update_extpract_subject_faculty($_POST);
			redirect(base_url($this->view_dir.'assign_prac_faculty'));
			}else{
				redirect(base_url($this->view_dir.'assign_prac_faculty'));
			}
		}
	}
	function load_subject_coures(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["school_code"]) && !empty($_POST["school_code"])){
			$stream = $this->Phd_marks_model->load_subject_coures($_POST["school_code"], $_POST["batch"]);
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Course</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">Course not available</option>';
			
			}
		}
	}
	
    public function practical_exam_reports($streamId='', $semester='', $course_id, $school_id, $batch, $acd_year)
    {
		//error_reporting(E_ALL);
      $this->load->model('Phd_exam_timetable_model');
	  $this->load->model('Subject_model');
	  $this->load->model('Timetable_model');
	  $this->data['batches']= $this->Subject_model->getRegulation1();
	  $this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session(); 
      if($_POST)
      {
        $this->load->view('header',$this->data);        
		$this->data['school_code'] =$_POST['school_code'];
		$this->data['admissioncourse'] =$_POST['admission-course'];
		$this->data['stream'] =$_POST['admission-branch'];
		$this->data['semester'] =$_POST['semester'];
		$this->data['exam'] =$_POST['exam_session'];
		$this->data['academicyear'] =$_POST['academic_year'];
		$this->data['marks_type'] =$_POST['marks_type'];
		$this->data['batch'] =$_POST['batch'];
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_curr_exam_session();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$this->data['exam_id'] =$exam_id;
		$this->data['sub_list']= $this->Phd_marks_model->list_practsubjects($_POST, $exam_id);
		$this->data['bksub_list']= $this->Phd_marks_model->list_backlogsubjects($_POST, $exam_id);
		
		for($i=0;$i< count($this->data['sub_list']); $i++){
			$subjectId = $this->data['sub_list'][$i]['sub_id'];
			$division = $this->data['sub_list'][$i]['division'];
			$batch_no = $this->data['sub_list'][$i]['batch_no'];
			$this->data['sub_list'][$i]['tt_details']= $this->Phd_marks_model->get_subdetails($subjectId, $_POST['admission-branch'], $_POST['semester'],$exam_id, $division, $batch_no);
		}
		
		for($i=0;$i< count($this->data['bksub_list']); $i++){
			$subjectId = $this->data['bksub_list'][$i]['sub_id'];
			$division = 'A';
			$batch_no = '1';
			$this->data['bksub_list'][$i]['tt_details']= $this->Phd_marks_model->get_subdetails($subjectId, $_POST['admission-branch'], $_POST['semester'],$exam_id, $division, $batch_no);
		}
		$this->load->view($this->view_dir.'practical_exam_reports',$this->data);
		
        $this->load->view('footer');    
      }
      else
      {
      
       $this->load->view('header',$this->data);        
		$this->data['school_code'] =$school_id;
		$this->data['admissioncourse'] = $course_id;
		$this->data['stream'] = $streamId;
		$this->data['semester'] =  $semester;
		$this->data['batch'] =  $batch;
		$this->data['academicyear'] =$acd_year;
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_curr_exam_session();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
        $this->load->view($this->view_dir.'practical_exam_reports',$this->data);
        $this->load->view('footer');
      
      }   
    } 
	public function download_practical_exam_reports()
    {
		//error_reporting(E_ALL);
		$this->load->model('Examination_model');
		$report_type =$_POST['report_type'];
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$this->data['exam_id'] =$exam_id;
		$this->data['exam_ses'] =$exam_month.'-'.$exam_year;
		
		if($report_type=='Subjectwise'){
			$streamname= $this->Phd_examination_model->getStreamShortName($_POST['admission-branch']);
		$this->data['stream_name'] = $streamname[0]['stream_name'];
		$this->data['semester'] = $_POST['semester'];
			$this->data['sub_list']= $this->Phd_marks_model->list_practsubjects_pdf($_POST, $exam_id);
			$this->data['bksub_list']= $this->Phd_marks_model->list_backlogsubjects_pdf($_POST, $exam_id);

			$this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'pdf_practical_exam_reports',$this->data, true);
			$pdfFilePath1 =$streamname[0]['stream_short_name']."_practical_exam_timetable.pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			$mpdf=new mPDF();
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '30', '10', '10', '10', '35');
			$footer ='<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  
  <tr>
    <td align="center" class="signature" height="50" >&nbsp;</td>
    <td align="center" class="signature">&nbsp;</td>
    <td align="center" class="signature">&nbsp;</td>
   
  </tr>
  <tr>
   <td align="left" height="50" class="signature"><strong>HOD/DEAN Signature</strong></td>
    <td align="right" height="50" class="signature"><strong>COE Signature</strong></td>
  </tr>
</table>';
			$this->m_pdf->pdf->SetHTMLFooter($footer);
			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");

		}elseif($report_type=='Attendane'){
			//$this->data['sub_list']= $this->Phd_marks_model->list_practsubjects_pdf($_POST, $exam_id);
			$sub_list= $this->Phd_marks_model->list_practsubjects_pdf($_POST, $exam_id);
			$bksub_list= $this->Phd_marks_model->list_backlogsubjects_pdf($_POST, $exam_id);
			
			$this->load->library('m_pdf');
			//$html = $this->load->view($this->view_dir.'pdf_practical_exam_attendance',$this->data, true);
			//$pdfFilePath1 ="practical_exam_reports.pdf";
			//$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			$mpdf=new mPDF();
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '30', '10', '10', '60', '35');
			$content='<style>  
			table {  
			font-family: arial, sans-serif;  
			border-collapse: collapse;  
			width: 100%; font-size:12px; margin:0 auto;
			}  
			td{vertical-align: top;}
                      
			.signature{
			text-align: center;
			}
			p{padding:0px;margin:0px;}
			h1, h3{margin:0;padding:0}
			
			.content-table tr td{border:1px solid #333;vertical-align:middle;}
			.content-table th{border:1px solid #333;margin:40px}
			</style> ';
			$k=1;$x=0;$y=0;
			if(!empty($sub_list)){
			foreach($sub_list as $sub){
	   
			   $subdata =$this->Phd_marks_model->fetch_sub_batch_details($sub['sub_id'],$sub['stream_id'],$sub['semester'],$sub['batch'],$sub['academic_year'],$sub['academic_session']);
			   $streamname= $this->Phd_examination_model->getStreamShortName($sub['stream_id']);
				foreach($subdata as $bth){
					$timetl =$this->Phd_marks_model->fetch_pract_timetable($sub['sub_id'],$sub['stream_id'],$sub['semester'],$bth['division'],$bth['batch_no']);
					if(!empty($timetl[$x]['exam_from_time'])){
						$extime = $timetl[$x]['exam_from_time'].':00 -'.$timetl[$x]['exam_to_time'].':00 '.$timetl[$x]['time_format'];
					}else{
						$extime ="";
					}
					$header ='<br><table cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
				<td width="100" align="center" style="text-align:center;padding-top:5px;"><img src="'.base_url().'assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
				<td style="font-weight:normal;text-align:center;">
				<h1 style="font-size:40px;" style="text-align:center;margin:0;padding:0">Sandip University</h1>
				<p style="margin:0;padding:0">Mahiravani, Trimbak Road, Nashik – 422 213</p>
<h3 style="font-size:14px;margin:0;padding:0px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>
		<u style="font-size:13px;">PRACTICAL EXAMINATION ATTENDANCE SHEET - '.$exam_month.'-'.$exam_year.'</u></h3>
				</td>
				<td width="120" align="right" valign="middle" style="text-align:right;">
				<span style="font-size: 20px;"><b>COE</b></span></td>
</tr>
				
				</table><hr>
				<table class="content-table" width="100%" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
				<tr>
				<td width="100" >&nbsp;<strong>Subject Code:</strong></td>
				<td >&nbsp;'.$sub['subject_code'].' - '.$sub['subject_name'].'</td>
				<td width="80" height="30">&nbsp;<strong>Batch:</strong> </td>
				<td >&nbsp;'.$bth['batch_no'].'</td>

							
				</tr>
						   
				<tr>
				<td valign="middle">&nbsp;<strong>Date:</strong></td>
				<td valign="middle">&nbsp;'.$timetl[$x]['exam_date'].', '.$extime.'</td>
				<td valign="middle">&nbsp;<strong>Division:</strong></td>
				<td valign="middle">&nbsp; '.$bth['division'].'</td>
				</tr>
				<tr>
				<td width="100" height="30" valign="middle">&nbsp;<strong>Stream:</strong></td>
				<td  valign="middle">&nbsp;'.$streamname[0]['stream_name'].'</td>
				<td width="80" height="30" valign="middle">&nbsp;<strong>Semester</strong> </td>
				<td height="30" valign="middle">&nbsp;'.$sub['semester'].'</td>
						   
				</tr>
				</table>';
				$studstrength =$this->Phd_marks_model->fetch_student_strength($sub['sub_id'],$sub['stream_id'],$sub['semester'],$bth['division'],$bth['batch_no']);
				
				$content .='<table border="0" cellspacing="5" cellpadding="5" width="100%" class="content-table" style="position: relative;">
				<tr>
				<th width="50" height="30">Sr No.</th>
				<th>PRN</th>
				<th align="left">Name</th>
				<th>Ans.Booklet No</th>
				<th>Candidate.Sign</th>
				</tr>';
			
				$j=1;
				if(!empty($studstrength)){
					foreach($studstrength as $stud){
						//echo $stud['enrollment_no'];
			
						$content .='<tr>
						<td height="30" align="center">'.$j.'</td>
						<td>'.$stud['enrollment_no'].'</td>
						<td>'.$stud['first_name'].' '.$stud['middle_name'].' '.$stud['last_name'].'</td>
						<td></td>
						<td></td>
						</tr>';
			
						$j++;
					}
				}
				$content .='</table>';	
			
				$footer .='<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:40px;">
				<tr>
				<td align="center">
				<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  
  
				<tr>
				<td align="left" class="signature" valign="bottom"><strong>Present :</strong></td>
    
				<td align="center"  class="signature" valign="bottom"><strong>Absent :</strong></td>
   
				<td align="center" class="signature" valign="bottom"><strong>Total :</strong></td>
				<td align="center" class="signature" style="text-align:right"><strong>Internal Examiner</strong></td>
				<td align="right" class="signature" style="text-align:right"><strong>External Examiner</strong></td>
				

		   

   
				</tr>
				</table>

				</td>
				</tr>
				</table><div align="center"><small><b>{PAGENO}</b></small></div>';	

				//$this->m_pdf->pdf->AddPage(); 			 
				//ob_clean();
				$this->m_pdf->pdf->PageNumSubstitutions[] = [
					'from' => 1, 
					'reset' => 0, 
					'type' => 'I', 
					'suppress' => 'off'
				];
				$this->m_pdf->pdf->defaultfooterline = false;
				$header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLHeader($header1);		
				$this->m_pdf->pdf->SetHTMLFooter($footer);
				//$this->m_pdf->pdf->setFooter('{PAGENO}');
				$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->AddPage();
			

				$this->m_pdf->pdf->WriteHTML($content);
				//$footer = $this->load->view($this->view_dir.'attendance_footer', $this->data, true);	
				
				unset($header1);
				unset($header);
				unset($content);
				unset($footer);
				unset($studlist);

				ob_clean();
			}
			
			}
			}
			if(!empty($bksub_list)){
foreach($bksub_list as $bksub){
	   
//echo "inside";exit;
			   $streamname= $this->Phd_examination_model->getStreamShortName($bksub['stream_id']);
				
					$timetl =$this->Phd_marks_model->fetch_bklgpract_timetable($bksub['sub_id'],$bksub['stream_id'],$bksub['semester'],$division='A',$bth_no='1');
					if(!empty($timetl[$y]['exam_from_time'])){
						$extime = $timetl[$y]['exam_from_time'].':00 -'.$timetl[$y]['exam_to_time'].':00 '.$timetl[$y]['time_format'];
					}else{
						$extime ="";
					}
					$header ='<br><table cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
				<td width="100" align="center" style="text-align:center;padding-top:5px;"><img src="'.base_url().'assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
				<td style="font-weight:normal;text-align:center;">
				<h1 style="font-size:40px;" style="text-align:center;margin:0;padding:0">Sandip University</h1>
				<p style="margin:0;padding:0">Mahiravani, Trimbak Road, Nashik – 422 213</p>
<h3 style="font-size:14px;margin:0;padding:0px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>
		<u style="font-size:13px;">PRACTICAL EXAMINATION ATTENDANCE SHEET - '.$exam_month.'-'.$exam_year.'</u></h3>
				</td>
				<td width="120" align="right" valign="middle" style="text-align:right;">
				<span style="font-size: 20px;"><b>COE</b></span></td>
</tr>
				
				</table><hr>
				<table class="content-table" width="100%" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
				<tr>
				<td width="100" >&nbsp;<strong>Subject Code:</strong></td>
				<td >&nbsp;'.$bksub['subject_code'].' - '.$bksub['subject_name'].'</td>
				<td width="80" height="30">&nbsp;<strong>Batch:</strong> </td>
				<td >&nbsp;1</td>

							
				</tr>
						   
				<tr>
				<td valign="middle">&nbsp;<strong>Date:</strong></td>
				<td valign="middle">&nbsp;'.$timetl[$y]['exam_date'].', '.$extime.'</td>
				<td valign="middle">&nbsp;<strong>Division:</strong></td>
				<td valign="middle">&nbsp; A</td>
				</tr>
				<tr>
				<td width="100" height="30" valign="middle">&nbsp;<strong>Stream:</strong></td>
				<td  valign="middle">&nbsp;'.$streamname[0]['stream_name'].'</td>
				<td width="80" height="30" valign="middle">&nbsp;<strong>Semester</strong> </td>
				<td height="30" valign="middle">&nbsp;'.$bksub['semester'].'</td>
						   
				</tr>
				</table>';
				$bkstudstrength =$this->Phd_marks_model->fetch_bklgstudent_strength($bksub['sub_id'],$bksub['stream_id'],$bksub['semester'],$division='A',$bth_no='1');
				
				$content .='<table border="0" cellspacing="5" cellpadding="5" width="100%" class="content-table" style="position: relative;">
				<tr>
				<th width="50" height="30">Sr No.</th>
				<th>PRN</th>
				<th align="left">Name</th>
				<th>Ans.Booklet No</th>
				<th>Candidate.Sign</th>
				</tr>';
			
				$j=1;
				if(!empty($bkstudstrength)){
					foreach($bkstudstrength as $stud){
						//echo $stud['enrollment_no'];
			
						$content .='<tr>
						<td height="30" align="center">'.$j.'</td>
						<td>'.$stud['enrollment_no'].'</td>
						<td>'.$stud['first_name'].' '.$stud['middle_name'].' '.$stud['last_name'].'</td>
						<td></td>
						<td></td>
						</tr>';
			
						$j++;
					}
				}
				$content .='</table>';	
			
				$footer .='<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:40px;">
				<tr>
				<td align="center">
				<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  
  
				<tr>
				<td align="left" class="signature" valign="bottom"><strong>Present :</strong></td>
    
				<td align="center"  class="signature" valign="bottom"><strong>Absent :</strong></td>

   
				<td align="center" class="signature" valign="bottom"><strong>Total :</strong></td>
				<td align="center" class="signature" style="text-align:right"><strong>Internal Examiner</strong></td>
				<td align="right" class="signature" style="text-align:right"><strong>External Examiner</strong></td>
				

		   

   
				</tr>
				</table>

				</td>
				</tr>
				</table><div align="center"><small><b>{PAGENO}</b></small></div>';	

				//$this->m_pdf->pdf->AddPage(); 			 
				//ob_clean();
				$this->m_pdf->pdf->PageNumSubstitutions[] = [
					'from' => 1, 
					'reset' => 0, 
					'type' => 'I', 
					'suppress' => 'off'
				];
				$this->m_pdf->pdf->defaultfooterline = false;
				$header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLHeader($header1);		
				$this->m_pdf->pdf->SetHTMLFooter($footer);
				//$this->m_pdf->pdf->setFooter('{PAGENO}');
				$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->AddPage();
			
				$this->m_pdf->pdf->WriteHTML($content);
				//$footer = $this->load->view($this->view_dir.'attendance_footer', $this->data, true);	
				
				unset($header1);
				unset($header);
				unset($content);
				unset($footer);
				unset($studlist);

				ob_clean();

			}	
			}		
			$pdfFilePath1 ="AS-".$streamname[0]['stream_short_name']."-".$_POST['semester']."-".$_POST['exam_session'].
			".pdf";			
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
		}else{
			echo "Something is wrong!!";
		} 
	} 	
	/**************************** Practical Faculty END ********************************************************/

	public function pract_marks_entry()
    {
		//error_reporting(E_ALL);exit();
      $this->load->model('Phd_exam_timetable_model');
	   $empid = $this->session->userdata("role_id");
        $this->load->view('header',$this->data);        
        $examsession = $this->Phd_exam_timetable_model->fetch_curr_exam_session();
        $exam_id= $examsession[0]['exam_id'];	

		$this->data['exam'] =$examsession[0]['exam_month'].'-'.$examsession[0]['exam_year'].'-'.$examsession[0]['exam_id'];
		
	
		
	if($empid !="15"){	
	   $uid = $this->session->userdata("uid");
	   if($uid==95){
		$exam_year= $examsession[0]['exam_year'];  
		$this->data['sub_list']= $this->Phd_marks_model->list_facultywise_pract_exam_subjects($exam_id);
		//$this->data['sub_list']= $this->Phd_marks_model->list_facultywise_pract_exam_all_subjects();
		//echo "<pre>";
		//print_r($this->data['sub_list']);
		//exit;
	   }else{
		 
		$this->data['sub_list']= $this->Phd_marks_model->list_facultywise_pract_exam_subjects($exam_id);
	   }
		for($i=0;$i< count($this->data['sub_list']); $i++){
			$subjectId = $this->data['sub_list'][$i]['sub_id'];
			$stream = $this->data['sub_list'][$i]['stream_id'];
			$semester = $this->data['sub_list'][$i]['semester'];
			$is_backlog = $this->data['sub_list'][$i]['is_backlog'];
			$batch_no = $this->data['sub_list'][$i]['batch_no'];
			$division = $this->data['sub_list'][$i]['division'];
			//$this->data['sub_list'][$i]['mrk']= $this->Phd_marks_model->getPractMarksEntry($subjectId, $exam_id,$stream,$semester,$is_backlog);
			$this->data['sub_list'][$i]['mrk']= $this->Phd_marks_model->getPractMarksEntry1($subjectId, $exam_id,$stream, $semester,$is_backlog,$division, $batch_no);
		}
	}else{
		//echo "Inside";exit;
		$this->data['sub_list']= $this->Phd_marks_model->list_coewise_pract_exam_subjects();
		$this->data['batch_no'] = '1';
		$this->data['division'] = 'A';
		for($i=0;$i< count($this->data['sub_list']); $i++){
			$subjectId = $this->data['sub_list'][$i]['sub_id'];
			$stream = $this->data['sub_list'][$i]['stream_id'];
			$semester = $this->data['sub_list'][$i]['semester'];
			/*$is_backlog = $this->data['sub_list'][$i]['is_backlog'];
			$batch_no = $this->data['sub_list'][$i]['batch_no'];
			$division = $this->data['sub_list'][$i]['division'];
			//$this->data['sub_list'][$i]['mrk']= $this->Phd_marks_model->getPractMarksEntry($subjectId, $exam_id,$stream, $semester,$is_backlog);*/
			$this->data['sub_list'][$i]['mrk']= $this->Phd_marks_model->coe_getPractMarksEntry1($subjectId, $exam_id,$stream, $semester,$is_backlog,$division, $batch_no);
		}
	}
		$this->load->view($this->view_dir.'add_pract_marks',$this->data);
        $this->load->view('footer');    
    
    } 
	public function pract_marksdetails($testId)
    {
		//error_reporting(E_ALL);
		$testId = base64_decode($testId);
		$this->load->model('Phd_exam_timetable_model');
		$roleid = $this->session->userdata("role_id");
		//echo $subdetails =$this->uri->segment(5);
		$this->load->model('Attendance_model');
		$curr_session= $this->Attendance_model->getCurrentSession();
		//exit;
		$this->data['sub_details'] = $testId;
		$subdetails =explode('~',$testId);
		//print_r($subdetails);exit;
		$sub_id  =$subdetails[0];
		$this->data['stream'] =$subdetails[3];
		$this->data['semester'] =$subdetails[4];
		$this->data['examsession'] =$subdetails[5];
		$this->data['exam_type'] =$subdetails[6];
		$this->data['division'] =$subdetails[7];
		$this->data['batch_no'] =$subdetails[8];
		$this->data['is_backlog'] =$subdetails[10];
		$stream_id = $subdetails[3];
		//echo $subdetails[8];
		$ex =explode('-',$subdetails[5]);
		$exam = $this->Phd_exam_timetable_model->fetch_exam_session($ex[2]);
		//print_r($exam);exit;
		$this->data['exam'] =$exam[0]['exam_month'].'-'.$exam[0]['exam_year'].'-'.$exam[0]['exam_id'];

		if($subdetails[10]=='N'){
			if($roleid !='15'){
				
			$this->data['allbatchStudent'] = $this->Phd_marks_model->getSubAppStudentList($sub_id,$stream_id, $subdetails[4],$subdetails[7], $subdetails[8],$exam[0]['exam_id'],$curr_session[0]['academic_year']);
			}else{
				$this->data['allbatchStudent'] = $this->Phd_marks_model->coe_getSubAppStudentList($sub_id,$stream_id, $subdetails[4],$subdetails[7], $subdetails[8]);
			}
		}else{
			echo "inside";exit;
			$this->data['allbatchStudent'] = $this->Phd_marks_model->getbacklogSubjectStudts($sub_id,$stream_id, $subdetails[4]);
		}
		$this->data['ut'] = $this->Phd_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Phd_marks_model->getStreamShortName($subdetails[3]);
		//echo "<pre>";
		//print_r($this->data['ut']);exit;
        $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'add_markdetails',$this->data);
        $this->load->view('footer');
    }  
//
	public function downloadStudlistpdf($testId, $me_id)
    {
		$testId = base64_decode($testId);
		$this->load->model('Phd_exam_timetable_model');
		$this->load->model('Attendance_model');
		$curr_session= $this->Attendance_model->getCurrentSession();
		$roleid = $this->session->userdata("role_id");
		$this->data['sub_details'] = $testId;
		$subdetails =explode('~',$testId);
		//print_r($subdetails);
		$sub_id  =$subdetails[0];
		$this->data['stream'] =$subdetails[3];
		$this->data['semester'] =$subdetails[4];
		$this->data['examsession'] =$subdetails[5];
		$this->data['exam_type'] =$subdetails[6];
		$this->data['division'] =$subdetails[7];
		$this->data['batch_no'] =$subdetails[8];
		$this->data['is_backlog'] =$subdetails[10];
		$this->data['exam_date'] =$subdetails[11];
		$stream_id = $subdetails[3];
		$exam =explode('-',$subdetails[5]);
		
		//$exam = $this->Phd_exam_timetable_model->fetch_exam_session($subdetails[5]);
		$this->data['exam']  =$exam[0].'-'.$exam[1];
		//$this->data['exam'] =$exam[0]['exam_month'].'-'.$exam[0]['exam_year'].'-'.$exam[0]['exam_id'];

		if($subdetails[10]=='N'){
			if($roleid !='15'){
			$this->data['allbatchStudent'] = $this->Phd_marks_model->getSubAppStudentList($sub_id,$stream_id, $subdetails[4],$subdetails[7], $subdetails[8],$exam[2],$curr_session[0]['academic_year']);
			}else{
				$this->data['allbatchStudent'] = $this->Phd_marks_model->coe_getSubAppStudentList($sub_id,$stream_id, $subdetails[4],$subdetails[7], $subdetails[8]);
			}
			
		}else{
			$this->data['allbatchStudent'] = $this->Phd_marks_model->getbacklogSubjectStudts($sub_id,$stream_id, $subdetails[4]);
		}
		$exam_id = $examses[2];
		$this->data['streamId'] = $subdetails[3];
		$this->data['ut'] = $this->Phd_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Phd_marks_model->getStreamShortName($subdetails[3]);
	
		//echo "<pre>";		
		//print_r($this->data['mrks']);
		$this->load->library('m_pdf');
		$html = $this->load->view($this->view_dir.'pdf_practStuddetails',$this->data, true);
		$pdfFilePath1 =$this->data['ut'][0]['subject_code']."_mrks_attendance_list.pdf";
		$mpdf=new mPDF();
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '65', '45');
		$header = $this->load->view($this->view_dir.'exam_timetable_pdf_header', $this->data, true);
		$dattime = date('d-m-Y H:i:s');
		//$footer ='<table width="100%" border="0" cellspacing="5" cellpadding="5" align="center" style="margin-bottom:40px;"><tr><td width="30%"><b>Office Seal</b></td><td width="40%"><b>COE Sign</b></td><td width="30%" style="float:right"> Printed on: '.$dattime.'</td></tr></table>';
		$footer = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
		  <tr>
		    <td align="left" height="40" class="signature" colspan="5"><strong>Declaration:</strong> <i>I hereby declare that the above details are correct and verified to the best of my knowledge.<i></td>		
		  </tr>
		  </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
		  <tr>
		    <td align="left" height="40" class="signature" style="text-align:right"><strong>Internal Examiner:</strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
		    <td align="center" height="40" width="100" class="signature"><strong></strong></td>
		    <td align="right" height="40" class="signature" style="text-align:right"><strong>External Examiner:</strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
		   
		  </tr>
		  
		  <tr>
		    <td align="left" height="40" class="signature" style="text-align:left"><strong>Signature:</strong></td>
		    <td align="center" height="40" width="100" class="signature"><strong></strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
		    <td align="right" height="40" class="signature" style="text-align:left"><strong>Signature:</strong></td>
			<td align="center" height="40" class="signature"><strong></strong></td>
			<td align="center" height="40" class="signature"><strong></strong></td>
		   
		  </tr>
		  <tr>
		    <td align="right" colspan="3" class="signature"><small><i>Printed on: '.$dattime.'</i></small></td>
		  </tr>
		</table>';
		$content = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$footer1 = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->SetHTMLHeader($header);
		$this->m_pdf->pdf->SetHTMLFooter($footer1);
		$this->m_pdf->pdf->AddPage();
		$this->m_pdf->pdf->WriteHTML($content);	
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath1, "D");
        
    }	
	public function downldPractmarkspdf($testId, $me_id)
    {
		//error_reporting(E_ALL);
		$me_id = base64_decode($me_id);//exit;
		$testId = base64_decode($testId);
		$this->data['me_id']=$me_id;
		$this->data['sub_details'] = $testId;
		$subdetails =explode('~',$testId);
		$sub_id  =$subdetails[0];
		
		$semester =$subdetails[4];
		$this->data['examsession'] =$subdetails[5];
		
		$division =$subdetails[7];
		$batch_no =$subdetails[8];
		$is_backlog =$subdetails[10];
		$this->data['exam_date'] =$subdetails[11];
		$stream_id = $subdetails[3];
		
		$exam  =$subdetails[5];
		$examses =explode('-',$exam);
		$exam_id = $examses[2];
		$this->data['exam']  =$examses[0].'-'.$examses[1];
		$this->data['streamId'] = $subdetails[3];
		$this->data['ut'] = $this->Phd_marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Phd_marks_model->getStreamShortName($subdetails[3]);
		$this->data['me']=$this->Phd_marks_model->fetch_me_details($me_id);
		$roleid = $this->session->userdata("role_id");
		if($roleid !='15'){		
			$this->data['mrks']=$this->Phd_marks_model->get_pract_marks_details($me_id,$stream_id,$semester,$division,$batch_no, $exam_id);
		}else{
			$this->data['mrks']=$this->Phd_marks_model->get_pract_marks_details($sub_id,$stream_id,$semester,$division,$batch_no, $exam_id);
		}		
		//echo "<pre>";		
		//print_r($this->data['mrks']);
	
		$this->load->library('m_pdf');
		$html = $this->load->view($this->view_dir.'pdf_practmarkdetails',$this->data, true);
		$pdfFilePath1 =$this->data['ut'][0]['subject_code']."_".$division."_".$batch_no."_Marks.pdf";
		
		$mpdf=new mPDF();
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '65', '45');
		$header = $this->load->view($this->view_dir.'pract_marks_pdf_header', $this->data, true);
		$dattime = date('d-m-Y H:i:s');
		//$footer ='<table width="100%" border="0" cellspacing="5" cellpadding="5" align="center" style="margin-bottom:40px;"><tr><td width="30%"><b>Office Seal</b></td><td width="40%"><b>COE Sign</b></td><td width="30%" style="float:right"> Printed on: '.$dattime.'</td></tr></table>';
		$footer = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
		  <tr>
		    <td align="left" height="40" class="signature" colspan="5"><strong>Declaration:</strong> <i>I hereby declare that the above details are correct and verified to the best of my knowledge.<i></td>		
		  </tr>
		  </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
		  <tr>
		    <td align="left" height="40" class="signature" style="text-align:right"><strong>Internal Examiner:</strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
		    <td align="center" height="40" width="100" class="signature"><strong></strong></td>
		    <td align="right" height="40" class="signature" style="text-align:right"><strong>External Examiner:</strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
		   
		  </tr>
		  
		  <tr>
		    <td align="left" height="40" class="signature" style="text-align:left"><strong>Signature:</strong></td>
		    <td align="center" height="40" width="100" class="signature"><strong></strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
		    <td align="right" height="40" class="signature" style="text-align:left"><strong>Signature:</strong></td>
			<td align="center" height="40" class="signature"><strong></strong></td>
			<td align="center" height="40" class="signature"><strong></strong></td>
		   
		  </tr>
		  <tr>
		    <td align="right" colspan="3" class="signature"><small><i>Printed on: '.$dattime.'</i></small></td>
		  </tr>
		</table>';
		$content = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$footer1 = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->SetHTMLHeader($header);
		$this->m_pdf->pdf->SetHTMLFooter($footer1);
		$this->m_pdf->pdf->AddPage();
		$this->m_pdf->pdf->WriteHTML($content);	
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath1, "D");
        
    }
	////////////////////////////////////////////
	public function testpractical_exam_reports()
    {
		//error_reporting(E_ALL);
		$this->load->model('Examination_model');
		$report_type='';
		$exam_month ='DEC';
		$exam_year ='2018';
		$exam_id ='9';
		$this->data['exam_id'] =$exam_id;
		$this->data['exam_ses'] =$exam_month.'-'.$exam_year;
		

			//echo "inside";exit;
			//$this->data['sub_list']= $this->Phd_marks_model->list_practsubjects_pdf($_POST, $exam_id);
			$sub_list= $this->Phd_marks_model->test_list_practsubjects_pdf();
			//$bksub_list= $this->Phd_marks_model->test_list_backlogsubjects_pdf($_POST, $exam_id);
			
			$this->load->library('m_pdf');
			//$html = $this->load->view($this->view_dir.'pdf_practical_exam_attendance',$this->data, true);
			//$pdfFilePath1 ="practical_exam_reports.pdf";
			//$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			$mpdf=new mPDF();
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '30', '10', '10', '60', '35');
			$content='<style>  
			table {  
			font-family: arial, sans-serif;  
			border-collapse: collapse;  
			width: 100%; font-size:12px; margin:0 auto;
			}  
			td{vertical-align: top;}
                      
			.signature{
			text-align: center;
			}
			p{padding:0px;margin:0px;}
			h1, h3{margin:0;padding:0}
			
			.content-table tr td{border:1px solid #333;vertical-align:middle;}
			.content-table th{border:1px solid #333;margin:40px}
			</style> ';
			$k=1;$x=0;$y=0;
			if(!empty($sub_list)){
			foreach($sub_list as $sub){
	   
			   $streamname= $this->Phd_examination_model->getStreamShortName($sub['stream_id']);
			   $extime ="";

				$header ='<br><table cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
				<td width="100" align="center" style="text-align:center;padding-top:5px;"><img src="'.base_url().'assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
				<td style="font-weight:normal;text-align:center;">
				<h1 style="font-size:40px;" style="text-align:center;margin:0;padding:0">Sandip University</h1>
				<p style="margin:0;padding:0">Mahiravani, Trimbak Road, Nashik – 422 213</p>
<h3 style="font-size:14px;margin:0;padding:0px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>
		<u style="font-size:13px;">PRACTICAL EXAMINATION ATTENDANCE SHEET - '.$exam_month.'-'.$exam_year.'</u></h3>
				</td>
				<td width="120" align="right" valign="middle" style="text-align:right;">
				<span style="font-size: 20px;"><b>COE</b></span></td>
</tr>
				
				</table><hr>
				<table class="content-table" width="100%" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
				<tr>
				<td width="100" >&nbsp;<strong>Subject Code:</strong></td>
				<td >&nbsp;'.$sub['subject_code'].' - '.$sub['subject_name'].'</td>
				<td width="80" height="30">&nbsp;<strong>Batch:</strong> </td>
				<td >&nbsp;1</td>

							
				</tr>
						   
				<tr>
				<td valign="middle">&nbsp;<strong>Date:</strong></td>
				<td valign="middle">&nbsp; '.$extime.'</td>
				<td valign="middle">&nbsp;<strong>Division:</strong></td>
				<td valign="middle">&nbsp; A</td>
				</tr>
				<tr>
				<td width="100" height="30" valign="middle">&nbsp;<strong>Stream:</strong></td>
				<td  valign="middle">&nbsp;'.$streamname[0]['stream_name'].'</td>
				<td width="80" height="30" valign="middle">&nbsp;<strong>Semester</strong> </td>
				<td height="30" valign="middle">&nbsp;'.$sub['semester'].'</td>
						   
				</tr>
				</table>';
				$studstrength =$this->Phd_marks_model->testfetch_student_strength($sub['sub_id'],$sub['stream_id'],$sub['semester']);
				
				$content .='<table border="0" cellspacing="5" cellpadding="5" width="100%" class="content-table" style="position: relative;">
				<tr>
				<th width="50" height="30">Sr No.</th>
				<th>PRN</th>
				<th align="left">Name</th>
				<th>Ans.Booklet No</th>
				<th>Candidate.Sign</th>
				</tr>';
			
				$j=1;
				if(!empty($studstrength)){
					foreach($studstrength as $stud){
						//echo $stud['enrollment_no'];
			
						$content .='<tr>
						<td height="30" align="center">'.$j.'</td>
						<td>'.$stud['enrollment_no'].'</td>
						<td>'.$stud['first_name'].' '.$stud['middle_name'].' '.$stud['last_name'].'</td>
						<td></td>
						<td></td>
						</tr>';
			
						$j++;
					}
				}
				$content .='</table>';	
			
				$footer .='<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:40px;">
				<tr>
				<td align="center">
				<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  
  
				<tr>
				<td align="left" class="signature" valign="bottom"><strong>Present :</strong></td>
    
				<td align="center"  class="signature" valign="bottom"><strong>Absent :</strong></td>
   
				<td align="center" class="signature" valign="bottom"><strong>Total :</strong></td>
				<td align="center" class="signature" style="text-align:right"><strong>Internal Examiner</strong></td>
				<td align="right" class="signature" style="text-align:right"><strong>External Examiner</strong></td>
				

		   

   
				</tr>
				</table>

				</td>
				</tr>
				</table><div align="center"><small><b>{PAGENO}</b></small></div>';	

				//$this->m_pdf->pdf->AddPage(); 			 
				//ob_clean();
				$this->m_pdf->pdf->PageNumSubstitutions[] = [
					'from' => 1, 
					'reset' => 0, 
					'type' => 'I', 
					'suppress' => 'off'
				];
				$this->m_pdf->pdf->defaultfooterline = false;
				$header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLHeader($header1);		
				$this->m_pdf->pdf->SetHTMLFooter($footer);
				//$this->m_pdf->pdf->setFooter('{PAGENO}');
				$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->AddPage();
			
				$this->m_pdf->pdf->WriteHTML($content);
				//$footer = $this->load->view($this->view_dir.'attendance_footer', $this->data, true);	
				
				unset($header1);
				unset($header);
				unset($content);
				unset($footer);
				unset($studlist);

				ob_clean();			
			}
			}
				
			$pdfFilePath1 ="AS-".$streamname[0]['stream_short_name']."-".$_POST['semester']."-".$_POST['exam_session'].
			".pdf";			
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
	}
//////////////////////////////////////////////////////////////////////////////
    public function pract_marks_entry_status($streamId='', $semester='', $course_id, $school_id, $batch, $acd_year)
    {
		//error_reporting(E_ALL);
      $this->load->model('Phd_exam_timetable_model');
	  $this->load->model('Subject_model');
	  $this->load->model('Timetable_model');
      if($_POST)
      {
        $this->load->view('header',$this->data);        
		$this->data['school_code'] =$_POST['school_code'];
		$this->data['admissioncourse'] =$_POST['admission-course'];
		$this->data['stream'] =$_POST['admission-branch'];
		$this->data['semester'] =$_POST['semester'];
		$this->data['exam'] =$_POST['exam_session'];
		$this->data['marks_type'] =$_POST['marks_type'];
		$this->data['exam_date'] =$_POST['exam_date'];
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_curr_exam_session();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$this->data['exam_id'] =$exam_id;
		$this->data['sub_list']= $this->Phd_marks_model->fetch_pract_marks_entry_status($_POST, $exam_id);
		$this->load->view($this->view_dir.'pract_marks_entry_status',$this->data);
		
        $this->load->view('footer');    
      }
      else
      {
      
       $this->load->view('header',$this->data);        
		$this->data['school_code'] =$school_id;
		$this->data['admissioncourse'] = $course_id;
		$this->data['stream'] = $streamId;
		$this->data['semester'] =  $semester;
		$this->data['batch'] =  $batch;
		$this->data['academicyear'] =$acd_year;
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_curr_exam_session();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
        $this->load->view($this->view_dir.'pract_marks_entry_status',$this->data);
        $this->load->view('footer');
      
      }   
    }
	function load_prmrentrycourses(){
		//echo $_POST["course_id"];exit;
		if($_POST["school_code"] !=0 && !empty($_POST["school_code"])){
			$stream = $this->Phd_marks_model->load_prmrentrycourses($_POST["school_code"], $_POST["batch"]);
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Course</option>';
				echo '<option value="0">ALL</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">Course not available</option>';
			
			}
		}else{
			echo '<option value="0">ALL</option>';
		}
	}
    // load practical mrks streams
	function load_prmrentrystreams() {
        if ($_POST["course_id"] !=0 && !empty($_POST["course_id"])) {
            $stream = $this->Phd_marks_model->load_prmrentrystreams($_POST);
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Stream</option>';
				echo '<option value="0">ALL</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['stream_id'] . '">' . $value['stream_name'] . '</option>';
                }
            } else {
                echo '<option value="">stream not available</option>';
            }
        }else{
			echo '<option value="0">ALL</option>';
		}
    }
	function load_prmrentrysemester() {
        if (!empty($_POST['stream_id']) && $_POST['stream_id'] !=0) {
            //Get all city data
            $stream = $this->Phd_marks_model->load_prmrentrysemester($_POST);
            
            //Count total number of rows
            $rowCount = count($stream);
				
            //Display cities list
            if ($rowCount > 0) {
				
                echo '<option value="">Select Semester</option>';
				echo '<option value="0">ALL</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
                }
            } else {
                echo '<option value="">semester not available</option>';
            }
        }else{
			echo '<option value="0">ALL</option>';
		}
    } 
    //cia marks of failed students
    function cia_for_supplimentry_exam(){
    	exit;
    	$liststud = $this->Phd_marks_model->get_failed_studentlist();
		//print_r($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Phd_marks_model->get_failedstudciamarks($stud);
			$i++;
    	}
    	echo  $i."records Successfully Updated";
    }
	//cia marks of failed students
    function update_marks_masterforcia_supplimentry(){
    	exit;
    	$liststud = $this->Phd_marks_model->get_examappliedsubjects();
		//print_r($liststud);
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Phd_marks_model->update_marks_master_cia($stud);
			$i++;
    	}
    	echo  $i."records Successfully Updated";
    }
	
	//Practical marks of failed students
    function update_marks_masterforpractical_supplimentry(){
    	exit;
    	$liststud = $this->Phd_marks_model->get_examappliedPrsubjects();
		//print_r($liststud);
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Phd_marks_model->update_marks_master_practical($stud);
			$i++;
    	}
    	echo  $i."records Successfully Updated";
    }	
	//Practical marks of failed students
    function update_marks_enryforpractical(){
    	
    	$liststud = $this->Phd_marks_model->get_examresultPrsubjects();
		//print_r($liststud);
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Phd_marks_model->update_marks_master_practical($stud);
			$i++;
    	}
    	echo  $i."records Successfully Updated";
    }	
	////////////////////////////////////////////////////////////////////////////////////
    function update_stream_marks_entry(){
    	
    	$liststud = $this->Phd_marks_model->get_mrkstudent_list();
		//print_r($liststud);
    	foreach($liststud as $stud){
    		$stud = $this->Phd_marks_model->update_mrkstream($stud);
    	}
    	echo  "Successfully Updated";
    }
/*
*script for updation backlog students stream dated 
*13-02-2019 by bala	
*/
	function update_bklog_stream(){
    	
    	$liststud = $this->Phd_marks_model->get_bklog_streamstud_list();
		//print_r($liststud);
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Phd_marks_model->update_bklog_streamstud($stud);
			$i++;
    	}
    	echo  $i."_exam applied records updated Successfully";
    }
	// theory marks
	function update_bklog_stream_marksentry(){
    	
    	$liststud = $this->Phd_marks_model->get_bklog_streamstud_list_marksentry();
		//print_r($liststud);
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Phd_marks_model->update_bklog_streamstud_marksentry($stud);
			$i++;
    	}
    	echo  $i."_Theory records updated Successfully";
    }
		function update_bklog_stream_cia_marks(){
    	
    	$liststud = $this->Phd_marks_model->get_bklog_streamstud_list_cia_marks();
		//print_r($liststud);
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Phd_marks_model->update_bklog_streamstud_cia_marks($stud);
			$i++;
    	}
    	echo  $i."_CIA records updated Successfully";
    }
/*
*update stream for backlog students end here.
*/	
/*script for updation of timetable of D.pharma 
*15-02-2019 by bala	
*/
	function insertttdprm(){
    	
    	$liststud = $this->Phd_marks_model->get_insertttdprm_list();
		//print_r($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Phd_marks_model->update_insertttdprm($stud);
			$i++;
    	}
    	echo  $i."_inserted Successfully";
    }
	/*
	*end
	*/	
/*script for updation of timetable of D.pharma 
*15-02-2019 by bala	
*/
	function update_attendancegrade(){
    	$exam_id='12';
    	$liststud = $this->Phd_marks_model->get_attendancegrade($exam_id);
		//print_r($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Phd_marks_model->update_attendancegrade($stud,$exam_id);
			$i++;
    	}
    	echo  $i."_updated Successfully";
    }
	/*
	*end
	*/
		function script_for_topper(){
    	
    	$list_streams = array('5','6','8','10','107','13','15','16','19','20','21','98','121','23','24','26','29','22','113','31','32','33','34','120','35','36','124','7','11','96','97','109','12','17','38','39','40','42','37','43','44','45','46','47','117','48','49','50','51','105','106','118','66','67','68','69','71','116','119');
		//print_r($liststud);
		$i=1;
		
		$this->load->library('m_pdf');
			//$html = $this->load->view($this->view_dir.'pdf_practical_exam_attendance',$this->data, true);
			//$pdfFilePath1 ="practical_exam_reports.pdf";
			//$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			$mpdf=new mPDF();
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '10', '10', '45', '15');
			$content='<style>  
			table {  
			font-family: arial, sans-serif;  
			border-collapse: collapse;  
			width: 100%; font-size:12px; margin:0 auto;
			}  
			td{vertical-align: top;}
                      
			.signature{
			text-align: center;
			}
			p{padding:0px;margin:0px;}
			h1, h3{margin:0;padding:0}
			
			.content-table tr td{border:1px solid #333;vertical-align:middle;}
			.content-table th{border:1px solid #333;margin:40px}
			</style> ';		
    		

			
			 
			   $extime ="";
foreach($list_streams as $strm){
			$division = $this->Phd_marks_model->fetch_stream_division_list($strm);
			foreach($division as $vr){
				//print_r($vr);exit;
				$stud_data = $this->Phd_marks_model->fetch_streamwisetopper_list($vr);
				$header ='<br><table cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
				<td width="100" align="center" style="text-align:center;padding-top:5px;"><img src="'.base_url().'assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
				<td style="font-weight:normal;text-align:center;">
				<h1 style="font-size:40px;" style="text-align:center;margin:0;padding:0">Sandip University</h1>
				<p style="margin:0;padding:0">Mahiravani, Trimbak Road, Nashik – 422 213</p>
<h3 style="font-size:14px;margin:0;padding:0px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>
		<u style="font-size:13px;">TOPPER LIST</u></h3>
				</td>
				<td width="120" align="right" valign="middle" style="text-align:right;">
				<span style="font-size: 20px;"><b>COE</b></span></td>
</tr>
				
				</table><hr>';
				$j=1;
				
				
				//echo "<pre>";print_r($stud_data);exit;
				if(!empty($stud_data)){
				$content .='<table border="0" cellspacing="5" cellpadding="5" width="100%" class="content-table" style="position: relative;">
				<tr>
				<th width="50" height="30">Sr No.</th>
				
				<th>PRN</th>
				<th align="left">Name</th>
				<th>School name</th>
				<th>Stream name</th>
				<th>Semester</th>
				<th>Division</th>
				<th>CGPA</th>
				</tr>';
				foreach($stud_data as $std){ 
						//echo $stud['enrollment_no'];
			
						$content .='<tr>
						<td height="30" align="center">'.$j.'</td>
						<td>'.$std['enrollment_no'].'</td>
						<td>'.$std['first_name'].' '.$std['middle_name'].' '.$std['last_name'].'</td>
						<td>'.$std['school_short_name'].'</td>
						<td>'.$std['stream_name'].'</td>
						<td>'.$std['semester'].'</td>
						<td>'.$std['division'].'</td>
						<td>'.$std['cumulative_gpa'].'</td>
						
						</tr>';
			
						$j++;
					}
				
				$content .='</table>';	
				
				$footer="";	

				//$this->m_pdf->pdf->AddPage(); 			 
				//ob_clean();
				$this->m_pdf->pdf->PageNumSubstitutions[] = [
					'from' => 1, 
					'reset' => 0, 
					'type' => 'I', 
					'suppress' => 'off'
				];
				$this->m_pdf->pdf->defaultfooterline = false;
				$header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLHeader($header1);		
				$this->m_pdf->pdf->SetHTMLFooter($footer);
				//$this->m_pdf->pdf->setFooter('{PAGENO}');
				$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->AddPage();
			
				$this->m_pdf->pdf->WriteHTML($content);
				//$footer = $this->load->view($this->view_dir.'attendance_footer', $this->data, true);	
				
				unset($header1);
				unset($header);
				unset($content);
				unset($footer);
				unset($stud_data);

				ob_clean();			
			}
			}
}
			//exit;		
			$pdfFilePath1 ="TOPPER LIST.pdf";			
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
		
    	
    	//echo  $i."_inserted Successfully";
    }
function script_for_pass_studts(){
    	//error_reporting(E_ALL);
    	$list_streams = $this->Phd_marks_model->fetch_studexam_list(11);
		ini_set('memory_limit', '2048M');
		//print_r($liststud);
		$i=1;
		
		$this->load->library('m_pdf');
			//$html = $this->load->view($this->view_dir.'pdf_practical_exam_attendance',$this->data, true);
			//$pdfFilePath1 ="practical_exam_reports.pdf";
			//$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			$mpdf=new mPDF();
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '10', '10', '45', '15');
			$content='<style>  
			table {  
			font-family: arial, sans-serif;  
			border-collapse: collapse;  
			width: 100%; font-size:12px; margin:0 auto;
			}  
			td{vertical-align: top;}
                      
			.signature{
			text-align: center;
			}
			p{padding:0px;margin:0px;}
			h1, h3{margin:0;padding:0}
			
			.content-table tr td{border:1px solid #333;vertical-align:middle;}
			.content-table th{border:1px solid #333;margin:40px}
			</style> ';		
    		

			
			 
			   $extime ="";

				$header ='<br><table cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
				<td width="100" align="center" style="text-align:center;padding-top:5px;"><img src="'.base_url().'assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
				<td style="font-weight:normal;text-align:center;">
				<h1 style="font-size:40px;" style="text-align:center;margin:0;padding:0">Sandip University</h1>
				<p style="margin:0;padding:0">Mahiravani, Trimbak Road, Nashik – 422 213</p>
<h3 style="font-size:14px;margin:0;padding:0px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>
		<u style="font-size:13px;">PASS STUDENT LIST- APR/MAY-2019</u></h3>
				</td>
				<td width="120" align="right" valign="middle" style="text-align:right;">
				<span style="font-size: 20px;"><b>COE</b></span></td>
</tr>
				
				</table><hr>';
				$content .='<table border="0" cellspacing="5" cellpadding="5" width="100%" class="content-table" style="position: relative;">
				<tr>
				<th width="50" height="30">Sr No.</th>
				
				<th>PRN</th>
				<th align="left">Name</th>
				<th>Stream name</th>
				<th>Semester</th>
				<th>RESULT</th>
				</tr>';
				$j=1;
				foreach($list_streams as $strm){
					$stud_data = $this->Phd_marks_model->fetch_streamwisepass_list($strm);
					//$k=0;
					foreach($stud_data as $std){ 
						$grade_arr[] = $std['final_grade'];
						//$k++;
					}
					//echo $strm['stream_id'];exit;
					if($strm['stream_id']=='116' || $strm['stream_id']=='119'){
						$gd = 'F';
					}else{
						$gd = 'U';
					}
					//echo $gd;exit;
				//echo "<pre>";print_r($grade_arr);exit;
				if(!empty($stud_data)){

					if(!in_array($gd, $grade_arr)){
						$content .='<tr>
						<td height="30" align="center">'.$j.'</td>
						<td>'.$strm['enrollment_no'].'</td>
						<td>'.$strm['first_name'].' '.$strm['middle_name'].' '.$strm['last_name'].'</td>
						<td>'.$strm['stream_name'].'</td>
						<td>'.$strm['semester'].'</td>
						<td>PASS</td>
						
						</tr>';
						$j++;
					}
						
					
				}
				unset($grade_arr);
				}
				$content .='</table>';	
				
				$footer="";	

				//$this->m_pdf->pdf->AddPage(); 			 
				//ob_clean();
				$this->m_pdf->pdf->PageNumSubstitutions[] = [
					'from' => 1, 
					'reset' => 0, 
					'type' => 'I', 
					'suppress' => 'off'
				];
				$this->m_pdf->pdf->defaultfooterline = false;
				$header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLHeader($header1);		
				$this->m_pdf->pdf->SetHTMLFooter($footer);
				//$this->m_pdf->pdf->setFooter('{PAGENO}');
				$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
				//$this->m_pdf->pdf->AddPage();
			
				$this->m_pdf->pdf->WriteHTML($content);
				//$footer = $this->load->view($this->view_dir.'attendance_footer', $this->data, true);	
				
				unset($header1);
				unset($header);
				unset($content);
				unset($footer);
				unset($stud_data);

				ob_clean();			
			
			
			//exit;		
			$pdfFilePath1 ="TOPPER LIST.pdf";			
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
		
    	
    	//echo  $i."_inserted Successfully";
    }	
	
	
	// for updating faculty code
		function updatevisitingfaculty(){
    	
    	$liststud = $this->Phd_marks_model->get_visfaculty_list();
		//print_r($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Phd_marks_model->update_visitingfaculty($stud);
			$i++;
    	}
    	echo  $i."_updated Successfully";
    }
	
/*************************** script for mapping backlog Cia marks Start*************************************/
//for regular exam
    function updateBklogCiamarks(){
    	$exam_id='3';
		$exam_month='APRIL';
		$exam_year='2022';
    	$liststud = $this->Phd_marks_model->get_backlog_studentsubjects($exam_id);
		//echo count($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Phd_marks_model->updateBklogCiamarks($stud,$exam_id,$exam_month,$exam_year);
			$i++;
    	}
    	echo  $i."records Successfully Updated";
    }
	function updateBklogCiaMaster(){
    	$exam_id='3';
		$exam_month='APRIL';
		$exam_year='2022';
    	$liststud = $this->Phd_marks_model->get_backlog_masterCiasubjects($exam_id);
		//echo count($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Phd_marks_model->updateBklogCiaMaster($stud,$exam_id,$exam_month,$exam_year);
			$i++;
    	}
    	echo  $i."records Successfully Updated";
    }
/*************************** script for mapping backlog Cia marks END*************************************/

/*************************** script for mapping backlog EMPR marks Start*************************************/
    function updateBklogEMPRmarks(){
    	$exam_id='13';
		$exam_month='DEC';
		$exam_year='2019';
    	$liststud = $this->Phd_marks_model->get_backlog_EMPR_studentsubjects($exam_id);
		//echo count($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Phd_marks_model->updateBklog_EMPR_marks($stud,$exam_id,$exam_month,$exam_year);
			$i++;
    	}
    	echo  $i."records Successfully Updated";
    }
	function updateBklogEMPRMaster(){
    	$exam_id='13';
		$exam_month='DEC';
		$exam_year='2019';
    	$liststud = $this->Phd_marks_model->get_backlog_masterEMPRsubjects($exam_id);
		//echo count($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Phd_marks_model->updateBklogEMPRMaster($stud,$exam_id,$exam_month,$exam_year);
			$i++;
    	}
    	echo  $i."records Successfully Updated";
    }
/*************************** script for mapping backlog EMPR marks END*************************************/
}
?>