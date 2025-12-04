<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loadstudentsmodel extends CI_Model {

    var $table = 'student_master';
    var $column_order = array(null, 'sm.stud_id', 'sm.enrollment_no', 'sm.enrollment_no_new', 'sm.form_number', 'sm.first_name', 'sm.middle_name', 'sm.last_name', 'sm.admission_year', 'sm.gender', 'sm.dob', 'sm.mobile', 'sm.email', 'sm.student_photo_path', 'sm.blood_group', 'sm.dob', 'sm.birth_place', 'sm.email', 'sm.mobile', 'sm.contact_no', 'sm.religion', 'sm.category', 'sm.is_detained'); //set column field database for datatable orderable
    var $column_search = array('sm.stud_id', 'sm.enrollment_no', 'sm.enrollment_no_new', 'sm.form_number', 'sm.first_name', 'sm.middle_name', 'sm.last_name', 'sm.admission_year', 'sm.gender', 'sm.dob', 'sm.mobile', 'sm.email', 'sm.student_photo_path', 'sm.blood_group', 'sm.dob', 'sm.birth_place', 'sm.email', 'sm.mobile', 'sm.contact_no', 'sm.religion', 'sm.category', 'sm.is_detained'); //set column field database for datatable searchable 
    var $order = array('sm.stud_id' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $DB1 = $this->load->database('umsdb', TRUE);
    }
 function loadempschool($emp_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT v.school_code,f.department from vw_faculty f 
		LEFT JOIN sandipun_erp.employee_master e  ON e.emp_id=f.emp_id
		INNER JOIN school_master c  ON c.erp_mapp_school_id=f.emp_school
		LEFT JOIN vw_stream_details v ON v.school_id=c.school_id where f.emp_id='$emp_id' group by v.school_code
		";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
 }
    private function _get_datatables_query($DB1 = '', $streamid = '', $year = '', $acdyear = '')
    {
        $uId = $this->session->userdata('uid');
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
        $DB1->select(
                        'sm.*,
                         vsd.*,u.username,u.password,
                         ad.form_number as formn,p.parent_mobile2
                        ', FALSE);
        $DB1->from('admission_details as ad');
        $DB1->join('student_master as sm','ad.student_id = sm.stud_id','left');
        $DB1->join('vw_stream_details as vsd','ad.stream_id = vsd.stream_id','left');
        $DB1->join('parent_details as p','p.student_id = sm.stud_id','left');
		$DB1->join('user_master as u','u.username = sm.enrollment_no and u.roles_id=4','left');
        if(!empty($streamid)) {
            $DB1->where("sm.admission_stream",$streamid);       
        }

        if(!empty($year)) {
            $DB1->where("ad.year", $year);
        }

        if(!empty($acdyear)) {
            $DB1->where("ad.academic_year", $acdyear);
        }
		if(isset($role_id) && $role_id==20){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 if($emp_id==110074){
				 $sql .=" AND vsd.course_id in(2,3)";
			 }else{
			 $DB1->where("vsd.school_code",$schid);
			 }
			 
			 //$sql .=" AND vsd.school_code = $schid";
		 }else if(isset($role_id) && $role_id==44){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $sql .=" AND vw.school_code = $schid";
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$DB1->where("vsd.school_code",$sccode);
				//$sql .=" AND vsd.school_code = $sccode";
		}

        $DB1->where("sm.cancelled_admission",'N');
		$DB1->where('sm.enrollment_no_new IS NOT', null);
        $DB1->order_by("sm.enrollment_no", "ASC");
        $DB1->order_by("sm.admission_stream", "ASC");
        $DB1->order_by("sm.current_semester", "ASC");
		
        $i = 0;

        foreach ($this->column_search as $item) {
            if($_POST['search']['value']) {
                
                if($i===0) {
                    $DB1->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $DB1->like($item, $_POST['search']['value']);
                } else {
                    $DB1->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $DB1->group_end(); //close bracket
            }
            $i++;
        }
        
        if(isset($_POST['order'])) {
            $DB1->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $DB1->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables($DB1 = '', $streamid = '', $year = '', $acdyear = '')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $this->_get_datatables_query($DB1, $streamid, $year, $acdyear);

        if($_POST['length'] != -1) {
            $DB1->limit($_POST['length'], $_POST['start']);
        }

        $query = $DB1->get();
		//echo $DB1->last_query();exit;
        return $query->result();
    }

    public function count_filtered($DB1 = '', $streamid = '', $year = '', $acdyear = '')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $this->_get_datatables_query($DB1, $streamid, $year, $acdyear);
        $query = $DB1->get();
        return $query->num_rows();
    }

    public function count_all($DB1 = '', $streamid = '', $year = '', $acdyear = '')
    {
        $uId=$this->session->userdata('uid');
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select(
                        'sm.*,
                         vsd.*,
                         ad.form_number as formn
                        ', FALSE);
        $DB1->from('admission_details as ad');
        $DB1->join('student_master as sm','ad.student_id = sm.stud_id','left');
        $DB1->join('vw_stream_details as vsd','ad.stream_id = vsd.stream_id','left');
        if(!empty($streamid)) {
            $DB1->where("sm.admission_stream",$streamid);       
        }

        if(!empty($year)) {
            $DB1->where("ad.year", $year);
        }

        if(!empty($acdyear)) {
            $DB1->where("ad.academic_year", $acdyear);
        }

        $DB1->where("sm.cancelled_admission",'N');
        $DB1->order_by("sm.enrollment_no", "ASC");
        $DB1->order_by("sm.admission_stream", "ASC");
        $DB1->order_by("sm.current_semester", "ASC");

        return $DB1->count_all_results();
    }
}