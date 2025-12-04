<?php
class Scholarship_concession_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
        ini_set('memory_limit', '-1');
        $DB1 = $this->load->database('umsdb', TRUE); 
    } 
	
	function migrate_attendance()
	{
		  $DB1 = $this->load->database('umsdb', TRUE);
		 $sql ="select emp_id from faculty_master where emp_id like '66%'";
		 $query=$DB1->query($sql);
	// echo $DB1->last_query();exit;
		$result=$query->result_array();
		foreach($result as $result1)
		{
			$new = $result1['emp_id'];
			$old = substr($result1['emp_id'], 2);
			echo $result1['emp_id'].">".$old."<br>";
			 $sql2 ="update punching_log set UserId='$new' where UserId='$old' ";
			// echo $sql2;
			$this->db->query($sql2);
		}
		
		
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


    function searchjlist_new($data){
		    $DB1 = $this->load->database('umsdb', TRUE);
		    /*$stid=array('190101221944','190101221945','190101221946','190101221947','190102201001','190102201002','190102201003','190102201004','190102201005','190102201006','190102201007');*/
			$stid=array('200301007','20SUN0302','20SUN0089','20SUN0289','20SUN0596','20SUN0108','20SUN0762','20SUN0482','20SUN0413','20SUN0336','20SUN0703','20SUN0597','20SUN0272','20SUN0015','20SUN0070','20SUN0628','20SUN0187','20SUN0530','20SUN0616','20SUN0121','20SUN0547','20SUN0612','20SUN0664','20SUN0525','20SUN0611','20SUN0182','20SUN0167','20SUN0155','20SUN0731','20SUN0729','20SUN0158','20SUN0378','20SUN0085','20SUN0700','20SUN0648','20SUN0197','20SUN0603','20SUN0661','20SUN0323','20SUN0606','20SUN0614','20SUN0602','20SUN0018','20SUN0727','20SUN0739','20SUN0367','20SUN0653','20SUN0601','20SUN0704','20SUN0725','20SUN0726','20SUN0697','20SUN0744','20SUN0743','20SUN0409');
		    //die;
		   
		$DB1->select("sm.*,stm.stream_name,cm.course_name");
		$DB1->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left'); 
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		$DB1->where("sm.cancelled_admission",'N');
		$DB1->where("sm.admission_session",'2020');	
		$DB1->where("sm.academic_year",'2020');
		$DB1->where("sm.is_detained",'N');
		//$DB1->where("sm.admission_cycle");
		//$DB1->where("length(sm.enrollment_no)",'9');
		$DB1->where_in("sm.enrollment_no_new",$stid);
		//$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
		/*  echo $DB1->last_query();
		exit(0);*/
		$result=$query->result_array();
		//echo $this->db->last_query();
		
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
    	function searchjlist($data){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,cm.course_name");
		$DB1->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left'); 
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
			$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');

			 	$DB1->where("sm.cancelled_admission",'N');  	    
	
	
		$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
	//	  echo $DB1->last_query();
	//	exit(0);
		$result=$query->result_array();
		//echo $this->db->last_query();
		
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
    
    
    public function change_engine()
    {
   // error_reporting(E_ALL);
//ini_set('display_errors', 1);
    $DB1 = $this->load->database('sujadmin', TRUE);
    
        $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES
    WHERE TABLE_SCHEMA = 'sandipun_ums_sijoul' 
    AND ENGINE = 'MyISAM'";

$rs = $DB1->query($sql);
// $pnr_details =  $rs->result_array();
 $arr = $rs->result_array();
 
foreach($arr as $arr1)
{
    $tbl = $arr1['TABLE_NAME'];
    $sql2 = "ALTER TABLE `$tbl` ENGINE=INNODB";
    echo $sql2;
   $DB1->query($sql2);
} 
        
        
        
    }
    public function calculate_attempts($studentid,$subjectid,$examid)
    {
      
      $DB1 = $this->load->database('umsdb', TRUE);
    	
		$DB1->select("count(*) as cnt");
		$DB1->from('exam_student_subject');
			$DB1->where("student_id",$studentid); 
	$DB1->where("subject_id",$subjectid); 

			 $DB1->where("exam_id <",$examid); 

		$query3=$DB1->get(); 
      	$result=$query3->row_array();
      return $result['cnt'];
      
      
        
    }
    
    public function last_receipt_no()
{
        $DB1 = $this->load->database('umsdb', TRUE);        
    $DB1->select('college_receiptno1');
$DB1->from('fees_details');
$DB1->order_by('college_receiptno1','desc');
$DB1->limit(1);
$query =$DB1->get();
//echo $this->db->last_query();
$result = $query->row_array();
return $result['college_receiptno1'];
  
}

    
    function generate_receipt_no()
{
      $DB1 = $this->load->database('umsdb', TRUE);     
    $receip = $this->last_receipt_no();
    $receip++;
    $prdet['college_receiptno1']= $receip;

  $DB1->where('fees_id',$_POST['feeid']);

		 $DB1->update('fees_details',$prdet);   
		 echo $DB1->last_query();
    echo "Y";
    
}


public function insert_sf_student_data()
{
    
     $this->db->select('*');
  $this->db->from('temp_sf_student_master');

$query = $this->db->get();
//echo $this->db->last_query();
$result = $query->result_array();
  foreach($result as $results)
  {
   $this->db->select('*');
  $this->db->from('sf_student_master');
  $this->db->where('enrollment_no',$results['enrollment_no']);
$query2 = $this->db->get();
//echo $this->db->last_query();
$result2 = $query2->row_array();  

   /* $upd['organization'] = $results['organization'];   
     $upd['instute_name'] = $results['instute_name'];   
     $upd['enrollment_no'] = $results['enrollment_no'];       
    $upd['first_name'] = $results['first_name'];   
    $upd['middle_name'] = $results['middle_name'];  
    $upd['last_name'] = $results['last_name'];*/
    if(trim($results['gender'])=="Male"){
      $gen ="M";  
    }
        if(trim($results['gender'])=="Female"){
          $gen ="F";  
    }
    $upd['gender'] = $gen;
   /* $upd['Address'] = $results['Address'];
    $upd['taluka'] = $results['taluka'];
    $upd['district'] = $results['district'];
    $upd['state'] = $results['state'];
    $upd['pincode'] = $results['pincode'];
    $upd['mobile'] = $results['mobile'];
    $upd['email'] = $results['email'];
    $upd['parent_mobile1'] = $results['parent_mobile1'];
    $upd['course'] = $results['course'];
    $upd['stream'] = $results['branch'];
      $upd['admission_session'] = $results['admission_session'];
    $upd['academic_year'] ="2018"; //$results['academic_year'];
     $upd['campus_name'] ="NASHIK";
        $upd['current_year'] = $results['current_year'];
        */
        
      if($result2['student_id']!='')
      {

    //$upd[''] = $results['branch'];
      $this->db->where("enrollment_no",$result2['enrollment_no']);
     $this->db->update("sf_student_master",$upd);
     
      }
      else
      {
       $this->db->insert("sf_student_master",$upd);
      }
      
  }
  
    
}

    
    public function update_exam_student_subject($examid)
    {
  
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
    	    $DB1 = $this->load->database('umsdb', TRUE);
    	//    $DB1->distinct();
		$DB1->select("student_id,enrollment_no,exam_id,exam_month,exam_year,school_id,stream_id,semester,subject_id,subject_code,final_grade,result_grade");
		$DB1->from('exam_result_data');
		$DB1->where("exam_id",$examid);
		$streamids = array('116', '119','170');
		$DB1->where_not_in('stream_id', $streamids);
		
		$query=$DB1->get();
	//echo $DB1->last_query();exit;

		$result=$query->result_array();

		foreach($result as $rdata)
		{
		   
		   $attemp =  $this->calculate_attempts($rdata['student_id'],$rdata['subject_id'],$rdata['exam_id']);
		   if($rdata['final_grade']=="WH"){
			  if($rdata['result_grade']=="U")
			  {
				  $passed ='N'; 
			  }
			  else
			  {
				$passed ='Y'; 	      
			  }
		    
		   }else{
			   if($rdata['final_grade']=="U")
			  {
				  $passed ='N'; 
			  }
			  else
			  {
				$passed ='Y'; 	      
			  }
		   }

    	   $dat['student_id']=$rdata['student_id'];
		   $dat['enrollment_no']=$rdata['enrollment_no'];
		   	  $dat['stream_id']=$rdata['stream_id'];
		   $dat['subject_id']=$rdata['subject_id'];
		  $dat['subject_code']=$rdata['subject_code'];  
		    $dat['semester']=$rdata['semester'];
		     $dat['grade']=$rdata['final_grade'];
		    $dat['passed']=$passed;
		    $dat['exam_id']=$rdata['exam_id'];
		  
	 $dat['no_of_attempt']=$attemp + 1;



$DB1->select("student_id");
		$DB1->from('exam_student_subject');
		//	 $DB1->where("exam_id",$rdata['exam_id']); 
	$DB1->where("student_id",$rdata['student_id']); 
	$DB1->where("subject_id",$rdata['subject_id']); 
//	 $DB1->where("exam_id>=",$rdata['exam_id']); 
		$query2=$DB1->get();

		$result2=$query2->row_array();	 
if($result2['student_id']=='')
{
    $DB1->insert('exam_student_subject',$dat);
}
else
{
   // $DB1->where('exam_id',$rdata['exam_id']);
    $DB1->where('student_id',$rdata['student_id']);
    $DB1->where('subject_id',$rdata['subject_id']);
    $DB1->update('exam_student_subject',$dat);   
}
    	
	/*	$DB1->select("student_id");
		$DB1->from('exam_student_subject');
			 $DB1->where("exam_id",$examid); 
	$DB1->where("student_id",$examid); 
	$DB1->where("stream_id",$examid); 
	$DB1->where("subject_id",$examid); 
	$DB1->where("semester",$examid); 
		$query2=$DB1->get();


		$result=$query->result_array();	    

		    */
		    	    
		}
           
    }
    
    
public function exam_result_data($examid,$semid)
{
      //   error_reporting(E_ALL);
//ini_set('display_errors', 1);
    	    $DB1 = $this->load->database('umsdb', TRUE);
    	//    $DB1->distinct();
		$DB1->select("student_id,enrollment_no,exam_id,exam_month,exam_year,school_id,stream_id,semester");
		$DB1->from('exam_result_data');
			 $DB1->where("exam_id",$examid);  	 
			 $DB1->where("stream_id",$semid);  		 
			 //	 $DB1->where("enrollment_no",'170109051002');  	 
		 $DB1->group_by("exam_id,student_id,semester");
		$query=$DB1->get();
//echo $DB1->last_query();
//exit();
		$result=$query->result_array();
		
//	$result = array_unique($resultj);
//	echo count($result);
//	var_dump($result);
//	exit();

		foreach($result as $rdata)
		{
		    
		    
		    $dat['student_id']=$rdata['student_id'];
		   $dat['enrollment_no']=$rdata['enrollment_no'];
		    $dat['exam_id']=$rdata['exam_id'];
		   $dat['exam_month']=$rdata['exam_month'];
		    $dat['exam_year']=$rdata['exam_year'];
	 $dat['school_id']=$rdata['school_id'];
	  $dat['stream_id']=$rdata['stream_id'];
	   $dat['semester']=$rdata['semester'];
	      $DB1->insert('exam_result_master',$dat);
		    
		    
		    
		    
		    
		    
		}
		
	
    
}

public function calculate_cgpa($examid, $stream_id)
{
   //$names = array('4105','3239','2585','4684','1219','626','2310','2025','2392','5237','5238','4271','4319','2541','2924','8','9','11','12','16','25','42','51','54','62','66','1640','350','428','439','1016','1195','1309','382','1635','1659','2020','2707','2729','3802','1000','87','1168','1937','2680','1705','4697','5000','5132');
//$DB1->where_in('ers.enrollment_no', $names);

    	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("ers.*,sgc.grade_rule");
		$DB1->from('exam_result_master as ers');
		$DB1->join('student_master as sm','ers.student_id = sm.stud_id','left'); 
	$DB1->join('stream_grade_criteria as sgc','sm.admission_stream = sgc.stream_id','left');
	$DB1->where("ers.exam_id",$examid);
	if($stream_id !=""){
		$DB1->where("ers.stream_id",$stream_id);
	}	
	$streamids = array('116', '119','170');
	$DB1->where_not_in('ers.stream_id', $streamids);
	//$school_arr = array('1014');
	//$DB1->where_in('ers.school_id', $school_arr);
//$DB1->where_in('ers.student_id', $names);
	 	//$DB1->where("ers.st",$examid); 
		$query=$DB1->get();
		
			$result=$query->result_array();	
//echo $DB1->last_query();
//exit();
	foreach($result as $mydata)
	{
	    //$rule =;
/*	$DB1->select("erd.enrollment_no,erd.student_id,erd.exam_id,erd.final_grade,erd.subject_id,erd.subject_code,sm.credits,gpd.grade_point,sum(sm.credits) as total_credits,
	sum(gpd.grade_point) as total_grade,sum(sm.credits*gpd.grade_point) as sumcredit,sum(case when gpd.grade_point=0 then 0 else sm.credits end ) as credit_earned,
	");
		$DB1->from('exam_result_data as erd');
		$DB1->join('subject_master as sm','erd.subject_id = sm.sub_id','left'); 
	$DB1->join('grade_policy_details as gpd','erd.final_grade = gpd.grade_letter','left');
	$DB1->where("erd.student_id",$mydata['student_id']); 
	$DB1->where('gpd.rule', $mydata['grade_rule']); 


	$DB1->where("erd.exam_id<=",$examid); 
		$query1=$DB1->get();

//echo $DB1->last_query();
//exit();
			$result1=$query1->row_array();		  
*/

//$dupdate['credits_registered']=$result1['total_credits'];
//	  $dupdate['credits_earned']=$result1['credit_earned'];
//	 $dupdate['grade_points_earned']=$result1['total_grade'];

	 



	$DB1->select("erd.enrollment_no,erd.student_id,erd.exam_id,erd.final_grade,erd.subject_id,erd.subject_code,sm.credits,gpd.grade_point,sum(sm.credits) as total_credits,
	sum(gpd.grade_point) as total_grade,sum(sm.credits*gpd.grade_point) as sumcredit,sum(case when gpd.grade_point=0 then 0 else sm.credits end ) as credit_earned,
	");
		$DB1->from('exam_result_data as erd');
		$DB1->join('subject_master as sm','erd.subject_id = sm.sub_id','left'); 
	$DB1->join('grade_policy_details as gpd','erd.final_grade = gpd.grade_letter','left');
	//$DB1->join('grade_policy_details as gpd','erd.result_grade = gpd.grade_letter','left');
	$DB1->where("erd.student_id",$mydata['student_id']); 
	$DB1->where('gpd.rule', $mydata['grade_rule']); 
	$DB1->where("erd.exam_id<=",$examid); 
	
			$DB1->where("erd.final_grade!=",'U');
		$query2=$DB1->get();

//echo $DB1->last_query();
//exit();

	$result2=$query2->row_array();

	

	if($result2['credit_earned']==0)	
{
    $tcgpa=0;
}
else
{
 $tcgpa = bcdiv($result2['sumcredit'],$result2['credit_earned'], 4); 	
}	  
	
//echo $tcgpa;exit;
	$dupdate['cumulative_credits']=$result2['sumcredit'];
 $dupdate['cumulative_gpa']=$tcgpa;


	  
       // $DB1->where('student_id', $result1['student_id']);
       $DB1->where('student_id', $result2['student_id']);
          $DB1->where('exam_id', $examid);
$DB1->update('exam_result_master',$dupdate);   
//echo $DB1->last_query();
//exit();

	}
		//$DB1->join('student_master as sm','um.username = sm.enrollment_no','left');
    
    
}


public function calculate_gpa($examid,$semester, $stream_id='')
{
     //$names = array('4105','3239','2585','4684','1219','626','2310','2025','2392','5237','5238','4271','4319','2541','2924','8','9','11','12','16','25','42','51','54','62','66','1640','350','428','439','1016','1195','1309','382','1635','1659','2020','2707','2729','3802','1000','87','1168','1937','2680','1705','4697','5000','5132');
//$DB1->where_in('ers.enrollment_no', $names);
 //$names = array('170101092107',170101082038);
   $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("ers.*,sgc.grade_rule");
		$DB1->from('exam_result_master as ers');
		$DB1->join('student_master as sm','ers.student_id = sm.stud_id','left'); 
	$DB1->join('stream_grade_criteria as sgc','sm.admission_stream = sgc.stream_id','left');
	$DB1->where("ers.exam_id",$examid); 
	$streamids = array('116', '119','170');
	$DB1->where_not_in('ers.stream_id', $streamids);
	//$school_arr = array('1014');
	//$DB1->where_in('ers.school_id', $school_arr);
	//$DB1->where_in('ers.student_id', $names);
	if($stream_id !=""){
		$DB1->where("ers.stream_id",$stream_id);
	}
	if($semester !=""){
		$DB1->where("ers.semester",$semester);
	}
	 	 
		$query=$DB1->get();
		
			$result=$query->result_array();	

	foreach($result as $mydata)
	{
	    //$rule =;
	$DB1->select("erd.enrollment_no,erd.student_id,erd.exam_id,erd.final_grade,erd.subject_id,erd.subject_code,sm.credits,gpd.grade_point,sum(sm.credits) as total_credits,
	sum(gpd.grade_point) as total_grade,sum(sm.credits*gpd.grade_point) as sumcredit,sum(case when gpd.grade_point=0 then 0 else sm.credits end ) as credit_earned,
	");
		$DB1->from('exam_result_data as erd');
		$DB1->join('subject_master as sm','erd.subject_id = sm.sub_id','left'); 
	$DB1->join('grade_policy_details as gpd','erd.final_grade = gpd.grade_letter','left');
	//$DB1->join('grade_policy_details as gpd','erd.result_grade = gpd.grade_letter','left');
	$DB1->where("erd.student_id",$mydata['student_id']); 
	$DB1->where('gpd.rule', $mydata['grade_rule']); 
	if($semester !=""){
		$DB1->where("erd.semester",$semester);
	}

	if($stream_id !=""){
		$DB1->where("erd.stream_id",$stream_id);
	}
	$DB1->where("erd.exam_id",$examid); 		

			//$DB1->where("erd.result_grade!=",'U');
		$query1=$DB1->get();

			$result1=$query1->row_array();		  
if($result1['credit_earned']==0)	
{
    $cgpa=0;
}
else
{
 $cgpa = bcdiv($result1['sumcredit'],$result1['credit_earned'], 4); 	
}

$dupdate['credits_registered']=$result1['total_credits'];
	  $dupdate['credits_earned']=$result1['credit_earned'];
	 $dupdate['grade_points_earned']=$result1['total_grade'];
	 $dupdate['grade_points_avg']=$cgpa;

        $DB1->where('student_id', $result1['student_id']);
          $DB1->where('exam_id', $examid);
		  if($semester !=""){
				$DB1->where("semester",$semester);
			}
$DB1->update('exam_result_master',$dupdate);   

	}
		//$DB1->join('student_master as sm','um.username = sm.enrollment_no','left');
    
    
}







function calculate_sgpa($examid,$semester,$stream_id)
{
  
 //$names = array('4105','3239','2585','4684','1219','626','2310','2025','2392','5237','5238','4271','4319','2541','2924','8','9','11','12','16','25','42','51','54','62','66','1640','350','428','439','1016','1195','1309','382','1635','1659','2020','2707','2729','3802','1000','87','1168','1937','2680','1705','4697','5000','5132');
//$DB1->where_in('ers.enrollment_no', $names);
    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("ers.*,sgc.grade_rule");
		$DB1->from('exam_result_master as ers');
		$DB1->join('student_master as sm','ers.student_id = sm.stud_id','left'); 
	$DB1->join('stream_grade_criteria as sgc','sm.admission_stream = sgc.stream_id','left');
	$DB1->where("ers.exam_id",$examid);  
	if($semester !=''){
		$DB1->where("ers.semester",$semester); 
	}
	if($stream_id !=""){
		$DB1->where("ers.stream_id",$stream_id);
	}
	$streamids = array('116', '119','170');
	$DB1->where_not_in('ers.stream_id', $streamids);
	//$school_arr = array('1014');//'1002', '1004','1009','1010' 
	//$DB1->where_in('ers.school_id', $school_arr);
			//$DB1->where("ers.semester!=",'U');
	//$DB1->where_in('ers.student_id', $names);
		$query=$DB1->get();
	//echo $DB1->last_query();exit();
			$result=$query->result_array();	
  
  
  	foreach($result as $mydata)
	{
	    //$rule =;
	$DB1->select("erd.enrollment_no,erd.student_id,erd.exam_id,erd.final_grade,erd.subject_id,erd.subject_code,sm.credits,gpd.grade_point,sum(sm.credits) as total_credits,
	sum(gpd.grade_point) as total_grade,sum(sm.credits*gpd.grade_point) as sumcredit,sum(case when gpd.grade_point=0 then 0 else sm.credits end ) as credit_earned,
	");
		$DB1->from('exam_result_data as erd');
		$DB1->join('subject_master as sm','erd.subject_id = sm.sub_id','left'); 
	$DB1->join('grade_policy_details as gpd','erd.final_grade = gpd.grade_letter','left');
	//$DB1->join('grade_policy_details as gpd','erd.result_grade = gpd.grade_letter','left');
	$DB1->where("erd.student_id",$mydata['student_id']); 
	$DB1->where('gpd.rule', $mydata['grade_rule']); 
	if($semester !=''){
		$DB1->where("erd.semester",$semester); 
	} 	
	 	$DB1->where("erd.exam_id <=",$examid); 
	 	
			$DB1->where("erd.final_grade!=",'U');
		$query1=$DB1->get();
//echo $DB1->last_query();
	$result1=$query1->row_array();
	  
	
	if($result1['credit_earned']==0)	
{
    $tcgpa=0;
}
else
{
 $tcgpa1 = bcdiv($result1['sumcredit'],$result1['credit_earned'],2); 	
 $tcgpa = number_format((float)$tcgpa1, 2, '.', '');  
}	  
	  


$dataupdate['sgpa']=$tcgpa;

        $DB1->where('student_id', $result1['student_id']);
          $DB1->where('exam_id', $examid);
		  if($semester !=''){
				$DB1->where("semester",$semester); 
			} 	
$DB1->update('exam_result_master',$dataupdate);   		  
		
//echo $DB1->last_query();

}
  
  
  
  
    
}

	
	public function send_stlogin()
	{
	    
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("um.*,sm.mobile");
		$DB1->from('user_master as um');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left'); 
	//	$DB1->join('user_master as um','mn.mobile = um.username','left');
		$DB1->join('student_master as sm','um.username = sm.enrollment_no','left');

			 $DB1->where("um.roles_id",'4');  	    
		 $DB1->where("um.status",'Y');  	   
	
	//	$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
//echo $DB1->last_query();
//	exit(0);
		$result=$query->result_array();	    
	foreach( $result as $results)
	{
	    
	    $mobile= $results['mobile'];
$username = $results['username'];
$password = $results['password'];
$sms_message =urlencode("Dear Student
Your login details.
Please logon to
sandipuniversity.edu.in/erp-login.php
Username $username
Password $password
Thank you
Sandip University
");


          $ch = curl_init();
   $sms=$sms_message;
   echo $sms."<br>";

 $query="?username=u4282&msg_token=j8eAyq&sender_id=SANDIP&message=$sms&mobile=$mobile";

    curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_URL,'http://49.50.67.32/smsapi/httpapi.jsp' . $query); 
    curl_setopt($ch, CURLOPT_URL,'http://bulksms.omegatelesolutions.com/api/send_transactional_sms.php' . $query); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
      $res = trim(curl_exec($ch));     
curl_close($ch);	    
	    
	}
		
		
	    
	}

 












function create_student_login()
{
    $DB1 = $this->load->database('umsdb', TRUE);
    $dat  = $this->searchjlist_new($var='');
 //exit;  
//print_r($dat);exit();
  foreach($dat as $sdata)
    {
        
        $rcnt = $this->check_if_exists('user_master','username',$sdata['enrollment_no_new'],'roles_id','9');
        if($rcnt<1)
        {
        $par['username'] = $sdata['enrollment_no'];    
        $par['password'] = rand(4999,999999);
         $par['inserted_by'] = $_SESSION['uid'];
          $par['inserted_datetime'] = date('Y-m-d h:i:s');
           $par['status'] ='N';
            $par['roles_id'] = 9;
      $DB1->insert('user_master',$par);
        }

      $rcnt3 = $this->check_if_exists('user_master','username',$sdata['enrollment_no_new'],'roles_id','4');
        if($rcnt3<1)
        {
        $par['username'] = $sdata['enrollment_no'];    
        $par['password'] = rand(4999,999999);
         $par['inserted_by'] = $_SESSION['uid'];
          $par['inserted_datetime'] = date('Y-m-d h:i:s');
           $par['status'] ='N';
            $par['roles_id'] = 4;
      $DB1->insert('user_master',$par);
        }
        
        
    }
    
    
}
/*
function update_admi_details()
{
   	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('admission_detailstemp');
			$DB1->where("academic_year",'2016');
			//	$DB1->where("sm.enrollment_no",$enroll);
		$query=$DB1->get();
//		echo $DB1->last_query();
	//	exit(0);
		$result=$query->result_array();
		
		foreach($result as $results)
		{
		$sstatus['applicable_fee']=$results['applicable_fee'];
        $DB1->where('adm_id', $results['adm_id']);
//	$DB1->update('admission_details',$sstatus);    
	//	echo $DB1->last_query();
	//	exit(0);	    
		    
		}
	return $result;    
    
    
}
*/







// function update_taluka_states()
// {
//     $DB1 = $this->load->database('umsdb', TRUE);
//     $DB1->select("*");
// 		$DB1->from('sandipun_ic_erp.states');	

// 			 $DB1->where("id >",'67'); 
// $DB1->order_by('id','ASC');
// 		$query3=$DB1->get(); 
//       	$result=$query3->result_array();
//       	//print_r($result);
// foreach ($result as $key => $value) {
// 	echo $value['name'];
// 	 $DB1->select("*");
// 		$DB1->from('sandipun_ums.demo_states');
// 			 $DB1->where("state_name",$value['name']); 
// $query4=$DB1->get();
// $results=$query4->row_array();
// echo "</br>";
// echo $results['state_id'];
// echo "</br>";

// $DB1->select("*");
// 		$DB1->from('sandipun_ic_erp.cities');
// 			 $DB1->where("state_id",$value['id']); 
// $query4=$DB1->get();
// $resulticc=$query4->result_array();
// foreach ($resulticc as $key1 => $value1) {
// 	//echo $value1['name'];
// 	$par['state_id'] =$results['state_id'];
//             $par['taluka_name'] = $value1['name'];
//       $DB1->insert('sandipun_ums.taluka_master',$par);
//      // $DB1->last_query();
// }
 
// }


//       	exit;
    
    
// }





function testd()
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,cm.course_name,ad.actual_fee,ad.applicable_fee,ac.canc_date");
		$DB1->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
			$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
			$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	
		    $DB1->join('admission_cancellations as ac','sm.stud_id = ac.stud_id','left');	
			$DB1->where("sm.cancelled_admission",'Y');	    
		
		//	$DB1->where("sm.admission_year", $year);	   	    
	
		$DB1->order_by("sm.stud_id", "asc");
		$query=$DB1->get();
	echo $DB1->last_query();
		 die();   
	//	echo $DB1->last_query();
		//die();  
		$result=$query->result_array();
		 
	//	$result=$query->result_array();
		return $result;
}




function result_master_update()
{
     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('exam_result_master');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
		$DB1->where("exam_id",'8');	    
		
		//	$DB1->where("sm.admission_year", $year);	   	    
		$query=$DB1->get();
		$result=$query->result_array();
		 foreach($result as $result1)
		 {
		$DB1->select("*");
		$DB1->from('student_master');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
		$DB1->where("stud_id",$result1['student_id']);	    
		
		//	$DB1->where("sm.admission_year", $year);	   	    
		$query=$DB1->get();
		$result2=$query->row_array();	  
		  
		  $upd['enrollment_no']=$result2['enrollment_no'];
		  $DB1->where("student_id",$result1['student_id']);
		  $DB1->update("exam_result_master",$upd);
		  
		  
		     
		 }
		 
		 
	//	$result=$query->result_array();
		return $result;
}



function generate_bonafied()
{

    	$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.first_name,sm.middle_name,sm.last_name,sm.gender,sm.form_number,sm.academic_year,
		sm.admission_session,ad.academic_year as admission_year,sm.current_semester,vsd.school_name,
		vsd.course_name,vsd.stream_name");
		$DB1->from('student_master as sm');
	$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
		//	$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
	$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	
			$DB1->where("sm.cancelled_admission",'N');
				$DB1->where("sm.enrollment_no",$_POST['prn']);
    // $DB1->order_by("sm.stud_id", "asc");


		$query=$DB1->get();
//echo $DB1->last_query(); 
//exit();
		$result=$query->row_array();
		
 if($result['first_name']=='')
    {
      $this->session->set_flashdata('message1','Please enter valid PRN number  ..');
	      redirect('ums_admission/generate_bonafied');    
     //   return 0;
    }
    
    $ref = $this->list_bonafied($cartid='',$_POST['reg']);
    
     if($ref[0]['bc_id']!='')
    {
      $this->session->set_flashdata('message1','Reference Number is already exist.');
	      redirect('ums_admission/add_bonafied');    
     //   return 0;
    }
    $bdata['cert_date']=$_POST['idate'] ;
        $bdata['purpose']=$_POST['purpose'] ;
         $bdata['enrollment_no']= $_POST['prn'];
         $bdata['stud_id']= $_POST['stud_id'];
      $bdata['cert_reg']= $_POST['reg'];  
      	$bdata['added_on']= date('Y-m-d h:i:s');
		$bdata['added_by']= $_SESSION['uid'];
     $DB1->insert('bonafied_certificates',$bdata);
		return $result;
		
    	    
}



function all_academic_session()
{
   // ini_set('display_errors', 1);
  	$DB1 = $this->load->database('umsdb', TRUE);
  	 	$DB1->distinct("academic_year");
 	$DB1->select("academic_year");
    $DB1->from("academic_session");
    //$DB1->where("currently_active","Y");
    $query = $DB1->get();
    $result = $query->result_array();
    return $result;
    
}


function active_academic_session()
{
 	$DB1 = $this->load->database('umsdb', TRUE);
 	$DB1->select("academic_year");
    $DB1->from("academic_session");
    $DB1->where("currently_active","Y");
    $query = $DB1->get();
    $result = $query->row_array();
    return $result['academic_year'];
}


function generate_transfer_cert()
{

    	$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.first_name,sm.middle_name,sm.last_name,sm.gender,sm.form_number,sm.academic_year,ad.academic_year as admission_year,sm.current_semester,vsd.school_name,vsd.course_name,vsd.stream_name");
		$DB1->from('student_master as sm');
	$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
		//	$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
	$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	
	//		$DB1->where("sm.cancelled_admission",'N');
				$DB1->where("sm.enrollment_no",$_POST['prn']);
    // $DB1->order_by("sm.stud_id", "asc");


		$query=$DB1->get();
//echo $this->db->
		$result=$query->row_array();
 if($result['first_name']=='')
    {
      $this->session->set_flashdata('message1','Please enter valid PRN number  ..');
	      redirect('ums_admission/add_transfer_cert');    
     //   return 0;
    }
    
    $ref = $this->transfer_certificate($cartid='',$_POST['reg']);
    
     if($ref[0]['bc_id']!='')
    {
      $this->session->set_flashdata('message1','Registration Number is already exist.');
	      redirect('ums_admission/add_transfer_cert');    
     //   return 0;
    }
  
         $bdata['enrollment_no']= $_POST['prn'];
         $bdata['stud_id']= $_POST['stud_id'];
           $bdata['leaving_date']=$_POST['ldate'] ;
               $bdata['cert_date']=$_POST['idate'] ;
          $bdata['cert_reg']= $_POST['reg'];  
            $bdata['reason']=$_POST['reason'] ;  
        $bdata['remark']=$_POST['remark'] ;
      
      $bdata['progress']=$_POST['progress'] ; 
        $bdata['conduct']=$_POST['conduct'] ; 
    $bdata['academic_year']=$this->active_academic_session();
      	$bdata['added_on']= date('Y-m-d h:i:s');
		$bdata['added_by']= $_SESSION['uid'];
     $DB1->insert('transfer_certificates',$bdata);
		return $result;
		
    	    
}





function generate_migration_cert($var)
{
	//print_r($var);

    	$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.first_name,sm.middle_name,sm.last_name,sm.gender,sm.form_number,sm.academic_year,ad.academic_year as admission_year,sm.current_semester,vsd.school_name,vsd.course_name,vsd.stream_name");
		$DB1->from('student_master as sm');
	$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
		//	$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
	$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	
			//$DB1->where("sm.cancelled_admission",'N');
				$DB1->where("sm.enrollment_no",$var['prn']);
    // $DB1->order_by("sm.stud_id", "asc");



		$query=$DB1->get();
//echo $DB1->last_query(); exit();
		$result=$query->row_array();
 if($result['first_name']=='')
    {
      $this->session->set_flashdata('message1','Please enter valid PRN number  ..');
	      redirect('ums_admission/generate_migration_cert');    
     //   return 0;
    }
    
    $ref = $this->migration_certificate($cartid='',$var['cnum']);
    
     if($ref[0]['bc_id']!='')
    {
      $this->session->set_flashdata('message1','Case Number is already exist.');
	      redirect('ums_admission/add_migration_cert');    
     //   return 0;
    }
  
         $bdata['enrollment_no']= $var['prn'];
         $bdata['stud_id']= $var['stud_id'];
        
               $bdata['cert_date']=$var['idate'] ;
        //  $bdata['case_no']= $_POST['cnum'];  
            $bdata['tc_no']=$var['reg'] ;  
       // $bdata['note']=$_POST['note'] ;
 $bdata['academic_year']=$this->active_academic_session();
    
      	$bdata['added_on']= date('Y-m-d h:i:s');
		$bdata['added_by']= $_SESSION['uid'];
     $DB1->insert('migration_certificates',$bdata);
		return $result;
		
    	    
}




















function regenerate_bonafied($enroll)
{
 
    	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.first_name,sm.enrollment_no,sm.middle_name,sm.last_name,sm.gender,sm.form_number,sm.academic_year,sm.admission_session,ad.academic_year as admission_year,sm.current_semester,vsd.school_name,vsd.course_name,vsd.stream_name");
		$DB1->from('student_master as sm');
	$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
		//	$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
	$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	
			$DB1->where("sm.cancelled_admission",'N');
				$DB1->where("sm.enrollment_no",$enroll);
		$query=$DB1->get();
		$result=$query->row_array();
	return $result;
    	    
   
}



function regenerate_transfer_cert($enroll)
{
 
    	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.first_name,sm.middle_name,sm.last_name,sm.gender,sm.form_number,sm.academic_year,sm.mother_name,sm.general_reg_no,sm.category,sm.sub_caste,sm.nationality,sm.birth_place,sm.religion,sm.dob,sm.last_institute,sm.admission_date,sm.current_year,sm.current_semester,sm.admission_session,ad.academic_year as admission_year,sm.current_semester,vsd.school_name,vsd.course_name,vsd.stream_name");
		$DB1->from('student_master as sm');
	$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
		//	$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
	$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	
		//	$DB1->where("sm.cancelled_admission",'N');
				$DB1->where("sm.enrollment_no",$enroll);
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		$result=$query->row_array();
		
	return $result;
    	    
   
}

function regenerate_migration_cert($enroll)
{
 
    	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.first_name,sm.middle_name,sm.last_name,sm.gender,sm.form_number,sm.academic_year,sm.mother_name,sm.general_reg_no,sm.category,sm.sub_caste,sm.nationality,sm.birth_place,sm.religion,sm.dob,sm.last_institute,sm.admission_date,sm.current_year,sm.current_semester,sm.admission_session,ad.academic_year as admission_year,sm.current_semester,vsd.school_name,vsd.course_name,vsd.stream_name");
		$DB1->from('student_master as sm');
	$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
		//	$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
	$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	
			//$DB1->where("sm.cancelled_admission",'N');
				$DB1->where("sm.enrollment_no",$enroll);
		$query=$DB1->get();
				//echo $DB1->last_query();exit;
		$result=$query->row_array();
	return $result;
    	    
   
}





function migration_certificate($cartid='',$refid='')
{
 	$DB1 = $this->load->database('umsdb', TRUE);
 			$DB1->select("tc.*,s.first_name,s.middle_name,s.last_name");
		$DB1->from('migration_certificates tc');
	$DB1->join('student_master as s','s.enrollment_no = tc.enrollment_no','left');
   $DB1->order_by('tc.mgc_id', 'desc');
	if($refid!='')
	{
	$DB1->where("tc.case_no", $refid);    
	}
		if($cartid!='')
	{
	$DB1->where("tc.mgc_id", $cartid);    
	}
		if($_POST['acyear']!='')
	{
	$DB1->where("tc.academic_year",$_POST['acyear']);    	    
	}
		$query=$DB1->get();
		$result=$query->result_array();
		return $result;
 	
}











function transfer_certificate($cartid='',$refid='')
{
 	$DB1 = $this->load->database('umsdb', TRUE);
 			$DB1->select("tc.*,s.first_name,s.middle_name,s.last_name");
		$DB1->from('transfer_certificates tc');
	$DB1->join('student_master as s','s.enrollment_no = tc.enrollment_no','left');
   $DB1->order_by('tc.tc_id', 'desc');
	if($refid!='')
	{
	$DB1->where("tc.cert_reg", $refid);    
	}
		if($cartid!='')
	{
	$DB1->where("tc.tc_id", $cartid);    
	}
	if($_POST['acyear']!='')
	{
	$DB1->where("tc.academic_year",$_POST['acyear']);    	    
	}
		$query=$DB1->get();
		$result=$query->result_array();
		
		//echo  $DB1->last_query();exit;
		return $result;
 	
}



function list_bonafied($cartid='',$refid='')
{
 	$DB1 = $this->load->database('umsdb', TRUE);
 			$DB1->select("b.*,s.first_name,s.middle_name,s.last_name");
		$DB1->from('bonafied_certificates b ');
	$DB1->join('student_master as s','s.enrollment_no = b.enrollment_no','left');
   $DB1->order_by('b.bc_id', 'desc');
	if($refid!='')
	{
	$DB1->where("cert_reg", $refid);    
	}
		if($cartid!='')
	{
	$DB1->where("bc_id", $cartid);    
	}
		$query=$DB1->get();
		$result=$query->result_array();
		return $result;
 	
}


function get_cancelled_adm($year='')
{
 
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,vsd.*,ad.actual_fee,ad.applicable_fee,ac.canc_date,ac.canc_fee,ac.canc_remark");
		$DB1->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
			$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	
				$DB1->join('admission_cancellations as ac','sm.stud_id = ac.stud_id','left');	
		//	$DB1->join('admission_cancellations as ac','sm.stud_id = ad.stud_id','left');	
				
			$DB1->where("sm.cancelled_admission",'Y');	
			if($year!='')    
			{
				$DB1->where("ac.academic_year", $year);

			}
		
		   	    
	
		$DB1->order_by("sm.stud_id", "asc");
		$query=$DB1->get();
//echo $DB1->last_query();
	//	 die();   
	//	echo $DB1->last_query();
		//die();  
		$result=$query->result_array();
		 
	//	$result=$query->result_array();
		return $result;
   
    
}


function fees_refund()
{
    
  $DB1 = $this->load->database('umsdb', TRUE);
  
  
  	$DB1->select("sm.first_name,sm.stud_id,sm.last_name,sm.enrollment_no,sm.form_number,sm.middle_name,stm.stream_name,cm.course_name,fr.*");
		$DB1->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
			$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		
				$DB1->join('fees_refunds as fr','sm.stud_id = fr.student_id','left');
					$DB1->where("fr.is_deleted",'N');	 
	$DB1->order_by("sm.stud_id", "asc");
	
		$query=$DB1->get();
  
//  echo $DB1->last_query();
		$result=$query->result_array();
		return $result;   
		
}


function cancel_stud_admission()
{
    //'stid':stid,'remark':remark,'cfee':cfee,'dat':dat,'stenrl':stenrl
      $DB1 = $this->load->database('umsdb', TRUE);

     $par['stud_id'] = $_POST['stid'];    
        $par['stud_prn'] = $_POST['stenrl'];
        $par['canc_fee'] = $_POST['cfee'];
          $par['canc_remark'] = $_POST['remark'];
          $par['canc_date'] = $_POST['dat'];
           $par['canc_on'] = date('Y-m-d h:i:s');
           $par['canc_by'] = $_SESSION['uid']; 
            $par['academic_year'] = $_POST['stayear']; 
           
        $ff=$DB1->insert('admission_cancellations',$par);
   //    echo $DB1->last_query();
   //  exit(0);
        if($ff)
        {
        	//$DB1 = $this->load->database('umsdb', TRUE);
		    if($_POST['stid']!="")
		    {
		        $where=" where stud_id='".$_POST['stid']."'";
		    }
		    
		   $sql="select * From student_master $where ";
		   $query = $DB1->query($sql); 

		  $rowss=$query->result_array();
	      if(!empty($rowss))
	      {

	      	$parc['student_id'] = $rowss[0]['stud_id'];    
		    $parc['academic_year'] = $rowss[0]['academic_year']; 
		    $parc['admission_session'] = $rowss[0]['admission_session']; 
	      	$parc['stream_id'] = $rowss[0]['admission_stream']; 
	      	$parc['current_year'] = $rowss[0]['current_year']; 
	       	$parc['current_semester'] = $rowss[0]['current_semester']; 
	       	$parc['created_by'] = $_SESSION['uid']; 

	        $DB1->insert('students_adm_cancel_lists',$parc);
	       echo 1;
	      
	
	        

	      }
	        
			
        }
       
		
		//echo "Y";
     //   echo $DB1->last_query();
    //  exit(0);
}



function creat_stu_par_login()
{
    $DB1 = $this->load->database('umsdb', TRUE);
    if($_POST['type1']=='S')
    {
      $role_id=4;  
    }
    if($_POST['type1']=='P')
    {
      $role_id=9;  
        
    }
     $rcnt = $this->check_if_exists('user_master','username',$_POST['um_id'],'roles_id',$role_id);
        if($rcnt<1)
        {
        $par['username'] = $_POST['um_id'];    
        $par['password'] = rand(4999,999999);
         $par['inserted_by'] = $_SESSION['uid'];
          $par['inserted_datetime'] = date('Y-m-d h:i:s');
           $par['status'] ='N';
            $par['roles_id'] = $role_id;
        $DB1->insert('user_master',$par);
        
        echo "Created";
        }
    
}

function smstest()
{
   
    
$mobile= "9326271593";//$udet['mobile'];
$username ="vikassingh"; //$result[$i]['username'];
$password = "12323";//$result[$i]['password'];
$sms_message ="Dear Student
To get your academic information and regular updates kindly logon to
sandipuniversity.edu.in/erp-login.php
Username $username
Password $password
Thank you
Sandip University
";
 
//echo "<br>stu".$mobile.">>".$sms_message;

  $ch = curl_init();
   $sms=urlencode($sms_message);
    //$query="?username=SANDIP03&password=SANDIP@2018&from=SANDIP&to=$mobile&text=$sms&coding=0";
    $query="?username=u4282&msg_token=j8eAyq&sender_id=SANDIP&message=$sms&mobile=$mobile";

    curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_URL,'http://49.50.67.32/smsapi/httpapi.jsp' . $query); 
    curl_setopt($ch, CURLOPT_URL,'http://bulksms.omegatelesolutions.com/api/send_transactional_sms.php' . $query); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
      $res = trim(curl_exec($ch));  
      var_dump($res);
curl_close($ch);

	 
    
    
    
}

function login_details($val)
{
    
    $icard = $this->getStudentsajax($val['astream'],$val['ayear']);
    for($i=0;$i<count($icard);$i++)
    {
        $sdet = $this->get_login_list('user_master','username',$icard[$i]['enrollment_no'],'roles_id','4');
        $pdet = $this->get_login_list('user_master','username',$icard[$i]['enrollment_no'],'roles_id','9');
        $icard[$i]['pstatus'] = $pdet['status'];
        $icard[$i]['sstatus'] = $sdet['status'];
        $icard[$i]['puid'] = $pdet['um_id'];
        $icard[$i]['suid'] = $sdet['um_id'];
        
    }
    
    return $icard;
//var_dump($icard);
  //  exit(0);
}
 
 
 function get_student_detail_by_prn($enrollment_no){
  $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("stud_id,first_name,last_name,middle_name,father_fname,father_mname,father_lname,mobile");
		$DB1->from('student_master');
		$DB1->where("enrollment_no", $enrollment_no);
		$query=$DB1->get();
		$result=$query->row_array();
		return $result;
        

}

function get_student_detail_by_prn_new_for_login_sms($enrollment_no){
  $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("stud_id,first_name,last_name,middle_name,father_fname,father_mname,father_lname,mobile");
		$DB1->from('student_master');
		$DB1->where("enrollment_no", $enrollment_no);
		$query=$DB1->get();
		$result=$query->row_array();
		return $result;
        

}


  function send_reset_password()
    {
    //    exit();
      $DB1 = $this->load->database('umsdb', TRUE);    
    $password = $par['password'] = rand(4999,999999);
    $par['updated_by'] = $_SESSION['uid'];
      $username = trim($_POST['prn']);
      
      if(trim($_POST['utype'])==4)
      {
          
          
          $udet = $this->get_student_detail_by_prn(trim($_POST['prn']));
//$fname = $udet['first_name'].' '.$udet['middle_name'].' '.$udet['last_name'];
if($udet['mobile']!='')
{
//$mobile= $udet['mobile'];
$mobile= $udet['mobile'];
$sms_message ='Dear Student
Your login details are updated by Admin.
Please logon to
sandipuniversity.edu.in/erp-login.php
Username '.$username.'
Password '.$password.'
Thank you
Sandip University
';

//echo "<br>stu".$mobile.">>".$sms_message;
/*$ch = curl_init();
$query="?username=SANDIP03&password=SANDIP@2018&from=SANDIP&to=$mobile&text=$sms_message&coding=0";
    curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL,'http://49.50.67.32/smsapi/httpapi.jsp' . $query); 
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 3);
$content = trim(curl_exec($ch));
curl_close($ch);
        curl_close($curl);
        */
   /*       $ch = curl_init();
   $sms=$sms_message;
    //$query="?username=SANDIP03&password=SANDIP@2018&from=SANDIP&to=$mobile&text=$sms&coding=0";
    $query="?username=u4282&msg_token=j8eAyq&sender_id=SANDIP&message=$sms&mobile=$mobile";

    curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_URL,'http://49.50.67.32/smsapi/httpapi.jsp' . $query); 
    curl_setopt($ch, CURLOPT_URL,'http://bulksms.omegatelesolutions.com/api/send_transactional_sms.php' . $query); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
      $res = trim(curl_exec($ch));     
curl_close($ch);
     */   
        
          $odj = new Message_api();
           
     $odj->send_sms($mobile,$sms_message);	  
        
        
        
        
        
        		$DB1->where('username',$username);
		$DB1->where('roles_id','4');
			$DB1->update('user_master',$par);
		
  $s++;
        echo "Student Password reset and sent successfully";
}
          
      }
       if(trim($_POST['utype'])==9)
      {
          
 $updet = $this->get_student_detail_by_prn(trim($_POST['prn']));
  $pmob = $this->fetch_parent_details($updet['stud_id']);
  
  
 // $fname = $updet['father_fname'].' '.$updet['father_mname'].' '.$updet['father_lname'];
 if($pmob[0]['parent_mobile2']!='')
 {
$mobile= $pmob[0]['parent_mobile2'];

$sms_message ='Dear Parent
Your login details are updated by Admin.
Please logon to
sandipuniversity.edu.in/erp-login.php
Username '.$username.'
Password '.$password.'
Thank you
Sandip University';
//echo "<br>par".$mobile.">>".$sms_message;
/*$ch = curl_init();
$query="?username=SANDIP03&password=SANDIP@2018&from=SANDIP&to=$mobile&text=$sms_message&coding=0";
    curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL,'http://49.50.67.32/smsapi/httpapi.jsp' . $query); 
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 3);
$content = trim(curl_exec($ch));
curl_close($ch);
        curl_close($curl);
        */
        /*  $ch = curl_init();
   $sms=$sms_message;
    //$query="?username=SANDIP03&password=SANDIP@2018&from=SANDIP&to=$mobile&text=$sms&coding=0";
    $query="?username=u4282&msg_token=j8eAyq&sender_id=SANDIP&message=$sms&mobile=$mobile";

    curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_URL,'http://49.50.67.32/smsapi/httpapi.jsp' . $query); 
    curl_setopt($ch, CURLOPT_URL,'http://bulksms.omegatelesolutions.com/api/send_transactional_sms.php' . $query); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
      $res = trim(curl_exec($ch));     
curl_close($ch);
        */
          $odj = new Message_api();
           
     $odj->send_sms($mobile,$sms_message);	  
        
        
  
        		$DB1->where('username',$username);
		$DB1->where('roles_id','9');
			$DB1->update('user_master',$par);

  $p++;
 }         
      
            echo "Parent Password reset and sent successfully";    
     
      }
      

      
      
    }



function send_login_credentials()
{
	exit();
		//error_reporting(E_ALL);
	   $DB1 = $this->load->database('umsdb', TRUE);
              
		$DB1->select("*");
		$DB1->from("user_master");
			//$DB1->like('username', "19", 'after');
		$DB1->where("um_id >",36440);
		$DB1->where("roles_id",4);
		$DB1->where("status",'Y');
		$DB1->order_by("um_id", "asc");
		$query=$DB1->get(); 
		/*echo $DB1->last_query();
		exit(0);
		die;*/
		
		$result = $query->result_array(); 

    
        $s=1;
       $p=1;
    
   for($i=0;$i<count($result);$i++)
   {
      
      if($result[$i]['roles_id']=='4')
     {
   //  $sdet = $this->get_login_list('user_master','um_id',$_POST['um_id'],'roles_id','4');

$udet = $this->get_student_detail_by_prn_new_for_login_sms($result[$i]['username']);
//print_r($udet);//exit;
//$fname = $udet['first_name'].' '.$udet['middle_name'].' '.$udet['last_name'];
if($udet['mobile']!='')
{
$mobile= $udet['mobile'];
//$mobile= '8850633088';

$username = $result[$i]['username'];
$password = $result[$i]['password'];
$sms_message ="Dear Student
To get your academic information and regular updates kindly logon to
https://www.sandipuniversity.edu.in/erp-login.php
Username: $username
Password: $password
Thank you
Sandip University.
";

//echo "<br>stu".$mobile.">>".$sms_message;exit;

  
	$sms=urlencode($sms_message);

	$smsGatewayUrl = "http://bulksms.bulkfactory.in/api/v2/sms/send?access_token=b5bb44175fe4aafb9b7e3b7c482d4b8e&message=$sms&sender=SANDIP&to=$mobile&service=T";  
	$smsgatewaydata = $smsGatewayUrl;
	$url = $smsgatewaydata;
	$ch = curl_init();                       // initialize CURL
	curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);         
        
  $s++;
  //exit;
}
     }
    /* if($result[$i]['roles_id']=='9')
     {

  $updet = $this->get_student_detail_by_prn_new_for_login_sms($result[$i]['username']);
  $pmob = $this->fetch_parent_details($updet['stud_id']);
  //print_r($pmob);
 if(!empty($pmob[0]['parent_mobile2']))
 {
//$mobile= $pmob[0]['parent_mobile2'];
$mobile= '8850633088';

$username = $result[$i]['username'];
$password = $result[$i]['password'];
$sms_message ="Dear Parent
To get your Ward academic information and regular updates kindly logon to
https://www.sandipuniversity.edu.in/erp-login.php
Username: $username
Password: $password
Thank you
Sandip University
";
   $sms=urlencode($sms_message);
$smsGatewayUrl = "http://bulksms.bulkfactory.in/api/v2/sms/send?access_token=b5bb44175fe4aafb9b7e3b7c482d4b8e&message=$sms&sender=SANDIP&to=$mobile&service=T";  
        $smsgatewaydata = $smsGatewayUrl;
        $url = $smsgatewaydata;

        $ch = curl_init();                       // initialize CURL
        curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch); 


  $p++;
 }
     }*/
    
   //exit; 
   }
    
    echo $s."##".$p;
    
   
    
}









 function activate_slogin()
 {
      $DB1 = $this->load->database('umsdb', TRUE);
     if($_POST['type1']=='S')
     {
     $sdet = $this->get_login_list('user_master','um_id',$_POST['um_id'],'roles_id','4');
if($sdet['status']=='Y')
{
   $nstat ='N'; 
    echo "Not Active";
}
 else
 {
 $nstat ='Y';   
  echo "Active";
$udet = $this->get_student_detail_by_prn($sdet['username']);
$fname = $udet['first_name'].' '.$udet['middle_name'].' '.$udet['last_name'];
$mobile= $udet['mobile'];
$username = $sdet['username'];
$password = $sdet['password'];
$sms_message ="Dear $fname
Your Sandip ERP Credentials
URL sandipuniversity.com/erp/login/index/student
Username $username
Password $password

Thank you
Sandip University
";

   $curl = curl_init('http://123.63.33.43/blank/sms/user/urlsms.php');
        curl_setopt($curl, CURLOPT_POST, 1);

   // curl_setopt($curl, CURLOPT_POSTFIELDS, "username=sandipfoundationnsk&pass=sandip@123&senderid=SANDIP&dest_mobileno=$mobile&msgtype=UNI&message=$sms_message&response=Y");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($curl);
        if ($res === FALSE) {
           // echo 'fail';
        } else {
           // echo 'success';
        }
        curl_close($curl);
  
 }
 
 $sstatus['status'] = $nstat;
 
         	$DB1->where('um_id', $_POST['um_id']);
		$DB1->update('user_master',$sstatus);
 
     }
      if($_POST['type1']=='P')
     {
     $pdet = $this->get_login_list('user_master','um_id',$_POST['um_id'],'roles_id','9'); 
     
     if($pdet['status']=='Y')
{
   $pstat ='N'; 
   echo "Not Active";
}
 else
 {
 $pstat ='Y';  
  echo "Active";
  
  $updet = $this->get_student_detail_by_prn($pdet['username']);
  $pmob = $this->fetch_parent_details($_POST['stid']);
  
  
  $fname = $updet['father_fname'].' '.$updet['father_mname'].' '.$updet['father_lname'];
$mobile= $pmob[0]['parent_mobile2'];
$username = $pdet['username'];
$password = $pdet['password'];
$sms_message ="Dear $fname
Your Sandip ERP Credentials
URL sandipuniversity.com/erp/login/index/parent
Username $username
Password $password

Thank you
Sandip University1
";

   $curl = curl_init('http://123.63.33.43/blank/sms/user/urlsms.php');
        curl_setopt($curl, CURLOPT_POST, 1);

   // curl_setopt($curl, CURLOPT_POSTFIELDS, "username=sandipfoundationnsk&pass=sandip@123&senderid=SANDIP&dest_mobileno=$mobile&msgtype=UNI&message=$sms_message&response=Y");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($curl);
        if ($res === FALSE) {
           // echo 'fail';
        } else {
          //  echo 'success';
        }
        curl_close($curl);
  
  
  
  
  
  
  
  
  
 }
  $pstatus['status'] = $pstat;
 
         	$DB1->where('um_id', $_POST['um_id']);
		$DB1->update('user_master',$pstatus);
    
     
     
     }
     
 }

function get_login_list($table,$cname1,$cvalue1,$cname2,$cvalue2)
{
    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from($table);
		$DB1->where($cname1,$cvalue1);
		$DB1->where($cname2,$cvalue2);
	//	$DB1->join('address_details as ad','sm.stud_id = ad.student_id','left');
	//	$DB1->where("adds_of", "STUDENT");
		//	$DB1->where("address_type", "CORS");d.district_name,c.taluka_name,s.state_name
		$query=$DB1->get(); 
		return $query->row_array(); 
    

}










function check_if_exists($table,$cname1,$cvalue1,$cname2,$cvalue2)
{
    
   
           $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("count(*) as ucount");
		$DB1->from($table);
		$DB1->where($cname1,$cvalue1);
		$DB1->where($cname2,$cvalue2);
	//	$DB1->join('address_details as ad','sm.stud_id = ad.student_id','left');
	//	$DB1->where("adds_of", "STUDENT");
		//	$DB1->where("address_type", "CORS");d.district_name,c.taluka_name,s.state_name
		$query=$DB1->get(); 
		$cn = $query->row_array();
		return $cn['ucount'];
    
}

//changes start
function generateprn($stream_id,$academic_year,$admission_year)
{
    
      $DB1 = $this->load->database('umsdb', TRUE); 
      
        $stream="select programme_code from stream_master where stream_id='".$stream_id."'";
        $stmdet = $DB1->query($stream);
       $stream_details =  $stmdet->result_array();
     // var_dump($stream_details);
    //  echo $stream_details[0]['programme_code'];
      
      //  $sql="select enrollment_no from student_master where admission_stream='".$stream_id."'  order by stud_id desc limit 0,1";
      $sql = "SELECT max(enrollment_no) as enrollment_no from student_master where admission_stream ='".$stream_id."' and admission_year='".$admission_year."' and academic_year = '".$academic_year."' AND `nationality`='international'";
     // echo $sql;
        $query = $DB1->query($sql);
       $pnr_details =  $query->result_array();
         $acyear =  substr($academic_year,-2);
    
	if($pnr_details[0]['enrollment_no']!='') {
		//echo 'LIN';
 $var = substr($pnr_details[0]['enrollment_no'], -3);

$var = ++$var;

$prn =  sprintf("%03d", $var);

$finalprn = $acyear."".$stream_details[0]['programme_code']."".$prn;
//$finalprn = "16".$stream_details[0]['programme_code']."001"; 
    }
    else
    {
        
    //$finalprn = "16".$stream_details[0]['programme_code']."001";     
   $finalprn = $acyear."".$stream_details[0]['programme_code']."001";     
    }
    

    return  $finalprn;
    
}



function generateprn_new($stream_id,$academic_year,$admission_year)
{
    
      $DB1 = $this->load->database('umsdb', TRUE); 
      
    $stream="select programme_code from stream_master where stream_id='".$stream_id."'";
        $stmdet = $DB1->query($stream);
       $stream_details =  $stmdet->result_array();

      $sql = "SELECT max(enrollment_no_new) as enrollment_no from student_master where admission_stream ='".$stream_id."' and admission_year='".$admission_year."' and academic_year = '".$academic_year."' AND `nationality`='international'";
     //   echo $sql;
        $query = $DB1->query($sql);
       $pnr_details =  $query->result_array();
       $acyear =  substr($academic_year,-2);
       //$acyear=$acyear."01";
    if($pnr_details[0]['enrollment_no']!='')
    {
        $var = substr($pnr_details[0]['enrollment_no'], -3);

$var = ++$var;

$prn =  sprintf("%03d", $var);

$finalprn = $acyear."01".$stream_details[0]['programme_code']."".$admission_year."".$prn;
//$finalprn = "16".$stream_details[0]['programme_code']."001"; 
    }
    else
    {
        
    //$finalprn = "16".$stream_details[0]['programme_code']."001";     
   $finalprn = $acyear."01".$stream_details[0]['programme_code']."".$admission_year."001";     
    }
    
//echo $finalprn;
//exit();
//$quer ="update student_master set enrollment_no_new='".$finalprn."' where stud_id='".$result[$i]['stud_id']."'";

//echo $quer;
//exit();
 // $DB1->query($quer);
   return  $finalprn;
    
}








function generate_allprn()
{
    
    
    $names =array('200103011611','20SUN0302','20SUN0089','20SUN0289','20SUN0596','20SUN0108','20SUN0762','20SUN0482','20SUN0413','20SUN0336','20SUN0703','20SUN0597','20SUN0272','20SUN0015','20SUN0070','20SUN0628','20SUN0187','20SUN0530','20SUN0616','20SUN0121','20SUN0547','20SUN0612','20SUN0664','20SUN0525','20SUN0611','20SUN0182','20SUN0167','20SUN0155','20SUN0731','20SUN0729','20SUN0158','20SUN0378','20SUN0085','20SUN0700','20SUN0648','20SUN0197','20SUN0603','20SUN0661','20SUN0323','20SUN0606','20SUN0614','20SUN0602','20SUN0018','20SUN0727','20SUN0739','20SUN0367','20SUN0653','20SUN0601','20SUN0704','20SUN0725','20SUN0726','20SUN0697','20SUN0744','20SUN0743','20SUN0409');
      $DB1 = $this->load->database('umsdb', TRUE); 
      
		$DB1->select("*");
		$DB1->from('student_master');
		$DB1->where("cancelled_admission", 'N');
		$DB1->where("admission_session", '2020');
		$DB1->where("univ_transfer", 'N');
		$DB1->where('admission_cycle IS NULL', NULL, FALSE);
		$DB1->where_in('enrollment_no', $names);
	//	$DB1->join('address_details as ad','sm.stud_id = ad.student_id','left');
	//	$DB1->where("adds_of", "STUDENT");
		$DB1->order_by("stud_id", "asc");
		//	$DB1->where("address_type", "CORS");d.district_name,c.taluka_name,s.state_name
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		//die();  
		$result=$query->result_array();
      
      
      
   for($i=0;$i<count($result);$i++)
   {
      
      
        $stream="select programme_code from stream_master where stream_id='".$result[$i]['admission_stream']."'";
        $stmdet = $DB1->query($stream);
       $stream_details =  $stmdet->result_array();

      $sql = "SELECT max(prn_2018) as enrollment_no from student_master where admission_session='2020' and admission_stream ='".$result[$i]['admission_stream']."' and admission_year='".$result[$i]['admission_year']."'";
        //echo $sql;exit;
        $query = $DB1->query($sql);
       $pnr_details =  $query->result_array();
    if($pnr_details[0]['enrollment_no']!='')
    {
        $var = substr($pnr_details[0]['enrollment_no'], -3);

$var = ++$var;

$prn =  sprintf("%03d", $var);

$finalprn = "2001".$stream_details[0]['programme_code']."".$result[$i]['admission_year']."".$prn;
//$finalprn = "16".$stream_details[0]['programme_code']."001"; 
    }
    else
    {
        
    //$finalprn = "16".$stream_details[0]['programme_code']."001";     
   $finalprn = "2001".$stream_details[0]['programme_code']."".$result[$i]['admission_year']."001";     
    }
    
//echo $finalprn;
$quer ="update student_master set prn_2018='".$finalprn."' where stud_id='".$result[$i]['stud_id']."'";

//echo $quer;
//exit();
 $DB1->query($quer);
 unset($quer);
    //return true;  
   }

}


function generate_prn_punching()
{
    
    
    
      $DB1 = $this->load->database('umsdb', TRUE); 
      
		$DB1->select("*");
		$DB1->from('student_master');
		$DB1->where("cancelled_admission", 'N');
		$DB1->where("admission_session", '2019');
		$DB1->where('admission_cycle IS NULL', NULL, FALSE);
		//		$DB1->where("univ_transfer", 'N');
	//	$DB1->join('address_details as ad','sm.stud_id = ad.student_id','left');
	//	$DB1->where("adds_of", "STUDENT");
		$DB1->order_by("stud_id", "asc");
		//	$DB1->where("address_type", "CORS");d.district_name,c.taluka_name,s.state_name
		$query=$DB1->get();
		//echo $DB1->last_query();
		//die();  
		$result=$query->result_array();
      
      
      
   for($i=0;$i<count($result);$i++)
   {
      
      
        $stream="select programme_code from stream_master where stream_id='".$result[$i]['admission_stream']."'";
        $stmdet = $DB1->query($stream);
       $stream_details =  $stmdet->result_array();

      $sql = "SELECT max(punching_prn) as enrollment_no from student_master where admission_session='2019' and admission_stream ='".$result[$i]['admission_stream']."' ";
     //   echo $sql;
        $query = $DB1->query($sql);
       $pnr_details =  $query->result_array();
    if($pnr_details[0]['enrollment_no']!='')
    {
        $var = substr($pnr_details[0]['enrollment_no'], -3);

$var = ++$var;

$prn =  sprintf("%03d", $var);

$finalprn = "19".$stream_details[0]['programme_code']."".$prn;
//$finalprn = "16".$stream_details[0]['programme_code']."001"; 
    }
    else
    {
        
    //$finalprn = "16".$stream_details[0]['programme_code']."001";     
   $finalprn = "19".$stream_details[0]['programme_code']."001";     
    }
    
//echo $finalprn;
$quer ="update student_master set punching_prn='".$finalprn."' where stud_id='".$result[$i]['stud_id']."'";

//echo $quer;
//exit();
$DB1->query($quer);
  //  return  $finalprn;
    
   }

}














	function load_studentlist_icard($streamid,$year,$academic_year){
		//    $DB1 = $this->load->database('umsdb', TRUE);
		    
		    	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,vsd.school_short_name,vsd.course_short_name,vsd.stream_name");
		$DB1->from('student_master as sm');
			$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		//	$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
			$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	
		//	$DB1->where("sm.admission_stream",$streamid);	 
		//	$DB1->where("ad.year", $year);	  
		    
		   
		    
		    /*
		    	$DB1->select("sm.*,vsd.school_short_name,vsd.course_short_name,vsd.stream_name");
		$DB1->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
			$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');*/
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
			$DB1->where("vsd.stream_id",$_POST['admission-stream']);	    
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
			$DB1->where("ad.year",$_POST['admission-year']);	    
		}
			
		}
		
			if($_POST['acyear']!='')
		{
		   	$DB1->where("ad.academic_year",$_POST['acyear']);	 
		}
		

			$DB1->where("sm.cancelled_admission",'N');
		//	$DB1->where("sm.academic_year",'2017');
	
		$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
	//	echo $DB1->last_query();
	//	die();   
		$result=$query->result_array();
		    
		    
		    
		    
		    
		    
		    
		    
		    
		    
		    
		    
	/*	$DB1->select("sm.*,stm.stream_name,cm.course_name");
		$DB1->from('student_master as sm');

		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
			$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		
			$DB1->where("sm.admission_stream",$streamid);	    
		
			$DB1->where("sm.admission_year", $year);	   
			$DB1->where("sm.academic_year",$academic_year);
	
		$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
	
		$result=$query->result_array();
	
	*/
	
	
	
	
	
   for($i=0;$i<count($result);$i++)
   {
       $add = $this->fetch_address_details($result[$i]['stud_id'],'STUDENT','CORS');
   
    $string = str_ireplace($add[0]['taluka_name'],"",$add[0]['address']);
     $string = str_ireplace($add[0]['district_name'],"",$string);
     $string = str_ireplace($add[0]['state_name'],"",$string);
     $string = str_ireplace($add[0]['pincode'],"",$string);
     if(strtolower(trim($add[0]['taluka_name']))==strtolower(trim($add[0]['district_name'])))
     {
        $result[$i]['add'] = $string." ".$add[0]['taluka_name']." ".$add[0]['state_name']." ".$add[0]['pincode']; 
     }
     else
     {
       $result[$i]['add'] = $string." ".$add[0]['taluka_name']." ".$add[0]['district_name']." ".$add[0]['state_name']." ".$add[0]['pincode'];
     }
       $pdet  = $this->fetch_parent_details($result[$i]['stud_id']);
        $result[$i]['pmobile'] = $pdet[0]['parent_mobile2'];
       
   }
		return $result;
	}
    












function student_Ids($id)
{
   $sid1 = implode(",",$id['lstd']);
   //var_dump($sid);
   $sid=array_map('intval', explode(',', $sid1));
   
           $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.stud_id,sm.form_number,sm.enrollment_no,sm.enrollment_no_new,sm.first_name,sm.middle_name,sm.last_name,sm.blood_group,sm.mobile,sm.dob,sm.academic_year,sm.admission_session");
		$DB1->from('student_master sm');
		$DB1->where_in("stud_id", $sid);
	//	$DB1->join('address_details as ad','sm.stud_id = ad.student_id','left');
	//	$DB1->where("adds_of", "STUDENT");
		//	$DB1->where("address_type", "CORS");d.district_name,c.taluka_name,s.state_name
		$query=$DB1->get();
	//dump	echo $DB1->last_query();
	//	die();  
		$result=$query->result_array();
		//return $result;
  
   for($i=0;$i<count($result);$i++)
   {
       $add = $this->fetch_address_details($result[$i]['stud_id'],'STUDENT','CORS');
    //  var_dump($add);
       $result[$i]['add'] = $add[0]['address']." ".$add[0]['taluka_name']." ".$add[0]['district_name']." ".$add[0]['state_name']." ".$add[0]['pincode'];
       $pdet  = $this->fetch_parent_details($result[$i]['stud_id']);
        $result[$i]['pmobile'] = $pdet[0]['parent_mobile2'];
       
   }
   //var_dump($result);
  // exit(0);
   return $result;
  
}








function student_Idsall()
{
//   $sid1 = implode(",",$id['lstd']);
   //var_dump($sid);
   //$sid=array_map('intval', explode(',', $sid1));
   
           $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.stud_id,sm.form_number,sm.admission_stream,sm.enrollment_no,sm.enrollment_no_new,sm.first_name,sm.middle_name,sm.last_name,sm.blood_group,sm.mobile,sm.dob,sm.academic_year");
		$DB1->from('student_master sm');
		$DB1->where("cancelled_admission",'N');
		//$DB1->where("sm.academic_year",'2019');
	//	$DB1->join('address_details as ad','sm.stud_id = ad.student_id','left');
	//	$DB1->where("adds_of", "STUDENT");
		//	$DB1->where("address_type", "CORS");d.district_name,c.taluka_name,s.state_name
			$DB1->order_by("sm.admission_school,sm.admission_stream,sm.admission_year,sm.enrollment_no", "asc");
		$DB1->limit(1,0);
		$query=$DB1->get();
	//	echo $DB1->last_query();
//	die();  
		$result=$query->result_array();
		//return $result;
  
   for($i=0;$i<count($result);$i++)
   {
      
      
      /* $add = $this->fetch_address_details($result[$i]['stud_id'],'STUDENT','CORS');
       $result[$i]['add'] = $add[0]['address']." ".$add[0]['taluka_name']." ".$add[0]['district_name']." ".$add[0]['state_name']." ".$add[0]['pincode'];
       $pdet  = $this->fetch_parent_details($result[$i]['stud_id']);
        $result[$i]['pmobile'] = $pdet[0]['parent_mobile2'];
         $result[$i]['validity'] = $this->get_course_duration($result[$i]['admission_stream']);
         $result[$i]['short_stream'] = $this->getfieldname_byid('vw_stream_details','stream_id',$result[$i]['admission_stream'],'stream_short_name');
         */
         
          $add = $this->fetch_address_details($result[$i]['stud_id'],'STUDENT','CORS');
   
    $string = str_ireplace($add[0]['taluka_name'],"",$add[0]['address']);
     $string = str_ireplace($add[0]['district_name'],"",$string);
     $string = str_ireplace($add[0]['state_name'],"",$string);
     $string = str_ireplace($add[0]['pincode'],"",$string);
     if(strtolower(trim($add[0]['taluka_name']))==strtolower(trim($add[0]['district_name'])))
     {
        $result[$i]['add'] = $string." ".$add[0]['taluka_name']." ".$add[0]['state_name']." ".$add[0]['pincode']; 
     }
     else
     {
       $result[$i]['add'] = $string." ".$add[0]['taluka_name']." ".$add[0]['district_name']." ".$add[0]['state_name']." ".$add[0]['pincode'];
     }
       $pdet  = $this->fetch_parent_details($result[$i]['stud_id']);
        $result[$i]['pmobile'] = $pdet[0]['parent_mobile2'];
       $result[$i]['validity'] = $this->get_course_duration($result[$i]['admission_stream']);
         $result[$i]['short_stream'] = $this->getfieldname_byid('vw_stream_details','stream_id',$result[$i]['admission_stream'],'stream_short_name'); 
         
   }
   //var_dump($result);
  // exit(0);
   return $result;
  
}











function get_student_id_by_prn($enrollment_no){
  $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("stud_id");
		$DB1->from('student_master');
		$DB1->where("enrollment_no", $enrollment_no);
		$DB1->or_where("enrollment_no_new", $enrollment_no);
		$query=$DB1->get();
		$result=$query->row_array();
		return $result;
        

}


 function get_course_duration($courseid)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("course_duration");
		$DB1->from('stream_master');
		$DB1->where("stream_id", $courseid);
		$query=$DB1->get();
		/*  echo $this->db->last_query();
		die();  */ 
		$result=$query->row_array();
	//	$var1 = 2017 + (int)$result['course_duration'];
		$var1 = (int)$result['course_duration'];
	//	echo $var1;
	//	exit();
		return $var1;
        
    }





 function  get_course_streams()
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
        
		$sql="SELECT vw.stream_id,vw.stream_name,vw.stream_short_name FROM student_master s left join vw_stream_details vw on s.admission_stream=vw.stream_id where s.academic_year='".$_POST['academic_year']."' and vw.course_id='".$_POST['course']."' group by vw.stream_id";
        
        if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND vw.school_code = $sccode";
			}
        $query = $DB1->query($sql);
       $stream_details =  $query->result_array();
        
        
       echo '<select name="admission-branch" class="form-control" id="admission-stream" required>
									<option value="">Select Stream</option>';
									
									foreach($stream_details as $course){
									
										echo '<option value="'.$course['stream_id'].'"'.$sel.'>'.$course['stream_name'].'</option>';
									} 
									echo '</select></div>';
        
        
        
        
        
        
        
    } 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    function getschool_bycourse($courseid)
    {
          $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("school_id");
		$DB1->from('vw_stream_details');
		$DB1->where("stream_id", $courseid);
		$query=$DB1->get();
		/*  echo $this->db->last_query();
		die();  */ 
		$result=$query->row_array();
		return $result['school_id'];
        
    }
    
    

function getbanks()
{
        $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('bank_master');
		$DB1->where("active", "Y");
		$query=$DB1->get();
		/*  echo $this->db->last_query();
		die();  */ 
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
    
    
    
    
    
      function getcourse_yearwise($academic_year){
       
	
	  $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("DISTINCT(vd.course_id),vd.course_name,vd.course_short_name");
		$DB1->from('vw_stream_details vd');
		$DB1->join('academic_fees as af','af.stream_id = vd.stream_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->where("af.academic_year", $academic_year);
		//	$DB1->where("certificate_name", $certtype);
		$query=$DB1->get();
	// echo $DB1->last_query();
	//	die();  
		$result=$query->result_array();
		return $result;
	
       
    }
    
    
     function  get_course_streams_yearwise()
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        
        $DB1->select("vd.stream_id,vd.stream_name,vd.stream_short_name");
		$DB1->from('vw_stream_details vd');
		$DB1->join('academic_fees as af','af.stream_id = vd.stream_id','left');
		$DB1->where("vd.course_id", $_POST['course']);
		$DB1->group_by("vd.stream_id");
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->where("af.academic_year", '2019-20');
		
		
		//	$DB1->where("certificate_name", $certtype);
		$query=$DB1->get();
		//echo $DB1->last_query();
           $stream_details =  $query->result_array();
        
        
        
        
       echo '<select name="admission-branch" class="form-control" id="admission-stream" required>
									<option value="">Select Stream</option>';
									
									foreach($stream_details as $course){
									
										echo '<option value="'.$course['stream_id'].'"'.$sel.'>'.$course['stream_name'].'</option>';
									} 
									echo '</select></div>';
        
        
        
        
        
        
        
    } 
    
    
    
    
    
    
    
    
    	function getcategorylist(){
    	     $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="select caste_code,caste_name from caste_master where status='y'";
		$query=$DB1->query($sql);
		return $query->result_array();
	}
    

    	function getAllStudents(){
    	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,stm.course_id");
		$DB1->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		
		$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		 // echo $DB1->last_query();
	//	  exit(0);
	//	die();  */ 
		$result=$query->result_array();
		$cnt=count($result);
		return $cnt;
	}
	
	function get_cert_details($stdid,$certtype)
	{
	     $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('student_certificate_submit_details');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->where("student_id", $stdid);
			$DB1->where("certificate_name", $certtype);
		$query=$DB1->get();
		/*  echo $this->db->last_query();
		die();  */ 
		return $query->result_array();
		//$cnt=count($result);
	//	return $cnt;  
	    
	}
	
	
	
	
	function count_rows($t)
	{
	    
	     	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('student_references');
		$DB1->where("student_id", "59");
		$DB1->where("is_reference", "N");
	//	$DB1->where("sm.stud_id", "desc");
	//	$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		/*  echo $this->db->last_query();
		die();  */ 
		$result=$query->num_rows();
	//	$cnt=count($result);
		echo $result;

	}
	
	
	
		function get_inst_details($feeid){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("fd.*,fid.balance_fees,fid.next_payment_date");
		$DB1->from('fees_details fd');
		$DB1->join('fees_installment_details as fid','fd.fees_id = fid.fees_id','left');
		$DB1->where('fd.fees_id',$feeid);
	
		//$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		$result=$query->result_array();
		 //echo $this->db->last_query();
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
	
	
	
	
	
	
	function fetch_address_details($stdid,$aof,$atype){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("a.*,d.district_name,c.taluka_name,s.state_name");
		$DB1->from('address_details as a');
		$DB1->where('student_id',$stdid);
		$DB1->where('adds_of',$aof);
		$DB1->where('address_type',$atype);
		$DB1->join('district_name as d','d.district_id = a.district_id','left');
		$DB1->join('taluka_master as c','c.taluka_id = a.city','left');
		$DB1->join('states as s','s.state_id = a.state_id','left');
		//$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		$result=$query->result_array();
		 //echo $this->db->last_query();
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
    
	
	
	
	
	function fetch_address_details_all($stdid){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("a.*,d.district_name,c.taluka_name,s.state_name");
		$DB1->from('address_details as a');
		
		//$DB1->where('adds_of',$aof);
		//$DB1->where('address_type',$atype);
		$DB1->join('district_name as d','d.district_id = a.district_id','left');
		$DB1->join('taluka_master as c','c.taluka_id = a.city','left');
		$DB1->join('states as s','s.state_id = a.state_id','left');
		$DB1->where('a.student_id',$stdid);
		//$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		$result=$query->result_array();
		// echo $DB1->last_query();
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
	
		 	function get_feedetails($stdid,$acyear=''){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("fd.*,bm.bank_name");
		$DB1->from('fees_details fd');
			$DB1->join('bank_master as bm','fd.bank_id = bm.bank_id','left');
			$DB1->where('fd.student_id',$stdid);
			if($acyear!='')
			{
			$DB1->where('fd.academic_year',$acyear);
			}
				$DB1->where('fd.type_id','2');
				$DB1->where('fd.is_deleted','N');
	
		$query=$DB1->get();
		/*$uId=$this->session->userdata('uid');
		if($uId=='2')
		{
				echo $DB1->last_query();
				die;
		}*/
	//	echo $DB1->last_query();
		$result=$query->result_array();
		return $result;
	}

	 	function get_feedetails_check_provisional($stdid,$acyear=''){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("fd.*,bm.bank_name");
		$DB1->from('fees_details fd');
			$DB1->join('bank_master as bm','fd.bank_id = bm.bank_id','left');
			$DB1->where('fd.prov_reg_no',$stdid);
			if($acyear!='')
			{
			$DB1->where('fd.academic_year',$acyear);
			}
				$DB1->where('fd.type_id','2');
				$DB1->where('fd.is_deleted','N');
	
		$query=$DB1->get();
	/*	$uId=$this->session->userdata('uid');
		if($uId=='2')
		{
				echo $DB1->last_query();
				die;
		}*/
	//	echo $DB1->last_query();
		$result=$query->result_array();
		return $result;
	}
	
	
	
		function get_challan_details($fees_id){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("fd.*,bm.bank_name,sm.first_name,sm.middle_name,sm.last_name,ad.year,vsd.stream_name,vsd.course_name");
		$DB1->from('fees_details fd');
			$DB1->join('bank_master as bm','fd.bank_id = bm.bank_id','left');
	$DB1->join('admission_details as ad','fd.student_id = ad.student_id and  fd.academic_year = ad.academic_year','left');		
			
		$DB1->join('student_master as sm','fd.student_id = sm.stud_id','left');
			$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
			$DB1->where('fd.fees_id',$fees_id);

	
		$query=$DB1->get();
	//	echo $DB1->last_query();
		$result=$query->row_array();
//var_dump($result);
//	exit();
		return $result;
	}
	
	
	
	
	
	
	
		function get_refundetails($stdid){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("fd.*,bm.bank_name");
		$DB1->from('fees_refunds fd');
			$DB1->join('bank_master as bm','fd.bank_id = bm.bank_id','left');
			$DB1->where('fd.student_id',$stdid);
				//$DB1->where('fd.type_id','2');
	$DB1->where('fd.is_deleted','N');
	
		$query=$DB1->get();
		$result=$query->result_array();
		return $result;
	}
	
		function get_tot_refunds($stdid,$acyear=''){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sum(amount) as rsum");
		$DB1->from('fees_refunds');

			$DB1->where('student_id',$stdid);
			if($acyear !='')
		{
		 	$DB1->where('academic_year',$acyear);  
		}
		
				//$DB1->where('fd.type_id','2');
	$DB1->where('is_deleted','N');
	
		$query=$DB1->get();
		$result=$query->row_array();
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
	
	function getpmedias(){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('publicity_media');
			$DB1->where('status','Y');

		$query=$DB1->get();
		$result=$query->result_array();
		return $result;
	}
	
	
	
	
		 	function get_bankdetails($stdid){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('student_bank_details');
			$DB1->where('student_id',$stdid);

		$query=$DB1->get();
		$result=$query->result_array();
		return $result;
	}
	
	
		function get_referencedetails($fldname,$stdid){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('student_references');
			$DB1->where($fldname,'Y');
	$DB1->where('student_id',$stdid);
		$query=$DB1->get();
	//	echo $DB1->last_query();
		$result=$query->result_array();
		return $result;
	}
	
	
	
	
	
	
	
		function fetch_parent_details($stdid){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("relation,occupation,income,parent_mobile2,parent_mobile1");//
		$DB1->from('parent_details');
		$DB1->where('student_id',$stdid);
			//	$DB1->where('address_type',$atype);
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		//$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		/*  echo $this->db->last_query();
		die();  */ 
		$result=$query->result_array();
		 //echo $DB1->last_query();
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
	
function fetch_distcity_details($tablename,$columnname,$parameter)
{
   $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from($tablename);
		$DB1->where($columnname,$parameter);
			//	$DB1->where('address_type',$atype);
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		//$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		  //echo $DB1->last_query();
	//	exit(0);
		$result=$query->result_array(); 
    	return $result;
    
}
	
	
	
	
	function userdoc_list($stud_id)
{
   $DB1 = $this->load->database('umsdb', TRUE);
$query =  $DB1->query("SELECT dm.*,sdd.* FROM document_master as dm 
left join student_document_details as sdd on dm.document_id =sdd.doc_id and sdd.student_id=$stud_id
where dm.status='Y' ");
	//	$DB1->select("dm.*,sdd.*");
	//	$DB1->from('document_master dm');
	//	$DB1->join('student_document_details  as sdd','sdd.doc_id = dm.document_id','left');
	//	$DB1->where('student_id',$stud_id);
			//	$DB1->where('address_type',$atype);
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		//$DB1->order_by("sm.stud_id", "desc");
	//	$query=$DB1->get();
//	 echo $DB1->last_query();
	//	exit(0);
		$result=$query->result_array(); 
    	return $result;
    
}
	
	
	
	
	
	
	
	
	
	
	
			function fetch_stcouse_details($stdid){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('vw_stream_details');
		$DB1->where('course_id',$stdid);
			//	$DB1->where('address_type',$atype);
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		//$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		//	 echo $DB1->last_query();
		// exit(0);
		/*  echo $this->db->last_query();
		die();  */ 
		$result=$query->result_array();
	
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
	
	
	function fetch_stcouse_details_id($stdid){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("stream_id,stream_name");
		$DB1->from('vw_stream_details');
		$DB1->where('course_id',$stdid);
			//	$DB1->where('address_type',$atype);
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		//$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		//	 echo $DB1->last_query();
		// exit(0);
		/*  echo $this->db->last_query();
		die();  */ 
		$result=$query->result_array();
	
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
	
	
	
			function fetch_stcouse_details1($stdid){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");//*
		$DB1->from('vw_stream_details');
		$DB1->where('stream_id',$stdid);
			//	$DB1->where('address_type',$atype);
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		//$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		/*  echo $this->db->last_query();
		die();  */ 
		$result=$query->result_array();
	//	 echo $DB1->last_query();
		// exit(0);
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
	
	function fetch_stcouse_id($stdid){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("course_id");//*
		$DB1->from('vw_stream_details');
		$DB1->where('stream_id',$stdid);
			//	$DB1->where('address_type',$atype);
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		//$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		/*  echo $this->db->last_query();
		die();  */ 
		$result=$query->result_array();
	//	 echo $DB1->last_query();
		// exit(0);
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
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
    
    
    
    function getfieldname_byid($tablename,$fieldid,$fieldidvalue,$fieldname)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select($fieldname);
		$DB1->from($tablename);
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
			$DB1->where($fieldid,$fieldidvalue);
        	$query=$DB1->get();
      //  	echo $DB1->last_query();
        
        $result=$query->row_array();
        //echo $result[$fieldname];
        //	exit(0);
        return $result[$fieldname];
        
    }
    
    
    
    function shift_emp_inhouse()
    {
       $DB1 = $this->load->database('icdb', TRUE);
        $dat2  = $this->db->query("SELECT em.*,epd.mobileNumber,epd.oemail FROM `employee_master` em left join employe_other_details epd on em.emp_id = epd.emp_id WHERE  em.emp_reg_id > 321");


		$result=$dat2->result_array();
	
		foreach($result as $result)
		{
		    $dat['staff_id']=$result['emp_id'];
		 $dat['staff_name']=$result['fname']." ".$result['mname']." ".$result['lname'];
		  $dat['institute']='SU';
		 $dat['mobile']=$result['mobileNumber'];
		  $dat['email']=$result['oemail'];
		 $dat['otp']=rand(1000,9999);
	$dat['status']='Y';	 
		    
//	$DB1->insert('inhouse_staff_details',$dat);
		   echo $DB1->last_query().";";
		}
	
		//var_dump($result);
		
		
/*
        $dat2  = $this->db->query("SELECT * FROM `employee_master` WHERE `old_emp_id` IS NOT NULL");


		$result=$dat2->result_array();
	
//	var_dump($result);
	

		foreach($result as $result)
		{
		    
	  $dat3  = $this->db->query("SELECT emp_code,weekly_off,shift,in_time,out_time,report_school,report_department,route,report_person1,report_person2,
	  report_person3,report_person4,status,updated_by,updated_datetime,inserted_by,inserted_datetime FROM `employee_reporting_master` WHERE emp_code ='".$result['old_emp_id']."' and status='Y'");


		$result3=$dat3->result_array();	    
	
		foreach($result3 as $result3)
		{	
		$arr1 = $result3;
			$arr1['emp_code'] = $result['emp_id'];
		//var_dump($arr1);
		$this->db->insert('employee_reporting_master',$arr1);    
		echo $this->db->last_query();
		}   
		/*    $dat['staff_id']=$result['emp_id'];
		 $dat['staff_name']=$result['fname']." ".$result['mname']." ".$result['lname'];
		  $dat['institute']='SU';
		 $dat['mobile']=$result['mobileNumber'];
		  $dat['email']=$result['oemail'];
		 $dat['otp']=rand(1000,9999);
	$dat['status']='Y';	 */
		    
		  //  $this->db->insert('inhouse_staff_details',$dat);
		  // echo $this->db->last_query().";";
	//	}
	
	
		
		
		
		
    }
    
    
    
    
    
    
    
    function jtest()
    {
        
        
        
        		    $DB1 = $this->load->database('umsdb', TRUE);




$str = array('71','17');

	$DB1->select("sm.*");
		$DB1->from("student_master as sm");
$DB1->where_not_in('sm.admission_stream', $str);
			$DB1->where("sm.cancelled_admission",'N');
	
//		$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
	//	echo $DB1->last_query();
		$result=$query->result_array();





        
        foreach($result as $stuid)
        {
          // echo $stuid.">>".$_POST[$stuid."_actual"]."**".$_POST[$stuid."_exem"]."@".$_POST[$stuid."_appli"]."|"; 
           
$fcd['current_semester1'] =  $stuid['current_semester'] + 1;
$DB1->where('stud_id', $stuid['stud_id']);
//$DB1->update('student_master',$fcd);
	
	
	
	
        }
    }
    
    
    
    
    
    
     	function getStudentsajax($streamid='',$year='',$acdyear=''){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,vsd.*,ad.form_number as formn");
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as sm','ad.student_id = sm.stud_id','left');
		$DB1->join('vw_stream_details as vsd','ad.stream_id = vsd.stream_id','left');
		//	$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		if($streamid!='')
		{
			$DB1->where("sm.admission_stream",$streamid);	    
		}
		if($year!='')
		{
		
			$DB1->where("ad.year", $year);
		}
			if($acdyear!='')
		{
		
			$DB1->where("ad.academic_year", $acdyear);
			}

			$DB1->where("sm.cancelled_admission",'N');
	
		$DB1->order_by("sm.enrollment_no", "asc");
		$DB1->order_by("sm.admission_stream", "asc");
		$DB1->order_by("sm.current_semester", "asc");
		//$DB1->limit(10); // testing purpose
		$query=$DB1->get();
		//echo $DB1->last_query();
		$result=$query->result_array();
		return $result;
	}
    
    
    
    
  
    
    
    function verify_prnno($data){

		$DB1 = $this->load->database('umsdb', TRUE);
		
		$DB1->select("sm.*,stm.stream_name,cm.course_name,adm.actual_fee,adm.applicable_fee,adm.year");
		$DB1->from('student_master as sm');
		$DB1->join('admission_details as adm','sm.stud_id = adm.student_id','left');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
	
		$DB1->where("sm.enrollment_no",$data['prn']);
				//$DB1->where("sm.is_detained",'N');
 
		$query=$DB1->get();
		//echo $DB1->last_query();
		$result=$query->row_array();
		
		
		$pdet = $this->fetch_parent_details($result['stud_id']);
	
		$result['pmobile'] = $pdet[0]['parent_mobile2'];
		return $result;
	}
    
    
    
    
    //jugal adm 2018
    
        
    function verifypro_prn($stdid=''){
		    $DB1 = $this->load->database('icdb', TRUE);
		    
		        $this->db->select('smd.*,pad.*,sm.state_name,cm.city_name,spn.sprogramm_acro,spn.ums_id');
$this->db->from('sandipun_ic_erp.provisional_admission_details pad');
$this->db->join('sandipun_ic_erp.student_meet_details smd','smd.id=pad.adm_id','left');
$this->db->join('sandipun_univerdb.school_programs_new spn','pad.program_id=spn.sp_id','left');
$this->db->join('sandipun_ic_erp.state_master sm','smd.state_id=sm.state_id','left');
$this->db->join('sandipun_ic_erp.city_master cm','smd.city_id=cm.city_id','left');
if($stdid=='')
{
$this->db->where('pad.prov_reg_no',$_POST['prn']);
}
else
{
$this->db->where('pad.adm_id',$stdid);    
}
$query =$this->db->get();
/*echo $this->db->last_query();
die;*/
$result = $query->row_array();
return $result;


		/*$DB1->select("sm.*,stm.stream_name,cm.course_name,adm.actual_fee,adm.applicable_fee,adm.year");
		$DB1->from('student_master as sm');
		$DB1->join('admission_details as adm','sm.stud_id = adm.student_id','left');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
			$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
	
			$DB1->where("sm.enrollment_no",$data['prn']);
			//	$DB1->where("sm.cancelled_admission",'N');
 
		$query=$DB1->get();

		$result=$query->row_array();
	
		$pdet = $this->fetch_parent_details($result['stud_id']);
		//var_dump($pdet);
		$result['pmobile'] = $pdet[0]['parent_mobile2'];*/
		//return $result;
	}
    
    
    
    
        
    function list_schools()
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('*');
		$DB1->from('school_master');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
			$DB1->where('is_active','Y');
        	$query=$DB1->get();
      //  	echo $DB1->last_query();
        
        $result=$query->result_array();
        //echo $result[$fieldname];
        //	exit(0);
        return $result;
        
    }
    
    
        function provisional_edu_det($stdid)
    {
        
        $DB1 = $this->load->database('icdb', TRUE);
		$DB1->select('*');
		$DB1->from('provisional_education_detail');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
			$DB1->where('adm_id',$stdid);
        	$query=$DB1->get();
      //  	echo $DB1->last_query();
        
        $result=$query->result_array();
        //echo $result[$fieldname];
        //	exit(0);
        return $result;
        
    }
    
        function provisional_fee_det($stdid)
    {
        
        $DB1 = $this->load->database('icdb', TRUE);
		$DB1->select('pad.*,sum(pfd.amount) as amtpaid');
		$DB1->from('provisional_admission_details pad');
		$DB1->join('provisional_fees_details as pfd','pad.adm_id = pfd.student_id','left');
		$DB1->where('pad.adm_id',$stdid);
		$DB1->where('pfd.type_id','2');
        $query=$DB1->get();
      //  	echo $DB1->last_query();
        
        $result=$query->row_array();
        //echo $result[$fieldname];
        //	exit(0);
        return $result;
        
    }
    
    
    function entrance_exam_master()
    {
           $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('*');
		$DB1->from('entrance_exam_master');
		$DB1->where('status','Y');
        	$query=$DB1->get();
      //  	echo $DB1->last_query();
        
        $result=$query->result_array();
        //echo $result[$fieldname];
        //	exit(0);
        return $result; 
        
        
        
        
    }
    
    
     
    
    
    function getschool_course($school=''){
         $DB1 = $this->load->database('umsdb', TRUE); 
		 $sql="SELECT DISTINCT(course_id),course_name,course_short_name FROM vw_stream_details";
			if($school !='')
			{
				$sql .=" where school_id = $school"; 
			}
        $query = $DB1->query($sql);
        return $query->result_array();
    }
    
   
           function getcourse_streams($course=''){
         $DB1 = $this->load->database('umsdb', TRUE); 
	//	$sql="SELECT DISTINCT(course_id),course_name,course_short_name FROM vw_stream_details";
		$DB1->select("*");
		$DB1->from('vw_stream_details');
		if($course!='')
		{
	$DB1->where("course_id",$course);	    		    
		}
	$DB1->where("is_active",'Y');	    
        $query = $DB1->get();
        return $query->result_array();
    }
     
    
    
    
    //jugal ends
    
    
    
    	function searchforcanc($data){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,cm.course_name,adm.actual_fee,adm.applicable_fee");
		$DB1->from('student_master as sm');
		$DB1->join('admission_details as adm','sm.stud_id = adm.student_id','left');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
			$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		
		//if($data['prn']!='')
	//	{
			$DB1->where("sm.enrollment_no",$data['prn']);	    
    //	}
    	
    	
	
	//	$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
	// echo $DB1->last_query();
	//	exit(0);
		$result=$query->row_array();
		$result['total_fee']=$this->fetch_total_fee_paid($result['stud_id']);
		//echo $this->db->last_query();
		
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
    
    
    
    
    
    	function searchforcanc1($data){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,cm.course_name,adm.actual_fee,adm.applicable_fee,sac.is_cancelled as cancelreq");
		$DB1->from('student_master as sm');
		$DB1->join('admission_details as adm','sm.stud_id = adm.student_id','left');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
			$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
			$DB1->join('students_adm_cancel_lists as sac','sac.student_id = sm.stud_id','left');
		
	//	if($data['prn']!='')
	//	{
			$DB1->where("sm.enrollment_no",$data['prn']);	    
    //	}
    	
    	
	
	//	$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
	// echo $DB1->last_query();
	//	exit(0);
		$result=$query->row_array();
		if($result['stud_id']!=''){
			$result['total_fee']=$this->fetch_total_fee_paid($result['stud_id']);
		}
//		$result['total_fee']=$this->fetch_total_fee_paid($result['stud_id']);
		//echo $this->db->last_query();
		
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
    
    
    
    
    
    
    
    
    
    
    
    	function searchStudentsajax($data){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,cm.course_name");
		$DB1->from('student_master as sm');
		//$DB1->join('tmp_student_change_stream as tems','tems.stud_id = sm.stud_id','left');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		//$DB1->join('tmp_student_change_stream as tems1','tems1.tmp_id=(select max(tmp_id) from tmp_student_change_stream )');
		// /$DB1->group_by('tems.stud_id');

		//$DB1->order_by('tems.tmp_id', 'DESC');
		
		
		if($data['prn']!='')
		{
			$DB1->where("sm.enrollment_no",trim($data['prn']));	   
			$DB1->or_where("sm.enrollment_no_new",trim($data['prn']));	    
    	}
    	//$DB1->where("tems.tmp_id=(select max(tmp_id) from tmp_student_change_stream)");
    	
    		if($data['fnum']!='')
		{
			$DB1->where("sm.form_number",$data['fnum']);	    
    	}
    	
    	
			if($data['mobile']!='')
		{
			$DB1->where("sm.mobile",trim($data['mobile']));	    
    	}
		
			if($data['fname']!='')
		{
			$DB1->like("sm.first_name",trim($data['fname']));	    
    	}
		
			if($data['mname']!='')
		{
			$DB1->like("sm.middle_name",trim($data['mname']));	    
    	}
		
			if($data['lname']!='')
		{
			$DB1->like("sm.last_name",trim($data['lname']));	    
    	}
			   	    
	   $where=" sm.enrollment_no!='' ";
	   $DB1->where($where);
	
		$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
	// echo $DB1->last_query();
	//exit(0);
		$result=$query->result_array();
	//echo $this->db->last_query();
		
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
    
    
    
    
    	function searchStudentfeedata1($streamid,$year,$academic_year){
    	    
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,cm.course_name,ad.*");
		$DB1->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
			$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
			$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	
			$DB1->where("sm.admission_stream",$streamid);
			
			$DB1->where("ad.year", $year);	   
		
			$DB1->where("ad.academic_year", $academic_year);	   	    
		$DB1->where("sm.cancelled_admission",'N');	 
		$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
	//	echo $DB1->last_query();
		//die();  
		$result=$query->result_array();
		 //echo $this->db->last_query();
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
    	    
    	    
    	    
    	    
    	    
    	    
    	    
    	    
	}
    
    
    
    
    
    function fee_exemption()
    {
        
		
        		    $DB1 = $this->load->database('umsdb', TRUE);
					
	$data['acdyear']= $_POST['academicyear'];
	$data['acourse']= $_POST['acourse'];
    $data['astream']= $_POST['astream'];
	$data['ayear']= $_POST['ayear'];
					
           $sid1 = implode(",",$_POST['lstd']);
   //var_dump($sid);
   $sid=array_map('intval', explode(',', $sid1));
        
        foreach($sid as $stuid)
        {
      // echo $stuid.">>".$_POST[$stuid."_actual"]."**".$_POST[$stuid."_exem"]."@".$_POST[$stuid."_scholarship"]."|".$_POST['fayear']; 
           
        $tempe['actual_fee']=$_POST[$stuid."_actual"];
        $tempe['applicable_fee']=$_POST[$stuid."_actual"]-$_POST[$stuid."_exem"];
		
		$tempe['concession_type']=$_POST[$stuid."_scholarship"];
		$tempe['duration']=$_POST[$stuid."_duration"];
		$tempe['concession_remark']=$_POST[$stuid."_remark"];
		if($_POST[$stuid."_scholarship"]!=''){
		$tempe['fees_consession_allowed']='Y';
		}
		
		
        $DB1->where('academic_year', $_POST['fayear']);
        $DB1->where('student_id', $stuid);
	    $DB1->update('admission_details',$tempe);
		
        $fcd['actual_fees']=$_POST[$stuid."_actual"];
        $fcd['fees_paid_required']=$_POST[$stuid."_appli"];
        $fcd['exepmted_fees']=$_POST[$stuid."_exem"];
		
		$fcd['concession_type']=$_POST[$stuid."_scholarship"];
		$fcd['duration']=$_POST[$stuid."_duration"];
		$fcd['concession_remark']=$_POST[$stuid."_remark"];
		
        $DB1->where('academic_year', $_POST['fayear']);
        $DB1->where('student_id', $stuid);
        $DB1->update('fees_consession_details',$fcd);
	
	
	
	
        }
		//exit();
       // echo '<script>alert("Fees updated successfully for selected students");<script>';
         redirect("ums_admission/stud_feelist/".$data['acdyear'].'/'.$data['acourse'].'/'.$data['astream'].'/'.$data['ayear']);
        //return 1;
     //   var_dump($sid);
       // exit(0);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    //changes end
	//get admission year for courses offered by college
	function getCourseYRClg($col_id=1){
		$arr = array(1=>array('FE','SE','ME-I','Phd-I'));
		return $arr[$col_id];
    }
	//get Quota
	function getQuota(){
		$sql="SELECT quota_code,quota_name FROM quota_master WHERE status='Y'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	function getbranch(){
		$sql="SELECT branch_id,branch_code,branch_name FROM branch_master WHERE status='Y'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	function getdocumentlist(){
	     $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="select document_id,document_name from document_master where status='y'";
		$query=$DB1->query($sql);
		return $query->result_array();
	}
	function getdocumentNameById($id){
		$sql="select document_name from document_master where document_id='$id' and status='y'";
		$query=$this->db->query($sql);
		//echo $query;
		$result=$query->result_array();
		/* print_r($result);
		die(); */
		return $result;
	}

	function getreligionlist(){
		$sql="select rel_code,rel_name from religion_master where status='y'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	function student_registration($data){
		//echo "in student registration function";
		/* echo $stid;
		echo"<pre>";
		print_r($data);
		echo"</pre>";
			die();  */
	  //  $temp['student_id']=stripcslashes($stid);
		//Admission for
		$temp['admission-course']=stripslashes(($data['admission-course'])); 	
		//course
		$temp['admission-branch']=stripslashes(($data['admission-branch'])); 	
		//student name
		$temp['fname']= strtoupper(stripslashes(($data['sfname']))); 		
		$temp['mname']=strtoupper(stripslashes(($data['smname']))); 		
		$temp['lname']=strtoupper(stripslashes(($data['slname']))); 
        
		$temp['gender']=stripslashes(($data['gender'])); 
		$temp['dob']=stripslashes(($data['dob'])); 
		$temp['mobile']=stripslashes(($data['mobile'])); 
		$temp['email_id']=stripslashes(($data['email_id'])); 
		$temp['nationality']=stripslashes(($data['nationality'])); 
		$temp['caste']=stripslashes(($data['category']));  
		//$temp['sub_caste']=stripslashes(($data['sub_caste']));  
		$temp['religion']=stripslashes(($data['religion'])); 
		$temp['aadhar_no']=stripslashes(($data['saadhar'])); 
		$temp['res_state']=stripslashes(($data['res_state'])); 
		$temp['hostelfacility']=stripslashes(($data['hostel'])); 
		$temp['transportfacility']=stripslashes(($data['transport'])); 
		$temp['bording_point']=stripslashes(($data['bording_point'])); 
		//student Husband/father name
        $address['student_id']=stripcslashes($stid);		
		$address['pfname']=strtoupper(stripslashes(($data['sfname1']))); 		
		$address['pmname']=strtoupper(stripslashes(($data['smname1']))); 		
		$address['plname']=strtoupper(stripslashes(($data['slname1']))); 
         // student mother name		
		$address['mothernm']=strtoupper(stripslashes(($data['sfname2']))); 
		/***Address details***/
		//local address bill_A
		$address['lhouseno']=stripslashes(($data['laddress'])); 
//		$address['lstreet']=stripslashes(($data['bill_B'])); 
		
		$address['lstate']=stripslashes(($data['lstate_id'])); 
		$address['lcity']=stripslashes(($data['lcity'])); 
		$address['ldistrict']=stripslashes(($data['ldistrict_id'])); 	
		//$address['lcountry']=stripslashes(($data['bill_country'])); 
		$address['lpostal']=stripslashes(($data['bill_pc']));
         // permenant	address	
         
         
		$address['phouseno']=stripslashes(($data['paddress'])); 
		//$address['pstreet']=stripslashes(($data['shipping_B'])); 
			$address['pdistrict']=stripslashes(($data['ldistrict_id'])); 
		$address['pcity']=stripslashes(($data['shipping_C'])); 
		$address['pstate']=stripslashes(($data['shipping_D'])); 
	//	$address['pcountry']=stripslashes(($data['shipping_country'])); 
		$address['ppostal']=stripslashes(($data['shipping_pc'])); 
		$address['same']=stripslashes(($data['same'])); 
		
		//Guardians details  parent_details
		  $guardian['student_id']=stripcslashes($stid);
		$guardian['gfname']=strtoupper(stripslashes(($data['fname']))); 
		$guardian['gmname']=strtoupper(stripslashes(($data['mname']))); 
		$guardian['glname']=strtoupper(stripslashes(($data['lname']))); 
		$guardian['grelationship']=stripslashes(($data['relationship'])); 
		$guardian['goccupation']=stripslashes(($data['occupation'])); 
		$guardian['gannual_income']=stripslashes(($data['annual_income'])); 
		$guardian['gparent_email']=stripslashes(($data['parent_email'])); 
		$guardian['gparent_mobile']=stripslashes(($data['parent_mobile'])); 
		$guardian['gparent_phone']=stripslashes(($data['parent_phone'])); 
		$guardian['gparent_address']=stripslashes(($data['parent_address']));
		
	    $res1=$this->db->insert('student_registration_part1',$temp);
		$insert_id1 = $this->db->insert_id();
		$res2=$this->db->insert('personal_details',$address);
		$insert_id2 = $this->db->insert_id();
		$res3=$this->db->insert('parent_details',$guardian);
		$insert_id3 = $this->db->insert_id();
		$query1="insert into student_formfill_status(student_id)values('$stid')";
		$res=$this->db->query($query1);
		if(!empty($insert_id1)&&$insert_id1!=0){
			$update_flag="UPDATE `student_formfill_status` SET step_first_flag=1 where student_id='$stid'";
			$res_flg=$this->db->query($update_flag);
			}
		echo $insert_id1;
		echo $insert_id2;
		echo $insert_id3;
		return $insert_id1;
	}
	
	
	
	
		function demo_student_registration_ums($data,$arr1,$arr2){
		     $DB1 = $this->load->database('umsdb', TRUE); 
		//echo "in student registration function";
		/* echo $stid;
		echo"<pre>";
		print_r($data);
		echo"</pre>";
			die();  */
	//    $temp['student_id']=stripcslashes($stid);
		//Admission for
		
		
	//	var_dump($_FILES);
			 if(!empty($_FILES['profile_img']['name'])){
				 $filenm=$student_id.'-'.time().'-'.$_FILES['profile_img']['name'];
                $config['upload_path'] = 'uploads/student_profilephotos/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('profile_img')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    $picture = '';
                }
            }
			else{
                $picture = '';
            }
		
		
		
		
		
		if(!empty($_FILES['payfile']['name'])){
				 $filenm=$student_id.'-'.$_FILES['payfile']['name'];
                $config['upload_path'] = 'uploads/student_challans/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('payfile')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    $payfile = '';
                }
            }
			else{
                $payfile = '';
            }
		
		
		/*
		
		
		
		
		*/
		
		
		
		
		
		
		
		
		
		
	//	exit(0);
		$temp['admission_school']=$this->Ums_admission_model->getschool_bycourse($data['admission-branch']); 	
		$temp['enrollment_no']=$this->Ums_admission_model->generateprn($data['admission-branch'],$data['acyear'],$data['admission_type']); 
	$prnj =	$temp['enrollment_no_new']=$this->Ums_admission_model->generateprn_new($data['admission-branch'],$data['acyear'],$data['admission_type']); 

		//($stream_id)
		//course
		$temp['admission_stream']=stripslashes(($data['admission-branch'])); 	
		//student name
		$temp['first_name']=strtoupper(stripslashes(($data['sfname']))); 		
		$temp['middle_name']=strtoupper(stripslashes(($data['smname']))); 		
		$temp['last_name']=strtoupper(stripslashes(($data['slname']))); 
        
		$temp['gender']=stripslashes(($data['gender'])); 
		$temp['blood_group']=stripslashes(($data['blood_gr'])); 
		$temp['dob']=stripslashes(($data['dob']));
		
		$temp['sub_caste']=stripslashes(($data['subcaste']));
		$temp['admission_date']=stripslashes(($data['doadd']));
		
		
		
		$temp['birth_place']=stripslashes(($data['pob']));  
		$temp['mobile']=stripslashes(($data['mobile'])); 
		$temp['email']=stripslashes(($data['email_id'])); 
		$temp['nationality']=stripslashes(($data['nationality'])); 
		$temp['category']=stripslashes(($data['category']));  
		//$temp['sub_caste']=stripslashes(($data['sub_caste']));  
		$temp['religion']=stripslashes(($data['religion'])); 
		$temp['adhar_card_no']=stripslashes(($data['saadhar'])); 
		$temp['domicile_status']=stripslashes(($data['res_state'])); 
		
		
								$temp['is_defence']=isset($data['defperson']) ? Y : 'N'; 		
		$temp['is_JKMigrant']= isset($data['jk']) ? Y : 'N'; //strtoupper(stripslashes(($data['slname1']))); 
		
			$temp['physically_handicap']= isset($data['pwd']) ? Y : 'N';
		
			$temp['general_reg_no']=strtoupper(stripslashes(($data['sgrn']))); 		
		$temp['last_institute']=strtoupper(stripslashes(($data['linst']))); 
		
		//$temp['hostelfacility']=stripslashes(($data['hostel'])); 
		//$temp['transportfacility']=stripslashes(($data['transport'])); 
	//	$temp['bording_point']=stripslashes(($data['bording_point'])); 
		//student Husband/father name
       // $temps['enrollment_no']=stripcslashes($stid);	
      //	$temp['academic_year']= date('Y');
       $temp['academic_year']= stripslashes(($data['acyear']));
        $temp['admission_session']= stripslashes(($data['acyear']));
        
       	$admission_type=stripslashes(($data['admission_type']));
       	
       if($admission_type==1)
       {
        	$temp['admission_year']='1';    
        	$temp['admission_semester']='1';
        	$temp['lateral_entry']='N';
        	$temp['current_semester']='1';
       }
       else
       {
           $temp['admission_year']='2';    
        	$temp['admission_semester']='3';
        	$temp['lateral_entry']='Y';
        	$temp['current_semester']='3';
       }
       
      $temp['entry_from_ip']= $_SERVER['REMOTE_ADDR'];
      $temp['created_on']= date('Y-m-d');
      $temp['created_by']= $_SESSION['uid'];
		$temp['father_fname']=strtoupper(stripslashes(($data['sfname1']))); 		
		$temp['father_mname']=strtoupper(stripslashes(($data['smname1']))); 		
		$temp['father_lname']=strtoupper(stripslashes(($data['slname1']))); 
         // student mother name		
		$temp['mother_name']=strtoupper(stripslashes(($data['sfname2']))); 
			$temp['student_photo_path']=$picture;
			$temp['about_uni_know']=implode(",",$data['publicitysandip']);//$temp=implode("/ ",$mstatus); 
		/***Address details***/
		//local address bill_A
		
		 	 $temp['form_number']=$data['sfnumber'];
	  
		
		//Guardians details  parent_details
		
	
		
	    $DB1->insert('demo_student_master',$temp);
	     
		$insert_id1 = $DB1->insert_id();
		
	      $address['adds_of']='STUDENT'; 
		$address['address_type']='CORS'; 
		$address['address']=stripslashes(($data['laddress'])); 
	//	$address['street']=stripslashes(($data['bill_B'])); 
		$address['city']=stripslashes(($data['lcity'])); 
		$address['state_id']=stripslashes(($data['lstate_id'])); 
		$address['district_id']=stripslashes(($data['ldistrict_id'])); 
		$address['pincode']=stripslashes(($data['lpincode']));
		$address['student_id']=$insert_id1;	
		
		$DB1->insert('demo_address_details',$address);
	     
	//	$insert_id1 = $this->db->insert_id();
		
		
		
		//fee and ins details
		
		
		
		
		
		
		
         // permenant	address	
	    $paddress['adds_of']='STUDENT'; 
		$paddress['address_type']='PERMNT'; 
		$paddress['address']=stripslashes(($data['paddress'])); 
	//	$paddress['street']=stripslashes(($data['bshipping_B'])); 
		$paddress['city']=stripslashes(($data['pcity'])); 
		$paddress['state_id']=stripslashes(($data['pstate_id'])); 
		$paddress['district_id']=stripslashes(($data['pdistrict_id'])); 
		$paddress['pincode']=stripslashes(($data['ppincode']));
		$paddress['student_id']=$insert_id1;	
			$DB1->insert('demo_address_details',$paddress);
		
		
		
		
		 $gpaddress['adds_of']='PARENT'; 
		$gpaddress['address_type']='PERMNT'; 
	    $gpaddress['student_id']=$insert_id1;
	 		$gpaddress['address']=stripslashes(($data['gparent_address'])); 
	//	$paddress['street']=stripslashes(($data['bshipping_B'])); 
		$gpaddress['city']=stripslashes(($data['gcity'])); 
		$gpaddress['state_id']=stripslashes(($data['gstate_id'])); 
		$gpaddress['district_id']=stripslashes(($data['gdistrict_id'])); 
		$gpaddress['pincode']=stripslashes(($data['gpincode']));
			$DB1->insert('demo_address_details',$gpaddress);
	
			$insert_id2 = $DB1->insert_id();
	 
	 

	 $guardian['student_id']=stripcslashes($insert_id1);
			//   $guardian['enrollement_no']=stripcslashes($stid);
		$guardian['gfirst_name']=strtoupper(stripslashes(($data['fname']))); 
		$guardian['gmiddle_name']=strtoupper(stripslashes(($data['mname']))); 
		$guardian['glast_name']=strtoupper(stripslashes(($data['lname']))); 
		$guardian['relation']=stripslashes(($data['relationship'])); 
		$guardian['occupation']=stripslashes(($data['occupation'])); 
		$guardian['income']=stripslashes(($data['annual_income'])); 
		$guardian['parent_email']=stripslashes(($data['parent_email'])); 
		$guardian['parent_mobile2']=stripslashes(($data['parent_mobile'])); 
		$guardian['parent_mobile1']=stripslashes(($data['parent_phone'])); 
		$guardian['address_id']=stripslashes($insert_id2);
	    	$DB1->insert('demo_parent_details',$guardian);
	    //echo $DB1->last_query();
	    //	exit(0);
	    //	var_dump($_FILES['sss_doc']);
	    	
	    	if(count($data['exam_id'])>0)
	    	{
	    	for($i=0;$i<count($data['exam_id']);$i++)
	    	
	    	{
	    	    
	    	    $exam['student_id']=$insert_id1;
				$exam['degree_type']=$data['exam_id'][$i]; 
	 			$exam['degree_name']=$data['stream_name'][$i]; 
	 			$exam['specialization']=$data['seat_no'][$i];
	 			$exam['board_uni_name']=$data['institute_name'][$i]; 
	 			$exam['passing_year']=$data['pass_month'][$i]."-".$data['pass_year'][$i];
	 			$exam['total_marks']=$data['marks_obtained'][$i];
	 			$exam['out_of_marks']=$data['marks_outof'][$i];
	 			$exam['percentage']=$data['percentage'][$i]; 
	 		//	$exam['degree_type']=$data['exam_id'][$i]['degree_type']; 
	 		
	 		 
	 	//	 var_dump($_FILES['sss_doc']);
	 	//	 exit(0);
	 	/*	
	 		 if(!empty($_FILES['sss_doc']['name'])){
				 $filenm=$student_id.'-'.$_FILES['sss_doc']['name'][$i];
                $config['upload_path'] = 'uploads/student_profilephotos/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('sss_doc')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    $picture = '';
                }
            }
			else{
                $picture = '';
            }
	 		*/
	 		
	 		 $picture='';
	 		$key =$i;
	 		
	 		
	 	
	 		
	 		
	 		
	 		
	 		
	 		
	 		
	 		
	 
	 		
	 		
	 		
	 		
	 		
	 		
	 	//	echo "j";
	 		//var_dump($arr2[0]);
	 	//	echo "k";
				if(!empty($arr2[$i]) && $arr2[$i] !=''){
					$exam['file_path']= $arr2[$i];
				}
	 		
	 	//	echo $arr2[$i];
	 		
	 		
	 		
	 		
	 		
	 		

			$DB1->insert('demo_student_qualification_details',$exam);
			
		//	echo ">>".$DB1->last_query();
	    	    
	    	    	$insert_ide = $DB1->insert_id();
	    	//    echo $data['tssc_eng'];
	    	    if($data['exam_id'][$i]=='SSC')
	    	    {
	    	        
	    	         $exam2['student_id']=$insert_id1;
	    	          $exam2['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam2['sub_sem_name']='English';
	 			$exam2['marks_obt']=$data['tssc_eng'];
	 			$exam2['marks_outof']=$data['ossc_eng']; 
	 			$exam2['passing_year']=$data['sscpass_date'];
	 			
	    	       	$DB1->insert('demo_student_qualifying_exam_details',$exam2); 
	    	     //  	echo $DB1->last_query();
	    	        
	    	    }
	    	    if(($data['exam_id'][$i]=='HSC'))
	    	    {
	    	        
	    	        if(($data['exam_id'][$i]=='HSC') && ($data['stream_name'][$i]=='Science'))
	    	        {
	    	            
	    	  $exam3['student_id']=$insert_id1;
	    	          $exam3['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam3['sub_sem_name']='English';
	 			$exam3['marks_obt']=$data['thsc_eng'];
	 			$exam3['marks_outof']=$data['ohsc_eng']; 
	 			$exam3['passing_year']=$data['hscpass_date'];
	 			
	    	       	$DB1->insert('demo_student_qualifying_exam_details',$exam3); 
	    	       	
	    	       	
	    	       		  $exam3['student_id']=$insert_id1;
	    	          $exam3['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam3['sub_sem_name']='Physics';
	 			$exam3['marks_obt']=$data['thsc_phy'];
	 			$exam3['marks_outof']=$data['ohsc_phy']; 
	 		//	$exam3['passing_year']=$data['hscpass_date'][$i];
	 			
	    	       	$DB1->insert('demo_student_qualifying_exam_details',$exam3); 
	    	       	
	    	       		  $exam3['student_id']=$insert_id1;
	    	          $exam3['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam3['sub_sem_name']='Chemistry';
	 			$exam3['marks_obt']=$data['thsc_chem'];
	 			$exam3['marks_outof']=$data['ohsc_chem']; 
	 		//	$exam3['passing_year']=$data['hscpass_date'][$i];
	 			
	    	       	$DB1->insert('demo_student_qualifying_exam_details',$exam3); 
	    	       	
	    	       	
	    	       	 $exam3['student_id']=$insert_id1;
	    	          $exam3['qual_id']=$insert_ide;
	    	          	$exam3['sub_sem_name']='Maths';
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	 			$exam3['marks_obt']=$data['thsc_maths'];
	 			$exam3['marks_outof']=$data['ohsc_maths']; 
	 		//	$exam3['passing_year']=$data['hscpass_date'][$i];
	 			
	    	       	$DB1->insert('demo_student_qualifying_exam_details',$exam3); 
	    	       	
	    	       	
	    	       	
	    	       		  $exam3['student_id']=$insert_id1;
	    	          $exam3['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam3['sub_sem_name']='Biology';
	 			$exam3['marks_obt']=$data['thsc_bio'];
	 			$exam3['marks_outof']=$data['ohsc_bio']; 
	 		//	$exam3['passing_year']=$data['hscpass_date'][$i];
	 			
	    	       	$DB1->insert('demo_student_qualifying_exam_details',$exam3); 
	    	       	
	    	       		 
	    	       		
	    	       	
	    	       	
	    	       	
	    	       	
	    	       	
	    	       	
	    	       	
	    	       	
	    	       	
	    	        }
	    	        else
	    	        {
	    	            
	    	              $exam4['student_id']=$insert_id1;
	    	          $exam4['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam4['sub_sem_name']='English';
	 			$exam4['marks_obt']=$data['thsc_eng'];
	 			$exam4['marks_outof']=$data['ohsc_eng']; 
	 			$exam4['passing_year']=$data['hscpass_date'];
	 			
	    	       	$DB1->insert('demo_student_qualifying_exam_details',$exam4); 
	    	        }
	    	        
	    	        
	    	        
	    	        
	    	    }
	    	     if($data['exam_id'][$i]=='Diploma')
	    	    {
	    	        
	    	        $exam5['student_id']=$insert_id1;
	    	          $exam5['qual_id']=$insert_ide;
	    	          	$exam5['sub_sem_name']='Sem 1';
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	 			$exam5['marks_obt']=$data['tdsem1_eng'];
	 			$exam5['marks_outof']=$data['odsem1_eng']; 
	 			$exam5['passing_year']=$data['dsem1pass_date'];
	 			
	    	       	$DB1->insert('demo_student_qualifying_exam_details',$exam5); 
	    	       	
	    	       	  $exam5['student_id']=$insert_id1;
	    	          $exam5['qual_id']=$insert_ide;
	    	          	$exam5['sub_sem_name']='Sem 2';
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	 			$exam5['marks_obt']=$data['tdsem2_eng'];
	 			$exam5['marks_outof']=$data['odsem2_eng']; 
	 			$exam5['passing_year']=$data['dsem2pass_date'];
	 			
	    	       	$DB1->insert('demo_student_qualifying_exam_details',$exam5); 
	    	       	
	    	       	
	    	       	  $exam5['student_id']=$insert_id1;
	    	          $exam5['qual_id']=$insert_ide;
	    	          	$exam5['sub_sem_name']='Sem 3';
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	 			$exam5['marks_obt']=$data['tdsem3_eng'];
	 			$exam5['marks_outof']=$data['odsem3_eng']; 
	 			$exam5['passing_year']=$data['dsem3pass_date'];
	 			
	    	       	$DB1->insert('demo_student_qualifying_exam_details',$exam5); 
	    	       	
	    	       	  $exam5['student_id']=$insert_id1;
	    	          $exam5['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam5['sub_sem_name']='Sem 4';
	 			$exam5['marks_obt']=$data['tdsem4_eng'];
	 			$exam5['marks_outof']=$data['odsem4_eng']; 
	 			$exam5['passing_year']=$data['dsem4pass_date'];
	 			
	    	       	$DB1->insert('demo_student_qualifying_exam_details',$exam5); 
	    	       	
	    	       	  $exam5['student_id']=$insert_id1;
	    	          $exam5['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam5['sub_sem_name']='Sem 5';
	 			$exam5['marks_obt']=$data['tdsem5_eng'];
	 			$exam5['marks_outof']=$data['odsem5_eng']; 
	 			$exam5['passing_year']=$data['dsem5pass_date'];
	 			
	    	       	$DB1->insert('demo_student_qualifying_exam_details',$exam5); 
	    	       	
	    	       	  $exam5['student_id']=$insert_id1;
	    	          $exam5['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam5['sub_sem_name']='Sem 6';
	 			$exam5['marks_obt']=$data['tdsem6_eng'];
	 			$exam5['marks_outof']=$data['odsem6_eng']; 
	 			$exam5['passing_year']=$data['dsem6pass_date'];
	 			
	    	       	$DB1->insert('demo_student_qualifying_exam_details',$exam5); 
	    	       	
	    	    }
	    	    
	    	    
	    	    
	    	    
	    	}
	    	}
	    	
	    //	exit(0);
	   if(!empty($data['suexam-name']) && $data['suexam-name']!='') 	
	    {
	     
	       	  $suexam['student_id']=$insert_id1;
	       	    $suexam['entrance_exam_type']=$data['examtype'];
	    	          $suexam['entrance_exam_name']=$data['suexam-name'];
	    	     $suexam['passing_year']=$data['supass_month']."-".$data['supass_year']; 
	 			$suexam['register_no']=$data['suenrolment'];
	 			$suexam['marks_obt']=$data['sumarks']; 
	 			$suexam['marks_outof']=$data['sutotal'];
	 			$suexam['percentage']=$data['super'];
	    	       	$DB1->insert('demo_student_entrance_exam',$suexam);    
	  
	    }	
	    if(!empty($data['exam-name']) && $data['exam-name']!='') 	
	    {	
			for($i=0;$i<count($data['exam-name']);$i++)	
			{
			 
				  $suexam['student_id']=$insert_id1;
						  $suexam['entrance_exam_type']=$data['exam-name'][$i];
						  $suexam['entrance_exam_name']=$data['other_exam-name'][$i];
						  
					 $suexam['passing_year']=$data['pass_month'][$i]."-".$data['pass_year'][$i]; 
					$suexam['register_no']=$data['enrolment'][$i];
					$suexam['marks_obt']=$data['marks'][$i]; 
					$suexam['marks_outof']=$data['totalmarks'][$i];
					$suexam['percentage']=$data['ent_percentage'][$i];
						$DB1->insert('demo_student_entrance_exam',$suexam);    
						
					   //	echo $DB1->last_query();
		  
			}
		}			
	    
	//    echo "jugal";
	//    exit(0);
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    //	$temp['academic_year']= date('Y');
       
   
      $feedet['entry_from_ip']= $_SERVER['REMOTE_ADDR'];
      $feedet['created_on']= date('Y-m-d');
      $feedet['created_by']= $_SESSION['uid'];
      
      
	     
	       	  $feedet['student_id']=$insert_id1;
	    	          $feedet['amount']=$data['totalfeepaid'];
	    	            $feedet['type_id']=2;
	    	            $feedet['fees_paid_type']=$data['payment_type'];
	    	             $feedet['academic_year']= stripslashes(($data['acyear']));
	    	            	
	    //	     $exam['passing_year']=$data['supass_month']."-".$data['supass_year']; fees_paid_type
	 			$feedet['receipt_no']=$data['dd_no'];
	 			$feedet['fees_date']=$data['dd_date']; 
	 			$feedet['bank_id']=$data['dd_bank'];
	 			$feedet['bank_city']=$data['dd_bank_branch'];
	 			$feedet['receipt_file']=$payfile;
	    	     //  	$DB1->insert('fees_details',$feedet);   
	    	      // 	$insert_feid1 = $DB1->insert_id();
	        
	          $sbank['student_id']=$insert_id1;
	    	          $sbank['account_no']=$data['account_no'];
	    //	     $exam['passing_year']=$data['supass_month']."-".$data['supass_year']; 
	 			$sbank['ifsc_code']=$data['ifsc'];
	 			$sbank['bank_name']=$data['bank_name']; 
	 
	 			$sbank['bank_city']=$data['bank_branch'];
	    	       	$DB1->insert('demo_student_bank_details',$sbank);   
	    	       	
	    	       	if($data['exepmted_fee']>0)
	    	       	{
	    	       	 $fcdetails['concession_type']='Schlorship';
	    	       	 $fcdetails['student_id']=$insert_id1;
	    	       	    $fcdetails['academic_year']=stripslashes(($data['acyear']));
	    	       	    
	    	       	    
	    	       	  $fcdetails['actual_fees']=$data['acd_totalfee'];
	    	       	  
	    	       	   $fcdetails['exepmted_fees']=$data['exepmted_fee'];
	    	       	    $fcdetails['fees_paid_required']=$data['totalfeeappli'];
	    	       	
	    	       	      	  $fcdetails['allowed_by']='Admin';
	    	            $fcdetails['created_on']= date("Y-m-d H:i:s");
      $fcdetails['created_by']= $_SESSION['uid'];
	    	         //   $fcdetails['fees_paid_type']=$data['payment_type'];
	    	          
	    	       	
	    	       	
	    	       	
	    	       		$DB1->insert('demo_fees_consession_details',$fcdetails);   
	    	       	
	    	       	}
	    	       	
	    	       	
	    	       	
	    	       		 	
   
	    	       	
	    	       	
	    	       		// $admdetails['concession_type']='Schlorship';
	    	       	 $admdetails['student_id']=$insert_id1;
	    	       	    $admdetails['school_code']=$this->Ums_admission_model->getschool_bycourse($data['admission-branch']);
	    	       	    $admdetails['stream_id']=stripslashes(($data['admission-branch']));
	    	       	    
	    	       	        if($admission_type==1)
       {
        	$admdetails['year']='1';    
        
       }
       else
       {
          	$admdetails['year']='2';     
        
       }
	    	       	   // $admdetails['year']=date('Y');
	    	       	    $admdetails['academic_year']= stripslashes(($data['acyear']));
	    	       	   // $admdetails['school_code']=date('Y');
	    	       	    
	    	       	  $admdetails['actual_fee']=$data['acd_totalfee'];
	    	       	  
	    	       	   $admdetails['applicable_fee']=$data['totalfeeappli'];
	    	       	  //  $admdetails['fees_paid_required']=$data['totalfeepaid'];
	    	       	  if($data['totalfeeappli']==$data['totalfeepaid'])
	    	       	  {
	    	       	     $admdetails['total_fees_paid']='Y'; 
	    	       	      
	    	       	  }
	    	       	   if($data['exepmted_fee']>0)
	    	       	  {
	    	       	     $admdetails['fees_consession_allowed']='Y'; 
	    	       	     	 $admdetails['concession_type']='Scholarship';
	    	       	      
	    	       	  }
	    	       
	    	      
	    	       	  $admdetails['hostel_required']=$data['hostel'];
	    	       	   $admdetails['hostel_type']=$data['hosteltype'];
	    	       	    $admdetails['transport_required']=$data['transport'];
	    	       	     $admdetails['transport_boarding_point']=$data['bording_point'];
	    	       	      $admdetails['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
	    	       	      //	  $admdetails['allowed_by']='Admin';
	    	            $admdetails['created_on']= date("Y-m-d H:i:s");
      $admdetails['created_by']= $_SESSION['uid'];
	    	         //   $fcdetails['fees_paid_type']=$data['payment_type'];
	    	          
	    	       	
	    	       	
	    	       	
	    	       		$DB1->insert('demo_admission_details',$admdetails);  
	    	       	
	    	       //	echo $DB1->last_query();
	    	       	
	    	       	
	    	       	
	    	 
	    	          
	    	       	
	    	       	
	    	       	
	    	       	//	$DB1->insert('fees_installment_details',$fidetails);  
	        
	        
	        
	        
	        
	

	
	
	$temp['student_id']=$insert_id1;

		
		return $prnj;
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		function student_registration_ums($data,$arr1,$arr2){
		     $DB1 = $this->load->database('umsdb', TRUE); 
		     
		     
		     //poonam 
		     
		   $dupj =  $this->Ums_admission_model->chek_mob_exist($data['mobile']);
		    if($dupj[0]['mobile']!='')
		    {
		       //  echo "exist";
		        echo '<script>alert("Student Already Registered");window.location.href = "stud_list";</script>';
		        exit();
		    }
		   
		//echo "in student registration function";
		// echo $stid;
	//	echo"<pre>";
	//	print_r($data);
	//	echo"</pre>";
		//	die();  
	//    $temp['student_id']=stripcslashes($stid);
		//Admission for
	//	echo $_POST['adm_id'];
		//		exit();
		
	//	var_dump($_FILES);
			 if(!empty($_FILES['profile_img']['name'])){
				 $filenm=$student_id.'-'.time().'-'.$_FILES['profile_img']['name'];
                $config['upload_path'] = 'uploads/student_profilephotos/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('profile_img')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    $picture = '';
                }
            }
			else{
                $picture = '';
            }
		
		
		
		
		
		if(!empty($_FILES['payfile']['name'])){
				 $filenm=$student_id.'-'.$_FILES['payfile']['name'];
                $config['upload_path'] = 'uploads/student_challans/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('payfile')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    $payfile = '';
                }
            }
			else{
                $payfile = '';
            }
		
		
		/*
		
		
		
		
		*/
		
		
		
		
		
		
		
		
		
		
	//	exit(0);
	
	
		$temp['admission_school']=$this->Ums_admission_model->getschool_bycourse($data['admission-branch']); 
		
		if($_POST['adm_id']!='')
		{
		 	     $prnj =$temp['enrollment_no']=$_POST['adm_id'];   
		 		$temp['enrollment_no_new']=$_POST['adm_id'];   
		}
		else
		{
	$prnj =	$temp['enrollment_no_new']=$this->generateprn($data['admission-branch'],$data['acyear'],$data['admission_type']); 
	//echo "prnj";
	//echo $prnj;
	//echo "<br/>";

	$temp['enrollment_no']=$this->generateprn_new($data['admission-branch'],$data['acyear'],$data['admission_type']); 
	/*print_r($temp['enrollment_no']);
	die;*/
}
//echo 'PRN';
//print_r($temp['enrollment_no']);
//exit();
		//($stream_id)
		//course
		$temp['admission_stream']=stripslashes(($data['admission-branch'])); 	
		//student name
		$temp['first_name']=strtoupper(stripslashes(($data['sfname']))); 		
		$temp['middle_name']=strtoupper(stripslashes(($data['smname']))); 		
		$temp['last_name']=strtoupper(stripslashes(($data['slname']))); 
        
		$temp['gender']=stripslashes(($data['gender'])); 
		$temp['blood_group']=stripslashes(($data['blood_gr'])); 
		$temp['dob']=stripslashes(($data['dob']));
		
		$temp['birth_place']=stripslashes(($data['pob']));  
		$temp['mobile']=stripslashes(($data['mobile'])); 
		$temp['email']=stripslashes(($data['email_id'])); 
		$temp['nationality']=stripslashes(($data['nationality'])); 
		$temp['category']=stripslashes(($data['category']));  
		$temp['sub_caste']=stripslashes(($data['subcaste']));  
		$temp['religion']=stripslashes(($data['religion'])); 
		$temp['adhar_card_no']=stripslashes(($data['saadhar'])); 
		$temp['domicile_status']=stripslashes(($data['res_state']));
		$temp['admission_date']=$data['doadd'];		
		$temp['last_institute']=strtoupper(stripslashes(($data['linst']))); 
		//$temp['hostelfacility']=stripslashes(($data['hostel'])); 
		//$temp['transportfacility']=stripslashes(($data['transport'])); 
	//	$temp['bording_point']=stripslashes(($data['bording_point'])); 
		//student Husband/father name
       // $temps['enrollment_no']=stripcslashes($stid);	
      //	$temp['academic_year']= date('Y');
       $temp['academic_year']= stripslashes(($data['acyear']));
           $temp['admission_session']= stripslashes(($data['acyear']));
        
       	$admission_type=stripslashes(($data['admission_type']));
       	
       	
       	
       if($admission_type==1 || $admission_type=='')
       {
        	$temp['current_year']='1';    
        		$temp['admission_year']='1';    
        	$temp['admission_semester']='1';
        	$temp['lateral_entry']='N';
        	$temp['current_semester']='1';
       }
       if($admission_type==2)
       {
           	$temp['current_year']='2';  
           $temp['admission_year']='2';    
        	$temp['admission_semester']='3';
        	$temp['lateral_entry']='Y';
        	$temp['current_semester']='3';
       }
       
      $temp['entry_from_ip']= $_SERVER['REMOTE_ADDR'];
      $temp['created_on']= date("Y-m-d H:i:s");
      $temp['created_by']= $_SESSION['uid'];
		$temp['father_fname']=strtoupper(stripslashes(($data['sfname1']))); 		
		$temp['father_mname']=strtoupper(stripslashes(($data['smname1']))); 		
		$temp['father_lname']=strtoupper(stripslashes(($data['slname1']))); 
         // student mother name		
		$temp['mother_name']=strtoupper(stripslashes(($data['sfname2']))); 
			$temp['student_photo_path']=$picture;
			$temp['about_uni_know']=implode(",",$data['publicitysandip']);//$temp=implode("/ ",$mstatus); 
		/***Address details***/
		//local address bill_A
		
		 	 $temp['form_number']=$data['sfnumber'];
	  
		
		//Guardians details  parent_details
		
	
		
	    $DB1->insert('student_master',$temp);
	     
		$insert_id1 = $DB1->insert_id();
		
	      $address['adds_of']='STUDENT'; 
		$address['address_type']='CORS'; 
		$address['address']=stripslashes(($data['laddress'])); 
	//	$address['street']=stripslashes(($data['bill_B'])); 
		$address['city']=stripslashes(($data['lcity'])); 
		$address['state_id']=stripslashes(($data['lstate_id'])); 
		$address['district_id']=stripslashes(($data['ldistrict_id'])); 
		$address['pincode']=stripslashes(($data['lpincode']));
		$address['student_id']=$insert_id1;	
		
		$DB1->insert('address_details',$address);
	     
	//	$insert_id1 = $this->db->insert_id();
		
		
		
		//fee and ins details
		
		
		
		
		
		
		
         // permenant	address	
	    $paddress['adds_of']='STUDENT'; 
		$paddress['address_type']='PERMNT'; 
		$paddress['address']=stripslashes(($data['paddress'])); 
	//	$paddress['street']=stripslashes(($data['bshipping_B'])); 
		$paddress['city']=stripslashes(($data['pcity'])); 
		$paddress['state_id']=stripslashes(($data['pstate_id'])); 
		$paddress['district_id']=stripslashes(($data['pdistrict_id'])); 
		$paddress['pincode']=stripslashes(($data['ppincode']));
		$paddress['student_id']=$insert_id1;	
			$DB1->insert('address_details',$paddress);
		
		
		
		
		 $gpaddress['adds_of']='PARENT'; 
		$gpaddress['address_type']='PERMNT'; 
	    $gpaddress['student_id']=$insert_id1;
	 		$gpaddress['address']=stripslashes(($data['gparent_address'])); 
	//	$paddress['street']=stripslashes(($data['bshipping_B'])); 
		$gpaddress['city']=stripslashes(($data['gcity'])); 
		$gpaddress['state_id']=stripslashes(($data['gstate_id'])); 
		$gpaddress['district_id']=stripslashes(($data['gdistrict_id'])); 
		$gpaddress['pincode']=stripslashes(($data['gpincode']));
			$DB1->insert('address_details',$gpaddress);
	
			$insert_id2 = $DB1->insert_id();
	 
	 

	 $guardian['student_id']=stripcslashes($insert_id1);
			//   $guardian['enrollement_no']=stripcslashes($stid);
		$guardian['gfirst_name']=strtoupper(stripslashes(($data['fname']))); 
		$guardian['gmiddle_name']=strtoupper(stripslashes(($data['mname']))); 
		$guardian['glast_name']=strtoupper(stripslashes(($data['lname']))); 
		$guardian['relation']=stripslashes(($data['relationship'])); 
		$guardian['occupation']=stripslashes(($data['occupation'])); 
		$guardian['income']=stripslashes(($data['annual_income'])); 
		$guardian['parent_email']=stripslashes(($data['parent_email'])); 
		$guardian['parent_mobile2']=stripslashes(($data['parent_mobile'])); 
		$guardian['parent_mobile1']=stripslashes(($data['parent_phone'])); 
		$guardian['address_id']=stripslashes($insert_id2);
	    	$DB1->insert('parent_details',$guardian);
	    //echo $DB1->last_query();
	    //	exit(0);
	    //	var_dump($_FILES['sss_doc']);
	    	
	    	if(count($data['exam_id'])>0)
	    	{
	    	for($i=0;$i<count($data['exam_id']);$i++)
	    	
	    	{
	    	    if($data['exam_id'][$i] !='')
	    	    {
	    	    $exam['student_id']=$insert_id1;
				$exam['degree_type']=$data['exam_id'][$i]; 
	 			$exam['degree_name']=$data['stream_name'][$i]; 
	 			$exam['specialization']=$data['seat_no'][$i];
	 			$exam['board_uni_name']=$data['institute_name'][$i]; 
	 			$exam['passing_year']=$data['pass_month'][$i]."-".$data['pass_year'][$i];
	 			$exam['total_marks']=$data['marks_obtained'][$i];
	 			$exam['out_of_marks']=$data['marks_outof'][$i];
	 			$exam['percentage']=$data['percentage'][$i]; 
	 
	 		
	 		 $picture='';
	 		$key =$i;
	 		

	 		
	 	
				if(!empty($arr2[$i]) && $arr2[$i] !=''){
					$exam['file_path']= $arr2[$i];
				}
	 		
	 

			$DB1->insert('student_qualification_details',$exam);
			

	    	    
	    	    	$insert_ide = $DB1->insert_id();
	    	    }
	    /*
	    	    if($data['exam_id'][$i]=='SSC')
	    	    {
	    	        
	    	         $exam2['student_id']=$insert_id1;
	    	          $exam2['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam2['sub_sem_name']='English';
	 			$exam2['marks_obt']=$data['tssc_eng'];
	 			$exam2['marks_outof']=$data['ossc_eng']; 
	 			$exam2['passing_year']=$data['sscpass_date'];
	 			
	    	       	$DB1->insert('student_qualifying_exam_details',$exam2); 
	    	     //  	echo $DB1->last_query();
	    	        
	    	    }
	    	    if(($data['exam_id'][$i]=='HSC'))
	    	    {
	    	        
	    	        if(($data['exam_id'][$i]=='HSC') && ($data['stream_name'][$i]=='Science'))
	    	        {
	    	            
	    	  $exam3['student_id']=$insert_id1;
	    	          $exam3['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam3['sub_sem_name']='English';
	 			$exam3['marks_obt']=$data['thsc_eng'];
	 			$exam3['marks_outof']=$data['ohsc_eng']; 
	 			$exam3['passing_year']=$data['hscpass_date'];
	 			
	    	       	$DB1->insert('student_qualifying_exam_details',$exam3); 
	    	       	
	    	       	
	    	       		  $exam3['student_id']=$insert_id1;
	    	          $exam3['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam3['sub_sem_name']='Physics';
	 			$exam3['marks_obt']=$data['thsc_phy'];
	 			$exam3['marks_outof']=$data['ohsc_phy']; 
	 		//	$exam3['passing_year']=$data['hscpass_date'][$i];
	 			
	    	       	$DB1->insert('student_qualifying_exam_details',$exam3); 
	    	       	
	    	       		  $exam3['student_id']=$insert_id1;
	    	          $exam3['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam3['sub_sem_name']='Chemistry';
	 			$exam3['marks_obt']=$data['thsc_chem'];
	 			$exam3['marks_outof']=$data['ohsc_chem']; 
	 		//	$exam3['passing_year']=$data['hscpass_date'][$i];
	 			
	    	       	$DB1->insert('student_qualifying_exam_details',$exam3); 
	    	       	
	    	       	
	    	       	 $exam3['student_id']=$insert_id1;
	    	          $exam3['qual_id']=$insert_ide;
	    	          	$exam3['sub_sem_name']='Maths';
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	 			$exam3['marks_obt']=$data['thsc_maths'];
	 			$exam3['marks_outof']=$data['ohsc_maths']; 
	 		//	$exam3['passing_year']=$data['hscpass_date'][$i];
	 			
	    	       	$DB1->insert('student_qualifying_exam_details',$exam3); 
	    	       	
	    	       	
	    	       	
	    	       		  $exam3['student_id']=$insert_id1;
	    	          $exam3['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam3['sub_sem_name']='Biology';
	 			$exam3['marks_obt']=$data['thsc_bio'];
	 			$exam3['marks_outof']=$data['ohsc_bio']; 
	 		//	$exam3['passing_year']=$data['hscpass_date'][$i];
	 			
	    	       	$DB1->insert('student_qualifying_exam_details',$exam3); 
	    	       	
	    	       		 
	    	       		
	    	       	
	    	       	
	    	       	
	    	       	
	    	       	
	    	       	
	    	       	
	    	       	
	    	       	
	    	        }
	    	        else
	    	        {
	    	            
	    	              $exam4['student_id']=$insert_id1;
	    	          $exam4['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam4['sub_sem_name']='English';
	 			$exam4['marks_obt']=$data['thsc_eng'];
	 			$exam4['marks_outof']=$data['ohsc_eng']; 
	 			$exam4['passing_year']=$data['hscpass_date'];
	 			
	    	       	$DB1->insert('student_qualifying_exam_details',$exam4); 
	    	        }
	    	        
	    	        
	    	        
	    	        
	    	    }
	    	     if($data['exam_id'][$i]=='Diploma')
	    	    {
	    	        
	    	        $exam5['student_id']=$insert_id1;
	    	          $exam5['qual_id']=$insert_ide;
	    	          	$exam5['sub_sem_name']='Sem 1';
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	 			$exam5['marks_obt']=$data['tdsem1_eng'];
	 			$exam5['marks_outof']=$data['odsem1_eng']; 
	 			$exam5['passing_year']=$data['dsem1pass_date'];
	 			
	    	       	$DB1->insert('student_qualifying_exam_details',$exam5); 
	    	       	
	    	       	  $exam5['student_id']=$insert_id1;
	    	          $exam5['qual_id']=$insert_ide;
	    	          	$exam5['sub_sem_name']='Sem 2';
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	 			$exam5['marks_obt']=$data['tdsem2_eng'];
	 			$exam5['marks_outof']=$data['odsem2_eng']; 
	 			$exam5['passing_year']=$data['dsem2pass_date'];
	 			
	    	       	$DB1->insert('student_qualifying_exam_details',$exam5); 
	    	       	
	    	       	
	    	       	  $exam5['student_id']=$insert_id1;
	    	          $exam5['qual_id']=$insert_ide;
	    	          	$exam5['sub_sem_name']='Sem 3';
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	 			$exam5['marks_obt']=$data['tdsem3_eng'];
	 			$exam5['marks_outof']=$data['odsem3_eng']; 
	 			$exam5['passing_year']=$data['dsem3pass_date'];
	 			
	    	       	$DB1->insert('student_qualifying_exam_details',$exam5); 
	    	       	
	    	       	  $exam5['student_id']=$insert_id1;
	    	          $exam5['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam5['sub_sem_name']='Sem 4';
	 			$exam5['marks_obt']=$data['tdsem4_eng'];
	 			$exam5['marks_outof']=$data['odsem4_eng']; 
	 			$exam5['passing_year']=$data['dsem4pass_date'];
	 			
	    	       	$DB1->insert('student_qualifying_exam_details',$exam5); 
	    	       	
	    	       	  $exam5['student_id']=$insert_id1;
	    	          $exam5['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam5['sub_sem_name']='Sem 5';
	 			$exam5['marks_obt']=$data['tdsem5_eng'];
	 			$exam5['marks_outof']=$data['odsem5_eng']; 
	 			$exam5['passing_year']=$data['dsem5pass_date'];
	 			
	    	       	$DB1->insert('student_qualifying_exam_details',$exam5); 
	    	       	
	    	       	  $exam5['student_id']=$insert_id1;
	    	          $exam5['qual_id']=$insert_ide;
	    	    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
	    	    	$exam5['sub_sem_name']='Sem 6';
	 			$exam5['marks_obt']=$data['tdsem6_eng'];
	 			$exam5['marks_outof']=$data['odsem6_eng']; 
	 			$exam5['passing_year']=$data['dsem6pass_date'];
	 			
	    	       	$DB1->insert('student_qualifying_exam_details',$exam5); 
	    	       	
	    	    }
	    	    
	    */	    
	    	    
	    	    
	    	}
	    	}
	    	
/*
	   if(!empty($data['suexam-name']) && $data['suexam-name']!='') 	
	    {
	     
	       	  $suexam['student_id']=$insert_id1;
	       	    $suexam['entrance_exam_type']=$data['examtype'];
	    	          $suexam['entrance_exam_name']=$data['suexam-name'];
	    	     $suexam['passing_year']=$data['supass_month']."-".$data['supass_year']; 
	 			$suexam['register_no']=$data['suenrolment'];
	 			$suexam['marks_obt']=$data['sumarks']; 
	 			$suexam['marks_outof']=$data['sutotal'];
	 			$suexam['percentage']=$data['super'];
	    	       	$DB1->insert('student_entrance_exam',$suexam);    
	  
	    }	 */
	    if(!empty($data['exam-name']) && $data['exam-name']!='') 	
	    {	
			for($i=0;$i<count($data['exam-name']);$i++)	
			{
			 
				  $suexam['student_id']=$insert_id1;
						  $suexam['entrance_exam_name']=$data['exam-name'][$i];
						//  $suexam['entrance_exam_name']=$data['other_exam-name'][$i];
						  
					 $suexam['passing_year']=$data['pass_monthe'][$i]."-".$data['pass_yeare'][$i]; 
					$suexam['register_no']=$data['enrolment'][$i];
					$suexam['marks_obt']=$data['marks'][$i]; 
				//	$suexam['marks_outof']=$data['totalmarks'][$i];
				//	$suexam['percentage']=$data['ent_percentage'][$i];
						$DB1->insert('student_entrance_exam',$suexam);    
						
					   //	echo $DB1->last_query();
		  
			}
		}			
	   
	//    echo "jugal";
	//    exit(0);
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    //	$temp['academic_year']= date('Y');
       
   
      $feedet['entry_from_ip']= $_SERVER['REMOTE_ADDR'];
      $feedet['created_on']= date('Y-m-d');
      $feedet['created_by']= $_SESSION['uid'];
      
      
	     
	       	  $feedet['student_id']=$insert_id1;
	    	          $feedet['amount']=$data['totalfeepaid'];
	    	            $feedet['type_id']=2;
	    	            $feedet['fees_paid_type']=$data['payment_type'];
	    	             $feedet['academic_year']= stripslashes(($data['acyear']));
	    	            	
	    //	     $exam['passing_year']=$data['supass_month']."-".$data['supass_year']; fees_paid_type
	 			$feedet['receipt_no']=$data['dd_no'];
	 			$feedet['fees_date']=$data['dd_date']; 
	 			$feedet['bank_id']=$data['dd_bank'];
	 			$feedet['bank_city']=$data['dd_bank_branch'];
	 			$feedet['receipt_file']=$payfile;
	    	     //  	$DB1->insert('fees_details',$feedet);   
	    	      // 	$insert_feid1 = $DB1->insert_id();
	        
	          $sbank['student_id']=$insert_id1;
	    	          $sbank['account_no']=$data['account_no'];
	    //	     $exam['passing_year']=$data['supass_month']."-".$data['supass_year']; 
	 			$sbank['ifsc_code']=$data['ifsc'];
	 			$sbank['bank_name']=$data['bank_name']; 
	 
	 			$sbank['bank_city']=$data['bank_branch'];
	    	       	$DB1->insert('student_bank_details',$sbank);   
	    	       	
	    	       	if($data['exepmted_fee']>0)
	    	       	{
	    	       	 $fcdetails['concession_type']='Schlorship';
	    	       	 $fcdetails['student_id']=$insert_id1;
	    	       	    $fcdetails['academic_year']=stripslashes(($data['acyear']));
	    	       	    
	    	       	    
	    	       	  $fcdetails['actual_fees']=$data['acd_totalfee'];
	    	       	  
	    	       	   $fcdetails['exepmted_fees']=$data['exepmted_fee'];
	    	       	    $fcdetails['fees_paid_required']=$data['totalfeeappli'];
	    	       	
	    	       	      	  $fcdetails['allowed_by']='Admin';
	    	            $fcdetails['created_on']= date("Y-m-d H:i:s");
      $fcdetails['created_by']= $_SESSION['uid'];
	    	         //   $fcdetails['fees_paid_type']=$data['payment_type'];
	    	          
	    	       	
	    	       	
	    	       	
	    	       		$DB1->insert('fees_consession_details',$fcdetails);   
	    	       	
	    	       	}
	    	       	
	    	       	
	    	       	
	    	       		 	
   
	    	       	
	    	       	
	    	       		// $admdetails['concession_type']='Schlorship';
	    	       	 $admdetails['student_id']=$insert_id1;
	    	       	    $admdetails['school_code']=$this->Ums_admission_model->getschool_bycourse($data['admission-branch']);
	    	       	    $admdetails['stream_id']=stripslashes(($data['admission-branch']));
	    	       	    
	    	       	        if($admission_type==1 || $admission_type=='')
       {
        	$admdetails['year']=1;    
        
       }
      if($admission_type==2)
       {
          	$admdetails['year']='2';     
        
       }
	    	       	   // $admdetails['year']=date('Y');
	    	       	    $admdetails['academic_year']= stripslashes(($data['acyear']));
	    	       	   // $admdetails['school_code']=date('Y');
	    	       	    
	    	       	  $admdetails['actual_fee']=$data['acd_totalfee'];
	    	       	  
	    	       	   $admdetails['applicable_fee']=$data['totalfeeappli'];
	    	       	  //  $admdetails['fees_paid_required']=$data['totalfeepaid'];
	    	       	  if($data['totalfeeappli']==$data['totalfeepaid'])
	    	       	  {
	    	       	     $admdetails['total_fees_paid']='Y'; 
	    	       	      
	    	       	  }
	    	       	   if($data['exepmted_fee']>0)
	    	       	  {
	    	       	     $admdetails['fees_consession_allowed']='Y'; 
	    	       	     	 $admdetails['concession_type']='Scholarship';
	    	       	      
	    	       	  }
	    	       
	    	      
	    	       	  $admdetails['hostel_required']=$data['hostel'];
	    	       	   $admdetails['hostel_type']=$data['hosteltype'];
	    	       	    $admdetails['transport_required']=$data['transport'];
	    	       	     $admdetails['transport_boarding_point']=$data['bording_point'];
	    	       	      $admdetails['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
	    	       	      //	  $admdetails['allowed_by']='Admin';
	    	            $admdetails['created_on']= date("Y-m-d H:i:s");
      $admdetails['created_by']= $_SESSION['uid'];
	    	         //   $fcdetails['fees_paid_type']=$data['payment_type'];
	    	          
	    	       	
	    	       	
	    	       	
	    	       		$DB1->insert('admission_details',$admdetails);  
	    	       	
	    	       //	echo $DB1->last_query();
	    	       	
	    	       	
	    	       	
	    	       	
	    	       	
	    	       	
	    	       		
	    	       	 $fidetails['student_id']=$insert_id1;
	    	       	$fidetails['fees_id']=$insert_feid1;
	    	       	  	 $fidetails['academic_year']= stripslashes(($data['acyear']));
	    	       	  $fidetails['no_of_installment']='1';
	    	       	   $fidetails['actual_fees']=$data['acd_totalfee'];
	    	       	   $fidetails['balance_fees']=((int)$data['totalfeeappli'] - (int)$data['totalfeepaid']);
	    	       	   //  $fidetails['transport_boarding_point']=$data['bording_point'];
	    	       	     
	    	       	      $fidetails['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
	    	       	      	//  $admdetails['allowed_by']='Admin';
	    	            $fidetails['created_on']= date('Y-m-d');
      $fidetails['created_by']= $_SESSION['uid'];
	    	         //   $fcdetails['fees_paid_type']=$data['payment_type'];
	    	          
	    	       	
	    	       	
	    	       	
	    	       	//	$DB1->insert('fees_installment_details',$fidetails);  
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	 	
	   // exit(0);
	    	
	    	
	    	
	 	//echo $DB1->last_query();   
	 //  exit(0);
	   
	/*	$res2=$this->db->insert('personal_details',$address);
		$insert_id2 = $this->db->insert_id();
		$res3=$this->db->insert('parent_details',$guardian);
		$insert_id3 = $this->db->insert_id();
		$query1="insert into student_formfill_status(student_id)values('$stid')";
		$res=$this->db->query($query1);
		if(!empty($insert_id1)&&$insert_id1!=0){
			$update_flag="UPDATE `student_formfill_status` SET step_first_flag=1 where student_id='$stid'";
			$res_flg=$this->db->query($update_flag);
			}
		echo $insert_id1;
		echo $insert_id2;
		echo $insert_id3;*/
		
		//step1 end
		//step2
		
		
		/*	$stid=$data['reg_id'];
		$edu['student_id']=stripslashes(($data['reg_id']));
		$edu['qexam_name']=stripslashes(($data['qexam']));
		$edu['qexam_pyear']=stripslashes(($data['pyexam']));
		$edu['qexam_colleg']=stripslashes(($data['cexam']));
		$edu['adm_basis']=stripslashes(($data['admission_basis']));
		$edu['qexam_roll']=stripslashes(($data['roll_exam']));
		$edu['qexam_rank']=stripslashes(($data['exam_rank']));
		$edu['hscpass_date']=stripslashes(($data['hscpass_date']));
		$edu['htotal_phy']=stripslashes(($data['thsc_phy']));
		$edu['htotal_chem']=stripslashes(($data['thsc_chem']));
		$edu['htotal_bio']=stripslashes(($data['thsc_bio']));
		$edu['htotal_eng']=stripslashes(($data['thsc_eng']));
		$edu['hobt_phy']=stripslashes(($data['ohsc_phy']));
		$edu['hobt_chem']=stripslashes(($data['ohsc_chem']));
		$edu['hobt_bio']=stripslashes(($data['ohsc_bio']));
		$edu['hobt_eng']=stripslashes(($data['ohsc_eng']));
		$edu['ssc_passing_dt']=stripslashes(($data['sscpass_date']));
		$edu['stotal_eng']=stripslashes(($data['tssc_eng']));
		$edu['sobt_eng']=stripslashes(($data['ossc_eng']));
		*/
		//academic History
	/*	$len=sizeof($data['exam_id'],1);
	
		for($i=0;$i<$len;$i++){
		$academic['student_id']=stripslashes(($data['reg_id']));
		$academic['exam_id']=stripslashes(($data['exam_id'][$i]));
		$academic['college_name']=stripslashes(($data['college_name'][$i]));
		$academic['pass_year']=stripslashes(($data['pass_year'][$i]));
		$academic['pass_month']=stripslashes(($data['pass_month'][$i]));
		$academic['seat_no']=stripslashes(($data['seat_no'][$i]));
		$academic['institute_name']=stripslashes(($data['institute_name'][$i]));
		$academic['marks_obtained']=stripslashes(($data['marks_obtained'][$i]));
		$academic['marks_outof']=stripslashes(($data['marks_outof'][$i]));
		$academic['percentage']=($academic['marks_obtained']/$academic['marks_outof'])*100;// % calulation
		//$academic['percentage']=stripslashes(($data['percentage'][$i]));
		$this->db->insert('education_details',$academic);
		}
	
		$insert_id1 = $this->db->insert_id();
		$this->db->insert('qualifying_exam_details',$edu);
		
		*/
		//step2 end
		
		//step3
		
	//		$stid=$data['reg_id'];
	//var_dump($_FILES['scandoc']);
	
/*	exit(0);
	//uncomment
		if(!empty($_FILES['scandoc']['name'])){
		    $student_id  =$insert_id1;
			$_FILES['scandoc']['name']=$this->rearrange1($_FILES['scandoc']['name']);
			// $filesCount = count($_FILES['scandoc']['name']);
            //for($i = 0; $i < $filesCount; $i++){
				foreach($_FILES['scandoc']['name'] as $key => $val){
                $_FILES['userFile']['name'] = $student_id.'-'.$_FILES['scandoc']['name'][$key];
                $_FILES['userFile']['type'] = $_FILES['scandoc']['type'][$key];
                $_FILES['userFile']['tmp_name'] = $_FILES['scandoc']['tmp_name'][$key];
                $_FILES['userFile']['error'] = $_FILES['scandoc']['error'][$key];
                $_FILES['userFile']['size'] = $_FILES['scandoc']['size'][$key];
                 $arr1[$key]=$_FILES['userFile']['name'];
                $uploadPath = 'uploads/student_document/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx';
				$config['overwrite']= FALSE;
                $config['max_size']= "2048000"; 
                
               // $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$key]['file_name'] = $fileData['file_name'];
                    $uploadData[$key]['created'] = date("Y-m-d H:i:s");
                    $uploadData[$key]['modified'] = date("Y-m-d H:i:s");
                }
            }
	
		}
	
	
	var_dump($arr1);
	
	
	
	
	exit(0);*/
	
		$temp['student_id']=$insert_id1;
		$temp['doc_id']= $this->rearrange1($data['dapplicable']);//without changing key value sequence
		$temp['doc_applicable']	= $this->rearrange1($data['dapplicable']);
		$temp['ox']	= $this->rearrange1($data['ox']);
		$temp['sub_dt']	= $this->rearrange1($data['docsubdate']);
		$temp['remark']	= $this->rearrange1($data['remark']);
		//$temp['doc_path']= $this->rearrange1($data['filescan']); 
		$temp['doc_path']= $arr1;//$this->rearrange1($data['filescan']); 
		$list=array();
		$list=array_keys( $temp['doc_id']);
		$temp['doc_id']=$list;
		$list=array_combine($temp['doc_id'],$temp['doc_id']);
		 $temp['doc_id']=$list;
		 
	      foreach($temp['doc_id'] as $key=>$val){
		     $temp2['doc_id'][$key]=$temp['doc_id'][$key];
			 $temp2['doc_applicable'][$key]=$temp['doc_applicable'][$key];
			 $temp2['ox'][$key]=$temp['ox'][$key];
			 $temp2['sub_dt'][$key]=$temp['sub_dt'][$key];
			 $temp2['remark'][$key]=$temp['remark'][$key];
			 $temp2['doc_path'][$key]=$temp['doc_path'][$key];
			 }
		// for certificate details
		$cert['certificate_name']=$data['cnm'];
		$cert['certificate_no']=$data['cno'];
		$cert['issue_date']=$data['issuedt'];
		$cert['validity_date']=$data['cval'];
			
		$len=sizeof($cert['certificate_name']);
		//echo $len;
		
		for($i=0;$i<$len;$i++){
		$a['student_id']=$insert_id1;
		$a['certificate_name']=	$cert['certificate_name'][$i];
		$a['certificate_no']=	$cert['certificate_no'][$i];
		$a['issue_date']=$cert['issue_date'][$i];
		$a['validity_date']=$cert['validity_date'][$i];
		$insert_id11 =$DB1->insert('student_certificate_submit_details',$a);
	//	echo $DB1->last_query();
		}
		//end
	
			foreach($temp2['doc_id'] as $key=>$val){
			$temp1['student_id']=$insert_id1;
			$temp1['doc_id']=stripslashes(($temp2['doc_id'][$key]));
			$temp1['doc_applicable']=stripslashes(($temp2['doc_applicable'][$key]));
			$temp1['ox']=stripslashes(($temp2['ox'][$key]));
			$temp1['remark']=stripslashes(($temp2['remark'][$key]));
			$temp1['created_on']=stripslashes(($temp2['sub_dt'][$key]));
			$temp1['doc_path']=stripslashes(($temp2['doc_path'][$key]));
			
		$DB1->insert('student_document_details',$temp1);
		}  
	//	$insert_id1 = $this->db->insert_id();
		
		
		
		//step3 end
		//step4
		
//	 $stid=$data['reg_id'];	
	
		if($data['fref1']!='')
		{
		$tempx['student_id']=$insert_id1;
		$tempx['is_from_reference']='Y';
		$tempx['person_name']=stripslashes(($data['fref1']));
		$tempx['contact_no']=stripslashes(($data['frefcont1']));
	$DB1->insert('student_references',$tempx);
		}
//		echo $DB1->last_query();

	
		if($data['fref2']!='')
		{
		$tempy['student_id']=$insert_id1;
		$tempy['is_from_reference']='Y';
		$tempy['person_name']=stripslashes(($data['fref2']));
		$tempy['contact_no']=stripslashes(($data['frefcont2']));
			$DB1->insert('student_references',$tempy);	
		}
		
		if($data['reletedsandip']=='Y')
		{
		$temp3['student_id']=$insert_id1;
		
		$temp3['is_uni_employed']='Y';
		$temp3['person_name']=stripslashes(($data['relatedname']));
		$temp3['designation']=stripslashes(($data['relateddesig']));
		$temp3['relation']=stripslashes(($data['relatedrelation']));
			$DB1->insert('student_references',$temp3);	
		}	
			
				if($data['aluminisandip']=='Y')
		{
			$temp4['student_id']=$insert_id1;
		$temp4['is_uni_alumni']='Y';

		$temp4['person_name']=stripslashes(($data['alumininame']));
			$temp4['passing_year']=stripslashes(($data['aluminiyear']));
		$temp4['relation']=stripslashes(($data['aluminirelation']));
		$DB1->insert('student_references',$temp4);	
		}
		
		
						if($data['concern']=='Y')
		{
			$temp49['student_id']=$insert_id1;
		$temp49['is_concern_ins']='Y';

		$temp49['institute']=stripslashes(($data['cin']));
		
		$DB1->insert('student_references',$temp49);	
		}
		
		
		
		
		
		
		
			if($data['relativesandip']=='Y')
		{
		$temp5['student_id']=$insert_id1;
		$temp5['is_uni_student']='Y';
		$temp5['person_name']=stripslashes(($data['relativename']));
		$temp5['course']=stripslashes(($data['relativecoursenm']));
		$temp5['relation']=stripslashes(($data['relativerelation']));
		$DB1->insert('student_references',$temp5);	
		}
		//publicity_media
		$temp1=array();
		//$temp1=$data['publicitysandip'];
	//	$temp['publicity_media']=implode(",",$temp1);//$temp=implode("/ ",$mstatus); 
	
		if($data['refcandidatenm']!='')
		{
		$temp6['student_id']=$insert_id1;
		$temp6['is_reference']='Y';
		$temp6['person_name']=stripslashes(($data['refcandidatenm']));
		$temp6['contact_no']=stripslashes(($data['refcandidatecont']));
		$temp6['email']=stripslashes(($data['refcandidateemail']));
		$temp6['relation']=stripslashes(($data['refcandidaterelt']));
		$temp6['area_of_interest']=stripslashes(($data['refcandidateinterest']));
		
		$DB1->insert('student_references',$temp6);
		}
		//step4 end
	//	exit(0);
		//step5
	//	 $stid=$data['reg_id'];
		$temp['student_id']=$insert_id1;
		//applicable fee
//	echo "jugal";
		//total of every
	/*	$temp['totalfeeappli']=stripslashes(($data['totalfeeappli']));
		$temp['totalfeepaid']=stripslashes(($data['totalfeepaid']));
		$temp['totalfeebal']=stripslashes(($data['totalfeebal']));
		//fee paid dd details
		//$temp['paidfee']=stripslashes(($data['paidfee']));
		$temp['dd_no']=stripslashes(($data['dd_no']));
		$temp['dd_drawn_date']=stripslashes(($data['dd_date']));
		$temp['dd_drawn_bank_branch']=stripslashes(($data['dd_bank']));
		
		//bank details
		$temp['bank_name']=stripslashes(($data['bank_name']));
		$temp['account_no']=stripslashes(($data['account_no']));
		$temp['ifsc']=stripslashes(($data['ifsc']));
		//profile image
		//$temp['profile_img']=$temp['student_id'].'-'.stripslashes(($data['profile_img']));
		$temp['profile_img']=$prof_img;
		$this->db->insert('student_fee_details',$temp);
		$insert_id=$this->db->insert_id();
*/

	
		//step5 end
		
	//	echo "ankur";
		//exit(0);
		
		return $prnj;
	}

	
	
	
	
	
	
	
		function prov_admission_submit($data,$arr1,$arr2){
		    
		      $DBj = $this->load->database('icdb', TRUE);
		      	$update_flag="UPDATE `provisional_admission_details` SET is_confirmed='Y' where prov_reg_no='".$_POST['adm_id']."'";
			$DBj->query($update_flag);
			
			
			
		      
		     $DB1 = $this->load->database('umsdb', TRUE); 
		     
		     
		     
		     //poonam 
		     
		    $dupj =  $this->Ums_admission_model->chek_mob_exist($data['mobile']);
		    if($dupj[0]['mobile']!='')
		    {
		       //  echo "exist";
		        echo '<script>alert("Student Already Registered");window.location.href = "stud_list";</script>';
		        exit();
		    }
		   
		//echo "in student registration function";
		/* echo $stid;
		echo"<pre>";
		print_r($data);
		echo"</pre>";
			die();  */
	//    $temp['student_id']=stripcslashes($stid);
		//Admission for
	//	echo $_POST['adm_id'];
		//		exit();
		
	//	var_dump($_FILES);
			 if(!empty($_FILES['profile_img']['name'])){
				 $filenm=$student_id.'-'.time().'-'.$_FILES['profile_img']['name'];
                $config['upload_path'] = 'uploads/student_profilephotos/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('profile_img')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    $picture = '';
                }
            }
			else{
                $picture = '';
            }
		
		
		
		
		
		if(!empty($_FILES['payfile']['name'])){
				 $filenm=$student_id.'-'.$_FILES['payfile']['name'];
                $config['upload_path'] = 'uploads/student_challans/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('payfile')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    $payfile = '';
                }
            }
			else{
                $payfile = '';
            }
		

	
		$temp['admission_school']=$this->Ums_admission_model->getschool_bycourse($data['admission-branch']); 
	
		 	$prnj =	$temp['enrollment_no']=$_POST['adm_id'];   
		 		$temp['enrollment_no_new']=$_POST['adm_id'];   

		//($stream_id)
		//course
		$temp['admission_stream']=stripslashes(($data['admission-branch'])); 	
		//student name
		$temp['first_name']=strtoupper(stripslashes(($data['sfname']))); 		
		$temp['middle_name']=strtoupper(stripslashes(($data['smname']))); 		
		$temp['last_name']=strtoupper(stripslashes(($data['slname']))); 
        
		$temp['gender']=stripslashes(($data['gender'])); 
		$temp['blood_group']=stripslashes(($data['blood_gr'])); 
		$temp['dob']=stripslashes(($data['dob']));
		
		$temp['birth_place']=stripslashes(($data['pob']));  
		$temp['mobile']=stripslashes(($data['mobile'])); 
		$temp['email']=stripslashes(($data['email_id'])); 
		$temp['nationality']=stripslashes(($data['nationality'])); 
		$temp['category']=stripslashes(($data['category']));  
		//$temp['sub_caste']=stripslashes(($data['sub_caste']));  
		$temp['religion']=stripslashes(($data['religion'])); 
		$temp['adhar_card_no']=stripslashes(($data['saadhar'])); 
		$temp['domicile_status']=stripslashes(($data['res_state'])); 
		
	
       $temp['academic_year']= stripslashes(($data['acyear']));
           $temp['admission_session']= stripslashes(($data['acyear']));
        
       	$admission_type=stripslashes(($data['admission_type']));
       	
       	
       	
       if($admission_type==1 || $admission_type=='')
       {
        	$temp['current_year']='1';    
        		$temp['admission_year']='1';    
        	$temp['admission_semester']='1';
        	$temp['lateral_entry']='N';
        	$temp['current_semester']='1';
       }
       if($admission_type==2)
       {
           	$temp['current_year']='2';  
           $temp['admission_year']='2';    
        	$temp['admission_semester']='3';
        	$temp['lateral_entry']='Y';
        	$temp['current_semester']='3';
       }
       
      $temp['entry_from_ip']= $_SERVER['REMOTE_ADDR'];
      $temp['created_on']= date("Y-m-d H:i:s");
      $temp['created_by']= $_SESSION['uid'];
		$temp['father_fname']=strtoupper(stripslashes(($data['sfname1']))); 		
		$temp['father_mname']=strtoupper(stripslashes(($data['smname1']))); 		
		$temp['father_lname']=strtoupper(stripslashes(($data['slname1']))); 
         // student mother name		
		$temp['mother_name']=strtoupper(stripslashes(($data['sfname2']))); 
			$temp['student_photo_path']=$picture;
			$temp['about_uni_know']=implode(",",$data['publicitysandip']);//$temp=implode("/ ",$mstatus); 
		/***Address details***/
		//local address bill_A
		
		 	 $temp['form_number']=$data['sfnumber'];
	  
		
		//Guardians details  parent_details
		
		
		
	
		
	    $DB1->insert('student_master',$temp);
	     
		$insert_id1 = $DB1->insert_id();
		
	      $address['adds_of']='STUDENT'; 
		$address['address_type']='CORS'; 
		$address['address']=stripslashes(($data['laddress'])); 
	//	$address['street']=stripslashes(($data['bill_B'])); 
		$address['city']=stripslashes(($data['lcity'])); 
		$address['state_id']=stripslashes(($data['lstate_id'])); 
		$address['district_id']=stripslashes(($data['ldistrict_id'])); 
		$address['pincode']=stripslashes(($data['lpincode']));
		$address['student_id']=$insert_id1;	
		
		$DB1->insert('address_details',$address);
	     
	//	$insert_id1 = $this->db->insert_id();
		
		
		
		//fee and ins details
		
		
		
		
		
		
		
         // permenant	address	
	    $paddress['adds_of']='STUDENT'; 
		$paddress['address_type']='PERMNT'; 
		$paddress['address']=stripslashes(($data['paddress'])); 
	//	$paddress['street']=stripslashes(($data['bshipping_B'])); 
		$paddress['city']=stripslashes(($data['pcity'])); 
		$paddress['state_id']=stripslashes(($data['pstate_id'])); 
		$paddress['district_id']=stripslashes(($data['pdistrict_id'])); 
		$paddress['pincode']=stripslashes(($data['ppincode']));
		$paddress['student_id']=$insert_id1;	
			$DB1->insert('address_details',$paddress);
		
		
		
		
		 $gpaddress['adds_of']='PARENT'; 
		$gpaddress['address_type']='PERMNT'; 
	    $gpaddress['student_id']=$insert_id1;
	 		$gpaddress['address']=stripslashes(($data['gparent_address'])); 
	//	$paddress['street']=stripslashes(($data['bshipping_B'])); 
		$gpaddress['city']=stripslashes(($data['gcity'])); 
		$gpaddress['state_id']=stripslashes(($data['gstate_id'])); 
		$gpaddress['district_id']=stripslashes(($data['gdistrict_id'])); 
		$gpaddress['pincode']=stripslashes(($data['gpincode']));
			$DB1->insert('address_details',$gpaddress);
	
			$insert_id2 = $DB1->insert_id();
	 
	 

	 $guardian['student_id']=stripcslashes($insert_id1);
			//   $guardian['enrollement_no']=stripcslashes($stid);
		$guardian['gfirst_name']=strtoupper(stripslashes(($data['fname']))); 
		$guardian['gmiddle_name']=strtoupper(stripslashes(($data['mname']))); 
		$guardian['glast_name']=strtoupper(stripslashes(($data['lname']))); 
		$guardian['relation']=stripslashes(($data['relationship'])); 
		$guardian['occupation']=stripslashes(($data['occupation'])); 
		$guardian['income']=stripslashes(($data['annual_income'])); 
		$guardian['parent_email']=stripslashes(($data['parent_email'])); 
		$guardian['parent_mobile2']=stripslashes(($data['parent_mobile'])); 
		$guardian['parent_mobile1']=stripslashes(($data['parent_phone'])); 
		$guardian['address_id']=stripslashes($insert_id2);
	    	$DB1->insert('parent_details',$guardian);
	    //echo $DB1->last_query();
	    //	exit(0);
	    //	var_dump($_FILES['sss_doc']);
	    	
	    	if(count($data['exam_id'])>0)
	    	{
	    	for($i=0;$i<count($data['exam_id']);$i++)
	    	
	    	{
	    	    if($data['exam_id'][$i] !='')
	    	    {
	    	    $exam['student_id']=$insert_id1;
				$exam['degree_type']=$data['exam_id'][$i]; 
	 			$exam['degree_name']=$data['stream_name'][$i]; 
	 			$exam['specialization']=$data['seat_no'][$i];
	 			$exam['board_uni_name']=$data['institute_name'][$i]; 
	 			$exam['passing_year']=$data['pass_month'][$i]."-".$data['pass_year'][$i];
	 			$exam['total_marks']=$data['marks_obtained'][$i];
	 			$exam['out_of_marks']=$data['marks_outof'][$i];
	 			$exam['percentage']=$data['percentage'][$i]; 
	 
	 		
	 		 $picture='';
	 		$key =$i;
	 		

	 		
	 	
				if(!empty($arr2[$i]) && $arr2[$i] !=''){
					$exam['file_path']= $arr2[$i];
				}
	 		
	 

			$DB1->insert('student_qualification_details',$exam);
			

	    	    
	    	    	$insert_ide = $DB1->insert_id();
	    	    }
	  
	    	    
	    	    
	    	}
	    	}
	    	

	    if(!empty($data['exam-name']) && $data['exam-name']!='') 	
	    {	
			for($i=0;$i<count($data['exam-name']);$i++)	
			{
			 
				  $suexam['student_id']=$insert_id1;
						  $suexam['entrance_exam_name']=$data['exam-name'][$i];
						//  $suexam['entrance_exam_name']=$data['other_exam-name'][$i];
						  
					 $suexam['passing_year']=$data['pass_monthe'][$i]."-".$data['pass_yeare'][$i]; 
					$suexam['register_no']=$data['enrolment'][$i];
					$suexam['marks_obt']=$data['marks'][$i]; 
				//	$suexam['marks_outof']=$data['totalmarks'][$i];
				//	$suexam['percentage']=$data['ent_percentage'][$i];
						$DB1->insert('student_entrance_exam',$suexam);    
						
					   //	echo $DB1->last_query();
		  
			}
		}			
	   
	//    echo "jugal";
	//    exit(0);
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    //	$temp['academic_year']= date('Y');
       
   
      $feedet['entry_from_ip']= $_SERVER['REMOTE_ADDR'];
      $feedet['created_on']= date('Y-m-d');
      $feedet['created_by']= $_SESSION['uid'];
      
      
	     
	       	  $feedet['student_id']=$insert_id1;
	    	          $feedet['amount']=$data['totalfeepaid'];
	    	            $feedet['type_id']=2;
	    	            $feedet['fees_paid_type']=$data['payment_type'];
	    	             $feedet['academic_year']= stripslashes(($data['acyear']));
	    	            	
	    //	     $exam['passing_year']=$data['supass_month']."-".$data['supass_year']; fees_paid_type
	 			$feedet['receipt_no']=$data['dd_no'];
	 			$feedet['fees_date']=$data['dd_date']; 
	 			$feedet['bank_id']=$data['dd_bank'];
	 			$feedet['bank_city']=$data['dd_bank_branch'];
	 			$feedet['receipt_file']=$payfile;
	    	     //  	$DB1->insert('fees_details',$feedet);   
	    	      // 	$insert_feid1 = $DB1->insert_id();
	        
	          $sbank['student_id']=$insert_id1;
	    	          $sbank['account_no']=$data['account_no'];
	    //	     $exam['passing_year']=$data['supass_month']."-".$data['supass_year']; 
	 			$sbank['ifsc_code']=$data['ifsc'];
	 			$sbank['bank_name']=$data['bank_name']; 
	 
	 			$sbank['bank_city']=$data['bank_branch'];
	    	       	$DB1->insert('student_bank_details',$sbank);   
	    	       	
	    	       	if($data['exepmted_fee']>0)
	    	       	{
	    	       	 $fcdetails['concession_type']='Schlorship';
	    	       	 $fcdetails['student_id']=$insert_id1;
	    	       	    $fcdetails['academic_year']=stripslashes(($data['acyear']));
	    	       	    
	    	       	    
	    	       	  $fcdetails['actual_fees']=$data['acd_totalfee'];
	    	       	  
	    	       	   $fcdetails['exepmted_fees']=$data['exepmted_fee'];
	    	       	    $fcdetails['fees_paid_required']=$data['totalfeeappli'];
	    	       	
	    	       	      	  $fcdetails['allowed_by']='Admin';
	    	            $fcdetails['created_on']= date("Y-m-d H:i:s");
      $fcdetails['created_by']= $_SESSION['uid'];
	    	         //   $fcdetails['fees_paid_type']=$data['payment_type'];
	    	          
	    	       	
	    	       	
	    	       	
	    	       		$DB1->insert('fees_consession_details',$fcdetails);   
	    	       	
	    	       	}
	    	       	
	    	       	
	    	       	$updateid =$_POST['adm_id'];
	    	       		 	$update_feedet="UPDATE `fees_details` SET student_id='$insert_id1' where prov_reg_no='$updateid'";
			$res_flg=$DB1->query($update_feedet);
	    	       		 	
	    	       		 	
   
	    	       	
	    	       	
	    	       		// $admdetails['concession_type']='Schlorship';
	    	       	 $admdetails['student_id']=$insert_id1;
	    	       	  $admdetails['enrollment_no'] = $_POST['adm_id'];
	    	       	    $admdetails['form_number'] = $data['sfnumber'];
	    	       	    $admdetails['school_code']=$this->Ums_admission_model->getschool_bycourse($data['admission-branch']);
	    	       	    $admdetails['stream_id']=stripslashes(($data['admission-branch']));
	    	       	    
	    	       	        if($admission_type==1 || $admission_type=='')
       {
        	$admdetails['year']=1;    
        
       }
      if($admission_type==2)
       {
          	$admdetails['year']='2';     
        
       }
	    	       	   // $admdetails['year']=date('Y');
	    	       	    $admdetails['academic_year']= stripslashes(($data['acyear']));
	    	       	   // $admdetails['school_code']=date('Y');
	    	       	    
	    	       	  $admdetails['actual_fee']=$data['acd_totalfee'];
	    	       	  
	    	       	   $admdetails['applicable_fee']=$data['totalfeeappli'];
	    	       	  //  $admdetails['fees_paid_required']=$data['totalfeepaid'];
	    	       	  if($data['totalfeeappli']==$data['totalfeepaid'])
	    	       	  {
	    	       	     $admdetails['total_fees_paid']='Y'; 
	    	       	      
	    	       	  }
	    	       	   if($data['exepmted_fee']>0)
	    	       	  {
	    	       	     $admdetails['fees_consession_allowed']='Y'; 
	    	       	     	 $admdetails['concession_type']='Scholarship';
	    	       	      
	    	       	  }
	    	       
	    	      
	    	       	  $admdetails['hostel_required']=$data['hostel'];
	    	       	   $admdetails['hostel_type']=$data['hosteltype'];
	    	       	    $admdetails['transport_required']=$data['transport'];
	    	       	     $admdetails['transport_boarding_point']=$data['bording_point'];
	    	       	      $admdetails['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
	    	       	      //	  $admdetails['allowed_by']='Admin';
	    	            $admdetails['created_on']= date("Y-m-d H:i:s");
      $admdetails['created_by']= $_SESSION['uid'];
	    	         //   $fcdetails['fees_paid_type']=$data['payment_type'];
	    	          
	    	       	
	    	       	
	    	       	
	    	       		$DB1->insert('admission_details',$admdetails);  
	    	       	
	    	       //	echo $DB1->last_query();
	    	       	
	    	       	
	    	       	
	    	       	
	    	       	
	    	       	
	    	       		
	    	       	 $fidetails['student_id']=$insert_id1;
	    	       	$fidetails['fees_id']=$insert_feid1;
	    	       	  	 $fidetails['academic_year']= stripslashes(($data['acyear']));
	    	       	  $fidetails['no_of_installment']='1';
	    	       	   $fidetails['actual_fees']=$data['acd_totalfee'];
	    	       	   $fidetails['balance_fees']=((int)$data['totalfeeappli'] - (int)$data['totalfeepaid']);
	    	       	   //  $fidetails['transport_boarding_point']=$data['bording_point'];
	    	       	     
	    	       	      $fidetails['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
	    	       	      	//  $admdetails['allowed_by']='Admin';
	    	            $fidetails['created_on']= date('Y-m-d');
      $fidetails['created_by']= $_SESSION['uid'];
	    	         //   $fcdetails['fees_paid_type']=$data['payment_type'];
	    	          
	    	       	
	    	       	
	    	       	
	    	       	//	$DB1->insert('fees_installment_details',$fidetails);  
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	 	
	   // exit(0);
	    	
	    	
	    	
	 	//echo $DB1->last_query();   
	 //  exit(0);
	   
	/*	$res2=$this->db->insert('personal_details',$address);
		$insert_id2 = $this->db->insert_id();
		$res3=$this->db->insert('parent_details',$guardian);
		$insert_id3 = $this->db->insert_id();
		$query1="insert into student_formfill_status(student_id)values('$stid')";
		$res=$this->db->query($query1);
		if(!empty($insert_id1)&&$insert_id1!=0){
			$update_flag="UPDATE `student_formfill_status` SET step_first_flag=1 where student_id='$stid'";
			$res_flg=$this->db->query($update_flag);
			}
		echo $insert_id1;
		echo $insert_id2;
		echo $insert_id3;*/
		
		//step1 end
		//step2
		
		
		/*	$stid=$data['reg_id'];
		$edu['student_id']=stripslashes(($data['reg_id']));
		$edu['qexam_name']=stripslashes(($data['qexam']));
		$edu['qexam_pyear']=stripslashes(($data['pyexam']));
		$edu['qexam_colleg']=stripslashes(($data['cexam']));
		$edu['adm_basis']=stripslashes(($data['admission_basis']));
		$edu['qexam_roll']=stripslashes(($data['roll_exam']));
		$edu['qexam_rank']=stripslashes(($data['exam_rank']));
		$edu['hscpass_date']=stripslashes(($data['hscpass_date']));
		$edu['htotal_phy']=stripslashes(($data['thsc_phy']));
		$edu['htotal_chem']=stripslashes(($data['thsc_chem']));
		$edu['htotal_bio']=stripslashes(($data['thsc_bio']));
		$edu['htotal_eng']=stripslashes(($data['thsc_eng']));
		$edu['hobt_phy']=stripslashes(($data['ohsc_phy']));
		$edu['hobt_chem']=stripslashes(($data['ohsc_chem']));
		$edu['hobt_bio']=stripslashes(($data['ohsc_bio']));
		$edu['hobt_eng']=stripslashes(($data['ohsc_eng']));
		$edu['ssc_passing_dt']=stripslashes(($data['sscpass_date']));
		$edu['stotal_eng']=stripslashes(($data['tssc_eng']));
		$edu['sobt_eng']=stripslashes(($data['ossc_eng']));
		*/
		//academic History
	/*	$len=sizeof($data['exam_id'],1);
	
		for($i=0;$i<$len;$i++){
		$academic['student_id']=stripslashes(($data['reg_id']));
		$academic['exam_id']=stripslashes(($data['exam_id'][$i]));
		$academic['college_name']=stripslashes(($data['college_name'][$i]));
		$academic['pass_year']=stripslashes(($data['pass_year'][$i]));
		$academic['pass_month']=stripslashes(($data['pass_month'][$i]));
		$academic['seat_no']=stripslashes(($data['seat_no'][$i]));
		$academic['institute_name']=stripslashes(($data['institute_name'][$i]));
		$academic['marks_obtained']=stripslashes(($data['marks_obtained'][$i]));
		$academic['marks_outof']=stripslashes(($data['marks_outof'][$i]));
		$academic['percentage']=($academic['marks_obtained']/$academic['marks_outof'])*100;// % calulation
		//$academic['percentage']=stripslashes(($data['percentage'][$i]));
		$this->db->insert('education_details',$academic);
		}
	
		$insert_id1 = $this->db->insert_id();
		$this->db->insert('qualifying_exam_details',$edu);
		
		*/
		//step2 end
		
		//step3
		
	//		$stid=$data['reg_id'];
	//var_dump($_FILES['scandoc']);
	
/*	exit(0);
	//uncomment
		if(!empty($_FILES['scandoc']['name'])){
		    $student_id  =$insert_id1;
			$_FILES['scandoc']['name']=$this->rearrange1($_FILES['scandoc']['name']);
			// $filesCount = count($_FILES['scandoc']['name']);
            //for($i = 0; $i < $filesCount; $i++){
				foreach($_FILES['scandoc']['name'] as $key => $val){
                $_FILES['userFile']['name'] = $student_id.'-'.$_FILES['scandoc']['name'][$key];
                $_FILES['userFile']['type'] = $_FILES['scandoc']['type'][$key];
                $_FILES['userFile']['tmp_name'] = $_FILES['scandoc']['tmp_name'][$key];
                $_FILES['userFile']['error'] = $_FILES['scandoc']['error'][$key];
                $_FILES['userFile']['size'] = $_FILES['scandoc']['size'][$key];
                 $arr1[$key]=$_FILES['userFile']['name'];
                $uploadPath = 'uploads/student_document/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx';
				$config['overwrite']= FALSE;
                $config['max_size']= "2048000"; 
                
               // $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$key]['file_name'] = $fileData['file_name'];
                    $uploadData[$key]['created'] = date("Y-m-d H:i:s");
                    $uploadData[$key]['modified'] = date("Y-m-d H:i:s");
                }
            }
	
		}
	
	
	var_dump($arr1);
	
	
	
	
	exit(0);*/
	
		$temp['student_id']=$insert_id1;
		$temp['doc_id']= $this->rearrange1($data['dapplicable']);//without changing key value sequence
		$temp['doc_applicable']	= $this->rearrange1($data['dapplicable']);
		$temp['ox']	= $this->rearrange1($data['ox']);
		$temp['sub_dt']	= $this->rearrange1($data['docsubdate']);
		$temp['remark']	= $this->rearrange1($data['remark']);
		//$temp['doc_path']= $this->rearrange1($data['filescan']); 
		$temp['doc_path']= $arr1;//$this->rearrange1($data['filescan']); 
		$list=array();
		$list=array_keys( $temp['doc_id']);
		$temp['doc_id']=$list;
		$list=array_combine($temp['doc_id'],$temp['doc_id']);
		 $temp['doc_id']=$list;
		 
	      foreach($temp['doc_id'] as $key=>$val){
		     $temp2['doc_id'][$key]=$temp['doc_id'][$key];
			 $temp2['doc_applicable'][$key]=$temp['doc_applicable'][$key];
			 $temp2['ox'][$key]=$temp['ox'][$key];
			 $temp2['sub_dt'][$key]=$temp['sub_dt'][$key];
			 $temp2['remark'][$key]=$temp['remark'][$key];
			 $temp2['doc_path'][$key]=$temp['doc_path'][$key];
			 }
		// for certificate details
		$cert['certificate_name']=$data['cnm'];
		$cert['certificate_no']=$data['cno'];
		$cert['issue_date']=$data['issuedt'];
		$cert['validity_date']=$data['cval'];
			
		$len=sizeof($cert['certificate_name']);
		//echo $len;
		
		for($i=0;$i<$len;$i++){
		$a['student_id']=$insert_id1;
		$a['certificate_name']=	$cert['certificate_name'][$i];
		$a['certificate_no']=	$cert['certificate_no'][$i];
		$a['issue_date']=$cert['issue_date'][$i];
		$a['validity_date']=$cert['validity_date'][$i];
		$insert_id11 =$DB1->insert('student_certificate_submit_details',$a);
	//	echo $DB1->last_query();
		}
		//end
	
			foreach($temp2['doc_id'] as $key=>$val){
			$temp1['student_id']=$insert_id1;
			$temp1['doc_id']=stripslashes(($temp2['doc_id'][$key]));
			$temp1['doc_applicable']=stripslashes(($temp2['doc_applicable'][$key]));
			$temp1['ox']=stripslashes(($temp2['ox'][$key]));
			$temp1['remark']=stripslashes(($temp2['remark'][$key]));
			$temp1['created_on']=stripslashes(($temp2['sub_dt'][$key]));
			$temp1['doc_path']=stripslashes(($temp2['doc_path'][$key]));
			
		$DB1->insert('student_document_details',$temp1);
		}  
	//	$insert_id1 = $this->db->insert_id();
		
		
		
		//step3 end
		//step4
		
//	 $stid=$data['reg_id'];	
	
		if($data['fref1']!='')
		{
		$tempx['student_id']=$insert_id1;
		$tempx['is_from_reference']='Y';
		$tempx['person_name']=stripslashes(($data['fref1']));
		$tempx['contact_no']=stripslashes(($data['frefcont1']));
	$DB1->insert('student_references',$tempx);
		}
//		echo $DB1->last_query();

	
		if($data['fref2']!='')
		{
		$tempy['student_id']=$insert_id1;
		$tempy['is_from_reference']='Y';
		$tempy['person_name']=stripslashes(($data['fref2']));
		$tempy['contact_no']=stripslashes(($data['frefcont2']));
			$DB1->insert('student_references',$tempy);	
		}
		
		if($data['reletedsandip']=='Y')
		{
		$temp3['student_id']=$insert_id1;
		
		$temp3['is_uni_employed']='Y';
		$temp3['person_name']=stripslashes(($data['relatedname']));
		$temp3['designation']=stripslashes(($data['relateddesig']));
		$temp3['relation']=stripslashes(($data['relatedrelation']));
			$DB1->insert('student_references',$temp3);	
		}	
			
				if($data['aluminisandip']=='Y')
		{
			$temp4['student_id']=$insert_id1;
		$temp4['is_uni_alumni']='Y';

		$temp4['person_name']=stripslashes(($data['alumininame']));
			$temp4['passing_year']=stripslashes(($data['aluminiyear']));
		$temp4['relation']=stripslashes(($data['aluminirelation']));
		$DB1->insert('student_references',$temp4);	
		}
		
		
						if($data['concern']=='Y')
		{
			$temp49['student_id']=$insert_id1;
		$temp49['is_concern_ins']='Y';

		$temp49['institute']=stripslashes(($data['cin']));
		
		$DB1->insert('student_references',$temp49);	
		}
		
		
		
		
		
		
		
			if($data['relativesandip']=='Y')
		{
		$temp5['student_id']=$insert_id1;
		$temp5['is_uni_student']='Y';
		$temp5['person_name']=stripslashes(($data['relativename']));
		$temp5['course']=stripslashes(($data['relativecoursenm']));
		$temp5['relation']=stripslashes(($data['relativerelation']));
		$DB1->insert('student_references',$temp5);	
		}
		//publicity_media
		$temp1=array();
		//$temp1=$data['publicitysandip'];
	//	$temp['publicity_media']=implode(",",$temp1);//$temp=implode("/ ",$mstatus); 
	
		if($data['refcandidatenm']!='')
		{
		$temp6['student_id']=$insert_id1;
		$temp6['is_reference']='Y';
		$temp6['person_name']=stripslashes(($data['refcandidatenm']));
		$temp6['contact_no']=stripslashes(($data['refcandidatecont']));
		$temp6['email']=stripslashes(($data['refcandidateemail']));
		$temp6['relation']=stripslashes(($data['refcandidaterelt']));
		$temp6['area_of_interest']=stripslashes(($data['refcandidateinterest']));
		
		$DB1->insert('student_references',$temp6);
		}
		//step4 end
	//	exit(0);
		//step5
	//	 $stid=$data['reg_id'];
		$temp['student_id']=$insert_id1;
		//applicable fee
//	echo "jugal";
		//total of every
	/*	$temp['totalfeeappli']=stripslashes(($data['totalfeeappli']));
		$temp['totalfeepaid']=stripslashes(($data['totalfeepaid']));
		$temp['totalfeebal']=stripslashes(($data['totalfeebal']));
		//fee paid dd details
		//$temp['paidfee']=stripslashes(($data['paidfee']));
		$temp['dd_no']=stripslashes(($data['dd_no']));
		$temp['dd_drawn_date']=stripslashes(($data['dd_date']));
		$temp['dd_drawn_bank_branch']=stripslashes(($data['dd_bank']));
		
		//bank details
		$temp['bank_name']=stripslashes(($data['bank_name']));
		$temp['account_no']=stripslashes(($data['account_no']));
		$temp['ifsc']=stripslashes(($data['ifsc']));
		//profile image
		//$temp['profile_img']=$temp['student_id'].'-'.stripslashes(($data['profile_img']));
		$temp['profile_img']=$prof_img;
		$this->db->insert('student_fee_details',$temp);
		$insert_id=$this->db->insert_id();
*/

	
		//step5 end
		
	//	echo "ankur";
		//exit(0);
		
		return $prnj;
	}

	
	
	
	
	
	
	
	
	
	
	
	function check_flag_status($id){
		$this->db->select('step_first_flag,step_second_flag,step_third_flag,step_fourth_flag,step_fifth_flag');
		$this->db->from('student_formfill_status');
		$this->db->where('student_id',$id);
		$query=$this->db->get();
		/* echo $this->db->last_query();
		die();   */
		$result=$query->result_array();
		return $result;		
	}
	function getstep1_data($id){
		$this->db->select('st.*,per.*,g.*');
		$this->db->from('student_registration_part1 as st');
		$this->db->join('personal_details as per','per.student_id = st.student_id','left');
		$this->db->join('parent_details as g','g.student_id = st.student_id','left');
		$this->db->where('st.reg_id',$id);
		$query=$this->db->get();
		/* echo $this->db->last_query();
		die(); */ 
		$result=$query->result_array();
		return $result; 
	}
	
	function ums_student_data($id){
		$this->db->select('*');
		$this->db->from('student_registration_part1');
		$this->db->where('student_id',$id);
		$query=$this->db->get();
		//echo $this->db->last_query();
		//die();  
		$result=$query->result_array();
		/* print_r($result);
		die(); */
		return $result; 
	}
	
	
	
	function getstep1_data2($id){
		$this->db->select('*');
		$this->db->from('student_registration_part1');
		$this->db->where('student_id',$id);
		$query=$this->db->get();
		//echo $this->db->last_query();
		//die();  
		$result=$query->result_array();
		/* print_r($result);
		die(); */
		return $result; 
	}
	function getstep1_data1($id){
		$this->db->select('st.*,per.*,g.*');
		$this->db->from('student_registration_part1 as st');
		$this->db->join('personal_details as per','per.student_id = st.student_id','left');
		$this->db->join('parent_details as g','g.student_id = st.student_id','left');
		$this->db->where('st.student_id',$id);
		$query=$this->db->get();
		$result=$query->result_array();
		return $result; 
	}
	function getstudent_certificate_data($id){
	 $this->db->select('*');
		$this->db->from('student_certificate_details');
		$this->db->where('student_id',$id);
		$query=$this->db->get();
		/* echo $this->db->last_query();
		die();  */
		$result=$query->result_array();
		return $result; 
		}
		function getstudent_education_data($id){
	    $this->db->select('*');
		$this->db->from('education_details');
		$this->db->where('student_id',$id);
		$query=$this->db->get();
		/* echo $this->db->last_query();
		die();  */
		$result=$query->result_array();
		return $result; 
		}
		function qualifying_exam_details($id){
	    $this->db->select('*');
		$this->db->from('qualifying_exam_details');
		$this->db->where('student_id',$id);
		$query=$this->db->get();
		/* echo $this->db->last_query();
		die(); */ 
		$result=$query->result_array();
		return $result; 
		}
		function getstud_document_details($id){
		      $DB1 = $this->load->database('umsdb', TRUE); 
	    $this->db->select('*');
		$this->db->from('student_documentlist');
		$this->db->where('student_id',$id);
		$query=$this->db->get();
		/* echo $this->db->last_query();
		die(); */ 
		$result=$query->result_array();
		return $result; 
		}
		function getstud_references_details($id){
	    $this->db->select('*');
		$this->db->from('student_reference');
		$this->db->where('student_id',$id);
		$query=$this->db->get();
		/* echo $this->db->last_query();
		die(); */ 
		$result=$query->result_array();
		return $result; 
		}
		function getstud_fee_details($id){
	    $this->db->select('*');
		$this->db->from('student_fee_details');
		$this->db->where('student_id',$id);
		$query=$this->db->get();
		/* echo $this->db->last_query();
		die(); */ 
		$result=$query->result_array();
		return $result; 
		}
		
			
	function registration_step2($data){
  echo"am in step 2 model";
		/* echo"<pre>";
		print_r($data);
		echo"</pre>";  
		die(); */
		$stid=$data['reg_id'];
		$edu['student_id']=stripslashes(($data['reg_id']));
		$edu['qexam_name']=stripslashes(($data['qexam']));
		$edu['qexam_pyear']=stripslashes(($data['pyexam']));
		$edu['qexam_colleg']=stripslashes(($data['cexam']));
		$edu['adm_basis']=stripslashes(($data['admission_basis']));
		$edu['qexam_roll']=stripslashes(($data['roll_exam']));
		$edu['qexam_rank']=stripslashes(($data['exam_rank']));
		$edu['hscpass_date']=stripslashes(($data['hscpass_date']));
		$edu['htotal_phy']=stripslashes(($data['thsc_phy']));
		$edu['htotal_chem']=stripslashes(($data['thsc_chem']));
		$edu['htotal_bio']=stripslashes(($data['thsc_bio']));
		$edu['htotal_eng']=stripslashes(($data['thsc_eng']));
		$edu['hobt_phy']=stripslashes(($data['ohsc_phy']));
		$edu['hobt_chem']=stripslashes(($data['ohsc_chem']));
		$edu['hobt_bio']=stripslashes(($data['ohsc_bio']));
		$edu['hobt_eng']=stripslashes(($data['ohsc_eng']));
		$edu['ssc_passing_dt']=stripslashes(($data['sscpass_date']));
		$edu['stotal_eng']=stripslashes(($data['tssc_eng']));
		$edu['sobt_eng']=stripslashes(($data['ossc_eng']));
		
		//academic History
		$len=sizeof($data['exam_id'],1);
		//echo $len;
		for($i=0;$i<$len;$i++){
		$academic['student_id']=stripslashes(($data['reg_id']));
		$academic['exam_id']=stripslashes(($data['exam_id'][$i]));
		$academic['college_name']=stripslashes(($data['college_name'][$i]));
		$academic['pass_year']=stripslashes(($data['pass_year'][$i]));
		$academic['pass_month']=stripslashes(($data['pass_month'][$i]));
		$academic['seat_no']=stripslashes(($data['seat_no'][$i]));
		$academic['institute_name']=stripslashes(($data['institute_name'][$i]));
		$academic['marks_obtained']=stripslashes(($data['marks_obtained'][$i]));
		$academic['marks_outof']=stripslashes(($data['marks_outof'][$i]));
		$academic['percentage']=($academic['marks_obtained']/$academic['marks_outof'])*100;// % calulation
		//$academic['percentage']=stripslashes(($data['percentage'][$i]));
		$this->db->insert('education_details',$academic);
		}
	
		$insert_id1 = $this->db->insert_id();
		$this->db->insert('qualifying_exam_details',$edu);
		$insert_id2 = $this->db->insert_id();
		if(!empty($insert_id2)&&$insert_id2!=0){
			$update_flag="UPDATE `student_formfill_status` SET step_second_flag=1 where student_id='$stid'";
			$res_flg=$this->db->query($update_flag);
			}
		return $insert_id1;
	}
	
	function registration_step3($data,$arr){
		//$data['filescan']=$_FILES['scandoc']['name'];
		//$data['filesize']=$_FILES['scandoc']['size'];
		$stid=$data['reg_id'];
		$temp['student_id']=stripslashes(($data['reg_id']));
		$temp['doc_id']= $this->rearrange1($data['dapplicable']);//without changing key value sequence
		$temp['doc_applicable']	= $this->rearrange1($data['dapplicable']);
		$temp['ox']	= $this->rearrange1($data['ox']);
		$temp['sub_dt']	= $this->rearrange1($data['docsubdate']);
		$temp['remark']	= $this->rearrange1($data['remark']);
		//$temp['doc_path']= $this->rearrange1($data['filescan']); 
		$temp['doc_path']= $arr;//$this->rearrange1($data['filescan']); 
		$list=array();
		$list=array_keys( $temp['doc_id']);
		$temp['doc_id']=$list;
		$list=array_combine($temp['doc_id'],$temp['doc_id']);
		 $temp['doc_id']=$list;
		 
	      foreach($temp['doc_id'] as $key=>$val){
		     $temp2['doc_id'][$key]=$temp['doc_id'][$key];
			 $temp2['doc_applicable'][$key]=$temp['doc_applicable'][$key];
			 $temp2['ox'][$key]=$temp['ox'][$key];
			 $temp2['sub_dt'][$key]=$temp['sub_dt'][$key];
			 $temp2['remark'][$key]=$temp['remark'][$key];
			 $temp2['doc_path'][$key]=$temp['doc_path'][$key];
			 }
		// for certificate details
		$cert['certificate_name']=$data['cnm'];
		$cert['certificate_no']=$data['cno'];
		$cert['cissue_dt']=$data['issuedt'];
		$cert['cvalidity']=$data['cval'];
			
		$len=sizeof($cert['certificate_name']);
		//echo $len;
		
		for($i=0;$i<$len;$i++){
		$a['student_id']=stripslashes(($data['reg_id']));
		$a['certificate_name']=	$cert['certificate_name'][$i];
		$a['certificate_no']=	$cert['certificate_no'][$i];
		$a['cissue_dt']=$cert['cissue_dt'][$i];
		$a['cvalidity']=$cert['cvalidity'][$i];
		$insert_id11 =$this->db->insert('student_certificate_details',$a);
		}
		//end
	
			foreach($temp2['doc_id'] as $key=>$val){
			$temp1['student_id']=stripslashes(($data['reg_id']));
			$temp1['doc_id']=stripslashes(($temp2['doc_id'][$key]));
			$temp1['doc_applicable']=stripslashes(($temp2['doc_applicable'][$key]));
			$temp1['ox']=stripslashes(($temp2['ox'][$key]));
			$temp1['remark']=stripslashes(($temp2['remark'][$key]));
			$temp1['sub_dt']=stripslashes(($temp2['sub_dt'][$key]));
			$temp1['doc_path']=stripslashes(($temp2['doc_path'][$key]));
			
			$insert_id1 =$this->db->insert('student_documentlist',$temp1);
		}  
		$insert_id1 = $this->db->insert_id();
		if(!empty($insert_id1)&&$insert_id1!=0){
			$update_flag="UPDATE `student_formfill_status` SET step_third_flag=1 where student_id='$stid'";
			$res_flg=$this->db->query($update_flag);
			}
		return 	$insert_id1;
	}
	

	
	
	function registration_step4($data){
        
        $DB1 = $this->load->database('umsdb', TRUE);
	 $student_id=$this->session->userdata('studId');		
	//	$temp['student_id']=$insert_id1;


   $DB1->where('student_id', $student_id);
   $DB1->delete('student_references');
   
if($data['fref1']!='')
{
	$temp['student_id']=$student_id;
		$temp['is_from_reference']='Y';
		$temp['person_name']=stripslashes(($data['fref1']));
		$temp['contact_no']=stripslashes(($data['frefcont1']));
	$DB1->insert('student_references',$temp);
}
if($data['fref2']!='')
{
		$temp2['student_id']=$student_id;
		$temp2['is_from_reference']='Y';
		$temp2['person_name']=stripslashes(($data['fref2']));
		$temp2['contact_no']=stripslashes(($data['frefcont2']));
			$DB1->insert('student_references',$temp2);	
}	
		
	if($data['reletedsandip']=='Y')
{
	
		$temp3['student_id']=$student_id;
		$temp3['is_uni_employed']='Y';
		$temp3['person_name']=stripslashes(($data['relatedname']));
		$temp3['designation']=stripslashes(($data['relateddesig']));
		$temp3['relation']=stripslashes(($data['relatedrelation']));
			$DB1->insert('student_references',$temp3);	
}		
		
		
			if($data['aluminisandip']=='Y')
{	
			$temp4['student_id']=$student_id;
		$temp4['is_uni_alumni']='Y';

		$temp4['person_name']=stripslashes(($data['alumininame']));
			$temp4['passing_year']=stripslashes(($data['aluminiyear']));
		$temp4['relation']=stripslashes(($data['aluminirelation']));
		$DB1->insert('student_references',$temp4);	
	}
	
	
			
						if($data['concern']=='Y')
		{
			$temp49['student_id']=$insert_id1;
		$temp49['is_concern_ins']='Y';

		$temp49['institute']=stripslashes(($data['cin']));
		
		$DB1->insert('student_references',$temp49);	
		}
		
		
				if($data['relativesandip']=='Y')
{	
	//	echo "jugal";
	//	exit();
		$temp5['student_id']=$student_id;
		$temp5['is_uni_student']='Y';
		$temp5['person_name']=stripslashes(($data['relativename']));
		$temp5['course_name']=stripslashes(($data['relativecoursenm']));
		$temp5['relation']=stripslashes(($data['relativerelation']));
		$DB1->insert('student_references',$temp5);	
	//	echo $DB1->last_query();
}
		//publicity_media
		$temp1=array();
		//$temp1=$data['publicitysandip'];
	//	$temp['publicity_media']=implode(",",$temp1);//$temp=implode("/ ",$mstatus); 
	
		$temp6['student_id']=$student_id;
		$temp6['is_reference']='Y';
		$temp6['person_name']=stripslashes(($data['refcandidatenm']));
		$temp6['contact_no']=stripslashes(($data['refcandidatecont']));
		$temp6['email']=stripslashes(($data['refcandidateemail']));
		$temp6['relation']=stripslashes(($data['refcandidaterelt']));
		$temp6['area_of_interest']=stripslashes(($data['refcandidateinterest']));
		
		$DB1->insert('student_references',$temp6);
	//	echo $DB1->last_query();
	//var_dump($data['publicitysandip']);
	
		$tempe['about_uni_know']=implode(",",$data['publicitysandip']);//$temp=implode("/ ",$mstatus); 
	
		$DB1->where('stud_id', $student_id);
		$DB1->update('student_master',$tempe);
	
	
	
	
	
	
		
	}
	
	function registration_step5($data){
	   // error_reporting(E_ALL);
//ini_set('display_errors', 1);
	     $student_id = $this->session->userdata('studId');

	     
	     $std = $this->fetch_personal_details($student_id);
	     $form = $std[0]['form_number'];
	    
	    $array = explode('.', $_FILES['profile_img']['name']);
$extension = end($array);

$structure = 'uploads/student_photo/'.$form;

// To create the nested structure, the $recursive parameter 
// to mkdir() must be specified.

/*if (!mkdir($structure, 0777, true)) {
  //  die('Failed to create folders...');
}*/
	    	 if(!empty($_FILES['profile_img']['name'])){
		     
				 //$filenm=$student_id.'-'.$_FILES['profile_img']['name'];
				// $filenm=$form.'_PHOTO.'.$extension;
				  $filenm=$std[0]['enrollment_no'].'.jpg'; //$std
				 // echo $filenm;
			//	  exit();
			//	 echo "jugal";
				 //P057_PHOTO
                $config['upload_path'] = 'uploads/student_photo/';
                $config['allowed_types'] = 'jpg';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('profile_img')){
                    //	var_dump($_FILES['profile_img']['name']);
		//exit();
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                   // $temp['student_photo_path'] = $picture ;
                  //  $DB1->where('stud_id', $student_id);
	//	$DB1->update('student_master',$temp);
                }else{
                    $picture = '';
                }
            }
			else{
                $picture = '';
            }
	    
	    
	    
	   // exit(0);
	    
	    
	    
	    
	    
	    
	    
	    /*  update registration details final jugal
	    $DB1 = $this->load->database('umsdb', TRUE);
	  $student_id = $this->session->userdata('studId');
	    	 // $feedet['student_id']=$data['student_id'];
	    	  
	    	          $feedet['amount']=$data['totalfeepaid'];
	    //	     $exam['passing_year']=$data['supass_month']."-".$data['supass_year']; 
	 			$feedet['receipt_no']=$data['dd_no'];
	 			$feedet['fees_date']=$data['dd_date']; 
	 			$feedet['bank_id']=$data['dd_bank'];
	 			$feedet['bank_city']=$data['dd_bank_branch'];
	    	      // 	$DB1->insert('fees_details',$feedet);  
	    	       	
	    	       		$DB1->where('student_id', $student_id);
		$DB1->update('fees_details',$feedet);
	        
	        //  $sbank['student_id']=$insert_id1;
	    	          $sbank['account_no']=$data['account_no'];
	    //	     $exam['passing_year']=$data['supass_month']."-".$data['supass_year']; 
	 			$sbank['ifsc_code']=$data['ifsc'];
	 			$sbank['bank_name']=$data['bank_name']; 
	 
	 			$sbank['bank_city']=$data['bank_branch'];
	    	    //   	$DB1->insert('student_bank_details',$sbank);    
	    	    
	    	    	$DB1->where('student_id', $student_id);
		$DB1->update('student_bank_details',$sbank);
		
	
		
		 if(!empty($_FILES['profile_img']['name'])){
		     
				 $filenm=$student_id.'-'.$_FILES['profile_img']['name'];
                $config['upload_path'] = 'uploads/student_profilephotos/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('profile_img')){
                    //	var_dump($_FILES['profile_img']['name']);
		//exit();
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                    $temp['student_photo_path'] = $picture ;
                    $DB1->where('stud_id', $student_id);
		$DB1->update('student_master',$temp);
                }else{
                    $picture = '';
                }
            }
			else{
                $picture = '';
            }
		
		
		
		
		
		 if(!empty($_FILES['payfile']['name'])){
		     
				 $filenm=$student_id.'-'.$_FILES['payfile']['name'];
                $config['upload_path'] = 'uploads/student_challans/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('payfile')){
                    //	var_dump($_FILES['profile_img']['name']);
		//exit();
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                    $feedet['receipt_file'] = $picture ;
                    $DB1->where('student_id', $student_id);
		$DB1->update('fees_details',$feedet);
                }else{
                    $picture = '';
                }
            }
			else{
                $picture = '';
            }
		
		
		
		
		
		*/
		
		
		
	    
	}

	function upload_student_photo($data){
	   	// error_reporting(E_ALL);
		//ini_set('display_errors', 1);
	    	 $enrollment_no = $this->session->userdata('name');
		     $std = $this->fetch_personal_details_enrollment_no($enrollment_no);
		     //$form = $std[0]['form_number'];
	    
	    	$array = explode('.', $_FILES['profile_img']['name']);
			$extension = end($array);
			//$structure = 'uploads/student_photo/'.$form;

				// To create the nested structure, the $recursive parameter 
				// to mkdir() must be specified.

				/*if (!mkdir($structure, 0777, true)) {
				  //  die('Failed to create folders...');
				}*/
	    	 if(!empty($_FILES['profile_img']['name'])){
		     
				 //$filenm=$student_id.'-'.$_FILES['profile_img']['name'];
				// $filenm=$form.'_PHOTO.'.$extension;
				  $filenm=$std[0]['enrollment_no'].'.jpg'; //$std
				  echo $filenm;
			 
			//	 echo "jugal";
				 //P057_PHOTO

                $config['upload_path'] = 'uploads/student_photo/';
                $config['allowed_types'] = 'jpg';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('profile_img')){
                	
                    //	var_dump($_FILES['profile_img']['name']);
		//exit();
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];

                   // $temp['student_photo_path'] = $picture ;
                  //  $DB1->where('stud_id', $student_id);
	//	$DB1->update('student_master',$temp);
                }else{
                	
                    $picture = '';
                }
            }
			else{
                $picture = '';
            }
	    
	    
	   
		
	    
	}
	

	function rearrange1($arr){
		   $new_arr1 = $arr;
		  foreach ($new_arr1 as $key=>$val) {
	      if ($val === null||$val ==='')
          unset($new_arr1[$key]);
	         }
	 return $new_arr1;
	}
	////////////Update Function //////////////
	
		function update_stepfirstdata($data){
	      $DB1 = $this->load->database('umsdb', TRUE);
	    $student_id=$data['student_id'];
	//$student_id ='61';
	//	exit(0);
	//	$temp['admission_school']=$this->Ums_admission_model->getschool_bycourse($data['admission-course']); 	
		//course
	//	$temp['admission_stream']=stripslashes(($data['admission-branch'])); 	
		//student name
		$temp['first_name']=strtoupper(stripslashes(($data['sfname']))); 		
		$temp['middle_name']=strtoupper(stripslashes(($data['smname']))); 		
		$temp['last_name']=strtoupper(stripslashes(($data['slname']))); 
        
		$temp['gender']=stripslashes(($data['gender'])); 
		$temp['blood_group']=stripslashes(($data['blood_gr'])); 
		$temp['dob']=stripslashes(($data['dob'])); 
			$temp['birth_place']=stripslashes(($data['pob'])); 
		$temp['mobile']=stripslashes(($data['mobile'])); 
		$temp['email']=stripslashes(($data['email_id'])); 
		$temp['nationality']=stripslashes(($data['nationality'])); 
		$temp['category']=stripslashes(($data['category']));  
			$temp['sub_caste']=stripslashes(($data['subcaste']));
		$temp['admission_date']=stripslashes(($data['doadd']));
		
		//$temp['sub_caste']=stripslashes(($data['sub_caste']));  
		$temp['religion']=stripslashes(($data['religion'])); 
		$temp['adhar_card_no']=stripslashes(($data['saadhar'])); 
		$temp['passport_no']=stripslashes(($data['passport_no']));
		$temp['visa_no']=stripslashes(($data['visa_no']));
		$temp['domicile_status']=stripslashes(($data['res_state'])); 
	
		$temp['father_fname']=strtoupper(stripslashes(($data['sfname1']))); 		
		$temp['father_mname']=strtoupper(stripslashes(($data['smname1']))); 		
		$temp['father_lname']=strtoupper(stripslashes(($data['slname1']))); 
         // student mother name		
		$temp['mother_name']=strtoupper(stripslashes(($data['sfname2']))); 
		//	$temp['student_photo_path']=$picture;
		//	$temp['about_uni_know']=implode(",",$data['publicitysandip']);//$temp=implode("/ ",$mstatus); 
	
		$temp['is_defence']=isset($data['defperson']) ? Y : 'N'; 		
		$temp['is_JKMigrant']= isset($data['jk']) ? Y : 'N'; //strtoupper(stripslashes(($data['slname1']))); 
		$temp['physically_handicap']= isset($data['pwd']) ? Y : 'N';
		
		
		
			$temp['general_reg_no']=strtoupper(stripslashes(($data['sgrn']))); 		
		$temp['last_institute']=strtoupper(stripslashes(($data['linst']))); 
		
		
		
		
		   	$temp['academic_year']= strtoupper(stripslashes(($data['acyear'])));;
       
       	$admission_type=stripslashes(($data['admission_type']));
       	
     /*  if($admission_type==1)
       {
        	$temp['admission_year']='1';    
        	$temp['admission_semester']='1';
        	$temp['lateral_entry']='N';
        	$temp['current_semester']='1';
       }
     if($admission_type==2)
       {
           $temp['admission_year']='2';    
        	$temp['admission_semester']='3';
        	$temp['lateral_entry']='Y';
        	$temp['current_semester']='3';
       }
       */
       
  //    $temp['entry_from_ip']= $_SERVER['REMOTE_ADDR'];
      $temp['modified_on']= date('Y-m-d H:i:s');
      $temp['modified_by']= $_SESSION['uid'];
		
		
		
		
		
		
		
		
		/***Address details***/
		//local address bill_A
		
		
	  
		
		//Guardians details  parent_details
		
		$DB1->where('stud_id', $student_id);
		$DB1->update('student_master',$temp);
		
	   // $DB1->insert('student_master',$temp);
	     	//echo $DB1->last_query();
	//	$insert_id1 = $DB1->insert_id();
	
	
	  $admdetails['hostel_required']=$data['hostel'];
	  $admdetails['hostel_type']=$data['hosteltype'];
	  $admdetails['transport_required']=$data['transport'];
	  $admdetails['transport_boarding_point']=$data['bording_point'];
	    	       	    //  $admdetails['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
	    	       	      //	  $admdetails['allowed_by']='Admin';
	  $admdetails['modified_on']=date('Y-m-d H:i:s');
      $admdetails['modified_by']= $_SESSION['uid'];
		$DB1->where('student_id', $student_id);
		$DB1->update('admission_details',$admdetails);
		
	
		
	}	
	
	
	
	
	function update_address($data){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		
		
		//print_r($data);
		//exit();
	    $student_id=$data['student_id'];
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	                                                                             //Address
        $DB1->select('student_id');
		$DB1->from('address_details');
		$DB1->where('student_id', $student_id);
		$DB1->where('adds_of','STUDENT');
		$DB1->where('address_type','CORS');
		$queryc=$DB1->get();
	
//echo $DB1->last_query();

//exit();
		$resultc=$queryc->result_array();
		
		$resultc['student_id'];
		//print_r($resultp[0]['student_id']);
		if(empty($resultc[0]['student_id'])){
			 //  $address['adds_of']='STUDENT'; 
	//	$address['address_type']='CORS'; 
		$address['address']=stripslashes(($data['laddress'])); 
	//	$address['street']=stripslashes(($data['bill_B'])); 
		$address['city']=stripslashes(($data['lcity'])); 
		$address['state_id']=stripslashes(($data['lstate_id'])); 
		$address['district_id']=stripslashes(($data['ldistrict_id'])); 
		$address['pincode']=stripslashes(($data['lpincode']));
		//$address['student_id']=$insert_id1;	
		$address['student_id']=$student_id;
		//$DB1->where('student_id', $student_id);
		//$DB1->where('adds_of','STUDENT');
		//$DB1->where('address_type','CORS');
		$DB1->insert('address_details',$address);
		}else{
		
	    //  $address['adds_of']='STUDENT'; 
	//	$address['address_type']='CORS'; 
		$address['address']=stripslashes(($data['laddress'])); 
	//	$address['street']=stripslashes(($data['bill_B'])); 
		$address['city']=stripslashes(($data['lcity'])); 
		$address['state_id']=stripslashes(($data['lstate_id'])); 
		$address['district_id']=stripslashes(($data['ldistrict_id'])); 
		$address['pincode']=stripslashes(($data['lpincode']));
		//$address['student_id']=$insert_id1;	
		
		$DB1->where('student_id', $student_id);
		$DB1->where('adds_of','STUDENT');
		$DB1->where('address_type','CORS');
		$DB1->update('address_details',$address);
		
		}
		
	//	$DB1->insert('address_details',$address);
	     
	//	$insert_id1 = $this->db->insert_id();
		$DB1->select('student_id');
		$DB1->from('address_details');
		$DB1->where('student_id', $student_id);
		$DB1->where('adds_of','STUDENT');
		$DB1->where('address_type','PERMNT');
		$queryp=$DB1->get();
	
//echo $DB1->last_query();

//exit();
		$resultp=$queryp->result_array();
		
		$resultp['student_id'];
		//print_r($resultp[0]['student_id']);
		if(empty($resultp[0]['student_id'])){
			//echo 'Insert';
	    $paddress['adds_of']='STUDENT'; 
		$paddress['address_type']='PERMNT'; 
		$paddress['address']=stripslashes(($data['paddress'])); 
	//	$paddress['street']=stripslashes(($data['bshipping_B'])); 
		$paddress['city']=stripslashes(($data['pcity'])); 
		$paddress['state_id']=stripslashes(($data['pstate_id'])); 
		$paddress['district_id']=stripslashes(($data['pdistrict_id'])); 
		$paddress['pincode']=stripslashes(($data['ppincode']));
	//	$paddress['student_id']=$insert_id1;
	    $paddress['student_id']=$student_id;
		//$DB1->where('student_id', $student_id);
		//$DB1->where('adds_of','STUDENT');
		//$DB1->where('address_type','PERMNT');
		$DB1->insert('address_details',$paddress);
		}else{
			//echo 'update';
	    $paddress['adds_of']='STUDENT'; 
		$paddress['address_type']='PERMNT'; 
		$paddress['address']=stripslashes(($data['paddress'])); 
	//	$paddress['street']=stripslashes(($data['bshipping_B'])); 
		$paddress['city']=stripslashes(($data['pcity'])); 
		$paddress['state_id']=stripslashes(($data['pstate_id'])); 
		$paddress['district_id']=stripslashes(($data['pdistrict_id'])); 
		$paddress['pincode']=stripslashes(($data['ppincode']));
	//	$paddress['student_id']=$insert_id1;
	
		$DB1->where('student_id', $student_id);
		$DB1->where('adds_of','STUDENT');
		$DB1->where('address_type','PERMNT');
		$DB1->update('address_details',$paddress);
		}
		
		
		//exit();
         // permenant	address	
	   
	
	
	
	
	
	
			//$DB1->insert('address_details',$paddress);
		
		
		
		
		/*// $gpaddress['adds_of']='PARENT'; 
	//	$gpaddress['address_type']='PERMNT'; 
	   // $gpaddress['student_id']=$insert_id1;
	 	$gpaddress['address']=stripslashes(($data['gparent_address'])); 
	//	$paddress['street']=stripslashes(($data['bshipping_B'])); 
		$gpaddress['city']=stripslashes(($data['gcity'])); 
		$gpaddress['state_id']=stripslashes(($data['gstate_id'])); 
		$gpaddress['district_id']=stripslashes(($data['gdistrict_id'])); 
		$gpaddress['pincode']=stripslashes(($data['gpincode']));
		//	$DB1->insert('address_details',$gpaddress);
			
			
			
		$DB1->where('student_id', $student_id);
		$DB1->where('adds_of','PARENT');
		$DB1->where('address_type','PERMNT');
		$DB1->update('address_details',$gpaddress);*/
	
			
			
			
			
			
			
	
		//	$insert_id2 = $DB1->insert_id();
	 
	 //	$insert_id1 = $this->db->insert_id();
		$DB1->select('student_id');
		$DB1->from('parent_details');
		$DB1->where('student_id', $student_id);
		//$DB1->where('adds_of','STUDENT');
		//$DB1->where('address_type','PERMNT');
		$queryper=$DB1->get();
	
//echo $DB1->last_query();

//exit();
		$resultper=$queryper->result_array();
		
		$resultper['student_id'];
		//print_r($resultp[0]['student_id']);
		if(empty($resultper[0]['student_id'])){

	// $guardian['student_id']=stripcslashes($insert_id1);
			//   $guardian['enrollement_no']=stripcslashes($stid);
		$guardian['gfirst_name']=strtoupper(stripslashes(($data['fname']))); 
		$guardian['gmiddle_name']=strtoupper(stripslashes(($data['mname']))); 
		$guardian['glast_name']=strtoupper(stripslashes(($data['lname']))); 
		$guardian['relation']=stripslashes(($data['relationship'])); 
		$guardian['occupation']=stripslashes(($data['occupation'])); 
		$guardian['income']=stripslashes(($data['annual_income'])); 
		$guardian['parent_email']=stripslashes(($data['parent_email'])); 
		$guardian['parent_mobile2']=stripslashes(($data['parent_mobile'])); 
		$guardian['parent_mobile1']=stripslashes(($data['parent_phone'])); 
	//	$guardian['address_id']=stripslashes($insert_id2);
	    //	$DB1->insert('parent_details',$guardian);
		$guardian['student_id']=$student_id;
		 	//$DB1->where('student_id', $student_id);
	//	$DB1->where('adds_of','PARENT');
		//$DB1->where('address_type','PERMNT');
		
		$DB1->insert('parent_details',$guardian);
		}else{
			// $guardian['student_id']=stripcslashes($insert_id1);
			//   $guardian['enrollement_no']=stripcslashes($stid);
		$guardian['gfirst_name']=strtoupper(stripslashes(($data['fname']))); 
		$guardian['gmiddle_name']=strtoupper(stripslashes(($data['mname']))); 
		$guardian['glast_name']=strtoupper(stripslashes(($data['lname']))); 
		$guardian['relation']=stripslashes(($data['relationship'])); 
		$guardian['occupation']=stripslashes(($data['occupation'])); 
		$guardian['income']=stripslashes(($data['annual_income'])); 
		$guardian['parent_email']=stripslashes(($data['parent_email'])); 
		$guardian['parent_mobile2']=stripslashes(($data['parent_mobile'])); 
		$guardian['parent_mobile1']=stripslashes(($data['parent_phone'])); 
	//	$guardian['address_id']=stripslashes($insert_id2);
	    //	$DB1->insert('parent_details',$guardian);
		
		 	$DB1->where('student_id', $student_id);
	//	$DB1->where('adds_of','PARENT');
		//$DB1->where('address_type','PERMNT');
		
		$DB1->update('parent_details',$guardian);
		}
//	echo $DB1->last_query();
//	exit(0);
	}
	
	function reregistration_details($data){
	      $DB1 = $this->load->database('umsdb', TRUE);
	    $student_id=$data['student_id'];
	    if($data['isdetained']=='Y') 
	    {
	    	
			$temp['first_name']=strtoupper(stripslashes(($data['sfname']))); 		
			$temp['middle_name']=strtoupper(stripslashes(($data['smname']))); 		
			$temp['last_name']=strtoupper(stripslashes(($data['slname']))); 

			$temp['gender']=stripslashes(($data['gender'])); 
			$temp['blood_group']=stripslashes(($data['blood_gr'])); 
			$temp['dob']=stripslashes(($data['dob'])); 
				$temp['birth_place']=stripslashes(($data['pob'])); 
			$temp['mobile']=stripslashes(($data['mobile'])); 
			$temp['email']=stripslashes(($data['email_id'])); 
			$temp['nationality']=stripslashes(($data['nationality'])); 
			$temp['category']=stripslashes(($data['category']));  
			//$temp['sub_caste']=stripslashes(($data['sub_caste']));  
			$temp['religion']=stripslashes(($data['religion'])); 
			$temp['adhar_card_no']=stripslashes(($data['saadhar'])); 
			$temp['passport_no']=stripslashes(($data['passport_no']));
			$temp['visa_no']=stripslashes(($data['visa_no']));
			$temp['domicile_status']=stripslashes(($data['res_state'])); 

			$temp['father_fname']=strtoupper(stripslashes(($data['sfname1']))); 		
			$temp['father_mname']=strtoupper(stripslashes(($data['smname1']))); 		
			$temp['father_lname']=strtoupper(stripslashes(($data['slname1']))); 
			 // student mother name		
			$temp['mother_name']=strtoupper(stripslashes(($data['sfname2']))); 
			//	$temp['student_photo_path']=$picture;
			//	$temp['about_uni_know']=implode(",",$data['publicitysandip']);//$temp=implode("/ ",$mstatus); 




			   	$temp['academic_year']= stripslashes(($data['hacyear'])) + 1;

				$temp['current_year']=stripslashes(($data['hcyear']));

				$temp['current_semester']=stripslashes(($data['hcsem']));


			//    $temp['entry_from_ip']= $_SERVER['REMOTE_ADDR'];
			$temp['modified_on']= date('Y-m-d H:i:s');
			$temp['modified_by']= $_SESSION['uid'];
			$temp['is_detained']='N';

			//Guardians details  parent_details

			$DB1->where('stud_id', $student_id);
			$DB1->update('student_master',$temp);

			//update student_detaintion_details 

			$studentdetentionsdetails['is_detained']='N';
			$studentdetentionsdetails['modified_on']= date('Y-m-d H:i:s');
			$studentdetentionsdetails['modified_by']= $_SESSION['uid'];
			$studentdetentionsdetails['modified_remark']='Natural by Re-registration process ';
			$DB1->where('stud_id', $student_id);
			$DB1->update('student_detaintion_details',$studentdetentionsdetails);

			// $DB1->insert('student_master',$temp);
			 	//echo $DB1->last_query();
			//	$insert_id1 = $DB1->insert_id();


			$admdetails['student_id'] = $student_id;
			$admdetails['hostel_required']=$data['hostel'];
				       	   $admdetails['hostel_type']=$data['hosteltype'];
				       	    $admdetails['transport_required']=$data['transport'];
				       	     $admdetails['transport_boarding_point']=$data['bording_point'];
				       	     
				       	     
				       	     
			   $neacyearj =	$admdetails['academic_year']=stripslashes(($data['hacyear'])) + 1;

				$admdetails['year']=stripslashes(($data['hcyear']));
				/*$admdetails['actual_fee']=stripslashes(($data['acd_totalfee'])) ;
				 	$admdetails['applicable_fee']=stripslashes(($data['acd_totalfee'])) ;*/
				 	$admdetails['actual_fee']='0' ;
				 	$admdetails['applicable_fee']='0' ;
				 		$admdetails['opening_balance']=stripslashes(($data['open_bal'])) ;
				 	
			//	$temp['current_semester']=strtoupper(stripslashes(($data['hcsem']))) + 2;
				       	    //  $admdetails['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
				       	      //	  $admdetails['allowed_by']='Admin';
				            $admdetails['created_on']= date('Y-m-d H:i:s');
			$admdetails['created_by']= $_SESSION['uid'];
			$admdetails['form_number']= stripslashes(($data['sfnumber']));
			$admdetails['enrollment_no']= stripslashes(($data['henroll']));
			$admdetails['school_code']= stripslashes(($data['hschool']));
			$admdetails['stream_id']= stripslashes(($data['hstream']));
			$admdetails['entry_from_ip']= $_SERVER['REMOTE_ADDR'];

			$dup = $this->fetch_admission_details($student_id,$neacyearj);
			//  $dup = $this->fetch_admission_details(2,$neacyearj);
			// echo $dup[0]['student_id'];
			//  var_dump($dup);
			// exit();
			if($dup[0]['student_id']=='')
			{
			$DB1->insert('admission_details',$admdetails);
			}
			//  echo $DB1->last_query();
			//  exit(0);
			//	$DB1->where('student_id', $student_id);
			//	$DB1->update('admission_details',$admdetails);



			$address['address']=stripslashes(($data['laddress'])); 
			//	$address['street']=stripslashes(($data['bill_B'])); 
			$address['city']=stripslashes(($data['lcity'])); 
			$address['state_id']=stripslashes(($data['lstate_id'])); 
			$address['district_id']=stripslashes(($data['ldistrict_id'])); 
			$address['pincode']=stripslashes(($data['lpincode']));

				$DB1->where('student_id', $student_id);
			$DB1->where('adds_of','STUDENT');
				$DB1->where('address_type','CORS');

			$DB1->update('address_details',$address);




			 // permenant	address	
			$paddress['adds_of']='STUDENT'; 
			$paddress['address_type']='PERMNT'; 
			$paddress['address']=stripslashes(($data['paddress'])); 
			//	$paddress['street']=stripslashes(($data['bshipping_B'])); 
			$paddress['city']=stripslashes(($data['pcity'])); 
			$paddress['state_id']=stripslashes(($data['pstate_id'])); 
			$paddress['district_id']=stripslashes(($data['pdistrict_id'])); 
			$paddress['pincode']=stripslashes(($data['ppincode']));
			//	$paddress['student_id']=$insert_id1;

			$DB1->where('student_id', $student_id);
			$DB1->where('adds_of','STUDENT');
				$DB1->where('address_type','PERMNT');

			$DB1->update('address_details',$paddress);






					$gpaddress['address']=stripslashes(($data['gparent_address'])); 
			//	$paddress['street']=stripslashes(($data['bshipping_B'])); 
			$gpaddress['city']=stripslashes(($data['gcity'])); 
			$gpaddress['state_id']=stripslashes(($data['gstate_id'])); 
			$gpaddress['district_id']=stripslashes(($data['gdistrict_id'])); 
			$gpaddress['pincode']=stripslashes(($data['gpincode']));
			//	$DB1->insert('address_details',$gpaddress);
				
				
				
				$DB1->where('student_id', $student_id);
			$DB1->where('adds_of','PARENT');
				$DB1->where('address_type','PERMNT');

			$DB1->update('address_details',$gpaddress);


			$guardian['gfirst_name']=strtoupper(stripslashes(($data['fname']))); 
			$guardian['gmiddle_name']=strtoupper(stripslashes(($data['mname']))); 
			$guardian['glast_name']=strtoupper(stripslashes(($data['lname']))); 
			$guardian['relation']=stripslashes(($data['relationship'])); 
			$guardian['occupation']=stripslashes(($data['occupation'])); 
			$guardian['income']=stripslashes(($data['annual_income'])); 
			$guardian['parent_email']=stripslashes(($data['parent_email'])); 
			$guardian['parent_mobile2']=stripslashes(($data['parent_mobile'])); 
			$guardian['parent_mobile1']=stripslashes(($data['parent_phone'])); 

			$DB1->where('student_id', $student_id);
			$DB1->update('parent_details',$guardian);

			//update student subject allocation deactivate
			$sem=($data['hcsem']);
			$isactic['is_active']='N';
			$isactic['modify_by']=$_SESSION['uid'];
			$isactic['modify_on']=date('Y-m-d H:i:s');
			$DB1->where('stud_id',$student_id);
			$DB1->where('semester',$sem);
			$DB1->where('stream_id',$data['hstream']);
			$DB1->update('student_applied_subject',$isactic);
			//end of student subject allocation deactivate

			//update student batch  allocation deactivate
			$sem=($data['hcsem']);
			$isacticbatch['active']='N';
			$isacticbatch['modify_by']=$_SESSION['uid'];
			$isacticbatch['modify_on']=date('Y-m-d H:i:s');
			$DB1->where('student_id',$student_id);
			$DB1->where('semester',$sem);
			$DB1->where('stream_id',$data['hstream']);
			$DB1->update('student_batch_allocation',$isacticbatch);
			//end of student subject allocation deactivate
	    }
	    else
	    {
	    	//$student_id ='61';
			//	exit(0);
		
			//	$temp['admission_school']=$this->Ums_admission_model->getschool_bycourse($data['admission-course']); 	
			//course
			//	$temp['form_number']=stripslashes(($data['sfnumber']));
			//	$temp['admission_stream']=stripslashes(($data['admission-branch'])); 	
			//student name
			$temp['first_name']=strtoupper(stripslashes(($data['sfname']))); 		
			$temp['middle_name']=strtoupper(stripslashes(($data['smname']))); 		
			$temp['last_name']=strtoupper(stripslashes(($data['slname']))); 
	        
			$temp['gender']=stripslashes(($data['gender'])); 
			$temp['blood_group']=stripslashes(($data['blood_gr'])); 
			$temp['dob']=stripslashes(($data['dob'])); 
				$temp['birth_place']=stripslashes(($data['pob'])); 
			$temp['mobile']=stripslashes(($data['mobile'])); 
			$temp['email']=stripslashes(($data['email_id'])); 
			$temp['nationality']=stripslashes(($data['nationality'])); 
			$temp['category']=stripslashes(($data['category']));  
			//$temp['sub_caste']=stripslashes(($data['sub_caste']));  
			$temp['religion']=stripslashes(($data['religion'])); 
			$temp['adhar_card_no']=stripslashes(($data['saadhar'])); 
			$temp['domicile_status']=stripslashes(($data['res_state'])); 
		
			$temp['father_fname']=strtoupper(stripslashes(($data['sfname1']))); 		
			$temp['father_mname']=strtoupper(stripslashes(($data['smname1']))); 		
			$temp['father_lname']=strtoupper(stripslashes(($data['slname1']))); 
	         // student mother name		
			$temp['mother_name']=strtoupper(stripslashes(($data['sfname2']))); 
			//	$temp['student_photo_path']=$picture;
			//	$temp['about_uni_know']=implode(",",$data['publicitysandip']);//$temp=implode("/ ",$mstatus); 
			
			
			
			
			   	$temp['academic_year']= stripslashes(($data['hacyear'])) + 1;
	       
	       	$temp['current_year']=stripslashes(($data['hcyear'])) + 1;
	     
	        	$temp['current_semester']=stripslashes(($data['hcsem'])) + 1;
	     
	       
	  //    $temp['entry_from_ip']= $_SERVER['REMOTE_ADDR'];
	      $temp['modified_on']= date('Y-m-d H:i:s');
	      $temp['modified_by']= $_SESSION['uid'];

			//Guardians details  parent_details
			
			$DB1->where('stud_id', $student_id);
		$DB1->update('student_master',$temp);
			
		   // $DB1->insert('student_master',$temp);
		     	//echo $DB1->last_query();
		//	$insert_id1 = $DB1->insert_id();
		
		
		$admdetails['student_id'] = $student_id;
		  $admdetails['hostel_required']=$data['hostel'];
		    	       	   $admdetails['hostel_type']=$data['hosteltype'];
		    	       	    $admdetails['transport_required']=$data['transport'];
		    	       	     $admdetails['transport_boarding_point']=$data['bording_point'];
		    	       	     
		    	       	     
		    	       	     
			   $neacyearj =	$admdetails['academic_year']=stripslashes(($data['hacyear'])) + 1;
	       
	       	$admdetails['year']=stripslashes(($data['hcyear'])) + 1;
	      	$admdetails['actual_fee']=stripslashes(($data['acd_totalfee'])) ;
	      	 	$admdetails['applicable_fee']=stripslashes(($data['acd_totalfee'])) ;
	      	 		$admdetails['opening_balance']=stripslashes(($data['open_bal'])) ;
	      	 	
	        //	$temp['current_semester']=strtoupper(stripslashes(($data['hcsem']))) + 2;
		    	       	    //  $admdetails['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		    	       	      //	  $admdetails['allowed_by']='Admin';
		    	            $admdetails['created_on']= date('Y-m-d H:i:s');
	      $admdetails['created_by']= $_SESSION['uid'];
	      $admdetails['form_number']= stripslashes(($data['sfnumber']));
	      $admdetails['enrollment_no']= stripslashes(($data['henroll']));
	      $admdetails['school_code']= stripslashes(($data['hschool']));
	      $admdetails['stream_id']= stripslashes(($data['hstream']));
	      $admdetails['entry_from_ip']= $_SERVER['REMOTE_ADDR'];
	      
	   $dup = $this->fetch_admission_details($student_id,$neacyearj);
	 //  $dup = $this->fetch_admission_details(2,$neacyearj);
	  // echo $dup[0]['student_id'];
	   //  var_dump($dup);
	   // exit();
	      if($dup[0]['student_id']=='')
	      {
	      $DB1->insert('admission_details',$admdetails);
	      }
	    //  echo $DB1->last_query();
	    //  exit(0);
		//	$DB1->where('student_id', $student_id);
		//	$DB1->update('admission_details',$admdetails);
		
		
		 
			$address['address']=stripslashes(($data['laddress'])); 
		//	$address['street']=stripslashes(($data['bill_B'])); 
			$address['city']=stripslashes(($data['lcity'])); 
			$address['state_id']=stripslashes(($data['lstate_id'])); 
			$address['district_id']=stripslashes(($data['ldistrict_id'])); 
			$address['pincode']=stripslashes(($data['lpincode']));
			
				$DB1->where('student_id', $student_id);
			$DB1->where('adds_of','STUDENT');
				$DB1->where('address_type','CORS');
			
			$DB1->update('address_details',$address);
			
			

			
	         // permenant	address	
		    $paddress['adds_of']='STUDENT'; 
			$paddress['address_type']='PERMNT'; 
			$paddress['address']=stripslashes(($data['paddress'])); 
		//	$paddress['street']=stripslashes(($data['bshipping_B'])); 
			$paddress['city']=stripslashes(($data['pcity'])); 
			$paddress['state_id']=stripslashes(($data['pstate_id'])); 
			$paddress['district_id']=stripslashes(($data['pdistrict_id'])); 
			$paddress['pincode']=stripslashes(($data['ppincode']));
		//	$paddress['student_id']=$insert_id1;
		
			$DB1->where('student_id', $student_id);
			$DB1->where('adds_of','STUDENT');
				$DB1->where('address_type','PERMNT');
			
			$DB1->update('address_details',$paddress);
		
		
		
		
		
		
		 		$gpaddress['address']=stripslashes(($data['gparent_address'])); 
		//	$paddress['street']=stripslashes(($data['bshipping_B'])); 
			$gpaddress['city']=stripslashes(($data['gcity'])); 
			$gpaddress['state_id']=stripslashes(($data['gstate_id'])); 
			$gpaddress['district_id']=stripslashes(($data['gdistrict_id'])); 
			$gpaddress['pincode']=stripslashes(($data['gpincode']));
			//	$DB1->insert('address_details',$gpaddress);
				
				
				
				$DB1->where('student_id', $student_id);
			$DB1->where('adds_of','PARENT');
				$DB1->where('address_type','PERMNT');
			
			$DB1->update('address_details',$gpaddress);
		
		
			$guardian['gfirst_name']=strtoupper(stripslashes(($data['fname']))); 
			$guardian['gmiddle_name']=strtoupper(stripslashes(($data['mname']))); 
			$guardian['glast_name']=strtoupper(stripslashes(($data['lname']))); 
			$guardian['relation']=stripslashes(($data['relationship'])); 
			$guardian['occupation']=stripslashes(($data['occupation'])); 
			$guardian['income']=stripslashes(($data['annual_income'])); 
			$guardian['parent_email']=stripslashes(($data['parent_email'])); 
			$guardian['parent_mobile2']=stripslashes(($data['parent_mobile'])); 
			$guardian['parent_mobile1']=stripslashes(($data['parent_phone'])); 
		
			 	$DB1->where('student_id', $student_id);

			
			$DB1->update('parent_details',$guardian);

	    }

	

		
	}	
	
    function update_stepseconddata($id,$data, $arr2){
		$DB1 = $this->load->database('umsdb', TRUE);
		//echo "<pre>";
		//print_r($data);exit;
		if (count($data['exam_id']) > 0) {
			
            for ($i = 0; $i < count($data['exam_id']); $i++) {

                $exam['student_id'] = $data['reg_id'];
                $exam['degree_type'] = $data['exam_id'][$i];
                $exam['degree_name'] = $data['stream_name'][$i];
                $exam['specialization'] = $data['seat_no'][$i];
                $exam['board_uni_name'] = $data['institute_name'][$i];
                $exam['passing_year'] = $data['pass_month'][$i] . "-" . $data['pass_year'][$i];
                $exam['total_marks'] = $data['marks_obtained'][$i];
                $exam['out_of_marks'] = $data['marks_outof'][$i];
                $exam['percentage'] = $data['percentage'][$i];
				$qual_id = $data['qual_id'][$i];

                $picture = '';
                $key = $i;
                
                if(!empty($arr2[$i])){
					$exam['file_path'] = str_replace(" ","_",$arr2[$i]);
				}
				
				if($exam['degree_type'] !=''){
					if($qual_id !=''){
						$DB1->where('qual_id', $qual_id);   			
						$DB1->update('student_qualification_details', $exam);
						//echo $DB1->last_query();
						
					}else{
						$DB1->insert('student_qualification_details', $exam);					
					}
				}
                if ($data['exam_id'][$i] == 'SSC') {

                    $exam2['student_id'] = $data['reg_id'];
                    $exam2['qual_id'] = $data['sub_qual_id'];
                    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
                    $exam2['marks_obt'] = $data['tssc_eng'];
                    $exam2['marks_outof'] = $data['ossc_eng'];
                    $exam2['passing_year'] = $data['sscpass_date'];
					$sub_id = $data['sub_id'];	
					if($sub_id !=''){
						$DB1->where('id', $sub_id);       
						$DB1->update('student_qualifying_exam_details', $exam2);

					}else{	
						$DB1->insert('student_qualifying_exam_details', $exam2);
					}
					
                }
				if (($data['exam_id'][$i] == 'HSC')) {

                    if (($data['exam_id'][$i] == 'HSC') && ($data['stream_name'][$i] == 'Science')) {
					//echo "hi";
						if($data['hsc_eng']=='English'){
							$exam3['student_id'] = $data['reg_id'];
							$exam3['qual_id'] = $data['hesub_qual_id'];
							//    $exam['sub_sem_name']=$data['stream_name'][$i]; 
							$exam3['sub_sem_name'] = 'English';
							$exam3['marks_obt'] = $data['thsc_eng'];
							$exam3['marks_outof'] = $data['ohsc_eng'];
							$exam3['passing_year'] = $data['hscpass_date'];
							$hesub_id = $data['hesub_id'];	
							if($hesub_id !=''){
								$DB1->where('id', $hesub_id);       
								$DB1->update('student_qualifying_exam_details', $exam3);
							}else{
								$DB1->insert('student_qualifying_exam_details', $exam3);
							}
						}
						if($data['hsc_phy']=='Physics'){
							$exam3['student_id'] = $data['reg_id'];
							$exam3['qual_id'] = $data['hpsub_qual_id']; 
							$exam3['sub_sem_name'] = 'Physics';
							$exam3['marks_obt'] = $data['thsc_phy'];
							$exam3['marks_outof'] = $data['ohsc_phy'];
							$physub_id = $data['hpsub_id'];	
							if($physub_id !=''){
								$DB1->where('id', $physub_id);       
								$DB1->update('student_qualifying_exam_details', $exam3);
							}else{
								$DB1->insert('student_qualifying_exam_details', $exam3);
							}
						}
						if($data['hsc_chem']=='Chemistry'){
							$exam3['student_id'] = $data['reg_id'];
							$exam3['qual_id'] = $data['hcsub_qual_id'];
							//    $exam['sub_sem_name']=$data['stream_name'][$i]; 
							$exam3['sub_sem_name'] = 'Chemistry';
							$exam3['marks_obt'] = $data['thsc_chem'];
							$exam3['marks_outof'] = $data['ohsc_chem'];
							//	$exam3['passing_year']=$data['hscpass_date'][$i];
							$hcsub_id = $data['hcsub_id'];
							if($hcsub_id !=''){
								$DB1->where('id', $hcsub_id);       
								$DB1->update('student_qualifying_exam_details', $exam3);
							}else{
								$DB1->insert('student_qualifying_exam_details', $exam3);
							}
						}
						if($data['hsc_maths']=='Maths'){
							$exam3['student_id'] = $data['reg_id'];
							$exam3['qual_id'] = $data['hmsub_qual_id'];
							$exam3['sub_sem_name'] = 'Maths';
							//    $exam['sub_sem_name']=$data['stream_name'][$i]; 
							$exam3['marks_obt'] = $data['thsc_maths'];
							$exam3['marks_outof'] = $data['ohsc_maths'];
							//	$exam3['passing_year']=$data['hscpass_date'][$i];
							$hmsub_id = $data['hmsub_id'];
							if($hmsub_id !=''){
								$DB1->where('id', $hmsub_id);       
								$DB1->update('student_qualifying_exam_details', $exam3);
							}else{
								$DB1->insert('student_qualifying_exam_details', $exam3);
							}
						}

						if($data['hsc_bio']=='Biology'){
							//echo "inside";exit;
							$exam3['student_id'] = $data['reg_id'];
							$exam3['qual_id'] = $data['hbsub_qual_id'];
							//    $exam['sub_sem_name']=$data['stream_name'][$i]; 
							$exam3['sub_sem_name'] = 'Biology';
							$exam3['marks_obt'] = $data['thsc_bio'];
							$exam3['marks_outof'] = $data['ohsc_bio'];
							//	$exam3['passing_year']=$data['hscpass_date'][$i];
							$hbsub_id = $data['hbsub_id'];
							if($hbsub_id !=''){
								$DB1->where('id', $hbsub_id);       
								$DB1->update('student_qualifying_exam_details', $exam3);
								//echo $DB1->last_query();
							}else{
								$DB1->insert('student_qualifying_exam_details', $exam3);
							}
						}
                    } else {
                        $exam4['student_id'] = $data['reg_id'];
                        $exam4['qual_id'] = $data['hsub_qual_id'];
                        //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
                        $exam4['sub_sem_name'] = 'English';
                        $exam4['marks_obt'] = $data['thsc_eng'];
                        $exam4['marks_outof'] = $data['ohsc_eng'];
                        $exam4['passing_year'] = $data['hscpass_date'];
						$hsub_id = $data['hsub_id'];	
                       if($hsub_id !=''){
							$DB1->where('id', $sub_id);       
							$DB1->update('student_qualifying_exam_details', $exam4);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam4);
						}
                    }
                }
				// diploma start
				if ($data['exam_id'][$i] == 'Diploma') {
					if($data['sem1']=='Sem 1'){
						$exam5['student_id'] = $data['reg_id'];
						$exam5['qual_id'] = $data['sem1sub_qual_id'];
						$exam5['sub_sem_name'] = 'Sem 1';
						$exam5['marks_obt'] = $data['tdsem1_eng'];
						$exam5['marks_outof'] = $data['odsem1_eng'];
						$exam5['passing_year'] = $data['dsem1pass_date'];
						$sem1_id = $data['sem1_id'];
						
						if($sem1_id !=''){
							$DB1->where('id', $sem1_id);       
							$DB1->update('student_qualifying_exam_details', $exam5);
							
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam5);
							
						}
					}
					if($data['sem2']=='Sem 2'){
						$exam5['student_id'] = $data['reg_id'];
						$exam5['qual_id'] = $data['sem2sub_qual_id'];
						$exam5['sub_sem_name'] = 'Sem 2';
						//    $exam['sub_sem_name']=$data['stream_name'][$i]; 
						$exam5['marks_obt'] = $data['tdsem2_eng'];
						$exam5['marks_outof'] = $data['odsem2_eng'];
						$exam5['passing_year'] = $data['dsem2pass_date'];
						$sem2_id = $data['sem2_id'];
						
						if($sem2_id !=''){
							$DB1->where('id', $sem2_id);       
							$DB1->update('student_qualifying_exam_details', $exam5);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam5);
						}
					}
					if($data['sem3']=='Sem 3'){
						$exam5['student_id'] = $data['reg_id'];
						$exam5['qual_id'] = $data['sem3sub_qual_id'];
						$exam5['sub_sem_name'] = 'Sem 3';
						//    $exam['sub_sem_name']=$data['stream_name'][$i]; 
						$exam5['marks_obt'] = $data['tdsem3_eng'];
						$exam5['marks_outof'] = $data['odsem3_eng'];
						$exam5['passing_year'] = $data['dsem3pass_date'];

						$sem3_id = $data['sem3_id'];
						
						if($sem3_id !=''){
							$DB1->where('id', $sem3_id);       
							$DB1->update('student_qualifying_exam_details', $exam5);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam5);
						}
					}
					if($data['sem4']=='Sem 4'){
						$exam5['student_id'] = $data['reg_id'];
						$exam5['qual_id'] = $data['sem4sub_qual_id'];
						//    $exam['sub_sem_name']=$data['stream_name'][$i]; 
						$exam5['sub_sem_name'] = 'Sem 4';
						$exam5['marks_obt'] = $data['tdsem4_eng'];
						$exam5['marks_outof'] = $data['odsem4_eng'];
						$exam5['passing_year'] = $data['dsem4pass_date'];
						$sem4_id = $data['sem4_id'];
						
						if($sem4_id !=''){
							$DB1->where('id', $sem4_id);       
							$DB1->update('student_qualifying_exam_details', $exam5);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam5);
						}
					}
					if($data['sem5']=='Sem 5'){
						$exam5['student_id'] = $data['reg_id'];
						$exam5['qual_id'] = $data['sem5sub_qual_id'];
						//    $exam['sub_sem_name']=$data['stream_name'][$i]; 
						$exam5['sub_sem_name'] = 'Sem 5';
						$exam5['marks_obt'] = $data['tdsem5_eng'];
						$exam5['marks_outof'] = $data['odsem5_eng'];
						$exam5['passing_year'] = $data['dsem5pass_date'];

						$sem5_id = $data['sem5_id'];
						
						if($sem5_id !=''){
							$DB1->where('id', $sem5_id);       
							$DB1->update('student_qualifying_exam_details', $exam5);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam5);
						}
					}
					if($data['sem6']=='Sem 6'){
						$exam5['student_id'] = $data['reg_id'];
						$exam5['qual_id'] = $data['sem6sub_qual_id'];
						//    $exam['sub_sem_name']=$data['stream_name'][$i]; 
						$exam5['sub_sem_name'] = 'Sem 6';
						$exam5['marks_obt'] = $data['tdsem6_eng'];
						$exam5['marks_outof'] = $data['odsem6_eng'];
						$exam5['passing_year'] = $data['dsem6pass_date'];

						$sem6_id = $data['sem6_id'];
						
						if($sem6_id !=''){
							$DB1->where('id', $sem6_id);       
							$DB1->update('student_qualifying_exam_details', $exam5);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam5);
						}
					}
                }
				
                
            }
        }

		if ($data['exam-name'] != '') {
			for ($i = 0; $i < count($data['exam-name']); $i++) {

				$suexam['student_id'] = $data['reg_id'];
				$suexam['entrance_exam_type'] = $data['exam-type'][$i];
				$suexam['entrance_exam_name'] = $data['exam-name'][$i];
				$suexam['passing_year'] = $data['ent_pass_month'][$i] . "-" . $data['ent_pass_year'][$i];
				$suexam['register_no'] = $data['enrolment'][$i];
				$suexam['marks_obt'] = $data['ent_marks'][$i];
				$suexam['marks_outof'] = $data['ent_totalmarks'][$i];
				$suexam['percentage'] = $data['ent_percentage'][$i];
				$ent_exam_id =  $data['ent_exam_id'][$i];
				//print_r()
				if ($suexam['entrance_exam_name'] != '') {
					if($ent_exam_id !=''){
						$DB1->where('ent_exam_id', $ent_exam_id);       
						$DB1->update('student_entrance_exam', $suexam);
						//echo $DB1->last_query();
					}else{
						echo "hi";
						$DB1->insert('student_entrance_exam', $suexam);
						//echo $DB1->last_query();exit;
					}
				}
			}
			
		}
		return true;
	}
	
	
	
	
	function student_confirm_doc($stud_id,$status){
		 $DB1 = $this->load->database('umsdb', TRUE);
		 $role_id = $this->session->userdata('role_id');
		 $emp_id = $this->session->userdata("name");
		
		 $DB1->select("stud_id,enrollment_no,academic_year,admission_session,admission_school,admission_stream,admission_year,current_year,current_semester");
		 $DB1->from('student_master');
		 $DB1->where("stud_id",$stud_id); 
	     $query2=$DB1->get();
		 
		 
		 $result2=$query2->row_array();	 
		// print_r($result2);

		if($result2['stud_id']!='')
		{
		
		
		
		
		
		
		//$DB1 = $this->load->database('umsdb', TRUE);
		$data_array=array();
		
		$data_array['student_id']=$stud_id;
		$data_array['enrollment_no_new']=$result2['enrollment_no'];
		$data_array['enrollment_no']=$result2['enrollment_no'];
		$data_array['academic_year']=$result2['academic_year'];
		$data_array['admission_session']=$result2['admission_session'];
		$data_array['admission_school']=$result2['admission_school'];
		$data_array['admission_stream']=$result2['admission_stream'];
		$data_array['admission_year']=$result2['admission_year'];
		
		$data_array['docuemnt_confirm']=$status;
		$data_array['docuemnt_date']=date("Y-m-d");
		
		$data_array['created_by']= $_SESSION['uid'];
		$data_array['created_on']=date("Y-m-d H:i:s");
		
		if($stud_id!=''){ 	
		$DB1->select("*");
		$DB1->from('student_confirm_status');
		//$DB1->where('school_code',$data['admission-school']);
		//$DB1->where('stream_id',$data['admission-branch']);
		//$DB1->where('academic_year',$data['acyear']);
		$DB1->where('student_id',$stud_id);
		$check_whether_entry_exists=$DB1->get()->row();
	
		 if(empty($check_whether_entry_exists))
		   {
             $DB1->insert('student_confirm_status',$data_array);
             return	$DB1->insert_id(); 		 
		   }
		   else{
			 $DB1->update('student_confirm_status',$data_array,array('confirm_id'=>$check_whether_entry_exists->confirm_id));
              return $check_whether_entry_exists->confirm_id; 			 
		   }
		
		/*$data_arrayy=array();
		$data_arrayy['admission_confirm']= 'Y';
			$DB1->update('student_master',$data_arrayy,array('stud_id'=>$stud_id));*/
		}
		else{
			return 0;
		}
		
		
		}
		
		
	}

	
	function update_stepthirddata($data){
	     $DB1 = $this->load->database('umsdb', TRUE);
	    	 $student_id = $this->session->userdata('studId');
			
			
			//print_r($data);
			//exit();
	    $error=array();
	      	if(!empty($_FILES['scandoc']['name'])){
		$_FILES['scandoc']['name']=$this->Ums_admission_model->rearrange1($_FILES['scandoc']['name']);
			// $filesCount = count($_FILES['scandoc']['name']);
			//print_r($_FILES['scandoc']['name']);
            //for($i = 0; $i < $filesCount; $i++){
				foreach($_FILES['scandoc']['name'] as $key => $val){
			     //$_FILES['scandoc']['name'][$key]; //echo '<br>';
			     //$_FILES['scandoc']['tmp_name'][$key];
               // $_FILES['userFile']['name'] = str_replace(" ","_",$student_id.'-'.$_FILES['scandoc']['name'][$key]);
				$lastDot = strrpos($_FILES['scandoc']['name'][$key], ".");
                $string = str_replace(".", "", substr($_FILES['scandoc']['name'][$key], 0, $lastDot)) . substr($_FILES['scandoc']['name'][$key], $lastDot);
				$string=str_replace(" ","_",$student_id.'-'.$string);
				$_FILES['userFile']['name']=$string;
			   // $_FILES['userFile']['name'] = str_replace(".","_",$student_id.'-'.$_FILES['scandoc']['name'][$key]);
				//$_FILES['userFile']['name'] = str_replace(".","_",$student_id.'-'.$_FILES['scandoc']['name'][$key]);
                $_FILES['userFile']['type'] = $_FILES['scandoc']['type'][$key];
                $_FILES['userFile']['tmp_name'] = $_FILES['scandoc']['tmp_name'][$key];
                $_FILES['userFile']['error'] = $_FILES['scandoc']['error'][$key];
                $_FILES['userFile']['size'] = $_FILES['scandoc']['size'][$key];
                $arr1[$key]=$_FILES['userFile']['name'];
                $uploadPath = 'uploads/student_document/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|jpe|jpeg|png|pdf|docx';//'gif|jpg|png|pdf|docx';
				$config['overwrite']= TRUE;
                $config['max_size']= "204800000"; 
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
				
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$key]['file_name'] = $fileData['file_name'];
                    $uploadData[$key]['created'] = date("Y-m-d H:i:s");
                    $uploadData[$key]['modified'] = date("Y-m-d H:i:s");
                }else{
					 $error = array('error' => $this->upload->display_errors());
				}
            }
               }
        
        	//print_r($fileData);
			//echo '<br>';
			//print_r($data['dapplicable']);
			//echo '<br>';
      //  echo count($data['dapplicable']);
  //  exit();
        $file='';
        foreach($data['dapplicable'] as $i=>$val)
     //   for($i=0;$i<=count($data['doc_id']);$i++)
        {
            
            $file = $data['doc_id'][$i];
            
      //     echo $i;
		$DB1->select("*");
		$DB1->from('student_document_details');
		$DB1->where("student_id",$student_id );
		$DB1->where("doc_id",$data['doc_id'][$i] );
	//	$DB1->where("sm.stud_id", "desc");
	//	$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
	 //echo $DB1->last_query();echo '<br>';
	//	die();  */ 
	    $result=$query->num_rows(); //echo '<br>';
		$result2=$query->row_array();	
		//print_r($result2['doc_path']);
	//	echo $result."***";
		
		    if($arr1[$file]!='')
               {
				   
				  // str_replace(" ","_",$arr1[$file])
                   $tdata['doc_path'] =$arr1[$file];
                   
                   
               }else{
                   $tdata['doc_path'] =$result2['doc_path'];
               }
		
		
		
		
		
            if($result>0)
            {
                
                 // $tdata['doc_id']=$data['doc_id'][$i];
			 $tdata['doc_applicable']=$data['dapplicable'][$i];
			 $tdata['ox']=$data['ox'][$i];
			 $tdata['created_on']=$data['docsubdate'][$i];
			 $tdata['remark']=$data['remark'][$i];
			 //$tdata['doc_path']=$temp['doc_path'][$key];
               
              
            
           	$DB1->where('doc_id',$data['doc_id'][$i]);    	
		    $DB1->where('student_id',$student_id);
			
		    $DB1->update('student_document_details',$tdata);
                //	 echo $DB1->last_query();
				//echo '1';echo '<br>';
               // print_r($tdata);echo '<br>';
            }
            else
            {
                if($data['dapplicable'][$i]=='' && $data['ox'][$i]=='' && $data['docsubdate'][$i]=='' && $data['remark'][$i]=='')
                {
                    
                }
                else
                {
             $tdata['student_id']=$student_id;
             $tdata['doc_id']=$data['doc_id'][$i];
			 $tdata['doc_applicable']=$data['dapplicable'][$i];
			 $tdata['ox']=$data['ox'][$i];
			 $tdata['created_on']=$data['docsubdate'][$i];
			 $tdata['remark']=$data['remark'][$i];
			 //$tdata['doc_path']=$temp['doc_path'][$key];
               
            // echo '2';echo '<br>';
               //  print_r($tdata);echo '<br>';
                	$DB1->insert('student_document_details',$tdata); 
                }
                
            }
          $file='';   
            unset($tdata['doc_path']);
            
        }
	    
	   // exit();
	    	 $DB1->where('student_id', $student_id);
            $DB1->delete('student_certificate_submit_details');
	    
	    		 
		// for certificate details
		$cert['certificate_name']=$data['cnm'];
		$cert['certificate_no']=$data['cno'];
		$cert['issue_date']=$data['issuedt'];
		$cert['validity_date']=$data['cval'];
			
		$len=sizeof($cert['certificate_name']);
		//echo $len;
		
		for($i=0;$i<$len;$i++){
		$a['student_id']=$student_id;
		$a['certificate_name']=	$cert['certificate_name'][$i];
		$a['certificate_no']=	$cert['certificate_no'][$i];
		$a['issue_date']=$cert['issue_date'][$i];
		$a['validity_date']=$cert['validity_date'][$i];
		$insert_id11 =$DB1->insert('student_certificate_submit_details',$a);
	//	echo $DB1->last_query();
		}
	    
	    
	    
	    if((!empty($student_id))&&($data['Mandatory']=='Y'))
	    {
	    $this->student_confirm_doc($student_id,'Y');
	    
		}else{
		$this->student_confirm_doc($student_id,'N');
		}
		
		//exit();
	    
	    
	    
	   // exit(0);
	    
	    
	    //	var_dump($_FILES);
	    
	    	
	    //	var_dump($arr1);
	    
	    //	exit(0);
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    /* added later
	      $DB1 = $this->load->database('umsdb', TRUE);
		//echo "in 3rd update";
		$student_id = $this->session->userdata('studId');;
		 $DB1->where('student_id', $student_id);
   $DB1->delete('student_certificate_submit_details');
   	 $DB1->where('student_id', $student_id);
   $DB1->delete('student_document_details');
   
			$temp['student_id']=$student_id;
		$temp['doc_id']= $this->rearrange1($data['dapplicable']);//without changing key value sequence
		$temp['doc_applicable']	= $this->rearrange1($data['dapplicable']);
		$temp['ox']	= $this->rearrange1($data['ox']);
		$temp['sub_dt']	= $this->rearrange1($data['docsubdate']);
		$temp['remark']	= $this->rearrange1($data['remark']);
		//$temp['doc_path']= $this->rearrange1($data['filescan']); 
		$temp['doc_path']= $arr1;//$this->rearrange1($data['filescan']); 
		$list=array();
		$list=array_keys( $temp['doc_id']);
		$temp['doc_id']=$list;
		$list=array_combine($temp['doc_id'],$temp['doc_id']);
		 $temp['doc_id']=$list;
		 
	      foreach($temp['doc_id'] as $key=>$val){
		     $temp2['doc_id'][$key]=$temp['doc_id'][$key];
			 $temp2['doc_applicable'][$key]=$temp['doc_applicable'][$key];
			 $temp2['ox'][$key]=$temp['ox'][$key];
			 $temp2['sub_dt'][$key]=$temp['sub_dt'][$key];
			 $temp2['remark'][$key]=$temp['remark'][$key];
			 $temp2['doc_path'][$key]=$temp['doc_path'][$key];
			 }
			 
			 
			 
		// for certificate details
		$cert['certificate_name']=$data['cnm'];
		$cert['certificate_no']=$data['cno'];
		$cert['issue_date']=$data['issuedt'];
		$cert['validity_date']=$data['cval'];
			
		$len=sizeof($cert['certificate_name']);
		//echo $len;
		
		for($i=0;$i<$len;$i++){
		$a['student_id']=$student_id;
		$a['certificate_name']=	$cert['certificate_name'][$i];
		$a['certificate_no']=	$cert['certificate_no'][$i];
		$a['issue_date']=$cert['issue_date'][$i];
		$a['validity_date']=$cert['validity_date'][$i];
		$insert_id11 =$DB1->insert('student_certificate_submit_details',$a);
	//	echo $DB1->last_query();
		}
		//end
	
			foreach($temp2['doc_id'] as $key=>$val){
			$temp1['student_id']=$student_id;
			$temp1['doc_id']=stripslashes(($temp2['doc_id'][$key]));
			$temp1['doc_applicable']=stripslashes(($temp2['doc_applicable'][$key]));
			$temp1['ox']=stripslashes(($temp2['ox'][$key]));
			$temp1['remark']=stripslashes(($temp2['remark'][$key]));
			$temp1['created_on']=stripslashes(($temp2['sub_dt'][$key]));
			$temp1['doc_path']=stripslashes(($temp2['doc_path'][$key]));
			
		$DB1->insert('student_document_details',$temp1);
		}  
		
	
		*/
		
		
        	
	}
	
	
	function update_stepfourthdata($id,$data){
		echo"in 4th update";
		
		 $stid=$data['reg_id'];		
		$temp['student_id']=stripslashes(($data['reg_id']));
		$temp['for_stud_refer_name1']=stripslashes(($data['fref1']));
		$temp['for_stud_refer_cont1']=stripslashes(($data['frefcont1']));
		$temp['for_stud_refer_name2']=stripslashes(($data['fref2']));
		$temp['for_stud_refer_cont2']=stripslashes(($data['frefcont2']));
		$temp['ex_emp_rel']=stripslashes(($data['reletedsandip']));
		$temp['ex_emp_rname']=stripslashes(($data['relatedname']));
		$temp['ex_emp_rdesig']=stripslashes(($data['relateddesig']));
		$temp['ex_emp_relat']=stripslashes(($data['relatedrelation']));
		$temp['alumini_rel']=stripslashes(($data['aluminisandip']));
		$temp['alumini_rel_name']=stripslashes(($data['alumininame']));
		$temp['alumini_rel_passyear']=stripslashes(($data['aluminiyear']));
		$temp['alumini_relat']=stripslashes(($data['aluminirelation']));
		$temp['rel_stud_san']=stripslashes(($data['relativesandip']));
		$temp['rel_stud_san_name']=stripslashes(($data['relativename']));
		$temp['rel_stud_san_course']=stripslashes(($data['relativecoursenm']));
		$temp['rel_stud_san_relat']=stripslashes(($data['relativerelation']));
		//publicity_media
		$temp1=array();
		$temp1=$data['publicitysandip'];
		$temp['publicity_media']=implode(",",$temp1);//$temp=implode("/ ",$mstatus); 
		$temp['ref_bystud_name']=stripslashes(($data['refcandidatenm']));
		$temp['ref_bystud_cont']=stripslashes(($data['refcandidatecont']));
		$temp['ref_bystud_email']=stripslashes(($data['refcandidateemail']));
		$temp['ref_bystud_relat']=stripslashes(($data['refcandidaterelt']));
		$temp['ref_bystud_area']=stripslashes(($data['refcandidateinterest']));
		
		$this->db->where('student_id',$temp['student_id']);
		 $res1=$this->db->update('student_reference',$temp);
		if($res1==true){
			return true;
		}
	}
	function update_stepfifthdata($id,$data,$prof_img){
		echo "am in 5th update";
		echo $prof_img."*";
		//die();
		 
		 $stid=$data['reg_id'];
		$temp['student_id']=stripslashes(($data['reg_id']));
		//applicable fee
		$temp['formfeeappli']=stripslashes(($data['formfeeappli']));
		$temp['formfeepaid']=stripslashes(($data['formfeepaid']));
		$temp['formfeebal']=stripslashes(($data['formfeebal']));
		//tution fee
		$temp['tutionfeeappli']=stripslashes(($data['tutionfeeappli']));
		$temp['tutionfeepaid']=stripslashes(($data['tutionfeepaid']));
		$temp['tutionfeebal']=stripslashes(($data['tutionfeebal']));
		//other fee
		$temp['otherfeeappli']=stripslashes(($data['otherfeeappli']));
		$temp['otherfeepaid']=stripslashes(($data['otherfeepaid']));
		$temp['otherfeebal']=stripslashes(($data['otherfeebal']));
		//total of every
		$temp['totalfeeappli']=stripslashes(($data['totalfeeappli']));
		$temp['totalfeepaid']=stripslashes(($data['totalfeepaid']));
		$temp['totalfeebal']=stripslashes(($data['totalfeebal']));
		//fee paid dd details
		//$temp['paidfee']=stripslashes(($data['paidfee']));
		$temp['dd_no']=stripslashes(($data['dd_no']));
		$temp['dd_drawn_date']=stripslashes(($data['dd_date']));
		$temp['dd_drawn_bank_branch']=stripslashes(($data['dd_bank']));
		//bank details
		$temp['bank_name']=stripslashes(($data['bank_name']));
		$temp['account_no']=stripslashes(($data['account_no']));
		$temp['ifsc']=stripslashes(($data['ifsc']));
		//profile image
		//$temp['profile_img']=$temp['student_id'].'-'.stripslashes(($data['profile_img']));
		if(!empty($prof_img)){$temp['profile_img']=$prof_img;}else{$temp['profile_img']=$data['profile_img'];}
		
	//	$this->db->where('student_id',$temp['student_id']);
	//	 $res1=$this->db->update('student_fee_details',$temp);
		if($res1==true){
			return true;
		}
	}
	
	// fetch states
	function fetch_states(){
	    $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT * from states order by state_name";
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	
	function fetch_district(){
	    $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT * from district_name order by district_name";
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	
	function fetch_taluka(){
	    $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT * from taluka_master order by taluka_name";
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	
	//////////////////////////////////////////////////////////////////////////////////////////
    
    //get discrict by state
	public function getStatewiseDistrict($stateid) {
	    $DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "select district_id, district_name from district_name where state_id='$stateid' order by district_name";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        //echo $DB1->last_query();
        return $res;
    }
    
    //get city by state and District
	public function getStateDwiseCity($stateid,$district_id) {
	    $DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "select taluka_id, taluka_name from taluka_master where state_id='$stateid' and district_id='$district_id' order by taluka_name";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        echo $DB1->last_query();
        return $res;
    }  
    
    // fetch qualification streams 
	public function fetch_qualification_streams() {
	    $DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "select * from qualification_master order by qualification";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        //echo $DB1->last_query();
        return $res;
    } 
    
    //get city by state and District
	public function fetch_sujee_details($reg_no) {
	    $DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "select * from su_jee_exam_result where reg_no='$reg_no'";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        //echo $DB1->last_query();
       // print_r($res);
        return $res;
    } 
    // fetch personal details
    function fetch_personal_details($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);//sm.stud_id,sm.academic_year,sm.general_reg_no,sm.admission_year,sm.form_number,sm.admission-stream,last_name,first_name,middle_name
		$DB1->select("sm.*,stm.stream_name, stm.course_name,stm.course_id,stm.stream_code,stm.course_short_name,sc.docuemnt_confirm,stm.stream_id");
		$DB1->from('student_master as sm');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('student_confirm_status as sc','sc.student_id = sm.stud_id','left');
		$DB1->where('stud_id', $stud_id);
		$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}

	// fetch personal details
    function fetch_personal_details_enrollment_no($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name, stm.course_name,stm.course_id,stm.stream_code,stm.course_short_name");
		$DB1->from('student_master as sm');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->where('enrollment_no', $stud_id);
		$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	
	    function fetch_admission_details($stud_id,$acyear=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");//hostel_required,hostel_type,transport_required,transport_boarding_point 
		$DB1->from('admission_details');
		//$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->where('student_id', $stud_id);
		if($acyear !='')
		{
		   	$DB1->where('academic_year', $acyear); 
		}
		$DB1->order_by("adm_id", "desc");
	$DB1->limit(1,0);

		$query=$DB1->get();
		$result=$query->result_array();
//	echo $DB1->last_query();
		return $result;
	}
	
	
	/*function total_fees_paid($stud_id,$acyear)
	{
	    
	}*/
	
	
	 function fetch_admission_details_all($stud_id,$acyear=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("ad.*,stm.stream_short_name");
		$DB1->from('admission_details as ad');
		$DB1->join('vw_stream_details as stm','ad.stream_id = stm.stream_id','left');
		$DB1->where('ad.student_id', $stud_id);
		if($acyear !='')
		{
		   	$DB1->where('ad.academic_year', $acyear); 
		}
		$DB1->order_by("adm_id", "desc");
//	$DB1->limit(1,0);

		$query=$DB1->get();
		$result=$query->result_array();
		//	var_dump($results);
	//exit();
	//	echo $DB1->last_query();
	for($i=0;$i<count($result);$i++)
	{
	    $totref=$this->get_tot_refunds($result[$i]['student_id'],$result[$i]['academic_year']);
	    $totfpaid =$this->fetch_total_fee_paid($result[$i]['student_id'],$result[$i]['academic_year']);
	    
	     $totcanc=$this->fetch_canc_charges($result[$i]['student_id'],$result[$i]['academic_year']);
	     
	       $result[$i]['tot_canc']=$totcanc['canc_amount'];
	    $result[$i]['tot_refunds']=$totref['rsum'];
	    $result[$i]['totfeepaid']=$totfpaid[0]['tot_fee_paid'];
	    
	}
//	var_dump($result);
//	exit();
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	    //get fetch_qualification_details
	public function fetch_qualification_details($stud_id) {
	    $DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "select * from student_qualification_details where student_id='$stud_id'";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        return $res;
    }
	
	public function fetch_qualification_new($stud_id,$emp_list){
		 $ums_id=$emp_list[0]['stream_id'];
		 $DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "select minimum_qk_required from sandipun_univerdb.school_programs_new where nashik_campus='Y' AND ums_id='$ums_id'";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        return $res;
	//echo $emp_list[0]['stream_id'];
	//exit();	
	}
    //get admission details
	public function admission_details($stud_id) {
	    $DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "select * from admission_details where student_id='$stud_id'";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        return $res;
    }	
    //get student entrance exam details
	public function student_entrance_exam($stud_id) {
	    $DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "select * from student_entrance_exam where student_id='$stud_id'";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        return $res;
    }		
    //get student references details
	public function student_references($stud_id, $ref_type) {
	    $DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "select * from student_references where student_id='$stud_id'";
		if(isset($ref_type) && $ref_type=='REF'){
			$sql .=" AND is_reference='Y'";
		}
		if(isset($ref_type) && $ref_type=='UNIEMP'){
			$sql .=" AND is_uni_employed='Y'";
		}
		if(isset($ref_type) && $ref_type=='UNIALU'){
			$sql .=" AND is_uni_alumni='Y'";
		}
		if(isset($ref_type) && $ref_type=='UNISTUD'){
			$sql .=" AND is_uni_student='Y'";
		}
		if(isset($ref_type) && $ref_type=='FROMREF'){
			$sql .=" AND is_from_reference='Y'";
		}
        $query = $DB1->query($sql);
        $res = $query->result_array();
        return $res;
    }

    // fetch student document details
    function fetch_document_details($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.document_name");
		$DB1->from('student_document_details as sm');
		$DB1->join('document_master as stm','sm.doc_id = stm.document_id','left');
		$DB1->where('student_id', $stud_id);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	
    // fetch student document details
    
    

    
    
    
    
   function fetch_academic_fees_for_stream_year($strm_id,$acyear,$year8=''){
      //   echo $acyear;
      $acy =  substr($acyear,-2);
  $ny = $acy+1;
      $year = $acyear."-".$ny;
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('academic_fees ');
		$DB1->where('stream_id', $strm_id);
		$DB1->where('academic_year', $year);
		if($year8 !=''){
		$DB1->where('year', $year8);
		}
		$query=$DB1->get();
		$result=$query->result_array();
	///echo $DB1->last_query();
		//exit(0);
//	var_dump($result);
		return $result;
	}
	
	   function fetch_academic_fees_stream_year_adm($strm_id,$acyear,$admyear,$year8){
      //   echo $acyear;
      $acy =  substr($acyear,-2);
  $ny = $acy+1;
      $year = $acyear."-".$ny;
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('academic_fees ');
		$DB1->where('stream_id', $strm_id);
		$DB1->where('academic_year', $year);
			$DB1->where('admission_year', $admyear);
		$DB1->where('year', $year8);
		$query=$DB1->get();
		$result=$query->result_array();
		/*echo $DB1->last_query();
		exit(0);*/
//	var_dump($result);
		return $result;
	}

	
	     function fetch_academic_fees_for_rereg($strm_id,$course_id,$batch,$acyear,$adm_session){
         //echo $course_id;
      $acy =  substr($acyear,-2);
  $ny = $acy+1;
      $year = $acyear."-".$ny;
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		if($course_id==15){
			$DB1->from('phd_academic_fees');
			$DB1->where('batch', $batch);
		}else{
			$DB1->from('academic_fees');
		}
		$DB1->where('stream_id', $strm_id);
		$DB1->where('academic_year', $year);
		$DB1->where('admission_year', $adm_session);
	//	$DB1->where('year', $year8);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		//exit(0);
	//var_dump($result);
		return $result;
	}
	 function fetch_academic_fees_for_reregistration($strm_id,$acyear,$adm_session){
      //   echo $acyear;
      $acy =  substr($acyear,-2);
  $ny = $acy+1;
      $year = $acyear."-".$ny;
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('academic_fees ');
		$DB1->where('stream_id', $strm_id);
		$DB1->where('academic_year', $year);
		$DB1->where('admission_year', $adm_session);
		$DB1->where('year', '0');
	//	$DB1->where('year', $year8);
		$query=$DB1->get();
		$result=$query->result_array();
	//	echo $DB1->last_query();
	//	exit(0);
//	var_dump($result);
		return $result;
	}
	
    
    function fetch_academic_fees_for_stream($strm_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('academic_fees ');
		$DB1->where('stream_id', $strm_id);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
    // fetch student Qualification details
    function fetch_stud_qualifications($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('student_qualification_details');
		$DB1->where('student_id', $stud_id);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}	
	    // fetch student exam details
    function fetch_stud_entranceexams($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('student_entrance_exam');
		$DB1->where('student_id', $stud_id);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}

    // fetch student Qualification subjects details
    function fetch_qua_subjects_details($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sub.*,q.degree_type, q.degree_name");
		$DB1->from('student_qualifying_exam_details  as sub');
		$DB1->join('student_qualification_details as q','q.qual_id = sub.qual_id','left');
		$DB1->where('sub.student_id', $stud_id);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
	
	///
	function update_stepseconddata111($id,$data){
		$DB1 = $this->load->database('umsdb', TRUE);
		if (count($data['exam_id']) > 0) {
            for ($i = 0; $i < count($data['exam_id']); $i++) {

                $exam['student_id'] = $data['reg_id'];
                $exam['degree_type'] = $data['exam_id'][$i];
                $exam['degree_name'] = $data['stream_name'][$i];
                $exam['specialization'] = $data['seat_no'][$i];
                $exam['board_uni_name'] = $data['institute_name'][$i];
                $exam['passing_year'] = $data['pass_month'][$i] . "-" . $data['pass_year'][$i];
                $exam['total_marks'] = $data['marks_obtained'][$i];
                $exam['out_of_marks'] = $data['marks_outof'][$i];
                $exam['percentage'] = $data['percentage'][$i];
				$qual_id = $data['qual_id'][$i];

                $picture = '';
                $key = $i;
                //	var_dump
                //	echo "j";
                //var_dump($arr2[0]);
                //	echo "k";

                $exam['file_path'] = $arr2[$i];

               
				if($qual_id !=''){
					$DB1->where('qual_id', $qual_id);   
echo "hello";					
					$DB1->update('student_qualification_details', $exam);
					echo $DB1->last_query();
					
				}else{
					echo "byy";
					$DB1->insert('student_qualification_details', $exam);echo $DB1->last_query();exit;
				}

                //	echo ">>".$DB1->last_query();

                

                if ($data['exam_id'][$i] == 'SSC') {

                    $exam2['student_id'] = $data['reg_id'];
                    $exam2['qual_id'] = $insert_ide;
                    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
                    $exam2['marks_obt'] = $data['tssc_eng'][$i];
                    $exam2['marks_outof'] = $data['ossc_eng'][$i];
                    $exam2['passing_year'] = $data['sscpass_date'][$i];
					$exam_name_id = $data['exam_name_id'][$i];
					 
					if($exam_name_id !=''){
						$DB1->where('qual_id', $exam_name_id);       
						$DB1->update('student_qualifying_exam_details', $exam2);
					}else{
						$DB1->insert('student_qualifying_exam_details', $exam2);
					}
                }
                if (($data['exam_id'][$i] == 'HSC')) {

                    if (($data['exam_id'][$i] == 'HSC') && ($data['stream_name'][$i] == 'Science')) {

                        $exam3['student_id'] = $data['reg_id'];
                        $exam3['qual_id'] = $insert_ide;
                        //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
                        $exam3['sub_sem_name'] = 'English';
                        $exam3['marks_obt'] = $data['thsc_eng'][$i];
                        $exam3['marks_outof'] = $data['ohsc_eng'][$i];
                        $exam3['passing_year'] = $data['hscpass_date'][$i];
						$exam_name_id = $data['exam_name_id'][$i];
						if($exam_name_id !=''){
							$DB1->where('qual_id', $exam_name_id);       
							$DB1->update('student_qualifying_exam_details', $exam3);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam3);
						}

                        $exam3['student_id'] = $data['reg_id'];
                        $exam3['qual_id'] = $insert_ide;
                        //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
                        $exam3['sub_sem_name'] = 'Physics';
                        $exam3['marks_obt'] = $data['thsc_phy'][$i];
                        $exam3['marks_outof'] = $data['ohsc_phy'][$i];
                        //	$exam3['passing_year']=$data['hscpass_date'][$i];

                        if($exam_name_id !=''){
							$DB1->where('qual_id', $exam_name_id);       
							$DB1->update('student_qualifying_exam_details', $exam3);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam3);
						}

                        $exam3['student_id'] = $data['reg_id'];
                        $exam3['qual_id'] = $insert_ide;
                        //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
                        $exam3['sub_sem_name'] = 'Chemistry';
                        $exam3['marks_obt'] = $data['thsc_chem'][$i];
                        $exam3['marks_outof'] = $data['ohsc_chem'][$i];
                        //	$exam3['passing_year']=$data['hscpass_date'][$i];

                       if($exam_name_id !=''){
							$DB1->where('qual_id', $exam_name_id);       
							$DB1->update('student_qualifying_exam_details', $exam3);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam3);
						}


                        $exam3['student_id'] = $data['reg_id'];
                        $exam3['qual_id'] = $insert_ide;
                        $exam3['sub_sem_name'] = 'Maths';
                        //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
                        $exam3['marks_obt'] = $data['thsc_math'][$i];
                        $exam3['marks_outof'] = $data['ohsc_math'][$i];
                        //	$exam3['passing_year']=$data['hscpass_date'][$i];

                        if($exam_name_id !=''){
							$DB1->where('qual_id', $exam_name_id);       
							$DB1->update('student_qualifying_exam_details', $exam3);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam3);
						}



                        $exam3['student_id'] = $data['reg_id'];
                        $exam3['qual_id'] = $insert_ide;
                        //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
                        $exam3['sub_sem_name'] = 'Biology';
                        $exam3['marks_obt'] = $data['thsc_bio'][$i];
                        $exam3['marks_outof'] = $data['ohsc_bio'][$i];
                        //	$exam3['passing_year']=$data['hscpass_date'][$i];

                        if($exam_name_id !=''){
							$DB1->where('qual_id', $exam_name_id);       
							$DB1->update('student_qualifying_exam_details', $exam3);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam3);
						}
                    } else {

                        $exam4['student_id'] = $data['reg_id'];
                        $exam4['qual_id'] = $insert_ide;
                        //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
                        $exam4['sub_sem_name'] = 'English';
                        $exam4['marks_obt'] = $data['thsc_eng'][$i];
                        $exam4['marks_outof'] = $data['ohsc_eng'][$i];
                        $exam4['passing_year'] = $data['hscpass_date'][$i];

                        if($exam_name_id !=''){
							$DB1->where('qual_id', $exam_name_id);       
							$DB1->update('student_qualifying_exam_details', $exam4);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam4);
						}
                    }
                }
                if ($data['exam_id'][$i] == 'Diploma') {

                    $exam5['student_id'] = $data['reg_id'];
                    $exam5['qual_id'] = $insert_ide;
                    $exam5['sub_sem_name'] = 'Sem 1';
                    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
                    $exam5['marks_obt'] = $data['tdsem1_eng'][$i];
                    $exam5['marks_outof'] = $data['odsem1_eng'][$i];
                    $exam5['passing_year'] = $data['dsem1pass_date'][$i];

                   if($exam_name_id !=''){
							$DB1->where('qual_id', $exam_name_id);       
							$DB1->update('student_qualifying_exam_details', $exam5);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam5);
						}

                    $exam5['student_id'] = $data['reg_id'];
                    $exam5['qual_id'] = $insert_ide;
                    $exam5['sub_sem_name'] = 'Sem 2';
                    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
                    $exam5['marks_obt'] = $data['tdsem2_eng'][$i];
                    $exam5['marks_outof'] = $data['odsem2_eng'][$i];
                    $exam5['passing_year'] = $data['dsem2pass_date'][$i];

                    if($exam_name_id !=''){
							$DB1->where('qual_id', $exam_name_id);       
							$DB1->update('student_qualifying_exam_details', $exam5);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam5);
						}


                    $exam5['student_id'] = $data['reg_id'];
                    $exam5['qual_id'] = $insert_ide;
                    $exam5['sub_sem_name'] = 'Sem 3';
                    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
                    $exam5['marks_obt'] = $data['tdsem3_eng'][$i];
                    $exam5['marks_outof'] = $data['odsem3_eng'][$i];
                    $exam5['passing_year'] = $data['dsem3pass_date'][$i];

                    if($exam_name_id !=''){
							$DB1->where('qual_id', $exam_name_id);       
							$DB1->update('student_qualifying_exam_details', $exam5);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam5);
						}

                    $exam5['student_id'] = $data['reg_id'];
                    $exam5['qual_id'] = $insert_ide;
                    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
                    $exam5['sub_sem_name'] = 'Sem 4';
                    $exam5['marks_obt'] = $data['tdsem4_eng'][$i];
                    $exam5['marks_outof'] = $data['odsem4_eng'][$i];
                    $exam5['passing_year'] = $data['dsem4pass_date'][$i];

                   if($exam_name_id !=''){
							$DB1->where('qual_id', $exam_name_id);       
							$DB1->update('student_qualifying_exam_details', $exam5);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam5);
						}

                    $exam5['student_id'] = $data['reg_id'];
                    $exam5['qual_id'] = $insert_ide;
                    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
                    $exam5['sub_sem_name'] = 'Sem 5';
                    $exam5['marks_obt'] = $data['tdsem5_eng'][$i];
                    $exam5['marks_outof'] = $data['odsem5_eng'][$i];
                    $exam5['passing_year'] = $data['dsem5pass_date'][$i];

                    if($exam_name_id !=''){
							$DB1->where('qual_id', $exam_name_id);       
							$DB1->update('student_qualifying_exam_details', $exam5);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam5);
						}

                    $exam5['student_id'] = $data['reg_id'];
                    $exam5['qual_id'] = $insert_ide;
                    //    $exam['sub_sem_name']=$data['stream_name'][$i]; 
                    $exam5['sub_sem_name'] = 'Sem 6';
                    $exam5['marks_obt'] = $data['tdsem6_eng'][$i];
                    $exam5['marks_outof'] = $data['odsem6_eng'][$i];
                    $exam5['passing_year'] = $data['dsem6pass_date'][$i];

                  if($exam_name_id !=''){
							$DB1->where('qual_id', $exam_name_id);       
							$DB1->update('student_qualifying_exam_details', $exam5);
						}else{
							$DB1->insert('student_qualifying_exam_details', $exam5);
						}
                }
            }
        }

        //	exit(0);
        if ($data['suexam-name'] != '') {

            $suexam['student_id'] = $data['reg_id'];
            $suexam['entrance_exam_name'] = $data['suexam-name'];
            $suexam['passing_year'] = $data['supass_month'] . "-" . $data['supass_year'];
            $suexam['register_no'] = $data['suenrolment'];
            $suexam['marks_obt'] = $data['sumarks'];
            $suexam['marks_outof'] = $data['sutotal'];
            $suexam['percentage'] = $data['super'];
            $DB1->insert('student_entrance_exam', $suexam);
        }
        for ($i = 0; $i < count($data['exam-name']); $i++) {

            $suexam['student_id'] = $data['reg_id'];
            $suexam['entrance_exam_name'] = $data['exam-name'];
            $suexam['passing_year'] = $data['pass_month'] . "-" . $data['pass_year'];
            $suexam['register_no'] = $data['enrolment'];
            $suexam['marks_obt'] = $data['marks'];
            $suexam['marks_outof'] = $data['total'];
            $suexam['percentage'] = $data['per'];
            $DB1->insert('student_entrance_exam', $suexam);
        }
	}
	
	// fetch student Qualification subjects details
    function chek_mob_exist($mobile_no){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('*'); 
		$DB1->from('student_master');
		$DB1->where('mobile', $mobile_no);
		$query = $DB1->get();
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
	
	// fetch all installment details
	function fetch_installment_details($studId){
		$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->distinct();
		$DB1->select("f.fees_paid_type,f.fees_id,f.academic_year,f.canc_charges,f.chq_cancelled, f.receipt_no, f.receipt_file, f.fees_date, b.bank_name, f.bank_city, f.amount as amt_paid, b.bank_name, f.college_receiptno");
		$DB1->from('fees_details as f');
		$DB1->join('fees_installment_details as fid','fid.student_id = f.student_id and fid.academic_year=f.academic_year','left');
		$DB1->join('bank_master b','f.bank_id = b.bank_id','left');
		//$DB1->where('fid.no_of_installment >', 1);
		$DB1->where('f.type_id','2');
		$DB1->where('f.student_id', $studId);
		$DB1->where('f.is_deleted', 'N');
		$DB1->order_by("f.academic_year,f.fees_id", "DESC");
		$query=$DB1->get();
		$result=$query->result_array();
	//	echo $DB1->last_query();exit;
		return $result;	
	}
	
		function fetch_canc_charges($studId,$year=''){
		    	$DB1 = $this->load->database('umsdb', TRUE);
		    		$DB1->select("sum(canc_charges) as canc_amount");
		$DB1->from('fees_details');
			$DB1->where('student_id', $studId);
		if($year!='')
		{
		    	$DB1->where('academic_year', $year);
		}
			$DB1->where('is_deleted', 'N');
				$query=$DB1->get();
		$result=$query->row_array();
	//	echo $DB1->last_query();exit;
		return $result;	
		}
	
	
	
	// fetch no fo installments
	function fetch_no_of_installment($studId){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT max(`no_of_installment`) as max_no_installment FROM `fees_installment_details` WHERE `student_id`=$studId";
		$query = $DB1->query($sql);
		$result=$query->result_array(); 
		//echo $DB1->last_query();exit;
		return $result;	
	}
	
	// fetch last min balance
	function fetch_last_balance($studId){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT min(`balance_fees`) as min_balance FROM `fees_installment_details` WHERE `student_id`=$studId and chq_cancelled='N' and is_deleted='N'";
		$query = $DB1->query($sql);
		$result=$query->result_array(); 
		if($result[0]['min_balance']=='')
		{
		    
		    	$sql="SELECT applicable_fee as min_balance FROM `admission_details` WHERE `student_id`=$studId";
		$query = $DB1->query($sql);
		$result=$query->result_array(); 
		//  $result[0]['min_balance']  
		}
		//echo $DB1->last_query();exit;
		return $result;	
	}
	
	// fetch total fee paid
	function fetch_total_fee_paid($studId,$acyear=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT sum(`amount`) as tot_fee_paid FROM `fees_details` WHERE `student_id`='$studId' and chq_cancelled='N' and is_deleted='N' and type_id='2'";
		if($acyear !='')
		{
		    $sql .=" and academic_year=$acyear ";
		}
		$query = $DB1->query($sql);
		$result=$query->result_array(); 
	
	//	echo $DB1->last_query();exit;
		return $result;	
	}
	
	// Insert payment installment
	function pay_Installment($data, $payfile){
		
		$DB1 = $this->load->database('umsdb', TRUE);
			//print_r($data);exit;
		
		//echo $payfile;exit;
		$feedet['student_id']=$data['stud_id'];
		$feedet['amount']=$data['paidfee'];
		$feedet['type_id']=2;
		$feedet['fees_paid_type']=$data['payment_type'];
		$feedet['academic_year']= $data['acyear'];
				
		$feedet['receipt_no']=$data['dd_no'];
		$feedet['fees_date']=$data['dd_date']; 
		$feedet['bank_id']=$data['dd_bank'];
		$feedet['bank_city']=$data['dd_bank_branch'];
			$feedet['remark']=$data['remark'];
	$feedet['academic_fee_fine']=$data['late_fees'];		
			
			
				$feedet['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['created_on']= date('Y-m-d h:i:s');
		$feedet['created_by']= $_SESSION['uid'];
		
			
			$feedet['college_receiptno']=$data['clreceipt'];
		if($payfile !=''){
			$feedet['receipt_file']=$payfile;
		}
		//print_r($feedet);exit;
		$DB1->insert('fees_details',$feedet);   
		$insert_feid1 = $DB1->insert_id();

		$fidetails['student_id']=$data['stud_id'];
		$fidetails['actual_fees']=$data['actfee'];
		$fidetails['fees_id']=$insert_feid1;
		$fidetails['academic_year']= '2019'; //date('Y');
		$fidetails['no_of_installment']=1+$data['no_of_installment'];
		$fidetails['balance_fees']=((int)$data['min_balance'] - (int)$data['paidfee']);
		$fidetails['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$fidetails['created_on']= date('Y-m-d h:i:s');
			$fidetails['next_payment_date']= $data['npdate'];
		$fidetails['created_by']= $_SESSION['uid'];
		$DB1->insert('fees_installment_details',$fidetails);
		//echo $DB1->last_query();exit;
		return true;
		
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
				
		$feedet['receipt_no']=$data['dd_no'];
		$feedet['refund_date']=$data['dd_date']; 
		$feedet['bank_id']=$data['dd_bank'];
		$feedet['bank_city']=$data['dd_bank_branch'];
			$feedet['remark']=$data['remark'];
			
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
		redirect('ums_admission/fees_refund/');
		return true;
		
	}
	
	
	function validate_receipt()
	{
	 	$DB1 = $this->load->database('umsdb', TRUE);   
	 	
	 		$DB1->select("college_receiptno");
		$DB1->from('fees_details');
		$DB1->where("college_receiptno", $_POST['clreceipt']);
		$query=$DB1->get();
		$result=$query->row_array();
		if($result['college_receiptno']!='')
		{
		    echo "F";
		}
		//return $result;
	}
	
	
	function update_parent_mobile()
	{
	    	$DB1 = $this->load->database('umsdb', TRUE);   
	 	
	 		$DB1->select("*");
		$DB1->from('pending_fees pf');
	
		$query=$DB1->get();
	
		$result=$query->result_array();
$i=1;

  $odj = new Message_api();

foreach($result as $result1)
{
    	$DB1->select("pd.parent_mobile2");
		$DB1->from('student_master sm');
		$DB1->join("parent_details pd",'sm.stud_id=pd.student_id','left');
		$DB1->where("sm.enrollment_no",$result1['prn']);
//	$DB1->where("gpd.rule",'R2');	
		$query2=$DB1->get();
	
		$result2=$query2->row_array();
$smobile=$result1['mobile'];
$sname=$result1['name'];
$act=$result1['semwise'];
$pend=$result1['pending'];

$pmobile=$result2['parent_mobile2'];

$smessage="Dear $sname,
We notice from our records that against Rs. $act due in the first semester for AY 2018-19, there is an outstanding of Rs. $pend. Please arrange to deposit the outstanding fees along with the applicable late fine without any further delay. In case you have already paid the full semester fees, please confirm with the Accounts Department at Sandip University, Nashik. 
Regards,
Sandip University";
$pmessage="Dear Sir / Madam,
We notice from our records that against Rs. $act due in the first semester for AY 2018-19 for your ward  $sname , there is an outstanding of Rs. $pend. Please arrange to deposit the outstanding fees along with the applicable late fine without any further delay.  In case you have already paid the full semester fees, please confirm with the Accounts Department at Sandip University, Nashik. 
Regards,
Sandip University";

 //$odj->send_sms($smobile,$smessage);
 // $odj->send_sms($pmobile,$pmessage);
echo $i."-".$smessage.">>".$pmessage."<br>";
$i++;
//exit();
}
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	}
	
	
	
	
	/*function update_fee_det($data, $payfile){
		
		$DB1 = $this->load->database('umsdb', TRUE);
			//print_r($data);exit;
		
		//echo $payfile;exit;
		$fee_id = $data['eid'];
			$bfees = $data['bfees'];
				$pfees = $data['pfees'];
				$tfee = $data['bfees'] + $data['pfees'];
			//	echo $tfee;
			//	echo $data['epaidfee'];
			//	echo ((int)$tfee - (int)$data['epaidfee']);
			//	exit(0);
	//	$feedet['student_id']=$data['stud_id'];
		$feedet['amount']=$data['epaidfee'];
		$feedet['type_id']=2;
		$feedet['fees_paid_type']=$data['epayment_type'];
		$feedet['academic_year']= $data['acyear'];
					$feedet['academic_fee_fine']=$data['ffine'];		
		$feedet['receipt_no']=$data['edd_no'];
		$feedet['fees_date']=$data['edd_date']; 
		$feedet['bank_id']=$data['edd_bank'];
		$feedet['bank_city']=$data['edd_bank_branch'];
		$feedet['modify_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['modified_on']= date('Y-m-d h:i:s');
		$feedet['modified_by']= $_SESSION['uid'];
	//	if($data['adjamt']>0)
	//	{
	$feedet['adjustment_type']="E";
	$feedet['adjustment_amount']=$data['adjamt'];
//		}
		
		if($data['ccanc']=="N")
		{
		 	$feedet['canc_charges']=0;   
		}
		else
		{
		    if($updet[0]['middle_name']=="M")
		    {
		       $gend="Mr"; 
		    }
		    else
		    {
		    $gend="Ms";       
		    }
		//cancsms
		 $updet = $this->fetch_personal_details(trim($data['sid']));
  $pmob = $this->fetch_parent_details($data['sid']);
  
		
			$feedet['canc_charges']=$data['cancamt'];
			$fo = "9545453087";
			$jchq = $data['edd_no'];
			$jdate = date('d-m-Y',strtotime($data['edd_date'])); 
			$jamount = $data['epaidfee']; 
			$studentname= trim($updet[0]['first_name']." ".$updet[0]['middle_name']." ".$updet[0]['last_name']);
			$parentname= trim($updet[0]['father_fname']." ".$updet[0]['father_mname']." ".$updet[0]['father_lname']);
			$studentmobile= $updet[0]['mobile'];
		//	$parentmobile= "";
			     $odj = new Message_api();
           $student ="Dear $gend $studentname,
Your Cheque/DD No $jchq dated $jdate for Rs. $jamount has been returned dishonored by your bank. Please arrange to make the payment immediately along with necessary charges for dishonor.";
 $odj->send_sms($studentmobile,$student);	  

if($pmob[0]['parent_mobile2']!='')
{
    
		
			$parentmobile= $pmob[0]['parent_mobile2'];
           $parent="Dear $parentname,
 Your Cheque/DD No $jchq dated $jdate for Rs $jamount  towards the fees of your ward $gend $studentname has been returned dishonored by your bank. Please arrange to make the payment immediately along with necessary charges for dishonor.";
 $odj->send_sms($parentmobile,$parent);	    

}        
    
       
    $odj->send_sms($fo,$student);    
			
		}
			$feedet['chq_cancelled']=$data['ccanc']; 
			$feedet['remark']=$data['eremark'];
			$feedet['college_receiptno']=$data['eclreceipt'];
		
		if($payfile !=''){
			$feedet['receipt_file']=$payfile;
		}
		//print_r($feedet);exit;
			$DB1->where('fees_id', $fee_id);
		$DB1->update('fees_details',$feedet);

		$fidetails['balance_fees']=((int)$tfee - (int)$data['epaidfee']);
$fidetails['chq_cancelled']=$data['ccanc']; 
		$fidetails['modify_from_ip']=$_SERVER['REMOTE_ADDR'];
		$fidetails['modified_on']= date('Y-m-d h:i:s');
		$fidetails['modified_by']= $_SESSION['uid'];
			$fidetails['next_payment_date']= $data['enpdate'];
				$DB1->where('fees_id', $fee_id);
		$DB1->update('fees_installment_details',$fidetails);
		
		
	//	$DB1->insert('fees_installment_details',$fidetails);
		//echo $DB1->last_query();exit;
		return true;
		
	}
	*/
	function update_fee_det($data, $payfile){
		
		$DB1 = $this->load->database('umsdb', TRUE);
			//print_r($data);exit;
		
		//echo $payfile;exit;
		$fee_id = $data['eid'];
			$bfees = $data['bfees'];
				$pfees = $data['pfees'];
				$tfee = $data['bfees'] + $data['pfees'];
			//	echo $tfee;
			//	echo $data['epaidfee'];
			//	echo ((int)$tfee - (int)$data['epaidfee']);
			//	exit(0);
	//	$feedet['student_id']=$data['stud_id'];
		$feedet['amount']=$data['epaidfee'];
		$feedet['type_id']=2;
		$feedet['fees_paid_type']=$data['epayment_type'];
		$feedet['academic_year']= $data['acyear'];
	    $feedet['academic_fee_fine']=$data['ffine'];		
		$feedet['receipt_no']=$data['edd_no'];
		$feedet['fees_date']=$data['edd_date']; 
		$feedet['bank_id']=$data['edd_bank'];
		$feedet['bank_city']=$data['edd_bank_branch'];
		$feedet['modify_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['modified_on']= date('Y-m-d h:i:s');
		$feedet['modified_by']= $_SESSION['uid'];
	//	if($data['adjamt']>0)
	//	{
	$feedet['adjustment_type']="E";
	$feedet['adjustment_amount']=$data['adjamt'];
//		}
		
		if($data['ccanc']=="N")
		{
		 	$feedet['canc_charges']=0;   
		}
		else
		{
		    if($updet[0]['middle_name']=="M")
		    {
		       $gend="Mr"; 
		    }
		    else
		    {
		    $gend="Ms";       
		    }
		//cancsms
		 $updet = $this->fetch_personal_details(trim($data['sid']));
  		$pmob = $this->fetch_parent_details($data['sid']);
  
		
			$feedet['canc_charges']=$data['cancamt'];
			$fo = "9545453087";
			$jchq = $data['edd_no'];
			$jdate = date('d-m-Y',strtotime($data['edd_date'])); 
			$jamount = $data['epaidfee']; 
			$studentname= trim($updet[0]['first_name']." ".$updet[0]['middle_name']." ".$updet[0]['last_name']);
			$parentname= trim($updet[0]['father_fname']." ".$updet[0]['father_mname']." ".$updet[0]['father_lname']);
			$studentmobile= $updet[0]['mobile'];
		//	$parentmobile= "";
			     $odj = new Message_api();
           $student ="Dear $gend $studentname,
Your Cheque/DD No $jchq dated $jdate for Rs. $jamount has been returned dishonored by your bank. Please arrange to make the payment immediately along with necessary charges for dishonor.";
 $odj->send_sms($studentmobile,$student);	  

if($pmob[0]['parent_mobile2']!='')
{
    
		
			$parentmobile= $pmob[0]['parent_mobile2'];
           $parent="Dear $parentname,
 Your Cheque/DD No $jchq dated $jdate for Rs $jamount  towards the fees of your ward $gend $studentname has been returned dishonored by your bank. Please arrange to make the payment immediately along with necessary charges for dishonor.";
 $odj->send_sms($parentmobile,$parent);	    

}        
    
       
    $odj->send_sms($fo,$student);    
			
		}
			$feedet['chq_cancelled']=$data['ccanc']; 
			$feedet['remark']=$data['eremark'];
			$feedet['college_receiptno']=$data['eclreceipt'];
		
		if($payfile !=''){
			$feedet['receipt_file']=$payfile;
		}
		//print_r($feedet);exit;
			$DB1->where('fees_id', $fee_id);
		    $DB1->update('fees_details',$feedet);

		/*$fidetails['balance_fees']=((int)$tfee - (int)$data['epaidfee']);
		$fidetails['chq_cancelled']=$data['ccanc']; 
		$fidetails['modify_from_ip']=$_SERVER['REMOTE_ADDR'];
		$fidetails['modified_on']= date('Y-m-d h:i:s');
		$fidetails['modified_by']= $_SESSION['uid'];
			$fidetails['next_payment_date']= $data['enpdate'];
				$DB1->where('fees_id', $fee_id);
		$DB1->update('fees_installment_details',$fidetails);*/

		//cancel challan code
		if($data['ccanc']=='Y')
		{


			$chall_fee['remark']=$data['eremark'];
			$chall_fee['is_deleted']='Y';
			//$chall_fee['balance_fees']=((int)$tfee - (int)$data['epaidfee']);
			$chall_fee['challan_status']='CL'; 
			$chall_fee['modify_from_ip']=$_SERVER['REMOTE_ADDR'];
			$chall_fee['modified_on']= date('Y-m-d h:i:s');
			$chall_fee['modified_by']= $_SESSION['uid'];
			$DB1->where('exam_session', $data['eclreceipt']);
			$DB1->where('student_id', $data['sid']);
			$DB1->update('fees_challan',$chall_fee);
			///////////////////////////////challan details amount update////////


			//$DB1 = $this->load->database('umsdb', TRUE);   
	 	$DB1->select("tution_fees,
						development_fees,
						caution_money,
						admission_form,
						exam_fees,
						university_fees");
		$DB1->from('fees_challan');
		$DB1->where('exam_session', $data['eclreceipt']);
		$DB1->where('student_id', $data['sid']);
		$query=$DB1->get();
		$result2=$query->row_array();
	
		
		
		$tution_fees=$result2['tution_fees'];

		$development_fees=$result2['development_fees'];
		$caution_money=$result2['caution_money'];
		$admission_form=$result2['admission_form'];
		$exam_fees=$result2['exam_fees'];
		$university_fees=$result2['university_fees'];

		/////// get top entry of the table
			$ignore=$data['eclreceipt'];
			$DB1->select("*");
			$DB1->from('fees_challan');
			$DB1->where('student_id', $data['sid']);
			$DB1->where_not_in('exam_session', $ignore);
			$query=$DB1->get();
		
			$rowcountt=$query->result_array();
			if(count($rowcountt)>1)
			{
				
				$DB1->select("*");
				$DB1->from('fees_challan');
				$DB1->where('student_id', $data['sid']);
				$DB1->where_not_in('exam_session', $ignore);
				$DB1->limit(1);
				$DB1->order_by('fees_id',"DESC");
				$query=$DB1->get();
				//echo $DB1->last_query();
				//die;
				$feechallan_detials=$query->row_array();


				if(!empty($feechallan_detials))
				{

					//get individual value
					$update_fees_challan['tution_pending']=$feechallan_detials['tution_pending']+$tution_fees;
					$update_fees_challan['development_pending']=$feechallan_detials['development_pending']+$development_fees;
					$update_fees_challan['caution_pending']=$feechallan_detials['caution_pending']+$caution_money;
					$update_fees_challan['admission_pending']=$feechallan_detials['admission_pending']+$admission_form;
					$update_fees_challan['exam_pending']=$feechallan_detials['exam_pending']+$exam_fees;
					$update_fees_challan['university_pending']=$feechallan_detials['university_pending']+$university_fees;
					$update_fees_challan['tution_status']='N';
					$update_fees_challan['development_status']='N';
					$update_fees_challan['caution_status']='N';
					$update_fees_challan['admission_status']='N';
					$update_fees_challan['exam_status']='N';
					$update_fees_challan['university_status']='N';

					$DB1->where('fees_id', $feechallan_detials['fees_id']);
					$DB1->update('fees_challan',$update_fees_challan);

				}

			}
		

		

		}
		
		
	//	$DB1->insert('fees_installment_details',$fidetails);
		//echo $DB1->last_query();exit;
		return true;
		
	}
	
	function check_mobile($mobile,$msg)
	{$odj = new Message_api();
	return $odj->send_new($mobile,$msg);  
	
	}
	
	function delete_fees()
	{
	    	$DB1 = $this->load->database('umsdb', TRUE);   
	    	
	    	$del['is_deleted']='Y';
	    	$del['chq_cancelled']='Y';
	    	$DB1->where('fees_id', $_POST['feeid']);
		    $DB1->update('fees_details',$del);
	    	
	    		$DB1->where('fees_id', $_POST['feeid']);
		$DB1->update('fees_installment_details',$del);
		return 'Y';
	    
	}

 	function updateAdmPayment($stud_id,$acad_year, $data)
	{
		//print_r($data);
		$DB1 = $this->load->database('umsdb', TRUE);
		$where=array("student_id"=>$stud_id,"academic_year"=>$acad_year);
		$DB1->where($where); 
		$DB1->update('admission_details', $data);
		//echo $this->db->last_query();exit;
		return true;
	}	
	
	

public function fetch_grade_result($gd)
{
    	 	$DB1 = $this->load->database('umsdb', TRUE);   
	 	
	 		$DB1->select("*");
		$DB1->from('grade_policy_details');
	$DB1->where("grade_letter",$gd);
		$DB1->where("rule",'R2');
		
		$query=$DB1->get();
	$result2=$query->row_array();
	return $result2['performance'];
    
}

	
	public function transfer_result()
	{
	 
	 	$DB1 = $this->load->database('umsdb', TRUE);   
	 	
	 		$DB1->select("erd.*,sm.subject_name");
		$DB1->from('exam_result_data erd');
		$DB1->join("subject_master sm",'erd.subject_id=sm.sub_id','left');
//	$DB1->join("grade_policy_details gpd",'erd.final_grade=gpd.grade_letter','left');
		$DB1->where("erd.exam_id",6);
//	$DB1->where("gpd.rule",'R2');	
		$query=$DB1->get();
	//	echo $DB1->last_query();
	//	exit();
		$result=$query->result_array();

$data =  array();
foreach($result as $result1)
{
  $data =  array();  
//echo  $result1['enrollment_no'];
    
    	
  $data1['enrollment_no']= $result1['enrollment_no'];
  $data1['student_id']= $result1['student_id'];
 $data1['exam_id']= $result1['exam_id'];
$data1['stream_id']= $result1['stream_id'];
$data1['semester']= $result1['semester'];
$data1['subject_id']= $result1['subject_id'];
$data1['course_code']= $result1['subject_code'];
$data1['course_name']= $result1['subject_name'];
$data1['grade1']= $result1['final_grade'];
$data1['grade']= $result1['final_grade'];
$data1['result']= $this->fetch_grade_result($result1['final_grade']);
$data1['active']= 'Y';
$data1['is_hostel']= 'N';
$data1['stud_id']= $result1['student_id'];
$data1['reval_appeared']='N';
	$DB2 = $this->load->database('univerdb', TRUE);
//var_dump($data1);
// $DB2->insert("exam_result_data",$data1);
//echo $DB2->last_query();
	/*$DB2 = $this->load->database('univerdb', TRUE);

	$query1="insert into exam_result_data(student_id)values('".$result1['enrollment_no']."')";

		$DB2->query($query1);
		echo $DB2->last_query();*/
		//	exit();
}
	 
	 
	    
	}
	// added by bala
    function load_courses_for_studentlist($acad_year=''){
         $DB1 = $this->load->database('umsdb', TRUE);
		 $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		 $sql="SELECT vw.course_id,vw. course_name,vw.course_short_name FROM student_master s left join vw_stream_details vw on s.admission_stream=vw.stream_id where s.academic_year='$acad_year' and vw.course_id IS NOT NULL ";
		 
		 if(isset($role_id) && $role_id==20){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $sql .=" AND vw.school_code = $schid";
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND vw.school_code = $sccode";
		}
			$sql .=" group by vw.course_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function load_years_for_studentlist($acad_year, $admission_stream){
         $DB1 = $this->load->database('umsdb', TRUE);
		 $sql="SELECT current_year as admission_year FROM student_master where academic_year='$acad_year' and admission_stream='$admission_stream' group by current_year";
        $query = $DB1->query($sql);
		//echo $DB1->last_query(); 
        return $query->result_array();
    }
	 function  load_streams_student_list()
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
        
		$sql="SELECT vw.stream_id,vw.stream_name,vw.stream_short_name FROM student_master s left join vw_stream_details vw on s.admission_stream=vw.stream_id where s.academic_year='".$_POST['academic_year']."' and vw.course_id='".$_POST['course']."'";
        
        if(isset($role_id) && $role_id==20){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $sql .=" AND vw.school_code = $schid";
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND vw.school_code = $sccode";
		}
		$sql .=" group by s.admission_stream";
        $query = $DB1->query($sql);
	//	echo $DB1->last_query();
		return $stream_details =  $query->result_array();       
    } 
	function detain_student($student_id,$detain){
		$DB1 = $this->load->database('umsdb', TRUE);
			if($detain=='yes'){
				$is_detained ="Y";
			}else{
				$is_detained ="N";
			}
		$where = "stud_id='$student_id'";
		$DB1->set('is_detained', $is_detained);
		$DB1->where($where);		
		$DB1->update('student_master'); 
		//echo $DB1->last_query();exit;
		return true;
	}
	function studentforchange_stream($data){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,s.school_code,stm.min_que, v.course_id");
		$DB1->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('school_master as s','s.school_id = sm.admission_school','left');
		$DB1->join('vw_stream_details as v','v.stream_id = sm.admission_stream','left');
		
		if($data['prn']!='')
		{
			$DB1->where("sm.stud_id",$data['prn']);	   				    
    	}
		//$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
		  //echo $DB1->last_query();
	//	exit(0);
		$result=$query->result_array();
		//echo $this->db->last_query();
		
		 /* die();   */  
	//	$result=$query->result_array();
		return $result;
	}
	 function school_streams($course_id, $min_que)
    {
        $DB1 = $this->load->database('umsdb', TRUE);         
		$sql="SELECT distinct vw.stream_id,vw.stream_name,vw.stream_short_name FROM vw_stream_details vw ";
		//where vw.course_id='".$course_id."' group by vw.stream_id"; //and  stm.min_que='".$min_que."'////left join stream_master as stm on stm.stream_id = vw.stream_id

        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $stream_details =  $query->result_array();       
    } 
	
	function insert_detain_student($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$stud_details=explode('~', $data['stud_details']);
		$detain['stud_id']=$data['stud_id'];
		if($data['detain']=='yes'){
			$detain['is_detained'] ="Y";
		}else{
			$detain['is_detained'] ="N";
		}
		$detain['stream_id']= $stud_details[0];
		$detain['semester']= $stud_details[1];
		$detain['academic_year']= $stud_details[2];
		$detain['exam_session']= $data['exam_session'];
		$detain['reason']= $data['dreason'];
		$detain['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$detain['created_on']= date('Y-m-d h:i:s');
		$detain['created_by']= $_SESSION['uid'];
		$DB1->insert('student_detaintion_details',$detain);
		//echo $DB1->last_query();exit;
		return true;
	}
	function fetch_stud_detain_reason($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
       
		$sql="SELECT d_id,reason,exam_session FROM student_detaintion_details where stud_id='".$stud_id."' order by d_id desc limit 0,1";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();
		return $res =  $query->result_array();  
	}
	function get_detaintion_list($academicyear,$exam_session,$school, $stream_id){
		//echo $exam_session;
		$exam_session = str_replace("_","/",$exam_session);
	    $DB1 = $this->load->database('umsdb', TRUE);
		$ac_yr = explode('-',$academicyear);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
	    $sql="SELECT s.`stud_id`,s.enrollment_no,s.`first_name`,s.`middle_name`,s.`last_name`,s.`mobile`,s.`admission_stream`,s.`admission_year`,s.`current_semester`,s.`current_year`,a.exam_session,a.semester,a.reason,a.created_on,vw.stream_name,vw.stream_short_name,vw.school_name, sm.school_dean FROM `student_master` as s 
LEFT JOIN (select stud_id,semester, reason,created_on,exam_session from student_detaintion_details where is_detained='Y' and academic_year='".$ac_yr[0]."' and exam_session='$exam_session' order by d_id desc) a on a.stud_id=s.stud_id 
LEFT JOIN vw_stream_details vw on vw.stream_id=s.admission_stream
LEFT JOIN school_master sm on vw.school_code=sm.school_code
WHERE s.`is_detained`='Y' and s.academic_year='".$ac_yr[0]."' and a.exam_session='$exam_session'";

if($school !=0){
	$sql .=" AND vw.school_code = $school";
}
if($stream_id !=''){
	$sql .=" AND s.admission_stream = $stream_id";
}
		 if(isset($role_id) && $role_id==20){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $sql .=" AND vw.school_code = $schid";
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND vw.school_code = $sccode";
		}

		$sql .=" order by vw.school_code asc";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}	
 	function update_stream_adm_details($var)
	{
		//print_r($data);
		$DB1 = $this->load->database('umsdb', TRUE);
		$acad_year = $var['academic_year']+1;
		$newac = substr($acad_year, -2);
		$nacdyr =$var['academic_year'].'-'.$newac; 
		$sql="SELECT a.total_fees FROM academic_fees a
		left join student_master s on s.admission_session= a.admission_year
		where a.academic_year='".$nacdyr."' and a.stream_id='".$var['admission_stream']."' and s.stud_id='".$var['stud_id']."'";//exit;
		if($var['admission_year'] < 2018){
			$sql .=" and year=0";
		}else{
			$sql .=" and year='".$var['current_year']."'";
		}
		//echo $sql;
        $query = $DB1->query($sql);
		$res =  $query->result_array();
		//echo "<br>";
		$total_fees = $res[0]['total_fees'];
		//echo "<br>";			
		$sql1="SELECT actual_fee, applicable_fee,adm_id FROM admission_details where academic_year='".$var['academic_year']."' and student_id='".$var['stud_id']."' and year='".$var['current_year']."'";

        $query1 = $DB1->query($sql1);
		$res1 =  $query1->result_array();
		
		$actual_fee = $res1[0]['actual_fee'];
		$applicable_fee = $res1[0]['applicable_fee'];
		$adm_id =$res1[0]['adm_id'];//exit;
		//log creation
		if($adm_id){
			$sql11 ="INSERT INTO `sandipun_ums`.`admission_details_log` (`adm_id`, `student_id`, `form_number`, `enrollment_no`, `school_code`, `stream_id`, `year`, `academic_year`, `actual_fee`, `applicable_fee`, `opening_balance`, `total_fees_paid`, `fees_consession_allowed`, `concession_type`, `hostel_required`, `hostel_type`, `transport_required`, `transport_boarding_point`, `entry_from_ip`, `modify_from_ip`, `created_by`, `created_on`, `modified_by`, `modified_on`, `remark`, `cancelled_admission`)
			SELECT `adm_id`, `student_id`, `form_number`, `enrollment_no`, `school_code`, `stream_id`, `year`, `academic_year`, `actual_fee`, `applicable_fee`, `opening_balance`, `total_fees_paid`, `fees_consession_allowed`, `concession_type`, `hostel_required`, `hostel_type`, `transport_required`, `transport_boarding_point`, `entry_from_ip`, `modify_from_ip`, `created_by`, `created_on`, `modified_by`, `modified_on`, `remark`, `cancelled_admission` FROM admission_details where adm_id='$adm_id'";
			$query11 = $DB1->query($sql11);
		}
		
		if($actual_fee==$applicable_fee){
			$data['actual_fee'] = $total_fees;
			$data['applicable_fee'] = $total_fees;
		}else{
			$diff = $actual_fee - $applicable_fee;
			$total_fees1 = $total_fees - $diff;
			$data['actual_fee'] = $total_fees;
			$data['applicable_fee'] = $total_fees1;
		}
		
		$data['stream_id'] = $var['admission_stream'];
		$where=array("student_id"=>$var['stud_id'],"academic_year"=>$var['academic_year']);
		$DB1->where($where); 
		$DB1->update('admission_details', $data);
		//echo $DB1->last_query();
		//exit;
		return true;
	}	
 	function update_stream_stud_master($var)
	{
		//print_r($data);
		$DB1 = $this->load->database('umsdb', TRUE);
		$where=array("stud_id"=>$var['stud_id'],"academic_year"=>$var['academic_year']);
		$DB1->where($where); 
		$data['previous_stream'] = $var['previous_stream'];
		$data['admission_stream'] = $var['admission_stream'];
		$DB1->update('student_master', $data);
		//echo $this->db->last_query();exit;
		return true;
	}	
 	function insert_to_changeStream($var)
	{
		//print_r($var);
		$DB1 = $this->load->database('umsdb', TRUE); 

		$data['stud_id']= $var['stud_id'];
		$data['academic_year']= $var['academic_year'];
		$data['admission_session']= $var['admission_session'];
		$data['current_year']= $var['current_year'];
		$data['current_semester']= $var['current_semester'];
		$data['previous_stream']= $var['previous_stream'];
		$data['change_to_stream']= $var['admission_stream'];
		$data['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$data['created_on']= date('Y-m-d h:i:s');
		$data['created_by']= $_SESSION['uid'];
		$DB1->insert('tmp_student_change_stream',$data);
		//echo $DB1->last_query();exit;
		return true;
	}
	function get_streamchange_list($academicyear){
	    $DB1 = $this->load->database('umsdb', TRUE);
		$ac_yr = explode('-',$academicyear);
	    $sql="SELECT s.`stud_id`,s.enrollment_no,s.`first_name`,s.`middle_name`,s.`last_name`,s.`mobile`,st.`academic_year`,st.previous_stream,st.change_to_stream, st.is_approved,  st.tmp_id, st.`admission_session`,s.`current_semester`,s.`current_year`,st.created_on,vw.stream_name as previous_stream_name,vw1.stream_name as change_to_stream_name,vw.stream_short_name FROM `tmp_student_change_stream` as st 
LEFT JOIN student_master as s on s.stud_id=st.stud_id
LEFT JOIN vw_stream_details vw on vw.stream_id=st.previous_stream
LEFT JOIN vw_stream_details vw1 on vw1.stream_id=st.change_to_stream
WHERE st.academic_year='".$ac_yr[0]."' AND tmp_id IN (SELECT MAX(tmp_id) FROM tmp_student_change_stream GROUP BY stud_id)";
		if(isset($role_id) && $role_id==10){
			$ex =explode("_",$emp_id);
			$sccode = $ex[1];
			$sql .=" AND vw.school_code = $sccode";
		}
		//$sql .=" group by st.stud_id order by st.tmp_id desc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result = $query->result_array();
		return $result;
	}
	// get details from temp table
	 function get_stream_temp_details($temp_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);         
		$sql="SELECT * FROM tmp_student_change_stream  where tmp_id='".$temp_id."'"; 
        $query = $DB1->query($sql);
		return $res =  $query->result_array();       
    }
	// update temp stream table
    function update_temp_stream_status($tmp_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$where=array("tmp_id"=>$tmp_id);
		$DB1->where($where); 
		$data['is_approved'] = 'Y';
		$DB1->update('tmp_student_change_stream', $data);
		return true;
	}	
	//
	function list_todaysadmissions(){
		$uId=$this->session->userdata('uid');	
		$DB1 = $this->load->database('umsdb', TRUE);
		$today = date('Y-m-d');
		$DB1->select("sm.*,stm.stream_name,cm.course_name, pd.parent_mobile2,fd.amount");
		$DB1->from('student_master as sm');
	//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		$DB1->join('parent_details as pd','pd.student_id = sm.stud_id','left');
		$DB1->join('fees_details as fd','fd.student_id = sm.stud_id','left');
		$DB1->where("sm.cancelled_admission", 'N');
		$DB1->where("sm.academic_year", '2019');
		$DB1->like('sm.created_on', $today);
		$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
		  //echo $DB1->last_query();
		//die();   
		$result=$query->result_array();

		return $result;
	}
	 function getAdmissionYear()
    {
        $DB1 = $this->load->database('umsdb', TRUE);         
		$sql="SELECT distinct admission_session FROM tmp_student_change_stream"; 
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $stream_details =  $query->result_array();       
    } 
	function update_prn_2018()
	{
		$DB1 = $this->load->database('umsdb', TRUE); 		  
		$DB1->select("*");
		$DB1->from('student_master');
		$DB1->where("cancelled_admission", 'N');
		$DB1->where("admission_session", '2018');
		//$DB1->where("univ_transfer", 'N');
		$DB1->order_by("stud_id", "asc");
		
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		//	die(); 
		$result=$query->result_array();
		  	//echo count($result);	  		  exit;
	   for($i=0;$i<count($result);$i++)
	   {
		  
		$quer ="update student_master set enrollment_no_new='".$result[$i]['prn_2018']."',enrollment_no='".$result[$i]['prn_2018']."'  where stud_id='".$result[$i]['stud_id']."'";
		$DB1->query($quer);
		//echo $quer;
		//exit();
		// $DB1->query($quer);
		  //  return  $finalprn;
		
	   }
	
	}
	public function send_stlogin_2018()
	{
	    $this->load->library('Message_api');
		$odj = new Message_api();	    

	    $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT `um`.*, `sm`.`mobile` FROM `user_master` as `um` LEFT JOIN `student_master` as `sm` ON `um`.`username` = `sm`.`enrollment_no` WHERE `um`.`roles_id` = '4' AND `um`.`status` = 'Y' and username like '18%'";
		$query = $DB1->query($sql);	   
		$result=$query->result_array();
		//echo count($result);exit;
	foreach( $result as $results)
	{
	    
	    $mobile= $results['mobile'];
		 //$mobile= '8850633088';
$username = $results['username'];
$password = $results['password'];
$sms_message ='Dear Student 
Your login details
Please logon to
sandipuniversity.edu.in/erp-login.php
Username: '.$username.'
Password: '.$password.'
Thank you,
Sandip University.';
$odj->send_sms($mobile,$sms_message); 
    //exit;  
	}
    
}

function get_mock_result($stdid)
    {
        
      $DB1 = $this->load->database('icdb', TRUE);
		$DB1->select('mr.*,smd.student_name,ir.ic_name');
		$DB1->from('mock_results mr');
		$DB1->join('su_jee_registration as sjr','mr.reg_no = sjr.reg_no','left');
		$DB1->join('student_meet_details as smd','sjr.reg_id = smd.id','left');
		$DB1->join('ic_registration as ir','smd.ic_code = ir.ic_code','left');
	//	$DB1->where('mr.exam_id','07');
		$DB1->order_by('mr.exam_id,mr.ranking');
	$query=$DB1->get();
  $result=$query->result_array();
        return $result;
       
     
     
     /*   
     $DB1 = $this->load->database('icdb', TRUE);
		$DB1->select('*');
		$DB1->from('mock_results mr');
	//	$DB1->join('su_jee_registration as sjr','mr.reg_no = sjr.reg_no','left');
	//	$DB1->join('student_meet_details as smd','sjr.reg_id = smd.id','left');
	//	$DB1->join('ic_registration as ir','smd.ic_code = ir.ic_code','left');
		$DB1->where('mr.exam_id','07');
		$DB1->order_by('mr.marks','desc');
	$query=$DB1->get();
	//echo $DB1->last_query();
  $res=$query->result_array();   
  $i=1;
  $j=0;
       for($i=0;$i<count($res);$i++)
       {
           if($res[$i]['marks']!=$res[$i-1]['marks'])
           {
              $j++; 
           }
        $dat['ranking'] =$j;
  
            $DB1->where('id',$res[$i]['id']);

		 $DB1->update('mock_results',$dat);   
           
       }
        
        */
        
    }
    
function update_admission_details_for_2018()
	{
		//print_r($data);
		$DB1 = $this->load->database('umsdb', TRUE);

		$sql="SELECT a.adm_id,a.student_id,a.stream_id,a.`actual_fee`,a.applicable_fee, s.admission_session,a.academic_year,a.year FROM `admission_details` a left join student_master s on s.stud_id=a.student_id and s.academic_year =a.academic_year WHERE a.academic_year='2018' and s.admission_session='2018' and a.cancelled_admission='N'";//exit;
		//echo $sql;
        $query = $DB1->query($sql);
		$res =  $query->result_array();
		//echo "<br>";
		foreach($res as $rs){
			$actual_fee = $rs['actual_fee'];
			$stream_id = $rs['stream_id'];
			$year =$rs['year'];
			$admission_session = $rs['admission_session'];
			$actual_fee = $rs['actual_fee'];
			$applicable_fee = $rs['applicable_fee'];
			$adm_id = $rs['adm_id'];
			
			$sql1="SELECT total_fees FROM academic_fees where academic_year='2018-19' and stream_id='".$stream_id."' and year='".$year."' and admission_year='".$admission_session."'";
			$query1 = $DB1->query($sql1);
			$res1 =  $query1->result_array();		
			$total_fees = $res1[0]['total_fees'];//exit;
			
			if($actual_fee == $total_fees){

			}else{
				$diff_sch = $actual_fee - $applicable_fee;
				$total_act_fees = $total_fees - $diff_sch;
				$data['actual_fee'] = $total_fees;
				$data['applicable_fee'] = $total_act_fees;
				$data['fess_update_bybala'] = 'Y';
			
			//log creation
				if($adm_id){
					$sql11 ="INSERT INTO `sandipun_ums`.`admission_details_log` (`adm_id`, `student_id`, `form_number`, `enrollment_no`, `school_code`, `stream_id`, `year`, `academic_year`, `actual_fee`, `applicable_fee`, `opening_balance`, `total_fees_paid`, `fees_consession_allowed`, `concession_type`, `hostel_required`, `hostel_type`, `transport_required`, `transport_boarding_point`, `entry_from_ip`, `modify_from_ip`, `created_by`, `created_on`, `modified_by`, `modified_on`, `remark`, `cancelled_admission`)
					SELECT `adm_id`, `student_id`, `form_number`, `enrollment_no`, `school_code`, `stream_id`, `year`, `academic_year`, `actual_fee`, `applicable_fee`, `opening_balance`, `total_fees_paid`, `fees_consession_allowed`, `concession_type`, `hostel_required`, `hostel_type`, `transport_required`, `transport_boarding_point`, `entry_from_ip`, `modify_from_ip`, `created_by`, `created_on`, `modified_by`, `modified_on`, `remark`, `cancelled_admission` FROM admission_details where adm_id='$adm_id'";
					$query11 = $DB1->query($sql11);
				}
			$where=array("adm_id"=>$adm_id);
			$DB1->where($where); 
			$DB1->update('admission_details', $data);			
			//echo $DB1->last_query();
			//exit;
			}
		}
		return true;
	}
	//student lofin sms for feedbak form 
	public function send_allstudlogin()
	{
		//exit;
	    $this->load->library('Message_api');
		$odj = new Message_api();	    

	    $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT a.mobile,a.`enrollment_no`,u.username, u.password FROM (SELECT l.student_id,s.mobile,s.enrollment_no,COUNT(*) AS tot_students, SUM(CASE WHEN l.is_present='Y' THEN 1 ELSE 0 END) AS totPersent, 
(SUM(CASE WHEN l.is_present='Y' THEN 1 ELSE 0 END)/COUNT(*)) *100 AS att_percentage 
FROM `lecture_attendance` l LEFT JOIN student_master s ON s.stud_id=l.student_id WHERE l.academic_year='2018-19' AND l.academic_session='SUM' GROUP BY l.student_id
) AS a  LEFT JOIN user_master u ON a.enrollment_no=u.username and u.roles_id=4 WHERE a.att_percentage >=60 AND u.roles_id=4 AND `u`.`status` = 'Y' GROUP BY a.student_id ";
		$query = $DB1->query($sql);	   
		$result=$query->result_array();
		//echo count($result);exit;
		$l=1;
	foreach( $result as $results)
	{
	    
	   $mobile= $results['mobile'];
		//$mobile= '9545453097';
$username = $results['username'];
$password = $results['password'];
$sms_message ='Dear students! We assure you the best academic experience.  
Please fill up the feedback form and send us your responses.  
Visit: https://sandipuniversity.com/erp/login/index/student
Username: '.$username.'
Password: '.$password.'
Thank you,
Sandip University.';
$odj->send_sms($mobile,$sms_message); 
    //exit;  
	unset($sms_message);
	unset($mobile);
	unset($username);
	unset($password);
	$l++;
	}
	$k= $l.' messages sent';
    return $k;
}	
///////////////////////////////////////////////////////////////////////////////////////////////////
public function test_api(){
	$username = urlencode("u4282");
$msg_token = urlencode("j8eAyq");
$sender_id = urlencode("SANDIP"); // optional (compulsory in transactional sms)
$message = urlencode("tet");
$mobile = urlencode("9960006338");

$api = "http://bulksms.omegatelesolutions.com/api/send_enterprise_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile."";

$response = file_get_contents($api);

echo $response;
}

public function send_allstudlogin_phd(){
		//exit;
	    $this->load->library('Message_api');
		$odj = new Message_api();	
		
	    $DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT sm.`first_name`,sm.mobile,um.`username`,um.`password`,sm.admission_cycle FROM student_master AS sm
INNER JOIN `user_master` AS um ON um.`username`=sm.`enrollment_no`
WHERE sm.`admission_cycle` IN('JULY-19','JAN-18') AND um.roles_id='4' AND sm.`cancelled_admission`='N'";
		$query = $DB1->query($sql);	   
		$result=$query->result_array();
		//echo count($result);exit;
		$l=1;
	foreach( $result as $results)
	{
$mobile= $results['mobile'];
		//$mobile= '9545453097';
$username = $results['username'];
$password = $results['password'];
$sms_message ='Dear Scholar! We assure you the best academic experience. 

Your login details.  
Visit: https://sandipuniversity.com/erp/login/index/student
Username: '.$username.'
Password: '.$password.'

Thank you,
Sandip University.';
$odj->send_sms($mobile,$sms_message); 
    //exit;  
	unset($sms_message);
	unset($mobile);
	unset($username);
	unset($password);
	$l++;
	}
	$k= $l.' messages sent';
    return $k;
}	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////



public function update_exam_student_subject_pharma($examid)
	{

	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);

	$DB1 = $this->load->database('umsdb', TRUE);

	//    $DB1->distinct();

	$DB1->select("student_id,enrollment_no,exam_id,exam_month,exam_year,school_id,stream_id,semester,subject_id,subject_code,final_grade,result_grade");
	$DB1->from('exam_result_data');
	$DB1->where("exam_id", $examid);
	$ids = array('116', '119','170');
	$DB1->where_in('stream_id', $ids );
	$query = $DB1->get();

	// echo $DB1->last_query();exit;

	$result = $query->result_array();
	foreach($result as $rdata)
		{
		$attemp = $this->calculate_attempts($rdata['student_id'], $rdata['subject_id'], $rdata['exam_id']);
		if ($rdata['final_grade'] == "WH")
			{
			if ($rdata['result_grade'] == "F")
				{
				$passed = 'N';
				}
			  else
				{
				$passed = 'Y';
				}
			}
		  else
			{
			if ($rdata['final_grade'] == "F" || $rdata['final_grade'] == "AB")
				{
				$passed = 'N';
				}
			  else
				{
				$passed = 'Y';
				}
			}

		$dat['student_id'] = $rdata['student_id'];
		$dat['enrollment_no'] = $rdata['enrollment_no'];
		$dat['stream_id'] = $rdata['stream_id'];
		$dat['subject_id'] = $rdata['subject_id'];
		$dat['subject_code'] = $rdata['subject_code'];
		$dat['semester'] = $rdata['semester'];
		$dat['grade'] = $rdata['final_grade'];
		$dat['passed'] = $passed;
		$dat['exam_id'] = $rdata['exam_id'];
		$dat['no_of_attempt'] = $attemp + 1;
		$DB1->select("student_id");
		$DB1->from('exam_student_subject');

		//	 $DB1->where("exam_id",$rdata['exam_id']);

		$DB1->where("student_id", $rdata['student_id']);
		$DB1->where("subject_id", $rdata['subject_id']);

		//	 $DB1->where("exam_id>=",$rdata['exam_id']);

		$query2 = $DB1->get();
		$result2 = $query2->row_array();
		if ($result2['student_id'] == '')
			{
			$DB1->insert('exam_student_subject', $dat);
			}
		  else
			{

			// $DB1->where('exam_id',$rdata['exam_id']);

			$DB1->where('student_id', $rdata['student_id']);
			$DB1->where('subject_id', $rdata['subject_id']);
			$DB1->update('exam_student_subject', $dat);
			}

		/*	$DB1->select("student_id");
		$DB1->from('exam_student_subject');
		$DB1->where("exam_id",$examid);
		$DB1->where("student_id",$examid);
		$DB1->where("stream_id",$examid);
		$DB1->where("subject_id",$examid);
		$DB1->where("semester",$examid);
		$query2=$DB1->get();
		$result=$query->result_array();
		*/
		}
	}
	// exam_sessions
	public function exam_sessions($acd_yr) {
	    $DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "select * from exam_session order by exam_id desc";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        return $res;
    }	
	// fetch school name for detention 
	public function get_school_name($school) {
	    $DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "select school_short_name,school_name from vw_stream_details where school_code='$school'";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        return $res;
    }
	// fetch school name for detention 
	public function exam_detention_sessions() {
	    $DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "select distinct exam_session from student_detaintion_details where exam_session !=''";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        return $res;
    }


	function student_phdregistration_ums($data,$arr1,$arr2){
    	$DB1 = $this->load->database('umsdb', TRUE); 
    		  
	    $dupj =  $this->Ums_admission_model->chek_mob_exist($data['mobile']);
	    if($dupj[0]['mobile']!='')
	    {
	       //  echo "exist";
	        echo '<script>alert("Student Already Registered");window.location.href = "stud_list";</script>';
	        exit();
	    }
    		   
    	
		 if(!empty($_FILES['profile_img']['name'])){
			 $filenm=$student_id.'-'.time().'-'.$_FILES['profile_img']['name'];
            $config['upload_path'] = 'uploads/student_profilephotos/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
            //$config['file_name'] = $_FILES['profile_img']['name'];
            $config['file_name'] = $filenm;
                    
            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
                
            if($this->upload->do_upload('profile_img')){
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];
            }else{
                $picture = '';
            }
        }
		else{
            $picture = '';
        }
    	
    		
			if(!empty($_FILES['payfile']['name'])){
				 $filenm=$student_id.'-'.$_FILES['payfile']['name'];
                $config['upload_path'] = 'uploads/student_challans/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm; 
                //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
                    
            if($this->upload->do_upload('payfile')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    $payfile = '';
                }
            }
			else{
                $payfile = '';
            }
    		
    		$temp['admission_school']=$this->Ums_admission_model->getschool_bycourse($data['admission-branch']); 
    		if($_POST['adm_id']!='')
    		{
    		 	$prnj =	$temp['enrollment_no']=$_POST['adm_id'];   
		 		$temp['enrollment_no_new']=$_POST['adm_id'];   
    		}
    		else
    		{
		    	$prnj =	$temp['enrollment_no_new']=$this->Ums_admission_model->generateprn($data['admission-branch'],$data['acyear'],$data['admission_type']); 
		    	$temp['enrollment_no']=$this->Ums_admission_model->	generateprn_new($data['admission-branch'],$data['acyear'],$data['admission_type']); 
   			}
    		//($stream_id)
    		//course
    		$temp['admission_stream']=stripslashes(($data['admission-branch'])); 	
    		//student name
    		$temp['first_name']=strtoupper(stripslashes(($data['sfname']))); 		
    		$temp['middle_name']=strtoupper(stripslashes(($data['smname']))); 		
    		$temp['last_name']=strtoupper(stripslashes(($data['slname']))); 
            
    		$temp['gender']=stripslashes(($data['gender'])); 
    		$temp['blood_group']=stripslashes(($data['blood_gr'])); 
    		$temp['dob']=stripslashes(($data['dob']));
    		
    		$temp['birth_place']=stripslashes(($data['pob']));  
    		$temp['mobile']=stripslashes(($data['mobile'])); 
    		$temp['email']=stripslashes(($data['email_id'])); 
    		$temp['nationality']=stripslashes(($data['nationality'])); 
    		$temp['category']=stripslashes(($data['category']));  
    		//$temp['sub_caste']=stripslashes(($data['sub_caste']));  
    		$temp['religion']=stripslashes(($data['religion'])); 
    		$temp['adhar_card_no']=stripslashes(($data['saadhar'])); 
    		$temp['domicile_status']=stripslashes(($data['res_state'])); 
    		
    		//$temp['hostelfacility']=stripslashes(($data['hostel'])); 
    		//$temp['transportfacility']=stripslashes(($data['transport'])); 
    	//	$temp['bording_point']=stripslashes(($data['bording_point'])); 
    		//student Husband/father name
           // $temps['enrollment_no']=stripcslashes($stid);	
          //	$temp['academic_year']= date('Y');
           $temp['academic_year']= stripslashes(($data['acyear']));
               $temp['admission_session']= stripslashes(($data['acyear']));
            
           	$admission_type=stripslashes(($data['admission_type']));
           	
           if($admission_type==1 || $admission_type=='')
           {
            	$temp['current_year']='1';    
            		$temp['admission_year']='1';    
            	$temp['admission_semester']='1';
            	$temp['lateral_entry']='N';
            	$temp['current_semester']='1';
           }
           if($admission_type==2)
           {
               	$temp['current_year']='2';  
               $temp['admission_year']='2';    
            	$temp['admission_semester']='3';
            	$temp['lateral_entry']='Y';
            	$temp['current_semester']='3';
           }
           
          	$temp['entry_from_ip']= $_SERVER['REMOTE_ADDR'];
          	$temp['created_on']= date("Y-m-d H:i:s");
          	$temp['created_by']= $_SESSION['uid'];
    		$temp['father_fname']=strtoupper(stripslashes(($data['sfname1']))); 		
    		$temp['father_mname']=strtoupper(stripslashes(($data['smname1']))); 		
    		$temp['father_lname']=strtoupper(stripslashes(($data['slname1']))); 
             // student mother name		
    		$temp['mother_name']=strtoupper(stripslashes(($data['sfname2']))); 
    		$temp['student_photo_path']=$picture;
    		$temp['about_uni_know']=implode(",",$data['publicitysandip']);//$temp=implode("/ ",$mstatus); 
    		/***Address details***/
    		//local address bill_A
    		
    		$temp['form_number']=$data['sfnumber'];
    	
    		//Guardians details  parent_details author- vikas inserted
    		
    	    $DB1->insert('student_master',$temp);
    	     
    		$insert_id1 = $DB1->insert_id();
  
    	    $address['adds_of']='STUDENT'; 
    		$address['address_type']='CORS'; 
    		$address['address']=stripslashes(($data['laddress'])); 
    	//	$address['street']=stripslashes(($data['bill_B'])); 
    		$address['city']=stripslashes(($data['lcity'])); 
    		$address['state_id']=stripslashes(($data['lstate_id'])); 
    		$address['district_id']=stripslashes(($data['ldistrict_id'])); 
    		$address['pincode']=stripslashes(($data['lpincode']));
    		$address['student_id']=$insert_id1;	
    		
    		$DB1->insert('address_details',$address);
    	     
    	//	$insert_id1 = $this->db->insert_id();
    		
             // permenant	address	
    	    $paddress['adds_of']='STUDENT'; 
    		$paddress['address_type']='PERMNT'; 
    		$paddress['address']=stripslashes(($data['paddress'])); 
    	//	$paddress['street']=stripslashes(($data['bshipping_B'])); 
    		$paddress['city']=stripslashes(($data['pcity'])); 
    		$paddress['state_id']=stripslashes(($data['pstate_id'])); 
    		$paddress['district_id']=stripslashes(($data['pdistrict_id'])); 
    		$paddress['pincode']=stripslashes(($data['ppincode']));
    		$paddress['student_id']=$insert_id1;	
    		$DB1->insert('address_details',$paddress);
    		
    		
    	
    		$gpaddress['adds_of']='PARENT'; 
    		$gpaddress['address_type']='PERMNT'; 
    	    $gpaddress['student_id']=$insert_id1;
    	 		$gpaddress['address']=stripslashes(($data['gparent_address'])); 
    	//	$paddress['street']=stripslashes(($data['bshipping_B'])); 
    		$gpaddress['city']=stripslashes(($data['gcity'])); 
    		$gpaddress['state_id']=stripslashes(($data['gstate_id'])); 
    		$gpaddress['district_id']=stripslashes(($data['gdistrict_id'])); 
    		$gpaddress['pincode']=stripslashes(($data['gpincode']));
			$DB1->insert('address_details',$gpaddress);
    	
			$insert_id2 = $DB1->insert_id();
    	
    	 	$guardian['student_id']=stripcslashes($insert_id1);
    			//   $guardian['enrollement_no']=stripcslashes($stid);
    		$guardian['gfirst_name']=strtoupper(stripslashes(($data['fname']))); 
    		$guardian['gmiddle_name']=strtoupper(stripslashes(($data['mname']))); 
    		$guardian['glast_name']=strtoupper(stripslashes(($data['lname']))); 
    		$guardian['relation']=stripslashes(($data['relationship'])); 
    		$guardian['occupation']=stripslashes(($data['occupation'])); 
    		$guardian['income']=stripslashes(($data['annual_income'])); 
    		$guardian['parent_email']=stripslashes(($data['parent_email'])); 
    		$guardian['parent_mobile2']=stripslashes(($data['parent_mobile'])); 
    		$guardian['parent_mobile1']=stripslashes(($data['parent_phone'])); 
    		$guardian['address_id']=stripslashes($insert_id2);
    	    	$DB1->insert('parent_details',$guardian);
    	    //echo $DB1->last_query();
    	    //	exit(0);
    	    //	var_dump($_FILES['sss_doc']);
    	    	
    	    	if(count($data['exam_id'])>0)
    	    	{
	    	    	for($i=0;$i<count($data['exam_id']);$i++)
	    	    	{
	    	    	    if($data['exam_id'][$i] !='')
	    	    	    {
	    	    	    $exam['student_id']=$insert_id1;
	    				$exam['degree_type']=$data['exam_id'][$i]; 
	    	 			$exam['degree_name']=$data['stream_name'][$i]; 
	    	 			$exam['specialization']=$data['seat_no'][$i];
	    	 			$exam['board_uni_name']=$data['institute_name'][$i]; 
	    	 			$exam['passing_year']=$data['pass_month'][$i]."-".$data['pass_year'][$i];
	    	 			$exam['total_marks']=$data['marks_obtained'][$i];
	    	 			$exam['out_of_marks']=$data['marks_outof'][$i];
	    	 			$exam['percentage']=$data['percentage'][$i]; 
						$picture='';
						$key =$i;
	    	 	
	    				if(!empty($arr2[$i]) && $arr2[$i] !=''){
	    					$exam['file_path']= $arr2[$i];
	    				}
	    	 		
	    				$DB1->insert('student_qualification_details',$exam);
	    	    	    
		    	    	$insert_ide = $DB1->insert_id();
	    	    	    }
	    	        
	    	    	    
	    	    	    
	    	    	}
    	    	}
    	    	
    
    	    if(!empty($data['exam-name']) && $data['exam-name']!='') 	
    	    {	
    			for($i=0;$i<count($data['exam-name']);$i++)	
    			{
    			 
		  			$suexam['student_id']=$insert_id1;
				  	$suexam['entrance_exam_name']=$data['exam-name'][$i];
						//  $suexam['entrance_exam_name']=$data['other_exam-name'][$i];  
					 $suexam['passing_year']=$data['pass_monthe'][$i]."-".$data['pass_yeare'][$i]; 
					$suexam['register_no']=$data['enrolment'][$i];
					$suexam['marks_obt']=$data['marks'][$i]; 
				//	$suexam['marks_outof']=$data['totalmarks'][$i];
				//	$suexam['percentage']=$data['ent_percentage'][$i];
					$DB1->insert('student_entrance_exam',$suexam);    
						
				   //	echo $DB1->last_query();
    		  
    			}
    		}			
    	   
    	//    echo "vikas";
    	//    exit(0);
    	    	    
    	    //	$temp['academic_year']= date('Y');
           
		          $feedet['entry_from_ip']= $_SERVER['REMOTE_ADDR'];
		          $feedet['created_on']= date('Y-m-d');
		          $feedet['created_by']= $_SESSION['uid'];
		          
    	       	 $feedet['student_id']=$insert_id1;
    	        $feedet['amount']=$data['totalfeepaid'];
	            $feedet['type_id']=2;
	            $feedet['fees_paid_type']=$data['payment_type'];
             	$feedet['academic_year']= stripslashes(($data['acyear']));
    	    	            	
    	    //	     $exam['passing_year']=$data['supass_month']."-".$data['supass_year']; fees_paid_type
    	 			$feedet['receipt_no']=$data['dd_no'];
    	 			$feedet['fees_date']=$data['dd_date']; 
    	 			$feedet['bank_id']=$data['dd_bank'];
    	 			$feedet['bank_city']=$data['dd_bank_branch'];
    	 			$feedet['receipt_file']=$payfile;
    	    	     //  	$DB1->insert('fees_details',$feedet);   
    	    	      // 	$insert_feid1 = $DB1->insert_id();
    	        
    	          	$sbank['student_id']=$insert_id1;
    	    	    $sbank['account_no']=$data['account_no'];
    	    //	     $exam['passing_year']=$data['supass_month']."-".$data['supass_year']; 
    	 			$sbank['ifsc_code']=$data['ifsc'];
    	 			$sbank['bank_name']=$data['bank_name']; 
    	 
    	 			$sbank['bank_city']=$data['bank_branch'];
    	    	       	$DB1->insert('student_bank_details',$sbank);   
    	    	       	
	    	       	if($data['exepmted_fee']>0)
	    	       	{
	    	       	 	$fcdetails['concession_type']='Schlorship';
	    	       	 	$fcdetails['student_id']=$insert_id1;
	    	       	    $fcdetails['academic_year']=stripslashes(($data['acyear']));
	    	     
	    	       	  	$fcdetails['actual_fees']=$data['acd_totalfee'];
	    	       	   	$fcdetails['exepmted_fees']=$data['exepmted_fee'];
	    	       	    $fcdetails['fees_paid_required']=$data['totalfeeappli'];
	    	       	
	    	       	    $fcdetails['allowed_by']='Admin';
	    	            $fcdetails['created_on']= date("Y-m-d H:i:s");
      					$fcdetails['created_by']= $_SESSION['uid'];
	    	         //   $fcdetails['fees_paid_type']=$data['payment_type'];
	    	       	
	    	       		$DB1->insert('fees_consession_details',$fcdetails);   
	    	       	
	    	       	}
	    	       	
    	    	       	
       			// $admdetails['concession_type']='Schlorship';
	       	 		$admdetails['student_id']=$insert_id1;
	       	    	$admdetails['school_code']=$this->Ums_admission_model->getschool_bycourse($data['admission-branch']);
	       	    	$admdetails['stream_id']=stripslashes(($data['admission-branch']));
    	    	       	    
		   	        if($admission_type==1 || $admission_type=='')
		           {
		            	$admdetails['year']=1;    
		            
		           }
		          if($admission_type==2)
		           {
		              	$admdetails['year']='2';     
		            
		           }
    	       	   // $admdetails['year']=date('Y');
    	       	    $admdetails['academic_year']= stripslashes(($data['acyear']));
    	       	   // $admdetails['school_code']=date('Y');
    	       	    
    	       	  $admdetails['actual_fee']=$data['acd_totalfee'];
    	       	  
    	       	   $admdetails['applicable_fee']=$data['totalfeeappli'];
    	       	  //  $admdetails['fees_paid_required']=$data['totalfeepaid'];
    	       	  if($data['totalfeeappli']==$data['totalfeepaid'])
    	       	  {
    	       	     $admdetails['total_fees_paid']='Y'; 
    	       	      
    	       	  }
    	       	   if($data['exepmted_fee']>0)
    	       	  {
    	       	     $admdetails['fees_consession_allowed']='Y'; 
    	       	     	 $admdetails['concession_type']='Scholarship';
    	       	      
    	       	  }
    	    	        
    	       	  $admdetails['hostel_required']=$data['hostel'];
    	       	  $admdetails['hostel_type']=$data['hosteltype'];
    	       	  $admdetails['transport_required']=$data['transport'];
    	       	  $admdetails['transport_boarding_point']=$data['bording_point'];
    	       	  $admdetails['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
    	       	      //	  $admdetails['allowed_by']='Admin';
    	          $admdetails['created_on']= date("Y-m-d H:i:s");
  				$admdetails['created_by']= $_SESSION['uid'];
    	         //   $fcdetails['fees_paid_type']=$data['payment_type'];
    	          
    	    	              	
	       		$DB1->insert('admission_details',$admdetails);  
    	    	       	
    	    	  //echo $DB1->last_query();
    	    	        		
    	       	$fidetails['student_id']=$insert_id1;
    	       	$fidetails['fees_id']=$insert_feid1;
    	       	$fidetails['academic_year']= stripslashes(($data['acyear']));
    	       	$fidetails['no_of_installment']='1';
    	       	$fidetails['actual_fees']=$data['acd_totalfee'];
    	       	$fidetails['balance_fees']=((int)$data['totalfeeappli'] - (int)$data['totalfeepaid']);
    	       	   //  $fidetails['transport_boarding_point']=$data['bording_point'];    
    	       	$fidetails['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
    	       	      	//  $admdetails['allowed_by']='Admin';
    	        $fidetails['created_on']= date('Y-m-d');
  				$fidetails['created_by']= $_SESSION['uid'];

	    		$temp['student_id']=$insert_id1;
	    		$temp['doc_id']= $this->rearrange1($data['dapplicable']);//without changing key value sequence
	    		$temp['doc_applicable']	= $this->rearrange1($data['dapplicable']);
	    		$temp['ox']	= $this->rearrange1($data['ox']);
	    		$temp['sub_dt']	= $this->rearrange1($data['docsubdate']);
	    		$temp['remark']	= $this->rearrange1($data['remark']);
	    		//$temp['doc_path']= $this->rearrange1($data['filescan']); 
	    		$temp['doc_path']= $arr1;//$this->rearrange1($data['filescan']); 
	    		$list=array();
	    		$list=array_keys( $temp['doc_id']);
	    		$temp['doc_id']=$list;
	    		$list=array_combine($temp['doc_id'],$temp['doc_id']);
	    		 $temp['doc_id']=$list;
    	
    	      foreach($temp['doc_id'] as $key=>$val){
    		     $temp2['doc_id'][$key]=$temp['doc_id'][$key];
    			 $temp2['doc_applicable'][$key]=$temp['doc_applicable'][$key];
    			 $temp2['ox'][$key]=$temp['ox'][$key];
    			 $temp2['sub_dt'][$key]=$temp['sub_dt'][$key];
    			 $temp2['remark'][$key]=$temp['remark'][$key];
    			 $temp2['doc_path'][$key]=$temp['doc_path'][$key];
    			 }
	    		// for certificate details
	    		$cert['certificate_name']=$data['cnm'];
	    		$cert['certificate_no']=$data['cno'];
	    		$cert['issue_date']=$data['issuedt'];
	    		$cert['validity_date']=$data['cval'];
	    			
	    		$len=sizeof($cert['certificate_name']);
    		//echo $len;
    		
    		for($i=0;$i<$len;$i++){
    		$a['student_id']=$insert_id1;
    		$a['certificate_name']=	$cert['certificate_name'][$i];
    		$a['certificate_no']=	$cert['certificate_no'][$i];
    		$a['issue_date']=$cert['issue_date'][$i];
    		$a['validity_date']=$cert['validity_date'][$i];
    		$insert_id11 =$DB1->insert('student_certificate_submit_details',$a);
    	//	echo $DB1->last_query();
    		}
    		//end
    	
    			foreach($temp2['doc_id'] as $key=>$val){
    			$temp1['student_id']=$insert_id1;
    			$temp1['doc_id']=stripslashes(($temp2['doc_id'][$key]));
    			$temp1['doc_applicable']=stripslashes(($temp2['doc_applicable'][$key]));
    			$temp1['ox']=stripslashes(($temp2['ox'][$key]));
    			$temp1['remark']=stripslashes(($temp2['remark'][$key]));
    			$temp1['created_on']=stripslashes(($temp2['sub_dt'][$key]));
    			$temp1['doc_path']=stripslashes(($temp2['doc_path'][$key]));
    			$DB1->insert('student_document_details',$temp1);
    		}  
    	//	$insert_id1 = $this->db->insert_id();
    	
    		if($data['fref1']!='')
    		{
	    		$tempx['student_id']=$insert_id1;
	    		$tempx['is_from_reference']='Y';
	    		$tempx['person_name']=stripslashes(($data['fref1']));
	    		$tempx['contact_no']=stripslashes(($data['frefcont1']));
	    		$DB1->insert('student_references',$tempx);
    		}
    //		echo $DB1->last_query();
    	
    		if($data['fref2']!='')
    		{
	    		$tempy['student_id']=$insert_id1;
	    		$tempy['is_from_reference']='Y';
	    		$tempy['person_name']=stripslashes(($data['fref2']));
	    		$tempy['contact_no']=stripslashes(($data['frefcont2']));
	    		$DB1->insert('student_references',$tempy);	
    		}
    		
    		if($data['reletedsandip']=='Y')
    		{
    			$temp3['student_id']=$insert_id1;
    			$temp3['is_uni_employed']='Y';
    			$temp3['person_name']=stripslashes(($data['relatedname']));
    			$temp3['designation']=stripslashes(($data['relateddesig']));
    			$temp3['relation']=stripslashes(($data['relatedrelation']));
    			$DB1->insert('student_references',$temp3);	
    		}	
    			
    		if($data['aluminisandip']=='Y')
    		{
    			$temp4['student_id']=$insert_id1;
    			$temp4['is_uni_alumni']='Y';
    			$temp4['person_name']=stripslashes(($data['alumininame']));
    			$temp4['passing_year']=stripslashes(($data['aluminiyear']));
    			$temp4['relation']=stripslashes(($data['aluminirelation']));
    			$DB1->insert('student_references',$temp4);	
    		}
    		
    		
    		if($data['concern']=='Y')
    		{
    			$temp49['student_id']=$insert_id1;
    			$temp49['is_concern_ins']='Y';
    			$temp49['institute']=stripslashes(($data['cin']));
    			$DB1->insert('student_references',$temp49);	
    		}
    		
    	
    		if($data['relativesandip']=='Y')
    		{
    		$temp5['student_id']=$insert_id1;
    		$temp5['is_uni_student']='Y';
    		$temp5['person_name']=stripslashes(($data['relativename']));
    		$temp5['course']=stripslashes(($data['relativecoursenm']));
    		$temp5['relation']=stripslashes(($data['relativerelation']));
    		$DB1->insert('student_references',$temp5);	
    		}
    		//publicity_media
    		$temp1=array();
    		//$temp1=$data['publicitysandip'];
    	//	$temp['publicity_media']=implode(",",$temp1);//$temp=implode("/ ",$mstatus); 
    	
    		if($data['refcandidatenm']!='')
    		{
	    		$temp6['student_id']=$insert_id1;
	    		$temp6['is_reference']='Y';
	    		$temp6['person_name']=stripslashes(($data['refcandidatenm']));
	    		$temp6['contact_no']=stripslashes(($data['refcandidatecont']));
	    		$temp6['email']=stripslashes(($data['refcandidateemail']));
	    		$temp6['relation']=stripslashes(($data['refcandidaterelt']));
	    		$temp6['area_of_interest']=stripslashes(($data['refcandidateinterest']));
	    		
	    		$DB1->insert('student_references',$temp6);
    		}
    		
    		$temp['student_id']=$insert_id1;
    		
    		
    		return $prnj;
    }
/****************************************************************************/
function calculate_sgpa_pharma($examid,$semester)
{
  
	//$names = array('2396','2446','2473','4185','4949','5162');
	//$DB1->where_in('ers.enrollment_no', $names);
    $DB1 = $this->load->database('umsdb', TRUE);
	$DB1->select("ers.*,sgc.grade_rule");
	$DB1->from('exam_result_master as ers');
	$DB1->join('student_master as sm','ers.student_id = sm.stud_id','left'); 
	$DB1->join('stream_grade_criteria as sgc','sm.admission_stream = sgc.stream_id','left');
	$DB1->where("ers.exam_id",$examid); 
	$DB1->where("ers.semester",$semester); 
	$streamids = array('116', '119','170');
	$DB1->where_in('ers.stream_id', $streamids);
	//$DB1->where("ers.semester!=",'U');
	//$DB1->where_in('ers.student_id', $names);
	$query=$DB1->get();
	//echo $DB1->last_query();exit();
	$result=$query->result_array();	
  
  
  	foreach($result as $mydata)
	{
	    //$rule =;
		$DB1->select("erd.enrollment_no,erd.student_id,erd.exam_id,erd.final_grade,erd.subject_id,erd.subject_code,sm.credits,gpd.grade_point,sum(sm.credits) as total_credits,
		sum(gpd.grade_point) as total_grade,sum(sm.credits*gpd.grade_point) as sumcredit,sum(case when gpd.grade_point=0 then 0 else sm.credits end ) as credit_earned,
		");
		$DB1->from('exam_result_data as erd');
		$DB1->join('subject_master as sm','erd.subject_id = sm.sub_id','left'); 
	//	$DB1->join('grade_policy_details as gpd','erd.final_grade = gpd.grade_letter','left');
		$DB1->join('grade_policy_details_pharma as gpd','erd.final_grade = gpd.grade_letter','left');
		$DB1->where("erd.student_id",$mydata['student_id']); 
		$DB1->where('gpd.rule', $mydata['grade_rule']); 
		$DB1->where('erd.semester', $semester);
		$DB1->where_in('erd.stream_id', $streamids);	
	 	$DB1->where("erd.exam_id <=",$examid); 
	 	
		//$DB1->where("erd.result_grade!=",'F');
		$query1=$DB1->get();
		//echo $DB1->last_query();exit;
		$result1=$query1->row_array();
	  
	
		if($result1['credit_earned']==0)	
		{
			$tcgpa=0;
		}
		else
		{
		 $tcgpa1 = bcdiv($result1['sumcredit'],$result1['total_credits'],2); 	
		 $tcgpa = number_format((float)$tcgpa1, 2, '.', '');  
		}	  

		$dataupdate['sgpa']=$tcgpa;

        $DB1->where('student_id', $result1['student_id']);
        $DB1->where('exam_id', $examid);
        $DB1->where('semester', $semester);
		$DB1->update('exam_result_master',$dataupdate);   		  
		
	//echo $DB1->last_query();

	} 
}

public function calculate_cgpa_pharma($examid)
{
	//$names = array('2396','2446','2473','4185','4949','5162');
	$DB1 = $this->load->database('umsdb', TRUE);
	$DB1->select("ers.*,sgc.grade_rule");
	$DB1->from('exam_result_master as ers');
	$DB1->join('student_master as sm','ers.student_id = sm.stud_id','left'); 
	$DB1->join('stream_grade_criteria as sgc','sm.admission_stream = sgc.stream_id','left');
	$DB1->where("ers.exam_id",$examid); 
	$streamids = array('116', '119','170');
	$DB1->where_in('ers.stream_id', $streamids);
	//$DB1->where_in('ers.student_id', $names);
	$query=$DB1->get();
	//echo $DB1->last_query();exit;
	$result=$query->result_array();	

	foreach($result as $mydata)
	{
		$DB1->select("erd.enrollment_no,erd.student_id,erd.exam_id,erd.final_grade,erd.subject_id,erd.subject_code,sm.credits,gpd.grade_point,sum(sm.credits) as total_credits,
	sum(gpd.grade_point) as total_grade,sum(sm.credits*gpd.grade_point) as sumcredit,sum(case when gpd.grade_point=0 then 0 else sm.credits end ) as credit_earned,
	");
		$DB1->from('exam_result_data as erd');
		$DB1->join('subject_master as sm','erd.subject_id = sm.sub_id','left'); 
		//$DB1->join('grade_policy_details as gpd','erd.final_grade = gpd.grade_letter','left');
		$DB1->join('grade_policy_details_pharma as gpd','erd.final_grade = gpd.grade_letter','left');
		$DB1->where("erd.student_id",$mydata['student_id']); 
		$DB1->where('gpd.rule', $mydata['grade_rule']); 
		$DB1->where("erd.exam_id<=",$examid); 
	
		//$DB1->where("erd.result_grade!=",'F');
		$query2=$DB1->get();

		//echo $DB1->last_query();
		//exit();

		$result2=$query2->row_array();

		if($result2['credit_earned']==0)	
		{
			$tcgpa=0;
		}
		else
		{
		 $tcgpa = bcdiv($result2['sumcredit'],$result2['total_credits'], 4); 	
		}	  

		$dupdate['cumulative_credits']=$result2['sumcredit'];
		$dupdate['cumulative_gpa']=$tcgpa;

       // $DB1->where('student_id', $result1['student_id']);
		$DB1->where('student_id', $result2['student_id']);
		$DB1->where('exam_id', $examid);
		$DB1->update('exam_result_master',$dupdate);   
	}
}

public function calculate_gpa_pharma($examid,$semester)
{
   //$names = array('2396','2446','2473','4185','4949','5162');
	$DB1 = $this->load->database('umsdb', TRUE);
	$DB1->select("ers.*,sgc.grade_rule");
	$DB1->from('exam_result_master as ers');
	$DB1->join('student_master as sm','ers.student_id = sm.stud_id','left'); 
	$DB1->join('stream_grade_criteria as sgc','sm.admission_stream = sgc.stream_id','left');
	$DB1->where("ers.exam_id",$examid); 
	//$DB1->where_in('ers.enrollment_no', $names);
	$DB1->where("ers.semester",$semester); 
	$streamids = array('116', '119','170');
	$DB1->where_in('ers.stream_id', $streamids);
	//$DB1->where_in('ers.student_id', $names);
	$query=$DB1->get();
		
	$result=$query->result_array();	

	foreach($result as $mydata)
	{
	    //$rule =;
		$DB1->select("erd.enrollment_no,erd.student_id,erd.exam_id,erd.final_grade,erd.subject_id,erd.subject_code,sm.credits,gpd.grade_point,sum(sm.credits) as total_credits,
	sum(gpd.grade_point) as total_grade,sum(sm.credits*gpd.grade_point) as sumcredit,sum(case when gpd.grade_point=0 then 0 else sm.credits end ) as credit_earned,
	");
		$DB1->from('exam_result_data as erd');
		$DB1->join('subject_master as sm','erd.subject_id = sm.sub_id','left'); 
	//	$DB1->join('grade_policy_details as gpd','erd.final_grade = gpd.grade_letter','left');
		$DB1->join('grade_policy_details_pharma as gpd','erd.final_grade = gpd.grade_letter','left');
		$DB1->where("erd.student_id",$mydata['student_id']); 
		$DB1->where('gpd.rule', $mydata['grade_rule']); 
		$DB1->where('erd.semester', $semester); 	
		$DB1->where("erd.exam_id",$examid); 		

		//$DB1->where("erd.result_grade!=",'F');
		$query1=$DB1->get();

		$result1=$query1->row_array();		  
		if($result1['credit_earned']==0)	
		{
			$cgpa=0;
		}
		else
		{
		 $cgpa = bcdiv($result1['sumcredit'],$result1['total_credits'], 4); 	
		}

		$dupdate['credits_registered']=$result1['total_credits'];
		$dupdate['credits_earned']=$result1['credit_earned'];
		$dupdate['grade_points_earned']=$result1['total_grade'];
		$dupdate['grade_points_avg']=$cgpa;

		$DB1->where('student_id', $result1['student_id']);
		$DB1->where('exam_id', $examid);
		$DB1->where('semester', $semester);
		$DB1->update('exam_result_master',$dupdate);   
	}      
}
/******************************************************************************/
//craeted by vikas for getting student record
 	function getStudentsdata(){
		 $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*");
		$DB1->from('student_master as sm');
		//$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		$DB1->where("sm.academic_year", '2018');
		$DB1->where("sm.admission_cycle");
		$DB1->where("sm.cancelled_admission",'N');
		$DB1->where("sm.is_detained",'N');
		$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
		//echo $DB1->last_query();
		$result=$query->result_array();
		return $result;
	}
	function getstreamcourseduration($streamid)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("course_duration");
		$DB1->from('vw_stream_details');
		$DB1->where("stream_id",$streamid);
		$query=$DB1->get();
		//echo $DB1->last_query();
		$result=$query->result_array();
		return $result;
	}
	 function fetch_maxadmission_details($stud_id,$acyear=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('admission_details');
		//$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->where('student_id', $stud_id);
		if($acyear !='')
		{
		   	$DB1->where('academic_year', $acyear); 
		}
		$DB1->order_by("adm_id", "desc");
	$DB1->limit(1,0);

		$query=$DB1->get();
		$result=$query->result_array();
//	echo $DB1->last_query();
		return $result;
	}

	function Reported($enrollment_no, $academic_year = '', $stud_id, $no_yes) {
		$this->studentReportingDetails($enrollment_no, $academic_year, $stud_id, $no_yes);
		$DB1 = $this->load->database('umsdb', TRUE);
		$dupdate['reported_status'] = $no_yes;
		$dupdate['reported_date'] = date('Y-m-d h:i:s');
		$DB1->where('stud_id', $stud_id);
		$DB1->where('enrollment_no', $enrollment_no);
		$DB1->update('student_master',$dupdate); 
		return $stud_id;
	}

	function studentReportingDetails($enrollment_no, $academic_year = '', $stud_id, $no_yes) {
		$DB1 = $this->load->database('umsdb', TRUE);

		// Check Record Already Exists
		$DB1->select("srd.*");
		$DB1->from('student_reporting_details srd');
		if($stud_id) {
			$DB1->where('srd.student_id', $stud_id);
		}

		if($enrollment_no) {

			$DB1->where('srd.enrollment_no', $enrollment_no);
		}

		if($academic_year) {
			$DB1->where('srd.academic_year', $academic_year);
		}

		$selectQuery = $DB1->get();
		$result1 = $selectQuery->result_array();

		// Update Reporting Date if Already Exists
		if ($result1) {
			$dataS['student_id'] = $stud_id;
			$dataS['enrollment_no'] = $enrollment_no;
			$dataS['academic_year'] = $academic_year;
			$dataS['reported_status'] = $no_yes;
			$dataS['reported_date'] = date('Y-m-d h:i:s');
			$dataS['inserted_on'] = date('Y-m-d h:i:s');
			$dataS['updated_on'] = date('Y-m-d h:i:s');
			$dataS['updated_by'] = $_SESSION['uid'];
			$dataS['ip_address'] = $this->input->ip_address();
			if($stud_id) {
				$DB1->where('srd.student_id', $stud_id);
			}

			if($enrollment_no) {
				$DB1->where('srd.enrollment_no', $enrollment_no);
			}

			if($academic_year) {
				$DB1->where('srd.academic_year', $academic_year);
			}

			$result = $DB1->update('student_reporting_details srd',$dataS);
		} else {
			//Prepare Data For Inserting Log
			$data['student_id'] = $stud_id;
			$data['enrollment_no'] = $enrollment_no;
			$data['academic_year'] = $academic_year;
			$data['reported_status'] = $no_yes;
			$data['reported_date'] = date('Y-m-d h:i:s');
			$data['inserted_on'] = date('Y-m-d h:i:s');
			$data['updated_on'] = date('Y-m-d h:i:s');
			$data['inserted_by'] = $_SESSION['uid'];
			$data['ip_address'] = $this->input->ip_address();
			$result = $DB1->insert('student_reporting_details', $data);
		}

		if($result) {
			return true;
		} else {
			return true;
		}
	}

	function get_feedetails_pro_listing($stdid,$acyear=''){
		    $DB1 = $this->load->database('umsdb', TRUE);
		//$DB1->select("fd.*,bm.bank_name");
		    $DB1->select("fd.*");
		$DB1->from('fees_details fd');
			//$DB1->join('bank_master as bm','fd.bank_id = bm.bank_id','left');
			$DB1->where('fd.prov_reg_no',$stdid);
			if($acyear!='')
			{
			$DB1->where('fd.academic_year',$acyear);
			}
				$DB1->where('fd.type_id','2');
				$DB1->where('fd.is_deleted','N');
	
		$query=$DB1->get();
	//	echo $DB1->last_query();
		$result=$query->result_array();
		return $result;
	}
	
		function get_registation_Studentsajax($reported='',$year='',$fees_paid='',$admission_school=""){
		
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$DB1->select("sm.enrollment_no,sm.stud_id,sm.mobile,sm.email,sm.dob,sm.first_name,sm.middle_name,sm.last_name,sm.admission_session,sm.academic_year,sm.current_semester,sm.current_year,  v.stream_name, v.partner_name, v.is_partnership, v.school_short_name ");
		$DB1->from('admission_details as ad');
		$DB1->join('student_master as sm','sm.stud_id = ad.student_id','inner');
		$DB1->join('vw_stream_details as v','v.stream_id = sm.admission_stream','left');

		
		if($year!='')
		{
			$DB1->where("sm.admission_session != ", $year);
			$DB1->where("sm.academic_year = ", $year);
		}
		if(isset($role_id) && $role_id==20){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $DB1->where("v.school_code",$schid);
			 //$sql .=" AND vsd.school_code = $schid";
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$DB1->where("v.school_code",$sccode);
				//$sql .=" AND vsd.school_code = $sccode";
		}
		else if($admission_school!='All'){
			$DB1->where("sm.admission_school",$admission_school);
		}
		
		$DB1->where("sm.cancelled_admission",'N');
		$DB1->where("sm.is_detained",'N');
		//$DB1->where("sm.admission_cycle!=",'NULL');
		
	
		$DB1->order_by("sm.enrollment_no", "desc");
		//$DB1->order_by("fd.fees_id", "desc");
		$DB1->group_by("sm.stud_id");
		$query=$DB1->get();
		//echo $DB1->last_query(); exit;
		$result=$query->result_array();
		return $result;
	}
	function get_registation_Studentsajax_2019($reported='',$year='',$fees_paid='',$admission_school=""){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,fd.*,fd.academic_year as fd_ac_year, fd.amount AS feepaid, v.stream_name,v.partner_name,v.is_partnership, sch.school_short_name");
		$DB1->from('student_master as sm');
		$DB1->join('fees_details as fd','sm.stud_id = fd.student_id','left');
		$DB1->join('vw_stream_details as v','v.stream_id = sm.admission_stream','left');
		$DB1->join('school_master as sch','sm.admission_school = sch.school_id','left');
		
		if($year!='')
		{
			$DB1->where("sm.admission_session != ", $year);
		}
		/*if($reported=='All' && $fees_paid=='All')
		{
			$where_fee = "fd.amount > 0 AND fd.academic_year='$year'";
			$DB1->where("fd.type_id",'2');
			$DB1->where("sm.academic_year",$year);
			$DB1->where("sm.stud_id NOT IN (select student_id from fees_details where academic_year='$year' and type_id='2')",NULL,FALSE);
		}
		if($reported!='All' && $fees_paid=='All')
		{
			$DB1->where("sm.reported_status",$reported);
			$where_fee = "fd.amount > 0 AND fd.academic_year='$year'";
			$DB1->where("fd.type_id",'2');
			$DB1->where("sm.academic_year",$year);
			$DB1->where("sm.stud_id NOT IN (select student_id from fees_details where academic_year='$year' and type_id='2')",NULL,FALSE);
		}*/
		if($reported=='All' && $fees_paid=='N')
		{
			$DB1->where("sm.academic_year",$year);
			$DB1->where("sm.stud_id NOT IN (select student_id from fees_details where academic_year='$year' and type_id='2')",NULL,FALSE);
		}

		if($reported=='All' && $fees_paid=='Y')
		{
			$where_fee = "fd.amount > 0 AND fd.academic_year='$year'";
			$DB1->where("fd.type_id",'2');
			$DB1->where("sm.academic_year",$year);
			$DB1->where($where_fee);
		}
		if($reported=='N' && $fees_paid=='N')
		{
			$DB1->where("sm.reported_status",$reported);
			$DB1->where("sm.academic_year",$year);
			$DB1->where("sm.stud_id NOT IN (select student_id from fees_details where academic_year='$year' and type_id='2')",NULL,FALSE);
		}

		if($reported=='Y' && $fees_paid=='Y')
		{
			$DB1->where("sm.reported_status",$reported);
			$where_fee = "fd.amount > 0 AND fd.academic_year='$year'";
			$DB1->where("fd.type_id",'2');
			$DB1->where("sm.academic_year",$year);
			$DB1->where($where_fee);
		}
		if($reported=='N' && $fees_paid=='Y')
		{
			$DB1->where("sm.reported_status",$reported);
			$DB1->where("sm.academic_year",$year);
			$DB1->where("fd.type_id",'2');
			$where_fee = "fd.amount > 0 AND fd.academic_year='$year'";
			$DB1->where($where_fee);
			//$DB1->order_by("fd.fees_id", "desc");
		}
		
		if($reported=='Y' && $fees_paid=='N')
		{
			$DB1->where("sm.reported_status",$reported);
			$DB1->where("sm.academic_year",$year);
			$DB1->where("sm.stud_id NOT IN (select student_id from fees_details where academic_year='$year' and type_id='2')",NULL,FALSE);
			//$where_fee = "fd.amount = 0 AND fd.academic_year='$year'";
			//$DB1->where($where_fee);
			//$where_fee = "fd.amount = 0 AND fd.academic_year='$year'";
			//$DB1->where($where_fee);
					
		}
		
		
		if($admission_school!='All'){
			$DB1->where("sm.admission_school",$admission_school);
		}
		
		$DB1->where("sm.cancelled_admission",'N');
		$DB1->where("sm.is_detained",'N');
		//$DB1->where("sm.admission_cycle!=",'NULL');
		
	
		$DB1->order_by("sm.enrollment_no", "desc");
		//$DB1->order_by("fd.fees_id", "desc");
		$DB1->group_by("sm.stud_id");
		$query=$DB1->get();
		//echo $DB1->last_query(); exit;
		$result=$query->result_array();
		return $result;
	}
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
/////////////////////////////////////////////////////////////////

function cancel_stud_admission_request($stud_id,$prn)
{
		$DB1 = $this->load->database('umsdb', TRUE);

		$sstatus['cancelled_admission']='Y';
        $DB1->where('stud_id', $stud_id);
		$DB1->update('student_master',$sstatus);
		
		//echo $DB1->last_query();
     	// exit(0);
		
		$DB1->where('student_id', $stud_id);
		$DB1->update('admission_details',$sstatus);
		
		$ustat['status']='N';
		$DB1->where('username', $prn);
		$DB1->update('user_master',$ustat);

		$students_adm_cancel_lists['is_cancelled']='Y';
		$DB1->where('student_id', $stud_id);
		$DB1->update('students_adm_cancel_lists',$students_adm_cancel_lists); 


		$DB1->select("*");
		$DB1->from('academic_session');
		$DB1->where("currently_active",'Y');
		$query=$DB1->get();
		//echo $DB1->last_query();
		$academic_session=$query->result_array();
		$academic_session_data=explode("-",$academic_session[0]['academic_year']);

		////////////////////////////////////////////////////////////////////
		$DB1->select("*");
		$DB1->from('student_master');
		$DB1->where('stud_id', $stud_id);
		$DB1->where("admission_session",$academic_session_data[0]);
		$DB1->where("academic_year",$academic_session_data[0]);
		$query1=$DB1->get();
		//echo $DB1->last_query();
		$getacademic_session=$query1->result_array();
		if(!empty($getacademic_session))
		{
			 $DB2 = $this->load->database('icdb', TRUE);
			 $DB2->select("adm_id");
			$DB2->from('provisional_admission_details');
			$DB2->where('prov_reg_no', $prn);
			$query1=$DB2->get();
			$adm_id=$query1->result_array();
			if(!empty($adm_id))
			{

				$padm_status['is_cancelled']='Y';
		        $DB2->where('prov_reg_no', $prn);
				$DB2->update('provisional_admission_details',$padm_status);
				/////////update student_meet_details////

				$smett_det_status['admission_confirm']='N';
		        $DB2->where('id', $adm_id[0]['adm_id']);
				$DB2->update('student_meet_details',$smett_det_status);
				


			}
			

		}



			
  
}
///////////

function searchforcancellation_registardata(){
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,cm.course_name,adm.actual_fee,adm.applicable_fee,sdc.is_cancelled as cancelreq,sdc.student_id");
		$DB1->from('students_adm_cancel_lists as sdc');
		$DB1->join('student_master as sm','sm.stud_id = sdc.student_id','left');
		$DB1->join('admission_details as adm','sm.stud_id = adm.student_id','left');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
			$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		
			$DB1->where("sdc.is_cancelled",'N');	
		
	//	if($data['prn']!='')
	//	{
			//$DB1->where("sm.enrollment_no",$data['prn']);	    
    //	}
    	
    	
	
	//	$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
	// echo $DB1->last_query();
	//	exit(0);
		$result=$query->result_array();
		
		if(!empty($result)){
			foreach($result as $res){
				
				$datas[$res['stud_id']]['total_fee']=$this->fetch_total_fee_paid($res['stud_id']);

			}
			
		}
//		$result['total_fee']=$this->fetch_total_fee_paid($result['stud_id']);
		//echo $this->db->last_query();
		
		 /* die();   */  
	//	$result=$query->result_array();
		return array($result,$datas);
	}
    ///////
    public function update_icerp_student_meet_details_provisional_adm_details($stud_id,$change_stream)
    {
    	$DB1 = $this->load->database('umsdb', TRUE);

    	$DB1->select("*");
		$DB1->from('academic_session');
		$DB1->where("currently_active",'Y');
		$query=$DB1->get();
		//echo $DB1->last_query();
		$academic_session=$query->result_array();
		$academic_session_data=explode("-",$academic_session[0]['academic_year']);

		////////////////////////////////////////////////////////////////////
		$DB1->select("*");
		$DB1->from('student_master');
		$DB1->where('stud_id', $stud_id);
		$DB1->where("admission_session",$academic_session_data[0]);
		$DB1->where("academic_year",$academic_session_data[0]);
		$query1=$DB1->get();
		//echo $DB1->last_query();
		$getacademic_session=$query1->result_array();
		
		if(!empty($getacademic_session))
		{
			
			$DB3=$this->load->database('univerdb', TRUE);
			$DB3->select("sp_id");
			$DB3->from('school_programs_new');
			$DB3->where('ums_id', $change_stream);
			$query2=$DB3->get();
			$streamid=$query2->result_array();
		
	
			$DB2 = $this->load->database('icdb', TRUE);
			$DB2->select("adm_id");
			$DB2->from('provisional_admission_details');
			$DB2->where('prov_reg_no', $getacademic_session[0]['enrollment_no']);
			$query1=$DB2->get();
			$adm_id=$query1->result_array();
			if(!empty($adm_id))
			{
				

				$padm_status['program_id']=$streamid[0]['sp_id'];
		        $DB2->where('prov_reg_no', $getacademic_session[0]['enrollment_no']);
				$DB2->update('provisional_admission_details',$padm_status);
				/////////update student_meet_details////

				$smett_det_status['course_interested']=$streamid[0]['sp_id'];
				$smett_det_status['programme_id']=$streamid[0]['sp_id'];
				$smett_det_status['course_walkin']=$streamid[0]['sp_id'];
		        $DB2->where('id', $adm_id[0]['adm_id']);
				$DB2->update('student_meet_details',$smett_det_status);
				


			}
			

		}
		return true;
    }
    public function change_status_of_student_batchallocation_and_applied_subjects($student_id,$prevstreamid,$sesmetsesr,$changestream,$acayear)
    {
    		$DB1 = $this->load->database('umsdb', TRUE);

			$acad_year = $acayear+1;
			$newac = substr($acad_year, -2);
			$nacdyr =$acayear.'-'.$newac; 
	    	$DB1->select("*");
			$DB1->from('student_applied_subject');
			$DB1->where('stud_id',$student_id);
			$DB1->where('semester',$sesmetsesr);
			$DB1->where('academic_year',$nacdyr);
			$DB1->where('stream_id',$changestream);
			$query=$DB1->get();
			//echo $DB1->last_query();
			$changestreamm=$query->result_array();
			if(!empty($changestreamm))
			{
				$changestreamdata['is_active']='Y';
				$changestreamdata['modify_by']=$_SESSION['uid'];
				$changestreamdata['modify_on']=date('Y-m-d H:i:s');
				$DB1->where('stud_id',$student_id);
				$DB1->where('semester',$sesmetsesr);
				$DB1->where('stream_id',$changestream);
				$DB1->where('academic_year',$nacdyr);
				$DB1->update('student_applied_subject',$changestreamdata);

			}

			//update student subject allocation deactivate
			$isactic['is_active']='N';
			$isactic['modify_by']=$_SESSION['uid'];
			$isactic['modify_on']=date('Y-m-d H:i:s');
			$DB1->where('stud_id',$student_id);
			$DB1->where('semester',$sesmetsesr);
			$DB1->where('stream_id',$prevstreamid);
			$DB1->where('academic_year',$nacdyr);
			$DB1->update('student_applied_subject',$isactic);
			//end of student subject allocation deactivate

			//update student batch  allocation deactivate
			//$sem=($data['hcsem']);
			$isacticbatch['active']='N';
			$isacticbatch['modify_by']=$_SESSION['uid'];
			$isacticbatch['modify_on']=date('Y-m-d H:i:s');
			$DB1->where('student_id',$student_id);
			$DB1->where('semester',$sesmetsesr);
			$DB1->where('stream_id',$prevstreamid);
			$DB1->where('academic_year',$nacdyr);
			$DB1->update('student_batch_allocation',$isacticbatch);
			//end of student subject allocation deactivate

		

    }
    public function check_request_of_stream_change($stud_id)
    {
    	$DB2 = $this->load->database('umsdb', TRUE);
		$DB2->select("*");
		$DB2->from('tmp_student_change_stream');
		$DB2->where('stud_id', $stud_id);
		$DB2->order_by('tmp_id', 'DESC');
		$DB2->limit('1');
		$query1=$DB2->get();
		return $query1->result_array();

    }
    function getStudentsajax_document($streamid='',$year='',$acdyear='',$course=''){
    	
		    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,vsd.*,GROUP_CONCAT( DISTINCT sdd.doc_id ORDER BY sdd.doc_id  SEPARATOR', ') as docdata, GROUP_CONCAT( DISTINCT sqd.degree_type ORDER BY sqd.degree_type  SEPARATOR', ') as degree_type ");
		$DB1->from('student_master as sm');
		$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
		$DB1->join('student_document_details as sdd','sdd.student_id = sm.stud_id','left');
		$DB1->join('student_qualification_details as sqd','sqd.student_id = sm.stud_id','left');
		if($streamid=='0' || $streamid=='')
		{
				    
		}
		else
		{
			$DB1->where("sm.admission_stream",$streamid);    
		}
		if($year=='0' || $year=='' )
		{
		
			
		}
		else
		{
		
			$DB1->where("sm.current_year", $year);
		}
		if($acdyear!='')
		{
		
			$DB1->where("sm.academic_year", $acdyear);
		}

		if($course=='0' || $course=='' )
		{
		
			
		}
		else
		{
		
			$DB1->where("vsd.course_id", $course);
		}

		$DB1->where("sm.cancelled_admission",'N');
	
		$DB1->order_by("sm.enrollment_no", "asc");
		//$DB1->order_by("sm.admission_stream", "asc");
		$DB1->order_by("sm.current_semester", "asc");
		$DB1->group_by("sm.stud_id");
		//$DB1->order_by("sm.admission_cycle", "asc");
		$query=$DB1->get();
	/*	echo $DB1->last_query();
		die;*/
		$result=$query->result_array();
		return $result;
	}
	function load_batch_student_list($data){
		$DB1 = $this->load->database('umsdb', TRUE); 

		$sql="SELECT distinct(admission_cycle) FROM student_master where academic_year='".$data['academic_year']."' and admission_cycle is not null";
	    $query = $DB1->query($sql);
		//echo $DB1->last_query();
		return $res =  $query->result_array();  
	}
    	
    

}

