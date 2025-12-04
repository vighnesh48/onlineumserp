<?php
class Fees_challan_model extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
		//error_reporting(E_ALL);
		//ini_set('display_errors', 1);
    }
	
	function students_data($data)
	{
		$this->db->select("sandipun_erp.sf_student_facilities.organisation,sandipun_ums.student_master.current_year,sandipun_ums.student_master.mobile,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.student_master.academic_year,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,sandipun_ums.student_master.admission_stream,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name, sandipun_ums.vw_stream_details.school_short_name as school_name,");
		$this->db->from("sandipun_ums.student_master");
		
		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no");
		
		$this->db->where('sandipun_ums.student_master.enrollment_no', $data['enrollment_no']);

		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("ssf.organisation,sm.current_year,sm.mobile,sm.first_name,sm.middle_name,sm.last_name,sm.academic_year,sm.enrollment_no,sm.student_id as stud_id,sm.program_id as admission_stream, spd.branch_short_name as stream_name, spd.course_name, spd.college_name as school_name,");
		$this->db->from("sandipun_erp.sf_student_master sm");
		$this->db->join('sandipun_erp.sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		$this->db->join('sandipun_erp.sf_student_facilities as ssf','ssf.enrollment_no = sm.enrollment_no','left');
		$this->db->where('sm.enrollment_no', $data['enrollment_no']);
        
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1." UNION ".$query2);
		//echo $this->db->last_query();exit();
		return $query->row_array();
		
	}
	
	public function fees_challan_list_byid($id)
	{
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_ums.student_master.current_year,sandipun_ums.student_master.mobile,sandipun_ums.student_master.academic_year,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,sandipun_ums.student_master.admission_stream,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name, sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_ums.bank_master.bank_name, sandipun_erp.sf_bank_account_details.account_name,sandipun_erp.sf_bank_account_details.account_no");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no");
		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = sandipun_erp.sf_fees_challan.bank_id",'left');
		$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = sandipun_erp.sf_fees_challan.bank_account_id");
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_erp.sf_fees_challan.fees_id', $id);
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_erp.sf_student_master.current_year,sandipun_erp.sf_student_master.mobile,sandipun_erp.sf_student_master.academic_year,sandipun_erp.sf_student_master.enrollment_no,sandipun_erp.sf_student_master.student_id as stud_id,sandipun_erp.sf_student_master.program_id as admission_stream,sandipun_erp.sf_student_master.first_name,sandipun_erp.sf_student_master.middle_name,sandipun_erp.sf_student_master.last_name,spd.branch_short_name as stream_name, spd.course_name, spd.college_name as school_name,sandipun_ums.bank_master.bank_name, sandipun_erp.sf_bank_account_details.account_name, sandipun_erp.sf_bank_account_details.account_no");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_erp.sf_student_master","sandipun_erp.sf_student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no");
		$this->db->join('sandipun_erp.sf_program_detail as spd','sandipun_erp.sf_student_master.program_id = spd.sf_program_id','left');
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = sandipun_erp.sf_fees_challan.bank_id",'left');
		$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = sandipun_erp.sf_fees_challan.bank_account_id");
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_erp.sf_fees_challan.fees_id', $id);
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1." UNION ".$query2);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function fees_challan_list($data='')
	{
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no");
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date >=', $data['fdate']);
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date <=', $data['tdate']);
		}
		/*else if(isset($data['fdate']) && $data['fdate']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date', $data['fdate']);
		}*/
		
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.challan_status', $data['status']);
		}
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_erp.sf_student_master.first_name,sandipun_erp.sf_student_master.middle_name,sandipun_erp.sf_student_master.last_name,");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_erp.sf_student_master","sandipun_erp.sf_student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no");
		
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date >=', $data['fdate']);
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date <=', $data['tdate']);
		}
		/*else if(isset($data['fdate']) && $data['fdate']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date', $data['fdate']);
		}
		*/
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.challan_status', $data['status']);
		}
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1." UNION ".$query2);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function getbanks()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('bank_master');
		$DB1->where("active", "Y");
		$query=$DB1->get();
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
	
	public function get_depositedto()
	{
		$this->db->select("*");
		$this->db->from("sf_bank_account_details");
		$this->db->where('is_active', 'Y');
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_faci_fee_details($data)
	{
		$this->db->select("*");
		$this->db->from("sf_facility_fees_master");
		$this->db->where('facility_type_id', $data['facility']);
		$this->db->where('category_id', $data['category']);
		$this->db->where('academic_year LIKE ', $data['academic'].'%');
		$this->db->where('status', 'Y');
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_faci_category_details($data)
	{
		if($data['facility']==1)
		{
			$this->db->select("cat_id,campus_name");
			$this->db->from("sf_facility_category");
			$this->db->where('faci_id', '1');
			$this->db->where('status', 'Y');
		}
		else if($data['facility']==2)
		{
			$this->db->select("board_id,boarding_point");
			$this->db->from("sf_transport_boarding_details");
			$this->db->where('is_active', 'Y');
		}
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
		
	public function add_fees_challan_submit($data)
	{
		$this->db->insert("sf_fees_challan", $data); 
		$last_inserted_id=$this->db->insert_id();                
		return $last_inserted_id;
	}
	
	public function update_challan_no($id,$data)
	{
		$this->db->where('fees_id', $id);
		$this->db->update("sf_fees_challan", $data);
		return $this->db->affected_rows();
	}
	
}

?>