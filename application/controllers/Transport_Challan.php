<?php
//ini_set("display_errors", "On");
//error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Transport_Challan extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Fees_model";
    var $model_name1="Transport_facility_model";
    var $model;
    var $view_dir='Transport_Challan/';
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
        $this->load->model("Transport_facility_model");
		$this->load->model("hostel_model");
		$this->load->model("Transport_model");
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
      
	  
	  public function fees_challan_list()
    {
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==17 || $this->session->userdata("role_id")==47 || $this->session->userdata("role_id")==46){
		}else{
			redirect('home');
		}
        $this->load->view('header',$this->data);
		$this->data['challan_details']=$this->Transport_facility_model->fees_challan_list();
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
        $this->load->view($this->view_dir.'fees_challan_list',$this->data);
        $this->load->view('footer');
    }

public function challan_type()
	{
		$this->load->view('header',$this->data);
		if(!empty($_POST)){
			$typ_value= $_POST['chln_type'];
			if($typ_value=='student'){
				redirect('Transport_Challan/add_fees_challan');
			}else{
				redirect('Transport_Challan/add_guest_challan');
			}
		}
		$this->load->view($this->view_dir.'challan_type',$this->data);
        $this->load->view('footer');
	}
      public function add_fees_challan()
	{
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==17 || $this->session->userdata("role_id")==47 || $this->session->userdata("role_id")==46){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Transport_facility_model->get_facility_types();
		//$this->data['depositedto_details']=$this->hostel_model->get_depositedto();
		$this->data['academic_details']=$this->hostel_model->get_academic_details();
		
		$this->data['boarding_details']=$this->Transport_model->get_boardingmaster_details();
		$this->data['route_details']=$this->Transport_model->get_route_details();
		
		$this->data['bank_details']= $this->hostel_model->getbanks();
		$this->load->view($this->view_dir.'add_fees_challan_details',$this->data);
        $this->load->view('footer');
	}

    public function get_faci_fee_details()
	{
		$fee_details = array_shift($this->Transport_facility_model->get_faci_fee_details($_POST));
	//	$fee_details = array_shift($this->Transport_facility_model->get_faci_fee_details($_POST));
		echo json_encode(array("fee_details"=>$fee_details));
	}
	
	
     public function index(){
        //$this->load->view('header',$this->data);    
      //  $this->load->view('Transport/report/fees_report.php',$this->data);
       // $this->load->view('footer');
	   redirect('Transport_Challan/fees_challan_list');
     }




     public function add_fees_challan_submit()
	{
		$this->load->model('hostel_model');
		$challan_digits=4;
		if($_POST['fees_date']=='')
			$fdate=date("Y-m-d");
		else
			$fdate=date("Y-m-d", strtotime($_POST['fees_date'])); 
		$check_exits=$this->hostel_model->check_exits($challan_no);
		$existing_record = $this->hostel_model->check_existing_record_challan($_POST['enroll'], $_POST['academic'], $_POST['receipt_number']);
		if ($existing_record) {
			$this->session->set_flashdata('message2', 'Fees Challan already Deposited.');
			redirect(base_url($this->view_dir . 'fees_challan_list'));
			exit;
		}
		//var_dump($_POST);
		//echo $fdate; exit();
		$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"Boarding_point"=>$_POST['Boarding_point'],
		"Route_name"=>$_POST['Route_name'],
		"bank_account_id"=>$_POST['depositto'],"deposit_fees"=>$_POST['deposit'],
		"facility_fees"=>$_POST['facility'],"college_receiptno"=>$_POST['category'],
		"fine_fees"=>$_POST['finefee'],"other_fees"=>$_POST['other'],"Excess_fees"=>$_POST['excess'],
		"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],
		"receipt_no"=>$_POST['receipt_number'],"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"organisation"=>$_POST['org_from'],
		"bank_city"=>$_POST['branch'],"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],
		"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"));
		//print_r($insert_array);exit();
        $last_inserted_id= $this->Transport_facility_model->add_fees_challan_submit($insert_array);
		if($last_inserted_id)
		{
			if($last_inserted_id>9999)
			{
				$challan_digits=strlen($last_inserted_id);
			}
			
			$ayear= substr($_POST['academic'], -2);  //explode("-",$_POST['academic']);
			$challan_no=$ayear.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			$update_array=array("exam_session"=>$challan_no);
			$last_inserted= $this->Transport_facility_model->update_challan_no($last_inserted_id,$update_array);
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}
		else{
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
		}
		
		if($this->session->userdata("role_id")==5){
		redirect(base_url('Transport_Challan/download_challan_pdf/'.$last_inserted_id));
		usleep(6000000);
		redirect(base_url('Transport_Challan/fees_challan_list'));
		
		}else{
		redirect(base_url($this->view_dir.'fees_challan_list'));
		}
	}

// add guest challan 
	public function add_guest_challan()
	{
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->hostel_model->get_facility_types();
		$data1['faci_type'] = 'Transport';
		$this->data['depositedto_details']=$this->hostel_model->get_depositedto($data1);
		$this->data['academic_details']=$this->hostel_model->get_academic_details();
		$this->data['bank_details']= $this->hostel_model->getbanks();
		$this->load->view($this->view_dir.'add_guest_challan_details',$this->data);
        $this->load->view('footer');
	}
	
	
	public function add_guest_challan_submit()
	{
		$challan_digits=4;
		if($_POST['fees_date']=='')
			$fdate=date("Y-m-d");
		else
			$fdate=date("Y-m-d", strtotime($_POST['fees_date'])); 
		error_reporting(E_ALL);
//error_reporting(1);
		//var_dump($_POST);
		//echo $fdate; exit();
		$insert_array=array("guest_name"=>$_POST['guest_name'],"mobile"=>$_POST['mobile'],"academic_year"=>$_POST['academic'],
		"type_id"=>5,"accomodation_charges"=>$_POST['accomodation_charges'],
		"remark"=>$_POST['remark'],
		"bank_account_id"=>$_POST['depositto'],"address"=>$_POST['address'],
		"organisation"=>$_POST['organisation'],
		"facility_fees"=>'',"other_fees"=>$_POST['other'],
		"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],
		"receipt_no"=>$_POST['receipt_number'],"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],
		"bank_city"=>$_POST['branch'],"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],
		"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"));
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->hostel_model->add_fees_challan_submit($insert_array);
		//exit();
		if($last_inserted_id)
		{
			if($last_inserted_id>9999)
			{
				$challan_digits=strlen($last_inserted_id);
			}
			
			$ayear= substr($_POST['academic'], -2);  //explode("-",$_POST['academic']);
			$challan_no=$ayear.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			$update_array=array("exam_session"=>$challan_no);
			$last_inserted_id= $this->hostel_model->update_challan_no($last_inserted_id,$update_array);
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}
		else
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
        
	  redirect(base_url($this->view_dir.'guest_challan_list'));
	}
	
	public function guest_challan_list()
    {
        $this->load->view('header',$this->data);
		$this->data['challan_details']=$this->hostel_model->guest_challan_list();
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
        $this->load->view($this->view_dir.'guest_challan_list',$this->data);
        $this->load->view('footer');
    }	
	public function edit_guest_challan()
	{
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->hostel_model->get_facility_types();
		$this->data['depositedto_details']=$this->hostel_model->depositedto_details();
		$this->data['bank_details']= $this->hostel_model->getbanks();
		$this->data['challan_details']=array_shift($this->hostel_model->guest_challan_list($this->uri->segment(3)));
		//exit();
		$this->load->view($this->view_dir.'edit_guest_challan_details',$this->data);
        $this->load->view('footer');
	}	
      public function edit_challan()
	{
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Transport_facility_model->get_facility_types();
		$this->data['depositedto_details']=$this->Transport_facility_model->depositedto_details();
		$this->data['bank_details']= $this->Transport_facility_model->getbanks();
		$this->data['challan_details']=array_shift($this->Transport_facility_model->fees_challan_list_byid($this->uri->segment(3)));
		
		$this->load->view($this->view_dir.'edit_fees_challan_details',$this->data);
        $this->load->view('footer');
	}



public function edit_fees_challan_submit()
	{
		$this->load->model('hostel_model');
		$date = str_replace('/', '-', $_POST['deposit_date']);
		
		$check_exits=$this->hostel_model->check_exits($challan_no);
		$existing_record = $this->hostel_model->check_existing_facility_fees($_POST['enroll'], $_POST['academic'], $_POST['receipt_number']);
		if ($existing_record) {
			$this->session->set_flashdata('message2', 'Fees Challan already Deposited.');
			redirect(base_url($this->view_dir . 'fees_challan_list'));
			exit;
		}
		if($_POST['challan_status']=='VR')
		{
			$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"college_receiptno"=>$_POST['challan_no'],"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],"receipt_no"=>$_POST['receipt_number'],"fees_date"=>date("Y-m-d", strtotime($date)),"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"));
			//var_dump($insert_array);exit();
			$this->Transport_facility_model->add_into_sf_fees_details($insert_array);
		}
		
		$update_array=array("challan_status"=>$_POST['challan_status'],"deposit_date"=>date("Y-m-d", strtotime($date)),"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));
		
		$challan_status='';
		if($_POST['challan_status']=='VR'){
		$challan_status='Verified';
		$last_online_payment= $this->Transport_facility_model->update_online_payment($_POST['receipt_number'],$_POST['student_id'],$_POST['amt']);
		}else if($_POST['challan_status']=='CL'){
		$challan_status='Cancelled';
		}else{
		$challan_status='Pending';
		}
		$id=$this->uri->segment(3);
        $last_inserted_id= $this->Transport_facility_model->update_challan_no($id,$update_array);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Fees Challan '.$challan_status.' Successfully.');
		else
			$this->session->set_flashdata('message2','Fees Challan Not '.$challan_status.' Successfully.');
        
		redirect(base_url($this->view_dir.'edit_challan/'.$id));
	}


public function download_guest_challan_pdf($fees_id)
	{
		//load mPDF library
        
		//$this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		//echo $hgp_id.','.$stud_prn.','.$stud_org;exit();
		$this->load->library('m_pdf', $param);
		
		if($fees_id!='')
		{
			$std_challan_details=array_shift($this->hostel_model->guest_challan_list($fees_id));
		  //echo json_encode(array("std_gatepass_details"=>$std_gatepass_details));
			$this->data['std_challan_details']= $std_challan_details;
		}

		$html = $this->load->view($this->view_dir.'guest_challan_pdf', $this->data, true);
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

      public function download_challan_pdf($fees_id)
	{
		//load mPDF library
        
		//$this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		//echo $hgp_id.','.$stud_prn.','.$stud_org;exit();
		$this->load->library('m_pdf', $param);
		
		if($fees_id!='')
		{
			$std_challan_details=array_shift($this->hostel_model->fees_challan_list_byid($fees_id));
		  //echo json_encode(array("std_gatepass_details"=>$std_gatepass_details));
			$this->data['std_challan_details']= $std_challan_details;
		}

		$html = $this->load->view($this->view_dir.'facility_challan_pdf', $this->data, true);
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
	
	
	public function challan_list_by_creteria(){
		
		$std_challan_list=$this->Transport_facility_model->fees_challan_list($_POST);
		echo json_encode(array("std_challan_list"=>$std_challan_list));
	}
}
?>