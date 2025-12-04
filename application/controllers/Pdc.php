<?php
/*ini_set("display_errors", "On");
error_reporting(1);*/
defined('BASEPATH') OR exit('No direct script access allowed');
define("MODEL_NM","pdc_model");
class Pdc extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="pdc_details";
    var $model_name="pdc_model";
    var $model;
    var $view_dir='Pdc/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        // /$this->load->helper("url");		
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        
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
        $this->data['pdc_details']= $this->pdc_model->get_pdc_details();                                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
    	/*ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);*/
        $this->load->view('header',$this->data);  
         $this->data['bank_details']= $this->pdc_model->bank_master();

        $this->load->view($this->view_dir.'add_pdc',$this->data);
        $this->load->view('footer');
    }

    public function serach_prn_student_master()
    {

    	    $bdat = $this->pdc_model->searchstudentmaster($_POST['prn']); 
    	    echo  json_encode($bdat); 

    }
    
    public function view()
    {
        $this->load->view('header',$this->data);        
        $this->data['pdc_details']=$this->pdc_model->get_pdc_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit_pdc($pdcid)
    {

        $this->load->view('header',$this->data);                
        //$pdc_id=$this->uri->segment(3);
         $this->data['bank_details']= $this->pdc_model->bank_master();
        $this->data['pdc_details']=$this->pdc_model->get_pdc_details_search($pdcid); 
       /* print_r($this->data['pdc_details']);
        die;*/

        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    } 

    public function disable()
    {
        $this->load->view('header',$this->data);                
        $pdc_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("pdc_id"=>$pdc_id);
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
        $pdc_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("pdc_id"=>$pdc_id);
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
                        array('field'   => 'pdc_code',
			'label'   => 'PDC Number',
			'rules'   => 'trim|required|alpha|xss_clean'
			),
			array('field'   => 'pdc_name',
			'label'   => 'PDC Number',
			'rules'   => 'trim|required|xss_clean'
			)
                        
			
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $pdc_id=$this->input->post('pdc_id');
        
        if($pdc_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
                $pdc_code=$this->input->post("pdc_code");    
                $pdc_name=$this->input->post("pdc_name");    
                //$pdc_type=$this->input->post("pdc_type");    
                //$duration=$this->input->post("duration");    
                
                $insert_array=array("pdc_short_name"=>$pdc_code,"pdc_name"=>$pdc_name,"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"));
                $DB1 = $this->load->database('umsdb', TRUE);                                                                
                $DB1->insert("pdc_master", $insert_array); 
                $last_inserted_id=$DB1->insert_id();                
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
                $pdc_id=$this->input->post("pdc_id");
                $this->data['pdc_details']=array_shift($this->pdc_model->get_pdc_details($pdc_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {        
                $pdc_id=$this->input->post("pdc_id");    
                $pdc_code=$this->input->post("pdc_code");    
                $pdc_name=$this->input->post("pdc_name");    
                //$pdc_type=$this->input->post("pdc_type");    
                //$duration=$this->input->post("duration"); 
                
                $update_array=array("pdc_short_name"=>$pdc_code,"pdc_name"=>$pdc_name,"modified_by"=>$this->session->userdata("uid"),"modified_by"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("pdc_id"=>$pdc_id);
                $DB1 = $this->load->database('umsdb', TRUE);
                $DB1->where($where);                
                if($DB1->update($this->table_name, $update_array))
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
        $pdc_details=  $this->pdc_model->get_pdc_details_search($para);                    
        echo json_encode(array("pdc_details"=>$pdc_details));
    } 

    public function submit_pdc()
    {
         /*   ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);*/
     
    	   $post_array=  $this->input->post();

        
       /* $config=array(
                        array('field'=> 'pdc_code',
			'label'   => 'PDC Number',
			'rules'   => 'trim|required|alpha|xss_clean'
			),
			array('field'   => 'pdc_name',
			'label'   => 'PDC Number',
			'rules'   => 'trim|required|xss_clean'
			)
              );*/

            if($_FILES['upload']['name']){
                

                $config['upload_path'] = 'uploads/student_document/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['upload']['name'];
                
                //Load upload library and initialize configuration
                  $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('upload')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];

                }else{
                    $picture = '';
                }
            }else{

                $picture = '';
            }
               

            $ss=$this->pdc_model->add_pdc($post_array,$picture);
           if($ss)
            {
                $this->session->set_flashdata('success', "Pdc Submited Successfully"); 
                
            }
            else
            {
                  $this->session->set_flashdata('error', "Somthing went wrong");
            }

            redirect(base_url($this->view_dir."view"));
    }

    public function edit_submit_pdc()
    {
            /*ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);*/
            $post_array=  $this->input->post();

       /* $config=array(
                        array('field'=> 'pdc_code',
            'label'   => 'PDC Number',
            'rules'   => 'trim|required|alpha|xss_clean'
            ),
            array('field'   => 'pdc_name',
            'label'   => 'PDC Number',
            'rules'   => 'trim|required|xss_clean'
            )
              );*/
                    if($_FILES['upload']['name']!=''){
                    $config['upload_path'] = 'uploads/student_document/';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['file_name'] = $_FILES['upload']['name'];
                    //Load upload library and initialize configuration
                    $this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('upload')){
                        $uploadData = $this->upload->data();
                        $picture = $uploadData['file_name'];

                    }
                else{
                        $picture = '';
                    }
                }else{

                    $picture = $post_array['upload1'];
                }
           
                $ss=$this->pdc_model->edit_pdc($post_array,$picture);
                if($ss)
                {
                    $this->session->set_flashdata('success', "Pdc Updated Successfully"); 
                    
                }
                else
                {
                      $this->session->set_flashdata('error', "Somthing went wrong");
                }
                redirect(base_url($this->view_dir."view"));
    }

    public function change_pdc_deposite_status($pdcid)
    {
         $ss=$this->pdc_model->change_pdc_status($pdcid,'deposite_status');
         if($ss)
        {
            $this->session->set_flashdata('success', "Pdc deposited Successfully"); 
            
        }
        else
        {
              $this->session->set_flashdata('error', "Somthing went wrong");
        }
        redirect(base_url($this->view_dir."view"));
    }
    public function delete_pdc($pdcid)
    {
        $ss=$this->pdc_model->delete_pdc_status($pdcid);
        if($ss)
        {
            $this->session->set_flashdata('success', "Pdc deleted Successfully"); 
            
        }
        else
        {
              $this->session->set_flashdata('error', "Somthing went wrong");
        }
        redirect(base_url($this->view_dir."view"));
    }
    public function submit_pdc_data()
    {
        $post_array=  $this->input->post();
        $ss=$this->pdc_model->Encash_pdc_status_remark($post_array);
        if($ss)
        {
            $this->session->set_flashdata('success', "Encash Status updated Successfully"); 
            
        }
        else
        {
              $this->session->set_flashdata('error', "Somthing went wrong");
        }
        redirect(base_url($this->view_dir."view"));
    }
    
}
?>