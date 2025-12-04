<?php
class Admission_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
        
    }

	/*Admission Statistics Report*/
	public function get_admission_statistics($row)
	{
	    	$DB1 = $this->load->database('umsdb', TRUE);
	   		 $sql="SELECT d.school_short_name,d.course_short_name,d.stream_short_name,d.stream_name,s.admission_stream,a.year,
            sum(case when s.gender='M' then 1 else 0 end )as 'M',
            sum(case when s.gender='F' then 1 else 0 end )as 'F',
            sum(case when s.gender='M' and s.category='SC' then 1 else 0 end )as 'SC-M',
            sum(case when s.gender='F' and s.category='SC' then 1 else 0 end )as 'SC-F',
            sum(case when s.category='SC' then 1 else 0 end )as 'SC',
            sum(case when s.gender='M' and s.category='ST' then 1 else 0 end )as 'ST-M',
            sum(case when s.gender='F' and s.category='ST' then 1 else 0 end )as 'ST-F',
              sum(case when s.category='ST' then 1 else 0 end )as 'ST',
            sum(case when s.gender='M' and s.category='Open' then 1 else 0 end )as 'GM-M',
            sum(case when s.gender='F' and s.category='Open' then 1 else 0 end )as 'GM-F',        
            sum(case when s.gender='M' and s.category in ('OBC') then 1 else 0 end )as 'OBC-M',
            sum(case when s.gender='F' and s.category in ('OBC') then 1 else 0 end )as 'OBC-F',
            sum(case when s.gender='M' and s.category in ('NT-B') then 1 else 0 end )as 'NT1-M',
            sum(case when s.gender='F' and s.category in ('NT-B') then 1 else 0 end )as 'NT1-F',
            sum(case when s.gender='M' and s.category in ('NT-C') then 1 else 0 end )as 'NT2-M',
            sum(case when s.gender='F' and s.category in ('NT-C') then 1 else 0 end )as 'NT2-F',
            sum(case when s.gender='M' and s.category in ('NT-D') then 1 else 0 end )as 'NT3-M',
            sum(case when s.gender='F' and s.category in ('NT-D') then 1 else 0 end )as 'NT3-F',
            sum(case when s.gender='M' and s.category in ('VJ/DT-A') then 1 else 0 end )as 'VJDT-M',
            sum(case when s.gender='F' and s.category in ('VJ/DT-A') then 1 else 0 end )as 'VJDT-F',
          sum(case when s.gender='M' and s.category in ('SBC') then 1 else 0 end )as 'SBC-M',
            sum(case when s.gender='F' and s.category in ('SBC') then 1 else 0 end )as 'SBC-F',
          sum(case when s.gender='M' and s.category in ('SBCM') then 1 else 0 end )as 'SBCM-M',
            sum(case when s.gender='F' and s.category in ('SBCM') then 1 else 0 end )as 'SBCM-F',
            sum(case when s.gender='M' and s.religion like 'Hin%' then 1 else 0 end )as 'Hind-M',
            sum(case when s.gender='F' and s.religion like 'Hin%' then 1 else 0 end )as 'Hind-F',
            sum(case when s.gender='M' and s.religion like 'Ch%' then 1 else 0 end )as 'Chri-M',
            sum(case when s.gender='F' and s.religion like 'Ch%' then 1 else 0 end )as 'Chri-F',
            sum(case when s.gender='M' and s.religion like 'Si%' then 1 else 0 end )as 'Sik-M',
            sum(case when s.gender='F' and s.religion like 'Si%' then 1 else 0 end )as 'Sik-F',
            sum(case when s.gender='M' and s.religion like 'Jai%' then 1 else 0 end )as 'Jai-M',
            sum(case when s.gender='F' and s.religion like 'Jai%' then 1 else 0 end )as 'Jai-F',
            sum(case when s.gender='M' and s.religion like 'Mus%' then 1 else 0 end )as 'Mus-M',
            sum(case when s.gender='F' and s.religion like 'Mus%' then 1 else 0 end )as 'Mus-F',
            sum(case when s.gender='M' and s.religion like 'Bud%' then 1 else 0 end )as 'Bud-M',
            sum(case when s.gender='F' and s.religion like 'Bud%' then 1 else 0 end )as 'Bud-F',
            sum(case when s.domicile_status='MS'then 1 else 0 end )as 'MS',
            sum(case when s.domicile_status='OMS'then 1 else 0 end )as 'OMS',
            sum(case when s.gender='M' and s.physically_handicap='Y' then 1 else 0 end )as 'PHY-M',
            sum(case when s.gender='F' and s.physically_handicap='Y' then 1 else 0 end )as 'PHY-F',
            sum(case when s.gender='M' and s.nationality!='Indian'then 1 else 0 end )as 'INT-M',
            sum(case when s.gender='F' and s.nationality!='Indian'  then 1 else 0 end )as 'INT-F',
            sum(case when  a.cancelled_admission='Y'  then 1 else 0 end )as 'cancel_adm'
            FROM `admission_details` a 
            left join student_master s on  s.stud_id=a.student_id and s.admission_stream=a.stream_id
            left join vw_stream_details d on a.stream_id=d.stream_id
            where a.academic_year='".$row['academic_year']."' and s.admission_confirm='Y'
            group by d.school_short_name,d.course_short_name,d.stream_short_name,s.admission_stream,a.year order by d.school_short_name,d.course_short_name,d.stream_short_name,s.admission_stream,a.year";
            $query =  $DB1->query($sql);
            //echo $DB1->last_query(); exit();
            return $query->result_array();
	    
	}
	public function get_admission_summary($row){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $sql="SELECT 
	        SUM(CASE WHEN d.is_partnership='N' AND s.cancelled_admission='N' AND s.admission_confirm='Y' AND s.enrollment_no !='' AND s.admission_session=s.academic_year AND  s.admission_year='1' and s.academic_year='".$row['academic_year']."' THEN 1 ELSE 0 END)AS new_adm,
	        SUM(CASE WHEN d.is_partnership='N' AND s.cancelled_admission='N' AND s.admission_confirm='Y'  AND s.enrollment_no !='' AND s.admission_session=s.academic_year AND  s.admission_year='3' and s.academic_year='".$row['academic_year']."' THEN 1 ELSE 0 END)AS new_adm_third,
            SUM(CASE WHEN d.is_partnership='N' AND a.cancelled_admission='N' AND s.admission_confirm='Y' AND s.enrollment_no !='' AND s.admission_session!=a.academic_year   THEN 1 ELSE 0 END)AS re_adm,
            SUM(CASE WHEN d.is_partnership='N' AND a.cancelled_admission='N' AND s.admission_confirm='Y' AND s.enrollment_no !='' AND s.admission_session=a.academic_year AND s.admission_year='2' and s.academic_year='".$row['academic_year']."' THEN 1 ELSE 0 END)AS di_adm,
            SUM(CASE WHEN d.is_partnership='Y' AND a.cancelled_admission='N' AND s.admission_confirm='Y' AND s.enrollment_no !='' AND s.admission_session=a.academic_year AND  s.admission_year='1' and s.academic_year='".$row['academic_year']."' THEN 1 ELSE 0 END)AS part_new_adm,
            SUM(CASE WHEN d.is_partnership='Y' AND a.cancelled_admission='N' AND s.admission_confirm='Y' AND s.enrollment_no !='' AND s.admission_session!=a.academic_year   THEN 1 ELSE 0 END)AS part_re_adm,
            SUM(CASE WHEN d.is_partnership='Y' AND a.cancelled_admission='N' AND s.admission_confirm='Y' AND s.enrollment_no !='' AND s.admission_session=a.academic_year AND s.admission_year='2' and s.academic_year='".$row['academic_year']."'  THEN 1 ELSE 0 END)AS part_di_adm,
            SUM(CASE WHEN d.is_partnership='N' AND a.cancelled_admission='Y' AND s.admission_confirm='Y' AND s.enrollment_no !='' AND s.admission_session=a.academic_year AND s.admission_year='1' THEN 1 ELSE 0 END)AS cancel_new_adm,
            SUM(CASE WHEN d.is_partnership='N' AND a.cancelled_admission='Y' AND s.admission_confirm='Y' AND s.enrollment_no !='' AND s.admission_session!=a.academic_year THEN 1 ELSE 0 END)AS cancel_re_adm,
            SUM(CASE WHEN d.is_partnership='N' AND a.cancelled_admission='Y' AND s.admission_confirm='Y' AND s.enrollment_no !='' AND s.admission_session=a.academic_year AND  s.admission_year='2'  THEN 1 ELSE 0 END)AS cancel_di_adm,
            SUM(CASE WHEN d.is_partnership='Y' AND a.cancelled_admission='Y' AND s.admission_confirm='Y' AND s.enrollment_no !='' AND s.admission_session=a.academic_year AND s.admission_year='1' THEN 1 ELSE 0 END)AS cancel_part_new_adm,
            SUM(CASE WHEN d.is_partnership='Y' AND a.cancelled_admission='Y' AND s.admission_confirm='Y' AND s.enrollment_no !='' AND s.admission_session!=a.academic_year THEN 1 ELSE 0 END)AS cancel_part_re_adm,
            SUM(CASE WHEN d.is_partnership='Y' AND a.cancelled_admission='y' AND s.admission_confirm='Y' AND s.enrollment_no !='' AND s.admission_session=a.academic_year AND s.admission_year='2'  THEN 1 ELSE 0 END)AS cancel_part_di_adm
            FROM admission_details a LEFT JOIN student_master s ON s.stud_id=a.student_id 
            LEFT JOIN vw_stream_details d ON a.stream_id=d.stream_id  where a.academic_year='".$row['academic_year']."'";
             $query =  $DB1->query($sql);
            //echo $DB1->last_query(); exit();
            return $query->result_array();
	}
	public function get_citywise_total($row){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $sql="SELECT dt.district_name,st.state_name,
            SUM(CASE WHEN d.course_id='1' THEN 1 ELSE 0 END)AS Diploma,
            SUM(CASE WHEN d.course_id='2' THEN 1 ELSE 0 END)AS BTECH,
            SUM(CASE WHEN d.course_id='3' THEN 1 ELSE 0 END)AS MTECH,
            SUM(CASE WHEN d.course_id='4' THEN 1 ELSE 0 END)AS BBA,
            SUM(CASE WHEN d.course_id='5' THEN 1 ELSE 0 END)AS MBA,
            SUM(CASE WHEN d.course_id='6' THEN 1 ELSE 0 END)AS BCOM,
            SUM(CASE WHEN d.course_id='7' THEN 1 ELSE 0 END)AS MCOM,
            SUM(CASE WHEN d.course_id='8' THEN 1 ELSE 0 END)AS LLB,
            SUM(CASE WHEN d.course_id='9' THEN 1 ELSE 0 END)AS BSC,
            SUM(CASE WHEN d.course_id='10' THEN 1 ELSE 0 END)AS MSC,
            SUM(CASE WHEN d.course_id='11' THEN 1 ELSE 0 END)AS BCA,
            SUM(CASE WHEN d.course_id='12' THEN 1 ELSE 0 END)AS MCA,
            SUM(CASE WHEN d.course_id='13' THEN 1 ELSE 0 END)AS BA,
            SUM(CASE WHEN d.course_id='14' THEN 1 ELSE 0 END)AS MA,
            SUM(CASE WHEN d.course_id='15' THEN 1 ELSE 0 END)AS PHD,
            SUM(CASE WHEN d.course_id='16' THEN 1 ELSE 0 END)AS DPHRM,
            SUM(CASE WHEN d.course_id='17' THEN 1 ELSE 0 END)AS BCS,
            SUM(CASE WHEN d.course_id='18' THEN 1 ELSE 0 END)AS MCS,
            SUM(CASE WHEN d.course_id='19' THEN 1 ELSE 0 END)AS LLM,
			SUM(CASE WHEN d.course_id='20' THEN 1 ELSE 0 END)AS CERT,
			SUM(CASE WHEN d.course_id='21' THEN 1 ELSE 0 END)AS BPharma,
			SUM(CASE WHEN d.course_id='22' THEN 1 ELSE 0 END)AS MPharma,
			SUM(CASE WHEN d.course_id='23' THEN 1 ELSE 0 END)AS BDes,			
			SUM(CASE WHEN d.course_id='24' THEN 1 ELSE 0 END)AS MDes,
			SUM(CASE WHEN d.course_id='25' THEN 1 ELSE 0 END)AS PGDACC,
			SUM(CASE WHEN d.course_id='34' THEN 1 ELSE 0 END)AS BscIT,
			SUM(CASE WHEN d.course_id='35' THEN 1 ELSE 0 END)AS MscIT,
			SUM(CASE WHEN d.course_id='39' THEN 1 ELSE 0 END)AS MSCPHARMA,
			SUM(CASE WHEN d.course_id='41' THEN 1 ELSE 0 END)AS MCOMFAA,		
SUM(CASE WHEN d.course_id='42' THEN 1 ELSE 0 END)AS LLMIPR,	
SUM(CASE WHEN d.course_id='43' THEN 1 ELSE 0 END)AS BBAHONS,	
SUM(CASE WHEN d.course_id='44' THEN 1 ELSE 0 END)AS BSCINTERIO,	
SUM(CASE WHEN d.course_id='45' THEN 1 ELSE 0 END)AS MSCINTERIO,	
SUM(CASE WHEN d.course_id='47' THEN 1 ELSE 0 END)AS LLMCRLOY,	
SUM(CASE WHEN d.course_id='48' THEN 1 ELSE 0 END)AS LLMCOCOMM,	
SUM(CASE WHEN d.course_id='49' THEN 1 ELSE 0 END)AS BscIT,	
SUM(CASE WHEN d.course_id='50' THEN 1 ELSE 0 END)AS BscIT,	
SUM(CASE WHEN d.course_id='51' THEN 1 ELSE 0 END)AS BTech,	
SUM(CASE WHEN d.course_id='52' THEN 1 ELSE 0 END)AS MSCDRUG,	
SUM(CASE WHEN d.course_id='53' THEN 1 ELSE 0 END)AS MBADATASCI,	
SUM(CASE WHEN d.course_id='54' THEN 1 ELSE 0 END)AS MBABANKFIN,	
SUM(CASE WHEN d.course_id='55' THEN 1 ELSE 0 END)AS MBAEntrepr,				
SUM(CASE WHEN d.course_id='56' THEN 1 ELSE 0 END)AS MBAIT,				
SUM(CASE WHEN d.course_id='57' THEN 1 ELSE 0 END)AS MBAOPERAT,				
			
            Count(dt.district_name)as city_total
            FROM admission_details a 
            LEFT JOIN student_master s ON s.stud_id=a.student_id  
            LEFT JOIN vw_stream_details d ON a.stream_id=d.stream_id 
            LEFT JOIN address_details ad ON ad.student_id=s.stud_id
            LEFT JOIN taluka_master t ON t.taluka_id=ad.city
            LEFT JOIN district_name dt ON dt.district_id=ad.district_id
            LEFT JOIN states st ON st.state_id=ad.state_id
            WHERE ad.adds_of='STUDENT' AND ad.address_type='CORS' AND  a.academic_year='".$row['academic_year']."' AND s.admission_session='".$row['academic_year']."' and a.cancelled_admission='N' and s.enrollment_no !=''
            GROUP BY dt.district_name,st.state_name
            ORDER BY st.state_name,dt.district_name";
             $query =  $DB1->query($sql);
            //echo $DB1->last_query(); exit();
            return $query->result_array();
     
	}
    public function get_scholorship_list($row){
		$DB1 = $this->load->database('umsdb', TRUE);
		/* $DB1->select("f.concession_type,f.duration,am.concession_remark,sm.enrollment_no,sm.admission_session,sm.academic_year,sm.first_name,sm.middle_name,sm.last_name,sm.mobile,am.applicable_fee,am.actual_fee,stm.course_short_name,stm.school_short_name,stm.stream_short_name,am.year");
		$DB1->from('admission_details as am ');
		$DB1->join('student_master as sm','am.student_id = sm.stud_id','left');
		$DB1->join('vw_stream_details  as stm','am.stream_id = stm.stream_id','left');
		$DB1->join('fees_consession_details  as f','f.student_id=sm.stud_id','left');
	
		$DB1->where("am.applicable_fee!=am.actual_fee and am.cancelled_admission='N' and sm.admission_confirm='Y' and am.academic_year='".$row['academic_year']."'");
		if($this->session->userdata('name')=='210708'){
				$DB1->where(" sm.admission_session='".$row['academic_year']."'");
		}
		$DB1->order_by(" course_short_name,stream_name,year,enrollment_no", "asc"); */
		
		
		
		$DB1->select('f.concession_type, f.duration, am.concession_remark, sm.enrollment_no, sm.admission_session, am.academic_year, sm.first_name, sm.middle_name, sm.last_name, sm.mobile, am.applicable_fee, am.actual_fee, stm.course_short_name, stm.school_short_name, stm.stream_short_name, am.year');
		$DB1->from('admission_details as am');
		$DB1->join('student_master as sm', 'am.student_id = sm.stud_id', 'left');
		$DB1->join('vw_stream_details as stm', 'am.stream_id = stm.stream_id', 'left');
		$DB1->join('(select * from fees_consession_details where academic_year="'.$row['academic_year'].'" group by student_id) as f', 'f.student_id=sm.stud_id', 'left');
		$DB1->where('am.applicable_fee != am.actual_fee');
		$DB1->where('am.cancelled_admission', 'N');
		$DB1->where('sm.admission_confirm', 'Y');
		$DB1->where('am.academic_year', $row['academic_year']);
		$DB1->order_by('stm.course_short_name', 'ASC');
		$DB1->order_by('stm.stream_name', 'ASC');
		$DB1->order_by('am.year', 'ASC');
		$DB1->order_by('sm.enrollment_no', 'ASC');
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;
	}
	
	 public function get_cancelled_list($row){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.enrollment_no_new,sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name,sm.mobile,stm.school_short_name,stm.course_short_name,stm.stream_short_name,am.year,DATE_FORMAT(c.canc_date,'%d/%m/%Y') AS cancel_date ,canc_fee");
		$DB1->from('admission_details as am ');
		$DB1->join('student_master as sm','am.student_id = sm.stud_id and am.academic_year=sm.academic_year','left');
		$DB1->join('admission_cancellations as c','am.student_id = c.stud_id ','left');
		$DB1->join('vw_stream_details  as stm','am.stream_id = stm.stream_id','left');
		$DB1->where(" am.cancelled_admission='Y' and am.academic_year='".$row['academic_year']."'");
		$DB1->order_by(" course_short_name,stream_name,year,enrollment_no_new", "asc");
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;
	}

	public function get_direct_admission_list($row){
	
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name,sm.mobile,stm.school_short_name,stm.course_short_name,stm.stream_short_name,am.year ");
		$DB1->from('admission_details as am ');
		$DB1->join('student_master as sm','am.student_id = sm.stud_id and am.academic_year=sm.academic_year','left');
		$DB1->join('vw_stream_details  as stm','am.stream_id = stm.stream_id','left');
		$DB1->where("sm.admission_session=sm.academic_year and sm.admission_year='2' and am.cancelled_admission='N' and sm.admission_confirm='Y' and am.academic_year='".$row['academic_year']."'");
		$DB1->order_by(" course_short_name,stream_name,year,enrollment_no", "asc");
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;
	}
	
		public function get_student_list($row){
		 //   exit();
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.stud_id,sm.enrollment_no,sm.first_name,sm.middle_name,sm.admission_date,
		sm.last_name,sm.mobile,sm.email,p.parent_mobile2,stm.school_short_name,stm.course_short_name,stm.stream_name,sm.current_semester,
		stm.stream_short_name,am.year,am.form_number,la.is_present, sm.reported_status,am.opening_balance,am.academic_year,sm.admission_session");
		// fd.fees_paid , ");
		$DB1->from('admission_details as am ');
		$DB1->join('student_master as sm','am.student_id = sm.stud_id ','left');
		$DB1->join('parent_details as p','p.student_id = sm.stud_id ','left');
		$DB1->join('vw_stream_details  as stm','am.stream_id = stm.stream_id','left');
		
		$DB1->join('(select distinct(is_present),student_id from lecture_attendance 
	where is_present="Y" and academic_year like "'.$row['academic_year'].'%" group by student_id) as la','la.student_id = sm.stud_id','left');
		/*$DB1->join('(select SUM(amount) as fees_paid, student_id from fees_details where type_id=2 and academic_year = "'.$row['academic_year'].'" group by student_id  ) as fd','fd.student_id = am.student_id ','left');
		*/
		$DB1->where("am.cancelled_admission='N' and sm.admission_confirm='Y' and am.academic_year='".$row['academic_year']."'");
		$DB1->order_by(" course_short_name,stream_name,year,enrollment_no", "asc"); 
		//$DB1->order_by(" admission_date", "asc");
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		$result=$query->result_array();

		return $result;
	}
	

	
	
	
		public function get_parent_list($row){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name,p.parent_mobile2,p.relation,p.occupation,stm.school_short_name,stm.course_short_name,stm.stream_short_name,am.year ");
		$DB1->from('admission_details as am ');
		$DB1->join('student_master as sm','am.student_id = sm.stud_id ','left');
		$DB1->join('parent_details as p','p.student_id = sm.stud_id ','left');
		$DB1->join('vw_stream_details  as stm','am.stream_id = stm.stream_id','left');
		$DB1->where("am.cancelled_admission='N' and am.academic_year='".$row['academic_year']."'");
		$DB1->order_by(" course_short_name,stream_name,year,enrollment_no", "asc");
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;
	}
	
	public function get_approval_list($row){
		 //error_reporting(E_ALL);
	   	$DB1 = $this->load->database('umsdb', TRUE);
	   	if($row['report_type']=="14"){
	   	    //$cond="  WHERE ad.academic_year='".$row['academic_year']."'  AND ad.`cancelled_admission`='N' 
			//and s.stud_id is not null order by cancelled_admission,enrollment_no asc";
			$cond="  WHERE ad.academic_year='".$row['academic_year']."'  AND (s.enrollment_no != '')
			and s.stud_id is not null order by cancelled_admission,enrollment_no asc";
	   	}
	   	else{
	   	       	$cond="  WHERE ad.academic_year='".$row['academic_year']."' AND ad.`cancelled_admission`='N'
				 and v.stream_id='".$row['stream_id']."' and ad.year='".$row['year']."'
				  and s.stud_id is not null group by s.stud_id order by cancelled_admission,enrollment_no asc";
	 
	   	}
	    $sql="SELECT s.stud_id,s.admission_session,s.enrollment_no,s.general_reg_no,s.father_fname,s.father_mname,s.father_lname,s.transefercase,s.belongs_to,s.mother_name,s.enrollment_no_new,CASE WHEN ad.form_number='' THEN s.form_number ELSE ad.form_number END AS form_no ,s.form_number,s.lateral_entry,s.first_name,s.middle_name,s.last_name,s.gender,s.mobile,s.email,s.religion,s.category,s.domicile_status,s.nationality,s.physically_handicap,s.sub_caste,s.birth_place,s.last_institute,s.adhar_card_no,s.dob,s.admission_date,s.blood_group,
            sa.address,tm.taluka_name,dt.district_name,st.state_name,sa.pincode,REPLACE(REPLACE(REPLACE(UPPER(sa.address),UPPER(tm.taluka_name),''),UPPER(dt.district_name),''), UPPER(st.state_name),'') AS adds,
            v.school_name,v.school_short_name,v.course_short_name,v.stream_name,v.stream_short_name,ad.year,c.name as country_name,
            q1.degree_type as degree_type1,q1.degree_name as degree_name1,q1.specialization as specialization1,q1.passing_year as passing_year1,q1.percentage as percentage1 ,UPPER(q1.board_uni_name) as board1,
            q2.degree_type as degree_type2,q2.degree_name as degree_name2,q2.specialization as specialization2,q2.passing_year as passing_year2,q2.percentage as percentage2 ,UPPER(q2.board_uni_name) as board2,
            q3.degree_type as degree_type3,q3.degree_name as degree_name3,q3.specialization as specialization3,q3.passing_year as passing_year3,q3.percentage as percentage3 ,UPPER(q3.board_uni_name) as board3,
            q4.degree_type as degree_type4,q4.degree_name as degree_name4,q4.specialization as specialization4,q4.passing_year as passing_year4,q4.percentage as percentage4 ,UPPER(q4.board_uni_name) as board4,
            q5.degree_type as degree_type5,q5.degree_name as degree_name5,q5.specialization as specialization5,q5.passing_year as passing_year5,q5.percentage as percentage5 ,UPPER(q5.board_uni_name) as board5,
            ad.cancelled_admission,ad.year,ad.academic_year,s.academic_year AS academic_year1,CASE 
  WHEN q5.degree_type!='' THEN 'Post Graduation'
  WHEN q4.degree_type!='' THEN 'Graduation'
   WHEN q3.degree_type!='' THEN 'Diploma'
    WHEN q2.degree_type!='' THEN 'HSC'
     WHEN q1.degree_type!='' THEN 'SSC'
  
  END AS last_exam,
    CONCAT(see.entrance_exam_name,'-',see.passing_year,'-',see.marks_obt) AS CET

            FROM admission_details ad 
			LEFT JOIN student_master s ON s.stud_id=ad.student_id 
            LEFT JOIN  student_qualification_details q1 on s.stud_id=q1.student_id and q1.degree_type='SSC'
            LEFT JOIN  student_qualification_details q2 on s.stud_id=q2.student_id  and q2.degree_type='HSC'
            LEFT JOIN  student_qualification_details q3 on s.stud_id=q3.student_id and q3.degree_type='Diploma'
            LEFT JOIN  student_qualification_details q4 on s.stud_id=q4.student_id and q4.degree_type='Graduation'
            LEFT JOIN  student_qualification_details q5 on s.stud_id=q5.student_id and q5.degree_type='Post Graduation'
            LEFT JOIN vw_stream_details v ON v.stream_id=s.admission_stream
            LEFT JOIN address_details sa ON sa.student_id=s.stud_id AND sa.address_type='PERMNT' AND sa.adds_of='STUDENT'
            LEFT JOIN states st ON st.state_id=sa.state_id
            LEFT JOIN district_name dt ON dt.district_id=sa.district_id
            LEFT JOIN taluka_master tm ON tm.taluka_id=sa.city
			LEFT JOIN countries c ON c.id=sa.country_id
            LEFT JOIN student_entrance_exam AS see ON see.student_id=s.stud_id
           ".$cond;
		   //$sql .=' limit 10';
          //echo $sql;exit;
            $query =  $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
        //print_r($result);exit();
		return $result;
		
	}
	
	
		public function get_last_qualification($studid){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('student_qualification_details as sqd');
		
		$DB1->where("sqd.student_id",$studid);
		$DB1->order_by('sqd.qual_id','desc');
         $DB1->limit(1);
		$query=$DB1->get();
	//	echo $DB1->last_query();exit;
		$result=$query->row_array();
		
		return $result;// $result['degree_type']." ".$result['degree_name']." ".$result['passing_year'];
	}
	public function student_entrance_exam($studid){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('student_entrance_exam as see');
		
		//$DB1->where("see.ent_exam_id",$studid);
		$DB1->where("see.student_id",$studid);
		//$DB1->order_by('sqd.qual_id','desc');
     //    $DB1->limit(1);
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		$val="";
		foreach($result as $result1)
		{if($result1['entrance_exam_name']!='')
		{
		    $val .=" ".$result1['entrance_exam_name']."-".$result1['passing_year']."-".$result1['marks_obt']."<br>";
		}
		}
		return $val;
		//return $result['degree_type']." ".$result['degree_name']." ".$result['passing_year'];
	}	
	
	public function get_student_status_list($row){
	    $current_year=$row['academic_year']+1;
	    $cond="";
	    if($row['report_type']=="16"){
	      $cond.=" and s.academic_year='".$row['academic_year']."' and s.cancelled_admission='N' and s.degree_completed='N'";  
	    }
	    $DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT case when s.enrollment_no='' then s.enrollment_no_new else s.enrollment_no end as reg_no,s.mobile,s.email, CONCAT(s.first_name, ' ', s.middle_name, ' ', s.last_name)AS student_name, s.admission_session, s.academic_year, s.current_year, s.cancelled_admission, v.school_short_name, v.course_short_name, v.stream_short_name, CASE WHEN s.degree_completed='Y' AND s.cancelled_admission='N' THEN 'Degree Completed' WHEN s.academic_year='".$current_year."' AND s.cancelled_admission='N' THEN 'Re-Registered Done' WHEN s.academic_year='".$row['academic_year']."' AND s.cancelled_admission='N' THEN 'Non-reported' WHEN s.cancelled_admission='Y' THEN 'Admission Cancelled' ELSE '' END AS Remark FROM student_master as s LEFT JOIN admission_details as a ON s.stud_id=a.student_id LEFT JOIN vw_stream_details as v ON s.admission_stream=v.stream_id WHERE a.academic_year = '".$row['academic_year']."'  $cond ORDER BY course_short_name ASC, stream_name ASC, year ASC, s.cancelled_admission ASC, s.enrollment_no ASC";
		$query =  $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
        //print_r($result);exit();
		return $result;
	    
	}
	
	public function get_course_list($row){
		$DB1 = $this->load->database('umsdb',TRUE);
	
		if($row['type']=="school"){
		    	$sel=" stm.school_id,stm.school_short_name,stm.school_name ";
	      	$ord="stm.school_id ";
	      	$cond="";
		}
		else if($row['type']=="course"){
		   	$sel=" stm.school_id,stm.course_short_name,stm.course_name,stm.course_id ";
	      	$ord="stm.course_short_name "; 
	      	$cond=" and stm.school_id='".$row['school_id']."'";
		}
    	else if($row['type']=="stream"){
    	    $sel=" stm.school_id,stm.stream_short_name,stm.stream_name,stm.stream_id ";
	      	$ord="stm.course_short_name "; 
	      	$cond=" and stm.school_id='".$row['school_id']."' and stm.course_id='".$row['course_id']."'";
		}
		else if($row['type']=="year"){
    	    $sel=" am.year ";
	      	$ord="am.year"; 
	      	$cond=" and stm.school_id='".$row['school_id']."' and stm.course_id='".$row['course_id']."' and stm.stream_id='".$row['stream_id']."'";
		}
		$DB1->distinct();
		$DB1->select($sel);
		$DB1->from('admission_details as am ');
		$DB1->join('vw_stream_details  as stm','am.stream_id = stm.stream_id','left');
		$DB1->where("am.cancelled_admission='N' and am.academic_year='".$row['academic_year']."'".$cond);
		$DB1->order_by($ord, "asc");
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;
	}
	public function getNoReRegistration_list($row){
	    $current_year=$row['academic_year'];
		$pre_year=$row['academic_year']-1;
	    $cond="";

	    $DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select R.* from (SELECT `sm`.`enrollment_no`, `sm`.`first_name`, `sm`.`middle_name`, `sm`.`last_name`, `sm`.`mobile`, `sm`.`email`, `p`.`parent_mobile2`, `stm`.`school_short_name`, `stm`.`course_short_name`, `stm`.`stream_short_name`, `am`.`year`, `am`.`form_number`, CASE 
WHEN sm.academic_year='".$current_year."' AND sm.cancelled_admission='N' THEN 'Re-Registered Done' 
WHEN sm.academic_year='".$pre_year."' AND sm.cancelled_admission='N' THEN 'Non-Registered' 
END AS Remark 
FROM `admission_details` as `am` 
LEFT JOIN `student_master` as `sm` ON `am`.`student_id` = `sm`.`stud_id` 
LEFT JOIN `parent_details` as `p` ON `p`.`student_id` = `sm`.`stud_id` 
LEFT JOIN `vw_stream_details` as `stm` ON `am`.`stream_id` = `stm`.`stream_id` 
WHERE `am`.`cancelled_admission` = 'N' and `am`.`academic_year` = '".$pre_year."' 
ORDER BY `course_short_name` ASC, `stream_name` ASC, `year` ASC, `enrollment_no` ASC ) as R  where R.remark='Non-Registered'";
		$query =  $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
        //print_r($result);exit();
		return $result;
	    
	}

public function getpaidfees($stud_id, $ayear){
	$DB1 = $this->load->database('umsdb', TRUE);
	$sql = "select SUM(amount) as fees_paid, student_id from fees_details where type_id=2 
 and academic_year = '".$ayear."' and student_id ='".$stud_id."'";
 
	$query =  $DB1->query($sql);
	//echo $DB1->last_query();exit;
	$result=$query->result_array();
	//print_r($result);exit();
	return $result;
	
}	

	public function getattendance($stud_id, $ayear){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select DISTINCT(is_present) from lecture_attendance where is_present='Y'
	 and academic_year like '".$ayear."%' and student_id ='".$stud_id."'";
	 
		$query =  $DB1->query($sql);
		//echo $DB1->last_query();
		$result=$query->result_array();
		//print_r($result);exit();
		//return $result;
		if(empty($result)){
			return "N";
		}if($result[0]['is_present']="Y"){
			return "Y";
		}else{
			return "N";
		}
		
	}


	// Added BY: Amit Dubey AS On 12-08-2025, Code block Start//
 
	public function getStudentRefundRequestList($dataArr = array()){
	 
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('student_request_refund.*,bank_master.bank_id,bank_master.bank_name,student_master.admission_stream'); 
		$DB1->from('student_request_refund');
		$DB1->join('bank_master', 'bank_master.bank_id = student_request_refund.student_bank_name'); 
		$DB1->join('student_master', 'student_master.stud_id = student_request_refund.student_id'); 
		//
		if(isset($dataArr['academic_year']) && !empty($dataArr['academic_year'])){
			$DB1->where('student_request_refund.academic_year', $dataArr['academic_year']);
		}
		//
		if(isset($dataArr['request_status']) && !empty($dataArr['request_status'])){
			$DB1->where('student_request_refund.status', $dataArr['request_status']);
		}
		//
		if(isset($dataArr['request_month']) && !empty($dataArr['request_month'])){
			$DB1->where('MONTH(student_request_refund.created_on)', $dataArr['request_month']);
		}
		 
		if(isset($dataArr['request_type']) && !empty($dataArr['request_type'])){
			$DB1->where('student_request_refund.request_type', $dataArr['request_type']);
		}
		
		if($_SESSION['role_id'] == 20 && (isset($dataArr['stream_id']) && !empty($dataArr['stream_id']))){
			 $streamIds = array_column($dataArr['stream_id'], 'ums_stream_id');
			$DB1->where_in('student_master.admission_stream', $streamIds);
		}
		
		if($_SESSION['role_id'] == 2 && empty($dataArr['request_status'])){
			$DB1->where_in('student_request_refund.status', 'hod_approved');
		}
		
		//
		$DB1->order_by('student_request_refund.id','desc');
		$query = $DB1->get();
		//echo $DB1->last_query();exit;
		$result = $query->result_array();
		return $result;	
	}



	
}