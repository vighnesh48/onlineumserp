<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Guide_allocation_phd extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="guide_master";
    var $model_name="Guide_allocation_phd_model";
    var $model;
    var $view_dir='Guide_allocation/';
    var $data=array();
	
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
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
		$this->load->library('Awssdk');
		$this->bucket_name = 'erp-asset';
    }
	//////for Research Admin 
   public function guide_allocation_view()
   {
	   $this->load->model('phd_subject_model');
	    $this->load->view('header',$this->data);  
		$this->data['allcated_guidelist']= $this->Guide_allocation_phd_model->get_allcated_guidelist();
		/* $this->data['allcated_dept']= $this->Guide_allocation_phd_model->fetch_department(); */
		$this->data['cycle']= $this->phd_subject_model->admission_cycle();
		$this->load->view($this->view_dir.'guide_allocated_view',$this->data);
        $this->load->view('footer');
   }
   public function fetch_dept_onbatch()
   {
	   $dept_list=$this->Guide_allocation_phd_model->fetch_department($_POST);
        if(!empty($dept_list)){
                echo '<option value="">Select Department</option>';
                foreach ($dept_list as $dept) {
                    echo '<option value="' . $dept['admission_stream'] . '">' . $dept['stream_name'] . '</option>';
                }
				
            } else {
                echo '<option value="">Department not available</option>';
            }
   }
    public function search_subAndStudent()
    {
		$this->load->model('phd_subject_model');
        $this->load->view('header',$this->data);                
        $stream_id = $_POST['stream_id'];
		$academic_year = explode('-',$_POST['academic_year']);
		$academic_year =$academic_year[0];
		$semester = $_POST['semester'];
		$admission_cycle = $_POST['admission_cycle'];
		$batch=$admission_cycle;
		$this->data['courseId'] = $_POST['course_id'];
		$this->data['streamId'] = $_POST['stream_id'];
		$this->data['semesterNo'] = $_POST['semester'];
		$this->data['admission_cycle'] = $_POST['admission_cycle'];
		$this->data['SAacademic_year'] = $_POST['academic_year'];
		$this->data['batch'] = $batch;
		// added session values
		$this->session->set_userdata('SAcourseId', $_POST['course_id']);
		$this->session->set_userdata('SAstream_id', $_POST['stream_id']);
		$this->session->set_userdata('SAacademic_year', $_POST['academic_year']);
		$this->session->set_userdata('SAsemester', $_POST['semester']);
		$this->session->set_userdata('Sadmission_cycle', $_POST['admission_cycle']);
		$this->session->set_userdata('SAbatch', $batch);
		
		if(!empty($stream_id) && !empty($semester)){
			$this->data['studlist']= $this->Guide_allocation_phd_model->get_stud_list($stream_id, $semester,$academic_year,$admission_cycle);	   
			$this->data['allcated_guidelist']= $this->Guide_allocation_phd_model->get_allcated_guidelist();
			$this->data['sublist']= $this->Guide_allocation_phd_model->get_sub_list($stream_id, $semester, $batch);
			$this->data['strmsub']= $this->Guide_allocation_phd_model->get_stream_mapping_tot_subject($stream_id, $semester, $batch);
			$this->data['faculty_list']=$this->Guide_allocation_phd_model->get_faculty_list();
		}
		$this->data['course_details']= $this->phd_subject_model->getCollegeCourse($college_id);		   
		$this->data['academic_year']= $this->phd_subject_model->getAcademicYear(); 
		$this->data['regulation']= $this->phd_subject_model->getRegulation();
		$this->data['batches']= $this->phd_subject_model->getRegulation1();
		$this->data['cycle']= $this->phd_subject_model->admission_cycle();
        $this->load->view($this->view_dir.'allocate_guide',$this->data);
        $this->load->view('footer');
    }     
	 public function assign_faculty_to_student()
	 {
	   $faculty= $this->Guide_allocation_phd_model->insert_guide($_POST);
       echo $faculty;
	 }
    
        function load_streams() {
        if (isset($_POST["course_id"]) && !empty($_POST["course_id"])) {
            //Get all city data
            $stream = $this->Guide_allocation_phd_model->load_streams_student_list($_POST);           
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
	
	function load_semester() {
        if (!empty($_POST)) {
            //Get all city data
            $stream = $this->Guide_allocation_phd_model->load_semester_subjects($_POST);

            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Semester</option>';
				
                foreach ($stream as $value) {	

						echo '<option value="'.$value['semester'].'">'.$value['semester'].'</option>';	

				}					
            }else{               
				if($_POST["stream_id"]=='9' || $_POST["stream_id"]=='234' || $_POST["stream_id"]=='235' || $_POST["stream_id"]=='236' || $_POST["stream_id"]=='237' || $_POST["stream_id"]=='239'){ // || $_POST["stream_id"]=='103'
					echo '<option value="">Select Semester</option>';
					echo '<option value="1">1</option>';
					echo '<option value="2">2</option>';
				}else{
					echo '<option value="">semester not available</option>';
				}
				
            }
			unset($_POST);
        }
    }	
	
	public function fetch_guide_student_view()
	{
		$this->data['allcated_guidelist']= $this->Guide_allocation_phd_model->fetch_guide_student_view($_POST);
		$html = $this->load->view($this->view_dir.'guide_fetch_view',$this->data,true);
        echo $html ;
	}
	
	/////for Guide view
    public function guide_recommendation()
	{
	    $this->load->view('header',$this->data); 
		$role_id=$this->session->userdata("role_id");
		$this->data['allcated_studlist']= $this->Guide_allocation_phd_model->get_allcated_guidelist();
	    $this->load->view($this->view_dir.'guide_view',$this->data);
        $this->load->view('footer');
	}

    /////for Student View
	public function topic_approval_add($sem='')
	{
	    $sem=base64_decode($sem); 
	    $this->load->view('header',$this->data); 
		$role_id=$this->session->userdata("role_id");
		$this->data['doc_det']=$this->Guide_allocation_phd_model->fetch_doc_det();
		$this->data['sem_det']=$this->Guide_allocation_phd_model->fetch_sem_det();
		
		 if(!empty($sem))
		 {
		   $this->data['doc_det_stud']=$this->Guide_allocation_phd_model->fetch_doc_det($sem); 
		 }	
		$this->load->view($this->view_dir.'topic_approval_view',$this->data);
        $this->load->view('footer');
	}	
	
	public function submit_topic_approval(){

    $stud_id=$this->session->userdata("aname");
	$check_entry=$this->Guide_allocation_phd_model->check_sem_wise_entry($_POST);
	
	  if($check_entry ==0){
	  if(!empty($_FILES['rac_topic_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['rac_topic_file']['name']);
           $filenm=$stud_id.'-'.$rand.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
				$file_path = 'uploads/phd_topic_approval/'.$filenm;
				$result = $this->awssdk->uploadFile($this->bucket_name, $file_path,$_FILES['rac_topic_file']['tmp_name']);

                $appr_files['rac_topic_file'] = $filenm;
                }catch(Exception $e){
				$appr_files['rac_topic_file'] = "";    
                }

		}
		else{
			$appr_files['rac_topic_file'] = '';
		  }
		  
		   if(!empty($_FILES['research_sem_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['research_sem_file']['name']);
           $filenm=$stud_id.'-'.$rand.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/phd_topic_approval/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['research_sem_file']['tmp_name']);
                   
                   $appr_files['research_sem_file'] = $filenm;
                }catch(Exception $e){
				$appr_files['research_sem_file'] = "";    
                }

		}
		else{
			$appr_files['research_sem_file'] = '';
		  } 
		  $in_data=$this->Guide_allocation_phd_model->insert_topic_approval_files($_POST,$appr_files);
		  if($in_data > 0)
		  {
			   $_SESSION['status']="Topic Files Submittion Successfully Done.";
		  }else
		  {
			   $_SESSION['status']="Something Wrong.";
		  }	
	  }else
	  {
		  $_SESSION['status']="Current Semester Topic Files Already Submitted";  
	  }
         return redirect('Guide_allocation_phd/topic_approval_add');  		  
	}
   public function fetch_allocated_stud_det($stud_id)
   {
	    $this->load->view('header',$this->data); 
	    $stud_id=base64_decode($stud_id);
	    $this->data['stud_det']=$this->Guide_allocation_phd_model->fetch_stud_doc_details($stud_id);
		$this->data['studs']=$this->Guide_allocation_phd_model->fetch_stud_det($stud_id);
        $this->load->view($this->view_dir.'stud_doc_det',$this->data);
        $this->load->view('footer');	 
   }
     public function topic_approval_status_chng()
    {
		 $stud_id=$_POST['stud_id'];
		 $sem=$_POST['sem'];
	     $status=$_POST['status'];
		 $sts=$this->Guide_allocation_phd_model->change_topic_approval_status($stud_id,$status,$sem);
		 echo  $sts;
    }
	public function update_topic_approval()
	{
		$stud_id=$this->session->userdata("aname");
		if(!empty($_FILES['rac_topic_file']['name'])){
			 
			 if($_POST['up']['rac_file']!='')
			 {
			 $del_path='uploads/phd_topic_approval/'.$_POST['up']['rac_file'];
             $this->awssdk->deleteFile($this->bucket_name, $del_path); 
			 }
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['rac_topic_file']['name']);
		   $filenm=$stud_id.'-'.$rand.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/phd_topic_approval/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['rac_topic_file']['tmp_name']);
                   
                   $appr_files['rac_file'] = $filenm;
                }catch(Exception $e){
				$appr_files['rac_file'] = "";    
                }

		}
			if(!empty($_FILES['research_sem_file']['name'])){
			 
			 if($_POST['up']['research_file']!='')
			 {
			 $del_path='uploads/phd_topic_approval/'.$_POST['up']['research_file'];
             $this->awssdk->deleteFile($this->bucket_name, $del_path); 
			 }
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['research_sem_file']['name']);
		   $filenm=$stud_id.'-'.$rand.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/phd_topic_approval/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['research_sem_file']['tmp_name']);
                   
                   $appr_files['research_file'] = $filenm;
                }catch(Exception $e){
				$appr_files['research_file'] = "";    
                }

		}
		  $in_data=$this->Guide_allocation_phd_model->update_topic_approval_files($_POST,$appr_files);
		  if($in_data > 0)
		  {
			   $_SESSION['status']="Topic Files Updation Successfully Done.";
		  }else
		  {
			   $_SESSION['status']="Something Wrong.";
		  }
		  return redirect('Guide_allocation_phd/topic_approval_add');
	}

}
?>