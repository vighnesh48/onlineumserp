<?php
class Guide_allocation_phd_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		$DB1 = $this->load->database('umsdb', TRUE);
    }
        function load_streams_student_list()
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
        //$acd_yr =explode('-', $_POST['academic_year']);
		$sql="SELECT vw.stream_id,vw.stream_name,vw.stream_short_name FROM student_master s left join vw_stream_details vw on s.admission_stream=vw.stream_id where s.admission_cycle='".$_POST['admission_cycle']."' and vw.course_id='".$_POST['course_id']."'  and s.cancelled_admission ='N'";
		
		if(!empty($_POST['school_code'])){
			$sql .=" AND vw.school_code ='".$_POST['school_code']."'";
		}
        
        if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND vw.school_code = $sccode";
			}
		$sql .=" group by s.admission_stream";
        $query = $DB1->query($sql);
		return $stream_details =  $query->result_array();  
    }

   function load_semester_subjects()
    { 
        $DB1 = $this->load->database('umsdb', TRUE);    
        //$acd_yr =explode('-', $_POST['academic_year']);
		$sql="SELECT s.current_semester as semester FROM student_master s  where s.admission_cycle='".$_POST['admission_cycle']."' and s.admission_stream='".$_POST['stream_id']."' and s.cancelled_admission ='N' and s.is_detained='N' group by s.current_semester";
        
        $query = $DB1->query($sql);
		return $stream_details =  $query->result_array();  
    }	
	// fetch student list
	function  get_stud_list($stream_id='', $semester='',$acyear='',$admission_cycle='')
    {

        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        if($semester=='1' || $semester=='2'){
	        if($stream_id ==9){
				$where.=" AND sm.admission_stream in(5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162)";	
			}else{
				$where.=" AND sm.admission_stream='".$stream_id."'";
			}
			/*else if($stream_id ==103 || $stream_id ==104){
				$where.=" AND sm.admission_stream in(43,44,45,46,47)";
			}*/
		}else{
			$where.=" AND sm.admission_stream='".$stream_id."'";
		}
		if($stream_id=="71")
        {
            $where.=" AND sm.cancelled_admission ='N'  AND sm.is_detained ='N' and sm.current_year='".$semester."' and sm.admission_cycle ='".$admission_cycle."'";
        }else
        {
            $where.=" AND sm.cancelled_admission ='N' AND sm.is_detained ='N' and sm.current_semester='".$semester."' and sm.admission_cycle ='".$admission_cycle."'";
        }
        $sql="SELECT sm.*, std.stream_name FROM `student_master` as sm left join stream_master std on std.stream_id=sm.admission_stream $where ";
		$sql.=" order by sm.enrollment_no";
		//echo $sql;exit;
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	// fetch subject list
	function  get_sub_list($stream_id='', $semester='', $batch='')
    {		
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE is_active ='Y' and batch ='$batch'";  
        
        if($stream_id!="")
        {
            $where.=" AND stream_id='".$stream_id."'";
        }
        
		if($semester!="")
        {
            $where.=" AND semester='".$semester."'";
        }

        $sql="SELECT * FROM `subject_master` $where";
        $query = $DB1->query($sql);
        return $query->result_array();
    }

	// fetch subject list
	function  get_stream_mapping_tot_subject($stream_id, $semester, $batch)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        
        if($stream_id!="")
        {
           $where.=" AND stream_id='".$stream_id."'";
        }        
		if($semester!="")
        {
           $where.=" AND semester='".$semester."' AND batch='".$batch."'";
        }
        $sql="SELECT * FROM `stream_mapping` $where";
        $query = $DB1->query($sql);
        return $query->result_array();
    }	
	
	 // get unique student list of allocated subject
	 function get_allcated_studlist($stream_id, $semester, $academic_year, $batch){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE 1=1 ";  
		
        if($semester!="")
        {
           $where.=" AND sas.stream_id='".$stream_id."' and sas.semester = '".$semester."' and sas.academic_year='$academic_year' ";//and sm.batch='".$batch."'
        }	
		
		$sql="SELECT distinct sas.stud_id FROM `student_applied_subject` as sas left join subject_master sm on sm.sub_id=sas.subject_id $where";
        $query = $DB1->query($sql);
        return $query->result_array();
	  }
	  
	 	function get_faculty_list() {			
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select emp_reg_id,emp_id, CONCAT(fname, ' ', mname, ' ', lname) AS fac_name,department_name,designation_name from vw_faculty order by fname";
		$query = $DB1->query($sql);
		$stream_details = $query->result_array();
		return $stream_details;
      } 
	
	public function insert_guide($val)
	{  
		$DB1 = $this->load->database('umsdb', TRUE);
		$faculty_det=explode(',',$val[faculty]);
		   foreach($val['chk_stud'] as $row){
        $stud_det=$this->fetch_stud_det($row);	
		$data['student_id']=$row;
		$data['enrollment_no']=$stud_det['enrollment_no'];
		$data['student_name']=$stud_det['first_name'].' '.$stud_det['middle_name'].' '.$stud_det['last_name'];
		$data['guide_id']=$faculty_det[0];
		$data['guide_name']=$faculty_det[1];
		$data['created_by']=$this->session->userdata("uid");
		$data['created_on']=date("Y-m-d H:i:s");
        $DB1->insert("guide_assign_to_student", $data);    
		}
		return $DB1->insert_id();
	}
	public function fetch_stud_det($stud_id='')
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('enrollment_no,first_name,middle_name,last_name');
		$DB1->from('student_master');
		$DB1->where('stud_id',$stud_id);
		$query=$DB1->get();
		return $query->row_array();
	}
	
	public function get_allcated_guidelist()
	{
        $guide_id=$this->session->userdata('aname');	  
        $role_id=$this->session->userdata('role_id');	  
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('g.*');
		$DB1->select('t.upload_file,t.status,t.type');
		$DB1->from('guide_assign_to_student g');
		$DB1->join('topic_approval_details t'," g.student_id = t.student_id and t.type = 'RPS-5'",'left');
		if($role_id!=6 && $role_id!=23){
		$DB1->where('g.guide_id',$guide_id);
		}
		$DB1->order_by('g.id','desc');	
		$query=$DB1->get();		
		
		return $query->result_array();
	}
	
	
			public function fetch_guide_det($guide_id='',$stud_id='',$type='')
	{
		 if($guide_id==''){
            $guide_id=$this->session->userdata('aname');	  	
		 }		
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('g.guide_id,g.guide_name');
		$DB1->select('gb.bid,gb.acc_holder_name,gb.acc_no,gb.ifsc_code,gb.branch,gb.bank_id,gb.cheque_file');
		$DB1->select('b.bank_name');
		$DB1->select('em.mobileNumber');
		if($type!="" && $stud_id !='' ){
			 $DB1->select('ph.amount,ph.renumeration,ph.travelling_allowance,ph.designation');	
			}
		$DB1->from('sandipun_ums.guide_assign_to_student g');
		$DB1->join('sandipun_ums.guide_bank_details gb'," g.guide_id = gb.guide_id",'left');
		$DB1->join('sandipun_ums.bank_master as b','gb.bank_id=b.bank_id','left');
		$DB1->join('sandipun_erp.employe_other_details as em','g.guide_id=em.emp_id','left');
		if($type!="" && $stud_id !='' ){
			$DB1->join('phd_renumeration_details as ph','g.guide_id=ph.emp_code','left');	
			$DB1->where('ph.student_id',$stud_id);	
			$DB1->where('ph.type',$type);	
			}
		$DB1->where('g.guide_id',$guide_id);
		if($type!="" && $stud_id !='' ){
			$DB1->group_by('g.guide_id');
			}
		$query=$DB1->get();	
		
		return $query->row_array();
	}
	
	

	 public function fetch_guide_student_view($val='')
	  {
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id=$this->session->userdata('role_id');	
		$DB1->select('g.*');
		$DB1->select('t.upload_file,t.status,t.type');
		$DB1->from('guide_assign_to_student g');
		$DB1->join('student_master sm','g.student_id=sm.stud_id','left');
		$DB1->join('topic_approval_details t'," g.student_id = t.student_id and t.type = 'RPS-5'",'left');
		$DB1->where('sm.admission_cycle',$val['cycle']);
		if($val['dept_id']!=''){
		$DB1->where('sm.admission_stream',$val['dept_id']);
		}
		if($role_id!=23){
		$DB1->where('g.guide_id',$guide_id);
		}
		$DB1->order_by('g.id','desc');	
		$query=$DB1->get();
		return $query->result_array(); 
	  }
	  
	 
	 
	 public function insert_topic_approval_files($val, $appr_files)
{
    $DB1 = $this->load->database('umsdb', TRUE);
    $um_id = $this->session->userdata("uid");
    $roles_id = $this->session->userdata("role_id");
    
    // Initialize data array
    $sdata = [
        'student_id' => $val['student_id'],
        'type' => $val['type'],
        'entry_by' => $um_id,
        'entry_on' => date('Y-m-d H:i:s'),
        'upload_file' => $appr_files['guide_file'],
        'status' => 'N'
    ];
    
    // Set semester based on type if role_id is 23
    if ($roles_id == 23) {
       $semesters = [
            'guide_allot_letter' => 1,
            'rac_topic_file' => 1,
            'pre_thesis' => 6,
            'course_work' => 1,
            'RPS-1' => 2,
            'RPS-2' => 3,
            'RPS-3' => 4,
            'RPS-4' => 5,
            'RPS-5' => 6,
			'RPS-6' => 7,
			'RPS-7' => 8,
			'RPS-8' => 9,
			'RPS-9' => 10
        ];

        // Assign semester if type matches one of the predefined types
        if (array_key_exists($val['type'], $semesters)) {
            $sdata['semester'] = $semesters[$val['type']];
        } else {
            $sdata['semester'] = $val['semester'];
        }
    } else {
        $sdata['semester'] = $val['semester'];
    }

    // Insert data into the database and return the insert ID
    $DB1->insert('topic_approval_details', $sdata);
    return $DB1->insert_id();
}

	   public function update_topic_approval_files($val,$appr_files)
	 {	
		 $DB1 = $this->load->database('umsdb', TRUE);
		 //$stud_id=$this->session->userdata("aname");
		 $um_id=$this->session->userdata("uid");
		 $sdata['upload_file']=$appr_files['guide_file']; 
		 $sdata['updated_by']=$um_id;
		 $sdata['updated_on']=date('Y-m-d H:i:s');
		 $DB1->where('student_id',$val['student_id']);	 
		 $DB1->where('type',$val['type']);	 
		 $query=$DB1->update('topic_approval_details',$sdata);	
		 return $query;
	 }
 
	  	 public function fetch_sem_det($stud_id='')
	 {
		$DB1 = $this->load->database('umsdb', TRUE);
		$stud_det=$this->session->userdata("aname");
		$DB1->select('s.current_semester,g.*');
		$DB1->select('vw.school_name,vw.stream_short_name as stream_name');
		$DB1->from('student_master s');
		$DB1->join('guide_assign_to_student g','g.enrollment_no=s.enrollment_no','left');
		$DB1->join('vw_stream_details vw','s.admission_stream=vw.stream_id','left');
		if($stud_id!=''){
		$DB1->where('stud_id',$stud_id);
		}else
		{
		  $DB1->where('stud_id',$stud_det);	
		}
		$query=$DB1->get();
		return $query->row_array();  
	 }
	 
	 
	 
	 public function fetch_doc_det($stud_id='',$type='')
	 {
	    $DB1 = $this->load->database('umsdb', TRUE);
		if($stud_id=='') {
		$stud_id = $this->session->userdata("aname");
		}
		$DB1->select('*');
		$DB1->from('topic_approval_details');
		$DB1->where('student_id', $stud_id);
		if($type == 'RPS') {
		$DB1->where_in('type', ['course_work', 'RPS-1', 'RPS-2', 'RPS-3', 'RPS-4', 'RPS-5', 'RPS-6', 'RPS-7', 'RPS-8', 'RPS-9']);
		///$DB1->group_by('semester');
		}
		$query = $DB1->get();
		//echo $DB1->last_query();exit;
		return $query->result_array();
    }
 
	  public function fetch_doc_det_files($stud_id='')
	 {
		$DB1 = $this->load->database('umsdb', TRUE);
		$stud_det=$this->session->userdata("aname");
		$DB1->select('student_id, type, GROUP_CONCAT(files_uploaded) AS upload_files');
		$DB1->from('topic_approval_det_files');
		$DB1->where('student_id',$stud_id);
		if($stud_id!=''){
		$DB1->where('student_id',$stud_id);
		}else
		{
		  $DB1->where('student_id',$stud_det);	
		}
		$DB1->group_by('student_id, type');
		$query=$DB1->get();
		return $query->result_array(); 
	 }
   public function fetch_stud_doc_details($stud_id='')
   {
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('t.*');
		$DB1->select('g.enrollment_no,g.student_name');
		$DB1->from('topic_approval_details t');
		$DB1->join('guide_assign_to_student g','t.student_id=g.student_id','left');
		$DB1->where('t.student_id',$stud_id);
		$DB1->order_by('t.semester','desc');
		$query=$DB1->get();
		return $query->result_array();
   }
   
   public function fetch_phd_renum_det($stud_id='')
   {
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('*');
		$DB1->from('phd_renumeration_details');
		$DB1->where('student_id',$stud_id);
		$query=$DB1->get();
		return $query->result_array(); 
   }

	   
		public function change_topic_approval_status($id,$status)
   {
		 $DB1 = $this->load->database('umsdb', TRUE);
		 //$type="RPS-".$sem;
		 $sdata=array(
		 'status'=>$status,
		 );
		 //$DB1->where('student_id',$stud_id);	
		 $DB1->where('id',$id);	
		 $query=$DB1->update('topic_approval_details',$sdata);
		 //echo $DB1->last_query();exit;
		 return $query;
   }

   public function check_sem_wise_entry($val)
{
    $DB1 = $this->load->database('umsdb', TRUE);
    $stud_id = $val['student_id'];
    if ($stud_id == '') {
        $stud_id = $this->session->userdata("aname");
    }

    $semesters = [
        'guide_allot_letter' => 1,
        'rac_topic_file' => 1,
        'pre_thesis' => 6,
        'course_work' => 1,
        'RPS-1' => 2,
        'RPS-2' => 3,
        'RPS-3' => 4,
        'RPS-4' => 5,
        'RPS-5' => 6,
        'RPS-6' => 7,
        'RPS-7' => 8,
        'RPS-8' => 9,
        'RPS-9' => 10
    ];

    $DB1->select('*');
    $DB1->from('topic_approval_details');

    // Use mapped semester if type exists in the mapping
    if (isset($semesters[$val['type']])) {
        $DB1->where('semester', $semesters[$val['type']]);
    } else {
        $DB1->where('semester', $val['semester']);
    }

    $DB1->where('student_id', $stud_id);
    $DB1->where('type', $val['type']);

    $query = $DB1->get();
    return $query->num_rows();
}

   public function fetch_department($val)
   {	   
		$DB1 = $this->load->database('umsdb', TRUE);
		$stud_id=$this->session->userdata("aname");
		$DB1->select('DISTINCT(s.admission_stream)');
		$DB1->select('st.stream_name');
		$DB1->from('student_master s');
		$DB1->join('stream_master st','st.stream_id=s.admission_stream','left');
		$DB1->where('s.admission_session!=','');
		$DB1->where('s.admission_cycle',$val['cycle']);
		$DB1->order_by('st.stream_name');
		$query=$DB1->get();
		return $query->result_array();
   }
   
   public function check_renumdata_entry($val)
   {
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('*');
		$DB1->from('guide_phd_renumeration');
		$DB1->where('student_id',$val['student_id']);
		$DB1->where('file_type',$val['type']);	
		$DB1->where('approval_copy_file!=','');	
		$DB1->where('final_approval_copy!=','');
		$query=$DB1->get();
		return $query->num_rows();
   }
   
   public function insert_renum_files($val,$appr_files)
	 {	 
		 $DB1 = $this->load->database('umsdb', TRUE);
		 $stud_id=$this->session->userdata("aname");
		 $um_id=$this->session->userdata("uid");
		 $sdata['student_id']=$val['student_id'];
		 $sdata['enrollment_no']=$val['enrollment_no'];
		 $sdata['conduction_date']=$val['cond_date'];
		 $sdata['file_type']=$val['type'];
		 $sdata['internal_id']=$val['internal_id'];
		 $sdata['external']=implode(',', $val['external_code']);
		 if($appr_files['approval_copy_file']!=''){
		 $sdata['approval_copy_file']=$appr_files['approval_copy_file'];
		 }
		 if($appr_files['final_approval_copy']!=''){
		 $sdata['final_approval_copy']=$appr_files['final_approval_copy'];
		 }
		  if($val['gid']!=''){
		 $sdata['updated_by']=$um_id;
		 $sdata['updated_on']=date('Y-m-d H:i:s');
		 $DB1->where('gid',$val['gid']);
		 $svg=$DB1->update('guide_phd_renumeration',$sdata);
          if($svg){
			 return 1;   
		  }else{ return 0;}		 
		 }else{

		 $sdata['entry_by']=$um_id;
		 $sdata['entry_on']=date('Y-m-d H:i:s');
		 $DB1->insert('guide_phd_renumeration',$sdata);	
		 return $DB1->insert_id(); 
		 }
	
   }
  
    public function fetch_phd_renum_amount($desig='',$type='')
		 {
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->from('phd_renumeration_amount');
			if($desig!=''){
			$DB1->where('designation', $desig);
			}
			if($type!=''){
			$DB1->where('type', $type);
			}
			$DB1->where('status','Y');
			$query = $DB1->get();
			if($desig!=''){
			return $query->row();
			}else
			{
			  return $query->result_array();	
			}
		}

   public function fetch_doc_det_rps($stud_id='',$type='')
		 {
			$DB1 = $this->load->database('umsdb', TRUE);
			if($stud_id==''){
			 $stud_id = $this->session->userdata("aname");
			}
			if($type=='2')
			{
			  $DB1->select('file_type');
			}else
			{
			   $DB1->select('*');
			}
		
			$DB1->from('guide_phd_renumeration');
			$DB1->where('student_id', $stud_id);
			$DB1->where_in('file_type', ['course_work', 'RPS-1', 'RPS-2', 'RPS-3', 'RPS-4', 'RPS-5', 'RPS-6', 'RPS-7', 'RPS-8', 'RPS-9']);
			$query = $DB1->get();
			return $query->result_array();
		}

 public function fetch_renum_det($stud_id)
   {
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('t.*');
		$DB1->from('guide_phd_renumeration t');
		$DB1->where('t.student_id',$stud_id);
		$query=$DB1->get();
		return $query->result_array();
   }
   
      public function insert_phdsection_renum_files($val,$appr_files)
	 {	 
		 $DB1 = $this->load->database('umsdb', TRUE);
		 $um_id=$this->session->userdata("uid");
		 $sdata['student_id']=$val['student_id'];
		 $sdata['enrollment_no']=$val['enrollment_no'];
		 $sdata['conduction_date']=$val['cond_date'];
		 $sdata['file_type']=$val['type'];
		 $sdata['approval_copy_letter']=$appr_files['approval_copy_file'];
		 $sdata['entry_by']=$um_id;
		 $sdata['entry_on']=date('Y-m-d H:i:s');  
		 $DB1->insert('phdsection_renum_letters',$sdata);	
		 return $DB1->insert_id();  
   }
      public function check_phdsec_renumletter_entry($val)
   {
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('*');
		$DB1->from('phdsection_renum_letters');
		$DB1->where('student_id',$val['student_id']);
		$DB1->where('file_type',$val['type']);	
		$DB1->where('approval_copy_letter!=','');	
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
	    return $query->num_rows();
   }
      public function fetch_phdsec_renum_det($stud_id)
   {
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('t.*');
		$DB1->from('phdsection_renum_letters t');
		$DB1->where('t.student_id',$stud_id);
		$query=$DB1->get();
		return $query->result_array();
   }
   
   
     public function insert_coe_notf_files($val,$appr_files)
	 {	 
		 $DB1 = $this->load->database('umsdb', TRUE);
		 $um_id=$this->session->userdata("uid");
		 $sdata['student_id']=$val['student_id'];
		 $sdata['enrollment_no']=$val['enrollment_no'];
		 $sdata['conduction_date']=$val['cond_date'];
		 $sdata['file_type']=$val['type'];
		 $sdata['notification_letter']=$appr_files['approval_copy_file'];
		 $sdata['entry_by']=$um_id;
		 $sdata['entry_on']=date('Y-m-d H:i:s');  
		 $DB1->insert('phdcoe_notification_letter',$sdata);	
		 //echo $DB1->last_query();exit;
		 return $DB1->insert_id();  
   }
      public function check_coe_notifiletter_entry($val)
   {
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('*');
		$DB1->from('phdcoe_notification_letter');
		$DB1->where('student_id',$val['student_id']);
		$DB1->where('file_type',$val['type']);	
		$DB1->where('notification_letter!=','');	
		$query=$DB1->get();
		return $query->num_rows();
   } 
      public function fetch_coe_notifletter_det($stud_id)
   {
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('t.*');
		$DB1->from('phdcoe_notification_letter t');
		$DB1->where('t.student_id',$stud_id);
		$query=$DB1->get();
		return $query->result_array();
   }
   public function fetch_bank_det()
   {
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('t.*');
		$DB1->from('bank_master t');
		$DB1->where('t.active','Y');
		$query=$DB1->get();
		return $query->result_array(); 
   }
   public function fetch_dispatch_details($stud_id='',$id='')
   {
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('p.*');
		$DB1->select('b.bank_id,b.bank_name');
		$DB1->select('ex.ext_fac_name,ex.ext_fac_email,ex.ext_fac_mobile,');
		$DB1->from('phd_thesis_ev_dispatch_record p');		
		$DB1->join('exam_external_faculty_master as ex','p.reviewer_code=ex.ext_faculty_code','left');
		$DB1->join('bank_master as b','ex.bank_id=b.bank_id','left');
		if(!empty($id)){
			$DB1->where('p.id',$id);
		}else{
		$DB1->where('p.student_id',$stud_id);
		}
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		return $query->result_array(); 
   }
   public function fetch_viewer_det($rev,$stud_id='')
   {
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('*');
		$DB1->from('phd_thesis_ev_dispatch_record');
		$DB1->where('student_id',$stud_id);
		if($rev!=""){
		$DB1->where('reviewer',$rev);
		}
		$query=$DB1->get();
		return $query->num_rows();
   } 
   
   public function fetch_guide_renum_det($stud_id='')
   {
	    $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('p.*');
		$DB1->select('COALESCE(g.cheque_file, ex.cheque_file) as cheque_file', FALSE);
		$DB1->from('phd_renumeration_details p');
		$DB1->join('guide_bank_details g','p.emp_code=g.guide_id','left');
		$DB1->join('exam_external_faculty_master ex','p.emp_code=ex.ext_faculty_code','left');
		$DB1->where('student_id',$stud_id);
		$DB1->order_by('p.type','DESC');
		$query=$DB1->get();
		return $query->result_array();
   }

		   public function fetch_faculty_details($designation)
		{  
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->select('ext_faculty_code,ext_fac_name');
			$DB1->from('exam_external_faculty_master');
			$DB1->where('btype', '2');
			$DB1->where('status', 'Y');
			$DB1->where('ext_fac_designation', $designation);
			$query = $DB1->get();
			return $query->result_array();
		}
		
		
		
  public function fetch_ext_renum_det($code='',$stud_id="",$type='')
	   {
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->select('ex.ext_faculty_code,ex.ext_fac_name,ex.ext_fac_mobile,ex.ext_fac_email,ex.ext_fac_designation,ex.ext_fac_institute,ex.bank_id,ex.acc_holder_name,ex.acc_no,ex.ifsc_code,ex.branch');
			$DB1->select('b.bank_name');
			if($type!="" && $stud_id !='' ){
			 $DB1->select('ph.amount,ph.renumeration,ph.travelling_allowance,ph.designation');	
			}
			$DB1->from('exam_external_faculty_master ex');
			$DB1->join('bank_master as b','ex.bank_id=b.bank_id','left');
			
			if($type!="" && $stud_id !='' ){
			$DB1->join('phd_renumeration_details as ph','ex.ext_faculty_code=ph.emp_code','left');	
			$DB1->where('ph.student_id',$stud_id);	
			$DB1->where('ph.type',$type);	
			}
			$DB1->where('ex.ext_faculty_code',$code);
			$query=$DB1->get();
			return $query->row_array();
	   }
	   



	    public function fetch_renum_types_det()
	   {
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->select('type');
			$DB1->from('phd_renumeration_details');
			$DB1->group_by('type');
			$query=$DB1->get();
			return $query->result_array();
	   }
	   
	   
	
public function fetch_guide_external_det()
	   {
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->select('member_name,emp_code');
			$DB1->from('phd_renumeration_details');
			$DB1->group_by('emp_code');
			$query=$DB1->get();
			return $query->result_array();
	   }
	   public function fetch_overall_renum_det($emp_code='',$acad_year='',$ren_month='')
	   {
		   if($acad_year=='')
		   {
			   $acad_year=ACADEMIC_YEAR;	
		   }
		  $DB1 = $this->load->database('umsdb', TRUE);
		 

							$DB1->select('
								p.student_id,
								p.type,
								p.emp_code,
								p.member_name,
								p.designation,
								p.institute,
								p.accountholdername,
								p.acc_no,
								p.ifsc,
								p.branch,
								sum(p.amount) as renumeration,
								p.rac_date,
								count(p.student_id) as stud_count,
								p.mobno,
								p.academic_year,
								py.amount as total_paid
							');
							$DB1->select('b.bank_name');
							$DB1->select('COALESCE(g.cheque_file, ex.cheque_file) as cheque_file', FALSE);
							$DB1->select('ex.ext_fac_email as email');

							// From and Join statements
							$DB1->from('phd_renumeration_details p');
							$DB1->join('bank_master b', 'p.bank_id=b.bank_id', 'left');
							$DB1->join('guide_bank_details g', 'p.emp_code=g.guide_id', 'left');
							$DB1->join('exam_external_faculty_master ex', 'p.emp_code=ex.ext_faculty_code', 'left');
							$DB1->join('(select sum(amount) as amount, emp_code, academic_year from phd_renumeration_payment group by emp_code, academic_year) as py', 'py.emp_code = p.emp_code and py.academic_year = p.academic_year', 'left');

							// Where conditions
							if (!empty($emp_code)) {
								$DB1->where('p.emp_code', $emp_code);
							}
							$DB1->where('p.academic_year', $acad_year);
							 if($ren_month!=''){
						
								$sel_year = date('Y', strtotime('01-' . $ren_month)); // Add a day if needed
								$sel_month = date('m', strtotime('01-' . $ren_month));

								$DB1->where('MONTH(p.created_on)', $sel_month);
								$DB1->where('YEAR(p.created_on)', $sel_year);
								}
							//Group by statement
							$DB1->group_by('p.emp_code');
							$DB1->order_by('p.member_name');

							//Execute the query
							$query = $DB1->get();
							//echo $DB1->last_query();exit;
							return $query->result_array();


			 } 
        
			public function fetch_payment_renum_det($emp_code='',$acad_year='')
			{
				$DB1 = $this->load->database('umsdb', TRUE);
				$DB1->select('p.*');
				$DB1->select('b.bank_name');
				$DB1->from('phd_renumeration_payment p');
			    $DB1->join('bank_master as b','p.bank_id=b.bank_id','left');
				$DB1->where('p.emp_code',$emp_code);
				$DB1->where('p.academic_year',$acad_year);
				$query=$DB1->get();
				return $query->result_array();
			}
			public function fetch_member_det($emp_code='')
			{
					$DB1 = $this->load->database('umsdb', TRUE);	
					$DB1->select('ext_fac_name,ext_fac_mobile,ext_fac_designation,bank_id,acc_holder_name,acc_no,ifsc_code,branch');
					$DB1->from('exam_external_faculty_master ');
					$DB1->where('ext_faculty_code',$emp_code);
					$query=$DB1->get();
					return $query->row_array();
			}


	public function fetch_internal_det($intr_id='',$stud_id='',$type='')
		{
			 if($intr_id==''){
				$intr_id=$this->session->userdata('aname');	  	
			 }		
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->select("em.emp_id as guide_id");
			$DB1->select("CONCAT(em.fname,' ',em.mname,' ',em.lname,'') AS guide_name");
			$DB1->select('gb.bid,gb.acc_holder_name,gb.acc_no,gb.ifsc_code,gb.branch,gb.bank_id,gb.cheque_file');
			$DB1->select('b.bank_name');
			$DB1->select('eod.mobileNumber');
			if($type!="" && $stud_id !='' ){
				$DB1->select('ph.amount,ph.renumeration,ph.travelling_allowance,ph.designation');	
			}
			$DB1->from('sandipun_erp.employee_master as em');
			$DB1->join('sandipun_erp.employe_other_details eod',"em.emp_id = eod.emp_id",'left');
			$DB1->join('sandipun_ums.guide_bank_details gb',"em.emp_id = gb.guide_id",'left');
			$DB1->join('sandipun_ums.bank_master as b','gb.bank_id=b.bank_id','left');
			if($type!="" && $stud_id !='' ){
				$DB1->join('phd_renumeration_details as ph','em.emp_id=ph.emp_code','left');	
				$DB1->where('ph.student_id',$stud_id);	
				$DB1->where('ph.type',$type);	
			}
			$DB1->where('em.emp_id',$intr_id);
			if($type!="" && $stud_id !='' ){
				$DB1->group_by('em.emp_id');
			}
			$query=$DB1->get();	
			return $query->row_array();
		}
		/* public function fetch_guide_renum_details($emp_code='',$acad_year='')
			{
				$DB1 = $this->load->database('umsdb', TRUE);
				$DB1->select('p.*');
				$DB1->select('sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name');
				$DB1->from('phd_renumeration_details p');
				$DB1->join('student_master sm','p.student_id=sm.stud_id','left');
				$DB1->where('p.emp_code',$emp_code);
				$DB1->where('p.academic_year',$acad_year);
				$query=$DB1->get();
				return $query->result_array();
			} */
			public function fetch_guide_renum_details($emp_code='',$acad_year='',$ren_month='')
			{
				
				if($acad_year=='')
				   {
					   $acad_year=ACADEMIC_YEAR;	
				   }
				$DB1 = $this->load->database('umsdb', TRUE);
				$DB1->select('p.*');
				$DB1->select('sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name');
				$DB1->from('phd_renumeration_details p');
				$DB1->join('student_master sm','p.student_id=sm.stud_id','left');
				$DB1->where('p.emp_code',$emp_code);
				$DB1->where('p.academic_year',$acad_year);
				//if(empty($ren_month)){
				  $DB1->where('p.academic_year', $acad_year);
				// }
				if($ren_month!=''){
							
				$sel_year = date('Y', strtotime('01-' . $ren_month)); // Add a day if needed
				$sel_month = date('m', strtotime('01-' . $ren_month));

				$DB1->where('MONTH(p.created_on)', $sel_month);
				$DB1->where('YEAR(p.created_on)', $sel_year);
				}
				$query=$DB1->get();
				return $query->result_array();
			}
			
			
			  public function update_newassign_guide_data($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);

		// Fetch the existing record
		$sd = $DB1->get_where('guide_assign_to_student', ['student_id' => $data['stud_id']])->row_array();

		if ($sd) {
			// Convert object to an array and add the inserted_on field
			$sd['inserted_on'] = date('Y-m-d H:i:s');
            unset($sd['id']);
			// Insert into the log table
			$DB1->insert('guide_assign_to_student_log', $sd);
			//echo $DB1->last_query();exit;
		}

		// If faculty and student_id are provided, update the record
		if (!empty($data['faculty']) && !empty($data['stud_id'])) {   
			$faculty_det = explode('-', $data['faculty']);

			$updata['guide_id'] = $faculty_det[0];
			$updata['guide_name'] = $faculty_det[1];
			$updata['created_by'] = $this->session->userdata("uid");
			$updata['created_on'] = date("Y-m-d H:i:s");

			// Update the record in guide_assign_to_student
			$DB1->where('student_id', $data['stud_id']);
			$DB1->update("guide_assign_to_student", $updata);
		  if ($DB1->affected_rows() > 0) {
            echo json_encode(["status" => "success", "message" => "New Guide Assigned Successfully!"]);
				} else {
					echo json_encode(["status" => "error", "message" => "No changes were made."]);
				}
			} else {
				echo json_encode(["status" => "error", "message" => "Invalid input data."]);
			}
	}

}

