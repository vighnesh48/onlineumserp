<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Links extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Links_model";
    var $model;
    var $view_dir='Links/';
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
    
		  public function links_add()
			{
				$this->load->view('header',$this->data);
				$this->load->view('Links/links_add', $this->data);
				$this->load->view('footer');
			}

			public function links_edit($id)
			{
				$this->load->view('header',$this->data);
				$this->data['links'] = $this->Links_model->get_link_by_id($id);
				$this->load->view('Links/links_add', $this->data);
				$this->load->view('footer');
			}

			public function save_links()
			{
				$this->form_validation->set_rules('link_title','Link Title','required');
				$this->form_validation->set_rules('url','Link URL','required|valid_url');
				$this->form_validation->set_rules('description','Description','required');

				if ($this->form_validation->run() == FALSE) {
					$this->session->set_flashdata('error', validation_errors());
					redirect($_SERVER['HTTP_REFERER']);
				}

				$id = $this->input->post('link_id');

				$data = [
					'link_title' => $this->input->post('link_title'),
					'url'        => $this->input->post('url'),
					'description'=> $this->input->post('description'),
					'status'     => 1
				];



				if ($id == "") {
					$this->Links_model->insert_link($data);
					$msg = "Link Added Successfully";
				} else {
					$this->Links_model->update_link($id, $data);
					$msg = "Link Updated Successfully";
				}

				$this->session->set_flashdata('success',$msg);
				redirect('Links/links_view');
			}

			public function links_delete($id)
			{

				$this->Links_model->delete_link($id);
				$this->session->set_flashdata('success',"Link Deleted Successfully (Soft Delete)");
				redirect('Links/links_view');
			}

			public function links_view()
			{
				 $this->load->view('header',$this->data);
				$data['list'] = $this->Links_model->get_all_links();
				$this->load->view('Links/links_view', $data);
				$this->load->view('footer');
			}
			
			 public function Listing_links()
			{
				$rid=$this->session->userdata('role_id');
				$this->load->view('header',  $this->data);  
				$this->data['links'] = $this->Admin_model->get_all_links();		
				$this->load->view('Admin/Listing_links', $this->data);  
			 
				$this->load->view('footer');
			}


}
	
?>
