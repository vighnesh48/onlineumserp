<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(E_ALL);
class Subject extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="subject_master";
    var $model_name="Subject_model";
    var $model;
    var $view_dir='Subject/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        $this->load->library(['form_validation','session','encryption']);
        $this->load->helper(['url','form','encryption']);
        
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
           $title=$this->master_arr['index'];
       
        
        $this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
        
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
        
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
        $this->load->library('Awssdk');
    }
    //view
    public function index()
    {
		if($this->session->userdata("role_id")==20 ||  $this->session->userdata("role_id")==10 ||
		$this->session->userdata("role_id")==44 ||  $this->session->userdata("role_id")==15 || 
		$this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==65 || $this->session->userdata("role_id")==64 ||
		$this->session->userdata("role_id")==68 || $this->session->userdata("role_id")==53 || $this->session->userdata("role_id")==66
		|| $this->session->userdata("role_id")==69 || $this->session->userdata("role_id")==71){
		}else{
			redirect('home');
		}
        $this->load->view('header',$this->data);        
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['regulatn']= $this->Subject_model->getRegulation();
		$this->data['batches']= $this->Subject_model->getRegulation1();
		$this->load->model('Timetable_model');
		$this->data['cur_session']= $this->Timetable_model->fetch_Curracademic_session();

		if($_POST['course_id'] !=''){
			$course_id = $_POST['course_id'];
			$stream_id = $_POST['stream_id'];
			$sem = $_POST['semester'];
			$regulation = $_POST['regulation'];
			$this->data['courseId'] = $_POST['course_id'];
			$this->data['streamId'] = $_POST['stream_id'];
			$this->data['semesterNo'] = $_POST['semester'];
			$this->data['regulation'] = $_POST['regulation'];
			$this->data['batch'] = $_POST['batch'];
			// add values to session
			$this->session->set_userdata('ScourseId', $course_id);
			$this->session->set_userdata('Sstream_id', $stream_id);
			$this->session->set_userdata('Ssemester', $sem);
			$this->session->set_userdata('Sregulation', $regulation);
			$this->session->set_userdata('Sbatch', $_POST['batch']);
			$this->data['stream_mapping']=$this->Subject_model->fetch_stream_mapping($stream_id,$sem,$regulation);
			$this->data['subj_details']=$this->Subject_model->get_subject_details($sub_id='',$course_id,$stream_id,$sem,$regulation,$_POST['batch']);       	                                        
		}elseif(!empty($this->session->userdata('ScourseId'))){		
			$course_id = $this->session->userdata('ScourseId');
			$stream_id = $this->session->userdata('Sstream_id');
			$sem = $this->session->userdata('Ssemester');
			$regulation = $this->session->userdata('Sregulation');
			$batch = $this->session->userdata('Sbatch');
			
			$this->data['courseId'] = $this->session->userdata('ScourseId');
			$this->data['streamId'] = $this->session->userdata('Sstream_id');
			$this->data['semesterNo'] = $this->session->userdata('Ssemester');
			$this->data['regulation'] = $this->session->userdata('Sregulation');
			$this->data['batch'] = $this->session->userdata('Sbatch');
			$this->data['stream_mapping']=$this->Subject_model->fetch_stream_mapping($stream_id,$sem,$regulation);
			$this->data['subj_details']=$this->Subject_model->get_subject_details($sub_id='',$course_id,$stream_id,$sem, $regulation, $batch);
		}
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
	public function phd_subject_list()
    {
        $this->load->view('header',$this->data);        
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['regulatn']= $this->Subject_model->getRegulation();
		$this->data['batches']= $this->Subject_model->getRegulation1();
		$this->load->model('Timetable_model');
		$this->data['cur_session']= $this->Timetable_model->fetch_Curracademic_session();

		if($_POST['course_id'] !=''){
			$course_id = $_POST['course_id'];
			$stream_id = $_POST['stream_id'];
			$sem = $_POST['semester'];
			$regulation = $_POST['regulation'];
			$this->data['courseId'] = $_POST['course_id'];
			$this->data['streamId'] = $_POST['stream_id'];
			$this->data['semesterNo'] = $_POST['semester'];
			$this->data['regulation'] = $_POST['regulation'];
			$this->data['batch'] = $_POST['batch'];
			// add values to session
			$this->session->set_userdata('ScourseId', $course_id);
			$this->session->set_userdata('Sstream_id', $stream_id);
			$this->session->set_userdata('Ssemester', $sem);
			$this->session->set_userdata('Sregulation', $regulation);
			$this->session->set_userdata('Sbatch', $_POST['batch']);
			$this->data['stream_mapping']=$this->Subject_model->fetch_stream_mapping($stream_id,$sem,$regulation);
			$this->data['subj_details']=$this->Subject_model->get_subject_details($sub_id='',$course_id,$stream_id,$sem,$regulation,$_POST['batch']);       	                                        
		}elseif(!empty($this->session->userdata('ScourseId'))){		
			$course_id = $this->session->userdata('ScourseId');
			$stream_id = $this->session->userdata('Sstream_id');
			$sem = $this->session->userdata('Ssemester');
			$regulation = $this->session->userdata('Sregulation');
			$batch = $this->session->userdata('Sbatch');
			
			$this->data['courseId'] = $this->session->userdata('ScourseId');
			$this->data['streamId'] = $this->session->userdata('Sstream_id');
			$this->data['semesterNo'] = $this->session->userdata('Ssemester');
			$this->data['regulation'] = $this->session->userdata('Sregulation');
			$this->data['batch'] = $this->session->userdata('Sbatch');
			$this->data['stream_mapping']=$this->Subject_model->fetch_stream_mapping($stream_id,$sem,$regulation);
			$this->data['subj_details']=$this->Subject_model->get_subject_details($sub_id='',$course_id,$stream_id,$sem, $regulation, $batch);
		}
        $this->load->view($this->view_dir.'view_phd',$this->data);
        $this->load->view('footer');
    }
    // add
    public function add()
    {
		if($this->session->userdata("role_id")==20 ||  $this->session->userdata("role_id")==10 ||  $this->session->userdata("role_id")==44 ||  $this->session->userdata("role_id")==15 ||  $this->session->userdata("role_id")==6 ||  $this->session->userdata("role_id")==65){
		}else{
			redirect('home');
		}
        $this->load->view('header',$this->data); 
        $this->data['subtype']= $this->Subject_model->get_sub_type();	 
        $this->data['regulatn']= $this->Subject_model->getRegulation(); 
		$this->data['batches']= $this->Subject_model->getRegulation1();		
		$this->data['subcmpt']= $this->Subject_model->get_subject_component();
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);
		$this->load->model('Timetable_model');
		$this->data['cur_session']= $this->Timetable_model->fetch_Curracademic_session();

		//print_r($this->data['subtype']);exit;		
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
	
	public function add_phd()
    {
        $this->load->view('header',$this->data); 
        $this->data['subtype']= $this->Subject_model->get_sub_type();	 
        $this->data['regulatn']= $this->Subject_model->getRegulation();  
		$this->data['adm_batches']= $this->Subject_model->getBatches_phd();
		$this->data['subcmpt']= $this->Subject_model->get_subject_component();
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);
		$this->load->model('Timetable_model');
		$this->data['cur_session']= $this->Timetable_model->fetch_Curracademic_session();

		//print_r($this->data['subtype']);exit;		
        $this->load->view($this->view_dir.'add_phd',$this->data);
        $this->load->view('footer');
    }
    //view
    public function view()
    {
        $this->load->view('header',$this->data);     
	
        $this->data['subj_details']=$this->Subject_model->get_subject_details();                                                             
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    //edit
    public function edit()
    {
		if($this->session->userdata("role_id")==20 ||  $this->session->userdata("role_id")==10 ||  $this->session->userdata("role_id")==44 ||  $this->session->userdata("role_id")==15 ||  $this->session->userdata("role_id")==6 ||  $this->session->userdata("role_id")==65){
		}else{
			redirect('home');
		}
        $this->load->view('header',$this->data);                
        $sub_id=$this->uri->segment(3);            
        $this->data['subtype']= $this->Subject_model->get_sub_type();	  
        $this->data['regulatn']= $this->Subject_model->getRegulation(); 
		$this->data['batches']= $this->Subject_model->getRegulation1();
		$this->data['subcmpt']= $this->Subject_model->get_subject_component();
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);		
        $this->data['subdet']=$this->Subject_model->get_subject_details($sub_id);     
		//print_r($this->data['subdet']);exit;		
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }    

     public function edit_stream_component()
    {
        $this->load->view('header',$this->data);                
        $sub_id=$this->uri->segment(3);

        $this->data['subtype']= $this->Subject_model->get_sub_type();	  
        $this->data['regulatn']= $this->Subject_model->getRegulation(); 
		$this->data['batches']= $this->Subject_model->getRegulation1();
		$this->data['subcmpt']= $this->Subject_model->get_subject_component();
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);		
        $this->data['subdet']=$this->Subject_model->get_subject_stream_componentdetails($sub_id);     
		//print_r($this->data['subdet']);exit;		
        $this->load->view($this->view_dir.'add_component',$this->data);
        $this->load->view('footer');
    } 

    // insert and update
    public function insert_subject()
    {       
        $this->load->helper('security');
        $config=array(
                        array('field'   => 'subject_name',
			'label'   => 'subject name',
			'rules'   => 'trim|required'
			)
            );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $sub_id=$this->input->post('sub_id');
        
        if($sub_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
				unset($_POST['submit']);
				//echo "<pre>";print_r($_POST);exit;
				$check_dup = $this->Subject_model->check_dup_subject($_POST);
				if(count($check_dup) > 0){
				    //$this->session->set_flashdata('dup_msg', 'This Subject is already exist, Please add another');
				    //$path = base_url().'subject/add/';
				    //redirect($path);
					echo "This subject is already exist.";
				}else{
					
					if ($_FILES["syllabus"]["name"] != "") {
						$DIR_NAME = "uploads/syllabus/";
						if (!is_dir($DIR_NAME)) {
							@mkdir($DIR_NAME, 0777);
						}
						$syl_name= $_POST['subject_code'].'-'.$_POST['stream_id'].'-'.$_POST['semester'];
						$target_dir = "uploads/syllabus/";
						$temp = explode(".", $_FILES["syllabus"]["name"]);
						$newfilename = clean($syl_name). '.' . end($temp);


						// $target_file = $target_dir.$newfilename;
						// $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
						// move_uploaded_file($_FILES["syllabus"]["tmp_name"], $target_file);
						$bucket_name = 'erp-asset';
						$file_path = $target_dir.$newfilename;
						$result = $this->awssdk->uploadFile($bucket_name, $file_path, $_FILES["syllabus"]["tmp_name"]);
						$syllabus = basename($newfilename);
						$syllabus_uploaded ='Y';
					}else{
						$syllabus_uploaded ="N";
					}
					$_POST['syllabus_uploaded'] ='Y';
					$_POST['syllabus_path'] =$syllabus;
    				$last_inserted_id = $this->Subject_model->insert_subject($_POST);
    
                   /* if($_POST['course_id'] !=''){
						$course_id = $_POST['course_id'];
						$stream_id = $_POST['stream_id'];
						$sem = $_POST['semester'];
					
						$subj_details=$this->Subject_model->get_subject_details($sub_id='',$course_id,$stream_id,$sem);
						$allstd['ss'] = $subj_details;						
						$allstd['actn'] = 'insert';
						$str4 = json_encode($allstd);
						echo $str4;
					}
					*/
					$this->session->set_flashdata('message', 'Subject updated succesfully');
					redirect(base_url($this->view_dir."/"));
				}
            }
        }
        else
        {      
				unset($_POST['sub_id']);
				unset($_POST['submit']);
				//echo $_FILES["syllabus"]["name"];exit;
				if ($_FILES["syllabus"]["name"] != "") {
					$DIR_NAME = "uploads/syllabus";
					if (!is_dir($DIR_NAME)) {
						@mkdir($DIR_NAME, 0777);
					}
					$syl_name= $_POST['subject_code'].'-'.$_POST['stream_id'].'-'.$_POST['semester'];
					$target_dir = "uploads/syllabus/";
					$temp = explode(".", $_FILES["syllabus"]["name"]);
					$newfilename = clean($syl_name). '.' . end($temp);


					// $target_file = $target_dir.$newfilename;
					// $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
					// move_uploaded_file($_FILES["syllabus"]["tmp_name"], $target_file);
					$syllabus = basename($newfilename);
					$_POST['syllabus_path'] =$syllabus;

					$bucket_name = 'erp-asset';
					$file_path = $target_dir.$newfilename;
					$result = $this->awssdk->uploadFile($bucket_name, $file_path, $_FILES["syllabus"]["tmp_name"]);
					$syllabus_uploaded ='Y';
				}else{
					$syllabus_uploaded ="N";
				}
				
                $last_updated_id = $this->Subject_model->update_subject($_POST, $sub_id, $syllabus_uploaded);                            
                if($last_updated_id)
                {   //flashdata 
					/*if($_POST['course_id'] !=''){
						$course_id = $_POST['course_id'];
						$stream_id = $_POST['stream_id'];
						$sem = $_POST['semester'];
					
						$subj_details=$this->Subject_model->get_subject_details($sub_id='',$course_id,$stream_id,$sem);
						$allstd['ss'] = $subj_details;
						$allstd['actn'] = 'update';
						$str4 = json_encode($allstd);
						
					}*/
					$this->session->set_flashdata('message', 'Subject updated succesfully');
					redirect(base_url($this->view_dir."/"));
                }
                else
                {  
                    redirect(base_url($this->view_dir."/"));
                }
        }      
    }  
	public function load_streams_sub()
	{
	global $model;	    
	$this->data['campus_details']= $this->Subject_model->get_course_streams($_POST);     	    
	}
    // load streams
		function load_streams() {
        if (isset($_POST["course_id"]) && !empty($_POST["course_id"])) {
            //Get all city data
            $stream = $this->Subject_model->load_streams_student_list($_POST);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Stream</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['stream_id'] . '">' . $value['stream_name'] . '</option>';
                }
            } else {
                echo '<option value="">stream not available</option>';
            }
        }
    }
	    // load streams
		function load_semester() {
        if (!empty($_POST)) {
            //Get all city data
            $stream = $this->Subject_model->load_semester_subjects($_POST);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Semester</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
                }
            } else {
                echo '<option value="">semester not available</option>';
            }
        }
    }
	// export subject to pdf
	public function downloadPdf($course_id,$stream_id,$sem, $reg, $batch)
    {
	
		//if($_POST['course_id'] !=''){
			$this->data['courseId'] = $course_id;
			$this->data['streamId'] = $stream_id;
			$this->data['semesterNo'] = $sem;
			$this->data['regulation'] = $reg;
			$this->data['batch'] = $batch;
			//$this->data['course']= $this->Subject_model->get_course_details($course_id);
			$this->data['course']= $this->Subject_model->get_stream_details($stream_id);
			$this->data['subj_details']=$this->Subject_model->get_subject_details($sub_id='',$course_id,$stream_id,$sem, $reg,$batch);
			$this->load->library('m_pdf');
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '5', '15');
			$html = $this->load->view('Subject/subject_pdf_view', $this->data, true);
			$pdfFilePath = $this->data['course'][0]['course_name'].'_'.$sem.".pdf";
			$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="left" height="50" class="signature"><strong>Verified By</strong></td>
  </tr>

</table><table width="800" border="0" cellspacing="0" cellpadding="0" align="center">

  

  <tr>


    <td align="left" class="signature">-------------------------</td>
<td align="right" class="signature">------------------------------------------</td>
    <td align="right" class="signature">-----------------------</td>

   

  </tr>

  <tr>



    <td align="left" height="50" class="signature"><strong>ERP Coordinator</strong></td>
<td align="right" height="50" class="signature"><strong>Programme Coordinator</strong></td>
    <td align="right" height="50" class="signature"><strong>HOD</strong></td>

   

  </tr>

</table>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">

  

  <tr>


    <td align="left" class="signature">-------------------------</td>

    <td align="right" class="signature">-----------------------</td>

   

  </tr>

  <tr>



    <td align="left" height="50" class="signature"><strong>Dean Signature</strong></td>

    <td align="right" height="50" class="signature"><strong>COE Signature</strong></td>

   

  </tr>

</table>';
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML($html);	
			$this->m_pdf->pdf->SetHTMLFooter($footer);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");       	                                        
		//}
	}
	// export subject to excel
	public function subject_report_excel($course_id,$stream_id,$sem, $reg,$batch){
     
	 $this->data['courseId'] = $course_id;
			$this->data['streamId'] = $stream_id;
			$this->data['semesterNo'] = $sem;
			$this->data['regulation'] = $reg;
			$this->data['batch'] = $batch;
			$this->data['course']= $this->Subject_model->get_stream_details($stream_id);
			$this->data['subj_details']=$this->Subject_model->get_subject_details($sub_id='',$course_id,$stream_id,$sem, $reg,$batch);
	 
	  //$this->data['ic_rec'] = $this->ic_reporting_model->get_ic_reporting_data($row);

     $this->load->view('Subject/subject_excel_view',$this->data);  
  }	
	// remove Subject  
	public function removeSubject($sub_id){
		if($this->Subject_model->removeSubject($sub_id)){
			redirect('Subject/');
		}
	}   
	// download stream list pdf
	public function downloadstreamPdf()
    {
	
			$this->load->model('Master_model');
			$this->data['school_details']=$this->Master_model->get_school_details_forstream();
			//$this->data['stream_details']=$this->Master_model->get_schoolwise_stream_details();
			$this->load->library('m_pdf');
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '5', '15');
			$html = $this->load->view('Master/streamlist_pdf_view', $this->data, true);
			//$header = $this->load->view('Marks/cia_pdf_header',$this->data, true);
			$pdfFilePath = "Programme List.pdf";
			
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$this->m_pdf->pdf->AddPage();

			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");
              	                                        
		//}
	}
	//
	public function update_stream_mapping(){	     
		if($this->Subject_model->update_stream_mapping($_POST)){
			echo "SUCCESS";
		}else{
			echo "Problem";
		}   

	}
	public function update_lock_subjects(){	     
		if($this->Subject_model->update_lock_subjects($_POST)){
			echo "SUCCESS";
		}else{
			echo "Problem";
		}   

	}
	public function update_unlock_subjects(){	     
		if($this->Subject_model->update_unlock_subjects($_POST)){
			echo "SUCCESS";
		}else{
			echo "Problem";
		}   

	}
/**************************************************************************************************************
Subject topic coding starts
*/
	public function topic()
    {
		//error_reporting(E_ALL);
		$emp_id = $this->session->userdata("name");
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['batches']= $this->Subject_model->getbatches();
		if($_POST['course_id'] !=''){
			$course_id = $_POST['course_id'];
			$stream_id = $_POST['stream_id'];
			$sem = $_POST['semester'];
			$batch = $_POST['batch'];
			$this->data['courseId'] = $_POST['course_id'];
			$this->data['streamId'] = $_POST['stream_id'];
			$this->data['semesterNo'] = $_POST['semester'];
			$this->data['batch'] = $_POST['batch'];
			//echo "<pre>";print_r($_POST);exit;
			$this->data['subj_details']=$this->Subject_model->get_subjects($course_id,$stream_id,$sem,$batch);
		}
		//exit;
		$this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'topic_view',$this->data);
        $this->load->view('footer');

	}
    public function add_topics($subject_id)
    {
		$this->data['subject_id'] = $subject_id;
        $this->load->view('header',$this->data); 
		$this->data['sub']=$this->Subject_model->fetch_subject_details($subject_id);
		$this->data['topic_details']=$this->Subject_model->get_topic_details($subject_id);
        $this->data['subtype']= $this->Subject_model->get_sub_type();	 
        $this->data['regulatn']= $this->Subject_model->getRegulation();  
		$this->data['subcmpt']= $this->Subject_model->get_subject_component();
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
        $this->load->view($this->view_dir.'add_topic',$this->data);
        $this->load->view('footer');
    }
    // insert topics
    public function insert_subject_topic()
    {               
		//echo "<pre>";print_r($_POST);exit;
		$check_dup = $this->Subject_model->check_dup_subject_topic_no($_POST);
		//echo count($check_dup);
		if(count($check_dup) > 0){
			//$this->session->set_flashdata('dup_msg', 'This Subject is already exist, Please add another');
			//$path = base_url().'subject/add/';
			//redirect($path);
			echo "dupyes";
		}else{
			$this->Subject_model->insert_subject_topic($_POST);

			if($_POST['subject_id'] !=''){
				$subject_id = $_POST['subject_id'];
				$topic_no = $_POST['topic_no'];
			
				$topic_details=$this->Subject_model->get_topic_details($subject_id);
				$allstd['ss'] = $topic_details;						
				$allstd['actn'] = 'insert';
				$str4 = json_encode($allstd);
				echo $str4;
			}
		}

    } 
    // insert sub topics
    public function insert_subject_subtopic()
    {               
		//echo "<pre>";print_r($_POST);exit;
		$check_dup = $this->Subject_model->check_dup_subject_subtopic_no($_POST);
		//echo count($check_dup);
		if(count($check_dup) > 0){
			//$this->session->set_flashdata('dup_msg', 'This Subject is already exist, Please add another');
			//$path = base_url().'subject/add/';
			//redirect($path);
			echo "dupyes";
		}else{
			$this->Subject_model->insert_subject_subtopic($_POST);

			if($_POST['subject_id'] !=''){
				$subject_id = $_POST['subject_id'];
				$topic_no = $_POST['topic_id'];
			
				$topic_details=$this->Subject_model->get_subtopic_details($subject_id,$topic_no);
				$allstd['ss'] = $topic_details;						
				$allstd['actn'] = 'insert';
				$str4 = json_encode($allstd);
				echo $str4;
			}
		}

    }
    public function get_subtopic_details()
    {
		$subject_id =$_POST['subject_id'];
		$topic_id =$_POST['topic_id'];
		$this->data['subtopic_details']=$this->Subject_model->get_subtopic_details($subject_id,$topic_id);	
        echo $this->load->view($this->view_dir.'ajaxtopicdetails',$this->data);

    }
	//faculty allocation
	public function coursewise_faculty($streamId='', $semester='', $division='',$academic_year='', $course_id='')
    {
		//error_reporting(E_ALL); ini_set('display_errors', '1'); 
		$this->load->model('Subject_model');
		$this->load->model('Timetable_model');
        $this->load->view('header',$this->data); 
		$this->data['course_details']= $this->Subject_model->getCollegeCourse();
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
		$this->data['batches']= $this->Subject_model->getRegulation1();		
		
		if($_POST['course_id'] !=''){
			$course_id = $_POST['course_id'];
			$stream_id = $_POST['stream_id'];
			$this->data['courseId'] = $_POST['course_id'];
			$this->data['streamId'] = $_POST['stream_id'];
			$this->data['academicyear'] = $_POST['academic_year'];
			$this->data['batch'] = $_POST['batch'];
			$this->data['semester'] = $_POST['semester'];
			$this->data['subject_details']=$this->Subject_model->get_subdetails_for_faculty($course_id, $stream_id, $_POST['academic_year'],$_POST['batch'],$_POST['semester']); 
			$this->data['ttdivisions']=$this->Subject_model->get_division_from_timetable($course_id, $stream_id, $_POST['academic_year'],$_POST['semester']);
		}
		
        $this->load->view($this->view_dir.'coursewise_faculty',$this->data);
        $this->load->view('footer');
    } 	
	// subject handling faculty report
	public function subject_handling_faculty_pdf($academicyear,$stream_id,$sem, $batch)
    {
	
		//if($_POST['course_id'] !=''){
			$course_id='';
			$this->data['courseId'] = $course_id;
			$this->data['streamId'] = $stream_id;
			$this->data['semester'] = $sem;
			$this->data['batch'] = $batch;
			$this->data['course']= $this->Subject_model->get_stream_details($stream_id);
			$this->data['subject_details']=$this->Subject_model->get_subdetails_for_faculty($course_id,$stream_id,$academicyear,$batch,$sem); 
			$this->data['ttdivisions']=$this->Subject_model->get_division_from_timetable($course_id, $stream_id, $academicyear,$sem);
			$this->load->library('m_pdf');
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '5', '15');
			$html = $this->load->view('Subject/subject_handling_faculty_pdf', $this->data, true);
			$pdfFilePath = $this->data['course'][0]['stream_name'].'_'.$sem.".pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML($html);
			$footer ='<table cellpadding="0" cellspacing="0" border="0" width="800" style="margin-bottom:15px;">
						<tr><td><b>HOD Signature</b><br><br><br><br><br><br></td></tr>
				<tr>
				<td style="font-size:11px;"><b>Note:</b><ol>
				<li>Kindly Verify the Course Code,Name,Credit,Max. Internal Mark,Max. External Mark with the Curriculum. </li>
				<li>Kindly Verify the Board Name of the Course with Head of the Department.</li>
<li>Kindly Verify the Sectionwise Students strength and Subject Handlers with the respective class Coordinator.</li></ol></td>
			</tr>
			</table>';			
			$this->m_pdf->pdf->SetHTMLFooter($footer);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");       	                                        
		//}
	}
	public function academic_info_consolidation()
    {
		//error_reporting(E_ALL); ini_set('display_errors', '1'); 
		$this->load->model('Subject_model');
		$this->load->model('Timetable_model');
        $this->load->view('header',$this->data); 
		$this->data['course_details']= $this->Subject_model->getCollegeCourse();
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
		$this->data['batches']= $this->Subject_model->getRegulation1();		
		
		if($_POST['course_id'] !=''){
			$course_id = $_POST['course_id'];
			$stream_id = $_POST['stream_id'];
			$this->data['courseId'] = $_POST['course_id'];
			$this->data['streamId'] = $_POST['stream_id'];
			$this->data['academicyear'] = $_POST['academic_year'];
			$this->data['batch'] = $_POST['batch'];
			$this->data['semester'] = $_POST['semester'];
			$this->data['subject_details']=$this->Subject_model->get_subdetails_for_faculty($course_id, $stream_id, $_POST['academic_year'],$_POST['batch'],$_POST['semester']);
			$this->data['stud_strength']=$this->Subject_model->admission_strength($stream_id, $_POST['academic_year'],$_POST['semester']);	
			
		}
		
        $this->load->view($this->view_dir.'academic_information_consolidation',$this->data);
        $this->load->view('footer');
    }
	// academic_info_consolidation_pdf report
	public function academic_info_consolidation_pdf($academicyear,$stream_id,$sem, $batch)
    {
	
		//error_reporting(E_ALL); ini_set('display_errors', '1');
			$course_id='';
			$this->data['courseId'] = $course_id;
			$this->data['streamId'] = $stream_id;
			$this->data['semester'] = $sem;
			$this->data['academicyear'] = $academicyear;
			$this->data['batch'] = $batch;
			$this->data['course']= $this->Subject_model->get_stream_details($stream_id);
			$this->data['subject_details']=$this->Subject_model->get_subdetails_for_faculty($course_id, $stream_id, $academicyear,$batch,$sem);
			$this->data['stud_strength']=$this->Subject_model->admission_strength($stream_id, $academicyear,$sem);
			$this->load->library('m_pdf');
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '5', '15');
			$html = $this->load->view('Subject/academic_info_consolidation_pdf', $this->data, true);
			$pdfFilePath = $this->data['course'][0]['stream_name'].'_'.$sem.".pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML($html);
			$footer ='<table cellpadding="0" cellspacing="0" border="0" width="800" style="margin-bottom:15px;">
			<tr><td><b>HOD Signature</b><br><br><br><br><br><br></td></tr>
				<tr>
				<td style="font-size:11px;"><b>Note:</b><ol>
				<li>Students are mapped as per Subject Allocation. </li>
				<li>Kindly Verify the Course Code,Name,Credit,Max. Internal Mark,Max. External Mark with the Curriculum. </li>
				<li>Kindly Verify the Board Name of the Course with Head of the Department.</li>
<li>Kindly Verify the Sectionwise Students strength and Subject Handlers with the respective class Coordinator.</li></ol></td>
			</tr>	
			</table>';
			$footer .='<table cellpadding="0" cellspacing="0" border="0" width="800" style="margin-bottom:15px;">	
			<tr>
			<td>
				<td style="font-size:9px;float:right;text-align:right;"><b style="font-size:9px;float:right;text-align:right;">Printed On: '.date('d-m-Y H:i:s').'</b>
				</td>
			</tr>
			</table>';
			$this->m_pdf->pdf->SetHTMLFooter($footer);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");       	                                        
		//}
	}	
	public function subject_wise_academic_studentinfo()
    {
	//error_reporting(E_ALL); ini_set('display_errors', '1');
		$this->load->model('Subject_model');
		$this->load->model('Timetable_model');
        $this->load->view('header',$this->data); 
		$this->data['course_details']= $this->Subject_model->getCollegeCourse();
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
		$this->data['batches']= $this->Subject_model->getRegulation1();		
		
		if($_POST['course_id'] !=''){
			$course_id = $_POST['course_id'];
			$stream_id = $_POST['stream_id'];
			$this->data['courseId'] = $_POST['course_id'];
			$this->data['streamId'] = $_POST['stream_id'];
			$this->data['academicyear'] = $_POST['academic_year'];
			$this->data['batch'] = $_POST['batch'];
			$this->data['semester'] = $_POST['semester'];
			$this->data['subject'] = $_POST['subject'];
			$this->data['division'] = $_POST['division'];
			$this->data['student_details']=$this->Subject_model->get_subjetc_wise_academic_studentinfo($_POST['subject'], $stream_id, $_POST['academic_year'],$_POST['semester'], $_POST['division']);
			//$this->data['stud_strength']=$this->Subject_model->admission_strength($stream_id, $_POST['academic_year'],$_POST['semester']);	
			
		}
		
        $this->load->view($this->view_dir.'subjetc_wise_academic_studentinfo',$this->data);
        $this->load->view('footer');
    }
	//load_stud_subjects
	function load_stud_subjects() {
        if (!empty($_POST)) {
			$course_id = $_POST['course_id'];
			$stream_id = $_POST['stream_id'];
			$this->data['courseId'] = $_POST['course_id'];
			$this->data['streamId'] = $_POST['stream_id'];
			$this->data['academicyear'] = $_POST['academic_year'];
			$this->data['batch'] = $_POST['batch'];
			$this->data['semester'] = $_POST['semester'];
            $stream = $this->Subject_model->get_subdetails_for_faculty($course_id, $stream_id, $_POST['academic_year'],$_POST['batch'],$_POST['semester']);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Subject</option>';
                foreach ($stream as $value) {
                    echo '<option value="'.$value['sub_id'].'">'.$value['subject_name'].'('.$value['subject_code'].')</option>';
                }
            } else {
                echo '<option value="">Subject not available</option>';
            }
        }
    }
	//load_stud_subjects division
	function load_stud_subjects_div() {
		//echo "<pre>";
		//print_r($_POST);
        if (!empty($_POST)) {
			$course_id = $_POST['course_id'];
			$stream_id = $_POST['stream_id'];
			$this->data['courseId'] = $_POST['course_id'];
			$this->data['streamId'] = $_POST['stream_id'];
			$this->data['academicyear'] = $_POST['academic_year'];
			$this->data['batch'] = $_POST['batch'];
			$this->data['semester'] = $_POST['semester'];
			$this->data['subject'] = $_POST['subject_id'];
            $stream = $this->Subject_model->sectionwise_strength($_POST['subject_id'], $stream_id,$_POST['academic_year'], $_POST['semester']);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Division</option>';
                foreach ($stream as $value) {
                    echo '<option value="'.$value['division'].'">'.$value['division'].'</option>';
                }
            } else {
                echo '<option value="">Division not available</option>';
            }
        }
    }

	// subject_wise_academic_studentinfo report
	public function subject_wise_academic_studentinfo_pdf($subject,$academicyear,$stream_id,$sem, $batch, $division)
    {
			$course_id='';
			$this->data['courseId'] = $course_id;
			$this->data['streamId'] = $stream_id;
			$this->data['semester'] = $sem;
			$this->data['academicyear'] = $academicyear;
			$this->data['batch'] = $batch;
			$this->data['division'] = $division;
			$this->data['course']= $this->Subject_model->get_stream_details($stream_id);
			$this->data['student_details']=$this->Subject_model->get_subjetc_wise_academic_studentinfo($subject, $stream_id, $academicyear,$sem, $division);
			//$this->data['stud_strength']=$this->Subject_model->admission_strength($stream_id, $academicyear,$sem);
			$this->load->library('m_pdf');
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '45', '55');
			
			
			$header = $this->load->view('Subject/subject_wise_academic_studentinfo_header', $this->data, true);
			$html='<style>  
    table {  
                font-family: arial, sans-serif;  
                border-collapse: collapse;  
                width: 100%; font-size:12px; margin:0 auto;
            }  
      td{vertical-align: top;}
                      
            .signature{
            text-align: center;
            }
            .marks-table{
            width: 100%;
            }
            p{padding:0px;margin:0px;}
            h1, h3{margin:0;padding:0}
            .marks-table td{height:30px;vertical-align:middle;}
			
            .marks-table th{height:30px;}
.content-table td{border:1px solid #333;padding-left:5px;vertical-align:middle;}
.content-table th{border-left:1px solid #333;border-right:1px solid #333;border-bottom:1px solid #333;}
        </style> ';
			$html .= $this->load->view('Subject/subject_wise_academic_studentinfo_pdf', $this->data, true);
			$pdfFilePath = $this->data['course'][0]['stream_name'].'_'.$sem.".pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$header = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
			
			
			$footer ='<table cellpadding="0" cellspacing="0" border="0" width="800" style="margin-bottom:15px;">
			<tr><td><b>HOD Signature</b><br><br><br></td></tr>
				<tr>
				<td style="font-size:11px;"><b>Note:</b><ol>
				<li>Students are mapped as per Subject Allocation. </li>
				<li>Kindly Verify the Course Code,Name,Credit,Max. Internal Mark,Max. External Mark with the Curriculum. </li>
				<li>Kindly Verify the Board Name of the Course with Head of the Department.</li>
<li>Kindly Verify the Sectionwise Students strength and Subject Handlers with the respective class Coordinator.</li></ol></td>
			</tr>	
			</table>';
			$footer .='<table cellpadding="0" cellspacing="0" border="0" width="800" style="margin-bottom:15px;">	
			<tr>
			<td>
				<td style="font-size:9px;float:right;text-align:right;"><b style="font-size:9px;float:right;text-align:right;">Printed On: '.date('d-m-Y H:i:s').'</b>
				</td>
			</tr>
			</table>';
			$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
			$this->m_pdf->pdf->SetHTMLHeader($header);
			$this->m_pdf->pdf->SetHTMLFooter($footer);
			$this->m_pdf->pdf->AddPage();			
			$this->m_pdf->pdf->WriteHTML($html);
			$this->m_pdf->pdf->Output($pdfFilePath, "D");       	                                        
		//}
	}	
	function phpinf(){
		phpinfo();
	}
	 public function Subject_component_details()
    {
        $this->load->view('header',$this->data);        
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['regulatn']= $this->Subject_model->getRegulation();
		$this->data['batches']= $this->Subject_model->getRegulation1();
		if($_POST['course_id'] !=''){
			
			$course_id = $_POST['course_id'];
			$stream_id = $_POST['stream_id'];
			$sem = $_POST['semester'];
			$regulation = $_POST['regulation'];
			$this->data['courseId'] = $_POST['course_id'];
			$this->data['streamId'] = $_POST['stream_id'];
			$this->data['semesterNo'] = $_POST['semester'];
			$this->data['regulation'] = $_POST['regulation'];
			$this->data['batch'] = $_POST['batch'];
			// add values to session
			$this->session->set_userdata('ScourseId', $course_id);
			$this->session->set_userdata('Sstream_id', $stream_id);
			$this->session->set_userdata('Ssemester', $sem);
			$this->session->set_userdata('Sregulation', $regulation);
			$this->session->set_userdata('Sbatch', $_POST['batch']);
			$this->data['stream_mapping']=$this->Subject_model->fetch_stream_mapping($stream_id,$sem,$regulation);
			$this->data['subj_details']=$this->Subject_model->get_subject_stream_componentdetails($sub_id='',$course_id,$stream_id,$sem,$regulation,$_POST['batch']);       	                                        
		}elseif(!empty($this->session->userdata('ScourseId'))){		

			$course_id = $this->session->userdata('ScourseId');
			$stream_id = $this->session->userdata('Sstream_id');
			$sem = $this->session->userdata('Ssemester');
			$regulation = $this->session->userdata('Sregulation');
			$batch = $this->session->userdata('Sbatch');
			
			$this->data['courseId'] = $this->session->userdata('ScourseId');
			$this->data['streamId'] = $this->session->userdata('Sstream_id');
			$this->data['semesterNo'] = $this->session->userdata('Ssemester');
			$this->data['regulation'] = $this->session->userdata('Sregulation');
			$this->data['batch'] = $this->session->userdata('Sbatch');
			$this->data['stream_mapping']=$this->Subject_model->fetch_stream_mapping($stream_id,$sem,$regulation);

			$this->data['subj_details']=$this->Subject_model->get_subject_stream_componentdetails($sub_id='',$course_id,$stream_id,$sem, $regulation, $batch);
			/*print_r($this->data['subj_details']);
			die;*/
		}
        $this->load->view($this->view_dir.'view_component',$this->data);
        $this->load->view('footer');
    }

     public function add_subject_component()
    {
        $this->load->view('header',$this->data); 
        $this->data['subtype']= $this->Subject_model->get_sub_type();	 
        $this->data['regulatn']= $this->Subject_model->getRegulation();  
		$this->data['subcmpt']= $this->Subject_model->get_subject_component();
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);
		//print_r($this->data['subtype']);exit;		
        $this->load->view($this->view_dir.'add_component',$this->data);
        $this->load->view('footer');
    }

     // insert and update
    public function insert_subject_component()
    {       

        $this->load->helper('security');
        $config=array(
                        array('field'   => 'theory',
			'label'   => 'Theory',
			'rules'   => 'trim|required|xss_clean'
			)
            );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $sub_id=$this->input->post('sub_id');
        
        if($sub_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add_component',  $this->data);
                $this->load->view('footer');
            }
            else
            {
				unset($_POST['submit']);
				//echo "<pre>";print_r($_POST);exit;
			
				/*	
					if ($_FILES["syllabus"]["name"] != "") {
						$DIR_NAME = "uploads/syllabus/";
						if (!is_dir($DIR_NAME)) {
							@mkdir($DIR_NAME, 0777);
						}
						$syl_name= $_POST['subject_code'].'-'.$_POST['stream_id'].'-'.$_POST['semester'];
						$target_dir = "uploads/syllabus/";
						$temp = explode(".", $_FILES["syllabus"]["name"]);
						$newfilename = $syl_name. '.' . end($temp);


						$target_file = $target_dir.$newfilename;
						$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
						move_uploaded_file($_FILES["syllabus"]["tmp_name"], $target_file);
						$syllabus = basename($newfilename);
						$syllabus_uploaded ='Y';
					}else{
						$syllabus_uploaded ="N";
					}*/
				/*	$_POST['syllabus_uploaded'] ='Y';
					$_POST['syllabus_path'] =$syllabus;*/
					/*print_r($_POST);
					die;*/
    				$last_inserted_id = $this->Subject_model->insert_stream_component($_POST);

    
                   /* if($_POST['course_id'] !=''){
						$course_id = $_POST['course_id'];
						$stream_id = $_POST['stream_id'];
						$sem = $_POST['semester'];
					
						$subj_details=$this->Subject_model->get_subject_details($sub_id='',$course_id,$stream_id,$sem);
						$allstd['ss'] = $subj_details;						
						$allstd['actn'] = 'insert';
						$str4 = json_encode($allstd);
						echo $str4;
					}
					*/
					$this->session->set_flashdata('message', 'stream Component added succesfully');
					redirect(base_url($this->view_dir."/Subject_component_details"));
				
            }
        }
        else
        {      
				unset($_POST['sub_id']);
				unset($_POST['submit']);
				//echo $_FILES["syllabus"]["name"];exit;
			/*	if ($_FILES["syllabus"]["name"] != "") {
					$DIR_NAME = "uploads/syllabus";
					if (!is_dir($DIR_NAME)) {
						@mkdir($DIR_NAME, 0777);
					}
					$syl_name= $_POST['subject_code'].'-'.$_POST['stream_id'].'-'.$_POST['semester'];
					$target_dir = "uploads/syllabus/";
					$temp = explode(".", $_FILES["syllabus"]["name"]);
					$newfilename = $syl_name. '.' . end($temp);


					$target_file = $target_dir.$newfilename;
					$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
					move_uploaded_file($_FILES["syllabus"]["tmp_name"], $target_file);
					$syllabus = basename($newfilename);
					$_POST['syllabus_path'] =$syllabus;
					$syllabus_uploaded ='Y';
				}else{
					$syllabus_uploaded ="N";
				}*/
				
                $last_updated_id = $this->Subject_model->update_stream_component($_POST, $sub_id);                            
                if($last_updated_id)
                {   //flashdata 
					/*if($_POST['course_id'] !=''){
						$course_id = $_POST['course_id'];
						$stream_id = $_POST['stream_id'];
						$sem = $_POST['semester'];
					
						$subj_details=$this->Subject_model->get_subject_details($sub_id='',$course_id,$stream_id,$sem);
						$allstd['ss'] = $subj_details;
						$allstd['actn'] = 'update';
						$str4 = json_encode($allstd);
						
					}*/
					$this->session->set_flashdata('message', 'Subject updated succesfully');
					redirect(base_url($this->view_dir."/"));
                }
                else
                {  
                    redirect(base_url($this->view_dir."/"));
                }
        }      
    }
	// syllabus upload status
	public function subject_syllabus_status()
    {
        $this->load->view('header',$this->data); 
		$this->load->model('Subject_allocation_model');
		$this->load->model('Exam_timetable_model');
		//$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		$this->data['academic_year']= $this->Subject_model->getAcademicYear(); 
		 $this->data['schools']= $this->Exam_timetable_model->getSchools();
		//$this->data['regulation']= $this->Subject_model->getRegulation();
		$this->data['batches']= $this->Subject_model->getRegulation1();
		if(!empty($this->session->userdata('SAstream_id'))){	

			$course_id = $this->session->userdata('SAcourseId');
			$stream_id = $this->session->userdata('SAstream_id');
			$semester = $this->session->userdata('SAsemester');
			$academic_year = $this->session->userdata('SAacademic_year');
			//$regulation = $this->session->userdata('SAregulation');
			$batch = $this->session->userdata('SAbatch');
			$academicyear = explode('-',$academic_year);
			$acdemicyear =$academicyear[0];
			$rp_status = $_POST['rp_status'];
			$this->data['courseId'] = $this->session->userdata('SAcourseId');
			$this->data['streamId'] = $this->session->userdata('SAstream_id');
			$this->data['semesterNo'] = $this->session->userdata('SAsemester');
			$this->data['SAacademic_year'] = $this->session->userdata('SAacademic_year');
			//$this->data['SAregulation'] = $this->session->userdata('SAregulation');
			$this->data['batch'] = $this->session->userdata('SAbatch');				   

			$this->data['sublist']= $this->Subject_model->get_sub_list_for_syllabus_status($stream_id, $semester, $batch, $rp_status);
			$this->data['strmsub']= $this->Subject_allocation_model->get_stream_mapping_tot_subject($stream_id, $semester, $batch);
		}
        $this->load->view($this->view_dir.'subject_syllabus_status',$this->data);
        $this->load->view('footer');
    }
    public function search_subsylabus()
    {
		$this->load->model('Subject_allocation_model');
		$this->load->model('Exam_timetable_model');
        $this->load->view('header',$this->data);                
        $stream_id = $_POST['stream_id'];
		$academic_year = explode('-',$_POST['academic_year']);
		$academic_year =$academic_year[0];
		$semester = $_POST['semester'];
		//$regulation = $_POST['regulation'];
		//$batch = $_POST['batch'];
		
		$batch = $this->getBatch($academic_year,$semester, $stream_id);
		
		//print_r($_POST);exit;
		$this->data['school_code'] = $_POST['school_code'];
		$this->data['courseId'] = $_POST['course_id'];
		$this->data['streamId'] = $_POST['stream_id'];
		$this->data['semesterNo'] = $_POST['semester'];
		//$this->data['SAregulation'] = $_POST['regulation'];
		$this->data['SAacademic_year'] = $_POST['academic_year'];
		$this->data['batch'] = $batch;
		$rp_status = $_POST['rp_status'];
		$this->data['rp_status'] = $_POST['rp_status'];
		// added session values
		$this->session->set_userdata('SAcourseId', $_POST['course_id']);
		$this->session->set_userdata('SAstream_id', $_POST['stream_id']);
		$this->session->set_userdata('SAacademic_year', $_POST['academic_year']);
		$this->session->set_userdata('SAsemester', $_POST['semester']);
		//$this->session->set_userdata('SAregulation', $_POST['regulation']);
		$this->session->set_userdata('SAbatch', $batch);
		
		if(!empty($stream_id) && !empty($semester)){

			$this->data['sublist']= $this->Subject_model->get_sub_list_for_syllabus_status($stream_id, $semester, $batch, $rp_status);
			$this->data['totsubjects']= $this->Subject_model->get_sub_list_for_syllabus($stream_id, $semester, $batch);
			$this->data['strmsub']= $this->Subject_allocation_model->get_stream_mapping_tot_subject($stream_id, $semester, $batch);
		}
		 $this->data['schools']= $this->Exam_timetable_model->getSchools();
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);		   
		$this->data['academic_year']= $this->Subject_model->getAcademicYear(); 
		$this->data['regulation']= $this->Subject_model->getRegulation();
		$this->data['batches']= $this->Subject_model->getRegulation1();

        $this->load->view($this->view_dir.'subject_syllabus_status',$this->data);
        $this->load->view('footer');
    }  
	function getBatch($academic_year,$semester, $stream_id){
		if($stream_id !='71'){
			if($semester=='1' || $semester=='2'){
				$batch = $academic_year;
			}else if($semester=='3' || $semester=='4'){
				$batch = $academic_year-1;
			}else if($semester=='5' || $semester=='6'){
				$batch = $academic_year-2;
			}else if($semester=='7' || $semester=='8'){
				$batch = $academic_year-3;
			}
		}else{
			if($semester=='1'){
				$batch = $academic_year;
			}else if($semester=='2'){
				$batch = $academic_year-1;
			}else if($semester=='3'){
				$batch = $academic_year-2;
			}else if($semester=='4'){
				$batch = $academic_year-3;
			}
			
		}
		return $batch;
	}	
	////////////////////////////////////////
		function subject_master_manually(){
    	exit;
		$batch=2020;
		$semester=5;
		$stream='180';
    	$liststud = $this->Subject_model->fetchsubjects($batch,$semester,$stream);
		//print_r($liststud);
		$i=0;
    	foreach($liststud as $stud){
			$subject_code=$stud['subject_code'];
			$stream_id=$stud['stream_id'];
			$academicyear='2023-24';
			$chkstud = $this->Subject_model->check_duplicate_subject_allocation($subject_code,$stream_id,$semester,$academicyear);
			//print_r($chkstud);
			if(empty($chkstud)){
				$stud = $this->Subject_model->insert_subject_master($stud);
				$i++;
				//echo 'inside'; exit;
			}
    	}
    	echo  $i."records Successfully Updated";
    }
	//////////////////////////////////////////
}
?>