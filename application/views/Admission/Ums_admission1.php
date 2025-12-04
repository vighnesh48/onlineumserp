<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//ini_set('display_errors', 1);
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
     $this->load->view('header',$this->data);    
     //  $this->data['student_list']= $this->Facility_model->get_hstudent_list();                        
        $this->load->view($this->view_dir.'reregistration',$this->data);
        $this->load->view('footer');
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
           
            $feedet =	$this->Ums_admission_model->get_feedetails($_POST['prn']);  
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
$academic_year='2018-19';

$acyear='2018';

$prov_det = $this->Ums_admission_model->verifypro_prn($stud_id);
//var_dump($prov_det);
//exit();
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
	 //    error_reporting(E_ALL);
//ini_set('display_errors', 1);
$data['emp_list']= $this->Ums_admission_model->getStudentsajax($_POST['dcourse'],$_POST['dyear']);

//var_dump($this->Ums_admission_model->getStudentsajax($_POST['dcourse'],$_POST['dyear']));


	       $data['dstream']= $this->Ums_admission_model->getfieldname_byid('vw_stream_details','stream_id',$_POST['dcourse'],'stream_name');
	     $data['dyear']= $_POST['dyear'];
	      
	      $filename= $data['dstream']."-".$_POST['dyear']."-Year";
	     $pdfFilePath = "StudentList-". $filename.".pdf";
	  //   echo "**********";
	    
// $html = $this->load->view('agents/invoices/invoice_pdf',$data,true);

$html = $this->load->view($this->view_dir.'student_listpdf',$data,true);

$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
        //load mPDF library
        $this->load->library('m_pdf',$param);


       //generate the PDF from the given html
       $this->m_pdf->pdf->WriteHTML($html);
//echo $html;
// exit(0);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
 $pdfFilePath = "output_pdf_name.pdf";     
	    
	    
	    
	}

function generate_payment_receipt($fees_id)
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
	  ini_set('memory_limit', '-1');
	 // error_reporting(E_ALL);
//ini_set('display_errors', 1);
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

$html = $this->load->view($this->view_dir.'all_icard',$data,true);
//echo $html;
//exit(0);
$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
        //load mPDF library
        $this->load->library('m_pdf',$param);

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
 $pdfFilePath = "output_pdf_name.pdf";     
	    
	    
	    
	    
	    
	}







	
	
	
function create_login()
{
   $this->Ums_admission_model->create_student_login(); 
    
}
	
		function generateID()
	{
	    //var_dump($_POST);
	  //  exit(0);
$data['emp_list']= $this->Ums_admission_model->getStudentsajax($_POST['dcourse'],$_POST['dyear']);

$data['valid']= $this->Ums_admission_model->get_course_duration($_POST['dcourse']);

//var_dump($this->Ums_admission_model->getStudentsajax($_POST['astream'],$_POST['ayear']));getfieldname_byid

//exit(0);
	       $data['dstream']= $this->Ums_admission_model->getfieldname_byid('vw_stream_details','stream_id',$_POST['dcourse'],'stream_name');
	       
	       
	       
	        $data['short_stream']= $this->Ums_admission_model->getfieldname_byid('vw_stream_details','stream_id',$_POST['dcourse'],'stream_short_name');
	       
	       
	       
	       
	     $data['dyear']= $_POST['dyear'];
	     
	     
	      $data['ids']= $this->Ums_admission_model->student_Ids($_POST);
	     
	  //    var_dump();
	      $filename= $data['dstream']."-".$_POST['dyear']."-Year";
	     $pdfFilePath = "StudentList-". $filename.".pdf";
// $html = $this->load->view('agents/invoices/invoice_pdf',$data,true);

$html = $this->load->view($this->view_dir.'student_icard',$data,true);
//echo $html;
//exit();
$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
        //load mPDF library
        $this->load->library('m_pdf',$param);
$this->m_pdf->pdf->SetFont('IDAutomationHC39M Code 39 Barcode');

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
 $pdfFilePath = "output_pdf_name.pdf";     
	    
	    
	    
	}
	
	function applyexem()
	{
$this->Ums_admission_model->fee_exemption();
   //echo '<script>alert("Fees updated successfully for selected students");</script>';
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
    ini_set('display_errors', 1);
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
  // var_dump($bdat);
}





function bonafied_pdf($reg)
{
  
        $this->Ums_admission_model->generate_bonafied();
       $this->load->view('header',$this->data);   
        $this->session->set_flashdata('message2','Bonafied is addedd successfully');
        $this->load->view($this->view_dir.'add_bonafied',$this->data);
        
}


function generate_transfer_cert($reg)
{
  
        $this->Ums_admission_model->generate_transfer_cert();
       $this->load->view('header',$this->data);   
        $this->session->set_flashdata('message2','Transfer Certificate is addedd successfully');
        $this->load->view($this->view_dir.'add_transfer_cert',$this->data);
        
}


function generate_migration_cert($reg)
{
  
        $this->Ums_admission_model->generate_migration_cert();
       $this->load->view('header',$this->data);   
        $this->session->set_flashdata('message2','Migration Certificate is addedd successfully');
        $this->load->view($this->view_dir.'add_migration_cert',$this->data);
        
}


	
function regenerate_bonafide($bid,$enroll)
{
    
    
     $bddata = $this->Ums_admission_model->regenerate_bonafied($enroll);
      $gendata = $this->Ums_admission_model->list_bonafied($bid,$refid='');
      $data['bonafieddata']= $bddata;
      
       $data['idate']=$gendata[0]['cert_date'] ;
        $data['purpose']=$gendata[0]['purpose'] ;
         $data['reg']= $gendata[0]['cert_reg'];
    $html = $this->load->view($this->view_dir.'bonafiedpdf',$data,true);
//echo $html;
//$html ="<div>gdf dfg df fdg fg dg gfdg gd fg</div>";
    $pdfFilePath = "Bonafied Certificate.pdf";
$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
        //load mPDF library
        $this->load->library('m_pdf',$param);

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
 $pdfFilePath = "output_pdf_name.pdf"; 
 
}
	
	
	
	
function regenerate_transfer_cert($bid,$enroll)
{
    
    
     $bddata = $this->Ums_admission_model->regenerate_transfer_cert($enroll);
      //$gendata = $this->Ums_admission_model->transfer_certificate($bid,$refid='');
      $data['cert_data'] = $this->Ums_admission_model->transfer_certificate($bid,$refid='');
      $data['bonafieddata']= $bddata;
      

    $html = $this->load->view($this->view_dir.'transfer_cert_pdf',$data,true);
//echo $html;
//exit();
//$html ="<div>gdf dfg df fdg fg dg gfdg gd fg</div>";
    $pdfFilePath = "Transfer Certificate.pdf";
$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
        //load mPDF library
        $this->load->library('m_pdf',$param);
        $this->m_pdf->pdf->SetWatermarkImage('http://sandipuniversity.com/erp/assets/su-watermark-logo.png', 
    0.2, 
    '', 
    array(160,10));
        $this->m_pdf->pdf->showWatermarkImage = true;
        
      //   $this->m_pdf->pdf->SetWatermarkText('DRAFT');
// $this->m_pdf->pdf->showWatermarkText = true;
$this->m_pdf->pdf->SetHTMLFooter("<div align='left' style='min-height:50px;margin:10px 10px 10px 20px;'>It is Certified that above information is in accordance with the Institute's records<br><br></div>");
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
 $pdfFilePath = "output_pdf_name.pdf"; 
 
}
		
	
	
	function regenerate_migration_cert($bid,$enroll)
{
    
    
     $bddata = $this->Ums_admission_model->regenerate_migration_cert($enroll);
      //$gendata = $this->Ums_admission_model->transfer_certificate($bid,$refid='');
      $data['cert_data'] = $this->Ums_admission_model->migration_certificate($bid,$refid='');
      $data['bonafieddata']= $bddata;
      

    $html = $this->load->view($this->view_dir.'migration_cert_pdf',$data,true);
//echo $html;
//$html ="<div>gdf dfg df fdg fg dg gfdg gd fg</div>";
    $pdfFilePath = "Migration Certificate.pdf";
$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
        //load mPDF library
        $this->load->library('m_pdf',$param);

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
 $pdfFilePath = "output_pdf_name.pdf"; 
 
}
		
	
	
	
	public function test()
	{
		//error_reporting(E_ALL);
	    // $this->Ums_admission_model->migrate_attendance();
    //$this->Ums_admission_model->change_engine();
	          // error_reporting(E_ALL);
//ini_set('display_errors', 1);
  //$this->Ums_admission_model->generate_allprn();

//echo $this->Ums_admission_model->calculate_attempts(724,163,7);

//$this->Ums_admission_model->shift_emp_inhouse();

//$this->Ums_admission_model->update_parent_mobile();

//$this->Ums_admission_model->result_master_update();
//$this->Ums_admission_model->update_admission_details_for_2018();
//$this->Ums_admission_model->update_exam_student_subject(10); // for failed student updation
//$this->Ums_admission_model->update_exam_student_subject_pharma(9); // for failed student updation for pharma
	    //$stream_id='5';
	    //$academic_year='2016-17';
	    //$admission_year='1';
	   //$this->Ums_admission_model->generate_prn_punching();
	 //  $this->Ums_admission_model->exam_result_data(5,17);
	   
	//   $foo =500.94;
	 //echo  number_format((float)$foo, 2, '.', '');  170109051001 170109051002
	   

	 
//	 $this->Ums_admission_model->insert_sf_student_data();
	    
//$this->Ums_admission_model->exam_result_data(7) ;
// for result generation cgpa 
//$this->Ums_admission_model->calculate_sgpa(10,5);	    
//$this->Ums_admission_model->calculate_cgpa(10);
//$this->Ums_admission_model->calculate_gpa(10,5);
	    
	    
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
//$prn = $this->Ums_admission_model->create_student_login();
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
		$data['ex_ses']= $this->Ums_admission_model->exam_sessions();
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
	   $data['ex_ses']= $this->Ums_admission_model->exam_sessions();
	      $data['emp_list']= $this->Ums_admission_model->getStudentsajax($_POST['astream'],$_POST['ayear'],$_POST['acdyear']);
	       $data['dcourse']= $_POST['astream'];
	        $data['dyear']= $_POST['ayear'];
	       $data['hide']= $_POST['hide'];
	       
	       
	//  print_r($data['emp_list']);
	   $html = $this->load->view($this->view_dir.'load_studentdata',$data,true);
	   echo $html;
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
	 $data['ex_ses']= $this->Ums_admission_model->exam_sessions();
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
	$data['dcourse']= $_POST['astream'];
	$data['dyear']= $_POST['ayear'];
    $data['academicyear']= $_POST['acdyear'];
    $data['emp_list']= $this->Ums_admission_model->searchStudentfeedata1($_POST['astream'],$_POST['ayear'],$data['academicyear']);
   
    
    $data['count_rows']=count($data['emp_list']);
	      $html = $this->load->view($this->view_dir.'fee_adjust',$data,true);
	  echo $html;
}
	
	
	
	
 public function cancel_admission(){
		   $this->load->view('header',$this->data); 
		    $this->data['emp_list']= $this->Ums_admission_model->get_cancelled_adm();
		     $this->load->view($this->view_dir.'cancel_list',$this->data);
		    $this->load->view('footer');
	 }
	 
	 public function load_cancel_admission()
	 {
	       $this->data['emp_list']= $this->Ums_admission_model->get_cancelled_adm($_POST['prn']);
		    echo $this->load->view($this->view_dir.'load_cancel_list',$this->data);
	     
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
        
        $this->load->view('header',$this->data);     
        $this->data['states'] = $this->Ums_admission_model->fetch_states();
        $campus_id=$this->uri->segment(3);
	//$college_id = $this->session->college_id;
	//$up_stud_id=$_REQUEST['s'];
	//echo $stud_id;
	    $college_id = 1;
      //  $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
      
     //  $academic_year='2016-17';
$academic_year='2018-19';
	    
	    	$this->data['school_list']= $this->Ums_admission_model->list_schools();
	    $this->data['course_details'] = $this->Ums_admission_model->getcourse_yearwise($academic_year);
		$this->data['doc_list']= $this->Ums_admission_model->getdocumentlist();
		$this->data['category']= $this->Ums_admission_model->getcategorylist();
		$this->data['religion']= $this->Ums_admission_model->getreligionlist();
	$this->data['course_year']= $this->Ums_admission_model->getCourseYRClg($college_id);
	$this->data['branches']= $this->Ums_admission_model->getbranch($college_id);
	
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
			  //  echo '<script>alert("PRN Number of '.$nam.' is '.$stud_reg_id.'");window.location.href = "stud_list";</script>';
			 $path= "http://sandipuniversity.com/erp/ums_admission/edit_personalDetails/".$_POST['student_id'];
			 echo '<script>alert("Student application updated  successfully..");window.location.href = "'.$path.'";</script>';
	//	redirect($path);
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
			redirect('ums_admission/edit_refDetails');
    }
	

		public function update_docDetails()
    {
        
            $student_id = $this->session->userdata('studId');
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
                 $arr1[$key]=str_replace(" ","_",$_FILES['userFile']['name']);
                $uploadPath = 'uploads/student_document/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx|pdf';
				$config['overwrite']= TRUE;
                $config['max_size']= "2048000"; 
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$key]['file_name'] = str_replace(" ","_",$fileData['file_name']);
                    $uploadData[$key]['created'] = date("Y-m-d H:i:s");
                    $uploadData[$key]['modified'] = date("Y-m-d H:i:s");
                }
            }
               }
       $this->Ums_admission_model->update_stepthirddata($_POST); 
         $msg5='student application updated  successfully..';
			 $this->session->set_flashdata('msg5', $msg5); 
			redirect('ums_admission/edit_docsndcertDetails');
    }
	
	
	
	public function reregistration_details($stud_id)
    {
        if($_POST)
        {
        //   var_dump($_POST['acd_totalfee']); 
           // exit();
         
       $this->Ums_admission_model->reregistration_details($_POST); 
         $msg5='student application updated  successfully..';
			 $this->session->set_flashdata('msg5', $msg5);
			  //  echo '<script>alert("PRN Number of '.$nam.' is '.$stud_reg_id.'");window.location.href = "stud_list";</script>';
			 $path= "http://sandipuniversity.com/erp/ums_admission/student_reregistration/";
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
        $this->data['feedetj'] = $this->Ums_admission_model->fetch_academic_fees_for_rereg($stdata[0]['admission_stream'],($stdata[0]['academic_year']+1),$stdata[0]['admission_session']);
        
          $loadd = $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');
	    $peradd = $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','PERMNT');
	    $parentadd = $this->Ums_admission_model->fetch_address_details($stud_id,'PARENT','PERMNT');
	    
	    
         $this->data['local_address']=$loadd;
          $this->data['perm_address']= $peradd;
           $this->data['parent_address']= $parentadd;
           $this->data['parent_details']= $this->Ums_admission_model->fetch_parent_details($stud_id);
            $this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id,$stdata[0]['academic_year']); 
          
          $this->data['total_fees_paid']=$this->Ums_admission_model->fetch_total_fee_paid($stud_id,$stdata[0]['academic_year']);
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
        $this->load->view($this->view_dir.'reregistration_details',$this->data);
        $this->load->view('footer');
        }
    }
	
	
	
	// edit student personal details
	public function edit_personalDetails($stud_id)
    {
    // error_reporting(E_ALL);
//ini_set('display_errors', 1);
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
	     $this->data['is_concern']= $this->Ums_admission_model->get_referencedetails('is_concern_ins',$stud_id);
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
		public function fetch_academic_fees_for_stream_year(){
		$strm_id=$_REQUEST['strm_id'];
			$acyear=$_REQUEST['acyear'];
		$fess =$this->Ums_admission_model->fetch_academic_fees_for_stream_year($strm_id,$acyear);
		
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
                $_FILES['userFile']['error'] = $_FILES['sss_doc']['error'][$key];
                $_FILES['userFile']['size'] = $_FILES['sss_doc']['size'][$key];
                 $arr2[$key]=str_replace(" ","_",$_FILES['userFile']['name']);
                $uploadPath = 'uploads/student_document/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx|pdf';
				$config['overwrite']= TRUE;
                $config['max_size']= "2048000"; 
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$key]['file_name'] = str_replace(" ","_",$fileData['file_name']);
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
		$this->data['parent_details']= $this->Ums_admission_model->fetch_parent_details($stud_id);
		$this->data['get_feedetails']= $this->Ums_admission_model->get_feedetails($stud_id);
		
		$this->data['get_refunds']= $this->Ums_admission_model->get_refundetails($stud_id);
			$this->data['tot_refunds']= $this->Ums_admission_model->get_tot_refunds($stud_id);
		$this->data['get_bankdetails']= $this->Ums_admission_model->get_bankdetails($stud_id);
		$this->data['bank_details']= $this->Ums_admission_model->getbanks();
	//	$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id);
		$this->data['admission_detail']= $this->Ums_admission_model->fetch_admission_details_all($stud_id,$acyear); 
		
		$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id,$acyear); 
	
		$this->data['totfeepaid']= $this->Ums_admission_model->fetch_total_fee_paid($stud_id);
		
		
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
	public function pay_Installment($stud_id)
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
	
	
	public function update_inst($stud_id)
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
        
         $data['academic_year']="2017";
         $this->load->view('header',$this->data);        
        $this->data['emp_list']= $this->Admission_model->get_scholorship_list($data);
        $this->load->view($this->view_dir.'scholorship_list',$this->data);
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
		$opt ='<option value="">Select Stream</option>';
	   foreach ($stream_details as $str) {

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
	public function change_stream($student_id){
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
	public function update_stream($temp_id){
		//error_reporting(E_ALL);
		$temp_id =$_POST['temp_id'];
		if(!empty($temp_id)){
			$tempid= $this->Ums_admission_model->get_stream_temp_details($temp_id);
			if(!empty($tempid)){
				$var['admission_stream'] = $tempid[0]['change_to_stream'];
				$var['stud_id'] = $tempid[0]['stud_id'];
				$var['academic_year'] = $tempid[0]['academic_year'];
				$var['current_year'] = $tempid[0]['current_year'];
				$var['previous_stream'] = $tempid[0]['previous_stream'];
				$var['admission_year'] = $tempid[0]['admission_session'];
				$update= $this->Ums_admission_model->update_stream_adm_details($var);
				$update1= $this->Ums_admission_model->update_stream_stud_master($var);
				$this->Ums_admission_model->update_temp_stream_status($temp_id);			
			}else{
				echo "N";
			}
		}
		$stud_id = $var['stud_id'];
		echo "Y";
		//redirect('ums_admission/change_stream/'.$stud_id);
	 }	
	function detaintion_list(){
	   // $this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
	    $this->load->model('Subject_model');
		$this->load->model('Exam_timetable_model');
		$this->data['schools']= $this->Exam_timetable_model->getSchools();
		$this->data['academic_year']= $this->Subject_model->getAcademicYear();
		$this->data['ex_ses']= $this->Ums_admission_model->exam_detention_sessions();
	    if(!empty($_POST['academicyear'])){
	        
	    $academicyear = $_POST['academicyear'];
		$exam_session = $_POST['exam_session'];
		$school = $_POST['school_code'];
	    $this->data['detaintion_list']= $this->Ums_admission_model->get_detaintion_list($academicyear, $exam_session,$school);
	    }
        $this->load->view('header',$this->data);
        $this->load->view($this->view_dir.'detaintion_list',$this->data);
        $this->load->view('footer',$this->data);
        //ob_end_clean();
	}	
	function detaintion_list_pdf($academicyear, $exam_session,$school){
	    //echo $exam_sessio;
		$this->data['academicyear']=$academicyear;
		$examses=explode('~',$exam_session);
		$this->data['examses']=$examses[0].'-'.$examses[1];
		//$this->data['school_name']= $this->Ums_admission_model->get_school_name($school);
	    $this->data['detaintion_list']= $this->Ums_admission_model->get_detaintion_list($academicyear, $exam_session,$school);
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
				<td align="left" width="70%"><b>Dean Academic </b><br><br><span style="font-size:11px;">Name: '.$dean_acdmic.'<br><br>Signature:</span><br><br><br><br></td>
		
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
	public function update_prn()
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
}
?>