<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Live_session_model extends CI_Model {
    protected $table = 'live_sessions';

    public function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function list_all() {
        return $this->db->order_by('start_time','DESC')->get($this->table)->result();
    }
}
