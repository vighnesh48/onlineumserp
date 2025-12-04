<?php
//ini_set("display_errors", "On");
//error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Challan_receipt extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Challan_receipt_model";
     var $model_name1="Challan_receipt_model";
    var $model;
    var $view_dir='Challan/';
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
   
	
    

	public function receipt_list($d)
	{
		//error_reporting(E_ALL);
		$this->load->view('header',$this->data);
			$this->data['receipt_typ']=$this->Challan_receipt_model->challan_rec_list();
        $this->load->view($this->view_dir.'chalan_receipt',$this->data);
        $this->load->view('footer');

	}
	public function get_receipt_list(){
		$arr['pst']=$_REQUEST['pst'];
		$arr['styp']=$_REQUEST['styp'];
		$arr['sdt']=$_REQUEST['sdt'];
		$arr['dfrm']=$_REQUEST['dfrm'];
		$arr['dto']=$_REQUEST['dto'];
$this->data['rec_list']=$this->Challan_receipt_model->get_recpt_list($arr);
$this->load->view($this->view_dir.'ajax_challen_receipt',$this->data);
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////	
}