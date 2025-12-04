<?php
class Bank_letter_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		
    }
    
    public function get_types()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('*');
		$DB1->from('student_facilities');
		$DB1->where('is_active', 'Y');
		$query = $DB1->get();
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
	
		public function get_next_id_formatted($state_code = '',$request_type='')
{
    $DB1 = $this->load->database('umsdb', TRUE);

    // Apply state_code filter if provided
    if (!empty($state_code)) {
        $DB1->where('state_code', $state_code);
    }
	if (!empty($state_code)) {
        $DB1->where('request_type', $request_type);
    }

    // Get the max incremented_no for the given state
    $DB1->select_max('incremented_no', 'max_no');
    $query = $DB1->get('student_request_details');
    $row = $query->row();

    $next = (int) $row->max_no + 1;

    // Format the number with leading zeros
    $formatted_no = ($next < 1000) 
        ? str_pad($next, 4, '0', STR_PAD_LEFT) 
        : (string) $next;

    // Return with state prefix
    return   $formatted_no;
}
	
		public function generate_request($data = array())
		{
		$DB1 = $this->load->database('umsdb', TRUE);

		if (empty($data) || !isset($data['request_no'])) {
		return FALSE;
		}

		// 1. Check if request_no already exists
		$DB1->where('request_no', $data['request_no']);
		$exists = $DB1->get('student_request_details')->num_rows() > 0;
		
		
		$DB1->where('academic_year', $data['academic_year']);
		$DB1->where('request_type', $data['request_type']);
		$DB1->where('student_id', $data['student_id']);
		$exists1 = $DB1->get('student_request_details')->num_rows() > 0;
		
		

		if ($exists  || $exists1) {
			
		// Skip insert, return a special status or false
		return FALSE;  // or return 'exists' if you'd like
		}

		// 2. Insert new record
		$DB1->insert('student_request_details', $data);
		return $DB1->insert_id(); // returns new ID if inserted, or 0 if failed
		}

	public function getStudentRefundRequestListsss($student_id, $count_only = false, $limit = 0, $start = 0)

{
    $DB1 = $this->load->database('umsdb', TRUE);

    $DB1->select('srd.*, sm.first_name, sm.enrollment_no,sm.admission_session,sm.email, sf.name as rt, st.state_code, sf.short_code as foldershortcode,vw.stream_name,vw.school_short_name as school_name,vw.course_short_name as coursename,sffm.sf_id');
    $DB1->from('student_request_details AS srd');
    $DB1->join('student_master AS sm', 'srd.student_id = sm.stud_id');
    $DB1->join('address_details AS ad', 'sm.stud_id = ad.student_id AND address_type = "PERMNT"', 'left');
	$DB1->join('vw_stream_details AS vw', 'sm.admission_stream = vw.stream_id');
    $DB1->join('states AS st', 'ad.state_id = st.state_id', 'left');
    $DB1->join('student_facilities AS sf', 'srd.request_type = sf.id', 'left');
    $DB1->join('sandipun_erp.sf_student_facilities AS sffm', 'sm.enrollment_no = sffm.enrollment_no  and sffm.academic_year in (2024,2025) and sffm.sffm_id=1 and sffm.status="Y"', 'left');

    if (!empty($student_id)) {
        $DB1->where('srd.student_id', $student_id);
    }

    if ($count_only) {
        return $DB1->count_all_results();
    } else {
        $DB1->order_by('`srd`.`id`', 'ASC');

        if ($limit > 0) {
            $DB1->limit($limit, $start);
        }

        $query = $DB1->get();
		
        return $query->result_array();
    }
}

		public function getStudentRefundRequestListddd($student_id, $count_only = false, $limit = 0, $start = 0)
{
    $DB1 = $this->load->database('umsdb', TRUE);

    // Fetch the student's admission_session and academic_year
    $DB1->select('admission_session, academic_year');
    $DB1->from('student_master');
    $DB1->where('stud_id', $student_id);
    $student_info = $DB1->get()->row_array();

    // Determine academic_year for the join
    $join_year = 2024; // Default
    if (!empty($student_info)) {
        if ($student_info['admission_session'] == 2025 || $student_info['academic_year'] == 2025) {
            $join_year = 2025;
        }
    }

    // Adjust applicable_fee based on join year
     $feeColumn = ($join_year == 2024)
    ? '(ad.applicable_fee - 2000) AS applicable_fee'
    : 'ad.applicable_fee AS applicable_fee';


    // Main query construction
    $DB1->select("srd.*, sm.first_name, sm.enrollment_no, sm.admission_session, sm.email,
                  sf.name AS rt, st.state_code, sf.short_code AS foldershortcode, vw.stream_name,
                  vw.school_short_name AS school_name, vw.course_short_name AS coursename,sm.current_year,
                  sffm.sf_id,$feeColumn,rd.total_fees_applicable");

    $DB1->from('student_request_details AS srd');
    $DB1->join('student_master AS sm', 'srd.student_id = sm.stud_id');
    $DB1->join('admission_details AS ad', "sm.stud_id = ad.student_id AND ad.academic_year = {$join_year}", 'left');
    $DB1->join('address_details AS addr', 'sm.stud_id = addr.student_id AND address_type = "PERMNT"', 'left');
    $DB1->join('vw_stream_details AS vw', 'sm.admission_stream = vw.stream_id');
    $DB1->join('states AS st', 'addr.state_id = st.state_id', 'left');
    $DB1->join('student_facilities AS sf', 'srd.request_type = sf.id', 'left');
	$DB1->join('package_students_fees_details AS rd', 'sm.enrollment_no = rd.enrollment_no', 'left');
	
    $DB1->join('sandipun_erp.sf_student_facilities AS sffm', 'sm.enrollment_no = sffm.enrollment_no AND sffm.academic_year IN (2024, 2025) AND sffm.sffm_id = 1 AND sffm.status = "Y"', 'left');

    if (!empty($student_id)) {
        $DB1->where('srd.student_id', $student_id);
    }

    if ($count_only) {
        return $DB1->count_all_results();
    } else {
        $DB1->order_by('srd.id', 'ASC');
        if ($limit > 0) {
            $DB1->limit($limit, $start);
        }
        return $DB1->get()->result_array();
    }
}

 public function getStudentRefundRequestList($student_id = null, $count_only = false, $limit = 0, $start = 0)
{
    $DB1 = $this->load->database('umsdb', TRUE);

    // Subquery to fetch one relevant admission_details record per student
    $subquery = "(SELECT ad1.student_id, ad1.academic_year, ad1.applicable_fee
                  FROM admission_details ad1
                  INNER JOIN (
                      SELECT student_id, MAX(
                          CASE 
                              WHEN academic_year = 2025 THEN 3
                              WHEN academic_year = 2024 THEN 2
                              ELSE 1
                          END
                      ) AS priority
                      FROM admission_details
                      WHERE academic_year IN (2024, 2025)
                      GROUP BY student_id
                  ) pr ON ad1.student_id = pr.student_id
                  AND (
                      (ad1.academic_year = 2025 AND pr.priority = 3) OR 
                      (ad1.academic_year = 2024 AND pr.priority = 2)
                  )
              ) AS ad";

    // Dynamic fee logic using CASE
    $feeColumn = "CASE
        WHEN sm.academic_year = 2025 THEN ad.applicable_fee
        WHEN sm.academic_year = 2024 AND sm.admission_session = sm.current_year THEN (ad.applicable_fee - 2000)
        WHEN sm.academic_year = 2024 AND sm.admission_session != sm.current_year THEN ad.applicable_fee
        ELSE ad.applicable_fee
    END AS applicable_fee";

    // Main query construction
    $DB1->select("srd.*, sm.first_name, sm.enrollment_no, sm.admission_session, sm.email,
                  sf.name AS rt, st.state_code, sf.short_code AS foldershortcode, vw.stream_name,
                  vw.school_short_name AS school_name, vw.course_short_name AS coursename, sm.current_year,
                   {$feeColumn}, rd.total_fees_applicable,sm.admission_stream,sm.stud_id");

    $DB1->from('student_request_details AS srd');
    $DB1->join('student_master AS sm', 'srd.student_id = sm.stud_id');
    $DB1->join($subquery, 'sm.stud_id = ad.student_id', 'left');
    $DB1->join('address_details AS addr', 'sm.stud_id = addr.student_id AND addr.address_type = "PERMNT"', 'left');
    $DB1->join('vw_stream_details AS vw', 'sm.admission_stream = vw.stream_id');
    $DB1->join('states AS st', 'addr.state_id = st.state_id', 'left');
    $DB1->join('student_facilities AS sf', 'srd.request_type = sf.id', 'left');
    $DB1->join('package_students_fees_details AS rd', 'sm.enrollment_no = rd.enrollment_no', 'left');
   /*  $DB1->join('sandipun_erp.sf_student_facilities AS sffm', 'sm.enrollment_no = sffm.enrollment_no AND sffm.academic_year IN (2024, 2025) AND sffm.sffm_id = 1 AND sffm.status = "Y"', 'left'); */

    // Apply filter if student_id is provided
    if (!empty($student_id)) {
        $DB1->where('srd.student_id', $student_id);
    }

    // Return results
    if ($count_only) {
        return $DB1->count_all_results();
    } else {
        $DB1->order_by('srd.id', 'ASC');
        if ($limit > 0) {
            $DB1->limit($limit, $start);
        }
        return $DB1->get()->result_array();
    }
}



		function update_data($requestId='',$fileName=''){
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->where('id', $requestId);
			$DB1->update('student_request_details', [
			'is_processed' => 'Y',
			'processed_doc' => $fileName
			]);
			}
			
			public function verify_request($request_id) {
			$DB1 = $this->load->database('umsdb', TRUE);
			$DB1->where('id', $request_id);
            return $DB1->update('student_request_details', ['is_verified' => 'Y']);
			}
			
			public function get_package_data($stud_id, $stream, $session, $request_id) {
    $DB1 = $this->load->database('umsdb', TRUE);

    $DB1->select("
        ad.package_id,
        sm.admission_stream,
        ad.academic_year AS admission_session,
        sm.first_name,
        sm.enrollment_no,
        vw.stream_name,
        vw.stream_short_name,
        vw.course_short_name,
        vw.course_duration,
        sm.admission_year,
        ps.is_hostel_included,
        sm.lateral_entry,
        sm.stud_id,
        pd.*,
        srd.request_no,

        /* ✅ Correlated subquery instead of JOINed aggregate */
        IFNULL((
            SELECT SUM(fd.amount)
            FROM fees_details fd
            WHERE fd.is_deleted = 'N'
              AND fd.student_id = sm.stud_id
            /* If your fees_details is session-wise, also add: 
               AND fd.academic_year = ad.academic_year */
        ), 0) AS total_fees_paid
    ", false);

    $DB1->from('admission_details ad');
    $DB1->join('student_master sm', 'ad.student_id = sm.stud_id');
    $DB1->join('vw_stream_details vw', 'sm.admission_stream = vw.stream_id');
    $DB1->join('package_structure ps', 'ad.package_id = ps.id');
    $DB1->join('student_request_details srd', 'sm.stud_id = srd.student_id');

    $DB1->join("package_details pd", "ad.package_id = pd.package_id 
        AND pd.stream_id = sm.admission_stream 
        AND pd.admission_session = ad.academic_year 
        AND pd.is_active = 'Y'");

    if (!empty($request_id)) {
        $DB1->where('srd.id', $request_id);
    }
    $DB1->where('ad.student_id', $stud_id);
    $DB1->where('ad.academic_year', $session);
    $DB1->limit(1);

    $result = $DB1->get()->row_array();

    // Optional: quick debug if still failing
    // $err = $DB1->error(); if (!empty($err['code'])) { log_message('error', 'DB ERR: '.print_r($err,true)); }
    // log_message('debug', 'SQL: '.$DB1->last_query());

    return $result ?: false;
}

}