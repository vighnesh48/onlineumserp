<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seatingreportmodel extends CI_Model {

    public function getExams() {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('*');
        $DB1->from('exam_session');
        $DB1->where('is_active', 'Y');
        $query = $DB1->get();
        return $query->result_array();
    }


    public function get_halls($floor, $building_id) {

        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('*');
        $DB1->from('hall_master');
        $DB1->where('floor', $floor);
        $DB1->where('building_id', $building_id);
        return $DB1->get()->result_array();
    }

    // Fetch rows and columns for the selected hall
    public function get_hall_details($hall_id, $floor, $building_id) {
        $DB1 = $this->load->database('umsdb', TRUE);

        return $DB1->where('hall_no', $hall_id)
                        ->where('floor', $floor)
                        ->where('building_id', $building_id)
                        ->get('hall_master')
                        ->row_array();
    }

    // Fetch seating arrangement JSON from the exam_hall_seating_arrangement table
    public function get_seating_arrangement($exam_id, $exam_date, $session, $hall_id, $building_id, $floor) {
        $DB1 = $this->load->database('umsdb', TRUE);

                return $DB1->where('exam_id', $exam_id)
                        ->where('exam_date', $exam_date)
                        ->where('session', $session)
                        ->where('hall', $hall_id)
                        ->where('building', $building_id)
                        ->where('floor', $floor)
                        ->where('is_active', 'Y')
                        ->get('exam_hall_seating_arrangement')
                        ->row_array();

    }

    public function get_students($exam_id = null, $date = null, $session = null, $subject_codes = []) {

        $DB1 = $this->load->database('umsdb', TRUE);

       // print_r($subject_codes);exit;
    
        $subject_id_list = [];

        if (is_array($subject_codes)) {
            foreach ($subject_codes as $pair) {
                [$sub_id] = explode('~', $pair);
                $subject_id_list[] = $sub_id;
            }
        }
        else {
            
            $subject_ids = explode('~', $subject_codes);
            $subject_id_list = $subject_ids[0];
        }

        // print_r($subject_id_list);
        // echo  "<br>";
        // print_r($stream_id_list);
        // exit;
        
        // Step 1: Fetch all students from exam_applied_subjects
        $DB1->select('es.enrollment_no, es.subject_id, s.subject_name');
        $DB1->from('exam_applied_subjects es');
        $DB1->join('exam_time_table et', 'et.subject_id = es.subject_id AND et.exam_id = es.exam_id', 'left');
        $DB1->join('examtime_slot ets', 'ets.id = et.exam_slot_id', 'left');
        $DB1->join('subject_master s', 's.sub_id = es.subject_id', 'left');
    
        if (!empty($exam_id)) {
            $DB1->where('es.exam_id', $exam_id);
        }
    
        if (!empty($subject_id_list)) {
            $DB1->where_in('es.subject_id', $subject_id_list);
        }
    
        if (!empty($date)) {
            $DB1->where('et.date', $date);
        }
    
        if (!empty($session)) {
            $DB1->where('ets.session', $session);
        }
    
        $DB1->order_by('es.enrollment_no', 'ASC');
    
        $students = $DB1->get()->result_array();
        //   echo $DB1->last_query();exit;

    
        // Step 2: Fetch existing assigned students from exam_hall_seating_arrangement
        $DB1->select('seating_arrangement');
        $DB1->from('exam_hall_seating_arrangement');
        $DB1->where('exam_id', $exam_id);
        $DB1->where('exam_date', $date);
        $DB1->where('session', $session);
        $DB1->where('is_active', 'Y');
    
        $existingEntries = $DB1->get()->result_array();
    
        // Step 3: Build composite key for already assigned [subject_id|enrollment_no]
        $assignedStudents = [];
        foreach ($existingEntries as $entry) {
            $seatingArrangements = json_decode($entry['seating_arrangement'], true);
            foreach ($seatingArrangements as $seat) {
                if (!empty($seat['enrollment_no']) && !empty($seat['subject_id'])) {
                    $key = $seat['subject_id'] . '|' . $seat['enrollment_no'];
                    $assignedStudents[$key] = true;
                }
            }
        }
    
        // Step 4: Filter students who are NOT already assigned (by subject + enrollment)
        $filteredStudents = array_filter($students, function ($student) use ($assignedStudents) {
            $key = $student['subject_id'] . '|' . $student['enrollment_no'];
            return !isset($assignedStudents[$key]);
        });

      //  print_r($filteredStudents);exit;
    
        return array_values($filteredStudents); // Re-indexed result
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
        $DB1->select('COUNT(es.enrollment_no) as stud_count, s.subject_code, s.subject_name, s.sub_id, es.semester, str.stream_short_name, et.batch, es.stream_id');
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
        public function getConsolidatedSeating($exam_id, $exam_date, $session, $building_id) {
            $DB1 = $this->load->database('umsdb', TRUE);
            
            // Fetch exam and building details
            $DB1->select('exam_name');
            $DB1->from('exam_session');
            $DB1->where('exam_id', $exam_id);
            $examDetails = $DB1->get()->row_array();
        
            // Fetch seating arrangements
            $DB1->select('*');
            $DB1->from('exam_hall_seating_arrangement');
            $DB1->where('exam_id', $exam_id);
            $DB1->where('exam_date', $exam_date);
            $DB1->where('session', $session);
            $DB1->where('building', $building_id);
            $DB1->where('is_active', 'Y');
            $seatingData = $DB1->get()->result_array();
        
			//print_r($seatingData);exit;
            $transformedData = [];
        
            foreach ($seatingData as $hallData) {
                // Decode the JSON in 'seating_arrangement'
				
                $seatingArrangement = json_decode($hallData['seating_arrangement'], true);
 //print_r($hallData);exit;
                $DB1->select('*');
                $DB1->from('hall_master');
                $DB1->where('hall_no', $hallData['hall']);
                $DB1->where('building_id', $hallData['building']);
                $DB1->where('floor', $hallData['floor']);
                $HallMasterData = $DB1->get()->row_array();

               
                
                // Count occurrences and track enrollment numbers
                $subjectCounts = [];
                $enrollmentNumbers = [];
                foreach ($seatingArrangement as $seat) {
                    if (isset($seat['subject_id'])) {
                        $subjectId = $seat['subject_id'];
                        if (!isset($subjectCounts[$subjectId])) {
                            $subjectCounts[$subjectId] = 0;
                            $enrollmentNumbers[$subjectId] = [];
                        }
                        $subjectCounts[$subjectId]++;
                        $enrollmentNumbers[$subjectId][] = $seat['enrollment_no'];
                    }
                }
				//print_r($subjectIds);exit;
        
                // Fetch subject details for all subject_ids at once
                $subjectIds = array_keys($subjectCounts); // Get all unique subject_ids
                $DB1->select('sm.sub_id, sm.subject_code, sm.subject_name, sm.semester, vsd.stream_name,vsd.stream_short_name , vsd.course_short_name');
                $DB1->from('subject_master sm');
                $DB1->join('vw_stream_details vsd', 'sm.stream_id = vsd.stream_id', 'left');
                $DB1->where_in('sm.sub_id', $subjectIds);
                $subjects = $DB1->get()->result_array();
				// print_r($subjects);
				// echo '<pre>';
				// echo $DB1->last_query();
        
                // Map subject details to their respective subject_id
                $subjectDetails = [];
                foreach ($subjects as $subject) {
                    $subjectDetails[$subject['sub_id']] = [
                        'subject_code' => $subject['subject_code'],
                        'subject_name' => $subject['subject_name'],
                        'stream_name' => $subject['stream_name'],
                        'stream_short_name' => $subject['stream_short_name'],
                        'semester' => $subject['semester'],
                        'course_short_name' => $subject['course_short_name']
                    ];
                }
        
                // Create the new 'seating_arrangement' format with student names
                $newSeatingArrangement = [];
                foreach ($subjectCounts as $subjectId => $count) {
                    $minEnrollment = min($enrollmentNumbers[$subjectId]);
                    $maxEnrollment = max($enrollmentNumbers[$subjectId]);
        
                    // Fetch student names for the enrollment numbers
                    $DB1->select('enrollment_no, CONCAT(first_name, " ", middle_name, " ", last_name," ") AS student_name');
                    $DB1->from('student_master');
                    $DB1->where_in('enrollment_no', $enrollmentNumbers[$subjectId]);
                    $studentData = $DB1->get()->result_array();
        
                    $studentNames = [];
                    foreach ($studentData as $student) {
                        $studentNames[$student['enrollment_no']] = $student['student_name'];
                    }
        
                    $newSeatingArrangement[] = [
                        'subject_id' => $subjectId,
                        'subject_code' => $subjectDetails[$subjectId]['subject_code'] ?? 'N/A',
                        'subject_name' => $subjectDetails[$subjectId]['subject_name'] ?? 'N/A',
                        'stream_name' => $subjectDetails[$subjectId]['stream_name'] ?? 'N/A',
                        'stream_short_name' => $subjectDetails[$subjectId]['stream_short_name'] ?? 'N/A',
                        'semester' => $subjectDetails[$subjectId]['semester'] ?? 'N/A',
                        'course_short_name' => $subjectDetails[$subjectId]['course_short_name'] ?? 'N/A',
                        'count_subject_id' => $count,
                        'min_enrollment' => $minEnrollment,
                        'max_enrollment' => $maxEnrollment,
                        'students' => $studentNames // Map enrollment numbers to names
                    ];
                }
               // print_r($newSeatingArrangement);exit;
				$filteredSeatingArrangement = array_filter($newSeatingArrangement, function($item) {
					return !empty($item['subject_id']);
				});

				$total = array_sum(array_column($filteredSeatingArrangement, 'count_subject_id'));
        
                // Transform the hall data
                $transformedData[] = [
                    'id' => $hallData['id'],
                    'exam_id' => $hallData['exam_id'],
                    'exam_date' => $hallData['exam_date'],
                    'session' => $hallData['session'],
                    'building' => $hallData['building'],
                    'floor' => $hallData['floor'],
                    'hall' => $hallData['hall'],
                    'rows' => $HallMasterData['matrix_rows'],
                    'columns' => $HallMasterData['matrix_columns'],
                    'total_students' => $total,
                    'total_subjects' => count($newSeatingArrangement),
                    'seating_arrangement' => $newSeatingArrangement,
                    'json_arrangement' => $seatingArrangement

                ];
            } // exit;
        
            return [
                'exam_name' => $examDetails['exam_name'],
                'exam_id' => $exam_id,
                'exam_date' => $exam_date,
                'session' => $session,
                'arrangements' => $transformedData
            ];
        }


        public function get_center_by_building($building_id, $exam_id){
            $DB1 = $this->load->database('umsdb', TRUE);

            $sql = "SELECT cm.center_name FROM exam_center_building_allocation cba LEFT JOIN exam_center_master cm ON cm.ec_id = cba.center_id WHERE cba.building_id = $building_id and cba.exam_id = $exam_id ";
            $query = $DB1->query($sql);
           //    echo $DB1->last_query();exit;
            return $query->row_array();
        } 
              
		public function get_building_name($building_id){
            $DB1 = $this->load->database('umsdb', TRUE);

            $sql = "SELECT building_name FROM `building_master` WHERE id = $building_id";
            $query = $DB1->query($sql);
           //    echo $DB1->last_query();exit;
            return $query->row_array();
        } 
}
