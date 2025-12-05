<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Faqs extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Faqs_model";
    var $model;
    var $view_dir='Faqs/';
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
    
		    public function faq_view()
		{
			$this->load->view('header',$this->data);
			$data['faq_list'] = $this->Faqs_model->get_all_faqs();
			$this->load->view('Faqs/faq_view', $data);
			$this->load->view('footer');
		}

			public function faq_add()
			{

				 $this->load->view('header',$this->data);
				 $this->load->view($this->view_dir.'faq_add',$this->data);
				 $this->load->view('footer');
			}

			public function faq_edit($id)
			{
				$this->load->view('header',$this->data);
				$this->data['faq'] = $this->Faqs_model->get_faq_by_id($id);
				$this->load->view('Faqs/faq_add', $this->data);
				$this->load->view('footer');
			}

		public function save_faq()
		{
			$this->form_validation->set_rules('question','Question','required');
			$this->form_validation->set_rules('answer','Answer','required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			}

			$id = $this->input->post('faq_id');

			$data = [
				'question' => $this->input->post('question'),
				'answer' => $this->input->post('answer'),
				'category' => $this->input->post('category'),
				'order_no' => $this->input->post('order_no'),
				'status' => $this->input->post('status')
			];


			if ($id == "") {
				$this->Faqs_model->insert_faq($data);
				$msg = "FAQ Added Successfully";
			} else {
				$this->Faqs_model->update_faq($id, $data);
				$msg = "FAQ Updated Successfully";
			}

			$this->session->set_flashdata('success', $msg);
			redirect('Faqs/faq_view');
		}
		  
		   public function faq_delete($id)
		{
			if ($this->Faqs_model->delete_faq($id)) {
				$this->session->set_flashdata('success', "FAQ Deleted Successfully");
			} else {
				$this->session->set_flashdata('error', "Failed to Delete FAQ");
			}

			redirect('Faqs/faq_view');
		}


		 public function Listing_faqs()
			{
				$rid=$this->session->userdata('role_id');
				$this->load->view('header',  $this->data);  
				$this->data['faqs'] = $this->Admin_model->get_all_faqs();		
				$this->load->view('Faqs/Listing_faqs', $this->data);  
			 
				$this->load->view('footer');
			}

}
	
?>
