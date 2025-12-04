<?php
//ini_set("display_errors", "On");
//error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Kp_report extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Fees_model";
     var $model_name1="Kp_report";
    var $model;
    var $view_dir='Kp_report/';
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
        $this->load->model("Kp_report_model");
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

    public function kp_report()
    {
        $this->load->view('header',$this->data);
        $this->data['exam_session']= $this->Kp_report_model->fetch_stud_curr_year();	
		$this->data['partner_list']= $this->Kp_report_model->fetch_partner_list();
        $this->load->view($this->view_dir.'admission_fees_report.php',$this->data);
        $this->load->view('footer');
    }
	
	public function admission_fees_report_same()
    {
      
        $this->load->view('header',$this->data);    
        $this->load->view($this->view_dir.'admission_fees_report_same.php',$this->data);
        $this->load->view('footer');
    }

    public function get_admission_fees_report()
    {   //error_reporting(E_ALL);
        // $year= (explode("-",$_POST['academic_year']));
         //$year=$year[1];
		 $_POST['report_type']=2;
         $this->data['academic_year']=$_POST['academic_year'];
         $this->data['admission_type']=$_POST['admission_type'];
         $this->data['report_type']=$_POST['report_type'];
		 $this->data['partner']=$_POST['partner'];
        //print_r($_POST);
       
	   
	   if($_POST['report_type']=="2" || $_POST['report_type']=="6" )
        {
            
             $this->data['fees']=$this->Kp_report_model->get_studentwise_admission_fees($this->data);
			 $this->data['share']=$this->Kp_report_model->get_share($this->data);
             if($_POST['act']=="view"){
               
                 $this->load->view($this->view_dir.'admission_fees',$this->data);
             }
             else{
                
                 $this->load->view($this->view_dir.'reports/excel_admission_fees',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }

        }
        /*else if($_POST['report_type']=="2" || $_POST['report_type']=="6" ) 
        {
            $this->data['get_by']="";
            $this->data['fees']=$this->Kp_report_model->get_studentwise_admission_fees($this->data);
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
             $this->data['fees']=$this->Kp_report_model->get_streamwise_admission_fees($this->data);
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
             $this->data['fees']=$this->Kp_report_model->get_studentwise_admission_fees($this->data);
            if($_POST['act']=="view"){
               // print_r($_POST);exit();
                 $this->load->view($this->view_dir.'admission_fees',$this->data);
             }
             else{
                
                 $this->load->view($this->view_dir.'reports/excel_admission_fees_studentwise',$this->data);
                  $this->session->set_flashdata('excelmsg', 'download');
             }
            
        }*/
        
    }
	
	public function get_admission_fees_report_same()
    {   
        
         $this->data['academic_year']=$_POST['academic_year'];
         $this->data['admission_type']=$_POST['admission_type'];
         $this->data['report_type']=$_POST['report_type'];
        if($_POST['report_type']=="1" || $_POST['report_type']=="5" )
        {
            
             $this->data['fees']=$this->Kp_report_model->get_fees_collection_admission($this->data);
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
            $this->data['fees']=$this->Kp_report_model->get_studentwise_admission_fees($this->data);
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
             $this->data['fees']=$this->Kp_report_model->get_streamwise_admission_fees($this->data);
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
             $this->data['fees']=$this->Kp_report_model->get_studentwise_admission_fees($this->data);
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
        $this->data['fees']=$this->Kp_report_model->get_studentwise_admission_fees($row);
        $this->load->view($this->view_dir.'stream_wise',$this->data);
       
    }
  	 
  	 
    public function fees_refund()
    {
		   $this->load->view('header',$this->data); 
		    $this->data['emp_list']= $this->Fees_model->fees_refund();
		     $this->load->view($this->view_dir.'refund_list',$this->data);
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
	    $this->data['acc_data']= $this->Kp_report_model->get_account_report($row);
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
                $this->data['acc_data']= $this->Kp_report_model->check_payment_no($row);
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
        $this->data['ex_sess']= $this->Kp_report_model->fetch_stud_curr_exam();
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
           $this->data['fees_data']= $this->Kp_report_model->get_examination_fees($row);
                
           $this->load->view($this->view_dir.'reports/excel_exam_fees',$this->data);
            
      }else if($_POST['report_type']=="2")
      {	
           $this->data['fees_data']= $this->Kp_report_model->get_exam_fees_statistics($row);
           $this->load->view($this->view_dir.'reports/excel_exam_fees_statistics',$this->data);
      }else
      {	
           $this->data['fees_data']= $this->Kp_report_model->get_student_examination_fees($row);
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
             $this->data['fees']=$this->Kp_report_model->get_fees_collection_hostel($this->data);
           
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
            $this->data['fees']=$this->Kp_report_model->get_studentwise_hostel_fees($this->data);
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
             $this->data['fees']=$this->Kp_report_model->get_hostel_fees_statistics($this->data);
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
             $this->data['fees']=$this->Kp_report_model->get_studentwise_hostel_fees($this->data);
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
		$this->data['indet']= $this->Kp_report_model->updatePayment($sf_id, $data);
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
        $this->load->model('Kp_report_model');
		if(!empty($_POST)){
		$data['dcourse']= $_POST['astream'];
    	$data['dyear']= $_POST['ayear'];
    	$data['hide']= $_POST['hide'];  
		$data['competative_fees']= $this->Kp_report_model->fetch_competative_fees($_POST);
		}else{
			$var =array();
			$data['competative_fees']= $this->Kp_report_model->fetch_competative_fees($var);
		} 	
		$this->load->view('header',$this->data); 	
    	$this->load->view($this->view_dir.'competative_fees',$data);
		$this->load->view('footer');		
    }

    function fees_student()
    {
        //error_reporting(E_ALL);
        $this->load->model('Kp_report_model');
        if(!empty($_POST)){
        $data['dcourse']= $_POST['astream'];
        $data['dyear']= $_POST['ayear'];
        $data['hide']= $_POST['hide'];  
       // $data['competative_fees']= $this->Kp_report_model->student_fees_details($_POST);
        }else{
            $var =array();
           $data['studentfee_details']= $this->Kp_report_model->student_fees_details(); 
        } 
        
        $this->load->view('header',$this->data);    
        $this->load->view($this->view_dir.'student_fees',$data);
        $this->load->view('footer');        
    }
}
?>