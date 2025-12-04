<?php
class Onlinepayment_model extends CI_Model 
{
    function __construct()
    {
		$DB1 = $this->load->database('umsdb', TRUE);
    }
	function add_online_feedetails($data)
	{

		$DB1 = $this->load->database('umsdb', TRUE);    
		{

		 $fdet['receipt_no']=$data['udf1'];
		 $fdet['payment_date']=$data['addedon'];
		 $fdet['payment_status']=$data['status'];
		 $fdet['error_code']=$data['error'];
		 $fdet['pg_type']=$data['PG_TYPE'];
		 $fdet['payment_mode']=$data['mode'];
		 $fdet['bank_ref_num']=$data['bank_ref_num'];
		 $fdet['error_message']=$data['error_Message'];
		   $DB1->where('txtid', $data['txnid']); 
		   $DB1->where('registration_no', $data['udf3']); 
		   $DB1->where('student_id', $data['udf5']);
		   $DB1->update('online_payment',$fdet);
		   return true;
		 
	}
}