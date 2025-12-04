<?php
class Caution_money_model extends CI_Model 
{
	function __construct()
    {
        
        parent::__construct();
    //       error_reporting(E_ALL);
//ini_set('display_errors', 1);
    }
	
	
	
	public function get_hostel_floor(){
		
		$sql="SELECT sfhrd.floor_no FROM sf_hostel_room_details AS sfhrd
	    INNER JOIN sf_hostel_master AS sfhm ON sfhm.hostel_code = sfhrd.hostel_code WHERE sfhrd.host_id = '3' 
	    GROUP BY floor_no";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getAllitem(){
		$DB1 = $this->load->database('umsdb', TRUE);
		//$this->load->database('',);
		$sql="SELECT * FROM caution_item";
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	public function getAllitemby_id($id){
		$DB1 = $this->load->database('umsdb', TRUE);
		//$this->load->database('',);
		$sql="SELECT * FROM caution_item where item_id='$id'";
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	public function Item_type($Item_type){
		$DB1 = $this->load->database('umsdb', TRUE);
		//$this->load->database('',);
		$sql="SELECT * FROM caution_item where Item_type='$Item_type' AND status='Y'";
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	
	public function Item_Name($item_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		//$this->load->database('',);
		$sql="SELECT * FROM caution_item where item_id='$item_id' AND status='Y'";
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	
	public function university_challan_list(){
		$DB1 = $this->load->database('umsdb', TRUE);
		//$this->load->database('',);
		$sql="SELECT ct.Item_Name as itname,sm.first_name,sm.last_name,vw.stream_name,uc.* FROM university_caution AS uc 
		LEFT JOIN caution_item AS ct ON ct.item_id=uc.Item_Name
		LEFT JOIN student_master AS sm ON sm.stud_id=uc.student_id
		LEFT JOIN vw_stream_details AS vw ON vw.stream_id=sm.admission_stream
		ORDER BY uc.ucaution_id DESC";
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	
	
	
	
	public function hostel_challan_list(){
		$DB1 = $this->load->database('umsdb', TRUE);
		//$this->load->database('',);
		$sql="SELECT ct.Item_Name as itname,sm.first_name,sm.last_name,uc.* FROM hostel_caution AS uc 
		LEFT JOIN caution_item AS ct ON ct.item_id=uc.Item_Name
		LEFT JOIN student_master AS sm ON sm.stud_id=uc.student_id
		ORDER BY uc.caution_hid DESC";
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	
	public function get_details_Challan($recepit){
		$DB=$this->load->database('umsdb',true);
	    $sql="SELECT sm.first_name,sm.last_name,sm.`enrollment_no`,sm.`stud_id`,sm.admission_cycle,vw.stream_name,uc.* FROM university_caution AS uc 
		LEFT JOIN student_master AS sm ON sm.stud_id=uc.student_id
		LEFT JOIN vw_stream_details AS vw ON vw.stream_id=sm.admission_stream
		where uc.ucaution_id='$recepit'";
		$query=$DB->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
	
	public function stud_depositelist($year){ $DB=$this->load->database('umsdb',true);
		$sql="SELECT student_id,`caution_dposite` FROM `university_caution` AS uc
JOIN (SELECT MAX(`ucaution_id`) AS id
      FROM university_caution where academic_year='$year'  GROUP BY student_id ORDER BY  ucaution_id  DESC     
) AS m ON m.id=uc.ucaution_id";
		$query=$DB->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
    public function check_hcode_exist($data)
    {
		//$hostel_code=$_REQUEST['hostel_code'];
		//$host_id=$_REQUEST['host_id'];

		$sql="select * From sf_hostel_master WHERE hostel_code='".$data['hcode']."' AND host_id !='".$data['host_id']."'";
		
		$query = $this->db->query($sql);
		if($query->num_rows()>0)
		{
			return "Duplicate hostel Code";
		}else{
			return "";
		}
	}
	
	public function get_incharge_byacademic()
	{
		$sql="select Distinct academic_year From sf_hostel_incharge_details";
		
		
        $query = $this->db->query($sql);
        return $query->result_array();
	}
	
	function  get_hostel_details($hostel_id='',$campus='')
    {
        //$where=" WHERE cm.status='Y' AND cm2.status='Y' ";  
        $where=" WHERE 1=1 ";  
        
        if($hostel_id!="")
        {
            $where.=" AND host_id='".$hostel_id."'";
        }
        
          if(isset($campus) && $campus!="")
        {
            $where.=" AND campus_name='".$campus."'";
        }
        
        
   		$exp = explode("_",$_SESSION['name']);
   //	echo $exp[1];
		     if($exp[1]=="sijoul")
        {
              $where.=" AND campus_name='SIJOUL'";
        }
        
            if($exp[1]=="nashik")
        {
            $where.=" AND campus_name='NASHIK'"; 
        }
      
        $sql="select * From sf_hostel_master $where  order by hostel_code";
     //  echo $sql;
      //  exit();
        $query = $this->db->query($sql);
        
        return $query->result_array();
    }
	
	function hostel_details($data)
    {
		$where=" WHERE 1=1 "; 
        if(isset($data['campus']) && $data['campus']=="All")
        {
			$where=" WHERE 1=1 ";  
        }
        if($hostel_id!="")
        {
            $where.=" AND host_id='".$hostel_id."'";
        }
        
        if(isset($data['campus']) && $data['campus']!="" && $data['campus']!="All")
        {
            $where.=" AND campus_name='".$data['campus']."'";
        }
        
        $sql="select * From sf_hostel_master $where  order by hostel_code";
     //  echo $sql;
      //  exit();
        $query = $this->db->query($sql);
        
        return $query->result_array();
    }
	
	function get_info($data)
    {
        $sql="select sm.first_name,sm.course,sm.stream,sm.current_year, sm.instute_name,sfsf.enrollment_no,ssf.organisation
from sf_hostel_room_details as sfhrd 
 join sf_student_facility_allocation as sfsf on sfhrd.sf_room_id = sfsf.allocated_id and sfsf.is_active='Y' 
and sfsf.sffm_id=1 and sfsf.academic_year='".$data['academic_y']."'
 join sf_student_master as sm on sm.enrollment_no = sfsf.enrollment_no
 join sf_student_facilities as ssf on ssf.organisation='SF' and ssf.sf_id = sfsf.sf_id and ssf.sffm_id = sfsf.sffm_id
WHERE  sm.first_name is not null and sfhrd.host_id='".$data['host_id']."' and sfhrd.floor_no='".$data['floors']."' and sfhrd.room_no='".$data['room']."' 
 and sfhrd.is_active='Y' 
union
select sm.first_name,vm.course_short_name as course,vm.stream_short_name as stream,sm.current_year, vm.school_name as instute_name,sfsf.enrollment_no,ssf.organisation
from sf_hostel_room_details as sfhrd 
 join sf_student_facility_allocation as sfsf on sfhrd.sf_room_id = sfsf.allocated_id and sfsf.is_active='Y'
 and sfsf.sffm_id=1 and sfsf.academic_year='".$data['academic_y']."'
 join sandipun_ums.student_master as sm on sm.enrollment_no = sfsf.enrollment_no
 join sandipun_ums.vw_stream_details as vm on vm.stream_id=sm.admission_stream
 join sf_student_facilities as ssf on ssf.organisation='SU' and ssf.sf_id = sfsf.sf_id and ssf.sffm_id = sfsf.sffm_id
WHERE  sm.first_name is not null and sfhrd.host_id='".$data['host_id']."' and sfhrd.floor_no='".$data['floors']."' and sfhrd.room_no='".$data['room']."' 
and sfhrd.is_active='Y'";
     //  echo $sql;
      //  exit();
        $query = $this->db->query($sql);
        
        return $query->result_array();
    }
	
    function  get_hostel_search_details($hostel_name='')
    {
        $where=" WHERE 1=1 ";  
        
        if($hostel_name!="")
        {
            $where.=" AND hostel_name like '$hostel_name'";
        }
        
        $sql="select * From sf_hostel_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	
	public function getAllState(){
	    $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT * from states order by state_name";
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	
	public function get_facilities_types()
	{
		//$sql="select fm.facility_name,ffd.* from sf_facility_fees_master as ffd inner join sf_facility_types as fm on fm.faci_id = ffd.sffm_id";
		
		$sql="SELECT * from sf_facility_types order by faci_id";
        $query = $this->db->query($sql);
        return $query->result_array();
	}
	
	public function getallfailities($data)
	{
	    
	    	$exp = explode("_",$_SESSION['name']);

	    
		$where="where ffd.facility_type_id = '".$data['faci_id']."' and academic_year='".$data['academic']."'";
		//$sql="select * From sf_facility_fees_master $where ";
		
				     if($exp[1]=="sijoul")
        {
              $where.=" AND fc.campus_name='SIJOUL'";
        }
        
            if($exp[1]=="nashik")
        {
            $where.=" AND fc.campus_name='NASHIK'"; 
        }
		
	
		
		$sql="select fc.category_name,fc.campus_name,fm.facility_name,ffd.* from sf_facility_fees_master as ffd
	    inner join sf_facility_types as fm on fm.faci_id = ffd.facility_type_id
		inner join sf_facility_category as fc on fc.cat_id = ffd.category_id
		$where";
        $query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
        return $query->result_array();
	}
	
	
	public function get_facilities_byid($sf_fc_id)
	{
		$where="where sffm_id = $sf_fc_id";
		$sql="select * From sf_facility_fees_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
	}
	
	public function get_inchrgr_detailsbyhid($hid)
    {
		 $sql="select sfhm.hostel_name,inchr.* from sf_hostel_incharge_details as inchr
	    inner join sf_hostel_master as sfhm on sfhm.hostel_code = inchr.hostel_code
		where inchr.host_id = $hid";
	
		//$sql="select * from sf_hostel_incharge_details where host_id=$hid;";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return  $query->result_array();
	}
	
	public function get_inchrgr_details($inchrgr_id)
	{
		$sql="select * from sf_hostel_incharge_details where host_inch_id=$inchrgr_id;";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_program_detail($camp='')
	{
	    if($camp!='')
	    {
	     	$sql="select distinct college_name from sf_program_detail where  campus ='$camp' and active='Y' ";   
	    }
	    else
	    {
	    		$sql="select distinct college_name from sf_program_detail where active='Y' ";
	    }
	    		$exp = explode("_",$_SESSION['name']);
		     if($exp[1]=="sijoul")
        {
              $sql.=" AND campus='SIJOUL'";
        }
        
            if($exp[1]=="nashik")
        {
            $sql.=" AND campus='NASHIK'"; 
        }
        
//echo $sql;
		$query = $this->db->query($sql);
				
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	
function get_institutes_by_campus($camp)
{
    if($camp=='SF-SIJOUL' || $camp=='SIJOUL')
		$camp='SIJOUL';
	else
		$camp='NASHIK';
	
	$sql="select distinct college_name from sf_program_detail where campus='".$camp."' and active='Y' ";
		$query = $this->db->query($sql);

	$result = $query->result_array();
	$opt = " <option value='' >select institute</option>";
	foreach($result as $results)
	{
		$opt .="<option value='".$results['college_name']."'>".$results['college_name']."</option>";
	}
	return $opt;
}

	public function get_su_program_detail($data)
	{
		$this->db->distinct();
		$this->db->select("sandipun_ums.school_master.school_id,sandipun_ums.school_master.school_short_name,");
		$this->db->from("sandipun_ums.school_master");
		$this->db->where("sandipun_ums.school_master.is_active",'Y');
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_su_designation()
	{
		$this->db->distinct();
		$this->db->select("designation_master.designation_id,designation_master.designation_name,");
		$this->db->from("designation_master");
		$this->db->where("designation_master.status",'Y');
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
		
	public function get_student_canc($enroll)
	{
	
		$this->db->select("sfc.*,ssf.cancellation_charges as actcanc_charge");
		$this->db->from("sf_facility_cancel as sfc");
		$this->db->join("sf_student_facilities ssf",'sfc.enrollment_no = ssf.enrollment_no and ssf.sffm_id=sfc.faci_id','left');
		
		//$this->db->join("sandipun_ums.bank_master",'sfc.bank_id = sandipun_ums.bank_master.bank_id','left');
		$this->db->where("sfc.enrollment_no",$enroll);
		$this->db->where("sfc.faci_id",1);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->row_array();
	}
	
	
	
	
	public function getprogrambycollegename($college_name)
	{
		$sql="select sf_program_id,CONCAT(course_name,' - ',branch_short_name) as course_short_name from sf_program_detail where college_name='$college_name';";
		
		//$sql="select course_name,branch_short_name from sf_program_detail where college_name='$college_name';";
		//echo $sql;exit();
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function getcoursename_by_prgmid($program_id,$academic_year)
	{
		$sql="select CONCAT(course_name, ' - ', branch_short_name) as course_short_name from sf_program_detail where sf_program_id=$program_id;";
		
		//$sql="select course_name,branch_short_name from sf_program_detail where college_name='$college_name';";
		//echo $sql;exit();
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->row()->course_short_name;//$query->result_array();
	}
	
	public function fee_paid_count($program_id)
	{
		$sql="select COUNT(distinct enrollment_no) as count_rows From sf_student_master WHERE enrollment_no='$enroll' AND student_id !=$std_id;";
		
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->row()->course_short_name;//$query->result_array();
	}
	
	public function get_std_details_byid($sf_std_id)
	{
		$sql="select * from sf_student_master where student_id=$sf_std_id;";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	
	public function get_hostelfee_details($data)
	{
		//print_r($data['org']);
		if($data['org']=="SU" )
		{
			$this->db->select("sandipun_erp.sf_student_facilities.sf_id,sandipun_erp.sf_student_facilities.student_id,sandipun_erp.sf_student_facilities.deposit_fees,sandipun_erp.sf_student_facilities.actual_fees,sandipun_erp.sf_student_facilities.academic_year,sandipun_ums.vw_stream_details.stream_name,sandipun_ums.vw_stream_details.course_short_name,sandipun_ums.vw_stream_details.stream_short_name,sandipun_ums.vw_stream_details.school_name,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.current_year,sandipun_ums.student_master.last_name,sandipun_erp.sf_student_facilities.enrollment_no,sandipun_ums.vw_stream_details.stream_code,");
			$this->db->from("sandipun_ums.student_master");

			$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
			
			//$this->db->join("sandipun_erp.sf_fees_details", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_fees_details.enrollement_no");

			$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.sffm_id=1");
			//$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id','left');

			$this->db->where("sandipun_erp.sf_student_facilities.organisation",$data['org']);
			if($data['enrollment_no']!='')
			{
				$this->db->where("sandipun_erp.sf_student_facilities.enrollment_no",str_replace("_","/",$data['enrollment_no']));
			}
			if($data['student_id']!='')
			{
				$this->db->where("sandipun_erp.sf_student_facilities.student_id",$data['student_id']);
			}
			

			$query = $this->db->get();
			//echo $this->db->last_query();exit();
			return $query->result_array();
			// $data['organisation']="SU";
		}
		else
		{
			//$sql="select sfsf.sf_id,sfsf.student_id,sfsf.deposit_fees,sfsf.actual_fees,sm.enrollment_no,sm.first_name,sm.instute_name,sm.organization,sfsf.academic_year from sf_student_facilities as sfsf inner join sf_student_master as sm on sm.student_id = sfsf.student_id where sfsf.enrollment_no='".$data['enroll']."' and sfsf.sf_id='".$data['sf_id']."';";
			
			$sql="select sm.stream,sm.course,sfsf.sf_id,sfsf.student_id,sfsf.deposit_fees,sfsf.actual_fees,sm.enrollment_no,
			sm.first_name,sm.middle_name,sm.last_name,sm.program_id,sm.stream as stream_name, 
			sm.course as course_name, sm.instute_name as school_name,sm.organization,sm.current_year,
			sfsf.academic_year from sf_student_facilities as sfsf 
			inner join sf_student_master as sm on sm.student_id = sfsf.student_id 			
			where sfsf.sffm_id=1 and  sfsf.enrollment_no='".str_replace("_","/",$data['enrollment_no'])."' 
			and sfsf.student_id='".$data['student_id']."' and sfsf.organisation='".$data['org']."';";
			//inner join sf_fees_details as fd on fd.student_id = sm.student_id 
			$query = $this->db->query($sql);
			//=echo $this->db->last_query();exit();

			return $query->result_array();
		}
	}
	
	public function get_std_fc_details_byid($data)
	{
		$sql1="SELECT sum(r.re_amount) as refund_paid, sum(f.amount) as paid_amt,sfsf.* FROM sf_student_facilities as sfsf 
inner join (select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_details where type_id='1' and is_deleted='N'
group by enrollment_no  ,academic_year ) f on sfsf.enrollment_no=f.enrollment_no  and 
f.academic_year=sfsf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as re_amount,academic_year from sf_fees_refunds where is_deleted='N' and type_id=1 group by enrollment_no  ,academic_year )
 r on sfsf.enrollment_no=r.enrollment_no  and 
r.academic_year=sfsf.academic_year
where  sfsf.sffm_id=1 and f.enrollment_no='".$data['enrollment_no']."' and f.academic_year='".$data['academic_year']."'
  group by f.academic_year;
";
		
		$query1 = $this->db->query($sql1);
		//echo $this->db->last_query();exit();
		$fee_count= $query1->result_array();
		
		/* $sql="select sum(r.amount) as refund_paid,ssf.*,sum(sfd.amount) as paid_amt,sfd.fees_id,sfd.bank_id,sfd.bank_city,sfd.canc_charges,sfd.exam_fee_fine,sfd.college_receiptno,sfd.chq_cancelled,sfd.is_deleted from sf_student_facilities as ssf inner join sf_fees_details as sfd on sfd.enrollment_no=ssf.enrollment_no and ssf.academic_year=sfd.academic_year and sfd.type_id=ssf.sffm_id left JOIN sf_fees_refunds as r on ssf.enrollment_no=r.enrollment_no  and ssf.sffm_id=1 and 
		r.academic_year=ssf.academic_year
		where ssf.enrollment_no='".$data['enrollment_no']."' and sfd.is_deleted='N' and ssf.sffm_id=1 group by ssf.academic_year;"; */
		$sql="SELECT sum(r.re_amount) as refund_paid, sum(f.amount) as paid_amt,sfsf.* FROM sf_student_facilities as sfsf 
inner join (select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_details where type_id='1' and is_deleted='N'
group by enrollment_no  ,academic_year ) f on sfsf.enrollment_no=f.enrollment_no  and 
f.academic_year=sfsf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as re_amount,academic_year from sf_fees_refunds where is_deleted='N'  and type_id=1 group by enrollment_no  ,academic_year )
 r on sfsf.enrollment_no=r.enrollment_no  and 
r.academic_year=sfsf.academic_year
where sfsf.sffm_id=1 and f.enrollment_no='".$data['enrollment_no']."'
  group by f.academic_year;";
		
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		
		if(!empty($fee_count))
		{
			return $query->result_array();
		}
		else
		{
			$res1=$query->result_array();
			$sql="SELECT f.* FROM `sf_student_facilities` as f 
			where f.enrollment_no='".$data['enrollment_no']."' and f.sffm_id=1 and f.academic_year='".$data['academic_year']."' ";
			
			$query = $this->db->query($sql);
			//echo $this->db->last_query();exit();
			$res2=$query->result_array();
			return array_merge($res1,$res2);
		}
		
		
	}
	
	public function get_all_std_details($data)
	{
		$this->db->select("spd.course_name,spd.branch_name as stream_name, sm.instute_name as school_name,sm.*,");
		$this->db->from("sandipun_erp.sf_student_master sm");
		$this->db->join('sandipun_erp.sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		$where=array("academic_year"=>$data['academic'],"campus_name"=>$data['campus']);
		$this->db->where($where);
		$this->db->order_by("student_id", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
	/* 	$sql="select * from sf_student_master;";
		$query = $this->db->query($sql);
		 */
		return $query->result_array();
	}
	
	// Insert payment installment
	function pay_Installment($data, $payfile)
	{
		$feedet['student_id']=$data['stud_id'];
		$feedet['enrollment_no']=$data['enrollment_no'];
		$feedet['amount']=$data['paidfee'];
		$feedet['type_id']=1;
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
		$this->db->insert("sf_fees_details", $feedet); 
		
		//echo $this->db->last_query();exit();
		$last_inserted_id=$this->db->insert_id();                
		return $last_inserted_id;	
	}
	
	// Insert Refund_payment installment
	function Refund_payment($data, $payfile)
	{
		$feedet['student_id']=$data['rstud_id'];
		$feedet['enrollment_no']=$data['renrollment_no'];
		$feedet['amount']=$data['rpaidfee'];
		$feedet['type_id']=1;
		$feedet['refund_paid_type']=$data['rpayment_type'];
		if($data['rpayment_type']=='CASH')
			$feedet['refund_date']=date('Y-m-d');
		else
			$feedet['refund_date']=$data['rdd_date']; 
	//	$feedet['academic_year']= date('Y');
		$feedet['academic_year']=$data['racyear'];
		$feedet['receipt_no']=$data['rdd_no'];
		
		$feedet['bank_id']=$data['rdd_bank'];
		$feedet['bank_city']=$data['rdd_bank_branch'];
		$feedet['remark']=$data['rremark'];

		$feedet['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['created_on']= date('Y-m-d h:i:s');
		$feedet['created_by']= $_SESSION['uid'];


		$feedet['refund_for']=$data['refund_type'];
		if($payfile !=''){
			$feedet['receipt_file']=$payfile;
		}
		//var_dump($feedet);exit();
		$this->db->insert("sf_fees_refunds", $feedet); 
		
		//echo $this->db->last_query();exit();
		$last_inserted_id=$this->db->insert_id();
		
		$updatefeedet['refund']=$data['rpaidfee'];
		$where=array("enrollment_no"=>$data['renrollment_no'],"academic_year"=>$data['racyear'],"sffm_id"=>1);
		$this->db->where($where); 
		$this->db->update('sf_student_facilities', $updatefeedet);
		
		return $last_inserted_id;	
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
	
	
	
		function student_paid_fees()
	{
		$sql="select f.student_id,f.fees_paid_type,f.fees_id,f.canc_charges,f.chq_cancelled, f.receipt_no, f.receipt_file, f.fees_date, f.bank_id, f.bank_city, f.amount as amt_paid,f.remark, f.college_receiptno,f.academic_year as academic_year from sf_fees_details as f where f.type_id=1 and f.enrollment_no='".$_POST['prn']."' and f.is_deleted='N' order by f.fees_id;";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	
	
	// fetch all installment details
	function fetch_hostelfee_details($data)
	{
		$sql="select f.student_id,f.fees_paid_type,f.academic_year,f.fees_id,f.canc_charges,f.chq_cancelled, f.receipt_no, f.receipt_file, f.fees_date, f.bank_id, f.bank_city, f.amount as amt_paid,f.remark, f.college_receiptno from sf_fees_details as f where  f.type_id=1 and f.enrollment_no='".$data['enrollment_no']."' and f.is_deleted='N' order by f.fees_id;";
		$query = $this->db->query($sql);
		$res1=$query->result_array();
		
		$sql="SELECT f.student_id,f.refund_paid_type as fees_paid_type,f.academic_year,f.fees_id, f.receipt_no, f.receipt_file, f.refund_date as fees_date, f.bank_id, f.bank_city, f.amount as amt_paid,f.remark  FROM `sf_fees_refunds` as f 
		where f.enrollment_no='".$data['enrollment_no']."' and f.type_id=1 and  f.is_deleted='N' and f.academic_year='".$data['academic_year']."' ";
		
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		$res2=$query->result_array();
		
		return array_merge($res1,$res2);
		//echo $this->db->last_query();exit();
		//return $query->result_array();
	}
	
	function total_fee_paid($data)
	{
	 $sql = "select sum(amount) as fee_paid from sf_fees_details where type_id=1 and enrollment_no = '".$data['enrollment_no']."' and academic_year = '".$data['academic_year']."' and is_deleted='N'  and chq_cancelled='N'";
	// echo $sql;
//	 exit();
	 	$query = $this->db->query($sql); 
	 		return $query->row_array();
	}
	
	
	function fetch_hostelfee_details_byfid($data)
	{
		//$sql="select f.fees_id,f.student_id,f.fees_paid_type,f.canc_charges,f.chq_cancelled, f.receipt_no, f.receipt_file, f.fees_date, f.bank_id, f.bank_city, f.amount as amt_paid,f.remark, f.college_receiptno from sf_fees_details as f where f.enrollement_no='".$data['enrollment_no']."' and f.student_id='".$data['student_id']."' and f.is_deleted='N' order by f.fees_id;";
		$sql="select f.academic_year,f.fees_id,f.student_id,f.fees_paid_type, f.canc_charges, f.chq_cancelled, f.receipt_no, f.receipt_file, f.fees_date, f.bank_id, f.bank_city, f.amount as amt_paid,f.remark, f.college_receiptno from sf_fees_details as f where f.type_id=1 and f.fees_id='".$data."' and f.is_deleted='N' order by f.fees_id;";
		
		$query = $this->db->query($sql);
	//	echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	
	public function getamtpaid_by_stdid($data)
	{
		$sql="select sum(amount) as paid_amt from sf_fees_details where type_id=1 and student_id=".$data['std_id'] ." and academic_year=".$data['academic_year']." and enrollment_no=".$data['enroll']." and is_deleted!='Y' and chq_cancelled!='Y';";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->row()->paid_amt;
	}
	

function update_fee_det($data, $payfile)
	{
		$fee_id = $data['eid'];
		$bfees = $data['bfees'];
		$pfees = $data['pfees'];
		$tfee = $data['bfees'] + $data['pfees'];

		$feedet['amount']=$data['epaidfee'];
		$feedet['type_id']=1;
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
		//echo $fee_id;exit();
		$where=array("fees_id"=>$fee_id);
		$this->db->where($where); 
		//$this->db->update($this->table_name, $update_array);
		//echo $this->db->last_query();exit();
		$this->db->update('sf_fees_details', $feedet);
				
			//$DB1->where('fees_id', $fee_id);
		//$DB1->update('fees_details',$feedet);

		return true;
		
	}
	

	function delete_fees($data)
	{
		$del['is_deleted']='Y';
		$del['chq_cancelled']='Y';
		$where=array("fees_id"=>$data['feeid']);
		$this->db->where($where); 
		$this->db->update('sf_fees_details', $del);
		return 'Y';
	}
	
	public function get_rooms_detailsbyhid($data)
    {
		$host_id=$data['h_id'];
		//select * from sf_hostel_room_details where host_id=5 order by host_id,floor_no,room_no;
		//$sql="select * from sf_hostel_room_details where host_id=$host_id order by host_id,floor_no,room_no;";
		
		$where="where sfhrd.host_id = $host_id";
		//$sql="select * From sf_facility_fees_master $where ";
		
		$sql="select sfhrd.sf_room_id,sfhrd.room_no,sfhrd.host_id,sfhrd.hostel_code,sfhrd.floor_no,sfhrd.no_of_beds as numbeds,
		sfhrd.bed_number,sfhrd.room_type,sfhrd.category,sfhrd.is_active,sfhm.* from sf_hostel_room_details as sfhrd
	    inner join sf_hostel_master as sfhm on sfhm.hostel_code = sfhrd.hostel_code $where group by floor_no,CAST(`room_no` AS SIGNED)";
		
		
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return  $query->result_array();
	}
	public function get_h_room_details($h_rm_id)
	{
		$sql="select * from sf_hostel_room_details where sf_room_id=$h_rm_id;";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return  $query->result_array();
	}
	
	public function check_exists($data)
	{
		$sql="select COUNT(distinct hostel_code) as count_rows From sf_hostel_master where  hostel_name='".$data['hname']."';";
		//echo $sql;exit();
        $query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		
		
		$sql1="select COUNT(distinct hostel_code) as count_rows From sf_hostel_master where hostel_code='".$data['hcode']."';";
		//echo $sql;exit();
        $query1 = $this->db->query($sql1);
		//echo $this->db->last_query();exit();
		return $query->row()->count_rows.'||'.$query1->row()->count_rows;
	}
	
	public function check_rm_exist_byflrhid($data,$sf_room_id)
	{
		/* $hostel_code=$this->input->post("hostel_code");    
		$flrno=$this->input->post("tot_flr");    
		$roomno=$this->input->post("tot_rooms");    
		$tot_beds=$this->input->post("tot_beds");                    
		$room_type=$this->input->post("room_type");
		$category=$this->input->post("category");
		
		 */
		$where1=" floor_no = '".$data['tot_flr']."' and hostel_code = '".$data['hostel_code']."' and room_no='".$data['tot_rooms']."'";
		
		$sql1="select sf_room_id From sf_hostel_room_details where $where1";
		$query = $this->db->query($sql1);
		
		$room_ids="(";
		
		$flr= $query->result_array();
		if(!empty($flr)){
			foreach($flr as $val){
				$room_ids.="'".$val['sf_room_id']."',";
			}
			$room_ids=substr($room_ids, 0, -1);
			$room_ids.=")";
		}
		else
			$room_ids.=$sf_room_id.")";
		
		
		$where=" floor_no = '".$data['tot_flr']."' and sf_room_id NOT IN $room_ids and hostel_code = '".$data['hostel_code']."' and room_no='".$data['tot_rooms']."'";
		
		$sql="select COUNT(distinct room_no) as count_rows From sf_hostel_room_details where $where group by floor_no,CAST(`room_no` AS SIGNED)";
		//echo $sql;exit();
        $query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->row()->count_rows;
	}
	
	public function check_rm_exist_byflr_rid($data)
	{
		$where=" floor_no = '".$data['flr_no']."' and hostel_code = '".$data['hostel_code']."' and room_no='".$data['r_no']."'";
		$sql="select COUNT(distinct room_no) as count_rows From sf_hostel_room_details where $where floor_no,CAST(`room_no` AS SIGNED)";
		//echo $sql.$where;exit();
        $query = $this->db->query($sql);
		return $query->row()->count_rows;
	}
	
	public function check_facilityfee_exists($data)
	{
		$where=" facility_type_id = '".$data['faci_id']."' and academic_year = '".$data['academic']."' and category_id='".$data['category']."'";
		$sql="select COUNT(distinct sffm_id) as count_rows From sf_facility_fees_master where $where;";
		//echo $sql.$where;exit();
        $query = $this->db->query($sql);
		return $query->row()->count_rows;
	}
	
	public function check_student_exists($data)
	{
		//academic_year = '".$data['academic']."'
		$where=" enrollment_no = '".$data['enroll']."' and student_id!='".$data['id']."'";
		$sql="select COUNT(*) as count_rows From sf_student_master where $where;";
		//echo $sql.$where;exit();
        $query = $this->db->query($sql);
		return $query->row()->count_rows;
	}
	
	public function check_facilityfee_exists_byid($data)
	{
		$where=" facility_type_id = '".$data['faci_id']."' and academic_year = '".$data['academic']."' and category_id='".$data['category']."' and sffm_id!='".$data['sffm_id']."'";
		$sql="select COUNT(distinct sffm_id) as count_rows From sf_facility_fees_master where $where;";
		//echo $sql.$where;exit();
        $query = $this->db->query($sql);
		return $query->row()->count_rows;
	}
	
	public function check_flr_exist($flr_no,$host_id)
	{
		$where=" floor_no = $flr_no and host_id = $host_id";
		$sql="select room_no,sf_room_id,no_of_beds,floor_no,room_type,category,bed_number From sf_hostel_room_details where $where GROUP by floor_no,CAST(`room_no` AS SIGNED)";
        $query = $this->db->query($sql);
		return  $query->result_array();
	}
	
	public function fetch_incharge_list($data)
	{
		$sql="select sfhm.hostel_name,inchr.* from sf_hostel_incharge_details as inchr
	    inner join sf_hostel_master as sfhm on sfhm.hostel_code = inchr.hostel_code
		where inchr.academic_year='".$data['academic']."' and is_active='Y'";
		
			$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
              $sql.=" AND inchr.organisation='SF-SIJOUL'";
        }
        
            if($exp[1]=="nashik")
        {
            $sql.=" AND inchr.organisation !='SF-SIJOUL'"; 
        }
        //echo $sql;
        
        
		//$sql="select * From sf_hostel_incharge_details where academic_year='".$data['academic']."';";
        $query = $this->db->query($sql);
       // echo $this->db->last_query();
        return $query->result_array();
	}
	
	public function room_existsbyflrofhostel($data)
	{
		/* $where=" floor_no = '".$data['flr_no']."' and host_id = '".$data['host_id']."' and room_no='".$data['r_no']."' and bed_number!='".$data['bed_number']."'";
		$sql="select room_no,sf_room_id,no_of_beds,floor_no,bed_number,category From sf_hostel_room_details where $where;";
        $query = $this->db->query($sql);
		$room_ids="(";
		
		$flr= $query->result_array();
		if(!empty($flr)){
			foreach($flr as $val){
				$room_ids.="'".$val['sf_room_id']."',";
			}
			$room_ids=substr($room_ids, 0, -1);
			$room_ids.=")";
		}
		else
			$room_ids.=$sf_room_id.")"; */
		
		$where=" sf_room_id = '".$data['sf_room_id']."' and floor_no = '".$data['flr_no']."' and host_id = '".$data['host_id']."' and room_no='".$data['r_no']."' and bed_number!='".$data['bed_number']."'";
		
		$sql="select COUNT(distinct room_no) as count_rows From sf_hostel_room_details where $where group by floor_no,CAST(`room_no` AS SIGNED)";
		//echo $sql;exit();
        $query = $this->db->query($sql);
		echo $this->db->last_query();exit();
		return $query->row()->count_rows;
		//return  $query->result_array();
	}
	
	public function total_rooms($host_id)
	{
		$sql="select no_of_rooms,no_of_beds from sf_hostel_master where host_id=$host_id";
		$query = $this->db->query($sql);
		return  $query->result_array();
	}
	public function rooms_allocated($host_id)
	{
		$sql="select count(a.room_no) as total_rooms_allotted from (select room_no From sf_hostel_room_details where host_id='$host_id'  group by floor_no,CAST(`room_no` AS SIGNED)) as a";
        $query = $this->db->query($sql);
		return $query->row()->total_rooms_allotted;
	}
	public function beds_allocated($host_id)
	{
		$sql="select sum(a.no_of_beds) as total_beds_allotted from (select no_of_beds From sf_hostel_room_details where host_id='$host_id' and category='Stay Room' group by floor_no,CAST(`room_no` AS SIGNED)) as a";
        $query = $this->db->query($sql);
		return $query->row()->total_beds_allotted;
	}
	public function get_h_flr_rm_details($h_id)
	{
		$sql="select * from sf_hostel_room_details where host_id=$h_id group by floor_no,CAST(`room_no` AS SIGNED)";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return  $query->result_array();
	}
	
	public function gethostelbycampus($data)
	{
		$sql="select * from sf_hostel_master where hostel_type='".$data['htype']."' and in_campus='".$data['campus']."' order by host_id;";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return  $query->result_array();
	}
	
	public function getroomnumsbyfloorno($data)
	{
		$sql="SELECT sf.sf_room_id,sf.floor_no,sf.room_no,sf.host_id,sf.no_of_beds, sf.room_type, sf.category, (select count(*) from sf_student_facility_allocation as r where r.`allocated_id`=sf.sf_room_id and r.is_active='Y') as tot FROM `sf_hostel_room_details` as sf WHERE sf.host_id='".$data['host_id']."' and sf.floor_no='".$data['floors']."';";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return  $query->result_array();
	}
	
	
	
	public function get_academic_details()
	{
		$sql="select * From sf_academic_year order by academic_year desc";
		$query = $this->db->query($sql);
		return  $query->result_array();
	}
	
	public function get_current_academic()
	{
		$sql="select academic_year From sf_academic_year where status='Y'";
		$query = $this->db->query($sql);
		return $query->row()->academic_year;
	}
	
	public function getsfid_byenrollment($data)
	{
		$sql="select sf_id From sf_student_facilities WHERE enrollment_no='".$data['enroll']."' AND student_id ='".$data['std_id']."' and sffm_id=1;";
		
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->row()->sf_id;//$query->result_array();
	}
	
	public function stdnt_faci_submit($data)
	{
		$temp['student_id']=$data['std_id'];
		$temp['enrollment_no']=str_replace("_","/",$data['enroll']);
		$temp['sf_id']=$data['sf_id'];
		$temp['sffm_id']=1;
		$temp['academic_year']=$data['academic'];
		$temp['allocated_id']=$data['sf_room_id'];
		$temp['valid_from']=$data['validfrom'];
		$temp['valid_to']=$data['validto'];
		$temp['created_ip']=$_SERVER['REMOTE_ADDR'];
		$temp['created_by']=$this->session->userdata("uid");
		$temp['created_on']=date("Y-m-d H:i:s");
		$temp['is_active']='Y';
		//var_dump($data);exit();
		$sql="select f_alloc_id From sf_student_facility_allocation WHERE enrollment_no='".$data['enroll']."' AND student_id ='".$data['std_id']."' and academic_year='".$data['academic']."' and is_active='Y';";
		
		//echo $sql.$where;exit();
        $query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		$check =  $query->row()->f_alloc_id;
		//echo $this->db->last_query();
		//echo '<br/>check=='.$check;exit();
        if ($check !=''){
			
			$this->db->where('f_alloc_id', $check);
		$this->db->update('sf_student_facility_allocation', $temp);
			return $check;
        }
		else
		{
			//$temp_cat['category_id']=$data['h_id'];
			//$this->db->where('sf_id', $data['sf_id']);
			//$this->db->update('sf_student_facilities', $temp_cat);
			//print_r($temp);exit();
			$this->db->insert("sf_student_facility_allocation", $temp); 
				
			return $this->db->insert_id();
		}
	}
	
	public function edit_stdnt_faci_submit($data,$f_alloc_id)
	{
		$temp['student_id']=$data['std_id'];
		$temp['enrollment_no']=$data['enroll'];
		$temp['sf_id']=$data['sf_id'];
		$temp['academic_year']=$data['academic'];
		$temp['allocated_id']=$data['sf_room_id'];
		$temp['valid_from']=$data['validfrom'];
		$temp['valid_to']=$data['validto'];
		$temp['modified_ip']=$_SERVER['REMOTE_ADDR'];
		$temp['modified_by']=$this->session->userdata("uid");
		$temp['modified_on']=date("Y-m-d H:i:s");
		//$update_flag="UPDATE `student_formfill_status` SET step_second_flag=1 where student_id='$stid'";
		$this->db->where('f_alloc_id', $f_alloc_id);
		$this->db->update('sf_student_facility_allocation', $temp);
		return $this->db->affected_rows();
//$res_flg=$this->db->query($update_flag);
	}
	
	public function get_facilities_allocation($f_alloc_id)
	{
		$sql="select sfsf.*,sfhm.*,sfhrd.* from sf_student_facility_allocation as sfsf
		inner join sf_hostel_room_details as sfhrd on sfhrd.sf_room_id = sfsf.allocated_id 
	    inner join sf_hostel_master as sfhm on sfhm.hostel_code = sfhrd.hostel_code WHERE sfsf.f_alloc_id=$f_alloc_id and sfsf.is_active='Y';";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return  $query->result_array();
	}
	
	public function get_allocated_hostel_details($allocated_id)
	{
		$sql="select sfsf.*,sfhm.*,sfhrd.* from sf_student_facility_allocation as sfsf
		inner join sf_hostel_room_details as sfhrd on sfhrd.sf_room_id = sfsf.allocated_id 
	    inner join sf_hostel_master as sfhm on sfhm.hostel_code = sfhrd.hostel_code WHERE sf_room_id=$allocated_id and sfsf.is_active='Y';";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return  $query->result_array();
	}
	
	public function student_allocation_list()
	{
		//$sql="select f.student_id,f.fees_paid_type,f.fees_id,f.canc_charges,f.chq_cancelled, f.receipt_no, f.receipt_file, f.fees_date, f.bank_id, f.bank_city, f.amount as amt_paid,f.remark, f.college_receiptno from sf_fees_details as f where f.student_id=$studId and f.is_deleted='N' order by f.fees_id;";
		
		$sql="select sfsf.*,sfhm.*,sfhrd.* from sf_student_facility_allocation as sfsf
		inner join sf_hostel_room_details as sfhrd on sfhrd.sf_room_id = sfsf.allocated_id 
	    inner join sf_hostel_master as sfhm on sfhm.hostel_code = sfhrd.hostel_code 
		inner join sf_student_master as sm on sm.enrollment_no = sfsf.enrollment_no ;";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_allocation_listbyhid($data)
	{
		$sql="select sfsf.is_active,sfsf.f_alloc_id,sfsf.allocated_id,sfhrd.room_no,sfhrd.floor_no,sfhm.hostel_code,sfhm.hostel_name,sm.enrollment_no,sm.first_name,sm.instute_name from sf_student_facility_allocation as sfsf
		inner join sf_hostel_room_details as sfhrd on sfhrd.sf_room_id = sfsf.allocated_id 
	    inner join sf_hostel_master as sfhm on sfhm.hostel_code = sfhrd.hostel_code 
		inner join sf_student_master as sm on sm.student_id = sfsf.student_id where sfhm.host_id='".$data['host_id']."' and sfsf.is_active='Y';";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	function fetch_std_hostel_fee_details($data)
	{
		$sql="SELECT  sum(f.amount) as amt_paid,sfsf.* FROM `sf_fees_details` as f 
		inner join sf_student_facilities as sfsf on sfsf.enrollment_no=f.enrollment_no  and sfsf.sffm_id=1 and f.academic_year=sfsf.academic_year
		where f.enrollment_no='".$data['enrollment_no']."' and f.academic_year='".$data['academic_year']."' and f.is_deleted='N' group by f.academic_year;";
		
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		$fee_count= $query->result_array();
		if(!empty($fee_count))
		{
			return $fee_count;
		}
		else
		{
			$sql="SELECT f.* FROM `sf_student_facilities` as f 
			where f.enrollment_no='".$data['enrollment_no']."' and f.sffm_id=1 and f.academic_year='".$data['academic_year']."' and f.status='Y' and f.cancelled_facility='N'";
			
			$query = $this->db->query($sql);
			//echo $this->db->last_query();exit();
			return $query->result_array();
		}
		
	}
	
	
	
	public function stdnt_faci_disable($f_alloc_id)
	{
		$temp['is_active']='N';
		$temp['modified_ip']=$_SERVER['REMOTE_ADDR'];
		$temp['modified_by']=$this->session->userdata("uid");
		$temp['modified_on']=date("Y-m-d H:i:s");
		$this->db->where('f_alloc_id', $f_alloc_id);
		$this->db->update('sf_student_facility_allocation', $temp);
		return $this->db->affected_rows();
	}
	
	public function stdnt_faci_enable($f_alloc_id)
	{
		$temp['is_active']='Y';
		$temp['modified_ip']=$_SERVER['REMOTE_ADDR'];
		$temp['modified_by']=$this->session->userdata("uid");
		$temp['modified_on']=date("Y-m-d H:i:s");
		$this->db->where('f_alloc_id', $f_alloc_id);
		$this->db->update('sf_student_facility_allocation', $temp);
		return $this->db->affected_rows();
	}
	
	
			public function get_details($data)
	{
		$sql="select sum(amount) as paid_amt from sf_fees_details where type_id=1 and enrollment_no='".str_replace("_","/",$data['enroll'])."' and student_id='".$data['stud_id']."' and academic_year='".$data['academic_year']."' and is_deleted='N';";
		$query = $this->db->query($sql);
	//	echo $this->db->last_query();
		$fee_count= $query->result_array();
		if(!empty($fee_count))
		{
			$fee_count=$fee_count[0]['paid_amt'];
		}
		
		if($data['org']=="SU" )
		{
			$this->db->select("sandipun_erp.sf_facility_fees_master.sffm_id as cat_id,sandipun_erp.sf_student_facilities.organisation as organization,sandipun_ums.student_master.*,sandipun_ums.parent_details.parent_mobile1,sandipun_ums.parent_details.parent_mobile2,sandipun_erp.sf_student_facilities.sf_id, sandipun_erp.sf_student_facilities.student_id,sandipun_erp.sf_student_facilities.deposit_fees,sandipun_erp.sf_student_facilities.actual_fees,sandipun_erp.sf_student_facilities.*,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.first_name,sandipun_erp.sf_student_facilities.academic_year,sandipun_ums.vw_stream_details.stream_code,sandipun_ums.vw_stream_details.course_short_name,sandipun_ums.vw_stream_details.stream_short_name,sandipun_ums.vw_stream_details.school_name as instute_name,");
			$this->db->from("sandipun_ums.student_master");
			$this->db->join("sandipun_ums.parent_details", "sandipun_ums.student_master.stud_id = sandipun_ums.parent_details.student_id");

			$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");

			$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.sffm_id=1");
			$this->db->join("sandipun_erp.sf_facility_fees_master","sandipun_erp.sf_facility_fees_master.facility_type_id=1 and sandipun_erp.sf_facility_fees_master.category_id=1");
			
			if($fee_count!=null)
			{
				$this->db->join("sandipun_erp.sf_fees_details", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_fees_details.enrollment_no and sandipun_ums.student_master.stud_id = sandipun_erp.sf_fees_details.student_id and sandipun_erp.sf_fees_details.is_deleted='N'");
			}
			
			$this->db->where("sandipun_erp.sf_student_facilities.organisation",$data['org']);
			if($data['enroll']!='')
			{
				$this->db->where("sandipun_erp.sf_student_facilities.enrollment_no",str_replace("_","/",$data['enroll']));
			}
			if($data['stud_id']!='')
			{
				$this->db->where("sandipun_erp.sf_student_facilities.student_id",$data['stud_id']);
			}
			if($data['academic_year']!='')
			{
				$this->db->where("sandipun_erp.sf_facility_fees_master.academic_year",$data['academic_year']);
			}

			$query = $this->db->get();
			//echo $this->db->last_query();exit();
			return $query->result_array();
		}
		else
		{
			if($fee_count!=null)
			$sql="select sm.parent_mobile1,sm.parent_mobile2,sfm.sffm_id as cat_id,sfsf.sf_id,sfsf.student_id,sfsf.deposit_fees,sfsf.actual_fees,sfsf.*,sm.current_year,sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name,sm.mobile,sm.instute_name,sm.organization,sm.stream as stream_short_name,sfsf.academic_year,sum(sfd.amount) as paid_amt,sfsf.excemption_fees from sf_student_facilities as sfsf 
			inner join sf_student_master as sm on sm.enrollment_no = sfsf.enrollment_no 
			inner join sf_fees_details as sfd on sfd.student_id = sfsf.student_id and sfd.enrollment_no=sfsf.enrollment_no and sfd.is_deleted='N'
			inner join sf_facility_fees_master as sfm on sfm.facility_type_id =1 
			where sfd.type_id=1 and sfsf.enrollment_no='".str_replace("_","/",$data['enroll'])."' and sfm.academic_year='".$data['academic_year']."' and sfsf.student_id='".$data['stud_id']."' and sfd.is_deleted='N' and sfsf.sffm_id=1;";
			//and sfsf.organisation='".$data['org']."'
			else
			$sql="select sm.parent_mobile1,sm.parent_mobile2,sfm.sffm_id as cat_id,sfsf.sf_id,sfsf.student_id,sfsf.deposit_fees,sfsf.actual_fees,sfsf.*,sm.current_year,sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name,sm.mobile,sm.instute_name,sm.organization,sm.stream as stream_short_name,sfsf.academic_year from sf_student_facilities as sfsf 
			inner join sf_student_master as sm on sm.enrollment_no = sfsf.enrollment_no  
			inner join sf_facility_fees_master as sfm on sfm.facility_type_id =1 
			where sfsf.enrollment_no='".str_replace("_","/",$data['enroll'])."' and sfm.academic_year='".$data['academic_year']."' and sfsf.student_id='".$data['stud_id']."' and sfsf.sffm_id=1;";
			
			//$query = $this->db->query($sql);
			
			$query = $this->db->query($sql);
			//echo $this->db->last_query();exit();

			return $query->result_array();
		}
		// $data;
		
		
		
		
	}
	public function get_stddetails($data)
	{
		$fee_count=0;
		$sql="select sfsf.organisation from sf_student_facilities as sfsf inner join sf_student_facility_allocation as sm on sfsf.sf_id=sm.sf_id and sfsf.sffm_id=1  and sm.enrollment_no=sfsf.enrollment_no where sm.enrollment_no='".str_replace("_","/",$data['enroll'])."' and sm.student_id='".$data['student_id']."' and sm.f_alloc_id='".$data['f_alloc_id']."' and sm.is_active='Y';";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		//echo $query->num_rows();exit();
		//return $query->result_array();
		$org= $query->result_array();
		//print_r($org);exit;
		if(!empty($org)){
			
			$org=$org[0]['organisation'];
					
		}
		
		$sql="select sum(amount) as paid_amt from sf_fees_details where type_id=1 and enrollment_no='".str_replace("_","/",$data['enroll'])."' and student_id='".$data['student_id']."' and is_deleted='N' and academic_year='".$data['academic']."';";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		$fee_count= $query->result_array();
		if(!empty($fee_count))
		{
			$fee_count=$fee_count[0]['paid_amt'];
		}
		
		if($org=="SU" )
		{
			if($fee_count!=null)
			{
				$this->db->select("sandipun_erp.sf_hostel_master.*,sandipun_erp.sf_hostel_room_details.floor_no,sandipun_erp.sf_hostel_room_details.room_no,sandipun_erp.sf_hostel_room_details.category,sandipun_erp.sf_hostel_room_details.room_type,sandipun_erp.sf_facility_fees_master.sffm_id as cat_id,sandipun_erp.sf_student_facilities.organisation as organization,sandipun_erp.sf_student_facilities.excemption_fees,sandipun_ums.student_master.*,sandipun_ums.parent_details.parent_mobile1,sandipun_ums.parent_details.parent_mobile2,sandipun_erp.sf_student_facilities.sf_id,sandipun_erp.sf_student_facilities.student_id,sandipun_erp.sf_student_facilities.deposit_fees,sandipun_erp.sf_student_facilities.actual_fees,sandipun_erp.sf_student_facilities.*,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.first_name,sandipun_erp.sf_student_facilities.academic_year,sandipun_ums.vw_stream_details.stream_code,sandipun_ums.vw_stream_details.stream_short_name,sandipun_ums.vw_stream_details.course_short_name,sandipun_ums.vw_stream_details.school_name as instute_name,sum(sandipun_erp.sf_fees_details.amount) as paid_amt");
				$this->db->from("sandipun_ums.student_master");
				$this->db->join("sandipun_ums.parent_details", "sandipun_ums.student_master.stud_id = sandipun_ums.parent_details.student_id");
				$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
				$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no");
				$this->db->join("sandipun_erp.sf_facility_fees_master","sandipun_erp.sf_facility_fees_master.facility_type_id=1 and sandipun_erp.sf_facility_fees_master.category_id=1");				
				$this->db->join("sandipun_erp.sf_student_facility_allocation", "sandipun_erp.sf_student_facility_allocation.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facility_allocation.sf_id=sandipun_erp.sf_student_facilities.sf_id and sandipun_erp.sf_student_facility_allocation.sffm_id=1 and sandipun_erp.sf_student_facility_allocation.is_active='Y'");
				$this->db->join("sandipun_erp.sf_hostel_room_details", "sandipun_erp.sf_hostel_room_details.sf_room_id = sandipun_erp.sf_student_facility_allocation.allocated_id");
				$this->db->join("sandipun_erp.sf_hostel_master", "sandipun_erp.sf_hostel_master.hostel_code = sandipun_erp.sf_hostel_room_details.hostel_code");
				
				$this->db->join("sandipun_erp.sf_fees_details", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_fees_details.enrollment_no and sandipun_ums.student_master.stud_id = sandipun_erp.sf_fees_details.student_id");
				$this->db->where("sandipun_erp.sf_fees_details.is_deleted",'N');
				$this->db->where("sandipun_erp.sf_fees_details.type_id",'1');
			}
			else
			{
				$this->db->select("sandipun_erp.sf_hostel_master.*,sandipun_erp.sf_hostel_room_details.floor_no,sandipun_erp.sf_hostel_room_details.room_no,sandipun_erp.sf_hostel_room_details.category,sandipun_erp.sf_hostel_room_details.room_type,sandipun_erp.sf_facility_fees_master.sffm_id as cat_id, sandipun_erp.sf_student_facilities.organisation as organization,sandipun_ums.student_master.*,sandipun_ums.parent_details.parent_mobile1,sandipun_ums.parent_details.parent_mobile2,sandipun_erp.sf_student_facilities.sf_id,sandipun_erp.sf_student_facilities.student_id,sandipun_erp.sf_student_facilities.deposit_fees,sandipun_erp.sf_student_facilities.actual_fees,sandipun_erp.sf_student_facilities.*,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.first_name,sandipun_erp.sf_student_facilities.academic_year,sandipun_ums.vw_stream_details.stream_code,sandipun_ums.vw_stream_details.stream_short_name,sandipun_ums.vw_stream_details.course_short_name,sandipun_ums.vw_stream_details.school_name as instute_name,");
				$this->db->from("sandipun_ums.student_master");
				$this->db->join("sandipun_ums.parent_details", "sandipun_ums.student_master.stud_id = sandipun_ums.parent_details.student_id");
				$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
				$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no");
				$this->db->join("sandipun_erp.sf_facility_fees_master","sandipun_erp.sf_facility_fees_master.facility_type_id=1 and sandipun_erp.sf_facility_fees_master.category_id=1");
				$this->db->join("sandipun_erp.sf_student_facility_allocation", "sandipun_erp.sf_student_facility_allocation.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facility_allocation.sf_id=sandipun_erp.sf_student_facilities.sf_id and sandipun_erp.sf_student_facility_allocation.sffm_id=1 and sandipun_erp.sf_student_facility_allocation.is_active='Y'");
				$this->db->join("sandipun_erp.sf_hostel_room_details", "sandipun_erp.sf_hostel_room_details.sf_room_id = sandipun_erp.sf_student_facility_allocation.allocated_id");
				$this->db->join("sandipun_erp.sf_hostel_master", "sandipun_erp.sf_hostel_master.hostel_code = sandipun_erp.sf_hostel_room_details.hostel_code");
				
			}
			
			$this->db->where("sandipun_erp.sf_student_facilities.organisation",$org);
			//
			if($data['enroll']!='')
			{
				$this->db->where("sandipun_erp.sf_student_facilities.enrollment_no",str_replace("_","/",$data['enroll']));
			}
			if($data['academic']!='')
			{
				$this->db->where("sandipun_erp.sf_facility_fees_master.academic_year",$data['academic']);
			}
			if($data['student_id']!='')
			{
				$this->db->where("sandipun_erp.sf_student_facilities.student_id",$data['student_id']);
			}

			$query = $this->db->get();
			//echo $this->db->last_query();//exit();
			return $query->result_array();
		}
		else
		{
			if($org=='SF')
				$cat_id=1;
			else
				$cat_id=2;
			if($fee_count!=null)
			$sql="select smm.parent_mobile1,smm.parent_mobile2,shm.*,shrd.floor_no,shrd.room_no,shrd.category,shrd.room_type,sfm.sffm_id as cat_id,sfsf.*,sm.allocated_id,sm.enrollment_no,smm.current_year,smm.mobile,smm.first_name,smm.middle_name,smm.last_name,smm.instute_name,smm.organization,sfsf.academic_year,sum(sfd.amount) as paid_amt,sfsf.excemption_fees,smm.stream as stream_short_name from sf_student_facilities as sfsf 
			inner join sf_student_facility_allocation as sm on sm.sf_id=sfsf.sf_id and sfsf.sffm_id=sm.sffm_id and sm.is_active='Y'
			inner join sf_fees_details as sfd on sfd.enrollment_no=sfsf.enrollment_no and sfd.academic_year='".$data['academic']."'
			inner join sf_facility_fees_master as sfm on sfm.facility_type_id =1  and sfm.category_id='".$cat_id."'
			inner join sf_hostel_room_details as shrd on shrd.sf_room_id = sm.allocated_id 
			inner join sf_hostel_master as shm on shm.hostel_code = shrd.hostel_code 
			inner join sf_student_master as smm on smm.enrollment_no = sfsf.enrollment_no  
			where sfd.type_id=1 and  sm.enrollment_no='".str_replace("_","/",$data['enroll'])."' and sm.student_id='".$data['student_id']."' and sfd.is_deleted='N' and sm.f_alloc_id='".$data['f_alloc_id']."' and sfm.academic_year='".$data['academic']."'";
			else
			$sql="select smm.parent_mobile1,smm.parent_mobile2,shm.*,shrd.floor_no,shrd.room_no,shrd.category,shrd.room_type,sfm.sffm_id as cat_id, sfsf.*, sm.enrollment_no,smm.current_year,smm.first_name, smm.middle_name,smm.last_name,smm.mobile,smm.instute_name,smm.organization,sfsf.academic_year,smm.stream as stream_short_name from sf_student_facilities as sfsf 
			inner join sf_facility_fees_master as sfm on sfm.facility_type_id =1  and sfm.category_id='".$cat_id."'
			inner join sf_student_facility_allocation as sm on sm.sf_id=sfsf.sf_id and sfsf.sffm_id=sm.sffm_id and sm.enrollment_no=sfsf.enrollment_no and sm.is_active='Y'
			inner join sf_hostel_room_details as shrd on shrd.sf_room_id = sm.allocated_id 
			inner join sf_hostel_master as shm on shm.hostel_code = shrd.hostel_code 
			inner join sf_student_master as smm on smm.enrollment_no = sfsf.enrollment_no 
			where sm.enrollment_no='".str_replace("_","/",$data['enroll'])."' and sm.student_id='".$data['student_id']."' and sm.f_alloc_id='".$data['f_alloc_id']."' and sfm.academic_year='".$data['academic']."';";
			
			$query = $this->db->query($sql);
			
			//var_dump($query);
			//echo $this->db->last_query();exit();
			
			return $query->result_array();
		}
		// $data;
		
		
		
		
	}
	
public function getcampusname()
	{
		$sql="select * From sf_facility_category where faci_id=1";// 1 for hostel facility
		
		$exp = explode("_",$_SESSION['name']);
		     if($exp[1]=="sijoul")
        {
              $sql.=" AND campus_name='SIJOUL'";
        }
        
            if($exp[1]=="nashik")
        {
            $sql.=" AND campus_name='NASHIK'"; 
        }
        
        $query = $this->db->query($sql);
        return $query->result_array();
	}
	
	function get_hstudent_list()
   {
       
		$acyear = date('Y');
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.stud_id,sm.first_name,sm.middle_name,sm.last_name,sm.form_number,sm.admission_year,sm.enrollment_no,stm.stream_name,cm.course_name");
		$DB1->from('student_master as sm');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
		$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	

		$DB1->where("ad.hostel_required",'Y');	    

		//	$DB1->where("sm.admission_year", $year);	   	    

		$DB1->order_by("sm.stud_id", "asc");
		$query=$DB1->get();
		//echo $DB1->last_query();
		//		 die();   
		//	echo $DB1->last_query();
		//die();  
		$result=$query->result_array();

		for($i=0;$i<count($result);$i++)
		{
		$result[$i]['fee_paid'] =$this->total_feepaid_typeid($result[$i]['stud_id'],3);

		}

		return $result;
       
   }
   
   function total_feepaid_typeid($std_id,$type_id)
   {
       $DB1 = $this->load->database('umsdb',TRUE);
       $DB1->select('sum(amount) as fee_paid');
       $DB1->from('fees_details');
       $DB1->where('student_id',$std_id);
       $DB1->where('type_id',$type_id);
       $query = $DB1->get();
       return $query->row_array();
       
   }
   
   
   
   function check_facility_allocated($student_id,$enrollno,$academic)
   {
      // $DB1 = $this->load->database('umsdb',TRUE);
       $this->db->select('*');
       $this->db->from('sf_student_facilities');
	   $this->db->where('sffm_id',1);
       $this->db->where('student_id',$student_id);
       $this->db->where('enrollment_no',$enrollno);
	   $this->db->where('academic_year',$academic);
	   $this->db->where('cancelled_facility','N');
	   $this->db->where('status','Y');
       $query =  $this->db->get();
	  // echo $this->db->last_query();exit();
       return $query->row_array();
       
       
   }
   
 
   
	function register_for_facility(){
//	     error_reporting(E_ALL);
//ini_set('display_errors', 1);
	    $chk = $this->check_facility_allocated($_POST['stud_id'],$_POST['prn_no'],$_POST['ac_year']);
	//    print_r($chk);exit();
	    if($chk['student_id']!='')
	    {
	        
	    }
	    else
	    {
			$this->db = $this->load->database('default',TRUE);
			$sub = $this->facility_fee_details($_POST['fc_id'],$_POST['ac_year'],$_POST['org_frm']) ;
			if(!empty($_FILES['exemfile']['name'])){
				$newfilename= date('dmYHis').str_replace(" ", "", basename($_FILES["exemfile"]["name"]));
				$stud['excem_doc_path'] = $newfilename;
			}
			//echo "<pre>";
			$stud['student_id']=$_POST['stud_id'];
			$stud['enrollment_no']=$_POST['prn_no'];
			$stud['organisation']=$_POST['org_frm'];
			$stud['year']=$_POST['c_year'];
			$stud['academic_year']=$_POST['hidac_year'];;
			$stud['sffm_id']=$_POST['hidfac_id'];
			//$stud['deposit_fees']=$sub['deposit'];
			//$stud['actual_fees']=$sub['fees'];
			$stud['actual_fees']=$_POST['fees'];
			$stud['excemption_fees']=$_POST['exem'];
			$stud['deposit_fees']=$_POST['fdeposit'];
			$stud['gym_fees']=$_POST['gym_fees'];
			$stud['fine_fees']=$_POST['pending_balance'];
			$stud['opening_balance']=$_POST['opening_balance'];
			
			$stud['status']='Y';
			$stud['created_by']=$_SESSION['uid'];
			$stud['created_on']=date("Y-m-d H:i:s");
			$stud['created_ip']=$_SERVER['REMOTE_ADDR'];
		
				
			if(!empty($_FILES['exemfile']['name'])){
				if(is_uploaded_file($_FILES['exemfile']['tmp_name'])){
					$sourcePath = $_FILES['exemfile']['tmp_name'];
					$targetPath = "uploads/Hostel/exepmted_fees/".$newfilename;
					if(move_uploaded_file($sourcePath,$targetPath)){
					
					}
				}
			}
			$this->db->insert('sf_student_facilities',$stud);
			//$this->db->last_query();
			return true;  
	    }
	    return true;	
		//echo "Y";
	}
   
   function facility_fee_details($fcid,$acyear,$org)
   {
       //$DB1 = $this->load->database('umsdb',TRUE);
    //   echo $org."******";
       if($org=="SU" || $org=="SF")
       {
        $campus="NASHIK";   
       }
       else
       {
     $campus="SIJOUL";    
           
       }
       
        $this->db->select('sffm.*');
        $this->db->from('sf_facility_fees_master sffm');
         $this->db->join('sf_facility_category sfc','sffm.category_id=sfc.cat_id','left');
        $this->db->where('sffm.facility_type_id',$fcid);
        $this->db->where('sffm.academic_year',$acyear);
         $this->db->where('sfc.campus_name',$campus);
	     $this->db->where('sffm.status','Y');
       $query =  $this->db->get();
	 //echo $this->db->last_query();
       return $query->row_array();
   }
   
   /* function facility_fee_details_by_prn($data)
   {
		$sql="select sfsf.academic_year,sfsf.amount,sfsf.deposit,sfsf.fees,sm.enrollment_no, smm.first_name,smm.instute_name,smm.organization,sfsf.academic_year from sf_facility_fees_master as sfsf 
		inner join sf_fees_details as sff on sff.student_id = sfsf.student_id and sff.enrollment_no=sfsf.enrollment_no
		inner join sf_student_master as smm on smm.student_id = sfsf.student_id 
		where sm.enrollment_no='".$data['enroll']."' and sm.student_id='".$data['student_id']."' and sm.f_alloc_id='".$data['f_alloc_id']."';";
			
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();

		return $query->result_array();
   } */
   
function search_students_data($data)
 {
	 $first= substr($data['prn'],0,5);
	  $pos=strpos($data['prn'],"SUN");
	 if($data['org']=="All"){
	$this->db->select("sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,sandipun_ums.student_master.admission_stream,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facilities.*,sandipun_erp.sf_student_facility_allocation.f_alloc_id,sandipun_erp.sf_student_facility_allocation.is_active,sandipun_erp.sf_student_facility_allocation.allocated_id");
	$this->db->from("sandipun_ums.student_master");
    $this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		 
		if( isset($data['cancel']) && $data['cancel']=="cancel" )
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='Y' and sandipun_erp.sf_student_facilities.sffm_id='1'");
	else
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='N' and sandipun_erp.sf_student_facilities.sffm_id='1'");
		
		$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\'','left');

		//$this->db->where("sandipun_erp.sf_student_facilities.organisation",$data['org']);
		if($data['prn']!='')
		{
		$this->db->where("sandipun_erp.sf_student_facilities.enrollment_no",$data['prn']);
		}
		if($data['acyear']!='')
		{
		$this->db->where("sandipun_erp.sf_student_facilities.academic_year",$data['acyear']);
		} 
		if($data['institute']!='')
		{
		$this->db->where("sandipun_ums.vw_stream_details.school_short_name",$data['institute']);
		}
		//$this->db->where("student_master.enrollment_no not like '19SUN%'");
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.student_id as stud_id,sm.program_id as admission_stream,sm.stream as stream_name, sm.course as course_name, sm.instute_name as school_name, ssf.*, sfa.f_alloc_id, sfa.is_active, sfa.allocated_id");
		$this->db->from("sf_student_master sm");
								
		//$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		
		$this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.sffm_id=1','left');
		
		$this->db->join('sf_student_facility_allocation as sfa','ssf.sf_id = sfa.sf_id and sfa.sffm_id=ssf.sffm_id and sfa.is_active="Y"','left');
		
		//$this->db->where("ssf.organisation",$data['org']);
		if($data['prn']!='')
		{
			$this->db->where("ssf.enrollment_no",$data['prn']);
		}
		if($data['acyear']!='')
		{
			$this->db->where("ssf.academic_year",$data['acyear']);
		}
		if($data['institute']!='')
		{
			$this->db->where("spd.college_name",$data['institute']);
		}				
		
		
		if( isset($data['cancel']) && $data['cancel']=="cancel" )
		 $this->db->where("ssf.cancelled_facility",'Y');
	 else
		 $this->db->where("ssf.cancelled_facility",'N');
		$query2 = $this->db->get_compiled_select();
		$query2 .="GROUP BY ssf.enrollment_no";
		$query = $this->db->query($query1." UNION ".$query2);
		//echo $this->db->last_query();exit();
		$data= $query->result_array();
	 }
	 else if($data['org']=="SU" ) // && !$pos
	{
		$this->db->select("sandipun_ums.student_master.*,sandipun_erp.sf_student_facilities.*,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facility_allocation.f_alloc_id,sandipun_erp.sf_student_facility_allocation.is_active,sandipun_erp.sf_student_facility_allocation.allocated_id");

		$this->db->from("sandipun_ums.student_master");

		 $this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		 
		if( isset($data['cancel']) && $data['cancel']=="cancel" )
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='Y' and sandipun_erp.sf_student_facilities.sffm_id='1'");
	else
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='N' and sandipun_erp.sf_student_facilities.sffm_id='1'");
		
		$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\'','left');
	
		$this->db->where("sandipun_erp.sf_student_facilities.organisation",$data['org']);
		if($data['prn']!='')
			{
		$this->db->where("sandipun_erp.sf_student_facilities.enrollment_no",$data['prn']);
			}
		if($data['acyear']!='')
		{
		$this->db->where("sandipun_erp.sf_student_facilities.academic_year",$data['acyear']);
		} 
		if($data['institute']!='')
		{
		$this->db->where("sandipun_ums.vw_stream_details.school_short_name",$data['institute']);
		}
			
	  $query = $this->db->get();
	//echo $this->db->last_query();//exit();
		 $data=$query->result_array();
		  // $data['organisation']="SU";
	}else{
		 if($pos)
			$org="SF";
		else
			$org=$data['org'];
			   
		$this->db->select("sm.student_id as stud_id,sm.organization,sm.stream as stream_name, sm.course as course_name, sm.instute_name as school_name,sm.academic_year,sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name,sfa.f_alloc_id,sfa.allocated_id,sfa.is_active,ssf.*,");
		$this->db->from("sf_student_master sm");
						
		//$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		
		$this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.sffm_id="1"','left');
		
		$this->db->join('sf_student_facility_allocation as sfa','ssf.sf_id = sfa.sf_id and sfa.sffm_id=ssf.sffm_id and sfa.is_active="Y"','left');
		
		$this->db->where("ssf.organisation",$org);
		if($data['prn']!='')
		{
			$this->db->where("ssf.enrollment_no",$data['prn']);
		}
		if($data['acyear']!='')
		{
			$this->db->where("ssf.academic_year",$data['acyear']);
		}
		if($data['institute']!='')
		{
			$this->db->where("spd.college_name",$data['institute']);
		}				
		
		
		if( isset($data['cancel']) && $data['cancel']=="cancel" )
		 $this->db->where("ssf.cancelled_facility",'Y');
		else
		 $this->db->where("ssf.cancelled_facility",'N');

		//$this->db->where("sfa.is_active",'Y');


		$result = $this->db->get();

		//echo $this->db->last_query();
		$data=$result->result_array();   
		//	  $data['organisation']="SF";
	}
	//var_dump($data);

	return $data;
	   
//var_dump($data);
	   
	   
	 
	 
 }
 
 public function allocated_list_export($data)
{
	//var_dump($data);exit();
	$pos=strpos($data['prn'],"SUN");
	 if($data['org']=="All")
	 {
		 $where="";
		if($data['prn']!='')
		$where.=" and f.enrollment_no='".$data['prn']."'";	
	
		 $ums_sf_sql="SELECT r.amount as refund_paid, f.amount as paid_amt, 
`sm`.`current_year`, `sm`.`gender`, 
`sm`.`mobile`, `sm`.`birth_place` as 
`address`, `sm`.`first_name`, `sm`.`middle_name`, 
`sm`.`last_name`,`sm`.`enrollment_no`, `sm`.`stud_id`, `sm`.`admission_stream`, 
`sandipun_ums`.`vw_stream_details`.`stream_short_name` as `stream_name`, 
`sandipun_ums`.`vw_stream_details`.`course_name`, 
`sandipun_ums`.`vw_stream_details`.`school_short_name` as `school_name`, 
`sandipun_erp`.`ssf`.* ,sfsf.f_alloc_id,sfsf.allocated_id,sfhrd.room_no,sfhrd.floor_no,sfhm.hostel_code,sfhm.hostel_name 
FROM `sandipun_erp`.`sf_student_facilities` as `ssf` 
INNER JOIN `sandipun_ums`.`student_master` as `sm` ON `sm`.`enrollment_no` = `ssf`.`enrollment_no` 
INNER JOIN `sandipun_ums`.`vw_stream_details` ON 
`sm`.`admission_stream` = 
`sandipun_ums`.`vw_stream_details`.`stream_id` 
left join (select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_details where type_id='1' and is_deleted='N' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_refunds where is_deleted='N' and type_id='1' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no  )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year left join sf_student_facility_allocation as sfsf on sfsf.sf_id=ssf.sf_id
left join sf_hostel_room_details as sfhrd on sfhrd.sf_room_id = sfsf.allocated_id 
left join sf_hostel_master as sfhm on sfhm.hostel_code = sfhrd.hostel_code 
WHERE  ssf.sffm_id=1 and sm.enrollment_no not like '18SUN%' and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'N' $where GROUP BY `ssf`.`enrollment_no` 
UNION 
SELECT r.amount as 
refund_paid, f.amount as paid_amt, `sm`.`current_year`, `sm`.`gender`, `sm`.`mobile`, 
`sm`.`Address` as `address`, `sm`.`first_name`, `sm`.`middle_name`, `sm`.`last_name`, `sm`.`enrollment_no`, 
`sm`.`student_id` as `stud_id`, `sm`.`program_id` as `admission_stream`, `sm`.`stream` as 
`stream_name`, `sm`.`course` as `course_name`, `sm`.`instute_name` as `school_name`, 
`ssf`.*,sfsf.f_alloc_id,sfsf.allocated_id,sfhrd.room_no,sfhrd.floor_no,sfhm.hostel_code,sfhm.hostel_name
FROM `sf_student_facilities` as `ssf` 
INNER JOIN `sf_student_master` `sm` ON `sm`.`enrollment_no` = `ssf`.`enrollment_no` 
left join (select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_details where type_id='1' and is_deleted='N' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_refunds where is_deleted='N' and type_id='1' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no  )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year left join sf_student_facility_allocation as sfsf on sfsf.sf_id=ssf.sf_id
left join sf_hostel_room_details as sfhrd on sfhrd.sf_room_id = sfsf.allocated_id 
left join sf_hostel_master as sfhm on sfhm.hostel_code = sfhrd.hostel_code 
WHERE  ssf.sffm_id=1 and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'N' $where GROUP BY `ssf`.`enrollment_no`";
		
		$query2 = $this->db->query($ums_sf_sql);
		//echo $this->db->last_query();exit();
		$data= $query2->result_array();
	 }
	 else if($data['org']=="SU"  && !$pos)
	{
		$where="";
		if($data['prn']!='')
		$where.=" and f.enrollment_no='".$data['prn']."'";	
	
		 $ums_sql="SELECT r.amount as refund_paid, f.amount as paid_amt, 
`sm`.`current_year`, `sm`.`gender`, 
`sm`.`mobile`, `sm`.`birth_place` as 
`address`, `sm`.`first_name`, `sm`.`middle_name`, 
`sm`.`last_name`,`sm`.`enrollment_no`, `sm`.`stud_id`, `sm`.`admission_stream`, 
`sandipun_ums`.`vw_stream_details`.`stream_short_name` as `stream_name`, 
`sandipun_ums`.`vw_stream_details`.`course_name`, 
`sandipun_ums`.`vw_stream_details`.`school_short_name` as `school_name`, 
`sandipun_erp`.`ssf`.*,sfsf.f_alloc_id,sfsf.allocated_id,sfhrd.room_no,sfhrd.floor_no,sfhm.hostel_code,sfhm.hostel_name
FROM `sandipun_erp`.`sf_student_facilities` as `ssf` 
INNER JOIN `sandipun_ums`.`student_master` as `sm` ON `sm`.`enrollment_no` = `ssf`.`enrollment_no` 
INNER JOIN `sandipun_ums`.`vw_stream_details` ON 
`sm`.`admission_stream` = 
`sandipun_ums`.`vw_stream_details`.`stream_id` 
left join (select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_details where type_id='1' and is_deleted='N' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_refunds where is_deleted='N' and type_id='1' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year left join sf_student_facility_allocation as sfsf on sfsf.sf_id=ssf.sf_id
left join sf_hostel_room_details as sfhrd on sfhrd.sf_room_id = sfsf.allocated_id 
left join sf_hostel_master as sfhm on sfhm.hostel_code = sfhrd.hostel_code 
WHERE  ssf.sffm_id=1 and sm.enrollment_no not like '18SUN%' and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'N' $where GROUP BY `ssf`.`enrollment_no` ";
		
		$query1 = $this->db->query($ums_sql);
		//echo $this->db->last_query();exit();
		$data= $query1->result_array();
	}
else
	{
		 if($pos)
			$org="SF";
		else
			$org=$data['org'];
		$where="";
		if($data['prn']!='')
		$where.=" and f.enrollment_no='".$data['prn']."'";	
	
		$sql="SELECT r.amount as 
refund_paid, f.amount as paid_amt, `sm`.`current_year`, `sm`.`gender`, `sm`.`mobile`, 
`sm`.`Address` as `address`, `sm`.`first_name`, `sm`.`middle_name`, `sm`.`last_name`, `sm`.`enrollment_no`, `sm`.`student_id` as `stud_id`, `sm`.`program_id` as `admission_stream`, `sm`.`stream` as 
`stream_name`, `sm`.`course` as `course_name`, `sm`.`instute_name` as `school_name`, 
`ssf`.*,sfsf.f_alloc_id,sfsf.allocated_id,sfhrd.room_no,sfhrd.floor_no,sfhm.hostel_code,sfhm.hostel_name FROM `sf_student_facilities` as `ssf` 
INNER JOIN `sf_student_master` `sm` ON `sm`.`enrollment_no` = `ssf`.`enrollment_no` 
left join (select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_details where type_id='1' and is_deleted='N' and `academic_year` = '".$data['acyear']."' group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_refunds where is_deleted='N' and type_id='1' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year 
left join sf_student_facility_allocation as sfsf on sfsf.sf_id=ssf.sf_id
left join sf_hostel_room_details as sfhrd on sfhrd.sf_room_id = sfsf.allocated_id 
left join sf_hostel_master as sfhm on sfhm.hostel_code = sfhrd.hostel_code 
WHERE ssf.sffm_id=1 and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'N' AND ssf.organisation='".$org."' $where GROUP BY `ssf`.`enrollment_no`";
		
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		$data= $query->result_array();
	}
	//var_dump($data);

	return $data;
	   
//var_dump($data);
	   
}	
 
public function cancelled_list_export($data)
{
	//var_dump($data);exit();
	$pos=strpos($data['prn'],"SUN");
	 if($data['org']=="All")
	 {
		 $where="";
		if($data['prn']!='')
		$where.=" and f.enrollment_no='".$data['prn']."'";	
	
		 $ums_sf_sql="SELECT r.amount as refund_paid, f.amount as paid_amt, 
`sm`.`current_year`, `sm`.`gender`, 
`sm`.`mobile`, `sm`.`birth_place` as 
`address`, `sm`.`first_name`, `sm`.`middle_name`, 
`sm`.`last_name`,`sm`.`enrollment_no`, `sm`.`stud_id`, `sm`.`admission_stream`, 
`sandipun_ums`.`vw_stream_details`.`stream_short_name` as `stream_name`, 
`sandipun_ums`.`vw_stream_details`.`course_name`, 
`sandipun_ums`.`vw_stream_details`.`school_short_name` as `school_name`, 
`sandipun_erp`.`ssf`.*   
FROM `sandipun_erp`.`sf_student_facilities` as `ssf` 
INNER JOIN `sandipun_ums`.`student_master` as `sm` ON `sm`.`enrollment_no` = `ssf`.`enrollment_no` 
INNER JOIN `sandipun_ums`.`vw_stream_details` ON 
`sm`.`admission_stream` = 
`sandipun_ums`.`vw_stream_details`.`stream_id` 
left join (select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_details where type_id='1' and is_deleted='N' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_refunds where is_deleted='N' and type_id='1' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no  )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year 
WHERE  ssf.sffm_id=1 and sm.enrollment_no not like '18SUN%' and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'Y' $where GROUP BY `ssf`.`enrollment_no` 
UNION 
SELECT r.amount as 
refund_paid, f.amount as paid_amt, `sm`.`current_year`, `sm`.`gender`, `sm`.`mobile`, 
`sm`.`Address` as `address`, `sm`.`first_name`, `sm`.`middle_name`, `sm`.`last_name`, `sm`.`enrollment_no`, 
`sm`.`student_id` as `stud_id`, `sm`.`program_id` as `admission_stream`, `sm`.`stream` as 
`stream_name`, `sm`.`course` as `course_name`, `sm`.`instute_name` as `school_name`, 
`ssf`.*
FROM `sf_student_facilities` as `ssf` 
INNER JOIN `sf_student_master` `sm` ON `sm`.`enrollment_no` = `ssf`.`enrollment_no` 
left join (select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_details where type_id='1' and is_deleted='N' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_refunds where is_deleted='N' and type_id='1' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no  )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year 
WHERE  ssf.sffm_id=1 and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'Y' $where GROUP BY `ssf`.`enrollment_no`";
		
		$query2 = $this->db->query($ums_sf_sql);
		//echo $this->db->last_query();exit();
		$data= $query2->result_array();
	 }
	 else if($data['org']=="SU"  && !$pos)
	{
		$where="";
		if($data['prn']!='')
		$where.=" and f.enrollment_no='".$data['prn']."'";	
	
		 $ums_sql="SELECT r.amount as refund_paid, f.amount as paid_amt, 
`sm`.`current_year`, `sm`.`gender`, 
`sm`.`mobile`, `sm`.`birth_place` as 
`address`, `sm`.`first_name`, `sm`.`middle_name`, 
`sm`.`last_name`,`sm`.`enrollment_no`, `sm`.`stud_id`, `sm`.`admission_stream`, 
`sandipun_ums`.`vw_stream_details`.`stream_short_name` as `stream_name`, 
`sandipun_ums`.`vw_stream_details`.`course_name`, 
`sandipun_ums`.`vw_stream_details`.`school_short_name` as `school_name`, 
`sandipun_erp`.`ssf`.*   
FROM `sandipun_erp`.`sf_student_facilities` as `ssf` 
INNER JOIN `sandipun_ums`.`student_master` as `sm` ON `sm`.`enrollment_no` = `ssf`.`enrollment_no` 
INNER JOIN `sandipun_ums`.`vw_stream_details` ON 
`sm`.`admission_stream` = 
`sandipun_ums`.`vw_stream_details`.`stream_id` 
left join (select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_details where type_id='1' and is_deleted='N' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_refunds where is_deleted='N' and type_id='1' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year 
WHERE  ssf.sffm_id=1 and sm.enrollment_no not like '18SUN%' and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'Y' and `ssf`.`organisation` = '".$data['org']."' $where GROUP BY `ssf`.`enrollment_no` ";
		
		$query1 = $this->db->query($ums_sql);
		//echo $this->db->last_query();exit();
		$data= $query1->result_array();
	}
else
	{
		 if($pos)
			$org="SF";
		else
			$org=$data['org'];
		$where="";
		if($data['prn']!='')
		$where.=" and f.enrollment_no='".$data['prn']."'";	
	
		$sql="SELECT r.amount as 
refund_paid, f.amount as paid_amt, `sm`.`current_year`, `sm`.`gender`, `sm`.`mobile`, 
`sm`.`Address` as `address`, `sm`.`first_name`, `sm`.`middle_name`, `sm`.`last_name`, `sm`.`enrollment_no`, `sm`.`student_id` as `stud_id`, `sm`.`program_id` as `admission_stream`, `sm`.`stream` as 
`stream_name`, `sm`.`course` as `course_name`, `sm`.`instute_name` as `school_name`, 
`ssf`.* FROM `sf_student_facilities` as `ssf` 
INNER JOIN `sf_student_master` `sm` ON `sm`.`enrollment_no` = `ssf`.`enrollment_no` 
left join (select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_details where type_id='1' and is_deleted='N' and `academic_year` = '".$data['acyear']."' group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_refunds where is_deleted='N' and type_id='1' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year 
WHERE  ssf.sffm_id=1 and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'Y'  and `ssf`.`organisation` = '".$data['org']."' $where GROUP BY `ssf`.`enrollment_no`";
		
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		$data= $query->result_array();
	}
	//var_dump($data);

	return $data;
	   
//var_dump($data);
	   
}	
 
   
function h_students_data($data)
{
		$temp='';
		if(!empty($_POST['chk_stud'])  && isset($_POST['chk_stud']) ){
			for($i = 0; $i < count($_POST['chk_stud']); $i++){
				$temp.=str_replace("_","/", ($_POST['chk_stud'][$i].','));
			}
			$temp=substr($temp, 0, -1);
		}
		
		if(!empty($_POST['chk_stud1'])  && isset($_POST['chk_stud1']) ){
			for($i = 0; $i < count($_POST['chk_stud1']); $i++){
				$temp.=str_replace("_","/", ($_POST['chk_stud1'][$i].','));
			}
			$temp=substr($temp, 0, -1);
		}
		//var_dump($data);exit();
	if(($data['arg_org']=="All" && isset($_POST['arg_org'])) || ($data['arg_org1']=="All" && isset($_POST['arg_org1'])))
	 {
		$this->db->select("sum(r.amount) as refund_paid,sum(sfd.amount) as paid_amt,sandipun_ums.student_master.current_year,sandipun_ums.student_master.gender,sandipun_ums.student_master.mobile,sandipun_ums.student_master.birth_place as address,shrd.floor_no,shrd.room_no, shm.hostel_code, sandipun_ums.student_master.first_name, sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,sandipun_ums.student_master.admission_stream,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name, sandipun_ums.vw_stream_details.school_short_name as school_name, sandipun_erp.sf_student_facilities.*, sandipun_erp.sf_student_facility_allocation.f_alloc_id, sandipun_erp.sf_student_facility_allocation.is_active,sandipun_erp.sf_student_facility_allocation.allocated_id");
		$this->db->from("sandipun_ums.student_master");

		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		 
		if($data['arg_org1']!=="" && isset($_POST['arg_org1']))
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='Y' and sandipun_erp.sf_student_facilities.sffm_id='1'");
	else
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='N' and sandipun_erp.sf_student_facilities.sffm_id='1'");
				
		$this->db->join("sandipun_erp.sf_fees_refunds as r", "r.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.academic_year=r.academic_year");
		
		$this->db->join("sandipun_erp.sf_fees_details as sfd",'sfd.student_id = sandipun_ums.student_master.stud_id and sfd.enrollment_no=sandipun_ums.student_master.enrollment_no and sfd.type_id=1');		
		$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\'','left');
		
		$this->db->join('sandipun_erp.sf_hostel_room_details as shrd','shrd.sf_room_id = sandipun_erp.sf_student_facility_allocation.allocated_id','left');
				
		$this->db->join('sandipun_erp.sf_hostel_master as shm','shm.hostel_code = shrd.hostel_code','left');
		
		if($data['arg_acyear']!=="" && isset($_POST['arg_acyear']))
		{
		$this->db->where("sandipun_erp.sf_student_facilities.academic_year",$data['arg_acyear']);
		$this->db->where("sfd.academic_year",$data['arg_acyear']);
		} 

		if($data['arg_acyear1']!=="" && isset($_POST['arg_acyear1']))
		{
		$this->db->where("sandipun_erp.sf_student_facilities.academic_year",$data['arg_acyear1']);
		$this->db->where("sfd.academic_year",$data['arg_acyear1']);
		}
		
		$this->db->where("student_master.enrollment_no not like '18SUN%'");
		$this->db->group_by('sandipun_erp.sf_student_facilities.enrollment_no'); 
		//echo $this->db->last_query();exit();
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("sum(r.amount) as refund_paid,sum(sfd.amount) as paid_amt,sm.current_year,sm.gender,sm.mobile,sm.Address as address,shrd.floor_no,shrd.room_no, shm.hostel_code, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no, sm.student_id as stud_id,sm.program_id as admission_stream,sm.stream as stream_name, sm.course as course_name, sm.instute_name as school_name,ssf.*,sfa.f_alloc_id, sfa.is_active,sfa.allocated_id");
		$this->db->from("sf_student_master sm");
		
		$this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.sffm_id="1"','left');
		
		$this->db->join("sf_fees_refunds as r", "r.enrollment_no = ssf.enrollment_no and ssf.academic_year=r.academic_year");
		
$this->db->join("sf_fees_details as sfd",'sfd.student_id = sm.student_id and sfd.enrollment_no=sm.enrollment_no and sfd.type_id=1');
		
		$this->db->join('sf_student_facility_allocation as sfa','ssf.sf_id = sfa.sf_id and sfa.sffm_id=ssf.sffm_id and sfa.is_active="Y"','left');
		
		$this->db->join('sf_hostel_room_details as shrd','shrd.sf_room_id = sfa.allocated_id','left');
				
		$this->db->join('sf_hostel_master as shm','shm.hostel_code = shrd.hostel_code','left');

		if($data['arg_acyear']!=="" && isset($_POST['arg_acyear']))
		{
		$this->db->where("ssf.academic_year",$data['arg_acyear']);
		$this->db->where("sfd.academic_year",$data['arg_acyear']);
		} 

		if($data['arg_acyear1']!=="" && isset($_POST['arg_acyear1']))
		{
		$this->db->where("ssf.academic_year",$data['arg_acyear1']);
		$this->db->where("sfd.academic_year",$data['arg_acyear1']);
		}
		
		if($data['arg_org1']!=="" && isset($_POST['arg_org1']))
		 $this->db->where("ssf.cancelled_facility",'Y');
	 else
		 $this->db->where("ssf.cancelled_facility",'N');
	
	$this->db->group_by('ssf.enrollment_no'); 	
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1." UNION ".$query2);
		
		$data= $query->result_array();
		//echo $this->db->last_query();exit();
	 }
	 else if(($data['arg_org']=="SU" && isset($_POST['arg_org'])) || ($data['arg_org1']=="SU" && isset($_POST['arg_org1'])))
	{
		$this->db->select("sum(r.amount) as refund_paid,sum(sfd.amount) as paid_amt,sandipun_ums.student_master.birth_place as address,shrd.floor_no,shrd.room_no,shm.hostel_code,sandipun_ums.student_master.current_year,sandipun_ums.student_master.admission_stream,sandipun_ums.student_master.admission_school,sandipun_ums.student_master.gender,sandipun_ums.student_master.dob,sandipun_ums.student_master.blood_group,sandipun_ums.student_master.mobile,sandipun_ums.student_master.adhar_card_no,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_erp.sf_student_facilities.*,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facility_allocation.f_alloc_id,sandipun_erp.sf_student_facility_allocation.is_active,sandipun_erp.sf_student_facility_allocation.allocated_id");

				$this->db->from("sandipun_ums.student_master");

				 $this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
				 $this->db->join("sandipun_erp.sf_fees_details as sfd",'sfd.student_id = sandipun_ums.student_master.stud_id and sfd.enrollment_no=sandipun_ums.student_master.enrollment_no and sfd.type_id=1');
				if($data['arg_org']!=="" && isset($_POST['arg_org']))
					$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='N' and sandipun_erp.sf_student_facilities.sffm_id='1'",'left');
				else
					$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='Y' and sandipun_erp.sf_student_facilities.sffm_id='1'",'left');
				
				$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\'','left');
			
				$this->db->join('sandipun_erp.sf_hostel_room_details as shrd','shrd.sf_room_id = sandipun_erp.sf_student_facility_allocation.allocated_id','left');
				
				$this->db->join('sandipun_erp.sf_hostel_master as shm','shm.hostel_code = shrd.hostel_code','left');
				
				if($data['arg_org']!=="" && isset($_POST['arg_org']))
				{
				$this->db->where("sandipun_erp.sf_student_facilities.organisation",$data['arg_org']);
				}
				if($data['arg_org1']!=="" && isset($_POST['arg_org1']))
				{
				$this->db->where("sandipun_erp.sf_student_facilities.organisation",$data['arg_org1']);
				}
				
				if($temp!=="" && strlen($temp)>0)
				{
				$this->db->where("sandipun_erp.sf_student_facilities.sf_id in(".$temp.")",NULL, false);
				}
				
				if($data['arg_acyear']!=="" && isset($_POST['arg_acyear']))
				{
				$this->db->where("sandipun_erp.sf_student_facilities.academic_year",$data['arg_acyear']);
				$this->db->where("sfd.academic_year",$data['arg_acyear']);
				}
				if($data['arg_acyear1']!=="" && isset($_POST['arg_acyear1']))
				{
				$this->db->where("sandipun_erp.sf_student_facilities.academic_year",$data['arg_acyear1']);
				$this->db->where("sfd.academic_year",$data['arg_acyear1']);
				}

				if($data['arg_institute']!=="")
				{
				$this->db->where("sandipun_ums.vw_stream_details.school_short_name",$data['arg_institute']);
				}
				$this->db->group_by('sandipun_erp.sf_student_facilities.enrollment_no');
					
				$query = $this->db->get();
				//echo $this->db->last_query();exit();
				$data=$query->result_array();
				// $data['organisation']="SU";
			}
		else
			{
				$org='SF';
				$this->db->select("sum(r.amount) as refund_paid,sum(sfd.amount) as paid_amt,shrd.floor_no,shrd.room_no,shm.hostel_code,sm.student_id as stud_id,sm.organization,sm.current_year,sm.program_id,sm.gender,sm.mobile,sm.Address as address,sm.first_name, sm.middle_name,sm.last_name, sfa.f_alloc_id, sfa.allocated_id,sfa.is_active,ssf.*, sm.stream as stream_name,sm.stream,sm.course, sm.course as course_name, sm.instute_name as school_name,");
				$this->db->from("sf_student_master sm");
								
				//$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
				
				if($data['arg_acyear']!='' && isset($_POST['arg_acyear']))
					$this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.sffm_id="1" and ssf.cancelled_facility="N"','left');
				else
					$this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.sffm_id="1" and ssf.cancelled_facility="Y"','left');
				$this->db->join("sf_fees_refunds as r", "r.enrollment_no = ssf.enrollment_no and ssf.academic_year=r.academic_year");
				
				$this->db->join("sf_fees_details as sfd",'sfd.student_id = sm.student_id and sfd.enrollment_no=sm.enrollment_no and sfd.type_id=1');
				$this->db->join('sf_student_facility_allocation as sfa','ssf.sf_id = sfa.sf_id and sfa.sffm_id=ssf.sffm_id and sfa.is_active="Y"','left');
				
				$this->db->join('sf_hostel_room_details as shrd','shrd.sf_room_id = sfa.allocated_id','left');
				
				$this->db->join('sf_hostel_master as shm','shm.hostel_code = shrd.hostel_code','left');
				if($data['arg_org']!='' && isset($_POST['arg_org']))
				{
				$this->db->where("ssf.organisation",$org);
				}
				if($data['arg_org1']!='' && isset($_POST['arg_org1']))
				{
				$this->db->where("ssf.organisation",$org);
				}
				
				if($temp!=="" && strlen($temp)>0)
				{
					//echo "ghghgh";exit();
				$this->db->where("ssf.sf_id in(".$temp.")",NULL, false);
				//where("App.id IN (".$subquery.")",NULL, false)
				}
				if($data['arg_acyear']!='' && isset($_POST['arg_acyear']))
				{
					$this->db->where("ssf.academic_year",$data['arg_acyear']);
					$this->db->where("sfd.academic_year",$data['arg_acyear']);
				}
				if($data['arg_acyear1']!='' && isset($_POST['arg_acyear1']))
				{
					$this->db->where("ssf.academic_year",$data['arg_acyear1']);
					$this->db->where("sfd.academic_year",$data['arg_acyear1']);
				}
				if($data['arg_institute']!='')
				{
					$this->db->where("spd.college_name",$data['arg_institute']);
				}				
				
			$this->db->group_by('ssf.enrollment_no');
			 
			//$this->db->where("sfa.is_active",'Y');
			 
				
				$result = $this->db->get();
								
				//echo $this->db->last_query();exit();
				 $data=$result->result_array();   
					//	  $data['organisation']="SF";
			}
			//var_dump($data);
		
			return $data;
	   
//var_dump($data);
	   
	   
	 
	 
 }
 
 function cancel_list($data)
 {
	 $sql="SELECT sm.student_id as stud_id,sm.organization,sm.current_year,sm.program_id,sm.gender,sm.mobile,sm.Address as address,sm.first_name, sm.middle_name,sm.last_name,sm.stream as stream_name,sm.stream,sm.course, sm.course as course_name, sm.instute_name as school_name,sum(r.amount) as refund_paid, sum(f.amount) as amt_paid,sfsf.* FROM sf_student_facilities as sfsf inner join sf_student_master as sm on sm.enrollment_no=sfsf.enrollment_no
inner join (select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_details where type_id='1' and is_deleted='N'
group by enrollment_no  ,academic_year ) f on sfsf.enrollment_no=f.enrollment_no  and 
f.academic_year=sfsf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_refunds where is_deleted='N'
group by enrollment_no  ,academic_year )
 r on sfsf.enrollment_no=r.enrollment_no  and 
r.academic_year=sfsf.academic_year
where f.academic_year='".$data['arg_acyear1']."' group by f.academic_year;";
  $query1 = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query1->result_array();
 }
 
 public function check_su_pnr($pnr){
 $DB1 = $this->load->database('umsdb',TRUE);
            
		$DB1->select("sm.stud_id,sm.first_name,sm.middle_name,sm.last_name,sm.form_number,sm.academic_year,
		sm.admission_year,sm.current_year,sm.admission_semester,sm.mobile,sm.email,sm.current_semester,
		sm.admission_session,sm.enrollment_no,vsd.stream_name as stream_short_name,vsd.course_name as course_short_name,
		vsd.school_name");
		$DB1->from('student_master as sm');
		$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
		//$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		//	$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
			//$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	    
     
       $DB1->where('sm.enrollment_no',$pnr);     
	   //$DB1->where('sm.academic_year',$acyear);
	   
     //  $DB1->where('type_id',$type_id);        
       $query = $DB1->get();
      //echo $DB1->last_query();
	//  exit();
     return $query->result_array();
 }
 
   
   function load_hostel_students()
   {
       $acyear = $_POST['acyear'];
	    $acd=$acyear+1;
       $acy=$acyear."-".$acd;
       $org = $_POST['org'];
	   $prn = $_POST['prn'];
	   //$data['academic']=$_POST['acyear'];
       //var_dump($_POST);
       $check= $this->fetch_student_data($_POST['prn'],$acyear,$_POST['org']);  
	  // print_r($check).'y';
	  // echo 'STU';
	 ///  die;
       $pos=strpos($_POST['prn'],"SUN");
       if($check['enrollment_no']=='')
       {
           
           
           
       if($_POST['org']=="SU") //if($_POST['org']=="SU"  && !$pos)
       {
		  // echo 'test';
		  // die;
            $DB1 = $this->load->database('umsdb',TRUE);
            
		$DB1->select("sm.stud_id,sm.first_name,sm.middle_name,sm.last_name,sm.form_number,sm.academic_year,
		sm.admission_year,sm.current_year,sm.admission_semester,sm.mobile,sm.email,sm.current_semester,
		sm.admission_session,sm.enrollment_no,vsd.stream_name as stream_short_name,vsd.course_name as course_short_name,
		vsd.school_name");
		$DB1->from('student_master as sm');
		$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
		//$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		//	$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
			//$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	    
     
       $DB1->where('sm.enrollment_no',$_POST['prn']);     
	   //$DB1->where('sm.academic_year',$acyear);
	   
     //  $DB1->where('type_id',$type_id);        
       $query = $DB1->get();
      //echo $DB1->last_query();
	//  exit();
     $data= $query->row_array();
            $data['organisation']="SU";
       }
      // elseif($_POST['org']=="SF")
      else
       {
		   if($pos)
				   $org="SF";

			
			
          $this->db->select("sm.stream,sm.course,sm.student_id as stud_id,sm.enrollment_no,sm.current_year,sm.first_name,sm.organization as organisation,sm.instute_name as school_name,sm.middle_name,sm.last_name,
		  sm.admission_session, sm.academic_year,sm.mobile,sm.email,sm.course as course_short_name, sm.stream as stream_short_name");
        $this->db->from("sf_student_master sm");
         $this->db->where("enrollment_no",$_POST['prn']);
		 //$this->db->where("academic_year",$acyear);
		 $this->db->where("sm.organization",$org);
         	//$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
        $result = $this->db->get();
		//echo 'sf=='.$this->db->last_query();
         $data=$result->row_array();
         // $data['organisation']="SF";
         
      
           //print_r($data);
		  // die();
           //$DB1 = $this->load->database('umsdb',TRUE); 
       }
       
	   
	   
       if(($data['enrollment_no']=='') && ($_POST['org']=="SF"))
			{
				 $ch = curl_init();
			    //$sms=$sms_message;
				$query="?UserName=SUN321&ApiKey=SU-API-Enrolled-Stud&SId=".$prn."&AYNAme=".$acy;
				/*echo 'https://www.sandipuniversity.edu.in/request_api.php'.$query;
				die;*/
			    //echo $query;
			    //exit;
			    curl_setopt($ch, CURLOPT_POST, 1);
			    curl_setopt($ch, CURLOPT_URL,'https://www.sandipuniversity.edu.in/request_api.php'.$query); //test
			    
			    //curl_setopt($ch, CURLOPT_URL,'http://103.224.243.182:182/RequestApi.aspx'.$query); 
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
				curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));


			   // curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1);//103.255.100.77 //http://bulksms.omegatelesolutions.com

			    $res = trim(curl_exec($ch)); 
				
			    $resArr = json_decode($res);
			    //print_r($resArr);
			     curl_close($ch);
			    /* die;*/
			     
			   
			    if(empty($resArr))
			    {
			    	 echo "PRN number does not exist";
	  				 exit();
			    }
			    
			    else
			    {
			    	$email_id=$resArr[0]->email;
			    	if($email_id!=''|| $email_id='null')
			    	{
			    		$emailid='';
			    	}
			    	else
			    	{
			    		$emailid=$resArr[0]->email;
			    	}
					
		    		$currentyear=explode("-",$resArr[0]->current_year);
		    		$admissioyear=explode("-",$resArr[0]->admission_session);
		    		$academicyear=explode("-",$resArr[0]->academic_year);
		    		$student_list['enrollment_no']=$resArr[0]->enrollment_no;
					$student_list['first_name']=$resArr[0]->first_name;
					$student_list['middle_name']=$resArr[0]->middle_name;
					$student_list['last_name']=$resArr[0]->last_name;
					$student_list['gender']=$resArr[0]->gender;
					$student_list['mobile']=$resArr[0]->student_mobile;
					$student_list['email']=$emailid;
					$student_list['parent_mobile1']=$resArr[0]->parent_mobile;
					$student_list['Address']=$resArr[0]->address;
					$student_list['taluka']= $resArr[0]->taluka_name;
					$student_list['district']= $resArr[0]->district_name;
					$student_list['state']= $resArr[0]->state_name;
					$student_list['pincode']= $resArr[0]->pincode;
					$student_list['instute_name']= $resArr[0]->institute_name;
					$student_list['course']= $resArr[0]->course;
					$student_list['stream']=$resArr[0]->stream;
					$student_list['current_year']= $currentyear[0];
					$student_list['admission_session']=$admissioyear[0];
					$student_list['academic_year']= $academicyear[0];
					$student_list['isactive']= $resArr[0]->active;
					$student_list['organization']='SF';
					$student_list['created_on']= date('Y-m-d h:i:s');
					
					
					$check_su=$this->check_su_pnr($_POST['prn']);
					if(empty($check_su)){
					$this->db->insert("sf_student_master", $student_list); 
					}
					//echo $this->db->last_query();exit();
					$last_inserted_id=$this->db->insert_id(); 
					$student_list['stud_id']=$last_inserted_id; 
					//fetch data of student form sf student master 
					$this->db->select("sm.stream,sm.course,sm.student_id as stud_id,sm.enrollment_no,sm.current_year,sm.first_name,sm.organization as organisation,sm.instute_name as school_name,sm.middle_name,sm.last_name,
				  sm.admission_session, sm.academic_year,sm.mobile,sm.email,sm.course as course_short_name, sm.stream as stream_short_name");
		        $this->db->from("sf_student_master sm");
		         $this->db->where("enrollment_no",$_POST['prn']);
				 //$this->db->where("academic_year",$acyear);
				 $this->db->where("sm.organization",$org);
		         	//$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		        $result = $this->db->get();
				//echo 'sf=='.$this->db->last_query();
		         $data=$result->row_array();  
				}
			}
       $data['stat']='N';
       $data['academic']=$_POST['acyear'];
     
	 
	 
	   }
       else
       {
           
		   
		   
		    if($_POST['org']=="SU") //if($_POST['org']=="SU"  && !$pos) edited on 28/06/2019
			{
				$this->db->select("sandipun_ums.student_master.*,sandipun_erp.sf_student_facilities.*,sandipun_ums.vw_stream_details.stream_short_name ,sandipun_ums.vw_stream_details.course_short_name,sandipun_ums.vw_stream_details.school_short_name");

				$this->db->from("sandipun_ums.student_master");

				$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");


				$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.sffm_id=1");

				$this->db->where("sandipun_ums.student_master.enrollment_no",$_POST['prn']);
				$this->db->where("sandipun_erp.sf_student_facilities.academic_year",$acyear);


				$query = $this->db->get();
				//echo $this->db->last_query();
				$data=$query->row_array();
				$data['organisation']="SU";
			}
			else
			{
				if($pos)
				   $org="SF";
			   
			   
				$this->db->select("sm.stream,sm.course,sm.student_id as stud_id,sm.enrollment_no,sm.current_year,sm.first_name,sm.organization as organisation,sm.instute_name as school_name, sm.middle_name, sm.last_name,sm.admission_session ,sm.academic_year, sm.mobile,sm.email, concat(sm.course,'[',sm.stream,']') as stream_short_name");
				$this->db->from("sf_student_master sm");
				//$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
				$this->db->join('sf_student_facilities as ssf','ssf.enrollment_no = sm.enrollment_no and ssf.sffm_id=1');
				$this->db->where("sm.enrollment_no",$_POST['prn']);
				$this->db->where("ssf.academic_year",$acyear);
				$this->db->where("sm.organization",$org);
				$result = $this->db->get();
				//echo $this->db->last_query();exit();
				$data=$result->row_array();   
				// $data['organisation']="SF";
				          
			}
           
           
           
             $data['stat']='Y';
			 $data['academic']=$_POST['acyear'];
       }
     //var_dump($data);exit();
  return $data;
       
   }
   
   
   
   function fetch_student_data($prn,$acyear,$org,$facility_id='')
   {
       
       $this->db->select("*");
       $this->db->from("sf_student_facilities");
       $this->db->where("enrollment_no",$prn);
	   $this->db->where("academic_year",$acyear);
	   $this->db->where("organisation",$org);
	   $this->db->where("sffm_id",1);
       $this->db->where("cancelled_facility",'N');
	   $this->db->where("status",'Y');
        $result = $this->db->get();
		//echo $this->db->last_query();
         $data=$result->result_array();
       return $data;
   }
   

   
   function test()
   {
        $DB1 = $this->load->database('umsdb',TRUE);
            $DB2 = $this->load->database('default',TRUE);
           
            $this->db->select("sandipun_ums.student_master.*,sandipun_erp.sf_student_facilities.*");

    $this->db->from("sandipun_ums.student_master");

    $this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.student_prn");

    $this->db->where("sandipun_ums.student_master.enrollment_no", "170112038");

    //$this->db->order_by('database2.tablename.id', 'DESC');

    $query = $this->db->get();
        echo $this->db->last_query();
        //   $result = $this->db->get();
         $data=$query->row_array();
         var_dump($data);
         
   }
   public function de_allocate_bed($data)
	{
		$temp['is_active']='N';
		$temp['modified_ip']=$_SERVER['REMOTE_ADDR'];
		$temp['modified_by']=$this->session->userdata("uid");
		$temp['modified_on']=date("Y-m-d H:i:s");
		$this->db->where('f_alloc_id', $data['f_alloc_id']);
		$this->db->update('sf_student_facility_allocation', $temp);
		return $this->db->affected_rows();
	}
	public function check_allocate($data)
	{
		$sql="select f_alloc_id From sf_student_facility_allocation WHERE enrollment_no='".$data['enrollment_no']."' and academic_year='".$data['academic_year']."' and is_active!='N';";
		
		//echo $sql.$where;exit();
        $query = $this->db->query($sql);
	//	echo $this->db->last_query();exit;
		return $check =  $query->row()->f_alloc_id;
	}
public function student_hostel_details($val)
 {
	if($val['organisation']=="SU" )
	{
		$this->db->select("sandipun_ums.student_master.*,sandipun_erp.sf_student_facilities.*,sandipun_ums.student_master.admission_stream,sandipun_ums.vw_stream_details.stream_short_name as stream_name, sandipun_ums.vw_stream_details.course_name, sandipun_ums.vw_stream_details.school_short_name as school_name, sandipun_erp.sf_hostel_master.*, sandipun_erp.sf_hostel_room_details.room_no,sandipun_erp.sf_hostel_room_details.floor_no");

		$this->db->from("sandipun_ums.student_master");

		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");


		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.sffm_id=1");
		
		$this->db->join("sandipun_erp.sf_student_facility_allocation", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facility_allocation.enrollment_no and sandipun_erp.sf_student_facility_allocation.academic_year=sandipun_erp.sf_student_facilities.academic_year and sandipun_erp.sf_student_facility_allocation.sf_id=sandipun_erp.sf_student_facilities.sf_id and sandipun_erp.sf_student_facility_allocation.is_active='Y'");
		
		$this->db->join("sandipun_erp.sf_hostel_room_details", "sandipun_erp.sf_hostel_room_details.sf_room_id = sandipun_erp.sf_student_facility_allocation.allocated_id ");
		
		$this->db->join("sandipun_erp.sf_hostel_master", "sandipun_erp.sf_hostel_room_details.host_id = sandipun_erp.sf_hostel_master.host_id ");

		$this->db->where("sandipun_ums.student_master.enrollment_no",$val['enrollment_no']);
		$this->db->where("sandipun_erp.sf_student_facilities.academic_year",$val['academic_year']);


		$query = $this->db->get();
		//echo $this->db->last_query();
		$data=$query->row_array();
		//$data['organisation']="SU";
	}
	else
	{
		//echo "inside else";
	$this->db->select("ssf.*,sm.*,sm.organization as organisation, hm.*,hrd.floor_no,hrd.room_no,sfa.allocated_id,sm.program_id as admission_stream,sm.stream as stream_name, sm.course as course_name, sm.instute_name as school_name,");
		$this->db->from("sf_student_master sm");
		
		//$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		$this->db->join('sf_student_facilities as ssf','ssf.enrollment_no = sm.enrollment_no and ssf.sffm_id=1');
		$this->db->join('sf_student_facility_allocation as sfa','sfa.enrollment_no = sm.enrollment_no and sfa.academic_year=ssf.academic_year and sfa.sf_id=ssf.sf_id and sfa.is_active="Y"');
		$this->db->join('sf_hostel_room_details as hrd','hrd.sf_room_id = sfa.allocated_id');
		$this->db->join('sf_hostel_master as hm','hm.hostel_code = hrd.hostel_code');
		$this->db->where("sfa.is_active",'Y');

		$this->db->where("sm.enrollment_no",$val['enrollment_no']);

		$this->db->where("ssf.academic_year",$val['academic_year']);
		$result = $this->db->get();
		//echo $this->db->last_query();
		$data=$result->row_array();   
		//$data['organisation']="SF";
	}
	//$data['stat']='Y';
	//var_dump($data);
	return $data;
 }
 	function student_payment_history($val)
	{
		$sql="select f.student_id,f.fees_paid_type,f.fees_id,f.canc_charges,f.chq_cancelled, f.receipt_no, f.receipt_file, f.fees_date, f.bank_id, f.bank_city, f.amount as amt_paid,f.remark, f.college_receiptno,f.academic_year as academic_year from sf_fees_details as f where f.type_id=1 and f.enrollment_no='".$val['enrollment_no']."' and f.is_deleted='N' order by f.fees_id;";
		$query = $this->db->query($sql);
		$res1=$query->result_array();
		
		$sql="SELECT f.student_id,f.refund_paid_type as fees_paid_type,f.academic_year,f.fees_id, f.receipt_no, f.receipt_file, f.refund_date as fees_date, f.bank_id, f.bank_city, f.amount as amt_paid,f.remark  FROM `sf_fees_refunds` as f 
		where f.enrollment_no='".$val['enrollment_no']."' and f.type_id=1 and  f.is_deleted='N' and f.academic_year='".$val['academic_year']."' ";
		
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		$res2=$query->result_array();
		
		return array_merge($res1,$res2);
	}	
	
	
	public function checking_enroll_acyear_exists($enroll,$id='')
	{
		if($id!='')
			$where=" enrollment_no='".$enroll."' and student_id!='".$id."'";
		else
			$where=" enrollment_no='".$enroll."'";
		
		$this->db->distinct();
		$this->db->select("COUNT(student_id) as count_rows");
		$this->db->from("sf_student_master");
		$this->db->where($where);
		$query = $this->db->get();
		$check=$query->row()->count_rows;
		if ($check ==1){
            return false;
        }else{
            return true;
        }
	}
	
	
	public function cancel_faci_submit($data)
	{
		$feedet['cancelled_facility']='Y'; 
		$feedet['refund']=$data['refund']; 
		$feedet['cancellation_charges']=$data['ccharges']; 
		$feedet['remark']=$data['remarks'];
		
		$feedet['modified_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['modified_on']= date('Y-m-d h:i:s');
		$feedet['modified_by']= $_SESSION['uid'];
		
		$where=array("sf_id"=>$data['sf_id'],"enrollment_no"=>$data['enroll'],"academic_year"=>$data['academic_year']);
		$this->db->where($where); 
		$this->db->update('sf_student_facilities', $feedet);
		
		$cancel_bed['modified_ip']=$_SERVER['REMOTE_ADDR'];
		$cancel_bed['modified_on']= date('Y-m-d h:i:s');
		$cancel_bed['modified_by']= $_SESSION['uid'];
		$cancel_bed['is_active']='N';
		$where=array("sf_id"=>$data['sf_id'],"enrollment_no"=>$data['enroll'],"academic_year"=>$data['academic_year']);
		$this->db->where($where); 
		$this->db->update('sf_student_facility_allocation', $cancel_bed);
		

	
		$candet['sf_id']=$data['sf_id'];
		$candet['enrollment_no']=$data['enroll'];
		$candet['refund_amount']=$data['refund'];
		$candet['can_charges']=$data['ccharges'];
		$candet['can_date']=$data['cdate']; 
		$candet['remark']=$data['remarks'];
		$candet['faci_id']=1;
		$candet['academic_year']=$data['academic_year']; 
		$candet['inserted_ip']=$_SERVER['REMOTE_ADDR'];
		$candet['inserted_on']= date('Y-m-d h:i:s');
		$candet['inserted_by']= $_SESSION['uid'];

		$this->db->insert("sf_facility_cancel", $candet); 
		
		//echo $this->db->last_query();exit();
		$last_inserted_id=$this->db->insert_id();                
		return $last_inserted_id;
	}
   
   public function gatepass_submit($data)
	{
		if($data['goingto']=='city')
		{
			$candet['type']='CITY';
			$candet['from_date']=$data['date'];
			$candet['to_date']=$data['date'];
		}
		else
		{
			$candet['type']='HOME';
			$candet['from_date']=$data['fdate'];
			$candet['to_date']=$data['tdate'];
		}
		$candet['student_id']=$data['student_id'];
		$candet['stud_org']=$data['orgs'];
		$candet['academic_year']=$data['academic'];
		$candet['stud_prn']=$data['enroll'];
		$candet['purpose']=$data['reason'];
		$candet['approval_status']='P';
		//$candet['checkin_status']='OUT';
		//$candet['gatepass_status']='N';
		//$candet['added_ip']=$_SERVER['REMOTE_ADDR'];
		$candet['added_on']= date('Y-m-d h:i:s');
		$candet['added_by']= $_SESSION['uid'];
		//print_r($candet);exit();
		$this->db->insert("sf_hostel_getpass", $candet); 
		
		//echo $this->db->last_query();exit();
		$last_inserted_id=$this->db->insert_id(); 
	
		return $last_inserted_id;
	}
	
	
	public function gatepass_list($academic,$hgp_id='')
    {
		$this->db->select("sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.student_master.academic_year,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,sandipun_ums.student_master.admission_stream,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facility_allocation.allocated_id,sandipun_erp.sf_hostel_master.hostel_code,sandipun_erp.sf_hostel_room_details.room_no,sandipun_erp.sf_hostel_room_details.floor_no,sandipun_erp.sf_hostel_getpass.*,");
		$this->db->from("sandipun_erp.sf_hostel_getpass");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_erp.sf_hostel_getpass.stud_prn and sandipun_ums.student_master.stud_id=sandipun_erp.sf_hostel_getpass.student_id");

		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		
		$this->db->join("sandipun_erp.sf_student_facility_allocation", "sandipun_erp.sf_hostel_getpass.stud_prn = sandipun_erp.sf_student_facility_allocation.enrollment_no and sandipun_erp.sf_student_facility_allocation.student_id=sandipun_erp.sf_hostel_getpass.student_id and sandipun_erp.sf_student_facility_allocation.is_active='Y'");
		
		$this->db->join("sandipun_erp.sf_hostel_room_details", "sandipun_erp.sf_hostel_room_details.sf_room_id = sandipun_erp.sf_student_facility_allocation.allocated_id ");
		
		$this->db->join("sandipun_erp.sf_hostel_master", "sandipun_erp.sf_hostel_room_details.host_id = sandipun_erp.sf_hostel_master.host_id ");
		$this->db->where('sandipun_erp.sf_student_facility_allocation.academic_year', $academic);
		if($hgp_id!="")
        {
			
			$this->db->where('hgp_id', $hgp_id);
            //$where.=" AND hgp_id='".$hgp_id."'";
        }
		else
		$this->db->like(array("sandipun_erp.sf_hostel_getpass.added_on"=>date('Y-m-d')));
		//$this->db->order_by("hgp_id", "desc");
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("sm.stream,sm.course,sm.first_name,sm.middle_name,sm.last_name,sm.academic_year,sm.enrollment_no,sm.student_id as stud_id,sm.program_id as admission_stream,sm.stream as stream_name, sm.course as course_name, sm.instute_name as school_name,sfa.allocated_id, hm.hostel_code,hrd.room_no,hrd.floor_no,shg.*,");
		$this->db->from("sandipun_erp.sf_hostel_getpass shg");
		$this->db->join('sandipun_erp.sf_student_master sm','sm.enrollment_no=shg.stud_prn and sm.student_id=shg.student_id');
		//$this->db->join('sandipun_erp.sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		$this->db->join('sandipun_erp.sf_student_facility_allocation as sfa','sfa.enrollment_no = shg.stud_prn and sfa.student_id = shg.student_id and  sfa.is_active="Y"');
		$this->db->join('sandipun_erp.sf_hostel_room_details as hrd','hrd.sf_room_id = sfa.allocated_id');
		$this->db->join('sandipun_erp.sf_hostel_master as hm','hm.hostel_code = hrd.hostel_code');
		$this->db->where('sfa.academic_year', $academic);
		if($hgp_id!="")
        {
			$this->db->where('hgp_id', $hgp_id);
            
        }
		else
		$this->db->like(array("shg.added_on"=>date('Y-m-d')));
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1." UNION ".$query2);
		//echo $this->db->last_query();exit();
		return $query->result_array();
		
		
        /* $sql="select * From sf_hostel_getpass $where order by hgp_id desc";
        $query = $this->db->query($sql);
        return $query->result_array(); */
    }
	
	public function getpass_approval_submit($data)
	{
		//echo $data['remarks'];exit();
		if(isset($_POST["reject"]))
		{
			$candet['remark']=$data['remarks'];
			$candet['modified_on']= date('Y-m-d h:i:s');
			$candet['modified_by']= $_SESSION['uid'];
			$candet['approval_status']='R';
			$candet['gatepass_status']='N';
			$this->db->where('hgp_id', $data['hgp_id']);
			$this->db->update('sf_hostel_getpass', $candet);
			//echo $this->db->last_query();exit();
			return 'R';//$this->db->affected_rows();
		}
		else if(isset($_POST["approve"]))
		{
			$candet['remark']=$data['remarks'];
			$candet['modified_on']= date('Y-m-d h:i:s');
			$candet['modified_by']= $_SESSION['uid'];
			$candet['approval_status']='A';
			$candet['gatepass_status']='Y';
			$this->db->where('hgp_id', $data['hgp_id']);
			$this->db->update('sf_hostel_getpass', $candet);
			return 'A';//$this->db->affected_rows();
		}		
	}
	
	public function edit_gatepass_submit($data)
	{
		if($data['goingto']=='city')
		{
			$candet['from_date']=$data['date'];
			$candet['to_date']=$data['date'];
		}
		else
		{
			$candet['from_date']=$data['fdate'];
			$candet['to_date']=$data['tdate'];
		}
		
		$candet['purpose']=$data['reason'];
		//$candet['approval_status']='P';
		//$candet['checkin_status']='OUT';
		//$candet['gatepass_status']='N';
		//$candet['added_ip']=$_SERVER['REMOTE_ADDR'];
		$candet['modified_on']= date('Y-m-d h:i:s');
		$candet['modified_by']= $_SESSION['uid'];

		$this->db->where('hgp_id', $data['hgp_id']);
		$this->db->update('sf_hostel_getpass', $candet);
		return $this->db->affected_rows();
	}
	
	public function get_gatepass_details($data)
	{
		if($data['org']=="SU" )
		{
			$this->db->select("sandipun_erp.sf_student_facilities.organisation,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,sandipun_ums.student_master.current_year,sandipun_ums.student_master.admission_stream,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facility_allocation.allocated_id,sandipun_erp.sf_hostel_master.hostel_code,sandipun_erp.sf_hostel_room_details.room_no,sandipun_erp.sf_hostel_room_details.floor_no,sandipun_erp.sf_hostel_getpass.*,");
			$this->db->from("sandipun_erp.sf_hostel_getpass");
			
			$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_erp.sf_hostel_getpass.stud_prn and sandipun_ums.student_master.stud_id=sandipun_erp.sf_hostel_getpass.student_id");

			$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
			
			$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.sffm_id=1 and sandipun_erp.sf_student_facilities.academic_year=sandipun_erp.sf_hostel_getpass.academic_year");
			
			$this->db->join("sandipun_erp.sf_student_facility_allocation", "sandipun_erp.sf_hostel_getpass.stud_prn = sandipun_erp.sf_student_facility_allocation.enrollment_no and sandipun_erp.sf_student_facility_allocation.student_id=sandipun_erp.sf_hostel_getpass.student_id and sandipun_erp.sf_student_facility_allocation.is_active='Y' and sandipun_erp.sf_student_facility_allocation.sf_id=sandipun_erp.sf_student_facilities.sf_id");
			
			$this->db->join("sandipun_erp.sf_hostel_room_details", "sandipun_erp.sf_hostel_room_details.sf_room_id = sandipun_erp.sf_student_facility_allocation.allocated_id ");
			
			$this->db->join("sandipun_erp.sf_hostel_master", "sandipun_erp.sf_hostel_room_details.host_id = sandipun_erp.sf_hostel_master.host_id ");

			$this->db->where("sandipun_ums.student_master.enrollment_no",$data['enroll']);
			$this->db->where("sandipun_erp.sf_hostel_getpass.hgp_id",$data['hgp_id']);
			$this->db->where("sandipun_erp.sf_hostel_getpass.academic_year",$data['ac_year']);
			$query = $this->db->get();
			//echo $this->db->last_query();exit();
			return $query->result_array();
		}
		else
		{
			$this->db->select("sm.stream,sm.course,ssf.organisation,sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.student_id as stud_id,sm.current_year,sm.program_id as admission_stream,sm.stream as stream_name, sm.course as course_name, sm.instute_name as school_name,sfa.allocated_id, hm.hostel_code,hrd.room_no,hrd.floor_no,shg.*,");
			$this->db->from("sandipun_erp.sf_hostel_getpass shg");
			$this->db->join('sandipun_erp.sf_student_master sm','sm.enrollment_no=shg.stud_prn and sm.student_id=shg.student_id');
			//$this->db->join('sandipun_erp.sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
			$this->db->join('sandipun_erp.sf_student_facilities as ssf','ssf.enrollment_no = sm.enrollment_no and ssf.sffm_id=1 and ssf.academic_year=shg.academic_year');
			$this->db->join('sandipun_erp.sf_student_facility_allocation as sfa','sfa.enrollment_no = shg.stud_prn and sfa.student_id = shg.student_id and sfa.academic_year=sm.academic_year and sfa.is_active="Y" and sfa.sf_id=ssf.sf_id');
			$this->db->join('sandipun_erp.sf_hostel_room_details as hrd','hrd.sf_room_id = sfa.allocated_id');
			$this->db->join('sandipun_erp.sf_hostel_master as hm','hm.hostel_code = hrd.hostel_code');
			$this->db->where("sm.enrollment_no",$data['enroll']);
			$this->db->where("shg.hgp_id",$data['hgp_id']);
			$this->db->where("shg.academic_year",$data['ac_year']);
			
			$query = $this->db->get();
			//echo $this->db->last_query();exit();
			return $query->result_array();
		}
	}
	
	public function check_gatepass_exists($data)
	{
		//echo "today==".date('Y-m-d');exit();
		$this->db->distinct();
		$this->db->select("*");
		$this->db->from("sf_hostel_getpass");
		//(added_on like '".date('Y-m-d')."%'  OR from_date like '".$data['fdate']."%')
		//(added_on like '".date('Y-m-d')."%'  OR from_date like '".$data['fdate']."%' OR to_date like '".$data['tdate']."%')
		if($data['type']=='city')
			$query=$this->db->like(array("added_on"=>date('Y-m-d'),"from_date"=>$data['fdate']));
		else
			$query=$this->db->like(array("added_on"=>date('Y-m-d'),"from_date"=>$data['fdate'],"to_date"=>$data['tdate']));
	
		$where=array("student_id"=>$data['student_id'],"stud_prn"=>$data['enrollment_no'],"stud_org"=>$data['organisation'],"type"=>$data['type']);
		$this->db->where($where);
		
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->num_rows();
	}
	
	public function edit_check_gatepass_exists($data)
	{
		//echo "today==".date('Y-m-d');exit();
		$this->db->distinct();
		$this->db->select("*");
		$this->db->from("sf_hostel_getpass");
		//(added_on like '".date('Y-m-d')."%'  OR from_date like '".$data['fdate']."%')
		//(added_on like '".date('Y-m-d')."%'  OR from_date like '".$data['fdate']."%' OR to_date like '".$data['tdate']."%')
		if($data['type']=='city')
			$query=$this->db->like(array("added_on"=>date('Y-m-d'),"from_date"=>$data['fdate']));
		else
			$query=$this->db->like(array("added_on"=>date('Y-m-d'),"from_date"=>$data['fdate'],"to_date"=>$data['tdate']));
	
		$where=array("type"=>$data['type']);
		$this->db->where_not_in('hgp_id', $data['hgp_id']);
		$this->db->where($where);
		
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->num_rows();
	}
	
	function gatepass_students_data($data)
	{
		$this->db->select("sandipun_erp.sf_student_facilities.organisation,sandipun_ums.student_master.current_year,sandipun_ums.student_master.mobile,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_erp.sf_student_facilities.academic_year,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,sandipun_ums.student_master.admission_stream,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facility_allocation.allocated_id,sandipun_erp.sf_hostel_master.hostel_code,sandipun_erp.sf_hostel_room_details.room_no,sandipun_erp.sf_hostel_room_details.floor_no,");
		$this->db->from("sandipun_ums.student_master");
		
		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
				
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.sffm_id=1");
		
		$this->db->join("sandipun_erp.sf_student_facility_allocation", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facility_allocation.enrollment_no and sandipun_erp.sf_student_facility_allocation.student_id=sandipun_ums.student_master.stud_id and sandipun_erp.sf_student_facility_allocation.is_active='Y' and sandipun_erp.sf_student_facility_allocation.sf_id=sandipun_erp.sf_student_facilities.sf_id");
		
		$this->db->join("sandipun_erp.sf_hostel_room_details", "sandipun_erp.sf_hostel_room_details.sf_room_id = sandipun_erp.sf_student_facility_allocation.allocated_id ");
		
		$this->db->join("sandipun_erp.sf_hostel_master", "sandipun_erp.sf_hostel_room_details.host_id = sandipun_erp.sf_hostel_master.host_id ");

		$this->db->where('sandipun_ums.student_master.enrollment_no', $data['enrollment_no']);
		
		$this->db->where('sandipun_erp.sf_student_facilities.academic_year', $data['ac_year']);

		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("ssf.organisation,sm.current_year,sm.mobile,sm.first_name,sm.middle_name,sm.last_name,ssf.academic_year,sm.enrollment_no,sm.student_id as stud_id,sm.program_id as admission_stream, sm.stream as stream_name, sm.course as course_name, sm.instute_name as school_name,sfa.allocated_id, hm.hostel_code,hrd.room_no,hrd.floor_no,");
		$this->db->from("sandipun_erp.sf_student_master sm");
		//$this->db->join('sandipun_erp.sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		$this->db->join('sandipun_erp.sf_student_facilities as ssf','ssf.enrollment_no = sm.enrollment_no and ssf.sffm_id=1');
		$this->db->join('sandipun_erp.sf_student_facility_allocation as sfa','sfa.enrollment_no = sm.enrollment_no and sfa.student_id = sm.student_id and  sfa.is_active="Y" and sfa.sf_id=ssf.sf_id');
		$this->db->join('sandipun_erp.sf_hostel_room_details as hrd','hrd.sf_room_id = sfa.allocated_id');
		$this->db->join('sandipun_erp.sf_hostel_master as hm','hm.hostel_code = hrd.hostel_code');
		
        $this->db->where('sm.enrollment_no', $data['enrollment_no']);
         $this->db->where('ssf.academic_year', $data['ac_year']);
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1." UNION ".$query2);
		//echo $this->db->last_query();exit();
		return $query->row_array();
		
	} 
	
	public function gatepass_listbydate($data)
    {
		//var_dump($data);exit();
		$this->db->select("sandipun_erp.sf_student_facilities.organisation,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,sandipun_ums.student_master.admission_stream,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facility_allocation.allocated_id,sandipun_erp.sf_hostel_master.hostel_code,sandipun_erp.sf_hostel_room_details.room_no,sandipun_erp.sf_hostel_room_details.floor_no,sandipun_erp.sf_hostel_getpass.*,");
		$this->db->from("sandipun_erp.sf_hostel_getpass");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_erp.sf_hostel_getpass.stud_prn and sandipun_ums.student_master.stud_id=sandipun_erp.sf_hostel_getpass.student_id");

		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.sffm_id=1 and sandipun_erp.sf_student_facilities.academic_year=sandipun_erp.sf_hostel_getpass.academic_year");
		
		$this->db->join("sandipun_erp.sf_student_facility_allocation", "sandipun_erp.sf_hostel_getpass.stud_prn = sandipun_erp.sf_student_facility_allocation.enrollment_no and  sandipun_erp.sf_student_facility_allocation.student_id=sandipun_erp.sf_hostel_getpass.student_id and sandipun_erp.sf_student_facility_allocation.is_active='Y' and sandipun_erp.sf_student_facility_allocation.sf_id=sandipun_erp.sf_student_facilities.sf_id");
		
		$this->db->join("sandipun_erp.sf_hostel_room_details", "sandipun_erp.sf_hostel_room_details.sf_room_id = sandipun_erp.sf_student_facility_allocation.allocated_id ");
		
		$this->db->join("sandipun_erp.sf_hostel_master", "sandipun_erp.sf_hostel_room_details.host_id = sandipun_erp.sf_hostel_master.host_id ");
		if($hgp_id!="")
        {
			$this->db->where('hgp_id', $hgp_id);
        }
		
		if($data['ac_year']!="")
        {
			$this->db->where('sandipun_erp.sf_hostel_getpass.academic_year', $data['ac_year']);
        }
		$this->db->like(array("sandipun_erp.sf_hostel_getpass.added_on"=>$data['date']));
		//$this->db->order_by("hgp_id", "desc");
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("ssf.organisation,sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.student_id as stud_id,sm.program_id as admission_stream,sm.stream as stream_name, sm.course as course_name, sm.instute_name as school_name,sfa.allocated_id, hm.hostel_code,hrd.room_no,hrd.floor_no,shg.*,");
		$this->db->from("sandipun_erp.sf_hostel_getpass shg");
		$this->db->join('sandipun_erp.sf_student_master sm','sm.enrollment_no=shg.stud_prn and sm.student_id=shg.student_id');
		//$this->db->join('sandipun_erp.sf_program_detail as spd','sm.program_id = spd.sf_program_id');
		$this->db->join('sandipun_erp.sf_student_facilities as ssf','ssf.enrollment_no = sm.enrollment_no and ssf.sffm_id=1 and ssf.academic_year=shg.academic_year');
		$this->db->join('sandipun_erp.sf_student_facility_allocation as sfa','sfa.enrollment_no = shg.stud_prn and sfa.student_id = shg.student_id and sfa.is_active="Y" and sfa.sf_id=ssf.sf_id');
		$this->db->join('sandipun_erp.sf_hostel_room_details as hrd','hrd.sf_room_id = sfa.allocated_id');
		$this->db->join('sandipun_erp.sf_hostel_master as hm','hm.hostel_code = hrd.hostel_code');
		if($data['ac_year']!="")
        {
			$this->db->where('shg.academic_year', $data['ac_year']);
        }
		if($hgp_id!="")
        {
			$this->db->where('hgp_id', $hgp_id);
            
        }
		//$this->db->order_by("hgp_id", "desc");
		$this->db->like(array("shg.added_on"=>$data['date']));
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1." UNION ".$query2);
		//echo $this->db->last_query();exit();
		return $query->result_array();
		
		
        /* $sql="select * From sf_hostel_getpass $where order by hgp_id desc";
        $query = $this->db->query($sql);
        return $query->result_array(); */
    }
	
	public function gatepass_checkincheckout($data)
	{
		$this->db->select("sandipun_ums.parent_details.parent_mobile1,sandipun_ums.parent_details.parent_mobile2,sandipun_ums.student_master.current_year,sandipun_ums.student_master.mobile,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_erp.sf_hostel_getpass.academic_year,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,sandipun_ums.student_master.admission_stream,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facility_allocation.f_alloc_id,sandipun_erp.sf_hostel_getpass.hgp_id,sandipun_erp.sf_hostel_getpass.stud_org,sandipun_erp.sf_hostel_getpass.type,sandipun_erp.sf_hostel_getpass.purpose,sandipun_erp.sf_hostel_getpass.from_date,sandipun_erp.sf_hostel_getpass.to_date,sandipun_erp.sf_hostel_getpass.approval_status,sandipun_erp.sf_hostel_getpass.checkin_status,");
		$this->db->from("sandipun_erp.sf_hostel_getpass");
		
		$this->db->join("sandipun_ums.student_master", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_hostel_getpass.stud_prn and sandipun_ums.student_master.stud_id = sandipun_erp.sf_hostel_getpass.student_id");
		
		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		
		$this->db->join("sandipun_ums.parent_details", "sandipun_ums.student_master.stud_id = sandipun_ums.parent_details.student_id");
		
		$this->db->join("sandipun_erp.sf_student_facility_allocation", "sandipun_erp.sf_hostel_getpass.stud_prn = sandipun_erp.sf_student_facility_allocation.enrollment_no and sandipun_erp.sf_student_facility_allocation.academic_year=sandipun_erp.sf_hostel_getpass.academic_year and sandipun_erp.sf_student_facility_allocation.student_id =sandipun_erp.sf_hostel_getpass.student_id and sandipun_erp.sf_student_facility_allocation.is_active='Y'");
		
		$this->db->join("sandipun_erp.sf_hostel_room_details", "sandipun_erp.sf_hostel_room_details.sf_room_id = sandipun_erp.sf_student_facility_allocation.allocated_id ");
		
		$this->db->join("sandipun_erp.sf_hostel_master", "sandipun_erp.sf_hostel_room_details.host_id = sandipun_erp.sf_hostel_master.host_id ");
	
		$this->db->where('sandipun_erp.sf_hostel_getpass.hgp_id', $data['hgp_id']);

		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("sm.parent_mobile1,sm.parent_mobile2,sm.current_year,sm.mobile,sm.first_name,sm.middle_name,sm.last_name,hgp.academic_year,sm.enrollment_no,sm.student_id as stud_id,sm.program_id as admission_stream, sm.stream as stream_name, sm.course as course_name, sm.instute_name as school_name, sfa.f_alloc_id,hgp.hgp_id, hgp.stud_org,hgp.type,hgp.purpose,hgp.from_date,hgp.to_date,hgp.approval_status,hgp.checkin_status,");
		$this->db->from("sandipun_erp.sf_hostel_getpass as hgp");
		$this->db->join('sandipun_erp.sf_student_master as sm','sm.student_id = hgp.student_id and sm.enrollment_no = hgp.stud_prn');
		//$this->db->join('sandipun_erp.sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		
		$this->db->join('sandipun_erp.sf_student_facility_allocation as sfa','sfa.enrollment_no = sm.enrollment_no and sfa.student_id = sm.student_id and sfa.academic_year=hgp.academic_year and sfa.is_active="Y"');
		$this->db->join('sandipun_erp.sf_hostel_room_details as hrd','hrd.sf_room_id = sfa.allocated_id');
		$this->db->join('sandipun_erp.sf_hostel_master as hm','hm.hostel_code = hrd.hostel_code');
		
        $this->db->where('hgp.hgp_id', $data['hgp_id']);
        
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1." UNION ".$query2);
		//echo $this->db->last_query();exit();
		return $query->row_array();
	}
	
	public function update_checkout($data)
	{
			//$candet['remark']=$data['remarks'];
			$candet['checkout_time']= date('Y-m-d h:i:s');
			$candet['modified_by']= $_SESSION['uid'];
			$candet['checkin_status']='out';
			
			$this->db->where('hgp_id', $data['hgp_id_out']);
			$this->db->update('sf_hostel_getpass', $candet);
			
			
			$status_update['modified_on']= date('Y-m-d h:i:s');
			$status_update['modified_by']= $_SESSION['uid'];
			$status_update['present_status']=$data['goingto'];
			$this->db->where('f_alloc_id', $data['f_alloc_id_out']);
			$this->db->update('sf_student_facility_allocation', $status_update);
			//echo $this->db->last_query();exit();
			
			
			/* 		$stud_name = $data['std_name_out'];
			$pmob=explode(',',$data['mobile_out']);
		$sms_message = "Dear Parent, 
Your ward ".$stud_name." is going out of the hostel for ."$data['goingto']"." on ".$candet['checkout_time']."
Thanks,
Sandip University.";
	//echo $sms_message;exit;
		$curl = curl_init('http://123.63.33.43/blank/sms/user/urlsms.php');
		curl_setopt($curl, CURLOPT_POST, 1);

		curl_setopt($curl, CURLOPT_POSTFIELDS, "username=sandipfoundationnsk&pass=sandip@123&senderid=SANDIP&dest_mobileno=$pmob[1]&msgtype=UNI&message=$sms_message&response=Y");
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($curl); */
			
			return $this->db->affected_rows();	
	}
	
	public function update_checkin($data)
	{
			//$candet['remark']=$data['remarks'];
			$candet['checkin_time']= date('Y-m-d h:i:s');
			$candet['modified_by']= $_SESSION['uid'];
			$candet['checkin_status']='in';
			
			$this->db->where('hgp_id', $data['hgp_id_in']);
			$this->db->update('sf_hostel_getpass', $candet);
			
			$status_update['modified_on']= date('Y-m-d h:i:s');
			$status_update['modified_by']= $_SESSION['uid'];
			$status_update['present_status']='IN';
			$this->db->where('f_alloc_id', $data['f_alloc_id_in']);
			$this->db->update('sf_student_facility_allocation', $status_update);
			//echo $this->db->last_query();exit();
			
/*	$stud_name = $data['std_name_in'];
			$pmob=explode(',',$data['mobile_in']);
		$sms_message = "Dear Parent, 
Your ward ".$stud_name." is came back to the hostel on ".$candet['checkin_time']."
Thanks,
Sandip University.";
	//echo $sms_message;exit;
		$curl = curl_init('http://123.63.33.43/blank/sms/user/urlsms.php');
		curl_setopt($curl, CURLOPT_POST, 1);

		curl_setopt($curl, CURLOPT_POSTFIELDS, "username=sandipfoundationnsk&pass=sandip@123&senderid=SANDIP&dest_mobileno=$pmob[1]&msgtype=UNI&message=$sms_message&response=Y");
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($curl); */
			
			return $this->db->affected_rows();	
	}
	
	
	public function checkout_listbydate($data)
    {
		$this->db->select("sandipun_ums.student_master.mobile,sandipun_erp.sf_student_facilities.organisation,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,sandipun_ums.student_master.admission_stream,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facility_allocation.allocated_id,sandipun_erp.sf_hostel_master.hostel_code,sandipun_erp.sf_hostel_room_details.room_no,sandipun_erp.sf_hostel_room_details.floor_no,sandipun_erp.sf_hostel_getpass.*,");
		$this->db->from("sandipun_erp.sf_hostel_getpass");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_erp.sf_hostel_getpass.stud_prn and sandipun_ums.student_master.stud_id=sandipun_erp.sf_hostel_getpass.student_id");

		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.sffm_id=1");
		
		$this->db->join("sandipun_erp.sf_student_facility_allocation", "sandipun_erp.sf_hostel_getpass.stud_prn = sandipun_erp.sf_student_facility_allocation.enrollment_no and sandipun_erp.sf_student_facility_allocation.academic_year=sandipun_erp.sf_hostel_getpass.academic_year and sandipun_erp.sf_student_facility_allocation.student_id=sandipun_erp.sf_hostel_getpass.student_id and sandipun_erp.sf_student_facility_allocation.is_active='Y' and sandipun_erp.sf_student_facility_allocation.sf_id=sandipun_erp.sf_student_facilities.sf_id");
		
		$this->db->join("sandipun_erp.sf_hostel_room_details", "sandipun_erp.sf_hostel_room_details.sf_room_id = sandipun_erp.sf_student_facility_allocation.allocated_id ");
		
		$this->db->join("sandipun_erp.sf_hostel_master", "sandipun_erp.sf_hostel_room_details.host_id = sandipun_erp.sf_hostel_master.host_id ");
		
		if($data['checkinout_type']=='OUT')
		{
		$this->db->where('sandipun_erp.sf_hostel_getpass.checkin_status', $data['checkinout_type']);
		$this->db->like(array("sandipun_erp.sf_hostel_getpass.checkout_time"=>$data['date']));
		}
		else if($data['checkinout_type']=='IN')
		{
		$this->db->where('sandipun_erp.sf_hostel_getpass.checkin_status', $data['checkinout_type']);
		$this->db->like(array("sandipun_erp.sf_hostel_getpass.checkin_time"=>$data['date']));
		}
		else if($data['checkinout_type']=='HOME')
		{
			$where = "(sandipun_erp.sf_hostel_getpass.checkin_status='IN' OR sandipun_erp.sf_hostel_getpass.checkin_status='OUT') and (sandipun_erp.sf_hostel_getpass.checkin_time like '".$data['date']."%'  OR sandipun_erp.sf_hostel_getpass.checkout_time like '".$data['date']."%')";
			$this->db->where($where);
			$this->db->where('sandipun_erp.sf_hostel_getpass.type', $data['checkinout_type']);
		}
		else
		{
			$where = "(sandipun_erp.sf_hostel_getpass.checkin_status='IN' OR sandipun_erp.sf_hostel_getpass.checkin_status='OUT') and (sandipun_erp.sf_hostel_getpass.checkin_time like '".$data['date']."%'  OR sandipun_erp.sf_hostel_getpass.checkout_time like '".$data['date']."%')";
			$this->db->where($where);
			$this->db->where('sandipun_erp.sf_hostel_getpass.type', $data['checkinout_type']);

		}
		$this->db->where('approval_status','A');
		
		
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("sm.mobile,ssf.organisation,sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.student_id as stud_id,sm.program_id as admission_stream,sm.stream as stream_name, sm.course as course_name, sm.instute_name as school_name,sfa.allocated_id, hm.hostel_code,hrd.room_no,hrd.floor_no,shg.*,");
		$this->db->from("sandipun_erp.sf_hostel_getpass shg");
		$this->db->join('sandipun_erp.sf_student_master sm','sm.enrollment_no=shg.stud_prn and sm.student_id=shg.student_id');
		//$this->db->join('sandipun_erp.sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		$this->db->join('sandipun_erp.sf_student_facilities as ssf','ssf.enrollment_no = sm.enrollment_no and ssf.sffm_id=1');
		$this->db->join('sandipun_erp.sf_student_facility_allocation as sfa','sfa.enrollment_no = shg.stud_prn and sfa.student_id = shg.student_id and sfa.academic_year=shg.academic_year and sfa.is_active="Y" and sfa.sf_id=ssf.sf_id');
		$this->db->join('sandipun_erp.sf_hostel_room_details as hrd','hrd.sf_room_id = sfa.allocated_id');
		$this->db->join('sandipun_erp.sf_hostel_master as hm','hm.hostel_code = hrd.hostel_code');

		if($data['checkinout_type']=='OUT')
		{
		$this->db->where('shg.checkin_status', $data['checkinout_type']);
		$this->db->like(array("shg.checkout_time"=>$data['date']));
		}
		else if($data['checkinout_type']=='IN')
		{
		$this->db->where('shg.checkin_status', $data['checkinout_type']);
		$this->db->like(array("shg.checkin_time"=>$data['date']));
		}
		else if($data['checkinout_type']=='HOME')
		{
			$where = "(shg.checkin_status='IN' OR shg.checkin_status='OUT') and (shg.checkin_time like '".$data['date']."%'  OR shg.checkout_time like '".$data['date']."%')";
			$this->db->where($where);
			$this->db->where('shg.type', $data['checkinout_type']);
		}
		else
		{
			$where = "(shg.checkin_status='IN' OR shg.checkin_status='OUT') and (shg.checkin_time like '".$data['date']."%'  OR shg.checkout_time like '".$data['date']."%')";
			$this->db->where($where);
			$this->db->where('shg.type', $data['checkinout_type']);

		}
		$this->db->where('approval_status','A');
		//$this->db->like(array("shg.added_on"=>$data['date']));
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1." UNION ".$query2);
		//if($data['checkinout_type']=='HOME')echo $this->db->last_query();exit();
		return $query->result_array();
		
		
        /* $sql="select * From sf_hostel_getpass $where order by hgp_id desc";
        $query = $this->db->query($sql);
        return $query->result_array(); */
    }
	
	public function emptybeds_count_data($data)
	{
		if(isset($data['host_id']) && $data['host_id']=='')
			$where=" WHERE sfsf.f_alloc_id is null and sfhrd.category='Stay Room' and sfhrd.is_active='Y' GROUP by sfhrd.host_id;";
		else
			$where=" WHERE sfsf.f_alloc_id is null and sfhrd.host_id='".$data['host_id']."' and sfhrd.category='Stay Room'  and sfhrd.is_active='Y' GROUP by sfhrd.host_id;";
		
		$sql="select shm.campus_name, COUNT(sfhrd.host_id) as tot_count, sfsf.academic_year, sfhrd.hostel_code,sfhrd.host_id from sf_hostel_room_details as sfhrd 
		join sf_hostel_master as shm on shm.host_id=sfhrd.host_id and shm.hostel_code=sfhrd.hostel_code and shm.campus_name='".$data['campus']."'
		left join sf_student_facility_allocation as sfsf on sfhrd.sf_room_id = sfsf.allocated_id and sfsf.is_active='Y' and sfsf.academic_year='".$data['academic']."'
		left join sf_student_facilities as ssf on ssf.sffm_id=1 and ssf.sf_id=sfsf.sf_id and ssf.enrollment_no = sfsf.enrollment_no 
		".$where;
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return  $query->result_array();
	}
	
	public function emptybeddetail($data)
	{
		$sql="select count(*) as beds_available,sfhrd.hostel_code,sfhrd.host_id,sfhrd.floor_no, CAST(sfhrd.`room_no` AS SIGNED) as room_no, sfhrd.no_of_beds,sfhrd.bed_number from sf_hostel_room_details as sfhrd 
		join sf_hostel_master as shm on shm.host_id=sfhrd.host_id and shm.hostel_code=sfhrd.hostel_code 
		left join sf_student_facility_allocation as sfsf on sfhrd.sf_room_id = sfsf.allocated_id and sfsf.is_active='Y' and sfsf.academic_year='".$data['academic']."'
		left join sf_student_facilities as ssf on ssf.sffm_id=1 and ssf.sf_id=sfsf.sf_id and  ssf.enrollment_no = sfsf.enrollment_no 
		WHERE sfsf.f_alloc_id is null and sfhrd.category='Stay Room' and sfhrd.host_id='".$data['host_id']."' and sfhrd.is_active='Y' group by sfhrd.floor_no,sfhrd.room_no";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return  $query->result_array();
	}
	
	function students_data($data)
	{
				   $first= substr($data['enrollment_no'],0,5);
				  

		$this->db->select("sandipun_erp.sf_student_facilities.organisation,sandipun_erp.sf_student_facility_allocation.route_id,sandipun_erp.sf_student_facility_allocation.allocated_id,
		sandipun_ums.student_master.current_year,
		sandipun_ums.student_master.mobile,sandipun_ums.student_master.first_name,
		sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,
		sandipun_ums.student_master.academic_year,sandipun_ums.student_master.enrollment_no,
		sandipun_ums.student_master.stud_id,sandipun_ums.student_master.admission_stream,
		sandipun_ums.vw_stream_details.stream_short_name as stream_name,
		sandipun_ums.vw_stream_details.course_short_name as course_name,
		 sandipun_ums.vw_stream_details.school_short_name as school_name, 
		 sandipun_ums.vw_stream_details.course_id as sfcourse,sandipun_ums.vw_stream_details.stream_code as sfstream");
		$this->db->from("sandipun_ums.student_master");
		
		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no");
		$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facility_allocation.enrollment_no = sandipun_ums.student_master.enrollment_no','left');
		$this->db->where('sandipun_ums.student_master.enrollment_no', $data['enrollment_no']);

		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("ssf.organisation,ssfa.route_id,ssfa.allocated_id,sm.current_year,sm.mobile,sm.first_name,sm.middle_name,sm.last_name,
		sm.academic_year,sm.enrollment_no,sm.student_id as stud_id,sm.program_id as admission_stream, 
		spd.branch_name as stream_name, spd.course_name as course_name, sm.instute_name as school_name,sm.course as sfcourse, 
		sm.stream as sfstream");
		$this->db->from("sandipun_erp.sf_student_master sm");
		$this->db->join('sandipun_erp.sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		$this->db->join('sandipun_erp.sf_student_facilities as ssf','ssf.enrollment_no = sm.enrollment_no','left');
		$this->db->join('sandipun_erp.sf_student_facility_allocation as ssfa','ssfa.enrollment_no = sm.enrollment_no','left');
		$this->db->where('sm.enrollment_no', $data['enrollment_no']);
        
		$query2 = $this->db->get_compiled_select();
		/*$query="SELECT `sandipun_erp`.`sf_student_facilities`.`organisation`, `sandipun_erp`.`sf_student_facility_allocation`.`route_id`, 
`sandipun_erp`.`sf_student_facility_allocation`.`allocated_id`, `sandipun_ums`.`student_master`.`current_year`, 
`sandipun_ums`.`student_master`.`mobile`, `sandipun_ums`.`student_master`.`first_name`, `sandipun_ums`.`student_master`.`middle_name`,
`sandipun_ums`.`student_master`.`last_name`, 
`sandipun_ums`.`student_master`.`academic_year` AS sacademic_year, 
`sandipun_erp`.`sf_student_facility_allocation`.academic_year,

`sandipun_ums`.`student_master`.`enrollment_no`, `sandipun_ums`.`student_master`.`stud_id`, 
`sandipun_ums`.`student_master`.`admission_stream`, `sandipun_ums`.`vw_stream_details`.`stream_short_name` AS `stream_name`,
 `sandipun_ums`.`vw_stream_details`.`course_short_name` AS `course_name`, 
 `sandipun_ums`.`vw_stream_details`.`school_short_name` AS `school_name`, 
 `sandipun_ums`.`vw_stream_details`.`course_id` AS `sfcourse`,
  `sandipun_ums`.`vw_stream_details`.`stream_code` AS `sfstream`
   FROM `sandipun_ums`.`student_master` 
   JOIN `sandipun_ums`.`vw_stream_details` 
   ON `sandipun_ums`.`student_master`.`admission_stream` = `sandipun_ums`.`vw_stream_details`.`stream_id`
    JOIN `sandipun_erp`.`sf_student_facilities` ON 
    `sandipun_ums`.`student_master`.`enrollment_no` = `sandipun_erp`.`sf_student_facilities`.`enrollment_no`
     JOIN `sandipun_erp`.`sf_student_facility_allocation` ON 
     `sandipun_erp`.`sf_student_facility_allocation`.`enrollment_no` = `sandipun_ums`.`student_master`.`enrollment_no`
      WHERE `sandipun_ums`.`student_master`.`enrollment_no` = '".$data['enrollment_no']."'
      AND `sandipun_erp`.`sf_student_facility_allocation`.academic_year='2019'
       AND `sandipun_erp`.`sf_student_facility_allocation`.academic_year='2019'
       UNION 
      
      SELECT `ssf`.`organisation`,
       `ssfa`.`route_id`, `ssfa`.`allocated_id`, `sm`.`current_year`, `sm`.`mobile`, `sm`.`first_name`,
        `sm`.`middle_name`, `sm`.`last_name`, `sm`.`academic_year` AS sacademic_year, ssfa.academic_year,`sm`.`enrollment_no`, `sm`.`student_id` AS `stud_id`, `sm`.`program_id` AS `admission_stream`, `spd`.`branch_name` AS `stream_name`, `spd`.`course_name` AS `course_name`, `sm`.`instute_name` AS `school_name`, `sm`.`course` AS `sfcourse`, `sm`.`stream` AS `sfstream` FROM 
        `sandipun_erp`.`sf_student_master` `sm`
          LEFT JOIN `sandipun_erp`.`sf_program_detail` AS `spd` ON `sm`.`program_id` = `spd`.`sf_program_id`
          INNER JOIN `sandipun_erp`.`sf_student_facilities` AS `ssf` ON `ssf`.`enrollment_no` = `sm`.`enrollment_no` AND ssf.academic_year='2019'
          INNER JOIN `sandipun_erp`.`sf_student_facility_allocation` AS `ssfa` ON `ssfa`.`enrollment_no` = `sm`.`enrollment_no` 
          WHERE `sm`.`enrollment_no` = '".$data['enrollment_no']."' AND 
		  ssf.academic_year='2019' AND
		   ssfa.academic_year='2019'";*/
		   $one=$data['enrollment_no'];
		  $first= strpos($data['enrollment_no'],0,5);
		   
		  // if($data['enrollment_no']19SUN)
		  if($first=="19SUN"){
			   $query = $this->db->query($query1);
		  }else{
			  $query = $this->db->query($query1." UNION ".$query2);
		  }
		   
		//$query = $this->db->query($query);
		//echo $this->db->last_query();exit();
		return $query->row_array();
		
	}
	
	public function fees_challan_list_byid($id)
	{
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_ums.student_master.current_year,
		sandipun_ums.student_master.mobile,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,
		sandipun_ums.student_master.admission_stream,sandipun_ums.student_master.first_name,
		sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,
		sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name,
		 sandipun_ums.vw_stream_details.stream_code as sfcourse,sandipun_ums.vw_stream_details.stream_short_name as sfstream,
		 sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_ums.bank_master.bank_name as stud_bankname,
		  sandipun_erp.sf_bank_account_details.account_name,sandipun_erp.sf_bank_account_details.account_no,
		  sandipun_erp.sf_bank_account_details.branch_name,sandipun_erp.sf_bank_account_details.bank_name,
		  sandipun_erp.sf_transport_boarding_details.boarding_point,
		  sandipun_erp.sf_transport_route.route_name");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no");
		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = sandipun_erp.sf_fees_challan.bank_id",'left');
		$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = sandipun_erp.sf_fees_challan.bank_account_id");
	    $this->db->join("sandipun_erp.sf_transport_boarding_details","sandipun_erp.sf_transport_boarding_details.board_id = sandipun_erp.sf_fees_challan.Boarding_point",'left');
		$this->db->join("sandipun_erp.sf_transport_route","sandipun_erp.sf_transport_route.route_id = sandipun_erp.sf_fees_challan.Route_name",'left');
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_erp.sf_fees_challan.fees_id', $id);
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_erp.sf_student_master.current_year,sandipun_erp.sf_student_master.mobile,sandipun_erp.sf_student_master.enrollment_no,sandipun_erp.sf_student_master.student_id as stud_id,sandipun_erp.sf_student_master.program_id as admission_stream,sandipun_erp.sf_student_master.first_name,sandipun_erp.sf_student_master.middle_name,sandipun_erp.sf_student_master.last_name,`sandipun_erp`.`sf_program_detail`.`branch_name` AS `stream_name`, 
`sandipun_erp`.`sf_program_detail`.`course_name`,sandipun_erp.sf_student_master.course as sfcourse,sandipun_erp.sf_student_master.stream as sfstream,
`sandipun_erp`.`sf_program_detail`.`college_name` AS `school_name`,
sandipun_ums.bank_master.bank_name as stud_bankname, 
sandipun_erp.sf_bank_account_details.account_name, 
sandipun_erp.sf_bank_account_details.account_no,
sandipun_erp.sf_bank_account_details.branch_name,
sandipun_erp.sf_bank_account_details.bank_name,
sandipun_erp.sf_transport_boarding_details.boarding_point,sandipun_erp.sf_transport_route.route_name
"); //sm.stream as stream_name, sm.course as course_name, sm.instute_name as school_name,
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_erp.sf_student_master","sandipun_erp.sf_student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no");
		$this->db->join('sandipun_erp.sf_program_detail','sandipun_erp.sf_student_master.program_id = sandipun_erp.sf_program_detail.sf_program_id','left');
		//$this->db->join("`sandipun_ums`.`vw_stream_details`", 
 //"`sandipun_erp`.`sf_student_master`.`program_id` = `sandipun_ums`.`vw_stream_details`.`stream_id`",'left');
		
		
		
		
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = sandipun_erp.sf_fees_challan.bank_id",'left');
		$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = sandipun_erp.sf_fees_challan.bank_account_id");
		
		$this->db->join("sandipun_erp.sf_transport_boarding_details","sandipun_erp.sf_transport_boarding_details.board_id = sandipun_erp.sf_fees_challan.Boarding_point",'left');
		$this->db->join("sandipun_erp.sf_transport_route","sandipun_erp.sf_transport_route.route_id = sandipun_erp.sf_fees_challan.Route_name",'left');
		
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_erp.sf_fees_challan.fees_id', $id);
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1);
		
		//echo $this->db->last_query();exit();
	$query = $this->db->query($query1." UNION ".$query2);
	  // echo $this->db->last_query(); exit();
		return $query->result_array();
	}
	
	public function fees_challan_list($data)
	{
		
		$uid=$this->session->userdata("uid");
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no","INNER");
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
			$this->db->where('sandipun_erp.sf_fees_challan.challan_status', $data['status']);
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
		$this->db->where('sandipun_erp.sf_fees_challan.type_id', '1');
		$this->db->where('sandipun_erp.sf_fees_challan.created_by', $uid);
        $this->db->where('sandipun_ums.student_master.actice_status', 'Y');
		
		
	    //$this->db->order_by("sandipun_erp.sf_fees_challan.fees_id", "DESC");

		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_erp.sf_student_master.first_name,sandipun_erp.sf_student_master.middle_name,sandipun_erp.sf_student_master.last_name,");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_erp.sf_student_master","sandipun_erp.sf_student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no","INNER");
		
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
			$this->db->where('sandipun_erp.sf_fees_challan.challan_status', $data['status']);
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
		$this->db->where('sandipun_erp.sf_fees_challan.type_id', '1');
		$this->db->where('sandipun_erp.sf_fees_challan.created_by', $uid);
		$this->db->where('sandipun_erp.sf_student_master.isactive', 'Y');
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
        $this->db->where('sandipun_erp.sf_student_master.organization', 'SF-SIJOUL');
        }
		
		//$this->db->order_by("sandipun_erp.sf_fees_challan.fees_id", "DESC");
		
		
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
	
	public function get_facility_types()
	{
		$this->db->select("*");
		$this->db->from("sf_facility_types");
		$this->db->where('status', 'Y');
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_depositedto($data)
	{
		$this->db->select("*");
		$this->db->from("sf_bank_account_details");
		$this->db->where('is_active', 'Y');
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
              $this->db->where('account_for', 'Hostel_sijoul');
        }else{	
			$this->db->where('account_for',$data['faci_type']);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function depositedto_details()
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
		//SELECT f.* FROM `sf_student_facilities` as f where f.enrollment_no='170110011050' and f.sffm_id=1 and f.academic_year='2018' and f.cancelled_facility='N' and f.status='Y';
		/* $this->db->select("*");
		$this->db->from("sf_student_facilities");
		$this->db->where('sffm_id', $data['facility']);
		$this->db->where('enrollment_no', $data['enroll']);
		$this->db->where('academic_year LIKE ', $data['academic'].'%');
		$this->db->where('cancelled_facility', 'N');
		$this->db->where('status', 'Y');
		$query = $this->db->get(); */
		
		$sql="SELECT `ssf`.*,sum(sfd.amount) as paid_amt,ifnull(`deposit_fees`, 0) + ifnull(`actual_fees`, 0) + ifnull(`fine_fees`, 0) - ifnull(`excemption_fees`, 0)as applicable_amt 
		FROM `sf_student_facilities` as `ssf`
		LEFT JOIN `sf_fees_details` as `sfd` ON `sfd`.`enrollment_no` = `ssf`.`enrollment_no` and `sfd`.`type_id`=`ssf`.`sffm_id`
		WHERE `ssf`.`sffm_id` = '".$data['facility']."'
		AND `ssf`.`enrollment_no` = '".$data['enroll']."'
		AND ssf.academic_year LIKE  '".$data['academic']."%'
		AND `ssf`.`cancelled_facility` = 'N'
		AND `ssf`.`status` = 'Y'
		GROUP BY `sfd`.`academic_year`";
		$query = $this->db->query($sql);

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
		//echo $this->db->last_query();exit;
		return $last_inserted_id;
	}
	
	public function add_into_sf_fees_details($data)
	{
		$this->db->insert("sf_fees_details", $data); 
		//echo $this->db->last_query();exit();
		$this->db->insert_id(); 
	}
	
	public function update_challan_no($id,$data)
	{
		$this->db->where('fees_id', $id);
		$this->db->update("sf_fees_challan", $data);
		//echo $this->db->last_query();exit();
		return $this->db->affected_rows();
	}
	// guest Challan list
	public function guest_challan_list($id)
	{
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_ums.bank_master.bank_name, sandipun_erp.sf_bank_account_details.account_name,sandipun_erp.sf_bank_account_details.account_no");
		$this->db->from("sf_fees_challan");		
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = sandipun_erp.sf_fees_challan.bank_id",'left');
		$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = sandipun_erp.sf_fees_challan.bank_account_id");
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_erp.sf_fees_challan.mobile is not null');
		if($id !=''){
			$this->db->where('sandipun_erp.sf_fees_challan.fees_id', $id);
		}
		$query1 = $this->db->get_compiled_select();
	
		$query = $this->db->query($query1);
		
		//echo $this->db->last_query();exit();
		$query = $this->db->query($query1);
	   //echo $this->db->last_query(); exit();
		return $query->result_array();
	}	
	public function Hostel_dashboard(){
		$sql='SELECT sfhrd.host_id,ssf.sffm_id, sfsf.present_status,sfsf.enrollment_no,sfsf.student_id,
 sfsf.academic_year, sfhrd.hostel_code,sfhrd.category, 
 #case present_status
 COUNT(sfhrd.sf_room_id) AS total_rooms,

 SUM(CASE WHEN sfsf.`present_status` ="IN" THEN 1 ELSE 0 END) AS student_in,
 SUM(CASE WHEN sfsf.`present_status` ="HOME" THEN 1 ELSE 0 END) AS HOME_in,
 SUM(CASE WHEN sfsf.`present_status` ="CITY" THEN 1 ELSE 0 END) AS CITY_in,
 SUM(CASE WHEN sfhrd.`category` ="Guest House" THEN 1 ELSE 0 END) AS Guest_in,
 SUM(CASE WHEN sfhrd.`category` ="Gym" THEN 1 ELSE 0 END) AS Gym_in,
 SUM(CASE WHEN sfhrd.`category` ="Parlour" THEN 1 ELSE 0 END) AS Parlour_in,
 SUM(CASE WHEN sfhrd.`category` !="Parlour" AND sfhrd.`category`!="Gym" 
AND sfhrd.`category`!="Guest House" AND sfsf.student_id="" 

AND sfsf.`present_status` !="IN" AND sfsf.`present_status` !="HOME" AND  sfsf.`present_status` !="CITY"

THEN 1 ELSE 0 END) AS notalloud_in

 FROM sf_hostel_room_details AS sfhrd 
LEFT JOIN sf_student_facility_allocation AS sfsf ON sfhrd.sf_room_id = sfsf.allocated_id 
AND sfsf.is_active="Y" AND sfsf.sffm_id=1 AND sfsf.academic_year="2019"
LEFT JOIN sf_student_master AS sm ON sm.enrollment_no = sfsf.enrollment_no
LEFT JOIN sf_student_facilities AS ssf ON ssf.sf_id = sfsf.sf_id AND ssf.sffm_id = sfsf.sffm_id
WHERE   
sfhrd.is_active="Y" GROUP BY sfhrd.host_id ORDER BY sfhrd.hostel_code';
		$query = $this->db->query($sql);

		return $query->result_array();
	}
///////////////////////////////////////////////////////////////////////////	


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
		$DB1->where("sm.enrollment_no !=", '');
			$DB1->where("ad.academic_year", $academic_year);	   	    
		$DB1->where("sm.cancelled_admission",'N');
        $DB1->where("sm.admission_confirm",'Y');		
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

public function fetch_alloted_details($data)
	{
		//$DB1 = $this->load->database('icdb', TRUE);
		$ac_year=explode("-",$data['academic_y']);
		if($data['floors']=='')
			$sql="select ssf.sffm_id, sfsf.present_status,sm.first_name, ssf.organisation,sfsf.enrollment_no,sfsf.f_alloc_id,sfsf.student_id, sfsf.academic_year, sfhrd.sf_room_id, sfhrd.hostel_code,sfhrd.host_id,sfhrd.floor_no, CAST(sfhrd.`room_no` AS SIGNED) as room_no, sfhrd.no_of_beds,sfhrd.bed_number, sfhrd.room_type,sfhrd.category from sf_hostel_room_details as sfhrd 
			left join sf_student_facility_allocation as sfsf on sfhrd.sf_room_id = sfsf.allocated_id and sfsf.is_active='Y' and sfsf.sffm_id=1 and sfsf.academic_year='".$data['academic_y']."'
            left join sf_student_master as sm on sm.enrollment_no = sfsf.enrollment_no
			left join sf_student_facilities as ssf on ssf.sf_id = sfsf.sf_id and ssf.sffm_id = sfsf.sffm_id
			WHERE sfhrd.host_id='".$data['host_id']."' and sfhrd.is_active='Y' order by sfhrd.floor_no,room_no,sfhrd.bed_number;";
		else
			$sql="select ssf.sffm_id, sfsf.present_status,sm.first_name, ssf.organisation,sfsf.enrollment_no,sfsf.f_alloc_id,sfsf.student_id, sfsf.academic_year, sfhrd.sf_room_id, sfhrd.hostel_code,sfhrd.host_id,sfhrd.floor_no, CAST(sfhrd.`room_no` AS SIGNED) as room_no, sfhrd.no_of_beds,sfhrd.bed_number, sfhrd.room_type,sfhrd.category from sf_hostel_room_details as sfhrd 
			left join sf_student_facility_allocation as sfsf on sfhrd.sf_room_id = sfsf.allocated_id and sfsf.is_active='Y' and sfsf.sffm_id=1 and sfsf.academic_year='".$data['academic_y']."'
            left join sf_student_master as sm on sm.enrollment_no = sfsf.enrollment_no
			left join sf_student_facilities as ssf on ssf.sf_id = sfsf.sf_id and ssf.sffm_id = sfsf.sffm_id
			WHERE sfhrd.host_id='".$data['host_id']."' and sfhrd.floor_no='".$data['floors']."' and sfhrd.is_active='Y' order by sfhrd.floor_no,room_no,sfhrd.bed_number;";

		$query =$this->db->query($sql);
		//echo $this->db->last_query();exit();
		return  $query->result_array();
	}



}
?>