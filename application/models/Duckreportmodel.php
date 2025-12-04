<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(E_ALL);
class Duckreportmodel extends CI_Model {
	function __construct()
    {
        parent::__construct();

		$DB1 = $this->load->database('sfumsdb', TRUE);
    }
	public function check_today_records($db) {
        // Get today's date
        $today = date('Y-m-d');
        if($db == 'sf'){
			echo 1;
			$DB1 = $this->load->database('sfumsdb', TRUE);
		}elseif($db == 'sijoul'){
			echo 2;
			$DB1 = $this->load->database('sjumsdb', TRUE);
		}else{
			echo 3;
			$DB1 = $this->load->database('umsdb', TRUE);
		}
        // Query to check records for today
        $DB1->where('DATE(date)', $today);
        $query = $DB1->get('duck_report');
       // echo $DB1->last_query();exit;
        // Return the result (you can adjust based on your needs)
        return $query->num_rows() > 0; // True if records exist, false otherwise
    }	
	public function getLectureTimeTable($academic_year, $date, $academic_session,$db='')
    { 
	  // $con=""
	  //echo $db;exit;
	if($db == 'sf'){
		$DB1 = $this->load->database('sfumsdb', TRUE);
		$database_tbl = 'sandipun_erp_sf.user_master';
	}elseif($db == 'sijoul'){
		$DB1 = $this->load->database('sjumsdb', TRUE);
		$database_tbl = 'sandipun_erp_sijoul.user_master';
	}else{
		$DB1 = $this->load->database('umsdb', TRUE);
		$database_tbl = 'sandipun_erp.user_master';
	}
		
        
    
        $day_of_week = date('l', strtotime($date)); // Get day of the week (e.g., Wednesday)
    //vp.subject_title,'' as subject_title,
        $sql = "
            (SELECT
                ltt.faculty_code, sm.subject_name, sm.subject_code as subcod, ltt.batch_no,
                vwf.fname, vwf.mname, vwf.lname, vwf.designation_name,
                vsd.school_short_name, vsd.stream_short_name,
                ls.from_time, ls.to_time, ls.slot_am_pm,
                ltt.semester, ltt.division, ltt.subject_code, ltt.subject_type, ltt.lecture_slot, ltt.stream_id, vsd.school_id
            FROM lecture_time_table ltt
            
            LEFT JOIN vw_faculty vwf ON vwf.emp_id = ltt.faculty_code
            LEFT JOIN $database_tbl um ON um.username = ltt.faculty_code
            LEFT JOIN subject_master sm ON sm.sub_id = ltt.subject_code
            LEFT JOIN vw_stream_details vsd ON vsd.stream_id = ltt.stream_id
            LEFT JOIN lecture_slot ls ON ls.lect_slot_id = ltt.lecture_slot
			
			
    
            WHERE ltt.academic_year = ?
            AND ltt.academic_session = ?
            AND ltt.wday = ?
            AND vsd.school_short_name NOT IN ('SOD')
           AND ltt.semester  IN (1,2)
            AND (ltt.is_swap IS NULL or ltt.is_swap='N')
            AND ltt.faculty_code != ''
            AND ltt.faculty_code IS NOT NULL
			# AND ltt.subject_code IN('18148','18152','18149','18150','18157')
            # AND ltt.faculty_code=110573
            AND NOT EXISTS (
                SELECT 1
                FROM event_lecture_drop eld
                WHERE eld.school_id = vsd.school_id 
                AND eld.from_date <= ?
                AND eld.to_date >= ?
                AND eld.status = 'Active'
                
                AND (eld.course_id = 0 OR eld.course_id = ltt.course_id)

                AND (eld.stream_id = 0 OR eld.stream_id = ltt.stream_id)

                AND (eld.semester = '' OR eld.semester = ltt.semester)

                AND (eld.division = '' OR eld.division = ltt.division)

                AND (eld.time_slot = '' OR eld.time_slot = ltt.lecture_slot)
            )
    
            GROUP BY faculty_code, subject_code, division, lecture_slot, batch_no, ltt.stream_id, semester  
            )  
    
            UNION ALL  
    
            (SELECT  
                alt.faculty_code, sm.subject_name, sm.subject_code as subcod, alt.batch_no,  
                vwf.fname, vwf.mname, vwf.lname, vwf.designation_name,  
                vsd.school_short_name, vsd.stream_short_name,  
                ls.from_time, ls.to_time, ls.slot_am_pm,  
                alt.semester, alt.division, alt.subject_code, alt.subject_type, alt.lecture_slot, alt.stream_id, vsd.school_id  
            FROM alternet_lecture_time_table alt  
    
            LEFT JOIN vw_faculty vwf ON vwf.emp_id = alt.faculty_code  
            LEFT JOIN $database_tbl um ON um.username = alt.faculty_code  
            LEFT JOIN subject_master sm ON sm.sub_id = alt.subject_code  
            LEFT JOIN vw_stream_details vsd ON vsd.stream_id = alt.stream_id  
            LEFT JOIN lecture_slot ls ON ls.lect_slot_id = alt.lecture_slot  
			# LEFT JOIN vap_subject_title vp ON vp.tid = alt.sub_title_id
    
            WHERE alt.academic_year = ?  
            AND alt.academic_session = ?  
            AND alt.dt_date = ?
            AND vsd.school_short_name NOT IN ('SOD')  
            AND alt.semester IN (1,2)
            AND alt.faculty_code != ''  
            AND alt.faculty_code IS NOT NULL  
			# AND alt.subject_code IN('18148','18152','18149','18150','18157')
            # AND alt.faculty_code=110573
            AND NOT EXISTS (
                SELECT 1 FROM event_lecture_drop eld   
                WHERE eld.school_id = vsd.school_id  
                AND eld.from_date <= ?  
                AND eld.to_date >= ?  
                AND eld.status = 'Active'
    

                AND (eld.course_id = 0 OR eld.course_id = alt.course_id)

                AND (eld.stream_id = 0 OR eld.stream_id = alt.stream_id)

                AND (eld.semester = '' OR eld.semester = alt.semester)

                AND (eld.division = '' OR eld.division = alt.division)

                AND (eld.time_slot = '' OR eld.time_slot = alt.lecture_slot)
            )  
    
            GROUP BY faculty_code, subject_code, division, lecture_slot, batch_no, alt.stream_id, semester  
            )  
            
            ORDER BY school_short_name;
        ";
        
        $query = $DB1->query($sql, [$academic_year, $academic_session, $day_of_week, $date, $date, $academic_year, $academic_session, $date, $date, $date]);
        // echo'<pre>';
         //echo $DB1->last_query();exit;
    
        return $query->result_array();
    }	
	
   public function getLectureTimeTable_vap($academic_year, $date, $academic_session,$db='')
    { 
	  // $con=""
	  //echo $db;exit;
	if($db == 'sf'){
		$DB1 = $this->load->database('sfumsdb', TRUE);
		$database_tbl = 'sandipun_erp_sf.user_master';
	}elseif($db == 'sijoul'){
		$DB1 = $this->load->database('sjumsdb', TRUE);
		$database_tbl = 'sandipun_erp_sijoul.user_master';
	}else{
		$DB1 = $this->load->database('umsdb', TRUE);
		$database_tbl = 'sandipun_erp.user_master';
	}
		
        
    
        $day_of_week = date('l', strtotime($date)); // Get day of the week (e.g., Wednesday)
    //vp.subject_title,'' as subject_title,
        $sql = "
            (SELECT
                ltt.faculty_code, sm.subject_name, sm.subject_code as subcod, ltt.batch_no,
                vwf.fname, vwf.mname, vwf.lname, vwf.designation_name,
                vsd.school_short_name, vsd.stream_short_name,
                ls.from_time, ls.to_time, ls.slot_am_pm,
                ltt.semester, ltt.division, ltt.subject_code, ltt.subject_type, ltt.lecture_slot, ltt.stream_id, vsd.school_id,vp.subject_title
            FROM lecture_time_table ltt
            
            LEFT JOIN vw_faculty vwf ON vwf.emp_id = ltt.faculty_code
            LEFT JOIN $database_tbl um ON um.username = ltt.faculty_code
            LEFT JOIN subject_master sm ON sm.sub_id = ltt.subject_code
            LEFT JOIN vw_stream_details vsd ON vsd.stream_id = ltt.stream_id
            LEFT JOIN lecture_slot ls ON ls.lect_slot_id = ltt.lecture_slot
			LEFT JOIN vap_subject_title vp ON vp.tid = ltt.sub_title_id
			
    
            WHERE ltt.academic_year = ?
            AND ltt.academic_session = ?
            AND ltt.wday = ?
            AND vsd.school_short_name NOT IN ('SOD')
			#AND ltt.semester IN (1,2)
            AND (ltt.is_swap IS NULL or ltt.is_swap='N')
            AND ltt.faculty_code != ''
            AND ltt.faculty_code IS NOT NULL
		    AND ltt.subject_code IN('18148','18152','18149','18150','18157')
            # AND ltt.faculty_code=110573
            AND NOT EXISTS (
                SELECT 1
                FROM event_lecture_drop eld
                WHERE eld.school_id = vsd.school_id 
                AND eld.from_date <= ?
                AND eld.to_date >= ?
                AND eld.status = 'Active'
                
                AND (eld.course_id = 0 OR eld.course_id = ltt.course_id)

                AND (eld.stream_id = 0 OR eld.stream_id = ltt.stream_id)

                AND (eld.semester = '' OR eld.semester = ltt.semester)

                AND (eld.division = '' OR eld.division = ltt.division)

                AND (eld.time_slot = '' OR eld.time_slot = ltt.lecture_slot)
            )
    
            GROUP BY faculty_code, subject_code, division, lecture_slot, batch_no, ltt.stream_id, semester  
            )  
    
            UNION ALL  
    
            (SELECT  
                alt.faculty_code, sm.subject_name, sm.subject_code as subcod, alt.batch_no,  
                vwf.fname, vwf.mname, vwf.lname, vwf.designation_name,  
                vsd.school_short_name, vsd.stream_short_name,  
                ls.from_time, ls.to_time, ls.slot_am_pm,  
                alt.semester, alt.division, alt.subject_code, alt.subject_type, alt.lecture_slot, alt.stream_id, vsd.school_id ,'' as subject_title 
            FROM alternet_lecture_time_table alt  
    
            LEFT JOIN vw_faculty vwf ON vwf.emp_id = alt.faculty_code  
            LEFT JOIN $database_tbl um ON um.username = alt.faculty_code  
            LEFT JOIN subject_master sm ON sm.sub_id = alt.subject_code  
            LEFT JOIN vw_stream_details vsd ON vsd.stream_id = alt.stream_id  
            LEFT JOIN lecture_slot ls ON ls.lect_slot_id = alt.lecture_slot  
			# LEFT JOIN vap_subject_title vp ON vp.tid = alt.sub_title_id
    
            WHERE alt.academic_year = ?  
            AND alt.academic_session = ?  
            AND alt.dt_date = ?
            AND vsd.school_short_name NOT IN ('SOD')
            #AND alt.semester IN (1,2)
			
            AND alt.faculty_code != ''  
            AND alt.faculty_code IS NOT NULL  
		    AND alt.subject_code IN('18148','18152','18149','18150','18157')
            # AND alt.faculty_code=110573
            AND NOT EXISTS (
                SELECT 1 FROM event_lecture_drop eld  
                WHERE eld.school_id = vsd.school_id  
                AND eld.from_date <= ?  
                AND eld.to_date >= ?  
                AND eld.status = 'Active'
    

                AND (eld.course_id = 0 OR eld.course_id = alt.course_id)

                AND (eld.stream_id = 0 OR eld.stream_id = alt.stream_id)

                AND (eld.semester = '' OR eld.semester = alt.semester)

                AND (eld.division = '' OR eld.division = alt.division)

                AND (eld.time_slot = '' OR eld.time_slot = alt.lecture_slot)
            )  
    
            GROUP BY faculty_code, subject_code, division, lecture_slot, batch_no, alt.stream_id, semester  
            )  
            
            ORDER BY school_short_name;
        ";
        
        $query = $DB1->query($sql, [$academic_year, $academic_session, $day_of_week, $date, $date, $academic_year, $academic_session, $date, $date, $date]);
        // echo'<pre>';
         //echo $DB1->last_query();exit;
    
        return $query->result_array();
    }	
	

 public function getLectureTimeTablesod($academic_year, $date, $academic_session,$is_sod='')
    { 
	  // $con=""
	
		
        $DB1 = $this->load->database('umsdb', TRUE);
    
        $day_of_week = date('l', strtotime($date)); // Get day of the week (e.g., Wednesday)
    
        $sql = "
            (SELECT
                ltt.faculty_code, sm.subject_name,vp.subject_title, sm.subject_code as subcod, ltt.batch_no,
                vwf.fname, vwf.mname, vwf.lname, vwf.designation_name,
                vsd.school_short_name, vsd.stream_short_name,
                ls.from_time, ls.to_time, ls.slot_am_pm,
                ltt.semester, ltt.division, ltt.subject_code, ltt.subject_type, ltt.lecture_slot, ltt.stream_id, vsd.school_id
            FROM lecture_time_table ltt
            
            LEFT JOIN vw_faculty vwf ON vwf.emp_id = ltt.faculty_code
            LEFT JOIN sandipun_erp.user_master um ON um.username = ltt.faculty_code
            LEFT JOIN subject_master sm ON sm.sub_id = ltt.subject_code
            LEFT JOIN vw_stream_details vsd ON vsd.stream_id = ltt.stream_id
            LEFT JOIN lecture_slot ls ON ls.lect_slot_id = ltt.lecture_slot
			LEFT JOIN vap_subject_title vp ON vp.tid = ltt.sub_title_id
			
    
            WHERE ltt.academic_year = ?
            AND ltt.academic_session = ?
            AND ltt.tdate = ?
            AND vsd.school_short_name  IN ('SOD')
			AND ltt.semester IN (1,2)
            AND (ltt.is_swap IS NULL or ltt.is_swap='N')
            AND ltt.faculty_code != ''
            AND ltt.faculty_code IS NOT NULL
			# AND ltt.subject_code IN('18148','18152','18149','18150','18157')
            # AND ltt.faculty_code=110573
            AND NOT EXISTS (
                SELECT 1
                FROM event_lecture_drop eld
                WHERE eld.school_id = vsd.school_id 
                AND eld.from_date <= ?
                AND eld.to_date >= ?
                AND eld.status = 'Active'
                
                AND (eld.course_id = 0 OR eld.course_id = ltt.course_id)

                AND (eld.stream_id = 0 OR eld.stream_id = ltt.stream_id)

                AND (eld.semester = '' OR eld.semester = ltt.semester)

                AND (eld.division = '' OR eld.division = ltt.division)

                AND (eld.time_slot = '' OR eld.time_slot = ltt.lecture_slot)
            )
    
            GROUP BY faculty_code, subject_code, division, lecture_slot, batch_no, ltt.stream_id, semester  
            )  
    
            UNION ALL  
    
            (SELECT  
                alt.faculty_code, sm.subject_name,'' as subject_title, sm.subject_code as subcod, alt.batch_no,  
                vwf.fname, vwf.mname, vwf.lname, vwf.designation_name,  
                vsd.school_short_name, vsd.stream_short_name,  
                ls.from_time, ls.to_time, ls.slot_am_pm,  
                alt.semester, alt.division, alt.subject_code, alt.subject_type, alt.lecture_slot, alt.stream_id, vsd.school_id  
            FROM alternet_lecture_time_table alt  
    
            LEFT JOIN vw_faculty vwf ON vwf.emp_id = alt.faculty_code  
            LEFT JOIN sandipun_erp.user_master um ON um.username = alt.faculty_code  
            LEFT JOIN subject_master sm ON sm.sub_id = alt.subject_code  
            LEFT JOIN vw_stream_details vsd ON vsd.stream_id = alt.stream_id  
            LEFT JOIN lecture_slot ls ON ls.lect_slot_id = alt.lecture_slot  
			# LEFT JOIN vap_subject_title vp ON vp.tid = alt.sub_title_id
    
            WHERE alt.academic_year = ?  
            AND alt.academic_session = ?  
            AND alt.dt_date = ?
            AND vsd.school_short_name  IN ('SOD')  
			#AND alt.semester NOT IN (1,2)
            AND alt.faculty_code != ''  
            AND alt.faculty_code IS NOT NULL  
			# AND alt.subject_code IN('18148','18152','18149','18150','18157')
            # AND alt.faculty_code=110573
            AND NOT EXISTS (
                SELECT 1 FROM event_lecture_drop eld  
                WHERE eld.school_id = vsd.school_id  
                AND eld.from_date <= ?  
                AND eld.to_date >= ?  
                AND eld.status = 'Active'
    

                AND (eld.course_id = 0 OR eld.course_id = alt.course_id)

                AND (eld.stream_id = 0 OR eld.stream_id = alt.stream_id)

                AND (eld.semester = '' OR eld.semester = alt.semester)

                AND (eld.division = '' OR eld.division = alt.division)

                AND (eld.time_slot = '' OR eld.time_slot = alt.lecture_slot)
            )  
    
            GROUP BY faculty_code, subject_code, division, lecture_slot, batch_no, alt.stream_id, semester  
            )  
            
            ORDER BY school_short_name;
        ";
        
        $query = $DB1->query($sql, [$academic_year, $academic_session, $date, $date, $date, $academic_year, $academic_session, $date, $date, $date]);
        // echo'<pre>';
        //echo $DB1->last_query();exit;
    
        return $query->result_array();
    }	
			
		
    public function getLectureTimeTableasxcas($academic_year, $date, $academic_session) {
		//echo 1;exit;
		$DB1 = $this->load->database('sfumsdb', TRUE);
        
        $day_of_week = date('l', strtotime($date)); // Get day of the week (e.g., Wednesday)
    
        $DB1->select('
            ltt.faculty_code,ltt.stream_id, sm.subject_name, sm.subject_code as subcod,ltt.batch_no,
            vwf.fname, vwf.mname, vwf.lname, vwf.designation_name, 
            vsd.school_short_name, vsd.stream_short_name, 
            ls.from_time, ls.to_time, ls.slot_am_pm,
            ltt.semester, ltt.division, ltt.subject_code, ltt.subject_type, ltt.lecture_slot
        ');
        $DB1->from('lecture_time_table ltt');
        $DB1->join('vw_faculty vwf', 'vwf.emp_id = ltt.faculty_code', 'left');
        $DB1->join('subject_master sm', 'sm.sub_id = ltt.subject_code', 'left');
        $DB1->join('vw_stream_details vsd', 'vsd.stream_id = ltt.stream_id', 'left');
        $DB1->join('lecture_slot ls', 'ls.lect_slot_id = ltt.lecture_slot', 'left');
        $DB1->where('ltt.academic_year', $academic_year);
        $DB1->where('ltt.academic_session', $academic_session); 
		$DB1->where_not_in('vsd.school_short_name', ['SOD']);
        $DB1->where('ltt.wday', $day_of_week);
        $DB1->where('ltt.faculty_code is not null');
        $DB1->where('ltt.faculty_code!=""');
        //$DB1->where_in('ltt.faculty_code','211672');
        $DB1->group_by('faculty_code, subject_code, division, lecture_slot,batch_no,ltt.stream_id,semester');
        $DB1->order_by('vsd.school_short_name');
       // $DB1->where('vsd.school_id', '1');
        $query = $DB1->get();
        // Uncomment for debugging,'110492','110517','662669','662680'
       // echo $DB1->last_query(); exit;
    
        return $query->result_array();
    }
	public function getLectureTimeTable11($academic_year, $date, $academic_session)
    {
        $DB1 = $this->load->database('sfumsdb', TRUE);
        
  
        $day_of_week = date('l', strtotime($date)); // Get day of the week (e.g., Wednesday)
    
        $sql = "
            (SELECT                                                                                                     
                ltt.faculty_code, sm.subject_name, sm.subject_code as subcod, ltt.batch_no,                                                                     
                vwf.fname, vwf.mname, vwf.lname, vwf.designation_name,                                                                      
                vsd.school_short_name, vsd.stream_short_name,                                                                       
                ls.from_time, ls.to_time, ls.slot_am_pm,                                                                    
                ltt.semester, ltt.division, ltt.subject_code, ltt.subject_type, ltt.lecture_slot, ltt.stream_id,vsd.school_id                                                                     
            FROM lecture_time_table ltt                                                                             
    
            LEFT JOIN vw_faculty vwf ON vwf.emp_id = ltt.faculty_code      
            LEFT JOIN sandipun_erp_sf.user_master um ON um.username = ltt.faculty_code                                                             
            LEFT JOIN subject_master sm ON sm.sub_id = ltt.subject_code                                                                     
            LEFT JOIN vw_stream_details vsd ON vsd.stream_id = ltt.stream_id                                                                    
            LEFT JOIN lecture_slot ls ON ls.lect_slot_id = ltt.lecture_slot                                                                     
            WHERE ltt.academic_year = ?                                                                             
    
            AND ltt.academic_session = ?                                                                            
            AND ltt.wday = ?                                                                                                
    
            AND vsd.school_short_name NOT IN ('SOD')                                                                    
            AND ltt.is_swap = ''                                                                                     
            AND ltt.faculty_code != ''                                                                              
            AND ltt.faculty_code IS NOT NULL                                                                            

    
            GROUP BY faculty_code, subject_code, division, lecture_slot, batch_no, ltt.stream_id, semester                                                                      
            )                                                                                                       
            UNION ALL                                                                                                   
            (SELECT 
                alt.faculty_code, sm.subject_name, sm.subject_code as subcod, alt.batch_no,
                vwf.fname, vwf.mname, vwf.lname, vwf.designation_name, 
                vsd.school_short_name, vsd.stream_short_name, 
                ls.from_time, ls.to_time, ls.slot_am_pm,
                alt.semester, alt.division, alt.subject_code, alt.subject_type, alt.lecture_slot, alt.stream_id,vsd.school_id  
            FROM alternet_lecture_time_table alt
    
            LEFT JOIN vw_faculty vwf ON vwf.emp_id = alt.faculty_code
            LEFT JOIN sandipun_erp_sf.user_master um ON um.username = alt.faculty_code   
            LEFT JOIN subject_master sm ON sm.sub_id = alt.subject_code
            LEFT JOIN vw_stream_details vsd ON vsd.stream_id = alt.stream_id
            LEFT JOIN lecture_slot ls ON ls.lect_slot_id = alt.lecture_slot
            WHERE alt.academic_year = ? 
            AND alt.academic_session = ?
            AND alt.wday = ?
            AND vsd.school_short_name NOT IN ('SOD')
            AND alt.faculty_code != ''
            AND alt.faculty_code IS NOT NULL
  
    
            GROUP BY faculty_code, subject_code, division, lecture_slot, batch_no, alt.stream_id, semester
            )
            ORDER BY school_short_name;
        ";
    
        $query = $DB1->query($sql, [$academic_year, $academic_session, $day_of_week, $academic_year, $academic_session, $day_of_week]);
    
        echo $DB1->last_query();exit;
        return $query->result_array();
    }
    
      public function checkAttendance($academic_year, $date, $faculty_code, $subject_id, $lecture_slot, $academic_session,$division,$batch_no,$stream_id,$semester) {
        $DB1 = $this->load->database('sfumsdb', TRUE);
        $DB1->select('faculty_code');
        $DB1->from('lecture_attendance');
        $DB1->where('academic_year', $academic_year);
        $DB1->where('academic_session', $academic_session);
        $DB1->where('attendance_date', $date);
     //   $DB1->where('faculty_code', $faculty_code);
     //   $DB1->where('subject_id', $subject_id);
        $DB1->where('slot', $lecture_slot);
        $DB1->where('division', $division);
        $DB1->where('batch', $batch_no);
        $DB1->where('stream_id', $stream_id);
        $DB1->where('semester', $semester);
        $DB1->group_by('faculty_code, subject_id, slot, division, attendance_date, batch,stream_id,semester');
        $query = $DB1->get();
        //echo '<pre>';
      // echo $DB1->last_query();exit;
        return $query->row_array();
    }

public function getLectureTimeTable111($academic_year, $date, $academic_session)
    {
        $DB1 = $this->load->database('sfumsdb', TRUE);
        
  
        $day_of_week = date('l', strtotime($date)); // Get day of the week (e.g., Wednesday)
    
        $sql = "
            (SELECT                                                                                                     
                ltt.faculty_code, sm.subject_name, sm.subject_code as subcod, ltt.batch_no,                                                                     
                vwf.fname, vwf.mname, vwf.lname, vwf.designation_name,                                                                      
                vsd.school_short_name, vsd.stream_short_name,                                                                       
                ls.from_time, ls.to_time, ls.slot_am_pm,                                                                    
                ltt.semester, ltt.division, ltt.subject_code, ltt.subject_type, ltt.lecture_slot, ltt.stream_id                                                                     
            FROM lecture_time_table ltt                                                                             
    
            LEFT JOIN vw_faculty vwf ON vwf.emp_id = ltt.faculty_code      
            LEFT JOIN sandipun_erp_sf.user_master um ON um.username = ltt.faculty_code                                                             
            LEFT JOIN subject_master sm ON sm.sub_id = ltt.subject_code                                                                     
            LEFT JOIN vw_stream_details vsd ON vsd.stream_id = ltt.stream_id                                                                    
            LEFT JOIN lecture_slot ls ON ls.lect_slot_id = ltt.lecture_slot                                                                     
            WHERE ltt.academic_year = ?                                                                             
    
            AND ltt.academic_session = ?                                                                            
            AND ltt.wday = ?                                                                                                
    
            AND vsd.school_short_name NOT IN ('SOD')                                                                    
            AND ltt.is_swap = ''                                                                                     
            AND ltt.faculty_code != ''                                                                              
            AND ltt.faculty_code IS NOT NULL                                                                            

    
            GROUP BY faculty_code, subject_code, division, lecture_slot, batch_no, ltt.stream_id, semester                                                                      
            )                                                                                                       
            UNION ALL                                                                                                   
            (SELECT 
                alt.faculty_code, sm.subject_name, sm.subject_code as subcod, alt.batch_no,
                vwf.fname, vwf.mname, vwf.lname, vwf.designation_name, 
                vsd.school_short_name, vsd.stream_short_name, 
                ls.from_time, ls.to_time, ls.slot_am_pm,
                alt.semester, alt.division, alt.subject_code, alt.subject_type, alt.lecture_slot, alt.stream_id
            FROM alternet_lecture_time_table alt
    
            LEFT JOIN vw_faculty vwf ON vwf.emp_id = alt.faculty_code
            LEFT JOIN sandipun_erp_sf.user_master um ON um.username = alt.faculty_code   
            LEFT JOIN subject_master sm ON sm.sub_id = alt.subject_code
            LEFT JOIN vw_stream_details vsd ON vsd.stream_id = alt.stream_id
            LEFT JOIN lecture_slot ls ON ls.lect_slot_id = alt.lecture_slot
            WHERE alt.academic_year = ? 
            AND alt.academic_session = ?
            AND alt.wday = ?
            AND vsd.school_short_name NOT IN ('SOD')
            AND alt.faculty_code != ''
            AND alt.faculty_code IS NOT NULL
  
    
            GROUP BY faculty_code, subject_code, division, lecture_slot, batch_no, alt.stream_id, semester
            )
            ORDER BY school_short_name;
        ";
    
        $query = $DB1->query($sql, [$academic_year, $academic_session, $day_of_week, $academic_year, $academic_session, $day_of_week]);
    
      //  echo $DB1->last_query();exit;
        return $query->result_array();
    }
    public function getTotalLectures($faculty_code, $academic_year, $academic_session, $month, $end_date, $lv) {
        $DB1 = $this->load->database('sfumsdb', TRUE);
      //  $faculty_code = '110073';
        
        // Get lecture timetable with batch and division
        $DB1->select('lecture_slot, subject_code, wday, batch_no, division');
        $DB1->from('lecture_time_table');
        $DB1->where('academic_year', $academic_year);
        $DB1->where('academic_session', $academic_session);
        $DB1->where_in('faculty_code', [$faculty_code]); // Dynamic faculty_code
        $DB1->group_by('subject_code, division, lecture_slot, batch_no, wday,stream_id,semester'); // Ensure batch_no and division are included
        $DB1->order_by('subject_code', 'ASC');
        $timetable = $DB1->get()->result_array();
        
        // Get attendance records
         $start_date = $month . '-10';
         $end_date = date("Y-m-d");//exit;
        
        $DB1->select('slot, subject_id, attendance_date, batch, division');
        $DB1->from('lecture_attendance');
        $DB1->where('academic_year', $academic_year);
        $DB1->where('academic_session', $academic_session);
        $DB1->where('attendance_date >=', $start_date);
        $DB1->where('attendance_date <=', $end_date);
        $DB1->where_in('faculty_code', [$faculty_code]);
        $DB1->group_by('faculty_code, slot, division, subject_id, attendance_date, batch,stream_id,semester');
        $DB1->order_by('subject_id', 'ASC');
        $attendance = $DB1->get()->result_array();
        
        // Map weekdays to dates
        $dates_by_weekday = [];
        $current_date = strtotime($start_date);
        while ($current_date <= strtotime($end_date)) {
            $weekday = date('l', $current_date); // Monday, Tuesday, etc.
            $dates_by_weekday[$weekday][] = date('Y-m-d', $current_date);
            $current_date = strtotime("+1 day", $current_date);
        }
        
        // Calculate total scheduled lectures per subject, per batch, per division
        $scheduled_lectures = [];
        foreach ($timetable as $lecture) {
            $subject_code = $lecture['subject_code'];
            $slot = $lecture['lecture_slot'];
            $weekday = $lecture['wday'];
            $batch_no = $lecture['batch_no'];
            $division = $lecture['division'];
        
            if (isset($dates_by_weekday[$weekday])) {
                $count = count($dates_by_weekday[$weekday]); // Total days lecture should happen
        
                // Create a key for each subject-batch-division combination
                $key = $subject_code . '_' . $batch_no . '_' . $division. '_' . $slot;
        
                if (!isset($scheduled_lectures[$key])) {
                    $scheduled_lectures[$key] = 0;
                }
        
                $scheduled_lectures[$key] += $count;
            }
        }
        
        // Print results for debugging
    //    echo '<pre>';

     //   print_r($scheduled_lectures);exit;
    
        // Calculate conducted lectures per subject
        $conducted_lectures = [];
        foreach ($attendance as $att) {
            $subject_id = $att['subject_id'];
            $batch_no = $att['batch'];
            $division = $att['division'];
            $slot = $att['slot'];
			
        
            // Create a unique key for each subject-batch-division combination
            $key = $subject_id . '_' . $batch_no . '_' . $division . '_' . $slot;
        
            if (!isset($conducted_lectures[$key])) {
                $conducted_lectures[$key] = 0;
            }
        
            $conducted_lectures[$key]++;
        }
        
        
    //    print_r($conducted_lectures);exit;
    
        return [
            'scheduled_lectures' => $scheduled_lectures, // Total lectures in the month per subject
            'conducted_lectures' => $conducted_lectures // Lectures actually conducted in the month per subject

        ];
    }



   function check_leave($fact, $dt)
    {
        $sql = "select lid,emp_id,applied_from_date,applied_to_date,leave_duration,CASE WHEN l.leave_type ='official' THEN 'OD' ELSE CASE WHEN l.leave_type ='LWP' THEN 'LWP' ELSE ea.leave_type END  END AS leave_name FROM leave_applicant_list l LEFT JOIN employee_leave_allocation ea ON l.`leave_type`=ea.`id` WHERE emp_id='" . $fact . "' and fstatus = 'Approved' and month(applied_from_date)='" . date('m', strtotime($dt)) . "' and YEAR(applied_from_date)='" . date('Y', strtotime($dt)) . "' ";
        $query = $this->db->query($sql);
      //  echo $this->db->last_query();exit;
        $result = $query->result_array();
        $ldate = [];
        $cnt = count($result);
        if ($cnt > 0) {
            foreach ($result as $key => $value) {
                if ($value['leave_duration'] == 'full-day') {
                    $s = 'Full Day';
                } else {
                    $s = 'Half Day';
                }
                if (date('Y-m-d', strtotime($value['applied_from_date'])) != date('Y-m-d', strtotime($value['applied_to_date']))) {
                    $darr = $this->get_dates($value['applied_from_date'], $value['applied_to_date']);

                    $l = $value['leave_name'] . "(" . $s . ")";
                    foreach ($darr as $dv) {
                        $ldate[$l][] = date('Y-m-d', strtotime($dv));
                    }
                } else {
                    $l = $value['leave_name'] . "(" . $s . ")";
                    $ldate[$l][] = date('Y-m-d', strtotime($value['applied_from_date']));


                }
            }
         //   print_r($ldate);exit;
            foreach ($ldate as $key1 => $value1) {

                if (in_array(date('Y-m-d', strtotime($dt)), $value1)) {
                    return $lev = $key1.'~'.$value['applied_from_date'].'~'.$value['applied_to_date'];
                } else {
                    $lev = 'N';
                }

            }
          //  echo $lev;exit;
        } else {
            $lev = 'N';
        }

       // echo $lev;exit;
        return $lev;
    }


 function get_dates($Date1,$Date2){
        

        // Declare two dates 
        //$Date1 = '01-10-2010'; 
        //$Date2 = '05-10-2010'; 
        
        // Declare an empty array 
        $array = array(); 
        
        // Use strtotime function 
        $Variable1 = strtotime($Date1); 
        $Variable2 = strtotime($Date2); 
        
        // Use for loop to store dates into array 
        // 86400 sec = 24 hrs = 60*60*24 = 1 day 
        for ($currentDate = $Variable1; $currentDate <= $Variable2; 
                                        $currentDate += (86400)) { 
                                            
        $Store = date('Y-m-d', $currentDate); 
        $array[] = $Store; 
        } 
        
        // Display the dates in array format 
        return $array; 
        
        
            }
    

   public function getDuckReport($date, $academic_year, $academic_session,$school_id='',$db,$hod) {
	  // echo $school_id;
   if($db == 'sf'){
		$DB1 = $this->load->database('sfumsdb', TRUE);
		$database_tbl = 'sandipun_erp_sf.user_master';
	}elseif($db == 'sijoul'){
		$DB1 = $this->load->database('sjumsdb', TRUE);
		$database_tbl = 'sandipun_erp_sijoul.user_master';
	}else{
		$DB1 = $this->load->database('umsdb', TRUE);
		$database_tbl = 'sandipun_erp.user_master';
	}
               $DB1->select('dr.*');
        $DB1->from('duck_report dr');
        $DB1->join("$database_tbl um", 'um.username = dr.faculty_code', 'left');
        $DB1->where('dr.date', $date);
        $DB1->where('dr.academic_year', $academic_year);
        $DB1->where('dr.academic_session', $academic_session);
		if($hod!=''){
			$DB1->where_in('um.roles_id', [20,44]);
		}
	   if($school_id!=''){
		   $DB1->where_in('dr.school_id',$school_id);
	   }
        
        $DB1->order_by('dr.today_ducks', 'desc');
		 //$DB1->limit(135,100);
        $query = $DB1->get();
             // echo $DB1->last_query();exit;
                return $query->result_array();
            }
		
	public function getVapDuckReport($date, $academic_year, $academic_session,$school_id='') {
	  // echo $school_id;
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select('dr.*');
        $DB1->from('vap_attendance_report dr');
        $DB1->join('sandipun_erp_sf.user_master um', 'um.username = dr.faculty_code', 'left');
        $DB1->where('dr.date', $date);
        $DB1->where('dr.academic_year', $academic_year);
        $DB1->where('dr.academic_session', $academic_session);
      // $DB1->where_in('um.roles_id', [20,44]);
	   if($school_id!=''){
		   $DB1->where_in('dr.school_id',$school_id);
	   }
        
        $DB1->order_by('dr.today_ducks', 'desc');
		 //$DB1->limit(135,100);
        $query = $DB1->get();
             // echo $DB1->last_query();exit;
                return $query->result_array();
     }
            public function getCumulativeDucks($faculty_code, $date, $academic_year, $academic_session,$db) {
               if($db == 'sf'){
					$DB1 = $this->load->database('sfumsdb', TRUE);
					$database_tbl = 'sandipun_erp_sf.user_master';
				}elseif($db == 'sijoul'){
					$DB1 = $this->load->database('sjumsdb', TRUE);
					$database_tbl = 'sandipun_erp_sijoul.user_master';
				}else{
					$DB1 = $this->load->database('umsdb', TRUE);
					$database_tbl = 'sandipun_erp.user_master';
				}

                $start_date = date('Y-m-01', strtotime($date)); // Get first date of the month
            
                $DB1->select('SUM(today_ducks) as total_ducks');
                $DB1->from('duck_report');
                $DB1->where('faculty_code', $faculty_code);
                $DB1->where('academic_year', $academic_year);
                $DB1->where('academic_session', $academic_session);
                $DB1->where('date >=', $start_date);
                $DB1->where('date <=', $date);
                $query = $DB1->get();
            //    echo $DB1->last_query();exit;
                $result = $query->row_array();
                return $result['total_ducks'] ?? 0;
            }        
			public function getCumulativeVapDucks($faculty_code, $date, $academic_year, $academic_session) {
                $DB1 = $this->load->database('umsdb', TRUE);

                $start_date = date('Y-m-01', strtotime($date)); // Get first date of the month
            
                $DB1->select('SUM(today_ducks) as total_ducks');
                $DB1->from('vap_attendance_report');
                $DB1->where('faculty_code', $faculty_code);
                $DB1->where('academic_year', $academic_year);
                $DB1->where('academic_session', $academic_session);
                $DB1->where('date >=', $start_date);
                $DB1->where('date <=', $date);
                $query = $DB1->get();
            //    echo $DB1->last_query();exit;
                $result = $query->row_array();
                return $result['total_ducks'] ?? 0;
            }
  public function insertDuckReport($faculty_code, $faculty, $date, $academic_year, $academic_session, $total_ducks, $details) {
                $DB1 = $this->load->database('sfumsdb', TRUE);
                $data = [
                    'faculty_code' => $faculty_code,
                    'faculty' => $faculty,
                    'date' => $date,
                    'academic_year' => $academic_year,
                    'academic_session' => $academic_session,
                    'today_ducks' => $total_ducks,
                    'details' => json_encode($details) // Store additional details as JSON
                ];
        
                $DB1->insert('duck_report', $data);
				
				
                return $DB1->insert_id(); // Return the last inserted ID
            }
			
			/// Duck report for Scool of Design

   public function getLectureTimeTable_sod($academic_year, $date, $academic_session) {
		$DB1 = $this->load->database('sfumsdb', TRUE);
        
        $day_of_week = date('l', strtotime($date)); // Get day of the week (e.g., Wednesday)
    
        $DB1->select('
            ltt.faculty_code,ltt.stream_id, sm.subject_name, sm.subject_code as subcod,ltt.batch_no,ltt.tdate,
            vwf.fname, vwf.mname, vwf.lname, vwf.designation_name, 
            vsd.school_short_name, vsd.stream_short_name, 
            ls.from_time, ls.to_time, ls.slot_am_pm,
            ltt.semester, ltt.division, ltt.subject_code, ltt.subject_type, ltt.lecture_slot
        ');
        $DB1->from('lecture_time_table ltt');
        $DB1->join('vw_faculty vwf', 'vwf.emp_id = ltt.faculty_code', 'left');
        $DB1->join('subject_master sm', 'sm.sub_id = ltt.subject_code', 'left');
        $DB1->join('vw_stream_details vsd', 'vsd.stream_id = ltt.stream_id', 'left');
        $DB1->join('lecture_slot ls', 'ls.lect_slot_id = ltt.lecture_slot', 'left');
        $DB1->where('ltt.academic_year', $academic_year);
        $DB1->where('ltt.academic_session', $academic_session); 
		$DB1->where_in('vsd.school_short_name', ['SOD']);
        ///$DB1->where('ltt.wday', $day_of_week);
        $DB1->where('ltt.tdate', $date);
        $DB1->where('ltt.faculty_code is not null');
        $DB1->where('ltt.faculty_code!=""');
		$sem=array(1,2);
        $DB1->where_in('ltt.semester', $sem);
        //$DB1->where_in('ltt.faculty_code','211672');
        $DB1->group_by('faculty_code, subject_code, division, lecture_slot,batch_no,ltt.stream_id,semester');
        $DB1->order_by('vsd.school_short_name');
       // $DB1->where('vsd.school_id', '1');
        $query = $DB1->get();
        // Uncomment for debugging,'110492','110517','662669','662680'
       //echo $DB1->last_query(); exit;
    
        return $query->result_array();
    } 
	//////////////////////////////////
	 public function checkAttendance_new_old($academic_year, $date, $faculty_code, $subject_id, $lecture_slot, $academic_session, $division, $batch_no, $stream_id, $semester,$db='')
    {
		if($db == 'sf'){
			$DB1 = $this->load->database('sfumsdb', TRUE);
			$database_tbl = 'sandipun_erp_sf.user_master';
		}elseif($db == 'sijoul'){
			$DB1 = $this->load->database('sjumsdb', TRUE);
			$database_tbl = 'sandipun_erp_sijoul.user_master';
		}else{
			$DB1 = $this->load->database('umsdb', TRUE);
			$database_tbl = 'sandipun_erp.user_master';
		}
	
        $DB1->select('SUM(is_present = "Y") AS present_count, SUM(is_present = "N") AS absent_count,count(is_present) as total, faculty_code');
        $DB1->from('lecture_attendance');
        $DB1->where('academic_year', $academic_year);
        $DB1->where('academic_session', $academic_session);
        $DB1->where('attendance_date', $date);
        //   $DB1->where('faculty_code', $faculty_code);
        //   $DB1->where('subject_id', $subject_id);
        $DB1->where('slot', $lecture_slot);
        $DB1->where('division', $division);
        $DB1->where('batch', $batch_no);
        $DB1->where('stream_id', $stream_id);
        $DB1->where('semester', $semester);
        $DB1->group_by('faculty_code, subject_id, slot, division, attendance_date, batch,stream_id,semester');
        $query = $DB1->get();
       // echo '<pre>';
       // echo $DB1->last_query(); exit;
        return $query->row_array();
    }
	public function checkAttendance_new($academic_year, $date, $faculty_code, $subject_id, $lecture_slot, $academic_session, $division, $batch_no, $stream_id, $semester, $db = '')
{
    if ($db == 'sf') {
        $DB1 = $this->load->database('sfumsdb', TRUE);
        $database_tbl = 'sandipun_erp_sf.user_master';
    } elseif ($db == 'sijoul') {
        $DB1 = $this->load->database('sjumsdb', TRUE);
        $database_tbl = 'sandipun_erp_sijoul.user_master';
    } else {
        $DB1 = $this->load->database('umsdb', TRUE);
        $database_tbl = 'sandipun_erp.user_master';
    }

    // 🔹 First check in lecture_attendance
    $DB1->select('
        SUM(is_present = "Y") AS present_count, 
        SUM(is_present = "N") AS absent_count,
        COUNT(is_present) as total,
        faculty_code,
        subject_id
    ');
    $DB1->from('lecture_attendance');
    $DB1->where('academic_year', $academic_year);
    $DB1->where('academic_session', $academic_session);
    $DB1->where('attendance_date', $date);
    $DB1->where('slot', $lecture_slot);
    $DB1->where('division', $division);
    $DB1->where('batch', $batch_no);
    $DB1->where('stream_id', $stream_id);
    $DB1->where('semester', $semester);
    $DB1->group_by('faculty_code, subject_id, slot, division, attendance_date, batch, stream_id, semester');
    $query = $DB1->get();
    $result = $query->row_array();

    // 🔹 If no record found, fallback to student_batch_allocation
    if (empty($result) || $result['total'] == 0) {
        $DB1->select('
            0 as present_count,
            0 as absent_count,
            COUNT(student_id) as total
        ');
        $DB1->from('student_batch_allocation');
        $DB1->where('academic_year', $academic_year);
        #$DB1->where('academic_session', $academic_session);
        $DB1->where('division', $division);
		if (!empty($batch_no) && $batch_no != 0) {
		$DB1->where('batch', $batch_no);
		}
		$DB1->where('stream_id', $stream_id);
        $DB1->where('semester', $semester);
        $DB1->where('active', 'Y');
        $query = $DB1->get();
        $result = $query->row_array();
    }

    return $result;
}

	  public function insertDuckReport_new($faculty_code, $faculty, $date, $academic_year, $academic_session, $total_ducks, $details,$school_id,$db) {
			if($db == 'sf'){
				$DB1 = $this->load->database('sfumsdb', TRUE);
				$database_tbl = 'sandipun_erp_sf.user_master';
			}elseif($db == 'sijoul'){
				$DB1 = $this->load->database('sjumsdb', TRUE);
				$database_tbl = 'sandipun_erp_sijoul.user_master';
			}else{
				$DB1 = $this->load->database('umsdb', TRUE);
				$database_tbl = 'sandipun_erp.user_master';
			}

                $data = [
                    'faculty_code' => $faculty_code,
                    'faculty' => $faculty,
                    'date' => $date,
                    'academic_year' => $academic_year,
                    'academic_session' => $academic_session,
                    'today_ducks' => $total_ducks,
					 'school_id' => $school_id,
                    'details' => json_encode($details) // Store additional details as JSON
                ];
        
                $DB1->insert('duck_report', $data);
				//echo $DB1->last_query();echo '<br>';
				
                return $DB1->insert_id(); // Return the last inserted ID
            }
			public function insertVapDuckReport_new($faculty_code, $faculty, $date, $academic_year, $academic_session, $total_ducks, $details,$school_id) {
                $DB1 = $this->load->database('umsdb', TRUE);
                $data = [
                    'faculty_code' => $faculty_code,
                    'faculty' => $faculty,
                    'date' => $date,
                    'academic_year' => $academic_year,
                    'academic_session' => $academic_session,
                    'today_ducks' => $total_ducks,
					 'school_id' => $school_id,
                    'details' => json_encode($details) // Store additional details as JSON
                ];
        
                $DB1->insert('vap_attendance_report', $data);
				//echo $DB1->last_query();echo '<br>';
				
                return $DB1->insert_id(); // Return the last inserted ID
            }
	public function getCumulativeDucksSubjects($faculty_code, $date, $academic_year, $academic_session,$db)
    {
        if($db == 'sf'){
				$DB1 = $this->load->database('sfumsdb', TRUE);
				$database_tbl = 'sandipun_erp_sf.user_master';
			}elseif($db == 'sijoul'){
				$DB1 = $this->load->database('sjumsdb', TRUE);
				$database_tbl = 'sandipun_erp_sijoul.user_master';
			}else{
				$DB1 = $this->load->database('umsdb', TRUE);
				$database_tbl = 'sandipun_erp.user_master';
			}
        $start_date = date('Y-m-01', strtotime($date)); // Get first date of the month

        // Fetch all records within the given range
        $DB1->select('details');
        $DB1->from('duck_report');
        $DB1->where('faculty_code', $faculty_code);
        $DB1->where('academic_year', $academic_year);
        $DB1->where('academic_session', $academic_session);
        $DB1->where('date >=', $start_date);
        $DB1->where('date <=', $date);
        $query = $DB1->get();

        $result = $query->result_array();
        $data_counts = []; // Array to store counts excluding subject and subcod

        foreach ($result as $row) {
            $details = json_decode($row['details'], true); // Convert JSON to an array

            if (!empty($details)) {
                foreach ($details as $lecture) {
                    if ($lecture['today'] == 1) { // Only count if today is 1

                        // Remove 'subject' and 'subcod' keys, keep all other parameters
                        // unset($lecture['subject']);
                        // unset($lecture['subcod']);

                        // Create a unique key based on remaining details
                        $key = json_encode($lecture); // Convert array to JSON string to use as key

                        if (!isset($data_counts[$key])) {
                            $data_counts[$key] = 0;
                        }

                        // Count occurrences where today = 1
                        $data_counts[$key] += 1;
                    }
                }
            }
        }

        //   echo '<pre>';
        //   print_r($data_counts);
        return $data_counts; // Return associative array with subject-wise counts
    }
	public function getCumulativeVapDucksSubjects($faculty_code, $date, $academic_year, $academic_session)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $start_date = date('Y-m-01', strtotime($date)); // Get first date of the month

        // Fetch all records within the given range
        $DB1->select('details');
        $DB1->from('vap_attendance_report');
        $DB1->where('faculty_code', $faculty_code);
        $DB1->where('academic_year', $academic_year);
        $DB1->where('academic_session', $academic_session);
        $DB1->where('date >=', $start_date);
        $DB1->where('date <=', $date);
        $query = $DB1->get();

        $result = $query->result_array();
        $data_counts = []; // Array to store counts excluding subject and subcod

        foreach ($result as $row) {
            $details = json_decode($row['details'], true); // Convert JSON to an array

            if (!empty($details)) {
                foreach ($details as $lecture) {
                    if ($lecture['today'] == 1) { // Only count if today is 1

                        // Remove 'subject' and 'subcod' keys, keep all other parameters
                        // unset($lecture['subject']);
                        // unset($lecture['subcod']);

                        // Create a unique key based on remaining details
                        $key = json_encode($lecture); // Convert array to JSON string to use as key

                        if (!isset($data_counts[$key])) {
                            $data_counts[$key] = 0;
                        }

                        // Count occurrences where today = 1
                        $data_counts[$key] += 1;
                    }
                }
            }
        }

        //   echo '<pre>';
        //   print_r($data_counts);
        return $data_counts; // Return associative array with subject-wise counts
    }
	public function getFacultyTotalHours($faculty_code, $academic_year, $academic_session,$db='')
    {
        if($db == 'sf'){
				$DB1 = $this->load->database('sfumsdb', TRUE);
				$database_tbl = 'sandipun_erp_sf.user_master';
			}elseif($db == 'sijoul'){
				$DB1 = $this->load->database('sjumsdb', TRUE);
				$database_tbl = 'sandipun_erp_sijoul.user_master';
			}else{
				$DB1 = $this->load->database('umsdb', TRUE);
				$database_tbl = 'sandipun_erp.user_master';
			}
    
        $DB1->select('ltt.subject_type, COUNT(DISTINCT CONCAT(ltt.division, "-", ltt.lecture_slot, "-", ltt.wday, "-" )) AS total_hours');
        $DB1->from('lecture_time_table ltt');
        $DB1->where('ltt.faculty_code', $faculty_code);
        $DB1->where('ltt.academic_year', $academic_year);
        $DB1->where('ltt.academic_session', $academic_session);
        $DB1->where_in('ltt.subject_type', ['TH', 'PR']); // ✅ Fetch both TH & PR
        $DB1->group_by('ltt.subject_type');
        $query = $DB1->get();
       // echo $DB1->last_query();exit;
        $result = $query->result_array();
    
        $total_hours = ['TH' => 0, 'PR' => 0]; // Initialize TH & PR hours
    
        foreach ($result as $row) {
            if ($row['subject_type'] == 'TH') {
                $total_hours['TH'] = $row['total_hours'];
            } elseif ($row['subject_type'] == 'PR') {
                $total_hours['PR'] = $row['total_hours'];
            }
        }

       // print_r($total_hours); exit;
    
        return $total_hours;
    }
	public function getFacultyTotalHours_old($faculty_code, $academic_year, $academic_session, $db = '')
{
    if ($db == 'sf') {
        $DB1 = $this->load->database('sfumsdb', TRUE);
    } elseif ($db == 'sijoul') {
        $DB1 = $this->load->database('sjumsdb', TRUE);
    } else {
        $DB1 = $this->load->database('umsdb', TRUE);
    }

    $DB1->select("
        ltt.subject_type, 
        SUM(ls.duration) AS total_hours
    ", FALSE);
    $DB1->from('lecture_time_table ltt');
    $DB1->join('lecture_slot ls', 'ls.lect_slot_id = ltt.lecture_slot');
    $DB1->where('ltt.faculty_code', $faculty_code);
    $DB1->where('ltt.academic_year', $academic_year);
    $DB1->where('ltt.academic_session', $academic_session);
    $DB1->where('ltt.is_active', 'Y');
    $DB1->where_in('ltt.subject_type', ['TH', 'PR']); 
    $DB1->group_by('ltt.subject_type');

    $query = $DB1->get();
    if (!$query) {
        log_message('error', 'DB Error: ' . print_r($DB1->error(), true));
        echo $DB1->last_query();exit;log_message('error', 'Last Query: ' . $DB1->last_query());exit;
        return ['TH' => 0, 'PR' => 0];
    }

    $result = $query->result_array();

    $total_hours = ['TH' => 0, 'PR' => 0]; 
    foreach ($result as $row) {
        if ($row['subject_type'] == 'TH') {
            $total_hours['TH'] = $row['total_hours'];
        } elseif ($row['subject_type'] == 'PR') {
            $total_hours['PR'] = $row['total_hours'];
        }
    }

    return $total_hours;
}



//////////////////////Faculty Monthly load report///////////

/* public function getFacultyReport($from_date, $to_date) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $academic_year = ACADEMIC_YEAR;
        $academic_session = CURRENT_SESS;
        $faculty_report = [];
        $previous_month_start = date("Y-m-01", strtotime("-1 month", strtotime($from_date)));
        $previous_month_end = date("Y-m-t", strtotime("-1 month", strtotime($from_date)));
    // **Step 1: Count Weekdays Between From & To Date (Excluding Holidays)**
    $weekday_count = $this->countWeekdaysBetweenDates($from_date, $to_date, $academic_year);
    $previous_weekday_count = $this->countWeekdaysBetweenDates($previous_month_start, $previous_month_end, $academic_year);

    // **Step 2: Get Faculty Load (Total TH & PR)**
    $sql = "
        SELECT
            ltt.`faculty_code`,
            ltt.`subject_type`,
            ltt.`wday`,
            COUNT(DISTINCT CONCAT(ltt.division, '-', ltt.`lecture_slot`, '')) AS weekly_load
        FROM
            `lecture_time_table` ltt
        WHERE
            ltt.`academic_year` = '{$academic_year}'
            AND ltt.`academic_session` = '{$academic_session}'
            AND ltt.`faculty_code` != ''
        GROUP BY
            ltt.`faculty_code`, ltt.`subject_type`, ltt.`wday`
    ";

    $query1 = $DB1->query($sql);
    // echo $DB1->last_query();exit;
    $faculty_load = $query1->result_array();


    foreach ($faculty_load as $row) {
        $faculty_code = $row['faculty_code'];
        $type = $row['subject_type'];
        $wday = $row['wday']; // Monday, Tuesday, etc.
        $weekly_count = $row['weekly_load'];

        $sql = "
        SELECT
            ltt.`faculty_code`,
            COUNT(DISTINCT CONCAT(ltt.division, '-', ltt.`lecture_slot`, '')) AS weekly_load_alt
        FROM
            `alternet_lecture_time_table` ltt
        WHERE
            ltt.`academic_year` = '{$academic_year}'
            AND ltt.`academic_session` = '{$academic_session}'
            AND ltt.`faculty_code` = '{$faculty_code}'
            AND dt_date BETWEEN '{$from_date}' AND '{$to_date}'
        GROUP BY
            ltt.`faculty_code`
        ";

        $qry = $DB1->query($sql);
        // echo $DB1->last_query();exit;
        $faculty_load = $qry->row_array();

        $additional_weekly_count = $faculty_load['weekly_load_alt'];

        // Multiply weekly load by occurrences of that weekday in date range (Excluding Holidays)
        $actual_load = $weekly_count * ($weekday_count[$wday] ?? 0);
        $actual_last_month = $weekly_count * ($previous_weekday_count[$wday] ?? 0);
      //  $additional_load = $additional_weekly_count * ($weekday_count[$wday] ?? 0); 

        if (!isset($faculty_report[$faculty_code])) {
            $faculty_report[$faculty_code] = [
                'faculty_code' => $faculty_code,
                'total_TH_load' => 0,
                'total_PR_load' => 0,
                'TH_taken' => 0,
                'PR_taken' => 0,
                'TH_attendance_percentage' => 0,
                'PR_attendance_percentage' => 0,
                'prev_total_TH_load' => 0,
                'prev_total_PR_load' => 0,
                'prev_TH_taken' => 0,
                'prev_PR_taken' => 0,
                'prev_TH_percentage' => 0,
                'prev_PR_percentage' => 0,
                'prev_TH_attendance_percentage' => 0,
                'prev_PR_attendance_percentage' => 0,
                'designation' => '',
                'faculty_name' => '',
                'school' => '',
                'department' => '',
                'month_OD' => 0,
                'cumm_OD' => 0,
                'month_leave' => 0,
                'cumm_leave' => 0,
                'additional_load_taken' => 0,
                'additional_load_student_attendance_avg' => 0
            ];
        }

        if ($type == 'TH') {
            $faculty_report[$faculty_code]['total_TH_load'] += $actual_load;
            $faculty_report[$faculty_code]['prev_total_TH_load'] += $actual_last_month;

        } elseif ($type == 'PR') {
            $faculty_report[$faculty_code]['total_PR_load'] += $actual_load;
            $faculty_report[$faculty_code]['prev_total_PR_load'] += $actual_last_month;
        }

        // **Store additional load from alternet_lecture_time_table**
        $faculty_report[$faculty_code]['additional_load_taken'] = $additional_weekly_count ?? 0;
    }
    //  print_r($faculty_report);echo'<br>';exit;
    // **Step 3: Get Faculty Attendance (TH & PR Taken)**
    $sql = "
        SELECT
            la.faculty_code,
            la.subtype,
            COUNT(DISTINCT CONCAT(la.division, '-', la.slot, '-', la.attendance_date, '')) AS total_taken,
            COUNT(DISTINCT la.student_id,
            '-',
            la.slot,
            '-',
            la.attendance_date,
            '-',
            la.subject_id,
            '-',
            la.division,
            '') AS total_students,
            COUNT(DISTINCT CASE WHEN la.is_present = 'Y' THEN CONCAT(
                la.student_id, '-',
                la.slot, '-',
                la.attendance_date, '-',
                la.subject_id, '-',
                la.division
            ) END) AS present_students
        FROM lecture_attendance la
        LEFT JOIN alternet_lecture_time_table alt
            ON la.faculty_code = alt.faculty_code
            AND la.slot = alt.lecture_slot
            AND la.division = alt.division
            AND la.attendance_date = alt.dt_date
        WHERE la.academic_year = '$academic_year' 
        AND la.academic_session = '$academic_session' 
        AND la.attendance_date BETWEEN '$from_date' AND '$to_date'
        AND alt.faculty_code IS NULL
        GROUP BY la.faculty_code, la.subtype;
    ";

$query2 = $DB1->query($sql);
 //   echo $DB1->last_query();exit;
    $faculty_attendance = $query2->result_array();

    foreach ($faculty_attendance as $row) {
        $faculty_code = $row['faculty_code'];
        $type = $row['subtype'];

        if (isset($faculty_report[$faculty_code])) {
            if ($type == 'TH') {
                $faculty_report[$faculty_code]['TH_taken'] = $row['total_taken'];
                $faculty_report[$faculty_code]['TH_total_students'] = $row['total_students'];
                $faculty_report[$faculty_code]['TH_present_students'] = $row['present_students'];

                // **Calculate Attendance Percentage**
                $faculty_report[$faculty_code]['TH_attendance_percentage'] = 
                    ($row['total_students'] > 0) 
                    ? round(($row['present_students'] / $row['total_students']) * 100, 2) 
                    : 0;
            } elseif ($type == 'PR') {
                $faculty_report[$faculty_code]['PR_taken'] = $row['total_taken'];
                $faculty_report[$faculty_code]['PR_total_students'] = $row['total_students'];
                $faculty_report[$faculty_code]['PR_present_students'] = $row['present_students'];

                // **Calculate Attendance Percentage**
                $faculty_report[$faculty_code]['PR_attendance_percentage'] = 
                    ($row['total_students'] > 0) 
                    ? round(($row['present_students'] / $row['total_students']) * 100, 2) 
                    : 0;
            }
        }
    }
   // **Step 4: Get Attendance for Additional Load**
    $sql = "
    SELECT 
        la.faculty_code, 
        COUNT(DISTINCT la.student_id,
            '-',
            la.slot,
            '-',
            la.attendance_date,
            '-',
            la.subject_id,
            '-',
            la.division,
            '') AS total_students,
            COUNT(DISTINCT CASE WHEN la.is_present = 'Y' THEN CONCAT(
                la.student_id, '-',
                la.slot, '-',
                la.attendance_date, '-',
                la.subject_id, '-',
                la.division
            ) END) AS present_students
    FROM lecture_attendance la
    INNER JOIN alternet_lecture_time_table alt
        ON la.faculty_code = alt.faculty_code
        AND la.slot = alt.lecture_slot
        AND la.division = alt.division
        AND la.attendance_date = alt.dt_date
        AND la.subject_id = alt.subject_code
        AND la.stream_id = alt.stream_id
        AND la.semester = alt.semester
    WHERE la.academic_year = '$academic_year' 
    AND la.academic_session = '$academic_session' 
    AND la.attendance_date BETWEEN '$from_date' AND '$to_date'
    GROUP BY la.faculty_code;
    ";

    $query3 = $DB1->query($sql);
   // echo $DB1->last_query();exit;
    $additional_attendance = $query3->result_array();

    foreach ($additional_attendance as $row) {
    $faculty_code = $row['faculty_code'];

    if (isset($faculty_report[$faculty_code])) {
        $faculty_report[$faculty_code]['additional_load_student_attendance_avg'] = 
            ($row['total_students'] > 0) 
            ? round(($row['present_students'] / $row['total_students']) * 100, 2) 
            : 0;
    }
    }

    // **Step 5: Calculate Previous Month Attendance (Excluding Holidays)**



    $DB1->select("
        faculty_code, 
        subtype, 
        COUNT(DISTINCT CONCAT(division, '-', slot, '-', attendance_date, '')) AS total_taken,
        COUNT(DISTINCT student_id) AS total_students, 
        COUNT(DISTINCT CASE WHEN is_present = 'Y' THEN student_id END) AS present_students
    ");
    $DB1->from('lecture_attendance');
    $DB1->where('academic_year', $academic_year);
    $DB1->where('academic_session', $academic_session);
    $DB1->where("attendance_date >=", $previous_month_start);
    $DB1->where("attendance_date <=", $previous_month_end);
    $DB1->group_by('faculty_code, subtype');
    $query4 = $DB1->get();
    $previous_attendance = $query4->result_array();

    foreach ($previous_attendance as $row) {
        $faculty_code = $row['faculty_code'];
        $type = $row['subtype'];

        if (isset($faculty_report[$faculty_code])) {
            if ($type == 'TH') {
                $faculty_report[$faculty_code]['prev_TH_taken'] = $row['total_taken'];
                $faculty_report[$faculty_code]['TH_total_students'] = $row['total_students'];
                $faculty_report[$faculty_code]['TH_present_students'] = $row['present_students'];

                // **Calculate Attendance Percentage**
                $faculty_report[$faculty_code]['prev_TH_attendance_percentage'] = 
                    ($row['total_students'] > 0) 
                    ? round(($row['present_students'] / $row['total_students']) * 100, 2) 
                    : 0;
            } elseif ($type == 'PR') {
                $faculty_report[$faculty_code]['prev_TH_taken'] = $row['total_taken'];
                $faculty_report[$faculty_code]['PR_total_students'] = $row['total_students'];
                $faculty_report[$faculty_code]['PR_present_students'] = $row['present_students'];

                // **Calculate Attendance Percentage**
                $faculty_report[$faculty_code]['prev_PR_attendance_percentage'] = 
                    ($row['total_students'] > 0) 
                    ? round(($row['present_students'] / $row['total_students']) * 100, 2) 
                    : 0;
            }
        }
    }

        //  echo '<pre>';
        //  print_r($faculty_report[110048]); 
        //  echo ' ';
        //  echo $faculty_report[$faculty_code]['prev_PR_percentage'];exit;

        // **Step 6: Get OD (Official Duty) Count** `e`.`emp_id` AS `faculty_code`, SUM(`l`.`no_days`) AS `cumm_OD`
        $this->db->select("e.emp_id AS faculty_code,  SUM(`l`.`no_days`) AS month_OD");
        $this->db->from("leave_applicant_list l");
        $this->db->join("employee_master e", "l.emp_id = e.emp_id");
        $this->db->join("college_master c", "e.emp_school = c.college_id", "left");
        $this->db->where("leave_type", "OD");
        $this->db->where_not_in("l.fstatus", ["Cancel", "Rejected"]);
        $this->db->where("c.college_name !=", "General");
        $this->db->where("l.applied_from_date <=", $to_date);
        $this->db->where("l.applied_to_date >=", $from_date);
        $this->db->group_by("e.emp_id");
        $query5 = $this->db->get();
        // echo $this->db->last_query();exit;
        $faculty_od = $query5->result_array();

        foreach ($faculty_od as $row) {
            $faculty_code = $row['faculty_code'];
            if (isset($faculty_report[$faculty_code])) {
                $faculty_report[$faculty_code]['month_OD'] = $row['month_OD'];
            }
        }

        // **Step 7: Get Cumm OD (Official Duty) Count**
        $this->db->select("`e`.`emp_id` AS `faculty_code`, SUM(`l`.`no_days`) AS `cumm_OD`");
        $this->db->from("leave_applicant_list l");
        $this->db->join("employee_master e", "l.emp_id = e.emp_id");
        $this->db->join("college_master c", "e.emp_school = c.college_id", "left");
        $this->db->where("leave_type", "OD");
        $this->db->where_not_in("l.fstatus", ["Cancel", "Rejected"]);
        $this->db->where("c.college_name !=", "General");
        $this->db->where("l.applied_from_date <=", $to_date);
        $this->db->where("l.applied_to_date >=", '2025-01-15');
        $this->db->group_by("e.emp_id");
        $query6 = $this->db->get();
    //  echo $this->db->last_query();exit;
        $faculty_od = $query6->result_array();

        foreach ($faculty_od as $row) {
            $faculty_code = $row['faculty_code'];
            if (isset($faculty_report[$faculty_code])) {
                $faculty_report[$faculty_code]['cumm_OD'] = $row['cumm_OD'];
            }
        }

        // **Step 8: Get Faculty Leave Counts (Monthly & Cumulative)**
        $this->db->select("e.emp_id AS faculty_code,
            SUM(
                CASE 
                    WHEN (CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END) >='2025-01-15' 
                    THEN 
                        DATEDIFF(
                            LEAST(
                                CASE 
                                    WHEN (CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END) > '$to_date' 
                                    THEN '$to_date' 
                                    ELSE (CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END)
                                END, 
                                '$to_date'
                            ), 
                            (CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END)
                        ) + 1
                    ELSE 0 
                END
            ) AS cumm_leave,

            SUM(
                CASE 
                    WHEN YEAR((CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END)) = YEAR('$to_date') 
                    AND MONTH((CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END)) = MONTH('$to_date') 
                    THEN 
                        DATEDIFF(LEAST(
                            CASE 
                                WHEN (CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END) > '$to_date' 
                                THEN '$to_date' 
                                ELSE (CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END)
                            END, 
                            '$to_date'
                        ), 
                        GREATEST((CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END), '$from_date')) + 1
                    ELSE 0 
                END
            ) AS month_leave
        ");
        $this->db->from("leave_applicant_list l");
        $this->db->join("employee_master e", "l.emp_id = e.emp_id", "left");
        $this->db->join("college_master c", "e.emp_school = c.college_id", "left");
        // $this->db->where("leave_type IN (SELECT id FROM employee_leave_allocation WHERE academic_year = '2024-25')");
        $this->db->where("leave_type IN (SELECT id FROM employee_leave_allocation WHERE academic_year = '".$academic_year."')", NULL, FALSE);

        $this->db->where_not_in("l.fstatus", ["Cancel", "Rejected"]);
        $this->db->where("l.applied_from_date <=", $to_date);
        $this->db->where("c.college_name !=", "General");
        $this->db->group_by("e.emp_id");
        $query7 = $this->db->get();
     //  echo '<pre>'; 
     //  echo $this->db->last_query();exit;
        $faculty_leave = $query7->result_array();

        foreach ($faculty_leave as $row) {
            $faculty_code = $row['faculty_code'];
            if (isset($faculty_report[$faculty_code])) {
                $faculty_report[$faculty_code]['cumm_leave'] = $row['cumm_leave'];
                $faculty_report[$faculty_code]['month_leave'] = $row['month_leave'];
            }
        }

        // **Step 9: Calculate Percentages & Fetch Faculty Details**
        foreach ($faculty_report as &$faculty) {
            $faculty['TH_percentage'] = ($faculty['total_TH_load'] > 0) ? round(($faculty['TH_taken'] / $faculty['total_TH_load']) * 100, 2) : 0;
            $faculty['PR_percentage'] = ($faculty['total_PR_load'] > 0) ? round(($faculty['PR_taken'] / $faculty['total_PR_load']) * 100, 2) : 0;
            $faculty['prev_TH_percentage'] = ($faculty['total_TH_load'] > 0) ? round(($faculty['prev_TH_taken'] / $faculty['prev_total_TH_load']) * 100, 2) : 0;
            $faculty['prev_PR_percentage'] = ($faculty['total_PR_load'] > 0) ? round(($faculty['prev_PR_taken'] / $faculty['prev_total_PR_load']) * 100, 2) : 0;

            // Fetch faculty details (name & designation)
            $DB1->select("fname, mname, lname, designation_name as designation,college_code as school_code,department_name");
            $DB1->from("vw_faculty");
            $DB1->where("emp_id", $faculty['faculty_code']);
            $faculty_data = $DB1->get()->row_array();
    
            if ($faculty_data) {
                $faculty['faculty_name'] = $faculty_data['fname'] . ' ' . $faculty_data['mname'] . ' ' . $faculty_data['lname'];
                $faculty['designation'] = $faculty_data['designation'];
                $faculty['school'] = $faculty_data['school_code'];
                $faculty['department'] = $faculty_data['department_name'];
            }
        }
    
        return $faculty_report;
    }
	
	private function getHolidaysBetweenDates($start_date, $end_date, $academic_year) {
        $this->db->select("hdate");
        $this->db->from("holiday_list_master");
        $this->db->where("academic_year", $academic_year);
        $this->db->where("hdate >=", $start_date);
        $this->db->where("hdate <=", $end_date);
        $query = $this->db->get();
        
        $holidays = [];
        foreach ($query->result_array() as $row) {
            $holidays[] = $row['hdate'];
        }
        
        return $holidays;
    }

    private function countWeekdaysBetweenDates($start_date, $end_date,  $academic_year) {
        $weekdays = [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0
        ];
    
        // **Fetch Holidays from holiday_list_master Table**
        $this->db->select("hdate, hday");
        $this->db->from("holiday_list_master");
        $this->db->where("academic_year", $academic_year);
        $this->db->where("hdate >=", $start_date);
        $this->db->where("hdate <=", $end_date);
        $query = $this->db->get();
        $holidays = $query->result_array();
        
        $holiday_dates = array_column($holidays, 'hdate');
    
        $current_date = strtotime($start_date);
        $end_date = strtotime($end_date);
    
        while ($current_date <= $end_date) {
            $day_name = date('l', $current_date);
            $formatted_date = date('Y-m-d', $current_date);
    
            // **Exclude Holidays**
            if (!in_array($formatted_date, $holiday_dates)) {
                $weekdays[$day_name]++; // Count occurrences
            }
    
            $current_date = strtotime("+1 day", $current_date);
        }
    
        return $weekdays;
    }
 */

public function getFacultyReport($from_date, $to_date)
{
	//$from_date = "2025-04-01";
	//$to_date = "2025-04-30";

    $DB1 = $this->load->database('umsdb', TRUE);
    $academic_year = '2025-26';
    $academic_session = 'WIN';
    $faculty_report = [];
    $previous_month_start = date("Y-m-01", strtotime("-1 month", strtotime($from_date)));
    $previous_month_end = date("Y-m-t", strtotime("-1 month", strtotime($from_date)));
    // **Step 1: Count Weekdays Between From & To Date (Excluding Holidays)**
     $weekday_count = $this->countWeekdaysBetweenDates($from_date, $to_date, $academic_year);
	 
    $previous_weekday_count = $this->countWeekdaysBetweenDates($previous_month_start, $previous_month_end, $academic_year);

    // **Step 2: Get Faculty Load (Total TH & PR)**
    $sql = "
    SELECT
        ltt.`faculty_code`,
        ltt.`subject_type`,
        ltt.`wday`,
        COUNT( DISTINCT ltt.lecture_slot ) AS weekly_load
    FROM
        `lecture_time_table` ltt
    WHERE
        ltt.`academic_year` = '{$academic_year}' 
        AND ltt.`academic_session` = '{$academic_session}'
        AND ltt.`faculty_code` != ''   
    GROUP BY
        ltt.`faculty_code`, ltt.`subject_type`, ltt.`wday`
";
// AND ltt.`faculty_code` = '110415' 
    $query1 = $DB1->query($sql);
    // echo $DB1->last_query();exit;
    $faculty_load = $query1->result_array();
	$additional_weekly_count =0;
    $loadArr = array();
    foreach ($faculty_load as $row) {
		 
        $faculty_code = $row['faculty_code'];
        $type = $row['subject_type'];
        $wday = $row['wday']; // Monday, Tuesday, etc.
        $weekly_count = $row['weekly_load'];

        $sql = "
		SELECT
			ltt.`faculty_code`,
			COUNT( DISTINCT ltt.lecture_slot ) AS weekly_load_alt
		FROM
			`alternet_lecture_time_table` ltt
		WHERE
			ltt.`academic_year` = '{$academic_year}' 
			AND ltt.`academic_session` = '{$academic_session}'
			AND ltt.`faculty_code` = '{$faculty_code}'
		   AND ltt.faculty_code != ''  AND ltt.faculty_code is not NULL
			AND dt_date BETWEEN '{$from_date}' AND '{$to_date}'  
		GROUP BY
			ltt.`faculty_code`
		";

        $qry = $DB1->query($sql);
         
        $faculty_load = $qry->row_array();
		
		//if(!empty($faculty_load)){
		//echo '<pre>';
		//print_r($faculty_load);die;
		//}else{
		//  echo 'something wrong';  
		//}
		

        $additional_weekly_count = $faculty_load['weekly_load_alt'] ? $faculty_load['weekly_load_alt'] : 0;

    //    print_r($weekday_count);exit;
        // Multiply weekly load by occurrences of that weekday in date range (Excluding Holidays)
		
         $actual_load = $weekly_count * ($weekday_count[$wday] ? $weekday_count[$wday] : 0);
         $actual_last_month = $weekly_count * ($previous_weekday_count[$wday] ? $previous_weekday_count[$wday]:0);
	   
	  
          // $additional_load = $additional_weekly_count * ($weekday_count[$wday] ? $weekday_count[$wday] : 0); 

        if (!isset($faculty_report[$faculty_code])) {
            $faculty_report[$faculty_code] = [
                'faculty_code' => $faculty_code,
                'total_TH_load' => 0,
                'total_PR_load' => 0,
                'TH_taken' => 0,
                'PR_taken' => 0,
                'TH_attendance_percentage' => 0,
                'PR_attendance_percentage' => 0,
                'prev_total_TH_load' => 0,
                'prev_total_PR_load' => 0,
                'prev_TH_taken' => 0,
                'prev_PR_taken' => 0,
                'prev_TH_percentage' => 0,
                'prev_PR_percentage' => 0,
                'prev_TH_attendance_percentage' => 0,
                'prev_PR_attendance_percentage' => 0,
                'designation' => '',
                'faculty_name' => '',
                'school' => '',
                'department' => '',
                'month_OD' => 0,
                'cumm_OD' => 0,
                'month_leave' => 0,
                'cumm_leave' => 0,
                'additional_load_taken' => 0,
                'additional_load_student_attendance_avg' => 0
            ];
        }
		

        if ($type == 'TH') {
            $faculty_report[$faculty_code]['total_TH_load'] += $actual_load;
            $faculty_report[$faculty_code]['prev_total_TH_load'] += $actual_last_month;

        } elseif ($type == 'PR') {
            $faculty_report[$faculty_code]['total_PR_load'] += $actual_load;
            $faculty_report[$faculty_code]['prev_total_PR_load'] += $actual_last_month;
        }

        // **Store additional load from alternet_lecture_time_table**
        $faculty_report[$faculty_code]['additional_load_taken'] = $additional_weekly_count ? $additional_weekly_count : 0;
    }

    // **Step 3: Get Faculty Attendance (TH & PR Taken)**
 
			 $sql="SELECT 
				la.faculty_code, 
				la.subtype, 
				
				COUNT(DISTINCT CONCAT(la.slot, '-', la.attendance_date)) AS total_taken,
				
				COUNT(DISTINCT CASE 
					WHEN ltt.faculty_code IS NULL THEN CONCAT(la.slot, '-', la.attendance_date)
				END) AS unscheduled_lectures,
				
				COUNT(DISTINCT CASE 
					WHEN ltt.faculty_code IS NOT NULL THEN CONCAT(la.slot, '-', la.attendance_date)
				END) AS scheduled_lectures,
				
				COUNT(DISTINCT CASE 
					WHEN ltt.faculty_code IS NULL THEN CONCAT(la.student_id, '-', la.slot, '-', la.attendance_date, '-', la.subject_id)
				END) AS total_students_unscheduled,
				
				COUNT(DISTINCT CASE 
					WHEN ltt.faculty_code IS NULL AND la.is_present = 'Y' THEN CONCAT(la.student_id, '-', la.slot, '-', la.attendance_date, '-', la.subject_id)
				END) AS present_students_unscheduled,
				
				COUNT(DISTINCT CASE 
					WHEN ltt.faculty_code IS NOT NULL THEN CONCAT(la.student_id, '-', la.slot, '-', la.attendance_date, '-', la.subject_id)
				END) AS total_students_scheduled,
				
				COUNT(DISTINCT CASE 
					WHEN ltt.faculty_code IS NOT NULL AND la.is_present = 'Y' THEN CONCAT(la.student_id, '-', la.slot, '-', la.attendance_date, '-', la.subject_id)
				END) AS present_students_scheduled

			FROM (
   SELECT is_present,faculty_code, subtype,attendance_date,slot,subject_id,student_id,academic_session,academic_year FROM lecture_attendance WHERE attendance_date >='$from_date' and
 attendance_date <='$to_date'  AND subtype IS NOT NULL and subtype!='' 
 ) la

			LEFT JOIN lecture_time_table ltt 
				ON la.faculty_code = ltt.faculty_code 
				AND la.slot = ltt.lecture_slot 
				AND DAYNAME(la.attendance_date) = CONVERT(ltt.wday USING utf8) COLLATE utf8_general_ci 
				AND la.subtype = ltt.subject_type  AND la.academic_session = ltt.academic_session AND la.academic_year = ltt.academic_year                   
            
			LEFT JOIN alternet_lecture_time_table alt 
				ON la.faculty_code = alt.faculty_code 
				AND la.slot = alt.lecture_slot 
				AND la.attendance_date = alt.dt_date 
				AND la.subtype = alt.subject_type  AND la.academic_session = alt.academic_session AND la.academic_year =alt.academic_year

			WHERE 
				la.academic_year = '$academic_year' 
				AND la.academic_session = '$academic_session' 
				AND la.attendance_date BETWEEN '$from_date' AND '$to_date'
				AND alt.faculty_code IS NULL  

			GROUP BY 
				la.faculty_code, 
				la.subtype;";
				
    $query2 = $DB1->query($sql);
	//echo $sql;
	//exit;
     //echo $DB1->last_query();exit;
    $faculty_attendance = $query2->result_array();
     $testArr = [];
    foreach ($faculty_attendance as $row) {
        $faculty_code = $row['faculty_code'];
        $type = $row['subtype'];
        $si=$row['unscheduled_lectures'];
        if (isset($faculty_report[$faculty_code])) {
            if ($type == 'TH') {
                $faculty_report[$faculty_code]['TH_taken'] = $row['scheduled_lectures'];
                $faculty_report[$faculty_code]['TH_total_students'] = $row['total_students_scheduled'];
                $faculty_report[$faculty_code]['TH_present_students'] = $row['present_students_scheduled'];
                // **Calculate Attendance Percentage**                                                               
                $faculty_report[$faculty_code]['TH_attendance_percentage'] =
                    ($row['total_students_scheduled'] > 0)
                    ? round(($row['present_students_scheduled'] / $row['total_students_scheduled']) * 100, 2)
                    : 0;
            } elseif ($type == 'PR') {
                $faculty_report[$faculty_code]['PR_taken'] = $row['scheduled_lectures'];
                $faculty_report[$faculty_code]['PR_total_students'] = $row['total_students_scheduled'];
                $faculty_report[$faculty_code]['PR_present_students'] = $row['present_students_scheduled'];

                // **Calculate Attendance Percentage**
                $faculty_report[$faculty_code]['PR_attendance_percentage'] =
                    ($row['total_students_scheduled'] > 0)
                    ? round(($row['present_students_scheduled'] / $row['total_students_scheduled']) * 100, 2)
                    : 0;
            }
            $testArr[] = $faculty_report[$faculty_code]['additional_load_taken'] =  $faculty_report[$faculty_code]['additional_load_taken']+ $si ;

            $faculty_report[$faculty_code]['additional_load_student_attendance_avg'] =
            ($row['total_students_unscheduled'] > 0)
            ? round(($row['present_students_unscheduled'] / $row['total_students_unscheduled']) * 100, 2)
            : 0;
        }
    }
	//print_r($testArr); die;


    // **Step 4: Get Attendance for Additional Load**
    $sql = "
        SELECT 
            la.faculty_code, 
            COUNT(DISTINCT la.student_id,
                '-',
                la.slot,
                '-',
                la.attendance_date,
                '-',
                la.subject_id,
                '') AS total_students,
                COUNT(DISTINCT CASE WHEN la.is_present = 'Y' THEN CONCAT(
                    la.student_id, '-',
                    la.slot, '-',
                    la.attendance_date, '-',
                    la.subject_id
                ) END) AS present_students
        FROM (
   SELECT is_present,faculty_code, subtype,attendance_date,slot,subject_id,student_id,academic_session,academic_year,division,stream_id,semester FROM lecture_attendance WHERE attendance_date >='$from_date' and
 attendance_date <='$to_date'  AND subtype IS NOT NULL and subtype!=''
 )  la
        INNER JOIN alternet_lecture_time_table alt
            ON la.faculty_code = alt.faculty_code
            AND la.slot = alt.lecture_slot
            AND la.division = alt.division
            AND la.attendance_date = alt.dt_date
            AND la.subject_id = alt.subject_code
            AND la.stream_id = alt.stream_id
            AND la.semester = alt.semester  AND la.academic_session = alt.academic_session AND la.academic_year = alt.academic_year
        WHERE la.academic_year = '$academic_year' 
        AND la.academic_session = '$academic_session' 
        AND la.attendance_date BETWEEN '$from_date' AND '$to_date'
        GROUP BY la.faculty_code;
    ";

    $query3 = $DB1->query($sql);
    // echo $DB1->last_query();exit;
    $additional_attendance = $query3->result_array();

    foreach ($additional_attendance as $row) {
        $faculty_code = $row['faculty_code'];

        if (isset($faculty_report[$faculty_code])) {
            if($faculty_report[$faculty_code]['additional_load_student_attendance_avg'] == 0 ){
                $faculty_report[$faculty_code]['additional_load_student_attendance_avg'] =
                ($row['total_students'] > 0)
                ? round(($row['present_students'] / $row['total_students']) * 100, 2)
                : 0;
            }else{
                $faculty_report[$faculty_code]['additional_load_student_attendance_avg'] +=
                ($row['total_students'] > 0)
                ? round(($row['present_students'] / $row['total_students']) * 100, 2)
                : 0;

                $faculty_report[$faculty_code]['additional_load_student_attendance_avg'] = $faculty_report[$faculty_code]['additional_load_student_attendance_avg'] / 2;
            }

        }
    }

    // **Step 5: Calculate Previous Month Attendance (Excluding Holidays)**

    $sql = "
        SELECT
            la.faculty_code,
            la.subtype,
            
            COUNT(DISTINCT CONCAT(la.slot, '-', la.attendance_date)) AS total_taken,

            COUNT(DISTINCT CASE 
                WHEN ltt.faculty_code IS NULL THEN CONCAT(la.slot, '-', la.attendance_date)
            END) AS unscheduled_lectures,

            COUNT(DISTINCT CASE 
                WHEN ltt.faculty_code IS NOT NULL THEN CONCAT(la.slot, '-', la.attendance_date)
            END) AS scheduled_lectures,

            COUNT(DISTINCT CASE 
                WHEN ltt.faculty_code IS NULL THEN CONCAT(la.student_id, '-', la.slot, '-', la.attendance_date, '-', la.subject_id)
            END) AS total_students_unscheduled,

            COUNT(DISTINCT CASE 
                WHEN ltt.faculty_code IS NULL AND la.is_present = 'Y' THEN CONCAT(la.student_id, '-', la.slot, '-', la.attendance_date, '-', la.subject_id)
            END) AS present_students_unscheduled,

            COUNT(DISTINCT CASE 
                WHEN ltt.faculty_code IS NOT NULL THEN CONCAT(la.student_id, '-', la.slot, '-', la.attendance_date, '-', la.subject_id)
            END) AS total_students_scheduled,

            COUNT(DISTINCT CASE 
                WHEN ltt.faculty_code IS NOT NULL AND la.is_present = 'Y' THEN CONCAT(la.student_id, '-', la.slot, '-', la.attendance_date, '-', la.subject_id)
            END) AS present_students_scheduled

        FROM (
   SELECT is_present,faculty_code, subtype,attendance_date,slot,subject_id,student_id,academic_session,academic_year FROM lecture_attendance WHERE attendance_date >='$previous_month_start' and
 attendance_date <='$previous_month_end'  AND subtype IS NOT NULL and subtype!='' 
 ) la

        LEFT JOIN lecture_time_table ltt 
            ON la.faculty_code = ltt.faculty_code
            AND la.slot = ltt.lecture_slot
			AND DAYNAME(la.attendance_date) = CONVERT(ltt.wday USING utf8) COLLATE utf8_general_ci 
            AND la.subtype = ltt.subject_type
			 AND la.academic_session = ltt.academic_session AND la.academic_year = ltt.academic_year

        LEFT JOIN alternet_lecture_time_table alt
            ON la.faculty_code = alt.faculty_code
            AND la.slot = alt.lecture_slot
            AND la.attendance_date = alt.dt_date
            AND la.subtype = alt.subject_type

			 AND la.academic_session = alt.academic_session AND la.academic_year = alt.academic_year

        WHERE la.academic_year = '$academic_year' 
            AND la.academic_session = '$academic_session' 
            AND la.attendance_date BETWEEN '$previous_month_start' AND '$previous_month_end'
            AND alt.faculty_code IS NULL

        GROUP BY la.faculty_code, la.subtype;
    ";

    $queryPrev = $DB1->query($sql);
    $previous_attendance = $queryPrev->result_array();


    foreach ($previous_attendance as $row) {
        $faculty_code = $row['faculty_code'];
        $type = $row['subtype'];

        if (isset($faculty_report[$faculty_code])) {
            if ($type == 'TH') {
                $faculty_report[$faculty_code]['prev_TH_taken'] = $row['scheduled_lectures'];
                $faculty_report[$faculty_code]['prev_TH_total_students'] = $row['total_students_scheduled'];
                $faculty_report[$faculty_code]['prev_TH_present_students'] = $row['present_students_scheduled'];

                $faculty_report[$faculty_code]['prev_TH_attendance_percentage'] =
                    ($row['total_students_scheduled'] > 0)
                    ? round(($row['present_students_scheduled'] / $row['total_students_scheduled']) * 100, 2)
                    : 0;
            } elseif ($type == 'PR') {
                $faculty_report[$faculty_code]['prev_PR_taken'] = $row['scheduled_lectures'];
                $faculty_report[$faculty_code]['prev_PR_total_students'] = $row['total_students_scheduled'];
                $faculty_report[$faculty_code]['prev_PR_present_students'] = $row['present_students_scheduled'];

                $faculty_report[$faculty_code]['prev_PR_attendance_percentage'] =
                    ($row['total_students_scheduled'] > 0)
                    ? round(($row['present_students_scheduled'] / $row['total_students_scheduled']) * 100, 2)
                    : 0;
            }
        }
    }


    //  echo '<pre>';
    //  print_r($faculty_report[110048]); 
    //  echo ' ';
    //  echo $faculty_report[$faculty_code]['prev_PR_percentage'];exit;

    // **Step 6: Get OD (Official Duty) Count** `e`.`emp_id` AS `faculty_code`, SUM(`l`.`no_days`) AS `cumm_OD`
         $this->db->select("
            e.emp_id AS faculty_code, 
            SUM(
                DATEDIFF(
                    LEAST('$to_date', 
                        CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END
                    ),
                    GREATEST('$from_date', 
                            CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END
                    )
                ) + 1
            ) AS month_OD
        ");
        $this->db->from("leave_applicant_list l");
        $this->db->join("employee_master e", "l.emp_id = e.emp_id");
        $this->db->join("college_master c", "e.emp_school = c.college_id", "left");
        $this->db->where("leave_type", "OD");
        $this->db->where_not_in("l.fstatus", ["Cancel", "Rejected"]);
        $this->db->where("c.college_name !=", "General");
        $this->db->where("l.applied_from_date <=", $to_date);
        $this->db->where("l.applied_to_date >=", $from_date);
        $this->db->group_by("e.emp_id");
        $query5 = $this->db->get();
        $faculty_od = $query5->result_array();
        
        foreach ($faculty_od as $row) {
            $faculty_code = $row['faculty_code'];
            if (isset($faculty_report[$faculty_code])) {
                $faculty_report[$faculty_code]['month_OD'] = $row['month_OD'];
            }
        }
    
		// $faculty_report[$faculty_code]['month_OD'] = 0;
    // **Step 7: Get Cumm OD (Official Duty) Count**
    $this->db->select("
            e.emp_id AS faculty_code, 
            SUM(
                DATEDIFF(
                    LEAST('$to_date', 
                        CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END
                    ),
                    GREATEST('2025-01-15', 
                            CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END
                    )
                ) + 1
            ) AS cumm_OD
        ");
        $this->db->from("leave_applicant_list l");
        $this->db->join("employee_master e", "l.emp_id = e.emp_id");
        $this->db->join("college_master c", "e.emp_school = c.college_id", "left");
        $this->db->where("leave_type", "OD");
        $this->db->where_not_in("l.fstatus", ["Cancel", "Rejected"]);
        $this->db->where("c.college_name !=", "General");
        $this->db->where("l.applied_from_date <=", $to_date);
        $this->db->where("l.applied_to_date >=", '2025-01-15');
        $this->db->group_by("e.emp_id");
        $query6 = $this->db->get();
        $faculty_od = $query6->result_array();
        
        foreach ($faculty_od as $row) {
            $faculty_code = $row['faculty_code'];
            if (isset($faculty_report[$faculty_code])) {
                $faculty_report[$faculty_code]['cumm_OD'] = $row['cumm_OD'];
            }
        }

		//$faculty_report[$faculty_code]['cumm_OD'] =0;
    // **Step 8: Get Faculty Leave Counts (Monthly & Cumulative)**
 $sqll = "
        SELECT 
            e.emp_id AS faculty_code,
    
            SUM(
                CASE 
                    WHEN 
                        (CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END) <= '$to_date'
                        AND (CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END) >= '2025-01-15'
                    THEN 
                        ROUND((
                            DATEDIFF(
                                LEAST(
                                    (CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END),
                                    '$to_date'
                                ),
                                GREATEST(
                                    (CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END),
                                    '2025-01-15'
                                )
                            ) + 1
                        ) / 
                        (DATEDIFF(
                            (CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END),
                            (CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END)
                        ) + 1) * l.no_days, 1 )
                    ELSE 0 
                END
            ) AS cumm_leave,
    
            SUM(
                CASE 
                    WHEN 
                        (CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END) <= '$to_date'
                        AND (CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END) >= '$from_date'
                    THEN 
                        ROUND((
                            DATEDIFF(
                                LEAST(
                                    (CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END),
                                    '$to_date'
                                ),
                                GREATEST(
                                    (CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END),
                                    '$from_date'
                                )
                            ) + 1
                        ) / 
                        (DATEDIFF(
                            (CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END),
                            (CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END)
                        ) + 1) * l.no_days, 1 )
                    ELSE 0 
                END
            ) AS month_leave
    
        FROM leave_applicant_list l
        LEFT JOIN employee_master e ON l.emp_id = e.emp_id
        LEFT JOIN college_master c ON e.emp_school = c.college_id
    
        WHERE l.leave_type IN (
            SELECT id FROM employee_leave_allocation WHERE academic_year = '$academic_year'
        )
        AND l.fstatus NOT IN ('Cancel', 'Rejected')
        AND l.applied_from_date <= '$to_date'
        AND c.college_name != 'General'
    
        GROUP BY e.emp_id
    ";
    
    $query7 = $this->db->query($sqll); // ✅ FIXED
  //  echo $this->db->last_query(); exit;
    
    $faculty_leave = $query7->result_array();

        foreach ($faculty_leave as $row) {
            $faculty_code = $row['faculty_code'];
            if (isset($faculty_report[$faculty_code])) {
                $faculty_report[$faculty_code]['cumm_leave'] = $row['cumm_leave'];
                $faculty_report[$faculty_code]['month_leave'] = $row['month_leave'];
            }
        }
			// $faculty_report[$faculty_code]['cumm_leave'] = 0;
            // $faculty_report[$faculty_code]['month_leave'] = 0;
    // **Step 9: Calculate Percentages & Fetch Faculty Details**
    foreach ($faculty_report as &$faculty) {
        $faculty['TH_percentage'] = ($faculty['total_TH_load'] > 0) ? round(($faculty['TH_taken'] / $faculty['total_TH_load']) * 100, 2) : 0;
        $faculty['PR_percentage'] = ($faculty['total_PR_load'] > 0) ? round(($faculty['PR_taken'] / $faculty['total_PR_load']) * 100, 2) : 0;
        $faculty['prev_TH_percentage'] = ($faculty['total_TH_load'] > 0) ? round(($faculty['prev_TH_taken'] / $faculty['prev_total_TH_load']) * 100, 2) : 0;
        $faculty['prev_PR_percentage'] = ($faculty['total_PR_load'] > 0) ? round(($faculty['prev_PR_taken'] / $faculty['prev_total_PR_load']) * 100, 2) : 0;

        // Fetch faculty details (name & designation)
        $DB1->select("fname, mname, lname, designation_name as designation,college_code as school_code,department_name");
        $DB1->from("vw_faculty");
        $DB1->where("emp_id", $faculty['faculty_code']);
        $faculty_data = $DB1->get()->row_array();

        if ($faculty_data) {
            $faculty['faculty_name'] = $faculty_data['fname'] . ' ' . $faculty_data['mname'] . ' ' . $faculty_data['lname'];
            $faculty['designation'] = $faculty_data['designation'];
            $faculty['school'] = $faculty_data['school_code'];
            $faculty['department'] = $faculty_data['department_name'];
        }
    }
		
	  
	// echo "<pre>";   print_r($additional_weekly_count);exit;
    // echo "<pre>";   print_r($faculty_report);exit;

    return $faculty_report;
}


private function getHolidaysBetweenDates($start_date, $end_date, $academic_year)
{
    $this->db->select("hdate");
    $this->db->from("holiday_list_master");
    $this->db->where("academic_year", $academic_year);
    $this->db->where("hdate >=", $start_date);
    $this->db->where("hdate <=", $end_date);
    $query = $this->db->get();

    $holidays = [];
    foreach ($query->result_array() as $row) {
        $holidays[] = $row['hdate'];
    }

    return $holidays;
}

private function countWeekdaysBetweenDates($start_date, $end_date, $academic_year)
{
    $weekdays = [
        'Monday' => 0,
        'Tuesday' => 0,
        'Wednesday' => 0,
        'Thursday' => 0,
        'Friday' => 0,
        'Saturday' => 0,
        'Sunday' => 0
    ];

    // **Fetch Holidays from holiday_list_master Table**
    $this->db->select("hdate, hday");
    $this->db->from("holiday_list_master");
    $this->db->where("academic_year", $academic_year);
    $this->db->where("hdate >=", $start_date);
    $this->db->where("hdate <=", $end_date);
    $this->db->where("applicable_for NOT LIKE", 'IC-Staff-HO');
    $query = $this->db->get();
    $holidays = $query->result_array();

    $holiday_dates = array_column($holidays, 'hdate');

    $current_date = strtotime($start_date);
    $end_date = strtotime($end_date);

    while ($current_date <= $end_date) {
        $day_name = date('l', $current_date);
        $formatted_date = date('Y-m-d', $current_date);

        // **Exclude Holidays**
        if (!in_array($formatted_date, $holiday_dates)) {
            $weekdays[$day_name]++; // Count occurrences
        }

        $current_date = strtotime("+1 day", $current_date);
    }

    return $weekdays;
}

///////////////////////
}
