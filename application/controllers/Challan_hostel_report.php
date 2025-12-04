<?php
ini_set("display_errors", "On");
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Challan_hostel_report extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Challan_hostel_report_model";
     var $model_name1="Challan_hostel_report_model";
    var $model;
    var $view_dir='Hostel/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
  //  error_reporting(E_ALL);
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
        $this->load->model($model_name);
		$this->load->model('Challan_model');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    
    public function index()
    {
        $this->load->view('header',$this->data);
		$this->data['challan_details']=$this->Challan_model->fees_challan_list();
        $this->load->view($this->view_dir.'fees_challan_list',$this->data);
        $this->load->view('footer');
    }  

	public function challan_list_reportview()
	{
		//$std_challan_list=$this->Challan_hostel_report_model->fees_challan_list($_POST);
		/*print_r($std_challan_list);
		die;*/
		//$std_challan_list=$std_challan_list;
		$this->data['challan_details']=$this->Challan_hostel_report_model->fees_challan_list($_POST);
		//var_dump($this->data['challan_details']);
		//exit();
		$this->load->view($this->view_dir.'ajax_challan_details',$this->data);
	}

	public function challan_list_reportview_daily_report()
	{
		//$std_challan_list=$this->Challan_hostel_report_model->fees_challan_list($_POST);
		/*print_r($std_challan_list);
		die;*/
		//$std_challan_list=$std_challan_list;
		$this->data['challan_details']=$this->Challan_hostel_report_model->fees_challan_list_daily($_POST);
		//var_dump($this->data['challan_details']);
		//exit();
		echo $this->load->view($this->view_dir.'ajax_challan_details',$this->data);
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
			$std_challan_details=$this->Challan_model->fees_challan_list_byid($fees_id);
		  //echo json_encode(array("std_gatepass_details"=>$std_gatepass_details));
			$this->data['std_challan_details']= $std_challan_details;
		}
//$this->load->view($this->view_dir.'facility_challan_pdf', $this->data);

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
	
	public function getchallanlist()
	{
		$this->load->view('header',$this->data);
		$this->data['receipt_typ']=$this->Challan_hostel_report_model->challan_rec_list();
		
		//$this->data['challan_details']=$this->Challan_model->fees_challan_list();
        $this->load->view($this->view_dir.'challan_details_list',$this->data);

        $this->load->view('footer');

	}
	//daily challan detailslist
	public function daily_getchallanlist()
	{
		$this->load->view('header',$this->data);
		$this->data['receipt_typ']=$this->Challan_hostel_report_model->challan_rec_list();
		
		//$this->data['challan_details']=$this->Challan_model->fees_challan_list();
        $this->load->view($this->view_dir.'daily_challan_details_list',$this->data);

        $this->load->view('footer');

	}

	public function getchallan_list($d)
	{		
		$this->data['challan_details']=$this->Challan_hostel_report_model->fees_challan_list($_POST);
	}
	//pdf for today mode
	public function download_modefor_today_pdf()
	{
		ini_set('memory_limit', '-1');
		$this->load->library('M_pdf');

		$this->data['challan_details_mode']=$this->Challan_hostel_report_model->fees_challan_list_today($_POST);
		$this->data['challan_details']=$this->Challan_hostel_report_model->fees_challan_list_pdf($_POST);
	
 		$mpdf=new mPDF('utf-8','A4', 0, '', 10, 10, 5, 5, 5, 5);
       	$html=$this->load->view($this->view_dir.'ajax_challan_formode_details_pdf',$this->data,true);
       	
       	$pdfFilePath ="Payment_Report".time()."-download.pdf";
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath, "D");

		
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////	

	///pdf for daily as per search

	public function download_modefor_today_pdff()
	{
		
		$this->load->library('M_pdf');

		$this->data['challan_details_mode']=$this->Challan_hostel_report_model->fees_challan_list_today($_POST);
		$this->data['challan_details']=$this->Challan_hostel_report_model->fees_challan_list_pdf($_POST);
	
 		$mpdf=new mPDF('utf-8','A4', 0, '', 20, 20, 10, 10, 9, 9, 'L');
       	$html=$this->load->view($this->view_dir.'ajax_challan_formode_details',$this->data,true);
       	
       	$pdfFilePath ="Payment_Report".time()."-download.pdf";
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath, "D");	
	}//end of file
}