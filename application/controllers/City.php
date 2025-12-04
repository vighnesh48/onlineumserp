<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class City extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="city_master";
    var $model_name="city_model";
    var $model;
    var $view_dir='City/';
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
        $this->data['city_details']= $this->city_model->get_city_details();                                        
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
        $this->load->view('header',$this->data); 
        $this->data['state_details']=$this->city_model->get_state_details();                
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
    public function view()
    {
        $this->load->view('header',$this->data);                
        $this->data['city_details']=$this->city_model->get_city_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);                
        $city_id=$this->uri->segment(3);
        $this->data['state_details']=$this->city_model->get_state_details();   
        $this->data['city_details']=array_shift($this->city_model->get_city_details($city_id));                            
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);                
        $city_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("city_id"=>$city_id);
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
        $city_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("city_id"=>$city_id);
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
       // echo "<pre>"; print_r($post_array); die;
        $config=array(                        
            
            array('field'   => 'state_id',
            'label'   => 'State name',
            'rules'   => 'trim|required|integer|xss_clean'
            ),
            array('field'   => 'city_name',
            'label'   => 'City name',
            'rules'   => 'trim|required|xss_clean'
            )
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $city_id=$this->input->post('city_id');
        
        if($city_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {                 
                $city_name=$this->input->post("city_name");   
                $state_id=$this->input->post("state_id");
                
                $insert_array=array("state_id"=>$state_id,"city_name"=>$city_name,"inserted_by"=>$this->session->userdata("uid"),"inserted_datetime"=>date("Y-m-d H:i:s"));                                                                
                $this->db->insert("city_master", $insert_array);                 
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
                $city_id=$this->input->post("city_id");
                $this->data['city_details']=array_shift($this->city_model->get_city_details($city_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {        
                $city_id=$this->input->post("city_id");       
                $city_name=$this->input->post("city_name");  
                $state_id=$this->input->post("state_id");
                
                $update_array=array("state_id"=>$state_id,"city_name"=>$city_name,"updated_by"=>$this->session->userdata("uid"),"updated_datetime"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("city_id"=>$city_id);
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
        $city_details=  $this->city_model->get_city_details($para);                    
        echo json_encode(array("city_details"=>$city_details));
    } 
}
?>