<?php
ini_set("display_errors", "On");
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
define("MODEL_NM","designation_model");
class Department_designation_reln extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="department_designation_reln";
    var $model_name="department_designation_reln_model";
    var $model;
    var $view_dir='Department_designation_reln/';
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
        $this->data['mapping_details']= $this->department_designation_reln_model->get_mapping_details();
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
        $this->load->view('header',$this->data);    
        $this->data['department_details']= $this->department_designation_reln_model->get_department_details();                                                        
        $this->data['designation_details']= $this->department_designation_reln_model->get_designation_details();                                                        
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
    public function view()
    {
        $this->load->view('header',$this->data);            
        $this->data['mapping_details']= $this->department_designation_reln_model->get_mapping_details();                                                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);                
        $ddr_id=$this->uri->segment(3);
        $this->data['mapping_details']= array_shift($this->department_designation_reln_model->get_mapping_details($ddr_id));                           
        $this->data['department_details']= $this->department_designation_reln_model->get_department_details();                                                        
        $this->data['designation_details']= $this->department_designation_reln_model->get_designation_details();                                                        
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);                
        $ddr_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("ddr_id"=>$ddr_id);
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
        $ddr_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("ddr_id"=>$ddr_id);
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
                        array('field'   => 'department_id',
			'label'   => 'Department',
			'rules'   => 'trim|required|integer|xss_clean'
			),
			array('field'   => 'designation_id',
			'label'   => 'Designation',
			'rules'   => 'trim|required|integer|xss_clean'
			)
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $ddr_id=$this->input->post('ddr_id');
        
        if($ddr_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
                $designation_id=$this->input->post("designation_id");    
                $department_id=$this->input->post("department_id");   
                
                $insert_array=array("department_id"=>$department_id,"designation_id"=>$designation_id,"inserted_by"=>$this->session->userdata("uid"),"inserted_datetime"=>date("Y-m-d H:i:s"));                                                                
                $this->db->insert("department_designation_reln", $insert_array); 
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
                $designation_id=$this->input->post("designation_id");
                $this->data['designation_details']=array_shift($this->designation_model->get_designation_details($designation_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {        
                $designation_id=$this->input->post("designation_id");    
                $department_id=$this->input->post("department_id"); 
                
                
                $update_array=array("designation_id"=>$designation_id,"department_id"=>$department_id,"updated_by"=>$this->session->userdata("uid"),"updated_datetime"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("ddr_id"=>$ddr_id);
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
        $ddr_id=$this->input->post("title");
        //$designation_details=  $this->designation_model->get_designation_details($para);                    
        $designation_details= $this->department_designation_reln_model->get_mapping_details($ddr_id);                                                
        echo json_encode(array("mapping_details"=>$designation_details));
    } 
}
?>