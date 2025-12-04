<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Project_slot extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="project_slot";
    var $model_name="projectslot_model";
    var $model;
    var $view_dir='Project_slot/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        date_default_timezone_set('Asia/Kolkata'); 
        $this->load->helper("url");     
        $this->load->library('form_validation');
		$this->load->library("session");
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
        $this->data['project_slot_details']=$this->projectslot_model->get_project_slot_details();  
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
        $this->data['project_slot_details']=$this->projectslot_model->get_project_slot_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);                
        $id=$this->uri->segment(3);
        $this->data['academic_session_details']=($this->academic_model->get_academic_session_details($id));
        $this->data['academic_year_details']= $this->academic_model->get_academic_year_details();		
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);                
        $id=$this->uri->segment(3);   
        $update_array=array("is_active"=>"N");   
         $secondDB = $this->load->database('umsdb', TRUE);		
         $where=array("lect_slot_id"=>$id);
         $secondDB ->where($where);
        
        if( $secondDB ->update($this->table_name, $update_array))
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
        $id=$this->uri->segment(3);   
        $update_array=array("is_active"=>"Y");                                
        $where=array("lect_slot_id"=>$id);
		$secondDB = $this->load->database('umsdb', TRUE);		
         
        $secondDB->where($where);
        
        if($secondDB->update($this->table_name, $update_array))
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
    {   //error_reporting(E_ALL);
        $this->load->helper('security');
        $post_array=  $this->input->post();
        //echo "<pre>"; print_r($post_array); die;
        $config=array(                        
            array('field'   => 'from_time',
            'label'   => 'From time',
            'rules'   => 'trim|required|xss_clean'
            ),
			array('field'   => 'to_time',
            'label'   => 'To Time',
            'rules'   => 'trim|required|xss_clean'
            ),
			array('field'   => 'duration',
            'label'   => 'Duration',
            'rules'   => 'trim|required|xss_clean|numeric'
            )
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $slot_id=$this->input->post('slot_id');
        
        if($slot_id=="")
        {
			
            if ($this->form_validation->run() == FALSE)
            {   
				$this->load->view('header',$this->data);     	
				$this->load->view($this->view_dir.'add',$this->data);
				$this->load->view('footer');
            }
            else
            {    
		       //check for already_exits
			    
				
                $insert_array=$this->input->post();
				
				$input_time = date($insert_array['from_time']);
				$input_time_timestamp = strtotime($input_time);
                $db_from_time = date('H:i', $input_time_timestamp);
                $input_to_time = date($insert_array['to_time']);
				$input_to_time_timestamp = strtotime($input_to_time);
                $db_to_time = date('H:i', $input_to_time_timestamp);   				
				$insert_array['from_time']=$db_from_time ;
				$insert_array['to_time']=$db_to_time ;
				$doesnot_exists=$this->projectslot_model->check_already_exists($insert_array);
				if($doesnot_exists){
				
                unset($insert_array['slot_id']);		
                $insert_array['is_active']='Y';
                $last_inserted_id=$this->projectslot_model->add_slot_details($insert_array);             
                if($last_inserted_id)
                {
                    redirect(base_url($this->view_dir."view?error=0"));
                }
                else
                {
                    redirect(base_url($this->view_dir.'view?error=1'));
                }
				}    
				else{
					$this->session->set_flashdata('message', 'Data already exists of these type');
					$this->load->view('header',$this->data);     	
				    $this->load->view($this->view_dir.'add',$this->data);
				    $this->load->view('footer');				
				}
            }
        }
        else
        {
			
				$this->load->view('header',$this->data);     	
				$this->load->view($this->view_dir.'add',$this->data);
				$this->load->view('footer');
         /*   if ($this->form_validation->run() == FALSE)
            {
				
				$this->data['academic_year_details']= $this->academic_model->get_academic_year_details();
                $this->data['academic_session_details']=($this->academic_model->get_academic_session_details($year_id));				
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {  

                    $this->data['academic_session_details']=($this->academic_model->get_academic_session_details($year_id));	
					$this->data['academic_year_details']= $this->academic_model->get_academic_year_details();
                    $this->session->set_flashdata('message', 'Data already exists of these type');					
					$this->load->view('header',$this->data);        
					$this->load->view($this->view_dir.'add',  $this->data);
					$this->load->view('footer');		
              
                $update_array=$this->input->post();		
              $doesnot_exists=$this->academic_model->check_already_exists($update_array,$year_id);
			  
                if($doesnot_exists){
			    $update_array['session']='W-'.substr($this->input->post('academic_year'), 0, 4);
				if($this->input->post('academic_session')=="SUMMER"){
				$update_array['session']='S-'.substr($this->input->post('academic_year'), 0, 4);
				} 
				unset($update_array['year_id']);
                $affected_rows=$this->academic_model->update_session_details($update_array,$year_id); 
                if($affected_rows==1)
                {                    
                    redirect(base_url($this->view_dir."view?error=0"));
                }
                else
                {  
                    redirect(base_url($this->view_dir."view?error=1"));
                } 				
				}
                else{
					$this->data['academic_session_details']=($this->academic_model->get_academic_session_details($year_id));	
					$this->data['academic_year_details']= $this->academic_model->get_academic_year_details();
                    $this->session->set_flashdata('message', 'Data already exists of these type');					
					$this->load->view('header',$this->data);        
					$this->load->view($this->view_dir.'add',  $this->data);
					$this->load->view('footer');
				}
				
                
            }
			*/
        }      
    }  
    
    public function search()
    {        
        $para=$this->input->post("title");
        $state_details=  $this->state_model->get_state_details($para);                    
        echo json_encode(array("state_details"=>$state_details));
    } 
}
?>