<?php
class Menu_privileges_reln_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_mapping_details($menu_id='')
    {
        $where='';
        if($menu_id!="")
        {
            $where=" AND mpr.menu_id='".$menu_id."'";
        }
                
        $sql="  SELECT mm.menu_name,group_concat(distinct pm.privileges_name) privileges,mpr.mpr_id,mpr.menu_id,mpr.status
                FROM menu_privileges_reln mpr 
                INNER JOIN menu_master mm on mm.menu_id=mpr.menu_id
                LEFT JOIN privileges_master pm on pm.privileges_id=mpr.privileges_id
                WHERE mpr.status='Y' AND mm.status='Y' $where
                group by mm.menu_name
                ORDER by mm.parent,mm.seq ";               
        $query = $this->db->query($sql);
        return $query->result_array();
    } 
    
    function  get_mapping_details2($menu_id='')
    {
        $where='';
        if($menu_id!="")
        {
            $where=" AND mpr.menu_id='".$menu_id."'";
        }
                
        $sql="  SELECT mpr.mpr_id,mm.menu_name,mm.menu_id,pm.privileges_id,pm.privileges_name,mpr.status
                FROM menu_privileges_reln mpr 
                RIGHT JOIN menu_master mm on mm.menu_id=mpr.menu_id
                RIGHT JOIN privileges_master pm on pm.privileges_id=mpr.privileges_id
                WHERE mm.status='Y' $where                
                ORDER by mm.parent,mm.seq ";  
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function  get_privileges_details($para='')
    {
        $where=" WHERE status='Y' ";  
        
        if($para!="")
        {
            $where.=" AND privileges_id like '%".$para."%' OR privileges_name like '%".$para."%' ";
        }
        
        $sql="select privileges_id,privileges_name,status From privileges_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_not_found_rows($in,$menu_id)
    {       
        $sql=" select mpr.mpr_id,mpr.menu_id,mpr.privileges_id from  menu_privileges_reln mpr where privileges_id not in ($in) AND mpr.menu_id='".$menu_id."' ";            
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }
    function  get_menu_details()
    {
        $where=" WHERE status='Y' AND parent='0' ";  
                
        $sql="select menu_id,menu_name,path,icon,parent,seq,status From menu_master $where  order by parent,seq";
        $query = $this->db->query($sql);
        $return_array=array();                        
        $return_array["level_0"]= $query->result_array();
        
        for($i=0;$i<count($return_array["level_0"]);$i++)
        {
            $sql2="select menu_id,menu_name,path,icon,parent,seq,status From menu_master WHERE status='Y' AND parent='".$return_array["level_0"][$i]['menu_id']."'  order by parent,seq";
            $query2 = $this->db->query($sql2);
            if(count($query2->result_array())>0)
            {
                $return_array["level_1"][$return_array["level_0"][$i]['menu_id']]= $query2->result_array();     
            }
            
        }        
        return $return_array;
    } 
    
}