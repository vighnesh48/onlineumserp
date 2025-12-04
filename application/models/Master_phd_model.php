<?php
class Master_phd_model extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
		//error_reporting(E_ALL);
		//ini_set('display_errors', 1);
    }
	
	public function get_academic_details()
	{
		$sql="select * From sf_academic_year order by academic_year desc ";
		$query = $this->db->query($sql);
		return  $query->result_array();
	}
	public function get_academic_fees_details($data)
	{
		//echo "academic_fees_id===".$data['academic_fees_id'];exit();
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("vw_stream_details.stream_short_name,vw_stream_details.stream_name as stream_name,vw_stream_details.course_short_name as course_name,vw_stream_details.school_short_name as school_name,phd_academic_fees.*,");
		$DB1->from("phd_academic_fees");
		$DB1->join("vw_stream_details", "vw_stream_details.stream_id=phd_academic_fees.stream_id");
		
		if($data['academic_fees_id']!='')
			$where=array("phd_academic_fees.academic_fees_id"=>$data['academic_fees_id']);
		else
			$where=array("phd_academic_fees.academic_year"=>$data['academic']);
		
		$arr=explode("-",$data['admission_year']);
		$adyear=$arr[0];
		if($data['admission_year']!='')
		{
			$DB1->where("phd_academic_fees.admission_year LIKE '$adyear%'");
		}

	//	$DB1->where('vw_stream_details.is_main_stream','Y');
	//	$DB1->where('vw_stream_details.is_lateral','Y');
		$DB1->where($where);
		$DB1->order_by("phd_academic_fees.admission_year,phd_academic_fees.year,school_name,stream_short_name", "desc");
		$query = $DB1->get();
//	echo $DB1->last_query();exit();
	/* 	$sql="select * from sf_student_master;";
		$query = $DB1->query($sql);
		 */
		return $query->result_array();
	}
	
	
	
		public function get_academic_fees_detailsnew($data)
	{
		//echo "academic_fees_id===".$data['academic_fees_id'];exit();
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("vw_stream_details.stream_short_name,vw_stream_details.stream_name as stream,vw_stream_details.stream_code as stream_name,vw_stream_details.course_short_name as course_name,vw_stream_details.school_short_name as school_name,phd_academic_fees.*,");
		$DB1->from("phd_academic_fees");
		$DB1->join("vw_stream_details", "phd_academic_fees.stream_id = vw_stream_details.stream_id");
		if($data['academic_fees_id']!='')
			$where=array("phd_academic_fees.academic_fees_id"=>$data['academic_fees_id']);
		else
			$where=array("phd_academic_fees.academic_year"=>$data['academic']);
		
		$arr=explode("-",$data['admission_year']);
		$adyear=$arr[0];
		if($data['admission_year']!='')
		{
			$DB1->where("phd_academic_fees.admission_year = '$adyear'");
		}

		$DB1->where($where);
	//	$DB1->order_by("phd_academic_fees.admission_year,phd_academic_fees.year,school_name,stream_short_name", "desc");
	$DB1->group_by("phd_academic_fees.batch,phd_academic_fees.admission_year,phd_academic_fees.stream_id,phd_academic_fees.academic_year,phd_academic_fees.year");//academic_fees.academic_year
		//$DB1->order_by("academic_fees.admission_year,academic_fees.year,school_name,stream_short_name", "desc");
		$DB1->order_by("phd_academic_fees.stream_id,phd_academic_fees.admission_year","ASC");//,academic_fees.year,school_name,stream_short_name"
		$query = $DB1->get();
		//echo $DB1->last_query();//exit();
	/* 	$sql="select * from sf_student_master;";
		$query = $DB1->query($sql);
		 */
		return $query->result_array();
	}
	
	
	
	
	
	
	
	
	
	
	
	public function get_academic_stream_list($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$arr=explode("-",$data['academic']);
		$ac_year=$arr[0];
		if($ac_year==$data['year'])
		{
			$get_all_stream_list=$this->get_all_stream_list($data);
	//exit();
			foreach($get_all_stream_list as $val){
				$streamlist[]=$val['stream_id'];
				
			}
			array_push($streamlist,"9","103","104");
			//print_r($streamlist);exit();
		//	$arr = array(9,103,104);
	    	//$DB1->where_not_in('vw_stream_details.stream_id',$streamlist);
			$DB1->distinct();
			$DB1->select("vw_stream_details.stream_id,vw_stream_details.stream_short_name, vw_stream_details.stream_name");
			$DB1->from("vw_stream_details");
			//$DB1->where_not_in('vw_stream_details.stream_id',$streamlist);
			$DB1->where('vw_stream_details.course_id','15');	
			if($data['yr']==3)
			{
			//	$DB1->where('vw_stream_details.is_third_year','Y');
			}
			else if($data['yr']==2)
			{
			//	$DB1->where('vw_stream_details.is_lateral','Y');
			//	$DB1->where('vw_stream_details.is_main_stream','Y');
			}
			
			$DB1->order_by("vw_stream_details.stream_name", "asc");
			
			$DB1->where_not_in('vw_stream_details.stream_id',$streamlist); ////
			
			
			$query = $DB1->get();
			//echo '1'. $DB1->last_query();
			//exit();
		
			return $query->result_array();
		}
		else{
			$get_admissionyear_stream_list=$this->get_admissionyear_stream_list($data);
			$year=$data['year'];
			foreach($get_admissionyear_stream_list as $val){
				$streamlist[]=$val['stream_id'];
			}
			//print_r($streamlist);exit();
			$DB1->distinct();
			$DB1->select("vw_stream_details.stream_id,vw_stream_details.stream_short_name,vw_stream_details.stream_name");
			$DB1->from("vw_stream_details");
			$DB1->join("admission_details", "admission_details.stream_id = vw_stream_details.stream_id AND admission_details.academic_year = '$year'",'left');
		    #$DB1->where("admission_details.academic_year = '$year'");
		    #$DB1->where("admission_details.cancelled_admission",'N');
			#$DB1->where('vw_stream_details.is_lateral','Y');
			#$DB1->where('vw_stream_details.is_main_stream','Y');
				if($data['yr']==3)
			{
			//$DB1->where('vw_stream_details.is_third_year','Y');	    
			}
			
			
		    $DB1->where('vw_stream_details.course_id','15');
				
			$DB1->where_not_in('vw_stream_details.stream_id',$streamlist);	
			$DB1->order_by("vw_stream_details.stream_short_name", "asc");
			$query = $DB1->get();
			//echo '2'. $DB1->last_query();
			//exit();
		
			return $query->result_array();
		}
	}
	
	public function get_admissionyear_stream_list($data)
	{
		//print_r($data);
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("vw_stream_details.stream_id,");
		$DB1->from("vw_stream_details");
		$DB1->join("phd_academic_fees", "phd_academic_fees.stream_id = vw_stream_details.stream_id",'left');
		$DB1->where("phd_academic_fees.academic_year = '".$data['academic']."' and phd_academic_fees.admission_year = '".$data['year']."' and batch='".$data['Batch']."'");
		$arr=explode("-",$data['academic']);
		$ac_year=$arr[0];
		
		if($ac_year===$data['year'])
		{
			$DB1->where("phd_academic_fees.year ='".$data['yr']."'");
		}
		
	    #$DB1->where('vw_stream_details.is_lateral','Y');
        #$DB1->where('vw_stream_details.is_main_stream','Y');
		$DB1->order_by("vw_stream_details.stream_id", "desc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->result_array();
	}
	
	public function get_all_stream_list($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		
		if($data['yr']>=2){
		$current_year='0';}else{
			$current_year='1';
		}
		$DB1->select("vw_stream_details.stream_id,");
		$DB1->from("vw_stream_details");
		$DB1->join("phd_academic_fees", "phd_academic_fees.stream_id = vw_stream_details.stream_id",'left');
		$where=("phd_academic_fees.academic_year ='".$data['academic']."' and phd_academic_fees.admission_year = '".$data['year']."'
		 and phd_academic_fees.year ='".$current_year."'  and phd_academic_fees.batch ='".$data['Batch']."'");
		
		$DB1->where($where);
		//	$arr = array(9,103,104);
		//	$DB1->where_not_in('vw_stream_details.stream_id',$arr);
		$arr=explode("-",$data['academic']);
		$ac_year=$arr[0];
		
		if(($ac_year==$data['year']) && $data['yr']==3)
		{
		//	$DB1->where('vw_stream_details.is_third_year','Y');
		}
		else{
		//$DB1->where('vw_stream_details.is_lateral','Y');
	//	$DB1->where('vw_stream_details.is_main_stream','Y');
		}
		$DB1->order_by("vw_stream_details.stream_id", "desc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->result_array();
	}
	
	public function get_stream_list_notin_school($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$get_all_schoolstream_list=$this->get_all_schoolstream_list($data['school']);
		
		foreach($get_all_schoolstream_list as $val){
			$streamlist[]=$val['stream_id'];
		}
		//print_r($streamlist);exit();
		$DB1->distinct();
		$DB1->select("stream_master.stream_id,stream_master.stream_short_name");
		$DB1->from("stream_master");
		$DB1->where_not_in('stream_master.stream_id',$streamlist);
		$DB1->where('course_cat',$data['category']);
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
	
		return $query->result_array();
	}
	
	public function get_all_schoolstream_list($school)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		//SELECT * FROM `school_stream` WHERE `school_code`=1001
		$DB1->select("school_stream.stream_id,");
		$DB1->from("school_stream");
		$DB1->where('school_code',$school);
		$DB1->order_by("school_stream.school_stream_id", "desc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->result_array();
	}
	
    public function check_academic_fees($stream_list,$academic,$year,$yr){

		$DB1 = $this->load->database('umsdb', TRUE);

     $sql="SELECT count(academic_fees_id) as Total From phd_academic_fees WHERE stream_id='$stream_list' AND academic_year='$academic' AND admission_year='$year' AND  year='$yr' AND is_active='Y'";
    
    $query = $DB1->query($sql);
     $result=$query->result_array();
      return $result[0]['Total'];

    }



	public function add_academic_fees_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$stream_list=$data['stream_list'];
		//echo "count====".count($stream_list).'<br/>';exit();
		if(count($stream_list)>0)
		{
			$j=0;
			for($i = 1; $i <= count($stream_list); $i++)
			{
				$check= $this->academic_check($stream_list[$j],$data['academic'],$data['year'],$data['yr']);
				if(!empty($data['exam_fees'])){
					$exam_fees=$data['exam_fees'];
				}else{
					$exam_fees=$data['exm_fees'];
				}
                //if($check==0){
					if($data['year']>=2019)
					{
						$insert_array=array("stream_id"=>$stream_list[$j],"academic_year"=>$data['academic'],
						"admission_year"=>$data['year'],"year"=>$data['yr'],"batch"=>$data['Batch'],"academic_fees"=>$data['academic_fee'],
						"tution_fees"=>$data['Tution'],"development"=>$data['Development'],
						"caution_money"=>$data['caution_money'],"admission_form"=>$data['admission_form'],
						"Gymkhana"=>$data['Gymkhana'],"registration"=>$data['Regis'],
						"student_safety_insurance"=>$data['Insurance'],"library"=>$data['Library'],
						"total_fees"=>$data['Total'],"eligibility"=>$data['eligibility'],"internet"=>$data['internet'],
						"educational_industrial_visit"=>$data['visit'],"seminar_training"=>$data['training'],
						"student_activity"=>$data['activity'],"exam_fees"=>$exam_fees,"lab"=>$data['lab'],
						"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>'Y'); 
					}
					if($data['year']<2019)
					{
						$insert_array=array("stream_id"=>$stream_list[$j],"academic_year"=>$data['academic'],
						"admission_year"=>$data['year'],"year"=>$data['yr'],"batch"=>$data['Batch'],"academic_fees"=>$data['academic_fee'],
						"tution_fees"=>$data['Tution'],"development"=>$data['Development'],"caution_money"=>$data['caution_money'],
						"admission_form"=>$data['admission_form'],"Gymkhana"=>$data['khana'],"disaster_management"=>$data['mngmt'],
						"computerization"=>$data['Computer'],"registration"=>$data['Regis'],
						"student_safety_insurance"=>$data['Insur'],"library"=>$data['Libr'],"nss"=>$data['NSS'],
						"total_fees"=>$data['Total'],"exam_fees"=>$exam_fees,
						"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>'Y');   
					}				
                // }
				//print_r($insert_array);exit();
				$DB1->insert("phd_academic_fees", $insert_array);
				$j++;
			}
			//echo $DB1->last_query();exit();
			$last_inserted_id=$DB1->insert_id();                
			return $last_inserted_id;
		}
		else{
			return 'No streams available to enter academic fee details';		
		}
	}
	
	
	function academic_check($stream_list,$academic,$year,$yr){
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select count(academic_fees_id) as Total from phd_academic_fees  where stream_id ='".$stream_list."' and academic_year='".$academic."' and admission_year='".$year."' and year='".$yr."'";
        $query = $DB1->query($sql);
       // echo $DB1->last_query();
        //exit;
        $res = $query->result_array();
        return $res[0]['Total'];
	}
	
	public function add_school_stream_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$school=explode('||',$data['school']);
		//echo "count====".count($data['stream_list']).'<br/>';exit();
		if(count($data['stream_list'])>0)
		{
			$j=0;
			for($i = 1; $i <= count($data['stream_list']); $i++)
			{				
				$insert_array=array("stream_id"=>$data['stream_list'][$j],"school_id"=>$school[0],"school_code"=>$school[1],"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>'Y');
				//print_r($insert_array);exit();
				$DB1->insert("school_stream", $insert_array);
				$j++;
			}
			//echo $DB1->last_query();exit();
			$last_inserted_id=$DB1->insert_id();                
			return $last_inserted_id;
		}
		else
			return 'No streams available to enter school stream details';		
	}
	
	public function edit_academic_fees_submit($data)
	{
		//echo var_dump($data);exit();
		$DB1 = $this->load->database('umsdb', TRUE);
		if($data['year']>=2019)
		{
			$feedetails=array("academic_year"=>$data['academic'],"admission_year"=>$data['year'],"year"=>$data['yr'],
			"batch"=>$data['Batch'],"academic_fees"=>$data['academic_fee'],"tution_fees"=>$data['Tution'],"development"=>$data['Development'],
			"caution_money"=>$data['caution_money'],"admission_form"=>$data['admission_form'],"Gymkhana"=>$data['Gymkhana'],
			"registration"=>$data['Regis'],"student_safety_insurance"=>$data['Insurance'],"library"=>$data['Library'],
			"total_fees"=>$data['Total'],"eligibility"=>$data['eligibility'],"internet"=>$data['internet'],
			"educational_industrial_visit"=>$data['visit'],"seminar_training"=>$data['training'],
			"student_activity"=>$data['activity'],"exam_fees"=>$data['exam_fees'],"lab"=>$data['lab'],
			"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"),"is_active"=>'Y'); 
		}
		if($data['year']<2019)
		{
			$feedetails=array("academic_year"=>$data['academic'],"admission_year"=>$data['year'],"year"=>$data['yr'],
			"batch"=>$data['Batch'],"academic_fees"=>$data['academic_fee'],"tution_fees"=>$data['Tution'],"development"=>$data['Development'],
			"caution_money"=>$data['caution_money'],"admission_form"=>$data['admission_form'],"Gymkhana"=>$data['khana'],
			"disaster_management"=>$data['mngmt'],"computerization"=>$data['Computer'],"registration"=>$data['Regis'],
			"student_safety_insurance"=>$data['Insur'],"library"=>$data['Libr'],"nss"=>$data['NSS'],
			"total_fees"=>$data['Total'],"exam_fees"=>$data['exm_fees'],"modified_by"=>$this->session->userdata("uid"),
			"modified_on"=>date("Y-m-d H:i:s"),"is_active"=>'Y');   
		}
	
		/* $feedetails['academic_year']=$data['academic'];
		$feedetails['year']=$data['year'];
		$feedetails['academic_fees']=$data['academic_fee'];
		$feedetails['tution_fees']=$data['Tution'];
		$feedetails['development']=$data['Development'];
		$feedetails['caution_money']=$data['caution_money'];
		$feedetails['admission_form']=$data['admission_form'];
		$feedetails['Gymkhana']=$data['Gymkhana'];
		$feedetails['disaster_management']=$data['Disaster'];
		$feedetails['computerization']=$data['Computerization'];
		$feedetails['registration']=$data['Registration'];
		$feedetails['student_safety_insurance']=$data['Insurance'];
		$feedetails['library']=$data['Library'];
		$feedetails['nss']=$data['NSS'];
		$feedetails['total_fees']=$data['Total'];
		$feedetails['scholorship_allowed']=$data['Scholorship'];
		$feedetails['modified_on']= date('Y-m-d h:i:s');
		$feedetails['modified_by']= $_SESSION['uid']; */

		$DB1->where('academic_fees_id', $data['fees_id']);
		$DB1->update('phd_academic_fees', $feedetails);
		return $DB1->affected_rows();
	}
	public function enable_academic_fees($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$feedetails['is_active']='Y';
		$feedetails['modified_on']= date('Y-m-d h:i:s');
		$feedetails['modified_by']= $_SESSION['uid'];

		$DB1->where('academic_fees_id', $data);
		$DB1->update('phd_academic_fees', $feedetails);
		return $DB1->affected_rows();
	}
	
	public function edit_check_academicfee_exists($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->distinct();
		$DB1->select("COUNT(academic_fees_id) as count_rows");
		$DB1->from("phd_academic_fees");
			
		$where=array("academic_year"=>$data['academic'],"stream_id"=>$data['stream_id'],"year"=>$data['year']);
		$DB1->where_not_in('academic_fees_id', $data['fees_id']);
		$DB1->where($where);
		
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->row()->count_rows;
	}
	
	public function get_academic_session_details($id='')
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("academic_session.*,");
		$DB1->from("academic_session");
		if($id!='')
		{
			$DB1->where('id', $id);
		}
		$DB1->order_by("academic_session.id", "desc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->result_array();
	}
	
	public function get_academic_year_details($id='')
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("academic_year.*,");
		$DB1->from("academic_year");
		if($id!='')
		{
			$DB1->where('id', $id);
		}
		$DB1->order_by("academic_year.id", "desc");
		$query = $DB1->get();
		return $query->result_array();
	}
	
	public function get_course_details($id='')
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("course_master.*,");
		$DB1->from("course_master");
		if($id!='')
		{
			$DB1->where('course_id', $id);
		}
		$DB1->order_by("course_master.course_id", "desc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->result_array();
	}
	
	public function get_school_details($id='')
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("school_master.*,");
		$DB1->from("school_master");
		if($id!='')
		{
			$DB1->where('school_id', $id);
		}
		$DB1->order_by("school_master.school_id", "desc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->result_array();
	}
	
	public function get_course_category_details($id='')
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("course_category.*,");
		$DB1->from("course_category");
		if($id!='')
		{
			$DB1->where('cr_cat_id', $id);
		}
		$DB1->order_by("course_category.cr_cat_id", "desc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->result_array();
	}
	
	public function get_stream_details($id='')
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("stream_master.*,");
		$DB1->from("stream_master");
		if($id!='')
		{
			$DB1->where('stream_id', $id);
		}
		$DB1->order_by("stream_master.stream_id", "desc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->result_array();
	}
	
	public function get_school_stream_details($data)
	{
		//echo 'id==========='.$data['id'];
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("school_stream.*,stream_master.*,school_master.*,course_master.course_name,course_master.course_short_name");
		$DB1->from("school_stream");
		$DB1->join("school_master", "school_stream.school_id = school_master.school_id");
		$DB1->join("stream_master", "school_stream.stream_id = stream_master.stream_id");
		$DB1->join("course_master", "course_master.course_id = stream_master.course_id");
		
		if(isset($data['id']) && $data['id']!='')
		{
			$DB1->where('school_stream.school_code', $data['id']);
		}
		
		$DB1->order_by("school_stream.school_code,school_stream.stream_id", "desc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->result_array();
	}
	
	public function get_partnership_details($id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("partnership_instutute_details.*,");
		$DB1->from("partnership_instutute_details");
		if($id!='')
		{
			$DB1->where('partner_id', $id);
		}
		$DB1->where('mou_active_status', 'Y');
		$DB1->order_by("partnership_instutute_details.partner_id", "desc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->result_array();
	}
	
	public function get_partnership_streams($id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("stream_master.*,");
		$DB1->from("stream_master");
		if($id!='')
		{
			$DB1->where('partnership_id', $id);
			$DB1->where('is_partnership', 'Y');
		}
		$DB1->order_by("stream_master.stream_id", "desc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->result_array();
	}
	
	public function get_last_stream_no($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		//$DB1->distinct();
		$DB1->select("MAX(stream_no) as stream_no");
		$DB1->from("stream_master");
		$DB1->join("school_stream", "school_stream.stream_id = stream_master.stream_id");
		$where=array("school_stream.school_code"=>$data['sid']);
		$DB1->where($where);
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->row()->stream_no;
	}
	
	public function get_school_id($id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		//$DB1->distinct();
		$DB1->select("school_stream.school_id,school_stream.school_code");
		$DB1->from("school_stream");
		
		$where=array("school_stream.stream_id"=>$id);
		$DB1->where($where);
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->row()->school_id.'||'.$query->row()->school_code;
	}
	
	public function check_academic_session_exists($data)
	{
		if(isset($data['id']) && $data['id']!='')
			$where=" academic_session = '".$data['session']."' and academic_year = '".$data['academic']."' and start_month='".$data['smonth']."' and last_month='".$data['lmonth']."' and id!='".$data['id']."'";
		else
			$where=" academic_session = '".$data['session']."' and academic_year = '".$data['academic']."' and start_month='".$data['smonth']."' and last_month='".$data['lmonth']."'";
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->distinct();
		$DB1->select("COUNT(id) as count_rows");
		$DB1->from("academic_session");
		$DB1->where($where);
		$query = $DB1->get();
		return $query->row()->count_rows;
	}
	
	public function check_academic_year_exists($data)
	{
		if(isset($data['id']) && $data['id']!='')
			$where=" academic_year = '".$data['academic']."' and start_month='".$data['smonth']."' and last_month='".$data['lmonth']."' and id!='".$data['id']."'";
		else
			$where=" academic_year = '".$data['academic']."' and start_month='".$data['smonth']."' and last_month='".$data['lmonth']."'";
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->distinct();
		$DB1->select("COUNT(id) as count_rows");
		$DB1->from("academic_year");
		$DB1->where($where);
		$query = $DB1->get();
		return $query->row()->count_rows;
	}
	
	public function check_course_exists($data)
	{
		if(isset($data['id']) && $data['id']!='')
		$where=" course_name = '".$data['cname']."' and course_short_name='".$data['csname']."' and course_id!='".$data['id']."'";
		else
			$where=" course_name = '".$data['cname']."' and course_short_name='".$data['csname']."'";
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->distinct();
		$DB1->select("COUNT(course_id) as count_rows");
		$DB1->from("course_master");
		$DB1->where($where);
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->row()->count_rows;
	}
	
	public function check_course_cat_exists($data)
	{
		if(isset($data['id']) && $data['id']!='')
			$where=" course_category = '".$data['cname']."' and cr_cat_id!='".$data['id']."'";
		else
			$where=" course_category = '".$data['cname']."'";
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->distinct();
		$DB1->select("COUNT(cr_cat_id) as count_rows");
		$DB1->from("course_category");
		$DB1->where($where);
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->row()->count_rows;
	}
	
	public function check_school_exists($data)
	{
		if(isset($data['id']) && $data['id']!='')
			$where=" start_year = '".$data['syear']."' and school_code='".$data['ccode']."' and school_type='".$data['stype']."' and school_name = '".$data['cname']."' and school_short_name='".$data['ssname']."' and campus='".$data['campus']."' and school_id!='".$data['id']."'";
		else
			$where=" start_year = '".$data['syear']."' and school_code='".$data['ccode']."' and school_type='".$data['stype']."' and school_name = '".$data['cname']."' and school_short_name='".$data['ssname']."' and campus='".$data['campus']."'";
	
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->distinct();
		$DB1->select("COUNT(school_id) as count_rows");
		$DB1->from("school_master");
		$DB1->where($where);
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->row()->count_rows;
	}
	
	public function check_stream_exists($data)
	{
		if(isset($data['id']) && $data['id']!='')
			$where=" start_year = '".$data['syear']."' and stream_code='".$data['ccode']."' and course_id='".$data['course']."' and stream_name = '".$data['cname']."' and stream_short_name='".$data['ssname']."' and course_cat='".$data['category']."' and stream_id!='".$data['id']."'";
		else
			$where=" start_year = '".$data['syear']."' and stream_code='".$data['ccode']."' and course_id='".$data['course']."' and stream_name = '".$data['cname']."' and stream_short_name='".$data['ssname']."' and course_cat='".$data['category']."'";
	
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->distinct();
		$DB1->select("COUNT(stream_id) as count_rows");
		$DB1->from("stream_master");
		$DB1->where($where);
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->row()->count_rows;
	}
	
	public function check_partnership_exists($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->distinct();
		$DB1->select("COUNT(partner_id) as count_rows");
		$DB1->from("partnership_instutute_details");
		if(isset($data['pcode']) && $data['pcode']!='')
			$DB1->where('partnership_code',$data['pcode']);
		if(isset($data['pname']) && $data['pname']!='')
			$DB1->where('partner_name',$data['pname']);
		if(isset($data['id']) && $data['id']!='')
			$DB1->where_not_in('partner_id',$data['id']);
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->row()->count_rows;
	}
	
	public function add_academic_session_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$academic_details['academic_year']=$data['academic'];
		$academic_details['academic_session']=$data['session'];
		$academic_details['start_month']=$data['smonth'];
		$academic_details['last_month']=$data['lmonth'];
		$academic_details['currently_active']='N';
		
		$academic_details['created_on']= date('Y-m-d h:i:s');
		$academic_details['created_by']= $_SESSION['uid'];
		
		$academic=explode("-",$data['academic']);
		if($data['session']=='WINTER')
			$academic_details['session']='W-'.$academic[0];
		else
			$academic_details['session']='S-'.$academic[0];
				
		$DB1->insert("academic_session", $academic_details);
		$last_inserted_id=$DB1->insert_id(); 
		return $last_inserted_id;  
	}
	
	public function edit_academic_session_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$academic_details['academic_year']=$data['academic'];
		$academic_details['academic_session']=$data['session'];
		$academic_details['start_month']=$data['smonth'];
		$academic_details['last_month']=$data['lmonth'];
		$academic_details['currently_active']=$data['active'];
		$academic_details['modified_on']= date('Y-m-d h:i:s');
		$academic_details['modified_by']= $_SESSION['uid'];
		$academic=explode("-",$data['academic']);
		if($data['session']=='WINTER')
			$academic_details['session']='W-'.$academic[0];
		else
			$academic_details['session']='S-'.$academic[0];
		
		$DB1->where('id', $data['aca_id']);
		$DB1->update('academic_session', $academic_details);
		//echo $DB1->last_query();exit();
		return $DB1->affected_rows();  
	}
	
	public function add_academic_year_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$academic_details['academic_year']=$data['academic'];
		$academic_details['start_month']=$data['smonth'];
		$academic_details['last_month']=$data['lmonth'];
		$academic_details['currently_active']='N';
		$academic_details['created_on']= date('Y-m-d h:i:s');
		$academic_details['created_by']= $_SESSION['uid'];
		$academic=explode("-",$data['academic']);
		$academic_details['session']=$academic[0];
		$DB1->insert("academic_year", $academic_details);
		$last_inserted_id=$DB1->insert_id(); 
		return $last_inserted_id;  
	}
	
	public function edit_academic_year_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$academic_details['academic_year']=$data['academic'];
		$academic_details['start_month']=$data['smonth'];
		$academic_details['last_month']=$data['lmonth'];
		$academic_details['currently_active']=$data['active'];
		$academic_details['modified_on']= date('Y-m-d h:i:s');
		$academic_details['modified_by']= $_SESSION['uid'];
		$academic=explode("-",$data['academic']);
		$academic_details['session']=$academic[0];
		
		$DB1->where('id', $data['aca_id']);
		$DB1->update('academic_year', $academic_details);
		return $DB1->affected_rows();  
	}
	
	public function add_course_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$course_details['course_name']=$data['cname'];
		$course_details['course_short_name']=$data['csname'];
		$course_details['is_active']='Y';
		$course_details['created_on']= date('Y-m-d h:i:s');
		$course_details['created_by']= $_SESSION['uid'];
		$DB1->insert("course_master", $course_details);
		$last_inserted_id=$DB1->insert_id(); 
		return $last_inserted_id;  
	}
	
	public function edit_course_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$course_details['course_name']=$data['cname'];
		$course_details['course_short_name']=$data['csname'];
		$course_details['is_active']=$data['active'];
		$course_details['modified_on']= date('Y-m-d h:i:s');
		$course_details['modified_by']= $_SESSION['uid'];
		$DB1->where('course_id', $data['c_id']);
		$DB1->update('course_master', $course_details);
		return $DB1->affected_rows();  
	}
	
	public function add_course_category_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$course_details['course_category']=$data['cname'];
		$course_details['is_active']='Y';
		$course_details['created_on']= date('Y-m-d h:i:s');
		$course_details['created_by']= $_SESSION['uid'];
		$DB1->insert("course_category", $course_details);
		$last_inserted_id=$DB1->insert_id(); 
		return $last_inserted_id;  
	}
	
	public function edit_course_category_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$course_details['course_category']=$data['cname'];
		$course_details['is_active']=$data['active'];
		$course_details['modified_on']= date('Y-m-d h:i:s');
		$course_details['modified_by']= $_SESSION['uid'];
		$DB1->where('cr_cat_id', $data['c_id']);
		$DB1->update('course_category', $course_details);
		return $DB1->affected_rows(); 
	}
	
	public function add_school_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$school_details['start_year']=$data['syear'];
		$school_details['school_code']=$data['ccode'];
		$school_details['school_name']=$data['cname'];
		$school_details['school_short_name']=$data['ssname'];
		$school_details['campus']=$data['campus'];
		$school_details['school_type']=$data['stype'];
		$school_details['contact_person']=$data['cperson'];
		$school_details['school_address']=$data['saddress'];
		$school_details['district']=$data['district'];
		$school_details['state']=$data['state'];
		$school_details['country']=$data['country'];
		$school_details['pincode']=$data['pincode'];
		$school_details['contact_no']=$data['contact'];
		$school_details['mobile_no']=$data['contact'];
		$school_details['school_email']=$data['semail'];
		$school_details['contact_email']=$data['cemail'];
		$school_details['is_active']='Y';
		$school_details['created_on']= date('Y-m-d h:i:s');
		$school_details['created_by']= $_SESSION['uid'];
		$DB1->insert("school_master", $school_details);
		$last_inserted_id=$DB1->insert_id(); 
		return $last_inserted_id;  
	}
	
	public function edit_school_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$school_details['start_year']=$data['syear'];
		$school_details['school_code']=$data['ccode'];
		$school_details['school_name']=$data['cname'];
		$school_details['school_short_name']=$data['ssname'];
		$school_details['campus']=$data['campus'];
		$school_details['school_type']=$data['stype'];
		$school_details['contact_person']=$data['cperson'];
		$school_details['school_address']=$data['saddress'];
		$school_details['district']=$data['district'];
		$school_details['state']=$data['state'];
		$school_details['country']=$data['country'];
		$school_details['pincode']=$data['pincode'];
		$school_details['contact_no']=$data['contact'];
		$school_details['mobile_no']=$data['contact'];
		$school_details['school_email']=$data['semail'];
		$school_details['contact_email']=$data['cemail'];
		$school_details['is_active']=$data['active'];
		$school_details['modified_on']= date('Y-m-d h:i:s');
		$school_details['modified_by']= $_SESSION['uid'];
		$DB1->where('school_id', $data['s_id']);
		$DB1->update('school_master', $school_details);
		return $DB1->affected_rows();
	}
	
	public function add_stream_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$stream_details['start_year']=$data['syear'];
		$stream_details['stream_code']=$data['ccode'];
		$stream_details['stream_name']=$data['cname'];
		$stream_details['specialization']=$data['specialization'];
		$stream_details['degree_specialization']=$data['Degree_name'];
		$stream_details['gradesheet_name']=$data['gradesheet_name'];
		$stream_details['stream_short_name']=$data['ssname'];
		$stream_details['stream_no']=$data['sno'];
		$stream_details['programme_code']=$data['pcode'];
		$stream_details['course_id']=$data['course'];
		$stream_details['course_duration']=$data['duration'];
		$stream_details['course_cat']=$data['category'];
		//$stream_details['min_que']=$data['qua'];
		$stream_details['is_partnership']=$data['partnership'];
		$stream_details['partnership_id']=$data['partner'];
		$stream_details['course_pattern']=$data['pattern'];
		//$stream_details['prn_series']=$data['prn_series'];
		$stream_details['is_active']='N';
		$stream_details['created_on']= date('Y-m-d h:i:s');
		$stream_details['created_by']= $_SESSION['uid'];
		$DB1->insert("stream_master", $stream_details);
		//echo $DB1->last_query();exit();
		$last_inserted_id=$DB1->insert_id(); 
		
		$school=explode('||',$data['school']);
		$school_stream_details['school_id']=$school[0];
		$school_stream_details['school_code']=$school[1];
		$school_stream_details['stream_id']=$last_inserted_id;
		$school_stream_details['is_active']='Y';
		$DB1->insert("school_stream", $school_stream_details);
		//echo $DB1->last_query();exit();
		$last_inserted_id=$DB1->insert_id(); 
		
		return $last_inserted_id; 
	}
	
	public function edit_stream_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$stream_details['start_year']=$data['syear'];
		$stream_details['stream_code']=$data['ccode'];
		$stream_details['stream_name']=$data['cname'];
		$stream_details['specialization']=$data['specialization'];
		$stream_details['degree_specialization']=$data['Degree_name'];
		$stream_details['gradesheet_name']=$data['gradesheet_name'];
		$stream_details['stream_short_name']=$data['ssname'];
		$stream_details['stream_no']=$data['sno'];
		$stream_details['programme_code']=$data['pcode'];
		$stream_details['course_id']=$data['course'];
		$stream_details['course_pattern']=$data['pattern'];
		$stream_details['course_duration']=$data['duration'];
		$stream_details['course_cat']=$data['category'];
		//$stream_details['min_que']=$data['qua'];
		$stream_details['is_partnership']=$data['partnership'];
		$stream_details['partnership_id']=$data['partner'];
		//$stream_details['prn_series']=$data['prn_series'];
		//$stream_details['is_active']=$data['active'];
		$stream_details['modified_on']= date('Y-m-d h:i:s');
		$stream_details['modified_by']= $_SESSION['uid'];
		$DB1->where('stream_id', $data['id']);
		$DB1->update('stream_master', $stream_details);
		$sm=$DB1->affected_rows();
		
		$school=explode('||',$data['school']);
		$school_stream_details['school_id']=$school[0];
		$school_stream_details['school_code']=$school[1];
		
		$DB1->where('stream_id', $data['id']);
		$DB1->update('school_stream', $school_stream_details);
		$ss=$DB1->affected_rows();
		if($sm)
			return $sm;
		if($ss)
			return $ss;
		
	}
	
	public function getAllState()
	{
	    $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT * from states order by state_name";
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	
	function add_partnership_submit($data, $payfile)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$feedet['partnership_code']=$data['pcode'];
		$feedet['partner_name']=$data['pname'];
		$feedet['contact_person']=$data['cperson'];
		//$feedet['type_id']=1;
		$feedet['contact_person_email']=$data['pemail'];
		$feedet['office_email']= $data['oemail'];
		$feedet['address']=$data['address'];
		$feedet['mobile']=$data['mobile'];
		$feedet['country']=$data['country'];
		$feedet['pincode']=$data['pincode'];
		$feedet['taluka_id']=$data['hcity'];
		$feedet['district_id']=$data['hdistrict_id']; 
		$feedet['state_id']=$data['hstate_id'];
		$feedet['country']=$data['country'];
		$feedet['pincode']=$data['pincode'];
		$feedet['first_party_person']=$data['fparty'];
		$feedet['third_party_person']= $data['sparty'];
		
		$feedet['mou_done_place']=$data['place'];
		$feedet['mou_sign_date']=$data['fdate']; 
		$feedet['mou_start_date']=$data['sdate'];
		$feedet['mou_expiray_date']=$data['edate'];
		$feedet['mou_sharing_ratio']=$data['r1'].':'.$data['r2'];
		$feedet['mou_share_factor']=$data['factor'];
		$feedet['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['created_on']= date('Y-m-d h:i:s');
		$feedet['created_by']= $_SESSION['uid'];

		if($payfile !=''){
			$feedet['mou_document_file']=$payfile;
		}
		$DB1->insert("partnership_instutute_details", $feedet); 
		
		//echo $DB1->last_query();exit();
		$last_inserted_id=$DB1->insert_id();                
		return $last_inserted_id;	
	}
	
	function edit_partnership_submit($data, $payfile)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$feedet['partnership_code']=$data['pcode'];
		$feedet['partner_name']=$data['pname'];
		$feedet['contact_person']=$data['cperson'];
		//$feedet['type_id']=1;
		$feedet['contact_person_email']=$data['pemail'];
		$feedet['office_email']= $data['oemail'];
		$feedet['address']=$data['address'];
		$feedet['mobile']=$data['mobile'];
		$feedet['country']=$data['country'];
		$feedet['pincode']=$data['pincode'];
		$feedet['taluka_id']=$data['hcity'];
		$feedet['district_id']=$data['hdistrict_id']; 
		$feedet['state_id']=$data['hstate_id'];
		$feedet['country']=$data['country'];
		$feedet['pincode']=$data['pincode'];
		$feedet['first_party_person']=$data['fparty'];
		$feedet['third_party_person']= $data['sparty'];
		
		$feedet['mou_done_place']=$data['place'];
		$feedet['mou_sign_date']=$data['fdate']; 
		$feedet['mou_start_date']=$data['sdate'];
		$feedet['mou_expiray_date']=$data['edate'];
		$feedet['mou_sharing_ratio']=$data['r1'].':'.$data['r2'];
		$feedet['mou_share_factor']=$data['factor'];
		$feedet['modify_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['modify_on']= date('Y-m-d h:i:s');
		$feedet['modify_by']= $_SESSION['uid'];

		if($payfile !=''){
			$feedet['mou_document_file']=$payfile;
		}
		
		$DB1->where('partner_id', $data['pid']);
		$DB1->update("partnership_instutute_details", $feedet); 
		//echo $DB1->last_query();exit();
		return $DB1->affected_rows();	
	}
	//
	public function get_schoolwise_stream_details($school_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("stream_name, stream_short_name, school_name,stream_code,specialization,gradesheet_name,start_year,course_pattern,course_duration");
		$DB1->from("vw_stream_details");
		$where=array("is_active"=>'Y', "school_id"=>$school_id);
		$DB1->where('gradesheet_name is NOT NULL', NULL, FALSE);
		$DB1->where($where);
		$DB1->order_by("school_id", "asc");
		$DB1->order_by("course_short_name", "asc");
		$DB1->order_by("stream_id", "asc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->result_array();
	}
	function get_school_details_forstream()
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT distinct school_id, school_name FROM `vw_stream_details` WHERE `is_active` = 'Y' ORDER BY `school_id`";
		//echo $sql;exit;
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}
}

?>