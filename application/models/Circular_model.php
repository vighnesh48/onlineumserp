<?php
class Circular_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function insert_circuler_data($data) {
        $arr['title']= $data['title'];
        $arr['file_attachment'] = $data['fname'];
		$arr['circular_type'] = $data['circular_type'];
        $arr['inserted_date']=date("Y-m-d H:i:s");
        $arr['inserted_by']= $this->session->userdata("uid");
     $ins=  $this->db->insert('circular_notice', $arr);
//echo $this->db->last_query();
     return $ins;
    }
function get_circuler_list($id='',$type=''){
	$wh='';
    if($id != ''){
        $wh .= 'and cid="'.$id.'"';
    }
	if($type != ''){
        $wh .= 'and circular_type="'.$type.'"';
    }
    $sql="select * from circular_notice where status='N' ".$wh." order by cid desc limit 7";
     $query=$this->db->query($sql);
     return $query->result_array();
}
   function get_delete_cirular($cid){
    
        $this->db->where('cid',$cid);
       
        $this->db->set('status','Y');   
         $this->db->set('updated_by',$this->session->userdata("uid"));   
         $this->db->set('updated_date',date("Y-m-d H:i:s"));     
        $this->db->update('circular_notice');
         return ($this->db->affected_rows() != 1) ? false : true;
   }
   function update_circuler_details($data){
     $this->db->where('cid',$data['cid']);
       
       $this->db->set('title',$data['title']);
	   $this->db->set('circular_type',$data['circular_type']);
       if($data['fname']!=''){
         $this->db->set('file_attachment',$data['fname']);   
       }
         $this->db->set('updated_by',$this->session->userdata("uid"));   
         $this->db->set('updated_date',date("Y-m-d H:i:s"));     
        $this->db->update('circular_notice');
         return ($this->db->affected_rows() != 1) ? false : true;
   }
}
