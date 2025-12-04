<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once(APPPATH.'third_party/mpdf/mpdf.php');
class ECR extends CI_Controller{

	var $currentModule = "";   
	var $title = "";   
	var $table_name = "unittest_master";    
	var $model_name = "Examination_model";   
	var $model;  
	var $view_dir = 'Ecr/';
	public function __construct(){        
		global $menudata;      
		parent::__construct();       
		$this->load->helper("url");     
		$this->load->library('form_validation');        
		if($this->uri->segment(2) != "" && $this->uri->segment(2) != "submit" && !in_array($this->uri->segment(2), $this->skipActions))
		$title = $this->uri->segment(2); //Second segment of uri for action,In case of edit,view,add etc.       
		else
		$title = $this->master_arr['index'];
		$this->currentModule = $this->uri->segment(1);    
		$this->data['currentModule'] = $this->currentModule;       
		$this->data['model_name'] = $this->model_name;             
		$this->load->library('form_validation');       
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
       
		$model = $this->load->model($this->model_name);
		
		$this->load->model('Online_feemodel');
		$this->load->model('Payment_model');
		$this->load->model('Results_model');
		$menu_name = $this->uri->segment(1);
        
		$this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
		$this->load->library('Awssdk');
        
	}
    
	function index(){

        $this->load->view('header',$this->data);
		if(!empty($_POST)){
			$this->data['rows'] = $_POST['row'];
			$this->data['columns'] = $_POST['column'];
		}
        $this->load->view($this->view_dir.'matrix',$this->data);
        $this->load->view('footer',$this->data);
        //ob_end_clean();
	}	
	
	
	
}
?>