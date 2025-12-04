<?php
class Transport_model extends CI_Model 
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
		$sql="SELECT * from states order by state_name";
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	
	public function getcampusname()
	{
		$sql="select * From sf_facility_category where faci_id=2";// 1 for Transport facility
		
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
	
	public function add_vendor_submit($data)
	{
		$this->db->insert("sf_transport_vendor", $data); 
		$last_inserted_id=$this->db->insert_id();                
		return $last_inserted_id;
	}
	
	public function get_vendor_details($id)
	{
		$this->db->select("sf_transport_vendor.*,");
		$this->db->from("sf_transport_vendor");
		if($id!='')
		{
			$this->db->where('vendor_id', $id);
		}
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			$this->db->where('campus', 'SIJOUL');
        }
        else if($exp[1]=="nashik")
        {
			$this->db->where('campus', 'NASHIK');			
        }
		
		$this->db->where('is_active', 'Y');
		$this->db->order_by("sf_transport_vendor.campus,sf_transport_vendor.vendor_id", "desc");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_bus_boarding_details($data)
	{
		//select sf_transport_route_details .*, sf_transport_boarding_details.boarding_point,sf_transport_boarding_details.distance_from_campus,sf_transport_boarding_details.pickup_timing,sf_transport_boarding_details.drop_timing from sf_transport_boarding_details left join sf_transport_route_details on sf_transport_boarding_details.board_id = sf_transport_route_details.board_id  and sf_transport_route_details.route_id=1 where sf_transport_boarding_details.campus='NASHIK'
		
		
		$this->db->select("sf_transport_route.route_id,sf_transport_route.route_name,sf_transport_route.route_code,sf_transport_route.campus,sf_transport_route_details.is_active,sf_transport_route_details.sequence_no,sf_transport_route_details.details_id,sf_transport_route_details.board_id,sf_transport_boarding_details.boarding_point,sf_transport_boarding_details.distance_from_campus,sf_transport_boarding_details.board_id,sf_transport_boarding_details.drop_timing,");
		$this->db->from("sf_transport_boarding_details");
		$this->db->join("sf_transport_route_details", "sf_transport_boarding_details.board_id = sf_transport_route_details.board_id and sf_transport_route_details.route_id='".$data['rid']."' and sf_transport_boarding_details.is_active='Y' and sf_transport_route_details.is_active='Y'",'left');
		$this->db->join("sf_transport_route", "sf_transport_route.route_id = sf_transport_route_details.route_id",'left');
		if(isset($data['campus']) && $data['campus']!='' )
		{
			$this->db->where('sf_transport_boarding_details.campus', $data['campus']);
		}
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			$this->db->where('sf_transport_boarding_details.campus', 'SIJOUL');
        }
        else if($exp[1]=="nashik")
        {
			$this->db->where('sf_transport_boarding_details.campus', 'NASHIK');			
        }
		$this->db->order_by("sf_transport_route_details.sequence_no");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_bus_details($id)
	{
		$this->db->select("bus.*,v.vendor_id,v.vendor_name,v.campus");
		$this->db->from("sf_transport_buses as bus");
		$this->db->join("sf_transport_vendor as v", "v.vendor_id = bus.vendor_id");
		if($id!='')
		{
			$this->db->where('bus.bus_id', $id);
		}
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul" || (isset($_POST['campus']) && $_POST['campus']=='SIJOUL' ))
        {
			$this->db->where('v.campus', 'SIJOUL');
        }
        else if($exp[1]=="nashik" || (isset($_POST['campus']) && $_POST['campus']=='NASHIK' ))
        {
			$this->db->where('v.campus', 'NASHIK');			
        }
		
		if(isset($_POST['campus']) && $_POST['campus']=='NASHIK' )
		{
			$this->db->where('v.campus', 'NASHIK');
		}
		$this->db->where('bus.is_active', 'Y');
		$this->db->order_by("bus.bus_id", "desc");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function edit_vendor_submit($id,$data)
	{
		$this->db->where('vendor_id', $id);
		$this->db->update("sf_transport_vendor", $data);
		return $this->db->affected_rows();
	}
	public function add_route_boarding_mapping_submit($data)
	{
		//print_r($data);exit;
		//if(!empty($data)){
		$this->db->insert_batch('sf_transport_route_details', $data);
		//echo $this->db->last_query();exit;
		$last_inserted_id=$this->db->insert_id();
		return $last_inserted_id;//}else{
			return 1;
		//}
	}
	public function edit_route_submit($data)
	{
		//print_r($data); 
		//$count=count($data);
		//exit;
		/*for($i=0;$i<$count;$count--){
		$this->db->where('details_id', $data[$i]['details_id']);
		$this->db->update("sf_transport_vendor", $data);
		}*/
		//if(!empty($data)){
		$reslut=$this->db->update_batch('sf_transport_route_details', $data,'details_id');
		//}else{
		//$reslut==1;	
		//}
		// $this->db->last_query();
				//print_r($reslut); 

	//exit;
	   return $reslut;//$this->db->get('sf_transport_route_details')->row()->id;//$this->db->affected_rows();
	}
	
	/* 
	function delete_boardingpoint($data)
	{
		$del['is_active']='N';
		$where=array("details_id"=>$data['feeid']);
		$this->db->where($where); 
		$this->db->update('sf_fees_details', $del);
		return 'Y';
	} */ 
	
	public function get_boardingmaster_details_bynashik($campus)
	{
		$this->db->select("sf_transport_boarding_details.*,");
		$this->db->from("sf_transport_boarding_details");
		
		//$exp = explode("_",$_SESSION['name']);
		//if($exp[1]=="sijoul")
       // {
			$this->db->where('campus',$campus);
      //  }
       // else if($exp[1]=="nashik")
        //{
		//	$this->db->where('campus', 'NASHIK');			
       // }
		$this->db->order_by("sf_transport_boarding_details.boarding_point");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_route_details_bynashik($campus)
	{
		$this->db->select("sf_transport_route.*,");
		$this->db->from("sf_transport_route");
		//if($campus!='')
		{
			$this->db->where('campus', $campus);
		}
		
		$this->db->order_by("sf_transport_route.route_name", "desc");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function add_bus_submit($data)
	{
		//var_dump($data);exit();
		$this->db->insert("sf_transport_buses", $data); 
		$last_inserted_id=$this->db->insert_id();                
		return $last_inserted_id;
	}
	
	public function edit_bus_submit($id,$data)
	{
		$this->db->where('bus_id', $id);
		$this->db->update("sf_transport_buses", $data);
		return $this->db->affected_rows();
	}
	
	public function edit_driver_submit($id,$data)
	{
		$this->db->where('driver_id', $id);
		$this->db->update("sf_transport_driver_details", $data);
		//echo $this->db->last_query();exit();
		return $this->db->affected_rows();
	}
	
	public function edit_boarding_submit($id,$data)
	{
		$this->db->where('board_id', $id);
		$this->db->update("sf_transport_boarding_details", $data);
		//echo $this->db->last_query();exit();
		return $this->db->affected_rows();
	}
	
	public function add_driver_submit($data)
	{
		$this->db->insert("sf_transport_driver_details", $data); 
		$last_inserted_id=$this->db->insert_id();                
		return $last_inserted_id;
	}
	
	public function get_driver_details($id)
	{
		$this->db->select("sf_transport_driver_details.*,sf_transport_route.route_name,sf_transport_route.route_id,sf_transport_route.route_code,sf_transport_vendor.vendor_id,sf_transport_vendor.vendor_name,sf_transport_buses.bus_no,sf_transport_driver_bus.is_active");
		$this->db->from("sf_transport_driver_details");
		$this->db->join("sf_transport_vendor", "sf_transport_vendor.vendor_id = sf_transport_driver_details.vendor_id",'left');
		$this->db->join("sf_transport_driver_bus", "sf_transport_driver_bus.is_active='Y' and sf_transport_driver_bus.driver_id = sf_transport_driver_details.driver_id",'left');
		$this->db->join("sf_transport_route", "sf_transport_route.route_id = sf_transport_driver_bus.route_id",'left');
		$this->db->join("sf_transport_buses", "sf_transport_buses.bus_id = sf_transport_driver_bus.bus_id",'left');
		if($id!='')
		{
			$this->db->where('sf_transport_driver_details.driver_id', $id);
		}
		$this->db->where('sf_transport_driver_details.is_active', 'Y');
		$this->db->order_by("sf_transport_driver_details.driver_id", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_drivermaster_details($id)
	{
		$this->db->select("sf_transport_driver_details.*,sf_transport_vendor.vendor_id,sf_transport_vendor.vendor_name,");
		$this->db->from("sf_transport_driver_details");
		$this->db->join("sf_transport_vendor", "sf_transport_vendor.vendor_id = sf_transport_driver_details.vendor_id",'left');
		
		if($id!='')
		{
			$this->db->where('sf_transport_driver_details.driver_id', $id);
		}
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			$this->db->where('sf_transport_driver_details.campus', 'SIJOUL');
        }
        else if($exp[1]=="nashik")
        {
			$this->db->where('sf_transport_driver_details.campus', 'NASHIK');			
        }
		$this->db->where('sf_transport_driver_details.is_active', 'Y');
		$this->db->order_by("sf_transport_driver_details.driver_id", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_drivers_details($data)
	{
		$this->db->select("sf_transport_driver_details.*,sf_transport_vendor.vendor_id,sf_transport_vendor.vendor_name,");
		$this->db->from("sf_transport_driver_details");
		$this->db->join("sf_transport_vendor", "sf_transport_vendor.vendor_id = sf_transport_driver_details.vendor_id",'left');
		
		if(isset($data['campus']) && $data['campus']!='')
		{
			$this->db->where('sf_transport_driver_details.campus', $data['campus']);
		}
		
		if(isset($data['vendor']) && $data['vendor']!='')
		{
			$this->db->where('sf_transport_driver_details.vendor_id', $data['vendor']);
		}
		
		$this->db->where('sf_transport_driver_details.is_active', 'Y');
		$this->db->order_by("sf_transport_driver_details.driver_id", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	function t_driver_data($data)
	{//var_dump($data);exit();
		$temp='';
		if(!empty($_POST['chk_stud'])  && isset($_POST['chk_stud']) ){
			for($i = 0; $i < count($_POST['chk_stud']); $i++){
				$temp.=str_replace("_","/", ($_POST['chk_stud'][$i].','));
			}
			$temp=substr($temp, 0, -1);
		}
		
		$this->db->select("sf_transport_driver_details.*,sf_transport_vendor.vendor_id,sf_transport_vendor.vendor_name,");
		$this->db->from("sf_transport_driver_details");
		$this->db->join("sf_transport_vendor", "sf_transport_vendor.vendor_id = sf_transport_driver_details.vendor_id",'left');
		if(isset($data['arg_campus']) && $data['arg_campus']!='')
		{
			$this->db->where('sf_transport_driver_details.campus', $data['arg_campus']);
		}
		
		if(isset($data['arg_vendor']) && $data['arg_vendor']!='')
		{
			$this->db->where('sf_transport_driver_details.vendor_id', $data['arg_vendor']);
		}
		if(isset($data['campus']) && $data['campus']!='')
		{
			$this->db->where('sf_transport_driver_details.campus', $data['campus']);
		}
		
		if(isset($data['vendor']) && $data['vendor']!='')
		{
			$this->db->where('sf_transport_driver_details.vendor_id', $data['vendor']);
		}
		if($temp!=="" && strlen($temp)>0)
		{
		$this->db->where("sf_transport_driver_details.driver_id in(".$temp.")",NULL, false);
		}
		
		$this->db->where('sf_transport_driver_details.is_active', 'Y');
		$this->db->order_by("sf_transport_driver_details.driver_id", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_all_vendorbuses_list()
	{
		//SELECT * FROM `sf_transport_vendor_bus` WHERE `vendor_id`=1
		$this->db->select("sf_transport_vendor_bus.*,");
		$this->db->from("sf_transport_vendor_bus");
		$this->db->where('is_active', 'Y');
		$this->db->order_by("sf_transport_vendor_bus.bus_no", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_buses_list_notin_vendor($buslist)
	{
		$this->db->distinct();
		$this->db->select("sf_transport_buses.bus_id,sf_transport_buses.bus_no");
		$this->db->from("sf_transport_buses");
		$this->db->where_not_in('sf_transport_buses.bus_id',$buslist);
		$this->db->where('is_active', 'Y');
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_allbuses_driverbusesmap_list()
	{
		//SELECT * FROM `sf_transport_vendor_bus` WHERE `vendor_id`=1
		$this->db->select("sf_transport_driver_bus.bus_id,");
		$this->db->from("sf_transport_driver_bus");
		$this->db->where('is_active', 'Y');
		$this->db->order_by("sf_transport_driver_bus.driver_bus_id", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_buses_list_notin_driver_bus_map($buslist,$vendor_id)
	{
		$this->db->distinct();
		$this->db->select("sf_transport_vendor_bus.bus_id,sf_transport_vendor_bus.bus_no");
		$this->db->from("sf_transport_vendor_bus");
		$this->db->where_not_in('sf_transport_vendor_bus.bus_id',$buslist);
		$this->db->where('is_active', 'Y');
		$this->db->where('vendor_id',$vendor_id);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_alldriver_driverbusesmap_list()
	{
		//SELECT * FROM `sf_transport_vendor_bus` WHERE `vendor_id`=1
		$this->db->select("sf_transport_driver_bus.driver_id,");
		$this->db->from("sf_transport_driver_bus");
		$this->db->where('is_active', 'Y');
		$this->db->order_by("sf_transport_driver_bus.driver_bus_id", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_drivers_list_notin_driver_bus_map($driverlist,$data)
	{
		$this->db->distinct();
		$this->db->select("sf_transport_driver_details.driver_id,sf_transport_driver_details.driver_name");
		$this->db->from("sf_transport_driver_details");
		$this->db->where_not_in('sf_transport_driver_details.driver_id',$driverlist);
		$this->db->where('is_active', 'Y');
		$this->db->where('vendor_id',$data['vendor']);
		if(isset($data['campus']) && $data['campus']!='')
		{$this->db->where('campus',$data['campus']);}
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_allbuses_in_allocationlist($id='')
	{
		//SELECT * FROM `sf_transport_vendor_bus` WHERE `vendor_id`=1
		$this->db->select("tbd.*,tr.route_name,tdd.driver_name,tdd.mobile,tdd.driving_license_no,v.vendor_name");
		$this->db->from("sf_transport_bus_details as tbd");
		$this->db->join("sf_transport_route as tr", "tr.route_id = tbd.route_id");
		$this->db->join("sf_transport_driver_details as tdd", "tdd.driver_id = tbd.driver_id");
		$this->db->join("sf_transport_buses as tb","tb.bus_id=tbd.bus_id");
		$this->db->join("sf_transport_vendor as v", "v.vendor_id = tb.vendor_id");
		if(isset($id) && $id!='')
			$this->db->where('tbd.driver_bus_id', $id);
		
		$this->db->where('tbd.is_active', 'Y');
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			$this->db->where('tdd.campus', 'SIJOUL');
			$this->db->where('tr.campus', 'SIJOUL');
			$this->db->where('v.campus', 'SIJOUL');
        }
        else if($exp[1]=="nashik")
        {
			$this->db->where('tdd.campus', 'NASHIK');
$this->db->where('tr.campus', 'NASHIK');
$this->db->where('v.campus', 'NASHIK');			
        }
		$this->db->order_by("tbd.bus_no", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_bus_list_notin_allocation($buslist,$data)
	{
		$this->db->distinct();
		$this->db->select("tb.*");
		$this->db->from("sf_transport_buses as tb");
		$this->db->join("sf_transport_vendor as v", "v.vendor_id = tb.vendor_id");
		$this->db->where_not_in('tb.bus_id',$buslist);
		$this->db->where('tb.is_active', 'Y');
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			$this->db->where('v.campus', 'SIJOUL');
        }
        else if($exp[1]=="nashik")
        {
			$this->db->where('v.campus', 'NASHIK');			
        }
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_driver_list_notin_allocation($driverlist,$data)
	{
		$this->db->distinct();
		$this->db->select("*");
		$this->db->from("sf_transport_driver_details");
		$this->db->where_not_in('driver_id',$driverlist);
		$this->db->where('is_active', 'Y');
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			$this->db->where('campus', 'SIJOUL');
        }
        else if($exp[1]=="nashik")
        {
			$this->db->where('campus', 'NASHIK');			
        }
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_vendor_bus_details($data)
	{
		$this->db->select("sf_transport_bus_details.*,sf_transport_vendor.campus,sf_transport_vendor.vendor_name,sf_transport_buses.capacity");
		$this->db->from("sf_transport_bus_details");
		$this->db->join("sf_transport_buses", "sf_transport_buses.bus_id = sf_transport_bus_details.bus_id");
		$this->db->join("sf_transport_vendor", "sf_transport_vendor.vendor_id = sf_transport_buses.vendor_id");
		
		if(isset($data['id']) && $data['id']!='')
		{
			$this->db->where('sf_transport_buses.vendor_id', $data['id']);
		}
		$this->db->where('sf_transport_bus_details.is_active','Y');
		$this->db->order_by("sf_transport_vendor.campus,sf_transport_buses.vendor_id,sf_transport_buses.capacity", "desc");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function add_vendor_bus_submit($data)
	{
		$this->db->insert_batch('sf_transport_vendor_bus', $data);
		$last_inserted_id=$this->db->insert_id();
		return $last_inserted_id;
	}
	
	public function driver_bus_mapping_submit($data)
	{
		$this->db->insert('sf_transport_driver_bus', $data);
		$last_inserted_id=$this->db->insert_id();
		return $last_inserted_id;
	}
	
	public function bus_allocation_submit($data)
	{
		$this->db->insert('sf_transport_bus_details', $data);
		//echo $this->db->last_query();exit();
		$last_inserted_id=$this->db->insert_id();
		return $last_inserted_id;
	}
	
	public function edit_bus_allocation_submit($data,$id)
	{
		$this->db->where('driver_bus_id', $id);
		$this->db->update('sf_transport_bus_details', $data);
		return $this->db->affected_rows();
	}
	
	public function getvendorsbycampus($campus)
	{
		$this->db->select("vendor_id,vendor_name");
		$this->db->from("sf_transport_vendor");
        $this->db->where('campus', $campus);
		$this->db->where('is_active', 'Y');
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
        return $query->result_array();
	}
	
	public function getroutesbycampus($campus)
	{
		$this->db->select("route_id,route_name");
		$this->db->from("sf_transport_route");
        $this->db->where('campus', $campus);
		$this->db->where('is_active', 'Y');
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
        return $query->result_array();
	}
	
	public function add_route_submit($data)
	{
		$this->db->insert('sf_transport_route', $data);
		$last_inserted_id=$this->db->insert_id();
		return $last_inserted_id;
	}
	
	public function add_boarding_submit($data)
	{
		$this->db->insert('sf_transport_boarding_details', $data);
		$last_inserted_id=$this->db->insert_id();
		return $last_inserted_id;
	}
	
	public function get_route_details($campus)
	{
		$this->db->select("sf_transport_route.*,");
		$this->db->from("sf_transport_route");
		if($campus!='')
		{
			$this->db->where('campus', $campus);
		}
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			$this->db->where('campus', 'SIJOUL');
        }
        else if($exp[1]=="nashik")
        {
			$this->db->where('campus', 'NASHIK');			
        }
		$this->db->order_by("sf_transport_route.route_name", "desc");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_allroute_routeboardingmap_list($data)
	{
		$this->db->distinct();
		$this->db->select("sf_transport_route_details.route_id");
		$this->db->from("sf_transport_route_details");
		/* $this->db->where_not_in('sf_transport_buses.bus_id',$buslist);
		$this->db->where('is_active', 'Y'); */
		$this->db->where('campus',$data);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_routes_list_notin_route_boarding_map($routelist,$data)
	{
		$this->db->select("sf_transport_route.route_id,sf_transport_route.route_name");
		$this->db->from("sf_transport_route");
		$this->db->where_not_in('sf_transport_route.route_id',$routelist);
		$this->db->where('campus',$data['campus']);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_routemaster_details($id='')
	{
		/* select r.route_name,r.route_code,r.campus,rd.board_id,b.boarding_point from sf_transport_route as r 
		left join sf_transport_route_details as rd on rd.route_id=r.route_id
		join sf_transport_boarding_details as b on b.board_id =rd.board_id  */
		$this->db->select("r.route_id,r.route_name,r.route_code,r.campus");
		$this->db->from("sf_transport_route as r");
		
		if($id!='')
		{
			$this->db->where('r.route_id', $id);
		}
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			$this->db->where('r.campus', 'SIJOUL');
        }
        else if($exp[1]=="nashik")
        {
			$this->db->where('r.campus', 'NASHIK');			
        }
		//$this->db->group_by("r.route_code");
		$this->db->order_by("r.route_code");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_boarding_details($campus)
	{
		$this->db->select("sf_transport_boarding_details.*,");
		$this->db->from("sf_transport_boarding_details");
		if($campus!='')
		{
			$this->db->where('campus', $campus);
		}
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			$this->db->where('campus', 'SIJOUL');
        }
        else if($exp[1]=="nashik")
        {
			$this->db->where('campus', 'NASHIK');			
        }
		$this->db->where('is_active', 'Y');
		$this->db->order_by("sf_transport_boarding_details.boarding_point");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_boardingmaster_details($id)
	{
		$this->db->select("sf_transport_boarding_details.*,");
		$this->db->from("sf_transport_boarding_details");
		if($id!='')
		{
			$this->db->where('board_id', $id);
		}
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			$this->db->where('campus', 'SIJOUL');
        }
        else if($exp[1]=="nashik")
        {
			$this->db->where('campus', 'NASHIK');			
        }
		$this->db->order_by("sf_transport_boarding_details.boarding_point");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	
	/* public function distinct_route_id_bycampus($data)
	{
		$this->db->distinct();
		$this->db->select("sf_transport_driver_bus.route_id");
		$this->db->from("sf_transport_driver_bus");
		$this->db->join("sf_transport_route", "sf_transport_route.route_id = sf_transport_driver_bus.route_id");
		if(isset($data['campus']) && $data['campus']!='')
		{
			$this->db->where('sf_transport_route.campus', $data['campus']);
		}
		$query = $this->db->get();
		return $query->result_array();
	} */
	
	public function get_route_boarding_details($data)
	{
		$this->db->select("sf_transport_vendor.vendor_name,sf_transport_bus_details.*,sf_transport_route.route_id,sf_transport_route.route_name,sf_transport_route.route_code,sf_transport_route.campus,sf_transport_driver_details.driver_name");
		$this->db->from("sf_transport_route");
		$this->db->join("sf_transport_bus_details", "sf_transport_bus_details.route_id = sf_transport_route.route_id","left");
		$this->db->join("sf_transport_driver_details", "sf_transport_driver_details.driver_id = sf_transport_bus_details.driver_id","left");
		$this->db->join("sf_transport_vendor", "sf_transport_vendor.vendor_id = sf_transport_driver_details.vendor_id","left");
		
		if(isset($data['campus']) && $data['campus']!='')
		{
			$this->db->where('sf_transport_route.campus', $data['campus']);
		}
		
		$this->db->order_by("sf_transport_route.campus,sf_transport_route.route_code,sf_transport_route.route_name,sf_transport_bus_details.bus_no");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function check_route_exists($data)
	{
		if(isset($data['id']) && $data['id']!='')
			$where=" campus='".$data['campus']."' and ( route_name='".$data['rname']."' || route_code='".$data['rcode']."') and route_id!='".$data['id']."'";
		else
			$where=" campus='".$data['campus']."' and ( route_name='".$data['rname']."' || route_code='".$data['rcode']."')";
		
		$this->db->distinct();
		$this->db->select("COUNT(route_id) as count_rows");
		$this->db->from("sf_transport_route");
		$this->db->where($where);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->row()->count_rows;
	}
	
	public function check_boardingpoint_exists($data)
	{
		if(isset($data['id']) && $data['id']!='')
			$where=" campus='".$data['campus']."' and  boarding_point='".$data['bpoint']."' and board_id!='".$data['id']."'";
		else
			$where=" campus='".$data['campus']."' and  boarding_point='".$data['bpoint']."'";
		
		$this->db->distinct();
		$this->db->select("COUNT(board_id) as count_rows");
		$this->db->from("sf_transport_boarding_details");
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row()->count_rows;
	}
	
	public function check_vendor_exists($data)
	{
		if(isset($data['id']) && $data['id']!='')
			$where=" campus='".$data['campus']."' and  vendor_name='".$data['vname']."' and vendor_id!='".$data['id']."'";
		else
			$where=" campus='".$data['campus']."' and  vendor_name='".$data['vname']."'";
		
		$this->db->distinct();
		$this->db->select("COUNT(vendor_id) as count_rows");
		$this->db->from("sf_transport_vendor");
		$this->db->where($where);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->row()->count_rows;
	}
	
	public function checking_vendor_exists($vname,$campus)
	{
		$where=" campus='".$campus."' and  vendor_name='".$vname."'";
		
		$this->db->distinct();
		$this->db->select("COUNT(vendor_id) as count_rows");
		$this->db->from("sf_transport_vendor");
		$this->db->where($where);
		$query = $this->db->get();
		$check=$query->row()->count_rows;
		if ($check ==1){
            return false;
        }else{
            return true;
        }
	}
	
	public function get_bus_trip_details($data)
	{
		if(isset($data['route']) && $data['route']!='' && $data['route']=='summary')
			$this->db->select("count(ttd.bus_no) as trip_count,ttd.*,tr.route_name");
		else
			$this->db->select("ttd.*,tr.route_name");
	
		$this->db->from("sf_transport_trip_details as ttd");

		$this->db->join("sf_transport_route as tr","tr.route_id=ttd.route_id");
		
		if(isset($data['bus']) && $data['bus']!='')
		{
			$this->db->where('ttd.bus_no', $data['bus']);
		}
		
		if(isset($data['route']) && $data['route']!='' && $data['route']=='day')
		{
			if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
			{
				$this->db->where('ttd.trip_date >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
				$this->db->where('ttd.trip_date <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
			}
			else if(isset($data['odate']) && $data['odate']!='')
			{
				$this->db->where('ttd.trip_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));
			}
			
		}
		else if(isset($data['route']) && $data['route']=='')
		{
			if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
			{
				$this->db->where('ttd.trip_date >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
				$this->db->where('ttd.trip_date <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
			}
			else if(isset($data['odate']) && $data['odate']!='')
			{
				$this->db->where('ttd.trip_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));
			}
			
		}
		else if(isset($data['route']) && $data['route']!='' && $data['route']=='summary')
		{
			 if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
			{
				$this->db->where('ttd.trip_date >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
				$this->db->where('ttd.trip_date <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
			}
			else if(isset($data['odate']) && $data['odate']!='')
			{
				$this->db->where('ttd.trip_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));
			}
			
		}
		$this->db->where('ttd.is_deleted', 'N');
		if(isset($data['route']) && $data['route']!='' && $data['route']=='summary')
			$this->db->group_by('ttd.bus_no,ttd.trip_type'); 

	
		$this->db->order_by('ttd.trip_date,ttd.trip_time,ttd.bus_no','desc');
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_bus_trip_details_new($data)
	{
		if(isset($data['route']) && $data['route']!='' && $data['route']=='summary')
			$this->db->select("count(ttd.bus_no) as trip_count,ttd.*,tr.route_name");
		else
			$this->db->select("ttd.*,tr.route_name");
	
		$this->db->from("sf_transport_trip_details as ttd");
		$this->db->join("sf_transport_bus_details as tbd","tbd.bus_no=ttd.bus_no");
		$this->db->join("sf_transport_route as tr","tr.route_id=tbd.route_id");
		
		if(isset($data['bus']) && $data['bus']!='')
		{
			$this->db->where('ttd.bus_no', $data['bus']);
		}
		
		if(isset($data['route']) && $data['route']!='' && $data['route']=='day')
		{
			if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
			{
				$this->db->where('ttd.trip_date >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
				$this->db->where('ttd.trip_date <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
			}
			else if(isset($data['odate']) && $data['odate']!='')
			{
				$this->db->where('ttd.trip_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));
			}
			
		}
		else if(isset($data['route']) && $data['route']=='')
		{
			if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
			{
				$this->db->where('ttd.trip_date >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
				$this->db->where('ttd.trip_date <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
			}
			else if(isset($data['odate']) && $data['odate']!='')
			{
				$this->db->where('ttd.trip_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));
			}
			
		}
		else if(isset($data['route']) && $data['route']!='' && $data['route']=='summary')
		{
			 if(isset($data['fdate']) && $data['fdate']!='' && isset($data['tdate']) && $data['tdate']!='')
			{
				$this->db->where('ttd.trip_date >=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['fdate']))));
				$this->db->where('ttd.trip_date <=',  date("Y-m-d", strtotime(str_replace('/', '-', $data['tdate']))));
			}
			else if(isset($data['odate']) && $data['odate']!='')
			{
				$this->db->where('ttd.trip_date',  date("Y-m-d", strtotime(str_replace('/', '-', $data['odate']))));
			}
			
		}
		$this->db->where('ttd.is_deleted', 'N');
		if(isset($data['route']) && $data['route']!='' && $data['route']=='summary')
			$this->db->group_by('ttd.bus_no,ttd.trip_type'); 

	
		$this->db->order_by('ttd.trip_date,ttd.trip_time,ttd.bus_no','desc');
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function add_trip_entry($data)
	{
		//var_dump($data);exit();
		$this->db->insert("sf_transport_trip_details", $data); 
		$last_inserted_id=$this->db->insert_id();                
		return $last_inserted_id;
	}
	
	public function checking_bus_exists($data)
	{
		$where=" bd.bus_no='".$data['bus']."'";
		$this->db->distinct();
		$this->db->select("COUNT(bd.bus_no) as count_rows,bd.bus_no,tr.route_name,tr.route_id,dd.driver_name");
		$this->db->from("sf_transport_bus_details as bd");
		//$this->db->join("sf_transport_trip_details as ttd","bd.bus_no=ttd.bus_no");
		$this->db->join("sf_transport_route as tr","tr.route_id=bd.route_id");
		$this->db->join("sf_transport_driver_details as dd","dd.driver_id=bd.driver_id");
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result_array();
		//return $query->row()->count_rows;
	}
	
	public function checking_bus_details($data)
	{
		$this->db->select("ttd.trip_id,ttd.bus_no,ttd.route_id,ttd.status,tr.route_name,ttd.trip_type");
		$this->db->from("sf_transport_trip_details as ttd");
		
		$this->db->join("sf_transport_route as tr","tr.route_id=ttd.route_id");
		$this->db->where('ttd.trip_date',  date("Y-m-d"));
		$this->db->where('ttd.bus_no',$data['bus']);
		$this->db->where('ttd.trip_type',$data['ttype']);
		$this->db->order_by("ttd.trip_id", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function check_vendor_gst_exists($data)
	{
		if(isset($data['id']) && $data['id']!='')
			$where=" gst_no='".$data['gst']."' and  campus='".$data['campus']."' and vendor_id!='".$data['id']."'";
		else
			$where=" campus='".$data['campus']."' and  gst_no='".$data['gst']."'";
		
		$this->db->distinct();
		$this->db->select("COUNT(vendor_id) as count_rows");
		$this->db->from("sf_transport_vendor");
		$this->db->where($where);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->row()->count_rows;
	}
	
	public function check_bus_exists($data)
	{
		if(isset($data['id']) && $data['id']!='')
			$where=" bus_no='".$data['bno']."' and bus_id!='".$data['id']."'";
		else
			$where=" bus_no='".$data['bno']."'";
		
		$this->db->distinct();
		$this->db->select("COUNT(bus_id) as count_rows");
		$this->db->from("sf_transport_buses");
		$this->db->where($where);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->row()->count_rows;
	}
	
	public function check_drivername_exists($data)
	{
		if(isset($data['id']) && $data['id']!='')
			$where=" driver_name='".$data['driver']."' and driver_id!='".$data['id']."'";
		else
			$where=" driver_name='".$data['driver']."'";
		
		$this->db->distinct();
		$this->db->select("COUNT(driver_id) as count_rows");
		$this->db->from("sf_transport_driver_details");
		$this->db->where($where);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->row()->count_rows;
	}
	
	public function check_driver_license_exists($data)
	{
		if(isset($data['id']) && $data['id']!='')
			$where=" driving_license_no='".$data['license']."' and driver_id!='".$data['id']."'";
		else
			$where=" driving_license_no='".$data['license']."'";
		
		$this->db->distinct();
		$this->db->select("COUNT(driver_id) as count_rows");
		$this->db->from("sf_transport_driver_details");
		$this->db->where($where);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->row()->count_rows;
	}
	
	public function check_driver_batchno_exists($data)
	{
		if(isset($data['id']) && $data['id']!='')
			$where=" batch_no='".$data['batch']."' and driver_id!='".$data['id']."'";
		else
			$where=" batch_no='".$data['batch']."'";
		
		$this->db->distinct();
		$this->db->select("COUNT(driver_id) as count_rows");
		$this->db->from("sf_transport_driver_details");
		$this->db->where($where);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->row()->count_rows;
	}
	
	public function disable_driver_bus_mapping($id,$data)
	{
		$this->db->where('driver_id', $id);
		$this->db->update('sf_transport_driver_bus', $data);
		return $this->db->affected_rows();
	}
	
	public function get_academic_details()
	{
		$sql="select * From sf_academic_year";
		$query = $this->db->query($sql);
		return  $query->result_array();
	}
	public function get_boarding_details_infeemaster($data)
	{
		$this->db->select("sf_facility_fees_master.*,sf_transport_boarding_details.boarding_point,sf_transport_boarding_details.board_id,sf_transport_boarding_details.campus");
		$this->db->from("sf_facility_fees_master");
		$this->db->join("sf_transport_boarding_details", "sf_transport_boarding_details.board_id = sf_facility_fees_master.category_id",'left');
		if($data['campus']!='')
		{
			$this->db->where('sf_transport_boarding_details.campus', $data['campus']);
		}
		
		if($data['academic']!='')
		{
			$this->db->where('sf_facility_fees_master.academic_year', $data['academic']);
		}
		
		if($data['pdfcampus']!='')
		{
			$this->db->where('sf_transport_boarding_details.campus', $data['pdfcampus']);
		}
		
		if($data['pdfacademic']!='')
		{
			$this->db->where('sf_facility_fees_master.academic_year', $data['pdfacademic']);
		}
		
		if($data['excelcampus']!='')
		{
			$this->db->where('sf_transport_boarding_details.campus', $data['excelcampus']);
		}
		
		if($data['excelacademic']!='')
		{
			$this->db->where('sf_facility_fees_master.academic_year', $data['excelacademic']);
		}
		
		$exp = explode("_",$_SESSION['name']);
		if($exp[1]=="sijoul")
        {
			$this->db->where('sf_transport_boarding_details.campus', 'SIJOUL');
        }
        else if($exp[1]=="nashik")
        {
			$this->db->where('sf_transport_boarding_details.campus', 'NASHIK');			
        }
		
		$this->db->where('facility_type_id','2');
		$this->db->where('status','Y');
		$this->db->order_by("sf_transport_boarding_details.boarding_point");//distance_from_campus
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function get_boarding_list_notin_boarding($boardinglist,$data)
	{
		$this->db->select("sf_transport_boarding_details.board_id,sf_transport_boarding_details.boarding_point");
		$this->db->from("sf_transport_boarding_details");
		if(!empty($boardinglist)){
			$this->db->where_not_in('sf_transport_boarding_details.board_id',$boardinglist);
		}
		$this->db->where('sf_transport_boarding_details.campus',$data['campus']);
		$this->db->order_by("sf_transport_boarding_details.boarding_point");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function add_boarding_fees_details_submit($data)
	{
		$this->db->insert_batch('sf_facility_fees_master', $data);
		$last_inserted_id=$this->db->insert_id();
		return $last_inserted_id;
	}
	
	public function updateall_fees_details_submit($data)
	{
		$this->db->update_batch('sf_facility_fees_master', $data,'sffm_id');
		return $this->db->affected_rows();
	}
		
	public function get_boardingfee_details_byid($id)
	{
		$this->db->select("sf_facility_fees_master.*,sf_transport_boarding_details.boarding_point,sf_transport_boarding_details.campus");
		$this->db->from("sf_facility_fees_master");
		$this->db->join("sf_transport_boarding_details", "sf_transport_boarding_details.board_id = sf_facility_fees_master.category_id");
		$this->db->where('sf_facility_fees_master.sffm_id',$id);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	public function edit_boarding_fee_submit($id,$updatearray)
	{
		$this->db->where('sffm_id', $id);
		$this->db->update("sf_facility_fees_master", $updatearray);
		return $this->db->affected_rows();
	}
	
	function fetch_student_data($prn,$acyear,$org,$facility_id='')
	{

		$this->db->select("*");
		$this->db->from("sf_student_facilities");
		$this->db->where("enrollment_no",$prn);
		$this->db->where("academic_year",$acyear);
		$this->db->where("organisation",$org);
		$this->db->where("sffm_id",2);
		$this->db->where("cancelled_facility",'N');
		$this->db->where("status",'Y');
		$result = $this->db->get();
		//echo $this->db->last_query();exit();
		$data=$result->row_array();
		return $data;
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
	
	function t_students_data($data)
	{//var_dump($data);exit();
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
		
	if(($data['arg_org']=="All" && isset($_POST['arg_org'])) || ($data['arg_org1']=="All" && isset($_POST['arg_org'])))
	 {
		$this->db->select("sum(sfd.amount) as paid_amt,sandipun_ums.student_master.current_year,sandipun_ums.student_master.gender,sandipun_ums.student_master.mobile,sandipun_ums.student_master.birth_place as address,shrd.floor_no,shrd.room_no, shm.hostel_code, sandipun_ums.student_master.first_name, sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,sandipun_ums.student_master.admission_stream,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name, sandipun_ums.vw_stream_details.school_short_name as school_name, sandipun_erp.sf_student_facilities.*, sandipun_erp.sf_student_facility_allocation.f_alloc_id, sandipun_erp.sf_student_facility_allocation.is_active,sandipun_erp.sf_student_facility_allocation.allocated_id");
		$this->db->from("sandipun_ums.student_master");

		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		 
		$this->db->join("sandipun_erp.sf_fees_details as sfd",'sfd.student_id = sandipun_ums.student_master.stud_id and sfd.enrollment_no=sandipun_ums.student_master.enrollment_no and sfd.type_id=2');
		
		if($data['arg_org1']!=="" && isset($_POST['arg_org1']))
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='Y' and sandipun_erp.sf_student_facilities.sffm_id='2'");
	else
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='N' and sandipun_erp.sf_student_facilities.sffm_id='2'");
				
		$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\'','left');
		$this->db->join('sandipun_erp.sf_transport_boarding_details','sandipun_erp.sf_transport_boarding_details.board_id = sandipun_erp.sf_student_facility_allocation.allocated_id and sandipun_erp.sf_transport_boarding_details.is_active=\'Y\'','left');
		
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
		$this->db->group_by('sandipun_erp.sf_student_facilities.enrollment_no'); 		
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("sum(sfd.amount) as paid_amt,sm.current_year,sm.gender,sm.mobile,sm.Address as address,shrd.floor_no,shrd.room_no, shm.hostel_code, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no, sm.student_id as stud_id,sm.program_id as admission_stream,spd.branch_short_name as stream_name, spd.course_name, spd.college_name as school_name,ssf.*,sfa.f_alloc_id, sfa.is_active,sfa.allocated_id");
		$this->db->from("sf_student_master sm");
		
		$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		
		$this->db->join("sf_fees_details as sfd",'sfd.student_id = sm.student_id and sfd.enrollment_no=sm.enrollment_no and sfd.type_id=1');
		
		$this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.sffm_id="1"','left');
				
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
		//echo $this->db->last_query();exit();
		$data= $query->result_array();
	 }
	 else if(($data['arg_org']=="SU" && isset($_POST['arg_org'])) || ($data['arg_org1']=="SU" && isset($_POST['arg_org'])))
	{
		$this->db->select("sandipun_ums.student_master.birth_place as address,sandipun_ums.student_master.current_year,sandipun_ums.student_master.admission_stream,sandipun_ums.student_master.admission_school,sandipun_ums.student_master.gender,sandipun_ums.student_master.dob,sandipun_ums.student_master.blood_group,sandipun_ums.student_master.mobile,sandipun_ums.student_master.adhar_card_no,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_erp.sf_student_facilities.*,sandipun_ums.vw_stream_details.stream_short_name as stream_name, sandipun_ums.vw_stream_details.course_name, sandipun_ums.vw_stream_details.school_short_name as school_name, sandipun_erp.sf_student_facility_allocation.f_alloc_id,sandipun_erp.sf_student_facility_allocation.is_active,sandipun_erp.sf_student_facility_allocation.allocated_id,sandipun_erp.sf_transport_boarding_details.board_id,sandipun_erp.sf_transport_boarding_details.boarding_point,sandipun_erp.sf_transport_boarding_details.campus,str.route_name");

		$this->db->from("sandipun_ums.student_master");

		 $this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		 //$this->db->join("sandipun_erp.sf_fees_details as sfd",'sfd.student_id = sandipun_ums.student_master.stud_id and sfd.enrollment_no=sandipun_ums.student_master.enrollment_no and sfd.type_id=2');
		if($data['arg_org']!=="" && isset($_POST['arg_org']))
			$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='N' and sandipun_erp.sf_student_facilities.sffm_id='2'",'left');
		else
			$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='Y' and sandipun_erp.sf_student_facilities.sffm_id='2'",'left');
		

		$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\'','left');
		$this->db->join('sandipun_erp.sf_transport_boarding_details','sandipun_erp.sf_transport_boarding_details.board_id = sandipun_erp.sf_student_facility_allocation.allocated_id and sandipun_erp.sf_transport_boarding_details.is_active=\'Y\'','left');
		
		$this->db->join('sandipun_erp.sf_transport_route_details as strd','sandipun_erp.sf_transport_boarding_details.board_id = strd.board_id');
		$this->db->join('sandipun_erp.sf_transport_route as str','str.route_id = strd.route_id');
						
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
		//$this->db->where("sfd.academic_year",$data['arg_acyear']);
		}
		if($data['arg_acyear1']!=="" && isset($_POST['arg_acyear1']))
		{
		$this->db->where("sandipun_erp.sf_student_facilities.academic_year",$data['arg_acyear1']);
		//$this->db->where("sfd.academic_year",$data['arg_acyear1']);
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
		$this->db->select("sm.Address as address,sm.mobile,sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.student_id as stud_id,sm.program_id as admission_stream,spd.branch_short_name as stream_name, spd.course_name, spd.college_name as school_name,ssf.*,sfa.f_alloc_id, sfa.is_active,sfa.allocated_id,stbd.board_id,stbd.boarding_point,str.route_name,stbd.campus");
		$this->db->from("sf_student_master sm");
		//$this->db->join("sf_fees_details as sfd",'sfd.student_id = sm.student_id and sfd.enrollment_no=sm.enrollment_no and sfd.type_id=2');				
		$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		
		if($data['arg_acyear']!='' && isset($_POST['arg_acyear']))
			$this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.sffm_id="2" and ssf.cancelled_facility="N"','left');
		else
			$this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.sffm_id="2" and ssf.cancelled_facility="Y"','left');
		
		$this->db->join('sf_student_facility_allocation as sfa','ssf.sf_id = sfa.sf_id and sfa.sffm_id=ssf.sffm_id and sfa.is_active="Y"','left');
		
		$this->db->join('sf_transport_boarding_details as stbd','stbd.board_id = sfa.allocated_id','left');
		$this->db->join('sf_transport_route_details as strd','stbd.board_id = strd.board_id');
		$this->db->join('sf_transport_route as str','str.route_id = strd.route_id');
		
		if($data['arg_org']!='' && isset($_POST['arg_org']))
		{
		$this->db->where("ssf.organisation",$data['arg_org']);
		}
		if($data['arg_org1']!='' && isset($_POST['arg_org1']))
		{
		$this->db->where("ssf.organisation",$data['arg_org1']);
		}
		
		if($temp!=="" && strlen($temp)>0)
		{
			$this->db->where("ssf.sf_id in(".$temp.")",NULL, false);
			//where("App.id IN (".$subquery.")",NULL, false)
		}
		if($data['arg_acyear']!='' && isset($_POST['arg_acyear']))
		{
			$this->db->where("ssf.academic_year",$data['arg_acyear']);
			//$this->db->where("sfd.academic_year",$data['arg_acyear']);
		}
		if($data['arg_acyear1']!='' && isset($_POST['arg_acyear1']))
		{
			$this->db->where("ssf.academic_year",$data['arg_acyear1']);
			//$this->db->where("sfd.academic_year",$data['arg_acyear1']);
		}
		if($data['arg_institute']!='')
		{
			$this->db->where("spd.college_name",$data['arg_institute']);
		}				
		
		$this->db->group_by('ssf.enrollment_no');
		$result = $this->db->get();
		$data=$result->result_array();   
	}
	//var_dump($data);
	return $data;
	}
	
	function load_transport_students()
	{
       $acyear = $_POST['acyear'];
       $org = $_POST['org'];
	   $prn = $_POST['prn'];
       $check= $this->fetch_student_data($_POST['prn'],$acyear,$_POST['org']);  
       $pos=strpos($_POST['prn'],"SUN");
       if($check['enrollment_no']=='')
       {
		  
		   if($_POST['org']=="SU" && !$pos)
		   {
				$DB1 = $this->load->database('umsdb',TRUE);
				$DB1->select("sm.stud_id,sm.first_name,sm.middle_name,sm.last_name,sm.form_number,sm.academic_year,sm.admission_year,sm.current_year,sm.admission_semester,sm.mobile,sm.email,sm.current_semester,sm.admission_session,sm.enrollment_no,vsd.stream_short_name,vsd.course_short_name,vsd.school_name");
				$DB1->from('student_master as sm');
				$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
				$DB1->where('sm.enrollment_no',$_POST['prn']);      
				$query = $DB1->get();
				$data= $query->row_array();
				$data['organisation']="SU";
				//$data['opted']="NO";
		   }
		  else
		   {
			   if($pos)
				   $org="SF";
			   
			   
				$this->db->select("sm.student_id as stud_id,sm.enrollment_no,sm.current_year,sm.first_name,sm.organization as organisation,sm.instute_name as school_name,sm.middle_name,sm.last_name,
				sm.admission_session, sm.academic_year,sm.mobile,sm.email,spd.course_name as course_short_name, spd.branch_name as stream_short_name");
				$this->db->from("sf_student_master sm");
				$this->db->where("enrollment_no",$_POST['prn']);
				//$this->db->where("academic_year",$acyear);
				$this->db->where("sm.organization",$org);
				$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
				$result = $this->db->get();
				//echo 'sf=='.$this->db->last_query();
				$data=$result->row_array();
				
			}

			if($data['enrollment_no']=='')
			{
			   echo "PRN number does not exist";
			   exit();
			}
			$data['stat']='N';
			$data['academic']=$_POST['acyear'];
			$data['opted']="NO";
		}
		else
		{
		    if($_POST['org']=="SU" && !$pos )
			{
				$this->db->select("sandipun_ums.student_master.*,sandipun_erp.sf_student_facilities.*,sandipun_ums.vw_stream_details.stream_short_name ,sandipun_ums.vw_stream_details.course_short_name,sandipun_ums.vw_stream_details.school_short_name as school_name");

				$this->db->from("sandipun_ums.student_master");

				$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");


				$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.sffm_id=2");

				$this->db->where("sandipun_ums.student_master.enrollment_no",$_POST['prn']);
				$this->db->where("sandipun_erp.sf_student_facilities.academic_year",$acyear);


				$query = $this->db->get();
				//echo $this->db->last_query();
				$data=$query->row_array();
				$data['organisation']="SU";
				//$data['opted']="YES";
			}
			else
			{
				if($pos)
				   $org="SF";
			   
			$this->db->select("sm.student_id as stud_id,sm.enrollment_no,sm.current_year,sm.first_name,sm.organization as organisation,sm.instute_name as school_name, sm.middle_name, sm.last_name,sm.admission_session ,sm.academic_year, sm.mobile,sm.email,spd.college_name as school_name, concat(spd.course_name,'[',spd.branch_short_name,']') as stream_short_name");
        $this->db->from("sf_student_master sm");
         	$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
			$this->db->join('sf_student_facilities as ssf','ssf.enrollment_no = sm.enrollment_no and ssf.sffm_id=2');
			 $this->db->where("sm.enrollment_no",$_POST['prn']);
		 $this->db->where("ssf.academic_year",$acyear);
		 $this->db->where("sm.organization",$org);
        $result = $this->db->get();
		//echo $this->db->last_query();exit();
         $data=$result->row_array();   
			//$data['organisation']="SF";
			
			}
		$data['stat']='Y';
		 $data['academic']=$_POST['acyear'];
		 $data['opted']="YES";
		}
		//var_dump($data);
		return $data;
	}
	
	function facility_fee_details($fcid,$acyear,$bpoint)
	{
		$this->db->select('*');
		$this->db->from('sf_facility_fees_master');
		$this->db->where('facility_type_id',$fcid);
		$this->db->like(array("academic_year"=>$acyear));
		$this->db->where('category_id',$bpoint);
		$this->db->where('status','Y');
		$query =  $this->db->get();
		return $query->row_array();
	}
   
	function register_for_facility($data)
	{	
		$this->db->insert("sf_student_facilities", $data); 
		$last_inserted_id=$this->db->insert_id();                
		return $last_inserted_id;
	}
	
	function allocate_boardingpoint($data)
	{	
		$this->db->insert("sf_student_facility_allocation", $data); 
		$last_inserted_id=$this->db->insert_id();                
		return $last_inserted_id;
	}
	
	function Rpoint($Rpoint){
		
		$query="SELECT bd.board_id,bd.boarding_point FROM sf_transport_route_details as rd 
		inner join sf_transport_boarding_details as bd ON bd.board_id=rd.board_id
		WHERE rd.route_id='$Rpoint'";
		
		$sql=$this->db->query($query);
		
		return $sql->result_array();
		
		
	}
	
	function search_students_data()
	{
		$pos=strpos($_POST['prn'],"SUN");
		
		if($_POST['org']=="All")
	 {
		 $this->db->select("sandipun_ums.student_master.mobile,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,sandipun_ums.student_master.admission_stream,sandipun_ums.vw_stream_details.stream_short_name as stream_name, sandipun_ums.vw_stream_details.course_name, sandipun_ums.vw_stream_details.school_short_name as school_name, sandipun_erp.sf_student_facilities.*, sandipun_erp.sf_student_facility_allocation.f_alloc_id,sandipun_erp.sf_student_facility_allocation.is_active,sandipun_erp.sf_student_facility_allocation.allocated_id,sandipun_erp.sf_transport_boarding_details.board_id,sandipun_erp.sf_transport_boarding_details.boarding_point,sandipun_erp.sf_transport_boarding_details.campus");
		$this->db->from("sandipun_ums.student_master");

		 $this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		 
		if( isset($_POST['cancel']) && $_POST['cancel']=="cancel" )
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='Y' and sandipun_erp.sf_student_facilities.sffm_id='2'");
	else
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='N' and sandipun_erp.sf_student_facilities.sffm_id='2'");
		
		$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\'','left');
		$this->db->join('sandipun_erp.sf_transport_boarding_details','sandipun_erp.sf_transport_boarding_details.board_id = sandipun_erp.sf_student_facility_allocation.allocated_id and sandipun_erp.sf_transport_boarding_details.is_active=\'Y\'','left');
		//$this->db->where("sandipun_erp.sf_student_facilities.organisation",$_POST['org']);
		if($_POST['prn']!='')
		{
		$this->db->where("sandipun_erp.sf_student_facilities.enrollment_no",$_POST['prn']);
		}
		if($_POST['acyear']!='')
		{
		$this->db->where("sandipun_erp.sf_student_facilities.academic_year",$_POST['acyear']);
		} 
		if($_POST['institute']!='')
		{
		$this->db->where("sandipun_ums.vw_stream_details.school_short_name",$_POST['institute']);
		}
		$this->db->where("sandipun_ums.student_master.enrollment_no not like '18SUN%'");
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("sm.mobile,sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.student_id as stud_id,sm.program_id as admission_stream,sm.stream as stream_name, sm.course as course_name, sm.instute_name as school_name,ssf.*,sfa.f_alloc_id, sfa.is_active,sfa.allocated_id,stbd.board_id,stbd.boarding_point,stbd.campus");
		$this->db->from("sf_student_master sm");
								
		//$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		
		$this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.sffm_id="2"','left');
		
		$this->db->join('sf_student_facility_allocation as sfa','ssf.sf_id = sfa.sf_id and sfa.sffm_id=ssf.sffm_id and sfa.is_active="Y"','left');
		
		$this->db->join('sf_transport_boarding_details as stbd','stbd.board_id = sfa.allocated_id','left');
		//$this->db->where("ssf.organisation",$_POST['org']);
		if($_POST['prn']!='')
		{
			$this->db->where("ssf.enrollment_no",$_POST['prn']);
		}
		if($_POST['acyear']!='')
		{
			$this->db->where("ssf.academic_year",$_POST['acyear']);
		}
		if($_POST['institute']!='')
		{
			$this->db->where("spd.college_name",$_POST['institute']);
		}				
		
		//"(col LIKE '%".$search_string1."%' OR col LIKE '%".$search_string2."%' OR col LIKE '%".$search_string3."%' OR col LIKE '%".$search_string4."%')", NULL, FALSE)
		
		
		if( isset($_POST['cancel']) && $_POST['cancel']=="cancel" )
		 $this->db->where("ssf.cancelled_facility",'Y');
	 else
		 $this->db->where("ssf.cancelled_facility",'N');
		
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1." UNION ".$query2);
		//echo $this->db->last_query();exit();
		$data= $query->result_array();
	 }
	 else if($_POST['org']=="SU" && !$pos)
	{
		$this->db->select("sandipun_ums.student_master.*,sandipun_erp.sf_student_facilities.*,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facility_allocation.f_alloc_id,sandipun_erp.sf_student_facility_allocation.is_active,sandipun_erp.sf_student_facility_allocation.allocated_id,sandipun_erp.sf_transport_boarding_details.board_id,sandipun_erp.sf_transport_boarding_details.boarding_point,sandipun_erp.sf_transport_boarding_details.campus");

		$this->db->from("sandipun_ums.student_master");

		 $this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		 
		if( isset($_POST['cancel']) && $_POST['cancel']=="cancel" )
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='Y' and sandipun_erp.sf_student_facilities.sffm_id='2'");
	else
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='N' and sandipun_erp.sf_student_facilities.sffm_id='2'");
		
		$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\'','left');
	
		$this->db->join('sandipun_erp.sf_transport_boarding_details','sandipun_erp.sf_transport_boarding_details.board_id = sandipun_erp.sf_student_facility_allocation.allocated_id and sandipun_erp.sf_transport_boarding_details.is_active=\'Y\'','left');
		$this->db->where("sandipun_erp.sf_student_facilities.organisation",$_POST['org']);
		if($_POST['prn']!='')
			{
		$this->db->where("sandipun_erp.sf_student_facilities.enrollment_no",$_POST['prn']);
			}
		if($_POST['acyear']!='')
		{
		$this->db->where("sandipun_erp.sf_student_facilities.academic_year",$_POST['acyear']);
		} 
		if($_POST['institute']!='')
		{
		$this->db->where("sandipun_ums.vw_stream_details.school_short_name",$_POST['institute']);
		}
			
	  $query = $this->db->get();
	//echo $this->db->last_query();//exit();
		 $data=$query->result_array();
		  // $data['organisation']="SU";
	}
else
	{
		if($pos)
			$org="SF";
		else
			$org=$_POST['org'];
		
		$this->db->select("sm.mobile,sm.student_id as stud_id,sm.organization,sm.instute_name,sm.academic_year,sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name,sfa.f_alloc_id,sfa.allocated_id,sfa.is_active,ssf.*,sm.stream as stream_name,sm.instute_name as school_name, sm.course,sfa.is_active, sfa.allocated_id,stbd.board_id,stbd.boarding_point,stbd.campus");
		$this->db->from("sf_student_master sm");
						
		//$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		
		$this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.sffm_id="2"','left');
		
		$this->db->join('sf_student_facility_allocation as sfa','ssf.sf_id = sfa.sf_id and sfa.sffm_id=ssf.sffm_id and sfa.is_active="Y"','left');
		
		$this->db->join('sf_transport_boarding_details as stbd','stbd.board_id = sfa.allocated_id','left');
		$this->db->where("ssf.organisation",$org);
		if($_POST['prn']!='')
		{
			$this->db->where("ssf.enrollment_no",$_POST['prn']);
		}
		if($_POST['acyear']!='')
		{
			$this->db->where("ssf.academic_year",$_POST['acyear']);
		}
		if($_POST['institute']!='')
		{
			$this->db->where("spd.college_name",$_POST['institute']);
		}				
		
		
		if( isset($_POST['cancel']) && $_POST['cancel']=="cancel" )
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
	
		 $ums_sf_sql="SELECT sum(r.amount) as refund_paid, sum(f.amount) as paid_amt, 
`sm`.`current_year`, `sm`.`gender`, 
`sm`.`mobile`, `sm`.`birth_place` as 
`address`, `sm`.`first_name`, `sm`.`middle_name`, 
`sm`.`last_name`,`sm`.`enrollment_no`, `sm`.`stud_id`, `sm`.`admission_stream`, 
`sandipun_ums`.`vw_stream_details`.`stream_short_name` as `stream_name`, 
`sandipun_ums`.`vw_stream_details`.`course_name`, 
`sandipun_ums`.`vw_stream_details`.`school_short_name` as `school_name`, 
`sandipun_erp`.`ssf`.* ,sfsf.f_alloc_id,sfsf.allocated_id,stbd.board_id,stbd.boarding_point
FROM `sandipun_erp`.`sf_student_facilities` as `ssf` 
INNER JOIN `sandipun_ums`.`student_master` as `sm` ON `sm`.`enrollment_no` = `ssf`.`enrollment_no` 
INNER JOIN `sandipun_ums`.`vw_stream_details` ON 
`sm`.`admission_stream` = 
`sandipun_ums`.`vw_stream_details`.`stream_id` 
left join (select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_details where type_id='2' and is_deleted='N' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_refunds where is_deleted='N' and type_id='2' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no  )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year left join sf_student_facility_allocation as sfsf on sfsf.sf_id=ssf.sf_id
left join sf_transport_boarding_details as stbd on stbd.board_id = sfsf.allocated_id 
WHERE  ssf.sffm_id=2 and sm.enrollment_no not like '18SUN%' and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'N' $where GROUP BY `ssf`.`enrollment_no` 
UNION 
SELECT sum(r.amount) as 
refund_paid, sum(f.amount) as paid_amt, `sm`.`current_year`, `sm`.`gender`, `sm`.`mobile`, 
`sm`.`Address` as `address`, `sm`.`first_name`, `sm`.`middle_name`, `sm`.`last_name`, `sm`.`enrollment_no`, 
`sm`.`student_id` as `stud_id`, `sm`.`program_id` as `admission_stream`, `sm`.`stream` as 
`stream_name`, `sm`.`course` as `course_name`, `sm`.`instute_name` as `school_name`, 
`ssf`.*,sfsf.f_alloc_id,sfsf.allocated_id,stbd.board_id,stbd.boarding_point
FROM `sf_student_facilities` as `ssf` 
INNER JOIN `sf_student_master` `sm` ON `sm`.`enrollment_no` = `ssf`.`enrollment_no` 
left join (select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_details where type_id='2' and is_deleted='N' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_refunds where is_deleted='N' and type_id='2' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no  )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year left join sf_student_facility_allocation as sfsf on sfsf.sf_id=ssf.sf_id
left join sf_transport_boarding_details as stbd on stbd.board_id = sfsf.allocated_id 

WHERE  ssf.sffm_id=2 and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'N' $where GROUP BY `ssf`.`enrollment_no`";
		
		$query2 = $this->db->query($ums_sf_sql);
		//echo $this->db->last_query();exit();
		$data= $query2->result_array();
	 }
	 else if($data['org']=="SU"  && !$pos)
	{
		$where="";
		if($data['prn']!='')
		$where.=" and f.enrollment_no='".$data['prn']."'";	
	
		 $ums_sql="SELECT sum(r.amount) as refund_paid, sum(f.amount) as paid_amt, 
`sm`.`current_year`, `sm`.`gender`, 
`sm`.`mobile`, `sm`.`birth_place` as 
`address`, `sm`.`first_name`, `sm`.`middle_name`, 
`sm`.`last_name`,`sm`.`enrollment_no`, `sm`.`stud_id`, `sm`.`admission_stream`, 
`sandipun_ums`.`vw_stream_details`.`stream_short_name` as `stream_name`, 
`sandipun_ums`.`vw_stream_details`.`course_name`, 
`sandipun_ums`.`vw_stream_details`.`school_short_name` as `school_name`, 
`sandipun_erp`.`ssf`.*,sfsf.f_alloc_id,sfsf.allocated_id,stbd.board_id,stbd.boarding_point
FROM `sandipun_erp`.`sf_student_facilities` as `ssf` 
INNER JOIN `sandipun_ums`.`student_master` as `sm` ON `sm`.`enrollment_no` = `ssf`.`enrollment_no` 
INNER JOIN `sandipun_ums`.`vw_stream_details` ON 
`sm`.`admission_stream` = 
`sandipun_ums`.`vw_stream_details`.`stream_id` 
left join (select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_details where type_id='2' and is_deleted='N' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_refunds where is_deleted='N' and type_id='2' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year left join sf_student_facility_allocation as sfsf on sfsf.sf_id=ssf.sf_id
left join sf_transport_boarding_details as stbd on stbd.board_id = sfsf.allocated_id 
WHERE  ssf.sffm_id=2 and sm.enrollment_no not like '18SUN%' and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'N' $where GROUP BY `ssf`.`enrollment_no` ";
		
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
	
		$sql="SELECT sum(r.amount) as 
refund_paid, sum(f.amount) as paid_amt, `sm`.`current_year`, `sm`.`gender`, `sm`.`mobile`, 
`sm`.`Address` as `address`, `sm`.`first_name`, `sm`.`middle_name`, `sm`.`last_name`, `sm`.`enrollment_no`, `sm`.`student_id` as `stud_id`, `sm`.`program_id` as `admission_stream`, `sm`.`stream` as 
`stream_name`, `sm`.`course` as `course_name`, `sm`.`instute_name` as `school_name`, 
`ssf`.*,sfsf.f_alloc_id,sfsf.allocated_id,stbd.board_id,stbd.boarding_point FROM `sf_student_facilities` as `ssf` 
INNER JOIN `sf_student_master` `sm` ON `sm`.`enrollment_no` = `ssf`.`enrollment_no` 
left join (select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_details where type_id='2' and is_deleted='N' and `academic_year` = '".$data['acyear']."' group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_refunds where is_deleted='N' and type_id='2' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year 
left join sf_student_facility_allocation as sfsf on sfsf.sf_id=ssf.sf_id
left join sf_transport_boarding_details as stbd on stbd.board_id = sfsf.allocated_id 
WHERE ssf.sffm_id=2 and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'N' AND ssf.organisation='".$org."' $where GROUP BY `ssf`.`enrollment_no`";
		
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
	
		 $ums_sf_sql="SELECT sum(r.amount) as refund_paid, sum(f.amount) as paid_amt, 
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
left join (select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_details where type_id='2' and is_deleted='N' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_refunds where is_deleted='N' and type_id='2' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no  )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year 
WHERE  ssf.sffm_id=2 and sm.enrollment_no not like '18SUN%' and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'Y' $where GROUP BY `ssf`.`enrollment_no` 
UNION 
SELECT sum(r.amount) as 
refund_paid, sum(f.amount) as paid_amt, `sm`.`current_year`, `sm`.`gender`, `sm`.`mobile`, 
`sm`.`Address` as `address`, `sm`.`first_name`, `sm`.`middle_name`, `sm`.`last_name`, `sm`.`enrollment_no`, 
`sm`.`student_id` as `stud_id`, `sm`.`program_id` as `admission_stream`, `sm`.`stream` as 
`stream_name`, `sm`.`course` as `course_name`, `sm`.`instute_name` as `school_name`, 
`ssf`.*
FROM `sf_student_facilities` as `ssf` 
INNER JOIN `sf_student_master` `sm` ON `sm`.`enrollment_no` = `ssf`.`enrollment_no` 
left join (select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_details where type_id='2' and is_deleted='N' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_refunds where is_deleted='N' and type_id='2' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no  )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year 
WHERE  ssf.sffm_id=2 and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'Y' $where GROUP BY `ssf`.`enrollment_no`";
		
		$query2 = $this->db->query($ums_sf_sql);
		//echo $this->db->last_query();exit();
		$data= $query2->result_array();
	 }
	 else if($data['org']=="SU"  && !$pos)
	{
		$where="";
		if($data['prn']!='')
		$where.=" and f.enrollment_no='".$data['prn']."'";	
	
		 $ums_sql="SELECT sum(r.amount) as refund_paid, sum(f.amount) as paid_amt, 
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
left join (select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_details where type_id='2' and is_deleted='N' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from `sandipun_erp`.sf_fees_refunds where is_deleted='N' and type_id='2' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year 
WHERE  ssf.sffm_id=2 and sm.enrollment_no not like '18SUN%' and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'Y' and `ssf`.`organisation` = '".$data['org']."' $where GROUP BY `ssf`.`enrollment_no` ";
		
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
	
		$sql="SELECT sum(r.amount) as 
refund_paid, sum(f.amount) as paid_amt, `sm`.`current_year`, `sm`.`gender`, `sm`.`mobile`, 
`sm`.`Address` as `address`, `sm`.`first_name`, `sm`.`middle_name`, `sm`.`last_name`, `sm`.`enrollment_no`, `sm`.`student_id` as `stud_id`, `sm`.`program_id` as `admission_stream`, `sm`.`stream` as 
`stream_name`, `sm`.`course` as `course_name`, `sm`.`instute_name` as `school_name`, 
`ssf`.* FROM `sf_student_facilities` as `ssf` 
INNER JOIN `sf_student_master` `sm` ON `sm`.`enrollment_no` = `ssf`.`enrollment_no` 
left join (select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_details where type_id='2' and is_deleted='N' and `academic_year` = '".$data['acyear']."' group by enrollment_no ) f on ssf.enrollment_no=f.enrollment_no  and 
f.academic_year=ssf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_refunds where is_deleted='N' and type_id='2' and `academic_year` = '".$data['acyear']."' 
group by enrollment_no )
 r on ssf.enrollment_no=r.enrollment_no  and 
r.academic_year=ssf.academic_year 
WHERE  ssf.sffm_id=2 and `ssf`.`academic_year` = '".$data['acyear']."' AND `ssf`.`cancelled_facility` = 'Y'  and `ssf`.`organisation` = '".$data['org']."' $where GROUP BY `ssf`.`enrollment_no`";
		
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		$data= $query->result_array();
	}
	//var_dump($data);

	return $data;
	   
//var_dump($data);
	   
}
   
function h_students_data($data)
{//var_dump($data);exit();
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
		
	if(($data['arg_org']=="All" && isset($_POST['arg_org'])) || ($data['arg_org1']=="All" && isset($_POST['arg_org'])))
	 {
		$this->db->select("sum(sfd.amount) as paid_amt,sandipun_ums.student_master.current_year,sandipun_ums.student_master.gender,sandipun_ums.student_master.mobile,sandipun_ums.student_master.birth_place as address,sandipun_ums.student_master.first_name, sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,sandipun_ums.student_master.admission_stream,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name, sandipun_ums.vw_stream_details.school_short_name as school_name, sandipun_erp.sf_student_facilities.*, sandipun_erp.sf_student_facility_allocation.f_alloc_id, sandipun_erp.sf_student_facility_allocation.is_active,sandipun_erp.sf_student_facility_allocation.allocated_id,sandipun_erp.sf_transport_boarding_details.board_id,sandipun_erp.sf_transport_boarding_details.boarding_point,sandipun_erp.sf_transport_boarding_details.campus");
		$this->db->from("sandipun_ums.student_master");

		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		
		if($data['arg_org1']!=="" && isset($_POST['arg_org1']))
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='Y' and sandipun_erp.sf_student_facilities.sffm_id='2'",'left');
	else
		$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='N' and sandipun_erp.sf_student_facilities.sffm_id='2'",'left');
		$this->db->join("sandipun_erp.sf_fees_details as sfd",'sfd.student_id = sandipun_erp.sf_student_facilities.student_id and sfd.enrollment_no=sandipun_erp.sf_student_facilities.enrollment_no and sfd.type_id=2','left');		
		$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\'','left');
		
		$this->db->join('sandipun_erp.sf_transport_boarding_details','sandipun_erp.sf_transport_boarding_details.board_id = sandipun_erp.sf_student_facility_allocation.allocated_id and sandipun_erp.sf_transport_boarding_details.is_active=\'Y\'','left');
		
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
		$this->db->group_by('sandipun_erp.sf_student_facilities.enrollment_no'); 		
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select("sum(sfd.amount) as paid_amt,sm.current_year,sm.gender,sm.mobile,sm.Address as address,sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no, sm.student_id as stud_id,sm.program_id as admission_stream,spd.branch_short_name as stream_name, spd.course_name, spd.college_name as school_name,ssf.*,sfa.f_alloc_id, sfa.is_active,sfa.allocated_id,stbd.board_id,stbd.boarding_point,stbd.campus");
		$this->db->from("sf_student_master sm");
		
		$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		
		$this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.sffm_id="2"','left');
	
	$this->db->join("sf_fees_details as sfd",'sfd.student_id = ssf.student_id and sfd.enrollment_no=ssf.enrollment_no and sfd.type_id=2','left');
		
		$this->db->join('sf_student_facility_allocation as sfa','ssf.sf_id = sfa.sf_id and sfa.sffm_id=ssf.sffm_id and sfa.is_active="Y"','left');
		
		$this->db->join('sf_transport_boarding_details as stbd','stbd.board_id = sfa.allocated_id','left');

		if($data['arg_acyear']!=="" && isset($_POST['arg_acyear']))
		{
		$this->db->where("ssf.academic_year",$data['arg_acyear']);
		//$this->db->where("sfd.academic_year",$data['arg_acyear']);
		} 

		if($data['arg_acyear1']!=="" && isset($_POST['arg_acyear1']))
		{
		$this->db->where("ssf.academic_year",$data['arg_acyear1']);
		//$this->db->where("sfd.academic_year",$data['arg_acyear1']);
		}
		
		if($data['arg_org1']!=="" && isset($_POST['arg_org1']))
		 $this->db->where("ssf.cancelled_facility",'Y');
	 else
		 $this->db->where("ssf.cancelled_facility",'N');
	
	$this->db->group_by('ssf.enrollment_no'); 	
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1." UNION ".$query2);
		//echo $this->db->last_query();exit();
		$data= $query->result_array();
	 }
	 else if(($data['arg_org']=="SU" && isset($_POST['arg_org'])) || ($data['arg_org1']=="SU" && isset($_POST['arg_org'])))
	{
		$this->db->select("sum(sfd.amount) as paid_amt,sandipun_ums.student_master.birth_place as address,sandipun_ums.student_master.current_year,sandipun_ums.student_master.admission_stream,sandipun_ums.student_master.admission_school,sandipun_ums.student_master.gender,sandipun_ums.student_master.dob,sandipun_ums.student_master.blood_group,sandipun_ums.student_master.mobile,sandipun_ums.student_master.adhar_card_no,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,sandipun_erp.sf_student_facilities.*,sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facility_allocation.f_alloc_id,sandipun_erp.sf_student_facility_allocation.is_active,sandipun_erp.sf_student_facility_allocation.allocated_id,sandipun_erp.sf_transport_boarding_details.board_id,sandipun_erp.sf_transport_boarding_details.boarding_point,sandipun_erp.sf_transport_boarding_details.campus");

		$this->db->from("sandipun_ums.student_master");

		 $this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
		 
		if($data['arg_org']!=="" && isset($_POST['arg_org']))
			$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='N' and sandipun_erp.sf_student_facilities.sffm_id='2'",'left');
		else
			$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='Y' and sandipun_erp.sf_student_facilities.sffm_id='2'",'left');
		$this->db->join("sandipun_erp.sf_fees_details as sfd",'sfd.student_id = sandipun_erp.sf_student_facilities.student_id and sfd.enrollment_no=sandipun_erp.sf_student_facilities.enrollment_no and sfd.type_id=2','left');
		$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\'','left');
	
		$this->db->join('sandipun_erp.sf_transport_boarding_details','sandipun_erp.sf_transport_boarding_details.board_id = sandipun_erp.sf_student_facility_allocation.allocated_id and sandipun_erp.sf_transport_boarding_details.is_active=\'Y\'','left');
		
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
		//$this->db->where("sfd.academic_year",$data['arg_acyear']);
		}
		if($data['arg_acyear1']!=="" && isset($_POST['arg_acyear1']))
		{
		$this->db->where("sandipun_erp.sf_student_facilities.academic_year",$data['arg_acyear1']);
		//$this->db->where("sfd.academic_year",$data['arg_acyear1']);
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
		$this->db->select("sum(sfd.amount) as paid_amt,sm.student_id as stud_id,sm.organization,sm.current_year,sm.program_id,sm.gender,sm.mobile,sm.Address as address,sm.first_name, sm.middle_name,sm.last_name, sfa.f_alloc_id, sfa.allocated_id,sfa.is_active,ssf.*, spd.branch_short_name as stream_name,spd.college_name as school_name,stbd.board_id,stbd.boarding_point,stbd.campus");
		$this->db->from("sf_student_master sm");
				
		$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		
		if($data['arg_acyear']!='' && isset($_POST['arg_acyear']))
			$this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.sffm_id="2" and ssf.cancelled_facility="N"','left');
		else
			$this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.sffm_id="2" and ssf.cancelled_facility="Y"','left');
		
		$this->db->join("sf_fees_details as sfd",'sfd.student_id = ssf.student_id and sfd.enrollment_no=ssf.enrollment_no and sfd.type_id=1','left');
		$this->db->join('sf_student_facility_allocation as sfa','ssf.sf_id = sfa.sf_id and sfa.sffm_id=ssf.sffm_id and sfa.is_active="Y"','left');
		
		$this->db->join('sf_transport_boarding_details as stbd','stbd.board_id = sfa.allocated_id','left');
		if($data['arg_org']!='' && isset($_POST['arg_org']))
		{
		$this->db->where("ssf.organisation",$data['arg_org']);
		}
		if($data['arg_org1']!='' && isset($_POST['arg_org1']))
		{
		$this->db->where("ssf.organisation",$data['arg_org1']);
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
			//$this->db->where("sfd.academic_year",$data['arg_acyear']);
		}
		if($data['arg_acyear1']!='' && isset($_POST['arg_acyear1']))
		{
			$this->db->where("ssf.academic_year",$data['arg_acyear1']);
			//$this->db->where("sfd.academic_year",$data['arg_acyear1']);
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
	   
	
	public function get_transportfee_details($data)
	{
		if($data['org']=="SU" )
		{
			$this->db->select("sandipun_erp.sf_student_facilities.cancelled_facility,sandipun_erp.sf_student_facilities.sf_id,sandipun_erp.sf_student_facilities.student_id,sandipun_erp.sf_student_facilities.organisation,sandipun_erp.sf_student_facilities.deposit_fees,sandipun_erp.sf_student_facilities.actual_fees,sandipun_erp.sf_student_facilities.academic_year,sandipun_ums.vw_stream_details.stream_name,sandipun_ums.vw_stream_details.course_short_name,sandipun_ums.vw_stream_details.stream_short_name,sandipun_ums.vw_stream_details.school_name,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.current_year,sandipun_ums.student_master.last_name,sandipun_erp.sf_student_facilities.enrollment_no,sandipun_ums.vw_stream_details.stream_code,sandipun_erp.sf_transport_boarding_details.campus,sandipun_erp.sf_transport_boarding_details.boarding_point,sandipun_ums.student_master.mobile,sandipun_ums.student_master.email,sandipun_ums.student_master.admission_session");
			$this->db->from("sandipun_ums.student_master");

			$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");

			$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.sffm_id=2");
			
			$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\'');
			$this->db->join('sandipun_erp.sf_transport_boarding_details','sandipun_erp.sf_transport_boarding_details.board_id = sandipun_erp.sf_student_facility_allocation.allocated_id and sandipun_erp.sf_transport_boarding_details.is_active=\'Y\'');
			
			$this->db->where("sandipun_erp.sf_student_facilities.organisation",$data['org']);
			$this->db->where("sandipun_erp.sf_student_facilities.academic_year",$data['academic_year']);
			if($data['enrollment_no']!='')
			{
				$this->db->where("sandipun_erp.sf_student_facilities.enrollment_no",$data['enrollment_no']);
			}
			if($data['student_id']!='')
			{
				$this->db->where("sandipun_erp.sf_student_facilities.student_id",$data['student_id']);
			}    

			$query = $this->db->get();
			//echo $this->db->last_query();exit();
			return $query->result_array();
			
		}
		else
		{		
			//$this->db->join('sf_student_facility_allocation as sfa','ssf.sf_id = sfa.sf_id and sfa.is_active=\'Y\'','left');
			
			//$this->db->join('sf_transport_boarding_details as stbd','stbd.board_id = sfa.allocated_id','left');
			if($data['student_id']!='')
			{
				$where=" where sfsf.sffm_id=2 and sfsf.enrollment_no='".$data['enrollment_no']."' and sfsf.academic_year='".$data['academic_year']."' and sfsf.organisation='".$data['org']."'";
			}
			else
				{
				$where=" where sfsf.sffm_id=2 and sfsf.enrollment_no='".$data['enrollment_no']."' and sfsf.organisation='".$data['org']."' and sfsf.academic_year='".$data['academic_year']."' ";
			}
			
			$sql="select sm.email,sm.mobile,sm.admission_session,sm.current_year,sm.organization as organisation,sm.course,sm.stream,sm.program_id as admission_stream, sm.stream as stream_short_name, sm.course as course_short_name, sm.instute_name as school_name, stbd.boarding_point,stbd.campus,sfsf.sf_id,sfsf.student_id, sfsf.deposit_fees,sfsf.actual_fees,sfsf.cancelled_facility,sm.enrollment_no, sm.first_name, sm.middle_name,sm.last_name,sm.program_id,sm.instute_name as school_name, sfsf.academic_year from sf_student_facilities as sfsf inner join sf_student_master as sm on sm.student_id = sfsf.student_id inner join sf_student_facility_allocation as ssfa on ssfa.sf_id=sfsf.sf_id and sfsf.status='Y' inner join sf_transport_boarding_details as stbd on stbd.board_id=ssfa.allocated_id and stbd.is_active='Y' ".$where; 
			
			$query = $this->db->query($sql);
			//echo $this->db->last_query();exit();

			return $query->result_array();
		}
	}
	
	public function boardingform_submit($data)
	{
		$feedet['actual_fees']=$data['bcharges']; 
		//$feedet['excemption_fees']=$data['bexcemcharges']; 

		$feedet['modified_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet['modified_on']= date('Y-m-d h:i:s');
		$feedet['modified_by']= $_SESSION['uid'];
		
		$where=array("sf_id"=>$data['bsf_id'],"enrollment_no"=>$data['benroll'],"academic_year"=>$data['bacademic_year']);
		$this->db->where($where); 
		$this->db->update('sf_student_facilities', $feedet);
		//echo $this->db->last_query();exit();
		
		$cancel_bed['modified_ip']=$_SERVER['REMOTE_ADDR'];
		$cancel_bed['modified_on']= date('Y-m-d h:i:s');
		$cancel_bed['modified_by']= $_SESSION['uid'];
		$cancel_bed['allocated_id']=$data['bpoint'];
		$where=array("sf_id"=>$data['bsf_id'],"enrollment_no"=>$data['benroll'],"academic_year"=>$data['bacademic_year']);
		$this->db->where($where); 
		$this->db->update('sf_student_facility_allocation', $cancel_bed);
		return $this->db->affected_rows();
	}
	
	public function cancel_faci_submit($data)
	{
		$feedet['cancelled_facility']='Y'; 
		$feedet['refund']=$data['charges']; 
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
		
		$rfeedet['student_id']=$data['rstud_id'];
		$rfeedet['enrollment_no']=$data['enroll'];
		$rfeedet['amount']=$data['charges'];
		$rfeedet['type_id']=2;
		$rfeedet['refund_paid_type']=$data['payment_type'];
		if($data['payment_type']=='CASH')
			$rfeedet['refund_date']=date('Y-m-d');
		else
			$rfeedet['refund_date']=$data['dd_date']; 
	//	$feedet['academic_year']= date('Y');
		$rfeedet['academic_year']=$data['academic_year'];
		$rfeedet['receipt_no']=$data['dd_no'];
		
		$rfeedet['bank_id']=$data['dd_bank'];
		$rfeedet['bank_city']=$data['dd_bank_branch'];
		$rfeedet['remark']=$data['remark'];

		$rfeedet['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$rfeedet['created_on']= date('Y-m-d h:i:s');
		$rfeedet['created_by']= $_SESSION['uid'];


		$rfeedet['refund_for']=$data['refund_type'];
		//var_dump($rfeedet);exit();
		$this->db->insert("sf_fees_refunds", $rfeedet);
	
		$candet['sf_id']=$data['sf_id'];
		$candet['enrollment_no']=$data['enroll'];
		$candet['refund_amount']=$data['charges'];
		$candet['can_charges']=$data['ccharges'];
		$candet['can_date']=$data['date']; 
		$candet['remark']=$data['remarks'];
		$candet['faci_id']=2;
		$candet['academic_year']=$data['academic_year']; 
		$candet['inserted_ip']=$_SERVER['REMOTE_ADDR'];
		$candet['inserted_on']= date('Y-m-d h:i:s');
		$candet['inserted_by']= $_SESSION['uid'];

		$this->db->insert("sf_facility_cancel", $candet); 
		
		//echo $this->db->last_query();exit();
		$last_inserted_id=$this->db->insert_id();                
		return $last_inserted_id;
		
		
		
		
		
		
		
		
		/* $feedet['cancelled_facility']='Y'; 
		$feedet['cancellation_refund']=$data['ccharges']; 
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
		
				
		$candet['refund_paid_type']=$data['payment_type'];
		$candet['receipt_no']=$data['clreceipt'];
		$candet['refund_date']=$data['dd_date']; 
		$candet['bank_id']=$data['dd_bank'];
		$candet['bank_city']=$data['dd_bank_branch']; 
		$candet['dd_no']=$data['dd_no']; 
		
		
		
		
		
		$candet['enrollment_no']=$data['enroll'];
		$candet['can_charges']=$data['charges'];
		$candet['faci_id']=2;
		$candet['academic_year']=$data['academic_year'];
		$candet['can_date']=$data['date']; 
		$candet['remark']=$data['remarks'];


		$candet['inserted_ip']=$_SERVER['REMOTE_ADDR'];
		$candet['inserted_on']= date('Y-m-d h:i:s');
		$candet['inserted_by']= $_SESSION['uid'];

		$this->db->insert("sf_facility_cancel", $candet); 
		
		//echo $this->db->last_query();exit();
		$last_inserted_id=$this->db->insert_id();                
		return $last_inserted_id; */
	}
	
	public function get_student_canc($enroll)
	{
	
		$this->db->select("sfc.*,ssf.cancellation_charges as actcanc_charge");
		$this->db->from("sf_facility_cancel as sfc");
		$this->db->join("sf_student_facilities ssf",'sfc.enrollment_no = ssf.enrollment_no and ssf.sffm_id=sfc.faci_id','left');
		
		//$this->db->join("sandipun_ums.bank_master",'sfc.bank_id = sandipun_ums.bank_master.bank_id','left');
		$this->db->where("sfc.enrollment_no",$enroll);
		$this->db->where("sfc.faci_id",2);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->row_array();
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

	function fetch_transportfee_details_byfid($data)
	{
		$sql="select *, f.amount as amt_paid from sf_fees_details as f where f.fees_id='".$data."' and f.is_deleted='N' and f.type_id=2 order by f.fees_id;";
		
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	function total_fee_paid($data)
	{
		$sql = "select sum(amount) as fee_paid from sf_fees_details where enrollment_no = '".$data['enrollment_no']."' and is_deleted='N'  and chq_cancelled='N' and type_id=2";
	 	$query = $this->db->query($sql); 
		return $query->row_array();
	}
	
	public function get_std_fc_details_byid($data)
	{
		/* $sql1="SELECT sum(r.re_amount) as refund_paid, sum(f.amount) as paid_amt,sfsf.* FROM sf_student_facilities as sfsf 
		inner join (select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_details where type_id='2' and is_deleted='N'
		group by enrollment_no  ,academic_year ) f on sfsf.enrollment_no=f.enrollment_no  and f.academic_year=sfsf.academic_year left JOIN 
		(select enrollment_no  ,sum(amount) as re_amount,academic_year from sf_fees_refunds where is_deleted='N'
		group by enrollment_no  ,academic_year )
		 r on sfsf.enrollment_no=r.enrollment_no  and 
		r.academic_year=sfsf.academic_year
		where f.enrollment_no='".$data['enrollment_no']."' and f.academic_year='".$data['academic_year']."'
		  group by f.academic_year;";
		
		$query1 = $this->db->query($sql1);
		//echo $this->db->last_query();exit();
		$fee_count= $query1->result_array();
		
		
		$sql="SELECT sum(r.re_amount) as refund_paid, sum(f.amount) as paid_amt,sfsf.* FROM sf_student_facilities as sfsf 
		inner join (select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_details where type_id='2' and is_deleted='N'
		group by enrollment_no  ,academic_year ) f on sfsf.enrollment_no=f.enrollment_no  and 
		f.academic_year=sfsf.academic_year left JOIN 
		(select enrollment_no  ,sum(amount) as re_amount,academic_year from sf_fees_refunds where is_deleted='N'
		group by enrollment_no  ,academic_year )
		 r on sfsf.enrollment_no=r.enrollment_no  and 
		r.academic_year=sfsf.academic_year
		where f.enrollment_no='".$data['enrollment_no']."'
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
			where f.enrollment_no='".$data['enrollment_no']."' and f.sffm_id=2 and f.academic_year='".$data['academic_year']."' ";
			
			$query = $this->db->query($sql);
			//echo $this->db->last_query();exit();
			$res2=$query->result_array();
			return array_merge($res1,$res2);
		} */
		
		$sql1="SELECT sum(r.re_amount) as refund_paid, sum(f.amount) as paid_amt,sfsf.* FROM sf_student_facilities as sfsf 
inner join (select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_details where type_id='2' and is_deleted='N'
group by enrollment_no  ,academic_year ) f on sfsf.enrollment_no=f.enrollment_no  and 
f.academic_year=sfsf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as re_amount,academic_year from sf_fees_refunds where is_deleted='N' and type_id=2 group by enrollment_no  ,academic_year )
 r on sfsf.enrollment_no=r.enrollment_no  and 
r.academic_year=sfsf.academic_year
where sfsf.sffm_id=2 and f.enrollment_no='".$data['enrollment_no']."' and f.academic_year='".$data['academic_year']."' and sfsf.cancelled_facility='N'
  group by f.academic_year;
";
		
		$query1 = $this->db->query($sql1);
		//echo $this->db->last_query();exit();
		$fee_count= $query1->result_array();
		
		/* $sql="select sum(r.amount) as refund_paid,ssf.*,sum(sfd.amount) as paid_amt,sfd.fees_id,sfd.bank_id,sfd.bank_city,sfd.canc_charges,sfd.exam_fee_fine,sfd.college_receiptno,sfd.chq_cancelled,sfd.is_deleted from sf_student_facilities as ssf inner join sf_fees_details as sfd on sfd.enrollment_no=ssf.enrollment_no and ssf.academic_year=sfd.academic_year and sfd.type_id=ssf.sffm_id left JOIN sf_fees_refunds as r on ssf.enrollment_no=r.enrollment_no  and ssf.sffm_id=1 and 
		r.academic_year=ssf.academic_year
		where ssf.enrollment_no='".$data['enrollment_no']."' and sfd.is_deleted='N' and ssf.sffm_id=1 group by ssf.academic_year;"; */
		$sql="SELECT sum(r.re_amount) as refund_paid, sum(f.amount) as paid_amt,sfsf.* FROM sf_student_facilities as sfsf 
inner join (select enrollment_no  ,sum(amount) as amount,academic_year from sf_fees_details where type_id='2' and is_deleted='N'
group by enrollment_no  ,academic_year ) f on sfsf.enrollment_no=f.enrollment_no  and 
f.academic_year=sfsf.academic_year left JOIN 
(select enrollment_no  ,sum(amount) as re_amount,academic_year from sf_fees_refunds where is_deleted='N' and type_id=2 group by enrollment_no  ,academic_year )
 r on sfsf.enrollment_no=r.enrollment_no  and 
r.academic_year=sfsf.academic_year
where  sfsf.sffm_id=2 and  f.enrollment_no='".$data['enrollment_no']."' and sfsf.cancelled_facility='N'
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
			where f.enrollment_no='".$data['enrollment_no']."' and f.sffm_id=2 and f.academic_year='".$data['academic_year']."' ";
			
			$query = $this->db->query($sql);
			//echo $this->db->last_query();exit();
			$res2=$query->result_array();
			return array_merge($res1,$res2);
		}
	}
	
	function student_paid_fees()
	{
		$sql="select f.student_id,f.fees_paid_type,f.fees_id,f.canc_charges,f.chq_cancelled, f.receipt_no, f.receipt_file, f.fees_date, f.bank_id, f.bank_city, f.amount as amt_paid,f.remark, f.college_receiptno,f.academic_year as academic_year from sf_fees_details as f where f.enrollment_no='".$_POST['prn']."' and f.is_deleted='N' and f.type_id=2 order by f.fees_id;";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}
	
	// fetch all installment details
	function fetch_transportfee_details($data)
	{
		/* $sql="select f.student_id,f.fees_paid_type,f.academic_year,f.fees_id,f.canc_charges,f.chq_cancelled, f.receipt_no, f.receipt_file, f.fees_date, f.bank_id, f.bank_city, f.amount as amt_paid,f.remark, f.college_receiptno from sf_fees_details as f where f.enrollment_no='".$data['enrollment_no']."' and f.is_deleted='N' and f.type_id=2 order by f.fees_id;";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		return $query->result_array(); */
		$sql="select f.student_id,f.fees_paid_type,f.academic_year,f.fees_id,f.canc_charges,f.chq_cancelled, f.receipt_no, f.receipt_file, f.fees_date, f.bank_id, f.bank_city, f.amount as amt_paid,f.remark, f.college_receiptno from sf_fees_details as f where  f.type_id=2 and f.enrollment_no='".$data['enrollment_no']."' and f.is_deleted='N' order by f.fees_id;";
		$query = $this->db->query($sql);
		$res1=$query->result_array();
		
		$sql="SELECT f.student_id,f.refund_paid_type as fees_paid_type,f.academic_year,f.fees_id, f.receipt_no, f.receipt_file, f.refund_date as fees_date, f.bank_id, f.bank_city, f.amount as amt_paid,f.remark  FROM `sf_fees_refunds` as f 
		where f.enrollment_no='".$data['enrollment_no']."' and f.type_id=2 and  f.is_deleted='N' and f.academic_year='".$data['academic_year']."' ";
		
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		$res2=$query->result_array();
		
		return array_merge($res1,$res2);
	}
	
	// Insert payment installment
	function pay_Installment($data, $payfile)
	{
		$feedet['student_id']=$data['stud_id'];
		$feedet['enrollment_no']=$data['enrollment_no'];
		$feedet['amount']=$data['paidfee'];
		$feedet['type_id']=2;
		$feedet['fees_paid_type']=$data['payment_type'];
	//	$feedet['academic_year']= date('Y');
		$feedet['academic_year']=$data['acyear'];
		$feedet['receipt_no']=$data['dd_no'];
		//$feedet['fees_date']=$data['dd_date']; 
		if($data['dd_date']=='')
			$feedet['fees_date']=date('Y-m-d');
		else
			$feedet['fees_date']=$data['dd_date']; 
		
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
	
	public function updatePayment($sf_id,$data)
	{
		$where=array("sf_id"=>$sf_id);
		$this->db->where($where); 
		$this->db->update('sf_student_facilities', $data);
		//echo $this->db->last_query();exit;
		return true;
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
		$feedet['academic_year']=$data['acyear'];
				
		$feedet['receipt_no']=$data['edd_no'];
		$feedet['fees_date']=$data['edd_date']; 
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
		$where=array("fees_id"=>$fee_id);
		$this->db->where($where); 
		$this->db->update('sf_fees_details', $feedet);
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
	
}
?>