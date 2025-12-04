<?php

class Ecrhallmodel extends CI_Model {

    /////////////////////////////////////////////////// code by Pj ////////////////////////////////////////////////
    public function getExamCenters() {
        $DB1 = $this->load->database('umsdb', TRUE);

        return $DB1->select('ec_id, center_name, center_code')
            ->where('is_active', 'Y')
            ->get('exam_center_master')
            ->result();
    }

    public function getfloors() {
        $DB1 = $this->load->database('umsdb', TRUE);

        return $DB1->select('floor_id, floor_name')
            ->where('status', '1')
            ->get('floor_master')
            ->result();
    }

    public function saveHall($data) {
        $DB1 = $this->load->database('umsdb', TRUE);
        return $DB1->insert('hall_master', $data);
    }
    public function getHallById($hall_id) {
        $DB1 = $this->load->database('umsdb', TRUE);

        return $DB1->select('*')
            ->where('id', $hall_id)
            ->get('hall_master')
            ->row();
    }
    public function updateHallById($hall_id, $data) {
        $DB1 = $this->load->database('umsdb', TRUE);
        return $DB1->where('id', $hall_id)
            ->update('hall_master', $data);
    }
    public function getAllHalls($hal_id) {
        $DB1 = $this->load->database('umsdb', TRUE);

        return $DB1->select('*')
            ->where('building_id', $hal_id['building_filter'])
            ->get('hall_master')
            ->result();
    }
    public function getExamSessions() {
        $DB1 = $this->load->database('umsdb', TRUE);

        return $DB1->select('exam_id, exam_name')
            ->where('is_active', 'Y')
            ->get('exam_session')
            ->result();
    }

    public function getBuildings(){
        $DB1 = $this->load->database('umsdb', TRUE);

        return $DB1->select('id, building_name')
            ->get('building_master')
            ->result();

    }

    public function saveExamCenterBuilding($data){
        $DB1 = $this->load->database('umsdb', TRUE);
        return $DB1->insert('exam_center_building_allocation', $data);
    }

       
    
   
        
     /////////////////////////////////////////////////// end /////////////////////////////////////////////////////

        
}
