<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Syllabus extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="subject_master";
    var $model_name="Subject_model";
    var $model;
    var $view_dir='Syllabus/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        $this->load->helper("url");		
        $this->load->library('form_validation');
        $this->load->model("Syllabus_model");	
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
		//echo 'inside';exit;
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
        $this->load->view($this->view_dir.'subjects_view',$this->data);
        $this->load->view('footer');
    }
    // add
    public function add_syllabus($subject_id='', $syllbusid='')
    {
        //error_reporting(E_ALL);
		$this->data['subject_id'] = $this->uri->segment(3);
		$subject_id = $this->uri->segment(3);//exit;
        //$this->load->view('header',$this->data); 
		$this->data['sub']=$this->Subject_model->fetch_subject_details($subject_id);
		$this->data['topic_details']=$this->Syllabus_model->get_topic_details($subject_id);
		if($syllbusid !=''){
		    $this->data['syllbus']=$this->Syllabus_model->get_syllbus_by_id($syllbusid);
		}
        $this->data['subtype']= $this->Subject_model->get_sub_type();	 
        $this->data['regulatn']= $this->Subject_model->getRegulation();  
		$this->data['subcmpt']= $this->Subject_model->get_subject_component();
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
		if(!empty($this->session->userdata('ScourseId'))){
		    $this->data['topic_no'] = $this->session->userdata('topic_no');
		    $this->data['unit_no'] = $this->session->userdata('unit_no');
		    $this->data['topic_name'] = $this->session->userdata('topic_name');
		    $this->data['topic_type'] = $this->session->userdata('topic_type');
		}else{
		    $this->data['topic_no'] = '';
		    $this->data['unit_no'] = '';
		    $this->data['topic_name'] = '';
		    $this->data['topic_type'] = '';
		}
		$this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'add_syllabus',$this->data);
        $this->load->view('footer');
    }
    // insert topics
    public function insert_syllabus()
    {               
		//echo "<pre>";print_r($_POST);exit;
		$check_dup = $this->Syllabus_model->check_dup_subject_topic_no($_POST);
		//echo count($check_dup);
		if($check_dup=='topic'){
			//$this->session->set_flashdata('dup_msg', 'This Subject is already exist, Please add another');
			//$path = base_url().'subject/add/';
			//redirect($path);
			echo "topic";
		}
		else if($check_dup=='subtopic')
		{
			echo "subtopic";
		}

		else{
			$this->Syllabus_model->insert_syllabus($_POST);

			if($_POST['subject_id'] !=''){
				$subject_id = $_POST['subject_id'];
				$topic_no = $_POST['topic_no'];
	
			    $this->session->set_userdata('topic_no', $topic_no);
			    $this->session->set_userdata('unit_no', $_POST['unit_no']);
			    if($_POST['topic_name'] !=''){
			        $this->session->set_userdata('topic_name', $_POST['topic_name']);
			    }
			    $this->session->set_userdata('topic_type', $_POST['topic_type']);
			    
				$topic_details=$this->Syllabus_model->get_topic_details($subject_id);
				$allstd['ss'] = $topic_details;						
				$allstd['actn'] = 'insert';
				$str4 = json_encode($allstd);
				echo $str4;
			}
		}

    } 

    // update syllabus 
    public function update_syllabus()
    {               
		//echo "<pre>";print_r($_POST);exit;

			//echo "<pre>";print_r($_POST);exit;
		$check_dup = $this->Syllabus_model->check_dup_subject_topic_no_update($_POST);
		//echo count($check_dup);
		if($check_dup=='topic'){
			//$this->session->set_flashdata('dup_msg', 'This Subject is already exist, Please add another');
			//$path = base_url().'subject/add/';
			//redirect($path);
			echo "topic";
		}
		else if($check_dup=='subtopic')
		{
			echo "subtopic";
		}
		else
		{
			$this->Syllabus_model->update_syllabus($_POST);
		}
		

		if($_POST['syllabus_id'] !=''){

		        $this->session->set_userdata('topic_name', $_POST['topic_name']);
		    }
    }
    //
    public function downloadpdf($subject_id)
    {
        //error_reporting(E_ALL);
		$this->data['sub']=$this->Subject_model->fetch_subject_details($subject_id);
		$this->data['topic_details']=$this->Syllabus_model->get_topic_details($subject_id);
        $sem =$this->data['sub'][0]['semester'];
        $this->load->library('m_pdf');
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '55', '30');
		$header =$this->load->view($this->view_dir.'syllabus_pdf_header',$this->data, true);
		$html = $this->load->view($this->view_dir.'pdf_syllabus',$this->data, true);
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
}
?>