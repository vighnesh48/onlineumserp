<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Live_attendance_model extends CI_Model {
    protected $table = 'live_attendance';

    public function mark($session_id, $student_id) {
        // Prevent duplicate attendance entry (optional)
        $exists = $this->db->get_where($this->table, [
            'session_id' => $session_id,
            'student_id' => $student_id
        ])->row();

        if (!$exists) {
            $this->db->insert($this->table, [
                'session_id' => $session_id,
                'student_id' => $student_id,
                'joined_at' => date('Y-m-d H:i:s')
            ]);
            return $this->db->insert_id();
        }
        return $exists->id;
    }
}
