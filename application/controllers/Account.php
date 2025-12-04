<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Fees_model";
     var $model_name1="Account_model";
    var $model;
    var $view_dir='Account/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
      //   error_reporting(E_ALL);
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
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
        $this->load->model("Account_model");
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		/* Code by vighnesh */
	    $this->load->model('Examination_model');
		/* End Code by vighnesh */
    }
    
    public function admission_fees()
    { 
        if($_POST){
            $this->data['fees']=$this->Fees_model->get_fees_collection_admission();
            $this->load->view($this->view_dir.'adm1',$this->data);

        }else
        {
         $this->load->view('header',$this->data);    
         $this->data['fees']=$this->Fees_model->get_fees_collection_admission();
      //  $this->load->view($this->view_dir.'admission_fees',$this->data);
        $this->load->view($this->view_dir.'adm2',$this->data);
        $this->load->view('footer');
   
        }
        
    }
    
    public function admission_fees_report1()
    { 
        $row['academic_year']='2017';
        $row['get_by']='stream';
        $this->load->view('header',$this->data);    
        $this->data['fees']=$this->Fees_model->get_fees_statistics($row);
        $row['get_by']='student';
        $this->data['studfees']=$this->Fees_model->get_streamwise_admission_fees($row);
        $this->load->view($this->view_dir.'cumulative_fees_report',$this->data);
        $this->load->view('footer');
    }

    public function admission_fees_report()
    {
        $this->load->view('header',$this->data);
		$role_id = $this->session->userdata('role_id');
        $this->data['exam_session']= $this->Account_model->fetch_stud_curr_year();	
		if($role_id ==49){
			$this->load->view($this->view_dir.'admission_fees_report_kp.php',$this->data);
		}else{
			$this->load->view($this->view_dir.'admission_fees_report.php',$this->data);
		}
        $this->load->view('footer');
    }
	
	public function admission_fees_report_same()
    {
      
        $this->load->view('header',$this->data);    
        $this->load->view($this->view_dir.'admission_fees_report_same.php',$this->data);
        $this->load->view('footer');
    }

    public function get_admission_fees_report()
    {   
        // $year= (explode("-",$_POST['academic_year']));
         //$year=$year[1];
         $this->data['academic_year']=$_POST['academic_year'];
         $this->data['admission_type']=$_POST['admission_type'];
         $this->data['report_type']=$_POST['report_type'];
		  $this->data['school_code']=$_POST['school_code'];
         $this->data['admission-course']=$_POST['admission_course'];
         $this->data['admission-branch']=$_POST['stream_id'];
		  $this->data['erp_type']=$_POST['erp_type'];
		 ini_set('memory_limit', '-1');
        if($_POST['report_type']=="1" || $_POST['report_type']=="5" )
        {
            
             $this->data['fees']=$this->Account_model->get_fees_collection_admission($this->data);
             if($_POST['act']=="view"){
               
                 $this->load->view($this->view_dir.'admission_fees',$this->data);
             }
             else{
                
                 $this->load->view($this->view_dir.'reports/excel_admission_fees',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }

        }
        else if($_POST['report_type']=="2" || $_POST['report_type']=="6" ) 
        {
            $this->data['get_by']="";
            $this->data['fees']=$this->Account_model->get_studentwise_admission_fees($this->data);
            if($_POST['act']=="view"){
                 $this->load->view($this->view_dir.'admission_fees',$this->data);
             }
             else{
                
                 $this->load->view($this->view_dir.'reports/excel_admission_fees_studentwise',$this->data);
				
                 $this->session->set_flashdata('excelmsg', 'download');
             }
           
		   
        }
         else if($_POST['report_type']=="3" || $_POST['report_type']=="7" )
        {
             $this->data['get_by']="";
             $this->data['fees']=$this->Account_model->get_streamwise_admission_fees($this->data);
              if($_POST['act']=="view"){
                 $this->load->view($this->view_dir.'admission_fees',$this->data);
             }
             else{
                
                 $this->load->view($this->view_dir.'reports/excel_admission_fees_statistics',$this->data);
                  $this->session->set_flashdata('excelmsg', 'download');
             }
            
        }
        else if($_POST['report_type']=="4" || $_POST['report_type']=="8" )
        { 
             $this->data['get_by']="";
             $this->data['fees']=$this->Account_model->get_studentwise_admission_fees($this->data);
            if($_POST['act']=="view"){
               // print_r($_POST);exit();
                 $this->load->view($this->view_dir.'admission_fees',$this->data);
             }
             else{
                
                 $this->load->view($this->view_dir.'reports/excel_admission_fees_studentwise',$this->data);
                  $this->session->set_flashdata('excelmsg', 'download');
             }
            
        }
        
    }
	
	
	public function final_report_phd(){
		error_reporting(E_ALL);
	ini_set('memory_limit', '-1');
        	
			$this->data['academic_year']="2021";
			$this->data['admission_type']="N";
			$this->data['get_by']="";
			$this->data['school_code']="All";
	        $this->data['admission-course']="";
			$this->data['report_type']="2";
			$this->data['admission-branch']="";
			$this->data['act']="excel";
			
        
         
		  
         
         
			
            $this->data['fees']=$this->Account_model->get_studentwise_admission_fees_phd($this->data);
         // print_r($this->data['fees']);
		  
		   // if($_POST['act']=="view"){
           //      $this->load->view($this->view_dir.'admission_fees',$this->data);
           //  }
            // else{
               // $this->load->view($this->view_dir.'admission_fees',$this->data);
			//   $this->load->view($this->view_dir.'reports/excel_admission_fees_studentwise',true);
                 $this->load->view($this->view_dir.'reports/excel_admission_fees_studentwise',$this->data);
				
                 $this->session->set_flashdata('excelmsg', 'download');
            // }
	}
	
	
	
	
	
	public function get_admission_fees_report_same()
    {   
        
         $this->data['academic_year']=$_POST['academic_year'];
         $this->data['admission_type']=$_POST['admission_type'];
         $this->data['report_type']=$_POST['report_type'];
        if($_POST['report_type']=="1" || $_POST['report_type']=="5" )
        {
            
             $this->data['fees']=$this->Account_model->get_fees_collection_admission($this->data);
             if($_POST['act']=="view"){
               
                 $this->load->view($this->view_dir.'admission_fees_same',$this->data);
             }
             else{
                
                 $this->load->view($this->view_dir.'reports/excel_admission_fees',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }

        }
        else if($_POST['report_type']=="2"  || $_POST['report_type']=="6" ) 
        {
            $this->data['get_by']="";
            $this->data['fees']=$this->Account_model->get_studentwise_admission_fees($this->data);
            if($_POST['act']=="view"){
                 $this->load->view($this->view_dir.'admission_fees_same',$this->data);
             }
             else{
                
                 $this->load->view($this->view_dir.'reports/excel_admission_fees_studentwise',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }
             
        }
         else if($_POST['report_type']=="3" || $_POST['report_type']=="7" )
        {
             $this->data['get_by']="";
             $this->data['fees']=$this->Account_model->get_streamwise_admission_fees($this->data);
              if($_POST['act']=="view"){
                 $this->load->view($this->view_dir.'admission_fees_same',$this->data);
             }
             else{
                
                 $this->load->view($this->view_dir.'reports/excel_admission_fees_statistics',$this->data);
                  $this->session->set_flashdata('excelmsg', 'download');
             }
            
        }
        else if($_POST['report_type']=="4" || $_POST['report_type']=="8" )
        { 
             $this->data['get_by']="";
             $this->data['fees']=$this->Account_model->get_studentwise_admission_fees($this->data);
            if($_POST['act']=="view"){
               // print_r($_POST);exit();
                 $this->load->view($this->view_dir.'admission_fees_same',$this->data);
             }
             else{
                
                 $this->load->view($this->view_dir.'reports/excel_admission_fees_studentwise',$this->data);
                  $this->session->set_flashdata('excelmsg', 'download');
             }
            
        }
        
    }
 
    public function admission_fees_streamwise()
    {
        $row['academic_year']=$_REQUEST['academic_year'];
        $row['year']=$_REQUEST['year'];
        $row['stream_id']=$_REQUEST['stream_id'];
        $row['get_by']='stream';
        $this->load->view('header',$this->data);    
        $this->data['fees']=$this->Fees_model->get_studentwise_admission_fees($row);
        $this->load->view($this->view_dir.'streamwise_fees',$this->data);
        $this->load->view('footer');
    }
      public function admission_fees_streamwise12()
    {
        $row['academic_year']=$_REQUEST['academic_year'];
        $row['year']=$_REQUEST['year'];
        $row['stream_id']=$_REQUEST['stream_id'];
        $row['get_by']='stream';
        //print_r($row);exit();
        $this->data['fees']=$this->Account_model->get_studentwise_admission_fees($row);
        $this->load->view($this->view_dir.'stream_wise',$this->data);
       
    }
  	 
  	 
    public function fees_refund()
    {		echo 'Welcome!';exit;
		   $this->load->view('header',$this->data); 
		    $this->data['emp_list']= $this->Fees_model->fees_refund();
		     $this->load->view($this->view_dir.'refund_list',$this->data);
		    $this->load->view('footer');
	 }
    public function student_fees_refund()
    {
		   $this->load->view('header',$this->data); 
		    //$this->data['emp_list']= $this->Fees_model->fees_refund();
		     $this->load->view($this->view_dir.'student_refund_list',$this->data);
		    $this->load->view('footer');
	 }	 
	 public function fees_refund_list_by_creteria()
	{
		$refund_list=$this->Fees_model->fees_refund($_POST['refund_for']);
		echo json_encode(array("refund_list"=>$refund_list));
	}
	 
	function delete_refund()
	 {
	  $this->Fees_model->delete_refund();   
	  
	 }
	 
	function search_refunddata()
    {
        $data['emp_list']= $this->Fees_model->searchforrefund($_POST);
	     $data['dcourse']= $_POST['astream'];
	    $data['dyear']= $_POST['ayear'];
	   $data['bank_details']= $this->Fees_model->getbanks();
	     // $data['type'] = $_POST['type'];

	       $html = $this->load->view($this->view_dir.'load_refund_data',$data,true);    

	  echo $html;
}
	function stud_search_refunddata()
    {
        $data['emp_list']= $this->Fees_model->searchforrefund($_POST);
	     $data['dcourse']= $_POST['astream'];
	    $data['dyear']= $_POST['ayear'];
	   $data['bank_details']= $this->Fees_model->getbanks();
	     // $data['type'] = $_POST['type'];

	       $html = $this->load->view($this->view_dir.'student_load_refund_data',$data,true);    

	  echo $html;
}	
    function edit_refund($refund='')
    {
    if($_POST)
    {
        
        if(!empty($_FILES['payfile']['name'])){
			$filenm=$stud_id.'-'.$no_of_installment.'-'.$_FILES['payfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('payfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
		
		  $this->Fees_model->update_refund($_POST,$payfile);
        
    }
    else
    {
		    $this->load->view('header',$this->data); 
		     $this->data['refund']= $this->Fees_model->edit_refund($refund);
		     $this->data['bank_details']= $this->Fees_model->getbanks();
		     $this->load->view($this->view_dir.'edit_refund',$this->data);
		     $this->load->view('footer');
	 }
}

    public function pay_refund()
    {
    $stud_id= $_POST['stud_id'];
		$no_of_installment =1+$_POST['no_of_installment'];
		if(!empty($_FILES['payfile']['name'])){
			$filenm=$stud_id.'-'.rand().'-'.$_FILES['payfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|bmp|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('payfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
        $this->data['emp']= $this->Fees_model->pay_refund($_POST,$payfile);
      //  redirect('ums_admission/fees_refund/');
}
public function stud_pay_refund()
    {
    $stud_id= $_POST['stud_id'];
		$no_of_installment =1+$_POST['no_of_installment'];
		if(!empty($_FILES['payfile']['name'])){
			$filenm=$stud_id.'-'.rand().'-'.$_FILES['payfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|bmp|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('payfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
        $this->data['emp']= $this->Fees_model->stud_pay_refund($_POST,$payfile);
        //redirect('ums_admission/viewPayments/'.$stud_id);
}
	public function finance_reports()
	{
	    $this->load->view('header',$this->data);    
        $this->load->view($this->view_dir.'finance',$this->data);
        $this->load->view('footer');
	    
	}
	public function get_reports_data()
	{
	  // print_r($_POST);exit();
	    $row['academic_year']=$_POST['academic_year'];
	    $row['exam_session']=$_POST['exam_session'];
	    $row['report_by']=$_POST['report_by'];
	    $row['report_type']=$_POST['report_type'];
	    if(strlen($_POST['report_month'])==6){
	        $month="0".$_POST['report_month'];
	    }
	    else{
	         $month=$_POST['report_month'];
	    }
	    $row['report_date']=substr($_POST['report_date'],'6','4').'-'.substr($_POST['report_date'],'3','2').'-'.substr($_POST['report_date'],'0','2');
	    $row['report_month']=substr($month,'3','4').'-'.substr($month,'0','2');
	    $row['from_date']=substr($_POST['from_date'],'6','4').'-'.substr($_POST['from_date'],'3','2').'-'.substr($_POST['from_date'],'0','2');
	    $row['to_date']=substr($_POST['to_date'],'6','4').'-'.substr($_POST['to_date'],'3','2').'-'.substr($_POST['to_date'],'0','2');
	    $this->data['acc_data']= $this->Account_model->get_account_report($row);
	   //print_r($this->data['acc_data']);exit();
	  $this->data['rpt']=$_POST;
	  if($_POST['act']=="view"){
	      $this->load->view($this->view_dir.'finance_report',$this->data);
	  }else{
	   //print_r($this->data['acc_data']);exit();
	    $this->load->view($this->view_dir.'reports/excel_report',$this->data);
	    if($this->data['acc_data']){
	         $this->session->set_flashdata('excelmsg', 'download');
	        echo"excel downloaded successfully";
	    }
	      
	  }
	    
	}
	public function check_transaction_status(){
		    $this->load->view('header',$this->data);
		    $this->load->view($this->view_dir.'finance_status',$this->data); 
		     $this->load->view('footer',$this->data);  
		}
	public function check_payment_status()
	{     
	          
                $row=array('check_by'=>$_POST['check_by'],'ref_no'=>$_POST['ref_no']);
                $this->data['acc_data']= $this->Account_model->check_payment_no($row);
                $this->load->view($this->view_dir.'finance_status_html',$this->data);
                
   }
    public function examination_fees()
    {
    
      $this->load->view('header',$this->data); 
	  $this->load->view($this->view_dir.'search',$this->data);
	  $this->load->view('footer');
    
    
}
    public function examination_fees1()
    {
    
    
     $this->load->view('header',$this->data);        
        $limit = 10;// set records per page
		if(isset($_REQUEST['per_page'])){
			$offSet=$_REQUEST['per_page'];
		}
    //    $total= $this->Ums_admission_model->getAllStudents();
       // $this->data['emp_list']= $this->Ums_admission_model->getStudents($offSet,$limit);
		$total_pages = ceil($total/$limit);
		//echo $total_pages; 
		$this->load->library('pagination');
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config['enable_query_strings']=TRUE;
		$config['page_query_string']=TRUE;
		$config['reuse_query_string'] = TRUE;
		$config['base_url'] = base_url().'ums_admission/stud_list?';
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);
	    $this->data['paginglinks'] = $this->pagination->create_links();
		$config['offSet'] = $offSet;		
		$total=ceil($total/$limit);
		/* echo $total;
             echo"<pre>";	     
		 print_r( $this->data['paginglinks']);
		 echo"</pre>"; 
		 die();   */
		 $college_id = 1;
		 $this->data['course_details']= $this->Fees_model->getCollegeCourse($college_id);
        $this->load->view($this->view_dir.'student_list',$this->data);
        $this->load->view('footer');
    
    
}

    function load_studentlist()
 	{
	    
	   
	    $academic_year='2017';
	      $data['emp_list']= $this->Fees_model->load_studentlist($_POST['astream'],$_POST['ayear'],$academic_year);
	       $data['dcourse']= $_POST['astream'];
	        $data['dyear']= $_POST['ayear'];
	        //var_dump($this->Fees_model->load_studentlist($_POST['astream'],$_POST['ayear'],$academic_year));
	     // exit(0);
	      $html = $this->load->view($this->view_dir.'stud_feelist',$data,true);
	  echo $html;
	}


	    public function updateExamfee()
   	{
   	    

		//print_r($data);exit;
	$stud_id =	$_POST['student_id'];
		$this->data['indet']= $this->Fees_model->updateExamfee();

       $this->session->set_flashdata('message1','Exam Fee Details Updated Successfully!!.');
		redirect(base_url("Account/viewPayments/".$stud_id));
	}  
   
	public function viewPayments($stud_id)
    {
        //ini_set("display_errors", "On");
//error_reporting(1);
        $this->session->set_userdata('studId', $stud_id);
        $this->load->view('header',$this->data);       
        $this->data['emp']= $this->Fees_model->fetch_personal_details($stud_id);
		$this->data['get_feedetails']= $this->Fees_model->fetch_admission_details_all($stud_id);
		$this->data['get_bankdetails']= $this->Fees_model->get_bankdetails($stud_id);
		$this->data['bank_details']= $this->Fees_model->getbanks();
		$this->data['admission_details']= $this->Fees_model->fetch_admission_details($stud_id); 
$this->data['installment']= $this->Fees_model->fetch_installment_details($stud_id);
//$this->data['exam_session']= $this->Fees_model->get_active_exam_session();
$this->data['exam_session']= $this->Fees_model->get_all_exam_session();
//$this->data['exam_session']= $this->Fees_model->get_active_exam_session($stud_id);

        $this->load->view($this->view_dir.'view_payment_details',$this->data);
		$this->load->view('footer');
        //$this->load->view('footer');
    } 
















    public function pay_exam_fee()
    {
	
	  $stud_id= $_POST['stud_id'];
	  $_POST['academic_year'] ='2017';
		$no_of_installment =1+$_POST['no_of_installment'];
		if(!empty($_FILES['payfile']['name'])){
			$filenm=$stud_id.'-'.$no_of_installment.'-'.$_FILES['payfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('payfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
        $this->data['emp']= $this->Fees_model->pay_exam_fee($_POST,$payfile );
        redirect('account/viewPayments/'.$stud_id);
	
}

   public function edit_exam_fdetails()
   {
    $stud_id =$_POST['feeid'];
    
		$this->data['bank_details']= $this->Fees_model->getbanks();
			$this->data['indet']= $this->Fees_model->get_inst_details($stud_id);
$this->data['exam_session']= $this->Fees_model->get_all_exam_session();
       $this->load->view($this->view_dir.'edit_fee',$this->data);
}

   public function update_exam_fee($stud_id)
    {
		//print_r($_FILES);exit;
		date_default_timezone_set('Asia/Kolkata');
        $stud_id= $_POST['sid'];
	//	$no_of_installment =1+$_POST['no_of_installment'];
		if(!empty($_FILES['epayfile']['name'])){
			$filenm=$stud_id.'-'.time().'-'.$_FILES['epayfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('epayfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
        $this->data['emp']= $this->Fees_model->update_exam_fee($_POST,$payfile );
        redirect('Account/viewPayments/'.$stud_id);
    }	

  function delete_fees()
	{
	      $this->Fees_model->delete_fees();  
	}
	
  function exam_fees_report()
  {
		//$this->load->model('Examination_model');
        $this->data['ex_sess']= $this->Account_model->fetch_stud_curr_exam();
	    $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'reports/exam_report',$this->data);
        $this->load->view('footer',$this->data); 
    } 
    
  function get_exam_fees_reports()
  {
      $row=array('exam_session'=>$_POST['exam_session']);
      	$crsession = $this->Fees_model->get_exam_session($_POST['exam_session']);
 
      $this->data['exam_session']=$crsession['exam_name'];
      
      if($_POST['report_type']=="1"){ 
           $this->data['fees_data']= $this->Account_model->get_examination_fees($row);
                
           $this->load->view($this->view_dir.'reports/excel_exam_fees',$this->data);
            
      }else if($_POST['report_type']=="2")
      {	
           $this->data['fees_data']= $this->Account_model->get_exam_fees_statistics($row);
           $this->load->view($this->view_dir.'reports/excel_exam_fees_statistics',$this->data);
      }else
      {	
           $this->data['fees_data']= $this->Account_model->get_student_examination_fees($row);
           $this->load->view($this->view_dir.'reports/excel_exam_fees_studentwise',$this->data);
      }
      
     // echo "File exported successfully....";
     
  }
  
    public function hostel_fees_report()
    {
      
        $this->load->view('header',$this->data);    
        $this->load->view('Hostel/report/fees_report.php',$this->data);
        $this->load->view('footer');
    }
    
      public function get_hostel_fees_report()
    {   
        
         $this->data['academic_year']=$_POST['academic_year'];
         $this->data['campus']=$_POST['campus'];
         $this->data['institute_name']=$_POST['institute_name'];
         $this->data['report_type']=$_POST['report_type'];
         
        if($_POST['report_type']=="1")
        {
             $this->data['fees']=$this->Account_model->get_fees_collection_hostel($this->data);
           
             if($_POST['act']=="view"){
                 $this->load->view('Hostel/report/fees_details',$this->data);
             }
             else{
                 $this->load->view('Hostel/report/excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }

        }
        else if($_POST['report_type']=="2") 
        {
            $this->data['get_by']="";
            $this->data['fees']=$this->Account_model->get_studentwise_hostel_fees($this->data);
            if($_POST['act']=="view"){
                 $this->load->view('Hostel/report/fees_details',$this->data);
             }
             else{
                $this->load->view('Hostel/report/excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }
        }
         else if($_POST['report_type']=="3")
        {
             $this->data['get_by']="";
             $this->data['fees']=$this->Account_model->get_hostel_fees_statistics($this->data);
              if($_POST['act']=="view"){
                   $this->load->view('Hostel/report/fees_details',$this->data);
             }
             else{
                 $this->load->view('Hostel/report/excel_details',$this->data);
                  $this->session->set_flashdata('excelmsg', 'download');
             }
        }
        else if($_POST['report_type']=="4")
        { 
             $this->data['get_by']="";
             $this->data['fees']=$this->Account_model->get_studentwise_hostel_fees($this->data);
            if($_POST['act']=="view"){
                 $this->load->view('Hostel/report/fees_details',$this->data);
             }
             else{
                $this->load->view('Hostel/report/excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }
        }
        
    }
    
    // load student list
    function search_studentdata()
    {
        $this->load->model('Ums_admission_model');
        $data['emp_list']= $this->Ums_admission_model->searchStudentsajax($_POST);
    	$data['dcourse']= $_POST['astream'];
    	$data['dyear']= $_POST['ayear'];
    	$data['hide']= $_POST['hide'];
    	      
    	$html = $this->load->view($this->view_dir.'load_studentdata',$data,true);
    	echo $html;
    }
    // update payment details
    public function updatePayment()
   	{
   	    $a = mt_rand(100000,999999); 
   	    
   	    $stud_id= $_POST['student_id'];
		$enroll= $_POST['enrollment_no'];
		$org= $_POST['org'];
		
    	$sf_id =$_POST['fstud_id'];
    	$data['deposit_fees'] =$_POST['fdeposite'];  
		$data['actual_fees'] =$_POST['fappliable'];  
    	$data['gym_fees'] =$_POST['fgym_fees'];
    	$data['fine_fees'] =$_POST['fpending_balance'];   	
    	$data['opening_balance'] =$_POST['fopening_balance'];  
    	$data['excemption_fees'] =$_POST['exem']; 
		$data['concession_fees'] =$_POST['concession']; 		
    	$data['remark'] =$_POST['fremark'];  
    	if(!empty($_FILES['exemfile']['name'])){
    	    $newfilename= date('dmYHis').str_replace(" ", "", basename($_FILES["exemfile"]["name"]));
    	$data['excem_doc_path'] = $newfilename;
    	}
		if(!empty($_FILES['concefile']['name'])){
    	    $newfilename1= date('dmYHis').str_replace(" ", "", basename($_FILES["concefile"]["name"]));
    	$data['conce_doc_path'] = $newfilename1;
    	}
    //	echo $_FILES['music']['temp_name']; exit();
    	//print_r($_FILES);exit;
    	
    	$data['modified_by']=$_SESSION['uid'];
		$data['modified_on']=date("Y-m-d H:i:s");
		$data['modified_ip']=$_SERVER['REMOTE_ADDR'];
		//print_r($data);exit;
		$this->data['indet']= $this->Account_model->updatePayment($sf_id, $data);
		if(!empty($_FILES['exemfile']['name'])) {
            if(is_uploaded_file($_FILES['exemfile']['tmp_name'])) {
                $sourcePath = $_FILES['exemfile']['tmp_name'];
                $targetPath = "uploads/Hostel/exepmted_fees/".$newfilename;
                if(move_uploaded_file($sourcePath,$targetPath)) {
                
                }
            }
        }
		if(!empty($_FILES['concefile']['name'])) {
            if(is_uploaded_file($_FILES['concefile']['tmp_name'])) {
                $sourcePath1 = $_FILES['concefile']['tmp_name'];
                $targetPath1 = "uploads/Hostel/concession_fees/".$newfilename1;
                if(move_uploaded_file($sourcePath1,$targetPath1)) {
                
                }
            }
        }
       $this->session->set_flashdata('message1','Fee Details Updated Successfully!!.');
		redirect(base_url("Hostel/view_std_payment/".$enroll."/".$stud_id."/".$org));
	}
	
    function competative()
    {
		//error_reporting(E_ALL);
        $this->load->model('Account_model');
		if(!empty($_POST)){
		$data['dcourse']= $_POST['astream'];
    	$data['dyear']= $_POST['ayear'];
    	$data['hide']= $_POST['hide'];  
		$data['competative_fees']= $this->Account_model->fetch_competative_fees($_POST);
		}else{
			$var =array();
			$data['competative_fees']= $this->Account_model->fetch_competative_fees($var);
		} 	
		$this->load->view('header',$this->data); 	
    	$this->load->view($this->view_dir.'competative_fees',$data);
		$this->load->view('footer');		
    }

    function fees_student()
    {
        //error_reporting(E_ALL);
        $this->load->model('Account_model');
        if(!empty($_POST)){
        $data['dcourse']= $_POST['astream'];
        $data['dyear']= $_POST['ayear'];
        $data['hide']= $_POST['hide'];  
       // $data['competative_fees']= $this->Account_model->student_fees_details($_POST);
        }else{
            $var =array();
           $data['studentfee_details']= $this->Account_model->student_fees_details(); 
        } 
        
        $this->load->view('header',$this->data);    
        $this->load->view($this->view_dir.'student_fees',$data);
        $this->load->view('footer');        
    }
	
	
	
	public function stud_feelist($stream='',$year='')
    {
        $offset='0';
     $this->load->model('Account_model');
           $this->load->view('header',$this->data);        
        $limit = 10;// set records per page
		if(isset($_REQUEST['per_page'])){
			$offSet=$_REQUEST['per_page'];
		}
			
        $total= 0;
		
        $this->data['emp_list']= array();
		
		//$this->Account_model->getStudents($offSet,$limit);
		$total_pages = ceil($total/$limit);
		//echo $total_pages; 
		$this->load->library('pagination');
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config['enable_query_strings']=TRUE;
		$config['page_query_string']=TRUE;
		$config['reuse_query_string'] = TRUE;
		$config['base_url'] = base_url().'';
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);
	    $this->data['paginglinks'] = $this->pagination->create_links();
		$config['offSet'] = $offSet;		
		$total=ceil($total/$limit);
	
		/* echo $total;
             echo"<pre>";	     
		 print_r( $this->data['paginglinks']);
		 echo"</pre>"; 
		 die();   */
		 if($stream!='' && $year!='')
		 {
		  $this->data['emp_list']= $this->Account_model->searchStudentfeedata1($stream,$year);
		  $this->data['dcourse']=$stream;
		  $this->data['dyear']=$year;
		 }
		 
		  $college_id = 1;
		 $this->data['course_details']= $this->Account_model->getCollegeCourse($college_id);
		 
		 $this->data['academic_year']= $this->uri->segment(3);// echo '<br>';
		 $this->data['admission_course']= $this->uri->segment(4); //echo '<br>';
		 $this->data['admission_branch']= $this->uri->segment(5); //echo '<br>';
		 $this->data['admission_year']= $this->uri->segment(6); //echo '<br>';
		 
        $this->load->view($this->view_dir.'stud_feelist1',$this->data);
        $this->load->view('footer');
    }
	
	function search_studentfeedata(){
 $this->load->model('Account_model');		
	$data['prn']= $_POST['prn'];
    $data['emp_list']= $this->Account_model->searchStudentfeedata1($data['prn']);
    $data['Scholarship_type'] =$this->Account_model->Scholarship_type();
    $data['Scholarship_typee'] =$this->Account_model->Scholarship_typee();
    
    $data['count_rows']=count($data['emp_list']);
	      $html = $this->load->view($this->view_dir.'fee_adjust',$data,true);
		  //$html='wait';
	  echo $html;
}


function applyexem()
	{
		$this->load->model('Account_model');
$this->Account_model->fee_exemption();
   //echo '<script>alert("Fees updated successfully for selected students");<script>';
	      // redirect('orderManagement/index', 'refresh');
	     // $this->stud_feelist($st=0,$_POST['dcourse'],$_POST['dyear']);
$this->session->set_flashdata('errormessage','Fees updated successfully for selected students');

	 //redirect('ums_admission/stud_feelist/'.$_POST['dcourse'].'/'.$_POST['dyear']);
	    
	}
	
	
	function perview_difference(){
		// $this->data['fees']=$this->Account_model->perview_diffferent();
		// print_r( $this->data['fees']);
		 //exit();
         //   if($_POST['act']=="view"){
           //      $this->load->view($this->view_dir.'admission_fees_same',$this->data);
           //  }
            // else{
                $this->load->view('header',$this->data);   
                 $this->load->view($this->view_dir.'Dilay_fees_report.php',$this->data);
              //   $this->session->set_flashdata('excelmsg', 'download');
			  $this->load->view('footer',$this->data);   
           //  }
	}
	
	
	function perview_diffenrnt_call(){
		 $this->data['fees']=$this->Account_model->perview_diffferent($_POST);
		 $this->data['academic_year']=$_POST['academic_year'];
		// print_r( $this->data['fees']);
		 //exit();
         //   if($_POST['act']=="view"){
           //      $this->load->view($this->view_dir.'admission_fees_same',$this->data);
           //  }
            // else{
                
                 $this->load->view($this->view_dir.'reports/perview_diffenrnt',$this->data);
              //   $this->session->set_flashdata('excelmsg', 'download');
           //  }
	}
	
	
	/*
	* Cancel Admission Request Refund Module start,
	* Added BY:: Amit Dubey
	*/
	
	
	public function student_refund_request_list_old() {
		
		$filterData = '';
		if(isset($_POST) && !empty($_POST)){
			//
			if(isset($_POST['export']) && $_POST['export'] == 'Export' ){
				$this->export_student_refund_request_list($_POST);
			}
			//
			$this->data['searchParam'] = $_POST;
			$filterData = $_POST;
		} 
		$studentRefundRequestData = $this->Account_model->getStudentRefundRequestList($filterData);
			
			// Will use in future, If needed pagination
			/* $this->load->library('pagination');
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$studentRefundRequestData = $this->Account_model->getStudentRefundRequestList($filterData, $page);
			$config['base_url'] = base_url('Account/student_refund_request_list');
			$config['total_rows'] = $studentRefundRequestData['count'];
			$config['per_page'] = 1;
			$config['uri_segment'] = 3;  
			$config['full_tag_open']   = '<ul class="custom-pagination">';
			$config['full_tag_close']  = '</ul>';
			$config['first_link']      = '« First';
			$config['first_tag_open']  = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_link']       = 'Last »';
			$config['last_tag_open']   = '<li>';
			$config['last_tag_close']  = '</li>';
			$config['next_link']       = '›';
			$config['next_tag_open']   = '<li>';
			$config['next_tag_close']  = '</li>';
			$config['prev_link']       = '‹';
			$config['prev_tag_open']   = '<li>';
			$config['prev_tag_close']  = '</li>';
			$config['cur_tag_open']    = '<li class="active"><a href="#">';
			$config['cur_tag_close']   = '</a></li>';
			$config['num_tag_open']    = '<li>';
			$config['num_tag_close']   = '</li>';
			$this->pagination->initialize($config);
			$this->data['links'] = $this->pagination->create_links();  */
			
			$refundListData = array();
			$refundListDataArr = array();
			foreach($studentRefundRequestData as $refundData){
				//	
				if($refundData['request_type'] == 'cancel_admission' && in_array($refundData['status'], ['pending','cancel'])){
					continue;
				}
				
				if($refundData['request_type'] == 'cancel_admission' && $refundData['is_confirm'] == 0){
					continue;
				}
				
				$refundListData['id'] = $refundData['id'];
				$refundListData['request_type'] = $refundData['request_type'];
				$refundListData['fees_refund_id'] = $refundData['fees_refund_id'];
				$refundListData['student_id'] = $refundData['student_id'];
				$refundListData['enrollment_no'] = $refundData['enrollment_no'];
				$refundListData['student_bank_name'] = $refundData['student_bank_name'];
				$refundListData['student_bank_ac_no'] = $refundData['student_bank_ac_no'];
				$refundListData['student_bank_ac_holder_name'] = $refundData['student_bank_ac_holder_name'];
				$refundListData['student_bank_ifsc'] = $refundData['student_bank_ifsc'];
				$refundListData['student_bank_ifsc'] = $refundData['student_bank_ifsc'];
				$refundListData['fees_receipt'] = $refundData['fees_receipt'];
				$refundListData['remark'] = $refundData['remark'];
				$refundListData['management_remark'] = $refundData['management_remark'];
				$refundListData['academic_year'] = $refundData['academic_year'];
				$refundListData['amount'] = $refundData['amount'];
				$refundListData['status'] = $refundData['status'];
				$refundListData['bank_name'] = $refundData['bank_name'];
				$refundListData['created_on'] = $refundData['created_on'];
				$refundListData['student_cancel_cheque'] = $refundData['student_cancel_cheque'];
				$refundListData['total_refundable_amt']  = 0;
				$refundListData['processing_charge'] = 0;
				//
				$paramData['student_id'] = $refundData['student_id'];
				$paramData['refund_type'] = $refundData['request_type'];
				$paramData['academic_year'] = $refundData['academic_year'];
				$student_total_paid_fees = $this->Fees_model->getStudentPaidFeesByStudId($paramData);
				//
				$totalPaidAmount = 0;
				foreach($student_total_paid_fees as $paidFees){
					$totalPaidAmount += $paidFees['amount'];
				}
				//
				$refundListData['total_paid_amount'] = $totalPaidAmount;
				 
				if($refundData['request_type'] == 'cancel_admission'){
					//
					$college_start_date = '2025-08-15';
					//
					$checkCancelParam['student_id'] = $refundData['student_id'];
					$checkCancelParam['academic_year'] = $refundData['academic_year'];
					$checkCancelParam['enrollment_no'] = $refundData['enrollment_no'];
					$student_admission_cancel_data = $this->Fees_model->getStudentCancelData($checkCancelParam);
				 
					$admission_cancel_request_date = date('Y-m-d', strtotime($student_admission_cancel_data['canc_date']));
					// Convert to DateTime objects
					$cancel_date = new DateTime($admission_cancel_request_date);
					$start_date = new DateTime($college_start_date);
					// Calculate the difference in days
					$diff_between_date = $cancel_date->diff($start_date)->days;
					   
					if ($diff_between_date <= 15) {
						
						if (!empty($student_total_paid_fees)) {
					
							$processing_charge = round(($totalPaidAmount * 10)/100); 
							$refundListData['total_refundable_amt'] = round($totalPaidAmount-$processing_charge); 
							$refundListData['processing_charge'] = $processing_charge;
							$refundListData['total_paid_amount'] = $totalPaidAmount;
							//
						}
					} 
					//
				}
				
				//For Excess Fees Refund//
				if($refundData['request_type'] == 'excess_fees'){
					
					$searchData['prn'] = $refundData['enrollment_no'];
					$searchData['academic_year'] = $refundData['academic_year'];
					$studentData = $this->data['emp_list']= $this->Fees_model->searchforrefund($searchData);
					echo '<pre>';print_r($studentData);exit;
					$refundListData['total_refundable_amt'] = round($studentData['total_fee'] - $studentData['applicable_fee']);	 
				}
				
				//For Hostel Fees Refund//
				if($refundData['request_type'] == 'hostel' || $refundData['request_type'] == 'hostel_security_money'){
					
					$this->data['amt_show_flag'] = $amt_show_flag = 1;
					$postData['refund_type'] = $refundData['request_type'];
					$postData['academic_year'] = $refundData['academic_year'];
					$postData['fees_type'] = 1; // For Hostel
					$postData['student_id'] = $refundData['student_id'];
					$hostel_refund_data = $this->Fees_model->getStudentPaidHostelFees($postData);
					$refundListData['total_refundable_amt'] = $hostel_refund_data['total_paid_amt'];
				}
		
				$refundListDataArr[] = $refundListData;
				
			} // End foreach loop
			
			$this->data['studentRefundRequestList'] = $refundListDataArr; 
			
			$this->load->view('header',$this->data); 
			$this->load->view($this->view_dir.'student_refund_request_list',$this->data);
			$this->load->view('footer');
	}
	
public function student_refund_request_list() {
		
		$filterData = '';
		if(isset($_POST) && !empty($_POST)){
			//
			if(isset($_POST['export']) && $_POST['export'] == 'Export' ){
				$this->export_student_refund_request_list($_POST);
			}
			//
			$this->data['searchParam'] = $_POST;
			$filterData = $_POST;
		} 
		//$studentRefundRequestData = $this->Account_model->getStudentRefundRequestList($filterData);
		$this->load->library('pagination');
		$limit = $this->input->get('page') ? (int)$this->input->get('page') : 15;
		$offset = $this->uri->segment(3) ? (int)$this->uri->segment(3) : 0;

		$config['base_url'] = base_url('Account/student_refund_request_list');
		$config['total_rows'] = $this->Account_model->getStudentRefundRequestCount($filterData);
		$config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;
		// Bootstrap Pagination styling
		$config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
		$from = $total_rows > 0 ? ($offset + 1) : 0;
        $to = ($limit == -1) ? $total_rows : min($offset + $limit, $total_rows);
        $this->data['entry_summary'] = "Showing {$from} to {$to} of {$total_rows} entries";
        $this->pagination->initialize($config);
		$studentRefundRequestData = $this->Account_model->getStudentRefundRequestList($filterData, $config['per_page'], $offset);
		 
        $this->data['pagination_links'] = $this->pagination->create_links();
        $this->data['limit'] = $limit;
		/* echo"<pre>";
		print_r($studentRefundRequestData); die; */  
			
			$refundListData = array();
			$refundListDataArr = array();
			
			foreach($studentRefundRequestData as $refundData){
				 
				
				$refundParam['student_id'] = $refundData['student_id'];
				$studentTotalRefundedAmt = $this->Account_model->getOldTotalRefundAmt($refundParam);
				 				 
				$pendingAmt = 0;
			/* 	if (is_array($studentApiData) && count($studentApiData) > 0) {
					
					$totalRefundedAmount = 0;
					foreach($studentApiData as $paidFees){
						$totalRefundedAmount += $paidFees['FeesRefunded'];
					}
					
				} */ 
				
				//$refundParam['enrollment_no'] = $refundData['enrollment_no'];
				
				//
				$refundListData['id'] = $refundData['id'];
				$refundListData['request_type'] = $refundData['request_type'];
				$refundListData['fees_refund_id'] = $refundData['fees_refund_id'];
				$refundListData['student_id'] = $refundData['student_id'];
				$refundListData['enrollment_no'] = $refundData['enrollment_no'];
				$refundListData['student_bank_name'] = $refundData['student_bank_name'];
				$refundListData['student_bank_ac_no'] = $refundData['student_bank_ac_no'];
				$refundListData['student_bank_ac_holder_name'] = $refundData['student_bank_ac_holder_name'];
				$refundListData['student_bank_ifsc'] = $refundData['student_bank_ifsc'];
				$refundListData['student_bank_ifsc'] = $refundData['student_bank_ifsc'];
				$refundListData['fees_receipt'] = $refundData['fees_receipt'];
				$refundListData['remark'] = $refundData['remark'];
				$refundListData['management_remark'] = $refundData['management_remark'];
				$refundListData['academic_year'] = $refundData['academic_year'];
				$refundListData['amount'] = $refundData['amount'];
				$refundListData['status'] = $refundData['status'];
				$refundListData['bank_name'] = $refundData['bank_name'];
				$refundListData['created_on'] = $refundData['created_on'];
				$refundListData['admission_session'] = $refundData['admission_session'];
				$refundListData['student_cancel_cheque'] = $refundData['student_cancel_cheque'];
				$refundListData['total_refunded_amt'] = $studentTotalRefundedAmt['total_refunded_amt'] ?? 0;
				
				
				$refundListData['total_refundable_amt']  = 0;
				$refundListData['processing_charge'] = 0;
				//
				$paramData['student_id'] = $refundData['student_id'];
				$paramData['refund_type'] = $refundData['request_type'];
				$paramData['academic_year'] = $refundData['academic_year'];
				$student_total_paid_fees = $this->Fees_model->getStudentPaidFeesByStudId($paramData);
				//
				$totalPaidAmount = 0;
				$totalRefundableAmount = 0;
				foreach($student_total_paid_fees as $paidFees){
					$totalPaidAmount += $paidFees['amount'];
				}
				//
				$refundListData['total_paid_amount'] = $totalPaidAmount;
				 
				if($refundData['request_type'] == 'cancel_admission'){
					
					if($refundData['admission_session'] == ADMISSION_SESSION){
						$refundListData['processing_charge'] = 1000;
						$refundListData['total_applicable_amt'] = 0;
						$refundListData['total_refundable_amt'] = round($totalPaidAmount-$refundListData['processing_charge']);
					}else{
						$refundListData['processing_charge'] = 0;
					}
					//
				/* 	$college_start_date = '2025-08-15';
					$checkCancelParam['student_id'] = $refundData['student_id'];
					$checkCancelParam['academic_year'] = $refundData['academic_year'];
					$checkCancelParam['enrollment_no'] = $refundData['enrollment_no'];
					$student_admission_cancel_data = $this->Fees_model->getStudentCancelData($checkCancelParam);
					$admission_cancel_request_date = date('Y-m-d', strtotime($student_admission_cancel_data['canc_date']));
					$cancel_date = new DateTime($admission_cancel_request_date);
					$start_date = new DateTime($college_start_date);
					$diff_between_date = $cancel_date->diff($start_date)->days;
					if ($diff_between_date <= 15) {
						if (!empty($student_total_paid_fees)) {
					
							$processing_charge = round(($totalPaidAmount * 10)/100); 
							$refundListData['total_refundable_amt'] = round($totalPaidAmount-$processing_charge); 
							$refundListData['processing_charge'] = $processing_charge;
							$refundListData['total_paid_amount'] = $totalPaidAmount;
						}
					}  */
				
				}
				
				//For Excess Fees Refund//
				if($refundData['request_type'] == 'excess_fees'){
					
					$searchData['prn'] = $refundData['enrollment_no'];
					$searchData['academic_year'] = $refundData['academic_year'];
					$studentData = $this->data['emp_list']= $this->Fees_model->searchforrefund($searchData);
				
					//$refundListData['total_refundable_amt'] = round($studentData['total_fee'] - $studentData['applicable_fee']);	 
					$totalRefundedAmount = $studentTotalRefundedAmt['total_refunded_amt'];
					$totalRefundableAmount = $refundListData['total_refundable_amt'] = round($totalPaidAmount - $studentData['applicable_fee'])-$totalRefundedAmount;
					$refundListData['total_applicable_amt']	= $studentData['applicable_fee'];				
				}
				
				//For Hostel Fees Refund//
				if($refundData['request_type'] == 'hostel' || $refundData['request_type'] == 'hostel_security_money'){
					
					$this->data['amt_show_flag'] = $amt_show_flag = 1;
					$postData['refund_type'] = $refundData['request_type'];
					$postData['academic_year'] = $refundData['academic_year'];
					$postData['fees_type'] = 1; // For Hostel
					$postData['student_id'] = $refundData['student_id'];
					$hostel_refund_data = $this->Fees_model->getStudentPaidHostelFees($postData);
					$refundListData['total_refundable_amt'] = $hostel_refund_data['total_paid_amt'];
				}
				
				$refundListDataArr[] = $refundListData;
				//
				/* $DB1 = $this->load->database('umsdb', TRUE);
				$DB1->where('id', $refundData['id']);
				$DB1->update('student_request_refund',['amount' => $totalRefundableAmount]);  */
				//echo $DB1->last_query(); die;
				
			} // End foreach loop
			
			$this->data['studentRefundRequestList'] = $refundListDataArr; 
			
			$this->load->view('header',$this->data); 
			$this->load->view($this->view_dir.'student_refund_request_list',$this->data);
			$this->load->view('footer');
	}	
	
	public function export_student_refund_request_list($dataArr){
		
		$this->load->library('Excel');
		$borderStyle = [
		'borders' => [
		'allborders' => [
			'style' => PHPExcel_Style_Border::BORDER_THIN
		]
		]
		];
		
        $student_request_data['academic_year'] = $dataArr['academic_year'];
		$student_request_data['request_month'] = $dataArr['request_month'];
		$student_request_data['request_status'] = $dataArr['request_status'];
     
        $studentRequestDataList = $this->Account_model->getStudentRefundRequestExcelExport($student_request_data);
		  
 		$this->load->library('Excel');
        $objPHPExcel = new Excel();
		 
		if(!empty($dataArr['academic_year']) && !empty($dataArr['request_month'])){
			$monthName = date("F", mktime(0, 0, 0, $dataArr['request_month'], 10));
			$title = 'Student Refund Request List (' . $monthName . '-' . $dataArr['academic_year'] . ')';
		}else{
			$title = 'Student Refund Request List';
		}
        
		$objPHPExcel->getProperties()->setCreator("")->setTitle($title);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('B3:R5');
		$objPHPExcel->getActiveSheet()->getStyle('B3:R5')->applyFromArray([ // new add
		
			'fill' => [
				'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				//'rotation' => 90,
				'startcolor' => ['rgb' => '4A90E2'], // Starting color (yellow)
				'endcolor' => ['rgb' => 'fbd214'],   // Ending color (orange)
			]
		]);
		
        //$objPHPExcel->getActiveSheet()->mergeCells('B3:AZ3');
        //$objPHPExcel->getActiveSheet()->mergeCells('A6:Q6');
		
		$logo = new PHPExcel_Worksheet_Drawing();
		$logo->setName('Logo');
		$logo->setDescription('Sandip University Logo');
		$logo->setPath('assets/su-watermark-logo.png'); // Provide the correct path to your logo
		$logo->setHeight(50); // Adjust height as needed
		$logo->setWidth(60);  // Adjust width as needed
		$logo->setCoordinates('E3'); // Set the top-left cell for the logo
		$logo->setOffsetX(3); // Adjust the horizontal offset
		$logo->setOffsetY(5); // Adjust the vertical offset
		$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(26); 
		
		// Define the header style with background fill
		$headerStyle = [
			'fill' => [
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => [
					'rgb' => '00274D'  
				]
			],    
			'font'=>[
						'bold' => true,
						'color' => ['rgb' => 'FFFFFF']
				],	
		];
		$objPHPExcel->getActiveSheet()->getStyle('B6:R6')->applyFromArray($headerStyle);
		
		$logo->setWorksheet($objPHPExcel->getActiveSheet());
        // Apply formatting to specific cells
        $objPHPExcel->getActiveSheet()->getStyle('B3:R2')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B6:R6')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("B6:R6")->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('B2:R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       
        $objPHPExcel->getActiveSheet()->setCellValue('B3', $title);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setSize(20)->setBold(true);//new add
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//new add
        $objPHPExcel->getActiveSheet()->getStyle('B3:Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		//$objPHPExcel->getActiveSheet()->setCellValue('B3', 'TRIMBAK ROAD, MAHIRAVANI, NASHIK-422213');
		//$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		/* $objPHPExcel->getActiveSheet()->getStyle('A6:Q6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Student Refund Request List');
        $objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); */
        
        //$objPHPExcel->getActiveSheet()->getStyle('B7:AZ7')->getFont()->setBold(true);
        //$objPHPExcel->getActiveSheet()->getStyle('B7:AZ7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //$objPHPExcel->getActiveSheet()->getStyle('A7:AZ7')->getFont()->setBold(true);

					/*->setCellValue('Q7', 'Blood Group')
					->setCellValue('R7', 'Scale Type')
					->setCellValue('S7', 'Pay Band')
					->setCellValue('T7', 'Pan Number');  
					->setCellValue('U7', 'UAN Number')
					->setCellValue('V7', 'Aadhar Number')
					->setCellValue('W7', 'Category') */
					
					 $objPHPExcel->getActiveSheet()
					->setCellValue('B6', 'Sr No.')
					->setCellValue('C6', 'Enrollment No')
					->setCellValue('D6', 'Student Name')
					->setCellValue('E6', 'Gender')
					->setCellValue('F6', 'Course')
					->setCellValue('G6', 'Stream')
					->setCellValue('H6', 'Current Year')
					->setCellValue('I6', 'Academic Year')
					->setCellValue('J6', 'School')
					->setCellValue('K6', 'Student Bank Name')
					->setCellValue('L6', 'Student Bank Account No')
					->setCellValue('M6', 'Bank Account Holder Name')
					->setCellValue('N6', 'IFSC')
					->setCellValue('O6', 'Amount')
					->setCellValue('P6', 'Deducted Amount')
					->setCellValue('Q6', 'Request For')
					->setCellValue('R6', 'Request Date');
                // Populate data
					//$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);  // Sr No.
					$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);  // Enrollment No
					$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);  // Student Name
					$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);  // Student Name
					$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);  // Account No
					$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);  // Account No
					$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);  // Account No
					$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);  // Account No

				$row = 7;
				$sn = 1;
				foreach ($studentRequestDataList as $requestData) {
					
					if($requestData['request_type'] == "hostel"){
						$request_for = 'Hostel';
					}
					//
					if($requestData['refund_for'] == "transport"){
						$request_for = 'Transport';
					}
					//
					if($requestData['request_type'] == "uniform"){
						$request_for = 'Uniform';
					}
					//
					if($requestData['request_type'] == "excess_fees"){
						$request_for = 'Excess Fees';
					}
					//
					if($requestData['request_type'] == "cancel_admission"){
						$request_for = 'Cancel Admission';
					}
					
					$objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $sn);
					$objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $requestData['enrollment_no']);
					$objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $requestData['first_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $requestData['gender']);
					$objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $requestData['course_short_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $requestData['stream_name']);   
					$objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $requestData['current_year']);
					$objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $requestData['academic_year']);
					$objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $requestData['school_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $requestData['bank_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $requestData['student_bank_ac_no']);
					$objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $requestData['student_bank_ac_holder_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $requestData['student_bank_ifsc']);
					$objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $requestData['amount']??0); 
					$objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $requestData['deduct_amount']??0);
					//$objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $request_for);
					//$objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $requestData['created_on']);
					$objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $request_for);
					$objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $requestData['created_on']);
					/*$objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $employee['blood_gr']);
					$objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $employee['scaletype']);
					$objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $value);
					$objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $employee['pan_no']); */
					$row++;
					$sn++; 
			    }  

			$objPHPExcel->getActiveSheet()
			->getStyle("B7:R".($row-1)."")
			->applyFromArray($borderStyle);

			ob_clean();
				
			$objPHPExcel->setActiveSheetIndex(0);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="student_refund_request_list.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');     
			
			exit;
		
	}

}
?>