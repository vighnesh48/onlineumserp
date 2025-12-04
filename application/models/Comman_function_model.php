<?php
class Comman_function_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }  
    
	function getStateList($id){
		
		$sql="SELECT * FROM states WHERE country_id='$id' order by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
	}
	function getStateById($sid){
		$sql="SELECT * FROM states WHERE id='$sid' order by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
	}
	
	
function getCityListbystate($sid){
$sql="SELECT * FROM cities WHERE state_id='$sid'  OR state_id='' order by name ASC ";


        $query = $this->db->query($sql);
        return $query->result_array();
}
	function getCityList($id){
		
		$sql="SELECT * FROM cities WHERE id='$id' order by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
	}
    function getCity_id_byname($name){
        
        $sql="SELECT * FROM cities WHERE name='$name' order by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	  function get_countries(){
    $this->db->select('*');
        $this->db->from('countries');       
            //$this->db->where("id IN ('101')"); 
      
        $query = $this->db->get();
      //  echo $DB1->last_query();
        $query = $query->result_array();
        return $query;
    }
	
	
	
	function getCountryById1($id){
		$this->db->select('id,name');
		$this->db->from('countries');
		$this->db->where('id',$id);
		$query=$this->db->get();
		$result=$query->result_array();
		return $result[0]['name'];
		
	}
	function getCityById($id){
		$this->db->select('id,name');
		$this->db->from('cities');
		$this->db->where('id',$id);
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
		
	}
	
	function get_between_dates($fdate,$tdate){
	
// Declare two dates 
$Date1 = date('d-m-Y',strtotime($fdate)); 
$Date2 = date('d-m-Y',strtotime($tdate)); 

// Declare an empty array 
$array = array(); 

// Use strtotime function 
$Variable1 = strtotime($Date1); 
$Variable2 = strtotime($Date2); 

// Use for loop to store dates into array 
// 86400 sec = 24 hrs = 60*60*24 = 1 day 
for ($currentDate = $Variable1; $currentDate <= $Variable2; 
								$currentDate += (86400)) { 
									
$Store = date('Y-m-d', $currentDate); 
$array[] = $Store; 
} 

// Display the dates in array format 
return $array; 

}
/**************************** */
function get_all_ic($iccode = '')
{
    $uid = $this->session->userdata("uid");
    $rid = $this->session->userdata('role_id');

    // Load icdb connection
    $ICDB = $this->load->database('icdb', TRUE);

    // Start building SQL
    $sql = "SELECT ic_code, ic_name FROM `{$ICDB->database}`.ic_registration WHERE center_type='ic' AND status='Y'";

    // If specific IC code is provided
    if ($iccode != '') {
        $sql .= ' AND ic_code="' . $iccode . '"';
    }

    // Restrict to consultant_head's ICs for role 27
    if ($rid == 27) {
        $sql .= " AND ic_code IN (
            SELECT ic_code FROM `{$ICDB->database}`.ic_mapping 
            WHERE consultant_head = $uid AND status = 'Y'
        )";
    }

    // Execute query on ICDB
    $query = $ICDB->query($sql);
    return $query->result_array();
}
/**************************** */

// 	function get_all_ic($iccode=''){
// 	$uid=$this->session->userdata("uid");	
// 	$sql = "select ic_code,ic_name FROM `ic_registration` where center_type='ic' and status ='Y'";
// 	//exit;
// 	if($iccode!=''){
// 		$sql .= 'and ic_code="'.$iccode.'"';
// 	}
// 	$rid = $this->session->userdata('role_id'); 
// 	if($rid==27 ){
//         $sql .= '  and ic_code in  (
// 		select ic_code
// 		from ic_mapping where consultant_head='.$uid.' and status="Y" 
// 		) ';
//     }
// 	$query = $this->db->query($sql);
//         return $query->result_array();
// }

function fetch_stream_bystandard($standard='')
    {
		if($standard =='6'){
			$degree_type = 'PR';
		}elseif($standard =='1' || $standard =='2'){
			$degree_type = 'JR';
		}elseif($standard =='3' || $standard =='4' || $standard =='5'){
			$degree_type = 'UG';
		}elseif($standard =='8'){
			$degree_type = 'UG';
		}elseif($standard =='10'){
			$degree_type = 'Diploma';
		}elseif($standard =='11'){
            $degree_type = 'PG';
        }else{
			$degree_type = '';
		}
		
        $this->db->select('*');
        $this->db->from('stream_master');
		
        if ($standard != "") {
            $this->db->where("degree_type ='".$degree_type."' ");
            $this->db->where("status ='Y' ");
        }
        $this->db->order_by('stream_name', 'ASC');
        $query = $this->db->get();
	//echo $this->db->last_query();//exit;
        $query = $query->result_array();
        return $query;
		
		
    }
    function fetch_streamByid($id)
    {

 $this->db->select('stream_id,stream_name');
        $this->db->from('stream_master');
  $this->db->where('stream_id',$id);
   $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }
     function chek_mob_exist($mobile_no='',$ac=""){
		 $academic_year=ACADEMIC_YEAR;
	if(!empty($ac))	{
	$academic_year=$ac;
}
         $sql="SELECT id FROM student_meet_details where (mobile1 = '".$mobile_no."' OR mobile2='".$mobile_no."' )
		 and academic_year='$academic_year'

		 limit 0,1";
    //echo $sql;exit();
       $query = $this->db->query($sql);
        return $query->result_array();  
    }  
     function chek_mob_exist_update($mobile_no,$id){
         $sql="SELECT id FROM student_meet_details where id !='".$id."' and mobile1 = '".$mobile_no."' OR mobile2='".$mobile_no."' limit 0,1 ";
    //echo $sql;exit();
       $query = $this->db->query($sql);
       //echo $this->db->last_query();exit;
        return $query->result_array();  
    }    
    function get_standards()
    {
		$DB1=$this->load->database('icdb',TRUE);
        $DB1->select('*');
        $DB1->from('standard_master');
        $DB1->where("status = 'Y'");
        $DB1->order_by('order_no', 'ASC');
        $query = $DB1->get();
        $query = $query->result_array();
        //echo $DB1->last_query();exit;
        return $query;       
    }
     function get_exam_list_bytype($ex=''){
    	$this->db->select('exam_id,exam_name');
        $this->db->from('exam_master');
        $this->db->where('is_active','Y');
		if(!empty($ex)){
          $this->db->where('test_type',$ex);
		}
		 $this->db->where('exam_id IN (1,2,3,5)');
        $this->db->order_by('exam_id', 'ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        //echo $this->db->last_query();//exit;
        return $query;   
    }

     function get_exam_list_bytype_name($ex){
        $this->db->select('exam_id,exam_name');
        $this->db->from('exam_master');
        $this->db->where('is_active','Y');
          $this->db->where('test_type',$ex);
        $this->db->order_by('exam_id', 'ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        //echo $this->db->last_query();exit;
        return $query;   
    }
    function check_student_exam_registration($stud,$mocksujee=''){
        if($mocksujee!='')
        {
            $dd="and em.test_type='$mocksujee'";

        }
        else {
            $dd='';

        }
        $sql="select sjr.sujee_id,em.test_type,sjr.student_id,sjr.reg_no,sjr.exam_no,sjr.exam_type,sjr.exam_date,sjr.exam_name,em.exam_name as examname from su_jee_registration  as sjr inner join  exam_master  em  on em.exam_id= sjr.exam_no  where sjr.is_active='Y' and sjr.student_id='".$stud."'  ".$dd."";
         $query = $this->db->query($sql);
        return $query->result_array(); 
    }
     function fetch_bd_bdm($ic_code){
       // $ic_code = $this->session->userdata('ic_code');
        $uid = $this->session->userdata('uid');
        $rid = $this->session->userdata('role_id');     
         $sql = "select UM.*,IUM.fname,IUM.lname from user_master as UM left join ic_user_master as IUM on IUM.username = UM.username       
          where UM.ic_code='$ic_code' and IUM.ic_code = '$ic_code'  and UM.roles_id IN ('4','8') and IUM.status='Y' and UM.status='Y' order by IUM.username ASC ";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        return $query->result_array();
    }

    function get_all_ic_belong_to_consultant($iccode=''){
    $sql = "select  ccd.ic_code,ir.ic_name FROM  consultants_call_details as ccd left join  `ic_registration` as ir on ir.ic_code=ccd.ic_code where center_type='ic' and ccd.status ='Y' and ir.status ='Y'";
    //exit;
    if($iccode!=''){
        $sql .= 'and ic_code="'.$iccode.'"';
    }
 $sql .= ' group by ccd.ic_code ';

    $query = $this->db->query($sql);
        return $query->result_array();
}

function get_all_users($iccode=''){
   /* $sql = "select  ccd.ic_code,ir.ic_name FROM  consultants_call_details as ccd left join  `ic_registration` as ir on ir.ic_code=ccd.ic_code where center_type='ic' and ccd.status ='Y' and ir.status ='Y'";
    //exit;
    if($iccode!=''){
        $sql .= 'and ic_code="'.$iccode.'"';
    }
 $sql .= ' group by ccd.ic_code ';

    $query = $this->db->query($sql);
        return $query->result_array();*/
		$co='';
		 if($iccode!=''){
			 
			 $co=' and um.ic_code="'.$iccode.'"';
		 }
		 $role_id=$this->session->userdata("role_id");
		 if($role_id==33){
			 $co=' and um.roles_id=33 ';
		 }
		 
		$sql="select * from (select ium.ic_code,CONCAT(fname,' ',lname) as name,um.um_id,um.employee_code from ic_user_master ium join user_master um on ium.employee_code=um.employee_code 
		where um.status='Y' and ium.status='Y'
		
		$co 
		UNION 
		(select ium.ic_code,contact_person as name,um.um_id,um.employee_code from consultants_call_details ium join user_master um on ium.id=um.con_id
		where um.status='Y' and ium.status='Y' $co   )
		UNION 
		(select '' as ic_code,staff_name as name,um.um_id,'' as employee_code from inhouse_staff_details ium join user_master um on ium.staff_id=um.username and um.roles_id=33
		where um.status='Y' and ium.status='Y' $co   ) ) a order by name
		
		";
	
		$query = $this->db->query($sql);
		
        return $query->result_array();
}

 function get_all_ic_belong_to_consultant_head_wise($status=''){
	 
	$uid = $this->session->userdata('uid'); 
	$ic_code = $this->session->userdata('ic_code');
    $sql = "select ir.ic_code,ir.ic_name FROM  `ic_registration` as ir where 1=1  ";
     $rid = $this->session->userdata('role_id');   
	 if($rid==27){
		 $ss=$this->db->query("select group_concat(ic_code) as ic_code
         from ic_mapping where consultant_head=$uid and status='Y'")->row()->ic_code;

		$ss = explode(",", $ss);
		$ss = "'" . implode("', '", $ss) ."'";
		 $sql .=" and (ir.ic_code IN ($ss))";
	 }
	  if($rid==7){
		  
		   $sql .=" and (ir.ic_code IN ('$ic_code'))";
	  }
	  if(!empty($status)){
		  $sql .=" and ir.status ='$status'";
	  }
   
 $sql .= ' group by ir.ic_code ';

    $query = $this->db->query($sql);
        return $query->result_array();
}

public function get_consultant_details($iccode='')
{
    $this->db->select('ccd.contact_person,um.um_id,ccd.employee_code');
    $this->db->from('consultants_call_details as ccd');
    $this->db->join('user_master as um', 'um.employee_code = ccd.employee_code','left join');
    $this->db->where('ccd.ic_code',$iccode);
    $this->db->where('um.status','Y');
    $this->db->group_by('ccd.employee_code');
    $this->db->order_by('ccd.contact_person', 'ASC');
    $query = $this->db->get();
    $query = $query->result_array();
    //echo $this->db->last_query();exit;
    return $query;

}
function get_call_centerlist($id=''){
	$uid=$this->session->userdata('name');
	$uid1 = $this->session->userdata('uid'); 
	$role_id = $this->session->userdata('role_id');
     $this->db->select('distinct(ic_code),ic_name');
        $this->db->from('ic_registration');
        $this->db->where('status','Y');
		$this->db->where('(center_type = "cc" or center_type = "ic")');
		
        if($id){
			
			if($id=='SU_MH_080' && $uid1=='3414'){
				$ic_array=array('SU_MH_080','SU_BR_124','SU_MH_122','SU_BR_102');			
				$this->db->where_in('ic_code',$ic_array); 
			}
			else{
        $this->db->where('ic_code',$id); 
			}
		
        }
		else if($role_id==27){
		$sql="select * from ic_mapping where consultant_head='2064' and status='Y'";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		foreach($res as $resic){
		$ic_map[] = $resic['ic_code'];
		}
		array_push($ic_map,$id); 
		$this->db->where_in('ic_code',$ic_map); 
		}
		
			 
		
        $query = $this->db->get();
        $res = $query->result_array();
		    //echo $this->db->last_query();exit;

        return $res;
}
function get_student_exam_reg($sid,$ex){
    $sql="select sjr.sujee_id,em.test_type,sjr.student_id,sjr.reg_no,sjr.exam_no,sjr.exam_type,sjr.exam_date,sjr.exam_name,em.exam_name as examname,sjr.exam_center from su_jee_registration  as sjr inner join  exam_master  em  on em.exam_id= sjr.exam_no  where sjr.is_active='Y' and sjr.student_id='".$sid."'  and sjr.exam_name='".$ex."' ";
    $query = $this->db->query($sql);
   return $query->result_array(); 
}

function get_data_of_date($date=""){
	  
	  $sql="SELECT COUNT(sujee_id) as today_count,exam_no FROM su_jee_registration_testseries ";
	  if($date !=''){
		$sql.="WHERE STR_TO_DATE(inserted_at,'%Y-%m-%d')='$date'  GROUP BY exam_no";  
	  }
	  $query = $this->db->query($sql)->result();
	   return  $query;
	  
     
}

function get_data_of_date_city_wise($date="",$tdate=""){
	  
	  /*$sql="SELECT COUNT(sujee_id) as today_count,exam_no FROM su_jee_registration_testseries ";
	  
	  $query = $this->db->query($sql)->result();
	   return  $query;*/
	   
	  $sql="SELECT DISTINCT(city_name) as city_name,city_id FROM su_jee_registration_testseries 

JOIN student_meet_details ON su_jee_registration_testseries.student_id=student_meet_details.id";
 
	  $sql.=" GROUP BY city_name order by city_name ";
	  
	  
	
      $query = $this->db->query($sql)->result();
	   return  $query;
	  
     
}


function get_data_of_date_city_wise_direct($date="",$tdate=""){
	  
	  /*$sql="SELECT COUNT(sujee_id) as today_count,exam_no FROM su_jee_registration_testseries ";
	  
	  $query = $this->db->query($sql)->result();
	   return  $query;*/
	   
	  $sql="SELECT DISTINCT(city_name) as city_name FROM su_jee_registration_testseries 

JOIN student_meet_details ON su_jee_registration_testseries.student_id=student_meet_details.id";
 
	  $sql.=" GROUP BY city_name order by city_name ";
	  
	  
	
      $query = $this->db->query($sql)->result();
	   return  $query;
	  
     
}

function get_data_of_date_city_wise_based_on_exams($date="",$city_name,$tdate=""){
	  
	  $sql="SELECT COUNT(sujee_id) as today_count,exam_no FROM su_jee_registration_testseries JOIN student_meet_details ON su_jee_registration_testseries.student_id=student_meet_details.id ";
	  if($date !=''){
		$sql.=" WHERE STR_TO_DATE(inserted_at,'%Y-%m-%d')>='$date' AND STR_TO_DATE(inserted_at,'%Y-%m-%d')<='$tdate' and city_name='$city_name'  GROUP BY exam_no";  
	  }
	  else{
		  $sql.="WHERE and city_name='$city_name'  GROUP BY exam_no";
	  }
	  $query = $this->db->query($sql)->result();
	   return  $query;
	  
     
}

function get_data_of_date_city_wise_based_on_exams_cumulative_count($date="",$city_name){
	  
	  $sql="SELECT COUNT(sujee_id) as today_count,exam_no FROM su_jee_registration_testseries JOIN student_meet_details ON su_jee_registration_testseries.student_id=student_meet_details.id ";
	  if($date !=''){
		$sql.="WHERE STR_TO_DATE(inserted_at,'%Y-%m-%d') <='$date' and city_name='$city_name'  GROUP BY exam_no";  
	  }
	  else{
		  $sql.="WHERE and city_name='$city_name'  GROUP BY exam_no";
	  }
	  $query = $this->db->query($sql)->result();
	   return  $query;
	  
     
}


function get_data_of_date_city_wise_based_on_exams_appeared($date="",$cityname="",$todate="",$series=""){
	


	  $sql="SELECT COUNT(DISTINCT(sandipun_sujee_exam_admin.exam_result_master_test_series.enrolled_no)) AS count_today,
sandipun_sujee_exam_admin.exam_result_master_test_series.setid 
FROM 
sandipun_sujee_exam_admin.exam_result_master_test_series JOIN  currentdb.su_jee_registration_testseries ON
 currentdb.su_jee_registration_testseries.reg_no=sandipun_sujee_exam_admin.exam_result_master_test_series.enrolled_no
 JOIN  currentdb.student_meet_details
  ON
 currentdb.su_jee_registration_testseries.student_id=currentdb.student_meet_details.id";
	  if($date !='' && $todate !=''){
		$sql.=" WHERE STR_TO_DATE(sandipun_sujee_exam_admin.exam_result_master_test_series.ans_submitted_on,'%Y-%m-%d') >='$date' AND STR_TO_DATE(sandipun_sujee_exam_admin.exam_result_master_test_series.ans_submitted_on,'%Y-%m-%d')<='$todate'  ";  
	  }
	   
	  $sql.=" AND currentdb.student_meet_details.city_name='$cityname' ";
		
		
		if($series !=''){
	  $sql.=" AND sandipun_sujee_exam_admin.exam_result_master_test_series.series_id='$series' ";
		}
	  $sql.='GROUP BY sandipun_sujee_exam_admin.exam_result_master_test_series.setid';
	  $query1 = $this->db->query($sql)->result();
	
	  return ($query1);
	  
     
}

function get_data_of_date_city_wise_based_on_exams_cumulative_count_appeared($date="",$cityname="",$series=""){
	


	  $sql="SELECT COUNT(DISTINCT(sandipun_sujee_exam_admin.exam_result_master_test_series.enrolled_no)) AS count_today,
sandipun_sujee_exam_admin.exam_result_master_test_series.setid 
FROM 
sandipun_sujee_exam_admin.exam_result_master_test_series JOIN  currentdb.su_jee_registration_testseries ON
 currentdb.su_jee_registration_testseries.reg_no=sandipun_sujee_exam_admin.exam_result_master_test_series.enrolled_no
 JOIN  currentdb.student_meet_details
  ON
 currentdb.su_jee_registration_testseries.student_id=currentdb.student_meet_details.id";
	  if($date !='' ){
		$sql.=" WHERE STR_TO_DATE(sandipun_sujee_exam_admin.exam_result_master_test_series.ans_submitted_on,'%Y-%m-%d') <='$date '";  
	  }
	    
	  $sql.=" AND currentdb.student_meet_details.city_name='$cityname' ";
		
		if($series !=''){
	  $sql.=" AND sandipun_sujee_exam_admin.exam_result_master_test_series.series_id='$series' ";
		}
	  $sql.='GROUP BY sandipun_sujee_exam_admin.exam_result_master_test_series.setid';
	  $query1 = $this->db->query($sql)->result();
	
	  return ($query1);
	  
     
}


function get_data_of_date_of_appeared($date="",$id=""){
	


	  $sql="SELECT COUNT(DISTINCT(sandipun_sujee_exam_admin.exam_result_master_test_series.enrolled_no)) AS count_today,
sandipun_sujee_exam_admin.exam_result_master_test_series.setid 
FROM 
sandipun_sujee_exam_admin.exam_result_master_test_series ";
	  if($date !=''){
		$sql.="WHERE STR_TO_DATE(sandipun_sujee_exam_admin.exam_result_master_test_series.ans_submitted_on,'%Y-%m-%d')='$date'  GROUP BY sandipun_sujee_exam_admin.exam_result_master_test_series.setid";  
	  }
	  $query1 = $this->db->query($sql)->result();
	
	  return ($query1);
	  
     
}

function get_data_of_date_cumulative_count($date=""){

 $sql1="SELECT COUNT(sujee_id) as cumulative_count,exam_no FROM su_jee_registration_testseries  ";
	  if($date !=''){
		$sql1.="WHERE STR_TO_DATE(inserted_at,'%Y-%m-%d')<='$date'  GROUP BY exam_no";  
	  }
	  $query1 = $this->db->query($sql1)->result();
	  
	  return ($query1);
}

function get_data_of_date_cumulative_count_of_appeared($date=""){

 $sql="SELECT COUNT(DISTINCT(sandipun_sujee_exam_admin.exam_result_master_test_series.enrolled_no)) AS cummulative,
sandipun_sujee_exam_admin.exam_result_master_test_series.setid 
FROM 
sandipun_sujee_exam_admin.exam_result_master_test_series ";
	  if($date !=''){
		$sql.="WHERE STR_TO_DATE(sandipun_sujee_exam_admin.exam_result_master_test_series.ans_submitted_on,'%Y-%m-%d')<='$date'  GROUP BY sandipun_sujee_exam_admin.exam_result_master_test_series.setid";  
	  }
	  $query1 = $this->db->query($sql)->result();
	  
	  return ($query1);
}




function distinct_series(){


 $sql1="SELECT  DISTINCT(sandipun_sujee_exam_admin.testseriesmapping.id) AS id,sandipun_sujee_exam_admin.testseriesmapping.series_name FROM sandipun_sujee_exam_admin.exam_result_master_test_series 
JOIN sandipun_sujee_exam_admin.testseriesmapping ON sandipun_sujee_exam_admin.testseriesmapping.id=sandipun_sujee_exam_admin.exam_result_master_test_series.series_id"; 
$query1 = $this->db->query($sql1)->result();
	  return ($query1);
}


function get_organisation_type(){


 $sql1="SELECT  * from organisation_type"; 
$query1 = $this->db->query($sql1)->result();
	  return ($query1);
}

function get_academic_year(){

$DB1=$this->load->database('icdb',TRUE);
 $sql1="SELECT  * from academic_year where status='Y' order by id desc"; 

$query1 = $DB1->query($sql1)->result();
	  return ($query1);
}

function get_academic_year_for_institutes(){


 $sql1="SELECT  * from academic_year  order by id desc"; 
$query1 = $this->db->query($sql1)->result();
	  return ($query1);
}


function get_data_of_date_city_wise_based_on_exams_direct($date="",$tdate="",$exam_no=''){
	  
	  $sql="SELECT COUNT(sujee_id) as today_count,exam_no,city_id FROM su_jee_registration_testseries JOIN student_meet_details ON su_jee_registration_testseries.student_id=student_meet_details.id ";
	  if($date !=''){
		$sql.=" WHERE STR_TO_DATE(inserted_at,'%Y-%m-%d')>='$date' AND STR_TO_DATE(inserted_at,'%Y-%m-%d')<='$tdate' and exam_no=$exam_no   GROUP BY exam_no,city_id";  
	  }
	  else{
		  $sql.="WHERE  exam_no=$exam_no   GROUP BY exam_no,city_id";
	  }
	  
	    
	  $query = $this->db->query($sql)->result();
	   return  $query;
	  
     
}

function get_data_of_date_city_wise_based_on_exams_cumulative_count_direct($date="",$exam_no=''){
	  
	  $sql="SELECT COUNT(sujee_id) as today_count,exam_no,city_id FROM su_jee_registration_testseries JOIN student_meet_details ON su_jee_registration_testseries.student_id=student_meet_details.id ";
	  if($date !=''){
		$sql.="WHERE STR_TO_DATE(inserted_at,'%Y-%m-%d') <='$date' and exam_no=$exam_no   GROUP BY exam_no,city_id";  
	  }
	  else{
		  $sql.="WHERE  exam_no=$exam_no   GROUP BY exam_no,city_id";
	  }
	  $query = $this->db->query($sql)->result();
	   return  $query;
	  
     
}

function get_data_of_date_city_wise_based_on_exams_appeared_direct($date="",$todate="",$series="",$exam_no=''){
	


	  $sql="SELECT COUNT(DISTINCT(sandipun_sujee_exam_admin.exam_result_master_test_series.enrolled_no)) AS count_today,currentdb.student_meet_details.city_id,
sandipun_sujee_exam_admin.exam_result_master_test_series.setid 
FROM 
sandipun_sujee_exam_admin.exam_result_master_test_series JOIN  currentdb.su_jee_registration_testseries ON
 currentdb.su_jee_registration_testseries.reg_no=sandipun_sujee_exam_admin.exam_result_master_test_series.enrolled_no
 JOIN  currentdb.student_meet_details
  ON
 currentdb.su_jee_registration_testseries.student_id=currentdb.student_meet_details.id";
 $sql.=" where  currentdb.su_jee_registration_testseries.exam_no=$exam_no";
	  if($date !='' && $todate !=''){
		$sql.=" AND STR_TO_DATE(sandipun_sujee_exam_admin.exam_result_master_test_series.ans_submitted_on,'%Y-%m-%d') >='$date' AND STR_TO_DATE(sandipun_sujee_exam_admin.exam_result_master_test_series.ans_submitted_on,'%Y-%m-%d')<='$todate'";  
	  }
	   
	  
		
		
		if($series !=''){
	  $sql.=" AND sandipun_sujee_exam_admin.exam_result_master_test_series.series_id='$series' ";
		}
	  $sql.='GROUP BY currentdb.student_meet_details.city_id,sandipun_sujee_exam_admin.exam_result_master_test_series.setid';
	  $query1 = $this->db->query($sql)->result();
	
	  return ($query1);
	  
     
}

function get_data_of_date_city_wise_based_on_exams_cumulative_count_appeared_direct($date="",$series="",$exam_no=''){
	


	  $sql="SELECT COUNT(DISTINCT(sandipun_sujee_exam_admin.exam_result_master_test_series.enrolled_no)) AS count_today,currentdb.student_meet_details.city_id,
sandipun_sujee_exam_admin.exam_result_master_test_series.setid 
FROM 
sandipun_sujee_exam_admin.exam_result_master_test_series JOIN  currentdb.su_jee_registration_testseries ON
 currentdb.su_jee_registration_testseries.reg_no=sandipun_sujee_exam_admin.exam_result_master_test_series.enrolled_no
 JOIN  currentdb.student_meet_details
  ON
 currentdb.su_jee_registration_testseries.student_id=currentdb.student_meet_details.id";
 $sql.=" where  currentdb.su_jee_registration_testseries.exam_no=$exam_no";
	  if($date !='' ){
		$sql.=" AND STR_TO_DATE(sandipun_sujee_exam_admin.exam_result_master_test_series.ans_submitted_on,'%Y-%m-%d') <='$date '";  
	  }
	    
	  
		
		if($series !=''){
	  $sql.=" AND sandipun_sujee_exam_admin.exam_result_master_test_series.series_id='$series' ";
		}
	  $sql.='GROUP BY currentdb.student_meet_details.city_id,sandipun_sujee_exam_admin.exam_result_master_test_series.setid';
	  $query1 = $this->db->query($sql)->result();
	
	  return ($query1);
	  
     
}

function get_all_consultants(){
    $sql = "select  ir.ic_code,ir.ic_name FROM    `ic_registration` as ir  where ir.center_type='ic'  and ir.status ='Y'";

 $sql .= ' group by ir.ic_code ';

    $query = $this->db->query($sql);
        return $query->result_array();
}


  function chek_mob_exist_web($mobile_no,$event_code){
         $sql="SELECT id FROM webiner_student_meet_details where mobile1 = '".$mobile_no."' and event_code='$event_code'  limit 0,1";
    //echo $sql;exit();
       $query = $this->db->query($sql);
        return $query->result_array();  
    }  
     function chek_mob_exist_update_web($mobile_no,$id,$event_code){
         $sql="SELECT * FROM webiner_student_meet_details where id !='".$id."' and mobile1 = '".$mobile_no."'  and event_code='$event_code' limit 0,1 ";
    //echo $sql;exit();
       $query = $this->db->query($sql);
       //echo $this->db->last_query();exit;
        return $query->result_array();  
    }


 function get_all_ic_belong_to_consultant_head_wise_ic_cc($type=''){
	 
	$uid = $this->session->userdata('uid'); 
	$ic_code = $this->session->userdata('ic_code'); 
	$whr='';
	if(!empty($type)){
		
		if($type==1){
		$whr=" and ir.center_type='ic'";
		}
        elseif($type==2){
		$whr=" and ir.center_type='cc'";
		}			
	}
    $sql = "select ir.ic_code,ir.ic_name FROM  `ic_registration` as ir where ir .status='Y'  $whr ";
     $rid = $this->session->userdata('role_id');   
	 if($rid==27){
		 $ss=$this->db->query("select group_concat(ic_code) as ic_code
         from ic_mapping where consultant_head=$uid and status='Y'")->row()->ic_code;

		$ss = explode(",", $ss);
		$ss = "'" . implode("', '", $ss) ."'";
		 $sql .=" and (ir.ic_code IN ($ss))";
	 }
	  elseif($rid==7){
		 $sql .=" and ir.ic_code ='$ic_code'";
	 }
   
 $sql .= ' group by ir.ic_code ';

    $query = $this->db->query($sql);
        return $query->result_array();
}
	
	
	
	function get_bank_details()
    {
		$this->db->select('*');
		$this->db->from('bank_master');
		$this->db->order_by('bank_name');
		$query=$this->db->get();
        return $query->result_array();
    }
	function get_payroll_details()
    {
		$this->db->select('*');
		$this->db->from('payroll_details');
		$this->db->where('status','Y');
		$this->db->order_by('payroll');
		$query=$this->db->get();
        return $query->result_array();
    }

   function get_campus_master($status='',$is_display=''){
        
        $this->db->select('*');
		$this->db->from('campus_master');
		if(!empty($status)){
		$this->db->where('status',$status);
		}
		if(!empty($is_display)){
		$this->db->where('is_display',$is_display);
		}
		$query=$this->db->get();
        return $query->result();
    }
	
	function get_cet_score()
    {
        $this->db->select('*');
        $this->db->from('cet_score_types'); 
        $this->db->where("status = 'Y'");
       // $this->db->order_by('order_no', 'ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;       
    }
	function get_interested_leads_types($type='')
    {
        $this->db->select('*');
        $this->db->from('interested_leads_subtypes');
        $this->db->where("status = 'Y'");
        $this->db->where('type',$type);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;       
    }
   
   
   
   function get_streams($academic_year='',$campus='')
    {
		$this->db->select('vw.school_short_name, vw.school_id, vw.course_short_name, vw.stream_name, vw.stream_id, dt.lead_target, dt.admission_target');
		$this->db->from('su_sf_sijoul_stream_details vw');
		$this->db->join('digital_target_year_wise dt', "vw.stream_id = dt.stream_id AND vw.belongtocampus = dt.campus AND dt.academic_year = '$academic_year'", 'left');
		$this->db->where('vw.active_for_year', $academic_year);
		$this->db->where('vw.belongtocampus',$campus);
		$this->db->order_by("vw.school_id");
		$query = $this->db->get();
		return $query->result();

    }
	
	function get_streams_week_wise($academic_year='',$campus='',$from='',$to='')
    { $c='';
		if(!empty($from)){
			$c.=' and dt.from_date ="'.$from.'"';
		}
		if(!empty($to)){
			$c.=' and dt.to_date ="'.$to.'"';
		}
		
		$this->db->select('vw.school_short_name, vw.school_id, vw.course_short_name, vw.stream_name, vw.stream_id, dt.lead_target, dt.admission_target');
		$this->db->from('su_sf_sijoul_stream_details vw');
		$this->db->join('digital_target_year_wise_week_wise dt', "vw.stream_id = dt.stream_id AND vw.belongtocampus = dt.campus AND dt.academic_year = '$academic_year' $c", 'left');
		$this->db->where('vw.active_for_year', $academic_year);
		$this->db->where('vw.belongtocampus',$campus);
		$this->db->order_by("vw.school_id");
		$query = $this->db->get();
		return $query->result();

    }

}
?>