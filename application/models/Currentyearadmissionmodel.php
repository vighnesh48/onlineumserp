<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currentyearadmissionmodel extends CI_Model {

    var $table = 'student_master';
    var $column_order = array(null, 'sm.stud_id', 'sm.enrollment_no', 'sm.enrollment_no_new', 'sm.form_number', 'sm.student_photo_path', 'sm.first_name', 'sm.middle_name', 'sm.last_name', 'sm.dob', 'sm.mobile', 'sm.reported_date', 'stm.stream_name'); //set column field database for datatable orderable
    var $column_search = array('sm.stud_id', 'sm.enrollment_no', 'sm.enrollment_no_new', 'sm.form_number', 'sm.student_photo_path', 'sm.first_name', 'sm.middle_name', 'sm.last_name', 'sm.dob', 'sm.mobile', 'sm.reported_date', 'stm.stream_name'); //set column field database for datatable searchable 
    var $order = array('sm.stud_id' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $DB1 = $this->load->database('umsdb', TRUE);
    }

    private function _get_datatables_query($DB1 = '', $schoolId = '', $academicYear = '')
    {
        $DB1->select(
                        'sm.stud_id,
                        sm.enrollment_no as oldprn,
                        sm.enrollment_no_new as prn,
                        sm.form_number,
                        sm.student_photo_path,
                        sm.first_name,
                        sm.middle_name,
                        sm.last_name,
                        sm.dob,
                        sm.mobile,
                        sm.reported_date,
                        stm.stream_name,
                        ', FALSE);
        $DB1->from('student_master as sm');
        $DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
        if(!empty($schoolId)) {
            $DB1->where('sm.admission_school', $schoolId);
        }

        if(!empty($academicYear)) {
            $DB1->where('sm.admission_session', $academicYear);
        }

        $DB1->where('sm.cancelled_admission', 'N');
		$DB1->where('sm.admission_confirm', 'Y');
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

    public function get_datatables($DB1 = '', $schoolId = '', $academicYear = '')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $this->_get_datatables_query($DB1, $schoolId, $academicYear);

        if($_POST['length'] != -1) {
            $DB1->limit($_POST['length'], $_POST['start']);
        }

        $query = $DB1->get();
        return $query->result();
    }

    public function count_filtered($DB1 = '', $schoolId = '', $academicYear = '')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $this->_get_datatables_query($DB1, $schoolId, $academicYear);
        $query = $DB1->get();
        return $query->num_rows();
    }

    public function count_all($DB1 = '', $schoolId = '', $academicYear = '')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select(
                        'sm.stud_id,
                        sm.enrollment_no as oldprn,
                        sm.enrollment_no_new as prn,
                        sm.form_number,
                        sm.student_photo_path,
                        sm.first_name,
                        sm.middle_name,
                        sm.last_name,
                        sm.dob,
                        sm.mobile,
                        sm.reported_date,
                        stm.stream_name,
                        ', FALSE);
        $DB1->from('student_master as sm');
        $DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
        if(!empty($schoolId)) {
            $DB1->where('sm.admission_school', $schoolId);
        }

        if(!empty($academicYear)) {
            $DB1->where('sm.admission_session', $academicYear);
        }

        $DB1->where('sm.cancelled_admission', 'N');
		$DB1->where('sm.admission_confirm', 'Y');

        return $DB1->count_all_results();
    }
}
