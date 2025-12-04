<?php
class Authentication_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
      //     error_reporting(E_ALL);
//ini_set('display_errors', 1);
       
    }
    
    public function test_sms()
    {
        $mobile ="9545453097";
        $sms_message ="Test message";
        $odj = new Message_api();
           
     $odj->send_sms($mobile,$sms_message);	
    }
    
  public function verify_credentials()
  {
   
      // $this->load->library('Mylibrary');
       // $test    = NEW CI_Mylibrary();
    //  $this->MyLibrary->sendSms('7208608357','test message');

  	$this->db->select("em.emp_id,eod.mobileNumber");
 	$this->db->from("employee_master em"); 	
 	$this->db->join('employe_other_details as eod','em.emp_id=eod.emp_id' ,'left');
	$this->db->where('em.emp_id ',$_POST['uid']);
	$this->db->where('em.date_of_birth ',$_POST['dob']);	
  	$query=$this->db->get();
//echo $this->db->last_query();
	$result=$query->row_array();
	if($result['emp_id']!='')
	{
	   // $obj = new CI_Mylibrary();
	    
	    echo "Y";
	}
	else{
	  
	    echo 'N';
	}
  	
  	
  	
  }
    
    
    public function get_otp_attempt($uid,$type)
    {
      $date = date('Y-m-d');
      if($type=='staff')
      {
   		$this->db->select("otp_count");
		$this->db->from('user_master');
	 $this->db->where("username",$uid);  
	 $this->db->where("otp_date",$date);  
		//	 $this->db->where("roles_id",'4');  	    
		$query=$this->db->get();
     
            
      }
    if($type=='student')
      {
     
     
        $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("otp_count");
		$DB1->from('user_master');
	 $DB1->where("username",$uid);  
	 $DB1->where("otp_date",$date);  
			 $DB1->where("roles_id",'4');  	    
		$query=$DB1->get();
     
     
          
      }
      
      
          if($type=='parent')
      {
     
     
        $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("otp_count");
		$DB1->from('user_master');
	 $DB1->where("username",$uid);  
	 $DB1->where("otp_date",$date);  
			 $DB1->where("roles_id",'9');  	    
		$query=$DB1->get();
     
     
          
      }
   	 
   	 


	$result=$query->row_array();   
      
      return $result['otp_count'];
      
        
    }
  
  
    public function verify_credentials_staff()
  {


  	$this->db->select("em.emp_id,eod.mobileNumber as mobile");
 	$this->db->from("employee_master em"); 	
 	$this->db->join('employe_other_details as eod','em.emp_id=eod.emp_id' ,'left');
	$this->db->where('em.emp_id',$_POST['uid']);
	$this->db->where('em.date_of_birth',$_POST['dob']);	
	$this->db->where("em.emp_status",'Y');  
  	$query=$this->db->get();

	$result=$query->row_array();
	if($result['mobile']!='')
	{
	    
	      $mobile= $result['mobile'];  
	    
	    if($mobile=='' || strlen($mobile) < 10 || strlen($mobile) > 11 )
{
     echo 'Mobile Number not registered. Please contact student section';
    exit();
}
   
	
	
   $cnt = $this->get_otp_attempt($_POST['uid'],'staff');

if($cnt > 2)
{
    echo 'You have reached maximum OTP generation limit for a day';
    exit();
}
	  
$otp = rand(10000,99999);

$sms_message ="Dear Staff
Your OTP for Password Reset at Sandip University ERP is $otp

Thank you
Sandip University
";

$sdata['otp'] = $otp ; 
$sdata['otp_date'] = date('Y-m-d') ; 
$sdata['otp_count'] = $result['otp_count'] + 1 ; 
  $this->db->where('username',$_POST['uid']);
 $this->db->update('user_master',$sdata);
	
$odj = new Message_api();
           
     $odj->send_sms($mobile,$sms_message);		

	    echo "Y";
 
	}
	else{
	    
	  
	    echo 'Invalid Combination Please Check and try again';
	}
  	
  	
  	
  }  
    
    
  
  
  
  
  
  
  
  
  
  
  
  
    public function verify_credentials_student()
  {

	    $DB1 = $this->load->database('umsdb', TRUE);
	    
	    if($_POST['utypes']=="parent")
	    {
	        $role ="9";
	    }
	     if($_POST['utypes']=="student")
	    {
	         $role ="4";  
	    }
		$DB1->select("um.*,sm.mobile,pd.parent_mobile2 as pmobile");
		$DB1->from('student_master as sm');
		$DB1->join('user_master as um','um.username = sm.enrollment_no','left');
		$DB1->join('parent_details as pd','sm.stud_id = pd.student_id','left');
	 $DB1->where("sm.enrollment_no",$_POST['uid']);  
	 $DB1->where("sm.dob",$_POST['dob']);  
			 $DB1->where("um.roles_id",$role);  	    
		 $DB1->where("um.status",'Y');  	   
	
		$query=$DB1->get();

//echo $DB1->last_query();
	$result=$query->row_array();
	if($result['username']!='')
	{


	    if($_POST['utypes']=="parent")
	    {
	    $mobile= $result['pmobile'];	 
	    }
	     if($_POST['utypes']=="student")
	    {
	        $mobile= $result['mobile'];	 
	    }
if($mobile=='' || strlen($mobile) < 10 || strlen($mobile) > 11 )
{
     echo 'Mobile Number not registered. Please contact student section';
    exit();
}
   
	    
	    
   $cnt = $this->get_otp_attempt($_POST['uid'],$_POST['utypes']);
//echo $cnt;
//exit();
if($cnt > 2)
{
    echo 'You have reached maximum OTP generation limit for a day';
    exit();
}
	   
	 $title = ucfirst($_POST['utypes']);  
	   
$otp = rand(10000,99999);

$sms_message ="Your OTP for Password Reset at Sandip University ERP is $otp";

$sdata['otp'] = $otp ; 
$sdata['otp_date'] = date('Y-m-d') ; 
$sdata['otp_count'] = $result['otp_count'] + 1 ; 
  $DB1->where('um_id',$result['um_id']);
 $DB1->update('user_master',$sdata);

$odj = new Message_api();
           
     $odj->send_sms_reset_password($mobile,$sms_message);		

	    echo "Y";
	}
	else{
	    
	  
	    echo 'Invalid Combination Please Check and try again';
	}
  	
  	
  	
  }  
    
    
    
    public function send_login_credentials()
    {
        
           if($_POST['utypes']=="parent")
	    {
	        $role ="9";
	    }
	     if($_POST['utypes']=="student")
	    {
	         $role ="4";  
	    }
	    
	    
   	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("um.*,sm.mobile,pd.parent_mobile2 as pmobile");
		$DB1->from('student_master as sm');
		$DB1->join('user_master as um','um.username = sm.enrollment_no','left');
		$DB1->join('parent_details as pd','sm.stud_id = pd.student_id','left');
	 $DB1->where("sm.enrollment_no",$_POST['uid']);  
	 $DB1->where("sm.dob",$_POST['dob']);  
			 $DB1->where("um.roles_id",$role);  
			 	 $DB1->where("um.otp",$_POST['otp']);  
		 $DB1->where("um.status",'Y');  	   
	

              $dat['user_id']=$_POST['uid'];
               $dat['dob']=$_POST['dob'];
                $dat['role']=$role;
            
             $dat['logintime']=date('Y-m-d H:i:s');
             $dat['ip_address']=$_SERVER['REMOTE_ADDR'];
             $dat['user_agent']=$_SERVER['HTTP_USER_AGENT'];


	 $title = ucfirst($_POST['utypes']);  
		$query=$DB1->get();
	$results=$query->row_array(); 
	
	if($results['username']!='')
	{
	    	    if($_POST['utypes']=="parent")
	    {
	    $mobile= $results['pmobile'];	 
	    }
	     if($_POST['utypes']=="student")
	    {
	        $mobile= $results['mobile'];	 
	    }
//	  $mobile= $results['mobile'];
$username = $results['username'];
$password = $results['password'];
$sms_message ="Dear $title
Your login details.
Please logon to
sandipuniversity.edu.in/erp-login.php
Username $username
Password $password
Thank you
Sandip University
";

$odj = new Message_api();
           
     $odj->send_sms($mobile,$sms_message);	

	  $dat['status']='Y';
	echo "Y";
	}
	else
	{
	  echo "N";  
	   $dat['status']='N';
	}
	
           	$DB1->insert('reset_password_logs',$dat);
        
    }
    
    
    
    
    
    
    
      public function send_login_credentials_staff()
    {
   	    $DB1 = $this->load->database('umsdb', TRUE);
	
	  	$this->db->select("em.emp_id,eod.mobileNumber as mobile,um.*");
 	$this->db->from("employee_master em"); 	
 	$this->db->join('employe_other_details as eod','em.emp_id=eod.emp_id' ,'left');
 	$this->db->join('user_master as um','um.username = em.emp_id','left');
	$this->db->where('em.emp_id',$_POST['uid']);
	$this->db->where('em.date_of_birth',$_POST['dob']);	
	$this->db->where("um.otp",$_POST['otp']);  
	$this->db->where("em.emp_status",'Y');  
  	$query=$this->db->get();
//	echo $this->db->last_query();
		$results=$query->row_array(); 
		
		
	  $dat['user_id']=$_POST['uid'];
               $dat['dob']=$_POST['dob'];
                $dat['role']=$results['roles_id'];
            
             $dat['logintime']=date('Y-m-d H:i:s');
             $dat['ip_address']=$_SERVER['REMOTE_ADDR'];
             $dat['user_agent']=$_SERVER['HTTP_USER_AGENT'];

	
		//	$query=	$this->db->get();

	
	

	
	if($results['mobile']!='')
	{
	  $mobile= $results['mobile'];
$username = $results['username'];
$password = $results['password'];
$sms_message ="Dear Staff
Your login details.
Please logon to
sandipuniversity.edu.in/erp-login.php
Username $username
Password $password
Thank you
Sandip University
";

$odj = new Message_api();
           
     $odj->send_sms($mobile,$sms_message);	

	  $dat['status']='Y';
	echo "Y";
	}
	else
	{
	  echo "N";  
	   $dat['status']='N';
	}
	
           	$DB1->insert('reset_password_logs',$dat);
        
    }
    
    
    
   
    
    
    
 public function get_fees_collection_admission($data){
     	$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("s.stud_id,s.enrollment_no,s.enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,v.school_short_name,v.course_short_name, v.stream_short_name,d.year,f.amount as paid,s.cancelled_admission, f.fees_paid_type,f.receipt_no as ddno,f.amount ,date_format(f.fees_date,'%d-%m-%Y') as fdate,f.college_receiptno,f.chq_cancelled ,f.remark,b.bank_name,b.bank_short_name,s.cancelled_admission ,d.actual_fee,d.applicable_fee");
		$DB1->from('admission_details as d');
		$DB1->join('student_master as s','s.stud_id = d.student_id  ','left');
		$DB1->join('vw_stream_details as v','s.admission_stream = v.stream_id','left');
		$DB1->join('fees_details as f','f.student_id = s.stud_id and f.academic_year=d.academic_year','left');
		$DB1->join('bank_master as b','f.bank_id=b.bank_id' ,'left');
		$DB1->where('f.is_deleted ', 'N');
		$DB1->where('f.type_id', '2');
	    $DB1->where('f.academic_year',$data['academic_year']);
	    if($data['admission_type']=="N"){
	      $DB1->where('s.admission_session',$data['academic_year']);
	    }else if($data['admission_type']=="R")
	    {
	        $DB1->where('s.admission_session!=',$data['academic_year']);
	    }
	    else{
	       $DB1->where('s.academic_year=',$data['academic_year']);  
	    }
	  
		$DB1->order_by("v.stream_name,s.cancelled_admission,s.current_year,s.enrollment_no", "asc");
		$query=$DB1->get();
	  // echo $DB1->last_query();exit;
			$result=$query->result_array();
		return $result;
 }
 
 
}

?>