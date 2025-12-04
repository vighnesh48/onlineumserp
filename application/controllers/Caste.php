<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Caste extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="caste_master";
    var $model_name="caste_model";
    var $model;
    var $view_dir='Caste/';
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
        $this->data['caste_details']= $this->caste_model->get_caste_details();                                        
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
        $this->data['caste_details']=$this->caste_model->get_caste_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);                
        $caste_id=$this->uri->segment(3);
        $this->data['caste_details']=array_shift($this->caste_model->get_caste_details($caste_id));                            
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);               
        $caste_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("caste_id"=>$caste_id);
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
        $caste_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("caste_id"=>$caste_id);
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
                        array('field'   => 'caste_code',
			'label'   => 'Caste Code',
			'rules'   => 'trim|required|alpha|xss_clean'
			),
			array('field'   => 'caste_name',
			'label'   => 'Caste name',
			'rules'   => 'trim|required|xss_clean'
			)
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $caste_id=$this->input->post('caste_id');
        
        if($caste_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
                $caste_code=$this->input->post("caste_code");    
                $caste_name=$this->input->post("caste_name");   
                
                $insert_array=array("caste_code"=>$caste_code,"caste_name"=>$caste_name,"inserted_by"=>$this->session->userdata("uid"),"inserted_datetime"=>date("Y-m-d H:i:s"));                                                                
                $this->db->insert("caste_master", $insert_array); 
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
                $caste_id=$this->input->post("caste_id");
                $this->data['caste_details']=array_shift($this->caste_model->get_caste_details($caste_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {        
                $caste_id=$this->input->post("caste_id");    
                $caste_code=$this->input->post("caste_code");    
                $caste_name=$this->input->post("caste_name");  
                
                $update_array=array("caste_code"=>$caste_code,"caste_name"=>$caste_name,"updated_by"=>$this->session->userdata("uid"),"updated_datetime"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("caste_id"=>$caste_id);
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
        $caste_details=  $this->caste_model->get_caste_details($para);                    
        echo json_encode(array("caste_details"=>$caste_details));
    } 
	
	
	public function update_excel_newjoin()
	{
		
	$this->load->view('header',$this->data);
    $this->load->view($this->view_dir . 'update_excel_newjoin');
    $this->load->view('footer');
	}
	
			function upload_excel_newjoin_data()
			{
			$this->load->view('header',$this->data);
			$this->load->library('Excel');
			if($_POST){

			$path = $_FILES["ex_file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);

			foreach($object->getWorksheetIterator() as $worksheet)
			{   

			$highestRow = $worksheet->getHighestRow();
			$highestColumn = $worksheet->getHighestColumn();

			for($row=2; $row<=$highestRow; $row++){

			 $emp_id=$worksheet->getCellByColumnAndRow(2, $row)->getValue();
			$emp_new_id=$worksheet->getCellByColumnAndRow(1, $row)->getValue();
			$report_schl=$worksheet->getCellByColumnAndRow(4, $row)->getValue();
			 $report_dept=$worksheet->getCellByColumnAndRow(5, $row)->getValue();

			$emp_det=$this->db->query("select * from employee_reporting_master where  status = 'Y' and emp_code = $emp_id")->result_array();
			//echo'<pre>';
			//print_r($emp_det);exit;
			if(!empty($emp_det)){
			foreach ($emp_det as $val) {
			$rtm['emp_code']=$emp_new_id;
			//  $rtm['weekly_off']=$val['weekly_off'];
			//  $rtm['shift']=$val['shift'];
			//   $rtm['in_time']=$val['in_time'];
			// $rtm['out_time']=$val['out_time'];
			//   $rtm['report_school']=$report_schl;
			//  $rtm['report_department']=$report_dept;
			$rtm['route']=$val['route'];
			$rtm['report_person1']=$val['report_person1'];
			$rtm['report_person2']=$val['report_person2'];
			$rtm['report_person3']=$val['report_person3'];
			$rtm['report_person4']=$val['report_person4'];
			$rtm['status']='Y';
			$rtm['inserted_by']=$this->session->userdata("uid");
			$rtm['inserted_datetime']=date("Y-m-d H:i:s");
            $id_st=$this->db->query("select * from employee_reporting_master where  status = 'Y' and emp_code = $emp_new_id")->result_array();
			if(empty($id_st)){
			
			
			
			$result=$this->db->insert('employee_reporting_master',$rtm);
			
			
			}
			}
			}	   
			}
			}
			echo "<script>alert('Successfully Updated Data.')</script>";
			}

			$this->load->view($this->view_dir . 'update_excel_newjoin', $this->data);
			$this->load->view('footer');
			}
			
			
			
			
			
}
?>