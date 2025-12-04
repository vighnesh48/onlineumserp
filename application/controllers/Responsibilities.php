<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Responsibilities extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="staff_documents";
    var $model_name="responsibilities_model";
    var $model;
    var $view_dir='Responsibilities/';
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
        $this->data['staff_details']= $this->responsibilities_model->staff_details();                                        
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
		 $this->data['fc_details']= $this->responsibilities_model->get_faculty_details();         
        $this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
    public function view()
    {
        $this->load->view('header',$this->data);        
        $this->data['staff_details']=$this->responsibilities_model->staff_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);                
        $branch_id=$this->uri->segment(3);
       $this->data['fc_details']= $this->responsibilities_model->get_faculty_details();                              
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);                
        $branch_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("branch_id"=>$branch_id);
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
        $branch_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("branch_id"=>$branch_id);
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

        $DB1 = $this->load->database('umsdb', TRUE);  	
        $this->load->helper('security');
        $post_array=  $this->input->post();
        $config=array(
                        array('field'   => 'search_me',
			'label'   => 'Faculty name',
			'rules'   => 'required'
			)
                 );
        $this->form_validation->set_rules($config);         
        $upload_id=$this->input->post('upload_id');
        
        if($upload_id=="")
        {
			
            if ($this->form_validation->run() == FALSE)
            {   
		
                $this->data['fc_details']= $this->responsibilities_model->get_faculty_details();      		
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
				
				if(!empty($_FILES['doc']['name'])){
					
			$filenm=$_FILES['doc']['name'];
			$config['upload_path'] = 'uploads/staff_document/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "5048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('doc')){
				
				$uploadData = $this->upload->data();
				$dname = $uploadData['file_name'];
				//echo 'yfuyfguy==='.$payfile;exit();
			}else{
					
				$dname = '';
			}
		}
		else{
				
			$dname = '';
		}
                $search_me=$this->input->post("search_me");    
              $check_entry=$DB1->query("select * from staff_documents where staff_id=$search_me")->row();
			  if(empty($check_entry)){
                $insert_array=array("staff_id"=>$search_me,"document_name"=>$dname,"inserted_by"=>$this->session->userdata("uid"),"inserted_datetime"=>date("Y-m-d H:i:s"));                                                                
                $DB1->insert("staff_documents", $insert_array); 
                $last_inserted_id=$DB1->insert_id();  
			  }
			  else{
				  $id=$check_entry->id;
				
				  $update_array=array("staff_id"=>$search_me,"document_name"=>$dname,"updated_by"=>$this->session->userdata("uid"),"updated_datetime"=>date("Y-m-d H:i:s"));                                                                
				  $DB1->where('id', $id);
                  $DB1->update('staff_documents', $update_array); 
                  $last_inserted_id=$DB1->affected_rows();   
			  }
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
        }      
    }  
    
    public function search()
    {        
        $para=$this->input->post("title");
        $branch_details=  $this->responsibilities_model->get_branch_details($para);                    
        echo json_encode(array("branch_details"=>$branch_details));
    } 
}
?>