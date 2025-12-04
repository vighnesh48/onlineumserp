<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hostel extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="sf_hostel_master";
    var $model_name="hostel_model";
    var $model;
    var $view_dir='Hostel/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;

        parent:: __construct();
        
       
     //error_reporting(E_ALL);
//ini_set('display_errors', 1);
        $this->load->helper("url");		
        $this->load->helper("hostel_helper");		
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
         $this->load->model('Ums_admission_model');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    
    public function index()
    {
        $this->load->view('header',$this->data);        
        $this->data['hostel_details']=$this->hostel_model->get_hostel_details();
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
		$this->data['campus']= $this->hostel_model->getcampusname();             
        $this->data['state']= $this->hostel_model->getAllState(); 
		//echo "".print_r($this->data['hostel_details']);exit();
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
	
/*	 public function add()
    {
        $this->load->view('header',$this->data); 
         
		$this->data['state']= $this->hostel_model->getAllState();		
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }*/
	
	public function check_exists()
	{
		echo $status=$this->hostel_model->check_exists($_POST);
	}

	public function check_hcode_exist()
	{
		echo $status=$this->hostel_model->check_hcode_exist($_POST);
	}
	
	
	public function add_facility()
	{
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==17 || $this->session->userdata("role_id")==45){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);                   
        $this->data['facilities_types']= $this->hostel_model->get_facilities_types();
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
		$this->data['campus']= $this->hostel_model->getcampusname(); 
		$this->load->view($this->view_dir.'add_facility',$this->data);
        $this->load->view('footer');
	}
    
    public function view()
    {
        $this->load->view('header',$this->data);        
        $this->data['hostel_details']=$this->hostel_model->get_hostel_details();                
        $this->data['state']= $this->hostel_model->getAllState(); 
		//echo "".print_r($this->data['hostel_details']);exit();
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
	
	public function view_facilities()
    {
        $this->load->view('header',$this->data);                   
        $this->data['facilities_types']= $this->hostel_model->get_facilities_types();
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
		$this->load->view($this->view_dir.'view_facilities',$this->data);
        $this->load->view('footer');
    }
    
	
	public function edit_facility()
    {
		$sf_fc_id=$this->uri->segment(3);
        $this->load->view('header',$this->data);                   
        $this->data['facilities_types']= $this->hostel_model->get_facilities_types();
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
		$this->data['campus']= $this->hostel_model->getcampusname(); 
		$this->data['facilities_details']= array_shift($this->hostel_model->get_facilities_byid($sf_fc_id));
		$this->load->view($this->view_dir.'edit_facility',$this->data);
        $this->load->view('footer');
    }
	
	
  /*  public function edit()
    {
        $this->load->view('header',$this->data);                
        $hostel_id=$this->uri->segment(3);
        $this->data['hostel_details']=array_shift($this->hostel_model->get_hostel_details($hostel_id));
		$this->data['state']= $this->hostel_model->getAllState();                          
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }   */ 
    
    public function disable()
    {
		//echo "caleddddddddd";exit();
        $this->load->view('header',$this->data);                
        $host_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","modified_by"=>$this->session->userdata('uid'),"modified_on"=>date("Y-m-d H:i:s"));                                
        $where=array("host_id"=>$host_id);
        $this->db->where($where);
        
        if($this->db->update($this->table_name, $update_array))
        {
			$this->session->set_flashdata('message1','Selected Hostel Disabled Successfully.');
            redirect(base_url($this->view_dir));
        }
        else
        {
			$this->session->set_flashdata('message2','Selected Hostel Not Disabled Successfully.');
            redirect(base_url($this->view_dir));
        }  
        $this->load->view('footer');
    }
    
    public function enable()
    {
        $this->load->view('header',$this->data);                
        $host_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","modified_by"=>$this->session->userdata('uid'),"modified_on"=>date("Y-m-d H:i:s"));                                
        $where=array("host_id"=>$host_id);
        $this->db->where($where);
        
        if($this->db->update($this->table_name, $update_array))
        {
			$this->session->set_flashdata('message1','Selected Hostel Enabled Successfully.');
            redirect(base_url($this->view_dir));
        }
        else
        {
			$this->session->set_flashdata('message2','Selected Hostel Not Enabled Successfully.');
            redirect(base_url($this->view_dir));
        }  
        $this->load->view('footer');
    }
	
	public function disable_facility()
    {
		$this->load->view('header',$this->data);                
        $sf_fc_id=$this->uri->segment(3);
        $update_array=array("status"=>"N","modified_by"=>$this->session->userdata('uid'),"modified_on"=>date("Y-m-d H:i:s"));     
		$where=array("sffm_id"=>$sf_fc_id);
		$this->db->where($where); 

		if($this->db->update('sf_facility_fees_master', $update_array))
		{                    
			$this->session->set_flashdata('message1','Facility Details Are Disabled Successfully.');
			redirect(base_url($this->view_dir."view_facilities"));
		}
		else
		{  
			$this->session->set_flashdata('message2','Facility Details Not Disabled Successfully.');
			redirect(base_url($this->view_dir."view_facilities"));
		}
 
        $this->load->view('footer');
    }
    
    public function enable_facility()
    {
        $this->load->view('header',$this->data);                
        $sf_fc_id=$this->uri->segment(3);
        $update_array=array("status"=>"Y","modified_by"=>$this->session->userdata('uid'),"modified_on"=>date("Y-m-d H:i:s"));     
		$where=array("sffm_id"=>$sf_fc_id);
		$this->db->where($where); 

		if($this->db->update('sf_facility_fees_master', $update_array))
		{                    
			$this->session->set_flashdata('message1','Facility Details Are Enabled Successfully.');
			redirect(base_url($this->view_dir."view_facilities"));
		}
		else
		{  
			$this->session->set_flashdata('message2','Facility Details Not Enabled Successfully.');
			redirect(base_url($this->view_dir."view_facilities"));
		}
		 
        $this->load->view('footer');
    }
    
  /*  public function submit()
    {     
        $hostel_name=$this->input->post("hostel_name");
		$hostel_code=$this->input->post("hostel_code");    
		$hostel_type=$this->input->post("hostel_type");    
		$campus_id=$this->input->post("campus_id");    
		$tot_flr=$this->input->post("tot_flr");    
		$tot_rooms=$this->input->post("tot_rooms");    
		$tot_beds=$this->input->post("tot_beds");                    
		$h_area=$this->input->post("h_area");
		$h_address=$this->input->post("h_address");    
		$hstate_id=$this->input->post("hstate_id");    
		$hdistrict_id=$this->input->post("hdistrict_id"); 
		$hcity=$this->input->post("hcity");
		$hostel_pincode=$this->input->post("hostel_pincode");
        
		$this->load->helper('security');
		$config=array(
						array('field'   => 'hostel_code',
						'label'   => 'hostel code',
						'rules'   => 'trim|required|xss_clean|is_unique[sf_hostel_master.hostel_code]'
						)
					);
		//print_r($this->input->post()); die; 
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == FALSE)
		{                
			$this->load->view('header',$this->data);        
			$this->load->view($this->view_dir.'add',  $this->data);
			$this->load->view('footer');
		}
		else
		{
			$insert_array=array("in_campus"=>$campus_id,"hostel_name"=>$hostel_name,"hostel_code"=>$hostel_code,"hostel_type"=>$hostel_type,"no_of_floors"=>$tot_flr,"no_of_rooms"=>$tot_rooms,"no_of_beds"=>$tot_beds,"Area"=>$h_area,"Address"=>$h_address,"state_id"=>$hstate_id,"district_id"=>$hdistrict_id,"taluka_id"=>$hcity,"pincode"=>$hostel_pincode,"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"status"=>"Y");   
			
			$this->db->insert("sf_hostel_master", $insert_array); 
			
			//echo $this->db->last_query();exit();
			
			$last_inserted_id=$this->db->insert_id();                
			if($last_inserted_id)
			{
				$this->session->set_flashdata('message1','New Hostel Added Successfully.');
				redirect(base_url($this->view_dir));
			}
			else
			{
				$this->session->set_flashdata('message2','New Hostel Not Added Successfully.');
				redirect(base_url($this->view_dir.''));
			}
		}
		
		
    }  
    
	public function edit_submit()
    {               
        $hostel_name=$this->input->post("hostel_name");
		$hostel_code=$this->input->post("hostel_code");    
		$hostel_type=$this->input->post("hostel_type");    
		$campus_id=$this->input->post("campus_id");    
		$tot_flr=$this->input->post("tot_flr");    
		$tot_rooms=$this->input->post("tot_rooms");    
		$tot_beds=$this->input->post("tot_beds");                    
		$h_area=$this->input->post("h_area");
		$h_address=$this->input->post("h_address");    
		$hstate_id=$this->input->post("hstate_id");    
		$hdistrict_id=$this->input->post("hdistrict_id"); 
		$hcity=$this->input->post("hcity");
		$hostel_pincode=$this->input->post("hostel_pincode");
       
		//$cntrl_mthd=$this->uri->segment(2);
		$host_id=$this->uri->segment(3);
		$res=$this->hostel_model->check_hcode_exist($host_id,$hostel_code);
		if($res=="Duplicate hostel Code")
		{  
		$this->session->set_flashdata('message2','Duplicate Hostel Code So Details Not Updated Successfully.');
			redirect(base_url($this->view_dir));
		}
		else
		{
			//echo $host_id;exit();
			$update_array=array("in_campus"=>$campus_id,"hostel_name"=>$hostel_name,"hostel_code"=>$hostel_code,"hostel_type"=>$hostel_type,"no_of_floors"=>$tot_flr,"no_of_rooms"=>$tot_rooms,"no_of_beds"=>$tot_beds,"Area"=>$h_area,"Address"=>$h_address,"state_id"=>$hstate_id,"district_id"=>$hdistrict_id,"taluka_id"=>$hcity,"pincode"=>$hostel_pincode,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));   
			
			$where=array("host_id"=>$host_id);
			$this->db->where($where); 
			//$this->db->update($this->table_name, $update_array);
			//echo $this->db->last_query();exit();
			if($this->db->update($this->table_name, $update_array))
			{                    
				$this->session->set_flashdata('message1','Hostel Details Are Updated Successfully.');
				redirect(base_url($this->view_dir));
			}
			else
			{  
				$this->session->set_flashdata('message2','Hostel Details Are Not Updated Successfully.');
				redirect(base_url($this->view_dir));
			}
		
		}
    }  
	*/
	
		 public function add()
    {
        $this->load->view('header',$this->data); 
        $this->data['campus']= $this->hostel_model->getcampusname();
		$this->data['state']= $this->hostel_model->getAllState();		
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
        public function edit()
    {
        $this->load->view('header',$this->data);                
        $hostel_id=$this->uri->segment(3);
        $this->data['hostel_details']=array_shift($this->hostel_model->get_hostel_details($hostel_id));
		$this->data['state']= $this->hostel_model->getAllState();
		$this->data['campus']= $this->hostel_model->getcampusname();
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
        public function submit()
    {     // echo "heloooooo";exit(); 
        $hostel_name=$this->input->post("hostel_name");
		$hostel_code=$this->input->post("hostel_code");    
		$hostel_type=$this->input->post("hostel_type");   
		$hostel_ctype=$this->input->post("hostel_ctype");   
		$campus_name=$this->input->post("campus");    
		$campus_id=$this->input->post("campus_id");    
		$tot_flr=$this->input->post("tot_flr");    
		$tot_rooms=$this->input->post("tot_rooms");    
		$tot_beds=$this->input->post("tot_beds");  
		$actual_capacity=$this->input->post("actual_capacity");  
		$h_area=$this->input->post("h_area");
		$h_address=$this->input->post("h_address");    
		$hstate_id=$this->input->post("hstate_id");    
		$hdistrict_id=$this->input->post("hdistrict_id"); 
		$hcity=$this->input->post("hcity");
		$hostel_pincode=$this->input->post("hostel_pincode");
        
		$this->load->helper('security');
		$config=array(
						array('field'   => 'hostel_code',
						'label'   => 'hostel code',
						'rules'   => 'trim|required|is_unique[sf_hostel_master.hostel_code]'
						)
					);
		//print_r($this->input->post()); die; 
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == FALSE)
		{                
			$this->load->view('header',$this->data);        
			$this->load->view($this->view_dir.'add',  $this->data);
			$this->load->view('footer');
		}
		else
		{
			$insert_array=array("campus_name"=>$campus_name,"in_campus"=>$campus_id,"actual_capacity"=>$actual_capacity,"hostel_name"=>$hostel_name,
			"hostel_code"=>$hostel_code,"hostel_type"=>$hostel_type,"hostel_ctype"=>$hostel_ctype,"no_of_floors"=>$tot_flr,"no_of_rooms"=>$tot_rooms,"no_of_beds"=>$tot_beds,"Area"=>$h_area,"Address"=>$h_address,"state_id"=>$hstate_id,"district_id"=>$hdistrict_id,"taluka_id"=>$hcity,"pincode"=>$hostel_pincode,"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"status"=>"Y");   
			
			$this->db->insert("sf_hostel_master", $insert_array); 
			
			//echo $this->db->last_query();exit();
			
			$last_inserted_id=$this->db->insert_id();                
			if($last_inserted_id)
			{
				$this->session->set_flashdata('message1','New Hostel Added Successfully.');
				redirect(base_url($this->view_dir));
			}
			else
			{
				$this->session->set_flashdata('message2','New Hostel Not Added Successfully.');
				redirect(base_url($this->view_dir.''));
			}
		}
		
		
    }
	
	public function edit_submit()
    {               
        $hostel_name=$this->input->post("hostel_name");
		$hostel_code=$this->input->post("hostel_code");    
		$hostel_type=$this->input->post("hostel_type"); 
		$hostel_ctype=$this->input->post("hostel_ctype");  
		$campus_name=$this->input->post("campus"); 		
		$campus_id=$this->input->post("campus_id");    
		$tot_flr=$this->input->post("tot_flr");    
		$tot_rooms=$this->input->post("tot_rooms");    
		$tot_beds=$this->input->post("tot_beds");   
		$actual_capacity=$this->input->post("actual_capacity");  
		$h_area=$this->input->post("h_area");
		$h_address=$this->input->post("h_address");    
		$hstate_id=$this->input->post("hstate_id");    
		$hdistrict_id=$this->input->post("hdistrict_id"); 
		$hcity=$this->input->post("hcity");
		$hostel_pincode=$this->input->post("hostel_pincode");
       
		//$cntrl_mthd=$this->uri->segment(2);
		$host_id=$this->uri->segment(3);
		//$res=$this->hostel_model->check_hcode_exist($host_id,$hostel_code);
		//if($res=="Duplicate hostel Code")
		//{  
		//$this->session->set_flashdata('message2','Duplicate Hostel Code So Details Not Updated Successfully.');
		//	redirect(base_url($this->view_dir));
		//}
		//else 
		{
			//echo $host_id;exit();
			$update_array=array("campus_name"=>$campus_name,"in_campus"=>$campus_id,"actual_capacity"=>$actual_capacity,"hostel_name"=>$hostel_name,
			"hostel_type"=>$hostel_type,"hostel_ctype"=>$hostel_ctype,"no_of_floors"=>$tot_flr,"no_of_rooms"=>$tot_rooms,"no_of_beds"=>$tot_beds,
			"Area"=>$h_area,"Address"=>$h_address,"state_id"=>$hstate_id,"district_id"=>$hdistrict_id,"taluka_id"=>$hcity,"pincode"=>$hostel_pincode,
			"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));   
			//echo $host_id;exit();
			//print_r($update_array);
			//exit();
			$where=array("host_id"=>$host_id);
			$this->db->where($where); 
			//$this->db->update($this->table_name, $update_array);
			//echo $this->db->last_query();exit();
			if($this->db->update($this->table_name, $update_array))
			{                    
				$this->session->set_flashdata('message1','Hostel Details Are Updated Successfully.');
				redirect(base_url($this->view_dir));
			}
			else
			{  
				$this->session->set_flashdata('message2','Hostel Details Are Not Updated Successfully.');
				redirect(base_url($this->view_dir));
			}
		
		}
    }  
	
	public function edit_faci_submit()
	{
		$sf_fc_id=$this->input->post("fid");
		$academic=$this->input->post("academic");
		$faci_id=$this->input->post("faci_id");    
		//$category=$this->input->post("category");    
		$arr=explode("||",$this->input->post("category"));
		$category=$arr[0];
		$deposit=$this->input->post("deposit");    
		$fees=$this->input->post("fees");   
		//echo "sf_fc_id==".$faci_id;exit();
		$update_array=array("facility_type_id"=>$faci_id,"category_id"=>$category,"deposit"=>$deposit,"fees"=>$fees,"academic_year"=>$academic,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));   
			
		$where=array("sffm_id"=>$sf_fc_id);
		$this->db->where($where); 
		//$this->db->update($this->table_name, $update_array);
		//echo $this->db->last_query();exit();
		if($this->db->update('sf_facility_fees_master', $update_array))
		{                    
			$this->session->set_flashdata('message1','Facility Details Are Updated Successfully.');
			redirect(base_url($this->view_dir."view_facilities/".$academic."/".$faci_id));
		}
		else
		{  
			$this->session->set_flashdata('message2','Facility Details Not Updated Successfully.');
			redirect(base_url($this->view_dir."view_facilities/".$academic."/".$faci_id));
		}
	}
	
	public function add_faci_submit()
	{
		$academic=$this->input->post("academic");
		$faci_id=$this->input->post("faci_id");   
		$arr=explode("||",$this->input->post("category"));
		$category=$arr[0];
		$hostel_ctype=$this->input->post("hostel_ctype"); 
		$deposit=$this->input->post("deposit");    
		$fees=$this->input->post("fees");   
		
		$insert_array=array("facility_type_id"=>$faci_id,"category_id"=>$category,"deposit"=>$deposit,"fees"=>$fees,"academic_year"=>$academic,'hostel_ctype'=>$hostel_ctype,"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"status"=>"Y");   
			
		$this->db->insert("sf_facility_fees_master", $insert_array); 
		
		//echo $this->db->last_query();exit();
		
		$last_inserted_id=$this->db->insert_id();                
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Facility Details Added Successfully.');
			redirect(base_url($this->view_dir."view_facilities/".$academic."/".$faci_id));
			//redirect(base_url($this->view_dir."add_facility"));
		}
		else
		{
			$this->session->set_flashdata('message2','Facility Details Not Added Successfully.');
			redirect(base_url($this->view_dir."view_facilities/".$academic."/".$faci_id));
			//redirect(base_url($this->view_dir."add_facility"));
		}
	}
    
    public function search()
    {        
        $para=$this->input->post("title");
        $hostel_details=  $this->hostel_model->get_hostel_search_details($para);                    
        echo json_encode(array("hostel_details"=>$hostel_details));
    } 
	
	public function getnooffloor()
	{
		$host_id=$_REQUEST['host_id'];
		$where=" host_id = $host_id";
		$sql="select host_id,no_of_floors From sf_hostel_master $where ";
        $query = $this->db->query($sql);
        $flr= $query->result_array();
		//print_r($flr);exit;
		if(!empty($flr)){
			echo"<option value=''>Select Floor</option>";
			foreach($flr as $key=>$val){
				echo"<option value='".$flr[$key]['host_id']."'>".$flr[$key]['no_of_floors']."</option>";
			}		
		}
		
	}
	
	public function getallfailities()
	{
		$faci_id=$_REQUEST['faci_id'];
		$fc_dts=$this->hostel_model->getallfailities($_POST);
		$i=1;
		$ban='fa-ban';
		$check='fa-check';
		foreach($fc_dts as $val){
           	 echo '<tr>
					<td>'.$i.'</td>                                                                
					<td>'.$val["facility_name"].'</td>
					<td>'.$val["category_name"].'</td>
					<td>'.$val["deposit"].'</td>
					<td>'.$val["fees"].'</td>
					<td>'.$val["hostel_ctype"].'</td>
					<td>'.$val["academic_year"].'</td>
					<td>
					   <a title="Edit Hostel Details" class="btn btn-primary btn-xs" href="'.base_url($currentModule.$this->view_dir.'edit_facility/'.$val["sffm_id"]).'">Edit</a><!--<a href="'.base_url($currentModule.$this->view_dir.($val["status"]=="Y"?'disable_facility/'.$val["sffm_id"]:'enable_facility/'.$val["sffm_id"])).'"><i '.($val["status"]=="Y"?'class="fa '.$ban:'class="fa '.$check).'" title="'.($val["status"]=="Y"?'Disable':'Enable').'"></i></a>-->
				   </td>
				   </tr>';
				   //<a href="'.base_url($currentModule.$this->view_dir.'edit_flr_room_details/'.$val["host_id"]).'"><i class="fa fa-edit"></i></a>
			$i++;
        }
	}
	
	public function getinstutename()
	{
		if($_POST['org']=='SU')
		{
			$school_list=$this->hostel_model->get_su_program_detail($_POST);
			if(!empty($school_list)){
				echo"<option value=''>Select institute</option>";
				foreach($school_list as $val){
					echo"<option value='".$val['school_short_name']."'>".$val['school_short_name']."</option>";
				}		
			}
		}
		else
		{
			$school_list=$this->hostel_model->get_program_detail();
			if(!empty($school_list)){
				echo"<option value=''>Select institute</option>";
				foreach($school_list as $val){
					echo"<option value='".$val['college_name']."'>".$val['college_name']."</option>";
				}		
			}
		}
	}
	
	public function incharge_list()
	{
		if(isset($_GET['academic_year']))
			$this->data['academic_year']= $_GET['academic_year'];
		
		$this->load->view('header',$this->data);        
        $this->data['hostel_details']=$this->hostel_model->get_hostel_details();
		$this->data['academic_details']= $this->hostel_model->get_academic_details();          
		$this->data['academic_year']=$this->hostel_model->get_incharge_byacademic();
        $this->data['state']= $this->hostel_model->getAllState(); 
		//echo "".print_r($this->data['hostel_details']);exit();
        $this->load->view($this->view_dir.'view_inchrg',$this->data);
        $this->load->view('footer');
	}
	
	public function fetch_incharge_list()
	{
		//$faci_id=$_REQUEST['faci_id'];
			
		$inchrg_dts=$this->hostel_model->fetch_incharge_list($_POST);
		$i=1;
		$ban='fa-ban';
		$check='fa-check';
		foreach($inchrg_dts as $val){
           	 echo '<tr>
					<td>'.$i.'</td>                                                                
					<td>'.$val["hostel_name"].' - '.$val["hostel_code"].'</td>
					<td>'.$val["name"].'</td>
					<td>'.$val["responsibility"].'</td>
					<td>'.$val["office_mobile"].', '.$val["personal_mobile"].'</td>
					<td>
					   <a title="Edit Incharge Details" class="btn btn-primary btn-xs" href="'.base_url($currentModule.$this->view_dir.'edit_inchrg/'.$val["host_inch_id"]).'">Edit</a><a  class="btn btn-primary btn-xs" title="Delete Incharge Details" href="'.base_url($currentModule.$this->view_dir.'disable_inchrg/'.$val["host_inch_id"].'/'.$val["academic_year"]).'">delete</a>
				   </td>
				   </tr>';
				   //<a href="'.base_url($currentModule.$this->view_dir.'edit_flr_room_details/'.$val["host_id"]).'"><i class="fa fa-edit"></i></a>
			$i++;
        }
	}
	
	public function disable_inchrg()
    {
		//echo "caleddddddddd";exit();
        $this->load->view('header',$this->data);                
        
		$sf_room_id=$this->uri->segment(3);   
		$academic_year=$this->uri->segment(4);
        $update_array=array("is_active"=>"N","modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));                                
        $where=array("host_inch_id"=>$sf_room_id);
		
        $this->db->where($where);
        
        if($this->db->update('sf_hostel_incharge_details', $update_array))
        {
			$this->session->set_flashdata('message1','Selected Hostel In-Charge Details Deleted Successfully.');
            redirect(base_url($this->view_dir."incharge_list/".$academic_year));
        }
        else
        {
			$this->session->set_flashdata('message2','Selected Hostel In-Charge Details Not Deleted  Successfully.');
            redirect(base_url($this->view_dir."incharge_list/".$academic_year));
        }  
        $this->load->view('footer');
    }
	
	public function add_inchrg()
    {
        $this->load->view('header',$this->data); 
		$this->data['hostel_details']=$this->hostel_model->get_hostel_details(); 
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
		$this->data['designations']=$this->hostel_model->get_su_designation();
		$this->data['state']= $this->hostel_model->getAllState();		
        $this->load->view($this->view_dir.'add_inchrg',$this->data);
        $this->load->view('footer');
    }
	
	public function add_inchrg_submit()
	{
		$host_id=$this->input->post("hid");
		$h_code=$this->input->post("h_code");
		$inchrg_name=$this->input->post("inchrg_name");    
		$inchrg_address=$this->input->post("inchrg_address");    
		$hstate_id=$this->input->post("hstate_id");    
		$hdistrict_id=$this->input->post("hdistrict_id");    
		$hcity=$this->input->post("hcity");    
		$inchrg_pincode=$this->input->post("inchrg_pincode");                    
		$institute=$this->input->post("institute");
		$department=$this->input->post("department");    
		$designation=$this->input->post("designation");    
		$office=$this->input->post("office"); 
		$personal=$this->input->post("personal");
		$email=$this->input->post("email");
		$responsibility=$this->input->post("responsibility");
		$academic=$this->input->post("academic");
			$organisation=$this->input->post("Organization");
		
		$this->load->helper('security');
		$config=array(
						array('field'   => 'inchrg_name',
						'label'   => 'Incharger Name',
						'rules'   => 'trim|required|xss_clean|is_unique[sf_hostel_incharge_details.name]'
						)
					);
		//print_r($this->input->post()); die; 
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == FALSE)
		{                
			$this->load->view('header',$this->data); 
			$this->data['hostel_details']=$this->hostel_model->get_hostel_details(); 
			$this->data['state']= $this->hostel_model->getAllState();		
			$this->load->view($this->view_dir.'add_inchrg',$this->data);
			$this->load->view('footer');
		}
		else
		{
			$insert_array=array("host_id"=>$host_id,"organisation"=>$organisation,"hostel_code"=>$h_code,"name"=>$inchrg_name,"address"=>$inchrg_address,"state_id"=>$hstate_id,"district_id"=>$hdistrict_id,"taluka_id"=>$hcity,"pincode"=>$inchrg_pincode,"working_institute"=>$institute,"department"=>$department,"designation"=>$designation,"office_mobile"=>$office,"personal_mobile"=>$personal,"email"=>$email,"responsibility"=>$responsibility,"academic_year"=>$academic,"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>"Y");   
			
			$this->db->insert("sf_hostel_incharge_details", $insert_array); 
			
			//echo $this->db->last_query();exit();
			
			$last_inserted_id=$this->db->insert_id();                
			if($last_inserted_id)
			{
				$this->session->set_flashdata('message1','Incharger Details Added Successfully.');
				redirect(base_url($this->view_dir."incharge_list/".$academic));
			}
			else
			{
				$this->session->set_flashdata('message2','Incharger Details Not Added Successfully.');
				redirect(base_url($this->view_dir."incharge_list/".$academic));
			}
		}
	}
	
	public function get_inchrgr_detailsbyhid()
	{
		$host_id=$_REQUEST['h_id'];
		$rm_dts=$this->hostel_model->get_inchrgr_detailsbyhid($host_id);
		//echo base_url($currentModule.$this->view_dir);exit();
		$i=1;
		$ban='fa-ban';
		$check='fa-check';
		foreach($rm_dts as $val){
           	 echo '<tr>
					<td>'.$i.'</td>                                                                
					<td>'.$val["hostel_name"].' - '.$val["hostel_code"].'</td>
					<td>'.$val["name"].'</td>
					<td>'.$val["responsibility"].'</td>
					<td>'.$val["office_mobile"].', '.$val["personal_mobile"].'</td>
					<td>
					   <a href="'.base_url($currentModule.$this->view_dir.'edit_inchrg/'.$val["host_inch_id"]).'"><i class="fa fa-edit"></i></a><a href="'.base_url($currentModule.$this->view_dir.($val["is_active"]=="Y"?'disable_inchrg/'.$val["host_inch_id"]:'enable_inchrg/'.$val["host_inch_id"])).'"><i '.($val["is_active"]=="Y"?'class="fa '.$ban:'class="fa '.$check).'" title="'.($val["is_active"]=="Y"?'Disable':'Enable').'"></i></a>
				   </td>
				   </tr>';
				   //<a href="'.base_url($currentModule.$this->view_dir.'edit_flr_room_details/'.$val["host_id"]).'"><i class="fa fa-edit"></i></a>
			$i++;
        }
	}
	
	public function edit_inchrg()
	{
		$this->load->view('header',$this->data);                
        $inchrgr_id=$this->uri->segment(3);
		//$hostel_id=$this->uri->segment(3);
        $this->data['hostel_details']= $this->hostel_model->get_hostel_details();
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
		$this->data['designations']=$this->hostel_model->get_su_designation();
        $this->data['inchrgr_details']=array_shift($this->hostel_model->get_inchrgr_details($inchrgr_id));
		$this->data['state']= $this->hostel_model->getAllState();                          
        $this->load->view($this->view_dir.'edit_inchrg',$this->data);
        $this->load->view('footer');
	}
	public function edit_inchrg_submit()
	{
		//echo "helllllloo";exit();
		$host_id=$this->input->post("hid");
		$h_code=$this->input->post("h_code");
		$inchrg_name=$this->input->post("inchrg_name");    
		$inchrg_address=$this->input->post("inchrg_address");    
		$hstate_id=$this->input->post("hstate_id");    
		$hdistrict_id=$this->input->post("hdistrict_id");    
		$hcity=$this->input->post("hcity");    
		$inchrg_pincode=$this->input->post("inchrg_pincode");                    
		$institute=$this->input->post("institute");
		$department=$this->input->post("department");    
		$designation=$this->input->post("designation");    
		$office=$this->input->post("office"); 
		$personal=$this->input->post("personal");
		$email=$this->input->post("email");
		$responsibility=$this->input->post("responsibility");
		$academic=$this->input->post("academic");
       
		//$cntrl_mthd=$this->uri->segment(2);
		$host_inch_id=$this->uri->segment(3);
		$update_array=array("name"=>$inchrg_name,"address"=>$inchrg_address,"state_id"=>$hstate_id,"district_id"=>$hdistrict_id,"taluka_id"=>$hcity,"pincode"=>$inchrg_pincode,"working_institute"=>$institute,"department"=>$department,"designation"=>$designation,"office_mobile"=>$office,"personal_mobile"=>$personal,"email"=>$email,"responsibility"=>$responsibility,"academic_year"=>$academic,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));   
		
		$where=array("host_inch_id"=>$host_inch_id);
		$this->db->where($where); 
		//$this->db->update($this->table_name, $update_array);
		//echo $this->db->last_query();exit();
		if($this->db->update('sf_hostel_incharge_details', $update_array))
		{                    
			$this->session->set_flashdata('message1','Incharger Details Are Updated Successfully.');
			redirect(base_url($this->view_dir."incharge_list/".$academic));
		}
		else
		{  
			$this->session->set_flashdata('message2','Incharger Details Are Not Updated Successfully.');
			redirect(base_url($this->view_dir."incharge_list/".$academic));
		}
		
	}

	
	public function view_rms_details()
    {
		if(isset($_GET['id']))
			$this->data['id']= $_GET['id'];

        $this->load->view('header',$this->data);                   
        $this->data['hostel_details']= $this->hostel_model->get_hostel_details();
		$this->load->view($this->view_dir.'view_room_details',$this->data);
        $this->load->view('footer');
    }
	
	public function view_student()
	{
		//$sf_std_id=$this->uri->segment(3);
		if(isset($_GET['academic']))
			$this->data['academic']= $_GET['academic'];
		if(isset($_GET['campus']))
			$this->data['campus_name']= $_GET['campus'];
		
		$this->load->view('header',$this->data); 
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
		$this->data['campus']= $this->hostel_model->getcampusname();
        $this->load->view($this->view_dir.'view_student',$this->data);
        $this->load->view('footer');
		
	}
	
	public function get_all_sf_students()
	{
		$fc_dts=$this->hostel_model->get_all_std_details($_POST);
		$i=1;
		$ban='fa-ban';
		$check='fa-check';
		$gender='';
		foreach($fc_dts as $val){
			
			///*<a href="'.base_url($currentModule.($val["status"]=="0"?'/disable_student/'.$val["student_id"]:'/enable_student/'.$val["student_id"])).'"><i class="fa '.$val["status"]=="0"?'fa-ban':'fa-check'" title="'.$val["status"]=="0"?"Disable":"Enable".'"></i></a>*/
			if($val["gender"]=="M")
				$gender='Male';
			else
				$gender='Female';
			
           	 echo '<tr>
					 <td>'.$i.'</td>
					  <td>'.$val["enrollment_no_new"].'</td>
					 <td>'.$val["enrollment_no"].'</td>
					 <td>'.$val["first_name"].' '.$val["middle_name"].' '.$val["last_name"].'</td>
					<td>'.$val["gender"].'</td>
					<td>'.$val["organization"].' - '.$val["instute_name"].'</td>
					<td>'.$val["course_name"].' - '.$val["stream_name"].'</td>
					<td>'.$val["current_year"].'</td>
					<td>'.$val["mobile"].'</td>
					<td>
					
					<a href="'.base_url($currentModule.$this->view_dir.'edit_student/'.$val['student_id'].'/'.$val['academic_year']).'"><i class="fa fa-edit"></i></a>
					
					 <a href="'.base_url($currentModule.$this->view_dir.($val["status"]=="0"?'disable_student/'.$val["student_id"]:'enable_student/'.$val["student_id"])).'"><i '.($val["status"]=="0"?'class="fa '.$ban:'class="fa '.$check).'" title="'.($val["status"]=="0"?'Disable':'Enable').'"></i></a>
				   </td>
				   </tr>';
				  
			$i++;
        }
	}
	
	public function add_student()
    {
        $this->load->view('header',$this->data); 
		$this->data['campus']= $this->hostel_model->getcampusname();
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
        $this->data['program_detail']=$this->hostel_model->get_program_detail();
		$this->data['state']= $this->hostel_model->getAllState();		
        $this->load->view($this->view_dir.'add_student',$this->data);
        $this->load->view('footer');
    }
	
	
	public function get_institutes_by_campus()
	{
	    echo $this->hostel_model->get_institutes_by_campus($_POST['campus']);
	}
		
	public function getprogrambycollegename()
	{
		$college_name=$_REQUEST['college'];
		//echo $college_name;exit();
		$college=$this->hostel_model->getprogrambycollegename($college_name);
		//print_r($dist);exit;
		if(!empty($college)){
			echo"<option value=''>Select Program</option>";
			foreach($college as $key=>$val){
				echo"<option value='".$college[$key]['sf_program_id']."'>".$college[$key]['course_short_name']."</option>";
			}		
		}
	}
	
	public function checking_enroll_acyear_exists($enroll,$acyear)
	{
		return $this->hostel_model->checking_enroll_acyear_exists($enroll,$acyear);
	}
	
	public function add_student_submit()
	{

		$campus=$this->input->post("campus");
		$instute_name=$this->input->post("college_name");
		$program_id=$this->input->post("program");    
		$admission_session=$this->input->post("dmission"); 
		$academic_year=$this->input->post("academic");
		$enrollment_no=$this->input->post("enrollment_no");
		$first_name=$this->input->post("fname");
		$middle_name=$this->input->post("mname");
		$last_name=$this->input->post("lname");
		$gender=$this->input->post("gender");
		$address=$this->input->post("address");
		$hstate_id=$this->input->post("hstate_id");    
		$hdistrict_id=$this->input->post("hdistrict_id");    
		$hcity=$this->input->post("hcity"); 
		$state=$this->input->post("state");    
		$district=$this->input->post("district");    
		$city=$this->input->post("city");		
		$pincode=$this->input->post("pincode");                    
		$mobile=$this->input->post("mobile");
		$email=$this->input->post("email");    
		$parent_mobile1=$this->input->post("pmobile");    
		$parent_mobile2=$this->input->post("pmobile2"); 
		$provisional=$this->input->post("provisional");
		$current_year=$this->input->post("current_year");
				
		$this->load->helper('security');
		$config=array(
						array('field'   => 'enrollment_no',
						'label'   => 'enrollment_no',
						'rules'   => 'trim|required|xss_clean|callback_checking_enroll_acyear_exists[' . $_POST['enrollment_no'] .']'
						)
					);

		//print_r($this->input->post()); die; 
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == FALSE)
		{                
			$this->add_student();
		}
		else
		{
			//"aadhar"=>$aadhar,
			if($campus=="NASHIK")
			{
			   $org ='SF'; 
			}
			else
			{
		    $org ='SF-SIJOUL'; 	    
			}
			
			
			$insert_array=array("campus_name"=>$campus,"organization"=>$org,"instute_name"=>$instute_name,"program_id"=>$program_id,"admission_session"=>$admission_session,"academic_year"=>$academic_year,"enrollment_no"=>$enrollment_no,"first_name"=>$first_name,"middle_name"=>$middle_name,"last_name"=>$last_name,"gender"=>$gender,"Address"=>$address,"state_id"=>$hstate_id,"district_id"=>$hdistrict_id,"taluka_id"=>$hcity,"state"=>$state,"district"=>$district,"taluka"=>$city,"pincode"=>$pincode,"mobile"=>$mobile,"email"=>$email,"parent_mobile1	"=>$parent_mobile1,"parent_mobile2"=>$parent_mobile2,"is_provisional"=>$provisional,"current_year"=>$current_year,"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"status"=>"Y");  

			//print_r($insert_array); die; 
			$this->db->insert("sf_student_master", $insert_array); 
			
			//echo $this->db->last_query();exit();
			
			$last_inserted_id=$this->db->insert_id();                
			if($last_inserted_id)
			{
				$this->session->set_flashdata('message1','Student Details Added Successfully.');
				redirect(base_url($this->view_dir."view_student"));
			}
			else
			{
				$this->session->set_flashdata('message2','Student Details Not Added Successfully.');
				redirect(base_url($this->view_dir."view_student"));
			}
		}
	}
	
	public function edit_student()
	{
	            
		//   error_reporting(E_ALL);
		//ini_set('display_errors', 1);
		$sf_std_id=$this->uri->segment(3);
		$this->load->view('header',$this->data); 
		$this->data['student_details']= array_shift($this->hostel_model->get_std_details_byid($sf_std_id));	
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
		$dat = $this->hostel_model->get_std_details_byid($sf_std_id);
		$this->data['program_detail']=$this->hostel_model->get_program_detail($dat[0]['campus_name']);

		$this->data['state']= $this->hostel_model->getAllState();
		//$this->data['student_details']= array_shift($this->hostel_model->get_std_details_byid($sf_std_id));		
		$this->data['campus']= $this->hostel_model->getcampusname();
		$this->load->view($this->view_dir.'edit_student',$this->data);
		$this->load->view('footer');
		
	}
	
	public function check_enroll_exists($enroll,$std_id){
        
        $sql="select COUNT(distinct enrollment_no) as count_rows From sf_student_master WHERE enrollment_no='$enroll' AND student_id !=$std_id;";
		
		//echo $sql.$where;exit();
        $query = $this->db->query($sql);
		$check =  $query->row()->count_rows;
        if ($check ==1){
            $this->form_validation->set_message('check_enroll_exists', 'The enrollment value already exist, please try another.');
            return false;
        }else{
            return true;
        }
    }
	
	public function edit_student_submit()
	{			//var_dump($_POST);exit();
		$std_id=$this->uri->segment(3);
		$campus=$this->input->post("campus");
		$instute_name=$this->input->post("college_name");
		$program_id=$this->input->post("program");    
		$admission_session=$this->input->post("dmission"); 
		$academic_year=$this->input->post("academic");
		$enrollment_no=$this->input->post("enrollment_no");
		$first_name=$this->input->post("fname");
		$middle_name=$this->input->post("mname");
		$last_name=$this->input->post("lname");
		$gender=$this->input->post("gender");
		$address=$this->input->post("address");
		$hstate_id=$this->input->post("hstate_id");    
		$hdistrict_id=$this->input->post("hdistrict_id");    
		$hcity=$this->input->post("hcity"); 
		$state=$this->input->post("state");    
		$district=$this->input->post("district");    
		$city=$this->input->post("city");		
		$pincode=$this->input->post("pincode");                    
		$mobile=$this->input->post("mobile");
		$email=$this->input->post("email");    
		$parent_mobile1=$this->input->post("pmobile");    
		$parent_mobile2=$this->input->post("pmobile2"); 
		$aadhar=$this->input->post("aadhar");
		$provisional=$this->input->post("provisional");
		$current_year=$this->input->post("current_year");

		if($campus=="NASHIK")
			{
			   $org ='SF'; 
			}
			else
			{
		    $org ='SF-SIJOUL'; 	    
			}
			

			$update_array=array("campus_name"=>$campus,"organization"=>$org,"instute_name"=>$instute_name,"program_id"=>$program_id,"admission_session"=>$admission_session,"academic_year"=>$academic_year,"enrollment_no"=>$enrollment_no,"first_name"=>$first_name,"middle_name"=>$middle_name,"last_name"=>$last_name,"gender"=>$gender,"Address"=>$address,"state_id"=>$hstate_id,"district_id"=>$hdistrict_id,"taluka_id"=>$hcity,"state"=>$state,"district"=>$district,"taluka"=>$city,"pincode"=>$pincode,"mobile"=>$mobile,"email"=>$email,"parent_mobile1	"=>$parent_mobile1,"parent_mobile2"=>$parent_mobile2,"is_provisional"=>$provisional,"current_year"=>$current_year,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));   
			//print_r($update_array); die;
			$where=array("student_id"=>$std_id);
			$this->db->where($where); 
			//$this->db->update('sf_student_master', $update_array);
			//echo $this->db->last_query();exit();
			if($this->db->update('sf_student_master', $update_array))
			{                    
				$this->session->set_flashdata('message1','Student Details Are Updated Successfully.');
				redirect(base_url($this->view_dir."edit_student/".$std_id."/".$academic_year));
			}
			else
			{  
				$this->session->set_flashdata('message2','Student Details Are Not Updated Successfully.');
				redirect(base_url($this->view_dir."edit_student/".$std_id."/".$academic_year));
			}
			
		/* $this->load->helper('security');
		$config=array(
						array('field'   => 'enrollment_no',
						'label'   => 'enrollment_no',
						'rules'   => 'trim|required|xss_clean|callback_checking_enroll_acyear_exists[' . $_POST['enrollment_no'] . ','.$std_id.']'
						)
					);
		
		//print_r($this->input->post()); die; 
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == FALSE)
		{                
			//$this->edit_student();
		$this->session->set_flashdata('message2','The enrollment value already exist, please try another.');
				redirect(base_url($this->view_dir."edit_student/".$std_id));
		}
		else
		{
		    
		    
		    

			
			
			
		} */
	}
	
	public function disable_student()
    {
		$this->load->view('header',$this->data);                
        $sf_std_id=$this->uri->segment(3);
        $update_array=array("status"=>"1","modified_by"=>$this->session->userdata('uid'),"modified_on"=>date("Y-m-d H:i:s"));     
		$where=array("student_id"=>$sf_std_id);
		$this->db->where($where); 

		if($this->db->update('sf_student_master', $update_array))
		{                    
			$this->session->set_flashdata('message1','Student Details Are Disabled Successfully.');
			redirect(base_url($this->view_dir."view_student"));
		}
		else
		{  
			$this->session->set_flashdata('message2','Student Details Not Disabled Successfully.');
			redirect(base_url($this->view_dir."view_student"));
		}
 
        $this->load->view('footer');
    }
    
    public function enable_student()
    {
        $this->load->view('header',$this->data);                
        $sf_std_id=$this->uri->segment(3);
        $update_array=array("status"=>"0","modified_by"=>$this->session->userdata('uid'),"modified_on"=>date("Y-m-d H:i:s"));     
		$where=array("student_id"=>$sf_std_id);
		$this->db->where($where); 

		if($this->db->update('sf_student_master', $update_array))
		{                    
			$this->session->set_flashdata('message1','Student Details Are Enabled Successfully.');
			redirect(base_url($this->view_dir."view_student"));
		}
		else
		{  
			$this->session->set_flashdata('message2','Student Details Not Enabled Successfully.');
			redirect(base_url($this->view_dir."view_student"));
		}
		 
        $this->load->view('footer');
    }
	
	public function view_std_payment()
{
    
 //   error_reporting(E_ALL);
//ini_set('display_errors', 1);
    $sf_std_id=$this->uri->segment(3);
    $this->data['stud_details']['enrollment_no']= str_replace("_","/",$this->uri->segment(3));//$this->uri->segment(3);
    $this->data['stud_details']['student_id']=$this->uri->segment(4);
    $this->data['stud_details']['org']=$this->uri->segment(5);
    $this->data['stud_details']['academic_year']=$this->uri->segment(6);
    
    $this->load->view('header',$this->data); 
    $this->data['academic_details']= $this->hostel_model->get_academic_details();
    $this->data['canteen_id']= $this->hostel_model->get_canteen_detail($this->data['stud_details']['enrollment_no'],$this->data['stud_details']['academic_year']);
    $this->data['canteen_details']= $this->hostel_model->get_all_canteens();
    // $this->data['canteen_name']= $this->hostel_model->get_canteen_name($this->data['canteen']);
    // print_r($this->data['canteen_name']); die;		
   // $this->data['program_detail']=$this->hostel_model->get_program_detail();
    //$this->data['state']= $this->hostel_model->getAllState();
    $this->data['student_details']= array_shift($this->hostel_model->get_hostelfee_details($this->data['stud_details']));
    $this->data['bank_details']= $this->hostel_model->getbanks();
    $this->data['installment']= $this->hostel_model->fetch_hostelfee_details($this->data['stud_details']);
    
    $this->data['canc']= $this->hostel_model->get_student_canc($this->data['stud_details']['enrollment_no']);
    
    $this->data['total_fees']= $this->hostel_model->total_fee_paid($this->data['stud_details']);
        
//	$this->data['installments'] = $this->hostel_model->student_paid_fees();
    $this->data['stud_faci_details']= $this->hostel_model->get_std_fc_details_byid($this->data['stud_details']);
    $this->load->view($this->view_dir.'view_std_payment',$this->data);
    $this->load->view('footer');
}
	
	public function getcoursename_by_prgmid()
	{
		$prgm_id=$_REQUEST['prgm_id'];
		$academic_year=$_REQUEST['academic_year'];
		//echo $college_name;exit();
		$course=$this->hostel_model->getcoursename_by_prgmid($prgm_id,$academic_year);
		echo $course;
		
	}
	
	// insert Refund_payment installment
	public function Refund_payment()
    {
		//print_r($_FILES);exit;
        $stud_id= $_POST['rstud_id'];
		$enroll= $_POST['renrollment_no'];
		$org= $_POST['rorg'];
		$acyear= $_POST['racyear'];
		$no_of_installment =1;
		if(!empty($_FILES['rpayfile']['name'])){
			$filenm=$stud_id.'-'.$no_of_installment.'-'.$_FILES['rpayfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('rpayfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
		
		//echo "calling";exit();
        $last_inserted_id= $this->hostel_model->Refund_payment($_POST,$payfile );
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Refund Fee Details Added Successfully.');
			redirect(base_url($this->view_dir."view_std_payment/".str_replace("/","_",$enroll)."/".$stud_id."/".$org."/".$acyear));
		}
		else
		{
			$this->session->set_flashdata('message2','Refund Fee Details Not Added Successfully.');
			redirect(base_url($this->view_dir."view_std_payment/".str_replace("/","_",$enroll)."/".$stud_id."/".$org."/".$acyear));
		}
        //redirect('Hostel/view_std_payment/'.$stud_id);
    }
	
	// insert Payment installment
	public function pay_Installment()
    {
		//print_r($_FILES);exit;
        $stud_id= $_POST['stud_id'];
		$enroll= $_POST['enrollment_no'];
		$org= $_POST['org'];
		$acyear= $_POST['acyear'];
		$no_of_installment =1+$_POST['no_of_installment'];
		if(!empty($_FILES['payfile']['name'])){
			$filenm=$stud_id.'-'.$no_of_installment.'-'.$_FILES['payfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('payfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
		
		//echo "calling";exit();
        $last_inserted_id= $this->hostel_model->pay_Installment($_POST,$payfile );
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Fee Details Added Successfully.');
			redirect(base_url($this->view_dir."view_std_payment/".str_replace("/","_",$enroll)."/".$stud_id."/".$org."/".$acyear));
		}
		else
		{
			$this->session->set_flashdata('message2','Fee Details Not Added Successfully.');
			redirect(base_url($this->view_dir."view_std_payment/".str_replace("/","_",$enroll)."/".$stud_id."/".$org."/".$acyear));
		}
        //redirect('Hostel/view_std_payment/'.$stud_id);
    }
	
	public function getamtpaid_by_stdid()
	{
		//echo "callinggggggg";exit();
		$paid_amt=$this->hostel_model->getamtpaid_by_stdid($_POST);
		echo $paid_amt;
	}
	
	public function edit_fdetails()
	{//alert("called"+stdid+orgz+enroll);
		$this->data['stud_details']['enrollment_no']=$_POST['enroll'];
		$this->data['stud_details']['student_id']=$_POST['stdid'];
		$this->data['stud_details']['org']=$_POST['org'];
		$feeid =$_POST['feeid'];
		//echo $sf_std_id;exit();
		//$this->data['bank_details']= $this->hostel_model->getbanks();
		//$this->data['indet']= $this->hostel_model->get_inst_details($stud_id);
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
		$this->data['program_detail']=$this->hostel_model->get_program_detail();
		//$this->data['student_details']= array_shift($this->hostel_model->get_std_details_byid($sf_std_id));
		$this->data['bank_details']= $this->hostel_model->getbanks();
		$this->data['indet']= $this->hostel_model->fetch_hostelfee_details_byfid($feeid);
		//$this->data['student_faci_details']= array_shift($this->hostel_model->get_std_fc_details_byid($sf_std_id));
		
		$this->load->view($this->view_dir.'edit_fee',$this->data);
	}
	public function update_inst($stud_id)
	{
		$stud_id= $_POST['student_id'];
		$enroll= $_POST['enrollment_no'];
		$org= $_POST['org'];
		//echo $stud_id;exit;
		date_default_timezone_set('Asia/Kolkata');
        $stud_id= $_POST['sid'];
		//echo $stud_id;exit();
	//	$no_of_installment =1+$_POST['no_of_installment'];
		if(!empty($_FILES['epayfile']['name'])){
			$filenm=$stud_id.'-'.time().'-'.$_FILES['epayfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('epayfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
        $this->hostel_model->update_fee_det($_POST,$payfile );
        //redirect('ums_admission/viewPayments/'.$stud_id);
		$this->session->set_flashdata('message1','Fee Details Updated Successfully.');
		redirect(base_url($this->view_dir."view_std_payment/".$enroll."/".$stud_id."/".$org));
	}
	
	public function delete_fees()
	{
	      $this->hostel_model->delete_fees($_POST);  
	}
	
	public function view_room_details()
    {
		if(isset($_GET['id']))
			$this->data['id']= $_GET['id'];

        $this->load->view('header',$this->data);                   
        $this->data['hostel_details']= $this->hostel_model->get_hostel_details();
		//$this->data['state']= $this->hostel_model->getAllState();
		$this->load->view($this->view_dir.'view_room_details',$this->data);
        $this->load->view('footer');
    }
	
	public function get_rms_detailsbyhid()
	{
		//echo "helloooo";exit();
		$rm_dts=$this->hostel_model->get_rooms_detailsbyhid($_POST);
		//echo base_url($currentModule.$this->view_dir);exit();
		$i=1;
		$ban='fa-ban';
		$check='fa-check';
		echo $rm_dts[0]['hostel_name'].'||'.$rm_dts[0]['hostel_code'].'||'.$rm_dts[0]['hostel_type'].'||'.$rm_dts[0]['in_campus'].'||';
		//.'||'.$rm_dts[0]['hostel_name'].'||'.$rm_dts[0]['hostel_type'].'||'.$rm_dts[0]['in_campus'];
		
		foreach($rm_dts as $val){
		    $temp_flr=$val["floor_no"];
			if($temp_flr==0)
				$temp_flr='G';
			else
				$temp_flr=$val["floor_no"];
           	 echo '<tr>
					<td>'.$i.'</td>                                                                
					<td>'.$val["hostel_code"].'</td>
					<td>'.$temp_flr.'</td>
					<td>'.$val["room_no"].'</td>
					<td>'.$val["numbeds"].'</td>
					<td>'.$val["room_type"].'</td>
					<td>'.$val["category"].'</td>
					<td>
					   <a style="" title="Edit Hostel Rooms Detail" class="btn btn-primary btn-xs" href="'.base_url($currentModule.$this->view_dir.'edit_room_details/'.$val["sf_room_id"]).'">Edit</a><!--<a href="'.base_url($currentModule.$this->view_dir.($val["is_active"]=="Y"?'disable_room_details/'.$val["sf_room_id"]:'enable_room_details/'.$val["sf_room_id"])).'"><i '.($val["is_active"]=="Y"?'class="fa '.$ban:'class="fa '.$check).'" title="'.($val["is_active"]=="Y"?'Disable':'Enable').'"></i></a>-->
				   </td>
				   </tr>';
				   //<a href="'.base_url($currentModule.$this->view_dir.'edit_flr_room_details/'.$val["host_id"]).'"><i class="fa fa-edit"></i></a>
			$i++;
        }
	}
	public function edit_room_details()
    {
        $this->load->view('header',$this->data);                
        $room_id=$this->uri->segment(3);
        $this->data['h_room_details']=array_shift($this->hostel_model->get_h_room_details($room_id));
		//	echo $this->view_dir.'edit_room_details';exit();
        $this->load->view($this->view_dir.'edit_room_details',$this->data);
        $this->load->view('footer');
    }
	
	public function add_rms_details()
    {
        $this->load->view('header',$this->data); 
		$this->data['hostel_details']= $this->hostel_model->get_hostel_details();		
        $this->load->view($this->view_dir.'add_room_details',$this->data);
        $this->load->view('footer');
    }
	
	public function room_details_submit()
    {
		//echo base_url($this->view_dir."?error=0");exit();
		//$r_no=$this->input->post("r_no");hostel_id//hostel_code//floor_no
		$hostel_id=$this->input->post("hostel_id");
		$hostel_code=$this->input->post("hostel_code");
		$floor_no=$this->input->post("floor_no");
		$room_no=$this->input->post("room_no");
		$floorbeds=$this->input->post("floorbeds");
		$flr_rm_type=$this->input->post("flr_rm_type");
		$flr_rm_cat=$this->input->post("flr_rm_cat");
		
		//if(!empty($floorbeds)){
			$j=1;
			for($i = 0; $i < count($floorbeds); $i++){
				//if(!empty($floorbeds[$i]))
				{
					$rnos = $room_no[$i];
					$fbeds = $floorbeds[$i];
					$rtype = $flr_rm_type[$i];
					$catg = $flr_rm_cat[$i];
					//echo $j."====".$hostel_id."====".$hostel_code."====".$floor_no."====".$fbeds."====".$rtype."====".$catg."<br/>";
					//exit();
					for($z = 1; $z <= $fbeds; $z++)
					{
					
						//database insert query goes here
						$insert_array=array("room_no"=>$rnos,"host_id"=>$hostel_id,"hostel_code"=>$hostel_code,"floor_no"=>$floor_no,"no_of_beds"=>$fbeds,"bed_number"=>$z,"room_type"=>$rtype,"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"category"=>$catg,"is_active"=>'Y');   
				
						$this->db->insert("sf_hostel_room_details", $insert_array);
					}
					
				}
				$j++;
			}
			$last_inserted_id=$this->db->insert_id();                
			if($last_inserted_id)
			{
				$this->session->set_flashdata('message1','Room Details Added Successfully.');
				redirect(base_url($this->view_dir.'add_rms_details'));
			}
			else
			{
				$this->session->set_flashdata('message2','Room Details Not Added Successfully.');
				redirect(base_url($this->view_dir.'add_rms_details'));
			}
		//}
		
	}
	
	public function in_up_submit()
	{
		$sf_room_id=$this->input->post("sf_room_id");
		$hostel_id=$this->input->post("hst_id");
		$hostel_code=$this->input->post("host_code");
		$floor_no=$this->input->post("fr_no");
		$room_no=$this->input->post("room_no");
		$floorbeds=$this->input->post("floorbeds");
		$flr_rm_type=$this->input->post("flr_rm_type");
		$flr_rm_cat=$this->input->post("flr_rm_cat");
		
		if(!empty($floorbeds)){
			$j=1;
			for($i = 0; $i < count($floorbeds); $i++){
				if(!empty($floorbeds[$i]))
				{
					$rm_id=$sf_room_id[$i];
					$rnos = $room_no[$i];
					$fbeds = $floorbeds[$i];
					$rtype = $flr_rm_type[$i];
					$catg = $flr_rm_cat[$i];
					//echo $rm_id."====".$hostel_id."====".$hostel_code."====".$floor_no."====".$fbeds."====".$rtype."====".$catg."<br/>";
					//exit();
					
					
					
					if($rm_id=="")
					{
						for($z = 1; $z <= $fbeds; $z++)
						{
							//database insert query goes here
							$insert_array=array("bed_number"=>$z,"room_no"=>$rnos,"host_id"=>$hostel_id,"hostel_code"=>$hostel_code,"floor_no"=>$floor_no,"no_of_beds"=>$fbeds,"room_type"=>$rtype,"category"=>$catg,"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>'Y');   
					
							$this->db->insert("sf_hostel_room_details", $insert_array);
						}
					}
					else
					{
						
						$bedswhere=" floor_no = $floor_no and sf_room_id = $rm_id and host_id = $hostel_id and room_no='$rnos'";
						$sql="select no_of_beds as beds_count From sf_hostel_room_details where $bedswhere group by room_no;";
						
						$query = $this->db->query($sql);
						$existed_rooms = $query->row()->beds_count;
						//echo $fbeds."====".$existed_rooms;exit();
						
						if($existed_rooms=='')
						{
							//room number is new insert it
							for($z = 1; $z <= $fbeds; $z++)
							{
								//database insert query goes here
								$insert_array=array("bed_number"=>$z,"room_no"=>$rnos,"host_id"=>$hostel_id,"hostel_code"=>$hostel_code,"floor_no"=>$floor_no,"no_of_beds"=>$fbeds,"room_type"=>$rtype,"category"=>$catg,"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>'Y');   
						
								$this->db->insert("sf_hostel_room_details", $insert_array);
							}
						}
						if($fbeds==$existed_rooms)
						{
							$update_array=array("no_of_beds"=>$fbeds,"room_type"=>$rtype,"category"=>$catg,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"),"category"=>$catg);   

							$where=array("room_no"=>$rnos,"host_id"=>$hostel_id,"floor_no"=>$floor_no);
							$this->db->where($where); 
							$this->db->update('sf_hostel_room_details', $update_array);
						} 
						if($fbeds>$existed_rooms)
						{
							//get difference and insert and update noofbeds of those number of times in db
							$rowstobeinserted=$fbeds-$existed_rooms;
							$flag=0;
							for($z = 1; $z <= $fbeds; $z++)
							{
								if($z>$existed_rooms)
								{
									$flag=1;
								}
								if($flag==0)
								{
									$update_array=array("no_of_beds"=>$fbeds,"room_type"=>$rtype,"category"=>$catg,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"),"category"=>$catg);   
		
									$where=array("bed_number"=>$z,"room_no"=>$rnos,"host_id"=>$hostel_id,"floor_no"=>$floor_no);
									$this->db->where($where); 
									$this->db->update('sf_hostel_room_details', $update_array);
								}
								else
								{
									$insert_array=array("bed_number"=>$z,"room_no"=>$rnos,"host_id"=>$hostel_id,"hostel_code"=>$hostel_code,"floor_no"=>$floor_no,"no_of_beds"=>$fbeds,"room_type"=>$rtype,"category"=>$catg,"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>'Y');   
					
									$this->db->insert("sf_hostel_room_details", $insert_array);
								}
								
							}
							
						}
						if($fbeds<$existed_rooms)
							{
								//get difference and update noofbeds of those number of times and delete rest rows in db
								//$rowstobedeleted=$existed_rooms-$fbeds;
								$flag=0;
								
								$bedswhere=" floor_no = $floor_no and hostel_code = '$hostel_code' and room_no='$rnos'";
								$sql="select COUNT(hrd.sf_room_id) AS allocatedbedscountofthatflrroom From sf_hostel_room_details as hrd 
								 inner join sf_student_facility_allocation as fm on fm.allocated_id = hrd.sf_room_id where $bedswhere;";
								
								$query = $this->db->query($sql);
								$allocated_bed_count = $query->row()->allocatedbedscountofthatflrroom;
								$rowstobedeleted=$existed_rooms-$fbeds;
								
								if(($existed_rooms-$allocated_bed_count)>=$rowstobedeleted)
								{
									$rowsdeletedcount=0;
									for($z = 1; $z <= $existed_rooms; $z++)
									{
										//echo "<br/>".$rowsdeletedcount;exit();
										if($rowsdeletedcount==$rowstobedeleted)
										{
											break;
										}
										else
										{
											$bedswhere=" floor_no = $floor_no and hostel_code = '$hostel_code' and room_no='$rnos' and bed_number='$z'";
											$sql="select hrd.bed_number From sf_hostel_room_details as hrd 
											 inner join sf_student_facility_allocation as fm on fm.allocated_id = hrd.sf_room_id where $bedswhere;";
											
											$query = $this->db->query($sql);
											//echo $this->db->last_query();exit();
											//echo "<br/>existed_bed==";
											$existed_bed = $query->row()->bed_number;
											//$flr= $query->result_array();
											if(empty($existed_bed)){
												//echo "delete";exit();
												$rowsdeletedcount++;
												$where=array("bed_number"=>$z,"room_no"=>$rnos,"host_id"=>$host_id,"floor_no"=>$floor_no);
												$this->db->where($where);
												$this->db->delete('sf_hostel_room_details'); 
											}
										}
														
									}
									//echo "availablebeds==";
									$availablebeds=$existed_rooms-$rowstobedeleted;
									if($availablebeds>0)
									{
										//echo "update";
										$bedswhere=" floor_no = $floor_no and hostel_code = '$hostel_code' and room_no='$rnos'";
										$sql="select sf_room_id From sf_hostel_room_details where $bedswhere order by sf_room_id;";
							
										$query = $this->db->query($sql);
										$rmids=$query->result_array();
										$j=1;
										foreach($rmids as $val)
										{
											$update_array=array("bed_number"=>$j,"no_of_beds"=>$fbeds,"room_type"=>$rtype,"category"=>$catg,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"),"category"=>$catg);   

											$where=array("sf_room_id"=>$val['sf_room_id']);
											$this->db->where($where); 
											$this->db->update('sf_hostel_room_details', $update_array); 
											$j++;
										}
									}
									
									//exit();
								}
								else
								{
									//display error msg for not able to delete becz its already allocated
									$this->session->set_flashdata('message2','Room Details Not Updated Successfully.');
									redirect(base_url($this->view_dir.'add_rms_details'));
								}
							}
						
					}
					
				}
				$j++;
			}

			$last_inserted_id=$this->db->insert_id();                
			if($last_inserted_id || $this->db->affected_rows())
			{
				$this->session->set_flashdata('message1','Room Details Updated Successfully.');
				redirect(base_url($this->view_dir.'add_rms_details'));
			}
			else
			{
				$this->session->set_flashdata('message2','Room Details Not Updated Successfully.');
				redirect(base_url($this->view_dir.'add_rms_details'));
			}
		}
	}
	
public function edit_room_submit()
{
    $host_id = $this->input->post("hostel_id");
    $hostel_code = $this->input->post("hostel_code");    
    $floor_no = $this->input->post("tot_flr");    
    $rnos = $this->input->post("tot_rooms");    
    $fbeds = $this->input->post("tot_beds");                    
    $rtype = $this->input->post("room_type");
    $catg = $this->input->post("category");  
    $sf_room_id = $this->uri->segment(3);
    $dbdel = $this->load->database('erpdell', TRUE);
    $r_dts = $this->hostel_model->check_rm_exist_byflrhid($_POST, $sf_room_id);
    
    if ($r_dts == 1) {  
        $this->session->set_flashdata('message2', 'Room Number Already exists, so details were not updated successfully.');
        redirect(base_url($this->view_dir . "edit_room_details/" . $sf_room_id));
    } else {
        $bedswhere = "floor_no = $floor_no AND hostel_code = '$hostel_code' AND room_no = '$rnos'";
        $sql = "SELECT no_of_beds AS beds_count FROM sf_hostel_room_details WHERE $bedswhere";
        $query1 = $this->db->query($sql);
        $query = $query1->row_array();
        $existed_rooms = $query['beds_count'];
        
        if ($fbeds == $existed_rooms) {
            $update_array = array(
                "no_of_beds" => $fbeds,
                "room_type" => $rtype,
                "category" => $catg,
                "modified_by" => $this->session->userdata("uid"),
                "modified_on" => date("Y-m-d H:i:s")
            );

            $where = array("room_no" => $rnos, "host_id" => $host_id, "floor_no" => $floor_no);
            $this->db->where($where); 
            $this->db->update('sf_hostel_room_details', $update_array);
        } elseif ($fbeds > $existed_rooms) {
            $rowstobeinserted = $fbeds - $existed_rooms;
            $flag = 0;

            for ($z = 1; $z <= $fbeds; $z++) {
                if ($z > $existed_rooms) {
                    $flag = 1;
                }
                if ($flag == 0) {
                    $update_array = array(
                        "no_of_beds" => $fbeds,
                        "room_type" => $rtype,
                        "category" => $catg,
                        "modified_by" => $this->session->userdata("uid"),
                        "modified_on" => date("Y-m-d H:i:s")
                    );

                    $where = array("bed_number" => $z, "room_no" => $rnos, "host_id" => $host_id, "floor_no" => $floor_no);
                    $this->db->where($where); 
                    $this->db->update('sf_hostel_room_details', $update_array);
                } else {
                    $insert_array = array(
                        "bed_number" => $z,
                        "room_no" => $rnos,
                        "host_id" => $host_id,
                        "hostel_code" => $hostel_code,
                        "floor_no" => $floor_no,
                        "no_of_beds" => $fbeds,
                        "room_type" => $rtype,
                        "category" => $catg,
                        "created_by" => $this->session->userdata("uid"),
                        "created_on" => date("Y-m-d H:i:s"),
                        "is_active" => 'Y'
                    );

                    $this->db->insert("sf_hostel_room_details", $insert_array);
                }
            }
        } elseif ($fbeds < $existed_rooms) {
            $bedswhere = "floor_no = $floor_no AND hostel_code = '$hostel_code' AND room_no = '$rnos' AND fm.is_active = 'Y' AND academic_year = '2018'";
            $sql = "SELECT COUNT(hrd.sf_room_id) AS allocatedbedscountofthatflrroom FROM sf_hostel_room_details AS hrd INNER JOIN sf_student_facility_allocation AS fm ON fm.allocated_id = hrd.sf_room_id AND fm.sffm_id = '1' WHERE $bedswhere";
            $query = $this->db->query($sql);
            $allocated_bed_count = $query->row()->allocatedbedscountofthatflrroom;
            $rowstobedeleted = $existed_rooms - $fbeds;

            if (($existed_rooms - $allocated_bed_count) >= $rowstobedeleted) {
                $rowsdeletedcount = 0;
                for ($z = 1; $z <= $existed_rooms; $z++) {
                    if ($rowsdeletedcount == $rowstobedeleted) {
                        break;
                    } else {
                        $bedswhere = "floor_no = $floor_no AND hostel_code = '$hostel_code' AND room_no = '$rnos' AND fm.is_active = 'Y' AND bed_number = '$z'";
                        $sql = "SELECT hrd.bed_number FROM sf_hostel_room_details AS hrd INNER JOIN sf_student_facility_allocation AS fm ON fm.allocated_id = hrd.sf_room_id WHERE $bedswhere";
                        $query = $this->db->query($sql);
                        $existed_bed = $query->row()->bed_number;

                        if (empty($existed_bed)) {
                            $rowsdeletedcount++;
                            $where = array("bed_number" => $z, "room_no" => $rnos, "host_id" => $host_id, "floor_no" => $floor_no);
                            $dbdel->where($where);
                            $dbdel->delete('sf_hostel_room_details');
                        }
                    }
                }

                $availablebeds = $existed_rooms - $rowstobedeleted;
                if ($availablebeds > 0) {
                    $bedswhere = "floor_no = $floor_no AND hostel_code = '$hostel_code' AND room_no = '$rnos'";
                    $sql = "SELECT sf_room_id FROM sf_hostel_room_details WHERE $bedswhere ORDER BY sf_room_id";
                    $query = $this->db->query($sql);
                    $rmids = $query->result_array();
                    $j = 1;

                    foreach ($rmids as $val) {
                        $update_array = array(
                            "bed_number" => $j,
                            "no_of_beds" => $fbeds,
                            "room_type" => $rtype,
                            "category" => $catg,
                            "modified_by" => $this->session->userdata("uid"),
                            "modified_on" => date("Y-m-d H:i:s")
                        );

                        $where = array("sf_room_id" => $val['sf_room_id']);
                        $this->db->where($where); 
                        $this->db->update('sf_hostel_room_details', $update_array); 
                        $j++;
                    }
                }
            } else {
                $this->session->set_flashdata('message2', 'Room details were not updated because beds are already allocated.');
                redirect(base_url($this->view_dir . 'view_room_details/' . $host_id));
            }
        }

        $last_inserted_id = $this->db->insert_id();                
        if ($last_inserted_id || $this->db->affected_rows()) {
            $this->session->set_flashdata('message1', 'Room details updated successfully.');
            redirect(base_url($this->view_dir . 'view_room_details/' . $host_id));
        } else {
            $this->session->set_flashdata('message2', 'Room details were not updated successfully.');
            redirect(base_url($this->view_dir . 'view_room_details/' . $host_id));
        }            
    }
}

	
	public function disable_room_details()
    {
		//echo "caleddddddddd";exit();
        $this->load->view('header',$this->data);                
        
		$sf_room_id=$this->uri->segment(3);   
        $update_array=array("is_active"=>"N","modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));                                
        $where=array("sf_room_id"=>$sf_room_id);
		
        $this->db->where($where);
        
        if($this->db->update('sf_hostel_room_details', $update_array))
        {
			$this->session->set_flashdata('message1','Selected Hostel Room Disabled Successfully.');
            redirect(base_url($this->view_dir."view_room_details"));
        }
        else
        {
			$this->session->set_flashdata('message2','Selected Hostel Room Not Disabled Successfully.');
            redirect(base_url($this->view_dir."view_room_details"));
        }  
        $this->load->view('footer');
    }
    
    public function enable_room_details()
    {
        $this->load->view('header',$this->data);                
        $sf_room_id=$this->uri->segment(3);   
        $update_array=array("is_active"=>"Y","modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));                                
        $where=array("sf_room_id"=>$sf_room_id);
        $this->db->where($where);
        
        if($this->db->update('sf_hostel_room_details', $update_array))
        {
			$this->session->set_flashdata('message1','Selected Hostel Room Enabled Successfully.');
            redirect(base_url($this->view_dir."view_room_details"));
        }
        else
        {
			$this->session->set_flashdata('message2','Selected Hostel Room Not Enabled Successfully.');
            redirect(base_url($this->view_dir."view_room_details"));
        }  
        $this->load->view('footer');
    }
	
	public function check_rm_exist_byflr_rid()
	{
		//$r_id=$_REQUEST['sf_room_id'];
		//$flr_no=$_REQUEST['flr_no'];
		//$r_no=$_REQUEST['r_no'];
		$r_dts=$this->hostel_model->check_rm_exist_byflr_rid($_POST);
		//$flr_dts['count_rows'];
		echo $r_dts;
		//echo $flr_dts['count_rows'];exit();
		
	}
	
	public function check_flr_exist()
	{
		$host_id=$_REQUEST['host_id'];
		$flr_no=$_REQUEST['flr_no'];
		$flr_dts=$this->hostel_model->check_flr_exist($flr_no,$host_id);
		echo json_encode(array("flr_details"=>$flr_dts));
		
	}
	
	public function check_student_exists()
	{
		echo $facifee_dts=$this->hostel_model->check_student_exists($_POST);
	}
	
	public function check_facilityfee_exists()
	{
		echo $facifee_dts=$this->hostel_model->check_facilityfee_exists($_POST);
	}
	
	public function check_facilityfee_exists_byid()
	{
		echo $facifee_dts=$this->hostel_model->check_facilityfee_exists_byid($_POST);
	}
	
	public function room_existsbyflrofhostel()
	{
		$roomsdts=$this->hostel_model->room_existsbyflrofhostel($_POST);
		if(!empty($roomsdts))
			echo "exists";
		else
			echo "notexists";
	}
	
	public function rooms_allocation_details()
	{
		$host_id=$_REQUEST['host_id'];
		$flr_no=$_REQUEST['flr_no'];
		$r_alloted=array_shift($this->hostel_model->total_rooms($host_id));
		echo $r_alloted['no_of_rooms']."||".$r_alloted['no_of_beds'];
		$r_alloted=$this->hostel_model->rooms_allocated($host_id);
		echo "||".$r_alloted;
		$b_alloted=$this->hostel_model->beds_allocated($host_id);
		echo "||".$b_alloted;
	}
	
	public function edit_flr_room_details()
	{
		$this->load->view('header',$this->data);                
        $hostel_id=$this->uri->segment(3);
        $this->data['h_flr_rm_details']=$this->hostel_model->get_h_flr_rm_details($hostel_id);
		//	echo $this->view_dir.'edit_room_details';exit();
        $this->load->view($this->view_dir.'edit_flr_rm_details',$this->data);
        $this->load->view('footer');
	}
	
	public function hostel_details_submit()
    {
		//echo base_url($this->view_dir."?error=0");exit();
		//$r_no=$this->input->post("r_no");hostel_id//hostel_code//floor_no
		$hostel_code=$this->input->post("h_code");
		$room_id=$this->input->post("h_rm_id");
		$host_id=$this->input->post("hostel_id");
		$floor_no=$this->input->post("floor_no");
		$rnos=$this->input->post("roomno");
		$fbeds=$this->input->post("floorbeds");
		$rtype=$this->input->post("flr_rm_type");
		$catg=$this->input->post("flr_rm_cat");
		
		$sql="select count(a.room_no) as rowscount from (select room_no From sf_hostel_room_details where host_id='$host_id[0]' group by floor_no,room_no) as a";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit();
		$rowscount = $query->row()->rowscount;
		for($i = 0; $i <$rowscount; $i++)
		{
			//echo 'floor_no = '.$floor_no[$i].'and hostel_code = '.$hostel_code[$i].' and room_no='.$rnos[$i];exit();

			$bedswhere=" floor_no = $floor_no[$i] and hostel_code = '$hostel_code[$i]' and room_no='$rnos[$i]'";
			$sql="select no_of_beds as beds_count From sf_hostel_room_details where $bedswhere group by floor_no,room_no;";
			
			$query = $this->db->query($sql);
			$existed_rooms = $query->row()->beds_count;
			//echo $fbeds[$i]."====".$existed_rooms;exit();
			if($fbeds[$i]==$existed_rooms)
			{
				$update_array=array("no_of_beds"=>$fbeds[$i],"room_type"=>$rtype[$i],"category"=>$catg[$i],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"),"category"=>$catg);   

				$where=array("room_no"=>$rnos[$i],"host_id"=>$host_id[$i],"floor_no"=>$floor_no[$i]);
				$this->db->where($where); 
				$this->db->update('sf_hostel_room_details', $update_array);
			}
			if($fbeds[$i]>$existed_rooms)
			{
				//get difference and insert and update noofbeds of those number of times in db
				$rowstobeinserted=$fbeds[$i]-$existed_rooms;
				$flag=0;
				for($z = 1; $z <= $fbeds[$i]; $z++)
				{
					if($z>$existed_rooms)
					{
						$flag=1;
					}
					if($flag==0)
					{
						$update_array=array("no_of_beds"=>$fbeds[$i],"room_type"=>$rtype[$i],"category"=>$catg[$i],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));   

						$where=array("bed_number"=>$z,"room_no"=>$rnos[$i],"host_id"=>$host_id[$i],"floor_no"=>$floor_no[$i]);
						$this->db->where($where); 
						$this->db->update('sf_hostel_room_details', $update_array);
					}
					else
					{
						$insert_array=array("bed_number"=>$z,"room_no"=>$rnos[$i],"host_id"=>$host_id[$i],"hostel_code"=>$hostel_code[$i],"floor_no"=>$floor_no[$i],"no_of_beds"=>$fbeds[$i],"room_type"=>$rtype[$i],"category"=>$catg[$i],"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>'Y');   
		
						$this->db->insert("sf_hostel_room_details", $insert_array);
					}
					
				}
				
			}
			if($fbeds[$i]<$existed_rooms)
			{
				//get difference and update noofbeds of those number of times and delete rest rows in db
				//$rowstobedeleted=$existed_rooms-$fbeds;
				$flag=0;
				
				$bedswhere=" floor_no = $floor_no[$i] and hostel_code = '$hostel_code[$i]' and room_no='$rnos[$i]' and fm.is_active ='Y'";
				$sql="select COUNT(hrd.sf_room_id) AS allocatedbedscountofthatflrroom From sf_hostel_room_details as hrd 
				 inner join sf_student_facility_allocation as fm on fm.allocated_id = hrd.sf_room_id where $bedswhere;";
				
				$query = $this->db->query($sql);
				$allocated_bed_count = $query->row()->allocatedbedscountofthatflrroom;
				$rowstobedeleted=$existed_rooms-$fbeds[$i];
				
				if(($existed_rooms-$allocated_bed_count)>=$rowstobedeleted)
				{
					$rowsdeletedcount=0;
					for($z = 1; $z <= $existed_rooms; $z++)
					{
						//echo "<br/>".$rowsdeletedcount;exit();
						if($rowsdeletedcount==$rowstobedeleted)
						{
							break;
						}
						else
						{
							$bedswhere=" floor_no = $floor_no[$i] and hostel_code = '$hostel_code[$i]' and room_no='$rnos[$i]' and bed_number='$z' and fm.is_active ='Y'";
							$sql="select hrd.bed_number From sf_hostel_room_details as hrd 
							 inner join sf_student_facility_allocation as fm on fm.allocated_id = hrd.sf_room_id where $bedswhere;";
							
							$query = $this->db->query($sql);
							//echo $this->db->last_query();exit();
							//echo "<br/>existed_bed==";
							$existed_bed = $query->row()->bed_number;
							//$flr= $query->result_array();
							if(empty($existed_bed)){
								//echo "delete";exit();
								$rowsdeletedcount++;
								$where=array("bed_number"=>$z,"room_no"=>$rnos[$i],"host_id"=>$host_id[$i],"floor_no"=>$floor_no[$i]);
								$this->db->where($where);
								$this->db->delete('sf_hostel_room_details'); 
							}
						}
										
					}
					//echo "availablebeds==";
					$availablebeds=$existed_rooms-$rowstobedeleted;
					if($availablebeds>0)
					{
						//echo "update";
						$bedswhere=" floor_no = $floor_no[$i] and hostel_code = '$hostel_code[$i]' and room_no='$rnos[$i]'";
						$sql="select sf_room_id From sf_hostel_room_details where $bedswhere order by sf_room_id;";
			
						$query = $this->db->query($sql);
						$rmids=$query->result_array();
						$j=1;
						foreach($rmids as $val)
						{
							$update_array=array("bed_number"=>$j,"no_of_beds"=>$fbeds[$i],"room_type"=>$rtype[$i],"category"=>$catg[$i],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));   

							$where=array("sf_room_id"=>$val['sf_room_id']);
							$this->db->where($where); 
							$this->db->update('sf_hostel_room_details', $update_array); 
							$j++;
						}
					}
					
					//exit();
				}
				else
				{
					//display error msg for not able to delete becz its already allocated
					$this->session->set_flashdata('message2','Room Details Not Updated Successfully.');
					redirect(base_url($this->view_dir.'view_room_details/'.$host_id[0]));
				}
			}
		}
		$last_inserted_id=$this->db->insert_id();                
		if($last_inserted_id || $this->db->affected_rows())
		{
			$this->session->set_flashdata('message1','Room Details Updated Successfully.');
			redirect(base_url($this->view_dir.'view_room_details/'.$host_id[0]));
		}
		else
		{
			$this->session->set_flashdata('message2','Room Details Not Updated Successfully.');
			redirect(base_url($this->view_dir.'view_room_details/'.$host_id[0]));
		}
		
		
		
		
			/* for($i = 0; $i < count($floorbeds); $i++){
				if(!empty($floorbeds[$i]))
				{
					$rmid = $room_id[$i];
					$hid = $h_id[$i];
					$fnos = $floor_no[$i];
					$rnos = $roomno[$i];
					$fbeds = $floorbeds[$i];
					$rtype = $flr_rm_type[$i];
					$catg = $flr_rm_cat[$i];
					//echo $rmid."====".$hid."====".$fnos."====".$rnos."====".$fbeds."====".$rtype."====".$catg."<br/>";
					//exit();
					//database insert query goes here
					$update_array=array("room_no"=>$rnos,"floor_no"=>$fnos,"no_of_beds"=>$fbeds,"room_type"=>$rtype,"category"=>$catg,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));   
		
					$where=array("sf_room_id"=>$rmid,"host_id"=>$hid);
					$this->db->where($where); 
					$this->db->update('sf_hostel_room_details', $update_array);
					
				}
				$j++;
			}
              
			if($this->db->affected_rows())
			{
				$this->session->set_flashdata('message1','Room Details Updated Successfully.');
				redirect(base_url($this->view_dir."view_rms_details?id=".$hid));
			}
			else
			{
				$this->session->set_flashdata('message2','Room Details Not Updated Successfully.');
				redirect(base_url($this->view_dir.'view_rms_details?id='.$hid));
			} */
		
		
	}
	public function check_rm_exist_byflrhid()
	{
		$h_rm_id=$_REQUEST['h_rm_id'];
		$h_id=$_REQUEST['hid'];
		$flr_no=$_REQUEST['flr_no'];
		$r_no=$_REQUEST['r_no'];
		$r_dts=$this->hostel_model->check_rm_exist_byflrhid($h_rm_id,$h_id,$flr_no,$r_no);
		//$flr_dts['count_rows'];
		echo $r_dts;
		//echo $flr_dts['count_rows'];exit();
		
	}
	
	
	public function add_stdnt_faci_allocation()
	{
		$this->load->view('header',$this->data); 
        $this->data['facilities_types']= $this->hostel_model->get_facilities_types();
		//$this->data['facilities_details']= array_shift($this->hostel_model->get_facilities_byid($sf_fc_id));
        $this->load->view($this->view_dir.'add_student_faci_allocation',$this->data);
        $this->load->view('footer');
	} 
	
	public function gethostelbycampus()
	{
		$h_dts=$this->hostel_model->gethostelbycampus($_POST);
		if(!empty($h_dts)){
			echo"<option value=''>Select Hostels</option>";
			foreach($h_dts as $val){
				echo"<option value='".$val['host_id']."||".$val['hostel_code']."||".$val['no_of_floors']."'>".$val['hostel_name']."</option>";
			}		
		}
	}
	
	public function getroomnumsbyfloorno()
	{
		$r_dts=$this->hostel_model->getroomnumsbyfloorno($_POST);
		echo json_encode(array("flr_details"=>$r_dts));
	}
	
	public function fetch_alloted_details()
	{
		$r_dts=$this->hostel_model->fetch_alloted_details($_POST);
		echo json_encode(array("flr_details"=>$r_dts));
	}
	
	public function fetch_alloted_details1()
	{
		$this->data['flr_details'] = $this->hostel_model->fetch_alloted_details($_POST);
		//var_dump($this->data['flr_details']);//exit();
	   echo $this->load->view($this->view_dir.'hostel_alloted_list',$this->data,true);	
	}
	
	
	
	public function getsfid_byenrollment()
	{
		$sf_id=$this->hostel_model->getsfid_byenrollment($_POST);
		//print_r($sf_id);exit();
		echo $sf_id;
	}
	
	public function stdnt_faci_submit()
	{
		$last_inserted_id=$this->hostel_model->stdnt_faci_submit($_POST);
		               
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Hostel facility allocated Successfully.');
			redirect(base_url($this->view_dir.'pages'));
		}
		else
		{
			$this->session->set_flashdata('message2','Hostel facility not allocated Successfully.');
			redirect(base_url($this->view_dir.'pages'));
		}
	}
	
	public function edit_stdnt_faci_allocation()
	{
		$f_alloc_id=$this->uri->segment(3);
		//echo $f_alloc_id;exit();
		$this->load->view('header',$this->data); 
        $this->data['facilities_types']= $this->hostel_model->get_facilities_types();
		$this->data['facilities_allocation']=array_shift($this->hostel_model->get_facilities_allocation($f_alloc_id));
	//print_r($this->data['facilities_allocation']);exit();
		$this->load->view($this->view_dir.'edit_student_faci_allocation',$this->data);
        $this->load->view('footer');
	}
	
	public function edit_stdnt_faci_submit()
	{
		$f_alloc_id=$this->uri->segment(3);//echo "f_alloc_id==".$f_alloc_id;exit();
		$last_inserted_id=$this->hostel_model->edit_stdnt_faci_submit($_POST,$f_alloc_id);
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Allocated facility updated Successfully');
			redirect(base_url($this->view_dir.'edit_stdnt_faci_allocation/'.$f_alloc_id));
		}
		else
		{
			$this->session->set_flashdata('message2','Allocated facility not updated Successfully');
			redirect(base_url($this->view_dir.'edit_stdnt_faci_allocation/'.$f_alloc_id));
		}
	}
	
	public function student_allocation_list()
	{
		$this->load->view('header',$this->data); 
       // $this->data['facilities_types']= $this->hostel_model->get_facilities_types();
		//$this->data['facilities_allocation']=$this->hostel_model->student_allocation_list();
		//print_r($this->data['facilities_allocation']);exit();
		$this->data['hostel_details']= $this->hostel_model->get_hostel_details();
		$this->load->view($this->view_dir.'student_allocation_list',$this->data);
        $this->load->view('footer');
	}
	
	public function get_allocation_listbyhid()
	{
		$std_list=$this->hostel_model->get_allocation_listbyhid($_POST);
		//echo base_url($currentModule.$this->view_dir);exit();
		
		$ban='fa-ban';
		$check='fa-check';
		
		foreach($std_list as $val){
           	 echo '<tr>
					<td>'.$val["f_alloc_id"].'</td>
					<td>'.$val["hostel_code"].'</td>
					<td>'.$val["floor_no"].'</td>
					<td>'.$val["room_no"].'</td>
					<td>'.$val["enrollment_no"].'</td>
					<td>'.$val["first_name"].'</td>
					<td>'.$val["instute_name"].'</td>
					<td>
					   <a href="'.base_url($currentModule.$this->view_dir.'edit_stdnt_faci_allocation/'.$val["f_alloc_id"]).'"><i class="fa fa-edit"></i></a><a href="'.base_url($currentModule.$this->view_dir.($val["is_active"]=="Y"?'disable_stdnt_faci_allocation/'.$val["f_alloc_id"]:'enable_stdnt_faci_allocation/'.$val["f_alloc_id"])).'"><i '.($val["is_active"]=="Y"?'class="fa '.$ban:'class="fa '.$check).'" title="'.($val["is_active"]=="Y"?'Disable':'Enable').'"></i></a>
				   </td>
				   </tr>';
        }
	}
	
	public function get_hostel_details()
	{
		$hostel_details= $this->hostel_model->hostel_details($_POST);
		echo json_encode(array("hostel_details"=>$hostel_details));
	}
	
	public function get_info()
	{
		$get_info= $this->hostel_model->get_info($_POST);
		echo json_encode(array("get_info"=>$get_info));
	}
	
	public function hostel_allocation_view()
	{
		 //$hostel_id=$this->uri->segment(3);
		 //$hostel_id=$this->uri->segment(4);
		if(isset($_GET['id']))
			$this->data['id']= $_GET['id'];
		
		
		$this->load->view('header',$this->data); 
        $this->data['facilities_types']= $this->hostel_model->get_facilities_types();
		$this->data['facilities_allocation']=$this->hostel_model->student_allocation_list();
		//print_r($this->data['facilities_allocation']);exit();
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
		$this->data['hostel_details']= $this->hostel_model->get_hostel_details();
		$this->data['student_details']['enrollment_no']=str_replace("_","/",$this->uri->segment(3));
		$this->data['student_details']['student_id']=$this->uri->segment(4);
		$this->data['student_details']['org']=$this->uri->segment(5);
		$this->data['student_details']['sf_id']=$this->uri->segment(6);
		$this->data['student_details']['academic_year']=$this->uri->segment(7);
		$this->load->view($this->view_dir.'pages',$this->data);
		//$this->load->view($this->view_dir.'pages/'.$this->uri->segment(3).'/'.$this->uri->segment(4),$this->data);
        $this->load->view('footer');
	}
	
	public function new_hostel_allocation_view()
	{
		 //$hostel_id=$this->uri->segment(3);
		 //$hostel_id=$this->uri->segment(4);
		if(isset($_GET['id']))
			$this->data['id']= $_GET['id'];
		
		
		$this->load->view('header',$this->data); 
        $this->data['facilities_types']= $this->hostel_model->get_facilities_types();
		$this->data['facilities_allocation']=$this->hostel_model->student_allocation_list();
		//print_r($this->data['facilities_allocation']);exit();
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
		$this->data['hostel_details']= $this->hostel_model->get_hostel_details();
		$this->data['student_details']['enrollment_no']=str_replace("_","/",$this->uri->segment(3));
		$this->data['student_details']['student_id']=$this->uri->segment(4);
		$this->data['student_details']['org']=$this->uri->segment(5);
		$this->data['student_details']['sf_id']=$this->uri->segment(6);
		$this->data['student_details']['academic_year']=$this->uri->segment(7);
		$this->load->view($this->view_dir.'pages1',$this->data);
		//$this->load->view($this->view_dir.'pages/'.$this->uri->segment(3).'/'.$this->uri->segment(4),$this->data);
        $this->load->view('footer');
	}
	
	public function disable_stdnt_faci_allocation()
    {
		$f_alloc_id=$this->uri->segment(3);//echo "f_alloc_id==".$f_alloc_id;exit();
		$last_inserted_id=$this->hostel_model->stdnt_faci_disable($f_alloc_id);
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Allocated facility disabled Successfully');
			redirect(base_url($this->view_dir.'student_allocation_list'));
		}
		else
		{
			$this->session->set_flashdata('message2','Allocated facility not disabled Successfully');
			redirect(base_url($this->view_dir.'edit_stdnt_faci_allocation/'.$f_alloc_id));
		}
    }
    
    public function enable_stdnt_faci_allocation()
    {
        $f_alloc_id=$this->uri->segment(3);//echo "f_alloc_id==".$f_alloc_id;exit();
		$last_inserted_id=$this->hostel_model->stdnt_faci_enable($f_alloc_id);
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Allocated facility enabled Successfully');
			redirect(base_url($this->view_dir.'student_allocation_list'));
		}
		else
		{
			$this->session->set_flashdata('message2','Allocated facility not enabled Successfully');
			redirect(base_url($this->view_dir.'edit_stdnt_faci_allocation/'.$f_alloc_id));
		}
    }
	
	public function fetch_std_hostel_fee_details()
	{
		$dts= $this->hostel_model->fetch_std_hostel_fee_details($_POST);
		if(!empty($dts)){
		    
		    $applicable=($dts[0]['actual_fees']+$dts[0]['deposit_fees']+$dts[0]['gym_fees']+$dts[0]['fine_fees']+$dts[0]['opening_balance'])-$dts[0]['excemption_fees'];
				$temp_amt=$applicable;
				$remaining=0;
				foreach($dts as $val)
				{
					echo "<tr><td>".$val['academic_year']."</td>";
					echo "<td>".$val['actual_fees']."</td>";
					echo "<td>".$val['deposit_fees']."</td>";
					echo "<td>".$applicable."</td>";
					echo "<td>".$val['gym_fees']."</td>";
					echo "<td>".$val['fine_fees']."</td>";
					echo "<td>".$val['opening_balance']."</td>";
					echo "<td>".$val['excemption_fees']."</td>";
					$temp_amt=$temp_amt-$val['amt_paid'];
					
					echo "<td>".$val['amt_paid']."</td>";
					//$remaining=$remaining-$val['amt_paid'];
					echo "<td>".$temp_amt."</td></tr>";
					
				}
				//echo"<tr>";
				/*foreach($dts as $val){
					echo "<tr><td>".$val['academic_year']."</td>";
					echo "<td>".$val['fees']."</td>";
					echo "<td>".$val['deposit']."</td>";
					$applicable=$val['fees']+$val['deposit'];
					echo "<td>".$applicable."</td>";
					echo "<td>".$val['amt_paid']."</td>";
					$remaining=$applicable-$val['amt_paid'];
					echo "<td>".$remaining."</td></tr>";
					/*echo "<td>".$val['academic_year']."</td>";
					echo "<td>".$val['academic_year']."</td>"; 
				}*/
				//echo "</tr>";
			}
	}
	
	public function get_details()
	{
		  $std_faci_details=array_shift($this->hostel_model->get_details($_POST));
		  echo json_encode(array("std_faci_details"=>$std_faci_details));
		 		
	}
	
	
	public function get_stddetails()
	{
		  $std_faci_details=array_shift($this->hostel_model->get_stddetails($_POST));
		  echo json_encode(array("std_fee_details"=>$std_faci_details));
		   //exit();	
	}
	
	
	public function hostel_Disallow(){
		echo $id=$this->hostel_model->hostel_Disallow($_POST);
	}
	
	
	public function facility_allocate_submit()
	{
		$last_inserted_id=$this->hostel_model->stdnt_faci_submit($_POST);
		               
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Hostel facility allocated Successfully.');
		redirect('Hostel/hostel_allocation_view/'.$_POST['h_id']);
		}
		else
		{
			$this->session->set_flashdata('message2','Hostel facility not allocated Successfully.');
			redirect('Hostel/hostel_allocation_view/'.$_POST['h_id']);
		}
	}
	
	public function student_list($enrollment_no='', $ac_year='', $org='')
    {
        //global $model;
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==17 || $this->session->userdata("role_id")==45 || $this->session->userdata("role_id")==60){
		}else{
			redirect('home');
		}
        $this->load->view('header',$this->data);    
        //$this->data['student_list']= $this->hostel_model->get_hstudent_list();
		$this->data['academic_details']= $this->hostel_model->get_academic_details();		
        $this->load->view($this->view_dir.'hostel_student_list',$this->data);
        $this->load->view('footer');
    }
	
	function search_hostel_students()
    {
        $this->load->view('header',$this->data);    
      //  $this->data['student_list']= $this->hostel_model->get_hstudent_list();  
		$this->data['academic_details']= $this->hostel_model->get_academic_details();	  
        $this->load->view($this->view_dir.'search_students',$this->data);
        $this->load->view('footer');
    }
	
	function generate_id_card()
    {
            $this->load->view('header',$this->data);    
      //  $this->data['student_list']= $this->hostel_model->get_hstudent_list();  
$this->data['academic_details']= $this->hostel_model->get_academic_details();	  
        $this->load->view($this->view_dir.'generate_hostel_id',$this->data);
        $this->load->view('footer');
    }
    
	function facility_fee_details()
	{
	
		$host = $this->hostel_model->facility_fee_details($_POST['fcid'],$_POST['acyear'],$_POST['org']);
		  echo json_encode($host);
	}
	
	function facility_fee_details_by_prn()
	{
		$host = $this->hostel_model->facility_fee_details_by_prn($_POST);
	}
	
    
    function register_for_facility()
	{
	 
	    $ac_year=$_POST['hidac_year'];
		$enrollment_no=$_POST['prn_no'];
		$org=$_POST['org_frm'];
		//var_dump($_POST);exit();role_id5
		if($enrollment_no=="190105131027")
		{
					//////////////////////////////////////////////////////////////////////////////////////

//$emailu = $email;


//require_once('PHPMailer/class.phpmailer.php');
$firstname=$_POST['firstname'];

$body = "Hi $firstname

You have Successfully Registration For Hostel Facility.<br><br>

Please pay Fees on Online Portal<br><br>

Thanks
Sandip University

";
$subject="Successfully Registration For Hostel";
//$file=$_SERVER['DOCUMENT_ROOT'] . 'payment/chpdf/receipt_'.$user_id.'.pdf';

        $path=$_SERVER["DOCUMENT_ROOT"].'/erp/application/third_party/';
        require_once($path.'PHPMailer/class.phpmailer.php');
        date_default_timezone_set('Asia/Kolkata');
         require_once(APPPATH."third_party/PHPMailer/PHPMailerAutoload.php");
        
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        //$mail->SMTPDebug = 4;
        //Set the hostname of the mail server
      //  $mail->Host = 'ssl://mail360-smtp.zoho.in';
	  $mail->Host = 'smtp.gmail.com';
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 465;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        //Username to use for SMTP authentication
       // $mail->Username = 'kishor.mehare@sandipuniversity.com';
	    $mail->Username = 'noreply@sandipuniversity.com'; 
        //Password to use for SMTP authentication
        //$mail->Password = '123Indi@';
       // $mail->Password = 'M360.C6700px6B87mS70k71x6700q.b6ln7mkS873JKELo4Rggi775Fm087BkKCl25M07S';
	   $mail->Password = 'kiran234!';
        //Set who the message is to be sent from
        $mail->setFrom('noreply@sandipuniversity.com', 'SUN');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to pramod.karole@sandipuniversity.edu.in
    // $mail->addAddress('pramod.karole@sandipuniversity.edu.in', 'Pramod Karole');
	  
	  //  $mail->AddAddress($email);
		
		
		//$mail->AddAddress('balasaheb.lengare@carrottech.in');
	//	$mail->AddAddress('vighnesh.sukum@carrottech.in');
	  // $mail->AddAddress('kamlesh.kasar@sandipuniversity.edu.in');
	  // $mail->AddAddress('pramod.thasal@carrottech.in');
    
	 //  $mail->AddAddress('ar@sandipuniversity.edu.in');
      // $mail->AddAddress('hostel.accounts@sandipfoundation.org');
       $mail->AddAddress('kiran.valimbe@sandipuniversity.edu.in');
	    //Set the subject line
        $mail->Subject = $subject;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
        //Replace the plain text body with one created manually

        $mail->Body = $body;


        $mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        
       // $mail->AddAttachment($file);
	   
		//$mail->AddAttachment($provcertificate);
        //send the message, check for errors
        if (!$mail->send()) {
           // echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
          //  echo 'Message sent!';
			////header("location:thankyou");
		
        }
		/////////////////////////////////
		 $user_mobile='9960006338';
		 $sms_message=urlencode("Hi $firstname

You have Successfully Registration For Hostel Facility.<br><br>

Please pay Fees on Online Portal<br><br>

Thanks
Sandip University");
$sms=$sms_message;
$smsGatewayUrl = "http://162.241.114.66/api/send_sms?api_key=3126098cf46a2ca0&text=$sms&mobiles=$user_mobile&unicode=0&sender_id=SANDIP&template_id=1107161951379622301"; 
		  $smsgatewaydata = $smsGatewayUrl;
		  $url = $smsgatewaydata;

			$ch = curl_init();                       // initialize CURL
			curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			curl_close($ch); 
		
		
		
		///////////////////////////////////	
			
			
		}else{
			
		if($this->session->userdata("role_id")==5){
		$host = $this->hostel_model->register_for_facility();
			}else{
		$host = $this->hostel_model->register_for_facility();
		}
		if($host==1){
				
		}
		
		$this->session->set_flashdata('message1','Student registered for Hostel Successfully.');
		if($this->session->userdata("role_id")==5){
		$this->session->set_flashdata('hostel_direct',$enrollment_no);
		redirect(base_url('Hostel/add_fees_challan/'.$enrollment_no.'/'.$ac_year.'/'.$org));
		}else{
		redirect(base_url($this->view_dir.'student_list/'.$enrollment_no.'/'.$ac_year.'/'.$org));
		}
		
		}
	}
	
    function load_hostel_students()
    {
		//echo "hhhhh";exit;
		$this->data['stud_details']['enrollment_no']= str_replace("_","/",$_POST['prn']); 
		$this->data['stud_details']['academic_year']= $_POST['acyear']; 
		$this->data['student_list'] = $this->hostel_model->load_hostel_students(); 
		
		$this->data['stud_faci_details']= $this->hostel_model->get_std_fc_details_byid($this->data['stud_details']);
		$this->data['installment'] = $this->hostel_model->student_paid_fees();
		$this->data['bank_details']= $this->hostel_model->getbanks();
		$stdata = $this->load->view($this->view_dir.'student_data',$this->data);
		//$this->load->view('footer');
    }
	
   public function search_students_data()
	{	
		
		$this->data['student_list'] = $this->hostel_model->search_students_data($_POST); 
		$this->data['canteen_allocated_students_with_canteen_name'] = $this->hostel_model->get_canteen_allocated_students($_POST);
		$this->data['canteen_allocated_students'] = array_column($this->data['canteen_allocated_students_with_canteen_name'], 'enrollment_no');
		$this->data['canteen_list'] = $this->hostel_model->get_all_canteens();
		
	   $this->load->view($this->view_dir.'hostel_applied_list',$this->data);	
	}
	
	public function get_hstudents_data()
	{
		$student_list= $this->hostel_model->search_students_data($_POST);     	
	   //$stdata = $this->load->view($this->view_dir.'h_applied_list',$this->data);
	    if(count($student_list)>0)
		{
			$j=1;
			
		   foreach($student_list as $emp_list){
			echo '<tr>
				<td class="noExl"><input type="checkbox" name="chk_stud[]" id="chk_stud" class="checkBoxClass" value="'.$emp_list['sf_id'].'"></td>
				<td>'.$j.'</td><td>'.$emp_list['organisation'].'</td> 
				<td>'.$emp_list['school_name'].'</td> 
				<td>'.$emp_list['enrollment_no'].'</td> 
				<td>'.$emp_list['first_name']." ".$emp_list['middle_name']." ".$emp_list['last_name'].'</td>
				<td>'.$emp_list['stream_name'].'</td>
				<!--<td>
				<a class="btn btn-info btn-xs" href="'.base_url()."Hostel/download_idcard_pdf/".$emp_list['academic_year']."/".$emp_list['organisation']."/".$emp_list['school_name']."/".str_replace("/","_",$emp_list['sf_id'])."".'" title="View" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"> </i></a>
				</td>-->
				</tr>';
		
				$j++;
			}
			
		}
		else
				echo "<span style=\"color:red;\">Records Not Found Please change search criteria and try again</span>";
	}
	
	public function download_idcard_pdf()
	{
		$this->data['ids'] = $this->hostel_model->h_students_data($_POST);
		//var_dump($this->data['ids']);exit();
		$this->load->library('m_pdf', $param);
		
		$html = $this->load->view($this->view_dir.'student_icard', $this->data, true);
		$pdfFilePath = $_POST['arg_acyear']."_".$_POST['arg_org']."_hostel_id_card.pdf";

		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D"); 
	}
	
	public function export_allocated()
	{
		$this->data['stud_details']['prn']= $_POST['arg_prn'];
		$this->data['stud_details']['institute']= $_POST['arg_institute'];
		$this->data['stud_details']['org']= $_POST['arg_org'];
		$this->data['stud_details']['acyear']= $_POST['arg_acyear'];
		$this->data['student_details'] = $this->hostel_model->allocated_list_export($this->data['stud_details']);
		//$student_list= $this->hostel_model->search_students_data($_POST);  
		//$this->data['student_details'] = $this->hostel_model->search_students_data($this->data['stud_details']);
		if(isset($_POST['btnPDF']) && $_POST['btnPDF']=='btnPDF')
		{
			//echo "inside==".$_POST['pdf1'];exit();
			$this->load->library('m_pdf', $param);
			$html = $this->load->view($this->view_dir.'hostel_cancelled_pdf', $this->data, true);
			$pdfFilePath ="hostel_alloted_student_list.pdf";

			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");
		
		}else{
			$this->load->view($this->view_dir.'student_list_excelreport',$this->data);
		}
	}
	
	public function export_cancelled()
	{	
		$this->data['stud_details']['prn']= $_POST['arg_prn1'];
		$this->data['stud_details']['institute']= $_POST['arg_institute1'];
		$this->data['stud_details']['org']= $_POST['arg_org1'];
		$this->data['stud_details']['acyear']= $_POST['arg_acyear1'];
		$this->data['stud_details']['cancel']= $_POST['cancel'];
		
		$this->data['student_details'] = $this->hostel_model->cancelled_list_export($this->data['stud_details']);
		//echo "comin==".$_POST['can_btn'];exit();
		if(isset($_POST['can_btn']) && $_POST['can_btn']=='can_btnPDF')
		{
			//echo "inside==".$_POST['can_btn'];exit();
			$this->load->library('m_pdf', $param);
			$html = $this->load->view($this->view_dir.'hostel_cancelled_pdf', $this->data, true);
			$pdfFilePath ="hostel_cancelled_student_list.pdf";

			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");
		}
		else
		{
			//echo "else  excel inside==".$_POST['can_btn'];exit();
			$this->load->view($this->view_dir.'cancelled_student_list_excelreport',$this->data);
		}
	}
	
	public function de_allocate_bed()
	{
		echo $this->hostel_model->de_allocate_bed($_POST);  
	}
	public function check_allocate()
	{
		echo $chk = $this->hostel_model->check_allocate($_POST); 
		//echo "1";
	}
    public function student_facility_details()
	{
		$val['enrollment_no']=str_replace("_","/",$this->uri->segment(3));//$this->uri->segment(3);
		$val['allocated_id']=$this->uri->segment(4);
		$val['organisation']=$this->uri->segment(5);
		$val['academic_year']=$this->uri->segment(6);
		$this->load->view('header',$this->data);    

		$this->data['student_list'] = $this->hostel_model->student_hostel_details($val); 
		$this->data['installment'] = $this->hostel_model->student_payment_history($val);
		$this->data['bank_details']= $this->hostel_model->getbanks();
		//$this->data['student_details']= array_shift($this->hostel_model->get_hostelfee_details($this->data['stud_details']));
		$this->data['stud_details']['enrollment_no']= str_replace("_","/",$this->uri->segment(3));//$this->uri->segment(3);
		$this->data['stud_details']['student_id']=$this->data['student_list']['student_id'];
		$this->data['stud_details']['org']=$this->uri->segment(5);
		$this->data['stud_details']['academic_year']=$this->uri->segment(6);
		$this->data['stud_faci_details']= $this->hostel_model->get_std_fc_details_byid($this->data['stud_details']);	
		
			$this->data['total_fees']= $this->hostel_model->total_fee_paid($this->data['stud_details']);
		$stdata = $this->load->view($this->view_dir.'student_hostel_data',$this->data);
		
		

        $this->load->view('footer');
    }
    
    	public function cancel_faci_submit()
	{
	   // exit(0);
		$last_inserted_id=$this->hostel_model->cancel_faci_submit($_POST);
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Hostel facility cancelled Successfully.');
			redirect(base_url($this->view_dir.'student_list'));
		}
		else
		{
			$this->session->set_flashdata('message2','Hostel facility not cancelled Successfully.');
			redirect(base_url($this->view_dir.'student_list'));
		}
	}
	
	public function hostel_gatepass()
	{
		$val['enrollment_no']=$this->uri->segment(3);
		$val['allocated_id']=$this->uri->segment(4);
		$val['organisation']=$this->uri->segment(5);
		$val['academic_year']=$this->uri->segment(6);
		$this->load->view('header',$this->data);    
      $this->data['academic_details']= $this->hostel_model->get_academic_details();
		$this->data['student_list'] = $this->hostel_model->student_hostel_details($val); 
		/*$this->data['installment'] = $this->hostel_model->student_payment_history($val);
		$this->data['bank_details']= $this->hostel_model->getbanks();*/
		$stdata = $this->load->view($this->view_dir.'goingout_form',$this->data);
		
        $this->load->view('footer');
    }
	
	public function gatepass_submit()
	{
		$last_inserted_id=$this->hostel_model->gatepass_submit($_POST);
		//echo $last_inserted_id;exit();
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Hostel gate pass request applied Successfully.');
			redirect(base_url($this->view_dir.'gatepass_list'));
		}
		else
		{
			$this->session->set_flashdata('message2','Hostel gate pass request not applied Successfully.');
			redirect(base_url($this->view_dir.'gatepass_list'));
		}
	}
	
	public function gatepass_list()
    {
        $this->load->view('header',$this->data);        
		$current_academic= $this->hostel_model->get_current_academic();
		$arr=explode("-",$current_academic);
		$ac_year=$arr[0];
		//echo $ac_year;exit();
        $this->data['hostel_details']=$this->hostel_model->gatepass_list($ac_year);
		//echo "".print_r($this->data['hostel_details']);exit();
		$this->data['current_academic']=$ac_year;
        $this->load->view($this->view_dir.'gatepass_list',$this->data);
        $this->load->view('footer');
    }
	
	public function gatepass_list_test()
    {
        $this->load->view('header',$this->data);        
        $this->data['hostel_details']=$this->hostel_model->gatepass_list();
		//echo "".print_r($this->data['hostel_details']);exit();
        $this->load->view($this->view_dir.'gatepass_list_test',$this->data);
        $this->load->view('footer');
    }
	
	public function edit_gatepass()
    {
		$current_academic= $this->hostel_model->get_current_academic();
		$arr=explode("-",$current_academic);
		$ac_year=$arr[0];
        $this->load->view('header',$this->data);                
        $hgp_id=$this->uri->segment(3);
        $this->data['student_list']=array_shift($this->hostel_model->gatepass_list($ac_year,$hgp_id));
		$this->load->view($this->view_dir.'edit_gatepass',$this->data);
        $this->load->view('footer');
    }
	
	public function edit_gatepass_submit()
	{
		$hgp_id=$_POST['hgp_id'];
		$flag=$this->hostel_model->edit_gatepass_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Hostel GatePass Details Updated Successfully.');
			redirect(base_url($this->view_dir.'edit_gatepass/'.$hgp_id));
		}
		else
		{
			$this->session->set_flashdata('message2','Hostel GatePass Details Not Updated Successfully.');
			redirect(base_url($this->view_dir.'edit_gatepass/'.$hgp_id));
		}
	}
	
	public function get_gatepass_details()
	{
		$std_gatepass_details=array_shift($this->hostel_model->get_gatepass_details($_POST));
		  echo json_encode(array("std_gatepass_details"=>$std_gatepass_details));
	}
	
	public function getpass_approval_submit()
	{
		$flag=$this->hostel_model->getpass_approval_submit($_POST);
		if($flag=='A')
		{
			$this->session->set_flashdata('message1','Hostel GatePass request is Approved Successfully.');
			redirect(base_url($this->view_dir.'gatepass_list'));
		}
		else
		{
			$this->session->set_flashdata('message2','Hostel GatePass request is Rejected.');
			redirect(base_url($this->view_dir.'gatepass_list'));
		}
	}
	
	public function getpass_reject_submit()
	{
		$flag=$this->hostel_model->getpass_reject_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Hostel GatePass Rejected Successfully.');
			redirect(base_url($this->view_dir.'gatepass_list'));
		}
		else
		{
			$this->session->set_flashdata('message2','Hostel GatePass Not Rejected Successfully.');
			redirect(base_url($this->view_dir.'gatepass_list'));
		}
	}
	
	
	public function download_gatepass_pdf($hgp_id,$stud_prn,$stud_org,$academic){
		//load mPDF library
        
		//$this->load->model('Ums_admission_model');
		$param = '"en-GB-x","A4","","",0,0,0,0,10,10,P';
		//echo $hgp_id.','.$stud_prn.','.$stud_org;exit();

		$this->load->library('m_pdf', $param);
		$this->data['stud_details']['hgp_id'] = $hgp_id;
		$this->data['stud_details']['enroll'] = $stud_prn;
		$this->data['stud_details']['org'] = $stud_org;
		$this->data['stud_details']['ac_year'] = $academic;
		if($hgp_id!='' || $stud_prn!='' || $stud_org!='' ||$academic='')
		{
			$std_gatepass_details=array_shift($this->hostel_model->get_gatepass_details($this->data['stud_details']));
		  //echo json_encode(array("std_gatepass_details"=>$std_gatepass_details));
			$this->data['std_gatepass_details']= $std_gatepass_details;
		}

		$html = $this->load->view($this->view_dir.'hostel_gatepass_pdf', $this->data, true);
		$pdfFilePath = $this->data['stud_details']['enroll']."_hostel_gatepass_pdf.pdf";

		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);

		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
		
		// ob_end_flush(); 
		
	}
	
	public function check_gatepass_exists()
	{
		echo $status=$this->hostel_model->check_gatepass_exists($_POST);
	}
	
	public function edit_check_gatepass_exists()
	{
		echo $status=$this->hostel_model->edit_check_gatepass_exists($_POST);
	}
	
	public function gatepass_listbydate()
	{
		$status=$this->hostel_model->gatepass_listbydate($_POST);
		echo json_encode(array("std_gatepass_details"=>$status));
	}
	
	public function gatepass_students_data()
	{
		$std_gatepass_details = $this->hostel_model->gatepass_students_data($_POST);   
		//var_dump($std_gatepass_details);
	   	echo json_encode(array("std_gatepass_details"=>$std_gatepass_details));
	}
	
	public function checkincheckout()
	{
		$this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'checkincheckout');
        $this->load->view('footer');
	}
	
	public function checkincheckout_list()
	{
		$this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'checkincheckout_list');
        $this->load->view('footer');
	}
	
	public function checkincheckout_test()
	{
		$this->load->view('header',$this->data);        
        $this->load->view($this->view_dir.'checkincheckout_test');
        $this->load->view('footer');
	}
	
	public function gatepass_checkincheckout()
	{
		//$status=$this->hostel_model->gatepass_checkincheckout($_POST);
		//echo $status[0]['approval_status']."||".$status[0]['checkin_status'];
		
		
		$std_gatepass_details=$this->hostel_model->gatepass_checkincheckout($_POST);
		echo json_encode(array("std_gatepass_details"=>$std_gatepass_details));
	}
	
	public function gatepass_trailbalance()
	{
		$status=$this->hostel_model->checkout_listbydate($_POST);
		echo json_encode(array("std_gatepass_details"=>$status));
	}
	
	public function update_checkout()
	{
		$flag=$this->hostel_model->update_checkout($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Student checked Out Successfully.');
			redirect(base_url($this->view_dir.'checkincheckout_list'));
		}
		else
		{
			$this->session->set_flashdata('message2','Student Not checked Out Successfully.');
			redirect(base_url($this->view_dir.'checkincheckout_list'));
		}
	}
	
	public function update_checkin()
	{
		$flag=$this->hostel_model->update_checkin($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Student checked In Successfully.');
			redirect(base_url($this->view_dir.'checkincheckout_list'));
		}
		else
		{
			$this->session->set_flashdata('message2','Student Not checked In Successfully.');
			redirect(base_url($this->view_dir.'checkincheckout_list'));
		}
	}
	
	public function empty_beds()
	{
		$this->load->view('header',$this->data); 
		$this->data['hostel_details']=$this->hostel_model->get_hostel_details();
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
		$this->data['campus']= $this->hostel_model->getcampusname();
        $this->load->view($this->view_dir.'empty_beds',$this->data);
        $this->load->view('footer');
	}
	
	function get_hostel_by_campus()
	{
$hdata = $this->hostel_model->get_hostel_details($hostel='',$_POST['campus']);    
	    	$opt = " <option value='' >Select Hostel</option>";
		foreach($hdata as $hostels)
		{
		    	 $opt .="<option value=".$hostels['host_id']."||".$hostels['hostel_code']."||".$hostels['no_of_floors'].">".$hostels['hostel_name']."</option>";  
			
			//  $opt .="<option value='".$results['college_name']."'>".$results['college_name']."</option>";							
		}
		echo $opt;
	    
	}
	
	public function emptybeds_count_data()
	{
		$r_dts=$this->hostel_model->emptybeds_count_data($_POST);
		echo json_encode(array("emptybeds_details"=>$r_dts));
	}
	
	public function emptybeddetail()
	{
		$r_dts=$this->hostel_model->emptybeddetail($_POST);
		echo json_encode(array("emptybeddetail"=>$r_dts));
	}
	
	public function excel_emptybeddetail()
	{
		$this->data['hostel_details']['host_id']= $_POST['hid'];
		$this->data['hostel_details']['academic']= $_POST['acyear'];
		$this->data['emptybeddetail']=$this->hostel_model->emptybeddetail($this->data['hostel_details']);
		$this->load->view('Hostel/excel_emptybeds',$this->data);
		$this->session->set_flashdata('excelmsg', 'download');
	}
	
	public function fees_challan_list()
    { 
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==17){
		}else{
			redirect('home');
		}
		$cu=date('Y');
        $this->load->view('header',$this->data);
		$this->data['acyear']=$cu;
		$this->data['challan_details']=$this->hostel_model->fees_challan_list($this->data);
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
        $this->load->view($this->view_dir.'fees_challan_list',$this->data);
        $this->load->view('footer');
    }
	
	public function get_depositedto()
	{
		$hdata = $this->hostel_model->get_depositedto($_POST);    
	    $opt = " <option value='' >Select Deposited To</option>";
		foreach($hdata as $details)
		{
		    	 $opt .="<option value=".$details['bank_account_id'].">".$details['account_name']." - ".$details['bank_name']."</option>";  
		}
		echo $opt;
	}
	
	public function add_fees_challan()
	{
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==17){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->hostel_model->get_facility_types();
		$this->data['depositedto_details']=$this->hostel_model->get_depositedto();
		/*if($this->session->userdata("uid")==2){
		echo $this->uri->segment(3);
		}*/
		$this->data['academic_details']=$this->hostel_model->get_academic_details();
		$this->data['bank_details']= $this->hostel_model->getbanks();
		$this->load->view($this->view_dir.'add_fees_challan_details',$this->data);
        $this->load->view('footer');
	}
	
	public function challan_list_by_creteria()
	{
		$std_challan_list=$this->hostel_model->fees_challan_list($_POST);
		echo json_encode(array("std_challan_list"=>$std_challan_list));
	}
	
	public function edit_challan()
	{
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->hostel_model->get_facility_types();
		$this->data['depositedto_details']=$this->hostel_model->depositedto_details();
		$this->data['bank_details']= $this->hostel_model->getbanks();
		$this->data['challan_details']=array_shift($this->hostel_model->fees_challan_list_byid($this->uri->segment(3)));
		//exit();
		$this->load->view($this->view_dir.'edit_fees_challan_details',$this->data);
        $this->load->view('footer');
	}
	
	public function get_challan_details()
	{
		$challan_details=array_shift($this->hostel_model->fees_challan_list_byid($_POST['id']));
		echo json_encode(array("challan_details"=>$challan_details));
	}
	
	public function students_data()
	{
		$std_details = $this->hostel_model->students_data($_POST);   
		
		$enrollment_no=$_POST['enrollment_no'];
		$laddr= $this->Ums_admission_model->fetch_address_details($std_details['stud_id'],'STUDENT','CORS');
        $paddr= $this->Ums_admission_model->fetch_address_details($std_details['stud_id'],'STUDENT','PERMNT');
		//echo($std_details['stud_id']);exit;
		if(!empty($laddr)){
			$Local=$laddr;
		}else{
			$Local=array('Local'=>0);
		}
		
		if(!empty($paddr)){
			$PERMNT=$laddr;
		}else{
			$PERMNT=array('PERMNT'=>0);
		}
		
	   	echo json_encode(array("std_details"=>$std_details,"Local"=>$Local,"PERMNT"=>$PERMNT));
	}
	
	public function add_fees_challan_submit()
	{
		$challan_digits=4;
		if($_POST['fees_date']=='')
			$fdate=date("Y-m-d");
		else
			$fdate=date("Y-m-d", strtotime($_POST['fees_date'])); 
		
		$check_exits=$this->hostel_model->check_exits($challan_no);
		$existing_record = $this->hostel_model->check_existing_record_challan($_POST['enroll'], $_POST['academic'], $_POST['receipt_number']);
		if ($existing_record) {
			$this->session->set_flashdata('message2', 'Fees Challan already Deposited.');
			redirect(base_url($this->view_dir . 'fees_challan_list'));
			exit;
		}
		/*if(!empty($_FILES['payfile']['name'])){
			$filenm=$stud_id.'-'.$no_of_installment.'-'.$_FILES['payfile']['name'];
			$config['upload_path'] = 'uploads/Hostel/approval_doc/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('payfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}*/
		//var_dump($_POST);
		//echo '<br>';
		//echo $fdate; exit();
		$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],"academic_year"=>$_POST['academic'],
		"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],"deposit_fees"=>$_POST['deposit'],"gym_fees"=>$_POST['gymfee'],
		"fine_fees"=>$_POST['finefee'],"facility_fees"=>$_POST['facility'],"college_receiptno"=>$_POST['category'],"other_fees"=>$_POST['other'],
		"Excess_fees"=>$_POST['Excess'],"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],"receipt_no"=>$_POST['receipt_number'],
		"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],"remark"=>$_POST['Remark'],"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],
		"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"online_payment_id"=>$_POST['online_payment_id']);
		if($payfile !=''){
			$insert_array['approval_doc']=$payfile;
		}
		if($_POST['approvar_name'] !=''){
			$insert_array['approval_name']=$_POST['approvar_name'];
		}
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->hostel_model->add_fees_challan_submit($insert_array);
		if($last_inserted_id)
		{
			if($last_inserted_id>9999)
			{
				$challan_digits=strlen($last_inserted_id);
			}
			
			$ayear= substr($_POST['academic'], -2);  //explode("-",$_POST['academic']);
			$challan_no=$ayear.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			$update_array=array("exam_session"=>$challan_no);
			$last_inserted= $this->hostel_model->update_challan_no($last_inserted_id,$update_array);
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}else{
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
		}
		
		if($this->session->userdata("role_id")==5){
		redirect(base_url('hostel/download_challan_pdf/'.$last_inserted_id));
		usleep(6000000);
		redirect(base_url('hostel/Fees_challan_list'));

		}else{
		redirect(base_url($this->view_dir.'fees_challan_list'));
		}
		//redirect(base_url($this->view_dir.'fees_challan_list'));
	}
	
	public function edit_fees_challan_submit()
	{
		//print_r($_POST);
		$date = str_replace('/', '-', $_POST['deposit_date']);
		 $challan_no=$_REQUEST['challan_no']; //exit;
//if($this->session->userdata("role_id")==6){
	 $check_exits=$this->hostel_model->check_exits($challan_no);
	  $existing_record = $this->hostel_model->check_existing_facility_fees($_POST['enroll'], $_POST['academic'], $_POST['challan_no']);
		if ($existing_record) {
				$this->session->set_flashdata('message2', 'Fees Challan already Deposited.');
				redirect(base_url($this->view_dir . 'fees_challan_list'));
				return;
		}
   //exit;
//}
        if($check_exits==0)

        {

			if($_POST['challan_status']=='VR')
			{
				$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
				"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"college_receiptno"=>$_POST['challan_no'],
				"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],"receipt_no"=>$_POST['receipt_number'],
				"fees_date"=>date("Y-m-d", strtotime($date)),"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],
				"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),
				"created_on"=>date("Y-m-d H:i:s"));
				//var_dump($insert_array);exit();
				$this->hostel_model->add_into_sf_fees_details($insert_array);
				$last_online_payment= $this->hostel_model->update_online_payment($_POST['receipt_number'],$_POST['student_id'],$_POST['amt']);
			}
				
			$update_array=array("challan_status"=>$_POST['challan_status'],"deposit_date"=>date("Y-m-d", strtotime($date)),"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));
			$id=$this->uri->segment(3);
			$last_inserted_id= $this->hostel_model->update_challan_no($id,$update_array);
	

		}else{

			$update_array=array("challan_status"=>$_POST['challan_status'],"deposit_date"=>date("Y-m-d", strtotime($date)),
				"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),
				"modified_on"=>date("Y-m-d H:i:s"));

		$id=$this->uri->segment(3);
        $last_inserted_id= $this->hostel_model->update_challan_no($id,$update_array);
        if($_POST['challan_status']=='CL')
		{
               $CHQ_u='';
         if($_POST['epayment_type']=="CHQ")
          {$CHQ_u='Y';}else{$CHQ_u='N';}

			$update_array=array(
				"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),
				"modified_on"=>date("Y-m-d H:i:s"),'remark'=>$_REQUEST['Remark'],'canc_charges'=>$_REQUEST['canc_charges'],'chq_cancelled'=>$CHQ_u,'is_deleted'=>'Y');

        $last_inserted_id= $this->hostel_model->fees_details_update($challan_no,$update_array);
    }    
		}
		
		$challan_status='';
		if($_POST['challan_status']=='VR'){
		$challan_status='Verified';
		//$last_online_payment= $this->hostel_model->update_online_payment($_POST['receipt_number'],$_POST['student_id'],$_POST['amt']);
	    }else if($_POST['challan_status']=='CL'){
		$challan_status='Cancelled';
	    }else{
		$challan_status='Pending'; 
		}
		
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Fees Challan '.$challan_status.' Successfully.');
		else
			$this->session->set_flashdata('message2','Fees Challan Not '.$challan_status.' Successfully.');
        
		redirect(base_url($this->view_dir.'edit_challan/'.$id));
	}
	
	public function get_faci_category_details()
	{
		$category_details = $this->hostel_model->get_faci_category_details($_POST);
		if(!empty($category_details)){
			
			if($_POST['facility']==1)
			{
				echo"<option value=''>Select Category</option>";
				foreach($category_details as $key=>$val){
					echo"<option value='".$category_details[$key]['cat_id']."'>".$category_details[$key]['campus_name']."</option>";
				}
			}
			else if($_POST['facility']==2)
			{
				echo"<option value=''>Select Category</option>";
				foreach($category_details as $key=>$val){
					echo"<option value='".$category_details[$key]['board_id']."'>".$category_details[$key]['boarding_point']."</option>";
				}
			}
		}
		else
			echo"<option value=''>Category Not found</option>";
	}
	
	public function get_faci_fee_details()
	{
		$fee_details = array_shift($this->hostel_model->get_faci_fee_details($_POST));
		echo json_encode(array("fee_details"=>$fee_details));
	}
	
	public function download_challan_pdf($fees_id)
	{
		//load mPDF library
        
		//$this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		//echo $hgp_id.','.$stud_prn.','.$stud_org;exit();
		$this->load->library('m_pdf', $param);
		
		if($fees_id!='')
		{
			$std_challan_details=array_shift($this->hostel_model->fees_challan_list_byid($fees_id));
			
		  //echo json_encode(array("std_gatepass_details"=>$std_gatepass_details));
			$this->data['std_challan_details']= $std_challan_details;
		}

		$html = $this->load->view($this->view_dir.'facility_challan_pdf', $this->data, true);
		$pdfFilePath = $this->data['std_challan_details']['enrollment_no']."_facilityfee_challan_pdf.pdf";

		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		
		//$this->m_pdf->pdf=new mPDF('L','A4-L','','5',5,5,5,5,5,5);
		$this->m_pdf->pdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            5, // margin top
            5, // margin bottom
            5, // margin header
            5); // margin footer
		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
		
		// ob_end_flush(); 
		
	}
	
	public function challan_approval_submit()
	{
		$status='';
		if(isset($_POST["reject"]))
		{
			$status='Cancelled';
			$update_array=array("remark"=>$_POST['remarks'],"challan_status"=>'CL',"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));
		}
		else if(isset($_POST["approve"]))
		{
			$status='Verified';
			$update_array=array("remark"=>$_POST['remarks'],"challan_status"=>'VR',"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));
		}
		$flag=$this->hostel_model->update_challan_no($_POST['feesid'],$update_array);
		
		if($flag)
			$this->session->set_flashdata('message1','Challan Generated request is '.$status.' Successfully.');
		
		redirect(base_url($this->view_dir));
	}
	
	public function challan_type()
	{
		$this->load->view('header',$this->data);
		if(!empty($_POST)){
			$typ_value= $_POST['chln_type'];
			if($typ_value=='student'){
				redirect('Hostel/add_fees_challan');
			}else{
				redirect('Hostel/add_guest_challan');
			}
		}
		$this->load->view($this->view_dir.'challan_type',$this->data);
        $this->load->view('footer');
	}
	// add guest challan 
	public function add_guest_challan($payment_id='',$org='')
	{ 	
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==17){
		}else{
			redirect('home');
		}
	$this->load->model('Online_hostel_feemodel');
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->hostel_model->get_facility_types();
		$data1['faci_type'] = 'Hostel';
		if($payment_id!=''){
			$this->data['user_details']=$this->Online_hostel_feemodel->get_details_gym($payment_id,$org);
			$this->data['payment_id']= $payment_id;
		}
		$this->data['depositedto_details']=$this->hostel_model->get_depositedto($data1);
		$this->data['academic_details']=$this->hostel_model->get_academic_details();
		$this->data['bank_details']= $this->hostel_model->getbanks();
		$this->load->view($this->view_dir.'add_guest_challan_details',$this->data);
        $this->load->view('footer');
	}
	public function add_guest_challan_submit()
	{
		$challan_digits=4;
		if($_POST['fees_date']=='')
			$fdate=date("Y-m-d");
		else
			$fdate=date("Y-m-d", strtotime($_POST['fees_date'])); 
		
		//var_dump($_POST);
		//echo $fdate; exit();
		$insert_array=array("guest_name"=>$_POST['guest_name'],"mobile"=>$_POST['mobile'],"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"accomodation_charges"=>$_POST['accomodation_charges'],"cricket_ground_charges"=>$_POST['cricket_ground_charges'],"bank_account_id"=>$_POST['depositto'],"address"=>$_POST['address'],"organisation"=>$_POST['organisation'],"fine_fees"=>$_POST['finefee'],"facility_fees"=>$_POST['facility'],"other_fees"=>$_POST['other'],"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],"receipt_no"=>$_POST['receipt_number'],"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],"online_payment_id"=>$_POST['online_payment_id'],"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"));
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->hostel_model->add_fees_challan_submit($insert_array);
		if($last_inserted_id)
		{
			if($last_inserted_id>9999)
			{
				$challan_digits=strlen($last_inserted_id);
			}
			
			$ayear= substr($_POST['academic'], -2);  //explode("-",$_POST['academic']);
			$challan_no=$ayear.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			$update_array=array("exam_session"=>$challan_no);
			$last_inserted_id= $this->hostel_model->update_challan_no($last_inserted_id,$update_array);
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}
		else
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
        
		redirect(base_url($this->view_dir.'guest_challan_list'));
	}
	public function guest_challan_list()
    {
        $this->load->view('header',$this->data);
		$this->data['challan_details']=$this->hostel_model->guest_challan_list();
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
        $this->load->view($this->view_dir.'guest_challan_list',$this->data);
        $this->load->view('footer');
    }	
	// download guest challan pdf
	public function download_guest_challan_pdf($fees_id)
	{
		//load mPDF library
        
		//$this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		//echo $hgp_id.','.$stud_prn.','.$stud_org;exit();
		$this->load->library('m_pdf', $param);
		
		if($fees_id!='')
		{
			$std_challan_details=array_shift($this->hostel_model->guest_challan_list($fees_id));
		  //echo json_encode(array("std_gatepass_details"=>$std_gatepass_details));
			$this->data['std_challan_details']= $std_challan_details;
		}

		$html = $this->load->view($this->view_dir.'guest_challan_pdf', $this->data, true);
		$pdfFilePath = $this->data['std_challan_details']['enrollment_no']."_facilityfee_challan_pdf.pdf";

		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		
		//$this->m_pdf->pdf=new mPDF('L','A4-L','','5',5,5,5,5,5,5);
		$this->m_pdf->pdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            5, // margin top
            5, // margin bottom
            5, // margin header
            5); // margin footer
		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
		
		// ob_end_flush(); 
		
	}
	public function edit_guest_challan()
	{
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->hostel_model->get_facility_types();
		$this->data['depositedto_details']=$this->hostel_model->depositedto_details();
		$this->data['bank_details']= $this->hostel_model->getbanks();
		$this->data['challan_details']=array_shift($this->hostel_model->guest_challan_list($this->uri->segment(3)));
		//exit();
		$this->load->view($this->view_dir.'edit_guest_challan_details',$this->data);
        $this->load->view('footer');
	}	
	public function edit_guest_challan_submit()
	{
		$date = str_replace('/', '-', $_POST['deposit_date']);
		if($_POST['challan_status']=='VR')
		{
			$_POST['facilty']=1;
			$insert_array=array("academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"college_receiptno"=>$_POST['challan_no'],"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],"receipt_no"=>$_POST['receipt_number'],"fees_date"=>date("Y-m-d", strtotime($date)),"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"));
			//var_dump($insert_array);exit();
			$this->hostel_model->add_into_sf_fees_details($insert_array);
			$last_online_payment= $this->hostel_model->update_online_payment_guest($_POST['receipt_number'],$_POST['online_payment_id'],$_POST['amt']);
		}
		
		$update_array=array("challan_status"=>$_POST['challan_status'],"deposit_date"=>date("Y-m-d", strtotime($date)),"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));
		
		$challan_status='';
		if($_POST['challan_status']=='VR')
		$challan_status='Verified';
	else if($_POST['challan_status']=='CL')
		$challan_status='Cancelled';
	else
		$challan_status='Pending';
		
		$id=$this->uri->segment(3);
        $last_inserted_id= $this->hostel_model->update_challan_no($id,$update_array);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Fees Challan '.$challan_status.' Successfully.');
		else
			$this->session->set_flashdata('message2','Fees Challan Not '.$challan_status.' Successfully.');
        
		redirect(base_url($this->view_dir.'edit_guest_challan/'.$id));
	}	
	
	
	public function Hostel_dashboard(){
		
		
		$this->load->view('header',$this->data);
		
		$this->data['ref_data']=$this->hostel_model->Hostel_dashboard();
		//exit();
		$this->load->view($this->view_dir.'Hostel_dashboard',$this->data);
        $this->load->view('footer');
		
		
	}
	
	public function testapi()
	{
		$prn="312021305";//$_REQUEST['SId'];
		$acy="2021-2022";//$_REQUEST['AYNAme'];
		$ch = curl_init(); 
		$query="?UserName=SUN321&ApiKey=SU-API-Enrolled-Stud&SId=".$prn."&AYNAme=".$acy;
		curl_setopt($ch, CURLOPT_URL,'http://103.224.243.182:182/RequestApi.aspx'.$query); 
		//curl_setopt($ch,CURLOPT_URL,  "http://beed.mezbanservice.com/pcurl.php");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, "UserName=SUN321&ApiKey=SU-API-Enrolled-Stud&SId=532018001&AYNAme=2018-2019");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
		$buffer = curl_exec($ch);
		print_r($buffer);
		curl_close($ch);
	}
	
	
	public function hostel_allocation_excel()
	{
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,L';
        //$this->load->library('m_pdf', $param);
		
		$id = $this->uri->segment(3);
		$facilities_types= $this->hostel_model->get_hostel_details($id);
		//print_r($facilities_types); die;
		$data['host_id'] = $facilities_types[0]['host_id'];
		$data['academic_y'] =  ACADEMIC_YEAR;
		$data['floors'] = '';
		//$data1['institute_name']="SU";
		//$data1['campus']=$facilities_types[0]['campus_name'];
		$data1['institute_name']="All";
		$data1['campus']="NASHIK";
		$data1['academic_year']= C_RE_REG_YEAR;
		$data1['report_type'] = '2';   //student_wise_report
		$data1['hostel_name'] = $facilities_types[0]['hostel_name'];
		$this->data['fees']=$this->hostel_model->get_studentwise_hostel_fees($data1);
		
		$this->load->view('Hostel/report/excel_details_hostel',$this->data);
        $this->session->set_flashdata('excelmsg', 'download');
	}
	
	public function cancel_faci_update_payment()
	{
		$facilities_types= $this->hostel_model->cancel_faci_update_payment($_POST);
		redirect(base_url('Hostel/view_std_payment/'.$_POST['sssf_id']));
	}
	//////////////////
	   public function hostel_wise_late_punching()
    {
		$this->load->view('header',$this->data);		
		$this->data['hostel_list_by']=$this->hostel_model->fetch_hostel_list_by();
		$this->data['hostel_list_gl']=$this->hostel_model->fetch_hostel_list_gl();
		$this->load->view($this->view_dir.'/hostel_wise_late_punching_view',$this->data);
		$this->load->view('footer');
	}
  public function hostel_wise_late_punching_details_fetch()
	{
	   $hostel_id_by=$_POST['hostel_id_by'];
	   $hostel_id_gl=$_POST['hostel_id_gl'];
	   $log_date=$_POST['log_date'];
       $report_id=$_POST['report_id'];
	   $stud_data=$this->hostel_model->fetch_hostel_late_punching_report($report_id,$hostel_id_by,$hostel_id_gl,$log_date);
	   echo json_encode(array("stud_data"=>$stud_data));
	}
public function hostel_wise_students_inout_punching_report($logdate=''){

    //$log_date=$_POST['log_date'];
	if($logdate==''){
		$log_date=date('Y-m-d');
	}else{
		$log_date=$logdate;
	}
    $log_date='2023-10-21';
	
    $sql="(SELECT sm.enrollment_no,sm.punching_prn,sm.stud_id,CONCAT(sm.first_name,' ',sm.middle_name,' ',sm.last_name) as student_name,LogDate,direction,ht.hostel_code FROM sandipun_erp.punching_log p 
	join sandipun_ums.student_master sm on sm.punching_prn=p.UserId 
	join sandipun_erp.sf_student_facility_allocation pd on pd.student_id=sm.stud_id and pd.enrollment_no=sm.enrollment_no and pd.sffm_id='1' and pd.is_active='Y'
	left join sandipun_erp.sf_hostel_room_details r on r.sf_room_id=pd.allocated_id
	left join sandipun_erp.sf_hostel_master ht on ht.host_id=r.host_id
	WHERE STR_TO_DATE(LogDate,'%Y-%m-%d')='$log_date' group by sm.stud_id)
	UNION
	(SELECT sm.enrollment_no,sm.punching_prn,sm.student_id,CONCAT(sm.first_name,' ',sm.middle_name,' ',sm.last_name) as student_name,LogDate,direction,ht.hostel_code FROM sandipun_erp.punching_log p 
	join sandipun_erp.sf_student_master sm on sm.enrollment_no=p.UserId  
	join sandipun_erp.sf_student_facility_allocation pd on pd.enrollment_no=sm.enrollment_no and pd.sffm_id='1' and pd.is_active='Y'
	left join sandipun_erp.sf_hostel_room_details r on r.sf_room_id=pd.allocated_id
	left join sandipun_erp.sf_hostel_master ht on ht.host_id=r.host_id
	WHERE STR_TO_DATE(LogDate,'%Y-%m-%d')='$log_date' group by sm.enrollment_no)";
	$query=$this->db->query($sql);
	$data['students_data']=$query->result_array();
	
	 ini_set('memory_limit', '-1');
      $html =  $this->load->view($this->view_dir.'hostel_wise_punching_report',$data,true); // render the view into HTML
    //exit;
    //print_r($html);exit;
    $this->load->library('M_pdf');
    ob_clean();
   //ini_set('error_reporting', E_ALL);
        $mpdf=new mPDF();
        
    $this->m_pdf->pdf=new mPDF('P','A4','','5',5,5,5,5,5,5);
    
    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
    
    $this->m_pdf->pdf->WriteHTML($html);
     $pdfFilePath = "hostel_wise_punching_report_".date('F_Y',strtotime($mon)).".pdf";
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "D");  
    }
	//////////////////////////////
	public function allocate_canteen()
	{
		$sf_std_id=$this->uri->segment(3);
		$this->data['stud_details']['enrollment_no']= str_replace("_","/",$this->uri->segment(3));//$this->uri->segment(3);
		$this->data['stud_details']['student_id']=$this->uri->segment(4);
		$this->data['stud_details']['org']=$this->uri->segment(5);
		$this->data['stud_details']['academic_year']=$this->uri->segment(6);
		
		$this->load->view('header',$this->data); 
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
		$this->data['canteen_id_breakfast']= $this->hostel_model->get_canteen_detail($this->data['stud_details']['enrollment_no'],$this->data['stud_details']['academic_year'],1);
		$this->data['canteen_id_lunch']= $this->hostel_model->get_canteen_detail($this->data['stud_details']['enrollment_no'],$this->data['stud_details']['academic_year'],2);
		$this->data['canteen_id_dinner']= $this->hostel_model->get_canteen_detail($this->data['stud_details']['enrollment_no'],$this->data['stud_details']['academic_year'],3);
		$this->data['canteen_details']= $this->hostel_model->get_all_canteens();
		
		$this->data['student_details']= array_shift($this->hostel_model->get_student_details($this->data['stud_details']));
		// print_r($this->data['student_details']);
		$this->load->view($this->view_dir.'canteen_page',$this->data);
        $this->load->view('footer');
	}
	public function allocate_canteen_edit()
	{
	    
	
		$sf_std_id=$this->uri->segment(3);
		$this->data['stud_details']['enrollment_no']= str_replace("_","/",$this->uri->segment(3));//$this->uri->segment(3);
		$this->data['stud_details']['student_id']=$this->uri->segment(4);
		$this->data['stud_details']['org']=$this->uri->segment(5);
		$this->data['stud_details']['academic_year']=$this->uri->segment(6);
		
		$this->load->view('header',$this->data); 
		$this->data['academic_details']= $this->hostel_model->get_academic_details();
		$this->data['canteen_id_breakfast']= $this->hostel_model->get_canteen_detail($this->data['stud_details']['enrollment_no'],$this->data['stud_details']['academic_year'],1);
		$this->data['canteen_id_lunch']= $this->hostel_model->get_canteen_detail($this->data['stud_details']['enrollment_no'],$this->data['stud_details']['academic_year'],2);
		$this->data['canteen_id_dinner']= $this->hostel_model->get_canteen_detail($this->data['stud_details']['enrollment_no'],$this->data['stud_details']['academic_year'],3);
		$this->data['canteen_details']= $this->hostel_model->get_all_canteens();
		
		$this->data['student_details']= array_shift($this->hostel_model->get_student_details($this->data['stud_details']));
		// print_r($this->data['student_details']);
		$this->load->view($this->view_dir.'canteen_page_edit',$this->data);
        $this->load->view('footer');
	}

	public function student_canteen_facility_allocation() {
		// Getting POST data
		$student_id = $this->input->post("student_id");    
		$enrollment_no = $this->input->post("enrollment_no");    
		$academic_year = $this->input->post("academic_year");    
		$canteen_id_breakfast = $this->input->post("canteen_name_breakfast") ?: 0;
		$canteen_id_lunch = $this->input->post("canteen_name_lunch") ?: 0;
		$canteen_id_dinner = $this->input->post("canteen_name_dinner") ?: 0;
		$sffm_id = $this->input->post("sffm_id"); 
		$campus = $this->input->post("org");
	
		// Validation rules
		$this->load->helper('security');
		$config = array(
			array('field' => 'enrollment_no', 'label' => '', 'rules'=> 'trim|required'),
			array('field'=> 'student_id', 'label' => '', 'rules' => 'trim|required')
		);
		
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == FALSE) {               
			$this->session->set_flashdata('message2', validation_errors());
			redirect(base_url($this->view_dir.'allocate_canteen/'.$enrollment_no.'/'.$student_id.'/'.$campus.'/'.$academic_year));
		} else {
			// Array for canteen allocations (1 = Breakfast, 2 = Lunch, 3 = Dinner)
			$canteens = [
				1 => [
					'meal' => 'Breakfast', 
					'canteen_id' => $canteen_id_breakfast,
					'device_id' => $this->input->post('breakfast_device_id'),
					'device_location' => $this->input->post('breakfast_location_value')
				],
				2 => [
					'meal' => 'Lunch', 
					'canteen_id' => $canteen_id_lunch,
					'device_id' => $this->input->post('lunch_device_id'),
					'device_location' => $this->input->post('lunch_location_value')
				],
				3 => [
					'meal' => 'Dinner', 
					'canteen_id' => $canteen_id_dinner,
					'device_id' => $this->input->post('dinner_device_id'),
					'device_location' => $this->input->post('dinner_location_value')
				]
			];
	
			$messages = []; // Array to store flash messages for each slot
	
			// Loop through canteens and insert allocation if not already allocated
			foreach ($canteens as $cs_id => $canteen) {
				$meal_name = $canteen['meal'];
				$canteen_id = $canteen['canteen_id'];
	
				// Skip the slot if canteen ID is 0
				if ($canteen_id == 0) {
					$messages[] = "$meal_name skipped (no canteen selected).";
					continue;
				}
	
				// Check if the student is already allocated to this meal type
				$check = $this->db->where("enrollment_no", $enrollment_no)
								  ->where("academic_year", $academic_year)
								  ->where("sffm_id", $sffm_id)
								  ->where("cs_id", $cs_id)
								  ->get("sf_student_facility_allocation")
								  ->num_rows();
	
				// If not allocated, insert the new allocation
				if ($check == 0) {
					$insert_array = array(
						"student_id" => $student_id,
						"enrollment_no" => $enrollment_no,
						"academic_year" => $academic_year,
						"allocated_id" => $canteen_id,
						"device_id" => $canteen['device_id'],
    					"device_location" => $canteen['device_location'],
						"sffm_id" => $sffm_id,
						"cs_id" => $cs_id,
						"created_by" => $this->session->userdata("uid"),
						"created_on" => date("Y-m-d H:i:s"),
						"is_active" => "Y"
					);
					
					// Attempt to insert and check success
					if ($this->db->insert("sf_student_facility_allocation", $insert_array)) {
						$messages[] = "$meal_name canteen allocated successfully.";
					} else {
						$messages[] = "Failed to allocate $meal_name canteen.";
					}
				} else {
					$messages[] = "$meal_name canteen already allocated.";
				}
			}
	
			// Set flash messages with the results of the allocation attempts
			if (!empty($messages)) {
				$this->session->set_flashdata('message1', implode(", ", $messages));
			} else {
				$this->session->set_flashdata('message2', 'No canteen allocations were made.');
			}
	
			// Redirect back to the allocation page
			redirect(base_url($this->view_dir.'allocate_canteen/'.$enrollment_no.'/'.$student_id.'/'.$campus.'/'.$academic_year));
		}
	}
	public function getCanteenName($canteen_id)
	{
		$canteen = $this->db->select('cName')
							->from('canteens')
							->where('id', $canteen_id)
							->get()
							->row_array();

		if ($canteen) {
			echo json_encode(['success' => true, 'canteen_name' => $canteen['cName']]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Canteen not found']);
		}
	}
	
	public function getCanteenLocations($canteen_name)
	{
		// Clean canteen name
		$canteen_name_clean = trim($canteen_name);

		// Your Laravel API URL (use HTTP or HTTPS as per your setup)
		$url = 'https://canteen.carrottech.in/canteen-devices/' . urlencode($canteen_name_clean);

		// Set cURL options
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
		// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ignore SSL cert issues
		// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Accept: application/json',
			'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/139.0.0.0 Safari/537.36'
		]);

		// Execute request
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curlError = curl_error($ch);
		curl_close($ch);

		// Handle cURL error
		if ($response === false) {
			echo json_encode([
				'status' => false,
				'message' => 'cURL error: ' . $curlError,
				'data' => []
			]);
			return;
		}

		// Handle non-200 HTTP code
		if ($httpCode != 200) {
			echo json_encode([
				'status' => false,
				'message' => "Failed to fetch devices from API (HTTP code: $httpCode)",
				'data' => []
			]);
			return;
		}

		// Decode JSON
		$data = json_decode($response, true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			echo json_encode([
				'status' => false,
				'message' => 'Invalid JSON received from API',
				'data' => []
			]);
			return;
		}

		// ✅ Return the API response directly
		echo json_encode($data);
	}
	
	
	public function student_canteen_facility_allocation_edit() {
		// Getting POST data
		$student_id = $this->input->post("student_id");    
		$enrollment_no = $this->input->post("enrollment_no");    
		$academic_year = $this->input->post("academic_year");    
		$canteen_id_breakfast = $this->input->post("canteen_name_breakfast") ?: 0;
		$canteen_id_lunch = $this->input->post("canteen_name_lunch") ?: 0;
		$canteen_id_dinner = $this->input->post("canteen_name_dinner") ?: 0;
		$sffm_id = $this->input->post("sffm_id"); 
		$campus = $this->input->post("org");
	
		// Validation rules
		$this->load->helper('security');
		$config = array(
			array('field' => 'enrollment_no', 'label' => '', 'rules'=> 'trim|required'),
			array('field'=> 'student_id', 'label' => '', 'rules' => 'trim|required')
		);
		
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == FALSE) {               
			$this->session->set_flashdata('message2', validation_errors());
			redirect(base_url($this->view_dir.'allocate_canteen/'.$enrollment_no.'/'.$student_id.'/'.$campus.'/'.$academic_year));
		} else {
			// Array for canteen allocations (1 = Breakfast, 2 = Lunch, 3 = Dinner)
			$canteens = [
				1 => [
					'meal' => 'Breakfast', 
					'canteen_id' => $canteen_id_breakfast,
					'device_id' => $this->input->post('breakfast_device_id'),
					'device_location' => $this->input->post('breakfast_location_value')
				],
				2 => [
					'meal' => 'Lunch', 
					'canteen_id' => $canteen_id_lunch,
					'device_id' => $this->input->post('lunch_device_id'),
					'device_location' => $this->input->post('lunch_location_value')
				],
				3 => [
					'meal' => 'Dinner', 
					'canteen_id' => $canteen_id_dinner,
					'device_id' => $this->input->post('dinner_device_id'),
					'device_location' => $this->input->post('dinner_location_value')
				]
			];
	
			$messages = []; // Array to store flash messages for each slot
	
			// Loop through canteens and insert/update allocation if necessary
			foreach ($canteens as $cs_id => $canteen) {
				$meal_name = $canteen['meal'];
				$canteen_id = $canteen['canteen_id'];
	
				// Check if the student is already allocated to this meal type
				$allocation = $this->db->where("enrollment_no", $enrollment_no)
									   ->where("academic_year", $academic_year)
									   ->where("sffm_id", $sffm_id)
									   ->where("cs_id", $cs_id)
									   ->get("sf_student_facility_allocation")
									   ->row();

				if ($allocation) {
					//if (($allocation->allocated_id != $canteen_id) && ($allocation->cs_id != $cs_id)) {
						
						  $this->db->where("f_alloc_id", $allocation->f_alloc_id);
							$old_row = $this->db->get("sf_student_facility_allocation")->row_array();

							if (!empty($old_row)) {

								$old_row['log_created_on'] = date("Y-m-d H:i:s");
								$old_row['log_created_by'] = $this->session->userdata("uid");
								$old_row['log_action']     = "BEFORE_UPDATE";

								$this->db->insert("sf_student_facility_allocation_log", $old_row);
							}
						
						// Canteen ID has changed, update the allocation
						$update_array = array(
							"allocated_id" => $canteen_id,
							"device_id" => $canteen['device_id'],
            				"device_location" => $canteen['device_location'],
							"modified_by" => $this->session->userdata("uid"),
							"modified_on" => date("Y-m-d H:i:s")
						);
						$this->db->where("f_alloc_id", $allocation->f_alloc_id)->update("sf_student_facility_allocation", $update_array);
						$messages[] = "$meal_name canteen allocation updated successfully.";
					/* } else {
						
						// Canteen ID hasn't changed, no need to update
						$messages[] = "$meal_name canteen already allocated and unchanged.";
					} */
				} else {
					// No existing allocation, so insert new allocation if canteen_id != 0
					if ($canteen_id != 0) {
						$insert_array = array(
							"student_id" => $student_id,
							"enrollment_no" => $enrollment_no,
							"academic_year" => $academic_year,
							"allocated_id" => $canteen_id,
							"device_id" => $canteen['device_id'],
							"device_location" => $canteen['device_location'],
							"sffm_id" => $sffm_id,
							"cs_id" => $cs_id,
							"created_by" => $this->session->userdata("uid"),
							"created_on" => date("Y-m-d H:i:s"),
							"is_active" => "Y"
						);
						$this->db->insert("sf_student_facility_allocation", $insert_array);
						$messages[] = "$meal_name canteen allocated successfully.";
					} else {
						$messages[] = "$meal_name skipped (no canteen selected).";
					}
				}
			}
	
			// Set flash messages with the results of the allocation attempts
			if (!empty($messages)) {
				$this->session->set_flashdata('message1', implode(" , ", $messages));
			} else {
				$this->session->set_flashdata('message2', 'No canteen allocations were made.');
			}
	
			// Redirect back to the allocation page
			redirect(base_url($this->view_dir.'allocate_canteen_edit/'.$enrollment_no.'/'.$student_id.'/'.$campus.'/'.$academic_year));
		}
	}
	
	
	public function allocate_students_to_canteen(){
		$canteen_id_breakfast = $this->input->post("canteen_name_breakfast") ?: 0;
		$canteen_id_lunch = $this->input->post("canteen_name_lunch") ?: 0;
		$canteen_id_dinner = $this->input->post("canteen_name_dinner") ?: 0;
		
		$student_details = $this->input->post('chk_stud');
		$sffm_id = 3;
	
		// Check if at least one canteen is selected and student details are provided
		if (($canteen_id_breakfast != 0 || $canteen_id_lunch != 0 || $canteen_id_dinner != 0) && !empty($student_details)) {
			foreach ($student_details as $student_detail) {
				list($enrollment_no, $academic_year, $student_id) = explode('|', $student_detail);
				
				// Array for canteen allocations (1 = Breakfast, 2 = Lunch, 3 = Dinner)
				$canteens = [
					1 => $canteen_id_breakfast,
					2 => $canteen_id_lunch,
					3 => $canteen_id_dinner
				];
	
				// Loop through canteens and insert allocation if not already allocated
				foreach ($canteens as $cs_id => $canteen_id) {
					$check = $this->db->where("enrollment_no", $enrollment_no)
									  ->where("academic_year", $academic_year)
									  ->where("sffm_id", $sffm_id)
									  ->where("cs_id", $cs_id)
									  ->get("sf_student_facility_allocation")
									  ->num_rows();
	
					if ($check == 0 && $canteen_id != 0) {
						$insert_array = array(
							"student_id" => $student_id,
							"enrollment_no" => $enrollment_no,
							"academic_year" => $academic_year,
							"allocated_id" => $canteen_id,
							"sffm_id" => $sffm_id,
							"cs_id" => $cs_id,
							"created_by" => $this->session->userdata("uid"),
							"created_on" => date("Y-m-d H:i:s"),
							"is_active" => "Y"
						);
						$this->db->insert("sf_student_facility_allocation", $insert_array);
					} else {
						$meal_type = ($cs_id == 1) ? 'Breakfast' : (($cs_id == 2) ? 'Lunch' : 'Dinner');
						$this->session->set_flashdata('message2', $meal_type . ' Canteen is already allocated.');
					}
				}
			}
	
			$last_inserted_id = $this->db->insert_id(); 
			if($last_inserted_id) {
				$this->session->set_flashdata('message1', 'Canteen allocated Successfully.');
				redirect(base_url($this->view_dir.'student_list'));
			} else {
				$this->session->set_flashdata('message2', 'Canteen allocation failed.');
				redirect(base_url($this->view_dir.'student_list'));
			}
		} else {
			$this->session->set_flashdata('message2', 'Please select a canteen and at least one student.');
			redirect(base_url($this->view_dir.'student_list'));
		}
	}
	public function list_facility_cancel() {
		// Check if there is a POST request with filters
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$academic_year = $this->input->post('academic_year');
	
		// Pass filter values to the model function
		$this->data['cancel_details'] = $this->hostel_model->get_cancel_details($from_date, $to_date, $academic_year);
	
		// Load the academic year options for dropdown
		$this->data['academic_years'] = $this->hostel_model->get_academic_years();
	
		// Load views
		$this->load->view('header', $this->data);
		$this->load->view($this->view_dir . 'facility_cancel_list', $this->data);
		$this->load->view('footer');
	}

		public function save_owner()
		{
			$data = [
				'hostel_id'     => $this->input->post('hostel_id'),
				'owner_name'    => $this->input->post('owner_name'),
				'academic_year' => $this->input->post('academic_year'),
				'from_date'     => $this->input->post('from_date'),
				'to_date'       => $this->input->post('to_date'),
				'rent_amount'   => $this->input->post('rent_amount'),
				'created_by'    => $this->session->userdata('user_id'),
				'created_on'    => date('Y-m-d H:i:s'),
				'status'        => 'Y'
			];

			$this->db->insert('sf_hostel_owners', $data);

			$this->session->set_flashdata('message', 'Owner added successfully.');
			redirect('hostel'); // or wherever your list page is
		}
		
	/// Hostel clearance
	public function student_clearance_view($enrollment_no = null)
	{
	
			$this->load->view('header', $this->data);

			$postEnrollmentNo = $this->input->post('enrollment_no');
			$enrollment_no = !empty($postEnrollmentNo) ? $postEnrollmentNo : $enrollment_no;
			$this->data['student_facilities'] = $this->hostel_model->getStudentFacilities($enrollment_no);

			if (!empty($this->data['student_facilities'])) {
				$val = (array) $this->data['student_facilities'][0];
				$this->data['student_list'] = $this->hostel_model->student_hostel_details($val);
			} else {
				$this->data['student_list'] = [];
			}

			$stdata = $this->load->view($this->view_dir.'student_hostel_clearance_view',$this->data);
		
        $this->load->view('footer');
    }

	public function submit_hostel_clearance()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('date_of_leaving', 'Date of Leaving', 'required');
		$this->form_validation->set_rules('damage_identified', 'Damage Identified', 'required');
		$this->form_validation->set_rules('rector_remark', 'Hostel Rector Remark', 'required');
		$this->form_validation->set_rules('school_name', 'College/School', 'required');
		$this->form_validation->set_rules('hostel_name', 'Hostel No', 'required');
		$this->form_validation->set_rules('deposit_fees', 'Deposit Amount', 'required|numeric');
		$this->form_validation->set_rules('course_name', 'Course Name', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message2', validation_errors());
			redirect($this->currentModule);
		}

		$student_id = $this->input->post('student_id');
		$enrollment_no = $this->input->post('enrollment_no');

		$this->db->where('student_id', $student_id);
		$this->db->where('enrollment_no', $enrollment_no);
		$existing = $this->db->get('sf_hostel_clearance')->row();

		if ($existing) {
			$this->session->set_flashdata('message2', 'Clearance has already been submitted for this student.');
			redirect($this->currentModule.'/clearance_list');
		}

		$data = [
			'student_id'             => $student_id,
			'enrollment_no'          => $enrollment_no,
			'academic_year'          => ADMISSION_SESSION,
			'hostel_no'              => $this->input->post('hostel_name'),
			'year'                   => $this->input->post('year'),
			'room_no'                => $this->input->post('room_no'),
			'student_name'            => $this->input->post('student_name'),
			'course_name'            => $this->input->post('course_name'),
			'school_name'            => $this->input->post('school_name'),
			'stream_name'            => $this->input->post('stream_name'),
			'date_of_joining'         => date('Y-m-d', strtotime($this->input->post('created_on'))),
			'date_of_leaving'         => date('Y-m-d', strtotime($this->input->post('date_of_leaving'))),
			'damage_identified'      => $this->input->post('damage_identified'),
			'hostel_rector_remark'   => $this->input->post('rector_remark'),
			'security_deposit_amount'=> $this->input->post('deposit_fees'),
			'clearance_status'       => 'Pending',
			'cleared_on'             => date('Y-m-d H:i:s'),
		];

		$insert = $this->db->insert('sf_hostel_clearance', $data);

		if ($insert) {
			$this->session->set_flashdata('message1', 'Hostel clearance form submitted successfully.');
		} else {
			$this->session->set_flashdata('message2', 'Failed to submit the form. Please try again.');
		}

		redirect($this->currentModule.'/clearance_list');
	}


	public function clearance_list()
	{
		$this->load->view('header', $this->data);

		$academic_year = $this->input->get('academic_year');
		$this->data['selected_academic_year'] = $academic_year;
		$this->data['clearance_list'] = $this->hostel_model->get_all_clearances($academic_year);

		$this->load->view($this->view_dir . 'hostel_students_clearence_list', $this->data);
		$this->load->view('footer');
	}



}
	
?>
