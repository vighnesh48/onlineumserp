<?php
class Guesthouse_model extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
		//error_reporting(E_ALL);
		//ini_set('display_errors', 1);
    }
	
	public function getAllState()
	{
	    $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT * from states where country_id=101 order by state_name";
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	
	public function get_guesthouse_details($id='')
	{
		

		$this->db->select("gm.*,");
		$this->db->from("sf_guesthouse_master as gm");
		if($id!='')
		{
			$this->db->where('gm.gh_id', $id);
		}
$exp = explode("_",$this->session->userdata("name"));
   //	echo $exp[1];
		     if($exp[1]=="sijoul")
        {              
              $this->db->where('gm.campus', 'SIJOUL');
        }
        
            if($exp[1]=="nashik")
        {
        	$this->db->where('gm.campus', 'NASHIK');
 $rolid = $this->session->userdata("role_id");
 if($rolid=='28'){
 	$this->db->where('gm.location', 'T');
 }elseif($rolid=='17'){
 	$this->db->where('gm.location !=', 'T');
 }
           
        }
		$this->db->where('is_active', 'Y');
		$this->db->order_by("gm.campus,gm.gh_id", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query();

		return $query->result_array();
	}


	public function get_guesthouse_details_individual($data)
	{
		$this->db->select("gm.*,");
		$this->db->from("sf_guesthouse_master as gm");
		if($data['campus']!='')
		{
			$this->db->where('gm.campus', $data['campus']);
			
		}
		if($data['host_typ']!=''){
			if($data['host_typ']=='T'){
			$this->db->where('gm.location', 'T');
		}elseif($data['host_typ']=='H'){
$this->db->where('gm.location !=', 'T');
		}

		}
		if($data['g_id']!=''){
			$this->db->where('gm.gh_id',$data['g_id']);
		}
		$this->db->where('is_active', 'Y');
		$this->db->order_by("gm.campus,gm.gh_id", "desc");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	/* public function get_allghouses_in_allocationlist($id='')
	{
		
	} */
	
	function  get_hostel_details($hostel_id='',$campus='')
    {
		$this->db->distinct();
		$this->db->select("h.host_id,h.hostel_name"); 
		$this->db->from("`sf_hostel_master` as h");
		$this->db->join("sf_hostel_room_details as r","r.host_id=h.host_id");
	    $this->db->where('r.category','Guest House');

		if($hostel_id!="")
        {
            $this->db->where('h.host_id',$hostel_id);
        }
        
        if(isset($campus) && $campus!="")
        {
			 $this->db->where('h.campus_name',$campus);
        }
        
        
   		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			  $this->db->where('h.campus_name','SIJOUL');
        }
        if($exp[1]=="nashik")
        {
			$this->db->where('h.campus_name','NASHIK');
        }
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return  $query->result_array();
    }
	
	public function get_rooms_detailsbyhid($roomslist,$data)
    {		
		$this->db->select("sfhrd.sf_room_id,sfhrd.room_no,sfhrd.host_id,sfhrd.hostel_code, sfhrd.floor_no, sfhrd.no_of_beds as numbeds,sfhrd.bed_number,sfhrd.room_type, sfhrd.category, sfhrd.is_active,sfhm.*,"); 
		$this->db->from("sf_hostel_room_details as sfhrd");
		$this->db->join("sf_hostel_master as sfhm","sfhm.hostel_code = sfhrd.hostel_code");
	    $this->db->where('sfhrd.category','Guest House');
		$this->db->where_not_in('room_no',$roomslist);
		if(isset($data['host_id']) && $data['host_id']!='')
		{
			$this->db->where('sfhrd.host_id',$data['host_id']);
		}
		$this->db->group_by('floor_no,CAST(`room_no` AS SIGNED)'); 

		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return  $query->result_array();
	}
	public function get_room_details_hostel($data){
		$sql="select rd.hostel_code,rd.floor_no,rd.no_of_beds from sf_hostel_room_details rd inner join sf_hostel_master hm on hm.host_id = rd.host_id where hm.campus_name='".$data['camp']."' and rd.host_id='".$data['host']."' and rd.room_no='".$data['rm']."'";
$query = $this->db->query($sql);
        
        return $query->result_array();
	}
	public function get_distinct_hostels($hostelslist,$data)
    {		
		$this->db->distinct();
		$this->db->select("h.host_id,h.hostel_name"); 
		$this->db->from("`sf_hostel_master` as h");
		$this->db->join("sf_hostel_room_details as r","r.host_id=h.host_id");
	    $this->db->where('r.category','Guest House');
		$this->db->where_not_in('h.host_id',$hostelslist);
		if(isset($data['host_id']) && $data['host_id']!='')
		{
			$this->db->where('h.host_id',$data['host_id']);
		}

		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return  $query->result_array();
	}
	
	public function get_all_hostel_allocated()
	{
		$sql="SELECT count(location) as room_count,SUBSTRING_INDEX(location,'_',2) as hostel FROM `sf_guesthouse_master` group by hostel";
		$query = $this->db->query($sql);
        
        return $query->result_array();
	}
	
	public function get_beds_available_gh()
	{
		$this->db->select("gm.*,");
		$this->db->from("sf_guesthouse_master as gm");
		if($id!='')
		{
			$this->db->where('gm.gh_id', $id);
		}
		$this->db->where('gm.current_status', 'AVAILABLE');
		$this->db->where('is_active', 'Y');
		$this->db->order_by("gm.campus,gm.gh_id", "desc");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_ghouse_list_by_creteria($data)
	{		
		/* select g.*,in_date,out_date from sf_guesthouse_master as g 
		left join (
		select count(*) as count,vr.gh_id,DATE(vd.proposed_in_date) as in_date,DATE(vd.proposed_out_date) as out_date from sf_guesthouse_visitor_room as vr 
		join sf_guesthouse_visitor_details as vd on vd.v_id=vr.vr_id 
		where vr.current_status='BOOKING-DONE' and DATE(vd.proposed_in_date) >= '2018-09-01'
		AND DATE(vd.proposed_out_date) <= '2018-09-21' group by vr.gh_id having count>0
		) v on v.gh_id=g.gh_id where g.bed_available>0
		*/
		//var_dump($data);
		$cond="";$gcond="";
		if(isset($data['cin']) && $data['cin']!='' && isset($data['cout']) && $data['cout']!='')
		{
			$cond=" and (('".date("Y-m-d", strtotime(str_replace('/', '-', $data['cin'])))."' between  DATE(vd.proposed_in_date) and DATE(vd.proposed_out_date)) or  ('".date("Y-m-d", strtotime(str_replace('/', '-', $data['cout'])))."' between  DATE(vd.proposed_in_date) and DATE(vd.proposed_out_date))) ";
		}
		else if(isset($data['cin']) && $data['cin']!='')
		{
			$cond=" AND ('".date("Y-m-d", strtotime(str_replace('/', '-', $data['cin'])))."' between  DATE(vd.proposed_in_date) and DATE(vd.proposed_out_date))";
		}
		else if(isset($data['cout']) && $data['cout']!='')
		{
			$cond=" AND ('".date("Y-m-d", strtotime(str_replace('/', '-', $data['cout'])))."' between  DATE(vd.proposed_in_date) and DATE(vd.proposed_out_date)) ";
		}
		
		if(isset($data['campus']) && $data['campus']!='')
		{
			$gcond.=" and campus='".$data['campus']."'";
		}
		
		if(isset($data['gtype']) && $data['gtype']!='')
		{
			$gcond.=" and guesthouse_type='".$data['gtype']."'";
		}
		
		//if(isset($data['nperson']) && $data['nperson']!='')
		//{
		//	$gcond.=" and bed_available>='".$data['nperson']."'";
		//}

		//$sql="select g.*,in_date,out_date from sf_guesthouse_master as g 
		//left join (
		//select count(*) as count,vr.gh_id,DATE(vd.proposed_in_date) as in_date,DATE(vd.proposed_out_date) as out_date from //sf_guesthouse_visitor_room as vr 
		//join sf_guesthouse_visitor_details as vd on vd.v_id=vr.vr_id 
		//where vr.current_status='BOOKING-DONE' $cond group by vr.gh_id having count>0
		//) v on v.gh_id=g.gh_id where 1 $gcond";
$sql="select g.*,in_date,out_date,v.no_of_person,v.current_status from sf_guesthouse_master as g 
		left join (
		select count(*) as count,vr.gh_id,DATE(vd.proposed_in_date) as in_date,vd.`current_status`,vd.`no_of_person`,DATE(vd.proposed_out_date) as out_date from sf_guesthouse_visitor_room as vr 
		join sf_guesthouse_visitor_details as vd on vd.booking_id=vr.booking_id 
		where vr.current_status='BOOKING-DONE' $cond group by vr.gh_id having count>0
		) v on v.gh_id=g.gh_id where 1 $gcond";

		$query = $this->db->query($sql);
		//echo $this->db->last_query(); //exit();
		return $query->result_array();
	}
	
	public function check_guesthouse_beds_remaining($data)
	{
		$sql="select count(*) as count,vr.gh_id from sf_guesthouse_visitor_room as vr 
		where vr.current_status='BOOKING-DONE' and vr.gh_id='".$data['ghid']."' group by vr.gh_id having count>0";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function check_visitor_exists($data)
	{
		$where=" vm.visitor_name='".$data['vname']."' or  vm.mobile='".$data['mobile']."' or vm.email='".$data['email']."'";
		if(isset($data['vid']) && $data['vid']!='')
			$where.=" and vm.v_id!='".$data['vid']."'";
		
		$this->db->select("vm.*,");
		$this->db->from("sf_guesthouse_visitor_master as vm");
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function visitors_master()
	{
		$this->db->select("vm.*,");
		$this->db->from("sf_guesthouse_visitor_master as vm");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function check_guesthouse_exists($data)
	{
		if(isset($data['id']) && $data['id']!='')
			$where=" campus='".$data['campus']."' and  guesthouse_name='".$data['gname']."' and gh_id!='".$data['id']."'";
		else
			$where=" campus='".$data['campus']."' and  guesthouse_name='".$data['gname']."'";
		
		$this->db->distinct();
		$this->db->select("COUNT(gh_id) as count_rows");
		$this->db->from("sf_guesthouse_master");
		$this->db->where($where);
		
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->row()->count_rows;
	}
	
	public function add_guesthouse_submit($data)
	{
		//var_dump($data);exit();
		$this->db->insert("sf_guesthouse_master", $data); 
		$last_inserted_id=$this->db->insert_id();  
		//echo $this->db->last_query();exit();              
		return $last_inserted_id;
	}
	
	public function edit_guesthouse_submit($data,$id)
	{
		$this->db->where('gh_id', $id);
		$this->db->update("sf_guesthouse_master", $data);
		return $this->db->affected_rows();
	}
	
	public function edit_visitmaster_submit($data,$id)
	{
		$this->db->where('v_id', $id);
		$this->db->update("sf_guesthouse_visitor_master", $data);
		//echo $this->db->last_query();exit(); 
		return $this->db->affected_rows();
	}
	
	public function add_visitmaster_submit($data)
	{
		$this->db->insert("sf_guesthouse_visitor_master", $data); 
		//echo $this->db->last_query();exit(); 
		$last_inserted_id=$this->db->insert_id();             
		return $last_inserted_id;
	}
	
	public function add_visitordetails_submit($data)
	{
		$this->db->insert("sf_guesthouse_visitor_details", $data); 
		//echo $this->db->last_query();exit(); 
		$last_inserted_id=$this->db->insert_id();             
		return $last_inserted_id;
	}
	
	public function update_visitordetails_submit($data,$id)
	{
		$this->db->where('booking_id', $id);
		$this->db->update("sf_guesthouse_visitor_details", $data);
		return $this->db->affected_rows();
	}
	
	public function update_existed_visitor_ghouse_details($data)
	{
		$this->db->update_batch('sf_guesthouse_visitor_room', $data,'vr_id');
		return $this->db->affected_rows();
	}
	
	public function add_individual_visitor_ghouse_details($data)
	{
		//ini_set('error_reporting', E_ALL);
		//print_r($data);exit;
		$this->db->insert_batch('sf_guesthouse_visitor_room', $data);
		//echo $this->db->last_query();//exit();
		$last_inserted_id=$this->db->insert_id();
		return $last_inserted_id;
	}
	
	public function update_ghouse_available_bed_details($data)
	{
		$this->db->update_batch('sf_guesthouse_master', $data,'gh_id');
		return $this->db->affected_rows();
	}
	
	public function update_ghouse_details_atcheckin($data)
	{
		$this->db->update_batch('sf_guesthouse_visitor_room', $data,'vr_id');
		//echo $this->db->last_query();//exit();
		return $this->db->affected_rows();
	}
	
	public function get_booking_list($data=array())
	{
		$this->db->select("gm.*,vm.visitor_name,vm.gender,vm.mobile,vm.id_proof,vm.id_ref_no,vm.email,vd.reference_of,vd.booking_id,vd.visiting_purpose,vd.proposed_in_date,vd.proposed_out_date,vd.no_of_days,vd.no_of_person,vd.charges,vr.checkin_on,vr.checkin_out,vr.current_status");
	
		$this->db->from("sf_guesthouse_visitor_room as vr");
		
		$this->db->join("sf_guesthouse_visitor_details as vd","vr.booking_id=vd.booking_id ");
		
		$this->db->join("sf_guesthouse_visitor_master as vm","vm.v_id=vd.v_id");
		$this->db->join("sf_guesthouse_master as gm","vr.gh_id=gm.gh_id","left");
		//$this->db->join("guesthouse_challan as gc","gc.Booking_id=vd.Booking_id","left");

		if(isset($data['status']) && $data['status']!='')
		{
			$this->db->where('vd.current_status', $data['status']);
		}
		if(isset($data['gtype']) && $data['gtype']!='')
		{
			$this->db->where('gm.gh_id', $data['gtype']);
		}
		if(isset($data['nperson']) && $data['nperson']!='')
		{
			$this->db->where('vd.no_of_person', $data['nperson']);
		}
		if(isset($data['cin']) && $data['cin']!='')
		{
			$this->db->where('DATE(vd.proposed_in_date)', DATE(date("Y-m-d", strtotime(str_replace('/', '-', $data['cin'])))));
		}
		if(isset($data['cout']) && $data['cout']!='')
		{
			$this->db->where('DATE(vd.proposed_out_date)', DATE(date("Y-m-d", strtotime(str_replace('/', '-', $data['cout'])))));
		}
		$rolid = $this->session->userdata("role_id");
 if($rolid=='28'){
 	$this->db->where('gm.location', 'T');
 }elseif($rolid=='17'){
 	$this->db->where('gm.location !=', 'T');
 }
        
		$this->db->group_by('vr.booking_id'); 
		$this->db->order_by('vr.vr_id desc'); 
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function dashboard($data)
	{
		
		// $this->db->select("vr.`visitor_name`,vr.mobile,vr.`checkin_on`,vr.`checkin_out`,vr.gh_id, gm.guesthouse_name,gm.bed_available,vr.current_status");
		// $this->db->from("sf_guesthouse_master as gm");
		// $this->db->join("sf_guesthouse_visitor_room as vr","vr.gh_id=gm.gh_id ");		
		// if(isset($data['gtype']) && $data['gtype']!='')
		// {
		// 	$this->db->where('vr.gh_id',$data['gtype']);
		// }		
		// 	if(isset($data['daywise']) && $data['daywise']!='')
		// {
		// 	$this->db->where('vr.checkin_on',  date("Y-m-d", strtotime(str_replace('/', '-', $data['daywise']))));
		// }		
		// $this->db->order_by('vr.gh_id,vr.booking_id'); 
		// $query = $this->db->get();
if(isset($data['daywise']) && $data['daywise']!='')
 {
 	$dw= " AND ('".date('Y-m-d',strtotime($data['daywise']))."'   BETWEEN  date(vd.proposed_in_date) AND DATE(vd.proposed_out_date)) OR 
 ('".date('Y-m-d',strtotime($data['daywise']))."'  BETWEEN DATE(vd.proposed_in_date) AND (vd.proposed_out_date)) ";

}
if(isset($data['gtype']) && $data['gtype']!='')
		 {
		 	$gw = " and vr.gh_id= '".$data['gtype']."'";
		 }
		 $rolid = $this->session->userdata("role_id");
 if($rolid=='28'){
 	$gm = "and gm.location = 'T'";
 }elseif($rolid=='17'){
 	$gm = "and gm.location != 'T'";
 }
 $exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			  $cmp = " and gm.campus ='SIJOUL'";
        }
        if($exp[1]=="nashik")
        {
			 $cmp = " and gm.campus ='NASHIK'";
        }

		$sql="SELECT vd.proposed_in_date,vd.current_status,gm.guesthouse_name,gm.room_no,gm.location,gm.campus,vr.bed_no,t.taluka_name,s.state_name,vd.proposed_out_date,vm.address,vd.no_of_days,vd.no_of_person,vr.gh_id,vr.booking_id,vr.visitor_name,vr.checkin_on,vr.checkin_out,vm.city,vm.state,vm.pincode,vm.id_proof,vm.id_ref_no,vd.is_chargeble,vd.charges
FROM sf_guesthouse_visitor_details AS vd 
INNER JOIN sf_guesthouse_visitor_room vr ON vr.booking_id=vd.booking_id 
inner join sf_guesthouse_visitor_master vm on vd.v_id=vm.v_id
left join sandipun_ums.states s on vm.state=s.state_id
left join sandipun_ums.taluka_master t on vm.city=t.taluka_id
left join sf_guesthouse_master gm on gm.gh_id=vr.gh_id
WHERE 1 $dw $gw $gm $cmp";
      $query = $this->db->query($sql);
	
		//echo $this->db->last_query();//exit();
		return $query->result_array();
	}
	
	public function get_booked_ghouses($data)
	{
		$this->db->select("gm.*,vr.visitor_name,vr.mobile,vm.visitor_name as booking_name,vm.gender,vm.mobile,vm.id_proof,vm.id_ref_no,vm.email,vd.reference_of,vd.booking_id,vd.visiting_purpose,vd.proposed_in_date,vd.proposed_out_date,vd.no_of_days,vd.no_of_person,vd.charges,vr.checkin_on,vr.current_status");
	
		$this->db->from("sf_guesthouse_visitor_room as vr");
		
		$this->db->join("sf_guesthouse_visitor_details as vd","vr.booking_id=vd.booking_id and vd.current_status!='CANCELLED'");
		
		$this->db->join("sf_guesthouse_visitor_master as vm","vm.v_id=vd.v_id");
		$this->db->join("sf_guesthouse_master as gm","vr.gh_id=gm.gh_id");
		
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='' && $data['selectby']=='Between')
		{
			$this->db->where('DATE(vd.proposed_in_date) >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('DATE(vd.proposed_in_date) <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		else if(isset($data['daywise']) && $data['daywise']!='' && $data['selectby']=='Datewise')
		{
			$this->db->where('DATE(vd.proposed_in_date)',  date("Y-m-d", strtotime(str_replace('/', '-', $data['daywise']))));
		}
		if(isset($data['campus']) && $data['campus']!=''){
			$this->db->where('gm.campus',$data['campus']);
			}
		
		$this->db->order_by('vr.booking_id'); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		//exit();
		return $query->result_array();
	}
	
	public function get_visitors($data)
	{
		/* $this->db->select("vr.*,vd.reference_of,vd.visiting_purpose");
		$this->db->from("sf_guesthouse_visitor_room as vr");
		
 		$this->db->join("sf_guesthouse_visitor_details as vd","vd.booking_id=vr.booking_id");
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('DATE(vd.proposed_in_date) >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('DATE(vd.proposed_in_date) <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		else if(isset($data['daywise']) && $data['daywise']!='')
		{
			$this->db->where('vd.proposed_in_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['daywise']))));
		}
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array(); */
		
		$this->db->select("vm.visitor_name,vm.gender,vm.mobile,vm.id_proof,vm.id_ref_no,vm.email,vd.reference_of,vd.visiting_purpose,vr.checkin_on,");
	
		$this->db->from("sf_guesthouse_visitor_master as vm");
		
		$this->db->join("sf_guesthouse_visitor_details as vd","vd.v_id=vm.v_id");
		$this->db->join("sf_guesthouse_visitor_room as vr","vr.booking_id=vd.booking_id and vr.current_status='BOOKING-DONE'");
		$this->db->join("sf_guesthouse_master as gm","gm.gh_id=vr.gh_id");
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('DATE(vd.proposed_in_date) >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('DATE(vd.proposed_in_date) <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		else if(isset($data['daywise']) && $data['daywise']!='')
		{
			$this->db->where('vd.proposed_in_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['daywise']))));
		}
		$this->db->group_by('vr.booking_id'); 
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}

	public function get_visitor_history($data)
	{
		$this->db->select("gm.guesthouse_name,vm.visitor_name,vm.gender,vm.mobile,vm.id_proof,vm.id_ref_no,vm.email,vd.current_status,vd.no_of_days,vd.no_of_person,vd.charges,vd.reference_of,vd.visiting_purpose,vr.checkin_out,vr.checkin_on,");
	
		$this->db->from("sf_guesthouse_visitor_master as vm");
		
		$this->db->join("sf_guesthouse_visitor_details as vd","vd.v_id=vm.v_id");
		$this->db->join("sf_guesthouse_visitor_room as vr","vr.booking_id=vd.booking_id");
		$this->db->join("sf_guesthouse_master as gm","gm.gh_id=vr.gh_id");
		if(isset($data['vname']) && $data['vname']!='')
		{
			$this->db->where('vr.visitor_name',$data['vname']);
		}
		if(isset($data['vmobile']) && $data['vmobile']!='')
		{
			$this->db->where('vr.mobile',$data['vmobile']);
		}
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$this->db->where('DATE(vd.proposed_in_date) >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('DATE(vd.proposed_in_date) <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		else if(isset($data['daywise']) && $data['daywise']!='')
		{
			$this->db->where('vd.proposed_in_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['daywise']))));
		}
		$this->db->group_by('vr.booking_id'); 
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_ghouse_history($data)
	{
		$cond="";
				
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$cond=" where DATE(vd.proposed_in_date) >= '".date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate'])))."'  and DATE(vd.proposed_out_date) <= '".date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate'])))."' ";
		}
		else if(isset($data['daywise']) && $data['daywise']!='')
		{
			$cond=" where DATE(vd.proposed_in_date) = '".date("Y-m-d", strtotime(str_replace('/', '-', $data['daywise'])))."' ";
		}
		
		if(isset($data['gtype']) && $data['gtype']!='')
		{
			if($data['gtype']!='All')
			$cond=" where g.gh_id='".$data['gtype']."'";
			else
				$cond=" where 1=1";
		}
		
		$sql="SELECT b.guesthouse_name,b.campus,COUNT(b.booking_id) AS visitor_total,SUM(b.charges)AS fees_paid FROM 
		( SELECT g.guesthouse_name,g.campus,a.booking_id,vd.charges,v.visitor_name,v.mobile FROM sf_guesthouse_master as g
		LEFT JOIN (SELECT vr.gh_id,vr.booking_id FROM sandipun_erp.sf_guesthouse_visitor_room as vr 
		WHERE vr.current_status!='CANCELLD' order by vr.gh_id,vr.booking_id
		) a 
		ON a.gh_id=g.gh_id AND g.is_active='Y'
		INNER JOIN sandipun_erp.sf_guesthouse_visitor_details as vd ON a.booking_id=vd.booking_id AND vd.current_status!='CANCELLD' 
		INNER JOIN sandipun_erp.sf_guesthouse_visitor_master v ON v.v_id=vd.v_id 
		$cond )b 
		GROUP BY b.guesthouse_name,b.campus";
        $query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	
	}
	
	public function get_visitor_rooms($data)
	{
		$cond="";
				
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
		{
			$cond=" where DATE(vd.proposed_in_date) >= '".date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate'])))."'  and DATE(vd.proposed_out_date) <= '".date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate'])))."' ";
		}
		else if(isset($data['daywise']) && $data['daywise']!='')
		{
			$cond=" where DATE(vd.proposed_in_date) = '".date("Y-m-d", strtotime(str_replace('/', '-', $data['daywise'])))."' ";
		}
		
		$sql="SELECT g.guesthouse_name,g.campus,a.booking_id,vd.charges,v.visitor_name,v.mobile,
		vd.no_of_days,vd.no_of_person,vd.reference_of,vd.visiting_purpose FROM sf_guesthouse_master as g
		LEFT JOIN (SELECT vr.gh_id,vr.booking_id FROM sandipun_erp.sf_guesthouse_visitor_room as vr 
		WHERE vr.current_status!='CANCELLD' order by vr.gh_id,vr.booking_id
		) a 
		ON a.gh_id=g.gh_id AND g.is_active='Y'
		INNER JOIN sandipun_erp.sf_guesthouse_visitor_details as vd ON a.booking_id=vd.booking_id AND vd.current_status!='CANCELLD'
		INNER JOIN sandipun_erp.sf_guesthouse_visitor_master v ON v.v_id=vd.v_id $cond group by a.booking_id";
        $query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}

	public function guesthouse_checkincheckout($booking_id)
	{
		$this->db->select("gm.guesthouse_name,gm.location,gm.doubel_bed,s.state_name,t.taluka_name,vm.v_id,vm.visitor_name,vm.gender,vm.mobile,vm.id_proof,vm.id_ref_no,vm.email,
		vd.booking_id,vd.current_status,vd.no_of_days,vd.proposed_in_date,vd.proposed_out_date,vd.no_of_person,vd.charges,
		vd.reference_of,vd.visiting_purpose,vd.balance,vd.pay_amount,
		vr.vr_id,vr.checkin_out,vr.checkin_on,vm.address,");
		$this->db->from("sf_guesthouse_visitor_master as vm");
		$this->db->join("sf_guesthouse_visitor_details as vd","vd.v_id=vm.v_id");
		$this->db->join("sf_guesthouse_visitor_room as vr","vr.booking_id=vd.booking_id");
		$this->db->join("sf_guesthouse_master as gm","gm.gh_id=vr.gh_id","left");
		$this->db->join("sandipun_ums.states as s","vm.state=s.state_id","left");
		$this->db->join("sandipun_ums.taluka_master as t","vm.city=t.taluka_id","left");		
		$this->db->where('vd.booking_id',$booking_id);
		$this->db->group_by('vm.v_id');
		$this->db->order_by('vd.booking_id','desc');
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function selected_guesthouse($booking_id)
	{
		$this->db->select("vr.*,gm.guesthouse_name,gm.gh_id");
		$this->db->from("sf_guesthouse_visitor_room as vr");
		$this->db->join("sf_guesthouse_master as gm","gm.gh_id=vr.gh_id","left");
		$this->db->where('vr.booking_id',$booking_id);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function guesthouse_count_details($data)
	{
		$this->db->select("count(vr.gh_id) as bed_count,vd.booking_id,vr.gh_id,vd.no_of_person,g.guesthouse_name,g.bed_available,g.bed_capacity,");
		$this->db->from("sf_guesthouse_visitor_details as vd");
		$this->db->join("sf_guesthouse_visitor_room as vr","vr.booking_id=vd.booking_id");
		$this->db->join("sf_guesthouse_master as g","g.gh_id=vr.gh_id");
		$this->db->where('vd.booking_id',$data['visitor_id']);
		$this->db->group_by('g.gh_id');
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function update_checkin($id,$data)
	{
			//$candet['remark']=$data['remarks'];
			$candet['checkin_on']= date('Y-m-d h:i:s');
			$candet['checkin_done_on']= date('Y-m-d h:i:s');
			$candet['checkin_done_by']= $_SESSION['uid'];
			$candet['modified_by']= $_SESSION['uid'];
			$candet['modified_on']= date('Y-m-d h:i:s');
			$candet['current_status']='CHECK-IN';
			
			$this->db->where('booking_id', $id);
			$this->db->update('sf_guesthouse_visitor_room', $candet);
			
			$status_update['mode_of_payment']= $data['mode_of_payment'];
			$status_update['pay_amount']= $data['pay_amount'];
			$status_update['balance']= $data['balance'];
			$status_update['receipt_no']= $data['receipt_no'];
			$status_update['receipt_date']=$data['receipt_date'];
			$status_update['Bank_Name']=$data['Bank_Name'];
			$status_update['Bank_Branch']=$data['Bank_Branch'];
			$status_update['Remark']=$data['Remark'];
			$status_update['Deposite_bank']=$data['Deposite_bank'];
			
			
			$status_update['modified_on']= date('Y-m-d h:i:s');
			$status_update['modified_by']= $_SESSION['uid'];
			$status_update['current_status']='CHECK-IN';
			$this->db->where('booking_id', $id);
			$this->db->update('sf_guesthouse_visitor_details', $status_update);
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
	
	public function update_checkout($id,$data)
	{
		$candet['checkin_out']= date('Y-m-d h:i:s');
		$candet['checkout_done_on']= date('Y-m-d h:i:s');
		$candet['checkout_done_by']= $_SESSION['uid'];
		$candet['modified_by']= $_SESSION['uid'];
		$candet['modified_on']= date('Y-m-d h:i:s');
		$candet['current_status']='CHECK-OUT';
		
		$this->db->where('booking_id', $id);
		$this->db->update('sf_guesthouse_visitor_room', $candet);
		
		$status_update['pay_amount']= $data['pay_amount'];
	    $status_update['balance']= $data['balance'];
		
		 $status_update['modified_on']= date('Y-m-d h:i:s');
		$status_update['modified_by']= $_SESSION['uid'];
		$status_update['current_status']='CHECK-OUT';
		$this->db->where('booking_id', $id);
		$this->db->update('sf_guesthouse_visitor_details', $status_update); 
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
	
	public function cancellation($data)
	{
		$candet['modified_by']= $_SESSION['uid'];
		$candet['modified_on']= date('Y-m-d h:i:s');
		$candet['current_status']='CANCELLED';
		
		$this->db->where('booking_id', $data['visitor_id']);
		$this->db->update('sf_guesthouse_visitor_room', $candet);
		
		 $status_update['modified_on']= date('Y-m-d h:i:s');
		$status_update['modified_by']= $_SESSION['uid'];
		$status_update['current_status']='CANCELLED';
		$this->db->where('booking_id', $data['visitor_id']);
		$this->db->update('sf_guesthouse_visitor_details', $status_update);
		return $this->db->affected_rows();			
	}
	
	public function visitor_details($id)
	{
		$this->db->select("vm.*,vd.booking_id,vd.booking_typ,vd.current_status,vd.no_of_days,vd.proposed_in_date,vd.proposed_out_date,vd.no_of_person,vd.charges,vd.reference_of,vd.visiting_purpose,vd.is_chargeble,");
		$this->db->from("sf_guesthouse_visitor_details as vd");
		$this->db->join("sf_guesthouse_visitor_master as vm","vd.v_id=vm.v_id");
		//$this->db->join("district_name as dm","vd.district=dm.district_id",'left');
		//$this->db->join("sf_guesthouse_visitor_master as vm","vd.v_id=vm.v_id");
		$this->db->where('vd.booking_id', $id);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function visitor_room_details($data)
	{
		$this->db->select("gm.*,vr.vr_id,vr.visitor_name,vr.mobile,vr.bed_no");
		$this->db->from("sf_guesthouse_visitor_room as vr");
		$this->db->join("sf_guesthouse_master as gm","vr.gh_id=gm.gh_id","left");
		$this->db->where('vr.booking_id', $data['visitor_id']);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	//kajal
	function get_dates($Date1,$Date2){
        

// Declare two dates 
//$Date1 = '01-10-2010'; 
//$Date2 = '05-10-2010'; 

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
	function get_gesthouse_booking_list_bydate($gh,$dt){
		$sql="SELECT  vd.proposed_in_date,vd.`proposed_out_date`,vd.`no_of_days`,vd.`no_of_person`,vr.`gh_id`,vr.`booking_id` FROM  `sf_guesthouse_visitor_details` AS vd             
            INNER JOIN `sf_guesthouse_visitor_room` vr ON vr.`booking_id`=vd.`booking_id`       
            WHERE (vd.current_status!='CANCELLED' OR vd.current_status!='CHECK-OUT' ) and vr.gh_id='".$gh."' and 
               ('".date('Y-m-d',strtotime($dt))."' BETWEEN proposed_in_date AND proposed_out_date)
     
			  GROUP BY vd.`booking_id`   ";
			   $query=$this->db->query($sql);
         $bl=$query->result_array();
		 $row = $query->row();
//$b=[];
if (isset($row))

{
foreach($bl as $vl){
	 $sql ="select bed_no,current_status from sf_guesthouse_visitor_room where booking_id='".$vl['booking_id']."' and gh_id='".$gh."'";
	 $query=$this->db->query($sql);
         $rm=$query->result_array();
         $i=1;
		 foreach($rm as $val){
			// $b[$val['current_status']][]=$val['bed_no'];
//$b[]=$val['current_status'];
			//$b[$val['current_status']][]=$val['bed_no'];
$b[$val['current_status'].$i."_".$vl['booking_id']]=$val['bed_no'];
$i++;
		 }
	}
}
		
		return $b;
	}


	////////availability of guest house
		function get_gesthouse_booking_list_bydate_avalability($gh,$fd,$td){

		 $sql="SELECT  vd.proposed_in_date,vd.`proposed_out_date`,vd.`no_of_days`,vd.`no_of_person`,vr.`gh_id`,vr.`booking_id`,vd.v_id FROM  `sf_guesthouse_visitor_details` AS vd             
            INNER JOIN `sf_guesthouse_visitor_room` vr ON vr.`booking_id`=vd.`booking_id`       
            WHERE (vd.current_status!='CANCELLED' OR vd.current_status!='CHECK-OUT' ) and vr.gh_id='".$gh."' and 
             (Date(vd.proposed_out_date) >='".date('Y-m-d h:i:s',strtotime($fd))."' AND DATE(vd.proposed_in_date) <='".date('Y-m-d h:i:s',strtotime($td))."')

     
			  GROUP BY vd.`booking_id`   ";
			   $query=$this->db->query($sql);
         $bl=$query->result_array();
       // echo $this->db->last_query();
        /*exit();*/
		 $row = $query->row();
//$b=[];
if (isset($row))

{
foreach($bl as $vl){
	 $sql ="select bed_no,current_status from sf_guesthouse_visitor_room where booking_id='".$vl['booking_id']."' and gh_id='".$gh."'";
	 $query=$this->db->query($sql);
         $rm=$query->result_array();
         $i=1;
		 foreach($rm as $k=>$val){
			// $b[$val['current_status']][]=$val['bed_no'];
//$b[]=$val['current_status'];
			$b[$val['current_status'].$i."_".$vl['booking_id']]=$val['bed_no'];
$i++;
		 }
	}
}
		
		return $b;
	}

	function get_guesthouse_details_rooms($arr){
	$sql1="SELECT  vd.proposed_in_date,vd.`proposed_out_date`,vd.`no_of_days`,vd.`no_of_person`,vr.`gh_id`,vr.`booking_id` FROM  `sf_guesthouse_visitor_details` AS vd             
            INNER JOIN sf_guesthouse_visitor_room vr ON vr.booking_id=vd.booking_id
            WHERE (vd.current_status!='CANCELLED' OR vd.current_status!='CHECK-OUT' ) and vr.gh_id='".$arr['gh_id']."' and 
               ( proposed_in_date BETWEEN '".date('Y-m-d',strtotime($arr['fd']))."'  AND '".date('Y-m-d',strtotime($arr['td']))."'  AND TIME(vd.proposed_in_date) >= '".date('H:i:s',strtotime($arr['fd']))."')
              OR  (proposed_out_date  BETWEEN '".date('Y-m-d',strtotime($arr['fd']))."' AND '".date('Y-m-d',strtotime($arr['td']))."'  AND TIME(vd.proposed_out_date) <= '".date('H:i:s',strtotime($arr['td']))."')
			  GROUP BY vd.`booking_id`   ";
			  $sql="SELECT  vd.proposed_in_date,vd.`proposed_out_date`,vd.`no_of_days`,vd.`no_of_person`,vr.`gh_id`,vr.`booking_id` FROM  `sf_guesthouse_visitor_details` AS vd             
            INNER JOIN sf_guesthouse_visitor_room vr ON vr.booking_id=vd.booking_id
            WHERE (vd.current_status!='CANCELLED' OR vd.current_status!='CHECK-OUT' ) and vr.gh_id='".$arr['gh_id']."' and 
               (DATE(proposed_out_date)  BETWEEN '".date('Y-m-d',strtotime($arr['fd']))."' AND '".date('Y-m-d',strtotime($arr['td']))."'  AND TIME(vd.proposed_out_date) >= '".date('H:i:s',strtotime($arr['fd']))."')
			  GROUP BY vd.`booking_id`   ";
			   $query=$this->db->query($sql);
         $bl=$query->result_array();
		 $row = $query->row();

if (isset($row))
{
	foreach($bl as $vl){
	$sql ="select bed_no from sf_guesthouse_visitor_room where booking_id='".$vl['booking_id']."' and gh_id='".$arr['gh_id']."'";
	 $query=$this->db->query($sql);
         $rm=$query->result_array();
		 foreach($rm as $val){
			 $b[]=$val['bed_no'];
		 }
	}
		 
}
      //return implode(",",$b);           
return $b;	  
}
function get_availabel_gh_hostal($arr){

$exp = explode("_",$this->session->userdata("name"));
   //	echo $exp[1];
		     if($exp[1]=="sijoul")
        {              
              $cp = " and g.campus= 'SIJOUL'";
        }
        
            if($exp[1]=="nashik")
        {
        	$cp = " and g.campus= 'NASHIK'";       	
           
        }
if($arr['host_typ']!=''){
	if($arr['host_typ']=='t'){
$ht = ' and g.location="T"';
}else{
	$ht = ' and g.location !="T"';
}
}
if($arr['nop'] !=''){
	//$n = '  HAVING new_bal >= "'.$arr['nop'].'" ';
}
if($arr['frmdt'] !='' && $arr['todt']!=''){
	$fdt = " and ( vd.proposed_in_date  BETWEEN '".date('Y-m-d',strtotime($arr['frmdt']))."'  AND '".date('Y-m-d',strtotime($arr['frmdt']))."' AND TIME(vd.proposed_in_date) >= '".date('H:i:s',strtotime($arr['frmdt']))."' )
              OR  (proposed_out_date  BETWEEN '".date('Y-m-d',strtotime($arr['todt']))."' AND '".date('Y-m-d',strtotime($arr['todt']))."' AND TIME(vd.proposed_out_date) <= '".date('H:i:s',strtotime($arr['todt']))."' )";
}

	echo $sql="SELECT g.*,v.book_cnt,(g.`bed_capacity` - CASE WHEN v.book_cnt IS NULL THEN 0 ELSE v.book_cnt END) AS NEW_BAL FROM sf_guesthouse_master AS g 
		LEFT JOIN (
		SELECT vr.gh_id,COUNT(vr.`booking_id`) AS book_cnt
		FROM sf_guesthouse_visitor_details AS vd  
		LEFT JOIN  sf_guesthouse_visitor_room AS vr ON vd.booking_id=vr.booking_id 
		WHERE 1 $fdt		
               GROUP BY vr.gh_id 
		) v ON v.gh_id=g.gh_id WHERE 1 $cp $ht $n";

 $query=$this->db->query($sql);
       return  $rm=$query->result_array();
}

function get_report_list($data){
$this->db->select("gm.*,vr.visitor_name,vr.mobile as vis_mobile,vr.bed_no,vm.visitor_name as booking_name,vm.gender,
vm.id_proof,vm.id_ref_no,vm.email,vd.reference_of,vd.booking_id,vd.visiting_purpose,vd.proposed_in_date,vd.proposed_out_date,
vd.no_of_days,vd.no_of_person,vd.charges,vr.checkin_on,vr.current_status,ch.mode_of_payment,ch.receipt_no,ch.challan_No");
	
		$this->db->from("sf_guesthouse_visitor_room as vr");
		
		$this->db->join("sf_guesthouse_visitor_details as vd","vr.booking_id=vd.booking_id ");
		
		$this->db->join("sf_guesthouse_visitor_master as vm","vm.v_id=vd.v_id");
		$this->db->join("sf_guesthouse_master as gm","vr.gh_id=gm.gh_id");
		$this->db->join("guesthouse_challan as ch","ch.Booking_id=vd.booking_id","left");
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='' && $data['selectby']=='Between')
		{
			$this->db->where('DATE(vd.proposed_in_date) >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('DATE(vd.proposed_in_date) <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		else if(isset($data['daywise']) && $data['daywise']!='' && $data['selectby']=='Datewise')
		{
			$this->db->where('DATE(vd.proposed_in_date)',  date("Y-m-d", strtotime(str_replace('/', '-', $data['daywise']))));
		}
		if(isset($data['campus']) && $data['campus']!=''){
			$this->db->where('gm.campus',$data['campus']);
			}
		
		$this->db->order_by('vr.booking_id'); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		//exit();
		return $query->result_array();

}
function get_campus_cnt($data){
	
   $this->db->select("COUNT(vd.booking_id)AS cnt");
	
		$this->db->from("sf_guesthouse_visitor_room as vr");
		
		$this->db->join("sf_guesthouse_visitor_details as vd","vr.booking_id=vd.booking_id ");
		
	
		$this->db->join("sf_guesthouse_master as gm","vr.gh_id=gm.gh_id");
		
		if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='' && $data['selectby']=='Between')
		{
			$this->db->where('DATE(vd.proposed_in_date) >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
			$this->db->where('DATE(vd.proposed_in_date) <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
		}
		else if(isset($data['daywise']) && $data['daywise']!='' && $data['selectby']=='Datewise')
		{
			$this->db->where('DATE(vd.proposed_in_date)',  date("Y-m-d", strtotime(str_replace('/', '-', $data['daywise']))));
		}
		if(isset($data['campus']) && $data['campus']!=''){
			$this->db->where('gm.campus',$data['campus']);
			}

		if(isset($data['hos_typ']) && $data['hos_typ']!=''){
			if($data['hos_typ']=='T'){
$this->db->where('gm.location ','T');
			}else{
			$this->db->where('gm.location !=','T');
		}
			}

			if(isset($data['curr_sts']) && $data['curr_sts']!=''){
$this->db->where('vd.current_status',$data['curr_sts']);
			}
			
		$this->db->group_by('vr.booking_id'); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		//exit();
		//$query = $query->result_array();
		return $query->num_rows();


}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
 public function Insert_challan($data)
	{
		//$DB1 = $this->load->database('umsdb', TRUE);
		$this->db->insert("guesthouse_challan", $data); 
		//echo $this->last_query();exit();
		$last_inserted_id=$this->db->insert_id();                
		return $last_inserted_id;
	}
	  public function update_challan($last_inserted_id,$challan_no){
   // $DB1 = $this->load->database('umsdb', TRUE);
   
		$this->db->where('gch_id', $last_inserted_id);
		
		$this->db->update('guesthouse_challan', $challan_no);
		//echo $this->db->last_query();exit();
		return $this->db->affected_rows();
    
    }
	
	public function fees_challan_list_byid($id){
		$sql="SELECT 
		sandipun_erp.bank_master.bank_id, 
		sandipun_erp.bank_master.bank_name, 
		sandipun_erp.bank_master.account_name,
		sandipun_erp.bank_master.bank_account_no as account_no,
		sandipun_erp.bank_master.clinet_id,
		sandipun_erp.bank_master.branch_name,
		sandipun_erp.bank_master.bank_code,
		sandipun_ums.bank_master.bank_id as ubank_id,
		sandipun_ums.bank_master.bank_name as ubank_name,
		gc.* FROM guesthouse_challan as gc
		
		LEFT join sandipun_erp.bank_master ON sandipun_erp.bank_master.bank_id = gc.Deposite_bank
		LEFT join sandipun_ums.bank_master ON sandipun_ums.bank_master.bank_id = gc.Bank_Name
		 WHERE Booking_id='$id'";
		 $query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
}
?>