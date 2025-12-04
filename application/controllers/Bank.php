<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bank extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="bank_master";
    var $model_name="bank_model";
    var $model;
    var $view_dir='Bank/';
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
        $this->data['bank_details']= $this->bank_model->get_bank_details();                                        
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
        $this->data['bank_details']=$this->bank_model->get_bank_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);        
        $bank_id=$this->uri->segment(3);
        $this->data['bank_details']=array_shift($this->bank_model->get_bank_details($bank_id));                            
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);               
        $bank_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("bank_id"=>$bank_id);
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
        $bank_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("bank_id"=>$bank_id);
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
       // echo "<pre>"; print_r($post_array); die;
        $config=array(
                        array('field'   => 'branch_name',
			'label'   => 'Branch Name',
			'rules'   => 'trim|required|xss_clean'
			),
                        array('field'   => 'bank_account_no',
			'label'   => 'Account No.',
			'rules'   => 'trim|required|integer|xss_clean'
			),
                        array('field'   => 'account_name',
			'label'   => 'Account Name',
			'rules'   => 'trim|required|xss_clean'
			),
                        array('field'   => 'bank_code',
			'label'   => 'Bank Code',
			'rules'   => 'trim|required|alpha|xss_clean'
			),
			array('field'   => 'bank_name',
			'label'   => 'Bank name',
			'rules'   => 'trim|required|xss_clean'
            		),
			array('field'   => 'bank_address',
			'label'   => 'Bank Address',
			'rules'   => 'trim|required|xss_clean'
			),
                        array('field'   => 'bank_micr',
			'label'   => 'Micr Code.',
			'rules'   => 'trim|required|integer|xss_clean'
			),
                        array('field'   => 'bank_ifsc',
			'label'   => 'IFSC.',
			'rules'   => 'trim|required|xss_clean'
			)
            
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $bank_id=$this->input->post('bank_id');
        
        if($bank_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
                $branch_name=$post_array['branch_name'];
                $bank_account_no=$post_array['bank_account_no'];
                $account_name=$post_array['account_name'];
                $bank_code=$post_array['bank_code'];
                $bank_name=$post_array['bank_name'];
                $bank_address=$post_array['bank_address'];
                $bank_micr=$post_array['bank_micr'];
                $bank_ifsc=$post_array['bank_ifsc'];
                
                $insert_array=array("branch_name"=>$branch_name,"bank_account_no"=>$bank_account_no,"account_name"=>$account_name,"bank_code"=>$bank_code,"bank_name"=>$bank_name,"bank_address"=>$bank_address,"bank_micr"=>$bank_micr,"bank_ifsc"=>$bank_ifsc,"inserted_by"=>$this->session->userdata("uid"),"inserted_datetime"=>date("Y-m-d H:i:s"));                                                                
                $this->db->insert("bank_master", $insert_array); 
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
                $bank_id=$this->input->post("bank_id");
                $this->data['bank_details']=array_shift($this->bank_model->get_bank_details($bank_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {        
              $branch_name=$post_array['branch_name'];
                $bank_account_no=$post_array['bank_account_no'];
                $account_name=$post_array['account_name'];
                $bank_code=$post_array['bank_code'];
                $bank_name=$post_array['bank_name'];
                $bank_address=$post_array['bank_address'];
                $bank_micr=$post_array['bank_micr'];
                $bank_ifsc=$post_array['bank_ifsc'];
                
                $update_array=array("branch_name"=>$branch_name,"bank_account_no"=>$bank_account_no,"account_name"=>$account_name,"bank_code"=>$bank_code,"bank_name"=>$bank_name,"bank_address"=>$bank_address,"bank_micr"=>$bank_micr,"bank_ifsc"=>$bank_ifsc,"updated_by"=>$this->session->userdata("uid"),"updated_datetime"=>date("Y-m-d H:i:s"));                                                                                 
                
                                
                $where=array("bank_id"=>$bank_id);
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
        $bank_details=  $this->bank_model->get_bank_details($para);                    
        echo json_encode(array("bank_details"=>$bank_details));
    } 
}
?>