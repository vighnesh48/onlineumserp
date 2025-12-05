<?php
class Notification_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }

	/////////////////Blogs/////////////////
		
	 function get_streams_yearwise()
			{
				$DB1 = $this->load->database('umsdb', TRUE);

				$highest_qualification = $_POST['highest_qualification'];
				//$academic_year = $_POST['acyear'];

				$DB1->select("stream_id, stream_name, stream_short_name");
				$DB1->from("stream_master");
				//$DB1->where("sess_year", $academic_year);
				$DB1->where("is_active", 'Y');
				//$DB1->where("FIND_IN_SET('$highest_qualification', minium_qualifiction_for_admission) >", 0, FALSE);
				$DB1->order_by("stream_name", "ASC");

				return $DB1->get()->result_array();
			}

		
			public function insert_notification($data)
		{
		   return  $this->db->insert('notification_master', $data);
			 //echo $this->db->last_query();exit;
		}
		  function fetch_notification_data(){
			$sql="select nm.*,sm.stream_name  from onlineerp.notification_master as nm left join onlineadmission_ums.stream_master as sm on sm.stream_id=nm.applicable_course where nm.status='1'";
			$query=$this->db->query($sql);
			return $query->result_array();
		}
		
		  public function update_notification($id, $data)
		{
			return $this->db->where('id', $id)->update('notification_master', $data);
		}
		
		public function get_notifications($course, $semester)
		{
			$today = date('Y-m-d');

			$DB1 = $this->load->database('umsdb', TRUE);

			$DB1->select('*');
			$DB1->from('notification_master');
			$DB1->where('applicable_course', $course);
			$DB1->where('semester', $semester);
			$DB1->where('from_date <=', $today);
			$DB1->where('to_date >=', $today);
			$DB1->where('status', 1);
			$DB1->order_by('id', 'DESC');  // latest first

			return $DB1->get()->result_array();
		}
	/////////////END///////////////////////
  
}