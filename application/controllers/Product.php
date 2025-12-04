<?php



defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="productmaster";
    var $model_name="product_model";
    var $model;
    var $view_dir='Product/';
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
        $this->data['product_details']= $this->product_model->get_product_details();
		//echo "<pre>";print_r($this->data['proudct_details']); die;                                           
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
        $this->data['product_details']=$this->product_model->get_product_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);                
        $color_id=$this->uri->segment(3);
        $this->data['product_details']=array_shift($this->product_model->get_product_details($color_id));                            
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
        //echo "<pre>"; print_r($post_array); 
        //echo "<pre>"; print_r($_FILES); die;
        $config=array(
                        array('field'   => 'product_price',
			'label'   => 'Product Code',
			'rules'   => 'trim|required|xss_clean'
			),
			array('field'   => 'product_name',
			'label'   => 'Product name',
			'rules'   => 'trim|required|xss_clean'
			)
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $product_id=$this->input->post('product_id');
        
        if($product_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
				
                $product_price=$this->input->post("product_price");    
                $product_name=$this->input->post("product_name");   
                
				if(!empty($_FILES['profile_img']['name'])){
					$filenm=$_POST['product_name'].'-'.'product-'.$_FILES['profile_img']['name'];
					$config['upload_path'] = 'uploads/uniform/product/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['overwrite']= TRUE;
					$config['max_size']= "2048000";
					//$config['file_name'] = $_FILES['profile_img']['name'];
					$config['file_name'] = $filenm;
					
					//Load upload library and initialize configuration
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					
					if($this->upload->do_upload('profile_img')){
						$uploadData = $this->upload->data();
					   // $picture = $uploadData['file_name'];
					 //  array_push($picture,$uploadData['file_name']);
					 $picture['profile_pic']=$uploadData['file_name'];
					}else{
						$picture['profile_pic']="";
						
					}
				}
				else{
					//$picture = '';
					$picture['profile_pic']="";

				}
				//echo $picture['profile_pic']; die;
				
                $insert_array=array("product_price"=>$product_price,"product_name"=>$product_name,
				"Image"=>$picture['profile_pic'],"is_active"=>'1',
				"created_by"=>'1',"created_at"=>date("Y-m-d H:i:s"));                                                                
                $secondDB->insert("productmaster", $insert_array); 
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
                $product_id=$this->input->post("product_id");
                 $product_price=$this->input->post("product_price");
                $this->data['product_details']=array_shift($this->product_model->get_product_details($product_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {   

            //echo "1"; die;

                $product_id=$this->input->post("product_id");    
                $product_price=$this->input->post("product_price");    
                $product_name=$this->input->post("product_name"); 
				$temp_image=$this->input->post("temp_image"); 
				if(!empty($_FILES['profile_img']['name'])){
					 $filenm=$_POST['product_name'].'-'.'product-'.$_FILES['profile_img']['name']; 

					$config['upload_path'] = '/uploads/uniform/product/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['overwrite']= TRUE;
					//$config['max_size']= "2048000";
					//$config['file_name'] = $_FILES['profile_img']['name'];
					$config['file_name'] = $filenm;
					
					//Load upload library and initialize configuration
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
                    if (!$this->upload->do_upload())
                    {
                          $error = array('error' => $this->upload->display_errors());
                            echo "<pre>"; print_r($error);  die;  
                    }
                    else{
                        $uploadData = $this->upload->data();
                        $picture['profile_pic'] = $uploadData['file_name'];
                    }
                }
                else{
                    $picture['profile_pic']=$temp_image;

                }
                
				
                
                $update_array=array("product_price"=>$product_price,"product_name"=>$product_name,
				"Image"=>$picture['profile_pic'],
				"updated_by"=>'1',"updated_at"=>date("Y-m-d H:i:s"));                                                                
                       echo "<pre>"; print_r($update_array);   die;

                $where=array("id"=>$product_id);
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
        $product_details=  $this->product_model->get_product_details($para);                    
        echo json_encode(array("product_details"=>$product_details));
    } 
}
?>