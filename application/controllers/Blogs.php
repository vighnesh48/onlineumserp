<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Blogs extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Blogs_model";
    var $model;
    var $view_dir='Blogs/';
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
    
		  public function blog_view() {

				$this->load->view('header',  $this->data);  
				$this->data['blogs'] = $this->Blogs_model->get_all_blogs();		
				$this->load->view('Blogs/blogs_view', $this->data); 
				$this->load->view('footer');
			}

			// OPEN ADD BLOG FORM
			public function blog_add() {
				
				$this->load->view('header',  $this->data);
				$this->load->view('Blogs/blogs_add', $this->data); 
				$this->load->view('footer');
			}

			// OPEN EDIT BLOG FORM
			public function blog_edit($id) {

				$this->load->view('header',  $this->data);  
				$this->data['blog'] = $this->Blogs_model->blog_by_id($id);		
				$this->load->view('Blogs/blogs_add', $this->data); 
				$this->load->view('footer');
			}
		 
		   public function blog_delete($id)
			{
				if ($this->Blogs_model->delete_blog($id)) {
					$this->session->set_flashdata('success', "Blog Deleted Successfully");
				} else {
					$this->session->set_flashdata('error', "Failed to Delete Blog");
				}
				redirect('Blogs/blog_view');
			}
		 
		  public function save_blog() {

			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('description','Description','required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			}

			$id = $this->input->post('blog_id');

			$data = [
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'blog_url' => $this->input->post('blog_url')
			];


			if ($id == "") {
				$this->Blogs_model->insert_blog($data);
				$msg = "Blog Added Successfully";
			} else {
				$this->Blogs_model->update_blog($id,$data);
				$msg = "Blog Updated Successfully";
			}

			$this->session->set_flashdata('success',$msg);
			redirect('Blogs/blog_view');
		}


}
	
?>
