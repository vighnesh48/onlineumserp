<?php
class Transport_facility_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
       
    }
	public function get_fees_collection_transport($data)
	{
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
		join sandipun_erp.sf_student_master as s on s.enrollment_no = d.enrollment_no
		join sandipun_erp.sf_fees_details as f on f.enrollment_no = s.enrollment_no and f.academic_year=d.academic_year
		left join sandipun_ums.bank_master as b on f.bank_id=b.bank_id
		where f.is_deleted='N' and f.chq_cancelled='N' and f.type_id = '2' and f.academic_year='".$data['academic_year']."' $con2
		UNION 
		SELECT s.stud_id,s.enrollment_no,s.enrollment_no_new,s.first_name,s.middle_name,s.last_name,
		s.mobile,d.organisation,v.school_short_name as intitute,v.stream_short_name as stream,v.course_short_name as
		 course,s.current_year as year,f.amount as paid,s.cancelled_admission, f.fees_paid_type,f.receipt_no as ddno,
		f.amount ,date_format(f.fees_date,'%d-%m-%Y') as fdate,f.college_receiptno,f.chq_cancelled ,f.remark,b.bank_name,
		b.bank_short_name ,d.deposit_fees,d.actual_fees,d.excemption_fees,d.refund as cancellation_refund
		from sandipun_erp.sf_fees_details as f
		join sandipun_erp.sf_student_facilities as d on f.enrollment_no = d.enrollment_no and f.academic_year=d.academic_year
		join sandipun_ums.student_master as s on s.enrollment_no = d.enrollment_no and s.stud_id=d.student_id
		join sandipun_ums.vw_stream_details as v on s.admission_stream = v.stream_id
		left join sandipun_ums.bank_master as b on f.bank_id=b.bank_id
		where f.is_deleted='N' and f.chq_cancelled='N' and f.type_id = '2' and f.academic_year='".$data['academic_year']."' and d.enrollment_no not like '18SUN%' $con1";
		$query=$DB1->query($sql);
		// echo $DB1->last_query();exit;
		$result=$query->result_array();
		//print_r($result);exit();
		return $result;
	}
 
  public function get_Transport_statistics($data){
       
    	$DB1 = $this->load->database('umsdb', TRUE);
    	 $cond=" b.academic_year='".$data['academic_year']."'";
    	if($data['campus']=="ALL"){
    	    
    	  }
    	  else{
    	      $cond.= "  and b.campus='".$data['campus']."'";
    	  }
		$sql="SELECT b.boarding_point,b.campus,COUNT(b.fees_paid) AS stud_total,SUM(b.fees_paid)AS fees_paid,SUM(b.fine)AS fine, SUM(b.actual_fees) AS actual_fees,SUM(b.fine_fees)AS fine_fees,SUM(b.opening_balance)AS opening_balance,SUM(b.excemption_fees) AS excemption_fees FROM 
            ( SELECT DISTINCT r.boarding_point,tr.campus,a.fees_paid,a.fine,f.enrollment_no,f.academic_year,f.deposit_fees,f.actual_fees,f.gym_fees,f.fine_fees,f.opening_balance,f.excemption_fees,f.cancelled_facility FROM sandipun_erp.sf_student_facilities f 
            LEFT JOIN (SELECT enrollment_no,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' and academic_year='".$data['academic_year']."' AND type_id='2' GROUP BY enrollment_no) a 
            ON a.enrollment_no=f.enrollment_no AND f.academic_year=a.academic_year 
            INNER JOIN sandipun_erp.sf_student_facility_allocation s ON s.enrollment_no=f.enrollment_no AND s.academic_year=f.academic_year AND s.is_active='Y' 
            INNER JOIN sandipun_erp.sf_transport_boarding_details r ON r.board_id=s.allocated_id 
            INNER JOIN sandipun_erp.sf_transport_route_details h ON h.board_id=r.board_id
			INNER JOIN sandipun_erp.sf_transport_route tr ON tr.route_id=h.route_id where f.sffm_id=2 and f.cancelled_facility='N' and f.status='Y' 
			)b where $cond
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
    	
    	 /* if($data['campus']=="NASHIK"){
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
		else if($data['institute_name']=="SU-PROV"){
    	 $cond.="  and intitute='".$data['institute_name']."'";
    	}
		else if($data['institute_name']=="JrCollege"){
    	 $cond.="  and intitute='".$data['institute_name']."'";
    	}
    	else{
    	     $cond.="  and intitute='".$data['institute_name']."'"; 
    	} */
		
		if($data['campus']=="NASHIK"){
			$cond.="  and organisation in ('SU','SF')"; 
		}
		else  if($data['campus']=="SIJOUL"){
		   $cond.="  and organisation='SF-SIJOUL'"; 
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
           $cond.='and (p.appl-COALESCE(p.fees_paid,0))!=0';
       }
  
    	$sql="SELECT p.*,COALESCE(p.fees_paid,0),COALESCE(p.fine,0),fa.allocated_id,ra.boarding_point,ra.campus FROM (
        SELECT DISTINCT f.sf_id,f.enrollment_no,f.enrollment_no as enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,s.gender,f.year,f.organisation,s.instute_name AS intitute,s.stream  AS branch_short_name,s.course AS course_name,stream,f.academic_year, f.deposit_fees,f.actual_fees,f.refund,f.gym_fees,f.fine_fees,f.opening_balance, a.fees_paid,a.fine,f.excemption_fees,f.cancelled_facility,(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees+f.opening_balance-f.excemption_fees) as appl FROM sandipun_erp.sf_student_facilities f LEFT JOIN (SELECT enrollment_no,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='2' and academic_year='".$data['academic_year']."' GROUP BY enrollment_no,academic_year) a ON a.enrollment_no=f.enrollment_no AND f.academic_year=a.academic_year INNER JOIN sandipun_erp.sf_student_master s ON s.enrollment_no=f.enrollment_no and s.student_id=f.student_id where f.sffm_id=2 and f.status='Y' and f.cancelled_facility='N' and f.academic_year='".$data['academic_year']."' UNION 
         SELECT DISTINCT f.sf_id,f.enrollment_no,s.enrollment_no_new,s.first_name,s.middle_name,s.last_name,s.mobile,s.gender,f.year,f.organisation,p.school_short_name AS intitute, p.stream_short_name AS branch_short_name,p.course_short_name AS course_name,concat(p.course_short_name,' ',p.stream_short_name) as stream,f.academic_year,f.deposit_fees,f.actual_fees,f.refund,f.gym_fees,f.fine_fees,f.opening_balance,a.fees_paid,a.fine,f.excemption_fees,f.cancelled_facility,(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees+f.opening_balance-f.excemption_fees) as appl FROM sandipun_erp.sf_student_facilities f LEFT JOIN (SELECT type_id,enrollment_no,academic_year,SUM( amount )AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='2' and academic_year='".$data['academic_year']."' GROUP BY enrollment_no) a ON a.enrollment_no=f.enrollment_no AND f.academic_year=a.academic_year INNER JOIN sandipun_ums.student_master s ON (s.enrollment_no=f.enrollment_no or s.enrollment_no_new=f.enrollment_no) AND s.stud_id=f.student_id INNER JOIN sandipun_ums.vw_stream_details p ON s.admission_stream=p.stream_id where f.sffm_id=2 and f.status='Y' and f.cancelled_facility='N' and f.academic_year='".$data['academic_year']."' and f.enrollment_no not like '18SUN%') p LEFT JOIN sf_student_facility_allocation fa ON fa.sf_id=p.sf_id AND fa.is_active='Y' LEFT JOIN sf_transport_boarding_details ra ON ra.board_id=fa.allocated_id 
           WHERE  $cond";
	       $query=$DB1->query($sql);
    	 // echo $DB1->last_query();exit();
    		$result=$query->result_array();
    		return $result;
 
 }
 
  public function get_institute_transportfees_statistics($data){
    	$DB1 = $this->load->database('umsdb', TRUE);
    	 $cond=" academic_year='".$data['academic_year']."' ";
    	 /*  if($data['campus']=="NASHIK"){
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
    	} */
		
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
SUM(b.deposit_fees) as deposit_fees,SUM(b.actual_fees) as actual_fees,SUM(b.refund) as cancellation_refund,SUM(b.gym_fees) as gym_fees,SUM(b.fine_fees)as fine_fees,SUM(b.opening_balance)as opening_balance,SUM(b.excemption_fees) as excemption_fees
 FROM (
SELECT DISTINCT a.fees_paid,a.fine,f.enrollment_no,f.organisation,s.instute_name as college_name,stream as branch_short_name,s.course as course_name,f.academic_year,f.deposit_fees,f.actual_fees,f.refund,f.gym_fees,f.fine_fees,f.opening_balance,f.excemption_fees,f.cancelled_facility
 FROM sandipun_erp.sf_student_facilities f 
 LEFT JOIN 
 (SELECT type_id,enrollment_no,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' and type_id='2' GROUP BY enrollment_no,academic_year) a
 ON a.enrollment_no=f.enrollment_no AND f.academic_year=a.academic_year  and f.sffm_id=a.type_id and a.academic_year='".$data['academic_year']."'
 INNER JOIN sandipun_erp.sf_student_master s ON s.enrollment_no=f.enrollment_no and s.student_id=f.student_id
 where f.cancelled_facility='N' and f.academic_year='".$data['academic_year']."'  AND f.sffm_id=2 
 UNION 
 SELECT DISTINCT a.fees_paid,a.fine,f.enrollment_no,f.organisation,p.school_short_name AS college_name,
 p.stream_short_name AS branch_short_name,p.course_short_name AS course_name,f.academic_year,f.deposit_fees,f.actual_fees,f.refund,f.gym_fees,f.fine_fees,f.opening_balance,f.excemption_fees,f.cancelled_facility
 FROM sandipun_erp.sf_student_facilities f 
 LEFT JOIN 
 (SELECT type_id,enrollment_no,academic_year,SUM(amount)AS fees_paid,SUM(exam_fee_fine) AS fine FROM sandipun_erp.sf_fees_details WHERE chq_cancelled='N' AND is_deleted='N' and type_id='2' GROUP BY enrollment_no,academic_year) a
 ON a.enrollment_no=f.enrollment_no AND f.academic_year=a.academic_year and f.sffm_id=a.type_id and a.academic_year='".$data['academic_year']."'
 INNER JOIN sandipun_ums.student_master s ON (s.enrollment_no=f.enrollment_no or s.enrollment_no_new=f.enrollment_no) and s.stud_id=f.student_id
 INNER JOIN sandipun_ums.vw_stream_details p ON s.admission_stream=p.stream_id where  f.cancelled_facility='N' and f.academic_year='".$data['academic_year']."' AND f.sffm_id=2
 )b where $cond GROUP BY b.organisation,b.college_name,b.academic_year
 ";
	
   $query=$DB1->query($sql);
    	   //echo $DB1->last_query();exit();
    		$result=$query->result_array();
    		return $result;
 }
 
 
 
 public function get_facility_types()
	{
		$this->db->select("*");
		$this->db->from("sf_facility_types");
		$this->db->where('faci_id', '2');
		$this->db->where('status', 'Y');
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
		
		$sql="SELECT tr.route_name,tbd.boarding_point,sfa.route_id,sfa.allocated_id,sfa.is_active,`ssf`.*,sum(sfd.amount) as paid_amt,ifnull(`deposit_fees`, 0) + ifnull(`actual_fees`, 0) + ifnull(`fine_fees`, 0) - ifnull(`excemption_fees`, 0)as applicable_amt 
		FROM `sf_student_facilities` as `ssf`
		LEFT JOIN `sf_fees_details` as `sfd` ON `sfd`.`enrollment_no` = `ssf`.`enrollment_no` and `sfd`.`type_id`=`ssf`.`sffm_id` AND sfd.academic_year='".$data['academic']."'
		LEFT JOIN `sf_student_facility_allocation` as sfa ON sfa.enrollment_no = ssf.enrollment_no AND sfa.sffm_id=ssf.sffm_id AND sfa.academic_year='".$data['academic']."'
		
		INNER JOIN sf_transport_route as tr ON tr.route_id = sfa.route_id
		INNER JOIN sf_transport_boarding_details as tbd ON tbd.board_id = sfa.allocated_id


		WHERE `ssf`.`sffm_id` = '".$data['facility']."'
		AND (`ssf`.`enrollment_no` = '".$data['enroll']."' OR `ssf`.`enrollment_no` = '".$data['enrollnew']."')
		AND ssf.academic_year =  '".$data['academic']."'
		AND `ssf`.`cancelled_facility` = 'N'
		AND `ssf`.`status` = 'Y'
		GROUP BY `sfd`.`academic_year`";
		$query = $this->db->query($sql);

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
		//echo $this->db->last_query();exit();
		return $this->db->affected_rows();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function fees_challan_list($data=array())
	{
		$emp_id = $this->session->userdata("name");
		$this->db->select("sandipun_erp.sf_fees_challan.*,sf.organisation,tr.route_name,tb.boarding_point,sandipun_ums.student_master.mobile,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no AND sandipun_ums.student_master.stud_id=sandipun_erp.sf_fees_challan.student_id");
		$this->db->join("sandipun_erp.sf_transport_route tr","tr.route_id=sandipun_erp.sf_fees_challan.Route_name");
		$this->db->join("sandipun_erp.sf_transport_boarding_details tb","tb.board_id=sandipun_erp.sf_fees_challan.Boarding_point");
		$this->db->join("sandipun_erp.sf_student_facilities sf","sf.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no");
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		if(isset($data['odate']) && $data['odate']!='')
		
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));

		}
		if(isset($data['acyear']) && $data['acyear']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.academic_year', $data['acyear']);
		}else{
			$this->db->where('sandipun_erp.sf_fees_challan.academic_year', C_RE_REG_YEAR);
		}
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.challan_status', $data['status']);
		}
		if(isset($data['campus']) && $data['campus']!='')
		{
			if($data['campus']=='NASHIK'){
				$org =array('SU','SF');
				$this->db->where_in('sf.organisation ', $org);
			}else{
				$org =array('SF-SIJOUL');
				$this->db->where_in('sf.organisation ', $org);
			}
			
		}
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			$orgg =array('SF-SIJOUL','SU-SIJOUL');
			$this->db->where_in('sf.organisation', $orgg);
        }
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		//$this->db->where('sandipun_erp.sf_fees_challan.challan_status', 'PD');
		$this->db->where('sandipun_erp.sf_fees_challan.type_id', '2');
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_ums.student_master.actice_status', 'Y');
		//$this->db->order_by('sandipun_erp.sf_fees_challan.fees_id', 'DESC');
		//$this->db->where('sandipun_erp.sf_fees_challan.created_by', $emp_id);
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("sandipun_erp.sf_fees_challan.*,sf.organisation,tr.route_name,tb.boarding_point,sandipun_erp.sf_student_master.mobile,sandipun_erp.sf_student_master.first_name,sandipun_erp.sf_student_master.middle_name,sandipun_erp.sf_student_master.last_name,");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_erp.sf_student_master","sandipun_erp.sf_student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no AND sandipun_erp.sf_student_master.student_id=sandipun_erp.sf_fees_challan.student_id");
		$this->db->join("sandipun_erp.sf_transport_route tr","tr.route_id=sandipun_erp.sf_fees_challan.Route_name");
		$this->db->join("sandipun_erp.sf_transport_boarding_details tb","tb.board_id=sandipun_erp.sf_fees_challan.Boarding_point");
		$this->db->join("sandipun_erp.sf_student_facilities sf","sf.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no");
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date >=', date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date <=', date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		if(isset($data['odate']) && $data['odate']!='')
		
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));

		}
		if(isset($data['acyear']) && $data['acyear']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.academic_year', $data['acyear']);
		}else{
			$this->db->where('sandipun_erp.sf_fees_challan.academic_year', C_RE_REG_YEAR);
		}
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.challan_status', $data['status']);
		}
		if(isset($data['campus']) && $data['campus']!='')
		{
			if($data['campus']=='NASHIK'){
				$org =array('SU','SF');
				$this->db->where_in('sf.organisation ', $org);
			}else{
				$org =array('SF-SIJOUL');
				$this->db->where_in('sf.organisation ', $org);
			}
			
		}
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			$orgg =array('SF-SIJOUL','SU-SIJOUL');
			$this->db->where_in('sf.organisation', $orgg);
        }
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		//$this->db->where('sandipun_erp.sf_fees_challan.challan_status', 'PD');
		$this->db->where('sandipun_erp.sf_fees_challan.type_id', '2');
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_erp.sf_student_master.isactive', 'Y');
		//$this->db->order_by('fees_id', 'DESC');

		//$this->db->where('sandipun_erp.sf_fees_challan.created_by', $emp_id);
		$query2 = $this->db->get_compiled_select();
		
		
		$this->db->select("sandipun_erp.sf_fees_challan.*,sf.organisation,tr.route_name,tb.boarding_point,sandipun_ums_sijoul.student_master.mobile,sandipun_ums_sijoul.student_master.first_name,sandipun_ums_sijoul.student_master.middle_name,sandipun_ums_sijoul.student_master.last_name,");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_ums_sijoul.student_master","sandipun_ums_sijoul.student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no AND sandipun_ums_sijoul.student_master.stud_id=sandipun_erp.sf_fees_challan.student_id");
		$this->db->join("sandipun_erp.sf_transport_route tr","tr.route_id=sandipun_erp.sf_fees_challan.Route_name");
		$this->db->join("sandipun_erp.sf_transport_boarding_details tb","tb.board_id=sandipun_erp.sf_fees_challan.Boarding_point");
		$this->db->join("sandipun_erp.sf_student_facilities sf","sf.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no");
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		if(isset($data['odate']) && $data['odate']!='')
		
		{
			$this->db->where('sandipun_erp.sf_fees_challan.fees_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));

		}
		if(isset($data['acyear']) && $data['acyear']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.academic_year', $data['acyear']);
		}else{
			$this->db->where('sandipun_erp.sf_fees_challan.academic_year', C_RE_REG_YEAR);
		}
		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.challan_status', $data['status']);
		}
		if(isset($data['campus']) && $data['campus']!='')
		{
			if($data['campus']=='NASHIK'){
				$org =array('SU','SF');
				$this->db->where_in('sf.organisation ', $org);
			}else{
				$org =array('SF-SIJOUL');
				$this->db->where_in('sf.organisation ', $org);
			}
			
		}
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			$orgg =array('SF-SIJOUL','SU-SIJOUL');
			$this->db->where_in('sf.organisation', $orgg);
        }
		if(isset($data['search']) && $data['search']!='')
		{
			$this->db->where('sandipun_erp.sf_fees_challan.enrollment_no like ',$data['search'].'%');
			//$this->db->where("(FirstName='Tove' OR FirstName='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
		}
		//$this->db->where('sandipun_erp.sf_fees_challan.challan_status', 'PD');
		$this->db->where('sandipun_erp.sf_fees_challan.type_id', '2');
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		
		#$this->db->where('sandipun_ums_sijoul.student_master.actice_status', 'Y');
		$this->db->order_by('fees_id', 'DESC');
		
		$query3 = $this->db->get_compiled_select();
		
		
		$query = $this->db->query($query1." UNION ".$query2." UNION ".$query3);
		//echo $this->db->last_query();exit();
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	
	
	public function fees_challan_list_byid($id)
	{
		$query1="SELECT `sandipun_erp`.`sf_fees_challan`.*, `sandipun_ums`.`student_master`.`current_year`, `sandipun_ums`.`student_master`.`mobile`, 
`sandipun_ums`.`student_master`.enrollment_no,`sandipun_ums`.`student_master`.enrollment_no_new, `sandipun_ums`.`student_master`.`stud_id`, 
`sandipun_ums`.`student_master`.`admission_stream`, `sandipun_ums`.`student_master`.`first_name`, 
`sandipun_ums`.`student_master`.`middle_name`, `sandipun_ums`.`student_master`.`last_name`, 
`sandipun_ums`.`vw_stream_details`.`stream_short_name` AS `stream_name`, `sandipun_ums`.`vw_stream_details`.`course_name`, 
`sandipun_ums`.`vw_stream_details`.`stream_code` AS `sfcourse`, 
`sandipun_ums`.`vw_stream_details`.`stream_short_name` AS `sfstream`, 
`sandipun_ums`.`vw_stream_details`.`school_short_name` AS `school_name`, `sandipun_ums`.`bank_master`.`bank_name` AS `stud_bankname`, 
`sandipun_erp`.`sf_bank_account_details`.`account_name`, `sandipun_erp`.`sf_bank_account_details`.`account_no`, 
`sandipun_erp`.`sf_bank_account_details`.`branch_name`,`sandipun_erp`.`sf_bank_account_details`.`client_id`, `sandipun_erp`.`sf_bank_account_details`.`bank_name`, 
`sandipun_erp`.`sf_transport_boarding_details`.`boarding_point`, `sandipun_erp`.`sf_transport_route`.`route_name`,sandipun_erp.user_master.display_name
 FROM `sf_fees_challan` 
 JOIN `sandipun_ums`.`student_master` ON (`sandipun_ums`.`student_master`.`enrollment_no_new`=`sandipun_erp`.`sf_fees_challan`.`enrollment_no`  OR 
 `sandipun_ums`.`student_master`.`enrollment_no`=`sandipun_erp`.`sf_fees_challan`.`enrollment_no`)
 AND `sandipun_ums`.`student_master`.`stud_id`=`sandipun_erp`.`sf_fees_challan`.`student_id`
 LEFT JOIN `sandipun_ums`.`vw_stream_details` ON `sandipun_ums`.`student_master`.`admission_stream` = `sandipun_ums`.`vw_stream_details`.`stream_id` 
 LEFT JOIN sandipun_erp.user_master ON sandipun_erp.user_master.um_id = sandipun_erp.sf_fees_challan.created_by
 LEFT JOIN `sandipun_ums`.`bank_master` ON `sandipun_ums`.`bank_master`.`bank_id` = `sandipun_erp`.`sf_fees_challan`.`bank_id` 
 LEFT JOIN `sandipun_erp`.`sf_bank_account_details` ON `sandipun_erp`.`sf_bank_account_details`.`bank_account_id` = `sandipun_erp`.`sf_fees_challan`.`bank_account_id` 
 LEFT JOIN `sandipun_erp`.`sf_transport_boarding_details` ON `sandipun_erp`.`sf_transport_boarding_details`.`board_id` = `sandipun_erp`.`sf_fees_challan`.`Boarding_point` LEFT JOIN `sandipun_erp`.`sf_transport_route` ON `sandipun_erp`.`sf_transport_route`.`route_id` = `sandipun_erp`.`sf_fees_challan`.`Route_name`
  WHERE `sandipun_erp`.`sf_fees_challan`.`is_deleted` = 'N' AND `sandipun_erp`.`sf_fees_challan`.`fees_id` = '$id' 

  UNION 
  
  SELECT `sandipun_erp`.`sf_fees_challan`.*, `sandipun_erp`.`sf_student_master`.`current_year`, `sandipun_erp`.`sf_student_master`.`mobile`, 
  `sandipun_erp`.`sf_student_master`.`enrollment_no`,'' as enrollment_no_new, `sandipun_erp`.`sf_student_master`.`student_id` AS `stud_id`, 
  `sandipun_erp`.`sf_student_master`.`program_id` AS `admission_stream`, `sandipun_erp`.`sf_student_master`.`first_name`, 
  `sandipun_erp`.`sf_student_master`.`middle_name`, `sandipun_erp`.`sf_student_master`.`last_name`, 
  `sandipun_erp`.`sf_program_detail`.`branch_name` AS `stream_name`, 
  `sandipun_erp`.`sf_program_detail`.`course_name`, `sandipun_erp`.`sf_student_master`.`course` AS `sfcourse`, 
  `sandipun_erp`.`sf_student_master`.`stream` AS `sfstream`, 
  `sandipun_erp`.`sf_program_detail`.`college_name` AS `school_name`, `sandipun_ums`.`bank_master`.`bank_name` AS `stud_bankname`, 
  `sandipun_erp`.`sf_bank_account_details`.`account_name`, `sandipun_erp`.`sf_bank_account_details`.`account_no`, 
  `sandipun_erp`.`sf_bank_account_details`.`branch_name`,`sandipun_erp`.`sf_bank_account_details`.`client_id`, `sandipun_erp`.`sf_bank_account_details`.`bank_name`,
   `sandipun_erp`.`sf_transport_boarding_details`.`boarding_point`, `sandipun_erp`.`sf_transport_route`.`route_name`,sandipun_erp.user_master.display_name
    FROM `sf_fees_challan` 
    JOIN `sandipun_erp`.`sf_student_master` ON `sandipun_erp`.`sf_student_master`.`enrollment_no`=`sandipun_erp`.`sf_fees_challan`.`enrollment_no` 
    LEFT JOIN `sandipun_erp`.`sf_program_detail` ON `sandipun_erp`.`sf_student_master`.`program_id` = `sandipun_erp`.`sf_program_detail`.`sf_program_id` 
	 LEFT JOIN sandipun_erp.user_master ON sandipun_erp.user_master.um_id = sandipun_erp.sf_fees_challan.created_by
    LEFT JOIN `sandipun_ums`.`bank_master` ON `sandipun_ums`.`bank_master`.`bank_id` = `sandipun_erp`.`sf_fees_challan`.`bank_id`
    LEFT JOIN `sandipun_erp`.`sf_bank_account_details` ON `sandipun_erp`.`sf_bank_account_details`.`bank_account_id` = `sandipun_erp`.`sf_fees_challan`.`bank_account_id` 
    LEFT JOIN `sandipun_erp`.`sf_transport_boarding_details` ON `sandipun_erp`.`sf_transport_boarding_details`.`board_id` = `sandipun_erp`.`sf_fees_challan`.`Boarding_point` 
    LEFT JOIN `sandipun_erp`.`sf_transport_route` ON `sandipun_erp`.`sf_transport_route`.`route_id` = `sandipun_erp`.`sf_fees_challan`.`Route_name`
     WHERE `sandipun_erp`.`sf_fees_challan`.`is_deleted` = 'N' 
      AND `sandipun_erp`.`sf_fees_challan`.`fees_id` = '$id'
	  
	  UNION
	  
	  SELECT `sandipun_erp`.`sf_fees_challan`.*, 
`sandipun_ums_sijoul`.`student_master`.`current_year`, `sandipun_ums_sijoul`.`student_master`.`mobile`, 
`sandipun_ums_sijoul`.`student_master`.enrollment_no,`sandipun_ums_sijoul`.`student_master`.enrollment_no_new, `sandipun_ums_sijoul`.`student_master`.`stud_id`, 
`sandipun_ums_sijoul`.`student_master`.`admission_stream`, `sandipun_ums_sijoul`.`student_master`.`first_name`, 
`sandipun_ums_sijoul`.`student_master`.`middle_name`, `sandipun_ums_sijoul`.`student_master`.`last_name`, 
`sandipun_ums_sijoul`.`vw_stream_details`.`stream_short_name` AS `stream_name`, `sandipun_ums_sijoul`.`vw_stream_details`.`course_name`, 
`sandipun_ums_sijoul`.`vw_stream_details`.`stream_code` AS `sfcourse`, 
`sandipun_ums_sijoul`.`vw_stream_details`.`stream_short_name` AS `sfstream`, 
`sandipun_ums_sijoul`.`vw_stream_details`.`school_short_name` AS `school_name`, `sandipun_ums_sijoul`.`bank_master`.`bank_name` AS `stud_bankname`, 
`sandipun_erp`.`sf_bank_account_details`.`account_name`, `sandipun_erp`.`sf_bank_account_details`.`account_no`, 
`sandipun_erp`.`sf_bank_account_details`.`branch_name`,`sandipun_erp`.`sf_bank_account_details`.`client_id`,
 `sandipun_erp`.`sf_bank_account_details`.`bank_name`, 
`sandipun_erp`.`sf_transport_boarding_details`.`boarding_point`, 
`sandipun_erp`.`sf_transport_route`.`route_name`,sandipun_erp.user_master.display_name
 FROM `sf_fees_challan` 
 JOIN `sandipun_ums_sijoul`.`student_master` ON (`sandipun_ums_sijoul`.`student_master`.`enrollment_no_new`=`sandipun_erp`.`sf_fees_challan`.`enrollment_no` 
  OR `sandipun_ums_sijoul`.`student_master`.`enrollment_no`=`sandipun_erp`.`sf_fees_challan`.`enrollment_no`)
 AND `sandipun_ums_sijoul`.`student_master`.`stud_id`=`sandipun_erp`.`sf_fees_challan`.`student_id`
 LEFT JOIN `sandipun_ums_sijoul`.`vw_stream_details`
  ON `sandipun_ums_sijoul`.`student_master`.`admission_stream` = `sandipun_ums_sijoul`.`vw_stream_details`.`stream_id` 
 LEFT JOIN sandipun_erp.user_master ON 
 sandipun_erp.user_master.um_id = sandipun_erp.sf_fees_challan.created_by
 LEFT JOIN `sandipun_ums_sijoul`.`bank_master` ON 
 `sandipun_ums_sijoul`.`bank_master`.`bank_id` = `sandipun_erp`.`sf_fees_challan`.`bank_id` 
 LEFT JOIN `sandipun_erp`.`sf_bank_account_details` ON 
 `sandipun_erp`.`sf_bank_account_details`.`bank_account_id` = `sandipun_erp`.`sf_fees_challan`.`bank_account_id` 
 LEFT JOIN `sandipun_erp`.`sf_transport_boarding_details` ON 
 `sandipun_erp`.`sf_transport_boarding_details`.`board_id` = `sandipun_erp`.`sf_fees_challan`.`Boarding_point` 
 LEFT JOIN `sandipun_erp`.`sf_transport_route` ON `sandipun_erp`.`sf_transport_route`.`route_id` = `sandipun_erp`.`sf_fees_challan`.`Route_name`
  WHERE `sandipun_erp`.`sf_fees_challan`.`is_deleted` = 'N' AND `sandipun_erp`.`sf_fees_challan`.`fees_id` = '$id'
	  
	  
	  
	  ";
	  $query = $this->db->query($query1);
		
		//echo $this->db->last_query();exit();
	    //$query = $this->db->query($query1." UNION ".$query2);
	  // echo $this->db->last_query(); exit();
		return $query->result_array();
	}

	public function fees_challan_list_byidold($id)
	{
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_ums.student_master.current_year,sandipun_ums.student_master.mobile,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,sandipun_ums.student_master.admission_stream,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name, sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_ums.bank_master.bank_name, sandipun_erp.sf_bank_account_details.account_name,sandipun_erp.sf_bank_account_details.account_no");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no");
		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = sandipun_erp.sf_fees_challan.bank_id",'left');
		$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = sandipun_erp.sf_fees_challan.bank_account_id");
		$this->db->where('sandipun_erp.sf_fees_challan.type_id', '2');
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_erp.sf_fees_challan.fees_id', $id);
		$query1 = $this->db->get_compiled_select();
		

		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_ums.student_master.current_year,sandipun_ums.student_master.mobile,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,sandipun_ums.student_master.admission_stream,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name, sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_ums.bank_master.bank_name, sandipun_erp.sf_bank_account_details.account_name,sandipun_erp.sf_bank_account_details.account_no");
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_ums.student_master","sandipun_ums.student_master.enrollment_no_new=sandipun_erp.sf_fees_challan.enrollment_no");
		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = sandipun_erp.sf_fees_challan.bank_id",'left');
		$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = sandipun_erp.sf_fees_challan.bank_account_id");
		$this->db->where('sandipun_erp.sf_fees_challan.type_id', '2');
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_erp.sf_fees_challan.fees_id', $id);
		$query2 = $this->db->get_compiled_select();
		
		$this->db->select("sandipun_erp.sf_fees_challan.*,sandipun_erp.sf_student_master.current_year,sandipun_erp.sf_student_master.mobile,sandipun_erp.sf_student_master.enrollment_no,sandipun_erp.sf_student_master.student_id as stud_id,sandipun_erp.sf_student_master.program_id as admission_stream,sandipun_erp.sf_student_master.first_name,sandipun_erp.sf_student_master.middle_name,sandipun_erp.sf_student_master.last_name,sandipun_ums.bank_master.bank_name, sandipun_erp.sf_bank_account_details.account_name, sandipun_erp.sf_bank_account_details.account_no,`sandipun_ums`.`vw_stream_details`.`stream_short_name` AS `stream_name`, 
`sandipun_ums`.`vw_stream_details`.`course_name`,
`sandipun_ums`.`vw_stream_details`.`school_short_name` AS `school_name`"); //sm.stream as stream_name, sm.course as course_name, sm.instute_name as school_name,
		$this->db->from("sf_fees_challan");
		
		$this->db->join("sandipun_erp.sf_student_master","sandipun_erp.sf_student_master.enrollment_no=sandipun_erp.sf_fees_challan.enrollment_no");
		//$this->db->join('sandipun_erp.sf_program_detail as spd','sandipun_erp.sf_student_master.program_id = spd.sf_program_id','left');
		$this->db->join("`sandipun_ums`.`vw_stream_details`", 
 "`sandipun_erp`.`sf_student_master`.`program_id` = `sandipun_ums`.`vw_stream_details`.`stream_id`",'left');
		
	
		
		$this->db->join("sandipun_ums.bank_master","sandipun_ums.bank_master.bank_id = sandipun_erp.sf_fees_challan.bank_id",'left');
		$this->db->join("sandipun_erp.sf_bank_account_details","sandipun_erp.sf_bank_account_details.bank_account_id = sandipun_erp.sf_fees_challan.bank_account_id");
		$this->db->where('sandipun_erp.sf_fees_challan.type_id', '2');
		$this->db->where('sandipun_erp.sf_fees_challan.is_deleted', 'N');
		$this->db->where('sandipun_erp.sf_fees_challan.fees_id', $id);
		$this->db->order_by('fees_id', 'DESC');
		$query3 = $this->db->get_compiled_select();
		
		//$query = $this->db->query($query1);
		
		
		
		//echo $this->db->last_query();exit();
	$query = $this->db->query($query1." UNION ".$query2." UNION ".$query3);
	   // $this->db->last_query(); 
		return $query->result_array();
	}
	
	public function add_into_sf_fees_details($data)
	{
		$this->db->insert("sf_fees_details", $data); 
		//echo $this->db->last_query();exit();
		$this->db->insert_id(); 
	}
	
  public function update_online_payment($receipt_number,$student_id,$amt){
		//$DB1 = $this->load->database('umsdb', TRUE);
		$update_array_f['verification_status']='Y';
		$update_array_f['verified_by']=$_SESSION['uid'];
		$update_array_f['verified_on']=date('Y-m-d h:i:s');
		//$DB1->where('student_id', $student_id);
		$this->db->where('amount', $amt);
		$this->db->where('bank_ref_num', $receipt_number);
		$this->db->update("online_payment_facilities", $update_array_f);
		//echo $this->db->last_query();exit();
		return $this->db->affected_rows();
	  }	
	
	
}
?>