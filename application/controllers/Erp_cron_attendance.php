<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
require_once APPPATH . 'controllers/Project.php'; // Include the parent controller
class Erp_cron_attendance extends Project {

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
		$this->load->library('Whatsapp_api');
		$this->load->Model('Erp_cron_attendance_model');
		$this->load->Model('Project_model');
		$this->load->library('m_pdf');
		//$this->data['currentModule']= 'Home';
		$this->load->Model('Student_Attendance_model');
    }

    public function student_attendance_reminder() 
    {
       $stddata=[];
       $stddata1=[];
//error_reporting(E_ALL); ini_set('display_errors', 1);
       
       $date='2024-09-03';
	   //$date=date('Y-m-d');
       $day=date('l',strtotime($date));
       $this->data['rdate'] = $date;
         $this->data['rday'] = $day;
        $academic_session= $this->Erp_cron_attendance_model->getsession();
        $acadsess=substr($academic_session[0]['academic_session'], 0, 3);
        $acadyear=$academic_session[0]['academic_year'];
$school_list = $this->Erp_cron_attendance_model->get_school_list();

foreach($school_list as $schval){
    //echo $schval['school_code'];
$stddata[$schval['school_name']]=[];
$cour_list = $this->Erp_cron_attendance_model->get_course_list_byschool($schval['school_code']);
foreach($cour_list as $crval){
    $stddata[$schval['school_name']]['courses'][$crval['course_name']]=[];
    //echo $crval['course_id'];
    //echo $crval['course_short_name'];
    $strm_list = $this->Erp_cron_attendance_model->get_stream_list($crval['course_id'],$schval['school_code']);

    foreach($strm_list as $strmval){
        $stddata[$schval['school_name']]['courses'][$crval['course_name']]['stream'][$strmval['stream_name']]=[];

        //$stddata[$crval['course_name']]['stream_name']=$strmval['stream_name'];
        $sem_list= $this->Erp_cron_attendance_model->get_semister($strmval['stream_id'],$acadyear,$acadsess);

        foreach($sem_list as $semval){
            $stddata[$schval['school_name']]['courses'][$crval['course_name']]['stream'][$strmval['stream_name']]['semsis'][$semval['semester']]=[];
        $div_list=$this->Erp_cron_attendance_model->get_division($strmval['stream_id'],$semval['semester'],$acadyear,$acadsess);
        
        foreach ($div_list as  $divval){
$stddata[$schval['school_name']]['courses'][$crval['course_name']]['stream'][$strmval['stream_name']]['semsis'][$semval['semester']]['divis'][$divval['division']]=[];

 $rowt=$this->Erp_cron_attendance_model->get_student_faculty_data($acadyear,$acadsess,$day,$strmval['stream_id'],$semval['semester'],$divval['division']);
         //exit; 
              foreach ($rowt as $key => $value) {
                # code...
      $rowa=$this->Erp_cron_attendance_model->get_student_attendance_data($acadyear,$acadsess,$date,$strmval['stream_id'],$semval['semester'],$divval['division'],$value['lecture_slot']);
         
     $cnt = count($rowa);
     if($cnt=='0'){
          $f[$schval['school_name']][]=1;
           $lv =$this->Erp_cron_attendance_model->check_leave($value['faculty_code'],$date);
           $hd= $this->Erp_cron_attendance_model->check_holidays($date,$value['staff_type']);
           if($hd=='true' || $hd=='RD'){
                $fr= "Holiday";
}else{
          if($lv!='N'){
            $fr= $lv;
          }else{
            $fr='';
          }
        }
            $stddata[$schval['school_name']]['courses'][$crval['course_name']]['stream'][$strmval['stream_name']]['semsis'][$semval['semester']]['divis'][$divval['division']][]=$value['subject_name']."/".$value['subject_type']."/".$value['from_time']."-".$value['to_time']."/".$value['fname']." ".$value['lname']."/".$fr;

     }

}
exit; 
//}else{
    //unset($stddata[$schval['school_name']]);
 //}
        }

        } // end of semister
        
    } // end of stream list
    
} // end of course list

if(count($f[$schval['school_name']])=='0'){
    $stddata[$schval['school_name']]['flag']='1';
}
} // end of school list
//echo "<pre>";
//print_r($stddata);exit;
       
//end of absent array

foreach($school_list as $schval){
    //echo $schval['school_code'];
$stddata1[$schval['school_name']]=[];
$cour_list = $this->Erp_cron_attendance_model->get_course_list_byschool($schval['school_code']);
foreach($cour_list as $crval){
    $stddata1[$schval['school_name']]['courses'][$crval['course_name']]=[];
    //echo $crval['course_id'];
    //echo $crval['course_short_name'];
    $strm_list = $this->Erp_cron_attendance_model->get_stream_list($crval['course_id'],$schval['school_code']);

    foreach($strm_list as $strmval){
        $stddata1[$schval['school_name']]['courses'][$crval['course_name']]['stream'][$strmval['stream_name']]=[];

        //$stddata[$crval['course_name']]['stream_name']=$strmval['stream_name'];
        $sem_list= $this->Erp_cron_attendance_model->get_semister($strmval['stream_id'],$acadyear,$acadsess);

        foreach($sem_list as $semval){
            $stddata1[$schval['school_name']]['courses'][$crval['course_name']]['stream'][$strmval['stream_name']]['semsis'][$semval['semester']]=[];
        $div_list=$this->Erp_cron_attendance_model->get_division($strmval['stream_id'],$semval['semester'],$acadyear,$acadsess);
       // echo "yy".count($div_list);echo"</br>";
        foreach ($div_list as  $divval){
$stddata1[$schval['school_name']]['courses'][$crval['course_name']]['stream'][$strmval['stream_name']]['semsis'][$semval['semester']]['divis'][$divval['division']]=[];

 $rowt=$this->Erp_cron_attendance_model->get_student_faculty_data_f($acadyear,$acadsess,$day,$strmval['stream_id'],$semval['semester'],$divval['division']);
       //echo "pp".count($rowt);
        //if(count($rowt)>'0'){  
              foreach ($rowt as $key => $value) {
                # code...
      $rowa=$this->Erp_cron_attendance_model->get_student_attendance_data_pre($acadyear,$acadsess,$date,$strmval['stream_id'],$semval['semester'],$divval['division'],$value['lecture_slot']);
        //  print_r($rowa);
        //  echo "<br>";
     //echo $rowa->row();
  $cnt = count($rowa);
     if($cnt != '0'){
       $f1[$schval['school_name']][]=1;
        foreach ($rowa as $keyr => $valuera) {
            # code...
       
            $stddata1[$schval['school_name']]['courses'][$crval['course_name']]['stream'][$strmval['stream_name']]['semsis'][$semval['semester']]['divis'][$divval['division']][]=$value['subject_name']."/".$value['subject_type']."/".$value['from_time']."-".$value['to_time']."/".$value['fname']." ".$value['lname']."/".$valuera['tpresent']."/".$valuera['tapsent']."/".$valuera['percen_lecturs'];
}
     }
     //else{
      // unset($f[$schval['school_name']]);
    // }

}
//}else{
   //  $f[$schval['school_name']][]=1;
 //}
        } //end of div

        } // end of semister
        
    } // end of stream list
    
} // end of course list
//print_r($f1[$schval['school_name']]);
//echo "pp".count($f1[$schval['school_name']]);
if(count($f1[$schval['school_name']])=='0'){
    $stddata1[$schval['school_name']]['flag']='1';
}

} // end of school list
//echo "<pre>";
//print_r($stddata1);
//exit;
                    
                    //$this->load->view('erp_cron/acadmic_time_table_entry',$this->data);

                    $this->load->library('M_pdf');
                    foreach ($stddata as $key => $value) {
//$ct=count($value['courses']);
if($value['flag']!='1'){
                        $this->data['courses'] = $value['courses'];
                       // print_r($value['courses']);
                         $this->data['school_name']=$key;
                    $mpdf=new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');

                    $html = $this->load->view('erp_cron/student_attendance_reminder', $this->data, true);
                   
                    $mpdf->autoScriptToLang = true;
                    $mpdf->baseScript = 1;  // Use values in classes/ucdn.php  1 = LATIN
                    $mpdf->autoVietnamese = true;
                    $mpdf->autoArabic = true;
                    $mpdf->autoLangToFont = true;
                    $mpdf->SetMargins(10,10,15);
                    $mpdf->SetDisplayMode('fullpage');                   
                    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
                    $mpdf->WriteHTML($html);
                    $fname=$key."_".$date;
                    $mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/uploads/payment/attendance/notmarkattendance/' . $fname . '.pdf', 'F');
                  $file=$_SERVER['DOCUMENT_ROOT'] . "/erp/uploads/payment/attendance/notmarkattendance/" . $fname . ".pdf";
                      $subject='Attendance Not Mark';
                        sleep(5);
                        $body="Dear all, 
                           Please find the attached file of Attendance not mark on ".$date.".";
                        $this->sendattachedemail($body,$email='balasaheb.lengare@carrottech.in',$subject,$file);
                        sleep(5);

                    }
                    }
//end if not mark
               //     error_reporting(E_ALL); ini_set('display_errors', 1);
  
/*  foreach ($stddata1 as $key => $value) {
//$ct=count($value['courses']);
if($value['flag']!='1'){
                        $this->data['courses'] = $value['courses'];
                       // print_r($value['courses']);
                         $this->data['school_name']=$key;
                  $mpdf=new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');

                    $html = $this->load->view('erp_cron/student_attendance_list', $this->data, true);
                   
                    $mpdf->autoScriptToLang = true;
                    $mpdf->baseScript = 1;  // Use values in classes/ucdn.php  1 = LATIN
                    $mpdf->autoVietnamese = true;
                    $mpdf->autoArabic = true;
                    $mpdf->autoLangToFont = true;
                    $mpdf->SetMargins(10,10,15);
                    $mpdf->SetDisplayMode('fullpage');                   
                    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
                    $mpdf->WriteHTML($html);
                    $fname=$key."_".$date;
                    $mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/uploads/payment/attendance/markattendance/' . $fname . '.pdf', 'F');
                    $file=$_SERVER['DOCUMENT_ROOT'] . "/erp/uploads/payment/attendance/markattendance/" . $fname . ".pdf";
                      $subject='Attendance  Mark details';
                        sleep(5);
                        $body="Dear all,
                            pls find the attached file of Attendance  Mark details on ".$date.".";
                       $this->sendattachedemail($body,$email='balasaheb.lengare@carrottech.in',$subject,$file);
                        sleep(5);
                    
                    }
}
 */
    }//end of function

  
   //email functionality
   public function sendattachedemail($body, $email, $subject, $file, $pdfData = '')
  {
	  
    $path = $_SERVER["DOCUMENT_ROOT"] . '/application/third_party/';
    require_once($path . 'PHPMailer/class.phpmailer.php');
    date_default_timezone_set('Asia/Kolkata');
    require_once(APPPATH . "third_party/PHPMailer/PHPMailerAutoload.php");

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
   $mail->Username = 'noreply10@sandipuniversity.edu.in';
		$mail->Password = 'pgef sqab ruxv cdvy';
    //Set who the message is to be sent from
    $mail->setFrom('NoReply10@sandipuniversity.edu.in', 'SANDIP UNIVERSITY');
    //$mail->addAddress('kajal.sonavane@carrottech.in', 'kajal');
    //$mail->AddAddress('balasaheb.lengare@carrottech.in', 'balasaheb');
    $mail->AddAddress('erp.support@sandipuniversity.edu.in', 'Developer');
    #$mail->AddCC('associatedean.academics@sandipuniversity.edu.in', 'Associatedean');
    #$mail->AddCC('vc@sandipuniversity.edu.in', 'VC');
    $mail->AddAddress($email);
    //Set the subject line
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = 'This is a plain-text message body';
    //Attach an image file
    $mail->addStringAttachment($pdfData, $file, 'base64', 'application/pdf');
    //send the message, check for errors
    if (!$mail->send()) {
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
      echo 'Message sent!';
    }
  }
  
  

function faculty_attendance_report(){
  ini_set('memory_limit', '-1');
//error_reporting(E_ALL); ini_set('display_errors', 1);
$fdat=date( 'Y-m-d', strtotime( 'monday this week' ) );
$tdt=date( 'Y-m-d', strtotime( 'Tuesday this week' ) );
$this->load->library('M_pdf');
$school_list = $this->Erp_cron_attendance_model->get_school_list();
 $s = $this->Erp_cron_attendance_model->get_dates($fdat,$tdt);
  $dtarr=[];
foreach ($s as $key => $value) {

    $dtarr[date('l',strtotime($value))]=date('Y-m-d',strtotime($value));
}
$this->data['sdate'] = $dtarr;

foreach($school_list as $schval){  
$arr['sch_id']=$schval['school_code'];
$arr['fdt']=$fdat;
$arr['tdt']=$tdt;
$this->data['crnf']='1';
 $this->data['pdata']=$arr;
$this->data['school_name_h'] = $schval['school_name'];
$this->data['sublist'] = $this->Erp_cron_attendance_model->get_faculty_lecture_list($arr);

if(count($this->data['sublist'])>0){
                    $html = $this->load->view('erp_cron/ajax_facultywise_report', $this->data, true);
                //exit();
                    $mpdf=new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');
                    $mpdf->autoScriptToLang = true;
                    $mpdf->baseScript = 1;  // Use values in classes/ucdn.php  1 = LATIN
                    $mpdf->autoVietnamese = true;
                    $mpdf->autoArabic = true;
                    $mpdf->autoLangToFont = true;
                    $mpdf->SetMargins(10,10,15);
                    $mpdf->SetDisplayMode('fullpage');                   
                    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
                    $mpdf->WriteHTML($html);
                    $fname=$schval['school_code']."_".$fdat."_".$tdt;
                    $mpdf->Output($_SERVER['DOCUMENT_ROOT'].'/erp/uploads/payment/attendance/faculty_attendance/'.$fname.'.pdf','F');
                   
//exit();
                    $file=$_SERVER['DOCUMENT_ROOT'] . "/erp/uploads/payment/attendance/faculty_attendance/" . $fname . ".pdf";
                      $subject='Faculty Attendance  Mark details';
                        sleep(5);
                        $body="Dear all,
                            pls find the attached file of Faculty Attendance  Mark details";
                        $this->sendattachedemail($body,$email='erp.support@sandipuniversity.edu.in',$subject,$file);
                        sleep(5);
                        //exit();

} // end of school
//print_r($attdata);

 }


} // end of function


////////////////////////////////////////////////////
   ////////////////////ERP-student_attendance/get_attendance_mark_report////////////////////

  public function get_attendance_mark_report()
  {
     echo'sss';exit;
    ini_set('memory_limit', '-1');
    $this->load->library('M_pdf');
    $sch_list = $this->Student_Attendance_model->get_school_list();
    $academic_year = ACADEMIC_YEAR;
    $cur_sess = CURRENT_SESS;
    $tdydate = date('Y-m-d');
    //$tdydate='2023-09-04';
    $day = date('l');
    //$day=date('l',strtotime($tdydate));
    $dtarr[date('l', strtotime($tdydate))] = date('Y-m-d', strtotime($tdydate));
    $this->data['sdate'] = $dtarr;
    $nmdata = '';
    $rowa1 = '';
    $this->data['pdata']['acd_yer'] = $academic_year . '~' . $cur_sess;

    foreach ($sch_list as $key => $sch) {
      $sch_id = $sch['school_code'];
      $sch_name = $sch['school_name'];
      $this->data['exp'] = 'Y';
      $timtab = $this->data['timtab'] = $this->Erp_cron_attendance_model->get_attendance_list($academic_year, $cur_sess, $day, $sch_id, $rtyp = 'm');

      $cntj = count($timtab);
      $mcount = 0;

      for ($i = 0; $i < $cntj; $i++) {
        $rowa = $this->Student_Attendance_model->get_student_attendance_data_pre($academic_year, $cur_sess, $tdydate, $timtab[$i]['stream_id'], $timtab[$i]['semester'], $timtab[$i]['division'], $timtab[$i]['lecture_slot'], $timtab[$i]['faculty_code']);

        $rowa1 = count($rowa);
        $mcount += $rowa1;
      }

      if ($mcount > 0) {
        $html = $this->load->view('Attendance/ajax_student_att_mark_report', $this->data, true);
        //echo $html;exit;
        $mpdf = new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');
        $mpdf->autoScriptToLang = true;
        $mpdf->baseScript = 1;  // Use values in classes/ucdn.php  1 = LATIN
        $mpdf->autoVietnamese = true;
        $mpdf->autoArabic = true;
        $mpdf->autoLangToFont = true;
        $mpdf->SetMargins(10, 10, 15);
        $mpdf->SetDisplayMode('fullpage');
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($html);
        $pdfData = $mpdf->Output('', 'S');
        $file = $sch_name . "_" . $tdydate;

        $subject = 'Attendance Mark Report.';
        sleep(5);
        $body = "Dear all, 
						Please find the attached file related to Attendance Mark Report";
        $this->sendattachedemail($body, $email = 'balasaheb.lengare@carrottech.in', $subject, $file, $pdfData);//exit;
      }
    }
    foreach ($sch_list as $key => $sch) {
      $sch_id = $sch['school_code'];
      $sch_name = $sch['school_name'];
      $this->data['exp'] = 'Y';
      $nmdata = $this->data['timtab'] = $this->Erp_cron_attendance_model->get_attendance_list($academic_year, $cur_sess, $day, $sch_id, $rtyp = '');
      if (!empty($nmdata)) {
        $html = $this->load->view('Attendance/ajax_student_att_report', $this->data, true);
        $mpdf = new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');
        $mpdf->autoScriptToLang = true;
        $mpdf->baseScript = 1;  // Use values in classes/ucdn.php  1 = LATIN
        $mpdf->autoVietnamese = true;
        $mpdf->autoArabic = true;
        $mpdf->autoLangToFont = true;
        $mpdf->SetMargins(10, 10, 15);
        $mpdf->SetDisplayMode('fullpage');
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($html);
        $pdfData = $mpdf->Output('', 'S');
        $file = $sch_name . "_" . $tdydate;

        $subject = 'Attendance Not Mark Report.';
        sleep(5);
        $body = "Dear all, 
						Please find the attached file related to Attendance Not Mark Report";
        //$this->sendattachedemail($body, $email = 'balasaheb.lengare@carrottech.in', $subject, $file, $pdfData);
      }
    }
  }


  ////////////////////////////////////////////////////////////////////////////
///////////////////////Lecture Attendance Report///////////////////////////

  public function lecture_attendance_report()
  {
	  exit;
    $this->load->library('m_pdf');
    $tdydate = date('d-m-Y');
    $this->data['stud_data'] = $this->Student_Attendance_model->fetch_lecture_attendance_data();
    $re_stud_data = [];
    foreach ($this->data['stud_data'] as $data) {
      $stream_id = $data['stream_id'];
      $semester_id = $data['semester'];
      $rereg_data = $this->Student_Attendance_model->fetch_lecture_attendance_reregister_data($stream_id, $semester_id);

      $data['rereg_stud_count'] = $rereg_data['rereg_stud_count'];
      $re_stud_data[] = $data;
    }

    $this->data['re_stud_data'] = $re_stud_data;
    $html = $this->load->view('Attendance/lecture_attendance_report_pdf', $this->data, true);
    //echo $html;exit;
    $this->m_pdf->pdf = new mPDF('L', 'A4-L', '', '', 5, 10, 5, 17, 5, 10);
    $this->m_pdf->pdf->WriteHTML($html);
    $pdfData = $this->m_pdf->pdf->Output('', "S");
    $file = 'Cumulative Daily Lecture Attendance Report' . "_" . $tdydate;

    $subject = 'Lecture Attendance Report.';
    sleep(5);
    $body = "Dear all, 
					Please find the attached file related to Lecture Attendance Report";
    $this->sendattachedemail($body, $email = 'balasaheb.lengare@carrottech.in', $subject, $file, $pdfData);

  }
  
  ////////Replace function sendattachedemail
  
   ////////////////////Faculty Wise Duck Report/////////////////

    public function get_faculty_report()
  {
	  echo 1;exit;
    ini_set('memory_limit', '-1');
    $this->load->library('M_pdf');
    $sch_list = $this->Student_Attendance_model->get_school_list();
    $academic_year = ACADEMIC_YEAR;
    $cur_sess = CURRENT_SESS;
    $tdydate = date('Y-m-d');
   // $tdydate = '2025-02-14';
	
    $day = date('l');
    $dtarr[date('l', strtotime($tdydate))] = date('Y-m-d', strtotime($tdydate));
    $this->data['sdate'] = $dtarr;
	$array = array(); 
    $array[] = $tdydate; 
	$this->data['sdl']=$array;
	$this->data['pdata']['acd_yer'] = $academic_year . '~' . $cur_sess;

    foreach ($sch_list as $key => $sch) {

      $sch_id = $sch['school_code'];
      $sch_name = $sch['school_name'];
	  $this->data['exp'] = 'Y';
	  $sublist=array();$i=0;
       $sublist_data= $this->Erp_cron_attendance_model->get_faculty_lecture_list1($academic_year, $cur_sess, $day, $sch_id);

	   foreach($sublist_data as $sub){
		   
		 $rowa=$this->Student_Attendance_model->get_faculty_lecturs_fact_code($academic_year,$cur_sess,$sub['faculty_code'],$tdydate,$tdydate); 

		 if(!empty($rowa)){
			 $rowp1 = []; 
			  foreach ($rowa as $row){
				  
                  $rowp=$this->Student_Attendance_model->get_student_attendance_data_duck($academic_year,$cur_sess,$tdydate,$row['stream_id'],$row['semester'],$row['division'],$row['lecture_slot'],$sub['faculty_code'],$row['batch']);
				  if(empty($rowp)){
				  $rowp1[]=$rowp;
				  }
			  }	

			    if(!empty($rowp1)){
				$sublist[$i]['course_id']=$sub['course_id'];
				$sublist[$i]['stream_id']=$sub['stream_id'];
				$sublist[$i]['semester']=$sub['semester'];
				$sublist[$i]['division']=$sub['division'];
				$sublist[$i]['lecture_slot']=$sub['lecture_slot'];
				$sublist[$i]['faculty_code']=$sub['faculty_code'];
				$sublist[$i]['fname']=$sub['fname'];
				$sublist[$i]['lname']=$sub['lname'];
				$sublist[$i]['wday']=$sub['wday'];
				$sublist[$i]['school_name']=$sub['school_name'];
				$i++;
			  }
		   }
	   }

    $this->data['sublist']=$sublist;
    $html = $this->load->view('Attendance/ajax_facultywise_report', $this->data,true);
    $this->m_pdf->pdf = new mPDF('L', 'A4-L', '', '', 5, 10, 5, 17, 5, 10);
    $this->m_pdf->pdf->WriteHTML($html);
    $pdfData = $this->m_pdf->pdf->Output('', "S");
    $file = $sch_name.'_Duck Report' . "_" . $tdydate;
	 $subject = $sch_name.'-Duck Report' . "-" . $tdydate;
    //$subject = 'Duck Report.';
    sleep(5);
    $body = "Dear all, 
					Please find the attached file related to Daily Duck Report";
    $this->sendattachedemail($body, $email = 'lengare.balasaheb@carrottech.in', $subject, $file, $pdfData);
	//exit;
    }
  }
	 public function save_duck_report() {
        $this->load->model('DuckReportModel');
        $this->load->model('Erp_cron_attendance_model');
    
        $date = date('Y-m-d');
        $academic_year = '2025-26';
        $academic_session = 'WIN';
        $month = date('Y-m'); 
        //$faculty_code = '110395';
    
        // Fetch lecture timetable data
        $lecture_data = $this->DuckReportModel->getLectureTimeTable($academic_year, $date, $academic_session);
    
        $faculty_reports = []; // Array to store per-faculty aggregated data
    
        // Process data
        foreach ($lecture_data as $lecture) {
            $faculty_code = $lecture['faculty_code'];
            $subject_id = $lecture['subject_code'];
            $lecture_slot = $lecture['lecture_slot'];
    
            $lv = $this->DuckReportModel->check_leave($lecture['faculty_code'], $date);
           // $hd = $this->Erp_cron_attendance_model->check_holidays($date, $lecture['staff_type']);
            
            if ($lv != 'N') {
                $lv = explode('~', $lv);
            }
    
            // Check attendance
            $attendance = $this->DuckReportModel->checkAttendance($academic_year, $date, $faculty_code, $subject_id, $lecture_slot, $academic_session, $lecture['division'], $lecture['batch_no'], $lecture['stream_id'], $lecture['semester']);

            $today = empty($attendance['faculty_code']) ? 1 : 0;
    
            /* $ltoday = '';
            if ($lv[0] == 'CL(Full Day)') {
                $ltoday = 'Leave';
            }
            if ($hd == '') {
                $ltoday = 'Holiday';
            } */
    
            // Prepare JSON details for this lecture
            $lecture_details = [
                'designation' => $lecture['designation_name'],
                'school_stream' => $lecture['school_short_name'] . ' - ' . $lecture['stream_short_name'],
                'semester' => $lecture['semester'],
                'division' => $lecture['division'],
                'batch' => $lecture['batch_no'],
                'subject' => $lecture['subject_name'],
                'subcod' => $lecture['subcod'],
                'subtype' => $lecture['subject_type'],
                'slot' => $lecture['from_time'] . ' - ' . $lecture['to_time'] . ' (' . $lecture['slot_am_pm'] . ')',
                'levtoday' => $ltoday,
                'today' => $today
            ];

            // Group data by faculty
            if (!isset($faculty_reports[$faculty_code])) {
                $faculty_reports[$faculty_code] = [
                    'faculty_code' => $faculty_code,
                    'faculty' => $lecture['fname'] . ' ' . $lecture['mname'] . ' ' . $lecture['lname'] . ' (' . $lecture['designation_name'] . ')',
                    'date' => $date,
                    'academic_year' => $academic_year,
                    'academic_session' => $academic_session,
                    'total_ducks' => 0,
                    'details' => []
                ];
            }

            // Increment today's total ducks for faculty
            $faculty_reports[$faculty_code]['total_ducks'] += $today;
            $faculty_reports[$faculty_code]['details'][] = $lecture_details;
        }  
      //  echo '<pre>';  
      //  print_r($faculty_reports[$faculty_code]['total_ducks']);
      //  exit;
    
        // Insert the grouped data into the database
        foreach ($faculty_reports as $faculty_code => $report) {
            $this->DuckReportModel->insertDuckReport(
                $report['faculty_code'],
                $report['faculty'],
                $report['date'],
                $report['academic_year'],
                $report['academic_session'],
                $report['total_ducks'],
                $report['details']
            );
        }
    
        echo "Duck Report Data Inserted Successfully!";
    }
    public function view_duck_report() {
        $this->load->model('DuckReportModel');
        $this->load->library('m_pdf');
        $date = date('Y-m-d');
        $academic_year = '2025-26';
        $academic_session = 'WIN';
       // $month = date('Y-m'); 
    
        // Fetch duck report data
        $report_data = $this->DuckReportModel->getDuckReport($date, $academic_year, $academic_session);
		//print_r( $report_data );
		//exit;
        // Decode JSON and calculate cumulative total
        foreach ($report_data as &$data) {
			
            $data['details'] = json_decode($data['details'], true);
            
            // Fetch cumulative sum from the start of the month
            $data['cumulative_ducks'] = $this->DuckReportModel->getCumulativeDucks($data['faculty_code'], $date, $academic_year, $academic_session);
			
			
			
			
         //   $data['cumulative_ducks_subject'] = $this->DuckReportModel->getCumulativeDucksSubjects($data['faculty_code'], $date, $academic_year, $academic_session);
        } // exit;
            // Header Design
			//<div>Mahiravani, Trimbak Road, Nashik - 422 213</div>
			// <div>Neelam Vidya Vihar, Village Sijoul, P.O. Mailam, Madhubani, Bihar, India.</div>
            $headerHTML = '
            <table style="width: 100%; border: none; font-size: 12px;">
                <tr>
                    <td style="width: 20%; text-align: center; border: none; ">
                        <img src="' . base_url('assets/images/sf-logo.png') . '" style="width: 80px; height: auto;">
                    </td>
                    <td style="width: 60%; text-align: center; border: none; ">
                        <div style="font-size: 20px; font-weight: bold; color:red;">Sandip Foundation</div>
                        <div>Mahiravani, Trimbak Road, Nashik - 422 213</div>
                       
                        <div style="font-size: 14px; font-weight: bold;">Attendance Not Marked Cum Duck Report</div>
                        <div style="font-weight: bold; font-size: 14px;">Date:  ' . $report_data[0]['date'] . ' | Academic Year: ' . $report_data[0]['academic_year'] . '</div>
                    </td>
                    <td style="width: 20%; text-align: center; border: none; ">
                        
                    </td>
                </tr>
            </table>
            <hr>';
        
            // Footer with Page Number
            $footerHTML = '
            <table width="100%" style="font-size: 12px;border: none; ">
                <tr>
                    <td style="border: none;" width="33%" align="left">Generated by Sandip University</td>
                    <td style="border: none;" width="33%" align="center">Attendance Report</td>
                    <td style="border: none;" width="33%" align="right">Page {PAGENO} of {nbpg}</td>
                </tr>
            </table>';
      
            // Load view and generate PDF
             $html = $this->load->view('duck_report_view', ['report_data' => $report_data], true); 
            $mpdf = new mPDF('L', 'A4', '', '', 5, 5, 35, 15, 5, 5);
            $mpdf->SetHTMLHeader($headerHTML);
            $mpdf->SetHTMLFooter($footerHTML);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Duck_Report.pdf', 'I'); // Display the PDF in the browser
        // Load view
    //    $this->load->view('duck_report_view', ['report_data' => $report_data]);
    }

/// Duck reports for school of Design
public function save_duck_report_sod() {
	$db='';
        $this->load->model('DuckReportModel');
        $this->load->model('Erp_cron_attendance_model');
    
        $date = date('Y-m-d');
        $academic_year = '2025-26';
        $academic_session = 'WIN';
        $month = date('Y-m'); 
        //$faculty_code = '110395';
    
        // Fetch lecture timetable data
        $lecture_data = $this->DuckReportModel->getLectureTimeTablesod($academic_year, $date, $academic_session);
    
        $faculty_reports = []; // Store per-faculty aggregated data
        $processedSlots = []; // To track counted (division, slot) pairs per faculty
    
        foreach ($lecture_data as $lecture) {
            $faculty_code = $lecture['faculty_code'];
            $subject_id = $lecture['subject_code'];
            $lecture_slot = $lecture['lecture_slot'];
            $division = $lecture['division'];
    
            // Create a unique key for (slot, division)
            $uniqueSlotKey = $faculty_code . '_' . $lecture_slot . '_' . $division;
    
            // Check attendance
            $attendance = $this->DuckReportModel->checkAttendance_new($academic_year, $date, $faculty_code, $subject_id, $lecture_slot, $academic_session, $division, $lecture['batch_no'], $lecture['stream_id'], $lecture['semester'],$db='');
    
            // Ensure attendance data is set before using
            $total_strength = isset($attendance['total']) ? $attendance['total'] : 0;
            $present_students = isset($attendance['present_count']) ? $attendance['present_count'] : 0;
            $absent_students = isset($attendance['absent_count']) ? $attendance['absent_count'] : 0;
    
            // Calculate attendance percentage
            $attendance_percentage = ($total_strength > 0) ? ($present_students / $total_strength) * 100 : 0;
            $attendance_percentage = number_format($attendance_percentage, 2);
    
            // **Ensure only one record per (division, slot) is counted in total_ducks**
            if (!isset($processedSlots[$uniqueSlotKey])) {
                $today = empty($attendance['faculty_code']) ? 1 : 0; // Count first occurrence
                $processedSlots[$uniqueSlotKey] = true; // Mark this slot-division as processed
            } else {
                $today = 0; // **Avoid counting duplicate slot-division pairs**
            }
    
            // Prepare JSON details for this lecture (unchanged)
            $lecture_details = [
                'designation' => $lecture['designation_name'],
                'school_stream' => $lecture['school_short_name'] . ' - ' . $lecture['stream_short_name'],
                'semester' => $lecture['semester'],
                'division' => $lecture['division'],
                'batch' => $lecture['batch_no'],
                'subject' => $lecture['subject_name'],
                'subcod' => $lecture['subcod'],
                'subtype' => $lecture['subject_type'],
                'slot' => $lecture['from_time'] . ' - ' . $lecture['to_time'] . ' (' . $lecture['slot_am_pm'] . ')',
                'today' => $today, // **Correctly stores in JSON**
                'total_students' => $total_strength,  
                'present_students' => $present_students,  
                'absent_students' => $absent_students,  
                'attendance_percentage' => $attendance_percentage
            ];
    
            // Group data by faculty
            if (!isset($faculty_reports[$faculty_code])) {
                $faculty_reports[$faculty_code] = [
                    'faculty_code' => $faculty_code,
                    'faculty' => $lecture['fname'] . ' ' . $lecture['mname'] . ' ' . $lecture['lname'] . ' (' . $lecture['designation_name'] . ')',
                    'date' => $date,
                    'academic_year' => $academic_year,
                    'academic_session' => $academic_session,
                    'school_id' => $lecture['school_id'],
                    'total_ducks' => 0, // Initialize correctly
                    'details' => []
                ];
            }
    
            // **Ensure correct total_ducks count includes only unique (slot, division) pairs**
            if ($today === 1) {
                $faculty_reports[$faculty_code]['total_ducks'] += 1;
            }
    
            $faculty_reports[$faculty_code]['details'][] = $lecture_details;
        }  
		echo  '<Pre>';//print_r($faculty_reports);exit;
        // Insert the grouped data into the database
        foreach ($faculty_reports as $faculty_code => $report) {
            $this->DuckReportModel->insertDuckReport_new(
                $report['faculty_code'],
                $report['faculty'],
                $report['date'],
                $report['academic_year'],
                $report['academic_session'],
                $report['total_ducks'], // ✅ **Now correctly reflects unique + matched counts**
                $report['details'],
                $report['school_id'],$db
            );
			//unset($$report);
        }
		exit;
        echo "Duck Report Data Inserted Successfully!";
    }
   /////////////////////////////////////////////////new development for duck Report///////////////////////////
    public function save_duck_report_new($db="") {
        $this->load->model('DuckReportModel');
        $this->load->model('Erp_cron_attendance_model');
    
         $date = date('Y-m-d');
		//$date='2025-10-06';
        $academic_year = '2025-26';
        $academic_session = 'WIN';
        $month = date('Y-m'); 
		$records_exist = $this->DuckReportModel->check_today_records($db);
        
        if ($records_exist) {
            echo "Records exist for today!";exit;
        } else {
            echo "No records for today.";
        }
    
        // Fetch lecture timetable data
        $lecture_data = $this->DuckReportModel->getLectureTimeTable($academic_year, $date, $academic_session,$db);
    
        $faculty_reports = []; // Store per-faculty aggregated data
        $processedSlots = []; // To track counted (division, slot) pairs per faculty
    
        foreach ($lecture_data as $lecture) {
            $faculty_code = $lecture['faculty_code'];
            $subject_id = $lecture['subject_code'];
            $lecture_slot = $lecture['lecture_slot'];
            $division = $lecture['division'];
    
            // Create a unique key for (slot, division)
            $uniqueSlotKey = $faculty_code . '_' . $lecture_slot . '_' . $division;
    
            // Check attendance
            $attendance = $this->DuckReportModel->checkAttendance_new($academic_year, $date, $faculty_code, $subject_id, $lecture_slot, $academic_session, $division, $lecture['batch_no'], $lecture['stream_id'], $lecture['semester'],$db);
    
            // Ensure attendance data is set before using
            $total_strength = isset($attendance['total']) ? $attendance['total'] : 0;
            $present_students = isset($attendance['present_count']) ? $attendance['present_count'] : 0;
            $absent_students = isset($attendance['absent_count']) ? $attendance['absent_count'] : 0;
    
            // Calculate attendance percentage
            $attendance_percentage = ($total_strength > 0) ? ($present_students / $total_strength) * 100 : 0;
            $attendance_percentage = number_format($attendance_percentage, 2);
    
            // **Ensure only one record per (division, slot) is counted in total_ducks**
            if (!isset($processedSlots[$uniqueSlotKey])) {
                $today = empty($attendance['faculty_code']) ? 1 : 0; // Count first occurrence
                $processedSlots[$uniqueSlotKey] = true; // Mark this slot-division as processed
            } else {
                $today = 0; // **Avoid counting duplicate slot-division pairs**
            }
    
            // Prepare JSON details for this lecture (unchanged)
            $lecture_details = [
                'designation' => $lecture['designation_name'],
                'school_stream' => $lecture['school_short_name'] . ' - ' . $lecture['stream_short_name'],
                'semester' => $lecture['semester'],
                'division' => $lecture['division'],
                'batch' => $lecture['batch_no'],
                'subject' => $lecture['subject_name'],
                'subcod' => $lecture['subcod'],
                'subtype' => $lecture['subject_type'],
                'slot' => $lecture['from_time'] . ' - ' . $lecture['to_time'] . ' (' . $lecture['slot_am_pm'] . ')',
                'today' => $today, // **Correctly stores in JSON**
                'total_students' => $total_strength,  
                'present_students' => $present_students,  
                'absent_students' => $absent_students,  
                'attendance_percentage' => $attendance_percentage
            ];
    
            // Group data by faculty
            if (!isset($faculty_reports[$faculty_code])) {
                $faculty_reports[$faculty_code] = [
                    'faculty_code' => $faculty_code,
                    'faculty' => $lecture['fname'] . ' ' . $lecture['mname'] . ' ' . $lecture['lname'] . ' (' . $lecture['designation_name'] . ')',
                    'date' => $date,
                    'academic_year' => $academic_year,
                    'academic_session' => $academic_session,
                    'school_id' => $lecture['school_id'],
                    'total_ducks' => 0, // Initialize correctly
                    'details' => []
                ];
            }
    
            // **Ensure correct total_ducks count includes only unique (slot, division) pairs**
            if ($today === 1) {
                $faculty_reports[$faculty_code]['total_ducks'] += 1;
            }
    
            $faculty_reports[$faculty_code]['details'][] = $lecture_details;
        }  
    
        // Insert the grouped data into the database
        foreach ($faculty_reports as $faculty_code => $report) {
            $this->DuckReportModel->insertDuckReport_new(
                $report['faculty_code'],
                $report['faculty'],
                $report['date'],
                $report['academic_year'],
                $report['academic_session'],
                $report['total_ducks'], // ✅ **Now correctly reflects unique + matched counts**
                $report['details'],
                $report['school_id'],
				$db
            );
        }
    
        echo "Duck Report Data Inserted Successfully!";
    }



  public function view_duck_report_new($db='',$hod='') {
        $this->load->model('DuckReportModel');
        $this->load->library('m_pdf');
		ini_set('memory_limit', '-1');
         $date = date('Y-m-d');
         //$date = '2025-03-04';
        $academic_year = '2025-26';
        $academic_session = 'WIN';
        $month = date('Y-m'); 
      //  $report_type = 'HOD';
        // Fetch duck report data
        $report_data = $this->DuckReportModel->getDuckReport($date, $academic_year, $academic_session,$sch_id='',$db,$hod);
    //print_r($report_data );exit;
        // Decode JSON and calculate cumulative total
        foreach ($report_data as &$data) {
			
            // Remove duplicate (slot, division) combinations before counting
			$data['details'] = json_decode($data['details'], true);
            $unique_slots = [];

            $data['total_lectures_TH'] = count(array_filter($data['details'], function($lecture) use (&$unique_slots) {
                $key = $lecture['slot'] . '_' . $lecture['division'];
                if ($lecture['subtype'] === 'TH' && !isset($unique_slots[$key])) {
                    $unique_slots[$key] = true;
                    return true;
                }
                return false;
            }));

            $data['total_lectures_PR'] = count(array_filter($data['details'], function($lecture) use (&$unique_slots) {
                $key = $lecture['slot'] . '_' . $lecture['division'];
                if ($lecture['subtype'] === 'PR' && !isset($unique_slots[$key])) {
                    $unique_slots[$key] = true;
                    return true;
                }
                return false;
            }));

            $unique_slots_TH = [];
            $unique_slots_PR = [];
            
            $data['Taken_lectures_TH'] = count(array_filter($data['details'], function($lecture) use (&$unique_slots_TH) {
                $key = $lecture['slot'] . '_' . $lecture['division'];
                
                if ($lecture['subtype'] === 'TH' && ($lecture['total_students'] != 0) && !isset($unique_slots_TH[$key])) {
                    $unique_slots_TH[$key] = true; // Mark as processed
                    return true;
                }
                return false;
            }));
            
            $data['Taken_lectures_PR'] = count(array_filter($data['details'], function($lecture) use (&$unique_slots_PR) {
                $key = $lecture['slot'] . '_' . $lecture['division'];
                
                if ($lecture['subtype'] === 'PR' && ($lecture['total_students'] != 0) && !isset($unique_slots_PR[$key])) {
                    $unique_slots_PR[$key] = true; // Mark as processed
                    return true;
                }
                return false;
            }));
			
             // Fetch total hours worked for TH & PR
            $faculty_hours = $this->DuckReportModel->getFacultyTotalHours($data['faculty_code'], $academic_year, $academic_session,$db);
            
            $data['total_hours_TH'] = $faculty_hours['TH'];
            $data['total_hours_PR'] = $faculty_hours['PR'];
            
            // echo '<pre>';
            // print_r( $data['total_lectures']);
            // Fetch cumulative sum from the start of the month
            $data['cumulative_ducks'] = $this->DuckReportModel->getCumulativeDucks($data['faculty_code'], $date, $academic_year, $academic_session,$db);

            $data['cumulative_ducks_subject'] = $this->DuckReportModel->getCumulativeDucksSubjects($data['faculty_code'], $date, $academic_year, $academic_session,$db);
        } 
        //echo '<pre>';
        //print_r( $data['cumulative_ducks_subject']);
        //exit;
        // Header Design
		if($db == 'sf'){
			$logo = '<img src="https://www.sandipfoundation.org/images/header-logo.png" style="width: 200px; height: auto;">';
			$title = 'Sandip Foundation';
			$address = '<div>Mahiravani, Trimbak Road, Nashik - 422 213</div>';
		}elseif($db == 'sijoul'){
			$logo = '<img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">';
			$title = 'Sandip University Madhubani';
			$address = '<div>Neelam Vidya Vihar, Village Sijoul, P.O. Mailam, Madhubani, Bihar, India.</div>';
		}else{
			$logo = '<img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">';
			$title = 'Sandip University';
			$address = '<div>Mahiravani, Trimbak Road, Nashik - 422 213</div>';
		}
        $headerHTML = '
        <table style="width: 100%; border: none; font-size: 12px;">
            <tr>
                <td style="width: 20%; text-align: center; border: none; ">
                    '.$logo.'
                </td>
                <td style="width: 60%; text-align: center; border: none; ">
                    <div style="font-size: 20px; font-weight: bold; color:red;">'.$title.'</div>
                    '.$address.'
                    <div style="font-size: 14px; font-weight: bold;">Attendance and Duck Report</div>
                    <div style="font-weight: bold; font-size: 14px;">Date:  ' . $report_data[0]['date'] . ' | Academic Year: ' . $report_data[0]['academic_year'] . '</div>
                </td>
                <td style="width: 20%; text-align: center; border: none; ">
                    
                </td>
            </tr>
        </table>
        <hr>';
        
            // Footer with Page Number
            $footerHTML = '
            <table width="100%" style="font-size: 12px;border: none; ">
                <tr>
                    <td style="border: none;" width="33%" align="left">Generated by Sandip University</td>
                    <td style="border: none;" width="33%" align="center">Attendance Report</td>
                    <td style="border: none;" width="33%" align="right">Page {PAGENO} of {nbpg}</td>
                </tr>
            </table>';
        //echo 1;exit;
            // Load view and generate PDF
             $html = $this->load->view('duck_report_view_new', ['report_data' => $report_data], true);
			// $html='hhh';
			$mpdf = new mPDF('L', 'A4-L', '', '', 5, 5, 35, 15, 5, 5);
            $mpdf->SetHTMLHeader($headerHTML);
            $mpdf->SetHTMLFooter($footerHTML);
            $mpdf->WriteHTML($html);
			$tddate=date('d-m-Y');
			if($hod!=''){
				$hodt="-Hod_Dean";
			}else{
				$hodt="";
			}
			
            $mpdf->Output($title.$hodt.'-Attendance and Duck Report-'.$tddate.'.pdf', 'D'); 
        // Load view
    //    $this->load->view('duck_report_view', ['report_data' => $report_data]);
    }
	
	
	///////////////////////////////Vap Subject Reports///////////////////////////
	
	
	public function save_vap_duck_report_new() {
        $this->load->model('DuckReportModel');
        $this->load->model('Erp_cron_attendance_model');
    
         $date = date('Y-m-d');
		//$date='2025-02-27';
        $academic_year = '2025-26';
        $academic_session = 'WIN';
        $month = date('Y-m'); 
    
        // Fetch lecture timetable data
        $lecture_data = $this->DuckReportModel->getLectureTimeTable_vap($academic_year, $date, $academic_session);
    
        $faculty_reports = []; // Store per-faculty aggregated data
        $processedSlots = []; // To track counted (division, slot) pairs per faculty
    
        foreach ($lecture_data as $lecture) {
            $faculty_code = $lecture['faculty_code'];
            $subject_id = $lecture['subject_code'];
            $lecture_slot = $lecture['lecture_slot'];
            $division = $lecture['division'];
    
            // Create a unique key for (slot, division)
            $uniqueSlotKey = $faculty_code . '_' . $lecture_slot . '_' . $division;
    
            // Check attendance
            $attendance = $this->DuckReportModel->checkAttendance_new($academic_year, $date, $faculty_code, $subject_id, $lecture_slot, $academic_session, $division, $lecture['batch_no'], $lecture['stream_id'], $lecture['semester']);
    
            // Ensure attendance data is set before using
            $total_strength = isset($attendance['total']) ? $attendance['total'] : 0;
            $present_students = isset($attendance['present_count']) ? $attendance['present_count'] : 0;
            $absent_students = isset($attendance['absent_count']) ? $attendance['absent_count'] : 0;
    
            // Calculate attendance percentage
            $attendance_percentage = ($total_strength > 0) ? ($present_students / $total_strength) * 100 : 0;
            $attendance_percentage = number_format($attendance_percentage, 2);
    
            // **Ensure only one record per (division, slot) is counted in total_ducks**
            if (!isset($processedSlots[$uniqueSlotKey])) {
                $today = empty($attendance['faculty_code']) ? 1 : 0; // Count first occurrence
                $processedSlots[$uniqueSlotKey] = true; // Mark this slot-division as processed
            } else {
                $today = 0; // **Avoid counting duplicate slot-division pairs**
            }
    
	// echo 'hii';exit;
            // Prepare JSON details for this lecture (unchanged)
            $lecture_details = [
                'designation' => $lecture['designation_name'],
                'school_stream' => $lecture['school_short_name'] . ' - ' . $lecture['stream_short_name'],
                'semester' => $lecture['semester'],
                'division' => $lecture['division'],
                'batch' => $lecture['batch_no'],
                'subject' => $lecture['subject_name']."(".$lecture['subject_title'].")",
                'subcod' => $lecture['subcod'],
                'subtype' => $lecture['subject_type'],
                'slot' => $lecture['from_time'] . ' - ' . $lecture['to_time'] . ' (' . $lecture['slot_am_pm'] . ')',
                'today' => $today, // **Correctly stores in JSON**
                'total_students' => $total_strength,  
                'present_students' => $present_students,  
                'absent_students' => $absent_students,  
                'attendance_percentage' => $attendance_percentage
            ];
    // echo 'hii';exit;
            // Group data by faculty
            if (!isset($faculty_reports[$faculty_code])) {
                $faculty_reports[$faculty_code] = [
                    'faculty_code' => $faculty_code,
                    'faculty' => $lecture['fname'] . ' ' . $lecture['mname'] . ' ' . $lecture['lname'] . ' (' . $lecture['designation_name'] . ')',
                    'date' => $date,
                    'academic_year' => $academic_year,
                    'academic_session' => $academic_session,
                    'school_id' => $lecture['school_id'],
                    'total_ducks' => 0, // Initialize correctly
                    'details' => []
                ];
            }
    
            // **Ensure correct total_ducks count includes only unique (slot, division) pairs**
            if ($today === 1) {
                $faculty_reports[$faculty_code]['total_ducks'] += 1;
            }
    
            $faculty_reports[$faculty_code]['details'][] = $lecture_details;
        }  
    
        // Insert the grouped data into the database
        foreach ($faculty_reports as $faculty_code => $report) {
            $this->DuckReportModel->insertVapDuckReport_new(
                $report['faculty_code'],
                $report['faculty'],
                $report['date'],
                $report['academic_year'],
                $report['academic_session'],
                $report['total_ducks'], // ✅ **Now correctly reflects unique + matched counts**
                $report['details'],
                $report['school_id']
            );
        }
    
        echo "Duck Report Data Inserted Successfully!";
    }
	
	  public function view_vap_duck_report_new() {
        $this->load->model('DuckReportModel');
        $this->load->library('m_pdf');
		ini_set('memory_limit', '-1');
         $date = date('Y-m-d');
         //$date = '2025-02-27';
        $academic_year = '2025-26';
        $academic_session = 'WIN';
        $month = date('Y-m'); 
      //  $report_type = 'HOD';
        // Fetch duck report data
        $report_data = $this->DuckReportModel->getVapDuckReport($date, $academic_year, $academic_session,$report_type='');
    //print_r($report_data );exit;
        // Decode JSON and calculate cumulative total
        foreach ($report_data as &$data) {
            $data['details'] = json_decode($data['details'], true);

            $data['total_lectures'] = count(array_filter($data['details'], function($lecture) {
                return $lecture['today'] != 0 || $lecture['total_students'] != 0;
            }));
             // Fetch total hours worked for TH & PR
            $faculty_hours = $this->DuckReportModel->getFacultyTotalHours($data['faculty_code'], $academic_year, $academic_session);
            
            $data['total_hours_TH'] = $faculty_hours['TH'];
            $data['total_hours_PR'] = $faculty_hours['PR'];
            
            // echo '<pre>';
            // print_r( $data['total_lectures']);
            // Fetch cumulative sum from the start of the month
            $data['cumulative_ducks'] = $this->DuckReportModel->getCumulativeVapDucks($data['faculty_code'], $date, $academic_year, $academic_session);

            $data['cumulative_ducks_subject'] = $this->DuckReportModel->getCumulativeVapDucksSubjects($data['faculty_code'], $date, $academic_year, $academic_session);
        } 
        //echo '<pre>';
        //print_r( $data['cumulative_ducks_subject']);
        //exit;
        // Header Design
        $headerHTML = '
        <table style="width: 100%; border: none; font-size: 12px;">
            <tr>
                <td style="width: 20%; text-align: center; border: none; ">
                    <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">
                </td>
                <td style="width: 60%; text-align: center; border: none; ">
                    <div style="font-size: 20px; font-weight: bold; color:red;">Sandip University</div>
                    <div>Mahiravani, Trimbak Road, Nashik - 422 213</div>
                    <div style="font-size: 14px; font-weight: bold;">VAP/SS/Cert Report</div>
                    <div style="font-weight: bold; font-size: 14px;">Date:  ' . $report_data[0]['date'] . ' | Academic Year: ' . $report_data[0]['academic_year'] . '</div>
                </td>
                <td style="width: 20%; text-align: center; border: none; ">
                    <img src="' . base_url('assets/images/OLD-logo.png') . '" style="width: 80px; height: auto;">
                </td>
            </tr>
        </table>
        <hr>';
        
            // Footer with Page Number
            $footerHTML = '
            <table width="100%" style="font-size: 12px;border: none; ">
                <tr>
                    <td style="border: none;" width="33%" align="left">Generated by Sandip University</td>
                    <td style="border: none;" width="33%" align="center">Attendance Report</td>
                    <td style="border: none;" width="33%" align="right">Page {PAGENO} of {nbpg}</td>
                </tr>
            </table>';
        //echo 1;exit;
            // Load view and generate PDF
             $html = $this->load->view('vap_duck_report_view', ['report_data' => $report_data], true);
			// $html='hhh';
			$mpdf = new mPDF('L', 'A4-L', '', '', 5, 5, 35, 15, 5, 5);
            $mpdf->SetHTMLHeader($headerHTML);
            $mpdf->SetHTMLFooter($footerHTML);
            $mpdf->WriteHTML($html);
            $mpdf->Output('SUN-VAP_SS_CERP_DUCK_REPORT.pdf', 'D'); 
        // Load view
    //    $this->load->view('duck_report_view', ['report_data' => $report_data]);
    }
	
	
////////////////////////////////////////////////////////////////////////////////////
    public function send_email_duck_report()
  {
    ini_set('memory_limit', '-1');
    $this->load->library('m_pdf');
    $sch_list = $this->Student_Attendance_model->get_school_list_for_duck_report();
    $academic_year = ACADEMIC_YEAR;
    $academic_session = CURRENT_SESS;
     $this->load->model('DuckReportModel');

         $date = date('Y-m-d');
         //$date = '2025-02-27';
        $month = date('Y-m'); 
	
    $day = date('l');
    $dtarr[date('l', strtotime($tdydate))] = date('Y-m-d', strtotime($tdydate));
    $this->data['sdate'] = $dtarr;
	$array = array(); 
    $array[] = $tdydate; 
	$this->data['sdl']=$array;
	$this->data['pdata']['acd_yer'] = $academic_year . '~' . $cur_sess;

    foreach ($sch_list as $key => $sch) {

      $sch_id = $sch['school_id'];
      $sch_name = $sch['school_name'];
	  $this->data['exp'] = 'Y';
	  if($sch_id==1){
		  $email_id='associate.deanengg@sandipuniversity.edu.in';
	  }elseif($sch_id==2){
		  $email_id='deanmgt@sandipuniversity.edu.in';
	  }elseif($sch_id==4){
		  $email_id='deanlaw@sandipuniversity.edu.in';
	  }elseif($sch_id==5){
		  $email_id='associate.deancse@sandipuniversity.edu.in';
	  }elseif($sch_id==6){
		  $email_id='deansci@sandipuniversity.edu.in';
	  }elseif($sch_id==9 || $sch_id==14){
		  $email_id='deanschoolofdesign@sandipuniversity.edu.in';
		  //$email_id='vighnesh.sukum@sandipuniversity.edu.in';
	  }elseif($sch_id==10){
		  $email_id='deanpharmacy@sandipuniversity.edu.in';
	  }
       

      //  $report_type = 'HOD';
        // Fetch duck report data
        $report_data = $this->DuckReportModel->getDuckReport($date, $academic_year, $academic_session, $sch_id,$db='',$hod='');
    
        // Decode JSON and calculate cumulative total
        foreach ($report_data as &$data) {
            $data['details'] = json_decode($data['details'], true);

            $unique_slots = [];

            $data['total_lectures_TH'] = count(array_filter($data['details'], function($lecture) use (&$unique_slots) {
                $key = $lecture['slot'] . '_' . $lecture['division'];
                if ($lecture['subtype'] === 'TH' && !isset($unique_slots[$key])) {
                    $unique_slots[$key] = true;
                    return true;
                }
                return false;
            }));

            $data['total_lectures_PR'] = count(array_filter($data['details'], function($lecture) use (&$unique_slots) {
                $key = $lecture['slot'] . '_' . $lecture['division'];
                if ($lecture['subtype'] === 'PR' && !isset($unique_slots[$key])) {
                    $unique_slots[$key] = true;
                    return true;
                }
                return false;
            }));

            $unique_slots_TH = [];
            $unique_slots_PR = [];
            
            $data['Taken_lectures_TH'] = count(array_filter($data['details'], function($lecture) use (&$unique_slots_TH) {
                $key = $lecture['slot'] . '_' . $lecture['division'];
                
                if ($lecture['subtype'] === 'TH' && ($lecture['total_students'] != 0) && !isset($unique_slots_TH[$key])) {
                    $unique_slots_TH[$key] = true; // Mark as processed
                    return true;
                }
                return false;
            }));
            
            $data['Taken_lectures_PR'] = count(array_filter($data['details'], function($lecture) use (&$unique_slots_PR) {
                $key = $lecture['slot'] . '_' . $lecture['division'];
                
                if ($lecture['subtype'] === 'PR' && ($lecture['total_students'] != 0) && !isset($unique_slots_PR[$key])) {
                    $unique_slots_PR[$key] = true; // Mark as processed
                    return true;
                }
                return false;
            }));
             // Fetch total hours worked for TH & PR
            $faculty_hours = $this->DuckReportModel->getFacultyTotalHours($data['faculty_code'], $academic_year, $academic_session,$db='');
            
            $data['total_hours_TH'] = $faculty_hours['TH'];
            $data['total_hours_PR'] = $faculty_hours['PR'];
            
            // echo '<pre>';
            // print_r( $data['total_lectures']);
            // Fetch cumulative sum from the start of the month
            $data['cumulative_ducks'] = $this->DuckReportModel->getCumulativeDucks($data['faculty_code'], $date, $academic_year, $academic_session,$db='');

            $data['cumulative_ducks_subject'] = $this->DuckReportModel->getCumulativeDucksSubjects($data['faculty_code'], $date, $academic_year, $academic_session,$db='');
        } 
        //echo '<pre>';
        //print_r( $data['cumulative_ducks_subject']);
        //exit;
        // Header Design
        $headerHTML = '
        <table style="width: 100%; border: none; font-size: 12px;">
            <tr>
                <td style="width: 20%; text-align: center; border: none; ">
                    <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">
                </td>
                <td style="width: 60%; text-align: center; border: none; ">
                    <div style="font-size: 20px; font-weight: bold; color:red;">Sandip University</div>
                    <div>Mahiravani, Trimbak Road, Nashik - 422 213</div>
                    <div style="font-size: 14px; font-weight: bold;">Attendance and Duck Report</div>
                    <div style="font-weight: bold; font-size: 14px;">Date:  ' . $report_data[0]['date'] . ' | Academic Year: ' . $report_data[0]['academic_year'] . '</div>
                </td>
                <td style="width: 20%; text-align: center; border: none; ">
                    <img src="' . base_url('assets/images/OLD-logo.png') . '" style="width: 80px; height: auto;">
                </td>
            </tr>
        </table>
        <hr>';
        
            // Footer with Page Number
            $footerHTML = '
            <table width="100%" style="font-size: 12px;border: none; ">
                <tr>
                    <td style="border: none;" width="33%" align="left">Generated by Sandip University</td>
                    <td style="border: none;" width="33%" align="center">Attendance Report</td>
                    <td style="border: none;" width="33%" align="right">Page {PAGENO} of {nbpg}</td>
                </tr>
            </table>';
        //echo 1;exit;
            // Load view and generate PDF
              $html = $this->load->view('duck_report_view_new', ['report_data' => $report_data], true);
			
			// $html='hhh';
			$mpdf = new mPDF('L', 'A4-L', '', '', 5, 5, 35, 15, 5, 5);
            $mpdf->SetHTMLHeader($headerHTML);
            $mpdf->SetHTMLFooter($footerHTML);
            $mpdf->WriteHTML($html);
            $pdfData=$mpdf->Output('Attendance and Duck Report.pdf', 'S'); 
    $file = $sch_name.'_Attendance and Duck Report' . "_" . $date.".pdf";
	 $subject = $sch_name.'-Attendance and Duck Report' . "-" . $date;
    //$subject = 'Duck Report.';
    sleep(5);
    $body = "Dear Sir, 
					Please find the attached file related to Daily Duck Report";
    $this->sendattachedemail($body, $email_id, $subject, $file, $pdfData);
	//exit;
    }
  }

function get_mark_report() {
// Enable error reporting for debugging
// error_reporting(E_ALL);

// Validate and sanitize input
$academic_year =  '2025-26';
$school_code =  0;
$course_id = 0;
$stream_id =  0;
$from_date = date('Y-m-d');
    $to_date = date('Y-m-d');
 $start_of_week = date('Y-m-d', strtotime('last Monday', strtotime($from_date)));
    
    // Calculate the end of the week (Sunday)
    $end_of_week = date('Y-m-d', strtotime('next Sunday', strtotime($from_date)));

    // You can use these dates now
    $from_date = $start_of_week;
    $to_date = $end_of_week;
 

// Ensure mandatory fields are present
if (!$academic_year || !$from_date || !$to_date ) {
die("Error: Missing required parameters.");
}

$result =  $this->Project_model->get_attendance_data($academic_year, $school_code, $course_id, $stream_id, $from_date, $to_date);
//echo '<pre>';
//print_r($result); die;


$result = $this->transformAttendance($result);


// Store the result
$this->data['attendance'] = $result;
$headerHTML = '
        <table style="width: 100%; border: none; font-size: 12px;">
            <tr>
                <td style="width: 20%; text-align: center; border: none; ">
                    <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">
                </td>
                <td style="width: 60%; text-align: center; border: none; ">
                    <div style="font-size: 20px; font-weight: bold; color:red;">Sandip University</div>
                    <div>Mahiravani, Trimbak Road, Nashik - 422 213</div>
                    <div style="font-size: 14px; font-weight: bold;">Attendance Not Marked Cum Duck Report</div>
                    <div style="font-weight: bold; font-size: 14px;">Date:  ' .$from_date . ' | Academic Year: ' . $academic_year . '</div>
                </td>
                
            </tr>
        </table>
        <hr>';
        
            // Footer with Page Number
            $footerHTML = '
            <table width="100%" style="font-size: 12px;border: none; ">
                <tr>
                    <td style="border: none;" width="33%" align="left">Generated by Sandip University</td>
                    <td style="border: none;" width="33%" align="center">Attendance Report</td>
                    <td style="border: none;" width="33%" align="right">Page {PAGENO} of {nbpg}</td>
                </tr>
            </table>';
        //echo 1;exit;
            // Load view and generate PDF
             $html = $this->load->view('Project/ajax_student_report', $this->data, true);
			// $html='hhh';
			$mpdf = new mPDF('L', 'A4-L', '', '', 5, 5, 35, 15, 5, 5);
            $mpdf->SetHTMLHeader($headerHTML);
            $mpdf->SetHTMLFooter($footerHTML);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Projectattendance.pdf', 'I');
// Load the view

}

function get_mark_report_revised() {
// Enable error reporting for debugging
// error_reporting(E_ALL);

// Validate and sanitize input
$academic_year =  '2025-26';
$school_code =  0;
$course_id = 0;
$stream_id =  0;
$from_date = date('Y-m-d');
    $to_date = date('Y-m-d');
 $start_of_week = date('Y-m-d', strtotime('last Monday', strtotime($from_date)));
    
    // Calculate the end of the week (Sunday)
    $end_of_week = date('Y-m-d', strtotime('next Sunday', strtotime($from_date)));

    // You can use these dates now
    $from_date = $start_of_week;
     $to_date = $end_of_week;
 

// Ensure mandatory fields are present
if (!$academic_year || !$from_date || !$to_date ) {
die("Error: Missing required parameters.");
}

$result =  $this->Project_model->get_attendance_data_revised($academic_year, $school_code, $course_id, $stream_id, $from_date, $to_date);



$result = $this->transformAttendancerevised($result);



// Store the result
$this->data['attendance'] = $result;
$headerHTML = '
        <table style="width: 100%; border: none; font-size: 12px;">
            <tr>
                <td style="width: 20%; text-align: center; border: none; ">
                    <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">
                </td>
                <td style="width: 60%; text-align: center; border: none; ">
                    <div style="font-size: 20px; font-weight: bold; color:red;">Sandip University</div>
                    <div>Mahiravani, Trimbak Road, Nashik - 422 213</div>
                    <div style="font-size: 14px; font-weight: bold;">WEEKLY PROJECT ATTENDANCE REPORT-' . $academic_year . '</div>
                    <div style="font-weight: bold; font-size: 14px;">Date: From  ' .$from_date . ' To ' . $to_date . '</div>
                </td>
                <td style="width: 20%; text-align: center; border: none; ">
                    <img src="' . base_url('assets/images/OLD-logo.png') . '" style="width: 80px; height: auto;">
                </td>
            </tr>
        </table>
        <hr>';
        
            // Footer with Page Number
            $footerHTML = '
            <table width="100%" style="font-size: 12px;border: none; ">
                <tr>
                    <td style="border: none;" width="33%" align="left">Generated by Sandip University</td>
                    <td style="border: none;" width="33%" align="center">Attendance Report</td>
                    <td style="border: none;" width="33%" align="right">Page {PAGENO} of {nbpg}</td>
                </tr>
            </table>';
        //echo 1;exit;
            // Load view and generate PDF
             $html = $this->load->view('Project/ajax_student_report_revised', $this->data, true);
			
			// $html='hhh';
			$mpdf = new mPDF('L', 'A4-L', '', '', 5, 5, 35, 15, 5, 5);
            $mpdf->SetHTMLHeader($headerHTML);
            $mpdf->SetHTMLFooter($footerHTML);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Projectattendance.pdf', 'I');
// Load the view

}

/////////////Faculty monthly load Report///////////////////////////
/* public function faculty_monthly_report() {
        $this->data = [];
    
        $this->load->model('DuckReportModel');
    
        // ✅ Check if form is submitted
        if ($this->input->post()) {
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
        } else {
            // ✅ Set default date values when the form is not submitted
            $from_date = date('Y-m-01');  // First day of current month
            $to_date = date('Y-m-t');     // Last day of current month
        }
    
        // ✅ Fetch Report Data
        $this->data['from_date'] = $from_date;
        $this->data['to_date'] = $to_date;
        $this->data['report_data'] = $this->DuckReportModel->getFacultyReport($from_date, $to_date);
    
        // ✅ Load Views
        $this->load->view('header', $this->data);
        $this->load->view('faculty_monthly_report_view', $this->data);
        $this->load->view('footer');
    }
    public function faculty_monthly_report_pdf() {
        $this->load->model('DuckReportModel');
        $this->load->library('m_pdf'); // Load mPDF Library
    
        // ✅ Fetch Date Range from Form
        $from_date = $this->input->post('from_date') ? $this->input->post('from_date') : date('Y-m-01');
        $to_date = $this->input->post('to_date') ? $this->input->post('to_date') : date('Y-m-t');
    
        // ✅ Fetch Faculty Report Data
        $report_data = $this->DuckReportModel->getFacultyReport($from_date, $to_date);
    
        // ✅ Define Header for PDF
        $headerHTML = '
        <table style="width: 100%; border: none; font-size: 12px;">
            <tr>
                <td style="width: 20%; text-align: center; border: none;">
                    <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">
                </td>
                <td style="width: 60%; text-align: center; border: none;">
                    <div style="font-size: 20px; font-weight: bold; color:red;">Sandip University</div>
                    <div>Mahiravani, Trimbak Road, Nashik - 422 213</div>
                    <div style="font-size: 14px; font-weight: bold;">Faculty Attendance Report</div>
                    <div style="font-weight: bold; font-size: 14px;">From: ' . $from_date . ' | To: ' . $to_date . '</div>
                </td>
                <td style="width: 20%; text-align: center; border: none;">
                </td>
            </tr>
        </table>
        <hr>';
        
        // ✅ Define Footer for PDF
        $footerHTML = '
        <table width="100%" style="font-size: 12px;border: none;">
            <tr>
                <td style="border: none;" width="33%" align="left">Generated by Sandip University</td>
                <td style="border: none;" width="33%" align="center">Faculty Attendance Report</td>
                <td style="border: none;" width="33%" align="right">Page {PAGENO} of {nbpg}</td>
            </tr>
        </table>';
    
        // ✅ Load the View into HTML Content for PDF
        $html = $this->load->view('faculty_monthly_report_pdf_view', ['report_data' => $report_data, 'from_date' => $from_date, 'to_date' => $to_date], true);
    
        // ✅ Initialize mPDF
        $mpdf = new mPDF('L', 'A4-L', '', '', 5, 5, 35, 15, 5, 5);
        $mpdf->SetHTMLHeader($headerHTML);
        $mpdf->SetHTMLFooter($footerHTML);
        $mpdf->WriteHTML($html);
    
        // ✅ Output the PDF (Direct Download)
        $mpdf->Output('Faculty_Attendance_Report_' . date('Y-m-d') . '.pdf', 'I'); // Open in Browser
    } */
 public function faculty_monthly_report() {
        $this->data = [];
    
        $this->load->model('DuckReportModel');
    
        // ✅ Check if form is submitted
        if ($this->input->post()) {
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
        } else {
            // ✅ Set default date values when the form is not submitted
            $from_date = date('Y-m-01');  // First day of current month
            $to_date = date('Y-m-t');     // Last day of current month
        }
    
        // ✅ Fetch Report Data
        $this->data['from_date'] = $from_date;
        $this->data['to_date'] = $to_date;
        $this->data['report_data'] = $this->DuckReportModel->getFacultyReport($from_date, $to_date);
   // echo "<pre>"; print_r($this->data['report_data']);exit;
        // ✅ Load Views
        $this->load->view('header', $this->data);
        $this->load->view('faculty_monthly_report_view', $this->data);
        $this->load->view('footer');
    }
	
	
    public function faculty_monthly_report_pdf($from_date1='',$to_date1='') {
		 $from_date1='2025-04-01';$to_date1='2025-04-30';
		//echo '1221';exit;
        $this->load->model('DuckReportModel');
        $this->load->library('m_pdf'); // Load mPDF Library
		
		
		
       if(!empty($from_date1)){
			$_POST['from_date'] =$from_date1;
		}
		if(!empty($to_date1)){
			$_POST['to_date'] =$to_date1;
		}
	
	
	
        // ✅ Fetch Date Range from Form
        $from_date = $this->input->post('from_date') ? $this->input->post('from_date') : date('Y-m-01');
        $to_date = $this->input->post('to_date') ? $this->input->post('to_date') : date('Y-m-t');
		
		
		
    
        // ✅ Fetch Faculty Report Data
        $report_data = $this->DuckReportModel->getFacultyReport($from_date, $to_date);
    
        // ✅ Define Header for PDF
        $headerHTML = '
        <table style="width: 100%; border: none; font-size: 12px;">
            <tr>
                <td style="width: 20%; text-align: center; border: none;">
                    <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">
                </td>
                <td style="width: 60%; text-align: center; border: none;">
                    <div style="font-size: 20px; font-weight: bold; color:red;">Sandip University</div>
                    <div>Mahiravani, Trimbak Road, Nashik - 422 213</div>
                    <div style="font-size: 14px; font-weight: bold;">Faculty Attendance Report</div>
                    <div style="font-weight: bold; font-size: 14px;">From: ' . $from_date . ' | To: ' . $to_date . '</div>
                </td>
                <td style="width: 20%; text-align: center; border: none;">
                </td>
            </tr>
        </table>
        <hr>';
        
        // ✅ Define Footer for PDF
        $footerHTML = '
        <table width="100%" style="font-size: 12px;border: none;">
            <tr>
                <td style="border: none;" width="33%" align="left">Generated by Sandip University</td>
                <td style="border: none;" width="33%" align="center">Faculty Attendance Report</td>
                <td style="border: none;" width="33%" align="right">Page {PAGENO} of {nbpg}</td>
            </tr>
        </table>';
    
        // ✅ Load the View into HTML Content for PDF
        $html = $this->load->view('faculty_monthly_report_pdf_view', ['report_data' => $report_data, 'from_date' => $from_date, 'to_date' => $to_date], true);
    
        // ✅ Initialize mPDF
        $mpdf = new mPDF('L', 'A4', '', '', 5, 5, 35, 15, 5, 5);
        $mpdf->SetHTMLHeader($headerHTML);
        $mpdf->SetHTMLFooter($footerHTML);
        $mpdf->WriteHTML($html);
    
        // ✅ Output the PDF (Direct Download)
        //$mpdf->Output('Faculty_Attendance_Report_' . date('Y-m-d') . '.pdf', 'I'); // Open in Browser
		// Save the PDF in the root directory of your project
		$savePath = 'uploads/Faculty_Attendance_Report_' . date('Y-m-d') . '.pdf';
		$mpdf->Output($savePath, 'D');
    }
	
	  public function send_all_students_attendance_pdfsNew()
  {
      $this->load->model('Attendance_model');
      $this->load->library('M_pdf');
  
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $tdydate = date('Y-m-d');
  
      $students = $this->Attendance_model->get_students();
     echo "<pre>"; print_r($students);exit;
      if (empty($students)) {
          echo "No students found.";
          return;
      }
  
      foreach ($students as $student) {
          $streamID = $student['admission_stream'];
          $semester = $student['current_semester'];
          $division = $student['division'];
          $academic_year = $student['academic_year'];
          $batch = $student['batch'];
          $enrollment_no = $student['enrollment_no'];
          $student_id = isset($student['stud_id']) ? $student['stud_id'] : null; 
          $parent_email = isset($student['parent_email']) ? trim($student['parent_email']) : '';
  
          if (empty($parent_email)) {
              continue;
          }
  
          $this->data['attendance_data'] = $this->Attendance_model->get_student_attendance_for_parent_cron(
              $streamID,
              $semester,
              $division,
              $academic_year,
              $from_date,
              $to_date,
              $student_id,
              $batch
          );
  
          $this->data['from_date'] = $from_date;
          $this->data['to_date'] = $to_date;
          $this->data['student_id'] = $student_id;
          $this->data['enrollment_no'] = $enrollment_no;
  
          $html = $this->load->view('Attendance/parent_letter', $this->data, true);
          $this->m_pdf->pdf = new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');
          $this->m_pdf->pdf->WriteHTML($html);
          $pdfData = $this->m_pdf->pdf->Output('', "S"); 
  
          $file = 'Attendance_Report_' . $enrollment_no . '_' . $tdydate . '.pdf';
          $subject = 'Lecture Attendance Report';
          $body = "Dear Parent/Student,<br><br>Please find attached the attendance report.<br><br>Regards,<br>Sandip University";
  
          // $this->sendattachedemail($body, $parent_email, $subject, $file, $pdfData);
  
          $this->sendattachedemail($body, 'hemant.kolte@sandipuniversity.edu.in', $subject, $file, $pdfData);

          // sleep(2);
      }
  
      echo "Attendance PDFs sent to all students with valid parent emails.";
  }
	
	
	function send_whats_app_message(){
		$odj = new Whatsapp_api();
		$odj ->send_whats_app_message();
	}
	
	
//////////////////////////////////////////////////
 public function save_student_attendance_pdf_in_storage_and_table()
    {
        $this->load->model('Attendance_model');
        $this->load->library('M_pdf');

        $from_date = '';
        $to_date = '';
        $tdydate = date('Y-m-d');

        $students = $this->Attendance_model->get_student_data(); 
        // echo "<pre>";print_r($students);exit;

        if (empty($students)) {
            echo "No students found.";
            return;
        }

        $pdf_dir = FCPATH . 'uploads/attendance_pdfs/';
        if (!file_exists($pdf_dir)) {
            mkdir($pdf_dir, 0777, true);
        }

        foreach ($students as $student) {
            $student_id = $student['stud_id'];
            $streamID = $student['admission_stream'];
            $semester = $student['current_semester'];
            $division = $student['division'];
            $academic_year = defined('ACADEMIC_YEAR') ? ACADEMIC_YEAR : '2025-26';
            $batch = $student['batch'];
            $enrollment_no = $student['enrollment_no'];
            $parent_mobile = $student['parent_mobile2'] ?? '';
            $student_mobile = $student['s_mobile'] ?? '';

            $this->data['attendance_data'] = $this->Attendance_model->get_student_attendance_for_parent_cron11(
                $streamID,
                $semester,
                $division,
                $academic_year,
                $from_date,
                $to_date,
                $student_id,
                $batch
            );

            $this->data['from_date'] = $from_date;
            $this->data['to_date'] = $to_date;
            $this->data['student_id'] = $student_id;
            $this->data['enrollment_no'] = $enrollment_no;
			$this->data['db_name']='sun';

            $html = $this->load->view('Attendance/parent_letter', $this->data, true);
            $this->m_pdf->pdf = new mPDF('utf-8', 'A4');
            $this->m_pdf->pdf->WriteHTML($html);

            $filename = 'Attendance_Report_' . $enrollment_no . '_' . $tdydate . '.pdf';
            $filepath = $pdf_dir . $filename;
            $relative_path = 'uploads/attendance_pdfs/' . $filename;
			
			$file_name = base_url($relative_path);
   


            $this->m_pdf->pdf->Output($filepath, 'F');

            $data = [
                'student_id'      => $student_id,
                'enrollement_no'  => $enrollment_no,
                'parent_mobile'   => $parent_mobile,
                'student_mobile'  => $student_mobile,
                'pdf_path'        => $relative_path,
                'academic_year'   => $academic_year,
                'from_date'       => $from_date,
                'to_date'         => $to_date,
                'created_at'      => date('Y-m-d H:i:s')
            ];
            $DB1 = $this->load->database('umsdb', TRUE);
            //  print_r($data);exit;
            $DB1->insert('monthly_student_attendance_report_pdf', $data);
			//$parent_mobile = "9518510089";
			  /*     if (!empty($parent_mobile)) {
                $this->whatsapp_api->send_whats_app_message($parent_mobile, $file_name);
            } */


            echo "PDF saved and record inserted for Enrollment No: $enrollment_no<br>";
        }

        echo "<br>All student PDFs processed and saved.";
    }
 public function send_whats_app_student_attendance_pdf_in_storage_and_table()
    {
        $this->load->model('Attendance_model');
        $this->load->library('M_pdf');
		$DB1 = $this->load->database('umsdb', TRUE);
        $from_date = '';
        $to_date = '';
        $tdydate = date('Y-m-d');

        $students = $this->Attendance_model->get_student_attendance_data_tbl(); 
        //echo "<pre>";print_r($students);exit;

        if (empty($students)) {
            echo "No students found.";
            return;
        }

        foreach ($students as $student) {
            $id = $student['id'];
            $streamID = $student['admission_stream'];
            $parent_mobile = $student['parent_mobile'];
            $relative_path = $student['pdf_path'];
			$file_name = base_url($relative_path);
           
			//$parent_mobile = "8850633088";
			    if (!empty($parent_mobile)) {
                $this->whatsapp_api->send_whats_app_message($parent_mobile, $file_name);
            } 

		 	   	   
			$DB1->where('id',$id);
			$prdet['msg_status']='Y';  
			$DB1->update('monthly_student_attendance_report_pdf',$prdet); 	 
            echo "PDF saved and record inserted for Enrollment No: $parent_mobile<br>";
			
        }

        echo "<br>All student PDFs processed and saved.";
    }
	
	public function generate_pdf_for_campus($report_date, $acad_year_sched, $acad_year_students, $campus_id, $campus_label)
    {
        $rows = $this->Report_model->get_attendance_summary($report_date, $acad_year_sched, $acad_year_students, $campus_id);

        // Render HTML
        $data = [
            'rows' => $rows,
            'report_date' => $report_date,
            'acad_year_sched' => $acad_year_sched,
            'campus_label' => $campus_label
        ];
        $html = $this->load->view('Attendance/AttendanceReport', $data, TRUE);

        // Build PDF
       $this->load->library('m_pdf');  // If you have a wrapper; else instantiate mPDF directly:
       $mpdf=new mPDF('utf-8', 'A3-L', '10', '10', '10', '5', '5', '5');
       $mpdf->WriteHTML($html);

       // Generate PDF in memory
        $pdf_content = $mpdf->Output('', 'S');  // 'S' = return as string
		// Attach to email (no file written on disk)
        $this->email->attach($pdf_content, 'attachment', 'Attendance_'.$label.'_'.$report_date.'.pdf', 'application/pdf');
        return $file;
    }

    // Email a single PDF
    public function email_pdf($to_list, $subject, $message, $attach_path)
    {
        $this->email->clear(true);
        $this->email->from('noreply@sandipuniversity.com', 'Attendance Reports');
        $this->email->to($to_list); // can be array
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->attach($attach_path);

        if (!$this->email->send()) {
            log_message('error', 'Attendance report email failed: '.$this->email->print_debugger(['headers']));
            return false;
        }
        return true;
    }

    // Run for all 3 campuses and email in one go
public function daily()
{
    $report_date = date('Y-m-d');
    $acad_year_sched = '2025-26';
    $acad_year_students = 2025;

    $campuses = [
        1 => 'SUN',
        2 => 'SUM',
        3 => 'SF',
    ];
	$logoMap = [
    1 => "https://www.sandipuniversity.edu.in/images/logo-dark.png",
    2 => "https://sijoul.sandipuniversity.edu.in/images/logo-dark.png",
    3 => "https://sitrc.sandipfoundation.org/wp-content/uploads/2023/09/SIPS.png",
];
    // Email setup
    $path = $_SERVER["DOCUMENT_ROOT"] . '/application/third_party/';
    require_once($path . 'PHPMailer/class.phpmailer.php');
    date_default_timezone_set('Asia/Kolkata');
    require_once(APPPATH . "third_party/PHPMailer/PHPMailerAutoload.php");

    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    //Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port = 465;
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    //Username to use for SMTP authentication
   $mail->Username = 'noreply10@sandipuniversity.edu.in';
   $mail->Password = 'pgef sqab ruxv cdvy';
    //Set who the message is to be sent from
    $mail->setFrom('NoReply10@sandipuniversity.edu.in', 'SANDIP UNIVERSITY');
    //$mail->AddAddress('erp.support@sandipuniversity.edu.in', 'Developer');
	$email='erp.support@sandipuniversity.edu.in';
    $mail->AddAddress($email);

    $subject='Daily Attendance Mark Report - '.$report_date;
	$mail->Subject = $subject;
	$body = "Dear Team,\n\nPlease find attached the daily campus-wise attendance report for {$report_date}.\n\nRegards,\nERP Bot";
	$mail->Body = $body;
    
	
	$this->load->library('m_pdf');
    //$mpdf=new mPDF('utf-8', 'A3-L', '10', '10', '10', '5', '5', '5');

    foreach ($campuses as $cid => $label) {
		 log_message('error', "Processing campus {$cid} ({$label})"); 
		 $logo_url = isset($logoMap[$cid]) ? $logoMap[$cid] : null;
        $rows = $this->Erp_cron_attendance_model->get_attendance_summary(
        $report_date, $acad_year_sched, $acad_year_students, $cid
    );
        $data = [
    'rows' => $rows,
    'report_date' => $report_date,
    'acad_year_sched' => $acad_year_sched,
    'campus_label' => $label,
    'logo_url' => $logo_url, // <-- pass here
];
        $html = $this->load->view('Attendance/AttendanceReport', $data, TRUE);
		$mpdf = new mPDF(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 5, 'margin_right' => 5, 'margin_top' => 5, 'margin_bottom' => 5]);

		$mpdf->WriteHTML($html);
		$pdf_content = $mpdf->Output('', 'S');	
        $mpdf->WriteHTML($html);


        // Attach to email (no file written on disk)
		$mail->addStringAttachment($pdf_content, "{$label}_Cumulative Attendance_mark_{$report_date}.pdf");
    }
	if (!$mail->send()) {
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
      echo 'Message sent!';
    }
    
}


}
