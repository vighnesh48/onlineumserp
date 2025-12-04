<?php
class Account_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
       
    }
 public function get_fees_collection_admission($data){
	   
	   /* code by vighnesh */
	    $role_id = $this->session->userdata('role_id');
	   
		$emp_id = $this->session->userdata("name");
		

		/* end by vighnesh */
     	$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("v.is_partnership,v.partnership_code,s.stud_id,s.enrollment_no,s.enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,v.school_short_name,v.course_short_name, v.stream_short_name,d.year,f.amount as paid,s.cancelled_admission, f.fees_paid_type,f.receipt_no as ddno,f.amount ,date_format(f.fees_date,'%d-%m-%Y') as fdate,f.college_receiptno,f.chq_cancelled ,f.remark,b.bank_name,b.bank_short_name,s.cancelled_admission ,d.actual_fee,d.applicable_fee");
		$DB1->from('admission_details as d');
		$DB1->join('student_master as s','s.stud_id = d.student_id  AND d.academic_year=s.academic_year  AND s.enrollment_no!=""','left');
		$DB1->join('vw_stream_details as v','s.admission_stream = v.stream_id','left');
	   $DB1->join('fees_details as f','f.student_id = s.stud_id and f.academic_year=d.academic_year','left');
//	$DB1->join('fees_details as f','f.student_id =CAST(s.stud_id AS CHAR) and f.academic_year=d.academic_year','left');

		$DB1->join('bank_master as b','f.bank_id=b.bank_id' ,'left');
		if(isset($role_id) && $role_id==20){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			  $DB1->where('v.school_code!=',$schid);
			
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$DB1->where('v.school_code!=',$sccode);
				
		}
		$DB1->where('f.is_deleted ', 'N');
		//$sql .=" AND vw.school_code = $sccode";
	//	$DB1->where('f.chq_cancelled ', 'N');
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
		 if($data['school_code'] !="" && $data['school_code'] !=0){
			 $DB1->where('v.school_code',$data['school_code']);   
         }

		 if($data['admission-course'] !="" ){
			  $DB1->where('v.course_id',$data['admission-course']); 
         }
        
		 if($data['admission-branch'] !="" && $data['admission-branch'] !=0 ){
			   $DB1->where('v.stream_id',$data['admission-branch']); 
         }
        
	  
		$DB1->order_by("v.stream_name,s.cancelled_admission,s.current_year,s.enrollment_no", "asc");
		$query=$DB1->get();
//	  echo $DB1->last_query();//exit;
			$result=$query->result_array();
		return $result;
 }
 
  /* code by vighnesh */
 function loadempschool($emp_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT v.school_code,f.department from vw_faculty f 
		LEFT JOIN sandipun_erp.employee_master e  ON e.emp_id=f.emp_id
		INNER JOIN school_master c  ON c.erp_mapp_school_id=f.emp_school
		LEFT JOIN vw_stream_details v ON v.school_id=c.school_id where f.emp_id='$emp_id' group by v.school_code
		";
        $query = $DB1->query($sql);
        return $query->result_array();
 }
 
 /* end by vighnesh */
 public function get_studentwise_admission_fees($data){
	
	 $role_id = $this->session->userdata('role_id');
	 $emp_id = $this->session->userdata("name");
     $DB1 = $this->load->database('umsdb', TRUE);
	 
	 
	 if($data['academic_year']==2020){
		  if($data['admission_type']=="N"){//new
         $cond =" AND sm.admission_session='".$data['academic_year']."' AND  sm.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N' AND sm.admission_confirm='Y'" ;//sm.admission_confirm='Y'
	    }else if($data['admission_type']=="R"){//Register
	        $cond =" AND ad.academic_year='".$data['academic_year']."'  AND  sm.`cancelled_admission` = 'N'   AND sm.admission_session!='".$data['academic_year']."' AND ad.`cancelled_admission` = 'N' AND sm.admission_confirm='Y'";//AND sm.admission_confirm='Y' AND ad.`enrollment_no` != ''
	    
		}else{//BOTH
	        $cond ="  AND sm.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N' AND sm.admission_confirm='Y'"; //AND sm.admission_confirm='Y'
	    }
		
	 }else{
		 
		 
       if($data['admission_type']=="N"){
         $cond =" AND sm.admission_session='".$data['academic_year']."' AND  sm.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N'" ;//sm.admission_confirm='Y'
	    }else if($data['admission_type']=="R")
	    {
	        $cond =" AND ad.academic_year='".$data['academic_year']."'  AND  sm.`cancelled_admission` = 'N'  AND ad.`enrollment_no` != '' AND sm.admission_session!='".$data['academic_year']."' AND ad.`cancelled_admission` = 'N'";//AND sm.admission_confirm='Y' 
	    }
	    else 
	    {
	        $cond ="  AND sm.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N'"; //AND sm.admission_confirm='Y'
	    }
		
		
	 }
		
         if($data['get_by']=="stream"){
              $cond.=" AND sm.admission_stream='".$data['stream_id']."' and ad.year ='".$data['year']."'";
         }
         else
         {
             $cond.="";
         }
		 
		 if($data['school_code'] !="" && $data['school_code'] !=0){
              $cond.=" AND v.school_code='".$data['school_code']."'";
         }
         else
         {
             $cond.="";
         }
		 if($data['admission-course'] !="" ){
              $cond.=" AND v.course_id='".$data['admission-course']."'";
         }
         else
         {
             $cond.="";
         }
		 if($data['admission-branch'] !="" && $data['admission-branch'] !=0 ){
              $cond.=" AND v.stream_id='".$data['admission-branch']."'";
         }
         else
         {
             $cond.="";
         }
		 
		 $cond .=" AND sm.enrollment_no not in (190101061007,190101061019,190101062024,190101062018,190101062039,170101061018,190101082020,180101091012,180101091030,180101092035,190101181011,180105041031,180105181052,190105141005,190114021005,190102011125,190102011141,180102011081,180102011120,190104051006,190104061003,190104061002,190104071004,190106191006,180101061004,180101061034)";
		 
         if($data['report_type']=="4" || $data['report_type']=="8"){
             //$cond .="  and ad.cancelled_admission='N' and sm.admission_cycle is null";
             $hav="  having  ((applicable_total + opening_balance + COALESCE(cancel_charges,0)) -(fees_total-refund)) >0 ";
         }
		 $condition1='';
		 if(isset($role_id) && $role_id==20){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $condition1 .=" AND v.school_code = $schid AND sm.admission_cycle IS NULL ";
			  //$DB1->where('v.school_code!=',$schid);
			
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$condition1 .=" AND v.school_code = $sccode" ;
				
		}
		
		
		
		
		
		 
     $sql="select v.is_partnership,v.partnership_code,sm.stud_id, sm.enrollment_no,sm.enrollment_no_new,sm.first_name,sm.middle_name,sm.last_name,sm.religion,sm.category,sm.sub_caste,sm.mobile,pd.parent_mobile2,sm.reported_status, COALESCE (sm.reported_date,'--') as reported_date,
	 sm.gender,sm.admission_cycle,v.school_short_name,v.school_name,v.course_name,v.stream_name,v.course_short_name as course,v.stream_short_name,v.stream_id,ad.year as admission_year,sum(ad.applicable_fee) as applicable_total ,sum(ad.actual_fee) as actual_fees,sum(case when f.amount is null then 0 else f.amount end ) as fees_total,sum(f.charges) as cancel_charges, count(ad.student_id) as stud_total ,ad.cancelled_admission,sum(case when rf.amount is null then 0 else rf.amount end )as refund ,
	 ad.academic_year,ad.opening_balance
	 
	 from admission_details ad 
	 left join vw_stream_details v on v.stream_id=ad.stream_id 
     left join ( select distinct student_id,academic_year,count(student_id)as total_count,sum( case when chq_cancelled='N' then amount else 0 end) as amount,sum( case when chq_cancelled='Y' then canc_charges else 0 end) as charges from fees_details where is_deleted='N' and type_id='2' group by student_id,academic_year) f on CAST(ad.student_id  AS CHAR)=f.student_id and ad.academic_year=f.academic_year 
	 left join student_master sm on sm.stud_id=ad.student_id AND sm.enrollment_no!=''
	 left join parent_details pd on sm.stud_id=pd.student_id    
     left join ( SELECT DISTINCT student_id,academic_year,SUM( CASE WHEN is_deleted='N' THEN amount ELSE 0 END) AS amount FROM fees_refunds WHERE is_deleted='N'
	  GROUP BY student_id,academic_year) rf ON ad.student_id=rf.student_id AND ad.academic_year=rf.academic_year
     where  ad.academic_year='".$data['academic_year']."'   ". $cond.$condition1."  
	 group by sm.stud_id,course,v.stream_id,admission_year ".$hav." 
	 order by v.school_short_name,v.course_short_name,ad.cancelled_admission,admission_year,sm.enrollment_no asc";
        $query=$DB1->query($sql);
		//#,CASE WHEN e.enrollment_no is not null THEN 'Filled' ELSE 'Not Filled'END AS Exam_form_status AND sm.`admission_cycle`!='' 
		//# LEFT JOIN exam_details e ON sm.stud_id = e.stud_id and e.exam_id=13 AND sm.`admission_cycle`!=''
      // echo $DB1->last_query(); 
	  // exit;
		$result=$query->result_array();
		return $result;
   
 }
 
 public function get_streamwise_admission_fees($data){
     
	 
	  /*  if($data['admission_type']=="N"){
         $cond ="and st.admission_session=".$data['academic_year'];
		 
		 $cond ="and st.admission_confirm='Y'";
		 
	    }elseif($data['admission_type']=="R"){
	      $cond ="and st.admission_session!=".$data['academic_year'];
	    }else{
	       $cond ="and st.academic_year=".$data['academic_year']; 
	    }*/
		
		 if($data['academic_year']==2020){
		  if($data['admission_type']=="N"){//new
         $cond =" AND st.admission_session='".$data['academic_year']."' AND  st.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N' AND st.admission_confirm='Y'" ;//sm.admission_confirm='Y'
	    }else if($data['admission_type']=="R"){//Register
	        $cond =" AND ad.academic_year='".$data['academic_year']."'  AND  st.`cancelled_admission` = 'N'   AND st.admission_session!='".$data['academic_year']."' AND ad.`cancelled_admission` = 'N' AND st.admission_confirm='Y'";//AND sm.admission_confirm='Y' AND ad.`enrollment_no` != ''
	    
		}else{//BOTH
	        $cond ="  AND st.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N' AND st.admission_confirm='Y'"; //AND sm.admission_confirm='Y'
	    }
		
	 }else{
		 
		 
       if($data['admission_type']=="N"){
         $cond =" AND st.admission_session='".$data['academic_year']."' AND  st.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N'" ;//sm.admission_confirm='Y'
	    }else if($data['admission_type']=="R")
	    {
	        $cond =" AND ad.academic_year='".$data['academic_year']."'  AND  st.`cancelled_admission` = 'N'  AND ad.`enrollment_no` != '' AND st.admission_session!='".$data['academic_year']."' AND ad.`cancelled_admission` = 'N'";//AND sm.admission_confirm='Y' 
	    }
	    else 
	    {
	        $cond ="  AND st.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N'"; //AND sm.admission_confirm='Y'
	    }
		
		
	 }
		
		
		if($data['school_code'] !="" && $data['school_code'] !=0){
              $cond.=" and v.school_code='".$data['school_code']."'";
         }
         else
         {
             $cond.="";
         }
		 if($data['admission-course'] !="" ){
              $cond.=" and v.course_id='".$data['admission-course']."'";
         }
         else
         {
             $cond.="";
         }
		 if($data['admission-branch'] !="" && $data['admission-branch'] !=0 ){
              $cond.=" and v.stream_id='".$data['admission-branch']."'";
         }
         else
         {
             $cond.="";
         }
		 
		 
      /* if($data['get_by']=="course"){
           $sel="v.school_short_name,v.stream_short_name ,v.course_short_name ,v.course_id,ad.year as admission_year";
           $grp="v.school_short_name,v.course_short_name order by v.school_short_name,v.course_short_name, v.stream_short_name"; //admission_year
       }
       else{
           $sel="v.school_short_name,v.course_short_name,v.stream_short_name ,v.stream_id,ad.year as admission_year ";
           $grp="v.school_short_name,v.stream_short_name,ad.year order by v.school_short_name,v.course_short_name,v.stream_short_name ,v.stream_id";
       }*/
	    if($data['get_by']=="course"){
           $sel="v.school_short_name,v.stream_short_name ,v.course_short_name ,v.course_id,ad.year as admission_year";
           $grp="v.school_short_name,v.course_short_name order by v.school_short_name,v.course_short_name, v.stream_short_name,ad.year";
       }else{
           $sel="v.school_short_name,v.course_short_name,v.stream_short_name ,v.stream_id,ad.year as admission_year ";
           $grp="v.school_short_name,v.stream_short_name,ad.year order by v.school_short_name,v.course_short_name,v.stream_short_name ,v.stream_id,ad.year";
       }
	   
        $DB1 = $this->load->database('umsdb', TRUE);
     
     $sql="select  v.is_partnership,v.partnership_code,$sel,sum(case when ad.cancelled_admission='N' then  ad.applicable_fee else 0 end) as applicable_total ,sum(case when ad.cancelled_admission='N' then ad.actual_fee else 0 end) as actual_fees,sum(case when ad.cancelled_admission='N' then f.amount else 0 end) as fees_total,sum(case when ad.cancelled_admission='N' then f.charges else 0 end) as cancel_charges,ad.opening_balance,
        count(case when ad.cancelled_admission='N' then  ad.student_id else 0 end) as stud_total,sum(case when rf.amount is null then 0 else rf.amount end) as refund
        from admission_details ad left join vw_stream_details v on v.stream_id=ad.stream_id 
        left join
        (
        select distinct student_id,academic_year,count(student_id)as total_count,sum( case when chq_cancelled='N' then amount else 0 end) as amount, sum( case when chq_cancelled='Y' then canc_charges else 0 end) as charges   from  fees_details where  is_deleted='N'and type_id='2'
        group by  student_id,academic_year
        ) f on ad.student_id=f.student_id and ad.academic_year=f.academic_year 
         left join fees_refunds rf on rf.student_id=ad.student_id AND rf.academic_year=ad.academic_year
         left join student_master st on st.stud_id=ad.student_id AND st.enrollment_no!=''
        where  ad.academic_year='".$data['academic_year']."' and ad.cancelled_admission='N' and st.cancelled_admission='N' $cond
        group by  $grp  ";
        $query=$DB1->query($sql);
	// echo $DB1->last_query(); //and st.academic_year=ad.academic_year
	 //exit;
		$result=$query->result_array();
		return $result;
     
 }

 public function get_cancle_admission_details1($row){
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
 
  //Author:Arvind
 public function get_student_examination_fees($row){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $cond="where f.exam_session='".$row['exam_session']."'";
		$sql="SELECT DISTINCT s.enrollment_no, concat(s.first_name,' ', s.middle_name,' ', s.last_name) as student_name, s.current_year, e.semester, CONCAT(e.exam_month, '-', e.exam_year) AS exam_session1, s.academic_year,s.admission_session, st.school_short_name, st.course_short_name, st.stream_short_name, SUM(e.exam_fees)AS exam_fees,SUM(e.late_fees)AS late_fees, SUM(f.amount) AS exam_fees_total, SUM(f.exam_fee_fine)AS fine,sum(f.canc_charges) as canc_charges
                FROM  (SELECT DISTINCT exam_session,student_id,SUM(amount) as amount,SUM(canc_charges)as canc_charges,SUM(exam_fee_fine)as exam_fee_fine FROM fees_details WHERE exam_session='".$row['exam_session']."' AND chq_cancelled='N' AND is_deleted='N' and type_id = '5' GROUP BY student_id) AS f
                LEFT JOIN student_master AS s ON f.student_id=s.stud_id 
                LEFT JOIN vw_stream_details AS st ON st.stream_id=s.admission_stream 
                LEFT JOIN exam_details AS e ON e.stud_id=s.stud_id and e.exam_id=f.exam_session  ";
        $sql.=$cond;
        $sql.="   group by s.enrollment_no, exam_session1,s.current_year, s.current_semester,  s.academic_year, s.admission_session, st.school_short_name, st.course_short_name, st.stream_short_name order by st.stream_short_name,s.current_year ";
	    $query=$DB1->query($sql);
	   // echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;
 }
 //Author:Arvind
 public function get_examination_fees($row){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $cond="and f.exam_session='".$row['exam_session']."'";
		$sql="SELECT DISTINCT s.enrollment_no, concat(s.first_name,' ', s.middle_name,' ', s.last_name) as student_name, s.current_year, e.semester, CONCAT(e1.exam_month, '-', e1.exam_year) AS exam_session1, s.academic_year, st.school_short_name, st.course_short_name, st.stream_short_name, date_format(f.fees_date,'%d/%m/%Y') as fdate,f.amount, f.fees_paid_type, f.receipt_no,f.canc_charges ,f.exam_fee_fine,f.college_receiptno, b.bank_name, f.bank_city, f.chq_cancelled,f.college_receiptno 
                FROM fees_details AS f LEFT JOIN bank_master AS b ON b.bank_id=f.bank_id 
                LEFT JOIN student_master AS s ON f.student_id=s.stud_id 
                LEFT JOIN vw_stream_details AS st ON st.stream_id=s.admission_stream 
               LEFT JOIN exam_details AS e ON e.stud_id=s.stud_id 
                LEFT JOIN exam_details AS e1 ON CONCAT(e1.exam_month, '-', e1.exam_year)=f.exam_session ";
        $sql.="WHERE f.is_deleted = 'N'   AND f.type_id = '5' ";
         $sql.=$cond;
	    $query=$DB1->query($sql);
  //echo $DB1->last_query();//exit;
// //LEFT JOIN exam_details AS e ON e.stud_id=s.stud_id 
		$result=$query->result_array();
		return $result;
 }
 //Author:Arvind
     public function get_exam_fees_statistics($row){
            $DB1 = $this->load->database('umsdb', TRUE);
            $cond="where f.exam_session='".$row['exam_session']."'";
		$sql="SELECT s.current_year,e.semester,count(s.enrollment_no)as stud_total, CONCAT(e.exam_month, '-', e.exam_year) AS exam_session1, s.academic_year,s.admission_session, st.school_short_name, st.course_short_name, st.stream_short_name, SUM(e.exam_fees)AS exam_fees,SUM(e.late_fees)AS late_fees, SUM(f.amount) AS exam_fees_total, SUM(f.exam_fee_fine)AS fine
                FROM  (SELECT DISTINCT exam_session,student_id,SUM(amount) as amount,SUM(canc_charges)as canc_charges,SUM(exam_fee_fine)as exam_fee_fine FROM fees_details WHERE exam_session='".$row['exam_session']."' AND chq_cancelled='N' AND is_deleted='N' and type_id = '5' GROUP BY student_id) AS f
                LEFT JOIN student_master AS s ON f.student_id=s.stud_id 
                LEFT JOIN vw_stream_details AS st ON st.stream_id=s.admission_stream 
                LEFT JOIN exam_details AS e ON e.stud_id=s.stud_id and e.exam_id=f.exam_session  ";
        $sql.=$cond;
        $sql.="   group by exam_session1,s.current_year, s.academic_year, s.admission_session, st.school_short_name, st.course_short_name, st.stream_short_name order by st.stream_short_name,s.current_year";
	    $query=$DB1->query($sql);
	 //   echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result; 
    }
    
    //Author:Arvind
    public function get_account_report($row){
     $DB1 = $this->load->database('umsdb', TRUE);
           if($row['report_type']=="3"){
                $str=" f.fees_id,f.type_id,f.student_id,s.enrollment_no,s.enrollment_no_new,s.first_name ,s.middle_name,s.last_name ,f.refund_paid_type as fees_paid_type,f.receipt_no,'' as college_receiptno,f.amount,date_format(f.refund_date,'%d/%m/%Y') as fdate,b.bank_name,f.bank_city,f.academic_year,f.refund_for as chq_cancelled,
                v.school_short_name,v.course_short_name,v.stream_short_name,u.username,ad.year";
                $tbl="fees_refunds as f";
            }else{
               $str=" f.fees_id,f.type_id,f.student_id,s.enrollment_no,s.enrollment_no_new,s.first_name ,s.last_name ,f.fees_paid_type,f.receipt_no,f.college_receiptno,f.amount,f.exam_fee_fine,f.canc_charges,date_format(f.fees_date,'%d/%m/%Y') as fdate,b.bank_name,f.bank_city,f.academic_year,f.chq_cancelled,
                f.college_receiptno,v.school_short_name,v.course_short_name,v.stream_short_name,u.username,ad.year";
                $tbl="fees_details as f";
            }
                $DB1->select($str);
                $DB1->from($tbl);
                $DB1->join('bank_master as b','b.bank_id=f.bank_id','left');
                $DB1->join('admission_details as ad','f.student_id=ad.student_id and f.academic_year=ad.academic_year','left');
            	$DB1->join('student_master as s','s.stud_id=ad.student_id ','left');
            	$DB1->join('vw_stream_details as v','v.stream_id=s.admission_stream','left');
                $DB1->join('sandipun_erp.user_master u','u.um_id=f.created_by','left');
        
              if($row['report_by']=='1'){
                  	$DB1->where('date(f.created_on)',$row['report_date']);
              }
               if($row['report_by']=='2'){
                  	$DB1->where("left(date(f.created_on),7) like '".$row['report_month']."%'");
              }
               if($row['report_by']=='3'){
                  	$DB1->where("date(f.created_on) BETWEEN '".$row['from_date']."' AND  '".$row['to_date']."'");
              }
              if($row['report_type']=="1"){
                  	$DB1->where('type_id','2');
              }
               if($row['report_type']=="2"){
                  	$DB1->where('chq_cancelled','Y');
              }
               if($row['report_type']=="3"){
                  	$DB1->where('type_id','2');
              }
               if($row['report_type']=="4"){
                  	$DB1->where('type_id','5');
                  	$DB1->where('exam_session',$row['exam_session']);
              }
              	$DB1->where('f.academic_year',$row['academic_year']);
               	$query=$DB1->get();
            //  echo $DB1->last_query();  exit();
               	$result=$query->result_array();
            	return $result;
   
}

   public function check_payment_no($row){
       
       $DB1 = $this->load->database('umsdb', TRUE);
       if($row['check_by']=="1"){
            $cond="f.college_receiptno='".$row['ref_no']."'";
           $cond1="f.receipt_no='".$row['ref_no']."'";
       }
       else if($row['check_by']=="2"){
            $cond="f.receipt_no='".$row['ref_no']."'";
            $cond1="f.receipt_no='".$row['ref_no']."'";
       }
       else if($row['check_by']=="3"){
            $cond="s.enrollment_no='".$row['ref_no']."'";
            $cond1=" s.enrollment_no='".$row['ref_no']."'";;
       }
        
       $sql="SELECT f.fees_id, f.type_id,t.fees_name, f.student_id, s.enrollment_no, s.enrollment_no_new, s.first_name,  s.middle_name,s.last_name, f.fees_paid_type, f.receipt_no, f.college_receiptno, f.amount, date_format(f.fees_date, '%d/%m/%Y') as fdate, b.bank_name, f.bank_city, f.academic_year, f.chq_cancelled, v.school_short_name, v.course_short_name, v.stream_short_name, u.username, ad.year ,date_format(f.created_on, '%d/%m/%Y') as entry_date FROM fees_details as f LEFT JOIN bank_master as b ON b.bank_id=f.bank_id LEFT JOIN admission_details as ad ON f.student_id=ad.student_id and f.academic_year=ad.academic_year LEFT JOIN student_master as s ON s.stud_id=ad.student_id LEFT JOIN vw_stream_details as v ON v.stream_id=s.admission_stream LEFT JOIN sandipun_erp.user_master u ON u.um_id=f.created_by left join fees_type t on t.type_id=f.type_id
        WHERE   $cond
        union 
        SELECT f.fees_id, f.type_id, t.fees_name,f.student_id, s.enrollment_no, s.enrollment_no_new, s.first_name, s.middle_name, s.last_name, f.refund_paid_type as fees_paid_type, f.receipt_no, '' as college_receiptno, f.amount, date_format(f.refund_date, '%d/%m/%Y') as fdate, b.bank_name, f.bank_city, f.academic_year, f.refund_for as chq_cancelled,v.school_short_name, v.course_short_name, v.stream_short_name, u.username, ad.year,date_format(f.created_on, '%d/%m/%Y') as entry_date FROM fees_refunds as f LEFT JOIN bank_master as b ON b.bank_id=f.bank_id LEFT JOIN admission_details as ad ON f.student_id=ad.student_id and f.academic_year=ad.academic_year LEFT JOIN student_master as s ON s.stud_id=ad.student_id LEFT JOIN vw_stream_details as v ON v.stream_id=s.admission_stream LEFT JOIN sandipun_erp.user_master u ON u.um_id=f.created_by left join fees_type t on t.type_id=f.type_id
        WHERE  $cond1 ";
       
        $query=$DB1->query($sql);
    	  // echo $DB1->last_query();exit;
    		$result=$query->result_array();
    		return $result;
   }
   
   public function get_fees_collection_transport($data)
   {
	   $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("s.stud_id,s.enrollment_no,s.enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,d.organisation,v.school_short_name as intitute,v.stream_short_name as stream,v.course_short_name as course,s.current_year as year,f.amount as paid,s.cancelled_admission, f.fees_paid_type,f.receipt_no as ddno,f.amount ,date_format(f.fees_date,'%d-%m-%Y') as fdate,f.college_receiptno,f.chq_cancelled ,f.remark,b.bank_name,b.bank_short_name ,d.deposit_fees,d.actual_fees,d.excemption_fees,d.cancellation_refund");
		$DB1->from('sandipun_erp.sf_student_facilities as d');
		$DB1->join('sandipun_ums.student_master as s','s.enrollment_no = d.enrollment_no  ','inner');
		$DB1->join('sandipun_ums.vw_stream_details as v','s.admission_stream = v.stream_id','inner');
		$DB1->join('sandipun_erp.sf_fees_details as f','f.enrollment_no = s.enrollment_no and f.academic_year=d.academic_year','inner');
		$DB1->join('sandipun_ums.bank_master as b','f.bank_id=b.bank_id' ,'inner');
		$DB1->where('f.is_deleted', 'N');
		$DB1->where('f.chq_cancelled', 'N');
		$DB1->where('f.type_id ', '2');
	    $DB1->where('f.academic_year',$data['academic_year']);
	     if($data['institute_name']=="All"){
	        $DB1->where('d.organisation','SU');
	    }
	    else
	    {
	        $DB1->where('d.organisation',$data['institute_name']);
	    }
	    
	//	$DB1->order_by("v.stream_name,s.cancelled_admission,s.current_year,s.enrollment_no", "asc");
		$query1 =$DB1->get_compiled_select();
		
		$DB1->select("s.student_id,s.enrollment_no,s.enrollment_no as enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,d.organisation,v.college_name as intitute,v.branch_short_name as stream,v.course_name as course,s.current_year as year,f.amount as paid,'' as cancelled_admission, f.fees_paid_type,f.receipt_no as ddno,f.amount ,date_format(f.fees_date,'%d-%m-%Y') as fdate,f.college_receiptno,f.chq_cancelled ,f.remark,b.bank_name,b.bank_short_name ,d.deposit_fees,d.actual_fees,d.excemption_fees,d.cancellation_refund");
		$DB1->from('sandipun_erp.sf_student_facilities as d');
		$DB1->join('sandipun_erp.sf_student_master as s','s.enrollment_no = d.enrollment_no  ','inner');
		$DB1->join('sandipun_erp.sf_program_detail as v','s.program_id = v.sf_program_id','inner');
		$DB1->join('sandipun_erp.sf_fees_details as f','f.enrollment_no = s.enrollment_no and f.academic_year=d.academic_year','inner');
		$DB1->join('sandipun_ums.bank_master as b','f.bank_id=b.bank_id' ,'inner');
		$DB1->where('f.is_deleted ', 'N');
		$DB1->where('f.type_id ', '2');
	    $DB1->where('f.academic_year',$data['academic_year']);
	    if($data['institute_name']!="All"){
	     $DB1->where('v.college_name',$data['institute_name']);
	    }
		//$DB1->order_by("v.stream_name,s.cancelled_admission,s.current_year,s.enrollment_no", "asc");
		$query2 =$DB1->get_compiled_select();
		 $sqlquery=$DB1->query($query1 . ' UNION ' . $query2);
	  // echo $DB1->last_query();exit;
			$result=$sqlquery->result_array();
			//print_r($result);exit();
		return $result;
 }
   
   public function get_refund_amount_paid_hostel($data){
     	$DB1 = $this->load->database('umsdb', TRUE);
		$con1="";
		$con2="";
		
		if($data['institute_name']=="All"){
			if($data['campus']=="NASHIK"){
				$con1=" and d.organisation in ('SU','SF')"; 
				$con2=" and d.organisation in ('SU','SF')"; 
			}
			else  if($data['campus']=="SIJOUL"){
			   $con1="  and d.organisation='SF-SIJOUL'"; 
			   $con2="  and d.organisation='SF-SIJOUL'"; 
			}
		}
		else
		{
			$con1="and d.organisation='".$data['institute_name']."'";
			$con2=" and s.instute_name='".$data['institute_name']."'";
		}
		
		$sql="SELECT s.stud_id,s.enrollment_no,s.enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,d.organisation,
v.school_short_name as intitute,v.stream_short_name as stream,v.course_short_name as course,s.current_year as year,
f.amount as paid, f.refund_paid_type as fees_paid_type,f.receipt_no as ddno,f.amount ,
date_format(f.refund_date,'%d-%m-%Y') as fdate,f.remark, b.bank_name, b.bank_short_name ,d.deposit_fees,d.actual_fees, 
d.excemption_fees, d.refund as cancellation_refund
 from sandipun_erp.sf_fees_refunds as f
 join sandipun_erp.sf_student_facilities as d on f.enrollment_no = d.enrollment_no and 
 f.academic_year=d.academic_year
 join sandipun_ums.student_master as s on s.enrollment_no = d.enrollment_no
 join sandipun_ums.vw_stream_details as v on s.admission_stream = v.stream_id
 left join sandipun_ums.bank_master as b on f.bank_id=b.bank_id
 where f.is_deleted='N' and f.type_id = '1'  and d.sffm_id=1 and
 f.academic_year='".$data['academic_year']."' $con1 and d.enrollment_no not like '18SUN%' 
 UNION 
 SELECT s.student_id,f.enrollment_no,s.enrollment_no as enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,
d.organisation,s.instute_name as intitute,s.stream,s.course,s.current_year as year,f.amount as paid,
 f.refund_paid_type as fees_paid_type,f.receipt_no as ddno,f.amount ,date_format(f.refund_date,'%d-%m-%Y') as fdate,
f.remark,b.bank_name, b.bank_short_name ,d.deposit_fees,d.actual_fees,d.excemption_fees, d.refund as cancellation_refund
from sandipun_erp.sf_student_facilities as d
join sandipun_erp.sf_student_master as s on s.enrollment_no = d.enrollment_no
join sandipun_erp.sf_fees_refunds as f on f.enrollment_no = s.enrollment_no and f.academic_year=d.academic_year
left join sandipun_ums.bank_master as b on f.bank_id=b.bank_id
where f.is_deleted='N' and f.type_id = '1' and f.academic_year='".$data['academic_year']."' $con2 and d.organisation='SF' and d.sffm_id=1 ";
	$query=$DB1->query($sql);
	// echo $DB1->last_query();exit;
	$result=$query->result_array();
	//print_r($result);exit();
	return $result;

 }
   
    public function get_fees_collection_hostel($data){
     	$DB1 = $this->load->database('umsdb', TRUE);
				
		$con1="";
		$con2="";
		

		if($data['institute_name']=="All"){
			if($data['campus']=="NASHIK"){
				$con1=" and d.organisation in ('SU','SF')"; 
				$con2=" and d.organisation in ('SU','SF')"; 
			}
			else  if($data['campus']=="SIJOUL"){
			   $con1="  and d.organisation='SF-SIJOUL'"; 
			   $con2="  and d.organisation='SF-SIJOUL'"; 
			}
		}
		else
		{
			$con1="and d.organisation='".$data['institute_name']."'";
			$con2=" and s.instute_name='".$data['institute_name']."'";
		}
		
		$sql="SELECT s.student_id,s.enrollment_no,s.enrollment_no as enrollment_no_new,s.first_name,s.middle_name,s.last_name,
s.mobile,d.organisation,s.instute_name as intitute,s.stream,s.course,s.current_year as year,f.amount as paid,'' 
as cancelled_admission, f.fees_paid_type,f.receipt_no as ddno,f.amount ,date_format(f.fees_date,'%d-%m-%Y') as fdate
,f.college_receiptno,f.chq_cancelled ,f.remark,b.bank_name,b.bank_short_name ,d.deposit_fees,d.actual_fees,
d.excemption_fees,d.refund as cancellation_refund
from sandipun_erp.sf_student_facilities as d
join sandipun_erp.sf_student_master as s on s.enrollment_no = d.enrollment_no AND s.student_id = d.student_id
join sandipun_erp.sf_fees_details as f on f.enrollment_no = s.enrollment_no and f.academic_year=d.academic_year
left join sandipun_ums.bank_master as b on f.bank_id=b.bank_id
where f.is_deleted='N' and f.chq_cancelled='N' and f.type_id = '1' and f.academic_year='".$data['academic_year']."' $con2
UNION 
SELECT s.stud_id,s.enrollment_no,s.enrollment_no_new,s.first_name,s.middle_name,s.last_name,
s.mobile,d.organisation,v.school_short_name as intitute,v.stream_short_name as stream,v.course_short_name as
 course,s.current_year as year,f.amount as paid,s.cancelled_admission, f.fees_paid_type,f.receipt_no as ddno,
f.amount ,date_format(f.fees_date,'%d-%m-%Y') as fdate,f.college_receiptno,f.chq_cancelled ,f.remark,b.bank_name,
b.bank_short_name ,d.deposit_fees,d.actual_fees,d.excemption_fees,d.refund as cancellation_refund
from sandipun_erp.sf_fees_details as f
join sandipun_erp.sf_student_facilities as d on f.enrollment_no = d.enrollment_no and f.academic_year=d.academic_year
join sandipun_ums.student_master as s on s.enrollment_no = d.enrollment_no AND s.stud_id = d.student_id
join sandipun_ums.vw_stream_details as v on s.admission_stream = v.stream_id
left join sandipun_ums.bank_master as b on f.bank_id=b.bank_id
where f.is_deleted='N' and f.chq_cancelled='N' and f.type_id = '1' and f.academic_year='".$data['academic_year']."' and d.enrollment_no not like '18SUN%' $con1";
//where f.is_deleted='N' and f.chq_cancelled='N' and f.type_id = '1' and f.academic_year='".$data['academic_year']."' and d.enrollment_no not like '18SUN%' $con1";
	$query=$DB1->query($sql);
	/*if($_SESSION['uid']=='2'){
		 echo $DB1->last_query();exit;
	}*/
	// echo $DB1->last_query();exit;
	$result=$query->result_array();
	//print_r($result);exit();
	return $result;
 }
 
  public function get_studentwise_hostel_fees($data){
    	$DB1 = $this->load->database('default', TRUE);
    	$cond="p.academic_year='".$data['academic_year']."'";
    	
		if($data['campus']=="NASHIK"){
			$cond.="  and organisation in ('SU','SF')"; 
		}
		else  if($data['campus']=="SIJOUL"){
		   $cond.="  and organisation='SF-SIJOUL'"; 
		}

		if($data['institute_name']=="All"){
			
		}
		else
		{
			if($data['institute_name']=="SU"){
			  $cond.="  and organisation='SU'"; 
			}
			else 
			{
				 $cond.="  and intitute='".$data['institute_name']."'"; 
			}
		}	  
		  
      
		
  
       if($data['report_type']=='4'){
           $cond.='and (p.appl-COALESCE(p.fees_paid,0))>0';
       }
  
    	/* $sql="SELECT p.*,fa.allocated_id,ra.hostel_code,ra.room_no FROM (
        SELECT DISTINCT f.sf_id,f.enrollment_no,f.enrollment_no as enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,s.gender,f.year,f.organisation,s.instute_name as intitute,s.stream as branch_short_name,s.stream as course_name,s.stream,f.academic_year,f.deposit_fees,f.actual_fees,f.refund as cancellation_refund,f.gym_fees,f.fine_fees,f.opening_balance, a.fees_paid,a.fine,f.excemption_fees,f.cancelled_facility,(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees+f.opening_balance-f.excemption_fees) as appl FROM sandipun_erp.sf_student_facilities f LEFT JOIN (SELECT enrollment_no,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='1' GROUP BY enrollment_no,academic_year) a ON a.enrollment_no=f.enrollment_no AND f.academic_year=a.academic_year INNER JOIN sandipun_erp.sf_student_master s ON s.enrollment_no=f.enrollment_no where f.sffm_id=1 UNION 
         SELECT DISTINCT f.sf_id,f.enrollment_no,s.enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,s.gender,f.year,f.organisation,p.school_short_name AS intitute, p.stream_short_name AS branch_short_name,p.course_short_name AS course_name,concat(p.course_short_name,' ',p.stream_short_name) as stream,f.academic_year,f.deposit_fees,f.actual_fees,f.refund as cancellation_refund,f.gym_fees,f.fine_fees,f.opening_balance,a.fees_paid,a.fine,f.excemption_fees,f.cancelled_facility,(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees+f.opening_balance-f.excemption_fees) as appl FROM sandipun_erp.sf_student_facilities f LEFT JOIN (SELECT enrollment_no,academic_year,SUM( amount )AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='1' GROUP BY enrollment_no,academic_year) a ON a.enrollment_no=f.enrollment_no AND f.academic_year=a.academic_year INNER JOIN sandipun_ums.student_master s ON s.enrollment_no=f.enrollment_no INNER JOIN sandipun_ums.vw_stream_details p ON s.admission_stream=p.stream_id where f.sffm_id=1) p LEFT JOIN sf_student_facility_allocation fa ON fa.sf_id=p.sf_id AND fa.is_active='Y' LEFT JOIN sf_hostel_room_details ra ON ra.sf_room_id=fa.allocated_id 
           WHERE  $cond"; */
		   
		   $sql="SELECT p.*,COALESCE(p.fees_paid,0),COALESCE(p.fine,0),fa.allocated_id,ra.hostel_code,ra.room_no 
       FROM ( SELECT DISTINCT f.sf_id,f.student_id,f.enrollment_no,f.enrollment_no as enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,s.gender,f.year,f.organisation,s.instute_name as intitute,s.stream as branch_short_name,s.stream as course_name,s.stream,f.academic_year,f.deposit_fees,f.actual_fees,f.refund as cancellation_refund,f.gym_fees,f.fine_fees,f.opening_balance, a.fees_paid,a.fine,f.excemption_fees,f.cancelled_facility,(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees+f.opening_balance-f.excemption_fees) as appl FROM sandipun_erp.sf_student_facilities f
        LEFT JOIN (SELECT enrollment_no,student_id,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='1' and academic_year='".$data['academic_year']."' GROUP BY enrollment_no,academic_year) a ON a.enrollment_no=f.enrollment_no AND a.student_id=f.student_id AND f.academic_year=a.academic_year
        INNER JOIN sandipun_erp.sf_student_master s ON s.enrollment_no=f.enrollment_no AND s.student_id=f.student_id where f.sffm_id=1 and f.status='Y' and f.cancelled_facility='N' and f.academic_year='".$data['academic_year']."' 
        UNION 
       SELECT DISTINCT f.sf_id,f.`student_id`,f.enrollment_no,s.enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,s.gender,f.year,f.organisation,p.school_short_name AS intitute, p.stream_short_name AS branch_short_name,p.course_short_name AS course_name,concat(p.course_short_name,' ',p.stream_short_name) as stream,f.academic_year,f.deposit_fees,f.actual_fees,f.refund as cancellation_refund,f.gym_fees,f.fine_fees,f.opening_balance,a.fees_paid,a.fine,f.excemption_fees,f.cancelled_facility,(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees+f.opening_balance-f.excemption_fees) as appl FROM sandipun_erp.sf_student_facilities f LEFT JOIN (SELECT enrollment_no,student_id,academic_year,SUM( amount )AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='1' and academic_year='".$data['academic_year']."'  and enrollment_no not like '18SUN%' GROUP BY enrollment_no,academic_year) a ON a.enrollment_no=f.enrollment_no AND a.student_id=f.student_id AND f.academic_year=a.academic_year INNER JOIN sandipun_ums.student_master s ON s.enrollment_no=f.enrollment_no and s.stud_id=f.student_id INNER JOIN sandipun_ums.vw_stream_details p ON s.admission_stream=p.stream_id where f.sffm_id=1 and f.status='Y' and f.cancelled_facility='N' and f.academic_year='".$data['academic_year']."' and f.enrollment_no not like '18SUN%') p 
       LEFT JOIN sf_student_facility_allocation fa ON fa.sf_id=p.sf_id AND fa.is_active='Y'
        LEFT JOIN sf_hostel_room_details ra ON ra.sf_room_id=fa.allocated_id WHERE $cond";
	       $query=$DB1->query($sql);

         if($this->session->userdata("role_id")==6){
    	// echo $DB1->last_query();exit();
		  }
    		$result=$query->result_array();
    		return $result;
 
 }
 
  public function get_institute_fees_statistics($data){
    	$DB1 = $this->load->database('umsdb', TRUE);
    	 $cond=" academic_year='".$data['academic_year']."' ";
    	  if($data['campus']=="NASHIK"){
    	        $cond.="  and organisation in ('SU','SF')"; 
    	  }
    	  else  if($data['campus']=="SIJOUL"){
    	       $cond.="  and organisation='SF-SIJOUL'"; 
    	  }
    	  else
    	  {
    	      
    	  }
    	  if($data['institute_name']=="All"){
    	      
    	  }
         else if($data['institute_name']=="SU"){
    	  $cond.="  and organisation='SU'"; 
    	}
    	else{
    	     $cond.="  and college_name='".$data['institute_name']."'"; 
    	}
    	
	
	$sql="SELECT b.organisation,b.college_name,b.academic_year,COUNT(b.enrollment_no) as stud_total,SUM(b.fees_paid)as fees_paid,SUM(b.fine)as fine,
SUM(b.deposit_fees) as deposit_fees,SUM(b.actual_fees) as actual_fees,SUM(b.cancellation_refund) as cancellation_refund,SUM(b.gym_fees) as gym_fees,SUM(b.fine_fees)as fine_fees,SUM(b.opening_balance)as opening_balance,SUM(b.excemption_fees) as excemption_fees
 FROM (
SELECT DISTINCT a.fees_paid,a.fine,f.enrollment_no,f.organisation,p.college_name,p.branch_short_name,p.course_name,f.academic_year,f.deposit_fees,f.actual_fees,f.refund as cancellation_refund,f.gym_fees,f.fine_fees,f.opening_balance,f.excemption_fees,
f.cancelled_facility,f.`sffm_id`
 FROM sandipun_erp.sf_student_facilities f 
 LEFT JOIN 
 (SELECT enrollment_no,student_id,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' and type_id='1' AND academic_year=".$data['academic_year']." GROUP BY enrollment_no,academic_year) a
 ON a.enrollment_no=f.enrollment_no AND a.student_id=f.student_id AND f.academic_year=a.academic_year 
 INNER JOIN sandipun_erp.sf_student_master s ON s.enrollment_no=f.enrollment_no AND s.student_id=f.student_id
 left JOIN sandipun_erp.sf_program_detail p ON s.program_id=p.sf_program_id where f.cancelled_facility='N' AND f.sffm_id='1' AND f.academic_year=".$data['academic_year']."
 UNION 
 SELECT DISTINCT a.fees_paid,a.fine,f.enrollment_no,f.organisation,p.school_short_name AS college_name,
 p.stream_short_name AS branch_short_name,p.course_short_name AS course_name,f.academic_year,f.deposit_fees,f.actual_fees,f.refund as cancellation_refund,f.gym_fees,f.fine_fees,f.opening_balance,f.excemption_fees,f.cancelled_facility,f.`sffm_id`
 FROM sandipun_erp.sf_student_facilities f 
 LEFT JOIN 
 (SELECT enrollment_no,student_id,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' and type_id='1' AND  academic_year=".$data['academic_year']." GROUP BY enrollment_no,academic_year) a
 ON a.enrollment_no=f.enrollment_no AND a.student_id=f.student_id AND f.academic_year=a.academic_year 
 INNER JOIN sandipun_ums.student_master s ON s.enrollment_no=f.enrollment_no AND s.stud_id=f.student_id
 INNER JOIN sandipun_ums.vw_stream_details p ON s.admission_stream=p.stream_id where  f.cancelled_facility='N' AND f.sffm_id='1' AND f.academic_year=".$data['academic_year']."
 )b where $cond GROUP BY b.organisation,b.college_name,b.academic_year
 ";
	
   $query=$DB1->query($sql);
   if($this->session->userdata("role_id")==6){
    	//   echo $DB1->last_query(); //exit();
   }
    		$result=$query->result_array();
    		return $result;
 }
 
 
   public function get_hostel_statistics($data){
       
    	$DB1 = $this->load->database('umsdb', TRUE);
    	 $cond=" b.academic_year='".$data['academic_year']."'";
    	if($data['campus']=="ALL"){
    	    
    	  }
    	  else{
    	      $cond.= "  and b.campus_name='".$data['campus']."'";
    	  }
		$sql="SELECT b.hostel_name,b.hostel_type,b.campus_name,b.area,b.in_campus,b.hostel_code,b.academic_year,b.capacity,b.capacity,b.actual_capacity,COUNT(b.enrollment_no) AS stud_total,SUM(b.fees_paid)AS fees_paid,SUM(b.fine)AS fine, SUM(b.deposit_fees) AS deposit_fees,SUM(b.actual_fees) AS actual_fees,SUM(b.gym_fees) AS gym_fees,SUM(b.fine_fees)AS fine_fees,SUM(b.opening_balance)AS opening_balance,SUM(b.excemption_fees) AS excemption_fees FROM 
            ( SELECT DISTINCT a.fees_paid,a.fine,f.enrollment_no,h.hostel_name,h.hostel_type,h.area,h.campus_name,h.actual_capacity,h.no_of_beds AS capacity,h.in_campus,r.bed_number,r.hostel_code,r.room_no,f.academic_year,f.deposit_fees,f.actual_fees,f.gym_fees,f.fine_fees,f.opening_balance,f.excemption_fees,f.cancelled_facility FROM sandipun_erp.sf_student_facilities f 
            LEFT JOIN (SELECT enrollment_no,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' GROUP BY enrollment_no,academic_year) a 
            ON a.enrollment_no=f.enrollment_no AND f.academic_year=a.academic_year 
            INNER JOIN sandipun_erp.sf_student_facility_allocation s ON s.enrollment_no=f.enrollment_no AND s.academic_year=f.academic_year AND s.is_active='Y'
            INNER JOIN sandipun_erp.sf_hostel_room_details r ON r.sf_room_id=s.allocated_id 
            INNER JOIN sandipun_erp.sf_hostel_master h ON h.host_id=r.host_id where f.sffm_id=1)b where $cond
            GROUP BY b.hostel_name,b.hostel_type,b.campus_name,b.in_campus,b.hostel_code,b.academic_year
             ";
         $query=$DB1->query($sql);
         if($this->session->userdata("role_id")==6){
    	 $DB1->last_query(); //exit();
         }
		$uId=$this->session->userdata('uid');
		/*if($uId=='2')
		{
				echo $DB1->last_query();
				die;
		}*/
    		$result=$query->result_array();
    		return $result;
 }
 
    public function get_Transport_statistics($data){
       
    	$DB1 = $this->load->database('umsdb', TRUE);
    	 $cond=" b.academic_year='".$data['academic_year']."'";
    	if($data['campus']=="ALL"){
    	    
    	  }
    	  else{
    	      $cond.= "  and b.campus_name='".$data['campus']."'";
    	  }
		$sql="SELECT b.boarding_point,b.campus,COUNT(b.fees_paid) AS stud_total,SUM(b.fees_paid)AS fees_paid,SUM(b.fine)AS fine, SUM(b.actual_fees) AS actual_fees,SUM(b.fine_fees)AS fine_fees,SUM(b.opening_balance)AS opening_balance,SUM(b.excemption_fees) AS excemption_fees FROM 
            ( SELECT DISTINCT r.boarding_point,tr.campus,a.fees_paid,a.fine,f.enrollment_no,f.academic_year,f.deposit_fees,f.actual_fees,f.gym_fees,f.fine_fees,f.opening_balance,f.excemption_fees,f.cancelled_facility FROM sandipun_erp.sf_student_facilities f 
            LEFT JOIN (SELECT enrollment_no,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' and academic_year='".$data['academic_year']."' GROUP BY enrollment_no,academic_year) a 
            ON a.enrollment_no=f.enrollment_no AND f.academic_year=a.academic_year 
            INNER JOIN sandipun_erp.sf_student_facility_allocation s ON s.enrollment_no=f.enrollment_no AND s.academic_year=f.academic_year AND s.is_active='Y'
            INNER JOIN sandipun_erp.sf_transport_boarding_details r ON r.board_id=s.allocated_id 
            INNER JOIN sandipun_erp.sf_transport_route_details h ON h.board_id=r.board_id
			INNER JOIN sandipun_erp.sf_transport_route tr ON tr.route_id=h.route_id where f.sffm_id=2)b where $cond
            GROUP BY b.boarding_point,b.campus
             ";
         $query=$DB1->query($sql);
    	//echo $DB1->last_query();exit();
    		$result=$query->result_array();
    		return $result;
 }
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function get_studentwise_transport_fees($data){
    	$DB1 = $this->load->database('default', TRUE);
    	$cond="p.academic_year='".$data['academic_year']."'";
    	
    	 if($data['campus']=="NASHIK"){
    	        $cond.="  and organisation in ('SU','SF')"; 
    	  }
    	  else  if($data['campus']=="SIJOUL"){
    	       $cond.="  and organisation='SF-SIJOUL'"; 
    	  }
    	  
    	  if($data['institute_name']=="All"){
    	      
    	  }
         else if($data['institute_name']=="SU"){
    	  $cond.="  and organisation='SU'"; 
    	}
    	else{
    	     $cond.="  and intitute='".$data['institute_name']."'"; 
    	}
  
       if($data['report_type']=='4'){
           $cond.='and (p.appl-p.fees_paid)>0';
       }
  
    	$sql="SELECT p.*,fa.allocated_id,ra.boarding_point,ra.campus FROM (
        SELECT DISTINCT f.sf_id,f.enrollment_no,f.enrollment_no as enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,s.gender,f.year,f.organisation,s.instute_name AS intitute,s.stream  AS branch_short_name,s.course AS course_name,stream,f.academic_year, f.deposit_fees,f.actual_fees,f.cancellation_refund,f.gym_fees,f.fine_fees,f.opening_balance, a.fees_paid,a.fine,f.excemption_fees,f.cancelled_facility,(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees+f.opening_balance-f.excemption_fees) as appl FROM sandipun_erp.sf_student_facilities f LEFT JOIN (SELECT enrollment_no,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='2' GROUP BY enrollment_no,academic_year) a ON a.enrollment_no=f.enrollment_no AND f.academic_year=a.academic_year INNER JOIN sandipun_erp.sf_student_master s ON s.enrollment_no=f.enrollment_no UNION 
         SELECT DISTINCT f.sf_id,f.enrollment_no,s.enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,s.gender,f.year,f.organisation,p.school_short_name AS intitute, p.stream_short_name AS branch_short_name,p.course_short_name AS course_name,concat(p.course_short_name,' ',p.stream_short_name) as stream,f.academic_year,f.deposit_fees,f.actual_fees,f.cancellation_refund,f.gym_fees,f.fine_fees,f.opening_balance,a.fees_paid,a.fine,f.excemption_fees,f.cancelled_facility,(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees+f.opening_balance-f.excemption_fees) as appl FROM sandipun_erp.sf_student_facilities f LEFT JOIN (SELECT enrollment_no,academic_year,SUM( amount )AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='2' GROUP BY enrollment_no,academic_year) a ON a.enrollment_no=f.enrollment_no AND f.academic_year=a.academic_year INNER JOIN sandipun_ums.student_master s ON s.enrollment_no=f.enrollment_no INNER JOIN sandipun_ums.vw_stream_details p ON s.admission_stream=p.stream_id ) p LEFT JOIN sf_student_facility_allocation fa ON fa.sf_id=p.sf_id AND fa.is_active='Y' LEFT JOIN sf_transport_boarding_details ra ON ra.board_id=fa.allocated_id 
           WHERE  $cond";
	       $query=$DB1->query($sql);
    	//  echo $DB1->last_query();exit();
    		$result=$query->result_array();
    		return $result;
 
 }
 
  public function get_institute_transportfees_statistics($data){
    	$DB1 = $this->load->database('umsdb', TRUE);
    	 $cond=" academic_year='".$data['academic_year']."' ";
    	  if($data['campus']=="NASHIK"){
    	        $cond.="  and organisation in ('SU','SF')"; 
    	  }
    	  else  if($data['campus']=="SIJOUL"){
    	       $cond.="  and organisation='SF-SIJOUL'"; 
    	  }
    	  else
    	  {
    	      
    	  }
    	  if($data['institute_name']=="All"){
    	      
    	  }
         else if($data['institute_name']=="SU"){
    	  $cond.="  and organisation='SU'"; 
    	}
    	else{
    	     $cond.="  and college_name='".$data['institute_name']."'"; 
    	}
    	
	
	$sql="SELECT b.organisation,b.college_name,b.academic_year,COUNT(b.fees_paid) as stud_total,SUM(b.fees_paid)as fees_paid,SUM(b.fine)as fine,
SUM(b.deposit_fees) as deposit_fees,SUM(b.actual_fees) as actual_fees,SUM(b.cancellation_refund) as cancellation_refund,SUM(b.gym_fees) as gym_fees,SUM(b.fine_fees)as fine_fees,SUM(b.opening_balance)as opening_balance,SUM(b.excemption_fees) as excemption_fees
 FROM (
SELECT DISTINCT a.fees_paid,a.fine,f.enrollment_no,f.organisation,s.instute_name as college_name,stream as branch_short_name,s.course as course_name,f.academic_year,f.deposit_fees,f.actual_fees,f.cancellation_refund,f.gym_fees,f.fine_fees,f.opening_balance,f.excemption_fees,f.cancelled_facility
 FROM sandipun_erp.sf_student_facilities f 
 LEFT JOIN 
 (SELECT enrollment_no,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' and type_id='2' GROUP BY enrollment_no,academic_year) a
 ON a.enrollment_no=f.enrollment_no AND f.academic_year=a.academic_year 
 INNER JOIN sandipun_erp.sf_student_master s ON s.enrollment_no=f.enrollment_no
 where f.cancelled_facility='N'
 UNION 
 SELECT DISTINCT a.fees_paid,a.fine,f.enrollment_no,f.organisation,p.school_short_name AS college_name,
 p.stream_short_name AS branch_short_name,p.course_short_name AS course_name,f.academic_year,f.deposit_fees,f.actual_fees,f.cancellation_refund,f.gym_fees,f.fine_fees,f.opening_balance,f.excemption_fees,f.cancelled_facility
 FROM sandipun_erp.sf_student_facilities f 
 LEFT JOIN 
 (SELECT enrollment_no,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' and type_id='2' GROUP BY enrollment_no,academic_year) a
 ON a.enrollment_no=f.enrollment_no AND f.academic_year=a.academic_year 
 INNER JOIN sandipun_ums.student_master s ON s.enrollment_no=f.enrollment_no
 INNER JOIN sandipun_ums.vw_stream_details p ON s.admission_stream=p.stream_id where  f.cancelled_facility='N'
 )b where $cond GROUP BY b.organisation,b.college_name,b.academic_year
 ";
	
   $query=$DB1->query($sql);
    	  // echo $DB1->last_query();exit();
    		$result=$query->result_array();
    		return $result;
 }
 
 	function updatePayment($sf_id, $data)
	{
		//print_r($data);
		//$DB1 = $this->load->database('umsdb', TRUE);
		$where=array("sf_id"=>$sf_id);
		$this->db->where($where); 
		$this->db->update('sf_student_facilities', $data);
		//echo $this->db->last_query();exit;
		return true;
	}
	function fetch_competative_fees($var)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT * FROM competative_fees where 1 ";
		if(!empty($var['year'])){
			$sql .="AND year='".$var['year']."'";
		}
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$res = $query->result_array();
		return $res;
	}
	function fetch_stud_curr_exam(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('exam_session');
		//$DB1->where("is_active", 'Y');
		$DB1->order_by("exam_id", 'desc');
		//$DB1->limit(1);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
function fetch_stud_curr_year(){
	$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('exam_session');
		//$DB1->where("is_active", 'Y');
		$DB1->order_by("exam_id", 'desc');
		//$DB1->limit(1);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
  
}