<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Flash_message extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Flash_message_model";
    var $model;
    var $view_dir='Flash_messages/';
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
    
		   public function flash_view() {
			$this->load->view('header',$this->data);
			$data['flash'] = $this->Flash_message_model->get_all_flash();
			$this->load->view('Flash_messages/flash_message_view', $data);
			$this->load->view('footer');
		}

		public function flash_add() {
			$this->load->view('header',$this->data);
			$this->load->view('Flash_messages/flash_message_add', $data);
			$this->load->view('footer');
		}

		public function flash_edit($id) {
			$this->load->view('header',$this->data);
			$data['flashData'] = $this->Flash_message_model->flash_by_id($id);
			$this->load->view('Flash_messages/flash_message_add', $data);
			$this->load->view('footer');
		}

		public function save_flash() {

			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('message','Message','required');
			$this->form_validation->set_rules('show_from','Show From','required');
			$this->form_validation->set_rules('show_to','Show To','required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			}

			$id = $this->input->post('id');

			$data = [
				'title' => $this->input->post('title'),
				'message' => $this->input->post('message'),
				'type' => $this->input->post('type'),
				'show_from' => $this->input->post('show_from'),
				'show_to' => $this->input->post('show_to')
			];

			if ($id == "") {
				$this->Flash_message_model->insert_flash($data);
				$msg = "Flash Message Added Successfully";
			} else {
				$this->Flash_message_model->update_flash($id, $data);
				$msg = "Flash Message Updated Successfully";
			}

			$this->session->set_flashdata('success',$msg);
			redirect('Flash_message/flash_view');
		}

		public function flash_delete($id){
			if ($this->Flash_message_model->delete_flash($id)) {
				$this->session->set_flashdata('success', "Flash Message Deleted Successfully");
			} else {
				$this->session->set_flashdata('error', "Failed to Delete Flash Message");
			}

			redirect('Flash_message/flash_view');
		}
}
	
?>
