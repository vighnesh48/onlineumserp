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

		 if($data['admission-course'] !="" && $data['admission-course'] !=0 ){
			  $DB1->where('v.course_id',$data['admission-course']); 
         }
        
		 if($data['admission-branch'] !="" && $data['admission-branch'] !=0 ){
			   $DB1->where('v.stream_id',$data['admission-branch']); 
         }
        
	  
		$DB1->order_by("v.stream_name,s.cancelled_admission,s.current_year,s.enrollment_no", "asc");
		$query=$DB1->get();
	  //echo $DB1->last_query();exit;
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
 public function get_studentwise_admission_fees_22062023($data){
	
	 $role_id = $this->session->userdata('role_id');
	 $emp_id = $this->session->userdata("name");
     $DB1 = $this->load->database('umsdb', TRUE);
	 $data['academic_year'];
	 $yearr = substr($data['academic_year'], -2);
	 $newy=$yearr+1;
	 $current_aced=$data['academic_year'].'-'.$newy;
	if($data['erp_type']=="phd"){
		$erp_type=" AND (sm.`admission_cycle` != ''  or sm.`admission_cycle` is not null)";
	}elseif($data['erp_type']=="R"){
		$erp_type="AND (sm.`admission_cycle` = '' or sm.`admission_cycle` is null)";
	}else{
		$erp_type='';
	}
	 if($data['academic_year']<=2019){
		 
		  if($data['admission_type']=="N"){//new
		 // echo '1_N';
         $cond ="  sm.admission_session='".$data['academic_year']."'  AND ad.`cancelled_admission` = 'N'" ;//sm.admission_confirm='Y'
	    }else if($data['admission_type']=="R"){//Register
		// echo '1_R';
	        $cond ="  ad.academic_year='".$data['academic_year']."'  AND sm.admission_session!='".$data['academic_year']."' AND ad.`cancelled_admission` = 'N'";//AND sm.admission_confirm='Y' AND ad.`enrollment_no` != ''
	    
		}else{//BOTH
	      // echo '1';
		    $cond ="   ad.`cancelled_admission` = 'N' AND ad.academic_year='".$data['academic_year']."'"; //AND sm.admission_confirm='Y'
	    }
		
	 }else{
		 
		 
		 
       if($data['admission_type']=="N"){
		 //    echo '2_N';
         $cond =" sm.admission_confirm='Y' and sm.admission_session='".$data['academic_year']."' AND ad.`cancelled_admission` = 'N' $erp_type" ;//
	    }else if($data['admission_type']=="R")
	    {
		//	echo '2_R';
	        $cond ="  ad.academic_year='".$data['academic_year']."'  AND sm.`enrollment_no` != '' AND sm.admission_session!='".$data['academic_year']."' AND ad.`cancelled_admission` = 'N' AND sm.admission_confirm='Y' AND sm.admission_confirm='Y' $erp_type";//
	    }
	    else {
		//	echo '2';
	     $cond =" ad.academic_year='".$data['academic_year']."'   AND sm.`enrollment_no` != '' AND ad.`cancelled_admission` = 'N' AND sm.admission_confirm='Y' $erp_type";
		  //  $cond ="  AND sm.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N' AND  sm.admission_confirm='Y' AND sm.`enrollment_no` != ''"; //AND sm.admission_confirm='Y'
	    //AND sm.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N' AND sm.admission_confirm='Y'
		}
		
		
	 }
		//exit();
         if($data['get_by']=="stream"){
              $cond.=" AND sm.admission_stream='".$data['stream_id']."' and ad.year ='".$data['year']."'";
         }
         else
         {
             $cond.="";
         }
		 if( $role_id==49){
			  $cond.=" AND v.stream_id in(223,222,160,161)";
		 }else{
		 if($data['school_code'] !="" && $data['school_code'] !=0){
              $cond.=" AND v.school_code='".$data['school_code']."'";
         }		 
         else
         {
             $cond.="";
         }
		 }
		 if(($data['admission-course'] !="") && ($data['admission-course'] !=0) ){
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
		 
		 //$cond .=" AND sm.stud_id in (8008,8010,8036,8061,8071,8080,8099,8110,8144,8145,8146,8148,8161,8162,8163,8164,8166,8168,8171,8174,8175,8177,8178,8182,8185,8188,8189,8191,8193,8194,8197,8198,8199,8202,8204,8211,8214,8222,8223,8227,8233,8234,8241,8242,8244,8245,8249,8251,8253,8254,8256,8259,8261,8265,8267,8269,8270,8271,8272,8273,8275,8276,8277,8279,8281,8282,8283,8284,8286,8287,8307,8322,8351,8398,8401,8420,8423,8448,8476,8494,8534,8551,8566,8572,8583,8586,8632,8633,8636,8642,8645,8682,8760,8767,8774,8777,8785,8788,8825,8827,8847,8863,8901,8915,8920,8971,9014,9018,9043,9047,9049,9052,9053,9056,9060,9061,9062,9065,9066,9067,9069,9070,9080,9091,9125,9139,9142,9162,9171,9172,9177,9208,9230,9246,9280,9329,9349,9350,9385,9390,9394,9434,9456,9457,9469,9484,9502,9577,9580,9598,9601,9604,9652,9658,9673,9694,9714,9724,9727,9728,9731,9739,9752,9761,9787,9789,9798,9843,9852,9855,9862,9863,9864,9865,9866,9868,9878,9896,9973,9986,10001,10002,10004,10026,10028,10049,10062,10156,10159,10175,10224,10250,10268,10272,10274,10275,10277,10282,10293,10304,10312,10314,10364,10365,10417,10435,10438,10443,10485,10487,10496,10501,10512,10517,10519,10527,10534,10556,10557,10561,10570,10571,10595,10597,10600,10606,10611,10615,10620,10657,10682,10683,10686,10707,10719,10720,10769,10774,10778,10799,10800,10801,10804,10807,10809,10813,10814,10822,10838,10868,10872,10875,10881,10885,10886,10887,10888,10890,10891,10894,10896,10898,10900,10905,10906,10910,10913,10916,10933,10940,10945,10948,10961,10963,10964,10965,10967,10970,10971,10972,11012,11027,11035,11054,11063,11078,11079,11081,11083,11086,11089,11102,11124,11141,11148,11149,11151,11158,11159,11176,11187,11202,11206,11207,11209,11215,11218,11219,11223,11225,11227,11230,11235,11236,11239,11253,11255,11262,11279,11285,11287,11293,11294,11299,11303,11312,11314,11316,11327,11333,11338,11342,11345,11361,11371,11373,11387,11394,11405,11409,11414,11416,11425,11431,11435,11473,11474,11480,11531,11592,11634,11651,11656,11667,11682,11683,11686,11693,11702,11711,11718,11719,11725,11731,11733,11746,11768,11775,11789,11801,11805,11808,11854,11874,11879,11882,11884,11890,11923,11927,11937,11940,11942,11946,11948,11956,11957,11958,11963,11974,11979,11988,11993,12001,12019,12022,12035,12054,12058,12065,12091,12098,12103,12117,12120,12125,12159,12163,12168,12170,12188,12222,12273,12274,12286,12297,12320,12330,12347,12378,12398,12416,12425,12506,12509,12520,12530,12551,12552,12563,12585,12600,12614,12624,12626,12648,12650,12651,12654,12666,12669,12672,12679,12697,12702,12723,12725,12726,12734,12743,12752,12755,12756,12757,12762,12766,12775,12778,12792,12794,12795,12817,12818,12819,12820,12821,12830,12833,12837,12850,12854,12857,12864,12874,12875,12877,12883,12897,12974,12981,12982,12983,12984,12985,12986,12987,12988,12989,12990,12991,12993,12994,12996,12997,12998,12999,13000,13001,13002,13003,13004,13005,13006,13007,13008,13009,13010,13011,13012,13013,13014,13015,13016,13017,13018,13019,13020,13021,13022,13023,13024,13025,13026,13027,13028,13029,13030,13031,13032,13033,13034,13035,13036,13037,13038,13039,13040,13041,13042,13043)";
		 
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
		
		
     $sql="select abs.benefit_name,sm.belongs_to,ad.year,v.is_partnership,v.partnership_code,v.course_pattern,sm.stud_id, CASE WHEN course_pattern='SEMESTER' 
	 THEN v.course_duration *2 else v.course_duration end as final_semester,sm.current_semester,sm.academic_year as acdyer,
	 sm.enrollment_no,sm.enrollment_no_new,sm.first_name,sm.middle_name,sm.last_name,sm.religion,sm.category,sm.sub_caste,sm.mobile,
	 sm.nationality,cc.name as country_name,sm.belongs_to,
	 pd.parent_mobile2,sm.reported_status, COALESCE (sm.reported_date,'--') as reported_date,
	 sm.gender,sm.admission_cycle,v.school_short_name,v.school_name,v.course_name,v.stream_name,v.course_short_name as course,
	 v.stream_short_name,v.stream_id,ad.year as admission_year,sum(ad.applicable_fee) as applicable_total ,sum(ad.actual_fee) as actual_fees,
	 sum(case when f.amount is null then 0 else f.amount end ) as fees_total,sum(f.charges) as cancel_charges, count(ad.student_id) as stud_total ,
	 ad.cancelled_admission,sum(case when rf.amount is null then 0 else rf.amount end )as refund ,
	 ad.academic_year,ad.opening_balance,dt.district_name,tm.taluka_name,st.state_name,ac.tution_fees,
	 ac.`academic_fees`,ac.`tution_fees` AS atution_fees,ac.`development`,ac.`caution_money`,ac.`admission_form`,ac.`exam_fees`,
(ac.`Gymkhana`+ ac.`disaster_management`+ ac.`computerization`+ ac.`registration`+ ac.`student_safety_insurance`+ ac.`library`+
ac.`nss`+ ac.`eligibility`+ ac.`internet`+ac.`educational_industrial_visit`+ ac.`seminar_training`+ ac.`student_activity`+
ac.`lab`+ ac.`accommodation`) AS Other_fees,ac.`total_fees` AS Final_Total
	 from admission_details ad 
	 left join student_master sm on sm.stud_id=ad.student_id AND sm.enrollment_no!=''
	 
	
	 left join academic_fees ac on ac.stream_id=ad.stream_id AND ac.academic_year='".$current_aced."' 
	 AND ac.admission_year=sm.admission_session AND CASE WHEN (ad.year<2 AND sm.admission_year=1) THEN ac.year=ad.year 
	 WHEN (ad.year=2 AND sm.admission_year=2 ) THEN ac.year=ad.year 
	 ELSE ac.year=0 END
	 
	 left join vw_stream_details v on v.stream_id=ad.stream_id
	 left join address_details ads on ads.student_id=ad.student_id AND ads.adds_of='STUDENT' AND ads.address_type='PERMNT'
     left join states as st on st.state_id=ads.state_id 
     left join district_name as dt on dt.district_id=ads.district_id
     left join taluka_master as tm on tm.taluka_id=ads.city 
	 left join countries as cc on cc.id=ads.country_id 
     left join ( select distinct student_id,academic_year,count(student_id)as total_count,sum( case when chq_cancelled='N' then amount else 0 end) as amount,sum( case when chq_cancelled='Y' then canc_charges else 0 end) as charges from fees_details where is_deleted='N' and type_id='2' group by student_id,academic_year) f on CAST(ad.student_id  AS CHAR)=f.student_id and ad.academic_year=f.academic_year 
	 
	 left join parent_details pd on sm.stud_id=pd.student_id    
	 left join sandipun_ic_erp22.admission_benefits_and_source abs on abs.student_id=sm.stud_id and remark is not null 
     left join ( SELECT DISTINCT student_id,academic_year,SUM( CASE WHEN is_deleted='N' THEN amount ELSE 0 END) AS amount FROM fees_refunds WHERE is_deleted='N'
	  GROUP BY student_id,academic_year) rf ON ad.student_id=rf.student_id AND ad.academic_year=rf.academic_year
     where   ". $cond.$condition1."  
	 group by sm.stud_id,course,v.stream_id,admission_year ".$hav." 
	 order by v.school_short_name,v.course_short_name,ad.cancelled_admission,admission_year,sm.enrollment_no asc";//AND sm.`admission_cycle`!=''
	 
        $query=$DB1->query($sql);
		
		#left join (select distinct e.stud_id,enrollment_no from exam_details e where e.exam_id in(18,19,20,21)) as ed on ed.stud_id=ad.student_id 
		//ad.student_id IN ('4199','1746','7566','1673','7542','5436','7356','7682','7469','7462','6198')  AND#,CASE WHEN e.enrollment_no is not null THEN 'Filled' ELSE 'Not Filled'END AS Exam_form_status
		//# LEFT JOIN exam_details e ON sm.stud_id = e.stud_id and e.exam_id=13
		//27-8-2021 left join academic_fees ac on ac.stream_id=ad.stream_id and ad.academic_year=ac.admission_year and ad.year=ac.year
		//ad.academic_year='".$data['academic_year']."'  
      // echo $DB1->last_query(); 
	   //exit;ed.enrollment_no AS exam_status, # left join (select distinct e.stud_id,enrollment_no from exam_details e where e.exam_id in(18,19,20,21,23)) as ed on ed.stud_id=ad.student_id
		$result=$query->result_array();
		return $result;
   
 }
 
 
public function get_studentwise_admission_fees($data){
	
	 $role_id = $this->session->userdata('role_id');
	 $emp_id = $this->session->userdata("name");
     $DB1 = $this->load->database('umsdb', TRUE);
	 $data['academic_year'];
	 $yearr = substr($data['academic_year'], -2);
	 $newy=$yearr+1;
	 $current_aced=$data['academic_year'].'-'.$newy;
	if($data['erp_type']=="phd"){
		$erp_type=" AND (sm.`admission_cycle` != ''  or sm.`admission_cycle` is not null)";
	}elseif($data['erp_type']=="R"){
		$erp_type="AND (sm.`admission_cycle` = '' or sm.`admission_cycle` is null)";
	}else{
		$erp_type='';
	}
	 if($data['academic_year']<=2019){
		 
		  if($data['admission_type']=="N"){//new
		 // echo '1_N';
         $cond ="  sm.admission_session='".$data['academic_year']."' AND ad.academic_year='".$data['academic_year']."'  AND ad.`cancelled_admission` = 'N'" ;//sm.admission_confirm='Y'
	    }else if($data['admission_type']=="R"){//Register
		// echo '1_R';
	        $cond ="  ad.academic_year='".$data['academic_year']."'   AND sm.admission_session!='".$data['academic_year']."' AND ad.`cancelled_admission` = 'N'";//AND sm.admission_confirm='Y' AND ad.`enrollment_no` != ''
	    
		}else{//BOTH
	      // echo '1';
		    $cond =" ad.`cancelled_admission` = 'N' AND ad.academic_year='".$data['academic_year']."'"; //AND sm.admission_confirm='Y'
	    }
		
	 }else{
		 
		 
		 
       if($data['admission_type']=="N"){
		 //    echo '2_N';
		 if($data['academic_year']==2025){
			 $confirm='Y';
		 }else{
			 $confirm='Y';
		 }
         $cond =" sm.admission_session='".$data['academic_year']."' AND ad.academic_year='".$data['academic_year']."' AND ad.`cancelled_admission` = 'N' $erp_type" ;//sm.admission_confirm='$confirm' and 
	    }else if($data['admission_type']=="R")
	    {
		//	echo '2_R';
	        $cond ="  ad.academic_year='".$data['academic_year']."'  AND sm.`enrollment_no` != '' AND sm.admission_session!='".$data['academic_year']."' AND ad.`cancelled_admission` = 'N' AND sm.admission_confirm='Y' AND sm.admission_confirm='Y' $erp_type";//
	    }
	    else {
		//	echo '2';
	     $cond =" ad.academic_year='".$data['academic_year']."'   AND sm.`enrollment_no` != '' AND ad.`cancelled_admission` = 'N'  $erp_type";
		  //  $cond ="  AND sm.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N' AND  sm.admission_confirm='Y' AND sm.`enrollment_no` != ''"; //AND sm.admission_confirm='Y'
	    //AND sm.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N' AND sm.admission_confirm='Y'
		}
		
		
	 }
		if( $emp_id=='sunInternational'){
			 $cond .=" and sm.nationality='International' ";
		}
		//exit();
         if($data['get_by']=="stream"){
              $cond.=" AND sm.admission_stream='".$data['stream_id']."' and ad.year ='".$data['year']."'";
         }
         else
         {
             $cond.="";
         }
		 if($role_id==49 && $emp_id=='kp_1014'){
			  $cond.=" AND v.stream_id in(223,222,160,161)";  
		 }elseif($role_id==49 && $emp_id=='kp_sunstone'){
			 $cond.=" AND v.stream_id in(224,228,248)";
		 }else{
		 if($data['school_code'] !="" && $data['school_code'] !=0){
              $cond.=" AND v.school_code='".$data['school_code']."'";
         }		 
         else
         {
             $cond.="";
         }
		 }
		 if(($data['admission-course'] !="") && ($data['admission-course'] !=0) ){
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
		//$cond .=" AND sm.package_name='Reddy' ";
		
		 /*$cond .=" AND sm.enrollment_no in ('240101461098','240101461081','240101461085','240101461079','240101461096','240101461084','240101461092','240101461034','240101461061','240101461032','240101461105','240105231380','240106271327','240106271330','240106271225','240106271293','240106271243','240105232055','240105231879','240105231598','240105231951','240105231937','240105231990','240105231978','240105232039','240105231439','240105231584','240105231383','240105232054','240105231341','240105231522','240105231972','240105231294','240105232033','240105231645','240105231980','240105232053','240105231665','240105231702','240105231716','240105231240','240105231908','240105231894','240105231453','240105231611','240105231486','240105231746','240105231843','240105231929','240105231472','220105131170','240105231298','240105231494','220105131084','240105231817','240105231898','220105231085','240105231925','240105231986','220105131283','240105231568','240105231767','240105232056','240105231399','240105231786','240105231842','240105231988','240105231705','240105231485','220105231141','240105231950','240105231541','240105231933','240105231231','240105231363','240105231615','240105231944','240105231469','240105232043','240105232036','240105231079','240105231812','240105231828','240105231601','240105231344','240105231816','240105232051','240105231447','240105231742','240105131406','240105231238','240105231664','240105231987','230105131257','240105231501','240105231841','240105231562','230101091014','240105231229','240105231248','240105231249','240105231126','240105231606','240105231847','230105131360','240101461090','240105231770','240105231656','240105231846','230105131476','230105131290','230105131355','240105231236','240105231262','230105131358','240105231830','230105131412','240105231116','240105231741','240105231744','240105231607','240105231122','240105231198','240105231962','240105231976','240105231942','240105232015','240105231417','240105231655','240105231599','240105231619','240105232059','240105231878','240105231877','240105232032','240105231296','240105232049','240105231998','240105231264','240105131426','240105232031','240105231054','240105232019','240105232047','240105231971','240105131182','240105131437','240105231521','240105131386','240105131230','240105131387','240105231945','240105131333','240105131411','240105131440','240105231730','240105131441','240105231766','240105131320','240105131338','240105131200','240205131142','240105131353','240105231685','240105131390','240105231682','240105231234','240105232030','240105231181','240105231882','240105231629','240105231237','240105231402','240105231273','240105231512','240105231524','240105231749','240105231683','240105231938','220105231128','240105231084','240105231180','240105231848','240105231943','240105231349','240105121017','240105231548','240105231957','240105231696','240105232029','240105231918','240105231928','240105231104','240105231892','240105231751','240105231874','240105231713','240105231345','240105231106','240105231896','240105231175','240105231838','240105231167','240105231475','240105231244','240105231640','240105231442','230102041031','240105231956','240105231199','240105231686','240105231156','240105231384','240105231958','240105231984','240105231663','240105231939','240105231993','240102161016','240102161015','240105181040','240105181091','240105181033','240105182009','240105181036','240105181050','240105181060','240105181034','240105181089','240105181052','240102041019','240101081028','240105131374','240105131402','240105131359','240105131397','240105131442','240105131240','240105131221','240105131435','240105131428','240105131201','240101461025','240105131224','240105131189','240105131424','240105131319','240105131172','240105131416','240105131366','240105131432','240105131393','240105131392','240105131362','240105131194','240105131373','240105131444','240101052008','240105231317','240101461094','230101461018','230101081003','230106301023','230106301021','240102621015','240106271295','240106271288','240106271294','240106271171','230106271201','230106271159','230106271197','230105011409','230106271211','230106271183','230106271108','230106271107','220106271086','220106271057','220106271069','220106271061','220106271024','220106271063','220106271033','220106271046','220106271043','220106271071','220106271050','220102011034','230102241001','240105231451','240105231132','240105231966','240105231985','240105231114','240105231171','240105231271','240105231459','240105231265','240105231099','240105231608','240105231443','240105231103','240105231213','240105231064','240105231982','240105231239','240105231871','240105231387','240105231525','240105231905','240105231862','240105231876','240105231186','240105231911','240105231996','240105232035','240105231844','240105231573','240105231968','240105231697','240105231222','240105231621','220105231110','220105181037','240105231880','240105231964','240105231865','230105181036','240105181042','240105181055','240105181056','240105181092','240105181090','240105181094','240105181021','240105181073','240105181049','240105181035','240105181045','240105231247','240105131193','240105231886','240105231967','240105181032','240105231438','240105231720','240105181082','240105181077','240105231866','240105231793','240105231491','240105231885','240105231152','240105231190','240105231778','240105231724','240105231187','240105231119','240105231466','240105231953','240105231680','240105231552','240105231105','240105231883','240105231881','240105231931','240105231557','240105231699','240105231860','240105231254','240105231947','240105231791','240105231726','240105231677','240105231337','240105231434','240105231432','240105231201','240105231245','240105231471','240105231646','240105231159','240105231476','240105231704','240105231946','240105231178','240105231072','240105232046','240105231474','240105231376','240105231681','240105231462','240105231735','240105231174','240105231666','240105231810','240105231785','240105231563','240105231292','240105231217','240105231690','240105231523','240105231965','240105231706','240105231712','240105231587','240105231195','240102161014','240105231991','240105231800','240105231695','240105231529','240105231570','240105231668','240105231109','240105231053','240105231498','240105231588','240105231679','240105231496','240105231100','240105231809','240105231867','240105231391','240105231539','240105231858','240105231419','240105231723','240105231427','240105231811','240105231734','240105231660','240105231797','240105231295','240105231661','240105231267','240105231571','240105231515','240105231650','220105231112','220105231118','220105231043','220105231052','240105231642','220105231053','240105231281','220105231061','240105231519','240105231688','240105232058','220105231050','220105131185','220105131141','220105231069','240105231761','240105231357','220105231103','220105231054','220105231137','220105231084','220105231102','220105231094','220105231095','220105131279','220105231124','220105231117','220105231132','220105231129','220105231152','220105231134','220105231133','240105231626','230105231419','230105231293','240105231209','230105232016','230105232017','240102161013','230105231122','230105231298','240105231385','230105231059','240105231318','230105231087','230105231252','230105231065','230105231101','230105231189','240105231748','230105231230','230105231200','230105231035','240105231595','240105231321','230105231217','240105231139','230105231365','230105231137','230105231156','230105231277','240105231253','230105231139','230105231311','230101461029','230105231403','230105231223','230105231309','240105231220','230105231390','240105231332','240105231836','230105231070','230105231083','230105231241','230105231250','230105131183','230105231246','230105231301','230105231315','230105231258','230105231183','230105231387','240105231080','230105231260','240105231535','230105231240','230105231351','230105231379','230105231407','230105231398','230105231310','230105231336','230105231269','230105231378','230105231305','230105231303','240105121012','230105231296','230105231337','230105131385','230105231370','230105232023','230105231363','230105231410','230105231366','230105231352','230105231343','230105231416','230105231409','230105181039','230105231406')"; */ //#,ac.`total_fees` AS Final_Total,ac.`tution_fees` AS atution_fees
		/*left join academic_fees ac on ac.stream_id=ad.stream_id AND ac.academic_year='".$current_aced."' 
	 AND ac.admission_year=sm.admission_session AND CASE WHEN (ad.year<2 AND sm.admission_year=1) THEN ac.year=ad.year 
	 WHEN (ad.year=2 AND sm.admission_year=2 ) THEN ac.year=ad.year 
	 ELSE ac.year=0 END*/
     $sql="select sm.uniform_status, hf.hostel_paid,abs.benefit_name,sm.admission_session,sm.belongs_to,sm.admission_confirm,sm.package_name,ad.year,ad.hostel_required,v.is_partnership,v.partnership_code,v.course_pattern,sm.stud_id, CASE WHEN course_pattern='SEMESTER' 
	 THEN v.course_duration *2 else v.course_duration end as final_semester,sm.current_semester,sm.academic_year as acdyer,
	 sm.enrollment_no,sm.enrollment_no_new,sm.first_name,sm.middle_name,sm.last_name,sm.religion,sm.category,sm.sub_caste,sm.mobile,
	 sm.nationality,'' as country_name,sm.belongs_to,ad.concession_remark,
	 pd.parent_mobile2,sm.reported_status, COALESCE (sm.reported_date,'--') as reported_date,
	 sm.gender,sm.admission_cycle,v.school_short_name,v.school_name,v.course_name,v.course_short_name,v.stream_name,v.course_short_name as course,
	 v.stream_short_name,v.stream_id,ad.year as admission_year,sum(ad.applicable_fee) as applicable_total ,sum(ad.actual_fee) as actual_fees,
	 sum(case when f.amount is null then 0 else f.amount end ) as fees_total,sum(f.charges) as cancel_charges, count(ad.student_id) as stud_total ,
	 ad.cancelled_admission,sum(case when rf.amount is null then 0 else rf.amount end )as refund ,
	 ad.academic_year,ad.opening_balance,st.state_name,dt.district_name,tm.taluka_name,sm.nationality,sum(case when fh.amount is null then 0 else fh.amount end ) as hostel_fees_total 
	 from admission_details ad 
	 left join student_master sm on sm.stud_id=ad.student_id AND sm.enrollment_no!=''
	 
	 LEFT JOIN (
    SELECT 
        student_id,
        adds_of,
        address_type,
        state_id,
        district_id,
        city
    FROM address_details
    WHERE adds_of='STUDENT'
      AND address_type='PERMNT'
    GROUP BY student_id
) AS ads ON ads.student_id = ad.student_id
	left join states as st on st.state_id=ads.state_id 
	left join district_name as dt on dt.district_id=ads.district_id
	left join taluka_master as tm on tm.taluka_id=ads.city 
	
	 left join vw_stream_details v on v.stream_id=ad.stream_id
     left join ( select distinct student_id,academic_year,count(student_id)as total_count,sum( case when chq_cancelled='N' then amount else 0 end) as amount,sum( case when chq_cancelled='Y' then canc_charges else 0 end) as charges from fees_details where is_deleted='N' and type_id='2' group by student_id,academic_year) f on CAST(ad.student_id  AS CHAR)=f.student_id and ad.academic_year=f.academic_year 
	 
	 left join ( select distinct student_id,enrollment_no,academic_year,count(student_id)as total_count,sum( case when chq_cancelled='N' then amount else 0 end) as amount,sum( case when chq_cancelled='Y' then canc_charges else 0 end) as charges from sandipun_erp.sf_fees_details where is_deleted='N' and type_id='1' group by student_id,academic_year) fh on CAST(ad.student_id  AS CHAR)=fh.student_id and ad.academic_year=fh.academic_year and sm.enrollment_no=fh.enrollment_no
	 
	 left join parent_details pd on sm.stud_id=pd.student_id  
	 
	 left join (select benefit_name,student_id from sandipun_ic_erp22.admission_benefits_and_source where remark is null and is_for=1 group by student_id) abs on abs.student_id=sm.stud_id
	 
	 left join (SELECT  enrollment_no,academic_year,student_id,SUM(CASE WHEN chq_cancelled = 'N' THEN amount ELSE 0 END) AS hostel_paid FROM sandipun_erp.sf_fees_details WHERE is_deleted = 'N' AND type_id = '1' and academic_year='".$data['academic_year']."' GROUP BY enrollment_no, academic_year) as hf on hf.student_id=sm.stud_id and hf.enrollment_no=sm.enrollment_no and hf.academic_year=ad.academic_year

     left join ( SELECT DISTINCT student_id,academic_year,SUM( CASE WHEN is_deleted='N' THEN amount ELSE 0 END) AS amount FROM fees_refunds WHERE is_deleted='N'
	  GROUP BY student_id,academic_year) rf ON ad.student_id=rf.student_id AND ad.academic_year=rf.academic_year
     where   ". $cond.$condition1."  
	 group by sm.stud_id,admission_year ".$hav." 
	 order by v.school_short_name,v.course_short_name,ad.cancelled_admission,admission_year,sm.enrollment_no asc";//AND sm.`admission_cycle`!='' AND ad.academic_year='".$data['academic_year']."'
	 //echo $sql;exit;//course,v.stream_id,
        $query=$DB1->query($sql);
		
		$result=$query->result_array();
		return $result;
   
 } 
  /* end by vighnesh */
 public function get_studentwise_admission_fees_phd($data){
	 $hav='';
	 $role_id = $this->session->userdata('role_id');
	 $emp_id = $this->session->userdata("name");
     $DB1 = $this->load->database('umsdb', TRUE);
	 $data['academic_year'];
	 $yearr = substr($data['academic_year'], -2);
	 $newy=$yearr+1;
	 $current_aced=$data['academic_year'].'-'.$newy;
	
	 if($data['academic_year']<=2019){
		 
		  if($data['admission_type']=="N"){//new
         $cond ="  sm.admission_session='".$data['academic_year']."' AND  sm.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N'" ;//sm.admission_confirm='Y'
	    }else if($data['admission_type']=="R"){//Register
	        $cond ="  ad.academic_year='".$data['academic_year']."'  AND  sm.`cancelled_admission` = 'N'   AND sm.admission_session!='".$data['academic_year']."' AND ad.`cancelled_admission` = 'N'";//AND sm.admission_confirm='Y' AND ad.`enrollment_no` != ''
	    
		}else{//BOTH
	        $cond ="   sm.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N'"; //AND sm.admission_confirm='Y'
	    }
		
	 }else{
		 
		 
       if($data['admission_type']=="N"){
         $cond ="  sm.admission_session='".$data['academic_year']."' AND  sm.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N' AND sm.admission_confirm='Y'" ;//sm.admission_confirm='Y'
	    }else if($data['admission_type']=="R")
	    {
	        $cond ="  ad.academic_year='".$data['academic_year']."'  AND  sm.`cancelled_admission` = 'N'  AND sm.`enrollment_no` != '' AND sm.admission_session!='".$data['academic_year']."' AND ad.`cancelled_admission` = 'N' AND sm.admission_confirm='Y'";//AND sm.admission_confirm='Y' 
	    }
	    else 
	    {
	     $cond =" ad.academic_year='".$data['academic_year']."'   AND sm.`enrollment_no` != '' AND sm.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N' AND sm.admission_confirm='Y'";
		  //  $cond ="  AND sm.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N' AND  sm.admission_confirm='Y' AND sm.`enrollment_no` != ''"; //AND sm.admission_confirm='Y'
	    //AND sm.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N' AND sm.admission_confirm='Y'
		}
		
		
	 }
		
         if($data['get_by']=="stream"){
              $cond.="  sm.admission_stream='".$data['stream_id']."' and ad.year ='".$data['year']."'";
         }
         else
         {
             $cond.="";
         }
		 
		 if($data['school_code'] !="" && $data['school_code'] !=0){
              $cond.="  v.school_code='".$data['school_code']."'";
         }
         else
         {
             $cond.="";
         }
		 if(($data['admission-course'] !="") && ($data['admission-course'] !=0) ){
              $cond.="  v.course_id='".$data['admission-course']."'";
         }
         else
         {
             $cond.="";
         }
		 if($data['admission-branch'] !="" && $data['admission-branch'] !=0 ){
              $cond.="  v.stream_id='".$data['admission-branch']."'";
         }
         else
         {
             $cond.="";
         }
		 
		 //$cond .=" AND sm.enrollment_no not in (190101061007,190101061019,190101062024,190101062018,190101062039,170101061018,190101082020,180101091012,180101091030,180101092035,190101181011,180105041031,180105181052,190105141005,190114021005,190102011125,190102011141,180102011081,180102011120,190104051006,190104061003,190104061002,190104071004,190106191006,180101061004,180101061034)";
		 
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
		 
     $sql="select ad.year,v.is_partnership,v.partnership_code,v.course_pattern,sm.stud_id, CASE WHEN course_pattern='SEMESTER' THEN v.course_duration *2 else v.course_duration end as final_semester,sm.current_semester,sm.academic_year as acdyer,sm.enrollment_no,sm.enrollment_no_new,sm.first_name,sm.middle_name,sm.last_name,sm.religion,sm.category,sm.sub_caste,sm.mobile,pd.parent_mobile2,sm.reported_status, COALESCE (sm.reported_date,'--') as reported_date,
	 sm.gender,sm.admission_cycle,v.school_short_name,v.school_name,v.course_name,v.stream_name,v.course_short_name as course,v.stream_short_name,v.stream_id,ad.year as admission_year,sum(ad.applicable_fee) as applicable_total ,sum(ad.actual_fee) as actual_fees,sum(case when f.amount is null then 0 else f.amount end ) as fees_total,sum(f.charges) as cancel_charges, count(ad.student_id) as stud_total ,ad.cancelled_admission,sum(case when rf.amount is null then 0 else rf.amount end )as refund ,
	 ad.academic_year,ad.opening_balance,dt.district_name,tm.taluka_name,st.state_name,ac.tution_fees,
	 ac.`academic_fees`,ac.`tution_fees` AS atution_fees,ac.`development`,ac.`caution_money`,ac.`admission_form`,ac.`exam_fees`,
(ac.`Gymkhana`+ ac.`disaster_management`+ ac.`computerization`+ ac.`registration`+ ac.`student_safety_insurance`+ ac.`library`+
ac.`nss`+ ac.`eligibility`+ ac.`internet`+ac.`educational_industrial_visit`+ ac.`seminar_training`+ ac.`student_activity`+
ac.`lab`+ ac.`accommodation`) AS Other_fees,ac.`total_fees` AS Final_Total
	 from admission_details ad 
	 left join student_master sm on sm.stud_id=ad.student_id AND sm.enrollment_no!=''
	 
	
	 left join phd_academic_fees ac on ac.stream_id=ad.stream_id AND ac.academic_year='".$current_aced."' 
	 AND ac.admission_year=sm.admission_session AND CASE WHEN (ad.year<2 AND sm.admission_year=1) THEN ac.year=ad.year 
	 WHEN (ad.year=2 AND sm.admission_year=2 ) THEN ac.year=ad.year 
	 ELSE ac.year=0 END
	 
	 left join vw_stream_details v on v.stream_id=ad.stream_id
	 left join address_details ads on ads.student_id=ad.student_id AND ads.adds_of='STUDENT' AND ads.address_type='CORS'
left join states as st on st.state_id=ads.state_id 
left join district_name as dt on dt.district_id=ads.district_id
left join taluka_master as tm on tm.taluka_id=ads.city 
     left join ( select distinct student_id,academic_year,count(student_id)as total_count,sum( case when chq_cancelled='N' then amount else 0 end) as amount,sum( case when chq_cancelled='Y' then canc_charges else 0 end) as charges from fees_details where is_deleted='N' and type_id='2' group by student_id,academic_year) f on CAST(ad.student_id  AS CHAR)=f.student_id and ad.academic_year=f.academic_year 
	 
	 left join parent_details pd on sm.stud_id=pd.student_id    
     left join ( SELECT DISTINCT student_id,academic_year,SUM( CASE WHEN is_deleted='N' THEN amount ELSE 0 END) AS amount FROM fees_refunds WHERE is_deleted='N'
	  GROUP BY student_id,academic_year) rf ON ad.student_id=rf.student_id AND ad.academic_year=rf.academic_year
     where   ". $cond.$condition1."  AND sm.`admission_cycle` IS NOT NULL
	 group by sm.stud_id,course,v.stream_id,admission_year ".$hav." 
	 order by v.school_short_name,v.course_short_name,ad.cancelled_admission,admission_year,sm.enrollment_no asc";//AND sm.`admission_cycle`!=''
        $query=$DB1->query($sql);
		#left join (select distinct e.stud_id,enrollment_no from exam_details e where e.exam_id in(18,19,20,21)) as ed on ed.stud_id=ad.student_id 
		//ad.student_id IN ('4199','1746','7566','1673','7542','5436','7356','7682','7469','7462','6198')  AND#,CASE WHEN e.enrollment_no is not null THEN 'Filled' ELSE 'Not Filled'END AS Exam_form_status
		//# LEFT JOIN exam_details e ON sm.stud_id = e.stud_id and e.exam_id=13
		//27-8-2021 left join academic_fees ac on ac.stream_id=ad.stream_id and ad.academic_year=ac.admission_year and ad.year=ac.year
		//ad.academic_year='".$data['academic_year']."'  
     //  echo $DB1->last_query(); 
	  // exit;//ed.enrollment_no AS exam_status, # left join (select distinct e.stud_id,enrollment_no from exam_details e where e.exam_id in(18,19,20,21,23)) as ed on ed.stud_id=ad.student_id
		$result=$query->result_array();
		return $result;
   
 }
 
 
 
 
 public function get_streamwise_admission_fees($data){
     
	 
	    if($data['admission_type']=="N"){
         $cond ="and st.admission_session=".$data['academic_year']." and st.admission_confirm='Y'";
	    }else  if($data['admission_type']=="R")
	    {
	        $cond ="and st.admission_session!=".$data['academic_year'];
	    }
	    else
	    {
	       $cond ="and st.academic_year=".$data['academic_year']; 
	    }
		
		if($data['school_code'] !="" && $data['school_code'] !=0){
              $cond.=" and v.school_code='".$data['school_code']."'";
         }
         else
         {
             $cond.="";
         }
		 if($data['admission-course'] !="" && $data['admission-course'] !=0 ){
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
		 
		 
       if($data['get_by']=="course"){
           $sel="v.school_short_name,v.stream_short_name ,v.course_short_name ,v.course_id,ad.year as admission_year";
           $grp="v.course_short_name,ad.year order by v.school_short_name,v.course_short_name, v.stream_short_name"; //admission_year
       }
       else{
           $sel="v.school_short_name,v.course_short_name,v.stream_short_name ,v.stream_id,ad.year as admission_year ";
           $grp="v.stream_short_name,ad.year order by v.school_short_name,v.course_short_name,v.stream_short_name ,v.stream_id";
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
         left join fees_refunds rf on rf.student_id=ad.student_id
         left join student_master st on st.stud_id=ad.student_id and st.academic_year=ad.academic_year AND st.enrollment_no!=''
        where  ad.academic_year='".$data['academic_year']."' and ad.cancelled_admission='N' and st.cancelled_admission='N' $cond 
        group by  $grp  ";//AND st.`admission_cycle`!=''
        $query=$DB1->query($sql);
	 //echo $DB1->last_query();//exit;
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
join sandipun_ums.student_master as s on (s.enrollment_no = d.enrollment_no OR s.enrollment_no_new = d.enrollment_no) AND s.stud_id = d.student_id
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
		   $cond.="  and organisation in ('SU-SIJOUL','SF-SIJOUL')"; 
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
		   if($data['campus']=="SIJOUL"){
			   
			   $sql="SELECT p.*,COALESCE(p.fees_paid,0),COALESCE(p.fine,0),fa.allocated_id,ra.hostel_code,ra.room_no,ha.hostel_name 
       FROM ( SELECT DISTINCT a.college_receiptno,fc.`exam_session`,fc.`bank_id`,fba.`bank_account_id`,
fba.`account_name`,fba.`bank_name`,fba.`client_id`,f.created_on,f.sf_id,f.student_id,'' as belongs_to, f.enrollment_no,f.enrollment_no as enrollment_no_new,s.first_name,
s.middle_name,s.last_name,s.mobile,s.email,s.gender,
f.year,f.organisation,s.instute_name as intitute,s.stream as branch_short_name,s.stream as course_name,s.stream,f.academic_year,f.deposit_fees,f.actual_fees,f.refund as cancellation_refund,f.gym_fees,f.fine_fees,f.opening_balance, a.fees_paid,a.fine,f.excemption_fees,f.cancelled_facility,(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees+f.opening_balance-f.excemption_fees) as appl FROM sandipun_erp.sf_student_facilities f
        LEFT JOIN (SELECT enrollment_no,student_id,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine,college_receiptno,type_id 
		FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='1' and academic_year='".$data['academic_year']."' 
		GROUP BY enrollment_no,academic_year) a ON a.enrollment_no=f.enrollment_no AND a.student_id=f.student_id AND f.academic_year=a.academic_year
		LEFT JOIN sf_fees_challan AS fc ON fc.exam_session=a.college_receiptno
LEFT JOIN sf_bank_account_details AS fba ON fba.`bank_account_id`=fc.`bank_account_id`
        INNER JOIN sandipun_erp.sf_student_master s ON s.enrollment_no=f.enrollment_no AND s.student_id=f.student_id where f.sffm_id=1 and f.status='Y' 
		and f.cancelled_facility='N' and f.academic_year='".$data['academic_year']."' 
        UNION 
       SELECT DISTINCT  a.college_receiptno,fc.`exam_session`,fc.`bank_id`,fba.`bank_account_id`, fba.`account_name`,fba.`bank_name`,
  fba.`client_id`,f.created_on,f.sf_id,f.`student_id`,dr.Payment_type as belongs_to,f.enrollment_no,s.enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,s.email,s.gender,f.year,
  f.organisation,p.school_short_name AS intitute, p.stream_short_name AS branch_short_name,p.course_short_name AS course_name,
  concat(p.stream_name) as stream,f.academic_year,f.deposit_fees,f.actual_fees,f.refund as cancellation_refund,
  f.gym_fees,f.fine_fees,f.opening_balance,a.fees_paid,a.fine,f.excemption_fees,f.cancelled_facility,
  (f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees+f.opening_balance-f.excemption_fees) as appl 
	   FROM sandipun_erp.sf_student_facilities f 
	   LEFT JOIN (SELECT enrollment_no,student_id,academic_year,SUM( amount )AS fees_paid,SUM(exam_fee_fine) AS fine,college_receiptno,type_id 
	   FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='1' and academic_year='".$data['academic_year']."'  
	   and enrollment_no not like '18SUN%' GROUP BY enrollment_no,academic_year) a ON a.enrollment_no=f.enrollment_no AND a.student_id=f.student_id 
	   AND f.academic_year=a.academic_year 
	   LEFT JOIN sf_fees_challan AS fc ON fc.exam_session=a.college_receiptno
       LEFT JOIN sf_bank_account_details AS fba ON fba.`bank_account_id`=fc.`bank_account_id`
	   INNER JOIN sandipun_ums_sijoul.student_master s ON (s.enrollment_no=f.enrollment_no or s.enrollment_no_new=f.enrollment_no) and s.stud_id=f.student_id 
	   INNER JOIN sandipun_ums_sijoul.vw_stream_details p ON s.admission_stream=p.stream_id 
	   LEFT JOIN sandipun_ums_sijoul.student_bank_details dr ON dr.student_id=s.stud_id  and dr.Payment_type='DRCC'
	   where f.sffm_id=1 and f.status='Y' and 
	   f.cancelled_facility='N' and f.academic_year='".$data['academic_year']."' and f.enrollment_no not like '18SUN%'
	   
	   ) p 
       
	   
	   LEFT JOIN sf_student_facility_allocation fa ON fa.sf_id=p.sf_id AND fa.is_active='Y'
        LEFT JOIN sf_hostel_room_details ra ON ra.sf_room_id=fa.allocated_id 
		   LEFT JOIN `sf_hostel_master` ha ON ha.`host_id`=ra.host_id 

		WHERE $cond";
			   //echo $sql;exit;
			   
			   }else{
		   $sql="SELECT p.*,COALESCE(p.fees_paid,0),COALESCE(p.fine,0),fa.allocated_id,ra.hostel_code,ra.room_no,ha.hostel_name 
       FROM ( SELECT DISTINCT a.college_receiptno,fc.`exam_session`,fc.`bank_id`,fba.`bank_account_id`,
fba.`account_name`,fba.`bank_name`,fba.`client_id`,f.created_on,f.sf_id,f.student_id,f.enrollment_no,f.enrollment_no as punching_prn,f.is_package as belongs_to, f.enrollment_no as enrollment_no_new,s.first_name,
s.middle_name,s.last_name,s.mobile,s.email,s.gender,
f.year,f.organisation,s.instute_name as intitute,s.stream as branch_short_name,s.stream as course_name,s.stream,f.academic_year,f.deposit_fees,f.actual_fees,f.refund as cancellation_refund,f.gym_fees,f.fine_fees,f.opening_balance, a.fees_paid,a.fine,f.excemption_fees,f.cancelled_facility,(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees+f.opening_balance-f.excemption_fees) as appl, '-' as cancelled_admission,f.remark
 FROM sandipun_erp.sf_student_facilities f
        LEFT JOIN (SELECT enrollment_no,student_id,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine,college_receiptno,type_id 
		FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='1' and academic_year='".$data['academic_year']."' 
		GROUP BY enrollment_no,academic_year) a ON a.enrollment_no=f.enrollment_no AND a.student_id=f.student_id AND f.academic_year=a.academic_year
		LEFT JOIN sf_fees_challan AS fc ON fc.exam_session=a.college_receiptno
LEFT JOIN sf_bank_account_details AS fba ON fba.`bank_account_id`=fc.`bank_account_id`
        INNER JOIN sandipun_erp.sf_student_master s ON s.enrollment_no=f.enrollment_no AND s.student_id=f.student_id where f.sffm_id=1 and f.status='Y' 
		and f.cancelled_facility='N' and f.academic_year='".$data['academic_year']."' 
        UNION 
       SELECT DISTINCT  a.college_receiptno,fc.`exam_session`,fc.`bank_id`,fba.`bank_account_id`, fba.`account_name`,fba.`bank_name`,
  fba.`client_id`,f.created_on,f.sf_id,f.`student_id`,f.enrollment_no,s.punching_prn,s.belongs_to,s.enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,s.email,s.gender,f.year,
  f.organisation,p.school_short_name AS intitute, p.stream_short_name AS branch_short_name,p.course_short_name AS course_name,
  concat(p.stream_name) as stream,f.academic_year,f.deposit_fees,f.actual_fees,f.refund as cancellation_refund,
  f.gym_fees,f.fine_fees,f.opening_balance,a.fees_paid,a.fine,f.excemption_fees,f.cancelled_facility,
  (f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees+f.opening_balance-f.excemption_fees) as appl,s.cancelled_admission,f.remark 
	   FROM sandipun_erp.sf_student_facilities f 
	   LEFT JOIN (SELECT enrollment_no,student_id,academic_year,SUM( amount )AS fees_paid,SUM(exam_fee_fine) AS fine,college_receiptno,type_id 
	   FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='1' and academic_year='".$data['academic_year']."'  
	   and enrollment_no not like '18SUN%' GROUP BY enrollment_no,academic_year) a ON a.enrollment_no=f.enrollment_no AND a.student_id=f.student_id 
	   AND f.academic_year=a.academic_year 
	   LEFT JOIN sf_fees_challan AS fc ON fc.exam_session=a.college_receiptno
       LEFT JOIN sf_bank_account_details AS fba ON fba.`bank_account_id`=fc.`bank_account_id`
	   INNER JOIN sandipun_ums.student_master s ON (s.enrollment_no=f.enrollment_no or s.enrollment_no_new=f.enrollment_no) and s.stud_id=f.student_id 
	   INNER JOIN sandipun_ums.vw_stream_details p ON s.admission_stream=p.stream_id where f.sffm_id=1 and f.status='Y' and 
	   f.cancelled_facility='N' and f.academic_year='".$data['academic_year']."' and f.enrollment_no not like '18SUN%') p 
       
	   LEFT JOIN sf_student_facility_allocation fa ON fa.sf_id=p.sf_id AND fa.is_active='Y'
        LEFT JOIN sf_hostel_room_details ra ON ra.sf_room_id=fa.allocated_id 
		   LEFT JOIN `sf_hostel_master` ha ON ha.`host_id`=ra.host_id 

		WHERE $cond";
		   }
//echo $sql;exit;
	       $query=$DB1->query($sql);

         if($this->session->userdata("role_id")==6){
    	// echo $DB1->last_query();exit();
		  }
		  //echo $DB1->last_query();exit();
    		$result=$query->result_array();
    		return $result;
 
 }
 
  public function get_institute_fees_statistics($data){
    	$DB1 = $this->load->database('umsdb', TRUE);
    	 $cond=" academic_year='".$data['academic_year']."' ";
    	  if($data['campus']=="NASHIK"){
    	        $cond.="  and organisation in ('SU','SF')"; 
				$db='sandipun_ums';
    	  }
    	  else  if($data['campus']=="SIJOUL"){
    	       $cond.="  and organisation='SF-SIJOUL'"; 
			   $db='sandipun_ums_sijoul';
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
 INNER JOIN $db.student_master s ON (s.enrollment_no=f.enrollment_no OR s.enrollment_no_new=f.enrollment_no) AND s.stud_id=f.student_id
 INNER JOIN $db.vw_stream_details p ON s.admission_stream=p.stream_id where  f.cancelled_facility='N' AND f.sffm_id='1' AND f.academic_year=".$data['academic_year']."
 )b where $cond GROUP BY b.organisation,b.college_name,b.academic_year
 ";
	
   $query=$DB1->query($sql);
   if($this->session->userdata("role_id")==6){
    	//   echo $DB1->last_query(); //exit();
   }
  // echo $DB1->last_query(); //exit();
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
		$sql="SELECT b.hostel_name,b.hostel_type,b.campus_name,b.area,b.in_campus,b.hostel_code,b.academic_year,b.capacity,b.host_id,b.capacity,b.actual_capacity,
		     COUNT(b.enrollment_no) AS stud_total,SUM(b.fees_paid)AS fees_paid,SUM(b.fine)AS fine, SUM(b.deposit_fees) AS deposit_fees,SUM(b.actual_fees) AS actual_fees,SUM(b.gym_fees) AS gym_fees,SUM(b.fine_fees)AS fine_fees,SUM(b.opening_balance)AS opening_balance,SUM(b.excemption_fees) AS excemption_fees FROM 
            (SELECT DISTINCT a.fees_paid,a.fine,f.enrollment_no,
			h.hostel_name,h.hostel_type,h.area,h.campus_name,h.actual_capacity,h.no_of_beds AS capacity,h.in_campus,h.host_id,
			r.bed_number,r.hostel_code,r.room_no,
			f.academic_year,f.deposit_fees,f.actual_fees,f.gym_fees,f.fine_fees,f.opening_balance,f.excemption_fees,f.cancelled_facility 
			 FROM sandipun_erp.sf_student_facilities f 
            LEFT JOIN (SELECT enrollment_no,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' GROUP BY enrollment_no,academic_year) a 
            ON a.enrollment_no=f.enrollment_no AND f.academic_year=a.academic_year 
            INNER JOIN sandipun_erp.sf_student_facility_allocation s ON s.enrollment_no=f.enrollment_no AND s.academic_year=f.academic_year AND s.is_active='Y' AND s.sffm_id=1
            INNER JOIN sandipun_erp.sf_hostel_room_details r ON r.sf_room_id=s.allocated_id 
            INNER JOIN sandipun_erp.sf_hostel_master h ON h.host_id=r.host_id where f.sffm_id=1)b where $cond
            GROUP BY b.hostel_name,b.hostel_type,b.campus_name,b.in_campus,b.hostel_code,b.academic_year
             ";
         $query=$DB1->query($sql);
		 
         if($this->session->userdata("role_id")==6){
    	// echo $DB1->last_query(); exit();
         }
		$uId=$this->session->userdata('uid');
		/* if($uId=='2')
		{
				echo $DB1->last_query();
				die;
		} */
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



    public function student_fees_details()
    {
         $DB1 = $this->load->database('umsdb', TRUE); 
       $sql=" SELECT fd.amount,fd.receipt_no,fd.fees_date,fd.college_receiptno,fd.created_on,sm.first_name,sm.last_name,sd.school_short_name,sd.stream_name,sm.academic_year,sm.current_year, sm.enrollment_no from  fees_details  AS fd
            inner JOIN `student_master` AS sm ON  
            sm.stud_id=fd.student_id

             INNER JOIN vw_stream_details sd ON sd.stream_id = sm.admission_stream
             WHERE fd.student_id REGEXP '^[0-9]+$' and  fd.fees_paid_type='CHQ' and fd.type_id='2' and fd.chq_cancelled='N' and fd.is_deleted='N' and fd.academic_year='2019' and  sm.academic_year='2019' and  CAST(fd.student_id AS UNSIGNED) > 0"; 
            
             //echo $sql; 
             $query=$DB1->query($sql);
            $result=$query->result_array();
            return $result;
    }
	
	function fetch_stud_curr_year(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('academic_year');
		//$DB1->where("currently_active", 'Y');
		$DB1->order_by("id", 'desc');
		//$DB1->limit(1);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	
	
	 function getAllStudents(){
		
    	    $DB1 = $this->load->database('umsdb', TRUE);
			
		$DB1->select("sm.*,stm.stream_name,stm.course_id");
		$DB1->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		
		$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		  //echo $DB1->last_query();
	  
	//	die();  */ 
		$result=$query->result_array();
		$cnt=count($result);
		return $cnt;
	}
	
	function getStudents($offSet=0,$limit=1,$streamid='',$year=''){
			$uId=$this->session->userdata('uid');	
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,cm.course_name, pd.parent_mobile2");
		$DB1->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		$DB1->join('parent_details as pd','pd.student_id = sm.stud_id','left');
		$DB1->where("sm.created_by", $uId);
		if($streamid !='')
		{
			$DB1->where("sm.admission_stream",$streamid);	    
		}
		if($year !='')
		{
			$DB1->where("sm.admission_year", $year);	   	    
		}
		$DB1->order_by("sm.enrollment_no", "asc");
		//$DB1->limit(10); //testing pupose only
		$query=$DB1->get();
		/*  echo $this->db->last_query();
		die();  */ 
		$result=$query->result_array();
		 //echo $this->db->last_query();
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
    
	
	function searchStudentfeedata1($prn=''){
    	     $academic_year=ACADEMIC_YEAR;	
			  $academic_year1=ACADEMIC_YEAR;
		 $c = explode('-', $academic_year);
	     $academic_year =$c[0];
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,vw.stream_name,vw.course_name,ad.`adm_id`,af.tution_fees,
		ad.`student_id`,ad.`batch_cycle`,ad.`school_code`,ad.`stream_id`,ad.`year`,ad.`academic_year`,ad.`actual_fee`,
		ad.`applicable_fee`,ad.`opening_balance`,ad.`total_fees_paid`,ad.concession_id
,ad.`fees_consession_allowed`,ad.`concession_type`,ad.`duration`,ad.`concession_remark`,ad.`hostel_required`,ad.`hostel_type`,
ad.`transport_required`,ad.`transport_boarding_point`,ad.`remark`,ad.`cancelled_admission`,ad.`fess_update_bybala`,fcd.duration as fduration");
		$DB1->from('student_master as sm');
		//$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
			//$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
			$DB1->join('vw_stream_details as vw','vw.stream_id = sm.admission_stream','left');	
			$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	
			$DB1->join('academic_fees as af','vw.stream_id = af.stream_id and af.academic_year="'. $academic_year1.'" 
			and af.admission_year="'. $academic_year.'" and af.year=1','left');	
			$DB1->join('fees_consession_details as fcd','fcd.student_id = ad.student_id and fcd.academic_year=ad.academic_year','left');
			if(!empty($prn)){
				$where=" (sm.enrollment_no='$prn' or sm.enrollment_no_new='$prn')";
			$DB1->where("$where");
			}
		$DB1->where("ad.academic_year", $academic_year);	
        $DB1->where("sm.admission_session", $academic_year);	    	    
		$DB1->where("sm.cancelled_admission",'N');	 
		$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
		
		//echo $DB1->last_query();
		//exit;
		$result=$query->result_array();
		return $result;
	}
	
	function getCollegeCourse($col_id=1){
         $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT(course_id),course_name,course_short_name FROM vw_stream_details";
		if(isset($_SESSION['role_id']) && $_SESSION['role_id']==10)
		{
		    $ex =explode("_",$_SESSION['name']);
		    $sccode = $ex[1];
		    $sql .=" where school_code = $sccode";
		}
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	
	
		function Scholarship_type(){
		
		$DB1=$this->load->database('umsdb',TRUE);
		
		$DB1->select("*");
		$DB1->from("schlorship_type");
		$DB1->where("status","Y");
		$DB1->group_by("type");
		
		$query=$DB1->get();
		
		$result=$query->result_array();
		return $result;
	}
	
	function Scholarship_typee(){
		
		$DB1=$this->load->database('umsdb',TRUE);
		
		$DB1->select("*");
		$DB1->from("schlorship_type");
		$DB1->where("status","Y");
		//$DB1->group_by("type");
		
		$query=$DB1->get();
		
		$result=$query->result_array();
		return $result;
	}
	
	
	 function fee_exemption()
    {
        
$academic_year=ACADEMIC_YEAR;	
  $academic_year1=ACADEMIC_YEAR;
$c = explode('-', $academic_year);
$academic_year =$c[0];
$DB1 = $this->load->database('umsdb', TRUE);
$uId=$this->session->userdata('uid');

					
           $sid1 = implode(",",$_POST['lstd']);
   //var_dump($sid);
   $sid=array_map('intval', explode(',', $sid1));
     
	  
        foreach($sid as $stuid)
        {
			$sc=$_POST[$stuid."_scholarship"];
	  $id=explode('-', $sc);
			
      // echo $stuid.">>".$_POST[$stuid."_actual"]."**".$_POST[$stuid."_exem"]."@".$_POST[$stuid."_scholarship"]."|".$_POST['fayear']; 
          
        $tempe['actual_fee']=$_POST[$stuid."_actual"];
        $tempe['applicable_fee']=$_POST[$stuid."_actual"]-$_POST[$stuid."_exem"];
		
		$tempe['concession_type']=$id[0];
		$tempe['concession_id']=$id[1];
		$tempe['duration']=$_POST[$stuid."_duration"];
		$tempe['concession_remark']=$_POST[$stuid."_remark"];
		if($_POST[$stuid."_scholarship"]!=''){
		$tempe['fees_consession_allowed']='Y';
		}
	
		
			$DB1->where('academic_year', $academic_year);
			$DB1->where('student_id', $stuid);
			$DB1->update('admission_details',$tempe);
			
		
        $fcd['actual_fees']=$_POST[$stuid."_actual"];
        $fcd['fees_paid_required']=$_POST[$stuid."_appli"];
        $fcd['exepmted_fees']=$_POST[$stuid."_exem"];
		
		$fcd['concession_type']=$id[0];
		$fcd['duration']=$_POST[$stuid."_duration"];
		$fcd['concession_remark']=$_POST[$stuid."_remark"];
		
        /*$DB1->where('academic_year', $_POST['fayear']);
        $DB1->where('student_id', $stuid);
        $DB1->update('fees_consession_details',$fcd);*/
		
	    $rcnt =$this->check_if_exists_list($academic_year, $stuid);
		
		
		if($rcnt<1){
	    $fcd['student_id']=$stuid;
		$fcd['academic_year']=$academic_year;
		$fcd['created_on']=date('Y-m-d h:i:s');
		$fcd['created_by']=$uId;
		
		$DB1->insert('fees_consession_details',$fcd);
		
		$DB1->insert('scholarshiplog',$fcd);
		
		}else{
		$fcd['modified_on']=date('Y-m-d h:i:s');
		$fcd['modified_by']=$uId;	
		$DB1->where('academic_year', $academic_year);
        $DB1->where('student_id', $stuid);
		
        $DB1->update('fees_consession_details',$fcd);
		unset($fcd['modified_on']);
		unset($fcd['modified_by']);
		$fcd['created_on']=date('Y-m-d h:i:s');
		$fcd['created_by']=$uId;
		$fcd['student_id']=$stuid;
		$fcd['academic_year']=$academic_year;
		$DB1->insert('scholarshiplog',$fcd);
		}
	
	
        }
		//exit();
       // echo '<script>alert("Fees updated successfully for selected students");<script>';
	   //$url="calling/stud_feelist/";
	   $url=base_url("Account/stud_feelist/");
	     echo '<script>window.location.href = "'.$url.'";</script>';
         //redirect();
        //return 1;
     //   var_dump($sid);
       // exit(0);
    }
	
	 function check_if_exists_list($year,$student_id)
{
    
   
        $DB5 = $this->load->database('umsdb', TRUE);
		$DB5->select("count(*) as ucount");
		$DB5->from('fees_consession_details');
		$DB5->where('academic_year',$year);
		$DB5->where('student_id',$student_id);
	//	$DB1->join('address_details as ad','sm.stud_id = ad.student_id','left');
	//	$DB1->where("adds_of", "STUDENT");
		//	$DB1->where("address_type", "CORS");d.district_name,c.taluka_name,s.state_name
		$query=$DB5->get(); 
		$cn = $query->row_array();
		return $cn['ucount'];
    
}


function perview_diffferent($data){
	$DB1 = $this->load->database('umsdb', TRUE);
	$current_data=date('Y-m-d');
	
	 $current_Year=date('Y',strtotime($data['applied_to_date'])); //echo '<br>';
	 $current_month=date('m',strtotime($data['applied_to_date']));//echo '<br>';
	 $current_day=date('d' ,strtotime($data['applied_to_date']));//echo '<br>';
	
	 $academic_year=$data['academic_year'];//echo '<br>';
	 $yearr = substr($data['academic_year'], -2);
	 $yearr=$yearr+1;
	 $ac=$academic_year.'-'.$yearr;
	 $applied_to_date=$data['applied_to_date'];//echo '<br>';
	 $Type=$data['Type'];//echo '<br>';
	
	$where="";
	if($Type=="month"){
		$where .=" AND MONTH(fd.created_on)='$current_month'  AND YEAR(fd.created_on)='$current_Year'";
	}else{
		$where .=" AND MONTH(fd.created_on)='$current_month'  AND YEAR(fd.created_on)='$current_Year' AND  DAY(fd.created_on)='$current_day'";
	}
	//exit();#SUM( CASE WHEN fd.chq_cancelled='Y' THEN fd.canc_charges ELSE 0 END) AS charges ,
	$sql="SELECT  ad.year,
v.is_partnership,v.partnership_code,v.course_pattern,
sm.stud_id, 
CASE WHEN course_pattern='SEMESTER' THEN v.course_duration *2 ELSE v.course_duration END AS final_semester,
sm.current_semester,sm.academic_year AS acdyer, sm.enrollment_no,sm.enrollment_no_new,sm.first_name,sm.middle_name,sm.admission_year,
sm.last_name,sm.religion,sm.category,sm.sub_caste,sm.mobile, sm.nationality,cc.name AS country_name,sm.belongs_to, 
sm.reported_status, COALESCE (sm.reported_date,'--') AS reported_date, sm.gender,sm.admission_cycle,
v.school_short_name,v.school_name,v.course_name,v.stream_name,v.course_short_name AS course, v.stream_short_name,v.stream_id,

fd.student_id,fd.academic_year,COUNT(fd.student_id)AS total_count,
SUM( CASE WHEN fd.chq_cancelled='N' THEN fd.amount ELSE 0 END) AS amount,

ad.academic_year,ad.opening_balance,
SUM(ad.applicable_fee) AS applicable_total ,SUM(ad.actual_fee) AS actual_fees, 
SUM(CASE WHEN fd.amount IS NULL THEN 0 ELSE fd.amount END ) AS fees_total,
SUM(( CASE WHEN fd.chq_cancelled='Y' THEN fd.canc_charges ELSE 0 END)) AS cancel_charges,

SUM(CASE WHEN rf.amount IS NULL THEN 0 ELSE rf.amount END )AS refund,
ac.tution_fees, ac.`academic_fees`,
ac.`tution_fees` AS atution_fees,ac.`development`,ac.`caution_money`,ac.`admission_form`,ac.`exam_fees`, 
(ac.`Gymkhana`+ ac.`disaster_management`+ ac.`computerization`+ ac.`registration`+ ac.`student_safety_insurance`+ ac.`library`+ 
ac.`nss`+ ac.`eligibility`+ ac.`internet`+ac.`educational_industrial_visit`+ ac.`seminar_training`+ ac.`student_activity`+ ac.`lab`+ 
ac.`accommodation`) AS Other_fees,ac.`total_fees` AS Final_Total ,fd.fees_paid_type
FROM fees_details AS fd
JOIN student_master AS sm ON sm.`stud_id`=fd.`student_id`
JOIN admission_details AS ad ON ad.`student_id`=fd.`student_id` AND ad.academic_year='$academic_year'
#AND sm.admission_session!='$academic_year'

LEFT JOIN vw_stream_details v ON v.stream_id=ad.stream_id 
LEFT JOIN address_details ads ON ads.student_id=ad.student_id AND ads.adds_of='STUDENT' AND ads.address_type='PERMNT' 
LEFT JOIN states AS st ON st.state_id=ads.state_id 
LEFT JOIN district_name AS dt ON dt.district_id=ads.district_id 
LEFT JOIN taluka_master AS tm ON tm.taluka_id=ads.city 
LEFT JOIN countries AS cc ON cc.id=ads.country_id 


LEFT JOIN academic_fees ac ON ac.stream_id=ad.stream_id  AND ac.admission_year=sm.admission_session 
AND CASE WHEN (ad.year<2 AND sm.admission_year=1) AND ac.academic_year='$ac'
THEN ac.year=ad.year WHEN (ad.year=2 AND sm.admission_year=2 ) THEN ac.year=ad.year ELSE ac.year=0 END 
LEFT JOIN ( SELECT DISTINCT student_id,academic_year,SUM( CASE WHEN is_deleted='N' THEN amount ELSE 0 END) AS amount FROM fees_refunds 
WHERE is_deleted='N' GROUP BY student_id,academic_year) rf ON ad.student_id=rf.student_id AND ad.academic_year=rf.academic_year 


WHERE fd.is_deleted='N' AND fd.type_id='2' 
$where
GROUP BY fd.student_id,fd.academic_year";
$query=$DB1->query($sql);
    	//  echo $DB1->last_query();exit();
    		$result=$query->result_array();
    		return $result;
}

/////////////////////////
 public function get_studentwise_admission_fees_for_update($acyear){
	
	 $role_id = $this->session->userdata('role_id');
	 $emp_id = $this->session->userdata("name");
     $DB1 = $this->load->database('umsdb', TRUE);
		if($acyear!=2024){
		 $and ="AND `sm`.`admission_confirm` = 'Y'";
	 }else{
		 $and ="";
	 }	
     $sql="select sm.stud_id,sm.belongs_to,v.school_short_name,v.school_name,v.course_name,v.stream_name,v.course_short_name as course, v.stream_short_name,v.stream_id,ad.year as admission_year,sum(ad.applicable_fee) as applicable_total ,sum(ad.actual_fee) as actual_fees, sum(case when f.amount is null then 0 else f.amount end ) as fees_total,sum(f.charges) as cancel_charges, count(ad.student_id) as stud_total , ad.cancelled_admission,sum(case when rf.amount is null then 0 else rf.amount end )as refund , ad.academic_year,ad.opening_balance
from admission_details ad
left join student_master sm on sm.stud_id=ad.student_id AND sm.enrollment_no!='' 
left join vw_stream_details v on v.stream_id=ad.stream_id 
left join ( select distinct student_id,academic_year,count(student_id)as total_count,sum( case when chq_cancelled='N' then amount else 0 end) as amount,sum( case when chq_cancelled='Y' then canc_charges else 0 end) as charges from fees_details where is_deleted='N' and type_id='2' group by student_id,academic_year) f on CAST(ad.student_id AS CHAR)=f.student_id and ad.academic_year=f.academic_year 
left join ( SELECT DISTINCT student_id,academic_year,SUM( CASE WHEN is_deleted='N' THEN amount ELSE 0 END) AS amount FROM fees_refunds WHERE is_deleted='N' GROUP BY student_id,academic_year) rf ON ad.student_id=rf.student_id AND ad.academic_year=rf.academic_year 
where ad.academic_year='$acyear' AND sm.`enrollment_no` != '' AND sm.`cancelled_admission` = 'N' AND ad.`cancelled_admission` = 'N' $and 
group by sm.stud_id,course,v.stream_id,admission_year  
ORDER BY `ad`.`opening_balance` ASC";//AND sm.`admission_cycle`!=''
	 
        $query=$DB1->query($sql);
		//echo $sql;exit;
		$result=$query->result_array();
		return $result;
   
 }
  public function get_todays_fees_paid($acyear,$today){
	
	 $role_id = $this->session->userdata('role_id');
	 $emp_id = $this->session->userdata("name");
     $DB1 = $this->load->database('umsdb', TRUE);
	 
	
	
	
	
// $today_date_con1=date('Y-m-d 18:00:00',strtotime('-1 day'));
	$today_date_con =date('Y-m-d 18:00:00', strtotime('-1 day', strtotime($today)));

	$today_date_after=date($today.' 18:00:00',time());
	 
	if($acyear!='2024'){
		 $and ="AND `sm`.`admission_confirm` = 'Y'";
	 }else{
		 $and ="";
	 }
     $sql="SELECT sum(fd.amount) as amount FROM `fees_details` `fd` 
	 INNER JOIN `student_master` as `sm` ON `sm`.`stud_id`=`fd`.`student_id` AND `sm`.`enrollment_no`!='' 
	 JOIN `admission_details` as `ad` ON `fd`.`student_id`=`ad`.`student_id` and `fd`.`academic_year` = `ad`.`academic_year` 
	 WHERE `ad`.`academic_year` = '$acyear' AND `fd`.`type_id` = 2 AND `ad`.`cancelled_admission` = 'N'  and fd.is_deleted='N' AND `fd`.`chq_cancelled` = 'N' $and 
	 and STR_TO_DATE(fd.created_on,'%Y-%m-%d %H:%i:%s')>='$today_date_con' and  STR_TO_DATE(fd.created_on,'%Y-%m-%d %H:%i:%s')<'$today_date_after'";
	 //fees_date='$todays'//AND sm.`admission_cycle`!=''	 and fd.created_on like  '%$todays%'
        $query=$DB1->query($sql);
		//echo $sql;exit;
		$result=$query->result_array();
		return $result;
   
 }
  public function get_todays_fees_paid_dec($acyear,$today){
	
	 $role_id = $this->session->userdata('role_id');
	 $emp_id = $this->session->userdata("name");
     $DB1 = $this->load->database('umsdb', TRUE);
	 if($acyear!=2024){
		 $and ="AND `sm`.`admission_confirm` = 'Y'";
	 }else{
		 $and ="";
	 }
	 
	$year = date('Y', strtotime($today));
	$month = date('m', strtotime($today));
	$yr_m = $year.'-'.$month; 
	//$yr_m = date('Y-m');
	 
	//$todays=MONTH(fees_date) = MONTH(CURRENT_DATE());	
	/*if($today !=''){
		$sql="SELECT sum(fd.amount) as amount FROM `fees_details` `fd` 
	 INNER JOIN `student_master` as `sm` ON `sm`.`stud_id`=`fd`.`student_id` AND `sm`.`enrollment_no`!='' 
	 JOIN `admission_details` as `ad` ON `fd`.`student_id`=`ad`.`student_id` and `fd`.`academic_year` = `ad`.`academic_year` 
	 WHERE `ad`.`academic_year` = '$acyear' AND `fd`.`type_id` = 2 AND `ad`.`cancelled_admission` = 'N' and fd.is_deleted='N' AND `fd`.`chq_cancelled` = 'N' $and and MONTH(fd.created_on) =MONTH('$today') and YEAR(fd.created_on) = YEAR('$today')"; 
	 }else{*/
		
		//$today=date('Y-m-d');
		
		$sql="SELECT sum(fd.amount) as amount FROM `fees_details` `fd` 
	 INNER JOIN `student_master` as `sm` ON `sm`.`stud_id`=`fd`.`student_id` AND `sm`.`enrollment_no`!='' 
	 JOIN `admission_details` as `ad` ON `fd`.`student_id`=`ad`.`student_id` and `fd`.`academic_year` = `ad`.`academic_year` 
	 WHERE `ad`.`academic_year` = '$acyear' AND `fd`.`type_id` = 2 AND `ad`.`cancelled_admission` = 'N' and fd.is_deleted='N' AND `fd`.`chq_cancelled` = 'N' $and and DATE_FORMAT(fd.created_on, '%Y-%m') = '$yr_m'
  AND HOUR('$today') < 18";
	 //}	
     //MONTH(fees_date) =MONTH(CURRENT_DATE())//AND sm.`admission_cycle`!=''	 
        $query=$DB1->query($sql);
		//echo $sql;exit;
		$result=$query->result_array();
		return $result;
   
 }
	////////////////////////////////////////////////////////////////////////////////////

	/*
	* Cancel Admission Request Refund Module start,
	* Added BY:: Amit Dubey
	*/
	
	
	
	public function getStudentRefundRequestList($dataArr = array()){
	
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('student_request_refund.*,bank_master.bank_id,bank_master.bank_name'); 
		$DB1->from('student_request_refund');
		$DB1->join('bank_master', 'bank_master.bank_id = student_request_refund.student_bank_name'); 
		//
		if(isset($dataArr['academic_year']) && !empty($dataArr['academic_year'])){
			$DB1->where('student_request_refund.academic_year', $dataArr['academic_year']);
		}
		//
		if(isset($dataArr['request_status']) && !empty($dataArr['request_status'])){
			$DB1->where('student_request_refund.status', $dataArr['request_status']);
		}
		//
		if(isset($dataArr['request_month']) && !empty($dataArr['request_month'])){
			$DB1->where('MONTH(student_request_refund.created_on)', $dataArr['request_month']);
		}
		//
		$DB1->order_by('student_request_refund.id','desc');
		$query = $DB1->get();
		//echo $DB1->last_query();exit;
		$result = $query->result_array();
		return $result;	
	}
	
	
	
	public function getStudentRefundRequestExcelExport($dataArr = array()){
		 
		$this->db->select(
						'sandipun_ums.student_request_refund.*,
						sandipun_ums.student_master.enrollment_no,
						sandipun_ums.student_master.enrollment_no_new,
						sandipun_ums.student_master.first_name,
						sandipun_ums.student_master.mobile,
						sandipun_ums.student_master.admission_school,
						sandipun_ums.student_master.admission_stream,
						sandipun_ums.student_master.admission_confirm,
						sandipun_ums.student_master.gender,
						sandipun_ums.student_master.current_year,
						sandipun_ums.school_master.school_name,
						sandipun_ums.school_master.school_short_name,
						sandipun_ums.stream_master.stream_name,
						sandipun_ums.stream_master.stream_short_name,
						sandipun_ums.stream_master.course_id,
						sandipun_ums.course_master.course_name,
						sandipun_ums.course_master.course_short_name,
						sandipun_ums.bank_master.bank_name,
						sandipun_erp.sf_fees_refunds.amount,
						sandipun_erp.sf_fees_refunds.deduct_amount,
						'); 
		$this->db->from('sandipun_ums.student_request_refund');
		
		$this->db->join('sandipun_ums.student_master', 'sandipun_ums.student_master.stud_id = sandipun_ums.student_request_refund.student_id');
		
		$this->db->join('sandipun_ums.school_master', 'sandipun_ums.school_master.school_id = sandipun_ums.student_master.admission_school');
		
		$this->db->join('sandipun_ums.stream_master', 'sandipun_ums.stream_master.stream_id = sandipun_ums.student_master.admission_stream');
		
		$this->db->join('sandipun_ums.course_master', 'sandipun_ums.course_master.course_id = sandipun_ums.stream_master.course_id');
		
		$this->db->join('sandipun_ums.bank_master', 'sandipun_ums.bank_master.bank_id = sandipun_ums.student_request_refund.student_bank_name');
		
		$this->db->join('sandipun_erp.sf_fees_refunds', 'sandipun_erp.sf_fees_refunds.fees_id = sandipun_ums.student_request_refund.fees_refund_id', 'left');
		//
		if(isset($dataArr['academic_year']) && !empty($dataArr['academic_year'])){
			$this->db->where('sandipun_ums.student_master.academic_year', $dataArr['academic_year']);
		}
		//
		if(isset($dataArr['request_status']) && !empty($dataArr['request_status'])){
			$this->db->where('sandipun_ums.student_request_refund.status', $dataArr['request_status']);
		}
		//
		if(isset($dataArr['request_month']) && !empty($dataArr['request_month'])){
			$this->db->where('MONTH(sandipun_ums.student_request_refund.created_on)', $dataArr['request_month']);
		}
		//
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query->result_array();
		return $result;	
			
	}
	public function getStudentRefundRequestCount($dataArr = array()){
	
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->select('student_request_refund.*,bank_master.bank_id,bank_master.bank_name'); 
			$DB1->from('student_request_refund');
			$DB1->join('bank_master', 'bank_master.bank_id = student_request_refund.student_bank_name'); 
			//
			if(isset($dataArr['academic_year']) && !empty($dataArr['academic_year'])){
				$DB1->where('student_request_refund.academic_year', $dataArr['academic_year']);
			}
			//
			if(isset($dataArr['request_status']) && !empty($dataArr['request_status'])){
				$DB1->where('student_request_refund.status', $dataArr['request_status']);
			}
			//
			if(isset($dataArr['request_month']) && !empty($dataArr['request_month'])){
				$DB1->where('MONTH(student_request_refund.created_on)', $dataArr['request_month']);
			}
			
			if(isset($dataArr['enrollment_no']) && !empty($dataArr['enrollment_no'])){
				$DB1->where('student_request_refund.enrollment_no', $dataArr['enrollment_no']);
			}
			
		/* 	$DB1->where("NOT (student_request_refund.request_type = 'cancel_admission' 
                   AND student_request_refund.status IN ('pending','cancel'))");

			$DB1->where("NOT (student_request_refund.request_type = 'cancel_admission' 
                   AND student_request_refund.is_confirm = 0)"); */
			//
			 
			return (int)$DB1->count_all_results();	 
	}
	public function getOldTotalRefundAmt($dataArr = array()){
	
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('fees_id,student_id,sum(amount) as total_refunded_amt'); 
		$DB1->from('fees_refunds');
		$DB1->where('student_id', $dataArr['student_id']);
		$query = $DB1->get();
		//echo $DB1->last_query();exit;
		$result = $query->row_array();
		return $result;  
	}


}

?>