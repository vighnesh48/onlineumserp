<?php
class Syllabus_model extends CI_Model {

    public function getTopicsWithSubtopics11($subject_id,$campus_id) {
		$DB3 = $this->load->database('obe', TRUE);
        $DB3->where('subject_id', $subject_id);
		$DB3->order_by('topic_order', 'ASC');
		$topics = $DB3->get('syllabus_topics')->result_array();

		foreach ($topics as &$topic) {
			$DB3->where('topic_id', $topic['topic_id']);
			$DB3->order_by('subtopic_order', 'ASC');
			$topic['subtopics'] = $DB3->get('syllabus_subtopics')->result_array();
		}

		return $topics;
    }
	public function getTopicsWithSubtopics($subject_id, $campus_id) {
    $DB3 = $this->load->database('obe', TRUE);

    // Get all topics for this subject
    $DB3->where('subject_id', $subject_id);
    $DB3->order_by('topic_order', 'ASC');
    $topics = $DB3->get('syllabus_topics')->result_array();
	//echo $DB3->last_query();exit;
    // Loop through each topic and fetch subtopics only if they exist
    foreach ($topics as &$topic) {
        $DB3->where('topic_id', $topic['topic_id']);
        $DB3->order_by('subtopic_order', 'ASC');
        $subtopics = $DB3->get('syllabus_subtopics')->result_array();

        $topic['subtopics'] = (!empty($subtopics)) ? $subtopics : [];
    }
	
    return $topics;
}


    public function insertTopic($data) {
		$DB3 = $this->load->database('obe', TRUE);
        $DB3->insert('syllabus_topics', $data);
        return $DB3->insert_id();
    }

    public function getTopic($id) {
		$DB3 = $this->load->database('obe', TRUE);
        return $DB3->get_where('syllabus_topics', ['topic_id' => $id])->row_array();
    }

    public function updateTopic($id, $data) {
		$DB3 = $this->load->database('obe', TRUE);
        $DB3->where('topic_id', $id)->update('syllabus_topics', $data);
    }

    public function deleteTopic($id) {
		$DB3 = $this->load->database('obe', TRUE);
        $DB3->delete('syllabus_topics', ['topic_id' => $id]);
    }

    public function insertSubtopic($data) {
		$DB3 = $this->load->database('obe', TRUE);
        $DB3->insert('syllabus_subtopics', $data);
    }

    public function getSubtopic($id) {
		$DB3 = $this->load->database('obe', TRUE);
        return $DB3->get_where('syllabus_subtopics', ['subtopic_id' => $id])->row_array();
    }

    public function updateSubtopic($id, $data) {
		$DB3 = $this->load->database('obe', TRUE);
        $DB3->where('subtopic_id', $id)->update('syllabus_subtopics', $data);
    }

    public function deleteSubtopic($id) {
		$DB3 = $this->load->database('obedel', TRUE);
        $DB3->delete('syllabus_subtopics', ['subtopic_id' => $id]);
    }

    public function addReference($subtopic_id, $data) {
        $data['subtopic_id'] = $subtopic_id;
        $DB3->insert('syllabus_references', $data);
    }

    public function getReferences($subtopic_id) {
        return $DB3->get_where('syllabus_references', ['subtopic_id' => $subtopic_id])->result_array();
    }
	
	public function getSubjectById($subject_id,$campus_id) {
			if($campus_id==1){
				$DB2 = $this->load->database('umsdb', TRUE);
			}elseif($campus_id==2){
				$DB2 = $this->load->database('sjumsdb', TRUE);
			}else{
				$DB2 = $this->load->database('sfumsdb', TRUE);
			}
			
		return $DB2->get_where('subject_master', ['sub_id' => $subject_id])->row_array();
	}
	public function getProgramById($subject_id,$campus_id) {
			if($campus_id==1){
				$DB2 = $this->load->database('umsdb', TRUE);
			}elseif($campus_id==2){
				$DB2 = $this->load->database('sjumsdb', TRUE);
			}else{
				$DB2 = $this->load->database('sfumsdb', TRUE);
			}
			
		return $DB2->get_where('vw_stream_details', ['stream_id' => $subject_id])->row_array();
	}
	public function get_topics_with_subtopics($subject_id) {
        $this->db->where(['subject_id' => $subject_id, 'is_main_topic' => 1]);
        $topics = $this->db->get('topic_master')->result_array();

        foreach($topics as &$topic) {
            $this->db->where(['topic_id' => $topic['id'], 'is_main_topic' => 0]);
            $topic['subtopics'] = $this->db->get('subtopic_master')->result_array();
        }
        return $topics;
    }
	

	public function deleteSyllabusBySubjectId($subject_id,$campus_id) {
		$DB3 = $this->load->database('obedel', TRUE);

		// Step 1: Fetch all topic IDs for the subject
		$topic_ids = $DB3->select('topic_id')
						 ->from('syllabus_topics')
						 ->where('subject_id', $subject_id)
						 ->where('campus_id', $campus_id)
						 ->get()
						 ->result_array();

		// Step 2: Extract topic_id values into a flat array
		$ids = array_column($topic_ids, 'topic_id');

		// Step 3: Delete subtopics only if there are topic_ids
		if (!empty($ids)) {
			$DB3->where_in('topic_id', $ids);
			$DB3->delete('syllabus_subtopics');
		}

		// Step 4: Delete topics
		$DB3->where('subject_id', $subject_id);
		$DB3->where('campus_id', $campus_id);
		return $DB3->delete('syllabus_topics');
	}

}
