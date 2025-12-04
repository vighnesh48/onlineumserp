<?php
class Inventory_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_inventory_details($inventory_id='')
    {
		$secondDB = $this->load->database('umsdb', TRUE);
       $role_id = $this->session->userdata('role_id');
	  
		$name = $this->session->userdata('name');
		
		
		
 
        $where=" WHERE 1=1 ";  
        
        if($inventory_id!="")
        {
            $where.=" AND i.id='".$inventory_id."'";
        }
		
		if($role_id==54){
			
			
			$where.=" and LOWER(school_name)='".strtolower($name)."'";
		}
        
        $sql="select i.*,s.school_name,si.size as size_name,p.product_name, il.total_quantity,
        il2.total_sale_quantity from inventory as i  
		LEFT JOIN schoolmaster as s On i.school_id=s.id 
		LEFT JOIN productsizemaster as si On i.product_size_id=si.id 
		LEFT JOIN productmaster as p On i.product_id=p.id 
		
		LEFT JOIN (
        SELECT
            SUM(quantity) AS total_quantity,
            product_id,
            product_size_id,
            school_id,
            gender
        FROM
            inventory_log
            where operation = 1
        GROUP BY
            product_id,
            product_size_id,
            school_id,
            gender
    ) il ON i.product_id = il.product_id
        AND i.product_size_id = il.product_size_id
        AND i.school_id = il.school_id
        AND i.gender = il.gender
        LEFT JOIN (
        SELECT
            SUM(quantity) AS total_sale_quantity,
            product_id,
            product_size_id,
            school_id,
            gender
        FROM
            inventory_log
            where operation = 2
        GROUP BY
            product_id,
            product_size_id,
            school_id,
            gender
    ) il2 ON i.product_id = il2.product_id
        AND i.product_size_id = il2.product_size_id
        AND i.school_id = il2.school_id
        AND i.gender = il2.gender
		$where ";
        $query = $secondDB->query($sql);
		//echo $secondDB->last_query();die;
        return $query->result_array();
		
    }  

    function get_school()
    {
		$secondDB = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$where=" WHERE 1=1 ";  
		$name = $this->session->userdata('name');
		if($role_id==54){
		$where.=" and LOWER(school_name)='".strtolower($name)."'";
		}
		
        $sql="select * from schoolmaster $where ";
        $query = $secondDB->query($sql);
		//echo $secondDB->last_query();die;
        return $query->result_array();
    }
	 function get_color()
    {
		$secondDB = $this->load->database('umsdb', TRUE);
        $sql="select * from colormaster";
        $query = $secondDB->query($sql);
		//echo $secondDB->last_query();die;
        return $query->result_array();
    }
	
	function get_product()
    {
		$secondDB = $this->load->database('umsdb', TRUE);
        $sql="select * from productmaster";
        $query = $secondDB->query($sql);
		//echo $secondDB->last_query();die;
        return $query->result_array();
    }
	
	 function get_size()
    {
		$secondDB = $this->load->database('umsdb', TRUE);
        $sql="select * from productsizemaster";
        $query = $secondDB->query($sql);
		//echo $secondDB->last_query();die;
        return $query->result_array();
    }
	
	function get_productbyid($pid)
	{
		$secondDB = $this->load->database('umsdb', TRUE);
        $sql="select * from productsizemaster where product_id=$pid";
        $query = $secondDB->query($sql);
        return $query->result();
	}
	function get_checkinventory($sid,$pid,$sizeid,$gender)
	{
		$secondDB = $this->load->database('umsdb', TRUE);
        $sql="select * from inventory where product_id=$pid AND product_size_id=$sizeid AND school_id=$sid and gender='$gender'";
        $query = $secondDB->query($sql);
        return $query->result();
	}
	function get_inout_uniform()
	{
		//echo"<pre>";
		//print_r($_SESSION);exit;
		$name = $this->session->userdata('name');
		$secondDB = $this->load->database('umsdb', TRUE);
		$sql="select sm.school_name,pr.product_name,ig.gender,ps.sizecode,sum(CASE WHEN ig.operation=1 THEN ig.quantity ELSE 0 END) as invalue,sum(CASE WHEN ig.operation=2 THEN ig.quantity ELSE 0 END) as outvalue from inventory_log ig left join schoolmaster sm on ig.school_id=sm.id left join productsizemaster ps on ig.product_size_id=ps.id left join productmaster pr on ig.product_id=pr.id WHERE school_name='$name' group by ig.school_id,ig.product_id,ig.product_size_id,ig.gender order by gender desc";
		$query = $secondDB->query($sql);
        return $query->result_array();
	}	
	  function  get_inventory_history($inventory_id='')
    {
		$secondDB = $this->load->database('umsdb', TRUE);
       $role_id = $this->session->userdata('role_id');
	  
		$name = $this->session->userdata('name');
		
		
		
 
        $where=" WHERE 1=1 ";  
        
        if($inventory_id!="")
        {
            $where.=" AND i.id='".$inventory_id."'";
        }
		
		if($role_id==54){
			
			
			$where.=" and LOWER(school_name)='".strtolower($name)."'";
		}
        
        $sql="SELECT i.id,il.created_at,il.id , il.operation, il.quantity, s.school_name,il.gender,
        si.size AS size_name,
        p.product_name
FROM inventory AS i
JOIN inventory_log AS il ON i.product_id = il.product_id
                         AND i.product_size_id = il.product_size_id
                         AND i.school_id = il.school_id
                         AND i.gender = il.gender
                          LEFT JOIN
        schoolmaster s ON i.school_id = s.id
    LEFT JOIN
        productsizemaster si ON i.product_size_id = si.id
    LEFT JOIN
        productmaster p ON i.product_id = p.id
		$where 
        having operation = 1";
    
        $query = $secondDB->query($sql);
		//echo $secondDB->last_query();die;
        return $query->result_array();
		
    }  

}