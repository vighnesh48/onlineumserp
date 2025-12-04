<?php
ini_set("display_errors", "On");
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
define("MODEL_NM","shift_model");
class Shift extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="shift_master";
    var $model_name="shift_model";
    var $model;
    var $view_dir='Shift/';
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
        $this->data['shift_details']= $this->shift_model->get_shift_details();                                        
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
        $this->data['shift_details']=$this->shift_model->get_shift_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);                
        $shift_id=$this->uri->segment(3);
        $this->data['shift_details']=array_shift($this->shift_model->get_shift_details($shift_id));                            
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);                
        $shift_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("shift_id"=>$shift_id);
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
        $shift_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("shift_id"=>$shift_id);
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
			array('field'   => 'shift_name',
			'label'   => 'Shift name',
			'rules'   => 'trim|required'
			)
                    );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);     
 	
        $shift_name = $this->input->post('shift_name', TRUE);
        
        if($shift_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {    

            
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {    

	
                $shift_name=$this->input->post("shift_name");   
                $start_hh=$this->input->post("start_hh");   
                $start_mm=$this->input->post("start_mm");   
                $end_hh=$this->input->post("end_hh");   
                $end_mm=$this->input->post("end_mm");   
                
                $start_time=$start_hh.":".$start_mm.":00";
                $end_time=$end_hh.":".$end_mm.":00";
                
                $insert_array=array("shift_name"=>$shift_name,"shift_start_time"=>$start_time,"shift_start_time"=>$start_time,"shift_end_time"=>$end_time,"inserted_by"=>$this->session->userdata("uid"),"inserted_datetime"=>date("Y-m-d H:i:s"));                                                                
                $this->db->insert("shift_master", $insert_array); 
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
                $shift_id=$this->input->post("shift_id");
                $this->data['shift_details']=array_shift($this->shift_model->get_shift_details($shift_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {        
                $shift_name=$this->input->post("shift_name");   
                $start_hh=$this->input->post("start_hh");   
                $start_mm=$this->input->post("start_mm");   
                $end_hh=$this->input->post("end_hh");   
                $end_mm=$this->input->post("end_mm");   
                
                $start_time=$start_hh.":".$start_mm.":00";
                $end_time=$end_hh.":".$end_mm.":00";  
                
                $update_array=array("shift_name"=>$shift_name,"shift_start_time"=>$start_time,"shift_start_time"=>$start_time,"shift_end_time"=>$end_time,"updated_by"=>$this->session->userdata("uid"),"updated_datetime"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("shift_id"=>$shift_id);
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
        $shift_details=  $this->shift_model->get_shift_details($para);                    
        echo json_encode(array("shift_details"=>$shift_details));
    } 
}
?>