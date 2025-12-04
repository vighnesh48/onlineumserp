<?php
class Collaboration_edu_model extends CI_Model{
   
    var $table = 'apply_studnet';
	var $column_order = array(null, 'full_name','designation','institution_name','mobile','email'); //set column field database for datatable orderable
	var $column_search = array('full_name','designation','institution_name','mobile','email');
	//set column field database for datatable searchable 
	var $order = array('created_at' => 'DESC'); // default order 
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Challan_model');
	}
	
	
	
	public function get_datatables($cyear='', $form_type='')
{  
    $DB1 = $this->load->database('icdb', TRUE);

    $DB1->select("
        cl.academic_year,
        cl.full_name,
        cl.designation,
        cl.institution_name,
        cl.institution_add,
        cl.city,
        cl.state,
        cl.mobile,
        cl.email,
        cl.institution_type,
        cl.category,
        cl.nominate,
        cl.nominate_text,
        st.name AS state_name,
        ct.name AS city_name,cl.created_at,

        /* Get category names */
        (
            SELECT GROUP_CONCAT(pc.category ORDER BY pc.category SEPARATOR ', ')
            FROM participation_categories pc
            WHERE FIND_IN_SET(pc.id, cl.category)
        ) AS category_names,

        /* Get institution type names */
        (
            SELECT GROUP_CONCAT(itm.type ORDER BY itm.type SEPARATOR ', ')
            FROM institution_types_master itm
            WHERE FIND_IN_SET(itm.id, cl.institution_type)
        ) AS institution_type_names
    ", FALSE);

    $DB1->from("collaborating_edu_details AS cl");
    $DB1->join("states AS st", "st.id = cl.state", "left");
    $DB1->join("cities AS ct", "ct.id = cl.city", "left");

    if (!empty($form_type)) {
        $DB1->where("cl.form_type", $form_type);  
    }

    $DB1->where("cl.academic_year", $cyear);

    // search
    $i = 0;
    foreach ($this->column_search1 as $item) {
        if ($_POST['search']['value']) {
            if ($i === 0) {
                $DB1->group_start();
                $DB1->like($item, $_POST['search']['value']);
            } else {
                $DB1->or_like($item, $_POST['search']['value']);
            }
            if (count($this->column_search1) - 1 == $i) {
                $DB1->group_end();
            }
        }
        $i++;
    }

    // order
    if (isset($_POST['order'])) {
        $DB1->order_by($this->column_order1[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->order)) {
        $order = $this->order;
        $DB1->order_by(key($order), $order[key($order)]);
    }

    if ($_POST['length'] != -1) {
        $DB1->limit($_POST['length'], $_POST['start']);
    }

    $query = $DB1->get();
    return $query->result();
}
	
	

	public function count_filtered($cyear='',$form_type='')
	{    $DB1=$this->load->database('icdb',TRUE);
		$ac=$cyear;
		//,12,48,49,50,51,5,3
        $DB1->select('academic_year,full_name,designation,institution_name,institution_add,city,state,mobile,email,institution_type,category,nominate,nominate_text',FALSE);
		$DB1->from('collaborating_edu_details');
		if(empty($form_type)){
		
		$DB1->where("form_type IN (1)");	
		}
		$DB1->where("academic_year","'".$cyear."'");
		$i = 0;

		 foreach ($this->column_search1 as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$DB1->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$DB1->like($item, $_POST['search']['value']);
				}
				else
				{
					$DB1->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search1) - 1 == $i) //last loop
					$DB1->group_end(); //close bracket
			}
			$i++;
		} 
		
		
		if(isset($_POST['order'])) // here order processing
		{
			$DB1->order_by($this->column_order1[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$DB1->order_by(key($order), $order[key($order)]);
		}
		if($_POST['length'] != -1)
		$DB1->limit($_POST['length'], $_POST['start']);
		$query = $DB1->get();
		return $query->num_rows();
	}

	public function count_all($cyear,$form_type='')
	{  
	    $DB1=$this->load->database('icdb',TRUE);
		$DB1->from('collaborating_edu_details');
		if($form_type!=''){
		$DB1->where('form_type',$form_type);
		}
		return $DB1->count_all_results();
	}
	
	
	

}
?>