<?php
class Online_feemodel extends CI_Model 
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
		//$DB1->select("*");
		//$DB1->from('online_payment');
		//$DB1->where("payment_status",'success');	
		$where='';  
	if($payid!='')
	{
		$where="AND payment_id='$payid'";
	  //	$DB1->where("payment_id",$payid);	    
	}
	//	$DB1->where("verification_status","N");	 
		//$DB1->where("is_deleted","N");	   
	
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		//	$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		
		//	$DB1->where("sm.admission_stream",$streamid);	    
		
		//	$DB1->where("sm.admission_year", $year);	   	    
	
		//$DB1->order_by("payment_id", "desc");
		//$query=$DB1->get();
		/*  echo $this->db->last_query();
		die();  */ 
		
		$sql="SELECT fd.`fees_id`,fd.`college_receiptno`,op.*
FROM `online_payment` AS op
LEFT JOIN fees_details AS fd ON fd.`receipt_no`=op.`bank_ref_num` AND  fd.chq_cancelled='N' AND fd.is_deleted='N'
WHERE op.`payment_status` = 'success' AND op.`verification_status` = 'N' AND op.`is_deleted` = 'N' 
ORDER BY op.`payment_id` DESC";
$query=$DB1->query($sql);

		$result=$query->result_array();
		 echo $DB1->last_query();
	//	 exit(0);
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}

function pay_session($name){ $DB1 = $this->load->database('umsdb', TRUE);
if(empty($name)){
	 $name=$_SESSION['name'];
}
	  $sql_check="select admission_cycle,stud_id FROM student_master where `enrollment_no` = '$name' ";
     $query_check=$DB1->query($sql_check);
		//echo $DB1->last_query();
		$result_check=$query_check->result_array();
 return $admission_cycle=$result_check[0]['admission_cycle'];//echo '<br>';
}
function student_payment_history($name=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		//$DB1->select("*");
		//$DB1->from('online_payment');
		//$DB1->where("registration_no",$_SESSION['name']);	  
	
		//$DB1->where("user_type","R");
//		$DB1->where("verification_status","Y");
		//$DB1->where("payment_status","success");
		
	//	$DB1->where("is_deleted","N");	   
 	   // print_r($_SESSION);
	   if($name==''){
		$name=$_SESSION['name'];
	   }else{
		  $name=$name; 
	   }
		//$DB1->order_by("payment_id", "desc");
		/*$sql="SELECT fd.`fees_id`,fd.`college_receiptno`, op.*
FROM `online_payment` as op
LEFT JOIN fees_details AS fd ON fd.`receipt_no`=op.`bank_ref_num`
WHERE op.`registration_no` = '$name'
AND op.`user_type` = 'R'
AND op.`payment_status` = 'success'
ORDER BY op.`payment_id` DESC
";*/
//exit();
$sql_check="select admission_cycle,stud_id FROM student_master where `enrollment_no` = '$name' ";
$query_check=$DB1->query($sql_check);
		//echo $DB1->last_query();
		$result_check=$query_check->result_array();
 $admission_cycle=$result_check[0]['admission_cycle'];//echo '<br>';
 $stud_id=$result_check[0]['stud_id'];//echo '<br>';
//exit();
if(empty($admission_cycle)){
$sql="SELECT fd.*,op.txtid,op.registration_no,op.productinfo,op.bank_ref_num,
op.payment_status,op.`verification_status`,op.amount AS payamount,fc.fees_id as challan_id
FROM `fees_details` AS fd
LEFT JOIN `fees_challan` AS fc on fd.student_id=fc.student_id and fd.college_receiptno=fc.exam_session
LEFT JOIN online_payment AS op ON fd.`receipt_no`=op.`bank_ref_num` AND op.`bank_ref_num`!=''
WHERE fd.`student_id` = '$stud_id' and fd.chq_cancelled='N' 
ORDER BY fd.`fees_id` DESC";
}else{
	$sql="SELECT fd.*,op.txtid,op.registration_no,op.productinfo,op.bank_ref_num,
op.payment_status,op.`verification_status`,op.amount AS payamount,fc.fees_id as challan_id
FROM `fees_details` AS fd
LEFT JOIN `fees_challan_phd` AS fc on fd.student_id=fc.student_id and fd.college_receiptno=fc.exam_session
LEFT JOIN online_payment AS op ON fd.`receipt_no`=op.`bank_ref_num` AND op.`bank_ref_num`!=''
WHERE fd.`student_id` = '$stud_id' and fd.chq_cancelled='N'
ORDER BY fd.`fees_id` DESC";
}

		$query=$DB1->query($sql);
		//echo $DB1->last_query(); exit();
		$result=$query->result_array();
		return $result;
	}



function getFeesajax(){
		 $DB1 = $this->load->database('umsdb', TRUE);
		//$DB1->select("*");
		//$DB1->from('online_payment');
		//$DB1->where("payment_status",'success');
		$where= " WHERE op.payment_status='success' AND op.is_deleted='N'";
		if($_POST['pstatus']!='')
		{
		//$where.=" AND op.verification_status='".$_POST['pstatus']."'";	
	//	$DB1->where("is_deleted",'N');	
		}
		if($_POST['pdate']!='')
		{
		$where.=" AND DATE(op.payment_date)='".$_POST['pdate']."'";    
		}
		
	    	
		$sql="SELECT fd.`fees_id`,fd.`college_receiptno`,op.*
FROM `online_payment` AS op
LEFT JOIN fees_details AS fd ON fd.`receipt_no`=op.`bank_ref_num`
$where
ORDER BY op.`payment_id` DESC";
		
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		//	$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		
		//	$DB1->where("sm.admission_stream",$streamid);	    
		
		//	$DB1->where("sm.admission_year", $year);	   	    
	
		//$DB1->order_by("payment_id", "desc");
		$query=$DB1->query($sql);
		 // echo $DB1->last_query();
		 // die();  
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
		 $stddet = $this->fetch_studentdata($_SESSION['name']);
		$Payment_type= $_POST['Payment_type'];
		$course_id= $_POST['course_id'];

		$array = array(				
				'Payment_type'=> $Payment_type,
				'ftype'=>$_POST['ftype'],
				'pstud_id'=>$stddet['stud_id'],
				'penrollment_no'=>$stddet['enrollment_no']
				);
				
		$this->session->set_userdata($array);
		
			if($Payment_type=='3322' && $course_id==2){
				$pamt =16500;
				echo $result['applicable_fee']+$result['canc_amount'].'~~'.$result['famount'].'~~'.$pamt.'~~'.$pamt;
							$this->session->set_userdata('amount',$pamt);
							exit;
			}else if($Payment_type=='332' && ($course_id==11)){
				$pamt =6500;
				echo $result['applicable_fee']+$result['canc_amount'].'~~'.$result['famount'].'~~'.$pamt.'~~'.$pamt;
							$this->session->set_userdata('amount',$pamt);
							exit;
			}else if($Payment_type=='323' && ($course_id==4 || $course_id==9)){
				$pamt =1500;
				echo $result['applicable_fee']+$result['canc_amount'].'~~'.$result['famount'].'~~'.$pamt.'~~'.$pamt;
				$this->session->set_userdata('amount',$pamt);
				exit;
			}
	   if($_POST['ftype']=='Duplicate_hallticket'){
		    echo $pamt =300;
				//echo $result['applicable_fee']+$result['canc_amount'].'~~'.$result['famount'].'~~'.$pamt.'~~'.$pamt;
				$this->session->set_userdata('amount',$pamt);
	   }elseif($_POST['ftype']=='Admission'){
	         
	           $stddet = $this->fetch_studentdata($_SESSION['name']);
	           $fed = $this->check_fee_records($stddet['stud_id'],2);
	           $year=$_POST['year'];
			   
			   
	          $DB1 = $this->load->database('umsdb', TRUE);
	   		  $DB1->select("ad.actual_fee,ad.applicable_fee,ad.opening_balance,mm.fmo as famount,mmm.canc_amount,m.refund_amount");
		      $DB1->from('admission_details ad');
	//	$DB1->where("payment_status",'success'); 
	          $DB1->join('student_master as sm','ad.student_id = sm.stud_id','left');
     	     // $DB1->join('fees_details as fd','ad.student_id = fd.student_id','left');
			  // if($stddet['stud_id']=="4989"){
			 $DB1->join("(SELECT SUM(amount) AS fmo, sum(canc_charges) as canc_amount,student_id FROM fees_details WHERE student_id='".$stddet['stud_id']."'
 AND `academic_year` = '". $year."' AND type_id='2' AND chq_cancelled='N')  AS mm",' `mm`.`student_id` = `sm`.`stud_id`','left');
 
 $DB1->join("(SELECT sum(canc_charges) as canc_amount,student_id FROM fees_details WHERE student_id='".$stddet['stud_id']."'
 AND `academic_year` = '". $year."' AND type_id='2' AND is_deleted='N')  AS mmm",' `mmm`.`student_id` = `sm`.`stud_id`','left');

			  $DB1->join("(SELECT SUM(amount) AS refund_amount,student_id FROM fees_refunds WHERE student_id='".$stddet['stud_id']."' AND `academic_year` = '". $year."'  AND `is_deleted` = 'N') AS m" ,'`m`.`student_id` = `sm`.`stud_id`','left');
			//  }
			
		    $DB1->where("sm.stud_id",$stddet['stud_id']);
			$DB1->where("ad.academic_year",$_POST['year']); 
			//$DB1->where("fd.student_id ",$stddet['stud_id']);
			//$DB1->where("fd.academic_year",$_POST['year']);
	 		
	
	      if($fed['student_id']!=''){
		 // $DB1->where("fd.type_id",2);
		 // $DB1->where("fd.chq_cancelled",'N');
			}
				
		$query=$DB1->get();
	
//echo $DB1->last_query();
		$result=$query->row_array();
		
			//$pamt = $result['actual_fee']-$result['famount'];
			$pamt = ($result['applicable_fee']+$result['canc_amount']+$result['opening_balance'])-$result['famount']+ $result['refund_amount'];
			
			 if($stddet['stud_id']=="6910"){
				  $DB1->last_query();
			//	 $pamt = ($result['applicable_fee']+$result['opening_balance'])-$result['famount']+ $result['refund_amount'];
			// $pamt =$pamt + $result['refund_amount'];
			 }
			 
	 '<table border="1" ><tr style="background:#3175af"><th><label class="">Total fees </label></th><th><label class="">Paid fees </label></th><th><label class="">Pending fees </label></th></tr><tr style="color:#000000"><td><b><label class="">'.$result['applicable_fee'].'</label></td><td><label class="">'.$result['famount'].'</label>
     </td><td><label class="">'.$pamt.'</label></b></td></tr></table>';
	    
		$C_RE_REG_YEAR =C_RE_REG_YEAR;
		
		if($year==$C_RE_REG_YEAR){
			      $Payment_type= $_POST['Payment_type'];
		        
				if($Payment_type==1){
					//$new=($result['famount']*35)/100;
					//$new=($pamt*35)/100;
					if($stddet['stud_id']=="3040"){
						//echo  $result['applicable_fee'].'--'.$result['canc_amount'].'~~'.$result['famount'];exit;
					}
					//$new=(($result['applicable_fee']+$result['canc_amount']+$result['opening_balance'])*70)/100;
					//$new=$new-$result['famount'];
					
					//if($stddet['stud_id']=="6560"){
						$arr_oms=array('25SUN0889','25SUN1541','25SUN1660','25SUN1681','25SUN2090','25SUN2362','25SUN2889','25SUN3024','25SUN3032','25SUN3037','25SUN3097','25SUN3099','25SUN3451','25SUN3696','25SUN3708','25SUN3750','25SUN0590','25SUN0587','25SUN0893','25SUN0401','25SUN01303','25SUN0397','25SUN1201','25SUN1044','25SUN1322','25SUN1418','25SUN1513','25SUN3707','25SUN4013');
						if(in_array($stddet['enrollment_no'],$arr_oms)){
							$fees_per=50;
						}else{
							$fees_per=50;
						}
					
					if(!empty($result['opening_balance'])){
						$paidoping=$result['opening_balance'] - $result['famount']; 
						$new=($result['applicable_fee'])*$fees_per/100 + $paidoping;
						$curr=($result['applicable_fee'])*$fees_per/100;
						if($result['famount']>$curr){
							//$new=0;
						}
					}else{
					$new=(($result['applicable_fee']+$result['canc_amount']+$result['opening_balance'])*$fees_per)/100;
					
					//$curr=($result['applicable_fee'])*35/100;
					if($result['famount']>$new){
						//$new=0;
					}else{
					
					$new=$new-$result['famount'];	
					}
					}
					
					
					
					echo $result['applicable_fee']+$result['canc_amount']+$result['opening_balance'].'~~'.$result['famount'].'~~'.$pamt.'~~'.$new;
					$this->session->set_userdata('amount',round($new));
					
					 }elseif($Payment_type==3){
					//$new=($result['famount']*35)/100;
					//$new=($pamt*35)/100;
					if($stddet['stud_id']=="3040"){
						//echo  $result['applicable_fee'].'--'.$result['canc_amount'].'~~'.$result['famount'];exit;
					}
					//$new=(($result['applicable_fee']+$result['canc_amount']+$result['opening_balance'])*70)/100;
					//$new=$new-$result['famount'];
					
					//if($stddet['stud_id']=="6560"){
					
					if(!empty($result['opening_balance'])){
					$paidoping=$result['opening_balance'] - $result['famount']; 
					$new=($result['applicable_fee'])*70/100 + $paidoping;
					}else{
					$new=(($result['applicable_fee']+$result['canc_amount']+$result['opening_balance'])*70)/100;
					$new=$new-$result['famount'];	
					}
					
					//}
					
					//$new=(($result['applicable_fee']+$result['canc_amount']+$result['opening_balance'])*70)/100;
					//$new=$new-$result['famount'];
					
					
					/*if($stddet['admission_session']==2020){						
					$new=$result['applicable_fee']+$result['canc_amount'];//-$result['famount'];
					$new=($new*70)/100;
					$new=$new-$result['famount'];
					}*/
					
					 echo $result['applicable_fee']+$result['canc_amount']+$result['opening_balance'].'~~'.$result['famount'].'~~'.$pamt.'~~'.$new;
					 
					 $this->session->set_userdata('amount',round($new));
					 }elseif($Payment_type==4){
					//$new=($result['famount']*35)/100;
					//$new=($pamt*35)/100;
					if($stddet['stud_id']=="3040"){
						//echo  $result['applicable_fee'].'--'.$result['canc_amount'].'~~'.$result['famount'];exit;
					}
					//$new=(($result['applicable_fee']+$result['canc_amount']+$result['opening_balance'])*70)/100;
					//$new=$new-$result['famount'];
					
					//if($stddet['stud_id']=="6560"){
					
					if(!empty($result['opening_balance'])){
					$paidoping=$result['opening_balance'] - $result['famount']; 
					$new=($result['applicable_fee'])*58/100 + $paidoping;
					}else{
					$new=(($result['applicable_fee']+$result['canc_amount']+$result['opening_balance'])*58)/100;
					$new=$new-$result['famount'];	
					}
					
					//}
					
					//$new=(($result['applicable_fee']+$result['canc_amount']+$result['opening_balance'])*70)/100;
					//$new=$new-$result['famount'];
					
					
					/*if($stddet['admission_session']==2020){						
					$new=$result['applicable_fee']+$result['canc_amount'];//-$result['famount'];
					$new=($new*70)/100;
					$new=$new-$result['famount'];
					}*/
					
					echo $result['applicable_fee']+$result['canc_amount']+$result['opening_balance'].'~~'.$result['famount'].'~~'.$pamt.'~~'.$new;
					$this->session->set_userdata('amount',round($new));
					 }elseif($Payment_type==2){
					echo $result['applicable_fee']+$result['canc_amount']+$result['opening_balance'].'~~'.$result['famount'].'~~'.$pamt.'~~'.$pamt;
					$this->session->set_userdata('amount',round($pamt));
					 }
		}else{
		
		if($stddet['stud_id']=="270"){
			//	  $DB1->last_query();
			//	 $pamt = ($result['applicable_fee']+$result['opening_balance'])-$result['famount']+ $result['refund_amount'];
			// $pamt =$pamt + $result['refund_amount'];
			$famount=$result['famount']-$pamt;
			echo $result['applicable_fee']+$result['canc_amount']+$result['opening_balance'].'~~'.$famount.'~~'.$pamt.'~~'.$pamt;
			 }else{
		if($Payment_type==4){
			//echo 'inside4';exit;
					//$new=($result['famount']*35)/100;
					//$new=($pamt*35)/100;
					if($stddet['stud_id']=="3040"){
						//echo  $result['applicable_fee'].'--'.$result['canc_amount'].'~~'.$result['famount'];exit;
					}
					//$new=(($result['applicable_fee']+$result['canc_amount']+$result['opening_balance'])*70)/100;
					//$new=$new-$result['famount'];
					
					//if($stddet['stud_id']=="6560"){
					
					if(!empty($result['opening_balance'])){
						//echo 'inside43';exit;
					$paidoping=$result['opening_balance'] - $result['famount']; 
					$new=($result['applicable_fee'])*58/100 + $paidoping;
					}else{
					$new=(($result['applicable_fee']+$result['canc_amount']+$result['opening_balance'])*58)/100;
					$new=$new-$result['famount'];	
					}
		echo $result['applicable_fee']+$result['canc_amount']+$result['opening_balance'].'~~'.$result['famount'].'~~'.$new.'~~'.$new;
		$this->session->set_userdata('amount',round($new));
			 }else{
		echo $result['applicable_fee']+$result['canc_amount']+$result['opening_balance'].'~~'.$result['famount'].'~~'.$pamt.'~~'.$pamt;
		$this->session->set_userdata('amount',round($pamt));
			 }
			 }
		}
		
		 }else if($_POST['ftype']=='Re-Registration'){
			 
			 $students_array=array('240105231994','220101091011','220105131168','220105131175','220105131178','220105131179','220105131318','220105231018','220105231019','220105231059','220105231073','220105231101','220105231161','220105231162','230105131226','230105231128','230105231163','230105231168','230105231169','230105231249','230105231283','230105231317','230105231349','230105231383','230105232020','230106271136','240101431018','240104071038','240104071055','240105131423','240105182008','240105231153','240105231202','240105231873','240105231875','240105231917','240105231994','240105232034','240106301019','230105231168','230105231317','230106271136','230105231283','230105231163','230106271136','220105231133','220105231103');
			 
			 $Payment_type= $_POST['Payment_type'];
			 $stddet = $this->fetch_studentdata($_SESSION['name']);
			 $fed = $this->check_fee_records($stddet['stud_id'],2);
			 
			 $DB2 = $this->load->database('umsdb', TRUE);
			 $DB2->select("amount,student_id,registration_no,academic_year,productinfo,payment_status");
			 $DB2->from('online_payment');
			 $DB2->where("academic_year",C_RE_REG_YEAR);
			 $DB2->where("student_id",$stddet['stud_id']);
			 $DB2->where("productinfo",'Re-Registration');
			 $DB2->where("payment_status",'success');
			 $query2=$DB2->get();
			 $result2=$query2->row_array();
			// echo $DB2->last_query();
			 
			 if($stddet['stud_id']=="5441"){
			 //echo $DB2->last_query();
			 }
			  /*if($result2['amount']>5000){
				//  echo "in";
			echo '<b style="color:#000000">Re-Registration Fee already Pay</b>';
			 }else*/{
				// echo "out";
			 //$DB2->where("student_id ",$stddet['stud_id']);
			// $DB2->where("registration_no",$stddet['stud_id']);
			 
			 
			
			  $DB1 = $this->load->database('umsdb', TRUE);
	   		  $DB1->select("ad.actual_fee,ad.applicable_fee,ad.opening_balance,sum(canc_charges) as canc_amount,sum(fd.amount) as famount,m.refund_amount,sm.belongs_to,sm.package_name,sm.enrollment_no,sm.admission_session");
		      $DB1->from('admission_details ad');
	//	$DB1->where("payment_status",'success'); 
	          $DB1->join('student_master as sm','ad.student_id = sm.stud_id','left');
     	      $DB1->join('fees_details as fd','ad.student_id = fd.student_id AND ad.academic_year=fd.academic_year AND type_id="2" AND is_deleted="N" AND chq_cancelled = "N"' ,'left');
			  //$DB1->join('fees_refunds as frf','frf.student_id = fd.student_id','left');
			  //if($stddet['stud_id']=="4989"){
			  $DB1->join("(SELECT SUM(amount) AS refund_amount,student_id FROM fees_refunds WHERE student_id='".$stddet['stud_id']."' AND `academic_year` = '".L_RE_REG_YEAR."'  AND `is_deleted` = 'N') AS m"
,'`m`.`student_id` = `sm`.`stud_id`','left');
				$DB1->join("(SELECT sum(canc_charges) as canc_amount,student_id FROM fees_details WHERE student_id='".$stddet['stud_id']."'
 AND `academic_year` = '".L_RE_REG_YEAR."' AND type_id='2' AND is_deleted='N' AND chq_cancelled = 'N')  AS mmm",' `mmm`.`student_id` = `sm`.`stud_id`','left');
			//  }
		     //$DB1->where("sm.enrollment_no",$_SESSION['name']);
			//$DB1->where("fd.student_id ",$stddet['stud_id']);
			$DB1->where("sm.stud_id",$stddet['stud_id']);
			//$DB1->where("fd.academic_year",L_RE_REG_YEAR);
			$DB1->where("ad.academic_year",L_RE_REG_YEAR); 
			//$DB1->where("frf.academic_year",'2019'); 
			//$DB1->where("frf.is_deleted",'N'); 
			if($fed['student_id']!=''){
		//$DB1->where("fd.type_id",2);
		//$DB1->where("fd.chq_cancelled",'N');
			}
				
		$query=$DB1->get();
		// echo $DB1->last_query();
		 //echo '<br>';
	if($stddet['stud_id']=="4634"){
 //echo $DB1->last_query();
	}
		$result=$query->row_array();
		
			//$pamt = $result['actual_fee']-$result['famount'];
			    $pamtt = ($result['applicable_fee']+$result['canc_amount']+$result['opening_balance'])-$result['famount']+ $result['refund_amount'];//exit;
			 
			 
			    $stream_id= $stddet['admission_stream'];
				$admission_year= $stddet['admission_session'];
				$current_year= $stddet['current_year'];
				$current_year=$current_year + 1;
				
				if($current_year<=2){
					$year=$current_year;
				}else{
					$year=0;
				}
				$year=0;
			    if(empty($stddet['admission_cycle']))
				 {
					 $academic_fees_table="academic_fees";
				 }else{
					 $academic_fees_table="phd_academic_fees";
				 }
				 if($result['belongs_to']=='Package' && $result['package_name']!='Reddy'){
					 
					 $sqlre="SELECT actual_fee as total_fees FROM admission_details WHERE stream_id='$stream_id' AND academic_year='".L_RE_REG_YEAR."' AND student_id='".$stddet['stud_id']."'";
					 
					 
				 }elseif($result['admission_session']=='2024' && $result['package_name']=='Reddy'){
					 $sqlre="SELECT (semwise_fees)/2 as total_fees FROM package_students_fees_details WHERE enrollment_no='".$result['enrollment_no']."' ";
				 }elseif($result['admission_session']!='2024' && $result['package_name']=='Reddy'){
					$sqlre="SELECT (applicable_fee)/4 as total_fees FROM admission_details WHERE stream_id='$stream_id' AND academic_year='".L_RE_REG_YEAR."' AND student_id='".$stddet['stud_id']."'";
				 }else{
					 
					 
					$sqlre="SELECT * FROM ".$academic_fees_table." WHERE stream_id='$stream_id' AND academic_year='".RE_REG_YEAR."' AND admission_year='$admission_year' AND year='$year'";
				 }
				 if($result['enrollment_no']==240106271336){
					// echo $sqlre;exit;
				 }
				 $queryre=$DB1->query($sqlre);
				 $resultre=$queryre->result_array();
				 
				 
				 if(!empty($_POST['stud_id'])){
				 $sqlsch="SELECT * FROM  fees_consession_details WHERE student_id='".$_POST['stud_id']."' AND academic_year='".L_RE_REG_YEAR."' AND duration!='1' ";//and 
//student_id not in ('1922','3128','3156','3178','3182','3189','3207','3209','3210','3227','3243','3282','3313','3316','3347','3349','3373','3374','3375','3380','3381','3393','3401','3500','3556','3638','3655','3675','3715','3737','3787','3802','3804','3817','3864','3867','3897','3898','3923','3940','3946','3980','3985','3987','4018','4046','4132','4166','4181','4192','4195','4205','4234','4274','4299','4304','4317','4379','4389','4457','4500','4526','4532','4534','4544','4589','4615','4617','4631','4652','4685','4945','4951','4963','5040','5061','5087','5090','5091','5132','5178','5338','5340')";
				 $querysch=$DB1->query($sqlsch);
				 $resultsch=$querysch->result_array();
				 
				 if($resultsch[0]['exepmted_fees']){
				 $exepmted_fees=$resultsch[0]['exepmted_fees'];
				 }else{
				 $exepmted_fees=0;
				 }
				 
				  $new_amount=$resultre[0]['total_fees'] - $exepmted_fees;
				  
				  
				  
				 
				  
				  
				  
				  //echo $resultre[0]['total_fees'].'~~'.($resultre[0]['total_fees']/2).'~~'.$result2['amount'];
				//  echo $new_amount.'~~'.$new_amount.'~~'.$pamtt;
				$from_date = '2025-08-31';   // Fine starts from this date
				$fine_per_day = 100;         // Fine amount per day

				// Get today's date
				$today = date('Y-m-d');

				// Calculate difference in days
				$datetime1 = new DateTime($from_date);
				$datetime2 = new DateTime($today);

				$interval = $datetime1->diff($datetime2);
				$days_late = $interval->days;

				// Apply fine only if today is after from_date
				if ($today > $from_date) {
					$fine = $days_late * $fine_per_day;
				} else {
					$fine = 0;
				}

				// Total fees including fine
				//$total_fees = $current_fees + $fine;
				 if (in_array($result['enrollment_no'], $students_array)) {
					  $new_amount=35000;
					  $fine = 0;
					  $pamtt = 0;
				  }
				
				
				if($Payment_type==2){
				  echo $new_amount.'~~'.$new_amount.'~~'.$pamtt.'~~'.$pamtt.'~~'.$fine;
				  $this->session->set_userdata('amount',round($new_amount+$pamtt+$fine));
				 }else if($Payment_type==3){
					 if($result['package_name']=='Reddy'){
						 $percent_amount= ($new_amount); 
					 }else{
						$percent_amount= ($new_amount*35)/100; 
						
					if (in_array($result['enrollment_no'], $students_array)) {
					$percent_amount=35000;
					}
					 }
					 
				  
					 
					 echo $new_amount.'~~'.$percent_amount.'~~'.$pamtt.'~~'.$pamtt.'~~'.$fine;
					 $this->session->set_userdata('amount',round($percent_amount+$pamtt+$fine));
				 }
				//$this->session->set_userdata('amount',$pamt);
				
				
				 }
				 
			// if(($stud_id=="4989")||($stud_id=="2169"))
			  /*if(($stddet['stud_id']=="4989")||($stddet['stud_id']=="2169")){
			$pamtt =$pamtt + $result['refund_amount'];
			 }*/
			//$pamtt='13';
			/* if($_POST['stud_id']=="4989"){
				 $result['refund_amount'];
					 }*/
					 
		/*		if($stddet['stud_id']=="2169"){
 //echo $pamtt;
	}	 */
	/*if($pamtt<0){
				
				if($_POST['year']=="2021"){
				
				$stream_id= $stddet['admission_stream'];
				$admission_year= $stddet['admission_session'];
				$current_year= $stddet['current_year'];
				$current_year=$current_year + 1;
				if($current_year<2){
					$year=$current_year;
				}else{
					$year=0;
				}
				 if(empty($stddet['admission_cycle']))
				 {
					 $academic_fees_table="academic_fees";
				 }else{
					 $academic_fees_table="phd_academic_fees";
				 }
				// echo $academic_fees_table;
				 $sqlre="SELECT * FROM ".$academic_fees_table." WHERE stream_id='$stream_id' AND academic_year='2021-22' AND admission_year='$admission_year' AND year='$year'";
				 
				 $queryre=$DB1->query($sqlre);
			   
			 if($stddet['stud_id']=="5038"){
 //echo $DB1->last_query();;
	}  
				$resultre=$queryre->result_array();
				
				if(!empty($_POST['stud_id'])){
				 $sqlsch="SELECT * FROM  fees_consession_details WHERE student_id='".$_POST['stud_id']."' AND academic_year='2020' AND duration!='1' and 
student_id not in ('1922','3128','3156','3178','3182','3189','3207','3209','3210','3227','3243','3282','3313','3316','3347','3349','3373','3374','3375','3380','3381','3393','3401','3500','3556','3638','3655','3675','3715','3737','3787','3802','3804','3817','3864','3867','3897','3898','3923','3940','3946','3980','3985','3987','4018','4046','4132','4166','4181','4192','4195','4205','4234','4274','4299','4304','4317','4379','4389','4457','4500','4526','4532','4534','4544','4589','4615','4617','4631','4652','4685','4945','4951','4963','5040','5061','5087','5090','5091','5132','5178','5338','5340')";
				 $querysch=$DB1->query($sqlsch);
				 $resultsch=$querysch->result_array();
				 
				 if($resultsch[0]['exepmted_fees']){
				 $exepmted_fees=$resultsch[0]['exepmted_fees'];
				 }else{
				 $exepmted_fees=0;
				 }
				 
				}//if(!empty($_POST['stud_id']))
			
				 //echo '<table border="1" ><tr style="background:#3175af"><th><label class="">Total fees </label></th></tr><tr style="color:#000000"><td><b><label class="">'.$resultre[0]['total_fees'].'</label></td></tr></table>'; 
				// if($exepmted_fees < 0 ) {
				 //   $namount=$resultre[0]['total_fees']/2;
				//	$new_amount=$namount + $exepmted_fees;
					
				//	 echo $resultre[0]['total_fees'].'~~'.$new_amount;
				// }else
				 
				 if($exepmted_fees==0){
					 
					 if($Payment_type==1){
					$new= $resultre[0]['total_fees']/2;
					 }elseif($Payment_type==2){
					$new= $resultre[0]['total_fees'];	 
					 }elseif($Payment_type==3){
					$new=($resultre[0]['total_fees']*35)/100;
					  }elseif($Payment_type==4){
					$new=($resultre[0]['total_fees']*70)/100;
					  }
					
					if($_POST['stud_id']=="4389"){
					// echo $resultre[0]['total_fees'];
					 }
					 
					$new=$new  + $pamtt;
					
					
				 echo $resultre[0]['total_fees'].'~~'.$new.'~~'.$result2['amount'];//$result2['amount']
				 
				 }else{ //if($exepmted_fees==0)
				 
					 if($_POST['stud_id']=="4389"){
					// echo $resultre[0]['total_fees'];
					 }
				 $new_amount=$resultre[0]['total_fees'] - $exepmted_fees;
				 
				 //if($Payment_type==1){
				 //$new=$new_amount/2;
				 //}else{
				//	 $new=$new_amount;
				// }/
				  if($Payment_type==1){
					$new= $new_amount/2;
					 }elseif($Payment_type==2){
					$new= $new_amount;	 
					 }elseif($Payment_type==3){
					$new=($new_amount*35)/100;
					  }elseif($Payment_type==4){
					$new=($new_amount*70)/100;
					  }
				 
				 $new=$new  + $pamtt;
				 echo $new_amount.'~~'.$new.'~~'.$result2['amount'];
				 } ////if($exepmted_fees==0)
				 
				}else{ //if($_POST['year']=="2020")
					echo '<b style="color:#000000">Please Select Year 2021-22 For Re-Registration</b>';
				}
				
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			}elseif($pamtt==0){ //if($pamtt<0)
				//echo "in 2";
				$exepmted_fees=0;
				
				if($_POST['year']=="2021"){
				
				$stream_id= $stddet['admission_stream'];
				$admission_year= $stddet['admission_session'];
				$current_year= $stddet['current_year'];
				//echo '<br>';
				 $current_year=$current_year + 1;
				if($current_year<=2){
					$year=$current_year;
				}else{
					$year=0;
				}
				 
				  if(empty($stddet['admission_cycle']))
				 {
					 $academic_fees_table="academic_fees";
				 }else{
					 $academic_fees_table="phd_academic_fees";
				 }
				///  echo $academic_fees_table;
				 $sqlre="SELECT * FROM ".$academic_fees_table." WHERE stream_id='".$stream_id."' AND academic_year='2021-22' AND admission_year='".$admission_year."' AND year='".$year."'";
				 $queryre=$DB1->query($sqlre);
			 // if($stddet['stud_id']=="5398"){
                //  echo $DB1->last_query();
//	}  
				$resultre=$queryre->result_array();
				
				if(!empty($_POST['stud_id'])){
				// $sqlsch="SELECT * FROM  fees_consession_details WHERE student_id='".$_POST['stud_id']."' AND academic_year='2019'";
				$sqlsch="SELECT * FROM  fees_consession_details WHERE student_id='".$_POST['stud_id']."' AND academic_year='2020' AND duration!='1'" ;
				//and 
//student_id not in ('1922','3128','3156','3178','3182','3189','3207','3209','3210','3227','3243','3282','3313','3316','3347','3349','3373','3374','3375','3380','3381','3393','3401','3500','3556','3638','3655','3675','3715','3737','3787','3802','3804','3817','3864','3867','3897','3898','3923','3940','3946','3980','3985','3987','4018','4046','4132','4166','4181','4192','4195','4205','4234','4274','4299','4304','4317','4379','4389','4457','4500','4526','4532','4534','4544','4589','4615','4617','4631','4652','4685','4945','4951','4963','5040','5061','5087','5090','5091','5132','5178','5338',
'5340')";/
				 $querysch=$DB1->query($sqlsch);
				 //   echo $DB1->last_query();
				 $resultsch=$querysch->result_array();
				 
				 if($resultsch[0]['exepmted_fees']){
				 $exepmted_fees=$resultsch[0]['exepmted_fees'];
				 }else{
				 $exepmted_fees=0;
				 }
				 
				}//if(!empty($_POST['stud_id']))
			
				 //echo '<table border="1" ><tr style="background:#3175af"><th><label class="">Total fees </label></th></tr><tr style="color:#000000"><td><b><label class="">'.$resultre[0]['total_fees'].'</label></td></tr></table>'; 
				//if($exepmted_fees < 0 ) {
				 //   $namount=$resultre[0]['total_fees']/2;
				//	$new_amount=$namount + $exepmted_fees;
				//	
				//	 echo $resultre[0]['total_fees'].'~~'.$new_amount;
				// }else/ 
				 
				 if($exepmted_fees==0){
					   
					
					  //if($Payment_type==1){
				     //  echo $resultre[0]['total_fees'].'~~'.$resultre[0]['total_fees']/2;
					 // }else{
				     //  echo $resultre[0]['total_fees'].'~~'.$resultre[0]['total_fees'];		  
					 // }/
					  
					  if($Payment_type==1){
					 echo $resultre[0]['total_fees'].'~~'.($resultre[0]['total_fees']/2).'~~'.$result2['amount'];
					 }elseif($Payment_type==2){
					echo $resultre[0]['total_fees'].'~~'.$resultre[0]['total_fees'].'~~'.$result2['amount']; 
					 }elseif($Payment_type==3){
						 echo $resultre[0]['total_fees'].'~~'.(($resultre[0]['total_fees']*35)/100).'~~'.$result2['amount'];
					//$new=($new_amount*35)/100;
					  }elseif($Payment_type==4){
						 echo $resultre[0]['total_fees'].'~~'.(($resultre[0]['total_fees']*70)/100).'~~'.$result2['amount'];
					//$new=($new_amount*35)/100;
					  }
					  
				 
				 }else{ //if($exepmted_fees==0)
					
					 if($_POST['stud_id']=="4389"){
					// echo '2';
					 }
					 $new_amount=$resultre[0]['total_fees'] - $exepmted_fees;
					 
					  //if($Payment_type==1){
					// echo $new_amount.'~~'.$new_amount/2;
				    // }else{
					 //echo $new_amount.'~~'.$new_amount;
				    //  }/
					   if($Payment_type==1){
					 echo $new_amount.'~~'.($new_amount/2).'~~'.$result2['amount'];
					 }elseif($Payment_type==2){
					echo $new_amount.'~~'.$new_amount.'~~'.$result2['amount'];
					 }elseif($Payment_type==3){
						 
						// echo $resultre[0]['total_fees'].'~~'.($resultre[0]['total_fees']*35)*100;
						echo $new_amount.'~~'.(($new_amount*35)/100).'~~'.$result2['amount'];
					//$new=($new_amount*35)/100;
					  }elseif($Payment_type==4){
						 
						// echo $resultre[0]['total_fees'].'~~'.($resultre[0]['total_fees']*35)*100;
						echo $new_amount.'~~'.(($new_amount*70)/100).'~~'.$result2['amount'];
					//$new=($new_amount*35)/100;
					  }
					  
				 } //if($exepmted_fees==0)
				 
				}else{ //if($_POST['year']=="2020")
					echo '<b style="color:#000000">Please Select Year 2021-22 For Re-Registration</b>';
				}
				
		       }else{ //elseif($pamtt==0)
				//echo '<b style="color:#000000">&nbsp;
				//First pay Admission 2019-20 Pending Fee.<br> Then You are eligible For Re-Registration<br>
				//Pending Amount Rs.'.$pamtt.'</b>&nbsp;';/
			
				echo 'Pending~~'.$new_amount.'~~'.$pamtt;
			    }*/
				
			 }
			
		 }else{
			 //echo "ins--8";
			     $sql22 = "select admission_cycle from student_master where enrollment_no='".$_SESSION['name']."'";
				 $query22 = $DB1->query($sql22);
				 $result22=$query22->row_array();
				// print_r($result22);
				 //echo $result22['admission_cycle'];exit;
				 $crr_date=date('Y-m-d');
				 $examsession=$_POST['examsession'];
			 if($_POST['ftype']=='Examination'){			
				 if(empty($result22['admission_cycle'])){
				
				
				 $exam_id=$examsession;//'18';				 				 
				 $sql = "select exam_fees from exam_details where enrollment_no='".$_SESSION['name']."' and exam_id='$exam_id'";
				 $late_fees_phd=0;
				 $late_fees=0;
				 }else{
					//$exam_id='2';
				 $sql = "select exam_fees from phd_exam_details where enrollment_no='".$_SESSION['name']."' and exam_id='$examsession'"; 
				 $late_fees=0;
				 $late_fees_phd=0;
				 }
			 }else{
				 //echo"1";
				 if(empty($result22['admission_cycle'])){
					$sql = "select photocopy_fees,reval_fees from exam_details where enrollment_no='".$_SESSION['name']."' and exam_id='29'";
				 }else{
				 $sql = "select photocopy_fees,reval_fees from phd_exam_details where enrollment_no='".$_SESSION['name']."' and exam_id='$examsession'"; //exit;
				 }
			 }
			 $query = $DB1->query($sql);
			 $result=$query->row_array();

			//echo '<table border="1" ><tr style="background:#3175af"><th><label class="">Exam fees </label></th></tr><tr style="color:#000000"><td><b><label class="">'.$result['exam_fees'].'</label></td></tr></table>';
			if($_POST['ftype']=='Examination'){

				 if(!empty($examsession)){
				 $exam_amount=$result['exam_fees'];
				 $sqlcheck =  "select amount from online_payment where registration_no='".$_SESSION['name']."' and examsession='$examsession' AND payment_status='success' union select amount from fees_details where student_id='".$_POST['stud_id']."' and exam_session='$examsession'";
				 $querycheck= $DB1->query($sqlcheck);
			     $resultcheck=$querycheck->row_array();
			    
				if(!empty($resultcheck['amount'])){
				 
				  $sqlcheckf =  "select sum(amount) as tot_amt from fees_details where student_id='".$_POST['stud_id']."' and exam_session='$examsession'";
				  $querycheckf= $DB1->query($sqlcheckf);
			      $resultcheckf=$querycheckf->row_array();
				  if(!empty($resultcheckf['tot_amt'])){
					
				    if($result['exam_fees'] !=0){
					  echo $result['exam_fees']+$late_fees+$late_fees_phd-$resultcheckf['tot_amt'];
					  $this->session->set_userdata('amount',round($result['exam_fees']+$late_fees+$late_fees_phd-$resultcheckf['tot_amt']));
					}else{
						echo 0;
					}
				  }else{
					 if($result['exam_fees'] !=0){
					  echo $result['exam_fees']+$late_fees+$late_fees_phd;
					  $this->session->set_userdata('amount',round($result['exam_fees']+$late_fees+$late_fees_phd));
					}else{
						echo 0;
					} 
				  }

				 
			 }else{
				
				if($result['exam_fees'] !=0){
				echo $result['exam_fees']+$late_fees+$late_fees_phd;
				$this->session->set_userdata('amount',round($result['exam_fees']+$late_fees+$late_fees_phd));
				}else{
					echo 0;
				}
			 }
			 
				 }else{
					 echo 0;
				 }
				//$late_fees=0;
				
				/* if($_SESSION['name'] == 240102041009){
					 echo '<pre>';
					 print_r($_SESSION);exit;
				 } 
				*/
				 
				 
			 }else if($_POST['ftype']=='Photocopy'){
				 echo $result['photocopy_fees'];
			 }else if($_POST['ftype']=='Revaluation'){
				 echo $result['reval_fees'];
			 }
			
		 }
	    
	}
	
	
	function fetch_admission($data){
	//	print_r($data);
		$stud_id=$data['stud_id'];
		$Payment_type=$data['Payment_type'];
		      $stddet = $this->fetch_studentdata($_SESSION['name']);
	           $fed = $this->check_fee_records($stddet['stud_id'],2);
	         
	          $DB1 = $this->load->database('umsdb', TRUE);
	   		  $DB1->select("ad.actual_fee,ad.applicable_fee,ad.opening_balance,sum(fd.amount) as famount,m.refund_amount");
		      $DB1->from('admission_details ad');
	//	$DB1->where("payment_status",'success'); 
	          $DB1->join('student_master as sm','ad.student_id = sm.stud_id','left');
     	      $DB1->join('fees_details as fd','ad.student_id = fd.student_id','left');
			  // if($stddet['stud_id']=="4989"){
			  

			   $DB1->join("(SELECT SUM(amount) AS refund_amount,student_id FROM fees_refunds WHERE student_id='".$stddet['stud_id']."' AND `academic_year` = '2019'  AND `is_deleted` = 'N') AS m"
,'`m`.`student_id` = `sm`.`stud_id`','left');
			//  }
			$DB1->where("fd.student_id ",$stddet['stud_id']);
		     $DB1->where("sm.stud_id",$stddet['stud_id']);
			$DB1->where("fd.academic_year",$data['udf2']);
	 		$DB1->where("ad.academic_year",$data['udf2']); 
	
	if($fed['student_id']!=''){
		  $DB1->where("fd.type_id",2);
		  $DB1->where("fd.chq_cancelled",'N');
			}
				
		$query=$DB1->get();
	
//echo $DB1->last_query();
		$result=$query->row_array();
		
			//$pamt = $result['actual_fee']-$result['famount'];
			$pamt = ($result['applicable_fee']+$result['opening_balance'])-$result['famount'];
			 if(($stddet['stud_id']=="4989")||($stddet['stud_id']=="2169")){
			$pamt =$pamt + $result['refund_amount'];
			 }
	 /*'<table border="1" ><tr style="background:#3175af"><th><label class="">Total fees </label></th><th><label class="">Paid fees </label></th><th><label class="">Pending fees </label></th></tr><tr style="color:#000000"><td><b><label class="">'.$result['actual_fee'].'</label></td><td><label class="">'.$result['famount'].'</label>
     </td><td><label class="">'.$pamt.'</label></b></td></tr></table>';*/
	    
		//echo $result['actual_fee'].'~~'.$result['famount'].'~~'.$pamt;
		return $pamt;
	}
	
	function fetch_ReRegistration($data){
		//$_POST['stud_id']
		$stud_id=$data['stud_id'];
		$Payment_type=$data['Payment_type'];
		    $DB1 = $this->load->database('umsdb', TRUE);
		    $amount=0;$new=0;
			$exepmted_fees=0;
		    $stddet = $this->fetch_studentdata($_SESSION['name']);
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////	
			
	   		  $DB1->select("ad.actual_fee,ad.applicable_fee,ad.opening_balance,sum(fd.amount) as famount,m.refund_amount,sm.belongs_to,sm.package_name,sm.enrollment_no,sm.admission_session");
		      $DB1->from('admission_details ad');
	//	$DB1->where("payment_status",'success'); 
	          $DB1->join('student_master as sm','ad.student_id = sm.stud_id','left');
     	      $DB1->join('fees_details as fd','ad.student_id = fd.student_id AND ad.academic_year=fd.academic_year and fd.type_id=2 AND is_deleted="N" AND chq_cancelled = "N"','left');
			 // if($data['stud_id']=="4989"){
			  

			   $DB1->join("(SELECT SUM(amount) AS refund_amount,student_id FROM fees_refunds WHERE student_id='".$data['stud_id']."' AND `academic_year` = '".L_RE_REG_YEAR."'  AND `is_deleted` = 'N') AS m"
,'`m`.`student_id` = `sm`.`stud_id`','left');
			//  }
		     //$DB1->where("sm.enrollment_no",$_SESSION['name']);
			 //$DB1->where("fd.student_id ",$stddet['stud_id']);
			  $DB1->where("sm.stud_id",$stud_id);
			//$DB1->where("fd.academic_year",L_RE_REG_YEAR);
			$DB1->where("ad.academic_year",L_RE_REG_YEAR); 
			if($stud_id!='')
			{
		//$DB1->where("fd.type_id",2);
		//$DB1->where("fd.chq_cancelled",'N');
			}
		//echo $DB1->last_query();		
		$query=$DB1->get();
	
		$result=$query->row_array();
		
			//$pamt = $result['actual_fee']-$result['famount'];
			 $pamtt = ($result['applicable_fee']+$result['opening_balance']+$result['refund_amount'])-$result['famount']; 
			 
			 
			 $stream_id= $stddet['admission_stream'];
			$admission_year= $stddet['admission_session'];
			$current_year= $stddet['current_year'];
			$current_year=$current_year + 1;
			if($current_year<2){
				$year=$current_year;
			}else{
				$year=0;
			}
		
		  if(empty($stddet['admission_cycle']))
				 {
					 $academic_fees_table="academic_fees";
				 }else{
					 $academic_fees_table="phd_academic_fees";
				 }
		 //echo $academic_fees_table;
				if($result['belongs_to']=='Package' && $result['package_name']!='Reddy'){
					 $sqlre="SELECT applicable_fee as total_fees FROM admission_details WHERE stream_id='$stream_id' AND academic_year='".L_RE_REG_YEAR."' AND student_id='".$stddet['stud_id']."'";
				 }elseif($result['admission_session']=='2024' && $result['package_name']=='Reddy'){
					 $sqlre="SELECT (semwise_fees)/2 as total_fees FROM package_students_fees_details WHERE enrollment_no='".$result['enrollment_no']."' ";
				 }elseif($result['admission_session']!='2024' && $result['package_name']=='Reddy'){
					$sqlre="SELECT (applicable_fee)/4 as total_fees FROM admission_details WHERE stream_id='$stream_id' AND academic_year='".L_RE_REG_YEAR."' AND student_id='".$stddet['stud_id']."'";
				 }else{
					$sqlre="SELECT * FROM ".$academic_fees_table." WHERE stream_id='".$stream_id."' AND academic_year='".ACADEMIC_YEAR."' AND admission_year='".$admission_year."' AND year='".$year."'";
				 }
		 
			 $queryre=$DB1->query($sqlre);
		  // echo $DB1->last_query();
		 // die();  
		$resultre=$queryre->result_array();
		
			 if(!empty($stud_id)){
		// $sqlsch="SELECT * FROM  fees_consession_details WHERE student_id='".$stud_id."' AND academic_year='2019'";
		$sqlsch="SELECT * FROM  fees_consession_details WHERE student_id='".$_POST['stud_id']."' AND academic_year='".L_RE_REG_YEAR."' AND duration!='1'"; 
//student_id not in ('1922','3128','3156','3178','3182','3189','3207','3209','3210','3227','3243','3282','3313','3316','3347','3349','3373','3374','3375','3380','3381','3393','3401','3500','3556','3638','3655','3675','3715','3737','3787','3802','3804','3817','3864','3867','3897','3898','3923','3940','3946','3980','3985','3987','4018','4046','4132','4166','4181','4192','4195','4205','4234','4274','4299','4304','4317','4379','4389','4457','4500','4526','4532','4534','4544','4589','4615','4617','4631','4652','4685','4945','4951','4963','5040','5061','5087','5090','5091','5132','5178','5338','5340')";
	     $querysch=$DB1->query($sqlsch);
		 $resultsch=$querysch->result_array();
		 
		 if($resultsch[0]['exepmted_fees']){
		 $exepmted_fees=$resultsch[0]['exepmted_fees'];
		 }else{
		 $exepmted_fees=0;
		 }
		 
		}
		
		
		$students_array=array('240105231994','220101091011','220105131168','220105131175','220105131178','220105131179','220105131318','220105231018','220105231019','220105231059','220105231073','220105231101','220105231161','220105231162','230105131226','230105231128','230105231163','230105231168','230105231169','230105231249','230105231283','230105231317','230105231349','230105231383','230105232020','230106271136','240101431018','240104071038','240104071055','240105131423','240105182008','240105231153','240105231202','240105231873','240105231875','240105231917','240105231994','240105232034','240106301019','230105231168','230105231317','230106271136','230105231283','230105231163','230106271136','220105231133','220105231103');
			 
			 /*$amount= $resultre[0]['total_fees']+$pamtt-$exepmted_fees;
			 
			 if($Payment_type==2){
				 $amount=$amount;
				 }else if($Payment_type==3){
					$amount= ($amount*35)/100;
					// echo $percent_amount.'~~'.$percent_amount.'~~'.$pamtt;
				 }*/
				 
				 
				   $new_amount=($resultre[0]['total_fees'] ) - $exepmted_fees;
				   
				   if (in_array($result['enrollment_no'], $students_array)) {
					  $new_amount=35000;
					  $pamtt = 0;
				  }
				   
				   
				  //echo $resultre[0]['total_fees'].'~~'.($resultre[0]['total_fees']/2).'~~'.$result2['amount'];
				  if($stddet['stud_id']=="5861"){
				  //echo $new_amount.'~~'.$new_amount.'~~'.$pamtt.'--'.$exepmted_fees; echo '<br>';
				  }
				if($Payment_type==2){
					
				   $amount=$new_amount;
				   $amount=$amount+$pamtt;
				   if($stddet['stud_id']=="5861"){
 //echo $amount+$pamtt;
	}	
				 }else if($Payment_type==3){
					if($result['package_name']=='Reddy'){
						$amount= $new_amount;
					}else{
						$amount= ($new_amount*35)/100;
						 if (in_array($result['enrollment_no'], $students_array)) {
					     $amount=35000;
						 $pamtt=0;
				      }
					}
					
					$amount=$amount+$pamtt;
					 if($stddet['stud_id']=="7832"){
						// echo $amount+$pamtt;
						 //echo $new_amount.'~~'.$amount.'~~'.$pamtt;
						}	
					// echo $new_amount.'~~'.$amount.'~~'.$pamtt;
				 }
				 
				 
				 
				 
				 
			 
			// if(($stddet['stud_id']=="4989")||($stddet['stud_id']=="2169"))
			 /*if(($stud_id=="4989")||($stud_id=="2169")){
				$pamtt = $pamtt + $result['refund_amount'];
					 }*/
			/*if($pamtt<0){
				
			////////////////////////////////////////////////////////////////////////////////////////////////////////////	
			$stream_id= $stddet['admission_stream'];
			$admission_year= $stddet['admission_session'];
			$current_year= $stddet['current_year'];
			$current_year=$current_year + 1;
			if($current_year<2){
				$year=$current_year;
			}else{
				$year=0;
			}
		
		  if(empty($stddet['admission_cycle']))
				 {
					 $academic_fees_table="academic_fees";
				 }else{
					 $academic_fees_table="phd_academic_fees";
				 }
		 //echo $academic_fees_table;
		 $sqlre="SELECT * FROM ".$academic_fees_table." WHERE stream_id='".$stream_id."' AND academic_year='2021-22' AND admission_year='".$admission_year."' AND year='".$year."'";
			 $queryre=$DB1->query($sqlre);
		  // $DB1->last_query();
		 // die();  
		$resultre=$queryre->result_array();

         if(!empty($stud_id)){
		// $sqlsch="SELECT * FROM  fees_consession_details WHERE student_id='".$stud_id."' AND academic_year='2019'";
		$sqlsch="SELECT * FROM  fees_consession_details WHERE student_id='".$_POST['stud_id']."' AND academic_year='2020' AND duration!='1' and 
student_id not in ('1922','3128','3156','3178','3182','3189','3207','3209','3210','3227','3243','3282','3313','3316','3347','3349','3373','3374','3375','3380','3381','3393','3401','3500','3556','3638','3655','3675','3715','3737','3787','3802','3804','3817','3864','3867','3897','3898','3923','3940','3946','3980','3985','3987','4018','4046','4132','4166','4181','4192','4195','4205','4234','4274','4299','4304','4317','4379','4389','4457','4500','4526','4532','4534','4544','4589','4615','4617','4631','4652','4685','4945','4951','4963','5040','5061','5087','5090','5091','5132','5178','5338','5340')";
	     $querysch=$DB1->query($sqlsch);
		 $resultsch=$querysch->result_array();
		 
		 if($resultsch[0]['exepmted_fees']){
		 $exepmted_fees=$resultsch[0]['exepmted_fees'];
		 }else{
		 $exepmted_fees=0;
		 }
		 
		}

             if($exepmted_fees==0){
				 
				  if($stud_id=="4826"){
					// echo '1';
					 }
					 
					// if($Payment_type==1){
			    //$amount= $resultre[0]['total_fees']/2;
				//	 }else{
				//$amount= $resultre[0]['total_fees'];		 
				//	 }//
					  if($Payment_type==1){
					 $amount= $resultre[0]['total_fees']/2;
					 }elseif($Payment_type==2){
					$amount= $resultre[0]['total_fees'];
					 }elseif($Payment_type==3){
						 $amount= ($resultre[0]['total_fees']*35)/100;
						// echo $resultre[0]['total_fees'].'~~'.($resultre[0]['total_fees']*35)*100;
						//echo $new_amount.'~~'.($new_amount*35)/100;
					//$new=($new_amount*35)/100;
					  }elseif($Payment_type==4){
						 $amount= ($resultre[0]['total_fees']*70)/100;
						// echo $resultre[0]['total_fees'].'~~'.($resultre[0]['total_fees']*35)*100;
						//echo $new_amount.'~~'.($new_amount*35)/100;
					//$new=($new_amount*35)/100;
					  }
					 
			$new=$amount+$pamtt;
			 }else{
				 if($stud_id=="4826"){
					//echo '2'.$exepmted_fees;
					 }
			$new_amount=$resultre[0]['total_fees'] - $exepmted_fees;
			
			 //if($Payment_type==1){
			//$amount=$new_amount/2;
			// }else{
			//	$amount=$new_amount; 
			// }//
			  if($Payment_type==1){
					 $amount=$new_amount/2;
					 }elseif($Payment_type==2){
					$amount=$new_amount;
					 }elseif($Payment_type==3){
						 $amount=($new_amount*35)/100;
						// echo $resultre[0]['total_fees'].'~~'.($resultre[0]['total_fees']*35)*100;
						//echo $new_amount.'~~'.($new_amount*35)/100;
					//$new=($new_amount*35)/100;
					  }elseif($Payment_type==4){
						 $amount=($new_amount*70)/100;
						// echo $resultre[0]['total_fees'].'~~'.($resultre[0]['total_fees']*35)*100;
						//echo $new_amount.'~~'.($new_amount*35)/100;
					//$new=($new_amount*35)/100;
					  }
			 
			$new=$amount+$pamtt;
			 }

			//$amount= $resultre[0]['total_fees']/2;
			 return round($new);	
				
				
				
       ////////////////////////////////////////////////////////////////////////////////////////////////////////////	

				
			}else{
		////////////////////////////////////////////////////////////////////////////////////////////////////////////	
			$stream_id= $stddet['admission_stream'];
			$admission_year= $stddet['admission_session'];
			$current_year= $stddet['current_year'];
			$current_year=$current_year + 1;
			if($current_year<2){
				$year=$current_year;
			}else{
				$year=0;
			}
			
			 if(empty($stddet['admission_cycle']))
				 {
					 $academic_fees_table="academic_fees";
				 }else{
					 $academic_fees_table="phd_academic_fees";
				 }
		
		 $sqlre="SELECT * FROM ".$academic_fees_table." WHERE stream_id='$stream_id' AND academic_year='2021-22' AND admission_year='$admission_year' AND year='$year'";
			 $queryre=$DB1->query($sqlre);
		  // $DB1->last_query();
		 // die();  
		$resultre=$queryre->result_array();

         if(!empty($stud_id)){
		 $sqlsch="SELECT * FROM  fees_consession_details WHERE student_id='".$stud_id."' AND academic_year='2020' AND duration!='1'";
	     $querysch=$DB1->query($sqlsch);
		 $resultsch=$querysch->result_array();
		 
		 if($resultsch[0]['exepmted_fees']){
		 $exepmted_fees=$resultsch[0]['exepmted_fees'];
		 }else{
		 $exepmted_fees=0;
		 }
		}

             if($exepmted_fees==0){
				 
				 
				 // if($Payment_type==1){
			//$amount= $resultre[0]['total_fees']/2;
			//	  }else{
			//		  $amount= $resultre[0]['total_fees'];
			//	  }/
				   if($Payment_type==1){
					$amount= $resultre[0]['total_fees']/2;
					 }elseif($Payment_type==2){
					 $amount= $resultre[0]['total_fees'];
					 }elseif($Payment_type==3){
						 $amount= ($resultre[0]['total_fees']*35)/100;
						// $amount=($new_amount*35)/100;
						// echo $resultre[0]['total_fees'].'~~'.($resultre[0]['total_fees']*35)*100;
						//echo $new_amount.'~~'.($new_amount*35)/100;
					//$new=($new_amount*35)/100;
					  }elseif($Payment_type==4){
						 $amount= ($resultre[0]['total_fees']*70)/100;
						// $amount=($new_amount*35)/100;
						// echo $resultre[0]['total_fees'].'~~'.($resultre[0]['total_fees']*35)*100;
						//echo $new_amount.'~~'.($new_amount*35)/100;
					//$new=($new_amount*35)/100;
					  }
				  
			 }else{
				 $new_amount=$resultre[0]['total_fees'] - $exepmted_fees;
				//
				//  if($Payment_type==1){
				// $amount=$new_amount/2;
				//  }else{
				//	  $amount=$new_amount;
				//  }
				  
				  if($Payment_type==1){
					$amount=$new_amount/2;
					 }elseif($Payment_type==2){
					  $amount=$new_amount;
					 }elseif($Payment_type==3){
						   $amount=($new_amount*35)/100;
					//	 $amount= ($resultre[0]['total_fees']*35)/100;
						// $amount=($new_amount*35)/100;
						// echo $resultre[0]['total_fees'].'~~'.($resultre[0]['total_fees']*35)*100;
						//echo $new_amount.'~~'.($new_amount*35)/100;
					//$new=($new_amount*35)/100;
					  }elseif($Payment_type==4){
						   $amount=($new_amount*70)/100;
					//	 $amount= ($resultre[0]['total_fees']*35)/100;
						// $amount=($new_amount*35)/100;
						// echo $resultre[0]['total_fees'].'~~'.($resultre[0]['total_fees']*35)*100;
						//echo $new_amount.'~~'.($new_amount*35)/100;
					//$new=($new_amount*35)/100;
					  }
			 }*/

			//$amount= $resultre[0]['total_fees']/2;
			 return round($amount);
		//	}
	}
	
	
	function fetch_feedet_full()
	{  $exepmted_fees=0;$new=0;
	     $DB1 = $this->load->database('umsdb', TRUE);
	      if($_POST['ftype']=='Re-Registration-full'){
			 
			$stddet = $this->fetch_studentdata($_SESSION['name']);
			$fed = $this->check_fee_records($stddet['stud_id'],2);
			
			$DB1 = $this->load->database('umsdb', TRUE);
	   		  $DB1->select("ad.actual_fee,ad.applicable_fee,ad.opening_balance,sum(fd.amount) as famount");
		      $DB1->from('admission_details ad');
	//	$DB1->where("payment_status",'success'); 
	          $DB1->join('student_master as sm','ad.student_id = sm.stud_id','left');
     	      $DB1->join('fees_details as fd','ad.student_id = fd.student_id','left');
		    // $DB1->where("sm.enrollment_no",$_SESSION['name']);$DB1->where("sm.stud_id",$stddet['stud_id']);
			$DB1->where("fd.student_id ",$stddet['stud_id']);
			 $DB1->where("sm.stud_id",$stddet['stud_id']);
			$DB1->where("fd.academic_year",'2019');
			$DB1->where("ad.academic_year",'2019'); 
			if($fed['student_id']!='')
			{
		$DB1->where("fd.type_id",2);
		$DB1->where("fd.chq_cancelled",'N');
			}
				
		$query=$DB1->get();
	
//echo $DB1->last_query();
		$result=$query->row_array();
		
			//$pamt = $result['actual_fee']-$result['famount'];
			 $pamtt = ($result['applicable_fee']+$result['opening_balance'])-$result['famount'];
			
			if($_POST['year']=="2020"){
				
				$stream_id= $stddet['admission_stream'];
				$admission_year= $stddet['admission_session'];
				$current_year= $stddet['current_year'];
				$current_year=$current_year + 1;
				if($current_year<2){
					$year=$current_year;
				}else{
					$year=0;
				}
				 
				 if(empty($stddet['admission_cycle']))
				 {
					 $academic_fees_table="academic_fees";
				 }else{
					 $academic_fees_table="phd_academic_fees";
				 }
				 
				 $sqlre="SELECT * FROM ".$academic_fees_table." WHERE stream_id='$stream_id' AND academic_year='2020-21' AND admission_year='$admission_year' AND year='$year'";
				 $queryre=$DB1->query($sqlre);
			   $DB1->last_query();
			 // die();  
				$resultre=$queryre->result_array();
				
				if(!empty($_POST['stud_id'])){
				 $sqlsch="SELECT * FROM  fees_consession_details WHERE student_id='".$_POST['stud_id']."' AND academic_year='2020' AND duration!='1' and 
student_id not in ('1922','3128','3156','3178','3182','3189','3207','3209','3210','3227','3243','3282','3313','3316','3347','3349','3373','3374','3375','3380','3381','3393','3401','3500','3556','3638','3655','3675','3715','3737','3787','3802','3804','3817','3864','3867','3897','3898','3923','3940','3946','3980','3985','3987','4018','4046','4132','4166','4181','4192','4195','4205','4234','4274','4299','4304','4317','4379','4389','4457','4500','4526','4532','4534','4544','4589','4615','4617','4631','4652','4685','4945','4951','4963','5040','5061','5087','5090','5091','5132','5178','5338','5340')";
				 $querysch=$DB1->query($sqlsch);
				 $resultsch=$querysch->result_array();
				 
				 if($resultsch[0]['exepmted_fees']){
				 $exepmted_fees=$resultsch[0]['exepmted_fees'];
				 }else{
				 $exepmted_fees=0;
				 }
				}
			
				 //echo '<table border="1" ><tr style="background:#3175af"><th><label class="">Total fees </label></th></tr><tr style="color:#000000"><td><b><label class="">'.$resultre[0]['total_fees'].'</label></td></tr></table>'; 
				/* if($exepmted_fees < 0 ) {
				    $namount=$resultre[0]['total_fees']/2;
					$new_amount=$namount + $exepmted_fees;
					
					 echo $resultre[0]['total_fees'].'~~'.$new_amount;
				 }else*/ 
				 
				 if($exepmted_fees==0){
					 
					 
					$new= $resultre[0]['total_fees'];
					
					$new=$new  + $pamtt;
					
					
				 echo $resultre[0]['total_fees'].'~~'.$new;
				 }else{
					
				 $new_amount=$resultre[0]['total_fees'] - $exepmted_fees;
				 $new=$new_amount;
				 $new=$new  + $pamtt;
				 echo $new_amount.'~~'.$new;
				 }
				 
				}else{
					echo '<b style="color:#000000">Please Select Year 2020-21 For Re-Registration</b>';
				}
		
	 }
	    
	}
	
	
	
	
	
	function fetch_ReRegistration_full($stud_id)
	{$exepmted_fees=0;$new=0;$new_amount=0;
	     $DB1 = $this->load->database('umsdb', TRUE);
	    //  if($_POST['ftype']=='Re-Registration-full')
		  {
			 
			$stddet = $this->fetch_studentdata($_SESSION['name']);
			$fed = $this->check_fee_records($stddet['stud_id'],2);
			
			$DB1 = $this->load->database('umsdb', TRUE);
	   		  $DB1->select("ad.actual_fee,ad.applicable_fee,ad.opening_balance,sum(fd.amount) as famount");
		      $DB1->from('admission_details ad');
	//	$DB1->where("payment_status",'success'); 
	          $DB1->join('student_master as sm','ad.student_id = sm.stud_id','left');
     	      $DB1->join('fees_details as fd','ad.student_id = fd.student_id','left');
		    // $DB1->where("sm.enrollment_no",$_SESSION['name']);
			$DB1->where("fd.student_id ",$stddet['stud_id']);
			 $DB1->where("sm.stud_id",$stddet['stud_id']);
			$DB1->where("fd.academic_year",'2019');
			$DB1->where("ad.academic_year",'2019'); 
			if($stud_id!='')
			{
		$DB1->where("fd.type_id",2);
		$DB1->where("fd.chq_cancelled",'N');
			}
				
		$query=$DB1->get();
	
//echo $DB1->last_query();
		$result=$query->row_array();
		
			//$pamt = $result['actual_fee']-$result['famount'];
			 $pamtt = ($result['applicable_fee']+$result['opening_balance'])-$result['famount'];
			
			//if($_POST['year']=="2020")
			{
				
				$stream_id= $stddet['admission_stream'];
				$admission_year= $stddet['admission_session'];
				$current_year= $stddet['current_year'];
				$current_year=$current_year + 1;
				if($current_year<2){
					$year=$current_year;
				}else{
					$year=0;
				}
				
				if(empty($stddet['admission_cycle']))
				 {
					 $academic_fees_table="academic_fees";
				 }else{
					 $academic_fees_table="phd_academic_fees";
				 }
				 
				 
				 $sqlre="SELECT * FROM ".$academic_fees_table." WHERE stream_id='".$stream_id."' AND academic_year='2020-21' AND admission_year='".$admission_year."' AND year='".$year."'";
				 $queryre=$DB1->query($sqlre);
			   //$DB1->last_query();
			 // die();  
				$resultre=$queryre->result_array();
				
				if(!empty($stud_id)){
				 $sqlsch="SELECT * FROM  fees_consession_details WHERE student_id='".$stud_id."' AND academic_year='2020' AND duration!='1' and 
student_id not in ('1922','3128','3156','3178','3182','3189','3207','3209','3210','3227','3243','3282','3313','3316','3347','3349','3373','3374','3375','3380','3381','3393','3401','3500','3556','3638','3655','3675','3715','3737','3787','3802','3804','3817','3864','3867','3897','3898','3923','3940','3946','3980','3985','3987','4018','4046','4132','4166','4181','4192','4195','4205','4234','4274','4299','4304','4317','4379','4389','4457','4500','4526','4532','4534','4544','4589','4615','4617','4631','4652','4685','4945','4951','4963','5040','5061','5087','5090','5091','5132','5178','5338','5340')";
				 $querysch=$DB1->query($sqlsch);
				 $resultsch=$querysch->result_array();
				 
				 if($resultsch[0]['exepmted_fees']){
				 $exepmted_fees=$resultsch[0]['exepmted_fees'];
				 }else{
				 $exepmted_fees=0;
				 }
				}
			
				 //echo '<table border="1" ><tr style="background:#3175af"><th><label class="">Total fees </label></th></tr><tr style="color:#000000"><td><b><label class="">'.$resultre[0]['total_fees'].'</label></td></tr></table>'; 
				/* if($exepmted_fees < 0 ) {
				    $namount=$resultre[0]['total_fees']/2;
					$new_amount=$namount + $exepmted_fees;
					
					 echo $resultre[0]['total_fees'].'~~'.$new_amount;
				 }else*/ 
				 
				 if($exepmted_fees==0){
					 
					 
					$new= $resultre[0]['total_fees'];
					
					$new=$new  + $pamtt;
					
					
				 return $new;
				 }else{
					
				 $new_amount=$resultre[0]['total_fees'] - $exepmted_fees;
				 $new=$new_amount;
				 $new=$new  + $pamtt;
				 return $new;
				 }
				 
				}
		
	 }
	    
	}
	
	
	
	
	
	

function fetch_studentdata()
{
      $DB1 = $this->load->database('umsdb', TRUE);
    //	$DB1->select("concat(first_name,' ',middle_name,' ',last_name) as sname,email");
	//	$DB1->from("student_master");
	//	$DB1->where("enrollment_no",$_SESSION['name']);	 
		
		   $sql = "select vw.course_id,sm.first_name,sm.middle_name,sm.last_name,sm.email,sm.mobile,sm.enrollment_no,sm.stud_id,sm.admission_school,sm.admission_stream,sm.academic_year,sm.admission_session,sm.current_year,vw.course_duration,sm.nationality,
		   sm.admission_cycle from student_master as sm
join vw_stream_details as vw on sm.admission_stream=vw.stream_id
		    where sm.enrollment_no='".$_SESSION['name']."'";
	   $query = $DB1->query($sql);
	   //echo $DB1->last_query();exit;

//echo "select concat(first_name,' ',middle_name,' ',last_name) as sname,email from student_master where enrollment_no='".$_SESSION['name']."'";
		$result=$query->row_array();
	//	var_dump($result);
	//	exit(0);
		return $result;
}
function check_admission_year($stud){
	 $DB1 = $this->load->database('umsdb', TRUE);
    //	$DB1->select("concat(first_name,' ',middle_name,' ',last_name) as sname,email");
	//	$DB1->from("student_master");
	//	$DB1->where("enrollment_no",$_SESSION['name']);	 
		
		$sql = "select ad.adm_id from admission_details as ad  where ad.student_id='".$stud."' AND academic_year='".C_RE_REG_YEAR."'";
	   $query = $DB1->query($sql);

//echo "select concat(first_name,' ',middle_name,' ',last_name) as sname,email from student_master where enrollment_no='".$_SESSION['name']."'";
		$result=$query->row_array();
	//	var_dump($result);
	//	exit(0);
		return $result;
}
function fetch_studentdata_by_no()
{
      $DB1 = $this->load->database('umsdb', TRUE);
    //	$DB1->select("concat(first_name,' ',middle_name,' ',last_name) as sname,email");
	//	$DB1->from("student_master");
	//	$DB1->where("enrollment_no",$_SESSION['name']);	 
		
		   $sql = "select first_name,middle_name,last_name,email,mobile,enrollment_no,stud_id,admission_school,admission_stream,academic_year,admission_session,current_year,admission_cycle from student_master where enrollment_no='".$_SESSION['name']."'";
	   $query = $DB1->query($sql);

//echo "select concat(first_name,' ',middle_name,' ',last_name) as sname,email from student_master where enrollment_no='".$_SESSION['name']."'";
		$result=$query->row_array();
	//	var_dump($result);
	//	exit(0);
		return $result;
}



function insert_data_in_trans($data=array(),$txnid=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$data_array=array();$data_arrayl=array();
		
		/*$data_array['student_id']=$data['stud_id'];
		$data_array['txtid'] =$txnid;
		$data_array['firstname'] =$data['firstname'];
		$data_array['registration_no'] =$data['udf3'];
		$data_array['academic_year']=$data['udf2'];
		$data_array['email'] =$data['email'];
		$data_array['phone']=$data['mobile'];
		$data_array['productinfo']=$data['productinfo'];
	    $data_array['amount'] =$data['amount'];
		$data_array['user_type']='R';*/
		
		if(!empty($data) && $txnid!=''){
			
	    $data_array['examsession']=$data['examsession'];
		
		if($data['productinfo']=="Re-Registration"){
	  /////////////////////////////////////////////////////////		
		$data_array['student_id']=$data['stud_id'];
		$data_array['txtid'] =$txnid;
		$data_array['firstname'] =$data['firstname'];
		$data_array['registration_no'] =$data['udf3'];
		$data_array['academic_year']=$data['udf2'];
		$data_array['email'] =$data['email'];
		$data_array['phone']=$data['mobile'];
		$data_array['productinfo']=$data['productinfo'];
	    $data_array['amount'] =$data['amount']-$data['udf6'];
	    $data_array['late_fees'] =$data['udf6'];
		$data_array['pending_amount'] =$data['udf5'];
		$data_array['opening_amount_paid'] =$data['opeing_balnace'];
		$data_array['user_type']='R';
		$DB1->insert('online_payment',$data_array);
		////////////////////////////////////////////////////
		/*$DB2 = $this->load->database('umsdb', TRUE);
		$data_arrayl['student_id']=$data['stud_id'];
		$data_arrayl['txtid'] =$txnid;
		$data_arrayl['firstname'] =$data['firstname'];
		$data_arrayl['registration_no'] =$data['udf3'];
		$data_arrayl['academic_year']=$data['udf2'];
		$data_arrayl['email'] =$data['email'];
		$data_arrayl['phone']=$data['mobile'];
		$data_arrayl['productinfo']='Late_fee';
	    $data_arrayl['amount'] =$data['udf6'];
		$data_arrayl['user_type']='R';
		$DB2->insert('online_payment',$data_arrayl);*/
		}else{
		$data_array['student_id']=$data['stud_id'];
		$data_array['txtid'] =$txnid;
		$data_array['firstname'] =$data['firstname'];
		$data_array['registration_no'] =$data['udf3'];
		$data_array['academic_year']=$data['udf2'];
		$data_array['email'] =$data['email'];
		$data_array['phone']=$data['mobile'];
		$data_array['productinfo']=$data['productinfo'];
	    $data_array['amount'] =$data['amount'];
		$data_array['pending_amount'] =$data['udf5'];
		$data_array['opening_amount_paid'] =$data['opeing_balnace'];
		$data_array['user_type']='R';
		$DB1->insert('online_payment',$data_array);
		}
		
		
		return $DB1->insert_id(); 
	    }
		else{
			
			return 0;
		}
	}
	
	
	function insert_data_in_trans_gym($data=array(),$txnid=''){
		//$DB1 = $this->load->database('umsdb', TRUE);
		//$DB1 = $this->load->database('umsdb', TRUE);
		$data_array=array();$data_arrayl=array();
		
		/*$data_array['student_id']=$data['stud_id'];
		$data_array['txtid'] =$txnid;
		$data_array['firstname'] =$data['firstname'];
		$data_array['registration_no'] =$data['udf3'];
		$data_array['academic_year']=$data['udf2'];
		$data_array['email'] =$data['email'];
		$data_array['phone']=$data['mobile'];
		$data_array['productinfo']=$data['productinfo'];
	    $data_array['amount'] =$data['amount'];
		$data_array['user_type']='R';*/
		
		if(!empty($data) && $txnid!=''){
			
	  //  $data_array['examsession']=$data['examsession'];
		
		if($data['productinfo']=="Re-Registration"){
	  /////////////////////////////////////////////////////////		
		$data_array['student_id']=$data['stud_id'];
		$data_array['txtid'] =$txnid;
		$data_array['firstname'] =$data['firstname'];
		$data_array['registration_no'] =$data['udf3'];
		$data_array['academic_year']=$data['udf2'];
		$data_array['email'] =$data['email'];
		$data_array['phone']=$data['mobile'];
		$data_array['productinfo']=$data['productinfo'];
	    $data_array['amount'] =$data['amount']-$data['udf6'];
		$data_array['pending_amount'] ='';
		$data_array['opening_amount_paid'] =$data['opeing_balnace'];
		$data_array['user_type']='R';
		$data_array['org_frm'] ='SU';
		$this->db->insert('online_payment_facilities',$data_array);
		////////////////////////////////////////////////////
		/*$DB2 = $this->load->database('umsdb', TRUE);
		$data_arrayl['student_id']=$data['stud_id'];
		$data_arrayl['txtid'] =$txnid;
		$data_arrayl['firstname'] =$data['firstname'];
		$data_arrayl['registration_no'] =$data['udf3'];
		$data_arrayl['academic_year']=$data['udf2'];
		$data_arrayl['email'] =$data['email'];
		$data_arrayl['phone']=$data['mobile'];
		$data_arrayl['productinfo']='Late_fee';
	    $data_arrayl['amount'] =$data['udf6'];
		$data_arrayl['user_type']='R';
		$DB2->insert('online_payment',$data_arrayl);*/
		}else{
		$data_array['student_id']=$data['stud_id'];
		$data_array['txtid'] =$txnid;
		$data_array['firstname'] =$data['firstname'];
		$data_array['registration_no'] =$data['udf3'];
		$data_array['academic_year']=C_RE_REG_YEAR;
		$data_array['email'] =$data['email'];
		$data_array['phone']=$data['mobile'];
		$data_array['productinfo']=$data['productinfo'];
	    $data_array['amount'] =$data['amount'];
		$data_array['pending_amount'] ='';
		$data_array['org_frm'] ='SU';
		$data_array['facility_id'] =4;
		$data_array['gym_subscription'] =$data['udf6'];
		$data_array['opening_amount_paid'] =$data['opeing_balnace'];
		$data_array['user_type']='R';
		$this->db->insert('online_payment_facilities',$data_array);
		}
		
		
		return $this->db->insert_id(); 
	    }
		else{
			
			return 0;
		}
	}
	
	
	
	function insert_data_in_trans_hostel_pending($data=array(),$txnid=''){
		//$DB1 = $this->load->database('umsdb', TRUE);
		//$DB1 = $this->load->database('umsdb', TRUE);
		$data_array=array();$data_arrayl=array();
		
		/*$data_array['student_id']=$data['stud_id'];
		$data_array['txtid'] =$txnid;
		$data_array['firstname'] =$data['firstname'];
		$data_array['registration_no'] =$data['udf3'];
		$data_array['academic_year']=$data['udf2'];
		$data_array['email'] =$data['email'];
		$data_array['phone']=$data['mobile'];
		$data_array['productinfo']=$data['productinfo'];
	    $data_array['amount'] =$data['amount'];
		$data_array['user_type']='R';*/
		
		if(!empty($data) && $txnid!=''){
			
	  //  $data_array['examsession']=$data['examsession'];
		
		if($data['productinfo']=="Re-Registration"){
	  /////////////////////////////////////////////////////////		
		$data_array['student_id']=$data['stud_id'];
		$data_array['txtid'] =$txnid;
		$data_array['firstname'] =$data['firstname'];
		$data_array['registration_no'] =$data['udf3'];
		$data_array['academic_year']=$data['udf2'];
		$data_array['email'] =$data['email'];
		$data_array['phone']=$data['mobile'];
		$data_array['productinfo']=$data['productinfo'];
	    $data_array['amount'] =$data['amount']-$data['udf6'];
		$data_array['pending_amount'] ='';
		$data_array['opening_amount_paid'] =$data['opeing_balnace'];
		$data_array['user_type']='R';
		$data_array['org_frm'] ='SU';
		$this->db->insert('online_payment_facilities',$data_array);
		////////////////////////////////////////////////////
		/*$DB2 = $this->load->database('umsdb', TRUE);
		$data_arrayl['student_id']=$data['stud_id'];
		$data_arrayl['txtid'] =$txnid;
		$data_arrayl['firstname'] =$data['firstname'];
		$data_arrayl['registration_no'] =$data['udf3'];
		$data_arrayl['academic_year']=$data['udf2'];
		$data_arrayl['email'] =$data['email'];
		$data_arrayl['phone']=$data['mobile'];
		$data_arrayl['productinfo']='Late_fee';
	    $data_arrayl['amount'] =$data['udf6'];
		$data_arrayl['user_type']='R';
		$DB2->insert('online_payment',$data_arrayl);*/
		}else{
		$data_array['student_id']=$data['stud_id'];
		$data_array['txtid'] =$txnid;
		$data_array['firstname'] =$data['firstname'];
		$data_array['registration_no'] =$data['udf3'];
		$data_array['academic_year']=C_RE_REG_YEAR;
		$data_array['email'] =$data['email'];
		$data_array['phone']=$data['mobile'];
		$data_array['productinfo']=$data['productinfo'];
	    $data_array['amount'] =$data['amount'];
		$data_array['org_frm'] ='SU';
		$data_array['pending_amount'] ='';
		$data_array['facility_id'] =1;
		$data_array['gym_subscription'] =0;
		$data_array['opening_amount_paid'] =$data['amount'];
		$data_array['user_type']='R';
		$this->db->insert('online_payment_facilities',$data_array);
		}
		
		
		return $this->db->insert_id(); 
	    }
		else{
			
			return 0;
		}
	}

function insert_data_in_trans_causion($data=array(),$txnid=''){

		$DB1 = $this->load->database('umsdb', TRUE);
		$data_array=array();$data_arrayl=array();
		//print_r($data);
		
		if(!empty($data) && $txnid!=''){
			
	  //  $data_array['examsession']=$data['examsession'];
		
		if($data['productinfo']=="causion_money"){
	  /////////////////////////////////////////////////////////		
		$data_array['student_id']=$data['stud_id'];
		$data_array['txtid'] =$txnid;
		$data_array['firstname'] =$data['firstname'];
		$data_array['registration_no'] =$data['udf3'];
		$data_array['academic_year']=C_RE_REG_YEAR;
		$data_array['email'] =$data['email'];
		$data_array['phone']=$data['mobile'];
		$data_array['productinfo']=$data['productinfo'];
	    $data_array['amount'] =$data['amount'];
		$DB1->insert('online_payment',$data_array);	
		}else{

		}
		//echo $DB1->last_query();exit;
		
		return $DB1->insert_id(); 
	    }
		else{
			
			return 0;
		}
	}

function Update_recepit($recepit,$txnid){
	
	$DB1 = $this->load->database('umsdb', TRUE);
	$fdet['receipt_no']=$receipt_no;
	
	$DB1->where('payment_id', $txnid);
	$DB1->update('online_payment',$fdet); 
}

function Update_Manually_Status($payment_id,$recepit_no,$txtid,$email,$productinfo,$amount,$bank_ref_num,$main_status,$payment_date){
	$DB1 = $this->load->database('umsdb', TRUE);
	//echo '<br>';
	if(empty($payment_id)){
	 $pay_id = substr($recepit_no, 6);
	}else{
		$pay_id = $payment_id;
	}
	//echo '<br>';
	$fdet['receipt_no']=$recepit_no;
	$fdet['bank_ref_num']=$bank_ref_num;
	$fdet['payment_date']=$payment_date;
	$fdet['payment_status']=$main_status;
	
	$DB1->where('txtid', $txtid);
	$DB1->where('email', $email);
    $DB1->where('payment_id', $pay_id);
	
	//$DB1->update('online_payment',$fdet); 
//echo	$DB1->last_query();
	//echo $recepit_no;
	  echo  $sql = "select * from online_payment where payment_id='".$pay_id."'";
	   $query = $DB1->query($sql);

//echo "select concat(first_name,' ',middle_name,' ',last_name) as sname,email from student_master where enrollment_no='".$_SESSION['name']."'";
		$result=$query->row_array();
	//	var_dump($result);
	//	exit(0);
		return $result;
}

function get_online_list(){
	$DB1 = $this->load->database('umsdb', TRUE);
	   $sql = "select * FROM online_payment where payment_id>=33880 AND productinfo='Re-Registration'";
	   $query = $DB1->query($sql);

//echo "select concat(first_name,' ',middle_name,' ',last_name) as sname,email from student_master where enrollment_no='".$_SESSION['name']."'";
		$result=$query->result_array();
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
     /*	$DB1->select("*");
		$DB1->from('online_payment');
		$DB1->where("receipt_no",$data['udf1']);	  
					
		$query=$DB1->get();
	
//echo $DB1->last_query();
		$result=$query->row_array();
		if($result['receipt_no']!='')
    {
    }
    else*/
    {
    // $fdet['txtid']=$data['txnid'];
     $fdet['receipt_no']=$data['udf1'];
     //$fdet['registration_no']=$data['udf3'];
     //$fdet['firstname']=$data['firstname'];
     //$fdet['email']=$data['email'];
    // $fdet['phone']=$data['udf4'];
    // $fdet['productinfo']=$data['productinfo'];
     $fdet['amount']=$data['amount'];
     $fdet['payment_date']=$data['addedon'];
     $fdet['payment_status']=$data['status'];
     $fdet['error_code']=$data['error'];
     $fdet['pg_type']=$data['PG_TYPE'];
     $fdet['payment_mode']=$data['mode'];
     $fdet['bank_ref_num']=$data['bank_ref_num'];
     $fdet['error_message']=$data['error_Message'];
   //  $fdet['academic_year']=$data['udf2'];
    // $fdet['user_type']=$data['udf5'];
   
  
       $DB1->where('txtid', $data['txnid']); 
       $DB1->where('registration_no', $data['udf3']); 
	   $DB1->where('student_id', $data['udf5']);
	  // $DB1->where('email', $data['email']);
	   /////////////////////////////////////////////////////////
       $DB1->update('online_payment',$fdet);
	   
    }
    //   echo $DB1->last_query();
    //   echo 'Y';
/*    
    $values="('".$txnid."','".$receipt."','".$formno."','".$_POST['firstname']."','".$_POST['email']."','".$_POST['phone']."','".$_POST['productinfo']."','".$_POST['amount']."','".$_POST['addedon']."','".$_POST['status']."','".$_POST['error']."'
,'".$_POST['PG_TYPE']."','".$_POST['mode']."','".$_POST['bank_ref_num']."','".$_POST['error_Message']."')";
	$gh=$conn->prepare("insert into online_payment (txtid,receipt_no,registration_no,firstname,email,phone,productinfo,amount,payment_date,payment_status,error_code,pg_type,payment_mode,bank_ref_num,error_message) values ".$values);

*/
    
}


function add_online_feedetails_gym($data)
{ 
    //echo $data['hash'];
   // var_dump($data);
    //exit();
      $DB1 = $this->load->database('umsdb', TRUE);
     /*	$DB1->select("*");
		$DB1->from('online_payment');
		$DB1->where("receipt_no",$data['udf1']);	  
					
		$query=$DB1->get();
	
//echo $DB1->last_query();
		$result=$query->row_array();
		if($result['receipt_no']!='')
    {
    }
    else*/
    {
    // $fdet['txtid']=$data['txnid'];
     $fdet['receipt_no']=$data['udf1'];
     //$fdet['registration_no']=$data['udf3'];
     //$fdet['firstname']=$data['firstname'];
     //$fdet['email']=$data['email'];
    // $fdet['phone']=$data['udf4'];
    // $fdet['productinfo']=$data['productinfo'];
   //  $fdet['amount']=$data['amount'];
     $fdet['payment_date']=$data['addedon'];
     $fdet['payment_status']=$data['status'];
     $fdet['error_code']=$data['error'];
     $fdet['pg_type']=$data['PG_TYPE'];
     $fdet['payment_mode']=$data['mode'];
     $fdet['bank_ref_num']=$data['bank_ref_num'];
     $fdet['error_message']=$data['error_Message'];
   //  $fdet['academic_year']=$data['udf2'];
    // $fdet['user_type']=$data['udf5'];
   
  
       $this->db->where('txtid', $data['txnid']); 
       $this->db->where('registration_no', $data['udf3']); 
	   $this->db->where('student_id', $data['udf5']);
	  // $DB1->where('email', $data['email']);
	   /////////////////////////////////////////////////////////
       $this->db->update('online_payment_facilities',$fdet);
	   return true;
	   
    }
    //   echo $DB1->last_query();
    //   echo 'Y';
/*    
    $values="('".$txnid."','".$receipt."','".$formno."','".$_POST['firstname']."','".$_POST['email']."','".$_POST['phone']."','".$_POST['productinfo']."','".$_POST['amount']."','".$_POST['addedon']."','".$_POST['status']."','".$_POST['error']."'
,'".$_POST['PG_TYPE']."','".$_POST['mode']."','".$_POST['bank_ref_num']."','".$_POST['error_Message']."')";
	$gh=$conn->prepare("insert into online_payment (txtid,receipt_no,registration_no,firstname,email,phone,productinfo,amount,payment_date,payment_status,error_code,pg_type,payment_mode,bank_ref_num,error_message) values ".$values);

*/
    
}


public function received_payment_details($stdid='')
{
	$DB2 = $this->load->database('icdb', TRUE);
$DB2->select('pfd.*,smd.student_name,smd.provisional_admission,smd.mobile1,bm.bank_name,pad.prov_reg_no,pad.admission_year');
$DB2->from('provisional_fees_details pfd');
$DB2->join('provisional_admission_details pad','pfd.student_id=pad.adm_id','left');
$DB2->join('student_meet_details smd','pfd.student_id=smd.id','left');
$DB2->join('bank_master bm','pfd.bank_id=bm.bank_id','left');
$DB2->where('pad.prov_reg_no is not null');
if($_POST['pstatus'] !='')
{
$DB2->where('pfd.payment_status',$_POST['pstatus']);   
}

if($stdid !='')
{
$DB2->where('pfd.student_id',$stdid);   
}

$DB2->order_by('fees_id','desc');

//$this->db->where('center_type','ic');
//$this->db->where('status','Y');
$query =$DB2->get();
$result = $query->result_array();
return $result;


} 
function getFeesdata_ic($payid=''){
		    $DB2 = $this->load->database('icdb', TRUE);
		$DB2->select("*");
		$DB2->from('online_payment');
		$DB2->where("payment_status",'success');	  
	if($payid!='')
	{
	  	$DB2->where("payment_id",$payid);	    
	}
		//$DB2->where("verification_status","N");	 
		//$DB2->where("is_deleted","N");	   
	
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		//	$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		
		//	$DB1->where("sm.admission_stream",$streamid);	    
		
		//	$DB1->where("sm.admission_year", $year);	   	    
	
		$DB2->order_by("payment_id", "desc");
		$query=$DB2->get();
		/*  echo $this->db->last_query();
		die();  */ 
		$result=$query->result_array();
	//	 echo $DB1->last_query();
	//	 exit(0);
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
	
	public function get_details($recepit){
		$DB=$this->load->database('umsdb',true);
		$sql="select vw.`school_name`,vw.`course_short_name`,vw.`stream_name`,s.*,op.* from online_payment as op 
		LEFT JOIN enquiry_student_master as s ON s.enquiry_id=op.student_id AND s.mobile=op.phone
		LEFT JOIN `vw_stream_details` AS vw ON vw.stream_id=s.stream_id
		where op.payment_id='$recepit'";
		$query=$DB->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
	public function get_details_int($recepit){
		$DB=$this->load->database('umsdb',true);
		$sql="select vw.`school_name`,vw.`course_short_name`,vw.`stream_name`,s.*,op.* from 


online_payment_international as op 
		LEFT JOIN  student_master as s ON s.passport_no=op.passport
		LEFT JOIN `vw_stream_details` AS vw ON vw.stream_id=s.admission_stream
		where op.payment_id='$recepit'";
		$query=$DB->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
	
	public function get_details_mba($recepit){
		$DB=$this->load->database('umsdb',true);
		$sql="select s.name as first_name,s.mobile as phone,op.* from `sandipun_admin`.`online_payment_edu` as op 
		LEFT JOIN `sandipun_admin`.`apply_studnet` as s ON s.mobile=op.phone
		
		where op.payment_id='$recepit'";
		$query=$DB->query($sql);
		$result=$query->result_array();
		return $result;
	}
	public function get_details_sujee($recepit){
		$DB=$this->load->database('umsdb',true);
		$sql="select op.firstname as first_name,op.* from `sandipun_ic_erp22`.`online_payment` as op 
		LEFT JOIN `sandipun_ic_erp22`.`su_jee_registration` as s ON s.student_id=op.student_id
		
		where op.payment_id='$recepit'";
		$query=$DB->query($sql);
		$result=$query->result_array();
		return $result;
	}	
	public function get_details_register($recepit){
		$DB=$this->load->database('umsdb',true);
		$sql="select vw.`school_name`,vw.`course_short_name`,vw.`stream_name`,s.*,op.* from online_payment as op 
		LEFT JOIN  student_master as s ON s.stud_id=op.student_id
		LEFT JOIN `vw_stream_details` AS vw ON vw.stream_id=s.admission_stream
		where op.payment_id='$recepit'";
		$query=$DB->query($sql);
		$result=$query->result_array();
		return $result;
	}

function students_data($data)
	{
		$this->db->select("sm.current_year,sm.mobile,sm.admission_session,sm.first_name,sm.middle_name,sm.last_name,sm.academic_year,sm.enrollment_no,sm.stud_id,
		sm.admission_stream,vw.stream_short_name as stream_name,vw.course_short_name as course_name, vw.school_short_name as school_name,");
		$this->db->from("sandipun_ums.student_master sm");
		
		$this->db->join("sandipun_ums.vw_stream_details vw", "sm.admission_stream = vw.stream_id");
		$this->db->where('sm.enrollment_no', $data['enrollment_no']);
		$this->db->or_where('sm.enrollment_no_new', $data['enrollment_no']);
        $this->db->where("sm.admission_cycle IS NULL");
		$query1 = $this->db->get();
		//echo $this->db->last_query();
			return $query1->row_array();
	
		
		
	}


function fee_details($data){
	
	    $this->db->select("*");
		$this->db->from("sandipun_ums.academic_fees");
		
		//$this->db->join("sandipun_ums.vw_stream_details vw", "sm.admission_stream = vw.stream_id");
		//$this->db->where('sm.enrollment_no', $data['enrollment_no']);
		//$this->db->or_where('sm.enrollment_no_new', $data['enrollment_no']);
        $this->db->where('stream_id',$data['admission_stream']);
		
		if($data['admission_year']==2020){
			
		$this->db->where('year',$data['curr_yr']);
		$this->db->where('admission_year',$data['admission_year']);	
		$this->db->where('academic_year','2020-21');
		}else{
		$this->db->where('admission_year',$data['admission_year']);	
		$this->db->where('academic_year','2020-21');	
		}
		
		
		$query1 = $this->db->get();
		//echo $this->db->last_query();
			return $query1->result_array();
	
}



function save_slot($data){
	
	
	    echo $emp_id = $this->session->userdata("name"); echo '<br>';
		echo $role_id = $this->session->userdata('role_id');  echo '<br>';
		echo $uId=$this->session->userdata('uid'); echo '<br>';
	
	
	$fdet['enroll']=$data['enroll'];
	$fdet['student_id']=$data['student_id'];
	$fdet['curr_yr']=$data['curr_yr'];
	$fdet['admission_year']=$data['admission_year'];
	$fdet['academic_year']=$data['academic_year'];
	$fdet['admission_stream']=$data['admission_stream'];
	$fdet['applicable_fee']=$data['applicable_fee'];
	$fdet['slot']=$data['Slot'];
	if($data['Slot']==3){
		$fee_Slot="35%";
	}elseif($data['Slot']==1){
		$fee_Slot="50%";
	}elseif($data['Slot']==13){
		$fee_Slot="BOTH";
	}
	$fdet['fee_Slot']=$fee_Slot;
	$fdet['approvestatus']=$data['ApproveStatus'];
	$fdet['remark']=$data['remark'];
	
	
	$fdet['created_by']=$emp_id;
	$fdet['created_on']=date('Y-m-d h:i:s');
	
	$this->db->insert('sandipun_ums.fee_slot',$fdet);
	//$fdet['modified_by']=$data['addedon'];
	//$fdet['modified_on']=$data['addedon'];
	
}
function check_payment_status($stud,$academic_year){
	 $DB1 = $this->load->database('umsdb', TRUE);
    //	$DB1->select("concat(first_name,' ',middle_name,' ',last_name) as sname,email");
	//	$DB1->from("student_master");
	//	$DB1->where("enrollment_no",$_SESSION['name']);	 
		
		$sql = "SELECT * FROM online_payment WHERE payment_status='' AND payment_date IS NULL and student_id='$stud' and academic_year='$academic_year'";
	    $query = $DB1->query($sql);

//echo "select concat(first_name,' ',middle_name,' ',last_name) as sname,email from student_master where enrollment_no='".$_SESSION['name']."'";
		$result=$query->row_array();
	//	var_dump($result);
	//	exit(0);
		return $result;
}
function get_stud_exams($stud,$admission_cycle){
	 $DB1 = $this->load->database('umsdb', TRUE);
    //	$DB1->select("concat(first_name,' ',middle_name,' ',last_name) as sname,email");
	//	$DB1->from("student_master");
	//	$DB1->where("enrollment_no",$_SESSION['name']);	 
		if(!empty($admission_cycle)){
			$tble="phd_exam_details";
			$tble2="phd_exam_session";
		}else{
			$tble="exam_details";
			$tble2="exam_session";
		}
		$sql = "SELECT e.*,s.exam_month,s.exam_year FROM $tble e 
		join $tble2 s on e.exam_id=s.exam_id WHERE e.stud_id='$stud' order by e.exam_id asc";
	    $query = $DB1->query($sql);

//echo "select concat(first_name,' ',middle_name,' ',last_name) as sname,email from student_master where enrollment_no='".$_SESSION['name']."'";
		$result=$query->result_array();
	//	var_dump($result);
	//	exit(0);
		return $result;
}
function student_hostelpayment_history($name){
		
$sql="SELECT fd.*,op.txtid,op.registration_no,op.productinfo,op.bank_ref_num,
op.payment_status,op.`verification_status`,op.amount AS payamount,fc.fees_id as challan_id,fc.fees_paid_type
FROM `sf_fees_details` AS fd
LEFT JOIN `sf_fees_challan` AS fc on fd.student_id=fc.student_id and fd.college_receiptno=fc.exam_session
LEFT JOIN online_payment_facilities AS op ON fd.`receipt_no`=op.`bank_ref_num` AND op.`bank_ref_num`!=''
WHERE fd.`enrollment_no` = '$name' and fd.type_id='1' 
ORDER BY fd.`fees_id` DESC
";

		$query=$this->db->query($sql);
		//echo $this->db->last_query();exit;
		$result=$query->result_array();
		return $result;
	}
function student_transportpayment_history($name){
		
$sql="SELECT fd.*,op.txtid,op.registration_no,op.productinfo,op.bank_ref_num,
op.payment_status,op.`verification_status`,op.amount AS payamount,fc.fees_id as challan_id,fc.fees_paid_type
FROM `sf_fees_details` AS fd
LEFT JOIN `sf_fees_challan` AS fc on fd.student_id=fc.student_id and fd.college_receiptno=fc.exam_session
LEFT JOIN online_payment_facilities AS op ON fd.`receipt_no`=op.`bank_ref_num` AND op.`bank_ref_num`!=''
WHERE fd.`enrollment_no` = '$name' and fd.type_id='2'
ORDER BY fd.`fees_id` DESC
";

		$query=$this->db->query($sql);
		//echo $this->db->last_query();exit;
		$result=$query->result_array();
		return $result;
	}	
function student_uniform_history($name,$stud_id){
		
$sql="select * from online_payment_facilities AS op 
WHERE op.`student_id` = '$stud_id' and op.productinfo='Uniform' and org_frm='SU'and payment_status='success'";

		$query=$this->db->query($sql);
		//echo $this->db->last_query();exit;
		$result=$query->result_array();
		return $result;
	}	
////////////////////////////////////////////////////////////////////////////////////////////////

public function Get_hostel_pending(){
 $DB1 = $this->load->database('umsdb', TRUE);
 $sql = "SELECT 
SUM(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees-f.excemption_fees) AS appl, COALESCE(a.fees_paid,0) AS fees_paid,COALESCE(rf.refund_paid,0) AS refund, 
SUM(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees-f.excemption_fees)- (COALESCE(a.fees_paid, 0) - COALESCE(rf.refund_paid, 0)) AS pending_fees
FROM sandipun_erp.sf_student_facilities f 
#INNER JOIN sandipun_erp.sf_student_facility_allocation af ON af.enrollment_no=f.enrollment_no AND f.academic_year=af.academic_year 

LEFT JOIN (SELECT enrollment_no,student_id,academic_year,SUM( amount ) AS refund_paid
 FROM sandipun_erp.sf_fees_refunds 
WHERE is_deleted='N' AND type_id='1' AND enrollment_no ='".$_SESSION['name']."' GROUP BY enrollment_no) rf 
ON rf.enrollment_no=f.enrollment_no AND rf.student_id=f.student_id 

LEFT JOIN (SELECT enrollment_no,student_id,academic_year,SUM( amount ) AS fees_paid,SUM(exam_fee_fine) AS fine,college_receiptno,type_id
 FROM sandipun_erp.sf_fees_details 
WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='1' AND enrollment_no ='".$_SESSION['name']."' GROUP BY enrollment_no) a 
ON a.enrollment_no=f.enrollment_no AND a.student_id=f.student_id 

INNER JOIN sandipun_ums.student_master s ON (s.enrollment_no=f.enrollment_no OR s.enrollment_no_new=f.enrollment_no) AND s.stud_id=f.student_id 

WHERE f.sffm_id=1 AND f.status='Y' AND f.cancelled_facility='N'   AND f.enrollment_no ='".$_SESSION['name']."'
#AND af.is_active='Y'
GROUP BY f.enrollment_no";

$query = $DB1->query($sql);

//echo "select concat(first_name,' ',middle_name,' ',last_name) as sname,email from student_master where enrollment_no='".$_SESSION['name']."'";
		$result=$query->row_array();
	//	var_dump($result);
	//	exit(0);
		return $result;
}

public function Get_causion_pending(){
 $DB1 = $this->load->database('umsdb', TRUE);
 $sql = "SELECT 
SUM(current_pay) AS causion_money from sandipun_ums.university_caution 
WHERE enrollment_no ='".$_SESSION['name']."'
GROUP BY enrollment_no";

$query = $DB1->query($sql);

$result=$query->row_array();
//	var_dump($result);
//	exit(0);
return $result;
}
function insert_exam_fees($data=array(),$txnid=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$data_array=array();$data_arrayl=array();
		if(!empty($data) && $txnid!=''){
			
	    $data_array['examsession']=$data['udf2'];
		$data_array['student_id']=$data['stud_id'];
		$data_array['txtid'] =$txnid;
		$data_array['firstname'] =$data['firstname'];
		$data_array['registration_no'] =$data['udf3'];
		//$data_array['exam_id']=$data['udf2'];
		$data_array['email'] =$data['email'];
		$data_array['phone']=$data['mobile'];
		$data_array['productinfo']=$data['productinfo'];
	    $data_array['amount'] = $data['applicable_fee'];
	    $data_array['degree_convocation_fees'] = $data['degree_convocation_fees'];
	    $data_array['academic_year'] =$data['academic_year'];
		//$data_array['pending_amount'] =$data['udf5'];
		//$data_array['opening_amount_paid'] =$data['opeing_balnace'];
		$data_array['user_type']='R';
		$DB1->insert('online_payment',$data_array);
		//echo $DB1->last_query();exit;
		return $DB1->insert_id(); 
	    }
		else{
			
			return 0;
		}
	}	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function check_reddy_students()
{
      $DB1 = $this->load->database('umsdb', TRUE);
    //	$DB1->select("concat(first_name,' ',middle_name,' ',last_name) as sname,email");
	//	$DB1->from("student_master");
	//	$DB1->where("enrollment_no",$_SESSION['name']);	 
		
		   /* $sql = "SELECT student_id FROM sandipun_ic_erp22.admission_benefits_and_source WHERE is_for=1 AND academic_year='2023-24' AND benefit_to IN ('5229','478080','478081','478126','478138','478158','478177','478178','478198','478325','478334','478386','478447','478523','4015','4101','4856','5019','5025','5026','5028','478255','478256','478288','478290','478424','478791','478807')";
			$query = $this->db->query($sql); */
			
			$sql = "SELECT stud_id as student_id FROM student_master WHERE package_name='reddy' and admission_confirm='Y' and cancelled_admission='N'";
			$query = $DB1->query($sql);
	   //echo $DB1->last_query();exit;

//echo "select concat(first_name,' ',middle_name,' ',last_name) as sname,email from student_master where enrollment_no='".$_SESSION['name']."'";
		$result=$query->result_array();
	//	var_dump($result);
	//	exit(0);
		return $result;
}
}