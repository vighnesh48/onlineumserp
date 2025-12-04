<?php
class Conference_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
        
        $DB1 = $this->load->database('umsdb', TRUE); 
    }
    //get courses offered by college

	public function appli_details($appid)
	{
		$DB1 = $this->load->database('univerdb', TRUE);
		$DB1->select("*");
		$DB1->from('conference_details');
		if($appid!='')
		$DB1->where("id",$appid);
	
		$query=$DB1->get();
		$result=$query->result_array();
		return $result;  
	}
	public function get_count_stream_appli_details(){
		$DB1 = $this->load->database('univerdb', TRUE);
		$DB1->select("count(stream) as cnt,stream");
		$DB1->from('conference_details');		
		$DB1->group_by('stream');	
		$query=$DB1->get();
		$result=$query->result_array();
		return $result;  
	}
public function appli_details_bystream($strm)
	{
		$DB1 = $this->load->database('univerdb', TRUE);
		$DB1->select("*");
		$DB1->from('conference_details');
		if($strm!='')
		$DB1->where("stream",$strm);
	
		$query=$DB1->get();
		$result=$query->result_array();
		return $result;  
	}
	
	public function icemelt2018_appli_details($appid='')
	{
		$DB1 = $this->load->database('univerdb', TRUE);
		$DB1->select("c.*,i.*");
		$DB1->from('conference_registrations c');
		
		$DB1->join("icemelt2018_online_payment i", "i.phone=c.mobile1 and i.registration_no=c.reg_id");
		if($appid!='')
		$DB1->where("reg_id",$appid);
	    $DB1->order_by("reg_id",DESC);
		$query=$DB1->get();
		$result=$query->result_array();
		return $result;  
	}
	
}