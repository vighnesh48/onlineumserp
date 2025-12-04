<?php
ini_set("display_errors", "On");
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
define("MODEL_NM","course_model");
class Course extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="course_master";
    var $model_name="course_model";
    var $model;
    var $view_dir='Course/';
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
        $this->data['course_details']= $this->course_model->get_course_details();                                
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
        $this->data['course_details']=$this->course_model->get_course_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);                
        $course_id=$this->uri->segment(3);
        $this->data['course_details']=array_shift($this->course_model->get_course_details($course_id));                            
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);                
        $course_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("course_id"=>$course_id);
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
        $course_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("course_id"=>$course_id);
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
                        array('field'   => 'course_code',
			'label'   => 'Course Code',
			'rules'   => 'trim|required|alpha|xss_clean'
			),
			array('field'   => 'course_name',
			'label'   => 'Course name',
			'rules'   => 'trim|required|xss_clean'
			)
                        
			
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $course_id=$this->input->post('course_id');
        
        if($course_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
                $course_code=$this->input->post("course_code");    
                $course_name=$this->input->post("course_name");    
                //$course_type=$this->input->post("course_type");    
                //$duration=$this->input->post("duration");    
                
                $insert_array=array("course_short_name"=>$course_code,"course_name"=>$course_name,"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"));
                $DB1 = $this->load->database('umsdb', TRUE);                                                                
                $DB1->insert("course_master", $insert_array); 
                $last_inserted_id=$DB1->insert_id();                
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
                $course_id=$this->input->post("course_id");
                $this->data['course_details']=array_shift($this->course_model->get_course_details($course_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {        
                $course_id=$this->input->post("course_id");    
                $course_code=$this->input->post("course_code");    
                $course_name=$this->input->post("course_name");    
                //$course_type=$this->input->post("course_type");    
                //$duration=$this->input->post("duration"); 
                
                $update_array=array("course_short_name"=>$course_code,"course_name"=>$course_name,"modified_by"=>$this->session->userdata("uid"),"modified_by"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("course_id"=>$course_id);
                $DB1 = $this->load->database('umsdb', TRUE);
                $DB1->where($where);                
                if($DB1->update($this->table_name, $update_array))
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
        $course_details=  $this->course_model->get_course_details_search($para);                    
        echo json_encode(array("course_details"=>$course_details));
    } 
}
?>