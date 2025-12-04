<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Studentadmissionmodel extends CI_Model {

    var $table = 'student_master';
    var $column_order = array(null, 'sm.stud_id', 'sm.enrollment_no', 'sm.enrollment_no_new', 'sm.form_number', 'sm.first_name', 'sm.middle_name', 'sm.last_name', 'sm.admission_year', 'sm.gender', 'sm.dob', 'sm.mobile', 'sm.email', 'sm.student_photo_path', 'sm.blood_group', 'sm.dob', 'sm.birth_place', 'sm.email', 'sm.mobile', 'sm.contact_no', 'sm.religion', 'sm.category', 'sm.is_detained', 'stm.stream_name', 'cm.course_name', 'pd.parent_mobile2'); //set column field database for datatable orderable
    var $column_search = array('sm.stud_id', 'sm.enrollment_no', 'sm.enrollment_no_new', 'sm.form_number', 'sm.first_name', 'sm.middle_name', 'sm.last_name', 'sm.admission_year', 'sm.gender', 'sm.dob', 'sm.mobile', 'sm.email', 'sm.student_photo_path', 'sm.blood_group', 'sm.dob', 'sm.birth_place', 'sm.email', 'sm.mobile', 'sm.contact_no', 'sm.religion', 'sm.category', 'sm.is_detained', 'stm.stream_name', 'cm.course_name', 'pd.parent_mobile2'); //set column field database for datatable searchable 
    var $order = array('sm.stud_id' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $DB1 = $this->load->database('umsdb', TRUE);
    }

    private function _get_datatables_query($DB1 = '', $streamid = '', $year = '')
    {
        $uId = $this->session->userdata('uid');

        $DB1->select(
                        'sm.stud_id,
                         sm.enrollment_no,
                         sm.enrollment_no_new,
                         sm.form_number,
                         sm.first_name,
                         sm.middle_name,
                         sm.last_name,
                         sm.admission_year,
                         sm.gender,
                         sm.dob,
                         sm.mobile,
                         sm.email,
                         sm.student_photo_path,
                         sm.category,
                         sm.is_detained,
                         stm.stream_name,
                         cm.course_name,
                         pd.parent_mobile2
                        ', FALSE);
        $DB1->from('student_master as sm');
        $DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
        $DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
        $DB1->join('parent_details as pd','pd.student_id = sm.stud_id','left');
        if(!empty($uId)) {
            $DB1->where("sm.created_by", $uId);
        }

        if(!empty($streamid)) {
            $DB1->where("sm.admission_stream", $streamid);       
        }

        if(!empty($year)) {
            $DB1->where("sm.admission_year", $year);            
        }

        $DB1->order_by("sm.enrollment_no", "ASC");
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

    public function get_datatables($DB1 = '', $streamid = '', $year = '')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $this->_get_datatables_query($DB1, $streamid, $year);

        if($_POST['length'] != -1) {
            $DB1->limit($_POST['length'], $_POST['start']);
        }

        $query = $DB1->get();
        return $query->result();
    }

    public function count_filtered($DB1 = '', $streamid = '', $year = '')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $this->_get_datatables_query($DB1, $streamid, $year);
        $query = $DB1->get();
        return $query->num_rows();
    }

    public function count_all($DB1 = '', $streamid = '', $year = '')
    {
        $uId=$this->session->userdata('uid');
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select(
                        'sm.stud_id,
                         sm.enrollment_no,
                         sm.enrollment_no_new,
                         sm.form_number,
                         sm.first_name,
                         sm.middle_name,
                         sm.last_name,
                         sm.admission_year,
                         sm.gender,
                         sm.dob,
                         sm.mobile,
                         sm.email,
                         sm.student_photo_path,
                         sm.category,
                         sm.is_detained,
                         stm.stream_name,
                         cm.course_name,
                         pd.parent_mobile2
                        ', FALSE);
        $DB1->from('student_master as sm');
        $DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
        $DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
        $DB1->join('parent_details as pd','pd.student_id = sm.stud_id','left');
        if(!empty($uId)) {
            $DB1->where("sm.created_by", $uId);
        }

        if(!empty($streamid)) {
            $DB1->where("sm.admission_stream", $streamid);       
        }

        if(!empty($year)) {
            $DB1->where("sm.admission_year", $year);            
        }

        $DB1->order_by("sm.enrollment_no", "ASC");

        return $DB1->count_all_results();
    }
}
