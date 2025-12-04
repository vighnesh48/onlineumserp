<?php
class Swap_timetable_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		$DB1 = $this->load->database('umsdb', TRUE);
    }
    function fetch_Allacademic_session(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
        //print_r($emp_id);exit;
		$sql = "select academic_year,academic_session from academic_session ";		
		if(isset($role_id) && ($role_id==15 || $role_id==6 || $emp_id=='admin_1010') ){
			$sql .=" Order by academic_year desc limit 0,2";
		}elseif($emp_id == 'research_admin'){
			$sql .=" Order by academic_year desc limit 0,4";
			
		}else{
			$sql .="  where currently_active='Y'";
			
		}
		
		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$res = $query->result_array();
		return $res;
	}
	function fetch_faculties(){
		 $DB1 = $this->load->database('umsdb', TRUE);
		 $sql = "SELECT fname,mname,lname,emp_id FROM vw_faculty order by fname asc";
		 $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
		 $query = $query->result_array();
		 return $query;
	}

    function  get_tt_details($time_table_id='', $stream_id='', $sem='', $div='',$academic_year='')
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $academic_year =explode('~', $academic_year);
        $where=" WHERE 1=1 ";          
        if($time_table_id!="")
        {
            $where.=" AND tt.time_table_id='".$time_table_id."'";
        } 
		if($stream_id!="")
        {
            $where.="tt.academic_year='".$academic_year[0]."'";
        }
		if($time_table_id!="" || $stream_id!=""){		
				$sql="SELECT tt.*,tt.tdate,tt.room_no,case tt.wday
		  when 'Monday' then 1
		  when 'Tuesday' then 2
		  when 'Wednesday' then 3
		  when 'Thursday' then 4
		  when 'Friday' then 5
		  when 'Saturday' then 6
		  when 'Sunday' then 7
		end as day_nr,sm.sub_id, sm.subject_name,sm.subject_code as sub_code,sm.batch,sm.subject_component, ls.from_time,ls.to_time, ls.slot_am_pm, em.fname,em.mname,em.lname,sd.stream_name FROM `lecture_time_table` as tt 
				left join subject_master sm on sm.sub_id = tt.subject_code 
				left join lecture_slot ls on ls.lect_slot_id = tt.lecture_slot
				left join vw_faculty em on em.emp_id = tt.faculty_code
				left join vw_stream_details sd on sd.stream_id = tt.stream_id
				$where order by day_nr,ls.from_time ASC";
				
				$query = $DB1->query($sql);
				//echo $DB1->last_query();
				$uId=$this->session->userdata('uid');
				if($uId=='2')
				{
						//echo $DB1->last_query();
						//die;
				}
		return $query->result_array();
		}else{
			return false;
		}
    }
	function get_data_by_faculty($faculty,$academic_year='', $date=''){

        $DB1 = $this->load->database('umsdb', TRUE); 
        $academic_year =explode('~', $academic_year);
		if($academic_year[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
        $day_of_week = date('l', strtotime($date)); // Get day of the week (e.g., Wednesday)
		
		$c='1=1  and  tt.is_swap = "Y"';
		
		if($faculty !='ALL'){
			$c=" tt.faculty_code='".$faculty."' ";
		}
		

		$sql="SELECT tt.*,tt.tdate,tt.room_no,case tt.wday
		  when 'Monday' then 1
		  when 'Tuesday' then 2
		  when 'Wednesday' then 3
		  when 'Thursday' then 4
		  when 'Friday' then 5
		  when 'Saturday' then 6
		  when 'Sunday' then 7
		  end as day_nr,sm.sub_id, sm.subject_name,sm.subject_code as sub_code,sm.batch,sm.subject_component, ls.from_time,ls.to_time, ls.slot_am_pm, em.fname,em.mname,em.lname,sd.stream_name,
          tt.is_swap,aem.fname afname,aem.mname amname,aem.lname alname,att.faculty_code afaculty_code,asm.subject_name asubject_name,asm.subject_code AS asub_code , asm.sub_id asub_id,att.dt_date
          FROM `lecture_time_table` as tt 
		  left join subject_master sm on sm.sub_id = tt.subject_code 
		  left join lecture_slot ls on ls.lect_slot_id = tt.lecture_slot
		  left join vw_faculty em on em.emp_id = tt.faculty_code
		  left join vw_stream_details sd on sd.stream_id = tt.stream_id
          LEFT JOIN alternet_lecture_time_table att ON att.lect_time_table_id = tt.time_table_id and tt.is_swap = 'Y' and dt_date = '".$date."'
          LEFT JOIN vw_faculty aem ON aem.emp_id = att.faculty_code
          LEFT JOIN subject_master asm ON asm.sub_id = att.subject_code    
		  where $c  and tt.academic_year='".$academic_year[0]."' and tt.academic_session='".$cur_ses."' and tt.wday='".$day_of_week."'
		  order by day_nr,ls.from_time ASC";
				
		$query = $DB1->query($sql);
			// echo $DB1->last_query();exit;
			// echo $DB1->last_query();exit;
		return $query->result_array();

	}



	function fetch_subjects($academic_year=''){
		 $DB1 = $this->load->database('umsdb', TRUE);
		 $academic_year =explode('~', $academic_year);
		 if($academic_year[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		
		$sql="SELECT
			  	sm.*
			  FROM
			  	`lecture_time_table` AS tt
			  LEFT JOIN subject_master sm ON
			  	sm.sub_id = tt.subject_code
			  LEFT JOIN vw_faculty em ON
			  	em.emp_id = tt.faculty_code
			  LEFT JOIN vw_stream_details sd ON
			  	sd.stream_id = tt.stream_id
			  WHERE
			  	tt.academic_year = '2024-25' AND tt.academic_session = 'WIN' and sm.stream_id = '116' group by sm.sub_id";

		 $query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
		 $query = $query->result_array();
		 return $query;
	}


    function get_data_by_faculty123($faculty, $academic_year = '', $date = '')
    {

        $DB1 = $this->load->database('umsdb', TRUE);
        $academic_year = explode('~', $academic_year);
        if ($academic_year[1] == 'WINTER') {
            $cur_ses = "WIN";
        } else {
            $cur_ses = "SUM";
        }
        $day_of_week = date('l', strtotime($date)); // Get day of the week (e.g., Wednesday)

        $sql = "SELECT 
                tt.time_table_id,
                tt.academic_year,
                tt.academic_session,
                tt.course_id,
                tt.stream_id,
                tt.semester,
                tt.subject_code,
                tt.subject_type,
                tt.division,
                tt.batch_no,
                tt.faculty_code,
                tt.wday,
                tt.lecture_slot,
                tt.tdate,
                tt.room_no,
                CASE tt.wday 
                    WHEN 'Monday' THEN 1 
                    WHEN 'Tuesday' THEN 2 
                    WHEN 'Wednesday' THEN 3 
                    WHEN 'Thursday' THEN 4 
                    WHEN 'Friday' THEN 5 
                    WHEN 'Saturday' THEN 6 
                    WHEN 'Sunday' THEN 7 
                END AS day_nr,
                sm.sub_id,
                sm.subject_name,
                sm.subject_code AS sub_code,
                sm.batch,
                sm.subject_component,
                ls.from_time,
                ls.to_time,
                ls.slot_am_pm,
                em.fname,
                em.mname,
                em.lname,
                sd.stream_name
            FROM lecture_time_table AS tt
            LEFT JOIN subject_master sm ON sm.sub_id = tt.subject_code
            LEFT JOIN lecture_slot ls ON ls.lect_slot_id = tt.lecture_slot
            LEFT JOIN vw_faculty em ON em.emp_id = tt.faculty_code
            LEFT JOIN vw_stream_details sd ON sd.stream_id = tt.stream_id
            where tt.faculty_code='" . $faculty . "'  and tt.academic_year='" . $academic_year[0] . "' and tt.academic_session='" . $cur_ses . "' and tt.wday='" . $day_of_week . "'

            UNION ALL

            SELECT 
                tt.time_table_id,
                tt.academic_year,
                tt.academic_session,
                tt.course_id,
                tt.stream_id,
                tt.semester,
                tt.subject_code,
                tt.subject_type,
                tt.division,
                tt.batch_no,
                tt.faculty_code,
                tt.wday,
                tt.lecture_slot,
                tt.tdate,
                tt.room_no,
                CASE tt.wday 
                    WHEN 'Monday' THEN 1 
                    WHEN 'Tuesday' THEN 2 
                    WHEN 'Wednesday' THEN 3 
                    WHEN 'Thursday' THEN 4 
                    WHEN 'Friday' THEN 5 
                    WHEN 'Saturday' THEN 6 
                    WHEN 'Sunday' THEN 7 
                END AS day_nr,
                sm.sub_id,
                sm.subject_name,
                sm.subject_code AS sub_code,
                sm.batch,
                sm.subject_component,
                ls.from_time,
                ls.to_time,
                ls.slot_am_pm,
                em.fname,
                em.mname,
                em.lname,
                sd.stream_name
            FROM alternet_lecture_time_table AS tt
            LEFT JOIN subject_master sm ON sm.sub_id = tt.subject_code
            LEFT JOIN lecture_slot ls ON ls.lect_slot_id = tt.lecture_slot
            LEFT JOIN vw_faculty em ON em.emp_id = tt.faculty_code
            LEFT JOIN vw_stream_details sd ON sd.stream_id = tt.stream_id
		  where tt.faculty_code='" . $faculty . "'  and tt.academic_year='" . $academic_year[0] . "' and tt.academic_session='" . $cur_ses . "' and tt.wday='" . $day_of_week . "'
		  order by day_nr ASC";

        $query = $DB1->query($sql);
        // echo $DB1->last_query();exit;
        return $query->result_array();

    }
	
	
	
	
	 function get_swap_data($faculty, $academic_year = '', $date = '')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $academic_year = explode('~', $academic_year);
        $cur_ses = ($academic_year[1] == 'WINTER') ? "WIN" : "SUM";
    
        $day_of_week = date('l', strtotime($date));
    
        $sql = "SELECT tt.*, tt.tdate, tt.room_no,
            sm.sub_id, sm.subject_name, sm.subject_code as sub_code, sm.batch, sm.subject_component,
            ls.from_time, ls.to_time, ls.slot_am_pm,
            em.fname, em.mname, em.lname, sd.stream_name,
            tt.is_swap, aem.fname afname, aem.mname amname, aem.lname alname, att.faculty_code afaculty_code,
            asm.subject_name asubject_name, asm.subject_code AS asub_code, asm.sub_id asub_id, att.dt_date
            FROM lecture_time_table as tt 
            LEFT JOIN subject_master sm ON sm.sub_id = tt.subject_code 
            LEFT JOIN lecture_slot ls ON ls.lect_slot_id = tt.lecture_slot
            LEFT JOIN vw_faculty em ON em.emp_id = tt.faculty_code
            LEFT JOIN vw_stream_details sd ON sd.stream_id = tt.stream_id
            LEFT JOIN alternet_lecture_time_table att ON att.lect_time_table_id = tt.time_table_id 
                AND dt_date = '".$date."'
            LEFT JOIN vw_faculty aem ON aem.emp_id = att.faculty_code
            LEFT JOIN subject_master asm ON asm.sub_id = att.subject_code    
            WHERE tt.faculty_code = '".$faculty."'  
            AND tt.academic_year = '".$academic_year[0]."' 
            AND tt.academic_session = '".$cur_ses."'
            AND tt.wday = '".$day_of_week."'
            AND tt.is_swap = 'Y'
            ORDER BY ls.from_time ASC";
    
        $query = $DB1->query($sql);
     //   echo $DB1->last_query();exit;
        return $query->result_array();
    }

}