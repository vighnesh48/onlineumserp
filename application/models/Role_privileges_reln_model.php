<?php
class Role_privileges_reln_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_mapping_details($roles_id='')
    {
        $where='';
        if($roles_id!="")
        {
            $where=" AND rmr.roles_id='".$roles_id."'";
        }
                
        $sql="SELECT rm.roles_name,group_concat( distinct menu_name) menu_name,rmr.rmr_id,rm.roles_id
                FROM role_menu_reln rmr
                INNER JOIN menu_master mm on rmr.menu_id=mm.menu_id
                INNER JOIN roles_master rm on rm.roles_id=rmr.roles_id
                WHERE rmr.status='Y' AND mm.status='Y' AND mm.status='Y'  $where              
                ORDER BY mm.parent,seq";              
        $query = $this->db->query($sql);
        return $query->result_array();
    } 
  
    function  get_roles_details($roles_id='')
    {
        $where=" WHERE status='Y'";
        if($roles_id!="")
        {
            $where=" AND r.roles_id='".$roles_id."'";
        }
                
        $sql="SELECT roles_id,roles_name,roles_type FROM roles_master $where ";               
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
    
    function  get_access_details($roles_id='',$privileges_id='')
    {
        $where="WHERE rmr.status='Y' AND rm.status='Y' AND mm.status='Y' ";
        if($roles_id!="")
        {
            $where.=" AND rmr.roles_id='".$roles_id."'";
        }
        if($privileges_id!="")
        {
            $where.=" AND rmr.privileges_id='".$privileges_id."'";
        }
                
        /*$sql="SELECT rmr.rmr_id,rmr.roles_id,rmr.menu_id
                FROM role_menu_reln rmr
                INNER JOIN menu_master mm on rmr.menu_id=mm.menu_id
                INNER JOIN roles_master rm on rm.roles_id=rmr.roles_id
                WHERE rmr.status='Y' AND mm.status='Y' AND mm.status='Y'  $where              
                ORDER BY mm.parent,seq";     */          
        $sql="  SELECT rmr.menu_id,mm.menu_name,rm.roles_id,rm.roles_name,pm.privileges_id,IFNULL(pm.privileges_name,'')privileges_name
                FROM role_menu_reln rmr
                INNER JOIN roles_master rm on rmr.roles_id=rm.roles_id
                INNER JOIN menu_master mm on mm.menu_id=rmr.menu_id
                INNER JOIN menu_privileges_reln mpr on mpr.menu_id=rmr.menu_id AND mpr.privileges_id=rmr.privileges_id
                LEFT JOIN privileges_master pm on pm.privileges_id=rmr.privileges_id
                $where
                ORDER BY rmr.menu_id ";
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }
    
    function get_not_found_rows($in,$roles_id)
    {       
        $sql=" select rmr.rmr_id,rmr.menu_id,rmr.roles_id from  role_menu_reln rmr where menu_id not in ($in) AND rmr.roles_id='".$roles_id."' ";            
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }
    
    function get_menuwise_privileges($menu_id='',$privileges_id='')
    {
        $where=" WHERE mpr.status='Y' AND mm.status='Y' AND pm.status='Y' ";
        if($menu_id!='')
        {
            $where.=" AND mpr.menu_id='".$menu_id."'";
        }
        if($privileges_id!='')
        {
            $where.=" AND mpr.privileges_id='".$privileges_id."'";
        }
        
        $sql="  SELECT mpr.menu_id,pm.privileges_id,pm.privileges_name
                FROM menu_privileges_reln mpr 
                INNER JOIN menu_master mm on mm.menu_id=mpr.menu_id
                INNER JOIN privileges_master pm on pm.privileges_id=mpr.privileges_id
                $where
                ORDER BY mpr.menu_id,pm.privileges_id";            
        $query = $this->db->query($sql);
        $array=$query->result_array();
        $array2=array();
        for($i=0;$i<count($array);$i++)
        {
            $array2[$array[$i]['menu_id']]['privileges_id'][]=$array[$i]['privileges_id'];
            $array2[$array[$i]['menu_id']]['privileges_name'][]=$array[$i]['privileges_name'];
        }
        return $array2;
    }
    /*
    function get_mapping_details_new($roles_id='',$menu_id='',$p)
    {
        $where='';
        if($roles_id!="")
        {
            $where=" AND rmr.roles_id='".$roles_id."'";
        }
                
        $sql="SELECT rm.roles_name,mm.menu_name,pm.privileges_name,rmr.rmr_id
                FROM role_menu_reln rmr 
                INNER JOIN roles_master rm on rm.roles_id=rmr.roles_id
                INNER JOIN menu_master mm on mm.menu_id=rmr.menu_id
                RIGHT JOIN privileges_master pm on pm.privileges_id=rmr.privileges_id
                WHERE rmr.status='Y' AND rm.status='Y' AND mm.status='Y' AND pm.status='Y'
                GROUP BY rm.roles_name,mm.menu_name,pm.privileges_name
                ORDER BY rm.roles_id,mm.parent,mm.seq";              
        $query = $this->db->query($sql);
        return $query->result_array();
    } */
    
}