<?php
class Fees_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
       
      
    }
    
    function  get_college_details()
    {
        $col = $this->session->userdata('name');
		$ex = explode("_",$col);
		if($ex[0]!='sf'){
			$whr = ' and college_name = "'.strtoupper($ex[0]).'"';
		}else{
			$whr = '';
		}
        $sql="select DISTINCT(college_name) as college_name From sf_program_detail where active='Y' $whr";
        $query = $this->db->query($sql);
        return $query->result_array();
    } 
	function  get_course_name_bycollegeid($cid)
    {
          $DB1 = $this->load->database('umsdb', TRUE); 
        if($cid == 'SU'){
             $sql="select DISTINCT(course_short_name) as course_name From vw_stream_details where is_active='Y'  ";
             $query = $DB1->query($sql);
        }else{
             $sql="select DISTINCT(course_name) as course_name From sf_program_detail where active='Y' and college_name = '".$cid."' ";
         $query = $this->db->query($sql);
                
        }
       
        return $query->result_array();
    } 
   
	function get_branch_name($colid,$crs){
	    
	     $DB1 = $this->load->database('umsdb', TRUE); 
        if($colid == 'SU'){
             $sql="select stream_short_name as branch_name, stream_id as sf_program_id From vw_stream_details where is_active='Y' and course_short_name = '".urldecode($crs)."'  ";
             $query = $DB1->query($sql);
        }else{
	    
		$sql="select * From sf_program_detail where active='Y' and college_name = '".$colid."' and course_name = '".$crs."' ";
        $query = $this->db->query($sql);
        }
        return $query->result_array();
	}
	
	
	
	
    function add_uniform_details($data){
       // print_r($data);
       // exit();
		$arr = array();
		$y = date('Y')."-".date('y',strtotime('+1 year'));
	$arr['academic_year'] = $y;
	$arr['college_code'] = $data['college_name'];
	$arr['program_id'] = $data['branch_name'];
	$arr['receipt_no'] = $data['rec_no'];
	$arr['reg_no'] = $data['reg_no'];
	$arr['student_name'] = $data['name'];
	$arr['course_year'] = $data['course_year'];
	$arr['fees_type'] = $data['fees_type'];
	$arr['paid_by'] = $data['fees_paid'];
	$arr['paid_date'] = date('Y-m-d',strtotime($data['fees_date']));
	$arr['amount'] = $data['fees_amt'];
	$arr['bank_name'] = $data['bank_name'];
	$arr['bank_city'] = $data['bank_city'];
	$arr['remark']=$data['remark'];
    $arr['entry_by']= $this->session->userdata("uid");
	$arr['entry_date']= date('Y-m-d',strtotime($data['entry_date']));
	//echo "<pre>";
	//print_r($arr);exit;
//$arr['entry_date']= date("Y-m-d H:i:s");
$arr['entry_ip']=  $this->input->ip_address();
		$ins=$this->db->insert('sf_fees_details',$arr);
	//	echo $this->db->last_query();
		return $ins;
	}
    function  get_form_details($college_name='',$cour='',$bran='',$year='', $srchdate='')
    {       
         $DB1 = $this->load->database('umsdb', TRUE); 
	    $col = $this->session->userdata('name');
		$ex = explode("_",$col);
		//echo $ex[0];
		if($ex[0]!='sf'){
			$whr = ' sf.college_code = "'.strtoupper($ex[0]).'"';
		}else{
			$whr = '1';
		}
        if($college_name!="")
        {
            $where.=" AND sf.college_code='".$college_name."'";
        }
		if($cour!="")
        {
            
            if($ex[0] == 'su'){
            $str="select stream_id From  vw_stream_details  where is_active='Y' and course_short_name = '".$cour."'  ";
           //exit;
            $where.=" AND sf.program_id IN (".$str.")";
        }elseif($ex[0] == 'sf' && $college_name == 'SU'){
            $str="select stream_id From  vw_stream_details  where is_active='Y' and course_short_name = '".$cour."'  ";
           //exit;
            $where.=" AND sf.program_id IN (".$str.")";
        }else{
            
			$str = 'select sf_program_id From sf_program_detail where active="Y" and college_name = "'.$college_name.'" and course_name = "'.$cour.'"';
          $where.=" AND sf.program_id IN (".$str.")";
        }
          
        }
		if($bran!="")
        {
            $where.=" AND sf.program_id='".$bran."'";
        }
        if($year!="")
        {
            $where.=" AND sf.course_year='".$year."'";
        }
		if($srchdate!="")
        {
            $where.=" AND sf.entry_date LIKE '%".$srchdate."%'";
        }
        //echo $ex[0];
        	if($ex[0] == 'su'){
          $sql="select sf.sf_fees_id,sf.course_year as course_year1,sf.college_code,sf.receipt_no,sf.program_id,sf.reg_no,sf.student_name as name,sf.bank_name as bankname,sf.paid_by as paid_by,sf.receipt_no,sf.paid_date,sf.amount,vd.stream_short_name as branchname, vd.stream_id as sf_program_id,vd.course_short_name as course_name1,vd.stream_short_name as branch_name From sandipun_erp.sf_fees_details as sf  INNER JOIN vw_stream_details as vd on vd.stream_id = sf.program_id where $whr $where  ";
           //exit;
             $query = $DB1->query($sql);
        }else{
        $sql = "select sf.sf_fees_id,sf.course_year as course_year1,sf.college_code,sf.receipt_no,sf.program_id,sf.reg_no,sf.student_name as name,sf.bank_name as bankname,sf.paid_by as paid_by,sf.receipt_no,sf.paid_date,sf.amount,sfd.course_name as course_name1,sfd.branch_name as branchname,sfd.branch_short_name as branch_short_name From sf_fees_details as sf inner join sf_program_detail as sfd ON sfd.sf_program_id = sf.program_id where $whr $where ";
        //exit();
		$query = $this->db->query($sql);
        }
        
        //echo $sql;exit;
    
        return $query->result_array();
    }
    
    function get_su_course_name($id){
         $DB1 = $this->load->database('umsdb', TRUE); 
          $sql="select course_short_name as course_name, stream_short_name as branch_name From vw_stream_details where is_active='Y' and stream_id = '".$id."' ";
             $query = $DB1->query($sql);
              return $query->result_array();
    }
    function get_search_report_details($cn,$dt,$colnam){
        $DB1 = $this->load->database('umsdb', TRUE); 
         $col = $this->session->userdata('name');
		$ex = explode("_",$col);
		if($ex[0]!='sf'){
			$whr = ' sf.college_code = "'.strtoupper($ex[0]).'"';
		}
		if(!empty($dt)){
		    $dt = ' AND sf.paid_date = "'.date('Y-m-d',strtotime($dt)).'"';
		}
		if($cn == 'cn'){
		    $gp = 'GROUP BY sf.program_id,sf.course_year ';
		}elseif($cn =='d'){
		    $gp = 'GROUP BY sf.paid_date,sf.course_year';
		}
		if($ex[0]=='sf'){
		if(!empty($colnam)){
			$whr1 = ' sf.college_code = "'.strtoupper($colnam).'"';
		}else{
			$whr1 = '1';
		}
		
		}
	//	echo $ex[0];
		if($ex[0] == 'su'){
            $sql="select sf.sf_fees_id,sf.course_year as course_year1,sf.college_code,sf.program_id,sf.paid_date,sf.amount,vd.stream_short_name as branchname, vd.stream_id as sf_program_id,vd.course_short_name as course_name1,vd.stream_short_name as branch_name,count(sf.student_name) as scnt,SUM(sf.amount) as am From sandipun_erp.sf_fees_details as sf  INNER JOIN vw_stream_details as vd on vd.stream_id = sf.program_id where $whr  $dt $gp ORDER BY sf.college_code,vd.course_short_name,sf.course_year ASC ";
           //exit;
             $query = $DB1->query($sql);
        }elseif($ex[0] == 'sf' && $college_name == 'SU'){
        	$sql="select sf.sf_fees_id,sf.course_year as course_year1,sf.college_code,sf.program_id,sf.paid_date,sf.amount,vd.stream_short_name as branchname, vd.stream_id as sf_program_id,vd.course_short_name as course_name1,vd.stream_short_name as branch_name,count(sf.student_name) as scnt,SUM(sf.amount) as am From sandipun_erp.sf_fees_details as sf  INNER JOIN vw_stream_details as vd on vd.stream_id = sf.program_id where $whr  $dt $gp ORDER BY sf.college_code,vd.course_short_name,sf.course_year ASC ";
           //exit;
             $query = $DB1->query($sql);
        }else{
         $sql = "select sf.sf_fees_id,sf.course_year as course_year1,sf.college_code,sf.program_id,sf.paid_date,sf.amount,sfd.course_name as course_name1,sfd.branch_name as branchname,sfd.branch_short_name as branch_short_name,count(sf.student_name) as scnt,SUM(sf.amount) as am From sf_fees_details as sf inner join sf_program_detail as sfd ON sfd.sf_program_id = sf.program_id where $whr $whr1 $dt $gp ORDER BY sf.college_code,sfd.course_name,sf.course_year ASC";
        $query = $this->db->query($sql);
        }
        return $query->result_array();
    }

 public function get_fees_collection_admission(){
     	$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("s.stud_id,s.enrollment_no,s.first_name,s.middle_name,s.last_name,s.mobile,v.school_short_name,v.course_short_name, v.stream_short_name,s.admission_year,f.amount as paid,s.cancelled_admission, f.fees_paid_type,f.receipt_no as ddno,f.amount ,date_format(f.fees_date,'%d-%m-%Y') as fdate,f.college_receiptno,f.chq_cancelled ,f.remark,b.bank_name,b.bank_short_name,s.cancelled_admission ,d.actual_fee,d.applicable_fee");
		$DB1->from('student_master as s');
		$DB1->join('admission_details as d','s.stud_id = d.student_id','left');
		$DB1->join('vw_stream_details as v','s.admission_stream = v.stream_id','left');
		$DB1->join('fees_details as f','f.student_id = s.stud_id','left');
		$DB1->join('bank_master as b','f.bank_id=b.bank_id' ,'left');
		$DB1->where('f.is_deleted ', 'N');
		$DB1->where('f.type_id ', '2');
	    $DB1->where('s.admission_session', '2019');
		$DB1->order_by("v.stream_name,s.enrollment_no_new", "asc");
		$query=$DB1->get();
	
		//echo $DB1->last_query();exit;
			$result=$query->result_array();
		return $result;
 }
   public function get_fees_statistics(array $data){
       if($data['get_by']=="course"){
           $sel="v.school_short_name,v.course_short_name as course,v.course_id";
           $grp="v.course_short_name";
       }
       else{
           $sel="v.school_short_name,v.stream_short_name as course,v.stream_id,ad.year as admission_year ";
           $grp="v.stream_short_name,admission_year";
           
       }
     $DB1 = $this->load->database('umsdb', TRUE);
     
     $sql="select  $sel,sum(ad.applicable_fee) as applicable_total ,sum(ad.actual_fee) as actual_fees,sum(f.amount) as fees_total,sum(f.charges) as cancel_charges,
        count(ad.student_id) as stud_total,sum(case when rf.amount is null then 0 else rf.amount end) as refund
        from admission_details ad left join vw_stream_details v on v.stream_id=ad.stream_id 
		join student_master s on s.stud_id=ad.student_id and ad.academic_year=s.academic_year and s.admission_confirm='Y'
        left join
        (
        select distinct student_id,academic_year,count(student_id)as total_count,sum( case when chq_cancelled='N' then amount else 0 end) as amount, sum( case when chq_cancelled='Y' then canc_charges else 0 end) as charges   from  fees_details where  is_deleted='N' and type_id='2'
        group by  student_id,academic_year
        
        ) f on ad.student_id=f.student_id and ad.academic_year=f.academic_year 
         left join fees_refunds rf on rf.student_id=ad.student_id
        where  ad.academic_year='".$data['academic_year']."' and ad.student_id in (SELECT stud_id FROM student_master WHERE academic_year='".$data['academic_year']."') 
         
        group by  $grp  ";
		//where  ad.academic_year='".$data['academic_year']."' and ad.student_id in (SELECT stud_id FROM student_master WHERE admission_session='".$data['academic_year']."')
        // where  ad.academic_year='".$data['academic_year']."' and ad.student_id in (SELECT stud_id FROM student_master WHERE admission_session='2017') 
        // where  ad.academic_year='".$data['academic_year']."' and ad.student_id in (SELECT stud_id FROM student_master WHERE admission_session='".$data['academic_year']."') 
        $query=$DB1->query($sql);
	//  echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;
     
 }
 public function get_streamwise_admission_fees($data){
     
   
     $DB1 = $this->load->database('umsdb', TRUE);
     if($data['get_by']=="stream"){
          $cond=" and sm.admission_stream='".$data['stream_id']."' and ad.year ='".$data['year']."'";
     }
     else
     {
         $cond="";
     }
     $sql="select sm.stud_id, sm.enrollment_no,sm.enrollment_no_new as new_prn,sm.first_name,sm.middle_name,sm.last_name,sm.mobile,sm.gender,v.school_short_name,v.stream_short_name as course,v.stream_id,ad.year as admission_year,sum(ad.applicable_fee) as applicable_total ,sum(ad.actual_fee) as actual_fees,sum(f.amount) as fees_total,sum(f.charges) as cancel_charges, count(ad.student_id) as stud_total ,ad.cancelled_admission,case when sum(rf.amount) is null then 0 else rf.amount end as refund from admission_details ad left join vw_stream_details v on v.stream_id=ad.stream_id 
     left join ( select distinct student_id,academic_year,count(student_id)as total_count,sum( case when chq_cancelled='N' then amount else 0 end) as amount,sum( case when chq_cancelled='Y' then canc_charges else 0 end) as charges from fees_details where is_deleted='N' and  type_id='2' group by student_id,academic_year) f on ad.student_id=f.student_id and ad.academic_year=f.academic_year left join student_master sm on sm.stud_id=ad.student_id 
     left join fees_refunds rf on rf.student_id=sm.stud_id
     where  ad.academic_year='".$data['academic_year']."' ".$cond." and sm.admission_session ='2017' group by sm.stud_id,course,v.stream_id,admission_year order by ad.cancelled_admission,sm.enrollment_no asc";
 
        $query=$DB1->query($sql);
	   //echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;
     
     
     
 }
 public function get_cancle_admission_details($row){
	 if($row==2020){return array('cancel_count'=>0);}else{
     	$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("count(distinct a.student_id) as cancel_count,sum(c.canc_fee) as cancel_fee");
		$DB1->from('admission_details as a');
		$DB1->join('admission_cancellations as c','c.stud_id=a.student_id','left');
		$DB1->where('a.cancelled_admission', 'Y');
		$DB1->where('a.academic_year',$row);
		
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
			$result=$query->result_array();
		return $result;
	 }
     
 }
 
 
		function pay_refund($data, $payfile){
		
		$DB1 = $this->load->database('umsdb', TRUE);
			//print_r($data);exit;
		
		//echo $payfile;exit;
		$feedet['student_id']=$data['stud_id'];
		$feedet['amount']=$data['paidfee'];
		$feedet['type_id']=2;
		$feedet['refund_paid_type']=$data['payment_type'];
	//	$feedet['academic_year']= date('Y');
					$feedet['academic_year']=$data['acyear'];
				
		$feedet['receipt_no']=$data['dd_no'];
		$feedet['refund_date']=$data['dd_date']; 
		$feedet['bank_id']=$data['dd_bank'];
		$feedet['bank_city']=$data['dd_bank_branch'];
			$feedet['remark']=$data['remark'];
		$feedet['refund_for']=$data['refund_type'];	
				$feedet['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['created_on']= date('Y-m-d h:i:s');
		$feedet['created_by']= $_SESSION['uid'];
		
			
			//$feedet['college_receiptno']=$data['clreceipt'];
		if($payfile !=''){
			$feedet['receipt_file']=$payfile;
		}
		//print_r($feedet);exit;
		$DB1->insert('fees_refunds',$feedet);
	//	echo $DB1->last_query();exit;
	  $this->session->set_flashdata('message1','Record Added Successfully');
		redirect('Account/fees_refund/');
		return true;
		
	}
	
		function stud_pay_refund($data, $payfile){
		
		$DB1 = $this->load->database('umsdb', TRUE);
			//print_r($data);exit;
		
		//echo $payfile;exit;
		$studid=$data['stud_id'];
		$feedet['student_id']=$data['stud_id'];
		$feedet['amount']=$data['paidfee'];
		$feedet['type_id']=2;
		$feedet['refund_paid_type']=$data['payment_type'];
	//	$feedet['academic_year']= date('Y');
					$feedet['academic_year']=$data['acyear'];
				
		$feedet['receipt_no']=$data['dd_no'];
		$feedet['refund_date']=$data['dd_date']; 
		$feedet['bank_id']=$data['dd_bank'];
		$feedet['bank_city']=$data['dd_bank_branch'];
			$feedet['remark']=$data['remark'];
		$feedet['refund_for']=$data['refund_type'];	
				$feedet['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['created_on']= date('Y-m-d h:i:s');
		$feedet['created_by']= $_SESSION['uid'];
		
			
			//$feedet['college_receiptno']=$data['clreceipt'];
		if($payfile !=''){
			$feedet['receipt_file']=$payfile;
		}
		//print_r($feedet);exit;
		$DB1->insert('fees_refunds',$feedet);
	//	echo $DB1->last_query();exit;
	  $this->session->set_flashdata('message1','Record Added Successfully');
		redirect('ums_admission/viewPayments/'.$studid);
		return true;
		
	}
		
	
	
	function update_refund($data,$payfile){
		
		$DB1 = $this->load->database('umsdb', TRUE);
			//print_r($data);exit;
		
		//echo $payfile;exit;
	//	$feedet['student_id']=$data['stud_id'];
		$feedet['amount']=$data['paidfee'];
		$feedet['type_id']=2;
		$feedet['refund_paid_type']=$data['payment_type'];
	//	$feedet['academic_year']= date('Y');
					$feedet['academic_year']=$data['acyear'];
		$feedet['receipt_no']=$data['dd_no'];
		$feedet['refund_date']=$data['dd_date']; 
		$feedet['bank_id']=$data['dd_bank'];
		$feedet['bank_city']=$data['dd_bank_branch'];
			$feedet['remark']=$data['remark'];
		$feedet['refund_for']=$data['refund_type'];	
				$feedet['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['modified_on']= date('Y-m-d h:i:s');
		$feedet['modified_by']= $_SESSION['uid'];
		
			
			//$feedet['college_receiptno']=$data['clreceipt'];
		if($payfile !=''){
			$feedet['receipt_file']=$payfile;
		}
		//print_r($feedet);exit;
		  $DB1->where('fees_id', $data['fees_id']);
   $DB1->update('fees_refunds',$feedet);
	//	$DB1->insert('fees_refunds',$feedet);
	//	echo $DB1->last_query();exit;
	  $this->session->set_flashdata('message1','Record Updated Successfully');
		redirect('Account/fees_refund/');
		//return true;
		
	}
	

	function delete_refund()
	{
	     $DB1 = $this->load->database('umsdb', TRUE);

//$DB1->where('fees_id', $fee_id);
//		$DB1->update('fees_details',$feedet);
$data['is_deleted']='Y';
   $DB1->where('fees_id', $_POST['fid']);
   $DB1->update('fees_refunds',$data);
  // echo $DB1->last_query();
 echo "Y";
  
	}
	
	function edit_refund($fid)
	{
	     $DB1 = $this->load->database('umsdb', TRUE);
	     $DB1->select("*");
	     $DB1->from("fees_refunds");
	     $DB1->where("fees_id",$fid);
	     $query=$DB1->get();
	   return $query->row_array();
	}
	
	function fees_refund($refund_for=''){
		echo $refund_for; die;
    
		$DB1 = $this->load->database('umsdb', TRUE);
		
		$DB1->select("sm.first_name,sm.stud_id,sm.last_name,sm.enrollment_no,sm.form_number,sm.middle_name,stm.stream_short_name,stm.course_short_name,,adm.actual_fee,adm.applicable_fee,adm.year,fr.*");
		$DB1->from('student_master as sm');
			$DB1->join('admission_details as adm','sm.stud_id = adm.student_id','left');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
				$DB1->join('fees_refunds as fr','sm.stud_id = fr.student_id','left');
					$DB1->where("fr.is_deleted",'N');
		if($refund_for!='')
			$DB1->where("fr.refund_for",$refund_for);
					
		$DB1->order_by("sm.stud_id", "asc");

		$query=$DB1->get();

		//  echo $DB1->last_query();
		$result=$query->result_array();

		 for($i=0;$i<count($result);$i++)
		{
			$result[$i]['total_fee']=$this->fetch_total_fee_paid($result[$i]['stud_id']);
		$bank =	$this->getbanks($result[$i]['bank_id']);
		//var_dump($this->getbanks($result[$i]['bank_id']));
		// exit(0);
			$result[$i]['bank_name']= $bank[0]['bank_name'];
		}
		return $result;   
		
}



	function fetch_total_fee_paid($studId){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT sum(`amount`) as tot_fee_paid FROM `fees_details` WHERE `student_id`=$studId and type_id=2  and chq_cancelled='N'";
		$query = $DB1->query($sql);
		$result=$query->row_array(); 
	
		//echo $result['tot_fee_paid'];exit;
		return $result['tot_fee_paid'];	
	}
	
	
		function searchforrefund($data){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_short_name as stream_name ,stm.course_short_name as course_name,adm.actual_fee,sum(adm.applicable_fee) as applicable_fee");
		$DB1->from('student_master as sm');
		$DB1->join('admission_details as adm','sm.stud_id = adm.student_id','left');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
			
		
	//	if($data['prn']!='')
	//	{
			$DB1->where("sm.enrollment_no",$data['prn']);	    
    //	}
    	
    	
	
	//	$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
	// echo $DB1->last_query();
	//	exit(0);
		$result=$query->row_array();
		/* if($result['stud_id']!=''){
			$result['total_fee']=$this->fetch_total_fee_paid($result['stud_id']);
		} */
//		$result['total_fee']=$this->fetch_total_fee_paid($result['stud_id']);
		//echo $this->db->last_query();
		
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
	function getbanks($bankid='')
{
        $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('bank_master');
		if($bankid !='')
		{
	 $DB1->where("bank_id", $bankid);	    
		}
		$DB1->where("active", "Y");
		$query=$DB1->get();
	//	echo $DB1->last_query();
	//	die();  
		$result=$query->result_array();
		return $result;
}

public function getCollegeCourse()
{
 $this->load->model('Ums_admission_model', 'admission_model');
// var_dump($this->admission_model->getCollegeCourse(1));
// exit(0);
   return $this->admission_model->getCollegeCourse(1);
    //return result;
}


	function load_studentlist($streamid,$year,$academic_year){
		    $DB1 = $this->load->database('umsdb', TRUE);
		    
		    
		    
		    /*	$DB1->select("sm.*,vsd.school_short_name,vsd.course_short_name,vsd.stream_name");
		$DB1->from('student_master as sm');
			$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
			*/
			
				$DB1->select("sm.*,vsd.*");
		$DB1->from('admission_details as ad');
$DB1->join('student_master as sm','ad.student_id = sm.stud_id','left');
		$DB1->join('vw_stream_details as vsd','ad.stream_id = vsd.stream_id','left');
		
			//$DB1->join('fees_details as fd','sm.stud_id = fd.student_id','left');
		if($_POST['admission-course']==0)
		{
			    
		}
		else
		{
			$DB1->where("vsd.course_id",$_POST['admission-course']);	    
		}
		
		if($_POST['admission-stream']!='')
		{
			//$DB1->where("sm.admission_stream", $year);
				if($_POST['admission-stream']==0)
		{
			    
		}
		else
		{
			$DB1->where("sm.admission_stream",$_POST['admission-stream']);	    
		}
			
		}
		
			if($_POST['admission-year']!='')
		{
			//$DB1->where("sm.admission_stream", $year);
				if($_POST['admission-year']==0)
		{
			    
		}
		else
		{
			$DB1->where("sm.current_semester",$_POST['admission-year']);	    
		}
			
		}
		
			if($_POST['acyear']!='')
		{
		   	$DB1->where("ad.academic_year",$_POST['acyear']);	 
		}
		

			$DB1->where("sm.cancelled_admission",'N');
		//	$DB1->where("sm.academic_year",'2017');
	
		$DB1->order_by("sm.enrollment_no_new", "asc");
		$query=$DB1->get();
	//  echo $DB1->last_query();
	//  exit(0);
	//	die();   
		$result=$query->result_array();
		
		$crsession = $this->Fees_model->get_active_exam_session();
		 for($i=0;$i<count($result);$i++)
    {
		$dat = $this->get_exam_feespaid_bysession($result[$i]['stud_id'],$crsession['exam_id']);
	//	echo $result[$i]['stud_id'];
	//	echo $crsession['exam_id'];
	//	var_dump($dat);
	
        	$result[$i]['famount']=$dat['famount'];
			$result[$i]['famfine']=$dat['famfine'];
		//	var_dump($result);
			//	exit(0);
      //  $bank =	$this->getbanks($result[$i]['bank_id']);
        //var_dump($this->getbanks($result[$i]['bank_id']));
       // exit(0);
        //	$result[$i]['bank_name']= $bank[0]['bank_name'];
    }

		
		return $result;
	}
	
	public function get_exam_feespaid_bysession($stid,$sess)
	{
		
         $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(amount) as famount,sum(exam_fee_fine) as famfine");
		$DB1->from('fees_details');
		 $DB1->where("student_id",$stid);	 
		 $DB1->where("type_id",5);	    
 $DB1->where("exam_session",$sess);	 
 $DB1->where("chq_cancelled", "N");
$query=$DB1->get();
	//echo $DB1->last_query();
	//die();  
		$result=$query->row_array();
		return $result;
		
	//	SELECT sum(amount),sum(exam_fee_fine) FROM `fees_details` where student_id =1 and type_id=5 and exam_session=5 and chq_cancelled='N'
		
		
		
		
	}



	public function fetch_personal_details($stdid)
	{
	 $this->load->model('Ums_admission_model', 'admission_model');
	// var_dump($this->admission_model->getCollegeCourse(1));
	// exit(0);
	   return $this->admission_model->fetch_personal_details($stdid);
		//return result;
	}

	public function get_feedetails($stdid)
	{
		
			$DB1 = $this->load->database('umsdb', TRUE);
			//$DB1->select("fd.*,es.*");
			$DB1->select("fd.type_id,fd.academic_year,ed.exam_fees as edexam_fees,ed.late_fees as edlate_fees,fd.exam_session,fd.student_id,SUM(fd.amount) as f_amount,SUM(fd.canc_charges)as f_charges,SUM(fd.exam_fee_fine) as f_fine,es.exam_name,es.exam_type");
			$DB1->from('fees_details fd');
			$DB1->join('exam_session es','fd.exam_session = es.exam_id','left');
			$DB1->join('exam_details ed','fd.exam_session = ed.exam_id and fd.student_id = ed.stud_id','left');
			$DB1->where("fd.type_id",5);	    
			$DB1->where("fd.student_id",$stdid);	 
			$DB1->where("fd.chq_cancelled", "N");
			$DB1->where("fd.is_deleted", "N");
			$query=$DB1->get();
			//	echo $DB1->last_query();
			//	die();  
			$result=$query->result_array();
			return $result;

	}


	 function fetch_admission_details_all($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("ed.*,es.*");
		$DB1->from('exam_details ed');
			$DB1->join('exam_session es','es.exam_id = ed.exam_id','left');
		$DB1->where('ed.stud_id', $stud_id);
	
		$DB1->order_by("ed.exam_master_id", "desc");

		$query=$DB1->get();
		$result=$query->result_array();

	for($i=0;$i<count($result);$i++)
	{
	   // $feeam = 
	    $feeam=$this->fee_paid_exam_session($stud_id,$result[$i]['exam_id']);

	    $result[$i]['tot_fine']=$feeam['latefees'];
	    $result[$i]['totfeepaid']=$feeam['tpaid'];
	    
	}
//	var_dump($result);
//	exit();
		return $result;
	}


public function fee_paid_exam_session($stdid,$exam)
{
    
    	$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(amount) as tpaid ,sum(exam_fee_fine) as latefees");
		$DB1->from('fees_details');
		$DB1->where('student_id', $stdid);
		$DB1->where('exam_session', $exam);
	  $DB1->where("type_id",5);	  
	          $DB1->where("chq_cancelled", "N");
        $DB1->where("is_deleted", "N");
		//$DB1->order_by("exam_master_id", "desc");
		

		$query=$DB1->get();
		$result=$query->row_array();
    
    return $result;
    
    
    
    
}













 	function updateExamfee()
	{
		//print_r($data);
			$DB1 = $this->load->database('umsdb', TRUE);
		   	    $stud_id= $_POST['student_id'];	
   	    $eid =$_POST['eid']; 
   	    	  	
    //	$data['opening_balance'] =$_POST['fopening_balance'];    
    		
    	$data['exam_fees']=$_POST['exam_fees'];
    		$data['late_fees']=$_POST['late_fees'];
    		
    	$data['modify_by']=$_SESSION['uid'];
		$data['modify_on']=date("Y-m-d H:i:s");
		$data['modify_from_ip']=$_SERVER['REMOTE_ADDR'];
		
		$DB1->where('exam_id',$eid);
			$DB1->where('stud_id',$stud_id);
		
		$DB1->update('exam_details',$data);
	
	//	echo $DB1->last_query();exit;
		return true;
	}	








public function get_bankdetails($stdid)
{
 $this->load->model('Ums_admission_model', 'admission_model');
// var_dump($this->admission_model->getCollegeCourse(1));
// exit(0);
   return $this->admission_model->get_bankdetails($stdid);
    //return result;
}


public function fetch_admission_details($stdid)
{
 $this->load->model('Ums_admission_model', 'admission_model');
// var_dump($this->admission_model->getCollegeCourse(1));
// exit(0);
   return $this->admission_model->fetch_admission_details($stdid);
    //return result;
}



	function fetch_installment_details($studId){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("f.fees_paid_type,f.fees_id,es.*,f.canc_charges,f.chq_cancelled,f.exam_fee_fine, f.receipt_no,
		f.receipt_file, f.fees_date, b.bank_name, f.bank_city, f.amount as amt_paid, b.bank_name,f.college_receiptno");
		$DB1->from('fees_details as f');
		$DB1->join('bank_master b','f.bank_id = b.bank_id','left');
		$DB1->join('exam_session es','f.exam_session = es.exam_id','left');
		//$DB1->where('fid.no_of_installment >', 1);
		$DB1->where('f.student_id', $studId);
			$DB1->where('f.type_id', 5);
			$DB1->where('f.is_deleted', 'N');
		$DB1->order_by("f.fees_id", "ASC");
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}

	
	
	
		function get_inst_details($feeid){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("fd.*,es.*,");
		$DB1->from('fees_details fd');
		$DB1->join('exam_session es','fd.exam_session = es.exam_id','left');
		$DB1->where('fd.fees_id',$feeid);
	
		//$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		$result=$query->result_array();
		 //echo $this->db->last_query();
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
	


	function pay_exam_fee($data, $payfile){
		
		$DB1 = $this->load->database('umsdb', TRUE);
			//print_r($data);exit;
		
		//echo $payfile;exit;
		$feedet['student_id']=$data['stud_id'];
		$feedet['amount']=$data['paidfee'];
		$feedet['type_id']=5;
		$feedet['fees_paid_type']=$data['payment_type'];
		$feedet['academic_year']= $data['academic_year'];
				
		$feedet['receipt_no']=$data['dd_no'];
		$feedet['fees_date']=$data['dd_date']; 
		$feedet['bank_id']=$data['dd_bank'];
		$feedet['bank_city']=$data['dd_bank_branch'];
		$feedet['exam_fee_fine']=$data['ffine'];
		$feedet['exam_session']=$data['exam_session'];
		
			$feedet['remark']=$data['remark'];
			
				$feedet['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['created_on']= date('Y-m-d h:i:s');
		$feedet['created_by']= $_SESSION['uid'];
		
			
			$feedet['college_receiptno']=$data['clreceipt'];
		if($payfile !=''){
			$feedet['receipt_file']=$payfile;
		}
		//print_r($feedet);exit;
		$DB1->insert('fees_details',$feedet);   
		
		//echo $DB1->last_query();exit;
		return true;
		
	}


	function update_exam_fee($data, $payfile){
		
		$DB1 = $this->load->database('umsdb', TRUE);
			
		$fee_id = $data['eid'];
			$bfees = $data['bfees'];
				$pfees = $data['pfees'];
				$tfee = $data['bfees'] + $data['pfees'];
		
		$feedet['amount']=$data['epaidfee'];
		$feedet['type_id']=5;
		$feedet['fees_paid_type']=$data['epayment_type'];
	
		$feedet['receipt_no']=$data['edd_no'];
		$feedet['fees_date']=$data['edd_date']; 
		$feedet['bank_id']=$data['edd_bank'];
		$feedet['bank_city']=$data['edd_bank_branch'];
		$feedet['modify_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['modified_on']= date('Y-m-d h:i:s');
		$feedet['modified_by']= $_SESSION['uid'];
		$feedet['exam_fee_fine']=$data['ffine'];
	    $feedet['exam_session']=$data['exam_session'];	
		
		if($data['ccanc']=="N")
		{
		 	$feedet['canc_charges']=0;   
		}
		else
		{
		
			$feedet['canc_charges']=$data['cancamt']; 
		}
			$feedet['chq_cancelled']=$data['ccanc']; 
			$feedet['remark']=$data['eremark'];
			$feedet['college_receiptno']=$data['eclreceipt'];
		
		if($payfile !=''){
			$feedet['receipt_file']=$payfile;
		}
	
			$DB1->where('fees_id', $fee_id);
		$DB1->update('fees_details',$feedet);

		return true;
		
	}
	
	
	
public function get_all_exam_session($id='')
{
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('exam_session');
	   $DB1->order_by('exam_id','desc');
	   $DB1->limit(4,0);

		$query=$DB1->get();

		$result=$query->result_array();
		return $result;
	
}	
	
	
	
	
public function get_active_exam_session($id='')
{
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('exam_session');
	
	 $DB1->where("is_active","Y");	 
	 if($id!=''){
	     $DB1->where("exam_id",$id);	 
	 }
 
	//	$DB1->where("active", "Y");
		$query=$DB1->get();
	//	echo $DB1->last_query();
	//	die();  
		$result=$query->row_array();
		return $result;
	
}

		function delete_fees()
	{
	    	$DB1 = $this->load->database('umsdb', TRUE);   
	    	
	    	$del['is_deleted']='Y';
	    	$del['chq_cancelled']='Y';
	    		$DB1->where('fees_id', $_POST['feeid']);
		$DB1->update('fees_details',$del);
		return 'Y';
	}

public function get_exam_session($id='')
{
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('exam_session');
        $DB1->where("exam_id",$id);	
		$query=$DB1->get();
		$result=$query->row_array();
		return $result;
	
}

public function get_day_wise_fees_collection_details_sale_by_pos()
{   $whr='';
    $fdate='f.fees_date';
	if($_POST['by_type']==2){
	$fdate='DATE(f.created_on)';	
	}
	if(isset($_POST['date']) && $_POST['date'] !=''){
		$whr='And '.$fdate.'="'.$_POST['date'].'"';
	}
	   $DB1 = $this->load->database('umsdb', TRUE);
	   $DB2 = $this->load->database('parttime', TRUE);
	   
	   $sql="SELECT  SUM(fmount) amount
       FROM
        (   SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_challan f 
		WHERE f.fees_paid_type='POS'".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR' AND  f.type_id IN (10,11) 
             
            UNION ALL
           SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_details f 
		JOIN sandipun_ums.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='POS'".$whr." AND f.is_deleted='N'	   
        ) s"; 
	    
		$a= $DB1->query($sql)->row()->amount;
		
		$sql1="SELECT  SUM(fmount) amount
       FROM
        ( SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_challan f 
		 LEFT JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='POS'".$whr." AND f.is_deleted='N' AND f.challan_status='VR'  AND f.student_id IS NULL  AND  f.type_id IN (10,11)
            UNION ALL
			
			SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_details f 
		JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='POS'".$whr." AND f.is_deleted='N'
          ) s";
		  
		// echo$sql1="select * from ".$DB2->database.".fees_challan limit 1"; 
		 $b= $DB2->query($sql1)->row()->amount;
		
		return $a+$b;
		
	
}

public function get_day_wise_fees_collection_details_sale_by_cheque()
{
	
	   $whr='';
	    $fdate='f.fees_date';
	if($_POST['by_type']==2){
	$fdate='DATE(f.created_on)';	
	}
		if(isset($_POST['date']) && $_POST['date'] !=''){
		$whr='And '.$fdate.'="'.$_POST['date'].'"';
	}
	   $DB1 = $this->load->database('umsdb', TRUE);
	   $DB2 = $this->load->database('parttime', TRUE);
	    $sql="SELECT  SUM(fmount) amount
       FROM
        ( SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_details f 
		JOIN sandipun_ums.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='CHQ'".$whr." AND f.is_deleted='N'
		 UNION ALL		      
           SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_challan f 
		WHERE f.fees_paid_type='CHQ'".$whr." AND f.is_deleted='N' AND f.student_id IS NULL  AND f.challan_status='VR' AND  f.type_id IN (10,11)) s"; 
	    //exit();
		$a= $DB1->query($sql)->row()->amount;
		$sql2 ="SELECT  SUM(fmount) amount
       FROM
        (SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_details f 
		JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='CHQ'".$whr." AND f.is_deleted='N'
		 UNION ALL
		SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_challan f 
		 LEFT JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='CHQ'".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR'  AND  f.type_id IN (10,11)) s
		";
		$b= $DB2->query($sql2)->row()->amount;
		return $a+$b;
	
}
public function get_day_wise_fees_collection_details_sale_by_dd()
{       
        $whr='';
	    $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
			if(isset($_POST['date']) && $_POST['date'] !=''){
			$whr='And '.$fdate.'="'.$_POST['date'].'"';
		}
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB2 = $this->load->database('parttime', TRUE);
	    $sql="SELECT  SUM(fmount) amount
         FROM
        (   
           SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_details f 
		JOIN sandipun_ums.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='DD'".$whr." AND f.is_deleted='N'
		 UNION ALL
		  
           SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_challan f 
		WHERE f.fees_paid_type='DD'".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR' AND  f.type_id IN (10,11)
        ) s";
		$a= $DB1->query($sql)->row()->amount;
		$sql2="SELECT  SUM(fmount) amount
         FROM
        ( SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_details f 
		JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='DD'".$whr." AND f.is_deleted='N'
		 UNION ALL
		 SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_challan f 
		 LEFT JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='DD'".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR'  AND  f.type_id IN (10,11)) s
		";
		
		$b= $DB2->query($sql2)->row()->amount;
		return $a+$b;
	
}
public function get_day_wise_fees_collection_details_sale_by_ol()
{       
        $whr='';
	    $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
			if(isset($_POST['date']) && $_POST['date'] !=''){
			$whr='And '.$fdate.'="'.$_POST['date'].'"';
		}
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB2 = $this->load->database('parttime', TRUE);
		
	    $sql="SELECT  SUM(fmount) amount
         FROM
        (            
           SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_details f 
		JOIN sandipun_ums.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type in('OL','GATEWAY-ONLINE')".$whr." AND f.is_deleted='N'
		 UNION ALL
          SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_challan f 
		WHERE f.fees_paid_type in('OL','GATEWAY-ONLINE')".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR' AND  f.type_id IN (10,11)
        ) s";
		$a= $DB1->query($sql)->row()->amount;
		$sql2 ="SELECT  SUM(fmount) amount
         FROM
        (      SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_details f 
		JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type in('OL','GATEWAY-ONLINE')".$whr." AND f.is_deleted='N'
            UNION ALL
			SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_challan f 
		 LEFT JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type in('OL','GATEWAY-ONLINE')".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR' AND  f.type_id IN (10,11)) s
			";
		$b= $DB2->query($sql2)->row()->amount;
		return $a+$b;
	
}

public function get_day_wise_fees_collection_details_sale_by_pg()
{       
       $whr='';
	    $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
			if(isset($_POST['date']) && $_POST['date'] !=''){
			$whr='And '.$fdate.'="'.$_POST['date'].'"';
		}
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB2 = $this->load->database('parttime', TRUE);
	    $sql="SELECT  SUM(fmount) amount
         FROM
        ( 
           
           SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_details f 
		JOIN sandipun_ums.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='PG'".$whr." AND f.is_deleted='N'
		UNION ALL
		   
           SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_challan f 
		WHERE f.fees_paid_type='PG'".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR' AND  f.type_id IN (10,11)
        ) s";
		$a= $DB1->query($sql)->row()->amount;
		$sql2 =" SELECT  SUM(fmount) amount
         FROM
        ( SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_details f 
		JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='PG'".$whr." AND f.is_deleted='N'
            UNION ALL
		SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_challan f 
		 LEFT JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='PG'".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR' AND  f.type_id IN (10,11))s	";
		$b= $DB2->query($sql2)->row()->amount;
		return $a+$b;
	
}

public function get_day_wise_fees_collection_details_sale_by_itf()
{       
       $whr='';
	    $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
			if(isset($_POST['date']) && $_POST['date'] !=''){
			$whr='And '.$fdate.'="'.$_POST['date'].'"';
		}
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB2 = $this->load->database('parttime', TRUE);
	    $sql="SELECT  SUM(fmount) amount
         FROM
        ( 
            
           SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_details f 
		JOIN sandipun_ums.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='ITF'".$whr." AND f.is_deleted='N'
		UNION ALL		   
          SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_challan f 
		WHERE f.fees_paid_type='ITF'".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR' AND  f.type_id IN (10,11)
        ) s";
		$a= $DB1->query($sql)->row()->amount;
		$sql2="SELECT  SUM(fmount) amount
         FROM
        ( SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_details f 
		JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='ITF'".$whr." AND f.is_deleted='N'
            UNION ALL 
			SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_challan f 
		 LEFT JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='ITF'".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR' AND   f.type_id IN (10,11) ) s";
		$b= $DB2->query($sql2)->row()->amount;
		return $a+$b;
	
}

public function get_day_wise_fees_collection_details_sale_by_recpt()
{       
        $whr='';
	    $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
			if(isset($_POST['date']) && $_POST['date'] !=''){
			$whr='And '.$fdate.'="'.$_POST['date'].'"';
		}
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB2 = $this->load->database('parttime', TRUE);
	    $sql="SELECT  SUM(fmount) amount
         FROM
        ( 
            
           SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_details f 
		JOIN sandipun_ums.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='RECPT'".$whr." AND f.is_deleted='N'
		UNION ALL
           SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_challan f 
		WHERE f.fees_paid_type='RECPT'".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR' AND  f.type_id IN (10,11)
        ) s";
		
		$a= $DB1->query($sql)->row()->amount;
		$sql2="SELECT  SUM(fmount) amount
         FROM
        ( SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_details f 
		JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='RECPT'".$whr." AND f.is_deleted='N'
            UNION ALL
			SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_challan f 
		 LEFT JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='RECPT'".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR' AND  f.type_id IN (10,11) ) s";
		$b= $DB2->query($sql2)->row()->amount;
		return $a+$b;
		
	
}

public function get_day_wise_fees_collection_details_sale_by_chln()
{       
        $whr='';
	    $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
			if(isset($_POST['date']) && $_POST['date'] !=''){
			$whr='And '.$fdate.'="'.$_POST['date'].'"';
		}
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB2 = $this->load->database('parttime', TRUE);
	    $sql="SELECT  SUM(fmount) amount
         FROM
        ( 
            
           SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_details f 
		JOIN sandipun_ums.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='CHLN'".$whr." AND f.is_deleted='N'
		UNION ALL

             SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_challan f 
		WHERE f.fees_paid_type='CHLN'".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR' AND  f.type_id IN (10,11)
        ) s";
		$a= $DB1->query($sql)->row()->amount;
		$sql2="SELECT  SUM(fmount) amount
         FROM
        ( SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_details f 
		JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='CHLN'".$whr." AND f.is_deleted='N'
            UNION ALL 
			SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_challan f 
		 LEFT JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type='CHLN'".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR' AND   f.type_id IN (10,11)) s";
		
		$b= $DB2->query($sql2)->row()->amount;
		return $a+$b;
	
}

public function get_day_wise_fees_collection_details_sale_by_others()
{       
        $whr='';
	    $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
			if(isset($_POST['date']) && $_POST['date'] !=''){
			$whr='And '.$fdate.'="'.$_POST['date'].'"';
		}
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB2 = $this->load->database('parttime', TRUE);
	    $sql="SELECT  SUM(fmount) amount
         FROM
        (           
           SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_details f 
		JOIN sandipun_ums.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type=''".$whr." AND f.is_deleted='N'
		UNION ALL
           SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
		FROM sandipun_ums.fees_challan f 
		WHERE f.fees_paid_type=''".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR' AND  f.type_id IN (10,11)
        ) s";
		$a= $DB1->query($sql)->row()->amount;
		$sql2="SELECT  SUM(fmount) amount
         FROM
        (  SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_details f 
		JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type=''".$whr." AND f.is_deleted='N'
            UNION ALL
			 SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
		FROM sandipun_ums_part_time.fees_challan f 
		 LEFT JOIN sandipun_ums_part_time.student_master sm 
		ON f.student_id=sm.stud_id
		WHERE f.fees_paid_type=''".$whr." AND f.is_deleted='N' AND f.student_id IS NULL AND f.challan_status='VR'  AND  f.type_id IN (10,11)) s";
		
		$b= $DB2->query($sql2)->row()->amount;
		return $a+$b;
	
}










public function get_day_wise_fees_collection_details_sale_by_academic_new_admission()
{   $whr='';
	
	    $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	   $DB1 = $this->load->database('umsdb', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0) AS fmount,f.fees_date,f.fees_paid_type
			FROM fees_details f 
			JOIN student_master sm 
			ON f.student_id=sm.stud_id
			WHERE ".$fdate."='".$_POST['date']."' 
			AND f.type_id =2 
			AND sm.academic_year =sm.admission_session
			AND sm.admission_cycle IS NULL
			AND f.is_deleted='N'
			GROUP BY f.`fees_paid_type`";
	    
		return $DB1->query($sql)->result_array();
	
}
public function get_day_wise_fees_collection_details_sale_by_academic_reregistration()
{       $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	   $DB1 = $this->load->database('umsdb', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0) AS fmount,f.fees_date,f.fees_paid_type
			FROM fees_details f 
			JOIN student_master sm 
			ON f.student_id=sm.stud_id
			WHERE ".$fdate."='".$_POST['date']."' 
			AND f.type_id =2 
			AND sm.academic_year !=sm.admission_session
			AND sm.admission_cycle IS NULL
			AND f.is_deleted='N'
			GROUP BY f.`fees_paid_type`";
	    
		return $DB1->query($sql)->result_array();
	
}
public function get_day_wise_fees_collection_details_sale_by_academic_phd()
{      $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	   $DB1 = $this->load->database('umsdb', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0) AS fmount,f.fees_date,f.fees_paid_type
				FROM fees_details f 
				JOIN student_master sm 
				ON f.student_id=sm.stud_id
				WHERE ".$fdate."='".$_POST['date']."' 
				AND f.type_id =2 
				AND sm.admission_cycle IS NOT NULL
				AND f.is_deleted='N'
				GROUP BY f.`fees_paid_type`";
	    
		return $DB1->query($sql)->result_array();
	
}
public function get_day_wise_fees_collection_details_sale_by_academic_illp()
{     $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	  $DB1 = $this->load->database('parttime', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0) AS fmount,f.fees_date,f.fees_paid_type
			FROM sandipun_ums_part_time.fees_details f 
			JOIN sandipun_ums_part_time.student_master sm 
			ON f.student_id=sm.stud_id
			WHERE ".$fdate."='".$_POST['date']."' 
			AND f.type_id =2 
			AND f.is_deleted='N'
			GROUP BY f.fees_paid_type";
			
	   
		 return $DB1->query($sql)->result_array();
		 
		 
	
}
public function get_day_wise_fees_collection_details_sale_by_exam_new_admission()
{      $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	   $DB1 = $this->load->database('umsdb', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0) AS fmount,f.fees_date,f.fees_paid_type
			FROM fees_details f 
			JOIN student_master sm 
			ON f.student_id=sm.stud_id
			WHERE ".$fdate."='".$_POST['date']."' 
			AND f.type_id  IN (5,7,8,9) 
			AND sm.academic_year =sm.admission_session
			AND sm.admission_cycle IS NULL
			AND f.is_deleted='N'
			GROUP BY f.`fees_paid_type`";
	    
		return $DB1->query($sql)->result_array();
}
public function get_day_wise_fees_collection_details_sale_by_exam_phd()
{      $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	   $DB1 = $this->load->database('umsdb', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0) AS fmount,f.fees_date,f.fees_paid_type
				FROM fees_details f 
				JOIN student_master sm 
				ON f.student_id=sm.stud_id
				WHERE ".$fdate."='".$_POST['date']."' 
				AND f.type_id IN (5,7,8,9) 
				AND sm.admission_cycle IS NOT NULL
				AND f.is_deleted='N'
				GROUP BY f.`fees_paid_type`";
	    
		return $DB1->query($sql)->result_array();
	
}
public function get_day_wise_fees_collection_details_sale_by_exam_reregistration()
{     $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	   $DB1 = $this->load->database('umsdb', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0) AS fmount,f.fees_date,f.fees_paid_type
				FROM fees_details f 
				JOIN student_master sm 
				ON f.student_id=sm.stud_id
				WHERE ".$fdate."='".$_POST['date']."'
				AND f.type_id IN (5,7,8,9)  
				AND sm.academic_year !=sm.admission_session
				AND sm.admission_cycle IS NULL
				AND f.is_deleted='N'
				GROUP BY f.`fees_paid_type`";
	    
		return $DB1->query($sql)->result_array();
	
}
public function get_day_wise_fees_collection_details_sale_by_exam_illp()
{     $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	  $DB1 = $this->load->database('parttime', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0) AS fmount,f.fees_date,f.fees_paid_type
			FROM sandipun_ums_part_time.fees_details f 
			JOIN sandipun_ums_part_time.student_master sm 
			ON f.student_id=sm.stud_id
			WHERE ".$fdate."='".$_POST['date']."' 
			AND f.type_id IN (5,7,8,9) 
			AND f.is_deleted='N'
			GROUP BY f.`fees_paid_type`";
	    
		return $DB1->query($sql)->result_array();
	
}

public function get_day_wise_fees_collection_details_sale_by_internal_external()
{      $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	   $DB1 = $this->load->database('umsdb', TRUE);
	   $DB2 = $this->load->database('parttime', TRUE);
	   $sql="SELECT  *
         FROM
        ( 
            SELECT COALESCE(SUM(f.amount),0) famount,f.fees_date,f.fees_paid_type as type
			FROM fees_challan f 
			 LEFT JOIN student_master sm 
			ON f.student_id=sm.stud_id
			WHERE ".$fdate."='".$_POST['date']."' 
			AND f.type_id IN (10,11) 
			GROUP BY f.`fees_paid_type`            
        ) s group by type" ;
		
		$a = $DB1->query($sql)->result_array();
	    $sql2="SELECT  *
         FROM
        (          
           SELECT COALESCE(SUM(f.amount),0) famount,f.fees_date,f.fees_paid_type as type
		   FROM sandipun_ums_part_time.fees_challan f 
		   LEFT JOIN sandipun_ums_part_time.student_master sm 
		   ON f.student_id=sm.stud_id
		   WHERE ".$fdate."='".$_POST['date']."' 
		   AND f.type_id IN (10,11)
		   AND f.is_deleted='N'
		   GROUP BY f.`fees_paid_type`
        ) s group by type" ;
		$b = $DB2->query($sql2)->result_array();
		return array_merge($a, $b);
}

/*  */


public function get_day_wise_fees_collection_details_sale_by_academic_new_admission_total()
{   $whr='';
	   $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	   $DB1 = $this->load->database('umsdb', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0) amount,f.fees_date,f.fees_paid_type
			FROM fees_details f 
			JOIN student_master sm 
			ON f.student_id=sm.stud_id
			WHERE ".$fdate."='".$_POST['date']."' 
			AND f.type_id =2 
			AND sm.academic_year =sm.admission_session
			AND f.is_deleted='N'
			AND sm.admission_cycle IS NULL";
	    
		return $DB1->query($sql)->row()->amount;
	
}

public function get_day_wise_fees_collection_details_sale_by_academic_reregistration_total()
{   $whr='';
	   $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	   $DB1 = $this->load->database('umsdb', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0)  amount,f.fees_date,f.fees_paid_type
			FROM fees_details f 
			JOIN student_master sm 
			ON f.student_id=sm.stud_id
			WHERE ".$fdate."='".$_POST['date']."'
			AND f.type_id =2  
			AND sm.academic_year !=sm.admission_session
			AND f.is_deleted='N'
			AND sm.admission_cycle IS NULL";
	    
		return $DB1->query($sql)->row()->amount;
	
}

public function get_day_wise_fees_collection_details_sale_by_academic_phd_total()
{   $whr='';
	   $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	   $DB1 = $this->load->database('umsdb', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0) amount,f.fees_date,f.fees_paid_type
			FROM fees_details f 
			JOIN student_master sm 
			ON f.student_id=sm.stud_id
			WHERE ".$fdate."='".$_POST['date']."' 
			AND f.type_id =2 
			AND f.is_deleted='N'
			AND sm.admission_cycle IS NOT NULL";
	    
		return $DB1->query($sql)->row()->amount;
	
}

public function get_day_wise_fees_collection_details_sale_by_academic_illp_total()
{   $whr='';
	  $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	   $DB1 = $this->load->database('parttime', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0) amount,f.fees_date,f.fees_paid_type
			FROM sandipun_ums_part_time.fees_details f 
			JOIN sandipun_ums_part_time.student_master sm 
			ON f.student_id=sm.stud_id
			WHERE ".$fdate."='".$_POST['date']."' 
			AND f.type_id =2 AND f.is_deleted='N'";
	    
		return $DB1->query($sql)->row()->amount;
	
}
public function get_day_wise_fees_collection_details_sale_by_exam_new_admission_total()
{   $whr='';
	  $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	   $DB1 = $this->load->database('umsdb', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0)  amount,f.fees_date,f.fees_paid_type
				FROM fees_details f 
				JOIN student_master sm 
				ON f.student_id=sm.stud_id
				WHERE ".$fdate."='".$_POST['date']."'
				AND f.type_id IN (5,7,8,9) 
				AND sm.academic_year =sm.admission_session
				AND sm.admission_cycle IS NULL AND f.is_deleted='N'";
	    
		return $DB1->query($sql)->row()->amount;
	
	
}

public function get_day_wise_fees_collection_details_sale_by_exam_phd_total()
{   $whr='';
	    $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	   $DB1 = $this->load->database('umsdb', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0) amount,f.fees_date,f.fees_paid_type
				FROM fees_details f 
				JOIN student_master sm 
				ON f.student_id=sm.stud_id
				WHERE ".$fdate."='".$_POST['date']."' 
				AND f.type_id IN (5,7,8,9) 
				AND sm.admission_cycle IS NOT NULL AND f.is_deleted='N'";
	    
		return $DB1->query($sql)->row()->amount;
	
}

public function get_day_wise_fees_collection_details_sale_by_exam_reregistration_total()
{   $whr='';
	   $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	   $DB1 = $this->load->database('umsdb', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0) amount,f.fees_date,f.fees_paid_type
			FROM fees_details f 
			JOIN student_master sm 
			ON f.student_id=sm.stud_id
			WHERE ".$fdate."='".$_POST['date']."' 
			AND f.type_id IN (5,7,8,9)  
			AND sm.academic_year !=sm.admission_session
			AND sm.admission_cycle IS NULL AND f.is_deleted='N'";
	    
		return $DB1->query($sql)->row()->amount;
	
}

public function get_day_wise_fees_collection_details_sale_by_exam_illp_total()
{   $whr='';
	   $fdate='f.fees_date';
		if($_POST['by_type']==2){
		$fdate='DATE(f.created_on)';	
		}
	   $DB1 = $this->load->database('parttime', TRUE);
	   $sql="SELECT COALESCE(SUM(f.amount),0) amount,f.fees_date,f.fees_paid_type
			FROM sandipun_ums_part_time.fees_details f 
			JOIN sandipun_ums_part_time.student_master sm 
			ON f.student_id=sm.stud_id
			WHERE ".$fdate."='".$_POST['date']."' 
			AND f.type_id IN (5,7,8,9)  AND f.is_deleted='N'";
	    
		return $DB1->query($sql)->row()->amount;
	
}

		public function get_day_wise_fees_collection_details_sale_by_internal_external_total()
		{     
			  $whr='';
			  $fdate='f.fees_date';
				if($_POST['by_type']==2){
				$fdate='DATE(f.created_on)';	
				}
			   $DB1 = $this->load->database('umsdb', TRUE);
			   $DB2 = $this->load->database('parttime', TRUE);
			   
			   $sql="SELECT  SUM(fmount) amount
			   FROM
				( 
				
				   SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
				FROM sandipun_ums.fees_details f 
				JOIN sandipun_ums.student_master sm 
				ON f.student_id=sm.stud_id
				WHERE ".$fdate."='".$_POST['date']."' AND f.type_id IN(10,11) AND f.is_deleted='N'
				UNION ALL
				   
				   SELECT COALESCE(SUM(sandipun_ums.f.amount),0) AS fmount
				FROM sandipun_ums.fees_challan f 
				LEFT JOIN sandipun_ums.student_master sm 
				ON f.student_id=sm.stud_id
				WHERE ".$fdate."='".$_POST['date']."' AND f.student_id IS NULL AND f.challan_status='VR' AND f.type_id IN(10,11)  AND f.is_deleted='N'
				) s";
				
				$a= $DB1->query($sql)->row()->amount;
				$sql2="SELECT  SUM(fmount) amount
				 FROM
				(  SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
				FROM sandipun_ums_part_time.fees_details f 
				JOIN sandipun_ums_part_time.student_master sm 
				ON f.student_id=sm.stud_id
				WHERE ".$fdate."='".$_POST['date']."' AND f.type_id IN(10,11)  AND f.is_deleted='N'
					UNION ALL
					 SELECT COALESCE(SUM(sandipun_ums_part_time.f.amount),0) AS fmount
				FROM sandipun_ums_part_time.fees_challan f 
				 LEFT JOIN sandipun_ums_part_time.student_master sm 
				ON f.student_id=sm.stud_id
				WHERE ".$fdate."='".$_POST['date']."' AND f.student_id IS NULL AND f.challan_status='VR' AND f.type_id IN(10,11)  AND f.is_deleted='N'
					) s";
				
				$b= $DB2->query($sql2)->row()->amount;
				return $a+$b;	
		}
		
		
		//Added By:Amit Dubey AS On 12-08-2025, Code block Start
		public function getStudentPaidFeesByStudId_old($dataArr){
			if(isset($dataArr['refund_type']) && ($dataArr['refund_type']=='cancel_admission' || $dataArr['refund_type'] =='excess_fees')){
				$refund_type = 2;
			}
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->select("fees_id,type_id,student_id,fees_paid_type,amount,fees_date,academic_year");
			$DB1->from('fees_details');
			$DB1->where("student_id",$dataArr['student_id']);
			$DB1->where("type_id",$refund_type);
			$DB1->where("academic_year",$dataArr['academic_year']);
			$DB1->where("chq_cancelled",'N');
			
			$query=$DB1->get();
			//echo $DB1->last_query(); die(); 	 
			$result=$query->result_array();
			return $result;
		}
		
		
		public function getStudentCancelData($dataArr){
			$this->db->select("ac_id,stud_id,stud_prn,canc_remark,canc_date,canc_on,academic_year");
			$this->db->from('sandipun_ums_sf.admission_cancellations');
			$this->db->where("stud_id",$dataArr['student_id']);
			$this->db->where("academic_year",$dataArr['academic_year']);
			$this->db->where("stud_prn",$dataArr['enrollment_no']);
			$query=$this->db->get();
			 //echo $this->db->last_query(); die(); 	 
			$result=$query->row_array();
			return $result;
		}
		
		
		/**/
		
	public function getStudentPaidFeesByStudId($dataArr){
			if(isset($dataArr['refund_type']) && ($dataArr['refund_type']=='cancel_admission' || $dataArr['refund_type'] =='excess_fees')){
				$refund_type = 2;
			}
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->select("fees_id,type_id,student_id,fees_paid_type,amount,fees_date,academic_year");
			$DB1->from('fees_details');
			$DB1->where("student_id",$dataArr['student_id']);
			$DB1->where("type_id",$refund_type);
			//$DB1->where("academic_year",$dataArr['academic_year']);
			//$DB1->where("academic_year",'2024');
			$DB1->where("chq_cancelled",'N');
			
			$query=$DB1->get();
			//echo $DB1->last_query(); die(); 	 
			$result=$query->result_array();
			return $result;
		}
		
}

?>