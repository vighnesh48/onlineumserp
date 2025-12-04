<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admission extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="student_master";
    var $model_name="Admission_model";
    var $model;
    var $view_dir='Admission/';
    
    public function __construct() 
    {
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
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    
    public function report(){
	    $this->load->view('header',$this->data);  
		$this->load->model('Account_model');
		$this->data['exam_session']= $this->Account_model->fetch_stud_curr_year();		
	    $this->load->view($this->view_dir.'report/report_list',$this->data);
	    $this->load->view('footer');
	}
	
	   public function get_admission_statistics()
        {      
		//error_reporting(E_ALL);
              $data['academic_year']=$_POST['academic_year'];
              $data['report_type']=$_POST['report_type'];
               $data['school_id']=$_POST['school_id'];
               $data['course_id']=$_POST['course_id'];
               $data['stream_id']=$_POST['stream_id'];
                $data['year']=$_POST['year'];
              ini_set("memory_limit", "-1");
				set_time_limit(0);
        	  $data['adm_data']= $this->Admission_model->get_admission_statistics($data);
        	   switch($_POST['report_type']){
        	           case "1": //echo"test";exit();
        	                $data['adm_data']= $this->Admission_model->get_admission_summary($data);
        	               if($_POST['act']=="view"){ 
        	                   
        	                  $html = $this->load->view($this->view_dir.'report/html_admission_report',$data,true);  
        	               }
        	               else{
        	                   $html = $this->load->view($this->view_dir.'report/excel_admission',$data,true); 
        	               }
        	           break;
        	            case "2":
        	                if($_POST['act']=="view"){   
        	                  $html = $this->load->view($this->view_dir.'report/html_admission_report',$data,true);  
        	               }
        	               else{
        	                    $html = $this->load->view($this->view_dir.'report/excel_admission',$data,true); 
        	               }
        	           break;
        	            case "3":
        	                if($_POST['act']=="view"){ 
        	                  $html = $this->load->view($this->view_dir.'report/html_admission_report',$data,true);  
        	               }
        	               else{
        	                    $html = $this->load->view($this->view_dir.'report/excel_admission',$data,true); 
        	               }
        	           break;
        	            case "4":
        	                 $data['adm_data']= $this->Admission_model->get_citywise_total($data);
        	                if($_POST['act']=="view"){
        	                    
        	                  $html = $this->load->view($this->view_dir.'report/html_admission_report',$data,true);  
        	               }
        	               else{
        	                   $html = $this->load->view($this->view_dir.'report/excel_admission',$data,true); 
        	               }
        	           break;
        	            case "5":
        	                $data['adm_data']= $this->Admission_model->get_scholorship_list($data);
        	                if($_POST['act']=="view"){
        	                  $html = $this->load->view($this->view_dir.'report/html_admission_report',$data,true);  
        	               }
        	               else{
        	                   $html = $this->load->view($this->view_dir.'report/excel_admission',$data,true); 
        	               }
        	           break;
        	            case "6":
        	                 $data['adm_data']= $this->Admission_model->get_cancelled_list($data);
        	                if($_POST['act']=="view"){
        	                  $html = $this->load->view($this->view_dir.'report/html_admission_report',$data,true);  
        	               }
        	               else{
        	                   $html = $this->load->view($this->view_dir.'report/excel_admission',$data,true); 
        	               }
        	           break;
        	            case "7":
        	                $data['adm_data']= $this->Admission_model->get_direct_admission_list($data);
        	                if($_POST['act']=="view"){
        	                  $html = $this->load->view($this->view_dir.'report/html_admission_report',$data,true);  
        	               }
        	               else{
        	                   $html = $this->load->view($this->view_dir.'report/excel_admission',$data,true); 
        	               }
        	           break;
        	            case "8":
        	                 $data['adm_data']= $this->Admission_model->get_student_list($data);
        	                if($_POST['act']=="view"){
        	                  $html = $this->load->view($this->view_dir.'report/html_admission_report',$data,true);  
        	               }
        	               else{
        	                   $html = $this->load->view($this->view_dir.'report/excel_admission',$data,true); 
        	               }
        	           break;
        	            case "9":
        	                 $data['adm_data']= $this->Admission_model->get_parent_list($data); 
        	                if($_POST['act']=="view"){
        	                  $html = $this->load->view($this->view_dir.'report/html_admission_report',$data,true);  
        	               }
        	               else{
        	                   $html = $this->load->view($this->view_dir.'report/excel_admission',$data,true); 
        	               }
        	           break;
        	            case "10"://print_r($_POST);exit();
        	                 $data['adm_data']= $this->Admission_model->get_approval_list($data); 
        	                if($_POST['act']=="view"){
        	                  $html = $this->load->view($this->view_dir.'report/html_admission_report',$data,true);  
        	               }
        	               else{
        	                   $html = $this->load->view($this->view_dir.'report/excel_admission',$data,true); 
        	               }
        	           break;
        	            case "14"://print_r($_POST);exit();
        	                 $data['adm_data']= $this->Admission_model->get_approval_list($data); 
        	                if($_POST['act']=="view"){
        	                  $html = $this->load->view($this->view_dir.'report/html_admission_report',$data,true);  
        	               }
        	               else{
        	                   $html = $this->load->view($this->view_dir.'report/excel_admission',$data,true); 
        	               }
        	           break;
        	            case "15"://print_r($_POST);exit();
        	                 $data['adm_data']= $this->Admission_model->get_student_status_list($data); 
        	                 
        	                if($_POST['act']=="view"){
        	                  $html = $this->load->view($this->view_dir.'report/html_admission_report',$data,true);  
        	               }
        	               else{
        	                   $html = $this->load->view($this->view_dir.'report/excel_admission',$data,true); 
        	               }
        	           break;
        	            case "16"://print_r($_POST);exit();
        	                 $data['adm_data']= $this->Admission_model->get_student_status_list($data); 
        	                 
        	                if($_POST['act']=="view"){
        	                  $html = $this->load->view($this->view_dir.'report/html_admission_report',$data,true);  
        	               }
        	               else{
        	                   $html = $this->load->view($this->view_dir.'report/excel_admission',$data,true); 
        	               }
        	           break;
					   case "17":
        	                 $data['adm_data']= $this->Admission_model->getNoReRegistration_list($data);
        	                if($_POST['act']=="view"){
        	                  $html = $this->load->view($this->view_dir.'report/html_admission_report',$data,true);  
        	               }
        	               else{
        	                   $html = $this->load->view($this->view_dir.'report/excel_admission',$data,true); 
        	               }
        	           break;
        	       
        	   }
        	 
        	  echo $html;
        }
        
        public function get_ajax_admission_course(){
           // print_r($_POST);exit();
               $data['academic_year']=$_POST['academic_year'];
               $data['school_id']=$_POST['school_id'];
               $data['course_id']=$_POST['course_id'];
               $data['stream_id']=$_POST['stream_id'];
                $data['year']=$_POST['year'];
               $data['type']=$_POST['type'];
               $result=$this->Admission_model->get_course_list($data);
          
               foreach($result as $row){
                    if($_POST['type']=="school"){
                echo'<option value="'.$row['school_id'].'">'.$row['school_name'].'</option>';
            }
              else if($_POST['type']=="course"){
                echo'<option value="'.$row['course_id'].'">'.$row['course_short_name'].'</option>';
            }
             else if($_POST['type']=="stream"){
                echo'<option value="'.$row['stream_id'].'">'.$row['stream_short_name'].'</option>';
            }
             else if($_POST['type']=="year"){
                echo'<option value="'.$row['year'].'">'.$row['year'].'</option>';
            }
               }
            
        }
        
        /*to be deleted not in use*/
	 public function overall_statistics(){
	     $row['academic_year']='2017';
	     $this->load->view('header',$this->data);        
	    $this->load->view($this->view_dir.'report/overall_statistics',$this->data);
	     $this->load->view('footer');
	}
	
	
	// Added BY: Amit Dubey AS On 10-09-2025, Code block Start for Admission Cancel Request/Refund//
	
	public function student_admission_cancel_request_list() 
	{
		 
			if(in_array($_SESSION['role_id'], [20,2], true)){
				$this->session->set_flashdata('error', "You don't have permission to perform this action.");
				redirect('home');
			}
			//
			$this->load->model('Account_model');
			$this->load->model('Fees_model');
			
			$this->db->select("dsm.ums_stream_id");
			$this->db->from("sandipun_erp_sf.employee_master as em");
			$this->db->join("sandipun_erp_sf.department_ums_stream_mapping as dsm", 'dsm.department_id = em.department');
			$this->db->where("em.emp_id", $_SESSION['username']);		
			$this->db->where("em.emp_status", 'Y');	
			$this->db->where("dsm.school_college_id", $_SESSION['school']);
			$query=$this->db->get();
			$mappedStreamIdData = $query->result_array();
		
			$filterData = array();
			if(isset($_POST) && !empty($_POST)){
				 
				if($_POST['export_flag'] == 1){
					$this->export_student_refund_request_list($_POST);
				}
				 
				$this->data['searchParam'] = $_POST;
				$filterData = $_POST;
			}
			
			$filterData['request_type'] = 'cancel_admission';
			$filterData['stream_id'] = $mappedStreamIdData;

			$studentRefundRequestListData = $this->Admission_model->getStudentRefundRequestList($filterData);
			
			$refundListData = array();
			$refundListDataArr = array();
			foreach($studentRefundRequestListData as $refundData){
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
					//echo $diff_between_date; die;
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
				
				$refundListDataArr[] = $refundListData;
				
			} // End foreach loop
			
			$this->data['studentRefundRequestList'] = $refundListDataArr; 
		 
			$this->load->view('header',$this->data); 
			$this->load->view($this->view_dir.'student_admission_cancel_request_list',$this->data);
			$this->load->view('footer');
		
	}
	
	public function updateRefundStatus(){
		
		if(empty($_POST['checkedRefund'])){
			$this->session->set_flashdata('error', 'Kindly select the record');
			redirect('Admission/student_admission_cancel_request_list');
		}
		$DB1 = $this->load->database('umsdb', TRUE); 
		$status = $_POST['request_status'];
		$DB1->where_in('id', $_POST['checkedRefund']);
		$DB1->update('student_request_refund',['status' => $status]); 
		$this->session->set_flashdata('success', 'Record updated successfully.');
		redirect('Admission/student_admission_cancel_request_list');
	}
	
   
		
	
}
?>