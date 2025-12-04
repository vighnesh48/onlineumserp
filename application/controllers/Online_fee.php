<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Online_fee extends CI_Controller 
{

    var $currentModule="Online_fee";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Online_feemodel";
    var $model;
    var $view_dir='Online_fee/';
    
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
     //   echo $_SERVER['REMOTE_ADDR'];
    // var_dump($_SESSION);
    // error_reporting(E_ALL);
    //ini_set('display_errors', 1);
        $this->load->helper("url");		
        $this->load->library('form_validation');
        $this->load->library('someclass');
		//session_start();
		$this->load->library('session');
		
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2),
		 $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
           $title=$this->master_arr['index'];
       
        
        $this->currentModule=$this->uri->segment(1);
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
        $this->load->model('Challan_model');
        $this->load->model('payment_model');
		$this->load->model('Phd_challan_model');
	    $this->load->model('Online_feesmodel');
	    $this->load->model('Examination_model');
		$this->load->model('online_transport_feemodel');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    
    public function indexold() // Renamed by to indexold as new index is down 
    {
        global $model;
        $this->load->view('header',$this->data);    
         $this->data['emp_list']= $this->Online_feemodel->getFeesdata();
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'fee_listing',$this->data);
        $this->load->view('footer');
    }
	
	public function index()
    {
        global $model;
        $this->load->view('header',$this->data);    
		
	 $this->data['product_info']= $this->Online_feesmodel->product_info();                 
        $this->load->view($this->view_dir.'fees_listing',$this->data);
        $this->load->view('footer');
    }
	
	public function fees_demo()
    {
       /* global $model;
		//$this->load->model('online_transport_feemodel');
        $this->load->view('header',$this->data);    
		$this->data['Transportation_payment']= $this->online_transport_feemodel->check_Transportation_payment(); 
		//print_r($this->data['Transportation_payment']);
		//exit();
	    $this->data['product_info']= $this->Online_feesmodel->product_info();                 
        $this->load->view($this->view_dir.'pay_fees_demo',$this->data);
        $this->load->view('footer');*/
		
		 if($_POST){
	      
	     //  var_dump($_POST);
	     //  exit(0);
	        $this->load->view('header',$this->data);    
      //   $this->data['emp_list']= $this->Online_feemodel->getFeesdata();
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'pay_fees_demo',$_POST);
        $this->load->view('footer'); 
        
	   }else{
		   
	      $this->load->view('header',$this->data);    
          $stdata= $this->Online_feemodel->fetch_studentdata();
		  $this->data['Transportation_payment']= $this->online_transport_feemodel->check_Transportation_payment(); 
		  $this->data['product_info']= $this->Online_feesmodel->product_info(); 
		  $this->data['adm']= $this->Online_feemodel->check_admission_year($stdata['stud_id']);
		  $this->data['ex_list']= $this->Online_feemodel->get_stud_exams($stdata['stud_id']);
		  //print_r($this->data['ex_sess']);
		  $this->data['stdata']=$stdata;
		  $this->data['productinfo1']=$type;
		  if(($stdata['stud_id']==4192)){
		  //$this->load->view($this->view_dir.'pay_full_fees',$this->data);
		  $this->load->view($this->view_dir.'payfeesnew',$this->data);
		  }else{
		   $this->load->view($this->view_dir.'pay_fees_demo',$this->data);
		  }
     
        $this->load->view('footer'); 
	   }
		
		
		
		
		
    }
	
	public function Registration_fees()
    {
        global $model;
        $this->load->view('header',$this->data);                       
        $this->load->view($this->view_dir.'Registration_listing',$this->data);
        $this->load->view('footer');
    }

    public function getOnlineFeeDetail()
    {
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==40){
		}else{
			redirect('home');
		}
      $this->load->model('Online_feesmodel');
      $pdate = strip_tags($this->input->post('pdate'));
      $pstatus = strip_tags($this->input->post('pstatus'));
      $Type_status=$this->input->post('Type_status');
      $Verify_status=$this->input->post('Verify_status');
	  $pyear=$this->input->post('pyear');
      $list = $this->Online_feesmodel->get_datatables('', $pstatus, $pdate,$Type_status,$Verify_status,$pyear);
    // print_r($list);
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $students) {
		  
		 // $adm_id=$students->adm_id;
		//if(!empty($adm_id))
		{
		  
		  
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $students->receipt_no;
        $row[] = $students->bank_ref_num;
		//if(($students->productinfo=="New_Admission")||($students->productinfo=="Online_Admission_Form")){$row[] ='';}else{
		if(($students->productinfo=="Online_Admission_Form")){$row[] ='';}else{
		$row[] = $students->registration_no;
		}
        $row[] = $students->firstname;
		$row[] = $students->phone;
        $row[] = $students->amount;
		$row[] = $students->academic_year;
        $row[] = $students->payment_mode;
        $row[] = $students->payment_status;
        $row[] = $students->payment_date;
		
		if(!empty($students->examsession)){
			$exam_session=$students->exam_month.'-'.$students->exam_year;
		}else{
			$exam_session ='';
		}
		if(($students->productinfo=="Re-Registration")||($students->productinfo=="Admission")){
			$a='';$r='';
			if($students->productinfo=="Re-Registration"){
				$r="selected";
			}else{
				$a="selected";
			}
			
			$row[] ='<select name="produc" id="produc" lang="'.$students->payment_id.'" onchange="change_productinfo(this)">
			<option value="Admission" '.$a.'>Admission</option>
			<option value="Re-Registration" '.$r.'>Re-Registration</option>
			</select>';
		}else{
        $row[] = $students->productinfo.' '.$exam_session;
			}
		
		
        $apStatus = $students->fees_id;
		$adm_id=$students->adm_id;
		if(empty($adm_id)){
			$row[] = 'Pending';
		}else{
			$row[] = 'Done';
		}
       
	    

        $verifyStatus = '';
        $verification_status = $students->verification_status;
        $payment_status = $students->payment_status;
		
		if($verification_status!='Y') {
        	$row[] = 'Pending';
        } else {
        	$row[] = 'Approved';
        }
		
        if($payment_status == 'success') {
        	if($apStatus != NULL) {
        		$verifyStatus .= $students->college_receiptno;
        	} else {
				if($students->productinfo=="Online_Admission_Form"){
					$studentVerify = base_url()."Online_fee/External_challan/".$students->payment_id."/".$students->productinfo;
				}else{
        		$studentVerify = base_url()."Online_fee/Challan/".$students->payment_id."/".$students->productinfo;
				}
				if($verification_status=='Y'){
					$verifyStatus .= 'Approved';
				}else{
					$verifyStatus .= '<a  href="'.$studentVerify.'" title="Verify" target="_blank"><i class="fa fa-book" aria-hidden="true"></i>Verify</a>';
				}
        	}
        }

        if ($students->payment_status == 'failure') {
        	$verifyStatus .= '<a href="#" onclick="remove_list('.$students->payment_id.')">Remove</a>';
        }

        $row[] = $verifyStatus;
		$data[] = $row;
      }
	  }
 
      $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->Online_feesmodel->count_all(),
              "recordsFiltered" => $this->Online_feesmodel->count_filtered('', $pstatus, $pdate,$Type_status,$Verify_status,$pyear),
              "data" => $data,
          );

      echo json_encode($output);
    }
		/////////////////////////////////////////////////////
		public function change_productinfo(){
		echo	$check=$this->Online_feesmodel->change_productinfo($_POST);
		}
		
		public function getOnlineFeeDetail_Registration()
    {
      $this->load->model('Online_feesmodel');
      $pdate = strip_tags($this->input->post('pdate'));
      $pstatus = strip_tags($this->input->post('pstatus'));

      $list = $this->Online_feesmodel->get_datatables_Registration('', $pstatus, $pdate);

      $data = array();
      $no = $_POST['start'];
      foreach ($list as $students) {
		  $adm_new=$students->adm_id;
		  //if(empty($adm_new))
		  {
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $students->receipt_no;
        $row[] = $students->bank_ref_num;//($students->productinfo=="New_Admission")||
		if(($students->productinfo=="Online_Admission_Form")){$row[] ='';}else{
		$row[] = $students->registration_no;
		}
        $row[] = $students->firstname;
		$row[] = $students->phone;
        $row[] = $students->amount;
        $row[] = $students->payment_mode;
        $row[] = $students->payment_status;
        $row[] = $students->payment_date;
        $row[] = $students->productinfo;
		$adm_id=$students->adm_id;
		if(empty($adm_id)){
			$row[] = 'Pending';
		}else{
			$row[] = 'Done';
		}
       /* $apStatus = $students->fees_id;
        if($apStatus == NULL) {
        	$row[] = 'Approved';
        } else {
        	$row[] = 'Pending';
        }

        $verifyStatus = '';
        $verification_status = $students->verification_status;
        $payment_status = $students->payment_status;
        if($verification_status == 'N' && $payment_status == 'success') {
        	if($apStatus != NULL) {
        		$verifyStatus .= $students->college_receiptno;
        	} else {
				if($students->productinfo=="Online_Admission_Form"){
					$studentVerify = base_url()."Online_fee/External_challan/".$students->payment_id."/".$students->productinfo;
				}else{
        		$studentVerify = base_url()."Online_fee/Challan/".$students->payment_id."/".$students->productinfo;
				}
        		$verifyStatus .= '<a  href="'.$studentVerify.'" title="Verify" target="_blank"><i class="fa fa-book" aria-hidden="true"></i>Verify</a>';
        	}
        }

        if ($students->payment_status == 'failure') {
        	$verifyStatus .= '<a href="#" onclick="remove_list('.$students->payment_id.')">Remove</a>';
        }

        $row[] = $verifyStatus;*/
		$data[] = $row;
		  }
      }

      $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->Online_feesmodel->count_all_Registration(),
              "recordsFiltered" => $this->Online_feesmodel->count_filtered_Registration(),
              "data" => $data,
          );

      echo json_encode($output);
    }
		
		
		
		
		
		
		///////////////////////////////////////////////////////////
	
	  public function student_payment_history($prn='',$stud_id='')
    {
        global $model;
        $this->load->view('header',$this->data); 
		if($stud_id ==''){		
			$stud_id=$this->session->userdata("aname");
		}else{
			$stud_id=$stud_id;
		}
		if($prn==''){
		$prn=$this->session->userdata("name");
		}else{
			$prn=$prn;	
		}
		//exit;
		 $this->data['pay_session']= $this->Online_feemodel->pay_session($prn);
         $this->data['pay_list']= $this->Online_feemodel->student_payment_history($prn);
		 $this->data['hostpay_list']= $this->Online_feemodel->student_hostelpayment_history($prn);
		 $this->data['transpay_list']= $this->Online_feemodel->student_transportpayment_history($prn);
		 $this->data['uniform']= $this->Online_feemodel->student_uniform_history($prn,$stud_id);
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'student_payment_history',$this->data);
        $this->load->view('footer');
    }
	
	
	
	
	
	
	function load_feelist()
	{
	    
	      $data['emp_list']= $this->Online_feemodel->getFeesajax();
	      // $data['dcourse']= $_POST['astream'];
	      //  $data['dyear']= $_POST['ayear'];
	      
	      $html = $this->load->view($this->view_dir.'load_feedata',$data,true);
	  echo $html;
	}
	
	function update_fstatus()
	{
	  $this->Online_feemodel->update_feestatus();  
	 echo "Y";   
	}
	
	
		function remove_list()
	{
	  $this->Online_feemodel->remove_list();  
	 echo "Y";   
	}
	
	
	
	
	function pay_fees($type='')
	{ 
		/*if($_REQUEST['test']!=1){
	    $this->load->view('maintenance_mode.php');
		}else{
	   //var_dump($_SESSION);
	   */
		$this->session->unset_userdata('amount');
		 $this->session->unset_userdata('Payment_type');
		 $this->session->unset_userdata('ftype');
		 $this->session->unset_userdata('txnid');
		 $this->session->unset_userdata('pstud_id');
		 $this->session->unset_userdata('penrollemt_no');
		 
	   if($_POST){
	      
	     //  var_dump($_POST);
	     //  exit(0);
	        $this->load->view('header',$this->data);    
      //   $this->data['emp_list']= $this->Online_feemodel->getFeesdata();
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        //$this->load->view($this->view_dir.'pay_fees',$_POST);
		 $this->load->view($this->view_dir.'pay_fees_demo',$this->data);
        $this->load->view('footer'); 
        
	   }else{
		  
	      $this->load->view('header',$this->data);    
          $stdata= $this->Online_feemodel->fetch_studentdata();
		  $this->data['Transportation_payment']= $this->online_transport_feemodel->check_Transportation_payment(); 
		  $this->data['product_info']= $this->Online_feesmodel->product_info();
		  $this->data['adm']= $this->Online_feemodel->check_admission_year($stdata['stud_id']);
		  //$this->data['reddystudents']= $this->Online_feemodel->check_reddy_students($stdata['stud_id']);
		  $this->data['reddystudents']= array();
		  $this->data['hostel_pending']= $this->Online_feemodel->Get_hostel_pending();
		  $causion_pending= $this->Online_feemodel->Get_causion_pending();
		  $this->data['causion_pending']= $causion_pending['causion_money'];
		  $this->data['ex_list']= $this->Online_feemodel->get_stud_exams($stdata['stud_id'],$stdata['admission_cycle']);
		  //print_r($this->data['ex_sess']);
		  $this->data['stdata']=$stdata;
		  $std_arr =array('7448','6088','8847','11832','11474','10305','10365','14052','16044','14527','15453','13907','17740','17799','14752','13757','14121','17852');
		  $this->data['productinfo1']=$type;
		  if(in_array($stdata['stud_id'],$std_arr)){
		  //$this->load->view($this->view_dir.'pay_full_fees',$this->data);
		  $this->load->view($this->view_dir.'pay_fees_demo',$this->data);
		  }else{
			 // echo "This page is under maintenance. We will back soon.";exit;
		 //  $this->load->view($this->view_dir.'pay_fees',$this->data);
		 $this->load->view($this->view_dir.'pay_fees_demo',$this->data);
		 //$this->load->view('maintenance_mode_online_payments.php');
		 
		  }
     
        $this->load->view('footer'); 
	   }
	    
	}
	function pay_fees_old($type='')
	{
	    
	   //var_dump($_SESSION);
	   if($_POST){
	      
	     //  var_dump($_POST);
	     //  exit(0);
	        $this->load->view('header',$this->data);    
      //   $this->data['emp_list']= $this->Online_feemodel->getFeesdata();
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
      //  $this->load->view($this->view_dir.'maintenance',$_POST);
		$this->load->view($this->view_dir.'payfeesnew',$this->data);//pay_fees
        $this->load->view('footer'); 
        
	   }else{
		   
		   $this->load->view('header',$this->data);    
          $stdata= $this->Online_feemodel->fetch_studentdata();
		  $this->data['adm']= $this->Online_feemodel->check_admission_year($stdata['stud_id']);
		  //$this->data['payment_status']= $this->Online_feemodel->check_payment_status($stdata['stud_id'],$acdemic_year='2021');
		  $this->data['stdata']=$stdata;
		  $this->data['productinfo1']=$type;
		  $this->load->view($this->view_dir.'payfeesnew',$this->data);//pay_fees
		//  $this->load->view($this->view_dir.'maintenance',$this->data);//pay_fees
		   $this->load->view('footer'); 
		   
		   
		   
	   }
	}
	function pay_test($type='')//ccanve
	{
	    
	   //var_dump($_SESSION);
	   if($_POST){
	      
	     //  var_dump($_POST);
	     //  exit(0);
	        $this->load->view('header',$this->data);    
      //   $this->data['emp_list']= $this->Online_feemodel->getFeesdata();
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'payfeesnew',$_POST);
        $this->load->view('footer'); 
        
	   }else{
		   
		   $this->load->view('header',$this->data);    
          $stdata= $this->Online_feemodel->fetch_studentdata();
		  $this->data['adm']= $this->Online_feemodel->check_admission_year($stdata['stud_id']);
		  $this->data['stdata']=$stdata;
		  $this->data['productinfo1']=$type;
		  $this->load->view($this->view_dir.'payfeesnew',$this->data);//pay_fees
		   $this->load->view('footer'); 
		   
		   
		   
	   }
	}
	
	function pay_fees_test()
	{
	    
	   //var_dump($_SESSION);
	  
		   
	   $this->load->view('header',$this->data);    
       $stdata= $this->Online_feemodel->fetch_studentdata();
	   $this->data['stdata']=$stdata;
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details(); 
	  if($stdata['stud_id']==2540)          {             
        $this->load->view($this->view_dir.'pay_fees_manually',$this->data);//pay_fees
	  }
        $this->load->view('footer'); 
	   
	    
	}
	
	function pay_full_fees()
	{
	    
	   //var_dump($_SESSION);
	   if($_POST){
	      
	     //  var_dump($_POST);
	     //  exit(0);
	        $this->load->view('header',$this->data);    
      //   $this->data['emp_list']= $this->Online_feemodel->getFeesdata();
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'pay_full_fees',$_POST);
        $this->load->view('footer'); 
        
	   }
	   else
	   {
		   
	      $this->load->view('header',$this->data);    
       $this->data['stdata']= $this->Online_feemodel->fetch_studentdata();
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'pay_full_fees',$this->data);
        $this->load->view('footer'); 
	   }
	    
	}
	
	
	function fetch_ReRegistration()
{
    $amount= $this->Online_feemodel->fetch_ReRegistration();
}
	
	function Online_fee_entery(){
    $DB1 = $this->load->database('umsdb', TRUE);
	/*if($_SESSION['penrollment_no'] == 240102041009){
	 echo '<pre>';
	 print_r($_SESSION);
	 print_r($_POST);exit;
	}*/
	if($_POST['productinfo']!= 'Examination'){
		if(($_POST['amount']==$_SESSION['amount'] && $_POST['Payment_type']==$_SESSION['Payment_type'] &&  $_POST['productinfo']==$_SESSION['ftype'])){ //
		
			$stdata= $this->Online_feemodel->fetch_studentdata();
			///////////////////////////////////////////////////////////////
			// $txnid=date('dmY').rand(100,999);
		   // $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		   // Merchant key here as provided by Payu
		   $MERCHANT_KEY = "soe5Fh"; //Please change this value with live key for production
		   $hash_string = '';
		   // Merchant Salt as provided by Payu
		   $SALT = "OhVBBZuL"; //Please change this value with live salt for production
		   //$txnid=date('ddmmyyyy').rand(100,999);
		   // End point - change to https://secure.payu.in for LIVE mode
		   $PAYU_BASE_URL = "https://secure.payu.in";
		   
			$action = '';
			$_POST['udf3']=$stdata['enrollment_no'];
			$_POST['udf5']=$stdata['stud_id'];
		   $posted = array();
		   if(!empty($_POST)) {
		 //  print_r($_POST);exit();
		   foreach($_POST as $key => $value) {    
		   $posted[$key] = $value; 
		   
		   }
		   }
		   //print_r($_POST);
		  // exit;
		  
		   $txnid='01'.date('ymdhis')."-".$_POST['stud_id'];
		   
		   $trans_id=$this->Online_feemodel->insert_data_in_trans($_POST,$txnid);
		   
		   $recepit = date('ymd')."".$trans_id; //recepit s
		   
		   
		   $formError = 0;
		   
		  // if(empty($posted['txnid'])) {
		   // Generate random transaction id
		   //$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		  //$txnid=date('ddmmyyyy').rand(100,999);
		 //  } else {
		   //$txnid = $posted['txnid'];
		  // }
		  
		   $hash = '';
		   //$txnid=date('dmY').rand(100,999);
		   //$txnid=date('dmY').rand(100,999);
		   // Hash Sequence
		   $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
		 
		 
		   $posted['txnid']=$txnid;
		   
		   if($posted['productinfo']=="Re-Registration"){
			  $amount= $this->Online_feemodel->fetch_ReRegistration($_POST);
			  $udf6=$posted['udf6'];
			  $posted['amount']=$amount+$udf6;
			//  $pay=$amount;
		   }else{
			  $posted['amount']=$posted['amount'];
		   }
		   
		   $posted['udf1']=$recepit;//receipt_no
		  // $posted['udf2']=$posted['udf2'];//Academic Year
		   $posted['udf3']=$posted['udf3'];//enrollment_no
		   $posted['udf4']=$posted['mobile'];//mobile
		   $posted['udf5']=$posted['stud_id'];//user_type 
		   
		   if(empty($_POST['hash']) && sizeof($posted) > 0) {
				 
		   if(empty($posted['key'])|| empty($posted['txnid'])|| empty($posted['amount'])|| empty($posted['firstname'])|| empty($posted['email'])|| empty($posted['productinfo'])) {
			  $formError = 1;
			 //print_r($_POST);exit();
		   } else {
		   
		   $hashVarsSeq = explode('|', $hashSequence);
		   
		   foreach($hashVarsSeq as $hash_var) {
			$hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
			$hash_string .= '|';
		   }
		   
		   $hash_string .= $SALT;
		   
		   
		   $hash = strtolower(hash('sha512', $hash_string));
			
			// print_r($_POST);exit();
		   $action = $PAYU_BASE_URL . '/_payment';
		   }
		   } elseif(!empty($posted['hash'])) {
		   $hash = $posted['hash'];
		   $action = $PAYU_BASE_URL . '/_payment';
		   }
				//echo $hash;
				//exit();
				//////////////////////////////////////////////////////////////
				
			echo json_encode(array('txnid'=>$txnid,'hash'=>$hash,'amount'=>$posted['amount'],'udf1'=>$recepit,'udf3'=>$posted['udf3'],'udf4'=>$posted['mobile'],'udf5'=>$posted['stud_id']));
			//return array('txnid'=>$txnid,'hash'=>$hash);
			//echo $hash;
			}else{
			//redirect("online_fee/pay_fees");
			echo "outside ";exit;
			}
		}
		else
		{
			if(($_POST['amount']==$_SESSION['amount'] &&  $_POST['productinfo']==$_SESSION['ftype'])){ //
		
			$stdata= $this->Online_feemodel->fetch_studentdata();
			///////////////////////////////////////////////////////////////
			// $txnid=date('dmY').rand(100,999);
		   // $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		   // Merchant key here as provided by Payu
		   $MERCHANT_KEY = "soe5Fh"; //Please change this value with live key for production
		   $hash_string = '';
		   // Merchant Salt as provided by Payu
		   $SALT = "OhVBBZuL"; //Please change this value with live salt for production
		   //$txnid=date('ddmmyyyy').rand(100,999);
		   // End point - change to https://secure.payu.in for LIVE mode
		   $PAYU_BASE_URL = "https://secure.payu.in";
		   
			$action = '';
			$_POST['udf3']=$stdata['enrollment_no'];
			$_POST['udf5']=$stdata['stud_id'];
		   $posted = array();
		   if(!empty($_POST)) {
		 //  print_r($_POST);exit();
		   foreach($_POST as $key => $value) {    
		   $posted[$key] = $value; 
		   
		   }
		   }
		   //print_r($_POST);
		  // exit;
		  
		   $txnid='01'.date('ymdhis')."-".$_POST['stud_id'];
		   
		   $trans_id=$this->Online_feemodel->insert_data_in_trans($_POST,$txnid);
		   
		   $recepit = date('ymd')."".$trans_id; //recepit s
		   
		   
		   $formError = 0;
		   
		  // if(empty($posted['txnid'])) {
		   // Generate random transaction id
		   //$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		  //$txnid=date('ddmmyyyy').rand(100,999);
		 //  } else {
		   //$txnid = $posted['txnid'];
		  // }
		  
		   $hash = '';
		   //$txnid=date('dmY').rand(100,999);
		   //$txnid=date('dmY').rand(100,999);
		   // Hash Sequence
		   $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
		 
		 
		   $posted['txnid']=$txnid;
		   
		   if($posted['productinfo']=="Re-Registration"){
			  $amount= $this->Online_feemodel->fetch_ReRegistration($_POST);
			  $udf6=$posted['udf6'];
			  $posted['amount']=$amount+$udf6;
			//  $pay=$amount;
		   }else{
			  $posted['amount']=$posted['amount'];
		   }
		   
		   $posted['udf1']=$recepit;//receipt_no
		  // $posted['udf2']=$posted['udf2'];//Academic Year
		   $posted['udf3']=$posted['udf3'];//enrollment_no
		   $posted['udf4']=$posted['mobile'];//mobile
		   $posted['udf5']=$posted['stud_id'];//user_type 
		   
		   if(empty($_POST['hash']) && sizeof($posted) > 0) {
				 
		   if(empty($posted['key'])|| empty($posted['txnid'])|| empty($posted['amount'])|| empty($posted['firstname'])|| empty($posted['email'])|| empty($posted['productinfo'])) {
			  $formError = 1;
			 //print_r($_POST);exit();
		   } else {
		   
		   $hashVarsSeq = explode('|', $hashSequence);
		   
		   foreach($hashVarsSeq as $hash_var) {
			$hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
			$hash_string .= '|';
		   }
		   
		   $hash_string .= $SALT;
		   
		   
		   $hash = strtolower(hash('sha512', $hash_string));
			
			// print_r($_POST);exit();
		   $action = $PAYU_BASE_URL . '/_payment';
		   }
		   } elseif(!empty($posted['hash'])) {
		   $hash = $posted['hash'];
		   $action = $PAYU_BASE_URL . '/_payment';
		   }
				//echo $hash;
				//exit();
				//////////////////////////////////////////////////////////////
				
			echo json_encode(array('txnid'=>$txnid,'hash'=>$hash,'amount'=>$posted['amount'],'udf1'=>$recepit,'udf3'=>$posted['udf3'],'udf4'=>$posted['mobile'],'udf5'=>$posted['stud_id']));
			//return array('txnid'=>$txnid,'hash'=>$hash);
			//echo $hash;
			}else{
			//redirect("online_fee/pay_fees");
			echo "outside ";exit;
			}
		}
	}
	
	
	
	
	
	
	function Online_fee_entery_gym(){
    $DB1 = $this->load->database('umsdb', TRUE);
		///////////////////////////////////////////////////////////////
		// $txnid=date('dmY').rand(100,999);
   // $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
   // Merchant key here as provided by Payu
   $MERCHANT_KEY = "BGdiP5"; //Please change this value with live key for production
   $hash_string = '';
   // Merchant Salt as provided by Payu
   $SALT = "cynzRXfALgCCW1O2MakDknkMaZ7rOg0A"; //Please change this value with live salt for production
   //$txnid=date('ddmmyyyy').rand(100,999);
   // End point - change to https://secure.payu.in for LIVE mode
   $PAYU_BASE_URL = "https://secure.payu.in";
   
   $action = '';
 //  print_r($_POST);
   $posted = array();
   if(!empty($_POST)) {
 //  print_r($_POST);exit();
   foreach($_POST as $key => $value) {    
   $posted[$key] = $value; 
   
   }
   }
   //print_r($_POST);
  // exit;
  
   $txnid=date('ymdhis')."-".$_POST['stud_id'];
   
   $trans_id=$this->Online_feemodel->insert_data_in_trans_gym($_POST,$txnid);
   
   $recepit = date('ymd')."".$trans_id; //recepit s
   
   
   $formError = 0;
   
  // if(empty($posted['txnid'])) {
   // Generate random transaction id
   //$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
  //$txnid=date('ddmmyyyy').rand(100,999);
 //  } else {
   //$txnid = $posted['txnid'];
  // }
  
   $hash = '';
   //$txnid=date('dmY').rand(100,999);
   //$txnid=date('dmY').rand(100,999);
   // Hash Sequence
   $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
 
 
   $posted['txnid']=$txnid;
   //$posted['amount']=1;
   /*if($posted['productinfo']=="Re-Registration"){
	  //$amount= $this->Online_feemodel->fetch_ReRegistration($_POST);
	  //$udf6=$posted['udf6'];
	 // $posted['amount']=$amount+$udf6;
	//  $pay=$amount;
	 $posted['amount']=$posted['amount'];
   }else{
	  $posted['amount']=$posted['amount'];
   }*/
   $posted['amount']=600 * $_POST['udf6'];
   $posted['udf1']=$recepit;//receipt_no
  // $posted['udf2']=$posted['udf2'];//Academic Year
   $posted['udf3']=$posted['udf3'];//enrollment_no
   $posted['udf4']=$posted['mobile'];//mobile
   $posted['udf5']=$posted['stud_id'];//user_type 
   $posted['udf6']=$posted['udf6'];//user_type 
   if(empty($_POST['hash']) && sizeof($posted) > 0) {
	     
   if(empty($posted['key'])|| empty($posted['txnid'])|| empty($posted['amount'])|| empty($posted['firstname'])|| empty($posted['email'])
|| empty($posted['productinfo'])) {
   $formError = 1;
     //print_r($_POST);exit();
   } else {
   
   $hashVarsSeq = explode('|', $hashSequence);
   
   foreach($hashVarsSeq as $hash_var) {
    $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
    $hash_string .= '|';
   }
   
   $hash_string .= $SALT;
   
   
   $hash = strtolower(hash('sha512', $hash_string));
    
	// print_r($_POST);exit();
   $action = $PAYU_BASE_URL . '/_payment';
   }
   } elseif(!empty($posted['hash'])) {
   $hash = $posted['hash'];
   $action = $PAYU_BASE_URL . '/_payment';
   }
		//echo $hash;
		//exit();
		//////////////////////////////////////////////////////////////
		
		echo json_encode(array('txnid'=>$txnid,'hash'=>$hash,'amount'=>$posted['amount'],'udf1'=>$recepit,'udf3'=>$posted['udf3'],'udf4'=>$posted['mobile'],
		'udf5'=>$posted['stud_id']));
		//return array('txnid'=>$txnid,'hash'=>$hash);
		//echo $hash;
	}
	
	
	
	function Online_fee_entery_hostel_pending(){
    $DB1 = $this->load->database('umsdb', TRUE);
		///////////////////////////////////////////////////////////////
		// $txnid=date('dmY').rand(100,999);
   // $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
   // Merchant key here as provided by Payu
   $MERCHANT_KEY = "BGdiP5"; //Please change this value with live key for production
   $hash_string = '';
   // Merchant Salt as provided by Payu
   $SALT = "cynzRXfALgCCW1O2MakDknkMaZ7rOg0A"; //Please change this value with live salt for production
   //$txnid=date('ddmmyyyy').rand(100,999);
   // End point - change to https://secure.payu.in for LIVE mode
   $PAYU_BASE_URL = "https://secure.payu.in";
   
   $action = '';
 //  print_r($_POST);
   $posted = array();
   if(!empty($_POST)) {
 //  print_r($_POST);exit();
   foreach($_POST as $key => $value) {    
   $posted[$key] = $value; 
   
   }
   }
   //print_r($_POST);
  // exit;
  
   $txnid=date('ymdhis')."-".$_POST['stud_id'];
   
   $trans_id=$this->Online_feemodel->insert_data_in_trans_hostel_pending($_POST,$txnid);
   
   $recepit = date('ymd')."".$trans_id; //recepit s
   
   
   $formError = 0;
   
  // if(empty($posted['txnid'])) {
   // Generate random transaction id
   //$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
  //$txnid=date('ddmmyyyy').rand(100,999);
 //  } else {
   //$txnid = $posted['txnid'];
  // }
  
   $hash = '';
   //$txnid=date('dmY').rand(100,999);
   //$txnid=date('dmY').rand(100,999);
   // Hash Sequence
   $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
 
 
   $posted['txnid']=$txnid;
   //$posted['amount']=1;
   /*if($posted['productinfo']=="Re-Registration"){
	  //$amount= $this->Online_feemodel->fetch_ReRegistration($_POST);
	  //$udf6=$posted['udf6'];
	 // $posted['amount']=$amount+$udf6;
	//  $pay=$amount;
	 $posted['amount']=$posted['amount'];
   }else{
	  $posted['amount']=$posted['amount'];
   }*/
   $reddystudents = $this->Online_feemodel->check_reddy_students($_POST['stud_id']);
   foreach($reddystudents as $ra){
	$redyy_stud[] =$ra['student_id'];
   }
   if(in_array($_POST['stud_id'], $redyy_stud)){
	 $$posted['amount'] =5000;
	}else{
		$hostel_pending=$this->Online_feemodel->Get_hostel_pending();
		$posted['amount']=$hostel_pending['pending_fees'];
	}
   //print_r($reddystudents);exit;
   
   $posted['udf1']=$recepit;//receipt_no
  // $posted['udf2']=$posted['udf2'];//Academic Year
   $posted['udf3']=$posted['udf3'];//enrollment_no
   $posted['udf4']=$posted['mobile'];//mobile
   $posted['udf5']=$posted['stud_id'];//user_type 
   $posted['udf6']=$posted['udf6'];//user_type 
   if(empty($_POST['hash']) && sizeof($posted) > 0) {
	     
   if(empty($posted['key'])|| empty($posted['txnid'])|| empty($posted['amount'])|| empty($posted['firstname'])|| empty($posted['email'])
|| empty($posted['productinfo'])) {
   $formError = 1;
     //print_r($_POST);exit();
   } else {
   
   $hashVarsSeq = explode('|', $hashSequence);
   
   foreach($hashVarsSeq as $hash_var) {
    $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
    $hash_string .= '|';
   }
   
   $hash_string .= $SALT;
   
   
   $hash = strtolower(hash('sha512', $hash_string));
    
	// print_r($_POST);exit();
   $action = $PAYU_BASE_URL . '/_payment';
   }
   } elseif(!empty($posted['hash'])) {
   $hash = $posted['hash'];
   $action = $PAYU_BASE_URL . '/_payment';
   }
		//echo $hash;
		//exit();
		//////////////////////////////////////////////////////////////
		
		echo json_encode(array('txnid'=>$txnid,'hash'=>$hash,'amount'=>$posted['amount'],'udf1'=>$recepit,'udf3'=>$posted['udf3'],'udf4'=>$posted['mobile'],
		'udf5'=>$posted['stud_id']));
		//return array('txnid'=>$txnid,'hash'=>$hash);
		//echo $hash;
	}
	
	function submitPayucausion(){
    $DB1 = $this->load->database('umsdb', TRUE);
		///////////////////////////////////////////////////////////////
		// $txnid=date('dmY').rand(100,999);
   // $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
   // Merchant key here as provided by Payu
   $MERCHANT_KEY = "soe5Fh"; //Please change this value with live key for production
	   $hash_string = '';
	   // Merchant Salt as provided by Payu
	   $SALT = "OhVBBZuL"; //Please change this value with live salt for production
   //$txnid=date('ddmmyyyy').rand(100,999);
   // End point - change to https://secure.payu.in for LIVE mode
   $PAYU_BASE_URL = "https://secure.payu.in";
   
   $action = '';
 //  print_r($_POST);
   $posted = array();
   if(!empty($_POST)) {
 //  print_r($_POST);exit();
   foreach($_POST as $key => $value) {    
   $posted[$key] = $value; 
   
   }
   }
   //print_r($_POST);
  // exit;
  
   $txnid=date('ymdhis')."-".$_POST['stud_id'];
   
   $trans_id=$this->Online_feemodel->insert_data_in_trans_causion($_POST,$txnid);
   
   $recepit = date('ymd')."".$trans_id; //recepit s
   
   
   $formError = 0;
   
  // if(empty($posted['txnid'])) {
   // Generate random transaction id
   //$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
  //$txnid=date('ddmmyyyy').rand(100,999);
 //  } else {
   //$txnid = $posted['txnid'];
  // }
  
		
		////////*******************
		$hash = '';
	   //$txnid=date('dmY').rand(100,999);
	   //$txnid=date('dmY').rand(100,999);
	   // Hash Sequence
	   $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
	 
	 
	   $posted['txnid']=$txnid;
	   
	   $causion_money=$this->Online_feemodel->Get_causion_pending();
	   if(empty($causion_money)){
		  $causion_money['causion_money']=500; 
	   }
	   $posted['amount']=$causion_money['causion_money'];
	   //$posted['amount']=1;
	   
	   $posted['udf1']=$recepit;//receipt_no
	  // $posted['udf2']=$posted['udf2'];//Academic Year
	   $posted['udf3']=$posted['udf3'];//enrollment_no
	   $posted['udf4']=$posted['mobile'];//mobile
	   $posted['udf5']=$posted['stud_id'];//user_type 
	   //print_r( $posted);exit;
	   if(empty($_POST['hash']) && sizeof($posted) > 0) {
			 
	   if(empty($posted['key'])|| empty($posted['txnid'])|| empty($posted['amount'])|| empty($posted['firstname'])|| empty($posted['email']) || empty($posted['productinfo'])) {
		  $formError = 1;
		 //print_r($_POST);exit();
	   } else {
	   
	   $hashVarsSeq = explode('|', $hashSequence);
	   
	   foreach($hashVarsSeq as $hash_var) {
		$hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
		$hash_string .= '|';
	   }
	   
	   $hash_string .= $SALT;
	   
	   
	   $hash = strtolower(hash('sha512', $hash_string));
		
		// print_r($_POST);exit();
	   $action = $PAYU_BASE_URL . '/_payment';
	   }
	   } elseif(!empty($posted['hash'])) {
	   $hash = $posted['hash'];
	   $action = $PAYU_BASE_URL . '/_payment';
	   }
			//echo $hash;
			//exit();
			//////////////////////////////////////////////////////////////
			
		echo json_encode(array('txnid'=>$txnid,'hash'=>$hash,'amount'=>$posted['amount'],'udf1'=>$recepit,'udf3'=>$posted['udf3'],'udf4'=>$posted['mobile'],'udf5'=>$posted['stud_id']));
		//return array('txnid'=>$txnid,'hash'=>$hash);
		//echo $hash;
		
		
		//////////////
	}	
	
	

	
	function Online_fee_entery_test(){
		 $DB1 = $this->load->database('umsdb', TRUE);
		///////////////////////////////////////////////////////////////
		// $txnid=date('dmY').rand(100,999);
   // $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
   // Merchant key here as provided by Payu
   $MERCHANT_KEY = "soe5Fh"; //Please change this value with live key for production
   $hash_string = '';
   // Merchant Salt as provided by Payu
   $SALT = "OhVBBZuL"; //Please change this value with live salt for production
   //$txnid=date('ddmmyyyy').rand(100,999);
   // End point - change to https://secure.payu.in for LIVE mode
   $PAYU_BASE_URL = "https://secure.payu.in";
   
   $action = '';
   
   $posted = array();
   if(!empty($_POST)) {
 //  print_r($_POST);exit();
   foreach($_POST as $key => $value) {    
   $posted[$key] = $value; 
   
   }
   }
   //print_r($_POST);
  // exit;
  
   $txnid=date('ymdhis')."-".$_POST['stud_id'];
   
   $trans_id=$this->Online_feemodel->insert_data_in_trans($_POST,$txnid);
   
   $recepit = date('ymd')."".$trans_id; //recepit s
   
   
   $formError = 0;
   
  // if(empty($posted['txnid'])) {
   // Generate random transaction id
   //$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
  //$txnid=date('ddmmyyyy').rand(100,999);
 //  } else {
   //$txnid = $posted['txnid'];
  // }
  
   $hash = '';
   //$txnid=date('dmY').rand(100,999);
   //$txnid=date('dmY').rand(100,999);
   // Hash Sequence
   $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
 
 
   $posted['txnid']=$txnid;
   
   if($posted['productinfo']=="Re-Registration"){
	 // $amount= $this->Online_feemodel->fetch_ReRegistration($_POST);
	  $udf6=$posted['udf6'];
	  $posted['amount']=$posted['amount'];
	 // $posted['amount']=$amount+$udf6;
	//  $pay=$amount;
   }else{
	  $posted['amount']=$posted['amount'];
   }
   
   $posted['udf1']=$recepit;//receipt_no
  // $posted['udf2']=$posted['udf2'];//Academic Year
   $posted['udf3']=$posted['udf3'];//enrollment_no
   $posted['udf4']=$posted['mobile'];//mobile
   $posted['udf5']=$posted['stud_id'];//user_type 
   
   if(empty($_POST['hash']) && sizeof($posted) > 0) {
	     
   if(empty($posted['key'])|| empty($posted['txnid'])|| empty($posted['amount'])|| empty($posted['firstname'])|| empty($posted['email'])
|| empty($posted['productinfo'])) {
   $formError = 1;
     //print_r($_POST);exit();
   } else {
   
   $hashVarsSeq = explode('|', $hashSequence);
   
   foreach($hashVarsSeq as $hash_var) {
    $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
    $hash_string .= '|';
   }
   
   $hash_string .= $SALT;
   
   
   $hash = strtolower(hash('sha512', $hash_string));
    
	// print_r($_POST);exit();
   $action = $PAYU_BASE_URL . '/_payment';
   }
   } elseif(!empty($posted['hash'])) {
   $hash = $posted['hash'];
   $action = $PAYU_BASE_URL . '/_payment';
   }
		//echo $hash;
		//exit();
		//////////////////////////////////////////////////////////////
		
		echo json_encode(array('txnid'=>$txnid,'hash'=>$hash,'amount'=>$posted['amount'],'udf1'=>$recepit,'udf3'=>$posted['udf3'],'udf4'=>$posted['mobile'],'udf5'=>$posted['stud_id']));
		//return array('txnid'=>$txnid,'hash'=>$hash);
		//echo $hash;
	}
	
	
	
	
	
	
	
	
	
	function Online_fee_entery_full(){
		 $DB1 = $this->load->database('umsdb', TRUE);
		///////////////////////////////////////////////////////////////
		// $txnid=date('dmY').rand(100,999);
   // $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
   // Merchant key here as provided by Payu
   $MERCHANT_KEY = "soe5Fh"; //Please change this value with live key for production
   $hash_string = '';
   // Merchant Salt as provided by Payu
   $SALT = "OhVBBZuL"; //Please change this value with live salt for production
   //$txnid=date('ddmmyyyy').rand(100,999);
   // End point - change to https://secure.payu.in for LIVE mode
   $PAYU_BASE_URL = "https://secure.payu.in";
   
   $action = '';
   
   $posted = array();
   if(!empty($_POST)) {
 //  print_r($_POST);exit();
   foreach($_POST as $key => $value) {    
   $posted[$key] = $value; 
   
   }
   }
   //print_r($_POST);
  // exit;
  
   $txnid=date('ymdhis')."-".$_POST['stud_id'];
   
   $trans_id=$this->Online_feemodel->insert_data_in_trans($_POST,$txnid);
   
   $recepit = date('ymd')."".$trans_id; //recepit s
   
   
   $formError = 0;
   
  // if(empty($posted['txnid'])) {
   // Generate random transaction id
   //$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
  //$txnid=date('ddmmyyyy').rand(100,999);
 //  } else {
   //$txnid = $posted['txnid'];
  // }
  
   $hash = '';
   //$txnid=date('dmY').rand(100,999);
   //$txnid=date('dmY').rand(100,999);
   // Hash Sequence
   $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
 
 
   $posted['txnid']=$txnid;
   
   /*if($posted['productinfo']=="Re-Registration"){
	  $amount= $this->Online_feemodel->fetch_ReRegistration($_POST['stud_id']);
	  $posted['amount']=$amount;
	//  $pay=$amount;
   }else{
	  $posted['amount']=$posted['amount'];
   }*/
   //$posted['amount']=$posted['amount'];
   
   
   if($posted['productinfo']=="Re-Registration-full"){
	  $amount= $this->Online_feemodel->fetch_ReRegistration_full($_POST['stud_id']);
	  $posted['amount']=$amount;
	//  $pay=$amount;
   }else{
	  $posted['amount']=$posted['amount'];
   }
   
   
   
   $posted['udf1']=$recepit;//receipt_no
  // $posted['udf2']=$posted['udf2'];//Academic Year
   $posted['udf3']=$posted['udf3'];//enrollment_no
   $posted['udf4']=$posted['mobile'];//mobile
   $posted['udf5']=$posted['stud_id'];//user_type 
   
   if(empty($_POST['hash']) && sizeof($posted) > 0) {
	     
   if(empty($posted['key'])|| empty($posted['txnid'])|| empty($posted['amount'])|| empty($posted['firstname'])|| empty($posted['email'])
|| empty($posted['productinfo'])) {
   $formError = 1;
     //print_r($_POST);exit();
   } else {
   
   $hashVarsSeq = explode('|', $hashSequence);
   
   foreach($hashVarsSeq as $hash_var) {
    $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
    $hash_string .= '|';
   }
   
   $hash_string .= $SALT;
   
   
   $hash = strtolower(hash('sha512', $hash_string));
    
	// print_r($_POST);exit();
   $action = $PAYU_BASE_URL . '/_payment';
   }
   } elseif(!empty($posted['hash'])) {
   $hash = $posted['hash'];
   $action = $PAYU_BASE_URL . '/_payment';
   }
		//echo $hash;
		//exit();
		//////////////////////////////////////////////////////////////
		
		echo json_encode(array('txnid'=>$txnid,'hash'=>$hash,'amount'=>$posted['amount'],'udf1'=>$recepit,'udf3'=>$posted['udf3'],'udf4'=>$posted['mobile'],'udf5'=>$posted['stud_id']));
		//return array('txnid'=>$txnid,'hash'=>$hash);
		//echo $hash;
	}
	
	
	function test_student(){
		echo $this->Online_feemodel->fetch_ReRegistration_full('4389');
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function Test_session(){
		//echo $_SESSION['name'];
	}
	
	function check_payment_status(){
		
		//error_reporting(0);
$working_key = 'CD259DC1D25B6EC6E48541D3230821EB'; //Shared by CCAVENUES
$access_code = 'AVGM94HH08AM38MGMA';

$merchant_json_data =
    array(
    'order_no' => '21081234821'
	
);

$merchant_data = json_encode($merchant_json_data);
$encrypted_data = $this->someclass->encrypt($merchant_data, $working_key);
$final_data = 'enc_request='.$encrypted_data.'&access_code='.$access_code.'&command=orderStatusTracker&request_type=JSON&response_type=JSON';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.ccavenue.com/apis/servlet/DoWebTrans");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER,'Content-Type: application/json') ;
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $final_data);
// Get server response ...
$result = curl_exec($ch);
curl_close($ch);
$status = '';
$information = explode('&', $result);

$dataSize = sizeof($information);
for ($i = 0; $i < $dataSize; $i++) {
    $info_value = explode('=', $information[$i]);
    if ($info_value[0] == 'enc_response') {
	$status = $this->someclass->decrypt(trim($info_value[1]), $working_key);
	
    }
}

echo 'Status revert is: ' . $status.'<pre>';
 $obj = json_decode($status);
 print_r($obj);
 echo '<br>';
 echo($obj->Order_Status_Result->order_no);
 exit();
 $recepit_no=trim($obj->Order_Status_Result->order_no);
 $txtid=trim($obj->Order_Status_Result->order_ship_address);
 $email=trim($obj->Order_Status_Result->order_bill_email);
 $productinfo=trim($obj->Order_Status_Result->order_bill_name);
 $amount=trim($obj->Order_Status_Result->order_amt);
 $bank_ref_num=trim($obj->Order_Status_Result->order_bank_ref_no);
 $payment_date=trim($obj->Order_Status_Result->order_status_date_time);
 $bank_response=trim($obj->Order_Status_Result->order_bank_response);
 $order_status=trim($obj->Order_Status_Result->order_status);
 
 ///////////////////////////////////////////////////////////////////////////////////////////////////////
 
         
 
 
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
 
 
 
 
 if(($bank_response=="SUCCESS")&&($order_status=="Shipped")){
 
 $get_data=$this->Online_feemodel->Update_Manually_Status($recepit_no,$txtid,$email,$productinfo,$amount,$bank_ref_num,$payment_date);
 ////////////////////////////////////////////////////
 
         $this->data["txnid"] =$txtid;
	     $this->data["udf1"] = $udf1;
	     $this->data["udf2"] =$udf2;
	     $this->data["udf3"] =$udf3;
	     $this->data["udf4"] =$udf4;
	     $this->data["udf5"] =$udf5;//utype//$_REQUEST['student_type'];
		// $this->data["udf6"] =$_REQUEST['udf6'];
	     $this->data["firstname"] = $firstname;
	     $this->data["email"] =$email;
	     $this->data["productinfo"] =$productinfo;
	     $this->data["amount"] =$amount;
	     $this->data['addedon']=date('Y-m-d h:i:s');
	     $this->data['status']=$main_status;
	     $this->data['error']=$failure_message;
	     $this->data['PG_TYPE']='';
	     $this->data['mode']=$payment_mode;
	     $this->data['bank_ref_num']=$bank_ref_no;
	     $this->data['error_Message']=$failure_message;
 ////////////////////////////////////////////////////////////
 
 
 $user_mobile = $mobile;//$udf4//7030942420,8850633088,9545453488,9545453087;
	   $sms_message=urlencode("Dear Student
Your payment of Rs $amount is duly received and tranction no -:$txnid. Your Receipt Number is $udf1
Thanks
Sandip University");
    /*$ch = curl_init();
    $sms=$sms_message;
    $query="?username=u4282&msg_token=j8eAyq&sender_id=SANDIP&message=$sms&mobile=$user_mobile";
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL,'http://103.255.100.77/api/send_transactional_sms.php' . $query);  //http://103.255.100.77/api/send_transactional_sms.php
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $res = trim(curl_exec($ch));
    curl_close($ch);*/
 
 $this->load->view($this->view_dir.'payment_success_manually',$this->data,true);
	}
	
	
	
	
	
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////	
	}
	
	
	
	
	
	
	
	
public	function payment_handler_success(){
	// global $model;
	 $this->load->library('session');
	    $this->load->library('someclass');
	 //exit();
		/*$data=(array(
			'tid'=>$txnid,
'merchant_id'=>$Merchant_id,
'order_id'=>$recepit,
'amount'=>$final_amount,
'currency'=>"INR",
'redirect_url'=>"https://www.sandipuniversity.com/erp/Online_fee/payment_handler",
'cancel_url'=>"https://www.sandipuniversity.com/erp/Online_fee/payment_handler",
'language'=>"EN",
'merchant_param1'=>$recepit,//$posted['udf1']//$recepit
'merchant_param2'=>$_POST['udf2'],//Academic Year,
'merchant_param3'=>$_POST['udf3'],//udf3//enrollment_no
'merchant_param4'=>$_POST['mobile'],//udf4
'merchant_param5'=>$_POST['stud_id'], //udf5
'billing_name'=>$_POST['productinfo'],
'billing_address'=>$_POST['firstname'],//productinfo
'billing_email'=>$_POST['email'],
'delivery_name'=>$txnid,
));*/ 
//echo $_SESSION['name']; //exit();

//print_r($this->session->all_userdata());
//exit();
     $ctid=$this->session->userdata('ctid'); //echo '<br>';
	 $cvamount=$this->session->userdata('cvamount');//echo '<br>';
	 $cvorder_id=$this->session->userdata('cvorder_id');//echo '<br>';
	 $latefee=$this->session->userdata('latefee');
	 $ccv=$this->session->userdata('ccv');
	// print_r($ccv);
	$ccv['tid'];
	$ccv['merchant_id'];
	$ccv['order_id'];
	$ccv['amount'];
	$ccv['currency'];
	$ccv['redirect_url'];
	$ccv['cancel_url'];
	$ccv['language'];
	$ccv['merchant_param1'];
	$ccv['merchant_param2'];
	$ccv['merchant_param3'];
	$ccv['merchant_param4'];
	$ccv['merchant_param5'];
	$ccv['billing_name'];
	$ccv['billing_address'];
	$ccv['billing_email'];
	$ccv['delivery_address'];
//$ccv['merchant_param3'];
	//exit();	
		$this->load->library('someclass');
	$workingKey='CD259DC1D25B6EC6E48541D3230821EB';		//Working Key should be provided here.
	
	//$this->session->set_userdata('ctid', $txnid);
   // $this->session->set_userdata('cvamount', $final_amount);
   // $this->session->set_userdata('cvorder_id', $recepit);
	
	
	$encResponse=$_REQUEST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=$this->someclass->decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	//print_r($rcvdString); echo '<br>';
		$decryptValues=explode('&', $rcvdString);
	
	//	print_r($decryptValues); echo '<br>';
		
		$dataSize=sizeof($decryptValues);
		for($i = 0; $i < $dataSize; $i++) 
	{
		 $information[]=explode('=',$decryptValues[$i]);
		//if($i==3)	$order_status=$information[1];
	}
	//exit();
		 $order_id=$information[0][1];
		 $tracking_id=$information[1][1];
		 $bank_ref_no= $information[2][1];
		 $order_status= $information[3][1];
		 $failure_message= $information[4][1];
		 $payment_mode= $information[5][1];
		 $card_name=$information[6][1];
		
		$amount= $information[10][1];
		$productinfo= $information[11][1];
		
		$firstname= $information[12][1];
		$email= $information[18][1];
	    $txnid= $information[20][1];
		
		$addedon= $information[40][1];
		
		$udf1= $information[26][1];
		$udf2= $information[27][1];
		$udf3= $information[28][1];
		$udf4= $information[29][1];
		$udf5= $information[30][1];
	     $main_status='';
		if($order_status=="Success")
		{
			$main_status='success';
		}else{
			$main_status=$order_status;
		}
		
	     $this->data["txnid"] =$txnid;
	     $this->data["udf1"] = $udf1;
	     $this->data["udf2"] =$udf2;
	     $this->data["udf3"] =$udf3;
	     $this->data["udf4"] =$udf4;
	     $this->data["udf5"] =$udf5;//utype//$_REQUEST['student_type'];
		// $this->data["udf6"] =$_REQUEST['udf6'];
	     $this->data["firstname"] = $firstname;
	     $this->data["email"] =$email;
	     $this->data["productinfo"] =$productinfo;
	     $this->data["amount"] =$amount;
	     $this->data['addedon']=date('Y-m-d h:i:s');
	     $this->data['status']=$main_status;
	     $this->data['error']=$failure_message;
	     $this->data['PG_TYPE']='';
	     $this->data['mode']=$payment_mode;
	     $this->data['bank_ref_num']=$bank_ref_no;
	     $this->data['error_Message']=$failure_message;
		
	//	print_r($this->data);
		//exit();
		$this->Online_feemodel->add_online_feedetails($this->data);
       //var_dump($this->Online_feemodel->getFeesdata());
       //$data['session_details']= $this->Online_feemodel->fetch_studentdata(); 
	   if(($main_status=="success")/*&&($cvamount==$amount)&&($cvorder_id==$order_id)*/){
	    $user_mobile = $udf4;//$udf4//7030942420,8850633088,9545453488,9545453087;
	   $sms_message=urlencode("Dear Student
Your payment of Rs $amount is duly received and tranction no -:$txnid. Your Receipt Number is $udf1
Thanks
Sandip University");
    /*$ch = curl_init();
    $sms=$sms_message;
    $query="?username=u4282&msg_token=j8eAyq&sender_id=SANDIP&message=$sms&mobile=$user_mobile";
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL,'http://103.255.100.77/api/send_transactional_sms.php' . $query);  //http://103.255.100.77/api/send_transactional_sms.php
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $res = trim(curl_exec($ch));
    curl_close($ch);*/
	   
	   
	   
	   $this->load->view('header',$this->data);                         
       $this->load->view($this->view_dir.'payment_success_manually',$this->data,true);
	   
       $this->load->view($this->view_dir.'thankyou',$this->data);
	   
       $this->load->view('footer'); 
	   $this->session->unset_userdata('ctid');
       $this->session->unset_userdata('cvamount');
       $this->session->unset_userdata('cvorder_id');
       $this->session->unset_userdata('latefee');
	   }else{
		        $this->load->view('header',$this->data);    
	            $this->load->view($this->view_dir.'payment_failure',$this->data);
				
                $this->load->view('footer'); 
			    $this->session->unset_userdata('ctid');
                $this->session->unset_userdata('cvamount');
                $this->session->unset_userdata('cvorder_id');
			    $this->session->unset_userdata('latefee');
	   }
	   
	   
	   
	}
	
	
	function payment_handler_failure()
	{
	    $this->load->library('session');
	    $this->load->library('someclass');
	 
	  $ctid=$this->session->userdata('ctid'); //echo '<br>';
	 $cvamount=$this->session->userdata('cvamount');//echo '<br>';
	 $cvorder_id=$this->session->userdata('cvorder_id');//echo '<br>';
	$workingKey='CD259DC1D25B6EC6E48541D3230821EB';		//Working Key should be provided here.
	$encResponse=$_REQUEST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=$this->someclass->decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	//print_r($rcvdString); echo '<br>';
		$decryptValues=explode('&', $rcvdString);
		//print_r($decryptValues); echo '<br>';
		$dataSize=sizeof($decryptValues);
		for($i = 0; $i < $dataSize; $i++) 
	{
		 $information[]=explode('=',$decryptValues[$i]);
		//if($i==3)	$order_status=$information[1];
	}
		 $order_id=$information[0][1];
		 $tracking_id=$information[1][1];
		 $bank_ref_no= $information[2][1];
		 $order_status= $information[3][1];
		 $failure_message= $information[4][1];
		 $payment_mode= $information[5][1];
		 $card_name=$information[6][1];
		
		$amount= $information[10][1];
		$productinfo= $information[11][1];
		
		$firstname= $information[12][1];
		$email= $information[18][1];
		$txnid= $information[20][1];
		
		$addedon= $information[40][1];
		
		$udf1= $information[26][1];
		$udf2= $information[27][1];
		$udf3= $information[28][1];
		$udf4= $information[29][1];
		$udf5= $information[30][1];
	    $main_status='';
		/*if($order_status=="Success")
		{
			$main_status='success';
		}else{
			$main_status=$order_status;
		}*/
	   
	      $this->load->view('header',$this->data);  
	     
	    // $this->data["key"] =$_REQUEST['key'];
	    //  $this->data["hash"] =$_REQUEST['hash'];
	     $this->data["txnid"] =$txnid;
	     $this->data["udf1"] = $udf1;
	     $this->data["udf2"] =$udf2;
	     $this->data["udf3"] =$udf3;
	     $this->data["udf4"] =$udf4;
	     $this->data["udf5"] =$udf5;//utype//$_REQUEST['student_type'];
		// $this->data["udf6"] =$_REQUEST['udf6'];
	           /* $this->data["firstname"] = $_REQUEST['firstname'];
	            $this->data["email"] =$_REQUEST['email'];
	            $this->data["productinfo"] =$_REQUEST['productinfo'];
	            $this->data["amount"] =$_REQUEST['amount'];
	            $this->data['addedon']=date('Y-m-d h:i:s');//$_REQUEST['addedon'];
	            $this->data['status']=$_REQUEST['status'];
	            $this->data['error']=$_REQUEST['error'];
	            $this->data['PG_TYPE']=$_REQUEST['PG_TYPE'];
	            $this->data['mode']=$_REQUEST['mode'];
	            $this->data['bank_ref_num']=$_REQUEST['bank_ref_num'];
	            $this->data['error_Message']=$_REQUEST['error_Message'];*/
				
		 $this->data["firstname"] = $firstname;
	     $this->data["email"] =$email;
	     $this->data["productinfo"] =$productinfo;
	     $this->data["amount"] =$amount;
	     $this->data['addedon']=date('Y-mm-dd h:i:s');
	     $this->data['status']=$order_status;
	     $this->data['error']=$failure_message;
	     $this->data['PG_TYPE']='';
	     $this->data['mode']=$payment_mode;
	     $this->data['bank_ref_num']=$bank_ref_no;
	     $this->data['error_Message']=$failure_message;	
				
                $this->Online_feemodel->add_online_feedetails($this->data);
	            $this->load->view('header',$this->data);    
	            $this->load->view($this->view_dir.'payment_failure',$this->data);
				$this->session->unset_userdata('ctid');
                $this->session->unset_userdata('cvamount');
                $this->session->unset_userdata('cvorder_id');
                $this->load->view('footer'); 
	}
	
	
		function Online_fee_entery_ccavenue(){
			$this->load->library('session');
//echo $_SESSION['name']; //exit();
    $DB1 = $this->load->database('umsdb', TRUE);
		///////////////////////////////////////////////////////////////
		// $txnid=date('dmY').rand(100,999);
   // $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
   // Merchant key here as provided by Payu
  // $MERCHANT_KEY = "soe5Fh"; //Please change this value with live key for production
  // $hash_string = '';
   // Merchant Salt as provided by Payu
  // $SALT = "OhVBBZuL"; //Please change this value with live salt for production
   //$txnid=date('ddmmyyyy').rand(100,999);
   // End point - change to https://secure.payu.in for LIVE mode
  // $PAYU_BASE_URL = "https://secure.payu.in";
  // 	$this->session->unset_userdata('ctid');
  //  $this->session->unset_userdata('cvamount');
  //  $this->session->unset_userdata('cvorder_id');
  //  $this->session->unset_userdata('latefee');
   //$action = '';
   $final_amount=0;
   $merchant_data='2345';
   $working_key='CD259DC1D25B6EC6E48541D3230821EB';//'CD259DC1D25B6EC6E48541D3230821EB';//Shared by CCAVENUES
   $access_code='AVGM94HH08AM38MGMA';//'AVGM94HH08AM38MGMA';//Shared by CCAVENUES
   $Merchant_id='268753';//'268753';  
   
   
   
  /* $posted = array();
   if(!empty($_POST)) {
 //  print_r($_POST);exit();
   foreach($_POST as $key => $value) {    
   $posted[$key] = $value; 
   
   }
   }*/
   //print_r($_POST);
  // exit;
  
   //Our dates and times.
//$then = "2020-07-31 00:00:00"; //7/31/2020
//Our "then" date.
$then = "2020-07-31";
 
//Convert it into a timestamp.
$then = strtotime($then);
 
//Get the current timestamp.
$now = time();
 
//Calculate the difference.
$difference = $now - $then;
 
//Convert seconds into days.
$days = floor($difference / (60*60*24) );
 
$latefee=$days*0;
   
   //exit();
  
  
   /*$txnid=date('ymdhis')."-".$_POST['stud_id'];
   
   $trans_id=$this->Online_feemodel->insert_data_in_trans($_POST,$txnid);
   
   $recepit = date('ymd')."".$trans_id; //recepit s*/
   
 //$_POST['amount']='10';
   $latefee=0;
   if($_POST['productinfo']=="Re-Registration"){
	  $amount= $this->Online_feemodel->fetch_ReRegistration($_POST);
	  
	  
	  $udf6=$_POST['udf6'];
	  $final_amount=$amount+$latefee;
	  $this->session->set_userdata('cvamount', $final_amount);
	//  $pay=$amount;
	}elseif($_POST['productinfo']=="Admission"){
	
	  $amount=$this->Online_feemodel->fetch_admission($_POST);
	  $udf6=$_POST['udf6'];
	  if($_POST['stud_id']=="4192"){
		  $final_amount=$_POST['amount'];
	  }else{
		  $final_amount=$amount;
	  }
	  
	  $this->session->set_userdata('cvamount', $final_amount);
   }else{
	  $final_amount=$_POST['amount'];
	  $this->session->set_userdata('cvamount', $final_amount);
   }
   
   //if(!empty($final_amount))
   if(!($final_amount<=0)){
   
    $_POST['amount']=$final_amount;
    $txnid=date('ymdhis')."-".$_POST['stud_id'];
   
   $trans_id=$this->Online_feemodel->insert_data_in_trans($_POST,$txnid);
   
   $recepit = date('ymd')."".$trans_id; //recepit s
   
  // $this->Online_feemodel->Update_recepit($recepit,$txnid);
   
 //  echo	$amount= $this->Online_feemodel->fetch_admission($_POST);
  // exit();
   $this->session->set_userdata('ctid', $txnid);
   
   $this->session->set_userdata('latefee', $latefee);
   $this->session->set_userdata('cvorder_id', $recepit);
  
 // $final_amount='1';
  //  $this->session->set_userdata('cvamount', $final_amount);
   $data=(array(
			'tid'=>$txnid,
'merchant_id'=>$Merchant_id,
'order_id'=>$recepit,
'amount'=>$final_amount,
'currency'=>"INR",
'redirect_url'=>"https://www.sandipuniversity.com/erp/online_fee/payment_handler_success",
'cancel_url'=>"https://www.sandipuniversity.com/erp/online_fee/payment_handler_failure",
'language'=>"EN",
'merchant_param1'=>$recepit,//$posted['udf1']//$recepit
'merchant_param2'=>$_POST['udf2'],//Academic Year,
'merchant_param3'=>$_POST['udf3'],//udf3//enrollment_no
'merchant_param4'=>$_POST['mobile'],//udf4
'merchant_param5'=>$_POST['stud_id'], //udf5
'billing_name'=>$_POST['productinfo'],
'billing_address'=>$_POST['firstname'],//productinfo
'billing_email'=>$_POST['email'],
'delivery_address'=>$txnid,
));
   
   $this->session->set_userdata('ccv',$data);
   //print_r($data);
   
   
  // exit();
   foreach ($data as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}
	
	$encrypted_data=$this->someclass->encrypt($merchant_data,$working_key);
	?>
<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php //https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction  
//https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
//echo json_encode(array('encRequest'=>$encrypted_data,'access_code'=>$access_code));
?>
</form></center><script language='javascript'>document.redirect.submit();</script>


<?php }else{ redirect('online_fee/pay_fees'); }
 //  $formError = 0;
   
  // if(empty($posted['txnid'])) {
   // Generate random transaction id
   //$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
  //$txnid=date('ddmmyyyy').rand(100,999);
 //  } else {
   //$txnid = $posted['txnid'];
  // }
  
   //$hash = '';
   //$txnid=date('dmY').rand(100,999);
   //$txnid=date('dmY').rand(100,999);
   // Hash Sequence
   //$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
 
 
   /*$posted['txnid']=$txnid;
   
   if($posted['productinfo']=="Re-Registration"){
	  $amount= $this->Online_feemodel->fetch_ReRegistration($_POST);
	  $udf6=$posted['udf6'];
	  $posted['amount']=$amount+$udf6;
	//  $pay=$amount;
   }else{
	  $posted['amount']=$posted['amount'];
   }
   
   $posted['udf1']=$recepit;//receipt_no
  // $posted['udf2']=$posted['udf2'];//Academic Year
   $posted['udf3']=$posted['udf3'];//enrollment_no
   $posted['udf4']=$posted['mobile'];//mobile
   $posted['udf5']=$posted['stud_id'];//user_type 
   
   if(empty($_POST['hash']) && sizeof($posted) > 0) {
	     
   if(empty($posted['key'])|| empty($posted['txnid'])|| empty($posted['amount'])|| empty($posted['firstname'])|| empty($posted['email'])
|| empty($posted['productinfo'])) {
   $formError = 1;
     //print_r($_POST);exit();
   } else {
   
   $hashVarsSeq = explode('|', $hashSequence);
   
   foreach($hashVarsSeq as $hash_var) {
    $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
    $hash_string .= '|';
   }
   
   $hash_string .= $SALT;
   
   
   $hash = strtolower(hash('sha512', $hash_string));
    
	// print_r($_POST);exit();
   $action = $PAYU_BASE_URL . '/_payment';
   }
   } elseif(!empty($posted['hash'])) {
   $hash = $posted['hash'];
   $action = $PAYU_BASE_URL . '/_payment';
   }*/
		//echo $hash;
		//exit();
		//////////////////////////////////////////////////////////////
		
	//	echo json_encode(array('txnid'=>$txnid,'hash'=>$hash,'amount'=>$posted['amount'],'udf1'=>$recepit,'udf3'=>$posted['udf3'],'udf4'=>$posted['mobile'],'udf5'=>$posted['stud_id']));
		//return array('txnid'=>$txnid,'hash'=>$hash);
		//echo $hash;
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
////////////////////////////////////////////////////////////////////////////////////////////////	
	
	function success()
	{	
	    //$post[]="";
	//   var_dump($_REQUEST);
//	   exit();
//	   error_reporting(E_ALL);
  //  ini_set('display_errors', 1);
	    $prn =$_SESSION['name']; 
	     if($prn==$_REQUEST['udf3']){
	     
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
	     $this->data['user_id']=$this->data['bank_ref_num']=$_REQUEST['bank_ref_num'];
	     $this->data['error_Message']=$_REQUEST['error_Message'];
	     
	     
	     
	     
	     /*$this->data["key"] ="soe5Fh";//$_REQUEST['key'];
	      $this->data["hash"] ="soe5Fh45ere";//$_REQUEST['hash'];
	       $this->data["txnid"] ="soe5Fh343se";//$_REQUEST['txnid'];
	        $this->data["udf1"] ="soe5Fh343fdfd";//$receipt//$_REQUEST['udf1'];
	           $this->data["udf2"] ="2017";//academic year//$_REQUEST['udf2'];
	         $this->data["udf3"] ="170401001";//enrollment_no//$_REQUEST['udf3'];
	           $this->data["udf4"] ="2323232";//mobile//$_REQUEST['udf4'];
	            $this->data["udf5"] ="R";//utype//$_REQUEST['student_type'];
	             $this->data["firstname"] ="balasaheb";//$_REQUEST['firstname'];
	           $this->data["email"] ="test@gmail.com";//$_REQUEST['email'];
	            $this->data["productinfo"] ="2";//$_REQUEST['feetype'];
	             $this->data["amount"] ="1200";////$_REQUEST['amount'];
	             
	                $this->data['addedon']="HDFC";////$_REQUEST['addedon'];
	            $this->data['status']="HDFC";//$_REQUEST['status'];
	            $this->data['error']="HDFC";//$_REQUEST['error_code'];
	            $this->data['PG_TYPE']="HDFC";//$_REQUEST['PG_TYPE'];
	            $this->data['mode']="CC";//$_REQUEST['mode'];
	            $this->data['bank_ref_num']="wewe2322we2324";//$_REQUEST['bank_ref_num'];
	            $this->data['error_Message']="error";//$_REQUEST['error_Message']
	            */
	            

     
       $this->Online_feemodel->add_online_feedetails($this->data);
       //var_dump($this->Online_feemodel->getFeesdata());
       //$data['session_details']= $this->Online_feemodel->fetch_studentdata(); 
	    $user_mobile = $udf4;//$udf4//7030942420,8850633088,9545453488,9545453087;
	   /*$sms_message=urlencode("Dear Student
Your payment of Rs $amount is duly received and tranction no -:$txnid. Your Receipt Number is $udf1
Thanks
Sandip University");
 $ch = curl_init();
    $sms=$sms_message;
    $query="?username=u4282&msg_token=j8eAyq&sender_id=SANDIP&message=$sms&mobile=$user_mobile";
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL,'http://103.255.100.77/api/send_transactional_sms.php' . $query);  //http://103.255.100.77/api/send_transactional_sms.php
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $res = trim(curl_exec($ch));
    curl_close($ch);*/
	   
	   
	   
	   $this->load->view('header',$this->data);                         
       $this->load->view($this->view_dir.'payment_success',$this->data,true);
	   
       $this->load->view($this->view_dir.'thankyou',$this->data);
       $this->load->view('footer');
		}else{
			 echo "Not valid Request";
		 }	   
	   // redirect('Thankyou');   
	}
	
	
	
	
	function Thankyou(){
    $this->load->view('header',$this->data);  
	$this->load->view($this->view_dir.'thankyou',$this->data);
	$this->load->view('footer'); 
	}
	function Test_payment(){
		
		 $this->data["key"] =1234;
	     $this->data["hash"] ='44355dfgdgdgdgd';
	     $this->data["txnid"] ='123434';
	     $this->data["udf1"] = '123434';
	     $this->data["udf2"] ='123434';
	     $this->data["udf3"] ='123434';
	     $this->data["udf4"] ='123434';
	     $this->data["udf5"] ="R";//utype//$_REQUEST['student_type'];
	     $this->data["firstname"] = '123434';
	     $this->data["email"] ='123434';
	     $this->data["productinfo"] ='123434';
	     $this->data["amount"] ='123434';
	     $this->data['addedon']='123434';
	     $this->data['status']='123434';
	     $this->data['error']='123434';
	     $this->data['PG_TYPE']='123434';
	     $this->data['mode']='123434';
	     $this->data['bank_ref_num']='123434';
	     $this->data['error_Message']='123434';
		 $this->load->view($this->view_dir.'payment_success',$this->data);
	}


	function failure()
	{
	    //echo 'payment failed inside';exit;
	      $this->load->view('header',$this->data);  
	     
	     $this->data["key"] =$_REQUEST['key'];
	      $this->data["hash"] =$_REQUEST['hash'];
	       $this->data["txnid"] =$_REQUEST['txnid'];
	        $this->data["udf1"] = $_REQUEST['udf1'];
	           $this->data["udf2"] =$_REQUEST['udf2'];
	         $this->data["udf3"] =$_REQUEST['udf3'];
	           $this->data["udf4"] =$_REQUEST['udf4'];
	            $this->data["udf5"] =$_REQUEST['udf5'];//utype//$_REQUEST['student_type'];
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
				
                $this->Online_feemodel->add_online_feedetails($this->data);
	            $this->load->view('header',$this->data);    
	            $this->load->view($this->view_dir.'payment_failure',$this->data);
                $this->load->view('footer'); 
	}
	
function fetch_feedet()
{
     $this->Online_feemodel->fetch_feedet();
}

function fetch_feedet_test()
{
     $this->Online_feemodel->fetch_feedet();
}

function fetch_feedet_full()
{
     $this->Online_feemodel->fetch_feedet_full();
}


public function received_payment_details()
{

    	$this->load->view('header', $this->data);
   $this->data['payment_data']	=  $this->Online_feemodel->received_payment_details();
   	
        $this->load->view($this->view_dir . 'ic_prov_adm_payment_list.php', $this->data);
     	$this->load->view('footer');       
        
           
}	
 public function ic_adm_payment()
    {
        global $model;
        $this->load->view('header',$this->data);    
         $this->data['emp_list']= $this->Online_feemodel->getFeesdata_ic();
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'ic_adm_fee_listing',$this->data);
        $this->load->view('footer');
    }	
	
	 public function Online_Test()
    {
        global $model;
        $this->load->view('header',$this->data);    
         $this->data['emp_list']= $this->Online_feemodel->getFeesdata();
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'fee_listing_test',$this->data);
        $this->load->view('footer');
    }
	
	public function Challan(){
		
		//echo 'TEts';
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==40){
		}else{
			redirect('home');
		}
		$this->load->model('Challan_model');
	    global $model;
        $this->load->view('header',$this->data);    
		 $recepit=$this->uri->segment(3);
		 $productinfo =$this->uri->segment(4);
		
		 $this->data['productinfo']=$this->uri->segment(4);
		//exit();
		if($productinfo=="New_Admission"){
		$this->data['user_details']=$this->Online_feemodel->get_details($recepit);
		$dats=$this->data['user_details'];
			}elseif($productinfo=="International_Admission"){
		$this->data['user_details']=$this->Online_feemodel->get_details_int($recepit);
		$dats=$this->data['user_details'];
		}
			else{
		$this->data['user_details']=$this->Online_feemodel->get_details_register($recepit);
		$dats=$this->data['user_details'];
		}
		
		
		//print_r($this->data['user_details']);
		//exit();
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		//$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		
		if(($dats[0]['admission_cycle']=="")||($dats[0]['admission_cycle']==NULL)){
			//print_r($this->data['user_details']);
		//exit();
		$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->load->view($this->view_dir.'add_fees_challan_details_new',$this->data);
		}else{
		$this->data['examsession']=$this->Challan_model->get_examsession_phd();
		$this->load->view($this->view_dir.'add_fees_challan_details_new_phd',$this->data);
		}
        $this->load->view('footer');
	}
	
	
	
	public function External_challan(){
		
		//echo 'TEts';
		$this->load->model('Challan_model');
	    global $model;
        $this->load->view('header',$this->data);    
		 $recepit=$this->uri->segment(3);
		 $this->data['productinfo']=$this->uri->segment(4);
		//exit();
		$this->data['user_details']=$this->Online_feemodel->get_details($recepit);
		$dats=$this->data['user_details'];
		//print_r($this->data['user_details']);
		//exit();
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		//$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		
		//if(($dats[0]['admission_cycle']=="")||($dats[0]['admission_cycle']==NULL)){
			//print_r($this->data['user_details']);
		//exit();
		$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->load->view($this->view_dir.'External_challan',$this->data);
		//}else{
		//$this->data['examsession']=$this->Challan_model->get_examsession_phd();
		//$this->load->view($this->view_dir.'add_fees_challan_details_new_phd',$this->data);
		//}
        $this->load->view('footer');
	}
	
	public function External_challan_mba(){
		
		//echo 'TEts';
		$this->load->model('Challan_model');
	    global $model;
        $this->load->view('header',$this->data);    
		 $recepit=$this->uri->segment(3);
		 $this->data['productinfo']=$this->uri->segment(4);
		//exit();
		$this->data['user_details']=$this->Online_feemodel->get_details_mba($recepit);
		$dats=$this->data['user_details'];
		//print_r($this->data['user_details']);
		//exit();
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		//$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		
		//if(($dats[0]['admission_cycle']=="")||($dats[0]['admission_cycle']==NULL)){
			//print_r($this->data['user_details']);
		//exit();
		//$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->load->view($this->view_dir.'External_challan_mba',$this->data);
		//}else{
		//$this->data['examsession']=$this->Challan_model->get_examsession_phd();
		//$this->load->view($this->view_dir.'add_fees_challan_details_new_phd',$this->data);
		//}
        $this->load->view('footer');
	}
	
	
	public function External_submit(){
		
        $challan_digits=4;
		if($_POST['fees_date']==''){
			$fdate=date("Y-m-d");
		}else{
			$fdate=date("Y-m-d", strtotime($_POST['fees_date'])); 
		}
	//echo '<pre>';	print_r($_POST);
		
	//	exit;
		
		
		
		$guest_name=$_POST['guest_name'];
		$guest_mobile=$_POST['guest_mobile'];
		$guest_organisation=$_POST['guest_organisation'];
		$guest_address=$_POST['guest_address'];
		$guest_year=$_POST['guest_year'];
		
		
		//echo $fdate; exit();
		//////////////////////////////////////////////////////////////////////////////////////////////
		
		$RegistrationFees=$_POST['RegistrationFees'];
		$OtherFees=$_POST['guest_OtherFees'];
		
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////
		 $insert_array=array(
		"academic_year"=>$_POST['academic'],"type_id"=>'11',"bank_account_id"=>$_POST['depositto'],
		"guest_name"=>$_POST['guest_name'],"guest_mobile"=>$_POST['guest_mobile'],
		"guest_organisation"=>$_POST['guest_organisation'],"guest_year"=>$guest_year,"guest_address"=>$_POST['guest_address'],
		"guest_RegistrationFees"=>$_POST['guest_RegistrationFees'],"guest_OtherFees"=>$_POST['guest_OtherFees'],
		"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],"TransactionNo"=>$_POST['TransactionNo'],
		"TransactionDate"=>$fdate,
		"receipt_no"=>$_POST['receipt_number'],"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],"remark"=>$_POST['Remark'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),
		"created_on"=>date("Y-m-d H:i:s"));
		
		//print_r($insert_array); exit();
		
		  $last_inserted_id= $this->Challan_model->add_fees_challan_submit($insert_array);
		//echo 'last_inserted_id==='.$last_inserted_id;exit();
		if($last_inserted_id)
		{
			if($last_inserted_id>9999)
			{
				$challan_digits=strlen($last_inserted_id);
			}
			//if($_POST['curr_yr']=="1"){
				$addmision_type='E';
			//}else{
			//	$addmision_type='R';
			//}
			
			$current_month=date('m');
			
			//if($current_month<=5){
			//	$month_session="2";
			//}else{
				$month_session="1";
			//}
			
			
			
			$ayear= substr(2020, -2);  //explode("-",$_POST['academic']);
			$challan_no=$ayear.'SUN'.$addmision_type.$month_session.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			$update_array=array("exam_session"=>$challan_no);
			
			$last_inserted_id= $this->Challan_model->update_challan_no($last_inserted_id,$update_array);
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}
		else
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
        
	    //	redirect(base_url($this->view_dir));
		redirect("Challan");
	}
	
	
	function test_date(){
		echo date('y-m-d-his'); 
		echo '<br>';
		echo date('ymd');
	}
	
	function payfeesnew()
	{
	    
	   //var_dump($_SESSION);
	   if($_POST){
	      
	     //  var_dump($_POST);
	     //  exit(0);
	        $this->load->view('header',$this->data);    
      //   $this->data['emp_list']= $this->Online_feemodel->getFeesdata();
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'pay_fees',$_POST);
        $this->load->view('footer'); 
        
	   }
	   else
	   {
		   
	      $this->load->view('header',$this->data);    
          $stdata= $this->Online_feemodel->fetch_studentdata();
		  $this->data['stdata']=$stdata;
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();  
	   if($stdata['stud_id']==3737)          {             
        $this->load->view($this->view_dir.'pay_fees_manually',$this->data);//pay_fees
	  }else{                
        $this->load->view($this->view_dir.'payfeesnew',$this->data);//pay_fees
	  }
        $this->load->view('footer'); 
	   }
	    
	}
	
	
	
	public function save()
	{

		$data=$this->input->post(array(
			'tid'=>'tid',
'merchant_id'=>'merchant_id',
'order_id'=>'order_id',
'amount'=>'amount',
'currency'=>'currency',
'redirect_url'=>'redirect_url',
'cancel_url'=>'cancel_url',
'language'=>'language',
'delivery_name'=>'delivery_name',
'delivery_address'=>'delivery_address',
'delivery_city'=>'delivery_city',
'delivery_state'=>'delivery_state',
'delivery_zip'=>'delivery_zip',
'delivery_country'=>'delivery_country',
'delivery_tel'=>'delivery_tel'

		));

//var_dump($data);



	
	$merchant_data='';
	$working_key='CD259DC1D25B6EC6E48541D3230821EB';//Shared by CCAVENUES
	$access_code='AVGM94HH08AM38MGMA';//Shared by CCAVENUES
	
	foreach ($data as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}

	//$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.
	$this->load->library('crypto_ccavnu');

	$encrypted_data=$this->crypto_ccavnu->encrypt($merchant_data,$working_key); 

	var_dump($encrypted_data);

?>
<form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form></center><script language='javascript'>document.redirect.submit();</script>


<?php
		echo "Payment Works";
	}	
	








function provision_add(){
	
	$this->load->view('header',$this->data);
	$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->data['bank_details']= $this->Challan_model->getbanks();
	$this->load->view($this->view_dir.'provision_add',$this->data);
	$this->load->view('footer');
}
	
	public function students_data()
	{
		$std_details = $this->Online_feemodel->students_data($_POST);   
		//var_dump($std_details);
	   	echo json_encode(array("std_details"=>$std_details));
	}
	
	public function get_fee(){
		  $fee_details_new = $this->Online_feemodel->fee_details($_POST);
		 echo $fee_details_new[0]['total_fees'];
		 
	}
	
	public function save_slot(){
		print_r($_POST);
		//exit();
		$emp_id = $this->session->userdata("name");
		$role_id = $this->session->userdata('role_id');
		$uId=$this->session->userdata('uid');
		$fee_details_new = $this->Online_feemodel->save_slot($_POST);
		//fee_slot
		
	}
    public function download_student_challan_pdf($fees_id)
	{
		//load mPDF library
        
		//$this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		//echo $hgp_id.','.$stud_prn.','.$stud_org;exit();
		$this->load->library('m_pdf', $param);
		$this->load->model('Challan_model');
		if($fees_id!='')
		{
			$std_challan_details=$this->Challan_model->fees_challan_list_byid($fees_id);
			//print_r($std_challan_details);
			//exit;
		  //echo json_encode(array("std_gatepass_details"=>$std_gatepass_details));
			$this->data['std_challan_details']= $std_challan_details;
		}
//$this->load->view($this->view_dir.'facility_challan_pdf', $this->data);

		$html = $this->load->view('Challan/facility_challan_pdf', $this->data, true);
		$pdfFilePath = $this->data['std_challan_details']['enrollment_no']."_facilityfee_challan_pdf.pdf";

		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		
		//$this->m_pdf->pdf=new mPDF('L','A4-L','','5',5,5,5,5,5,5);
		$this->m_pdf->pdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            5, // margin top
            5, // margin bottom
            5, // margin header
            5); // margin footer
		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
		
		// ob_end_flush(); 
		
	}	
	
	 public function download_student_challan_PHD_pdf($fees_id)
	{
		//load mPDF library
        
		//$this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		//echo $hgp_id.','.$stud_prn.','.$stud_org;exit();
		$this->load->library('m_pdf', $param);
		$this->load->model('Challan_model');
		if($fees_id!='')
		{
			$std_challan_details=$this->Phd_challan_model->fees_challan_list_byid($fees_id);
			//print_r($std_challan_details);
			//exit;
		  //echo json_encode(array("std_gatepass_details"=>$std_gatepass_details));
			$this->data['std_challan_details']= $std_challan_details;
		}
//$this->load->view($this->view_dir.'facility_challan_pdf', $this->data);

		$html = $this->load->view('Challan/facility_challan_pdf', $this->data, true);
		$pdfFilePath = $this->data['std_challan_details']['enrollment_no']."_facilityfee_challan_pdf.pdf";

		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		
		//$this->m_pdf->pdf=new mPDF('L','A4-L','','5',5,5,5,5,5,5);
		$this->m_pdf->pdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            5, // margin top
            5, // margin bottom
            5, // margin header
            5); // margin footer
		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
		
		// ob_end_flush(); 
		
	}	
	
	function success_gym()
	{
	    
		
		
		
		
		
	    //$post[]="";
	//   var_dump($_REQUEST);
//	   exit();
//	   error_reporting(E_ALL);
  //  ini_set('display_errors', 1);
	    
	     
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
	     
	     
	     
	     
	     /*$this->data["key"] ="soe5Fh";//$_REQUEST['key'];
	      $this->data["hash"] ="soe5Fh45ere";//$_REQUEST['hash'];
	       $this->data["txnid"] ="soe5Fh343se";//$_REQUEST['txnid'];
	        $this->data["udf1"] ="soe5Fh343fdfd";//$receipt//$_REQUEST['udf1'];
	           $this->data["udf2"] ="2017";//academic year//$_REQUEST['udf2'];
	         $this->data["udf3"] ="170401001";//enrollment_no//$_REQUEST['udf3'];
	           $this->data["udf4"] ="2323232";//mobile//$_REQUEST['udf4'];
	            $this->data["udf5"] ="R";//utype//$_REQUEST['student_type'];
	             $this->data["firstname"] ="balasaheb";//$_REQUEST['firstname'];
	           $this->data["email"] ="test@gmail.com";//$_REQUEST['email'];
	            $this->data["productinfo"] ="2";//$_REQUEST['feetype'];
	             $this->data["amount"] ="1200";////$_REQUEST['amount'];
	             
	                $this->data['addedon']="HDFC";////$_REQUEST['addedon'];
	            $this->data['status']="HDFC";//$_REQUEST['status'];
	            $this->data['error']="HDFC";//$_REQUEST['error_code'];
	            $this->data['PG_TYPE']="HDFC";//$_REQUEST['PG_TYPE'];
	            $this->data['mode']="CC";//$_REQUEST['mode'];
	            $this->data['bank_ref_num']="wewe2322we2324";//$_REQUEST['bank_ref_num'];
	            $this->data['error_Message']="error";//$_REQUEST['error_Message']
	            */
	            

     
       $this->Online_feemodel->add_online_feedetails_gym($this->data);
       //var_dump($this->Online_feemodel->getFeesdata());
       //$data['session_details']= $this->Online_feemodel->fetch_studentdata(); 
	    $user_mobile = $udf4;//$udf4//7030942420,8850633088,9545453488,9545453087;
	   $sms_message=urlencode("Dear Student
Your payment of Rs $amount is duly received and tranction no -:$txnid. Your Receipt Number is $udf1
Thanks
Sandip University");
 $ch = curl_init();
    $sms=$sms_message;
    $query="?username=u4282&msg_token=j8eAyq&sender_id=SANDIP&message=$sms&mobile=$user_mobile";
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL,'http://103.255.100.77/api/send_transactional_sms.php' . $query);  //http://103.255.100.77/api/send_transactional_sms.php
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $res = trim(curl_exec($ch));
    curl_close($ch);
	   
	   
	   
	  // $this->load->view('header',$this->data);                         
       $this->load->view($this->view_dir.'payment_success_gym',$this->data,true);
	   
       $this->load->view($this->view_dir.'thankyou',$this->data);
       $this->load->view('footer'); 
	   // redirect('Thankyou');   
	}
	
	function failure_gym()
	{
	    
	      $this->load->view('header',$this->data);  
	     
	     $this->data["key"] =$_REQUEST['key'];
	      $this->data["hash"] =$_REQUEST['hash'];
	       $this->data["txnid"] =$_REQUEST['txnid'];
	        $this->data["udf1"] = $_REQUEST['udf1'];
	           $this->data["udf2"] =$_REQUEST['udf2'];
	         $this->data["udf3"] =$_REQUEST['udf3'];
	           $this->data["udf4"] =$_REQUEST['udf4'];
	            $this->data["udf5"] =$_REQUEST['udf5'];//utype//$_REQUEST['student_type'];
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
				
                $this->Online_feemodel->add_online_feedetails_gym($this->data);
	           // $this->load->view('header',$this->data);    
	            $this->load->view($this->view_dir.'payment_failure',$this->data);
                $this->load->view('footer'); 
	}
	
	
	////////////////////////////////////////////////////////////////////
	
	function success_hostel_pending()
	{
	    
		
		
		
		
		
	    //$post[]="";
	//   var_dump($_REQUEST);
//	   exit();
	  // error_reporting(E_ALL);
    //ini_set('display_errors', 1);
	    
	     
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
	     
	     
	     
	     
	     /*$this->data["key"] ="soe5Fh";//$_REQUEST['key'];
	      $this->data["hash"] ="soe5Fh45ere";//$_REQUEST['hash'];
	       $this->data["txnid"] ="soe5Fh343se";//$_REQUEST['txnid'];
	        $this->data["udf1"] ="soe5Fh343fdfd";//$receipt//$_REQUEST['udf1'];
	           $this->data["udf2"] ="2017";//academic year//$_REQUEST['udf2'];
	         $this->data["udf3"] ="170401001";//enrollment_no//$_REQUEST['udf3'];
	           $this->data["udf4"] ="2323232";//mobile//$_REQUEST['udf4'];
	            $this->data["udf5"] ="R";//utype//$_REQUEST['student_type'];
	             $this->data["firstname"] ="balasaheb";//$_REQUEST['firstname'];
	           $this->data["email"] ="test@gmail.com";//$_REQUEST['email'];
	            $this->data["productinfo"] ="2";//$_REQUEST['feetype'];
	             $this->data["amount"] ="1200";////$_REQUEST['amount'];
	             
	                $this->data['addedon']="HDFC";////$_REQUEST['addedon'];
	            $this->data['status']="HDFC";//$_REQUEST['status'];
	            $this->data['error']="HDFC";//$_REQUEST['error_code'];
	            $this->data['PG_TYPE']="HDFC";//$_REQUEST['PG_TYPE'];
	            $this->data['mode']="CC";//$_REQUEST['mode'];
	            $this->data['bank_ref_num']="wewe2322we2324";//$_REQUEST['bank_ref_num'];
	            $this->data['error_Message']="error";//$_REQUEST['error_Message']
	            */
	            

     
       $this->Online_feemodel->add_online_feedetails_gym($this->data);
       //var_dump($this->Online_feemodel->getFeesdata());
       //$data['session_details']= $this->Online_feemodel->fetch_studentdata(); 
	    $user_mobile = $udf4;//$udf4//7030942420,8850633088,9545453488,9545453087;
	   $sms_message=urlencode("Dear Student
Your payment of Rs $amount is duly received and tranction no -:$txnid. Your Receipt Number is $udf1
Thanks
Sandip University");
/* $ch = curl_init();
    $sms=$sms_message;
    $query="?username=u4282&msg_token=j8eAyq&sender_id=SANDIP&message=$sms&mobile=$user_mobile";
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL,'http://103.255.100.77/api/send_transactional_sms.php' . $query);  //http://103.255.100.77/api/send_transactional_sms.php
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $res = trim(curl_exec($ch));
    curl_close($ch);
	   */
	   
	   
	  // $this->load->view('header',$this->data);                         
       $this->load->view($this->view_dir.'payment_success_gym',$this->data,true);
	   
       $this->load->view($this->view_dir.'thankyou',$this->data);
       $this->load->view('footer'); 
	   // redirect('Thankyou');   
	}
	
	function failure_hostel_pending()
	{
	    
	      $this->load->view('header',$this->data);  
	     
	     $this->data["key"] =$_REQUEST['key'];
	      $this->data["hash"] =$_REQUEST['hash'];
	       $this->data["txnid"] =$_REQUEST['txnid'];
	        $this->data["udf1"] = $_REQUEST['udf1'];
	           $this->data["udf2"] =$_REQUEST['udf2'];
	         $this->data["udf3"] =$_REQUEST['udf3'];
	           $this->data["udf4"] =$_REQUEST['udf4'];
	            $this->data["udf5"] =$_REQUEST['udf5'];//utype//$_REQUEST['student_type'];
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
				
                $this->Online_feemodel->add_online_feedetails_gym($this->data);
	           // $this->load->view('header',$this->data);    
	            $this->load->view($this->view_dir.'payment_failure',$this->data);
                $this->load->view('footer'); 
	}
	
	
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	public function External_challan_sujee(){
		
		//echo 'TEts';
		$this->load->model('Challan_model');
	    global $model;
        $this->load->view('header',$this->data);    
		 $recepit=$this->uri->segment(3);
		 $this->data['productinfo']=$this->uri->segment(4);
		//exit();
		$this->data['user_details']=$this->Online_feemodel->get_details_sujee($recepit);
		$dats=$this->data['user_details'];
		//print_r($this->data['user_details']);
		//exit();
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		//$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		
		//if(($dats[0]['admission_cycle']=="")||($dats[0]['admission_cycle']==NULL)){
			//print_r($this->data['user_details']);
		//exit();
		//$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->load->view($this->view_dir.'External_challan_mba',$this->data);
		//}else{
		//$this->data['examsession']=$this->Challan_model->get_examsession_phd();
		//$this->load->view($this->view_dir.'add_fees_challan_details_new_phd',$this->data);
		//}
        $this->load->view('footer');
	}
	
	
	 function exam_success()
	{
	    $DB1 = $this->load->database('umsdb', TRUE);
		$this->load->model('Challan_model');
		 ini_set('display_errors', 1);
         ini_set('display_startup_errors', 1);
         /* error_reporting(E_ALL);
		 echo '<pre>';
		 print_r($_POST);exit; */
	     $this->data["key"] =$_REQUEST['key'];
	     $this->data["hash"] =$_REQUEST['hash'];
	     $this->data["txnid"] =$_REQUEST['txnid'];
	     $this->data["udf1"] = $_REQUEST['udf1'];
	     $this->data["udf2"] =$_REQUEST['udf2'];
	     $this->data["udf3"] =$_REQUEST['udf3'];
	     $this->data["udf4"] =$_REQUEST['udf4'];
	     $this->data["udf5"] =$_REQUEST['udf5'];
	     $this->data["firstname"] = $_REQUEST['firstname'];
	     $this->data["degree_convocation_fees"] = $_REQUEST['address1'];
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
         $this->Online_feemodel->add_online_feedetails($this->data);
	     $user_mobile = $_REQUEST['udf4'];
		 
		 if($_REQUEST['status'] == 'success'){
			 
	    $get_exam_detail_data = $this->Examination_model->get_exam_detail_data($_REQUEST['udf2'],$_REQUEST['udf3'],$_REQUEST['udf5'],$_REQUEST['txnid']);
         //echo '<pre>';
		 //print_r($get_exam_detail_data);exit;

		 
		// echo $DB1->last_query();exit;
		 
		 
		 $insert_exam_details =array(
			"stud_id"=>$get_exam_detail_data[0]['stud_id'],
			"enrollment_no"=>$get_exam_detail_data[0]['enrollment_no'],
			"stream_id"=>$get_exam_detail_data[0]['stream_id'],
			"course_id"=>$get_exam_detail_data[0]['course_id'],
			"semester"=>$get_exam_detail_data[0]['semester'],
			"school_code"=>$get_exam_detail_data[0]['school_code'],
			"exam_fees"=>$get_exam_detail_data[0]['exam_fees'],
			"exam_id" => $get_exam_detail_data[0]['exam_id'],
			"exam_month" => $get_exam_detail_data[0]['exam_month'],
			"exam_year" => $get_exam_detail_data[0]['exam_year'],
			"is_regular_makeup" => $get_exam_detail_data[0]['is_regular_makeup'],
			"exam_fees_paid" => $get_exam_detail_data[0]['exam_fees_paid'],
			"degree_convocation_fees" => $get_exam_detail_data[0]['degree_convocation_fees'],
			"late_fees" => $get_exam_detail_data[0]['late_fees'],
			"txnid" => $get_exam_detail_data[0]['txnid'],
			"entry_by" => $get_exam_detail_data[0]['entry_by'],
			"entry_from_ip" => $_SERVER['REMOTE_ADDR'],
			"entry_on" => date("Y-m-d H:i:s"),
			"allow_for_exam" => $get_exam_detail_data[0]['allow_for_exam'],
			"is_active" => 'Y',
		  );
		 
		 
		 // Assuming $get_exam_detail_data[0] is already available
			$exam_id = $get_exam_detail_data[0]['exam_id'];

			// ✅ Fetch last form number for this exam_id
			$lastForm = $DB1->select('exam_form_no')
							->from('exam_details')
							->where('exam_id', $exam_id)
							->order_by('exam_master_id', 'DESC')   // use PK for latest
							->limit(1)
							->get()
							->row_array();

			if ($lastForm && !empty($lastForm['exam_form_no'])) {
				// Extract numeric part after exam_id prefix
				$lastNumber = (int)substr($lastForm['exam_form_no'], strlen($exam_id));
				$newNumber  = $lastNumber + 1;
			} else {
				$newNumber = 1; // first form
			}

			// ✅ Generate new exam_form_no (exam_id + padded number)
			$exam_form_no = $exam_id . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
		 
		// echo $exam_form_no;exit;
		 $insert_exam_details['exam_form_no'] = $exam_form_no;
		 
		  $insert_exam_subjects=array(
			"stud_id"=>$get_exam_detail_data[0]['stud_id'],
			"enrollment_no"=>$get_exam_detail_data[0]['enrollment_no'],
			"stream_id"=>$get_exam_detail_data[0]['stream_id'],
			"semester"=>$get_exam_detail_data[0]['semester'],
			"exam_id" => $get_exam_detail_data[0]['exam_id'],
			"exam_month" => $get_exam_detail_data[0]['exam_month'],
			"exam_year" => $get_exam_detail_data[0]['exam_year'],
			"entry_by" => $this->session->userdata("uid"),
			"entry_from_ip" => $_SERVER['REMOTE_ADDR'],
			// "exam_form_no"  => $exam_form_no, // ✅ Insert new generated form no
			"entry_on" => date("Y-m-d H:i:s"),
			"is_absent" => 'N');

        $DB1->insert("exam_details", $insert_exam_details); 
		$insert_exam_subjects['allow_for_exam']=$get_exam_detail_data[0]['allow_for_exam'];
		$exam_master_id=$DB1->insert_id(); 
		//echo $DB1->last_query();exit;
		if($exam_master_id !=''){
			 $insert_exam_subjects['exam_master_id'] = $exam_master_id;
			 $get_exam_subject_detail_data = $this->Examination_model->get_exam_subject_detail_data($_REQUEST['udf2'],$_REQUEST['udf3'],$_REQUEST['udf5'],$_REQUEST['txnid'],$get_exam_detail_data[0]['exam_master_id']);
			 //echo  '<pre>';
			 //print_r($get_exam_subject_detail_data);
			 
				/* $subjects = $this->input->post('sub');
				foreach($subjects as $sub){
					$sub = explode('~', $sub);
					$insert_exam_subjects['subject_id']=$sub[0];
					$insert_exam_subjects['subject_code']= $sub[1];
					$insert_exam_subjects['semester']= $sub[2];
					$insert_exam_subjects['sub_credits']= $sub[3];
					$insert_exam_subjects['is_backlog']= $sub[4];
					$DB1->insert("exam_applied_subjects", $insert_exam_subjects);
				} */
				
				for($i=0; $i<count($get_exam_subject_detail_data); $i++){
					//echo count($get_exam_subject_detail_data);
					//print_r($get_exam_subject_detail_data[$i]);exit;
					//print_r($get_exam_subject_detail_data[$i]);exit;
					
					$insert_exam_subjects['subject_id']=$get_exam_subject_detail_data[$i]['subject_id'];
					$insert_exam_subjects['subject_code']= $get_exam_subject_detail_data[$i]['subject_code'];
					$insert_exam_subjects['semester']=   $get_exam_subject_detail_data[$i]['semester'];
					$insert_exam_subjects['sub_credits']= $get_exam_subject_detail_data[$i]['sub_credits'];
					$insert_exam_subjects['is_backlog']=  $get_exam_subject_detail_data[$i]['is_backlog'];
					$DB1->insert("exam_applied_subjects", $insert_exam_subjects);
					
				}
			
		}
		
		 $DB11 = $this->load->database('erpdel', TRUE);
		//$DB11->where('txtid', $_REQUEST['txnid']); 
        //$DB11->where('registration_no', $_REQUEST['udf3']); 
	    //$DB11->where('student_id', $_REQUEST['udf5']);
	    // $DB1->where('email', $data['email']);
	    /////////////////////////////////////////////////////////
        $DB11->delete('exam_details_transaction', array('txnid' => $_REQUEST['txnid'],'enrollment_no'=> $_REQUEST['udf3'],'stud_id' =>$_REQUEST['udf5']));
		//echo $DB11->last_query();exit;
        $DB11->delete('exam_applied_subjects_transaction', array('txnid' => $_REQUEST['txnid'],'enrollment_no'=> $_REQUEST['udf3'],'stud_id' =>$_REQUEST['udf5']));
		//$this->db->delete('mytable', array('id' => $id))
		
		//$DB11->where('txtid', $_REQUEST['txnid']); 
        //$DB11->where('registration_no', $_REQUEST['udf3']); 
	   // $DB11->where('student_id', $_REQUEST['udf5']);
	    // $DB1->where('email', $data['email']);
	    /////////////////////////////////////////////////////////
        //$DB11->delete('exam_applied_subjects_transaction'); 
		
		
		
		////added by jp
			try {

				$prefix = '25SUNR';
				$checkChallanNo = $this->Challan_model->checkChallanNumber_for_callback($prefix);

				if ($checkChallanNo) {
					// Extract numeric part and increment
					$last_numeric = (int)substr($checkChallanNo['exam_session'], -7);
					$new_number = $last_numeric + 1;
				} else {
					$new_number = 1; // First entry for this academic year
				}

				// Format new challan number
				//$formatted_number = str_pad($new_number, 7, '0', STR_PAD_LEFT);
				// $challan_number = $prefix . $formatted_number;
				
				$challan_number = $this->Challan_model->checkChallanNumber_unique($prefix,$new_number);

				// ✅ Check if challan already inserted
				$existingChallan = $DB1->get_where('fees_challan', [
					'receipt_no' => $_REQUEST['bank_ref_num']
				])->row_array();
				
				// $emp_name = $this->session->userdata("emp_name");
				// print_r($challan_number);exit;
				if (!$existingChallan) {
					// Prepare insert array
					$insert_array = [
						"exam_session"    => $challan_number,
						"enrollment_no"   => $_REQUEST['udf3'],
						"student_id"      => $_REQUEST['udf5'],
						"academic_year"   => C_RE_REG_YEAR,
						"type_id"         => 5,
						"challan_status"  => 'PD',
						"is_deleted"      => 'N',
						"exam_monthyear"  => $get_exam_detail_data[0]['exam_month'] . '-' . $get_exam_detail_data[0]['exam_year'],
						"bank_account_id" => 4,
						"college_receiptno" => '',
						"exam_id"         => $_REQUEST['udf2'],
						"amount"          => $get_exam_detail_data[0]['exam_fees'],
						"Backlog_fees"    => $get_exam_detail_data[0]['exam_fees'],
						"Balance_Amount"  => 0,
						"fees_paid_type"  => 'GATEWAY-ONLINE'.'-'.$_REQUEST['mode'],
						"TransactionNo"   => $_REQUEST['bank_ref_num'],
						"TransactionDate" => date('Y-m-d'),
						"receipt_no"      => $_REQUEST['bank_ref_num'],
						"fees_date"       => date('Y-m-d'),
						"bank_id"         => 19,
						"bank_city"       => 'Nashik',
						"remark"          => '',
						"entry_from_ip"   => $_SERVER['REMOTE_ADDR'],
						"created_by"      => $emp_name,
						"created_on"      => date("Y-m-d H:i:s")
					];

					// Insert into fees_challan
					$DB1->insert("fees_challan", $insert_array);
				}

			} catch (Exception $e) {
				log_message('error', 'Error inserting challan: ' . $e->getMessage());
				echo "Something went wrong while generating challan. Please contact admin.";
			}
		
		 }
	     $this->load->view('header',$this->data);                         
         $this->load->view($this->view_dir.'payment_success',$this->data,true);
         $this->load->view($this->view_dir.'thankyou',$this->data);
         $this->load->view('footer'); 
	    
	}

	 function reval_exam_success()
	{
	    $DB1 = $this->load->database('umsdb', TRUE);
		 //ini_set('display_errors', 1);
         //ini_set('display_startup_errors', 1);
		 // error_reporting(E_ALL);
		 //echo '<pre>';
		 //print_r($_REQUEST);exit;
	     $this->data["key"] =$_REQUEST['key'];
	     $this->data["hash"] =$_REQUEST['hash'];
	     $this->data["txnid"] =$_REQUEST['txnid'];
	     $this->data["udf1"] = $_REQUEST['udf1'];
	     $this->data["udf2"] =$_REQUEST['udf2'];
	     $this->data["udf3"] =$_REQUEST['udf3'];
	     $this->data["udf4"] =$_REQUEST['udf4'];
	     $this->data["udf5"] =$_REQUEST['udf5'];
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
		 $this->data['user_id']=$_REQUEST['bank_ref_num'];
	     $this->data['error_Message']=$_REQUEST['error_Message'];      
         $this->Online_feemodel->add_online_feedetails($this->data);
		 
		 if($_REQUEST['productinfo']=='Photocopy_Examination'){
			$r_exam_details =array(
				 "photocopy_fees"=>$_REQUEST['amount'],
				 "photocpy_appeared"=>'Y',
				 "txnid"=>$_REQUEST['txnid'],
				 //reval_entry_by"=>$this->session->userdata("uid"),
				 "photocpy_entry_on"=>date("Y-m-d H:i:s")
			     );
			$DB1->where('txnid_photocopy', $_REQUEST['txnid']);	 
		 }else{
			$r_exam_details =array(
				 "reval_fees"=>$_REQUEST['amount'],
				 "reval_appeared"=>'Y',
				 "txnid"=>$_REQUEST['txnid'],
				 //reval_entry_by"=>$this->session->userdata("uid"),
				 "reval_entry_on"=>date("Y-m-d H:i:s")
			     );
			$DB1->where('txnid_reval', $_REQUEST['txnid']);	 
		 }
			   //$DB1->where('txnid', $_REQUEST['txnid']);	
			   $DB1->update("exam_details", $r_exam_details); 
			   
				if($_REQUEST['productinfo']=='Photocopy_Examination'){	   
					$pexam_details =array(
					"photocopy_appeared"=>'Y',
					"txnid_photocopy"=>$_REQUEST['txnid'],
					"photocopy_entry_on"=>date("Y-m-d H:i:s")
					);
					$DB1->where('txnid_photocopy',$_REQUEST['txnid']);
				}else{
					$pexam_details =array(
					"reval_appeared"=>'Y',
					"txnid_reval"=>$_REQUEST['txnid'],
					"reval_entry_on"=>date("Y-m-d H:i:s")
					);
					$DB1->where('txnid_reval',$_REQUEST['txnid']);
				}	
						
					$DB1->update("exam_applied_subjects", $pexam_details); 
	     $user_mobile = $_REQUEST['udf4'];
	     $this->load->view('header',$this->data);                         
         $this->load->view($this->view_dir.'payment_success',$this->data);
         $this->load->view($this->view_dir.'thankyou',$this->data);
         $this->load->view('footer'); 
	    
	}

    function reval_failure()
	{
	    //echo 'payment failed inside';exit;
		$DB1 = $this->load->database('umsdb', TRUE);
	      $this->load->view('header',$this->data);  
	     
	          $this->data["key"] =$_REQUEST['key'];
	          $this->data["hash"] =$_REQUEST['hash'];
	          $this->data["txnid"] =$_REQUEST['txnid'];
	          $this->data["udf1"] = $_REQUEST['udf1'];
	          $this->data["udf2"] =$_REQUEST['udf2'];
	          $this->data["udf3"] =$_REQUEST['udf3'];
	           $this->data["udf4"] =$_REQUEST['udf4'];
	            $this->data["udf5"] =$_REQUEST['udf5'];//utype//$_REQUEST['student_type'];
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
				
				 $r_exam_details =array(
				 "reval_fees"=>0,
				 "txnid"=>$_REQUEST['txnid'],
				 //reval_entry_by"=>$this->session->userdata("uid"),
				 "reval_entry_on"=>date("Y-m-d H:i:s")
			     );
			   $DB1->where('txnid', $_REQUEST['txnid']);	
			   $DB1->update("exam_details", $r_exam_details); 
			   
			   $pexam_details =array(
					"reval_appeared"=>'N',
					"txnid"=>$_REQUEST['txnid'],
					//"reval_entry_by"=>$this->session->userdata("uid"),
					"reval_entry_on"=>date("Y-m-d H:i:s")
					);
					$DB1->where('txnid',$_REQUEST['txnid']);	
					$DB1->update("exam_applied_subjects", $pexam_details); 
				
                $this->Online_feemodel->add_online_feedetails($this->data);
	            $this->load->view('header',$this->data);    
	            $this->load->view($this->view_dir.'payment_failure',$this->data);
                $this->load->view('footer'); 
	  } 

function verify_reval_tr_uni_payments_test(){
			//echo 1;exit;
			$DB1 = $this->load->database('umsdb', TRUE);
			
		// Merchant key here as provided by Payu
		//$key = "BGdiP5";//"qyt13u";
		$key = "soe5Fh";//"qyt13u";
		//$salt = "cynzRXfALgCCW1O2MakDknkMaZ7rOg0A";
		$salt = "OhVBBZuL";
		$command = "verify_payment";
		
		//$trdate = date('Y-m-d');
		$trdate = '2023-05';
		$type = 'Examination';
		$trans = $this->payment_model->getverify_payment($trdate,$type);
		$i=0;
		$j=0;
		foreach($trans as $trns){
		
		
		//$var1 = $trns['txtid']; // Transaction ID
        //$var1 = '230411105933-17629'; // Transaction ID
		$var1 = '230411083412-8382'; // Transaction ID


		$hash_str = $key  . '|' . $command . '|' . $var1 . '|' . $salt ;
		$hash = strtolower(hash('sha512', $hash_str));

			$r = array('key' => $key , 'hash' =>$hash , 'var1' => $var1, 'command' => $command);
			//echo $hash;
			
			$qs= http_build_query($r);
			//$wsUrl = "https://test.payu.in/merchant/postservice.php?form=1";
			$wsUrl = "https://info.payu.in/merchant/postservice?form=2";
			$c = curl_init();
			curl_setopt($c, CURLOPT_URL, $wsUrl);
			curl_setopt($c, CURLOPT_POST, 1);
			curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
			curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
			$o = curl_exec($c);
			if (curl_errno($c)) {
			  $sad = curl_error($c);
			  throw new Exception($sad);
			}
			curl_close($c);

			$valueSerialized = @unserialize($o);
			if($o === 'b:0;' || $valueSerialized !== false) {
			 $valueSerialized;
			}
			//echo "<pre>";
			//echo $o;
			$var =json_decode($o,true);
			//print_r($var);exit;
			if($var['transaction_details'][$var1]['status']=='success'){ // if payments is successful
				$data['receipt_no']=$var['transaction_details'][$var1]['udf4'];
				$data['payment_mode']=$var['transaction_details'][$var1]['mode'];
				$data['bank_ref_num']=$var['transaction_details'][$var1]['bank_ref_num'];
				$data['error_code']=$var['transaction_details'][$var1]['error_code'];
				$data['pg_type']=$var['transaction_details'][$var1]['PG_TYPE'];
				$data['payment_status']=$var['transaction_details'][$var1]['status'];
				$data['amount']=$var['transaction_details'][$var1]['transaction_amount'];
				$txtid=$var['transaction_details'][$var1]['txnid'];
				$data['remark']='Update from API';
				//print_r($data);
				$trans = $this->payment_model->update_api_payment($data,$txtid);
				 $r_exam_details =array(
				 "reval_fees"=>$var['transaction_details'][$var1]['transaction_amount'],
				 "reval_appeared"=>'Y',
				 "txnid"=>$var['transaction_details'][$var1]['txnid'],
				 //reval_entry_by"=>$this->session->userdata("uid"),
				 "reval_entry_on"=>date("Y-m-d H:i:s")
			     );
			   $DB1->where('txnid', $var['transaction_details'][$var1]['txnid']);	
			   $DB1->update("exam_details", $r_exam_details); 
		       $pexam_details =array(
					"reval_appeared"=>'Y',
					"txnid"=>$var['transaction_details'][$var1]['txnid'],
					//"reval_entry_by"=>$this->session->userdata("uid"),
					"reval_entry_on"=>date("Y-m-d H:i:s")
					);
					$DB1->where('txnid',$var['transaction_details'][$var1]['txnid']);	
					$DB1->update("exam_applied_subjects", $pexam_details); 
				
				$j++;
				exit;
			}else{
			
			}
			
		$i++;	
		}
		echo $i.' records are updated';
		echo $j.' records are updated';
	}	  
	public function Challan_test(){
		
		//echo 'TEts';
		$this->load->model('Challan_model');
	    global $model;
        $this->load->view('header_test',$this->data);    
		 $recepit=$this->uri->segment(3);
		 $productinfo =$this->uri->segment(4);
		
		 $this->data['productinfo']=$this->uri->segment(4);
		//exit();
		if($productinfo=="New_Admission"){
		$this->data['user_details']=$this->Online_feemodel->get_details($recepit);
		$dats=$this->data['user_details'];
			}elseif($productinfo=="International_Admission"){
		$this->data['user_details']=$this->Online_feemodel->get_details_int($recepit);
		$dats=$this->data['user_details'];
		}
			else{
		$this->data['user_details']=$this->Online_feemodel->get_details_register($recepit);
		$dats=$this->data['user_details'];
		}
		
		
		//print_r($this->data['user_details']);
		//exit();
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		//$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		
		if(($dats[0]['admission_cycle']=="")||($dats[0]['admission_cycle']==NULL)){
			//print_r($this->data['user_details']);
		//exit();
		$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->load->view($this->view_dir.'add_fees_challan_details_new_test',$this->data);
		}else{
		$this->data['examsession']=$this->Challan_model->get_examsession_phd();
		$this->load->view($this->view_dir.'add_fees_challan_details_new_phd',$this->data);
		}
        $this->load->view('footer_test');
	}
	
	
  
}
?>