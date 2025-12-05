<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notification extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Notification_model";
    var $model;
    var $view_dir='Notifications/';
    var $data=array();
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
    
		  public function notification_view(){
		 $this->load->view('header',$this->data);
		 $this->data['notification_list']=$this->Notification_model->fetch_notification_data();
		 $this->load->view($this->view_dir.'notification_view',$this->data);
		 $this->load->view('footer');
	  }
	   public function notification_add(){
		 $this->load->view('header',$this->data);
		 $this->data['stream_details']=$this->Notification_model->get_streams_yearwise();
		 $this->load->view($this->view_dir.'notification_add',$this->data);
		 $this->load->view('footer');
	  }

	   public function notification_edit($id){
		 $this->load->view('header',$this->data);
		 $this->data['notification'] = $this->db->get_where('notification_master',['id'=>$id])->row();
		  $this->data['stream_details']=$this->Notification_model->get_streams_yearwise();
		 $this->load->view($this->view_dir.'notification_add',$this->data);
		 $this->load->view('footer');
	  }
	  
	public function save_notification()
	{

		$this->form_validation->set_rules('subject','Subject','required');
		$this->form_validation->set_rules('description','Description','required');
		//$this->form_validation->set_rules('applicable_course','Applicable Course','required');
		//$this->form_validation->set_rules('semester','Semester','required|numeric');
		$this->form_validation->set_rules('from_date','From Date','required');
		$this->form_validation->set_rules('to_date','To Date','required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$id = $this->input->post('notification_id');

		$data = [
			'subject' => $this->input->post('subject'),
			'description' => $this->input->post('description'),
			'notification_url' => $this->input->post('notification_url'),
			'applicable_course' => $this->input->post('applicable_course'),
			'semester' => $this->input->post('semester'),
			'from_date' => $this->input->post('from_date'),
			'to_date' => $this->input->post('to_date'),
			'status' => 1
		];

		if ($id == "") {
			$data['created_by'] = $this->session->userdata('uid');
			$this->Notification_model->insert_notification($data);
			$this->session->set_flashdata('success', "Notification Created Successfully");
		} else {
			$this->Notification_model->update_notification($id, $data);
			$this->session->set_flashdata('success', "Notification Updated Successfully");
		}

		redirect('Notification/notification_view');
	}


}
	
?>
