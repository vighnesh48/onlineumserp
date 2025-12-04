<?php
class Externalexamfaculty_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_faculty_details1($id='')
    {
		$DB1 = $this->load->database('umsdb', TRUE);  
        $where=" WHERE 1=1 ";  
        
        if($id!="")
        {
            $where.=" AND id='".$id."'";
        }      
        $sql="select * From exam_external_faculty_master $where ";
        $query = $DB1->query($sql);
        return $query->result_array();
    } 
	
	
	function  get_faculty_details($id='',$type='')
       {
		$DB1 = $this->load->database('umsdb', TRUE);  
        $where=" WHERE 1=1 ";  
        
        if($id!="")
        {
            $where.=" AND ex.id='".$id."'";
        }
		if($type!="")
        {
            $where.=" AND ex.btype='".$type."'";
        }
		
        $sql="select ex.*,bk.bank_name From exam_external_faculty_master ex left join bank_master bk on ex.bank_id=bk.bank_id $where ";
        $query = $DB1->query($sql);
        return $query->result_array();
      }
	  
	  
	function auto_ext_faculty() {
		$DB1 = $this->load->database('umsdb', TRUE);
        $quer = $DB1->query("SHOW TABLE STATUS WHERE `Name` = 'exam_external_faculty_master'");
        $quer = $quer->result_array();
        return $quer[0]['Auto_increment'];
    }   
	function checkDuplicate_pract_faculty($var)
    {
		$DB1 = $this->load->database('umsdb', TRUE);
    	$ext_fac_mobile = $var['ext_fac_mobile'];
		$ext_fac_email = $var['ext_fac_email'];
		
        $DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT id from exam_external_faculty_master WHERE (ext_fac_mobile='".$ext_fac_mobile."' OR ext_fac_email='".$ext_fac_email."') and ext_fac_designation='External'  ";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function  get_campus_details_search($para='')
    {
        $where=" WHERE 1=1 ";  
        
        if($para!="")
        {
            $where.=" AND campus_code like '%".$para."%' OR campus_name like '%".$para."%' OR campus_city like '%".$para."%' OR campus_state like '%".$para."%' OR campus_address like '%".$para."%' OR campus_pincode like '%".$para."%' ";
        }
        
        $sql="select campus_id,campus_code,campus_name,campus_city,campus_state,campus_address,campus_pincode,status From campus_master $where ";
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	
	public function get_ext_faculty_details()
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $uid = $this->session->userdata('uid');

        $DB1->select('ex.id, ex.ext_fac_name, ex.ext_faculty_code');
        $DB1->from('exam_external_faculty_master ex');
        $DB1->where('ex.status', 'Y');
        //$DB1->where('ex.inserted_by', $uid); 

        $query = $DB1->get();
        return $query->result_array();
    }


    public function get_event_ext_faculty()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select('*');
        $DB1->from('event_type_ext_faculty');
        $DB1->where('status', 'Y');

        $query = $DB1->get();
        return $query->result_array();
    }


    public function get_all_ext_faculty_event_details($event_type = '', $month_year = '')
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select('d.id, d.month_year, ef.ext_fac_name, et.event_type, d.description, d.ta_amount, d.honorarium_amount, d.verification_status, d.total_amount, d.created_at,ef.acc_holder_name,ef.acc_no,ef.ifsc_code,ef.cheque_file,b.bank_name,ef.ext_fac_email,ef.ext_fac_mobile,ef.branch');
        $DB1->from('event_type_ext_faculty_payment_details d');
        $DB1->join('exam_external_faculty_master ef', 'ef.id = d.ext_faculty_id', 'left');
        $DB1->join('bank_master b', 'ef.bank_id=b.bank_id', 'left');
        $DB1->join('event_type_ext_faculty et', 'et.id = d.event_type_id', 'left');

        if (!empty($event_type)) {
            $DB1->where('d.event_type_id', $event_type);
        }

        if (!empty($month_year)) {
            $DB1->where('d.month_year', $month_year);
        }

        $DB1->order_by('d.id', 'DESC');
        return $DB1->get()->result_array();
    }


    public function get_event_detail_by_id($id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select('*');
        $DB1->from('event_type_ext_faculty_payment_details');
        $DB1->where('id', $id);
        $query = $DB1->get();
        return $query->result_array();
    }
    public function get_event_type_by_id($id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        return $DB1->get_where('event_type_ext_faculty', ['id' => $id])->row_array();
    }


}