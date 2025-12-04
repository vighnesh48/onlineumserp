<?php
class Ecrempregmodel extends CI_Model
{
	echo 'hoo';exit;

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
        $centers = $this->session->userdata('center_ids');
        if (!empty($centers)) {
            $DB1->where_in('ec_id', $centers);
        }
        $DB1->select('ec_id, center_name, center_code');
        $DB1->from('exam_center_master');
        $DB1->where('is_active', 'Y');
        $query = $DB1->get();
        return $query->result();
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

    public function generateEmployeeId($ecr_role_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
    
        // Determine prefix based on role
        if ($ecr_role_id == 6) {
            $prefix = 'P';
        } elseif ($ecr_role_id == 9) {
            $prefix = 'S';
        } else {
            return null; // Invalid role for ID generation
        }
    
        // Get the last inserted employee_id with the same prefix
        $DB1->select('emp_id');
		$DB1->where('is_active', 1);
		$DB1->where('ecr_role', $ecr_role_id);
        $DB1->like('emp_id', $prefix, 'after'); // WHERE emp_id LIKE 'P%' or 'S%'
        $DB1->order_by('emp_id', 'DESC');
        $DB1->limit(1);
    
        $query = $DB1->get('ecr_emp_reg');
    
		//echo $DB1->last_query();exit;
        $lastId = $query->row('emp_id');
     
        if ($lastId) {
            // Extract numeric part and increment
            $num = (int)substr($lastId, 1); // remove P or S
            $newNum = $num + 1;
        } else {
            $newNum = 1; // first ID
        }
		
        // Pad with leading zeros
        $newId = $prefix . str_pad($newNum, 5, '0', STR_PAD_LEFT);
		
		//echo $newId;exit;
    
        return $newId;
    }
    
    public function searchEmployeeByIdOrName_old($query)
    {
        $search_query = $query; // Preserve the original input query in a different variable

        $this->db->select("
            employee_master.emp_id,
            CONCAT_WS(' ', employee_master.fname, employee_master.mname, employee_master.lname, '') AS full_name,
            employe_other_details.oemail,
            employe_other_details.mobileNumber
        ");
        $this->db->from('employee_master');
        $this->db->join('employe_other_details', 'employee_master.emp_id = employe_other_details.emp_id', 'left');
        $this->db->group_start();
        $this->db->like('employee_master.emp_id', $search_query);
        $this->db->or_like('employee_master.fname', $search_query);
        $this->db->or_like('employee_master.mname', $search_query);
        $this->db->or_like('employee_master.lname', $search_query);
        $this->db->group_end();
        $this->db->where('employee_master.emp_status', 'Y');
        $this->db->limit(10);
        
        $result = $this->db->get(); // Store the result in a separate variable
       // echo $this->db->last_query();exit;  
        return $result->result();   // Or handle it as needed
    }
     public function searchEmployeeByIdOrName($query)
{

    $search_query = $this->db->escape_like_str($query);

    $sql = "
        (
            SELECT 
                em.emp_id, 
                CONCAT_WS(' ', em.fname, em.mname, em.lname) AS full_name, 
                eod.oemail, 
                eod.mobileNumber
            FROM employee_master em
            LEFT JOIN employe_other_details eod ON em.emp_id = eod.emp_id
            WHERE em.emp_status = 'Y' 
                AND (
                    em.emp_id LIKE '%$search_query%' OR
                    em.fname LIKE '%$search_query%' OR
                    em.mname LIKE '%$search_query%' OR
                    em.lname LIKE '%$search_query%'
                )
        )
        UNION
        (
            SELECT 
                ext.ext_faculty_code AS emp_id, 
                ext.ext_fac_name AS full_name, 
                ext.ext_fac_email AS oemail, 
                ext.ext_fac_mobile AS mobileNumber
            FROM sandipun_ums.exam_external_faculty_master ext
            WHERE ext.status = 'Y'
                AND (
                    ext.ext_faculty_code LIKE '%$search_query%' OR
                    ext.ext_fac_name LIKE '%$search_query%'
                )
        )
        LIMIT 10
    ";

    $query = $this->db->query($sql);
   // echo $this->db->last_query();exit;
    return $query->result();
}
    // Get ECR Roles
    public function getAllEcrRoles()
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('ecr_role_id, role_name');
        $DB1->from('ecr_roles');
        $query = $DB1->get();
        return $query->result();
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

    public function searchEmployees($search_term)
    {
        // Sanitize the search term to prevent SQL injection
        $search_term = $this->db->escape_like_str($search_term);
    
        // Query the employee_master table for employees that match the search term (either by employee_id or name)
        $this->db->select('employee_id, name');
        $this->db->from('employee_master');
        $this->db->like('employee_id', $search_term);  // Search by employee ID
        $this->db->or_like('name', $search_term);       // Or search by employee name
        

    
        // Limit the number of results to prevent overwhelming the user
        $this->db->limit(10); // Adjust the limit as needed
    
        $query = $this->db->get();
    
        return $query->result(); // Return the result as an array of employee objects
    }
    

    public function checkEmployeeExistence($emp_id, $exam_id) {
        $DB1 = $this->load->database('umsdb', TRUE);

		// if(!empty($emp_id)){
        $DB1->where('emp_id', $emp_id);
		// }
        $DB1->where('exam_id', $exam_id);
		$DB1->where('is_active', 1);
        $query = $DB1->get('ecr_emp_reg');
        return $query->num_rows() > 0; // If a matching row exists
    }
    public function checkRoleExistence($exam_id, $ecr_role_id) {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->where('exam_id', $exam_id);
        $DB1->where('ecr_role', $ecr_role_id);
        $query = $DB1->get('ecr_emp_reg');
        return $query->num_rows() > 0; // If a record with the same exam_id and ecr_role exists
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
        $centers = $this->session->userdata('center_ids');
        $user_role = $this->session->userdata('role_id');
        if (!empty($centers)) {
            $DB1->where_in('ecr_emp_reg.center_id', $centers);
        }
        if ($user_role != 15) {
            $DB1->where_not_in('ecr_emp_reg.ecr_role', 1);
        }
        $DB1->select('ecr_emp_reg.*,exam_session.exam_name,exam_center_master.center_name,school_master.school_short_name,ecr_roles.role_name')->from('ecr_emp_reg');
        $DB1->join('exam_session', 'exam_session.exam_id = ecr_emp_reg.exam_id', 'left');
        $DB1->join('exam_center_master', 'exam_center_master.ec_id = ecr_emp_reg.center_id', 'left');
        $DB1->join('school_master', 'school_master.school_id = ecr_emp_reg.school_id', 'left');
        $DB1->join('ecr_roles', 'ecr_roles.ecr_role_id = ecr_emp_reg.ecr_role', 'left');
        $DB1->where('exam_session.is_active', 1);
		$DB1->where('ecr_emp_reg.is_active', 1);
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
            // echo $DB1->last_query();exit;
        return $query->result();
    }
    public function getSessions()
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        return $DB1->distinct()->select('session')->get('examtime_slot')->result();
    }

    public function getEmployeesByRole($role_id, $exam_id, $center_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('ecr_emp_reg.*,exam_session.exam_name,exam_center_master.center_name,school_master.school_short_name,ecr_roles.role_name')->from('ecr_emp_reg');
        $DB1->join('exam_session', 'exam_session.exam_id = ecr_emp_reg.exam_id', 'left');
        $DB1->join('exam_center_master', 'exam_center_master.ec_id = ecr_emp_reg.center_id', 'left');
        $DB1->join('school_master', 'school_master.school_id = ecr_emp_reg.school_id', 'left');
        $DB1->join('ecr_roles', 'ecr_roles.ecr_role_id = ecr_emp_reg.ecr_role', 'left');
        $DB1->where('ecr_role', $role_id);
        $DB1->where('ecr_emp_reg.exam_id', $exam_id);
        $DB1->where('ecr_emp_reg.center_id', $center_id);
        $DB1->where('ecr_emp_reg.is_active', 1);

        $query = $DB1->get();
        //  echo $DB1->last_query();exit;
        return $query->result();
    }
    public function getExamDatesBySession($exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select('DISTINCT(et.date)');
        $DB1->from('exam_time_table et');
        $DB1->join('subject_master sm', 'sm.sub_id = et.subject_id', 'left');
        $DB1->where('sm.subject_component', 'TH');
        $DB1->where('et.exam_id', $exam_id);
		$arr_dates=array('2000-01-01','0000-00-00','1970-01-01');
        $DB1->where_not_in('et.date', $arr_dates);
        $DB1->order_by('et.date', 'ASC');
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
        $DB1->select('*');
        $DB1->from('duety_allocation');
        $DB1->where('is_active', 1);
        $query = $DB1->get();

        return $query->result();
    }
    public function getAllocations($exam_id, $role_id, $center_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('da.emp_id, da.replace_emp_id, da.is_replaced, da.date, da.session');
        $DB1->from('duety_allocation da');
        $DB1->join('ecr_emp_reg eer', 'eer.emp_id = da.emp_id', 'left');
        $DB1->where('da.exam_id', $exam_id);
        $DB1->where('da.duety_name', $role_id);
        $DB1->where('eer.center_id', $center_id);
        $DB1->where('eer.is_active', 1);
        $DB1->where('da.is_active', 1);
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

    public function insertOrDeleteAllocation($emp_id, $date, $sessions, $duety_name, $exam_id, $center_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        // Get existing entries for the specific employee, date, duty name, and exam ID
        $existingSessions = $DB1->select('session')
            ->from('duety_allocation')
            ->where('emp_id', $emp_id)
            ->where('date', $date)
            ->where('duety_name', $duety_name)
            ->where('exam_id', $exam_id)
            ->where('center_id', $center_id)
            ->where('is_active', 1)
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
                ->where('center_id', $center_id)
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
                'center_id' => $center_id,
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
		$DB1->where('da.is_active', 1);
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
            $DB1->where('is_active', 1);
            $DB1->update('duety_allocation', ['attendance' => $attendance_status]);
        }
    }
    public function isVerified($exam_id, $role_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('emp_id');
        $DB1->from('duty_verification');
        $DB1->where('exam_id', $exam_id);
        $DB1->where('role_id', $role_id);
        $DB1->where('is_verified', 1);
        $query = $DB1->get();
        // echo $DB1->last_query();exit;

        return $query->result();

    }
    public function isLetterSent($exam_id, $role_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('emp_id');
        $DB1->from('duty_verification');
        $DB1->where('exam_id', $exam_id);
        $DB1->where('role_id', $role_id);
        $DB1->where('letter_sent', 1);
        $query = $DB1->get();
        // echo $DB1->last_query();exit;

        return $query->result();

    }
    public function getEmployeeData($emp_id, $exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $sql = "SELECT ecr.emp_id,ecr.name,ecr.exam_id,ecr.ecr_role, ecr.mobile, ecr.email, es.exam_name,es.exam_type,es.exam_year, c.center_name, er.role_name,dm.designation_name as designation,dms.department_name as department
        FROM `ecr_emp_reg` ecr 
        LEFT JOIN exam_session es ON es.exam_id = ecr.exam_id 
        LEFT JOIN sandipun_erp.employee_master em ON em.emp_id = ecr.emp_id
        LEFT JOIN sandipun_erp.designation_master dm ON dm.designation_id = em.designation 
        LEFT JOIN sandipun_erp.department_master dms ON dms.department_id = em.department 
        LEFT JOIN exam_center_master c ON c.ec_id = ecr.center_id 
        LEFT JOIN ecr_roles er ON er.ecr_role_id = ecr.ecr_role 

        WHERE ecr.emp_id = '$emp_id' and es.exam_id = $exam_id";
        $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
        return $query->row_array();

    }
    public function getNewRefNo($exam_id, $emp_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select('ref_no');
        $DB1->from('duty_verification');
        $DB1->where('exam_id', $exam_id);
        $DB1->where('emp_id', $emp_id);
		
        $query = $DB1->get();
		//echo $DB1->last_query();exit;
        return $query->row_array();
    }
    public function getEmployeesByRoleAndExam($exam_id, $center_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select('name, mobile');
        $DB1->from('ecr_emp_reg');
        $DB1->where('ecr_role', 1);
        $DB1->where('exam_id', $exam_id);        
		$DB1->where('center_id', $center_id);
        $query = $DB1->get();
      // echo $DB1->last_query();exit;
        return $query->row_array();
    }
    public function getDuietyDates($employee_data)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select('DISTINCT(date),session');
        $DB1->from('duety_allocation');
        $DB1->where('exam_id', $employee_data['exam_id']);
        $DB1->where('duety_name', $employee_data['ecr_role']);
        $DB1->where('emp_id', $employee_data['emp_id']);
		$arr_dates=array('2000-01-01','0000-00-00','1970-01-01','2000-01-22','2000-01-14','2000-01-21');
        $DB1->where_not_in('date', $arr_dates);
        $DB1->where('is_active', 1);
        $query = $DB1->get();
        //  echo $DB1->last_query();exit;
        return $query->result_array();
    }

    public function getFilteredDutyAllocations($filter_date = null, $filter_role = null, $filter_exam = null,  $filter_center = null, $session = null)
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
			COALESCE(
				NULLIF(
					CONCAT(
						IF(da.is_replaced = 1, em_replace.fname, em.fname),
						' ',
						IF(da.is_replaced = 1, em_replace.mname, em.mname),
						' ',
						IF(da.is_replaced = 1, em_replace.lname, em.lname)
					), '  '
				),
				ecr.name
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
            sandipun_ums.ecr_emp_reg ecr ON ecr.emp_id = IF(da.is_replaced = 1, em_replace.emp_id, da.emp_id)
        LEFT JOIN 
            sandipun_ums.ecr_roles er ON er.ecr_role_id = ecr.ecr_role
        LEFT JOIN 
            sandipun_ums.duty_verification dv ON dv.emp_id = da.emp_id
        WHERE 
           da.is_active = 1 and ecr.is_active = 1 AND dv.is_verified = 1";

		if($filter_role == 1 || $filter_role == 2 || $filter_role == 7){
			$sql .= " AND  dv.letter_sent = 1";
		}
        if (!empty($filter_date)) {
            $sql .= " AND da.date = '" . $filter_date . "'";
        }

        if (!empty($filter_role)) {
            if (strpos($sql, 'WHERE') === false) {
                $sql .= " AND da.duety_name = '" . $filter_role . "'";
            } else {
                $sql .= " AND da.duety_name = '" . $filter_role . "'";
            }
        }
        if (!empty($filter_exam)) {
            if (strpos($sql, 'WHERE') === false) {
                $sql .= " AND da.exam_id = '" . $filter_exam . "'";
            } else {
                $sql .= " AND da.exam_id = '" . $filter_exam . "'";
            }
        }
        if (!empty($filter_center)) {
            if (strpos($sql, 'WHERE') === false) {
                $sql .= " AND ecr.center_id = '" . $filter_center . "'";
            } else {
                $sql .= " AND ecr.center_id = '" . $filter_center . "'";
            }
        }
        if (!empty($session)) {
            if (strpos($sql, 'WHERE') === false) {
                $sql .= " AND da.session = '" . $session . "'";
            } else {
                $sql .= " AND da.session = '" . $session . "'";
            }

        }

        $sql .= "ORDER BY da.date DESC";
        $query = $DB1->query($sql);
        // echo'<pre>';
        // echo $DB1->last_query();exit;
        return $query->result();
    }


    public function getFilteredDutyAllocations_hall($filter_date = null, $filter_role = null, $filter_exam = null)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $centers = $this->session->userdata('center_ids');

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
            da.hall_id,
            es.exam_name,
            ecr.email,
            er.role_name,
            hm.building_id,
            hm.floor,
            ecba.center_id,
			COALESCE(
				NULLIF(
					CONCAT(
						IF(da.is_replaced = 1, em_replace.fname, em.fname),
						' ',
						IF(da.is_replaced = 1, em_replace.mname, em.mname),
						' ',
						IF(da.is_replaced = 1, em_replace.lname, em.lname)
					), '  '
				),
				ecr.name
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
        LEFT JOIN 
            sandipun_ums.duty_verification dv ON dv.emp_id = da.emp_id
        LEFT JOIN 
            sandipun_ums.hall_master hm ON hm.id = da.hall_id
        LEFT JOIN 
            sandipun_ums.exam_center_building_allocation ecba ON ecba.building_id = hm.building_id
        WHERE 
            da.is_active = 1 and ecr.is_active = 1 AND dv.is_verified = 1";
			
		if (!empty($centers) && is_array($centers)) {
			$centerList = implode(',', array_map('intval', $centers)); // sanitize input
			$sql .= " AND ecr.center_id IN ($centerList)";
		}
		
		if($filter_role == 1 || $filter_role == 2 || $filter_role == 7){
			$sql .= " AND  dv.letter_sent = 1";
		}
		
        if (!empty($filter_date)) {
            $sql .= " AND da.date = '" . $filter_date . "'";
        }

        if (!empty($filter_role)) {
            if (strpos($sql, 'WHERE') === false) {
                $sql .= " AND da.duety_name = '" . $filter_role . "'";
            } else {
                $sql .= " AND da.duety_name = '" . $filter_role . "'";
            }
        }
        if (!empty($filter_exam)) {
            if (strpos($sql, 'WHERE') === false) {
                $sql .= " AND da.exam_id = '" . $filter_exam . "'";
            } else {
                $sql .= " AND da.exam_id = '" . $filter_exam . "'";
            }
        }

        $sql .= " ORDER BY da.date DESC";
		
        $query = $DB1->query($sql);
		
        // echo'<pre>';
        // echo $DB1->last_query();exit;
		
        return $query->result();
    }

    public function getFilteredDutyAllocations_report($filter_date = null, $filter_role = null, $filter_exam = null,  $filter_center = null, $session = null )
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
                    ecr.mobile,
                    es.exam_name,
                    ecr.email,
                    er.role_name,
                    hm.hall_no,
                    hm.floor,
                    bm.building_name,
					COALESCE(
						NULLIF(
						TRIM(CONCAT(em.fname, ' ', em.mname, ' ', em.lname)),
						''
						),
						ecr.name
					) AS NAME,
                    CASE 
						WHEN da.is_replaced = 1 
						THEN CONCAT(em_replace.fname, ' ', em_replace.mname, ' ', em_replace.lname)
						ELSE NULL
					END AS replace_emp_name,
                    des.designation_name,
                    sch.college_code
                FROM 
                    sandipun_ums.duety_allocation da
                LEFT JOIN 
                    sandipun_erp.employee_master em ON em.emp_id = da.emp_id
                LEFT JOIN 
                    sandipun_erp.designation_master des ON des.designation_id = em.designation
                LEFT JOIN 
                    sandipun_erp.college_master sch ON sch.college_id = em.emp_school 
                LEFT JOIN
                    sandipun_erp.employee_master em_replace ON em_replace.emp_id = da.replace_emp_id
                LEFT JOIN 
                    sandipun_ums.exam_session es ON es.exam_id = da.exam_id
                LEFT JOIN 
				sandipun_ums.ecr_emp_reg ecr ON ecr.emp_id = 
				(
					CASE 
						WHEN da.is_replaced = 1 THEN em_replace.emp_id
						ELSE em.emp_id
					END
				)
                LEFT JOIN 
                    sandipun_ums.ecr_roles er ON er.ecr_role_id = ecr.ecr_role
                LEFT JOIN 
                    sandipun_ums.duty_verification dv ON dv.emp_id = da.emp_id
                LEFT JOIN 
                    sandipun_ums.hall_master hm ON hm.id = da.hall_id
                LEFT JOIN  
                    sandipun_ums.building_master bm ON bm.id = hm.building_id 
                WHERE 
            da.is_active = 1 and ecr.is_active = 1 AND dv.is_verified = 1 
			";

		if($filter_role == 1 || $filter_role == 2 || $filter_role == 7){
			$sql .= " AND  dv.letter_sent = 1";
		}
        if (!empty($filter_date)) {
            $sql .= " AND da.date = '" . $filter_date . "'";
        }

        if (!empty($filter_role)) {
            
            if (strpos($sql, 'WHERE') === false) {

                $sql .= " AND da.duety_name = '" . $filter_role . "'";

            } else {

                $sql .= " AND da.duety_name = '" . $filter_role . "'";

            }
        }
        if (!empty($filter_exam)) {
            if (strpos($sql, 'WHERE') === false) {
                $sql .= " AND da.exam_id = '" . $filter_exam . "'";
            } else {
                $sql .= " AND da.exam_id = '" . $filter_exam . "'";
            }
        }
        if (!empty($filter_center)) {
            if (strpos($sql, 'WHERE') === false) {
                $sql .= " AND ecr.center_id = '" . $filter_center . "'";
            } else {
                $sql .= " AND ecr.center_id = '" . $filter_center . "'";
            }
        }
        if (!empty($session)) {
            if (strpos($sql, 'WHERE') === false) {
                $sql .= " AND da.session = '" . $session . "'";
            } else {
                $sql .= " AND da.session = '" . $session . "'";
            }
        }

        $sql .= " ORDER BY da.date DESC  limit 40";
        $query = $DB1->query($sql);
		
		// echo'<pre>';
		// echo $DB1->last_query();exit;
	
        return $query->result_array();
    }


    public function getEmployeeDetailsFromEcr($employee_id, $exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $query = $DB1->query("
        SELECT * FROM `ecr_emp_reg` where emp_id= ? and exam_id = ? and ecr_role != 1;
        ", [$employee_id, $exam_id]);
        //  echo $DB1->last_query();exit;
        return $query->row();
    }

    

    public function updateAllocation($allocation_id, $data)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->where('id', $allocation_id);
        $DB1->where('is_active', 1);
        $DB1->update('duety_allocation', $data);
    }

    public function getDateWiseFaculty($date = null, $exam_id = null, $roleId = null, $centerId = null)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$centers = $this->session->userdata('center_ids');

        $DB1->distinct();
        $DB1->select('eer.name as faculty_name,replace.name as replace_faculty_name,replace.mobile as replace_faculty_mobile, eer.mobile, da.session, da.date, er.role_name, da.exam_id, es.exam_name');
        $DB1->from('duety_allocation as da');
        $DB1->join('ecr_emp_reg as eer', 'eer.emp_id = da.emp_id', 'left');
        $DB1->join('ecr_emp_reg as replace', 'replace.emp_id = da.replace_emp_id AND da.is_replaced = 1','left');
        $DB1->join('ecr_roles as er', 'eer.ecr_role = er.ecr_role_id','left');
        $DB1->join('exam_session as es', 'eer.exam_id = es.exam_id','left');
        $DB1->where('da.is_active', 1);
       // $DB1->where('da.attendance', 'P');

        // Apply filters if provided
        if ($date) {
            $DB1->where('da.date', $date);
        }
        if ($exam_id) {
            $DB1->where('da.exam_id', $exam_id);
        }
        if ($roleId) {
            $DB1->where('da.duety_name', $roleId);
        }
        if ($centerId) {
            $DB1->where('eer.center_id', $centerId);
        }
        if (!empty($centers)) {
            $DB1->where_in('eer.center_id', $centers);
        }
        // Order results by date, then session, then role
        $DB1->order_by('da.date', 'asc');
        $DB1->order_by('da.session', 'asc');
        $DB1->order_by('eer.ecr_role', 'asc');

        $query = $DB1->get();

       // echo $DB1->last_query();exit;
        $results = $query->result_array();



        // Organize results by date and session
        $groupedResults = [];
        foreach ($results as $row) {
            $date = $row['date'];
            $session = $row['session'];

            // Initialize arrays if not already present
            if (!isset($groupedResults[$date])) {
                $groupedResults[$date] = [];
            }
            if (!isset($groupedResults[$date][$session])) {
                $groupedResults[$date][$session] = [];
            }

            // Add faculty to the specific date and session group
            $groupedResults[$date][$session][] = [
                'faculty_name' => $row['faculty_name'],
                'replace_faculty_name' => $row['replace_faculty_name'],
                'role_name' => $row['role_name'],
                'mobile' => $row['mobile'],
                'replace_faculty_mobile' => $row['replace_faculty_mobile']
            ];
        }


        return $groupedResults;
    }
    public function getExamName($exam_id = null)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select('exam_name, exam_id');
        $DB1->from('exam_session');
        $DB1->where('active_for_exam', 'Y');
        if ($exam_id != null) {
            $DB1->where('exam_id', $exam_id);
        }
        $DB1->order_by('exam_id', 'asc');
        $query = $DB1->get();
        return $query->row_array();
    }
    public function getRoleName($role_id = null)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select('role_name');
        $DB1->from('ecr_roles');
        if ($role_id != null) {
            $DB1->where('ecr_role_id', $role_id);
        }
        $DB1->order_by('ecr_role_id', 'asc');
        $query = $DB1->get();
        return $query->row_array();
    }

    public function getBuildingsByCenter($center_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select('b.id, b.building_name')
            ->from('exam_center_building_allocation ecba')
            ->join('building_master b', 'ecba.building_id = b.id')
            ->where('ecba.center_id', $center_id);
        $query = $DB1->get();
        //    echo $DB1->last_query();exit;
        return $query->result();
    }

    public function getFloorsByBuilding($building_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->distinct()
            ->select('floor')
            ->from('hall_master')
            ->where('building_id', $building_id);
        $query = $DB1->get();
        return $query->result();
    }

    public function getHallsByFloor($building_id, $floor)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select('id,hall_no')
            ->from('hall_master')
            ->where('building_id', $building_id)
            ->where('floor', $floor);
        $query = $DB1->get();
        return $query->result();
    }

    public function getAllocationById($filter_role,$filter_exam,$allocation_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1 ->select('id, emp_id, duety_name');
        $DB1 ->from('duety_allocation');
        $DB1 ->where('id', $allocation_id);
        $DB1->where('da.is_active', 1);
        $query = $DB1 ->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }
    public function getEmployeeById($employee_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('emp_id, name, ecr_role');
        $DB1->from('ecr_emp_reg');
        $DB1->where('emp_id', $employee_id);
        $DB1->where('is_active', '1');
        $query = $DB1->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }
	
	public function getExamDetailsTime($exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);

        $sql = "SELECT es.exam_id,es.exam_name,es.exam_type,es.exam_year,ets.from_time,ets.session
                FROM exam_session es 
                LEFT JOIN examtime_slot ets on ets.exam_id = es.exam_id 
                WHERE es.exam_id = $exam_id and ets.is_active = 'Y' 
                ORDER BY ets.id ASC LIMIT 2 ";
        $query = $DB1->query($sql);
        return $query->result_array();

    }
	
	
	public function getExamCentersById($center)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $centers = $this->session->userdata('center_ids');

		$DB1->select('ec_id, center_name, center_code');
		$DB1->from('exam_center_master');
        $DB1->where('ec_id', $center);
        $DB1->where('is_active', 'Y');
		if (!empty($centers)) {
            $DB1->where_in('ec_id', $centers);
			}
          $query = $DB1->get();
        return $query->row_array();
    }
    public function getCenterIdIfUserExists($email)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('e.center_id');
        $DB1->from('ecr_emp_reg e');
        $DB1->join('exam_session es', 'e.exam_id = es.exam_id');
        $DB1->where('e.email', $email);
        $DB1->where('e.is_active', 1); // active employee
        $DB1->where('e.ecr_role', 1);
        $DB1->where('es.is_active', 'Y'); // active exam
        $query = $DB1->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }


}

?>