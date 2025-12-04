<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class College extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="college_master";
    var $model_name="college_model";
    var $model;
    var $view_dir='College/';
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
		if($this->session->userdata("role_id")==6){
		}else{
			redirect('home');
		}
    }
    
    public function index()
    {
        $this->load->view('header',$this->data);        
        $this->data['college_details']=$this->college_model->get_college_details();                
        $this->data['campus_details']= $this->college_model->get_campus_details();                                        
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
        $this->load->view('header',$this->data); 
        $this->data['campus_details']= $this->college_model->get_campus_details();                                        
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
    public function view()
    {
        $this->load->view('header',$this->data);        
        $this->data['college_details']=$this->college_model->get_college_details();                
        $this->data['campus_details']= $this->college_model->get_campus_details();                                        
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);                
        $campus_id=$this->uri->segment(3);
        $this->data['campus_details']= $this->college_model->get_campus_details();                                        
        $this->data['college_details']=array_shift($this->college_model->get_college_details($campus_id));                            
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);                
        $college_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("college_id"=>$college_id);
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
        $college_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("college_id"=>$college_id);
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
        $config=array(
                        array('field'   => 'campus_id',
			'label'   => 'Campus',
			'rules'   => 'trim|required|integer|xss_clean'
			),
                        array('field'   => 'college_code',
			'label'   => 'College code',
			'rules'   => 'trim|required|alpha|xss_clean'
			),
                        array('field'   => 'college_name',
			'label'   => 'College name',
			'rules'   => 'trim|required|xss_clean'
			)
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $college_id=$this->input->post('college_id');
        
        if($college_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
                $campus_id=$this->input->post("campus_id");
                $college_code=$this->input->post("college_code");    
                $college_name=$this->input->post("college_name");    
                $college_city=$this->input->post("college_city");    
                $college_state=$this->input->post("college_state");    
                $college_address=$this->input->post("college_address");    
                $college_pincode=$this->input->post("college_pincode");                    
                
                $insert_array=array("campus_id"=>$campus_id,"college_code"=>$college_code,"college_name"=>$college_name,"college_city"=>$college_city,"college_state"=>$college_state,"college_address"=>$college_address,"college_pincode"=>$college_pincode,"inserted_by"=>$this->session->userdata("uid"),"inserted_datetime"=>date("Y-m-d H:i:s"));                                                                
                $this->db->insert("college_master", $insert_array); 
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
                $college_id=$this->input->post("college_id");
                $this->data['college_details']=array_shift($this->college_model->get_college_details($college_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {        
                $campus_id=$this->input->post("campus_id");
                $college_code=$this->input->post("college_code");    
                $college_name=$this->input->post("college_name");    
                $college_city=$this->input->post("college_city");    
                $college_state=$this->input->post("college_state");    
                $college_address=$this->input->post("college_address");    
                $college_pincode=$this->input->post("college_pincode");                    
                
                $update_array=array("campus_id"=>$campus_id,"college_code"=>$college_code,"college_name"=>$college_name,"college_city"=>$college_city,"college_state"=>$college_state,"college_address"=>$college_address,"college_pincode"=>$college_pincode,"updated_by"=>$this->session->userdata("uid"),"updated_datetime"=>date("Y-m-d H:i:s"));                                                                                    
                                
                $where=array("college_id"=>$college_id);
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
        $college_details=  $this->college_model->get_college_search_details($para);                    
        echo json_encode(array("college_details"=>$college_details));
    } 
}
?>