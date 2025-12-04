<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="menu_master";
    var $model_name="menu_model";
    var $model;
    var $view_dir='Menu/';
    
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
			
		}else{
			redirect('home');
		}
    }
    
    public function index()
    {
        global $model;
        $this->load->view('header',$this->data);            
        $this->data['menu_details']= $this->menu_model->get_menu_details();                                
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
        $this->data['menu_details']=$this->menu_model->get_menu_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    /*public function edit()
    {
        $this->load->view('header',$this->data);
        $campus_id=$this->uri->segment(3);
        $this->data['menu_details']=array_shift($this->menu_model->get_menu_details($campus_id));                            
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    */
    
    public function disable()
    {
        $this->load->view('header',$this->data);                
        $campus_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("menu_id"=>$campus_id);
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
        $campus_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("menu_id"=>$campus_id);
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
       // print_r($this->input->post()); die;
        $config=array(
                        array('field'   => 'menu_name',
			'label'   => 'Menu Name',
			'rules'   => 'trim|required'
			),
			array('field'   => 'menu_level',
			'label'   => 'Menu Level',
			'rules'   => 'trim|required|integer'
			),
                        array('field'   => 'menu_parent',
			'label'   => 'Menu Parent',
			'rules'   => 'trim|required|integer'
			),
			array('field'   => 'menu_path',
			'label'   => 'Menu URL',
			'rules'   => 'trim|required'
			),
                        array('field'   => 'menu_seq',
			'label'   => 'Menu Sequence',
			'rules'   => 'trim|required|integer'
			),
                        array('field'   => 'menu_icon',
			'label'   => 'Menu Icon',
			'rules'   => 'trim|required'
			),
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $menu_id=$this->input->post('menu_id');
        
        if($menu_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {                    
                $menu_parent=$this->input->post("menu_parent");    
                $menu_name=$this->input->post("menu_name");    
                $menu_path=$this->input->post("menu_path");    
                $menu_seq=$this->input->post("menu_seq");    
                $menu_icon=$this->input->post("menu_icon");                   
                $insert_array=array("parent"=>$menu_parent,"menu_name"=>$menu_name,"path"=>$menu_path,"seq"=>$menu_seq,"icon"=>$menu_icon,"inserted_by"=>$this->session->userdata("uid"),"inserted_datetime"=>date("Y-m-d H:i:s"));                                                                                
                $this->db->insert("menu_master", $insert_array); 
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
        /*else
        {
            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('header',$this->data);        
                $campus_id=$this->input->post("campus_id");
                $this->data['menu_details']=array_shift($this->menu_model->get_menu_details($campus_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {        
                $campus_id=$this->input->post("campus_id");    
                $campus_code=$this->input->post("campus_code");    
                $campus_name=$this->input->post("campus_name");    
                $campus_city=$this->input->post("campus_city");    
                $campus_state=$this->input->post("campus_state");    
                $campus_address=$this->input->post("campus_address");    
                $campus_pincode=$this->input->post("campus_pincode");                    
                $update_array=array("campus_code"=>$campus_code,"campus_name"=>$campus_name,"campus_city"=>$campus_city,"campus_state"=>$campus_state,"campus_address"=>$campus_address,"campus_pincode"=>$campus_pincode,"inserted_by"=>$this->session->userdata("uid"),"inserted_datetime"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("campus_id"=>$campus_id);
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
        }  */    
    }  
    
    public function search()
    {        
        $para=$this->input->post("title");        
        $menu_details=  $this->menu_model->get_menu_details_search($para);    
		
        echo json_encode(array("menu_details"=>$menu_details));
    } 
    
    public function get_parent_menus()
    {        
        $parent=  $this->input->post('parent');
        $menu_details=  $this->menu_model->get_menu_details('',$parent);                    
        echo json_encode(array("menu_details"=>$menu_details));
    } 
    
}
?>