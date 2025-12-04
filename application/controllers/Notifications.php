<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//ini_set('error_reporting', E_ALL);
class Notifications extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Employee_model";
    var $model;
    var $view_dir='Employee/';
    
    public function __construct() 
    {
        date_default_timezone_set('Asia/Kolkata');
        global $menudata;
        parent:: __construct();
        
        $this->load->helper("url");		
        $this->load->library('form_validation');
        
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
           $title=$this->master_arr['index'];
       
        
        $this->currentModule=$this->uri->segment(1);
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
        $this->load->model('Admin_model');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		$this->load->model('Examination_model');
		$this->load->library('Awssdk');
    }
    
	
     public function send_pending_fee_msg()	  
		{
			
		$stud_data=$this->Examination_model->get_studentwise_admission_fees_pending();		
		if(!empty($stud_data)){
		foreach($stud_data as $stud){
		$other=0;$pending=0;
		$fullname=$stud['first_name'];
		$enrollment_no=$stud['enrollment_no'];
		$mob=$stud['mobile'];
		$parent_mobile=$stud['parent_mobile2'];
		$other=$stud['opening_balance']+$stud['cancel_charges'];
		$pending=($stud['applicable_total']+$other+$stud['refund'])-$stud['fees_total'];
		if(!empty($parent_mobile)){
			$mob.=",".$parent_mobile;
		}
        $mob.=",8976450323";    
		if($pending > 0){
		$msg='Dear '.$fullname.', this is a reminder to settle your Pending fees of Rs. '.$pending.' pending.Kindly ignore if payment has already been made. Thank you, Sandip University.';
		$msg = urlencode($msg);
		 //echo $smsGatewayUrl="http://web.smsgw.in/smsapi/httpapi.jsp?username=SANDEEP03&password=Found123&from=SANDIP&to=$mob&text=$msg&coding=0&pe_id=1701159161247599930&template_id=1107171662148015617";
		 $smsGatewayUrl="http://login.businesslead.co.in/api/mt/SendSMS?user=SANDIPFOUNDATION&password=ABC@789&senderid=SANDIP&channel=Trans&DCS=0&flashsms=0&number=$mob&text=$msg&coding=0&pe_id=1701159161247599930&template_id=1107171662148015617";
		
		$ch = curl_init();                       // initialize CURL
		curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
		curl_setopt($ch, CURLOPT_URL, $smsGatewayUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = trim(curl_exec($ch));
		curl_close($ch); 
		$response = json_decode($output, true);
		
		
		
		
		
		
		
		
		
		//exit;
		} 
		}
		}
		echo 'success';

		}
		
		
		
		
}