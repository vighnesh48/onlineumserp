<?php
ini_set("display_errors", "On");
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
define("MODEL_NM","Exam_center_model");
class Exam_center_master extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="exam_center_master";
    var $model_name="Exam_center_model";
    var $model;
    var $view_dir='Exam_center_master/';
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
        $this->data['exam_center_details']= $this->Exam_center_model->get_exam_center_master_details();         // print_r( $this->data['exam_center_details']);exit;                               
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
        $this->data['exam_center_details']=$this->Exam_center_model->get_exam_center_master_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);                
        $ec_id=$this->uri->segment(3);
        $this->data['exam_center_details']=array_shift($this->Exam_center_model->get_exam_center_master_details($ec_id));                            
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $this->load->view('header',$this->data);                
        $ec_id=$this->uri->segment(3);   
        $update_array=array("is_active"=>"N","modified_by"=>  $this->session->userdata('uid'));                                
        $where=array("ec_id"=>$ec_id);
        $DB1->where($where);
        //echo $DB1->last_query();exit;
        if($DB1->update($this->table_name, $update_array))
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
        $DB1 = $this->load->database('umsdb', TRUE);

        $this->load->view('header',$this->data);               
        $ec_id=$this->uri->segment(3);   
        $update_array=array("is_active"=>"Y","modified_by"=>  $this->session->userdata('uid'));                                
        $where=array("ec_id"=>$ec_id);
        $DB1->where($where);
        
        if($DB1->update($this->table_name, $update_array))
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

			array('field'   => 'center_name',
			'label'   => 'exam center name',
			'rules'   => 'trim|required|xss_clean'
			)
                        
			
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $ec_id=$this->input->post('ec_id');
        
        if($ec_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
                $center_name=$this->input->post("center_name");
                $center_code=$this->input->post("center_code");
                $venue_address=$this->input->post("venue_address");
                $land_mark=$this->input->post("land_mark");
                $contact_person=$this->input->post("contact_person");
                $contact_mobile=$this->input->post("contact_mobile");
                $email_official=$this->input->post("email_official");


                
                $insert_array=array("center_name"=>$center_name,"center_code"=>$center_code,"venue_address"=>$venue_address,"land_mark"=>$land_mark,"contact_person"=>$contact_person,"contact_mobile"=>$contact_mobile,"email_official"=>$email_official,"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"));
                $DB1 = $this->load->database('umsdb', TRUE);                                                                
                $DB1->insert("exam_center_master", $insert_array); 
                //print_r($DB1->insert_id());exit;        
                $last_inserted_id=$DB1->insert_id();    
                if($last_inserted_id)
                {
                    redirect(base_url("exam_center_master"));
                }
                else
                {
                    redirect(base_url($this->view_dir.'exam_center_master?error=1'));
                }
            }
        }
        else
        {
            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('header',$this->data);                
                $ec_id=$this->input->post("ec_id");
                $this->data['exam_center_details']=array_shift($this->Exam_center_model->get_exam_center_master_details($ec_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {        
                $ec_id=$this->input->post("ec_id");    
                $center_name=$this->input->post("center_name");
                $center_code=$this->input->post("center_code");
                $venue_address=$this->input->post("venue_address");
                $land_mark=$this->input->post("land_mark");
                $contact_person=$this->input->post("contact_person");
                $contact_mobile=$this->input->post("contact_mobile");
                $email_official=$this->input->post("email_official");
                
                $update_array=array("center_name"=>$center_name,"center_code"=>$center_code,"venue_address"=>$venue_address,"land_mark"=>$land_mark,"contact_person"=>$contact_person,"contact_mobile"=>$contact_mobile,"email_official"=>$email_official,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("ec_id"=>$ec_id);
                $DB1 = $this->load->database('umsdb', TRUE);
                $DB1->where($where);                
                if($DB1->update($this->table_name, $update_array))
                {                    
                    redirect(base_url("exam_center_master"));
                }
                else
                {  
                    redirect(base_url($this->view_dir."exam_center_master?error=1"));
                }
            }
        }      
    }  
    
    public function search()
    {        
        $para=$this->input->post("title");
        $exam_center_details=  $this->Exam_center_model->get_exam_center_master_details_search($para);                    
        echo json_encode(array("exam_center_details"=>$exam_center_details));
    } 

}
?>