<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//ini_set('error_reporting', E_ALL);
class Circular extends CI_Controller 
{
   var $view_dir='Circular/';
   var $currentModule = "";
    function __construct()
    {        
        parent::__construct();                
        $this->load->helper("url");       
        $array=$this->session->all_userdata();          
             
        if(!$this->session->has_userdata('uid'))
        redirect('login'); 
       
		$this->currentModule = $this->uri->segment(1);
        $this->data['currentModule'] = $this->currentModule;
     $this->load->model('Circular_model');
    }
    public function index()
    {
       
		$this->load->view('header',$this->data);  
		//top all summary count
	$this->data['circulerlist'] = $this->Circular_model->get_circuler_list();
	   $this->load->view($this->view_dir.'view',$this->data);
		$this->load->view('footer');
    }
	
	
	public function add(){
		//ini_set('error_reporting', E_ALL);
		$this->load->view('header',$this->data);  

    $this->load->view($this->view_dir.'add',$this->data);
		$this->load->view('footer');
	}
    
    
	public function submit(){
		//print_r($_POST);exit;
		if(!empty($_FILES['fileatt']['name'])){
                  $filenm='Circular-'.$_FILES['fileatt']['name'];
                $config['upload_path'] = 'uploads/circular/';
                $config['allowed_types'] = 'pdf|jpg|jpeg|png|PhP';
                $config['overwrite']= TRUE;
                $config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('fileatt')){
                    $uploadData = $this->upload->data();
                    $_POST['fname'] = $uploadData['file_name'];
                  // array_push($picture,$uploadData['file_name']);
                }else{
                    $_POST['fname']="";
                }
            }
		 $ins = $this->Circular_model->insert_circuler_data($_POST);
if($ins=='1'){
$this->session->set_flashdata('message', 'Added Successfully');
				
				redirect('Circular');
}
	}

    public function edit($id){
		//ini_set('error_reporting', E_ALL);
		$this->load->view('header',$this->data);  
$this->data['cir_details'] = $this->Circular_model->get_circuler_list($id);
    $this->load->view($this->view_dir.'edit',$this->data);
		$this->load->view('footer');
	}
	 public function update_submit($id){
		//ini_set('error_reporting', E_ALL);
		if(!empty($_FILES['fileatt']['name'])){
                  $filenm='Circular-'.$_FILES['fileatt']['name'];
                $config['upload_path'] = 'uploads/circular/';
                $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                $config['overwrite']= TRUE;
                $config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('fileatt')){
                    $uploadData = $this->upload->data();
                    $_POST['fname'] = $uploadData['file_name'];
                  // array_push($picture,$uploadData['file_name']);
                }else{
                    $_POST['fname']="";
                }
            }
$up = $this->Circular_model->update_circuler_details($_POST);
if($up=='true'){
    $this->session->set_flashdata('message', 'Updated Successfully');
				}else{
	 $this->session->set_flashdata('message', 'Not Updated Successfully');				
				}
				redirect('Circular');
	}
    public function delete_circular($cid){
   $del = $this->Circular_model->get_delete_cirular($cid);
redirect('Circular');
    }
}
			