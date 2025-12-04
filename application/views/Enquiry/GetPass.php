<?php
ini_set("display_errors", "On");
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
define("MODEL_NM","course_model");

class GetPass extends CI_Controller {
	
	var $currentModule="GetPass";
	var $model;
	public function __construct(){
		global $menudata;
		parent:: __construct();

        $this->load->helper("date");
		$this->load->helper("url");
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('file');
        $this->load->model('Getpass_model');
		$this->load->model('Walkin_reporting_model');
		$this->load->model('state_model');
		$this->load->model('city_model');
		$this->load->model('Students_model');
		$this->load->model('college_model');
		$this->currentModule=$this->uri->segment(1);
		$menu_name=$this->uri->segment(1);  
		$this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		$this->currentModule = $this->uri->segment(1);
        $this->data['currentModule'] = $this->currentModule;
		$this->load->library('Message_api');
		$this->view_dir="GetPass/";
		date_default_timezone_set('Asia/Kolkata');
	}
	
	public function index(){
		//echo 'test';
		$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		//exit;
		$uid=$session['uid'];
		$name=$session['name'];
		$gateno=substr($name, -1);
		//exit;
		$this->data['usermobile']=$_REQUEST['mobno'];
		$this->load->view('header',$this->data); 
		$this->data['reception_data']=$this->Getpass_model->get_walk_detials($uid,$gateno);
		$this->load->view('GetPass/GetPass',$this->data);
        $this->load->view('footer');
	}
	
	
	
	public function Listing(){
		$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		$gateno=substr($name, -1); 
		//exit;
		$this->load->view('header',$this->data); 
		 $this->data['reception_data']=$this->Getpass_model->get_walk_detials($uid,$gateno);
		//exit;
		$this->load->view('GetPass/GetPassListing',$this->data);
        $this->load->view('footer');
	}
	
	public function Refresh_gatelist(){
		$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		$gateno=substr($name, -1);
		 $this->data['reception_data']=$this->Getpass_model->get_walk_detials($uid,$gateno);
		//exit;
		$this->load->view('GetPass/Gatelist_Refresh',$this->data);
	}
	
	
	
	public function All_Gatelist(){
		$this->load->view('header',$this->data); 
		$this->data['reception_data']=$this->Getpass_model->get_walk_AllList();
		$this->load->view('GetPass/GetPassListing',$this->data);
        $this->load->view('footer');
	}
	
	
	
	public function GeatPassFrom(){
		
		
		if($_POST['Msubmit']){
		//$this->session->unset_userdata('OTP');
		 //$this->session->unset_userdata('last_login_timestamp');
			//echo '1';
			//exit;
	//$this->load->library('Message_api');
	 $mobno = $_REQUEST['mobile_no'];
	 
	 $campus=$this->Getpass_model->get_stud_campus($mobno);
	 
	mt_srand((double)microtime()*1000000); 
    $rand_number = mt_rand(10000,99999);  
    //$this->session->set_userdate('OTP',$rand_number);
    $this->session->set_userdata('OTP',$rand_number.'~'.$mobno);
    $this->session->set_userdata('last_login_timestamp',time());
    $this->session->set_userdata('campus_inst',$campus[0]['campus_inst']);
    // if ((time() - $_SESSION['last_login_timestamp']) > 5) {}
   // $test = NEW Message_api();
    $content="Sandip University Generate Auto OTP No-: ".$rand_number;
   // $test->send_sms($mobno,$content);
   ?>
   <script src="<?=base_url()?>assets/javascripts/jquery.min.js"></script>
   <script>
   
   
   var mobno="<?php echo $mobno; ?>";
   var content="<?php echo $content; ?>";
    jQuery.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>/GetPass/Ajax_sms',
            data: {mobno:mobno,content:content},
			cache: false,
            success: function(data) {
            console.log('done');
             }
        });
	//	setTimeout("window.location.href=''<?php // echo base_url(); ?>/GetPass';",4000);
   </script>
   <?php
	//$this->data['usermobile']=$_REQUEST['mobno'];
	//$this->data['Otpon']='Yes';
	//sleep(5);
	// redirect('GetPass');
	header('Refresh: 0;url='.base_url().'GetPass');
	// header('Refresh: 2;url=GetPass');

	/*$OTP = $this->session->userdata('OTP');
	$set=explode('~',$OTP );
    $setotp=$set[0];
     $mobe=$set[1];*/
	}
	
	
	
	       if($_POST['Otsubmit']){
			   
		   $mobno = $_REQUEST['usmobile'];//echo '<br>';
		//	echo '2';
		//	exit;
		   $Optv = $_REQUEST['Optv'];
		 //echo '<br>';
		 // $mobile_no = $_REQUEST['usmobile'];
		  
		  // echo $Optv;
		   $OTP=$this->session->userdata('OTP');
		   $set=explode('~',$OTP );
		   //print_r($set);
		   $setotp=$set[0]; //echo '<br>';
		   $mobe=$set[1]; //echo '<br>';
		  // exit;
		  if(($Optv==$setotp)&&($mobno==$mobe)){
		   echo 1;
		// $this->session->unset_userdata('OTP');
	    // $this->session->unset_userdata('last_login_timestamp');
		 $data['std_det'] = $this->Getpass_model->get_student_details($mobno);
		 $this->load->view('header',$this->data);
		 $this->load->view('GetPass/After_otp',$data);
		 $this->load->view('footer');
		  }else{
	     $this->session->set_flashdata('message_error', 'OTP Invalid');
		 $this->session->unset_userdata('OTP');
         redirect('GetPass');
		 
		 echo 2;
			  
		  }
		  
		 // exit;
	}
	////////////////////////////////////////////////////////////////////////	
		
		
		
	
	
	if($_POST['Resend']){
		
	$this->session->unset_userdata('OTP');
	
	$mobno = $_REQUEST['usmobile'];
	mt_srand((double)microtime()*1000000); 
    $rand_number = mt_rand(10000,99999);  
    //$this->session->set_userdate('OTP',$rand_number);
    $this->session->set_userdata('OTP',$rand_number.'~'.$mobno);
    //$this->session->set_userdata('last_login_timestamp',time());
    // if ((time() - $_SESSION['last_login_timestamp']) > 5) {}
   // $test = NEW Message_api();
    $content="Sandip University Generate Auto OTP No-: ".$rand_number;
   // $test->send_sms($mobno,$content);
   ?>
   <script src="<?=base_url()?>assets/javascripts/jquery.min.js"></script>
   <script>
   
   
   var mobno="<?php echo $mobno; ?>";
   var content="<?php echo $content; ?>";
    jQuery.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>/GetPass/Ajax_sms',
            data: {mobno:mobno,content:content},
			cache: false,
            success: function(data) {
            console.log('done');
             }
        });
	//	setTimeout("window.location.href=''<?php // echo base_url(); ?>/GetPass';",4000);
   </script>
   <?php
	//$this->data['usermobile']=$_REQUEST['mobno'];
	//$this->data['Otpon']='Yes';
	// redirect('GetPass');
		header('Refresh: 0;url='.base_url().'GetPass');
	/*$OTP = $this->session->userdata('OTP');
	$set=explode('~',$OTP );
    $setotp=$set[0];
     $mobe=$set[1];*/
		
	}
	
	
	    if($_POST['Back']){
			
		$this->session->unset_userdata('OTP');
     //   $this->session->unset_userdata('last_login_timestamp');
		 redirect('GetPass');
	     }
	
	
	//////////////////////////////////////////////////////////
	}
	
  function Ajax_sms(){
	   $test = NEW Message_api();
	  $mobno=$_REQUEST['mobno'];
	  $content=$_REQUEST['content'];
	  
	   $test->send_sms($mobno,$content);
  }
	
	public function Insert_data(){
		
		 ($this->session->all_userdata());
		$session=$this->session->userdata('logsession');
		 $OTP=$this->session->userdata('OTP');
		   $set=explode('~',$OTP );
		   $setotp=$set[0];
		   $mobe=$set[1];
		//echo '<pre>';print_r($OTP);
		//exit;
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		//exit;
		$name=$session['name'];
		$gateno=substr($name, -1); 
		
		
		$current_date=date('Y-m-d');
		$current=date('Y');//.'-'.
		$next=date('y')+1;
		 $current.'-'.$next;
		 $currenttime=date('Y-m-d H:i:s');
		$uniccode= date('Ymdhis');
		$stud=$_REQUEST['student_name'];
		//exit;
		$Campus=$_REQUEST['Campus'];
		
		$data['current_data']=date('Y-m-d');
		$data['uniqid']=date('Ymdhis');
		
		$smd['mobile1']= $mobe;//$_REQUEST['mobile_no'];
		$smd['student_name']=$_REQUEST['student_name'];
	    $smd['ic_code']='SU_MH_002';
		$smd['event_code']="EV/ADM-19";
		//$smd['Campous']=$_REQUEST['Campous'];
		//$smd['relation_with']=$_REQUEST['Relations'];
		//$smd['parentname']=$_REQUEST['parentname'];
		//$smd['pmobile_no']=$_REQUEST['parentmobile'];
		//////////////////////////////////////////////////////
		$already_mobile=$_REQUEST['already_mobile'];
		$wk['GateNo']=$gateno;
		$wk['entry_by']=$uid; // Enter Gate Pass ID
		$wk['entry_on']=$currenttime;
		$wk['status']='INT';
		
	///////////////////////////////////////////////////////////////////
		$wk['academic_year']=$current.'-'.$next;
	
	    //if($already_mobile){
		///$wk['walking_mobile']=$mobe;//$already_mobile;//$_REQUEST['mobile_no'];
		//}else{
		$wk['walking_mobile']=$mobe;//$_REQUEST['mobile_no'];	
		//}
		//$wk['ic_code']=$mobe;
		$wk['no_guest']=$_REQUEST['NumberGuests'];
		$wk['walkin_on']=$currenttime;
		$wk['executive_id']='0'; //executive_id//reception_id
		$wk['institute']=$_REQUEST['Campus'];
		$wk['gate_pass_applicable']='Y';
		$wk['relation_with']=$_REQUEST['Relations'];
		$wk['remark']=$_REQUEST['gate_remark'];
		$wk['reception_status']='Open';
		$wk['walking_date']=$current_date;
		
		//$wk['counselling_status']='Open';
		$check_countt=$this->Getpass_model->check_count();
		$check_count=$check_countt[0]['Total'];
		//print_r($check_count);
		$new=$check_count + 1;
		$newcount=str_pad($new, 4, "0", STR_PAD_LEFT);
		$gate_pass_no=$Campus.'/'.$uniccode.$newcount;
		$wk['gate_pass_no']=$Campus.'/'.$gateno.'/'.$uniccode.$newcount;
		
		//exit;
		//$image=$_REQUEST['Optv'];
		$img = $_POST['image'];
     $folderPath = "uploads/Pic/";
  if (!is_dir('uploads/Pic/')) {
    mkdir('uploads/Pic/', 0777, TRUE);
   // echo 'exit';
}
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.png';
  
    $file = $folderPath . $fileName;
    file_put_contents($file, $image_base64);
	$data['fileName']=$fileName;
	//print_r($fileName);
	$wk['profile_pic']=$fileName;
	$cntr_id = $this->Getpass_model->Insert_walking($smd,$wk,$mobe);
	if($cntr_id){
		//echo 'Done';
		$this->session->unset_userdata('OTP');
		//$this->session->unset_userdata('last_login_timestamp');
		redirect('GetPass/Listing');
	}
	
	
	}
	
	function image_cam(){
	$img = $_POST['image'];
    $folderPath = "upload/";
  
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.png';
  
    $file = $folderPath . $fileName;
    file_put_contents($file, $image_base64);
  
    print_r($fileName);
	}
	
	
	
	function getpasswaliking_id(){
    //$id= $this->uri->segment(3);
    $this->data['reception_data']=$this->Getpass_model->getdetailsof_walingid($_REQUEST['walkin_id']);
    echo $this->load->view('GetPass/New-gate-pass', $this->data);
    }
	
	    function Get_reception(){
		$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		//exit;
		//$recption_id='';institute
		//$Rection_data=$this->Getpass_model->Rection_data();
		//print_r($Rection_data);
		$this->load->view('header',$this->data); 
		$data['Rection_data']=$this->Getpass_model->Rection_data($uid,$name,$campusid);
		$this->load->view('GetPass/reception_walking_details',$data);
		$this->load->view('footer');
	}
	
	function Reception_refresh(){
		$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$data['Rection_data']=$this->Getpass_model->Rection_data($uid,$name,$campusid);
		$this->load->view('GetPass/Reception_Refresh',$data);
	}
	
	function get_reception_list(){
		$this->load->view('header',$this->data); 
		$data['Rection_data']=$this->Getpass_model->get_reception_list();
		$this->load->view('GetPass/Reception_list',$data);
		$this->load->view('footer');
	}
	
	
	function get_director_list(){
		$this->load->view('header',$this->data); 
		$data['Rection_data']=$this->Getpass_model->get_Director_list(); //CounsellorDesk
		$this->load->view('GetPass/Director_list',$data);
		$this->load->view('footer');
	}
	
	
	function get_Security_list(){
		$this->load->view('header',$this->data); 
		$data['Rection_data']=$this->Getpass_model->get_Security_list();
		$this->load->view('GetPass/Gate_security_list',$data);
		$this->load->view('footer');
	}
	
	function edit_Reception_waliking_details(){
		
    $id= $this->uri->segment(3);
    
	$data['requestion_details']=$this->Getpass_model->get_studetails($id);
	$data['state_details']=$this->Getpass_model->get_state_details();
	//$data['Counsellor_details']=$this->Getpass_model->get_Counsellor_details();
	//print_r($Rection_data);
	//$this->load->view('header',$this->data);
   echo $this->load->view('GetPass/ajax_edit_reception_walking', $data);
  // $this->load->view('footer');
 }
 
 function edit_Counsellor_waliking_details(){
     $id= $this->uri->segment(3);
    //exit;
	$requestion_details=$this->Getpass_model->get_CounsellorDetails($id);
	$this->data['requestion_details']=$this->Getpass_model->get_CounsellorDetails($id);
	//print_r($this->data['requestion_details']);
	//exit;
	$this->data['state_details']=$this->Getpass_model->get_state_details();
	$this->data['iclist'] = $this->Students_model->get_ic_bytype('ic');
	$this->data['newslist'] = $this->Getpass_model->get_newspaperlist();
	$this->data['streams'] = $this->Getpass_model->get_streams();
    $this->data['courses'] = $this->Getpass_model->get_courses();
    $this->data['standards'] = $this->college_model->get_standards();
	$this->data['Courses_SF'] = $this->Getpass_model->Get_Courses_SF();
	//$data['Counsellor_details']=$this->Getpass_model->get_Counsellor_details();
	//print_r($Rection_data);
	 $this->data['Doa_details']=$this->Getpass_model->Doa_Request($id);
	$swalk=$requestion_details[0]['walkin_id'];
	$this->load->view('header',$this->data);
    $this->load->view('GetPass/ajax_edit_Counsellor_walking', $this->data);
   $this->load->view('header',$this->data);
 }
 
 function Su_score(){
	  $reg = $_REQUEST['reg'];
      $cror = $this->Getpass_model->Su_score($reg);
	  echo $cror[0]['scored_marks'];
 }
 
   function Get_school_details(){       
        $std = $_REQUEST['std'];
        $cror = $this->Getpass_model->get_stream_std($std);
        echo "<option value=''>Select School</option>";
        foreach($cror as $val){
            echo "<option value='".$val['stream_id']."'>".$val['stream_name']."</option>";
        }
    }
 
 
 function GetStatewiseCity(){
	 $State=$_REQUEST['State'];
	 $city_details=$this->Getpass_model->get_city_details($State);
	// print_r($city_details);
	echo  $city='<select name="City" id="City" class="form-control">';
	 foreach($city_details as $city){
	echo '<option value="'.$city['city_id'].'">'.$city['city_name'].'</option>';
	 }
	 echo '</select>';
	 //echo $city;
 }
 
 
 
 
 function Get_Schooldetails(){
	  
	    $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];

	    $Campus=$_REQUEST['Campus'];
	    $schoolnew=$_REQUEST['schoolnew'];
	  
	  if($schoolnew){$school=$schoolnew;}else{$school='';}
	  $city_details=$this->Getpass_model->Get_Schooldetails($Campus,$schoolnew);
	// print_r($city_details);
	echo  $city='<select name="school_name" id="school_name" class="form-control" style=""><option value="">Select School</option>';
	 foreach($city_details as $city){
		 if($schoolnew==$city['school_id']){$sel='selected="selected"';}else{$sel='';}
	echo '<option value="'.$city['school_id'].'" '.$sel.'>'.$city['school_name'].'</option>'; //school_short_name
	 }
	 echo '</select>';
 }
 
 
 function Get_ReceptionSchooldetails(){
	  
	    $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];

	    $Campus=$_REQUEST['Campus'];
	   // $schoolnew=$_REQUEST['schoolnew'];
	  $sel='';
	 // if($schoolnew){$school=$schoolnew;}else{$school='';}
	  $city_details=$this->Getpass_model->Get_Schooldetails($Campus,$campusid);
	// print_r($city_details);
	echo  $city='<select name="school_name" id="school_name" class="form-control" style=""><option value="">Select School</option>';
	 foreach($city_details as $city){
		// if($school==$city['school_short_name']){$sel='selected="selected"';}else{$sel='';}
	echo '<option value="'.$city['school_id'].'" '.$sel.'>'.$city['school_name'].'</option>';
	 }
	 echo '</select>';
 }
 
 
 
 
 
 function Get_CoursesType(){
	 $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		
		$school_name=$_REQUEST['school_name'];
		$Campus=$_REQUEST['Campus'];
		$CoursesType=$_REQUEST['CoursesType'];
		$Qualification=$_REQUEST['Qualification'];
		$city_details=$this->Getpass_model->Get_CoursesType($school_name,$Campus,$Qualification);
	// print_r($city_details);
	echo  $city='<select name="CoursesType" id="CoursesType" class="form-control">';
	?>
    <option value="" data-icon="glyphicon glyphicon-eye-open" data-subtext="petrification" >Select</option>
    <?php
	 foreach($city_details as $city){
		 
	 if(isset($CoursesType)){ if($city['course_type']==$CoursesType){ $sal='selected="selected"'; }else{$sal='';}}	 
	echo '<option value="'.$city['course_type'].'"'.$sal.'>'.$city['course_type'].'</option>';
	 }
	 echo '</select>';
				
 }
 
  function Get_Courses(){
	 $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		
		$school_name=$_REQUEST['school_name'];
		$Campus=$_REQUEST['Campus'];
		$CoursesType=$_REQUEST['CoursesType'];
		
		$currentcourse=$_REQUEST['currentcourse'];
		
		
		$city_details=$this->Getpass_model->Get_Courses($CoursesType,$school_name,$Campus);
	// print_r($city_details);
	echo  $city='<select name="CoursesType" id="CoursesType" class="form-control">';
	?>
    <option value="" data-icon="glyphicon glyphicon-eye-open" data-subtext="petrification" >Select</option>
    <?php
	 foreach($city_details as $city){
		 
		  if(isset($currentcourse)){ if($city['course_id']==$currentcourse){ $sal='selected="selected"'; }else{$sal='';}}	
	echo '<option value="'.$city['course_id'].'"'.$sal.'>'.$city['course'].'</option>';
	 }
	 echo '</select>';
				
 }
 
// function Get_Courses_SF()
 
 
	
	function Get_Counsellerdetails(){
		$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
	    $school_name=$_REQUEST['school_name'];
	    $Campus=$_REQUEST['Campus'];
		
	 $city_details=$this->Getpass_model->Get_Counsellerdetails($school_name,$Campus);
	// print_r($city_details);
	echo  $city='<select name="Counsellor" id="Counsellor" class="form-control">';
	?>
    <option value="" data-icon="glyphicon glyphicon-eye-open" data-subtext="petrification" >Select Counseller</option>
    <?php
	 foreach($city_details as $city){
echo '<option value="'.$city['acd_id'].'">'.$city['staff_name'].'('.$city['Total'].') '.'('.$city['course'].') '.$city['Online_Status'].'</option>';
	 }
	 echo '</select>';
 }
 
function  Get_Counsellerdesk(){
	$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
	    $acd_id=$_REQUEST['acd_id'];
	 //  $Campus=$_REQUEST['Campus'];
	    $city_details=$this->Getpass_model->Get_Counsellerdesk($acd_id);
	// print_r($city_details);
	echo '<input type="text" class="form-control" id="CounsellorDesk" name="CounsellorDesk" value="'.$city_details[0]['desk_no'].'" readonly="readonly"><input type="hidden" class="form-control" id="staffid" name="staffid" value="'.$city_details[0]['staff_Id'].'" readonly="readonly">';
 }

	function Insert_reception(){
		$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		////////////////////////////
		//print_r($_REQUEST);exit;
		 $current=date('Y');//.'-'.
		 $next=date('y')+1;
		 $current.'-'.$next;
		 $currenttime=date('Y-m-d H:i:s');
		 $uniccode= date('Ymdhis');
		 $data['current_data']=date('Y-m-d');
		 
		//$smd['state_id']=$_REQUEST['State'];
		//$smd['city_id']=$_REQUEST['City'];
		//$smd['pincode']=$_REQUEST['Pincode'];
		//$smd['address']=$_REQUEST['Address'];
		$studentmeet_id=$_REQUEST['studentmeet_id'];
		
		//$reception['tokon_num']=$_REQUEST['tokon_num'];
		//$reception['Campus']=$_REQUEST['Campus'];
		
		//$reception['school_name']=$_REQUEST['school_name'];
		//$reception['Counsellor']=$_REQUEST['Counsellor'];
		//$reception['CounsellorDesk']=$_REQUEST['CounsellorDesk'];
		$walkin_id=$_REQUEST['walkin_id'];
		$reception['reception_id']=$uid; //executive_id//reception_id
		$reception['reception_remark']=$_REQUEST['reception_remark'];
		$reception['reception_status']='Closed';
		$reception['reception_time']=$currenttime;
		$smd['student_name']=$_REQUEST['student_name'];
		///////////////////////////////////////////////////////////////////////
		$reception['school_name']=$_REQUEST['school_name'];
		$reception['acdno']=$_REQUEST['Counsellor'];
		$reception['Counsellor']=$_REQUEST['staffid'];
		$reception['desk_no']=$_REQUEST['CounsellorDesk'];
		$reception['counselling_status']='Open';
		
	//	$wk=
		
		$check=$this->Getpass_model->Insert_reception($smd,$studentmeet_id,$walkin_id,$reception);
		if($check==1){
			redirect('GetPass/Get_reception');
		}else{
			echo 'Error Exit';
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function DeskSelect(){
		$EnterDesk=$_REQUEST['EnterDesk'];
		$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$CheckDesk=$this->Getpass_model->CheckDesk($uid,$name,$campusid,$EnterDesk);
		$check_count=$CheckDesk[0]['Total'];
		if($check_count==0){
		$check=$this->Getpass_model->DeskSelect($uid,$name,$campusid,$EnterDesk);
		if($check==1){
		// $data['msg'] = 'Succesfully Acquired';
		// $this->session->set_flashdata('message_name', 'Succesfully Acquired');
	
		 //redirect('GetPass/CounsellorDesk');
		echo 1;
		}else{
		echo 2;
		}
		}else{
		echo 3;
			
		}
	}
	
	public function Onlinestatus(){
		$status=$_REQUEST['status'];
		$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		
		$check=$this->Getpass_model->Onlinestatus($uid,$name,$campusid,$status);
		if($check==1){
		// $data['msg'] = 'Succesfully Acquired';
		//== $this->session->set_flashdata('message_name', 'Succesfully Acquired');
	
		 //redirect('GetPass/CounsellorDesk');
		echo 1;
		}else{
		echo 2;
		}
		
	}
	
	
	
	public function CounsellorDesk(){
		$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		
		$last_login=$this->session->userdata('last_login_timestamp');
		/*  if ((time() - $_SESSION['last_login_timestamp']) > 600) {  //3000
			  redirect('Login/logoff');
			  }*/
		//exit;
		$this->load->view('header',$this->data); 
		
		$CheckDesk=$this->Getpass_model->DeskAcquired($uid,$name,$campusid);
		$check_count=$CheckDesk[0]['Total'];
		$data['check_count']=$check_count;
	    $data['Desk_No']=$CheckDesk[0]['desk_no'];
		$data['Online_Status']=$CheckDesk[0]['Online_Status'];
		
		 $CheckDesk[0]['Online_Status'];
		
		$data['Rection_data']=$this->Getpass_model->CounsellorDesk($uid,$name,$campusid); //CounsellorDesk
	 //   $data['iclist'] = $this->Students_model->get_ic_bytype('ic');
		$this->load->view('GetPass/CounsellorDesk',$data);
		$this->load->view('footer');
	}
	
	public function Refresh_Counsellor(){
	$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];	
		$data['Rection_data']=$this->Getpass_model->CounsellorDesk($uid,$name,$campusid); //CounsellorDesk
	
		$this->load->view('GetPass/Counsellor_refresh',$data);
	}
	
	public function Insert_Counsellor(){
		//print_r($_POST);
		$currenttime=date('Y-m-d H:i:s');
		
		$studentmeet_id=$_REQUEST['studentmeet_id'];
		$walkin_id=$_REQUEST['walkin_id'];
		
		$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		
		//////////////////////////////////////////////
		$Counsellor['Counsellor_id']=$uid;
		$Switch=$_REQUEST['Switch'];
		if($Switch=="No"){
		$Counsellor['Counsellor_remark']=$_REQUEST['Counsellor_remark'];
		}else{
			
		$Counsellor['switch_institute']=$_REQUEST['Select_Campus'];
		$Counsellor['swschool']=$_REQUEST['Select_school'];
		$Counsellor['swCounsellor']=$_REQUEST['Select_Counsellor'];
		$Counsellor['swacd']=$_REQUEST['Select_acdno'];
		$Counsellor['swdeskno']=$_REQUEST['Select_Desk'];
		$Counsellor['switch_remark']=$_REQUEST['Counsellor_remark'];
			
		$Counsellor['switch_status']=$Switch;
		$Counsellor['institute']=$_REQUEST['Campus_Switch'];
		$Counsellor['school_name']=$_REQUEST['school_Switch'];
		$Counsellor['acdno']=$_REQUEST['CounsellorSwitch'];
		$Counsellor['Counsellor']=$_REQUEST['staffid'];
		$Counsellor['desk_no']=$_REQUEST['CounsellorDesk'];
		$Counsellor['counselling_remark']=$_REQUEST['Switch_remark'];
		
		}
		if($_REQUEST['Select_acdno']==$_REQUEST['staffid']){}else{
		$Counsellor['counselling_status']='Closed';
		}
		
		
		
		$Counsellor['Counsellor_remark']=$_REQUEST['Counsellor_Reference'];
		$Counsellor['Counsellor_time']=$currenttime;
		
		
		$Counsellor['Counsellor_Status']=$_REQUEST['Counsellor_Status'];//Counsellor_Status
		
		$Counsellor['CoursesType']=$_REQUEST['CoursesType'];
		$Counsellor['Courses']=$_REQUEST['Courses'];
		$Counsellor['visite_ic_code']=$_REQUEST['visit_ic'];
		$Counsellor['visite_date']=$_REQUEST['revisit_date'];
		$Counsellor['revisit_date']=$_REQUEST['revisit_date'];
		///////////////////////////////////////////////////////////////////////////////////
		$Counsellor['Counsellor_Reference']=$_REQUEST['Counsellor_Reference'];
		$Counsellor['Reference_value']=$_REQUEST['Reference_value'];
		$Counsellor['other_Reference']=$_REQUEST['other_Reference'];
		
		
		$smd['campus_inst']=$_REQUEST['Campus'];
		//$smd['school_name']=$_REQUEST['school_name'];
		$smd['programme_id']=$_REQUEST['Courses'];//$_REQUEST['school_name'];
		$smd['course_type']=$_REQUEST['CoursesType'];
		$smd['course_walkin']=$_REQUEST['Courses'];
		
		
		$Counsellor['LastQualification']=$_REQUEST['standard'];
		$Counsellor['Laststrem']=$_REQUEST['stream'];
		$Counsellor['LastQualificationmark']=$_REQUEST['LastQualificationmark'];
		$Counsellor['cast_category']=$_REQUEST['Cast'];
		$Counsellor['CourseYear']=$_REQUEST['CourseYear'];
		$Counsellor['CET']=$_REQUEST['CET'];
		$Counsellor['JEE']=$_REQUEST['JEE'];
		$Counsellor['Suyear']=$_REQUEST['Suyear'];
		$Counsellor['SuScore']=$_REQUEST['SuScore'];
		
		
		if($_REQUEST['Counsellor_Status']=="CAP"){
			
		$Counsellor['cap_status']='Y';
		
		$CAP['stumobile']=$_REQUEST['stumobile'];
		$CAP['student_name']=$_REQUEST['student_name'];
		
		$CAP['studentmeet_id']=$_REQUEST['studentmeet_id'];
		$CAP['walkin_id']=$_REQUEST['walkin_id'];
			
			
		$CAP['LastQualification']=$_REQUEST['standard'];
		$CAP['stream']=$_REQUEST['stream'];
		$CAP['LastQualificationmark']=$_REQUEST['LastQualificationmark'];
		$CAP['Cast']=$_REQUEST['Cast'];
		
		$CAP['CET']=$_REQUEST['CET'];
		$CAP['JEE']=$_REQUEST['JEE'];
		$CAP['Suyear']=$_REQUEST['Suyear'];
		$CAP['SuScore']=$_REQUEST['SuScore'];
		$CAP['CourseYear']=$_REQUEST['CourseYear'];
			
		$CAP['capdistricts']=$_REQUEST['capdistricts'];
		$CAP['captaluka']=$_REQUEST['captaluka'];
		
		$CAP['Interested_one']=$_REQUEST['Interested_one'];
		$CAP['Interested_two']=$_REQUEST['Interested_two'];
		$CAP['Interested_three']=$_REQUEST['Interested_three'];
		$CAP['cap_status']='Y';
		}/*else{ //cap_round
		
		}*/
		
		/////////////////////////////////////////////////////////////////////////////
		$smd['contact_source']=$_REQUEST['Counsellor_Reference'];
		if(isset($_REQUEST['other_Reference'])){
		$smd['othr_ref']=$_REQUEST['other_Reference'];
		}
		//$call_log['Counsellor_Status']=$_REQUEST['Counsellor_Status'];
		//$call_log['Counsellor_Status']=$_REQUEST['Counsellor_Status'];
		//$Counsellor_Status=$_REQUEST['stumobile'];
		//if($Counsellor_Status=="")
		//$call_center=$_REQUEST['cstatus'];
		//$check=$this->Getpass_model->Insert_Call_log($studentmeet_id,$walkin_id,$Counsellor,$call_center,$Counsellor_Status);
		
		

		
		$check=$this->Getpass_model->Insert_Counsellor($uid,$name,$studentmeet_id,$walkin_id,$Counsellor,$Counsellor_Status,$smd,$_REQUEST,$CAP);
		
		//exit;
		if($check==1){
		if($_REQUEST['Counsellor_Status']=="REGISTRATION"){
		redirect('Prospectus_fee_details/student_prospectus_add?mobile='.$_REQUEST['stumobile'].'&csid='.$uid);
		}else{
		redirect('GetPass/CounsellorDesk');
		}
			
		}else{
			echo 'Error Exit';
		}
		
	}
	
	
	    function Switch_Request(){
			
		$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		
		$studentmeet_id=$_REQUEST['studentmeet_id'];
		$walkin_id=$_REQUEST['walkin_id'];
		
		$Counsellor['switch_institute']=$_REQUEST['Select_Campus'];
		$Counsellor['swschool']=$_REQUEST['Select_school'];
		$Counsellor['swCounsellor']=$_REQUEST['Select_Counsellor'];
		$Counsellor['swacd']=$_REQUEST['Select_acdno'];
		$Counsellor['swdeskno']=$_REQUEST['Select_Desk'];
		$Counsellor['switch_remark']=$_REQUEST['Counsellor_remark'];
			
		$Counsellor['switch_status']='Yes';
		$Counsellor['institute']=$_REQUEST['Campus_Switch'];
		$Counsellor['school_name']=$_REQUEST['school_Switch'];
		$Counsellor['acdno']=$_REQUEST['CounsellorSwitch'];
		$Counsellor['Counsellor']=$_REQUEST['staffid'];
		$Counsellor['desk_no']=$_REQUEST['CounsellorDesk'];
		$Counsellor['counselling_remark']=$_REQUEST['Switch_remark'];
		echo $check=$this->Getpass_model->Switch_Request($uid,$name,$studentmeet_id,$walkin_id,$Counsellor);
		//if($check==1){
		//redirect('GetPass/CounsellorDesk');
		//}
		//$uid,$name
		
	    }
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	public function ExitGate(){
		$this->load->view('header',$this->data); 
		$data['Rection_data']=$this->Getpass_model->ExitGate(); //CounsellorDesk
		$this->load->view('GetPass/exit_get',$data);
		$this->load->view('footer');
	}
	
	function Exit_Refresh(){
	$data['Rection_data']=$this->Getpass_model->ExitGate(); //CounsellorDesk
		$this->load->view('GetPass/Exitgate_Refresh',$data);	
	}
	
	function edit_ExitGate(){
    $id= $this->uri->segment(3);
    
	$data['requestion_details']=$this->Getpass_model->edit_ExitGate($id);
	//$data['state_details']=$this->Getpass_model->get_state_details();
	//$data['Counsellor_details']=$this->Getpass_model->get_Counsellor_details();
	//print_r($Rection_data);
   echo $this->load->view('GetPass/ajax_edit_ExitGate', $data);
 }
 
        function Getexit_insert(){
	    $session=$this->session->userdata('logsession');
		echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		//exit;
		$gateno=substr($name, -1); 
		
     $currenttime=date('Y-m-d H:i:s');
	 $studentmeet_id=$_REQUEST['studentmeet_id'];
	 $walkin_id=$_REQUEST['walkin_id'];
	 
	 $Gateexit['gate_status']=$_REQUEST['exitStatus'];
	 $Gateexit['exitgate_no']=$gateno;
	 $Gateexit['exitgate_by']=$uid;
	 $Gateexit['gate_pass_exit_entry_on']=$currenttime;
	// print_r($_REQUEST);
	// $studentmeet_id.'__'.$walkin_id.'__'.$Getexit;
	// exit;
	//  $Getexit['get_status']=$_REQUEST['Get_remark'];
	 $check=$this->Getpass_model->Getexit_insert($studentmeet_id,$walkin_id,$Gateexit);
		if($check==1){
		redirect('GetPass/ExitGate');
		}else{
	    echo 'Error Exit';
		}
      }
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
	
	
	  public function Admission_Director_Register(){
			
		$this->load->view('header',$this->data); 
		$data['Get_Directorlist']=$this->Getpass_model->Get_Directorlist();
		//$data['Get_stafflist']=$this->Getpass_model->Get_stafflist();
		//$data['Get_Course']=$this->Getpass_model->Get_Courselist();
		//$this->load->view('GetPass/Director_Admission',$data);
		$this->load->view('GetPass/Admission_Director_Register',$data);
		$this->load->view('footer');
		
	    }
		
		
		
		public function Director_Register(){
			
			$StaffId=$_REQUEST['StaffId'];
			//$Campus=$_REQUEST['Campus'];
			$Name=$_REQUEST['Name'];
			$Mobile=$_REQUEST['Mobile'];
			$WhatsApp=$_REQUEST['WhatsApp'];
			
			
			$pass=rand(1000,9999);//generate random password for user account
			
		    $user_R['username']=$StaffId;
	        $user_R['password']=$pass;//md5($pass);// make md5 of password
		
		    $user_R['ic_code']='All';
		    $user_R['campus']='All';
			
		    $user_R['roles_id']=24;
	
		    $user_R['status']='Y';
		    $user_R['inserted_by']=$this->session->userdata("uid");
	        $user_R['updated_by']=$this->session->userdata("uid");
			
			
		
		$coun_R['staff_Id']=$StaffId;
		$coun_R['staff_name']=$Name;
		$coun_R['Campus']='All';
		$coun_R['mobile_no']=$Mobile;
		$coun_R['whatsapp']=$WhatsApp;
		$coun_R['role']=24;
		$coun_R['Status']='Y';
		$coun_R['Create_date']='';
		$coun_R['staff_type']='Current';
		
		//$this->load->library('Message_api');
		$role_name="Director Of Admission";
		$test = NEW Message_api();
		//$mob = mysql_real_escape_string($_POST['mobile_official']);
		$content="Dear ".$_REQUEST['Name']." 
Your ".$role_name." Account is created successfully ,Please login with below details
Link: ".base_url()."
UserName: ".$StaffId."
Password: ".$pass."

Thanks,
Sandip University";
	$test->send_sms($Mobile,$content);
			
			$useradd=$this->Getpass_model->AddDirector($user_R,$StaffId,$coun_R);
			
			
		redirect('GetPass/Admission_Director_Register');
			
			
		}
		public function Director_edit(){
		$acd_id=$_REQUEST['acd_id'];
		$this->load->view('header',$this->data); 
		$data['Get_Directorlist']=$this->Getpass_model->Get_Directorlist_byid($acd_id);
		$this->load->view('GetPass/Director_edit',$data);
		$this->load->view('footer');
		}

		public function Director_Update(){
			
			$acd_id=$_REQUEST['acd_id'];
			$um_id=$_REQUEST['um_id'];
			$StaffId=$_REQUEST['StaffId'];
			$Name=$_REQUEST['Name'];
			$Mobile=$_REQUEST['Mobile'];
			$WhatsApp=$_REQUEST['WhatsApp'];
			
			
			
			
			$user_R['username']=$StaffId;
			
			$coun_R['staff_Id']=$StaffId;
		    $coun_R['staff_name']=$Name;
			$coun_R['mobile_no']=$Mobile;
		    $coun_R['whatsapp']=$WhatsApp;
			
			$useradd=$this->Getpass_model->Director_Update($user_R,$um_id,$coun_R,$acd_id);
			
			
		redirect('GetPass/Admission_Director_Register');
		}
		
		
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		
		
		 public function Director_Admission_Create(){
			
		$this->load->view('header',$this->data); 
		$data['Get_Counsellerlist']=$this->Getpass_model->Get_Counsellerlist();
		//$data['Get_stafflist']=$this->Getpass_model->Get_stafflist();
		//$data['Get_Course']=$this->Getpass_model->Get_Courselist();
		//$this->load->view('GetPass/Director_Admission',$data);
		$this->load->view('GetPass/Director_Admission_Create',$data);
		$this->load->view('footer');
		
	    }
		
		  public function Director_Admission(){
			
		$this->load->view('header',$this->data); 
		$data['Get_Counsellerlist']=$this->Getpass_model->Get_Counsellerlist();
		$data['Get_stafflist']=$this->Getpass_model->Get_stafflist();
		$data['Get_Course']=$this->Getpass_model->Get_Courselist();
		$this->load->view('GetPass/Director_Admission',$data);
		//$this->load->view('GetPass/Director_Admission',$data);
		$this->load->view('footer');
		
	    }
		
		
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		
		public function AddCounselor(){
			
	   $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		 $uid=$session['uid']; echo '<br>';
		 $name=$session['name'];  echo '<br>';
			//;//print_r();
			
		$this->load->view('header',$this->data); 
		$data['Get_Counsellerlist']=$this->Getpass_model->Get_Counsellerlist();
		$data['Get_stafflist']=$this->Getpass_model->Get_stafflist();
		$data['Get_Course']=$this->Getpass_model->Get_Courselist();
		//$this->load->view('GetPass/Director_Admission',$data);
		$this->load->view('GetPass/Add_Counsellor',$data);
		$this->load->view('footer');
		}
		
		function get_counsellor_list(){
		$this->load->view('header',$this->data); 
		$data['Rection_data']=$this->Getpass_model->get_counsellor_list(); //CounsellorDesk
		$this->load->view('GetPass/Counsellor_list',$data);
		$this->load->view('footer');
	}
	
	
		public function Counsellor_Register(){
			
		 $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		 $uid=$session['uid']; echo '<br>';
		 $name=$session['name'];  echo '<br>';	
			
		$Courses=array();
		
		$Staff=$_REQUEST['Staff'];
	    $StaffId=$_REQUEST['StaffId'];
		$Role=$_REQUEST['Role'];
		
		$school_name='';
		$CoursesType='';
		
		$Name=$_REQUEST['Name'];
		$Mobile=$_REQUEST['Mobile'];
		$WhatsApp=$_REQUEST['WhatsApp'];
		
		$Campus=$_REQUEST['Campus'];
		$school_name=$_REQUEST['school_name'];
		$CoursesType=$_REQUEST['CoursesType'];
		$Courses=$_REQUEST['Courses'];
		$Gate=$_REQUEST['Gate'];
		if(isset($Gate)){
		if($Gate==1){
		$Campus="SF";
		}elseif($Gate==2){
		$Campus="SUN";
		}
		}
		//print_r($Courses[0]);
		//exit;
		
	//	$check_already=$this->Getpass_model->check_already($StaffId,$Mobile,$school_name,$CoursesType,$Courses,$Role);
	//	print_r($check_already);
	//	exit;
		$role_name='';
		if($Role==23){
			$role_name="Admission Counsellor";
			$user_R['employee_code']='Admission Counsellor';
			
		}else if($Role==22){
			$role_name="Receptionist";
			$user_R['employee_code']='Receptionist';
		}elseif($Role==21){
			$role_name="Gate Security";
			$user_R['employee_code']='Gate Security';
			$coun_R['gateno']=$Gate;
		}elseif($Role==25){
			$role_name="Admission Center";
			$user_R['employee_code']='Admission Center';
			//$coun_R['gateno']=$Gate;
		}elseif($Role==26){
			$role_name="Student Section";
			$user_R['employee_code']='Student Section';
			//$coun_R['gateno']=$Gate;
		}
		
		///////////////////////////////////////////////////////////////////////
		$pass=rand(1000,9999);//generate random password for user account
		$user_R['username']=$StaffId;
	    $user_R['password']=$pass;//md5($pass);// make md5 of password
		
		$user_R['ic_code']='SU_MH_002';
		//$user_R['employee_code']=$Campus;
		$user_R['roles_id']=$Role;
	
		$user_R['status']='Y';
		$user_R['inserted_by']=$this->session->userdata("uid");
	    $user_R['updated_by']=$this->session->userdata("uid");
		
		$user_r['stafftype']=$Staff;
	  //echo $data['created_by'];
	    $user_R['inserted_datetime']=date('Y-m-d H:i:s');
	    $user_R['updated_datetime']=date('Y-m-d H:i:s');
		//$user_R['con_id']=$StaffId;
		$user_R['campus']=$Campus;
		
		
		
		if($Role==23){
		
		$i=0;
		foreach($Courses as $list){
			//echo $list;
		$coun_R[$i]['staff_Id']=$StaffId;
		$coun_R[$i]['staff_name']=$Name;
		
		$coun_R[$i]['Campus']=$Campus;
		$coun_R[$i]['school']=$school_name;
		$coun_R[$i]['Courses']=$CoursesType;
		
		$coun_R[$i]['department']=$list;
		
		$coun_R[$i]['mobile_no']=$Mobile;
		$coun_R[$i]['whatsapp']=$WhatsApp;
		$coun_R[$i]['role']=$Role;
		$coun_R[$i]['email_id']='';
		$coun_R[$i]['Status']='Y';
		$coun_R[$i]['Create_date']=$Campus;
		$coun_R[$i]['staff_type']=$Staff;
		$i++;
	     }
	//print_r($coun_R[0]);
	//exit;
		}else{
		$coun_R['staff_Id']=$StaffId;
		$coun_R['staff_name']=$Name;
		$coun_R['Campus']=$Campus;
		$coun_R['mobile_no']=$Mobile;
		$coun_R['whatsapp']=$WhatsApp;
		$coun_R['role']=$Role;
		$coun_R['email_id']=$Campus;
		$coun_R['Status']='Y';
		$coun_R['Create_date']=$Campus;
		$coun_R['staff_type']=$Staff;	
		}
		
		$coun_R['staff_Id'];
	//	exit;
		
		
		
		//$this->load->library('Message_api');
					$test = NEW Message_api();
				//$mob = mysql_real_escape_string($_POST['mobile_official']);
				$content="Dear ".$_REQUEST['Name']." 
Your ".$role_name." Account is created successfully ,Please login with below details
Link: ".base_url()."
UserName: ".$StaffId."
Password: ".$pass."

Thanks,
Sandip University";
				$test->send_sms($Mobile,$content);
				
				////////////////SEND SMS END///////////////////
			   
			   // sending mail to the Newly added user
			  $this->session->set_flashdata('message1','Information Center User Added Successfully ..');
		
		
		
		
		$useradd=$this->Getpass_model->AddICUser($user_R,$StaffId,$coun_R,$Courses,$uid,$name);
		if($useradd==3){
		$this->session->set_flashdata('message1', 'Staff Id Already Create On This Role.Use Another Staff Id');
		 redirect('GetPass/AddCounselor');
		}elseif($useradd==0){
		$this->session->set_flashdata('message1', 'Database Error');
	    redirect('GetPass/AddCounselor');
		}else{
		redirect('GetPass/Director_Admission_Create');
		}
		}
		
		
		
		
		public function AddCounselor_edit(){
		$this->load->view('header',$this->data); 
		$userexit=$_REQUEST['name'];
		if(isset($userexit)){
		$data['userexit']=$_request['name'];
		$data['userdata']=$this->Getpass_model->Get_Counsellerlistby($userexit);
		}else{
		$data['userexit']='';
		$data['userdata']='';
		}
		//print_r($data);
		//exit;
		$data['Get_Counsellerlist']=$this->Getpass_model->Get_Counsellerlist();
		$data['Get_stafflist']=$this->Getpass_model->Get_stafflist();
		$data['Get_Course']=$this->Getpass_model->Get_Courselist();
		//$this->load->view('GetPass/Director_Admission',$data);
		$this->load->view('GetPass/Add_Counsellor_edit',$data);
		$this->load->view('footer');
		}
		
		
		
		
		
		
		
		function Counsellor_edit_Update(){
		$Courses=array();
		$school_name='';
		$CoursesType='';
		
		$acd_id=$_REQUEST['acd_id'];
		$um_id=$_REQUEST['um_id'];
		
		
		$StaffId=$_REQUEST['StaffId'];
		$Role=$_REQUEST['Role'];
		
		$Name=$_REQUEST['Name'];
		$Mobile=$_REQUEST['Mobile'];
		$WhatsApp=$_REQUEST['WhatsApp'];
		
		$Campus=$_REQUEST['Campus'];
		$school_name=$_REQUEST['school_name'];
		$CoursesType=$_REQUEST['CoursesType'];
		$Courses=$_REQUEST['Courses'];
		$Gate=$_REQUEST['Gate'];
		///////////////////////////////////////////////////////////////////////
		$user_R['username']=$StaffId;
		$user_R['roles_id']=$Role;
		$user_r['stafftype']=$Staff;
		if($Role==23){
		$i=0;
		foreach($Courses as $list){
		$coun_R[$i]['staff_Id']=$StaffId;
		$coun_R[$i]['staff_name']=$Name;
		
		$coun_R[$i]['Campus']=$Campus;
		$coun_R[$i]['school']=$school_name;
		$coun_R[$i]['Courses']=$CoursesType;
		
		$coun_R[$i]['department']=$list;
		
		$coun_R[$i]['mobile_no']=$Mobile;
		$coun_R[$i]['whatsapp']=$WhatsApp;
		$coun_R[$i]['role']=$Role;
		$coun_R[$i]['email_id']=$Campus;
		$coun_R[$i]['Status']='Y';
		
		$coun_R[$i]['staff_type']=$Staff;
		//$coun_R[$i]['role']=$Role;
		//$coun_R['email_id']=$Campus;
		//$coun_R['Status']='Y';
		//$coun_R['Create_date']=$Campus;
		$i++;
		}
		}else{
		$coun_R['staff_Id']=$StaffId;
		$coun_R['staff_name']=$Name;
		
		$coun_R['Campus']=$Campus;
		$coun_R['school']=$school_name;
		$coun_R['Courses']=$CoursesType;
		
		$coun_R['department']=$list;
		
		$coun_R['mobile_no']=$Mobile;
		$coun_R['whatsapp']=$WhatsApp;
		$coun_R['role']=$Role;
		$coun_R['email_id']=$Campus;
		$coun_R['Status']='Y';
		
		$coun_R['staff_type']=$Staff;
		
		}
		if($Role==21){
			$coun_R['gateno']=$Gate;
		}
		
		//print_r($coun_R);echo '<br>';
		//echo $acd_id;
		//exit;
		
		$useradd=$this->Getpass_model->Counsellor_edit_Update($user_R,$um_id,$coun_R,$acd_id,$Courses);
		redirect('GetPass/Director_Admission_Create');
			
		}
		
		
		
		
		
		function actionchangeDelete(){
			$acd_id=$_REQUEST['acd_id'];
			$um_id=$_REQUEST['um_id'];
		echo $Get_Counselorbyid=$this->Getpass_model->actionchangeDelete($acd_id,$um_id);	
		}
	
	    public function AddCounselor_new(){
		$Campus = $_REQUEST['Campus'];
		$school_name =  $_REQUEST['school_name'];
	    $CoursesType =  $_REQUEST['CoursesType'];
		$Courses =  $_REQUEST['Courses'];
		$Counselor=$_REQUEST['Counselor'];
		$Get_Counselorbyid=$this->Getpass_model->Get_Counselorbyid($Counselor);
		//print_r($Get_Counselorbyid);
		//exit;
		
		$mobile=$Get_Counselorbyid[0]['mobile_no'];
		$email=$Get_Counselorbyid[0]['email_id'];
		$staff_name=$Get_Counselorbyid[0]['staff_name'];
		//exit;
	    $addCounselor['staff_Id']=$Counselor;
		$addCounselor['staff_name']=$staff_name;
		$addCounselor['school']=$school_name;
		//$addCounselor['department']=$Courses;
		$addCounselor['mobile_no']=$mobile;
		$addCounselor['email_id']=$email;
		$addCounselor['Campus']=$Campus;
		
	//	print_r($addCounselor);
		
		$check=$this->Getpass_model->AddCounselor_data($Counselor,$staff_name,$school_name,$mobile,$email,$Campus,$Courses);
		//print_r($check);
		//exit;
		if($check==1){
			redirect('GetPass/Director_Admission');
		}else{
			echo 'Error Exit';
		}
		/*$Campus = $_REQUEST['Campus'];
		$school_name =  $_REQUEST['school_name'];
		$Counselor =  $_REQUEST['Counselor'];
		$Course =  $_REQUEST['Course'];
		
		exit;
		$Get_Counselorbyid=$this->Getpass_model->Get_Counselorbyid($Counselor);
		
		$mobile=$Get_Counselorbyid[0][];
		$email=$Get_Counselorbyid[0][];
		$staff_name=$Get_Counselorbyid[0]['staff_name'];
		
		$addCounselor['staff_Id']=$Counselor;
		$addCounselor['staff_name']=$staff_name;
		$addCounselor['school_name']=$school_name;
		$addCounselor['department']=$Course;
		$addCounselor['mobile_no']=$mobile;
		$addCounselor['email_id']=$email;
		$addCounselor['Campus']=$Campus;
		
		/*$check=$this->Getpass_model->AddCounselor_data($addCounselor);
		
		if($check==1){
			redirect('GetPass/CounsellorDesk');
		}else{
			echo 'Error Exit';
		}*/
		
	    }
		
		function Get_CampusType(){
			
			$Campus = $_REQUEST['Campus'];
			$Qualification = $_REQUEST['Qualification'];
			$school_name = $_REQUEST['school_name'];
			$city_details=$this->Getpass_model->Get_CampusType($Campus,$Qualification);
	// print_r($city_details);
	echo  $city='<select name="CoursesType" id="CoursesType" class="form-control">';
	?>
    <option value="" >Select Course</option>
    <?php
	 foreach($city_details as $city){
		 if(isset($school_name)){ if($city['school_id']==$school_name){ $sal='selected="selected"'; }else{$sal='';}}
	echo '<option value="'.$city['school_id'].'" '.$sal.'>'.$city['school_name'].'</option>';
	 }
	 echo '</select>';
			
			}
	
	
	function AdmisionCounselor_Change(){
		$values = $_REQUEST['values'];
		$id =  $_REQUEST['id'];
		$um_id=$_REQUEST['um_id'];
		$addCounselor['Status']=$values;
		$user['status']=$values;
		$city_details=$this->Getpass_model->AdmisionCounselor_Change($addCounselor,$id,$user,$um_id);
		if($city_details==1){
		redirect('GetPass/Director_Admission');
		}else{
			echo 'Error Exit';
		}
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////// Walking Dashboard 
	
	
	
	public function Walking_dashboard()
{
    $this->load->view('header',$this->data);
  
  
  /*  $this->data['totaltodaygatepass'] = $this->Getpass_model->total_today_gate_pass();
    $this->data['totalgatepass'] = $this->Getpass_model->total_gate_pass();

    $this->data['totalgateonepass'] = $this->Getpass_model->total_gate_one_pass();
    $this->data['receptionsu'] = $this->Getpass_model->receptioncount_sandundetails();
    $this->data['receptionsf'] = $this->Getpass_model->receptioncount_sanfoundetails();
    $this->data['receptionsjc'] = $this->Getpass_model->receptioncount_sanjcdetails();
    $this->data['councelor_loggedin'] = $this->Getpass_model->councelor_loggedin();
    $this->data['totalcouncelloer'] = $this->Getpass_model->total_councellor();
    $this->data['total_awaycouncelloer'] = $this->Getpass_model->total_awaycouncelloer();

    $this->data['total_gate_one_pass_today'] = $this->Getpass_model->total_gate_one_pass_today();
    $this->data['total_gate_one_pass'] = $this->Getpass_model->total_gate_one_pass();
    $this->data['total_gate_two_pass_today'] = $this->Getpass_model->total_gate_two_pass_today();
    $this->data['total_gate_two_pass'] = $this->Getpass_model->total_gate_two_pass();*/
     
	 $this->data['All_details'] =$this->Getpass_model->All_details_Dashboard();
	 
	 $this->data['All_walking'] = $this->Getpass_model->All_walking_Dashboard();
	 
	 
    $this->load->view('GetPass/walking_dashboard',$this->data);
    $this->load->view('footer');
}

public function Reload_ajax()
{
	$this->data['All_details'] = $this->Getpass_model->All_details_Dashboard();

	 
	 $this->data['All_walking'] = $this->Getpass_model->All_walking_Dashboard();
	 
    echo $this->load->view('GetPass/ajax_walkin_dashboard',$this->data); 
}







public function dashboard_reports()
{  
    ini_set('error_reporting', E_ALL);
    if($_POST['report_id']=='1')
    { 
        $total='';
        $this->data['reports_today_gate_pass'] = $this->Getpass_model->reports_today_gate_pass($total);
        //print_r($this->data['reports_today_gate_pass']);
        echo $this->load->view($this->view_dir .'total_walkins',$this->data,TRUE);
    }
    //for total walking report
    if($_POST['report_id']=='2')
    {
         $total='Y';
         $this->data['reports_today_gate_pass'] = $this->Getpass_model->reports_today_gate_pass($total);
         echo $this->load->view($this->view_dir .'total_walkins',$this->data,TRUE);
    }
    //report for Reception
    if($_POST['report_id']=='3')
    {
        $total='3';
		$report_type='Reception';
		$report_filed='SF';
         $this->data['reports_today_gate_pass'] = $this->Getpass_model->reports_receptiongate_pass($total,$report_type,$report_filed);
         echo $this->load->view($this->view_dir .'total_walkins_Reception',$this->data,TRUE);
    }
    if($_POST['report_id']=='4')
    {
         $total='4';
		 $report_type='Reception';
		 $report_filed='SUN';
         $this->data['reports_today_gate_pass'] = $this->Getpass_model->reports_receptiongate_pass($total,$report_type,$report_filed);
         echo $this->load->view($this->view_dir .'total_walkins_Reception',$this->data,TRUE);
    }
    if($_POST['report_id']=='5')
    {
        $total='5';
         $this->data['reports_today_gate_pass'] = $this->Getpass_model->reports_receptiongate_pass($total);
         echo $this->load->view($this->view_dir .'total_walkins',$this->data,TRUE);
    }
    if($_POST['report_id']=='6')
    {
        
         $this->data['reports_today_gate_pass'] = $this->Getpass_model->reports_counceller();
         echo $this->load->view($this->view_dir .'councellor_report',$this->data,TRUE);
    }

    if($_POST['report_id']=='7')
    {
        $todayinout='in';
         $this->data['reports_today_gate_pass'] = $this->Getpass_model->gate_one_passdetails_today($todayinout);
         echo $this->load->view($this->view_dir .'total_walkins',$this->data,TRUE);
    }
    if($_POST['report_id']=='8')
    {
        $todayinout='out';
         $this->data['reports_today_gate_pass'] = $this->Getpass_model->gate_one_passdetails_today($todayinout);
        
         echo $this->load->view($this->view_dir .'total_walkins',$this->data,TRUE);
    }
    if($_POST['report_id']=='9')
    {
       $todayinout='totalin';
       $this->data['reports_today_gate_pass'] = $this->Getpass_model->gate_one_passdetails_today($todayinout);
       echo $this->load->view($this->view_dir .'total_walkins',$this->data,TRUE);
    }
    if($_POST['report_id']=='10')
    {
        $todayinout='totalout';
         $this->data['reports_today_gate_pass'] = $this->Getpass_model->gate_one_passdetails_today($todayinout);
         echo $this->load->view($this->view_dir .'total_walkins',$this->data,TRUE);
    }

     if($_POST['report_id']=='11')
    {
        $todayinout='in';
         $this->data['reports_today_gate_pass'] = $this->Getpass_model->gate_two_passdetails_today($todayinout);
         echo $this->load->view($this->view_dir .'total_walkins',$this->data,TRUE);
    }
    if($_POST['report_id']=='12')
    {
        $todayinout='out';
         $this->data['reports_today_gate_pass'] = $this->Getpass_model->gate_two_passdetails_today($todayinout);
        
         echo $this->load->view($this->view_dir .'total_walkins',$this->data,TRUE);
    }
    if($_POST['report_id']=='13')
    {
        $todayinout='totalin';
         $this->data['reports_today_gate_pass'] = $this->Getpass_model->gate_two_passdetails_today($todayinout);
                  echo $this->load->view($this->view_dir .'total_walkins',$this->data,TRUE);
    }
    if($_POST['report_id']=='14')
    {
        $todayinout='totalout';
         $this->data['reports_today_gate_pass'] = $this->Getpass_model->gate_two_passdetails_today($todayinout);
         echo $this->load->view($this->view_dir .'total_walkins',$this->data,TRUE);
    }
     if($_POST['report_id']=='15')
    {
        $this->data['counsellorawaydetails'] = $this->Getpass_model->total_awaycouncelloer();
         echo $this->load->view($this->view_dir .'ajax_away_councellor_details',$this->data,TRUE); 
    }
	
	if($_POST['report_id']=='16')
    {
        $this->data['Rection_data'] = $this->Getpass_model->Get_Counsellerlist();
		//$this->data['reports_today_gate_pass'] = $this->Getpass_model->Get_Counsellerlist();
         echo $this->load->view($this->view_dir .'Counsellor_list_dashboard',$this->data,TRUE); 
		 // echo $this->load->view($this->view_dir .'Staff_Details',$this->data,TRUE); 
    }
	
	if($_POST['report_id']=='17')
    {
        $this->data['Rection_data'] = $this->Getpass_model->Counsellerlist_Login();
         echo $this->load->view($this->view_dir .'Counsellor_list_dashboard',$this->data,TRUE); 
    }
	
	if($_POST['report_id']=='20')
    {
        $this->data['Rection_data'] = $this->Getpass_model->Counsellerlist_Login();
        echo $this->load->view($this->view_dir .'total_walkins',$this->data,TRUE);
    }
 
}


function reports(){
	$role=$_REQUEST['role'];
    $condition=$_REQUEST['condition'];
	$value=$_REQUEST['value'];
	$type=$_REQUEST['type'];
	 $this->data['reports_today_gate_pass'] = $this->Getpass_model->All_details_Dashboard_report($role,$condition,$value,$type);
      // print_r($this->data['reports_today_gate_pass']);
     echo $this->load->view($this->view_dir .'Staff_Details',$this->data,TRUE);
}



public function Receptionlist_reports()
{  
$staffid=$_REQUEST['staffid'];
$campus=$_REQUEST['campus'];

$this->data['reports_today_gate_pass'] = $this->Getpass_model->report_by_receptionlist($staffid,$campus);
//print_r($this->data['reports_today_gate_pass']);
//echo $this->load->view($this->view_dir .'total_walkins_Reception',$this->data,TRUE);
 echo $this->load->view($this->view_dir .'total_walkins',$this->data,TRUE);

}
public function get_student_schoolwise()
{
	$this->data['dat1']=$_POST['date1'];
	$this->data['dat2']=$_POST['date2'];
	$this->data['concellorid']=$_POST['counid']; 
	$this->data['get_concellor']=$this->Getpass_model->getcouncellordetails();
    $this->data['reports_today_gate_pass'] = $this->Getpass_model->report_student_councellordetails($_POST['counid'],$_POST['date1'],$_POST['date2']);
         echo $this->load->view($this->view_dir .'ajax_councellr_student',$this->data,TRUE);
}

public function get_counsellordatewise_search()
{
    
    	$this->data['reports_today_gate_pass'] = $this->Getpass_model->reports_counceller($_POST['date1'],$_POST['date2']);
         echo $this->load->view($this->view_dir .'ajax_counsellor_report',$this->data,TRUE);
}

public function get_student_schoolwise_search()
{
	$this->data['dat1']=$_POST['date1'];
	$this->data['dat2']=$_POST['date2'];
	$this->data['concellorid']=$_POST['counid']; 
	$this->data['get_concellor']=$this->Getpass_model->getcouncellordetails();
    $this->data['reports_today_gate_pass'] = $this->Getpass_model->report_student_councellordetails($_POST['counid'],$_POST['date1'],$_POST['date2']);
         echo $this->load->view($this->view_dir .'ajax_councellr_studentwise_search',$this->data,TRUE);
}

public function get_counsellorawaydetails()
{
    
    $this->data['counsellorawaydetails'] = $this->Getpass_model->getcouncellorawaydetails($_POST['counid']);
     echo $this->load->view($this->view_dir .'ajax_individual_awaycouncellor',$this->data,TRUE);  
}
	
public function Student_details(){
	
		$mobno = $_REQUEST['mobile'];
		$this->load->model('state_model');
		$this->load->model('city_model');
		$std_det = $this->Walkin_reporting_model->get_student_details($mobno);
   // echo "kkk".$std_det[0]['city_id'];
		//$std = $this->Walkin_reporting_model->get_stream_std($std_det[0]['standard']);
    if(!empty($std_det[0]['state_id'])){
		$state_name = $this->state_model->get_state_details($std_det[0]['state_id']);
    }
    if(!empty($std_det[0]['city_id'])){
		$city_name = $this->city_model->get_city_details($std_det[0]['city_id']);
  }
   // print_r($city_name);
		$wlkin_details = $this->Walkin_reporting_model->get_walkin_details($std_det[0]['id']);
        $call_log =$this->Walkin_reporting_model->get_call_details($mobno);
		//print_r($std);
		//echo $std_det[0]['standard'];
		if(count($std_det)>0){
		echo "<script>    
    $(document).ready(function()
    {
	
        $('#myform').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			 row: {
        valid: 'field-success',
        invalid: 'field-error'
    },
            fields: 
            {
                status:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Select Status'
                      }
                      
                    }
                },
				walkin_on:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Select walkin date'
                      }
                      
                    }
                },
                remark:
                {
                    validators: 
                    {
                     notEmpty: 
                      {
                       message: 'Remark should not be empty'
                      }
                    }
                }		
            }       
        });
		
    });
</script>";
		echo '<div><input type="hidden" name="stud_id" id="stud_id" value="'.$std_det[0]['id'].'" /><div class="col-md-6 table-info">
<table class="table table-bordered">
<thead>
<tr>
<th colspan="4">Student Details </th>
</tr>
</thead>
<tbody>
<tr>
<td colspan="1"><b>Name</b></td>
<td colspan="3">'.$std_det[0]['student_name'].' </td>
</tr>
<tr>
<td><b>Gender</b></td>
<td>';if($std_det[0]['gender']=='M'){echo "Male"; }elseif($std_det[0]['gender']=='F'){echo 'Female'; } echo '</td>
<td><b>Date of Birth</b></td>
<td>';
if(!empty($std_det[0]['dob'])){ echo date('d-m-Y',strtotime($std_det[0]['dob'])); }else{ echo "--"; } 
echo '</td>
</tr>
<tr>
<td><b>Mobile1</b></td>
<td>'.$std_det[0]['mobile1'].'</td>
<td><b>Mobile2</b></td>
<td>'.$std_det[0]['mobile2'].'</td>
</tr>
<tr>
<td colspan="1"><b>Email Id</b></td>
<td colspan="3">'.$std_det[0]['email'].'</td>
</tr>
<tr>
<td colspan="1"><b>Address</b></td>
<td colspan="3">'.$std_det[0]['address'].' '.$std_det[0]['landmark'].'</td>
</tr>
<tr>
<td ><b>State</b></td>
<td >'.$state_name[0]['state_name'].'</td>

<td ><b>City</b></td>
<td >'.$city_name[0]['city_name'].'</td>
</tr>
<tr>
<td colspan="1"><b>Standard</b></td>
<td colspan="3">'.$std_det[0]['standard_name'].' ('.$std_det[0]['stream_name'].')</td>
</tr>
<tr>
<td ><b>Course</b></td>
<td colspan="2" >'.$this->Walkin_reporting_model->get_programme_byid($std_det[0]['programme_id']).' </td>

<td ><b>Year:</b>';
if(isset($std_det[0]['programme_year'])){ 
	if($std_det[0]['programme_year'] == '1'){
	echo ' FY ';
	}elseif($std_det[0]['programme_year'] == '2'){
  echo 'SY';
	} } 
	echo '</td>

</tr>
<tr>
<td colspan="1"><b>Source</b></td>
<td colspan="3">';
if(isset($std_det[0]['executive_id'])){
	$exe = $this->Walkin_reporting_model->get_inhouse_details($std_det[0]['executive_id']);
	if($std_det[0]['event_code']==$std_det[0]['executive_id']){
		
	echo "Staff Ref:".$std_det[0]['executive_id']." - ".$exe[0]['staff_name']." (".$exe[0]['institute'].")";
	}else{
		
	echo "Student Ref - ".$std_det[0]['event_code']."/(".$exe[0]['staff_name']."-".$exe[0]['institute'].")";	
	}
}else{
if($std_det[0]['ic_code']=='digital'){
	echo "Digital-".$std_det[0]['utm_source'];
}else{
	$icr = $this->Walkin_reporting_model->get_ic_registration($std_det[0]['ic_code']);
echo "IC-".$icr[0]['ic_name'];
	}
}

echo ' </td>
</tr>
<tr>
<td colspan="1"><b>SU JEE APPEARED</b></td>
<td colspan="3">'; 
$regno = $this->Walkin_reporting_model->get_student_registration_no($std_det[0]['id']);
//print_r($regno);
$exam_rest =  $this->Walkin_reporting_model->check_su_jee_appear($regno[0]['reg_no']);
$cnt = count($exam_rest);
$flag = 0;
if($cnt > 0){
    $flag = 1;
	echo $exam_rest[0]['exam_name'].' <a href="'.base_url().'Results/result_download/'.$regno[0]['reg_no'].'" class="btn btn-primary pull-right" aria-hidden="true">'.$regno[0]['reg_no'].'</a>';
}else{
	echo "No";
}

echo ' </td>
</tr>';
if($flag=='1'){
    echo "<tr><td colspan='1'><b>Result Collected</b> </td>";
    
    if($regno[0]['result_collected']=='N'){
        echo "<td colspan='1'>";
        echo 'No ';
        echo "</td><td colspan='2'>";
        echo ' <input type="checkbox" name="restcoll" id="restcoll" value="'.$regno[0]['reg_no'].'" > Yes'; 
        echo ' <input type="button" class="btn btn-primary pull-right" name="collres" id="collres" value="Save" />';
    echo "</td>";
    }else{
        echo "<td colspan='3'>";
        echo 'Yes';
        echo "</td>";
    }
    echo "</tr>";
}
echo '<tr>
<td colspan="1"><b>Remark</b></td>
<td colspan="3">'.$std_det[0]['remark'].'</td>
</tbody>
</table>
<div class="form-group"><div class="col-md-5"></div><div class="col-md-2"><!--<a href="'.base_url().'students/edit/'.$std_det[0]['id'].'" target="_blank"><span class="btn btn-primary pull-center">Edit</span></a>--></div><div class="col-md-2">
<a href="javascript:void(0);" class="closed_mod"><span class="btn btn-primary pull-center">Close</span></a>
</div></div>
</div>
<div class="col-md-6 " >
<div class="table-info" >
<table class="table table-bordered" >
<thead>
<tr>
<th colspan="5">Calling Details <span id="dtr" class="pull-right">show</span></th>
</tr></thead>
</table>
</div>
<div id="tdiv" style="display:none;" >
<div class="table-info" >
<table class="table table-bordered"  >
<tr>
<th>#</th>
<th >Date</th>
<th >Executive</th>
<th >Status</th>
<th >Remark</th>

</tr>

<tbody >';
$c =1;
if(count($call_log)>0){
    foreach($call_log as $val){
    echo "<tr>";
    echo "<td>".$c."</td>";
    echo "<td>".date('d-m-Y h:i:s',strtotime($val['called_on']))."</td>";
    echo "<td>".$val['staff_name']."</td>";
    
    echo "<td>".$val['calling_status']."</td>";
    echo "<td>".$val['remark']."</td>";
    echo "</tr>";
    $c++;
    }
}else{
    echo "<tr><td colspan='5'>No Call Logs</td></tr>";
}
echo '</tbody>
</table>
</div>
<form method="POST" id="callfrm" action="'.base_url().'Calling/save_call_log">
<input type="hidden" name="ssel" value="walkin" />
<div class="row">
     <div class="form-group">
        <label class="col-sm-4">Calling Status</label>
        <div class="col-sm-4"><select id="call_action" name="call_action" class="form-control"><option>SUCCESS</option><option>IN-VALID</option><option>CALL-LATER</option><option>NOT-RECHABLE</option>
        <option>INTERESTED</option>
          <option>NOT-INTERESTED</option>
        
        </select></div>
        </div>
   </div>
   <div class="row">
    <div class="form-group">
        <label  class="col-sm-4" >Remark:</label>
        <div class="col-sm-4">
            <textarea class="form-control" id="remark" name="remark"></textarea>
            <input type="hidden" id="mobile1" name="mobile1" value="'.$mobno.'" >
            <input type="hidden" id="student_id" name="student_id" value="'.$std_det[0]['id'].'" >
             <input type="hidden" id="event_code" name="event_code" value="'.$std_det[0]['event_code'].'" >
              <input type="hidden" id="ic_code" name="ic_code" value="'.$std_det[0]['ic_code'].'" >
        </div>
     </div>
    </div>
 <div class="row">
     <div class="col-sm-4"></div>
       <div class="col-sm-4" style="padding-bottom: 10px;"><button type="submit" class="btn btn-primary" id="save_log">Save Log</button></div>
 
 </div>
 
 </form>

</div>
<div class="table-info" >
<table class="table table-bordered">
<thead>
<tr>
<th colspan="5">Walkin Details</th>
</tr>
<tr>
<th>#</th>
<th >Date</th>
<th >Executive</th>
<th >Status</th>
<th >Remark</th>

</tr>
</thead>
<tbody>';
$k = 1;
foreach($wlkin_details as $val1){
	$exe = $this->Walkin_reporting_model->get_ic_users_details($val1['executive_id']);
	echo "<tr>";
	echo "<td>".$k."</td>";
	echo "<td>".date('d-m-Y h:i:s',strtotime($val1['walkin_on']))."</td>";
	echo "<td>".$exe[0]['fname']." ".$exe[0]['lname']."</td>";
	
	echo "<td>";
	if($val1['status']=='INT'){
									echo "<span class='alert status alert-success'>Interested</span>";
								}elseif($val1['status']=='NINT'){
									echo "<span class='alert status alert-danger'>Not Interested</span>";
								}elseif($val1['status']=='LCALL'){
									echo "<span class='alert status alert-warning'>Call Later</span>";
								}
	echo "</td>";
	echo "<td>".$val1['remark']."</td>";
	echo "</tr>";
	$k++;
}

echo '</tbody></table></div>';
echo '<script>$(document).ready(function(){ ';
echo '$("#dtr").click(function(){   
  $("#tdiv").toggle(function(){
    if($(this).css("display")=="none"){
        $("#dtr").html("Show");
    }else{
        $("#dtr").html("Hide");
    }
});
  }); ';
  echo "$('#collres').click(function(){ 
  var cr = $('#restcoll').val();
  if($('#restcoll'). prop('checked') == true){
  $.ajax({
                       type:'POST',
                       url: '".base_url()."walkin_reporting/save_result_collected_flag',
                       data: 'colr='+cr,
                       success: function (str) {                         
                              //alert(str);
                              if(str=='1')
                              {
                                  get_walkin_details();
                              }
                       }                     
                   });
  }else{
      alert('Select Check Box.');
  }
  
  }); $('.closed_mod').click(function(){
	//alert();
$('.studentdata').html('');
$('#myModal_view').modal('hide'); 
});";
  
echo '});</script>';
 if($this->session->userdata("role_id")=='4' || $this->session->userdata("role_id")=='7' || $this->session->userdata("role_id")=='8' || $this->session->userdata("role_id")=='6' || $this->session->userdata("role_id")=='11'){

echo ' <form id="myform" name="form" action="'.base_url('Walkin_reporting/submit').'" method="POST" enctype="multipart/form-data"><div class="panel">
<br/><input type="hidden" name="stud_id" id="stud_id" value="'.$std_det[0]['id'].'" />
<div class="form-group">
					<div class="col-md-4 text-right"><strong>Walkin On: <sup class="redasterik" style="color:red">*</sup></strong> </div>
							<div class="col-md-6"><input type="text" class="form-control" name="walkin_on" id="walkin_on" value="'.date('d-m-Y').'" />
							</div>
							</div>
<div class="form-group">
					<div class="col-md-4 text-right"><strong>Status: <sup class="redasterik" style="color:red">*</sup></strong> </div>
							<div class="col-md-6"><select class="form-control" name="status" id="status" required ><option value="">select</option><option value="INT">Interest</option><option value="NINT">Not Interest</option><option value="LCALL">Call Later</option></select>
							</div>
							</div>
							<div class="form-group">
					<div class="col-md-4 text-right"><strong>Remark: <sup class="redasterik" style="color:red">*</sup></strong> </div>
							<div class="col-md-6"><textarea class="form-control" name="remark" required ></textarea></div>
</div>
<div class="form-group">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-3">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>       </div>

</div></form></div></div>
							<script>
							
$(document).ready(function(){	 
	$("#walkin_on").datepicker( {format: "dd-mm-yyyy",autoclose:true}).on("changeDate", function (e) {
                      $("#myform").bootstrapValidator("revalidateField", "walkin_on");
                });					
		});		
</script>';
		}}else{
			echo "<div class='col-md-10 text-center text-danger'>Sorry, No Data found. Click Here <a href='".base_url()."students/add' target='_blank'><button class='btn btn-primary '  type='button' >Add</button></a> </div>";
		}
	
	
	
	
	
}
	
	function Test_redirect(){
		function pathUrl($dir = __DIR__){

    $root = "";
    $dir = str_replace('\\', '/', realpath($dir));

    //HTTPS or HTTP
    $root .= !empty($_SERVER['HTTPS']) ? 'https' : 'http';

    //HOST
    $root .= '://' . $_SERVER['HTTP_HOST'];

    //ALIAS
    if(!empty($_SERVER['CONTEXT_PREFIX'])) {
        $root .= $_SERVER['CONTEXT_PREFIX'];
        $root .= substr($dir, strlen($_SERVER[ 'CONTEXT_DOCUMENT_ROOT' ]));
    } else {
        $root .= substr($dir, strlen($_SERVER[ 'DOCUMENT_ROOT' ]));
    }

    $root .= '/';

    return $root;
}

$file = 'https://sandipuniversity.com/payment/chpdf/rights.jpg';
echo $file_headers = @get_headers($file);
/*if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
    $exists = false;
}
else {
    $exists = true;
}*/



 $handle = fopen("var/www/html/payment/chpdf/rights.jpg", "r");
 echo $handle;echo '<br>';
//echo pathUrl();
$path = getcwd();echo '<br>';
echo "This Is Your Absolute Path: ";echo '<br>';
echo $path;echo '<br>';
echo dirname(__DIR__);echo '<br>'; // prints '/home/public_html/'
echo dirname(__FILE__); echo '<br>';// prints '/home/public_html/images'
		//echo dirname(dirname(__FILE__));
		$mobile='9960006338';
		//redirect('Prospectus_fee_details/student_prospectus_add?mobile='.$mobile);
	echo	$url='var/www/html/payment/chpdf/rights.jpg';echo '<br>';
	 $handle = fopen("../var/www/html/payment/chpdf/rights.jpg", "r");
 echo $handle;

	echo '<img src="'.$url.'">';
	/*echo "<iframe src=\"$url\" width=\"100%\" style=\"height:100%\">
	<img src=".$url.">
	</iframe>";*/

		if (file_exists($url)) {
    echo "The file $filename exists";
} else {
    echo "The file $filename does not exist";
}
	}
	
	
	public function payment_counselloer(){
		 $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$this->load->view('header',$this->data);
		 $this->data['Rection_data'] = $this->Getpass_model->payment_counselloer($uid);
	 
	 
    $this->load->view('GetPass/payment_counselloer',$this->data);
    $this->load->view('footer');
		
	}
	
	public function Approval_Request(){
		 $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		$uid=$session['uid'];
		$name=$session['name'];
		
		$walkin_id =$_REQUEST['walkin_id'];
		$student_name =$_REQUEST['student_name'];
	    $studentmeet_id =$_REQUEST['studentmeet_id'];
		$walkin_id =$_REQUEST['walkin_id'];
		$stumobile =$_REQUEST['stumobile'];
		///////////////////////////////////////////////////////
		$Qualification =$_REQUEST['Qualification'];
		$Qualificationmark =$_REQUEST['Qualificationmark'];
		$Campus =$_REQUEST['Campus'];
		$school_name =$_REQUEST['school_name'];
		$CoursesType =$_REQUEST['CoursesType'];
		$Courses =$_REQUEST['Courses'];
		$CourseYear =$_REQUEST['CourseYear'];
		
		
		$id=$this->Getpass_model->Approval_Request($_REQUEST,$uid,$name);
		$data['Doa_details']=$this->Getpass_model->Doa_Request($walkin_id);
       // $data['requestion_details']=$this->Getpass_model->Doa_Request($name);
	    $data['requestion_details']=$this->Getpass_model->get_CounsellorDetails($walkin_id);
	    $this->load->view('GetPass/Refresh_Request',$data);
		//if($id){echo '1';}else{echo '2';}
		
	}
	
	function Doa_Refresh(){
		$session=$this->session->userdata('logsession');
		$uid=$session['uid'];
		$name=$session['name'];
		
		$id=$_REQUEST['walkin_id'];
	    $data['Doa_details']=$this->Getpass_model->Doa_Request($id);
       // $data['requestion_details']=$this->Getpass_model->Doa_Request($name);
	    $data['requestion_details']=$this->Getpass_model->get_CounsellorDetails($id);
	    $this->load->view('GetPass/Refresh_Request',$data);
	}
	
	
	function Request_page(){
		$session=$this->session->userdata('logsession');
		 $uid=$session['uid'];
		 $name=$session['name'];
		//exit;
		$id=$_REQUEST['walkin_id'];
	    //$data['requestion_details']=$this->Getpass_model->Doa_Request($id);
       
		
	    $this->load->view('header',$this->data);
		 $data['Rection_data']=$this->Getpass_model->Request_page();
		//print_r($data['Rection_data']);
	    $this->load->view('GetPass/Ado_Request_page',$data);
		
		$this->load->view('footer');
	}
	
	function Request_page_refresh(){
		 $data['Rection_data']=$this->Getpass_model->Request_page();
		//print_r($data['Rection_data']);
	    $this->load->view('GetPass/Ado_Request_page_refresh',$data);
	}
	
	function edit_Ado_Request(){
		$session=$this->session->userdata('logsession');
		$uid=$session['uid'];
		$name=$session['name'];
		  $id= $this->uri->segment(3);
		//$id=$_REQUEST['walkin_id'];
	    //$data['requestion_details']=$this->Getpass_model->get_studetails($id);
        $data['requestion_details']=$this->Getpass_model->edit_Ado_Request($id);
	
	    $this->load->view('GetPass/edit_Ado_Request',$data);
	}
	
	function Request_update(){
		$session=$this->session->userdata('logsession');
		$uid=$session['uid'];
		$name=$session['name'];
		
		$request_id=$_REQUEST['request_id'];
		$walkin_id=$_REQUEST['walkin_id'];
		$cstatus=$_REQUEST['cstatus'];
		$Ado_remark=$_REQUEST['Ado_remark'];
		
		$data['requestion_details']=$this->Getpass_model->Request_update($request_id,$walkin_id,$cstatus,$Ado_remark);
		redirect('GetPass/Request_page');
	}
	
	public function Payment_Ado(){
		 $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$this->load->view('header',$this->data);
		 $this->data['Rection_data'] = $this->Getpass_model->payment_counselloer($uid);
	 
	 
    $this->load->view('GetPass/payment_Ado',$this->data);
    $this->load->view('footer');
		
	}
	
	function Paymentado_update(){
		 $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$ads['ado_status']=$_REQUEST['status'];
		$id=$_REQUEST['id'];
		
		echo $this->Getpass_model->Paymentado_update($ads,$id);
	}
	
	
	
	public function Capado(){
		 $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$this->load->view('header',$this->data);
		 $this->data['Rection_data'] = $this->Getpass_model->payment_counselloer($uid);
	 
	 
    $this->load->view('GetPass/cap_ado',$this->data);
    $this->load->view('footer');
		
	}
	/*function Doa_Refresh(){
		$session=$this->session->userdata('logsession');
		$uid=$session['uid'];
		$name=$session['name'];
		$walkin_id=$_REQUEST['walkin_id'];
	}*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function Admission_Send(){
	
	 $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		$walkin_id=$_REQUEST['walkin_id'];
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		
		$awd['admissionc_status']='Open';
		//$this->load->view('header',$this->data);	
		//$data['Rection_data']=$this->Getpass_model->Rection_data($uid,$name,$campusid);
		$d=$this->Getpass_model->Admission_Send($uid,$name,$awd,$walkin_id);
		redirect('GetPass/Get_reception');
	// print_r($data['Rection_data']);
	// exit;
	 
   /// $this->load->view('GetPass/Admission_Center',$data);
    //$this->load->view('footer');
}



function Admission_center(){
	 $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$this->load->view('header',$this->data);	
		//$data['Rection_data']=$this->Getpass_model->Rection_data($uid,$name,$campusid);
		$data['Rection_data']=$this->Getpass_model->Admission_center($uid,$name,$campusid);
	// print_r($data['Rection_data']);
	// exit;
	 
    $this->load->view('GetPass/Admission_Center',$data);
    $this->load->view('footer');
}


function Admission_centerRefesh(){
	 $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		//$this->load->view('header',$this->data);	
		//$data['Rection_data']=$this->Getpass_model->Rection_data($uid,$name,$campusid);
		$data['Rection_data']=$this->Getpass_model->Admission_center($uid,$name,$campusid);
	    // print_r($data['Rection_data']);
	    // exit;
	 
         $this->load->view('GetPass/Admissioncenter_refresh',$data);
        // $this->load->view('footer');
     }
	 
	 
	 public function History(){
		 $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$id=$_REQUEST['id'];
		$data['reports_today_gate_pass']=$this->Getpass_model->History($id);
	    // print_r($data['Rection_data']);
	    // exit;
	 
         $this->load->view('GetPass/History_details',$data);
	 }
	 
	  public function Action_report(){
		 $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$id=$_REQUEST['id'];
		$role=$_REQUEST['role'];
		$data['reports_today_gate_pass']=$this->Getpass_model->Action_report($role,$id);
	    // print_r($data['Rection_data']);
	    // exit;
	 
         $this->load->view('GetPass/Action_report',$data);
	 }
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	public function Dispatch(){
		$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$data['Dispatchlist']=$this->Getpass_model->Dispatchlist($uid);
		$data['Formlist']=$this->Getpass_model->Formlist($uid);
	   //  print_r($data['Formlist']);
	    // exit;
	    $this->load->view('header',$this->data);
        $this->load->view('GetPass/Dispatch',$data);
		$this->load->view('footer');
		
		
	}
	  
	  
	  public function Dispatch_add(){
		  $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		$favorite=array();
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$token=date('ymdhis');
		
		$favorite=$_REQUEST['Id'];
		$approval['Dispatch_status']='Y';
		foreach($favorite as $list){
		$this->db->where('counsellor_Prospectusid', $list);
		$this->db->update('admission_counsellor_Prospectus', $approval);	
		}
		 $data['Dispatchlist']=$this->Getpass_model->Dispatchlist($uid);
		$data['Formlist']=$this->Getpass_model->Formlist($uid);
		 echo  $this->load->view('GetPass/Dispatch_ajax',$data);
	  }
	  
	  public function Dispatch_Remove(){
		   $session=$this->session->userdata('logsession');
		   $uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		  $Id=$_REQUEST['Id'];
		  $approval['Dispatch_status']='N';
		  $this->db->where('counsellor_Prospectusid', $Id);
		 $this->db->update('admission_counsellor_Prospectus', $approval);
		$data['Dispatchlist']=$this->Getpass_model->Dispatchlist($uid);
		$data['Formlist']=$this->Getpass_model->Formlist($uid);
		 echo  $this->load->view('GetPass/Dispatch_ajax',$data);
	  }
	  
	  public function Dispatch_Submit(){
		  
		    $session=$this->session->userdata('logsession');
			 $_FILES['fileToUpload']['name'];
		//	print_r($_REQUEST);exit;
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		$favorite=array();
		$formno=array();
		$sname=array();
		$mobile=array();
		
		
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$token=date('ymdhis');
		
		$favorite=$_REQUEST['Prospectusid'];
		
		$formno=$_REQUEST['formno'];
		$sname=$_REQUEST['sname'];
		$mobile=$_REQUEST['mobile'];
		
		if(!empty($_FILES['fileToUpload']['name'])){
      $filenm=time().'-'.$_FILES['fileToUpload']['name'];
      $config['upload_path'] = 'uploads/Ado/';
      $config['allowed_types'] = 'jpg|jpeg|png|PNG|pdf|xlsx|xls|txt';
      $config['overwrite']= TRUE;
      $config['max_size']= "5048000";
      //$config['file_name'] = $_FILES['profile_img']['name'];
      $config['file_name'] = $filenm;

      //Load upload library and initialize configuration
      $this->load->library('upload',$config);
      $this->upload->initialize($config);

      if($this->upload->do_upload('fileToUpload')){
        $uploadData = $this->upload->data();
		//print_r($uploadData);
        $pic = $uploadData['file_name'];
		echo '1';
      }else{
		 $error= $this->upload->display_errors();
		// print_r($error);
        $pic = '';
		echo '2';
      }
     }
     else{
      $pic = '';
	 // echo 'Not';
     }
		//echo $pic;
		//exit;
		
		
		
		$approval['Dispatch_status']='S';
		$approval['recepit_key']=$token;
		$approval['upload_recepit']='uploads/Ado/'.$pic;
		
		
		//$fp = fopen('uploads/Ado/'.$recepit_key, 'w');
		$myfile = fopen('uploads/Ado/'.$token.'.txt', "w") or die("Unable to open file!");

       // fwrite($fp, $content);
        
         
		$approval['upload_file']='uploads/Ado/'.$token.'.txt';
		
		
		$i=0;
		foreach($favorite as $list){
		$this->db->where('counsellor_Prospectusid', $list);
		$content=$formno[$i].'-'.$sname[$i].'-'.$mobile[$i];
		 // fwrite($myfile, $content);
		 file_put_contents('./uploads/Ado/'.$token.'.txt', $content.'-'.PHP_EOL , FILE_APPEND | LOCK_EX);
		$this->db->update('admission_counsellor_Prospectus', $approval);	
		$i++;
		}
		fclose($myfile);
    	chmod('uploads/Ado/'.$recepit_key, 0777);
		redirect('GetPass/Dispatch');
		
		
		// $data['Dispatchlist']=$this->Getpass_model->Dispatchlist($uid);
		// $data['Formlist']=$this->Getpass_model->Formlist($uid);
		// echo  $this->load->view('GetPass/Dispatch_ajax',$data);
	  }
	  
	  
	  
	  
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	                             ///IC -DISPATCH provisional_admission_details////////////////////////////////////
								 
								 
								 
								 
	public function IC_Dispatch(){
		
		
		$session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$data['Dispatchlist']=$this->Getpass_model->IC_Dispatchlist($uid);
		$data['Formlist']=$this->Getpass_model->IC_Formlist($uid);
	   //  print_r($data['Formlist']);
	    // exit;
	    $this->load->view('header',$this->data);
        $this->load->view('GetPass/Ic_dispatch',$data);
		$this->load->view('footer');
		
		
	}
	  
	  
	  public function IC_Dispatch_add(){
		  $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		$favorite=array();
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$token=date('ymdhis');
		
		$favorite=$_REQUEST['Id'];
		$approval['Dispatch_status']='Y';
		foreach($favorite as $list){
		$this->db->where('adm_id', $list);
		$this->db->update('provisional_admission_details', $approval);	
		}
		 $data['Dispatchlist']=$this->Getpass_model->IC_Dispatchlist($uid);
		$data['Formlist']=$this->Getpass_model->IC_Formlist($uid);
		 echo  $this->load->view('GetPass/ajax_ic_dispatch',$data);
	  }
	  
	  public function IC_Dispatch_Remove(){
		   $session=$this->session->userdata('logsession');
		   $uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		  $Id=$_REQUEST['Id'];
		  $approval['Dispatch_status']='N';
		  $this->db->where('adm_id', $Id);
		 $this->db->update('provisional_admission_details', $approval);
		$data['Dispatchlist']=$this->Getpass_model->IC_Dispatchlist($uid);
		$data['Formlist']=$this->Getpass_model->IC_Formlist($uid);
		 echo  $this->load->view('GetPass/ajax_ic_dispatch',$data);
	  }
	  
	  public function IC_Dispatch_Submit(){
		  
		    $session=$this->session->userdata('logsession');
			 $_FILES['fileToUpload']['name'];
		//	print_r($_REQUEST);exit;
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		$favorite=array();
		$formno=array();
		$sname=array();
		$mobile=array();
		
		
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$token=date('ymdhis');
		
		$favorite=$_REQUEST['Prospectusid'];
		
		$formno=$_REQUEST['formno'];
		$sname=$_REQUEST['sname'];
		$mobile=$_REQUEST['mobile'];
		
		if(!empty($_FILES['fileToUpload']['name'])){
      $filenm=time().'-'.$_FILES['fileToUpload']['name'];
      $config['upload_path'] = 'uploads/Ado/';
      $config['allowed_types'] = 'jpg|jpeg|png|PNG|pdf|xlsx|xls|txt';
      $config['overwrite']= TRUE;
      $config['max_size']= "5048000";
      //$config['file_name'] = $_FILES['profile_img']['name'];
      $config['file_name'] = $filenm;

      //Load upload library and initialize configuration
      $this->load->library('upload',$config);
      $this->upload->initialize($config);

      if($this->upload->do_upload('fileToUpload')){
        $uploadData = $this->upload->data();
		//print_r($uploadData);
        $pic = $uploadData['file_name'];
		echo '1';
      }else{
		 $error= $this->upload->display_errors();
		// print_r($error);
        $pic = '';
		echo '2';
      }
     }
     else{
      $pic = '';
	 // echo 'Not';
     }
		//echo $pic;
		//exit;
		
		
		
		$approval['Dispatch_status']='S';
		$approval['recepit_key']=$token;
		$approval['upload_recepit']='uploads/Ado/'.$pic;
		
		$approval['DispatchType']=$_REQUEST['DispatchType'];
		$approval['Dispatchperson']=$_REQUEST['Dispatchperson'];
		$approval['DispatchMobile']=$_REQUEST['DispatchMobile'];
		$approval['DispatchCourier']=$_REQUEST['DispatchCourier'];
		$approval['Courier_track']=$_REQUEST['Courier_track'];
     	$approval['upload_file']=$_REQUEST['upload_file'];
		//$fp = fopen('uploads/Ado/'.$recepit_key, 'w');
		$myfile = fopen('uploads/Ado/'.$token.'.txt', "w") or die("Unable to open file!");

       // fwrite($fp, $content);
        
         
		$approval['upload_file']='uploads/Ado/'.$token.'.txt';
		
		
		$i=0;
		foreach($favorite as $list){
		$this->db->where('adm_id', $list);
		$content=$formno[$i].'-'.$sname[$i].'-'.$mobile[$i];
		 // fwrite($myfile, $content);
		 file_put_contents('./uploads/Ado/'.$token.'.txt', $content.'-'.PHP_EOL , FILE_APPEND | LOCK_EX);
		$this->db->update('provisional_admission_details', $approval);	
		$i++;
		}
		fclose($myfile);
    	chmod('uploads/Ado/'.$recepit_key, 0777);
		redirect('GetPass/IC_Dispatch');
		
		
		// $data['Dispatchlist']=$this->Getpass_model->Dispatchlist($uid);
		// $data['Formlist']=$this->Getpass_model->Formlist($uid);
		// echo  $this->load->view('GetPass/Dispatch_ajax',$data);
	  }
	  
	  public function IC_Dispatch_Ado(){
		 $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$this->load->view('header',$this->data);
		 $this->data['Rection_data'] = $this->Getpass_model->IC_payment_counselloer($uid);
	 
	 
    $this->load->view('GetPass/IC_payment_Ado',$this->data);
    $this->load->view('footer');
		
	}
	
	function IC_Paymentado_update(){
		 $session=$this->session->userdata('logsession');
		//echo '<pre>';print_r($_POST);echo '<br>';
		// $uid=$session['uid']; echo '<br>';
		// $name=$session['name'];echo '<br>';
		
		$uid=$session['uid'];
		$name=$session['name'];
		$campusid=$session['campusid'];
		$ads['Dispatch_status']=$_REQUEST['status'];
		$id=$_REQUEST['id'];
		
		echo $this->Getpass_model->Ic_Paymentado_update($ads,$id);
	}
	
	function test_sms(){
		$data=$this->Getpass_model->call_newdb();
		print_r($data);
		exit;
		?>
		
		<script src="<?=base_url()?>assets/javascripts/jquery.min.js"></script>
		 <script>
   var mobno='9960006338';
   var content='Test';
    jQuery.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>/GetPass/Ajax_sms',
            data: {mobno:mobno,content:content},
			cache: false,
            success: function(data) {
            console.log('done');
             }
        });
   </script>
<?php	

header('Refresh: 0;url='.base_url().'/GetPass');

} 
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////	





/* code by vghnsh */

public function dashboard()
{
    $this->load->view('header',$this->data);

     
	 $this->data['all_enquiry_details'] =$this->Getpass_model->enquiry_details();
	 $this->data['today_enquiry_details'] =$this->Getpass_model->enquiry_details(date('Y-m-d'));
	 $this->data['today_form_details'] =$this->Getpass_model->form_details(date('Y-m-d'));
	 $this->data['all_form_details'] =$this->Getpass_model->form_details();
	 $this->data['all_provisional_details'] =$this->Getpass_model->provisional_details();
	 $this->data['today_provisional_details'] =$this->Getpass_model->provisional_details(date('Y-m-d'));

     $this->load->view('GetPass/dashboard',$this->data);
    $this->load->view('footer');
}

}
?>