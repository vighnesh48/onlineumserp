<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Placement extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="placement";
    var $model_name="placement_model";
    var $model;
    var $view_dir='Placement/';
    
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
        global $model;
        $this->load->view('header',$this->data);     
        $this->data['placement_details']= $this->placement_model->get_placement_details(); 

        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
        $this->data['company_details']= $this->placement_model->get_company_details();  
        $this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
    public function view()
    {
        $this->load->view('header',$this->data);        
        $this->data['placement_details']=$this->placement_model->get_placement_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
       

        $this->load->view('header',$this->data);                
        $placement_id=$this->uri->segment(3);
        $this->data['placement_details']=($this->placement_model->get_placement_details($placement_id));     
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    

    function alpha_dash_space($str)
    {
        return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;

    } 
    
    public function submit()
    {       

        $this->load->helper('security');
        $config=array(
            array('field'   => 'name',
            'label'   => 'Student Name',
            'rules'   => 'trim|required'
            ),
            array('field'   => 'stream',
            'label'   => 'Stream Name',
            'rules'   => 'trim|required'
            ),
             array('field'   => 'company',
            'label'   => 'Company Name',
            'rules'   => 'trim|required'
            ),
            array('field'   => 'year',
            'label'   => 'Year',
            'rules'   => 'trim|required'
            ),
             array('field'   => 'college',
            'label'   => 'College',
            'rules'   => 'trim|required'
            )
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);

        $placement_id=$this->input->post('placement_id');
        
        if($placement_id=="")
        {


            if ($this->form_validation->run() == FALSE)
            { 
                      
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {  
                $insert_array=$this->input->post();
                $insert_array['stream_name']=$this->input->post('stream');
                $insert_array['year']=(int)$this->input->post('stream');
                
                $last_inserted_id=$this->placement_model->add_placement_details($insert_array);
               
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
                $roles_id=$this->input->post("roles_id");
                $this->data['roles_details']=array_shift($this->roles_model->get_roles_details($roles_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {        
                $roles_name=$this->input->post("roles_name");    
                $roles_type=$this->input->post("roles_type");    
                
                $update_array=array("roles_name"=>$roles_name,"roles_type"=>$roles_type,"updated_by"=>$this->session->userdata("uid"),"updated_datetime"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("roles_id"=>$roles_id);
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
        $roles_details=  $this->roles_model->get_roles_details_search($para);                    
        echo json_encode(array("roles_details"=>$roles_details));
    } 
}
?>