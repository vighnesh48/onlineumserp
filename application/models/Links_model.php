<?php
class Links_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }

	/////////////////Blogs/////////////////
	
 public function get_all_links()
    {
        return $this->db->where('status',1)
                        ->order_by('id','DESC')
                        ->get('links_master')
                        ->result_array();
    }

    public function insert_link($data)
    {
        return $this->db->insert('links_master', $data);
    }

    public function update_link($id, $data)
    {
        return $this->db->where('id', $id)->update('links_master', $data);
    }

    public function get_link_by_id($id)
    {
        return $this->db->where('id', $id)->get('links_master')->row_array();
    }

    public function delete_link($id)
    {
        return $this->db->where('id', $id)->update('links_master', ['status' => 0]);
    }
	/////////////END///////////////////////
  
}