<?php //error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');
class Student_attendance extends CI_Controller 
{
    var $currentModule="Student_attendance";
    var $title="";

    var $model_name="Student_Attendance_model";
    var $model;
    var $view_dir='Attendance/';
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
    }
    //view
    
    public function student_attendance_report()
    {
       //error_reporting(E_ALL);
        //$this->data['stud']=$this->Ums_admission_model->searchStudentsajax(array('prn'=>$this->session->userdata('name')));
$this->load->model('Subject_model'); 
        $this->load->model('Timetable_model');
        $this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id='');  
        $this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
        $this->data['school_list']= $this->Student_Attendance_model->get_school_list();
       // $this->data['absent_stud_list'] = $this->Student_Attendance_model->featch_absent_student_list();
        $this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'student_attendance_report',$this->data);
        $this->load->view('footer');
    }
    public function get_student_attendance(){
//error_reporting(E_ALL);
$arr['acd_yer']=$_REQUEST['acd_yer'];
$arr['curs']=$_REQUEST['curs'];
$arr['strm']=$_REQUEST['strm'];
$arr['sem']=$_REQUEST['sem'];
$arr['divis']=$_REQUEST['divis'];
$arr['fdt']=$_REQUEST['fdt'];
$arr['tdt']=$_REQUEST['tdt'];
$arr['frmper']=$_REQUEST['frmper'];
$arr['toper']=$_REQUEST['toper'];
$arr['schid']=$_REQUEST['schid'];
$this->data['stud_list']= $this->Student_Attendance_model->get_student_list($arr);
//print_r($this->data['stud_list']);
$this->data['sfdate']=$_REQUEST['fdt'];
$this->data['stdate']=$_REQUEST['tdt'];
$this->data['acd_yer']=$_REQUEST['acd_yer'];
//printf($this->data['stud_list']);
         $this->load->view($this->view_dir.'ajax_student_atten_list',$this->data);
    }
   public function get_student_list_apsent_details($sd){
   
        //error_reporting(E_ALL); ini_set('display_errors', '1');   
        $ex_sd=explode('~',$sd);    
        $stud_enroll_no = $ex_sd[2];
       $this->data['std_enr_no'] = $ex_sd[2];
        $this->load->view('header',$this->data); 
        $this->load->model('Subject_model');
         $this->load->model('Attendance_model');
        // fetch student details like stream,semester,div,batch
        $stud_det= $this->Student_Attendance_model->fetch_stud_details($stud_enroll_no);

        $division = $ex_sd[4];
            $this->data['student_name']=$stud_det[0]['first_name']." ".$stud_det[0]['last_name'];
        $this->data['course_short_name']= $stud_det[0]['course_short_name'];
        $this->data['stream_name']= $stud_det[0]['stream_short_name'];
        $this->data['semester']=$ex_sd[3];
        $this->data['course_id']= $stud_det[0]['course_id'];
        //$current_semester = $stud_det[0]['current_semester'];
        $current_semester= $ex_sd[3];
        if($stud_det[0]['batch'] !=0){
        $this->data['batch']= $stud_det[0]['division'].''.$stud_det[0]['batch'];
        }elseif($division !=''){
            $this->data['batch']= $division;    
        }else{
            $this->data['batch']= 'A';  
        }
        // load subjects of students
        $this->data['sb']= $this->Attendance_model->fetch_student_subjects($stud_enroll_no,$current_semester);
       // print_r($this->data['sb']);
        // load unique dates
        $dat['fdate']=$ex_sd[5];
        $dat['tdate']=$ex_sd[6];
        $this->data['attCnt']= $this->Student_Attendance_model->fetchStudAttDates1($stud_enroll_no,$current_semester,$dat);  
       // print_r($this->data['attCnt']) ;    
        for($i=0;$i<count($this->data['attCnt']);$i++){
            //echo "kk";
            $attendance_date = $this->data['attCnt'][$i]['attendance_date'];
            $studId = $this->data['attCnt'][$i]['stud_id'];
            for($j=0;$j<count($this->data['sb']);$j++){             
                $subId = $this->data['sb'][$j]['sub_id'];
                $this->data['attCnt'][$i]['subject'][$j]= $subId;
                $this->data['attCnt'][$i]['P_attCnt'][$j]= $this->Attendance_model->fetchStudAttPresent($attendance_date,$subId,$studId);
                $this->data['attCnt'][$i]['P_attCnt'][$j]['total']= $this->Attendance_model->fetchStudAttTotLecture($attendance_date,$subId,$studId);
                $this->data['attCnt'][$i]['P_attCnt'][$j]['absent']= $this->Attendance_model->fetchStudAttAbsent($attendance_date,$subId,$studId);
            }
        }
       // echo "<pre>";
        //print_r($this->data['attCnt']);//exit;
        $this->load->view($this->view_dir.'view_student_attendance_report_details',$this->data);
        $this->load->view('footer');    

   }

   function get_attendance_mark_report(){
	   //error_reporting(E_ALL);
	  $this->load->model('Erp_cron_attendance_model'); 
	  $this->load->model('Timetable_model');
	  $this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
	  $this->data['sch_list']= $this->Student_Attendance_model->get_school_list();  
       
       // $this->data['absent_stud_list'] = $this->Student_Attendance_model->featch_absent_student_list();
	   
        $this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'student_attendance_mark_report',$this->data);
        $this->load->view('footer');
   }
   function get_courses(){
    $crs_list = $this->Student_Attendance_model->get_course_list($_REQUEST['school_id']);
    echo "<option value=''>Select All Courses</option>";
foreach ($crs_list as $key => $value) {
   echo "<option value='".$value['course_id']."'>".$value['course_short_name']."</option>";
     }
 }

   function get_stream(){
    $stm_list = $this->Student_Attendance_model->get_stream_list($_REQUEST['course_id'],$_REQUEST['sch_id']);
    echo "<option value=''>Select All Streams</option>";
foreach ($stm_list as $key => $value) {
   echo "<option value='".$value['stream_id']."'>".$value['stream_name']."</option>";
}
if($_REQUEST["course_id"]=='2'){
					echo '<option value="9">B.Tech First Year</option>';
				}elseif($_REQUEST["course_id"]=='5'){
					echo '<option value="234">MBA First Year</option>';
				}elseif($_REQUEST["course_id"]=='4'){
					echo '<option value="235">BBA First Year</option>';
				}elseif($_REQUEST["course_id"]=='6'){
					echo '<option value="236">B.Com First Year</option>';
				}elseif($_REQUEST["course_id"]=='11'){
					echo '<option value="237">BCA First Year</option>';
				}elseif($_REQUEST["course_id"]=='9'){
					echo '<option value="238">B.Sc First Year</option>';
				}elseif($_REQUEST["course_id"]=='43'){
					echo '<option value="239">BBA HONOURS First Year</option>';
				}
   }
function get_semister(){
    $sem_list = $this->Student_Attendance_model->get_semister($_REQUEST['stream_id']);
    echo "<option value=''>Select All Semester</option>";
foreach ($sem_list as $key => $value) {
   echo "<option value='".$value['semester']."'>".$value['semester']."</option>";
}
   }
function get_division(){
    $div = $this->Student_Attendance_model->get_division($_REQUEST['semester'],$_REQUEST['stream_id']);
    echo "<option value=''>Select All Division</option>";
foreach ($div as $key => $value) {
   echo "<option value='".$value['division']."'>".$value['division']."</option>";
}

   }

   function get_mark_report(){

//error_reporting(E_ALL);
    $arr['acd_yer']=$_REQUEST['acd_yer'];
$arr['sch_id']=$_REQUEST['sch_id'];
$arr['curs']=$_REQUEST['curs'];
$arr['strm']=$_REQUEST['strm'];
$arr['sem']=$_REQUEST['sem'];
$arr['divis']=$_REQUEST['divis'];
$arr['fdt']=$_REQUEST['fdt'];
$arr['tdt']=$_REQUEST['tdt'];
$arr['rtyp']=$_REQUEST['rtyp'];
   $s = $this->Student_Attendance_model->get_dates($_REQUEST['fdt'],$_REQUEST['tdt']);
   $this->data['pdata']=$_REQUEST;
   $dtarr=[];
foreach ($s as $key => $value) {

    $dtarr[date('l',strtotime($value))]=date('Y-m-d',strtotime($value));
}
$this->data['sdate'] = $dtarr;
//$this->data['sdate']
$this->data['timtab']= $this->Student_Attendance_model->get_attendance_list($arr);

	if($_REQUEST['rtyp']=='m'){
	$this->load->view($this->view_dir.'ajax_student_att_mark_report',$this->data);
	}else{
	$this->load->view($this->view_dir.'ajax_student_att_report',$this->data);
	}
   }
   public function stud_rep_download($reg_no='') {
        // ob_start ();
        //$user_id = $this->session->userdata('user_id');
       $arr['acd_yer']=$_REQUEST['sacd_yer'];
       $arr['sch_id']=$_REQUEST['ssch_id'];
$arr['curs']=$_REQUEST['scurs'];
$arr['strm']=$_REQUEST['sstrm'];
$arr['sem']=$_REQUEST['ssem'];
$arr['divis']=$_REQUEST['sdivis'];
$arr['fdt']=$_REQUEST['sfdt'];
$arr['tdt']=$_REQUEST['stdt'];
$arr['rtyp']=$_REQUEST['srtyp'];
   $s = $this->Student_Attendance_model->get_dates($_REQUEST['sfdt'],$_REQUEST['stdt']);
   $dtarr=[];
foreach ($s as $key => $value) {

    $dtarr[date('l',strtotime($value))]=date('Y-m-d',strtotime($value));
}
$this->data['sdate'] = $dtarr;
   $this->data['pdata']=$arr;
$this->data['timtab']= $this->Student_Attendance_model->get_attendance_list($arr);
$this->data['exp']='Y';

        
        //load mPDF library
        $this->load->library('m_pdf');
        if($_REQUEST['srtyp']=='m'){
		$html = $this->load->view($this->view_dir.'ajax_student_att_mark_report',$this->data,true);
		$pdfFilePath = 'Attendance-mark-'.$this->data['timtab'][0]['school_name'].".pdf";
		}else{
				$html = $this->load->view($this->view_dir.'ajax_student_att_report',$this->data,true);
				$pdfFilePath = 'Attendance-not-mark-'.$this->data['timtab'][0]['school_name'].".pdf";
		}
        //$pdfFilePath = 'Attendance-not-mark-'.$this->data['timtab'][0]['school_name'].".pdf";

                         $mpdf=new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');
 $mpdf->autoScriptToLang = true;
                    $mpdf->baseScript = 1;  // Use values in classes/ucdn.php  1 = LATIN
                    $mpdf->autoVietnamese = true;
                 //   $mpdf->autoArabic = true;
                 //   $mpdf->autoLangToFont = true;
                    $mpdf->SetMargins(10,10,15);
                    $mpdf->SetDisplayMode('fullpage');                   
                    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($html);
        //$this->Results_model->update_resultdownloadStatus($reg_no);
        //download it.
        $mpdf->Output($pdfFilePath, "D");
        // ob_end_flush(); 
    }
   
        function load_lecture_cources(){
    //echo $_POST["course_id"];exit;
    if(isset($_POST["academic_year"]) && !empty($_POST["academic_year"])){
      //Get all streams
      $stream = $this->Student_Attendance_model->load_lecture_cources($_POST["academic_year"],$_REQUEST['sch_list']);
            
      //Count total number of rows
      $rowCount = count($stream);

      //Display cities list
      if($rowCount > 0){
        echo '<option value="">Select Course</option>';
        foreach($stream as $value){
          echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
        }
      }else{
        echo '<option value="">Courses not available</option>';
      }
    }
  } 
 function load_streams() {
        if (isset($_POST["course_id"]) && !empty($_POST["course_id"])) {
            //Get all city data
            $stream = $this->Student_Attendance_model->get_attendance_streams($_POST["course_id"],$_POST['academic_year'],$_POST['sch_id']);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Stream</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['stream_id'] . '">' . $value['stream_name'] . '</option>';
                }
				if($_POST["course_id"]==5){
					echo '<option value="234">MBA First Year</option>';
				}
				if($_POST["course_id"]==2){
					echo '<option value="9">B.Tech First Year</option>';
				}
				
				
            } else {
                echo '<option value="">stream not available</option>';
            }
        }
    } 

    function get_facultywise_report(){

        $this->load->model('Erp_cron_attendance_model'); 
    
        $this->load->model('Timetable_model');
       
        $this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
        $this->data['sch_list']= $this->Student_Attendance_model->get_school_list();  
       
       // $this->data['absent_stud_list'] = $this->Student_Attendance_model->featch_absent_student_list();
        $this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'facultywise_report',$this->data);
        $this->load->view('footer');
    }
    function get_faculty_report(){
      //error_reporting(E_ALL);
      //print_r($_REQUEST);exit;
      $arr['acd_yer']=$_REQUEST['acd_yer'];
 $arr['sch_id']=$_REQUEST['sch_id'];
$arr['curs']=$_REQUEST['curs'];
$arr['strm']=$_REQUEST['strm'];
$arr['fctl']=$_REQUEST['fctl'];
//$arr['divis']=$_REQUEST['divis'];
$arr['fdt']=$_REQUEST['fdt'];
$arr['tdt']=$_REQUEST['tdt'];

   $s = $this->Student_Attendance_model->get_dates($_REQUEST['fdt'],$_REQUEST['tdt']);
 // print_r($s);
  //exit;
   $dtarr=[];
	foreach ($s as $key => $value) {

		$dtarr[date('l',strtotime($value))]=date('Y-m-d',strtotime($value));
	}
	
	$this->data['sdate'] = $dtarr;
	$this->data['pdata']=$_REQUEST;
	$this->data['sdl'] =$s;
	$this->data['sublist'] = $this->Student_Attendance_model->get_faculty_lecture_list($arr);
		 // print_r($this->data['sublist']);
	//exit;
	$this->load->view($this->view_dir.'ajax_facultywise_report',$this->data);
}

    function get_faculty_list(){
       if (isset($_POST["sch_id"]) && !empty($_POST["sch_id"])) {
$arr['sch_id']=$_REQUEST['sch_id'];
$arr['curs']=$_REQUEST['curs'];
$arr['strm']=$_REQUEST['strm'];
            //Get all city data
            $fact = $this->Student_Attendance_model->get_faculty_lecture_list($arr);
            
            //Count total number of rows
            $rowCount = count($fact);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Faculty</option>';
                foreach ($fact as $value) {
                    echo '<option value="' . $value['faculty_code'] . '">'.$value['fname'].' '.$value['lname'] . '</option>';
                }
            } else {
                echo '<option value="">Faculty not available</option>';
            }
        }
    }
	
	function get_dates_test(){
		

// Declare two dates 
$Date1 = '01-10-2010'; 
$Date2 = '05-10-2010'; 

// Declare an empty array 
$array = array(); 

// Use strtotime function 
$Variable1 = strtotime($Date1); 
$Variable2 = strtotime($Date2); 

// Use for loop to store dates into array 
// 86400 sec = 24 hrs = 60*60*24 = 1 day 
for ($currentDate = $Variable1; $currentDate <= $Variable2; 
								$currentDate += (86400)) { 
									
$Store = date('Y-m-d', $currentDate); 
$array[] = $Store; 
} 

// Display the dates in array format 
print_r($array); 


	}
     public function faculty_rep_download() {
ini_set('memory_limit', '-1');
      //print_r($_REQUEST);exit;
        // ob_start ();
        //$user_id = $this->session->userdata('user_id');
       //error_reporting(E_ALL);
      $arr['acd_yer']=$_REQUEST['sacd_yer'];
       $arr['sch_id']=$_REQUEST['ssch_id'];
$arr['curs']=$_REQUEST['scurs'];
$arr['strm']=$_REQUEST['sstrm'];
$arr['fctl']=$_REQUEST['sfctl'];
$arr['fdt']=$_REQUEST['sfdt'];
$arr['tdt']=$_REQUEST['stdt'];

   $s = $this->Student_Attendance_model->get_dates($_REQUEST['sfdt'],$_REQUEST['stdt']);
   $dtarr=[];
foreach ($s as $key => $value) {

    $dtarr[date('l',strtotime($value))]=date('Y-m-d',strtotime($value));
}
$this->data['sdate'] = $dtarr;
$this->data['pdata']=$arr;
$this->data['sdl'] =$s;
$this->data['sublist']= $this->Student_Attendance_model->get_faculty_lecture_list($arr);
//print_r($this->data['sublist']);
//exit;
$this->data['school_name_h'] = $this->data['sublist'][0]['school_name'];
$this->data['exp']='Y';

        
        //load mPDF library
        $this->load->library('m_pdf');
       
 $html =  $this->load->view($this->view_dir.'ajax_facultywise_report',$this->data,true);

//exit;
//$this->load->view($this->view_dir.'ajax_facultywise_report',$this->data,true);

        $pdfFilePath = 'Faculty_report_'.$this->data['sublist'][0]['school_name'].".pdf";

                         $mpdf=new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');
 $mpdf->autoScriptToLang = true;
                    $mpdf->baseScript = 1;  // Use values in classes/ucdn.php  1 = LATIN
                    $mpdf->autoVietnamese = true;
                 //   $mpdf->autoArabic = true;
                 //   $mpdf->autoLangToFont = true;
                    $mpdf->SetMargins(10,10,15);
                    $mpdf->SetDisplayMode('fullpage');                   
                    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
//sleep(10);
        $mpdf->WriteHTML($html);
        //$this->Results_model->update_resultdownloadStatus($reg_no);
        //download it.
        $mpdf->Output($pdfFilePath, "D");
        // ob_end_flush(); 
    }

    public function faculty_rep_download1() {
    ini_set('memory_limit', '-1');
    
    $arr = [
        'acd_yer' => $_REQUEST['sacd_yer'],
        'sch_id' => $_REQUEST['ssch_id'],
        'curs' => $_REQUEST['scurs'],
        'strm' => $_REQUEST['sstrm'],
        'fctl' => $_REQUEST['sfctl'],
        'fdt' => $_REQUEST['sfdt'],
        'tdt' => $_REQUEST['stdt']
    ];

    $s = $this->Student_Attendance_model->get_dates($_REQUEST['sfdt'], $_REQUEST['stdt']);
    $dtarr = [];
    foreach ($s as $key => $value) {
        $dtarr[date('l', strtotime($value))] = date('Y-m-d', strtotime($value));
    }
    $sdate = $dtarr;
    $pdata = $arr;
    $sdl = $s;
    $sublist = $this->Student_Attendance_model->get_faculty_lecture_list($arr);
    $school_name_h = $this->data['sublist'][0]['school_name'];

    // Load mPDF library
    $this->load->library('m_pdf');
    $mpdf = new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');

    $html = '
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <style type="text/css">
    .table-bordered, .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, 
    .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
        border-color:#8acc82;
        border-collapse: collapse;
    }
    </style>';

    if (!empty($sublist)) {
        $j = 1;                             
        $p = 0; 
        $t = 0;
        $kk = [];
        $cntj = count($sublist);

        for ($i = 0; $i < $cntj; $i++) {  
            if ($t == 'r') {
                $t = $i - 1;
            } else {
                $t = $t;
            }
            $acd_yr = explode('~', $pdata['acd_yer']);

            if ($sublist[$t]['faculty_code'] != $sublist[$i]['faculty_code']) {
                if ($cnt != '0') {
                    $html = '
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                        <tr>
                            <td align="center">
                                <img src="http://erp.sandipuniversity.com/assets/images/logo_form.png" width="200" />
                                <p style="margin-top:0"><strong>Mahiravani, Trimbak Road, Nashik – 422 213</strong></p>
                            </td>
                        </tr>
                    </table>
                    <div style="text-align:center;color:red;padding-top:5px;padding-bottom:0px;font-size:15px;"><b>' . $school_name_h . '</b></div>
                    <div style="text-align:center;color:red;padding-top:5px;font-size:13px;"><b>Faculty Report</b></div>
                    <table id="dis_data" class="table table-bordered" border="1" cellspacing="0" cellpadding="3" style="border-color:#249f8a;border-collapse: collapse;font-size: 11px !important;font-family: "Arial", "Verdana" !important;" id="pdf_print">
                        <tr>
                            <td colspan="12" align="center" style="align:center;padding:10px;">
                                <h4><b>' . $sublist[0]['school_name'] . '</b></h4>
                                <b>Current Session: ' . $this->config->item('current_year') . '(';
                    if ($this->config->item('current_sess') == 'WIN') {
                        $html .= 'WINTER';
                    } else {
                        $html .= 'SUMMER';
                    }
                    $html .= ')</b>
                            </td>
                        </tr>';                        
                    $html .= '
                        <tr style="background-color:#6BCEEF;padding:10px;">
                            <td colspan="12" align="left" style="padding:10px;">
                                <b>Faculty: </b>
                                <span style="font-size:11px;"> ' . $sublist[$i]['fname'] . ' ' . $sublist[$i]['lname'] . '(' . $sublist[$i]['faculty_code'] . ')</span>
                            </td>
                        </tr>
                        <tr style="background-color:#D2D2D2;">
                            <th align="center" style="padding:10px;"><b>Sr.no</b></th>
                            <th style="padding:10px;" align="center"><b>Day</b></th>
                            <th style="padding:10px;" align="center"><b>School</b></th>
                            <th style="padding:10px;" align="center"><b>Stream</b></th>
                            <th style="padding:10px;" align="center"><b>Sem</b></th>
                            <th style="padding:10px;" align="center"><b>Div</b></th>
                            <th style="padding:10px;" align="center"><b>Subject Name</b></th>
                            <th style="padding:10px;" align="center"><b>Type</b></th>
                            <th style="padding:10px;" align="center"><b>Slot</b></th>
                            <th style="padding:10px;" align="center"><b>Present</b></th>
                            <th style="padding:10px;" align="center"><b>Absent</b></th>
                            <th style="padding:10px;" align="center"><b>Percentage</b></th>
                        </tr>';
                    $k = 1; 
                    $y = '1';
                }
            }

            foreach ($sdl as $s) {
                $fdate = $s;
                $tdate = $s;
                $rowa = $this->Student_Attendance_model->get_faculty_lecturs_fact_code($acd_yr[0], substr($acd_yr[1], 0, 3), $sublist[$i]['faculty_code'], $fdate, $tdate);
                $cnt = count($rowa);

                if ($cnt != '0') {
                    for ($j = 0; $j < $cnt; $j++) {
                        $dt = $sdate[$rowa[$j]['wday']];
                        $rowp = $this->Student_Attendance_model->get_student_attendance_data_duck($acd_yr[0], substr($acd_yr[1], 0, 3), $fdate, $rowa[$j]['stream_id'], $rowa[$j]['semester'], $rowa[$j]['division'], $rowa[$j]['lecture_slot'], $sublist[$i]['faculty_code'], $rowa[$j]['batch']);
                        $assign_f = $sublist[$i]['faculty_code'];
                        $taken_f = $rowp[0]['faculty_code'];
                        $rs = '';

                        if($taken_f !=''){
						if($taken_f!=$assign_f){ 
						  $rs=2; 
						  //$rs='';
						}else{
						  $rs='';
						}
						}else{
						  $rs='';
						}

                        $html .= '
                        <tr>
                            <td rowspan="' . $rs . '" align="center">' . $k . '</td>
                            <td rowspan="' . $rs . '">';

                        if ($z != $rowa[$j]['wday']) {
                            $html .= $fdate;
                            $z = $rowa[$j]['wday'];
                        } else {
                            if ($y == '1') {
                                $html .= $dt;
                            }
                        }

                        $html .= '</td>
                            <td rowspan="' . $rs . '" align="center">' . $rowa[$j]['school_short_name'] . '</td>
                            <td rowspan="' . $rs . '">' . $rowa[$j]['stream_name'] . '</td>
                            <td rowspan="' . $rs . '" align="center">' . $rowa[$j]['semester'] . '</td>
                            <td rowspan="' . $rs . '" align="center">' . $rowa[$j]['division'] . '</td>
                            <td rowspan="' . $rs . '">';

                        $subject_codes = [
                            'OFF' => 'OFF Lecture',
                            'Library' => 'Library',
                            'Tutorial' => 'Tutorial',
                            'Tutor' => 'Tutor',
                            'IS' => 'Internet Slot',
                            'RC' => 'Remedial Class',
                            'EL' => 'Experiential Learning',
                            'SPS' => 'Swayam Prabha Session',
                            'ST' => 'Spoken Tutorial',
                            'FAM' => 'Faculty Advisor Meet'
                        ];

                        $html .= $subject_codes[$rowa[$j]['subject_code']] ?? ($rowa[$j]['sub_code'] . ' - ' . $rowa[$j]['subject_name']);

                        $html .= '</td>
                            <td rowspan="' . $rs . '" align="center">';
                        $html .= $rowa[$j]['subject_type'] == 'TH' ? 'Th' : 'PR';
                        $html .= '</td>
                            <td rowspan="' . $rs . '">' . $rowa[$j]['from_time'] . '-' . $rowa[$j]['to_time'] . '</td>';

                        if ($rs == '2') {
                            $html .= '<td colspan="3" style="color:green;"><b>' . $rowp[0]['fname'] . ' ' . $rowp[0]['lname'] . ' (' . $taken_f . ')</b></td>';
                        } else {
                            if ($rowp[0]['tpresent'] == '') {
                                $html .= '<td colspan="3" align="center">';

                                $lv = $this->Student_Attendance_model->check_leave($sublist[$i]['faculty_code'], $fdate);
                                $hd = $this->Student_Attendance_model->check_holidays($fdate, $sublist[$i]['staff_type']);

                                if ($lv == 'N' && $hd == 'false') {
                                    $is_for_other = $this->Student_Attendance_model->check_other_duty($sublist[$i]['faculty_code'], $fdate);
                                    if (!empty($is_for_other)) {
                                        $html .= $is_for_other->task_name;
                                    } else {
                                        $df[$sublist[$i]['faculty_code']][] = 1;
                                        $html .= '<img src="' . site_url() . 'assets/images/duck1.png" width="40px" height="40px" /> ';
                                    }
                                } else {
                                    if ($hd == 'true' || $hd == 'RD') {
                                        $html .= "<b>Holiday</b>";
                                    } else {
                                        $html .= "<b>Leave - " . $lv . " </b>";
                                    }
                                }

                                $html .= '</td>';
                            } else {
                                $html .= '
                                <td align="center"><b>' . $rowp[0]['tpresent'] . '</b></td>
                                <td align="center"><b>' . $rowp[0]['tapsent'] . '</b></td>
                                <td align="center"><b>' . $rowp[0]['percen_lecturs'] . '</b></td>';
                            }
                        }
                        $html .= '</tr>';

                        if ($rs == '2') {
                            $html .= '
                            <tr>
                                <td align="center"><b>' . $rowp[0]['tpresent'] . '</b></td>
                                <td align="center"><b>' . $rowp[0]['tapsent'] . '</b></td>
                                <td align="center"><b>' . $rowp[0]['percen_lecturs'] . '</b></td>
                            </tr>';
                        }

                        $k++;
                        $y = '';
                    }

                    $t = 'r';
                } else {
                    $p++;
                    $t = $i - $p;
                }
            }

            $html .= '
            <tr>
                <td colspan="9" align="right" style="padding:10px;"><b>Total No. Ducks:</b></td>
                <td colspan="3" align="center" style="color:red;padding:10px;font-size:15px;"><b>' . count($df[$sublist[$i]['faculty_code']]) . '</b></td>
            </tr>
            </tbody></table>';

            $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
            $mpdf->AddPage();
            $mpdf->WriteHTML($html);
        }
    }

    $pdfFilePath = 'Faculty_report_' . $sublist[0]['school_name'] . '.pdf';

    $mpdf->autoScriptToLang = true;
    $mpdf->baseScript = 1;  // Use values in classes/ucdn.php  1 = LATIN
    $mpdf->autoVietnamese = true;
    $mpdf->SetMargins(10, 10, 15);
    $mpdf->SetDisplayMode('fullpage');

    $mpdf->Output($pdfFilePath, "D");
}
 function get_commulative_attendance_report11(){
    $this->load->model('Erp_cron_attendance_model'); 
        $this->load->model('Timetable_model');
          $this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
        $this->data['sch_list']= $this->Erp_cron_attendance_model->get_school_list();  
       
       // $this->data['absent_stud_list'] = $this->Student_Attendance_model->featch_absent_student_list();
        $this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'commulative_attendance_report',$this->data);
        $this->load->view('footer');
   }
   function attendance_mark_report_all()
   {
	   $this->load->model('Timetable_model');
       $this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
	   $this->load->view('header',$this->data);        
       $this->load->view($this->view_dir.'attendance_mark_report',$this->data);
       $this->load->view('footer');
   }
   function get_rolewise_attendance_mark_report()
   {
   $arr['sub_type']=$_REQUEST['sub_type'];
   $arr['acd_yer']=$_REQUEST['acd_yer'];
   $sfdt=$arr['fdt']=$_REQUEST['fdt'];
   $stdt=$arr['tdt']=$_REQUEST['tdt'];
   $arr['attendance_date']=$_REQUEST['fdt'];
   $day = date('l', strtotime($sfdt)); 
   $this->data['fdate'] = $sfdt;
   $this->data['tdate'] = $stdt;
   $this->data['sub_type'] = $_REQUEST['sub_type'];

  $this->data['pdata']=$arr;
  $this->data['timtab']= $this->Student_Attendance_model->get_attendance_mark_report_list($arr);
  $this->load->view($this->view_dir.'ajax_attendance_mark_report',$this->data);
}
  function stud_attendance_mark_report_download() { 
   $arr['acd_yer']=$_REQUEST['sacd_yer'];
   $arr['sub_type']=$_REQUEST['sub_type'];
   $sfdt=$arr['fdt']=$_REQUEST['sfdt'];
   $stdt=$arr['tdt']=$_REQUEST['stdt'];
   $arr['attendance_date']=$_REQUEST['sfdt'];
   $day = date('l', strtotime($sfdt)); 
   $this->data['fdate'] = $sfdt;
   $this->data['tdate'] = $stdt;

   $this->data['pdata']=$arr;
   $this->data['timtab']= $this->Student_Attendance_model-> get_attendance_mark_report_list($arr);

     $this->data['exp']='Y';   
     $this->load->library('m_pdf');

      $html = $this->load->view($this->view_dir.'ajax_attendance_mark_report',$this->data,true);
      $pdfFilePath = 'SUN-Cumulative Attendance-mark-'.$arr['fdt'].".pdf";

        $mpdf=new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');
        $mpdf->autoScriptToLang = true;
		$mpdf->baseScript = 1;  // Use values in classes/ucdn.php  1 = LATIN
		$mpdf->autoVietnamese = true;
	 //   $mpdf->autoArabic = true;
	 //   $mpdf->autoLangToFont = true;
		$mpdf->SetMargins(10,10,15);
		$mpdf->SetDisplayMode('fullpage');                   
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($html);
        //$this->Results_model->update_resultdownloadStatus($reg_no);
        //download it.
        $mpdf->Output($pdfFilePath, "D");
        // ob_end_flush(); 
    } 
      function get_commulative_report(){
//error_reporting(E_ALL);
$arr['acd_yer']=$_REQUEST['acd_yer'];
$arr['sch_id']=$_REQUEST['sch_id'];
$arr['curs']=$_REQUEST['curs'];
$arr['strm']=$_REQUEST['strm'];
$arr['sem']=$_REQUEST['sem'];
$arr['divis']=$_REQUEST['divis'];
$arr['fdt']=$_REQUEST['fdt'];
$arr['tdt']=$_REQUEST['tdt'];
$arr['rtyp']=$_REQUEST['rtyp'];
$arr['attendance_date']=$_REQUEST['fdt'];
   $s = $this->Student_Attendance_model->get_dates($_REQUEST['fdt'],$_REQUEST['tdt']);
   $this->data['pdata']=$_REQUEST;
   $dtarr=[];
foreach ($s as $key => $value) {

    $dtarr[date('l',strtotime($value))]=date('Y-m-d',strtotime($value));
}
$this->data['sdate'] = $dtarr;
$day = date('l', strtotime($_REQUEST['fdt'])); 
$this->data['sdate'] = $_REQUEST['fdt'];
$this->data['day'] = $day ;
//$this->data['sdate']
$this->data['timtab']= $this->Student_Attendance_model->get_commu_attendance_list($arr);
$this->load->view($this->view_dir.'ajax_student_att_commu_report',$this->data);
}
      public function get_commulative_attendance_report_pdf() {
        // ob_start ();
        //$user_id = $this->session->userdata('user_id');
		$sfdt= date('Y-m-d');
		$stdt= date('Y-m-d');
       $arr['acd_yer']='2023-24~SUMMER';
       $arr['sch_id']=$_REQUEST['ssch_id'];
$arr['curs']=$_REQUEST['scurs'];
$arr['strm']=$_REQUEST['sstrm'];
$arr['sem']=$_REQUEST['ssem'];
$arr['divis']=$_REQUEST['sdivis'];
$arr['fdt']=$_REQUEST['sfdt'];
$arr['tdt']=$_REQUEST['stdt'];
$arr['rtyp']=$_REQUEST['srtyp'];
$arr['attendance_date']=$sfdt;
$day = date('l', strtotime($sfdt)); 
$this->data['sdate'] = $sfdt;
$this->data['day'] = $day ;


  $this->data['pdata']=$arr;
   //print_r($arr);exit;
$this->data['timtab']= $this->Student_Attendance_model->get_commu_attendance_list($arr);
$this->data['exp']='Y';

   //  echo'<pre>';
    // print_r($this->data['timtab']);exit;	 
        //load mPDF library
        $this->load->library('m_pdf');

$html = $this->load->view($this->view_dir.'ajax_student_att_commu_report_pdf',$this->data,true);

//echo $html;exit();
 $pdfFilePath = "school_wise_attandance_report_".$sfdt.".pdf";

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
        //$this->Results_model->update_resultdownloadStatus($reg_no);
        //download it.
        $mpdf->Output($pdfFilePath, "D");
		/* $mpdf->Output($_SERVER['DOCUMENT_ROOT'] .'/uploads/payment/attendance/notmarkattendance/'.$pdfFilePath, 'F');
                  $file=$_SERVER['DOCUMENT_ROOT'] ."/uploads/payment/attendance/notmarkattendance/".$pdfFilePath;
                      $subject='Daily Attendance Report';
                        sleep(5);
                        $body="Dear all, 
                           Please find the attached file of Daily Attendance Report";
                        $this->sendattachedemail($body,$email='balasaheb.lengare@carrottech.in',$subject,$file);
                        sleep(5); */
        // ob_end_flush(); 
    }
	//email functionality
     public function sendattachedemail($body,$email,$subject,$file)
    {
        $path=$_SERVER["DOCUMENT_ROOT"].'/application/third_party/';
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
        $mail->Host = 'smtp.gmail.com';
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 465;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        //Username to use for SMTP authentication
            $mail->Username = 'NoReply2@sandipuniversity.com';
        //Password to use for SMTP authentication
        //$mail->Password = '123Indi@';
          $mail->Password = '*K052r4ItvjN';
        //Set who the message is to be sent from
        $mail->setFrom('info@sandipuniversity.edu.in', '');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to
        $mail->addAddress('chaitali.veer@sandipfoundation.org', 'Chaitali');
        $mail->AddAddress('balasaheb.lengare@carrottech.in', 'balasaheb');
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
        
        $mail->AddAttachment($file);
        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message sent!';
        }
    } 
public function get_commulative_attendance_report() {
        // ob_start ();
        //$user_id = $this->session->userdata('user_id');
		$sfdt= date('Y-m-d');
		$stdt= date('Y-m-d');
       $arr['acd_yer']='2023-24~SUMMER';
       $arr['sch_id']=$_REQUEST['ssch_id'];
$arr['curs']=$_REQUEST['scurs'];
$arr['strm']=$_REQUEST['sstrm'];
$arr['sem']=$_REQUEST['ssem'];
$arr['divis']=$_REQUEST['sdivis'];
$arr['fdt']=$_REQUEST['sfdt'];
$arr['tdt']=$_REQUEST['stdt'];
$arr['rtyp']=$_REQUEST['srtyp'];
$arr['attendance_date']=$sfdt;
$day = date('l', strtotime($sfdt)); 
$this->data['sdate'] = $sfdt;
$this->data['day'] = $day ;


   $this->data['pdata']=$arr;
   //print_r($arr);exit;
$this->data['timtab']= $this->Student_Attendance_model->get_commu_attendance_list($arr);
$this->data['exp']='Y';
        
        //load mPDF library
        //$this->load->library('m_pdf');

$html = $this->load->view($this->view_dir.'ajax_student_att_commu_report_pdf',$this->data,true);
echo $html;exit();
 $pdfFilePath = "school_wise_attandance_report_".$sfdt.".pdf";

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
        //$this->Results_model->update_resultdownloadStatus($reg_no);
        //download it.
        //$mpdf->Output($pdfFilePath, "D");
		$mpdf->Output($_SERVER['DOCUMENT_ROOT'] .'/uploads/payment/attendance/notmarkattendance/'.$pdfFilePath, 'F');
                  $file=$_SERVER['DOCUMENT_ROOT'] ."/uploads/payment/attendance/notmarkattendance/".$pdfFilePath;
                      $subject='Daily Attendance Report';
                        sleep(5);
                        $body="Dear all, 
                           Please find the attached file of Daily Attendance Report";
                        $this->sendattachedemail($body,$email='balasaheb.lengare@carrottech.in',$subject,$file);
                        sleep(5);
        // ob_end_flush(); 
    }
	
	public function coursewise_inout_punching_Students()
	{
		$this->load->view('header',$this->data);
        $this->load->model('Timetable_model');		
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
        $this->load->view($this->view_dir.'inout_punching_view',$this->data);
        $this->load->view('footer');		
	}
	
	public function search_inout_punching_Students()
    {                
        $course_id = $_REQUEST['course_id'];
        $stream_id = $_REQUEST['stream_id'];
		$semester = $_REQUEST['semester'];
		$division = $_REQUEST['division'];
		$log_date = $_REQUEST['log_date'];
		$academic_year = explode('~', $_REQUEST['academic_year']);
		$this->data['academicyear'] = $_REQUEST['academic_year'];
		//$academic_year =$_REQUEST['academic_year'];

		$strm_code = $this->Student_Attendance_model->getStreamCode($stream_id);
		$stream_code = $strm_code[0]['stream_code'];
		$this->data['streamName'] = $strm_code[0]['stream_name'];
		//$batch_code = $subject_id[1].'-'.$subject_id[2];
		$batch_code = $stream_code.'-'.$division;
		
		//$this->data['subdetails']= $this->Attendance_model->getsubdetails($subject_id[0]);
		if(!empty($stream_id) && !empty($semester)){
			$this->data['batchstudents']= $this->Student_Attendance_model->getStudinoutpunchingList($stream_id,$semester,$division,$academic_year[0],$log_date);			
		}
        $this->load->view($this->view_dir.'search_inout_punching_view',$this->data);
    } 
	  public function stud_attendance_mark_report_excel_download()
	  {          
	   $arr['acd_yer']=$_REQUEST['sacd_yer'];
	   $arr['sub_type']=$_REQUEST['sub_type'];
	   $sfdt=$arr['fdt']=$_REQUEST['sfdt'];
	   $stdt=$arr['tdt']=$_REQUEST['stdt'];
	   $arr['attendance_date']=$_REQUEST['sfdt'];
	   $day = date('l', strtotime($sfdt)); 
	   $this->data['fdate'] = $sfdt;
	   $this->data['tdate'] = $stdt;
	   $this->data['pdata']=$arr;
	   $this->data['timtab']= $this->Student_Attendance_model-> get_attendance_mark_report_list($arr);
       $this->data['exp']='Y'; 
       $this->load->view($this->view_dir.'stud_attend_mark_report_list_exl_export',$this->data);
	   
	   }
	   ////////////////////////
	   public function lecture_attendance_report($type=''){
		$this->load->view('header',$this->data);
		$this->data['stud_data']=$this->Student_Attendance_model->fetch_lecture_attendance_data();

		$re_stud_data = [];
		foreach ($this->data['stud_data'] as $data) {
			$stream_id = $data['stream_id'];
			$semester_id = $data['semester'];
			$rereg_data = $this->Student_Attendance_model->fetch_lecture_attendance_reregister_data($stream_id, $semester_id);
        
        $data['rereg_stud_count'] = $rereg_data['rereg_stud_count'];
        $re_stud_data[] = $data;
     }

     $this->data['re_stud_data'] = $re_stud_data;
	 
		$this->load->library('m_pdf');

		if($type=='PDF'){
		
		$html = $this->load->view($this->view_dir.'lecture_attendance_report_pdf', $this->data, true);	
		$pdfFilePath ="lecture_attendance.pdf";
		//$this->m_pdf->pdf=new mPDF('','A4','','',5,5,15,15,5,5);	
		$this->m_pdf->pdf=new mPDF('L','A4-L','','',5,10,5,17,5,10);
		$this->m_pdf->pdf->WriteHTML($html);
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
       }
	   elseif($type=='mail')
	   {
		   
		    $html = $this->load->view($this->view_dir.'lecture_attendance_report_pdf', $this->data, true);	
		    $this->m_pdf->pdf = new mPDF('L','A4-L','','',5,10,5,17,5,10);
			$this->m_pdf->pdf->WriteHTML($html);
			$pdfData=$this->m_pdf->pdf->Output('', "S");
			$file='Cumulative Daily Lecture Attendance Report-'.date('d-m-Y').'.pdf';			
		    $path=$_SERVER["DOCUMENT_ROOT"].'/application/third_party/';
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
			$mail->Host = 'smtp.gmail.com';
			//Set the SMTP port number - likely to be 25, 465 or 587
			$mail->Port = 465;
			//Whether to use SMTP authentication
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->Username = 'NoReply5@sandipuniversity.edu.in'; 
			$mail->Password = 'n2sdMk3*5bW78@9YZ6z0';
			//Set who the message is to be sent from
			$mail->setFrom('NoReply5@sandipuniversity.edu.in', 'SUN');
			$mail->AddAddress('siddesh.nangle@sandipuniversity.edu.in');
			$mail->AddAddress('pramod.karole@sandipuniversity.edu.in');
			$mail->AddAddress('balasaheb.lengare@carrottech.in');
			$mail->isHTML(true);   
			$subject='Cumulative Daily Lecture Attendance Report-'.date('d-m-Y');
			$body="Dear Sir, 
						   Please find the attached file of Daily Lecture Attendance Report";
			$mail->Subject = $subject;
			$mail->Body = $body;
			$mail->AltBody = 'This is a plain-text message body';
			$mail->addStringAttachment($pdfData, $file, 'base64', 'application/pdf');

			 if (!$mail->send()) { echo"Something Went Wrong!!!";exit;} else { //redirect('Student_attendance/lecture_attendance_report');
			 }
	   }
	   else{

		$this->load->view($this->view_dir.'lecture_attendance_report',$this->data);
	    $this->load->view('footer');
	   }
	}

	
public function generateLectureAttendanceExcel()
{
    $this->load->library('excel');
    
    // Fetch data (replace this with your actual data retrieval logic)
    $stud_data = $this->Student_Attendance_model->fetch_lecture_attendance_data();
    header('Content-Type: application/vnd.ms-excel');
    header('Cache-Control: max-age=0');
    header('Content-Disposition: attachment;filename="lecture_attendance.xls"');

    $styleArray = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
    $styleArray1 = array(
        'font'  => array(
            'bold'  => true,
            'size'  => 8,
            'name'  => 'Arial'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        )
    );
    $styleArray2 = array(
        'font'  => array(
            'size'  => 8,
            'name'  => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        )
    );

    $object = new PHPExcel();
    $object->setActiveSheetIndex(0);

	$object->getActiveSheet()->mergeCells('B2:M2');
    $object->getActiveSheet()->getStyle('B2:M2')->applyFromArray($styleArray1);
    $object->getActiveSheet()->setCellValue('B2', 'SANDIP UNIVERSITY');
    $object->getActiveSheet()->mergeCells('B3:M3');
    $object->getActiveSheet()->getStyle('B3:M3')->applyFromArray($styleArray1);
    $object->getActiveSheet()->setCellValue('B3', 'TRIMBAK ROAD, MAHIRAVANI, NASHIK-422213');
    $object->getActiveSheet()->mergeCells('B6:M6');
    $object->getActiveSheet()->getStyle('B6:M6')->applyFromArray($styleArray1);
    $object->getActiveSheet()->setCellValue('B6', 'Student Attendance Details');

    // Set Header Rows starting from A8
    $object->getActiveSheet()->setCellValue('A8', '#')->mergeCells('A8:A9')->getStyle('A8:A9')->applyFromArray($styleArray)->applyFromArray($styleArray1);
    $object->getActiveSheet()->setCellValue('B8', 'Program Name')->mergeCells('B8:B9')->getStyle('B8:B9')->applyFromArray($styleArray)->applyFromArray($styleArray1);
    
    $object->getActiveSheet()->setCellValue('C8', 'I Sem')->mergeCells('C8:D8')->getStyle('C8:D8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
    $object->getActiveSheet()->setCellValue('E8', 'III Sem')->mergeCells('E8:F8')->getStyle('E8:F8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
    $object->getActiveSheet()->setCellValue('G8', 'V Sem')->mergeCells('G8:H8')->getStyle('G8:H8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
    $object->getActiveSheet()->setCellValue('I8', 'VII Sem')->mergeCells('I8:J8')->getStyle('I8:J8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
    $object->getActiveSheet()->setCellValue('K8', 'IX Sem')->mergeCells('K8:L8')->getStyle('K8:L8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
    $object->getActiveSheet()->setCellValue('M8', 'Percentage')->mergeCells('M8:M9')->getStyle('M8:M9')->applyFromArray($styleArray)->applyFromArray($styleArray1);

    // Second Row Headers starting from A9
    $object->getActiveSheet()->setCellValue('C9', 'Total')->getStyle('C9')->applyFromArray($styleArray)->applyFromArray($styleArray1);
    $object->getActiveSheet()->setCellValue('D9', 'Present')->getStyle('D9')->applyFromArray($styleArray)->applyFromArray($styleArray1);

    $object->getActiveSheet()->setCellValue('E9', 'Total')->getStyle('E9')->applyFromArray($styleArray)->applyFromArray($styleArray1);
    $object->getActiveSheet()->setCellValue('F9', 'Present')->getStyle('F9')->applyFromArray($styleArray)->applyFromArray($styleArray1);

    $object->getActiveSheet()->setCellValue('G9', 'Total')->getStyle('G9')->applyFromArray($styleArray)->applyFromArray($styleArray1);
    $object->getActiveSheet()->setCellValue('H9', 'Present')->getStyle('H9')->applyFromArray($styleArray)->applyFromArray($styleArray1);

    $object->getActiveSheet()->setCellValue('I9', 'Total')->getStyle('I9')->applyFromArray($styleArray)->applyFromArray($styleArray1);
    $object->getActiveSheet()->setCellValue('J9', 'Present')->getStyle('J9')->applyFromArray($styleArray)->applyFromArray($styleArray1);

    $object->getActiveSheet()->setCellValue('K9', 'Total')->getStyle('K9')->applyFromArray($styleArray)->applyFromArray($styleArray1);
    $object->getActiveSheet()->setCellValue('L9', 'Present')->getStyle('L9')->applyFromArray($styleArray)->applyFromArray($styleArray1);

    // Populate Data starting from row 10
    $i = 1;
    $j = 10;

    $organized_data = [];
    foreach ($stud_data as $row) {
        $organized_data[$row['stream_name']][$row['semester']] = [
            'stud_count' => $row['stud_count'],
            'present_count' => $row['present_count'],
            'present_percentage' => $row['present_percentage']
        ];
    }

    foreach ($organized_data as $stream_name => $semesters) {
        $sem1_total = isset($semesters[1]) ? $semesters[1]['stud_count'] : '';
        $sem1_present = isset($semesters[1]) ? $semesters[1]['present_count'] : '';

        $sem3_total = isset($semesters[3]) ? $semesters[3]['stud_count'] : '';
        $sem3_present = isset($semesters[3]) ? $semesters[3]['present_count'] : '';

        $sem5_total = isset($semesters[5]) ? $semesters[5]['stud_count'] : '';
        $sem5_present = isset($semesters[5]) ? $semesters[5]['present_count'] : '';

        $sem7_total = isset($semesters[7]) ? $semesters[7]['stud_count'] : '';
        $sem7_present = isset($semesters[7]) ? $semesters[7]['present_count'] : '';

        $sem9_total = isset($semesters[9]) ? $semesters[9]['stud_count'] : '';
        $sem9_present = isset($semesters[9]) ? $semesters[9]['present_count'] : '';

        $total_percentage = 0;
        $count = 0;
        foreach ([$semesters[1]['present_percentage'] ?? 0, $semesters[3]['present_percentage'] ?? 0, $semesters[5]['present_percentage'] ?? 0, $semesters[7]['present_percentage'] ?? 0, $semesters[9]['present_percentage'] ?? 0] as $percentage) {
            if ($percentage !== 0) {
                $total_percentage += $percentage;
                $count++;
            }
        }
        $avg_percentage = ($count > 0) ? round($total_percentage / $count, 2) : '';

        $object->getActiveSheet()->setCellValue('A'.$j, $i)->getStyle('A'.$j.':M'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
        $object->getActiveSheet()->setCellValue('B'.$j, $stream_name);
        $object->getActiveSheet()->setCellValue('C'.$j, $sem1_total);
        $object->getActiveSheet()->setCellValue('D'.$j, $sem1_present);
        $object->getActiveSheet()->setCellValue('E'.$j, $sem3_total);
        $object->getActiveSheet()->setCellValue('F'.$j, $sem3_present);
        $object->getActiveSheet()->setCellValue('G'.$j, $sem5_total);
        $object->getActiveSheet()->setCellValue('H'.$j, $sem5_present);
        $object->getActiveSheet()->setCellValue('I'.$j, $sem7_total);
        $object->getActiveSheet()->setCellValue('J'.$j, $sem7_present);
        $object->getActiveSheet()->setCellValue('K'.$j, $sem9_total);
        $object->getActiveSheet()->setCellValue('L'.$j, $sem9_present);
        $object->getActiveSheet()->setCellValue('M'.$j, $avg_percentage);

        $i++;
        $j++;
    }
    $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
    $objWriter->setPreCalculateFormulas(true);
    $objWriter->save('php://output');
}
	   /////////////////////////
	   
    public function generate_pdf() {
        $this->load->model('DuckReportModel');
        $this->load->model('Erp_cron_attendance_model');
        $this->load->library('m_pdf');
    
        $date =date('Y-m-d');
        $academic_year = ACADEMIC_YEAR;
        $academic_session = CURRENT_SESS;
        $month = date('Y-m');; // Example: January 2025
        //$faculty_code = '110073';
    
        // Fetch lecture timetable data
        $lecture_data = $this->DuckReportModel->getLectureTimeTable($academic_year, $date, $academic_session);
    
        // Prepare data for the report
        $report_data = [];
        foreach ($lecture_data as $lecture) {
            $faculty_code = $lecture['faculty_code'];
            $subject_id = $lecture['subject_code'];
            $lecture_slot = $lecture['lecture_slot'];
    
            $lv = $this->DuckReportModel->check_leave($lecture['faculty_code'], $date);
            $hd = $this->Erp_cron_attendance_model->check_holidays($date, $lecture['staff_type']);
			if($lv!='N'){
            $lv = explode('~', $lv);
			}
    //print($lv);
            // Fetch scheduled and conducted lectures
            $lectures = $this->DuckReportModel->getTotalLectures($faculty_code, $academic_year, $academic_session, $month, $date, $lv);

            // Create the unique key
            $key = $subject_id . '_' . $lecture['batch_no'] . '_' . $lecture['division']. '_' . $lecture['lecture_slot'];
            
            // Retrieve the scheduled and conducted lectures for the specific batch and division
            $scheduled_lectures = isset($lectures['scheduled_lectures'][$key]) ? $lectures['scheduled_lectures'][$key] : 0;
            $conducted_lectures = isset($lectures['conducted_lectures'][$key]) ? $lectures['conducted_lectures'][$key] : 0;
            
            // Calculate total ducks (missed lectures)
            $total_ducks = max(0, $scheduled_lectures - $conducted_lectures);

            //print_r($scheduled_lectures );echo '--'; print_r($conducted_lectures );echo '<br>';
           //exit;
            
    
            $attendance = $this->DuckReportModel->checkAttendance($academic_year, $date, $faculty_code, $subject_id, $lecture_slot, $academic_session,$lecture['division'], $lecture['batch_no']);
			//echo '<pre>';print_r($attendance['faculty_code']);
			if(!empty($attendance['faculty_code'])){
				$today = 0;
			}else{
				 $today = 1;
			}
    
            if ($lv[0] == 'CL(Full Day)') {
                $ltoday = 'Leave';
            }
            if ($hd == '') {
                $ltoday = 'Holiday';
            }
			// $report_data['total_ducks'] = $total_ducks;
    
           //if (!$attendance) {
                // Faculty missed attendance, add to report
                $report_data[] = [
                    'date' => $date,
                    'academic_year' => $academic_year,
                    'academic_session' => $academic_session,
                    'faculty' => $lecture['fname'] . ' ' . $lecture['mname'] . ' ' . $lecture['lname'] . ' (' . $lecture['designation_name'] . ')',
                    'faculty_code' => $faculty_code,
                    'designation' => $lecture['designation_name'],
                    'school_stream' => $lecture['school_short_name'] . ' - ' . $lecture['stream_short_name'],
                    'semester' => $lecture['semester'],
                    'division' => $lecture['division'],
                    'batch' => $lecture['batch_no'],
                    'subject' => $lecture['subject_name'],
                    'subcod' => $lecture['subcod'],
                    'subtype' => $lecture['subject_type'],
                    'slot' => $lecture['from_time'] . ' - ' . $lecture['to_time'] . ' (' . $lecture['slot_am_pm'] . ')',
                    'today' => $today,
                    'levtoday' => $ltoday,
                    'total_ducks' => $total_ducks
                ];
           // }
		   unset($attendance);
        }
    
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
                    <div style="font-size: 14px; font-weight: bold;">Attendance Not Marked Cum Duck Report</div>
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
    
        // Load view and generate PDF
        $html = $this->load->view('duck_report_view', ['report_data' => $report_data], true);
        $mpdf = new mPDF('L', 'A4', '', '', 5, 5, 35, 15, 5, 5);
        $mpdf->SetHTMLHeader($headerHTML);
        $mpdf->SetHTMLFooter($footerHTML);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Duck_Report.pdf', 'I'); // Display the PDF in the browser
    }
	public function sendReRegistrationReport11()
	{
		$this->load->model('Student_Attendance_model');
		$this->load->library('pdf'); // Make sure PDF library is loaded
		$this->load->library('email');

		$data = $this->Student_Attendance_model->getReRegistrationReport();

		// Load PDF view and generate
		echo $html = $this->load->view('Attendance/re_registration_pdf', ['reportData' => $data], TRUE);exit;

		$filename = 'ReRegistration_Report_' . date('Ymd_His') . '.pdf';
		$pdfPath = FCPATH . 'uploads/reports/' . $filename;

		$this->pdf->loadHtml($html);
		$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->render();
		file_put_contents($pdfPath, $this->pdf->output());

		// Send Email with PDF attachment
		$this->email->from('your@email.com', 'Admin');
		$this->email->to('recipient@email.com');
		$this->email->subject('School-wise Re-Registration Report');
		$this->email->message('Please find attached the re-registration report.');
		$this->email->attach($pdfPath);

		if ($this->email->send()) {
			echo "Email sent successfully with the report.";
		} else {
			echo $this->email->print_debugger();
		}
	}
	public function sendReRegistrationReportDirect()
	{
		$this->load->model('Student_Attendance_model');
		$this->load->library('m_pdf'); // Dompdf wrapper

		// Get report data
		$data['reportData'] = $this->Student_Attendance_model->getReRegistrationReport();

		// Load HTML from view
		$html = $this->load->view('Attendance/re_registration_pdf', $data, TRUE);

		$this->m_pdf->pdf = new mPDF('L','A4-L','','',5,10,5,17,5,10);
		$this->m_pdf->pdf->WriteHTML($html);
		//$pdf_data = $this->pdf->output();
		$pdfData=$this->m_pdf->pdf->Output('', "S");
		$file = 'ReRegistration_Report_' . date('Ymd_His') . '.pdf';
			//$file='Cumulative Daily Lecture Attendance Report-'.date('d-m-Y').'.pdf';	


			$path=$_SERVER["DOCUMENT_ROOT"].'/application/third_party/';
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
			$mail->Host = 'smtp.gmail.com';
			//Set the SMTP port number - likely to be 25, 465 or 587
			$mail->Port = 465;
			//Whether to use SMTP authentication
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->Username   = 'noreply6@sandipuniversity.edu.in';          // SMTP username
			$mail->Password   = 'mztv pmkl amlh jtac'; 
			//Set who the message is to be sent from
			$mail->setFrom('NoReply6@sandipuniversity.edu.in', 'SUN');
			//$mail->AddAddress('pramod.karole@sandipuniversity.edu.in');
			$mail->AddAddress('lengare.balasaheb@carrottech.in');
			$mail->isHTML(true);   
			$subject='School-wise Re-Registration Report-'.date('d-m-Y');
			$body="Dear Team,<br><br>Please find attached the Re-Registration PDF report.<br><br>Thanks,<br>Admin'";
			$mail->Subject = $subject;
			$mail->Body = $body;
			$mail->AltBody = 'This is a plain-text message body';
			$mail->addStringAttachment($pdfData, $file, 'base64', 'application/pdf');

			 if (!$mail->send()) { echo"Something Went Wrong!!!";exit;} else { //redirect('Student_attendance/lecture_attendance_report');
			 }
}


}
?>