<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends CI_Controller 
{

    var $currentModule="";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Reports_model";
    var $model;
    var $view_dir='Reports/';
    
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
     //   echo $_SERVER['REMOTE_ADDR'];
 // var_dump($_SESSION);
// error_reporting(E_ALL);
//ini_set('display_errors', 1);
setlocale(LC_MONETARY, 'en_IN');
if(isset($this->session->userdata['role_id']))
{
   // echo "jugal";
}
//echo $this->session->userdata['role_id'].">>>>>>>>>>>>>>";
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
        $this->load->model('Fees_model');
        
        $menu_name=$this->uri->segment(1);        
      //  $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    
    public function index()
    {
        global $model;
        //$academic_year='2017';
		//changed year for year 2019 
		$academic_year=date('Y');
        $this->load->view('header',$this->data);    
             $this->data['getTotalfee']= $this->Reports_model->getTotalfee($academic_year);
             $this->data['getExemfee']= $this->Reports_model->getExemfee($academic_year);
             $this->data['getFeeReceived']= $this->Reports_model->getFeeReceived($academic_year);
             $this->data['getTotalAdm']= $this->Reports_model->getTotalAdm($academic_year);
             $this->data['cdata']= $this->Reports_model->getchartdata($academic_year);
             $this->data['fees']=$this->Fees_model->get_fees_statistics(array('academic_year'=>$academic_year,'get_by'=>'course'));
             $this->data['cancle']=$this->Fees_model->get_cancle_admission_details($academic_year);
             $this->data['gender']= $this->Reports_model->getGenderwiseTotal($academic_year);
             $this->data['admyear']= $this->Reports_model->getYearwiseTotal($academic_year);
             $this->data['domacile']= $this->Reports_model->getDomacilewiseTotal($academic_year);
     
     
   
     $this->load->view($this->view_dir.'Dashboard',$this->data);
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
	

	
}
?>