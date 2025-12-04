<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conversion_cert_model extends CI_Model
{
    protected $umsdb;

    public function __construct()
    {
        parent::__construct();
        // Load 'umsdb' connection explicitly
        $this->umsdb = $this->load->database('umsdb', TRUE);
    }

    public function get_latest_exam_results_by_enrollments($enrollments = [])
    {
        if (empty($enrollments)) {
            return [];
        }

        $placeholders1 = implode(',', array_fill(0, count($enrollments), '?'));
        $placeholders2 = implode(',', array_fill(0, count($enrollments), '?'));

        $sql = "
            SELECT
                er.enrollment_no,
                sm.first_name,
                sm.academic_year,
                stm.stream_short_name,
                stm.degree_specialization,
                er.semester,
                er.sgpa,
				esn.exam_name
            FROM exam_result_master er
            JOIN (
                SELECT 
                    enrollment_no,
                    semester,
                    MAX(CONCAT(LPAD(exam_year,4,'0'), 
                    LPAD(
                        CASE UPPER(exam_month)
                        WHEN 'JAN' THEN '01' WHEN 'FEB' THEN '02' WHEN 'MARCH' THEN '03'
                        WHEN 'APRIL' THEN '04' WHEN 'MAY' THEN '05' WHEN 'JUNE' THEN '06'
                        WHEN 'JULY' THEN '07' WHEN 'AUGUST' THEN '08' WHEN 'SEPT' THEN '09'
                        WHEN 'OCT' THEN '10' WHEN 'NOV' THEN '11' WHEN 'DEC' THEN '12' ELSE '00'
                        END, 2, '0'
                    )
                    )) AS latest_key
                FROM exam_result_master
                WHERE enrollment_no IN ($placeholders1)
                GROUP BY enrollment_no, semester
            ) latest ON 
                er.enrollment_no = latest.enrollment_no
                AND er.semester = latest.semester
                AND CONCAT(LPAD(er.exam_year,4,'0'),
                        LPAD(
                            CASE UPPER(er.exam_month)
                            WHEN 'JAN' THEN '01' WHEN 'FEB' THEN '02' WHEN 'MARCH' THEN '03'
                            WHEN 'APRIL' THEN '04' WHEN 'MAY' THEN '05' WHEN 'JUNE' THEN '06'
                            WHEN 'JULY' THEN '07' WHEN 'AUGUST' THEN '08' WHEN 'SEPT' THEN '09'
                            WHEN 'OCT' THEN '10' WHEN 'NOV' THEN '11' WHEN 'DEC' THEN '12' ELSE '00'
                            END, 2, '0'
                        )
                ) = latest.latest_key
            JOIN student_master sm ON er.enrollment_no = sm.enrollment_no
            LEFT JOIN stream_master stm ON sm.admission_stream = stm.stream_id
            LEFT JOIN exam_session esn ON esn.exam_id = er.exam_id
            WHERE er.enrollment_no IN ($placeholders2)
            ORDER BY er.enrollment_no, er.semester
        ";

        $params = array_merge($enrollments, $enrollments);
        $query = $this->umsdb->query($sql, $params);

        if (!$query) {
            $error = $this->umsdb->error();
            echo 'DB Error: ' . $error['message'];
            return [];
        }

        return $query->result_array();
    }

    public function get_transcript_data_by_enrollments($enrollments = [])
    {
        if (empty($enrollments)) {
            return [];
        }

        // Prepare placeholders for IN clause
        $placeholders = implode(',', array_fill(0, count($enrollments), '?'));

		$sql = "
			SELECT 
				sm.enrollment_no,
				sm.first_name,
				stm.stream_name,
				et.obtain_marks,
				at.semester,
				at.total_marks_out_of,
				es.exam_name
			FROM student_master sm
			JOIN (
				SELECT 
					sas.stud_id,
					sas.semester,
					SUM(subm.sub_max) AS total_marks_out_of
				FROM student_applied_subject sas
				JOIN subject_master subm 
					ON subm.sub_id = sas.subject_id
				GROUP BY sas.stud_id, sas.semester
			) at ON sm.stud_id = at.stud_id
			LEFT JOIN (
				SELECT 
					er1.enrollment_no,
					er1.semester,
					SUM(er1.final_garde_marks) AS obtain_marks
				FROM exam_result_data er1
				WHERE er1.final_grade NOT IN ('U','F')
				GROUP BY er1.enrollment_no, er1.semester
			) et ON sm.enrollment_no = et.enrollment_no
				 AND et.semester = at.semester
			LEFT JOIN stream_master stm 
				ON sm.admission_stream = stm.stream_id
			LEFT JOIN (
				SELECT er2.enrollment_no, MAX(er2.exam_id) AS latest_exam_id
				FROM exam_result_data er2
				GROUP BY er2.enrollment_no
			) le ON sm.enrollment_no = le.enrollment_no
			LEFT JOIN exam_session es 
				ON es.exam_id = le.latest_exam_id
			WHERE sm.enrollment_no IN ($placeholders)
			ORDER BY sm.enrollment_no, at.semester
		";

		$query = $this->umsdb->query($sql, $enrollments);

		// echo'<pre>';
		// echo $this->umsdb->last_query();exit;
        return $query->result_array();
    }

    public function fetch_degree_cert_by_student($exam_id, $enrollment_no, $stream_id = null) {
    $DB1 = $this->load->database('umsdb', TRUE);

		$sql = "
		SELECT DISTINCT
			s.enrollment_no,
			s.stud_id,
			TRIM(CONCAT_WS(' ', s.first_name, s.middle_name, s.last_name)) AS stud_name,
			TRIM(CONCAT_WS(' ', s.father_fname, s.father_mname, s.father_lname)) AS father_name,
			CONCAT(
				vw.gradesheet_name,
				CASE
					WHEN COALESCE(NULLIF(vw.specialization, '--'), '') <> ''
						THEN CONCAT(' (', COALESCE(NULLIF(vw.specialization, '--'), NULLIF(vw.stream_name, ''), ''), ')')
					ELSE ''
				END
			) AS degree_with_specialization,
			CONCAT(erd.exam_month, ' ', erd.exam_year) AS month_year_of_passing,
			erm.cumulative_gpa
		FROM exam_result_data AS erd
		JOIN student_master AS s 
			ON s.enrollment_no = erd.enrollment_no
		LEFT JOIN exam_result_master AS erm
			ON erm.enrollment_no = erd.enrollment_no
			AND erm.exam_id = erd.exam_id
			AND erm.semester = erd.semester
		LEFT JOIN vw_stream_details AS vw 
			ON vw.stream_id = erd.stream_id
		WHERE erd.exam_id = ?
		  AND erd.enrollment_no = ?
		  AND COALESCE(erd.is_deleted, 'N') = 'N'
		";

        
    $params = [$exam_id, $enrollment_no];

    if ($stream_id !== null && $stream_id !== '') {
        $sql .= " AND erd.stream_id = ? ";
        $params[] = $stream_id;
    }

    $sql .= " ORDER BY s.enrollment_no LIMIT 1";

    $q = $DB1->query($sql, $params);
	//	echo $DB1->last_query();exit;
    // for debugging: uncomment to log the final SQL with bindings
     // log_message('debug', 'fetch_degree_cert_by_student SQL: ' . $DB1->last_query());

   $row = $q ? ($q->row_array() ?: []) : [];
	if (!empty($row)) {
    $row['stud_name']   = ucwords(strtolower(trim($row['stud_name'] ?? '')));
    $row['father_name'] = ucwords(strtolower(trim($row['father_name'] ?? '')));
	}
	return $row;
	
}

}

