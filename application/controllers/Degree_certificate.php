<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Degree_certificate extends CI_Controller 
{
    function __construct()
    {        
        parent::__construct();                     
       // $this->load->model('Certificate_model');
    }    
	public function view($prn)
    {
		$this->load->model('Certificate_model');
		$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents($prn);			
		$this->load->view('Certificate/degree_certificate_html',$this->data);

    }	
}