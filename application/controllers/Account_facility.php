<?php
//ini_set("display_errors", "On");
//error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_facility extends CI_Controller 
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
        $this->load->helper("hostel_helper");		
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
    }

        
        public function hostel_fees_report()
    {

        $this->load->view('header',$this->data); 
		$this->data['exam_session']= $this->Account_model->fetch_stud_curr_year();			
        $this->load->view('Hostel/report/fees_report.php',$this->data);
        $this->load->view('footer');
    }
	
	public function transport_fees_report()
    {
        
     
        $this->load->view('header',$this->data);    
        $this->load->view('Transport/report/fees_report.php',$this->data);
        $this->load->view('footer');
    }
    
	public function get_transport_fees_report()
	{   
           // error_reporting(E_ALL);
//ini_set('display_errors', 1);
         $this->data['academic_year']=$_POST['academic_year'];
         $this->data['campus']=$_POST['campus'];
         $this->data['institute_name']=$_POST['institute_name'];
         $this->data['report_type']=$_POST['report_type'];
           
        if($_POST['report_type']=="1")
        {
             $this->data['fees']=$this->Account_model->get_fees_collection_transport($this->data);
           
             if($_POST['act']=="view"){
                 $this->load->view('Transport/report/fees_details',$this->data);
             }
             else{
                 $this->load->view('Transport/report/excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }

        }
        else if($_POST['report_type']=="2") 
        {
            $this->data['get_by']="";
            $this->data['fees']=$this->Account_model->get_studentwise_transport_fees($this->data);
            if($_POST['act']=="view"){
                 $this->load->view('Transport/report/fees_details',$this->data);
             }
             else{
                $this->load->view('Transport/report/excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }
        }
         else if($_POST['report_type']=="3")
        {
             $this->data['get_by']="";
             $this->data['fees']=$this->Account_model->get_institute_transportfees_statistics($this->data);
              if($_POST['act']=="view"){
                   $this->load->view('Transport/report/fees_details',$this->data);
             }
             else{
                 $this->load->view('Transport/report/excel_details',$this->data);
                  $this->session->set_flashdata('excelmsg', 'download');
             }
        }
        else if($_POST['report_type']=="4")
        { 
             $this->data['get_by']="";
             $this->data['fees']=$this->Account_model->get_studentwise_Transport_fees($this->data);
            if($_POST['act']=="view"){
                 $this->load->view('Transport/report/fees_details',$this->data);
             }
             else{
                $this->load->view('Transport/report/excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }
        }
        else if($_POST['report_type']=="5")
        { 
            
             $this->data['get_by']="";
             $this->data['fees']=$this->Account_model->get_Transport_statistics($this->data);
            if($_POST['act']=="view"){
                 $this->load->view('Transport/report/fees_details',$this->data);
             }
             else{
                $this->load->view('Transport/report/excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }
        }
        
    }
    
	public function get_hostel_fees_report()
    {   
		$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,L';
		$this->load->library('m_pdf', $param);

         $this->data['academic_year']=$_POST['academic_year'];
         $this->data['campus']=$_POST['campus'];
         $this->data['institute_name']=$_POST['institute_name'];
         $this->data['report_type']=$_POST['report_type'];
           
        if($_POST['report_type']=="1")
        {
             $this->data['fees']=$this->Account_model->get_fees_collection_hostel($this->data);
			 // error_reporting(E_ALL);
		//ini_set('display_errors', 1);
          // var_dump($_POST);//exit();
             if($_POST['act']=="view"){
                 $this->load->view('Hostel/report/fees_details',$this->data);
             }
             else if($_POST['act']=="pdf"){
				 //echo 'hhhhhh';
                 $html = $this->load->view('Hostel/report/pdf_details',$this->data, true);
				 // echo $html;//exit();
				 $this->m_pdf->pdf->WriteHTML($html);
				 $pdfFilePath = 'Hostel Fees Collection-'.$_POST['academic_year'].'.pdf';
				$this->m_pdf->pdf->Output($pdfFilePath, "D");
				$this->session->set_flashdata('pdfmsg', 'download');
             }
			 else
			 {
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
			 else if($_POST['act']=="pdf"){
				 //echo 'hhhhhh';
                 $html = $this->load->view('Hostel/report/pdf_details',$this->data, true);
				 // echo $html;//exit();
				 $this->m_pdf->pdf->WriteHTML($html);
				 $pdfFilePath = 'Hostel Fees  StudentWise-'.$_POST['academic_year'].'.pdf';
				$this->m_pdf->pdf->Output($pdfFilePath, "D");
				$this->session->set_flashdata('pdfmsg', 'download');
             }
             else{
                $this->load->view('Hostel/report/excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }
        }
         else if($_POST['report_type']=="3")
        {
             $this->data['get_by']="";
             $this->data['fees']=$this->Account_model->get_institute_fees_statistics($this->data);
              if($_POST['act']=="view"){
                   $this->load->view('Hostel/report/fees_details',$this->data);
             }
			 else if($_POST['act']=="pdf"){
				 //echo 'hhhhhh';
                 $html = $this->load->view('Hostel/report/pdf_details',$this->data, true);
				 // echo $html;//exit();
				 $this->m_pdf->pdf->WriteHTML($html);
				 $pdfFilePath = 'Hostel Inst Statistics Fees-'.$_POST['academic_year'].'.pdf';
				$this->m_pdf->pdf->Output($pdfFilePath, "D");
				$this->session->set_flashdata('pdfmsg', 'download');
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
			 else if($_POST['act']=="pdf"){
				 //echo 'hhhhhh';
                 $html = $this->load->view('Hostel/report/pdf_details',$this->data, true);
				 // echo $html;//exit();
				 $this->m_pdf->pdf->WriteHTML($html);
				 $pdfFilePath = 'Hostel Outstanding Fees-'.$_POST['academic_year'].'.pdf';
				$this->m_pdf->pdf->Output($pdfFilePath, "D");
				$this->session->set_flashdata('pdfmsg', 'download');
             }
             else{
                $this->load->view('Hostel/report/excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }
        }
        else if($_POST['report_type']=="5")
        { 
            
             $this->data['get_by']="";
             $this->data['fees']=$this->Account_model->get_hostel_statistics($this->data);
            if($_POST['act']=="view"){
                 $this->load->view('Hostel/report/fees_details',$this->data);
             }
			 else if($_POST['act']=="pdf"){
				 //echo 'hhhhhh';
                 $html = $this->load->view('Hostel/report/pdf_details',$this->data, true);
				 // echo $html;//exit();
				 $this->m_pdf->pdf->WriteHTML($html);
				 $pdfFilePath = 'Hostel Statistics Fees-'.$_POST['academic_year'].'.pdf';
				$this->m_pdf->pdf->Output($pdfFilePath, "D");
				$this->session->set_flashdata('pdfmsg', 'download');
             }
             else{
                $this->load->view('Hostel/report/excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }
        }
		else if($_POST['report_type']=="6")
        {
             $this->data['fees']=$this->Account_model->get_refund_amount_paid_hostel($this->data);
           
             if($_POST['act']=="view"){
                 $this->load->view('Hostel/report/fees_details',$this->data);
             }
			 else if($_POST['act']=="pdf"){
				 //echo 'hhhhhh';
                 $html = $this->load->view('Hostel/report/pdf_details',$this->data, true);
				 // echo $html;//exit();
				 $this->m_pdf->pdf->WriteHTML($html);
				 $pdfFilePath = 'Hostel Fees Refund Details-'.$_POST['academic_year'].'.pdf';
				$this->m_pdf->pdf->Output($pdfFilePath, "D");
				$this->session->set_flashdata('pdfmsg', 'download');
             }
             else{
                 $this->load->view('Hostel/report/excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }

        }
        
    }
    
}
?>