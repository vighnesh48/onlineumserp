<?php
class Phd_model extends CI_Model 
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


function phd_results($exam,$regno=''){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("er.*,ee.marks_obtained,ee.marks_outoff");
		$DB1->from('entrance_exam_result ee');
		$DB1->join('entrance_exam_registration er','er.reg_no=ee.reg_no','left');
		
	//	$DB1->from('entrance_exam_registration er');
	//	$DB1->join('entrance_exam_result ee','er.reg_no=ee.reg_no','left');
		$DB1->where("er.exam_session",$exam);	  
if($regno!='')
{
 	$DB1->where("er.reg_no",$regno);	   
}
	
		$DB1->order_by("er.reg_no");
		$query=$DB1->get();
		$result=$query->result_array();
		return $result;
	}

public function appli_details($appid)
{
   	    $DB1 = $this->load->database('suadmin', TRUE);
		$DB1->select("*");
		$DB1->from('phd_student_details');

		$DB1->where("phd_id",$appid);
		$query=$DB1->get();
		$result=$query->row_array();
		return $result; 
    
    
}
 public function set_is_mailsend_status($appid)
{
   	    $DB1 = $this->load->database('suadmin', TRUE);
		$DB1->where("phd_id",$appid);
		$query=$DB1->update("phd_student_details", array('is_mailsend' => 'Y'));
		return $query;    
}
    public function generate_phd_reg()
    {
         $DB1 = $this->load->database('suadmin', TRUE);
         
         $stud  = $this->Phd_model->appli_details_all();
         foreach($stud as $stud)
       {
            $deptc = "SELECT serial_no from phd_departments where dept_name ='".$stud['department']."'";

                $query2 = $DB1->query($deptc);
       $deptdet =  $query2->row_array();
       
       
           
           
        //$sql = "SELECT max(phd_reg_no) as regno from phd_student_details where department ='".$stud['department']."' and fees_paid = 'Y'";
$sql = "SELECT max(phd_reg_no_demo) as regno from phd_student_details where department ='".$stud['department']."' and fees_paid = 'Y'";

                $query = $DB1->query($sql);
       $pnr_details =  $query->result_array();
       
            if($stud['admission_category']=="FT")
     {
     $cat =1;
     }
   if($stud['admission_category']=="PT")
     {
       $cat =2;    
     }
     
     
     
        // $acyear =  substr($academic_year,-2);
    if($pnr_details[0]['regno']!='')
    {
        $var = substr($pnr_details[0]['regno'], -3);

$var = ++$var;

$prn =  sprintf("%03d", $var);

$prn1 =  $deptdet['serial_no']."".$prn;

$finalprn = "19".$cat."8".$deptdet['serial_no']."".$prn;
//$finalprn = "16".$stream_details[0]['programme_code']."001"; 
    }
    else
    {
        $prn1 =  $deptdet['serial_no']."001";
    //$finalprn = "16".$stream_details[0]['programme_code']."001";     
   $finalprn = "19".$cat."8".$deptdet['serial_no']."001";     
    }
    
     $prdet['phd_reg_no_demo']=$prn1;
      $prdet['phd_reg_no']=$finalprn;

  $DB1->where('phd_id',$stud['phd_id']);

		 $DB1->update('phd_student_details',$prdet);    
    echo $DB1->last_query();
    
        
       }
        
    }

      public function generatesingle_phd_reg($phdid='')
    {
         $DB1 = $this->load->database('suadmin', TRUE);
         
         $stud  = $this->Phd_model->appli_details_single($phdid);
         foreach($stud as $stud)
       {
            $deptc = "SELECT serial_no from phd_departments where dept_name ='".$stud['department']."'";

                $query2 = $DB1->query($deptc);
       $deptdet =  $query2->row_array();
       
       
           
           
        //$sql = "SELECT max(phd_reg_no) as regno from phd_student_details where department ='".$stud['department']."' and fees_paid = 'Y'";
$sql = "SELECT max(phd_reg_no_demo) as regno from phd_student_details where department ='".$stud['department']."' and fees_paid = 'Y'";

                $query = $DB1->query($sql);
       $pnr_details =  $query->result_array();
       
            if($stud['admission_category']=="FT")
     {
     $cat =1;
     }
   if($stud['admission_category']=="PT")
     {
       $cat =2;    
     }
     
     
     
        // $acyear =  substr($academic_year,-2);
    if($pnr_details[0]['regno']!='')
    {
        $var = substr($pnr_details[0]['regno'], -3);

$var = ++$var;

$prn =  sprintf("%03d", $var);

$prn1 =  $deptdet['serial_no']."".$prn;

$finalprn = "23".$cat."8".$deptdet['serial_no']."".$prn;
//$finalprn = "16".$stream_details[0]['programme_code']."001"; 
    }
    else
    {
        $prn1 =  $deptdet['serial_no']."001";
    //$finalprn = "16".$stream_details[0]['programme_code']."001";     
   $finalprn = "22".$cat."8".$deptdet['serial_no']."001";     
    }
    
     $prdet['phd_reg_no_demo']=$prn1;
      $prdet['phd_reg_no']=$finalprn;

  $DB1->where('phd_id',$stud['phd_id']);

		 $DB1->update('phd_student_details',$prdet);    
    //echo $DB1->last_query();
    
        
       }
        
    }

public function appli_details_one($dept='')
{
   	    $DB1 = $this->load->database('suadmin', TRUE);
		$DB1->select("*");
		$DB1->from('phd_student_details');
if($dept!='')
{
   	$DB1->where("department",$dept); 
}
		$DB1->where("phd_id","363");
			$DB1->order_by("phd_id");
		$query=$DB1->get();
		$result=$query->result_array();
		return $result; 
    
    
}


public function appli_details_all($dept='')
{
   	    $DB1 = $this->load->database('suadmin', TRUE);
		$adm_batch=PHD_ADMISSION_BATCH;

		$DB1->select("*");
		$DB1->from('phd_student_details');
		if($dept!='')
		{
		   	$DB1->where("department",$dept); 
		}
		//$DB1->where("fees_paid","Y");
		//$DB1->where("phd_id >","1044");
		//$DB1->where("academic_year",'2024');
  	    $DB1->where("verification",'V');
  	    //$DB1->where("campus",'sum');
		#$DB1->where("DATE(entry_on) >= '2024-01-11'");
		#$DB1->where("DATE(entry_on) LIKE '%2020%'");
		$DB1->where("admission_batch",$adm_batch);
		$DB1->group_by("mobile_no");
		$DB1->order_by("phd_id");
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result; 
    
    
}

public function appli_details_single($phdid='')
{
   	    $DB1 = $this->load->database('suadmin', TRUE);
		$DB1->select("*");
		$DB1->from('phd_student_details');
		/*if($dept!='')
		{
		   	$DB1->where("department",$dept); 
		}*/
		$DB1->where("fees_paid","Y");
		$DB1->where("phd_id",$phdid);
		//$DB1->order_by("phd_id");
		$query=$DB1->get();
		$result=$query->result_array();
		return $result; 
    
    
}



public function phd_listing()
{
   	    $DB1 = $this->load->database('suadmin', TRUE);
		$username = $this->session->userdata('name');
		$cp =explode('_',$username);
		 //print_r($cp);exit;
		$campus=ucwords($cp[1]);
		
		$adm_batch=PHD_ADMISSION_BATCH;
		$DB1->select("psd.*,op.amount,verification_status,payment_id,op.payment_status,sm.entrance_marks,sm.interview_marks,sm.final_marks,sm.id as pid");
			$DB1->from('phd_student_details psd');
		$DB1->join('online_payment op','op.registration_no = psd.phd_id','left');
		$DB1->join('sunpet_marks_entry sm','sm.phd_id = psd.phd_id and sm.academic_year = psd.academic_year','left');
	//	$DB1->from('phd_student_details psd');
	//	$DB1->join('online_payment op','op.registration_no = psd.phd_id','left');
  	$DB1->where("psd.admission_batch",$adm_batch);
  	$DB1->where("psd.fees_paid",'Y');
	
	if($campus!=''){
		$DB1->where("campus", $campus);	
		}
	//$DB1->where("psd.define('ADMISSION_BATCH', 'JULY-24');",'V');
  	//$DB1->where("psd.ADMISSION_BATCH",'2023');
	//	$DB1->where("op.payment_status",$_POST['pstatus']);
if($_POST['dept']!='')
{
    	$DB1->where("psd.department",$_POST['dept']);
}
if($_POST['yearsession']!='' && ($_POST['yearsession']=='JULY-2020'))
{


    	$DB1->where("DATE(psd.entry_on) >= '2020-08-01' and DATE(psd.entry_on) <= '2020-09-30'");
}
if($_POST['yearsession']!='' && ($_POST['yearsession']=='JULY-2019'))
{


    	$DB1->where("DATE(psd.entry_on) >= '2019-07-01' and DATE(psd.entry_on) <= '2019-08-30'");
}
if($_POST['yearsession']!='' && ($_POST['yearsession']=='FEB-2019'))
{


    	$DB1->where("DATE(psd.entry_on) >= '2019-01-20' and DATE(psd.entry_on) < '2019-03-30'");
}

if($_POST['pstatus']!='')
{
    if($_POST['pstatus']=="success")
    {
     $DB1->where("op.payment_status",$_POST['pstatus']);    
    }
    else
    {
        $DB1->where("op.payment_status is NULL");
    }	
}
		$DB1->order_by("payment_id", "desc");
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result; 
    
    
}
public function update_payment_status()
{
     $DB1 = $this->load->database('suadmin', TRUE);
    $prdet['verification_status']=$_POST['upstatus'];
   $prdet['modified_by']=$_SESSION['uid'];
     $prdet['modified_on']=date('Y-m-d h:i:s');
  $prdet['modify_from_ip']=$_SERVER['REMOTE_ADDR'];

  $DB1->where('payment_id',$_POST['fees_id']);

		 $DB1->update('online_payment',$prdet);    
  
    redirect('phd/');  
}


public function update_verification_status()
{
     $DB1 = $this->load->database('suadmin', TRUE);
    $prdet['verification']=$_POST['upstatus'];


  $DB1->where('phd_id',$_POST['reg_id']);

	$DB1->update('phd_student_details',$prdet); 
	$this->generatesingle_phd_reg($_POST['reg_id']);  
  
     
}




public function phd_cand_photo($pid)
	{
	    
	       $DB1 = $this->load->database('suadmin', TRUE);
 $DB1->select("*");
   $DB1->from("phd_documents");  
      $DB1->where("phd_id",$pid);  
   $DB1->where("doc_id",8);  
  		
$query = $DB1->get();

 
return $query->row_array();	    
	}	

public function documents($appid)
{
   	    $DB1 = $this->load->database('suadmin', TRUE);
		$DB1->select("pd.*,pdm.doc_name");
		$DB1->from('phd_documents pd');
			$DB1->join('phd_document_master pdm','pd.doc_id= pdm.doc_id','left');
		$DB1->where("phd_id",$appid);
		$query=$DB1->get();
		$result=$query->result_array();
		return $result; 
    
    
}



public function department()
{
   	    $DB1 = $this->load->database('suadmin', TRUE);
		$DB1->select("*");
		$DB1->from('phd_departments');

		$DB1->where("dept_status","Y");
		$query=$DB1->get();
		$result=$query->result_array();
		return $result; 
    
    
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
////////// below code is added by ranjan


	function getphdstdonlineFeesdata($payid='')
	{
		$DB1 = $this->load->database('suadmin', TRUE);
		$DB1->select("p.*,fd.college_receiptno");
		$DB1->from('phd_student_details as s');
		$DB1->join('online_payment as p','s.phd_id = p.registration_no');
		$DB1->join('sandipun_ums.fees_details as fd','fd.receipt_no = p.bank_ref_num AND fd.chq_cancelled="N" AND fd.is_deleted="N"' ,'left');
		$DB1->where("p.payment_status",'success');	  
		if($payid!='')
		{
		$DB1->where("p.payment_id",$payid);	    
		}
		if($_POST['pdate']!='')
		{
		$DB1->where("DATE(payment_date)",$_POST['pdate']);	    
		}
		
		
		
		if($_POST['pstatus']=='V'){
			$w="`fd`.`college_receiptno`!=''";
			$DB1->where($w);		
		}else{
			$w="`fd`.`college_receiptno` is null";
			$DB1->where($w);
		}
			
		//$DB1->where("p.verification_status","P");	 
		//$DB1->where("p.is_deleted","N");	   
		$DB1->order_by("DATE(p.payment_date)", "DESC");
		$query=$DB1->get();
		//echo $DB1->last_query();exit();
		$result=$query->result_array();
		return $result;
	}
	
	function update_phdfeestatus()
	{
		$DB1 = $this->load->database('suadmin', TRUE);
		
		date_default_timezone_set("Asia/Kolkata");
		$pdata['modified_by'] = $_SESSION['uid'];
		$pdata['modified_on'] = date('Y-m-d h:i:s');
		$pdata['verification_status'] = 'V';
		$pdata['modify_from_ip'] = $_SERVER['REMOTE_ADDR'];
		$DB1->where('payment_id', $_POST['fid']);       
		$DB1->update('online_payment', $pdata);
	}
	function camulative_report()
	{
		$DB1 = $this->load->database('suadmin', TRUE);
		$sql ="SELECT `psd`.department, COUNT(*) AS dept_stud_cnt FROM `online_payment` `op` 
RIGHT JOIN `phd_student_details` `psd` ON `op`.`registration_no` = `psd`.`phd_id` WHERE `op`.`payment_status`='success' 
GROUP BY `psd`.department";
		 $query = $DB1->query($sql);
       //echo $DB1->last_query();exit;
        return $query->result_array();
	}
	
	
	
	public function get_details($recepit){
		$DB=$this->load->database('suadmin',true);
		$sql="select s.*,op.* from online_payment as op 
		LEFT JOIN phd_student_details as s ON  s.mobile_no=op.phone AND verification='V'
		where op.payment_id='$recepit'";
		//LEFT JOIN phd_student_details as s ON s.enquiry_id=op.student_id AND s.mobile=op.phone
		//LEFT JOIN `vw_stream_details` AS vw ON vw.stream_id=s.stream_id
		$query=$DB->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
	public function insert_sunpet_marks($val)
	 {
		 $DB1 = $this->load->database('suadmin', TRUE);
		  $DB1->select('*');
		  $DB1->from('sunpet_marks_entry');
		  $DB1->where('phd_id',$val['phd_id']);	
		  $DB1->where('academic_year',$val['academic_year']);
		  $query=$DB1->get();
		  $lentry=$query->result_array();

		   if(!empty($lentry)){
		  $val['updated_on']=date('Y-m-d H:m:s');
		  $DB1->where('phd_id',$val['phd_id']);
		  $DB1->where('academic_year',$val['academic_year']);
		  $DB1->update('sunpet_marks_entry',$val);
		  $result=0;
		 }else
		 {
		   $val['created_on']=date('Y-m-d H:m:s');
		   $DB1->insert('sunpet_marks_entry',$val);		 
		   $result=$DB1->insert_id();		 
		  }	
		  
		 return $result;
	 }
	public function fetch_sunpet_marks_entry($phd_id,$acad_year)
	{
		 $DB1 = $this->load->database('suadmin', TRUE);
		 $DB1->select('*');		 
		 $DB1->from('sunpet_marks_entry');		 
		 $DB1->where('academic_year',$acad_year);		 
		 $DB1->where('phd_id',$phd_id);		 
		 $query=$DB1->get(); 
		 //echo $DB1->last_query();exit;
		 return $query->result_array();
	}
	
	public function sunpet_phd_results($phd_id,$acad_year)
	{
		 $DB1 = $this->load->database('suadmin', TRUE);
		 $DB1->select('ps.*');		 
		 $DB1->select('sm.*');		 
		 $DB1->from('phd_student_details ps');		 
		 $DB1->join('sunpet_marks_entry sm','sm.phd_id=ps.phd_id');		 
		 $DB1->where('sm.academic_year',$acad_year);		 
		 $DB1->where('sm.phd_id',$phd_id);		 
		 $query=$DB1->get(); 
		 return $query->result_array();
	 }
	
	
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
}