<?php
class International_recepit_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
       
    }
	public function fees_challan_list($data)
	{
		$this->db->select("sandipun_ums.fees_challan.*,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,");
		$this->db->from("sandipun_ums.fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_ums.fees_challan.enrollment_no OR sandipun_ums.student_master.enrollment_no_new=sandipun_ums.fees_challan.enrollment_no ",'left');
		
		/*if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.fees_date >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('sandipun_ums.fees_challan.fees_date <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		
		if(isset($data['odate']) && $data['odate']!='')
		
		{
			$this->db->where('sandipun_ums.fees_challan.fees_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));

		}*/
		//$this->db->where('sandipun_ums.fees_challan.fees_date', date("Y-m-d"));
		
		//$this->db->where('sandipun_ums.fees_challan.fees_date >=','2019-01-01');
      //  $this->db->where('sandipun_ums.fees_challan.fees_date <=', date("Y-m-d"));
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.challan_status', $data['status']);
		}else{
			$this->db->where('sandipun_ums.fees_challan.challan_status', 'PD');
		}
		
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		
		$this->db->where('sandipun_ums.fees_challan.is_deleted', 'N');
		$this->db->order_by("sandipun_ums.fees_challan.fees_id", "DESC");

		//$query1 = $this->db->get_compiled_select();
		
		/*$this->db->select("sandipun_ums.fees_challan.*,sandipun_erp.sf_student_master.first_name,sandipun_erp.sf_student_master.middle_name,sandipun_erp.sf_student_master.last_name,");
		$this->db->from("sandipun_ums.fees_challan");
		
		$this->db->join("sandipun_erp.sf_student_master","sandipun_erp.sf_student_master.enrollment_no=sandipun_ums.fees_challan.enrollment_no");
		
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.fees_date >=', date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('sandipun_ums.fees_challan.fees_date <=', date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		if(isset($data['odate']) && $data['odate']!='')
		
		{
			$this->db->where('sandipun_ums.fees_challan.fees_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));

		}
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.challan_status', $data['status']);
		}
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		$this->db->where('sandipun_ums.fees_challan.is_deleted', 'N');
		//$this->db->order_by("sandipun_ums.fees_challan.fees_id", "DESC");

		$query2 = $this->db->get_compiled_select();*/
		$query = $this->db->get();
		//$query = $this->db->query($query1);//." UNION ".$query2
		//echo $this->db->last_query(); //exit();
		return $query->result_array();
	}


	public function fees_challan_internationlist($data)
	{
		$this->db->select("sandipun_ums.fees_challan_internationl.*,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,");
		$this->db->from("sandipun_ums.fees_challan_internationl");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_ums.fees_challan_internationl.enrollment_no",'left');
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('sandipun_ums.fees_challan_internationl.fees_date >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('sandipun_ums.fees_challan_internationl.fees_date <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		if(isset($data['odate']) && $data['odate']!='')
		
		{
			$this->db->where('sandipun_ums.fees_challan_internationl.fees_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));

		}
		
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_ums.fees_challan_internationl.challan_status', $data['status']);
		}
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_ums.fees_challan_internationl.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		$this->db->where('sandipun_ums.fees_challan_internationl.is_deleted', 'N');
		$this->db->order_by("sandipun_ums.fees_challan_internationl.fees_id", "DESC");

		$query1 = $this->db->get_compiled_select();
		
		/*$this->db->select("sandipun_ums.fees_challan.*,sandipun_erp.sf_student_master.first_name,sandipun_erp.sf_student_master.middle_name,sandipun_erp.sf_student_master.last_name,");
		$this->db->from("sandipun_ums.fees_challan");
		
		$this->db->join("sandipun_erp.sf_student_master","sandipun_erp.sf_student_master.enrollment_no=sandipun_ums.fees_challan.enrollment_no");
		
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.fees_date >=', date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('sandipun_ums.fees_challan.fees_date <=', date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		if(isset($data['odate']) && $data['odate']!='')
		
		{
			$this->db->where('sandipun_ums.fees_challan.fees_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));

		}
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.challan_status', $data['status']);
		}
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		$this->db->where('sandipun_ums.fees_challan.is_deleted', 'N');
		//$this->db->order_by("sandipun_ums.fees_challan.fees_id", "DESC");

		$query2 = $this->db->get_compiled_select();*/
		
		$query = $this->db->query($query1);//." UNION ".$query2
		//echo $this->db->last_query(); //exit();
		return $query->result_array();
	}
	
	
	public function Get_country()
	{	$DB2 = $this->load->database('umsdb', TRUE);
		$DB2->select("*");
		$DB2->from("countries");
		//$this->db->where('status', 'Y');
		$query = $DB2->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
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
	
		public function get_academic_details()
	{
		$sql="select * From sf_academic_year";
		$query = $this->db->query($sql);
		return  $query->result_array();
	}

	public function get_academic_feesdetails($data)
	{
		$DB2 = $this->load->database('umsdb', TRUE);
		$DB2->select("*");
		$DB2->from("academic_fees");
		
		//$this->db->join("sandipun_ums.vw_stream_details vw", "sm.admission_stream = vw.stream_id");
		$DB2->where('stream_id', $data['admission_stream']);
        $DB2->where("admission_year",$data['academic']);
        $DB2->where("year",$data['curr_yr']);
		$query1 = $DB2->get();
		//echo $DB2->last_query();
		//die;
		return $query1->row_array();
	}
	
	
	
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}