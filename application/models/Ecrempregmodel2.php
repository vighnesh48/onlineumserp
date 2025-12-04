<?php
class Ecrempregmodel extends CI_Model
{

    public function getExamSessions()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        return $DB1->select('exam_id, exam_name')
            ->where('active_for_exam', 'Y')
            ->get('exam_session')
            ->result();
    }

    public function getExamCenters()
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        return $DB1->select('ec_id, center_name, center_code')
            ->where('is_active', 'Y')
            ->get('exam_center_master')
            ->result();
    }

    public function getSchools()
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        return $DB1->select('school_id, school_short_name')
            ->where('is_active', 'Y')
            ->get('school_master')
            ->result();
    }

    public function getEcrRoles()
    {
        $role_id = $this->session->userdata('role_id');  // Get role_id from session

        // Load the database connection for 'umsdb'
        $DB1 = $this->load->database('umsdb', TRUE);

        // Begin query
        $DB1->select('ecr_role_id, role_name')
            ->from('ecr_roles')
            ->where('is_active', 1);  // Only get active roles

        // Apply conditional logic based on role_id
        if ($role_id == 15) {
            // If role_id is 15, get only ecr_role_id = 1
            $DB1->where_in('ecr_role_id', [1, 3]);

        } elseif ($role_id == 25) {
            // If role_id is 25, get everything except ecr_role_id = 1
            $DB1->where('ecr_role_id !=', 1);
            $DB1->where('ecr_role_id !=', 3);

        }

        // Execute query and return the result
        return $DB1->get()->result();
    }

    public function getEmployeeDetails($employee_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $query = $DB1->query("
            SELECT em.emp_id, CONCAT(em.fname, ' ', em.mname, ' ', em.lname) AS name, od.mobileNumber as mobile, od.oemail as email
            FROM sandipun_erp.employee_master em
            LEFT JOIN sandipun_erp.employe_other_details od ON od.emp_id = em.emp_id
            WHERE em.emp_id = ?
            UNION
            SELECT ext_faculty_code AS emp_id, ext_fac_name AS name, ext_fac_mobile as mobile, ext_fac_email as email
            FROM sandipun_ums.exam_external_faculty_master
            WHERE btype = 3 AND ext_faculty_code = ?
        ", [$employee_id, $employee_id]);

        //  echo $DB1->last_query();exit;
        return $query->row();
    }

    public function insertEcrEmployee($data)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        return $DB1->insert('ecr_emp_reg', $data);
        //  echo $DB1->last_query(); exit;
    }
    public function insertUserMaster($data)
    {
        $this->db->insert('user_master', $data);
        //  echo $this->db->last_query(); exit;
    }

    public function getFilteredEmployees($filters = '')
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('ecr_emp_reg.*,exam_session.exam_name,exam_center_master.center_name,school_master.school_short_name,ecr_roles.role_name')->from('ecr_emp_reg');
        $DB1->join('exam_session', 'exam_session.exam_id = ecr_emp_reg.exam_id', 'left');
        $DB1->join('exam_center_master', 'exam_center_master.ec_id = ecr_emp_reg.center_id', 'left');
        $DB1->join('school_master', 'school_master.school_id = ecr_emp_reg.school_id', 'left');
        $DB1->join('ecr_roles', 'ecr_roles.ecr_role_id = ecr_emp_reg.ecr_role', 'left');
        if (!empty($filters['exam_id'])) {
            $DB1->where('ecr_emp_reg.exam_id', $filters['exam_id']);
        }
        if (!empty($filters['center_id'])) {
            $DB1->where('ecr_emp_reg.center_id', $filters['center_id']);
        }
        if (!empty($filters['ecr_role_id'])) {
            $DB1->where('ecr_emp_reg.ecr_role', $filters['ecr_role_id']);
        }

        $query = $DB1->get();
        //    echo $DB1->last_query();exit;
        return $query->result();
    }
    public function getSessions()
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        return $DB1->distinct()->select('session')->get('examtime_slot')->result();
    }

    public function getEmployeesByRole($role_id, $exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('ecr_emp_reg.*,exam_session.exam_name,exam_center_master.center_name,school_master.school_short_name,ecr_roles.role_name')->from('ecr_emp_reg');
        $DB1->join('exam_session', 'exam_session.exam_id = ecr_emp_reg.exam_id', 'left');
        $DB1->join('exam_center_master', 'exam_center_master.ec_id = ecr_emp_reg.center_id', 'left');
        $DB1->join('school_master', 'school_master.school_id = ecr_emp_reg.school_id', 'left');
        $DB1->join('ecr_roles', 'ecr_roles.ecr_role_id = ecr_emp_reg.ecr_role', 'left');
        $DB1->where('ecr_role', $role_id);
        $DB1->where('ecr_emp_reg.exam_id', $exam_id);
        $query = $DB1->get();
    //  echo $DB1->last_query();exit;
        return $query->result();
    }
    public function getExamDatesBySession($exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select('DISTINCT(date)');
        $DB1->from('exam_time_table');
        $DB1->where('exam_id', $exam_id);
        $result = $DB1->get()->result_array();

        // Extract only the dates into a simple array
        $dates = array_map(function ($row) {
            return $row['date'];
        }, $result);

        return $dates;
    }
    public function getDuetyAllocations()
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        return $DB1->get('duety_allocation')->result();
    }
    public function getAllocations($exam_id, $role_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
    
        $DB1->select('emp_id, replace_emp_id, is_replaced, date, session');
        $DB1->from('duety_allocation');
        $DB1->where('exam_id', $exam_id);
        $DB1->where('duety_name', $role_id);
        $results = $DB1->get()->result_array();
    
        $allocations = [];
        foreach ($results as $row) {
            // Determine the effective employee ID based on the is_replaced flag
            $effective_emp_id = $row['is_replaced'] == 1 ? $row['replace_emp_id'] : $row['emp_id'];
            
            // Store allocation data with the effective employee ID
            $allocations[$effective_emp_id][$row['date']][] = $row['session'];
        }
        
        return $allocations;
    }
    
    public function insertAllocation($data)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        //   echo'<pre>'; print_r($data);exit;
        return $DB1->insert('duety_allocation', $data);
        //  echo $DB1->last_query(); exit;
    }
    
    public function insertOrDeleteAllocation($emp_id, $date, $sessions, $duety_name, $exam_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
    
        // Get existing entries for the specific employee, date, duty name, and exam ID
        $existingSessions = $DB1->select('session')
                                ->from('duety_allocation')
                                ->where('emp_id', $emp_id)
                                ->where('date', $date)
                                ->where('duety_name', $duety_name)
                                ->where('exam_id', $exam_id)
                                ->get()
                                ->result_array();
    
        // Extract existing session values for easy comparison
        $existingSessionValues = array_column($existingSessions, 'session');
    
        // Determine sessions to delete: existing sessions not in the currently selected sessions
        $sessionsToDelete = array_diff($existingSessionValues, $sessions);
    
        // Determine sessions to insert: selected sessions not in the existing sessions
        $sessionsToInsert = array_diff($sessions, $existingSessionValues);
    
        // Delete unchecked sessions
        if (!empty($sessionsToDelete)) {
            $DB1->where('emp_id', $emp_id)
                ->where('date', $date)
                ->where('duety_name', $duety_name)
                ->where('exam_id', $exam_id)
                ->where_in('session', $sessionsToDelete)
                ->delete('duety_allocation');
        }
    
        // Insert new checked sessions
        foreach ($sessionsToInsert as $session) {
            $DB1->insert('duety_allocation', [
                'emp_id' => $emp_id,
                'date' => $date,
                'session' => $session,
                'duety_name' => $duety_name,
                'exam_id' => $exam_id
            ]);
        }
    }
    
    
    // Function to fetch duty allocations with joins
    public function getDutyAllocations()
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('da.id, da.emp_id, da.date, da.session, da.duety_name, da.attendance, em.fname, em.lname');
        $DB1->from('sandipun_ums.duety_allocation da');
        $DB1->join('sandipun_erp.employee_master em', 'em.emp_id = da.emp_id', 'left');  // Join with employee master
        $DB1->join('sandipun_ums.exam_session es', 'es.exam_id = da.exam_id', 'left');  // Join with exam session (if necessary)
        $DB1->order_by('da.date', 'DESC');  // You can adjust the ordering as needed
        $query = $DB1->get();
        //    echo $DB1->last_query();exit;
        return $query->result();

    }

    public function markAttendance($attendance_data)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        // Loop through each attendance entry and update the attendance status

        foreach ($attendance_data as $id => $attendance_status) {
//          print_r($attendance_data);exit;
    //     echo ($attendance_status == 'P') ? 'P' : 'A';
    //    exit;

            $DB1->where('id', $id);
            $DB1->update('duety_allocation', ['attendance' => $attendance_status]);
        }
    }

    public function getEmployeeData($emp_id) {
        $DB1 = $this->load->database('umsdb', TRUE);

        $sql="SELECT ecr.name, ecr.mobile, ecr.email, es.exam_name, c.center_name, er.role_name FROM `ecr_emp_reg` ecr LEFT JOIN exam_session es ON es.exam_id = ecr.exam_id LEFT JOIN exam_center_master c ON c.ec_id = ecr.center_id LEFT JOIN ecr_roles er ON er.ecr_role_id = ecr.ecr_role WHERE ecr.emp_id = $emp_id";
        $query = $DB1->query($sql);
        return $query->row_array();
        //echo $DB1->last_query();exit;
    }

    public function getFilteredDutyAllocations($filter_date = null, $filter_role = null, $filter_exam = null)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
    
        // Select fields with conditional logic to handle `is_replaced`
        $sql = "
        SELECT 
            da.id, 
            da.emp_id, 
            da.replace_emp_id, 
            da.is_replaced, 
            da.date, 
            da.session, 
            da.duety_name, 
            da.attendance, 
            da.exam_id,
            es.exam_name,
            ecr.email,
            er.role_name,
            CONCAT(
                IF(da.is_replaced = 1, em_replace.fname, em.fname),
                ' ', 
                IF(da.is_replaced = 1, em_replace.mname, em.mname),
                ' ', 
                IF(da.is_replaced = 1, em_replace.lname, em.lname)
            ) AS name
        FROM 
            sandipun_ums.duety_allocation da
        LEFT JOIN 
            sandipun_erp.employee_master em ON em.emp_id = da.emp_id
        LEFT JOIN 
            sandipun_erp.employee_master em_replace ON em_replace.emp_id = da.replace_emp_id
        LEFT JOIN 
            sandipun_ums.exam_session es ON es.exam_id = da.exam_id
        LEFT JOIN 
            sandipun_ums.ecr_emp_reg ecr ON ecr.emp_id = IF(da.is_replaced = 1, em_replace.emp_id, em.emp_id)
        LEFT JOIN 
            sandipun_ums.ecr_roles er ON er.ecr_role_id = ecr.ecr_role
    ";
    
    if (!empty($filter_date)) {
        $sql .= " WHERE da.date = '" . $filter_date . "'";
    }
    
    if (!empty($filter_role)) {
        if (strpos($sql, 'WHERE') === false) {
            $sql .= " WHERE da.duety_name = '" . $filter_role . "'";
        } else {
            $sql .= " AND da.duety_name = '" . $filter_role . "'";
        }
    }
    if (!empty($filter_exam)) {
        if (strpos($sql, 'WHERE') === false) {
            $sql .= " WHERE da.exam_id = '" . $filter_exam . "'";
        } else {
            $sql .= " AND da.exam_id = '" . $filter_exam . "'";
        }
    }
    
    $sql .= " ORDER BY da.date DESC";
    $query = $DB1->query($sql);
//        echo'<pre>';
//        echo $DB1->last_query();exit;
        return $query->result();
    }
    
    

    public function getEmployeeDetailsFromEcr($employee_id,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $query = $DB1->query("
        SELECT * FROM `ecr_emp_reg` where emp_id= ? and exam_id = ? and ecr_role != 1;
        ", [$employee_id , $exam_id]);
        //  echo $DB1->last_query();exit;
        return $query->row();
    }

    public function updateAllocation($allocation_id, $data)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->where('id', $allocation_id);
        $DB1->update('duety_allocation', $data);
    }



}

?>