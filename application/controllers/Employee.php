<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//ini_set('error_reporting', E_ALL);
class Employee extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Employee_model";
    var $model;
    var $view_dir='Employee/';
    
    public function __construct() 
    {
        date_default_timezone_set('Asia/Kolkata');
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
        $this->load->model('Admin_model');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		$this->load->model('Admin_model');
		$this->load->library('Awssdk');
    }
    
    public function index()
    {
        global $model;
        $this->load->view('header',$this->data);    
        //$this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
	public function view_profile()
    {
        $this->load->view('header',$this->data);
        $emp_id=$this->session->userdata("name");
/* echo $emp_id;
die();	 */	
         $this->data['temp']=$this->Employee_model->fetchEmployeeData($emp_id);
		/* print_r($this->data['temp']);
		 die();  */
        $this->load->view($this->view_dir.'profile',$this->data);
        $this->load->view('footer');
    }
	public function apply_leave(){
		$this->load->view('header',$this->data);
		 $this->data['state']= $this->Admin_model->getAllState();
		 $this->data['school_list']= $this->Admin_model->getAllschool();
		$this->data['emp_detail']=$this->Employee_model->fetchEmployeeData($this->session->userdata("name"));
		$this->data['leave']=$this->Employee_model->getAllLeaveType();
		$this->load->view($this->view_dir.'leave_form',$this->data);
        $this->load->view('footer');
      
	}

	public function add_leave(){
		$this->load->view('header',$this->data);
		if(!empty($_POST)){
			$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		//echo"<pre>";print_r($_POST);echo"</pre>";die();
			$res=$this->Employee_model->addEmpLeave($_POST);
		}
		if($res==1){
			//after applying for the leave.it should be forwarded to the Reporting officer.
			$reporting=$this->Employee_model->getROforLeave($this->session->userdata("name"));
			$emp_detail=$this->Employee_model->fetchEmployeeData($this->session->userdata("name"));
			//echo"<pre>";print_r($_POST);echo"</pre>";
//			//send mail to the Hr and Senior 
/*using curl*/
$ch = curl_init("http://www.carrottech.in/mailer/mailer-sandip-erp-leave.php");
$to =$reporting[0]['oemail'] ;
$frm_nm=$emp_detail[0]['fname'].' '.$emp_detail[0]['lname'];//'pallavi komatwad';
$frm_email=$emp_detail[0]['oemail'];//$_POST['email']$encoded = 'send=true&from_name='.urlencode($frm_nm).'&from_email='.urlencode($frm_email).'&to='.urlencode($to).'&subject=Leave Application Details';
 $name = $emp_detail[0]['fname']." ".$emp_detail[0]['lname'];
        $emailId = $emp_detail[0]['oemail'];
        $contactNo = $emp_detail[0]['mobileNumber'];
        $body = 'Respected sir/madam,<br>';
        $body .= 'Referring to the above mentioned subject,<br>';
        $body .= 'I am '.$emp_detail[0]['designation_name'].' '.$name .'  working under Department Of '.$emp_detail[0]['department_name'].' in '.$emp_detail[0]['college_name'].'<br>';
        $body .= 'applying for the leave from '.$_POST['leave_applied_from_date'].' To '.$_POST['leave_applied_to_date'].'<br>';
        $body .= 'because '.$_POST['reason'].'.';
        $body .= 'so,please approve my leave for the mentioned period.<br>';
        $body .= 'Thanking You.<br><br>';
        $body .= 'Yours Faithful,<br>';
        $body .= $name.',<br>';
        $body .= $contactNo.'<br>';

$encoded .= '&message='.urlencode($body).'&';
// chop off last ampersand
$encoded = substr($encoded, 0, strlen($encoded)-1);
curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_exec($ch);
curl_close($ch);
/*end curl*/

			$this->session->set_flashdata('message1','Your Leave Application Has been submitted...');
				redirect('Employee/apply_leave');	
						
		}else{
			$this->session->set_flashdata('message1','Please Try Again');
				redirect('Employee/apply_leave');
		}
		$this->load->view('footer');
	}
public function add_od(){
	
	$this->load->view('header',$this->data);
		if(!empty($_POST)){
			$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		//echo"<pre>";print_r($_POST);echo"</pre>"; die();
			$res=$this->Employee_model->addEmpOD($_POST);
		  // echo $res;
		  
		 }
		if($res==1){
			//after applying for the leave.it should be forwarded to the Reporting officer.
			$reporting=$this->Employee_model->getROforLeave($this->session->userdata("name"));
			$emp_detail=$this->Employee_model->fetchEmployeeData($this->session->userdata("name"));
			/* echo"<pre>";print_r($emp_detail);echo"</pre>";
			 exit(); */
			//send mail to the Hr and Senior 
/*using curl*/
$ch = curl_init("http://www.carrottech.in/mailer/mailer-sandip-erp-leave.php");
$to ='pmadde1@gmail.com';
//$to = 'deepak.nagane@carrottech.in,jugal.singh@carrottech.in,mohini.patil@carrottech.in';
$name = $emp_detail[0]['fname']." ".$emp_detail[0]['lname'];
$frm_nm=$name;//$_POST['ename']
$frm_email=$emp_detail[0]['oemail'];//$_POST['email']
$encoded = 'send=true&from_name='.urlencode($frm_nm).'&from_email='.urlencode($frm_email).'&to='.urlencode($to).'&subject=OD Application Details';
 
        $emailId = $emp_detail[0]['oemail'];
        $contactNo = $emp_detail[0]['mobileNumber'];
        $body = 'Respected sir/madam,<br>';
        $body .= 'Referring to the above mentioned subject,<br>';
        $body .= 'I am '.$emp_detail[0]['designation_name'].' '.$name .'  working under Department Of '.$emp_detail[0]['department_name'].' in '.$emp_detail[0]['college_name'].'<br>';
        $body .= 'applying for the OD from '.$_POST['applied_from_date'].' To '.$_POST['applied_to_date'].'<br>';
        $body .= 'because '.$_POST['reason_od'].'.';
        $body .= 'so,please approve my OD for the mentioned period.<br>';
        $body .= 'Thanking You.<br><br>';
        $body .= 'Yours Faithful,<br>';
        $body .= $name.',<br>';
        $body .= $contactNo.'<br>';

$encoded .= '&message='.urlencode($body).'&';
// chop off last ampersand
$encoded = substr($encoded, 0, strlen($encoded)-1);
curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_exec($ch);
curl_close($ch);
/*end curl*/
			$this->session->set_flashdata('message1','Your OD Application Has been submitted...');
				redirect('Employee/apply_leave');	
						
		}else{
			$this->session->set_flashdata('message1','Please Try Again');
				redirect('Employee/apply_leave');
		}
		$this->load->view('footer');
	
}	
	

	public function check_my_attendance(){
		$this->load->view('header',$this->data);
		$id=$this->session->userdata('name');
		$result=$this->Employee_model->fetchEmployeeData($id);
		if(!empty($_POST)){
			$today=$_POST['attend_date'];
			/* echo $today;
            die(); */			
		}else{
		$today=date("Y-m-d");	
		}
		
		$d = date_parse_from_format("Y-m-d",$today);
		$info['mno']=$d['month'];
		$info['yr']=$d['year'];
		$info['emp_school']=$result[0]['emp_school'];
		$info['department']=$result[0]['department'];
		
         $this->data['present']=$this->Employee_model->getMyTotalPresentByID($id,$info);// total present
			$this->data['abscent']=$this->Employee_model->getMyTotalAbscentByID($id,$info); // total abscent
			$this->data['outer']=$this->Employee_model->getMyTotalOuterDutyByID($id,$info); // total OD(outerDuty)
			$this->data['over']=$this->Employee_model->getMyTotalOverTimeByID($id,$info); // total OT(overtime)
			$this->data['late']=$this->Employee_model->getMyTotalLatemarkByID($id,$info); // total LT(Latemark)
			$this->data['leave']=$this->Employee_model->getMyTotalLeaveByID($id,$info); // total Leave(Leave)
		    $this->data['res']=$this->Employee_model->getMyAttendances($id,$info);
		if(empty($this->data['res'])){
			$this->session->set_flashdata('message1','Sorry No Attendance available...');
				$this->load->view($this->view_dir.'my_attendance',$this->data);	
		}else{
		$this->session->set_flashdata('message1','');
		$this->load->view($this->view_dir.'my_attendance',$this->data);	
		}
		$this->load->view('footer');
	}
 public function check_od_status(){
	    $this->load->view('header',$this->data);
		$id=$this->session->userdata('name');
		$this->data['od']=$this->Employee_model->getMyAllOD($id);
		 /* echo"<pre>";print_r($this->data['od']);echo"</pre>";
		die();  */
		$this->load->view($this->view_dir.'odlist_status',$this->data);
		$this->load->view('footer'); 
 }

 public function downloadgetpass(){
	 $str=$_REQUEST['str'];
	$this->load->view($this->view_dir.'exporttoexcel',$str);
 }
public function employee_reporting(){	
	if($this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==1){
			//echo 1;exit;
		}else{
			redirect('home');
		}
	$this->load->view('header',$this->data);  
	$menu = $this->uri->segment(1);
	 $menu1 = $this->uri->segment(2);
	 $this->data['my_privileges'] = $this->retrieve_privileges($menu."/".$menu1);  
       $this->data['emp_rep_details']= $this->Employee_model->get_emp_reporting('1');    
$this->data['emp_rep_details1']= $this->Employee_model->get_emp_reporting('2');    		               
        $this->load->view($this->view_dir.'employee_reporting_list',$this->data);
        $this->load->view('footer');
}
public function add_employee_reporting($i=''){	
	$this->load->view('header',$this->data); 
  if($i=='1'){
          $this->data['err'] = "<span style='color:red'>Reportee already assigned.</span>";
  }
$this->data['school_list']= $this->Admin_model->getAllschool();	       		
        $this->load->view($this->view_dir.'employee_reporting_add',$this->data);
        $this->load->view('footer');
}
	public function update_employee_reporting(){	
	$this->load->view('header',$this->data); 
	$erid=$this->uri->segment(3);	
	$this->data['emp_rep_details']= $this->Employee_model->get_emp_reporting_byid($erid); 

  $this->data['visiting_list']= $this->Admin_model->get_visiting_list();
	$this->data['school_list']= $this->Admin_model->getAllschool();		 
	// $this->data['bank_list']= $this->Admin_model->getAllBank();		 
	//  $this->data['shift_list']= $this->Admin_model->getAllShift();		 
	//  $this->data['dept_list']= $this->Admin_model->getAllDepartments();		 
	//  $this->data['desig_list']= $this->Admin_model->getAllDesignations();		
	$this->load->view($this->view_dir.'employee_reporting_update',$this->data);
	$this->load->view('footer');
}
public function update_employee_reporting_submit(){
	$up = $this->Employee_model->update_employee_reporting_submit($_POST);
	if($up!=0){
	redirect('Employee/employee_reporting');
	}else{
	    	$this->add_employee_reporting(1);
	}
}
public function get_emp_history($erid){
	
	$emp = explode("_",$erid);
	 $emp = $this->Employee_model->get_emp_reporting_bycode($emp[0],$emp[1]);
$j =1;
     
     foreach($emp as $val){
		 $rep_person1 =$this->Employee_model->get_emp_details($val['report_person1']);
 $rep_person2 =$this->Employee_model->get_emp_details($val['report_person2']);
 $rep_person3 =$this->Employee_model->get_emp_details($val['report_person3']);
 $rep_person4 =$this->Employee_model->get_emp_details($val['report_person4']); 
		 echo "<tr><td>".$j."</td>"; 
                              echo "<td>".$val['emp_code']."</td>";                             
                                 echo "<td>".$rep_person1[0]['fname']." ".$rep_person1[0]['lname']."</td>"; 
echo "<td>".$rep_person2[0]['fname']." ".$rep_person2[0]['lname']."</td>";
echo "<td>".$rep_person3[0]['fname']." ".$rep_person3[0]['lname']."</td>";
echo "<td>".$rep_person4[0]['fname']." ".$rep_person4[0]['lname']."</td>";
								 
                              	echo "<td>".date("d-m-y ",strtotime($val['inserted_datetime']))."</td>";						
                                echo "</tr>";
								$j=$j+1;
	 }     
}
public function getEmpListDepartmentSchool1(){
		$school=$_REQUEST['school'];
		$department=$_REQUEST['department'];
		$this->data['emp_list']=$this->Employee_model->getSchoolDepartmentWiseEmployeeList1($school,$department);
		$emp=$this->data['emp_list'];
		if(!empty($emp)){
	echo "<option  value='' >Select Reporting Person </option>";
	foreach($emp as $key=>$val ){
	echo "<option  value=".$emp[$key]['emp_id'].">".$emp[$key]['fname']." ".$emp[$key]['mname']." ".$emp[$key]['lname']."</option>";
	}
}else{
	echo "<option  value='' >Select Reporting Person</option>";
}

	}	
	public function employee_shifttime_update($id){
		$this->load->view('header',$this->data); 
  $this->data['shift_list']= $this->Admin_model->getAllShift();	
   $this->data['emp_shift']= $this->Employee_model->getempShift_id($id);	
        $this->load->view($this->view_dir.'employee_shifttime_update',$this->data);
        $this->load->view('footer');
	}
	public function update_employee_shifttime_submit(){
		$this->load->view('header',$this->data); 
  
   $this->data['emp_shift']= $this->Employee_model->update_emp_shifttime($_POST);	
        redirect('Employee/emp_shift_time_list');	
	}
	public function getshift(){
		$id=$_REQUEST['shiftid'];
		
		 if(isset($_REQUEST['shiftid']))
       {
          $shift =$this->Admin_model->getshifttime($_REQUEST['shiftid']);
		  // print_r($shift);
		  echo $shift[0]['shift_start_time']." - ".$shift[0]['shift_end_time'];
       }
	}
	public function employee_shifttime_list(){
		$this->load->view('header',$this->data); 
  $this->data['emplist']= $this->Employee_model->getAllempShift();	       		
        $this->load->view($this->view_dir.'employee_shifttime_list',$this->data);
        $this->load->view('footer');
	}
	public function check_my_reporting(){	
	$this->load->view('header',$this->data);    
       $this->data['emp_rep_details']= $this->Employee_model->get_my_reporting('1');    
$this->data['emp_rep_details1']= $this->Employee_model->get_my_reporting('2');    		               
        $this->load->view($this->view_dir.'check_reporting',$this->data);
        $this->load->view('footer');
}

public function employee_reset_password(){
	exit;	
	$this->load->view('header',$this->data); 
 
$this->data['school_list']= $this->Admin_model->getAllschool();	       		
        $this->load->view($this->view_dir.'employee_reset_password_form',$this->data);
        $this->load->view('footer');
}


public function resign_list(){	
	$this->load->view('header',$this->data); 
	$menu = $this->uri->segment(1);
	 $menu1 = $this->uri->segment(2);
	 $this->data['my_privileges'] = $this->retrieve_privileges($menu."/".$menu1);  
    $this->data['resign_data']= $this->Employee_model->get_resign_list();	       		
    $this->load->view($this->view_dir.'resign_list',$this->data);
    $this->load->view('footer');
}
public function add_resign(){	
	$this->load->view('header',$this->data); 
    $this->data['school_list']= $this->Admin_model->getAllschool();	       		
    $this->load->view($this->view_dir.'add_resign',$this->data);
    $this->load->view('footer');
}

public function get_resign_employee(){	
      $emp_code=$_POST['emp_code'];
      $id=$this->Employee_model->get_emp_details($emp_code);
   if(count($id)==1){
        $this->data['emp_data']=$this->Employee_model->fetchEmployeeData1($emp_code);
    echo json_encode($this->data['emp_data'][0]);
   }
   else{
       echo '0';
   }	 
}

public function save_employee_resign(){	
    $data['emp_id']=$_POST['emp_id'];
    $data['resign_date']=$_POST['resign_date'];
    $data['reason']=$_POST['resign_reason'];
    $data['entry_by ']=$this->session->userdata("uid");
    $data['entry_on ']=date("Y-m-d H:i:s");
    $a= $this->Employee_model->save_resign_employee($data);	 
}
public function employee_reset_password_submit(){

	  $id = $this->Employee_model->update_employee_password($_POST);
	

if($id =='1'){
	$user = $this->Employee_model->get_user_login($_POST['staffid']);
	try{
		/* $emp_detail=$this->Employee_model->fetchEmployeeData($_POST['staffid']);
$ch = curl_init("http://www.rvduniversity.com/mailer/mailer-matrimony.php");
$to =$emp_detail[0]['oemail'] ;
//$to = 'kajal.sonavane@carrottech.in';
//$to = 'abhishek.vitkar@carrottech.in';
$frm_nm='admin@sandipuniversity.com';//'pallavi komatwad';
$frm_email=$emp_detail[0]['oemail'];//$_POST['email']
$encoded = 'send=true&from_name='.urlencode($frm_nm).'&from_email='.urlencode($frm_email).'&to='.urlencode($to).'&subject=Password Reset of Sandip ERP';
 $name = $emp_detail[0]['ename']." ".$emp_detail[0]['lname'];
        $emailId = $emp_detail[0]['oemail'];
        $contactNo = $emp_detail[0]['mobileNumber'];
        $body = 'Dear sir/madam,<br><br>';
        $body .= 'Your Sandip University ERP Password has been reset successfully. The details are as below,<br>';
        
        $body .= 'Password :- '.$user[0]['password'].'<br>';
        
        $body .= 'Thanking You.<br><br>';     
        $body .= 'Sandip university,<br>';
        $body .= 'ERP Admin<br>';

$encoded .= '&message='.urlencode($body).'&';
// chop off last ampersand
$encoded = substr($encoded, 0, strlen($encoded)-1);
curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_exec($ch);
curl_close($ch); 
/*end curl*/
}
catch(Exception $e){
    throw new Exception("Invalid URL",0,$e);
}

	    $password = $user[0]['password'];
	    $mobile = $emp_detail[0]['mobileNumber'];

		 $user_mobile2 = "$mobile"; 

			$sms_message22 = urlencode("Dear sir/madam, 
Your SU ERP Password has been reset successfully. The details are as below,
Password = ".$password."
http://www.sandipuniversity.com/erp/
Thanks,
SU ERP.");
	//echo $sms_message22;exit;
	   $ch = curl_init();
	$query="?username=SANDIP03&password=SANDIP@2018&from=GLOBAL&to=$user_mobile2&text=$sms_message22&coding=0";
    curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL,'http://49.50.67.32/smsapi/httpapi.jsp' . $query); 
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 3);
$content = trim(curl_exec($ch));
curl_close($ch);
	/*
			$curl = curl_init('http://123.63.33.43/blank/sms/user/urlsms.php');
			curl_setopt($curl, CURLOPT_POST, 1);

			curl_setopt($curl, CURLOPT_POSTFIELDS, "username=sandipfoundationnsk&pass=sandip@123&senderid=SANDIP&dest_mobileno=$user_mobile2&msgtype=UNI&message=$sms_message22&response=Y");
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			 $res = curl_exec($curl);*/
			//exit;
			 	$this->session->set_flashdata('message1','Employee password has been sent by sms successfully .New Password is :  '.$password);
			redirect('Employee/employee_reset_password');	
}else{
	$this->session->set_flashdata('message1','Invalid Staff ID .');
			redirect('Employee/employee_reset_password');	

} 
	 
}

public function change_reporting(){
	$this->load->view('header',$this->data); 
  
$this->data['school_list']= $this->Admin_model->getAllschool();	       		
        $this->load->view($this->view_dir.'change_reporting',$this->data);
        $this->load->view('footer');
}
public function display_emp_details($emp){
	
	$this->load->model('leave_model');
	$emp=$this->leave_model->get_employee_code($emp);
	echo "<div class='emp-list' id='etable'><input type='text' id='myInput' onkeyup='myFunction()' placeholder='Search ..' title='Type in a name'><table id='myTable' class='table' style=''>";
        echo "<th></th><th>Emp Code</th><th>Emp Name</th>";
        foreach($emp as $val){
                $nme = '"'.$val['fname'].' '.$val['lname'].'"';
            $sch = '"'.$val['college_code'].'"';
            $dep = '"'.$val['department_name'].'"';
            $des = '"'.$val['designation_name'].'"';
            echo "<tr >";
            echo "<td><input type='checkbox' onclick='insert_emp_id(".$val['emp_id'].",".$nme.",".$sch.",".$dep.",".$des.")'></td>";
            echo "<td>".$val['emp_id']."</td>";
            echo "<td>".$val['fname']." ".$val['lname']."</td>";
            echo "</tr>";
        }
        echo "</table></div>";
}
public function get_report_emp($emp){
	
	$emp1 = $this->Employee_model->get_reporting_employee($emp);
	//echo $emp1;
	
	$this->load->model('leave_model');
	if($emp1>0){
	$emp = $this->leave_model->get_employee_code($emp);
	echo $emp[0]['fname']." ".$emp[0]['mname']." ".$emp[0]['lname']."-".$emp[0]['department_name']."-".$emp[0]['college_name']."-".$emp[0]['designation_name'];
	}else{
		echo '1';
	}
}
public function change_reporting_submit(){
	$upd = $this->Employee_model->change_employee_reporting($_POST);	
		redirect('Employee/employee_reporting');		
}
public function emp_shift_time_update(){
	$this->load->view('header',$this->data);
	$this->load->model('Staff_payment_model');
	 $this->data['school_list']= $this->Admin_model->getAllschool();
		 $this->data['emp']=$this->Staff_payment_model->get_employee();
		$this->data['shift_time']= $this->Employee_model->getShifttime();
		$this->load->view($this->view_dir.'emp_shift_time_update',$this->data);
	    $this->load->view('footer');
		
}
public function emp_shift_time_update_submit(){
	 $upd = $this->Employee_model->insert_emp_shift_time($_POST);	
	
	if($upd != 1){
		$this->session->set_flashdata('message1','Already exits for this date.');
		redirect('Employee/emp_shift_time_list');
	}else{
		redirect('Employee/emp_shift_time_list');	
	}
}
public function emp_shift_time_list(){
		$this->load->view('header',$this->data); 
		$menu = $this->uri->segment(1);
	 $menu1 = $this->uri->segment(2);
	 $this->data['my_privileges'] = $this->retrieve_privileges($menu."/".$menu1);  
  $this->data['emplisty']= $this->Employee_model->getAllempShift();
 $this->data['emplistn']= $this->Employee_model->getAllempShifttimePre();         		
        $this->load->view($this->view_dir.'emp_shift_time_list',$this->data);
        $this->load->view('footer');
	}
	
	public function emp_shift_time_del($id){
		$dels = $this->Employee_model->del_emp_shift_time($id);
         if(isset($dels)){
			$this->session->set_flashdata('message1','Deleted successfully');
		redirect('Employee/emp_shift_time_list'); 
		 }		
	}
	public function getshiftduration(){
		$e = $_POST['sftid'];
		$sft = $this->Employee_model->get_shift_duration($e);
		echo $sft[0]['duration']."-".date('H:i',strtotime($sft[0]['shift_start_time']))."-".date('H:i',strtotime($sft[0]['shift_end_time']));
	}
		public function get_emp_shift_history($empid){
		//echo $empid;
			 $emp = $this->Employee_model->get_emp_shift_details($empid);
$j =1;
     //print_r($emp);
     foreach($emp as $val){
$dur = $this->Employee_model->get_shift_duration($val['shift_id']);
		 echo "<tr><td>".$j."</td>"; 
                              echo "<td>".$val['in_time']."</td>";                             
                                 echo "<td>".$val['out_time']."</td>"; 
echo "<td>".date('d-m-Y',strtotime($val['active_from']))."</td>";
echo "<td>".$val['shift_id']."</td>";
echo "<td>".$dur[0]['duration']."</td>";
echo "<td>".$val['status']."</td>";
								 
                                   echo "</tr>";
								$j=$j+1;
	 }     
	}

function role_assign_list(){
	exit;
		$this->load->view('header',$this->data);
 $this->data['school_list']= $this->Admin_model->getAllschool();
$sid = $this->session->userdata("uid");
if($sid=='1'){
$this->data['role_list']= $this->Admin_model->get_emp_roles_adm(); 
}else{
$this->data['role_list']= $this->Admin_model->get_emp_roles(); 
}
		$this->load->view($this->view_dir.'emp_role_assign',$this->data);
        $this->load->view('footer');
	}
	function getEmpListbyDepartmentSchool_role(){
		$school=$_REQUEST['school'];
        $department=$_REQUEST['department'];
        $empl =$this->Employee_model->get_emp_sch_dep($school,$department);
		$i=1;
     foreach($empl as $val){
		 echo "<tr>";
		 echo "<td><input type='checkbox' id='".$val['emp_id']."' name='empsid[]' value='".$val['emp_id']."' /></td>";
		 echo "<td>".$i."</td>";
		 echo "<td>".$val['emp_id']."</td>";
		 echo "<td>".$val['fname']." ".$val['mname']." ".$val['lname']."</td>";
		 echo "<td>".$val['designation_name']."</td>";
		 echo "<td>".$val['roles_name']."</td>";
		 echo "</tr>";
		 $i++;
	 }
	}
	function assign_role_emp_submit(){
		 $asg = $this->Employee_model->update_role_emp($_POST);
		if($asg != '0'){
			redirect('Employee/role_assign_list'); 
		}
	}
	function get_emp_sch_dep_shift_time(){
		$school=$_REQUEST['school'];
        $department=$_REQUEST['department'];
        $empl =$this->Employee_model->get_emp_sch_dep($school,$department);
		$i=1;

     foreach($empl as $val){
		
		    if($val['gender']=='male'){$pr = 'Mr.';}else if($val['gender']=='female'){ $pr = 'Mrs.';}
				
            echo "<tr >";
            echo "<td><input type='checkbox' name='emp_chk[]' id='".$val['emp_id']."' onclick='active_row('".$val['emp_id']."')' value='".$val['emp_id']."''></td>";
            echo "<td>".$val['emp_id']."</td>";
            echo "<td>".$pr." ".$val['fname']." ".$val['lname']."</td>";
			echo "<td>".$val['college_code']."</td>";
			echo "<td>".$val['department_name']."</td>";
            echo "</tr>";
      
		 $i++;
	 }
	}

	function employee_document_add($empid){
		$this->load->view('header',$this->data);
		$this->data['emp_details'] = $this->Employee_model->get_emp_details_emprid($empid);
		//print_r($this->data['emp_details']);
		$this->data['doc_list'] = $this->Employee_model->get_document_list($empid);
		$this->load->view($this->view_dir.'employee_document_add',$this->data);
        $this->load->view('footer');
	}

	function employee_document_submit(){
//print_r($_FILES); print_r($_POST);

if(!empty($_POST['doc_id'])){
	foreach($_POST['doc_id'] as $docv){
		if(!empty($_FILES['dupload_'.$docv]['name'])) {
            $filenm= $_POST['er_id'].'-'.$_POST['staffid'].'-'.$docv.'-'.$_POST['ox_'.$docv].'-'.$_FILES['dupload_'.$docv]['name'];
            // $config['upload_path'] = 'uploads/employee_documents/';
            // $config['allowed_types'] = 'doc|docx|pdf';
            // $config['overwrite']= TRUE;
            // $config['max_size']= "2048000";
            // //$config['file_name'] = $_FILES['profile_img']['name'];
            // $config['file_name'] = $filenm;
            
            //Load upload library and initialize configuration
            // $this->load->library('upload',$config);
            // $this->upload->initialize($config);
            try{
                $bucket_name = 'erp-asset';
                $lastDot = strrpos($filenm, ".");
				$file_name_string = str_replace(".", "", substr($filenm, 0, $lastDot)) . substr($filenm, $lastDot);
				$ext = explode('.', $file_name_string);

				$file_name_string = clean($ext[0]). '.'.$ext[1];
                $file_path = 'uploads/employee_documents/'.$file_name_string;
                $result = $this->awssdk->uploadFile($bucket_name, $file_path, $_FILES['dupload_'.$docv]["tmp_name"]);
				$_POST['duploadf_'.$docv] = $file_name_string;

            }catch(Exception $e){
            	$_POST['duploadf_'.$docv]="";
            }
            // if($this->upload->do_upload('dupload_'.$docv)){
            //     $uploadData = $this->upload->data();
            //     $_POST['duploadf_'.$docv] = $filenm;
            // }else{
            //     $_POST['duploadf_'.$docv]="";
            // }
        }
        else{
            $_POST['duploadf_'.$docv]="";
        }
	}
}
//print_r($docupl);
//		exit;
		$st = $this->Employee_model->insert_document_emp($_POST);
		redirect('Employee/employee_document_list'); 
	}
	function employee_document_list(){ 
		if($this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==1){
			//echo 1;exit;
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);
$this->data['emplisty']= $this->Admin_model->getEmployees1('Y');

$this->load->view($this->view_dir.'employee_document_list',$this->data);
$this->load->view('footer');
	}

	function get_emp_document($emp){
		$edc = $this->Employee_model->get_emp_document_list($emp);
$i=1;
foreach($edc as $val){
	if($val['doc_status']=='Submitted'){
		$tc = 'green';
	}elseif($val['doc_status']=='Pending'){
		$tc = 'red';
	}else{
		$tc = 'black';
	}
	echo "<tr>";
echo "<td>".$i."</td>";
echo "<td>".$val['document_name']."</td>";
echo "<td>".$val['doc_ox']."</td>";
echo "<td style='color:".$tc.";'>".$val['doc_status']."</td>";
	echo "</tr>";
	$i++;
}

	}

	function get_document_list(){
		$this->load->view('header',$this->data);
$this->data['empdocp']= $this->Employee_model->getEmployeeDoc('Pending');
$this->data['empdocs']= $this->Employee_model->getEmployeeDoc('Submitted');
$this->load->view($this->view_dir.'employee_document_status',$this->data);
$this->load->view('footer');
	}
}
?>