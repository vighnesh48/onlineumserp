<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller 
{
    var $data=array(); 
    function __construct()
    {        
            
   //  error_reporting(E_ALL);
//ini_set('display_errors', 1);
        parent::__construct();                
        $this->load->helper("url");       
        $array=$this->session->all_userdata();
          $this->load->model('login_model');
		  $this->load->model('Responsibilities_model');
//print_r($array);		
        if(!$this->session->has_userdata('uid'))
        redirect('login');     
    }
    public function index()
    {
		$rid=$this->session->userdata('role_id');
		if($rid==4 || $rid==9){
			$rid='Students';
		}else{
			$rid='';
		}
		//print_r($this->data);exit;
        $this->load->view('header',  $this->data);   
        $this->data['sstream'] = $this->login_model->get_user_stream();
        $this->load->model('Circular_model');
		$this->load->model('Dashboard_model');
		$this->load->model('Feedback_model');
        $this->data['circulerlist'] = $this->Circular_model->get_circuler_list($id='',$rid);
        if( $this->session->userdata('role_id')==6111 && ($this->session->userdata("name") !='sunerp' || $this->session->userdata("name")!='suerp_aryan')){			
           redirect('/finance/dashboard');         
        }
       else
       {
           if($this->session->userdata('role_id')==7){
			 $this->load->model('Dashboard_model');
			 
			  $this->data['emplist'] = $this->Dashboard_model->get_employees();
		 // print_r($this->data['emplist']);
		   }
			if($this->session->userdata('role_id')==4){
				//error_reporting(E_ALL);
				//$this->load->model('Feedback_model');
				$this->load->model('Examination_model');
				$this->load->model('Phd_examination_model');
				$this->load->model('Reval_model');
				$this->load->model('Results_model');
				//$this->data['isformexist'] = $this->Dashboard_model->check_isformexist($this->session->userdata('name'));  
				$obj = New Consts();
				$cursession = $obj->fetchCurrSession();
				$this->data['feedback'] = $this->Feedback_model->check_student_feedback($cursession,$stud_det[0]['stud_id']);
				$this->data['attper'] = $this->Feedback_model->check_student_attper($_SESSION['name']);
				//$this->data['latest_exam'] = $this->Dashboard_model->check_latest_exam($_SESSION['name']);
				//$this->data['with_held']= $this->Results_model->fetch_withheld_student_data($_SESSION['name']);
				$data1['prn']=$_SESSION['name'];
				$data1['examid']=$this->data['latest_exam'][0]['exam_id'];
				//$data['fees']= $this->Examination_model->fetch_fees($data1);
				//$this->data['online_fees']= $this->Examination_model->fetch_onlinefees($data1);
				$this->data['student_details']=$stud_data= $this->Dashboard_model->get_student_details($_SESSION['name']);
				$this->data['notifications'] = $this->Dashboard_model->get_student_notifications($stud_data[0]['admission_stream'], $stud_data[0]['current_semester']);
				$this->data['student_academic_calendar'] = $this->Dashboard_model->get_student_academic_calendar($this->data['student_details'][0]['academic_year'],$this->data['student_details'][0]['course_id'],$this->data['student_details'][0]['admission_school'],$this->data['student_details'][0]['admission_stream'],$this->data['student_details'][0]['current_year']);
				$this->data['student_academic_event'] = $this->Dashboard_model->get_student_academic_event($this->data['student_details'][0]['academic_year'],$this->data['student_details'][0]['course_id'],$this->data['student_details'][0]['admission_school'],$this->data['student_details'][0]['admission_stream'],$this->data['student_details'][0]['current_year']);
				
				if(!empty($this->data['student_details'][0]['admission_cycle'])){
					$this->data['exam_session_val']= $this->Phd_examination_model->fetch_stud_curr_exam();
					 $phdallowed_prn=$this->Phd_examination_model->get_exam_allowed_studntlist($this->data['exam_session_val'][0]['exam_id']);
					foreach($phdallowed_prn as $prn){
						$phdarr_prn[] = $prn['enrollment_no'];
					}
					$this->data['phd_allowed_stud_prn'] = $phdarr_prn; 
				}else{
					 $this->data['exam_session_val']= $this->Examination_model->fetch_stud_curr_exam_ecr();
					/*$reval_exam_id= $this->Reval_model->fetch_exam_session_for_reval();
					$reval_exam_id=$reval_exam_id[0]['exam_id'];
					$this->data['prevexam']= $this->Examination_model->fetch_stud_suppli_prev_exam($_SESSION['name'],$reval_exam_id);
					
					//print_r($this->data['prevexam']);//exit;
					$allowed_prn=$this->Examination_model->get_exam_allowed_studntlist($this->data['exam_session_val'][0]['exam_id']);
					foreach($allowed_prn as $pr){
						$arr_prn[] = $pr['enrollment_no'];
					}
					$this->data['stud_prn'] = $arr_prn; */
				}
			}
			$this->data['pdf']=array();
			if($this->session->userdata('role_id')==21){
				$this->data['pdf'] = $this->Responsibilities_model->get_pdf_details();
			}
			  $this->load->view('home', $this->data);  
       }
        $this->load->view('footer');
    }
}
