<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Online_uniform_feesmodel extends CI_Model {

    var $table = 'online_payment_facilities';
    var $column_order = array(null, 'op.payment_id', 'op.receipt_no', 'op.student_id', 'op.txtid', 'op.firstname', 'op.registration_no', 'op.academic_year', 'op.email', 'op.phone', 'op.productinfo', 'op.amount', 'op.payment_mode', 'op.bank_ref_num', 'op.error_message', 'op.pg_type', 'op.payment_date', 'op.added_on', 'op.payment_status', 'op.error_code', 'op.verification_status', 'op.verified_by', 'op.verified_on', 'op.verified_from_ip', 'op.user_type', 'op.is_deleted'); //set column field database for datatable orderable
    var $column_search = array('op.payment_id', 'op.receipt_no', 'op.student_id', 'op.txtid', 'op.firstname', 'op.registration_no', 'op.academic_year', 'op.email', 'op.phone', 'op.productinfo', 'op.amount', 'op.payment_mode', 'op.bank_ref_num', 'op.error_message', 'op.pg_type', 'op.payment_date', 'op.added_on', 'op.payment_status', 'op.error_code', 'op.verification_status', 'op.verified_by', 'op.verified_on', 'op.verified_from_ip', 'op.user_type', 'op.is_deleted'); //set column field database for datatable searchable 
    var $order = array('op.payment_id' => 'DESC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $DB1 = $this->load->database('s_erp', TRUE);
    }


public function product_info($type=''){

	  $DB1 = $this->load->database('s_erp', TRUE);
	 $DB1->select('productinfo');
	 $DB1->from('online_payment_facilities');
	 $DB1->where('productinfo','uniform');

	 $DB1->group_by('productinfo');
	 $query = $DB1->get();
	 //echo $DB1->last_query();exit;
        return $query->result();
	

}

public function hostel_get_depositedto()
	{
		$this->db->select("*");
		$this->db->from("sf_bank_account_details");
		$this->db->where('is_active','Y');
		$this->db->where('bank_account_id',12);
		//$this->db->where('account_for',$data['faci_type']);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}

    private function _get_datatables_query($DB1 = '', $pstatus = '', $pdate = '',$Type_status='',$Verify_status='',$pyear='')
    {
		$name=$this->session->userdata("name");
		$role_id = $this->session->userdata("role_id");
        //$DB1->select('op.*,fd.fees_id,fd.college_receiptno,', FALSE);
		//$DB1->select('op.*,fd.fees_id,fd.receipt_no as freceipt_no,fd.college_receiptno');
		$DB1->select('op.*');
		$DB1->from('online_payment_facilities as op');
		$DB1->where('op.is_deleted', 'N');
		$where = " (op.facility_id ='6')";
		$DB1->where($where);

		$DB1->where('op.productinfo', 'Uniform');

		if ($role_id == '52' || $role_id == '54') {
			if ($name == 'sun') {
				$DB1->where('op.org_frm', 'SU');
			} elseif ($name == 'uniform_sijoul') {
				$DB1->group_start(); // Open a group for or_where conditions
				$DB1->where('op.org_frm', 'SU-SIJOUL');
				$DB1->or_where('op.org_frm', 'SF-SIJOUL');
				$DB1->group_end(); // Close the group
			} else {
				$DB1->like('op.institute', $name, 'after');
			}
		} elseif ($role_id == '40') {
			$DB1->where('op.org_frm', 'SU');
		}
		//$DB1->where('op.facility_id', '1');
        if(!empty($pstatus)) {
            $pStatus = ($pstatus == 'N') ? 'pending' : 'success';
           // $DB1->where('op.payment_status', $pStatus);
        } else {
           // $DB1->where('op.payment_status', 'success');
        }
		
		
        
		
        if(!empty($pdate)) {
            $DB1->where('DATE(op.payment_date)', $pdate);
        }
		
		
		$where="op.payment_id >'624'";
		//$DB1->where($where);
		if($name=="admin_nashik"){
			  // $query = $this->db->query($sql1);
			  $wheren="op.org_frm= 'SU'";
		  }else{
			 $wheren="op.org_frm ='SF'";
		  }
		//$DB1->where($wheren);
		
		
		if($Type_status=="ALL"){
	
		}elseif($Type_status=="Both"){
			$wherepr="(op.productinfo = 'Re-Registration' OR op.productinfo = 'Late_fee')";
			$DB1->where($wherepr);
		}else{
			$DB1->where('op.productinfo',$Type_status);
		}
		
		
		if($Verify_status=="ALL"){
		
		}elseif($Verify_status=="Pending"){
		//$DB1->where('fd.fees_id',$Type_status);
		 $DB1->where('op.verification_status', 'N');
		//$DB1->where($wherep);
		}elseif($Verify_status=="Approved"){
		//$DB1->where('fd.fees_id',$Type_status);
		//$wherepr="`op`.`verification_status` = 'Y'";
		 $DB1->where('op.verification_status', 'Y');
		}
		if($Verify_status=="AdmissionCancel")
		{
		$DB1->where('op.admission_cancel', 'Y');
		}
		else
		{
		$DB1->where('op.admission_cancel', 'N');
		}
		if($pyear=="ALL"){	
		
		}else{
		$DB1->where('op.academic_year', $pyear);
		}
		
		$DB1->where('op.payment_status', 'success');
		
	
		$DB1->group_by('op.payment_id');
        //$DB1->order_by('fd.fees_id', 'ASC');
		$DB1->order_by('op.payment_id', 'DESC');

        $i = 0;

        foreach ($this->column_search as $item) {
            if($_POST['search']['value']) {

                if($i===0) {
                    $DB1->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $DB1->like($item, $_POST['search']['value']);
                } else {
                    $DB1->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $DB1->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) {
            $DB1->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $DB1->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables($DB1 = '', $pstatus = '', $pdate = '',$Type_status= '',$Verify_status= '',$pyear='')
    {
        $DB1 = $this->load->database('s_erp', TRUE);
        $this->_get_datatables_query($DB1, $pstatus, $pdate,$Type_status,$Verify_status,$pyear);

        if($_POST['length'] != -1) {
            $DB1->limit($_POST['length'], $_POST['start']);
        }
             
        $query = $DB1->get();
	 //echo $DB1->last_query();exit;
        return $query->result();
    }
	

    public function count_filtered($DB1 = '', $pstatus = '', $pdate = '',$Type_status= '',$Verify_status= '',$pyear='')
    {
        $DB1 = $this->load->database('s_erp', TRUE);
        $this->_get_datatables_query($DB1, $pstatus, $pdate,$Type_status,$Verify_status,$pyear);
        $query = $DB1->get();
		// echo $DB1->last_query();exit;
        return $query->num_rows();
    }

    public function count_all()
    {
		
       // $DB1 = $this->load->database('s_erp', TRUE);
		
        //$this->db->select('op.*,fd.fees_id,fd.college_receiptno');
        $this->db->select('op.*');
        $this->db->from('online_payment_facilities as op');
        //$this->db->join('sf_fees_details as fd','fd.receipt_no = op.bank_ref_num AND fd.chq_cancelled = "N" AND fd.is_deleted = "N"','left');
        $this->db->where('op.payment_status','success');
		$this->db->where('op.productinfo','Uniform');
        $this->db->where('op.verification_status','N');
        $this->db->where('op.is_deleted','N');
        $this->db->order_by('op.payment_id', 'DESC');
		
       // $this->db->last_query();
	  //echo 'one';exit;
        return $this->db->count_all_results();
    }
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	
	var $table_Registration = 'online_payment_facilities';
    var $column_order_Registration = array(null, 'op.payment_id', 'op.receipt_no', 'op.student_id', 'op.txtid', 'op.firstname', 'op.registration_no', 'op.academic_year', 'op.email', 'op.phone', 'op.productinfo', 'op.amount', 'op.payment_mode', 'op.bank_ref_num', 'op.error_message', 'op.pg_type', 'op.payment_date', 'op.added_on', 'op.payment_status', 'op.error_code', 'op.verification_status', 'op.verified_by', 'op.verified_on', 'op.verified_from_ip', 'op.user_type', 'op.is_deleted', 'fd.fees_id', 'fd.college_receiptno'); //set column field database for datatable orderable
    var $column_search_Registration = array('op.payment_id', 'op.receipt_no', 'op.student_id', 'op.txtid', 'op.firstname', 'op.registration_no', 'op.academic_year', 'op.email', 'op.phone', 'op.productinfo', 'op.amount', 'op.payment_mode', 'op.bank_ref_num', 'op.error_message', 'op.pg_type', 'op.payment_date', 'op.added_on', 'op.payment_status', 'op.error_code', 'op.verification_status', 'op.verified_by', 'op.verified_on', 'op.verified_from_ip', 'op.user_type', 'op.is_deleted', 'fd.fees_id', 'fd.college_receiptno'); //set column field database for datatable searchable 
    var $order_Registration = array('op.payment_id' => 'DESC'); // default order 

   

    private function _get_datatables_query_Registration($DB1 = '', $pstatus = '', $pdate = '')
    {
        //$DB1->select('op.*,fd.fees_id,fd.college_receiptno,', FALSE);
		#$DB1->select('op.*,fd.fees_id,fd.college_receiptno,ad.adm_id');
		$DB1->select('op.*');
        $DB1->from('online_payment_facilities as op');
        /*$DB1->join('sf_fees_details as fd', 'fd.receipt_no = op.bank_ref_num AND fd.chq_cancelled = "N" 
            AND fd.is_deleted = "N"', 'left');
		$DB1->join('admission_details as ad', 'ad.student_id = op.student_id AND ad.academic_year = "2021"', 'left');	*/
        $DB1->where('op.verification_status', 'N');
        $DB1->where('op.is_deleted', 'N');
		
        if(!empty($pstatus)) {
            $pStatus = ($pstatus == 'N') ? 'pending' : 'success';
            $DB1->where('op.payment_status', $pStatus);
        } else {
            $DB1->where('op.payment_status', 'success');
        }
       $DB1->where('op.productinfo','Uniform');
        if(!empty($pdate)) {
            $DB1->where('DATE(op.payment_date)', $pdate);
        }
        //$DB1->order_by('ad.adm_id', 'asc');

        $i = 0;

        foreach ($this->column_search_Registration as $item) {
            if($_POST['search']['value']) {

                if($i===0) {
                    $DB1->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $DB1->like($item, $_POST['search']['value']);
                } else {
                    $DB1->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_Registration) - 1 == $i) //last loop
                    $DB1->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) {
            $DB1->order_by($this->column_order_Registration[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $DB1->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables_Registration($DB1 = '', $pstatus = '', $pdate = '')
    {
        $DB1 = $this->load->database('s_erp', TRUE);
        $this->_get_datatables_query_Registration($DB1, $pstatus, $pdate);

        if($_POST['length'] != -1) {
            $DB1->limit($_POST['length'], $_POST['start']);
        }
             
        $query = $DB1->get();
		// echo $DB1->last_query();
        return $query->result();
    }

    public function count_filtered_Registration()
    {
        $DB1 = $this->load->database('s_erp', TRUE);
        $this->_get_datatables_query_Registration($DB1);
        $query = $DB1->get();
		
        return $query->num_rows();
    }

    public function count_all_Registration()
    {
        $DB1 = $this->load->database('s_erp', TRUE);
        $DB1->select(
                        'op.*,
                        fd.fees_id,
                        fd.college_receiptno,
                        ', FALSE);
        $DB1->from('online_payment_facilities as op');
        //$DB1->join('sf_fees_details as fd','fd.receipt_no = op.bank_ref_num AND fd.chq_cancelled = "N" AND fd.is_deleted = "N"','left');
        $DB1->where('op.payment_status','success');
        $DB1->where('op.verification_status','N');
		$DB1->where('op.is_deleted','N');
        $DB1->where('op.productinfo','Uniform');
        $DB1->order_by('op.payment_id', 'DESC');

        return $DB1->count_all_results();
    }
	
	function change_productinfo($data){
		$DB1 = $this->load->database('s_erp', TRUE);
		$pid=$data['lang'];
		$up['productinfo']=$data['value'];
		$DB1->where('payment_id',$pid);
		$DB1->update('online_payment_facilities',$up);
		return 1;
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //admission cancel
	function admissioncancel($data)
	{
	$DB1 = $this->load->database('s_erp', TRUE);

	$up['admission_cancel']=$data['status'];

	$DB1->where('payment_id',$data['payment_id']);
	$DB1->where('student_id',$data['student_id']);
	$result=$DB1->update('online_payment_facilities',$up);

	return $result;
	} 
	 //////////////////////////HK////////////////////////////////
    public function insertPaymentFacility($data, $payment_id = "")
{   
    $secondDB = $this->load->database('umsdb', TRUE);
    $role_id = $this->session->userdata('role_id');
    $name = $this->session->userdata('name');

    $where = " WHERE 1=1 ";  

    if ($payment_id != "") {
        $where .= " AND i.id='".$payment_id."'";
    }

    if ($role_id == 54) {
        $where .= " and LOWER(school_name)='".strtolower($name)."'";
    }

    $DB1 = $this->load->database('s_erp', TRUE);
    $DB1->insert('online_payment_facilities', $data);
    return $DB1->insert_id();
}


public function get_student_detail_by_prn_with_union($enrollment_no) {
    $DB1 = $this->load->database('umsdb', TRUE);

    $sql = "SELECT sm.first_name, sm.last_name, sm.middle_name, sm.mobile, sm.enrollment_no,sm.academic_year,sm.stud_id as student_id, sc.school_short_name as institute_name, adhar_card_no, email
            FROM student_master as sm
            join school_master as sc on sc.school_id = sm.admission_school
            WHERE enrollment_no = $enrollment_no
            UNION
            SELECT first_name, last_name, middle_name, mobile, enrollment_no,academic_year,student_id, instute_name as institute_name ,adhar_card_no, email
            FROM sandipun_erp.sf_student_master
            WHERE enrollment_no = $enrollment_no";

    $query = $DB1->query($sql);
            $result = $query->row_array();
            //echo $DB1->last_query();exit;

    return $result ?: []; echo $result ?: [];
}
///////////////////////// HK END CODE//////////////////////////////////////////
//////////////////////////HK////////////////////////////////
    public function getPaymentFacilityByEnrollmentNo($enrollmentNo) {
        
        $this->db->where('productinfo', 'Uniform');
        $this->db->where('payment_status', 'success');
        $this->db->where('registration_no', $enrollmentNo);
        $query = $this->db->get('online_payment_facilities');

        return $query->row_array();
    }

    //////////////////////////HK END CODE ////////////////////////////////
}
