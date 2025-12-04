<?php
class Institutes_vision_model extends CI_Model {

    public function get_all() {
		$DB3 = $this->load->database('obe', TRUE); // for institutes_vision
		$DB2 = $this->load->database('umsdb', TRUE); // for school_master (different DB)

		$db3Name = $DB3->database;
		$db2Name = $DB2->database;

		$sql = "
			SELECT v.*, s.school_name
			FROM {$db3Name}.institutes_vision AS v
			LEFT JOIN {$db2Name}.school_master AS s ON v.institutes_id = s.school_id
		";

		return $DB3->query($sql)->result();
		}

    public function get_by_id($id) {
		$DB3 = $this->load->database('obe', TRUE);
        return $DB3->get_where('institutes_vision', ['id' => $id])->row();
    }

    public function insert($data) {
		$DB3 = $this->load->database('obe', TRUE);
        return $DB3->insert('institutes_vision', $data);
    }

    public function update($id, $data) {
		$DB3 = $this->load->database('obe', TRUE);
        return $DB3->where('id', $id)->update('institutes_vision', $data);
    }

    public function delete($id) {
		$DB3 = $this->load->database('obe', TRUE);
        return $DB3->where('id', $id)->delete('institutes_vision');
    }

    public function get_institutes($campus_id) {
		if($campus_id==1){
			$DB2 = $this->load->database('umsdb', TRUE);
		}elseif($campus_id==2){
			$DB2 = $this->load->database('sjumsdb', TRUE);
		}else{
			$DB2 = $this->load->database('sfumsdb', TRUE);
		}
        return $DB2->where('is_active', 'Y')->get('school_master')->result();// Assuming institutes table exists
    }
}
