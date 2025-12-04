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
		//echo $sql;exit;
		//echo $DB1->last_query();exit;
		return $stream_details =  $query->result_array();  
    }

function load_semester_subjects()
    { 

        $DB1 = $this->load->database('umsdb', TRUE);    
        //$acd_yr =explode('-', $_POST['academic_year']);
		$sql="SELECT s.current_semester as semester FROM student_master s  where s.admission_cycle='".$_POST['admission_cycle']."' and s.admission_stream='".$_POST['stream_id']."' and s.cancelled_admission ='N' and s.is_detained='N' group by s.current_semester";
        
        $query = $DB1->query($sql);
		//echo $DB1->last_query();
		//exit;
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
        $sql="SELECT sm.*, std.stream_name FROM `student_master` as sm left join stream_master std on std.stream_id=sm.admission_stream $where AND sm.admission_cycle='".$admission_cycle."'";
		$sql.=" order by sm.enrollment_no";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
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
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	//
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
		//echo $DB1->last_query();exit;
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
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	 	function get_faculty_list() {

		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select emp_reg_id,emp_id, CONCAT(fname, ' ', mname, ' ', lname) AS fac_name,department_name,designation_name from vw_faculty order by fname";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
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
		$DB1->select('*');
		$DB1->from('guide_assign_to_student');
		if($role_id==3 || $role_id==21){
		$DB1->where('guide_id',$guide_id);
		}
		$DB1->order_by('id','desc');
		$query=$DB1->get();		
		return $query->result_array();
	}
	  public function fetch_guide_student_view($val='')
	  {
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('g.*');
		$DB1->from('guide_assign_to_student g');
		$DB1->join('student_master sm','g.student_id=sm.stud_id','left');
		$DB1->where('sm.admission_cycle',$val['cycle']);
		if($val['dept_id']!=''){
		$DB1->where('sm.admission_stream',$val['dept_id']);
		}
		$query=$DB1->get();
		return $query->result_array(); 
	  }
	  
	   public function insert_topic_approval_files($val,$appr_files)
	 {	 
		 $DB1 = $this->load->database('umsdb', TRUE);
		 $stud_id=$this->session->userdata("aname");
		 $um_id=$this->session->userdata("uid");
		 //$sem_det=$this->fetch_sem_det($stud_id);
		 $sdata['student_id']=$stud_id;
		 //$sdata['semester']=$sem_det['current_semester'];
		 $sdata['semester']=$val['semester'];
		 $sdata['rac_file']=$appr_files['rac_topic_file'];
		 $sdata['research_file']=$appr_files['research_sem_file'];
		 $sdata['entry_by']=$um_id;
		 $sdata['entry_on']=date('Y-m-d H:i:s');  
		 $DB1->insert('topic_approval_details',$sdata);	
		 return $DB1->insert_id();
	 }
	   public function update_topic_approval_files($val,$appr_files)
	 {	 
		 $DB1 = $this->load->database('umsdb', TRUE);
		 $stud_id=$this->session->userdata("aname");
		 $um_id=$this->session->userdata("uid");
		 $sem_det=$this->fetch_sem_det($stud_id);
		 $appr_files['updated_by']=$um_id;
		 $appr_files['updated_on']=date('Y-m-d H:i:s');
		 $DB1->where('id',$val['app_id']);	 
		 $query=$DB1->update('topic_approval_details',$appr_files);	
		// echo $DB1->last_query();exit;
		 return $query;
	 }
 
 public function fetch_sem_det()
 {
	$DB1 = $this->load->database('umsdb', TRUE);
	$stud_id=$this->session->userdata("aname");
	$DB1->select('current_semester');
	$DB1->from('student_master');
	$DB1->where('stud_id',$stud_id);
	$query=$DB1->get();
	return $query->row_array();  
 }
 public function fetch_doc_det($sem='')
 {
	$DB1 = $this->load->database('umsdb', TRUE);
	$stud_id=$this->session->userdata("aname");
	$DB1->select('*');
	$DB1->from('topic_approval_details t');
	$DB1->where('student_id',$stud_id);
	if($sem!='')
	{
	  $DB1->where('semester',$sem);	
	}
	$DB1->order_by('semester','desc');
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
   
   public function change_topic_approval_status($stud_id,$status,$sem)
   {
	 $DB1 = $this->load->database('umsdb', TRUE);
   	 $sdata=array(
	 'status'=>$status,
	 );
	 $DB1->where('student_id',$stud_id);	
	 $DB1->where('semester',$sem);	
	 $query=$DB1->update('topic_approval_details',$sdata);
	 return $query;
   }
   public function check_sem_wise_entry($val)
   {
	$DB1 = $this->load->database('umsdb', TRUE);
	$stud_id=$this->session->userdata("aname");
	$DB1->select('*');
	$DB1->from('topic_approval_details');
	$DB1->where('student_id',$stud_id);
	$DB1->where('semester',$val['semester']);	
	$query=$DB1->get();
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
}