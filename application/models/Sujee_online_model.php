<?php
class Sujee_online_model extends CI_Model{
   
    var $table = 'apply_studnet';
	var $column_order = array(null, 'sid','name','email','mobile','apply_date'); //set column field database for datatable orderable
	var $column_search = array('sid','name','email','mobile','apply_date'); //set column field database for datatable searchable 
	var $order = array('payment_date' => 'DESC'); // default order 
	
	function __construct()
	{
		parent::__construct();
		//$DBU=$this->load->database('umsdb', TRUE);
		//$this->load->database();
		$this->load->model('Challan_model');
	}
	
	public function get_facility_types()
	{   $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from("sf_facility_types");
		$DB1->where('status', 'Y');
		$query = $DB1->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	/*public function generateprovisional($student_id='')
	{     //$DB = $this->load->database('umsdb', TRUE);
		    $finalprn='';
			$DB1 = $this->load->database('umsdb', TRUE); 
			$student_data=$DB1->get_where('student_master',array('stud_id'=>$student_id))->row();
			
			if(!empty($student_data)){
			$stream_id=$student_data->admission_stream;
			$academic_year=$student_data->academic_year;
			$admission_year=$student_data->admission_session;
		
			$stmdet = $DB1->query("select * from student_master where academic_year=$academic_year and admission_session=$admission_year and enrollment_no_new IS NOT NULL and enrollment_no_new  !='' order by enrollment_no_new desc LIMIT 1")->row();
			
			
			if(!empty($stmdet)){
			
			$auto =$stmdet->enrollment_no_new;	
			}
			else{
			$auto =substr($student_data->academic_year, -2)."SUS0000";
			}
			
			$var1 = substr($auto, -4);
			$var1 = ++$var1;
			$prn =  sprintf("%04d", $var1);
			$finalprn  =substr($student_data->academic_year, -2)."SUS".$prn;
			$DB1->update('student_master',array('enrollment_no_new'=>$finalprn,'enrollment_no'=>$finalprn),array('stud_id'=>$student_id));		
			}
		  return $finalprn;
	}*/
	
	
	
	public function get_academic_details()
	{$DB1 = $this->load->database('umsdb', TRUE);
		$sql="select * From sf_academic_year";
		$query = $DB1->query($sql);
		return  $query->result_array();
	}
	public function get_depositedto()
	{  
	    //$DB1 = $this->load->database('erpdb', TRUE);
		
		$this->db->select("*");
		
		$this->db->from("bank_master");
		$this->db->where('status','Y');
		//$this->db->where('account_for',$data['faci_type']);
		$query =$this->db->get();
	//echo $this->db->last_query();exit();
		return $query->result_array();
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
	
	
	function chek_mob_exist($mobile_no,$Enquiry_search){
      $DBU = $this->load->database('umsdb', TRUE);
	  if(empty($Enquiry_search)){
     $sql="select * FROM enquiry_student_master WHERE status='Y' AND admission_session='2021'  AND (mobile='$mobile_no' OR altarnet_mobile='$mobile_no')";
	  }else{
	  $sql="select * FROM enquiry_student_master WHERE status='Y' AND admission_session='2021' AND enquiry_no='$Enquiry_search'";	  
	  }
      $query = $DBU->query($sql);
    //$query = $this->db->get();
    $result = $query->result_array();
  //echo $DBU->last_query();exit;
    return $result;
  }  
	
	function fetch_states(){
	    $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT * from states order by state_name";
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	
	public function getStatewiseDistrict($stateid) {
	    $DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "select district_id, district_name from district_name where state_id='$stateid' order by district_name";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        //echo $DB1->last_query();
        return $res;
    }
	public function getStateDwiseCity($stateid,$district_id) {
	    $DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "select taluka_id, taluka_name from taluka_master where state_id='$stateid' and district_id='$district_id' order by taluka_name";
        $query = $DB1->query($sql);
        $res = $query->result_array();
        //echo $DB1->last_query();
        return $res;
    }  
	function list_schools_data($id)
    {
		

	/*sandipun_univerdb.`school_programs_new`.`min_qualification`='$id'*/
	
	if($id='PG'){
	$id='UG';	
	}
	$data=$this->db->query("SELECT sandipun_ums_sijoul.vw_stream_details.* FROM 
	sandipun_univerdb.`school_programs_new` 
	JOIN  sandipun_ums_sijoul.`vw_stream_details`
	ON sandipun_univerdb.`school_programs_new`.`ums_id`=sandipun_ums_sijoul.vw_stream_details.stream_id 
	WHERE FIND_IN_SET ('$id', sandipun_univerdb.school_programs_new.min_qualification)
	GROUP BY sandipun_ums_sijoul.`vw_stream_details`.school_id")->result_array();
	
	return $data;
    }
	 function getschool_course($school='',$hq=''){
         $DB1 = $this->load->database('umsdb', TRUE); 
		 $sql="SELECT DISTINCT(sandipun_ums_sijoul.vw_stream_details.course_id),sandipun_ums_sijoul.vw_stream_details.course_name,sandipun_ums_sijoul.vw_stream_details.course_short_name FROM sandipun_ums_sijoul.vw_stream_details
		 join sandipun_univerdb.school_programs_new
         ON sandipun_univerdb.`school_programs_new`.`ums_id`=sandipun_ums_sijoul.vw_stream_details.stream_id WHERE FIND_IN_SET ('$hq', sandipun_univerdb.school_programs_new.min_qualification) ";
		 
			if($school !='')
			{
				$sql .=" and sandipun_ums_sijoul.vw_stream_details.school_id = $school"; 
			}
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	
	 function  get_course_streams_yearwise()
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        
        $DB1->select("vd.stream_id,vd.stream_name,vd.stream_short_name");
		$DB1->from('vw_stream_details vd');
		$DB1->join('academic_fees as af','af.stream_id = vd.stream_id','left');
		$DB1->where("vd.course_id", $_POST['course']);
		$DB1->where("vd.school_id", $_POST['school_id']);
		$DB1->group_by("vd.stream_id");
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->where("af.academic_year", '2021-22');
		
		
		//	$DB1->where("certificate_name", $certtype);
		$query=$DB1->get();
		//echo $DB1->last_query();
           $stream_details =  $query->result_array();
        
        $schoola=$_POST['schoola']; 
        
        
       echo '<option value="">Select Stream</option>';									
		foreach($stream_details as $course){
		if($course['stream_id']==$schoola){
				$sel='selected';
			}else{
		$sel='';
			}
			echo '<option value="'.$course['stream_id'].'" '.$sel.'>'.$course['stream_name'].'</option>';
		} 
	
	}
	
	
	 function fetch_academic_fees_for_stream_year($strm_id,$acyear,$year8=''){
      //   echo $acyear;
      $acy =  substr($acyear,-2);
      $ny = $acy+1;
      $year = $acyear."-".$ny;
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('academic_fees');
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
	
	
	
	 //check mobile
    function chek_formno_exist($formno){
    $this->db->select('adm_form_no'); 
    $this->db->from('provisional_admission_details');
    $this->db->where('adm_form_no', $formno);
    $query = $this->db->get();
    $result = $query->result_array();
    ///echo $this->db->last_query();//exit;
    return $result;
  } 

    function chek_formno_exist_withapprove($formno){
		$DB1 = $this->load->database('umsdb', TRUE);
		$formno=trim($formno);
    $this->db->select('pros_serial_no'); 
    $this->db->from('material_distribution_details');
    $this->db->where('pros_serial_no', $formno);
    $this->db->where('status', '1');
    $query = $this->db->get();
    $result = $query->result_array();
   // echo $this->db->last_query();exit;
	//print_r($result);
    return $result;
  }
   //check serial no
    function chek_duplicate_serial_no($serial_no){
    $this->db->select('pros_serial_no'); 
    $this->db->from('material_distribution_details');
    $this->db->where('pros_serial_no', $serial_no);
    $query = $this->db->get();
    $result = $query->result_array();
    ///echo $this->db->last_query();//exit;
    return $result;
  }
	
	function get_schollership_by_id($id){
		$DB=$this->load->database('umsdb',TRUE);
	$DB->select('type,schlorship_name'); 
    $DB->from('schlorship_type');
    $DB->where('s_id', $id);
    $query = $DB->get();
    $result = $query->result_array();
    ///echo $this->db->last_query();//exit;
    return $result;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function Enquiry_insert($values){
	/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

	function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function Enquiry_no($DB1){
	
	//$num = 1;
    //printf("%04d", $num);
	//print_r($DB1);
	//$DB=$this->load->database('umsdb',TRUE);
   $DB1->select('enquiry_id');
   $DB1->from('enquiry_student_master');
   $DB1->order_by('enquiry_id','DESC');
   $DB1->limit('1');
   $query = $DB1->get();
    $result = $query->result_array();
    return $result[0]['enquiry_id'];
}

	$DB=$this->load->database('umsdb',TRUE);
	//print_r($values);
	 $Enquiry_no=Enquiry_no($DB);
	//printf("%04d", $Enquiry_no);
	 $num_str = sprintf("%06d", $Enquiry_no);
	//exit();
	$updated_by =$this->session->userdata('uid');
	$ic_code = $this->session->userdata('ic_code');
	
	$enquiry_newno='21ENQ'.$num_str;
	
	
	$Enquiry['enquiry_no']=$enquiry_newno;
	
	$Enquiry['first_name']=strtoupper($values['first_name']);
	$Enquiry['middle_name']=strtoupper($values['middle_name']);
	$Enquiry['last_name']=strtoupper($values['last_name']);
	$Enquiry['email_id']=($values['email_id']);
	$Enquiry['mobile']=$values['mobile'];
	
	$Enquiry['altarnet_mobile']=$values['altarnet_mobile'];
	
	$Enquiry['state_id']=$values['state_id'];
	//$Enquiry['state_name']=$values['state_name'];
	$Enquiry['district_id']=$values['district_id'];
	//$Enquiry['district_name']=$values['district_name'];
	$Enquiry['city_id']=$values['city_id'];
	//$Enquiry['city_name']=$values['city_name'];
	/////////////////////////////////////////////////////////////////////////////////////////////
	$Enquiry['pincode']=$values['pincode'];
	$Enquiry['admission_type']=$values['admission_type'];
	$Enquiry['gender']=$values['gender'];
	$Enquiry['aadhar_card']=$values['aadhar_card'];
	$Enquiry['category']=$values['category'];
	$Enquiry['last_qualification']=$values['last_qualification'];
	$Enquiry['qualification_percentage']=$values['qualification_percentage'];
	$Enquiry['school_id']=$values['school_id'];
//	$Enquiry['school_name']=$values['school_name'];
	$Enquiry['course_id']=$values['course_id'];
//	$Enquiry['course_name']=$values['course_name'];
	$Enquiry['stream_id']=$values['stream_id'];
//	$Enquiry['stream_name']=$values['stream_name'];
	/////////////////////////////////////////////////////////////////////////////////////////////
	$Enquiry['actual_fee']=$values['actual_fee'];
	$Enquiry['tution_fees']=$values['tution_fees'];
	$Enquiry['form_taken']=$values['form_taken'];
	$Enquiry['form_no']=$values['form_no'];
	$Enquiry['form_amount']=$values['form_amount'];
	$Enquiry['payment_mode']=$values['payment_mode'];
	$Enquiry['payment_date']=date('Y-m-d');
	$Enquiry['recepit_no']=$values['TransactionNo'];
   //////////////////////////////////////////////////////////////////

	$Enquiry['scholarship_allowed']=$values['scholarship_allowed'];
	$Enquiry['other_scholarship']=$values['Other_Scholarship_selected'];
	$Enquiry['sports_scholarship']=$values['Sports_Scholarship_selecet'];
	$Enquiry['merit_state']=$values['Scholarship_state'];
	$Enquiry['merit_scholarship']=$values['Merit_Scholarship_selected'];
	//////////////////////////////////////////////////////////////////////////////////
	$scholarship_id='';
	if($values['Other_Scholarship_selected']==23){}else{
		$scholarship_id=$values['Other_Scholarship_selected'];
	}
	if($values['Sports_Scholarship_selecet']==24){}else{
       $scholarship_id=$values['Sports_Scholarship_selecet'];
	}
	if(($values['Merit_Scholarship_selected']==25)||($values['Merit_Scholarship_selected']==26)){
	   // $scholarship_id=$values['Merit_Scholarship_selected'];
	}else{
		$scholarship_id=$values['Merit_Scholarship_selected'];
	}
	
	
	$Enquiry['scholarship_id']=$scholarship_id;
	$scholar_name=$this->get_schollership_by_id($scholarship_id);
	$Enquiry['scholarship_type']=$scholar_name[0]['type'];
	$Enquiry['scholarship_name']=$scholar_name[0]['schlorship_name'];
	//////////////////////////////////////////////////////////////////////////////////
	$Enquiry['scholarship_amount']=$values['Scholarship_Amount'];
	$Enquiry['without_scholarship']=$values['mpfees'];
	$Enquiry['with_scholarship']=$values['Paid'];
	if($values['scholarship_allowed']=="Y"){
	$Enquiry['scholarship_status']='Pending';
	}
	////////////////////////////////////////////////////////////////////////////////////
	$Enquiry['hostel_allowed']=$values['hostel_allowed'];
	//////////////////////////////////////////////////////////////////
	$Enquiry['academic_year']=2021;
	$Enquiry['current_year']=$values['admission_type'];
	$Enquiry['admission_session']=2021;
	$Enquiry['admission_year']=2021;
	/////////////////////////////////////////////////////////
	$Enquiry['date_enter']=date('Y-m-d');
	$Enquiry['academic_year']=date('Y');
	$Enquiry['ic_code']=$ic_code;
	$Enquiry['created_on']=date('Y-m-d h:i:s');
	$Enquiry['created_by']=$updated_by;
	$Enquiry['updated_on']='';
	$Enquiry['updated_by']=$updated_by;
	$Enquiry['ip_address']=getUserIpAddr();
	$Enquiry['enquiry_status']='enquiry';
	
	///print_r($Enquiry);
	//exit();
	$this->db->trans_begin(); 
	$result=$DB->insert('enquiry_student_master',$Enquiry);
	
	//print_r($result);
	//exit();
	$this->db->trans_complete();
	 if ($this->db->trans_status() === FALSE){
    $this->db->trans_rollback();
	$enquiry_id=$this->db->insert_id();
   return $enquiry_id.'/'.$enquiry_newno;
    }else{
  $this->db->trans_commit();
   $enquiry_id=$this->db->insert_id();
   return $enquiry_id.'/'.$enquiry_newno;//$this->db->insert_id();
  }
	/*if($result)
	{
		echo '1';
	}else{
		echo '2';
	}*/
	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function Enquiry_Updated($values){
	function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function Enquiry_no($DB1){
	//$num = 1;
    //printf("%04d", $num);
	//print_r($DB1);
	//$DB=$this->load->database('umsdb',TRUE);
   $DB1->select('enquiry_id');
   $DB1->from('enquiry_student_master');
   $DB1->order_by('enquiry_id','DESC');
   $DB1->limit('0','1');
   $query = $DB1->get();
    $result = $query->result_array();
    return $result[0]['enquiry_id'];
}

	$DB=$this->load->database('umsdb',TRUE);
	//print_r($values);
	//$Enquiry_no=Enquiry_no($DB);
	//printf("%04d", $Enquiry_no);
	 //$num_str = sprintf("%06d", $Enquiry_no);
	//exit();
	$updated_by =$this->session->userdata('uid');
	$ic_code = $this->session->userdata('ic_code');
	
	//$Enquiry['enquiry_no']='20ENQ'.$num_str;
	$enquiry_id=trim($values['enquiry_id']);
	$Enquiry['first_name']=strtoupper($values['first_name']);
	$Enquiry['middle_name']=strtoupper($values['middle_name']);
	$Enquiry['last_name']=strtoupper($values['last_name']);
	$Enquiry['email_id']=($values['email_id']);
	$Enquiry['mobile']=$values['mobile'];
	$Enquiry['altarnet_mobile']=$values['altarnet_mobile'];
	$Enquiry['state_id']=$values['state_id'];
	//$Enquiry['state_name']=$values['state_name'];
	$Enquiry['district_id']=$values['district_id'];
	//$Enquiry['district_name']=$values['district_name'];
	$Enquiry['city_id']=$values['city_id'];
	//$Enquiry['city_name']=$values['city_name'];
	/////////////////////////////////////////////////////////////////////////////////////////////
	$Enquiry['pincode']=$values['pincode'];
	$Enquiry['admission_type']=$values['admission_type'];
	$Enquiry['gender']=$values['gender'];
	$Enquiry['aadhar_card']=$values['aadhar_card'];
	$Enquiry['category']=$values['category'];
	$Enquiry['last_qualification']=$values['last_qualification'];
	$Enquiry['qualification_percentage']=$values['qualification_percentage'];
	$Enquiry['school_id']=$values['school_id'];
//	$Enquiry['school_name']=$values['school_name'];
	$Enquiry['course_id']=$values['course_id'];
//	$Enquiry['course_name']=$values['course_name'];
	$Enquiry['stream_id']=$values['stream_id'];
//	$Enquiry['stream_name']=$values['stream_name'];
	/////////////////////////////////////////////////////////////////////////////////////////////
	$Enquiry['actual_fee']=$values['actual_fee'];
	$Enquiry['tution_fees']=$values['tution_fees'];
	$Enquiry['form_taken']=$values['form_taken'];
	$Enquiry['form_no']=$values['form_no'];
	$Enquiry['form_amount']=$values['form_amount'];
	$Enquiry['payment_mode']=$values['payment_mode'];
	$Enquiry['payment_date']=date('Y-m-d');
	$Enquiry['recepit_no']=$values['TransactionNo'];
   //////////////////////////////////////////////////////////////////

	$Enquiry['scholarship_allowed']=$values['scholarship_allowed'];
	
	$Enquiry['other_scholarship']=$values['Other_Scholarship_selected'];
	$Enquiry['sports_scholarship']=$values['Sports_Scholarship_selecet'];
	$Enquiry['merit_scholarship']=$values['Merit_Scholarship_selected'];
	
	 $values['Other_Scholarship_selected'];
	$scholarship_id='';
	
	if(!empty($values['Other_Scholarship_selected'])){
	if($values['Other_Scholarship_selected']==23){}else{
		$scholarship_id=$values['Other_Scholarship_selected'];
	}
	}
	if(!empty($values['Sports_Scholarship_selecet'])){
	if($values['Sports_Scholarship_selecet']==24){}else{
       $scholarship_id=$values['Sports_Scholarship_selecet'];
	}
	}
	if(!empty($values['Merit_Scholarship_selected'])){
	if(($values['Merit_Scholarship_selected']==25)||($values['Merit_Scholarship_selected']==26)){
	   // $scholarship_id=$values['Merit_Scholarship_selected'];
	}else{
		$scholarship_id=$values['Merit_Scholarship_selected'];
	}
	}
	//echo $scholarship_id;// $values['Merit_Scholarship_selected'].'--'.$scholarship_id;
	//exit();
	
	$Enquiry['scholarship_id']=$scholarship_id;
	//echo $scholarship_id;
	$scholar_name=$this->get_schollership_by_id($scholarship_id);
	//print_r($scholar_name);exit;
	$Enquiry['scholarship_type']=$scholar_name[0]['type'];
	$Enquiry['scholarship_name']=$scholar_name[0]['schlorship_name'];
	
	
	$Enquiry['scholarship_amount']=$values['scholarship_amount'];
	$Enquiry['without_scholarship']=$values['without_scholarship'];
	$Enquiry['with_scholarship']=$values['with_scholarship'];
	
	$Enquiry['scholarship_status']=$values['scholarship_status'];
	//////////////////////////////////////////////////////////////////
	$Enquiry['academic_year']=date('Y');
	
	//////////////////////////////////////////////////////////////////
	//$Enquiry['academic_year']=2020;
	$Enquiry['current_year']=$values['admission_type'];
	$Enquiry['admission_session']=2021;
	$Enquiry['admission_year']=2021;
	/////////////////////////////////////////////////////////
	$Enquiry['ic_code']=$ic_code;
	//$Enquiry['created_on']=date('Y-m-d h:i:s');
	//$Enquiry['created_by']=$updated_by;
	$Enquiry['updated_on']='';
	$Enquiry['updated_by']=$updated_by;
	$Enquiry['ip_address']=getUserIpAddr();
	
	$this->db->trans_begin(); 
	
	$DB->where('enquiry_id', $enquiry_id);
	
  //  print_r($Enquiry);
//	exit();
	
	$result=$DB->update('enquiry_student_master',$Enquiry);
	$this->db->trans_complete();
	 if ($this->db->trans_status() === FALSE){
    $this->db->trans_rollback();
    return $enquiry_id.'/'.$values['enquiry_no'];
  }else{
   $this->db->trans_commit();
    return $enquiry_id.'/'.$values['enquiry_no'];
  }
	/*if($result)
	{
		echo '1';
	}else{
		echo '2';
	}*/
	
}
	
	
	private function _Enquiry_list($DB){
		//$DB=$this->load->database('umsdb',TRUE);
	//	print_r($DB);
		//add custom filter here
		/*if($this->input->post('country'))
		{
			$this->db->where('country', $this->input->post('country'));
		}
		if($this->input->post('FirstName'))
		{
			$this->db->like('FirstName', $this->input->post('FirstName'));
		}
		if($this->input->post('LastName'))
		{
			$this->db->like('LastName', $this->input->post('LastName'));
		}
		if($this->input->post('address'))
		{
			$this->db->like('address', $this->input->post('address'));
		}*/

//echo $this->table;
        $DB->select('vw.stream_name as vstream_name,eq.*');
		$DB->from('enquiry_student_master as eq');
		$DB->join('vw_stream_details as vw','vw.stream_id=eq.stream_id','left');
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$DB->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$DB->like($item, $_POST['search']['value']);
				}
				else
				{
					$DB->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$DB->group_end(); //close bracket
			}
			$i++;
		}
		
		
		if(isset($_POST['order'])) // here order processing
		{
			$DB->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$DB->order_by(key($order), $order[key($order)]);
		}
	}
	
	public function get_datatables($date='',$type_param='',$cyear='')
	{  
	
	    $DB1=$this->load->database('umsdb',TRUE);
		$this->_Enquiry_list1($DB1,$date,$type_param,$cyear);
		//$this->_Enquiry_list($DB1);
		if($_POST['length'] != -1)
		$DB1->limit($_POST['length'], $_POST['start']);
		$query = $DB1->get();
		//echo $DB1->last_query();
		//exit;
		return $query->result();
	}
	
	private function _Enquiry_list1($DB,$date='',$type_param='',$cyear=''){
		
		
		
		
        $DB->select('fc.exam_session,ope.payment_id,ope.productinfo,`ope`.*');
		$DB->from('`sandipun_ic_erp22`.`online_payment` as ope');
		$DB->join('`sandipun_ic_erp22`.`su_jee_registration` as aas','ope.student_id=aas.student_id','left');
		$DB->join('`sandipun_ums`.`fees_challan` as fc','fc.TransactionNo=ope.txtid AND fc.challan_status!="CL"','left');
		//$DB->join('vw_stream_details as vw','vw.stream_id=bcd.Course','left');
		//$DB->join('sandipun_ic_erp20.consultants_call_details as ccd','ccd.id=bcd.consultant AND bcd.consultant!=0','left');
		//$DB->join('sandipun_erp_sijoul.city_master as cm','cm.city_id=bcd.drcc_city','left');
		//$DB->join('sandipun_erp_sijoul.city_master as cmm','cmm.city_id=bcd.District','left');
		//if($date !=''){
	//	$DB->where("STR_TO_DATE(eq.created_on,'%Y-%m-%d') ='$date'");
		//}
		
		//if($type_param !=''){
			/*if($type_param==1){
					$DB->where("eq.form_taken='Y'");
				
			}else if($type_param==2){
					$DB->where("eq.provisional_no !='-'  and eq.provisional_no IS NOT NULL");
				
			}*/
		
		//}
		$DB->where("aas.is_payment_done='Y'");	
		$DB->where("ope.payment_status='success'");	
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$DB->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$DB->like($item, $_POST['search']['value']);
				}
				else
				{
					$DB->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$DB->group_end(); //close bracket
			}
			$i++;
		}
		
		
		if(isset($_POST['order'])) // here order processing
		{
			$DB->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$DB->order_by(key($order), $order[key($order)]);
		}
	}
	
	
	

	public function count_filtered($date='',$type_param='',$cyear='')
	{   $DB2=$this->load->database('umsdb',TRUE);
		$this->_Enquiry_list1($DB2,$date,$type_param,$cyear);
		$query = $DB2->get();
		return $query->num_rows();
	}

	public function count_all($cyear)
	{  
	    $DB3=$this->load->database('umsdb',TRUE);
		$DB3->from('`sandipun_admin`.`apply_studnet`');
		//$DB3->where('status','Y');
		//$DB3->where('admission_session',$cyear);
		$DB3->where('status','success');
		return $DB3->count_all_results();
	}
	
	
	function students_data($data)
	{
		$this->db->select("sm.current_year,sm.mobile,sm.admission_session,sm.first_name,sm.middle_name,sm.last_name,sm.academic_year,sm.enquiry_no as enrollment_no,sm.stude_id as stud_id,
		sm.stream_id as admission_stream,vw.stream_short_name as stream_name,vw.course_short_name as course_name, vw.school_short_name as school_name,");
		$this->db->from("sandipun_ums_sijoul.enquiry_student_master sm");
		
		$this->db->join("sandipun_ums_sijoul.vw_stream_details vw", "sm.stream_id = vw.stream_id");
		$this->db->where('sm.enquiry_no', $data['enrollment_no']);
		//$this->db->or_where('sm.enrollment_no_new', $data['enrollment_no']);
       // $this->db->where("sm.admission_cycle IS NULL");
		$query1 = $this->db->get();
		//echo $this->db->last_query();
			return $query1->row_array();
	
		
		
	}
	
	public function get_fee_details($data)
	{
		 $DB1=$this->load->database('umsdb',TRUE);
		$session=$this->session->userdata('logged_in');
		
  /* $sql="select fd.amount_p as amount_paid,ad.applicable_fee,ad.actual_fee,ad.opening_balance,
		af.academic_fees,af.tution_fees,af.development,af.caution_money,af.admission_form,af.Gymkhana,af.disaster_management,af.accommodation,
		af.student_safety_insurance,af.internet,af.library,af.registration,af.eligibility,af.educational_industrial_visit,
		af.seminar_training,af.exam_fees,af.student_activity,af.lab,af.computerization,af.nss
		FROM `admission_details` as `ad`
		 left JOIN (SELECT SUM(amount) AS amount_p,student_id,academic_year,chq_cancelled,is_deleted FROM fees_details WHERE
 academic_year='".$data['academic']."' AND chq_cancelled='N' AND is_deleted='N'  AND type_id= '2' AND `student_id` = '".$data['stud']."') as `fd`
  ON `ad`.`student_id` = `fd`.`student_id` And ad.academic_year=fd.academic_year 
		 
		LEFT JOIN academic_fees af ON  ad.stream_id=af.stream_id AND af.academic_year='".$new_year."' AND af.admission_year='".$data['admission_session']."' 
		AND af.year='".$curr_yr."' AND af.`is_active`='Y'
		WHERE  `ad`.`student_id` = '".$data['stud']."'
		
		AND ad.academic_year =  '".$data['academic']."'
		AND `ad`.`cancelled_admission` = 'N' GROUP BY fd.student_id";*/
		 $sql="SELECT em.*,ad.* FROM  academic_fees as ad 
		 INNER JOIN enquiry_student_master as em ON em.stream_id=ad.stream_id AND em.current_year=ad.year AND em.admission_year=ad.admission_year
		 WHERE ad.stream_id='".$data['stream_id']."' AND ad.year='".$data['curr_yr']."' AND ad.admission_year='2021' AND em.enquiry_no='".$data['enroll']."'";
		$query = $DB1->query($sql);
		if($this->session->userdata("uid")==2){
		//echo  $DB1->last_query(); //af.admission_year=ad.academic_year AND
		//print_r($query->row_array());
		}
		return $query->row_array();
       

	}
	
	
	public function fee_details($data){
		
			$DB1 = $this->load->database('umsdb', TRUE);
			$sql="SELECT *,type_id AS ntype_id FROM fees_challan WHERE academic_year ='".$data['academic']."' AND student_id = '".$data['stud']."'
			AND type_id= '".$data['facility']."' AND enrollment_no='".$data['enroll']."' AND challan_status !='CL' AND type_id='2'
			ORDER BY fees_id DESC limit 0,1";
			$query = $DB1->query($sql);
			if($this->session->userdata("uid")==2){
		 // echo  $DB1->last_query();
			}
		    return $query->row_array();
			
	}
	
	function insert_data_in_address($data=array(),$stud_id=''){
		
	    $DB1 = $this->load->database('umsdb', TRUE);
		$data_array=array();
		if(!empty($data) && $stud_id!=''){
		$DB1->select("*");
		$DB1->from('address_details');
		$DB1->where('student_id',$stud_id);
		$DB1->where('adds_of','STUDENT');
		$DB1->where('address_type','CORS');
		$check_whether_entry_exists=$DB1->get()->row();
		
		    $data_array['student_id']=$stud_id;
			$data_array['adds_of']='STUDENT';
			
			$data_array['state_id']=$data['state_id'];
			$data_array['district_id']=$data['district_id'];
			$data_array['city']=$data['city_id'];
			$data_array['pincode']=$data['pincode'];
			
		if(empty($check_whether_entry_exists))
		   {
			
			$DB1->insert('address_details',$data_array);
			return $DB1->insert_id(); 
		   }
		 else{
			 $DB1->update('address_details',$data_array,array('add_id'=>$check_whether_entry_exists->add_id));
			 return $check_whether_entry_exists->add_id; 
		 }		   
		}
		else{
			return 0;
		}
	}
	
	public function Update_scholarship($sm_is){
	
	$current_date=date('Y-m-d h:i:s');
	
	$DBs = $this->load->database('umsdb', TRUE);
	$sqls ="SELECT af.`academic_fees`,af.`tution_fees`,af.`total_fees`,st.stud_id,st.enrollment_no,st.academic_year,st.admission_school,st.admission_stream,st.admission_year FROM student_master AS st

LEFT JOIN `academic_fees` AS af ON af.stream_id=st.`admission_stream` AND af.year=st.`admission_year` AND af.admission_year=st.`academic_year`

WHERE st.stud_id='".$sm_is."'";
	
	   $querys = $DBs->query($sqls);
		$results= $querys->result_array();
		//print_r($result); echo '<br>'; //exit();ech
		foreach($results as $val){
		//echo $val['tution_fees']; echo '<br>';
		$stud_id=$val['stud_id'];
		$enrollment_no=$val['enrollment_no'];
		$total_fees=$val['total_fees'];
		
		$scloership=(($val['tution_fees']) * 10 / 100);
		$year=$val['admission_year'];
		$val['tution_fees'].'---'.round($scloership); //echo '<br>';
		$fees_paid_required=(round($val['total_fees'])-round($scloership));
			
			$scloership=round($scloership);
			
			//$DBE = $this->load->database('umsdb', TRUE);
		 /*  echo $sqlE ="INSERT INTO `fees_consession_details`  VALUES (NULL, 'Other_Scholarship', '$stud_id', '$enrollment_no', '2020', '$total_fees', '$scloership', '$fees_paid_required', 'covid 10%', NULL, NULL, NULL, NULL, '$current_date', NULL)"; 
	        $queryE = $DBs->query($sqlE);*/
		$created_on=date('Y-m-d H:i:s');
		$fees_con['concession_type'] = 'Covid-19';
        $fees_con['student_id'] = $stud_id;
        $fees_con['enrollement_no'] = $enrollment_no;
        $fees_con['academic_year'] = '2021';
        $fees_con['actual_fees'] = $total_fees;
        $fees_con['exepmted_fees'] = $scloership;
        $fees_con['fees_paid_required'] = $fees_paid_required;
        $fees_con['concession_remark'] = 'covid 10%';
       // $fees_con['allowed_by'] = $var['stream_id'];
        //$fees_con['created_by'] = $var['stream_id'];
        $fees_con['created_on'] = $created_on;
       // $fees_con['modified_by'] = $var['stream_id'];
       // $fees_con['modified_on'] = $var['stream_id'];
        //$fees_con['remark'] = $var['stream_id'];
			
	   $DBs->insert('fees_consession_details', $fees_con);
		 
  // $DBd = $this->load->database('umsdb', TRUE);
   $sqld ="UPDATE `sandipun_ums`.`admission_details` SET enrollment_no='$enrollment_no',`applicable_fee` = '$fees_paid_required' , `fees_consession_allowed` = 'Y',`concession_type` = 'Covid-19',`concession_remark` = 'covid 10%'
   WHERE `student_id` = '$stud_id' AND academic_year='2021' AND year='$year'"; 
   $queryd = $DBs->query($sqld);
   

		}
		
		//return 1;
		
}
	
		///////////////////////////////////////////check_fees_challan_submit Details///////////////////////////////////////////

	public function check_fees_challan_submit($data){
		
		$DB = $this->load->database('umsdb', TRUE);
		//print_r($_POST);
		//exit();
		
		$updated_by =$this->session->userdata('name');
		//print_r($updated_by);
		function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
		//$DB->trans_begin(); 
		
		
		$sql="SELECT em.*,ad.* FROM  academic_fees as ad 
		 INNER JOIN enquiry_student_master as em ON em.stream_id=ad.stream_id AND em.current_year=ad.year AND em.admission_year=ad.admission_year
		 WHERE ad.stream_id='".$data['stream_id']."' AND ad.year='".$data['curr_yr']."' AND ad.admission_year='2021' AND em.enquiry_no='".$data['enroll']."'";
		$query = $DB->query($sql);
		$result= $query->row_array();
	//print_r($result); echo '<br>';
	//echo $result['first_name'];
	// exit();
		
		//foreach($result as $list)
		{
			
			echo $result['first_name'].'kk'; echo '<br/>';
		//}
		
		//{
			//echo $list['enquiry_no'];
			$st_master['form_number']=$result['form_no'];
			
			//$st_master['enrollment_no_new']=$list[''];
			//$st_master['enrollment_no']=$list[''];
			
			$st_master['first_name']=$result['first_name'].' '.$result['middle_name'].' '.$result['last_name'];
			//$st_master['middle_name']=$list['middle_name'];
			//$st_master['last_name']=$list['last_name'];
			$st_master['gender']=$result['gender'];
			$st_master['email']=$result['email_id'];
			$st_master['mobile']=$result['mobile'];
			$st_master['category']=$result['category'];
			$st_master['adhar_card_no']=$result['aadhar_card'];
			
			
			$st_master['lateral_entry']= ($result['admission_type']==1) ? "N":"Y";
			$st_master['current_semester']= ($result['admission_type']==1) ? 1:3;
			$st_master['admission_semester']= ($result['admission_type']==1) ? 1:3;
			$st_master['admission_year']= ($result['admission_type']==1) ? 1:2;
			$st_master['current_year']= ($result['admission_type']==1) ? 1:2;
			
			$st_master['academic_year']=2021;
			$st_master['admission_session']=$result['admission_session'];
			$st_master['admission_school']=$result['school_id'];
			$st_master['admission_stream']=$result['stream_id'];
			
			
			$st_master['is_detained']='N';
			$st_master['cancelled_admission']='N';
			$st_master['admission_date']=date('Y-m-d');
			$st_master['entry_from_ip']=getUserIpAddr();
			
			$st_master['created_by']=$updated_by;
			$st_master['created_on']=date('Y-m-d h:i:s');
			$st_master['modified_by']=$updated_by;
			$st_master['modified_on']=date('Y-m-d h:i:s');
			
			$st_master['enquiry_id']=$result['enquiry_id'];
			$st_master['enquiry_no']=$result['enquiry_no'];
			
			$in_address['state_id']=$result['state_id'];
            $in_address['district_id']=$result['district_id'];
            $in_address['city_id']=$result['city_id'];
            $in_address['pincode']=$result['pincode'];
		
		}//Loop
		
		//print_r($st_master);
		
	$resultt=$DB->insert('student_master',$st_master);
	
    $student_id=$DB->insert_id();
    
	//exit();
	
	     if(!empty($student_id)){
		 $add=$this->insert_data_in_address($in_address,$student_id);
		 $student_id;echo '<br/>';
		//exit();
	     $generateprovisional=$this->generateprovisional($student_id);echo '<br/>';
	
	
	//exit();
	///////////////////////////////////////////Admission Details///////////////////////////////////////////
	    if(!empty($generateprovisional)){
		
		
		
	    $adm['student_id']=$student_id;
		$adm['form_number']=$result['form_no'];
		$adm['enrollment_no']=$generateprovisional;
		
		$adm['school_code']=$result['school_id'];
		$adm['stream_id']=$result['stream_id'];
		$adm['year']=$result['admission_type']==1 ? 1:2;
		$adm['academic_year']='2021';
		
		$adm['actual_fee']=$result['actual_fee'];
		$adm['applicable_fee']=$data['applicable_fee'];
		
		//if($result['scholarship_allowed']=="YES"){
		$adm['concession_type']='Covid-19';
		$adm['fees_consession_allowed']='Y';
		//}else{
		//$adm['concession_type']='';
		//$adm['fees_consession_allowed']='N';	
		//}
		
		$adm['hostel_required']=$result['hostel_allowed'];
		$adm['created_by']=$updated_by;
		$adm['created_on']=date('Y-m-d h:i:s');
		$adm['modified_by']=$updated_by;
		$adm['modified_on']=date('Y-m-d h:i:s');
		
		
		
		
		if(!empty($adm) && $result['enquiry_id']!=''){ 	
		
		$DB1 = $this->load->database('umsdb', TRUE);
		
		$sql_ad="SELECT * FROM admission_details where school_code='".$result['school_id']."' AND stream_id='".$result['stream_id']."' AND year='".$result['admission_type']."' AND academic_year='2021' AND  student_id='".$student_id."'";
		$query_ad = $DB1->query($sql_ad);
		$result_ad= $query_ad->row_array();
		
		
		
		/*$DB1->select("*");
		$DB1->from('admission_details');
		$DB1->where('school_code',$result['school_id']);
		$DB1->where('stream_id',$result['stream_id']);
		$DB1->where('year','1');
		$DB1->where('academic_year','2020');
		$DB1->where('student_id',$student_id);
		
		//echo 'AD';
		echo '<br/>';
		echo $check_entry_exists=$DB1->get()->num_rows();
		echo '<br/>';*/
		//echo $result_ad['adm_id'];
		
	    //echo $result['scholarship_allowed'];
	
		  if(empty($result_ad['adm_id'])){
            $DB1->insert('admission_details',$adm);
             $last_ad=$DB1->insert_id(); 		 
		   }else{
		   $DB1->update('admission_details',$adm,array('adm_id'=>$result_ad['adm_id']));
             $last_ad=$result_ad['adm_id']; 			 
		   }
		
		//echo 'AB';	
		}
		
		}
		}
		
	//echo '<br/>';
	//echo 'AB';
	//echo '<br/>';
//print_r($adm);
		//echo $generateprovisional;
		//exit();
	
	//exit();

	//echo $result['scholarship_allowed'];
	/////////////////////////////////////////////////////////////////////////////////////	
	 if(!empty($student_id)){
	//$last_scholarshipid=$this->Update_scholarship($student_id);
	 }
	        if($result['scholarship_allowed']=="YES"){
				
	        $scholarship['concession_type']=$result['scholarship_type'];//'Schlorship';
			$scholarship['student_id']=$student_id;
			$scholarship['enrollement_no']=$generateprovisional;
			$scholarship['academic_year']=2021;
			
			$scholarship['actual_fees']=$result['actual_fee'];
			
			$scholarship['exepmted_fees']=$result['scholarship_amount'];
			$scholarship['fees_paid_required']=$result['actual_fee'] - $result['scholarship_amount'];
			$scholarship['concession_remark']=$result['scholarship_name'];
			$scholarship['allowed_by']='Admin';
			
			$scholarship['created_by']=$updated_by;
			$scholarship['created_on']=date('Y-m-d h:i:s');
			$scholarship['modified_by']=$updated_by;
			$scholarship['modified_on']=date('Y-m-d h:i:s');
			$scholarship['remark']=$result['scholarship_name'];
			
			$DB1->insert('fees_consession_details',$scholarship);
            $last_scholarshipid=	$DB1->insert_id();
			}
	/////////////////////////////////////////////////////////////////////////////////////////////	
		//}//Loop
	//print_r($scholarship);
	//	echo $last_scholarshipid;
	//	exit();
	$DB3 = $this->load->database('umsdb', TRUE);
	$enquiryu['provisional_no']=$generateprovisional;
	$enquiryu['enrollment_no']=$generateprovisional;
	$enquiryu['stude_id']=$student_id;
	$enquiryu['enquiry_status']="Provisional";
	$DB3->update('enquiry_student_master',$enquiryu,array('enquiry_id'=>$result['enquiry_id']));
	//exit();
		////////////////////////////////////////// Challan Start/////////////////////////////////////	
        
		  $challan_digits=4;
		if($_POST['fees_date']=='')
			$fdate=date("Y-m-d");
		else
			$fdate=date("Y-m-d", strtotime($_POST['fees_date'])); 
	//echo '<pre>';	print_r($_POST);
		
	//	exit;
		
		$enroll=$generateprovisional;
		$student_id=$student_id;
		
		$academic=$_POST['academic'];
		$facilty=$_POST['facilty'];
		
		//$_POST['depositto'];
		//$_POST['category'];
		
		$Balance_Amount=$_POST['Balance_Amount'];
		$tutf=$_POST['tutf'];
		$devf=$_POST['devf'];
		$cauf=$_POST['cauf'];
		$admf=$_POST['admf'];
		$exmf= $_POST['exmf'];
		$unirf= $_POST['unirf'];
		
		$_POST['amt'];
		$refund_paid=$_POST['amth'];
		$Excess_Fees=$_POST['Excess'];
		
		//$_POST['epayment_type'];
		//$_POST['receipt_number'];
		//$_POST['bank'];
		//$_POST['branch'];
		//echo $fdate; exit();
		//////////////////////////////////////////////////////////////////////////////////////////////
		
		$Backlog_Exam=$_POST['Backlog_Exam'];
		$Photocopy_Fees=$_POST['Photocopy_Fees'];
		$Revaluation_Fees=$_POST['Revaluation_Fees'];
		$Late_Fees=$_POST['Late_Fees'];
		
		$OtherFINE_Brekage=$_POST['OtherFINE_Brekage'];
		$Other_Registration=$_POST['Other_Registration'];
		$Other_Late=$_POST['Other_Late'];
		$Other_fees=$_POST['Other_fees'];
		//////////////////////////////////////////////////////////////////////////////////////////////
		$Balance_org=$_POST['Balance_org'];
		$Tuition_org=$_POST['Tuition_org'];
		$development_org=$_POST['development_org'];
		$caution_org=$_POST['caution_org'];
		$admission_org=$_POST['admission_org'];
		$exam_org=$_POST['exam_org'];
		$University_org=$_POST['University_org'];
		//////////////////////////////////////////////////////////////
		$currnt=array('stud'=>$student_id,'enroll'=>$generateprovisional,'facility'=>$facilty,'academic'=>$academic);
		$Check_challan=$this->Challan_model->Check_challan($currnt);
	//	print_r($Check_challan);
		//echo '<br>';
		//echo 'fees_id'.$Check_challan[0]['fees_id'];
		//echo '<br>';
		if(empty($Check_challan[0]['fees_id'])){
			$Balance_pending=$Balance_org - $Balance_Amount;
			$Tuition_pending=$Tuition_org - $tutf;
			
			$development_pending=$development_org - $devf;
			if($this->session->userdata("uid")==2){
			//echo $development_org;echo ' development_org<br>';
			//echo $devf;echo '<br>';
			//echo $development_pending;echo '<br>';
			//exit;
		   }
			
			$caution_pending=$caution_org - $cauf;
			$admission_pending=$admission_org - $admf;
			$exam_pending= $exam_org - $exmf;
			$University_pending=$University_org - $unirf;
			
			if($Balance_pending==0){
				$Balance_Amount_status='Y';
			}else{
				$Balance_Amount_status='N';
			}
			
			
			if($Tuition_pending==0){
				$tution_status='Y';
			}else{
				$tution_status='N';
			}
			
			if($development_pending==0){
			$development_status='Y';
			}else{
			$development_status='N';
			}
			
			if($caution_pending==0){
				$caution_status='Y';
			}else{
				$caution_status='N';
			}
			
			if($admission_pending==0){
				$admission_status='Y';
			}else{
				$admission_status='N';
			}
			
			if($exam_pending==0){
				$exam_status='Y';
			}else{
				$exam_status='N';
			}
			
			if($University_pending==0){
				$university_status='Y';
			}else{
				$university_status='N';
			}
			
		}else{
			
			if($Check_challan[0]['Balance_Amount_status']=="N"){
			$Balance_pending= $Check_challan[0]['Balance_Pending'] - $Balance_Amount;
			}else{
			$Balance_pending= $Check_challan[0]['Balance_Pending'];
			}
			
			
			if($Check_challan[0]['tution_status']=="N"){
			$Tuition_pending= $Check_challan[0]['tution_pending'] - $tutf;
			}else{
			$Tuition_pending= $Check_challan[0]['tution_pending'];
			}
			
			if($Check_challan[0]['development_status']=="N"){
			$development_pending= $Check_challan[0]['development_pending'] - $devf;
			}else{
			$development_pending= $Check_challan[0]['development_pending'];	
			}
			
			if($this->session->userdata("uid")==2){
			//echo $Check_challan[0]['development_pending'];echo ' Check_challan<br>';
			//echo $devf;echo '<br>';
			//echo $development_pending;echo '<br>';
			//exit;
		}
			
			
			if($Check_challan[0]['caution_status']=="N"){
			$caution_pending= $Check_challan[0]['caution_pending'] -  $cauf;
			}else{
			$caution_pending= $Check_challan[0]['caution_pending'];	
			}
			if($Check_challan[0]['admission_status']=="N"){
			$admission_pending= $Check_challan[0]['admission_pending'] - $admf;
			}else{
			$admission_pending= $Check_challan[0]['admission_pending'];	
			}
			if($Check_challan[0]['exam_status']=="N"){
			$exam_pending= $Check_challan[0]['exam_pending'] -  $exmf;
			}else{
			$exam_pending= $Check_challan[0]['exam_pending'];	
			}
			if($Check_challan[0]['university_status']=="N"){
			$University_pending= $Check_challan[0]['university_pending'] - $unirf;
			}else{
			$University_pending= $Check_challan[0]['university_pending'];	
			}
			
			
			
			if($Balance_pending==0){
				$Balance_Amount_status='Y';
			}else{
				$Balance_Amount_status='N';
			}
			
			if($Tuition_pending==0){
				$tution_status='Y';
			}else{
				$tution_status='N';
			}
			
			if($development_pending==0){
			$development_status='Y';
			}else{
			$development_status='N';
			}
			
			if($caution_pending==0){
				$caution_status='Y';
			}else{
				$caution_status='N';
			}
			
			if($admission_pending==0){
				$admission_status='Y';
			}else{
				$admission_status='N';
			}
			
			if($exam_pending==0){
				$exam_status='Y';
			}else{
				$exam_status='N';
			}
			
			if($University_pending==0){
				$university_status='Y';
			}else{
				$university_status='N';
			}
		}
		$fdate;
		$epayment_type=$_POST['epayment_type'];
		$receipt_number=$_POST['receipt_number'];
		//$TransactionNo=$_POST['TransactionNo'];
		//$TransactionDate=$_POST['TransactionDate'];
		/*if(isset($_POST['Balance_Amount_check'])){
			$Balance_c="Y";
		}else{
			$Balance_c="N";
		}*/
///echo $Balance_c;
//exit;$enroll=$generateprovisional;
		//$student_id=$student_id;
		//Remark
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
        if($_POST['facilty']==2){
		$insert_array=array("enrollment_no"=>$generateprovisional,"student_id"=>$student_id,
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>$_POST['category'],"tution_fees"=>$_POST['tutf'],"development_fees"=>$_POST['devf'],
		"caution_money"=>$_POST['cauf'],"admission_form"=>$_POST['admf'],"exam_fees"=>$_POST['exmf'],
		"university_fees"=>$_POST['unirf'],"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],
		"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),
		"created_on"=>date("Y-m-d H:i:s"),
		"refund_pay"=>$refund_paid,"Excess_Fees"=>$refund_paid,
		"tution_pending"=>$Tuition_pending,"tution_status"=>$tution_status,
		"development_pending"=>$development_pending,"development_status"=>$development_status,
		"caution_pending"=>$caution_pending,"caution_status"=>$caution_status,
		"admission_pending"=>$admission_pending,"admission_status"=>$admission_status,
		"exam_pending"=>$exam_pending,"exam_status"=>$exam_status,
		"university_pending"=>$University_pending,"university_status"=>$university_status,
		"Balance_Amount"=>$_POST['Balance_Amount'],"Balance_Pending"=>$Balance_pending,"Balance_Amount_status"=>$Balance_Amount_status,"remark"=>$_POST['Remark']
		);
		
		if($this->session->userdata("uid")==2){
			//print_r($insert_array);
			//exit;
		}
		
		}/*elseif(($_POST['facilty']==5)||($_POST['facilty']==7)||($_POST['facilty']==8)||($_POST['facilty']==9)){
			$exam_mon = $_POST['exam_monthyear'];
            $arr_exammon = explode(':', $exam_mon);
			
			$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>$_POST['category'],"Backlog_fees"=>$_POST['Backlog_Exam'],"Photocopy_fees"=>$_POST['Photocopy_Fees'],
		"Revaluation_Fees"=>$_POST['Revaluation_Fees'],"Exam_LateFees"=>$_POST['Late_Fees'],"amount"=>$_POST['amt'],
		"Balance_Amount"=>$_POST['Balance_Amount'],"Balance_Amount_status"=>$Balance_c,"exam_monthyear"=>$arr_exammon[0],"exam_id"=>$arr_exammon[1],
		"fees_paid_type"=>$_POST['epayment_type'],"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),"remark"=>$_POST['Remark'],
		"created_on"=>date("Y-m-d H:i:s"));
			
		}elseif($_POST['facilty']==10){
			$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>$_POST['category'],"OtherFINE_Brekage"=>$_POST['OtherFINE_Brekage'],"Other_Registration"=>$_POST['Other_Registration'],
		"Other_Late"=>$_POST['Other_Late'],"Other_fees"=>$_POST['Other_fees'],"amount"=>$_POST['amt'],
		"Balance_Amount"=>$_POST['Balance_Amount'],"Balance_Amount_status"=>$Balance_c,"fees_paid_type"=>$_POST['epayment_type'],
		"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],"remark"=>$_POST['Remark'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),
		"created_on"=>date("Y-m-d H:i:s"));
			
		}*/
		//echo '<pre>';print_r($insert_array);
		//exit;
        $last_inserted_id= $this->Challan_model->add_fees_challan_submit($insert_array);
		//echo 'last_inserted_id==='.$last_inserted_id;exit();
		if($last_inserted_id)
		{
			if($last_inserted_id>9999)
			{
				$challan_digits=strlen($last_inserted_id);
			}
			
			
			if($_POST['curr_yr']=="1"){
				$addmision_type='A';
			}else{
				$addmision_type='R';
			}
			
			$current_month=date('m');
			
			//if($current_month<=5){
			//	$month_session="2";
			//}else{
				$month_session="1";
			//}
			
			$ayear= substr($_POST['academic'], -2);  //explode("-",$_POST['academic']);$ayear.
			$challan_no='20SIJ'.$addmision_type.$month_session.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			
			$update_array=array("exam_session"=>$challan_no);
			$last_inserted_id= $this->Challan_model->update_challan_no($last_inserted_id,$update_array);
			
			
			
			
			
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}
		else{
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
		}
	//	exit();
		
		
		
	/*$DB->trans_complete();
 if ($DB->trans_status() === FALSE){
    $DB->trans_rollback();
	
     }else{
    $DB->trans_commit();
  
   }*/
		    // redirect('Challan');
	
		////////////////////////////////////////// Challan Start/////////////////////////////////////	

	
		
	}
	
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	

function insert_in_admission_details($data=array(),$stud_id=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$data_array=array();
		$data_array['student_id']=$stud_id;
		$data_array['school_code']=$data['admission-school'];
		$data_array['stream_id']=$data['admission-branch'];
		$data_array['year']=$data['admission_type']==1 ? 1:2;
		$data_array['academic_year']=$data['acyear'];
		$data_array['actual_fee']=$data['actual_fee'];
		$data_array['applicable_fee']=$data['actual_fee'];
		if(!empty($data) && $stud_id!=''){ 	
		$DB1->select("*");
		$DB1->from('admission_details');
		//$DB1->where('school_code',$data['admission-school']);
		//$DB1->where('stream_id',$data['admission-branch']);
		//$DB1->where('academic_year',$data['acyear']);
		$DB1->where('student_id',$stud_id);
		$check_whether_entry_exists=$DB1->get()->row();
	
		 if(empty($check_whether_entry_exists))
		   {
             $DB1->insert('admission_details',$data_array);
             return	$DB1->insert_id(); 		 
		   }
		   else{
			 $DB1->update('admission_details',$data_array,array('adm_id'=>$check_whether_entry_exists->adm_id));
              return $check_whether_entry_exists->adm_id; 			 
		   }
		
			
		}
		else{
			return 0;
		}
	}


	
	
	
	
	function enquiry_by_id($id){
		$DB = $this->load->database('umsdb', TRUE);
		
		 $sql="SELECT vw.`school_name`,vw.`course_short_name`,vw.`stream_name`,st.state_name,dt.`district_name`,tm.`taluka_name`,em.*,ad.* FROM academic_fees AS ad 
INNER JOIN enquiry_student_master AS em ON em.stream_id=ad.stream_id AND em.current_year=ad.year AND em.admission_year=ad.admission_year 
LEFT JOIN `vw_stream_details` AS vw ON vw.stream_id=em.stream_id

LEFT JOIN `states` AS st ON st.state_id=em.state_id
LEFT JOIN `district_name` AS dt ON dt.`district_id`=em.district_id
LEFT JOIN `taluka_master` AS tm ON tm.`taluka_id`=em.city_id

WHERE em.enquiry_id='$id'";
		 
		$query = $DB->query($sql);
		$result= $query->row_array();
		return $result;
		//print_r($result); echo '<br>'; //
	}
//////////////////////////////////////////////////////////////////////////////////////////////////	

function generateprovisional($student_id='')
	{     //$DB = $this->load->database('umsdb', TRUE);
		    $finalprn='';
			$DB1 = $this->load->database('umsdb', TRUE); 
			$student_data=$DB1->get_where('sandipun_ums_sijoul.student_master',array('stud_id'=>$student_id))->row();
			if(!empty($student_data)){
			$stream_id=$student_data->admission_stream;
			$academic_year=$student_data->academic_year;
			$admission_year=$student_data->admission_session;
		
			$stmdet = $DB1->query("select * from sandipun_ums_sijoul.student_master where academic_year=$academic_year and admission_session=$admission_year and enrollment_no_new IS NOT NULL and enrollment_no_new  !='' order by enrollment_no_new desc LIMIT 1")->row();
			
			
			if(!empty($stmdet)){
			$auto =$stmdet->enrollment_no_new;	
			}
			else{
			$auto =substr($student_data->academic_year, -2)."SUS0000";
			}
			
			$var1 = substr($auto, -4);
			$var1 = ++$var1;
			$prn =  sprintf("%04d", $var1);
			$finalprn  =substr($student_data->academic_year, -2)."SUS".$prn;
			$DB1->update('sandipun_ums_sijoul.student_master',array('enrollment_no_new'=>$finalprn,'enrollment_no'=>$finalprn),array('stud_id'=>$student_id));		
			}
		  return $finalprn;
	}	
	
function insert_st_direct(){
//error_reporting(E_ALL);
$DB = $this->load->database('umsdb', TRUE);
		//print_r($_POST);
		//exit();
		
		$updated_by =$this->session->userdata('name');
		//print_r($updated_by);
		function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

		//$DB->trans_begin(); 
		$sqlmain="SELECT * FROM enquiry_student_master WHERE enquiry_status='enquiry'";//enquiry_status='enquiry' limit 0,1enquiry_no='20ENJ000007'
		$querymain = $DB->query($sqlmain);//$result=$query->result_array();
		$resultmain= $querymain->result_array();
		//print_r($resultmain);
		foreach($resultmain as $data){
			echo $data['enquiry_no']; echo '<br>';
			echo $data['stream_id']; echo '<br>';
			echo $data['admission_type']; echo '<br>';
		//}
		
	//exit();
	//	{
		echo $sql="SELECT em.*,ad.* FROM  academic_fees as ad 
		 INNER JOIN enquiry_student_master as em ON em.stream_id=ad.stream_id AND em.current_year=ad.year AND em.admission_year=ad.admission_year
		 WHERE ad.stream_id='".$data['stream_id']."' AND ad.year='".$data['admission_type']."' AND ad.admission_year='2021' AND em.enquiry_no='".$data['enquiry_no']."'";
		$query = $DB->query($sql);
		$result= $query->row_array();
	 print_r($result); echo '<br>';
	//echo $result['first_name'];

		
		//foreach($result as $list)
		{
			
			echo $result['first_name'].'kk'; echo '<br/>';
		//}
		
		//{
			//echo $list['enquiry_no'];
			$st_master['form_number']=$result['form_no'];
			
			//$st_master['enrollment_no_new']=$list[''];
			//$st_master['enrollment_no']=$list[''];
			
			$st_master['first_name']=$result['first_name'].' '.$result['middle_name'].' '.$result['last_name'];
			//$st_master['middle_name']=$list['middle_name'];
			//$st_master['last_name']=$list['last_name'];
			$st_master['gender']=$result['gender'];
			$st_master['email']=$result['email_id'];
			$st_master['mobile']=$result['mobile'];
			$st_master['category']=$result['category'];
			$st_master['adhar_card_no']=$result['aadhar_card'];
			
			
			$st_master['lateral_entry']= ($result['admission_type']==1) ? "N":"Y";
			$st_master['current_semester']= ($result['admission_type']==1) ? 1:3;
			$st_master['admission_semester']= ($result['admission_type']==1) ? 1:3;
			$st_master['admission_year']= ($result['admission_type']==1) ? 1:2;
			$st_master['current_year']= ($result['admission_type']==1) ? 1:2;
			
			$st_master['academic_year']=2021;
			$st_master['admission_session']=$result['admission_session'];
			$st_master['admission_school']=$result['school_id'];
			$st_master['admission_stream']=$result['stream_id'];
			
			
			$st_master['is_detained']='N';
			$st_master['cancelled_admission']='N';
			$st_master['admission_date']=date('Y-m-d');
			$st_master['entry_from_ip']=getUserIpAddr();
			
			$st_master['created_by']=$updated_by;
			$st_master['created_on']=date('Y-m-d h:i:s');
			$st_master['modified_by']=$updated_by;
			$st_master['modified_on']=date('Y-m-d h:i:s');
			
			$st_master['enquiry_id']=$result['enquiry_id'];
			$st_master['enquiry_no']=$result['enquiry_no'];
			
			$in_address['state_id']=$result['state_id'];
            $in_address['district_id']=$result['district_id'];
            $in_address['city_id']=$result['city_id'];
            $in_address['pincode']=$result['pincode'];
		
		}//Loop
		
		//print_r($st_master);
		
	$resultt=$DB->insert('student_master',$st_master);
	
    $student_id=$DB->insert_id();
    
	//exit();
	
	     if(!empty($student_id)){
		 $add=$this->insert_data_in_address($in_address,$student_id);
		 $student_id;echo '<br/>';
		
	    echo $generateprovisional=$this->generateprovisional($student_id);echo '<br/>';
	
	
	
	///////////////////////////////////////////Admission Details///////////////////////////////////////////
	    if(!empty($generateprovisional)){
		
		
		
	    $adm['student_id']=$student_id;
		$adm['form_number']=$result['form_no'];
		$adm['enrollment_no']=$generateprovisional;
		
		$adm['school_code']=$result['school_id'];
		$adm['stream_id']=$result['stream_id'];
		$adm['year']=$result['admission_type']==1 ? 1:2;
		$adm['academic_year']='2021';
		
		$adm['actual_fee']=$result['actual_fee'];
		$adm['applicable_fee']=$data['applicable'];//applicable_fee
		
		//if($result['scholarship_allowed']=="YES"){
		$adm['concession_type']='Covid-19';
		$adm['fees_consession_allowed']='Y';
		//}else{
		//$adm['concession_type']='';
		//$adm['fees_consession_allowed']='N';	
		//}
		
		$adm['hostel_required']=$result['hostel_allowed'];
		$adm['created_by']=$updated_by;
		$adm['created_on']=date('Y-m-d h:i:s');

		$adm['modified_by']=$updated_by;
		$adm['modified_on']=date('Y-m-d h:i:s');
		
		
		
		
		if(!empty($generateprovisional)){ 	
		
		$DB1 = $this->load->database('umsdb', TRUE);
		
		 $sql_ad="SELECT  * FROM admission_details where school_code='".$result['school_id']."' AND stream_id='".$result['stream_id']."' AND year='".$result['admission_type']."' AND academic_year='2021' AND  student_id='".$student_id."'";
		$query_ad = $DB1->query($sql_ad);
		 $result_ad= $query_ad->result_array();
		($result_ad);
		//echo $result_ad['adm_id'];
		 
		/*$DB1->select("*");
		$DB1->from('admission_details');
		$DB1->where('school_code',$result['school_id']);
		$DB1->where('stream_id',$result['stream_id']);
		$DB1->where('year','1');
		$DB1->where('academic_year','2020');
		$DB1->where('student_id',$student_id);
		
		//echo 'AD';
		echo '<br/>';
		echo $check_entry_exists=$DB1->get()->num_rows();
		echo '<br/>';*/
		//echo $result_ad['adm_id'];
		
	    //echo $result['scholarship_allowed'];
	
		  if(empty($result_ad['adm_id'])){
            $DB1->insert('admission_details',$adm);
             $last_ad=$DB1->insert_id(); 		 
		   }else{
		   $DB1->update('admission_details',$adm,array('adm_id'=>$result_ad['adm_id']));
             $last_ad=$result_ad['adm_id']; 			 
		   }
		
		//echo 'AB';	
		}
		
		}
		}
		//exit();
	//echo '<br/>';
	//echo 'AB';
	//echo '<br/>';
//print_r($adm);
		//echo $generateprovisional;
		//exit();
	
	//exit();

	//echo $result['scholarship_allowed'];
	/////////////////////////////////////////////////////////////////////////////////////	
	 if(!empty($student_id)){
	//$last_scholarshipid=$this->Update_scholarship($student_id);
	 }
	        if($result['scholarship_allowed']=="YES"){
				
	        $scholarship['concession_type']=$result['scholarship_type'];//'Schlorship';
			$scholarship['student_id']=$student_id;
			$scholarship['enrollement_no']=$generateprovisional;
			$scholarship['academic_year']=2021;
			
			$scholarship['actual_fees']=$result['actual_fee'];
			
			$scholarship['exepmted_fees']=$result['scholarship_amount'];
			$scholarship['fees_paid_required']=$result['actual_fee'] - $result['scholarship_amount'];
			$scholarship['concession_remark']=$result['scholarship_name'];
			$scholarship['allowed_by']='Admin';
			
			$scholarship['created_by']=$updated_by;
			$scholarship['created_on']=date('Y-m-d h:i:s');
			$scholarship['modified_by']=$updated_by;
			$scholarship['modified_on']=date('Y-m-d h:i:s');
			$scholarship['remark']=$result['scholarship_name'];
			
			$DB1->insert('fees_consession_details',$scholarship);
            $last_scholarshipid=	$DB1->insert_id();
			}
	/////////////////////////////////////////////////////////////////////////////////////////////	
		//}//Loop
	//print_r($scholarship);
	//	echo $last_scholarshipid;
	//	exit();
	$DB3 = $this->load->database('umsdb', TRUE);
	$enquiryu['provisional_no']=$generateprovisional;
	$enquiryu['enrollment_no']=$generateprovisional;
	$enquiryu['stude_id']=$student_id;
	$enquiryu['course_type']='direct_entery';
	$enquiryu['enquiry_status']="Provisional";
	$DB3->update('enquiry_student_master',$enquiryu,array('enquiry_id'=>$result['enquiry_id']));
	//exit();
	}//foreach($resultmain as $data){
		
}


public function consultants_list(){
	$DB1 = $this->load->database('ic_erp', TRUE);
	
	 $sql_ad="SELECT  * FROM consultants_call_details where status='Y'";
		$query_ad = $DB1->query($sql_ad);
		 return $result_ad= $query_ad->result_array();
}

public function City_list(){
	$DB1 = $this->load->database('umsdb', TRUE);
	
	 $sql_ad="SELECT  * FROM city_master where state_id='4'";
		$query_ad = $this->db->query($sql_ad);
		 return  $query_ad->result_array();
}

public function fetch_Bonafide($data){
	$DB1 = $this->load->database('umsdb', TRUE);
	
	 $sql_ad="SELECT  * FROM bonafied_certificates_drcc where bcd_id='".$data['bcd_id']."'";
		$query_ad = $DB1->query($sql_ad);
		 return  $query_ad->result_array();
}

public function fetch_Bonafide_all($data){
	$DB = $this->load->database('umsdb', TRUE);
	
	  //$sql_ad="SELECT  * FROM bonafied_certificates_drcc where bcd_id='".$data['bcd_id']."'";
		//$query_ad = $DB1->query($sql_ad);
		// return  $query_ad->result_array();
		
		$DB->select('bcd.*,vw.stream_name,vw.course_duration,vw.course_id,ccd.contact_person,cm.city_name as dcity_name,cmm.city_name as Districtname');
		$DB->from('bonafied_certificates_drcc as bcd');
		
		$DB->join('vw_stream_details as vw','vw.stream_id=bcd.Course','left');
		$DB->join('sandipun_ic_erp20.consultants_call_details as ccd','ccd.id=bcd.consultant','left');
		$DB->join('sandipun_erp_sijoul.city_master as cm','cm.city_id=bcd.drcc_city','left');
		$DB->join('sandipun_erp_sijoul.city_master as cmm','cmm.city_id=bcd.District','left');
		
	//	$DB->join('bonafide_academic_fees as bcf','bcf.course=vw.course_id AND bcf.is_hostel=bcd.hostel_status','left');
		
		$DB->where("bcd.bcd_id", $data['bcd_id']);
		$query=$DB->get();
	//  echo $DB->last_query();
         return $result= $query->result_array();
}


public function Academic_Fees($data,$hs,$ht,$course_id,$course_duration,$admission_year){
	$DB = $this->load->database('umsdb', TRUE);
	
	  //$sql_ad="SELECT  * FROM bonafied_certificates_drcc where bcd_id='".$data['bcd_id']."'";
		//$query_ad = $DB1->query($sql_ad);
		// return  $query_ad->result_array();
		
		$DB->select('*');
		$DB->from('bonafide_academic_fees');
		
		//$DB->join('vw_stream_details as vw','vw.stream_id=bcd.Course','left');
		//$DB->join('bonafide_academic_fees as bcf','bcf.course=vw.course_id AND bcf.is_hostel=bcd.hostel_status AND bcd.hostel_type=bcf.is_hostel_type','left');
		
		$DB->where("course", $course_id);
		
		if($admission_year==2){
		$DB->where("course_dusration", '3');	
			}else{
		$DB->where("course_dusration", $course_duration);
		}
		
		$DB->where("admission_year", $admission_year);
		
		$DB->where("is_hostel", $hs);
		if($hs=="Y"){
		$DB->where("is_hostel_type", $ht);
		}
		$query=$DB->get();
	// echo $DB->last_query();
         return $result= $query->result_array();
}

public function save_status($data){
	$DB1 = $this->load->database('umsdb', TRUE);
	//$save['date_in']=$data['Date_f'];
	$save['status_date']=$data['Date_f'];
	$save['acknowledgement_no']=$data['acknowledgement_no'];
	$save['status']=$data['status_m'];
	$save['status_remark']=$data['Remark'];
	
	$DB1->update('bonafied_certificates_drcc',$save,array('bcd_id'=>$data['bcd_id']));
	
}

public function OpenDialougedeleted($data){
	
	$DB1 = $this->load->database('umsdb', TRUE);
	
	
	$DB1->where('bcd_id', $data['bcd_id']);
    $DB1->delete('bonafied_certificates_drcc');
	// $sql_ad="DELETE  FROM bonafied_certificates_drcc where bcd_id='".$data['bcd_id']."'";
	//	$query_ad = $DB1->query($sql_ad);
	//	 return  $query_ad->result_array();
	echo $DB1->affected_rows();

	//$DB1->update('bonafied_certificates_drcc',$save,array('bcd_id'=>$data['bcd_id']));
}

public function current_ref(){
	$DB1 = $this->load->database('umsdb', TRUE);
	
	$DB1->select('ref_no');
	$DB1->from('bonafied_certificates_drcc');
    $DB1->order_by('bcd_id','DESC');
	$DB1->limit('0','1');
	// $sql_ad="DELETE  FROM bonafied_certificates_drcc where bcd_id='".$data['bcd_id']."'";
	//	$query_ad = $DB1->query($sql_ad);
	//	 return  $query_ad->result_array();
	$query=$DB1->get();
	 // echo $DB1->last_query();
         return $result= $query->result_array();

	//$DB1->update('bonafied_certificates_drcc',$save,array('bcd_id'=>$data['bcd_id']));
	
}
public function check_adhar($adhar){
$DB1 = $this->load->database('umsdb', TRUE);
	
	$DB1->select('*');
	$DB1->from('bonafied_certificates_drcc');	
	$DB1->where("aadhar_card", $adhar);
	$query=$DB1->get();
	return $query->num_rows();
}
public function streams_yearwise(){
	 
        $DB1 = $this->load->database('umsdb', TRUE); 
        
        $DB1->select("vd.stream_id,vd.stream_name,vd.stream_short_name");
		$DB1->from('vw_stream_details vd');
		$DB1->join('academic_fees as af','af.stream_id = vd.stream_id','left');
		//$DB1->where("vd.course_id", $_POST['course']);
        //$DB1->where("vd.school_id", $_POST['school']);
		$DB1->where("af.academic_year", '2021-22');
		$DB1->group_by("vd.stream_id");
	//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		
		
		
		//	$DB1->where("certificate_name", $certtype);
		$query=$DB1->get();
	//echo $DB1->last_query();
         return  $stream_details =  $query->result_array();
        
        
        
        
     /*  echo '<option value="">Select Stream</option>';									
		foreach($stream_details as $course){
		
			echo '<option value="'.$course['stream_id'].'"'.$sel.'>'.$course['stream_name'].'</option>';
		} */
									
        
        
        
        
        
        
        
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////


}
?>