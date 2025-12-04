<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

defined('BASEPATH') OR exit('No direct script access allowed');
class Inventory extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="inventory";
    var $model_name="inventory_model";
    var $model;
    var $view_dir='Inventory/';
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
        $this->data['inventory_details']= $this->inventory_model->get_inventory_details();
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
		
    }
    
    public function add()
    {
        $this->load->view('header',$this->data);  
        $this->data['school']= $this->inventory_model->get_school(); 
		$this->data['color']= $this->inventory_model->get_color();
		$this->data['size']= $this->inventory_model->get_size();
		$this->data['product']= $this->inventory_model->get_product();
		//echo "<pre>";print_r($this->data['products']); die;		
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
    public function view()
    {
        $this->load->view('header',$this->data);  
		//echo "1"; die;
        $this->data['inventory_details']= $this->inventory_model->get_inventory_details();
		//echo "<pre>";print_r($this->data['inventory_details']); die;		
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data); 
        $this->data['school']= $this->inventory_model->get_school(); 
		//$this->data['color']= $this->inventory_model->get_color();
		$this->data['size']= $this->inventory_model->get_size();
		$this->data['product']= $this->inventory_model->get_product();
		
        $inventory_id=$this->uri->segment(3);
        $this->data['inventory_details']=array_shift($this->inventory_model->get_inventory_details($inventory_id));    
		//echo "<pre>";print_r($this->data['inventory_details']); die;
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
			'label'   => 'School',
			'rules'   => 'trim|required|xss_clean'
			),
			array('field'   => 'size_id',
			'label'   => 'Size',
			'rules'   => 'trim|required|xss_clean'
			),
			array('field'   => 'product_id',
			'label'   => 'Product',
			'rules'   => 'trim|required|xss_clean'
			)
        );
		//echo "<pre>";print_r($this->input->post()); 
        $this->form_validation->set_rules($config);         
        $inventory_id=$this->input->post('inventory_id');
        
        if($inventory_id=="")
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
                $size_id=$this->input->post("size_id"); 
				$quantity=$this->input->post("quantity"); 
				$gender=$this->input->post("gender"); 

				
				$check_inventory=$this->inventory_model->get_checkinventory($school_id,$product_id,$size_id,$gender);
				/*$secondDB->insert("inventory_log", $insert_array_log);
				$last_inserted_id=$secondDB->insert_id();
				//echo "<pre>";print_r($check_inventory); 
                */
				
				if(empty($check_inventory))
				{
					//echo "1"; die;
					$insert_array=array("school_id"=>$school_id,"product_id"=>$product_id,"product_size_id"=>$size_id,"quantity"=>$quantity,"gender"=>$gender,"created_by"=>$this->session->userdata('uid'),'is_active'=>'1',
                        "created_at"=>date("Y-m-d H:i:s"));

                    $insert_array_log=array("school_id"=>$school_id,
                    "product_id"=>$product_id,
                    "product_size_id"=>$size_id,
                    "quantity"=>$quantity,
					"gender"=>$gender,
                    'operation'=>'1',
                    "created_by"=>$this->session->userdata('uid'),
                    "created_at"=>date("Y-m-d H:i:s"));

					$secondDB->insert("inventory", $insert_array); 
					$secondDB->insert("inventory_log", $insert_array_log);
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
				else
				{
					$school_id=$this->input->post("school_id");          
					$product_id=$this->input->post("product_id");    
					$size_id=$this->input->post("size_id"); 
					$quantity=$this->input->post("quantity"); 
					$gender=$this->input->post("gender"); 
					//echo "2"; die;
					$inv_id = $check_inventory['0']->id;
					$oldquantity = $check_inventory['0']->quantity;
					//echo '<pre>';print_r($check_inventory);exit;
					if(isset($oldquantity))
					{
                       /* if($check_inventory['0']->opration =='1')
                        {
						    $quantity_new = $oldquantity+$quantity;
                        }
                        else
                        {
                            $quantity_new = $oldquantity-$quantity;
                        }*/
						$quantity_new = $oldquantity+$quantity;
					}
					
					$insert_array_log=array("school_id"=>$school_id,
                    "product_id"=>$product_id,
                    "product_size_id"=>$size_id,
                    "quantity"=>$quantity,
					"gender"=>$gender,
                    'operation'=>'1',
                    "created_by"=>$this->session->userdata('uid'),
                    "created_at"=>date("Y-m-d H:i:s"));
					$secondDB->insert("inventory_log", $insert_array_log);
					//echo $quantity_new; die;
					$where=array("id"=>$inv_id);
					$update_array=array("quantity"=>$quantity_new,
                        "updated_by"=>$this->session->userdata('uid'),"updated_at"=>date("Y-m-d H:i:s"));                                                           
					$secondDB->where($where);					
					
					if($secondDB->update("inventory", $update_array))
					{
						
						//echo $secondDB->last_query();die;
						redirect(base_url($this->view_dir."view?error=0"));
					}
					else
					{
						//echo "2"; die;
						redirect(base_url($this->view_dir.'view?error=1'));
					}
				}
            }
			
        }
        else
        {
            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('header',$this->data);                
                $inventory_id=$this->input->post("inventory_id");
                $this->data['inventory_details']=array_shift($this->inventory_model->get_inventory_details($inventory_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {    
				$inventory_id=$this->input->post("inventory_id");
                $school_id=$this->input->post("school_id");    
                $color_id=$this->input->post("color_id");      
				$product_id=$this->input->post("product_id");    
                $size_id=$this->input->post("size_id");  
				$quantity=$this->input->post("quantity"); 
                $update_array=array("school_id"=>$school_id,"color_id"=>$color_id,"product_id"=>$product_id,"quantity"=>$quantity,"product_size_id"=>$size_id,"updated_by"=>'1',"updated_at"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("id"=>$inventory_id);
                $secondDB->where($where);     
				$secondDB->update("inventory_log", $update_array);
				echo $secondDB->last_query(); die;  
				if($secondDB->update("inventory", $update_array))
               //if($secondDB->update($this->table_name, $update_array))
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

	public function getAllsize()
	{
		$pid=$this->input->post("valueSelected");
		//print_r($_POST); die;
		$arrResp=array();
        if(isset($pid)) {
            $sizeData = $this->inventory_model->get_productbyid($pid);
            // $publicationData = $this->mastermodel->master_get("school_master",array("is_active" => 1));
             //print_r($publicationData);die;

             if($sizeData) {
                $html = '<option  value="">Select</option>';
                foreach($sizeData as $data) {
                  //print_r($data);die;
                  $html .= '<option value="'.$data->id.'">'.$data->size.'</option>';
                } 
                  // print_r($html);die;      
                $arrResp = array("status" => 1, "message" => 'success.', "data" => $html);  
              } else {
                $arrResp = array("status" => 0, "message" => 'Something went wrong.');  
              }

          echo json_encode($arrResp);
        }
	}
	public function inout_view()
    {
        $this->load->view('header',$this->data);  
        $this->data['inventory_details']= $this->inventory_model->get_inventory_details();
		$this->data['inout_uniform_data']=$this->inventory_model->get_inout_uniform();
        $this->load->view($this->view_dir.'inout_view',$this->data);
        $this->load->view('footer');
    }
	public function view_history($inventory_id='')
    {
        $this->load->view('header', $this->data);
    
       
        $this->data['inventory_details'] = $this->inventory_model->get_inventory_history($inventory_id);
  //  echo "<pre>";print_r($this->data['inventory_details']); die;
        $this->load->view($this->view_dir . 'view_history', $this->data);
        $this->load->view('footer');
    }
	
}
?>