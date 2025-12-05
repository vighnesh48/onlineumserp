<?php
class Faqs_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }

	/////////////////Blogs/////////////////
		
	 public function get_all_faqs()
{
    return $this->db->where('status', 1)->order_by('order_no','ASC')->get('faq_master')->result_array();
}
    public function insert_faq($data)
    {
        return $this->db->insert('faq_master', $data);
    }

    public function update_faq($id, $data)
    {
        return $this->db->where('id', $id)->update('faq_master', $data);
    }

    public function get_faq_by_id($id)
    {
        return $this->db->where('id', $id)->get('faq_master')->row_array();
    }

		 public function delete_faq($id)
		{
			$data = [
				'status' => 0,
				'updated_at' => date('Y-m-d H:i:s')
			];

			return $this->db->where('id', $id)->update('faq_master', $data);
		}
	/////////////END///////////////////////
  
}