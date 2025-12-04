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
        $this->load->library('excel');
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
        $this->load->helper('common_helper.php');
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
		//$this->data['faculty_list']=$this->Guide_allocation_phd_model->get_faculty_list();
		$this->data['cycle']= $this->phd_subject_model->admission_cycle();
		$this->load->view($this->view_dir.'guide_allocated_view',$this->data);
        $this->load->view('footer');
   }
   
    public function fetch_faculty_data()
	{
		$this->load->model('Guide_allocation_phd_model');
		$faculty_list = $this->Guide_allocation_phd_model->get_faculty_list();

		if (!empty($faculty_list)) {
			echo json_encode(['success' => true, 'faculty' => $faculty_list]);
		} else {
			echo json_encode(['success' => false, 'message' => 'No faculty found.']);
		}
	}

  public function new_guide_assign_tostudent()
   {
	   $chek=$this->Guide_allocation_phd_model->update_newassign_guide_data($_POST);
	   return $chek;
	   
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
		$this->data['guide_det']= $this->Guide_allocation_phd_model->fetch_guide_det();
		if($this->data['guide_det']=='')
                {
                  $this->data['guide_det']= $this->Guide_allocation_phd_model->fetch_internal_det();
                }
	    $this->load->view($this->view_dir.'guide_view',$this->data);
        $this->load->view('footer');
	 }
	 
	 public function add_guide_bank_details()
	 {
		$this->load->view('header',$this->data); 
		$this->data['guide_det']= $this->Guide_allocation_phd_model->fetch_guide_det();
		if($this->data['guide_det']=='')
                {
                  $this->data['guide_det']= $this->Guide_allocation_phd_model->fetch_internal_det();
                }
		$this->data['bank_details']=$this->Guide_allocation_phd_model->fetch_bank_det();
	    $this->load->view($this->view_dir.'add_guide_bank_det',$this->data);
        $this->load->view('footer');
	 }
	 
	 public function edit_guide_bank_details($bid)
	 {
		$this->load->view('header',$this->data); 
		$guide_id=base64_decode($bid);
		$this->data['guide_det']= $this->Guide_allocation_phd_model->fetch_guide_det($guide_id);
		if($this->data['guide_det']=='')
                {
                  $this->data['guide_det']= $this->Guide_allocation_phd_model->fetch_internal_det();
                }
		$this->data['bank_details']=$this->Guide_allocation_phd_model->fetch_bank_det();
	    $this->load->view($this->view_dir.'edit_guide_bank_det',$this->data);
        $this->load->view('footer');
	 }  
	 public function file_check($str){
    $allowed_mime_type_arr = array('image/jpeg','image/jpg','image/png','image/gif','application/pdf');
    $mime = get_mime_by_extension($_FILES['cheque_file']['name']);
    $file_size = 2097152; // 2 MB in bytes

    if(isset($_FILES['cheque_file']['name']) && $_FILES['cheque_file']['name'] != ""){
        if(in_array($mime, $allowed_mime_type_arr) && $_FILES['cheque_file']['size'] <= $file_size){
            return true;
        }else{
            $this->form_validation->set_message('file_check', 'Please select a valid file (jpeg, jpg, png, gif, pdf) and the file size must be less than 2 MB');
            return false;
        }
    }else{
        $this->form_validation->set_message('file_check', 'Please select a file');
        return false;
    }
}
	  public function insert_guide_bank_details()
	  {
		  $DB1 = $this->load->database('umsdb', TRUE);
          $roles_id=$this->session->userdata('role_id');
          $guide_id=$this->input->post('guide_id');
          $bid=$this->input->post('bid');
          $this->load->helper('security');
	
			  $config = array(
							array(
								'field' => 'bank_name',
								'label' => 'Bank Name',
								'rules' => 'trim|required',
								'errors' => array(
									'required' => 'Bank Name should not be empty',
								),
							),
							array(
								'field' => 'acc_holder_name',
								'label' => 'Account Holder Name',
								'rules' => 'trim|required|regex_match[/^[a-z\s]+$/i]|min_length[2]|max_length[50]',
								'errors' => array(
									'required' => 'Account Holder Name should not be empty',
									'regex_match' => 'Account Holder Name should be alphabetic characters and spaces only',
									'min_length' => 'Account Holder Name should be 2-50 characters long',
									'max_length' => 'Account Holder Name should be 2-50 characters long',
								),
							),
							array(
								'field' => 'acc_no',
								'label' => 'Account No',
								'rules' => 'trim|required|numeric|min_length[2]|max_length[20]',
								'errors' => array(
									'required' => 'Account no should not be empty',
									'numeric' => 'Account no should be numeric value',
									'min_length' => 'Account no should be 2-20 characters long',
									'max_length' => 'Account no should be 2-20 characters long',
								),
							),
							array(
								'field' => 'branch',
								'label' => 'Branch',
								'rules' => 'trim|required|regex_match[/^[a-zA-Z0-9 ]+$/]|min_length[2]|max_length[20]',
								'errors' => array(
									'required' => 'Branch name should not be empty',
									'regex_match' => 'Branch name can only consist of alphanumeric characters and spaces',
									'min_length' => 'Branch name should be 2-20 characters long',
									'max_length' => 'Branch name should be 2-20 characters long',
								),
							),
							array(
								'field' => 'ifsc_code',
								'label' => 'IFSC Code',
								'rules' => 'trim|required|regex_match[/^[A-Z0-9]+$/]|exact_length[11]',
								'errors' => array(
									'required' => 'IFSC should not be empty',
									'regex_match' => 'IFSC should be an alphanumeric value',
									'exact_length' => 'IFSC should be exactly 11 characters long',
								),
							),
							/* array(
								'field' => 'cheque_file',
								'label' => 'Cheque File',
								'rules' => 'trim|required|callback_file_check',
								'errors' => array(
									'required' => 'Please select a file',
									'file_check' => 'Please select a valid file (jpeg, jpg, png, gif, pdf) and the file size must be less than 2 MB',
								),
							), */
						);
           $this->form_validation->set_rules($config); 			  
          if($bid==''){
            if ($this->form_validation->run()== FALSE)
            {                    
				$this->load->view('header',$this->data); 
				$this->data['guide_det']= $this->Guide_allocation_phd_model->fetch_guide_det();
				if($this->data['guide_det']=='')
                {
                  $this->data['guide_det']= $this->Guide_allocation_phd_model->fetch_internal_det();
                }
				$this->data['bank_details']=$this->Guide_allocation_phd_model->fetch_bank_det();
				$this->load->view($this->view_dir.'add_guide_bank_det',$this->data);
				$this->load->view('footer'); 
			}
		else
		   {	
                   if(!empty($_FILES['cheque_file']['name'])){
					$rand=rand(1000,9999);
					$filenm_arr = explode(".",$_FILES['cheque_file']['name']);
					$filenm=$_POST['guide_id'].'-'.$rand.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

					try{
						$file_path = 'uploads/phd_renumaration_files/'.$filenm;
						$result = $this->awssdk->uploadFile($this->bucket_name, $file_path,$_FILES['cheque_file']['tmp_name']);
						$cheque_file = $filenm;
						}catch(Exception $e){
						$rcheque_file = "";    
						}
					}
					else{
					 $cheque_file= '';
					}
               	   
                $insert_array=array(
				"guide_id"=>$this->input->post('guide_id'),
				"bank_id"=>$this->input->post("bank_name"),
				"acc_holder_name"=>$this->input->post("acc_holder_name"),
				"acc_no"=>$this->input->post("acc_no"),
				"ifsc_code"=>$this->input->post("ifsc_code"),
				"branch"=>$this->input->post("branch"),
				"cheque_file"=>$cheque_file,
				"created_by"=>$this->session->userdata("uid")
				);
				
                 $insert=$DB1->insert("guide_bank_details", $insert_array); 
                if($insert)
                  {					
                    $_SESSION['status']="Guide Bank Details Submitted Successfully Done.";  
					  
			      }else
			      {
				   $_SESSION['status']="Something Wrong.";
			      }	
                   if($roles_id==23){
					 return redirect('Guide_allocation_phd/guide_allocation_view');  
				   }else
				   {					   
                   return redirect('Guide_allocation_phd/guide_recommendation'); 
				   }
				}             
		 }
	  else
	  {
		 if ($this->form_validation->run()== FALSE)
            {                    
               		$this->load->view('header',$this->data); 
					$this->data['guide_det']= $this->Guide_allocation_phd_model->fetch_guide_det($guide_id);
					if($this->data['guide_det']=='')
                {
                  $this->data['guide_det']= $this->Guide_allocation_phd_model->fetch_internal_det();
                }
					$this->data['bank_details']=$this->Guide_allocation_phd_model->fetch_bank_det();
					$this->load->view($this->view_dir.'edit_guide_bank_det',$this->data);
					$this->load->view('footer');
			}
		else
		   {	
                  if(!empty($_FILES['cheque_file']['name'])){
					$rand=rand(1000,9999);
					$filenm_arr = explode(".",$_FILES['cheque_file']['name']);
					$filenm=$_POST['guide_id'].'-'.$rand.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

					try{
						$file_path = 'uploads/phd_renumaration_files/'.$filenm;
						$result = $this->awssdk->uploadFile($this->bucket_name, $file_path,$_FILES['cheque_file']['tmp_name']);
						$cheque_file = $filenm;
						}catch(Exception $e){
						$cheque_file = "";    
						}

					}
					
                $update_array=array(
				"guide_id"=>$this->input->post('guide_id'),
				"bank_id"=>$this->input->post("bank_name"),
				"acc_holder_name"=>$this->input->post("acc_holder_name"),
				"acc_no"=>$this->input->post("acc_no"),
				"ifsc_code"=>$this->input->post("ifsc_code"),
				"branch"=>$this->input->post("branch"),
				"updated_by"=>$this->session->userdata("uid")
				);
				if ($cheque_file) {
					$update_array['cheque_file'] = $cheque_file;
				}
				 $DB1->where('bid',$bid);
                 $update=$DB1->update("guide_bank_details", $update_array);
				 //echo $DB1->last_query();exit;
                if($update)
                  {					
                    $_SESSION['status']="Guide Bank Details Updated Successfully.";  
					  
			      }else
			      {
				   $_SESSION['status']="Something Wrong.";
			      }		                 	
                   return redirect('Guide_allocation_phd/guide_allocation_view');  
				}             
			}
	  }
	  
    /////for Student View
	public function topic_approval_add($stud_id='')
	{
		$this->load->model('Ums_admission_model');
	    if($stud_id=='')
		{
		  $stud_id=$this->session->userdata("aname");
		}else{ $stud_id=base64_decode($stud_id); }
			
	    $this->load->view('header',$this->data); 
		$role_id=$this->session->userdata("role_id");
		$this->data['doc_det']=$this->Guide_allocation_phd_model->fetch_doc_det($stud_id,'');
		$this->data['rps_doc_files']=$this->Guide_allocation_phd_model->fetch_doc_det($stud_id,'RPS');
		$this->data['sem_det']=$this->Guide_allocation_phd_model->fetch_sem_det($stud_id);
		$this->data['admission_detail']= $this->Ums_admission_model->fetch_admission_details_all($stud_id); 
		$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id); 
		if($this->data['admission_details'][0]['batch_cycle'] !=''){
		$this->load->view($this->view_dir.'topic_approval_view',$this->data);
		}else{}
        $this->load->view('footer');
	  }	

	      public function submit_topic_approval(){

            $roles_id=$this->session->userdata('role_id');			
			$check_entry=0;
			if($_POST['type']!="guide_allot_letter"){
            $check_entry=$this->Guide_allocation_phd_model->check_sem_wise_entry($_POST);
			}
		    if($check_entry==0){
		    if(!empty($_FILES['guide_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['guide_file']['name']);
           $filenm=$_POST['student_id'].'-'.$rand.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
				$file_path = 'uploads/phd_topic_approval/'.$filenm;
				$result = $this->awssdk->uploadFile($this->bucket_name, $file_path,$_FILES['guide_file']['tmp_name']);
                $renum_files['guide_file'] = $filenm;
                }catch(Exception $e){
				$renum_files['guide_file'] = "";    
                }

		}
		else{
			 $renum_files['guide_file'] = '';
		  }

				  $in_data=$this->Guide_allocation_phd_model->insert_topic_approval_files($_POST,$renum_files);
			  if($in_data > 0)
			  {
				     if($_POST['type']=="guide_allot_letter"){
					  $_SESSION['status']="Guide Allotment Letter Submitted Successfully Done.";  
					  }
					  elseif($_POST['type']=="rac_topic_file"){
					  $_SESSION['status']="RAC (Topic Approval) File Submitted Successfully Done.";  
					  }
					  elseif ($_POST['type']=="pre_thesis"){ 
					  
					  $_SESSION['status']="RAC (Pre Thesis)File Submitted Successfully Done."; 
					  }
					  else{ 
					     $_SESSION['status']=  $_POST['type']." File Submitted Successfully Done.";  
					  }
			  }else
			  {
				   $_SESSION['status']="Something Wrong.";
			  }	
		  }else
		  {
			  if($_POST['type']!='guide_allot_letter' && $_POST['type']!='rac_topic_file' && $_POST['type']!='pre_thesis' ){
				    if(!empty($_FILES['guide_file']['name'])){
					   $rand=rand(1000,9999);
					   $filenm_arr = explode(".",$_FILES['guide_file']['name']);
					   $filenm=$_POST['student_id'].'-'.$rand.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

					  try{
							$file_path = 'uploads/phd_topic_approval/'.$filenm;
							$result = $this->awssdk->uploadFile($this->bucket_name, $file_path,$_FILES['guide_file']['tmp_name']);
							$renum_files['guide_file'] = $filenm;
							}catch(Exception $e){
							$renum_files['guide_file'] = "";    
							}

					}
					else{
						$renum_files['guide_file'] = '';
					  }
				 $up_data=$this->Guide_allocation_phd_model->update_topic_approval_files($_POST,$renum_files);  
			  }			  
			 if($_POST['type']=="guide_allot_letter"){
					  $_SESSION['status']="Guide Allotment Letter Already Submitted.";  
					  }
					  elseif($_POST['type']=="rac_topic_file"){
					  $_SESSION['status']="RAC (Topic Approval) File Already Submitted.";  
					  }
					  elseif ($_POST['type']=="pre_thesis"){ 
					  $_SESSION['status']="RAC (Pre Thesis)File Already Submitted.";  
					  }
					  else
					  {
						  if($up_data){
					          $_SESSION['status']= $_POST['type']." File Updated successfully."; 
						  }else
						  {
							  $_SESSION['status']= $_POST['type']." File updation found Some Problem !!!";  
						  }	  
					  }
		    }
			  if($roles_id==23)
		  { $stud_id=base64_encode($_POST['student_id']); }else{$stud_id='';}
			 return redirect('Guide_allocation_phd/topic_approval_add/'.$stud_id); 		 
	} 
   public function fetch_allocated_stud_det($stud_id)
   {
	    $this->load->view('header',$this->data); 
	    $stud_id=base64_decode($stud_id);
	    $this->data['stud_det_files']=$this->Guide_allocation_phd_model->fetch_doc_det($stud_id,'');
	    $this->data['stud_rps_det']=$this->Guide_allocation_phd_model->fetch_doc_det($stud_id,'RPS');
		$this->load->model('Ums_admission_model');
		$this->data['admission_detail']= $this->Ums_admission_model->fetch_admission_details_all($stud_id); 
        $this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id);
		$this->data['sem_det']=$this->Guide_allocation_phd_model->fetch_sem_det($stud_id);
        $this->load->view($this->view_dir.'stud_doc_det',$this->data);
        $this->load->view('footer');	 
   }
     public function topic_approval_status_chng()
    {
		 //$stud_id=$_POST['stud_id'];
		 $id=$_POST['id'];
	     $status=$_POST['status'];
	    // $sem=$_POST['sem'];
		 $sts=$this->Guide_allocation_phd_model->change_topic_approval_status($id,$status);
		 echo  $sts;
    }
	
      public function add_phd_renumeration($stud_id)
	   {
			$this->load->view('header',$this->data); 
			$stud_id=base64_decode($stud_id);
			$this->data['errors']=$this->session->userdata('errors');
			$this->data['table']=$this->session->userdata('table');
			$this->data['sem_det']=$this->Guide_allocation_phd_model->fetch_sem_det($stud_id);
			$this->data['renum_files']=$this->Guide_allocation_phd_model->fetch_renum_det($stud_id);
			//$this->data['renum_det']=$this->Guide_allocation_phd_model->fetch_phd_renum_det($stud_id);
			$this->data['rps_doc_files']=$this->Guide_allocation_phd_model->fetch_doc_det($stud_id,'RPS');
			$this->data['guide_renum_det']=$this->Guide_allocation_phd_model->fetch_guide_renum_det($stud_id);
			$this->data['external_det']=$this->Guide_allocation_phd_model->fetch_faculty_details('External');
			$this->data['rps_files']=$this->Guide_allocation_phd_model->fetch_doc_det_rps($stud_id,'2');
            $this->data['rps_files_details']=$this->Guide_allocation_phd_model->fetch_doc_det_rps($stud_id,'1');
			$this->load->view($this->view_dir.'add_phd_renumeration',$this->data);
			$this->load->view('footer'); 
	   }
	   public function insert_renum_data_files()
	   {
			
			$check_entry=$this->Guide_allocation_phd_model->check_renumdata_entry($_POST);
			$um_id=$this->session->userdata("uid");
			if($um_id=='3195')
			{
				$check_entry=0;
			}
		    if($check_entry==0){
		    if(!empty($_FILES['approval_copy']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['approval_copy']['name']);
           $filenm=$_POST['student_id'].'-'.$rand.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
				$file_path = 'uploads/phd_renumaration_files/'.$filenm;
				$result = $this->awssdk->uploadFile($this->bucket_name, $file_path,$_FILES['approval_copy']['tmp_name']);

                $renum_files['approval_copy_file'] = $filenm;
                }catch(Exception $e){
				$renum_files['approval_copy_file'] = "";    
                }

		}
		else{
			$renum_files['approval_copy_file'] = '';
		  }
		  	    if(!empty($_FILES['final_app_copy']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['final_app_copy']['name']);
           $filenm=$_POST['student_id'].'-'.$rand.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
				$file_path = 'uploads/phd_renumaration_files/'.$filenm;
				$result = $this->awssdk->uploadFile($this->bucket_name, $file_path,$_FILES['final_app_copy']['tmp_name']);

                $renum_files['final_approval_copy'] = $filenm;
                }catch(Exception $e){
				$renum_files['final_approval_copy'] = "";    
                }

		}
		else{
			$renum_files['final_approval_copy'] = '';
		  }
				  $in_data=$this->Guide_allocation_phd_model->insert_renum_files($_POST,$renum_files);
			  if($_POST['gid']!='')
			  {
				  $in_data=1;
				  $stm="Updated";
			  }else{ $stm='submitted'; }
			  if($in_data > 0)
			  {
				   $_SESSION['status']="Renumeration Files ".$stm." Successfully Done.";
			  }else
			  {
				   $_SESSION['status']="Something Wrong.";
			  }
		  }else
		  {
			  if($_POST['type']=="topic_approval"){
			  $_SESSION['status']="RAC Topic Approval Files Already Submitted";  
			  }
			  elseif($_POST['type']=="pre_thesis"){
			  $_SESSION['status']="RAC Pre Thesis Files Already Submitted";  
			  }
			  elseif($_POST['type']=="final_defence"){
			  $_SESSION['status']="Final Defence Files Already Submitted";  
			  }
			  elseif($_POST['type']=="course_work"){
			  $_SESSION['status']="Course Work Files Already Submitted";  
			  }
			  else
			  {
			  $_SESSION['status']="".$_POST['type']." Files Already Submitted";  
			  }

				  
		  }
			 return redirect('Guide_allocation_phd/add_phd_renumeration/'.base64_encode($_POST['student_id']));  
	  }	


     function insert_renum_excel_files(){
	    $this->load->view('header',$this->data);
        $stud_id=$_POST['student_id'];
		if($_POST){
        $table="";
        $a="";$guide_id=$_POST['guide_id'];$internal_id=$_POST['internal_id'];
		$rac_date=$_POST['rac_date'];$stud_id=$_POST['student_id'];$type=$_POST['type'];$typ='';
		$rowIndex = 0;
		$academic_year=ACADEMIC_YEAR;
		$table.="<table id='report'><thead><th>Member Name</th><th>Designation</th><th>Institute</th><th>Mobile no</th><th>Bank name</th><th>Account holder name</th><th>Account No</th><th>IFSC Code</th><th>Branch</th><th>Travelling Allowance</th><th>Renumeration</th><th>Date of RAC</th>";

         if($type=='topic_approval')
                                   {
                                          $typ=1; 
                                   }elseif($type=='pre_thesis')
                                   {
                                           $typ=3; 
                                   }elseif($type=='final_defence')
                                   {
                                          $typ=5;  
                                   }else{
                                          $typ=2;  
                                   }
		    $external=explode(',',$_POST['external']);
		    foreach($external as $ext){
				
		          $rowIndex++;
			      $amt_data=$this->Guide_allocation_phd_model->fetch_phd_renum_amount('External',$typ);
				  $amount=$amt_data->amount;
			      $ex_det=$this->Guide_allocation_phd_model->fetch_ext_renum_det($ext);
				
				 $table.="<tr><td><input type='text'  name='item[".$stud_id."][" . $rowIndex . "][member_name]' value='".$ex_det['ext_fac_name']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][designation]' value='".$ex_det['ext_fac_designation']."'  readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][institute]' value='".$ex_det['ext_fac_institute']."' readonly ></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][mobno]' value='".$ex_det['ext_fac_mobile']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][bank_name]' value='".$ex_det['bank_name']."' readonly ></td>
				<td><input type='text'  name='item[".$stud_id."][" . $rowIndex . "][accountholdername]' value='".$ex_det['acc_holder_name']."'  readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][acc_no]' value='".$ex_det['acc_no']."' readonly ></td>				
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][ifsc]' value='".$ex_det['ifsc_code']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][branch]' value='".$ex_det['branch']."' readonly ></td>
				<td><input type='text'  name='item[".$stud_id."][" . $rowIndex . "][travelling_allowance]' value='0'></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][renumeration]' value='".$amount."'  readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][rac_date]' value='".$rac_date."'  readonly >
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][student_id]' value='".$stud_id."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][academic_year]' value='".$academic_year."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][type]' value='".$type."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][bank_id]' value='".$ex_det['bank_id']."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][emp_code]' value='".$ex_det['ext_faculty_code']."'></td></tr>";
		     }
	       if($type=="topic_approval" || $type=="pre_thesis" ||$type=="final_defence"){
		    if($guide_id!=''){				
		     $gdata=$this->Guide_allocation_phd_model->fetch_guide_det($guide_id);
			 $amt_data=$this->Guide_allocation_phd_model->fetch_phd_renum_amount('Guide',$typ);
			 $amount=$amt_data->amount;
		     $rowIndex++; 
		    $table.="<tr><td><input type='text'  name='item[".$stud_id."][" . $rowIndex . "][member_name]' value='".$gdata['guide_name']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][designation]' value='".'Supervisor'."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][institute]' value='".'SUN'."' readonly ></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][mobno]' value='".$gdata['mobileNumber']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][bank_name]' value='".$gdata['bank_name']."' readonly ></td>
				<td><input type='text'  name='item[".$stud_id."][" . $rowIndex . "][accountholdername]' value='".$gdata['acc_holder_name']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][acc_no]' value='".$gdata['acc_no']."' readonly ></td>				
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][ifsc]' value='".$gdata['ifsc_code']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][branch]' value='".$gdata['branch']."' readonly ></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][travelling_allowance]' value='0' readonly ></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][renumeration]' value='".$amount."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][rac_date]' value='".$rac_date."' readonly >
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][student_id]' value='".$stud_id."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][academic_year]' value='".$academic_year."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][type]' value='".$type."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][bank_id]' value='".$gdata['bank_id']."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][emp_code]' value='".$guide_id."'></td></tr>";
			  } 
		   }
			    if($internal_id!='' && $internal_id!=0 ){
				  $rowIndex++;$amount='';$designation='';
				  $gdata=$this->Guide_allocation_phd_model->fetch_internal_det($internal_id);
				  if($type=="final_defence")
				  {
					 $designation="Chairperson";
					 $amt_data=$this->Guide_allocation_phd_model->fetch_phd_renum_amount('Chairperson',$typ);
			         $amount=$amt_data->amount;
					 
				  }else{
					  $designation="Internal";
					  $amt_data=$this->Guide_allocation_phd_model->fetch_phd_renum_amount('Internal',$typ);
			          $amount=$amt_data->amount;

					  }
				  $table.="<tr><td><input type='text'  name='item[".$stud_id."][" . $rowIndex . "][member_name]' value='".$gdata['guide_name']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][designation]' value='".$designation."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][institute]' value='".'SUN'."' readonly ></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][mobno]' value='".$gdata['mobileNumber']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][bank_name]' value='".$gdata['bank_name']."' readonly ></td>
				<td><input type='text'  name='item[".$stud_id."][" . $rowIndex . "][accountholdername]' value='".$gdata['acc_holder_name']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][acc_no]' value='".$gdata['acc_no']."' readonly ></td>				
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][ifsc]' value='".$gdata['ifsc_code']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][branch]' value='".$gdata['branch']."' readonly ></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][travelling_allowance]' value='0' readonly ></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][renumeration]' value='".$amount."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][rac_date]' value='".$rac_date."' readonly >
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][student_id]' value='".$stud_id."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][academic_year]' value='".$academic_year."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][type]' value='".$type."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][bank_id]' value='".$gdata['bank_id']."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][emp_code]' value='".$internal_id."'></td></tr>";
			}
		
			$this->data['errors']=$a;
			$this->data['table']=$table;
			$this->data['sem_det']=$this->Guide_allocation_phd_model->fetch_sem_det($stud_id);
			$this->data['renum_files']=$this->Guide_allocation_phd_model->fetch_renum_det($stud_id);
			$this->data['rps_doc_files']=$this->Guide_allocation_phd_model->fetch_doc_det($stud_id,'RPS');
			$this->data['guide_renum_det']=$this->Guide_allocation_phd_model->fetch_guide_renum_det($stud_id);
			$this->data['external_det']=$this->Guide_allocation_phd_model->fetch_faculty_details('External');
			$this->data['rps_files']=$this->Guide_allocation_phd_model->fetch_doc_det_rps($stud_id,'2');
			$this->data['rps_files_details']=$this->Guide_allocation_phd_model->fetch_doc_det_rps($stud_id,'1');
			$this->load->view($this->view_dir.'add_phd_renumeration',$this->data);
			$this->load->view('footer'); 

		}
     else{
        $_SESSION['status']="Uploaded File is empty";
	    return redirect('Guide_allocation_phd/add_phd_renumeration/'.base64_encode($stud_id));
       }  	  
    }



    function insert_renum_excel_files44(){
	    $this->load->view('header',$this->data);
        $stud_id=$_POST['student_id'];
		if($_POST){
        $table="";
        $a="";$guide_id=$_POST['guide_id'];$internal_id=$_POST['internal_id'];
		$rac_date=$_POST['rac_date'];$stud_id=$_POST['student_id'];$type=$_POST['type'];
		$rowIndex = 0; // Initialize row index
		$academic_year=ACADEMIC_YEAR;
		$table.="<table id='report' ><thead><th>Member Name</th><th>Designation</th><th>Institute</th><th>Mobile no</th><th>Bank name</th><th>Account holder name</th><th>Account No</th><th>IFSC Code</th><th>Branch</th><th>Travelling Allowance</th><th>Renumeration</th><th>Date of RAC</th>";

		    $external=explode(',',$_POST['external']);
		    foreach($external as $ext){
				
		          $rowIndex++;$amount="1500";
			      $ex_det=$this->Guide_allocation_phd_model->fetch_ext_renum_det($ext);
				
				 $table.="<tr><td><input type='text'  name='item[".$stud_id."][" . $rowIndex . "][member_name]' value='".$ex_det['ext_fac_name']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][designation]' value='".$ex_det['ext_fac_designation']."'  readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][institute]' value='".$ex_det['ext_fac_institute']."' readonly ></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][mobno]' value='".$ex_det['ext_fac_mobile']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][bank_name]' value='".$ex_det['bank_name']."' readonly ></td>
				<td><input type='text'  name='item[".$stud_id."][" . $rowIndex . "][accountholdername]' value='".$ex_det['acc_holder_name']."'  readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][acc_no]' value='".$ex_det['acc_no']."' readonly ></td>				
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][ifsc]' value='".$ex_det['ifsc_code']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][branch]' value='".$ex_det['branch']."' readonly ></td>
				<td><input type='text'  name='item[".$stud_id."][" . $rowIndex . "][travelling_allowance]' ></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][renumeration]' value='".$amount."'  readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][rac_date]' value='".$rac_date."'  readonly >
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][student_id]' value='".$stud_id."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][academic_year]' value='".$academic_year."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][type]' value='".$type."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][bank_id]' value='".$ex_det['bank_id']."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][emp_code]' value='".$ex_det['ext_faculty_code']."'></td></tr>";

		}
	       
		    if($guide_id!=''){				
		     $gdata=$this->Guide_allocation_phd_model->fetch_guide_det($guide_id);
		     $rowIndex++; $amount='1000';
		    $table.="<tr><td><input type='text'  name='item[".$stud_id."][" . $rowIndex . "][member_name]' value='".$gdata['guide_name']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][designation]' value='".'Supervisor'."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][institute]' value='".'SUN'."' readonly ></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][mobno]' value='".$gdata['mobileNumber']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][bank_name]' value='".$gdata['bank_name']."' readonly ></td>
				<td><input type='text'  name='item[".$stud_id."][" . $rowIndex . "][accountholdername]' value='".$gdata['acc_holder_name']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][acc_no]' value='".$gdata['acc_no']."' readonly ></td>				
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][ifsc]' value='".$gdata['ifsc_code']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][branch]' value='".$gdata['branch']."' readonly ></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][travelling_allowance]' value='0' readonly ></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][renumeration]' value='".$amount."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][rac_date]' value='".$rac_date."' readonly >
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][student_id]' value='".$stud_id."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][academic_year]' value='".$academic_year."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][type]' value='".$type."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][bank_id]' value='".$gdata['bank_id']."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][emp_code]' value='".$guide_id."'></td></tr>";
			} 
			if($internal_id!=''){
				  $rowIndex++;$amount='';$designation='';
				  $gdata=$this->Guide_allocation_phd_model->fetch_internal_det($internal_id);
				  if($type=="final_defence")
				  {
					 $designation="Chairperson";
                     $amount="500";					 
				  }else{$designation="Internal";$amount="1000";}
				  $table.="<tr><td><input type='text'  name='item[".$stud_id."][" . $rowIndex . "][member_name]' value='".$gdata['guide_name']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][designation]' value='".$designation."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][institute]' value='".'SUN'."' readonly ></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][mobno]' value='".$gdata['mobileNumber']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][bank_name]' value='".$gdata['bank_name']."' readonly ></td>
				<td><input type='text'  name='item[".$stud_id."][" . $rowIndex . "][accountholdername]' value='".$gdata['acc_holder_name']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][acc_no]' value='".$gdata['acc_no']."' readonly ></td>				
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][ifsc]' value='".$gdata['ifsc_code']."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][branch]' value='".$gdata['branch']."' readonly ></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][travelling_allowance]' value='0' readonly ></td>
				<td><input type='number'  name='item[".$stud_id."][" . $rowIndex . "][renumeration]' value='".$amount."' readonly ></td>
				<td><input type='text'   name='item[".$stud_id."][" . $rowIndex . "][rac_date]' value='".$rac_date."' readonly >
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][student_id]' value='".$stud_id."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][academic_year]' value='".$academic_year."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][type]' value='".$type."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][bank_id]' value='".$gdata['bank_id']."'>
				<input type='hidden'   name='item[".$stud_id."][" . $rowIndex . "][emp_code]' value='".$internal_id."'></td></tr>";
			}
		
			$this->data['errors']=$a;
			$this->data['table']=$table;
			$this->data['sem_det']=$this->Guide_allocation_phd_model->fetch_sem_det($stud_id);
			$this->data['renum_files']=$this->Guide_allocation_phd_model->fetch_renum_det($stud_id);
			$this->data['rps_doc_files']=$this->Guide_allocation_phd_model->fetch_doc_det($stud_id,'RPS');
			$this->data['guide_renum_det']=$this->Guide_allocation_phd_model->fetch_guide_renum_det($stud_id);
			$this->data['external_det']=$this->Guide_allocation_phd_model->fetch_faculty_details('External');
			$this->load->view($this->view_dir.'add_phd_renumeration',$this->data);

		}
     else{
        $_SESSION['status']="Uploaded File is empty";
	    return redirect('Guide_allocation_phd/add_phd_renumeration/'.base64_encode($stud_id));
       }  	  
    }
	 
 
		public function add_renum_data_details()
{

    $m = '';
    $DB1 = $this->load->database('umsdb', TRUE);
    if (isset($_POST) && !empty($_POST)) {
        $items = $_POST['item'];

             $all_data_valid = true; // Flag to check if all entries are valid
        $missing_fields_info = []; // To log missing fields

        // Validate all entries
        foreach ($items as $stud_id => $rows) {
            foreach ($rows as $rowIndex => $data_to_insert) {
                // Required fields for validation
                $required_fields = [
                    'member_name',
                    'designation',
                    'institute',
                    'mobno',
                    'accountholdername',
                    'acc_no',
                    'ifsc',
                    'branch',
                    'renumeration',
                    'rac_date'
                ];

                // Check if any required field is empty
                $missing_fields = [];
                foreach ($required_fields as $field) {
                    if (empty($data_to_insert[$field])) {
                        $missing_fields[] = $field;
                    }
                }

                // If missing fields are found, mark as invalid and log details
                if (!empty($missing_fields)) {
                    $all_data_valid = false;
                    $missing_fields_info[] = [
                        'member_name' => $data_to_insert['member_name'] ?? 'Unknown',
                        'missing_fields' => implode(', ', $missing_fields),
                    ];
                }
            }
        }

        // If any entry is invalid, return an error and skip insertion
        if (!$all_data_valid) {
            foreach ($missing_fields_info as $info) {
                $m .= "Member name: {$info['member_name']} is missing the following fields: {$info['missing_fields']}.\n";
            }
            $_SESSION['status'] = nl2br($m);
            return redirect('Guide_allocation_phd/add_phd_renumeration/' . base64_encode($stud_id));
        }
             
        foreach ($items as $stud_id => $rows) {
            foreach ($rows as $rowIndex => $data_to_insert) {
				
			    $data_to_insert['rac_date']=date('d-m-Y',strtotime($data_to_insert['rac_date']));
                $member_name = $data_to_insert['member_name'];
                $acno = $data_to_insert['acc_no'];
                $stud_id = $data_to_insert['student_id'];
                $type = $data_to_insert['type'];
                $amount = $data_to_insert['renumeration']+$data_to_insert['travelling_allowance'];
                $data_to_insert['amount'] = $amount;
                $emp_code = $data_to_insert['emp_code'];
                $designation = $data_to_insert['designation'];
                $uid = $this->session->userdata("uid");
                $data_to_insert['created_by'] = $uid;
				unset($data_to_insert['bank_name']);
                $check_entry_alread_updated = $DB1->query("SELECT * FROM phd_renumeration_details WHERE student_id = ? AND type = ? AND emp_code = ?", [$stud_id, $type, $emp_code])->row();

                if (empty($check_entry_alread_updated)) {
                    // Insert data
                    $DB1->insert('phd_renumeration_details', $data_to_insert);
					//echo $DB1->last_query();exit;
                    $insert_id = $DB1->insert_id();
                    if (!empty($insert_id)) {
						
					    $m .= "Member name: $member_name with account number $acno entry with amount $amount done successfully.\n";
						
                    } else {
                        $m .= "Member name: $member_name with account number $acno entry with amount $amount not done. Some error occurred.\n";
                    }
                } else {
                    $m .= "Member name: $member_name with account number $acno entry with amount $amount already exists.\n";
				
                }
            }
        }

        $_SESSION['status'] = nl2br($m);
		
        return redirect('Guide_allocation_phd/add_phd_renumeration/'.base64_encode($stud_id));
    } else {
        $_SESSION['status'] = "No data to process.";
        return redirect('Guide_allocation_phd/add_phd_renumeration/'.base64_encode($stud_id));
    }
}

    
	   public function add_phd_section_upload_files($stud_id='')
	   {
			$this->load->view('header',$this->data); 
			$stud_id=base64_decode($stud_id);
			$this->data['sem_det']=$this->Guide_allocation_phd_model->fetch_sem_det($stud_id);
			$this->data['renum_files']=$this->Guide_allocation_phd_model->fetch_phdsec_renum_det($stud_id);
			$this->data['rps_doc_files']=$this->Guide_allocation_phd_model->fetch_doc_det($stud_id,'RPS');
			$this->load->view($this->view_dir.'phd_section_upload_view',$this->data);
			$this->load->view('footer'); 
	   }

      public function insert_phdsection_renum_files()
	  {
		  	$check_entry=$this->Guide_allocation_phd_model->check_phdsec_renumletter_entry($_POST);
		    if($check_entry==0){
		    if(!empty($_FILES['approval_copy']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['approval_copy']['name']);
           $filenm=$_POST['student_id'].'-'.$rand.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
				$file_path = 'uploads/phd_renumaration_files/'.$filenm;
				$result = $this->awssdk->uploadFile($this->bucket_name, $file_path,$_FILES['approval_copy']['tmp_name']);

                $renum_files['approval_copy_file'] = $filenm;
                }catch(Exception $e){
				$renum_files['approval_copy_file'] = "";    
                }

		}
		else{
			$renum_files['approval_copy_file'] = '';
		  }

		   $in_data=$this->Guide_allocation_phd_model->insert_phdsection_renum_files($_POST,$renum_files);
			  if($in_data > 0)
			  {
				   $_SESSION['status']="Renumeration Letters Submitted Successfully Done.";
			  }else
			  {
				   $_SESSION['status']="Something Wrong.";
			  }	
		  }else
		  {
			  if($_POST['type']=="pro_adm_letter"){
			  $_SESSION['status']="Provisional Admission Letter File Already Submitted";  
			  }
			  elseif($_POST['type']=="pre_thesis_notf"){
			  $_SESSION['status']="RAC (Pre Thesis Notification) File Already Submitted";  
			  }
			  elseif($_POST['type']=="thesis_sub_let"){
			  $_SESSION['status']="Thesis submission letter File Already Submitted";  
			  }
			  else{
			  $_SESSION['status']="Thesis Panel submission letter File Already Submitted";  
			  }				  
		  }
			 return redirect('Guide_allocation_phd/add_phd_section_upload_files/'.base64_encode($_POST['student_id'])); 
	  }
	  public function add_coe_upaward_files($stud_id)
	  {
		  	$this->load->view('header',$this->data); 
			$stud_id=base64_decode($stud_id);
			$this->data['sem_det']=$this->Guide_allocation_phd_model->fetch_sem_det($stud_id);
			$this->data['renum_files']=$this->Guide_allocation_phd_model->fetch_coe_notifletter_det($stud_id);
			$this->load->view($this->view_dir.'coe_upload_award_files',$this->data);
			$this->load->view('footer'); 
	  }
	   public function insert_coe_notification_files()
	  {
		  	$check_entry=$this->Guide_allocation_phd_model->check_coe_notifiletter_entry($_POST);
		    if($check_entry==0){
		    if(!empty($_FILES['approval_copy']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['approval_copy']['name']);
           $filenm=$_POST['student_id'].'-'.$rand.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
				$file_path = 'uploads/phd_renumaration_files/'.$filenm;
				$result = $this->awssdk->uploadFile($this->bucket_name, $file_path,$_FILES['approval_copy']['tmp_name']);

                $renum_files['approval_copy_file'] = $filenm;
                }catch(Exception $e){
				$renum_files['approval_copy_file'] = "";    
                }

		}
		else{
			$renum_files['approval_copy_file'] = '';
		  }

				  $in_data=$this->Guide_allocation_phd_model->insert_coe_notf_files($_POST,$renum_files);
			  if($in_data > 0)
			  {
				     if($_POST['type']=="pvcc_notf"){
					  $_SESSION['status']="PVVC Notification Letter Submitted Successfully Done.";  
					  }
					  else{
					  $_SESSION['status']="Award Notification letter Submitted Successfully Done.";  
					  }
			  }else
			  {
				   $_SESSION['status']="Something Wrong.";
			  }	
		  }else
		  {
			  if($_POST['type']=="pvcc_notf"){
			  $_SESSION['status']="PVVC Notification Letter Already Submitted";  
			  }
			  else{
			  $_SESSION['status']="Award Notification letter Already Submitted";  
			  } 
		  }
			 return redirect('Guide_allocation_phd/add_coe_upaward_files/'.base64_encode($_POST['student_id'])); 
	  }
	  
	  
	  public function add_thesis_ev_dispatch_records($stud_id)
	  {
		  	$this->load->view('header',$this->data); 
			$stud_id=base64_decode($stud_id);
			$this->data['sem_det']=$this->Guide_allocation_phd_model->fetch_sem_det($stud_id);
			$this->data['dispatch_det']=$stud_data=$this->Guide_allocation_phd_model->fetch_dispatch_details($stud_id);
			$this->data['reviewer_det']=$this->Guide_allocation_phd_model->fetch_faculty_details('Previewer');
		
			$reviewer_names = [];
			foreach ($stud_data as $key => $student) {
				
				$reviewer_names[$key] = $student['reviewer_name'];
			}
			$this->data['reviewer_names']=$reviewer_names;
			$this->data['bank_details']=$this->Guide_allocation_phd_model->fetch_bank_det();
			$this->load->view($this->view_dir.'add_thesis_ev_dispatch_record',$this->data);
			$this->load->view('footer'); 
	  }
	    public function edit_thesis_ev_dispatch_records($id)
	  {
		  	$this->load->view('header',$this->data); 
			$id=base64_decode($id);
			$this->data['reviewer_det']=$this->Guide_allocation_phd_model->fetch_faculty_details('Previewer');
			$this->data['dispatch_det']=array_shift($this->Guide_allocation_phd_model->fetch_dispatch_details('',$id));
			$this->data['bank_details']=$this->Guide_allocation_phd_model->fetch_bank_det();
			$this->load->view($this->view_dir.'edit_thesis_ev_dispatch_record',$this->data);
			$this->load->view('footer'); 
	  }
	  
	  
	  
	  public function submit_thesis_dispatch_records()
	  {
		  $DB1 = $this->load->database('umsdb', TRUE);
          $student_id=$this->input->post('student_id');
          $rid=$this->input->post('rid');
          $this->load->helper('security');
		  $chek=$this->Guide_allocation_phd_model->fetch_viewer_det('',$student_id);

			   $config = array(
            array(
                'field' => 'reviewer',
                'label' => 'Reviewer Name',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'reviewer_code',
                'label' => 'Reviewer Name',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'aff_instiute',
                'label' => 'Institute Name',
                'rules' => 'trim|required|regex_match[/^[a-z\s]+$/i]|min_length[2]|max_length[50]'
            ),
            array(
                'field' => 'institute_addr',
                'label' => 'Institute Address',
                'rules' => 'trim|required|min_length[2]|max_length[100]'
            ),
            array(
                'field' => 'dispatch_date',
                'label' => 'Dispatch Date',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'tracking_no',
                'label' => 'Tracking No.',
                'rules' => 'trim|required|regex_match[/^[a-zA-Z0-9 ]+$/]|min_length[4]|max_length[12]'
            ),
            array(
                'field' => 'receipt_date',
                'label' => 'Receipt Date',
                'rules' => 'trim|required'
            ),
        );
           $this->form_validation->set_rules($config); 			  
          if($rid==''){
			   if($chek < 3){
            if ($this->form_validation->run()== FALSE)
            {                    
				$this->load->view('header',$this->data); 
				$this->data['sem_det']=$this->Guide_allocation_phd_model->fetch_sem_det($student_id);
				$this->data['bank_details']=$this->Guide_allocation_phd_model->fetch_bank_det();
				$this->load->view($this->view_dir.'add_thesis_ev_dispatch_record',$this->data);
				$this->load->view('footer'); 
			}
		else
		   {	$amt_data=$this->Guide_allocation_phd_model->fetch_phd_renum_amount('Reviewer',$typ);
                $amount=$amt_data->amount;
                $insert_array=array(
				"student_id"=>$this->input->post('student_id'),
				"enrollment_no"=>$this->input->post('enrollment_no'),
				"reviewer"=>$this->input->post('reviewer'),
				"reviewer_code"=>$this->input->post('reviewer_code'),
				"aff_instiute"=>$this->input->post('aff_instiute'),
				"institute_addr"=>$this->input->post('institute_addr'),
				"dispatch_date"=>$this->input->post("dispatch_date"),
				"amount"=>$amount,
				"academic_year"=>ACADEMIC_YEAR,
				"tracking_no"=>$this->input->post("tracking_no"),
				"receipt_date"=>$this->input->post("receipt_date"),
				"created_by"=>$this->session->userdata("uid")
				);
				
                 $insert=$DB1->insert("phd_thesis_ev_dispatch_record", $insert_array); 
                if($insert)
                  {	
							$emp_code=$this->input->post('reviewer_code');
							$member_det=$this->Guide_allocation_phd_model->fetch_member_det($emp_code);
							$renum_array=array(
							"student_id"=>$this->input->post('student_id'),
							"academic_year"=>ACADEMIC_YEAR,
							"type"=>'',
							"emp_code"=>$this->input->post('reviewer_code'),
							"member_name"=>$member_det['ext_fac_name'],
							"designation"=>$member_det['ext_fac_designation'],
							"institute"=>$this->input->post('aff_instiute'),
							"mobno"=> $member_det['ext_fac_mobile'],
							"bank_id"=> $member_det['bank_id'],
							"accountholdername"=> $member_det['acc_holder_name'],
							"acc_no"=>$member_det['acc_no'],
							"ifsc"=>$member_det['ifsc_code'],
							"branch"=>$member_det['branch'],
							"amount"=>$amount,
							"rac_date"=>'',
							"created_by"=>$this->session->userdata("uid"),
							);

							$DB1->insert("phd_renumeration_details", $renum_array);


			  
                    $_SESSION['status']="Thesis Dispatch Records Submitted Successfully Done.";  
					  
			      }else
			      {
				   $_SESSION['status']="Something Wrong.";
			      }		                 	
                   return redirect('Guide_allocation_phd/add_thesis_ev_dispatch_records/'.base64_encode($student_id)); 
				}             
			}
		  else
		  {
			  $_SESSION['status']="Already 3 Reviewers Records Submitted Against This Students";
			  return redirect('Guide_allocation_phd/add_thesis_ev_dispatch_records/'.base64_encode($student_id)); 
		  }
		 }
	  else
	  {
		 if ($this->form_validation->run()== FALSE)
            {                    
                $this->load->view('header',$this->data); 
				$this->data['dispatch_det']=array_shift($this->Guide_allocation_phd_model->fetch_dispatch_details('',$rid));
				$this->data['bank_details']=$this->Guide_allocation_phd_model->fetch_bank_det();
				$this->load->view($this->view_dir.'edit_thesis_ev_dispatch_record',$this->data);
				$this->load->view('footer'); 
			}
		else
		   {		
                $update_array=array(
				"student_id"=>$this->input->post('student_id'),
				"enrollment_no"=>$this->input->post('enrollment_no'),
				"reviewer"=>$this->input->post('reviewer'),
				"reviewer_code"=>$this->input->post('reviewer_code'),
				"aff_instiute"=>$this->input->post('aff_instiute'),
				"institute_addr"=>$this->input->post('institute_addr'),
				"dispatch_date"=>$this->input->post("dispatch_date"),
				"tracking_no"=>$this->input->post("tracking_no"),
				"receipt_date"=>$this->input->post("receipt_date"),
				"updated_by"=>$this->session->userdata("uid")
				);
				
				 $DB1->where('id',$rid);
                 $update=$DB1->update("phd_thesis_ev_dispatch_record", $update_array);
				 
                if($update)
                  {					
                    $_SESSION['status']="Thesis Dispatch Records Updated Successfully.";  
					  
			      }else
			      {
				   $_SESSION['status']="Something Wrong.";
			      }		                 	
                   return redirect('Guide_allocation_phd/add_thesis_ev_dispatch_records/'.base64_encode($student_id)); 
				}             
			}
		 
        }			
    
	   public function fetch_reviewer_det()
	   {
		  $chek=$this->Guide_allocation_phd_model->fetch_viewer_det($_POST['rev'],$_POST['stud_id']);
		  echo $chek;
	   }
	   
	   ///////for account view
	     public function account_phd_renum()
	   {
		   if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==40){
		}else{
			redirect('home');
		}
			$this->load->model('phd_subject_model');
			$this->load->view('header',$this->data);  
			$this->data['academic_year']=fetch_active_year();
			$this->data['renum_det']= $this->Guide_allocation_phd_model->fetch_overall_renum_det();		
			$this->data['cycle']= $this->phd_subject_model->admission_cycle();
			$this->data['guide_det']= $this->Guide_allocation_phd_model->fetch_guide_external_det();
			$this->data['renum_types']= $this->Guide_allocation_phd_model->fetch_renum_types_det();
			$this->data['renum_amount_det']= $this->Guide_allocation_phd_model->fetch_phd_renum_amount();
			$this->load->view($this->view_dir.'account_phd_renum_view',$this->data);
			$this->load->view('footer');
	   }
			
		public function fetch_guide_renumeration_det()
		{
			 $emp_code=$this->input->post('emp_code');
			 $acad_year=$this->input->post('acad_year');
			 $ren_month=$this->input->post('ren_month');
			 $this->data['ren_month']=$ren_month;
			 $this->data['renum_det']= $this->Guide_allocation_phd_model->fetch_overall_renum_det($emp_code,$acad_year,$ren_month);
			 $html = $this->load->view($this->view_dir.'guide_renumeration_det',$this->data,true);
			 echo $html ;
		}
		
	   
	  
		 public function make_payment($emp_code='',$acad_year='')
	   {
		    $this->load->view('header',$this->data); 
		    $emp_code=base64_decode($emp_code);
			$acad_year=base64_decode($acad_year);
			$this->data['renum_det']= array_shift($this->Guide_allocation_phd_model->fetch_overall_renum_det($emp_code,$acad_year));	
			$this->data['bank_details']=$this->Guide_allocation_phd_model->fetch_bank_det();
			$this->load->view($this->view_dir.'add_payment',$this->data);
			$this->load->view('footer'); 
	   }
	   
	    public function payment_view_history($emp_code='',$acad_year='')
	   {
		    $this->load->view('header',$this->data); 
			$emp_code=base64_decode($emp_code);
			$acad_year=base64_decode($acad_year);
			$this->data['renum_det']= array_shift($this->Guide_allocation_phd_model->fetch_overall_renum_det($emp_code,$acad_year));	
			$this->data['payment_det']= $this->Guide_allocation_phd_model->fetch_payment_renum_det($emp_code,$acad_year);	
			$this->load->view($this->view_dir.'payment_view_history',$this->data);
			$this->load->view('footer'); 
	   }
	   public function insert_payment_details()
	   {
		  $DB1 = $this->load->database('umsdb', TRUE);
          $emp_code=$this->input->post('emp_code');
          $acad_year=$this->input->post('academic_year');
          $this->load->helper('security');

					$config = array(
					array( 
						'field' => 'bank_name',
						'label' => 'Bank Name',
						'rules' => 'trim|required',
						'errors' => array(
							'required' => 'The Bank Name field is required.'
						)
					),
					 array(
							'field' => 'cheq_date',
							'label' => 'Cheque Date',
							'rules' => 'trim|required',
							'errors' => array(
								'required' => 'The Cheque Date field is required.'
							)
						),
					    array(
								'field' => 'pay_mode',
								'label' => 'Payment Mode',
								'rules' => 'trim|required|regex_match[/^[a-zA-Z\/]+$/]',
								'errors' => array(
									'required' => 'The Payment Mode field is required.',
									'regex_match' => 'The Payment Mode field should contain only alphabetic characters and slashes.'
								)
							),
					array(
						'field' => 'amount',
						'label' => 'Amount',
						'rules' => 'trim|required|numeric|greater_than[0]|max_length[8]',
						'errors' => array(
							'required' => 'The Amount field is required.',
							'numeric' => 'The Amount field must contain only numbers.',
							'greater_than' => 'The Amount field must be greater than zero.',
							'max_length' => 'The Amount field cannot exceed 8 characters in length.'
						)
					),
					
					array(
						'field' => 'cheq_no',
						'label' => 'Cheque No',
						'rules' => 'trim|required|numeric|exact_length[6]',
						'errors' => array(
							'required' => 'The Cheque No field is required.',
							'numeric' => 'The Cheque No field must contain only numbers.',
							'exact_length' => 'The Cheque No field must be exactly 6 characters in length.'
						)
					),
					array(
						'field' => 'remark',
						'label' => 'Remark',
						'rules' => 'trim|required|min_length[2]|max_length[250]',
						'errors' => array(
							'required' => 'The Remark field is required.',
							'min_length' => 'The Remark field must be at least 2 characters in length.',
							'max_length' => 'The Remark field cannot exceed 250 characters in length.'
						)
					),
					array(
						'field' => 'ref_no',
						'label' => 'Reference No',
						'rules' => 'trim|required|alpha_dash|min_length[2]|max_length[25]',
						'errors' => array(
							'required' => 'The Reference No field is required.',
							'alpha_dash' => 'The Reference No field can only contain alphabets, numbers, and dashes.',
							'min_length' => 'The Reference No field must be at least 2 characters in length.',
							'max_length' => 'The Reference No field cannot exceed 25 characters in length.'
						)
					),
				);
             $this->form_validation->set_rules($config); 			     
            if ($this->form_validation->run()== FALSE)
            {        			 
				    $this->load->view('header',$this->data);                    					
					$this->data['renum_det']= array_shift($this->Guide_allocation_phd_model->fetch_overall_renum_det($emp_code,$acad_year));	
					$this->data['bank_details']=$this->Guide_allocation_phd_model->fetch_bank_det();
					$this->load->view($this->view_dir.'add_payment',$this->data);
					$this->load->view('footer'); 
			}
		 else
		     {	

		             if(!empty($_FILES['cheque_file']['name'])){
					$rand=rand(1000,9999);
					$filenm_arr = explode(".",$_FILES['cheque_file']['name']);
					$filenm=$emp_code.'-'.$rand.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

					try{
						$file_path = 'uploads/phd_renumaration_files/'.$filenm;
						$result = $this->awssdk->uploadFile($this->bucket_name, $file_path,$_FILES['cheque_file']['tmp_name']);
						$cheque_file = $filenm;
						}catch(Exception $e){
						$rcheque_file = "";    
						}
					}
					else{
					 $cheque_file= '';
					}
	         
                $insert_array=array(
				"emp_code"=>$emp_code,
				"academic_year"=> $acad_year,
				"amount"=>$this->input->post('amount'),
				"pay_mode"=>$this->input->post('pay_mode'),
				"bank_id"=>$this->input->post('bank_name'),
				"cheq_no"=>$this->input->post('cheq_no'),
				"cheq_date"=>$this->input->post('cheq_date'),
				"ref_no"=>$this->input->post('ref_no'),
				"cheque_file"=>$cheque_file,
				"remark"=>$this->input->post("remark"),
				"created_by"=>$this->session->userdata("uid")
				);
				
                 $insert=$DB1->insert("phd_renumeration_payment", $insert_array); 
                if($insert)
                  {					
                    $_SESSION['status']="Payment Details Submitted Successfully Done.";  
					  
			      }else
			      {
				   $_SESSION['status']="Something Wrong.";
			      }		                 	
                   return redirect('Guide_allocation_phd/payment_view_history/'.base64_encode($emp_code).'/'.base64_encode($acad_year)); 
				}             
		 
	   }


		public function download_renumeration_pdf()
	 {
		 $this->load->library('m_pdf');
		  $rac_date=$_POST['rac_date'];$stud_id=$_POST['student_id'];$type=$_POST['type'];$ex_det=[];$guide_id=$_POST['guide_id'];$internal_id=$_POST['internal_id'];
		   $external=explode(',',$_POST['external']);
		    foreach($external as $ext){				
			      $details=$this->Guide_allocation_phd_model->fetch_ext_renum_det($ext,$stud_id,$type);
				  $ex_det[]=$details;
			}
			
			if($guide_id!=''){				
		     $gdata=$this->Guide_allocation_phd_model->fetch_guide_det($guide_id,$stud_id,$type);
			}
			if($internal_id!=''){
				  $rowIndex++;$amount='';$designation='';
				  $intdata=$this->Guide_allocation_phd_model->fetch_internal_det($internal_id,$stud_id,$type);
			}

			$this->data['sem_det']=$this->Guide_allocation_phd_model->fetch_sem_det($stud_id);
			$this->data['post']=$_POST;
			$this->data['ex_det']=$ex_det;
			$this->data['gdata']=$gdata;
			$this->data['intdata']=$intdata;

			$html = $this->load->view($this->view_dir.'phd_renumeration_pdf', $this->data, true);				
			$pdfFilePath ="Phd_Renumeration.pdf";
			$this->m_pdf->pdf=new mPDF('L','A4-L','','',5,10,5,17,5,10);
			$this->m_pdf->pdf->WriteHTML($html);
			$this->m_pdf->pdf->Output($pdfFilePath, "D");
	 }
	
/* public function fetch_guide_renumeration_det_view($emp_code='',$acad_year='')
		{   
		     $this->load->view('header',$this->data); 
		     $emp_code=base64_decode($emp_code);
		     $acad_year=base64_decode($acad_year);
			 $this->data['renum_det']= $this->Guide_allocation_phd_model->fetch_guide_renum_details($emp_code,$acad_year);
			 $this->data['renum_amount_det']= $this->Guide_allocation_phd_model->fetch_phd_renum_amount();
			 $this->load->view($this->view_dir.'guide_renumeration_det_view',$this->data);
	         $this->load->view('footer'); 
		} */
		
		public function fetch_guide_renumeration_det_view($emp_code='',$acad_year='',$ren_month='')
		{   
		     $this->load->view('header',$this->data); 
		     $emp_code=base64_decode($emp_code);
		     $acad_year=base64_decode($acad_year);
		     $ren_month=base64_decode($ren_month);
			 $this->data['renum_det']= $this->Guide_allocation_phd_model->fetch_guide_renum_details($emp_code,$acad_year,$ren_month);
			 $this->data['renum_amount_det']= $this->Guide_allocation_phd_model->fetch_phd_renum_amount();
			 $this->load->view($this->view_dir.'guide_renumeration_det_view',$this->data);
	         $this->load->view('footer'); 
		}

public function guide_exportExcel($stud_id='') {

		$stud_id=base64_decode($stud_id);
		$guide_renum_det=$this->Guide_allocation_phd_model->fetch_guide_renum_det($stud_id);

        // Create new PHPExcel object
           $objPHPExcel = new PHPExcel();
			$activeSheet = $objPHPExcel->setActiveSheetIndex(0);

			// Set column headers
			$headers = [
				'SNo', 'Type', 'Institute', 'Designation', 'Member Name', 'Mobile NO.',
				'Renumeration', 'Travelling Allowance', 'Total Amount', 'Account Holder Name',
				'Account No', 'IFSC Code', 'Branch', 'Rac Date'
			];

			$col = 0;
			foreach ($headers as $header) {
				$cell = $activeSheet->setCellValueByColumnAndRow($col, 1, $header, true);
				$col++;
			}

			// Apply bold styling to the header
			$headerStyleArray = [
				'font' => [
					'bold' => true,
				],
				'borders' => [
					'allborders' => [
						'style' => PHPExcel_Style_Border::BORDER_THIN,
					],
				],
				'alignment' => [
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				],
			];
			$activeSheet->getStyle('A1:' . $activeSheet->getHighestColumn() . '1')->applyFromArray($headerStyleArray);

			// Fill data
			$row = 2; // Start from the second row
			$sno = 1;
			foreach ($guide_renum_det as $stud) {
				$type = $stud['type'];
				$type_map = [
					'topic_approval' => 'Rac Topic Approval',
					'pre_thesis' => 'RAC Pre Thesis',
					'final_defence' => 'Final Defence',
					'course_work' => 'Course Work'
				];
				$type = isset($type_map[$type]) ? $type_map[$type] : $type;
				$activeSheet->setCellValueByColumnAndRow(0, $row, $sno++);
				$activeSheet->setCellValueByColumnAndRow(1, $row, $type);
				$activeSheet->setCellValueByColumnAndRow(2, $row, $stud['institute']);
				$activeSheet->setCellValueByColumnAndRow(3, $row, $stud['designation']);
				$activeSheet->setCellValueByColumnAndRow(4, $row, $stud['member_name']);
				$activeSheet->setCellValueByColumnAndRow(5, $row, $stud['mobno']);
				$activeSheet->setCellValueByColumnAndRow(6, $row, $stud['renumeration']);
				$activeSheet->setCellValueByColumnAndRow(7, $row, $stud['travelling_allowance']);
				$activeSheet->setCellValueByColumnAndRow(8, $row, $stud['amount']);
				$activeSheet->setCellValueByColumnAndRow(9, $row, $stud['accountholdername']);
				$activeSheet->setCellValueByColumnAndRow(10, $row, $stud['acc_no']);
				$activeSheet->setCellValueByColumnAndRow(11, $row, $stud['ifsc']);
				$activeSheet->setCellValueByColumnAndRow(12, $row, $stud['branch']);
				$activeSheet->setCellValueByColumnAndRow(13, $row, $stud['rac_date']);
				$row++;
			}

			// Apply border styling to the entire table
			$tableStyleArray = [
				'borders' => [
					'allborders' => [
						'style' => PHPExcel_Style_Border::BORDER_THIN,
					],
				],
			];
			$activeSheet->getStyle('A1:' . $activeSheet->getHighestColumn() . $activeSheet->getHighestRow())
				->applyFromArray($tableStyleArray);

			// Save the Excel file
			$filename = 'Guide_Renumeration_Details.xlsx';
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header("Content-Disposition: attachment;filename=\"$filename\"");
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
    }		
		
		
		
}
?>