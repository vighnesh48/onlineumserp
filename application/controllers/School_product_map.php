<?php



defined('BASEPATH') OR exit('No direct script access allowed');
class School_product_map extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="schoolproduct";
    var $model_name="school_product_map_model";
    var $model;
    var $view_dir='School_product_map/';
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
        $this->data['schoolproduct_details']= $this->school_product_map_model->get_school_product_details();
		//echo "<pre>";print_r($this->data['schoolcolor_details']); die;
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
        $this->load->view('header',$this->data);  
        $this->data['school']= $this->school_product_map_model->get_school(); 
		$this->data['products']= $this->school_product_map_model->get_product();
		//echo "<pre>";print_r($this->data['products']); die;		
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
    public function view()
    {
        $this->load->view('header',$this->data);        
        $this->data['schoolproduct_details']= $this->school_product_map_model->get_school_product_details();               
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data); 
        $this->data['school']= $this->school_product_map_model->get_school(); 
		$this->data['product']= $this->school_product_map_model->get_product(); 		
        $productsize_id=$this->uri->segment(3);
        $this->data['schoolproduct_details']=array_shift($this->school_product_map_model->get_school_product_details($productsize_id));    
		//echo "<pre>";print_r($this->data['schoolcolor_details']); die;
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);                
        $school_product_id=$this->uri->segment(3);   
        $update_array=array("is_active"=>"0","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("id"=>$school_product_id);
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
        $where=array("school_product_id"=>$school_product_id);
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
			'label'   => 'School',
			'rules'   => 'trim|required|xss_clean'
			),
			array('field'   => 'product_id',
			'label'   => 'Product',
			'rules'   => 'trim|required|xss_clean'
			)
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $school_product_id=$this->input->post('school_product_id');
        
        if($school_product_id=="")
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
                $product_id=$this->input->post("product_id");     
                $insert_array=array("school_id"=>$school_id,"product_id"=>$product_id,"created_by"=>'1',"created_at"=>date("Y-m-d H:i:s"));                                                                
                $secondDB->insert("schoolproduct", $insert_array); 
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
                $school_product_id=$this->input->post("school_product_id");
                $this->data['schoolproduct_details']=array_shift($this->school_product_map_model->get_school_product_details($school_product_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {    
				$school_product_id=$this->input->post("school_product_id");
                $school_id=$this->input->post("school_id");    
                $product_id=$this->input->post("product_id");      
         
                $update_array=array("school_id"=>$school_id,"product_id"=>$product_id,"updated_by"=>'1',"updated_at"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("id"=>$school_product_id);
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
    
   
}
?>