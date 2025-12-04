<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phd_admission extends CI_Controller 
{

    var $currentModule="";
    var $title="";
    var $table_name="campus_master";
    var $model_name="phd_admission_model";
    var $model;
    var $view_dir='Admission/';
    
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
     //   echo $_SERVER['REMOTE_ADDR'];
 // var_dump($_SESSION);
// error_reporting(E_ALL);
//ini_set('display_errors', 1);
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
         $this->load->model("Admission_model");
           $this->load->library('Message_api');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
        $this->load->library('Awssdk');
    }
	
    public function index()
    {
        global $model;
        $this->load->view('header',$this->data);    
        $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    

	
	

	    public function Phd_admission_form()
	    {
		
	        $this->load->view('header',$this->data);     
	        $this->data['states'] = $this->phd_admission_model->fetch_states();
	        $campus_id=$this->uri->segment(3);
		//$college_id = $this->session->college_id;
		//$up_stud_id=$_REQUEST['s'];
		//echo $stud_id;
		    $college_id = 1;
	      //  $this->data['course_details']= $this->phd_admission_model->getCollegeCourse($college_id);
	     $academic_year= $this->config->item('current_year');
	     //  $academic_year='2016-17';
			///$academic_year='2019-20';
		    
		    	$this->data['school_list']= $this->phd_admission_model->list_schools();
		    $this->data['course_details'] = $this->phd_admission_model->getcourse_yearwise($academic_year);
			$this->data['doc_list']= $this->phd_admission_model->getdocumentlist();
			$this->data['category']= $this->phd_admission_model->getcategorylist();
			$this->data['religion']= $this->phd_admission_model->getreligionlist();
		$this->data['course_year']= $this->phd_admission_model->getCourseYRClg($college_id);
		$this->data['branches']= $this->phd_admission_model->getbranch($college_id);
		$this->data['exam_list']= $this->phd_admission_model->entrance_exam_master();
		$this->data['bank_details']= $this->phd_admission_model->getbanks();
			$this->data['pmedia']= $this->phd_admission_model->getpmedias();
		
		if(!empty($_REQUEST['s'])){ //code for update
			$up_stud_id=$_REQUEST['s'];//student id for update 
			$check_stud_form_flag=$this->phd_admission_model->check_flag_status($up_stud_id);// check steps completion status
			if($this->session->userdata('student_id')==$up_stud_id){
				if($this->session->userdata('stepfirst_status')=='success'&& $check_stud_form_flag[0]['step_first_flag']==1){
					$data=['updatestep1flag'=>'active'];
					$this->session->set_userdata($data);
					}
				if($this->session->userdata('stepsecond_status')=='success' && $check_stud_form_flag[0]['step_second_flag']==1 ){$data=['updatestep2flag'=>'active'];$this->session->set_userdata($data);}
				if($this->session->userdata('stepthird_status')=='success' && $check_stud_form_flag[0]['step_third_flag']==1){$data=['updatestep3flag'=>'active'];$this->session->set_userdata($data);}
				if($this->session->userdata('stepfourth_status')=='success' && $check_stud_form_flag[0]['step_fourth_flag']==1){$data=['updatestep4flag'=>'active'];$this->session->set_userdata($data);}
				if($this->session->userdata('stepfifth_status')=='success' && $check_stud_form_flag[0]['step_fifth_flag']==1){$data=['updatestep5flag'=>'active'];$this->session->set_userdata($data);}
			 //setting session variable for update process
			$this->session->set_userdata($data);
			}
			// fetch all data for displying prefilled form for updating
			         $this->data['personal']=$this->phd_admission_model->getstep1_data1($up_stud_id);
					 $this->data['certificate']=$this->phd_admission_model->getstudent_certificate_data($up_stud_id);
					 $this->data['education']=$this->phd_admission_model->getstudent_education_data($up_stud_id);
					 $this->data['qualiexam']=$this->phd_admission_model->qualifying_exam_details($up_stud_id);
					 $this->data['document']=$this->phd_admission_model->getstud_document_details($up_stud_id);
					 $this->data['references']=$this->phd_admission_model->getstud_references_details($up_stud_id);
					 $this->data['fee']=$this->phd_admission_model->getstud_fee_details($up_stud_id); 
					 
		}
		    $this->load->view($this->view_dir.'phd_admission',$this->data);
	        $this->load->view('footer');
	    }

	    function ums_phdadmission_submit()
	 { 
        $student_id = $this->session->userdata('studId');
	    if(!empty($_FILES['scandoc']['name'])){
			$_FILES['scandoc']['name']=$this->phd_admission_model->rearrange1($_FILES['scandoc']['name']);
			
			$arr1 = [];
			$arr2 = [];
			foreach($_FILES['scandoc']['name'] as $key => $val){
               // $_FILES['userFile']['name'] = $student_id.'-'.$_FILES['scandoc']['name'][$key];
			    $_FILES['userFile']['name'] = $_FILES['scandoc']['name'][$key];
                $_FILES['userFile']['type'] = $_FILES['scandoc']['type'][$key];
                $_FILES['userFile']['tmp_name'] = $_FILES['scandoc']['tmp_name'][$key];
                $uploadPath = 'uploads/student_document/';
				$src_file = $_FILES['userFile']['tmp_name'];
	          	$ext = explode('.', $_FILES['userFile']['name']);
				$student_year = $_POST['acyear'];
	            $file_name = time() .'-'. clean($ext[0]).'.'.$ext[1];
				$file_path = $uploadPath. $student_year. '/' .$file_name;
	            $bucket_name = 'erp-asset';
	            try {
                   $result = $this->awssdk->uploadFile($bucket_name, $file_path, $src_file);
                    // Success message
                    $arr1[$key]= $file_name;
                } catch (AwsException $e) {
	               // echo 'Error uploading file to S3: ' . $e->getMessage();
				   $arr1[$key]= '';
					} 
				}
			}

	    	if(!empty($_FILES['sss_doc']['name'])){
				$_FILES['sss_doc']['name']=$this->phd_admission_model->rearrange1($_FILES['sss_doc']['name']);
			
			
				foreach($_FILES['sss_doc']['name'] as $key => $val) {
	                /* $_FILES['userFile']['name'] = $student_id.'-'.$_FILES['sss_doc']['name'][$key]; */
					$_FILES['userFile']['name'] =$_FILES['sss_doc']['name'][$key];
	                $_FILES['userFile']['type'] = $_FILES['sss_doc']['type'][$key];
	                $_FILES['userFile']['tmp_name'] = $_FILES['sss_doc']['tmp_name'][$key];
	                $uploadPath = 'uploads/student_document/';

	                $src_file = $_FILES['userFile']['tmp_name'];
		            $ext = explode('.', $_FILES['userFile']['name']);
		            $file_name = time() .'-'. clean($ext[0]).'.'.$ext[1];
					$student_year = $_POST['acyear'];
		            //$file_path = $uploadPath.$file_name;
					$file_path = $uploadPath. $student_year. '/' .$file_name;
		            $bucket_name = 'erp-asset';
		            $userFile= $file_name; 
		            try {
	                    $result = $this->awssdk->uploadFile($bucket_name, $file_path, $src_file);
						 $arr2[$key]= $file_name;
		            } catch (AwsException $e) {
		                //echo 'Error uploading file to S3: ' . $e->getMessage();
						$arr2[$key]= '';
		            }
	            }
            }
	       
	    $stud_reg_id=$this->phd_admission_model->student_phdregistration_ums($_POST,$arr1,$arr2);

       $nam = $_POST['slname']."".$_POST['sfname']."".$_POST['smname'];
	    echo '<script>alert("PRN Number of '.$nam.' is '.$stud_reg_id.'");window.location.href = "stud_list";</script>'; 
	    redirect('phd_admission/stud_list','refresh');	 
}
public function load_courses()
{
	// global $model;
	  $course_details =$this->phd_admission_model->getschool_course($_POST['school']);

	   $opt ='<option value="">Select Course</option>';
	    foreach ($course_details as $course) {

   		 $opt .= '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
		}echo $opt;
}

	public function get_course_streams_yearwise()
	{
 		global $model;	    
    	$this->data['campus_details']= $this->phd_admission_model->get_course_streams_yearwise($_POST);     	    
	}
	public function fetch_academic_fees_for_stream_year(){
	
		$strm_id=$_REQUEST['strm_id'];
	    $acyear=$_REQUEST['acyear'];
		$admission_cycle=$_REQUEST['admission_cycle'];
		$fess =$this->phd_admission_model->fetch_academic_fees_for_stream_year($strm_id,$acyear,$admission_cycle);
		
		echo json_encode($fess);
	}  
	 public function stud_list($offSet=0)
    {
        $this->load->view('header',$this->data);        
        $limit = 10;// set records per page
		if(isset($_REQUEST['per_page'])){
			$offSet=$_REQUEST['per_page'];
		}
		$data['ex_ses']= $this->phd_admission_model->exam_sessions();
		 $this->data['academic_year']= $this->phd_admission_model->load_distinct_acadmeic_year();
        $total= $this->phd_admission_model->getAllStudents();
        $this->data['emp_list']= $this->phd_admission_model->getStudents($offSet,$limit);

		$total_pages = ceil($total/$limit);
		//echo $total_pages; 
		$this->load->library('pagination');
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config['enable_query_strings']=TRUE;
		$config['page_query_string']=TRUE;
		$config['reuse_query_string'] = TRUE;
		$config['base_url'] = base_url().'phd_admission/stud_list?';
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);
	    $this->data['paginglinks'] = $this->pagination->create_links();
		$config['offSet'] = $offSet;		
		$total=ceil($total/$limit);
		$college_id = 1;
		$this->data['course_details']= $this->phd_admission_model->getCollegeCourse($college_id); 
        $this->load->view($this->view_dir.'student_list_of_phd',$this->data);
        $this->load->view('footer');
    }

    public function load_batch_student_list()
	{    
		$stream_details= $this->phd_admission_model->load_batch_student_list($_POST);
		$opt ='<option value="">Select Batch</option>';
		$opt .='<option value="0">ALL</option>';
	   foreach ($stream_details as $str) {

			$opt .= '<option value="' . $str['admission_cycle'] . '">' . $str['admission_cycle'] . '</option>';
		}
		echo $opt;		
	}
    

    public function load_courses_for_studentlist()
	{    
	   $course_details =  $this->phd_admission_model->load_courses_for_studentlist($_POST['academic_year']);  
	   $opt ='<option value="">Select Course</option>';
	   foreach ($course_details as $course) {

			$opt .= '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
		}
			echo $opt;
	}
	public function load_years_for_studentlist()
	{	    
	   $year_details =  $this->phd_admission_model->load_years_for_studentlist($_POST['academic_year'],$_POST['admission_stream']);  
	   $opt ='<option value="">Select Year</option>';
	   foreach ($year_details as $yr) {

			$opt .= '<option value="' . $yr['admission_year'] . '"' . $sel . '>' . $yr['admission_year'] . '</option>';
		}
			echo $opt;
	}

		// edit student personal details
		public function edit_personalDetails($stud_id)
	    {
	    // error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	        $this->session->set_userdata('studId', $stud_id);
	        $this->load->view('header',$this->data);  
	        $this->data['states'] = $this->phd_admission_model->fetch_states();
	        $this->data['course_details']= $this->phd_admission_model->getCollegeCourse($college_id);
			$this->data['doc_list']= $this->phd_admission_model->getdocumentlist();
			$this->data['category']= $this->phd_admission_model->getcategorylist();
			$this->data['religion']= $this->phd_admission_model->getreligionlist();
		    $this->data['course_year']= $this->phd_admission_model->getCourseYRClg($college_id);
		    $this->data['branches']= $this->phd_admission_model->getbranch($college_id);
		    $stdata = $this->phd_admission_model->fetch_personal_details($stud_id);
		   
	        $this->data['emp_list']= $this->phd_admission_model->fetch_personal_details($stud_id);
	          $this->data['perm_address']= $this->phd_admission_model->fetch_address_details($stud_id,'STUDENT','PERMNT');

	            $this->data['admission_details']= $this->phd_admission_model->fetch_admission_details($stud_id); 
	            $loadd = $this->phd_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');
		    $peradd = $this->phd_admission_model->fetch_address_details($stud_id,'STUDENT','PERMNT');
		    $parentadd = $this->phd_admission_model->fetch_address_details($stud_id,'PARENT','PERMNT');
	           
	    
	            $this->data['localcity']= $this->phd_admission_model->fetch_distcity_details('taluka_master','district_id',$loadd[0]['district_id']);
	             $this->data['localdistrict']= $this->phd_admission_model->fetch_distcity_details('district_name','state_id',$loadd[0]['state_id']);
	            $this->data['permcity']= $this->phd_admission_model->fetch_distcity_details('taluka_master','district_id',$peradd[0]['district_id']);
	            $this->data['permdistrict']= $this->phd_admission_model->fetch_distcity_details('district_name','state_id',$peradd[0]['state_id']);
	            $this->data['parentcity']= $this->phd_admission_model->fetch_distcity_details('taluka_master','district_id',$parentadd[0]['district_id']);
	             $this->data['parentdistrict']= $this->phd_admission_model->fetch_distcity_details('district_name','state_id',$parentadd[0]['state_id']);
	        
	            $this->data['coursedet']= $this->phd_admission_model->fetch_stcouse_details1($stdata[0]['admission_stream']);
	            $cde = $this->phd_admission_model->fetch_stcouse_details1($stdata[0]['admission_stream']);
	            
	               $this->data['stream']= $this->phd_admission_model->fetch_stcouse_details($cde[0]['course_id']);
	               $this->data['school_list']= $this->phd_admission_model->list_schools();
	        $this->load->view($this->view_dir.'personal_details_of_phd',$this->data);
	        $this->load->view('footer');
	    }
		// edit student edu details
		public function edit_eduDetails()
	    {
			//var_dump($_SESSION);
	        $stud_id = $this->session->userdata('studId');
	        $this->load->view('header',$this->data);     
			
			$this->data['qual']= $this->phd_admission_model->fetch_stud_qualifications($stud_id);
			$this->data['ent_exams']= $this->phd_admission_model->fetch_stud_entranceexams($stud_id);
			$this->data['subjects']= $this->phd_admission_model->fetch_qua_subjects_details($stud_id);
	        $this->load->view($this->view_dir.'educational_details_phd',$this->data);
	        $this->load->view('footer');
	    }
		// edit student Docs &cert details
		public function edit_docsndcertDetails()
	    {
	        $stud_id = $this->session->userdata('studId');
	        $this->load->view('header',$this->data);   
	        
	              $this->data['get_icert_details']= $this->phd_admission_model->get_cert_details($stud_id,'Income');
	         $this->data['get_ccert_details']= $this->phd_admission_model->get_cert_details($stud_id,'Cast-category');
	          $this->data['get_rcert_details']= $this->phd_admission_model->get_cert_details($stud_id,'Residence-State Subject');
	     //   $this->data['course_details']= $this->phd_admission_model->getCollegeCourse($college_id);
		//	$this->data['doc_list']= $this->phd_admission_model->getdocumentlist();
				$this->data['doc_list']= $this->phd_admission_model->userdoc_list($stud_id);
			$this->data['category']= $this->phd_admission_model->getcategorylist();
			$this->data['religion']= $this->phd_admission_model->getreligionlist();
		    $this->data['course_year']= $this->phd_admission_model->getCourseYRClg($college_id);
		    $this->data['branches']= $this->phd_admission_model->getbranch($college_id);
		    
	        $this->data['emp_list']= $this->phd_admission_model->fetch_personal_details($stud_id);
	        $this->load->view($this->view_dir.'certificates_and_docs_phd',$this->data);
	        $this->load->view('footer');
	    }
		// edit student reference details
		public function edit_refDetails()
	    {
	        $stud_id = $this->session->userdata('studId');
	        $this->load->view('header',$this->data);   
	        
	        $this->data['is_from_reference']= $this->phd_admission_model->get_referencedetails('is_from_reference',$stud_id);
		   $this->data['is_uni_employed']= $this->phd_admission_model->get_referencedetails('is_uni_employed',$stud_id);
		    $this->data['is_uni_alumni']= $this->phd_admission_model->get_referencedetails('is_uni_alumni',$stud_id);
		    $this->data['is_uni_student']= $this->phd_admission_model->get_referencedetails('is_uni_student',$stud_id);
		    $this->data['is_reference']= $this->phd_admission_model->get_referencedetails('is_reference',$stud_id);
		     $this->data['is_concern']= $this->phd_admission_model->get_referencedetails('is_concern_ins',$stud_id);
		   $this->data['pmedia']= $this->phd_admission_model->getpmedias(); 
	        $this->data['emp_list']= $this->phd_admission_model->fetch_personal_details($stud_id);
	        $this->load->view($this->view_dir.'references_phd',$this->data);
	        $this->load->view('footer');
	    }  
		// edit student payment details
		public function edit_paymentDetails()
	    {
	        $stud_id = $this->session->userdata('studId');
	        $this->load->view('header',$this->data);  
	        $this->data['get_feedetails']= $this->phd_admission_model->get_feedetails($stud_id);
			$this->data['get_bankdetails']= $this->phd_admission_model->get_bankdetails($stud_id);
			 $this->data['emp_list']= $this->phd_admission_model->fetch_personal_details($stud_id);
			 	$this->data['bank_details']= $this->phd_admission_model->getbanks();
			 	 $this->data['admission_details']= $this->phd_admission_model->fetch_admission_details($stud_id); 
	        $this->load->view($this->view_dir.'payments_phd',$this->data);
	        $this->load->view('footer');
	    } 	
	public function load_streams_student_list()
	{    
		$stream_details= $this->phd_admission_model->load_streams_student_list($_POST);
		$opt ='<option value="">Select Stream</option>';
	   foreach ($stream_details as $str) {

			$opt .= '<option value="' . $str['stream_id'] . '"' . $sel . '>' . $str['stream_name'] . '</option>';
		}
		echo $opt;		
	}

		public function update_personalDetails()
	    {
	       $this->phd_admission_model->update_stepfirstdata($_POST); 
	         $msg5='student application updated  successfully..';
				 $this->session->set_flashdata('msg5', $msg5);
				  //  echo '<script>alert("PRN Number of '.$nam.' is '.$stud_reg_id.'");window.location.href = "stud_list";<script>';
				 $path= "http://sandipuniversity.com/erp/phd_admission/edit_personalDetails/".$_POST['student_id'];
				//$path= "http://localhost/erp/phd_admission/edit_personalDetails/".$_POST['student_id'];
				 echo '<script>alert("Student application updated  successfully..");window.location.href = "'.$path.'";<script>';
		       redirect($path);
	    }
		
		
			public function update_bankDetails()
	    {
	       $this->phd_admission_model->registration_step5($_POST); 
	         $msg5='student application updated  successfully..';
				 $this->session->set_flashdata('msg5', $msg5);
				redirect('phd_admission/stud_list');
	    }
		
		
		
			public function update_refDetails()
	    {
	       $this->phd_admission_model->registration_step4($_POST); 
	         $msg5='student application updated  successfully..';
				 $this->session->set_flashdata('msg5', $msg5);
				redirect('phd_admission/edit_refDetails');
	    }
		

		public function update_docDetails()
	    {

            $student_id = $this->session->userdata('studId');
        	// if(!empty($_FILES['scandoc']['name'])){
			// $_FILES['scandoc']['name']=$this->phd_admission_model->rearrange1($_FILES['scandoc']['name']);
	
			// 	foreach($_FILES['scandoc']['name'] as $key => $val){
            //     $_FILES['userFile']['name'] = $student_id.'-'.$_FILES['scandoc']['name'][$key];
            //     $_FILES['userFile']['type'] = $_FILES['scandoc']['type'][$key];
            //     $_FILES['userFile']['tmp_name'] = $_FILES['scandoc']['tmp_name'][$key];
            //     $_FILES['userFile']['error'] = $_FILES['scandoc']['error'][$key];
            //     $_FILES['userFile']['size'] = $_FILES['scandoc']['size'][$key];
            //      $arr1[$key]=str_replace(" ","_",$_FILES['userFile']['name']);
            //     $uploadPath = 'uploads/student_document/';
            //     $config['upload_path'] = $uploadPath;
            //     $config['allowed_types'] = 'gif|jpg|png|pdf|docx|pdf';
			// 	$config['overwrite']= TRUE;
            //     $config['max_size']= "2048000"; 
            //     $this->load->library('upload', $config);
            //     $this->upload->initialize($config);
            //     if($this->upload->do_upload('userFile')){
            //         $fileData = $this->upload->data();
            //         $uploadData[$key]['file_name'] = str_replace(" ","_",$fileData['file_name']);
            //         $uploadData[$key]['created'] = date("Y-m-d H:i:s");
            //         $uploadData[$key]['modified'] = date("Y-m-d H:i:s");
            //     }
            // }
            //    }
            $this->phd_admission_model->update_stepthirddata($_POST); 
         	$msg5='student application updated  successfully..';
			$this->session->set_flashdata('msg5', $msg5); 
			redirect('phd_admission/edit_docsndcertDetails');
	    }
	    
	    public function detain_student(){    
		$student_id = $_POST['stud_id'];
		$detain = $_POST['detain'];
		if($this->phd_admission_model->detain_student($student_id,$detain)){
			$this->phd_admission_model->insert_detain_student($_POST);
			echo "Y";
		}else{							
			echo "N";
		}

	}
	public function change_stream($student_id){
		//error_reporting(E_ALL);
		$this->load->view('header',$this->data); 
		$data['prn']=$student_id;
		$this->data['stud_details']= $this->phd_admission_model->studentforchange_stream($data);
		$course_id = $this->data['stud_details'][0]['course_id'];
		$min_que = $this->data['stud_details'][0]['min_que'];
		$this->data['streams']= $this->phd_admission_model->school_streams($course_id,$min_que);
		$this->load->view($this->view_dir.'change_stream_view_phd',$this->data);
		$this->load->view('footer');
	 }	
	 public function insert_to_changeStream(){
		//error_reporting(E_ALL);
		if(!empty($_POST)){			
			$update= $this->phd_admission_model->insert_to_changeStream($_POST);
		}
		$stud_id = $_POST['stud_id'];
		$this->session->set_flashdata('message1','Stream Changed Successfully!!.');
		redirect('ums_admission/change_stream/'.$stud_id);
	 }
	public function update_stream($temp_id){
		//error_reporting(E_ALL);
		$temp_id =$_POST['temp_id'];
		if(!empty($temp_id)){
			$tempid= $this->phd_admission_model->get_stream_temp_details($temp_id);
			if(!empty($tempid)){
				$var['admission_stream'] = $tempid[0]['change_to_stream'];
				$var['stud_id'] = $tempid[0]['stud_id'];
				$var['academic_year'] = $tempid[0]['academic_year'];
				$var['current_year'] = $tempid[0]['current_year'];
				$var['previous_stream'] = $tempid[0]['previous_stream'];
				$var['admission_year'] = $tempid[0]['admission_session'];
				$update= $this->phd_admission_model->update_stream_adm_details($var);
				$update1= $this->phd_admission_model->update_stream_stud_master($var);
				$this->phd_admission_model->update_temp_stream_status($temp_id);			
			}else{
				echo "N";
			}
		}
		$stud_id = $var['stud_id'];
		echo "Y";
		//redirect('ums_admission/change_stream/'.$stud_id);
	 }
	function load_studentlist()
	{
		$data['ex_ses']= $this->phd_admission_model->exam_sessions();
		$data['emp_list']= $this->phd_admission_model->getStudentsajax($_POST['astream'],$_POST['ayear'],$_POST['acdyear'],$_POST['batch']);
		$data['dcourse']= $_POST['astream'];
		$data['dyear']= $_POST['ayear'];
		$data['hide']= $_POST['hide'];
		$html = $this->load->view($this->view_dir.'load_studentdata_phd',$data,true);
		echo $html;
	}
	public function view_studentFormDetails($stud_id)
    {
       if($this->session->userdata('role_id')==4 ||$this->session->userdata('role_id')==9){
      
         $id= $this->phd_admission_model->get_student_id_by_prn($this->session->userdata('name'));
         $stud_id=$id['stud_id'];
       }
       else
       {
        $this->session->set_userdata('studId', $stud_id);
       }
       /* end-1:This loop is added by arvind for student login to view his own profile where stud_id variable is set from his login id.*/
        $this->load->view('header',$this->data);     
  
        $this->data['emp']= $this->phd_admission_model->fetch_personal_details($stud_id);
		$this->data['laddr']= $this->phd_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');
        $this->data['paddr']= $this->phd_admission_model->fetch_address_details($stud_id,'STUDENT','PERMNT');
		$this->data['gaddr']= $this->phd_admission_model->fetch_address_details($stud_id,'PARENT','PERMNT');
        $this->data['qual']= $this->phd_admission_model->fetch_qualification_details($stud_id);		
		$this->data['admdetails']= $this->phd_admission_model->admission_details($stud_id);
		$this->data['entrance']= $this->phd_admission_model->student_entrance_exam($stud_id);
		$this->data['ref']= $this->phd_admission_model->student_references($stud_id, 'REF');
		$this->data['uniemp']= $this->phd_admission_model->student_references($stud_id, 'UNIEMP');
		$this->data['unialu']= $this->phd_admission_model->student_references($stud_id, 'UNIALU');
		$this->data['unistud']= $this->phd_admission_model->student_references($stud_id, 'UNISTUD');
		$this->data['fromref']= $this->phd_admission_model->student_references($stud_id, 'FROMREF');
		$this->data['docs']= $this->phd_admission_model->fetch_document_details($stud_id);
		$this->data['parent_details']= $this->phd_admission_model->fetch_parent_details($stud_id);
		$this->data['get_feedetails']= $this->phd_admission_model->get_feedetails($stud_id);
		
		$this->data['get_refunds']= $this->phd_admission_model->get_refundetails($stud_id);
			$this->data['tot_refunds']= $this->phd_admission_model->get_tot_refunds($stud_id);
		$this->data['get_bankdetails']= $this->phd_admission_model->get_bankdetails($stud_id);
		$this->data['bank_details']= $this->phd_admission_model->getbanks();
	//	$this->data['admission_details']= $this->phd_admission_model->fetch_admission_details($stud_id);
		$this->data['admission_detail']= $this->phd_admission_model->fetch_admission_details_all($stud_id,$acyear); 
		
		$this->data['admission_details']= $this->phd_admission_model->fetch_admission_details($stud_id,$acyear); 
	
		$this->data['totfeepaid']= $this->phd_admission_model->fetch_total_fee_paid($stud_id);
		
		
        $this->load->view($this->view_dir.'view_student_form_details_phd',$this->data);
		$this->load->view('footer');
        //$this->load->view('footer');
    } 

    public function updateEducation()
    {
		$stud_id = $_POST['reg_id'];
		$sss_docss=$this->phd_admission_model->rearrange1($_POST['exam_id']);
		$qual= $_POST['qual_id'];
		if(!empty($sss_docss)){
			$i = 0;
			$p=1;
			foreach($sss_docss as $key => $val){
				if(!empty($_FILES['sss_doc']['name'][$i])){
					$p++;
	                $_FILES['userFile']['name'] = $stud_id.'-'.$_FILES['sss_doc']['name'][$i];
	                $_FILES['userFile']['type'] = $_FILES['sss_doc']['type'][$i];
	                $_FILES['userFile']['tmp_name'] = $_FILES['sss_doc']['tmp_name'][$i];
	                $uploadPath = 'uploads/student_document/';

	                if ($_FILES && $_FILES['userFile']['name']) {
			            $src_file = $_FILES['userFile']['tmp_name'];
			            $ext = explode('.', $_FILES['userFile']['name']);
			            $file_name = time() .'-'. clean($ext[0]).'.'.$ext[1];
			            $student_year = getStudentYear($stud_id);
			            $file_path = $uploadPath. $student_year. '/' . $file_name;
			            $bucket_name = 'erp-asset';
			            $userFile= $file_name;
			            try {
		                    $result = $this->awssdk->uploadFile($bucket_name, $file_path, $src_file);
		                    // Success message
		                    echo 'File uploaded successfully to S3!';
		                    $arr1[$key]= $file_name;
		                   /*  $DB1 = $this->load->database('umsdb', TRUE);
		                    $DB1->select("*");
							$DB1->from('student_qualification_details');
							$DB1->where('student_id', $stud_id);
							$DB1->where('qual_id', $key);
							$query = $DB1->get();
							$result=$query->result_array();
							$bucketname = 'erp-asset';
			                $filepath = 'uploads/student_document/'. $result[0]['file_path'];
			                $result = $this->awssdk->deleteFile($bucket_name, $filepath); */
			            } catch (AwsException $e) {
			                echo 'Error uploading file to S3: ' . $e->getMessage();
			            }
		    		}
					if(!empty($userFile)){
					 	$exam1['degree_type'] = $val;
	                	$exam1['degree_name'] = $_POST['stream_name'][$i];
	                	$exam1['specialization'] = $_POST['seat_no'][$i];
	                	$exam1['board_uni_name'] = $_POST['institute_name'][$i];
	                	$exam1['passing_year'] = $_POST['pass_month'][$i] . "-" . $_POST['pass_year'][$i];
	                	$exam1['total_marks'] = $_POST['marks_obtained'][$i];
	                	$exam1['out_of_marks'] = $_POST['marks_outof'][$i];
	                	$exam1['percentage'] = $_POST['percentage'][$i];
					 	$exam1['file_path']=  $userFile;
					 	$exam1['modified_on'] = date("Y-m-d H:i:s");
				
					 	$dddd=$this->phd_admission_model->update_datanew($stud_id, $exam1, $qual[$i]); 
					}
				}
				else
				{
					$exam['degree_type'] = $val;
                	$exam['degree_name'] = $_POST['stream_name'][$i];
                	$exam['specialization'] = $_POST['seat_no'][$i];
                	$exam['board_uni_name'] = $_POST['institute_name'][$i];
                	$exam['passing_year'] = $_POST['pass_month'][$i] . "-" . $_POST['pass_year'][$i];
                	$exam['total_marks'] = $_POST['marks_obtained'][$i];
                	$exam['out_of_marks'] = $_POST['marks_outof'][$i];
                	$exam['percentage'] = $_POST['percentage'][$i];
                	$exam['created_on'] = date("Y-m-d H:i:s");
				 	$dddd=$this->phd_admission_model->update_datanew($stud_id, $exam, $qual[$i]); 
				}	
				$i++;
            }
        }
           
		$msg5='student application updated  successfully..';
		$this->session->set_flashdata('msg5', $msg5);
		redirect('phd_admission/edit_eduDetails');
    }
}
?>