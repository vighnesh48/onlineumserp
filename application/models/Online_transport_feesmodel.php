<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Online_transport_feesmodel extends CI_Model {

    var $table = 'online_payment_facilities';
    var $column_order = array(null, 'op.payment_id', 'op.receipt_no', 'op.student_id', 'op.txtid', 'op.firstname', 'op.registration_no', 'op.academic_year', 'op.email', 'op.phone', 'op.productinfo', 'op.amount', 'op.payment_mode', 'op.bank_ref_num', 'op.error_message', 'op.pg_type', 'op.payment_date', 'op.added_on', 'op.payment_status', 'op.error_code', 'op.verification_status', 'op.verified_by', 'op.verified_on', 'op.verified_from_ip', 'op.user_type', 'op.is_deleted'); //set column field database for datatable orderable //, 'fd.fees_id', 'fd.college_receiptno'
    var $column_search = array('op.payment_id', 'op.receipt_no', 'op.student_id', 'op.txtid', 'op.firstname', 'op.registration_no', 'op.academic_year', 'op.email', 'op.phone', 'op.productinfo', 'op.amount', 'op.payment_mode', 'op.bank_ref_num', 'op.error_message', 'op.pg_type', 'op.payment_date', 'op.added_on', 'op.payment_status', 'op.error_code', 'op.verification_status', 'op.verified_by', 'op.verified_on', 'op.verified_from_ip', 'op.user_type', 'op.is_deleted'); //set column field database for datatable searchable //, 'fd.fees_id', 'fd.college_receiptno'
    var $order = array('op.payment_id' => 'DESC','fd.fees_id'=> 'ASC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $DB1 = $this->load->database('s_erp', TRUE);
    }


public function product_info(){
	  $DB1 = $this->load->database('s_erp', TRUE);
	 $DB1->select('productinfo');
	 $DB1->from('online_payment_facilities');
	 $DB1->where('facility_id',2);	 
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
		//$this->db->where('account_for',$data['faci_type']);
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		return $query->result_array();
	}

    private function _get_datatables_query($DB1 = '', $pstatus = '', $pdate = '',$Type_status='',$Verify_status='',$pyear='')
    {
		$name=$this->session->userdata("name");
        //$DB1->select('op.*,fd.fees_id,fd.college_receiptno,', FALSE);
		//$DB1->select('ssf.organisation,op.*,fd.fees_id,fd.receipt_no as freceipt_no,fd.college_receiptno');
		$DB1->select('ssf.organisation,op.*');
        $DB1->from('online_payment_facilities as op');
       
		$DB1->join('sf_student_facilities as ssf', 'ssf.enrollment_no = op.registration_no ', 'left');	
		/*$DB1->join('sf_fees_details as fd', 'fd.receipt_no = op.bank_ref_num  AND `op`.`academic_year` = fd.academic_year  AND
		 fd.amount=op.amount AND  fd.chq_cancelled = "N"
		 AND fd.is_deleted = "N" AND `op`.`payment_status` = "success"', 'left');*/
		// $DB1->join('exam_session as e','e.exam_id = op.examsession','left');
       // $DB1->where('op.verification_status', 'N');
        $DB1->where('op.is_deleted', 'N');
		$DB1->where('op.facility_id', '2');
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
		
		if($name=="admin_nashik" ||$name=="transport_nashik"){
			  // $query = $this->db->query($sql1);
			  $wheren="(op.org_frm= 'SU' || op.org_frm= 'SF' || op.org_frm= 'SU-NASHIK' || op.org_frm= 'SF-NASHIK')";
			  $DB1->where($wheren);
		  }elseif($name=="transport_sijoul"){
			 $wheren="op.org_frm in('SF-SIJOUL','SU-SIJOUL')";
			 $DB1->where($wheren);
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
	// echo $DB1->last_query();exit;
        return $query->result();
    }
	

    public function count_filtered($DB1 = '', $pstatus = '', $pdate = '',$Type_status= '',$Verify_status= '',$pyear='')
    {
        $DB1 = $this->load->database('s_erp', TRUE);
        $this->_get_datatables_query($DB1, $pstatus, $pdate,$Type_status,$Verify_status,$pyear);
        $query = $DB1->get();
        return $query->num_rows();
    }

    public function count_all()
    {
		
       // $DB1 = $this->load->database('s_erp', TRUE);
		
        //$this->db->select('op.*,fd.fees_id,fd.college_receiptno');
        $this->db->select('op.*');
        $this->db->from('online_payment_facilities as op');
       // $this->db->join('sf_fees_details as fd','fd.receipt_no = op.bank_ref_num AND fd.chq_cancelled = "N" AND fd.is_deleted = "N"','left');
        $this->db->where('op.payment_status','success');
        $this->db->where('op.verification_status','N');
        $this->db->where('op.is_deleted','N');
		$this->db->where('op.facility_id','2');
        $this->db->order_by('op.payment_id', 'DESC');
		
       // $this->db->last_query();
	  //echo 'one';exit;
        return $this->db->count_all_results();
    }
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	
	var $table_Registration = 'online_payment_facilities';
    var $column_order_Registration = array(null, 'op.payment_id', 'op.receipt_no', 'op.student_id', 'op.txtid', 'op.firstname', 'op.registration_no', 'op.academic_year', 'op.email', 'op.phone', 'op.productinfo', 'op.amount', 'op.payment_mode', 'op.bank_ref_num', 'op.error_message', 'op.pg_type', 'op.payment_date', 'op.added_on', 'op.payment_status', 'op.error_code', 'op.verification_status', 'op.verified_by', 'op.verified_on', 'op.verified_from_ip', 'op.user_type', 'op.is_deleted'); //set column field database for datatable orderable
    var $column_search_Registration = array('op.payment_id', 'op.receipt_no', 'op.student_id', 'op.txtid', 'op.firstname', 'op.registration_no', 'op.academic_year', 'op.email', 'op.phone', 'op.productinfo', 'op.amount', 'op.payment_mode', 'op.bank_ref_num', 'op.error_message', 'op.pg_type', 'op.payment_date', 'op.added_on', 'op.payment_status', 'op.error_code', 'op.verification_status', 'op.verified_by', 'op.verified_on', 'op.verified_from_ip', 'op.user_type', 'op.is_deleted'); //set column field database for datatable searchable 
    var $order_Registration = array('op.payment_id' => 'DESC'); // default order 

   

    private function _get_datatables_query_Registration($DB1 = '', $pstatus = '', $pdate = '')
    {
        //$DB1->select('op.*,fd.fees_id,fd.college_receiptno,', FALSE);
		$DB1->select('op.*,fd.fees_id,fd.college_receiptno,ad.adm_id');
        $DB1->from('online_payment_facilities as op');
        $DB1->join('sf_fees_details as fd', 'fd.receipt_no = op.bank_ref_num AND fd.chq_cancelled = "N" 
            AND fd.is_deleted = "N"', 'left');
		$DB1->join('admission_details as ad', 'ad.student_id = op.student_id AND ad.academic_year = "2021"', 'left');	
        $DB1->where('op.verification_status', 'N');
        $DB1->where('op.is_deleted', 'N');
		$DB1->where('op.facility_id','2');
        if(!empty($pstatus)) {
            $pStatus = ($pstatus == 'N') ? 'pending' : 'success';
            $DB1->where('op.payment_status', $pStatus);
        } else {
            $DB1->where('op.payment_status', 'success');
        }
       $DB1->where('op.productinfo','Re-Registration');
        if(!empty($pdate)) {
            $DB1->where('DATE(op.payment_date)', $pdate);
        }
		
        $DB1->order_by('ad.adm_id', 'asc');

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
        $DB1->join('sf_fees_details as fd','fd.receipt_no = op.bank_ref_num AND fd.chq_cancelled = "N" AND fd.is_deleted = "N"','left');
        $DB1->where('op.payment_status','success');
        $DB1->where('op.verification_status','N');
		$DB1->where('op.is_deleted','N');
		$DB1->where('op.facility_id','2');
        $DB1->where('op.productinfo','Re-Registration');
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
}
