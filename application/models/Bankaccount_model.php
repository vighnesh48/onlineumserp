<?php
class Bankaccount_model extends CI_Model {

    private $table = "bank_accounts";

    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    public function get($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        //echo $this->db->last_query();exit;
    }

    public function update($id, $data) {
		
        $this->db->where('id', $id)->update($this->table, $data);
		//echo $this->db->last_query();exit;
    }

    public function delete($id) {
        $this->db->delete($this->table, ['id' => $id]);
    }
	public function exists($account_no, $ifsc) {
        $this->db->where('account_number', $account_no);  // make sure this column exists
        $this->db->where('ifsc_code', $ifsc);              // make sure this column exists
        $query = $this->db->get('bank_accounts');     // make sure this table exists
		//echo $this->db->last_query();exit;
    
        if (!$query) {
            // debugging: show error if query failed
            $error = $this->db->error();
            log_message('error', 'DB Error in exists(): ' . print_r($error, true));
            return false;
        }

        return $query->num_rows() > 0;
    }
}
