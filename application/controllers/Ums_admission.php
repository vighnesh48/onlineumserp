<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Ums_admission extends CI_Controller 
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
 // var_dump($_SESSION);
// error_reporting(E_ALL);
//ini_set('display_errors', 1);
        $this->load->library('form_validation');
        
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions ?? []))
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
    
    
    
function student_reregistration()
{
	if($this->session->userdata("role_id")==2 ||  $this->session->userdata("role_id")==59 ||  $this->session->userdata("role_id")==6){
		}else{
			redirect('home');
		}
     $this->load->view('header',$this->data);    
     //  $this->data['student_list']= $this->Facility_model->get_hstudent_list();                        
        $this->load->view($this->view_dir.'reregistration',$this->data);
        $this->load->view('footer');
}


function student_de_reregistration()
{
     $this->load->view('header',$this->data);    
     //  $this->data['student_list']= $this->Facility_model->get_hstudent_list();                        
        $this->load->view($this->view_dir.'de_reregistration',$this->data);
        $this->load->view('footer');
}





function student_sempromotion()
{
	if($this->session->userdata("role_id")==2 ||  $this->session->userdata("role_id")==59 ||  $this->session->userdata("role_id")==20 ||  $this->session->userdata("role_id")==44){
		}else{
			redirect('home');
		}
     $this->load->view('header',$this->data);    
     //  $this->data['student_list']= $this->Facility_model->get_hstudent_list();                        
        $this->load->view($this->view_dir.'sempromotion',$this->data);
        $this->load->view('footer');
}
public function promote_semester($stud_id,$sem)
{

   $this->Ums_admission_model->promote_semester($stud_id,$sem); 
	 $msg5='student application updated  successfully..';
		 $this->session->set_flashdata('msg5', $msg5);
		  //  echo '<script>alert("PRN Number of '.$nam.' is '.$stud_reg_id.'");window.location.href = "stud_list";<script>';
		 $path= "http://erp.sandipuniversity.com/ums_admission/student_sempromotion/";
		 echo '<script>alert("Student Semester Promotion done successfully..");window.location.href = "'.$path.'";</script>';
}
function cancelled_admission()
{
     $this->load->view('header',$this->data);    
     //  $this->data['student_list']= $this->Facility_model->get_hstudent_list();                        
        $this->load->view($this->view_dir.'cancelled_admission',$this->data);
        $this->load->view('footer');
}

function cancelled_admission_list()
{ 
     $this->load->view('header',$this->data);    
     //  $this->data['student_list']= $this->Facility_model->get_hstudent_list();                        
        $this->load->view($this->view_dir.'cancelled_admission_list',$this->data);
        $this->load->view('footer');
}

 function cancelled_list_admissions_ajax()
    {
		       
   		
		$role_id =$this->session->userdata('role_id');
		$date='';
		$type_param='';
		$Document_status='';
		$admission_status='';
		$list = $this->Ums_admission_model->get_datatables_cancelled($date,$type_param,'N',$Document_status,$admission_status);
		//print_r($list);exit();
		$data = array();$statusn='';$statusy='';
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			$row[] = $no;
			
			
			
			//$row[] = $customers->form_no;ums_admission/view_studentFormDetails/3168
			/*if($role_id==7){
			$row[] = '<a href="https://erp.sandipuniversity.com/ums_admission/view_studentFormDetails/'.$customers->stud_id.'" target="_blank">'.$customers->enrollment_no.'<a>';
				}else{
			$row[] = '<a href="https://erp.sandipuniversity.com/ums_admission/edit_personalDetails/'.$customers->stud_id.'/pro" target="_blank">'.$customers->enrollment_no.'<a>';
			}*/
			
			$row[] = $customers->enrollment_no;
			$row[] = $customers->first_name;
		/*	$row[] = $customers->email;*/
			$row[] = $customers->mobile;
		/*	$row[] = $customers->school_short_name;*/
			$row[] = $customers->stream_name;
			$row[] = $customers->remark;
			/*$row[] = $customers->admission_year;
			$row[] = $customers->nationality;*/
			

			//$row[] = $customers->confirm_date;
			//$row[] = '';
			$row[] = '<select name="confirm_admi" id="confirm_admi" class="confirm_admi" lang="'.$customers->stud_id.'" onchange="admissiom_chnage(this)">
				
				<option value="N" selected="selected">Cancelled</option>
				<option value="Y">Admit</option>
				</select><input type="hidden" name="student_id" id="student_id" value="'.$customers->stud_id.'"/>';
			
			

			$data[] = $row;
		}
	//	$count_all=$this->Provisional_adm_model->count_all();
//echo ($count_all);
//exit();




		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Ums_admission_model->count_all_cancelled('N'),
						"recordsFiltered" => $this->Ums_admission_model->count_filtered_cancelled($date,$type_param,'N',$Document_status,$admission_status),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
		
		
		
		
		
        
    }






public function admissiom_chnage(){
	$values=$this->input->post('values');
	$id=$this->input->post('id');

	echo $this->Ums_admission_model->admissiom_chnage($id);
	//Redirect('ums_admission/cancelled_admission');
}











function student_upload_photo()
{

		$this->load->view('header',$this->data);    
		//$this->data['student_list']= $this->Facility_model->get_hstudent_list();                        
        $this->load->view($this->view_dir.'upload_student_photo.php',$this->data);
        $this->load->view('footer');
}

   	public function stud_document_reports($offSet=0)
    {
        
         $this->load->view('header',$this->data);        
        $limit = 10;// set records per page
		if(isset($_REQUEST['per_page'])){
			$offSet=$_REQUEST['per_page'];
		}
		$data['ex_ses']= $this->Ums_admission_model->exam_sessions();
        $total= $this->Ums_admission_model->getAllStudents();

        //$this->data['emp_list']= $this->Ums_admission_model->getStudents($offSet,$limit);
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
		 $college_id = 1;
		 $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
        $this->load->view($this->view_dir.'student_document_reports',$this->data);
        $this->load->view('footer');
    }

	public function load_studentlist_with_document() 
	{ 	
		
	    //error_reporting(E_ALL);
	   //$data['ex_ses']= $this->Ums_admission_model->exam_sessions();
	      $data['emp_list']= $this->Ums_admission_model->getStudentsajax_document($_POST['astream'],$_POST['ayear'],$_POST['acdyear'],$_POST['acourse']);
	     /* print_r($data['emp_list']);
	      die;*/
	   
	      
	       $data['dcourse']= $_POST['astream'];
	        $data['dyear']= $_POST['ayear'];
	       $data['hide']= $_POST['hide'];
	       
	       
	 
	   $html = $this->load->view($this->view_dir.'student_docment_view',$data,true);
	   echo $html;
	}

	public function update_student_picsDetails()
    {
    	 //error_reporting(E_ALL);
		//ini_set('display_errors', 1);

		$image_info = getimagesize($_FILES["profile_img"]["tmp_name"]);
		$image_width = $image_info[0];
		//echo "<br/>";
		  $image_height = $image_info[1];

	 	if (($image_width <= 300 && $image_width >= 350) || ($image_height <=300 && $image_height >=500)) {
         	$error = array('error' =>'image size must be 300x300 pixels and 350x500 maximum.'); 
	         $this->load->view('header',$this->data);  
	         $this->load->view($this->view_dir.'upload_student_photo.php',$error);
	         $this->load->view('footer');
    	} 
    	else if(($_FILES["profile_img"]["size"]<=10240) || ($_FILES["profile_img"]["size"]>=307200) )
    	{

    		$error = array('error' =>'image size  should be 10KB to 300KB.'); 
	         $this->load->view('header',$this->data);  
	         $this->load->view($this->view_dir.'upload_student_photo.php',$error);
	         $this->load->view('footer');
    	}
    	else
    	{
    		$enrollment_no = $this->session->userdata('name');
		    $std = $this->Ums_admission_model->fetch_personal_details_enrollment_no($enrollment_no);
		    $filenm=$std[0]['enrollment_no'].'.jpg'; //$std
		    $config['upload_path'] = 'uploads/student_photo/';
            $config['allowed_types'] = 'jpg';
            $config['overwrite']= TRUE;
           	
            /*$config['max_width'] = '1000';
			$config['max_height'] = '1000';
			$config['min_width'] = '350';
			$config['min_height'] = '350';*/
			
            $config['file_name'] = $filenm;
            $this->load->library('upload', $config);
            // AWS file upload
            $bucket_name = "erp-asset";
            $src_file = $_FILES["profile_img"]["tmp_name"];
            $file_path = "uploads/student_photo/".$filenm;
		    $result = $this->awssdk->uploadFile($bucket_name, $file_path, $src_file);
		    /* // old code
		    if (!$this->upload->do_upload('profile_img')) {
				 $error = array('error' => $this->upload->display_errors()); 
				 $this->load->view('header',$this->data);  
				 $this->load->view($this->view_dir.'upload_student_photo.php',$error);
				 $this->load->view('footer'); 
			}else{ 
				
				//update data in student master
				$DB1 = $this->load->database('umsdb', TRUE);
				$prof['profile_photo_status']='Y';
				$DB1->where('enrollment_no', $std[0]['enrollment_no']);
				$DB1->update('student_master',$prof);
				
				$this->load->view('header',$this->data);
				$success=array('success' =>'Profile Photo Successfully uploaded.') ; 
				$this->load->view($this->view_dir.'upload_student_photo.php',$success);
				$this->load->view('footer'); 
			} 
			*/

    	}
    	 	
    	  
       	/*$this->Ums_admission_model->upload_student_photo($_POST); 
         $msg5='student application updated  successfully..';
		 $this->session->set_flashdata('msg5', $msg5);
		redirect('ums_admission/student_upload_photo');*/
    }




//jugal 2018 adm
function student_prov_confirmation()
{
     $this->load->view('header',$this->data);    
     //  $this->data['student_list']= $this->Facility_model->get_hstudent_list();                        
        $this->load->view($this->view_dir.'prov_confirmation',$this->data);
        $this->load->view('footer');
}


 public function generate_receipt_no()
 {
     $this->Ums_admission_model->generate_receipt_no();
 }
 


function verifypro_prn()
{
        
//  error_reporting(E_ALL);
//ini_set('display_errors', 1);
   $regi =  $this->Ums_admission_model->regenerate_bonafied($_POST['prn']);
    if($regi['enrollment_no']!='')
    {
       echo "R";   
    }
    else
    {
   $bdat =  $this->Ums_admission_model->verifypro_prn();
   
   
   if($bdat['is_cancelled']=='Y')
   {
     echo "C";    
   }
   else
   {
  
   if($bdat['student_name']!='')
   {
       
       //  $feedet =  $this->Ums_admission_model->fetch_academic_fees_for_rereg($stdata[0]['admission_stream'],($bdat[]),$stdata[0]['admission_session']);
  
        	
     if($bdat['is_verified']=="Y")  
       {
           
            $feedet =	$this->Ums_admission_model->get_feedetails_check_provisional($_POST['prn'],'');
         /*   $uId=$this->session->userdata('uid');

			if($uId=='2')
			{
				print_r($feedet);
				die;
			} */ 
            if($feedet[0]['student_id']=='')
            {
          	echo "FD";      
            }
            else
            {
		echo  json_encode($bdat);
		}
	}
	else
	{
		echo "NV";
	}
   }
   else
   {
       echo "N";
   }
   
   }
   
    }
}



    public function confirm_prov_adm()
    {
        
// error_reporting(E_ALL);
//ini_set('display_errors', 1);
        
        $this->load->view('header',$this->data);     
        $this->data['states'] = $this->Ums_admission_model->fetch_states();
        $stud_id=$this->uri->segment(3);
	//$college_id = $this->session->college_id;
	//$up_stud_id=$_REQUEST['s'];
//	echo $campus_id;
	
	    $college_id = 1;
      //  $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
      
     //  $academic_year='2016-17';
$academic_year='2019-20';

$acyear='2019';

$prov_det = $this->Ums_admission_model->verifypro_prn($stud_id);
/*echo "<pre>";
print_r($prov_det);
echo "</pre>";
die;*/
/*var_dump($prov_det);
exit();*/
	    	$this->data['stud_det']= $prov_det;
//	    $this->data['stream_det']= $this->Ums_admission_model->fetch_stcouse_details1();
	    		
	    			$this->data['stream_det']= $this->Ums_admission_model->fetch_stcouse_details1($prov_det['ums_id']); 
	    	
	    		$this->data['district']= $this->Ums_admission_model->getStatewiseDistrict($prov_det['state_id']);		
	    				
	    			$this->data['edu_det']= $this->Ums_admission_model->provisional_edu_det($stud_id);
	    			$this->data['fee_det']= $this->Ums_admission_model->provisional_fee_det($stud_id);	
	    			 //$this->data['acfees']= $this->Ums_admission_model->fetch_academic_fees_for_stream_year($prov_det['ums_id'],$acyear,$prov_det['admission_year']);
	    $this->data['acfees']= $this->Ums_admission_model->fetch_academic_fees_stream_year_adm($prov_det['ums_id'],$acyear,$acyear,$prov_det['admission_year']);
	  		 
	    			 
	    		//	var_dump($this->Ums_admission_model->fetch_stcouse_details1($prov_det['ums_id']));
	    		//	exit();
	    			
	    			$this->data['school_list']= $this->Ums_admission_model->list_schools();
	    		$this->data['course_list']= $this->Ums_admission_model->getschool_course($this->data['stream_det'][0]['school_id']);
	    		$this->data['stream_list']= $this->Ums_admission_model->getcourse_streams($this->data['stream_det'][0]['course_id']);
	    		$this->data['exam_list']= $this->Ums_admission_model->entrance_exam_master();
	    	
	    	
	    		//	exit();
	    
	    $this->data['course_details'] = $this->Ums_admission_model->getcourse_yearwise($academic_year);
		$this->data['doc_list']= $this->Ums_admission_model->getdocumentlist();
		$this->data['category']= $this->Ums_admission_model->getcategorylist();
		$this->data['religion']= $this->Ums_admission_model->getreligionlist();
	$this->data['course_year']= $this->Ums_admission_model->getCourseYRClg($college_id);
	$this->data['branches']= $this->Ums_admission_model->getbranch($college_id);
	
	$this->data['bank_details']= $this->Ums_admission_model->getbanks();
		$this->data['pmedia']= $this->Ums_admission_model->getpmedias();
	
/*	if(!empty($_REQUEST['s'])){ //code for update
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
	}*/
	    $this->load->view($this->view_dir.'confirm_prov_adm',$this->data);
        $this->load->view('footer');
    }














//ends







		
		function validate_receipt()
		{
		  $this->Ums_admission_model->validate_receipt();     
		}
		
		
	function activate_student_login()
	{
	   $this->Ums_admission_model->activate_slogin(); 
	}
	
	function create_stu_par_login()
	{
	    $this->Ums_admission_model->creat_stu_par_login();  
	}
	
	function delete_fees()
	{
	      $this->Ums_admission_model->delete_fees();  
	}
	
	
	function generatepdf()
	{
	    ini_set('memory_limit', '4096M');
		ini_set("pcre.backtrack_limit", "1000000");
        $data['emp_list']= $this->Ums_admission_model->getStudentsajax($_POST['dcourse'],$_POST['dyear'],$_POST['academic_year_pdf']);
	    $data['dstream']= $this->Ums_admission_model->getfieldname_byid('vw_stream_details','stream_id',$_POST['dcourse'],'stream_name');
	    $data['dyear']= $_POST['dyear'];
	    $filename= $data['dstream']."-".$_POST['dyear']."-Year";
	    $pdfFilePath = "StudentList-". $filename.".pdf";
        $html = $this->load->view($this->view_dir.'student_listpdf',$data,true);
        $param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
        try{
        $this->load->library('m_pdf',$param);
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4-L', '15', '15', '15', '15', '15', '10');
		$this->m_pdf->pdf->AddPage();
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->WriteHTML($html);

		$this->m_pdf->pdf->Output($pdfFilePath, "D");
		
		}catch(Exception $e){
			echo $e->getMessage();die();
		}
	}

function generate_payment_receipt($fees_id='')
{
    
	 //    error_reporting(E_ALL);
//ini_set('display_errors', 1);
/*$data['emp_list']= $this->Ums_admission_model->getStudentsajax($_POST['dcourse'],$_POST['dyear']);



	       $data['dstream']= $this->Ums_admission_model->getfieldname_byid('vw_stream_details','stream_id',$_POST['dcourse'],'stream_name');
	     $data['dyear']= $_POST['dyear'];
	      
	      $filename= $data['dstream']."-".$_POST['dyear']."-Year";
	     $pdfFilePath = "StudentList-". $filename.".pdf";
*/

$data['fee_det']= $this->Ums_admission_model->get_challan_details($fees_id);

$html = $this->load->view($this->view_dir.'payment_receipt_pdf',$data,true);

$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';

        $this->load->library('m_pdf',$param);

       $this->m_pdf->pdf->WriteHTML($html);

        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
 $pdfFilePath = "output_pdf_name.pdf";        
    
}



	function generateallpdfs()
	{
	  //ini_set('memory_limit', '-1'); 
	
	 error_reporting(E_ALL);
ini_set('display_errors', 1);

//$data['emp_list']= $this->Ums_admission_model->getStudentsajax();
//var_dump($this->Ums_admission_model->getStudentsajax());

//$data['valid']= $this->Ums_admission_model->get_course_duration($_POST['dcourse']);

//var_dump($this->Ums_admission_model->getStudentsajax($_POST['astream'],$_POST['ayear']));getfieldname_byid

//exit(0);
	      // $data['dstream']= $this->Ums_admission_model->getfieldname_byid('vw_stream_details','stream_id',$_POST['dcourse'],'stream_name');
	       
	       
	       
	      //  $data['short_stream']= $this->Ums_admission_model->getfieldname_byid('vw_stream_details','stream_id',$_POST['dcourse'],'stream_short_name');
	       
	       
	       
	       
	   //  $data['dyear']= $_POST['dyear'];
	     
	     
	      $data['ids']= $this->Ums_admission_model->student_Idsall();
	  
	  //    var_dump();
	   $filename= "-Year";
	      //$filename= $data['dstream']."-".$_POST['dyear']."-Year";
	     $pdfFilePath = "StudentList-". $filename.".pdf";
// $html = $this->load->view('agents/invoices/invoice_pdf',$data,true);

$html=$this->load->view($this->view_dir.'all_icard',$data,true);

$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
        //load mPDF library
        $this->load->library('m_pdf',$param);
       //generate the PDF from the given html
       $this->m_pdf->pdf->WriteHTML($html);
//echo $html;
// exit(0);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
 
	    
	}







	
	
	
function create_login()
{
   $this->Ums_admission_model->create_student_login(); 
    
}
function check_email()
{
   $this->Ums_admission_model->smstest(); 
}


	function generateID()
	{
		//print_r($_POST);die;
		$data['emp_list'] = $this->Ums_admission_model->getStudentsajax($_POST['dcourse'],$_POST['dyear']);
		$data['valid'] = $this->Ums_admission_model->get_course_duration($_POST['dcourse']);
	    $data['dstream'] = $this->Ums_admission_model->getfieldname_byid('vw_stream_details','stream_id',$_POST['dcourse'],'stream_name');
	    $data['short_stream'] = $this->Ums_admission_model->getfieldname_byid('vw_stream_details','stream_id',$_POST['dcourse'],'stream_short_name');
	    $data['dyear'] = $_POST['dyear'];
	    $data['ids'] = $this->Ums_admission_model->student_Ids($_POST);
		$filename = $data['dstream']."-".$_POST['dyear']."-Year";
	    $pdfFilePath = "StudentList-". $filename.".pdf";
		// $html = $this->load->view('agents/invoices/invoice_pdf',$data,true);
		$html = $this->load->view($this->view_dir.'student_icard', $data, true);

		$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
        //load mPDF library
        $this->load->library('m_pdf', $param);
		$this->m_pdf->pdf->SetFont('IDAutomationHC39M Code 39 Barcode');

        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
 		$pdfFilePath = "output_pdf_name.pdf";     
	}
	
	function applyexem()
	{
				//echo "exxcxcx";exit;
		$this->Ums_admission_model->fee_exemption();
		   //echo '<script>alert("Fees updated successfully for selected students");<script>';
				  // redirect('orderManagement/index', 'refresh');
				 // $this->stud_feelist($st=0,$_POST['dcourse'],$_POST['dyear']);
		$this->session->set_flashdata('errormessage','Fees updated successfully for selected students');

		 redirect('ums_admission/stud_feelist/'.$_POST['dcourse'].'/'.$_POST['dyear']);
	    
	}
	

	
    public function add()
    {
        $this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
	
	
 function add_bonafied(){
        //echo 1;exit;
        $this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'add_bonafied',$this->data);
        $this->load->view('footer');
 }


 function add_transfer_cert(){
       $this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'add_transfer_cert',$this->data);
        $this->load->view('footer');
 }


 function add_migration_cert(){
       $this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'add_migration_cert',$this->data);
        $this->load->view('footer');
 }

	
	
function bonafied_list()
{
    
    $this->data['student_list']= $this->Ums_admission_model->list_bonafied();
    $this->load->view('header',$this->data);        
    $this->load->view($this->view_dir.'bonafied',$this->data);
    $this->load->view('footer');
}



function transfer_certificate()
{
   // ini_set('display_errors', 1);
   $this->data['student_list']= $this->Ums_admission_model->transfer_certificate();
      $this->data['academic_years']= $this->Ums_admission_model->all_academic_session();
    $this->load->view('header',$this->data);        
    $this->load->view($this->view_dir.'transfer_cert',$this->data);
    $this->load->view('footer');
}

function migration_certificate()
{
    
   $this->data['student_list']= $this->Ums_admission_model->migration_certificate();
   $this->data['academic_years']= $this->Ums_admission_model->all_academic_session();
    $this->load->view('header',$this->data);        
    $this->load->view($this->view_dir.'migration_cert',$this->data);
    $this->load->view('footer');
}




function verifyprn_bonafide()
{
    $pda['prn'] = $_POST['prn'];

   $bdat=$this->Ums_admission_model->verify_prnno($pda);
   //echo "sdd";
   //print_r($bdat);
 
   if($bdat[stream_name]!='')
   {
  // echo "Name : ".$bdat['first_name']." ".$bdat['middle_name']." ".$bdat['last_name']." Course : ".$bdat['course_name']." Stream :".$bdat['stream_name']." Year : ".$bdat['admission_year'];
   echo  json_encode($bdat);

   }
   else
   {
       echo "N";
   }
  // var_dump($bdat);
}
function verifyprn_bonafide1()
{
    $pda['prn'] = $_POST['prn'];

   $bdat=$this->Ums_admission_model->verify_prnno1($pda);
   //echo "sdd";
   //print_r($bdat);
 
   if($bdat[stream_name]!='')
   {
  // echo "Name : ".$bdat['first_name']." ".$bdat['middle_name']." ".$bdat['last_name']." Course : ".$bdat['course_name']." Stream :".$bdat['stream_name']." Year : ".$bdat['admission_year'];
   echo  json_encode($bdat);

   }
   else
   {
       echo "N";
   }
  // var_dump($bdat);
}

function check_deregistration()
{
    $pda['prn'] = $_POST['prn'];

   $bdat=$this->Ums_admission_model->verify_prnno($pda);
   //echo "sdd";
   //print_r($bdat);
 
   if($bdat[stream_name]!='')
   {
  // echo "Name : ".$bdat['first_name']." ".$bdat['middle_name']." ".$bdat['last_name']." Course : ".$bdat['course_name']." Stream :".$bdat['stream_name']." Year : ".$bdat['admission_year'];
   echo  json_encode($bdat);

   }
   else
   {
       echo "N";
   }
  // var_dump($bdat);
}


function bonafied_pdf()
{
  
        $this->Ums_admission_model->generate_bonafied();	
        $this->load->view('header',$this->data);   
        $this->session->set_flashdata('message2','Bonafied is addedd successfully');
        $this->load->view($this->view_dir.'add_bonafied',$this->data);
        
}


function generate_transfer_cert($reg='')
{
  
        $this->Ums_admission_model->generate_transfer_cert();
       $this->load->view('header',$this->data);   
        $this->session->set_flashdata('message2','Transfer Certificate is addedd successfully');
        $this->load->view($this->view_dir.'add_transfer_cert',$this->data);
        
}


function generate_migration_cert($reg='')
{
		//error_reporting(E_ALL);echo "Inside";//exit;
		$this->load->model('Ums_admission_model');
        $this->Ums_admission_model->generate_migration_cert($_POST);
       $this->load->view('header',$this->data);   
        $this->session->set_flashdata('message2','Migration Certificate is addedd successfully');
        $this->load->view($this->view_dir.'add_migration_cert',$this->data);
        
}


	
function regenerate_bonafide($bid='',$enroll='')
{
    
    
     $bddata = $this->Ums_admission_model->regenerate_bonafied($enroll);
      $gendata = $this->Ums_admission_model->list_bonafied($bid,$refid='');
      $data['bonafieddata']= $bddata;
      $subs=substr($bddata['academic_year'],-2);
      $data['curryear']=$bddata['academic_year'];
      $data['subyear']=$subs+1;
      
       $data['idate']=$gendata[0]['cert_date'] ;
        $data['purpose']=$gendata[0]['purpose'] ;
         $data['reg']= $gendata[0]['cert_reg'];
    $html = $this->load->view($this->view_dir.'bonafiedpdf',$data,true);
//echo $html;exit;
//$html ="<div>gdf dfg df fdg fg dg gfdg gd fg</div>";
    $pdfFilePath = "Bonafied Certificate.pdf";
//$param = '"en-GB-x","A4","","",0,0,0,0,0,0,P';
        //load mPDF library
        $this->load->library('m_pdf');
		$mpdf=new mPDF();
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '10', '10', '10', '10');
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
 $pdfFilePath = "output_pdf_name.pdf"; 
 
}
	
	
	
	
function regenerate_transfer_cert($bid='',$enroll=''){  
//ob_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
   
       $bddata = $this->Ums_admission_model->regenerate_transfer_cert($enroll);
      //$gendata = $this->Ums_admission_model->transfer_certificate($bid,$refid='');
      $data['cert_data'] = $this->Ums_admission_model->transfer_certificate($bid,$refid='');
      $data['bonafieddata']= $bddata;
     // print_r($bddata);
//exit();

    
    $html = $this->load->view($this->view_dir.'transfer_cert_pdf',$data,true);
	 
	//$html = $this->load->view($this->view_dir.'transfer_cert_pdf',$data);
//echo $html;
//exit();
//$html ="<div>gdf dfg df fdg fg dg gfdg gd fg</div>";
    
	$param = '"en-GB-x","A4","","",0,0,0,0,0,0,P';
        //load mPDF library
        $this->load->library('m_pdf',$param);
		$mpdf=new mPDF(/*[
			'mode' => 'en-GB-x',
			'format' => 'A4',
			'default_font_size' => 0,
			'default_font' => '',
			'margin_left' => 50,
			'margin_right' => 25,
			'margin_top' => 25,
			'margin_bottom' => 25,
			'margin_header' => -10,
			'margin_footer' => -10,
			'orientation' => 'P',
		]*/);
        $watermark = 'https://erp.sandipuniversity.com/assets/su-watermark-logo.png';

// Image dimensions (mm)
$imgWidth  = 19;
$imgHeight = 45;

// Page dimensions
$pageWidth  = $this->m_pdf->pdf->w;
$pageHeight = $this->m_pdf->pdf->h;

// 🧭 Adjust for center + slightly upward (ideal for A4 portrait)
$x = ($pageWidth - $imgWidth) / 2 - 2;  // tiny left shift
$y = ($pageHeight - $imgHeight) / 2 - 25; // move up ~25 mm

$this->m_pdf->pdf->SetWatermarkImage(
    $watermark,
    0.2,                         // opacity
    '',                          // alpha mode
    array($imgWidth, $imgHeight),
    $x,
    $y
);
$this->m_pdf->pdf->showWatermarkImage = true;
        
      //   $this->m_pdf->pdf->SetWatermarkText('DRAFT');
// $this->m_pdf->pdf->showWatermarkText = true;align='left'
  //$this->m_pdf->pdf->SetHTMLFooter("<div  style='min-height:10px;margin:0px 0px 30px 30px;'>It is Certified that above information is in accordance with the Institute's records<br><br></div>");
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        $pdfFilePath =$enroll."-Transfer Certificate.pdf";
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
	
		//$pdfFilePath = "output_pdf_name.pdf"; 
	//	ob_clean();
 
}
		
	
	
	function regenerate_migration_cert($bid='',$enroll='')
{
    
    
     $bddata = $this->Ums_admission_model->regenerate_migration_cert($enroll);
      //$gendata = $this->Ums_admission_model->transfer_certificate($bid,$refid='');
      $data['cert_data'] = $this->Ums_admission_model->migration_certificate($bid,$refid='');
      $data['bonafieddata']= $bddata;
      

    $html = $this->load->view($this->view_dir.'migration_cert_pdf',$data,true);

//$html ="<div>gdf dfg df fdg fg dg gfdg gd fg</div>";
    $pdfFilePath = "Migration Certificate.pdf";
	//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
        //load mPDF library
         //load mPDF library
        $this->load->library('m_pdf');
		$mpdf=new mPDF();
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '10', '10', '10', '10');
		
      
$watermark = 'https://erp.sandipuniversity.com/assets/su-watermark-logo.png';

// Image dimensions (mm)
$imgWidth  = 19;
$imgHeight = 40;

// Page dimensions
$pageWidth  = $this->m_pdf->pdf->w;
$pageHeight = $this->m_pdf->pdf->h;

// 🧭 Adjust for center + slightly upward (ideal for A4 portrait)
$x = ($pageWidth - $imgWidth) / 2 - 2;  // tiny left shift
$y = ($pageHeight - $imgHeight) / 2 - 25; // move up ~25 mm

$this->m_pdf->pdf->SetWatermarkImage(
    $watermark,
    0.2,                         // opacity
    '',                          // alpha mode
    array($imgWidth, $imgHeight),
    $x,
    $y
);
$this->m_pdf->pdf->showWatermarkImage = true;



		//end watermark
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
 $pdfFilePath = "output_pdf_name.pdf"; 
 
}
		
	
	
	
	public function test()
	{
		//exit;
		// $this->Ums_admission_model->create_student_login();
		//exit;
		//$ff=$this->Ums_admission_model->send_login_credentials();exit;
		
		//die;
		//error_reporting(E_ALL);
	    // $this->Ums_admission_model->migrate_attendance();
    //$this->Ums_admission_model->change_engine();
	          // error_reporting(E_ALL);
//ini_set('display_errors', 1); 
  $this->Ums_admission_model->generate_allprn_suerp();exit;

//echo $this->Ums_admission_model->calculate_attempts(724,163,7);

//$this->Ums_admission_model->shift_emp_inhouse();

//$this->Ums_admission_model->update_parent_mobile();

//$this->Ums_admission_model->result_master_update();
//$this->Ums_admission_model->update_admission_details_for_2018();
//$this->Ums_admission_model->update_exam_student_subject(27); // for failed student updation arear 
//echo 'Done';
//$this->Ums_admission_model->update_exam_student_subject_pharma(24); // for failed student updation for pharma

// phd arriers link 

// $this->Ums_admission_model->phd_update_exam_student_subject(8); // for failed student updation arear for PHD
//echo 'done';exit;
	    //$stream_id='5';
	    //$academic_year='2016-17';
	    //$admission_year='1';
	   //$this->Ums_admission_model->generate_prn_punching();
	   //echo 'Done11';
	 //  $this->Ums_admission_model->exam_result_data(5,17);
	   
	//   $foo =500.94;
	 //echo  number_format((float)$foo, 2, '.', '');  170109051001 170109051002 
	    

	 
//	 $this->Ums_admission_model->insert_sf_student_data();
	    
//$this->Ums_admission_model->exam_result_data(7) ;
// for result generation cgpa 
//echo bcdiv('1010', '131', 4); exit;
//$this->Ums_admission_model->calculate_sgpa(26,8,$stream_id=""); //$stream_id="122"   
//$this->Ums_admission_model->calculate_cgpa(26,$stream_id="");
//$this->Ums_admission_model->calculate_gpa(26,8,$stream_id="");     
//echo 'done8';  exit;
//for pharma gpa generation	    
//$this->Ums_admission_model->calculate_sgpa_pharma(24,5);	    
//$this->Ums_admission_model->calculate_cgpa_pharma(24);
//$this->Ums_admission_model->calculate_gpa_pharma(24,5);

	    
	   // $this->Ums_admission_model->transfer_result();
	    	    
 //$this->Ums_admission_model->send_stlogin();
//$this->Ums_admission_model->send_login_credentials();
	    
	   // $this->Ums_admission_model->fetch_admission_details(2);
	   // $prn = $this->Ums_admission_model->generateprn_new($stream_id,$academic_year,$admission_year);
	  //  echo $prn;
	   // exit(0);
	   // $str = "jugal";
	 //   echo strtoupper($str);
//$prn = $this->Ums_admission_model->generate_allprn();
//$prn =
//echo 'done';
	    //  echo '<script>alert("PRN Number of '.$nam.' is '.$stud_reg_id.'"); window.location.href = "stud_list";<script>';
 //window.location.href = "auth/login";
// echo $prn;
	    
	}
	
	 public function stud_listold($offSet=0)
    {
        
           $this->load->view('header',$this->data);        
        $limit = 10;// set records per page
		if(isset($_REQUEST['per_page'])){
			$offSet=$_REQUEST['per_page'];
		}
		$this->load->model('Attendance_model');
		//$curr_session= $this->Attendance_model->getCurrentSession();
		//$data['ex_ses']= $this->Ums_admission_model->exam_sessions();
		$data['ex_ses']= $this->Attendance_model->getCurrentSession();
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
		 $college_id = 1;
		 $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
        $this->load->view($this->view_dir.'student_list',$this->data);
        $this->load->view('footer');
    }

	public function stud_list($offSet=0)
    {
		if($this->session->userdata("role_id")==2 || $this->session->userdata("role_id")==20 || 
		$this->session->userdata("role_id")==10 || $this->session->userdata("role_id")==44 ||
		$this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==6 || 
		$this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==59 || 
		$this->session->userdata("role_id")==65 || $this->session->userdata("role_id")==64|| $this->session->userdata("role_id")==66
		|| $this->session->userdata("role_id")==69|| $this->session->userdata("role_id")==70 || $this->session->userdata("role_id")==71){}else{
			redirect('home');
		}
    	$this->load->model('Attendance_model');
    	// $data['ex_ses']= $this->Attendance_model->getCurrentSession();
        $this->load->model('Exam_timetable_model');
        $this->data['ex_ses'] = $this->Exam_timetable_model->fetch_curr_exam_session();

        $this->load->view('header', $this->data);
        $this->load->view($this->view_dir.'students_list', $this->data);
        $this->load->view('footer');
    }

    public function studs_list()
    {
      $this->load->model('Studentadmissionmodel');
      $list = $this->Studentadmissionmodel->get_datatables();
      $role_id = $_SESSION['role_id'];
      $deptName = $_SESSION['name'];

      $data = array();
      $no = $_POST['start'];
      foreach ($list as $students) {
        $no++;
        $row = array();
        $row[] = '<input type="checkbox" value="'.$students->stud_id.'" name="lstd[]" class="checkBoxClass">';
        $row[] = $no;
        $row[] = $students->enrollment_no;
        $row[] = $students->enrollment_no_new;
        $row[] = $students->form_number;
        $bucket_key = '/uploads/student_photo/'.$students->student_photo_path;
		$imageData = $this->awssdk->getImageData($bucket_key);
        
        //$student_img = base_url().$students->student_photo_path;
        $student_img = $imageData;
        $row[] = '<img src='.$student_img.' alt="" width="80" height="80">';
        $row[] = $students->first_name." ".$students->middle_name." ".$students->last_name;
        $row[] = $students->stream_name;
        $row[] = $students->admission_year;
        $gender = $students->gender;
        $finalGender = '';
        if(!empty($gender) && $gender == "M") {
        	$finalGender = "Male";
        } else {
        	$finalGender = "Female";
        }
        $row[] = $finalGender;
        $row[] = $students->dob;
        $row[] = $students->mobile;
        $row[] = $students->parent_mobile2;
        $row[] = $students->email;
        $row[] = $students->category;

        $action = '';
        if($role_id == 1 || $role_id == 2 || $role_id == 6) {
            if($deptName == 'student_dept' || $deptName == 'suerp') {     
              $studentEdit = base_url()."ums_admission/edit_personalDetails/".$students->stud_id;
              $action .= '<a  href="'.$studentEdit.'" title="View" target="_blank"><i class="fa fa-edit"></i>  </a>';
            }
        }

        $studentView = base_url()."ums_admission/view_studentFormDetails/".$students->stud_id;
        $action .= '<a  href="'.$studentView.'" title="View" target="_blank"><i class="fa fa-eye"></i>  </a>';
        $row[] = $action;

        $is_detained = $students->is_detained;
        if($is_detained == 'N') {
			$detention = '<button class="btn btn-success" id="no~'.$students->stud_id.'" onclick="return mark_detention(this.id)">N</button>';

			$change_stream = base_url()."ums_admission/change_stream/".$students->stud_id;
			$streamBtn = '<a  href="'.$change_stream.'" title="View" target="_blank" title="Change Stream" ><span class="btn btn-primary">Change Stream</span></a>';
		} else {
			$detention = '<button class="btn btn-danger">Detained</button>';
			$streamBtn = '<button class="btn btn-danger">Detained</button>';
		}

		$row[] = $detention;
		$row[] = $streamBtn;

        $data[] = $row;
      }

      $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->Studentadmissionmodel->count_all(),
              "recordsFiltered" => $this->Studentadmissionmodel->count_filtered(),
              "data" => $data,
          );

      echo json_encode($output);
    }

	 public function stud_list_icard($offSet=0)
    {
           $this->load->view('header',$this->data);        
        $limit = 10;// set records per page
		if(isset($_REQUEST['per_page'])){
			$offSet=$_REQUEST['per_page'];
		}
        $total= $this->Ums_admission_model->getAllStudents();
    //    $this->data['emp_list']= $this->Ums_admission_model->getStudents($offSet,$limit);
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
		 $college_id = 1;
		 $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
        $this->load->view($this->view_dir.'student_list_icard',$this->data);
        $this->load->view('footer');
    }
	

	
		function load_studentlist()
	{
	   
	   // error_reporting(E_ALL);
	   $this->load->model('Exam_timetable_model');
		$data['ex_ses']= $this->Exam_timetable_model->fetch_curr_exam_session();

	      $data['emp_list']= $this->Ums_admission_model->getStudentsajax($_POST['astream'],$_POST['ayear'],$_POST['acdyear']);
	       $data['dcourse']= $_POST['astream'];
	       $data['dyear']= $_POST['ayear'];
		   $data['academic_year']= $_POST['acdyear'];
	       $data['hide']= $_POST['hide'];
	   
	   $html = $this->load->view($this->view_dir.'load_studentdata',$data,true);
	   echo $html;
	   
	}

	public function loadStudentsList()
    {
      //DD($list,"here");
      $stream = $this->input->post('astream');
      $admissionYear = $this->input->post('ayear');
      $academicYear = $this->input->post('acdyear');
      $role_id = $_SESSION['role_id'];
      $deptName = $_SESSION['name'];

      $this->load->model('Loadstudentsmodel');
      $list = $this->Loadstudentsmodel->get_datatables('', $stream, $admissionYear, $academicYear);
      //DD($list);
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $students) {
		   if($students->transefercase == 'Y'){
			 $prn = $students->enrollment_no. '<img src="https://erp.sandipuniversity.com/uploads/Transfer-PNG.png" style="width:15px; height:15px">';
		  }
		  else{
			  $prn = $students->enrollment_no;
		  } 
        $no++;
        $row = array();
        $row[] = '<input type="checkbox" value="'.$students->stud_id.'" name="lstd[]" class="checkBoxClass">';
        $row[] = $no;
        $row[] = $prn;
        $row[] = $students->enrollment_no_new;
		$row[] = $students->punching_prn;
        $row[] = $students->form_number;

		$bucket_key = 'uploads/student_photo/'.$students->enrollment_no.'.jpg';
		$imageData = $this->awssdk->getImageData($bucket_key);
	
        $student_img = $imageData;
        $row[] = '<img src='.$student_img.' alt="" width="80" height="80">';
        $row[] = $students->first_name." ".$students->middle_name." ".$students->last_name;
        $row[] = $students->marathi_name;
        $row[] = $students->stream_name;
        $row[] = $students->admission_year;
		$row[] = $students->current_year;
        $gender = $students->gender;
        $finalGender = '';
        if(!empty($gender) && $gender == "M") {
        	$finalGender = "Male";
        } else {
        	$finalGender = "Female";
        }
        $row[] = $finalGender;
        $row[] = $students->dob;
		$row[] = $students->admission_date;
        $row[] = $students->mobile;
		//$row[] = $students->username;
		//$row[] = $students->password;
        $row[] = $students->parent_mobile2;
        $row[] = $students->email;
        $row[] = $students->category;
		
        $reported_status = $students->reported_status;
        //$row[] = ($reported_status == 'N') ? 'Not Reported' : 'Reported On '.$students->reported_date;

        if($role_id == 5) {     
              $studentPayments = base_url()."ums_admission/viewPayments/".$students->stud_id;
              $row[] = '<a  href="'.$studentPayments.'" title="View Payments" target="_blank"><i class="fa fa-credit-card" aria-hidden="true"></i>  </a>';
        }

        if($role_id == 7) {     
              $studentPaymentDept = base_url()."ums_admission/viewPayment_det/".$students->stud_id;
              $row[] = '<a  href="'.$studentPaymentDept.'" title="View Payment Department" target="_blank"><i class="fa fa-credit-card" aria-hidden="true"></i>  </a>';
        }

        if($role_id == 6 || $role_id == 2) {
            if($deptName == 'student_dept' || $deptName == 'suerp' || $deptName == 'suerp_aryan') {     
              $studentEdit = base_url()."ums_admission/edit_personalDetails/".$students->stud_id;
              $row[] = '<a  href="'.$studentEdit.'" title="View" target="_blank"><i class="fa fa-edit"></i>  </a>';
            }
        }

        if($role_id == 15 || $role_id == 10 || $role_id == 6) {     
              $studentViewSubject = base_url()."Subject_allocation/view_studSubject/".$students->stud_id;
			  $row[] = '<a  href="'.$studentViewSubject.'" title="View Subject" target="_blank"><i class="fa fa-book" aria-hidden="true"></i></a>';
        }  

        $action = '';
        $studentView = base_url()."ums_admission/view_studentFormDetails/".$students->stud_id;
        $row[] = '<a  href="'.$studentView.'" title="View" target="_blank"><i class="fa fa-eye"></i>  </a>';

        $is_detained = $students->is_detained;
        $detainBtn = '';

        if($is_detained == 'Y') {
           $btncls = "btn-danger"; 
        } else if($is_detained == 'N') {
           $btncls = "btn-success";
        } else {
            $btncls = "btn-info";
        }

        if($role_id == 15) {
        	$std_reason = $this->Ums_admission_model->fetch_stud_detain_reason($students->stud_id);
        	$std_details = $students->admission_stream.'~'.$students->current_semester.'~'.$students->academic_year;
			if($is_detained == 'Y') {
                $detainBtn = '<span class="btn <?=$btncls?> btn-xs">Detained</span>';
            } else {
            	$detainBtn = '<a class="marksat" id="state'.$students->stud_id.'" data-stud_id="'.$students->stud_id.'"  data-dexses="'.$std_reason[0]['exam_session'].'" data-dstatus="'.$is_detained.'" data-stud_details="'.$std_details.'" data-stud_dreason="'.$std_reason[0]['reason'].'" data-toggle="modal" data-target="#walkinModal" style="cursor:pointer"><span class="btn '.$btncls.' btn-xs">'.$is_detained.'</span></a>';
            }

            $row[] = $detainBtn;
        }

        if($role_id == 15 || $role_id == 2) {
			$detainBtnTwo=1;
        	$check_request_of_stream_change=$this->Ums_admission_model->check_request_of_stream_change($emp_list[$i]['stud_id']);
        	if($is_detained == 'Y') {
        		$detainBtnTwo = '<span class="btn '.$btncls.' btn-xs">Detained</span>';
        	} else {
        		if($check_request_of_stream_change[0]['is_approved'] == ''
        		   || $check_request_of_stream_change[0]['is_approved'] == 'Y' ) {
        		   	$change_stream = base_url()."ums_admission/change_stream/".$students->stud_id;
        			$detainBtnTwo = '<a  href="'.$change_stream.'" title="Change Stream" target="_blank"><span class="btn btn-primary">Change Stream</span> </a>';
        		} else {
        			$detainBtnTwo = 'Requested';
        		}
        	}

        	$row[] = $detainBtnTwo;
        }

        $data[] = $row;
      }

      $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->Loadstudentsmodel->count_all('', $stream, $admissionYear, $academicYear),
              "recordsFiltered" => $this->Loadstudentsmodel->count_filtered('', $stream, $admissionYear, $academicYear),
              "data" => $data,
          );

      echo json_encode($output);
    }
	
	
	
	
	
			function load_studentlist_icard()
	{
	    
	   
	    $academic_year='2017';
	      $data['emp_list']= $this->Ums_admission_model->load_studentlist_icard($_POST['astream'],$_POST['ayear'],$academic_year);
	       $data['dcourse']= $_POST['astream'];
	        $data['dyear']= $_POST['ayear'];
	      
	      $html = $this->load->view($this->view_dir.'load_studentdata_icard',$data,true);
	  echo $html;
	}
	
	
	
function search_studentdata()
{
     $data['emp_list']= $this->Ums_admission_model->searchStudentsajax($_POST);
	  $this->load->model('Exam_timetable_model');
		$data['ex_ses']= $this->Exam_timetable_model->fetch_curr_exam_session();
	  $data['dcourse']= $_POST['astream'];
	        $data['dyear']= $_POST['ayear'];
	         $data['hide']= $_POST['hide'];
	      
	      $html = $this->load->view($this->view_dir.'load_studentdata',$data,true);
	  echo $html;
}
	
	function search_cancaldata()
{
     $data['emp_list']= $this->Ums_admission_model->searchforcanc1($_POST);
	  $data['dcourse']= $_POST['astream'];
	        $data['dyear']= $_POST['ayear'];
	        	$data['bank_details']= $this->Ums_admission_model->getbanks();
	     // $data['type'] = $_POST['type'];
	      if($_POST['type']=="refund"){
	       $html = $this->load->view($this->view_dir.'load_refund_data',$data,true);    
	      }
	      else
	      {
	       $html = $this->load->view($this->view_dir.'load_cancel_data',$data,true);   
	      }
	      
	  echo $html;
}
	
	
	
	function search_studentfeedata(){       
	$data['acdyear']= $_POST['acdyear'];
	$data['acourse']= $_POST['acourse'];
    $data['astream']= $_POST['astream'];
	$data['ayear']= $_POST['ayear'];
	$data['prn']= $_POST['prn'];
	
    $data['emp_list']= $this->Ums_admission_model->searchStudentfeedata1($_POST['acourse'],$_POST['astream'],$_POST['ayear'],$data['acdyear'],$data['prn']);
   
    
    $data['count_rows']=count($data['emp_list']);
	      $html = $this->load->view($this->view_dir.'fee_adjust',$data,true);
	  echo $html;
}
	
	
	
	
 public function cancel_admission($prn=''){
	 if($this->session->userdata("role_id")==2 ||  $this->session->userdata("role_id")==59 ||  $this->session->userdata("role_id")==6 ||  $this->session->userdata("role_id")==5){
		}else{
			redirect('home');
		}
		   $this->load->view('header',$this->data); 
		   $this->load->model('Account_model');
			$this->data['exam_session']= $this->Account_model->fetch_stud_curr_year();
		    $this->data['emp_list']= $this->Ums_admission_model->get_cancelled_adm($prn);
		     $this->load->view($this->view_dir.'cancel_list',$this->data);
		    $this->load->view('footer');
	 }
	 
	 public function load_cancel_admission()
	 { 		
			$prn=$_POST['prn'];	 
			
	       $this->data['emp_list']= $this->Ums_admission_model->get_cancelled_adm($prn);
		    $this->load->view($this->view_dir.'load_cancel_list',$this->data);
	     
	 }
	 
	 
	 function send_reset_password()
	 {
	     
	  $this->Ums_admission_model->send_reset_password();   
	  
	 }
	 
	 	 function reset_student_password()
	 {
	     	if($_POST){
	     	    
	     	     $pda['prn'] = $_POST['prn'];
   $bdat =  $this->Ums_admission_model->verify_prnno($pda);
   if($bdat[stream_name]!='')
   {
  // echo "Name : ".$bdat['first_name']." ".$bdat['middle_name']." ".$bdat['last_name']." Course : ".$bdat['course_name']." Stream :".$bdat['stream_name']." Year : ".$bdat['admission_year'];
   echo  json_encode($bdat);

   }
   else
   {
       echo "N";
   }
	     	    
	     	    
	     	    
	     	}
	     	else
	     	{
	     	     $this->load->view('header',$this->data); 
		   
		     $this->load->view($this->view_dir.'reset_password',$this->data);
		    $this->load->view('footer');
	     	}
	 }
	 
	 
	 
	 
	 
	 
	 
 public function fees_refund(){
		   $this->load->view('header',$this->data); 
		    $this->data['emp_list']= $this->Ums_admission_model->fees_refund();
		     $this->load->view($this->view_dir.'refund_list',$this->data);
		    $this->load->view('footer');
	 }
	 
	 




 public function stud_feelist($stream='',$year='')
    {
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6){
		}else{
			redirect('home');
		}
        $offset='0';
    
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
		 if($stream!='' && $year!='')
		 {
		  $this->data['emp_list']= $this->Ums_admission_model->searchStudentfeedata1($stream,$year);
		  $this->data['dcourse']=$stream;
		  $this->data['dyear']=$year;
		 }
		 
		  $college_id = 1;
		 $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
		 
		 $this->data['academic_year']= $this->uri->segment(3);// echo '<br>';
		 $this->data['admission_course']= $this->uri->segment(4); //echo '<br>';
		 $this->data['admission_branch']= $this->uri->segment(5); //echo '<br>';
		 $this->data['admission_year']= $this->uri->segment(6); //echo '<br>';
		 
        $this->load->view($this->view_dir.'stud_feelist',$this->data);
        $this->load->view('footer');
    }


    public function view()
    {
        $this->load->view('header',$this->data);        
        $this->data['campus_details']=$this->campus_model->get_campus_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    

		
			public function get_course_streams_yearwise()
		{
	 global $model;	    
	    $this->data['campus_details']= $this->Ums_admission_model->get_course_streams_yearwise($_POST);     	    
		}
		
		
	public function load_courses()
		{
	// global $model;	    
	  $course_details =  $this->Ums_admission_model->getschool_course($_POST['school']);  
	   $opt ='<option value="">Select Course</option>';
	    foreach ($course_details as $course) {

    $opt .= '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
}
echo $opt;
		}	
		
		
		
    public function form()
    {
        // redirect('ums_admission/stud_list','refresh');
        $this->load->view('header',$this->data);     
        $this->data['states'] = $this->Ums_admission_model->fetch_states();
		$this->data['kps'] = $this->Ums_admission_model->fetch_kps();
        $campus_id=$this->uri->segment(3);
	//$college_id = $this->session->college_id;
	//$up_stud_id=$_REQUEST['s'];
	//echo $stud_id;
	    $college_id = 1;
      //  $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
      
     //  $academic_year='2016-17';
$academic_year='2021-22';
	    
	    	$this->data['school_list']= $this->Ums_admission_model->list_schools();
	    $this->data['course_details'] = $this->Ums_admission_model->getcourse_yearwise($academic_year);
		$this->data['doc_list']= $this->Ums_admission_model->getdocumentlist();
		$this->data['category']= $this->Ums_admission_model->getcategorylist();
		$this->data['religion']= $this->Ums_admission_model->getreligionlist();
	$this->data['course_year']= $this->Ums_admission_model->getCourseYRClg($college_id);
	$this->data['branches']= $this->Ums_admission_model->getbranch($college_id);
	$this->data['exam_list']= $this->Ums_admission_model->entrance_exam_master();
	
	$this->data['bank_details']= $this->Ums_admission_model->getbanks();
		$this->data['pmedia']= $this->Ums_admission_model->getpmedias();
	
	if(!empty($_REQUEST['s'])){ //code for update
		$up_stud_id=$_REQUEST['s'];//student id for update 
		$check_stud_form_flag=$this->Ums_admission_model->check_flag_status($up_stud_id);// check steps completion status
		if($this->session->userdata('student_id')==$up_stud_id){
			if(($this->session->userdata('stepfirst_status')=='success') && ($check_stud_form_flag[0]['step_first_flag']==1)){
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
	
	
	 public function form_INTERNATIONAL()
    {
        // redirect('ums_admission/stud_list','refresh');
        $this->load->view('header',$this->data);     
        $this->data['states'] = $this->Ums_admission_model->fetch_states();
        $campus_id=$this->uri->segment(3);
	//$college_id = $this->session->college_id;
	//$up_stud_id=$_REQUEST['s'];
	//echo $stud_id;
	    $college_id = 1;
      //  $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
      
     //  $academic_year='2016-17';
$academic_year='2024-25';
	    
	    	$this->data['school_list']= $this->Ums_admission_model->list_schools();
	    $this->data['course_details'] = $this->Ums_admission_model->getcourse_yearwise($academic_year);
		$this->data['doc_list']= $this->Ums_admission_model->getdocumentlist();
		$this->data['category']= $this->Ums_admission_model->getcategorylist();
		$this->data['religion']= $this->Ums_admission_model->getreligionlist();
	$this->data['course_year']= $this->Ums_admission_model->getCourseYRClg($college_id);
	$this->data['branches']= $this->Ums_admission_model->getbranch($college_id);
	$this->data['exam_list']= $this->Ums_admission_model->entrance_exam_master();
	
	$this->data['bank_details']= $this->Ums_admission_model->getbanks();
		$this->data['pmedia']= $this->Ums_admission_model->getpmedias();
	
	if(!empty($_REQUEST['s'])){ //code for update
		$up_stud_id=$_REQUEST['s'];//student id for update 
		$check_stud_form_flag=$this->Ums_admission_model->check_flag_status($up_stud_id);// check steps completion status
		if($this->session->userdata('student_id')==$up_stud_id){
			if(($this->session->userdata('stepfirst_status')=='success') && ($check_stud_form_flag[0]['step_first_flag']==1)){
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
	$this->data['country'] = $this->Ums_admission_model->fetch_country();
		$this->data['states'] = $this->Ums_admission_model->fetch_states();
	    $this->load->view($this->view_dir.'ums_admission_INTERNATIONAL',$this->data);
        $this->load->view('footer');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	 public function searchstudents(){
		 if($this->session->userdata("role_id")==2 || $this->session->userdata("role_id")==69 
		 || $this->session->userdata("role_id")==20 || $this->session->userdata("role_id")==10 
		 || $this->session->userdata("role_id")==44 || $this->session->userdata("role_id")==15 
		 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==5 
		 || $this->session->userdata("role_id")==40 || $this->session->userdata("role_id")==17 
		 || $this->session->userdata("role_id")==45 || $this->session->userdata("role_id")==46 
		 || $this->session->userdata("role_id")==59 || $this->session->userdata("role_id")==23 
		 || $this->session->userdata("role_id")==65 || $this->session->userdata("role_id")==66 
		 || $this->session->userdata("role_id")==64 || $this->session->userdata("role_id")==67
		 || $this->session->userdata("role_id")==70 || $this->session->userdata("role_id")==72
		 || $this->session->userdata("role_id")==71 
		 || $this->session->userdata("role_id")==7 || $this->session->userdata("role_id")==50 || $this->session->userdata("role_id")==73  || $this->session->userdata("role_id")==74){}else{
			redirect('home');
		}
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
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx|pdf';
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
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx|pdf';
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
	     
	     //exit();
	      $stud_reg_id=$this->Ums_admission_model->student_registration_ums($_POST,$arr1,$arr2);
	     
	     //exit();
	     $nam = $_POST['slname']."".$_POST['sfname']."".$_POST['smname'];
	     
	      echo '<script>alert("PRN Number of '.$nam.' is '.$stud_reg_id.'");window.location.href = "stud_list";</script>';
	      // redirect('orderManagement/index', 'refresh');
	      
	     redirect('ums_admission/stud_list','refresh');
	 
	 }
	
	
	
	
		 function prov_admission_submit()
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
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx|pdf';
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
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx|pdf';
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
	     
	    
	      $stud_reg_id=$this->Ums_admission_model->prov_admission_submit($_POST,$arr1,$arr2);
	     
	     //exit();
	     $nam = $_POST['slname']."".$_POST['sfname']."".$_POST['smname'];
	     
	      echo '<script>alert("Provisional Registration Number of '.$nam.' is '.$stud_reg_id.'");window.location.href = "stud_list";</script>';
	      // redirect('orderManagement/index', 'refresh');
	      
	     redirect('ums_admission/stud_list','refresh');
	 
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
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx|pdf';
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
                $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
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
	public function getCountrywiseState(){
//ini_set('error_reporting', E_ALL);
		$Country_id=$_REQUEST['Country_id'];
		$lstate_id=$_REQUEST['lstate_id'];
		//echo $state;
		$state=$this->Ums_admission_model->getCountrywiseState($Country_id);
		//print_r($state);exit;
		if(!empty($state)){$sel='';
			echo"<option value=''>Select District</option>";
			foreach($state as $key=>$val){
				if($state[$key]['state_id']==$lCountry_id){
				$sel="selected";
				}else{
				$sel="";
				}
				echo"<option value='".$state[$key]['state_id']."' ".$sel.">".$state[$key]['state_name']."</option>";
			}		
		}
	}
		
		
	// fetch District by state
	public function getStatewiseDistrict(){

		$state=$_REQUEST['state_id'];
		$ldistrict_id=$_REQUEST['ldistrict_id'];
		//echo $state;
		$dist=$this->Ums_admission_model->getStatewiseDistrict($state);
		//print_r($dist);exit;
		if(!empty($dist)){$sel='';
			echo"<option value=''>Select District</option>";
			foreach($dist as $key=>$val){
				if($dist[$key]['district_id']==$ldistrict_id){
				$sel="selected";
				}else{
				$sel="";
				}
				echo"<option value='".$dist[$key]['district_id']."' ".$sel.">".$dist[$key]['district_name']."</option>";
			}		
		}
	}
	
	
	public function getStatewiseDistrict_p(){

		$state=$_REQUEST['state_id'];
		$ldistrict_id=$_REQUEST['ldistrict_id'];
		//echo $state;
		$dist=$this->Ums_admission_model->getStatewiseDistrict($state);
		//print_r($dist);exit;
		if(!empty($dist)){$sel='';
			echo"<option value=''>Select District</option>";
			foreach($dist as $key=>$val){
				if($dist[$key]['district_id']==$ldistrict_id){
				$sel="selected";
				}else{
				$sel="";
				}
				echo"<option value='".$dist[$key]['district_id']."' ".$sel.">".$dist[$key]['district_name']."</option>";
			}		
		}
	}
	
	
	
	
	// fetch city by state and district
	public function getStateDwiseCity(){
		$state_id=$_REQUEST['state_id'];
		$dist_id=$_REQUEST['district_id'];
		$lcity=$_REQUEST['lcity'];
		//echo $state;
		$city=$this->Ums_admission_model->getStateDwiseCity($state_id, $dist_id);
		//print_r($city);exit;
		$sel="";
		if(!empty($city)){
			echo"<option value=''>Select City</option>";
			foreach($city as $key=>$val){
			if($city[$key]['taluka_id']==$lcity){
				$sel="selected";
				}else{
				$sel="";
				}
				
				echo"<option value='".$city[$key]['taluka_id']."' ".$sel.">".$city[$key]['taluka_name']."</option>";
			}		
		}
	}
	
	
	// fetch city by state and district
	public function getStateDwiseCity_p(){
		$state_id=$_REQUEST['state_id'];
		$dist_id=$_REQUEST['district_id'];
		$lcity=$_REQUEST['lcity'];
		//echo $state;
		$city=$this->Ums_admission_model->getStateDwiseCity($state_id, $dist_id);
		//print_r($city);exit;
		$sel="";
		if(!empty($city)){
			echo"<option value=''>Select City</option>";
			foreach($city as $key=>$val){
				//echo $val;
				if($city[$key]['taluka_id']==$lcity){
				$sel="selected";
				}else{
				$sel="";
				}
				
				echo"<option value='".$city[$key]['taluka_id']."' ".$sel.">".$city[$key]['taluka_name']."</option>";
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
			  //  echo '<script>alert("PRN Number of '.$nam.' is '.$stud_reg_id.'");window.location.href = "stud_list";<script>';
			 $path= "http://erp.sandipuniversity.com/ums_admission/edit_personalDetails/".$_POST['student_id'];
			 echo '<script>alert("Student application updated  successfully..");window.location.href = "'.$path.'";</script>';
	//	redirect($path);
    }
	public function update_addressDetails()
    {
       $this->Ums_admission_model->update_address($_POST); 
         $msg5='student application updated  successfully..';
			 $this->session->set_flashdata('msg5', $msg5);
			  //  echo '<script>alert("PRN Number of '.$nam.' is '.$stud_reg_id.'");window.location.href = "stud_list";<script>';
			 $path= "http://erp.sandipuniversity.com/ums_admission/edit_AddressDetails/".$_POST['student_id'];
			 echo '<script>alert("Student application updated  successfully..");window.location.href = "'.$path.'";</script>';
	//	redirect($path);
    }
	
		public function update_bankDetails()
    { //error_reporting(E_ALL);
       $this->Ums_admission_model->registration_step5($_POST); 
         $msg5='student application updated  successfully..';
			 $this->session->set_flashdata('msg5', $msg5);
			redirect('ums_admission/edit_paymentDetails');
    }
	
	
	
		public function update_refDetails()
    {
       $this->Ums_admission_model->registration_step4($_POST); 
         $msg5='student application updated  successfully..';
			 $this->session->set_flashdata('msg5', $msg5);
			redirect('ums_admission/edit_refDetails');
    }
	

		public function update_docDetails()
    {
        
            $student_id = $this->session->userdata('studId');
        	if(!empty($_FILES['scandoc']['name'])){
			$_FILES['scandoc']['name']=$this->Ums_admission_model->rearrange1($_FILES['scandoc']['name']);
				// $filesCount = count($_FILES['scandoc']['name']);
	            //for($i = 0; $i < $filesCount; $i++){
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
            }
        $this->Ums_admission_model->update_stepthirddata($_POST); 
        $msg5='student application updated  successfully..';
		$this->session->set_flashdata('msg5', $msg5); 
		redirect('ums_admission/edit_docsndcertDetails');
    }
	
	public function update_docDetails_provisional()
    {
        //error_reporting(E_ALL);
        $student_id = $this->session->userdata('studId');
        	/*if(!empty($_FILES['scandoc']['name'])){
			$_FILES['scandoc']['name']=$this->Ums_admission_model->rearrange1($_FILES['scandoc']['name']);
			// $filesCount = count($_FILES['scandoc']['name']);
            //for($i = 0; $i < $filesCount; $i++){
				foreach($_FILES['scandoc']['name'] as $key => $val){
                $_FILES['userFile']['name'] = $student_id.'-'.$_FILES['scandoc']['name'][$key];
                $_FILES['userFile']['type'] = $_FILES['scandoc']['type'][$key];
                $_FILES['userFile']['tmp_name'] = $_FILES['scandoc']['tmp_name'][$key];
                $_FILES['userFile']['error'] = $_FILES['scandoc']['error'][$key];
                $_FILES['userFile']['size'] = $_FILES['scandoc']['size'][$key];
                 $arr1[$key]=str_replace(" ","_",$_FILES['userFile']['name']);
                $uploadPath = 'uploads/student_document/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx|pdf';//'gif|jpg|png|pdf|docx|pdf|txt'
				$config['overwrite']= TRUE;
                $config['max_size']= "2048000"; 
                $this->load->library('upload', $config);
                $this->upload->initialize($config);$error=array();
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$key]['file_name'] = str_replace(" ","_",$fileData['file_name']);
                    $uploadData[$key]['created'] = date("Y-m-d H:i:s");
                    $uploadData[$key]['modified'] = date("Y-m-d H:i:s");
                }else{
					            $error = array('error' => $this->upload->display_errors());

				}
            }
               }
	   print_r($fileData);
	   exit();*/
			  
        $this->Ums_admission_model->update_stepthirddata($_POST); 
        $msg5 = 'student application updated  successfully..';
		$this->session->set_flashdata('msg5', $msg5); 
		redirect('ums_admission/edit_docsndcertDetails_provisional');
    }
	
	public function reregistration_Cancelled($stud_id='',$stau='')
    {

        if($_POST)
        {
          // var_dump($_POST); 
           // exit();
		   $DB1 = $this->load->database('umsdb', TRUE);
	
	    $data['cancelled_admission']='Y';
	    $where=array("student_id"=>$_POST['stud_id']);
		$DB1->where($where); 
		$DB1->update('admission_details', $data);
     // $this->Ums_admission_model->cancel_stud_admission();
	 //////////////////////////////////////////////////////////////////////////////////////
	 //////////////////////////////////////////////////////////////////////////////////////
        $datas['admission_confirm']='N';
        $datas['cancelled_admission']='Y';
	    $wheres=array("stud_id"=>$_POST['stud_id']);
		$DB1->where($wheres); 
		$DB1->update('student_master', $datas);
		 //////////////////////////////////////////////////////////////////////////////////////
	
		$confirm_status['confirm_admission']='N';
        $confirm_status['confirm_date']='';
	    $wheresstatus=array("student_id"=>$_POST['stud_id']);
		$DB1->where($wheresstatus); 
		$DB1->update('student_confirm_status', $confirm_status);
		
		
		
		
   //////////////////////////////////////////////////////////////////////////////////////
   $emp_id = $this->session->userdata('name');
   $uId=$this->session->userdata('uid');
   $cancelled_admission['enrollment_no']=$_POST['prn'];
   $cancelled_admission['student_id']=$_POST['stud_id'];
   $cancelled_admission['deleted_by']=$emp_id;
   $cancelled_admission['remark']=$_POST['remark'];
   $cancelled_admission['date']=date('Y-m-d');
   
   $cancelled_admission['created_on']=date('Y-m-d h:i:s');
   $cancelled_admission['created_by']=$uId;
   
   $DB1->insert('cancelled_admission_new', $cancelled_admission);
    $this->session->set_flashdata('message1', 'Admission cancelled Successfully ');
	Redirect('ums_admission/cancelled_admission');
		}
	}
	
	
	public function reregistration_details($stud_id,$stau='')
    { //error_reporting(E_ALL);
//ini_set('display_errors', 1);

        if($_POST)
        {
        //   var_dump($_POST['acd_totalfee']); 
           // exit();
         
       $this->Ums_admission_model->reregistration_details($_POST); 
	//   exit();
         $msg5='student application updated  successfully..';
			 $this->session->set_flashdata('msg5', $msg5);
			  //  echo '<script>alert("PRN Number of '.$nam.' is '.$stud_reg_id.'");window.location.href = "stud_list";<script>';
			 $path= "http://erp.sandipuniversity.com/ums_admission/student_reregistration/";
			 echo '<script>alert("Student Registration successfully..");window.location.href = "'.$path.'";</script>';
        }
        else{
        $this->session->set_userdata('studId', $stud_id);
        $this->load->view('header',$this->data);  
        $this->data['states'] = $this->Ums_admission_model->fetch_states();
        $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
	
		$this->data['category']= $this->Ums_admission_model->getcategorylist();
		$this->data['religion']= $this->Ums_admission_model->getreligionlist();
	    $this->data['course_year']= $this->Ums_admission_model->getCourseYRClg($college_id);
	    $this->data['branches']= $this->Ums_admission_model->getbranch($college_id);
	    $stdata = $this->Ums_admission_model->fetch_personal_details($stud_id);
	   
        $this->data['emp_list']= $stdata;
        
       // $this->data['feedetj'] = $this->Ums_admission_model->fetch_academic_fees_for_stream_year($stdata[0]['admission_stream'],($stdata[0]['academic_year']+1),($stdata[0]['current_year']+1));
	   //if($stdata[0]['belongs_to']=='Package'){
		    $this->data['package'] = $this->Ums_admission_model->fetch_academic_fees_for_package_students($stdata[0]['admission_stream'],$stdata[0]['course_id'],$stdata[0]['admission_cycle'],($stdata[0]['academic_year']),$stud_id);
	   //}else{
        $this->data['feedetj'] = $this->Ums_admission_model->fetch_academic_fees_for_rereg($stdata[0]['admission_stream'],$stdata[0]['course_id'],$stdata[0]['admission_cycle'],($stdata[0]['academic_year']+1),$stdata[0]['admission_session']);
	   //}
        
          $loadd = $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');
	    $peradd = $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','PERMNT');
	    $parentadd = $this->Ums_admission_model->fetch_address_details($stud_id,'PARENT','PERMNT');
	    
	    
         $this->data['local_address']=$loadd;
          $this->data['perm_address']= $peradd;
           $this->data['parent_address']= $parentadd;
           $this->data['parent_details']= $this->Ums_admission_model->fetch_parent_details($stud_id);
            $this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id,$stdata[0]['academic_year']); 
          
			$this->data['total_fees_paid']=$this->Ums_admission_model->fetch_total_fee_paid($stud_id,$stdata[0]['academic_year']);
			$this->data['total_fees_refund']=$this->Ums_admission_model->fetch_total_fee_refund($stud_id,$stdata[0]['academic_year']);
			$this->data['canc_charges']=$this->Ums_admission_model->fetch_canc_charges($stud_id,$stdata[0]['academic_year']);
              
    
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
           $this->data['stau']=$stau;
        $this->load->view($this->view_dir.'reregistration_details',$this->data);
        $this->load->view('footer');
        }
    }
	
	
	
	
	
	
	
	
	public function De_reregistration_details($stud_id,$stau='')
    {

       
	
	//echo $stud_id;
	//exit();
	   $this->Ums_admission_model->De_reregistration_details($stud_id); 
        $msg5='De_reregistration  successfully..';
			 $this->session->set_flashdata('msg5', $msg5);
			  //  echo '<script>alert("PRN Number of '.$nam.' is '.$stud_reg_id.'");window.location.href = "stud_list";<script>';
			 $path= "https://erp.sandipuniversity.com/ums_admission/student_de_reregistration/";
			 echo '<script>alert("Student De-reregistration successfully..");window.location.href = "'.$path.'";</script>';
	
	
	
	
	
	}
	// edit student personal details
	
	
	public function edit_personalDetails($stud_id)
    {
    // error_reporting(E_ALL);
//ini_set('display_errors', 1);
    	$this->load->helper('date_helper');
    	//test();die;
		 
		//exit();
		if($this->session->userdata("role_id")==2 || $this->session->userdata("role_id")==59 || $this->session->userdata("role_id")==6 ){}else{
			redirect('home');
		}
        $this->session->set_userdata('studId', $stud_id);
        $this->load->view('header',$this->data);  
        $this->data['states'] = $this->Ums_admission_model->fetch_states();
		$this->data['kps'] = $this->Ums_admission_model->fetch_kps();
        $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
		$this->data['doc_list']= $this->Ums_admission_model->getdocumentlist();
		$this->data['category']= $this->Ums_admission_model->getcategorylist();
		$this->data['religion']= $this->Ums_admission_model->getreligionlist();
	    $this->data['course_year']= $this->Ums_admission_model->getCourseYRClg($college_id);
	    $this->data['branches']= $this->Ums_admission_model->getbranch($college_id);
	   
	   
	    $stdata = $this->Ums_admission_model->fetch_personal_details($stud_id);
	    $this->data['segment']= $stdata;
        $this->data['emp_list']=$stdata; //$this->Ums_admission_model->fetch_personal_details($stud_id);
		
         
		   
            $this->data['parent_details']= $this->Ums_admission_model->fetch_parent_details($stud_id);
            $this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id); 
          
	
        
            $this->data['coursedet']= $this->Ums_admission_model->fetch_stcouse_details1($stdata[0]['admission_stream']);
            $cde = $this->Ums_admission_model->fetch_stcouse_id($stdata[0]['admission_stream']);
            
            $this->data['stream']= $this->Ums_admission_model->fetch_stcouse_details_id($cde[0]['course_id']);

		
        $this->load->view($this->view_dir.'personal_details',$this->data);
        $this->load->view('footer');
    }
	
	
	
	public function edit_AddressDetails(){
		if($this->session->userdata("role_id")==2 ||  $this->session->userdata("role_id")==59 ||  $this->session->userdata("role_id")==6 ){
		}else{
			redirect('home');
		}
		$stud_id = $this->session->userdata('studId');
		 $this->load->view('header',$this->data);  
	//	$stdata = $this->Ums_admission_model->fetch_personal_details($stud_id);
	
	    $this->data['country'] = $this->Ums_admission_model->fetch_country();
		$this->data['states'] = $this->Ums_admission_model->fetch_states();
		//$this->data['district'] = $this->Ums_admission_model->fetch_district();
		//$this->data['city'] = $this->Ums_admission_model->fetch_taluka();
		$this->data['studentid'] = $stud_id ;
		
		
		$this->data['parent_details']= $this->Ums_admission_model->fetch_parent_details($stud_id);
		
		
		$address_details_all = $this->Ums_admission_model->fetch_address_details_all($stud_id);
		
		//print_r($address_details_all);
		//exit();
		
		foreach($address_details_all as $address){
				
			//address
			if(($address['adds_of']=="STUDENT")&&($address['address_type']=="CORS")){
			
				$this->data['local_address']=$address['address'];
			//	echo $address['address'];
			}
			if(($address['adds_of']=="STUDENT")&&($address['address_type']=="PERMNT")){
				$this->data['perm_address']=$address['address'];
			}
			if(($address['adds_of']=="PARENT")&&($address['address_type']=="PERMNT")){
				$this->data['parent_address']=$address['address'];
			}
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//city
			if(($address['adds_of']=="STUDENT")&&($address['address_type']=="CORS")){
				$this->data['localcity']=$address['city'];
			}
			if(($address['adds_of']=="STUDENT")&&($address['address_type']=="PERMNT")){
				$this->data['permcity']=$address['city'];
			}
			if(($address['adds_of']=="PARENT")&&($address['address_type']=="PERMNT")){
				$this->data['parentcity']=$address['city'];
			}
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
           //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		   //district
			if(($address['adds_of']=="STUDENT")&&($address['address_type']=="CORS")){
				$this->data['localdistrict']=$address['district_id'];
			}
			if(($address['adds_of']=="STUDENT")&&($address['address_type']=="PERMNT")){
				$this->data['permdistrict']=$address['district_id'];
			}
			if(($address['adds_of']=="PARENT")&&($address['address_type']=="PERMNT")){
				$this->data['parentdistrict']=$address['district_id'];
			}
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		   //State
			if(($address['adds_of']=="STUDENT")&&($address['address_type']=="CORS")){
				$this->data['localcountry']=$address['countryid'];
				$this->data['localstate']=$address['state_id'];
			}
			if(($address['adds_of']=="STUDENT")&&($address['address_type']=="PERMNT")){
				$this->data['permcountry']=$address['countryid'];
				$this->data['permstate']=$address['state_id'];
			}
			if(($address['adds_of']=="PARENT")&&($address['address_type']=="PERMNT")){
				$this->data['parentcountry']=$address['countryid'];
				$this->data['parentstate']=$address['state_id'];
			}
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			 //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		   //Pincode
			if(($address['adds_of']=="STUDENT")&&($address['address_type']=="CORS")){
				$this->data['localpincode']=$address['pincode'];
			}
			if(($address['adds_of']=="STUDENT")&&($address['address_type']=="PERMNT")){
				$this->data['permpincode']=$address['pincode'];
			}
			if(($address['adds_of']=="PARENT")&&($address['address_type']=="PERMNT")){
				$this->data['parentpincode']=$address['pincode'];
			}
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
	//	exit();
		//$loadd = $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');
	   // $peradd = $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','PERMNT');
	   // $parentadd = $this->Ums_admission_model->fetch_address_details($stud_id,'PARENT','PERMNT');
		
		//$this->data['local_address']=$loadd;// $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');
       // $this->data['perm_address']=$peradd;// $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','PERMNT');
        //$this->data['parent_address']= $parentadd;// $this->Ums_admission_model->fetch_address_details($stud_id,'PARENT','PERMNT');
		
		
	//	$this->data['localcity']= $this->Ums_admission_model->fetch_distcity_details('taluka_master','district_id',$loadd[0]['district_id']);
     //   $this->data['localdistrict']= $this->Ums_admission_model->fetch_distcity_details('district_name','state_id',$loadd[0]['state_id']);
			 
     //   $this->data['permcity']= $this->Ums_admission_model->fetch_distcity_details('taluka_master','district_id',$peradd[0]['district_id']);
      //  $this->data['permdistrict']= $this->Ums_admission_model->fetch_distcity_details('district_name','state_id',$peradd[0]['state_id']);
			 
      //  $this->data['parentcity']= $this->Ums_admission_model->fetch_distcity_details('taluka_master','district_id',$parentadd[0]['district_id']);
      //  $this->data['parentdistrict']= $this->Ums_admission_model->fetch_distcity_details('district_name','state_id',$parentadd[0]['state_id']);
		
		$this->load->view($this->view_dir.'address_details',$this->data);
        $this->load->view('footer');
	}
	// edit student edu details
	public function edit_eduDetails()
    {
		//var_dump($_SESSION);
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
		//$this->data['emp_list']=$emp_list;
	    $this->data['emp_documents']= $this->Ums_admission_model->fetch_qualification_details($stud_id,$emp_list);
       
		
        $this->load->view($this->view_dir.'certificates_and_docs',$this->data);
        $this->load->view('footer');
    }
	
	public function edit_docsndcertDetails_provisional()
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
	    
       // $this->data['emp_list']= $this->Ums_admission_model->fetch_personal_details($stud_id);
		
		//$this->data['emp_documents']= $this->Ums_admission_model->fetch_qualification_details($stud_id);
		
		
		$emp_list= $this->Ums_admission_model->fetch_personal_details($stud_id);
		$this->data['emp_list']=$emp_list;
	    $this->data['emp_documents']= $this->Ums_admission_model->fetch_qualification_new($stud_id,$emp_list);
		
        $this->load->view($this->view_dir.'certificates_and_docs_provisional',$this->data);
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
	     $this->data['is_concern']= $this->Ums_admission_model->get_referencedetails('is_concern_ins',$stud_id);
 //$this->data['consultants']= $this->Ums_admission_model->get_consultants_from_ic('2020-21');
 $this->data['consultants']= array();
	   $this->data['pmedia']= $this->Ums_admission_model->getpmedias(); 
        $this->data['emp_list']= $this->Ums_admission_model->fetch_personal_details($stud_id);
        $this->load->view($this->view_dir.'references',$this->data);
        $this->load->view('footer');
    }  
	// edit student payment details
	public function edit_paymentDetails()
    {
        $stud_id = $this->session->userdata('studId');
        $this->load->view('header',$this->data);  
        $this->data['get_feedetails']= $this->Ums_admission_model->get_feedetails($stud_id);
		$this->data['get_bankdetails']= $this->Ums_admission_model->get_bankdetails($stud_id);
		$this->data['emp_list']= $this->Ums_admission_model->fetch_personal_details($stud_id);
	 	$this->data['bank_details']= $this->Ums_admission_model->getbanks();
	 	$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id); 
		//$this->data['category']= $this->Ums_admission_model->getcategorylist();
		//$this->data['religion']= $this->Ums_admission_model->getreligionlist();
	   	//$this->data['course_year']= $this->Ums_admission_model->getCourseYRClg($college_id);
	 	//$this->data['branches']= $this->Ums_admission_model->getbranch($college_id);
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
		public function fetch_academic_fees_for_stream_year(){
	     
		$strm_id=$_REQUEST['strm_id'];
			$acyear=$_REQUEST['acyear'];
			$year=$_REQUEST['admission_type'];
		$fess =$this->Ums_admission_model->fetch_academic_fees_for_stream_year($strm_id,$acyear,$year);
		
		echo json_encode($fess);
	}    
	public function updateEducation()
    {   
	//var_dump($_SESSION);
	//exit(); 
	$stud_id = $this->session->userdata('studId');   
    
		if(!empty($_FILES['sss_doc']['name'])){
			$_FILES['sss_doc']['name']=$this->Ums_admission_model->rearrange1($_FILES['sss_doc']['name']);
			// $filesCount = count($_FILES['scandoc']['name']);
            //for($i = 0; $i < $filesCount; $i++){
				foreach($_FILES['sss_doc']['name'] as $key => $val){
                $_FILES['userFile']['name'] = $stud_id.'-'.$_FILES['sss_doc']['name'][$key];
                $_FILES['userFile']['type'] = $_FILES['sss_doc']['type'][$key];
                $_FILES['userFile']['tmp_name'] = $_FILES['sss_doc']['tmp_name'][$key];
                
                $uploadPath = 'uploads/student_document/';
                if ($_FILES && $_FILES['userFile']['name']) {
                	$lastDot = strrpos($_FILES['userFile']['name'], ".");
					$string = str_replace(".", "", substr($_FILES['userFile']['name'], 0, $lastDot)) . substr($_FILES['userFile']['name'], $lastDot);

		            $src_file = $_FILES['userFile']['tmp_name'];
		            $ext = explode('.', $string);
		            $file_name = time() .'-'. clean($ext[0]).'.'.$ext[1];
		            $student_year = getStudentYear($stud_id);

		            $file_path = $uploadPath. $student_year. '/'. $file_name;
		            $bucket_name = 'erp-asset';
		            $userFile= $file_name; 
		            try {
	                    $result = $this->awssdk->uploadFile($bucket_name, $file_path, $src_file);
	                    // Success message
	                    echo 'File uploaded successfully to S3!';
	                    $arr2[$key]= $file_name;
	                    /* $DB1 = $this->load->database('umsdb', TRUE);
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

	public function view_studentFormDetails($stud_id='')
    {
     /* strat-1*/
    

       if($this->session->userdata('role_id')==4 ||$this->session->userdata('role_id')==9){

      
         $id= $this->Ums_admission_model->get_student_id_by_prn($this->session->userdata('name'));

         $stud_id=$id['stud_id'];
        
       }
       else
       {
        $this->session->set_userdata('studId', $stud_id);
       }
       /* end-1:This loop is added by arvind for student login to view his own profile where stud_id variable is set from his login id.*/
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
	    $this->data['doc_list']= $this->Ums_admission_model->userdoc_list($stud_id);
		$this->data['parent_details']= $this->Ums_admission_model->fetch_parent_details($stud_id);
		$this->data['get_feedetails']= $this->Ums_admission_model->get_feedetails($stud_id);
		$this->data['get_examfeedetails']= $this->Ums_admission_model->get_examfeedetails($stud_id);
		$this->load->model('pdc_model');
		 $this->data['pdc_details']=$this->pdc_model->get_pdc_studentdetails($stud_id);  
		
		$this->data['get_refunds']= $this->Ums_admission_model->get_refundetails($stud_id);
		$this->data['tot_refunds']= $this->Ums_admission_model->get_tot_refunds($stud_id);
		$this->data['get_bankdetails']= $this->Ums_admission_model->get_bankdetails($stud_id);
		$this->data['bank_details']= $this->Ums_admission_model->getbanks();
	//	$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id);
		$this->data['admission_detail']= $this->Ums_admission_model->fetch_admission_details_all($stud_id,$acyear); 
		
		$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id,$acyear); 
	
		$this->data['totfeepaid']= $this->Ums_admission_model->fetch_total_fee_paid($stud_id);
		
		$this->data['stud_id']=$stud_id;
        $this->load->view($this->view_dir.'view_student_form_details',$this->data);
		$this->load->view('footer');
        //$this->load->view('footer');
    } 
	// view payment details of student
	public function viewPayments($stud_id,$acyear='')
    {
        $this->session->set_userdata('studId', $stud_id);
        $this->load->view('header',$this->data);       
        $this->data['emp']= $this->Ums_admission_model->fetch_personal_details($stud_id);
		$this->data['get_feedetails']= $this->Ums_admission_model->get_feedetails($stud_id,$acyear);
		$this->data['get_bankdetails']= $this->Ums_admission_model->get_bankdetails($stud_id);
		$this->data['bank_details']= $this->Ums_admission_model->getbanks();
		$this->data['admission_detail']= $this->Ums_admission_model->fetch_admission_details_all($stud_id,$acyear); 
		
		$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id,$acyear); 
		$this->data['installment']= $this->Ums_admission_model->fetch_installment_details($stud_id);
			$this->data['canc_charges']= $this->Ums_admission_model->fetch_canc_charges($stud_id);
		//	var_dump($this->Ums_admission_model->fetch_canc_charges($stud_id));
			$this->data['get_refunds']= $this->Ums_admission_model->get_refundetails($stud_id);
			$this->data['tot_refunds']= $this->Ums_admission_model->get_tot_refunds($stud_id);
			
		$this->data['noofinst']= $this->Ums_admission_model->fetch_no_of_installment($stud_id);
		$this->data['minbalance']= $this->Ums_admission_model->fetch_last_balance($stud_id);
		$this->data['totfeepaid']= $this->Ums_admission_model->fetch_total_fee_paid($stud_id);
			$this->data['acye']=$acyear; 
		
        $this->load->view($this->view_dir.'view_payment_details',$this->data);
		$this->load->view('footer');
        //$this->load->view('footer');
    } 
    
    
    
    
    public function viewPayment_det($stud_id,$acyear='')
    {
        $this->session->set_userdata('studId', $stud_id);
        $this->load->view('header',$this->data);       
        $this->data['emp']= $this->Ums_admission_model->fetch_personal_details($stud_id);
		$this->data['get_feedetails']= $this->Ums_admission_model->get_feedetails($stud_id,$acyear);
		$this->data['get_bankdetails']= $this->Ums_admission_model->get_bankdetails($stud_id);
		$this->data['bank_details']= $this->Ums_admission_model->getbanks();
			$this->data['admission_detail']= $this->Ums_admission_model->fetch_admission_details_all($stud_id,$acyear); 
		
		$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id,$acyear); 
		$this->data['installment']= $this->Ums_admission_model->fetch_installment_details($stud_id);
			$this->data['canc_charges']= $this->Ums_admission_model->fetch_canc_charges($stud_id);
		//	var_dump($this->Ums_admission_model->fetch_canc_charges($stud_id));
			$this->data['get_refunds']= $this->Ums_admission_model->get_refundetails($stud_id);
			$this->data['tot_refunds']= $this->Ums_admission_model->get_tot_refunds($stud_id);
			
		$this->data['noofinst']= $this->Ums_admission_model->fetch_no_of_installment($stud_id);
		$this->data['minbalance']= $this->Ums_admission_model->fetch_last_balance($stud_id);
		$this->data['totfeepaid']= $this->Ums_admission_model->fetch_total_fee_paid($stud_id);
			$this->data['acye']=$acyear; 
		
        $this->load->view($this->view_dir.'student_payment_details',$this->data);
		$this->load->view('footer');
        //$this->load->view('footer');
    } 
    
    
    
    

function cancel_stud_adm()
{
	
	
    $this->Ums_admission_model->cancel_stud_admission();
}


public function edit_fdetails()
{
    $stud_id =$_POST['feeid'];
    
    // $this->data['emp']= $this->Ums_admission_model->fetch_personal_details($stud_id);
	//	$this->data['get_feedetails']= $this->Ums_admission_model->get_feedetails($stud_id);
	//	$this->data['get_bankdetails']= $this->Ums_admission_model->get_bankdetails($stud_id);
		$this->data['bank_details']= $this->Ums_admission_model->getbanks();
			$this->data['indet']= $this->Ums_admission_model->get_inst_details($stud_id);
//$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id); 
	//	$this->data['installment']= $this->Ums_admission_model->fetch_installment_details($stud_id);
		
	//	$this->data['noofinst']= $this->Ums_admission_model->fetch_no_of_installment($stud_id);
	//	$this->data['minbalance']= $this->Ums_admission_model->fetch_last_balance($stud_id);
	//	$this->data['totfeepaid']= $this->Ums_admission_model->fetch_total_fee_paid($stud_id);
       $this->load->view($this->view_dir.'edit_fee',$this->data);
}


    // insert Payment installment
	public function pay_Installment($stud_id='')
    {
		//print_r($_FILES);exit;
        $stud_id= $_POST['stud_id'];
		$no_of_installment =1+$_POST['no_of_installment'];
		if(!empty($_FILES['payfile']['name'])){
			$filenm=$stud_id.'-'.$no_of_installment.'-'.$_FILES['payfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
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
        if($_POST['acye']!='')
        {
                    redirect('ums_admission/viewPayments/'.$stud_id.'/'.$_POST['acye']);
        }
        else
        {
        redirect('ums_admission/viewPayments/'.$stud_id);
        }
    }	
	
	
	
public function pay_refund()
{
    $stud_id= $_POST['stud_id'];
		$no_of_installment =1+$_POST['no_of_installment'];
		if(!empty($_FILES['payfile']['name'])){
			$filenm=$stud_id.'-'.rand().'-'.$_FILES['payfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|bmp|pdf';
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
        $this->data['emp']= $this->Ums_admission_model->pay_refund($_POST,$payfile);
      //  redirect('ums_admission/fees_refund/');
}
	
	
	public function update_inst($stud_id='')
    {
		//print_r($_FILES);exit;
		date_default_timezone_set('Asia/Kolkata');
        $stud_id= $_POST['sid'];
	//	$no_of_installment =1+$_POST['no_of_installment'];
		if(!empty($_FILES['epayfile']['name'])){
			$filenm=$stud_id.'-'.time().'-'.$_FILES['epayfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('epayfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
        $this->data['emp']= $this->Ums_admission_model->update_fee_det($_POST,$payfile );
        redirect('ums_admission/viewPayments/'.$stud_id);
    }	
	
/*For creating Student and Parent Login-By Arvind*/
	public function load_login_list()
	{
	   $data['slist'] = $this->Ums_admission_model->login_details($_POST);
	  $html =  $this->load->view($this->view_dir.'load_login_data',	$data);
	  echo $html;
	}
	public function login_list()
	{
	    $this->load->model('Subject_model');
	    $this->load->view('header',$this->data);    
      	$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
      	if($_POST['course_id'] !=''){
			$course_id = $_POST['course_id'];
			$stream_id = $_POST['stream_id'];
			$sem = $_POST['year'];
			$this->data['courseId'] = $_POST['course_id'];
			$this->data['streamId'] = $_POST['stream_id'];
			$this->data['semesterNo'] = $_POST['year'];
			
		//	$this->data['sud_list']=$this->Ums_admission_model->get_subject_details($sub_id='',$course_id,$stream_id,$sem);       	                                        
		}
        $this->load->view($this->view_dir.'login_list',	$this->data);
        $this->load->view('footer');
	    
	}
//for scholorship admission list
	 public function scholorship_list()
    {
        
         //$data['academic_year']="2017";
		// $data['academic_year']=$this->config->item('cyear');
		$this->data['years']= $this->Ums_admission_model->all_academic_session_for_scholorship_list();
		// print_r($this->data['years']);exit;

		// Capture the selected academic year from the POST request
		$selected_year = $this->input->post('academic_year');
		$this->data['selected_year'] = $selected_year;  // Pass it to the view
		
		// Load views and pass data
		$this->load->view('header', $this->data);
		$this->data['emp_list'] = $this->Admission_model->get_scholorship_list(['academic_year' => $selected_year]);
		$this->load->view($this->view_dir.'scholorship_list', $this->data);
		$this->load->view('footer');
    }

     // update payment details
    public function updateAdmPayment()
   	{
   	    
   	    $stud_id= $_POST['student_id'];	
   	    $acad_year =$_POST['acad_year']; 
   	    	  	
    	$data['opening_balance'] =$_POST['fopening_balance'];    
    		
    	$data['modified_by']=$_SESSION['uid'];
		$data['modified_on']=date("Y-m-d H:i:s");
		$data['modify_from_ip']=$_SERVER['REMOTE_ADDR'];
		//print_r($data);exit;
		$this->data['indet']= $this->Ums_admission_model->updateAdmPayment($stud_id,$acad_year, $data);

       $this->session->set_flashdata('message1','Fee Details Updated Successfully!!.');
		redirect(base_url("Ums_admission/viewPayments/".$stud_id));
	}  
	// added by bala	
	public function load_courses_for_studentlist()
	{    
	   $course_details =  $this->Ums_admission_model->load_courses_for_studentlist($_POST['academic_year']);  
	   $opt ='<option value="">Select Course</option>';
	   foreach ($course_details as $course) {

			$opt .= '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
		}
			echo $opt;
	}
	public function load_years_for_studentlist()
	{	    
	   $year_details =  $this->Ums_admission_model->load_years_for_studentlist($_POST['academic_year'],$_POST['admission_stream']); 
	 
	   $opt ='<option value="">Select Year</option>';
	   foreach ($year_details as $yr) {

			$opt .= '<option value="' . $yr['admission_year'] . '"' . $sel . '>' . $yr['admission_year'] . '</option>';
		}
			echo $opt;
	}	
	public function load_streams_student_list()
	{    
		$stream_details= $this->Ums_admission_model->load_streams_student_list($_POST);
		$opt ='<option value="">Select Stream</option><option value="0">ALL</option>';
	   foreach ($stream_details as $str) {
            
			 if ($str['stream_id'] == $_POST['stream']) {
                                                $sel = "selected";
                                            } else {
                                                $sel = '';
                                            }
			$opt .= '<option value="' . $str['stream_id'] . '"' . $sel . '>' . $str['stream_name'] . '</option>';
		}
		echo $opt;		
	}
	public function detain_student(){    
		$student_id = $_POST['stud_id'];
		$detain = $_POST['detain'];
		if($this->Ums_admission_model->detain_student($student_id,$detain)){
			$this->Ums_admission_model->insert_detain_student($_POST);
			echo "Y";
		}else{							
			echo "N";
		}

	}
	public function change_stream($student_id=''){
		
		//error_reporting(E_ALL);
		$this->load->view('header',$this->data); 
		$data['prn']=$student_id;
		$this->data['stud_details']= $this->Ums_admission_model->studentforchange_stream($data);
		$course_id = $this->data['stud_details'][0]['course_id'];
		$min_que = $this->data['stud_details'][0]['min_que'];
		$this->data['streams']= $this->Ums_admission_model->school_streams($course_id,$min_que);
		$this->load->view($this->view_dir.'change_stream_view',$this->data);
		$this->load->view('footer');
	 }	
	 public function insert_to_changeStream(){
		//error_reporting(E_ALL);
		if(!empty($_POST)){			
			$update= $this->Ums_admission_model->insert_to_changeStream($_POST);
		}
		$stud_id = $_POST['stud_id'];
		$this->session->set_flashdata('message1','Stream Changed Successfully!!.');
		redirect('ums_admission/change_stream/'.$stud_id);
	 }
	public function update_stream(){
		//error_reporting(E_ALL);
		$temp_id =$_POST['temp_id'];
		$stud_id='';
		if(!empty($temp_id)){
			$tempid= $this->Ums_admission_model->get_stream_temp_details($temp_id);
			if(!empty($tempid)){
				$var['admission_stream'] = $tempid[0]['change_to_stream'];
				$var['stud_id'] = $tempid[0]['stud_id'];
				$var['academic_year'] = $tempid[0]['academic_year'];
				$var['current_year'] = $tempid[0]['current_year'];
				$var['previous_stream'] = $tempid[0]['previous_stream'];
				$var['admission_year'] = $tempid[0]['admission_session'];
				$stud_id = $var['stud_id'];
				//$update= $this->Ums_admission_model->Update_prn($var);$var['academic_year']
				$update= $this->Ums_admission_model->update_stream_adm_details($var);
				$update1= $this->Ums_admission_model->update_stream_stud_master($var);
				if($update1){
				if(($tempid[0]['admission_session']==$tempid[0]['academic_year'])&&(($tempid[0]['current_year']==1)||($tempid[0]['current_year']==2))){
				//$tempid1= $this->Ums_admission_model->get_stream_temp_details($temp_id);
				//echo 1;
				 
			//	 $updatee= $this->Ums_admission_model->Update_prn($var);	  // PRN UPDATE STOP
			
			
			
				/////////////////////////////////////////////////////////////////
				
				
				/////////////////////////////////////////////////////////////////// 
				 
				 
				// echo 'fffffffff';exit();
				  
				}
				}
				//echo 'jjjjjjj';exit();
				$update2=$this->Ums_admission_model->update_temp_stream_status($temp_id);
				//$update3=$this->Ums_admission_model->update_icerp_student_meet_details_provisional_adm_details($tempid[0]['stud_id'],$tempid[0]['change_to_stream']);

				$update3=$this->Ums_admission_model->change_status_of_student_batchallocation_and_applied_subjects($tempid[0]['stud_id'],$tempid[0]['previous_stream'],$tempid[0]['current_semester'],$tempid[0]['change_to_stream'],$tempid[0]['academic_year']);
							
			}else{
				echo "N";
			}
		}
		echo "Y";
		//echo 'updated...';exit .'ums_admission/change_stream/'.$stud_id;
		redirect(base_url());
		//
		
	 }	
	function detaintion_list(){
		$role_id =$_SESSION['role_id'];
	   // $this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
	    $this->load->model('Subject_model');
		$this->load->model('Exam_timetable_model');
		$this->data['schools']= $this->Exam_timetable_model->getSchools();
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);
		$this->data['academic_year']= $this->Subject_model->getAcademicYear();
		if($role_id==15){
			$this->data['ex_ses']= $this->Ums_admission_model->exam_detention_sessions();
		}else{
			$this->data['ex_ses']= $this->Exam_timetable_model->fetch_curr_exam_session();
			
		}
	    if(!empty($_POST['academicyear'])){
	    if(!empty($_POST['stream_id'])){
			$stream_id = $_POST['stream_id'];
			$this->data['streamId'] = $_POST['stream_id'];
		}else{
			$stream_id = "";
			$this->data['streamId'] = '';
		}
	    $academicyear = $_POST['academicyear'];
		$exam_session = $_POST['exam_session'];
		$school = $_POST['school_code'];
	    $this->data['detaintion_list']= $this->Ums_admission_model->get_detaintion_list($academicyear, $exam_session,$school, $stream_id);
	    }
        $this->load->view('header',$this->data);
        $this->load->view($this->view_dir.'detaintion_list',$this->data);
        $this->load->view('footer',$this->data);
        //ob_end_clean();
	}	
	function detaintion_list_pdf($academicyear, $exam_session,$school,$stream_id){
	    //echo $exam_sessio;
		$this->data['academicyear']=$academicyear;
		$examses=explode('~',$exam_session);
		$this->data['examses']=$examses[0].'-'.$examses[1];
		//$this->data['school_name']= $this->Ums_admission_model->get_school_name($school);
	    $this->data['detaintion_list']= $this->Ums_admission_model->get_detaintion_list($academicyear, $exam_session,$school,$stream_id);
        $school_dean = $this->data['detaintion_list'][0]['school_dean'];
		$this->load->library('m_pdf');
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '5', '15');
			$html = $this->load->view('Admission/detaintion_list_pdf', $this->data, true);
			$pdfFilePath = $academicyear."_Detention_List.pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML($html);
			$regstr = REGISTRAR;
			$dean_acdmic= DEANACADEMIC;
			$footer ='<table cellpadding="0" cellspacing="0" border="0" width="800" style="margin-bottom:15px;">
			<tr>
				<td align="left" colspan="2"><b>Note: </b> Above details are Verified by <br><br></td>
				
			</tr>
			<tr>
				<td align="left" colspan="2">&nbsp;</td>
				
			</tr>
			<tr>
				<td align="left" width="70%"><b>HOD/Dean </b><br><br><span style="font-size:11px;">Name: <br><br>Signature:</span><br><br><br><br></td>
		
				<td align="left"  width="30%"><b>Controller of Examination</b><br><br><span style="font-size:11px;">Name: <br><br>Signature:</span><br><br><br></td>
				
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
	}	
	function stream_change_list(){
	   // $this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
	    $this->load->model('Subject_model');
		$this->data['academic_year']= $this->Subject_model->getAcademicYear();
	    if(!empty($_POST['academicyear'])){
	        
	    $academicyear = $_POST['academicyear'];
	    $this->data['stchange_list']= $this->Ums_admission_model->get_streamchange_list($academicyear);
	    }
        $this->load->view('header',$this->data);
        $this->load->view($this->view_dir.'stream_change_list',$this->data);
        $this->load->view('footer',$this->data);
        //ob_end_clean();
	}	
//
    function list_todaysadmissions()
    {        
		$this->load->view('header', $this->data);
		$this->data['stud_data']	=  $this->Ums_admission_model->list_todaysadmissions();
        $this->load->view($this->view_dir . 'todays_adm_student_list', $this->data);
     	$this->load->view('footer');           
    }	
	public function update_prnn()
	{
	    // error_reporting(E_ALL);//ini_set('display_errors', 1);
		//$upstatus = $this->Ums_admission_model->update_prn_2018();
		//$prn = $this->Ums_admission_model->create_student_login();
		//$this->Ums_admission_model->send_stlogin_2018();

	}	  
	
	
		function mock_result_pdf()
	{
	    
	  //  error_reporting(E_ALL);
	   // ini_set('display_errors', 1);

$data['emp_list']= $this->Ums_admission_model->get_mock_result();

	     $pdfFilePath = "StudentList-". $filename.".pdf";

$html = $this->load->view($this->view_dir.'mock_pdf',$data,true);

$param = '"en-GB-x","A4","","",20,20,20,20,10,10,P';
        $this->load->library('m_pdf',$param);

       $this->m_pdf->pdf->WriteHTML($html);

        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
 $pdfFilePath = "output_pdf_name.pdf";     
	    
	
	    
	}
	
public function update_adm_details(){
		//error_reporting(E_ALL);	
		$tempid= $this->Ums_admission_model->update_admission_details_for_2018();
		echo "success";
	 }
	 //public function update_taluka()
	// {
	// 	$st = $this->Ums_admission_model->update_taluka_states();
	// }
	public function send_sms_all_students()
	{
		//error_reporting(E_ALL);//ini_set('display_errors', 1);
		$res = $this->Ums_admission_model->send_allstudlogin();
		echo $res;
	}
	
	public function test_api(){
	$username = urlencode("u4282");
$msg_token = urlencode("j8eAyq");
$sender_id = urlencode("SANDIP"); // optional (compulsory in transactional sms)
$message = urlencode("tet");
$mobile = urlencode("9960006338");
//send_transactional_sms//send_enterprise_sms
$api = "http://bulksms.omegatelesolutions.com/api/send_transactional_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile."";

$response = file_get_contents($api);

echo $response;
}
	public function send_sms_all_students_phd()
	{
		//error_reporting(E_ALL);//ini_set('display_errors', 1);
		exit(); 
		$res = $this->Ums_admission_model->send_allstudlogin_phd();
		echo $res;
	}

	    public function Phd_admission_form()
	    {
	        
	        $this->load->view('header',$this->data);     
	        $this->data['states'] = $this->Ums_admission_model->fetch_states();
	        $campus_id=$this->uri->segment(3);
		//$college_id = $this->session->college_id;
		//$up_stud_id=$_REQUEST['s'];
		//echo $stud_id;
		    $college_id = 1;
	      //  $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
	      
	     //  $academic_year='2016-17';
			$academic_year='2019-20';
		    
		    	$this->data['school_list']= $this->Ums_admission_model->list_schools();
		    $this->data['course_details'] = $this->Ums_admission_model->getcourse_yearwise($academic_year);
			$this->data['doc_list']= $this->Ums_admission_model->getdocumentlist();
			$this->data['category']= $this->Ums_admission_model->getcategorylist();
			$this->data['religion']= $this->Ums_admission_model->getreligionlist();
		$this->data['course_year']= $this->Ums_admission_model->getCourseYRClg($college_id);
		$this->data['branches']= $this->Ums_admission_model->getbranch($college_id);
		$this->data['exam_list']= $this->Ums_admission_model->entrance_exam_master();
		$this->data['bank_details']= $this->Ums_admission_model->getbanks();
			$this->data['pmedia']= $this->Ums_admission_model->getpmedias();
		
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
		    $this->load->view($this->view_dir.'php_admission',$this->data);
	        $this->load->view('footer');
	    }

	    function ums_phdadmission_submit()
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
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx|pdf';
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
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx|pdf';
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
	     
	    
	      $stud_reg_id=$this->Ums_admission_model->student_phdregistration_ums($_POST,$arr1,$arr2);
	     
	     //exit();
	     $nam = $_POST['slname']."".$_POST['sfname']."".$_POST['smname'];
	     
	      echo '<script>alert("PRN Number of '.$nam.' is '.$stud_reg_id.'");window.location.href = "stud_list";</script>';
	      // redirect('orderManagement/index', 'refresh');
	      
	     redirect('ums_admission/stud_list','refresh');
	 
	 }	



    public function reregistrationdetails()
    {
    	//ini_set('display_errors', 1);
      $data= $this->Ums_admission_model->getStudentsdata(); 
     /* echo "<pre>";
      print_r($data);
        echo "</pre>";
      die;*/
      

      foreach ($data as $key => $value) {

      		$academic_year=$value['academic_year'];
      	    //echo '<br>';
      	    $student_id=$value['stud_id'];//echo '<br>';
        	 $current_year=$value['current_year']; //echo '<br>';
        	 //get current data of student from admission_details
        	$admission_details = $this->Ums_admission_model->fetch_maxadmission_details($student_id,$academic_year);
        	//get course duration for studnet stream
        	$getstreamcourseduration= $this->Ums_admission_model->getstreamcourseduration($value['admission_stream']);

      	if($getstreamcourseduration[0]['course_duration']>$current_year) //4>1
      	{

  			$student_id=$value['stud_id'];
  			//echo    $getstreamcourseduration[0]['course_duration']; echo '<br>';
            //echo 	$current_year; echo '<br>';
  		    echo    $student_id; echo '<br>';
  		    echo $i;echo '<br>new';
      		//$current_year=$value['current_year'];
      		//$aa=$value['stud_id'];
      	
       			//fetch current academic year fees from academic fees table 
   			$feedetj = $this->Ums_admission_model->fetch_academic_fees_for_reregistration($value['admission_stream'],($value['academic_year']+1),$value['admission_session']);
   		
   			if(!empty($feedetj))
   			{
   				$DB1 = $this->load->database('umsdb', TRUE);
   				$academic_year=$value['academic_year'];
	      		$temp['academic_year']=$value['academic_year']+1;
	       		$temp['current_year']=$value['current_year']+1;
	        	$temp['current_semester']=$value['current_semester']+1;
				$temp['modified_on']= date('Y-m-d H:i:s');
				$temp['modified_by']= $_SESSION['uid'];
				//update data in student master

				$DB1->where('stud_id', $value['stud_id']);
				$DB1->update('student_master',$temp);
				//end of update

				//add log data for student_master
				$logstudent['student_id']=$value['stud_id'];
				$logstudent['enrollment_no']=$value['enrollment_no'];
				$logstudent['academic_year']=$value['academic_year'];
	       		$logstudent['current_year']=$value['current_year'];
	        	$logstudent['current_semester']=$value['current_semester'];
				$logstudent['to_academic_year']=$value['academic_year']+1;
	       		$logstudent['to_current_year']=$value['current_year']+1;
	        	$logstudent['to_current_semester']=$value['current_semester']+1;
				$logstudent['modified_on']= date('Y-m-d H:i:s');
				$logstudent['modified_by']= $_SESSION['uid'];
				$DB1->insert('student_master_logs_2019',$logstudent);
				//end of the student logs


				$admdetails['academic_year']=$academic_year+1;
	      		$neacyearj=$academic_year+1;
	   			$admdetails['year']=$current_year+1;
   				$admdetails['actual_fee']=$feedetj[0]['total_fees'];
   				$admdetails['applicable_fee']=$feedetj[0]['total_fees'];
   				$canc_chargee=$this->Ums_admission_model->fetch_canc_charges($student_id,$academic_year);
   				//print_r($canc_chargee);
   				
	   			$total_fees_paid=$this->Ums_admission_model->fetch_total_fee_paid($student_id,$academic_year);
	   			/*	print_r($total_fees_paid);
	   				echo "</br/>";
	   				echo "applicable".$admission_details[0]['applicable_fee'];
	   				echo "</br/>";
	   				echo "cancel".$canc_chargee['canc_amount'];
	   				echo "</br/>";
	   				echo "openni". $admission_details[0]['opening_balance'];
	   				echo "</br/>";
	   				echo $total_fees_paid[0]['tot_fee_paid'];
	   				echo "</br/>";*/
   				
	   			$opbal = $admission_details[0]['applicable_fee']+$canc_charges['canc_charges'] + $admission_details[0]['opening_balance']- $total_fees_paid[0]['tot_fee_paid'];
	   		
	   			
	   			$admdetails['opening_balance']=$opbal;
	   			$admdetails['student_id'] = $value['stud_id'];

	  			$admdetails['hostel_required']=$admission_details[0]['hostel_required'];
	       	   	$admdetails['hostel_type']=$admission_details[0]['hostel_type'];

	       	    $admdetails['transport_required']=$admission_details[0]['transport_required'];
	   	     	$admdetails['transport_boarding_point']=$admission_details[0]['transport_boarding_point'];

	   	     	$admdetails['created_on']= date('Y-m-d H:i:s');
		      	$admdetails['created_by']= $_SESSION['uid'];
		      	$admdetails['form_number']='7102019';

		      	$admdetails['enrollment_no']=$value['enrollment_no'];
		      	$admdetails['school_code']=$value['admission_school'];
		      	$admdetails['stream_id']=$value['admission_stream'];;
		      	$admdetails['entry_from_ip']= $_SERVER['REMOTE_ADDR'];

		      	$dup = $this->Ums_admission_model->fetch_admission_details($student_id,$neacyearj);
		      
		      	if($dup[0]['student_id']=='')
			    {
			 	  $DB1->insert('admission_details',$admdetails);
			    }
   			}
   			
		    
      	}//end of if($courseduration>$current_year)
      		
      	
      	
      	
      }//end of for loop
      //print_r($aa);
   	}//end of function
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function Reported(){
		$enrollment_no = $this->input->post('enrollment_no');
		$academic_year = $this->input->post('academic_year');
		$stud_id = $this->input->post('stud_id');
		$no_yes = $this->input->post('no_yes');
		$data = $this->Ums_admission_model->Reported($enrollment_no,$academic_year,$stud_id,$no_yes);
		if($data) {
			header("Location:view_studentFormDetails/".$stud_id);
		}
	}
	
	public function reregistration_student_list(){
		//error_reporting(E_ALL);
		$this->load->view('header',$this->data);        
		$this->data['school_list']= $this->Ums_admission_model->list_schools();
        $this->load->view($this->view_dir.'reregistration_student_list_2019',$this->data);
        $this->load->view('footer');
	}
	public function load_re_registration_studentlist(){
		//echo "sss";
		//die;
		//print_r($_POST); exit;
		 //error_reporting(E_ALL);
	      $data['stud_list']= $this->Ums_admission_model->get_registation_Studentsajax($_POST['reported'],$_POST['ayear'],$_POST['fees_paid'],$_POST['admission_school']);
	       $data['reported']= $_POST['reported'];
	        $data['ayear']= $_POST['ayear'];
	       $data['fees_paid']= $_POST['fees_paid'];
	       $data['admission_school']= $_POST['admission_school'];
	       
	  //print_r($data['stud_list']);exit;
	   $html = $this->load->view($this->view_dir.'load_reregistration_studentdata',$data,true);
	   echo $html;
	}


function search_cancaldatafor_restar()
{
 
	  
	   $this->load->view('header',$this->data);        
		$this->data['emp_list']= $this->Ums_admission_model->searchforcancellation_registardata();
		/*print_r($this->data['emp_list']);
		die;*/
		$this->data['bank_details']= $this->Ums_admission_model->getbanks();
         $this->load->view($this->view_dir.'cancellation_request_lists',$this->data);
        $this->load->view('footer');
}

function cancel_stud_adm_request($studid,$prn,$acyear='')
{
	 /*ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);*/
          
    $this->Ums_admission_model->cancel_stud_admission_request($studid,$prn,$acyear);

     redirect(base_url("ums_admission/search_cancaldatafor_restar"));
}
public function load_batch_student_list()
{    
	$stream_details= $this->Ums_admission_model->load_batch_student_list($_POST);
	$opt ='<option value="">Select Batch</option>';
	$opt .='<option value="0">ALL</option>';
   foreach ($stream_details as $str) {

		$opt .= '<option value="' . $str['admission_cycle'] . '">' . $str['admission_cycle'] . '</option>';
	}
	echo $opt;		
}

function check_mobile(){
	//echo $this->Ums_admission_model->check_mobile(9960006338,'test');
	$mobile='9960006338';
	$sms-='test';
	$username = urlencode("u4282");
$msg_token = urlencode("j8eAyq");
$sender_id = urlencode("SANDIP"); // optional (compulsory in transactional sms)
$message = urlencode($sms);
$mobile = urlencode($mobile);

$api = "http://bulksms.omegatelesolutions.com/api/send_transactional_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile."";

$response = file_get_contents($api);

echo $response;
}


public function update_scholarship($stream='',$year='')
    {
		
		$this->load->view('header',$this->data); 
		$this->load->view($this->view_dir.'search_new',$this->data);
		$this->load->view('footer');

    }
	
	
		public function update_studentname($stud_id)
    {
     /* strat-1*/
    

       if($this->session->userdata('role_id')==4 ||$this->session->userdata('role_id')==9){

      
         $id= $this->Ums_admission_model->get_student_id_by_prn($this->session->userdata('name'));

         $stud_id=$id['stud_id'];
        
       }
       else
       {
        $this->session->set_userdata('studId', $stud_id);
       }
       /* end-1:This loop is added by arvind for student login to view his own profile where stud_id variable is set from his login id.*/
        $this->load->view('header',$this->data);     
  
        $this->data['emp']= $this->Ums_admission_model->fetch_personal_details($stud_id);
	//	$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id);
		$this->data['admission_detail']= $this->Ums_admission_model->fetch_admission_details_all($stud_id,$acyear); 
		
		$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id,$acyear); 
	
		$this->data['stud_id']=$stud_id;
        $this->load->view($this->view_dir.'update_student_form_details',$this->data);
		$this->load->view('footer');
        //$this->load->view('footer');
    }
	
	
	public function update_marathiname()
    { //error_reporting(E_ALL);
		//print_r($_POST); die;
       $this->Ums_admission_model->update_marathiname($_POST);
        if($_POST['marathi_name']!=''){	   
        $msg5='student Marathi Name updated  successfully..';
		}
		else
		{
	    $msg5='Guardian Details updated successfully..';
		}
			 $this->session->set_flashdata('msg5', $msg5);
		redirect('ums_admission/update_studentname'.'/'.$_POST['student_code']);
    }
	
	
    function allow_student_for_password($prn){
		$DB1 = $this->load->database('umsdb', TRUE);
		$check_duplicate_student= $this->Ums_admission_model->check_student_for_pass($prn);
							
		if($check_duplicate_student==0)
		{

			//echo 1; exit;
			$arr_insert =array(
			'username'=>$prn,
			'password'=>rand(4999,999999),
			'roles_id'=>4,
			"inserted_by" => $this->session->userdata("uid"),
			"inserted_datetime	" => date("Y-m-d H:i:s")
			);
			//echo "<pre>";print_r($arr_insert);  
			$DB1->insert("user_master", $arr_insert);
			 // echo $DB1->last_query();exit; 

			 $arr_insert =array(
			'username'=>$prn,
			'password'=>rand(4999,999999),
			'roles_id'=>9,
			"inserted_by" => $this->session->userdata("uid"),
			"inserted_datetime	" => date("Y-m-d H:i:s")
			);
			//echo "<pre>";print_r($arr_insert);  
			$DB1->insert("user_master", $arr_insert); 
		}else{
            
        //update data in user master
				$DB1 = $this->load->database('umsdb', TRUE);
				$data['password']=rand(4999,999999);
				$DB1->where('username', $prn);
				$DB1->where('roles_id', 4);
				$DB1->update('user_master',$data);

			//echo 2; exit;



		}
		redirect('/ums_admission/search');
	}
	
	function renamecode(){
		
		
		$old=$student_data['enrollment_no_new'];
		$new=$student_data['enrollment_no'];
        rename("uploads/student_photo/$old.jpg","uploads/student_photo/$new.jpg");
		
		//echo "dd";
	}
	// admission De-cancellation code 
	 function get_student_details($stud_id)
	 {
	  $DB1 = $this->load->database('umsdb', TRUE);
	  $DB1->select("*");
	  $DB1->from('student_master');
	  $DB1->where("stud_id", $stud_id);;
	  $query=$DB1->get();
	  $data=$query->result_array();
       echo json_encode($data);
	 }
	 
	 function student_decancel()
	 {
		 $stud_id=$_POST['stud_id'];
		 $remark=$_POST['remark'];
		 
	   $DB1 = $this->load->database('umsdb', TRUE); 
	  	$stud_mast['cancelled_admission']='N';
	  	$adm_det['cancelled_admission']='N';
	  	$adm_canlns=array(
		    'decanc_remark'=>$remark,
		    'status'=>'N',		
		    'modified_by'=>$_SESSION['uid'],		
		    'modified_on'=>date('Y-m-d H:i:s'),		
		   );
		
        	$adm_dets['status']='N';
			$adm_dets['modified_on']=$_SESSION['uid'];
			$adm_dets['modified_by']=date('Y-m-d H:i:s');
		
	    $DB1->where('stud_id', $stud_id);
	    $DB1->update('student_master',$stud_mast);
		
		$DB1->where('student_id', $stud_id);
	    $DB1->update('admission_details',$adm_det);
		
		$DB1->where('student_id', $stud_id);
	    $DB1->update('students_adm_cancel_lists',$adm_dets);
		
		$DB1->where('stud_id', $stud_id);
	    $DB1->update('admission_cancellations',$adm_canlns);
		$data=$DB1->affected_rows(); 	
	  echo json_encode($data);
	 }
	public function convertToMarathi($text) {
    // URL to Google Transliteration API
    $url = "https://inputtools.google.com/request?text=" . urlencode($text) . "&itc=mr-t-i0-und&num=1&cp=0&cs=1&ie=utf-8&oe=utf-8";

    // Send a GET request to the API
    $response = file_get_contents($url);

    // Decode the JSON response
    $data = json_decode($response, true);

    // Extract the transliterated text from the response
    if(isset($data[1][0][1][0])) {
        return $data[1][0][1][0];
    } else {
        // If transliteration fails, return original text
        return $text;
    }
}
	 
	 public function fetch_marathi_fullname()
	 {
		 $fname=$this->input->post('fname');
		 $transliteratedText = $this->convertToMarathi($fname);
         echo $transliteratedText;
	 }	


	/*
	* Cancel Admission Request Refund Module start,
	* Added BY:: Amit Dubey
	*/
	
	public function student_refund_request_list()
	{
		$this->data['studentRefundRequestList'] = $this->Ums_admission_model->getStudentRefundRequestList($_SESSION['name']);
		$this->load->view('header', $this->data);
		$this->load->view($this->view_dir . 'student_refund_request_list', $this->data);
		$this->load->view('footer');
	}
	
	
	public function student_cancelation_request()
	{
		$this->data['studentData'] = $this->Ums_admission_model->getStudentByEnrollment($_SESSION['name']);
		$this->data['bankMasterData'] = $this->Ums_admission_model->getBankMasterData();
		$this->load->view('header', $this->data);
		$this->load->view($this->view_dir . 'student_cancelation_request', $this->data);
		$this->load->view('footer');
	}
	
	
	public function save_student_academic_request()
	{
		$studentData = $this->Ums_admission_model->getStudentByEnrollment($_SESSION['name']);
		$postData['enrollment_no'] = $_SESSION['name'];
		$postData['academic_year'] = $this->input->post('current_academic_year');
		$postData['student_bank_ac_no'] = $this->input->post('account_number');
		$postData['student_bank_ac_holder_name'] = $this->input->post('account_holder_name');
		$postData['student_bank_name'] = $this->input->post('bank_name');
		$postData['student_bank_ifsc'] = $this->input->post('ifsc_code');
		$student_id = $postData['student_id'] = $studentData['stud_id'];
		$postData['created_by'] = $studentData['stud_id'];
		$postData['remark'] = $this->input->post('remark');
		$postData['created_on'] = date('Y-m-d H:i:s');
		$postData['entry_from_ip'] = $_SERVER['REMOTE_ADDR'];
		$request_for = $this->input->post('request_type');
		//
		if ($postData['academic_year'] == '' || $postData['remark'] == '' || $postData['student_bank_ac_no'] == '' || $postData['student_bank_ac_holder_name'] == '' || $postData['student_bank_name'] =='' || $postData['student_bank_ifsc'] =='' || $postData['enrollment_no'] == '') {
			$this->session->set_flashdata('error', 'All fields are required, Please fill in all the fields.');
			redirect('Ums_admission/student_cancelation_request'); // Redirect to the view page
		}
		//
		if ($request_for == 1) {
			$postData['request_type'] = 'hostel';
		}
		//
		if ($request_for == 2) {
			$postData['request_type'] = 'transport';
		}
		//
		if ($request_for == 3) {
			$postData['request_type'] = 'uniform';
		}
		//
		if ($request_for == 4) {
			$postData['request_type'] = 'excess_fees';
		}
		//
		if ($request_for == 5) {
			$postData['request_type'] = 'cancel_admission';
		}
		//
		if ($request_for == 6) {
			$postData['request_type'] = 'hostel_security_money';
		}
		//
		if (!empty($_FILES['cancel_cheque']['name'])) {
			
			$uploadPath = ACADEMIC_YEAR.'/refunds/';
			$bucket_name = 'erp-asset';
			$filename = $postData['student_cancel_cheque'] = $student_id . '-' . time() . '-cancel_cheque';
		
			$allowed_types = ['jpg', 'jpeg', 'png', 'pdf'];
			$config['overwrite'] = TRUE;
			$max_size = 3 * 1024 * 1024;
			
			$file_ext = strtolower(pathinfo($_FILES['cancel_cheque']['name'], PATHINFO_EXTENSION));
			$file_size = $_FILES['cancel_cheque']['size'];

			if (!in_array($file_ext, $allowed_types)) {
				$this->session->set_flashdata('error', 'Invalid file type. Allowed types: jpg, jpeg, png, pdf.');
				redirect('Ums_admission/student_cancelation_request'); // Redirect to the view page
			}
			//
			if ($file_size > $max_size) {
				$this->session->set_flashdata('error', 'File too large. Max size is 3MB.');
				redirect('Ums_admission/student_cancelation_request'); // Redirect to the view page
			}
			
			$postData['student_cancel_cheque'] = $file_name = $postData['enrollment_no'] . '_' . time() . '_cancel_cheque.' . $file_ext;
			$file_path = $uploadPath . $file_name;
			$src_file = $_FILES['cancel_cheque']['tmp_name'];
		
			try {
				$this->awssdk->uploadFile($bucket_name, $file_path, $src_file);
				
			} catch (AwsException $e) {
				echo 'Error uploading file to S3: ' . $e->getMessage(); die;
			}
		
		}else{
			$this->session->set_flashdata('error', 'Cancel cheque is required, Please choose the file.');
			redirect('Ums_admission/student_cancelation_request'); // Redirect to the view page
		}
		//
		
		//
		$this->db->insert("sandipun_ums.student_request_refund", $postData);
		//
		$this->session->set_flashdata('success', 'Record saved successfully.');
		redirect('Ums_admission/student_refund_request_list'); // Redirect to the view page  

	}
	
	
	
	public function check_student_request_eligibility()
	{
		$postDataArr['request_type'] =  $_POST['request_type'];
		$postDataArr['curr_academic_year'] =  $_POST['curr_academic_year'];
		$postDataArr['enrollment_no'] =  $_SESSION['name'];
		//
		$studentData = $this->Ums_admission_model->getStudentByEnrollment($_SESSION['name']);
		$postDataArr['enrollment_no_new'] = $studentData['enrollment_no_new'];
		//
		$hostelTransportUniformCheckData = $this->Ums_admission_model->checkStudentRequest($postDataArr);

		if (!empty($hostelTransportUniformCheckData)) {
			$response = [
				"status" => 1,
				"message" => "Record found successfully",
				"data" => $hostelTransportUniformCheckData
			];
		} else {

			$response = [
				"status" => 0,
				"message" => "Record not found",
				"data" => $hostelTransportUniformCheckData
			];
		}
		echo json_encode($response);
		exit;
	}
	
	
	public function cancel_student_admission(){
		//
		if($_POST['enrollment_no'] == '' || $_POST['cancel_date'] == '' || $_POST['cancel_remark'] == ''){
			$this->session->set_flashdata('error', 'All fields are mandatory.');
			redirect('Admission/student_admission_cancel_request_list');
		}
		//
		$studentData = $this->Ums_admission_model->get_student_detail_by_prn($_POST['enrollment_no']);
		//
		$postData['student_id'] = $studentData['stud_id'];
		$postData['enrollment_no'] = $_POST['enrollment_no'];
		$postData['cancel_date'] = $_POST['cancel_date'];
		$postData['cancel_remark'] = $_POST['cancel_remark'];
		$postData['academic_year'] = $_POST['academic_year'];
		//
		$this->Ums_admission_model->saveCancelStudentAdmissionData($postData);
	}
/*******************************************************Added Start ********************************************************************************************* */
	/*public function save_imported_concession_data()
	{
		$this->load->library('excel');
		$DB1 = $this->load->database('umsdb', TRUE);
		$file_path = $this->input->post('uploaded_file');
		$conc_type = $this->input->post('conc_type');

		if (empty($file_path) || !file_exists($file_path)) {
			$this->session->set_flashdata('error', 'Excel file not found. Please upload again.');
			redirect('Ums_admission/import_concession_fee_excel');
		}

		$objPHPExcel = PHPExcel_IOFactory::load($file_path);
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

		$inserted = 0;
		$existing_prns = [];

		foreach ($sheetData as $index => $row) {
			if ($index == 1) continue;

			$prn              = trim($row['C']);
			$row_concession    = trim($row['B']);
			$academic_year     = !empty($row['F']) ? trim($row['F']) : ADMISSION_SESSION;
			$actual_fees       = isset($row['G']) ? (float)$row['G'] : null;
			$exepmted_fees     = isset($row['H']) ? (float)$row['H'] : null;
			$fees_paid         = isset($row['I']) ? (float)$row['I'] : null;
			$duration          = !empty($row['E']) ? $row['E'] : null;
			$concession_remark = trim($row['J']);

			if (
				empty($row_concession) || empty($prn) || empty($academic_year) || $actual_fees === null ||
				$exepmted_fees === null || $fees_paid === null || $duration === null || empty($concession_remark)
			) {
				$this->session->set_flashdata('conc_type', $conc_type);

				$this->session->set_flashdata('error', "Row {$index} has missing mandatory data. Please check the Excel file.");
				redirect('Ums_admission/import_concession_fee_excel');
			}

			if ($academic_year != ADMISSION_SESSION) {
				$this->session->set_flashdata('conc_type', $conc_type);

				$this->session->set_flashdata('error', "Row {$index} has academic year mismatch. Must be " . ADMISSION_SESSION);
				redirect('Ums_admission/import_concession_fee_excel');
			}
				$data['conc_types'] = $concession_type ?? '';
			// Check concession type matches the selected type
			if ($row_concession != $conc_type) {
				$this->session->set_flashdata('conc_type', $conc_type);

				$this->session->set_flashdata('error', "Row {$index} has concession type '{$row_concession}' which does not match the selected type '{$conc_type}'.");
				redirect('Ums_admission/import_concession_fee_excel');
			}

			// Check student exists
			$student = $DB1->select('stud_id')->where('enrollment_no', $prn)->get('student_master')->row();
			if (!$student) {
				$this->session->set_flashdata('error', "Row {$index} has invalid PRN. Student not found.");
				redirect('Ums_admission/import_concession_fee_excel');
			}

			// Check duplicate
			$duplicate = $DB1->where('student_id', $student->stud_id)
				->where('enrollement_no', $prn)
				->where('academic_year', $academic_year)
				->where('concession_type', $conc_type)
				->get('fees_consession_details')
				->row();

			if ($duplicate) {
				$existing_prns[] = $prn;
				continue; 
			}

			$data = [
				'concession_type'    => $conc_type,
				'student_id'         => $student->stud_id,
				'enrollement_no'     => $prn,
				'academic_year'      => $academic_year,
				'actual_fees'        => $actual_fees,
				'exepmted_fees'      => $exepmted_fees,
				'fees_paid_required' => $fees_paid,
				'duration'           => $duration,
				'concession_remark'  => $concession_remark,
				'allowed_by'         => 'Admin',
				'created_by'         => $this->session->userdata('uid'),
				'created_on'         => date('Y-m-d H:i:s'),
			];

			$DB1->insert('fees_consession_details', $data);
			$inserted++;

			$update_data = [
				'applicable_fee'         => $fees_paid,
				'fees_consession_allowed' => 'Y',
				'duration'               => $duration,
				'modified_by'            => $this->session->userdata('uid'),
				'modified_on'            => date('Y-m-d H:i:s'),
				'concession_remark' 	=> $concession_remark
			];

			$DB1->where('student_id', $student->stud_id)
				->where('academic_year', $academic_year)
				->update('admission_details', $update_data);
		}

		@unlink($file_path);

		$msg = "Inserted {$inserted} rows successfully.";
		if (!empty($existing_prns)) {
			$msg .= " ⚠️ The following Enrollment(s) already exist and were skipped: " . implode(', ', $existing_prns);
		}

		$this->session->set_flashdata('message', $msg);
		redirect('Ums_admission/import_concession_fee_excel');
	}*/

public function save_imported_concession_data()
{
	if($this->session->userdata('name')=='211530'){
		
	}else{
		//echo "Not Allowed.";exit;
	}
	
    $this->load->library('excel');
    $DB1 = $this->load->database('umsdb', TRUE);
    $file_path = $this->input->post('uploaded_file');
    $conc_type = $this->input->post('conc_type');

    if (empty($file_path) || !file_exists($file_path)) {
        $this->session->set_flashdata('error', 'Excel file not found. Please upload again.');
        redirect('Ums_admission/import_concession_fee_excel');
    }
	//print_r($_POST);exit;
    $objPHPExcel = PHPExcel_IOFactory::load($file_path);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

    $inserted = 0;
    $existing_prns = [];
    $updated_students = []; // ✅ to store students for email summary

    foreach ($sheetData as $index => $row) {
        if ($index == 1) continue;

        $prn              = trim($row['C']);
        $row_concession   = $row['B'];
        $academic_year    = !empty($row['F']) ? trim($row['F']) : ADMISSION_SESSION;
        $actual_fees      = isset($row['G']) ? (float)$row['G'] : 0;
        $exepmted_fees    = isset($row['H']) ? (float)$row['H'] : 0;
        $fees_paid        = isset($row['I']) ? (float)$row['I'] : 0;
        $duration         = isset($row['E']) ? $row['E'] : 0;
        $concession_remark = trim($row['J']);
		//echo '<pre>'; print_r($row);exit;
			if (
				empty($row_concession)
			) {
				$this->session->set_flashdata('conc_type', $conc_type);

				$this->session->set_flashdata('error', "Row {$index} has missing mandatory data. Please check the Excel file.");
				redirect('Ums_admission/import_concession_fee_excel');
			}

			if ($academic_year != ADMISSION_SESSION) {
				$this->session->set_flashdata('conc_type', $conc_type);

				$this->session->set_flashdata('error', "Row {$index} has academic year mismatch. Must be " . ADMISSION_SESSION);
				redirect('Ums_admission/import_concession_fee_excel');
			}
				// $data['conc_types'] = $concession_type ?? '';
			// Check concession type matches the selected type
			if ($row_concession != $conc_type) {
				$this->session->set_flashdata('conc_type', $conc_type);

				$this->session->set_flashdata('error', "Row {$index} has concession type '{$row_concession}' which does not match the selected type '{$conc_type}'.");
				redirect('Ums_admission/import_concession_fee_excel');
			}

        $student = $DB1->select('stud_id, first_name, enrollment_no')
            ->where('enrollment_no', $prn)
            ->get('student_master')
            ->row();

        if (!$student) {
            $this->session->set_flashdata('error', "Row {$index} has invalid PRN. Student not found.");
            redirect('Ums_admission/import_concession_fee_excel');
        }

        $duplicate = $DB1->where('student_id', $student->stud_id)
            ->where('enrollement_no', $prn)
            ->where('academic_year', $academic_year)
            ->where('concession_type', $conc_type)
            ->get('fees_consession_details')
            ->row();

        if ($duplicate) {
            $existing_prns[] = $prn;
            continue;
        }

        // ✅ Fetch old applicable fee before update
        $old_fees_data = $DB1->select('applicable_fee')
            ->where('student_id', $student->stud_id)
            ->where('academic_year', $academic_year)
            ->get('admission_details')
            ->row();
        $old_applicable_fee = $old_fees_data ? $old_fees_data->applicable_fee : 0;

        // Insert new concession data
        $data = [
            'concession_type'    => $conc_type,
            'student_id'         => $student->stud_id,
            'enrollement_no'     => $prn,
            'academic_year'      => $academic_year,
            'actual_fees'        => $actual_fees,
            'exepmted_fees'      => $exepmted_fees,
            'fees_paid_required' => $fees_paid,
            'duration'           => $duration,
            'concession_remark'  => $concession_remark,
            'allowed_by'         => 'Admin',
            'created_by'         => $this->session->userdata('uid'),
            'created_on'         => date('Y-m-d H:i:s'),
        ];

        $DB1->insert('fees_consession_details', $data);
        $inserted++;

        // Update admission details
        $update_data = [
            'applicable_fee'          => $fees_paid,
            'fees_consession_allowed' => 'Y',
            'duration'                => $duration,
			'concession_remark'       => $concession_remark,
            'modified_by'             => $this->session->userdata('uid'),
            'modified_on'             => date('Y-m-d H:i:s')
        ];

        $DB1->where('student_id', $student->stud_id)
            ->where('academic_year', $academic_year)
            ->update('admission_details', $update_data);

        // ✅ Add student data for email
        $updated_students[] = [
            'enrollment_no' => $student->enrollment_no,
            'name'          => $student->first_name,
            'old_fee'       => $old_applicable_fee,
            'exempted_fee'  => $exepmted_fees,
            'new_fee'       => $fees_paid,
            'conc_remark'       => $concession_remark,
            'updated_on'    => date('d-m-Y H:i:s'),
        ];
    }

    @unlink($file_path);

    // ✅ Send summary email after all updates
    if (!empty($updated_students)) {
       $body = "
<html>
<head>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
    }
    .email-container {
      max-width: 1000px;
      background-color: #ffffff;
      margin: auto;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
      border: 1px solid #ddd;
    }
    .email-header {
      font-size: 20px;
      font-weight: bold;
      color: #005bab;
      margin-bottom: 15px;
      text-align: center;
    }
    .info-block {
      background-color: #eaf1fb;
      border-left: 4px solid #005bab;
      padding: 12px 15px;
      margin-bottom: 20px;
      font-size: 14px;
      line-height: 1.6;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
      margin-top: 10px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 8px 12px;
      text-align: left;
    }
    th {
      background-color: #005bab;
      color: #fff;
      font-weight: bold;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    tr:hover {
      background-color: #f1f7ff;
    }
    .footer {
      font-size: 11px;
      color: #777;
      margin-top: 20px;
      text-align: center;
    }
    .icon {
      vertical-align: middle;
      margin-right: 6px;
    }
  </style>
</head>
<body>
  <div class='email-container'>
    <div class='email-header'>
      ✅ Student Concession-Fee Updated Successfully
    </div>

    <div class='info-block'>
      <strong>Concession Type:</strong> {$conc_type}<br>
      <strong>Total Students Updated:</strong> " . count($updated_students) . "<br> 
    </div>

    <table>
      <tr>
        <th>🎓 Enrollment No</th>
        <th>👤 Student Name</th>
        <th>💰 Previous Fee</th>
        <th>💸 Exempted Fee</th>
        <th>💵 Updated Fee</th>
        <th>📝 Concession Remark</th>
        <th>🕒 Updated On</th>
      </tr>";

foreach ($updated_students as $stu) {
    $body .= "
      <tr>
        <td>{$stu['enrollment_no']}</td>
        <td>{$stu['name']}</td>
        <td style='text-align:right;'>{$stu['old_fee']}</td>
		<td style='text-align:right;'>{$stu['exempted_fee']}</td>
		<td style='text-align:right;'>{$stu['new_fee']}</td>
		<td>{$stu['conc_remark']}</td>
        <td>{$stu['updated_on']}</td>
      </tr>";
}

$body .= "
    </table>

    <div class='footer'>
      This is an auto-generated email from Sandip University ERP. Please do not reply.
    </div>
  </div>
</body>
</html>";


        $subject = "Notification for student concession fees updation - {$this->session->userdata('name')} {$this->session->userdata('emp_name')}";
        $from = 'noreply10@sandipuniversity.edu.in';
        $admin_email = "erp.support@sandipuniversity.edu.in";
        $cc_email = "pramod.thasal@sandipuniversity.edu.in";

        $this->send_concession_update_mail($body, $subject, $admin_email, $cc_email, $from);
    }

    $msg = "Inserted {$inserted} rows successfully.";
    if (!empty($existing_prns)) {
        $msg .= " ⚠️ The following Enrollment(s) already exist and were skipped: " . implode(', ', $existing_prns);
    }

    $this->session->set_flashdata('message', $msg);
    redirect('Ums_admission/import_concession_fee_excel');
}

private function send_concession_update_mail($body, $subject, $to, $cc = '', $from = 'noreply10@sandipuniversity.edu.in')
{
    $this->load->library('email');

    $config = [
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'noreply10@sandipuniversity.edu.in',
        'smtp_pass' => 'pgefsqabruxvcdvy', // Gmail App Password
        'mailtype'  => 'html',
        'charset'   => 'utf-8',
        'newline'   => "\r\n",
        'wordwrap'  => TRUE,
    ];

    $this->email->initialize($config);
    $this->email->from($from, 'Sandip University ERP');
    $this->email->to($to);
    if (!empty($cc)) $this->email->cc($cc);
    $this->email->subject($subject);
    $this->email->message($body);

    if (!$this->email->send()) {
        log_message('error', $this->email->print_debugger(['headers']));
        echo $this->email->print_debugger(['headers']);
        exit;
    }
}

	public function import_concession_fee_excel()
	{
		$this->load->library('upload');
		$this->load->library('excel');
		$DB1 = $this->load->database('umsdb', TRUE);
		// $concession_type = $this->input->post('conc_type');
		$concession_type = $this->input->post('conc_type') ?? $this->session->flashdata('conc_type') ?? '';  
		$data['conc_types'] = $concession_type ?? '';
		if (!empty($_FILES['excel_file']['name'])) {
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'xls|xlsx';
			$config['file_name'] = time() . '_' . $_FILES['excel_file']['name'];
			$this->upload->initialize($config);

			if ($this->upload->do_upload('excel_file')) {
				$file_data = $this->upload->data();
				$file_path = './uploads/' . $file_data['file_name'];

				$this->load->library('PHPExcel');
				$objPHPExcel = PHPExcel_IOFactory::load($file_path);
				$sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

				$data['excel_data'] = $sheetData;
				$data['uploaded_file'] = $file_path;
			} else {
				$data['error'] = $this->upload->display_errors();
			}
		}
		$data['concession_types'] = $DB1->select('DISTINCT(concession_type) as concession_type')
			->where('concession_type IS NOT NULL', null, false)
			->where('concession_type !=', '')
			->get('fees_consession_details')
			->result();



	
		$this->load->view('header', $this->data);
		$this->load->view($this->view_dir . 'import_concession_fee_excel', $data);
		$this->load->view('footer');
	}


	public function download_concession_excel()
	{
		$concession_type = $this->input->post('concession_type');

		$this->load->library('excel');
		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$sheet = $object->getActiveSheet();

		$headers = [
			'A1' => 'Sr .No',
			'B1' => 'Concession Type',
			'C1' => 'Enrollment No',
			'D1' => 'Student_name',
			'E1' => 'Duration (1 = "One" Yr only & 0 =  "All" Yr)',
			'F1' => 'Academic Year',
			'G1' => 'Actual Fee',
			'H1' => 'Exepmted Fee',
			'I1' => 'Applicable Fee',
			'J1' => 'Remark'
		];

		foreach ($headers as $cell => $value) {
			$sheet->setCellValue($cell, $value);
		}

		// === Header Styling ===
		$sheet->getStyle('A1:J1')->getFont()->setBold(true);
		$sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A1:J1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		// === Add Only First Sample Row ===
		$sheet->setCellValue('A2', '1'); // srno
		$sheet->setCellValue('B2', $concession_type); // selected concession type
		$sheet->setCellValue('C2', (int)$enrollmentNo); // Set as integer (e.g. 123456)
		$sheet->getStyle('C2')->getNumberFormat()->setFormatCode('#');
		$sheet->setCellValue('F2', ADMISSION_SESSION); // academic year
		// all other cells remain blank intentionally

		// === Style the data row borders ===
		$sheet->getStyle('A1:J2')->getBorders()->getAllBorders()
			->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		// === Auto-size Columns ===
		foreach (range('A', 'J') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// === Output Excel ===
		$filename = 'Concession_Sample_' . preg_replace('/\s+/', '_', $concession_type) . '.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
		$writer->save('php://output');

		exit;
	}
	/*******************************************************Added End ********************************************************************************************* */


	 
}
?>