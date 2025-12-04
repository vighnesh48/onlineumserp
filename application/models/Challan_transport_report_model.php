<?php
class Challan_transport_report_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
       
    }
	public function fees_challan_list($data)
	{
		$uid=$this->session->userdata("uid");
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.vw_stream_details.stream_name,`sandipun_erp`.`sf_bank_account_details`.`bank_name`,`sandipun_erp`.`sf_bank_account_details`.branch_name,sandipun_ums.bank_master.bank_name as stud_bankname, sandipun_erp.sf_bank_account_details.account_name,sandipun_erp.sf_bank_account_details.account_no,sandipun_erp.sf_student_facilities.organisation,");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no_new=sandipun_erp.sf_fees_challan.enrollment_no 
		OR `sandipun_ums`.`student_master`.`enrollment_no`=`sandipun_erp`.`sf_fees_challan`.`enrollment_no` 
		AND sandipun_ums.student_master.stud_id=sandipun_erp.sf_fees_challan.student_id","INNER");
		$this->db->join("sandipun_erp.sf_student_facilities","sandipun_erp.sf_student_facilities.enrollment_no = sandipun_erp.sf_fees_challan.enrollment_no");
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = sandipun_erp.sf_fees_challan.bank_id",'left');
		
		$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = sandipun_erp.sf_fees_challan.bank_account_id");
		$this->db->join("sandipun_ums.vw_stream_details","sandipun_ums.vw_stream_details.stream_id = sandipun_ums.student_master.admission_stream",'left');
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		if(isset($data['odate']) && $data['odate']!='')
		
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));

		}
		
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_paid_type', $data['status']);
		}
		if(isset($data['acyear']) && $data['acyear']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.academic_year', $data['acyear']);
		}
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_erp.sf_fees_challan.type_id', '2');
		$this->db->where('sandipun_erp.sf_fees_challan.created_by', $uid);
        $this->db->where('sandipun_ums.student_master.actice_status', 'Y');
		
		
	  //  $this->db->order_by("sandipun_erp.sf_fees_challan.fees_id", "ASC");




		$query1 = $this->db->get_compiled_select();
		
		
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_erp.sf_student_master.instute_name as school_name,sandipun_erp.sf_student_master.first_name,sandipun_erp.sf_student_master.middle_name,sandipun_erp.sf_student_master.last_name,sandipun_erp.sf_student_master.course as stream_name,`sandipun_erp`.`sf_bank_account_details`.`bank_name`,`sandipun_erp`.`sf_bank_account_details`.branch_name,sandipun_ums.bank_master.bank_name as stud_bankname, sandipun_erp.sf_bank_account_details.account_name,sandipun_erp.sf_bank_account_details.account_no,sandipun_erp.sf_student_facilities.organisation,");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_erp.sf_student_master","sandipun_erp.sf_student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no AND sandipun_erp.sf_student_master.student_id=sandipun_erp.sf_fees_challan.student_id","INNER");
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = sandipun_erp.sf_fees_challan.bank_id",'left');
		$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = sandipun_erp.sf_fees_challan.bank_account_id");
		$this->db->join("sandipun_erp.sf_student_facilities","sandipun_erp.sf_student_facilities.enrollment_no = sandipun_erp.sf_fees_challan.enrollment_no");
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date >=', date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date <=', date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		if(isset($data['odate']) && $data['odate']!='')
		
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));

		}
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_paid_type', $data['status']);
		}
		if(isset($data['acyear']) && $data['acyear']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.academic_year', $data['acyear']);
		}
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_erp.sf_fees_challan.type_id', '2');
		$this->db->where('sandipun_erp.sf_fees_challan.created_by', $uid);
		$this->db->where('sandipun_erp.sf_student_master.isactive', 'Y');
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
        $this->db->where('sandipun_erp.sf_student_master.organization', 'SF-SIJOUL');
        }
		
		//$this->db->order_by("sandipun_erp.sf_fees_challan.fees_id", "ASC");
		
		
		$query2 = $this->db->get_compiled_select();
		
	   //$this->db->order_by("sandipun_erp.sf_fees_challan.fees_id", "DESC");
		
		if($exp[1]=="sijoul")
        {
              $query = $this->db->query($query2);
        }else{
		$query = $this->db->query($query1." UNION ".$query2);
		}
		
		
		//echo $this->db->last_query();exit();
		return $query->result_array();
		
	}
	///daily list


	public function fees_challan_list_daily($data)
	{
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_ums.student_master.first_name,
			sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,
			sandipun_ums.stream_master.stream_name,sandipun_ums.student_master.current_year,
			sandipun_ums.student_master.academic_year,sandipun_ums.bank_master.bank_name as student_bank,sandipun_erp.bank_master.bank_name as su_bank_name,sandipun_ums.stream_master.stream_short_name");
		$this->db->from("sandipun_erp.sf_fees_challan");
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_ums.fees_challan.enrollment_no OR sandipun_ums.student_master.enrollment_no_new=sandipun_ums.fees_challan.enrollment_no",'left');
	
		//$this->db->join("sandipun_ums.admission_details","sandipun_ums.admission_details.student_id=sandipun_ums.student_master.stud_id",'inner');
		$this->db->join("sandipun_ums.stream_master","sandipun_ums.stream_master.stream_id=sandipun_ums.student_master.admission_stream",'left');
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.fees_challan.bank_id=sandipun_ums.bank_master.bank_id",'left');
		$this->db->join("sandipun_erp.bank_master","sandipun_ums.fees_challan.bank_account_id=sandipun_erp.bank_master.bank_id",'left');
		
		
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('DATE(sandipun_ums.fees_challan.created_on) >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('DATE(sandipun_ums.fees_challan.created_on) <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		if(isset($data['odate']) && $data['odate']!='')
		
		{
			$this->db->where('DATE(sandipun_ums.fees_challan.created_on)',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));

		}
		
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.fees_paid_type', $data['status']);
		}
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_ums.fees_challan.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		$this->db->where('sandipun_ums.fees_challan.is_deleted', 'N');
		$this->db->order_by("sandipun_ums.fees_challan.fees_id", "DESC");

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
		/*echo $this->db->last_query(); 
		exit();*/
		return $query->result_array();
	}//end of

	public function fees_challan_list_pdf($data)
	{
		$uid=$this->session->userdata("uid");
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.vw_stream_details.stream_name,`sandipun_erp`.`sf_bank_account_details`.`bank_name`,`sandipun_erp`.`sf_bank_account_details`.branch_name,sandipun_ums.bank_master.bank_name as stud_bankname, sandipun_erp.sf_bank_account_details.account_name,sandipun_erp.sf_bank_account_details.account_no,sandipun_ums.student_master.current_year,sandipun_erp.sf_student_facilities.organisation,");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no_new=sandipun_erp.sf_fees_challan.enrollment_no 
		OR `sandipun_ums`.`student_master`.`enrollment_no`=`sandipun_erp`.`sf_fees_challan`.`enrollment_no` 
		AND sandipun_ums.student_master.stud_id=sandipun_erp.sf_fees_challan.student_id","INNER");
		$this->db->join("sandipun_erp.sf_student_facilities","sandipun_erp.sf_student_facilities.enrollment_no = sandipun_erp.sf_fees_challan.enrollment_no");
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = sandipun_erp.sf_fees_challan.bank_id",'left');		
		$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = sandipun_erp.sf_fees_challan.bank_account_id");
		$this->db->join("sandipun_ums.vw_stream_details","sandipun_ums.vw_stream_details.stream_id = sandipun_ums.student_master.admission_stream",'left');

		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_erp.sf_fees_challan.type_id', '2');
		$this->db->where('sandipun_erp.sf_fees_challan.created_by', $uid);
        $this->db->where('sandipun_ums.student_master.actice_status', 'Y');
		$this->db->where('DATE(sandipun_erp.sf_fees_challan.created_on)=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['selectdate']))));

		
	  //  $this->db->order_by("sandipun_erp.sf_fees_challan.fees_id", "ASC");




		$query1 = $this->db->get_compiled_select();
		
		
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_erp.sf_student_master.instute_name as school_name,sandipun_erp.sf_student_master.enrollment_no,sandipun_erp.sf_student_master.first_name,sandipun_erp.sf_student_master.middle_name,sandipun_erp.sf_student_master.last_name,sandipun_erp.sf_student_master.course as stream_name,`sandipun_erp`.`sf_bank_account_details`.`bank_name`,`sandipun_erp`.`sf_bank_account_details`.branch_name,sandipun_ums.bank_master.bank_name as stud_bankname, sandipun_erp.sf_bank_account_details.account_name,sandipun_erp.sf_bank_account_details.account_no,sandipun_erp.sf_student_master.current_year,sandipun_erp.sf_student_facilities.organisation,");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_erp.sf_student_master","sandipun_erp.sf_student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no AND sandipun_erp.sf_student_master.student_id=sandipun_erp.sf_fees_challan.student_id","INNER");
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = sandipun_erp.sf_fees_challan.bank_id",'left');
		$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = sandipun_erp.sf_fees_challan.bank_account_id");
		$this->db->join("sandipun_erp.sf_student_facilities","sandipun_erp.sf_student_facilities.enrollment_no = sandipun_erp.sf_fees_challan.enrollment_no");
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_erp.sf_fees_challan.type_id', '2');
		$this->db->where('sandipun_erp.sf_fees_challan.created_by', $uid);
		$this->db->where('sandipun_erp.sf_student_master.isactive', 'Y');
		$this->db->where('DATE(sandipun_erp.sf_fees_challan.created_on)=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['selectdate']))));

		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
        $this->db->where('sandipun_erp.sf_student_master.organization', 'SF-SIJOUL');
        }
		
		//$this->db->order_by("sandipun_erp.sf_fees_challan.fees_id", "ASC");
		
		$query2 = $this->db->get_compiled_select();
		
	   //$this->db->order_by("sandipun_erp.sf_fees_challan.fees_id", "DESC");
		
		if($exp[1]=="sijoul")
        {
              $query = $this->db->query($query2);
        }else{			
		$query = $this->db->query($query1." UNION ".$query2);
		}
		
		//echo $this->db->last_query(); 
		//exit();
		return $query->result_array();
	}



	public function fees_challan_list_today($data)
	{
			$this->db->select("sum(amount) as amt,fees_paid_type");
			$this->db->from('sf_fees_challan');
			$this->db->where('type_id', 2);
			$this->db->where('DATE(sf_fees_challan.created_on)=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['selectdate']))));
			$this->db->group_by('fees_paid_type');
			$query=$this->db->get();
			/*  echo $this->db->last_query();
			die();  */ 
			$result=$query->result_array();
			return $result;
		
	}
	
	public function get_facility_types()
	{
		$this->db->select("*");
		$this->db->from("sf_facility_types");
		$this->db->where('status', 'Y');
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
		public function get_academic_details()
	{
		$sql="select * From sf_academic_year";
		$query = $this->db->query($sql);
		return  $query->result_array();
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
	
	function students_data($data)
	{
		$this->db->select("sm.current_year,sm.mobile,sm.admission_session,sm.first_name,sm.middle_name,sm.last_name,sm.academic_year,sm.enrollment_no,sm.stud_id,
		sm.admission_stream,vw.stream_short_name as stream_name,vw.course_short_name as course_name, vw.school_short_name as school_name,");
		$this->db->from("sandipun_ums.student_master sm");
		
		$this->db->join("sandipun_ums.vw_stream_details vw", "sm.admission_stream = vw.stream_id");
		$this->db->where('sm.enrollment_no', $data['enrollment_no']);

		$query1 = $this->db->get();
			return $query1->row_array();
	
		
		
	}
	
	public function fees_challan_list_byid($id)
	{
		
		$this->db->select("fee.*,sm.current_year,sm.mobile,sm.first_name,sm.middle_name,sm.last_name,sm.academic_year as sacademic_year,sm.enrollment_no,sm.stud_id,
		sm.admission_stream,vw.stream_name as stream_name,vw.course_short_name as course_name, vw.school_short_name as school_name,
		sandipun_erp.bank_master.bank_id, 
		sandipun_erp.bank_master.bank_name, 
		sandipun_erp.bank_master.account_name,
		sandipun_erp.bank_master.bank_account_no as account_no,
		sandipun_erp.bank_master.clinet_id,
		sandipun_erp.bank_master.branch_name,
		sandipun_erp.bank_master.bank_code,
		sandipun_ums.bank_master.bank_name as ubank_name
		");
		$this->db->from("sandipun_ums.fees_challan fee");
		
		$this->db->join("sandipun_ums.student_master sm","sm.enrollment_no=fee.enrollment_no",'left');
		$this->db->join("sandipun_ums.vw_stream_details vw", "sm.admission_stream = vw.stream_id",'left');
		$this->db->join("sandipun_erp.bank_master","sandipun_erp.bank_master.bank_id = fee.bank_account_id",'left');
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = fee.bank_id",'left');
		//$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = fee.bank_account_id");
		$this->db->where('fee.is_deleted', 'N');
		$this->db->where('fee.fees_id', $id);

		$query1 = $this->db->get();
		//echo $this->db->last_query(); //exit();
			return $query1->row_array();
	}
	
	public function get_depositedto()
	{
		$this->db->select("*");
		$this->db->from("bank_master");
		$this->db->where('status','Y');
		//$this->db->where('account_for',$data['faci_type']);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
		
	public function get_fee_details($data)
	{
		$session=$this->session->userdata('logged_in');
		//echo '<pre>';print_r($session);
		$uid=$session['uid'];
		$name=$session['name'];
		
		//#AND fd.type_id= '".$data['facility']."'
			$DB1 = $this->load->database('umsdb', TRUE);
			$current=date('Y');
			$admission_session=$data['admission_session'];
			$new=$current - $data['admission_session'];
			
			if($new==0){
			$curr_yr=$data['curr_yr'];	
			}else{
            $curr_yr=0;
			}
				if(($data['stud']=="2646")){
				$curr_yr=0;
			}		
			$admi_seesion=$data['admission_session'];
			$datt=date('Y', strtotime('+1 year'));
			$year_new=substr($data['academic'],2);
			$newadd=$year_new + 1;
			$new_year=$data['academic'].'-'.$newadd; //$datt[2].$datt[3];
            /*if(($data['stud']=="2646")&&($new_year=="2019-20")){
				$curr_yr=0;
			}*/




	$sql="select sum(fd.amount) as amount_paid,ad.applicable_fee,ad.actual_fee,ad.opening_balance,
		af.academic_fees,af.tution_fees,af.development,af.caution_money,af.admission_form,af.Gymkhana,af.disaster_management,
		af.student_safety_insurance,af.internet,af.library,af.registration,af.eligibility,af.educational_industrial_visit,
		af.seminar_training,af.exam_fees,af.student_activity,af.lab,af.computerization,af.nss
		FROM `admission_details` as `ad`
		 left JOIN `fees_details` as `fd` ON `ad`.`student_id` = `fd`.`student_id`  
		 And ad.academic_year=fd.academic_year And fd.type_id= '".$data['facility']."' 
		 
		LEFT JOIN academic_fees af ON  ad.stream_id=af.stream_id AND af.academic_year='".$new_year."' AND af.admission_year='".$data['admission_session']."' 
		AND af.year='".$curr_yr."'
		WHERE  `ad`.`student_id` = '".$data['stud']."'
		
		AND ad.academic_year =  '".$data['academic']."'
		AND `ad`.`cancelled_admission` = 'N'";//AND ad.academic_year =  '".$data['academic']."'
	
		$query = $DB1->query($sql);
		if($this->session->userdata("uid")==2){
		//echo $DB1->last_query(); //af.admission_year=ad.academic_year AND
		}
		return $query->row_array();
	}
	

	public function fee_details($data){
		
			$DB1 = $this->load->database('umsdb', TRUE);
			$sql="SELECT *,type_id AS ntype_id FROM fees_challan WHERE academic_year ='".$data['academic']."' AND student_id = '".$data['stud']."'
			AND type_id= '".$data['facility']."' AND enrollment_no='".$data['enroll']."' AND challan_status!='CL'  ORDER BY fees_id DESC limit 0,1";
			$query = $DB1->query($sql);
		    $DB1->last_query();
		    return $query->row_array();
			
	}
	
	
		public function add_fees_challan_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->insert("fees_challan", $data); 
		//echo $DB1->last_query();exit();kamlesh@k
		$last_inserted_id=$DB1->insert_id();                
		return $last_inserted_id;
	}
	
	public function add_into_fees_details($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->insert("fees_details", $data); 
		//echo $DB1->last_query();exit();
		$last_inserted_id=$DB1->insert_id();                
		return $last_inserted_id;
	}
	
	public function update_challan_no($id,$data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->where('fees_id', $id);
		$DB1->update("fees_challan", $data);
		//echo $this->db->last_query();exit();
		return $DB1->affected_rows();
	}
	
	
	public function check_current($data){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT count(paid_id) as Total FROM paid_fees WHERE  student_id='".$data['stud']."' AND enroll_no='".$data['enroll']."' AND facility='".$data['facility']."' AND curr_yr='".$data['curr_yr']."' AND academic_year='".$data['academic']."'";
		$query = $DB1->query($sql);
		 $DB1->last_query();
		return $query->result_array();
	}
	
	public function get_paid_details($data){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT * FROM paid_fees WHERE  student_id='".$data['stud']."' AND enroll_no='".$data['enroll']."' AND facility='".$data['facility']."' AND curr_yr='".$data['curr_yr']."' AND academic_year='".$data['academic']."'";
		$query = $DB1->query($sql);
		 $DB1->last_query();
		return $query->result_array();
	}
	
		
	
	public function Check_challan($data){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT * FROM fees_challan WHERE  student_id='".$data['stud']."' AND enrollment_no='".$data['enroll']."' AND 
		type_id='".$data['facility']."' AND academic_year='".$data['academic']."' ORDER BY fees_id DESC limit 0,1";
		$query = $DB1->query($sql);
		 $DB1->last_query();
		return $query->result_array();
	}

	public function examfees_challan_list($data,$examid)
	{


		$this->db->select("sandipun_ums.fees_challan.*,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,");
		$this->db->from("sandipun_ums.fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_ums.fees_challan.enrollment_no OR sandipun_ums.student_master.enrollment_no_new=sandipun_ums.fees_challan.enrollment_no",'inner');
	
		$this->db->where('sandipun_ums.fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_ums.fees_challan.type_id', '5');
		$this->db->where('sandipun_ums.fees_challan.exam_id', $examid);
		$query = $this->db->get();
		//echo $this->db->last_query(); 
		//exit();
		return $query->result_array();
	}
	function challan_rec_list(){
		//$DB1 = $this->load->database('umsdb', TRUE);
		$sql="SELECT fees_paid_type FROM sf_fees_challan where fees_paid_type !='' and type_id=2 GROUP BY fees_paid_type";
		$query = $this->db->query($sql);
		return  $query->result_array();
	}
	
	
	
	
 
}