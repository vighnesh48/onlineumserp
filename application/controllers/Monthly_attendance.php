<?php
//error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');
class Monthly_attendance extends CI_Controller 
{
    var $currentModule="Monthly_attendance";
    var $title="";
  
    var $model_name="Monthlyattendance_model";
    
    var $view_dir='Admin/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        $this->load->model('Monthlyattendance_model');
        $this->load->helper("url");		
        $this->load->library('form_validation');
        
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
           $title=$this->master_arr['index'];
       
       
    }
    
    public function index()
    {
      
        $this->load->view('header',$this->data);        
          $now = new DateTime('Asia/Kolkata');
 $date = $now->format('Y-m');
 // exit;
$this->data['attend_date']= $date;
 $this->data['attendance']= $this->Monthlyattendance_model->checkAvailableAttendance($date);                 
        $this->load->view($this->view_dir.'display_monthly_attendance',$this->data);
        $this->load->view('footer');
    }
    
    public function view_monthly_attendance()
    {
        $this->load->view('header',$this->data); 
		 $date = $_POST['attend_date'];
		$this->data['attend_date']= $date;
        $this->data['attendance']= $this->Monthlyattendance_model->checkAvailableAttendance($date);  
//print_r($this->data['attendance']);
//exit;
        $this->load->view($this->view_dir.'display_monthly_attendance',$this->data);
        $this->load->view('footer');
    }
    
   
   public function export_pdf(){
          $this->load->library('m_pdf');
         $date = $_POST['attend_date1'];
        //exit;
        $this->data['attend_date']= $date;
        $this->data['attendance']= $this->Monthlyattendance_model->checkAvailableAttendance($date);  

        $html1 = $this->load->view($this->view_dir.'monthly_attendance_report', $this->data, true);
        $pdfFilePath = "Monthly_attendance".date('M Y',strtotime($date)).".pdf";
        
        //$mpdf->WriteHTML($stylesheet,1);
        //$this->m_pdf->pdf->WriteHTML($stylesheet,1);
$this->m_pdf->pdf=new mPDF('','A4','','',15,15,15,15,10,10);
        $this->m_pdf->pdf->WriteHTML($html1);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");   
    }
    
   
}
?>