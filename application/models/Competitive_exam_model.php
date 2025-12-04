<?php
class Competitive_exam_model extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
		//error_reporting(E_ALL);
		//ini_set('display_errors', 1);
    }
	
	 // fetch qualification streams 
	public function fetch_qualification_streams($data) {
		//var_dump($data);exit();
	    $DB1 = $this->load->database('umsdb', TRUE); 
        //$sql = "select * from qualification_master order by qualification";
		$DB1->select("*");
		$DB1->from('qualification_master');
		$DB1->where("level", $data['level']);
		$DB1->order_by("qualification", "asc");
        $query=$DB1->get();
		// echo $DB1->last_query(); exit();
        $res = $query->result_array();
       
        return $res;
    } 
	
	function getbanks()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('bank_master');
		$DB1->where("active", "Y");
		$query=$DB1->get();
		//echo $this->db->last_query();
		$result=$query->result_array();
		return $result;
	}
	public function getAllState()
	{
	    $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT * from states order by state_name";
        $query = $DB1->query($sql);
        return $query->result_array();
    }
		public function getmoduledetails()
	{
		$this->db->select("sm.*,");
		$this->db->from("sandipun_ums.competative_fees as sm");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
		// $data['organisation']="SU";
	}
	
	public function get_student_list($id='')
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,");
		$DB1->from("sandipun_ums.competative_admissions as sm");
		if($id!='')
		{
			$DB1->where('sm.stud_id', $id);
		}
		$DB1->order_by("stud_id", "desc");
		$query = $DB1->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
		// $data['organisation']="SU";
	}
	
	public function getAllcaste()
	{
		$this->db->select("sm.*,");
		$this->db->from("sandipun_ums.caste_master as sm");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
		// $data['organisation']="SU";
	}
	
	public function getAllpublicmedia()
	{
		$this->db->select("sm.*,");
		$this->db->from("sandipun_ums.publicity_media as sm");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
		// $data['organisation']="SU";
	}
	
	public function get_academic_details()
	{
		$sql="select * From sf_academic_year where status='Y'";
		//$this->db->where('status', 'Y');
		$query = $this->db->query($sql);
		return  $query->result_array();
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
	
	public function get_stream_list_in_school($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.stream_id,sm.stream_short_name");
		$DB1->from("stream_master as sm");
		
		$DB1->join("school_stream as ss", "ss.stream_id = sm.stream_id");
		$DB1->where('ss.school_id',$data['school']);
		//$DB1->where('course_cat',$data['category']);
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
		$DB1->where('school_id',$school);
		$DB1->order_by("school_stream.school_stream_id", "desc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->result_array();
	}
	
	public function check_prn_exists($data)
	{
		if($data['org']=="SU" )
		{
			$this->db->select("sm.*,sandipun_ums.vw_stream_details.stream_name,sandipun_ums.vw_stream_details.course_short_name,sandipun_ums.vw_stream_details.stream_short_name,sandipun_ums.vw_stream_details.school_name,sandipun_ums.vw_stream_details.stream_code,");
			$this->db->from("sandipun_ums.student_master as sm");
			$this->db->join("sandipun_ums.vw_stream_details", "sm.admission_stream = sandipun_ums.vw_stream_details.stream_id");

			if($data['prn']!='')
			{
				$this->db->where("sm.enrollment_no",str_replace("_","/",$data['prn']));
			}
			$query = $this->db->get();
			//echo $this->db->last_query();exit();
			return $query->result_array();
			// $data['organisation']="SU";
		}
		else
		{			
			$sql="select sm.* from sf_student_master as sm where sm.enrollment_no='".str_replace("_","/",$data['prn'])."';";
			
			$query = $this->db->query($sql);
			//echo $this->db->last_query();exit();

			return $query->result_array();
		}
	}
	
	public function fetch_fees($data)
	{
		$this->db->select("sm.*,");
		$this->db->from("sandipun_ums.competative_fees as sm");
		$this->db->where("sm.module_no",$data['module']);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
		// $data['organisation']="SU";
	}
	
	public function get_last_reg_no()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("MAX(sm.reg_no) as reg_no");
		$DB1->from("sandipun_ums.competative_admissions as sm");
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->row()->reg_no;
	}
	
	public function form_submit($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->insert("competative_admissions", $data);
		//echo $DB1->last_query();exit();
		//$DB1->insert("course_master", $course_details);
		$last_inserted_id=$DB1->insert_id(); 
		return $last_inserted_id; 
	}
	
	public function update_form_submit($data,$id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->where('stud_id', $id);
		$DB1->update("competative_admissions", $data);
		return $DB1->affected_rows();
	}
	
	public function get_std_fc_details_byid($id)
	{
		$sql1="select s.*,sum(f.amount) as paid_amt from sandipun_ums.competative_admissions as s 
		left join sandipun_ums.competative_fees_details as f on s.stud_id=f.student_id  where s.stud_id='".$id."' group by s.stud_id";
		//f.academic_year='".$data['academic_year']."' and
		
		$query = $this->db->query($sql1);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	
	// fetch all installment details
	function fetch_fee_details($id)
	{
		$sql="select f.* from sandipun_ums.competative_fees_details as f where f.student_id='".$id."' and f.is_deleted='N' and f.type_id=2 order by f.fees_id;";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	// Insert payment installment
	function pay_Installment($data, $payfile)
	{
		$feedet['student_id']=$data['stud_id'];
		//$feedet['enrollment_no']=$data['enrollment_no'];
		$feedet['amount']=$data['paidfee'];
		$feedet['type_id']=2;
		$feedet['fees_paid_type']=$data['payment_type'];
		if($data['payment_type']=='CASH')
			$feedet['fees_date']=date('Y-m-d');
		else
			$feedet['fees_date']=$data['dd_date']; 
	//	$feedet['academic_year']= date('Y');
		$feedet['academic_year']=$data['acyear'];
		$feedet['receipt_no']=$data['dd_no'];
		
		$feedet['bank_id']=$data['dd_bank'];
		$feedet['bank_city']=$data['dd_bank_branch'];
		$feedet['remark']=$data['remark'];

		$feedet['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['created_on']= date('Y-m-d h:i:s');
		$feedet['created_by']= $_SESSION['uid'];


		$feedet['college_receiptno']=$data['clreceipt'];
		if($payfile !=''){
			$feedet['receipt_file']=$payfile;
		}
		//var_dump($feedet);exit();
		$this->db->insert("sandipun_ums.competative_fees_details", $feedet); 
		
		//echo $this->db->last_query();exit();
		$last_inserted_id=$this->db->insert_id();                
		return $last_inserted_id;	
	}
	
	function fetch_examfee_details_byfid($data)
	{
		$sql="select f.academic_year,f.fees_id,f.student_id,f.fees_paid_type, f.canc_charges, f.chq_cancelled, f.receipt_no, f.receipt_file, f.fees_date, f.bank_id, f.bank_city, f.amount as amt_paid,f.remark, f.college_receiptno from sandipun_ums.competative_fees_details as f where f.type_id=2 and f.fees_id='".$data."' and f.is_deleted='N' order by f.fees_id;";
		
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	function delete_fees($data)
	{
		$del['is_deleted']='Y';
		$del['chq_cancelled']='Y';
		$where=array("fees_id"=>$data['feeid']);
		$this->db->where($where); 
		$this->db->update('sandipun_ums.competative_fees_details', $del);
		return 'Y';
	}
	
	function update_fee_det($data, $payfile)
	{
		$fee_id = $data['eid'];
		$bfees = $data['bfees'];
		$pfees = $data['pfees'];
		$tfee = $data['bfees'] + $data['pfees'];

		$feedet['amount']=$data['epaidfee'];
		$feedet['type_id']=2;
		$feedet['fees_paid_type']=$data['epayment_type'];
		
		if($data['epayment_type']=='CASH')
			$feedet['fees_date']=date('Y-m-d');
		else
			$feedet['fees_date']=$data['edd_date'];
		
		$feedet['academic_year']=$data['acyear'];
				
		$feedet['receipt_no']=$data['edd_no'];
		 
		$feedet['bank_id']=$data['edd_bank'];
		$feedet['bank_city']=$data['edd_bank_branch'];
		$feedet['modify_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['modified_on']= date('Y-m-d h:i:s');
		$feedet['modified_by']= $_SESSION['uid'];
		if($data['ccanc']=="N")
		{
		 	$feedet['canc_charges']=0;   
		}
		else
		{
			$feedet['canc_charges']=$data['cancamt']; 
		}
		$feedet['chq_cancelled']=$data['ccanc']; 
		$feedet['remark']=$data['eremark'];
		$feedet['college_receiptno']=$data['eclreceipt'];
		
		if($payfile !=''){
			$feedet['receipt_file']=$payfile;
		}
		//var_dump($feedet);exit();
		$where=array("fees_id"=>$fee_id);
		$this->db->where($where); 
		//$this->db->update($this->table_name, $update_array);
		//echo $this->db->last_query();exit();
		$this->db->update('sandipun_ums.competative_fees_details', $feedet);
		return true;
		
	}
	
	public function get_studentwise_Competitive_fees($data){
    	$DB1 = $this->load->database('default', TRUE);
    	$cond="p.academic_year='".$data['academic_year']."'";
  
       if($data['report_type']=='4'){
           $cond.=' and (p.appl- 
(CASE
    WHEN p.fees_paid is null THEN 0 ELSE p.fees_paid
END))>0';
       }
  
    	$sql="SELECT p.* FROM (
                 SELECT DISTINCT f.*,f.applicable_fees as appl,a.fees_paid FROM sandipun_ums.competative_admissions f LEFT JOIN (SELECT student_id,academic_year,SUM( amount )AS fees_paid FROM sandipun_ums.competative_fees_details WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='2' and academic_year='".$data['academic_year']."' GROUP BY student_id) a ON a.student_id=f.stud_id AND f.academic_year=a.academic_year ) p WHERE $cond";
	       $query=$DB1->query($sql);
    	  //echo $DB1->last_query();exit();
    		$result=$query->result_array();
    		return $result;
 
 }
}
?>