<?php
//error_reporting(E_ALL);
ini_set('memory_limit', '-1');
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once(APPPATH.'third_party/mpdf/mpdf.php');
class Boardvaluation extends CI_Controller{
	var $currentModule = "";   
	var $title = "";   
	var $table_name = "unittest_master";    
	var $model_name = "Boardvaluation_model";   
	var $model;  
	var $view_dir = 'Boardvaluation/';
 
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
		if(($this->session->userdata("role_id")==15)||($this->session->userdata("role_id")==6)||($this->session->userdata("role_id")==71)
			||($this->session->userdata("role_id")==26)){}else{
			redirect('home');
			}
		$this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
        
	}
	
	
public function index() //markscard_new
	{
	   // error_reporting(E_ALL);exit();
	    $this->load->model('Exam_timetable_model');
		$this->load->model('Marks_model');
		$this->load->model('Boardvaluation_model');
		$this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
		$this->data['board']= $this->Boardvaluation_model->fetch_board();
		//$this->data['regulatn']= $this->Exam_timetable_model->getRegulation();
	    if($_POST){
	          //echo "<pre>";
	         // print_r($_POST);exit;
	        $this->load->view('header',$this->data);
			/*$this->data['regulation'] =$_POST['regulation'];
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission_course'];
	        $this->data['stream'] =$_POST['admission_branch'];
	        $this->data['semester'] =$_POST['semester'];
	        $this->data['exam'] =$_POST['exam_session'];
	        $this->data['marks_type'] =$_POST['marks_type'];*/
	        $this->data['board_code'] =$_POST['board_code'];
			$this->data['board_date'] =$_POST['board_date'];
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Results_model->getresltSchools();
	        $exam= explode('-', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];
			
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
			$this->data['exam_new'] =$exam_month.'-'.$exam_year;
			 
			
			
		    $this->data['stud_list']= $this->Boardvaluation_model->list_Boardvaluation($_POST,$exam_month,$exam_year,$exam_id);	   				     
		    $this->load->view($this->view_dir.'Gradesheet_view',$this->data); //markscard_view

	        $this->load->view('footer');
	    }
	    else
	    {
	        
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] ='';
	        $this->data['admissioncourse'] = '';
	        $this->data['stream'] = '';
	        $this->data['semester'] = '';
	        $this->data['stud_list']='';
	        
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Results_model->getresltSchools();
	        $this->load->view($this->view_dir.'Gradesheet_view',$this->data); //markscard_view
	        $this->load->view('footer');
	        
	    }
	    
	    
	}
	
	public function load_date(){
		$board_code=$this->input->post('board_code');
		$ex_ses=$this->input->post('ex_ses');
		$board_date=$this->input->post('board_date');
        $stud_list= $this->Boardvaluation_model->load_date($board_code,$ex_ses);	
		echo '<option value="">Select All Date</option>'; 
		foreach($stud_list as $list){  	
		if($list['date']==$board_date)	{
		$sel="selected";
		}else{
		$sel="";
		}
echo "<option value='".$list['date']."' $sel>".$list['date']."</option>";
	}
	
	}
	public function Create_pdf(){
		if($_POST['board_code']=="All"){
			//echo '1';
		//	exit();
			$this->load->library('m_pdf');
		$mpdf=new mPDF();
		$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '6', '6', '6', '6', '15', '15');
	//	print_r($_POST);//exit();
		/*
		 $exam_ses="2019_May_new";
//$exam_ses= $exam_month.'_'.$exam_year.'_'.$exam_id;
///////////////////
			include_once "phpqrcode/qrlib.php";
			//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
			$tempDir = 'uploads/gradesheet/'.$exam_ses.'/';
			//Check if the directory already exists.
			if(!is_dir($tempDir)){
				//Directory does not exist, so lets create it.
				mkdir($tempDir, 0777, true);
			}
			//$po_id = $p_row[0]['ord_no'];
			$site_url="https://erp.sandipuniversity.com/";
			$codeContents = $site_url.'grade_sheet.php?po='.$list;
			
			// we need to generate filename somehow, 
			// with md5 or with database ID used to obtains $codeContents...
			$fileName = 'qrcode_'.$list.'.png';		
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $pngAbsoluteFilePath;
			
			// generating
			//if (!file_exists($pngAbsoluteFilePath)) {
			QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);
		*/
		    $exam= explode('~', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];
			
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
			$this->data['exam_new'] =$exam_month.'-'.$exam_year;
			$this->data['board_date'] =$_POST['board_date'];
			$boardname=array();
			
		//	print_r($_POST);
			//exit();
		$stud_list= $this->Boardvaluation_model->list_Boardvaluation_group($_POST,$exam_month,$exam_year,$exam_id);
		//print_r($stud_list);
		//exit();
		foreach($stud_list as $list){
			if(!empty($list['evaluation_board'])){
		/* for($i=0;$i<count($stud_list);$i++){
			 if(empty($boardname)){
			$stud_list[$i]['evaluation_board'];
			$boardname[]=$stud_list[$i]['evaluation_board'];
			}else{
			if($stud_list[$i]['evaluation_board']==$stud_list[$i+1]['evaluation_board']){
			//echo '-';
			}else{
			//echo '-';
			unset($boardname);
			}
			}
		 }*/
			 
		 //if(!empty($stud_list[$i]['couser_code'])){
		//$this->data['stud_list']=$stud_list;
		//print_r($this->data['stud_list']); exit();
		//foreach($stud_list as $list){
		//if(($list['evaluation_board']!=="")||($list['evaluation_board']!==NULL)){
			$stud_listt= $this->Boardvaluation_model->list_Boardvaluation_all($list['evaluation_board'],$_POST['board_date'],$exam_month,$exam_year,$exam_id);
			
			
			$this->data['stud_list']=$stud_listt;
		    $html =$this->load->view($this->view_dir.'markscard_pdf.php',$this->data,true);
		
		   
		   $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

	        $footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:-5px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" width="70" class="signature" style="margin-left:655px;margin-top:13px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td  height="50" class="signature" valign="top" style="margin-left:550px;"><strong>'; $footer .=$current_date.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:%23CDCACA;"></small></td>
	</tr>
	</table>';
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLFooter($footer);

			
		
			
 
			$this->m_pdf->pdf->useFixedNormalLineHeight = false;
            $this->m_pdf->pdf->useFixedTextBaseline = false;
            $this->m_pdf->pdf->normalLineheight = 2.7;
            $this->m_pdf->pdf->adjustFontDescLineheight = 2.7;
		    //$this->m_pdf->pdf->SetDefaultBodyCSS('line-height', 5.2);
			$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1,
								'reset' => 0,
								'type' => 'I',
								'suppress' => 'off'
							];
			$this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML($html);
			
			 
			ob_clean();
			
			$i++;
			
		}} //LOop
			
			$currtnt_time= date('y-m-d h:i:s');
			//$this->data['schoolname_new'];//date('y-m-d h:i:s');
		    $pdfFilePath1 =$currtnt_time."_AUTONOMOUS_VALUATION.pdf";
			
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
		//}}
			
			
			}else{
		
		$this->load->library('m_pdf');
		$mpdf=new mPDF();
		$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '6', '6', '6', '6', '15', '15');
	//	print_r($_POST);//exit();
		/*
		 $exam_ses="2019_May_new";
//$exam_ses= $exam_month.'_'.$exam_year.'_'.$exam_id;
///////////////////
			include_once "phpqrcode/qrlib.php";
			//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
			$tempDir = 'uploads/gradesheet/'.$exam_ses.'/';
			//Check if the directory already exists.
			if(!is_dir($tempDir)){
				//Directory does not exist, so lets create it.
				mkdir($tempDir, 0777, true);
			}
			//$po_id = $p_row[0]['ord_no'];
			$site_url="https://erp.sandipuniversity.com/";
			$codeContents = $site_url.'grade_sheet.php?po='.$list;
			
			// we need to generate filename somehow, 
			// with md5 or with database ID used to obtains $codeContents...
			$fileName = 'qrcode_'.$list.'.png';		
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $pngAbsoluteFilePath;
			
			// generating
			//if (!file_exists($pngAbsoluteFilePath)) {
			QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);
		*/
		    $exam= explode('~', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];
			
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
			$this->data['exam_new'] =$exam_month.'-'.$exam_year;
			
			
		$this->data['stud_list']= $this->Boardvaluation_model->list_Boardvaluation($_POST,$exam_month,$exam_year,$exam_id);
		//print_r($this->data['stud_list']); exit();
		$html =$this->load->view($this->view_dir.'markscard_pdf.php',$this->data,true);
		   
		   $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

	        $footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:-5px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" width="70" class="signature" style="margin-left:655px;margin-top:13px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td  height="50" class="signature" valign="top" style="margin-left:550px;"><strong>'; $footer .=$current_date.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:%23CDCACA;"></small></td>
	</tr>
	</table>';
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLFooter($footer);

			
		
			
 
			$this->m_pdf->pdf->useFixedNormalLineHeight = false;
            $this->m_pdf->pdf->useFixedTextBaseline = false;
            $this->m_pdf->pdf->normalLineheight = 2.7;
            $this->m_pdf->pdf->adjustFontDescLineheight = 2.7;
		    //$this->m_pdf->pdf->SetDefaultBodyCSS('line-height', 5.2);
			$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1,
								'reset' => 0,
								'type' => 'I',
								'suppress' => 'off'
							];
			$this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML($html);
			
			 
			ob_clean();
			
			$i++;
			
		//	} //LOop
			
			$currtnt_time= date('y-m-d h:i:s');
			//$this->data['schoolname_new'];//date('y-m-d h:i:s');
		    $pdfFilePath1 =$currtnt_time."_AUTONOMOUS_VALUATION.pdf";
			
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
		
			}
	}
	
////////////////////////////////////////////////////////////////////////////////////////	
	}
	?>