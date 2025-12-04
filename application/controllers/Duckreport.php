<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Duckreport extends CI_Controller {
    
    public function generate_pdf() {
        $this->load->model('Duckreportmodel');
        $this->load->library('m_pdf');
    
        $date = '2025-02-04';
        $academic_year = '2024-25';
        $academic_session = 'SUM';
        $month = '2025-02'; // Example: November 2024
    
        // Fetch lecture timetable data
        $lecture_data = $this->Duckreportmodel->getLectureTimeTable($academic_year, $date, $academic_session);
    
        // Prepare data for the report
        $report_data = [];
        foreach ($lecture_data as $lecture) {
            $faculty_code = $lecture['faculty_code'];
            $subject_id = $lecture['subject_code'];
            $lecture_slot = $lecture['lecture_slot'];
    
          //  $lv =$this->Erp_cron_attendance_model->check_leave($lecture['faculty_code'],$date);
          //  $hd = $this->Erp_cron_attendance_model->check_holidays($date,$sublist[$i]['staff_type']);
            // Fetch scheduled and conducted lectures
            $lectures = $this->Duckreportmodel->getTotalLectures($faculty_code, $academic_year, $academic_session, $month, $date);

          //  echo '<pre>';
          //  print_r($lecture);
    
            $scheduled_lectures = isset($lectures['scheduled_lectures'][$subject_id]) ? $lectures['scheduled_lectures'][$subject_id] : 0;
            $conducted_lectures = isset($lectures['conducted_lectures'][$subject_id]) ? $lectures['conducted_lectures'][$subject_id] : 0;
    
            // Calculate total ducks
            $total_ducks = max(0, $scheduled_lectures - $conducted_lectures);
    
          //  print_r($total_ducks);exit;
            // Check attendance for the current day
            $attendance = $this->Duckreportmodel->checkAttendance($academic_year, $date, $faculty_code, $subject_id, $lecture_slot, $academic_session);
    
          //  print_r($attendance);exit;
            if (!$attendance) {
                // Faculty missed attendance, add to report
                $report_data[] = [
                    'date' => $date,
                    'academic_year' => $academic_year, // Academic Year
                    'academic_session' => $academic_session, // Academic Session
                    'faculty' => $lecture['fname'] . ' ' . $lecture['mname'] . ' ' . $lecture['lname'].'('. $lecture['designation_name'] .')', // Full Faculty Name
                    'faculty_code' => $faculty_code, // Faculty Code
                    'designation' => $lecture['designation_name'], // Faculty Designation
                    'school_stream' => $lecture['school_short_name'] . ' - ' . $lecture['stream_short_name'], // School - Stream
                    'semester' => $lecture['semester'], // Semester
                    'division' => $lecture['division'], // Division
                    'subject' => $lecture['subject_code'], // Subject Code
                    'subtype' => $lecture['subject_type'], // Subject Type
                    'slot' => $lecture['from_time'] . ' - ' . $lecture['to_time'] . ' (' . $lecture['slot_am_pm'] . ')', // Lecture Slot (Time)
                    'today' => '1', // Today's Duck (Missed Attendance)
                    'total_ducks' => $total_ducks // Total Ducks for the Month
                ];
            }
        } // exit;
    
        // Load view and generate PDF
        $html = $this->load->view('duck_report_view', ['report_data' => $report_data], true);
        $mpdf = new mPDF('L', 'A4', '', '', 5, 5, 5, 5, 5, 5);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Duck_Report.pdf', 'I'); // Download PDF
    }
    

    public function totalLectures() {
        $this->load->model('Duckreportmodel');
    
        $faculty_code = '110513'; // Example faculty code
        $academic_year = '2024-25';
        $academic_session = 'SUM';
        $month = '2025-02'; // Example: November 2024
    
        $data = $this->Duckreportmodel->getTotalLectures($faculty_code, $academic_year, $academic_session, $month, '2025-02-04');
    
        $this->load->view('lec_count', $data);
    }
    
    
}
