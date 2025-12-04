<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Exam_session extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="exam_session";
    var $model_name="examsession_model";
    var $model;
    var $view_dir='Exam_session/';
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
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==6){
		}else{
			redirect('home');
		}
		
    }
    
    public function index()
    {

      
        $this->load->view('header',$this->data);  
         $this->data['exam_session_details']=$this->examsession_model->get_exam_session_details();
          
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
        $this->data['exam_session_details']=$this->examsession_model->get_exam_session_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit($id)
    {
		//error_reporting(E_ALL);
        $this->load->view('header',$this->data);                
        $id=$this->uri->segment(3);
        $this->data['exam_session']=($this->examsession_model->get_exam_session_details($id));
		//print_r($this->data['exam_session']->exam_id);
        $this->data['ses_details']= $this->examsession_model->get_ex_ses_details($id);	
		//echo "<pre>";		
		//print_r($this->data['ses_details']);exit;
        $this->load->view($this->view_dir.'edit',$this->data);
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
        $id=$this->uri->segment(3);   
        $update_array=array("is_active"=>"Y");                                
        $where=array("exam_id"=>$id);
		$secondDB = $this->load->database('umsdb', TRUE);		
         
        $secondDB->where($where);
        
        if($secondDB->update($this->table_name, $update_array))
        {
            redirect(base_url($this->view_dir."view?error=0"));
        }
        else
        {
            redirect(base_url($this->view_dir."view?error=1"));
        }  
        $this->load->view('footer');
    }
    
	
	
	public function disableactive_for_exam()
    {
        $this->load->view('header',$this->data);                
        $id=$this->uri->segment(3);   
        $update_array=array("active_for_exam"=>"N");   
         $secondDB = $this->load->database('umsdb', TRUE);		
         $where=array("exam_id"=>$id);
         $secondDB ->where($where);
        
        if( $secondDB ->update($this->table_name, $update_array))
        {
            redirect(base_url($this->view_dir."view?error=0"));
        }
        else
        {
            redirect(base_url($this->view_dir."view?error=1"));
        }  
        $this->load->view('footer');
    }
    
    public function enableactive_for_exam()
    {
        $this->load->view('header',$this->data);                
        $id=$this->uri->segment(3);   
        $update_array=array("active_for_exam"=>"Y");                                
        $where=array("exam_id"=>$id);
		$secondDB = $this->load->database('umsdb', TRUE);		
         
        $secondDB->where($where);
        
        if($secondDB->update($this->table_name, $update_array))
        {
            redirect(base_url($this->view_dir."view?error=0"));
        }
        else
        {
            redirect(base_url($this->view_dir."view?error=1"));
        }  
        $this->load->view('footer');
    }
    
	
	 public function disableactive_for_reval()
    {
        $this->load->view('header',$this->data);                
        $id=$this->uri->segment(3);   
        $update_array=array("active_for_reval"=>"N");   
         $secondDB = $this->load->database('umsdb', TRUE);		
         $where=array("exam_id"=>$id);
         $secondDB ->where($where);
        
        if( $secondDB ->update($this->table_name, $update_array))
        {
            redirect(base_url($this->view_dir."view?error=0"));
        }
        else
        {
            redirect(base_url($this->view_dir."view?error=1"));
        }  
        $this->load->view('footer');
    }
    
    public function enableactive_for_reval()
    {
        $this->load->view('header',$this->data);                
        $id=$this->uri->segment(3);   
        $update_array=array("active_for_reval"=>"Y");                                
        $where=array("exam_id"=>$id);
		$secondDB = $this->load->database('umsdb', TRUE);		
         
        $secondDB->where($where);
        
        if($secondDB->update($this->table_name, $update_array))
        {
            redirect(base_url($this->view_dir."view?error=0"));
        }
        else
        {
            redirect(base_url($this->view_dir."view?error=1"));
        }  
        $this->load->view('footer');
    }
    
	 public function disableactive_for_result()
    {
        $this->load->view('header',$this->data);                
        $id=$this->uri->segment(3);   
        $update_array=array("active_for_result"=>"N");   
         $secondDB = $this->load->database('umsdb', TRUE);		
         $where=array("exam_id"=>$id);
         $secondDB ->where($where);
        
        if( $secondDB ->update($this->table_name, $update_array))
        {
            redirect(base_url($this->view_dir."view?error=0"));
        }
        else
        {
            redirect(base_url($this->view_dir."view?error=1"));
        }  
        $this->load->view('footer');
    }
    
    public function enableactive_for_result()
    {
        $this->load->view('header',$this->data);                
        $id=$this->uri->segment(3);   
        $update_array=array("active_for_result"=>"Y");                                
        $where=array("exam_id"=>$id);
		$secondDB = $this->load->database('umsdb', TRUE);		
         
        $secondDB->where($where);
        
        if($secondDB->update($this->table_name, $update_array))
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
    {   //error_reporting(E_ALL);
        $this->load->helper('security');
        $post_array=  $this->input->post();
        //echo "<pre>"; print_r($post_array); die;
        $config=array(                        
            array('field'   => 'exam_month',
            'label'   => 'Exam Month',
            'rules'   => 'trim|required'
            ),
			array('field'   => 'exam_year',
            'label'   => 'Exam Year',
            'rules'   => 'trim|required'
            ),
			array('field'   => 'exam_type',
            'label'   => 'Exam type',
            'rules'   => 'trim|required'
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
				$doesnot_exists=$this->examsession_model->check_already_exists($insert_array);
				if($doesnot_exists){
				$insert_array['exam_name']=$this->input->post('exam_month').'-'.$this->input->post('exam_year');
				$insert_array['academic_year']=$this->input->post('exam_year');
                unset($insert_array['exam_id']);		
                $insert_array['is_active']='Y';
                $last_inserted_id=$this->examsession_model->add_exam_session_details($insert_array);             
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
         /*   if ($this->form_validation->run() == FALSE)
            {
				
				$this->data['academic_year_details']= $this->academic_model->get_academic_year_details();
                $this->data['academic_session_details']=($this->academic_model->get_academic_session_details($year_id));				
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {  

                    $this->data['academic_session_details']=($this->academic_model->get_academic_session_details($year_id));	
					$this->data['academic_year_details']= $this->academic_model->get_academic_year_details();
                    $this->session->set_flashdata('message', 'Data already exists of these type');					
					$this->load->view('header',$this->data);        
					$this->load->view($this->view_dir.'add',  $this->data);
					$this->load->view('footer');		
              
                $update_array=$this->input->post();		
              $doesnot_exists=$this->academic_model->check_already_exists($update_array,$year_id);
			  
                if($doesnot_exists){
			    $update_array['session']='W-'.substr($this->input->post('academic_year'), 0, 4);
				if($this->input->post('academic_session')=="SUMMER"){
				$update_array['session']='S-'.substr($this->input->post('academic_year'), 0, 4);
				} 
				unset($update_array['year_id']);
                $affected_rows=$this->academic_model->update_session_details($update_array,$year_id); 
                if($affected_rows==1)
                {                    
                    redirect(base_url($this->view_dir."view?error=0"));
                }
                else
                {  
                    redirect(base_url($this->view_dir."view?error=1"));
                } 				
				}
                else{
					$this->data['academic_session_details']=($this->academic_model->get_academic_session_details($year_id));	
					$this->data['academic_year_details']= $this->academic_model->get_academic_year_details();
                    $this->session->set_flashdata('message', 'Data already exists of these type');					
					$this->load->view('header',$this->data);        
					$this->load->view($this->view_dir.'add',  $this->data);
					$this->load->view('footer');
				}
				
                
            }
			*/
        }      
    }  
    
    public function search()
    {        
        $para=$this->input->post("title");
        $state_details=  $this->state_model->get_state_details($para);                    
        echo json_encode(array("state_details"=>$state_details));
    } 
    public function update_exam_dates()
    {   //error_reporting(E_ALL);
        $this->load->helper('security');
        $post_array=  $this->input->post();
        //echo "<pre>"; print_r($post_array); die;
        $config=array(                        
            array('field'   => 'frm_open_date',
            'label'   => 'Exam form start date',
            'rules'   => 'trim|required'
            ),
			array('field'   => 'frm_end_date',
            'label'   => 'Exam from end date',
            'rules'   => 'trim|required'
            ),
			array('field'   => 'frm_latefee_date',
            'label'   => 'Exam form late fee date',
            'rules'   => 'trim|required'
            ),
			array('field'   => 'cia_start_date',
            'label'   => 'cia start date',
            'rules'   => 'trim|required'
            ),
			array('field'   => 'cia_end_date',
            'label'   => 'cia end date',
            'rules'   => 'trim|required'
            ),
            array('field'   => 'cia_start_date',
            'label'   => 'cia start date',
            'rules'   => 'trim|required'
            ),
			array('field'   => 'cia_end_date',
            'label'   => 'cia end date',
            'rules'   => 'trim|required'
            )
     );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $exam_id=$this->input->post('exam_id');
        

			
            if ($this->form_validation->run() == FALSE)
            {   
				$this->load->view('header',$this->data);     	
				$this->load->view($this->view_dir.'edit',$this->data);
				$this->load->view('footer');
            }
            else
            {    
		       //check for already_exits
			    
				
                $insert_array1=$this->input->post();
				$doesnot_exists=$this->examsession_model->check_already_exists_dates($insert_array1);
				//print_r($doesnot_exists);exit;
				if(empty($doesnot_exists)){
					//echo "inside1";exit;
				$insert_array['exam_id']=$this->input->post('exam_id');
				$insert_array['frm_open_date']=$this->input->post('frm_open_date');
				$insert_array['frm_end_date']=$this->input->post('frm_end_date');
				$insert_array['frm_latefee_date']=$this->input->post('frm_latefee_date');
				$insert_array['date_start']=$this->input->post('cia_start_date');
				$insert_array['date_end']=$this->input->post('cia_end_date');
				$insert_array['create_date']=date('Y-m-d H:i:s');
				$insert_array['created_by']=$this->session->userdata('um_id');
				$insert_array['status']='Y';
				
                $last_inserted_id=$this->examsession_model->add_exam_session_details_dates($insert_array);             
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
					//echo "outside";exit;
					$update_array['exam_id']=$this->input->post('exam_id');
					$update_array['frm_open_date']=$this->input->post('frm_open_date');
					$update_array['frm_end_date']=$this->input->post('frm_end_date');
					$update_array['frm_latefee_date']=$this->input->post('frm_latefee_date');
					$update_array['date_start']=$this->input->post('cia_start_date');
					$update_array['date_end']=$this->input->post('cia_end_date');
					$update_array['update_date']=date('Y-m-d H:i:s');
					$update_array['updated_by']=$this->session->userdata('um_id');
					$update_array['th_date_start']=$this->input->post('th_start_date');
                    $update_array['th_date_end']=$this->input->post('th_end_date');
					$last_inserted_id=$this->examsession_model->update_exam_session_details_dates($update_array);  
					
					$this->session->set_flashdata('message', 'Data updated successfully');
					redirect(base_url($this->view_dir."view?error=0"));				
				}
            }     
    } 
		public function disableactive_for_marksentry()
    {
        $this->load->view('header',$this->data);                
        $id=$this->uri->segment(3);   
        $update_array=array("active_for_marks_entry"=>"N");   
         $secondDB = $this->load->database('umsdb', TRUE);		
         $where=array("exam_id"=>$id);
         $secondDB ->where($where);
        
        if( $secondDB ->update($this->table_name, $update_array))
        {
            redirect(base_url($this->view_dir."view?error=0"));
        }
        else
        {
            redirect(base_url($this->view_dir."view?error=1"));
        }  
        $this->load->view('footer');
    }
    
    public function enableactive_for_marksentry()
    {
        $this->load->view('header',$this->data);                
        $id=$this->uri->segment(3);   
        $update_array=array("active_for_marks_entry"=>"Y");                                
        $where=array("exam_id"=>$id);
		$secondDB = $this->load->database('umsdb', TRUE);		
         
        $secondDB->where($where);
        
        if($secondDB->update($this->table_name, $update_array))
        {
            redirect(base_url($this->view_dir."view?error=0"));
        }
        else
        {
            redirect(base_url($this->view_dir."view?error=1"));
        }  
        $this->load->view('footer');
    }
	public function check_result_generated_or_not()
    {

      
        $this->load->view('header',$this->data);  
         $this->data['exam_session_details']=$this->examsession_model->check_result_generated_or_not();
          
        $this->load->view($this->view_dir.'view_results_not_generated',$this->data);
        $this->load->view('footer');
    }	
	public function exam_download()
    {
        $this->load->view('header',$this->data);        
        //$this->data['exam_session_details']=$this->examsession_model->get_exam_session_details();                
        $this->load->view($this->view_dir.'exam_download_view',$this->data);
        $this->load->view('footer');
    }
}
?>