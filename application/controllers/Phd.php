<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Phd extends CI_Controller 
{

    var $currentModule="";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Phd_model";
    var $model;
    var $view_dir='Phd/';
    
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
     //   echo $_SERVER['REMOTE_ADDR'];
    // var_dump($_SESSION);
 // error_reporting(E_ALL);
  // ini_set('display_errors', 1);
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
    
    
    
    public function test()
    {
      //  $this->Phd_model->generate_phd_reg();
    }

    
    public function index()
    {
    if($_POST)
        {
            
            $this->generate_attendence_sheet();
            /*
     $this->data['stud_data']	=  $this->Phd_model->phd_listing();
        $this->load->view($this->view_dir . 'phd_list_excel', $this->data); 
        */
        }
        else
        {
        $this->load->view('header',$this->data);    
         $this->data['phd_data']= $this->Phd_model->phd_listing();
         $this->data['dept']= $this->Phd_model->department();
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'phd_listing',$this->data);
        $this->load->view('footer');
        } 
     
    }
    
    	public function generate_attendence_sheet()
	{
	    
	  //  if($_POST['report_type']=='AttendanceSheet'){
			//error_reporting(E_ALL);
			$dept = $_POST['dept'];
		if($dept !='')
		{
		   $deptname =  $_POST['dept'];
		}
		else
		{
		      $deptname =  "All";
		}
		$studphd = 	$this->Phd_model->appli_details_all($dept);
			
			//$this->data['school_code'] =$_POST['school_code'];
		//	$this->data['admissioncourse'] =$_POST['admission-course'];
			//$this->data['stream'] =$_POST['admission-branch'];
		//	$this->data['semester'] =$_POST['semester'];
		
			ini_set('max_execution_time', 0);
			ini_set('memory_limit', '-1');
			$this->load->library('m_pdf');
			//$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '65', '18');
			//$mpdf=new mPDF();
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '45', '18');
			//$sublist= $this->Examination_model->fetchExamSubjects();
			//echo "<pre>";
			//print_r($sublist);exit;
			$content='<style>  
			table {  
			font-family: arial, sans-serif;  
			border-collapse: collapse;  
			width: 100%; font-size:12px; margin:0 auto;
			}  
			td{vertical-align: top;}
                      
			.signature{
			text-align: center;
			}
			p{padding:0px;margin:0px;}
			h1, h3{margin:0;padding:0}
			
			.content-table tr td{border:1px solid #333;vertical-align:middle;}
			.content-table th{border:1px solid #333;margin:0px}
			</style> ';
			$k=1;
	
				$adm_batch=PHD_ADMISSION_BATCH;
				$username = $this->session->userdata('name');
		 $cp =explode('_',$username);//exit;
		$campus=ucwords($cp[1]);
		if($campus=='Sum'){
			$exam_name='SUMPET';
		}else{
			$exam_name='SUNPET';
		}
				//$frmtime = explode(':', $sublist[$i]['from_time']);
				//$totime = explode(':', $sublist[$i]['to_time']);
				//$frmtime[0].':'.$frmtime[1].'-'.$totime[0].':'.$totime[1];
			//	$subject_id =$sublist[$i]['subject_id'];
				//$studlist= $this->Examination_model->getSubjectStudentList($subject_id,$_POST['admission-branch'], $exam_month, $exam_year,$exam_id);
				//$streamname= $this->Examination_model->getStreamShortName($_POST['admission-branch']);
				
				$header ='<table cellpadding="0" cellspacing="0" border="0" align="center" width="900">
				<tr>
				<td width="50" align="right" style="text-align:right;padding-top:00px;"></td>
				<td style="font-weight:normal;text-align:center;padding-top:00px;" valign="top">
			<img src="'.base_url().'assets/images/logo-77.png" alt="" width="" border="0">
			
<br>
<h5 style="font-size:18px;"> '.$exam_name.'- '.$adm_batch.'</h5>
				</td>
				<td width="120" align="right" valign="middle" style="text-align:center;padding-top:10px;">
				<span style="border:0px solid #333;padding:10px;"><strong>Hall No :</strong>_______</span></td>

				<tr>
				<td></td>
				<td align="center" style="text-align:center;margin:0;padding:0"><h4 style="font-size:18px;">Attendance Sheet</h4></td>
				<td></td>
				</tr>
				</table>';
//echo $header;
				$content .='
				<h3 style="font-size:15px;margin-left:20px;"> Department :'.$deptname.'</h3>
				<table border="0" cellspacing="5" cellpadding="5" class="content-table" width="900"  style="; position: relative;">
			
				<tr>
				<th width="50" height="30">Sr No.</th>
				<th>Admission Ticket No.</th>
				<th align="left">Name of the Candidate</th>
				<th>Ans.Booklet No</th>
				<th>Candidate.Sign</th>
				</tr>';
			
				$j=1;
			//	if(!empty($studlist)){
					foreach($studphd as $stud){
						//echo $stud['enrollment_no'];
			            $reg_no = $stud['phd_reg_no'];
						$content .='<tr>
						<td height="10" align="center">'.$j.'</td>
						<td>'.$reg_no.'</td>
						<td>'.$stud['student_name'].'</td>
						<td></td>
						<td></td>
						</tr>';
			
						$j++;
					}
		//		
			
       
				$content .='</table>';	
			
				$footer .='<table width="900" border="1" cellspacing="0" cellpadding="0" align="center" style="margin:0px;">
				<tr>
				<td align="center">
				<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" >
  
  	<tr>
  	<td colspan="4">
  	</td>
  		</tr>
				<tr>
				<td align="center" class="signature" valign="bottom"><strong>Present :</strong></td>
    
				<td align="center"  class="signature" valign="bottom"><strong>Absent :</strong></td>
   
				<td align="center" class="signature" valign="bottom"><strong>Total :</strong></td>
    	<td valign="bottom" align="center" width="150" class="signature"  style=""><strong>Invigilator Name</strong></td>
				<td valign="bottom" align="center" width="150" class="signature"  style="border-top:1px solid #000;padding-top:5px;"><strong>Invigilator Signature</strong></td>
   
				</tr>
				</table>

				</td>
				</tr>
				</table>
				<div align="center"><small><b>{PAGENO}</b></small></div>';	

				//$this->m_pdf->pdf->AddPage(); 			 
				//ob_clean();
				$this->m_pdf->pdf->PageNumSubstitutions[] = [
					'from' => 1, 
					'reset' => 0, 
					'type' => 'I', 
					'suppress' => 'off'
				];
				$this->m_pdf->pdf->defaultfooterline = false;
				$header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLHeader($header1);		
				$this->m_pdf->pdf->SetHTMLFooter($footer);
				//$this->m_pdf->pdf->setFooter('{PAGENO}');
				$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->AddPage();
			
		
				$this->m_pdf->pdf->WriteHTML($content);
				//$footer = $this->load->view($this->view_dir.'attendance_footer', $this->data, true);	
				
				unset($header1);
				unset($header);
				unset($content);
				unset($footer);
				unset($studlist);

 	
				ob_clean();
		
			$pdfFilePath1 ="Attendance Sheet.pdf";			
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
			//ob_clean();
	
	    
	}
	
	
    
    
    
    
    
    //for bulk phd_reg_no
    public function generate_phd_reg()
    {
        
	 $this->Phd_model->generate_phd_reg();
        
        
    }
//for bulk single
     public function generate_phd_regsingle($phd_id)
    {
        
 		$this->Phd_model->generatesingle_phd_reg($phd_id);
        
        
    }
    
    
    
	
	
		public function send_admit_card_all()
{
     $phd  = $this->Phd_model->appli_details_all();
   
   foreach($phd as $phd)
   {
          $this->data['students'] = $this->Phd_model->appli_details($phd['phd_id']);
          $this->data['doc'] = $this->Phd_model->phd_cand_photo($phd['phd_id']);
          
          $subject="Sandip University Ph.D. 2018 online registration";
$message ="Dear ".$phd['student_name']."
Your Ph.D. 2018 online registration done successfully
Please find the below details

For any queries mail to deanresearch@sandipuniversity.edu.in

Thanks
Sandip University
";



$email = new PHPMailer();

$email->Host = 'smtp.gmail.com';                 // Specify main and backup server
$email->Port = 587;                                    // Set the SMTP port
$email->SMTPAuth = true;                               // Enable SMTP authentication
$email->Username = 'developers@sandipuniversity.com';                // SMTP username
$email->Password = 'university@24';                  // SMTP password
$email->SMTPSecure = 'tls';       

$email->From = 'developers@sandipuniversity.com';
$email->FromName = 'Sandip University';
$email->Subject = "Sandip University PhD 2018 Online Registration";
$email->Body = $message;
$email->AddAddress($phd['email_id']);
$email->AddBCC('jugal.singh@carrottech.in');
//$email->AddBCC('hardik.gosavi@sandipuniversity.edu.in');
$email->AddBCC('arvind.thasal@carrottech.in');
//$email->AddBCC('pramod.karole@gmail.com');


$file_to_attach = $_SERVER['DOCUMENT_ROOT'] . '/erp/phd_admit_cards/Admit_Card_'.$phd['phd_id'].'.pdf';

$email->AddAttachment($file_to_attach, 'receipt_' . $user_id . '.pdf');



//return $email->Send();
          
          
    /* $html =  $this->load->view($this->view_dir.'phd',$this->data,true);
     
      $this->load->library('M_pdf');
        $mpdf=new mPDF('utf-8', 'A4');
          $mpdf=new mPDF('','', 0, '', 15, 15, 15,0, 0, 0,'L');
			
			
		$stylpath = base_url() . "css/style.css";
			$bootpath = base_url() . "css/bootstrap.css";
		    $fontpath = base_url() . "css/font-awesome.css";
		///	$mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
		//	$mpdf->SetHTMLFooter('<br><div class="row xbottom-text" style="margin-bottom:10px;height:30px;"></div>');
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$mpdf->WriteHTML($html);
			$mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/phd_admit_cards/Admit_Card_'.$phd['phd_id'].'.pdf', 'F'); */  
   }
    
}



	
	public function  send_sms_all()
	{
	  $phd  = $this->Phd_model->appli_details_all();
	  
	    //$phd  = $this->Phd_model->appli_details_one();
	    
	    
 foreach($phd as $phd)
   {
       
	$user_mobile = $phd['mobile_no'];
//$user_mobile = "8169767169";//$udf4;	
       $ch = curl_init();
   
   
   $sms=urlencode("Dear ".$phd['student_name']."
Sandip University SUNPET-2019 exam is scheduled on 3rd March, 2019 from 12:30 pm to 02:30 pm. 
Your Admit Card No:".$phd['phd_reg_no']."
Venue of the exam:O-Building,Sandip university,Nashik.
Download your hall ticket at http://www.sandipuniversity.edu.in/sunpet/admitcard/".$phd['phd_id'].".pdf 
All the best");


 $query="?username=u4282&msg_token=j8eAyq&sender_id=SANDIP&message=$sms&mobile=$user_mobile";
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL,'http://bulksms.omegatelesolutions.com/api/send_transactional_sms.php' . $query); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
      $res = trim(curl_exec($ch));     
curl_close($ch);
echo $sms;
//exit();

    

   }	  
	  
	}
	
	
	
	
		public function phd_results()
{
   //  error_reporting(E_ALL);
  // ini_set('display_errors', 1);
    $this->load->view('header',$this->data);    
  $this->data['phd_data']  = $this->Phd_model->phd_results($exam='August-2018');
   
     $this->load->view($this->view_dir.'results',$this->data);
  $this->load->view('footer',$this->data);    
 
}

	
	
			public function phd_results_excel()
{
   //  error_reporting(E_ALL);
  // ini_set('display_errors', 1);
    $this->load->view('header',$this->data);    
  $this->data['phd_data']  = $this->Phd_model->phd_results($exam='August-2018');
   
     $this->load->view($this->view_dir.'phd_results_excel',$this->data);
  $this->load->view('footer',$this->data);    
 
}

	
	
	
			public function student_results_pdf($studid)
{
   //  error_reporting(E_ALL);
  // ini_set('display_errors', 1);
  $this->data['phd']  = $this->Phd_model->phd_results($exam='August-2018',$studid);
 //  echo $this->data['phd'][0]['student_name'];
  // exit();
   
    $html =  $this->load->view($this->view_dir.'phd_results',$this->data,true);
 //  echo $html;
   //  $html =  $this->load->view($this->view_dir.'phd_results',$this->data,true);
     
      $this->load->library('M_pdf');
        $mpdf=new mPDF('utf-8', 'A4');
          $mpdf=new mPDF('','', 0, '', 15, 15, 15,0, 0, 0,'L');
			
			
	//	$pdfFilePath = 'PHD18_Admission_form_'.$this->datab['students'][0]['prov_reg_no']. ".pdf";


			
			$stylpath = base_url() . "css/style.css";
			$bootpath = base_url() . "css/bootstrap.css";
		    $fontpath = base_url() . "css/font-awesome.css";
		///	$mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
		//	$mpdf->SetHTMLFooter('<br><div class="row xbottom-text" style="margin-bottom:10px;height:30px;"></div>');
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$mpdf->WriteHTML($html);
			$mpdf->Output($this->data['phd'][0]['student_name'].'.pdf', 'D');   
 
}
	
	
		public function results()
{
   //  error_reporting(E_ALL);
  // ini_set('display_errors', 1);
  $this->data['phd']  = $this->Phd_model->phd_results($exam='August-2018');
   
    $html =  $this->load->view($this->view_dir.'phd_results',$this->data,true);
 //  echo $html;
   //  $html =  $this->load->view($this->view_dir.'phd_results',$this->data,true);
     
      $this->load->library('M_pdf');
        $mpdf=new mPDF('utf-8', 'A4');
          $mpdf=new mPDF('','', 0, '', 15, 15, 15,0, 0, 0,'L');
			
			
	//	$pdfFilePath = 'PHD18_Admission_form_'.$this->datab['students'][0]['prov_reg_no']. ".pdf";


			
			$stylpath = base_url() . "css/style.css";
			$bootpath = base_url() . "css/bootstrap.css";
		    $fontpath = base_url() . "css/font-awesome.css";
		///	$mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
		//	$mpdf->SetHTMLFooter('<br><div class="row xbottom-text" style="margin-bottom:10px;height:30px;"></div>');
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$mpdf->WriteHTML($html);
			$mpdf->Output('SUNPET-Aug2018-Results.pdf', 'D');   
 
}

	
	
	
	
	
	
	
	
	
	
	
public function generate_admit_card_all()
{
   //  error_reporting(E_ALL);
  // ini_set('display_errors', 1);
  $phd  = $this->Phd_model->appli_details_all();

   
   foreach($phd as $phd)
   {
          $this->data['students'] = $this->Phd_model->appli_details($phd['phd_id']);
          $this->data['doc'] = $this->Phd_model->phd_cand_photo($phd['phd_id']);
          
     $html =  $this->load->view($this->view_dir.'phd',$this->data,true);

      	$this->load->library('M_pdf');
        $mpdf=new mPDF('utf-8', 'A4');
          $mpdf=new mPDF('','', 0, '', 15, 15, 15,0, 0, 0,'L');

          /*$this->load->library('M_pdf');
           $mpdf= new mPDF('utf-8', 'A4', '15', '15', '15', '15', '50', '35');*/
			
			
	//	$pdfFilePath = 'PHD18_Admission_form_'.$this->datab['students'][0]['prov_reg_no']. ".pdf";


			
			$stylpath = base_url() . "css/style.css";
			$bootpath = base_url() . "css/bootstrap.css";
		    $fontpath = base_url() . "css/font-awesome.css";
		///	$mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
		//	$mpdf->SetHTMLFooter('<br><div class="row xbottom-text" style="margin-bottom:10px;height:30px;"></div>');
			//$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$mpdf->WriteHTML($html);
			   $mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/uploads/payment/phdadmitcard_2019/'.$phd['phd_id'].'.pdf', 'F');
			      //$mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/uploads/payment/phdadmitcard_2019/' . $stdata . '.pdf', 'F');
			//$mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/phd_admit_cards/'.$phd['phd_id'].'.pdf', 'F');   
   }
}


public function generate_admit_card_single($phdid)
{
   //  error_reporting(E_ALL);
  // ini_set('display_errors', 1);
  $phd  = $this->Phd_model->appli_details_single($phdid);

   
   foreach($phd as $phd)
   {
          $this->data['students'] = $this->Phd_model->appli_details($phd['phd_id']);
          $this->data['doc'] = $this->Phd_model->phd_cand_photo($phd['phd_id']);
          
     $html =  $this->load->view($this->view_dir.'phd',$this->data,true);

      	$this->load->library('M_pdf');
        $mpdf=new mPDF('utf-8', 'A4');
          $mpdf=new mPDF('','', 0, '', 15, 15, 15,0, 0, 0,'L');

          /*$this->load->library('M_pdf');
           $mpdf= new mPDF('utf-8', 'A4', '15', '15', '15', '15', '50', '35');*/
			
			
	//	$pdfFilePath = 'PHD18_Admission_form_'.$this->datab['students'][0]['prov_reg_no']. ".pdf";


			
			$stylpath = base_url() . "css/style.css";
			$bootpath = base_url() . "css/bootstrap.css";
		    $fontpath = base_url() . "css/font-awesome.css";
		///	$mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
		//	$mpdf->SetHTMLFooter('<br><div class="row xbottom-text" style="margin-bottom:10px;height:30px;"></div>');
			//$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$mpdf->WriteHTML($html);
			   $mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/uploads/payment/phdadmitcard_2019/'.$phd['phd_id'].'.pdf', 'F');
			      //$mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/uploads/payment/phdadmitcard_2019/' . $stdata . '.pdf', 'F');
			//$mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/phd_admit_cards/'.$phd['phd_id'].'.pdf', 'F');   
   }
}

	

	
	
	
	
	
public function generate_admit_card($empid)
{
   //  error_reporting(E_ALL);
  // ini_set('display_errors', 1);
          $this->data['students'] = $this->Phd_model->appli_details($empid);
          $this->data['doc'] = $this->Phd_model->phd_cand_photo($empid);
          
     $html =  $this->load->view($this->view_dir.'phd',$this->data,true);
    // echo $html;
    // exit();
      $this->load->library('M_pdf');
        $mpdf=new mPDF('utf-8', 'A4');
          $mpdf=new mPDF('','', 0, '', 15, 15, 15,0, 0, 0,'L');
			
			
	//	$pdfFilePath = 'PHD18_Admission_form_'.$this->datab['students'][0]['prov_reg_no']. ".pdf";


			
			$stylpath = base_url() . "css/style.css";
			$bootpath = base_url() . "css/bootstrap.css";
		    $fontpath = base_url() . "css/font-awesome.css";
		///	$mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
		//	$mpdf->SetHTMLFooter('<br><div class="row xbottom-text" style="margin-bottom:10px;height:30px;"></div>');
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$mpdf->WriteHTML($html);
				$mpdf->Output('Admit_Card'.$empid.'.pdf', 'D');  
		//	$mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/phd_admit_cards/Admit_Card'.$empid.'.pdf', 'D');   
}



	
	
public function search_reg()
{
      $this->data['phd_data'] = $this->Phd_model->phd_listing();    
   echo  $this->load->view($this->view_dir.'ajax_phd_list',$this->data);
}
 public function update_payment_status()
{
       $this->Phd_model->update_payment_status();    
    
}	
 	
 public function update_verification_status()
{
       $this->Phd_model->update_verification_status(); 

       $this->generate_admit_card_single($_POST['reg_id']);

        redirect('phd/documents/'.$_POST['reg_id']);   
    
}	


	    public function documents($appid)
    {
        global $model;
        $this->load->view('header',$this->data);    
         $this->data['documents']= $this->Phd_model->documents($appid);
          $this->data['appli']= $this->Phd_model->appli_details($appid);
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'documents',$this->data);
        $this->load->view('footer');
    }
	
	
	  public function student_payment_history()
    {
        global $model;
        $this->load->view('header',$this->data);    
         $this->data['pay_list']= $this->Online_feemodel->student_payment_history();
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'student_payment_history',$this->data);
        $this->load->view('footer');
    }
	

	function load_feelist()
	{
	    
	      $data['emp_list']= $this->Online_feemodel->getFeesajax();
	      // $data['dcourse']= $_POST['astream'];
	      //  $data['dyear']= $_POST['ayear'];
	      
	      $html = $this->load->view($this->view_dir.'load_feedata',$data,true);
	  echo $html;
	}
	
	function update_fstatus()
	{
	  $this->Online_feemodel->update_feestatus();  
	 echo "Y";   
	}
	
	
		function remove_list()
	{
	  $this->Online_feemodel->remove_list();  
	 echo "Y";   
	}
	

	
function fetch_feedet()
{
     $this->Online_feemodel->fetch_feedet();
}
	
	//below code is added by ranjan
	public function online_fees()
    {
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==40){
		}else{
			redirect('home');
		}
		//error_reporting(E_ALL);ini_set('display_errors', 1);
        $this->load->view('header',$this->data);    
        $this->data['phd_stud_list']= $this->Phd_model->getphdstdonlineFeesdata();       
        $this->load->view($this->view_dir.'phd_online_fees',$this->data);
        $this->load->view('footer');
    }
	
	function load_phd_feelist()
	{
	    
	      $data['phd_stud_list']= $this->Phd_model->getphdstdonlineFeesdata();
	      // $data['dcourse']= $_POST['astream'];
	       // $data['pstatus']= $_POST['pstatus'];
	      
	      $html = $this->load->view($this->view_dir.'load_phdfeedata',$data,true);
	  echo $html;
	}
	
	function update_phdfstatus()
	{
	  $this->Phd_model->update_phdfeestatus();  
	 echo "Y";   
	}
	
	//below code is added by bala 29-03-19
	public function cumulative_report()
    {
		//error_reporting(E_ALL);ini_set('display_errors', 1);
        $this->load->view('header',$this->data);    
        $this->data['phd_data']= $this->Phd_model->camulative_report();       
        $this->load->view($this->view_dir.'phd_cumulative_report',$this->data);
        $this->load->view('footer');
    }	
	
	
	public function External_challan(){
		
		//echo 'TEts';
		$this->load->model('Challan_model');
		//$this->load->model($this->model_name);
	    global $model;
        $this->load->view('header',$this->data);    
		 $recepit=$this->uri->segment(3);
		 $this->data['productinfo']=$this->uri->segment(4);
		//exit();
		$this->data['user_details']=$this->Phd_model->get_details($recepit);
		$dats=$this->data['user_details'];
		//print_r($this->data['user_details']);
		//exit();
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		//$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		
		//if(($dats[0]['admission_cycle']=="")||($dats[0]['admission_cycle']==NULL)){
			//print_r($this->data['user_details']);
		//exit();
		$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->load->view($this->view_dir.'External_challan',$this->data);
		//}else{
		//$this->data['examsession']=$this->Challan_model->get_examsession_phd();
		//$this->load->view($this->view_dir.'add_fees_challan_details_new_phd',$this->data);
		//}
        $this->load->view('footer');
	}
	
	public function generate_hall_ticket($empid='')
{
    // error_reporting(E_ALL);
  // ini_set('display_errors', 1);
		  $studdata=$_POST['studdata'];
     foreach($studdata as $empid){
		  $is_mailsend=$this->Phd_model->set_is_mailsend_status($empid);
          $this->data['students'] = $this->Phd_model->appli_details($empid);
          $this->data['doc'] = $this->Phd_model->phd_cand_photo($empid);
          
     $html =  $this->load->view($this->view_dir.'phd_hall_ticket_sum',$this->data,true);
     
      $this->load->library('M_pdf');
        $mpdf=new mPDF('utf-8', 'A4');
          $mpdf=new mPDF('','', 0, '', 15, 15, 10,0, 0, 0,'L');
			 $mpdf->SetFont('monotypecorsiva');
			 $mpdf->curlAllowUnsafeSslRequests = true;
			
	//	$pdfFilePath = 'PHD18_Admission_form_'.$this->datab['students'][0]['prov_reg_no']. ".pdf";

            //echo '<pre>';
			//print_r( $this->data['students']['email_id'] );exit;
			$std_email = $this->data['students']['email_id'];
			$std_name  = $this->data['students']['student_name'];
			//$pdfFilePath ='HallTicket'.$empid.'.pdf';
			$stylpath = base_url() . "css/style.css";
			$bootpath = base_url() . "css/bootstrap.css";
		    $fontpath = base_url() . "css/font-awesome.css";
		///	$mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
		//	$mpdf->SetHTMLFooter('<br><div class="row xbottom-text" style="margin-bottom:10px;height:30px;"></div>');
		    //$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$mpdf->WriteHTML($html);
            //$mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/uploads/question_papper/'.$pdfFilePath, 'F');
			 $pdfData = $mpdf->Output('', 'S');
            $file ='HallTicket'.$empid.'.pdf';						  
            //$subject='Sandip University, Ph.D. Entrance Hall Ticket -JULY-2024';          
            $subject='Sandip University, Ph.D. Entrance Hall Ticket -JAN-2025';          
            $body="Dear ".$this->data['students']['student_name'].", 
                    Please find the attached Hall Ticket.";
           // $file=$_SERVER['DOCUMENT_ROOT'] . "/uploads/question_papper/".$pdfFilePath;
			 //$this->sendattachedemail($body,$email=$this->data['students']['email_id'],$subject,$file);
			 $this->sendattachedemail($body,$std_email,$subject,$file,$std_name,$pdfData);
             sleep(5);
		    $mpdf->Output('HallTicket'.$empid.'.pdf', 'D');  
		//	$mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/phd_admit_cards/Admit_Card'.$empid.'.pdf', 'D');
			
   }
}
public function generate_hall_ticket_sum($empid='')
{
    // error_reporting(E_ALL);
  // ini_set('display_errors', 1);
		  $studdata=$_POST['studdata'];
     //foreach($studdata as $empid){
		  $is_mailsend=$this->Phd_model->set_is_mailsend_status($empid);
          $this->data['students'] = $this->Phd_model->appli_details($empid);
          $this->data['doc'] = $this->Phd_model->phd_cand_photo($empid);
          
     $html =  $this->load->view($this->view_dir.'phd_hall_ticket_sum',$this->data,true);
     
      $this->load->library('M_pdf');
        $mpdf=new mPDF('utf-8', 'A4');
          $mpdf=new mPDF('','', 0, '', 15, 15, 10,0, 0, 0,'L');
			 $mpdf->SetFont('monotypecorsiva');
			 $mpdf->curlAllowUnsafeSslRequests = true;
			
	//	$pdfFilePath = 'PHD18_Admission_form_'.$this->datab['students'][0]['prov_reg_no']. ".pdf";

            //echo '<pre>';
			//print_r( $this->data['students']['email_id'] );exit;
			$std_email = $this->data['students']['email_id'];
			$std_name  = $this->data['students']['student_name'];
			//$pdfFilePath ='HallTicket'.$empid.'.pdf';
			$stylpath = base_url() . "css/style.css";
			$bootpath = base_url() . "css/bootstrap.css";
		    $fontpath = base_url() . "css/font-awesome.css";
		///	$mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
		//	$mpdf->SetHTMLFooter('<br><div class="row xbottom-text" style="margin-bottom:10px;height:30px;"></div>');
		    //$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$mpdf->WriteHTML($html);
            //$mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/uploads/question_papper/'.$pdfFilePath, 'F');
			 $pdfData = $mpdf->Output('', 'S');
            $file ='HallTicket'.$empid.'.pdf';						  
            //$subject='Sandip University, Ph.D. Entrance Hall Ticket -JULY-2024';          
            $subject='Sandip University, Ph.D. Entrance Hall Ticket -JULY-25';          
            $body="Dear ".$this->data['students']['student_name'].", 
                    Please find the attached Hall Ticket.";
           // $file=$_SERVER['DOCUMENT_ROOT'] . "/uploads/question_papper/".$pdfFilePath;
			 //$this->sendattachedemail($body,$email=$this->data['students']['email_id'],$subject,$file);
			 $this->sendattachedemail($body,$std_email,$subject,$file,$std_name,$pdfData);
             sleep(5);
		    $mpdf->Output('HallTicket'.$empid.'.pdf', 'D');  
		//	$mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/phd_admit_cards/Admit_Card'.$empid.'.pdf', 'D');
			
   //}
}
 public function sendattachedemail($body,$email,$subject,$file,$std_name,$pdfData='')
    {
		//$email='coe@sandipuniversity.edu.in';
        $path = $_SERVER["DOCUMENT_ROOT"] . '/application/third_party/';
		require_once($path . 'PHPMailer/class.phpmailer.php');
		date_default_timezone_set('Asia/Kolkata');
		require_once(APPPATH . "third_party/PHPMailer/PHPMailerAutoload.php");


        //echo $file; exit;
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();


        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        //$mail->SMTPDebug = 4;
        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 465;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        //Username to use for SMTP authentication
        $mail->Username   = 'noreply6@sandipuniversity.edu.in';          // SMTP username
        $mail->Password   = 'mztv pmkl amlh jtac';
		$mail->setFrom('noreply7@sandipuniversity.edu.in');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to
        //$mail->addAddress('saurabh.singh@sandipuniversity.edu.in', 'Saurabh');
		 //$mail->AddCC('balasaheb.lengare@carrottech.in', 'Balasaheb');
		 $mail->AddCC('erp.support@sandipuniversity.edu.in', 'Balasaheb');
		//$mail->AddCC('coe@sandipuniversity.edu.in', 'COE');
        //$mail->AddCC('sun.phd@sandipuniversity.edu.in', 'SUN PHD');
        $mail->AddCC('research.sijoul@sandipuniversity.edu.in', 'SUM PHD');
        $mail->addAddress($email,$std_name);

        //$mail->AddAddress('pramod.karole@sandipuniversity.edu.in', 'Pramod');
        //Set the subject line
        $mail->Subject = $subject;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
        //Replace the plain text body with one created manually

        $mail->Body = $body;


        $mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        
        //$mail->AddAttachment($file);
		$mail->addStringAttachment($pdfData, $file, 'base64', 'application/pdf');				  
        //send the message, check for errors
        if (!$mail->send()) {
             //echo 1 ; exit;
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
             //echo 11 ; exit;
            echo 'Message sent!';
        }
    }
	
   function add_sunpet_marks(){
	
		$data['phd_id']=$_POST['phd_id'];
		$data['academic_year']=$_POST['academic_year'];
		$data['entrance_marks']=$_POST['entrance_marks'];
		$data['interview_marks']=$_POST['interview_marks'];
		$data['final_marks']=$_POST['final_marks'];
		$data['phd_reg_no']=$_POST['phd_reg_no'];  	
        $entry=$this->Phd_model->insert_sunpet_marks($data);   	
		echo json_encode($entry);
        } 	
		
     public function get_sunpet_marks_details()	
	 {
	   	$phd_id=$_POST['phd_id'];
		$academic_year=$_POST['academic_year'];
		$fetch_data=$this->Phd_model->fetch_sunpet_marks_entry($phd_id,$academic_year);
		echo json_encode($fetch_data);       		
	 }
	 
  
   public function sunpet_student_results_pdf($phd_id,$acad_year)
{
  $this->data['phd']  = $this->Phd_model->sunpet_phd_results($phd_id,$acad_year);

    $html =  $this->load->view($this->view_dir.'sunpet_phd_results',$this->data,true);
	
      $this->load->library('M_pdf');
        $mpdf=new mPDF('utf-8', 'A4');
          $mpdf=new mPDF('','', 0, '', 15, 15, 15,0, 0, 0,'L');
			
			$stylpath = base_url() . "css/style.css";
			$bootpath = base_url() . "css/bootstrap.css";
		    $fontpath = base_url() . "css/font-awesome.css";
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$mpdf->WriteHTML($html);
			$mpdf->Output($this->data['phd'][0]['student_name'].'.pdf', 'D');    
 
   } 	
	
	
	
}
?>