<?php  ini_set("display_errors", "On");
error_reporting(1);
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');
define("MODEL_NM","course_model");

class Feedback extends CI_Controller {
	
    var $currentModule="";
    var $title="";
   var $model_name="Feedback_model";
    var $model;
    var $view_dir='Feedback/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        //error_reporting(E_ALL);
        ini_set('display_errors', 1);

       // $this->load->helper('url');		
        $this->load->library('form_validation');
        
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
          $title=$this->master_arr['index'];
       
        $this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']='feedback';
        $this->data['model_name']=$this->model_name;
        
       
         $model = $this->load->model($this->model_name);
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    function index(){
         $this->load->view('header',$this->data);   
         $this->load->view($this->view_dir.'index',$this->data);
        $this->load->view('footer',$this->data);   
    }
    
    
     function rating_feedback(){
         $this->load->view('header',$this->data);   
         $rslot="campaign1";
         $rdate="2018-08-20";
            $this->data['rating']=$this->Feedback_model->all_rating($rslot,$rdate);
            $this->data['comments']=$this->Feedback_model->all_comments();
            $this->data['campaigns']=$this->Feedback_model->campaigns_list();
         $this->load->view($this->view_dir.'rating',$this->data);
        $this->load->view('footer',$this->data);   
    }
    
    
    public function parent()
    {
          
        if($_POST){
             $this->load->view('header',$this->data);   
            $row=array();
             $row=$_POST;
            $row['feedback_date']=date('Y-m-d');
            $row['from_ip']=$_SERVER['REMOTE_ADDR'];
            $row['entry_on']=date('Y-m-d h:m:i');
            $row['prn']=$this->session->userdata('name');
            
            
              //print_r($row);exit();
              $res=$this->Feedback_model->post_parent_fedback($row);
               if($res>0){
                  $this->session->set_flashdata('msg',"1");
               }else{
                  $this->session->set_flashdata('msg',"0");
                
				
				
               }
                $this->load->view($this->view_dir.'parent',$this->data);
              $this->load->view('footer',$this->data);   
            
        }
        else
        {
            $count=$this->Feedback_model->check_feedback($this->session->userdata('name'));
          //echo $count;exit();
            if($count>0){
                 $this->session->set_flashdata('exist',"Y");
           }
          $this->load->view('header',$this->data);   
       
        $this->load->view($this->view_dir.'parent',$this->data);
        $this->load->view('footer',$this->data);
            
        }
          
         
    }
    
    public function summary_parent(){
         $this->load->view('header',$this->data);  
         $this->data['summary']=$this->Feedback_model->parent_feedback_summary($row);
        $this->load->view($this->view_dir.'summary_parent',$this->data);
        $this->load->view('footer',$this->data);
        
    }
    
     public function excel_parent_feedback(){
         $year="2017";
         $this->data['summary']=$this->Feedback_model->export_parent_feedback($year);
         $this->load->view($this->view_dir.'excel_parent_feedback',$this->data);
      
        
    }
   // for student
    function student_bala(){		
		$stud_enroll_no = $this->session->userdata("name");
		$this->load->view('header',$this->data); 
		$this->load->model('Subject_model');
		// fetch student details like stream,semester,div,batch
		$stud_det= $this->Feedback_model->fetch_stud_details($stud_enroll_no);

		//$division = explode('-', $stud_det[0]['batch_code']);
			
		$this->data['course_short_name']= $stud_det[0]['course_short_name'];
		$this->data['stream_name']= $stud_det[0]['stream_short_name'];
		$this->data['stream']= $stud_det[0]['strmId'];
		$this->data['semester']= $stud_det[0]['current_semester'];
		$this->data['division']= $stud_det[0]['division'];
		$this->data['student_id']= $stud_det[0]['stud_id'];		
		$semester= $stud_det[0]['current_semester'];
		$stream = $stud_det[0]['strmId'];
		$div = $stud_det[0]['division'];
		
		// load subjects of students
		$this->data['sub']= $this->Feedback_model->fetch_student_subjects($semester, $stream, $div);
		for($i=0;$i<count($this->data['sub']); $i++){
			$subid = $this->data['sub'][$i]['subject_code'];
			$this->data['sub'][$i]['fb']= $this->Feedback_model->fetch_feedback_subjects($subid, $semester, $stream, $div,$stud_det[0]['stud_id']);
		}
		//echo "<pre>";
		//print_r($this->data['sb']);exit;
        $this->load->view($this->view_dir.'view_student_subjects',$this->data);
        $this->load->view('footer');	
	}

    public function submiit_old($stud_det)
    {
		//$this->load->model('Marks_model'); 
		$this->load->helper("url");
		$obj = New Consts();
		$cursession = $obj->fetchCurrSession();
		if(!empty($_POST)){
			//echo "<pre>";
			//print_r($_POST);
			$row=array();
			$subject_det = explode('~',$_POST['subject_det']);
            $row=$_POST;
			$row['stream_id']=$subject_det[0];
			$row['semester']=$subject_det[1];
			$row['division']=$subject_det[2];
			$row['subject_id']=$subject_det[4];
			$row['student_id']=$subject_det[3];
			$row['faculty_code']=$subject_det[5];
			$row['academic_year']='2017-18';
			$row['academic_type']= $cursession;
			
            $row['feedback_date']=date('Y-m-d');
            $row['from_ip']=$_SERVER['REMOTE_ADDR'];
            
			unset($row['subject_det']);
			$res=$this->Feedback_model->post_student_fedback($row);
			if($res>0){
			  $this->session->set_flashdata('msg',"1");
			  redirect('feedback/student');
			}
			else
			{
			  $this->session->set_flashdata('msg',"0");
			  
			}
			$this->data['stud_det'] = $_POST['subject_det'];
			$this->load->view('header',$this->data); 
            $this->load->view($this->view_dir.'student_feedback_view',$this->data);
            $this->load->view('footer',$this->data);  
		}else{
			$studdet = base64_decode($stud_det);
			$this->data['stud_det'] = $studdet;
			$subject_det = explode('~',$studdet);
			$this->data['sub'] = $this->Feedback_model->getsubdetails($subject_det[4]);
			$this->data['fac'] = $this->Feedback_model->getfacdetails($subject_det[5]);
			$this->load->view('header',$this->data);        
			$this->data['questions']=$this->Feedback_model->get_feedback_questions();       	                         
			$this->load->view($this->view_dir.'student_feedback_view', $this->data);
			$this->load->view('footer');
		}
    }
    
  
  
  
  
      function student(){
		 // exit;
            //error_reporting(E_ALL);
//ini_set('display_errors', 1);
		$datetime=date('Y-m-d');
		if($datetime >='2025-10-08' && $datetime <='2025-10-11'){
			//echo 'Link is closed';exit;	
		}else{
			echo 'Link is closed';exit;
		}
		$obj = New Consts();
		$cursession = $obj->fetchCurrSession_feedback();
		 $attper = $this->Feedback_model->check_student_attper($_SESSION['name']);
		//echo $attper[0]['att_percentage'];
		if($attper[0]['att_percentage'] < 50){
			echo  'Your not allowed for Feedback.';exit;
		}
//echo $cursession."*";exit;

		$stud_enroll_no = $this->session->userdata("name");
		$this->load->view('header',$this->data); 
		$this->load->model('Subject_model');
		// fetch student details like stream,semester,div,batch
		$stud_det= $this->Feedback_model->fetch_stud_details($stud_enroll_no);

		$feedback = $this->Feedback_model->check_student_feedback($cursession,$stud_det[0]['stud_id']);
		if($feedback['feedback_id']!='')
		{
		  $this->data['feedback']  ='Y';
		  //redirect('feedback/student');
		  
		}
		else
		{
			 $this->data['feedback']  ='N'; 
		}

		$this->data['course_short_name']= $stud_det[0]['course_short_name'];
		$this->data['stream_name']= $stud_det[0]['stream_short_name'];
		$this->data['stream']= $stud_det[0]['admission_stream'];
		$this->data['semester']= $stud_det[0]['current_semester'];
		$this->data['student_id']= $stud_det[0]['stud_id'];		
		$semester= $stud_det[0]['current_semester'];
		$stream = $stud_det[0]['admission_stream'];
		$div = $this->Feedback_model->fetch_student_division($stud_det[0]['stud_id'], $stream,$semester);//$division[1];
		$this->data['division']= $div['division'];
		//	$div = $division[1];
	//	echo $div;
		$this->data['questions']=$this->Feedback_model->get_feedback_questions();  
		// load subjects of students
		$this->data['sub']= $this->Feedback_model->fetch_student_subjects($semester, $stream, $div,$stud_det[0]['stud_id']);
		for($i=0;$i<count($this->data['sub']); $i++){
			$subid = $this->data['sub'][$i]['subject_code'];
			$this->data['sub'][$i]['fb']= $this->Feedback_model->fetch_feedback_subjects($subid, $semester, $stream, $div,$stud_det[0]['stud_id']);
		}
		//echo "<pre>";
		//print_r($this->data['sb']);exit;
        $this->load->view($this->view_dir.'view_student_subjects',$this->data);
        $this->load->view('footer');	
	}
  
    public function submit($stud_det='')
    {
        
  //     var_dump($_POST);
     //   exit(0);
		//$this->load->model('Marks_model'); 
		//error_reporting(E_ALL);
		$obj = New Consts();
		$cursession = $obj->fetchActiveSession_feedback();
		$actses = explode('~',$cursession);
		//print_r($actses);exit;
		if(!empty($_POST)){
		  	//var_dump($_POST);
		  	 //exit(0);
		$subdata = $this->Feedback_model->fetch_student_subjects($_POST['hsem'],$_POST['hcourse'],$_POST['hdiv'],$_POST['hstdid']);
		foreach($subdata as $stddata)
		{
		  		$row=array();
			//$subject_det = explode('~',$_POST['subject_det']);
            //$row=$_POST;
			$row['stream_id']=$_POST['hcourse'];
			$row['semester']=$_POST['hsem'];
			$row['division']=$_POST['hdiv'];
			$row['subject_id']=$stddata['subject_code'];
			$row['student_id']=$_POST['hstdid'];
			$row['faculty_code']=$stddata['faculty_code'];
			$row['Q1']= $_POST["Q19_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q2']= $_POST["Q20_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q3']= $_POST["Q21_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q4']= $_POST["Q22_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q5']= $_POST["Q23_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q6']= $_POST["Q24_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q7']= $_POST["Q25_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q8']= $_POST["Q26_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q9']= $_POST["Q27_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q10']= $_POST["Q28_".$stddata['faculty_code']."_".$stddata['subject_code']];
			/* $row['Q11']= $_POST["Q11_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q12']= $_POST["Q12_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q13']= $_POST["Q13_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q14']= $_POST["Q14_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q15']= $_POST["Q15_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q16']= $_POST["Q16_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q17']= $_POST["Q17_".$stddata['faculty_code']."_".$stddata['subject_code']];
			$row['Q18']= $_POST["Q18_".$stddata['faculty_code']."_".$stddata['subject_code']]; */
			//$row['comment']= $_POST["comment_".$stddata['faculty_code']."_".$stddata['subject_code']];
			
			$row['academic_type']= $actses[0];
			$row['academic_year']=$actses[1];
			$row['feedback_cycle']=$actses[2];
			
            $row['feedback_date']=date('Y-m-d H:i:s');
            $row['from_ip']=$_SERVER['REMOTE_ADDR'];
            
		//	unset($row['subject_det']);
			$res=$this->Feedback_model->post_student_fedback($row);
			//echo '<pre>';print_r($row);exit;
		}
		
		//	exit();
		    	//$studdet = base64_decode($stud_det);
			//$this->data['stud_det'] = $studdet;
		
		
		//	$subject_det = explode('~',$studdet);
			
			
			//echo "<pre>";
			//print_r($_POST);
		/*	$row=array();
			$subject_det = explode('~',$_POST['subject_det']);
            $row=$_POST;
			$row['stream_id']=$subject_det[0];
			$row['semester']=$subject_det[1];
			$row['division']=$subject_det[2];
			$row['subject_id']=$subject_det[4];
			$row['student_id']=$subject_det[3];
			$row['faculty_code']=$subject_det[5];
			$row['academic_year']='2017-18';
			$row['academic_type']= $cursession;
			
            $row['feedback_date']=date('Y-m-d');
            $row['from_ip']=$_SERVER['REMOTE_ADDR'];
            
			unset($row['subject_det']);
			$res=$this->Feedback_model->post_student_fedback($row);*/
			if($res>0){
				echo "inside";
			  $this->session->set_flashdata('msg',"1");
			  //redirect(base_url().'feedback/student', 'refresh');
			  redirect('Feedback/student');
			}
			else
			{
				echo "outside";
			  $this->session->set_flashdata('msg',"0");
			  redirect('feedback/student');
			  //redirect('feedback/general');
			}
			/*$this->data['stud_det'] = $_POST['subject_det'];
			$this->load->view('header',$this->data); 
            $this->load->view($this->view_dir.'view_student_subjects',$this->data);
            $this->load->view('footer',$this->data);  */
		}else{
			$studdet = base64_decode($stud_det);
			$this->data['stud_det'] = $studdet;
			$subject_det = explode('~',$studdet);
			$this->data['sub'] = $this->Feedback_model->getsubdetails($subject_det[4]);
			$this->data['fac'] = $this->Feedback_model->getfacdetails($subject_det[5]);
			$this->load->view('header',$this->data);        
			$this->data['questions']=$this->Feedback_model->get_feedback_questions();       	                         
			$this->load->view($this->view_dir.'view_student_subjects', $this->data);
			$this->load->view('footer');
		}
    }
    
	
	function check_redirect(){
		redirect('home');
		echo '1';
	}
  
    
	// for admin 
	public function faculty_feedback_report_old($tt_id=''){
		$role_id = $this->session->userdata('role_id');
		$this->load->model('Subject_model');  
		$this->load->model('Timetable_model');  
		$this->load->view('header',$this->data);           	                                        
        $this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['school_details']= $this->Timetable_model->getSchools();

		$this->data['streamId']=$_POST['stream_id'];
		$this->data['semester']= $_POST['semester'];
		$this->data['division']= $_POST['division'];
		//$this->data['student_id']= $_POST['stud_id'];		
		$semester= $_POST['semester'];
		$stream = $_POST['stream_id'];
		$div = $_POST['division'];
		
		// load subjects of semester
		$this->data['sub']= $this->Feedback_model->fetch_student_subjects_org($semester, $stream, $div);
		
		for($i=0;$i<count($this->data['sub']); $i++){
			$subid = $this->data['sub'][$i]['subject_code'];
			$faculty_code = $this->data['sub'][$i]['faculty_code'];
			$this->data['sub'][$i]['fb']= $this->Feedback_model->fetch_feedback_subjects_to_admin($subid, $semester, $stream, $div,$faculty_code);
			$this->data['sub'][$i]['mrks']= $this->Feedback_model->fetch_mrk_reports($subid, $semester, $stream, $div,$faculty_code);
		}
		
        $this->load->view($this->view_dir.'faculty_feedback_score_view',$this->data);
        $this->load->view('footer');
	}	
	public function faculty_feedback_report($tt_id=''){
		//error_reporting(E_ALL);
		//ini_set("error_reporting", E_ALL); 
		$role_id = $this->session->userdata('role_id');
		        	                                        
		$this->data['fbsession']= $this->Feedback_model->fetch_feedback_session();
		$this->data['schools']= $this->Feedback_model->fetch_feedback_schools();
		$obj = New Consts();
		$cursession = $obj->fetchActiveSession_feedback();
		$this->data['actses'] =$cursession;
		
		
		
		// load subjects of semester
		if(!empty($_POST)){
			$sesdetails = explode('~', $_POST['fbsession']);
			$this->data['fbschool'] = $_POST['fbschool'];
			$this->data['fbses'] = $_POST['fbsession'];
			$this->data['fbcycle'] = $_POST['fbcycle'];	
			
			if(!empty($_POST['fbschool'])){
				$school = $_POST['fbschool'];
			}else{
				$school='';
			}
			
			$academic_type = $sesdetails[0];
			$academic_year = $sesdetails[1];
			$cycle = $_POST['fbcycle'];	
			$this->data['academic_type']=$academic_type;
		    $this->data['academic_year']=$academic_year;
		    $this->data['school']=$school;
			$this->data['class']= $this->Feedback_model->fetch_classwise_summary($academic_type, $academic_year,$school,$cycle);
		}
		
		$this->data['ALL_count']='';//$this->Feedback_model->fetch_total_count($stream_id, $division, $semester,$academic_year, $cycle);
		//print_r($this->data['ALL_count']);
		//exit;
		
		for($i=0; $i<count($this->data['class']); $i++){
			$stream_id = $this->data['class'][$i]['stream_id'];
			$stream_code = $this->data['class'][$i]['stream_code'];
			$division = $this->data['class'][$i]['division'];
			$semester = $this->data['class'][$i]['semester'];
			$batch_code = $stream_code.'-'.$division;
			$this->data['class'][$i]['class_studcnt']= $this->Feedback_model->fetch_classwise_student_count($stream_id, $division, $semester,$academic_year);//exit;
			$this->data['class'][$i]['fdappeared_studcnt']= $this->Feedback_model->fetch_classwise_fdapperedstudent_count($stream_id, $division, $semester,$academic_year,$academic_type);
			$this->data['class'][$i]['studcnt_submitted']= $this->Feedback_model->fetch_fbsubmitted_student_count($stream_id, $semester, $division,$academic_year,$academic_type,$cycle);
		}
		

		$this->load->view('header',$this->data);   
        $this->load->view($this->view_dir.'faculty_feedback_summary_view',$this->data);
        $this->load->view('footer');
	}
	
	
	    public function faculty_feedback_report_pdf($stud_details){
		//error_reporting(E_ALL);
		//ini_set("error_reporting", E_ALL); 
		$role_id = $this->session->userdata('role_id');
		        	                                        
		$this->data['fbsession']= $this->Feedback_model->fetch_feedback_session();
		$this->data['schools']= $this->Feedback_model->fetch_feedback_schools();
		$obj = New Consts();
		$cursession = $obj->fetchActiveSession_feedback();
		$this->data['actses'] =$cursession;
		// load subjects of semester
		/*if(!empty($_POST)){
			$sesdetails = explode('~', $_POST['fbsession']);
			$this->data['fbschool'] = $_POST['fbschool'];
			$this->data['fbses'] = $_POST['fbsession'];
			if(!empty($_POST['fbschool'])){
				$school = $_POST['fbschool'];
			}else{
				$school='';
			}
			$academic_type = $sesdetails[0];
			$academic_year = $sesdetails[1];
			$this->data['class']= $this->Feedback_model->fetch_classwise_summary($academic_type, $academic_year,$school);
		}*/
		
		$stud_det = base64_decode($stud_details);
		//print_r($stud_det);exit;
		$subject_det = explode('~',$stud_det);
		
		 $academic_type=$subject_det[0];//echo '<br>';
		 $academic_year=$subject_det[1];//echo '<br>';
         $school=$subject_det[2];//echo '<br>';
		  $cycle=$subject_det[3];//echo '<br>';
		 
		 $this->data['academic_type']=$academic_type;
		 $this->data['academic_year']=$academic_year;
		 $this->data['school']=$school;
		//$this->data['ALL_count']=$this->Feedback_model->fetch_total_count($stream_id, $division, $semester,$academic_year);
					$this->data['class']= $this->Feedback_model->fetch_classwise_summary($academic_type, $academic_year,$school, $cycle);

		for($i=0; $i<count($this->data['class']); $i++){
			$stream_id = $this->data['class'][$i]['stream_id'];
			$stream_code = $this->data['class'][$i]['stream_code'];
			$division = $this->data['class'][$i]['division'];
			$semester = $this->data['class'][$i]['semester'];
			$batch_code = $stream_code.'-'.$division;
			$this->data['class'][$i]['class_studcnt']= $this->Feedback_model->fetch_classwise_student_count($stream_id, $division, $semester,$academic_year);//exit;
			$this->data['class'][$i]['fdappeared_studcnt']= $this->Feedback_model->fetch_classwise_fdapperedstudent_count($stream_id, $division, $semester,$academic_year, $academic_type);
			$this->data['class'][$i]['studcnt_submitted']= $this->Feedback_model->fetch_fbsubmitted_student_count($stream_id, $semester, $division,$academic_year,$academic_type, $cycle);
		}
		

		   $this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'faculty_feedback_summary_view_pdf',$this->data, true);
			$html .= $this->load->view('footer',$this->data, true);
			$pdfFilePath1 ="Feedback_Report.pdf";
			$dattime = date('d-m-Y H:i:s');
		$footer = '<table width="700" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
		  <tr>
		    <td align="right" colspan="3" class="signature"><small><i>Printed on: '.$dattime.'</i></small></td>	
		  </tr>
		  </table>';
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$footer1 = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');	
		$this->m_pdf->pdf->SetHTMLFooter($footer1);		
			
			$mpdf=new mPDF();

			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
	//	$this->load->view('header',$this->data);   
      //  $this->load->view($this->view_dir.'faculty_feedback_summary_view',$this->data);
      //  $this->load->view('footer');
	}
	
	public function HCT_feedback_report($tt_id=''){
		//error_reporting(E_ALL);
		//ini_set("error_reporting", E_ALL); 
		$role_id = $this->session->userdata('role_id');
		        	                                        
		$this->data['fbsession']= $this->Feedback_model->fetch_feedback_session();
		$this->data['schools']= $this->Feedback_model->fetch_feedback_schools();
		$obj = New Consts();
		$cursession = $obj->fetchActiveSession_feedback();
		$this->data['actses'] =$cursession;
		// load subjects of semester
		if(!empty($_POST)){
			$sesdetails = explode('~', $_POST['fbsession']);
			$this->data['fbschool'] = $_POST['fbschool'];
			$this->data['fbses'] = $_POST['fbsession'];
			if(!empty($_POST['fbschool'])){
				$school = $_POST['fbschool'];
			}else{
				$school='';
			}
			$academic_type = $sesdetails[0];
			$academic_year = $sesdetails[1];
			$this->data['academic_type'] = $academic_type;
			$this->data['academic_year'] = $academic_year;
			$this->data['fbcycle'] = $_POST['fbcycle'];	
			$cycle = $_POST['fbcycle'];	
			$this->data['school'] = $school;
			//$this->data['class']= $this->Feedback_model->fetch_classwise_summary($academic_type, $academic_year,$school);
		}
		
	/*for($i=0; $i<count($this->data['class']); $i++){
			$stream_id = $this->data['class'][$i]['stream_id'];
			$stream_code = $this->data['class'][$i]['stream_code'];
			$division = $this->data['class'][$i]['division'];
			$semester = $this->data['class'][$i]['semester'];
			$batch_code = $stream_code.'-'.$division;
			$this->data['class'][$i]['class_studcnt']= $this->Feedback_model->fetch_classwise_student_count($stream_id, $division, $semester,$academic_year);//exit;
			//$this->data['class'][$i]['fdappeared_studcnt']= $this->Feedback_model->fetch_classwise_fdapperedstudent_count($stream_id, $division, $semester,$academic_year);
			$this->data['class'][$i]['studcnt_submitted']= $this->Feedback_model->fetch_fbsubmitted_student_count($stream_id, $semester, $division,$academic_year,$academic_type);
		}*/
		
        $this->data['All_data']= $this->Feedback_model->HCT_feedback_report($academic_type, $academic_year,$school, $cycle);
      // print_r($class);
	//	exit;
		$this->load->view('header',$this->data);   
        $this->load->view($this->view_dir.'Hostel_Cateen_Transportation',$this->data);
        $this->load->view('footer');
	}
	
	public function HCT_feedback_report_Pdf($stud_details){
		//error_reporting(E_ALL);
		//ini_set("error_reporting", E_ALL); 
		$role_id = $this->session->userdata('role_id');
		        	                                        
		//$this->data['fbsession']= $this->Feedback_model->fetch_feedback_session();
		//$this->data['schools']= $this->Feedback_model->fetch_feedback_schools();
		$obj = New Consts();
		$cursession = $obj->fetchActiveSession_feedback();
		$this->data['actses'] =$cursession;
		// load subjects of semester
		$stud_det = base64_decode($stud_details);
		//print_r($stud_det);exit;
		$subject_det = explode('~',$stud_det);
		
		 $academic_type=$subject_det[0];//echo '<br>';
		 $academic_year=$subject_det[1];//echo '<br>';
         $school=$subject_det[2];//echo '<br>';
		 
		 $this->data['academic_type']=$academic_type;
		 $this->data['academic_year']=$academic_year;
		 $this->data['school']=$school;
		
	/*for($i=0; $i<count($this->data['class']); $i++){
			$stream_id = $this->data['class'][$i]['stream_id'];
			$stream_code = $this->data['class'][$i]['stream_code'];
			$division = $this->data['class'][$i]['division'];
			$semester = $this->data['class'][$i]['semester'];
			$batch_code = $stream_code.'-'.$division;
			$this->data['class'][$i]['class_studcnt']= $this->Feedback_model->fetch_classwise_student_count($stream_id, $division, $semester,$academic_year);//exit;
			//$this->data['class'][$i]['fdappeared_studcnt']= $this->Feedback_model->fetch_classwise_fdapperedstudent_count($stream_id, $division, $semester,$academic_year);
			$this->data['class'][$i]['studcnt_submitted']= $this->Feedback_model->fetch_fbsubmitted_student_count($stream_id, $semester, $division,$academic_year,$academic_type);
		}*/
		
        $this->data['All_data']= $this->Feedback_model->HCT_feedback_report($academic_type, $academic_year,$school);
      // print_r($class);
	//	exit;
		//$this->load->view('header',$this->data);   
        //$this->load->view($this->view_dir.'Hostel_Cateen_Transportation',$this->data);
        //$this->load->view('footer');
		    $this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'Hostel_Cateen_Transportation_pdf',$this->data, true);
			$html .= $this->load->view('footer',$this->data, true);
			$pdfFilePath1 ="Feedback_Report.pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			$mpdf=new mPDF();

			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
	}
	
	// view faculty report details
	public function view($stud_details)
    {
			//$this->load->model('Marks_model');  
			$row=array();
			$stud_det = base64_decode($stud_details);
			$subject_det = explode('~',$stud_det);

			$stream=$subject_det[0];
			$semester=$subject_det[1];
			$this->data['division']=$subject_det[2];
			$this->data['semester']=$subject_det[1];
			$subid=$subject_det[3];
			$faculty_code=$subject_det[4];
			$div=$subject_det[2];
			$row['academic_year']='2017-18';
			$row['academic_type']='W';
			
            $row['feedback_date']=date('Y-m-d');
            $row['from_ip']=$_SERVER['REMOTE_ADDR'];
            
			$this->data['StreamSrtName'] = $this->Feedback_model->getStreamShortName($subject_det[0]);
			//print_r($this->data['StreamSrtName']);exit;
			$this->data['sub'] = $this->Feedback_model->getsubdetails($subject_det[3]);
			$this->data['fac'] = $this->Feedback_model->getfacdetails($subject_det[4]);
			$this->data['questions']=$this->Feedback_model->get_feedback_questions(); 
			$this->data['marks']= $this->Feedback_model->fetch_feedback_report($subid, $semester, $stream, $div,$faculty_code);
			for($i=0;$i<count($this->data['questions']); $i++){
			$qid = 'Q'.$this->data['questions'][$i]['ques_id'];
			$faculty_code = $subject_det[4];
			//$this->data['sub'][$i]['fb']= $this->Feedback_model->fetch_feedback_report($subid, $semester, $stream, $div,$faculty_code);
		}
			$this->load->view('header',$this->data); 
            $this->load->view($this->view_dir.'faculty_feedback_report',$this->data);
            $this->load->view('footer',$this->data);  
		
    }
	// download feedback report pdf
	public function download_report($stud_details, $fbdses, $cycle)
    {
			//$this->load->model('Marks_model');  
			$row=array();
			$stud_det = base64_decode($stud_details);
			//print_r($fbdses);exit;
			$subject_det = explode('~',$stud_det);
			$stream=$subject_det[0];
			$semester=$subject_det[1];
			$this->data['division']=$subject_det[2];
			$this->data['semester']=$subject_det[1];
			$this->data['fbdses']= $fbdses;
			$subid=$subject_det[3];
			$faculty_code=$subject_det[4];
			$div=$subject_det[2];
			$row['academic_year']='2017-18';
			$row['academic_type']='W';
			
            $row['feedback_date']=date('Y-m-d');
            $row['from_ip']=$_SERVER['REMOTE_ADDR'];
            $this->data['active_session']= $this->Feedback_model->active_academic_session();
			$this->data['StreamSrtName'] = $this->Feedback_model->getStreamShortName($subject_det[0]);
			//print_r($this->data['StreamSrtName']);exit;
			$this->data['sub'] = $this->Feedback_model->getsubdetails($subject_det[3]);
			$this->data['fac'] = $this->Feedback_model->getfacdetails($subject_det[4]);
			$this->data['questions']=$this->Feedback_model->get_feedback_questions(); 
			$this->data['marks']= $this->Feedback_model->fetch_feedback_report($subid, $semester, $stream, $div,$faculty_code, $cycle);
			for($i=0;$i<count($this->data['questions']); $i++){
			$qid = 'Q'.$this->data['questions'][$i]['ques_id'];
			$faculty_code = $subject_det[4];
			//$this->data['sub'][$i]['fb']= $this->Feedback_model->fetch_feedback_report($subid, $semester, $stream, $div,$faculty_code);
			}
			$this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'faculty_feedback_report_pdf',$this->data, true);
			$html .= $this->load->view('footer',$this->data, true);
			$pdfFilePath1 ="Feedback_Report.pdf";
			$dattime = date('d-m-Y H:i:s');
		$footer = '<table width="700" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
		  <tr>
		    <td align="right" colspan="3" class="signature"><small><i>Printed on: '.$dattime.'</i></small></td>	
		  </tr>
		  </table>';
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$footer1 = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');	
		$this->m_pdf->pdf->SetHTMLFooter($footer1);		
			
			$mpdf=new mPDF();

			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
		
    }
	//common pdf generation
	public function all_faculty_report_pdf($semester, $stream, $div,$fbdses, $cycle){
		
		$role_id = $this->session->userdata('role_id');
		$this->load->model('Subject_model');  
		$this->load->model('Timetable_model');  
		$this->load->view('header',$this->data);           	                                        
		$this->data['division']=$div;
		$this->data['semester']=$semester;
		// load subjects of semester
		$this->data['active_session']= $this->Feedback_model->active_academic_session();
		$this->data['sub']= $this->Feedback_model->fetch_student_subjects_org($semester, $stream, $div, $fbdses);
		$streamid = $this->data['sub'][0]['stream_id'];
		$this->data['StreamSrtName'] = $this->Feedback_model->getStreamShortName($stream);
		$this->data['questions']=$this->Feedback_model->get_feedback_questions(); 
		//print_r($this->data['sub']);exit;
		$html="    <style>  
            table {  
                font-family: arial, sans-serif;  
                border-collapse: collapse;  
                width: 100%; font-size:12px; xmargin:0 auto;
            }  
      td{vertical-align: top;}
                      
            .signature{
            text-align: center;
            }
            .marks-table{
            width: 100%;xxheight:650px;
            }
            p{padding:0px;margin:0px;}
            h1, h3{margin:0;padding:0}
            .marks-table td{height:30px;vertical-align:middle;}
            .marks-table th{height:30px;}
.content-table tr td{border:1px solid #333;vertical-align:middle;}
.content-table th{border-left:1px solid #333;border-right:1px solid #333;border-bottom:1px solid #333;}
        </style> ";
		for($i=0;$i<count($this->data['sub']); $i++){
			
			$subid = $this->data['sub'][$i]['subject_code'];
			$faculty_code = $this->data['sub'][$i]['faculty_code'];
			$this->data['sub'][$i]['fb']= $this->Feedback_model->fetch_feedback_subjects_to_admin($subid, $semester, $stream, $div,$faculty_code,$fbdses, $cycle);	
			
			$this->data['subj'] = $this->Feedback_model->getsubdetails($subid);
			$this->data['fac'] = $this->Feedback_model->getfacdetails($faculty_code);	
			$this->data['marks'] = $this->Feedback_model->fetch_feedback_report($subid, $semester, $stream, $div,$faculty_code, $cycle);

			if($this->data['sub'][$i]['fb'][0]['feedback_id'] !=''){
							

			$html .= $this->load->view($this->view_dir.'all_faculty_feedback_report_pdf',$this->data, true);
			}
			ob_clean();
			 unset($subid);
			 unset($faculty_code);
		}
		
		//echo $html;exit;
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '-1');
		$this->load->library('m_pdf');

		$pdfFilePath ="Feedback_Report_Common.pdf";
		$dattime = date('d-m-Y H:i:s');
		$footer = '<table width="700" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
		  <tr>
		    <td align="right" colspan="3" class="signature"><small><i>Printed on: '.$dattime.'</i></small></td>	
		  </tr>
		  </table>';
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$footer1 = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');	
		$this->m_pdf->pdf->SetHTMLFooter($footer1);		
		$this->m_pdf->pdf->AddPage();
		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");	
	}	
	
	// download Excel report	
	public function download_excel($stud_details)
    {
		//error_reporting(E_ALL); 
			$stud_det = base64_decode($stud_details);
			$subject_det = explode('~',$stud_det);
			$stream=$subject_det[0];
			$semester=$subject_det[1];
			$this->data['division']=$subject_det[2];
			$this->data['semester']=$subject_det[1];
			$subid=$subject_det[3];
			$faculty_code=$subject_det[4];
			$div=$subject_det[2];
	$this->data['active_session']= $this->Feedback_model->active_academic_session();
			$this->data['StreamSrtName'] = $this->Feedback_model->getStreamShortName($subject_det[0]);
			//print_r($this->data['StreamSrtName']);exit;
			$this->data['sub'] = $this->Feedback_model->getsubdetails($subject_det[3]);
			$this->data['fac'] = $this->Feedback_model->getfacdetails($subject_det[4]);
			$this->data['questions']=$this->Feedback_model->get_feedback_questions(); 
			
			$this->data['marks']= $this->Feedback_model->fetch_studentwise_report($subid, $semester, $stream, $div,$faculty_code);
			$html = $this->load->view($this->view_dir.'faculty_feedback_report_excel',$this->data);

		
    }
	// download feedback summary report pdf
	public function download_summary_report($stud_details){
		//$this->load->model('Marks_model');  
		
		$row=array();
		$stud_det = base64_decode($stud_details);
		//print_r($stud_det);exit;
		$subject_det = explode('~',$stud_det);
		$stream=$subject_det[0];
		$semester=$subject_det[1];
		$this->data['division']=$subject_det[2];
		$this->data['semester']=$subject_det[1];
		$subid=$subject_det[3];
		$faculty_code=$subject_det[4];
		$div=$subject_det[2];
		$row['academic_year']='2017-18';
		$row['academic_type']='W';
			
		$row['feedback_date']=date('Y-m-d');
		$row['from_ip']=$_SERVER['REMOTE_ADDR'];
            
		$this->data['StreamSrtName'] = $this->Feedback_model->getStreamShortName($subject_det[0]);
		//print_r($this->data['StreamSrtName']);exit;
		$this->data['sub']= $this->Feedback_model->fetch_student_subjects_org($semester, $stream, $div);
		$this->data['active_session']= $this->Feedback_model->active_academic_session();
		
		
		for($i=0;$i<count($this->data['sub']); $i++){
			$subid = $this->data['sub'][$i]['subject_code'];
			$faculty_code = $this->data['sub'][$i]['faculty_code'];
			$this->data['sub'][$i]['fb']= $this->Feedback_model->fetch_feedback_subjects_to_admin($subid, $semester, $stream, $div,$faculty_code);	
			$this->data['sub'][$i]['mrks']= $this->Feedback_model->fetch_mrk_reports($subid, $semester, $stream, $div,$faculty_code);
		}
		
		$this->load->library('m_pdf');
		$html = $this->load->view($this->view_dir.'feedback_summary_report_pdf',$this->data, true);
		$html .= $this->load->view('footer',$this->data, true);
		$pdfFilePath1 ="Feedback_summary_report.pdf";
		$dattime = date('d-m-Y H:i:s');
		$footer = '<table width="700" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
		  <tr>
		    <td align="right" colspan="3" class="signature"><small><i>Printed on: '.$dattime.'</i></small></td>	
		  </tr>
		  </table>';
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$footer1 = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');	
		$this->m_pdf->pdf->SetHTMLFooter($footer1);		
			
		$mpdf=new mPDF();

		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath1, "D");
		
	}
	// for admin 
	public function facultywise_feedback_report($tt_id=''){
		$role_id = $this->session->userdata('role_id');
		$this->load->model('Subject_model');  
		$this->load->model('Timetable_model');  
		$this->load->view('header',$this->data);           	                                        
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['school_details']= $this->Timetable_model->getSchools();
		//print_r($this->data['school_details']);exit;

		$this->data['school_id']=$_POST['school_id'];
		$this->data['dept_id']= $_POST['dept_id'];
			
		$school_id= $_POST['school_id'];
		$dept_id = $_POST['dept_id'];
		//error_reporting(E_ALL); ini_set('display_errors', 1);
		
		// load subjects of semester
		$this->data['fac']= $this->Feedback_model->load_faculty($school_id, $dept_id);
		//print_r($this->data['fac']);exit;
		for($j=0;$j<count($this->data['fac']); $j++){
			$faculty_code = $this->data['fac'][$j]['emp_id'];
			$sub = $this->Feedback_model->getFacultySubjects($faculty_code);
			//print_r($sub);
			//echo "<pre>";
			for($i=0;$i<count($sub); $i++){
				$subid = $sub[$i]['subject_id'];
				$this->data['fac'][$j]['mrks'][$i]= $this->Feedback_model->fetch_fac_mrk_reports($subid, $faculty_code);
			}
		}
		$this->load->view($this->view_dir.'facultywise_feedback_report',$this->data);
		$this->load->view('footer');
	}
	// load Department
	public function load_department(){
		$this->load->model('Timetable_model');
		$school_id = $_POST['school_id'];
		$this->data['emp']= $this->Timetable_model->load_department($school_id);
	}
	// facultywise feedback report pdf download
	//common pdf generation
	public function facultywise_report_pdf($faculty_id){

		$faculty_code = base64_decode($faculty_id);
		$obj = New Consts();
		$cursession = $obj->fetchCurrSession();
		if($cursession=='WIN'){
			$this->data['cursess'] ="Winter"; 
		}else{
			$this->data['cursess'] ="Summer";
		}  	                                        
		// load subjects of semester
		$this->data['sub'] = $this->Feedback_model->getFacultyFeedbackSubjects($faculty_code);
		$this->data['subjects'] =$this->data['sub'];
		$this->data['fac'] = $this->Feedback_model->get_faculty($faculty_code);

		for($i=0;$i<count($this->data['sub']); $i++){
			$subid = $this->data['sub'][$i]['subject_id'];
			$this->data['sub']['mrks'][$i]= $this->Feedback_model->fetch_fac_mrk_reports($subid, $faculty_code);
			
		}

		$html = $this->load->view($this->view_dir.'facultywise_feedback_report_pdf',$this->data, true);

		//echo $html;exit;
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '-1');
		$this->load->library('m_pdf');

		$pdfFilePath ="Facultywise_Feedback_Report.pdf";
		$dattime = date('d-m-Y H:i:s');
		$footer = '<table width="700" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
		  <tr>
		    <td align="right" colspan="3" class="signature"><small><i>Printed on: '.$dattime.'</i></small></td>	
		  </tr>
		  </table>';
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$footer1 = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');	
		$this->m_pdf->pdf->SetHTMLFooter($footer1);				
		$this->m_pdf->pdf->AddPage();
		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");	
	}	
// view 
	public function faculty_feedback_report_view($stream_id='', $semester='', $division='',$course_id,$ses='', $cycle=''){
	//error_reporting(E_ALL);
		$role_id = $this->session->userdata('role_id');
		$this->load->model('Subject_model');  
		$this->load->model('Timetable_model');  
		
		$this->load->view('header',$this->data);           	                                        
        $this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['school_details']= $this->Timetable_model->getSchools();
		
		if($stream_id !='' && $semester!=''){

		$this->data['streamId']=$stream_id;
		$this->data['semester']=  $semester;
		$this->data['division']= $division;
		$this->data['fbdses']= $ses;
		$this->data['cycle']= $cycle;
		$semester=  $semester;
		$stream = $stream_id;
		$div = $division;
		}else{
		$this->data['streamId']=$_POST['stream_id'];
		$this->data['semester']= $_POST['semester'];
		$this->data['division']= $_POST['division'];	
		$semester= $_POST['semester'];
		$stream = $_POST['stream_id'];
		$div = $_POST['division'];
		}
		
		// load subjects of semester
		$this->data['sub']= $this->Feedback_model->fetch_student_subjects_org($semester, $stream, $div,$ses);
		//print_r($this->data['sub']);
		for($i=0;$i<count($this->data['sub']); $i++){
			 $subid = $this->data['sub'][$i]['subject_code'];//echo  '<br>';
			 $faculty_code = $this->data['sub'][$i]['faculty_code'];//echo  '<br>';
			
			$this->data['sub'][$i]['fb']= $this->Feedback_model->fetch_feedback_subjects_to_admin($subid, $semester, $stream, $div,$faculty_code,$ses, $cycle);
			$this->data['sub'][$i]['mrks']= $this->Feedback_model->fetch_mrk_reports($subid, $semester, $stream, $div,$faculty_code,$ses, $cycle);
		}
		//exit;
		
        $this->load->view($this->view_dir.'faculty_feedback_score_view',$this->data);
        $this->load->view('footer');
	}
	
	
	
	public function faculty_feedback_report_view_pdf($stud_details, $cycle){
	//error_reporting(E_ALL);
		$role_id = $this->session->userdata('role_id');
		$this->load->model('Subject_model');  
		$this->load->model('Timetable_model');  
		
		//$this->load->view('header',$this->data);           	                                        
      //  $this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		//$this->data['school_details']= $this->Timetable_model->getSchools();
		
		 $stud_det = base64_decode($stud_details);
		// print_r($stud_det); //exit;
		 $subject_det = explode('~',$stud_det);
		
		 $streamId=$subject_det[0];//echo '<br>';
		 $semester=$subject_det[1];//echo '<br>';
         $division=$subject_det[2];//echo '<br>';
		 $fbdses=$subject_det[3];//echo '<br>';
		 $fdses=$subject_det[4];//echo '<br>';
		 
		 $this->data['streamId']=$streamId;
		 $this->data['semester']=$semester;
		 $this->data['division']=$division;
		 $this->data['fbdses']=$fbdses;
		 $this->data['fdses']=$fdses;
		 
		 $semester=  $semester;
		 $stream = $streamId;
		 $div = $division;
		 $ses=$fbdses.'~'.$subject_det[4];
		
		
		// load subjects of semester
		$this->data['sub']= $this->Feedback_model->fetch_student_subjects_org($semester, $stream, $div,$ses);
		//print_r($this->data['sub']);exit;
		for($i=0;$i<count($this->data['sub']); $i++){
			 $subid = $this->data['sub'][$i]['subject_code'];//echo  '<br>';
			 $faculty_code = $this->data['sub'][$i]['faculty_code'];//echo  '<br>';
			
			$this->data['sub'][$i]['fb']= $this->Feedback_model->fetch_feedback_subjects_to_admin($subid, $semester, $stream, $div,$faculty_code,$ses,$cycle);
			$this->data['sub'][$i]['mrks']= $this->Feedback_model->fetch_mrk_reports($subid, $semester, $stream, $div,$faculty_code,$ses,$cycle);
		}
		//exit;
		
		    $this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'faculty_feedback_score_view_pdf',$this->data, true);
			$html .= $this->load->view('footer',$this->data, true);
			$pdfFilePath1 ="Feedback_Report.pdf";
			$dattime = date('d-m-Y H:i:s');
		$footer = '<table width="700" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
		  <tr>
		    <td align="right" colspan="3" class="signature"><small><i>Printed on: '.$dattime.'</i></small></td>	
		  </tr>
		  </table>';
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$footer1 = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');	
		$this->m_pdf->pdf->SetHTMLFooter($footer1);		
			
			$mpdf=new mPDF();

			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
		
        //$this->load->view($this->view_dir.'faculty_feedback_score_view',$this->data);
       // $this->load->view('footer');
	}
	
	
	    public function Factilywise_report(){
		//error_reporting(E_ALL);
		$role_id = $this->session->userdata('role_id');
		$this->load->model('Subject_model');  
		$this->load->model('Timetable_model');  
		
		$this->load->view('header',$this->data);           	                                        
      //  $this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		//$this->data['school_details']= $this->Timetable_model->getSchools();
		//$this->data['school_details']= $this->Timetable_model->getSchools();
		$this->data['schools']= $this->Feedback_model->fetch_feedback_schools();
		$this->data['fbsession']= $this->Feedback_model->fetch_feedback_session();
		
		//getfacdetails_all();
	//	exit;
		$select_School = $_POST['select_School'];
		if(!empty($_POST)){
			$sesdetails = explode('~', $_POST['fbsession']);
		
			$this->data['fbschool'] = $_POST['fbschool'];
			//$this->data['fbses'] = $_POST['fbsession'];
			
			
			if(!empty($_POST['fbschool'])){
				$school = $_POST['fbschool'];
			}else{
				$school='';
			}
			
		    $academic_type = $sesdetails[0];
			$academic_year = $sesdetails[1];
			
			$this->data['academic_type'] = $academic_type;
			$this->data['academic_year'] = $academic_year;
			$this->data['fbses']=$academic_type.'~'.$academic_year;
			$this->data['select_School']=$select_School;
			$this->data['school'] = $school;
			$this->data['getfacdetails_all']=$this->Feedback_model->get_facultybyschool($_POST['fbsession'],$select_School);
			
			//$this->data['class']= $this->Feedback_model->fetch_classwise_summary($academic_type, $academic_year,$school);
			$this->data['sub']= $this->Feedback_model->Factilywise_report($academic_type, $academic_year,$select_School,$school);
	
	//exit;
	         for($i=0;$i<count($this->data['sub']); $i++){
			 $subid = $this->data['sub'][$i]['subject_code'];//echo  '<br>';
			//$this->data['sub']['subid'] = $this->data['sub'][$i]['subject_code'];
			//$this->data['sub']['faculty_code'] = $this->data['sub'][$i]['faculty_code'];
			$faculty_code = $this->data['sub'][$i]['faculty_code'];//echo  '<br>';

			$this->data['sub'][$i]['fb']= $this->Feedback_model->fetch_feedback_fsubjects_to_admin($subid, $faculty_code, $academic_type);
			$this->data['sub'][$i]['mrks']= $this->Feedback_model->Fetch_mark_fwise($subid, $faculty_code, $academic_type);
		}
	
	        
	
		}
		   // $this->data['academic_type'] = $academic_type;
			//$this->data['academic_year'] = $academic_year;
			//$this->data['select_School']=$select_School;
			//$this->data['school'] = $school;
		
		//exit;
		// load subjects of semester
		//$this->data['sub']= $this->Feedback_model->fetch_student_subjects_org($semester, $stream, $div,$ses);
	//	$this->data['sub']= $this->Feedback_model->Factilywise_report();
		//print_r($this->data['sub']);
		
		
		
		//exit;
		
		/*for($j=0;$j<count($this->data['sub']); $j++){
			$faculty_code = $this->data['sub'][$j]['emp_id'];
			$sub = $this->Feedback_model->getFacultySubjects($faculty_code);
			//print_r($sub);
			//echo "<pre>";
			for($i=0;$i<count($sub); $i++){
				$subid = $sub[$i]['subject_id'];
				$this->data['sub'][$j]['mrks'][$i]= $this->Feedback_model->fetch_fac_mrk_reports($subid, $faculty_code);
			}
		}*/
		
		
        $this->load->view($this->view_dir.'Faculty_wise_report',$this->data);
        $this->load->view('footer');
	
		
	}
	
	 public function Factilywise_report_pdf($stud_details){
		//error_reporting(E_ALL);
		$role_id = $this->session->userdata('role_id');
		$this->load->model('Subject_model');  
		$this->load->model('Timetable_model');  
		
		$this->load->view('header',$this->data);           	                                        
      //  $this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
	//	$this->data['school_details']= $this->Timetable_model->getSchools();
		//$this->data['school_details']= $this->Timetable_model->getSchools();
		//$this->data['fbsession']= $this->Feedback_model->fetch_feedback_session();
		//$this->data['getfacdetails_all']=$this->Feedback_model->getfacdetails_all();
		//exit;
		//$stud_details=$_request[];
		$stud_det = base64_decode($stud_details);
		//print_r($stud_det);exit;
		$subject_det = explode('~',$stud_det);
		
		 $academic_type=$subject_det[0];//echo '<br>';
		 $academic_year=$subject_det[1];//echo '<br>';
         $school=$subject_det[2];//echo '<br>';
		 $select_School = $subject_det[3];
		 
		 $this->data['academic_type']=$academic_type;
		 $this->data['academic_year']=$academic_year;
		 $this->data['school']=$school;
		 $this->data['fbses']=$academic_type.'~'.$academic_year;
		 $this->data['select_School']=$select_School;
		 //$this->data['school'] = $school;
		//$pdf=$subject_det[1];
			//exit;
		//$academic_type ='';
		//$academic_year ='';
		//$school='';
		 $this->data['sub']= $this->Feedback_model->Factilywise_report($academic_type, $academic_year,$select_School,$school);
//}
		
		// load subjects of semester
		//$this->data['sub']= $this->Feedback_model->fetch_student_subjects_org($semester, $stream, $div,$ses);
	//	$this->data['sub']= $this->Feedback_model->Factilywise_report();
		//print_r($this->data['sub']);exit;
		for($i=0;$i<count($this->data['sub']); $i++){
			 $subid = $this->data['sub'][$i]['subject_code'];//echo  '<br>';
			//$this->data['sub']['subid'] = $this->data['sub'][$i]['subject_code'];
			//$this->data['sub']['faculty_code'] = $this->data['sub'][$i]['faculty_code'];
			$faculty_code = $this->data['sub'][$i]['faculty_code'];//echo  '<br>';

			$this->data['sub'][$i]['fb']= $this->Feedback_model->fetch_feedback_fsubjects_to_admin($subid, $faculty_code, $academic_type);
			$this->data['sub'][$i]['mrks']= $this->Feedback_model->Fetch_mark_fwise($subid, $faculty_code, $academic_type);
		}
		
		
		/*for($j=0;$j<count($this->data['sub']); $j++){
			$faculty_code = $this->data['sub'][$j]['emp_id'];
			$sub = $this->Feedback_model->getFacultySubjects($faculty_code);
			//print_r($sub);
			//echo "<pre>";
			for($i=0;$i<count($sub); $i++){
				$subid = $sub[$i]['subject_id'];
				$this->data['sub'][$j]['mrks'][$i]= $this->Feedback_model->fetch_fac_mrk_reports($subid, $faculty_code);
			}
		}*/
		
		
		
		 //if($_POST['pdf']=="YES"){
		    $this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'Faculty_wise_report_pdf',$this->data, true);
			$html .= $this->load->view('footer',$this->data, true);
			$pdfFilePath1 ="Feedback_Report.pdf";
			$dattime = date('d-m-Y H:i:s');
		$footer = '<table width="700" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
		  <tr>
		    <td align="right" colspan="3" class="signature"><small><i>Printed on: '.$dattime.'</i></small></td>	
		  </tr>
		  </table>';
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$footer1 = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');	
		$this->m_pdf->pdf->SetHTMLFooter($footer1);		
			
			$mpdf=new mPDF();

			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
		//}else{
		
		
		
		
       // $this->load->view($this->view_dir.'Faculty_wise_report',$this->data);
        //$this->load->view('footer');
		//}
		
		
		
	}
    // excel report download
	function fb_studentwise_excel_report($stream_id='', $semester='', $division=''){
		//echo "<pre>";
		$semester=  $semester;
		$stream = $stream_id;
		$div = $division;
		$this->data['semester']=  $semester;
		$this->data['division']= $division;
		
		$this->data['fbsession']= $this->Feedback_model->fetch_feedback_session();
		$this->data['strmdetails'] = $this->Feedback_model->getStreamShortName($stream);
		$stream_code = $this->data['strmdetails'][0]['stream_code'];
		$batch_code = $stream_code.'-'.$div;
       	$this->data['class_stud']= $this->Feedback_model->fetch_classwise_student_count($batch_code, $semester);
		$this->data['studcnt_submitted']= $this->Feedback_model->fetch_fbsubmitted_student_count($stream_id, $semester, $division);
        
		$this->load->view($this->view_dir.'fb_submitted_studentwise_status_excel_report',$this->data);
		

	}
    public function grievance()
    {
         $this->data['category']=$this->Feedback_model->esuggestion_category();
		 $this->data['esuggestions']=$this->Feedback_model->fetch_esuggestions($this->session->userdata('name'), $this->session->userdata('role_id'));
		 $today = date('Y-m-d');
		 $this->data['es_categ']=$this->Feedback_model->fetchcomments($this->session->userdata('name'),$today, $this->session->userdata('role_id'));
		 
		 foreach($this->data['es_categ'] as $catg){
			 $category[] =$catg['category'];
		 }
		 
		$this->data['added_category'] =$category;
        if($_POST){
             $this->load->view('header',$this->data);   
            $row=array();
             $row=$_POST;
            $row['suggestion_date']=date('Y-m-d');
            $row['from_ip']=$_SERVER['REMOTE_ADDR'];
            $row['entry_on']=date('Y-m-d h:m:i');
            $row['prn']=$this->session->userdata('name');
			$row['role_id']=$this->session->userdata('role_id');
            
            $count=$this->Feedback_model->check_esuggestion($row);
          //echo $count;exit();
            if($count>0){
                 $this->session->set_flashdata('exist',"Y");
			}else{
              //print_r($row);exit();
              $res=$this->Feedback_model->post_esuggestion($row);
               if($res>0){
                  $this->session->set_flashdata('msg',"1");
				  redirect('Feedback/grievance');
               }
               else
               {
                  $this->session->set_flashdata('msg',"0");
				  redirect('Feedback/grievance');
                  
               }
			}
                $this->load->view($this->view_dir.'grievance',$this->data);
				$this->load->view('footer',$this->data);   
            
        }
        else
        {           
        $this->load->view('header',$this->data);   
        $this->load->view($this->view_dir.'esuggestion',$this->data);
        $this->load->view('footer',$this->data);
            
        }
          
         
    }
    public function esuggestion_list()
    {
        $this->data['category']=$this->Feedback_model->esuggestion_category();
		$this->data['esuggestions']=$this->Feedback_model->fetch_Allesuggestions();         
        $this->load->view('header',$this->data);   
        $this->load->view($this->view_dir.'esuggestion_list',$this->data);
        $this->load->view('footer',$this->data);    
    }
    public function fetch_escatwise_list()
    {
		$category =$_POST['category'];
		$type =$_POST['type'];
		$this->data['type'] =$_POST['type'];
        $this->data['category']=$this->Feedback_model->esuggestion_category();
		$this->data['esuggestions']=$this->Feedback_model->fetch_Allesuggestions($category,$type);         
        $this->load->view($this->view_dir.'ajxesuggestion_list',$this->data);  
    }
	
	 public function stud_list($offSet=0)
    {
        $this->load->model('Exam_timetable_model');
		$this->load->model('Timetable_model');
        $this->load->view('header',$this->data);        
        //$total= $this->Ums_admission_model->getAllStudents();
        //$this->data['emp_list']= $this->Ums_admission_model->getStudents($offSet,$limit);
		$college_id = 1;
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
		$this->data['schools']= $this->Exam_timetable_model->getSchools();
		//$this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
        $this->load->view($this->view_dir.'student_list',$this->data);
        $this->load->view('footer');
    }
	function load_studentlist()
	{
	   $this->load->model('Ums_admission_model');
	   // error_reporting(E_ALL);
	      $data['emp_list']= $this->Feedback_model->getStudentsajax($_POST['acourse'],$_POST['astream'],$_POST['ayear'],$_POST['acdyear'], $_POST['cycle']);
	       $data['dcourse']= $_POST['acourse'];
		   $data['dstream']= $_POST['astream'];
	       $data['dyear']= $_POST['acdyear'];
		   $data['fbcycle']= $_POST['cycle'];
	       $data['hide']= $_POST['hide'];
	       
	       
	//  print_r($data['emp_list']);
	   $html = $this->load->view($this->view_dir.'load_studentdata',$data,true);
	   echo $html;
	}
//////////////////////////////////////////////
   function general(){
	   //error_reporting(E_ALL);
		$obj = New Consts();
		$cursession = $obj->fetchCurrSession();
		$curyear=$obj->fetchCurrSessionacademic();
		$academicyear=$curyear[0]['academic_year'];
		$curyearr=explode('-',$academicyear);
	
		$stud_enroll_no = $this->session->userdata("name");
		$this->load->view('header',$this->data); 
		$this->load->model('Subject_model');
		// fetch student details like stream,semester,div,batch
		$stud_det= $this->Feedback_model->fetch_stud_details($stud_enroll_no);
		
		$this->data['host']= $this->Feedback_model->fetch_stud_facility_status($type=1,$stud_det[0]['enrollment_no'],$curyearr[0]);// hostel
		$this->data['trans']= $this->Feedback_model->fetch_stud_facility_status($type=2,$stud_det[0]['enrollment_no'],$curyearr[0]); // transport
		$this->data['canteen']= $this->Feedback_model->fetch_stud_facility_status($type=3,$stud_det[0]['enrollment_no'],$curyearr[0]); // canteen

		$feedback = $this->Feedback_model->check_student_feedback_cht($cursession,$stud_det[0]['stud_id']);
		if($feedback['feedback_id']!='')
		{
		  $this->data['feedback1']  ='Y';
		}
		else
		{
			 $this->data['feedback1']  ='N'; 
		}
			
		$this->data['course_short_name']= $stud_det[0]['course_short_name'];
		$this->data['stream_name']= $stud_det[0]['stream_short_name'];
		$this->data['stream']= $stud_det[0]['admission_stream'];
		$this->data['semester']= $stud_det[0]['current_semester'];
		$this->data['student_id']= $stud_det[0]['stud_id'];		
		$semester= $stud_det[0]['current_semester'];
		$stream = $stud_det[0]['admission_stream'];
		$div = $this->Feedback_model->fetch_student_division($stud_det[0]['stud_id'], $stream,$semester);
		$this->data['division']= $div['division'];
		$this->data['questions']=$this->Feedback_model->get_feedback_questions_cht();  
		for($i=0;$i<count($this->data['questions']); $i++){
			$ques_id = $this->data['questions'][$i]['ques_id'];
			$this->data['questions'][$i]['sub_question']= $this->Feedback_model->fetch_sub_question($ques_id);
		}
        $this->load->view($this->view_dir.'cant_host_trans_student_feedback',$this->data);
        $this->load->view('footer');	
	}
    /////////////////////////
   public function submit_fdbcht($stud_det)
    {
       
		$obj = New Consts();
		$cursession = $obj->fetchActiveSession_feedback();
		$actses = explode('~',$cursession);
		if(!empty($_POST)){

		//$this->data['questions']=$this->Feedback_model->get_feedback_questions_cht();  
		$k=0;
		$row=array();
		
		$typarr =explode(',' ,$_POST['typ_arr']); 
		//print_r($typarr);exit;
		foreach($typarr as $que){
			$ques_id = $que;
			$subdata = $this->Feedback_model->fetch_sub_question($ques_id);
				$row['stream_id']=$_POST['hcourse'];
				$row['semester']=$_POST['hsem'];
				$row['division']=$_POST['hdiv'];
				$row['question_category']=$ques_id;
				$row['student_id']=$_POST['hstdid'];
				$row['Q1']= $_POST["Q1_".$ques_id];
				$row['Q2']= $_POST["Q2_".$ques_id];
				$row['Q3']= $_POST["Q3_".$ques_id];
				$row['Q4']= $_POST["Q4_".$ques_id];
				$row['Q5']= $_POST["Q5_".$ques_id];
				
				$row['academic_type']= $actses[0];
				$row['academic_year']=$actses[1];
				$row['feedback_cycle']=$actses[2];
				
				$row['feedback_date']=date('Y-m-d H:i:s');
				$row['from_ip']=$_SERVER['REMOTE_ADDR'];
				$res=$this->Feedback_model->post_student_fedback_cht($row);
				unset($row);
			}
			//	exit();
				$studdet = base64_decode($stud_det);
				$this->data['stud_det'] = $studdet;
				if($res>0){
				  $this->session->set_flashdata('msg',"2");
				  redirect('feedback/general');
				}
				else
				{
				  $this->session->set_flashdata('msg',"0");
				  
				}
				$this->data['stud_det'] = $_POST['subject_det'];
				$this->load->view('header',$this->data); 
				$this->load->view($this->view_dir.'cant_host_trans_student_feedback',$this->data);
				$this->load->view('footer',$this->data);  
		}
    }	
	public function load_courses_for_studentlist()
	{    
	   $course_details =  $this->Feedback_model->load_courses_for_studentlist($_POST['academic_year'], $_POST['school_code']);  
	   $opt ='<option value="">Select Course</option>';
	   //$opt .='<option value="0">ALL</option>';
	   foreach ($course_details as $course) {

			$opt .= '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
		}
			echo $opt;
	}
	public function load_streams_student_list()
	{    
		$stream_details= $this->Feedback_model->load_streams_student_list($_POST);
		$opt ='<option value="">Select Stream</option>';
		$opt .='<option value="0">ALL</option>';
	   foreach ($stream_details as $str) {

			$opt .= '<option value="' . $str['stream_id'] . '"' . $sel . '>' . $str['stream_name'] . '</option>';
		}
		echo $opt;		
	}
	
	public function load_streams_Faculty_list()
	{    
	//print
	$fbsession=$_POST['fbsession'];
	$School=$_POST['School'];
		$stream_details= $this->Feedback_model->get_facultybyschool($fbsession,$School);
		//$opt ='<option value="">Select Stream</option>';
		$opt ='<option value="">ALL</option>';
		
		foreach($stream_details as $sch){
												$schvalue = $sch['emp_id'];
												
												//$actses1 = $actses[0];
											/*	if($schvalue == $fbschool){
													$sel = "selected";
												} else{
													$sel = '';
												}*/
												if($sch['gender']=='male'){
												$sex = 'Mr.';
											    }else{
												$sex = 'Mrs.';
											    }
					$opt .=  '<option value="' . $schvalue . '">'.$sex.' '.$sch['fname'].' '.$sch['lname'].' </option>';
											}
		
		
	   /*foreach ($stream_details as $str) {

			$opt .= '<option value="' . $str['stream_id'] . '"' . $sel . '>' . $str['stream_name'] . '</option>';
		}*/
		echo $opt;		
	}
	
	
	
	public function stud_fd_status_excel($school,$streamid='',$acdyear='',$cycle){
		$this->data['emp_list']= $this->Feedback_model->getStudentsajax($school,$streamid,$year='',$acdyear,$cycle); 
		$this->load->view('Feedback/fd_status_excel_view.php',$this->data);  
  }		
  
  
  public function Hostel_Cateen_Transportation(){
	  //error_reporting(E_ALL);
		//ini_set("error_reporting", E_ALL); 
		$role_id = $this->session->userdata('role_id');
		        	                                        
		$this->data['fbsession']= $this->Feedback_model->fetch_feedback_session();
		$this->data['schools']= $this->Feedback_model->fetch_feedback_schools();
		$obj = New Consts();
		$cursession = $obj->fetchActiveSession_feedback();
		$this->data['actses'] =$cursession;
		// load subjects of semester
		if(!empty($_POST)){
			$sesdetails = explode('~', $_POST['fbsession']);
			$this->data['fbschool'] = $_POST['fbschool'];
			$this->data['fbses'] = $_POST['fbsession'];
			if(!empty($_POST['fbschool'])){
				$school = $_POST['fbschool'];
			}else{
				$school='';
			}
			$academic_type = $sesdetails[0];
			$academic_year = $sesdetails[1];
			$this->data['class']= $this->Feedback_model->fetch_classwise_summary($academic_type, $academic_year,$school);
		}
		
		for($i=0; $i<count($this->data['class']); $i++){
			$stream_id = $this->data['class'][$i]['stream_id'];
			$stream_code = $this->data['class'][$i]['stream_code'];
			$division = $this->data['class'][$i]['division'];
			$semester = $this->data['class'][$i]['semester'];
			$batch_code = $stream_code.'-'.$division;
			$this->data['class'][$i]['class_studcnt']= $this->Feedback_model->fetch_classwise_student_count($stream_id, $division, $semester,$academic_year);//exit;
			//$this->data['class'][$i]['fdappeared_studcnt']= $this->Feedback_model->fetch_classwise_fdapperedstudent_count($stream_id, $division, $semester,$academic_year);
			$this->data['class'][$i]['studcnt_submitted']= $this->Feedback_model->fetch_fbsubmitted_student_count($stream_id, $semester, $division,$academic_year,$academic_type);
		}
		

		
		$this->load->view('header',$this->data);   
       // $this->load->view($this->view_dir.'faculty_feedback_summary_view',$this->data);
	     $this->load->view($this->view_dir.'Hostel_Cateen_Transportation',$this->data);
        $this->load->view('footer');
	  
  }
  
  public function check_report(){
	  $DB1 = $this->load->database('icdb', TRUE); 
	  $sql="SELECT sj.reg_id,sj.reg_no,sj.exam_no,sj.exam_date,sj.exam_type,sj.exam_center,sj.pref_location,sj.perf_location_name, c.city_name,s.state_name,e.exam_name, SRD.ic_code,im.institute_name FROM su_jee_registration AS sj LEFT JOIN student_meet_details AS SRD ON SRD.id = sj.reg_id LEFT JOIN state_master s ON s.state_id=SRD.state_id LEFT JOIN city_master c ON c.city_id=SRD.city_id LEFT JOIN exam_master e ON e.exam_id=SRD.exam_id LEFT JOIN event_details evd ON evd.event_code=SRD.event_code LEFT JOIN institute_master im ON im.institue_id=evd.institue_id WHERE SRD.ic_code='SU_MH_007' AND sj.exam_type LIKE '%OF%' AND sj.is_term_confirmed='Y' AND sj.`exam_date` IN ('2019-04-20','2019-04-21') ";
	   $query3 = $DB1->query($sql);
	   //$DB1->count_all_results();
	 $data3=$query3->result_array();
	echo '<pre>'; print_r($data3);
  }
  ///////
	public function Factilywise_attendance_report(){
		//error_reporting(E_ALL);
		$role_id = $this->session->userdata('role_id');
		$this->load->model('Subject_model');  
		$this->load->model('Timetable_model');  
		
		$this->load->view('header',$this->data);           	                                        
      //  $this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		//$this->data['school_details']= $this->Timetable_model->getSchools();
		//$this->data['school_details']= $this->Timetable_model->getSchools();
		$this->data['schools']= $this->Feedback_model->fetch_feedback_schools();

		$this->data['fbsession']= $this->Feedback_model->fetch_feedback_session();
		
		//getfacdetails_all();
	//	exit;
		$select_School = $_POST['select_School'];
		if(!empty($_POST)){
			$sesdetails = explode('~', $_POST['fbsession']);
		
			$this->data['fbschool'] = $_POST['fbschool'];
			$this->data['fbcycle'] = $_POST['fbcycle'];
			
			
			if(!empty($_POST['fbschool'])){
				$school = $_POST['fbschool'];
			}else{
				$school='';
			}
			
		    $academic_type = $sesdetails[0];
			$academic_year = $sesdetails[1];
			$cycle = $_POST['fbcycle'];
			$this->data['academic_type'] = $academic_type;
			$this->data['academicyear']=$_POST['fbsession'];
			$this->data['academic_year'] = $academic_year;
			$this->data['fbses']=$academic_type.'~'.$academic_year;
			$this->data['select_School']=$select_School;
			$this->data['school'] = $school;
			$this->data['getfacdetails_all']=$this->Feedback_model->get_facultybyschool($_POST['fbsession'],$select_School);
			
			//$this->data['class']= $this->Feedback_model->fetch_classwise_summary($academic_type, $academic_year,$school);
			$this->data['sub']= $this->Feedback_model->Factilywise_report($academic_type, $academic_year,$select_School,$school);
	
	//exit;
	         for($i=0;$i<count($this->data['sub']); $i++){
			 $subid = $this->data['sub'][$i]['subject_code'];//echo  '<br>';
			 $stream_id = $this->data['sub'][$i]['stream_id'];
			 $division = $this->data['sub'][$i]['division']; 
			 $semester = $this->data['sub'][$i]['semester'];
			//$this->data['sub']['subid'] = $this->data['sub'][$i]['subject_code'];
			//$this->data['sub']['faculty_code'] = $this->data['sub'][$i]['faculty_code'];
			$faculty_code = $this->data['sub'][$i]['faculty_code'];//echo  '<br>';

			$this->data['sub'][$i]['fb']= $this->Feedback_model->fetch_feedback_fsubjects_to_admin_attendance($subid, $faculty_code, $academic_type,$academic_year,$cycle,$semester,$division);
			/*	echo "<pre>";
			print_r($this->data['sub'][$i]['fb']);
			echo "jp</br/>";*/
			
			$this->data['sub'][$i]['mrks']= $this->Feedback_model->Fetch_mark_fwise_attendance($subid, $faculty_code, $academic_type,$academic_year,$cycle,$semester,$division);
			
			if($this->data['sub'][$i]['mrks'][0]['STUD_CNT']!=0 || $this->data['sub'][$i]['mrks'][0]['Tot_marks']!=''  )
			{
					$this->data['sub'][$i]['class_studcnt']= $this->Feedback_model->fetch_classwise_student_count_attendance($stream_id, $division, $semester,$academic_year,$subid);//exit;print_r($this->data['sub'][$i]['mrks']);
				/*	echo "<pre>";
				print_r($this->data['sub'][$i]['class_studcnt']);*/
		
					//$this->data['sub'][$i]['fdappeared_studcnt']= $this->Feedback_model->fetch_classwise_fdapperedstudent_count_attendance($stream_id, $division, $semester,$academic_year,$academic_type,$subid, $faculty_code);
				
				/*print_r($this->data['sub'][$i]['fdappeared_studcnt']);
				die;*/

			}
			
		}
		
	
		}
		
		//print_r($this->data['sub']);
        $this->load->view($this->view_dir.'Faculty_wise_attendance_report',$this->data);
        $this->load->view('footer');
	
		
	}
  	 public function Factilywise_attendance_report_pdf($stud_details, $cycle){
		//error_reporting(E_ALL);
		$role_id = $this->session->userdata('role_id');
		$this->load->model('Subject_model');  
		$this->load->model('Timetable_model');  
		
		$this->load->view('header',$this->data);           	                                        
		$stud_det = base64_decode($stud_details);
		//print_r($stud_det);exit;
		$subject_det = explode('~',$stud_det);
		
		 $academic_type=$subject_det[0];//echo '<br>';
		 $academic_year=$subject_det[1];//echo '<br>';
         $school=$subject_det[2];//echo '<br>';
		 $select_School = $subject_det[3];
		 
		 $this->data['academic_type']=$academic_type;
		 $this->data['academic_year']=$academic_year;
		 $this->data['school']=$school;
		 $this->data['fbses']=$academic_type.'~'.$academic_year;
		 $this->data['select_School']=$select_School;

		 $this->data['sub']= $this->Feedback_model->Factilywise_report($academic_type, $academic_year,$select_School,$school);

		for($i=0;$i<count($this->data['sub']); $i++){
			 $subid = $this->data['sub'][$i]['subject_code'];//echo  '<br>';
			$faculty_code = $this->data['sub'][$i]['faculty_code'];//echo  '<br>';
			$stream_id = $this->data['sub'][$i]['stream_id'];
			 $division = $this->data['sub'][$i]['division']; 
			 $semester = $this->data['sub'][$i]['semester'];
			$this->data['sub'][$i]['fb']= $this->Feedback_model->fetch_feedback_fsubjects_to_admin_attendance($subid, $faculty_code, $academic_type,$cycle);
			$this->data['sub'][$i]['mrks']= $this->Feedback_model->Fetch_mark_fwise_attendance($subid, $faculty_code, $academic_type,$academic_year,$cycle);
			$this->data['sub'][$i]['class_studcnt']= $this->Feedback_model->fetch_classwise_student_count_attendance($stream_id, $division, $semester,$academic_year);//exit;
			$this->data['sub'][$i]['fdappeared_studcnt']= $this->Feedback_model->fetch_classwise_fdapperedstudent_count_attendance($stream_id, $division, $semester,$academic_year,$academic_type);
		}
	
		    $this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'Faculty_wise_report_pdf',$this->data, true);
			$html .= $this->load->view('footer',$this->data, true);
			$pdfFilePath1 ="Feedback_Report.pdf";
			$dattime = date('d-m-Y H:i:s');
		$footer = '<table width="700" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
		  <tr>
		    <td align="right" colspan="3" class="signature"><small><i>Printed on: '.$dattime.'</i></small></td>	
		  </tr>
		  </table>';
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$footer1 = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');	
		$this->m_pdf->pdf->SetHTMLFooter($footer1);		
			
			$mpdf=new mPDF();

			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
		
	}

	public function load_school_details()
	{
		if(isset($_POST["academic_year"]) && !empty($_POST["academic_year"])){
			//Get all streams

			$academic_year = $this->Feedback_model->fetch_feedback_schools_details($_POST["academic_year"]);
	    
			//Count total number of rows
			$rowCount = count($academic_year);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select School</option>';
				foreach($academic_year as $value){

					if($_POST['school'] == $value['school_code']){
													$sel = "selected";
												} else{
													$sel = '';
												}
					echo '<option value="' . $value['school_code'] . '" ' . $sel . '>' . $value['school_name'] . '</option>';
				}
			}else{
				echo '<option value="">School not available</option>';
			}
		}
	}
	function send_test_mail(){
		$this->load->library('Message_api');
		$obj = New Message_api();
		$body="test";
		$subject="Email Api testing";
		$file=""; 
		$to="balasaheb.lengare@carrottech.in";
		$cc="kiran.valimbe@sandipuniversity.edu.in";
		$bcc="kiran.valimbe@sandipuniversity.edu.in";
		$from='noreply@sandipuniversity.com';
		$cursession = $obj->sendattachedemail($body,$subject,$file,$to,$cc,$bcc,$from);
	}
}
?>