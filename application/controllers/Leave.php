<?php


defined('BASEPATH') OR exit('No direct script access allowed');
//ini_set('error_reporting', E_ALL);
class Leave extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="leave_master";
    var $model_name="leave_model";
    var $model;
    var $view_dir='Leave/';
    var $data=array();
    var $officer_id = '110096';
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
        $this->load->model('Admin_model');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
        $this->load->library('awssdk');
    }
    
    public function index()
    {
        $this->load->view('header',$this->data);    
        $this->data['leave_details']= $this->leave_model->get_leave_details();                                        
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
        $this->data['leave_details']=$this->leave_model->get_leave_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);                
        $leave_id=$this->uri->segment(3);
        $this->data['leave_details']=array_shift($this->leave_model->get_leave_details($leave_id));                            
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);                
        $leave_id=$this->uri->segment(3);   
        $update_array=array("lstatus"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("leave_id"=>$leave_id);
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
        $leave_id=$this->uri->segment(3);   
        $update_array=array("lstatus"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("leave_id"=>$leave_id);
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
     //  echo "<pre>"; print_r($post_array); die;
        $config= array(
        array('field'   => 'leave_name',
            'label'   => 'leave name',
            'rules'   => 'trim|required|xss_clean'
             )
             );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $leave_id=$this->input->post('leave_id');
        if($leave_id=="")
        { 
                if ($this->form_validation->run() == FALSE)
            { 
                $this->load->view('header',$this->data);        
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
                echo "in query";
                $leave_name=$this->input->post("leave_name");   
                
                $insert_array=array("ltype"=>$leave_name,"inserted_by"=>$this->session->userdata("uid"),"inserted_date"=>date("Y-m-d H:i:s"));      print_r($insert_array);                                                          
                $this->db->insert("leave_master", $insert_array); 
                
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
        }else
        {
            echo "in query";
            if ($this->form_validation->run() == FALSE)
            {
                 echo "in validation for update"; 
                $this->load->view('header',$this->data);                
                $leave_id=$this->input->post("leave_id");
                echo $leave_id;
                $this->data['leave_details']=array_shift($this->leave_model->get_leave_details($leave_id));  
                
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {        
                $leave_name=$this->input->post("leave_name");  
                $leave_id=$this->input->post("leave_id");
                $update_array=array("ltype"=>$leave_name,"updated_by"=>$this->session->userdata("uid"),"updated_date"=>date("Y-m-d H:i:s")); 
                $where=array("leave_id"=>$leave_id);
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
        $leave_details=  $this->leave_model->get_leave_details($para);                    
        echo json_encode(array("leave_details"=>$leave_details));
    } 
     public function add_employee_leave_allocation(){
         $this->load->view('header',$this->data); 
    
        $this->load->view($this->view_dir.'employee_leave_allocation_add',$this->data);
        $this->load->view('footer');
    }
    public function add_employee_leaves(){
          $this->load->view('header',$this->data);     
        $this->load->view($this->view_dir.'employee_leave_add',$this->data);
        $this->load->view('footer');
    }
     public function add_employee_leave_submit(){
        
        $holid=$this->leave_model->add_employee_leave($_POST);
        if($holid=='err'){
         
           $this->session->set_userdata('err',"This leave is already assign to this employee.");
           redirect($this->view_dir.'add_employee_leaves');
        }else{
             $this->session->set_userdata('err','');
        redirect($this->view_dir.'employee_leave_allocation');  
        }
    }
    public function employee_leave_allocation($yer=''){
         $this->load->view('header',$this->data); 
         if($yer != ''){
$yer=$yer;
         }else{
$yer= $this->config->item('current_year2');
         }
          $this->data['yer']=$yer;
          $this->data['emp_leave_allocation'] =$this->leave_model->get_employee_leave_allocation($yer);      
        $this->load->view($this->view_dir.'employee_leave_allocation_list',$this->data);
        $this->load->view('footer');
    }   
    public function add_employee_leave_allocation_submit(){
        
        $holid=$this->leave_model->add_employee_leave_allocation($_POST);
        if($holid=='err'){
         
           $this->session->set_userdata('err',"This leave is already assign to this employee.");
           redirect($this->view_dir.'add_employee_leave_allocation');
        }else{
             $this->session->set_userdata('err',"");
        redirect($this->view_dir.'employee_leave_allocation');  
        }
    }
    public function get_emp_code($txt){
        $emp=$this->leave_model->get_employee_code($txt);
        //print_r($emp);
        echo "<div class='emp-list' id='etable'><input type='text' id='myInput' onkeyup='myFunction()' placeholder='Search ..' title='Type in a name'><table id='myTable' class='table' style=''>";
        echo "<th></th><th>Emp Code</th><th>Emp Name</th>";
        foreach($emp as $val){
                $nme = '"'.$val['fname'].' '.$val['lname'].'"';
            $sch = '"'.$val['college_name'].'"';
            $dep = '"'.$val['department_name'].'"';
            $des = '"'.$val['designation_name'].'"';
            echo "<tr >";
            echo "<td><input type='checkbox' onclick='insert_emp_id(".$val['emp_id'].",".$nme.",".$sch.",".$dep.",".$des.")'></td>";
            echo "<td>".$val['emp_id']."</td>";
            echo "<td>".$val['fname']." ".$val['lname']."</td>";
            echo "</tr>";
        }
        echo "</table></div>";
    }
    public function get_emp_code_leave(){
		 $txt = $_POST['post_data'];
		 $lt = $_POST['lt'];
		 $y= $_POST['y'];
        $emp=$this->leave_model->get_employee_code($txt);
//print_r($emp);
        echo "<script>$('#checkAllt').click(function(){
    $('.empidt').prop('checked', $(this).prop('checked'));
});</script><div  id='etable'><div class='emp-list'><input type='text' id='myInput' onkeyup='myFunction()' placeholder='Search ..' title='Type in a name'><table id='myTable' class='table'>";
        echo "<th><input type='checkbox' name='checkall' id='checkAllt' value='1' /></th><th>Emp Code</th><th>Emp Name</th><th>".$lt."</th>";
        foreach($emp as $val){
        	// $lv = $this->leave_model->get_emp_leaves($val['emp_id'],$lt,$y);
        	//if($lv[0]['leaves_allocated']!=''){          
        	
            echo "<tr >";
            echo "<td><input type='checkbox' name='emp_id[]' class='empidt' value='".$val['emp_id']."'></td>";
            echo "<td>".$val['emp_id']."</td>";
             echo "<td>";
			if($val['gender']=='male'){echo 'Mr.';}else if($val['gender']=='female'){ echo 'Mrs.';} 
			echo $val['fname']." ".$val['lname'];
			echo "</td>";
			echo "<td>";
			if($lv[0]['leaves_allocated']==''){echo '0';}else{ echo $lv[0]['leaves_allocated']; }
			echo "</td>";
            echo "</tr>";
        //}
        }
       echo '</table></div><br/><div class="text-center"><input type="button" class="btn btn-primary" onclick="insert_emp_id('."'".$lt."'".','."'".$y."'".')" name="sform" value="submit" />&nbsp;&nbsp;<button class="btn btn-primary" id="btn_cancel" type="button" onclick="window.location='."'".base_url($this->data['currentModule'])."/employee_leave_allocation'".'">Cancel</button></div></div>';
    }
	public function get_emp_code_leave_table(){
		 $empid = $_POST['eid'];
		$elt = $_POST['elt'];
		$ey = $_POST['ey'];
		echo "<div class='emp-list1' ><table id='myTable1' class='table table-bordered' >";
        echo "<thead><th>Emp Code</th><th>Emp Name</th><th>School</th><th>Department</th><th>Designation</th><th>".$elt."</th></thead>";
		$empid = explode('_',$empid);
		foreach($empid as $empd){
			if(!empty($empd)){
			 $emp=$this->leave_model->get_employee_code($empd);
			 foreach($emp as $val){
                $lv = $this->leave_model->get_emp_leaves($val['emp_id'],$elt,$ey);           
            echo "<tr >";
            echo "<td><input type='hidden' name='empid[]' value='".$val['emp_id']."' /> ".$val['emp_id']."</td>";
             echo "<td>";
			if($val['gender']=='male'){echo 'Mr.';}else if($val['gender']=='female'){ echo 'Mrs.';} 
			echo $val['fname']." ".$val['lname'];
			echo "</td>";
			echo "<td>".$val['college_code']."</td>";
			echo "<td>".$val['department_name']."</td>";
			echo "<td>".$val['designation_name']."</td>";
			echo "<td>";
			if($lv[0]['leaves_allocated']==''){echo '0';}else{ echo $lv[0]['leaves_allocated']; }
			echo "</td>";
            echo "</tr>";
			 }
        }
			 
		}
		echo "</table></div></div>";
	}
    public function update_employee_leave_allocation($eid,$yer){
         $this->load->view('header',$this->data);    
                 $this->data['emp_leave_allocation'] =$this->leave_model->get_employee_leave_allocation_byid($eid,$yer); 
        $this->load->view($this->view_dir.'employee_leave_allocation_update',$this->data);
        $this->load->view('footer');
    }
    public function update_employee_leave_allocation_submit(){
         $this->load->view('header',$this->data);     
        $holid=$this->leave_model->update_employee_leave_allocation($_POST);
		
        redirect($this->view_dir.'employee_leave_allocation');       
    }
        public function emp_leave_disable()
    {
        $this->load->view('header',$this->data);                
        $emp_id=$this->uri->segment(3);  
        $yer=$this->uri->segment(4);  
$modify_on=date("Y-m-d H:i:s");     
        $update_array=array("status"=>"N","modify_on"=>$modify_on,"modify_by"=>  $this->session->userdata('uid'));                                
        $where=array("employee_id"=>$emp_id,"academic_year"=>$yer);
        $this->db->where($where);
        
        if($this->db->update('employee_leave_allocation', $update_array))
        {
            redirect(base_url($this->view_dir."employee_leave_allocation?error=0"));
        }
        else
        {
            redirect(base_url($this->view_dir."employee_leave_allocation?error=1"));
        }  
        $this->load->view('footer');
    }
    
    public function emp_leave_enable()
    {
        $this->load->view('header',$this->data);                
        $emp_id=$this->uri->segment(3);   
        $modify_on=date("Y-m-d H:i:s");     
        $update_array=array("status"=>"Y","modify_on"=>$modify_on,"modify_by"=>  $this->session->userdata('uid'));                                
        $where=array("employee_id"=>$emp_id);
        $this->db->where($where);
        
        if($this->db->update('employee_leave_allocation', $update_array))
        {
            redirect(base_url($this->view_dir."employee_leave_allocation?error=0"));
        }
        else
        {
            redirect(base_url($this->view_dir."employee_leave_allocation?error=1"));
        }  
        $this->load->view('footer');
    }
    public function apply_leave(){
		
		      echo '
    <html>
    <head><title>Leave Application Disabled</title></head>
    <body style="font-family: Arial, sans-serif; font-size: 16px;">
        <p><strong>This link is closed!</strong></p>
        <p>
            I am pleased to inform you that the <strong>HRMS ERP</strong> is now live. Below are the login credentials for accessing the portal:
        </p>
        <p>
            <strong>Project Link:</strong>
            <a href="https://hrms.sandipuniversity.com/login" target="_blank">
                https://hrms.sandipuniversity.com/login
            </a>
        </p>
        <p><strong>Login Credentials:</strong><br>
        Username: EmployeeId (e.g., 2101001)<br>
        Password: 12345</p>
        <p><strong>Steps to Get Started:</strong><br>
        Login as User: Use the provided credentials to log in.<br>
        <span style="color:red;">Please change your password after first login using the current password: 12345.</span></p>
    </body>
    </html>';
    
    exit;
		
        $adhhoc_faculty =array(210407,210408,210414,210424,210468,210469,210471,210477,210425,210464,210483,210437,210421,210422,210413,210418,210419,210420,210472,210474,210454,210452,210443,210416,210415,210444,210441,210430,210429,210428,210442,210448,210446,210447,210462,210460,210457,210458,210459,210406,210461,210473,210475,210439,210438,210405,210432,210433,210431,210445,210435,210476);
		if(in_array($this->session->userdata("name"),$adhhoc_faculty)){
			redirect(base_url('home'));
		}
        $this->load->view('header',$this->data);
        $this->load->model('Admin_model');
         $this->data['state']= $this->Admin_model->getAllState();
         $this->data['school_list']= $this->Admin_model->getAllschool();
        
        $this->data['emp_detail']=$this->leave_model->fetchEmployeeData($this->session->userdata("name"));
        $this->data['leave']=$this->leave_model->getAllLeaveType();
        $this->data['emp_leave_list'] = $this->leave_model->get_employee_leave_type($this->session->userdata("name"));  
     
        $mlf=[];
        foreach($this->data['emp_leave_list'] as $val){
           // echo $val['leave_type'];
                if($val['leave_type']=='ML'){
 $mlf[] ='1';
                }else{
                   // $mlf='N';
                }
            }

$this->data['mlfs']= count($mlf);
        $this->load->view($this->view_dir.'leave_form',$this->data);
       //  $this->load->view($this->view_dir.'leave_form_new',$this->data);
        $this->load->view('footer');
      
    }

       public function apply_ml_leave(){
        
        $this->load->view('header',$this->data);
        $this->load->model('Admin_model');
         $this->data['state']= $this->Admin_model->getAllState();
         $this->data['school_list']= $this->Admin_model->getAllschool();
        
        $this->data['emp_detail']=$this->leave_model->fetchEmployeeData($this->session->userdata("name"));
        $this->data['leave']=$this->leave_model->getAllLeaveType();
        $this->data['emp_leave_list'] = $this->leave_model->get_employee_leave_type($this->session->userdata("name"));  
        $this->load->view($this->view_dir.'leave_form24',$this->data);
        $this->load->view('footer');
      
    }
    
    public function add_leave(){
        $this->load->view('header',$this->data);
           //$ad = date('d-m-Y',strtotime($_POST['leave_applied_from_date']));
		
		
		
		    $current_yyear = date('Y');
			
			if($_POST['apply_leave_type']=='OD'){
				
				if(strtotime($_POST['applied_from_date']) < strtotime(date('Y-m-d 00:00:00'))){
					 $this->session->set_flashdata('message1','You cannot apply for back date');
                      redirect('Leave/apply_leave');  
				}
				
				
				
				$hrsc = $_POST['od_duration'];
				if($hrsc=='hrs'){
			 $leave_from_datey = date('Y',strtotime($_POST['applied_from_date'])); 
			 $leave_to_datey = date('Y',strtotime($_POST['applied_from_date']));
		//	echo '';
				}else{
		    $leave_from_datey = date('Y',strtotime($_POST['applied_from_date'])); 
            $leave_to_datey = date('Y',strtotime($_POST['od_applied_to_date'])); 
				}
			}else{
				if((strtotime($_POST['leave_applied_from_date']) < strtotime(date('Y-m-d 00:00:00'))) &&  ($_POST['ltyp'] =='CL' || $_POST['ltyp'] =='LWP' )){
					 $this->session->set_flashdata('message1','You cannot apply for back date');
                      redirect('Leave/apply_leave');  
				}
				
				
				
				
				
				
				
			if(($_POST['ltyp']=="CL")&&($_POST['leave_duration']=="half-day")){
			//	if($this->session->userdata("name")==210555){ echo '1w';}
			$leave_from_datey = date('Y',strtotime($_POST['leave_applied_from_date'])); 
            $leave_to_datey = date('Y',strtotime($_POST['applied_to_date1'])); 
			}else if(($_POST['ltyp']=="")&&($_POST['leave_type']=="LWP")&&($_POST['leave_duration']=="half-day")){
			//	if($this->session->userdata("name")==210555){ echo '2w';}
	        $leave_from_datey = date('Y',strtotime($_POST['leave_applied_from_date'])); 
            $leave_to_datey = date('Y',strtotime($_POST['applied_to_date1'])); 
			
				
			}else if(($_POST['ltyp']=="LWP")&&($_POST['leave_type']=="LWP")&&($_POST['leave_duration']=="half-day")){
			//	if($this->session->userdata("name")==210555){ echo '2w';}
	        $leave_from_datey = date('Y',strtotime($_POST['leave_applied_from_date'])); 
            $leave_to_datey = date('Y',strtotime($_POST['applied_to_date1'])); 
			
				
			
			
			}else{
			//	if($this->session->userdata("name")==210555){ echo '2w';}
	        $leave_from_datey = date('Y',strtotime($_POST['leave_applied_from_date'])); 
            $leave_to_datey = date('Y',strtotime($_POST['leave_applied_to_date'])); 
			
				}
			}
			//$leave_to_datey=$leave_from_datey;
			//echo $leave_from_datey;
			//echo $leave_to_datey;
			//exit();
			if($this->session->userdata("name")==210501){ 
			//print_r($_POST);
			//echo $leave_to_datey = date('Y',strtotime($_POST['applied_to_date1']));
			//echo $_POST['leave_applied_to_date'];
			//echo 'test_1';echo $current_yyear.'---'.$leave_from_datey.'--&&--'.$current_yyear.'--'.$leave_to_datey;
			//exit();
			}
			if(1==1){
				//($current_yyear ==($leave_from_datey))&&($current_yyear == ($leave_to_datey))
				
			//	if($this->session->userdata("name")==210555){echo 'test_2';}
			/*	echo '1';
			}else{
				echo '2';
			}
			exit();*/
        //echo "Please Apply leave after some times...Page is under modification.";
       // print_r($_POST);
       // exit;
        // 29-08-2018 ristriction of 2 days back leave
         $td = date('d-m-Y',strtotime('-2days'));
          $cd = date('d-m-Y');
         if($_POST['apply_leave_type']=='OD'){
		    $ad = date('d-m-Y',strtotime($_POST['applied_from_date']));
		    $y = date('Y',strtotime($_POST['applied_from_date'])); 
	   }else{
	  // 	echo $_REQUEST['leave_applied_from_date'];

		    $ad = date('d-m-Y',strtotime($_POST['leave_applied_from_date']));
	        $y = date('Y',strtotime($_POST['leave_applied_from_date'])); 
	   }
//	 echo $y;
      // echo $ad;
      // exit;
	 $ct = substr($y,0,2) ;
	  if($ct == '19'){
		   $this->session->set_flashdata('message1','Apply Date is not in proper format.');
                redirect('Leave/apply_leave');    
	  }else{
	  	//$empary = array('110111');
        $empary = array();
       
        if($_POST['apply_leave_type']=='OD'){
			
          $ldur = $_POST['od_duration'];
          if($ldur=='hrs'){
             $nday = $_POST['no_hrs_forod'];
          }else{
          $nday = $_POST['no_days_forod'];    
          }
		 // echo $_FILES['od_cert']['name'];
		  
			
			
			
		  
		  
      }elseif($_POST['apply_leave_type']=='leave'){
          $ldur = $_POST['leave_duration'];
          $nday = $_POST['no_days'];
      }
     
      if(($ldur =='full-day' && $nday >0) || ($ldur=='half-day' && $nday==0.5) || ($ldur=='hrs' && $nday > 0.0)){
     
        if(!empty($_POST)){
            $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    //  echo"<pre>";print_r($_FILES['medical_cert']['name']);echo"</pre>";die();
            if(!empty($_FILES['medical_cert']['name'])){
                $_FILES['medical_cert']['name'] = clean($_FILES['medical_cert']['name']);
                $filenm='ML_'.$_POST['emp_id'].'_'.strtotime(date('h:s',strtotime())).'_'.$_FILES['medical_cert']['name'];
                
                $config['upload_path'] = 'uploads/employee_documents/';
                $config['allowed_types'] = 'doc|docx|pdf|txt|jpg|jpeg|png';
                $config['overwrite']= false;
                $config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                $ext = explode('.', $filenm);
                $filenm = $filenm. '.'. end($ext);
                //Load upload library and initialize configuration
                // $this->load->library('upload',$config);
                // $this->upload->initialize($config);

                /*
                if($this->upload->do_upload('medical_cert')){
                    //  echo "hhh";
                    $uploadData = $this->upload->data();
                    $_POST['medical_cert']= $uploadData['file_name'];
                   // array_push($picture,$uploadData['file_name']);
                }else{
                   //  $error = array('error' => $this->upload->display_errors());
                    // print_r($error);
                    // $this->load->view('display', $error); 
                       $_POST['medical_cert']= '';
                }*/
                try{
                    $bucket_name = 'erp-asset';
                    $file_path = 'uploads/employee_documents/'.$filenm;
                    $src_file = $_FILES['medical_cert']['tmp_name'];
                    $result = $this->awssdk->uploadFile($bucket_name, $file_path, $src_file);
                    $_POST['medical_cert']= $filenm;
                }catch(Exception $e){
                    $_POST['medical_cert']= '';
                }
                
            }
            else{
                $_POST['medical_cert']= '';
            }
			
			
			 
			
			if(!empty($_FILES['od_cert']['name'])){

                $od_certff=clean(trim($_FILES['od_cert']['name']));
				$dname = explode(".", $_FILES['od_cert']['name']);
                $ext = end($dname);
				
                $file_od='OD_'.$_POST['emp_id'].'_'.date('Ymdhis').'.'.$ext;
                
                $configg['upload_path'] = 'uploads/employee_documents/';
                $configg['allowed_types'] = 'doc|docx|pdf|txt|jpg|jpeg|png';
                $configg['overwrite']= false;
                $configg['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $configg['file_name'] = $file_od;
                
                //Load upload library and initialize configuration
                // $this->load->library('upload',$configg);
                // $this->upload->initialize($configg);
                
                try{
                    $bucket_name = 'erp-asset';
                    $file_path = 'uploads/employee_documents/'.$file_od;
                    $src_file = $_FILES['od_cert']['tmp_name'];
                    $result = $this->awssdk->uploadFile($bucket_name, $file_path, $src_file);
                    $_POST['od_cert_new']= $file_od;
                }catch(Exception $e){
                    $_POST['od_cert_new']= '';
                }
                /*
                if($this->upload->do_upload('od_cert')){
                  //  echo "hhh";
                    $uploadData = $this->upload->data();
                    $_POST['od_cert_new']=$file_od; //$uploadData['file_name'];
                  // array_push($picture,$uploadData['file_name']);
                }else{
                   //  $error = array('error' => $this->upload->display_errors());
                    // print_r($error);
       // $this->load->view('display', $error); 
                       $_POST['od_cert_new']= 'no_file';
                }
                */
            }
            else{
                $_POST['od_cert_new']= 'no_file';
            }
			
		
			
            $_POST['officer_id'] = $this->officer_id;
            $res=$this->leave_model->addEmpLeave($_POST);
        }
		if($_POST['emp_id']=="210510"){
		//print_r($_POST);
		 // print_r($uploadData);
		 // exit();
			}
        if($res>=1){
            //after applying for the leave.it should be forwarded to the Reporting officer.
            $app_type = $_POST['apply_leave_type'];
    if($app_type == 'leave'){
            $r_emp = $this->leave_model->get_reporting_person($this->session->userdata("name"),$_POST["leave_type"]);
    }else{
            $r_emp = $this->leave_model->get_reporting_person($this->session->userdata("name"),'OD');
    }
            
            $reporting=$this->leave_model->fetchEmployeeData($r_emp[0]['report_person1']);
            $emp_detail=$this->leave_model->fetchEmployeeData($this->session->userdata("name"));
           
         $lst = $this->leave_model->update_used_leaves($_POST['emp_id'],$_POST['leave_type'],'Pending',$_POST['no_days'],$_POST['leave_duration'],$this->config->item('current_year2'));
		 	
			
		 

		 
		 
		 
        //  exit;
            //echo"<pre>";print_r($_POST);echo"</pre>";
//          //send mail to employee
/*using curl*/
try{
//$ch = curl_init("http://www.rvduniversity.com/mailer/mailer-matrimony.php");
//$to =$reporting[0]['oemail'] ;
//$to = 'arvind.thasal@carrottech.in';
     

 if($_POST['apply_leave_type']=='leave'){
    if($_POST['leave_type']=='lwp'){
        $leave_ty ='LWP';
    }else{
 $leave_ty =$this->leave_model->getLeaveTypeById($_POST['leave_type']);
}
}else{
    $leave_ty = "OD";
}
$loc =$_POST['location_od'];
//$to ="abhishek.vitkar@carrottech.in";
if($emp_detail[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($emp_detail[0]['gender'] == 'female'){
$g = 'Mrs.';
}
if($_POST['vl_leave']=='vl'){
            $info = $this->leave_model->get_vid_emp_allocation($_POST['leave_type']);
$_POST['leave_applied_from_date']  = $info[0]['from_date'];
$_POST['leave_applied_to_date'] = $info[0]['to_date'];
            
        }
$name = $g." ".$emp_detail[0]['fname']." ".$emp_detail[0]['lname']; 
$body1 = 'Application no. :<b> '.$res.'</b><br>';
     $body1 .= 'Staff ID: <b>'.$this->session->userdata("name").'</b><br>';
        $body1 .= 'Staff Name:<b> '.$name .'</b><br>';
        $body1 .= 'Application for : <b>'.$leave_ty.'</b><br>';
        if($_POST['apply_leave_type']=='leave'){
        $body1 .= 'No. Of Days :<b>'.$_POST['no_days'].'</b><br>';
        if($_POST['leave_duration']=='half-day'){
            $todate = $_POST['leave_applied_from_date'];
        }else{
            $todate = $_POST['leave_applied_to_date'];
        }
        if($_POST['leave_applied_from_date']==$todate){
            $body1 .= 'For Date : <b>'.$_POST['leave_applied_from_date'].'</b><br>';
        }else{
        $body1 .= 'For Date :<b> '.$_POST['leave_applied_from_date'].' To '.$todate.'</b><br>';
    }
        $body1 .= 'Reason :<b>'.$_POST['reason'].'</b><br>';
        $su = $_POST['leave_applied_from_date'].' To '.$todate;
        }elseif($_POST['apply_leave_type']=='OD'){
            if($_POST['od_duration']=='hrs'){
                $body1 .= 'No. Of Hrs :<b>'.$_POST['no_hrs_forod'].' Hrs</b><br>';
                if($_POST['od_departure_time']==$_POST['od_arrival_time']){
 $body1 .= 'Time :<b>'.$_POST['od_departure_time'].'</b><br>';
                }else{
                $body1 .= 'Time :<b>'.$_POST['od_departure_time'].' to '.$_POST['od_arrival_time'].'</b><br>';
            }
        $body1 .= 'For Date :<b> '.$_POST['applied_from_date'].'</b><br>';
        $body1 .= 'Purpose For OD :<b>'.$_POST['reason_od'].'.</b><br>';
        $body1 .= 'Location: <b>'.$loc.'</b><br>';   
$su = $_POST['applied_from_date'].' To '.$_POST['applied_from_date'];       
            }else{
                $body1 .= 'No. Of Days :<b>'.$_POST['no_days_forod'].'</b><br>';
                if($_POST['applied_from_date']==$_POST['od_applied_to_date']){
$body1 .= 'For Date : <b>'.$_POST['applied_from_date'].'</b><br>';
                }else{
                   $body1 .= 'For Date : <b>'.$_POST['applied_from_date'].' To '.$_POST['od_applied_to_date'].'</b><br>'; 
                }
        
        $body1 .= 'Purpose For OD :<b>'.$_POST['reason_od'].'</b><br>';
        $body1 .= 'Location: <b>'.$loc.'</b><br>';   
        $su = $_POST['applied_from_date'].' To '.$_POST['od_applied_to_date'];      
            }
        }

        
$sub = 'You sent application of '.$leave_ty.' from '.$su;
//$encoded = 'send=true&Cc=arvind.thasal@carrottech.in&from_name='.urlencode($frm_nm).'&from_email='.urlencode($frm_email).'&to='.urlencode($to).'&subject='.urlencode($sub);
       
        $body = 'Your '.$_POST['apply_leave_type'].' application details are;<br>';
        $body .= $body1; 

       $this->send_leave_mail($emp_detail[0]['oemail'],$sub,$body);



$sub1 = 'You have '.$_POST['apply_leave_type'].' application of '.$name ;
//$encoded1 = 'send=true&Cc=arvind.thasal@carrottech.in&from_name='.urlencode($frm_nm).'&from_email='.urlencode($frm_email).'&to='.urlencode($to_re).'&subject='.urlencode($sub1);
 
        $body_r = 'Your '.$_POST['apply_leave_type'].' application details are;<br>';
        $body_r .= $body1;      
         $this->send_leave_mail($reporting[0]['oemail'],$sub1,$body_r);

		 
//print_r($_POST);
//exit;
//$email_ary = array('ankur.saxena@carrottech.in','jugal.singh@carrottech.in','balasaheb.lengare@carrottech.in');
//mail for alternate
if(!empty($_POST['ch'])){
$cnt = count($_POST['ch']);
    for($i=0;$i<=$cnt;$i++){
$alt_email = $this->leave_model->fetchEmployeeData($_POST['ch'][$i]);
           

$to1 =$alt_email[0]['oemail'];
$sub2 = 'You are Selected as a atlernate arrangement for '.$leave_ty.' by '.$name ;
//$encoded1 = 'send=true&Cc=arvind.thasal@carrottech.in&from_name='.urlencode($frm_nm).'&from_email='.urlencode($frm_email).'&to='.urlencode($to1).'&subject='.urlencode($sub2);
 
        $body_r = 'You are selected as alternative arrangement for '.$leave_ty.' taken by<br>';
        $body_r .= 'Staff ID: <b>'.$this->session->userdata("name").'</b><br>';
        $body_r .= 'Staff Name:<b> '.$name .'</b><br>'; 
        if($_POST['fromdt'][$i] == $_POST['todt'][$i]){
$body_r .= 'For Date : <b>'.$_POST['fromdt'][$i].'</b><br>';
        }else{
         $body_r .= 'For Date : <b>'.$_POST['fromdt'][$i].' To '.$_POST['todt'][$i].'</b><br>';
        }
if($_POST['apply_leave_type']=='leave'){
    $body_r .= 'Purpose: <b>'.$_POST['reason'] .'</b><br>';
}else{  
$body_r .= 'Purpose: <b>'.$_POST['reason_od'] .'</b><br>';
$body_r .= 'Location: <b>'.$loc.'</b><br>';   
}
//$this->send_leave_mail($to1,$sub2,$body_r);
// $this->load->library('Message_api');
/*$odj = new Message_api();
$sms_message = 'You are selected as alternative arrangement for '.$leave_ty.' taken by';
        $sms_message .= 'Staff ID: '.$this->session->userdata("name").'';
        $sms_message .= 'Staff Name: '.$name .''; 
        if($_POST['fromdt'][$i] == $_POST['todt'][$i]){
$sms_message .= 'For Date : '.$_POST['fromdt'][$i].'';
        }else{
         $sms_message .= 'For Date : '.$_POST['fromdt'][$i].' To '.$_POST['todt'][$i].'';
        }
        $mobile = $alt_email[0]['mobileNumber'];
$odj->send_sms($mobile,$sms_message);   
*/
}
   
}

//curl_close($ch); 
}
catch(Exception $e){
    throw new Exception("Invalid URL",0,$e);
}


            $this->session->set_flashdata('message1','Your Leave Application Has been submitted...');
                redirect('Leave/apply_leave');  
                        
        }else{
             if($res=='lexd'){
                    $this->session->set_flashdata('message1','CL leave is exceed for this month.');
                redirect('Leave/apply_leave');
             }elseif($res=='lAD'){
                    $this->session->set_flashdata('message1','leave already applyed on this date.');
                redirect('Leave/apply_leave');
             }else{
            $this->session->set_flashdata('message1','Your Reporting/Leave is not Assigned. Please contact to Admin Dept.');
                redirect('Leave/apply_leave');
             }
        }
        }else{
          $this->session->set_flashdata('message1','Please Select valid date and duration.');
                redirect('Leave/apply_leave');
      }
 // }
}
        $this->load->view('footer');
		
		
		
	}else{
		//if($this->session->userdata("name")==210555){echo 'test_3';}
	 $this->session->set_flashdata('message1','Not Apply.Please Try again');
	 redirect('Leave/apply_leave');
	}
	////////////////////////////////////////////////////////////////////////////
    }

public function send_leave_mail1($addres,$sub,$body){
	echo '4';
exit();
	$addres=$addres.',kiran.valimbe@sandipuniversity.edu.in,noreply@sandipuniversity.com';
 $this->load->library('smtp');
    $this->load->library('phpmailer');
    $mail = new PHPMailer;

//$mail->isSMTP();                            // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                     // Enable SMTP authentication
$mail->Username = 'developers@sandipuniversity.com';          // SMTP username
$mail->Password = 'university@24'; // SMTP password
$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                          // TCP port to connect to

$mail->setFrom('admindept@sandipuniversity.edu.in', 'Admin Department');
$mail->addAddress($addres);

//$mail->addReplyTo('admindept@sandipuniversity.in', 'Admin Department');
$mail->addCC('admindept@sandipuniversity.edu.in');
$mail->isHTML(true);  // Set email format to HTML
$mail->Subject = $sub;
 $body .= "<span style='color:red;'>Note:This is an autogenerated mail,Please dont reply for this mail.</span>";

$mail->Body    = $body;
//if(!empty($addres)){
/*if(!$mail->send()) {
    return $mail->ErrorInfo;
}else{
    return '1';
} */return '1';
//}
}
public function send_leave_mail($addres,$sub,$body){

$this->load->library('Message_api');
$obj = New Message_api();
//$body="test";
//$subject=$sub;
//$file="";
//$to="balasaheb.lengare@carrottech.in";
//$cc="admindept@sandipuniversity.edu.in";
//$bcc="kiran.valimbe@sandipuniversity.edu.in";
//$newaddress="kiran.valimbe@sandipuniversity.edu.in,noreply@sandipuniversity.com,".$addres;
$newaddress=$addres;
$from='noreply7@sandipuniversity.edu.in';
$cc='balasaheb.lengare@carrottech.in';
if(!empty($addres)){
$cursession = $obj->sendattachedemail($body,$sub,$file,$newaddress,$cc,$bcc,$from);
}
    return '1';
}



public function send_leave_mail_approved($addres,$sub,$body){

//echo '2';
//exit();
    $this->load->library('Message_api');
$obj = New Message_api();
//$body="test";
//$subject=$sub;
//$file="";
//$to="balasaheb.lengare@carrottech.in";
//$cc="admindept@sandipuniversity.edu.in";
$cc='';
$addres=$addres.',kiran.valimbe@sandipuniversity.edu.in';
//$bcc="kiran.valimbe@sandipuniversity.edu.in";
$from='noreply@sandipuniversity.com';
if(!empty($addres)){
//$cursession = $obj->sendattachedemail($body,$sub,$file,$addres,$cc,$bcc,$from);
}

    return '1';

}
public function send_leave_mail_approved1($addres,$sub,$body){
	//echo '3';
//exit();
 $this->load->library('smtp');
    $this->load->library('phpmailer');
    $mail = new PHPMailer;

//$mail->isSMTP();                            // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                     // Enable SMTP authentication
$mail->Username = 'developers@sandipuniversity.com';          // SMTP username
$mail->Password = 'university@24'; // SMTP password
$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                          // TCP port to connect to

$mail->setFrom('admindept@sandipuniversity.edu.in', 'Admin Department');
$mail->addAddress($addres);

//$mail->addReplyTo('admindept@sandipuniversity.in', 'Admin Department');
$mail->addCC('admindept@sandipuniversity.edu.in');
//$mail->addBCC('arvind.thasal@carrottech.in');
$mail->addBCC('kiran.valimbe@sandipuniversity.edu.in');
$mail->isHTML(true);  // Set email format to HTML
$mail->Subject = $sub;
 $body .= "<span style='color:red;'>Note:This is an autogenerated mail,Please dont reply for this mail.</span>";

$mail->Body    = $body;
//if(!empty($addres))
{
/*if(!$mail->send()) {
    return $mail->ErrorInfo;
}else{
    return '1';
}*/

return '1';
}
}

     public function leave_applicant_list($mon='')
    {
       //ini_set('error_reporting', E_ALL);
    $this->load->view('header',$this->data);
    $this->data['mon'] = $mon;
	
	//print_r($mon);
	//exit();
      if($this->session->userdata("role_id")==58 || $this->session->userdata("role_id")==1 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==11 || $this->session->userdata("role_id")==7){  //for Admin
     
        $this->data['applicant_od']= $this->leave_model->getAllLeaveApplicantList('OD',$mon); 
        $this->data['applicant_leave']= $this->leave_model->getAllLeaveApplicantList('leave',$mon);  
		
		

      }else{ 
	  
	   
      $this->data['applicant_od']= $this->leave_model->getLeaveApplicantList($this->session->userdata("role_id"),$this->session->userdata("name"),'OD',$mon);
      $this->data['applicant_leave']= $this->leave_model->getLeaveApplicantList($this->session->userdata("role_id"),$this->session->userdata("name"),'leave',$mon);
	  
     
      } 
   $this->data['checked_hours'] = $this->leave_model->getLeaveTimeByType();

    $this->load->view($this->view_dir.'leave_process',$this->data);
    $this->load->view('footer');
    }
	
	
	 public function allocated_task_list($mon='')
    {
       //ini_set('error_reporting', E_ALL);
     $this->load->view('header',$this->data);
     $this->data['mon'] = $mon;
      if($this->session->userdata("role_id")==1 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==11 || $this->session->userdata("role_id")==7){  //for Admin
        $this->data['other_tsk_list']= $this->leave_model->other_tsk_list($mon); 
           
      }else{ 
          $this->data['other_tsk_list']= $this->leave_model->other_tsk_list($mon,$this->session->userdata("uid"));
     
     
      } 
   //print_r($this->data['other_tsk_list']);
   //exit;
    $this->load->view($this->view_dir.'other_task_process',$this->data);
    $this->load->view('footer');
    }
	
	
	
	
	
    function view_leave_application($application_id,$sts=''){
       // ini_set('error_reporting', E_ALL);
      $this->load->view('header',$this->data);
        $this->load->model('Admin_model');
        $this->load->model('Employee_model');
      // echo $application_id;    
      $this->data['sfilter'] = $sts;
      $this->data['details']= $this->leave_model->getLeaveDetailById($application_id);
      $this->data['emp_leave_list'] = $this->leave_model->get_employee_leave_type($this->data['details'][0]['emp_id']);   
      //print_r($this->data['details']);
      //exit;
       $this->load->view($this->view_dir.'view_leave_application',$this->data);
        $this->load->view('footer');
   }
   
   
   
    function update_leave_application(){  
   //print_r($_POST);
   //exit;
    	//ini_set('error_reporting', E_ALL);
   //$this->load->library('smtp');
   // $this->load->library('phpmailer');
        $mon='';
       if(!empty($_POST)){             
        $res=$this->leave_model->update_leave_applicationDetails($_POST);  
       //$res = 1;     
       }
	   $mon =date("m-Y", strtotime($_POST['applied_from_date']));
	  // $this->data['mon'] = $mon;
       if($res==1){        
           /* //Deduct leave balance from staff allocated leave ///leave deduction will be done only leave approved by registrar only**/

          /* if($res['lstatus']=='Approved'){              
               $deduct=$this->Admin_model->deductLeaveCount($res);
           } */
           $emp_detail=$this->leave_model->fetchEmployeeData($_POST['emp_id'],'Y');
           
           $reporting=$this->leave_model->fetchEmployeeData($this->session->userdata("name"));
          
           
         
if($reporting[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($reporting[0]['gender'] == 'female'){
$g = 'Mrs.';
}
$name = $g." ".$reporting[0]['fname']." ".$reporting[0]['lname'];

if($_POST['status']=='Approved'){
$sub ='Your '.$_POST['leave_name'].' Application is Approved By '.$name;
}elseif($_POST['status']=='Rejected'){
$sub ='Your '.$_POST['leave_name'].' Application is Rejected By '.$name;
}elseif($_POST['status']=='Forward'){
    $emp = $_POST['emp_lev'];
    if($emp == 'emp1_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp2_reporting_person',$_POST['lid']);
    }elseif($emp == 'emp2_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp3_reporting_person',$_POST['lid']);
    }elseif($emp == 'emp3_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp4_reporting_person',$_POST['lid']);
    }
    $emp_nr=$this->leave_model->fetchEmployeeData($nr);
  if($emp_nr[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($emp_nr[0]['gender'] == 'female'){
$g = 'Mrs.';
}
    $sub ='Your '.$_POST['leave_name'].' Application is Forwarded to '.$g.' '.$emp_nr[0]['fname'].' '.$emp_nr[0]['lname'];
}
//$encoded = 'send=true&from_name='.urlencode($frm_nm).'&from_email='.urlencode($frm_email).'&to='.urlencode($to).'&subject='.$sub;
              $empl =$this->leave_model->fetchEmployeeData($_POST['emp_id']);
      if($emp1[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($emp1[0]['gender'] == 'female'){
$g = 'Mrs.';
}
        
        $body1 .= 'Application no. :<b> '.$_POST['lid'].'</b><br>';
     $body1 .= 'Staff ID:<b>'.$_POST['emp_id'].'</b><br>';
        $body1 .= 'Staff Name:<b>'.$g.' '.$_POST['ename'].'</b><br>';
        if($_POST['leave_name'] == 'OD'){
            if($_POST['leave_duration'] == 'hrs'){
            $body1 .= 'No. Of Hrs :<b> '.$_POST['no_days'] .'Hrs</b><br>';
            }else{
                $body1 .= 'No. Of Days :<b> '.$_POST['no_days'] .'</b><br>';
            }
        }else{
        $body1 .= 'No. Of Days :<b> '.$_POST['no_days'] .'</b><br>';
        }
       if($_POST['leave_name'] == 'OD'){
if($_POST['leave_duration'] == 'hrs'){
           $body1 .= 'For Date :<b> '.$_POST['applied_from_date'].'</b><br>';
            }else{
                 
if($_POST['applied_from_date'] == $_POST['applied_to_date']){
 $body1 .= 'For Date :<b> '.$_POST['applied_from_date'].'</b><br>';
        }else{
        $body1 .= 'For Date : <b>'.$_POST['applied_from_date'].' to '.$_POST['applied_to_date'].'</b><br>';
    }
              
            }
 


        }elseif($_POST['applied_from_date'] == $_POST['applied_to_date']){
 $body1 .= 'For Date :<b> '.$_POST['applied_from_date'].'</b><br>';
        }else{
        $body1 .= 'For Date : <b>'.$_POST['applied_from_date'].' to '.$_POST['applied_to_date'].'</b><br>';
    }
if($_POST['leave_name'] == 'OD'){
            if($_POST['leave_duration'] == 'hrs'){
            $body1 .= 'Departure_time :<b> '.$_POST['departure_time'] .'</b><br>';
            $body1 .= 'Arrival_time :<b> '.$_POST['arrival_time'] .'</b><br>';
            }
        }

       if($_POST['leave_name'] == 'OD'){
          $body1 .= 'Purpose :<b> '.$_POST['reason'].'</b><br>';
       }else{
        $body1 .= 'Reason :<b> '.$_POST['reason'].'</b><br>';
    }
if($_POST['leave_name'] == 'OD'){
       $body1 .= 'Location:<b>'.$_POST['leave_contct_address'].'</b><br>';
   }
        $body = $sub .' and Application details are;<br>';
        $body .= $body1;
        //for emp
$this->send_leave_mail($emp_detail[0]['oemail'],$sub,$body);

      $empl =$this->leave_model->fetchEmployeeData($_POST['emp_id']);
      if($emp1[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($emp1[0]['gender'] == 'female'){
$g = 'Mrs.';
}


if($_POST['status']=='Approved'){
$sub1 ='You have Approved '.$_POST['leave_name'].' of '.$g.' '.$_POST['ename'];
}elseif($_POST['status']=='Rejected'){
$sub1 ='Your have Rejected '.$_POST['leave_name'].' of '.$g.' '.$_POST['ename'];
}elseif($_POST['status']=='Forward'){
 $sub1 ='You have Forwarded '.$_POST['leave_name'].' Application  to '.$g.' '.$emp_nr[0]['fname'].' '.$emp_nr[0]['lname'];
}


$body2 = $sub1 .' and Application details are;<br>';
        $body2 .= $body1;
         $body2 .= 'Status :<b> '.$_POST['status'].'</b><br>';
         //for reporter
$this->send_leave_mail($reporting[0]['oemail'],$sub1,$body2);
      
       if($_POST['status']=='Forward'){
 $emp = $_POST['emp_lev'];
    if($emp == 'emp1_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp2_reporting_person',$_POST['lid']);
    }elseif($emp == 'emp2_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp3_reporting_person',$_POST['lid']);
    }elseif($emp == 'emp3_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp4_reporting_person',$_POST['lid']);
    }
    $emp_nr=$this->leave_model->fetchEmployeeData($nr);
    if($emp_detail[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($emp_detail[0]['gender'] == 'female'){
$g = 'Mrs.';
}
    $sub3 ='You have '.$_POST['leave_name'].' application of '.$g.' '.$emp_detail[0]['fname'].' '.$emp_detail[0]['lname'] ;
$body3 = $sub3 .' and Application details are;<br>';

        $body3 .= $body1;
//forward reporter
        $to = $emp_nr[0]['oemail'];
        if($_POST['status']=='Approved'){
       $this->send_leave_mail_approved($to,$sub3,$body3);
        }else{
$this->send_leave_mail($to,$sub3,$body3);
        }

      
       }

       if($_POST['status'] == 'Cancel'){
     $begin12 = new DateTime(date('Y-m-d',strtotime($_POST['applied_from_date'])));
     $end12 = new DateTime(date('Y-m-d',strtotime($_POST['applied_to_date'].' +1 day')));
    
$daterange12 = new DatePeriod($begin12, new DateInterval('P1D'), $end12);
 //print_r($daterange12);
foreach($daterange12 as $date){
    $ch = curl_init("http://sandipuniversity.com/erp_cron/erp_cron_new.php");

    //echo "pp".$date->format("Y-m-d");
        // Now set some options (most are optional)
 $encoded = "dt=".$date->format("Y-m-d")."&empid=".$_POST['emp_id'];
   $encoded = substr($encoded, 0, strlen($encoded));
curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_exec($ch);
//curl_setopt($ch, CURLOPT_VERBOSE, 0);     
//curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_close($ch); 
ob_clean();
unset($ch);
}   
$bd =date("d-m-Y", strtotime($_POST['applied_from_date']));
 //$this->session->set_flashdata('message1', 'Leave Application Updated Successfully.. ');
              //  redirect('leave/leave_applicant_list');
 //redirect('leave/leave_applicant_list/'.$bd.'/?lt='.$_POST['leave_type'].'&sf='.$_POST['fsearch']);
 redirect('leave/leave_applicant_list/?lt='.$_POST['leave_type'].'&sf='.$_POST['fsearch']);
 
}

//$b = new DateTime(date('m-Y',strtotime($_POST['applied_from_date'])));
$b =date("d-m-Y", strtotime($_POST['applied_from_date']));
        $this->session->set_flashdata('message1', 'Leave Application Updated Successfully.. ');
               // redirect('leave/leave_applicant_list/'.$b.'/?lt='.$_POST['leave_type'].'&sf='.$_POST['fsearch']);
                redirect('leave/leave_applicant_list/?lt='.$_POST['leave_type'].'&sf='.$_POST['fsearch']);
                }
            else{
                $this->session->set_flashdata('message1','Some Problem Occured ...');
               // redirect('leave/leave_applicant_list/'.$b.'/?lt='.$_POST['leave_type'].'&sf='.$_POST['fsearch']);
				redirect('leave/leave_applicant_list/?lt='.$_POST['leave_type'].'&sf='.$_POST['fsearch']);
            }   
   } 
   
   
   
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function update_leave_application_group(){  
//error_reporting(E_ALL);
   //print_r($_POST['chk_checkedf']);
  // exit;
   $status=$_POST['status'];
   foreach($_POST['chk_checkedf'] as $lists){
	  // echo $lists;
  // }
   // exit;
   $data_post= $this->leave_model->getLeaveDetailById($lists);
   
   
    //$this->data['details'][0]['emp_id']; //exit();
   $this->data['emp_leave_list'] = $this->leave_model->get_employee_leave_type($lists);
 //   print_r($data_post); echo '<br>';
	////////////////////////////////////////////////
	$data_post[0]['remark']='WHF by direct entery checkbox';
	$data_post[0]['status']=$status;
	$data_post[0]['ro_recommendation']='WHF by direct entery checkbox';
	
	/////////////////////////////////////////////
	//print_r($data_post[0]['fname']);
	//exit;
	$uid = $this->session->userdata("name");
    $role = $this->session->userdata("role_id");
	$check_employee=$this->leave_model->check_employee($uid);
	$staff_nature=$check_employee[0]['staff_nature'];
                if($staff_nature=="V"){
                  $uid = "v_".$uid;
                }else{
                  $uid = $uid;
                }
									if($data_post[0]['emp1_reporting_person'] == $uid){
										$k=1;
									$emp_lev= "emp1_reporting_person";
									}elseif($data_post[0]['emp2_reporting_person'] == $uid){
										$k=2;
									$emp_lev= "emp2_reporting_person";
									}elseif($data_post[0]['emp3_reporting_person'] == $uid){
										$k=3;
									$emp_lev="emp3_reporting_person";
									}elseif($data_post[0]['emp4_reporting_person']==$uid){
										$k=4;
									$emp_lev="emp4_reporting_person";
									}    
	
	
	$data_post[0]['emp_lev']=$emp_lev;
	
	$data_post[0]['ename']=$data_post[0]['fname'].' '.$data_post[0]['lname'];
	$data_post[0]['leave_name']=$data_post[0]['leave_type'];
    	//ini_set('error_reporting', E_ALL);
   //$this->load->library('smtp');
   // $this->load->library('phpmailer');
   $this->data['details']=$data_post;

//print_r($data_post);
$mon='';
       if(!empty($data_post)){             
        $res=$this->leave_model->update_leave_applicationDetails_group($data_post);  //remark//$status//emp_lev-emp1_reporting_person//
       //$res = 1;     
       }
	// exit;  
	   $mon =date("m-Y", strtotime($data_post[0]['applied_from_date']));
	   $this->data['mon'] = $mon;
       if($res==1){        
           /* //Deduct leave balance from staff allocated leave ///leave deduction will be done only leave approved by registrar only**/

          /* if($res['lstatus']=='Approved'){              
               $deduct=$this->Admin_model->deductLeaveCount($res);
           } */
           $emp_detail=$this->leave_model->fetchEmployeeData($data_post[0]['emp_id'],'Y');
           
           $reporting=$this->leave_model->fetchEmployeeData($this->session->userdata("name"));
          
           
         $body1='';
if($reporting[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($reporting[0]['gender'] == 'female'){
$g = 'Mrs.';
}
$name = $g." ".$reporting[0]['fname']." ".$reporting[0]['lname'];

if($data_post[0]['status']=='Approved'){
$sub ='Your '.$data_post[0]['leave_name'].' Application is Approved By '.$name;
}elseif($data_post[0]['status']=='Rejected'){
$sub ='Your '.$data_post[0]['leave_name'].' Application is Rejected By '.$name;
}elseif($data_post[0]['status']=='Forward'){
    $emp = $data_post[0]['emp_lev'];
    if($emp == 'emp1_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp2_reporting_person',$data_post[0]['lid']);
    }elseif($emp == 'emp2_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp3_reporting_person',$data_post[0]['lid']);
    }elseif($emp == 'emp3_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp4_reporting_person',$data_post[0]['lid']);
    }
    $emp_nr=$this->leave_model->fetchEmployeeData($nr);
  if($emp_nr[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($emp_nr[0]['gender'] == 'female'){
$g = 'Mrs.';
}
    $sub ='Your '.$data_post['leave_name'].' Application is Forwarded to '.$g.' '.$emp_nr[0]['fname'].' '.$emp_nr[0]['lname'];
}
//$encoded = 'send=true&from_name='.urlencode($frm_nm).'&from_email='.urlencode($frm_email).'&to='.urlencode($to).'&subject='.$sub;
              $empl =$this->leave_model->fetchEmployeeData($data_post[0]['emp_id']);
   //  print_r($empl[0]['gender']);
	// exit();
	  if($empl[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($empl[0]['gender'] == 'female'){
$g = 'Mrs.';
}
        
        $body1 .= 'Application no. :<b> '.$data_post[0]['lid'].'</b><br>';
     $body1 .= 'Staff ID:<b>'.$data_post[0]['emp_id'].'</b><br>';
        $body1 .= 'Staff Name:<b>'.$g.' '.$data_post[0]['ename'].'</b><br>';
        if($data_post[0]['leave_name'] == 'OD'){
            if($data_post[0]['leave_duration'] == 'hrs'){
            $body1 .= 'No. Of Hrs :<b> '.$data_post[0]['no_days'] .'Hrs</b><br>';
            }else{
                $body1 .= 'No. Of Days :<b> '.$data_post[0]['no_days'] .'</b><br>';
            }
        }else{
        $body1 .= 'No. Of Days :<b> '.$data_post[0]['no_days'] .'</b><br>';
        }
       if($data_post[0]['leave_name'] == 'OD'){
if($data_post[0]['leave_duration'] == 'hrs'){
           $body1 .= 'For Date :<b> '.$data_post[0]['applied_from_date'].'</b><br>';
            }else{
                 
if($data_post[0]['applied_from_date'] == $data_post[0]['applied_to_date']){
 $body1 .= 'For Date :<b> '.$data_post[0]['applied_from_date'].'</b><br>';
        }else{
        $body1 .= 'For Date : <b>'.$data_post[0]['applied_from_date'].' to '.$data_post[0]['applied_to_date'].'</b><br>';
    }
              
            }
 


        }elseif($data_post[0]['applied_from_date'] == $data_post[0]['applied_to_date']){
 $body1 .= 'For Date :<b> '.$data_post[0]['applied_from_date'].'</b><br>';
        }else{
        $body1 .= 'For Date : <b>'.$data_post[0]['applied_from_date'].' to '.$data_post[0]['applied_to_date'].'</b><br>';
    }
if($data_post[0]['leave_name'] == 'OD'){
            if($data_post[0]['leave_duration'] == 'hrs'){
            $body1 .= 'Departure_time :<b> '.$data_post[0]['departure_time'] .'</b><br>';
            $body1 .= 'Arrival_time :<b> '.$data_post[0]['arrival_time'] .'</b><br>';
            }
        }

       if($data_post[0]['leave_name'] == 'OD'){
          $body1 .= 'Purpose :<b> '.$data_post[0]['reason'].'</b><br>';
       }else{
        $body1 .= 'Reason :<b> '.$data_post[0]['reason'].'</b><br>';
    }
if($data_post[0]['leave_name'] == 'OD'){
       $body1 .= 'Location:<b>'.$data_post[0]['leave_contct_address'].'</b><br>';
   }
        $body = $sub .' and Application details are;<br>';
        $body .= $body1;
        //for emp
//$this->send_leave_mail($emp_detail[0]['oemail'],$sub,$body);

      $emp2 =$this->leave_model->fetchEmployeeData($data_post[0]['emp_id']);
     
	// print_r($empl);
	 
if($emp2[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($emp2[0]['gender'] == 'female'){
$g = 'Mrs.';
}


if($data_post[0]['status']=='Approved'){
$sub1 ='You have Approved '.$data_post[0]['leave_name'].' of '.$g.' '.$data_post[0]['ename'];
}elseif($data_post['status']=='Rejected'){
$sub1 ='Your have Rejected '.$data_post[0]['leave_name'].' of '.$g.' '.$data_post[0]['ename'];
}elseif($data_post['status']=='Forward'){
 $sub1 ='You have Forwarded '.$data_post[0]['leave_name'].' Application  to '.$g.' '.$emp_nr[0]['fname'].' '.$emp_nr[0]['lname'];
}


$body2 = $sub1 .' and Application details are;<br>';
        $body2 .= $body1;
         $body2 .= 'Status :<b> '.$data_post[0]['status'].'</b><br>';
         //for reporter

//$this->send_leave_mail($reporting[0]['oemail'],$sub1,$body2);
      
       if($data_post[0]['status']=='Forward'){
 $emp = $data_post[0]['emp_lev'];
    if($emp == 'emp1_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp2_reporting_person',$data_post[0]['lid']);
    }elseif($emp == 'emp2_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp3_reporting_person',$data_post[0]['lid']);
    }elseif($emp == 'emp3_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp4_reporting_person',$data_post[0]['lid']);
    }
    $emp_nr=$this->leave_model->fetchEmployeeData($nr);
    if($emp_detail[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($emp_detail[0]['gender'] == 'female'){
$g = 'Mrs.';
}
    $sub3 ='You have '.$data_post[0]['leave_name'].' application of '.$g.' '.$emp_detail[0]['fname'].' '.$emp_detail[0]['lname'] ;
$body3 = $sub3 .' and Application details are;<br>';

        $body3 .= $body1;
//forward reporter
        $to = $emp_nr[0]['oemail'];
        if($data_post[0]['status']=='Approved'){
      // $this->send_leave_mail_approved($to,$sub3,$body3);
        }else{
//$this->send_leave_mail($to,$sub3,$body3);
        }

      
       }

       if($data_post[0]['status'] == 'Cancel'){
     $begin12 = new DateTime(date('Y-m-d',strtotime($data_post[0]['applied_from_date'])));
     $end12 = new DateTime(date('Y-m-d',strtotime($data_post[0]['applied_to_date'].' +1 day')));
    
$daterange12 = new DatePeriod($begin12, new DateInterval('P1D'), $end12);
 //print_r($daterange12);
foreach($daterange12 as $date){
    $ch = curl_init("http://sandipuniversity.com/erp_cron/erp_cron_new.php");

    //echo "pp".$date->format("Y-m-d");
        // Now set some options (most are optional)
 $encoded = "dt=".$date->format("Y-m-d")."&empid=".$data_post[0]['emp_id'];
   $encoded = substr($encoded, 0, strlen($encoded));
curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_exec($ch);
//curl_setopt($ch, CURLOPT_VERBOSE, 0);     
//curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_close($ch); 
ob_clean();
unset($ch);
}   
$bd =date("d-m-Y", strtotime($data_post[0]['applied_from_date']));
 //$this->session->set_flashdata('message1', 'Leave Application Updated Successfully.. ');
              //  redirect('leave/leave_applicant_list');
 //redirect('leave/leave_applicant_list/'.$bd.'/?lt='.$data_post[0]['leave_type'].'&sf='.$data_post[0]['fsearch']);
 echo 1;
}

//$b = new DateTime(date('m-Y',strtotime($_POST['applied_from_date'])));
$b =date("d-m-Y", strtotime($data_post[0]['applied_from_date']));
        $this->session->set_flashdata('message1', 'Leave Application Updated Successfully.. ');
              //  redirect('leave/leave_applicant_list/'.$b.'/?lt='.$data_post[0]['leave_type'].'&sf='.$data_post[0]['fsearch']);
                echo 2; 
                }
            else{
                $this->session->set_flashdata('message1','Some Problem Occured ...');
              //  redirect('leave/leave_applicant_list/'.$b.'/?lt='.$data_post[0]['leave_type'].'&sf='.$data_post[0]['fsearch']);
			   echo 3;
            }   
}
   } 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
   function update_leave_application_group_od(){  
//error_reporting(E_ALL);
  // print_r($_POST);
 // exit;
   $status=$_POST['status'];
   foreach($_POST['chk_checkedf'] as $lists){
	  // echo $lists;
  // }
   // exit;
   $data_post= $this->leave_model->getLeaveDetailById($lists);
   
   
    //$this->data['details'][0]['emp_id']; //exit();
   $this->data['emp_leave_list'] = $this->leave_model->get_employee_leave_type($lists);
 //   print_r($data_post); echo '<br>';
	////////////////////////////////////////////////
	if($_POST['ltype']=='leave'){
	$data_post[0]['remark']='Leave by direct entery checkbox';
	$data_post[0]['status']=$status;
	$data_post[0]['ro_recommendation']='Leave by direct entery checkbox';
	}else{
	$data_post[0]['remark']='OD by direct entery checkbox';
	$data_post[0]['status']=$status;
	$data_post[0]['ro_recommendation']='OD by direct entery checkbox';
	}
	
	/////////////////////////////////////////////
	//print_r($data_post[0]['fname']);
	//exit;
	$uid = $this->session->userdata("name");
    $role = $this->session->userdata("role_id");
	$check_employee=$this->leave_model->check_employee($uid);
	$staff_nature=$check_employee[0]['staff_nature'];
                if($staff_nature=="V"){
                  $uid = "v_".$uid;
                }else{
                  $uid = $uid;
                }
									if($data_post[0]['emp1_reporting_person'] == $uid){
										$k=1;
									$emp_lev= "emp1_reporting_person";
									}elseif($data_post[0]['emp2_reporting_person'] == $uid){
										$k=2;
									$emp_lev= "emp2_reporting_person";
									}elseif($data_post[0]['emp3_reporting_person'] == $uid){
										$k=3;
									$emp_lev="emp3_reporting_person";
									}elseif($data_post[0]['emp4_reporting_person']==$uid){
										$k=4;
									$emp_lev="emp4_reporting_person";
									}    
	
	
	$data_post[0]['emp_lev']=$emp_lev;
	
	$data_post[0]['ename']=$data_post[0]['fname'].' '.$data_post[0]['lname'];
	//$data_post[0]['leave_name']=$data_post[0]['leave_type'];
	
	if($data_post[0]['leave_apply_type']=='OD')
	{
		$data_post[0]['leave_name']=$data_post[0]['leave_type'];
	}else
	{
		$ldata=$this->leave_model->getLeaveTypeById($data_post[0]['leave_type']);		
		$data_post[0]['leave_name']=$ldata;
	}
    	//ini_set('error_reporting', E_ALL);
   //$this->load->library('smtp');
   // $this->load->library('phpmailer');
   $this->data['details']=$data_post;

//print_r($data_post);
$mon='';
       if(!empty($data_post)){             
        $res=$this->leave_model->update_leave_applicationDetails_group($data_post);  //remark//$status//emp_lev-emp1_reporting_person//
       //$res = 1;     
       }
	// exit;  
	   $mon =date("m-Y", strtotime($data_post[0]['applied_from_date']));
	   $this->data['mon'] = $mon;
       if($res==1){        
           /* //Deduct leave balance from staff allocated leave ///leave deduction will be done only leave approved by registrar only**/

          /* if($res['lstatus']=='Approved'){              
               $deduct=$this->Admin_model->deductLeaveCount($res);
           } */
           $emp_detail=$this->leave_model->fetchEmployeeData($data_post[0]['emp_id'],'Y');
           
           $reporting=$this->leave_model->fetchEmployeeData($this->session->userdata("name"));
          
           
         $body1='';
if($reporting[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($reporting[0]['gender'] == 'female'){
$g = 'Mrs.';
}
$name = $g." ".$reporting[0]['fname']." ".$reporting[0]['lname'];

if($data_post[0]['status']=='Approved'){
$sub ='Your '.$data_post[0]['leave_name'].' Application is Approved By '.$name;
}elseif($data_post[0]['status']=='Rejected'){
$sub ='Your '.$data_post[0]['leave_name'].' Application is Rejected By '.$name;
}elseif($data_post[0]['status']=='Forward'){
    $emp = $data_post[0]['emp_lev'];
    if($emp == 'emp1_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp2_reporting_person',$data_post[0]['lid']);
    }elseif($emp == 'emp2_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp3_reporting_person',$data_post[0]['lid']);
    }elseif($emp == 'emp3_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp4_reporting_person',$data_post[0]['lid']);
    }
    $emp_nr=$this->leave_model->fetchEmployeeData($nr);
  if($emp_nr[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($emp_nr[0]['gender'] == 'female'){
$g = 'Mrs.';
}

    $sub ='Your '.$data_post['leave_name'].' Application is Forwarded to '.$g.' '.$emp_nr[0]['fname'].' '.$emp_nr[0]['lname'];
}
//$encoded = 'send=true&from_name='.urlencode($frm_nm).'&from_email='.urlencode($frm_email).'&to='.urlencode($to).'&subject='.$sub;
              $empl =$this->leave_model->fetchEmployeeData($data_post[0]['emp_id']);
   //  print_r($empl[0]['gender']);
	// exit();
	  if($empl[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($empl[0]['gender'] == 'female'){
$g = 'Mrs.';
}
        
        $body1 .= 'Application no. :<b> '.$data_post[0]['lid'].'</b><br>';
     $body1 .= 'Staff ID:<b>'.$data_post[0]['emp_id'].'</b><br>';
        $body1 .= 'Staff Name:<b>'.$g.' '.$data_post[0]['ename'].'</b><br>';
        if($data_post[0]['leave_name'] == 'OD' || $data_post[0]['leave_name'] == 'Leave'){
            if($data_post[0]['leave_duration'] == 'hrs'){
            $body1 .= 'No. Of Hrs :<b> '.$data_post[0]['no_days'] .'Hrs</b><br>';
            }else{
                $body1 .= 'No. Of Days :<b> '.$data_post[0]['no_days'] .'</b><br>';
            }
        }else{
        $body1 .= 'No. Of Days :<b> '.$data_post[0]['no_days'] .'</b><br>';
        }
       if($data_post[0]['leave_name'] == 'OD' || $data_post[0]['leave_name'] == 'Leave'){
if($data_post[0]['leave_duration'] == 'hrs'){
           $body1 .= 'For Date :<b> '.$data_post[0]['applied_from_date'].'</b><br>';
            }else{
                 
if($data_post[0]['applied_from_date'] == $data_post[0]['applied_to_date']){
 $body1 .= 'For Date :<b> '.$data_post[0]['applied_from_date'].'</b><br>';
        }else{
        $body1 .= 'For Date : <b>'.$data_post[0]['applied_from_date'].' to '.$data_post[0]['applied_to_date'].'</b><br>';
    }
              
            }
 


        }elseif($data_post[0]['applied_from_date'] == $data_post[0]['applied_to_date']){
 $body1 .= 'For Date :<b> '.$data_post[0]['applied_from_date'].'</b><br>';
        }else{
        $body1 .= 'For Date : <b>'.$data_post[0]['applied_from_date'].' to '.$data_post[0]['applied_to_date'].'</b><br>';
    }
if($data_post[0]['leave_name'] == 'OD' || $data_post[0]['leave_name'] == 'Leave'){
            if($data_post[0]['leave_duration'] == 'hrs'){
            $body1 .= 'Departure_time :<b> '.$data_post[0]['departure_time'] .'</b><br>';
            $body1 .= 'Arrival_time :<b> '.$data_post[0]['arrival_time'] .'</b><br>';
            }
        }

       if($data_post[0]['leave_name'] == 'OD' || $data_post[0]['leave_name'] == 'Leave'){
          $body1 .= 'Purpose :<b> '.$data_post[0]['reason'].'</b><br>';
       }else{
        $body1 .= 'Reason :<b> '.$data_post[0]['reason'].'</b><br>';
    }
if($data_post[0]['leave_name'] == 'OD' || $data_post[0]['leave_name'] == 'Leave'){
       $body1 .= 'Location:<b>'.$data_post[0]['leave_contct_address'].'</b><br>';
   }
        $body = $sub .' and Application details are;<br>';
        $body .= $body1;
        //for emp
	$this->send_leave_mail($emp_detail[0]['oemail'],$sub,$body);

      $emp2 =$this->leave_model->fetchEmployeeData($data_post[0]['emp_id']);
     
	// print_r($empl);
	 
if($emp2[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($emp2[0]['gender'] == 'female'){
$g = 'Mrs.';
}


if($data_post[0]['status']=='Approved'){
$sub1 ='You have Approved '.$data_post[0]['leave_name'].' of '.$g.' '.$data_post[0]['ename'];
}elseif($data_post['status']=='Rejected'){
$sub1 ='Your have Rejected '.$data_post[0]['leave_name'].' of '.$g.' '.$data_post[0]['ename'];
}elseif($data_post['status']=='Forward'){
 $sub1 ='You have Forwarded '.$data_post[0]['leave_name'].' Application  to '.$g.' '.$emp_nr[0]['fname'].' '.$emp_nr[0]['lname'];
}


$body2 = $sub1 .' and Application details are;<br>';
        $body2 .= $body1;
         $body2 .= 'Status :<b> '.$data_post[0]['status'].'</b><br>';
         //for reporter

$this->send_leave_mail($reporting[0]['oemail'],$sub1,$body2);
      
       if($data_post[0]['status']=='Forward'){
 $emp = $data_post[0]['emp_lev'];
    if($emp == 'emp1_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp2_reporting_person',$data_post[0]['lid']);
    }elseif($emp == 'emp2_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp3_reporting_person',$data_post[0]['lid']);
    }elseif($emp == 'emp3_reporting_person'){
        $nr=$this->leave_model->get_next_reporting('emp4_reporting_person',$data_post[0]['lid']);
    }
    $emp_nr=$this->leave_model->fetchEmployeeData($nr);
    if($emp_detail[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($emp_detail[0]['gender'] == 'female'){
$g = 'Mrs.';
}
    $sub3 ='You have '.$data_post[0]['leave_name'].' application of '.$g.' '.$emp_detail[0]['fname'].' '.$emp_detail[0]['lname'] ;
$body3 = $sub3 .' and Application details are;<br>';

        $body3 .= $body1;
//forward reporter
        $to = $emp_nr[0]['oemail'];
        if($data_post[0]['status']=='Approved'){
      // $this->send_leave_mail_approved($to,$sub3,$body3);
        }else{
		$this->send_leave_mail($to,$sub3,$body3);
        }

      
       }

       if($data_post[0]['status'] == 'Cancel'){
     $begin12 = new DateTime(date('Y-m-d',strtotime($data_post[0]['applied_from_date'])));
     $end12 = new DateTime(date('Y-m-d',strtotime($data_post[0]['applied_to_date'].' +1 day')));
    
$daterange12 = new DatePeriod($begin12, new DateInterval('P1D'), $end12);
 //print_r($daterange12);
foreach($daterange12 as $date){
    $ch = curl_init("http://sandipuniversity.com/erp_cron/erp_cron_new.php");

    //echo "pp".$date->format("Y-m-d");
        // Now set some options (most are optional)
 $encoded = "dt=".$date->format("Y-m-d")."&empid=".$data_post[0]['emp_id'];
   $encoded = substr($encoded, 0, strlen($encoded));
curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_exec($ch);
//curl_setopt($ch, CURLOPT_VERBOSE, 0);     
//curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_close($ch); 
ob_clean();
unset($ch);
}   
$bd =date("d-m-Y", strtotime($data_post[0]['applied_from_date']));
 //$this->session->set_flashdata('message1', 'Leave Application Updated Successfully.. ');
              //  redirect('leave/leave_applicant_list');
 //redirect('leave/leave_applicant_list/'.$bd.'/?lt='.$data_post[0]['leave_type'].'&sf='.$data_post[0]['fsearch']);
 echo 1;
}

//$b = new DateTime(date('m-Y',strtotime($_POST['applied_from_date'])));
$b =date("d-m-Y", strtotime($data_post[0]['applied_from_date']));
        $this->session->set_flashdata('message1', 'Leave Application Updated Successfully.. ');
              //  redirect('leave/leave_applicant_list/'.$b.'/?lt='.$data_post[0]['leave_type'].'&sf='.$data_post[0]['fsearch']);
                echo 2; 
                }
            else{
                $this->session->set_flashdata('message1','Some Problem Occured ...');
              //  redirect('leave/leave_applicant_list/'.$b.'/?lt='.$data_post[0]['leave_type'].'&sf='.$data_post[0]['fsearch']);
			   echo 3;
            }   
}
   } 
 



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
   
   
   
   
   
   function view_application_forward_details($id){
      // $eid = explode("_",$id);
        $ldetails = $this->leave_model->getLeaveDetailById($id);
        $emp_details=$this->leave_model->fetchEmployeeData($ldetails[0]['emp_id']);
          $lt = $this->leave_model->getLeaveTypeById($ldetails[0]['leave_type']);
	   if($lt == 'VL'){
            $cnt = $this->leave_model->get_vid_emp_allocation($ldetails[0]['leave_type']);
        $lt = $lt." - ".$cnt[0]['slot_type'];    
        }else{
            $lt = $lt;
        }
       $this->load->model('Employee_model');
             echo '<div class="modal-header">
       <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
        <h4 class="modal-title">'.$emp_details[0]['emp_id'].' - '.$emp_details[0]['fname'].' '.$emp_details[0]['lname'].' ('.$ldetails[0]['leave_apply_type'].'  '.$lt.') </h4>
  
      </div>
      <div class="modal-body">
        <p>     
            <div class="row">
    
        <div class="timeline-centered">';
        $cnt = $this->leave_model->getcountreporting($id);
                        
        for($i=1;$i<=$cnt;$i++){
         
             $emp_detail=$this->Employee_model->get_emp_details($ldetails[0]['emp'.$i.'_reporting_person']);
        echo '<article class="timeline-entry">
            <div class="timeline-entry-inner">
                <div class="timeline-icon bg-success">'.$i.'</div>
                <div class="timeline-label">
                    <h2><a href="#">'.$emp_detail[0]['emp_id'].'</a> <span> - '.$emp_detail[0]['fname'].' '.$emp_detail[0]['lname'].'</span><span class="pull-right">Date : ';
                 //echo  $ldetails[0]['emp'.$i.'_reporting_date'];
                   if(!is_null($ldetails[0]['emp'.$i.'_reporting_date'])){
                    echo date('d-m-Y',strtotime($ldetails[0]['emp'.$i.'_reporting_date']));
                    }
                    echo' </span></h2>
                    <p>Status : ';
                    if(empty($ldetails[0]['emp'.$i.'_reporting_status'])){echo 'Pending'; }else{ echo $ldetails[0]['emp'.$i.'_reporting_status']; }
                    echo ' </p><p>Remark : '.$ldetails[0]['emp'.$i.'_reporting_remark'].' </p>
                </div>
            </div>

        </article>';
          if($ldetails[0]['emp'.$i.'_reporting_status'] == 'Approved' || $ldetails[0]['emp'.$i.'_reporting_status'] == 'Rejected'){
          $i = $cnt+2;
         }
      
        if(empty($ldetails[0]['emp'.$i.'_reporting_status']) ){
          $i = $cnt+2;
         }
        }
        if($ldetails[0]['fstatus']=='Cancel'){
            $cnt1 = $cnt+ 1;
         echo '<article class="timeline-entry">
            <div class="timeline-entry-inner">
                <div class="timeline-icon bg-success">'.$cnt1.'</div>
                <div class="timeline-label">
                    <h2><a href="#"></a> <span> Admin </span><span class="pull-right">Date : '.date('d-m-Y',strtotime($ldetails[0]['adm_comment_date']));
                 //echo  $ldetails[0]['emp'.$i.'_reporting_date'];
                 
                    echo' </span></h2>
                    <p>Status : '.$ldetails[0]['fstatus'];
                      echo ' </p><p>Remark : '.$ldetails[0]['adm_comment'].' </p>
                </div>
            </div>

        </article>';
        }
    echo '</p>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div></div></div>';
       
       
   }
    public function check_leave_status($mon=''){
        $this->load->view('header',$this->data);
        $this->data['mon']=$mon;
        $id=$this->session->userdata('name');
        $this->data['leave']=$this->leave_model->getMyAllLeave($id,'leave',$mon);
        $this->data['leaveod']=$this->leave_model->getMyAllLeave($id,'OD',$mon);
        /* print_r($this->data['leave']);
        die(); */
        $this->load->view($this->view_dir.'leave_status',$this->data);
        $this->load->view('footer');
    }
        function del_leave_app(){
        $application_id=$_REQUEST['id'];
        if(!empty($application_id)){
         $res=$this->leave_model->remove_leave_application($application_id);    
        }
         if($res==true){
        $this->session->set_flashdata('message1', 'Leave Application Deleted Successfully.. ');
                redirect('leave/check_leave_status');
                
                }
            else{
                $this->session->set_flashdata('message1','Some Problem Occured ...');
                redirect('leave/check_leave_status');
            }   
   }
    public function create_getpass(){
      $this->load->view('header',$this->data);
      if(!empty($_REQUEST['od_id'])){
        $data['od_id']=$_REQUEST['od_id'];
      $data['emp_id']=$_REQUEST['emp_id'];
      $id=$this->session->userdata('name');
      $this->data['od']=$this->Employee_model->getMyAllOD($id);  
         $this->data['getpass_data']=$this->Employee_model->getPassData($data);
     /* echo"<pre>";print_r($data['getpass_data']);echo"</pre>";
        die(); */
     $this->load->view($this->view_dir.'odlist_status',$this->data);
      }
      if(!empty($_REQUEST['lv_id'])){
          //echo"in leave data";exit;
         $data['lv_id']=$_REQUEST['lv_id'];
         $data['emp_id']=$_REQUEST['emp_id']; 
         $id=$this->session->userdata('name'); 
         $this->data['leave']=$this->leave_model->getMyAllLeave($id);
        $this->data['getpass_data1']=$this->leave_model->getPassDataforLeave($data);    
           // Print_r($this->data['getpass_data1']);
         $this->load->view($this->view_dir.'leave_status',$this->data);     
      }
        $this->load->view('footer');
 }

 public function downloadgetpass($lid,$emp,$gt){
     //ini_set('error_reporting', E_ALL);
    // $str=$_REQUEST['str'];
     $data['lv_id']=$lid;
     $data['emp_id']=$emp;
     $id=$this->session->userdata('name'); 
         $this->data['leave']=$this->leave_model->getMyAllLeave($id,'');
      $this->data['getpass_data1']=$this->leave_model->getPassDataforLeave($data);
      $this->data['gtyp']=$gt;
     // print_r($this->data['getpass_data1']);
     $html = $this->load->view($this->view_dir . 'gatepass_form', $this->data,true);
   
     //exit;
     if($gt=='m'){
         $pdfFilePath = $id."_MovementOrder.pdf";
     }else{
            $pdfFilePath = $id."_gatepass.pdf";
        }

            //load mPDF library
            $this->load->library('m_pdf');
             $this->m_pdf->pdf->SetDisplayMode('fullpage');

            $this->m_pdf->pdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
            //$stylesheet = file_get_contents($stylpath);
           // $this->m_pdf->pdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text

           // $stylesheet1 = file_get_contents($bootpath);
           // $this->m_pdf->pdf->WriteHTML($stylesheet1, 1); // The parameter 1 tells that this is css/style only and no body/html/text
//              $stylesheet2 = file_get_contents($fontpath);
//              $this->m_pdf->pdf->WriteHTML($stylesheet2,1);   // The parameter 1 tells that this is css/style only and no body/html/text
            //generate the PDF from the given html
            $this->m_pdf->pdf->WriteHTML($html);

            //download it.
            $this->m_pdf->pdf->Output($pdfFilePath, "D");
//  $this->load->view($this->view_dir.'exporttoexcel',$str);
 }
 function employee_coff_add(){
     $this->load->view('header',$this->data);
        $id=$this->session->userdata('name');
        //$this->data['leave']=$this->leave_model->getMyAllLeave($id);
        /* print_r($this->data['leave']);
        die(); */
        $this->load->view($this->view_dir.'employee_leave_coff_add',$this->data);
        $this->load->view('footer');
 }
 function get_emp_coff($eid,$date){
     if(empty($date)){
         echo "Select date for C-OFF";
     }else{
     $coff =$this->leave_model->get_punching_emp_bydate($eid,$date);
echo $coff;

 }
 }
 function add_employee_coff(){
    if(!empty($_FILES['upload_file']['name'])){

                $filenm='COFF_'.$_POST['staffid'].'_'.strtotime(date('h:s',strtotime())).'_'.$_FILES['upload_file']['name'];
                
            $config['upload_path'] = 'uploads/employee_coff_documents/';
                $config['allowed_types'] = 'doc|docx|pdf';
                $config['overwrite']= False;
                $config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('upload_file')){
                  //  echo "hhh";
                    $uploadData = $this->upload->data();
                    $_POST['upload_file']= $filenm;
                  // array_push($picture,$uploadData['file_name']);
                }else{
                     $error = array('error' => $this->upload->display_errors());
                    // print_r($error);
                     //exit;
        redirect('Leave/employee_coff_add?e=1'); 
                       $_POST['upload_file']= '';
                }
            }
            else{
                $_POST['upload_file']= '';
            }
            if(isset($_POST['status'])){
                  $this->data['leave']=$this->leave_model->add_coff($_POST);
            }else{
                $this->session->set_flashdata('message1','Your  Application not submitted. Select status.');
                redirect('Leave/employee_coff_add');
    
 }
     $this->session->set_flashdata('message1','Your  Application Has been submitted...');
                redirect('Leave/employee_coff_add');
 }
 public function download($fileName = NULL) {   
   $this->load->helper('download');
   if ($fileName) {
    $file = realpath("uploads/employee_coff_documents")."\\".urldecode($fileName);
  // exit;
   // check file exists    
    if (file_exists ( $file )) {
     // get file content
     $data = file_get_contents ( $file );
     //force download
     force_download ( $fileName, $data );
    } else {
     // Redirect to base url
     redirect ( base_url () );
    }
   }
  }
 function employee_coff_list($mon=''){
     $this->load->view('header',$this->data);
        $this->data['mon'] = $mon;
        $this->data['coffleave']=$this->leave_model->getMyAllcoffLeave($mon);
        /* print_r($this->data['leave']);
        die(); */
        $this->load->view($this->view_dir.'employee_leave_coff_list',$this->data);
        $this->load->view('footer');
 }
 function employee_coff_update($id){
     $this->load->view('header',$this->data);       
        $this->data['leave']=$this->leave_model->getcoff_byid($id);
        /* print_r($this->data['leave']);
        die(); */
        $this->load->view($this->view_dir.'employee_leave_coff_update',$this->data);
        $this->load->view('footer');
 }
 function update_employee_coff(){
     $this->data['leave']=$this->leave_model->update_coff($_POST);
     $this->session->set_flashdata('message1','Your  Application Has been updated...');
                redirect('Leave/employee_coff_list');
 }
function send_mail_test($sub,$body){

$this->load->library('smtp');
    $this->load->library('phpmailer');
    $mail = new PHPMailer;

//$mail->isSMTP();                            // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                     // Enable SMTP authentication
$mail->Username = 'developers@sandipuniversity.com';          // SMTP username
$mail->Password = 'university@24'; // SMTP password
$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                          // TCP port to connect to

$mail->setFrom('developers@sandipuniversity.com', 'Admin Department');
$mail->addAddress('admindept@sandipuniversity.edu.in');

//$mail->addReplyTo('admindept@sandipuniversity.in', 'Admin Department');
//$mail->addCC('arvind.thasal@carrottech.in');
$mail->addBCC('arvind.thasal@carrottech.in');
$mail->isHTML(true);  // Set email format to HTML
$mail->Subject = $sub;
$mail->Body    = $body;

if(!$mail->send()) {
    return $mail->ErrorInfo;
}else{
    return '1';
}
}


    function update_leave_application1(){  
        $emp_approved = $this->leave_model->fetch_leaves_approved();
   $i=1;
   //echo count($emp_approved);
   foreach($emp_approved as $val){
   //echo $val['emp_id'];
           $emp_detail1=$this->leave_model->fetchEmployeeData1($val['emp_id']);
           //print_r($emp_detail1);
           //$reporting=$this->leave_model->fetchEmployeeData($this->session->userdata("name"));
          
          // echo $val['emp_id'];
          // echo "<br/>";
         //getLeaveTypeById
if($emp_detail1[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($emp_detail1[0]['gender'] == 'female'){
$g = 'Mrs.';
}
$name = $g." ".$emp_detail1[0]['fname']." ".$emp_detail1[0]['lname'];
 //echo $val['leave_type'];
if($val['leave_type']=='OD'){ ////official
    $levname = 'OD';
}else{
    $levname =$this->leave_model->getLeaveTypeById($val['leave_type']);
}

//if($val['status']=='Approved'){
 $sub ='You have Approved '.$levname.' of '.$name ;
//echo "<br/>";
//}
$body.$i = 'You have Approved '.$levname.' of '.$name .' and Application details are;<br>';

        
        $body.$i .= 'Application no. :<b> '.$val['lid'].'</b><br>';
     $body.$i .= 'Staff ID:<b>'.$emp_detail1[0]['emp_id'].'</b><br>';
        $body.$i .= 'Staff Name:<b> '. $name.'</b><br>';
        if($levname == 'OD'){
            if($val['leave_duration'] == 'hrs'){
            $body.$i .= 'No. Of Hrs :<b> '.$val['no_days'] .'Hrs</b><br>';
            }else{
                $body.$i .= 'No. Of Days :<b> '.$val['no_days'] .'</b><br>';
            }
        }else{
        $body.$i .= 'No. Of Days :<b> '.$val['no_days'] .'</b><br>';
        }
       if($levname == 'OD'){
if($val['leave_duration'] == 'hrs'){
           $body.$i .= 'For Date :<b> '.date('d-m-Y',strtotime($val['applied_from_date'])).'</b><br>';
            }else{
                 
if($val['applied_from_date'] == $val['applied_to_date']){
 $body.$i .= 'For Date :<b> '.date('d-m-Y',strtotime($val['applied_from_date'])).'</b><br>';
        }else{
        $body.$i .= 'For Date : <b>'.date('d-m-Y',strtotime($val['applied_from_date'])).' to '.date('d-m-Y',strtotime($val['applied_to_date'])).'</b><br>';
    }
              
            }
 


        }elseif($val['applied_from_date'] == $val['applied_to_date']){
 $body.$i .= 'For Date :<b> '.date('d-m-Y',strtotime($val['applied_from_date'])).'</b><br>';
        }else{
        $body.$i .= 'For Date : <b>'.date('d-m-Y',strtotime($val['applied_from_date'])).' to '.date('d-m-Y',strtotime($val['applied_to_date'])).'</b><br>';
    }
if($levname == 'OD'){
            if($val['leave_duration'] == 'hrs'){
            $body.$i .= 'Departure_time :<b> '.$val['departure_time'] .'</b><br>';
            $body.$i .= 'Arrival_time :<b> '.$val['arrival_time'] .'</b><br>';
            }
        }

       if($levname == 'OD'){
          $body.$i .= 'Purpose :<b> '.$val['reason'].'</b><br>';
       }else{
        $body.$i .= 'Reason :<b> '.$val['reason'].'</b><br>';
    }
if($levname == 'OD'){
       $body.$i .= 'Location:<b>'.$val['leave_contct_address'].'</b><br>';
   }

       // $body2.$i .= $body.$i;
         $body.$i .= 'Status :<b> '.$val['fstatus'].'</b><br>';
          $body.$i .="<br/><br/>";
         echo $body.$i .= "<span style='color:red;'>Note:This is an autogenerated mail,Please dont reply for this mail.</span>";
         //for reporter
      $this->send_mail_test($sub,$body.$i);    
$i=$i+1;
     }
//$this->send_mail_test($reporting[0]['oemail'],$sub1,$body2);      
   }
function export_leaves_deductions($mon) {
   if($mon != '') {
		$mon=$mon;
    } else {
		$mon= date('m-Y');
    }
    $this->data['mon'] = $mon;
    $this->data['leave_deduction'] =$this->leave_model->get_leaves_deductions_lists($mon);
    //echo "<pre>";print_r($this->data['leave_deduction']);die;      
    $this->load->view($this->view_dir.'reports/leaves_deduction_excel.php',$this->data);     
} 

public function employee_leave_deduction($mon=''){
    //ini_set('error_reporting', E_ALL);
         $this->load->view('header',$this->data); 
          $this->data['mon'] = $mon;
        $this->data['leave_deduction'] =$this->leave_model->get_leave_deduction_list($mon);      //echo "<pre>";print_r($this->data['leave_deduction']);die;
        $this->load->view($this->view_dir.'leave_deduction_list',$this->data);
        $this->load->view('footer');
    }
    public function employee_other_leaves_deductions($mon='') {
    //ini_set('error_reporting', E_ALL);
        $this->load->view('header', $this->data); 
        $this->data['mon'] = $mon;
        $this->data['leave_deduction'] = $this->leave_model->get_leaves_deductions_lists($mon);      //echo "<pre>";print_r($this->data['leave_deduction']);die;
        $this->load->view($this->view_dir.'other_leave_deduction_list',$this->data);
        $this->load->view('footer');
    }
     public function leave_deduction_add(){
         $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'leave_deduction_add',$this->data);
        $this->load->view('footer');
    }

    public function leave_deductions(){
        $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'leave_deductions',$this->data);
        $this->load->view('footer');
    }

    public function add_leave_deduction(){
        $ld_add = $this->leave_model->add_emp_leave_deduction($_POST);
        redirect('Leave/employee_leave_deduction');
    }

    public function add_leaves_deductions(){
        $ld_add = $this->leave_model->add_emp_leaves_deductions($_POST);
        redirect('Leave/leave_deductions');
    }

    public function get_emp_leves($empid){
        
    $emp_leave_list = $this->leave_model->get_employee_leave_type($empid,$this->config->item('current_year'));  
   //echo "<pre>";print_r($emp_leave_list);die;
    if(!empty($emp_leave_list)){
        echo '  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Leave Type</th>
        <th>Total Allocated</th>
        <th>Used leaves</th>
        <th>Balance</th>
      </tr>
    </thead>';

    foreach($emp_leave_list as $val){
                    
     echo '<tr>
        <td>'.$val['leave_type'];
if($val['leave_type']=='VL'){
            $cnt = $this->leave_model->get_vacation_leave_list('',$val['vl_id']);
           echo " - ".$cnt[0]['slot_type'];
}     
        echo '<input type="hidden" class="lclass" name="'.$val['leave_type'].'" value="';
        if($val['leave_type']=='CL') { 

            echo $val['id'];
}elseif($val['leave_type']=='Leave') { 
 echo $val['id'];
    }else{
            echo 'LWP';
        }
        echo '"/></td>
        <td>'.$val['leaves_allocated'].'</td>
        <td>';
        if(!empty($val['leave_used'])){ echo $val['leave_used']; }else{ echo '0'; }
        echo '</td>
        <td><span id="'.$val['leave_type'].'">';
        echo $bal =  $val['leaves_allocated']-$val['leave_used'];
        echo '<input type="hidden" name="'.$val['leave_type'].'_bal" id="'.$val['leave_type'].'_bal" value="'.$bal.'" />';
        echo '</span></td></tr>';
     } 
    }else{
    	echo '  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Leave Type</th>
        <th>Total Allocated</th>
        <th>Used leaves</th>
        <th>Balance</th>
      </tr>
    </thead>';
         echo '<tr>
        <td>--</td>
        <td>0</td>
        <td>0</td>
        <td>0</td></tr>';
    }
        echo "</table>";
    }

    public function get_emps_leves($empid){
        
    $emp_leave_list = $this->leave_model->get_employee_leave_type($empid,$this->config->item('current_year'));  
   //echo "<pre>";print_r($emp_leave_list);die;
    if(!empty($emp_leave_list)){
        echo '  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Leave Type</th>
        <th>Total Allocated</th>
        <th>Used leaves</th>
        <th>Balance</th>
        <th>Deduct Leave</th>
      </tr>
    </thead>';
    $count = 0;
    foreach($emp_leave_list as $val){
      $count++;
     echo '<tr>
        <td>'.$val['leave_type'];
if($val['leave_type']=='VL'){
            $cnt = $this->leave_model->get_vacation_leave_list('',$val['vl_id']);
           echo " - ".$cnt[0]['slot_type'];
}     
        echo '<input type="hidden" class="lclass" name="'.$val['leave_type'].'" value="';
        if($val['leave_type']=='CL') { 

            echo $val['id'];
}elseif($val['leave_type']=='Leave') { 
 echo $val['id'];
    }else{
            echo 'LWP';
        }
        echo '"/></td>
        <td class="totalallocated">'.$val['leaves_allocated'].'</td>
        <td class="usedleaves">';
        if(!empty($val['leave_used'])){ echo $val['leave_used']; }else{ echo '0'; }
        echo '</td>
        <td class="balanceeaves"><span id="'.$val['leave_type'].'">';
        echo $bal =  $val['leaves_allocated']-$val['leave_used'];
        echo '<input type="hidden" name="'.$val['leave_type'].'_bal" id="'.$val['leave_type'].'_bal" value="'.$bal.'" />';
        echo '</span></td>';
         echo '</td>
        <td class="col-md-4 deductleavetype"><span id="'.$val['deduct_leave_type'].'">';
        if($val['leave_type'] == 'VL') {
        	echo '<input class="form-control VL" type="text" name="'.$val['leave_type'].'_bal_deduct" id="'.$val['leave_type'].'_bal_deduct" onkeyup="myFunction()" value="" />';
        } else {
        	echo '<input class="form-control" type="text" name="'.$val['leave_type'].'_bal_deduct" id="'.$val['leave_type'].'_bal_deduct" onkeyup="myFunction()" value="" />';
        }

        echo '</span></td></tr>';
     }
     echo '<input class="form-control" type="hidden" name="noofleaves" id="noofleaves" value="'.$count.'" />'; 
    }else{
    	echo '  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Leave Type</th>
        <th>Total Allocated</th>
        <th>Used leaves</th>
        <th>Balance</th>
      </tr>
    </thead>';
         echo '<tr>
        <td>--</td>
        <td>0</td>
        <td>0</td>
        <td>0</td></tr>';
    }
        echo "</table>";
    }

     function get_emp_punching($eid,$date){
     if(empty($date)){
         echo "Select date.";
     }else{
     $coff =$this->leave_model->get_punching_emp_leave_bydate($eid,$date);
echo $coff;

 }
 }

public function vacation_leave_list($yer=''){
         $this->load->view('header',$this->data); 
		 if(!empty($yer)){
			$yer = $yer;
		}else{
			$yer = $this->config->item('current_year2');
		}
         $this->data['yer'] = $yer;
        $this->data['vac_leave'] =$this->leave_model->get_vacation_leave_list($yer);      
        $this->load->view($this->view_dir.'vacation_leave_list',$this->data);
        $this->load->view('footer');
    }
public function vacation_leave_add(){
         $this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'vacation_leave_add',$this->data);
        $this->load->view('footer');
    }
public function add_vacation_leave_submit(){
$fdate = $_POST['from_date'];
$tdate = $_POST['to_date'];
 //$chk_dt = $this->leave_model->check_vl_dates($fdate,$tdate);
 $chk_vl = $this->leave_model->check_vl_bytype($_POST['vacation_type'],$_POST['slot_type'],$_POST['academic_year']);
//exit;
	if($chk_vl != '1'){
	$this->leave_model->add_vacation_leaves($_POST);
	redirect('Leave/vacation_leave_list');
	}else{
//if($chk_dt == '1'){
//$this->session->set_flashdata('err','Vacation Slot is assigned for this Dates.');
//}else if($chk_vl == '1'){
		$this->session->set_flashdata('err','Vacation Slot is assigned.');
//}
		redirect('Leave/vacation_leave_add');
	}
	
}
public function vacation_leave_edit($vid){
		$this->load->view('header',$this->data); 
		 $this->data['vac_leave'] =$this->leave_model->get_vacation_leave_list('',$vid);      
        $this->load->view($this->view_dir.'vacation_leave_edit',$this->data);
        $this->load->view('footer');
	}
	public function edit_vacation_leave_submit(){	
    $up = $this->leave_model->edit_vacation_leaves($_POST);
  // exit;
if($up){
	redirect('Leave/vacation_leave_list');
}else{
	redirect('Leave/vacation_leave_edit/'.$_POST['vid']);
}
	
	}

	public function vacation_leave_delete($vid){
		$this->leave_model->del_vacation_leaves($vid);	
	}
public function vl_slot(){
		$this->load->view('header',$this->data); 
		$this->load->model('Admin_model');
     //  $this->data['emplist'] = $this->leave_model->getEmpForAllSchool(); 
//print_r($this->data['emplist']);	   
        $this->data['school_list']= $this->Admin_model->getAllschool();
        
		$this->load->view($this->view_dir.'vl_assign_emp',$this->data);
       $this->load->view('footer');
	}
	public function get_emp($vl='',$sch='',$dep=''){
	
		$emplist =$this->leave_model->getEmpForAllSchool($vl,$sch,$dep);
	$j = 1;
 foreach($emplist as $emp){ 

			 echo '<tr>
			 <td><input type="checkbox" name="emp[]" class="empid" value="'.$emp['emp_id'].'" /></td>
			 <td>'.$emp['emp_id'].'</td>
			 <td>';
			 if($emp['gender']=='male'){ echo 'Mr.'; }else{ echo 'Mrs.'; } echo $emp['fname']." ".$emp['lname']; 
			 echo '</td>
			 <td>'.$emp['college_code'].'</td>
			 <td>'.$emp['department_name'].'</td>
			 </tr>';
			 $j++;
			 }
	}
	public function add_vacation_slot_submit(){
		$vl = $this->leave_model->add_vacation_slot($_POST);
		redirect('Leave/vl_slot_list');
	}
	public function vl_slot_list($yer=''){
		$this->load->view('header',$this->data);
		if(!empty($yer)){
          $yer = $yer;
		}else{
			$yer = $this->config->item('current_year2');
		}	
		$this->data['yer'] = $yer;
		 $this->data['vl_slot_emp'] =$this->leave_model->get_vl_slot_emp_list('',$yer);      
        $this->load->view($this->view_dir.'vl_slot_list',$this->data);
        $this->load->view('footer');
	}
	public function update_vl_assign_emp($id){
		//ini_set('error_reporting', E_ALL);
			$this->load->view('header',$this->data); 
		 $this->data['vl_assign_emp'] =$this->leave_model->get_vl_slot_emp_list($id,'');      
        $this->load->view($this->view_dir.'update_vl_assign_emp',$this->data);
        $this->load->view('footer');
	}
	public function get_vl_info($year,$vl,$st){
		$info = $this->leave_model->get_vacation_leave_nodays($year,$vl,$st);
	if(!empty($info[0]['from_date'])){
	echo date('d-m-Y',strtotime($info[0]['from_date']))."/".date('d-m-Y',strtotime($info[0]['to_date']))."/".$info[0]['no_days']."/".$info[0]['vid'];
	}
	}
	public function update_vl_assign_emp_submit(){
		$chk_vl = $this->leave_model->check_emp_slot($_POST['academic_year'],$_POST['emp_id'],$_POST['slot_type']);
		if($chk_vl == '0'){
		$uid = $this->leave_model->update_vl_assign_emp($_POST);
		redirect('Leave/vl_slot_list');
		}else{
		$this->session->set_flashdata('err','Vacation Slot is assigned for this Employee.');
		redirect('Leave/update_vl_assign_emp/'.$_POST['id']);
		}
	}
	public function get_vl_details($lid){
		$info = $this->leave_model->get_vid_emp_allocation($lid);
//print_r($info);
echo date('d-m-Y',strtotime($info[0]['from_date']))."/".date('d-m-Y',strtotime($info[0]['to_date']))."/".$info[0]['no_days']."/".$info[0]['vid'];

	}
	public function get_vl_slot_date($yer,$vt,$st){
		$info = $this->leave_model->get_vacation_leave_slot($yer,$vt,$st);
//print_r($info);
echo date('d-m-Y',strtotime($info[0]['from_date']))."/".date('d-m-Y',strtotime($info[0]['to_date']))."/".$info[0]['no_days']."/".$info[0]['vid'];

	}
public function leave_report(){
	$this->load->view('header',$this->data); 
	$this->load->model('Admin_model');
		 $this->data['school_list']= $this->Admin_model->getAllschool();  
         $this->data['dept_list']= $this->Admin_model->getAllDepartments();      
         $this->data['desig_list']= $this->Admin_model->getAllDesignations();  
		
        $this->load->view($this->view_dir.'leave_reports',$this->data);
        $this->load->view('footer');
}

public function leave_report_pdf(){
	 if(!empty($_POST)){
			 $data['attend_date']=$_POST["attend_date"];
        $data['emp_school']=$_POST["emp_school"];
        $data['department']=$_POST["department"];
		$data['leave_typ']=$_POST['leave_typ'];	 
		
		
		 }
		 $this->data['attend_date']=$_POST["attend_date"];
		 $this->data['emp_leaves_list'] = $this->leave_model->get_emp_leave_list_bymonth($data);
		 
		 $html =  $this->load->view($this->view_dir.'reports/leave_pdf_report',$this->data,true); // render the view into HTML
 $this->load->library('M_pdf');
 ob_clean();
 //ini_set('error_reporting', E_ALL);
        $mpdf=new mPDF();
        
    $this->m_pdf->pdf=new mPDF('L','A4-L','','5',5,5,5,5,5,5);

    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
    
    $this->m_pdf->pdf->WriteHTML($html);
$pdfFilePath = "Leave_Monthly_Report_".date('F_Y',strtotime($data['attend_date'])).".pdf";
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "D");  
		 
}
/*created by Arvind on 9th March 2018 for displaying notication on dashboard*/
  public function check_leave_application_alert(){
    $leave = $this->leave_model->check_leave_approval('110156');
    print_r($leave);exit();
 
}

 public function leave_monthly_report()
    {
        $this->load->view('header',$this->data);
$this->load->model('Admin_model');
        $this->data['school_list']= $this->Admin_model->getAllschool();  
         $this->data['dept_list']= $this->Admin_model->getAllDepartments();      
        // $this->data['desig_list']= $this->Admin_model->getAllDesignations();
        $this->data['emp_list']= $this->Admin_model->getEmployees();
//print_r($_POST);  
    $this->data['attend_date']= $_POST['attend_date'];
        $this->load->view($this->view_dir.'leave_mon_report',$this->data);
        $this->load->view('footer');
    }
    public function generate_leave_report(){
       $this->data['dt'] = $_POST['attend_date'];
       $this->data['app_data']= $this->leave_model->get_leave_report_list($_POST);   
       $html =  $this->load->view($this->view_dir.'/reports/leave_monthly_report',$this->data,true);
       $this->load->library('M_pdf');
 ob_clean();

 //ini_set('error_reporting', E_ALL);
        $mpdf=new mPDF();        
     $this->m_pdf->pdf=new mPDF('L','A4-L','','5',5,5,5,5,5,5); 
    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8'); 
    //print_r($html);exit;   
    $this->m_pdf->pdf->WriteHTML($html);
$pdfFilePath = "LeaveMonthlyReport_".date('F_Y',strtotime($_POST['attend_date'])).".pdf";
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "D");  
   }
   function get_vl_slot_type($ty=''){
     $vt = $this->leave_model->get_vacation_leave_slot_list($this->config->item('current_year2'),$ty);
     echo  "<option value=''>Select</option>";
     foreach ($vt as $key => $value) {
         echo "<option value='".$value['slot_type']."'>".$value['slot_type']."</option>";
     }
   }
   function get_vl_slot_type_duration($vt='',$st=''){
     $vt = $this->leave_model->get_vacation_leave_slot($this->config->item('current_year2'),$vt,$st);
     echo date('d M Y',strtotime($vt[0]['from_date']))." - ".date('d M Y',strtotime($vt[0]['to_date']));
   }
   function export_emp_leave_allocate($typ,$yer){
       if($yer != ''){
$yer=$yer;
         }else{
$yer= $this->config->item('current_year');
         }
         $this->data['yer']=$yer;
         $emp_leave_allocation=$this->data['emp_leave_allocation'] =$this->leave_model->get_employee_leave_allocation($yer);      
          if($typ=='Exl'){
			  ob_clean();
          //$this->load->view($this->view_dir.'reports/employee_leave_allocation_excel',$this->data);  
		  $this->load->library('excel');
 $object = new PHPExcel();
//print_r($sdet);exit;
	  //$iccode = $this->session->userdata("ic_code");

$styleArray = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      ),
	  'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        )
  );
  $styleArray2 = array(
    'font'  => array(
        'size'  => 12,
        'name'  => 'Times New Roman'
    ),
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));

$object->setActiveSheetIndex(0);
	
	 
	$object->getActiveSheet()->setTitle('Employee leave list');

	$object->getActiveSheet()->getStyle('A1:S6')->getFont()->setBold(true);
	  $object->getActiveSheet()->getStyle('A5:S6')->applyFromArray($styleArray);
	  $object->getActiveSheet()->getColumnDimension('F')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('G')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('H')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('I')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('J')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('K')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('L')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('M')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('N')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('O')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('P')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('Q')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('R')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('S')->setWidth('5');
	  
	  $object->getActiveSheet()->mergeCells('A1:S1');
        $object->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);
        $object->getActiveSheet()->getStyle('A1:S1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('A1', 'SANDIP UNIVERSITY');
     $object->getActiveSheet()->mergeCells('A2:S2');        
        $object->getActiveSheet()->getStyle('A2:S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('A2', 'TRIMBAK ROAD,MAHIRAVANI,NASHIK-422213');
      $object->getActiveSheet()->mergeCells('A3:S3');  
        $object->getActiveSheet()->getStyle('A3:S3')->getFont()->setBold(true);      
        $object->getActiveSheet()->getStyle('A3:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('A3', 'Employee leave list for Academic year '.$yer);
      
	  
	  
	  
	

$object->getActiveSheet()->mergeCells('A5:A6')->setCellValue('A5','Sr.No');
$object->getActiveSheet()->mergeCells('B5:B6')->setCellValue('B5','Emp ID');
$object->getActiveSheet()->mergeCells('C5:C6')->setCellValue('C5','Name');
$object->getActiveSheet()->mergeCells('D5:D6')->setCellValue('D5','School');
$object->getActiveSheet()->mergeCells('E5:E6')->setCellValue('E5','Department');
$object->getActiveSheet()->mergeCells('F5:G5')->setCellValue('F5','CL');

$object->getActiveSheet()->setCellValue('F6','A');
$object->getActiveSheet()->setCellValue('G6','U');
$object->getActiveSheet()->mergeCells('H5:I5')->setCellValue('H5','EL');
$object->getActiveSheet()->setCellValue('H6','A');
$object->getActiveSheet()->setCellValue('I6','U');
$object->getActiveSheet()->mergeCells('J5:K5')->setCellValue('J5','ML');
$object->getActiveSheet()->setCellValue('J6','A');
$object->getActiveSheet()->setCellValue('K6','U');
$object->getActiveSheet()->mergeCells('L5:M5')->setCellValue('L5','VL');
$object->getActiveSheet()->setCellValue('L6','A');
$object->getActiveSheet()->setCellValue('M6','U');
$object->getActiveSheet()->mergeCells('N5:O5')->setCellValue('N5','SL');
$object->getActiveSheet()->setCellValue('N6','A');
$object->getActiveSheet()->setCellValue('O6','U');
$object->getActiveSheet()->mergeCells('P5:Q5')->setCellValue('P5','C-OFF');
$object->getActiveSheet()->setCellValue('P6','A');
$object->getActiveSheet()->setCellValue('Q6','U');
 $object->getActiveSheet()->mergeCells('R5:S5')->setCellValue('R5','Leave');
$object->getActiveSheet()->setCellValue('R6','A');
$object->getActiveSheet()->setCellValue('S6','U');
  $ci =&get_instance();
   $ci->load->model('admin_model');
		$j=1;
			$row = 7;	
		foreach($emp_leave_allocation as $val){
			  $lis = $this->leave_model->get_employee_leave_type($val['employee_id'],$val['academic_year']);  
foreach($lis as $val){
	if($val['leave_type']=='VL'){
                 // echo $val['vl_id'];
                    $vl_cnt[$val['employee_id']][] = $val['leaves_allocated'];
$vl_us_cnt[$val['employee_id']][] = $val['leave_used'];
	}
	if($val['leave_type']=='C-OFF'){
			$cff[$val['employee_id']][]= $val['leave_used'];
		}
}
			  $emp = $ci->admin_model->getEmployeeById($val['employee_id']);	
$department =  $ci->admin_model->getDepartmentById($emp[0]['department']); 
$school =  $ci->admin_model->getSchoolById($emp[0]['emp_school']); 
                   if($emp[0]['gender']=='male'){ $g = 'Mr.';}else if($emp[0]['gender']=='female'){ $g = 'Mrs.';}       
$cl = $this->leave_model->get_emp_leaves($val['employee_id'],'CL',$yer);
$el = $this->leave_model->get_emp_leaves($val['employee_id'],'EL',$yer);
$ml = $this->leave_model->get_emp_leaves($val['employee_id'],'ML',$yer);
$vl = $this->leave_model->get_emp_leaves($val['employee_id'],'VL',$yer);
$sl = $this->leave_model->get_emp_leaves($val['employee_id'],'SL',$yer);
$leave = $this->leave_model->get_emp_leaves($val['employee_id'],'Leave',$yer);
  $coff = $this->leave_model->get_emp_leaves($val['employee_id'],'C-OFF',$yer);
$object->getActiveSheet()->setCellValue('A'.$row, $j);
$object->getActiveSheet()->setCellValue('B'.$row, $val['employee_id']);
$object->getActiveSheet()->setCellValue('C'.$row, $g." ".$emp[0]['fname']." ".$emp[0]['lname']);
$object->getActiveSheet()->setCellValue('D'.$row, $school[0]['college_code']);
$object->getActiveSheet()->setCellValue('E'.$row, $department[0]['department_name']);
$object->getActiveSheet()->setCellValue('F'.$row,$cl[0]['leaves_allocated']);
$object->getActiveSheet()->setCellValue('G'.$row,$cl[0]['leave_used']);
$object->getActiveSheet()->setCellValue('H'.$row,$el[0]['leaves_allocated']);
$object->getActiveSheet()->setCellValue('I'.$row,$el[0]['leave_used']);
$object->getActiveSheet()->setCellValue('J'.$row,$ml[0]['leaves_allocated']);
$object->getActiveSheet()->setCellValue('K'.$row,$ml[0]['leave_used']);
$object->getActiveSheet()->setCellValue('L'.$row,array_sum($vl_cnt[$val['employee_id']]));
$object->getActiveSheet()->setCellValue('M'.$row,array_sum($vl_us_cnt[$val['employee_id']]));
$object->getActiveSheet()->setCellValue('N'.$row,$sl[0]['leaves_allocated']);
$object->getActiveSheet()->setCellValue('O'.$row,$sl[0]['leave_used']);
$object->getActiveSheet()->setCellValue('P'.$row,$coff[0]['leaves_allocated']);
$object->getActiveSheet()->setCellValue('Q'.$row,array_sum($cff[$val['employee_id']]));
$object->getActiveSheet()->setCellValue('R'.$row,$leave[0]['leaves_allocated']);
$object->getActiveSheet()->setCellValue('S'.$row,$leave[0]['leave_used']);
		  $row = $row+1;
		  $j=$j+1;			
		}
	$row=$row-1;	

for($r=7;$r<=$row;$r++){
			 $object->getActiveSheet()->getStyle('A'.$r.':s'.$r)->applyFromArray($styleArray);
		}

					
$filename='employee_leave_allocation.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output'); 

          }else{
   $html =  $this->load->view($this->view_dir.'/reports/employee_leave_allocation_pdf',$this->data,true);
       $this->load->library('M_pdf');
 ob_clean();

 //ini_set('error_reporting', E_ALL);
        $mpdf=new mPDF();        
     $this->m_pdf->pdf=new mPDF('L','A4-L','','5',5,5,5,5,5,5); 
    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8'); 
    //print_r($html);exit;   
    $this->m_pdf->pdf->WriteHTML($html);
$pdfFilePath = "LeaveAllocationReport_".$yer.".pdf";
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "D");  
          }
     }
   function export_emp_leave_coff($mon){
        if($mon != ''){
$mon=$mon;
         }else{
$mon= date('m-Y');
         }
         $this->data['mon'] = $mon;
        $this->data['coffleave']=$this->leave_model->getMyAllcoffLeave($mon);
        $this->load->view($this->view_dir.'reports/employee_leave_coff_excel',$this->data);  
   }
   function export_leave_deduction($mon){
       if($mon != ''){
$mon=$mon;
         }else{
$mon= date('m-Y');
         }
         $this->data['mon'] = $mon;
        $this->data['leave_deduction'] =$this->leave_model->get_leave_deduction_list($mon);      
       $this->load->view($this->view_dir.'reports/leave_deduction_excel',$this->data);     
   }
   function export_vl_slot_list($typ,$yer){
       if(!empty($yer)){
$yer = $yer;
        }else{
            $yer = $this->config->item('current_year');
        }   
        $this->data['yer'] = $yer;
         $this->data['vl_slot_emp'] =$this->leave_model->get_vl_slot_emp_list('',$yer);  
     if($typ=='exl'){
         $this->load->view($this->view_dir.'reports/employee_vl_slot_excel',$this->data);  
     }elseif($typ=='pdf'){
         $html =  $this->load->view($this->view_dir.'/reports/employee_vl_slot_pdf',$this->data,true);
       $this->load->library('M_pdf');
 ob_clean();

 //ini_set('error_reporting', E_ALL);
        $mpdf=new mPDF();        
     $this->m_pdf->pdf=new mPDF('','A4','','5',5,5,5,5,5,5); 
    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8'); 
    //print_r($html);exit;   
    $this->m_pdf->pdf->WriteHTML($html);
$pdfFilePath = "Vacation_Leaves_Slot_List_".$yer.".pdf";
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "D");
     }
         
   }

   function export_emp_application_lev($typs='',$mon='',$sel=''){
        if(!empty($mon)){
$mon = $mon;
        }else{
            $mon = date('m-Y');
        }   
        $this->data['mon'] = $mon;
        $this->data['sel'] = $sel;
        $exptp = explode('-',$typs);
$typ = $exptp[0];
$ltyp = $exptp[1];
$this->data['ltyp'] = $ltyp;
           //for Admin
      
        if($ltyp=='od'){
          $this->data['applicant_leave']= $this->leave_model->getLeaveApplicantList($this->session->userdata("role_id"),$this->session->userdata("name"),'OD',$mon);
      }else{
      $this->data['applicant_leave']= $this->leave_model->getLeaveApplicantList($this->session->userdata("role_id"),$this->session->userdata("name"),'leave',$mon);
     }
      
     if($typ=='exl'){
         $this->load->view($this->view_dir.'reports/employee_application_list_excel',$this->data);  
     }elseif($typ=='pdf'){
        // echo "kk";exit;
         $html =  $this->load->view($this->view_dir.'reports/employee_application_list_pdf',$this->data,true);
       //$html = "kkk";
       $this->load->library('M_pdf');
 ob_clean();

 //ini_set('error_reporting', E_ALL);
        $mpdf=new mPDF();        
     $this->m_pdf->pdf=new mPDF('L','A4-L','','5',5,5,5,5,5,5); 
    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8'); 
    //print_r($html);exit;   
    $this->m_pdf->pdf->WriteHTML($html);
$pdfFilePath = "employee_leave_application_list_".$mon.".pdf";
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "D");
     }
   }
    public function leave_adjustment_add(){
        $this->load->view('header',$this->data);
$this->load->model('Admin_model');
        $this->data['school_list']= $this->Admin_model->getAllschool();  
        
        $this->load->view($this->view_dir.'leave_adjustment_add',$this->data);
        $this->load->view('footer');
   }
   public function getEmpListbyDepartmentSchool(){
       $dt = $_REQUEST['sdate'];
       $sc = $_REQUEST['school'];
       $dep= $_REQUEST['department'];
       $emp = $this->leave_model->get_emp_sch_dep($dt,$sc,$dep);
       $i= 1;
       foreach($emp as $val){
           echo "<tr>";
           echo "<td><input type='checkbox' name='empsid[]' value='".$val['emp_id']."' /></td>";
           echo "<td>".$i."</td>";
           echo "<td>".$val['emp_id']."</td>";
           echo "<td>".$val['fname']." ".$val['lname']."</td>";
           echo "<td>".$val['designation_name']."</td>";
           echo "<td>".date('H:i',strtotime($val['Intime']))." - ".date('H:i',strtotime($val['Outtime']))."</td>";
           echo "</tr>";
           $i++;
       }
       
   }
   public function leave_adjustment_submit(){
       if(!empty($_FILES['upfile']['name'])){

                $filenm='leave_adjustment_'.strtotime(date('Y-m-d_h:s',strtotime($_POST['sdate']))).'_'.$_FILES['upfile']['name'];
                
            $config['upload_path'] = 'uploads/';
                $config['allowed_types'] = 'doc|docx|pdf';
                $config['overwrite']= False;
                $config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('upfile')){
                  //  echo "hhh";
                    $uploadData = $this->upload->data();
                    $_POST['upfile']= $filenm;
                  // array_push($picture,$uploadData['file_name']);
                }else{
                     $error = array('error' => $this->upload->display_errors());
                    // print_r($error);
                     //exit;
        redirect('Leave/leave_adjustment_add?e=1'); 
                       $_POST['upfile']= '';
                }
            }
       $ins = $this->leave_model->add_leave_adjustment_emp($_POST);
       redirect('Leave/leave_adjustment_list');
   }
   public function leave_adjustment_list($mon=''){
        $this->load->view('header',$this->data);
        if($mon==''){
            $mon = date('m-Y');
        }else{
            $mon = $mon;
        }
        $this->data['mon']=$mon;
        $this->data['leave_list'] = $this->leave_model->get_emp_adjustment_leaves($mon);
        $this->load->view($this->view_dir.'leave_adjustment_list',$this->data);
        $this->load->view('footer');
   }
   public function add_extra_leaves($mon){
        $this->load->view('header',$this->data);
      
        $this->load->view($this->view_dir.'add_extra_leaves',$this->data);
        $this->load->view('footer');
   }
   public function add_extra_leave_deduction(){
   	$clup = $this->leave_model->update_extra_cl_leave_emp($_POST);
   	if($clup=='1'){
 $this->session->set_flashdata('message1','CL is Added Successfully..');
   	}
       redirect('Leave/add_extra_leaves');  
   }
   public function ml_leave_list($mon=''){
    //ini_set('error_reporting', E_ALL);
         $this->load->view('header',$this->data); 
          $this->data['mon'] = $mon;
        $this->data['ml_leave'] =$this->leave_model->get_ml_list($mon);      
        $this->load->view($this->view_dir.'ml_leave_list',$this->data);
        $this->load->view('footer');
   }
   public function update_ml_leave_application($id){
         $this->load->view('header',$this->data);
 $this->load->model('Admin_model');      
         $this->data['details']= $this->leave_model->getLeaveDetailById($id);
        $this->data['emp_leave_list'] = $this->leave_model->get_employee_leave_type($this->data['details'][0]['emp_id']);       
        $this->load->view($this->view_dir.'update_ml_leaves',$this->data);
        $this->load->view('footer');       
   }
   public function update_ml_leave_application_submit(){
      // print_r($_POST);
       $up = $this->leave_model->update_ml_leave($_POST);
       if(isset($up)){
           $this->session->set_flashdata('message1','ML is Updated Successfully..');
           redirect('Leave/ml_leave_list');
       }else{
             $this->session->set_flashdata('message1','Sorry ML is NOT Updated..');
           redirect('Leave/ml_leave_list');
       }
       
   }

   public function emp_leave_report(){
    $this->load->view('header',$this->data);
 $this->load->model('Admin_model');      
         $this->data['school_list']= $this->Admin_model->getAllschool();  
         $this->data['dept_list']= $this->Admin_model->getAllDepartments();      
         $this->data['desig_list']= $this->Admin_model->getAllDesignations();
         //$this->data['emp_list']= $this->Admin_model->getEmployees1('Y'); //updated by kishor on 21 june,2019
         $this->data['emp_list']= $this->Admin_model->getEmployees2();
        $this->load->view($this->view_dir.'leave_report',$this->data);
        $this->load->view('footer'); 
   }
  /* public function view_emp_leves_list(){
   $emplc = $this->leave_model->get_emp_leave_list($_POST);
   // echo "<pre>";
  // print_r($emplc);exit;
   $this->data['empl'] = $emplc;
   $this->data['styp'] = $_POST['select_dur'];
   if($_POST['select_dur']=='monthly'){
$this->data['smonth'] = $_POST['attend_date'];
}elseif($_POST['select_dur']=='yer'){
$this->data['smonth'] = '00-'.$_POST['attend_datey'];
    }
 if($_POST['rtype']=='pdf'){
       //$html = "kkk";
       $this->load->library('M_pdf');
 ob_clean();

 //ini_set('error_reporting', E_ALL);
       // $mpdf=new mPDF();        
     $this->m_pdf->pdf=new mPDF('','A4','','15',15,15,15,15,15,15); 
     $footer = '<div style="font-size:7.5px;text-align:center;height:10px;" ></div>';
  $this->m_pdf->pdf->SetHTMLFooter($footer);
foreach($emplc as $val1){
$this->data['val'] = $val1;
     $this->m_pdf->pdf->AddPage();
   $htmlc =  $this->load->view($this->view_dir.'reports/employee_leave_list_pdf',$this->data,true);
      $html = mb_convert_encoding($htmlc, 'UTF-8', 'UTF-8'); 
    $this->m_pdf->pdf->WriteHTML($html);
  }
 
   
    //print_r($html);exit;   

   
$pdfFilePath = "employee_leave.pdf";
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "D");

}elseif($_POST['rtype']=='exl'){



$this->load->view($this->view_dir.'reports/employee_leave_list_excel',$this->data);  


}



   }*/
   
    public function view_emp_leves_list(){
   $emplc = $this->leave_model->get_emp_leave_list_new($_POST);
    //echo "<pre>";
   //print_r($emplc);exit;
   $this->data['empl'] = $emplc;
   $this->data['styp'] = $_POST['select_dur'];
   if($_POST['select_dur']=='monthly'){
$this->data['smonth'] = $_POST['attend_date'];
}elseif($_POST['select_dur']=='yer'){
$this->data['smonth'] = $_POST['frm_attend_datey']." - ".$_POST['to_attend_datey'];
    }
 if($_POST['rtype']=='pdf'){
       //$html = "kkk";
       $this->load->library('M_pdf');
 ob_clean();

 //ini_set('error_reporting', E_ALL);
       // $mpdf=new mPDF();        
     $this->m_pdf->pdf=new mPDF('','A4','','15',15,15,15,15,15,15); 
     $footer = '<div style="font-size:7.5px;text-align:center;height:10px;" ></div>';
  $this->m_pdf->pdf->SetHTMLFooter($footer);
foreach($emplc as $val1){
$this->data['val'] = $val1;
     $this->m_pdf->pdf->AddPage();
   $htmlc =  $this->load->view($this->view_dir.'reports/employee_leave_list_pdf',$this->data,true);
      $html = mb_convert_encoding($htmlc, 'UTF-8', 'UTF-8'); 
      //echo $html;
    $this->m_pdf->pdf->WriteHTML($html);
  }
 
   
    //print_r($html);exit;   

   
$pdfFilePath = "employee_leave.pdf";
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "D");

}elseif($_POST['rtype']=='exl'){



$this->load->view($this->view_dir.'reports/employee_leave_list_excel',$this->data);  


}



   }
    public function carry_forward_employee_leave(){
         $this->load->view('header',$this->data); 
    
        $this->load->view($this->view_dir.'carry_forward_employee_leave',$this->data);
        $this->load->view('footer');
    }
  public function get_emp_carry_leave(){
         $txt['post_data'] = $_POST['post_data'];
         $txt['leave_typ'] = $_POST['lt'];
         $txt['acd_year']= $_POST['y'];
        $emp=$this->leave_model->get_employee_crry_list($txt);
//print_r($emp);
        echo "<script>$('#checkAllt').click(function(){
    $('.empidt').prop('checked', $(this).prop('checked'));
});</script><div  id='etable'><div class='emp-list'><input type='text' id='myInput' onkeyup='myFunction()' placeholder='Search ..' title='Type in a name'><table id='myTable' class='table'>";
        echo "<th><input type='checkbox' name='checkall' id='checkAllt' value='1' /></th><th>Emp Code</th><th>Emp Name</th><th>College</th><th>Department</th><th>Designation</th><th>Leave</th><th>Allocated</th><th>Used</th><th>Balance</th>";
        foreach($emp as $val){
            // $lv = $this->leave_model->get_emp_leaves($val['emp_id'],$lt,$y);
            //if($lv[0]['leaves_allocated']!=''){          
            
            echo "<tr >";
            echo "<td><input type='checkbox' name='emp_id[]' class='empidt' value='".$val['emp_id']."'></td>";
            echo "<td>".$val['emp_id']."</td>";
             echo "<td>";
            if($val['gender']=='male'){echo 'Mr.';}else if($val['gender']=='female'){ echo 'Mrs.';} 
            echo $val['fname']." ".$val['lname'];
            echo "</td>";
            echo "<td>";
          echo $val['college_name'];
            echo "</td>";
              echo "<td>";
          echo $val['department_name'];
            echo "</td>";
              echo "<td>";
          echo $val['designation_name'];
            echo "</td>";
              echo "<td>";
          echo $val['leave_type'];
            echo "</td>";
              echo "<td>";
          echo $val['leaves_allocated'];
            echo "</td>";
              echo "<td>";
          echo $val['leave_used'];
            echo "</td>";
               echo "<td>";
                 echo "<input type='hidden' name='".$val['emp_id']."_".$val['leave_type']."'  value='".$val['bal']."'/>";
          echo $val['bal'];
            echo "</td>";
            echo "</tr>";
        //}
        }
       echo '</table></div><br/></div>';
    }

    function employee_carry_farward_submit(){
       // print_r($_POST);exit;

       $ss = $this->leave_model->carry_employee_leave_allocation($_POST);
       if($ss){
       $this->session->set_flashdata('message1','Leave is forwarded');
                redirect('Leave/employee_leave_allocation');
    }
    }
      public function apply_leave1(){
        
        $this->load->view('header',$this->data);
        $this->load->model('Admin_model');
         $this->data['state']= $this->Admin_model->getAllState();
         $this->data['school_list']= $this->Admin_model->getAllschool();
        
        $this->data['emp_detail']=$this->leave_model->fetchEmployeeData($this->session->userdata("name"));
        $this->data['leave']=$this->leave_model->getAllLeaveType();
        $this->data['emp_leave_list'] = $this->leave_model->get_employee_leave_type($this->session->userdata("name"));  
        $this->load->view($this->view_dir.'leave_form1',$this->data);
        $this->load->view('footer');
      
    }
	
	public function allocate_faculty_for_other_tasks(){
        
         $this->load->view('header',$this->data);
         $this->load->model('Admin_model');
		 $this->load->model('Timetable_model');
         $this->data['state']= $this->Admin_model->getAllState();
         $this->data['school_list']= $this->Admin_model->getAllschool();
		 $this->data['other_task']= $this->Admin_model->getAlltask();
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
        $this->load->view($this->view_dir.'other_task_form',$this->data);
        $this->load->view('footer_new');
      
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	  public function add_task(){
       
           

	$ad = date('d-m-Y',strtotime($_POST['leave_applied_from_date']));
	$y = date('Y',strtotime($_POST['leave_applied_from_date'])); 
	 $ct = substr($y,0,2) ;
	  if($ct == '19'){
		 $this->session->set_flashdata('message1','Allocated Date is not in proper format.');
         redirect('Leave/allocate_faculty_for_other_tasks');    
	  }else{
        $empary = array();
        $ldur = $_POST['leave_duration'];
      if(($ldur =='full-day') || ($ldur=='half-day') || ($ldur=='hrs')){ 
        if(!empty($_POST)){
            $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $res=$this->leave_model->addtask_to_employee($_POST);
        }
        if($res=1){
            $this->session->set_flashdata('message1','Allocation done successfully...');
                redirect('Leave/allocate_faculty_for_other_tasks');             
        }else{
           $this->session->set_flashdata('message1','Something went wrong .Please try again.');
                redirect('Leave/allocate_faculty_for_other_tasks'); 
        }
        }else{
          $this->session->set_flashdata('message1','Please Select valid date and duration.');
                redirect('Leave/allocate_faculty_for_other_tasks');
      }

       }
        
    }
	
	 
    public function enable_request()
    {
                     
        $id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y");                                
        $where=array("id"=>$id);
			
         
        $this->db->where($where);
        
        if($this->db->update('emp_other_task_list', $update_array))
        {
            redirect(base_url('Leave/allocated_task_list'));
        }
        else
        {
            redirect(base_url('Leave/allocated_task_list'));
        }  
        
    }
	
	public function disable_request()
    {
                     
        $id=$this->uri->segment(3);   
        $update_array=array("status"=>"N");                                
        $where=array("id"=>$id);
			
         
        $this->db->where($where);
        
        if($this->db->update('emp_other_task_list', $update_array))
        {
            redirect(base_url('Leave/allocated_task_list'));
        }
        else
        {
            redirect(base_url('Leave/allocated_task_list'));
        }  
        
    }
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
  public function attendance_employee($offSet=0){
     $this->load->view('header',$this->data); 
     $limit = 5;// set records per page
        if(isset($_REQUEST['per_page']) && !empty($_REQUEST['per_page'])){
            $offSet=$_REQUEST['per_page'];
        }
        //Copy data from device log to System table//
        $check=$this->Admin_model->check_todays();
        
        if(empty($check)){
            $res=$this->Admin_model->backupDeviceLogDaily();
        }
        
        //end of copy//
    //  $cnt=$this->Admin_model->getAttendance_AllDefault1(); // for getting count only
        $total=count($cnt);
        $total_pages = ceil($total/$limit);
    //  echo $total_pages; 
        $this->load->library('pagination');
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['enable_query_strings']=TRUE;
        $config['page_query_string']=TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = base_url().'admin/attendance_all?';
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        $this->data['paginglinks'] = $this->pagination->create_links();
        $config['offSet'] = $offSet;        
        $total=ceil($rows/$limit);
        $this->data['school_list']= $this->Admin_model->getAllschool();  
         $this->data['dept_list']= $this->Admin_model->getAllDepartments();      
         $this->data['desig_list']= $this->Admin_model->getAllDesignations();
       //  $this->data['attendance']= $this->Admin_model->getAttendance_AllDefault($offSet,$limit); // for fetching result of punched
        $this->data['emp_list']= $this->Admin_model->getEmployees1('Y');
        $this->data['vemp_list']= $this->Admin_model->getVisitingEmployees1('Y');
     $this->load->view($this->view_dir.'display_attendance',$this->data);
     $this->load->view('footer');    
    }
	
	
	public function view_attendance($offSet=0){
		 
 ini_set('memory_limit', '-1');
//ini_set('error_reporting', E_ALL);
      
        $this->load->view('header',$this->data);
        $limit = 70;// set records per page
        
            $this->data['school_list']= $this->Admin_model->getAllschool();  
            $this->data['dept_list']= $this->Admin_model->getAllDepartments();       
            $this->data['desig_list']= $this->Admin_model->getAllDesignations();
            $this->data['emp_list']= $this->Admin_model->getEmployees();
            //print_r($this->data['emp_list']);
            //exit();
        if(isset($_REQUEST['per_page'])&& !empty($_REQUEST['per_page'])){
            $offSet=$_REQUEST['per_page'];        
        }  
		         
        if(!empty($_POST)){
            //print_r($_POST);
            //exit();
            $temp = ['attend_date' => $_POST['attend_date'],
                     'emp_school'=> $_POST['emp_school'],
                      'department'=>$_POST['department'],
                      'empsid'=>$_POST['empsid']      
                     ];
            $this->session->set_userdata($temp);
        }
		
        $data['attend_date']=$this->session->userdata("attend_date");
        $data['emp_school']=$this->session->userdata("emp_school");
        $data['department']=$this->session->userdata("department");
        $data['empsid']=$this->session->userdata("empsid");
        //print_r($_POST['empsid']);
        $emplist = $_POST['empsid'];    
        //$emplist = array('110038','110048','110052','110070','110071','110073','110074','110075','110077','110078','110083','110087','110088','110096','110109','110111','110116','110131','110137','110139','110140','110145','110156','110170','110192','110193','110194','110196','110223','110232','110263','110265','110266','110283','110299','110303','110311','110313','110318','110330','110332','110333','110337','110338','110341','110342','110343','110344','110346','110347','110349','110350','110351','110352','110353','110354','110356','110357','110358','110360','110363','110364','110365','110366','110368','110369','110370','110371','110372','110373','110374','110378','110379','110380','110381','110382','210170','210171','210173','210174','210176','210177','210178','210179','210180','210181','210182','210184','210185','210186','210187','210188','210189','210190','210191','210192','210193','210194','210197','210198','210199','210200','210201','210202','210203','210205','210207','210208','210209','210210','210212','210213','210214','210215','210216','210217','210218','210219','210220','210221','210222','210223','210224','210226','210228','210229','210230','210231','210232','210233','210234','210235','210236','210237','210238','210240','210241','210243','210245','210247','210248','210250','210251','210252','210255','210261','210263','210265','210266','210267','210269','210271','210273','210275','210277','210278','210279','210280','210281','210282','210283','210284','210285','210287','210288','210289','210290','210293','210301','210302','210303','210304','210305','210306','210308','210309','210310','210311','210312','210314','210315','210316','210317','210318','210319','210321','210322','210323','210325','210326','210327','210328','210329','210330','210331','210332','210333','210334','210335','210336','210337','210338','210339','210340','210341','210342','210343','210344','210345','210346','210347','210348','210349','210350','210351','210352','210353','210354','210355','210356','210357','210358','210359','210360','210361','210362','210363','210364','210365','210366','210367','210368','210369','210370','210371');
        //for all department and under that all schools attendance
         if(empty($data['emp_school']) && empty($data['department'])){
         //echo "inside date";
              $this->data['attend_date']=$data['attend_date'];
              //first check whether the attandance available in punching backup table
              $check_dt=$this->Admin_model->checkAvailableAttendance($this->data['attend_date']);
             
              if(!empty($check_dt)){
                 //get distinct schoolfrom employee master table for displaying attendance of all school
              $all_school=$this->Admin_model->getAllDistinctSchool();//first get all school
              $this->data['all_school']=$all_school;
              foreach($all_school as $key=>$val){
                  $school[]=$all_school[$key]['emp_school'];
              }
             
                if(!empty($emplist)){
					
                for($i=0;$i<count($school);$i++){
                $all_emp[$school[$i]]=$this->Admin_model->getEmpForAllSchool($school[$i],$data['attend_date']); //get all employee school wise 
                  }
				  
              $emplist1=array();
             
			  foreach($emplist as $val){
                  $emplist1[]['emp_id'] = $val;
              }
			  
              asort($emplist1);
              $this->data['all_emp']=$emplist1;

              foreach($emplist as $key=>$val){
               //echo $val;
                 $attendance[$val]=$this->Admin_model->getAttendanceForAllSchool($val,$data['attend_date']);
                 // print_r($attendance[$val]);
              }   
                
            }else{ //if(!empty($emplist))
				
                for($i=0;$i<count($school);$i++){
                $all_emp[$school[$i]]=$this->Admin_model->getEmpForAllSchool($school[$i],$data['attend_date']); //get all employee school wise 
                 }
            
             $employeelist=array();    
			      
              foreach($all_emp as $em){
                  
				  foreach($em as $key=>$val){
                    $employeelist[]=array_merge($em[$key]);                                 
                  }
				  
              }
               
			  asort($employeelist);//for sorting according to employee id ascending 
       
            $this->data['all_emp']=$employeelist; 
           //print_r($employeelist) ;
           //exit;          
              foreach($all_emp as $em){            
              foreach($em as $key=>$val){            
                 $attendance[$em[$key]['emp_id']]=$this->Admin_model->getAttendanceForAllSchool($em[$key]['emp_id'],$data['attend_date']);
                }   
              }  
			  
            }  // if(!empty($emplist))
			
			        
//print_r($attendance);     
//exit; 
              $this->data['attendance']=$attendance;  
              }elseif(empty($check_dt)){
               $this->data['all_emp']="";
               $this->data['attendance']="";
              }

            //  if($_POST['downpdf'] == 'Download To PDF')
     //{  
      //print_r($this->data);
     // exit;
    $this->inout_table_exporttopdf($this->data);
    // }
          //  $this->load->view($this->view_dir.'display_attendance',$this->data);  
            
        }elseif(!empty($data['emp_school'])&& empty($data['department'])){ //for all deprtment under only selected School
        
             $this->data['attend_date']=$data['attend_date'];
              //first check whether the attandance available in punching backup table
              $check_dt=$this->Admin_model->checkAvailableAttendance($this->data['attend_date']);
             
              if(!empty($check_dt)){
                 //get distinct school from employee master table for displaying attendance of selected school
              if(!empty($emplist)){
                  
$emplist1=array();
              foreach($emplist as $val){
                  $emplist1[]['emp_id'] = $val;
              }
              $all_emp= $emplist1;
                $this->data['all_emp']=$emplist1;
                
              }else{
             $all_emp=$this->Admin_model->getAllEmployeeUnderSchool($data['emp_school'],$data['attend_date']);//first get all employee under selected school
              $this->data['all_emp']=$all_emp;
              }
         for($i=0;$i<count($all_emp);$i++){
                 $attendance[$all_emp[$i]['emp_id']]=$this->Admin_model->getAttendanceForAllSchool($all_emp[$i]['emp_id'],$data['attend_date']);
                  
              }   
        /* echo"<pre>";print_r($attendance);echo"</pre>";
             die(); */
                $this->data['attendance']=$attendance;  
              }elseif(empty($check_dt)){
                                 $this->data['all_emp']="";
                                $this->data['attendance']="";
              }
            //  if($_POST['downpdf'] == 'Download To PDF')
   //  {  
    $this->inout_table_exporttopdf($this->data);
   //  }
       //     $this->load->view($this->view_dir.'display_attendance',$this->data);        
            
        }else{ 
             $this->data['attend_date']=$data['attend_date'];
              //first check whether the attandance available in punching backup table
              $check_dt=$this->Admin_model->checkAvailableAttendance($this->data['attend_date']);
             
              if(!empty($check_dt)){
            
           // if(!empty($emplist)){
                  
//$emplist1=array();
          //    foreach($emplist as $val){
            //      $emplist1[]['emp_id'] = $val;
            //  }
           //   $all_emp = $emplist1;
           // }else{
            $all_emp=$this->Admin_model->getAttendance_All1($data);  
           // }
        $total=count($all_emp);
        $total_pages = ceil($total/$limit);
        $this->load->library('pagination');
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['enable_query_strings']=TRUE;
        $config['page_query_string']=TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = base_url().'admin/view_attendance?';
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        $this->data['paginglinks'] = $this->pagination->create_links();
        $config['offSet'] = $offSet;        
        $total=ceil($rows/$limit);
          // print_r($all_emp);
          // exit;
            $this->data['attend_date']=$data['attend_date'];
            $this->data['all_emp']=$all_emp;
            $this->data['attendance']= $this->Admin_model->getAttendance_All($data,$all_emp,$offSet,$limit);
          //  echo "<pre>";
        //print_r($this->data['attendance']);
        //exit;
           // if($_POST['downpdf'] == 'Download To PDF')
    // {  
    $this->inout_table_exporttopdf($this->data);
    // }
      //  $this->load->view($this->view_dir.'display_attendance',$this->data);        
        }elseif(empty($check_dt)){
                                 $this->data['all_emp']="";
                                $this->data['attendance']="";
        //                        if($_POST['downpdf'] == 'Download To PDF')
   //  {  
    $this->inout_table_exporttopdf($this->data);
  //   }
      //  $this->load->view($this->view_dir.'display_attendance',$this->data);                        
              }
      
            } 
         
       $this->load->view('footer');  
    }
    
	  public function inout_table_exporttopdf($data){
      //print_r($data);
      //exit;
ini_set('memory_limit', '-1');
      $html =  $this->load->view($this->view_dir.'inout_pdf_export',$data,true); // render the view into HTML
//exit();
 $this->load->library('M_pdf');
 ob_clean();
 //ini_set('error_reporting', E_ALL);
        $mpdf=new mPDF();
        
      $this->m_pdf->pdf=new mPDF('L','A4-L','','',5,10,5,2,5,5);

   $footer = '<div style="font-size:7.5px;text-align:center;" >P - Present Days | S - Sunday | H - Holiday | LWP - Leave Without Pay | OD - Outdoor Duty | Lv - Leave | CO - C-OFF | CL - Casual leave | SL - Sick leave  |  EL - Earned leave  | ML - Medical leave | VL - Vacation leave | Leave(*) - Leave+LWP | SP - Special Case | JD - Joining Day | BL - Bus Late | SD - Special Day </div>';
  $this->m_pdf->pdf->SetHTMLFooter($footer);
  
  $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
    
    $this->m_pdf->pdf->WriteHTML($html);
$pdfFilePath = "MonthInOutTimeReport_".date('F_Y',strtotime($data['attend_date'])).".pdf";
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "D");  
    }
    
	public function getEmpListbyDepartmentSchool_attendance(){
        $school=$_REQUEST['school'];
        $department=$_REQUEST['department'];
        $this->data['emp_list']=$this->Admin_model->getSchoolDepartmentWiseEmployeeList($school,$department);
        $emp=$this->data['emp_list'];
        if(!empty($emp)){
    
    foreach($emp as $key=>$val ){
         echo '<li>
                    <input type="checkbox" name="empsid[]" id="'.$emp[$key]['emp_id'].'" onclick="onclick_checkbox_emp('.$emp[$key]['emp_id'].');" value="'.$emp[$key]['emp_id'].'" /> '.$emp[$key]['emp_id'].' - '.$emp[$key]['fname'].' '.$emp[$key]['lname'].' </li>';
       }
}else{
    echo "<li >No employees </li>";
}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	


public function work_from_home(){
	    $this->load->view('header',$this->data);   
		$this->data['emp_detail']=$this->leave_model->fetchEmployeeData($this->session->userdata("name")); 
        $this->data['leave_details']= $this->leave_model->get_leave_details();                                        
        $this->load->view($this->view_dir.'work_from_home',$this->data);
        $this->load->view('footer');
}

public function add_work_from_home(){
	
	echo $emp_id=$_REQUEST['emp_id'];
	echo '<br>';
	 $leave_applied_from_date=$_REQUEST['leave_applied_from_date'].' 10:00:00';
	 $from_date=date("Y-m-d h:i:s",strtotime($leave_applied_from_date));
	echo '<br>';
	echo $leave_applied_to_date=$_REQUEST['leave_applied_to_date'].' 05:00:00';
	$to_date=date("Y-m-d h:i:s",strtotime($leave_applied_to_date));
	echo '<br>';
	echo $reason=$_REQUEST['reason'];
	echo '<br>';
	
	
  $this->leave_model->add_work_from_home($emp_id,$from_date,$to_date,$reason);
}

  
  public function work_ajax_list(){
	    $emp_id= $this->session->userdata("name");
	    $date='';//$_POST['date'];
		//$type_param=$_POST['type_param'];
		$list = $this->leave_model->get_datatables($date,$emp_id);
		//print_r($list);exit();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			$row[] = $no;
		//	$row[] = '<a href="'.base_url().'Enquiry/New_Enquiry/'.$customers->enquiry_id.'/'.$customers->enquiry_no.'">'.$customers->enquiry_no.'</a>';
			$row[] = $customers->UserId;
			$row[] = $customers->Intime;
			$row[] = $customers->Outtime;
			$row[] = $customers->reason;
			/*$row[] = $customers->altarnet_mobile;*/
			/*$row[] = $customers->email_id;*/
			if($customers->approve_status=="N"){
				$status="Pending";
			}else{
				$status="approve";
			}
			$row[] = $status;
			
			/*$row[] = $customers->form_taken;*/
			
			/*$row[] = $customers->scholarship_allowed;*/
		//	$row[] = $customers->scholarship_status;
			
			
			
			//if($customers->form_no!=''){
			
			//}else{
			//$row[] ='-';	
			//}
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->leave_model->count_all(),
						"recordsFiltered" => $this->leave_model->count_filtered($date,$emp_id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
  }
  
  
    function get_time_details($app_id='')
  {

	//echo $app_id;
	  $query="select * from leave_applicant_list where lid='$app_id'";
	  $row=$this->db->query($query);
	  $data=$row->result_array();
	  echo json_encode($data);
	  
  }
  
 	function update_time(){
		$app_id=$_POST['app_id'];
		$fdate=$_POST['fdate'];
		$tdate=$_POST['tdate'];

		/*$date1 = new Datetime($fdate);
		$date2 = new Datetime($tdate);
		$days  = $date1->diff($date2)->format('%a');
		$days++;*/
         $tdays=$_POST['tdays'];
          $data['no_days']=$tdays;	  
		$data['applied_from_date']=$fdate;
		$data['applied_to_date']=$tdate;
		
		
		$get_details=$this->db->get_where('leave_applicant_list',array('lid'=>$app_id))->row();
		
		$ar_time=$get_details->arrival_time;
		$d_time=$get_details->departure_time;
		
		$ah=date('H',strtotime($ar_time));
		$am=date('i',strtotime($ar_time));
		$as=date('s',strtotime($ar_time));
		
		$dh=date('H',strtotime($d_time));
		$dm=date('i',strtotime($d_time));
		$ds=date('s',strtotime($d_time));
		
		if($ar_time !='0000-00-00'){
			//echo "$fdate $ah $am $as";
			//exit;
		 $data['departure_time']=date('Y-m-d H:i:s',strtotime("$fdate $ah:$am:$as"));
		 $data['arrival_time']=date('Y-m-d H:i:s',strtotime("$fdate $dh:$dm:$ds"));
		}
		
		
		//$f=
		//$data['departure_time']=$tdate;
		//$data['arrival_time']=$tdate;
		
		$this->db->where('lid', $app_id);
		$this->db->update('leave_applicant_list',$data );
		$data=$this->db->affected_rows();            
		echo json_encode($data);
        } 
  
  
  
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
}
?>