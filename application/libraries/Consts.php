<?php
class Consts
{
    private $CI;
    public function __construct()
    {
        $this->CI = & get_instance();
        $current_session =$this->fetchCurrSession();
    }
    Public function fetchCurrSession()
    {
		$DB1 = $this->CI->load->database('umsdb', TRUE);	
		$sql = "SELECT * FROM `academic_session` WHERE `currently_active` ='Y'";		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		if($res[0]['academic_session']=='WINTER'){
			$current_session = 'WIN';
		}else{
			$current_session = 'SUM';
		}
		//echo $current_session;exit;
        return $current_session;
    }
	Public function fetchCurrSession_feedback()
    {
		$DB1 = $this->CI->load->database('umsdb', TRUE);	
		$sql = "SELECT * FROM `academic_session` WHERE `active_for_feedback` ='Y'";		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		if($res[0]['academic_session']=='WINTER'){
			$current_session = 'WIN';
		}else{
			$current_session = 'SUM';
		}
		//echo $current_session;exit;
        return $current_session;
    }
	Public function fetchActiveSession()
    {
		$DB1 = $this->CI->load->database('umsdb', TRUE);	
		$sql = "SELECT * FROM `academic_session` WHERE `currently_active` ='Y'";		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		if($res[0]['academic_session']=='WINTER'){
			$current_session = 'WIN';
		}else{
			$current_session = 'SUM';
		}
		//echo $current_session;exit;
        return $current_session.'~'.$res[0]['academic_year'].'~'.$res[0]['feedback_cycle'];
    }
Public function fetchActiveSession_feedback()
    {
		$DB1 = $this->CI->load->database('umsdb', TRUE);	
		$sql = "SELECT * FROM `academic_session` WHERE `active_for_feedback` ='Y'";		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		if($res[0]['academic_session']=='WINTER'){
			$current_session = 'WIN';
		}else{
			$current_session = 'SUM';
		}
		//echo $current_session;exit;
        return $current_session.'~'.$res[0]['academic_year'].'~'.$res[0]['feedback_cycle'];
    }
     Public function fetchCurrSessionacademic()
    {
		$DB1 = $this->CI->load->database('umsdb', TRUE);	
		$sql = "SELECT academic_year FROM `academic_session` WHERE `currently_active` ='Y'";		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		
        return $res;
    }
}