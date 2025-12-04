<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Designation extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="designation_master";
    var $model_name="designation_model";
    var $model;
    var $view_dir='Designation/';
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
        $this->data['designation_details']= $this->designation_model->get_designation_details();                                                
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
        $this->data['designation_details']=$this->designation_model->get_designation_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);                
        $designation_id=$this->uri->segment(3);
        $this->data['designation_details']=array_shift($this->designation_model->get_designation_details($designation_id));                            
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);                
        $designation_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("designation_id"=>$designation_id);
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
        $where=array("designation_id"=>$designation_id);
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
                        array('field'   => 'designation_code',
			'label'   => 'Designation Code',
			'rules'   => 'trim|required'
			),
			array('field'   => 'designation_name',
			'label'   => 'Designation name',
			'rules'   => 'trim|required'
			)
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $designation_id=$this->input->post('designation_id');
        
        if($designation_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
                $designation_code=$this->input->post("designation_code");    
                $designation_name=$this->input->post("designation_name");   
                
                $insert_array=array("designation_code"=>$designation_code,"designation_name"=>$designation_name,"inserted_by"=>$this->session->userdata("uid"),"inserted_datetime"=>date("Y-m-d H:i:s"));                                                                
                $this->db->insert("designation_master", $insert_array); 
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
                $designation_code=$this->input->post("designation_code");    
                $designation_name=$this->input->post("designation_name");  
                
                $update_array=array("designation_code"=>$designation_code,"designation_name"=>$designation_name,"updated_by"=>$this->session->userdata("uid"),"updated_datetime"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("designation_id"=>$designation_id);
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
        $designation_details=  $this->designation_model->get_designation_details($para);                    
        echo json_encode(array("designation_details"=>$designation_details));
    } 
	////////////////////////////////////////////////
	function view_user_master_data()
	{
		
		if($this->session->userdata("role_id")==15){
		}else{
			redirect('home');
		}
		exit;
		$this->load->view('header',$this->data);
        $this->data['user_master_data']=$this->designation_model->fetch_user_master_data();		
		$this->load->view($this->view_dir."view_user_master",$this->data);
		$this->load->view('footer');
	}
		public function user_status()
    {
        $this->load->view('header',$this->data);       
        $um_id=$this->uri->segment(4);
        $status=$this->uri->segment(3);
		if($status=="enable")
		{
        $update_array=array("status"=>"Y");                               
        $where=array("um_id"=>$um_id);
        $this->db->where($where);		
        if($this->db->update('user_master', $update_array))
        {
            redirect(base_url($this->view_dir."view_user_master_data?error=0"));			
        }
        else
        {
            redirect(base_url($this->view_dir."view_user_master_data?error=1"));
        } 
		}
 else
 {
        $update_array=array("status"=>"N");                                
        $where=array("um_id"=>$um_id);
        $this->db->where($where);        
        if($this->db->update('user_master', $update_array))
        {
          redirect(base_url($this->view_dir."view_user_master_data?error=0"));			
        }
        else
        {
         redirect(base_url($this->view_dir."view_user_master_data?error=1")); 
       }	 
          $this->load->view('footer');
    }
	}
	
	public function user_search()
    {        
        $para=$this->input->post("title");
        $user_master_data=$this->designation_model->user_search_details($para);                    
        echo json_encode(array("user_master_data"=>$user_master_data));
    }
	
}
?>