<?php
class Event_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('Awssdk');
        // $this->bucket_name = 'humanresourcemanagement';
        $this->bucket_name =  'erp-asset';
        date_default_timezone_set('Asia/Kolkata');
    }

    public function get_events($limit, $offset, $search = null)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('e.*,ep.file_name,ep.file_path, 
                  vw.school_name, 
                  vw.course_short_name, 
                  vw.course_name, 
                  vw.stream_name');
        $DB1->from('events e');
        $DB1->join('vw_stream_details vw', 'vw.school_id = e.school_id AND vw.course_id = e.course_id AND vw.stream_id = e.stream_id');
        $DB1->join('event_photos ep', 'e.id = ep.event_id', 'left');

        if (!empty($search)) {
            $DB1->group_start();
            $DB1->like('e.event_name', $search);
            $DB1->or_like('e.organised_by', $search);
            $DB1->or_like('e.event_address', $search);
            $DB1->or_like('vw.school_name', $search);
            $DB1->or_like('vw.course_short_name', $search);
            $DB1->or_like('vw.stream_name', $search);
            $DB1->group_end();
        }

        $DB1->limit($limit, $offset);
        $query = $DB1->get();

        return $query->result_array();
    }

    public function count_events($search = null)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->from('events');

        if (!empty($search)) {
            $DB1->like('event_name', $search);
            $DB1->or_like('organised_by', $search);
            $DB1->or_like('event_address', $search);
        }

        return $DB1->count_all_results();
    }

    function get_event($event_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('*');
        $DB1->from('events');
        $DB1->where('id', $event_id);
        $query = $DB1->get();

        return $query->row_array();
    }

    function insert_event($data)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        // print_r($data);exit;
        $DB1->insert('events', $data);

        $last_inserted_id = $DB1->insert_id();

        if ($last_inserted_id == 0) {
            return false;
        }
        return true;
    }

    function save_event_pdf($event_id, $file)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        if (!isset($file['name']) || empty($file['name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return ['status' => false, 'error' => 'File upload error or no file selected.'];
        }

        $allowed_types = ['pdf'];
        $max_size = 5 * 1024 * 1024;

        $file_size = $file['size'];
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_types)) {
            return ['status' => false, 'error' => 'Invalid file type. Only PDFs are allowed.'];
        }

        if ($file_size > $max_size) {
            return ['status' => false, 'error' => 'File size exceeds the limit of 5MB.'];
        }

        $unique_file_name = time() . '_' . uniqid() . '.' . $file_extension;
        $file_path = 'uploads/events/' . $unique_file_name;

        try {
            $upload_result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $file['tmp_name']);

            if (!$upload_result) {
                return ['status' => false, 'error' => 'AWS S3 upload failed.'];
            }

            $data = [
                'event_id' => $event_id,
                'file_name' => $unique_file_name,
                'file_path' => $file_path,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('uid')
            ];

            $DB1->insert('event_photos', $data);
            return ['status' => true, 'file_path' => $file_path];
        } catch (Exception $e) {
            return ['status' => false, 'error' => 'File upload failed: ' . $e->getMessage()];
        }
    }

    function get_schools()
    {

        $role_id = $this->session->userdata('role_id');
        $emp_id = $this->session->userdata("name");

        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT DISTINCT(school_code),school_short_name FROM vw_stream_details where school_code IS NOT NULL";

        // if(isset($role_id) && $role_id==20){
        // 	 $empsch = $this->Subject_model->loadempschool($emp_id);
        // 	 $schid= $empsch[0]['school_code'];
        // 	 $sql .=" and school_code = $schid";
        //  }else if(isset($role_id) && $role_id==10){
        // 		$ex =explode("_",$emp_id);
        // 		$sccode = $ex[1];
        // 		$sql .=" and school_code = $sccode";
        // }else if(isset($role_id) && $role_id==37){
        // 		$ex =explode("_",$emp_id);
        // 		$sccode = $ex[1];
        // 		$sql .=" and school_code = $sccode";
        // }

        $query = $DB1->query($sql);
        // echo $DB1->last_query();exit;
        // print_r($query->result_array()); exit;
        return $query->result_array();
    }

    function get_courses($school_code = '')
    {

        $DB1 = $this->load->database('umsdb', TRUE);

        $sql = "SELECT DISTINCT(vw.course_id),course_name,course_short_name FROM vw_stream_details vw join exam_details ed on ed.stream_id=vw.stream_id 
		where vw.school_code='" . $school_code . "'";

        $query = $DB1->query($sql);
        return $query->result_array();
    }

    function get_streams($course_id, $school_code = '')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $role_id = $this->session->userdata('role_id');
        $emp_id = $this->session->userdata("name");


        $sql = "select vw.stream_id,stream_name,stream_short_name from vw_stream_details vw join exam_details ed on ed.stream_id=vw.stream_id where 1";
        if ($school_code != '') {
            $sql .= " and vw.school_code='" . $school_code . "'";
        }
        if ($course_id != 0) {
            $sql .= " and vw.course_id='" . $course_id . "'";
        }
        $sql .= " group by vw.stream_id";
        $query = $DB1->query($sql);

        $stream_details = $query->result_array();
        return $stream_details;
    }


    public function get_student_id($enrollment_no = '')
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $sql = "SELECT stud_id FROM student_master 
                WHERE enrollment_no = ? OR enrollment_no_new = ? 
                LIMIT 1";

        $query = $DB1->query($sql, array($enrollment_no, $enrollment_no));
        return $query->row_array();
    }


    public function get_event_name_by_id($event_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('event_name');
        $DB1->from('events');
        $DB1->where('id', $event_id);
        $query = $DB1->get();

        return $query->row_array();
    }

    public function get_event_detail_by_id($event_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('e.id,e.event_name,e.organised_by,e.school_id,e.course_id,e.stream_id,e.academic_year,vsd.school_name,vsd.course_name,vsd.stream_name');
        $DB1->from('events e');
        $DB1->join('vw_stream_details vsd', 'e.school_id = vsd.school_id AND e.course_id = vsd.course_id AND e.stream_id = vsd.stream_id');
        $DB1->where('id', $event_id);
        $query = $DB1->get();

        return $query->row_array();
    }

    function get_academic_years()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $role_id = $this->session->userdata('role_id');
        $emp_id = $this->session->userdata("name");

        $sql = "select academic_year,academic_session from academic_session ";
        if (isset($role_id) && ($role_id == 15 || $role_id == 6 || $emp_id == 'admin_1010')) {
            $sql .= " Order by academic_year desc limit 0,2";
        } elseif ($emp_id == 'research_admin') {
            $sql .= " Order by academic_year desc limit 0,4";
        } else {
            $sql .= "  where currently_active='Y'";
        }

        $query = $DB1->query($sql);
        return $query->result_array();
    }

    function getSchools()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT school_id,school_short_name FROM school_master";
        $query = $DB1->query($sql);

        return $query->result_array();
    }


    public function get_time_slots($academic_year, $course_id, $stream_id, $semester, $division)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $sql = "
        SELECT 
            ls.lect_slot_id, 
            ls.from_time, 
            ls.to_time, 
            ls.slot_am_pm,
            vf.fname, 
            vf.mname, 
            vf.lname,
            sm.subject_code,
            ltt.subject_type
        FROM lecture_time_table ltt
        LEFT JOIN vw_faculty vf ON vf.emp_id = ltt.faculty_code
        LEFT JOIN lecture_slot ls ON ls.lect_slot_id = ltt.lecture_slot
        LEFT JOIN subject_master sm ON sm.sub_id = ltt.subject_code
        WHERE ltt.academic_year = ?
        AND ltt.course_id = ?
        AND ltt.stream_id = ?
        AND ltt.semester = ?
        AND ltt.division = ?
        GROUP BY ltt.lecture_slot, vf.fname, vf.mname, vf.lname
        ORDER BY ls.from_time
    ";

        $query = $DB1->query($sql, [$academic_year, $course_id, $stream_id, $semester, $division]);
        return $query->result_array();
    }

    public function get_event_deatils($filters = [])
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT e.*, s.school_short_name,sd.stream_name,sd.course_short_name,ls.from_time,ls.to_time,ls.slot_am_pm FROM event_lecture_drop e 
            LEFT JOIN school_master s ON e.school_id = s.school_id
            LEFT JOIN vw_stream_details sd ON e.stream_id = sd.stream_id
            LEFT JOIN lecture_slot ls ON e.time_slot = ls.lect_slot_id
             WHERE 1=1
             ORDER BY e.id DESC
             ";

        if (!empty($filters['school_id'])) {
            $sql .= " AND e.school_id = " . $DB1->escape($filters['school_id']);
        }
        if (!empty($filters['course_id'])) {
            $sql .= " AND e.course_id = " . $DB1->escape($filters['course_id']);
        }
        if (!empty($filters['stream_id'])) {
            $sql .= " AND e.stream_id = " . $DB1->escape($filters['stream_id']);
        }
        if (!empty($filters['semester'])) {
            $sql .= " AND e.semester = " . $DB1->escape($filters['semester']);
        }
        if (!empty($filters['division'])) {
            $sql .= " AND e.division = " . $DB1->escape($filters['division']);
        }

        return $DB1->query($sql)->result_array();
    }


    public function insert_event_allocation($data)
    {

        $DB1 = $this->load->database('umsdb', TRUE);

        if (empty($data)) {
            return false;
        }

        if (!$DB1->insert_batch('event_allocation', $data)) {
            log_message('error', 'Failed to insert event allocation: ' . $DB1->error());
            return false;
        }
        return true;
    }

    public function get_event_allocation_list_by_idNew($event_id, $limit, $offset, $search = '')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
    
        $DB1->select([
            'e.id',
            'ea.id AS event_allocation_id',
            'e.event_name',
            'e.organised_by',
            'ea.stream_id',
            'ea.course_id',
            'ea.school_id',
            'ea.division',
            'e.start_date as from_date',
            'e.end_date as to_date',
            'vsd.stream_name',
            'vsd.stream_short_name',
            'vsd.course_name',
            'vsd.school_name',
           
            '(SELECT COUNT(*) FROM event_student_attendance esa WHERE esa.event_allocation_id = ea.id AND esa.stream_id = ea.stream_id AND esa.course_id = ea.course_id AND esa.school_id = ea.school_id LIMIT 1) as attendance_exists'
        ]);
    
        $DB1->from('events e');
        $DB1->join('event_allocation ea', 'e.id = ea.event_id', 'left');
        $DB1->join('vw_stream_details vsd', 'ea.school_id = vsd.school_id AND ea.course_id = vsd.course_id AND ea.stream_id = vsd.stream_id');
    
        $DB1->where('e.id', $event_id);
    
        if (!empty($search)) {
            $DB1->group_start();
            $DB1->like('e.event_name', $search);
            $DB1->or_like('e.organised_by', $search);
            $DB1->or_like('vsd.stream_name', $search);
            $DB1->or_like('vsd.course_name', $search);
            $DB1->or_like('vsd.school_name', $search);
            $DB1->group_end();
        }
    
        $DB1->limit($limit, $offset);
        $query = $DB1->get();
    
        return $query->result_array();
    }
    
    public function get_event_allocation_list_by_id($event_id, $limit, $offset, $search = '')
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select([
            'e.id',
            'ea.id AS event_allocation_id',
            'e.event_name',
            'e.organised_by',
            'ea.stream_id',
            'ea.course_id',
            'ea.school_id',
            'ea.division',
            'e.start_date as from_date',
            'e.end_date as to_date',
            'vsd.stream_name',
            'vsd.stream_short_name',
            'vsd.course_name',
            'vsd.school_name'
        ]);

        $DB1->from('events e');
        $DB1->join('event_allocation ea', 'e.id = ea.event_id', 'left');
        $DB1->join('vw_stream_details vsd', 'ea.school_id = vsd.school_id AND ea.course_id = vsd.course_id AND ea.stream_id = vsd.stream_id');

        $DB1->where('e.id', $event_id);

        if (!empty($search)) {
            $DB1->group_start();
            $DB1->like('e.event_name', $search);
            $DB1->or_like('e.organised_by', $search);
            $DB1->or_like('vsd.stream_name', $search);
            $DB1->or_like('vsd.course_name', $search);
            $DB1->or_like('vsd.school_name', $search);
            $DB1->group_end();
        }

        $DB1->limit($limit, $offset);
        $query = $DB1->get();

        return $query->result_array();
    }


    public function count_event_allocations($event_id, $search = '')
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->from('events e');
        $DB1->join('event_allocation ea', 'e.id = ea.event_id', 'left');
        $DB1->join('vw_stream_details vsd', 'ea.school_id = vsd.school_id AND ea.course_id = vsd.course_id AND ea.stream_id = vsd.stream_id');

        $DB1->where('e.id', $event_id);

        if (!empty($search)) {
            $DB1->group_start();
            $DB1->like('e.event_name', $search);
            $DB1->or_like('e.organised_by', $search);
            $DB1->or_like('vsd.stream_name', $search);
            $DB1->or_like('vsd.course_name', $search);
            $DB1->or_like('vsd.school_name', $search);
            $DB1->group_end();
        }

        return $DB1->count_all_results();
    }


    public function get_event_by_allocation_id($event_allocation_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select([
            'e.id',
            'e.start_date',
            'e.end_date',
            'ea.id AS event_allocation_id',
            'e.event_name',
            'e.organised_by',
            'ea.stream_id',
            'ea.semester',
            'ea.course_id',
            'ea.school_id',
            'ea.division',
            'ea.to_date',
            'ea.from_date',
            'vsd.stream_name',
            'vsd.stream_short_name',
            'vsd.course_name',
            'vsd.school_name'
        ]);

        $DB1->from('events e');
        $DB1->join('event_allocation ea', 'e.id = ea.event_id', 'left');
        $DB1->join('vw_stream_details vsd', 'ea.school_id = vsd.school_id AND ea.course_id = vsd.course_id AND ea.stream_id = vsd.stream_id');

        $DB1->where('ea.id', $event_allocation_id);
        $query = $DB1->get();

        return $query->result_array();
    }

    public function get_allocate_students($stream_id = null, $semester = null, $division = null)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
    
        $academic_year = '2023-24';
        $cur_ses = CURRENT_SESS;

        $DB1->select([
            'sba.student_id',
            'sba.roll_no',
            'sba.batch',
            'sba.academic_year',
            'sba.academic_session',
            'sba.stream_id',
            'sba.semester',
            'sba.division',
            'sm.enrollment_no',
            'sm.first_name'
        ]);

        $DB1->from('student_batch_allocation sba');

        $DB1->join('student_master sm', 'sba.student_id = sm.stud_id', 'left');

        $DB1->where('sba.stream_id', $stream_id);
        $DB1->where('sba.semester', $semester);
        $DB1->where('sba.division', $division);
        $DB1->where('sba.academic_year', $academic_year);
        $DB1->where('sba.active', 'Y');

        $query = $DB1->get();

        return $query->result_array();
    }

    public function get_marked_attendance($event_allocation_id, $attendance_date = null)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('student_id,attendance_date');
        $DB1->from('event_student_attendance');
        $DB1->where('event_allocation_id', $event_allocation_id);
        $DB1->where('attendance_date', $attendance_date);

        $query = $DB1->get();
        return $query->result_array();
    }

    public function get_marked_attendance_students($event_allocation_id, $attendance_date = null)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select([
            'sm.stud_id',
            'sm.enrollment_no',
            'sm.first_name',
        ]);

        $DB1->from('event_student_attendance esa');
        $DB1->join('student_master sm', 'esa.student_id = sm.stud_id', 'left');

        $DB1->where('esa.event_allocation_id', $event_allocation_id);
        $DB1->where('esa.attendance_date', $attendance_date);

        $query = $DB1->get();

        return $query->result_array();
    }

    public function check_duplicate_event_allocation($data)
{
    $DB1 = $this->load->database('umsdb', TRUE);

    $DB1->where([
        'event_id'      => $data['event_id'],
        'academic_year' => $data['academic_year'],
        'school_id'     => $data['school_id'],
        'course_id'     => $data['course_id'],
        'stream_id'     => $data['stream_id'],
        'semester'      => $data['semester'],
        'division'      => $data['division'],
        'status'        => 'Active'
    ]);
    $query = $DB1->get('event_allocation');

    return $query->num_rows() > 0;
}

}
