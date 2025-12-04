<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assignment_question_bank_model extends CI_Model {

    protected $table = 'assignment_question_bank';
	
    public function __construct() {
        parent::__construct();
		$DB3 = $this->load->database('obe', TRUE);
    }

    // Get all questions (with optional filters)
    public function get_all($where = [], $order_by = 'id DESC') {
		$DB3 = $this->load->database('obe', TRUE);
        if (!empty($where)) {
            $DB3->where($where);
        }
        $DB3->order_by($order_by);
        return $DB3->get($this->table)->result();
    }
	public function get_all_questions($subject_id, $campus_id, $filters = [])
	{
		$this->db = $this->load->database('obe', TRUE);
		$this->db->select('aq.*, t.topic_title,t.topic_order,st.srno, st.subtopic_title');
		$this->db->from('assignment_question_bank aq');
		$this->db->join('syllabus_topics t', 'aq.topic_id = t.topic_id', 'left');
		$this->db->join('syllabus_subtopics st', 'aq.subtopic_id = st.subtopic_id', 'left');
		$this->db->where('aq.subject_id', $subject_id);
		$this->db->where('aq.campus_id', $campus_id);

		if (!empty($filters['topic_id'])) {
			$this->db->where('aq.topic_id', $filters['topic_id']);
		}
		if (!empty($filters['course_outcome'])) {
			$this->db->where('aq.course_outcome', $filters['course_outcome']);
		}
		if (!empty($filters['blooms_level_id'])) {
			$this->db->where('aq.blooms_level_id', $filters['blooms_level_id']);
		}

		#$this->db->order_by('aq.created_at', 'DESC');
		$this->db->order_by('t.topic_order', 'asc');
		$this->db->order_by('st.srno', 'asc');
		$query = $this->db->get();
//echo  $this->db->last_query();exit;
		if (!$query) {
			// Log or print last query for debugging
			log_message('error', 'Query failed in get_all_questions: ' . $this->db->last_query());
			return []; // Return empty array on failure
		}

		return $query->result();
	}


	public function get_blooms_levels($table) {
		$DB3 = $this->load->database('obe', TRUE);
        return $DB3->get($table)->result();
    }
    // Get single question by ID or condition
    public function get_by_id($id) {
		$DB3 = $this->load->database('obe', TRUE);
        return $DB3->get_where($this->table, ['id' => $id])->row();
		 //echo $DB3->last_query();exit;
    }

    // Insert new question
    public function insert($data) {
		$DB3 = $this->load->database('obe', TRUE);
        $DB3->insert($this->table, $data);
		//echo $DB3->last_query();exit;
        return $DB3->insert_id();
    }

    // Update question by ID
    public function update($id, $data) {
		$DB3 = $this->load->database('obe', TRUE);
        return $DB3->update($this->table, $data, ['id' => $id]);
		//echo $DB3->last_query();exit;
    }

    // Delete question by ID
    public function delete($id) {
		$DB3 = $this->load->database('obedel', TRUE);
        return $DB3->delete($this->table, ['id' => $id]);
    }

    // Count questions with filters (optional)
    public function count($where = []) {
        if (!empty($where)) {
            $DB3->where($where);
        }
        return $DB3->count_all_results($this->table);
    }
	/* public function get_by_id($id) {
		return $this->db->get_where('assignment_question_bank', ['id' => $id])->row();
	}

	public function update($id, $data) {
		$this->db->where('id', $id);
		return $this->db->update('assignment_question_bank', $data);
	} */

}
