<?php
class Other_feemodel extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
        
        $DB1 = $this->load->database('umsdb', TRUE); 
    }
    //get courses offered by college
	  public  function getStudentID($studid ='SU'){
	
	$random_id_length = 5; 
	$this->db->select_max('reg_id','max_no');
	$query = $this->db->get('student_registration_part1');
	$ret = $query->row();

	//$max_id =$dd['max_no']+1;
	 $max_id =($ret->max_no)+1;
	$rnd_id = str_pad($max_id,$random_id_length,'0',STR_PAD_LEFT); 
	$current_yr=date("Y");
	return $studid.'_'.$current_yr.'_'.$rnd_id;
}



function getFeesdata($payid=''){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('online_payment');
		$DB1->where("payment_status",'success');	  
	if($payid!='')
	{
	  	$DB1->where("payment_id",$payid);	    
	}
		$DB1->where("verification_status","N");	 
		$DB1->where("is_deleted","N");	   
	
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		//	$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		
		//	$DB1->where("sm.admission_stream",$streamid);	    
		
		//	$DB1->where("sm.admission_year", $year);	   	    
	
		$DB1->order_by("payment_id", "desc");
		$query=$DB1->get();
		/*  echo $this->db->last_query();
		die();  */ 
		$result=$query->result_array();
	//	 echo $DB1->last_query();
	//	 exit(0);
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}


function student_payment_history(){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('online_payment');
		$DB1->where("registration_no",$_SESSION['name']);	  
	
		$DB1->where("user_type","R");
//		$DB1->where("verification_status","Y");
		$DB1->where("payment_status","success");
		
	//	$DB1->where("is_deleted","N");	   
 	    
	
		$DB1->order_by("payment_id", "desc");
		$query=$DB1->get();
		$result=$query->result_array();
		return $result;
	}



function getFeesajax(){
		 $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('online_payment');
		$DB1->where("payment_status",'success');	  
		if($_POST['pstatus']!='')
		{
		$DB1->where("verification_status",$_POST['pstatus']);	
	//	$DB1->where("is_deleted",'N');	
		}
		if($_POST['pdate']!='')
		{
		$DB1->where("DATE(payment_date)",$_POST['pdate']);	    
		}
			$DB1->where("is_deleted",'N');	
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		//	$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		
		//	$DB1->where("sm.admission_stream",$streamid);	    
		
		//	$DB1->where("sm.admission_year", $year);	   	    
	
		$DB1->order_by("payment_id", "desc");
		$query=$DB1->get();
		/*  echo $this->db->last_query();
		die();  */ 
		$result=$query->result_array();
		 //echo $this->db->last_query();
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
    

function studentdet_byprn($prn)
{
    	 $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("stud_id");
		$DB1->from('student_master');
		$DB1->where("enrollment_no",$prn);	  
    	$query=$DB1->get();
	
//echo $DB1->last_query();
		$result=$query->row_array();
		return $result;
}

function remove_list()
{
        $DB1 = $this->load->database('umsdb', TRUE);
    	$fdat = $this->getFeesdata($_POST['fid']);

    $pdata['verification_status'] = 'R';

      
   $DB1->where('payment_id', $_POST['fid']);       
	$DB1->update('online_payment', $pdata);
	
}


function update_feestatus()
{
        $DB1 = $this->load->database('umsdb', TRUE);
    	$fdat = $this->getFeesdata($_POST['fid']);
    date_default_timezone_set("Asia/Kolkata");
    $pdata['verified_by'] = $_SESSION['uid'];
    $pdata['verified_on'] = date('Y-m-d h:i:s');
    $pdata['verification_status'] = 'Y';
    $pdata['verified_from_ip'] = $_SERVER['REMOTE_ADDR'];
                    
  
      
   $DB1->where('payment_id', $_POST['fid']);       
	$DB1->update('online_payment', $pdata);
	
	

//	var_dump($fdat);
	
	$studdet = $this->studentdet_byprn($fdat[0]['registration_no']);
	//	var_dump($studdet);
//	echo $DB1->last_query();
//	echo $fdat[0]['payment_mode'];
//	exit(0);
	
	$fdetails['type_id']=$fdat;
	$fdetails['student_id']=$studdet['stud_id'];
	$fdetails['fees_paid_type']='PG';	
	$fdetails['receipt_no']=$fdat[0]['receipt_no'];	
	$fdetails['type_id']=2;	
$fdetails['amount']=$fdat[0]['amount'];	
$fdetails['bank_id']=79;	
$fdetails['bank_city']=$fdat[0]['pg_type'];
$fdetails['fees_date']=$fdat[0]['payment_date'];

$fdetails['remark']="Payment Made using ".$fdat[0]['payment_mode'];	
$fdetails['academic_year']=$fdat[0]['academic_year'];	
$fdetails['entry_from_ip']=$_SERVER['REMOTE_ADDR'];	
$fdetails['created_by']=$_SESSION['uid'];	
$fdetails['created_on']=date('Y-m-d h:i:s');	
$fdetails['chq_cancelled']='N';	
$fdetails['is_deleted']='N';	
	  $DB1->insert('fees_details',$fdetails);
		echo $DB1->last_query();
}

function check_fee_records($stdid,$type)
{
	     $DB1 = $this->load->database('umsdb', TRUE);
	
	$DB1->select("student_id");
		$DB1->from('fees_details');
	//	$DB1->where("payment_status",'success'); 
		$DB1->where("student_id",$stdid);
		$DB1->where("type_id",$type); 
		//	$DB1->where("fd.type_id",2);
		$DB1->where("chq_cancelled",'N');
				
		$query=$DB1->get();
	
//echo $DB1->last_query();
		$result=$query->row_array();	
	
	
	return $result;
	
	
	
	
	     
}


	function fetch_feedet()
	{
	     $DB1 = $this->load->database('umsdb', TRUE);
	     if($_POST['ftype']=='Admission')
	     {
	         
	         $stddet = $this->fetch_studentdata($_SESSION['name']);
	           $fed = $this->check_fee_records($stddet['stud_id'],2);
	         
	          $DB1 = $this->load->database('umsdb', TRUE);
	   		$DB1->select("ad.actual_fee,sum(fd.amount) as famount");
		$DB1->from('admission_details ad');
	//	$DB1->where("payment_status",'success'); 
	$DB1->join('student_master as sm','ad.student_id = sm.stud_id','left');
     	$DB1->join('fees_details as fd','ad.student_id = fd.student_id','left');
		$DB1->where("sm.enrollment_no",$_SESSION['name']);
			$DB1->where("ad.academic_year",$_POST['year']); 
			if($fed['student_id']!='')
			{
		$DB1->where("fd.type_id",2);
		$DB1->where("fd.chq_cancelled",'N');
			}
				
		$query=$DB1->get();
	
//echo $DB1->last_query();
		$result=$query->row_array();
		
			$pamt = $result['actual_fee']-$result['famount'];
	echo '<table border="1" ><tr style="background:#3175af"><th><label class="">Total fees </label></th><th><label class="">Paid fees </label></th><th><label class="">Pending fees </label></th></tr><tr style="color:#000000"><td><b><label class="">'.$result['actual_fee'].'</label></td><td><label class="">'.$result['famount'].'</label>
     </td><td><label class="">'.$pamt.'</label></b></td></tr></table>';
	     }
	    
	}

function fetch_studentdata()
{
      $DB1 = $this->load->database('umsdb', TRUE);
    //	$DB1->select("concat(first_name,' ',middle_name,' ',last_name) as sname,email");
	//	$DB1->from("student_master");
	//	$DB1->where("enrollment_no",$_SESSION['name']);	 
		
		   $sql = "select concat(first_name,' ',middle_name,' ',last_name) as sname,email,mobile,enrollment_no,stud_id from student_master where enrollment_no='".$_SESSION['name']."'";
	   $query = $DB1->query($sql);

//echo "select concat(first_name,' ',middle_name,' ',last_name) as sname,email from student_master where enrollment_no='".$_SESSION['name']."'";
		$result=$query->row_array();
	//	var_dump($result);
	//	exit(0);
		return $result;
}

function add_online_feedetails($data)
{
    //echo $data['hash'];
   // var_dump($data);
    //exit();
      $DB1 = $this->load->database('umsdb', TRUE);
     	$DB1->select("*");
		$DB1->from('online_payment');
		$DB1->where("receipt_no",$data['udf1']);	  
					
		$query=$DB1->get();
	
//echo $DB1->last_query();
		$result=$query->row_array();
		if($result['receipt_no']!='')
    {
    }
    else
    {
   $fdet['txtid']=$data['txnid'];
     $fdet['receipt_no']=$data['udf1'];
      $fdet['registration_no']=$data['udf3'];
     $fdet['firstname']=$data['firstname'];
     $fdet['email']=$data['email'];
     $fdet['phone']=$data['udf4'];
     $fdet['productinfo']=$data['productinfo'];
     $fdet['amount']=$data['amount'];
     $fdet['payment_date']=$data['addedon'];
         $fdet['payment_status']=$data['status'];
     $fdet['error_code']=$data['error'];
     $fdet['pg_type']=$data['PG_TYPE'];
     $fdet['payment_mode']=$data['mode'];
     $fdet['bank_ref_num']=$data['bank_ref_num'];
     $fdet['error_message']=$data['error_Message'];
     $fdet['academic_year']=$data['udf2'];
     $fdet['user_type']=$data['udf5'];
   
       $DB1->insert('online_payment',$fdet);
    }
     //  echo $DB1->last_query();
    //   echo 'Y';
/*    
    $values="('".$txnid."','".$receipt."','".$formno."','".$_POST['firstname']."','".$_POST['email']."','".$_POST['phone']."','".$_POST['productinfo']."','".$_POST['amount']."','".$_POST['addedon']."','".$_POST['status']."','".$_POST['error']."'
,'".$_POST['PG_TYPE']."','".$_POST['mode']."','".$_POST['bank_ref_num']."','".$_POST['error_Message']."')";
	$gh=$conn->prepare("insert into online_payment (txtid,receipt_no,registration_no,firstname,email,phone,productinfo,amount,payment_date,payment_status,error_code,pg_type,payment_mode,bank_ref_num,error_message) values ".$values);

*/
    
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function Get_hostel_pending(){

$sql = "SELECT 
SUM(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees-f.excemption_fees) AS appl, COALESCE(a.fees_paid,0) AS fees_paid, SUM(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees-f.excemption_fees)-
COALESCE(a.fees_paid,0) AS pending_fees
FROM sandipun_erp.sf_student_facilities f 

LEFT JOIN (SELECT enrollment_no,student_id,academic_year,SUM( amount ) AS fees_paid,SUM(exam_fee_fine) AS fine,college_receiptno,type_id
 FROM sandipun_erp.sf_fees_details 
WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='1' AND enrollment_no ='".$_SESSION['name']."' GROUP BY enrollment_no) a 
ON a.enrollment_no=f.enrollment_no AND a.student_id=f.student_id 

INNER JOIN sandipun_ums.student_master s ON (s.enrollment_no=f.enrollment_no OR s.enrollment_no_new=f.enrollment_no) AND s.stud_id=f.student_id 

WHERE f.sffm_id=1 AND f.status='Y' AND f.cancelled_facility='N'  AND f.enrollment_no ='".$_SESSION['name']."'
GROUP BY f.enrollment_no";

$query = $DB1->query($sql);

//echo "select concat(first_name,' ',middle_name,' ',last_name) as sname,email from student_master where enrollment_no='".$_SESSION['name']."'";
		$result=$query->row_array();
	//	var_dump($result);
	//	exit(0);
		return $result;
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



}