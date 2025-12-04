<?php
class Canteen_model extends CI_Model 
{
	function __construct()
    {
        
        parent::__construct();
    
    }

	public function get_canteen_detail($enrollment_no, $academic){
		$this->db->select('allocated_id, cs_id');
		$this->db->from('sf_student_facility_allocation');
		$this->db->where('enrollment_no', $enrollment_no);
		$this->db->where('academic_year', $academic);
		$this->db->where('sffm_id', "3");
		$query = $this->db->get(); 
		return $query->result_array();
	}

	public function get_canteen_allocated_students($canteen_id = 0, $prn = null, $meal_type = null) {
		$this->db->select('sfa.enrollment_no');
		
		if($canteen_id != 0) {
			// Fetch specific canteen allocations
			$this->db->select('c.cName as canteens');
			$this->db->where('allocated_id', $canteen_id);
		} else {
			// Fetch allocations for all canteens with GROUP_CONCAT, ordered by cs_id (meal type)
			$this->db->select('GROUP_CONCAT(c.cName ORDER BY sfa.cs_id ASC SEPARATOR ", ") as canteens');
		}
		
		// Base query with join and filtering by sffm_id
		$this->db->from('sf_student_facility_allocation as sfa');
		$this->db->join('canteens as c', 'c.id = sfa.allocated_id');
		$this->db->where('sfa.sffm_id', "3");
	
		// Apply additional filters
		if ($prn != null) {
			$this->db->where('sfa.enrollment_no', $prn);
		}
		if ($meal_type != null && $meal_type != 0) {
			$this->db->where('sfa.cs_id', $meal_type);
		}
	
		$this->db->group_by('sfa.enrollment_no');
		
		// Execute the query and return the results
		$query = $this->db->get();
		return $query->result_array();
	}

	
	 function search_canteen_students_data($data){
		
		$first= substr($data['prn'],0,5);
		 $pos=strpos($data['prn'],"SUN");
		if($data['org']=="All"){
	   $this->db->select("sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,
	   sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,
	   sandipun_ums.student_master.admission_stream,sandipun_ums.vw_stream_details.stream_short_name as stream_name,
	   sandipun_ums.vw_stream_details.course_name,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facilities.*,
	   sandipun_erp.sf_student_facility_allocation.f_alloc_id,sandipun_erp.sf_student_facility_allocation.is_active,
	   sandipun_erp.sf_student_facility_allocation.allocated_id,,sandipun_ums.student_master.academic_year as sacademic_year");
	   $this->db->from("sandipun_ums.student_master");
	   $this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
			
		   if( isset($data['cancel']) && $data['cancel']=="cancel" )
		   $this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no_new = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='Y' and sandipun_erp.sf_student_facilities.sffm_id='1'");
	   else
		   $this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no_new = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='N' and sandipun_erp.sf_student_facilities.sffm_id='1'");
		   
		   $this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\' and sandipun_erp.sf_student_facility_allocation.sffm_id=\'3\' ','left');
   
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
		   $dataa= $query->result_array();
		}
		else if($data['org']=="SU" ) // && !$pos
	   {
		   $this->db->select("sandipun_ums.student_master.*,sandipun_erp.sf_student_facilities.*,
		   sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name,
		   sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facility_allocation.f_alloc_id,
		   sandipun_erp.sf_student_facility_allocation.is_active,sandipun_erp.sf_student_facility_allocation.allocated_id,sandipun_ums.student_master.academic_year as sacademic_year");
   
		   $this->db->from("sandipun_ums.student_master");
   
			$this->db->join("sandipun_ums.vw_stream_details", 
			"sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
			
		   $this->db->join("sandipun_erp.sf_student_facilities",
			"sandipun_ums.student_master.enrollment_no_new = sandipun_erp.sf_student_facilities.enrollment_no
			  OR sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no
			  AND sandipun_ums.student_master.stud_id = sandipun_erp.sf_student_facilities.student_id");
		   
		   $this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\' and sandipun_erp.sf_student_facility_allocation.sffm_id=\'3\'','left');
	   
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
		   if( isset($data['cancel']) && $data['cancel']=="cancel" ){
			   $this->db->where("sandipun_erp.sf_student_facilities.cancelled_facility",'Y');
		   }else{
			   $this->db->where("sandipun_erp.sf_student_facilities.cancelled_facility",'N');
		   }
		   $this->db->where("sandipun_erp.sf_student_facilities.sffm_id",1);	
		   $this->db->order_by("sandipun_erp.sf_student_facilities.created_on", 'desc');
		 $query = $this->db->get();
	   //echo $this->db->last_query();//exit();
			$dataa=$query->result_array();
			 // $data['organisation']="SU";
	   }
   		elseif(($data['org']=="SF-SIJOUL")||($data['org']=="SF")){
	   $this->db->select("sandipun_ums_sijoul.student_master.*,sandipun_erp.sf_student_facilities.*,
		   sandipun_ums_sijoul.vw_stream_details.stream_short_name as stream_name,sandipun_ums_sijoul.vw_stream_details.course_name,
		   sandipun_ums_sijoul.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facility_allocation.f_alloc_id,
		   sandipun_erp.sf_student_facility_allocation.is_active,sandipun_erp.sf_student_facility_allocation.allocated_id,sandipun_ums_sijoul.student_master.academic_year as sacademic_year");
   
		   $this->db->from("sandipun_ums_sijoul.student_master");
   
			$this->db->join("sandipun_ums_sijoul.vw_stream_details", 
			"sandipun_ums_sijoul.student_master.admission_stream = sandipun_ums_sijoul.vw_stream_details.stream_id");
			
		   $this->db->join("sandipun_erp.sf_student_facilities",
			"sandipun_ums_sijoul.student_master.enrollment_no_new = sandipun_erp.sf_student_facilities.enrollment_no
			  OR sandipun_ums_sijoul.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no");
		   
		   $this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\' and sandipun_erp.sf_student_facility_allocation.sffm_id=\'3\'','left');
	   
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
		   $this->db->where("sandipun_ums_sijoul.vw_stream_details.school_short_name",$data['institute']);
		   }
		   if( isset($data['cancel']) && $data['cancel']=="cancel" ){
			   $this->db->where("sandipun_erp.sf_student_facilities.cancelled_facility",'Y');
		   }else{
			   $this->db->where("sandipun_erp.sf_student_facilities.cancelled_facility",'N');
		   }
		   $this->db->where("sandipun_erp.sf_student_facilities.sffm_id",1);	
		   $this->db->order_by("sandipun_erp.sf_student_facilities.created_on", 'desc');
		 $query = $this->db->get();
	   //echo $this->db->last_query();//exit();
			$dataa=$query->result_array();
		   // print_r($dataa);
		   if(empty($dataa)){
			   $this->db->select("sm.student_id as stud_id,sm.organization,sm.stream as stream_name, 
		   sm.course as course_name, sm.instute_name as school_name,sm.academic_year,sm.enrollment_no,
		   sm.first_name,sm.middle_name,sm.last_name,sfa.f_alloc_id,sfa.allocated_id,sfa.is_active,sm.academic_year as sacademic_year,ssf.*,");
		   $this->db->from("sf_student_master sm");
						   
		   //$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		   
		   $this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no AND  ssf.student_id=sm.student_id and ssf.sffm_id="1"','left');
		   
		   $this->db->join('sf_student_facility_allocation as sfa',
		   'ssf.sf_id = sfa.sf_id and sfa.sffm_id=ssf.sffm_id and sfa.is_active="Y"','left');
		   
		   $this->db->where("ssf.organisation",$data['org']);
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
		   
		   if($data['acyear']!='')
		   {
		   $this->db->where("ssf.academic_year",$data['acyear']);
		   } 
		   if( isset($data['cancel']) && $data['cancel']=="cancel" ){
			   $this->db->where("ssf.cancelled_facility",'Y');
		   }else{
			   $this->db->where("ssf.cancelled_facility",'N');
		   }
		   $this->db->where("ssf.sffm_id",1);	
		   $this->db->order_by("ssf.created_on", 'desc');
   
		   $result = $this->db->get();
   
		   //echo $this->db->last_query();
		   $dataa=$result->result_array();   
			   }
   		}elseif(($data['org']=="SF-SIJOUL")&&(empty($dataa))){
	   
		   
				  
		   $this->db->select("sm.student_id as stud_id,sm.organization,sm.stream as stream_name, 
		   sm.course as course_name, sm.instute_name as school_name,sm.academic_year,sm.enrollment_no,
		   sm.first_name,sm.middle_name,sm.last_name,sfa.f_alloc_id,sfa.allocated_id,sfa.is_active,ssf.academic_year as sacademic_year,ssf.*,");
		   $this->db->from("sf_student_master sm");
						   
		   //$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
		   
		   $this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.sffm_id="1" AND ssf.academic_year="'.$data['acyear']."'",'left');
		   
		   $this->db->join('sf_student_facility_allocation as sfa',
		   'ssf.sf_id = sfa.sf_id and sfa.sffm_id=ssf.sffm_id and sfa.is_active="Y"','left');
		   
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
		   $this->db->where("sm.academic_year",$data['acyear']);
		   //AND sm .`academic_year` = '2021'
		   //if( isset($data['cancel']) && $data['cancel']=="cancel" )
		   // $this->db->where("ssf.cancelled_facility",'Y');
		   //else
			$this->db->where("ssf.cancelled_facility",'N');
   
		   //$this->db->where("sfa.is_active",'Y');
   
   
		   $result = $this->db->get();
   
		   //echo $this->db->last_query();
		   $dataa=$result->result_array();   
		   //	  $data['organisation']="SF";
	   }
	   //var_dump($data);
   
	   return $dataa;
		  
 
		
	}

	public function get_all_canteens_with_student_count() {
		$this->db->select('
			canteens.id,
			canteens.cName,
			canteens.cPhone,
			COUNT(DISTINCT CASE WHEN sfa.cs_id = 1 THEN sfa.enrollment_no END) as breakfast_count,
			COUNT(DISTINCT CASE WHEN sfa.cs_id = 2 THEN sfa.enrollment_no END) as lunch_count,
			COUNT(DISTINCT CASE WHEN sfa.cs_id = 3 THEN sfa.enrollment_no END) as dinner_count
		');
		
		$this->db->from('canteens');
		
		// Perform a LEFT JOIN on the allocation table only once
		$this->db->join('sf_student_facility_allocation as sfa', 'canteens.id = sfa.allocated_id AND sfa.sffm_id = 3', 'left');
		
		// Group by canteen ID
		$this->db->group_by('canteens.id');
		
		$query = $this->db->get();
		return $query->result_array();
	}
		
	public function get_canteen_student_count($canteen_id) {
		$this->db->select('
			COUNT(DISTINCT CASE WHEN cs_id = 1 THEN enrollment_no END) AS breakfast_count,
			COUNT(DISTINCT CASE WHEN cs_id = 2 THEN enrollment_no END) AS lunch_count,
			COUNT(DISTINCT CASE WHEN cs_id = 3 THEN enrollment_no END) AS dinner_count
		');
		$this->db->where('sffm_id', 3);
		$this->db->where('is_active', 'Y');
		$this->db->where('allocated_id', $canteen_id);
		
		$query = $this->db->get('sf_student_facility_allocation');
		
		// Fetch the result as an associative array
		$result = $query->row_array();
		
		// Return counts for each slot or 0 if no data found
		return [
			'breakfast_count' => isset($result['breakfast_count']) ? (int)$result['breakfast_count'] : 0,
			'lunch_count' => isset($result['lunch_count']) ? (int)$result['lunch_count'] : 0,
			'dinner_count' => isset($result['dinner_count']) ? (int)$result['dinner_count'] : 0
		];
	}
	

	public function get_all_canteen_slot_price_detail(){
		$sql = "SELECT 
				    csp.canteen_id,
				    c.cName,

				    -- Breakfast Slot and Price
				    MAX(CASE WHEN csp.canteen_mtype = 'B' THEN CONCAT(csp.from_time, ' - ', csp.to_time) END) AS breakfast_slot,
				    MAX(CASE WHEN csp.canteen_mtype = 'B' THEN csp.price END) AS breakfast_price,

				    -- Lunch Slot and Price
				    MAX(CASE WHEN csp.canteen_mtype = 'L' THEN CONCAT(csp.from_time, ' - ', csp.to_time) END) AS lunch_slot,
				    MAX(CASE WHEN csp.canteen_mtype = 'L' THEN csp.price END) AS lunch_price,

				    -- Dinner Slot and Price
				    MAX(CASE WHEN csp.canteen_mtype = 'D' THEN CONCAT(csp.from_time, ' - ', csp.to_time) END) AS dinner_slot,
				    MAX(CASE WHEN csp.canteen_mtype = 'D' THEN csp.price END) AS dinner_price

				FROM 
				    canteen_slots_price AS csp
				JOIN 
				    canteens AS c ON csp.canteen_id = c.id
				GROUP BY 
				    csp.canteen_id;";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_canteen_breakfast_slot_price_detail($canteen_id){
		$this->db->from('canteen_slots_price');
		$this->db->where('canteen_id', $canteen_id);
		$this->db->where('canteen_mtype', 'B');
		$query = $this->db->get();
		return $query->row_array();

	}
	public function get_canteen_lunch_slot_price_detail($canteen_id){
		$this->db->from('canteen_slots_price');
		$this->db->where('canteen_id', $canteen_id);
		$this->db->where('canteen_mtype', 'L');
		$query = $this->db->get();
		return $query->row_array();
	}
	public function get_canteen_dinner_slot_price_detail($canteen_id){
		$this->db->from('canteen_slots_price');
		$this->db->where('canteen_id', $canteen_id);
		$this->db->where('canteen_mtype', 'D');
		$query = $this->db->get();
		return $query->row_array();
	}

	public function delete_canteen_slot_price($meal_type, $canteen_id) {
		$meals = [
			'1' => 'B',
			'2' => 'L',
			'3' => 'D'
		];

		// print_r($meals[$meal_type]); die;
	
		$isDeleted = false;
	
		if($meal_type == 0) {
			foreach ($meals as $key => $value) {
				$this->db->where('canteen_id', $canteen_id);
				$this->db->where('canteen_mtype', $value);
				$this->db->delete('canteen_slots_price');
				
				// Check if any rows were deleted and update the flag
				if($this->db->affected_rows() > 0) {
					$isDeleted = true;
				}
			}
		} else {
			$this->db->where('canteen_id', $canteen_id);
			$this->db->where('canteen_mtype', $meals[$meal_type]);
			$this->db->delete('canteen_slots_price');
			
			// Check if any rows were deleted
			$isDeleted = $this->db->affected_rows() > 0;
		}
	
		return $isDeleted;
	}
	

    public function get_all_canteens(){
		$this->db->select('*');
		$this->db->from('canteens');
		$query = $this->db->get(); 
		return $query->result_array();
	}

	public function get_canteen($canteen_id){
		$this->db->select('*');
		$this->db->from('canteens');
		$this->db->where('id', $canteen_id);
		$query = $this->db->get(); 
		return $query->row_array();
	}

	public function get_canteen_name($canteen_id){
		$this->db->select('cName');
		$this->db->from('canteens');
		$this->db->where('id', $canteen_id);
		$query = $this->db->get(); 
		return $query->row_array();
	}

	public function get_canteen_id($cName = ''){
		$this->db->select('id');
		$this->db->from('canteens');
		$this->db->where('cName', $cName);
		$query = $this->db->get(); 
		$row = $query->row(); // Get the row as an object
	
		// Return the 'id' field directly if the row exists
		return $row ? $row->id : 0;
	}

	public function update_breakfast_slot_detail($canteen_id, $breakfast_from_time,$breakfast_to_time,$breakfast_price){
		$data = array(
			'from_time' => $breakfast_from_time,
			'to_time' => $breakfast_to_time,
			'price' => $breakfast_price
		);
		
		$this->db->where('canteen_id', $canteen_id);
		$this->db->where('canteen_mtype', 'B');
		$this->db->update('canteen_slots_price', $data);
		
		return $this->db->affected_rows() > 0;
	}

	public function update_lunch_slot_detail($canteen_id, $lunch_from_time, $lunch_to_time, $lunch_price) {
		$data = array(
			'from_time' => $lunch_from_time,
			'to_time' => $lunch_to_time,
			'price' => $lunch_price
		);
		
		$this->db->where('canteen_id', $canteen_id);
		$this->db->where('canteen_mtype', 'L');
		$this->db->update('canteen_slots_price', $data);
		
		return $this->db->affected_rows() > 0;
	}

	public function update_dinner_slot_detail($canteen_id, $dinner_from_time, $dinner_to_time, $dinner_price) {
		$data = array(
			'from_time' => $dinner_from_time,
			'to_time' => $dinner_to_time,
			'price' => $dinner_price
		);
		
		$this->db->where('canteen_id', $canteen_id);
		$this->db->where('canteen_mtype', 'D');
		$this->db->update('canteen_slots_price', $data);
		
		return $this->db->affected_rows() > 0;
	}

	public function get_academic_details()
	{
		$sql="select * From sf_academic_year order by academic_year desc";
		$query = $this->db->query($sql);
		return  $query->result_array();
	}

	public function get_student_details($data)
	{
		//print_r($data['org']);
		if($data['org']=="SU" )
		{
			$this->db->select("sandipun_erp.sf_student_facilities.sf_id,sandipun_erp.sf_student_facilities.student_id,sandipun_erp.sf_student_facilities.deposit_fees,sandipun_erp.sf_student_facilities.actual_fees,sandipun_erp.sf_student_facilities.academic_year,sandipun_ums.vw_stream_details.stream_name,sandipun_ums.vw_stream_details.course_short_name,sandipun_ums.vw_stream_details.stream_short_name,sandipun_ums.vw_stream_details.school_name,sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.current_year,sandipun_ums.student_master.last_name,sandipun_erp.sf_student_facilities.enrollment_no,sandipun_ums.vw_stream_details.stream_code,");
			$this->db->from("sandipun_ums.student_master");

			$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
			
			//$this->db->join("sandipun_erp.sf_fees_details", "sandipun_ums.student_master.enrollment_no_new = sandipun_erp.sf_fees_details.enrollement_no");

			$this->db->join("sandipun_erp.sf_student_facilities", 
			"sandipun_erp.sf_student_facilities.sffm_id='1' AND
			 sandipun_ums.student_master.enrollment_no_new = sandipun_erp.sf_student_facilities.enrollment_no OR 
			 sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no");
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
		else if($data['org']=="SF-SIJOUL" )
		{
			$this->db->select("sandipun_erp.sf_student_facilities.sf_id,sandipun_erp.sf_student_facilities.student_id,sandipun_erp.sf_student_facilities.deposit_fees,sandipun_erp.sf_student_facilities.actual_fees,sandipun_erp.sf_student_facilities.academic_year,sandipun_ums_sijoul.vw_stream_details.stream_name,sandipun_ums_sijoul.vw_stream_details.course_short_name,sandipun_ums_sijoul.vw_stream_details.stream_short_name,sandipun_ums_sijoul.vw_stream_details.school_name,sandipun_ums_sijoul.student_master.first_name,sandipun_ums_sijoul.student_master.middle_name,sandipun_ums_sijoul.student_master.current_year,sandipun_ums_sijoul.student_master.last_name,sandipun_erp.sf_student_facilities.enrollment_no,sandipun_ums_sijoul.vw_stream_details.stream_code,");
			$this->db->from("sandipun_ums_sijoul.student_master");

			$this->db->join("sandipun_ums_sijoul.vw_stream_details", "sandipun_ums_sijoul.student_master.admission_stream = sandipun_ums_sijoul.vw_stream_details.stream_id");
			
			//$this->db->join("sandipun_erp.sf_fees_details", "sandipun_ums.student_master.enrollment_no_new = sandipun_erp.sf_fees_details.enrollement_no");

			$this->db->join("sandipun_erp.sf_student_facilities", 
			"sandipun_erp.sf_student_facilities.sffm_id='1' AND
			 sandipun_ums_sijoul.student_master.enrollment_no_new = sandipun_erp.sf_student_facilities.enrollment_no OR 
			 sandipun_ums_sijoul.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no");
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
	
	function fetch_student_data($prn,$acyear,$canteen_id)
	{
		
		$this->db->select("*");
		$this->db->from("sf_student_facility_allocation");
		// $this->db->where("enrollment_no",$prn);
		$this->db->where("academic_year",$acyear);
		$this->db->where("allocated_id", $canteen_id);
		$this->db->where("sffm_id",3);
		$this->db->where("is_active",'Y');
		 $result = $this->db->get();
		 //echo $this->db->last_query();
		  $data=$result->result_array();
		return $data;
	}

	public function allocated_list_export($data){
	
	
		$first= substr($data['prn'],0,5);
		  $pos=strpos($data['prn'],"SUN");
		 if($data['org']=="All"){
		$this->db->select("sandipun_ums.student_master.first_name,sandipun_ums.student_master.middle_name,sandipun_ums.student_master.last_name,
		sandipun_ums.student_master.enrollment_no,sandipun_ums.student_master.stud_id,
		sandipun_ums.student_master.admission_stream,sandipun_ums.vw_stream_details.stream_short_name as stream_name,
		sandipun_ums.vw_stream_details.course_name,sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facilities.*,
		sandipun_erp.sf_student_facility_allocation.f_alloc_id,sandipun_erp.sf_student_facility_allocation.is_active,
		sandipun_erp.sf_student_facility_allocation.allocated_id,,sandipun_ums.student_master.academic_year as sacademic_year");
		$this->db->from("sandipun_ums.student_master");
		$this->db->join("sandipun_ums.vw_stream_details", "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
			 
			if( isset($data['cancel']) && $data['cancel']=="cancel" )
			$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no_new = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='Y' and sandipun_erp.sf_student_facilities.sffm_id='1'");
		else
			$this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no_new = sandipun_erp.sf_student_facilities.enrollment_no and sandipun_erp.sf_student_facilities.cancelled_facility='N' and sandipun_erp.sf_student_facilities.sffm_id='1'");
			
			$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\' and sandipun_erp.sf_student_facility_allocation.sffm_id=\'3\'','left');
	
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
			$dataa= $query->result_array();
		 }
		 else if($data['org']=="SU" ) // && !$pos
		{
			$this->db->select("sandipun_ums.student_master.*,sandipun_erp.sf_student_facilities.*,
			sandipun_ums.vw_stream_details.stream_short_name as stream_name,sandipun_ums.vw_stream_details.course_name,
			sandipun_ums.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facility_allocation.f_alloc_id,
			sandipun_erp.sf_student_facility_allocation.is_active,sandipun_erp.sf_student_facility_allocation.allocated_id,sandipun_ums.student_master.academic_year as sacademic_year");
	
			$this->db->from("sandipun_ums.student_master");
	
			 $this->db->join("sandipun_ums.vw_stream_details", 
			 "sandipun_ums.student_master.admission_stream = sandipun_ums.vw_stream_details.stream_id");
			 
			$this->db->join("sandipun_erp.sf_student_facilities",
			 "sandipun_ums.student_master.enrollment_no_new = sandipun_erp.sf_student_facilities.enrollment_no
			   OR sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no");
			
			$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\' and sandipun_erp.sf_student_facility_allocation.sffm_id=\'3\'','left');
		
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
			if( isset($data['cancel']) && $data['cancel']=="cancel" ){
				$this->db->where("sandipun_erp.sf_student_facilities.cancelled_facility",'Y');
			}else{
				$this->db->where("sandipun_erp.sf_student_facilities.cancelled_facility",'N');
			}
			$this->db->where("sandipun_erp.sf_student_facilities.sffm_id",1);	
		  $query = $this->db->get();
		//echo $this->db->last_query();//exit();
			 $dataa=$query->result_array();
			  // $data['organisation']="SU";
		}
		elseif(($data['org']=="SF-SIJOUL")||($data['org']=="SF")){
		$this->db->select("sandipun_ums_sijoul.student_master.*,sandipun_erp.sf_student_facilities.*,
			sandipun_ums_sijoul.vw_stream_details.stream_short_name as stream_name,sandipun_ums_sijoul.vw_stream_details.course_name,
			sandipun_ums_sijoul.vw_stream_details.school_short_name as school_name,sandipun_erp.sf_student_facility_allocation.f_alloc_id,
			sandipun_erp.sf_student_facility_allocation.is_active,sandipun_erp.sf_student_facility_allocation.allocated_id,sandipun_ums_sijoul.student_master.academic_year as sacademic_year");
	
			$this->db->from("sandipun_ums_sijoul.student_master");
	
			 $this->db->join("sandipun_ums_sijoul.vw_stream_details", 
			 "sandipun_ums_sijoul.student_master.admission_stream = sandipun_ums_sijoul.vw_stream_details.stream_id");
			 
			$this->db->join("sandipun_erp.sf_student_facilities",
			 "sandipun_ums_sijoul.student_master.enrollment_no_new = sandipun_erp.sf_student_facilities.enrollment_no
			   OR sandipun_ums_sijoul.student_master.enrollment_no = sandipun_erp.sf_student_facilities.enrollment_no");
			
			$this->db->join('sandipun_erp.sf_student_facility_allocation','sandipun_erp.sf_student_facilities.sf_id = sandipun_erp.sf_student_facility_allocation.sf_id and sandipun_erp.sf_student_facility_allocation.is_active=\'Y\' and sandipun_erp.sf_student_facility_allocation.sffm_id=\'3\'','left');
		
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
			$this->db->where("sandipun_ums_sijoul.vw_stream_details.school_short_name",$data['institute']);
			}
			if( isset($data['cancel']) && $data['cancel']=="cancel" ){
				$this->db->where("sandipun_erp.sf_student_facilities.cancelled_facility",'Y');
			}else{
				$this->db->where("sandipun_erp.sf_student_facilities.cancelled_facility",'N');
			}
			$this->db->where("sandipun_erp.sf_student_facilities.sffm_id",1);	
		  $query = $this->db->get();
		//echo $this->db->last_query();//exit();
			 $dataa=$query->result_array();
			// print_r($dataa);
			if(empty($dataa)){
				$this->db->select("sm.student_id as stud_id,sm.organization,sm.stream as stream_name, 
			sm.course as course_name, sm.instute_name as school_name,sm.academic_year,sm.enrollment_no,
			sm.first_name,sm.middle_name,sm.last_name,sfa.f_alloc_id,sfa.allocated_id,sfa.is_active,sm.academic_year as sacademic_year,ssf.*,");
			$this->db->from("sf_student_master sm");
							
			//$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
			
			$this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.student_id=sm.student_id and ssf.sffm_id="1"','left');
			
			$this->db->join('sf_student_facility_allocation as sfa',
			'ssf.sf_id = sfa.sf_id and sfa.sffm_id=ssf.sffm_id and sfa.is_active="Y"','left');
			
			$this->db->where("ssf.organisation",$data['org']);
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
			
			//$this->db->where("sm.academic_year",$data['acyear']);
			//if( isset($data['cancel']) && $data['cancel']=="cancel" )
			// $this->db->where("ssf.cancelled_facility",'Y');
			//else
			 $this->db->where("ssf.cancelled_facility",'N');
	
			//$this->db->where("sfa.is_active",'Y');
	
	
			$result = $this->db->get();
	
			//echo $this->db->last_query();
			$dataa=$result->result_array();   
				}
		}elseif(($data['org']=="SF-SIJOUL")&&(empty($dataa))){
		
			
				   
			$this->db->select("sm.student_id as stud_id,sm.organization,sm.stream as stream_name, 
			sm.course as course_name, sm.instute_name as school_name,sm.academic_year,sm.enrollment_no,
			sm.first_name,sm.middle_name,sm.last_name,sfa.f_alloc_id,sfa.allocated_id,sfa.is_active,ssf.academic_year as sacademic_year,ssf.*,");
			$this->db->from("sf_student_master sm");
							
			//$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
			
			$this->db->join('sf_student_facilities as ssf','sm.enrollment_no = ssf.enrollment_no and ssf.sffm_id="1" AND ssf.academic_year="'.$data['acyear']."'",'left');
			
			$this->db->join('sf_student_facility_allocation as sfa',
			'ssf.sf_id = sfa.sf_id and sfa.sffm_id=ssf.sffm_id and sfa.is_active="Y"','left');
			
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
			$this->db->where("sm.academic_year",$data['acyear']);
			//AND sm .`academic_year` = '2021'
			//if( isset($data['cancel']) && $data['cancel']=="cancel" )
			// $this->db->where("ssf.cancelled_facility",'Y');
			//else
			 $this->db->where("ssf.cancelled_facility",'N');
	
			//$this->db->where("sfa.is_active",'Y');
	
	
			$result = $this->db->get();
	
			//echo $this->db->last_query();
			$dataa=$result->result_array();   
			//	  $data['organisation']="SF";
		}
		//var_dump($data);
	
		return $dataa;
		   
	}	

	public function get_month_name($month_number) {
    // Array of month names
    $months = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December'
    ];

    // Check if the passed month number is valid
    if (isset($months[$month_number])) {
        return strtoupper($months[$month_number]); // Return the month name
    } else {
        return 'Invalid month'; // Handle invalid input
    }
	}

	public function get_punching_data($year, $month,$machine_id, $canteen_slot_price_breakfast, $canteen_slot_price_lunch, $canteen_slot_price_dinner) {
	
		$breakfast_from_time = $canteen_slot_price_breakfast['from_time'];
		$breakfast_to_time = $canteen_slot_price_breakfast['to_time'];
		
		$lunch_from_time = $canteen_slot_price_lunch['from_time'];
		$lunch_to_time = $canteen_slot_price_lunch['to_time'];
		
		$dinner_from_time = $canteen_slot_price_dinner['from_time'];
		$dinner_to_time = $canteen_slot_price_dinner['to_time'];
		$this->db->select("
    	DATE(LogDate) AS punch_date,
    	COUNT(DISTINCT CASE WHEN TIME(LogDate) BETWEEN '$breakfast_from_time:00' AND '$breakfast_to_time:00' THEN UserId END) AS breakfast_present,
    	COUNT(DISTINCT CASE WHEN TIME(LogDate) BETWEEN '$lunch_from_time:00' AND '$lunch_to_time:00' THEN UserId END) AS lunch_present,
    	COUNT(DISTINCT CASE WHEN TIME(LogDate) BETWEEN '$dinner_from_time:00' AND '$dinner_to_time:00' THEN UserId END) AS dinner_present
 		");
		
		$this->db->from('punching_log');
		
		// Filter for specific year and month
		$this->db->where('YEAR(LogDate)', $year);
		$this->db->where('MONTH(LogDate)', $month);
		$this->db->where('DeviceId', $machine_id); //TODO: add a where clause to filter by machine ID
		
		// Subquery to get the earliest punch time for each student for the specific date
		$this->db->group_start();
		$this->db->where('LogDate IN (
		    SELECT MIN(LogDate) 
		    FROM punching_log AS pb
		    WHERE DATE(pb.LogDate) = DATE(punching_log.LogDate)
		    AND pb.UserId = punching_log.UserId
		    GROUP BY pb.UserId
		)');
		$this->db->group_end();
		
		$this->db->group_by('DATE(LogDate)');
		$this->db->order_by('punch_date', 'ASC');
		
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query->result_array(); // Fetch as an array of results
		return $result;


	}
	public function get_student_id($canteen_id){
		$this->db->select('student_id');
		$this->db->from('sf_student_facilities');
		$this->db->where('enrollment_no',$canteen_id);
		//$this->db->where('organisation', 'SU');
		$this->db->where('academic_year', '2024');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->row_array();
	}



}