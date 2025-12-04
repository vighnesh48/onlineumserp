<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(E_ALL); ini_set('display_errors', 1); 
class Erp_cron extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guseride/general/urls.html
     */
    function __construct() {
        parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->Model('Erp_cron_model');
       
		//$this->data['currentModule']= 'Home';
		
    }

    public function Timetable_entry_notdone() 
    {
        $this->load->Model('Erp_cron_model');
        $this->data['academic_session']=$this->Erp_cron_model->getsession();
        $academic_session= $this->data['academic_session'];
        $ac_session=$academic_session[0]['academic_session'];
        $this->data['ac_session']=$academic_session[0]['academic_session'];
        $acadyear=$academic_session[0]['academic_year'];
        $this->data['acadyear']=$acadyear;
        $get_session=substr($ac_session,0,3);
        $this->data['get_session']=$get_session;
        $student_academicy=explode('-',$acadyear);
         $this->data['student_academicy']=$student_academicy;
        $this->data['school_details']=$this->Erp_cron_model->getsschool_details();
        $school_details=$this->data['school_details'];

        $this->data['TimetableEntryReport']=$this->Erp_cron_model->TimetableEntryReport($student_academicy[0],$acadyear,$get_session);
        $TimetableEntryReport=$this->data['TimetableEntryReport'];
       $first_yr_streams= array('5','6','7','8','10','11','96','97','107','108','109','158','159');
       $diploma_stream=array('71');
        //$subjectname ="";
        /******************view logic ******************/
        if(!empty($school_details))
        {
           for($i=0;$i<count($school_details);$i++)
            {
              

                $schoolid=$school_details[$i]["school_code"];
                $streamid=$school_details[$i]["stream"];
                $email=$school_details[$i]["email"];

                $school_name=$schoolid."-".$school_details[$i]["school_name"];
                $this->data['school_name']=$school_name;
                 $school_short_name=$schoolid."-".$school_details[$i]["school_short_name"]."_Timetable_not assigned";
                $streamarray=explode(',',$streamid);
                if(!empty($TimetableEntryReport))
                {
                    $pdfarray=array();
                    foreach($TimetableEntryReport as $tt)
                    {
            
                        if($tt['school_code']==$schoolid && in_array($tt['admission_stream'], $streamarray))
                        {
                           

                            if($tt['current_semester']=='1' && in_array($tt['admission_stream'],$first_yr_streams)){
                                echo "";
                            }
                            else if($tt['current_semester']=='2' && !in_array($tt['admission_stream'],$diploma_stream))
							{
								echo "";
							}
                            else
                            {
                                $pdfarray[]=array($tt['school_code'],$tt['stream_name'],
                                                $tt['current_semester'],$tt['entry_status']
                                            );
                            }         
                        }

                        
                
                     //$k++;
                    }//end of loop

                    //pdf and email logic
                    //error_reporting(E_ALL);
                   if(!empty($pdfarray))
                   {
                        $this->data['pdfarray']=$pdfarray;
                        $stdata=$schoolid.'_timetablenotdone';
                        //$this->load->view('erp_cron/acadmic_time_table_entry',$this->data);
                        $this->load->library('M_pdf');
                        $mpdf= new mPDF('utf-8', 'A4', '15', '15', '15', '15', '50', '35');
                        $html = $this->load->view('erp_cron/acadmic_time_table_entry', $this->data, true);
                        $mpdf->autoScriptToLang = true;
                        $mpdf->baseScript = 1;  // Use values in classes/ucdn.php  1 = LATIN
                        $mpdf->autoVietnamese = true;
                        $mpdf->autoArabic = true;
                        $mpdf->autoLangToFont = true;
                        $mpdf->SetMargins(10,10,15);
                        $mpdf->SetDisplayMode('fullpage');

                        /*$mpdf->SetHTMLHeader('
                        <div style="text-align: right; font-weight: bold;">
                            My document
                        </div>');*/
                        $mpdf->SetHTMLFooter('
                        <table width="100%">
                            <tr>
                                <td width="33%">{DATE j-m-Y}</td>
                                <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                                <td width="33%" style="text-align: right;"></td>
                            </tr>
                        </table>');
                        //$mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
                        //$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
                        $mpdf->WriteHTML($html);
                        $mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/uploads/payment/time_table_notdone/' . $stdata . '.pdf', 'F');
                        //$mpdf->Output($pdfFilePath, "I");
                        $subject='Timetable not done';
                        $file=$_SERVER['DOCUMENT_ROOT'] . "/erp/uploads/payment/time_table_notdone/" . $stdata . ".pdf";
                        sleep(5);
                        $body="Hello, <br/>
                            pls find the attached file of Timetable not done.";
                        $this->sendattachedemail($body,$email='pramod.karole@sandipuniversity.edu.in',$subject,$file);
                        sleep(5);
                       
                    }
                    else
                    {
                        echo "not done";
                    }
                    

                    //end of pdf

                }//end of  if
                else
                {
                    $html = "<tr><td colspan=4>No data found.</td></tr>";
                }
            }
        }//end of main if
        else
        {
            echo "No data found";
        }        
    }//end of function

    /********************faculty Not assigned **************/
    public function streamnotallocated_to_faculty() 
    {  
          //error_reporting(E_ALL);
        $this->load->Model('Erp_cron_model');
        $academic_session=$this->Erp_cron_model->getsession();
        $ac_session=$academic_session[0]['academic_session'];
        $acadyear=$academic_session[0]['academic_year'];
        $get_session=substr($ac_session,0,3);
        $student_academicy=explode('-',$acadyear);
       $school_details=$this->Erp_cron_model->getsschool_details();
       $streamnotallocated_to_faculty=$this->Erp_cron_model->streamnotallocated_to_faculty($student_academicy[0],$acadyear,$get_session);
     
       // print_r($streamnotallocated_to_faculty);
       // die;
          
 	      $diploma_stream=array('71');
        if(!empty($school_details))
        {
            for($i=0;$i<count($school_details);$i++)
            {
                $schoolid=$school_details[$i]["school_code"];
                $streamid=$school_details[$i]["stream"];
                $school_name=$schoolid."-".$school_details[$i]["school_name"];
                $this->data['school_name']=$school_name;
                $school_short_name=$schoolid."-".$school_details[$i]["school_short_name"]."_faculty_not_assign";
                
                $streamarray=explode(',',$streamid);
                if(!empty($streamnotallocated_to_faculty))
                {
                    $pdfarray=array();
                    foreach($streamnotallocated_to_faculty as $tt)
                    {
            
                        if($tt['school_code']==$schoolid && in_array($tt['stream_id'], $streamarray))
                        {


                                if($tt['subject_code']== 'OFF'){
                                   $subjectname_code="OFF Lecture";
                                }else if($tt['subject_code']=='Library'){
                                    $subjectname_code= "Library";
                                }else if($tt['subject_code']== 'Tutorial'){
                                   $subjectname_code= "Tutorial";
                                }else if($tt['subject_code']== 'Tutor'){
                                    $subjectname_code= "Tutor";
                                }else if($tt['subject_code']== 'IS'){
                                   $subjectname_code= "Internet Slot";
                                }else if($tt['subject_code']== 'RC'){
                                    $subjectname_code= "Remedial Class";
                                }else if($tt['subject_code']== 'EL'){
                                  $subjectname_code= "Experiential Learning";
                                }else if($tt['subject_code']== 'SPS'){
                                  $subjectname_code= "Swayam Prabha Session";
                                }else if($tt['subject_code']== 'ST'){
                                 $subjectname_code= "Spoken Tutorial";
                                }else if($tt['subject_code']== 'FAM'){
                                   $subjectname_code= "Faculty Advisor Meet";
                                }else{
                                    $subjectname_code= $tt['sub_code'].' - '.$tt['subject_name'];
                                }
                                if($tt['subject_name']=='')
                                {
                                    $subname=$subjectname_code;

                                }
                                else
                                {
                                    $subname=$tt['subject_name'];
                                }
                            if($tt['semester']=='2' && !in_array($tt['stream_id'],$diploma_stream))
							{
								echo "";
							}
							else
							{
								$pdfarray[]=array($tt['school_code'],$subjectname_code,
                                    $subname,$tt['stream_name'],$tt['semester'],
                                    $tt['division'],$tt['batch_no'],$tt['faculty_code']
                                );
							}

                                
                           

                                     
                        }
                        

                        
                
                     //$k++;
                    }//end of loop

                    //pdf and email logic
                    //error_reporting(E_ALL);
                   if(!empty($pdfarray))
                   {
                        $stdata=$school_short_name;
                        //$this->load->view('erp_cron/acadmic_time_table_entry',$this->data);
                        $this->data['pdfarray']=$pdfarray;
                        $this->load->library('M_pdf');
                        $mpdf= new mPDF('utf-8', 'A4', '15', '15', '15', '15', '50', '35');
                        $html=$this->load->view('erp_cron/streamnotallocated_to_faculty', $this->data, true);
                        $mpdf->autoScriptToLang = true;
                        $mpdf->baseScript = 1;  // Use values in classes/ucdn.php  1 = LATIN
                        $mpdf->autoVietnamese = true;
                        $mpdf->autoArabic = true;
                        $mpdf->autoLangToFont = true;
                        $mpdf->SetMargins(10,10,15);
                        $mpdf->SetDisplayMode('fullpage');

                        /*$mpdf->SetHTMLHeader('
                        <div style="text-align: right; font-weight: bold;">
                            My document
                        </div>');*/
                        $mpdf->SetHTMLFooter('
                        <table width="100%">
                            <tr>
                                <td width="33%">{DATE j-m-Y}</td>
                                <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                                <td width="33%" style="text-align: right;"></td>
                            </tr>
                        </table>');
                        //$mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
                        //$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
                        $mpdf->WriteHTML($html);
                        $mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/uploads/payment/faculty_not_allocated/' . $stdata . '.pdf', 'F');
                        //$mpdf->Output($pdfFilePath, "I");
                        $subject='Faculty not allocated';
                        $file=$_SERVER['DOCUMENT_ROOT'] . "/erp/uploads/payment/faculty_not_allocated/" . $stdata . ".pdf";
                        sleep(5);
                        $body="Hello, <br/> 
                            Pls find the attached file of Faculty not allocated.";
                        $this->sendattachedemail($body,$email='pramod.karole@sandipuniversity.edu.in',$subject,$file);
                        sleep(5);

                       

                   }
                   else
                   {
                    echo "not";
                   }
                       
                        
                    //end of pdf

                }//end of  if
                else
                {
                    $html = "<tr><td colspan=4>No data found.</td></tr>";
                }
            }//end of main loop
        }//end of main if
        else
        {
            echo "No data found";
        }

    }//end of main function


    /********************subject  Not allocated **************/
    public function subject_Not_allocated() 
    { 

        $academic_session=$this->Erp_cron_model->getsession();
        $ac_session=$academic_session[0]['academic_session'];
        $acadyear=$academic_session[0]['academic_year'];
        
        $get_session=substr($ac_session,0,3);
        $student_academicy=explode('-',$acadyear);
       
        $school_details=$this->Erp_cron_model->getsschool_details();
        $subjectnotallocated_to_student=$this->Erp_cron_model->subjectnotallocated_to_student($student_academicy[0]);
        $streamarraybetech_firstsems=array('5','6','7','8','9','10','11','96','97','107','108','109','158','159');
         $diploma_stream=array('71');
        if(!empty($school_details))
        {
            for($i=0;$i<count($school_details);$i++)
            {
                $schoolid=$school_details[$i]["school_code"];
                $streamid=$school_details[$i]["stream"];
                $school_name=$schoolid."-".$school_details[$i]["school_name"];
                $this->data['school_name']=$school_name;
                $school_short_name=$schoolid."-".$school_details[$i]["school_short_name"]."_subject_not assigned";
                
                $streamarray=explode(',',$streamid);
                if(!empty($subjectnotallocated_to_student))
                {
                    $pdfarray=array();
                    foreach($subjectnotallocated_to_student as $tt)
                    {
            
                        if($tt['school_code']==$schoolid && in_array($tt['admission_stream'], $streamarray) )
                        {
                        	if(in_array($tt['admission_stream'], $streamarraybetech_firstsems) && ($tt['current_semester']=='1'))
                        	{
                        		echo "not added";
                        	}
                        	else if($tt['current_semester']=='2' && !in_array($tt['admission_stream'],$diploma_stream))
							{
								echo "";
							}
                        	else
                        	{
                        		 $pdfarray[]=array(
                                    $tt['stream_name'],$tt['current_semester']
                                
                                );
                        	}                  
                    	}
                        

                        
                
                     //$k++;
                    }//end of loop

                    //pdf and email logic
                    //error_reporting(E_ALL);
                   if(!empty($pdfarray))
                   {
                        $stdata=$school_short_name;
                        //$this->load->view('erp_cron/acadmic_time_table_entry',$this->data);
                        $this->data['pdfarray']=$pdfarray;
                        $this->load->library('M_pdf');
                        $mpdf= new mPDF('utf-8', 'A4', '15', '15', '15', '15', '50', '35');
                        $html=$this->load->view('erp_cron/subject_Not_allocated', $this->data, true);

                         $mpdf->autoScriptToLang = true;
                        $mpdf->baseScript = 1;  // Use values in classes/ucdn.php  1 = LATIN
                        $mpdf->autoVietnamese = true;
                        $mpdf->autoArabic = true;
                        $mpdf->autoLangToFont = true;
                        $mpdf->SetMargins(10,10,15);
                        $mpdf->SetDisplayMode('fullpage');

                        /*$mpdf->SetHTMLHeader('
                        <div style="text-align: right; font-weight: bold;">
                            My document
                        </div>');*/
                        $mpdf->SetHTMLFooter('
                        <table width="100%">
                            <tr>
                                <td width="33%">{DATE j-m-Y}</td>
                                <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                                <td width="33%" style="text-align: right;"></td>
                            </tr>
                        </table>');
                        //$mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
                        //$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
                        $mpdf->WriteHTML($html);
                        $mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/uploads/payment/subject_not_allocated/' . $stdata . '.pdf', 'F');
                        //$mpdf->Output($pdfFilePath, "I");
                         $subject='Subject not allocated';
                        $file=$_SERVER['DOCUMENT_ROOT'] . "/erp/uploads/payment/subject_not_allocated/" . $stdata . ".pdf";
                        sleep(5);
                        $body="Hello, <br/>
                            Pls find the attached file of Subject not allocated.";
                        $this->sendattachedemail($body,$email='pramod.karole@sandipuniversity.edu.in',$subject,$file);
                        sleep(5);
                        


                   }
                   else
                   {
                    echo "not";
                   }
                       
                        
                    //end of pdf

                }//end of  if
                else
                {
                    $html = "<tr><td colspan=4>No data found.</td></tr>";
                }
            }//end of main loop
        }//end of main if
        else
        {
            echo "No data found";
        }
    }
    //end of crons

    //email functionality
    public function sendattachedemail($body,$email='pramod.karole@sandipuniversity.edu.in',$subject,$file)
    {
        $path=$_SERVER["DOCUMENT_ROOT"].'/erp/application/third_party/';
        require_once($path.'PHPMailer/class.phpmailer.php');
        date_default_timezone_set('Asia/Kolkata');
         require_once(APPPATH."third_party/PHPMailer/PHPMailerAutoload.php");
        
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
        $mail->Host = 'ssl://mail360-smtp.zoho.in';
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 465;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        //Username to use for SMTP authentication
        $mail->Username = 'kishor.mehare@sandipuniversity.com';
        //Password to use for SMTP authentication
        //$mail->Password = '123Indi@';
        $mail->Password = 'M360.C6700px6B87mS70k71x6700q.b6ln7mkS873JKELo4Rggi775Fm087BkKCl25M07S';
        //Set who the message is to be sent from
        $mail->setFrom('kishor.mehare@sandipuniversity.com', '');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to
        $mail->addAddress('pramod.karole@sandipuniversity.edu.in', 'Pramod Karole');
        $mail->AddAddress('balasaheb.lengare@carrottech.in', 'balasaheb');
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
        
        $mail->AddAttachment($file);
        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message sent!';
        }
    } 


    
}
