<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reminder extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Reminder_model";
    var $model;
    var $view_dir='Reminders/';
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
    
		 public function reminder_view() {
			$this->load->view('header',  $this->data);  
			$this->data['reminders'] = $this->Reminder_model->get_all_reminders();
			$this->load->view('Reminders/reminder_view', $this->data);
			$this->load->view('footer');
		}

		public function reminder_add() {
			$this->load->view('header',  $this->data);  
			$this->load->view('Reminders/reminder_add', $data);
			$this->load->view('footer');
		}

		public function reminder_edit($id) {
			$this->load->view('header',  $this->data);
			$this->data['reminder'] = $this->Reminder_model->reminder_by_id($id);
			$this->load->view('Reminders/reminder_add', $this->data);
			$this->load->view('footer');
		}

		public function save_reminder() {

			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('reminder_date','Reminder Date','required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			}

			$id = $this->input->post('reminder_id');

			$data = [
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'reminder_date' => $this->input->post('reminder_date'),
				'reminder_time' => $this->input->post('reminder_time')
			];


			if ($id == "") {
				$this->Reminder_model->insert_reminder($data);
				$msg = "Reminder Added Successfully";
			} else {
				$this->Reminder_model->update_reminder($id, $data);
				$msg = "Reminder Updated Successfully";
			}

			$this->session->set_flashdata('success',$msg);
			redirect('Reminder/reminder_view');
		}

		public function reminder_delete($id) {
			
			if ($this->Reminder_model->delete_reminder($id)) {
					$this->session->set_flashdata('success', "Reminder Deleted Successfully");
				} else {
					$this->session->set_flashdata('error', "Failed to Delete Reminder");
				}
				redirect('Reminder/reminder_view');
		}


}
	
?>
