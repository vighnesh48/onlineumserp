<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Employee_category extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="employee_category";
    var $model_name="employee_category_model";
    var $model;
    var $view_dir='Employee_category/';
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
    
    public function index()
    {
        $this->load->view('header',$this->data);    
        $this->data['category_details']= $this->employee_category_model->get_Category_details();                                        
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
        $this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
    public function view()
    {
        $this->load->view('header',$this->data);        
        $this->data['category_details']=$this->employee_category_model->get_Category_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);                
        $caste_id=$this->uri->segment(3);
        $this->data['category_details']=array_shift($this->employee_category_model->get_Category_details($caste_id));
		//print_r($this->data);
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);               
        $emp_cat_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("emp_cat_id"=>$emp_cat_id);
        $this->db->where($where);
        
        if($this->db->update($this->table_name, $update_array))
        {
            redirect(base_url($this->view_dir."view?error=0"));
        }
        else
        {
            redirect(base_url($this->view_dir."view?error=1"));
        }  
        $this->load->view('footer');
    }
    
    public function enable()
    {
        $this->load->view('header',$this->data);              
        $emp_cat_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("emp_cat_id"=>$emp_cat_id);
        $this->db->where($where);
        
        if($this->db->update($this->table_name, $update_array))
        {
            redirect(base_url($this->view_dir."view?error=0"));
        }
        else
        {
            redirect(base_url($this->view_dir."view?error=1"));
        }  
        $this->load->view('footer');
    }
    
    public function submit()
    {       
        $this->load->helper('security');
        $post_array=  $this->input->post();
        //echo "<pre>"; print_r($post_array); die;
        $config=array(
                        array('field'   => 'emp_cat_name',
			'label'   => 'Organization Name',
			'rules'   => 'trim|required|xss_clean'
			)
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $emp_cat_id=$this->input->post('emp_cat_id');
        
        if($emp_cat_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
                $emp_cat_id=$this->input->post("emp_cat_id");    
                $emp_cat_name=$this->input->post("emp_cat_name");   
                             
                $insert_array=array("emp_cat_name"=>$emp_cat_name,"inserted_by"=>$this->session->userdata("uid"),"inserted_date"=>date("Y-m-d H:i:s"));                                                                
                $this->db->insert("employee_category", $insert_array); 
                $last_inserted_id=$this->db->insert_id();                
                if($last_inserted_id)
                {
                    redirect(base_url($this->view_dir."view?error=0"));
                }
                else
                {
                    redirect(base_url($this->view_dir.'view?error=1'));
                }
            }
        }
        else
        {
            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('header',$this->data);                
                $caste_id=$this->input->post("caste_id");
                $this->data['category_details']=array_shift($this->employee_category_model->get_Category_details($caste_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {    
                $emp_cat_id=$this->input->post("emp_cat_id");    
                $emp_cat_name=$this->input->post("emp_cat_name");   
                
                $update_array=array("emp_cat_name"=>$emp_cat_name,"updated_by"=>$this->session->userdata("uid"),"updated_date"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("emp_cat_id"=>$emp_cat_id);
                $this->db->where($where); 
               	
                if($this->db->update($this->table_name, $update_array))
                {  
 		
                    redirect(base_url($this->view_dir."view?error=0"));
                }
                else
                {  
                    redirect(base_url($this->view_dir."view?error=1"));
                }
            }
        }      
    }  
    
    public function search()
    {        
        $para=$this->input->post("title");
        $caste_details=  $this->caste_model->get_caste_details($para);                    
        echo json_encode(array("caste_details"=>$caste_details));
    } 
}
?>