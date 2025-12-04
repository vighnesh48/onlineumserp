<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class School extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="schoolmaster";
    var $model_name="school_model";
    var $model;
    var $view_dir='School/';
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
		//echo "1"; die;
		
        $this->load->view('header',$this->data);            
        $this->data['school_details']= $this->school_model->get_school_details();
		//echo "<pre>";print_r($this->data['school_details']); die;
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
        $this->load->view('header',$this->data);  
       // $this->data['products']= $this->school_model->get_proudcts();
		//echo "<pre>";print_r($this->data['products']); die;		
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
    public function view()
    {
        $this->load->view('header',$this->data);        
        $this->data['school_details']= $this->school_model->get_school_details();               
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data); 
        $this->data['products']= $this->school_model->get_proudcts();                 
        $school_id=$this->uri->segment(3);
        $this->data['school_details']=array_shift($this->school_model->get_school_details($school_id));    
		//echo "<pre>";print_r($this->data['productsize_details']); die;
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);                
        $designation_id=$this->uri->segment(3);   
        $update_array=array("is_active"=>"0","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("id"=>$proudct_id);
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
        $designation_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("school_id"=>$school_id);
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
		$secondDB = $this->load->database('umsdb', TRUE);
        $this->load->helper('security');
        $post_array=  $this->input->post();
        //echo "<pre>"; print_r($post_array); die;
        $config=array(
                        array('field'   => 'is_sun',
			'label'   => 'Sun',
			'rules'   => 'trim|required|xss_clean'
			),
			array('field'   => 'school_name',
			'label'   => 'School Name',
			'rules'   => 'trim|required|xss_clean'
			)
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $school_id=$this->input->post('school_id');
        
        if($school_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
                    
                $school_name=$this->input->post("school_name");    
                $is_sun=$this->input->post("is_sun");  
                
                $insert_array=array("is_sun"=>$is_sun,"school_name"=>$school_name,"created_by"=>'1',"created_at"=>date("Y-m-d H:i:s"));                                                                
                $secondDB->insert("schoolmaster", $insert_array); 
                $last_inserted_id=$secondDB->insert_id();
				//echo $secondDB->last_query(); die;                
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
                $id=$this->input->post("school_id");
                $this->data['school_details']=array_shift($this->school_model->get_school_details($school_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {    
				$id=$this->input->post("school_id");
				$school_name=$this->input->post("school_name");    
                $is_sun=$this->input->post("is_sun"); 
                
                $update_array=array("is_sun"=>$is_sun,"school_name"=>$school_name,"updated_by"=>'1',"updated_at"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("id"=>$school_id);
                $secondDB->where($where);                
                if($secondDB->update($this->table_name, $update_array))
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
        $school_details=  $this->school_model->get_school_details($para);                    
        echo json_encode(array("school_details"=>$school_details));
    } 
}
?>