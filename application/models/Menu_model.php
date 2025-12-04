<?php
class Menu_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_menu_details($menu_id='',$parent='')
    {
        $where=" WHERE 1=1 ";  
        
        if($menu_id!="")
        {
            $where.=" AND menu_id='".$menu_id."'";
        }
        if($parent!="")
        {
            $where.=" AND parent='".$parent."'";
        }
        $sql="select menu_id,menu_name,path,icon,parent,seq,status From menu_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } 
    
    function  get_menu_details_search($para='')
    {
        $where=" WHERE 1=1 ";  
        
        if($para!="")
        {
            $where.=" AND menu_name like '%".$para."%' OR path like '%".$para."%' OR icon like '%".$para."%' OR parent like '%".$para."%' OR parent like '%".$para."%' OR seq like '%".$para."%' ";
        }
        
        $sql="select menu_id,menu_name,path,icon,parent,seq,status From menu_master $where "; 
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
}