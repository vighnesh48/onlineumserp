<?php
class Cia_examsession_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();

    }

    function get_cia_exam_session_details($session_id = '')
    {

        $secondDB = $this->load->database('umsdb', TRUE);
        $secondDB->select("*");
        $secondDB->from("cia_exam_session");
        if (($session_id)) {
            $secondDB->where("cia_exam_id", $session_id);
        }
        $secondDB->order_by("cia_exam_id", 'ASC');
        $query = $secondDB->get();

        //  echo $secondDB->last_query();exit;
        if (($session_id)) {

            return $query->row();
        } else {
            return $query->result();
        }
    }

    function add_cia_exam_session_details($data = array())
    {


        $secondDB = $this->load->database('umsdb', TRUE);
        $secondDB->insert("cia_exam_session", $data);
        //  echo $secondDB->last_query();exit;
        return $secondDB->insert_id();


    }

    function check_already_exists($data = array(), $id = "")
    {


        $secondDB = $this->load->database('umsdb', TRUE);
        $secondDB->select("*");
        $secondDB->from("cia_exam_session");
        $secondDB->where("academic_year", $data['academic_year']);
        $secondDB->where("subject_component", $data['subject_component']);
        $secondDB->where("cia_exam_name", $data['cia_exam_name']);
        $secondDB->where("cia_exam_type", $data['cia_exam_type']);
        if ($id) {
            $secondDB->where("id !=", $id);
        }
        $query = $secondDB->get()->row();
        if (!empty($query)) {
            return false;
        } else {
            return true;
        }
    }

    function update_session_details($update_array = array(), $id = "")
    {
        // error_reporting(E_ALL);
        $secondDB = $this->load->database('umsdb', TRUE);
        $where = array("id" => $id);
        $secondDB->where($where);
        $secondDB->update("academic_session", $update_array);
        return $secondDB->affected_rows();


    }

    function check_already_exists_dates($data = array(), $id = "")
    {


        $secondDB = $this->load->database('umsdb', TRUE);
        $secondDB->select("*");
        $secondDB->from("cia_exam_session");
        $secondDB->where("cia_exam_id", $data['cia_exam_id']);
        if ($id) {
            $secondDB->where("id !=", $id);
        }
        $query = $secondDB->get()->row();
        // echo $secondDB->last_query();exit;
        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }
    function add_cia_exam_session_details_dates($data = array())
    {
        $secondDB = $this->load->database('umsdb', TRUE);
        $secondDB->insert("cia_exam_session", $data);
        // echo $secondDB->last_query();exit;
        return $secondDB->insert_id();


    }
    function update_cia_exam_session_details_dates($data = array())
    {
        $secondDB = $this->load->database('umsdb', TRUE);
        $secondDB->where("cia_exam_id", $data['cia_exam_id']);
        $secondDB->update("cia_exam_session", $data);
        //echo $secondDB->last_query();exit;
        return true;


    }
    function get_ex_ses_details($session_id)
    {
        $secondDB = $this->load->database('umsdb', TRUE);
        $secondDB->select("*");
        $secondDB->from("cia_exam_session");
        if (($session_id)) {
            $secondDB->where("cia_exam_id", $session_id);
        }
        $secondDB->order_by("cia_exam_id", 'desc');
        $query = $secondDB->get();

        // echo $secondDB->last_query();exit;
        if (($session_id)) {

            return $query->row();
        } else {
            return $query->result();
        }
    }

    function get_academic_session(){
        $secondDB = $this->load->database('umsdb', TRUE);
        $secondDB->select("*");
        $secondDB->from("academic_session");
        $secondDB->where("academic_year",ACADEMIC_YEAR);
        $secondDB->where("currently_active",'Y');
        $query = $secondDB->get();
      //  echo $secondDB->last_query();exit;
        return $query->row();
    }
}