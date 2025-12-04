<?php
class Reports_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
        
        $DB1 = $this->load->database('umsdb', TRUE); 
    }
    //get courses offered by college
	 

function getTotalfee($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(ad.applicable_fee) as totalfee");
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as sm','sm.stud_id=ad.student_id','INNER');
		$DB1->where('ad.academic_year',$year);
		$DB1->where('ad.cancelled_admission','N');
		//$DB1->where('sm.cancelled_admission','N');
		//$DB1->where('sm.admission_confirm','Y');
		
		$query=$DB1->get();
	//	echo $DB1->last_query();
	$result=$query->row_array();
		return $result['totalfee'];
}
/////////////////////////////////////////////////////


function getTotalfee_new_reg($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		
		$DB1->select("sum(case when sm.admission_session='$year' then (ad.applicable_fee) else null end) as totalfee_new,sum(case when sm.admission_session!='$year' then (ad.applicable_fee) else null end) as totalfee_reg");
		
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as sm','sm.stud_id=ad.student_id AND sm.enrollment_no!=""','INNER');
		$DB1->where('ad.academic_year',$year);
		$DB1->where('ad.cancelled_admission','N');
		//$DB1->where('sm.cancelled_admission','N');
		if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}
	
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
	$result=$query->row_array();
		return $result;
}
function getTotalfee_new_reg_23($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		
		$DB1->select("sum(case when sm.admission_session='$year' then (ad.applicable_fee) else null end) as totalfee_new,sum(case when sm.admission_session!='$year' then (ad.applicable_fee) else null end) as totalfee_reg");
		
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as sm','sm.stud_id=ad.student_id AND sm.enrollment_no!=""','INNER');
		$DB1->where('ad.academic_year',$year);
		$DB1->where('ad.cancelled_admission','N');
		$DB1->where('sm.cancelled_admission','N');
		//$DB1->where('sm.admission_confirm','Y');
	
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
	$result=$query->row_array();
		return $result;
}

function getTotalfee_new($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(ad.applicable_fee) as totalfee");
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as sm','sm.stud_id=ad.student_id AND sm.enrollment_no!=""','INNER');
		$DB1->where('ad.academic_year',$year);
		$DB1->where('ad.cancelled_admission','N');
		$DB1->where('sm.cancelled_admission','N');
		if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}
		$where=" sm.admission_session='$year'";

		$DB1->where($where);
		$query=$DB1->get();
	//	echo $DB1->last_query();
	$result=$query->row_array();
		return $result['totalfee'];
}
function getTotalfee_reg($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(ad.applicable_fee) as totalfee");
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as sm','sm.stud_id=ad.student_id AND sm.enrollment_no!=""','INNER');
		$DB1->where('ad.academic_year',$year);
		$DB1->where('ad.cancelled_admission','N');
		$DB1->where('sm.cancelled_admission','N');
		if($year>=2020){
		   $DB1->where('sm.admission_confirm','Y');
		}
		$where=" sm.admission_session!='$year'";
		//$DB1->where('sm.admission_confirm','Y');
		$DB1->where($where);
		$query=$DB1->get();
	//	echo $DB1->last_query();
	$result=$query->row_array();
		return $result['totalfee'];
}
////////////////////////////////////////////////////////

function get_opening_balance($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(opening_balance) as opaning_bal");
		$DB1->from('admission_details');
			$DB1->where('academic_year',$year);
			$DB1->where('cancelled_admission','N');
		$query=$DB1->get();
	//	echo $DB1->last_query();
	$result=$query->row_array();
		return $result['opaning_bal'];
}
/////////////////////////////////////////////////////
function get_opening_balance_new_reg($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(case when sm.admission_session='$year' then (ad.opening_balance) else null end) as opaning_bal_new,sum(case when sm.admission_session!='$year' then (ad.opening_balance) else null end) as opaning_bal_reg");
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as sm','sm.stud_id=ad.student_id AND sm.enrollment_no!=""','left');
		
		$DB1->where('ad.academic_year',$year);
		$DB1->where('ad.cancelled_admission','N');
		if($year >='2020'){
			$DB1->where('admission_confirm','Y');
			}
		$query=$DB1->get();
	//	echo $DB1->last_query();
	$result=$query->row_array();
	return $result;
}

function get_opening_balance_new($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(ad.opening_balance) as opaning_bal");
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as sm','sm.stud_id=ad.student_id AND sm.enrollment_no!=""','left');
			$DB1->where('ad.academic_year',$year);
			$DB1->where('ad.cancelled_admission','N');
			
			$where=" sm.admission_session='$year'";
		//$DB1->where('sm.admission_confirm','Y');
		$DB1->where($where);
		$query=$DB1->get();
	//	echo $DB1->last_query();
	$result=$query->row_array();
		return $result['opaning_bal'];
}

function get_opening_balance_reg($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(ad.opening_balance) as opaning_bal");
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as sm','sm.stud_id=ad.student_id AND sm.enrollment_no!=""','left');
			$DB1->where('ad.academic_year',$year);
			$DB1->where('ad.cancelled_admission','N');
			if($year >='2020'){
			$DB1->where('admission_confirm','Y');
			}
			$where=" sm.admission_session!='$year'";
		//$DB1->where('sm.admission_confirm','Y');
		$DB1->where($where);
		$query=$DB1->get();
	//	echo $DB1->last_query();
	$result=$query->row_array();
		return $result['opaning_bal'];
}

function getchartdata($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
       // $stream="select programme_code from stream_master where stream_id='".$stream_id."'";
      //  $stmdet = $DB1->query($stream);
     //  $stream_details =  $stmdet->result_array();
	
	$query =	$DB1->query("select vsd.course_short_name as course,count(sm.stud_id) as count from student_master sm 
join vw_stream_details vsd on sm.admission_stream = vsd.stream_id
where  sm.admission_session='$year' and sm.cancelled_admission='N' and admission_confirm='Y' and cancelled_admission='N' GROUP by vsd.course_id order by count(sm.stud_id) desc");
//echo "select vsd.course_short_name as course,count(sm.stud_id) as count from student_master sm ,vw_stream_details vsd where sm.admission_stream = vsd.stream_id and sm.admission_session=$year and sm.cancelled_admission='N' GROUP by vsd.course_id";

	//	$query=$DB1->get();
	$result=$query->result_array();
	//var_dump($result);
	return json_encode($result, JSON_NUMERIC_CHECK);
//	exit(0);
	//	return $result;
}


function getExemfee($year)
{
    
      $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(actual_fee - applicable_fee) as exemfee");
		$DB1->from('admission_details');
		$DB1->where('academic_year',$year);
			$DB1->where('cancelled_admission','N');
		$query=$DB1->get();
	$result=$query->row_array();
		return $result['exemfee'];
}


function getExemfee_new_reg($year)
{
    
        $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(case when sm.admission_session='$year' then (ad.actual_fee - ad.applicable_fee) else null end) as exemfee_new,sum(case when sm.admission_session!='$year' then (ad.actual_fee - ad.applicable_fee) else null end) as exemfee_reg");
		
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as sm','sm.stud_id=ad.student_id','left');
		
		$DB1->where('ad.academic_year',$year);
		$DB1->where('ad.cancelled_admission','N');
		if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}
	
		$query=$DB1->get();
	    $result=$query->row_array();
		return $result;
}
function getExemfee_new_reg_23($year)
{
    
        $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(case when sm.admission_session='$year' then (ad.actual_fee - ad.applicable_fee) else null end) as exemfee_new,sum(case when sm.admission_session!='$year' then (ad.actual_fee - ad.applicable_fee) else null end) as exemfee_reg");
		
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as sm','sm.stud_id=ad.student_id','left');
		
		$DB1->where('ad.academic_year',$year);
		$DB1->where('ad.cancelled_admission','N');
		//$DB1->where('sm.admission_confirm','Y');
	
		$query=$DB1->get();
	    $result=$query->row_array();
		return $result;
}
function getExemfee_new($year)
{
    
      $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(ad.actual_fee - ad.applicable_fee) as exemfee");
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as sm','sm.stud_id=ad.student_id','left');
		
		$DB1->where('ad.academic_year',$year);
		$DB1->where('ad.cancelled_admission','N');
		if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}
		$WHERE=" sm.admission_session='$year'";
        $DB1->where($WHERE);
		$query=$DB1->get();
	    $result=$query->row_array();
		return $result['exemfee'];
}

function getExemfee_reg($year)
{
    
      $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(ad.actual_fee - ad.applicable_fee) as exemfee");
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as sm','sm.stud_id=ad.student_id','left');
		
		$DB1->where('ad.academic_year',$year);
		$DB1->where('ad.cancelled_admission','N');
		if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}
		$WHERE=" sm.admission_session!='$year'";
        $DB1->where($WHERE);
		$query=$DB1->get();
	    $result=$query->row_array();
		return $result['exemfee'];
}

function fees_from_cancelled($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(applicable_fee) as totalfee");
		$DB1->from('admission_details');
			$DB1->where('academic_year',$year);
			$DB1->where('cancelled_admission','N');
		$query=$DB1->get();
	//	echo $DB1->last_query();
	$result=$query->row_array();
		return $result['totalfee'];
}

function fees_refunds($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(amount) as totalrefund");
		$DB1->from('fees_refunds fd');
			$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
	
			$DB1->where('fd.academic_year',$year);
			$DB1->where('fd.is_deleted','N');
			//$DB1->where('fd.refund_date <=','2018-03-31');
		$query=$DB1->get();
	//	echo $DB1->last_query();
	$result=$query->row_array();
		return $result['totalrefund'];
}

function fees_refunds_new_reg($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);

	   $DB1->select("sum(case when sm.admission_session='$year' then (amount) else null end) as totalrefund_new,sum(case when sm.admission_session!='$year' then (amount) else null end) as totalrefund_reg");
		
		$DB1->from('fees_refunds fd');
		$DB1->JOIN('student_master as sm','sm.stud_id=fd.student_id AND sm.enrollment_no!=""','inner');

			$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
	
			$DB1->where('fd.academic_year',$year);
			$DB1->where('fd.is_deleted','N');
			$DB1->where('ad.cancelled_admission','N');
			if($year >='2020'){
			$DB1->where('admission_confirm','Y');
			}
			//$DB1->where('sm.admission_confirm','Y');
			
		$query=$DB1->get();
	//echo $DB1->last_query();
	$result=$query->row_array();
		return $result;
}
function fees_refunds_new_reg_23($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);

	   $DB1->select("sum(case when sm.admission_session='$year' then (amount) else null end) as totalrefund_new,sum(case when sm.admission_session!='$year' then (amount) else null end) as totalrefund_reg");
		
		$DB1->from('fees_refunds fd');
		$DB1->JOIN('student_master as sm','sm.stud_id=fd.student_id AND sm.enrollment_no!=""','inner');

			$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
	
			$DB1->where('fd.academic_year',$year);
			$DB1->where('fd.is_deleted','N');
			//$DB1->where('sm.admission_confirm','Y');
			
		$query=$DB1->get();
	//echo $DB1->last_query();
	$result=$query->row_array();
		return $result;
}
function fees_refunds_new($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(amount) as totalrefund");
		$DB1->from('fees_refunds fd');
		$DB1->JOIN('student_master as sm','sm.stud_id=fd.student_id AND sm.enrollment_no!=""','inner');

			$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
	
			$DB1->where('fd.academic_year',$year);
			$DB1->where('fd.is_deleted','N');
			$DB1->where('ad.cancelled_admission','N');
			if($year >='2020'){
			$DB1->where('admission_confirm','Y');
			}
			$WHERE=" sm.admission_session='$year'";
            $DB1->where($WHERE);
			//$DB1->where('fd.refund_date <=','2018-03-31');
		$query=$DB1->get();
	//	echo $DB1->last_query();
	$result=$query->row_array();
		return $result['totalrefund'];
}
function fees_refunds_reg($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(amount) as totalrefund");
		$DB1->from('fees_refunds fd');
		$DB1->JOIN('student_master as sm','sm.stud_id=fd.student_id AND sm.enrollment_no!=""','inner');

			$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
	
			$DB1->where('fd.academic_year',$year);
			$DB1->where('fd.is_deleted','N');
			if($year >='2020'){
			$DB1->where('admission_confirm','Y');
			}
			
			$WHERE=" sm.admission_session!='$year'";
            $DB1->where($WHERE);
			//$DB1->where('fd.refund_date <=','2018-03-31');
		$query=$DB1->get();
	//	echo $DB1->last_query();
	$result=$query->row_array();
		return $result['totalrefund'];
}

function getFeeReceived($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(fd.amount) as fee_received");
		$DB1->from('fees_details fd');
		
		$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
			$DB1->where('ad.academic_year',$year);
		$DB1->where('fd.type_id',2);
		$DB1->where('ad.cancelled_admission','N');
	$DB1->where('fd.chq_cancelled','N');
	//$DB1->where('fd.fees_date <=','2018-03-31');
		$query=$DB1->get();
		//echo $DB1->last_query();
		//exit(0);
	$result=$query->row_array();
		return $result['fee_received'];
}

/////////////////////////////////////////////////////////////////////////


function getFeeReceived_new_reg($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(fd.amount) as fee_received");
		$DB1->select("sum(case when sm.admission_session='$year' then (fd.amount) else null end) as fee_received_new,sum(case when sm.admission_session!='$year' and fd.is_deleted='N' then (fd.amount) else null end) as fee_received_reg");
		$DB1->from('fees_details fd');
		$DB1->join('student_master as sm','sm.stud_id=fd.student_id AND sm.enrollment_no!=""','inner');

		$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
	
		$DB1->where('ad.academic_year',$year);
		$DB1->where('fd.type_id',2);
		$DB1->where('ad.cancelled_admission','N');
		$DB1->where('fd.chq_cancelled','N');
		if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}
		
		
		$query=$DB1->get();
	//echo $DB1->last_query();exit;
	    $result=$query->row_array();
		return $result;
}

function getFeeReceived_new_reg_23($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(fd.amount) as fee_received");
		$DB1->select("sum(case when sm.admission_session='$year' then (fd.amount) else null end) as fee_received_new,sum(case when sm.admission_session!='$year' and fd.is_deleted='N' then (fd.amount) else null end) as fee_received_reg");
		$DB1->from('fees_details fd');
		$DB1->join('student_master as sm','sm.stud_id=fd.student_id AND sm.enrollment_no!=""','inner');

		$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
	
		$DB1->where('ad.academic_year',$year);
		$DB1->where('fd.type_id',2);
		$DB1->where('ad.cancelled_admission','N');
		$DB1->where('fd.chq_cancelled','N');
		//$DB1->where('sm.admission_confirm','Y');
		
		$query=$DB1->get();
	//echo $DB1->last_query();exit;
	    $result=$query->row_array();
		return $result;
}
function getFeeReceived_new($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(fd.amount) as fee_received");
		$DB1->from('fees_details fd');
		$DB1->join('student_master as sm','sm.stud_id=fd.student_id AND sm.enrollment_no!=""','inner');

		$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
		$DB1->where('ad.academic_year',$year);
		$DB1->where('fd.type_id',2);
		$DB1->where('ad.cancelled_admission','N');
		if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}
	    $DB1->where('fd.chq_cancelled','N');
		$WHERE=" sm.admission_session='$year'";
        $DB1->where($WHERE);
	//$DB1->where('fd.fees_date <=','2018-03-31');
		$query=$DB1->get();
		//echo $DB1->last_query();
		//exit(0);
	$result=$query->row_array();
		return $result['fee_received'];
}

function getFeeReceived_reg($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(fd.amount) as fee_received");
		$DB1->from('fees_details fd');
		$DB1->join('student_master as sm','sm.stud_id=fd.student_id AND sm.enrollment_no!=""','inner');

		$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
		$DB1->where('ad.academic_year',$year);
		$DB1->where('fd.type_id',2);
		$DB1->where('ad.cancelled_admission','N');
	    $DB1->where('fd.chq_cancelled','N');
		$DB1->where('fd.is_deleted','N');
		if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}
		
		$WHERE=" sm.admission_session!='$year'";
        $DB1->where($WHERE);
	//$DB1->where('fd.fees_date <=','2018-03-31');
		$query=$DB1->get();
		//echo $DB1->last_query();
		//exit(0);
	$result=$query->row_array();
		return $result['fee_received'];
}

function geOtherFees($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(fd.canc_charges) as other_fees");
		$DB1->from('fees_details fd');
		
		$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
			$DB1->where('ad.academic_year',$year);
		$DB1->where('fd.type_id',2);
		$DB1->where('ad.cancelled_admission','N');
//	$DB1->where('fd.chq_cancelled','N');
	
		$query=$DB1->get();
//	echo $DB1->last_query();
	//	exit(0);
	$result=$query->row_array();
		return $result['other_fees'];
}
///////////////////////////////////////////////////////////
function geOtherFees_new_reg($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
	
		$DB1->select("sum(case when sm.admission_session='$year' then (fd.canc_charges) else null end) as other_fees_new,sum(case when sm.admission_session!='$year'  then (fd.canc_charges) else null end) as other_fees_reg");
	
		$DB1->from('fees_details fd');
		
		$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
		$DB1->join('student_master as sm','sm.stud_id=fd.student_id AND sm.enrollment_no!=""','inner');

		$DB1->where('ad.academic_year',$year);
		$DB1->where('fd.type_id',2);
		$DB1->where('ad.cancelled_admission','N');
		if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}
       $query=$DB1->get();
//echo $DB1->last_query();
	   $result=$query->row_array();
		return $result;
}




function geOtherFees_new($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(fd.canc_charges) as other_fees");
		$DB1->from('fees_details fd');
		
		$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
		$DB1->join('student_master as sm','sm.stud_id=fd.student_id AND sm.enrollment_no!=""','inner');

		$DB1->where('ad.academic_year',$year);
		$DB1->where('fd.type_id',2);
		$DB1->where('ad.cancelled_admission','N');
		$where=" sm.admission_session='$year'";
        $DB1->where($where);
//	$DB1->where('fd.chq_cancelled','N');
	
		$query=$DB1->get();
//	echo $DB1->last_query();
	//	exit(0);
	$result=$query->row_array();
		return $result['other_fees'];
}


function geOtherFees_reg($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(fd.canc_charges) as other_fees");
		$DB1->from('fees_details fd');
		
		$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
		$DB1->join('student_master as sm','sm.stud_id=fd.student_id AND sm.enrollment_no!=""','inner');

		$DB1->where('ad.academic_year',$year);
		$DB1->where('fd.type_id',2);
		$DB1->where('ad.cancelled_admission','N');
		if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}
		
		$where=" sm.admission_session!='$year'";
        $DB1->where($where);
//	$DB1->where('fd.chq_cancelled','N');
	
		$query=$DB1->get();
//	echo $DB1->last_query();
	//	exit(0);
	$result=$query->row_array();
		return $result['other_fees'];
}

function getTotalAdm_reg($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
$DB1->select("COUNT(ad.student_id) AS totstud, 
SUM(CASE WHEN ad.academic_year=sm.admission_session THEN 1 ELSE 0 END) AS new_adm, 
SUM(CASE WHEN ad.academic_year!=sm.admission_session THEN 1 ELSE 0 END) AS rr_adm");
//	$DB1->select("count(stud_id) as totstud,SUM(CASE WHEN  admission_session=$year THEN 1 ELSE 0 END) AS new_adm,SUM(CASE WHEN  academic_year!=admission_session THEN 1 ELSE 0 END) AS rr_adm ");
		
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as sm','sm.stud_id=ad.student_id and sm.enrollment_no != ""','LEFT');
		$DB1->where('ad.cancelled_admission','N');
	    //$DB1->where('sm.cancelled_admission','N');
		//$DB1->where('sm.is_detained','N');
		if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}
		$DB1->where('ad.academic_year',$year);
		$query=$DB1->get();
	$result=$query->row_array();
//	echo $DB1->last_query();
		return $result;
}
function getTotalAdm($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
$DB1->select("count(stud_id) as totstud,SUM(CASE WHEN  academic_year=admission_session THEN 1 ELSE 0 END) AS new_adm,SUM(CASE WHEN  academic_year!=admission_session THEN 1 ELSE 0 END) AS rr_adm ");
//	$DB1->select("count(stud_id) as totstud,SUM(CASE WHEN  admission_session=$year THEN 1 ELSE 0 END) AS new_adm,SUM(CASE WHEN  academic_year!=admission_session THEN 1 ELSE 0 END) AS rr_adm ");
		
		$DB1->from('student_master');
	    $DB1->where('cancelled_admission','N');
		if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}
		$DB1->where('academic_year',$year);
		$query=$DB1->get();
	$result=$query->row_array();
//	echo $DB1->last_query();
		return $result;
}
function getTotalAdmNew($year)
{
        $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("count(stud_id) as newadd,SUM((CASE  WHEN nationality='INTERNATIONAL' THEN 1 ELSE 0 END)) AS ing");
		$DB1->from('student_master as sm');
		$DB1->join('admission_details as ad','sm.stud_id=ad.student_id and sm.enrollment_no != "" and sm.academic_year=sm.academic_year','INNER');
		if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}
		$DB1->where('ad.cancelled_admission','N');
		$DB1->where('sm.admission_session',$year);
		$DB1->where('ad.academic_year',$year);
		
		if($year=="2021"){
		$where="sm.enrollment_no!='' AND sm.enrollment_no_new !=''";
		}else{
		$where="sm.enrollment_no!=''";
		}
				$DB1->where($where);
		$query=$DB1->get();
	$result=$query->row_array();
	//echo $DB1->last_query();
		return $result;
}
function getTotalAdmNew_23($year)
{
        $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("count(stud_id) as newadd,SUM((CASE  WHEN nationality='INTERNATIONAL' THEN 1 ELSE 0 END)) AS ing");
		$DB1->from('student_master');
		//$DB1->where('admission_confirm','Y');
		$DB1->where('cancelled_admission','N');
		$DB1->where('admission_session',$year);
		
		if($year=="2023"){
		$where="`enrollment_no`!='' AND `enrollment_no_new` !=''";
		}else{
		$where="`enrollment_no`!=''";
		}
				$DB1->where($where);
		$query=$DB1->get();
	$result=$query->row_array();
	//echo $DB1->last_query();exit;
		return $result;
}
function getTotalAdmAll($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		
		
		$DB1->select("count(sm.stud_id) as totstud");
		$DB1->from('admission_details as ad');
		//$DB1->where('cancelled_admission','N');
		$DB1->join('student_master as sm','sm.stud_id=ad.student_id and sm.enrollment_no != ""','LEFT');
		$where="ad.academic_year='".$year."' and sm.admission_confirm='Y' AND sm.admission_session!='".$year."'";
	    $DB1->where($where);
		//$DB1->where('academic_year',$year);
			//	$DB1->where('year',$year);
			/*if($year=="2020"){
		$where="`year`!='1'";
		}else{
			$where="";
		}
		//echo $where;
		$DB1->where($where);*/
		//exit();
		$query=$DB1->get();
	$result=$query->row_array();
	//echo $DB1->last_query();//exit;
		return $result;
}

function getTotal($year)
{
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(case when s.gender='M' then 1 else 0 end )as 'male', sum(case when s.gender='F' then 1 else 0 end )as 'female',sum(case when s.lateral_entry ='N' then 1 else 0 end )as 'firstyear', sum(case when s.lateral_entry ='Y' then 1 else 0 end )as 'lateral',sum(case when s.domicile_status ='MS' then 1 else 0 end )as 'ms', sum(case when s.domicile_status ='OMS' then 1 else 0 end )as 'oms'");
		$DB1->from('student_master as s');
		//	$DB1->join('admission_details as am','s.stud_id=am.student_id ','left');
		//	$DB1->where('am.cancelled_admission','N');
			$DB1->where('s.cancelled_admission','N');	
			if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}
			$DB1->where('s.admission_session',$year);
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
return	$result=$query->row_array();
}

function getGenderwiseTotal($year){
    
    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(case when s.gender='M' then 1 else 0 end )as 'male', sum(case when s.gender='F' then 1 else 0 end )as 'female'");
		$DB1->from('student_master as s');
		//	$DB1->join('admission_details as am','s.stud_id=am.student_id ','left');
		//	$DB1->where('am.cancelled_admission','N');
			$DB1->where('s.cancelled_admission','N');	
			if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}		
			$DB1->where('s.admission_session',$year);
		$query=$DB1->get();
return	$result=$query->row_array();
    
}

function getYearwiseTotal($year){
    
    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(case when s.lateral_entry ='N' then 1 else 0 end )as 'firstyear', sum(case when s.lateral_entry ='Y' then 1 else 0 end )as 'lateral' ");
		$DB1->from('student_master as s');
		//	$DB1->join('admission_details as am','s.stud_id=am.student_id ','left');
			//$DB1->where('am.cancelled_admission','N');
	$DB1->where('s.cancelled_admission','N');		
	if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}		
			$DB1->where('s.admission_session',$year);
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
return	$result=$query->row_array();
    
}

function getDomacilewiseTotal($year){
    
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(case when s.domicile_status ='MS' then 1 else 0 end )as 'ms', sum(case when s.domicile_status ='OMS' then 1 else 0 end )as 'oms' ");
		$DB1->from('student_master as s');
		//	$DB1->join('admission_details as am','s.stud_id=am.student_id ','left');
		//	$DB1->where('am.cancelled_admission','N');
			$DB1->where('s.cancelled_admission','N');
			if($year >='2020'){
		$DB1->where('admission_confirm','Y');
		}
			$DB1->where('s.admission_session',$year);
		$query=$DB1->get();
        return	$result=$query->row_array();
    
}
function get_fees_details_fromdb($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);		
		$DB1->select("*");		
		$DB1->from('fees_dashboard ');		
		$DB1->where('academic_year',$year);
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		$result=$query->row_array();
		return $result;
}




}