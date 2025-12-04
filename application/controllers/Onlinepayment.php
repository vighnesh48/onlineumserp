<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onlinepayment extends CI_Controller {
	var $currentModule="Online_fee";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Onlinepayment_model";
    var $model;
    var $view_dir='Online_fee/';
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function success()
	{
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$this->load->helper("url");		
		//session_start();
		$this->load->library('session');	
	     $this->load->model('Onlinepayment_model');
	     $this->data["key"] =$_REQUEST['key'];
	     $this->data["hash"] =$_REQUEST['hash'];
	     $this->data["txnid"] =$_REQUEST['txnid'];
	     $this->data["udf1"] = $_REQUEST['udf1'];
	     $this->data["udf2"] =$_REQUEST['udf2'];
	     $this->data["udf3"] =$_REQUEST['udf3'];
	     $this->data["udf4"] =$_REQUEST['udf4'];
	     $this->data["udf5"] =$_REQUEST['udf5'];//utype//$_REQUEST['student_type'];
		// $this->data["udf6"] =$_REQUEST['udf6'];
	     $this->data["firstname"] = $_REQUEST['firstname'];
	     $this->data["email"] =$_REQUEST['email'];
	     $this->data["productinfo"] =$_REQUEST['productinfo'];
	     $this->data["amount"] =$_REQUEST['amount'];
	     $this->data['addedon']=$_REQUEST['addedon'];
	     $this->data['status']=$_REQUEST['status'];
	     $this->data['error']=$_REQUEST['error'];
	     $this->data['PG_TYPE']=$_REQUEST['PG_TYPE'];
	     $this->data['mode']=$_REQUEST['mode'];
	     $this->data['bank_ref_num']=$_REQUEST['bank_ref_num'];
	     $this->data['error_Message']=$_REQUEST['error_Message'];	     
	    print_r($this->data);exit;
       $this->Onlinepayment_model->add_online_feedetails($this->data);
	   $user_mobile = $udf4;//$udf4//7030942420,8850633088,9545453488,9545453087;
	   $this->load->view('header',$this->data);                         
       $this->load->view($this->view_dir.'payment_success',$this->data,true);
	   
       $this->load->view($this->view_dir.'thankyou',$this->data);
       $this->load->view('footer'); 
	   // redirect('Thankyou');   
	}
}