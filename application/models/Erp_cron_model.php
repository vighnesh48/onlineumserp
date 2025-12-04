<?php
class Erp_cron_model extends CI_Model 
{
    function __construct()
    {        
        parent::__construct();     
       // $this->currentModule=$this->uri->segment(1);        
    } 
    
    
    
   //to get session
    function getsession()
    {
         $DB1 = $this->load->database('umsdb', TRUE);
         $sql ="SELECT academic_year,academic_session FROM academic_session where currently_active='Y'";
         $query=$DB1->query($sql);
         $result=$query->result_array();
    
        return $result;
    }
	//to get all school details
     function getsschool_details()
    {
         
         $DB1 = $this->load->database('umsdb', TRUE);
         $sql ="SELECT school_code,school_name,school_short_name,umas.email,GROUP_CONCAT(stream_id) AS stream FROM vw_stream_details INNER JOIN  (SELECT roles_id,email, SUBSTRING(username,7) AS b FROM  user_master ) AS umas  ON umas.b=vw_stream_details.school_code WHERE umas.roles_id='10' GROUP BY school_code";
         $query=$DB1->query($sql);
         $result=$query->result_array();
        return $result;
    }

    function TimetableEntryReport($student_academicy,$acadyear,$get_session)
    {

            $DB1 = $this->load->database('umsdb', TRUE);
            $sql ="SELECT a.*,t.stream_id,t.semester,v.stream_name,v.school_code,
            (CASE WHEN t.stream_id=admission_stream THEN 'Done' ELSE 'Not done' END) AS entry_status 
            FROM (SELECT DISTINCT admission_stream,current_semester FROM student_master 
            WHERE `cancelled_admission`='N' AND academic_year='".$student_academicy."' and current_semester not in('4','6','8') and (admission_cycle  is null or admission_cycle='' ) ORDER BY admission_stream,current_semester) as a 
            LEFT JOIN (SELECT DISTINCT stream_id,semester FROM `lecture_time_table` WHERE `academic_year`='".$acadyear."' AND `academic_session`='".$get_session."' ) as t 
            ON t.`stream_id`=a.admission_stream
            AND t.semester=a.current_semester 
            LEFT JOIN vw_stream_details v ON v.stream_id=a.admission_stream 
            HAVING entry_status = 'Not done' ORDER BY v.stream_name,a.current_semester";
            $query=$DB1->query($sql);
            $result=$query->result_array();
            return $result;
    }
    /***get faccultynotassign *****/
    public function streamnotallocated_to_faculty($student_academicy,$acadyear,$get_session)
    {
         $DB2= $this->load->database('umsdb', TRUE);

        // / die;
    $sql=" SELECT sd.`school_code`,tt.subject_code,tt.time_table_id, tt.division,tt.batch_no,tt.course_id, sm.subject_type,tt.stream_id,tt.semester, sm.subject_name,sm.subject_code AS sub_code,
             sm.subject_component,tt.subject_type AS subtype, em.fname,em.mname,em.lname,sd.stream_name, tt.faculty_code 
            FROM `lecture_time_table` AS tt 
            left JOIN (SELECT subject_code,division,semester,stream_id,batch_no,faculty_code FROM lecture_faculty_assign WHERE is_active='Y' and academic_year='2019-20' and  academic_session='WIN') f ON f.subject_code = tt.subject_code AND f.division=tt.division AND f.semester=tt.semester AND f.stream_id=tt.stream_id AND f.batch_no = tt.batch_no
            LEFT JOIN subject_master sm ON sm.sub_id = tt.subject_code 
            LEFT JOIN vw_faculty em ON em.emp_id = tt.faculty_code 
            INNER JOIN vw_stream_details sd ON sd.stream_id = tt.stream_id 
            WHERE (tt.`faculty_code`='' OR tt.`faculty_code` IS NULL)  AND sm.subject_code!='' and  
             tt.academic_year='".$acadyear."' AND tt.academic_session='".$get_session."' and  tt.stream_id not in('4','6','8') 
            GROUP BY tt.subject_code,sm.subject_component,tt.semester, tt.division,tt.batch_no";
            
           //die;
             $query=$DB2->query($sql);
            // $DB1->last_query();
            // die;
            $result=$query->result_array();
            return $result;
    }

    public function subjectnotallocated_to_student()
    {
         $DB1 = $this->load->database('umsdb', TRUE);
         $sql=" SELECT sd.`school_code`,sm.stud_id,sm.admission_stream,sm.current_semester,IFNULL(sub_applied_id, 0) AS subapplied_id,sd.stream_name FROM student_master  AS sm
            LEFT JOIN `student_applied_subject` AS sas ON sas.stud_id=sm.stud_id and sas.academic_year='2019-20'
             INNER JOIN vw_stream_details sd ON sd.stream_id = sm.admission_stream
             WHERE sm.academic_year='2019' and sm.current_semester not in('4','6','8') and sm.cancelled_admission='N' and (sm.admission_cycle  is null or sm.admission_cycle='') and sm.is_detained='N'   GROUP BY sm.admission_stream, sm.current_semester HAVING subapplied_id=0";
             $query=$DB1->query($sql);
            $result=$query->result_array();
            return $result;
    }


   
}