<?php
class Reports_status_model extends CI_Model 
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
		$DB1->join('student_master as s','s.stud_id=ad.student_id and s.academic_year = ad.academic_year','INNER');
		$DB1->where('s.reported_status','Y');
		$DB1->where('ad.academic_year',$year);
		$DB1->where('ad.cancelled_admission','N');
		
		$query=$DB1->get();
	//	echo $DB1->last_query();
	$result=$query->row_array();
		return $result['totalfee'];
}


function get_opening_balance($year)
{
        $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(ad.opening_balance) as opaning_bal");
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as s','s.stud_id=ad.student_id and s.academic_year = ad.academic_year','INNER');
		$DB1->where('s.reported_status','Y');
		$DB1->where('ad.academic_year',$year);
		$DB1->where('ad.cancelled_admission','N');
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
	
	$query =	$DB1->query("select vsd.course_short_name as course,count(sm.stud_id) as count from student_master sm ,
	vw_stream_details vsd where sm.admission_stream = vsd.stream_id and sm.admission_session=$year 
	and sm.cancelled_admission='N' AND sm.reported_status='Y' GROUP by vsd.course_id");
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
		$DB1->select("sum(ad.actual_fee - ad.applicable_fee) as exemfee");
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as s','s.stud_id=ad.student_id and s.academic_year = ad.academic_year','INNER');
		$DB1->where('s.reported_status','Y');
		$DB1->where('ad.academic_year',$year);
		$DB1->where('ad.cancelled_admission','N');
		$query=$DB1->get();
	$result=$query->row_array();
		return $result['exemfee'];
}

function fees_from_cancelled($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(ad.applicable_fee) as totalfee");
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as s','s.stud_id=ad.student_id and s.academic_year = ad.academic_year','INNER');
		$DB1->where('s.reported_status','Y');
		$DB1->where('ad.academic_year',$year);
		$DB1->where('ad.cancelled_admission','N');
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
		$DB1->join('student_master as s','s.stud_id=fd.student_id and s.academic_year = fd.academic_year','INNER');
		$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
		$DB1->where('s.reported_status','Y');
		$DB1->where('fd.academic_year',$year);
		$DB1->where('fd.is_deleted','N');
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
		
		$DB1->join('student_master as s','s.stud_id=fd.student_id and s.academic_year = fd.academic_year','INNER');
		$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
	   
		$DB1->where('s.reported_status','Y');
		$DB1->where('ad.academic_year',$year);
		
		$DB1->where('fd.type_id',2);
		$DB1->where('ad.cancelled_admission','N');
	    $DB1->where('fd.chq_cancelled','N');
	
		$query=$DB1->get();
//		echo $DB1->last_query();
	//	exit(0);
	$result=$query->row_array();
		return $result['fee_received'];
}

function geOtherFees($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(fd.canc_charges) as other_fees");
		$DB1->from('fees_details fd');
		$DB1->join('student_master as s','s.stud_id=fd.student_id and s.academic_year = fd.academic_year','INNER');
		$DB1->join('admission_details as ad','fd.student_id=ad.student_id and fd.academic_year = ad.academic_year','join');
		
		$DB1->where('s.reported_status','Y');
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


function getTotalAdm($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
$DB1->select("count(stud_id) as totstud,SUM(CASE WHEN  academic_year=admission_session THEN 1 ELSE 0 END) AS new_adm,SUM(CASE WHEN  academic_year!=admission_session THEN 1 ELSE 0 END) AS rr_adm ");
//	$DB1->select("count(stud_id) as totstud,SUM(CASE WHEN  admission_session=$year THEN 1 ELSE 0 END) AS new_adm,SUM(CASE WHEN  academic_year!=admission_session THEN 1 ELSE 0 END) AS rr_adm ");
		
		$DB1->from('student_master');
		$DB1->where('cancelled_admission','N');
		$DB1->where('academic_year',$year);
		$DB1->where('reported_status','Y');
		$query=$DB1->get();
	$result=$query->row_array();
//	echo $DB1->last_query();
		return $result;
}

function getTotalAdmNew($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("count(stud_id) as newadd");
		$DB1->from('student_master');
		$DB1->where('cancelled_admission','N');
		$DB1->where('admission_session',$year);
		$DB1->where('reported_status','Y');
		$query=$DB1->get();
	$result=$query->row_array();
	//echo $DB1->last_query();
		return $result;
}

function getTotalAdmAll($year)
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("count(ad.student_id) as totstud");
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as s','s.stud_id=ad.student_id and s.academic_year = ad.academic_year','INNER');
		$DB1->where('s.reported_status','Y');
		$DB1->where('ad.cancelled_admission','N');
		$DB1->where('ad.academic_year',$year);
		$query=$DB1->get();
	$result=$query->row_array();
//	echo $DB1->last_query();
		return $result;
}

function getGenderwiseTotal($year){
    
    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(case when s.gender='M' then 1 else 0 end )as 'male', sum(case when s.gender='F' then 1 else 0 end )as 'female'");
		$DB1->from('student_master as s');
		//	$DB1->join('admission_details as am','s.stud_id=am.student_id ','left');
		//	$DB1->where('am.cancelled_admission','N');
			$DB1->where('s.cancelled_admission','N');		
			$DB1->where('s.admission_session',$year);
			$DB1->where('s.reported_status','Y');
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
			
	$DB1->where('s.admission_session',$year);
	$DB1->where('s.reported_status','Y');
		$query=$DB1->get();
	//	echo $DB1->last_query();
return	$result=$query->row_array();
    
}

function getDomacilewiseTotal($year){
    
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(case when s.domicile_status ='MS' then 1 else 0 end )as 'ms', sum(case when s.domicile_status ='OMS' then 1 else 0 end )as 'oms' ");
		$DB1->from('student_master as s');
		//	$DB1->join('admission_details as am','s.stud_id=am.student_id ','left');
		//	$DB1->where('am.cancelled_admission','N');
			$DB1->where('s.cancelled_admission','N');		
			$DB1->where('s.admission_session',$year);
			$DB1->where('s.reported_status','Y');
		$query=$DB1->get();
        return	$result=$query->row_array();
    
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
        from admission_details ad
		INNER join student_master s on s.stud_id=ad.student_id
		left join vw_stream_details v on v.stream_id=ad.stream_id 
        left join
        (select distinct student_id,academic_year,count(student_id)as total_count,sum( case when chq_cancelled='N' then amount else 0 end) as amount, sum( case when chq_cancelled='Y' then canc_charges else 0 end) as charges   from  fees_details where  is_deleted='N' and type_id='2'
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
 public function get_cancle_admission_details($row){
     	$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("count(distinct ad.student_id) as cancel_count,sum(c.canc_fee) as cancel_fee");
		$DB1->from('admission_details as ad');
		$DB1->join('admission_cancellations as c','c.stud_id=ad.student_id','left');
		#$DB1->join('student_master as s','s.stud_id=ad.student_id and s.academic_year = ad.academic_year','inner');
		#$DB1->where('s.reported_status','Y');
		$DB1->where('ad.cancelled_admission', 'Y');
		$DB1->where('ad.academic_year',$row);
		
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
	    $result=$query->result_array();
		return $result;
     
 }


}