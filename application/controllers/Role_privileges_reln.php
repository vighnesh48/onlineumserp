<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Role_privileges_reln extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="role_privileges_reln";
    var $model_name="role_privileges_reln_model";
    var $model;
    var $view_dir='Role_privileges_reln/';
    
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
		if($this->session->userdata("role_id")==6){
			//echo 1;exit;
		}else{
			redirect('home');
		}
    }
    
    public function index() 
    {
        $this->load->view('header',$this->data);                            
        $this->data['mapping_details']= $this->role_privileges_reln_model->get_mapping_details();                                        
        $this->data['roles_details']= $this->role_privileges_reln_model->get_roles_details();                                                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
        $this->load->view('header',$this->data);                
        $this->data['menu_details']= $this->role_privileges_reln_model->get_menu_details();                                        
        $this->data['roles_details']= $this->role_privileges_reln_model->get_roles_details();   
        $this->data['menuwise_privileges_details']= $this->role_privileges_reln_model->get_menuwise_privileges();   
        //echo "<pre>";print_r($this->data['menuwise_privileges_details']); die;
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
    public function view()
    {
        $this->load->view('header',$this->data);                            
        $this->data['mapping_details']= $this->role_privileges_reln_model->get_mapping_details();                                        
        $this->data['roles_details']= $this->role_privileges_reln_model->get_roles_details();                                                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    public function submit()
    {  
        $post_array=$this->input->post();
        $roles_id=isset($post_array['roles_id']) && $post_array['roles_id']!=""?$post_array['roles_id']:""; 
        
        if((isset($post_array['action']))&&($post_array['action']=="add"))
        {
            $i=0;
            $insert_array=array();
            
            foreach ($post_array['prev'] as $key1=>$array)
            {
                
                for($j=0;$j<count($array);$j++)
                {
                    $insert_array[$i]['roles_id']=$roles_id;
                    $insert_array[$i]['menu_id']=$key1;
                    $insert_array[$i]['privileges_id']=$array[$j];
                    $insert_array[$i]["inserted_by"]=  $this->session->userdata('uid');            
                    $insert_array[$i]["inserted_datetime"]=date("Y-m-d H:i:s");
                    $i++;
                }
            }
            $data=array("status"=>'N');
            $this->db->where('roles_id', $post_array['roles_id']);
            $this->db->update("role_menu_reln",$data);
            $cnt= $this->db->insert_batch("role_menu_reln", $insert_array);
            if($cnt>0)
            {
                redirect(base_url(strtolower($this->view_dir)."view?error=0"));
            }
            else
            {
                redirect(base_url(strtolower($this->view_dir)."view?error=1"));
            }
        }
        elseif((isset($post_array['action']))&&($post_array['action']=="edit"))
        {
            //echo "<pre>";
            
            $i=0;
            $insert_array=array();
            
            foreach ($post_array['prev'] as $key1=>$array)
            {
                
                for($j=0;$j<count($array);$j++)
                {
                    $insert_array[$i]['roles_id']=$roles_id;
                    $insert_array[$i]['menu_id']=$key1;
                    $insert_array[$i]['privileges_id']=$array[$j];
                    $insert_array[$i]["inserted_by"]=  $this->session->userdata('uid');            
                    $insert_array[$i]["inserted_datetime"]=date("Y-m-d H:i:s");
                    $i++;
                }
            }
			//echo "<pre>";
			//print_r($insert_array);exit;
            $data=array("status"=>'N');
            $this->db->where('roles_id', $post_array['roles_id']);
            $this->db->update("role_menu_reln",$data);
            $cnt= $this->db->insert_batch("role_menu_reln", $insert_array);
            if($cnt>0)
            {
                redirect(base_url(strtolower($this->view_dir)."view?error=0"));
            }
            else
            {
                redirect(base_url(strtolower($this->view_dir)."view?error=1"));
            }
            print_r($post_array); die;
        }
    }
    
     public function edit()
    {
        $this->load->view('header',$this->data);                
        $roles_id=$this->uri->segment(3);
        $this->data['menu_details']= $this->role_privileges_reln_model->get_menu_details();                                        
        $this->data['roles_details']= $this->role_privileges_reln_model->get_roles_details();   
        $this->data['menuwise_privileges_details']= $this->role_privileges_reln_model->get_menuwise_privileges();  
        $this->data['access_details']= $this->role_privileges_reln_model->get_access_details($roles_id);        
        
        $array1=array();
        $selected_menus=array();
        $array=$this->data['access_details'];
        for($i=0;$i<count($array);$i++)
        {
            $array1[$array[$i]['menu_id']]['privileges_id'][]=$array[$i]['privileges_id'];
            $selected_menus[]=$array[$i]['menu_id'];
        }
                
        $this->data['access_details']=$array1;
        $this->data['selected_menus']=$selected_menus;
        $this->data['roles_id']=$roles_id;
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }
    
    public function search()
    {           
        $para=$this->input->post("title");        
        $mapping_details= $this->role_privileges_reln_model->get_mapping_details($para);         
        echo json_encode(array("mapping_details"=>$mapping_details));
    }
    
    
    
}
?>