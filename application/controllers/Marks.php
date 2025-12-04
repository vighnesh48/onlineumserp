<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marks extends CI_Controller
{
	
    var $currentModule = "";   
    var $title = "";   
    var $table_name = "unittest_master";    
    var $model_name = "Unittest_model";   
    var $model;  
    var $view_dir = 'Marks/';
 
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
		$this->load->library('excel');

        $model = $this->load->model($this->model_name);
        $menu_name = $this->uri->segment(1);
        
        $this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
        $this->load->model('Marks_model');
		
		if(($this->session->userdata("role_id")==15) ||($this->session->userdata("role_id")==14) ||($this->session->userdata("role_id")==6) ||
		   ($this->session->userdata("role_id")==26) ||($this->session->userdata("role_id")==36) || $this->session->userdata("role_id")==20 ||  
			$this->session->userdata("role_id")==10 || $this->session->userdata("role_id")==63 || $this->session->userdata("role_id")==64 ||
			$this->session->userdata("role_id")==21 || $this->session->userdata("role_id")==44  || $this->session->userdata("role_id")==13 || $this->session->userdata("role_id")==68){
			
		}else{
			redirect('home');
			}
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
	
    public function add_cap_marks()
    {
		// redirect('home');
		//error_reporting(E_ALL);exit();
		if($this->session->userdata("role_id")==15){
		}else{
			redirect('home');
		}
      $this->load->model('Exam_timetable_model');
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
		$this->data['exam_session']= $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
		$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Exam_timetable_model->getSchools();
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		if($_POST['marks_type']=='TH'){
		$this->data['sub_list']= $this->Marks_model->list_exam_subjects($_POST, $exam_id);
				for($i=0;$i< count($this->data['sub_list']); $i++){
					$subjectId = $this->data['sub_list'][$i]['sub_id'];
					$this->data['sub_list'][$i]['mrk']= $this->Marks_model->getMarksEntry($subjectId, $exam_id, $_POST['marks_type'],$_POST['admission-branch'], $_POST['semester'],$_POST['reval']);
				}
		}else{
			$this->data['sub_list']= $this->Marks_model->list_exam_pr_subjects($_POST, $exam_id);
			for($i=0;$i< count($this->data['sub_list']); $i++){
				$subjectId = $this->data['sub_list'][$i]['sub_id'];
				$this->data['sub_list'][$i]['mrk']= $this->Marks_model->getPr_MarksEntry($subjectId, $exam_id, $_POST['marks_type'],$_POST['admission-branch'], $_POST['semester'],$_POST['reval']);
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
	
		$this->data['exam_session']= $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
		$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Exam_timetable_model->getSchools();
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
		$this->load->model('Examination_model');
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
		$this->data['allbatchStudent'] = $this->Examination_model->getSubjectStudentList($sub_id,$stream_id, $exam[0], $exam[1], $exam[2]);
		$this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);
		//echo "<pre>";
		//print_r($this->data['ut']);exit;
        $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'add_markdetails',$this->data);
        $this->load->view('footer');
    }
	public function submitMarkDetails()
    {       
		ini_set("memory_limit", "-1");
		set_time_limit(0);
        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$stud_id = $_POST['stud_id'];
		$marks_obtained = $_POST['marks_obtained'];
		$enrollement_no = $_POST['enrollement_no'];
		$adm_stream_id = $_POST['adm_stream'];
		$markentrydate =$this->input->post('markentrydate');
		$max_marks =$this->input->post('max_marks');
		if($markentrydate !=''){
			$markentrydate = str_replace('/', '-', $markentrydate);
            $markentrydate1 = date('Y-m-d', strtotime($markentrydate));
			}else{
			 $markentrydate1 = '0000-00-00';	
			}
		$stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,158,159,162,266);
		$stream_arr1 = array(43,44,45,46,47);
		
		$subdetails =explode('~',$_POST['sub_details']);
		/* echo '<pre>';
		print_r($subdetails);exit; */
		
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
			/* if(empty($subdetails[8])  && $subdetails[8] !=0){
			 $batch_no =1;	
			}else{ */
			  $batch_no =$subdetails[8];
			//}
			
			if(empty($subdetails[7])){
			 $division ='A';	
			}else{
			 $division =$subdetails[7];
			}
			
			
		}else{
			$division ='';
			$batch_no ='';
		}
	/*	if($subdetails[12] == 4 || $subdetails[12] ==5 || $subdetails[12] ==43){
		   $batch_no =0;
		}*/
		//exit;
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
				
		//	echo "<pre>";
		// print_r($insert_master_array);exit;
		if($marks_type=='TH'){
			$chkstud = $this->Marks_model->check_marks_enteredmaster_th($subject_id,$exam[2],$stream);
		}else{
			$chkstud = $this->Marks_model->check_marks_enteredmaster_pr($subject_id,$marks_type,$exam[2],$batch_no,$division);
		}
		if($this->session->userdata("uid")==4389){
			//print_r($chkstud);
			//print_r($insert_master_array);
			//exit;
		}
		//$chkstud =array();
		if(empty($chkstud)){
					
				$DB1->insert("marks_entry_master", $insert_master_array); 
				$last_inserted_id_master =$DB1->insert_id();
				// echo $DB1->last_query();
				// echo "<pre>";
				// print_r($insert_master_array);exit;
				for($i=0;$i<count($stud_id);$i++){
					$insert_array=array(
						"me_id"=>$last_inserted_id_master,
						"stud_id"=>$stud_id[$i],
						"enrollment_no"=>$enrollement_no[$i],
						"marks"=>$marks_obtained[$i],
						"stream_id"=>$adm_stream_id[$i],
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
					
					$DB1->insert("marks_entry", $insert_array); 
					//echo $DB1->last_query();exit;
					//echo "<pre>";
				//print_r($insert_array);exit;
					$last_inserted_id=$DB1->insert_id();               
					
				}
				if($last_inserted_id)
					{
						
						if($marks_type=='PR'){
							$this->session->set_flashdata('prdupentry', 'Marks entry successfuly done.');
							redirect(base_url('Marks/pract_marks_entry'));
						}else{
							redirect(base_url('Marks/add_cap_marks'));
						}
					}
	}else{
		
			if($marks_type=='PR'){
				$this->session->set_flashdata('prdupentry', 'Marks entry already done.');
				redirect(base_url('Marks/pract_marks_entry/prdupentry'));
			}else{
				redirect(base_url('Marks/add_cap_marks'));
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
		if($subdetails[6]=='PR'){
			$this->data['reval'] =$subdetails[9];//exit;
		}else{
			$this->data['reval'] =$subdetails[7];//exit;
		}
		$this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);
		$this->data['me']=$this->Marks_model->fetch_me_details($me_id);
		if($subdetails[7] !='reval'){
			
			$this->data['mrks']=$this->Marks_model->get_marks_details($me_id, $exam_id,$subdetails); 			
		}else{
			//echo 1;exit;
			$this->data['mrks']=$this->Marks_model->getSubjectStudentList_reval($sub_id,$stream_id, $exam_id);	
		}		
			
        $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'edit_markdetails',$this->data);
        $this->load->view('footer');
    }
	//update marks
	public function updateStudMarks_03032025()
    {       
        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$m_id = $_POST['m_id'];//exit;
		$subdetls = $_POST['sub_details'];
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
			$speakerupdate = $this->Marks_model->updateMarkDetails($spk_details, $m_id,$subdetls); //edit marks detail
		}else{
			$speakerupdate = $this->Marks_model->updateMarkDetails_reval($spk_details, $m_id); //edit reval marks detail
		}
		
		//redirect(base_url('Marks/editMarksDetails/'.$testId.'/'.base64_encode($m_id)));
		
		//echo $DB1->last_query();exit;
	} 
	
	//
	public function updateStudMarks()
{       
    $this->load->helper('security');
    $DB1 = $this->load->database('umsdb', TRUE);

    // Fetch and sanitize input
    $m_id = $this->input->post('m_id', TRUE);
    $subdetls = $this->input->post('sub_details', TRUE);
    $testId = base64_encode($subdetls);
    $reval = $this->input->post('reval', TRUE);

    // Fetch student details safely
    $spk_details = [
        'stud_id' => $this->input->post('stud_id', TRUE) ?? [],
        'enrollement_no' => $this->input->post('enrollement_no', TRUE) ?? [],
        'mrk_id' => $this->input->post('mrk_id', TRUE) ?? [],
        'marks_obtained' => $this->input->post('marks_obtained', TRUE) ?? [],
        'subject_id' => $this->input->post('subject_id', TRUE) ?? [],
        'exam_id' => $this->input->post('exam_id', TRUE) ?? []
		
    ];
	// print_r($spk_details);exit;
    // Validate inputs before proceeding
    if (!empty($spk_details['stud_id']) && !empty($m_id)) {
        if ($reval != 'reval') {
            $updateStatus = $this->Marks_model->updateMarkDetails($spk_details, $m_id, $subdetls);
        } else {
		
            $updateStatus = $this->Marks_model->updateMarkDetails_reval($spk_details, $m_id);
        }

        if ($updateStatus) {
            $this->session->set_flashdata('success', 'Marks updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update marks.');
        } //  exit;
    } else {
        $this->session->set_flashdata('error', 'Invalid or missing data.');
    }

    redirect(base_url('Marks/editMarksDetails/' . $testId . '/' . base64_encode($m_id)));
}

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
		$this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);
		$this->data['me']=$this->Marks_model->fetch_me_details($me_id);	
				echo "<pre>";		
		// print_r($subdetails);exit;
		if($subdetails[6] !='PR'){
			$this->data['mrks']=$this->Marks_model->download_marks_details($me_id, $exam_id,$subdetails);
		}else{
			$this->data['mrks']=$this->Marks_model->download_pr_marks_details($me_id, $exam_id,$subdetails);			
		}		

		$this->load->library('m_pdf');
		$html = $this->load->view($this->view_dir.'pdf_markdetails',$this->data, true);
		//echo $html;Exit;
		$this->data['sts']="Y";
		$header = $this->load->view($this->view_dir.'cia_pdf_header',$this->data, true);
		$pdfFilePath1 =$this->data['ut'][0]['subject_code']."_Marks.pdf";
		//$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		
		$mpdf=new mPDF();
		$this->m_pdf->pdf=new mPDF('L','A4','','5','15',15,60,37,5,5);
         $footer ='
    <table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:12px;">
	<tr>
    <td align="left" colspan="3" class="signature"><i><b>Declaration:</b>  I hereby declare that the above details are correct and verified to the best of my knowledge.
 </i></td>
  </tr>
  <tr>
    <td align="left" height="50" class="signature"><strong>Entry By:______________________</strong></td>
                <td align="center" height="50" class="signature"><strong>Veryfied By:___________________</strong></td>
                <td align="right" height="50" class="signature"><strong>Approved By:_____________________</strong></td>
  </tr>
  <tr>
    <td align="left" height="50" class="signature"><strong>Entry Date:___________________</strong></td>
                <td align="center" height="50" class="signature"><strong>Veryfied Date:________________</strong></td>
                <td align="right" height="50" class="signature"><strong>Approved Date:____________________</strong></td> 
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
	public function downloadCIApdf($testId, $me_id)
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
		$this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);
		$this->data['me']=$this->Marks_model->fetch_me_details($me_id);	
		
		if($this->session->userdata("role_id")!=15){
			$this->data['mrks']=$this->Marks_model->get_cia_marks_details($me_id);	
		}else{
			$this->data['mrks']=$this->Marks_model->get_cia_marks_details($sub_id,$exam_id);	
		}
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

        if ($DB1->update('marks_entry_master', $update_array)) {
			//echo $DB1->last_query();exit;
            $this->session->set_flashdata('msg', 'Verified Successfully');
            redirect(base_url('Marks/editMarksDetails/'.base64_encode($testId).'/'.base64_encode($me_id)));
        } else {
            $this->session->set_flashdata('msg', 'Problem while Verifying');
            redirect(base_url('Marks/editMarksDetails/'.base64_encode($testId).'/'.base64_encode($m_id)));
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
		
        if ($DB1->update('marks_entry_master', $update_array)) {
			//echo $DB1->last_query();exit;
            $this->session->set_flashdata('msg', 'Verified Successfully');
            redirect(base_url('Marks/editMarksDetails/'.base64_encode($testId).'/'.base64_encode($me_id)));
        } else {
            $this->session->set_flashdata('msg', 'Problem while Verifying');
            redirect(base_url('Marks/editMarksDetails/'.base64_encode($testId).'/'.base64_encode($m_id)));
        }
	}
	/////////////////////////////////////////////////////
	// for CIA
	public function cia()
    {
		
		//error_reporting(E_ALL); ini_set('display_errors', 1);
      $this->load->model('Exam_timetable_model');
	  $this->load->view('header',$this->data); 
	  $roll_id = $this->session->userdata("role_id");	
	  $emp_id = $this->session->userdata("name");	  	  
	  if($roll_id==15){

			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['exam'] =$_POST['exam_session'];
			$this->data['marks_type'] =$_POST['marks_type'];
			$this->data['reval'] =$_POST['reval'];
			$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
			$this->data['schools']= $this->Exam_timetable_model->getSchools();
			$this->data['exam_session']= $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
			if($_POST){
				
				$exam_month =$this->data['exam_session'][0]['exam_month'];
				$exam_year =$this->data['exam_session'][0]['exam_year'];
				$exam_id =$this->data['exam_session'][0]['exam_id'];
				$this->data['Marks_submission_date']= $this->Marks_model->Marks_submission_date($exam_id);
				$this->data['exam'] =$exam_month.'-'.$exam_year.'-'.$exam_id;
				$this->data['sub_list']= $this->Marks_model->list_coewise_cia_exam_subjects($emp_id, $curr_session[0]['academic_session'],$exam_id, $curr_session[0]['academic_year'],$_POST);

				for($i=0;$i< count($this->data['sub_list']); $i++){
					$subjectId = $this->data['sub_list'][$i]['sub_id'];
					$stream = $this->data['sub_list'][$i]['stream_id'];
					$semester = $this->data['sub_list'][$i]['semester'];
					$this->data['sub_list'][$i]['mrk']= $this->Marks_model->getCIAMarksEntry($subjectId, $exam_id,'CIA',$stream, $semester);

				}
			}
			$this->load->view($this->view_dir.'add_cia_marks',$this->data);
			
		 /* }
		  else
		  {		         
			$this->data['school_code'] ='';
			$this->data['admissioncourse'] = '';
			$this->data['stream'] = '';
			$this->data['semester'] = '';
		
			$this->data['exam_session']= $this->Exam_timetable_model->fetch_curr_exam_session();
			$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
			$this->data['schools']= $this->Exam_timetable_model->getSchools();
			$this->load->view($this->view_dir.'add_cia_marks',$this->data);
		  }*/
	  }else{
		  if($this->session->userdata("role_id")==21 || $this->session->userdata("role_id")==20 || $this->session->userdata("role_id")==44 || $this->session->userdata("role_id")==13 || $this->session->userdata("role_id")==63){
		}else{
			redirect('home');
		}
		  // for faculty
		$this->load->model('Attendance_model');
		$curr_session= $this->Attendance_model->getCurrentSession_for_marks_entry();	
		$this->data['exam_session']= $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
		$exam_month=$this->data['exam_session'][0]['exam_month'];
		$exam_year=$this->data['exam_session'][0]['exam_year'];
		$exam_id=$this->data['exam_session'][0]['exam_id'];
		$this->data['Marks_submission_date']= $this->Marks_model->Marks_submission_date($exam_id);
		$this->data['subject']= $this->Marks_model->getFaqExam_applied_subjects($emp_id, $curr_session[0]['academic_session'],$exam_id, $curr_session[0]['academic_year']);
		for($j=0;$j<count($this->data['subject']);$j++){
			
			$subId = $this->data['subject'][$j]['subject_code'];
			$semester = $this->data['subject'][$j]['semester'];
			$stream_id = $this->data['subject'][$j]['stream_id'];
			$subject_component = $this->data['subject'][$j]['subject_component'];
			$this->data['subject'][$j]['batches']= $this->Attendance_model->getFaqSubjectBatches($emp_id, $subId, $subject_component);//function name changed for 2019 getFaqSubjectBatches
			
			$this->data['subject'][$j]['mrk']= $this->Marks_model->getCIAMarksEntry($subId, $exam_id,$marks_type='CIA', $stream_id, $semester);

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
		$this->load->model('Examination_model');
		$roll_id = $this->session->userdata("role_id");	
		$emp_id = $this->session->userdata("name");	
		$this->load->model('Attendance_model');
		$curr_session= $this->Attendance_model->getCurrentSession();
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
		if($roll_id==6 || $roll_id==15){
			$this->data['allbatchStudent'] = $this->Examination_model->getSubjectStudentList($sub_id,$stream_id, $exam[0], $exam[1], $exam[2]);
		}else{
			if($this->session->userdata("role_id")==21 || $this->session->userdata("role_id")==13 || $this->session->userdata("role_id")==44 || $this->session->userdata("role_id")==20 || $this->session->userdata("role_id")==63){
			}else{
				redirect('home');
			}
			$this->data['allbatchStudent'] = $this->Marks_model->get_studbatch_allot_list($batch_details,$th_batch,$sub_id,$stream_id, $subdetails[4],$exam[2],$curr_session[0]['academic_year']);
			$this->data['allexamStudent'] = $this->Examination_model->getSubjectStudentList($sub_id,$stream_id, $exam[0], $exam[1], $exam[2]);
		}
		$this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);
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
		$stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,158,159,162,266);
		//$stream_arr1 = array(43,44,45,46,47);
		
		$subdetails =explode('~',$_POST['sub_details']);
		$subject_id  =$subdetails[0];
		$streamId =$subdetails[3];
		$semester =$subdetails[4];
		$examsession =$subdetails[5];
		$marks_type =$subdetails[6];
		$exam =explode('-',$examsession);
		
		//checking marks submission dates
		$exam_id=$exam[2];
		$today = date('Y-m-d');
		$Marks_submission_date= $this->Marks_model->Marks_submission_date($exam_id);
		$start_date=date('Y-m-d', strtotime($Marks_submission_date[0]['date_start']));
		$end_date=date('Y-m-d', strtotime($Marks_submission_date[0]['date_end']));
		$action_date=date('d-m-Y', strtotime($Marks_submission_date[0]['date_end']));
		if($today >= $start_date && $today <= $end_date){
		}else{
			 echo '<small style="color:red">Submission end</small>';exit;
		}
		/////////end /////////
		
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
				$DB1->insert("marks_entry_master", $insert_master_array); 
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
			
			$DB1->insert("marks_entry_cia", $insert_array); 
			//echo $last_inserted_id=$DB1->insert_id();    exit;           
			
		}
		$path =base_url().'marks/cia';
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
		$this->load->model('Attendance_model');
		$curr_session= $this->Attendance_model->getCurrentSession();
		$exam = explode('-',$subdetails[5]);
		$exam_id  =$exam[2];
		$this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);
		$this->data['me']=$this->Marks_model->fetch_me_details($me_id);	
		$roll_id = $this->session->userdata("role_id");	  	  
	  if($roll_id==6 || $roll_id==15){
		  $this->data['mrks']=$this->Marks_model->get_ciamarks_details_coe($sub_id, $subdetails[3], $exam_id);
		
	  }else{
		  $this->data['mrks']=$this->Marks_model->get_ciamarks_details($me_id,$exam_id,$subdetails,$curr_session[0]['academic_year']);
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
		$testId2 =$_POST['sub_details'];

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
		$subdetails =explode('~',$_POST['sub_details']);
		$exss = str_replace('/', '_', $subdetails[5]);
		$exam = explode('-', $exss);
		//checking marks submission dates
		$exam_id=$exam[2];
		$today = date('Y-m-d');
		$Marks_submission_date= $this->Marks_model->Marks_submission_date($exam_id);
		$start_date=date('Y-m-d', strtotime($Marks_submission_date[0]['date_start']));
		$end_date=date('Y-m-d', strtotime($Marks_submission_date[0]['date_end']));
		$action_date=date('d-m-Y', strtotime($Marks_submission_date[0]['date_end']));
		// print_r($Marks_submission_date);
		// echo $today.'---'.$start_date.'---'.$end_date;exit;
		if($today >= $start_date && $today <= $end_date){

		}else{
			echo '<small style="color:red">Submission end</small>';exit;
		}
		/////////end /////////
		
		if (!empty($spk_details)) {
			$speakerupdate = $this->Marks_model->updateCIAMarkDetails($spk_details, $m_id,$testId2); //edit marks detail
		}
		
		redirect(base_url('Marks/editCIAMarksDetails/'.$testId.'/'.base64_encode($m_id)));
		
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

        if ($DB1->update('marks_entry_master', $update_array)) {
			//echo $DB1->last_query();exit;
            $this->session->set_flashdata('msg', 'Verified Successfully');
            redirect(base_url('Marks/editCIAMarksDetails/'.base64_encode($testId).'/'.base64_encode($me_id)));
        } else {
            $this->session->set_flashdata('msg', 'Problem while Verifying');
            redirect(base_url('Marks/editCIAMarksDetails/'.base64_encode($testId).'/'.base64_encode($m_id)));
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
		
        if ($DB1->update('marks_entry_master', $update_array)) {
			//echo $DB1->last_query();exit;
            $this->session->set_flashdata('msg', 'Verified Successfully');
            redirect(base_url('Marks/editCIAMarksDetails/'.base64_encode($testId).'/'.base64_encode($me_id)));
        } else {
            $this->session->set_flashdata('msg', 'Problem while Verifying');
            redirect(base_url('Marks/editCIAMarksDetails/'.base64_encode($testId).'/'.base64_encode($m_id)));
        }
	}
	// marks entry status
	public function entry_status()
	{
	    //error_reporting(E_ALL); ini_set('display_errors', 1);
		if($this->session->userdata("role_id")==15){
		}else{
			redirect('home');
		}
	    $this->load->model('Exam_timetable_model');
		$this->load->model('Results_model');
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
	        $this->data['exam_session']= $this->Results_model->fetch_result_exam_session();
	        $this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        $this->data['schools']= $this->Exam_timetable_model->getSchools();
	        $exam= explode('-', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
			$this->load->model('Results_model');
			$this->data['chk1'] = $this->Results_model->check_for_duplicate_result($_POST['admission-branch'], $_POST['semester'], $exam_month, $exam_year, $exam_id);
	        $this->data['sub_list']= $this->Marks_model->list_exam_subjects_for_status_applied($_POST, $exam_id);
	        
	        /*for($i=0;$i< count($this->data['sub_list']); $i++){
	            $subjectId = $this->data['sub_list'][$i]['sub_id'];
	            $this->data['sub_list'][$i]['mrk']= $this->Marks_model->getTHMarksEntryStatus($subjectId, $exam_month, $exam_year,$_POST['marks_type'],$_POST['admission-branch'], $_POST['semester']);
	            $this->data['sub_list'][$i]['cia']= $this->Marks_model->getCIAMarksEntryStatus($subjectId, $exam_month, $exam_year,$_POST['marks_type'],$_POST['admission-branch'], $_POST['semester']);
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
	        
	        $this->data['exam_session']=$this->Results_model->fetch_result_exam_session();
	        $this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        $this->data['schools']= $this->Exam_timetable_model->getSchools();
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
		
		$this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);
		$this->data['me']=$this->Marks_model->fetch_me_details($me_id);	
		$this->data['mrks']=$this->Marks_model->get_cia_and_thmarks_details($sub_id, $stream, $semester,$exam_id);		

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
		if($this->session->userdata("role_id")==15){
		}else{
			redirect('home');
		}
	    //error_reporting(E_ALL); ini_set('display_errors', 1);
	    $this->load->model('Exam_timetable_model');
	    $grade_letters= $this->Marks_model->list_grade_letter();
		$this->data['regulatn']= $this->Exam_timetable_model->getRegulation();
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
	        $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Exam_timetable_model->getSchools();
	        $exam= explode('-', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
			$exam_id =$exam[2];
			$exam_sess_acdyer =$exam[3];
	        
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;	       

			$this->data['grde_dt']= $this->Marks_model->fetch_examGrades($_POST, $exam_id);
			$updsateData = $this->data['grde_dt'];
			if(!empty($updsateData)){
				
				$this->data['stud_list']= $this->Marks_model->list_examresult_students_for_grade($_POST,$exam_id);	
				$this->data['sub_list']= $this->Marks_model->list_examAppliedstud_subjects($_POST, $exam_month, $exam_year,$exam_id);
				//$this->data['stud_list']= $this->Marks_model->update_grade_list_students($_POST,$exam_month, $exam_year,$this->data['exam_id']);	  
				$this->load->view($this->view_dir.'update_exam_marks_entry',$this->data);
			}else{	
			
				$this->data['stud_list']= $this->Marks_model->list_prev_exam_students($_POST,$exam_sess_acdyer);	
				$this->data['sub_list']= $this->Marks_model->list_prev_exam_stud_subjects($_POST);    
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
	        
	        $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Exam_timetable_model->getSchools();
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

		$sub_list= $this->Marks_model->list_prev_exam_stud_subjects($var);
		
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
						$DB1->insert("exam_result_data", $data);
				}
				//echo $DB1->last_query();//echo "insert <br>";
				//exit;

			}
			
			//exit();
		}
		//echo "Inserted Successfully!";
		$this->session->set_flashdata('msg', 'Grade Inserted Successfully!');
        redirect(base_url('Marks/prev_exam_grade_entry/'));
	}
	//update grades
	public function updateStudSubjectGrade()
    {       
        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$result_grade = $_POST['result_grade'];
		$result_id = $_POST['result_id'];
		$sub_det = explode('~',$_POST['sub_det']);
		$subject_id= $sub_det[0];
		$student_id= $sub_det[1];
		//echo "<pre>";
		//print_r($marks);  
		/// maintaing log
		if($result_id!=''){
 		$sql ="INSERT INTO exam_result_data_log (result_id, student_id, enrollment_no,exam_id,exam_month,exam_year,school_id,stream_id,semester,subject_id,subject_code,cia_marks,	exam_marks,	cia_garde_marks,garce_marks,moderate_marks,exam_grade_marks,final_garde_marks,result_grade,reval_grade,final_grade,entry_by,entry_on,entry_ip,modified_by, modified_on,modified_ip,is_deleted)
 			SELECT result_id, student_id, enrollment_no,exam_id,exam_month,exam_year,school_id,stream_id,semester,subject_id,subject_code,cia_marks,	exam_marks,	cia_garde_marks,garce_marks,moderate_marks,exam_grade_marks,final_garde_marks,result_grade,reval_grade,final_grade,entry_by,entry_on,entry_ip,modified_by, modified_on,modified_ip,is_deleted FROM exam_result_data where result_id='$result_id'";
		//$DB1->query->($sql); 
		$query = $DB1->query($sql);
		//$update_array['reval_grade'] = strtoupper($result_grade);
		$update_array['result_grade'] = strtoupper($result_grade);
		$update_array['final_grade'] = strtoupper($result_grade);
		$update_array['modified_on'] = date('Y-m-d H:i:s');
		$update_array['modified_by'] = $this->session->userdata("uid");
		$update_array['modified_ip'] = $this->input->ip_address();
		$where=array("result_id"=>$result_id);
		$DB1->where($where);                
		$DB1->update('exam_result_data', $update_array);
		//echo $DB1->last_query();
		$update_array1['grade'] = strtoupper($result_grade);
		$update_array1['passed'] = 'Y';
		$where1=array("student_id"=>$student_id,"subject_id"=>$subject_id);
		$DB1->where($where1);                
		//$DB1->update('exam_student_subject', $update_array1);
		//echo $DB1->last_query();exit;
		echo "SUCCESS";
		}else{
			echo "problem while updating";
		}
		//echo $DB1->last_query();exit;
	} 
	// for CIA
	public function cia_report()
    {
    	//error_reporting(E_ALL); ini_set('display_errors', 1);
		if($this->session->userdata("role_id")==20 ||  $this->session->userdata("role_id")==44 ||  $this->session->userdata("role_id")==15 ||  $this->session->userdata("role_id")==10){
		}else{
			redirect('home');
		}
      $this->load->model('Exam_timetable_model');
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
			$this->data['exam_session']= $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
			$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
			$this->data['schools']= $this->Exam_timetable_model->getSchools();
			$exam= explode('-', $_POST['exam_session']);
			$exam_month = $exam[0];
			$exam_year = $exam[1];
			
			$this->data['exam_month'] = $exam[0];
			$this->data['exam_year'] = $exam[1];
			$this->data['exam_sess_id'] = $exam[2];

			$this->data['sub_list']= $this->Marks_model->list_cia_subjects($_POST);
			$this->data['stud_list']= $this->Marks_model->list_cia_students_of_stream($_POST, $exam[2]);

			if($roll_id==15){
				$this->load->view($this->view_dir.'cia_consolidated_report_coe',$this->data);
			}else{
				$this->load->view($this->view_dir.'cia_consolidated_report',$this->data);
			}
			
		  }
		  else
		  {		         
			$this->data['school_code'] ='';
			$this->data['admissioncourse'] = '';
			$this->data['stream'] = '';
			$this->data['semester'] = '';
		
			$this->data['exam_session']= $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
			$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
			$this->data['schools']= $this->Exam_timetable_model->getSchools();
			$this->load->view($this->view_dir.'cia_consolidated_report',$this->data);
		  }
	 
	  $this->load->view('footer');
        
    }	
    // load cia stream

    function load_cia_streams(){
		//echo $_POST["course_id"];exit;
		if($_POST["course_id"] !=''){
			//Get all streams
			$stream = $this->Marks_model->load_cia_streams($_POST["course_id"]);
            
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
		$this->data['result_info'] = $this->Marks_model->list_cia_students_of_stream($res_data,$exam_id);
		//echo count($result_info);
		$this->data['exam_month'] = $exam[0];
		$this->data['exam_year'] = $exam[1];
		$this->data['exam_sess_id'] = $exam[2];
		
		$this->load->model('Exam_timetable_model');
		//$this->data['exam_sess']= $this->Exam_timetable_model->fetch_stud_curr_exam();
		$this->load->model('Examination_model');
		$this->data['StreamShortName'] =$this->Examination_model->getStreamShortName($stream);
		$this->data['sem_subjects'] = $this->Marks_model->list_cia_subjects($res_data);
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
		$this->data['result_info'] = $this->Marks_model->list_cia_students_of_stream($res_data, $exam_id);
		//echo count($result_info);
		$this->load->model('Exam_timetable_model');
		$this->data['exam_sess']= $this->Exam_timetable_model->fetch_stud_curr_exam();
		$this->load->model('Examination_model');
		$this->data['StreamShortName'] =$this->Examination_model->getStreamShortName($stream);
		$this->data['sem_subjects'] = $this->Marks_model->list_cia_subjects($res_data);
		//print_r($this->data['sem_subjects']);exit;

		//echo '<pre>';
		//print_r($this->data['result_info']);exit;
        $this->load->view($this->view_dir.'cia_consolidated_report_pdf',$this->data);
    }
//
     public function pdf_CIAReport($result_data){
		ini_set('memory_limit', '4096M');
		ini_set('max_execution_time', 600);
		set_time_limit(600);
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
		$this->data['result_info'] = $this->Marks_model->list_cia_students_of_stream($res_data, $exam_id);
		//echo count($result_info);
		$this->load->model('Exam_timetable_model');
		//$this->data['exam_sess']= $this->Exam_timetable_model->fetch_stud_curr_exam();
		$this->load->model('Examination_model');
		$this->data['StreamShortName'] =$this->Examination_model->getStreamShortName($stream);
		$this->data['sem_subjects'] = $this->Marks_model->list_cia_subjects($res_data);
		
		$this->data['exam_month'] = $exam_month;
		$this->data['exam_year'] = $exam_year;
		$this->data['exam_id'] = $exam_id;
        $this->load->library('m_pdf', $param);
	    $this->m_pdf->pdf=new mPDF('utf-8', 'A4-L', '5', '5', '15', '15', '45', '35');
	    $stream_name = $this->data['StreamShortName'][0]['stream_short_name'];
		$school = $this->data['StreamShortName'][0]['school_name'];
	    
	    $header ='<table align="center" width="100%"> 
			<tbody>  
				<tr>
					<td valign="top" height="40">
						<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin-top:15px;">
							<tr>
							<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="https://erp.sandipuniversity.com/assets/images/logo-7.jpg" alt="" width="50" border="0"></td>
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
						<table class="content-table" width="100%" cellpadding="2" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;">
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
		$footer ='<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" style="margin-bottom:40px;">
		<tr><td align="left" width="30%"><b>HOD</b><br><br><span style="font-size:11px;">Name: <br><br>Signature:</span><br><br><br><br></td>
		<td align="left" width="40%"><b>DEAN</b><br><br><span style="font-size:11px;">Name: <br><br>Signature:</span><br><br><br><br></td>
		<td align="left" width="30%"><b>Controller of Examination</b><br><br><span style="font-size:11px;">Name: Dr. Pravin R. Gundalwar <br><br>Signature:</span><br><br><br></td>
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
	    $this->m_pdf->pdf->Output($pdfFilePath, "I");
    }
	    // load cia stream

    function load_cia_semester(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			//Get all streams
			$exam = explode('-',$_POST["exam_session"]);
			$exam_id= $exam[2];
			$stream = $this->Marks_model->get_cia_examsemester($_POST["stream_id"], $exam_id);
            
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
		
		$this->data['result_info'] = $this->Marks_model->fetch_student_result_data($result_data);
		//echo count($result_info);

		$this->load->model('Exam_timetable_model');
		$this->data['exam_sess']= $this->Exam_timetable_model->fetch_stud_curr_exam();
		$this->load->model('Examination_model');
		$this->data['StreamShortName'] =$this->Examination_model->getStreamShortName($stream);
		$this->data['sem_subjects'] = $this->Marks_model->fetch_subjects_exam_semester($result_data);
		//print_r($this->data['sem_subjects']);exit;
		$i=0;
		foreach ($this->data['result_info'] as $res) {
			$stud_id = $res['student_id'];
			$this->data['result_info'][$i]['sub'] = $this->Marks_model->list_exam_subjects_for_status($res_data, $exam_id);
			$i++;
		}
		//echo '<pre>';
		//print_r($this->data['result_info']);exit;
        $this->load->view($this->view_dir.'comulative_mark_entry_excel',$this->data);
    }
	/************** Practical faculty Assign *****************/
	//List
	
	
    public function assign_prac_faculty($streamId='', $semester='', $course_id='', $school_id='', $batch='', $acd_year='')
    {
	   if($this->session->userdata("role_id")==20 ||  $this->session->userdata("role_id")==10 ||  $this->session->userdata("role_id")==44 
	      || $this->session->userdata("role_id")==15 ||  $this->session->userdata("role_id")==6 ){
	   }else{
			redirect('home');
	   }
		//error_reporting(E_ALL);
      $this->load->model('Exam_timetable_model');
	  $this->load->model('Subject_model');
	  $this->load->model('Timetable_model');
	  $this->data['batches']= $this->Subject_model->getRegulation1();
	  $this->data['academic_year']= $this->Exam_timetable_model->getCurrentSession_for_marks_entry(); 
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
		$this->data['exam_session']= $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
		$this->data['schools']= $this->Exam_timetable_model->getSchools();
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$this->data['exam_id'] =$exam_id;
		$sub_batch = $_POST['batch'];
		if($this->data['exam_session'][0]['exam_type']=='Regular'){
			
			$this->data['sub_list']= $this->Marks_model->list_practsubjects($_POST, $exam_id);
			$this->data['bksub_list']= $this->Marks_model->list_backlogsubjects($_POST, $exam_id);	
			for($i=0;$i< count($this->data['sub_list']); $i++){
				$subjectId = $this->data['sub_list'][$i]['sub_id'];
				$division = $this->data['sub_list'][$i]['division'];
				$batch_no = $this->data['sub_list'][$i]['batch_no'];
				
				$this->data['sub_list'][$i]['tt_details']= $this->Marks_model->get_subdetails($subjectId, $_POST['admission-branch'], $_POST['semester'],$exam_id, $division, $batch_no);
			}
			
			for($i=0;$i< count($this->data['bksub_list']); $i++){
				$subjectId = $this->data['bksub_list'][$i]['sub_id'];
				$division = 'A';
				if($_POST['school_code']==1002){
					$batch_no = '0';
				}else{
					$batch_no = '1';
				}
				//echo 'batch-'.$batch_no;exit;
				$this->data['bksub_list'][$i]['tt_details']= $this->Marks_model->get_subdetails_bklog($subjectId, $_POST['admission-branch'], $_POST['semester'],$exam_id, $division, $batch_no,$sub_batch);
			}
		}else{
			$this->data['bksub_list']= $this->Marks_model->list_backlogsubjects($_POST, $exam_id);
			for($i=0;$i< count($this->data['bksub_list']); $i++){
				$subjectId = $this->data['bksub_list'][$i]['sub_id'];
				$division = 'A';
				if($_POST['school_code']==1002){
					$batch_no = '0';
				}else{
					$batch_no = '1';
				}
				// echo 'basdastch-'.$batch_no;
				// exit;
				$this->data['bksub_list'][$i]['tt_details']= $this->Marks_model->get_subdetails_bklog($subjectId, $_POST['admission-branch'], $_POST['semester'],$exam_id, $division, $batch_no,$sub_batch);
			}
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
		$this->data['exam_session']= $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
		$this->data['schools']= $this->Exam_timetable_model->getSchools();
        $this->load->view($this->view_dir.'assign_prac_faculty',$this->data);
        $this->load->view('footer');
  
      }    
    } 
	
	//verify 
	
	public function verify_practical_entries()
	{
		$this->load->model('Marks_model');

		$school_code = $this->input->post('school_code');
		$course_id = $this->input->post('course_id');
		$stream_id = $this->input->post('stream_id');
		$semester = $this->input->post('semester');
		$batch = $this->input->post('batch');
		$academic_year = $this->input->post('academic_year');
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];

		// Example: update practical marks table
		$data = [
			'verified_flag' => 1,
			'verified_by' => $this->session->userdata('uid'),
			'verified_at' => date('Y-m-d H:i:s')
		];

		$where = [
			'course_id' => $course_id,
			'stream_id' => $stream_id,
			'semester' => $semester,
			'batch' => $batch,
			'exam_id' => $exam_id
		];
		// print_r($where);exit;
		$DB1 = $this->load->database('umsdb', TRUE);
		$update = $DB1->where($where)->update('exam_practical_subjects_faculty_assign', $data);
		echo $DB1->last_query();exit;
		if ($update) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'message' => 'No records updated']);
		}
	}

	// PR Appointment order 
	
	public function appointment_order_index()
	{
		$this->load->model('Exam_timetable_model');
		$this->load->model('Subject_model');
		$this->load->model('Marks_model');

		$this->load->view('header', $this->data);

		$this->data['academic_year'] = $this->Exam_timetable_model->getCurrentSession_for_marks_entry();
		$this->data['batches'] = $this->Subject_model->getRegulation1();
		$this->data['exam_session'] = $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
		$this->data['schools'] = $this->Exam_timetable_model->getSchools();
		
        $this->data['school_code'] = $this->input->get('school_code');
        $this->data['exam_id'] = $this->input->get('exam_session'); // optional if you have exam_id filter

        if (!empty($this->data['school_code']) && !empty($this->data['exam_session'])) {
            $this->data['assignments'] = $this->Marks_model->get_unique_external_faculty(
                $this->input->get('school_code'),
                $this->input->get('exam_session')
            );
        } else {
            $this->data['assignments'] = [];
        }

		$this->load->view($this->view_dir . 'appointments_list', $this->data);
		$this->load->view('footer');
	}
	
public function preview_appointment_letter($id = null)
{
    $this->load->model('Marks_model');

    // if you pass an $id, fetch real data; otherwise use dummy data for testing
    $assignment = $id ? $this->Marks_model->get_assignment($id) : [];

    // fallback dummy data for preview
    $data = [
        'ref_no'        => 'SUN/COE/PRACTICALS/Nov2025/CSE/001',
        'date'          => date('d-m-Y'),
        'examiner_name' => $assignment['ext_fac_name'] ?? 'Dr. John Doe',
        'designation'   => $assignment['ext_fac_designation'] ?? 'Assistant Professor',
        'department'    => $assignment['department_name'] ?? 'Computer Science and Engineering',
        'college_name'  => $assignment['ext_fac_institute'] ?? 'Sandip University, Nashik',
        'mobile_no'     => $assignment['ext_fac_mobile'] ?? '9876543210',
        'programme'     => $assignment['programme_name'] ?? 'B.Tech (CSE)',
        'course_name'   => $assignment['subject_name'] ?? 'Programming in C Laboratory',
        'exam_date'     => $assignment['exam_date'] ?? '23-11-2025',
        'timing'        => $assignment['exam_from_time'] ?? '09:00 AM - 05:00 PM',
        'strength'      => $assignment['strength'] ?? '30',
        'exam_month'    => 'Nov',
        'exam_year'     => '2025',
    ];

    // directly load the HTML view (not PDF)
    $this->load->view('Marks/appointment_letter_html', $data);
}

	public function verify_and_get_url()
	{
		$id = $this->input->post('id');
		$school_code = $this->input->post('school_code');
		$exam_session = $this->input->post('exam_session');
		$exam= explode('-', $exam_session);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		
		$DB1 = $this->load->database('umsdb', TRUE);

        $sql = "select school_short_name from school_master where school_code = '".$school_code."'";
        $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
       $data["school"] = $query->row();
		// echo $data["school"]->school_short_name;exit;
		 
		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid id']);
			return;
		}

		$this->load->model('Marks_model');
		$this->load->library('m_pdf');

		$user_id = $this->session->userdata('uid') ?? $this->session->userdata('name');
		$this->Marks_model->mark_letter_verified($id, $user_id);

		$assignments = $this->Marks_model->get_assignment($id,$exam_id);
		if (!$assignments) {
			echo json_encode(['status' => 'error', 'message' => 'No record found']);
			return;
		}

		$month     = $exam_month;
		$year      = $exam_year;
		$order_no = $this->Marks_model->generate_order_no($id,$data["school"]->school_short_name);

		// use the first row for common examiner details
		$first = $assignments[0];

		$data = [
			'ref_no'        => $order_no,
			'date'          => date('d-m-Y'),
			'examiner_name' => $first['ext_fac_name'],
			'designation'   => $first['ext_fac_designation'],
			'department'    => $first['department_name'] ?? 'N/A',
			'college_name'  => $first['ext_fac_institute'],
			'mobile_no'     => $first['ext_fac_mobile'],
			'exam_month'    => $month,
			'exam_year'     => $year,
			'courses'       => [] // for looping in view
		];

		// loop through all assignments and push to table
		$i = 1;
		foreach ($assignments as $a) {
			$data['courses'][] = [
				'sno'         => $i++,
				'exam_date'   => $a['exam_date'] ?? '-',
				'programme'   => $a['stream_short_name'] ?? 'N/A',
				'course_name' => $a['subject_name'] ?? 'N/A',
				'division'   => $a['division'] ?? '-',
				'batch'   => $a['batch_no'] ?? '-',
				'timing'      => (($a['exam_from_time'] ?? '') . ':00 - ' . ($a['exam_to_time'] ?? '') . ' ' . ($a['time_format'] ?? '')),
				'strength'    => $a['regular_strength'] ?? '—',
			];
		}

		$html = $this->load->view('Marks/appointment_letter_html', $data, true);

		$this->m_pdf->pdf = new mPDF('L', 'A4', '', '', 15, 15, 40, 10, 5, 5);

		$header = '
			<div style="text-align: center; font-size: 16px; font-weight: bold; padding-top: 0px; margin-bottom: 0px;">
				<table style="width: 100%; border: 1px solid black; border-collapse: collapse; font-size: 12px;">
					<tr>
						<td style="width: 20%; border: none; text-align: center;">
							<img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">
						</td>
						<td style="width: 60%; border-left: 1px solid black;border-right: 1px solid black; text-align: center;">
							<div style="font-size: 24px; font-weight: bold;color: red;">Sandip University</div>
							<div style="font-size: 12px; color: #242424;">Mahiravani, Trimbak Road, Nashik - 422 213</div>
							<div style="font-weight: bold; font-size: 14px;">Office of the Controller of Examinations</div>
						</td>
						<td style="width: 20%; border: none; text-align: center;">
							<div style="font-size: 30px; font-weight: bold;">COE</div>
						</td>
					</tr>
				</table>
				
				<!-- Ref No and Date -->
				<table style="border:none !important; margin-bottom:0px !important;">
					<tr>
						<td class="left" style="border:none !important;"><strong>Ref:</strong> '.$order_no.'</td>
						<td class="right" style="border:none !important;"><strong>Date:</strong> '.date('d-m-Y').'</td>
					</tr>
				</table>
			</div>
			';
		$this->m_pdf->pdf->SetHTMLHeader($header);
		$this->m_pdf->pdf->SetHTMLFooter("<div style='text-align: center; font-size: 10px;'>Page {PAGENO} of {nbpg}</div>");

		$this->m_pdf->pdf->WriteHTML($html);
		
		$pdfContent = $this->m_pdf->pdf->Output('', 'S'); // return string, not file

		$base64 = 'data:application/pdf;base64,' . base64_encode($pdfContent);

		echo json_encode([
			'status'       => 'success',
			'download_url' => $base64,
		]);
	}

    public function send_and_mail_letter()
	{
		$id = $this->input->post('id');
		$school_code = $this->input->post('school_code');
		$exam_session = $this->input->post('exam_session');
		$exam = explode('-', $exam_session);
		$exam_month = $exam[0];
		$exam_year = $exam[1];
		$exam_id = $exam[2];

		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
			return;
		}

		$DB1 = $this->load->database('umsdb', TRUE);
		$this->load->model('Marks_model');
		$this->load->library('m_pdf');
		$this->load->library('phpmailer');
		$this->load->library('smtp');

		// Fetch school details
		$school = $DB1->query("SELECT school_short_name FROM school_master WHERE school_code = ?", [$school_code])->row();

		// Get assignment details
		$assignments = $this->Marks_model->get_assignment($id, $exam_id);
		if (!$assignments) {
			echo json_encode(['status' => 'error', 'message' => 'No record found']);
			return;
		}

		$first = $assignments[0];
		// $to_email = $first['ext_fac_email'];
		// $to_email = 'jayesh.patil@siem.org.in';
		 $to_email = 'acoe@sandipuniversity.edu.in';

		if (empty($to_email)) {
			echo json_encode(['status' => 'error', 'message' => 'Email not found for this faculty']);
			return;
		}

		// Generate order no & letter content
		$order_no = $this->Marks_model->generate_order_no($id, $school->school_short_name);
		$month = $exam_month;
		$year = $exam_year;

		$data = [
			'ref_no'        => $order_no,
			'date'          => date('d-m-Y'),
			'examiner_name' => $first['ext_fac_name'],
			'designation'   => $first['ext_fac_designation'],
			'department'    => $first['department_name'] ?? 'N/A',
			'college_name'  => $first['ext_fac_institute'],
			'mobile_no'     => $first['ext_fac_mobile'],
			'exam_month'    => $month,
			'exam_year'     => $year,
			'courses'       => []
		];

		$i = 1;
		foreach ($assignments as $a) {
			$data['courses'][] = [
				'sno'         => $i++,
				'exam_date'   => $a['exam_date'] ?? '-',
				'programme'   => $a['stream_short_name'] ?? 'N/A',
				'course_name' => $a['subject_name'] ?? 'N/A',
				'division'   => $a['division'] ?? '-',
				'batch'   => $a['batch_no'] ?? '-',
				'timing'      => (($a['exam_from_time'] ?? '') . ':00 - ' . ($a['exam_to_time'] ?? '') . ' ' . ($a['time_format'] ?? '')),
				'strength'    => $a['regular_strength'] ?? '—',
			];
		}

		// Generate PDF
		$html = $this->load->view('Marks/appointment_letter_html', $data, true);
		$mpdf = new mPDF('L', 'A4', '', '', 15, 15, 40, 10, 5, 5);

		$header = '
		<div style="text-align: center; font-size: 16px; font-weight: bold;">
			<table style="width:100%; border:1px solid black; border-collapse:collapse; font-size:12px;">
				<tr>
					<td style="width:20%; text-align:center;">
						<img src="' . base_url('assets/images/su-logo.png') . '" style="width:80px;">
					</td>
					<td style="width:60%; text-align:center; border-left:1px solid black; border-right:1px solid black;">
						<div style="font-size:24px; color:red;">Sandip University</div>
						<div style="font-size:12px;">Mahiravani, Trimbak Road, Nashik - 422 213</div>
						<div style="font-weight:bold; font-size:14px;">Office of the Controller of Examinations</div>
					</td>
					<td style="width:20%; text-align:center;">
						<div style="font-size:30px; font-weight:bold;">COE</div>
					</td>
				</tr>
			</table>
			<table style="width:100%; border:none;">
				<tr>
					<td><strong>Ref:</strong> ' . $order_no . '</td>
					<td style="text-align:right;"><strong>Date:</strong> ' . date('d-m-Y') . '</td>
				</tr>
			</table>
		</div>';

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter("<div style='text-align:center;font-size:10px;'>Page {PAGENO} of {nbpg}</div>");
		$mpdf->WriteHTML($html);

		$pdfContent = $mpdf->Output('', 'S');

		// Send email with PHPMailer
		$mail = new PHPMailer(true);
		try {
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'noreply11@sandipuniversity.edu.in';
			$mail->Password = 'gqej udth gjpj nxvs'; // Use App Password
			$mail->SMTPSecure = 'ssl';
			$mail->Port = 465;

			$mail->setFrom('noreply11@sandipuniversity.edu.in', 'Exam Management Team');
			$mail->addAddress($to_email);
			$mail->addAddress('erp.support@sandipuniversity.edu.in');
			$mail->isHTML(true);
			$mail->Subject = "Appointment Letter - Sandip University";
			$mail->Body = "
				<p>Dear " . $first['ext_fac_name'] . ",</p>
				<p>Please find attached your appointment order for the upcoming Practical Examination.</p>
				<p>Warm regards,<br>Office of the Controller of Examinations<br>Sandip University</p>
			";

			$mail->addStringAttachment($pdfContent, 'Appointment_Letter.pdf');

			if ($mail->send()) {
				// Update status in DB
				$DB1->set('letter_sent', 'N');
				$DB1->set('sent_on', 'NOW()', false);
				$DB1->set('sent_by', $this->session->userdata('uid'));
				$DB1->where('ext_faculty_code', $id);
				$DB1->update('exam_external_faculty_master');
				
				echo json_encode(['status' => 'success', 'message' => 'Email sent successfully']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Mail sending failed']);
			}
		} catch (Exception $e) {
			echo json_encode(['status' => 'error', 'message' => 'Mailer error: ' . $mail->ErrorInfo]);
		}
	}

	
	// PR Remuneration
	
	public function remuneration_index() {
		$this->load->view('header',$this->data);  
        $this->data['schools'] = $this->Marks_model->get_all_schools();
        $this->data['remunerations'] = $this->Marks_model->get_all_remunerations();
		$this->load->view($this->view_dir.'remuneration_index',$this->data);
        $this->load->view('footer');
    }

    public function load_courses() {
        $school_code = $this->input->post('school_code');
        $courses = $this->Marks_model->get_courses_by_school($school_code);
        echo '<option value="">Select Course</option>';
        foreach ($courses as $c) {
            echo '<option value="'.$c['course_id'].'">'.$c['course_short_name'].'</option>';
        }
    }

    public function remuneration_save() {
        $post = $this->input->post();

        // Validation — at least one remuneration must be filled
		// print_r($post);exit;
        if (
            empty($post['practical']) &&
            empty($post['project']) &&
            empty($post['viva_voce']) &&
            empty($post['dissertation'])
        ) {
            echo json_encode(['status' => 'error', 'message' => 'Enter at least one remuneration value.']);
            return;
        }

        if (empty($post['id'])) {
            $this->Marks_model->insert_remuneration($post);
            echo json_encode(['status' => 'success', 'message' => 'Remuneration added successfully']);
        } else {
            $this->Marks_model->update_remuneration($post['id'], $post);
            echo json_encode(['status' => 'success', 'message' => 'Remuneration updated successfully']);
        }
    }

    public function get_remuneration() {
        $id = $this->input->post('id');
        $data = $this->Marks_model->get_remuneration($id);
        echo json_encode($data);
    }
	
	
	
	public function assign_prac_faculty_pdf()
	{
		// Load models
		$this->load->model('Marks_model');
		$this->load->model('Exam_timetable_model');
		
		$post = $this->input->post();
		if(!$post){
			show_error('No data provided for PDF generation.');
		}

		$exam = explode('-', $post['exam_session']);
		$exam_month = $exam[0];
		$exam_year = $exam[1];
		$exam_id = $exam[2];

		// Fetch subjects
		$sub_list = $this->Marks_model->list_practsubjects($post, $exam_id);
		$bksub_list = $this->Marks_model->list_backlogsubjects($post, $exam_id);

		// Fetch timetable details
		foreach ($sub_list as $i => $sub) {
			$sub_list[$i]['tt_details'] = $this->Marks_model->get_subdetails(
				$sub['sub_id'],
				$post['admission-branch'],
				$post['semester'],
				$exam_id,
				$sub['division'],
				$sub['batch_no']
			);
		}
		foreach ($bksub_list as $i => $sub) {
			$batch_no = ($post['school_code']==1002) ? '0' : '1';
			$bksub_list[$i]['tt_details'] = $this->Marks_model->get_subdetails_bklog(
				$sub['sub_id'],
				$post['admission-branch'],
				$post['semester'],
				$exam_id,
				'A',
				$batch_no,
				$post['batch']
			);
		}
		// print_r($sub_list[0]['tt_details'][0]);exit;
			$this->load->library('m_pdf');
			//$mpdf=new mPDF();
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4-L', '8', '8', '10', '10', '45', '30');
			// Determine exam type based on backlog subjects
			$exam_type = !empty($bksub_list) ? 'PRACTICAL - BACKLOG' : 'PRACTICAL - REGULAR';

		// HEADER - Table layout
		$header = '
		<table width="100%" style="border-bottom:1px solid #000;">
			<tr>
				<td width="20%" style="text-align:left;vertical-align:top;">
					<img src="'.base_url('assets/images/su-logo.png').'" height="80">
				</td>
				<td width="60%" style="text-align:center; font-family:Bookman-old-style; vertical-align:top;">
					<h3 style="padding-bottom:5px;color:red;font-size:22px;">SANDIP UNIVERSITY</h3>
					<h3 style="margin:0;font-size:14px;">END SEMESTER EXAMINATIONS ('.$exam_type.') – '.$exam_month.' '.$exam_year.'</h3><br>
					<h4 style="margin:0;font-size:14px;">TIME – TABLE & PANEL OF EXAMINERS</h4>
					<h4 style="margin:0;font-size:10px; font-weight:normal;">(To be submitted to the CoE office)</h4>
				</td>
				<td width="20%" style="text-align:right; font-size:30px; font-weight:bold; vertical-align:center;">
					COE
				</td>
			</tr>
		</table>
		<p style="font-size:13px;font-weight:bold;font-family:Bookman-old-style;">Academic Year: '.$post['academic_year'].' | School: '.$sub_list[0]['tt_details'][0]['school_short_name'].' | Stream: '.$sub_list[0]['tt_details'][0]['stream_name'].' | Semester: '.$post['semester'].' | Batch: '.$post['batch'].'</p>
		';

		$this->m_pdf->pdf->SetHTMLHeader($header,'',true); // 3rd parameter true ensures repetition on all pages

		// FOOTER
		$footer = '
		<table width="100%" style="border:none; font-family:Bookman-old-style; font-size:12px;">
			<tr>
			
				<td width="20%">Date: '.date('d-m-Y').'</td>
				<td width="20%" style="text-align:center;">COE/ERP Co-ordinator</td>
				<td width="20%" style="text-align:center;">Signature of HoD</td>
				<td width="20%" style="text-align:center;">Signature of Dean</td>
				<td width="20%" style="text-align:center;">Controller Of Examination</td>
				
			</tr>
		</table>
		<p style="font-size:10px; margin-top:5px;">
			Note: As per the programme and course requirement, the department can rearrange the timings and batches (25-30 candidates only) per day.
			Project/Dissertation - 15-20 Candidates per batch.<br>
			If number of candidates exceed per batch, special permission should be obtained from the CoE.
		</p>';

		$this->m_pdf->pdf->SetHTMLFooter($footer,'',true); // Footer on each page

		// Table content (same as your code)
		$table = '
		
		<table border="0" cellpadding="5" cellspacing="0" width="100%" style="text-align:center;font-family:Bookman-old-style;">
			<thead>
				<tr style="background-color:#f2f2f2;">
					<th style="border:1px solid #ccc; padding:4px;">S.No</th>
					<th style="border:1px solid #ccc; padding:4px; text-align:left;">Practical Course Code & Title</th>
					<th style="border:1px solid #ccc; padding:4px;">Division/Batch(s)</th>
					<th style="border:1px solid #ccc; padding:4px;">Strength</th>
					<th style="border:1px solid #ccc; padding:4px;">Date of Exam</th>
					<th style="border:1px solid #ccc; padding:4px;">Timings</th>
					<th style="border:1px solid #ccc; padding:4px;">Internal Examiner<br><span style="font-size:9px;">(Name, Designation)</span></th>
					<th style="border:1px solid #ccc; padding:4px;">External Examiner<br><span style="font-size:9px;">(Name, Designation, Dept & College)</span></th>
					<th style="border:1px solid #ccc; padding:4px;">Lab Assistant<br><span style="font-size:9px;">(Name, Designation)</span></th>
				</tr>
			</thead>
			<tbody>';

		$i = 1;
		foreach($sub_list as $sub){
			$tt = $sub['tt_details'][0];
			$internal = (!empty($tt['fname'])) ? strtoupper($tt['fname'][0].'. '.$tt['mname'][0].'. '.$tt['lname']).'<br><span style="font-size:9px;">('.$tt['designation_name'].')</span>' : 'Not Assigned';
			$lab_asst = (!empty($tt['lab_fname'])) ? strtoupper($tt['lab_fname'][0].'. '.$tt['lab_mname'][0].'. '.$tt['lab_lname']).'<br><span style="font-size:9px;">('.$tt['lab_designation_name'].')</span>' : 'Not Assigned';
			$external = (!empty($tt['ext_faculty_code'])) ? strtoupper($tt['ext_faculty_code']).'- '.strtoupper($tt['ext_fac_name']).'<br><span style="font-size:9px;">('.$tt['ext_fac_designation'].','.$tt['ext_fac_institute'].')</span>' : 'Not Assigned';
			$date = (!empty($tt['exam_date'])) ? $tt['exam_date'] : '';
			$timing = (!empty($tt['exam_from_time'])) ? $tt['exam_from_time'].':00 - '.$tt['exam_to_time'].':00 '.$tt['time_format'] : '';
			$strength = $this->Marks_model->fetch_student_strength($sub['sub_id'],$tt['stream_id'],$sub['semester'],$sub['division'],$sub['batch_no'], $post['academic_year']);
			// print_r($strength);exit;
			$regstrength = count($strength);
			$batch = ($post['school_code']==1002) ? 0 : $sub['batch_no'];

			$table .= '<tr>
							<td style="border:1px solid #ccc; padding:4px;">'.$i.'</td>
							<td style="border:1px solid #ccc; padding:4px; text-align:left;">'.$sub['subject_code'].' - '.strtoupper($sub['subject_name']).'</td>
							<td style="border:1px solid #ccc; padding:4px;">'.$sub['division'].'/'.$batch.'</td>
							<td style="border:1px solid #ccc; padding:4px;">'.$regstrength.'</td>
							<td style="border:1px solid #ccc; padding:4px;">'.$date.'</td>
							<td style="border:1px solid #ccc; padding:4px;">'.$timing.'</td>
							<td style="border:1px solid #ccc; padding:4px;">'.$internal.'</td>
							<td style="border:1px solid #ccc; padding:4px;">'.$external.'</td>
							<td style="border:1px solid #ccc; padding:4px;">'.$lab_asst.'</td>
						</tr>';
			$i++;
		}

		// Backlog subjects
		foreach($bksub_list as $sub){
			$tt = $sub['tt_details'][0];
			$internal = (!empty($tt['fname'])) ? strtoupper($tt['fname'][0].'. '.$tt['mname'][0].'. '.$tt['lname']).'<br><span style="font-size:9px;">('.$tt['designation_name'].')</span>' : 'Not Assigned';
			$lab_asst = (!empty($tt['lab_fname'])) ? strtoupper($tt['lab_fname'][0].'. '.$tt['lab_mname'][0].'. '.$tt['lab_lname']).'<br><span style="font-size:9px;">('.$tt['lab_designation_name'].')</span>' : 'Not Assigned';
			$external = (!empty($tt['ext_faculty_code'])) ? strtoupper($tt['ext_faculty_code']).'- '.strtoupper($tt['ext_fac_name']).'<br><span style="font-size:9px;">('.$tt['ext_fac_designation'].','.$tt['ext_fac_institute'].')</span>' : 'Not Assigned';
			$date = (!empty($tt['exam_date'])) ? $tt['exam_date'] : '';
			$timing = (!empty($tt['exam_from_time'])) ? $tt['exam_from_time'].':00 - '.$tt['exam_to_time'].':00 '.$tt['time_format'] : '';
			$strength = $this->Marks_model->fetch_student_strength_backlog($sub['sub_id'],$sub['semester'],$exam_id);
			$bkstrength = count($strength);
			$batch = ($post['school_code']==1002) ? 0 : 'A/1';

			$table .= '<tr>
				<td style="border:1px solid #ccc; padding:4px;">'.$i.'</td>
				<td style="border:1px solid #ccc; padding:4px;">'.$sub['subject_code'].' - '.strtoupper($sub['subject_name']).'</td>
				<td style="border:1px solid #ccc; padding:4px;">'.$batch.'</td>
				<td style="border:1px solid #ccc; padding:4px;">'.$bkstrength.'</td>
				<td style="border:1px solid #ccc; padding:4px;">'.$date.'</td>
				<td style="border:1px solid #ccc; padding:4px;">'.$timing.'</td>
				<td style="border:1px solid #ccc; padding:4px;">'.$internal.'</td>
				<td style="border:1px solid #ccc; padding:4px;">'.$external.'</td>
				<td style="border:1px solid #ccc; padding:4px;">'.$lab_asst.'</td>
				
			</tr>';
			$i++;
		}

		$table .= '</tbody></table>';
		$this->m_pdf->pdf->WriteHTML($table);

		$filename = 'Practical_Faculty_Assign_'.$exam_month.'_'.$exam_year.'.pdf';
		$this->m_pdf->pdf->Output($filename,'I');
	}

	public function practical_noticeboard_pdf()
	{
		$post = $this->input->post();
		if (!$post) {
			show_error('No data provided for PDF generation.');
		}

		$exam = explode('-', $post['exam_session']);
		$exam_month = $exam[0];
		$exam_year = $exam[1];
		$exam_id = $exam[2];

		// Load model
		$this->load->model('Marks_model');

		// =========================
		// 1. FETCH PRACTICAL SUBJECTS (Regular)
		// =========================
		$sub_list = $this->Marks_model->list_practsubjects($post, $exam_id);

		// =========================
		// 2. FETCH BACKLOG PRACTICAL SUBJECTS
		// =========================
		$bksub_list = $this->Marks_model->list_backlogsubjects($post, $exam_id); // ← ensure you have this model function

		// attach timetable details to backlog list
		foreach ($bksub_list as $i => $sub) {
			$batch_no = ($post['school_code'] == 1002) ? '0' : '1';
			$bksub_list[$i]['tt_details'] = $this->Marks_model->get_subdetails_bklog(
				$sub['sub_id'],
				$post['admission-branch'],
				$post['semester'],
				$exam_id,
				'A',
				'1',
				$post['batch']
			);
		}

		// Combine both lists
		$final_list = array_merge($sub_list, $bksub_list);

		// =========================
		// 3. INIT MPDF
		// =========================
		$this->load->library('m_pdf');
		$this->m_pdf->pdf = new mPDF('utf-8', 'A4-L', '8', '8', '5', '5', '45', '30');

		// =========================
		// 4. HEADER
		// =========================
		$exam_type = !empty($bksub_list) ? 'PRACTICAL - BACKLOG' : 'PRACTICAL - REGULAR';
		$header = '
		<table width="100%" style="border-bottom:1px solid #000;">
			<tr>
				<td width="20%" style="text-align:left;vertical-align:top;">
					<img src="'.base_url('assets/images/su-logo.png').'" height="80">
				</td>
				<td width="60%" style="text-align:center; font-family:Bookman-old-style; vertical-align:top;">
					<h3 style="padding-bottom:5px;color:red;font-size:22px;">SANDIP UNIVERSITY</h3>
					<h3 style="margin:0;font-size:14px;">END SEMESTER EXAMINATIONS ('.$exam_type.') – '.$exam_month.' '.$exam_year.'</h3>
					<br>
					<h4 style="margin:0;font-size:14px;">PRACTICAL EXAM TIME – TABLE</h4>
				</td>
				<td width="20%" style="text-align:right; font-size:30px; font-weight:bold; vertical-align:center;">
					COE
				</td>
			</tr>
		</table>
		<p style="font-size:13px;font-weight:bold;font-family:Bookman-old-style;">
			Academic Year: '.$post['academic_year'].' | School: '.$sub_list[0]['school_short_name'].' | Stream: '.$sub_list[0]['stream_name'].' | Semester: '.$post['semester'].' | Batch: '.$post['batch'].'
		</p>';
		$this->m_pdf->pdf->SetHTMLHeader($header, '', true);

		// =========================
		// 5. FOOTER
		// =========================
		$footer = '
		<table width="100%" style="border:none; font-family:Bookman-old-style; font-size:12px; margin-top:10px;">
			<tr>
					<td width="25%">Date: '.date('d-m-Y').'</td>
					<td width="25%" style="text-align:center;">COE/ERP Co-ordinator</td>
					<td width="25%" style="text-align:center;">Signature of HoD</td>
					<td width="25%" style="text-align:center;">Signature of Dean</td>
			</tr>
		</table>
		<p style="font-size:10px; margin-top:5px;">
			Important Instructions:<br>
			1. The students must report 15 minutes before the scheduled time in proper dress
			code/uniform along with I-card.<br>
			2. Ensure all journals/term work files are duly checked and signed before the exam.<br>
			3. Maintain discipline and decorum during the examination.<br>
			4. Any change in the schedule will be communicated in the due course.
		</p>';
		$this->m_pdf->pdf->SetHTMLFooter($footer, '', true);

		// =========================
		// 6. GROUP DATA (Regular + Backlog)
		// =========================
		$grouped = [];
		// print_r($final_list);exit;
		foreach ($final_list as $sub) {
			// use correct timetable function based on type
			$tt_details = isset($sub['tt_details'])
				? $sub['tt_details']
				: $this->Marks_model->get_subdetails(
					$sub['sub_id'],
					$post['admission-branch'],
					$sub['semester'],
					$exam_id,
					$sub['division'],
					$sub['batch_no']
				);

				foreach ($tt_details as $tt) {
					// Regular students
					$students = $this->Marks_model->fetch_student_strength(
						$sub['sub_id'],
						$tt['stream_id'],
						$sub['semester'],
						$sub['division'],
						$sub['batch_no'],
						$post['academic_year']
					);

					// Backlog students
					$bklg_students = $this->Marks_model->fetch_student_strength_backlog(
						$sub['sub_id'],
						$sub['semester'],
						$exam_id
					);
					// print_r($bklg_students);exit;
					$strength = count($students);
					$strength_bklg = count($bklg_students);

					// Regular student PRN range
					if ($strength > 0) {
						usort($students, fn($a, $b) => $a['roll_no'] - $b['roll_no']);
						$prn_from = $students[0]['enrollment_no'];
						$prn_to = $students[$strength - 1]['enrollment_no'];
					} else {
						$prn_from = $prn_to = '-';
					}

					// Backlog student PRN range
					if ($strength_bklg > 0) {
						usort($bklg_students, fn($a, $b) => $a['roll_no'] - $b['roll_no']);
						$prn_from_bklg = $bklg_students[0]['enrollment_no'];
						$prn_to_bklg = $bklg_students[$strength_bklg - 1]['enrollment_no'];
					} else {
						$prn_from_bklg = $prn_to_bklg = '-';
					}

					$key = $tt['exam_date'].'_'.$sub['subject_code'];
					$grouped[$key][] = [
						'batch_no' => $sub['batch_no'] ?? '1',
						'division' => $sub['division'] ?? 'A',
						'timings' => $tt['exam_from_time'].':00 - '.$tt['exam_to_time'].':00 '.$tt['time_format'],
						'strength' => $strength + $strength_bklg, // combine both strengths if needed
						'prn_from' => $prn_from,
						'prn_to' => $prn_to,
						'prn_from_bklg' => $prn_from_bklg,
						'prn_to_bklg' => $prn_to_bklg,
						'venue' => $tt['hall_no'].' - '.$tt['lab_name'],
						'subject_name' => strtoupper($sub['subject_name']),
						'date' => $tt['exam_date'],
						'subject_code' => $sub['subject_code']
					];
				}

			}

		// =========================
		// 7. BUILD TABLE (THIN BORDERS, NEAT)
		// =========================
		$table = '
		<table border="0" cellpadding="4" cellspacing="0" width="100%" style="font-family:Bookman-old-style; font-size:12px; border-collapse:collapse;">
			<thead>
				<tr style="background-color:#f2f2f2; border-bottom:1px solid #999;">
					<th style="border:0.3px solid #999; padding:4px;">Sr.No.</th>
					<th style="border:0.3px solid #999; padding:4px; text-align:left;">Course Code - Subject Name</th>
					<th style="border:0.3px solid #999; padding:4px;">Div/Batch</th>
					<th style="border:0.3px solid #999; padding:4px;">Date</th>
					<th style="border:0.3px solid #999; padding:4px;">Timings</th>
					<th style="border:0.3px solid #999; padding:4px;">Total Strength</th>
					<th style="border:0.3px solid #999; padding:4px;">PRN (From-To)</th>
					<th style="border:0.3px solid #999; padding:4px;">Venue</th>
				</tr>
			</thead>
			<tbody>';

		$i = 1;
		foreach ($grouped as $batches) {
			$rowspan = count($batches);
			$first = true;

			foreach ($batches as $batch) {
				$table .= '<tr>';
				if ($first) {
					$table .= '<td rowspan="'.$rowspan.'" style="border:0.3px solid #999; padding:4px; vertical-align:middle;">'.$i++.'</td>';
					$table .= '<td rowspan="'.$rowspan.'" style="border:0.3px solid #999; padding:4px; text-align:left; vertical-align:middle;">'.$batch['subject_code'].' - '.$batch['subject_name'].'</td>';
					$first = false;
				}

				$table .= '<td style="border:0.3px solid #999; padding:4px; text-align:center;">'.$batch['division'].'/'.$batch['batch_no'].'</td>';
				$table .= '<td style="border:0.3px solid #999; padding:4px;">'.$batch['date'].'</td>';
				$table .= '<td style="border:0.3px solid #999; padding:4px;">'.$batch['timings'].'</td>';
				$table .= '<td style="border:0.3px solid #999; padding:4px; text-align:center;">'.$batch['strength'].'</td>';
				$table .= '<td style="border:0.3px solid #999; padding:4px;">';
				if ($batch['prn_from'] != '-' || $batch['prn_to'] != '-') {
					$table .= $batch['prn_from'].' - '.$batch['prn_to'].'<br>';
				}
				if ($batch['prn_from_bklg'] != '-' || $batch['prn_to_bklg'] != '-') {
					$table .= $batch['prn_from_bklg'].' - '.$batch['prn_to_bklg'];
				}
				$table .= '</td>';
				$table .= '<td style="border:0.3px solid #999; padding:4px;">'.$batch['venue'].'</td>';
				$table .= '</tr>';
			}
		}

		$table .= '</tbody></table>';

		// =========================
		// 8. OUTPUT PDF
		// =========================
		$this->m_pdf->pdf->WriteHTML($table);
		$filename = 'Practical_Noticeboard_' . $exam_month . '_' . $exam_year . '.pdf';
		$this->m_pdf->pdf->Output($filename, 'I');
	}


	



     //add view
	public function add_subject_faculty($subject_id ='',$stream_id ='',$semester = '',$exam_id='',$school='', $division='', $batch='', $bkflag=''){
	   //error_reporting(E_ALL);
		$this->load->model('Timetable_model');  
		$this->load->view('header',$this->data); 
		$this->data['academicyear']=$academicyear;   
		$this->data['exam_id']=$exam_id;
		$this->data['stream_id_bsc']= $stream_id;
		
		if($bkflag==''){
			$this->data['sub']=$this->Marks_model->get_subdetails($subject_id,$stream_id,$semester,$exam_id, $division, $batch);
		}else{
			$this->data['sub']=$this->Marks_model->get_backlogsubdetails($subject_id,$stream_id,$semester,$exam_id, $division, $batch);
		}
		$this->data['labs'] = $this->Marks_model->get_all_labs(); 
		$this->data['faculty_list']=$this->Marks_model->get_faculty_list($stream_id,$semester); 	
		$this->data['peon_list']=$this->Marks_model->get_peon_list($stream_id,$semester); 	
		$this->data['lab_assist_list']=$this->Marks_model->get_lab_faculty_list($stream_id,$semester); 	
		$this->data['exfaculty_list']=$this->Marks_model->get_exfaculty_list(); 		
        $this->load->view($this->view_dir.'add_pract_exam_faculty_subject',$this->data);
        $this->load->view('footer');
	}

	// claim form
	
	public function download_claim_form($encoded_details)
	{
		$details = explode('~', base64_decode($encoded_details));
		list($subject_id, $school_code, $admissioncourse, $stream_id, $semester, $exam_session, $marks_type, $division,
		$batch_no, $reval, $is_backlog, $exam_date,$course_id) = $details;
		$exam_parts = explode('-', $exam_session);
		$data['exam_id'] = strtoupper($exam_parts[2]);
		$data['exam_month'] = strtoupper($exam_parts[0]);
		$data['exam_year']  = $exam_parts[1];
		$this->load->model('Marks_model');
		$this->load->library('m_pdf');
		
		// Fetch claim data
		$data['claim'] = $this->Marks_model->get_claim_details($subject_id, $stream_id, $semester, $division, $batch_no, $exam_parts[2]);

		if (empty($data['claim'])) {
			show_error('No claim data found for this practical.', 404);
			return;
		}

		// Render HTML → PDF
		$html = $this->load->view('Marks/claim_form_pdf', $data, true);

		$mpdf = new mPDF('P', 'A4-L', '', '', 10, 10, 10, 10);
		$mpdf->WriteHTML($html);
		$mpdf->Output('Claim_Form_'.$data['claim']['subject_code'].'.pdf', 'I');
	}


	// insert 
	public function insert_pract_subject_faculty(){
	    //error_reporting(E_ALL);
		$chk_duplicate = $this->Marks_model->checkDuplicate_pract_faculty($_POST);
		 // echo 'hiii';exit;
		 // print_r($_POST);exit;
		 if (!empty($_POST['faculty']) || !empty($_POST['int_faculty_code'])) {
			if(count($chk_duplicate) > 0){	
				// if($this->session->userdata("role_id")==15){			
					$this->Marks_model->update_pract_subject_faculty($_POST);
				// }else{
					// echo 'Edit Should Done By COE Office Only';exit;
				// }
			}
			// echo 'byee';exit;
			
			if($this->Marks_model->insert_pract_subject_faculty($_POST))
			{
				
				redirect(base_url($this->view_dir.'assign_prac_faculty/'.$_POST['stream_id'].'/'.$_POST['semester'].'/'.$_POST['course_id'].'/'.$_POST['school_code'].'/'.$_POST['batch']));
			}
			else
			{
				redirect(base_url($this->view_dir.'assign_prac_faculty'));
			}
		}else{
			// if($this->session->userdata("role_id")==15){
				if(!empty($_POST['change_exfaculty']) || !empty($_POST['exam_date']) || !empty($_POST['exam_from_time']) || !empty($_POST['exam_to_time']) || !empty($_POST['time_format'])){
					// echo "outside";exit;
					$this->Marks_model->update_extpract_subject_faculty($_POST);
					redirect(base_url($this->view_dir.'assign_prac_faculty'));
				}else{
					redirect(base_url($this->view_dir.'assign_prac_faculty'));
				}
			// }else{
			 	// echo 'Edit Should Done By COE Only';exit;
			// }
		}
	}
	function load_subject_coures(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["school_code"]) && !empty($_POST["school_code"])){
			$stream = $this->Marks_model->load_subject_coures($_POST["school_code"], $_POST["batch"]);
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
	
    public function practical_exam_reports($streamId='', $semester='', $course_id='', $school_id='', $batch='', $acd_year='')
    {
		if($this->session->userdata("role_id")==15){
		}else{
			redirect('home');
		}
		//error_reporting(E_ALL);
      $this->load->model('Exam_timetable_model');
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
		$this->data['exam_session']= $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
		$this->data['schools']= $this->Exam_timetable_model->getSchools();
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$this->data['exam_id'] =$exam_id;
		$this->data['sub_list']= $this->Marks_model->list_practsubjects($_POST, $exam_id);
		$this->data['bksub_list']= $this->Marks_model->list_backlogsubjects($_POST, $exam_id);
		
		for($i=0;$i< count($this->data['sub_list']); $i++){
			$subjectId = $this->data['sub_list'][$i]['sub_id'];
			$division = $this->data['sub_list'][$i]['division'];
			$batch_no = $this->data['sub_list'][$i]['batch_no'];
			$this->data['sub_list'][$i]['tt_details']= $this->Marks_model->get_subdetails($subjectId, $_POST['admission-branch'], $_POST['semester'],$exam_id, $division, $batch_no);
		}
		
		for($i=0;$i< count($this->data['bksub_list']); $i++){
			$subjectId = $this->data['bksub_list'][$i]['sub_id'];
			$division = 'A';
			$batch_no = '1';
			$this->data['bksub_list'][$i]['tt_details']= $this->Marks_model->get_subdetails($subjectId, $_POST['admission-branch'], $_POST['semester'],$exam_id, $division, $batch_no);
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
		$this->data['exam_session']= $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
		$this->data['schools']= $this->Exam_timetable_model->getSchools();
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
			$streamname= $this->Examination_model->getStreamShortName($_POST['admission-branch']);
		$this->data['stream_name'] = $streamname[0]['stream_name'];
		$this->data['semester'] = $_POST['semester'];
			$this->data['sub_list']= $this->Marks_model->list_practsubjects_pdf($_POST, $exam_id);
			$this->data['bksub_list']= $this->Marks_model->list_backlogsubjects_pdf($_POST, $exam_id);

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

		}elseif($report_type == 'Attendane'){
			//$this->data['sub_list']= $this->Marks_model->list_practsubjects_pdf($_POST, $exam_id);
			$sub_list= $this->Marks_model->list_practsubjects_pdf($_POST, $exam_id);
			$bksub_list= $this->Marks_model->list_backlogsubjects_pdf($_POST, $exam_id);
			
			$this->load->library('m_pdf');
			//$html = $this->load->view($this->view_dir.'pdf_practical_exam_attendance',$this->data, true);
			//$pdfFilePath1 ="practical_exam_reports.pdf";
			//$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			$mpdf=new mPDF();
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '30', '10', '10', '65', '35');
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
	   
			   $subdata =$this->Marks_model->fetch_sub_batch_details($sub['sub_id'],$sub['stream_id'],$sub['semester'],$sub['batch'],$sub['academic_year'],$sub['academic_session']);
			   $streamname= $this->Examination_model->getStreamShortName($sub['stream_id']);
				foreach($subdata as $bth){
					$timetl =$this->Marks_model->fetch_pract_timetable($sub['sub_id'],$sub['stream_id'],$sub['semester'],$bth['division'],$bth['batch_no']);
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
							<span style="font-size: 20px;"><b>COE</b></span>
						</td>
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
				$studstrength =$this->Marks_model->fetch_student_strength($sub['sub_id'],$sub['stream_id'],$sub['semester'],$bth['division'],$bth['batch_no'],$sub['academic_year']);
				
				$content .='<table border="0" cellspacing="5" cellpadding="5" width="100%" class="content-table" style="position: relative;">
				<tr>
				<th width="10%" height="30">Sr No.</th>
				<th width="15%" >PRN</th>
				<th width="50%" align="left">Name</th>
				<th width="25%">Candidate.Sign</th>
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
			   $streamname= $this->Examination_model->getStreamShortName($bksub['stream_id']);
				
					$timetl =$this->Marks_model->fetch_bklgpract_timetable($bksub['sub_id'],$bksub['stream_id'],$bksub['semester'],$division='A',$bth_no='1');
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
				$bkstudstrength =$this->Marks_model->fetch_bklgstudent_strength($bksub['sub_id'],$bksub['stream_id'],$bksub['semester'],$division='A',$bth_no='1');
				
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
		// redirect('home');
		if($this->session->userdata("role_id")==20 ||  $this->session->userdata("role_id")==63 || 
		$this->session->userdata("role_id")==6 ||  $this->session->userdata("role_id")== 21 ||  
		$this->session->userdata("role_id")==44 ||  $this->session->userdata("role_id")==13 || $this->session->userdata("role_id")==68){
		}else{
			redirect('home');
		}
		//error_reporting(E_ALL);exit();
		$this->load->model('Exam_timetable_model');
	   $empid = $this->session->userdata("role_id");

        $this->load->view('header',$this->data);        
        $examsession = $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
        $exam_id= $examsession[0]['exam_id'];	

		$this->data['exam'] =$examsession[0]['exam_month'].'-'.$examsession[0]['exam_year'].'-'.$examsession[0]['exam_id'];
		if($empid !="15"){	
			//echo 'Last date of marks enry is over.';exit;
			$this->data['sub_list']= $this->Marks_model->list_facultywise_pract_exam_subjects($exam_id);
			
			for($i=0;$i< count($this->data['sub_list']); $i++){
				$subjectId = $this->data['sub_list'][$i]['sub_id'];
				$stream = $this->data['sub_list'][$i]['stream_id'];
				$semester = $this->data['sub_list'][$i]['semester'];
				$is_backlog = $this->data['sub_list'][$i]['is_backlog'];
				$batch_no = $this->data['sub_list'][$i]['batch_no'];
				$division = $this->data['sub_list'][$i]['division'];
				//$this->data['sub_list'][$i]['mrk']= $this->Marks_model->getPractMarksEntry($subjectId, $exam_id,$stream, $semester,$is_backlog);
				$this->data['sub_list'][$i]['mrk']= $this->Marks_model->getPractMarksEntry1($subjectId, $exam_id,$stream, $semester,$is_backlog,$division, $batch_no);
			}
		}else{
		
			$this->data['sub_list']= $this->Marks_model->list_coewise_pract_exam_subjects($exam_id);
			$this->data['batch_no'] = '1';
			$this->data['division'] = 'A';
			for($i=0;$i< count($this->data['sub_list']); $i++){
				$subjectId = $this->data['sub_list'][$i]['sub_id'];
				$stream = $this->data['sub_list'][$i]['stream_id'];
				$semester = $this->data['sub_list'][$i]['semester'];
				/*$is_backlog = $this->data['sub_list'][$i]['is_backlog'];
				$batch_no = $this->data['sub_list'][$i]['batch_no'];
				$division = $this->data['sub_list'][$i]['division'];
				//$this->data['sub_list'][$i]['mrk']= $this->Marks_model->getPractMarksEntry($subjectId, $exam_id,$stream, $semester,$is_backlog);*/
				$this->data['sub_list'][$i]['mrk']= $this->Marks_model->coe_getPractMarksEntry1($subjectId, $exam_id,$stream, $semester,$is_backlog,$division, $batch_no);
			}
		}
		$this->load->view($this->view_dir.'add_pract_marks',$this->data);
			
		$this->load->view('footer');    
		
	} 
	
	
	
	public function pract_marksdetails($testId)
    {
		//error_reporting(E_ALL);
		$testId = base64_decode($testId);
		$this->load->model('Exam_timetable_model');
		$roleid = $this->session->userdata("role_id");
		//echo $subdetails =$this->uri->segment(4);
		$this->load->model('Attendance_model');
		$curr_session= $this->Attendance_model->getCurrentSession();
		//exit;
		$this->data['sub_details'] = $testId;
		$subdetails =explode('~',$testId);
		// print_r($subdetails);exit;
		$sub_id  =$subdetails[0];
		$this->data['stream'] =$subdetails[3];
		$this->data['semester'] =$subdetails[4];
		$this->data['examsession'] =$subdetails[5];
		$this->data['exam_type'] =$subdetails[6];
		$this->data['division'] =$subdetails[7];
		$this->data['batch_no'] =$subdetails[8];
		$this->data['is_backlog'] =$subdetails[10];
		$this->data['course_id'] =$subdetails[12];
		$stream_id = $subdetails[3];
		//echo $subdetails[8];
		$exam = $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
		$this->data['exam'] =$exam[0]['exam_month'].'-'.$exam[0]['exam_year'].'-'.$exam[0]['exam_id'];

		if($subdetails[10]=='N'){
			// echo "outside";exit;
			if($roleid !='15'){
			$this->data['allbatchStudent'] = $this->Marks_model->getSubAppStudentList($sub_id,$stream_id, $subdetails[4],$subdetails[7], $subdetails[8],$exam[0]['exam_id'],$curr_session[0]['academic_year']);
			}else{
				$this->data['allbatchStudent'] = $this->Marks_model->coe_getSubAppStudentList($sub_id,$stream_id, $subdetails[4],$subdetails[7], $subdetails[8],$exam[0]['exam_id']);
			}
		}else{
			// echo "inside";exit;
			$this->data['allbatchStudent'] = $this->Marks_model->getbacklogSubjectStudts($sub_id,$stream_id, $subdetails[4],$exam[0]['exam_id']);
		}
		$this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);
		//echo "<pre>";
		//print_r($this->data['allbatchStudent']);exit;
        $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'add_markdetails',$this->data);
        $this->load->view('footer');
    }  
	
//
	public function downloadStudlistpdf($testId='', $me_id='')
    {
		
		$testId = base64_decode($testId);
		$this->load->model('Exam_timetable_model');
		$roleid = $this->session->userdata("role_id");
		$this->data['sub_details'] = $testId;
		$subdetails =explode('~',$testId);
		// echo '<pre>';print_r($subdetails);exit;
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
		$this->data['course_id'] =$subdetails[12];
		//$exam =explode('-',$subdetails[5]);
		$this->load->model('Attendance_model');
		$curr_session= $this->Attendance_model->getCurrentSession();		
		$exam_sess = $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
		// print_r($exam_sess[0]['exam_id']);exit;
		$this->data['exam']  =$exam_sess[0]['exam_month'].'-'.$exam_sess[0]['exam_year'];
		// $this->data['exam'] =$exam[0]['exam_month'].'-'.$exam[0]['exam_year'].'-'.$exam[0]['exam_id'];
        $DB1 = $this->load->database('umsdb', TRUE);

        $sql = "SELECT eefm.ext_fac_name,CONCAT(em.fname, ' ', em.mname, ' ', em.lname) AS full_name 
		FROM exam_practical_subjects_faculty_assign  efa
		LEFT JOIN sandipun_erp.employee_master em on em.emp_id = efa.faculty_code
        LEFT JOIN exam_external_faculty_master  eefm on eefm.ext_faculty_code = efa.ext_faculty_code
        WHERE efa.semester  = '".$subdetails[4]."' and efa.exam_id  ='".$exam_sess[0]['exam_id']."' 
			  and efa.stream_id  = '".$stream_id."' and efa.division  = '".$subdetails[7]."' and efa.batch_no = '".$subdetails[8]."'
			  and efa.subject_id  = '".$sub_id."' and efa.subject_type  = '".$subdetails[6]."' and efa.is_active = 'Y'";
        $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
        $this->data["faculty"] = $query->row();
		
		if($subdetails[10]=='N'){

			if($roleid !='15'){
				
			$this->data['allbatchStudent'] = $this->Marks_model->getSubAppStudentList($sub_id,$stream_id, $subdetails[4],$subdetails[7], $subdetails[8],$exam_sess[0]['exam_id'],$curr_session[0]['academic_year']);
			
			}else{
				
				$this->data['allbatchStudent'] = $this->Marks_model->coe_getSubAppStudentList($sub_id,$stream_id, $subdetails[4],$subdetails[7], $subdetails[8],$exam_sess[0]['exam_id']);
			
			}
			
		}else{
			
			
			$this->data['allbatchStudent'] = $this->Marks_model->getbacklogSubjectStudts($sub_id,$stream_id, $subdetails[4],$exam_sess[0]['exam_id']);
		}
		$exam_id = $exam_sess[0]['exam_id'];
		$this->data['streamId'] = $subdetails[3];
		$this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);
	
	
	
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
			<td style="text-align: left; height: 40px; width: 50%" class="signature">
				<strong>Internal Examiner:</strong> 
				<span style="font-weight: normal;"> ' . $this->data["faculty"]->full_name . ' </span>
			</td>
			<td style="text-align: left; height: 40px; width: 50%;" class="signature">
				<strong>External Examiner:</strong>
				<span style="font-weight: normal;"> ' . $this->data["faculty"]->ext_fac_name . ' </span>
			</td>
		  </tr>
		  
		  <tr>
		    <td align="left" height="40" class="signature" style="text-align:left"><strong>Signature:</strong></td>
		    <td align="left" height="40" class="signature" style="text-align:left"><strong>Signature:</strong></td>
			<td align="center" height="40" class="signature"><strong></strong></td>
			<td align="center" height="40" class="signature"><strong></strong></td>
		  </tr>
		  <tr>
		    <td align="right" colspan="3" class="signature"><small><i>Printed on: ' . $dattime . '</i></small></td>
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
		//print_r($subdetails);exit;
		$sub_id  =$subdetails[0];
		
		$semester =$subdetails[4];
		$this->data['examsession'] =$subdetails[5];
		
		$division =$subdetails[7];
		$batch_no =$subdetails[8];
		if($batch_no==0){
			//$batch_no=1;
		}
		$is_backlog =$subdetails[10];
		$this->data['exam_date'] =$subdetails[11];
		$stream_id = $subdetails[3];
		
		$exam  =$subdetails[5];
		$examses =explode('-',$exam);
		$exam_id = $examses[2];
		$this->data['exam']  =$examses[0].'-'.$examses[1];
		$this->data['streamId'] = $subdetails[3];
		$this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);
		$this->data['me']=$this->Marks_model->fetch_me_details($me_id);
		$roleid = $this->session->userdata("role_id");
		if($roleid !='15'){		
			$this->data['mrks']=$this->Marks_model->get_pract_marks_details($me_id,$stream_id,$semester,$division,$batch_no, $exam_id);
		}else{
			$this->data['mrks']=$this->Marks_model->get_pract_marks_details($sub_id,$stream_id,$semester,$division,$batch_no, $exam_id);
		}		
		
		$DB1 = $this->load->database('umsdb', TRUE);

        $sql = "SELECT eefm.ext_fac_name,CONCAT(em.fname, ' ', em.mname, ' ', em.lname) AS full_name 
		FROM exam_practical_subjects_faculty_assign  efa
		LEFT JOIN sandipun_erp.employee_master em on em.emp_id = efa.faculty_code
        LEFT JOIN exam_external_faculty_master  eefm on eefm.ext_faculty_code = efa.ext_faculty_code
        WHERE efa.semester  = '".$subdetails[4]."' and efa.exam_id  ='".$examses[2]."' 
			  and efa.stream_id  = '".$stream_id."' and efa.division  = '".$subdetails[7]."' and efa.batch_no = '".$subdetails[8]."'
			  and efa.subject_id  = '".$sub_id."' and efa.subject_type  = '".$subdetails[6]."' and efa.is_active = 'Y'";
        $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
        $this->data["faculty"] = $query->row();
		
		// echo "<pre>";		
		// print_r($this->data['mrks']);exit;
	
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
			<td style="text-align: left; height: 40px; width: 50%" class="signature">
				<strong>Internal Examiner:</strong> 
				<span style="font-weight: normal;"> ' . $this->data["faculty"]->full_name . ' </span>
			</td>
			<td style="text-align: left; height: 40px; width: 50%;" class="signature">
				<strong>External Examiner:</strong>
				<span style="font-weight: normal;"> ' . $this->data["faculty"]->ext_fac_name . ' </span>
			</td>
		  </tr>
		  
		  <tr>
		    <td align="left" height="40" class="signature" style="text-align:left"><strong>Signature:</strong></td>
		    <td align="left" height="40" class="signature" style="text-align:left"><strong>Signature:</strong></td>
		   
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
			//$this->data['sub_list']= $this->Marks_model->list_practsubjects_pdf($_POST, $exam_id);
			$sub_list= $this->Marks_model->test_list_practsubjects_pdf();
			//$bksub_list= $this->Marks_model->test_list_backlogsubjects_pdf($_POST, $exam_id);
			
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
	   
			   $streamname= $this->Examination_model->getStreamShortName($sub['stream_id']);
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
				$studstrength =$this->Marks_model->testfetch_student_strength($sub['sub_id'],$sub['stream_id'],$sub['semester']);
				
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
    public function pract_marks_entry_status($streamId='', $semester='', $course_id='', $school_id='', $batch='', $acd_year='')
    {
		if($this->session->userdata("role_id")==15){
		}else{
			redirect('home');
		}
		//error_reporting(E_ALL);
      $this->load->model('Exam_timetable_model');
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
		$this->data['exam_session']= $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
		$this->data['schools']= $this->Exam_timetable_model->getSchools();
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$this->data['exam_id'] =$exam_id;
		$this->data['sub_list']= $this->Marks_model->fetch_pract_marks_entry_status($_POST, $exam_id);
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
		$this->data['exam_session']= $this->Exam_timetable_model->fetch_exam_session_for_marks_entry();
		$this->data['schools']= $this->Exam_timetable_model->getSchools();
        $this->load->view($this->view_dir.'pract_marks_entry_status',$this->data);
        $this->load->view('footer');
      
      }   
    }
	function load_prmrentrycourses(){
		//echo $_POST["course_id"];exit;
		if($_POST["school_code"] !=0 && !empty($_POST["school_code"])){
			$stream = $this->Marks_model->load_prmrentrycourses($_POST["school_code"], $_POST["batch"]);
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
            $stream = $this->Marks_model->load_prmrentrystreams($_POST);
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
            $stream = $this->Marks_model->load_prmrentrysemester($_POST);
            
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
		$exam_id='38';
		$exam_month='AUG';
		$exam_year='2024';
    	$liststud = $this->Marks_model->get_failed_studentlist($exam_id,$exam_month,$exam_year);
		//print_r($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
			$chkstud = $this->Marks_model->check_marks_entered_cia($stud,$exam_id);
			//print_r($chkstud);
			if(empty($chkstud)){
    		$stud = $this->Marks_model->get_failedstudciamarks($stud,$exam_id,$exam_month,$exam_year);
			$i++;
			}
			//exit;
    	}
    	echo  $i."records Successfully Updated";
    }
	//cia marks of failed students
    function update_marks_masterforcia_supplimentry(){
    	exit;
		$exam_id='38';
		$exam_month='AUG';
		$exam_year='2024';
    	$liststud = $this->Marks_model->get_examappliedsubjects($exam_id,$exam_month,$exam_year);
		//print_r($liststud);
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Marks_model->update_marks_master_cia($stud,$exam_id,$exam_month,$exam_year);
			$i++;
    	}
    	echo  $i."records Successfully Updated";
    }
	
	//Practical marks of failed students
    function update_marks_masterforpractical_supplimentry(){
    	//exit;
		$exam_id='38';
		$exam_month='AUG';
		$exam_year='2024';
    	$liststud = $this->Marks_model->get_examappliedPrsubjects($exam_id);
		//print_r($liststud);
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Marks_model->updateBklogEMPRMaster($stud,$exam_id,$exam_month,$exam_year);
			$i++;
			
    	}
    	echo  $i."records Successfully Updated";
    }	
	//Practical marks of failed students for supplimentry  exam
    function update_marks_enryforpractical_supplimentry(){
		exit;
    	$exam_id='38';
		$exam_month='AUG';
		$exam_year='2024';
    	$liststud = $this->Marks_model->get_examappliedPrsubjects($exam_id);
		//print_r($liststud);
		$i=1;
    	foreach($liststud as $stud){
			
			$chkstud = $this->Marks_model->check_marks_entered_practical($stud,$exam_id);
			//print_r($chkstud);
			if(empty($chkstud)){
				$stud = $this->Marks_model->update_marks_master_practical($stud,$exam_id,$exam_month,$exam_year);
				$i++;
				//echo 'inside'; exit;
			}
			
			
    	}
    	echo  $i."records Successfully Updated";
    }	
	////////////////////////////////////////////////////////////////////////////////////
    function update_stream_marks_entry(){
    	
    	$liststud = $this->Marks_model->get_mrkstudent_list();
		//print_r($liststud);
    	foreach($liststud as $stud){
    		$stud = $this->Marks_model->update_mrkstream($stud);
    	}
    	echo  "Successfully Updated";
    }
/*
*script for updation backlog students stream dated 
*13-02-2019 by bala	
*/
	function update_bklog_stream(){
    	
    	$liststud = $this->Marks_model->get_bklog_streamstud_list();
		//print_r($liststud);
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Marks_model->update_bklog_streamstud($stud);
			$i++;
    	}
    	echo  $i."_exam applied records updated Successfully";
    }
	// theory marks
	function update_bklog_stream_marksentry(){
    	
    	$liststud = $this->Marks_model->get_bklog_streamstud_list_marksentry();
		//print_r($liststud);
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Marks_model->update_bklog_streamstud_marksentry($stud);
			$i++;
    	}
    	echo  $i."_Theory records updated Successfully";
    }
		function update_bklog_stream_cia_marks(){
    	
    	$liststud = $this->Marks_model->get_bklog_streamstud_list_cia_marks();
		//print_r($liststud);
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Marks_model->update_bklog_streamstud_cia_marks($stud);
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
    	
    	$liststud = $this->Marks_model->get_insertttdprm_list();
		//print_r($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Marks_model->update_insertttdprm($stud);
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
    	$exam_id='16';
    	$liststud = $this->Marks_model->get_attendancegrade($exam_id);
		//print_r($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Marks_model->update_attendancegrade($stud,$exam_id);
			$i++;
    	}
    	echo  $i."_updated Successfully";
    }
	/*
	*end
	*/
		function script_for_topper30123(){
    	
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
			$division = $this->Marks_model->fetch_stream_division_list($strm);
			foreach($division as $vr){
				//print_r($vr);exit;
				$stud_data = $this->Marks_model->fetch_streamwisetopper_list($vr);
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


function script_for_topper(){
    	
    	//$list_streams = array('5','6','8','10','107','13','15','16','19','20','21','98','121','23','24','26','29','22','113','31','32','33','34','120','35','36','124','7','11','96','97','109','12','17','38','39','40','42','37','43','44','45','46','47','117','48','49','50','51','105','106','118','66','67','68','69','71','116','119');

    	$list_streams = $this->Marks_model->fetch_ist_streams(); 
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
	     // print_r($strm['stream_id']);exit;
			$division = $this->Marks_model->fetch_stream_division_list($strm['stream_id']);
			foreach($division as $vr){
				//print_r($vr);exit;
				$stud_data = $this->Marks_model->fetch_streamwisetopper_list($vr);
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
				<th>Exam</th>
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
						<td>'.$std['exam_month'].' '.$std['exam_year'].'</td>
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
    	$list_streams = $this->Marks_model->fetch_studexam_list(11);
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
					$stud_data = $this->Marks_model->fetch_streamwisepass_list($strm);
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
    	
    	$liststud = $this->Marks_model->get_visfaculty_list();
		//print_r($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Marks_model->update_visitingfaculty($stud);
			$i++;
    	}
    	echo  $i."_updated Successfully";
    }
	
/*************************** script for mapping backlog Cia marks Start*************************************/
//for regular exam 
    function updateBklogCiamarks(){
		exit;
    	$exam_id='41';
		$exam_month='MAY';
		$exam_year='2024';
    	$liststud = $this->Marks_model->get_backlog_studentsubjects($exam_id);
		//echo count($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
			$chkstud_cia = $this->Marks_model->check_marks_entered_cia($stud,$exam_id);
			//print_r($chkstud);
			if(empty($chkstud_cia)){
    		$stud = $this->Marks_model->updateBklogCiamarks($stud,$exam_id,$exam_month,$exam_year);
			$i++;
			}
    	}
    	echo  $i."records Successfully Updated";
    }
	function updateBklogCiaMaster(){
		exit;
    	$exam_id='41';
		$exam_month='MAY';
		$exam_year='2024';
    	$liststud = $this->Marks_model->get_backlog_masterCiasubjects($exam_id);
		//echo count($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
			$chkstud_ciam = $this->Marks_model->check_marks_entered_ciam($stud,$exam_id);
			//print_r($chkstud);
			if(empty($chkstud_ciam)){
    		$stud = $this->Marks_model->updateBklogCiaMaster($stud,$exam_id,$exam_month,$exam_year);
			$i++;
			}
    	}
    	echo  $i."records Successfully Updated";
    }
/*************************** script for mapping backlog Cia marks END*************************************/

/*************************** script for mapping backlog EMPR marks Start*************************************/
    function updateBklogEMPRmarks(){
		 exit;
    	$exam_id='41';
		$exam_month='MAY';
		$exam_year='2025';
    	$liststud = $this->Marks_model->get_backlog_EMPR_studentsubjects($exam_id);
		//echo count($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
			$chkstud_EMPR = $this->Marks_model->check_marks_entered_EMPR($stud,$exam_id);
			//print_r($chkstud);
			if(empty($chkstud_EMPR)){
				$stud = $this->Marks_model->updateBklog_EMPR_marks($stud,$exam_id,$exam_month,$exam_year);
				$i++;
			}
			unset($chkstud_EMPR);
    	}
    	echo  $i."records Successfully Updated";
    }
	function updateBklogEMTHmarks(){
		exit;
    	$exam_id='41';
		$exam_month='MAY';
		$exam_year='2024';
    	$liststud = $this->Marks_model->get_backlog_EMPR_studentsubjects($exam_id);
		//echo count($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
			$chkstud_EMPR = $this->Marks_model->check_marks_entered_EMTH($stud,$exam_id);
			//print_r($chkstud);
			if(empty($chkstud_EMPR)){
				$stud = $this->Marks_model->updateBklog_EMTH_marks($stud,$exam_id,$exam_month,$exam_year);
				$i++;
			}
			unset($chkstud_EMPR);
    	}
    	echo  $i."records Successfully Updated";
    }
	function updateBklogEMPRMaster(){
		 exit;
    	$exam_id='41';
		$exam_month='MAY';
		$exam_year='2024';
    	$liststud = $this->Marks_model->get_backlog_masterEMPRsubjects($exam_id);
		//echo count($liststud);exit;
		$i=1;
    	foreach($liststud as $stud){
    		$stud = $this->Marks_model->updateBklogEMPRMaster($stud,$exam_id,$exam_month,$exam_year);
			$i++;
    	}
    	echo  $i."records Successfully Updated";
    }
/*************************** script for mapping backlog EMPR marks END*************************************/

	function updatearrears(){
    	/*$exam_id='13';
		$exam_month='DEC';
		$exam_year='2019';
		//error_reporting(E_ALL);
    	$liststud = $this->Marks_model->updatearrears($exam_id);
		//echo "<pre>";print_r($liststud);//exit;
		$i=2;
    	foreach($liststud as $stud){
			//echo $stud['final_grade'];exit;
    		$stud = $this->Marks_model->updatearrearstest($stud['final_grade'],$stud['student_id'],$stud['subject_id']);
			$i++;
    	}
    	echo  $i."records Successfully Updated";*/
    }
	
		//function for marks entry 
    function insert_marks_masterforcia_june20(){
    	//error_reporting(E_ALL);//exit;
		$exam_id=15;
    	$liststud = $this->Marks_model->get_examappliedsubjectsjune20();
		//print_r($liststud);
		$i=1;
    	foreach($liststud as $stud){
			$chkstud = $this->Marks_model->check_marks_entered_theory($stud,$exam_id);
			//print_r($chkstud);
			if(empty($chkstud)){
				$stud = $this->Marks_model->insert_marks_master_cia_june20($stud);
				$i++;
				//echo 'inside'; exit;
			}
    	}
    	echo  $i."records Successfully Updated";
    }
	// function for master marks update
	function insert_marks_master_june20(){
    	//exit;
		$exam_id=15;
    	$liststud = $this->Marks_model->get_examappliedsubjects_masterjune20();
		//print_r($liststud);
		$i=1;
    	foreach($liststud as $stud){
			$chkstud = $this->Marks_model->check_marks_entered_theory_master($stud,$exam_id);
			//print_r($chkstud);
			if(empty($chkstud)){
				$stud = $this->Marks_model->insert_marks_master_june20($stud);
				$i++;
				//echo 'inside'; exit;
			}
    	}
    	echo  $i."records Successfully Updated";
    }
		//update cia marks
	public function updateStudSubjectCiaMarks()
    {       
        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$cia_marks = $_POST['cia_marks'];
		$subdetails =explode('~',$_POST['result_id']);
		////echo "<pre>";
		//print_r($subdetails); 
		if(empty($subdetails[1])){
			$cia_id = $subdetails[0];
			//$cia_id = $_POST['result_id'];	
			//echo "<pre>";
			//print_r($marks);  
			/// maintaing log
			$stud_ciamrks = $this->Marks_model->get_studCIAmarks($cia_id, $m_id='');
			if($stud_ciamrks != $cia_marks){
				$sql ="INSERT INTO marks_entry_cia_log (`cia_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `cia_marks`,`attendance_marks`, `exam_id`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted`)
				SELECT `cia_id`, `me_id`, `stud_id`, `enrollment_no`, `stream_id`, `specialization_id`, `semester`, `subject_id`, `subject_code`, `cia_marks`,`attendance_marks`, `exam_id`, `exam_month`, `exam_year`, `entry_ip`, `entry_by`, `entry_on`, `modified_ip`, `modified_by`, `modified_on`, `is_deleted` FROM marks_entry_cia where cia_id='$cia_id'";
				$query = $DB1->query($sql);
			}
			//end log
			$spk['cia_marks'] = $cia_marks;
			$spk['modified_by'] = $this->session->userdata("uid");
			$spk['modified_on'] = date('Y-m-d H:i:s');
			$DB1->where('cia_id', $cia_id);
			$DB1->update('marks_entry_cia', $spk);
			
			$sql_update_th="SELECT * FROM marks_entry_cia WHERE cia_id='$cia_id'";//exit;
			$query1 = $DB1->query($sql_update_th);
			$res= $query1->result_array();
			
			$th_mrks['marks'] = $cia_marks *2;
			$DB1->where('marks_type', 'TH');
			$DB1->where('exam_id', $res[0]['exam_id']);
			$DB1->where('stud_id', $res[0]['stud_id']);
			$DB1->where('subject_id', $res[0]['subject_id']);
			$DB1->update('marks_entry', $th_mrks);
			//echo $DB1->last_query();exit;
			unset($cia_id);
			unset($sql);
			unset($cia_id);
		}else{
			//echo 'inside';//exit;
			$c_data['subject_id'] = $subdetails[0];
			$c_data['stud_id'] = $subdetails[1];
			$c_data['enrollment_no'] = $subdetails[2];			
			$c_data['stream_id'] = $subdetails[3];
			$c_data['semester'] = $subdetails[4];
			$c_data['exam_month'] = $subdetails[5];
			$c_data['exam_year'] = $subdetails[6];
			$c_data['exam_id'] = $subdetails[7];
			$c_data['cia_marks'] = $cia_marks;
			$c_data['entry_by'] = $this->session->userdata("uid");
			$c_data['entry_on'] = date('Y-m-d H:i:s');
			//echo "<pre>";
			//print_r($c_data);exit;
			$DB1->insert('marks_entry_cia', $c_data);
			unset($c_data);
			$m_data['subject_id'] = $subdetails[0];
			$m_data['stud_id'] = $subdetails[1];
			$m_data['enrollment_no'] = $subdetails[2];			
			$m_data['stream_id'] = $subdetails[3];
			$m_data['semester'] = $subdetails[4];
			$m_data['exam_month'] = $subdetails[5];
			$m_data['exam_year'] = $subdetails[6];
			$m_data['exam_id'] = $subdetails[7];
			$m_data['marks_type'] = 'TH';
			$m_data['marks'] = $cia_marks *2;
			$m_data['entry_by'] = $this->session->userdata("uid");
			$m_data['entry_on'] = date('Y-m-d H:i:s');
			$DB1->insert('marks_entry', $m_data);
			//echo $DB1->last_query();exit;
			unset($m_data);
			unset($_POST['result_id']);
			//unset($cia_id);
		} 
		echo "SUCCESS";
		//echo $DB1->last_query();exit;
	} 
function upload_excel_for_marks_entry(){
	exit;
     $this->load->library('Excel');
	 $this->load->model('Exam_timetable_model');
	 $DB1 = $this->load->database('umsdb', TRUE);
	  $examsession = $this->Exam_timetable_model->fetch_curr_exam_session();
	  $this->data['ex']=$examsession;
      $ex_id= $examsession[0]['exam_id'];
  if($_POST){
//print_r($_FILES);exit;

    $gen_arr=array('F','M');
  $path = $_FILES["file"]["tmp_name"];
    $object = PHPExcel_IOFactory::load($path);
  // echo "vighnesh";
   foreach($object->getWorksheetIterator() as $worksheet)
   {   
  // echo "vighnesh";
   $highestRow = $worksheet->getHighestRow();
   $highestColumn = $worksheet->getHighestColumn();
  
    for($row=2; $row<=$highestRow; $row++){
        $data=array();
	   $subject_code=($worksheet->getCellByColumnAndRow(0, $row)->getValue());
	   $prn=($worksheet->getCellByColumnAndRow(3, $row)->getValue());
	   $obt_marks=($worksheet->getCellByColumnAndRow(5, $row)->getValue());
	   $total_marks =2*($worksheet->getCellByColumnAndRow(6, $row)->getValue());
	   
	   $eas = $this->Marks_model->get_studsubjectdetails($subject_code, $prn,$ex_id);
	   if(!empty($eas)){
	   $data['stud_id']=$eas[0]['stud_id'];
	   $data['enrollment_no']=$eas[0]['enrollment_no'];
	   $data['exam_id']=$eas[0]['exam_id'];
	   $data['stream_id']=$eas[0]['stream_id'];
	   $data['semester']=$eas[0]['semester'];
	   $data['subject_id']=$eas[0]['subject_id'];
	   $data['subject_code']=$eas[0]['subject_code'];
	   $data['marks_type']='TH';
	   if($eas[0]['stream_id']==71){
		   if($obt_marks !='AB'){
			$obtmrks = round(($obt_marks /50)*80);
		   }else{
			 $obtmrks = $obt_marks;
		   }
			$data['marks']=$obtmrks;
		$total_marks=80;
	   }if($eas[0]['stream_id']==116){
		 if($obt_marks !='AB'){  
			$obtmrks = round(($obt_marks /50)*75);
		 }else{
			 $obtmrks = $obt_marks;
		   }
		$data['marks']=$obtmrks;
		$total_marks=75;
	   }else{
		if($obt_marks !='AB'){  
			$data['marks']=2*$obt_marks;
		}else{
			$data['marks'] = $obt_marks;
		   }
	   }
	   $data['exam_month']=$eas[0]['exam_month'];
	   $data['exam_year']=$eas[0]['exam_year'];
	   $data['entry_ip']=$this->input->ip_address();
	   $data['entry_by']=$this->session->userdata("uid");
	   $data['entry_on']=date('Y-m-d h:i:s');
	   
	   //echo '<pre>';print_r($data);exit;
	   
	   $chkstud = $this->Marks_model->check_marks_entered_theory_master($eas[0]['subject_id'],$eas[0]['exam_id']);
	   //print_r($chkstud);
	   if(empty($chkstud)){
			$insert_master_array=array(
				"stream_id"=>$eas[0]['stream_id'],
				"semester"=>$eas[0]['semester'],
				"subject_id"=>$eas[0]['subject_id'],
				"exam_month"=>$eas[0]['exam_month'],
				"exam_year"=>$eas[0]['exam_year'],
				"exam_id"=>$eas[0]['exam_id'],
				"marks_entry_date" => date('Y-m-d'),
				"marks_type" => 'TH',	
				"max_marks" => $total_marks,
				"entry_by" => $this->session->userdata("uid"),
				"entry_on" => date("Y-m-d H:i:s"),
				"entry_status" => 'Entered'
				); 
			$DB1->insert("marks_entry_master", $insert_master_array); 
			//echo $DB1->last_query();exit;
			$last_inserted_id_master =$DB1->insert_id();
	   }else{
		   $last_inserted_id_master=$chkstud[0]['me_id'];
	   }

	/*echo "<pre>";
	print_r($data);
exit;*/
			$chkstud1 = $this->Marks_model->check_marks_entered_theory_1($eas[0]['subject_id'],$eas[0]['exam_id'],$eas[0]['enrollment_no']);
			print_r($chkstud1);//exit;
			if(empty($chkstud1)){
				echo 'inside';//exit;
				$data['me_id']=$last_inserted_id_master;
				$jhj = $this->Marks_model->upload_exceldata_for_marks_entry($data); 
			}
		}
	}
	//exit;
	//print_r($data);
}
echo "Successfully uploaded";
  

}

	$this->load->view('header',$this->data); 
	$this->load->view($this->view_dir . 'student_data_import_excel_bala', $this->data);
	$this->load->view('footer');

	 }
	 
	function deletemrksentrytheory($me_id){
    	$exam_id='17';
    	$liststud = $this->Marks_model->deletmrksentrytheory($exam_id,$me_id);
		redirect(base_url($this->view_dir.'entry_status'));
    }	 
	//subject allocation Manually
	function subject_allocation_manually(){
    	//exit;
    	$liststud = $this->Marks_model->subject_allocation_manually_student_list();
		//print_r($liststud);exit;
		$i=0;
		$subject_id='1640';
    	foreach($liststud as $stud){
			$chkstud = $this->Marks_model->check_duplicate_subject_allocation($stud,$subject_id);
			//print_r($chkstud);exit;
			if(empty($chkstud)){
				$stud = $this->Marks_model->insert_subject_allocation_manually($stud,$subject_id);
				$i++;
				//echo 'inside'; exit;
			}
    	}
    	echo  $i."records Successfully Updated";
    }
	function upload_excel_for_marks_entry_practical(){

     $this->load->library('Excel');
	 $this->load->model('Exam_timetable_model');
	 $DB1 = $this->load->database('umsdb', TRUE);
	  $examsession = $this->Exam_timetable_model->fetch_curr_exam_session();
	  $this->data['ex']=$examsession;
      $ex_id= $examsession[0]['exam_id'];
  if($_POST){
//print_r($_FILES);exit;

    $gen_arr=array('F','M');
  $path = $_FILES["file"]["tmp_name"];
    $object = PHPExcel_IOFactory::load($path);
  // echo "vighnesh";
   foreach($object->getWorksheetIterator() as $worksheet)
   {   
  // echo "vighnesh";
   $highestRow = $worksheet->getHighestRow();
   $highestColumn = $worksheet->getHighestColumn();
  
    for($row=2; $row<=$highestRow; $row++){
        $data=array();
	   $subject_code=($worksheet->getCellByColumnAndRow(0, $row)->getValue());
	   $prn=($worksheet->getCellByColumnAndRow(3, $row)->getValue());
	   $obt_marks=($worksheet->getCellByColumnAndRow(5, $row)->getValue());
	   $total_marks =$worksheet->getCellByColumnAndRow(6, $row)->getValue();
	   
	   $eas = $this->Marks_model->get_studsubjectdetails($subject_code, $prn,$ex_id);
	   if(!empty($eas)){
	   $data['stud_id']=$eas[0]['stud_id'];
	   $data['enrollment_no']=$eas[0]['enrollment_no'];
	   $data['exam_id']=$eas[0]['exam_id'];
	   $data['stream_id']=$eas[0]['stream_id'];
	   $data['semester']=$eas[0]['semester'];
	   $data['subject_id']=$eas[0]['subject_id'];
	   $data['subject_code']=$eas[0]['subject_code'];
	   $data['marks_type']='PR';
	   if($eas[0]['stream_id']==71){
		   if($obt_marks !='AB'){
			$obtmrks = round($obt_marks);
		   }else{
			 $obtmrks = $obt_marks;
		   }
			$data['marks']=$obtmrks;
		$total_marks=80;
	   }if($eas[0]['stream_id']==116){
		 if($obt_marks !='AB'){  
			$obtmrks = round(($obt_marks /50)*75);
		 }else{
			 $obtmrks = $obt_marks;
		   }
		$data['marks']=$obtmrks;
		$total_marks=75;
	   }else{
		if($obt_marks !='AB'){  
			$data['marks']=2*$obt_marks;
		}else{
			$data['marks'] = $obt_marks;
		   }
	   }
	   $data['exam_month']=$eas[0]['exam_month'];
	   $data['exam_year']=$eas[0]['exam_year'];
	   $data['entry_ip']=$this->input->ip_address();
	   $data['entry_by']=$this->session->userdata("uid");
	   $data['entry_on']=date('Y-m-d h:i:s');
	   
	   //echo '<pre>';print_r($data);exit;
	   
	   $chkstud = $this->Marks_model->check_marks_entered_practical_master($eas[0]['subject_id'],$eas[0]['exam_id']);
	   //print_r($chkstud);
	   if(empty($chkstud)){
			$insert_master_array=array(
				"stream_id"=>$eas[0]['stream_id'],
				"semester"=>$eas[0]['semester'],
				"subject_id"=>$eas[0]['subject_id'],
				"exam_month"=>$eas[0]['exam_month'],
				"exam_year"=>$eas[0]['exam_year'],
				"exam_id"=>$eas[0]['exam_id'],
				"marks_entry_date" => date('Y-m-d'),
				"marks_type" => 'PR',	
				"max_marks" => $total_marks,
				"entry_by" => $this->session->userdata("uid"),
				"entry_on" => date("Y-m-d H:i:s"),
				"entry_status" => 'Entered'
				); 
			$DB1->insert("marks_entry_master", $insert_master_array); 
			//echo $DB1->last_query();exit;
			$last_inserted_id_master =$DB1->insert_id();
	   }else{
		   $last_inserted_id_master=$chkstud[0]['me_id'];
	   }

	/*echo "<pre>";
	print_r($data);
exit;*/
			$chkstud1 = $this->Marks_model->check_marks_entered_pract_1($eas[0]['subject_id'],$eas[0]['exam_id'],$eas[0]['enrollment_no']);
			//print_r($chkstud1);//exit;
			if(empty($chkstud1)){
				//echo 'inside';//exit;
				$data['me_id']=$last_inserted_id_master;
				$jhj = $this->Marks_model->upload_exceldata_for_marks_entry($data); 
			}
		}
	}
	//exit;
	//print_r($data);
}
echo "Successfully uploaded";
  

}

	$this->load->view('header',$this->data); 
	$this->load->view($this->view_dir . 'student_data_import_excel_bala', $this->data);
	$this->load->view('footer');

	 }
	 //////////////////Exam attendance grade updation//////////////////////////////////
	 public function exam_attendacne_grade_entry()
	{
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==64){
		}else{
			redirect('home');
		}
	    //error_reporting(E_ALL); ini_set('display_errors', 1);
	    $this->load->model('Exam_timetable_model');
	    $grade_letters= $this->Marks_model->list_grade_letter();
		$this->data['regulatn']= $this->Exam_timetable_model->getRegulation();
	    $grdletr='';
	    foreach ($grade_letters as $grl) {
	    	$grdletr .=$grl['grade_letter'].','; 
	    }
	    //echo $grdletr;exit;
	    //$this->data['grade_letters'] = $grdletr.'NA,P,B++,D,A++,B++';
		$this->data['grade_letters'] = 'O,M,S';
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
	        $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Exam_timetable_model->getSchools();
	        $exam= explode('-', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
			$exam_id =$exam[2];
			$exam_sess_acdyer =$exam[3];
	        
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;	       

			$this->data['grde_dt']= $this->Marks_model->fetch_examGrades($_POST, $exam_id);
			$updsateData = $this->data['grde_dt'];
			if(!empty($updsateData)){
				$this->data['stud_list']= $this->Marks_model->list_examresult_students_for_grade($_POST,$exam_id);	
				$this->data['sub_list']= $this->Marks_model->list_examAppliedstud_subjects($_POST, $exam_month, $exam_year,$exam_id);
				//$this->data['stud_list']= $this->Marks_model->update_grade_list_students($_POST,$exam_month, $exam_year,$this->data['exam_id']);	  
				$this->load->view($this->view_dir.'update_attendace_grade_entry',$this->data);
			}else{	
				$this->data['stud_list']= $this->Marks_model->list_prev_exam_students($_POST,$exam_sess_acdyer);	
				$this->data['sub_list']= $this->Marks_model->list_prev_exam_stud_subjects($_POST);    
		        $this->load->view($this->view_dir.'attendace_grade_entry',$this->data);
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
	        
	        $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Exam_timetable_model->getSchools();
	        $this->load->view($this->view_dir.'attendace_grade_entry',$this->data);
	        $this->load->view('footer');
	        
	    }  
	} 
	public function updateStud_subject_attendace_grade()
    {       
        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$result_grade = $_POST['result_grade'];
		$result_id = $_POST['result_id'];	//exit;
		//echo "<pre>";
		//print_r($marks);  
		/// maintaing log
 		$sql ="INSERT INTO exam_result_data_log (result_id, student_id, enrollment_no,exam_id,exam_month,exam_year,school_id,stream_id,semester,subject_id,subject_code,cia_marks,	exam_marks,	cia_garde_marks,garce_marks,moderate_marks,exam_grade_marks,final_garde_marks,result_grade,reval_grade,final_grade,entry_by,entry_on,entry_ip,modified_by, modified_on,modified_ip,is_deleted)
 			SELECT result_id, student_id, enrollment_no,exam_id,exam_month,exam_year,school_id,stream_id,semester,subject_id,subject_code,cia_marks,	exam_marks,	cia_garde_marks,garce_marks,moderate_marks,exam_grade_marks,final_garde_marks,result_grade,reval_grade,final_grade,entry_by,entry_on,entry_ip,modified_by, modified_on,modified_ip,is_deleted FROM exam_result_data where result_id='$result_id'";
		//$DB1->query->($sql); 
		$query = $DB1->query($sql);
		$update_array['attendance_grade'] = strtoupper($result_grade);
		$update_array['modified_on'] = date('Y-m-d H:i:s');
		$update_array['modified_by'] = $this->session->userdata("uid");
		$update_array['modified_ip'] = $this->input->ip_address();
		$where=array("result_id"=>$result_id);
		$DB1->where($where);                
		$DB1->update('exam_result_data', $update_array);
		echo "SUCCESS";
		//echo $DB1->last_query();exit;
	} 
	///////////
	public function downloadExcel($testId)
	{

		$this->load->library('PHPExcel');

		// $students = $this->Cia_marks_model->getStudentXl();
		$testId = base64_decode($testId);

		$this->load->model('Examination_model');

		$roll_id = $this->session->userdata("role_id");

		$emp_id = $this->session->userdata("name");

		//echo $subdetails =$this->uri->segment(4);
		//exit;

		$this->data['sub_details'] = $testId;
		$subdetails = explode('~', $testId);

		// print_r($subdetails);exit;

		$sub_id = $subdetails[0];
		$this->data['stream'] = $subdetails[3];
		$this->data['semester'] = $subdetails[4];
		$this->data['examsession'] = $subdetails[5];
		$this->data['exam_type'] = $subdetails[6];
		$this->data['batch_details'] = $subdetails[7];
		$stream_id = $subdetails[3];

		//	print_r($sub_id);exit;

		$batch_details = $subdetails[7];
		$batch_code = explode('-', $batch_details);
		$th_batch = $batch_code[2]; //echo $subdetails[5];exit;
		$exam = explode('-', $subdetails[5]);

		// print_r($exam);exit;

		// $this->data['allbatchStudent'] = $this->Cia_marks_model->get_studbatch_allot_list($batch_details,$th_batch,$sub_id,$stream_id, $subdetails[4],$exam[2],$curr_session[0]['academic_year']);

		$students = $this->Examination_model->getSubjectStudentList($sub_id, $stream_id, $exam[0], $exam[1], $exam[2]);

		$this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
		$sub_code =$this->data['ut'][0]['subject_code'];
		$this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);

		// echo '<pre>';
		// print_r($this->data['allexamStudent']);exit;
		//$sub_code = $subdetails[8];
		// print_r($sub_code);exit;

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Your Name")
			->setTitle("Students Marks Entry Data");

		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'Sr. No.')
			->setCellValue('B1', 'Subject')
			->setCellValue('C1', 'Student_id')
			->setCellValue('D1', 'PRN')
			->setCellValue('E1', 'Barcode')
			->setCellValue('F1', 'ABN')
			->setCellValue('G1', 'Marks');
		//	->setCellValue('G1', 'Attendance');

		$row = 2;
		$i = 1;
		foreach ($students as $student) {
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $i++);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $sub_id . '-' . $sub_code);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $student['stud_id']);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $student['enrollment_no']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $student['barcode']);
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $student['ans_bklet_no']);
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $student['marks']);
			//	$objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $student['attendance_marks']);
			$row++;
		}

		$objPHPExcel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $sub_id . '-' . $sub_code . '.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$objWriter->save('php://output');

		exit;
	}

	public function uploadExcelData()
	{
		// Load necessary libraries
		ini_set("memory_limit", "-1");

		$subdetails = $this->input->post('sub_details');
		//print_r($subdetails);
		$subdetails = json_decode($subdetails, true); // Decode JSON string to array
		//  $value_at_index_2 = $subdetails[0][2]; 

		$this->load->library('PHPExcel');
		$this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		$stud_id = $_POST['stud_id'];
		$stream_id = $_POST['stream_id'];
		$marks_obtained = $_POST['marks_obtained'];
		$attdance_marks = $_POST['attdance_marks'];
		$enrollement_no = $_POST['enrollement_no'];
		if (!empty($_POST['division']) && $_POST['division'] != '') {
			$division = $_POST['division'];
		} else {
			$division = '';
		}
		if (!empty($_POST['batch']) && $_POST['batch'] != '') {
			$batch = $_POST['batch'];
		} else {
			$batch = '';
		}

		$stream_arr = array(5, 6, 7, 8, 9, 10, 11, 96, 97, 107, 108, 109, 158, 159, 162, 266);
		//$stream_arr1 = array(43,44,45,46,47);

		// $subdetails =explode('~',$_POST['sub_details']);

		// print_r($subdetails);

		$subject_id = $subdetails[0][0];
		$streamId = $subdetails[0][1];
		$semester = $subdetails[0][2];
		$marks_type = $subdetails[0][4];
		$max_marks = $subdetails[0][6];
		$sub_component = $subdetails[0][7];
		$exam = explode('-', $subdetails[0][3]);

		$exam_id = $exam[2];

		//  print_r($exam);exit;
		if ($semester == 1 || $semester == 2) {
			if (in_array($streamId, $stream_arr)) {
				$specialization_id = 9;
			} else {
				$specialization_id = 0;
			}
		} else {
			$specialization_id = 0;
		}
		/*else if (in_array($stream,  $stream_arr1)){
					  $specialization_id=103;	
				}*/
		//insert in master
		$insert_master_array = array(
			"stream_id" => $streamId,
			"specializaion_id" => $specialization_id,
			"semester" => $semester,
			"division" => $division,
			"batch_no" => $batch,
			"subject_id" => $subject_id,
			"exam_id" => $exam_id,
			"marks_entry_date" => date("Y-m-d"),
			"marks_type" => $marks_type,
			"max_marks" => $max_marks,
			"entry_by" => $this->session->userdata("uid"),
			"entry_on" => date("Y-m-d H:i:s"),
			"entry_status" => 'Entered'
		);
		// echo '<pre>';
		//	 print_r($insert_master_array);die;


		// print_r($last_inserted_id_master);exit;

		$existing_data = $this->Marks_model->get_marks_entry($subject_id, $exam_id, $marks_type,$streamId);

		if (!empty($existing_data)) {
			$this->session->set_flashdata('error', 'Data already exists for this subject and exam.');
			redirect('Marks/add_cap_marks');

		} else{

			$DB1->insert("marks_entry_master", $insert_master_array);
			// echo $DB1->last_query();exit;
			$last_inserted_id_master = $DB1->insert_id();
			// Check if a file was uploaded
			if ($_FILES['file']['name']) {
				// Load the uploaded file
				$inputFileName = $_FILES['file']['tmp_name'];

				// Load PHPExcel object
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

				// Get the active sheet
				$sheet = $objPHPExcel->getActiveSheet();

				// Iterate through rows
				$isFirstRow = true;

				$i = 0;
				foreach ($sheet->getRowIterator() as $row) {
					$i++;
					// Skip the first row
					if ($isFirstRow) {
						$isFirstRow = false;
						continue;
					}
					if ($specialization_id == 0) {
						$stream = $streamId;
					} else {
						$stream = $stream_id[$row];
					}
					$marks = $sheet->getCell('G' . $row->getRowIndex())->getValue();
					$enrollement_no = $sheet->getCell('D' . $row->getRowIndex())->getValue();

					if (intval($marks) > intval($max_marks) || intval($marks) < 0) {
						// Redirect back with error message
						$this->session->set_flashdata('error', 'Marks or attendance out of range. Please check the data.');
						redirect('Marks/add_cap_marks');
					}

					// print_r($cia_exam_type);			

					//	echo "hii";
					//   $data['cia_exam_type'] = $sheet->getCell('C' . $row->getRowIndex())->getValue();
					$data['stud_id'] = $sheet->getCell('C' . $row->getRowIndex())->getValue();
					$data['enrollment_no'] = $sheet->getCell('D' . $row->getRowIndex())->getValue();
					$data["marks"] = $marks;
					// print_r($cia_exam_type);			
					$data['marks_type'] = $marks_type;
					$data['me_id'] = $last_inserted_id_master;
					$data['subject_id'] = $subject_id;
					$data['stream_id'] = $streamId;
					$data['semester'] = $semester;
					$data['division'] = $division;
					$data['exam_id'] = $exam_id;
					$data['entry_by'] = $this->session->userdata("uid");
					$data['entry_on'] = date("Y-m-d H:i:s");
					$data['modified_ip'] = 'Excel';

						//echo "<pre>";
						//print_r($data);exit;
					//if(!empty($data['stud_id'])){
						$DB1->insert("marks_entry", $data);
					//}
				 //echo $DB1->last_query();exit;	
				}
			}
		}

		// Optionally, you can redirect the user or show a success message
		$this->session->set_flashdata('success', 'Data uploaded successfully.');
		redirect('Marks/add_cap_marks');


	}
	
	
	
	
	
	
	
	

}
?>