<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="academic_fees";
    var $model_name="Master_model";
    var $model;
    var $view_dir='Master/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
		//error_reporting(E_ALL);ini_set('display_errors', 1);
        $this->load->helper("url");		
        $this->load->library('form_validation');
		
		$this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
		
		$this->load->model($this->model_name);
		 $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==2 || $this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==53){
		}else{
			redirect('home');
		}
	}
	
	public function index()
    {
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6){
		}else{
			redirect('home');
		}
        $this->load->view('header',$this->data);  
	    $this->data['academic_details']= $this->Master_model->get_academic_details_new();

        //print_r($this->data['academic_details']);exit;		
        $this->load->view($this->view_dir.'view_academic_fees',$this->data);
        $this->load->view('footer');
    }
	
	public function get_academic_fees_details()
	{
		$academic_fees_details=$this->Master_model->get_academic_fees_detailsnew($_POST);
		 $menu_name='Master';   
		 $my_privileges=$this->retrieve_privileges($menu_name);
		 //print_r($my_privileges);exit;
		//print_r($academic_fees_details); exit();
		$i=1;
		$ban='fa-ban';
		$check='fa-check';
		$gender='';
		
		foreach($academic_fees_details as $val){
			
		$otherfees=0;
		if($val['admission_year']>=2018)
		{
			$otherfees=$val['Gymkhana']+$val['registration']+$val['student_safety_insurance']+$val['library']+$val['eligibility']+$val['internet']+$val['educational_industrial_visit']+$val['seminar_training']+$val['student_activity'];//+$val['exam_fees']
		}
		if($val['admission_year']<2018)
		{
			$otherfees=$val['Gymkhana']+$val['disaster_management']+$val['computerization']+$val['registration']+$val['student_safety_insurance']+$val['library']+$val['nss'];//+$val['exam_fees']
		}
			
			if($val["gender"]=="M")
				$gender='Male';
			else
				$gender='Female';

			if($val["year"]>0)
				$yr=$val["year"];
			else
				$yr='-';
			
			if($val["fees_type"]=="")
			{$fees_type='-';
			}else{$fees_type=$val["fees_type"];
			}
			
           	 echo '<tr>
					 <td>'.$i.'</td>
					 <td>'.$val["cname"].'</td>
					  <td>'.$val["stream"].'</td>
					  <td>'.$val["academic_year"].'</td>
					 <td>'.$val["admission_year"].'</td>
					 <td>'.$yr.'</td>
					<td>'.$val["tution_fees"].'</td>
					<td>'.$val["development"].'</td>
					<td>'.$val["academic_fees"].'</td>
					<td>'.$val["caution_money"].'</td>
					<td>'.$val["admission_form"].'</td>
					<td>'.$otherfees.'</td>
					<td>'.$val["exam_fees"].'</td>
					<td>'.$val["total_fees"].'</td>
					<td>'.$fees_type.'</td>
					<td>';
					if(in_array("Edit", $my_privileges)) { 
					echo '<a href="'.base_url($currentModule.$this->view_dir.'edit_academic_fees/'.$val['academic_fees_id'].'/'.$val['academic_year']).'" title="edit the details"><i class="fa fa-edit"></i></a>';
					}
					echo '<a title="View complete Fee Details" class="btn btn-primary btn-xs" onclick="fullview_feedetails('.$val['academic_fees_id'].')"><i class="fa fa-eye"></i></a>
					
					 <!--<a href="'.base_url($currentModule.$this->view_dir.($val["is_active"]=="Y"?'disable_academic_fees/'.$val["academic_fees_id"]:'enable_academic_fees/'.$val["academic_fees_id"])).'"><i '.($val["is_active"]=="Y"?'class="fa '.$ban:'class="fa '.$check).'" title="'.($val["is_active"]=="Y"?'Disable':'Enable').'"></i></a>-->
				   </td>
				   </tr>';
				  
			$i++;
        }
	}
	
	public function fullview_feedetails()
	{
		$p_dts=array_shift($this->Master_model->get_academic_fees_details($_POST));
		echo json_encode(array("fees_details"=>$p_dts));
	}
	
	public function get_school_stream_details()
	{
		$school_stream_details=$this->Master_model->get_school_stream_details($_POST);
		$i=1;
		$ban='fa-ban';
		$check='fa-check';
		$gender='';
		
		foreach($school_stream_details as $val){
           	 echo '<tr>
					 <td>'.$i.'</td>
					 <td>'.$val["school_short_name"].'</td>
					 <td>'.$val["course_short_name"].'</td>
					 <td>'.$val["stream_short_name"].'</td>
					 <td>'.$val["course_pattern"].'</td>
					 <td>'.$val["course_duration"].'</td>
					<!--<td>
					
					<a href="'.base_url($currentModule.$this->view_dir.'edit_school_stream/'.$val['school_code']).'" title="edit the details"><i class="fa fa-edit"></i></a>
					
				   </td>-->
				   </tr>';
				  
			$i++;
        }
	}
	
	public function add_academic_fees()
	{
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);     
		$this->data['academic_details']= $this->Master_model->get_academic_details_new();	
		$this->data['countryies_details']= $this->Master_model->get_countryies_details();	
        $this->load->view($this->view_dir.'add_academic_fees',$this->data);
        $this->load->view('footer');
	}
	
	public function get_academic_stream_list()
	{
		$academic_fees_details=$this->Master_model->get_academic_stream_list($_POST);
		/* echo "<table id='myTable' class='table' >";
        echo "<th></th><th>Stream Name</th><th>Year</th>"; */
        foreach($academic_fees_details as $val){
            echo "<tr >";
            echo "<td><input name=\"stream_list[]\" onclick=\"count_ischecked()\" value='".$val['stream_id']."' class = \"chk\" type='checkbox' ></td>";
            echo "<td>".$val['stream_name']." <small>(".$val['stream_short_name'].")</small></td>";
           // echo "<td>".$_POST['year']."</td>";
            echo "</tr>";
        }
        //echo "</table>";
		
		
		//'No streams available to enter academic fee details'
	}
	
	public function academic_fee_details_excelReports()
	{
		$val['academic']=$this->uri->segment(3);
		$this->data['academic_fees_details']=$this->Master_model->get_academic_fees_details($val);
		$this->load->view($this->view_dir.'academic_fee_details_excelReports',$this->data);
	}
	
public function check_academic_fees(){
	//echo 'Test dfgdgdgd';
echo $check=$this->Master_model->check_academic_fees();
}

	public function add_academic_fees_submit()
	{
		//var_dump($_POST);exit();
        //  $check=$this->Master_model->check_academic_fees($_POST);

		$last_inserted_id=$this->Master_model->add_academic_fees_submit($_POST);
		if($last_inserted_id){
			$this->session->set_flashdata('message1','Academic Fees Detail has added Successfully.');
		}else{
			$this->session->set_flashdata('message2','Academic Fees Detail has not added Successfully.');
		}
		redirect('Master');
	}
	
	public function add_school_stream_submit()
	{
		$last_inserted_id=$this->Master_model->add_school_stream_submit($_POST);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','School Stream Detail has inserted Successfully.');
		else
			$this->session->set_flashdata('message2','School Stream Detail has not inserted Successfully.');
		redirect('Master/school_stream');
	}
	
	public function edit_academic_fees()
	{
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);                
        $val['academic_fees_id']=$this->uri->segment(3);
		$val['academic']=$this->uri->segment(4);
        $this->data['academic_fee_details']=array_shift($this->Master_model->get_academic_fees_details($val));
		$this->data['academic_details']= $this->Master_model->get_academic_details();
		$this->data['countryies_details']= $this->Master_model->get_countryies_details();	
		//	echo $this->view_dir.'edit_room_details';exit();
        $this->load->view($this->view_dir.'edit_academic_fees',$this->data);
        $this->load->view('footer');
	}
	public function edit_school_stream()
	{
		$this->load->view('header',$this->data);                
        $val['id']=$this->uri->segment(3);
		$this->data['school_details']=$this->Master_model->get_school_details();
		$this->data['course_category_details']=$this->Master_model->get_course_category_details();
        $this->data['school_stream_details']=array_shift($this->Master_model->get_school_stream_details($val));
		//	echo $this->view_dir.'edit_room_details';exit();
        $this->load->view($this->view_dir.'edit_school_stream',$this->data);
        $this->load->view('footer');
	}
	
	public function edit_academic_fees_submit()
	{
		$academic_fees_id=$_POST['fees_id'];
		$academic=$_POST['academic'];
		$flag=$this->Master_model->edit_academic_fees_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Academic Fees Detail Has Updated Successfully.');
			redirect(base_url($this->view_dir.'edit_academic_fees/'.$academic_fees_id.'/'.$academic));
		}
		else
		{
			$this->session->set_flashdata('message2','Academic Fees Detail Has Not Updated Successfully.');
			redirect(base_url($this->view_dir.'edit_academic_fees/'.$academic_fees_id.'/'.$academic));
		}
	}
	
	public function disable_academic_fees()
	{
		$academic_fees_id=$this->uri->segment(3);
		$flag=$this->Master_model->disable_academic_fees($academic_fees_id);
		if($flag)
		{
			$this->session->set_flashdata('message1','Academic Fees Detail Has disabled Successfully.');
			redirect('Master');
		}
		else
		{
			$this->session->set_flashdata('message2','Academic Fees Detail Has Not disabled Successfully.');
			redirect('Master');
		}
	}
	
	public function enable_academic_fees()
	{
		$academic_fees_id=$this->uri->segment(3);
		$flag=$this->Master_model->enable_academic_fees($academic_fees_id);
		if($flag)
		{
			$this->session->set_flashdata('message1','Academic Fees Detail Has enabled Successfully.');
			redirect('Master');
		}
		else
		{
			$this->session->set_flashdata('message2','Academic Fees Detail Has Not enabled Successfully.');
			redirect('Master');
		}
	}
	
	public function edit_check_academicfee_exists()
	{
		echo $status=$this->Master_model->edit_check_academicfee_exists($_POST);
	}
	
	public function academic_session()
	{
		$this->load->view('header',$this->data);   
		$this->data['academic_session_details']=$this->Master_model->get_academic_session_details();
		$this->load->view($this->view_dir.'view_academic_session',$this->data);
        $this->load->view('footer');
	}
	
	public function academic_year()
	{
		$this->load->view('header',$this->data);   
		$this->data['academic_year_details']=$this->Master_model->get_academic_year_details();
		$this->load->view($this->view_dir.'view_academic_year',$this->data);
        $this->load->view('footer');
	}
	
	public function course_master()
	{
		$this->load->view('header',$this->data);   
		$this->data['course_details']=$this->Master_model->get_course_details();
		$this->load->view($this->view_dir.'view_course',$this->data);
        $this->load->view('footer');
	}
	
	public function angular()
	{
		//$this->load->view('header',$this->data);   
		//$this->data['course_details']=$this->Master_model->get_course_details();
		$this->load->view($this->view_dir.'test_angular');
        //$this->load->view('footer');
	}
	
	public function school_master()
	{
		$this->load->view('header',$this->data);   
		$this->data['school_details']=$this->Master_model->get_school_details();
		$this->load->view($this->view_dir.'view_school_master',$this->data);
        $this->load->view('footer');
	}
	
	public function course_category_master()
	{
		$this->load->view('header',$this->data);   
		$this->data['course_category_details']=$this->Master_model->get_course_category_details();
		$this->load->view($this->view_dir.'view_course_category',$this->data);
        $this->load->view('footer');
	}
	
	public function stream_master()
	{
		if($this->session->userdata("role_id")==2 || $this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==53){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);   
		$this->data['stream_details']=$this->Master_model->get_stream_details();
		$this->data['partnership_details']=$this->Master_model->get_partnership_details();
		$this->load->view($this->view_dir.'view_stream_master',$this->data);
        $this->load->view('footer');
	}
	
	
	public function stream_master_list()
	{
		$this->load->view('header',$this->data);   
		$this->data['stream_details']=$this->Master_model->get_stream_details_list();
		$this->data['partnership_details']=$this->Master_model->get_partnership_details();
		$this->load->view($this->view_dir.'view_stream_master',$this->data);
        $this->load->view('footer');
	}
	 
	public function stream_mapping()
	{
		$this->load->view('header',$this->data);
		$this->data['school_details']=$this->Master_model->get_school_details();
//$this->data['stream_map_details']=$this->Master_model->get_stream_mapping_details();
		$this->load->view($this->view_dir.'view_stream_mapping',$this->data);
        $this->load->view('footer');
	}
	
	public function school_stream()
	{
		$this->load->view('header',$this->data);   
		$this->data['school_stream_details']=$this->Master_model->get_school_stream_details();
		$this->data['school_details']=$this->Master_model->get_school_details();
		$this->load->view($this->view_dir.'school_stream',$this->data);
        $this->load->view('footer');
	}
	
	public function get_partnership_details()
	{
		$id=$_POST['pid'];//echo "id===".$id;
		$p_dts=array_shift($this->Master_model->get_partnership_details($id));
		echo json_encode(array("partnership_details"=>$p_dts));
	}
	
	public function get_school_details()
	{
		$id=$_POST['id'];//echo "id===".$id;
		$p_dts=array_shift($this->Master_model->get_school_details($id));
		echo json_encode(array("school_details"=>$p_dts));
	}
	
	public function get_partnership_streams()
	{
		$id=$_POST['pid'];//echo "id===".$id;
		$p_dts=$this->Master_model->get_partnership_streams($id);
		echo json_encode(array("partnership_streams"=>$p_dts));
	}
	
	public function partnership()
	{
		$this->load->view('header',$this->data);   
		$this->data['partnership_details']=$this->Master_model->get_partnership_details();
		$this->load->view($this->view_dir.'view_partnership',$this->data);
        $this->load->view('footer');
	}
	
	public function add_partnership()
	{
		$this->load->view('header',$this->data);   
		$this->data['state']= $this->Master_model->getAllState();
		$this->load->view($this->view_dir.'add_partnership',$this->data);
        $this->load->view('footer');
	}
	
	public function add_academic_session()
	{
		$this->load->view('header',$this->data);   
		$this->load->view($this->view_dir.'add_academic_session',$this->data);
        $this->load->view('footer');
	}
	
	public function add_academic_year()
	{
		$this->load->view('header',$this->data);   
		$this->load->view($this->view_dir.'add_academic_year',$this->data);
        $this->load->view('footer');
	}
	
	public function add_course()
	{
		$this->load->view('header',$this->data);   
		$this->load->view($this->view_dir.'add_course',$this->data);
        $this->load->view('footer');
	}
	
	public function add_course_category()
	{
		$this->load->view('header',$this->data);   
		$this->load->view($this->view_dir.'add_course_category',$this->data);
        $this->load->view('footer');
	}
	
	public function add_school()
	{
		$this->load->view('header',$this->data);   
		$this->load->view($this->view_dir.'add_school',$this->data);
        $this->load->view('footer');
	}
	
	public function add_stream()
	{
		$this->load->view('header',$this->data);
		$this->data['course_details']=$this->Master_model->get_course_details();
		$this->data['course_category_details']=$this->Master_model->get_course_category_details();
		$this->data['partnership_details']=$this->Master_model->get_partnership_details();
		$this->data['school_details']=$this->Master_model->get_school_details();
		
		$this->load->view($this->view_dir.'add_stream',$this->data);
        $this->load->view('footer');
	}
	
	public function add_test_stream()
	{
		$this->load->view('header',$this->data);
		$this->data['course_details']=$this->Master_model->get_course_details();
		$this->data['course_category_details']=$this->Master_model->get_course_category_details();
		$this->data['partnership_details']=$this->Master_model->get_partnership_details();
		$this->data['school_details']=$this->Master_model->get_school_details();
		
		$this->load->view($this->view_dir.'add_test_stream',$this->data);
        $this->load->view('footer');
	}
	
	public function add_school_stream()
	{
		$this->load->view('header',$this->data);
		$this->data['school_details']=$this->Master_model->get_school_details();
		$this->data['course_category_details']=$this->Master_model->get_course_category_details();
		$this->load->view($this->view_dir.'add_school_stream',$this->data);
        $this->load->view('footer');
	}
	
	public function get_stream_list_notin_school()
	{
		$get_stream_list_notin_school=$this->Master_model->get_stream_list_notin_school($_POST);
		/* echo "<table id='myTable' class='table' >";
        echo "<th></th><th>Stream Name</th><th>Year</th>"; */
        foreach($get_stream_list_notin_school as $val){
            echo "<tr >";
            echo "<td><input name=\"stream_list[]\" onclick=\"count_ischecked()\" value='".$val['stream_id']."' class = \"chk\" type='checkbox' ></td>";
            echo "<td>".$val['stream_short_name']."</td>";
            //echo "<td>".$_POST['year']."</td>";
            echo "</tr>";
        }
	}
	
	public function add_partnership_submit()
    {
		//echo 'filename=='.$_FILES['mou_doc']['name'];exit();
		if(!empty($_FILES['mou_doc']['name'])){
			$filenm=$_POST['pcode'].'-'.$_FILES['mou_doc']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "5048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('mou_doc')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
				//echo 'yfuyfguy==='.$payfile;exit();
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
		
		//echo "calling";exit();
        $last_inserted_id= $this->Master_model->add_partnership_submit($_POST,$payfile );
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Partnership Details Added Successfully.');
			redirect(base_url($this->view_dir."partnership"));
		}
		else
		{
			$this->session->set_flashdata('message2','Partnership Details Not Added Successfully.');
			redirect(base_url($this->view_dir."partnership"));
		}
        //redirect('Hostel/view_std_payment/'.$stud_id);
    }

	public function edit_partnership_submit()
	{
		//echo 'filename=='.$_FILES['mou_doc']['name'];exit();
		if(!empty($_FILES['mou_doc']['name'])){
			$filenm=$_POST['pcode'].'-'.$_FILES['mou_doc']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('mou_doc')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
				//echo 'yfuyfguy==='.$payfile;exit();
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
		
		$flag=$this->Master_model->edit_partnership_submit($_POST,$payfile);
		if($flag)
		{
			$this->session->set_flashdata('message1','partnership details updated Successfully.');
			redirect(base_url($this->view_dir.'partnership'));
		}
		else
		{
			$this->session->set_flashdata('message2','partnership details not updated Successfully.');
			redirect(base_url($this->view_dir.'partnership'));
		}
	}
	
	public function get_stream_no()
	{
		$dts=$this->Master_model->get_last_stream_no($_POST);
		echo sprintf("%02d", $dts+1);
		//echo $dts+1;
	}
	
	public function check_academic_session_exists()
	{
		echo $dts=$this->Master_model->check_academic_session_exists($_POST);
	}
	
	public function check_academic_year_exists()
	{
		echo $dts=$this->Master_model->check_academic_year_exists($_POST);
	}
	
	public function check_course_exists()
	{
		echo $dts=$this->Master_model->check_course_exists($_POST);
	}
	
	public function check_course_cat_exists()
	{
		echo $dts=$this->Master_model->check_course_cat_exists($_POST);
	}
	
	public function check_school_exists()
	{
		echo $dts=$this->Master_model->check_school_exists($_POST);
	}
	
	public function check_stream_exists()
	{
		echo $dts=$this->Master_model->check_stream_exists($_POST);
	}
	
	public function check_partnership_exists()
	{
		echo $dts=$this->Master_model->check_partnership_exists($_POST);
	}
	
	public function add_academic_session_submit()
	{
		$flag=$this->Master_model->add_academic_session_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Academic session added Successfully.');
			redirect(base_url($this->view_dir.'academic_session'));
		}
		else
		{
			$this->session->set_flashdata('message2','Academic session not added Successfully.');
			redirect(base_url($this->view_dir.'academic_session'));
		}
	}
	
	public function edit_academic_session_submit()
	{
		$flag=$this->Master_model->edit_academic_session_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Academic session updated Successfully.');
			redirect(base_url($this->view_dir.'academic_session'));
		}
		else
		{
			$this->session->set_flashdata('message2','Academic session not updated Successfully.');
			redirect(base_url($this->view_dir.'academic_session'));
		}
	}
	
	public function add_academic_year_submit()
	{
		$flag=$this->Master_model->add_academic_year_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Academic year added Successfully.');
			redirect(base_url($this->view_dir.'academic_year'));
		}
		else
		{
			$this->session->set_flashdata('message2','Academic year not added Successfully.');
			redirect(base_url($this->view_dir.'academic_year'));
		}
	}
	
	public function edit_academic_year_submit()
	{
		$flag=$this->Master_model->edit_academic_year_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Academic year updated Successfully.');
			redirect(base_url($this->view_dir.'academic_year'));
		}
		else
		{
			$this->session->set_flashdata('message2','Academic year not updated Successfully.');
			redirect(base_url($this->view_dir.'academic_year'));
		}
	}
	
	public function add_course_submit()
	{
		$flag=$this->Master_model->add_course_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Course added Successfully.');
			redirect(base_url($this->view_dir.'course_master'));
		}
		else
		{
			$this->session->set_flashdata('message2','Course not added Successfully.');
			redirect(base_url($this->view_dir.'course_master'));
		}
	}
	
	public function edit_course_submit()
	{
		$flag=$this->Master_model->edit_course_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Course updated Successfully.');
			redirect(base_url($this->view_dir.'course_master'));
		}
		else
		{
			$this->session->set_flashdata('message2','Course not updated Successfully.');
			redirect(base_url($this->view_dir.'course_master'));
		}
	}
	
	public function add_course_category_submit()
	{
		$flag=$this->Master_model->add_course_category_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Course Category added Successfully.');
			redirect(base_url($this->view_dir.'course_category_master'));
		}
		else
		{
			$this->session->set_flashdata('message2','Course Category not added Successfully.');
			redirect(base_url($this->view_dir.'course_category_master'));
		}
	}
	
	public function edit_course_category_submit()
	{
		$flag=$this->Master_model->edit_course_category_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Course Category updated Successfully.');
			redirect(base_url($this->view_dir.'course_category_master'));
		}
		else
		{
			$this->session->set_flashdata('message2','Course Category not updated Successfully.');
			redirect(base_url($this->view_dir.'course_category_master'));
		}
	}
	
	public function add_school_submit()
	{
		$flag=$this->Master_model->add_school_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','School Details added Successfully.');
			redirect(base_url($this->view_dir.'school_master'));
		}
		else
		{
			$this->session->set_flashdata('message2','School Details not added Successfully.');
			redirect(base_url($this->view_dir.'school_master'));
		}
	}
	
	public function edit_school_submit()
	{
		$flag=$this->Master_model->edit_school_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','School Details updated Successfully.');
			redirect(base_url($this->view_dir.'school_master'));
		}
		else
		{
			$this->session->set_flashdata('message2','School Details not updated Successfully.');
			redirect(base_url($this->view_dir.'school_master'));
		}
	}
	
	public function add_stream_submit()
	{
		$flag=$this->Master_model->add_stream_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Stream Details added Successfully.');
			redirect(base_url($this->view_dir.'stream_master'));
		}
		else
		{
			$this->session->set_flashdata('message2','Stream Details not added Successfully.');
			redirect(base_url($this->view_dir.'stream_master'));
		}
	}
	
	public function edit_academic_session()
	{
		$id=$this->uri->segment(3);
        $this->load->view('header',$this->data);
        $this->data['academic_details']= array_shift($this->Master_model->get_academic_session_details($id));
		$this->load->view($this->view_dir.'edit_academic_session',$this->data);
        $this->load->view('footer');
	}
	
	public function edit_academic_year()
	{
		$id=$this->uri->segment(3);
        $this->load->view('header',$this->data);                   
        $this->data['academic_details']= array_shift($this->Master_model->get_academic_year_details($id));
		$this->load->view($this->view_dir.'edit_academic_year',$this->data);
        $this->load->view('footer');
	}
	
	public function edit_course()
	{
		$id=$this->uri->segment(3);
        $this->load->view('header',$this->data);                   
        $this->data['course_details']= array_shift($this->Master_model->get_course_details($id));
		$this->load->view($this->view_dir.'edit_course',$this->data);
        $this->load->view('footer');
	}
	
	public function edit_course_category()
	{
		$id=$this->uri->segment(3);
        $this->load->view('header',$this->data);                   
        $this->data['course_details']= array_shift($this->Master_model->get_course_category_details($id));
		$this->load->view($this->view_dir.'edit_course_category',$this->data);
        $this->load->view('footer');
	}
	
	public function edit_school()
	{
		$id=$this->uri->segment(3);
        $this->load->view('header',$this->data);                   
        $this->data['school_details']= array_shift($this->Master_model->get_school_details($id));
		$this->load->view($this->view_dir.'edit_school',$this->data);
        $this->load->view('footer');
	}
	
	public function edit_partnership()
	{
		$id=$this->uri->segment(3);
        $this->load->view('header',$this->data);                
		$this->data['state']= $this->Master_model->getAllState();
        $this->data['partnership_details']= array_shift($this->Master_model->get_partnership_details($id));
		$this->load->view($this->view_dir.'edit_partnership',$this->data);
        $this->load->view('footer');
	}
	
	public function edit_stream()
	{ //error_reporting(E_ALL);
		$id=$this->uri->segment(3);
		if($this->session->userdata("role_id")==2 || $this->session->userdata("role_id")==15){
		}else{
			redirect('home');
		}
                $this->load->view('header',$this->data);
		$this->data['course_details']=$this->Master_model->get_course_details();
		$this->data['course_category_details']=$this->Master_model->get_course_category_details();
		$this->data['last_stream_no']=array_shift($this->Master_model->get_last_stream_no($data=array()));
        $this->data['stream_details']= array_shift($this->Master_model->get_stream_details($id));
		$this->data['partnership_details']=$this->Master_model->get_partnership_details();
		$this->data['school_details']=$this->Master_model->get_school_details();
		$this->data['school_id_code']=$this->Master_model->get_school_id($id);
		$arr = $this->Master_model->get_stream_details($id);
		//print_r($arr);exit();
		$this->data['school_stream_details']=array_shift($this->Master_model->get_school_stream_details($arr[0]['stream_id']));
		$this->load->view($this->view_dir.'edit_stream',$this->data);
        $this->load->view('footer');
	}
	
	public function edit_stream_submit()
	{
		$flag=$this->Master_model->edit_stream_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Stream Details updated Successfully.');
			redirect(base_url($this->view_dir.'stream_master'));
		}
		else
		{
			$this->session->set_flashdata('message2','Stream Details not updated Successfully.');
			redirect(base_url($this->view_dir.'stream_master'));
		}
	}
	
	public function update_payment_status()
	{
		$this->load->view('header',$this->data);
		
		$this->load->view($this->view_dir.'update_payment_status',$this->data);
        $this->load->view('footer');
	}


	public function update_payment_status_data()
	{
		/*$flag=$this->Master_model->add_stream_submit($_POST);
		if($flag)
		{
			$this->session->set_flashdata('message1','Stream Details added Successfully.');
			//redirect(base_url($this->view_dir.'stream_master'));
		}
		else
		{
			$this->session->set_flashdata('message2','Stream Details not added Successfully.');
			//redirect(base_url($this->view_dir.'stream_master'));
		}*/

      //print_r($_POST);exit;
      if($_POST['payment_type'] == 'R'){
      	$DB1 = $this->load->database('umsdb', TRUE);	
        $data['payment_status']='success';
        $data['bank_ref_num']=$_POST['ref_no'];
		
		/*$stream_details['modified_on']= date('Y-m-d h:i:s');
		$stream_details['modified_by']= $_SESSION['uid'];*/
		$DB1->where('txtid', $_POST['txtid']);
		//$DB1->where('bank_ref_num', $_POST['ref_no']);
		$DB1->update('online_payment', $data);
		$sm=$DB1->affected_rows();

		if($sm > 0 ){

			//echo $sm;exit;
			 $this->session->set_flashdata('message1','Payment Details Updated Successfully.');

		$DB1 = $this->load->database('umsdb', TRUE);
		$data1['modified_by']=$_SESSION['uid'];;
		$data1['modified_on']=date('Y-m-d h:i:s');
		$data1['txtid']=$_POST['txtid'];
		$data1['bank_ref_num']=$_POST['ref_no'];	
		$DB1->insert("payment_status_log", $data1);
		//echo $DB1->last_query();exit();
		$last_inserted_id=$DB1->insert_id(); 
		}

      }


      if($_POST['payment_type'] == 'H'){
      	$DB1 = $this->db;
        $data['payment_status']='success';
		$data['bank_ref_num']=$_POST['ref_no'];
		if(!empty($_POST['recepit_no'])){
        $data['receipt_no']=$_POST['recepit_no'];
         }
		
		/*$stream_details['modified_on']= date('Y-m-d h:i:s');
		$stream_details['modified_by']= $_SESSION['uid'];*/
		$DB1->where('txtid', $_POST['txtid']);
		//$DB1->where('bank_ref_num', $_POST['ref_no']);
		$DB1->update('online_payment_facilities', $data);
		$sm=$DB1->affected_rows();
		$this->session->set_flashdata('message1','Payment Details Updated Successfully.');

		///$DB1 = $this->load->database('umsdb', TRUE);
		$data1['modified_by']=$_SESSION['uid'];;
		$data1['modified_on']=date('Y-m-d h:i:s');
		$data1['txtid']=$_POST['txtid'];
		$data1['bank_ref_num']=$_POST['ref_no'];
        if(!empty($_POST['recepit_no'])){
        $data['receipt_no']=$_POST['recepit_no'];
         }		
		$DB1->insert("payment_status_log", $data1);
		//echo $DB1->last_query();exit();
		$last_inserted_id=$DB1->insert_id(); 

      }
     
      redirect('master/update_payment_status'); 
		
	}
}

?>