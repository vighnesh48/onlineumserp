<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fees_challan extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="";
    var $model_name="Fees_challan_model";
    var $model;
    var $view_dir='Fees_challan/';
    var $data=array();
    public function __construct() 
    {
        parent:: __construct();
		// error_reporting(E_ALL);
		//ini_set('display_errors', 1);
        // load form and url helpers
        $this->load->helper(array('form', 'url'));
         
        // load form_validation library
        $this->load->library('form_validation');
		$this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
		$this->load->model($this->model_name);
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==40){
		}else{
			redirect('home');
		}
	}
	
	public function index()
    {
        $this->fees_challan_list();
    }
	
	public function fees_challan_list()
    {
        $this->load->view('header',$this->data);
		$this->data['challan_details']=$this->Fees_challan_model->fees_challan_list();
        $this->load->view($this->view_dir.'fees_challan_list',$this->data);
        $this->load->view('footer');
    }
	
	public function add_fees_challan()
	{
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Fees_challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Fees_challan_model->get_depositedto();
		$this->data['bank_details']= $this->Fees_challan_model->getbanks();
		$this->load->view($this->view_dir.'add_fees_challan_details',$this->data);
        $this->load->view('footer');
	}
	
	public function challan_list_by_creteria()
	{
		$std_challan_list=$this->Fees_challan_model->fees_challan_list($_POST);
		echo json_encode(array("std_challan_list"=>$std_challan_list));
	}
	
	public function edit_challan()
	{
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Fees_challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Fees_challan_model->get_depositedto();
		$this->data['bank_details']= $this->Fees_challan_model->getbanks();
		$this->data['challan_details']=array_shift($this->Fees_challan_model->fees_challan_list_byid($this->uri->segment(3)));
		//exit();
		$this->load->view($this->view_dir.'edit_fees_challan_details',$this->data);
        $this->load->view('footer');
	}
	
	public function get_challan_details()
	{
		$challan_details=array_shift($this->Fees_challan_model->fees_challan_list_byid($_POST['id']));
		echo json_encode(array("challan_details"=>$challan_details));
	}
	
	public function students_data()
	{
		$std_details = $this->Fees_challan_model->students_data($_POST);   
		//var_dump($std_details);
	   	echo json_encode(array("std_details"=>$std_details));
	}
	
	public function add_fees_challan_submit()
	{
		if($_POST['fees_date']=='')
			$fdate=date("Y-m-d");
		else
			$fdate=$_POST['fees_date']; 
		//var_dump($_POST);
		//echo $fdate; exit();
		$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],"deposit_fees"=>$_POST['deposit'],"facility_fees"=>$_POST['facility'],"college_receiptno"=>$_POST['category'],"other_fees"=>$_POST['other'],"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],"receipt_no"=>$_POST['receipt_number'],"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s")); 
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->Fees_challan_model->add_fees_challan_submit($insert_array);
		if($last_inserted_id)
		{
			$ayear= substr($_POST['academic'], -2);  //explode("-",$_POST['academic']);
			$challan_no=$ayear.str_pad( $last_inserted_id, 4, "0", STR_PAD_LEFT );
			$update_array=array("exam_session"=>$challan_no);
			$last_inserted_id= $this->Fees_challan_model->update_challan_no($last_inserted_id,$update_array);
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}
		else
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
        
		redirect(base_url($this->view_dir.'fees_challan_list'));
	}
	
	public function edit_fees_challan_submit()
	{
		if($_POST['fees_date']=='')
			$fdate=date("Y-m-d");
		else
			$fdate=$_POST['fees_date']; 
		
		$update_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],"deposit_fees"=>$_POST['deposit'],"facility_fees"=>$_POST['facility'],"college_receiptno"=>$_POST['category'],"other_fees"=>$_POST['other'],"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],"receipt_no"=>$_POST['receipt_number'],"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s")); 
		$id=$this->uri->segment(3);
        $last_inserted_id= $this->Fees_challan_model->update_challan_no($id,$update_array);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Generated Fees Challan updated Successfully.');
		else
			$this->session->set_flashdata('message2','Generated Fees Challan Not updated Successfully.');
        
		redirect(base_url($this->view_dir.'edit_challan/'.$id));
	}
	
	public function get_faci_category_details()
	{
		$category_details = $this->Fees_challan_model->get_faci_category_details($_POST);
		if(!empty($category_details)){
			
			if($_POST['facility']==1)
			{
				echo"<option value=''>Select Category</option>";
				foreach($category_details as $key=>$val){
					echo"<option value='".$category_details[$key]['cat_id']."'>".$category_details[$key]['campus_name']."</option>";
				}
			}
			else if($_POST['facility']==2)
			{
				echo"<option value=''>Select Category</option>";
				foreach($category_details as $key=>$val){
					echo"<option value='".$category_details[$key]['board_id']."'>".$category_details[$key]['boarding_point']."</option>";
				}
			}
		}
		else
			echo"<option value=''>Category Not found</option>";
	}
	
	public function get_faci_fee_details()
	{
		$fee_details = array_shift($this->Fees_challan_model->get_faci_fee_details($_POST));
		echo json_encode(array("fee_details"=>$fee_details));
	}
	
	public function download_challan_pdf($fees_id){
		//load mPDF library
        
		//$this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		//echo $hgp_id.','.$stud_prn.','.$stud_org;exit();
		$this->load->library('m_pdf', $param);
		
		if($fees_id!='')
		{
			$std_challan_details=array_shift($this->Fees_challan_model->fees_challan_list_byid($fees_id));
		  //echo json_encode(array("std_gatepass_details"=>$std_gatepass_details));
			$this->data['std_challan_details']= $std_challan_details;
		}

		$html = $this->load->view($this->view_dir.'facility_challan_pdf', $this->data, true);
		$pdfFilePath = $this->data['std_challan_details']['enrollment_no']."_facilityfee_challan_pdf.pdf";

		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);

		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
		
		// ob_end_flush(); 
		
	}
	
	public function challan_approval_submit()
	{
		$status='';
		if(isset($_POST["reject"]))
		{
			$status='Cancelled';
			$update_array=array("remark"=>$_POST['remarks'],"challan_status"=>'CL',"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));
		}
		else if(isset($_POST["approve"]))
		{
			$status='Verified';
			$update_array=array("remark"=>$_POST['remarks'],"challan_status"=>'VR',"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));
		}
		$flag=$this->Fees_challan_model->update_challan_no($_POST['feesid'],$update_array);
		
		if($flag)
			$this->session->set_flashdata('message1','Challan Generated request is '.$status.' Successfully.');
		
		redirect(base_url($this->view_dir));
	}
}

?>