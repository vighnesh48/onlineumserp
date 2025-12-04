    <?php
    class Seating_model extends CI_Model {

        public function get_halls($floor, $building_id, $exam_id = '', $date = '', $session = '') {
            $DB1 = $this->load->database('umsdb', TRUE);
        
            // Fetch all halls for the given floor and building
            $DB1->select('*');
            $DB1->from('hall_master');
            $DB1->where('floor', $floor);
            $DB1->where('building_id', $building_id);
            $allHalls = $DB1->get()->result_array();
        
            // Fetch existing halls from exam_hall_seating_arrangement for the given exam, date, and session
            $DB1->select('hall');
            $DB1->from('exam_hall_seating_arrangement');
            $DB1->where('exam_id', $exam_id);
            $DB1->where('exam_date', $date);
            $DB1->where('session', $session);
            $DB1->where('floor', $floor);
            $DB1->where('building', $building_id);
			$DB1->where('is_active', 'Y');
            $existingHalls = $DB1->get()->result_array();
        
            // Extract existing hall numbers into an array
            $assignedHalls = array_column($existingHalls, 'hall');
        
            // Add 'used' key to each hall
            foreach ($allHalls as &$hall) {
                $hall['used'] = in_array($hall['hall_no'], $assignedHalls) ? 1 : 0;
            }
         //   echo '<pre>';
         //   print_r($allHalls);exit;
            // Return the halls with the 'used' key
            return $allHalls;
        }
        
        
              public function get_buildings() {
            $DB1 = $this->load->database('umsdb', TRUE);
            $centers = $this->session->userdata('center_ids');
            $user_role = $this->session->userdata('role_id');
            if (!empty($centers)) {
                $DB1->select('*');
                $DB1->from('exam_center_building_allocation');
                $DB1->where_in('center_id', $centers);
                
                $buildings = $DB1->get()->result_array();
                $building_ids = array_column($buildings, 'building_id');
            }

            $DB1->select('id, building_name');
            $DB1->from('building_master');
            if (!empty($building_ids)) {
                $DB1->where_in('id', $building_ids);
            }
            return $DB1->get()->result_array();
        }


        public function get_floors($building_id) {
            $DB1 = $this->load->database('umsdb', TRUE);
            $DB1->select('floor');
            $DB1->from('hall_master');
            $DB1->where('building_id', $building_id);
            $DB1->group_by('floor');
            return $DB1->get()->result_array();
        }

        public function get_selected_halls($floor, $building_id, $hall_ids) {

            $hall_ids_array = []; // Initialize an empty array
            foreach ($hall_ids as $hall) {
                $hall_ids_array[] = $hall; // Add each hall ID to the array
            }
            
        // If you need it in a variable but not as a string:
        //  print_r($hall_ids_array); // Outputs [14, 15]
    
        //  exit;

            $DB1 = $this->load->database('umsdb', TRUE);
            $DB1->select('*');
            $DB1->from('hall_master');
            $DB1->where('floor', $floor);
            $DB1->where('building_id', $building_id);
            $DB1->where_in('id', $hall_ids_array);
            $query = $DB1->get()->result_array();
        //  echo $DB1->last_query();exit;
            return $query;
        }
        public function create_seating1($students, $halls, $floor, $sub_id_count) {
    //  print_r($halls);exit;
            $arrangement = [];
            foreach ($halls as $hall) {
                // Extract rows, columns, and extra seats from the matrix
                preg_match('/(\d+) X (\d+)(?:\+(\d+))?/', $hall['matrix'], $matches);
                $rows = $matches[1];
                $columns = $matches[2];
                $extra = isset($matches[3]) ? (int)$matches[3] : 0;

                // Calculate the total number of seats
                $total_seats = ($rows * $columns);

                // echo '<pre>';
                // print_r($students);exit;

                // Initialize the seating for each hall
                $arrangement[$floor][$hall['hall_no']] = [
                    'floor' => $floor,
                    'rows' => $rows,
                    'columns' => $columns,
                    'extra' => $extra,
                    'seats' => array_splice($students, 0, $total_seats)
                ];

            //    print_r($arrangement[$floor][$hall['hall_no']]);exit;
        //       print_r($arrangement[$hall['floor']][$hall['hall_no']]);

            }

        //   exit;
            
            return $arrangement;
        }

        public function create_seating($students, $halls, $floor, $sub_id_count, $seating_type) {
            $arrangement = [];
            $remaining_students = $students; // Maintain a list of unallocated students
        
            if($seating_type == 'normal'){
                foreach ($halls as $hall) {
                    // Extract rows, columns, and extra seats from the matrix
                    $rows = $hall['matrix_rows'];
                    $columns = $hall['matrix_columns'];
                    $extra = $hall['matrix_extra'];
    
                    // Calculate the total number of seats
                    $total_seats = ($rows * $columns) + $extra;
    
                    // echo '<pre>';
                    // print_r($students);exit;
    
                    // Initialize the seating for each hall
                    $arrangement[$floor][$hall['hall_no']] = [
                        'floor' => $floor,
                        'rows' => $rows,
                        'columns' => $columns,
                        'extra' => $extra,
                        'seats' => array_splice($students, 0, $total_seats)
                    ];
    
                //    print_r($arrangement[$floor][$hall['hall_no']]);exit;
            //       print_r($arrangement[$hall['floor']][$hall['hall_no']]);
    
                }
            }else{
            foreach ($halls as $hall) {
                // Extract rows, columns, and extra seats from the matrix
             //   preg_match('/(\d+) X (\d+)(?:\+(\d+))?/', $hall['matrix'], $matches);
             //   $rows = (int) $matches[1];      // Total rows in hall
             //   $columns = (int) $matches[2];   // Total columns in hall
             //   $extra = isset($matches[3]) ? (int) $matches[3] : 0;
               
                $rows = $hall['matrix_rows'];
                $columns = $hall['matrix_columns'];
                $extra = $hall['matrix_extra'];
                // Total seats in the hall
                $total_seats = ($rows * $columns);
        
                // If no remaining students, stop further allocation
                if (empty($remaining_students)) {
                    continue;
                }
        
                // Group remaining students by subject ID
                $subject_students = [];
                foreach ($remaining_students as $student) {
                    $subject_students[$student['subject_id']][] = $student;
                }
        
                // Sort subjects by student count in descending order
                uasort($subject_students, function($a, $b) {
                    return count($b) - count($a);
                });
        
                // Number of unique subjects
                $num_subjects = count($subject_students);
                if ($num_subjects == 0) {
                    continue; // Skip if no subjects
                }
        
                $subject_ids = array_keys($subject_students);
                $assigned_seats = [];
        
                if ($num_subjects == 1) {
                    // **Single Subject Logic (Alternate with Spaces)**
                    $subject_id = $subject_ids[0];
                    for ($row = 0; $row < $columns; $row++) {
                        for ($col = 0; $col < $rows; $col++) {
                            if (($row + $col) % 2 == 0 && !empty($subject_students[$subject_id])) {
                                $assigned_seats[] = array_shift($subject_students[$subject_id]);
                            } else {
                                $assigned_seats[] = null; // Space
                            }
                        }
                    }
                } else {
                    // **Multiple Subjects (Even Distribution)**
                    $subject_seat_counts = [];
                    $base_seats = intdiv($total_seats, $num_subjects);
                    $extra_seats = $total_seats % $num_subjects;
        
                    foreach ($subject_ids as $index => $subject_id) {
                        $subject_seat_counts[$subject_id] = $base_seats + ($index < $extra_seats ? 1 : 0);
                    }
        
                    $seat_position = 0;
                    $subject_index = 0;
                    $subject_keys = array_keys($subject_seat_counts);
        
                    for ($row = 0; $row < $columns; $row++) {
                        for ($col = 0; $col < $rows; $col++) {
                            $current_subject_id = $subject_keys[$subject_index % $num_subjects];
        
                            if (!empty($subject_students[$current_subject_id]) && $subject_seat_counts[$current_subject_id] > 0) {
                                $assigned_seats[] = array_shift($subject_students[$current_subject_id]);
                                $subject_seat_counts[$current_subject_id]--;
                            } else {
                                $assigned_seats[] = null; // Empty seat if no student available
                            }
        
                            $subject_index++;
                        }
                    }
        
                    // Handle extra seats
                    for ($i = 0; $i < $extra; $i++) {
                        $current_subject_id = $subject_keys[$subject_index % $num_subjects];
                        if (!empty($subject_students[$current_subject_id]) && $subject_seat_counts[$current_subject_id] > 0) {
                            $assigned_seats[] = array_shift($subject_students[$current_subject_id]);
                            $subject_seat_counts[$current_subject_id]--;
                        } else {
                            $assigned_seats[] = null; // Empty seat if no student available
                        }
        
                        $subject_index++;
                    }
                }
        
                // Assign allocated seats to the hall
                $arrangement[$floor][$hall['hall_no']] = [
                    'floor' => $floor,
                    'rows' => $rows,
                    'columns' => $columns,
                    'extra' => $extra,
                    'seats' => $assigned_seats
                ];
        
                // Update remaining_students by removing allocated students
                $remaining_students = [];
                foreach ($subject_students as $sub_id => $student_list) {
                    if (!empty($student_list)) {
                        $remaining_students = array_merge($remaining_students, $student_list);
                    }
                }
            }
            }
            return $arrangement;
        }
        
        public function get_students_by_subject($subject_id)
        {
            $DB1 = $this->load->database('umsdb', TRUE);
            
            $DB1->select('es.enrollment_no, es.subject_id , s.subject_name');
            $DB1->from('exam_applied_subjects es');
            $DB1->join('exam_time_table et', 'et.subject_id = es.subject_id and et.exam_id = es.exam_id', 'left');
            $DB1->join('subject_master s', 's.sub_id = es.subject_id', 'left'); 
            $DB1->where('es.subject_id', $subject_id);
            $DB1->order_by('es.enrollment_no', 'ASC');
            return $DB1->get()->result_array();
        }
        public function get_students1($exam_id = null, $subject_codes = [], $date = null, $session = null) {
            $DB1 = $this->load->database('umsdb', TRUE);
            
            $DB1->select('es.enrollment_no, es.subject_id , s.subject_name');
            $DB1->from('exam_applied_subjects es');
            $DB1->join('exam_time_table et', 'et.subject_id = es.subject_id and et.exam_id = es.exam_id', 'left');
            $DB1->join('examtime_slot ets', 'ets.id = et.exam_slot_id', 'left');
            $DB1->join('subject_master s', 's.sub_id = es.subject_id', 'left'); 

            if (!empty($exam_id)) {
                $DB1->where('es.exam_id', $exam_id);
            }
        
            if (!empty($subject_codes)) {
                $DB1->where_in('es.subject_id', $subject_codes);
            }

            if (!empty($date)) {
                $DB1->where('et.date', $date);
            }

            if (!empty($session)) {
                $DB1->where('ets.session', $session);
            }
        
        return $DB1->get()->result_array();

        // echo $DB1->last_query();exit;

        }
        
        public function get_students($exam_id = null, $subject_codes =[], $date = null, $session = null) {
            $DB1 = $this->load->database('umsdb', TRUE);
           // echo'ghgh';exit;
		  // print_r($subject_codes);exit;
		   // Step 1: Fetch all students from exam_applied_subjects
            $DB1->select('es.enrollment_no, es.subject_id, s.subject_name');
            $DB1->from('exam_applied_subjects es');
            $DB1->join('exam_time_table et', 'et.subject_id = es.subject_id AND et.exam_id = es.exam_id', 'left');
            $DB1->join('examtime_slot ets', 'ets.id = et.exam_slot_id', 'left');
            $DB1->join('subject_master s', 's.sub_id = es.subject_id', 'left');
        
            if (!empty($exam_id)) {
                $DB1->where('es.exam_id', $exam_id);
            }
        
            if (!empty($subject_codes)) {
                $DB1->where_in('es.subject_id', $subject_codes);
            }
        
            if (!empty($date)) {
                $DB1->where('et.date', $date);
            }
        
            if (!empty($session)) {
                $DB1->where('ets.session', $session);
            }

            $DB1->order_by('es.enrollment_no', 'ASC');
      
            $students = $DB1->get()->result_array();
          // echo $DB1->last_query();exit;
            // Step 2: Fetch existing assigned students from exam_hall_seating_arrangement
            $DB1->select('seating_arrangement');
            $DB1->from('exam_hall_seating_arrangement');
            $DB1->where('exam_id', $exam_id);
            $DB1->where('exam_date', $date);
            $DB1->where('session', $session);
			$DB1->where('is_active', 'Y');
        
            $existingEntries = $DB1->get()->result_array();
        
            // Step 3: Extract already assigned enrollment_no from JSON data
            $assignedStudents = [];
            foreach ($existingEntries as $entry) {
                $seatingArrangements = json_decode($entry['seating_arrangement'], true);
                foreach ($seatingArrangements as $seat) {
                    $assignedStudents[] = $seat['enrollment_no'];  // Store assigned students
                }
            }
        
            // Step 4: Filter students who are NOT already assigned
            $filteredStudents = array_filter($students, function ($student) use ($assignedStudents) {
                return !in_array($student['enrollment_no'], $assignedStudents);  // Exclude already assigned students
            });
        
            return array_values($filteredStudents); // Return re-indexed array
        }
        
        public function get_all_exams() {
            $DB1 = $this->load->database('umsdb', TRUE);
            $DB1->select('exam_id, exam_name');
            $DB1->from('exam_session');
            $DB1->where('active_for_exam', 'Y');
            return $DB1->get()->result_array();
        }
        
       
         public function get_all_subjects($exam_id = "", $date = "", $session = "") {
        $DB1 = $this->load->database('umsdb', TRUE);
        
        $centers = $this->session->userdata('center_ids');

        $user_role = $this->session->userdata('role_id');

        if (!empty($centers)) {
            $DB1->select('school_id');
            $DB1->from('exam_center_allocation');
            $DB1->where_in('center_id', $centers);
            if(!empty($exam_id)){
            $DB1->where('exam_id', $exam_id);
            }   
            $school_ids = $DB1->get()->result_array();
            $school_ids = array_column($school_ids, 'school_id');
        }
        
        // Fetch subjects with total student count
        $DB1->select('COUNT(es.enrollment_no) as stud_count, s.subject_code, s.subject_name, s.sub_id, es.semester, str.stream_short_name, et.batch');
        $DB1->from('exam_applied_subjects es');
        $DB1->join('subject_master s', 's.sub_id = es.subject_id', 'left');
        $DB1->join('exam_session e', 'e.exam_id = es.exam_id', 'left');
        $DB1->join('exam_time_table et', 'et.subject_id = es.subject_id AND et.exam_id = es.exam_id', 'left');
        $DB1->join('examtime_slot ets', 'ets.id = et.exam_slot_id', 'left');
        $DB1->join('stream_master str', 'str.stream_id = es.stream_id', 'left');
        $DB1->join('vw_stream_details vsd', 'vsd.stream_id = es.stream_id', 'left');
        if(!empty($school_ids)){
            $DB1->where_in('vsd.school_id', $school_ids);
        }
        $DB1->where('e.active_for_exam', 'Y');
        $DB1->where('es.exam_id', $exam_id);
        $DB1->where('et.date', $date);
        $DB1->where('ets.session', $session);
        $DB1->group_by('es.subject_id');
		$DB1->group_by('es.stream_id');
        $DB1->order_by('s.subject_name', 'ASC');
        
        $subjects = $DB1->get()->result_array();
	//	echo $DB1->last_query();exit;
        
        // Fetch assigned subject counts from `exam_hall_seating_arrangement`
        $DB1->select('seating_arrangement');
        $DB1->from('exam_hall_seating_arrangement');
        $DB1->where('exam_id', $exam_id);
        $DB1->where('exam_date', $date);
        $DB1->where('session', $session);
        $DB1->where('is_active', 'Y');
        
        $existingEntries = $DB1->get()->result_array();
    
        // Extract assigned student count per subject from JSON
        $storedSubjectCounts = [];
        foreach ($existingEntries as $entry) {
            $seatingArrangements = json_decode($entry['seating_arrangement'], true);
            foreach ($seatingArrangements as $seat) {
                $sub_id = $seat['subject_id'];
                if (!isset($storedSubjectCounts[$sub_id])) {
                    $storedSubjectCounts[$sub_id] = 0;
                }
                $storedSubjectCounts[$sub_id]++;
            }
        }
    
        // Include all subjects and calculate remaining students
        foreach ($subjects as &$subject) {
            $subjectId = $subject['sub_id'];
            $totalStudentCount = intval($subject['stud_count']); // Total students for this subject
            $assignedCount = isset($storedSubjectCounts[$subjectId]) ? intval($storedSubjectCounts[$subjectId]) : 0;
            // Calculate remaining students (can be 0 if fully assigned)
            $subject['remaining_students'] = max($totalStudentCount - $assignedCount, 0);

            $subject['label'] = $subject['subject_name'] . ' (' . $subject['subject_code'] . ') - Batch: ' . $subject['batch'] . ', Sem: ' . $subject['semester'] . ', Total: ' . $subject['stud_count'] . ', Remaining: ' . $subject['remaining_students'];
            $subject['highlight'] = $subject['remaining_students'] == 0;
        }
    


        return $subjects; // Return all subjects with remaining students included
    }
        
        
        public function saveSeatingArrangement($data) {
            $DB1 = $this->load->database('umsdb', TRUE);
            return $DB1->insert('exam_hall_seating_arrangement', $data);
            
        }
        // Check if an entry already exists in the database
        public function checkExistingEntry($exam_id, $exam_date, $session, $building, $floor, $hall) {
            $DB1 = $this->load->database('umsdb', TRUE);
            $DB1->where('exam_id', $exam_id);
            $DB1->where('exam_date', $exam_date);
            $DB1->where('session', $session);
            $DB1->where('building', $building);
            $DB1->where('floor', $floor);
            $DB1->where('hall', $hall);
			$DB1->where('is_active', 'Y');
            $query = $DB1->get('exam_hall_seating_arrangement');

            return $query->num_rows() > 0; // Return true if entry exists, false otherwise
        }

}
