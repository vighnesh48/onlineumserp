<?php





defined('BASEPATH') OR exit('No direct script access allowed');
class Productsize extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="productsizemaster";
    var $model_name="productsize_model";
    var $model;
    var $view_dir='Productsize/';
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
        $this->data['proudctsize_details']= $this->productsize_model->get_productsize_details();
		//echo "<pre>";print_r($this->data['proudctsize_details']); die;
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
        $this->load->view('header',$this->data);  
        $this->data['products']= $this->productsize_model->get_proudcts();
		//echo "<pre>";print_r($this->data['products']); die;		
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
    public function view()
    {
        $this->load->view('header',$this->data);        
        $this->data['proudctsize_details']= $this->productsize_model->get_productsize_details();               
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data); 
        $this->data['products']= $this->productsize_model->get_proudcts();                 
        $productsize_id=$this->uri->segment(3);
        $this->data['productsize_details']=array_shift($this->productsize_model->get_productsize_details($productsize_id));    
		//echo "<pre>";print_r($this->data['productsize_details']); die;
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);                
        $designation_id=$this->uri->segment(3);   
        $update_array=array("is_active"=>"0","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("id"=>$proudct_id);
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
		$secondDB = $this->load->database('umsdb', TRUE);
		
        $this->load->helper('security');
        $post_array=  $this->input->post();
        //echo "<pre>"; print_r($post_array); die;
        $config=array(
                        array('field'   => 'sizecode',
			'label'   => 'Size Code',
			'rules'   => 'trim|required|xss_clean'
			),
			array('field'   => 'size',
			'label'   => 'Size',
			'rules'   => 'trim|required|xss_clean'
			)
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $productsize_id=$this->input->post('productsize_id');
        
        if($productsize_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {

                
                

                $product_id=$this->input->post("product_id");    
                $sizecode=$this->input->post("sizecode");    
                $size=$this->input->post("size");  
                //$check_ps=$this->productsize_model->get_ps($product_id,$sizecode,$size);
                $check_ps=  $this->productsize_model->get_ps($product_id,$sizecode,$size);  
               // echo "<pre>"; print_r($check_ps); die;
                if(!empty($check_ps))
                {
                    redirect(base_url($this->view_dir."view?error=1"));
                }

                $insert_array=array("size"=>$size,"product_id"=>$product_id,"sizecode"=>$sizecode,"created_by"=>'1',"created_at"=>date("Y-m-d H:i:s"));                                                                
                $secondDB->insert("productsizemaster", $insert_array); 
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
                $productsize_id=$this->input->post("productsize_id");
                $this->data['productsize_details']=array_shift($this->productsize_model->get_productsize_details($productsize_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {    
				$productsize_id=$this->input->post("productsize_id");
                $product_id=$this->input->post("product_id");    
                $sizecode=$this->input->post("sizecode");    
                $size=$this->input->post("size");  
                
                $update_array=array("size"=>$size,"product_id"=>$product_id,"sizecode"=>$sizecode,"updated_by"=>'1',"updated_at"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("id"=>$productsize_id);
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
        $productsize_details=  $this->productsize_model->get_productsize_details($para);                    
        echo json_encode(array("productsize_details"=>$productsize_details));
    } 
}
?>