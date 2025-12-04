<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Time_table extends CI_Controller 
{

    var $currentModule="";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Ums_admission_model";
    var $model;
    var $view_dir='Admission/';
    
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
     //   echo $_SERVER['REMOTE_ADDR'];
  //var_dump($_SESSION);
// error_reporting(E_ALL);
//ini_set('display_errors', 1);
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
    }
    
    public function index()
    {
        global $model;
        $this->load->view('header',$this->data);    
        $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
		
	
	
	function generatepdf()
	{
$data['emp_list']= $this->Ums_admission_model->getStudentsajax($_POST['dcourse'],$_POST['dyear']);

//var_dump($this->Ums_admission_model->getStudentsajax($_POST['astream'],$_POST['ayear']));getfieldname_byid

//exit(0);
	       $data['dstream']= $this->Ums_admission_model->getfieldname_byid('vw_stream_details','stream_id',$_POST['dcourse'],'stream_name');
	     $data['dyear']= $_POST['dyear'];
	      
	     $pdfFilePath = "output_pdf_name.pdf";
// $html = $this->load->view('agents/invoices/invoice_pdf',$data,true);

$html = $this->load->view($this->view_dir.'student_listpdf',$data,true);


        //load mPDF library
        $this->load->library('m_pdf');
 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
 $pdfFilePath = "output_pdf_name.pdf";     
	    
	    
	    
	}
	
	
	
	
	
	
	
    public function add()
    {
        $this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
	
	
	public function test()
	{
	    $str = "jugal";
	    echo strtoupper($str);
$prn = $this->Ums_admission_model->generateprn('5');
	    //  echo '<script>alert("PRN Number of '.$nam.' is '.$stud_reg_id.'"); window.location.href = "stud_list";</script>';
 //window.location.href = "auth/login";
// echo $prn;
	    
	}
	
	 public function stud_list($offSet=0)
    {
           $this->load->view('header',$this->data);        
        $limit = 10;// set records per page
		if(isset($_REQUEST['per_page'])){
			$offSet=$_REQUEST['per_page'];
		}
       $total= $this->Ums_admission_model->getAllStudents();
        $this->data['emp_list']= $this->Ums_admission_model->getStudents($offSet,$limit);
		$total_pages = ceil($total/$limit);
		//echo $total_pages; 
		$this->load->library('pagination');
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config['enable_query_strings']=TRUE;
		$config['page_query_string']=TRUE;
		$config['reuse_query_string'] = TRUE;
		$config['base_url'] = base_url().'ums_admission/stud_list?';
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);
	    $this->data['paginglinks'] = $this->pagination->create_links();
		$config['offSet'] = $offSet;		
		$total=ceil($total/$limit);
		/* echo $total;
             echo"<pre>";	     
		 print_r( $this->data['paginglinks']);
		 echo"</pre>"; 
		 die();   */
        $this->load->view($this->view_dir.'student_list',$this->data);
        $this->load->view('footer');
    }
	
	
	
	
		function load_studentlist()
	{
	    
	      $data['emp_list']= $this->Ums_admission_model->getStudentsajax($_POST['astream'],$_POST['ayear']);
	       $data['dcourse']= $_POST['astream'];
	        $data['dyear']= $_POST['ayear'];
	      
	      $html = $this->load->view($this->view_dir.'load_studentdata',$data,true);
	  echo $html;
	}
	
	
	
function search_studentdata()
{
     $data['emp_list']= $this->Ums_admission_model->searchStudentsajax($_POST);
	       $data['dcourse']= $_POST['astream'];
	        $data['dyear']= $_POST['ayear'];
	      
	      $html = $this->load->view($this->view_dir.'load_studentdata',$data,true);
	  echo $html;
}
	
	
	
	
	
	
    
    public function view()
    {
        $this->load->view('header',$this->data);        
        $this->data['campus_details']=$this->campus_model->get_campus_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    
    	public function load_streams()
		{
	 global $model;	    
	    $this->data['campus_details']= $this->Ums_admission_model->get_course_streams($_POST);     	    
		}
		
		
    public function form()
    {
        
        $this->load->view('header',$this->data);     
        $this->data['states'] = $this->Ums_admission_model->fetch_states();
        $campus_id=$this->uri->segment(3);
	//$college_id = $this->session->college_id;
	//$up_stud_id=$_REQUEST['s'];
	//echo $stud_id;
	    $college_id = 1;
        $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
		$this->data['doc_list']= $this->Ums_admission_model->getdocumentlist();
		$this->data['category']= $this->Ums_admission_model->getcategorylist();
		$this->data['religion']= $this->Ums_admission_model->getreligionlist();
	$this->data['course_year']= $this->Ums_admission_model->getCourseYRClg($college_id);
	$this->data['branches']= $this->Ums_admission_model->getbranch($college_id);
	
	$this->data['bank_details']= $this->Ums_admission_model->getbanks();
	
	if(!empty($_REQUEST['s'])){ //code for update
		$up_stud_id=$_REQUEST['s'];//student id for update 
		$check_stud_form_flag=$this->Ums_admission_model->check_flag_status($up_stud_id);// check steps completion status
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
		         $this->data['personal']=$this->Ums_admission_model->getstep1_data1($up_stud_id);
				 $this->data['certificate']=$this->Ums_admission_model->getstudent_certificate_data($up_stud_id);
				 $this->data['education']=$this->Ums_admission_model->getstudent_education_data($up_stud_id);
				 $this->data['qualiexam']=$this->Ums_admission_model->qualifying_exam_details($up_stud_id);
				 $this->data['document']=$this->Ums_admission_model->getstud_document_details($up_stud_id);
				 $this->data['references']=$this->Ums_admission_model->getstud_references_details($up_stud_id);
				 $this->data['fee']=$this->Ums_admission_model->getstud_fee_details($up_stud_id); 
	}
	    $this->load->view($this->view_dir.'ums_admission',$this->data);
        $this->load->view('footer');
    }
	 public function search(){
		   $this->load->view('header',$this->data); 
		     $this->load->view($this->view_dir.'search',$this->data);
		    $this->load->view('footer');
	 }
	function search_student(){
		global $model;
		if($_POST){
			session_start();
			$id=$_POST['search_id'];
			$check_stud=$this->Ums_admission_model->getstep1_data2($id);
		//	$check_stud=$this->Ums_admission_model->ums_student_data($id);
			/* print_r($check_stud);
			die(); */ 
			$check_stud_form_flag=$this->Ums_admission_model->check_flag_status($id);
		if($check_stud[0]['student_id']==$_POST['search_id']) {
		 $data = ['student_id' => $check_stud[0]['student_id'],
				  'resistered'=>True
                 ];
				 $this->session->set_userdata($data);
				
        	if($check_stud_form_flag[0]['step_first_flag']==1){
			$data=['stepfirst_status'=>'success'];
			
           }	
		   $this->session->set_userdata($data);
	if($check_stud_form_flag[0]['step_second_flag']==1){
			$data=['stepsecond_status'=>'success'];
			
		}
		$this->session->set_userdata($data);
	 if($check_stud_form_flag[0]['step_third_flag']==1){
			$data=['stepthird_status'=>'success'];
			
		}
		$this->session->set_userdata($data);
       if($check_stud_form_flag[0]['step_fourth_flag']==1){
			$data=['stepfourth_status'=>'success'];
			
		}
		$this->session->set_userdata($data);
if($check_stud_form_flag[0]['step_fifth_flag']==1){
			$data=['stepfifth_status'=>'success'];
			
		} 
		$this->session->set_userdata($data);
		 /* echo"<pre>";
		 print_r($this->session->all_userdata());
		 echo"</pre>";
	     die(); */
	       $this->session->set_userdata($data);
			  $this->session->set_flashdata('message1','Student Registration Details ..');
	          redirect('admission/profile');
	    }
	 else{
		  $this->session->set_flashdata('message1','Student Details  not available.Please Register student  ..');
	      redirect('admission/search');
	 }
	 
	 }
	}
	
	
	 function ums_admission_submit()
	 {
	     
	     
	     		if(!empty($_FILES['scandoc']['name'])){
			$_FILES['scandoc']['name']=$this->Ums_admission_model->rearrange1($_FILES['scandoc']['name']);
			// $filesCount = count($_FILES['scandoc']['name']);
            //for($i = 0; $i < $filesCount; $i++){
				foreach($_FILES['scandoc']['name'] as $key => $val){
                $_FILES['userFile']['name'] = $student_id.'-'.$_FILES['scandoc']['name'][$key];
                $_FILES['userFile']['type'] = $_FILES['scandoc']['type'][$key];
                $_FILES['userFile']['tmp_name'] = $_FILES['scandoc']['tmp_name'][$key];
                $_FILES['userFile']['error'] = $_FILES['scandoc']['error'][$key];
                $_FILES['userFile']['size'] = $_FILES['scandoc']['size'][$key];
                 $arr1[$key]=$_FILES['userFile']['name'];
                $uploadPath = 'uploads/student_document/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx';
				$config['overwrite']= TRUE;
                $config['max_size']= "2048000"; 
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$key]['file_name'] = $fileData['file_name'];
                    $uploadData[$key]['created'] = date("Y-m-d H:i:s");
                    $uploadData[$key]['modified'] = date("Y-m-d H:i:s");
                }
            }
               }
	     
	     
	     
	     		if(!empty($_FILES['sss_doc']['name'])){
			$_FILES['sss_doc']['name']=$this->Ums_admission_model->rearrange1($_FILES['sss_doc']['name']);
			// $filesCount = count($_FILES['scandoc']['name']);
            //for($i = 0; $i < $filesCount; $i++){
				foreach($_FILES['sss_doc']['name'] as $key => $val){
                $_FILES['userFile']['name'] = $student_id.'-'.$_FILES['sss_doc']['name'][$key];
                $_FILES['userFile']['type'] = $_FILES['sss_doc']['type'][$key];
                $_FILES['userFile']['tmp_name'] = $_FILES['sss_doc']['tmp_name'][$key];
                $_FILES['userFile']['error'] = $_FILES['sss_doc']['error'][$key];
                $_FILES['userFile']['size'] = $_FILES['sss_doc']['size'][$key];
                 $arr2[$key]=$_FILES['userFile']['name'];
                $uploadPath = 'uploads/student_document/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx';
				$config['overwrite']= TRUE;
                $config['max_size']= "2048000"; 
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$key]['file_name'] = $fileData['file_name'];
                    $uploadData[$key]['created'] = date("Y-m-d H:i:s");
                    $uploadData[$key]['modified'] = date("Y-m-d H:i:s");
                }
            }
               }
	     
	     
	     
	     
	     
	     
	     
	     
	     
	     
	     
	     
	     
	     
	     
	      $stud_reg_id=$this->Ums_admission_model->student_registration_ums($_POST,$arr1,$arr2);
	     
	     //exit();
	     $nam = $_POST['slname']."".$_POST['sfname']."".$_POST['smname'];
	     
	      echo '<script>alert("PRN Number of '.$nam.' is '.$stud_reg_id.'");window.location.href = "stud_list";</script>';
	      // redirect('orderManagement/index', 'refresh');
	      
	     redirect('ums_admission/stud_list','refresh');
	     
	     /*	 $this->load->view('header');
		     $stud_reg_id=$this->Ums_admission_model->getStudentID();
		     
		     	 $reg_step1=$this->Ums_admission_model->student_registration_ums($stud_reg_id,$_POST);
			 $step1data=$this->Ums_admission_model->getstep1_data($reg_step1);
			 $stud_id=$step1data[0]['student_id'];
			if(!empty($reg_step1)){ 
				 $data = ['student_id' => $stud_id,
				          'stepfirst_status'=>'success',
				          'resistered'=>True
                         ];	
						 
			 $this->session->set_userdata($data);
			}
			 
			 
			   $reg_step2=$this->Ums_admission_model->registration_step2($_POST);
			if(!empty($reg_step2) && $reg_step2!=0 ){
				$data=['stepsecond_status'=>'success'];
			$this->session->set_userdata($data);
             $msg2='Educational Details Saved successfully..';
			 $this->session->set_flashdata('msg2', $msg2);			
			}
			 
			 
			 
			 	if(!empty($_FILES['scandoc']['name'])){
			$_FILES['scandoc']['name']=$this->Ums_admission_model->rearrange1($_FILES['scandoc']['name']);
			// $filesCount = count($_FILES['scandoc']['name']);
            //for($i = 0; $i < $filesCount; $i++){
				foreach($_FILES['scandoc']['name'] as $key => $val){
                $_FILES['userFile']['name'] = $student_id.'-'.$_FILES['scandoc']['name'][$key];
                $_FILES['userFile']['type'] = $_FILES['scandoc']['type'][$key];
                $_FILES['userFile']['tmp_name'] = $_FILES['scandoc']['tmp_name'][$key];
                $_FILES['userFile']['error'] = $_FILES['scandoc']['error'][$key];
                $_FILES['userFile']['size'] = $_FILES['scandoc']['size'][$key];
                 $arr1[$key]=$_FILES['userFile']['name'];
                $uploadPath = 'uploads/student_document/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx';
				$config['overwrite']= TRUE;
                $config['max_size']= "2048000"; 
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$key]['file_name'] = $fileData['file_name'];
                    $uploadData[$key]['created'] = date("Y-m-d H:i:s");
                    $uploadData[$key]['modified'] = date("Y-m-d H:i:s");
                }
            }
               }
               
               	$reg_step3=$this->Ums_admission_model->registration_step3($_POST,$arr1);
			if(!empty($reg_step3) && $reg_step3!=0 ){
				$data=['stepthird_status'=>'success'];
			$this->session->set_userdata($data);
             $msg3='Documents & Certifictes Details Saved successfully..';
			 $this->session->set_flashdata('msg3', $msg3);			
			}
			
			
				$reg_step4=$this->Ums_admission_model->registration_step4($_POST);
			if(!empty($reg_step4) && $reg_step4!=0 ){
				$data=['stepfourth_status'=>'success'];
			$this->session->set_userdata($data);	
			
			$msg4='References Added Saved successfully..';
			 $this->session->set_flashdata('msg4', $msg4);
			
			 }
			 
			  if(!empty($_FILES['profile_img']['name'])){
				 $filenm=$student_id.'-'.$_FILES['profile_img']['name'];
                $config['upload_path'] = 'uploads/student_profilephotos/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('profile_img')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    $picture = '';
                }
            }
			else{
                $picture = '';
            }
			
			
			
			$reg_step5=$this->Ums_admission_model->registration_step5($_POST,$picture);
			if(!empty($reg_step5) && $reg_step5!=0 ){
				$data=['stepfifth_status'=>'success'];
			$this->session->set_userdata($data);	
			 $msg5='Photo & Account Details Added Saved successfully..';
			 $this->session->set_flashdata('msg5', $msg5);
			 }
			 if($this->session->userdata('stepfirst_status')&&$this->session->userdata('stepsecond_status')&&$this->session->userdata('stepthird_status')&&$checkstatus3&&$this->session->userdata('stepfifth_status'))
			 {	// echo "all steps completed";
				 $this->session->set_flashdata('message1','all steps completed ..');
				// redirect('admission/profile');
					   	 
			 }
	     */
	 }
	
	
	
	
	
	
	
	
	
	
	 function form1step1(){
		global $model;
		if($_POST){
			 $this->load->view('header');
		     $stud_reg_id=$this->Ums_admission_model->getStudentID();
			 //for update process code
			 if(!empty($this->session->userdata('student_id'))&&$this->session->userdata('updatestep1flag')=='active'){
				 $up_stud_id=$this->session->userdata('student_id');
				$first_update= $this->Ums_admission_model->update_stepfirstdata($up_stud_id,$_POST);
				if($first_update==true){
					 $msg1='student personal details updated successfully..';
			 $this->session->set_flashdata('msg1', $msg1);
			 redirect('admission/form?s='.$up_stud_id.'');
				}
				else{
					$this->session->set_flashdata('message1','Some problem occured please try again ..');
	                redirect('admission/profile');
				}
			 }
			 else{ //for registration process code
			 $reg_step1=$this->Ums_admission_model->student_registration($stud_reg_id,$_POST);
			 $step1data=$this->Ums_admission_model->getstep1_data($reg_step1);
			 $stud_id=$step1data[0]['student_id'];
			if(!empty($reg_step1)){ 
				 $data = ['student_id' => $stud_id,
				          'stepfirst_status'=>'success',
				          'resistered'=>True
                         ];	
						 
			 $this->session->set_userdata($data);
			 $msg1='New student registered successfully..';
			 $this->session->set_flashdata('msg1', $msg1);
			}
		redirect('admission/form');
		}
		} 
		$this->load->view('footer');
	}
	public function form2step2(){
		global $model;
		if($_POST){
			/*  echo"<pre>";
		print_r($_POST);
		echo"</pre>"; 
		die(); */
 			 $this->load->view('header');
			 $checkstatus=$this->session->userdata('stepfirst_status');
			 echo $checkstatus;
			if($checkstatus!='success') {
			$this->session->set_flashdata('message','Please Complete the first step ..');
			redirect('admission/form');
        }
		else{
			//for update process code
			
		if(!empty($this->session->userdata('student_id'))&&$this->session->userdata('updatestep2flag')=='active'){
		   $up_stud_id=$this->session->userdata('student_id');
		  $second_update= $this->Ums_admission_model->update_stepseconddata($up_stud_id,$_POST);           
           if($second_update==true){
					 $msg2='student Educational details updated successfully..';
			 $this->session->set_flashdata('msg2', $msg2);
			 redirect('admission/form?s='.$up_stud_id.'');
				}
				else{
					$this->session->set_flashdata('message1','Some problem occured please try again ..');
	                redirect('admission/profile');
				}   
		
		}else{//for registration process code
		  $reg_step2=$this->Ums_admission_model->registration_step2($_POST);
			if(!empty($reg_step2) && $reg_step2!=0 ){
				$data=['stepsecond_status'=>'success'];
			$this->session->set_userdata($data);
             $msg2='Educational Details Saved successfully..';
			 $this->session->set_flashdata('msg2', $msg2);			
			}
			redirect('admission/form');
		  }	 
		}
		     $this->load->view('footer');	
		}
	}
	function form3sub3(){
		global $model;
		if($_POST){
			 /* echo"<pre>";
		print_r($_POST);
		echo"</pre>";
		die();  */
			$this->load->view('header');
			$checkstatus1=$this->session->userdata('stepsecond_status');
			if($checkstatus1!='success') {
			   $this->session->set_flashdata('message','Please Complete the second step ..');
                redirect('admission/form');
        }
		else{
			//scandoc
			$student_id=$this->session->userdata('student_id');
			if(!empty($_FILES['scandoc']['name'])){
			$_FILES['scandoc']['name']=$this->Ums_admission_model->rearrange1($_FILES['scandoc']['name']);
			// $filesCount = count($_FILES['scandoc']['name']);
            //for($i = 0; $i < $filesCount; $i++){
				foreach($_FILES['scandoc']['name'] as $key => $val){
                $_FILES['userFile']['name'] = $student_id.'-'.$_FILES['scandoc']['name'][$key];
                $_FILES['userFile']['type'] = $_FILES['scandoc']['type'][$key];
                $_FILES['userFile']['tmp_name'] = $_FILES['scandoc']['tmp_name'][$key];
                $_FILES['userFile']['error'] = $_FILES['scandoc']['error'][$key];
                $_FILES['userFile']['size'] = $_FILES['scandoc']['size'][$key];
                 $arr1[$key]=$_FILES['userFile']['name'];
                $uploadPath = 'uploads/student_document/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx';
				$config['overwrite']= TRUE;
                $config['max_size']= "2048000"; 
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$key]['file_name'] = $fileData['file_name'];
                    $uploadData[$key]['created'] = date("Y-m-d H:i:s");
                    $uploadData[$key]['modified'] = date("Y-m-d H:i:s");
                }
            }
               }
			//code for updation process
			if(!empty($this->session->userdata('student_id'))&&$this->session->userdata('updatestep3flag')=='active'){
		   $up_stud_id=$this->session->userdata('student_id');
		  $third_update= $this->Ums_admission_model->update_stepthirddata($up_stud_id,$_POST,$arr1);           
           if($third_update==true){
					 $msg3='student Document & Certificate details updated successfully..';
			 $this->session->set_flashdata('msg3', $msg3);
			 redirect('admission/form?s='.$up_stud_id.'');
				}
				else{
					$this->session->set_flashdata('message1','Some problem occured please try again ..');
	                redirect('admission/profile');
				}   
		
		}else{//for registration process code
			$reg_step3=$this->Ums_admission_model->registration_step3($_POST,$arr1);
			if(!empty($reg_step3) && $reg_step3!=0 ){
				$data=['stepthird_status'=>'success'];
			$this->session->set_userdata($data);
             $msg3='Documents & Certifictes Details Saved successfully..';
			 $this->session->set_flashdata('msg3', $msg3);			
			}
			
		//$this->load->view($this->view_dir.'add');
			 redirect('admission/form');
			}
			}
		}
		
	}
	function form4sub4(){
		global $model;
		if($_POST){
			$this->load->view('header');
			$checkstatus2=$this->session->userdata('stepthird_status');
			if($checkstatus2!='success') {
			   $this->session->set_flashdata('message','Please Complete the third step ..');
                redirect('admission/form');
           }
		else{
			 /*  echo"am in form4 daTA...";	*/
		 if(!empty($this->session->userdata('student_id'))&&$this->session->userdata('updatestep3flag')=='active'){
		   $up_stud_id=$this->session->userdata('student_id');
		  $fourth_update= $this->Ums_admission_model->update_stepfourthdata($up_stud_id,$_POST);           
           if($fourth_update==true){
					 $msg4='student Reference details updated successfully..';
			 $this->session->set_flashdata('msg4', $msg4);
			 redirect('admission/form?s='.$up_stud_id.'');
				}
				else{
					$this->session->set_flashdata('message1','Some problem occured please try again ..');
	                redirect('admission/profile');
				}   
		
		}else{
			$reg_step4=$this->Ums_admission_model->registration_step4($_POST);
			if(!empty($reg_step4) && $reg_step4!=0 ){
				$data=['stepfourth_status'=>'success'];
			$this->session->set_userdata($data);	
			
			$msg4='References Added Saved successfully..';
			 $this->session->set_flashdata('msg4', $msg4);
			 redirect('admission/form');
			 }
		   }
		}			
	}
		
	}
	function form5sub5(){
		
		global $model;
		if($_POST){
			 
			$student_id=$this->session->userdata('student_id');
			$this->load->view('header');
			$checkstatus3=$this->session->userdata('stepfourth_status');
			if($checkstatus3!='success') {
			   $this->session->set_flashdata('message','Please Complete the fourth step ..');
                redirect('admission/form');
           }
		else{
			  echo"am in form5 daTA...";	
			 if(!empty($_FILES['profile_img']['name'])){
				 $filenm=$student_id.'-'.$_FILES['profile_img']['name'];
                $config['upload_path'] = 'uploads/student_profilephotos/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('profile_img')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    $picture = '';
                }
            }
			else{
                $picture = '';
            }
			
			if(!empty($this->session->userdata('student_id'))&&$this->session->userdata('updatestep4flag')=='active'){
		   $up_stud_id=$this->session->userdata('student_id');
		  $fifth_update= $this->Ums_admission_model->update_stepfifthdata($up_stud_id,$_POST,$picture);           
           if($fifth_update==true){
					 $msg5='student Fee And Photo details updated successfully..';
			 $this->session->set_flashdata('msg5', $msg5);
			 if($this->session->userdata('stepfirst_status')&&$this->session->userdata('stepsecond_status')&&$this->session->userdata('stepthird_status')&&$checkstatus3&&$this->session->userdata('stepfifth_status'))
			 {	// echo "all steps completed";
				 $this->session->set_flashdata('message1','all steps completed ..');
				 redirect('admission/profile');
					   	 
			 }
			// redirect('admission/form?s='.$up_stud_id.'');
				}
				else{
					$this->session->set_flashdata('message1','Some problem occured please try again ..');
	                redirect('admission/profile');
				}   
		
		}else{
             //			
			$reg_step5=$this->Ums_admission_model->registration_step5($_POST,$picture);
			if(!empty($reg_step5) && $reg_step5!=0 ){
				$data=['stepfifth_status'=>'success'];
			$this->session->set_userdata($data);	
			 $msg5='Photo & Account Details Added Saved successfully..';
			 $this->session->set_flashdata('msg5', $msg5);
			 }
			 if($this->session->userdata('stepfirst_status')&&$this->session->userdata('stepsecond_status')&&$this->session->userdata('stepthird_status')&&$checkstatus3&&$this->session->userdata('stepfifth_status'))
			 {	// echo "all steps completed";
				 $this->session->set_flashdata('message1','all steps completed ..');
				 redirect('admission/profile');
					   	 
			 }
			 else{
				 $this->session->set_flashdata('message','Please check all steps for form completing ..');
				 redirect('admission/form');
				 }
			}
			
		}		
	}
	}
      function profile(){
		 $student_id=$this->session->userdata('student_id');
		// echo $student_id."&&&&";
		  $this->load->view('header',$this->data);    
		         $student_details['personal']=$this->Ums_admission_model->getstep1_data1($student_id);
				 $student_details['certificate']=$this->Ums_admission_model->getstudent_certificate_data($student_id);
				 $student_details['education']=$this->Ums_admission_model->getstudent_education_data($student_id);
				 $student_details['qualiexam']=$this->Ums_admission_model->qualifying_exam_details($student_id);
				 $student_details['document']=$this->Ums_admission_model->getstud_document_details($student_id);
				 $student_details['references']=$this->Ums_admission_model->getstud_references_details($student_id);
				 $student_details['fee']=$this->Ums_admission_model->getstud_fee_details($student_id); 
				 $student_details['doc_list']= $this->Ums_admission_model->getdocumentlist();
				 /*  echo"<pre>";
				 print_r($student_details);
				 echo"</pre>";
				 die();  */
				 $this->load->view($this->view_dir.'view_full_profile',$student_details);
				  $this->load->view('footer');
	 }
	function cancel1(){
		 echo"<script>alert('Data removed..')</script>";
		unset($_SESSION['stepfirst_status']);
		//session_destroy();
		//$this->load->view('header',$this->data);        
        redirect('admission/form');
			}
	function cancel2(){
		 echo"<script>alert('Data removed..')</script>";
		unset($_SESSION['stepsecond_status']);
		 redirect('admission/form');
		}
	function cancel3(){
		 echo"<script>alert('Data removed..')</script>";
		unset($_SESSION['stepthird_status']);
		 redirect('admission/form');
		}
	function cancel4(){
		 echo"<script>alert('Data removed..')</script>";
		unset($_SESSION['stepfourth_status']);
		 redirect('admission/form');
		}
		function cancel_all_sessions(){
		 echo"<script>alert('Data removed..')</script>";
		unset($_SESSION['stepfirst_status']);
		unset($_SESSION['stepsecond_status']);
		unset($_SESSION['stepthird_status']);
		unset($_SESSION['stepfourth_status']);
		unset($_SESSION['student_id']);
		unset($_SESSION['updatestep4flag']);
		unset($_SESSION['updatestep3flag']);
		unset($_SESSION['updatestep2flag']);
		unset($_SESSION['updatestep1flag']);
		unset($_SESSION['updatestep5flag']);
		//session_destroy();
		 redirect('admission/search');
		}
		
	// fetch District by state
	public function getStatewiseDistrict(){

		$state=$_REQUEST['state_id'];
		//echo $state;
		$dist=$this->Ums_admission_model->getStatewiseDistrict($state);
		//print_r($dist);exit;
		if(!empty($dist)){
			echo"<option value=''>Select District</option>";
			foreach($dist as $key=>$val){
				echo"<option value='".$dist[$key]['district_id']."'>".$dist[$key]['district_name']."</option>";
			}		
		}
	}
	
	// fetch city by state and district
	public function getStateDwiseCity(){
		$state_id=$_REQUEST['state_id'];
		$dist_id=$_REQUEST['district_id'];
		//echo $state;
		$city=$this->Ums_admission_model->getStateDwiseCity($state_id, $dist_id);
		//print_r($city);exit;
		if(!empty($city)){
			echo"<option value=''>Select City</option>";
			foreach($city as $key=>$val){
				echo"<option value='".$city[$key]['taluka_id']."'>".$city[$key]['taluka_name']."</option>";
			}		
		}
	}
	
	// fetch qualification streams 
	public function fetch_qualification_streams(){
		//echo $state;
		$qul=$this->Ums_admission_model->fetch_qualification_streams();
		//print_r($city);exit;
		if(!empty($qul)){
			echo"<option value=''>Select </option>";
			foreach($qul as $key=>$val){
				echo"<option value='".$qul[$key]['qualification']."'>".$qul[$key]['qualification']."</option>";
			}		
		}
	}
	
	// fetch qualification streams 
	public function fetch_sujee_details(){
		//echo $state;
		$reg_no=$_REQUEST['reg_no'];
		$stud =$this->Ums_admission_model->fetch_sujee_details($reg_no);
		//print_r($city);exit;
		if(!empty($stud)){
		    //echo $stud[0]['exam_name'];
		    ?>
		             <table class="table table-bordered edu-table" id="">
                            <thead>
                          <tr>
                            <th>Exam Name</th>
                             <th>Exam Type</th>
                            <th width="12%">Month</th>
                            <th width="12%">Year</th>
                            <th>Enrolment Number</th>
                            <th>Marks Obtained</th>
                            <th>Total Marks</th>
                            <th>Percentage</th>
                            
                          </tr>
                          </thead>
                          <tbody>
                          <tr>
                              <td>
                                  <select name="examtype" class="form-control" style="width: 95px;"><option value="">Select</option>
                                <option value="SU-JEE" selected="">SU-JEE</option>
                                </select>
                                  </td>
                              <td><input type="text" name="suexam-name" class="form-control" value="<?=$stud[0]['exam_name']?>" /></td>
                              <td>
                            <select name="supass_month" class="form-control">
                                <option value="April">April</option>
                            </select>
                            </td>
                          <td><select name="supass_year" class="form-control">
                                        
                                <?php
                                    echo '<option value="2017">2017</option>';
                                
                                ?>
                            </select>
                            </td>
                            
                          <td><input type="text" name="suenrolment" class="form-control" placeholder="Enrolment Number" value="<?=$stud[0]['reg_no']?>" style="width: 100px;"/></td>
                          <td><input type="text" name="sumarks" class="form-control" placeholder="Marks Obtained" value="<?=$stud[0]['scored_marks']?>" style="width: 70px;" /></td>
                          <td><input type="text" name="sutotal" class="form-control" placeholder="Total Marks" value="200" style="width: 70px;"/></td>
                          <td><input type="text" name="super" id="super" class="form-control" placeholder="Percentage" value="<?=$stud[0]['percentile']?>" style="width: 90px;" /></td>
                          
                         </tr>
                        </table>
		<?php }
	}
	
	
	
	
	
	
	
	public function update_personalDetails()
    {
       $this->Ums_admission_model->update_stepfirstdata($_POST); 
         $msg5='student application updated  successfully..';
			 $this->session->set_flashdata('msg5', $msg5);
			redirect('ums_admission/stud_list');
    }
	
	
		public function update_bankDetails()
    {
       $this->Ums_admission_model->registration_step5($_POST); 
         $msg5='student application updated  successfully..';
			 $this->session->set_flashdata('msg5', $msg5);
			redirect('ums_admission/stud_list');
    }
	
	
	
		public function update_refDetails()
    {
       $this->Ums_admission_model->registration_step4($_POST); 
         $msg5='student application updated  successfully..';
			 $this->session->set_flashdata('msg5', $msg5);
			redirect('ums_admission/stud_list');
    }
	
	
	
		public function update_docDetails()
    {
        
        
        /*	if(!empty($_FILES['scandoc']['name'])){
			$_FILES['scandoc']['name']=$this->Ums_admission_model->rearrange1($_FILES['scandoc']['name']);
			// $filesCount = count($_FILES['scandoc']['name']);
            //for($i = 0; $i < $filesCount; $i++){
				foreach($_FILES['scandoc']['name'] as $key => $val){
                $_FILES['userFile']['name'] = $student_id.'-'.$_FILES['scandoc']['name'][$key];
                $_FILES['userFile']['type'] = $_FILES['scandoc']['type'][$key];
                $_FILES['userFile']['tmp_name'] = $_FILES['scandoc']['tmp_name'][$key];
                $_FILES['userFile']['error'] = $_FILES['scandoc']['error'][$key];
                $_FILES['userFile']['size'] = $_FILES['scandoc']['size'][$key];
                 $arr1[$key]=$_FILES['userFile']['name'];
                $uploadPath = 'uploads/student_document/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx';
				$config['overwrite']= TRUE;
                $config['max_size']= "2048000"; 
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$key]['file_name'] = $fileData['file_name'];
                    $uploadData[$key]['created'] = date("Y-m-d H:i:s");
                    $uploadData[$key]['modified'] = date("Y-m-d H:i:s");
                }
            }
               }
        
        */
        
        
        
        
        
        
        
       $this->Ums_admission_model->update_stepthirddata($_POST); 
         $msg5='student application updated  successfully..';
			 $this->session->set_flashdata('msg5', $msg5);
			redirect('ums_admission/stud_list');
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// edit student personal details
	public function edit_personalDetails($stud_id)
    {
        $this->session->set_userdata('studId', $stud_id);
        $this->load->view('header',$this->data);  
        $this->data['states'] = $this->Ums_admission_model->fetch_states();
        $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
		$this->data['doc_list']= $this->Ums_admission_model->getdocumentlist();
		$this->data['category']= $this->Ums_admission_model->getcategorylist();
		$this->data['religion']= $this->Ums_admission_model->getreligionlist();
	    $this->data['course_year']= $this->Ums_admission_model->getCourseYRClg($college_id);
	    $this->data['branches']= $this->Ums_admission_model->getbranch($college_id);
	    $stdata = $this->Ums_admission_model->fetch_personal_details($stud_id);
	   
        $this->data['emp_list']= $this->Ums_admission_model->fetch_personal_details($stud_id);
         $this->data['local_address']= $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');
          $this->data['perm_address']= $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','PERMNT');
           $this->data['parent_address']= $this->Ums_admission_model->fetch_address_details($stud_id,'PARENT','PERMNT');
           $this->data['parent_details']= $this->Ums_admission_model->fetch_parent_details($stud_id);
            $this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id); 
            $loadd = $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');
	    $peradd = $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','PERMNT');
	    $parentadd = $this->Ums_admission_model->fetch_address_details($stud_id,'PARENT','PERMNT');
           
    
            $this->data['localcity']= $this->Ums_admission_model->fetch_distcity_details('taluka_master','district_id',$loadd[0]['district_id']);
             $this->data['localdistrict']= $this->Ums_admission_model->fetch_distcity_details('district_name','state_id',$loadd[0]['state_id']);
            $this->data['permcity']= $this->Ums_admission_model->fetch_distcity_details('taluka_master','district_id',$peradd[0]['district_id']);
            $this->data['permdistrict']= $this->Ums_admission_model->fetch_distcity_details('district_name','state_id',$peradd[0]['state_id']);
            $this->data['parentcity']= $this->Ums_admission_model->fetch_distcity_details('taluka_master','district_id',$parentadd[0]['district_id']);
             $this->data['parentdistrict']= $this->Ums_admission_model->fetch_distcity_details('district_name','state_id',$parentadd[0]['state_id']);
        
            $this->data['coursedet']= $this->Ums_admission_model->fetch_stcouse_details1($stdata[0]['admission_stream']);
            $cde = $this->Ums_admission_model->fetch_stcouse_details1($stdata[0]['admission_stream']);
            
               $this->data['stream']= $this->Ums_admission_model->fetch_stcouse_details($cde[0]['course_id']);
      //  $this->data['district'] =  $this->Ums_admission_model->fetch_stcouse_details->getStatewiseDistrict('18');
       //  $this->data['city'] =  $this->Ums_admission_model->fetch_stcouse_details->getStateDwiseCity('18','282');
        //$this->data['stud_addr']= $this->Ums_admission_model->fetch_address_details($stud_id);
        $this->load->view($this->view_dir.'personal_details',$this->data);
        $this->load->view('footer');
    }
	// edit student edu details
	public function edit_eduDetails()
    {
        $stud_id = $this->session->userdata('studId');
        $this->load->view('header',$this->data);     
		
		$this->data['qual']= $this->Ums_admission_model->fetch_stud_qualifications($stud_id);
		$this->data['ent_exams']= $this->Ums_admission_model->fetch_stud_entranceexams($stud_id);
		$this->data['subjects']= $this->Ums_admission_model->fetch_qua_subjects_details($stud_id);
        $this->load->view($this->view_dir.'educational_details',$this->data);
        $this->load->view('footer');
    }
	// edit student Docs &cert details
	public function edit_docsndcertDetails()
    {
        $stud_id = $this->session->userdata('studId');
        $this->load->view('header',$this->data);   
        
              $this->data['get_icert_details']= $this->Ums_admission_model->get_cert_details($stud_id,'Income');
         $this->data['get_ccert_details']= $this->Ums_admission_model->get_cert_details($stud_id,'Cast-category');
          $this->data['get_rcert_details']= $this->Ums_admission_model->get_cert_details($stud_id,'Residence-State Subject');
     //   $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
	//	$this->data['doc_list']= $this->Ums_admission_model->getdocumentlist();
			$this->data['doc_list']= $this->Ums_admission_model->userdoc_list($stud_id);
		$this->data['category']= $this->Ums_admission_model->getcategorylist();
		$this->data['religion']= $this->Ums_admission_model->getreligionlist();
	    $this->data['course_year']= $this->Ums_admission_model->getCourseYRClg($college_id);
	    $this->data['branches']= $this->Ums_admission_model->getbranch($college_id);
	    
        $this->data['emp_list']= $this->Ums_admission_model->fetch_personal_details($stud_id);
        $this->load->view($this->view_dir.'certificates_and_docs',$this->data);
        $this->load->view('footer');
    }
	// edit student reference details
	public function edit_refDetails()
    {
        $stud_id = $this->session->userdata('studId');
        $this->load->view('header',$this->data);   
        
        $this->data['is_from_reference']= $this->Ums_admission_model->get_referencedetails('is_from_reference',$stud_id);
	   $this->data['is_uni_employed']= $this->Ums_admission_model->get_referencedetails('is_uni_employed',$stud_id);
	    $this->data['is_uni_alumni']= $this->Ums_admission_model->get_referencedetails('is_uni_alumni',$stud_id);
	    $this->data['is_uni_student']= $this->Ums_admission_model->get_referencedetails('is_uni_student',$stud_id);
	    $this->data['is_reference']= $this->Ums_admission_model->get_referencedetails('is_reference',$stud_id);
	    
        $this->data['emp_list']= $this->Ums_admission_model->fetch_personal_details($stud_id);
        $this->load->view($this->view_dir.'references',$this->data);
        $this->load->view('footer');
    }  
	// edit student payment details
	public function edit_paymentDetails()
    {
        $stud_id = $this->session->userdata('studId');
        $this->load->view('header',$this->data);  
       // echo $stud_id;
       // exit(0);
        
        $this->data['get_feedetails']= $this->Ums_admission_model->get_feedetails($stud_id);
		$this->data['get_bankdetails']= $this->Ums_admission_model->get_bankdetails($stud_id);
		 $this->data['emp_list']= $this->Ums_admission_model->fetch_personal_details($stud_id);
		 	$this->data['bank_details']= $this->Ums_admission_model->getbanks();
		 	 $this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id); 
		//$this->data['category']= $this->Ums_admission_model->getcategorylist();
	//	$this->data['religion']= $this->Ums_admission_model->getreligionlist();
	   // $this->data['course_year']= $this->Ums_admission_model->getCourseYRClg($college_id);
	 //   $this->data['branches']= $this->Ums_admission_model->getbranch($college_id);
	    
        //$this->data['emp_list']= $this->Ums_admission_model->fetch_personal_details($stud_id);
        $this->load->view($this->view_dir.'payments',$this->data);
        $this->load->view('footer');
    }  
    
    // edit student payment details
	public function view_formDetails($stud_id)
    {
        $this->session->set_userdata('studId', $stud_id);
        //$this->load->view('header',$this->data);     
  
        $this->data['emp']= $this->Ums_admission_model->fetch_personal_details($stud_id);
		$this->data['laddr']= $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');
        $this->data['paddr']= $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','PERMNT');
        $this->data['qual']= $this->Ums_admission_model->fetch_qualification_details($stud_id);		
		$this->data['admdetails']= $this->Ums_admission_model->admission_details($stud_id);
		$this->data['entrance']= $this->Ums_admission_model->student_entrance_exam($stud_id);
		$this->data['ref']= $this->Ums_admission_model->student_references($stud_id, 'REF');
		$this->data['uniemp']= $this->Ums_admission_model->student_references($stud_id, 'UNIEMP');
		$this->data['unialu']= $this->Ums_admission_model->student_references($stud_id, 'UNIALU');
		$this->data['unistud']= $this->Ums_admission_model->student_references($stud_id, 'UNISTUD');
		$this->data['fromref']= $this->Ums_admission_model->student_references($stud_id, 'FROMREF');
		$this->data['docs']= $this->Ums_admission_model->fetch_document_details($stud_id);
		
        $this->load->view($this->view_dir.'form_view',$this->data);
        //$this->load->view('footer');
    }
	// fetch fees
	public function fetch_academic_fees_for_stream(){
		$strm_id=$_REQUEST['strm_id'];
		$fess =$this->Ums_admission_model->fetch_academic_fees_for_stream($strm_id);
		echo json_encode($fess);
	}    
	public function updateEducation()
    {   $stud_id = $this->session->userdata('studId');   
    
		if(!empty($_FILES['sss_doc']['name'])){
			$_FILES['sss_doc']['name']=$this->Ums_admission_model->rearrange1($_FILES['sss_doc']['name']);
			// $filesCount = count($_FILES['scandoc']['name']);
            //for($i = 0; $i < $filesCount; $i++){
				foreach($_FILES['sss_doc']['name'] as $key => $val){
                $_FILES['userFile']['name'] = $student_id.'-'.$_FILES['sss_doc']['name'][$key];
                $_FILES['userFile']['type'] = $_FILES['sss_doc']['type'][$key];
                $_FILES['userFile']['tmp_name'] = $_FILES['sss_doc']['tmp_name'][$key];
                $_FILES['userFile']['error'] = $_FILES['sss_doc']['error'][$key];
                $_FILES['userFile']['size'] = $_FILES['sss_doc']['size'][$key];
                 $arr2[$key]=$_FILES['userFile']['name'];
                $uploadPath = 'uploads/student_document/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx';
				$config['overwrite']= TRUE;
                $config['max_size']= "2048000"; 
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$key]['file_name'] = $fileData['file_name'];
                    $uploadData[$key]['created'] = date("Y-m-d H:i:s");
                    $uploadData[$key]['modified'] = date("Y-m-d H:i:s");
                }
            }
           }
           
           $this->Ums_admission_model->update_stepseconddata($stud_id, $_POST, $arr2); 
		$msg5='student application updated  successfully..';
		$this->session->set_flashdata('msg5', $msg5);
		redirect('ums_admission/edit_eduDetails');
    }
    
    // check mobile exist
	public function chek_mob_exist(){

		$mobile_no=$_REQUEST['mobile_no'];
		//echo $state;
		$mob =$this->Ums_admission_model->chek_mob_exist($mobile_no);
		//print_r($dist);exit;
		$cnt_mob = count($mob);
		if($cnt_mob > 0){
			echo "Duplicate";
		}else{
			echo "regular";
		}
	}

	public function view_studentFormDetails($stud_id)
    {
        $this->session->set_userdata('studId', $stud_id);
        $this->load->view('header',$this->data);     
  
        $this->data['emp']= $this->Ums_admission_model->fetch_personal_details($stud_id);
		$this->data['laddr']= $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');
        $this->data['paddr']= $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','PERMNT');
		$this->data['gaddr']= $this->Ums_admission_model->fetch_address_details($stud_id,'PARENT','PERMNT');
        $this->data['qual']= $this->Ums_admission_model->fetch_qualification_details($stud_id);		
		$this->data['admdetails']= $this->Ums_admission_model->admission_details($stud_id);
		$this->data['entrance']= $this->Ums_admission_model->student_entrance_exam($stud_id);
		$this->data['ref']= $this->Ums_admission_model->student_references($stud_id, 'REF');
		$this->data['uniemp']= $this->Ums_admission_model->student_references($stud_id, 'UNIEMP');
		$this->data['unialu']= $this->Ums_admission_model->student_references($stud_id, 'UNIALU');
		$this->data['unistud']= $this->Ums_admission_model->student_references($stud_id, 'UNISTUD');
		$this->data['fromref']= $this->Ums_admission_model->student_references($stud_id, 'FROMREF');
		$this->data['docs']= $this->Ums_admission_model->fetch_document_details($stud_id);
		$this->data['parent_details']= $this->Ums_admission_model->fetch_parent_details($stud_id);
		
		$this->data['get_feedetails']= $this->Ums_admission_model->get_feedetails($stud_id);
		$this->data['get_bankdetails']= $this->Ums_admission_model->get_bankdetails($stud_id);
		$this->data['bank_details']= $this->Ums_admission_model->getbanks();
		$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id); 
		
        $this->load->view($this->view_dir.'view_student_form_details',$this->data);
		$this->load->view('footer');
        //$this->load->view('footer');
    } 
	// view payment details of student
	public function viewPayments($stud_id)
    {
        $this->session->set_userdata('studId', $stud_id);
        $this->load->view('header',$this->data);       
        $this->data['emp']= $this->Ums_admission_model->fetch_personal_details($stud_id);
		$this->data['get_feedetails']= $this->Ums_admission_model->get_feedetails($stud_id);
		$this->data['get_bankdetails']= $this->Ums_admission_model->get_bankdetails($stud_id);
		$this->data['bank_details']= $this->Ums_admission_model->getbanks();
		$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id); 
		$this->data['installment']= $this->Ums_admission_model->fetch_installment_details($stud_id);
		
		$this->data['noofinst']= $this->Ums_admission_model->fetch_no_of_installment($stud_id);
		$this->data['minbalance']= $this->Ums_admission_model->fetch_last_balance($stud_id);
		$this->data['totfeepaid']= $this->Ums_admission_model->fetch_total_fee_paid($stud_id);
        $this->load->view($this->view_dir.'view_payment_details',$this->data);
		$this->load->view('footer');
        //$this->load->view('footer');
    } 
    
    // insert Payment installment
	public function pay_Installment($stud_id)
    {
		//print_r($_FILES);exit;
        $stud_id= $_POST['stud_id'];
		$no_of_installment =1+$_POST['no_of_installment'];
		if(!empty($_FILES['payfile']['name'])){
			$filenm=$stud_id.'-'.$no_of_installment.'-'.$_FILES['payfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('payfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
        $this->data['emp']= $this->Ums_admission_model->pay_Installment($_POST,$payfile );
        redirect('ums_admission/viewPayments/'.$stud_id);
    }	
	
}
?>