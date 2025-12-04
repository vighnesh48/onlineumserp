<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Course_branch_reln extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="college_course_branch_reln";
    var $model_name="course_branch_reln_model";
    var $model;
    var $view_dir='Course_branch_reln/';
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
        
        $this->load->model($this->model_name);
        $this->load->model("common_model");        
        
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
        //print_r($this->data['my_privileges']); die;
    }
    
    public function index()
    {
        $this->load->view('header',$this->data);    
        $this->data['details']= $this->course_branch_reln_model->get_details();                                        
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
        $this->load->view('header',$this->data);                        
        $this->data['campus_details']=$this->common_model->get_campus_details();                       
        $this->data['course_details']=$this->course_branch_reln_model->get_course_details();                       
        $this->data['branch_details']=$this->course_branch_reln_model->get_branch_details();   
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
    public function view()
    {
        $this->load->view('header',$this->data);    
        $this->data['details']= $this->course_branch_reln_model->get_details();                                        
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);        
        $ccb_id=$this->uri->segment(3);
        $this->data['details']=array_shift($this->course_branch_reln_model->get_details($ccb_id));       
        $this->data['campus_details']=$this->common_model->get_campus_details();               
        $this->data['college_details']=$this->common_model->get_campuswise_college_details($this->data['details']['campus_id']);               
        $this->data['course_details']=$this->common_model->get_collegewise_course_details($this->data['details']['campus_id'],$this->data['details']['college_id']);               
        $this->data['branch_details']=$this->common_model->get_collegewise_course_details($this->data['details']['campus_id'],$this->data['details']['college_id'],$this->data['details']['course_id']);                                
        $branches_details=array();
        for($i=0;$i<count($this->data['course_details']);$i++)
        {
            $course_details[$this->data['course_details'][$i]['course_id']]=$this->data['course_details'][$i]['course_code'];                        
        }
        
        for($i=0;$i<count($this->data['branch_details']);$i++)
        {
            $branch_details[$this->data['branch_details'][$i]['branch_id']]=$this->data['branch_details'][$i]['branch_name'];            
        }        
        $this->data['course_details']=$course_details;
        $this->data['branch_details']=$branch_details;
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {        
        $this->load->view('header',$this->data);        
        $ccb_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("ccb_id"=>$ccb_id);
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
        $ccb_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("ccb_id"=>$ccb_id);
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
                        array('field'   => 'campus_id',
			'label'   => 'Campus',
			'rules'   => 'trim|required|integer|xss_clean'
			),
                        array('field'   => 'college_id',
			'label'   => 'College',
			'rules'   => 'trim|required|integer|xss_clean'
			),
                        array('field'   => 'course_id',
			'label'   => 'Course',
			'rules'   => 'trim|required|integer|xss_clean'
			),
                        array('field'   => 'branch_id',
			'label'   => 'Branch',
			'rules'   => 'trim|required|integer|xss_clean'
			),
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $ccb_id=$this->input->post('ccb_id');
        
        if($ccb_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
                $campus_id=$post_array['campus_id'];
                $college_id=$post_array['college_id'];
                $course_id=$post_array['course_id'];
                $branch_id=$post_array['branch_id'];
                
                $insert_array=array("college_id"=>$college_id,"course_id"=>$course_id,"branch_id"=>$branch_id,"inserted_by"=>$this->session->userdata("uid"),"inserted_datetime"=>date("Y-m-d H:i:s"));                                                                
                $this->db->insert($this->table_name, $insert_array); 
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
                $branch_id=$this->input->post("branch_id");
                $this->data['branch_details']=array_shift($this->course_branch_reln_model->get_branch_details($branch_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {   
                $college_id=$post_array['college_id'];
                $course_id=$post_array['course_id'];
                $branch_id=$post_array['branch_id']; 
                
                $update_array=array("college_id"=>$college_id,"course_id"=>$course_id,"branch_id"=>$branch_id,"updated_by"=>$this->session->userdata("uid"),"updated_datetime"=>date("Y-m-d H:i:s"));                                                                
                
                $where=array("ccb_id"=>$ccb_id);                
                $this->db->where($where);             
                //$this->db->update($this->table_name, $update_array);


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
        $branch_details=  $this->course_branch_reln_model->get_branch_details($para);                    
        echo json_encode(array("branch_details"=>$branch_details));
    } 
    
    public function get_colleges()
    {        
        $campus_id=$this->input->post("campus_id");
        $college_details=  $this->common_model->get_campuswise_college_details($campus_id);                                  
        echo json_encode(array("college_details"=>$college_details));
    }
    
    public function get_collegewise_courses()
    {        
        $college_id=$this->input->post("college_id");
        $campus_id=  $this->input->post('campus_id');
        $this->data['course_details']=$this->common_model->get_collegewise_course_details($campus_id,$college_id);               
        
        for($i=0;$i<count($this->data['course_details']);$i++)
        {
            $course_details[$this->data['course_details'][$i]['course_id']]=$this->data['course_details'][$i]['course_code'];
        }
        $i=0;
        $course_details_new=array();
        foreach ($course_details as $key=>$val)
        {
            $course_details_new[$i]['course_id']=$key;
            $course_details_new[$i]['course_code']=$val;
            $i++;
        }
        //print_r($course_details_new); die;
        echo json_encode(array("course_details"=>$course_details_new));
    }    
    
    public function get_coursewise_branches()
    {        
        $college_id = $this->input->post("college_id");
        $campus_id =  $this->input->post('campus_id');
        $course_id =  $this->input->post('course_id');
        
        $this->data['branch_details']=$this->common_model->get_collegewise_course_details($campus_id,$college_id,$course_id);               
        
        for($i=0;$i<count($this->data['branch_details']);$i++)
        {
            $branch_details[$this->data['branch_details'][$i]['branch_id']]=$this->data['branch_details'][$i]['branch_name'];
        }
        $i=0;
        $branch_details_new=array();
        foreach ($branch_details as $key=>$val)
        {
            $branch_details_new[$i]['branch_id']=$key;
            $branch_details_new[$i]['branch_name']=$val;
            $i++;
        }
        //echo "<pre>";print_r($branch_details_new); die;
        echo json_encode(array("branch_details"=>$branch_details_new));
    }    
    
}
?>