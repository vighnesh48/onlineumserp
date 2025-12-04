<?php
class Onlineapplicationforms_model extends CI_Model 
{
	function __construct()
    {
        
        parent::__construct();
    
    }

	public function getApplications($filter_application_type = null){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "
		SELECT 
		    op.firstname AS name,
		    op.payment_id,
		    op.txtid,
		    sm.school_name,
		    stm.stream_name,
		    op.academic_year,
		    op.productinfo,
		    op.amount,
		    op.payment_mode,
		    op.table_name,
		    op.registration_no AS enrollment_no,
		    op.student_id,
		    op.email,
		    op.phone,
		    cert_data.status AS certificate_status,
		    cert_data.application_no,
		    cert_data.id AS certificate_id,
		    cert_data.submit_status AS certificate_submit_status
		FROM 
		    online_payment op
		LEFT JOIN (
		    SELECT 
		        txnid,id,
		        school_name,
		        stream,
		        status,
		        application_no,
		        submit_status
		    FROM 
		        new_certificate_obtain
		    UNION ALL
		    SELECT 
		        txnid,id,
		        school_name,
		        stream,
		        status,
		        application_no,
		        submit_status
		    FROM 
		        duplicate_certificate_obtain
		    UNION ALL
		    SELECT 
		        txnid,id,
		        school_name,
		        stream,
		        status,
		        application_no,
		        submit_status
		    FROM 
		        correction_certificate_obtain
		    UNION ALL
		    SELECT 
		        txnid,id,
		        school_name,
		        stream,
		        status,
		        application_no,
		        submit_status
		    FROM 
		        transript_certificate_obtain
		) AS cert_data ON op.txtid = cert_data.txnid
		LEFT JOIN 
		    school_master sm ON cert_data.school_name = sm.school_id
		LEFT JOIN 
		    stream_master stm ON cert_data.stream = stm.stream_id
		WHERE 
		    op.payment_status = 'success'
		    
			AND cert_data.txnid IS NOT NULL
		";
		if (!empty($filter_application_type)) {
			$sql .= " AND op.productinfo = '" . $DB1->escape_str($filter_application_type) . "'";
		} 
		$sql .= "order by 
			op.payment_id desc";
		$query = $DB1->query($sql);
		
		return $query->result();
	} 

	public function get_application_formss(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT DISTINCT table_name FROM online_payment WHERE table_name IS NOT NULL AND table_name != ''";
		$query = $DB1->query($sql);
		return $query->result();
	}


	public function get_application_forms() {
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT DISTINCT productinfo, 
				CONCAT(UCASE(SUBSTRING(REPLACE(productinfo, '_', ' '), 1, 1)),
					   LOWER(SUBSTRING(REPLACE(productinfo, '_', ' '), 2))) AS formatted_productinfo
				FROM online_payment 
				WHERE productinfo IN ('duplicate_degree_obtaining_form', 'online_degree_obtaining_form_new', 'online_Transcript_form', 'online_correction_form')";
		$query = $DB1->query($sql);
		return $query->result();  // Make sure the result is as expected
	}
	
	

	public function getStudentData($txtid){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT * FROM online_payment WHERE txtid = '$txtid'";
		$query = $DB1->query($sql);
		return $query->row_array();
	}

	public function updateApplicationStatus($txtid) {
		// Load the second database (umsdb)
		$DB1 = $this->load->database('umsdb', TRUE);
	
		// List of tables to check
		$tables = ['new_certificate_obtain', 'duplicate_certificate_obtain', 'correction_certificate_obtain', 'transript_certificate_obtain'];
	
		// Data to update
		$data = ['status' => 1];
	
		// Loop through each table and update the matching record
		foreach ($tables as $table_name) {
			// Update the table where txnid matches
			$DB1->where('txnid', $txtid);
			$DB1->update($table_name, $data);
	
			// Check if the update was successful
			if ($DB1->affected_rows() > 0) {
				log_message('info', "Updated status in table '{$table_name}' for txnid '{$txtid}'.");
			} else {
				log_message('info', "No matching record found in table '{$table_name}' for txnid '{$txtid}'.");
			}
		}
	}
		
	public function updateApplicationSubmitStatus($txtid) {
		// Load the second database (umsdb)
		$DB1 = $this->load->database('umsdb', TRUE);
		
		// List of tables to check
		$tables = ['new_certificate_obtain', 'duplicate_certificate_obtain', 'correction_certificate_obtain', 'transript_certificate_obtain'];
	
		// Loop through each table and check for txtid
		foreach ($tables as $table_name) {
			// Data to update
			$data = array('submit_status' => 1);
			
			// Check if the row exists for the given txtid
			$DB1->where('txnid', $txtid);
			$DB1->update($table_name, $data);
			
			// Check if the update was successful
			if ($DB1->affected_rows() > 0) {
				log_message('info', "Updated status in table '{$table_name}' for txnid '{$txtid}'.");
			} else {
				log_message('info', "No matching record found in table '{$table_name}' for txnid '{$txtid}'.");
			}
		}
	}
	
	
	




}