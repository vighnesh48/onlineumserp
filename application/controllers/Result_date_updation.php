<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Result_date_updation extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="result_date_updation";
    var $model_name="Resultdateupdation_model";
    var $model;
    var $view_dir='Result_date_updation/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        date_default_timezone_set('Asia/Kolkata'); 
        $this->load->helper("url");     
        $this->load->library('form_validation');
		$this->load->library("session");
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);
       else
        $title=$this->master_arr['index'];
        $this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;     
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
       // $this->load->model(' Resultdateupdation_model');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		
    }
    
    public function indexOk()
    {

        $this->load->view('header',$this->data);  
         $this->data['exam_session_details']=$this->Resultdateupdation_model->get_exam_session_details();
          
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }

    public function index() {
		//echo 2;exit;
		$this->load->model('Resultdateupdation_model');
        $this->load->view('header', $this->data);  

        // Fetch all exam sessions
        $this->data['exam_sessions'] = $this->Resultdateupdation_model->fetch_stud_curr_exam();

        // Check if form submitted
        if ($this->input->post('exam_session')) {
            // If exam session selected, filter data
            $exam_session = $this->input->post('exam_session');
            $this->data['exam_session_details'] = $this->Resultdateupdation_model->get_exam_session_details($exam_session);
        } else {
            // Otherwise, get all data
            $this->data['exam_session_details'] = $this->Resultdateupdation_model->get_exam_session_details();
        }

        $this->load->view($this->view_dir . 'view', $this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
		
        $this->load->view('header',$this->data);     	
        $this->data['exam_session']= $this->Resultdateupdation_model->fetch_stud_curr_exam();
		$exam_id = $this->data['exam_session'][0]['exam_id'];
        //print_r($exam_id);exit;

        $this->data['school_details']=$this->Resultdateupdation_model->get_school_details();
        //print_r( $this->data['school_details']);exit;

        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');

      
    }

    public function edit($id)
    {
  
        $this->load->view('header', $this->data);
        
     
        $this->data['exam_session'] = $this->Resultdateupdation_model->get_exam_session_detailsOk($id);
        
     
        $this->data['exam_sessions'] = $this->Resultdateupdation_model->fetch_stud_curr_exam();
        
        
          $this->data['school_details'] = $this->Resultdateupdation_model->get_school_details();

        $this->load->view($this->view_dir . 'edit', $this->data);
        
        
        $this->load->view('footer');
    }
    
    

    public function submit()
    {
        $this->load->helper('security');
        $post_array = $this->input->post();
        
        $exam_session_parts = explode('-', $post_array['exam_session']);
        $post_array['exam_month'] = $exam_session_parts[0]; 
        $post_array['exam_year'] = $exam_session_parts[1]; 
        $post_array['examId'] = $exam_session_parts[2];
        
     /*   $config = array(
            array(
                'field' => 'exam_session',
                'label' => 'Exam Month',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
               'field' => 'school',
               'label' => 'School',
               'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'start_date',
                'label' => 'Result Date Time',
                'rules' => 'trim|required|xss_clean'
            )
        );
        
        $this->form_validation->set_rules($config);
        */
		
        $exam_id = $this->input->post('exam_id');
        
        if ($exam_id == "") {
           // if ($this->form_validation->run() == FALSE) {
				// echo 4321;exit;
                // Validation failed, reload the form with errors
            //    $this->load->view('header', $this->data);
            //    $this->data['exam_session'] = $this->Resultdateupdation_model->fetch_stud_curr_exam();
            //    $this->data['school_details'] = $this->Resultdateupdation_model->get_school_details();
            //    $this->load->view($this->view_dir . 'add', $this->data);
            //    $this->load->view('footer');
         //   } else {
                // Validation passed, proceed to check and insert data
			//	echo 1234;exit;
                $does_not_exist = $this->Resultdateupdation_model->check_already_exists($post_array);
              //  print_r($does_not_exist);exit;
                if ($does_not_exist) {
                    // Data doesn't exist, proceed to insert
                    $post_array['exam_session'] = $exam_session_parts[0].'-'.$exam_session_parts[1].'-'.$exam_session_parts[2]; // Set exam month
                    $post_array['school'] = $this->input->post('school');
                    $post_array['start_date'] = $this->input->post('start_date');
                    unset($post_array['exam_id']);
                    $post_array['is_active'] = 'Y';
                    
                    // Insert into database
                    $last_inserted_id = $this->Resultdateupdation_model->add_exam_pubDate_details($post_array);
                    
                    if ($last_inserted_id) {
                        // Redirect to view if insertion is successful
                        redirect(base_url('Result_date_updation'));
                    } else {
                        // Redirect with error if insertion failed
                        redirect(base_url($this->view_dir . 'view?error=1'));
                    }
                } else {
					
                    // Data already exists, set flash message and reload the form
                    $this->session->set_flashdata('message', 'Data already exists of this type');
                    $this->load->view('header', $this->data);
                    $this->data['exam_session'] = $this->Resultdateupdation_model->fetch_stud_curr_exam();
                    $this->data['school_details'] = $this->Resultdateupdation_model->get_school_details();
                    $this->load->view($this->view_dir . 'add', $this->data);
                    $this->load->view('footer');
                }
           // }
        } else {
            // If exam_id is not empty, just reload the form
            $this->load->view('header', $this->data);
            $this->data['exam_session'] = $this->Resultdateupdation_model->fetch_stud_curr_exam();
            $this->data['school_details'] = $this->Resultdateupdation_model->get_school_details();
            $this->load->view($this->view_dir . 'add', $this->data);
            $this->load->view('footer');
        }
    }


    public function updateResultDateokkk()
{
    $this->load->helper('security');
    $post_array = $this->input->post();
    
    $exam_session_parts = explode('-', $post_array['exam_session']);
    $post_array['exam_month'] = $exam_session_parts[0]; 
    $post_array['exam_year'] = $exam_session_parts[1]; 
    $post_array['examId'] = $exam_session_parts[2];
    
    $config = array(
        array(
            'field' => 'exam_session',
            'label' => 'Exam Month',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'school',
            'label' => 'School',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'start_date',
            'label' => 'Result Date Time',
            'rules' => 'trim|required|xss_clean'
        )
    );
    
    $this->form_validation->set_rules($config);
    
    $exam_id = $this->input->post('exam_id');
    
    if ($this->form_validation->run() == FALSE) {
        // Validation failed, reload the form with errors
        $this->load->view('header', $this->data);
        $this->data['exam_session'] = $this->Resultdateupdation_model->get_exam_session_details($exam_id);
        $this->data['exam_sessions'] = $this->Resultdateupdation_model->fetch_stud_curr_exam();
        $this->data['school_details'] = $this->Resultdateupdation_model->get_school_details();
        // Pass the previously submitted data to the view
        $this->data['post_array'] = $post_array;
        $this->load->view($this->view_dir . 'edit', $this->data);
        $this->load->view('footer');
    } else {
        // Validation passed, check if data already exists
        $does_not_exist = $this->Resultdateupdation_model->check_already_exists($post_array, $exam_id);
        
        if ($does_not_exist) {
            // Data doesn't exist, proceed to update
            $post_array['exam_session'] = $exam_session_parts[0].'-'.$exam_session_parts[1].'-'.$exam_session_parts[2]; 
            $post_array['school'] = $this->input->post('school');
            $post_array['start_date'] = $this->input->post('start_date');
            unset($post_array['exam_id']);
           
            // Update database
            $result = $this->Resultdateupdation_model->update_exam_pubDate_details($exam_id, $post_array);
            
            if ($result) {
                redirect(base_url('Result_date_updation'));
            } else {
                redirect(base_url($this->view_dir . 'view?error=1'));
            }
        } else {
            // Data already exists, set flash message and reload the form
            $this->session->set_flashdata('message', 'Data already exists of this type');
            redirect(base_url($this->view_dir . 'edit/'.$exam_id)); // Redirect to edit page with exam_id
        }
    }
}

    public function updateResultDate()
{
    $this->load->helper('security');
    $post_array = $this->input->post();
    
    $exam_session_parts = explode('-', $post_array['exam_session']);
    $post_array['exam_month'] = $exam_session_parts[0]; 
    $post_array['exam_year'] = $exam_session_parts[1]; 
    $post_array['examId'] = $exam_session_parts[2];
    
    $config = array(
        array(
            'field' => 'exam_session',
            'label' => 'Exam Month',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'school',
            'label' => 'School',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'start_date',
            'label' => 'Result Date Time',
            'rules' => 'trim|required|xss_clean'
        )
    );
    
    $this->form_validation->set_rules($config);
    
    $exam_id = $this->input->post('exam_id');
   // print_r($exam_id);exit;
    
    if ($this->form_validation->run() == FALSE) {
        // Validation failed, reload the form with errors
        $this->load->view('header', $this->data);
        $this->data['exam_session'] = $this->Resultdateupdation_model->get_exam_session_details($exam_id);
        $this->data['exam_sessions'] = $this->Resultdateupdation_model->fetch_stud_curr_exam();
        $this->data['school_details'] = $this->Resultdateupdation_model->get_school_details();
        $this->load->view($this->view_dir . 'edit', $this->data);
        $this->load->view('footer');
    } else {
        // Validation passed, check if data already exists
        $does_not_exist = $this->Resultdateupdation_model->check_already_exists($post_array, $exam_id);
        
        if ($does_not_exist) {
            // Data doesn't exist, proceed to update
            $post_array['exam_session'] = $$exam_session_parts[0].'-'.$exam_session_parts[1].'-'.$exam_session_parts[2]; 
            $post_array['school'] = $this->input->post('school');
            $post_array['start_date'] = $this->input->post('start_date');
            unset($post_array['exam_id']);
           
            // Update database
            $result = $this->Resultdateupdation_model->update_exam_pubDate_details($exam_id, $post_array);
            
            if ($result) {
               
                redirect(base_url('Result_date_updation'));
            } else {
            
                redirect(base_url($this->view_dir . 'view?error=1'));
            }
        } else {
            // Data already exists, set flash message and reload the form
            $this->session->set_flashdata('message', 'Data already exists of this type');
            $this->load->view('header', $this->data);
            $this->data['exam_session'] = $this->Resultdateupdation_model->get_exam_session_details($exam_id);
            $this->data['exam_sessions'] = $this->Resultdateupdation_model->fetch_stud_curr_exam();
            $this->data['school_details'] = $this->Resultdateupdation_model->get_school_details();
            $this->load->view($this->view_dir . 'edit', $this->data);
            $this->load->view('footer');
        }
    }
}

    public function submitsss()
    {   //error_reporting(E_ALL);
      //  print_r($_POST);exit;
        $this->load->helper('security');
        $post_array=  $this->input->post();
        //echo "<pre>"; print_r($post_array); die;
        $config=array(                        
            array('field'   => 'exam_session',
            'label'   => 'Exam Month',
            'rules'   => 'trim|required|xss_clean'
            ),
			array('field'   => 'school',
            'label'   => 'Exam Year',
            'rules'   => 'trim|required|xss_clean'
            ),
			array('field'   => 'start_date',
            'label'   => 'ResultDateTime',
            'rules'   => 'trim|required|xss_clean'
            )
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $exam_id=$this->input->post('exam_id');
        
        if($exam_id=="")
        {
			
            if ($this->form_validation->run() == FALSE)
            {   
				$this->load->view('header',$this->data);     	
				$this->load->view($this->view_dir.'add',$this->data);
				$this->load->view('footer');
            }
            else
            {    
		       //check for already_exits
			    
				
                $insert_array=$this->input->post();
				$doesnot_exists=$this->Resultdateupdation_model->check_already_exists($insert_array);
				if($doesnot_exists){
				$insert_array['exam_session']=$this->input->post('exam_session');
				$insert_array['school']=$this->input->post('school');
                $insert_array['start_date']=$this->input->post('start_date');
                unset($insert_array['exam_id']);		
                $insert_array['is_active']='Y';
                $last_inserted_id=$this->Resultdateupdation_model->add_exam_pubDate_details($insert_array);             
                if($last_inserted_id)
                {
                    redirect(base_url($this->view_dir."view?error=0"));
                }
                else
                {
                    redirect(base_url($this->view_dir.'view?error=1'));
                }
				}    
				else{
					$this->session->set_flashdata('message', 'Data already exists of these type');
					$this->load->view('header',$this->data);     	
				    $this->load->view($this->view_dir.'add',$this->data);
				    $this->load->view('footer');				
				}
            }
        }
        else
        {
			
				$this->load->view('header',$this->data);     	
				$this->load->view($this->view_dir.'add',$this->data);
				$this->load->view('footer');
        }      
    }  


    public function view()
    {
        $this->load->view('header',$this->data);        
        $this->data['exam_session_details']=$this->Resultdateupdation_model->get_exam_session_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    

    public function disable()
    {
        $this->load->view('header',$this->data);                
        $id=$this->uri->segment(3);   
        $update_array=array("is_active"=>"N");   
         $secondDB = $this->load->database('umsdb', TRUE);		
         $where=array("exam_id"=>$id);
         $secondDB ->where($where);
        
        if( $secondDB ->update($this->table_name, $update_array))
        {
            redirect(base_url('Result_date_updation'));
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
        $id=$this->uri->segment(3);   
        $update_array=array("is_active"=>"Y");                                
        $where=array("exam_id"=>$id);
		$secondDB = $this->load->database('umsdb', TRUE);		
         
        $secondDB->where($where);
        
        if($secondDB->update($this->table_name, $update_array))
        {
            redirect(base_url('Result_date_updation'));
        }
        else
        {
            redirect(base_url($this->view_dir."view?error=1"));
        }  
        $this->load->view('footer');
    }
    

    public function submit11()
    {   //error_reporting(E_ALL);
        $this->load->helper('security');
        $post_array=  $this->input->post();
        //echo "<pre>"; print_r($post_array); die;
        $config=array(                        
            array('field'   => 'exam_month',
            'label'   => 'Exam Month',
            'rules'   => 'trim|required|xss_clean'
            ),
			array('field'   => 'exam_year',
            'label'   => 'Exam Year',
            'rules'   => 'trim|required|xss_clean'
            ),
			array('field'   => 'exam_type',
            'label'   => 'Exam type',
            'rules'   => 'trim|required|xss_clean'
            )
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $exam_id=$this->input->post('exam_id');
        
        if($exam_id=="")
        {
			
            if ($this->form_validation->run() == FALSE)
            {   
				$this->load->view('header',$this->data);     	
				$this->load->view($this->view_dir.'add',$this->data);
				$this->load->view('footer');
            }
            else
            {    
		       //check for already_exits
			    
                $insert_array=$this->input->post();
				$doesnot_exists=$this->Resultdateupdation_model->check_already_exists($insert_array);
				if($doesnot_exists){
				$insert_array['exam_name']=$this->input->post('exam_month').'-'.$this->input->post('exam_year');
				$insert_array['academic_year']=$this->input->post('exam_year');
                unset($insert_array['exam_id']);		
                $insert_array['is_active']='Y';
                $last_inserted_id=$this->Resultdateupdation_model->add_exam_session_details($insert_array);             
                if($last_inserted_id)
                {
                    redirect(base_url($this->view_dir."view?error=0"));
                }
                else
                {
                    redirect(base_url($this->view_dir.'view?error=1'));
                }
				}    
				else{
					$this->session->set_flashdata('message', 'Data already exists of these type');
					$this->load->view('header',$this->data);     	
				    $this->load->view($this->view_dir.'add',$this->data);
				    $this->load->view('footer');				
				}
            }
        }
        else
        {
			
				$this->load->view('header',$this->data);     	
				$this->load->view($this->view_dir.'add',$this->data);
				$this->load->view('footer');
        }      
    }  
    
  
}
?>