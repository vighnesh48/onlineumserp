<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_master_model extends CI_Model
{
    protected $umsdb;   // second DB connection

    public function __construct()
    {
        parent::__construct();
        // Load second DB (umsdb)
        $this->umsdb = $this->load->database('umsdb', TRUE);
    }

    public function get_all_active()
    {
        return $this->umsdb
            ->where('is_active', 'Y')
            ->order_by('course_id, stream_id, semester, subject_name', 'ASC')
            ->get('subject_master')
            ->result();
    }

    public function get($sub_id)
    {
        return $this->umsdb
            ->get_where('subject_master', ['sub_id' => $sub_id])
            ->row();
    }

    /**
     * Returns subjects assigned to a faculty from lecture_time_table
     */
    public function get_by_faculty($faculty_identifier)
    {
        $db = $this->umsdb;

        $db->distinct();
        $db->select('sm.*');
        $db->from('lecture_time_table ltt');

        // CASE 1 — BEST CASE: ltt.sub_title_id = sm.sub_id
        if ($db->field_exists('sub_title_id', 'lecture_time_table')) {

            $db->join('subject_master sm', 'ltt.subject_code = sm.sub_id', 'inner');

        } else {
            // CASE 2 — if subject_code stores sub_id
            $db->join('subject_master sm', 'TRIM(ltt.subject_code) = TRIM(CAST(sm.sub_id AS CHAR))', 'inner');
        }

        // Faculty assignment
        if (is_string($faculty_identifier) && trim($faculty_identifier) !== '') {
            $db->where('ltt.faculty_code', $faculty_identifier);
        } else {
            // numeric fallback
            $db->where('ltt.inserted_by', $faculty_identifier);
        }

        $db->where('ltt.is_active', 'Y');
        $db->order_by('sm.course_id, sm.stream_id, sm.semester, sm.subject_name', 'ASC');
		
        return $db->get()->result();
    }
}
