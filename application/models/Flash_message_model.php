<?php
class Flash_message_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }

  public function get_all_flash() {
        return $this->db
            ->where('status', 1)
            ->order_by('id', 'DESC')
            ->get('flash_messages')
            ->result_array();
    }

    public function flash_by_id($id) {
        return $this->db->where('id', $id)->get('flash_messages')->row_array();
    }

    public function insert_flash($data) {
        return $this->db->insert('flash_messages', $data);
    }

    public function update_flash($id, $data) {
        return $this->db->where('id',$id)->update('flash_messages', $data);
    }

    public function delete_flash($id) {
        return $this->db->where('id',$id)->update('flash_messages',['status'=>0]);
    }
	/////////////END///////////////////////
  
}