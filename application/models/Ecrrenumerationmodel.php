<?php

class Ecrrenumerationmodel extends CI_Model {

    /////////////////////////////////////////////////// code by JP ////////////////////////////////////////////////

    // Get joined data for view
    public function getRenumData() {

        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('r.id, r.academic_year, r.renum, ecr.role_name, es.exam_name, r.additional_ssn_count, r.ecr_role_id, r.exam_id');
        $DB1->from('ecr_renum r');
        $DB1->join('ecr_roles ecr', 'ecr.ecr_role_id = r.ecr_role_id', 'left');
        $DB1->join('exam_session es', 'es.exam_id = r.exam_id', 'left');
		$DB1->order_by('r.id', 'DESC');
        $query = $DB1->get();

        // echo $DB1->last_query();exit;

        return $query->result_array();

    }

    // Get ECR Roles
    public function getEcrRoles() {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('ecr_role_id, role_name');
        $DB1->from('ecr_roles');
        $query = $DB1->get();
        return $query->result_array();
    }

    // Get Exam Sessions
    public function getExamSessions() {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('exam_id, exam_name');
        $DB1->from('exam_session');
        $DB1->where('active_for_exam', 'Y');
        $query = $DB1->get();
        return $query->result_array();
    }

public function checkExistingEntry($exam_id, $ecr_role_id) {
    // Query to check if an entry with the same exam_id and ecr_role_id already exists
    $DB1 = $this->load->database('umsdb', TRUE);

    $DB1->where('exam_id', $exam_id);
    $DB1->where('ecr_role_id', $ecr_role_id);
    $query = $DB1->get('ecr_renum'); // Replace with your table name

    // Return true if the entry exists, false otherwise
    return $query->num_rows() > 0;
}

    // Insert a new renum record
    public function insertRenum($data) {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->insert('ecr_renum', $data);
    }

    public function updateRenum($id, $data) {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->where('id', $id);
        $DB1->update('ecr_renum', $data);
    }

        public function getEmployeesByExamAndRole($exam_id, $role_id) {
            $DB1 = $this->load->database('umsdb', TRUE);
            $centers = $this->session->userdata('center_ids');
            // Build additional WHERE conditions
            $whereExtras = "";
        
            if (!empty($centers)) {
                $center_list = implode(',', array_map('intval', $centers)); // sanitize values
                $whereExtras .= " AND center_id IN ($center_list)";
            }
            
            $sql = "
                SELECT emp_id, CONCAT(fname, ' ', lname, ' ') AS name
                FROM sandipun_erp.employee_master
                WHERE emp_id IN (
                    SELECT emp_id FROM sandipun_ums.ecr_emp_reg 
                    WHERE exam_id = '$exam_id' AND ecr_role = '$role_id' $whereExtras
                )
            ";
           $query =  $DB1->query($sql); 
          // echo $DB1->last_query();exit;
           return $query->result_array();
        }

        
        public function getEmployeePaymentData($exam_id, $role_id, $emp_id = null) {
            $DB1 = $this->load->database('umsdb', TRUE);
        
            // Dynamic condition to fetch specific employee or all employees
            $emp_condition = $emp_id ? "AND                 CASE 
                    WHEN da.is_replaced = 1 THEN da.replace_emp_id 
                    ELSE da.emp_id 
                END = '$emp_id'" : "";
        
            $sql = "
            SELECT 
                da.emp_id, 
                CASE 
                    WHEN da.is_replaced = 1 THEN da.replace_emp_id 
                    ELSE da.emp_id 
                END AS effective_emp_id,
					COALESCE(
						NULLIF(
							TRIM(
								CONCAT_WS(
									' ',
									CASE WHEN da.is_replaced = 1 THEN em_replace.fname ELSE em.fname END,
									CASE WHEN da.is_replaced = 1 THEN em_replace.lname ELSE em.lname END
								)
							),
							'' 
						),
						ecr.name
					) AS name,
                CASE 
                    WHEN da.attendance = 'P' AND da.session IN ('AN', 'FN') THEN 1 * er.renum
                    ELSE 0
                    END
                    + (COALESCE(er.additional_ssn_count, 0) * er.renum) AS total_payment,
                da.session,
                da.attendance,
                da.duety_name,
                da.attendance,
                da.date,
                er.renum,
                er.additional_ssn_count
            FROM 
                sandipun_ums.duety_allocation AS da
            LEFT JOIN 
                sandipun_erp.employee_master AS em ON em.emp_id = da.emp_id and em.emp_status = 'Y'
            LEFT JOIN 
                sandipun_erp.employee_master AS em_replace ON em_replace.emp_id = da.replace_emp_id  and em_replace.emp_status = 'Y'
            LEFT JOIN 
                sandipun_ums.ecr_renum AS er ON er.ecr_role_id = da.duety_name AND er.exam_id = da.exam_id
			LEFT JOIN 
                sandipun_ums.ecr_emp_reg AS ecr ON ecr.emp_id = da.emp_id AND ecr.exam_id = da.exam_id AND ecr.is_active = 1
            WHERE 
                da.is_active = 1 and 
                da.exam_id = '$exam_id'
                AND da.duety_name = '$role_id'
                AND da.attendance != 'A'
                $emp_condition
            ";
        
            $query = $DB1->query($sql);
			// echo $DB1->last_query();exit;
            $employees = $query->result_array();
            $employee_payments = [];
        
            // Calculate total present sessions and payment for each employee
            foreach ($employees as $employee) {
                $total_present_count = 0;
        
                if ($employee['attendance'] == 'P') {
                    $total_present_count += ($employee['session'] == 'BOTH') ? 2 : 1;
        
                    if (in_array($employee['duety_name'], [5, 6])) {
                        $total_present_count = 1;
                    }
                }
        
                // Calculate payment
                $payment = $total_present_count * $employee['renum'];
        
                $employee_payments[] = [
                    'emp_id' => $employee['effective_emp_id'],
                    'name' => $employee['name'],
                    'date' => $employee['date'],
                    'session' => $employee['session'],
                    'attendance' => $employee['attendance'],
                    'total_present' => $total_present_count,
                    'renum' => $employee['renum'],
                    'additional_ssn_count' => $employee['additional_ssn_count'],
                    'payment' => $payment
                ];
            }
        
            return $employee_payments;
        }
        public function getEmployeePaymentDataBySessionDate($exam_id = null, $role_id = null, $date = null, $session = null, $center_id = null) {
            $DB1 = $this->load->database('umsdb', TRUE);
        
            $date_condition = $date ? "AND da.date = '$date'" : "";
            $session_condition = $session ? "AND da.session = '$session'" : "";
        
            $sql = "
                SELECT 
                    da.emp_id, 
                    CASE 
                        WHEN da.is_replaced = 1 THEN da.replace_emp_id 
                        ELSE da.emp_id 
                    END AS effective_emp_id,
					COALESCE(
						NULLIF(
							TRIM(
								CONCAT_WS(
									' ',
									CASE WHEN da.is_replaced = 1 THEN em_replace.fname ELSE em.fname END,
									CASE WHEN da.is_replaced = 1 THEN em_replace.lname ELSE em.lname END
								)
							),
							''  -- if empty string, treat as NULL
						),
						ecr.name  -- <-- adjust to the actual column name in ecr_emp_reg (e.g., ecr.emp_name)
					) AS name,
                    da.session,
                    da.attendance,
                    da.duety_name,
                    da.date,
                    er.renum,
                    er.additional_ssn_count
                FROM 
                    sandipun_ums.duety_allocation AS da
                LEFT JOIN 
                    sandipun_erp.employee_master AS em ON em.emp_id = da.emp_id and em.emp_status = 'Y'
                LEFT JOIN 
                    sandipun_erp.employee_master AS em_replace ON em_replace.emp_id = da.replace_emp_id and em_replace.emp_status = 'Y'
                LEFT JOIN 
                    sandipun_ums.ecr_renum AS er ON er.ecr_role_id = da.duety_name AND er.exam_id = da.exam_id
                LEFT JOIN 
                    sandipun_ums.ecr_emp_reg AS ecr ON ecr.emp_id = da.emp_id AND ecr.exam_id = da.exam_id  AND ecr.is_active = 1
                WHERE 
                    da.is_active = 1 and 
                    da.exam_id = '$exam_id'
                    AND da.duety_name = '$role_id'
                    AND ecr.center_id = '$center_id'
                    AND da.attendance != 'A'
                    $date_condition
                    $session_condition
            ";
        
            $query = $DB1->query($sql);
            $employees = $query->result_array();
            $employee_payments = [];
        
            foreach ($employees as $employee) {
                $total_present_count = ($employee['attendance'] == 'P') ? (($employee['session'] == 'BOTH') ? 2 : 1) : 0;
        
                if (in_array($employee['duety_name'], [5, 6])) {
                    $total_present_count = 1;
                }
        
                $payment = $total_present_count * $employee['renum'];
                
                $employee_payments[] = [
                    'emp_id' => $employee['effective_emp_id'],
                    'name' => $employee['name'],
                    'date' => $employee['date'],
                    'session' => $employee['session'],
                    'attendance' => $employee['attendance'],
                    'total_present' => $total_present_count,
                    'renum' => $employee['renum'],
                    'payment' => $payment,
                    'additional_ssn_count' => $employee['additional_ssn_count']
                ];
            }
        
            return $employee_payments;
        }
        
        
         public function getConsolidatedPaymentData($exam_id = null, $role_id = null) {
            $DB1 = $this->load->database('umsdb', TRUE);
            
            $centers = $this->session->userdata('center_ids');
            $user_role = $this->session->userdata('role_id');
        
            // Build additional WHERE conditions
            $whereExtras = "";
        
            if (!empty($centers)) {
                $center_list = implode(',', array_map('intval', $centers)); // sanitize values
                $whereExtras .= " AND ecr.center_id IN ($center_list)";
            }
        
            if ($user_role != 15) {
                $whereExtras .= ""; //  AND da.duety_name != 1
            }
            if (!empty($role_id)) {
                $whereExtras .= " AND da.duety_name = " . intval($role_id);
            }
        
            $sql = "
                SELECT  
                    da.emp_id,  
                    CASE    
                        WHEN da.is_replaced = 1 THEN da.replace_emp_id  
                        ELSE da.emp_id  
                    END AS effective_emp_id,    
					COALESCE(
						NULLIF(
							TRIM(
								CONCAT_WS(
									' ',
									CASE WHEN da.is_replaced = 1 THEN em_replace.fname ELSE em.fname END,
									CASE WHEN da.is_replaced = 1 THEN em_replace.lname ELSE em.lname END
								)
							),
							''  -- if empty string, treat as NULL
						),
						ecr.name  -- <-- adjust to the actual column name in ecr_emp_reg (e.g., ecr.emp_name)
					) AS name,
                    er.renum,  
					SUM(    
                        CASE    
                            WHEN da.attendance = 'P' AND da.session IN ('AN', 'FN') THEN 1  
                            ELSE 0  
                        END 
                    ) as pr_ssn,
					er.additional_ssn_count as extra_ssn,				
                    SUM(    
                        CASE    
                            WHEN da.attendance = 'P' AND da.session IN ('AN', 'FN') THEN 1  
                            ELSE 0  
                        END 
                    ) + COALESCE(er.additional_ssn_count, 0) AS total_present_sessions, 
                    SUM(    
                        CASE    
                            WHEN da.attendance = 'P' AND da.session IN ('AN', 'FN') THEN 1 * er.renum   
                            ELSE 0  
                        END 
                    ) + (COALESCE(er.additional_ssn_count, 0) * er.renum) AS total_payment, 
                    da.exam_id, 
                    da.duety_name,
					ecr.bank_name,
					ecr.acc_no,
					ecr.ifsc,
					ecr.branch_name,
					ecr.mobile,
					role.role_name
                FROM    
                    sandipun_ums.duety_allocation AS da 
                LEFT JOIN   
					sandipun_ums.ecr_roles as role on role.ecr_role_id = da.duety_name
				LEFT JOIN
                    sandipun_erp.employee_master AS em ON em.emp_id = da.emp_id and em.emp_status = 'Y'
                LEFT JOIN   
                    sandipun_erp.employee_master AS em_replace ON em_replace.emp_id = da.replace_emp_id and em_replace.emp_status = 'Y'
                LEFT JOIN   
                    sandipun_ums.ecr_renum AS er ON er.ecr_role_id = da.duety_name AND er.exam_id = da.exam_id  
                LEFT JOIN 
                    sandipun_ums.ecr_emp_reg AS ecr ON ecr.emp_id = da.emp_id AND ecr.exam_id = '$exam_id' and ecr.is_active = 1
                WHERE   
                    da.is_active = 1 and 
                    da.exam_id = '$exam_id' AND 
                    da.attendance != 'A'    
                    $whereExtras
                GROUP BY    
                    effective_emp_id, er.renum    
            ";  
        
            $query = $DB1->query($sql);
            //  echo $DB1->last_query();exit;
           return $query->result_array();
        }

        public function getRoleWisePaymentData($exam_id = null, $date = null, $session = null) {
            $DB1 = $this->load->database('umsdb', TRUE);
            $centers = $this->session->userdata('center_ids');
            $user_role = $this->session->userdata('role_id');
			
            $DB1->select('da.duety_name, ers.role_name AS role, SUM(er.renum) + (er.renum * (er.additional_ssn_count * COUNT(DISTINCT ecr.emp_id))) AS total_payment');
            $DB1->from('sandipun_ums.duety_allocation AS da');
			$DB1->join('sandipun_ums.ecr_emp_reg AS ecr', 'ecr.ecr_role = da.duety_name AND ecr.emp_id = da.emp_id AND ecr.is_active = 1 AND ecr.exam_id = "'.$exam_id.'"', 'left');
            $DB1->join('sandipun_ums.ecr_renum AS er', 'er.ecr_role_id = da.duety_name AND er.exam_id = da.exam_id', 'left');
            $DB1->join('sandipun_ums.ecr_roles AS ers', 'ers.ecr_role_id = da.duety_name', 'left');
            $DB1->where('da.is_active',1);
            // Add conditions only if parameters are provided
            if (!empty($exam_id)) {
                $DB1->where('da.exam_id', $exam_id);
            }
            if (!empty($date)) {
                $DB1->where('da.date', $date);
            }
            if (!empty($session)) {
                $DB1->where('da.session', $session);
            }if (!empty($centers)) {
                $center_list = implode(',', array_map('intval', $centers)); // sanitize values
				$DB1->where('ecr.center_id', ($center_list));
            }
        
            $DB1->where('da.attendance !=', 'A');
            $DB1->group_by('da.duety_name');
        
            $query = $DB1->get();
        
            // Uncomment this line to see the generated query for debugging
			//  echo '<pre>';
            //  echo $DB1->last_query(); exit;
        
            return $query->result_array();
        }
        
        
            /////////////////////////////////////////////////// end ////////////////////////////////////////////////

        
}
