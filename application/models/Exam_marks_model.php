<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_marks_model extends CI_Model {

    public function get_exam_data($barcode , $exam_id) {

        // Query to fetch data based on barcode

        $DB1 = $this->load->database('umsdb', TRUE);  

        $sql= "SELECT
                    eas.*,sm.enrollment_no,sub.subject_code,sub.subject_name,es.exam_name,es.exam_month,es.exam_year,str.stream_name,sub.theory_max,ses.th_date_start,ses.th_date_end
                FROM
                    exam_applied_subjects as eas
                LEFT JOIN 
                    student_master as sm ON sm.stud_id = eas.stud_id 
                LEFT JOIN 
                    exam_session as es ON es.exam_id = eas.exam_id
                LEFT JOIN
                    subject_master as sub ON sub.sub_id = eas.subject_id
                LEFT JOIN
                    stream_master as str ON str.stream_id = eas.stream_id
                LEFT JOIN 
                    marks_entery_date as ses ON ses.exam_id = eas.exam_id
                WHERE
                    barcode = '$barcode' AND eas.exam_id = '$exam_id'";
                

        $query = $DB1->query($sql);

      // echo $DB1->last_query();exit;

        return $query->row_array();

    }

    public function insert_marks($marks, $exam_data) {

        $DB1 = $this->load->database('umsdb', TRUE);  

        // Check if an entry exists in marks_entry_master with the given parameters

        $check_data = array(
            'subject_id' => $exam_data['subject_id'],
            'exam_id' => $exam_data['exam_id'],
            'semester' => $exam_data['semester'],
            'stream_id' => $exam_data['stream_id'],
            'marks_type' => 'TH'
        );
    
        $DB1->where($check_data);
        $existing_entry = $DB1->get('marks_entry_master')->row_array();
    
     //   print_r($existing_entry);exit;
        if (!$existing_entry) {
            // If no entry exists, insert into marks_entry_master
            $master_data = array(

                'exam_id' => $exam_data['exam_id'],
                'stream_id' => $exam_data['stream_id'],
                'semester' => $exam_data['semester'],
                'subject_id' => $exam_data['subject_id'],
                'subject_code' => $exam_data['subject_code'],
                'exam_month' => $exam_data['exam_month'],
                'exam_year' => $exam_data['exam_year'],
                'marks_type' => 'TH',
                'max_marks' => $exam_data['theory_max'],
                'marks_entry_date' => date('Y-m-d')

            );

     //    print_r($master_data);exit;

            $DB1->insert('marks_entry_master', $master_data);

        //    echo $DB1->last_query();exit;

            $last_inserted_id_master = $DB1->insert_id();

        } else {

            // If an entry already exists, use its ID

            $last_inserted_id_master = $existing_entry['me_id'];

        }

        if ($existing_entry) {
            $data = array(
                'marks' => $marks,
                'me_id' => $last_inserted_id_master,
                'stud_id' => $exam_data['stud_id'],
                'enrollment_no' => $exam_data['enrollment_no'],
                'exam_id' => $exam_data['exam_id'],
                'stream_id' => $exam_data['stream_id'],
                'barcode' => $exam_data['barcode'],
                'semester' => $exam_data['semester'],
                'subject_id' => $exam_data['subject_id'],
                'subject_code' => $exam_data['subject_code'],
                'marks_type' => 'TH',
                'exam_month' => $exam_data['exam_month'],
                'exam_year' => $exam_data['exam_year']
            );

          //  print_r($data);exit;
            $DB1->insert('marks_entry', $data);

        }
        else {  
        // Insert marks into the database along with other data
        $data = array(
            'marks' => $marks,
            'me_id' => $last_inserted_id_master,
            'stud_id' => $exam_data['stud_id'],
            'enrollment_no' => $exam_data['enrollment_no'],
            'exam_id' => $exam_data['exam_id'],
            'stream_id' => $exam_data['stream_id'],
            'barcode' => $exam_data['barcode'],
            'semester' => $exam_data['semester'],
            'subject_id' => $exam_data['subject_id'],
            'subject_code' => $exam_data['subject_code'],
            'marks_type' => 'TH',
            'exam_month' => $exam_data['exam_month'],
            'exam_year' => $exam_data['exam_year']
        );

     // print_r($data);exit;

        $DB1->insert('marks_entry', $data);

     //   echo $DB1->last_query();exit;
    }
    }
    public function get_exam_list() {
        $DB1 = $this->load->database('umsdb', TRUE);
    
        // Assuming 'exam_session' is the table name for exams
        $DB1->select('es.*, med.*');
        $DB1->from('exam_session as es');
        $DB1->join('marks_entery_date AS med', 'med.exam_id = es.exam_id', 'left');
        $DB1->where('es.active_for_marks_entry', 'Y');
        $query = $DB1->get();
        // Return the result as an array
     //   echo $DB1->last_query();exit;
        return $query->result_array();


    }

    public function is_marks_entry_exists($exam_id, $subject_id, $barcode) {
        // Connect to the database
        $DB1 = $this->load->database('umsdb', TRUE);
    
        // Query to check if marks entry exists for the provided parameters
        $DB1->where('exam_id', $exam_id);
        $DB1->where('subject_id', $subject_id);
        $DB1->where('barcode', $barcode);
        $query = $DB1->get('marks_entry');
    
        // Return TRUE if marks entry exists, FALSE otherwise
        return $query->num_rows() > 0;
    }
    
}
?>
