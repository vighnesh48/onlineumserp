<?php
class Reminder_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }

	/////////////////Reminder/////////////////
	  public function get_all_reminders() {
        return $this->db
            ->where('status',1)
            ->order_by('reminder_date','ASC')
            ->get('reminder_master')
            ->result_array();
    }

    public function insert_reminder($data) {
        return $this->db->insert('reminder_master', $data);
    }

    public function update_reminder($id, $data) {
        return $this->db->where('id', $id)->update('reminder_master', $data);
    }

    public function reminder_by_id($id) {
        return $this->db->where('id',$id)->get('reminder_master')->row_array();
    }

    public function delete_reminder($id) {
        return $this->db->where('id',$id)->update('reminder_master',['status'=>0]);
    }
	/////////////END///////////////////////
  
}