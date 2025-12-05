<?php
class Blogs_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }

	/////////////////Blogs/////////////////
	
	public function get_all_blogs() {
        return $this->db->where('status',1)->order_by('id','DESC')->get('blogs_master')->result_array();
    }

    public function insert_blog($data) {
        return $this->db->insert('blogs_master',$data);
    }

    public function update_blog($id,$data) {
        return $this->db->where('id',$id)->update('blogs_master',$data);
    }

    public function blog_by_id($id) {
        return $this->db->where('id',$id)->get('blogs_master')->row_array();
    }

    public function delete_blog($id) {
        return $this->db->where('id',$id)->update('blogs_master',['status'=>0]);
    }
   
	/////////////END///////////////////////
  
}