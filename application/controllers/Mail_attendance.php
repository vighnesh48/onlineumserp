<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mail_attendance extends CI_Controller 
{
    function __construct()
    {        
        parent::__construct();                     
        $this->load->model('Timetable_model');
    }
    
    public function index()
    {
    	date_default_timezone_set("Asia/Kolkata");
		$todaysdate = '2018-08-14';	   
		$day = date('l', strtotime($todaysdate));
		$academic= $this->Timetable_model->fetch_Curracademic_session(); 
		$academic_year =$academic[0]['academic_year'];
		$academic_session =$academic[0]['academic_session'];
		if($academic_session=='WINTER'){
			$ses= "WIN";
		}else{
			$ses= "SUM";
		}
		$html ='';
		$schools = $this->Timetable_model->fetch_schools($todaysdate,$day,$academic_year,$ses);
		foreach ($schools as $val) {
			$school_code = $val['school_code'];
			$school_name = $val['school_name'];
			$html .='<table width="100%" border="1" cellspacing="0" cellpadding="5">
			<tr bgcolor="#0550c0">
			<td colspan="9" style="font-weight: bold;text-align:center; text-transform:uppercase;font-size: 17px;color:#fff;">Daily Attendence Report</td>
			</tr>
			  <tr bgcolor="#e6e6e6">
				<td colspan="5" width="50%"><strong>Day :</strong> '.$day.'</td>
				<td colspan="4"><strong>Date : </strong>'.$todaysdate.'</td>
			  </tr bgcolor="#CCCCCC">
			  <tr bgcolor="#e6e6e6">
				<td colspan="9"><strong>School Name : </strong> '.$school_name.'</td>
			  </tr>';
			$streams = $this->Timetable_model->fetch_streams($school_code,$day, $academic_year,$ses);
			foreach ($streams as $value) {
				$stream_id = $value['stream_id'];
				$stream_name = $value['stream_name'];
				$division = $value['division'];
				$semester = $value['semester'];
				$html .='<tr bgcolor="#e6e6e6">
				<td colspan="3" width="33%"><strong>Class : </strong> '.$stream_name.'</td>
				<td colspan="3"><strong>Sem :</strong> '.$semester.'</td>
				<td colspan="3"><strong>Div :</strong> '.$division.'</td>
			  </tr>';
							
							$html .='<tr bgcolor="#317def">
				 <th style="color:#fff;" width="5%">Sr No.</th>
				<th style="color:#fff;" width="30%">Subject Name</th>
				<th style="color:#fff;" width="5%">Type</th>
				<th style="color:#fff;" width="10%">Slot</th>
				<th style="color:#fff;" width="30%">Faculty Name</th>
				<th style="color:#fff;" width="5%">P</th>
				<th style="color:#fff;" width="5%">A</th>
				<th style="color:#fff;" width="5%">T</th>
				<th style="color:#fff;">%</th>
			  </tr>';
			$mdata = $this->Timetable_model->fetch_mailing_details($todaysdate,$day, $school_code, $stream_id,$semester, $division, $academic_year,$ses);
			$i=1;
			if(!empty($mdata)){
				foreach ($mdata as $mld) {
					$subject_name = $mld['subject_name'];
					$sub_code = $mld['sub_code'];
					$subject_type = $mld['subject_type'];
					$slot = $mld['from_time'].'-'.$mld['to_time'].' '.$mld['slot_am_pm'];
					$facname = strtoupper($mld['fname'][0].'. '.$mld['mname'][0].'. '.$mld['lname']);;
					$att_percentage = number_format($mld['att_percentage'], 2, '.', '');
					$tot_students = $mld['tot_students'];
					$totPersent = $mld['totPersent'];
					$totAbsent=$tot_students - $totPersent;
					$html .='<tr>
					<td align="center">'.$i.'</td>
					<td>'.$sub_code.'-'.$subject_name.'</td>
					<td align="center">'.$subject_type.'</td>
					<td align="left">'.$slot.'</td>
					<td>'.$facname.'</td>
					<td align="center">'.$totPersent.'</td>
					<td align="center">'.$totAbsent.'</td>
					<td align="center">'.$tot_students.'</td>
					<td align="center">'.$att_percentage.'%</td>
				  </tr>';
				  $i++;
				}
				
		}else{
			$html .='<tr>
				<td align="center" colspan=9>No Data Found</td>
			  </tr>';
		}

	}
		$email_id ='balasaheb.lengare@carrottech.in';
		$subj ='Attendance Report';
		$this->send_leave_mail($email_id, $subj, $html);
		//$html .='</table><br><br>';
		unset($school_code);
		unset($stream_id);
		unset($semester);
		unset($html);
		}
		//echo $html;
		//echo "<pre>";
		//print_r($data);
    }
    // mailing function
public function send_leave_mail($addres,$sub,$body){
	 $this->load->library('smtp');
	 $this->load->library('phpmailer');
	 $mail = new PHPMailer;

	//$mail->isSMTP();                            // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                     // Enable SMTP authentication
	$mail->Username = 'developers@sandipuniversity.com';          // SMTP username
	$mail->Password = 'university@24'; // SMTP password
	$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                          // TCP port to connect to

	$mail->setFrom('admindept@sandipuniversity.edu.in', 'Admin Department');
	$mail->addAddress($addres);

	//$mail->addReplyTo('admindept@sandipuniversity.in', 'Admin Department');
	//$mail->addCC('johnlangar@gmail.com');
	$mail->isHTML(true);  // Set email format to HTML
	$mail->Subject = $sub;
	 //$body .= "<span style='color:red;'>Note:This is an autogenerated mail,Please dont reply for this mail.</span>";

	$mail->Body    = $body;

		if(!$mail->send()) {
			return $mail->ErrorInfo;
		}else{
			return '1';
		}
	}	
 // attendance mailing functionality 
	public function timetable_schoolwise_mail(){
		//error_reporting(E_ALL);
		date_default_timezone_set("Asia/Kolkata");
		$todaysdate = '2018-08-14';	   
		$this->data['todaysdate'] = $todaysdate;	
		$day = date('l', strtotime($todaysdate));		
		$this->data['day'] = $day;
		$academic= $this->Timetable_model->fetch_Curracademic_session(); 
		$academic_year =$academic[0]['academic_year'];
		$academic_session =$academic[0]['academic_session'];
		if($academic_session=='WINTER'){
			$ses= "WIN";
		}else{
			$ses= "SUM";
		}
		$html ='';
		$schools = $this->Timetable_model->fetch_schools($todaysdate,$day,$academic_year,$ses);
		foreach ($schools as $val) {
			$school_code = $val['school_code'];
			$school_name = $val['school_name'];
			$streams = $this->Timetable_model->fetch_streams($school_code,$day, $academic_year,$ses);
			$this->data['streams'] =$streams;
			$i=0;
			foreach ($streams as $value) {
				$stream_id = $value['stream_id'];
				$stream_name = $value['stream_name'];
				$division = $value['division'];
				$semester = $value['semester'];

			$this->data['streams'][$i]['mdata'] = $this->Timetable_model->fetch_mailing_details($todaysdate,$day, $school_code, $stream_id,$semester, $division, $academic_year,$ses);
			$i++;
			}
		$email_id ='balasaheb.lengare@carrottech.in';
		$subj ='Attendance Report';
		//echo "<pre>";
		//print_r($this->data['streams']);
		$this->load->view('Attendance/mail_attendance_excel',$this->data);
		//$this->send_leave_mail($email_id, $subj, $html);
		//$html .='</table><br><br>';
		unset($school_code);
		unset($stream_id);
		unset($semester);
		//unset($html);
		}
		//echo $html;
		
	} 
    
 
}