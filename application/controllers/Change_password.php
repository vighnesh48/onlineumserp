<?php
ini_set("display_errors", "On");
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
define("MODEL_NM","course_model");
class Change_password extends CI_Controller 
{
    var $currentModule="Change_password";
    var $title="";
    var $table_name="Change_password";
    var $model_name="Login_model";
    var $model;
    var $view_dir='Course/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        $this->load->helper("url");		
        $this->load->library('form_validation');
        $this->load->library('session');
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
           $title=$this->master_arr['index'];
       
        
        $this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
        $this->load->model('Online_feemodel');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
        
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    
    public function index()
    {
        $this->load->view('header',$this->data);    
        //$this->data['course_details']= $this->course_model->get_course_details();
		$this->data['stdata']= $this->Online_feemodel->fetch_studentdata();                                
        $this->load->view('change_password',$this->data);
        $this->load->view('footer');
    }
    
    public function change_user_password()
    {
        $this->load->view('header',$this->data); 
        $this->load->library('form_validation');
        $rules = array(
            [
                'field' => 'old_password',
                'label' => 'Old Password',
                'rules' => 'required',
            ],
            [
                'field' => 'new_password',
                'label' => 'New Password',
                'rules' => 'callback_valid_password',
            ],
            [
                'field' => 'con_password',
                'label' => 'Confirm Password',
                'rules' => 'matches[new_password]',
            ],
        );
        
        $this->form_validation->set_rules($rules);
        $isValid = $this->form_validation->run();
        $_POST['uid'] = $this->session->userdata('uid');
        

        if($isValid){
            $this->data['change_status']= $this->Login_model->change_user_password($_POST);
            if (!empty($this->data['change_status'])) {
                if($this->data['change_status'] == '1') {
                    $this->session->set_flashdata('change_password_success', 'Your password has been changed successfully, You will be redirected to login form shortly !');
                    //redirect('login/logoff/');
                } else {
                    $this->session->set_flashdata('error', 'Old password is wrong.');    
                }   
            }
        }
        $this->load->view('change_password',$this->data);
        $this->load->view('footer');
    }   

   
	//Create strong password 
    public function valid_password($password = '')
    {
        $password = trim($password);

        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>ยง~]/';

        if (empty($password))
        {
            $this->form_validation->set_message('valid_password', 'The {field} field is required.');

            return FALSE;
        }

        if (preg_match_all($regex_lowercase, $password) < 1)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least one lowercase letter.');

            return FALSE;
        }

        if (preg_match_all($regex_uppercase, $password) < 1)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least one uppercase letter.');

            return FALSE;
        }

        if (preg_match_all($regex_number, $password) < 1)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must have at least one number.');

            return FALSE;
        }

        if (preg_match_all($regex_special, $password) < 1)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>ยง~'));

            return FALSE;
        }

        if (strlen($password) < 8)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least 8 characters in length.');

            return FALSE;
        }

        if (strlen($password) > 32)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field cannot exceed 32 characters in length.');

            return FALSE;
        }

        return TRUE;
    }
	function Update_email()
	{
		$_POST['uid'] = $this->session->userdata('uid');
		$this->data['change_status']= $this->Login_model->update_password($_POST); 
		redirect('Change_password');
	}

    public function env_test()
    {
       echo ENVIRONMENT;
       $this->Login_model->password_change_mail('1234');
       return "hello";
    }
}
?>