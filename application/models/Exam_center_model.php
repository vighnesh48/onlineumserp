

<?php
class Exam_center_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('umsdb', TRUE);
    }

    public function get_exam_center_master_details($ec_id='')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $where=" WHERE 1=1 ";  
        
        if($ec_id!="")
        {
            $where.=" AND ec_id='".$ec_id."'";
        }
        
        $sql="select * From exam_center_master $where ";
       
        $query = $DB1->query($sql); 
        //echo $DB1->last_query();exit;
        if($query !== FALSE && $query->num_rows() > 0){
            foreach ($query->result_array() as $row) {
            $data[] = $row;
            }
        }
        return $data;
    }

    function  get_exam_center_master_details_search($ec_id='')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $where=" WHERE 1=1 ";  
        
        if($ec_id!="")
        {
            $where.=" AND ec_id='".$ec_id."'";
        }
        
        $sql="select * From exam_center_master $where ";
       
        $query = $DB1->query($sql); 
        if($query !== FALSE && $query->num_rows() > 0){
            foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        }

    return $data;
    }

}
