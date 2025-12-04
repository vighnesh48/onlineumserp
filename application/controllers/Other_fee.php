<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Other_fee extends CI_Controller 
{

    var $currentModule="";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Other_feemodel";
    var $model;
    var $view_dir='Other_fee/';
    
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
        
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    
    public function index()
    {
        global $model;
        $this->load->view('header',$this->data);    
         $this->data['emp_list']= $this->Online_feemodel->getFeesdata();
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'fee_listing',$this->data);
        $this->load->view('footer');
    }
	
		
	
	  public function student_payment_history()
    {
        global $model;
        $this->load->view('header',$this->data);    
         $this->data['pay_list']= $this->Online_feemodel->student_payment_history();
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
	
	
	
	
	function pay_fees()
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
       $this->data['stdata']= $this->Online_feemodel->fetch_studentdata();
      //    var_dump($this->Online_feemodel->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'pay_fees',$this->data);
        $this->load->view('footer'); 
	   }
	    
	}
	
	function success()
	{
	    
	    //$post[]="";
	//   var_dump($_REQUEST);
//	   exit();
//	   error_reporting(E_ALL);
  //  ini_set('display_errors', 1);
	     $this->load->view('header',$this->data);  
	     
	     $this->data["key"] =$_REQUEST['key'];
	      $this->data["hash"] =$_REQUEST['hash'];
	       $this->data["txnid"] =$_REQUEST['txnid'];
	        $this->data["udf1"] = $_REQUEST['udf1'];
	           $this->data["udf2"] =$_REQUEST['udf2'];
	         $this->data["udf3"] =$_REQUEST['udf3'];
	           $this->data["udf4"] =$_REQUEST['udf4'];
	            $this->data["udf5"] ="R";//utype//$_REQUEST['student_type'];
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
	            

     
      $this->Online_feemodel->add_online_feedetails($this->data);
      //    var_dump($this->Online_feemodel->getFeesdata());
       //$data['session_details']= $this->Online_feemodel->fetch_studentdata();                        
$htm = $this->load->view($this->view_dir.'payment_success',$this->data);
 $this->load->view($this->view_dir.'thankyou',$this->data);
        $this->load->view('footer'); 
	    
	    
	}


	function failure()
	{
	    
	      $this->load->view('header',$this->data);  
	     
	     $this->data["key"] =$_REQUEST['key'];
	      $this->data["hash"] =$_REQUEST['hash'];
	       $this->data["txnid"] =$_REQUEST['txnid'];
	        $this->data["udf1"] = $_REQUEST['udf1'];
	           $this->data["udf2"] =$_REQUEST['udf2'];
	         $this->data["udf3"] =$_REQUEST['udf3'];
	           $this->data["udf4"] =$_REQUEST['udf4'];
	            $this->data["udf5"] ="R";//utype//$_REQUEST['student_type'];
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
	
	
}
?>