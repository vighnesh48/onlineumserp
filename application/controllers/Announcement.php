<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Announcement extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Announcement_model";
    var $model;
    var $view_dir='Announcement/';
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
    
public function announcement_view() {
		    $this->load->view('header',  $this->data);
			$data['announcements'] = $this->Announcement_model->get_all_announcements();
			$this->load->view('Announcement/announcement_view', $data);
			$this->load->view('footer');
		}

		public function announcement_add() {
            $this->load->view('header',  $this->data);
			$this->load->view('Announcement/announcement_add', $data);
			$this->load->view('footer');
		}

		public function announcement_edit($id) {
			 $this->load->view('header',  $this->data);
			$data['announcement'] = $this->Announcement_model->announcement_by_id($id);
			$this->load->view('Announcement/announcement_add', $data);
			$this->load->view('footer');
		}

		public function save_announcement() {

			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('announcement_date','Date','required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			}

			$id = $this->input->post('announcement_id');

			$data = [
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'announcement_type' => $this->input->post('announcement_type'),
				'announcement_date' => $this->input->post('announcement_date'),
				'announcement_url' => $this->input->post('announcement_url')
			];


			if ($id == "") {
				$this->Announcement_model->insert_announcement($data);
				$msg = "Announcement Added Successfully";
			} else {
				$this->Announcement_model->update_announcement($id, $data);
				$msg = "Announcement Updated Successfully";
			}

			$this->session->set_flashdata('success',$msg);
			redirect('Admin/announcement_view');
		}

		public function announcement_delete($id) {

			if ($this->Announcement_model->delete_announcement($id)) {
			$this->session->set_flashdata('success', "Announcement Deleted Successfully");
			} else {
				$this->session->set_flashdata('error', "Failed to Delete Announcement");
			}
			redirect('Announcement/announcement_view');
		}
	 
	 
	 public function combined_listing()
	{
		$this->load->view('header',  $this->data);
		$data['announcements'] = $this->Announcement_model->get_all_announcements();
		$data['reminders'] = $this->Announcement_model->get_all_reminders();
		$data['blogs'] = $this->Announcement_model->get_all_blogs();
		$data['flash'] = $this->Announcement_model->get_all_flash();

		$this->load->view('Announcement/combined_listing', $data);
		$this->load->view('footer');
	}


}
	
?>
