<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

defined('BASEPATH') OR exit('No direct script access allowed');
class School_color_map extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="schoolcolor";
    var $model_name="school_color_map_model";
    var $model;
    var $view_dir='School_color_map/';
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
        $this->data['schoolcolor_details']= $this->school_color_map_model->get_school_color_details();
		//echo "<pre>";print_r($this->data['schoolcolor_details']); die;
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
		
    }
    
    public function add()
    {
        $this->load->view('header',$this->data);  
        $this->data['school']= $this->school_color_map_model->get_school(); 
		$this->data['color']= $this->school_color_map_model->get_color();
		//echo "<pre>";print_r($this->data['products']); die;		
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
    public function view()
    {
        $this->load->view('header',$this->data);        
        $this->data['schoolcolor_details']= $this->school_color_map_model->get_school_color_details();               
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data); 
        $this->data['school']= $this->school_color_map_model->get_school(); 
		$this->data['color']= $this->school_color_map_model->get_color(); 		
        $productsize_id=$this->uri->segment(3);
        $this->data['schoolcolor_details']=array_shift($this->school_color_map_model->get_school_color_details($productsize_id));    
		//echo "<pre>";print_r($this->data['schoolcolor_details']); die;
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);                
        $school_color_id=$this->uri->segment(3);   
        $update_array=array("is_active"=>"0","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("id"=>$school_color_id);
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
        $school_color_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("school_color_id"=>$school_color_id);
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
                        array('field'   => 'school_id',
			'label'   => 'Size',
			'rules'   => 'trim|required|xss_clean'
			),
			array('field'   => 'color_id',
			'label'   => 'Color',
			'rules'   => 'trim|required|xss_clean'
			)
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $school_color_id=$this->input->post('school_color_id');
        
        if($school_color_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
                $school_id=$this->input->post("school_id");    
                $color_id=$this->input->post("color_id");     
                $insert_array=array("school_id"=>$school_id,"color_id"=>$color_id,"created_by"=>'1',"created_at"=>date("Y-m-d H:i:s"));                                                                
                $secondDB->insert("schoolcolor", $insert_array); 
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
                $school_color_id=$this->input->post("school_color_id");
                $this->data['schoolcolor_details']=array_shift($this->school_color_map_model->get_school_color_details($school_color_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {    
				$school_color_id=$this->input->post("school_color_id");
                $school_id=$this->input->post("school_id");    
                $color_id=$this->input->post("color_id");      
         
                $update_array=array("school_id"=>$school_id,"color_id"=>$color_id,"updated_by"=>'1',"updated_at"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("id"=>$school_color_id);
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
        $schoolcolor_details=  $this->school_color_map_model->get_schoolcolor_details($para);                    
        echo json_encode(array("productsize_details"=>$schoolcolor_details));
    } 
}
?>