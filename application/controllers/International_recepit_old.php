<?php
ini_set("display_errors", "On");
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');

class International_recepit extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="International_recepit_model";
     var $model_name1="Challan_model";
    var $model;
    var $view_dir='International_recepit/';
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
        //$this->load->model($model_name);
		 $this->load->model('International_recepit_model');
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
    public function add_recepit()
	{
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		$this->data['getcountry']= $this->International_recepit_model->Get_country();
		$this->data['getcourse']= $this->International_recepit_model->streams_yearwise();
		$this->load->view($this->view_dir.'add_recepit',$this->data);
        $this->load->view('footer');
	}
	
	 public function add_fees_challan()
	{
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		$this->load->view($this->view_dir.'add_fees_challan_details_new',$this->data);
        $this->load->view('footer');
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

}