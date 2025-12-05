<?php
class Announcement_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }

	/////////////////Announcement/////////////////
	public function get_all_announcements() {
        return $this->db
            ->where('status',1)
            ->order_by('announcement_date','DESC')
            ->get('announcement_master')
            ->result_array();
    }

    public function insert_announcement($data) {
        return $this->db->insert('announcement_master', $data);
    }

    public function update_announcement($id, $data) {
        return $this->db->where('id', $id)->update('announcement_master', $data);
    }

    public function announcement_by_id($id) {
        return $this->db->where('id',$id)->get('announcement_master')->row_array();
    }

    public function delete_announcement($id) {
        return $this->db->where('id',$id)->update('announcement_master', ['status'=>0]);
    }
	
	 public function get_all_reminders() {
        return $this->db
            ->where('status',1)
            ->order_by('reminder_date','ASC')
            ->get('reminder_master')
            ->result_array();
    }
	
	public function get_all_blogs() {
        return $this->db->where('status',1)->order_by('id','DESC')->get('blogs_master')->result_array();
    }
	 public function get_all_flash() {
        return $this->db
            ->where('status', 1)
            ->order_by('id', 'DESC')
            ->get('flash_messages')
            ->result_array();
    }


	/////////////END///////////////////////
  
}