<?php
ini_set('max_input_vars', 3000);



defined('BASEPATH') OR exit('No direct script access allowed');
//ini_set('error_reporting', E_ALL);
class Admin extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Admin_model";
    var $model;
    var $view_dir='Admin/';

    
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
		
        $this->load->library('excel');
        $this->load->helper("url");     
        $this->load->library('form_validation');
        $this->load->library('pagination');
         if(!$this->session->has_userdata('uid'))
        redirect('login');  
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
        $this->load->library('Awssdk');
        $this->bucket_name =  'erp-asset';
		/*if($this->session->userdata("role_id")==1 ){
		}else{
			redirect('home');
		}*/
		
            
      //  $this->data['method_privileges']=$this->retrieve_privileges($this->uri->segment(2));
    }
    
    public function index()
    {
        global $model;
        $this->load->view('header',$this->data);    
        //$this->data['campus_details']= $this->campus_model->get_campus_details();                        
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
        $this->data['campus_details']=$this->campus_model->get_campus_details();                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    
    
    public function employee_list_old($offSet=0)
    {
        $this->load->view('header',$this->data);        
     /*  $total= $this->Admin_model->getAllEmployee();
    //  exit;
        //$total_pages = ceil($total/$limit);
        //echo $total_pages; 
        $config = array();
        $config["base_url"] = base_url()."admin/employee_list/";
        //$total_row = $this->pagination_model->record_count();
        $config["total_rows"] = $total;
        $config["per_page"] = 10;
        $config['use_page_numbers'] = False;
        $config['num_links'] = $total;
        $config['cur_tag_open'] = '&nbsp;<a class="current">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        
        $this->pagination->initialize($config);
        if($this->uri->segment(3)){
        $page = ($this->uri->segment(3)) ;
          }
        else{
               $page = 0;
        } */
      //echo $page;
        //$this->data['emp_list']= $this->Admin_model->getEmployees($config["per_page"], $page);
        $this->data['emp_list_act']= $this->Admin_model->getEmployees1('Y');
		//echo $this->db->last_query();
		//echo "<pre>";
		//print_r($this->data['emp_list_act']);
		//exit;
        $this->data['emp_list_inact']= $this->Admin_model->getEmployees1('N');
        $this->data['emp_list_reg']= $this->Admin_model->getRegEmployees();
        //print_r($this->data['emp_list']);
         $str_links = $this->pagination->create_links();
        //print_r($str_links);
        $this->data["links"] = $str_links;
        $this->data["current_page"]=$page;
        
        
        $this->load->view($this->view_dir.'employee_list',$this->data);
        $this->load->view('footer');
    }
	
	
     public function employee_list($offset = 0)
    {
		if($this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==1 || $this->session->userdata("role_id") == 48 || $this->session->userdata("role_id")==33){
			//echo 1;exit;
		}else{
			redirect('home');
		}
        $this->load->view('header', $this->data);
        
        $search_term = $this->input->get('search');
        $department_id = $this->input->get('department');
        $designation_id = $this->input->get('designation');
        $staff_type = $this->input->get('staff_type');
    
        $departments = $this->Admin_model->getDepartments(); 
        $designations = $this->Admin_model->getDesignations();
        $staff_types = $this->Admin_model->getEmpType();


        if (!empty($search_term) || !empty($department_id) || !empty($designation_id) || !empty($search_term) || !empty($staff_type)) {

            $emp_list_act = $this->Admin_model->getEmployees1(-1, 0, $search_term, $department_id, $designation_id,$staff_type);
            $total = count($emp_list_act);
        } else {
        
            $per_page = $this->input->post('per_page') ? $this->input->post('per_page') : 10;
            $total = $this->Admin_model->countAllEmployees($search_term);
            $config = array(
                "base_url" => base_url() . "admin/employee_list/",
                "total_rows" => $total,
                "per_page" => $per_page,
                "use_page_numbers" => TRUE,
                "uri_segment" => 3
            );
            $this->pagination->initialize($config);
            $page = $offset == 0 ? 1 : $offset;
            
           
            $emp_list_act = $this->Admin_model->getEmployees1($config["per_page"], ($page - 1) * $config["per_page"]);
        }
    
        $this->data['departments'] = $departments;
        $this->data['designations'] = $designations;
        $this->data['staff_types'] = $staff_types;
        $this->data['search_term'] = $search_term;
        $this->data['department_id'] = $department_id;
        $this->data['designation_id'] = $designation_id;
        $this->data['staff_type'] = $staff_type;
        $this->data['emp_list_act'] = $emp_list_act;
    
      
        if (empty($department_id) && empty($designation_id) && empty($search_term)) {
            $this->data["links"] = $this->pagination->create_links();
            $this->data["current_page"] = $page;
        }
        
        $this->load->view($this->view_dir . 'employee_list', $this->data);
        $this->load->view('footer');
    }
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   public function employee_listInact($offset = 0)
    {
        $this->load->view('header', $this->data);
    
        $search_term = $this->input->get('search');
        $department_id = $this->input->get('department');
        $designation_id = $this->input->get('designation');
        $staff_type = $this->input->get('staff_type');
    
        $departments = $this->Admin_model->getDepartments(); 
        $designations = $this->Admin_model->getDesignations();
        $staff_types = $this->Admin_model->getEmpType();
    
        if (!empty($search_term) || !empty($department_id) || !empty($designation_id) || !empty($search_term) || !empty($staff_type)) {
            $emp_list_inact = $this->Admin_model->getEmployeesN(-1, 0, $search_term, $department_id, $designation_id, $staff_type);
            $total = count($emp_list_inact);
        } else {
            $per_page = $this->input->post('per_page') ? $this->input->post('per_page') : 10;
            $total = $this->Admin_model->countAllEmployees($search_term, false); // Pass false for inactive employees
            $config = array(
                "base_url" => base_url() . "admin/employee_listInact/",
                "total_rows" => $total,
                "per_page" => $per_page,
                "use_page_numbers" => TRUE,
                "uri_segment" => 3
            );
            $this->pagination->initialize($config);
            $page = $offset == 0 ? 1 : $offset;
            $emp_list_inact = $this->Admin_model->getEmployeesN($config["per_page"], ($page - 1) * $config["per_page"]);
        }
    
        $this->data['departments'] = $departments;
        $this->data['designations'] = $designations;
        $this->data['staff_types'] = $staff_types;
        $this->data['search_term'] = $search_term;
        $this->data['department_id'] = $department_id;
        $this->data['designation_id'] = $designation_id;
        $this->data['staff_type'] = $staff_type;
        $this->data['emp_list_inact'] = $emp_list_inact;
    
        if (empty($department_id) && empty($designation_id) && empty($search_term)) {
            $this->data["links"] = $this->pagination->create_links();
            $this->data["current_page"] = $page;
        }
    
        $this->load->view($this->view_dir . 'inact_emp', $this->data);
        $this->load->view('footer');
    }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function employee_listReg($offset = 0)
{
    $this->load->view('header', $this->data);
    
    $search_term = $this->input->get('search');
    $department_id = $this->input->get('department');
    $designation_id = $this->input->get('designation');
    $staff_type = $this->input->get('staff_type');

    $departments = $this->Admin_model->getDepartments(); 
    $designations = $this->Admin_model->getDesignations();
    $staff_types = $this->Admin_model->getEmpType();

    if (!empty($search_term) || !empty($department_id) || !empty($designation_id) || !empty($staff_type)) {
      
        $emp_list_reg = $this->Admin_model->getRegEmployees(-1, 0, $search_term, $department_id, $designation_id, $staff_type);
        $total = count($emp_list_reg);
    } else {
        // If no filters applied, get all employees
        $per_page = $this->input->post('per_page') ? $this->input->post('per_page') : 10;
        $total = $this->Admin_model->countAllEmployees($search_term);

        // Pagination configuration
        $config = array(
            "base_url" => base_url() . "admin/employee_listReg/",
            "total_rows" => $total,
            "per_page" => $per_page,
            "use_page_numbers" => TRUE,
            "uri_segment" => 3
        );
        $this->pagination->initialize($config);
        $page = $offset == 0 ? 1 : $offset;
   
        $emp_list_reg = $this->Admin_model->getRegEmployees($config["per_page"], ($page - 1) * $config["per_page"]);
    }

   
    $this->data['departments'] = $departments;
    $this->data['designations'] = $designations;
    $this->data['staff_types'] = $staff_types;
    $this->data['search_term'] = $search_term;
    $this->data['department_id'] = $department_id;
    $this->data['designation_id'] = $designation_id;
    $this->data['staff_type'] = $staff_type;
    $this->data['emp_list_reg'] = $emp_list_reg;

    if (empty($department_id) && empty($designation_id) && empty($search_term)) {
        $this->data["links"] = $this->pagination->create_links();
        $this->data["current_page"] = $page;
    }
    
    // Load views
    $this->load->view($this->view_dir . 'employee_listReg', $this->data);
    $this->load->view('footer');
}


   
   
   
	 public function create_employee()
    {

//
         $this->load->view('header',$this->data);
		
        // $this->data['org_list']= $this->Admin_model->getAllOrganizations();       
         $this->data['school_list']= $this->Admin_model->getAllschool();         
         $this->data['bank_list']= $this->Admin_model->getAllBank();         
         $this->data['shift_list']= $this->Admin_model->getAllShift();       
         $this->data['dept_list']= $this->Admin_model->getAllDepartments();      
         $this->data['desig_list']= $this->Admin_model->getAllDesignations();
         $this->data['emp_cat']= $this->Admin_model->getAllEmpCategory();
         $this->data['state']= $this->Admin_model->getAllState();
         $this->data['role_list']= $this->Admin_model->get_emp_roles();
         $this->data['knowlegeplist']= $this->Admin_model->get_knowledge_partner_list();
         //$this->load->model("Admission_model"); 
        $this->data['category']= $this->Admin_model->getcategorylist();
$_REQUEST=$_GET;





       if(!empty($_REQUEST['id']) && !empty($_REQUEST['status'])){  //for update
       //echo $_REQUEST['id'];
      
       $this->data['update_flg']=$_REQUEST['flag'];
        $this->data['emp']= $this->Admin_model->getEmployeeById($_REQUEST['id'],$_REQUEST['status']);
		
          $this->data['emp_pre_jdet']= $this->Admin_model->getEmployeePrejobDetails($_REQUEST['id']);
		  
       }
/* else{
    echo "direct";
}     */  
         $this->load->view($this->view_dir.'create_employee',$this->data);
		 
		 
		 
        $this->load->view('footer');
    }
    public function getStatewiseCity(){
        $id=$_REQUEST['state_id'];
         if(isset($_REQUEST['state_id']))
       {
          $this->data['city_list']=$this->Admin_model->getStateCity($id);
          /* print_r($this->data['city_list']);
          die(); */
          $this->load->view($this->view_dir.'state_wise_city',$this->data);
       }
    }
    public function getdepartmentByschool(){
        $id=$_REQUEST['school_id'];
       $department= $_REQUEST['department'];
         if(isset($_REQUEST['school_id']))
       {
          $deptBYschool_list=$this->Admin_model->getdepartmentByschool($id);
		  
		  
		  //schoolwise department
          //schoolwise =>related department wise employee list
         // $this->data['emp_list']=$this->Admin_model->getSchoolDepartmentWiseEmployeeList($id,$this->data['deptBYschool_list']);
       //   $this->load->view($this->view_dir.'school_wise_department',$this->data);
	   if(!empty($deptBYschool_list)){
	echo "<option  value='' >Select Department </option>";
	foreach($deptBYschool_list as $ec ){
		
		if($department==$ec['department_id']){
			  $sel='selected="selected"';
		}else{
			  $sel='';
		}
		
	echo "<option  value=".$ec['department_id']."  $sel>".$ec['department_name']."</option>";
	}
	
}else{
	echo "<option  value='' >Select Department </option>";
}

       }
    }
    public function getEmpListDepartmentSchool(){
        $school=$_REQUEST['school'];
        $department=$_REQUEST['department'];
        $this->data['emp_list']=$this->Admin_model->getSchoolDepartmentWiseEmployeeList($school,$department);
        $emp=$this->data['emp_list'];
        if(!empty($emp)){
    echo "<option  value='' >Select Reporting Person </option>";
    foreach($emp as $key=>$val ){
    echo "<option  value=".$emp[$key]['emp_id'].">".$emp[$key]['fname']." ".$emp[$key]['mname']." ".$emp[$key]['lname']."</option>";
    }
}else{
    echo "<option  value='' >Select Reporting Person</option>";
}

    }
    public function getEmpListDepartmentSchoolForLeaveallocation(){
        $school=$_REQUEST['school'];
        $department=$_REQUEST['department'];
        $this->data['emp_list']=$this->Admin_model->getEmployeeListForLeaveAllocation($school,$department);
        $emp=$this->data['emp_list'];
        if(!empty($emp)){
    echo "<option  value='' >Select Employee </option>";
    foreach($emp as $key=>$val ){
    echo "<option  value=".$emp[$key]['emp_id'].">".$emp[$key]['fname']." ".$emp[$key]['mname']." ".$emp[$key]['lname']."</option>";
    }
}else{
    echo "<option  value='' >Select Employee</option>";
}

    }
    //function for staff leave alternative adding
    public function getEmpListDepartmentSchoolforLeave(){
        $school=$_REQUEST['school'];
        $department=$_REQUEST['department'];
        $frmdt= $_REQUEST['fromdt'];//leave from date
        $todt=$_REQUEST['todt'];//leave to date
        $noday=$_REQUEST['nd'];//no of days
       if($todt ==''){
           $todt = $frmdt;
       }
        //echo $frmdt.'---'.$todt;exit;
        $this->data['emp_list']=$this->Admin_model->getSchoolDepartmentWiseEmployeeList($school,$department,$this->session->userdata("name"));
        $emp=$this->data['emp_list'];
        if(!empty($emp)){
            echo"<thead>
    <th>Select</th>
      <th>Staff Id</th>
      <th>Name</th>
     
      <th>From Date</th>
      <th>To Date</th>
      <th style='width:50px;'>No.Of.Days</th>
        </thead>";
        $od = "lt";
        $begin = new DateTime($frmdt);
        if($todt != ''){
 $end = new DateTime($todt.' +1 day');
        }else{
        $end = new DateTime($frmdt.' +1 day');
    }
$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
            foreach($emp as $key=>$val ){
    echo"<tr><td><input type='checkbox' id='".$emp[$key]['emp_id']."' value='".$emp[$key]['emp_id']."'  onclick='if (this.checked) { onCheck(".$emp[$key]['emp_id'].") } else { onUnCheck(".$emp[$key]['emp_id'].") }'  name='ch[]'></td>
    <td>".$emp[$key]['emp_id']."</td><td>".$emp[$key]['fname']." ".$emp[$key]['mname']." ".$emp[$key]['lname']."</td>";
    echo '<td><select style="width:100%" name="fromdt[]" id="fromdt'.$emp[$key]['emp_id'].'" disabled="true" >';
    if($frmdt==$todt){
        //echo '<option value="01-02-2019">Select</option>';
    }else{
    echo '<option value="">Select</option>';
    }
foreach($daterange as $date){
    echo '<option value="'.$date->format("d-m-Y").'" >'.$date->format("d-m-Y").'</option>';
}
    echo '</select></td>';
    echo '<td><select style="width:100%" onchange="get_datet('.$emp[$key]['emp_id'].','."'".$od."'".');" disabled="true" name="todt[]" id="todt'.$emp[$key]['emp_id'].'" >';
    if($frmdt==$todt){
    }else{
   echo '<option value="">Select</option>';
    }
    foreach($daterange as $date){
    echo '<option value="'.$date->format("d-m-Y").'" >'.$date->format("d-m-Y").'</option>';
}
    echo '</select></td>';
    echo "<td><input style='width:50px;' type='text' readonly value='' id='no_of_alter_days".$emp[$key]['emp_id']."' disabled='true' name='no_of_alter_days[]'></td>
    </tr>";
                }
                
}else{
     echo"<tr><td colspan='6'>No Employee Availabe in this department</td></tr>";;
}

    }public function getEmpListDepartmentSchoolforod(){
        $school=$_REQUEST['school'];
        $department=$_REQUEST['department'];
        $frmdt=$_REQUEST['fromdt'];//od from date
        $todt=$_REQUEST['todt'];//od to date    
$lt=$_REQUEST['lt'];//od to date            
        $this->data['emp_list']=$this->Admin_model->getSchoolDepartmentWiseEmployeeList($school,$department,$this->session->userdata("name"));
        $emp=$this->data['emp_list'];
        if(!empty($emp)){
            echo"<thead>
    <th style='width:20px;'>Select</th>
      <th>Staff Id</th>
      <th>Name</th> 
      <th>From Date</th>
      <th>To Date</th>";
      if($lt=='hrs'){
           echo "<th>No.Of.Hrs</th>";
      }else{
      echo "<th>No.Of.Days</th>";
      }
        echo "</thead>";
         $od = "od";
         $begin = new DateTime($frmdt);
         if($todt != ''){
             $end = new DateTime($todt.' +1 day');
         }else{
        $end = new DateTime($frmdt.' +1 day');
    }
$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
            foreach($emp as $key=>$val ){
               
    echo"<tr><td><input type='checkbox' id='".$emp[$key]['emp_id']."' value='".$emp[$key]['emp_id']."' onclick='if (this.checked) { onCheckod(".$emp[$key]['emp_id'].") } else { onUnCheckod(".$emp[$key]['emp_id'].") }' name='ch[]'></td>
    <td>".$emp[$key]['emp_id']."</td>
    <td>".$emp[$key]['fname']." ".$emp[$key]['mname']." ".$emp[$key]['lname']."</td>";
    echo '<td><select  name="fromdt[]" id="fromdt'.$emp[$key]['emp_id'].'"  disabled="true">';
   if($frmdt==$todt || $lt=='hrs' ){
    }else{
   echo '<option value="">Select</option>';
    }
foreach($daterange as $date){
    echo '<option value="'.$date->format("d-m-Y").'" >'.$date->format("d-m-Y").'</option>';
}
    echo '</select></td>';
    echo '<td><select onchange="get_datet('.$emp[$key]['emp_id'].','."'".$od."'".');"  disabled="true" name="todt[]" id="todt'.$emp[$key]['emp_id'].'" >';
    if($frmdt==$todt || $lt=='hrs' ){
    }else{
    echo '<option value="">Select</option>';
    }
    foreach($daterange as $date){
    echo '<option value="'.$date->format("d-m-Y").'" >'.$date->format("d-m-Y").'</option>';
}
    echo '</select></td>';
    echo "<td><input readonly  type='text' value=''  id='no_of_alter_od_days".$emp[$key]['emp_id']."' disabled='true' name='no_of_alter_od_days[]'></td></tr>";
                }
}else{
     echo"<tr><td colspan='6'>No Employee Availabe in this department</td></tr>";;
}

    }
    /*end of function for leave alternative*/
    
    public function getshift(){
        $id=$_REQUEST['shiftid'];
        
         if(isset($_REQUEST['shiftid']))
       {
          $this->data['shift_time']=$this->Admin_model->getshifttime($id);
          $this->load->view($this->view_dir.'showtime',$this->data);
       }
    }
    public function create_holiday(){
        $this->load->view('header',$this->data);
        $this->load->view($this->view_dir.'create_holiday');
        $this->load->view('footer');
    }
    public function add_emp()
    {    /* echo"<pre>";
         print_r($_POST);
        print_r($_FILES);
        echo"</pre>"; 
        echo"******************************";
        die();  */
		ini_set('memory_limit', '2048M');
        $this->load->view('header',$this->data); 
        $picture=array();
        if(!empty($_POST)){
            
             //for profile Image
            if(!empty($_FILES['profile_img']['name'])) {
                //$original_name = remove_dot_filename($_FILES['profile_img']['name']);
                $ext = explode('.', $_FILES['profile_img']['name']);
                $filenm=$_POST['employeeID'].'-'.'profile'.'.'.$ext[1];
                // $config['upload_path'] = 'uploads/employee_profilephotos/';
                // $config['allowed_types'] = 'jpg|jpeg|png';
                // $config['overwrite']= TRUE;
                // $config['max_size']= "2048000";
                // //$config['file_name'] = $_FILES['profile_img']['name'];
                // $config['file_name'] = $filenm;
                
                // //Load upload library and initialize configuration
                // $this->load->library('upload',$config);
                // $this->upload->initialize($config);
                
                // if($this->upload->do_upload('profile_img')){
                //     $uploadData = $this->upload->data();
                //     $picture['profile_pic']=$uploadData['file_name'];
                // }else{
                //     $picture['profile_pic']="";
                // }
                
                try{
                    // $filepath = remove_dot_filename($filenm);
                    // $ext = explode('.', $filepath);
                    // $file_upload_name = clean($ext[0]). '.'. $ext[1];
                    $file_path = 'uploads/employee_profilephotos/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['profile_img']['tmp_name']);
                   
                    $picture['profile_pic'] = $filenm;
                }catch(Exception $e){
                    $picture['profile_pic'] = "";    
                }
            }else{
                //$picture = '';
                $picture['profile_pic']="";
            }

            //  *******for Resume *********
            if(!empty($_FILES['resume']['name'])){
                $original_name = remove_dot_filename($_FILES['resume']['name']);
                $ext = explode('.', $original_name);
                $filenm=$_POST['employeeID'].'-'.'resume'. '.'. $ext[1];
                // $config['upload_path'] = 'uploads/employee_documents/';
                // $config['allowed_types'] = 'doc|docx|pdf|txt';
                // $config['overwrite']= TRUE;
                // $config['max_size']= "2048000";
                // //$config['file_name'] = $_FILES['profile_img']['name'];
                // $config['file_name'] = $filenm;
                
                // //Load upload library and initialize configuration
                // $this->load->library('upload',$config);
                // $this->upload->initialize($config);
                
                // if($this->upload->do_upload('resume')){
                //     $uploadData = $this->upload->data();
                //     $picture['resume'] = $uploadData['file_name'];
                //   // array_push($picture,$uploadData['file_name']);
                // }else{
                //     $picture['resume']="";
                // }

                try{
                    // $filepath = remove_dot_filename($filenm);
                    // $ext = explode('.', $filepath);
                    // $file_upload_name = clean($ext[0]). '.'. $ext[1];
                    $file_path = 'uploads/employee_documents/'.$filenm;
                    //$this->awssdk->deleteFile($this->bucket_name, $file_path, 1);
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['resume']['tmp_name']);
                    $picture['resume'] = $filenm;
                }catch(Exception $e){
                    $picture['resume'] = "";
                    
                }
            }
            else{
                $picture['resume']="";
            }
            // ******offer letter*******
            if(!empty($_FILES['offerLetter']['name'])){
                $original_name = remove_dot_filename($_FILES['offerLetter']['name']);
                $ext = explode('.', $original_name);
                $filenm = $_POST['employeeID'].'-'.'resume'. '.'. $ext[1];
                // $config['upload_path'] = 'uploads/employee_documents/';
                // $config['allowed_types'] = 'doc|docx|pdf|txt|jpg|jpeg|png';
                // $config['overwrite']= TRUE;
                // $config['max_size']= "2048000";
                // //$config['file_name'] = $_FILES['profile_img']['name'];
                // $config['file_name'] = $filenm;
                
                // //Load upload library and initialize configuration
                // $this->load->library('upload',$config);
                // $this->upload->initialize($config);
                
                // if($this->upload->do_upload('offerLetter')){
                //     $uploadData = $this->upload->data();
                //     $picture['offer_letter']= $uploadData['file_name'];
                //   // array_push($picture,$uploadData['file_name']);
                // }else{
                //        $picture['offer_letter']= '';
                // }

                try{
                    // $filepath = remove_dot_filename($filenm);
                    // $ext = explode('.', $filepath);
                    // $file_upload_name = clean($ext[0]). '.'. $ext[1];
                    $file_path = 'uploads/employee_documents/'.$filenm;
                    //$this->awssdk->deleteFile($this->bucket_name, $file_path, 1);
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['offer_letter']['tmp_name']);
                    $picture['offer_letter'] = $filenm;
                }catch(Exception $e){
                    $picture['offer_letter'] = "";    
                }
            }
            else{
                $picture['offer_letter']= '';
            }
            //********** Joining Letter*****
            if(!empty($_FILES['joiningLetter']['name'])){
                $original_name = remove_dot_filename($_FILES['joiningLetter']['name']);
                $ext = explode('.', $original_name);
                $filenm = $_POST['employeeID'].'-'.'joining'. '.'. $ext[1];
                // $config['upload_path'] = 'uploads/employee_documents/';
                // $config['allowed_types'] = 'doc|docx|pdf|txt|jpg|jpeg|png';
                // $config['overwrite']= TRUE;
                // $config['max_size']= "2048000";
                // //$config['file_name'] = $_FILES['profile_img']['name'];
                // $config['file_name'] = $filenm;
                
                // //Load upload library and initialize configuration
                // $this->load->library('upload',$config);
                // $this->upload->initialize($config);
                
                // if($this->upload->do_upload('joiningLetter')){
                //     $uploadData = $this->upload->data();
                //     $picture['Joining_Letter']=$uploadData['file_name'];
                //    //array_push($picture,$uploadData['file_name']);
                // }else{
                //     $picture['Joining_Letter']="";
                // }
                try{
                    // $filepath = remove_dot_filename($filenm);
                    // $ext = explode('.', $filepath);
                    // $file_upload_name = clean($ext[0]). '.'. $ext[1];
                    // $file_path = 'uploads/employee_documents/'.$file_upload_name;
                    $file_path = 'uploads/employee_documents/'.$filenm;
                   // $this->awssdk->deleteFile($this->bucket_name, $file_path, 1);
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['Joining_Letter']['tmp_name']);
                    $picture['Joining_Letter'] = $filenm;

                }catch(Exception $e){
                    $picture['Joining_Letter'] = "";    
                }
            }
            else{
               $picture['Joining_Letter']="";
            }
            //*********** ID Proof ******
            if(!empty($_FILES['IDProof']['name'])){
                $original_name = remove_dot_filename($_FILES['IDProof']['name']);
                $ext = explode('.', $original_name);
                $filenm = $_POST['employeeID'].'-'.'offer'. '.'. $ext[1];
                // $config['upload_path'] = 'uploads/employee_documents/';
                // $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                // $config['overwrite']= TRUE;
                // $config['max_size']= "2048000";
                // //$config['file_name'] = $_FILES['profile_img']['name'];
                // $config['file_name'] = $filenm;
                
                // //Load upload library and initialize configuration
                // $this->load->library('upload',$config);
                // $this->upload->initialize($config);
                
                // if($this->upload->do_upload('IDProof')){
                //     $uploadData = $this->upload->data();
                //     $picture['ID_Proof']= $uploadData['file_name'];
                //    //array_push($picture,$uploadData['file_name']);
                // }else{
                //     $picture['ID_Proof']="";
                // }
                try{
                    // $filepath = remove_dot_filename($filenm);
                    // $ext = explode('.', $filepath);
                    // $file_upload_name = clean($ext[0]). '.'. $ext[1];
                    // $file_path = 'uploads/employee_documents/'.$file_upload_name;
                    $file_path = 'uploads/employee_documents/'.$filenm;
                    //$this->awssdk->deleteFile($this->bucket_name, $file_path, 1);
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['ID_Proof']['tmp_name']);
                    $picture['ID_Proof'] = $filenm;
                }catch(Exception $e){
                    $picture['ID_Proof'] = "";    
                }
            }
            else{
                $picture['ID_Proof']="";
            }
            //*********** SSC ******
            if(!empty($_FILES['ssc']['name'])){
                $original_name = remove_dot_filename($_FILES['ssc']['name']);
                $ext = explode('.', $original_name);
                $filenm = $_POST['employeeID'].'-'.'ssc'. '.'. $ext[1];
                // $config['upload_path'] = 'uploads/employee_documents/';
                // $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                // $config['overwrite']= TRUE;
                // $config['max_size']= "2048000";
                // //$config['file_name'] = $_FILES['profile_img']['name'];
                // $config['file_name'] = $filenm;
                
                // //Load upload library and initialize configuration
                // $this->load->library('upload',$config);
                // $this->upload->initialize($config);
                
                // if($this->upload->do_upload('ssc')){
                //     $uploadData = $this->upload->data();
                //     $picture['ssc']= $uploadData['file_name'];
                //    //array_push($picture,$uploadData['file_name']);
                // }else{
                //     $picture['ssc']="";
                // }
                try{
                    $file_path = 'uploads/employee_documents/'.$filenm;
                  //  $this->awssdk->deleteFile($this->bucket_name, $file_path, 1);
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['ssc']['tmp_name']);
                    $picture['ssc'] = $filenm;
                }catch(Exception $e){
                    $picture['ssc'] = "";    
                }   
            }
            else{
                $picture['ssc']="";
            }
			//*********** HSC ******
            if(!empty($_FILES['hsc']['name'])){
                $original_name = remove_dot_filename($_FILES['hsc']['name']);
                $ext = explode('.', $original_name);
                $filenm = $_POST['employeeID'].'-'.'hsc'. '.'. $ext[1];
                // $config['upload_path'] = 'uploads/employee_documents/';
                // $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                // $config['overwrite']= TRUE;
                // $config['max_size']= "2048000";
                // //$config['file_name'] = $_FILES['profile_img']['name'];
                // $config['file_name'] = $filenm;
                
                // //Load upload library and initialize configuration
                // $this->load->library('upload',$config);
                // $this->upload->initialize($config);
                
                // if($this->upload->do_upload('hsc')){
                //     $uploadData = $this->upload->data();
                //     $picture['hsc']= $uploadData['file_name'];
                //    //array_push($picture,$uploadData['file_name']);
                // }else{
                //     $picture['hsc']="";
                // }
                try{
                    $file_path = 'uploads/employee_documents/'.$filenm;
                    //$this->awssdk->deleteFile($this->bucket_name, $file_path, 1);
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['hsc']['tmp_name']);
                    $picture['hsc'] = $filenm;
                }catch(Exception $e){
                    $picture['hsc'] = "";    
                }

            }else{
                $picture['hsc']="";
            }
			//***********Diploma ******
            if(!empty($_FILES['diploma']['name'])){
                 //$filenm=$_POST['employeeID'].'-'.'diploma-'.$_FILES['diploma']['name'];
                $original_name = remove_dot_filename($_FILES['diploma']['name']);
                $ext = explode('.', $original_name);
                $filenm = $_POST['employeeID'].'-'.'diploma'. '.'. $ext[1];
                // $config['upload_path'] = 'uploads/employee_documents/';
                // $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                // $config['overwrite']= TRUE;
                // $config['max_size']= "2048000";
                // //$config['file_name'] = $_FILES['profile_img']['name'];
                // $config['file_name'] = $filenm;
                
                // //Load upload library and initialize configuration
                // $this->load->library('upload',$config);
                // $this->upload->initialize($config);
                
                // if($this->upload->do_upload('diploma')){
                //     $uploadData = $this->upload->data();
                //     $picture['diploma']= $uploadData['file_name'];
                //    //array_push($picture,$uploadData['file_name']);
                // }else{
                //     $picture['diploma']="";
                // }

                try{
                    $file_path = 'uploads/employee_documents/'.$filenm;
                   // $this->awssdk->deleteFile($this->bucket_name, $file_path, 1);
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['diploma']['tmp_name']);
                    $picture['diploma'] = $filenm;
                }catch(Exception $e){
                    $picture['diploma'] = "";    
                }
            }
            else{
                $picture['diploma']="";
            }
			//*********** UG ******
            if(!empty($_FILES['ug']['name'])){
                $original_name = remove_dot_filename($_FILES['ug']['name']);
                $ext = explode('.', $original_name);
                $filenm = $_POST['employeeID'].'-'.'ug'. '.'. $ext[1];
                // $config['upload_path'] = 'uploads/employee_documents/';
                // $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                // $config['overwrite']= TRUE;
                // $config['max_size']= "2048000";
                // //$config['file_name'] = $_FILES['profile_img']['name'];
                // $config['file_name'] = $filenm;
                
                // //Load upload library and initialize configuration
                // $this->load->library('upload',$config);
                // $this->upload->initialize($config);
                
                // if($this->upload->do_upload('ug')){
                //     $uploadData = $this->upload->data();
                //     $picture['ug']= $uploadData['file_name'];
                //    //array_push($picture,$uploadData['file_name']);
                // }else{
                //     $picture['ug']="";
                // }
                try{
                    $file_path = 'uploads/employee_documents/'.$filenm;
                   // $this->awssdk->deleteFile($this->bucket_name, $file_path, 1);
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['ug']['tmp_name']);
                    $picture['ug'] = $filenm;
                }catch(Exception $e){
                    $picture['ug'] = "";    
                }
            }
            else{
                $picture['ug']="";
            }
			//*********** PG ******
            if(!empty($_FILES['pg']['name'])){
                
                $original_name = remove_dot_filename($_FILES['pg']['name']);
                $ext = explode('.', $original_name);
                $filenm = $_POST['employeeID'].'-'.'pg'. '.'. $ext[1];
                // $config['upload_path'] = 'uploads/employee_documents/';
                // $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                // $config['overwrite']= TRUE;
                // $config['max_size']= "2048000";
                // //$config['file_name'] = $_FILES['profile_img']['name'];
                // $config['file_name'] = $filenm;
                
                // //Load upload library and initialize configuration
                // $this->load->library('upload',$config);
                // $this->upload->initialize($config);
                
                // if($this->upload->do_upload('pg')){
                //     $uploadData = $this->upload->data();
                //     $picture['pg']= $uploadData['file_name'];
                //    //array_push($picture,$uploadData['file_name']);
                // }else{
                //     $picture['pg']="";
                // }
                try{
                    $file_path = 'uploads/employee_documents/'.$filenm;
                   // $this->awssdk->deleteFile($this->bucket_name, $file_path, 1);
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['pg']['tmp_name']);
                    $picture['pg'] = $filenm;
                }catch(Exception $e){
                    $picture['pg'] = "";    
                }
            }
            else{
                $picture['pg']="";
            }
			//*********** PHD ******
            if(!empty($_FILES['phd']['name'])){
                $original_name = remove_dot_filename($_FILES['phd']['name']);
                $ext = explode('.', $original_name);
                $filenm = $_POST['employeeID'].'-'.'phd'. '.'. $ext[1];
                // $config['upload_path'] = 'uploads/employee_documents/';
                // $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                // $config['overwrite']= TRUE;
                // $config['max_size']= "2048000";
                // //$config['file_name'] = $_FILES['profile_img']['name'];
                // $config['file_name'] = $filenm;
                
                // //Load upload library and initialize configuration
                // $this->load->library('upload',$config);
                // $this->upload->initialize($config);
                
                // if($this->upload->do_upload('phd')){
                //     $uploadData = $this->upload->data();
                //     $picture['phd']= $uploadData['file_name'];
                //    //array_push($picture,$uploadData['file_name']);
                // }else{
                //     $picture['phd']="";
                // }
                try{
                    $file_path = 'uploads/employee_documents/'.$filenm;
                   // $this->awssdk->deleteFile($this->bucket_name, $file_path, 1);
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['phd']['tmp_name']);
                    $picture['phd'] = $filenm;
                }catch(Exception $e){
                    $picture['phd'] = "";    
                }
            }
            else{
                $picture['phd']="";
            }
			//*********** Mphil ******
            if(!empty($_FILES['mphil']['name'])){
                $original_name = remove_dot_filename($_FILES['mphil']['name']);
                $ext = explode('.', $original_name);
                $filenm = $_POST['employeeID'].'-'.'mphil'. '.'. $ext[1];
                // $config['upload_path'] = 'uploads/employee_documents/';
                // $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                // $config['overwrite']= TRUE;
                // $config['max_size']= "2048000";
                // //$config['file_name'] = $_FILES['profile_img']['name'];
                // $config['file_name'] = $filenm;
                
                // //Load upload library and initialize configuration
                // $this->load->library('upload',$config);
                // $this->upload->initialize($config);
                
                // if($this->upload->do_upload('mphil')){
                //     $uploadData = $this->upload->data();
                //     $picture['mphil']= $uploadData['file_name'];
                //    //array_push($picture,$uploadData['file_name']);
                // }else{
                //     $picture['mphil']="";
                // }

                try{
                    $file_path = 'uploads/employee_documents/'.$filenm;
                    //$this->awssdk->deleteFile($this->bucket_name, $file_path, 1);
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['mphil']['tmp_name']);
                    $picture['mphil'] = $filenm;
                }catch(Exception $e){
                    $picture['mphil'] = "";    
                }
            }
            else{
                $picture['mphil']="";
            }
			//*********** Experience_certificate ******
            if(!empty($_FILES['experience_certificate']['name'])){
                
                $original_name = remove_dot_filename($_FILES['experience_certificate']['name']);
                $ext = explode('.', $original_name);
                $filenm = $_POST['employeeID'].'-'.'experience_certificate'. '.'. $ext[1];
                // $config['upload_path'] = 'uploads/employee_documents/';
                // $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                // $config['overwrite']= TRUE;
                // $config['max_size']= "2048000";
                // //$config['file_name'] = $_FILES['profile_img']['name'];
                // $config['file_name'] = $filenm;
                
                // //Load upload library and initialize configuration
                // $this->load->library('upload',$config);
                // $this->upload->initialize($config);
                
                // if($this->upload->do_upload('experience_certificate')){
                //     $uploadData = $this->upload->data();
                //     $picture['experience_certificate']= $uploadData['file_name'];
                //    //array_push($picture,$uploadData['file_name']);
                // }else{
                //     $picture['experience_certificate']="";
                // }
                try{
                    $file_path = 'uploads/employee_documents/'.$filenm;
                  //  $this->awssdk->deleteFile($this->bucket_name, $file_path, 1);
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['experience_certificate']['tmp_name']);
                    $picture['experience_certificate'] = $filenm;
                }catch(Exception $e){
                    $picture['experience_certificate'] = "";    
                }
            }
            else{
                $picture['experience_certificate']="";
            }
			//*********** NET/SET ******
            if(!empty($_FILES['net_set']['name'])){
                $original_name = remove_dot_filename($_FILES['net_set']['name']);
                $ext = explode('.', $original_name);
                $filenm = $_POST['employeeID'].'-'.'net_set'. '.'. $ext[1];
                // $config['upload_path'] = 'uploads/employee_documents/';
                // $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                // $config['overwrite']= TRUE;
                // $config['max_size']= "2048000";
                // //$config['file_name'] = $_FILES['profile_img']['name'];
                // $config['file_name'] = $filenm;
                
                // //Load upload library and initialize configuration
                // $this->load->library('upload',$config);
                // $this->upload->initialize($config);
                
                // if($this->upload->do_upload('net_set')){
                //     $uploadData = $this->upload->data();
                //     $picture['net_set']= $uploadData['file_name'];
                //    //array_push($picture,$uploadData['file_name']);
                // }else{
                //     $picture['net_set']="";
                // }
                try{
                    $file_path = 'uploads/employee_documents/'.$filenm;
                  //  $this->awssdk->deleteFile($this->bucket_name, $file_path, 1);
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['net_set']['tmp_name']);
                    $picture['net_set'] = $filenm;
                }catch(Exception $e){
                    $picture['net_set'] = "";    
                }
            }
            else{
                $picture['net_set']="";
            }
        //  print_r($_POST['update_flg']); exit;
        if(isset($_POST['update_flg']) && !empty($_POST['update_flg'])){   //for updation************************************
                //echo"In Emp Updation";
            
                $empolyee=$this->Admin_model->update_employee($_POST,$picture);
            /* print_r($empolyee);
            die(); */
            if(!empty($empolyee)&& $empolyee>0){
                $this->session->set_flashdata('message1','Employee Details Updated Successfully..');
            redirect('admin/create_employee?p=&id='.$_POST['employeeID'].'&status=Y&flag=1'); 
            }else{
                $this->session->set_flashdata('message1','Some problem occured please try again ..');
                    redirect('admin/employee_list/'.$_POST['pag']);
            }
                
            }
            else{                     //for addition of employee************************************        
                //first check availability of emp_id
            $check=$this->Admin_model->checkEmployeeIDAvailable($_POST['employeeID']);
            if(!empty($check)){
                $this->session->set_flashdata('message1','Employee Id Is already alloted......');
                redirect('admin/create_employee');
            }

            //for addition of employee          
            //echo"In Emp Addition";
            /*Employee Login Credentials Generation */
				$temp=array();
				$temp['username']=$_POST['employeeID'];
				$temp['password']= rand(100000, 999999);
            //$temp['password']=MD5(strtoUpper($_POST['fname']).strtoUpper($_POST['lname']).$_POST['employeeID']);
             /* print_r($temp);
             exit;   */ 
            /* End of Employee Login Credentials*/
            $empolyee=$this->Admin_model->add_nem_employee($_POST,$picture,$temp);
            /*  print_r($empolyee);
            die();  */ 
            if(!empty($empolyee)&& $empolyee>0){
                //send email to the employee forits username and password
                
                if($_POST['mobileNumber']!=''){
                   $this->load->library('Message_api');
$obj = New Message_api();
$txt = 'Hi, ' . strtoupper(htmlspecialchars($_POST['fname'])) . ' ' . strtoupper(htmlspecialchars($_POST['lname'])) . ',<br> 
        Login Credentials are: <br>
        <strong>Username:</strong> ' . htmlspecialchars($temp['username']) . '<br> 
        <strong>Password:</strong> ' . htmlspecialchars($temp['password']) . '<br> 
        Thank you.';
  
               // $cursession = $obj->send_sms($_POST['mobileNumber'],$txt);
			   
			   if(!empty($_POST['oemail']))
			   {
			     
				 
				$subject="Welcome! Your SU-ERP Login Credentials ";
				$file='';
				$cc='';
				$to=$_POST['oemail'];
				$from='SUN';
				$bcc='vighnesh.sukum@sandipuniversity.edu.in';
			     $obj->sendattachedemail($txt,$subject,$file,$to,$cc,$bcc,$from);
				}
  }
                
                $this->session->set_flashdata('message1','Employee Registered Successfully..');
            redirect('admin/employee_list');    
            }else{
                $this->session->set_flashdata('message1','Some problem occured please try again ..');
                    redirect('admin/create_employee');
            }
        }//end for addition
            
        }
         $this->load->view('footer');
    }
    
    
    public function add_holiday(){
        $this->load->view('header',$this->data); 
        if(!empty($_POST)){
            $holid=$this->Admin_model->addHoliday($_POST);
        }
        if(!empty($holid)&& $holid>0){
                $this->session->set_flashdata('message1','New Holiday Added Successfully..');
            redirect('admin/holiday_list'); 
            }else{
                $this->session->set_flashdata('message1','Some problem occured please try again ..');
                    redirect('admin/create_holiday');
            }
        $this->load->view('footer');
    }
	
	
    public function view_emp(){
        $this->load->view('header',$this->data); 
		$_REQUEST=$_GET; 
        $emp_id=$_REQUEST['id'];
        $status=$_REQUEST['status'];
		
            $result['temp']=$this->Admin_model->getEmployeeById($emp_id,$status);
            /* echo"<pre>";
            print_r($result);
            echo"</pre>";
            die();  */
             $this->load->view($this->view_dir.'view_emp',$result);
            
         $this->load->view('footer');
    }
	
	
    public function deact_emp(){
        $this->load->view('header',$this->data);
$_REQUEST=$_GET; 
            $emp_id=$_REQUEST['id'];
            $status=$_REQUEST['status'];
            $result['temp']=$this->Admin_model->changeEmployeeStatus($emp_id,$status);
            if($result){
                $this->session->set_flashdata('message1', 'profile Status Updated ');
                redirect('admin/employee_list/'.$_REQUEST['p']);
                
                }
            else{
                $this->session->set_flashdata('message1', 'Some Problem Occured ...');
                redirect('admin/employee_list/'.$_REQUEST['p']);
            }   
            $this->load->view('footer');
    }
    public function disable_emp(){

$_REQUEST=$_GET;
        $this->load->view('header',$this->data); 
            $emp_id=$_REQUEST['id'];
            $status=$_REQUEST['status'];
            $result['temp']=$this->Admin_model->disableEmployeeStatus($emp_id,$status);
            if($result){
                $this->session->set_flashdata('message1', 'profile Status Updated ');
                redirect('admin/employee_list/'.$_REQUEST['p']);
                
                }
            else{
                $this->session->set_flashdata('message1', 'Some Problem Occured ...');
                redirect('admin/employee_list/'.$_REQUEST['p']);
            }   
            $this->load->view('footer');
    }	
     public function department_list()
    {
        $this->load->view('header',$this->data);        
   /*  $this->data['course_details']= $this->Admin_model->getCollegeCourse($college_id);
    $this->data['course_year']= $this->Admin_model->getCourseYRClg($college_id);
    $this->data['quota']= $this->Admin_model->getQuota($college_id); */
    
        $this->load->view($this->view_dir.'department_list',$this->data);
        $this->load->view('footer');
    }

     public function holiday_list()
    {
		if($this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==1){
			//echo 1;exit;
		}else{
			redirect('home');
		}
        $this->load->view('header',$this->data);   
        $menu = $this->uri->segment(1);
   $menu1 = $this->uri->segment(2);
   $this->data['my_privileges'] = $this->retrieve_privileges($menu."/".$menu1);
          if(isset($_POST['search_dt1'])&& !empty($_POST['search_dt1'])){
            // $search_dt=$_POST['search_dt1'];
           //  $search_dt=$_POST['search_dt1'].'-01';
            // $time=strtotime($search_dt);
            // $month=date("F",$time);
           //   $year1=date("Y",$time);
              //echo $year;//die();
             $this->data['year']=$_POST['search_dt1'];
             
           }else{
               $today=date('Y-m-d');
               $time=strtotime($today);
              $month=date("F",$time);
              $year=date("Y",$time);
               $this->data['year']=$this->config->item('current_year'); //default current year
               // $this->data['month']= $month;
           }

        $this->load->view($this->view_dir.'holiday_list',$this->data);
        $this->load->view('footer');
    }
    public function del_holiday(){
        $hol_id=$_REQUEST['id'];
        $res=$this->Admin_model->del_Holiday($hol_id);
        if($res==true){
        $this->session->set_flashdata('message1', 'Holiday Deleted Successfully.. ');
                redirect('admin/holiday_list');
                
                }
            else{
                $this->session->set_flashdata('message1','Some Problem Occured ...');
                redirect('admin/create_holiday');
            }   
        
    }
    public function del_holidaybyoid(){
        $hol_id=$_REQUEST['id'];
        $res=$this->Admin_model->del_Holiday_byoid($hol_id);
        if($res==true){
        $this->session->set_flashdata('message1', 'Holiday Deleted Successfully.. ');
                redirect('admin/holiday_list');
                
                }
            else{
                $this->session->set_flashdata('message1','Some Problem Occured ...');
                redirect('admin/create_holiday');
            }   
        
    }
    function view_leave_application(){
       $application_id=$_REQUEST['id'];
      $this->load->view('header',$this->data);  
      $this->data['leave']=$this->Admin_model->getAllLeaveType();      
      $this->data['details']= $this->Admin_model->getLeaveDetailById($application_id);
       $this->load->view($this->view_dir.'view_leave_application',$this->data);
        $this->load->view('footer');
   }
   function view_leave_application_reg(){
       $application_id=$_REQUEST['id'];
      $this->load->view('header',$this->data);  
      $this->data['leave']=$this->Admin_model->getAllLeaveType();      
      $this->data['details']= $this->Admin_model->getLeaveDetailById($application_id);
       $this->load->view($this->view_dir.'view_leave_application_reg',$this->data);
        $this->load->view('footer');
   }
   
   function del_leave_app(){
        $application_id=$_REQUEST['id'];
        if(!empty($application_id)){
         $res=$this->Admin_model->remove_leave_application($application_id);    
        }
         if($res==true){
        $this->session->set_flashdata('message1', 'Leave Application Deleted Successfully.. ');
                redirect('admin/leave_applicant_list');
                
                }
            else{
                $this->session->set_flashdata('message1','Some Problem Occured ...');
                redirect('admin/leave_applicant_list');
            }   
   }
   function del_od_app(){
        $application_id=$_REQUEST['id'];
        if(!empty($application_id)){
         $res=$this->Admin_model->remove_od_application($application_id);   
        }
         if($res==true){
        $this->session->set_flashdata('message1', 'OD Application Deleted Successfully.. ');
                redirect('admin/od_application_list');
                
                }
            else{
                $this->session->set_flashdata('message1','Some Problem Occured ...');
                redirect('admin/od_application_list');
            }   
   }

   
   function update_leave_application(){  
   
       if(!empty($_POST)){             
         $res=$this->Admin_model->update_leave_applicationDetails($_POST);       
       }
       if($res==1){        
           /* //Deduct leave balance from staff allocated leave ///leave deduction will be done only leave approved by registrar only**/

          /* if($res['lstatus']=='Approved'){              
               $deduct=$this->Admin_model->deductLeaveCount($res);
           } */
           $emp_detail=$this->Admin_model->getEmployeeById($_POST['emp_id'],'Y');
           $reporting=$this->Admin_model->getROforLeave($_POST['emp_id']);
            /* echo"<pre>";print_r($reporting);echo"</pre>";
            echo"************************************************";
            echo"<pre>";print_r($emp_detail);echo"</pre>";
           die(); 
            */
           //send mail on leave approval/rejection by ro/admin
           /*using curl*/
//$ch = curl_init("http://www.carrottech.in/mailer/mailer-sandip-erp-leave.php");
$to =$emp_detail[0]['oemail']; //to staff
//$to = 'deepak.nagane@carrottech.in,jugal.singh@carrottech.in,mohini.patil@carrottech.in';
$name = $reporting[0]['fname']." ".$reporting[0]['lname'];
$frm_nm=$name;//$_POST['ename']
$frm_email=$reporting[0]['oemail'];//$_POST['email']
//$encoded = 'send=true&from_name='.urlencode($frm_nm).'&from_email='.urlencode($frm_email).'&to='.urlencode($to).'&subject=Leave Application Processed';
 
        $emailId = $emp_detail[0]['oemail'];
        $contactNo = $emp_detail[0]['mobileNumber'];
        $body = 'Hello,<br>';
        $body .= 'Referring to the above mentioned subject,<br>';
        $body .='your application for Leave has been '.$_POST['status'].' dated '.$_POST['applied_on_date'].' with leave ID:'.$_POST['lid'];
if($_POST['status']=='Approved') {
        $body.='<br> Now your Leave application is forwarded to the Registrar for final approval';
}     
      $body .= '<br>Thanking You.<br><br>';

      $this->load->library('Message_api');
$obj = New Message_api();
//$body="test";
$subject="Leave Application Processed";
$file="";
//$to="balasaheb.lengare@carrottech.in";
//$cc="kiran.valimbe@sandipuniversity.edu.in";
$cc='';
//$bcc="kiran.valimbe@sandipuniversity.edu.in";
$from='noreply@sandipuniversity.com';
$cursession = $obj->sendattachedemail($body,$subject,$file,$to,$cc,$bcc,$from);

       // $encoded .= '&message='.urlencode($body).'&';
// chop off last ampersand
//$encoded = substr($encoded, 0, strlen($encoded)-1);
//curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
//curl_setopt($ch, CURLOPT_HEADER, 0);
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_exec($ch);
//curl_close($ch);
/*end curl*/
        $this->session->set_flashdata('message1', 'Leave Application Updated Successfully.. ');
                redirect('admin/leave_applicant_list');
                
                }
            else{
                $this->session->set_flashdata('message1','Some Problem Occured ...');
                redirect('admin/leave_applicant_list');
            }   
   } 
function update_leave_application_registrar(){
    if(!empty($_POST)){            
         $res=$this->Admin_model->update_leave_applicationByRegistrar($_POST);       
       }
       
        if($res['ures']==1){           
            //Deduct leave balance from staff allocated leave ///leave deduction will be done only leave approved by registrar only**/

          if($res['lstatus']=='Approved'){             
               $deduct=$this->Admin_model->deductLeaveCount($res);
           } 
           $emp_detail=$this->Admin_model->getEmployeeById($_POST['emp_id'],'Y');
           $reporting=$this->Admin_model->getROforLeave($_POST['emp_id']);
            /* echo"<pre>";print_r($reporting);echo"</pre>";
            echo"************************************************";
            echo"<pre>";print_r($emp_detail);echo"</pre>";
           die(); 
            */
           //send mail on leave approval/rejection by ro/admin
           /*using curl*/
$ch = curl_init("http://www.carrottech.in/mailer/mailer-sandip-erp-leave.php");
$to =$emp_detail[0]['oemail']; //to staff
//$to = 'deepak.nagane@carrottech.in,jugal.singh@carrottech.in,mohini.patil@carrottech.in';
$name = $reporting[0]['fname']." ".$reporting[0]['lname'];
$frm_nm=$name;//$_POST['ename']
$frm_email=$reporting[0]['oemail'];//$_POST['email']
$encoded = 'send=true&from_name='.urlencode($frm_nm).'&from_email='.urlencode($frm_email).'&to='.urlencode($to).'&subject=Leave Application Processed';
 
        $emailId = $emp_detail[0]['oemail'];
        $contactNo = $emp_detail[0]['mobileNumber'];
        $body = 'Hello,<br>';
      //  $body .= 'Referring to the above mentioned subject,<br>';
        $body .='your application for Leave has been '.$_POST['reg_approval_status'].' dated '.$_POST['applied_on_date'].'with leave ID:'.$_POST['lid'];
        $body .= '<br>Thanking You.<br><br>';
        $encoded .= '&message='.urlencode($body).'&';
// chop off last ampersand
$encoded = substr($encoded, 0, strlen($encoded)-1);
curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_exec($ch);
curl_close($ch);
/*end curl*/
        $this->session->set_flashdata('message1', 'Leave Application Updated Successfully.. ');
                redirect('admin/leave_applicant_list');
                
                }
            else{
                $this->session->set_flashdata('message1','Some Problem Occured ...');
                redirect('admin/leave_applicant_list');
            }
       
}  
   function update_od_application(){
       if(!empty($_POST)){
            /* print_r($_POST);
           die(); */ 
         $res=$this->Admin_model->update_od_applicationDetails($_POST);  
       }
       if($res==true){
           //send mail on leave approval/rejection by ro/admin
            $emp_detail=$this->Admin_model->getEmployeeById($_POST['emp_id'],'Y');
           $reporting=$this->Admin_model->getROforLeave($_POST['emp_id']);
            /* echo"<pre>";print_r($reporting);echo"</pre>";
            echo"************************************************";
            echo"<pre>";print_r($emp_detail);echo"</pre>";
           die(); 
            */
           //send mail on leave approval/rejection by ro/admin
           /*using curl*/
$ch = curl_init("http://www.carrottech.in/mailer/mailer-sandip-erp-leave.php");
$to =$emp_detail[0]['oemail']; //to staff
//$to = 'deepak.nagane@carrottech.in,jugal.singh@carrottech.in,mohini.patil@carrottech.in';
$name = $reporting[0]['fname']." ".$reporting[0]['lname'];
$frm_nm=$name;//$_POST['ename']
$frm_email=$reporting[0]['oemail'];//$_POST['email']
$encoded = 'send=true&from_name='.urlencode($frm_nm).'&from_email='.urlencode($frm_email).'&to='.urlencode($to).'&subject=OD Application Processed';
        
        $body = 'Hello,<br>';
        $body .= 'Referring to the above mentioned subject,<br>';
        $body .='your application for OD has been'.$_POST['status'].'dated'.$_POST['od_applied_on_date'].'with OD ID:'.$_POST['lid'];
        $body .= 'Thanking You.<br><br>';
        $encoded .= '&message='.urlencode($body).'&';
// chop off last ampersand
$encoded = substr($encoded, 0, strlen($encoded)-1);
curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_exec($ch);
curl_close($ch);
/*end curl*/
           
        $this->session->set_flashdata('message1', 'OD Application Updated Successfully.. ');
                redirect('admin/od_application_list');
                
                }
            else{
                $this->session->set_flashdata('message1','Some Problem Occured ...');
                redirect('admin/od_application_list');
            }   
   }   
     public function leave_applicant_list()
    {
     $this->load->view('header',$this->data);
      if($this->session->userdata("uid")==1){  //for Admin
      
        $this->data['applicant']= $this->Admin_model->getAllLeaveApplicantList();  
      }else{ 
          $this->data['applicant']= $this->Admin_model->getLeaveApplicantList($this->session->userdata("role_id"),$this->session->userdata("name"));
      } 
   
    $this->load->view($this->view_dir.'leave_process',$this->data);
    $this->load->view('footer');
    }
     public function od_application_list()
    {
     $this->load->view('header',$this->data);
      if($this->session->userdata("uid")==1){
        $this->data['applicant']= $this->Admin_model->getAllODApplicantList();  
      }else{
          $this->data['applicant']= $this->Admin_model->getODApplicantList($this->session->userdata("uid"),$this->session->userdata("name"));
      } 
    
    $this->load->view($this->view_dir.'od_process',$this->data);
    $this->load->view('footer');
    }
    function view_od_application(){
       $application_id=$_REQUEST['id'];
      $this->load->view('header',$this->data);       
      $this->data['details']= $this->Admin_model->getODDetailById($application_id);
       $this->load->view($this->view_dir.'view_od_application',$this->data);
        $this->load->view('footer');
   }
    
    //*****For Attendance*****/////
    public function dailycron(){
        //Copy data from device log table to System punching backup table//
        // first check for todays entry present or not
        $check=$this->Admin_model->check_todays();
        /* print_r($check);
        die(); */
        if(empty($check)){
            $res=$this->Admin_model->backupDeviceLogDaily();
        }
    }
	
	
    public function attendance_all($offSet=0){
		
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
        $this->data['emp_cat']= $this->Admin_model->getAllEmpCategory();
        $total=count($cnt);
        $total_pages = ceil($total/$limit);
       //echo $total_pages; 
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
       //$this->data['attendance']= $this->Admin_model->getAttendance_AllDefault($offSet,$limit); // for fetching result of punched
        $this->data['emp_list']= $this->Admin_model->getEmployees('Y');
		
        $this->data['vemp_list']= $this->Admin_model->getVisitingEmployees1('Y');
        $this->load->view($this->view_dir.'display_attendance',$this->data);
        $this->load->view('footer');    
    }
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


public function attendance_all_demo($offSet=0){
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
     $this->load->view($this->view_dir.'display_attendance_new',$this->data);
     $this->load->view('footer');    
    }
	








 public function view_attendance($offSet=0){
	// echo'aaa1212';exit;	 
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
                      'empsid'=>$_POST['empsid'],
                      'staff_type'=>$_POST['staff_type']				  
                     ];
            $this->session->set_userdata($temp);
        }
		
        $data['attend_date']=$this->session->userdata("attend_date");
        $data['emp_school']=$this->session->userdata("emp_school");
        $data['department']=$this->session->userdata("department");
        $data['empsid']=$this->session->userdata("empsid");
		$data['staff_type']=$this->session->userdata("staff_type");
        //print_r($_POST['empsid']);
        $emplist = $_POST['empsid'];  

      
         if(empty($data['emp_school']) && empty($data['department'])){
        
		 // echo'aaa';exit;
              $this->data['attend_date']=$data['attend_date'];
              //first check whether the attandance available in punching backup table
              $check_dt=$this->Admin_model->checkAvailableAttendance($this->data['attend_date']);
			
			  

          if(!empty($check_dt)){
                
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
			
/*  echo'<pre>';			        
print_r($attendance);     
exit; */ 

 

              $this->data['attendance']=$attendance;  
			 
			 
              }elseif(empty($check_dt)){
               $this->data['all_emp']="";
               $this->data['attendance']="";
              }

            //  if($_POST['downpdf'] == 'Download To PDF')
     //{  
     
      //exit;
	
	
    $this->inout_table_exporttopdf($this->data);
	///// ex
    // }
          //  $this->load->view($this->view_dir.'display_attendance',$this->data);  
            
        }
		
		elseif(!empty($data['emp_school'])&& empty($data['department'])){ //for all deprtment under only selected School
       
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
 //echo'aaa1212';exit;
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
    
	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	


			public function send_attendance(){
				$emplist= $this->Admin_model->getEmployees1('Y');
				$date=date('Y-m');

				$emplist1=array();
				if(!empty($emplist)){ $m=1;
				foreach($emplist as $val){
				$emplist1[]['emp_id'] = $val['emp_id'];
				$sent_date=$val['mail_sent_on'];
				if($sent_date !=date('Y-m-d')){
				if($m<50){
				$attendance[$val['emp_id']]=$this->Admin_model->getAttendanceForAllSchool($val['emp_id'],$date);
				$dt=array('empsid'=>array($val['emp_id']));
				$all_emp=$this->Admin_model->getAttendance_All1($dt);  
				$this->data['all_emp']= $all_emp;
				$this->data['attendance']=$attendance;
				$this->data['attend_date']=$date;		    		  		   
				$html =  $this->load->view($this->view_dir.'inout_pdf_export',$this->data,true);
				$this->load->library('m_pdf');
				$pdfFilePath1 =$val['emp_id'].$date."_attendance.pdf";
				$mpdf=new mPDF();
				$this->m_pdf->pdf = new mPDF('L', 'A3', '', '', 5, 5, 5, 5, 5, 5);
				$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->WriteHTML($html);
				$pdf_data=$this->m_pdf->pdf->Output('', "S");
				$body = "Hi Sir,
				Please find your attendance. Kindly contact admin section for any queries.

				Thanks,
				Sandip University";
				$email='vighnesh.sukum@sandipuniversity.edu.in';
				$subject='weekly attendance';
				$this->send_mail($email,$subject,$body,$pdf_data,$pdfFilePath1);
				$this->db->where('emp_id', $val['emp_id']);
				$this->db->update('employee_master', array('mail_sent_on'=> $sent_date));
				$m++;
				}
				}
				//exit;
				}
				}
			}

			function send_mail($email='',$subject='',$body='',$pdfData='',$filename=''){
			$path=$_SERVER["DOCUMENT_ROOT"].'/application/third_party/';
			require_once($path.'PHPMailer/class.phpmailer.php');
			date_default_timezone_set('Asia/Kolkata');
			require_once(APPPATH."third_party/PHPMailer/PHPMailerAutoload.php");
			$mail = new PHPMailer;
			//Tell PHPMailer to use SMTP
			$mail->isSMTP();			
			$mail->Host = 'smtp.gmail.com';		
			$mail->Port = 465;			
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';			
			$mail->Username = 'NoReply2@sandipuniversity.com'; 			
			$mail->Password = '*K052r4ItvjN';			
			$mail->setFrom('noreply@sandipuniversity.com', 'SUN');
			$mail->AddAddress($email);
			$mail->Subject = $subject;
			$mail->Body = $body;
			$mail->addStringAttachment($pdfData, $filename, 'base64', 'application/pdf');
			if (!$mail->send()) {
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
			echo 'Message sent!';
			}
			}


	
    function exporttoexcel(){
        $this->load->view($this->view_dir.'exporttoexcel');
    }
    function exporttoexcelattend(){
        $this->load->view($this->view_dir.'exporttoexcelattend');
    }
    
    
    //searching attendance of a user by Id and updating it
    public function search_attendance(){
        $this->load->view('header',$this->data);
        $this->data['org_list']= $this->Admin_model->getAllOrganizations();      
         $this->data['school_list']= $this->Admin_model->getAllschool();     
         $this->data['dept_list']= $this->Admin_model->getAllDepartments();      
         $this->data['desig_list']= $this->Admin_model->getAllDesignations();
        $this->load->view($this->view_dir.'search_attendance',$this->data);
        $this->load->view('footer');
        
    }
    public function fetch_attendance(){
        $this->load->view('header',$this->data);
        $this->data['org_list']= $this->Admin_model->getAllOrganizations();
         $this->data['school_list']= $this->Admin_model->getAllschool();            
         $this->data['dept_list']= $this->Admin_model->getAllDepartments();      
         $this->data['desig_list']= $this->Admin_model->getAllDesignations();
        if(isset($_POST)&& !empty($_POST)){
            $this->data['res']=$this->Admin_model->getAttendanceForSearchID($_POST);
            $this->data['present']=$this->Admin_model->getTotalPresentByID($_POST);// total present
            $this->data['abscent']=$this->Admin_model->getTotalAbscentByID($_POST); // total abscent
            $this->data['outer']=$this->Admin_model->getTotalOuterDutyByID($_POST); // total OD(outerDuty)
            $this->data['over']=$this->Admin_model->getTotalOverTimeByID($_POST); // total OT(overtime)
            $this->data['late']=$this->Admin_model->getTotalLatemarkByID($_POST); // total LT(Latemark)
            $this->data['leave']=$this->Admin_model->getTotalLeaveByID($_POST); // total Leave(Leave)
            if(!empty($this->data['res'])){
                 $this->load->view($this->view_dir.'search_attendance',$this->data);
            }else{
                
                $this->session->set_flashdata('message1','No Result Found...');
                redirect('admin/search_attendance');
            }           
        }       
            $this->load->view('footer');
    }
    public function update_attendance(){
        $emp_id1=$_POST['emp_id'];
          $name1=$_POST['name'];
           $adate1=$_POST['adate'];
            $intime1=$_POST['intime'];
            $outtime1=$_POST['outtime'];
            $reason=$_POST['reason'];
            
        if(isset($_POST)&& !empty($_POST)){
            
            $res=$this->Admin_model->updateEmpAttendance($_POST);
            
            if($res==true){
                $this->session->set_flashdata('message1','Employee Attendance Status Updated...');
                redirect('admin/search_attendance','refresh');
            }
            if($res==false){
                $this->session->set_flashdata('message1','some problem occured try again...');
                redirect('admin/search_attendance');
            }           
        }
    }
    
    //for calculating total monthly attendance i.e.total day present ,total day OD,Cl,PL,etc..
    
    public function total_monthly_attendance(){
    
        $this->load->view('header',$this->data);
        $this->data['school_list']= $this->Admin_model->getAllschool();  
         $this->data['dept_list']= $this->Admin_model->getAllDepartments();      
         $this->data['desig_list']= $this->Admin_model->getAllDesignations();
        $this->data['emp_list']= $this->Admin_model->getEmployees();
 
         if(isset($_POST['submit'])){
             
           $this->data['emp_school']=$_POST['emp_school'];
           $this->data['department']=$_POST['department'];
           $this->data['attend_date']=$_POST['attend_date'];
		   $this->data['empsid_new']=$_POST['empsid'];
           $chk_tab = $this->Admin_model->checkFinalAttendance($_POST);
		   
		   
		   
		   //echo $this->db->last_query();
		   //exit;
		  
       if(!empty($chk_tab)){         
		 $this->data['all_attend']=$this->Admin_model->fetch_employee_monthly($_POST);   
		
         $this->data['sbtn'] = '1';
		 
		 
	   }
	   else
	   { 
   
   
	        // if(!empty($chk_tab))
		//echo "ddd";
	//exit;
             $monatt = $this->Admin_model->checkMonthAttendance($_POST);
  
 
  
              if(empty($monatt)){
				
              $this->data['sbtn'] = '0';
              $check_dt=$this->Admin_model->checkAvailableAttendance($this->data['attend_date']);
			  
              if(!empty($check_dt)){
				
                  /*calculate sundays and holidyas of a serched month and total working days,present days*/
					$attend_date= $this->data['attend_date'];
					$date =  $attend_date."-01";
					$lt=date('t', strtotime($attend_date)); //get end date of month
					$end = $attend_date."-".$lt;
					$time=strtotime($attend_date);
					$d = date_parse_from_format("Y-m-d",$attend_date);
					$msearch=$d["month"];//month number
					$ysearch=date("Y",strtotime($attend_date));
					$monthName = date('F', mktime(0, 0, 0, $msearch, 10));// month name
					$cm = date('m');
             
			       if($cm == $msearch){
                   $totaldays= date('d')-1; 
                   }else{
                   $totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);
                   }
				   
                        // echo $total_days;
                   //$totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);//total month days
                    $i=1;
                   //calculate number of sundays in given month
                 //  $total_holiday=$this->Admin_model->getTotalHoliday($msearch,$ysearch);
                       
                  /***********************************end**************************************/
                  
                  if($cm == $msearch){
                  $totaldays= date('d')-1; 
                  }else{
                  $totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);
                  }
				  
				  
                         //echo $totaldays;
                  
              $all_attend=$this->Admin_model->getAllTotalAttendance1($_POST);
			
              for($i=0;$i<count($all_attend);$i++){

              	//echo $all_attend[$i]['manual_attendance_flag'];
              	//echo  $all_attend[$i]['emp_id'];
                if($all_attend[$i]['manual_attendance_flag']=='K'){
					
                 $mand = $this->Admin_model->get_Marked_Emp_attendance($all_attend[$i]['emp_id'],$this->data['attend_date']);

                   if($all_attend[$i]['gender']=='male'){ $f = 'Mr.';}else if($all_attend[$i]['gender']=='female'){ $f = 'Mrs.';}
				   
				
   //  if($temp_pret[0]['total_present'] != '0'){
                   $all_attend[$i]['total_present'] = $mand[0]['total_present'];
                   $all_attend[$i]['total'] = $mand[0]['Total'];
                   $all_attend[$i]['UserId'] = $all_attend[$i]['emp_id'];
				   
                   $all_attend[$i]['ename'] = $f." ".$all_attend[$i]['fname']." ".$all_attend[$i]['mname']." ".$all_attend[$i]['lname'];
				   $all_attend[$i]['Type'] = '--';
                   $all_attend[$i]['total_outduty']=$mand[0]['total_outduty'];
                   $all_attend[$i]['total_CL']=$mand[0]['CL'];
                   $all_attend[$i]['total_ML']=$mand[0]['ML'];
                   $all_attend[$i]['total_EL']=$mand[0]['EL'];
                   $all_attend[$i]['total_Coff']=$mand[0]['C-Off'];
                   $all_attend[$i]['total_SL']=$mand[0]['SL'];
                   $all_attend[$i]['total_VL']=$mand[0]['VL'];
                   $all_attend[$i]['total_leave']=$mand[0]['leaves'];               
                   $all_attend[$i]['total_LWP']=$mand[0]['LWP'];  
				   $all_attend[$i]['total_WFH']=$mand[0]['WFH'];                  
                   $all_attend[$i]['month_days']=$totaldays; 
                   $all_attend[$i]['working_days']=$mand[0]['working_days']; 
                   $all_attend[$i]['sunday']=$mand[0]['sunday']; 
                   $all_attend[$i]['holiday']=$mand[0]['holiday']; 

                }else{
					
				///echo "ddd";
				//exit;
                  $total_holiday = $this->Admin_model->getHolidayListMonthWiseFromPunching($all_attend[$i]['emp_id'],$this->data['attend_date']);
                  $working_days=$totaldays-($total_holiday['sunday']+$total_holiday['holiday']);
                  $temp=$this->Admin_model->getremainingAllLeaveCountByEmp1($all_attend[$i]['emp_id'],$this->data['attend_date']);
                 $temp_pret =$this->Admin_model->getPresentCountByEmp($all_attend[$i]['emp_id'],$this->data['attend_date']);
                 
       //print_r($temp_pret); echo count($temp_pret);exit;
                  $od = $this->Admin_model->getremainingAllODCountByEmp1($all_attend[$i]['emp_id'],$this->data['attend_date']);
				
				  
				//  exit();
                  $temp1=$this->Admin_model->getAllLeaveHalfDayCountByEmpID($all_attend[$i]['emp_id'],$this->data['attend_date']);
				  
				  //echo $this->db->last_query();
				  //exit;
    
                   if($all_attend[$i]['gender']=='male'){ $f = 'Mr.';}else if($all_attend[$i]['gender']=='female'){ $f = 'Mrs.';}
                     //  if($temp_pret[0]['total_present'] != '0'){
                   $all_attend[$i]['total_present'] = $temp1+count($temp_pret);//
                   $all_attend[$i]['total_present_half']= $temp1;
                   $all_attend[$i]['UserId'] = $all_attend[$i]['emp_id'];
                   $all_attend[$i]['ename'] =  $f." ".$all_attend[$i]['fname']." ".$all_attend[$i]['mname']." ".$all_attend[$i]['lname'];
				   $all_attend[$i]['Type'] = $all_attend[$i]['category_type']; 
                   $all_attend[$i]['total_outduty']=$od;
                   $all_attend[$i]['total_CL']=$temp['CL'];
                   $all_attend[$i]['total_ML']=$temp['ML'];
                   $all_attend[$i]['total_EL']=$temp['EL'];
                   $all_attend[$i]['total_Coff']=$temp['C-OFF'];
                   $all_attend[$i]['total_SL']=$temp['SL'];
                   $all_attend[$i]['total_VL']=$temp['VL'];
                   $all_attend[$i]['total_leave']=$temp['Leave'];               
                   $all_attend[$i]['total_LWP']=$temp['LWP'];   
				   $all_attend[$i]['total_WFH']=$temp['WFH'];                
                   $all_attend[$i]['month_days']=$totaldays;
                   $all_attend[$i]['working_days']=$working_days;
                   $all_attend[$i]['sunday']=$total_holiday['sunday'];
                   $all_attend[$i]['holiday']=$total_holiday['holiday'];
                   $all_attend[$i]['total'] = $temp1+count($temp_pret)+$temp['EL']+$temp['Leave']+$temp['C-OFF']+$temp['SL']+$temp['VL']+$total_holiday['sunday']+$total_holiday['holiday']+$od+$temp['CL']+$temp['ML'];
				   
             
			  } // if($all_attend[$i]['manual_attendance_flag']=='Y')
			  
			  
              } //for($i=0;$i<count($all_attend);$i++)
			  
             $this->data['all_attend']= $all_attend;
                
               }elseif(empty($check_dt)){
				  //  echo '5';
		//	exit;
               $this->data['all_attend']="";
                }
				
			  
               }else{ //if(empty($monatt))
			 // echo '6';
			//exit; 
       // $this->data['all_attend'] = $monatt;
                $monatt = $this->Admin_model->checkMonthAttendance1($_POST);
                $mcnt = count($monatt);
     //  echo '<pre>';  print_r($monatt);echo '<pre/>';exit;
                for($i=0;$i<$mcnt;$i++){
  //echo $monatt[$i]['UserId'];
  //echo $this->data['attend_date'];
             //    $total_holiday = $this->Admin_model->getHolidayListMonthWiseFromPunching($all_attend[$i]['emp_id'],$this->data['attend_date']);
                        // print_r($total_holiday);
       // $working_days=$totaldays-($total_holiday['sunday']+$total_holiday['holiday']);
                  $temp=$this->Admin_model->getremainingAllLeaveCountByEmp1($monatt[$i]['UserId'],$this->data['attend_date']);
                  //print_r($temp);
          //exit;
                     //  $temp_pret =$this->Admin_model->getPresentCountByEmp($all_attend[$i]['emp_id'],$this->data['attend_date']);
                 
      
                  $od = $this->Admin_model->getremainingAllODCountByEmp1($monatt[$i]['UserId'],$this->data['attend_date']);
                  $temp1=$this->Admin_model->getAllLeaveHalfDayCountByEmpID($monatt[$i]['UserId'],$this->data['attend_date']);
    
                 if($monatt[$i]['gender']=='male'){ $f = 'Mr.';}else if($monatt[$i]['gender']=='female'){ $f = 'Mrs.';}
                 //  if($temp_pret[0]['total_present'] != '0'){
                 $all_attend[$i]['total_present'] = $monatt[$i]['total_present'];//$temp1+
                 $all_attend[$i]['total_present_half']= $temp1;
                 $all_attend[$i]['UserId'] = $monatt[$i]['UserId'];
                 $all_attend[$i]['ename'] = $f." ".$monatt[$i]['ename'];
				
				 $all_attend[$i]['Type'] = '-';
                   if($monatt[$i]['manual_attendance']=='K'){
				
                   $memp = $this->Admin_model->get_Marked_Emp_attendance($monatt[$i]['UserId'],$this->data['attend_date']);
                   $all_attend[$i]['total_outduty']=$memp[0]['total_outduty'];
                   $all_attend[$i]['total_CL']=$memp[0]['CL'];
                   $all_attend[$i]['total_ML']=$memp[0]['ML'];
                   $all_attend[$i]['total_EL']=$memp[0]['EL'];
                   $all_attend[$i]['total_Coff']=$memp[0]['C-Off'];
                   $all_attend[$i]['total_SL']=$memp[0]['SL'];
                   $all_attend[$i]['total_VL']=$memp[0]['VL'];
                   $all_attend[$i]['total_leave']=$memp[0]['leaves']; 
				    
                   }else{//if($monatt[$i]['manual_attendance']=='Y')
			  
                   $all_attend[$i]['total_outduty']=$od;
                   $all_attend[$i]['total_CL']=$temp['CL'];
                   $all_attend[$i]['total_ML']=$temp['ML'];
                   $all_attend[$i]['total_EL']=$temp['EL'];
                   $all_attend[$i]['total_Coff']=$temp['C-OFF'];
                   $all_attend[$i]['total_SL']=$temp['SL'];
                   $all_attend[$i]['total_VL']=$temp['VL'];
                   $all_attend[$i]['total_leave']=$temp['Leave'];   

                   }  //if($monatt[$i]['manual_attendance']=='Y')
				    $all_attend[$i]['total_WFH']=$monatt[$i]['WFH']; 
				             
                   $all_attend[$i]['total_LWP']=$monatt[$i]['LWP'];                   
                   $all_attend[$i]['month_days']=$monatt[$i]['month_days'];
                   $all_attend[$i]['working_days']=$monatt[$i]['working_days'];
                   $all_attend[$i]['sunday']=$monatt[$i]['sunday'];
                   $all_attend[$i]['holiday']=$monatt[$i]['holiday'];
                   $all_attend[$i]['total']=$monatt[$i]['Total'];
               
			    }//for($i=0;$i<$mcnt;$i++)
 //echo '<pre>';  print_r($all_attend);echo '<pre/>';exit;

                   $this->data['all_attend'] = $all_attend;
                   $this->data['sbtn'] = '2';
      }// if(!empty($chk_tab))
	  
	  
         }//if(empty($monatt))
		 
		 
     } //if(isset($_POST['submit']))
   
 
 
         if($_POST['exp_t']=='1'){
			 
          $this->total_attendance_export($this->data,$_POST['attend_date']);
         }
        
		
		$this->load->view($this->view_dir.'total_attendance',$this->data); 
        $this->load->view('footer');
        
    }
	
	
	
	
	
	
public function add_update_monthly_attendance(){
	
	ini_set('max_input_vars', 3000);
	/*echo "<pre>";
	$data=file_get_contents('php://input');
	
	
	
	$data1=$this->input->post(NULL, FALSE);
	*/
	
	
     $this->data['emp_school']=$_POST['empschool'];
     $this->data['department']=$_POST['dept'];
     $this->data['attend_date']=$_POST['rdate'];
     $_POST['attend_date']= $_POST['rdate'];
	 $this->data['UserId']=$_POST['UserId'];
	 //print_r( $_POST);exit;
	 
     if($_POST['sbtnv']=='2'){
		
     $all_attend=$this->Admin_model->getAllTotalAttendance1($_POST);
	// print_r($all_attend); exit;
               count($all_attend); //exit;
              for($i=0;$i<count($all_attend);$i++){
            
			 $temp=$this->Admin_model->getremainingAllLeaveCountByEmp1($all_attend[$i]['emp_id'],$this->data['attend_date']);
             $all_attend[$i]['sbtnv'] = '2';
             $od = $this->Admin_model->getremainingAllODCountByEmp1($all_attend[$i]['emp_id'],$this->data['attend_date']);
//$all_attend[$i]['total_present1'] = $temp_pret[0]['total_present'];
           $all_attend[$i]['total_present'] = $_POST['pday_'.$all_attend[$i]['emp_id']];
	//	echo $all_attend[$i]['emp_id'];echo '<br>';

          if($all_attend[$i]['manual_attendance_flag']=='K'){
		  
            $memp = $this->Admin_model->get_Marked_Emp_attendance($all_attend[$i]['emp_id'],$this->data['attend_date']);
                   
				   $all_attend[$i]['total_outduty']=$memp[0]['total_outduty'];
                   $all_attend[$i]['total_CL']=$memp[0]['CL'];
                   $all_attend[$i]['total_ML']=$memp[0]['ML'];
                   $all_attend[$i]['total_EL']=$memp[0]['EL'];
                   $all_attend[$i]['total_Coff']=$memp[0]['C-Off'];
                   $all_attend[$i]['total_SL']=$memp[0]['SL'];
                   $all_attend[$i]['total_VL']=$memp[0]['VL'];
                   $all_attend[$i]['total_leave']=$memp[0]['leaves'];  
				   $all_attend[$i]['total_WFH']=$memp[0]['WFH'];
               }else{
                   $all_attend[$i]['total_outduty']=$od;
                   $all_attend[$i]['total_CL']=$temp['CL'];
                   $all_attend[$i]['total_ML']=$temp['ML'];
                   $all_attend[$i]['total_EL']=$temp['EL'];
                   $all_attend[$i]['total_Coff']=$temp['C-OFF'];
                   $all_attend[$i]['total_SL']=$temp['SL'];
                   $all_attend[$i]['total_VL']=$temp['VL'];
                   $all_attend[$i]['total_leave']=$temp['leave'];
				   $all_attend[$i]['total_WFH']=$temp['WFH'];
                }  
				
				
			   	//$all_attend[$i]['total_LWP']=$_POST['LWP_'.$all_attend[$i]['emp_id']]; 
                   $all_attend[$i]['total_LWP']=$_POST['LWP_'.$all_attend[$i]['emp_id']];                
                  // $all_attend[$i]['month_days']=$totaldays;
                   $all_attend[$i]['working_days']=$_POST['wday_'.$all_attend[$i]['emp_id']];
                   $all_attend[$i]['sunday']=$_POST['sun_'.$all_attend[$i]['emp_id']];
                   $all_attend[$i]['holiday']=$_POST['holi_'.$all_attend[$i]['emp_id']];
                   $all_attend[$i]['totalp']=$_POST['tday_'.$all_attend[$i]['emp_id']];
        } /// FOR llop
	//	exit();
         $this->data['all_attend']= $all_attend;
     //echo '<pre>';  print_r($all_attend);echo '<pre/>';exit;
         $result=$this->Admin_model->add_update_final_monthly_attendance($all_attend,$this->data['attend_date']);
		 ////
  }else{
	  
	 
	 
         $this->data['sbtn'] = '0';
              $check_dt=$this->Admin_model->checkAvailableAttendance($_POST['rdate']);
			
              if(!empty($check_dt)){
           /*calculate sundays and holidyas of a serched month and total working days,present days*/
                  $attend_date= $this->data['attend_date'];
                  $date =  $attend_date."-01";
                   $lt=date('t', strtotime($attend_date)); //get end date of month
                   $end = $attend_date."-".$lt;
                   $time=strtotime($attend_date);
                   $d = date_parse_from_format("Y-m-d",$attend_date);
                    $msearch=$d["month"];//month number
                   $ysearch=date("Y",strtotime($attend_date));
                   $monthName = date('F', mktime(0, 0, 0, $msearch, 10));// month name
                    $cm = date('m');
             if($cm == $msearch){
              $totaldays= date('d')-1; 
             }else{
                          $totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);
                         }
                        // echo $total_days;
                   //$totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);//total month days
                    $i=1;
                   //calculate number of sundays in given month
                  //  $total_holiday=$this->Admin_model->getTotalHoliday($msearch,$ysearch);
                       
                  /***********************************end**************************************/
                  
                  if($cm == $msearch){
              $totaldays= date('d')-1; 
             }else{
                          $totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);
                         }
                     //$totaldays=7;
              $all_attend=$this->Admin_model->getAllTotalAttendance1($_POST);
			 // print_r($all_attend);
              //echo count($all_attend);exit;
				for($i=0;$i<count($all_attend);$i++){
				$total_holiday = $this->Admin_model->getHolidayListMonthWiseFromPunching($all_attend[$i]['emp_id'],$this->data['attend_date']);
				// print_r($total_holiday);
				$working_days=$_POST['wday_'.$all_attend[$i]['emp_id']];
				$temp=$this->Admin_model->getremainingAllLeaveCountByEmp1($all_attend[$i]['emp_id'],$this->data['attend_date']);
			  
				//print_r($temp);
				//exit;
				$temp_pret =$this->Admin_model->getPresentCountByEmp($all_attend[$i]['emp_id'],$this->data['attend_date']);
	
				$od = $this->Admin_model->getremainingAllODCountByEmp1($all_attend[$i]['emp_id'],$this->data['attend_date']);
				$temp1=$this->Admin_model->getAllLeaveHalfDayCountByEmpID($all_attend[$i]['emp_id'],$this->data['attend_date']);
				if($all_attend[$i]['gender']=='male'){ $f = 'Mr.';}else if($all_attend[$i]['gender']=='female'){ $f = 'Mrs.';}
				$all_attend[$i]['total_present1'] = $temp_pret[0]['total_present'];
				$all_attend[$i]['total_present'] = $_POST['pday_'.$all_attend[$i]['emp_id']];
				$all_attend[$i]['total_present_half']= $temp1;
				$all_attend[$i]['UserId'] = $all_attend[$i]['emp_id'];

				$all_attend[$i]['ename'] = $f." ".$all_attend[$i]['fname']." ".$all_attend[$i]['lname'];
				if($all_attend[$i]['manual_attendance_flag']=='Khh'){
				$memp = $this->Admin_model->get_Marked_Emp_attendance($all_attend[$i]['emp_id'],$this->data['attend_date']);

				$all_attend[$i]['total_outduty']=$memp[0]['total_outduty'];
				$all_attend[$i]['total_CL']=$memp[0]['CL'];
				$all_attend[$i]['total_ML']=$memp[0]['ML'];
				$all_attend[$i]['total_EL']=$memp[0]['EL'];
				$all_attend[$i]['total_Coff']=$memp[0]['C-Off'];
				$all_attend[$i]['total_SL']=$memp[0]['SL'];
				$all_attend[$i]['total_VL']=$memp[0]['VL'];
				$all_attend[$i]['total_leave']=$memp[0]['leaves'];  
				$all_attend[$i]['total_WFH']=$memp[0]['WFH'];
				}
				
				else{
					
					

				$all_attend[$i]['total_outduty']=$od;
				$all_attend[$i]['total_CL']=$temp['CL'];
				$all_attend[$i]['total_ML']=$temp['ML'];
				$all_attend[$i]['total_EL']=$temp['EL'];
				$all_attend[$i]['total_Coff']=$temp['C-OFF'];
				$all_attend[$i]['total_SL']=$temp['SL'];
				$all_attend[$i]['total_VL']=$temp['VL'];
				$all_attend[$i]['total_leave']=$temp['leave'];
				$all_attend[$i]['total_WFH']=$temp['WFH'];
				}               

				$all_attend[$i]['total_LWP']=$_POST['LWP_'.$all_attend[$i]['emp_id']];                
				$all_attend[$i]['month_days']=$totaldays;
				$all_attend[$i]['working_days']=$working_days;
				$all_attend[$i]['sunday']=$_POST['sun_'.$all_attend[$i]['emp_id']];
				$all_attend[$i]['holiday']=$_POST['holi_'.$all_attend[$i]['emp_id']];
				$all_attend[$i]['totalp']=$_POST['tday_'.$all_attend[$i]['emp_id']];
				
				}


               
              $this->data['all_attend']= $all_attend;
			  
			  
               
         }

     

        $result=$this->Admin_model->add_update_final_monthly_attendance($all_attend,$this->data['attend_date']);
		
		
		
        }
       
	   
	   
	    redirect('admin/total_monthly_attendance');
       // redirect('admin/staff_manual_attendance');
        }
		
		
		
    //day wise attendance
    public function daywise_attendance(){
    
        $this->load->view('header',$this->data);
        $this->data['school_list']= $this->Admin_model->getAllschool();  
         $this->data['dept_list']= $this->Admin_model->getAllDepartments();      
        
        
         if(isset($_POST['submit'])){
             
              $this->data['emp_school']=$_POST['emp_school'];
             $this->data['department']=$_POST['department'];
             $this->data['attend_date']=$_POST['attend_date'];
              $check_dt=$this->Admin_model->checkAvailableAttendanceDate($this->data['attend_date'],$_POST['emp_school'],$_POST['department']);
            // print_r($check_dt);
            // exit;
              if(!empty($check_dt)){
                
            $this->data['all_attend']=$this->Admin_model->checkAvailableAttendanceDate($this->data['attend_date'],$_POST['emp_school'],$_POST['department']);       
                
                /* echo"<pre>";print_r($this->data['all_attend']);
                die(); */
         }elseif(empty($check_dt)){
                                  $this->data['all_attend']="";
                                
              }
         }
         $this->load->view($this->view_dir.'daywise_attendance',$this->data); 
        $this->load->view('footer');
        
    }
    
    //staff for maunnal attendance
    public function mark_staff(){
		if($this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==1){
			//echo 1;exit;
		}else{
			redirect('home');
		}
        $this->load->view('header',$this->data);
        $menu = $this->uri->segment(1);
	   $menu1 = $this->uri->segment(2);
	   $this->data['my_privileges'] = $this->retrieve_privileges($menu."/".$menu1);
        $this->data['emp_list']=$this->Admin_model->getEmployeesManual();
        if(isset($_POST['mark'])){
            /* echo"<pre>";print_r($_POST);
            exit;  */
            $marked=$this->Admin_model->mark_Employee_manually($_POST);
            
            if($marked==1){
                $this->session->set_flashdata('message1','Selected employee marked for manual attendance');
                redirect('admin/mark_staff');
            }else{
                $this->session->set_flashdata('message1','');
                redirect('admin/mark_staff');
            }           
        }       
        $this->load->view($this->view_dir.'mark_emp_for_manual_attend',$this->data);
        $this->load->view('footer');
    }
    /**Assign staff manual attendnce for the searched month if other employees
    attendnce is available for that searched month from punching_backup  table**/
    
    public function staff_manual_attendance(){
        $this->load->view('header',$this->data);
        /* $this->data['school_list']= $this->Admin_model->getAllschool();   
         $this->data['dept_list']= $this->Admin_model->getAllDepartments();      
         $this->data['desig_list']= $this->Admin_model->getAllDesignations(); */
         if(isset($_POST['view'])){
             //
             $jdt=$this->Admin_model->checkpunchingBackup_for_manualattend($_POST['for_month_year']);
           
         if($jdt==1){
                 $chk = $this->Admin_model->check_monthly_manual_Emp_attendance($_POST['for_month_year']);
                 if(empty($chk)){
        $this->data['emp_list']=$this->Admin_model->get_Marked_Emp_Manual($_POST['for_month_year']);
        }else{
          $this->data['emp_list'] = $chk;
        }
        /*  //first check the attendnce is available for serched month year
         for($i=0;$i<count($this->data['emp_list']);$i++){
            $this->Admin_model->get_Marked_Emp_attendance(); 
         } */
         
$this->data['attend_date']=$_POST['for_month_year'];    
         }
         if($jdt==0){
            $this->session->set_flashdata('message1','Sorry You can not add attendce now.You have to wait till Month end'); 
         }
          
         }
        
        // print_r($this->data['emp_list']);exit;
         if(isset($_POST['attend_submit'])){
             
             $temp1=$_POST;
            // print_r($temp1);
             $temp=array();
             for($i=0;$i<count($temp1['eid']);$i++){                
                 $temp[$i]['eid']=$temp1['eid'][$i];
                 $temp[$i]['ename']=$temp1['ename'][$i];
                 $temp[$i]['month_days']=$temp1['month_days'][$i];
                 $temp[$i]['present_days']=$temp1['present_days'][$i];
                 $temp[$i]['working_days']=$temp1['working_days'][$i];
                 $temp[$i]['sunday']=$temp1['sundays'][$i];
                 $temp[$i]['holiday']=$temp1['holidays'][$i];
                 $temp[$i]['OD']=$temp1['OD'][$i];
                 $temp[$i]['CL']=$temp1['CL'][$i];
                 $temp[$i]['ML']=$temp1['ML'][$i];
                 $temp[$i]['EL']=$temp1['EL'][$i];
                 $temp[$i]['C-Off']=$temp1['C-Off'][$i];
                 $temp[$i]['SL']=$temp1['SL'][$i];
                 $temp[$i]['VL']=$temp1['VL'][$i];
                 $temp[$i]['Leave']=$temp1['Leave'][$i];
                 $temp[$i]['LWP']=$temp1['LWP'][$i];
				 $temp[$i]['WFH']=$temp1['WFH'][$i];
               //  $temp[$i]['STL']=$temp1['STL'][$i];
                 $temp[$i]['Total']=$temp1['Total'][$i];                 
             }
            /* echo"<pre>";print_r($temp);
             die();*/ 
            $add=$this->Admin_model->add_upd_Emp_Manual_Attendance($temp,$_POST['attend_date']);
            if($add==1){
                $this->session->set_flashdata('message1','Employee manual attendance added successfully...');
                redirect('admin/staff_manual_attendance');
            }
         }
        $this->load->view($this->view_dir.'assign_emp_manual_attend',$this->data);
        $this->load->view('footer');
    }
    
    public function getEmpListMarked_Emp_Manual(){
        $school=$_REQUEST['school'];
        $department=$_REQUEST['department'];
        $this->data['emp_list']=$this->Admin_model->get_Marked_Emp_Manual($school,$department);
        $emp=$this->data['emp_list'];
        if(!empty($emp)){
    echo "<option  value='' >Select Employee </option>";
    foreach($emp as $key=>$val ){
    echo "<option  value=".$emp[$key]['emp_id'].">".$emp[$key]['fname']." ".$emp[$key]['mname']." ".$emp[$key]['lname']."</option>";
    }
}else{
    echo "<option  value='' >No Employee Marked For Manual Attendance</option>";
}
    }
    
    //Staff Leave Allocation
    public function staff_leave_allocation_list(){
        $this->load->view('header',$this->data);
        $this->data['all_emp_leave']=$this->Admin_model->fetchAllEmpLeaves();
        /* echo"<pre>";print_r($this->data['all_emp_leave']);
        die(); */
        $this->load->view($this->view_dir.'staff_leave_allocation_list',$this->data);
        $this->load->view('footer');
        
    }
    public function staff_leave_allocation(){
         $this->load->view('header',$this->data);
         $this->data['school_list']= $this->Admin_model->getAllschool();     
         $this->data['dept_list']= $this->Admin_model->getAllDepartments();      
         $this->data['desig_list']= $this->Admin_model->getAllDesignations(); 
         $this->data['get_quarter']=$this->Admin_model->getCurrentQuarterNo();
         if(isset($_REQUEST['lv_id'])){
             $leave_track_id=$_REQUEST['lv_id'];
             $this->data['emp_leave_info']=$this->Admin_model->getEmpleave_track($leave_track_id);
            // print_r($this->data['emp_leave_info']);exit;
         }
         if(isset($_POST['submit'])){
            //print_r($_POST);exit;
             if(isset($_POST['inupdate'])){
                 $update=$this->Admin_model->update_allocated_StaffLeave($_POST);
            if($update==1){
                $this->session->set_flashdata('message1','Employee Leaves updated successsfully');
                redirect('admin/staff_leave_allocation_list');
            } 
             }else{
                 $add=$this->Admin_model->allocateStaffLeave($_POST);
            if($add==1){
                $this->session->set_flashdata('message1','Employee Leaves added successsfully');
                redirect('admin/staff_leave_allocation_list');
            } 
                 
             }
            
         }
      
         
        $this->load->view($this->view_dir.'staff_leave_allocation',$this->data);
        $this->load->view('footer');    
    }
    public function getjoiningdtEmp(){
        $emp_id=$_REQUEST['empl_id'];
        $jdt=$this->Admin_model->getEmpJoiningdt($emp_id);
        echo"<input type='hidden' name='joiningDate' value='".$jdt."'>";
    }
    //function to check punching backup for data available of searched date
    public function checkpunchingBackup(){
        $search_dt=$_REQUEST['search_dt'];
        $jdt=$this->Admin_model->checkpunchingBackup_for_manualattend($search_dt);
        if($jdt==1){
            echo "continue";            
        }elseif($jdt==0){
            echo "stop";
        }
    //  echo"<input type='hidden' name='joiningDate' value='".$jdt."'>";
    }
    
     public function search()
    {        
        $para=$this->input->post("title");
        $emp_details=  $this->Admin_model->getEmployeeById($para,'Y'); 
        echo json_encode(array("emp_details"=>$emp_details));
    } 
    
     public function table_exporttopdf(){
    //error_reporting(E_ALL);
        $content = '<style>

.attexl table th{
    border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.add-table tr td{border:0px}

.attexl table  td{
     border: 1px solid black;
    padding: 5px;border-collapse: collapse
}
.bottom-table{padding:50px 0 20px 0}
.bottom-table-2{padding-top:20px}
</style>

<div class="row">

<div class="col-lg-12">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="100"><img src="'.site_url().'assets/images/lg.png" alt="Sandip University" class="img-responsive"></td>
    <td valign="top" align="center">
    <span style="font-size:25px;text-align:center"><b>Sandip University</b></span><br>
    <span style="text-align:center;font-size:11px">Trimbak Road, A/p - Mahiravani, Nashik – 422 213</span><br>
    <span style="font-size:10px;text-align:center">Website : http://www.sandipuniversity.com | Email : info@sandipuniversity.com </span><br>
    <span style="font-size:15px;;text-align:center"><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></span>
    </td>
  </tr>
</table>
<hr  style="border-width:1px;">

</div>
<div class="col-lg-12">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td align="right">
  <strong>Date :</strong> ___ /___ /_________
  </td>
  </tr>
  </table>
  
</div>
</div>';
       // echo $_REQUEST['datatodisplay'];
       // exit;
        $content .=$_REQUEST['datatodisplay'];
        $content .= '
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="bottom-table"><strong>Prepared by:</strong></td>
    <td align="center" class="bottom-table"><strong>Varified by:</strong></td>
    <td align="center" class="bottom-table"><strong>Approved by:</strong></td>
  </tr>
  <tr>
    <td align="center" class="bottom-table-2"><strong>Establishment Clerk</strong></td>
    <td align="center" class="bottom-table-2"><strong>O.S.D.</strong></td>
    <td align="center" class="bottom-table-2"><strong>Register</strong></td>
  </tr>
  <tr>
    <td align="center">Sandip University</td>
    <td align="center">Sandip University</td>
    <td align="center">Sandip University</td>
  </tr>
</table>

        
        
        ';
        $html = $content; // render the view into HTML

    
 $this->load->library('M_pdf');
   
    //$data['result'] = $this->mod->getReport();

 
        $mpdf=new mPDF();
        
    $this->m_pdf->pdf=new mPDF('c','A4','','5',10,10,10,10,10,10);
    
    
    
    $this->m_pdf->pdf->WriteHTML($html);
$pdfFilePath = 'MonthlyAttendance';
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
    }
    
    
     public function inout_table_exporttopdf($data){
	 //echo'ffff';exit;
		ini_set('max_execution_time', 0); 
ini_set('memory_limit', '-1');
               $html =  $this->load->view($this->view_dir.'inout_pdf_export',$data,true);

	//echo'sdsd';exit;
	// render the view into HTML
	  $htmll =  $this->load->view($this->view_dir.'inout_monthly_insert',$data,true); // render the view into HTML
	  
	 
//=exit();
 $this->load->library('M_pdf');
 ob_clean();
 //ini_set('error_reporting', E_ALL);
        $mpdf=new mPDF();
        
      $this->m_pdf->pdf=new mPDF('L','A4-L','','',5,10,5,17,5,10);

   $footer = '<br/><br/><div style="font-size:7.5px;text-align:center;" >P - Present Days | S - Sunday | H - Holiday | LWP - Leave Without Pay | OD - Outdoor Duty | OFFICIAL - Outdoor Duty | Lv - Leave | CO - C-OFF | CL - Casual leave | SL - Special leave  |  EL - Earned leave  | ML - Medical leave | VL - Vacation leave | Leave(*) - Leave+LWP | SP - Special Case | JD - Joining Day | BL - Bus Late | SD - Special Day </div><div style="font-size:12px;text-align:center;" ><b>Note-: Continuous LWP case sunday and holiday not considered.</b> </div>';
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
		$category=$_REQUEST['category_type'];
        $this->data['emp_list']=$this->Admin_model->getSchoolDepartmentWiseEmployeeList($school,$department,'',$category);
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

//this function will return Active/Inactive/Resigned Employees by School and department //updated by kishor 21/06/2019
	public function getAllTypeEmpListbyDepartmentSchool_attendance(){
		$school=$_REQUEST['school'];
		$department=$_REQUEST['department'];
		$this->data['emp_list']=$this->Admin_model->getSchoolDepartmentWiseAllTypeEmployeeList($school,$department);
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
  
	
public function total_attendance_export($data,$mon){
    //  print_r($data);
   // exit;
ini_set('memory_limit', '-1');
      $html =  $this->load->view($this->view_dir.'total_attendance_report',$data,true); // render the view into HTML
//exit;
    
    $this->load->library('M_pdf');
 ob_clean();
 //ini_set('error_reporting', E_ALL);
        $mpdf=new mPDF();
        
    $this->m_pdf->pdf=new mPDF('P','A4','','5',5,5,5,5,5,5);
    
    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
    
    $this->m_pdf->pdf->WriteHTML($html);
$pdfFilePath = " Montly_Attendance_".date('F_Y',strtotime($mon)).".pdf";
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "D");  
    }
    
    public function employee_list_export($status){
	  if($status!='reg'){
     // ini_set('error_reporting', E_ALL);
             $this->data['emp_list'] = $this->Admin_model->getEmployees1($status);
          }else{
    $this->data['emp_list'] = $this->Admin_model->getRegEmployees();
          }
         //print_r($emp_list);exit;
         $this->load->view($this->view_dir.'/reports/employee_list_exl_export',$this->data); 
				  
	}
  public function employee_data_transfer_add(){
     $this->load->view('header',$this->data);
    $this->load->view($this->view_dir.'emp_data_transfer',$this->data);
        $this->load->view('footer');
  }
    public function add_emp_data_transfer(){
    $check=$this->Admin_model->checkEmployeeIDAvailable($_POST['new_empid']);
            if(!empty($check)){
                $this->session->set_flashdata('message1','Employee Id Is already exits......');
                redirect('admin/employee_data_transfer_add');
            }else{
        $temp=array();
           
     $emp = $this->Admin_model->get_emp_data_transfer($_POST);
   $this->session->set_flashdata('message1','Employee Data transfer successfully.');
   redirect('admin/employee_data_transfer');
      }
   
  }
  public function employee_data_transfer(){
     $this->load->view('header',$this->data);
     $menu = $this->uri->segment(1);
   $menu1 = $this->uri->segment(2);
   $this->data['my_privileges'] = $this->retrieve_privileges($menu."/".$menu1);
     $this->data['emplist']=$this->Admin_model->getEmployeesDataTransfer();
    $this->load->view($this->view_dir.'employee_data_transfer',$this->data);
        $this->load->view('footer');
  }
  
    public function employee_multi_data_transfer_add(){
     $this->load->view('header',$this->data);
	$this->data['emp_list']= $this->Admin_model->getEmployees(0,0,'N');
     $this->load->view($this->view_dir.'emp_multi_data_transfer',$this->data);
     $this->load->view('footer');
  }
    public function employee_multi_data_transfer_search(){  

        $this->load->view('header',$this->data);
        $this->data['emp_list']= $this->Admin_model->getEmployees(0,0,'N');
      if (isset($_POST) && !empty($_POST['empsid']) && !empty($_POST['jdate'])) {	
		$this->data['all_attend']=$this->Admin_model->fetch_employee_data_for_transfer($_POST); 
         $this->data['jdate']=$_POST['jdate'];		
	  }else{

		 $_SESSION['status']='Employee ID and Joining Date are Required !!!!!';
	  }
        		
		$this->load->view($this->view_dir.'emp_multi_data_transfer',$this->data); 
        $this->load->view('footer');  
    }
	
	public function save_multi_emp_data_transfer(){
      if(isset($_POST) && !empty($_POST['emp_id'])){
        $emp_id = $_POST['emp_id'];
        $m = '';
        foreach($emp_id as $empid){
            $newempid = $_POST['newid_'.$empid.''];
            
            // Backend validation for newempid (numeric and between 4 to 10 digits)
            if(!preg_match('/^\d{4,10}$/', $newempid)){
                $m.= "Invalid Employee ID ".$newempid." for ID ".$empid.". Must be numeric and between 4 to 10 digits.";
                $m.="<br>";
                continue; // Skip this iteration if validation fails
            }
            
            $check = $this->Admin_model->checkEmployeeIDAvailable($newempid);
            if(!empty($check)){
                $m.= "Employee ID ".$newempid." already exists for ID ".$empid."";
                $m.="<br>";
            } else {
                $data['staffid'] = $empid;
                $data['new_empid'] = $newempid;
                $data['new_jdate'] = $_POST['join_date'];
                $emp = $this->Admin_model->get_emp_data_transfer($data);
            } 
        }
        $_SESSION['errors'] = nl2br($m);
    } else {
        $_SESSION['errors'] = nl2br('Something Went Wrong!!!!');
    }
                
    redirect('admin/employee_data_transfer');
  }


  
  
  
  
  public function employee_attendance_synchronise(){
	  $this->load->view('header',$this->data);
     $this->data['emplist']=$this->Admin_model->getSchoolDepartmentWiseEmployeeList1();
    $this->load->view($this->view_dir.'employee_attendance_synchronise',$this->data);
        $this->load->view('footer');
  }
  public function get_month_date($mon){
	  $mone = explode('-',$mon);
	  $d=cal_days_in_month(CAL_GREGORIAN,$mone[1],$mone[0]);
	  echo "<table class='table table-bordered'>";
	  echo "<thead>";
	  
	  echo "<th><input type='checkbox' onclick='check_all_date()' name='chkal' value='1' /></th>";
	  echo "<th>Day</th><th>Date</th>";
	  echo "</thead><tbody>";
	  for($i=1;$i<=$d;$i++){
		  echo "<tr id='dt_".$i."'>";
		  echo "<td><input type='checkbox' onclick='get_sel_chk_dt(".$i.")' id='".$i."' name='datelist[]' value='".date('d-m-Y',strtotime($i."-".$mone[1]."-".$mone[0]))."' /></td>";
		  echo "<td>".date('l',strtotime($i."-".$mone[1]."-".$mone[0]))."</td>";
		  echo "<td>".date('d-m-Y',strtotime($i."-".$mone[1]."-".$mone[0]))."</td>";
		  echo "</tr>";
	  }
	  
	  echo '</tbody></table>';
  }
  public function synchronise_attendance_emp(){
  	//exit;
    ini_set('max_execution_time',0);
	 $ck = $this->Admin_model->run_cron_attendance($_POST);
if($ck == 'err'){
$this->session->set_flashdata('message1','Sorry, No Attendance Synchronise.');
}else{
	$this->session->set_flashdata('message1','Attendance Synchronise Successfully.');
}
	  redirect('admin/employee_attendance_synchronise');
  }
  public function employee_attendance_punchinglog(){
	  $this->load->view('header',$this->data);
    
    $this->load->view($this->view_dir.'employee_attendance_punchin',$this->data);
        $this->load->view('footer');
  }
  public function get_month_punching_date($mon,$emp){
  	$emp = $this->Admin_model->get_emp_punchin_month($mon,$emp);
  	echo "<table class='table table-bordered'>";
	  echo "<thead>";
	  
	  echo "<th>Sr.No</th>";
	  echo "<th>Date</th><th>Time</th>";
	  echo "</thead><tbody>";
	  $i=1;
	  foreach($emp as $val){
		  echo "<tr >";
		  echo "<td>".$i."</td>";
		 
		  echo "<td>".date('d-m-Y',strtotime($val['LogDate']))."</td>";
		   echo "<td>".date('H:i',strtotime($val['LogDate']))."</td>";
		  echo "</tr>";
		  $i++;
	  }
	  
	  echo '</tbody></table>';
  }

  public function get_emp_list_bystafftyp($tp=''){
	  $type=$this->input->post('type');
    $emp = $this->Admin_model->get_emp_bystafftype($type);
    echo "<div style='height:400px;overflow-y:scroll;'><table class='table table-hover' >";
    echo "<thead><tr><th>Sr.No</th><th>Emp ID</th><th>Name</th></tr></thead><tbody>";
    $i = 1;
    foreach($emp as $val){
      echo "<tr>";
      echo "<td>".$i."</td>";
      echo "<td>".$val['emp_id']."</td>";
      echo "<td>".$val['fname']." ".$val['lname']."</td>";
      echo "</tr>";
      $i++;
    }
    echo "</tbody></table></div>";
  }
  public function view_visiting_attendance(){
    //print_r($_POST);
    //ini_set('error_reporting', E_ALL);
    ini_set('memory_limit', '-1');
     $this->load->view('header',$this->data);
    $check_dt=$this->Admin_model->checkAvailableAttendance($_POST['attend_datev']);
    //print_r($check_dt);
    $this->data['attend_date'] = $_POST['attend_datev'];
    if(!empty($check_dt)){
      if(empty($_POST['empsidv'])){
        $emplist1 = $this->Admin_model->getVisitingEmployees1('Y');
        $emplist = array();
        foreach ($emplist1 as  $value) {
          $emplist[] = $value['emp_id'];
        }
      }else{
           $emplist = $_POST['empsidv'];
      }
     // print_r($emplist);exit;
      foreach($emplist as $val){
      $this->data['attendance'][$val] = $this->Admin_model->get_visiting_attendance($_POST['attend_datev'],$val);
      }
      
    }
   // print_r($this->data['attendance']);exit;
    // ini_set('memory_limit', '-1');
      $html =  $this->load->view($this->view_dir.'inout_visiting_pdf_export',$this->data,true); // render the view into HTML
 //echo $html ;exit;
 $this->load->library('M_pdf');
 ob_clean();
 //ini_set('error_reporting', E_ALL);
        $mpdf=new mPDF();
        
      $this->m_pdf->pdf=new mPDF('L','A4-L','','',5,10,5,5,5,5);

  // $footer = '<div style="font-size:9px;text-align:center;" >P - Present Days | S - Sunday | H - Holiday | LWP - Leave Without Pay | OD - Outdoor Duty | Lv - Leave | CO - C-OFF | CL - Casual leave | SL - Sick leave  |  EL - Earned leave  | ML - Medical leave | VL - Vacation leave | Leave(*) - Leave+LWP </div>';
  //$this->m_pdf->pdf->SetHTMLFooter($footer);
  
  $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
    
    $this->m_pdf->pdf->WriteHTML($html);
$pdfFilePath = "VisitingStaffMonthInOutTimeReport_".date('F_Y',strtotime($_POST['attend_datev'])).".pdf";
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "D");
     //$this->load->view('footer');    
  }
 

 public function final_submit_Attendance(){
    $fdt = $this->Admin_model->Add_final_status_attendance($_POST);
    if($fdt=='updated'){
       $this->session->set_flashdata('message1','Monthly Attendance Submited successfully...');
           redirect('admin/total_monthly_attendance');
    }else{
       $this->session->set_flashdata('message1','Sorry, Monthly Attendance is not Submited successfully...');
 redirect('admin/total_monthly_attendance');
    }
  }
   public function getvisitinglist(){
     $vlist = $this->Admin_model->get_visiting_list();
     foreach($vlist as $val){
       echo "<option value='v_".$val['emp_id']."'>".$val['fname']." ".$val['lname']."</option>";
     }
     
   }
   
   
   
   
   
     public function get_employee_list_of_specific_stream_semester(){
        $stream_id=$_REQUEST['stream_id'];
        $academic_year=$_REQUEST['academic_year'];
		$semester=$_REQUEST['semester'];
        $frmdt= $_REQUEST['from_date'];//leave from date
        $todt=$_REQUEST['to_date'];//leave to date
		$division=$_REQUEST['division'];
		//print_r($division);
		//exit;
		//$division = explode(',', $division);
		  $begin = new DateTime($frmdt);
		 $end = new DateTime($todt.' +1 day');
		 $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
		 $std='';
		 $std.='<option value="" >Select</option>';
		foreach($daterange as $date){
			$std.='<option value="'.$date->format("d-m-Y").'" >'.$date->format("d-m-Y").'</option>';
		}
		 $div.='<option value="" >Select</option>';
		foreach($division as $data){
			$div.='<option value="'.$data.'" >'.$data.'</option>';
		}
         $str=''; 
        $this->data['emp_list']=$this->Admin_model->get_employee_list_of_specific_stream_semester($stream_id,$academic_year,$semester,$division);
        $emp=$this->data['emp_list'];
        if(!empty($emp)){
         $str.="<thead>
<th>Select</th>
<th>Staff Id</th>
<th>Name</th>
<!--<th>From Date</th>
<th>To Date</th>
<th>Divison</th>-->
</thead>"; 
      foreach($emp as $key=>$val ){
		  $emp_id=$emp[$key]['emp_id'];
		 $str.="<tr><td><input type='checkbox' id='".$emp[$key]['emp_id']."' value='".$emp[$key]['emp_id']."'    name='emp[ch][]'></td><td>".$emp[$key]['emp_id']."</td><td>".$emp[$key]['fac_name']."</td>";
		 $str.='<!--<td><select  style="width:100%" name="emp['.$emp_id.'][fromdt]" class="form-control ms" id="fromdt'.$emp[$key]['emp_id'].'" > '.$std.'</select></td><td><select  class="form-control ms"  style="width:100%" name="emp['.$emp_id.'][todt]" id="todt'.$emp[$key]['emp_id'].'"  >'.$std.'</select></td><td><select multiple class="form-control ms"  style="width:100%" name="emp['.$emp_id.'][div]" id="div'.$emp[$key]['emp_id'].'"  >'.$div.'</select></td>--></tr>';
	  }		  
}else{
     $str.="<tr><td colspan='3'>No Employee Availabe in this department</td></tr>";;
}
    echo $str;
    }
	
	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function total_datewise_attendance(){
    
        $this->load->view('header',$this->data);
         $this->data['school_list']= $this->Admin_model->getAllschool();  
         $this->data['dept_list']= $this->Admin_model->getAllDepartments();      
         $this->data['desig_list']= $this->Admin_model->getAllDesignations();
        $this->data['emp_list']= $this->Admin_model->getEmployees();
  //  print_r($_POST);
             $this->data['emp_school']=$_POST['emp_school'];
              $this->data['department']=$_POST['department'];
              $this->data['attend_date']=$_POST['attend_date'];
			  
         if(isset($_POST['submit'])){
             
             
      // exit;
       $chk_tab = $this->Admin_model->checkFinalAttendance($_POST);
      
       if(!empty($chk_tab)){         
         $this->data['all_attend']=$this->Admin_model->fetch_employee_monthly($_POST);           
            
         $this->data['sbtn'] = '1';
       }else{
        $monatt = $this->Admin_model->checkMonthAttendance($_POST);
   
      if(empty($monatt)){
        $this->data['sbtn'] = '0';
              $check_dt=$this->Admin_model->checkAvailableAttendance($this->data['attend_date']);
			  
              if(!empty($check_dt)){
				 
                  /*calculate sundays and holidyas of a serched month and total working days,present days*/
                  $attend_date= $this->data['attend_date'];
                  $date =  $attend_date."-01";
                   $lt=date('t', strtotime($attend_date)); //get end date of month
                   $end = $attend_date."-".$lt;
                   $time=strtotime($attend_date);
                   $d = date_parse_from_format("Y-m-d",$attend_date);
                    $msearch=$d["month"];//month number
                   $ysearch=date("Y",strtotime($attend_date));
                   $monthName = date('F', mktime(0, 0, 0, $msearch, 10));// month name
                    $cm = date('m');
             if($cm == $msearch){
              $totaldays= date('d')-1; 
             }else{
                          $totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);
                         }
                        // echo $total_days;
                   //$totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);//total month days
                    $i=1;
                   //calculate number of sundays in given month
                 //  $total_holiday=$this->Admin_model->getTotalHoliday($msearch,$ysearch);
                       
                  /***********************************end**************************************/
                  
                  if($cm == $msearch){
              $totaldays= date('d')-1; 
             }else{
                          $totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);
                         }
                         //echo $totaldays;
                  
              $all_attend=$this->Admin_model->getAllTotalAttendance1($_POST);
			  //echo "<pre>";
            // print_r($all_attend);
			// echo "ss";
//exit;
              for($i=0;$i<count($all_attend);$i++){

              	//echo $all_attend[$i]['manual_attendance_flag'];
              	//echo  $all_attend[$i]['emp_id'];
                if($all_attend[$i]['manual_attendance_flag']=='Y'){
$mand = $this->Admin_model->get_Marked_Emp_attendance($all_attend[$i]['emp_id'],$this->data['attend_date']);
//print_r($mand);

if($all_attend[$i]['gender']=='male'){ $f = 'Mr.';}else if($all_attend[$i]['gender']=='female'){ $f = 'Mrs.';}
   //  if($temp_pret[0]['total_present'] != '0'){
     $all_attend[$i]['total_present'] = $mand[0]['total_present'];
     $all_attend[$i]['total'] = $mand[0]['Total'];
          $all_attend[$i]['UserId'] = $all_attend[$i]['emp_id'];
          $all_attend[$i]['ename'] = $f." ".$all_attend[$i]['fname']." ".$all_attend[$i]['lname'];
          $all_attend[$i]['total_outduty']=$mand[0]['total_outduty'];
          $all_attend[$i]['total_CL']=$mand[0]['CL'];
                   $all_attend[$i]['total_ML']=$mand[0]['ML'];
                   $all_attend[$i]['total_EL']=$mand[0]['EL'];
                   $all_attend[$i]['total_Coff']=$mand[0]['C-Off'];
                   $all_attend[$i]['total_SL']=$mand[0]['SL'];
                   $all_attend[$i]['total_VL']=$mand[0]['VL'];
                   $all_attend[$i]['total_leave']=$mand[0]['leaves'];               
                   $all_attend[$i]['total_LWP']=$mand[0]['LWP'];                   
                   $all_attend[$i]['month_days']=$totaldays; 
                   $all_attend[$i]['working_days']=$mand[0]['working_days']; 
                   $all_attend[$i]['sunday']=$mand[0]['sunday']; 
                   $all_attend[$i]['holiday']=$mand[0]['holiday']; 

                }else{

                 $total_holiday = $this->Admin_model->getHolidayListMonthWiseFromPunching($all_attend[$i]['emp_id'],$this->data['attend_date']);
                        // print_r($total_holiday);
                
                
        $working_days=$totaldays-($total_holiday['sunday']+$total_holiday['holiday']);
                  $temp=$this->Admin_model->getremainingAllLeaveCountByEmp1($all_attend[$i]['emp_id'],$this->data['attend_date']);
                  //print_r($temp);
          //exit;
                       $temp_pret =$this->Admin_model->getPresentCountByEmp($all_attend[$i]['emp_id'],$this->data['attend_date']);
                 
      
                  $od = $this->Admin_model->getremainingAllODCountByEmp1($all_attend[$i]['emp_id'],$this->data['attend_date']);
                  $temp1=$this->Admin_model->getAllLeaveHalfDayCountByEmpID($all_attend[$i]['emp_id'],$this->data['attend_date']);
    
if($all_attend[$i]['gender']=='male'){ $f = 'Mr.';}else if($all_attend[$i]['gender']=='female'){ $f = 'Mrs.';}
   //  if($temp_pret[0]['total_present'] != '0'){
     $all_attend[$i]['total_present'] = $temp1+$temp_pret[0]['total_present'];
      $all_attend[$i]['total_present_half']= $temp1;
          $all_attend[$i]['UserId'] = $all_attend[$i]['emp_id'];
          $all_attend[$i]['ename'] = $f." ".$all_attend[$i]['fname']." ".$all_attend[$i]['lname'];
          $all_attend[$i]['total_outduty']=$od;
          $all_attend[$i]['total_CL']=$temp['CL'];
                   $all_attend[$i]['total_ML']=$temp['ML'];
                   $all_attend[$i]['total_EL']=$temp['EL'];
                   $all_attend[$i]['total_Coff']=$temp['C-OFF'];
                   $all_attend[$i]['total_SL']=$temp['SL'];
                   $all_attend[$i]['total_VL']=$temp['VL'];
                   $all_attend[$i]['total_leave']=$temp['Leave'];               
                   $all_attend[$i]['total_LWP']=$temp['LWP'];                   
                   $all_attend[$i]['month_days']=$totaldays;
                   $all_attend[$i]['working_days']=$working_days;
                   $all_attend[$i]['sunday']=$total_holiday['sunday'];
                   $all_attend[$i]['holiday']=$total_holiday['holiday'];
                   $all_attend[$i]['total'] = $temp1+$temp_pret[0]['total_present']+$temp['EL']+$temp['Leave']+$temp['C-OFF']+$temp['SL']+$temp['VL']+$total_holiday['sunday']+$total_holiday['holiday']+$od+$temp['CL']+$temp['ML'];
              }
              }
                $this->data['all_attend']= $all_attend;
                
         }elseif(empty($check_dt)){
                                  $this->data['all_attend']="";
                                
              }
               }else{
       // $this->data['all_attend'] = $monatt;
                $monatt = $this->Admin_model->checkMonthAttendance1($_POST);
$mcnt = count($monatt);
//print_r($monatt);exit;
for($i=0;$i<$mcnt;$i++){
  //echo $monatt[$i]['UserId'];
  //echo $this->data['attend_date'];
             //    $total_holiday = $this->Admin_model->getHolidayListMonthWiseFromPunching($all_attend[$i]['emp_id'],$this->data['attend_date']);
                        // print_r($total_holiday);
       // $working_days=$totaldays-($total_holiday['sunday']+$total_holiday['holiday']);
                  $temp=$this->Admin_model->getremainingAllLeaveCountByEmp1($monatt[$i]['UserId'],$this->data['attend_date']);
                  //print_r($temp);
          //exit;
                     //  $temp_pret =$this->Admin_model->getPresentCountByEmp($all_attend[$i]['emp_id'],$this->data['attend_date']);
                 
      
                 $od = $this->Admin_model->getremainingAllODCountByEmp1($monatt[$i]['UserId'],$this->data['attend_date']);
                  $temp1=$this->Admin_model->getAllLeaveHalfDayCountByEmpID($monatt[$i]['UserId'],$this->data['attend_date']);
    
if($monatt[$i]['gender']=='male'){ $f = 'Mr.';}else if($monatt[$i]['gender']=='female'){ $f = 'Mrs.';}
   //  if($temp_pret[0]['total_present'] != '0'){
     $all_attend[$i]['total_present'] = $temp1+$monatt[$i]['total_present'];
      $all_attend[$i]['total_present_half']= $temp1;
          $all_attend[$i]['UserId'] = $monatt[$i]['UserId'];
          $all_attend[$i]['ename'] = $f." ".$monatt[$i]['ename'];
          if($monatt[$i]['manual_attendance']=='Y'){
            $memp = $this->Admin_model->get_Marked_Emp_attendance($monatt[$i]['UserId'],$this->data['attend_date']);
         $all_attend[$i]['total_outduty']=$memp[0]['total_outduty'];
          $all_attend[$i]['total_CL']=$memp[0]['CL'];
                   $all_attend[$i]['total_ML']=$memp[0]['ML'];
                   $all_attend[$i]['total_EL']=$memp[0]['EL'];
                   $all_attend[$i]['total_Coff']=$memp[0]['C-Off'];
                   $all_attend[$i]['total_SL']=$memp[0]['SL'];
                   $all_attend[$i]['total_VL']=$memp[0]['VL'];
                   $all_attend[$i]['total_leave']=$memp[0]['leaves'];  
          }else{
          $all_attend[$i]['total_outduty']=$od;
          $all_attend[$i]['total_CL']=$temp['CL'];
                   $all_attend[$i]['total_ML']=$temp['ML'];
                   $all_attend[$i]['total_EL']=$temp['EL'];
                   $all_attend[$i]['total_Coff']=$temp['C-OFF'];
                   $all_attend[$i]['total_SL']=$temp['SL'];
                   $all_attend[$i]['total_VL']=$temp['VL'];
                   $all_attend[$i]['total_leave']=$temp['Leave'];   

                   }            
                   $all_attend[$i]['total_LWP']=$monatt[$i]['LWP'];                   
                   $all_attend[$i]['month_days']=$monatt[$i]['month_days'];
                   $all_attend[$i]['working_days']=$monatt[$i]['working_days'];
                   $all_attend[$i]['sunday']=$monatt[$i]['sunday'];
                   $all_attend[$i]['holiday']=$monatt[$i]['holiday'];
                    $all_attend[$i]['total']=$monatt[$i]['Total'];
              }


$this->data['all_attend'] = $all_attend;


        $this->data['sbtn'] = '2';
      }
         }
     }
   
   if($_POST['exp_t']=='1'){
     $this->total_attendance_export($this->data,$_POST['attend_date']);
   }
         $this->load->view($this->view_dir.'total_attendance_date',$this->data); 
        $this->load->view('footer');
        
    }
////////////////////////////////////////////////////////////////////////////////////////

public function add_update_datewise_attendance(){
	//empolyee_datwise_manual_attendance
	ini_set('max_input_vars', 3000);
	
	/*echo "<pre>";
	$data=file_get_contents('php://input');
	//print_r($data);
	
	$data1=$this->input->post(NULL, FALSE);
	print_r($data1);
	//echo '<br>';
	//echo $uid=$this->session->userdata("uid");
	//echo '<br>';
	//echo $this->session->userdata("role_id");
	//echo '<br>';
	//echo $name=$this->session->userdata("name");
	//echo '<br>';
	//$this->Admin_model->add_update_datewise_attendance($_POST);
	exit;//*/
    
	
	$_POST['empschool'];
	$_POST['rdate'];
	$_POST['dept'];
	$_POST['rdate'];
	$_POST['Attendance'];
	          /*$this->data['emp_school']=$_POST['emp_school'];
              $this->data['department']=$_POST['department'];
              $this->data['attend_date']=$_POST['attend_date'];*/
	
	 $this->data['emp_school']=$_POST['emp_school'];
     $this->data['department']=$_POST['department'];
     $this->data['attend_date']=$_POST['rdate'];
	 
     $_POST['attend_date']= $_POST['rdate'];
	 
	$re=$this->Admin_model->add_update_datewise_attendance($_POST);
	 if($re==1){
       // redirect('admin/total_datewise_attendance');
	  // $this->load->view('header',$this->data);
	   $this->data['school_list']= $this->Admin_model->getAllschool();  
         $this->data['dept_list']= $this->Admin_model->getAllDepartments(); 
	   // $this->load->view($this->view_dir.'total_attendance_date',$this->data); 
		//$this->load->view('footer');
		$this->session->set_flashdata('msg', 'Attendance Added Succefully');
		redirect('admin/total_datewise_attendance');
	 }
        
        }
    //day wise attendance	
	
	
	function view_Attendance_report(){
		 $this->load->view('header',$this->data);
         $this->data['school_list']= $this->Admin_model->getAllschool();  
         $this->data['dept_list']= $this->Admin_model->getAllDepartments(); 
		 $this->load->view($this->view_dir.'view_date_report',$this->data); 
        $this->load->view('footer');  
		
	}
	
	function check_Attendance_report(){
		 $this->load->view('header',$this->data);
		$emp_school= $_POST['emp_school'];
	    $attend_date=   $_POST['attend_date'];
	    $department=  $_POST['department'];
		
		$this->data['emp_school']=$_POST['emp_school'];
     $this->data['department']=$_POST['department'];
     $this->data['attend_date']=$_POST['attend_date'];
		$this->data['all_attend']= $this->Admin_model->check_Attendance_report($emp_school,$attend_date,$department);  
		 
         $this->data['school_list']= $this->Admin_model->getAllschool();  
         $this->data['dept_list']= $this->Admin_model->getAllDepartments(); 
		 $this->load->view($this->view_dir.'view_date_report',$this->data); 
		  $this->load->view('footer');  
       
		
	}
	
	// code by siddesh
	public function view_attendance_excel($offSet=0){
		 
 ini_set('memory_limit', '-1');
//ini_set('error_reporting', E_ALL);
     
       // $this->load->view('header',$this->data);
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
      
         if(empty($data['emp_school']) && empty($data['department'])){
        
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
            }  			
              $this->data['attendance']=$attendance;  
              }elseif(empty($check_dt)){
               $this->data['all_emp']="";
               $this->data['attendance']="";
              }
         $this->load->view($this->view_dir.'/reports/regular_staff_attendance_excel_report',$this->data); 
            
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

                $this->data['attendance']=$attendance;  
              }elseif(empty($check_dt)){
                                 $this->data['all_emp']="";
                                $this->data['attendance']="";
              }

           $this->load->view($this->view_dir.'/reports/regular_staff_attendance_excel_report',$this->data);        
            
        }else{ 
             $this->data['attend_date']=$data['attend_date'];
              //first check whether the attandance available in punching backup table
              $check_dt=$this->Admin_model->checkAvailableAttendance($this->data['attend_date']);
             
              if(!empty($check_dt)){

            $all_emp=$this->Admin_model->getAttendance_All1($data);  
   
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
            $this->load->view($this->view_dir.'/reports/regular_staff_attendance_excel_report',$this->data);       
        }
		elseif(empty($check_dt)){
						 $this->data['all_emp']="";
						$this->data['attendance']="";
                       $this->load->view($this->view_dir.'/reports/regular_staff_attendance_excel_report',$this->data);
              }      
         } 
    }




///////////////////////////   visiting_staff_attendance   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

  public function view_visiting_attendance_excel(){
    ini_set('memory_limit', '-1');

    $check_dt=$this->Admin_model->checkAvailableAttendance($_POST['attend_datev']);		
	
    $this->data['attend_date'] = $_POST['attend_datev'];       
  
    if(!empty($check_dt)){
      if(empty($_POST['empsidv'])){
        $emplist1 = $this->Admin_model->getVisitingEmployees1('Y');
        $emplist = array();
        foreach ($emplist1 as  $value) {
          $emplist[] = $value['emp_id'];
        }
      }else{
           $emplist = $_POST['empsidv'];
      }
      foreach($emplist as $val){
      $this->data['attendance'][$val] = $this->Admin_model->get_visiting_attendance($_POST['attend_datev'],$val);
      }      
    }
  $this->load->view($this->view_dir.'/reports/visiting_staff_attendance_excel_report',$this->data);
  }
    
	
	
	// code end by siddhesh
	
	public function student_gradesheet_excel_old()
	{
		$this->data['student_data']=$this->Admin_model->fetch_student_grade_data();
		//$this->load->view($this->view_dir.'/reports/student_gradesheet_excel_report',$this->data);
		$this->load->view($this->view_dir.'/reports/student_gradesheet_view_report',$this->data);
	}
	
	
	public function earlygo_latemark_report()
	{
		$this->load->view('header',$this->data);
		$this->load->view($this->view_dir.'/earlygo_latemark');
		$this->load->view('footer');
	}
	
	public function earlygo_latemark_show()
	{
		$this->load->view('header',$this->data);
		$date=$this->input->post('attend_date');
		$this->data['emp_data']=$this->Admin_model->fetch_earlygo_latemark($date);
		$this->load->view($this->view_dir.'/earlygo_latemark_show',$this->data);
		$this->load->view('footer');
	}
	
	
	public function inoutmissing_report()
	{
		$this->load->view('header',$this->data);
		$this->load->view($this->view_dir.'/inoutmissing_report');
		$this->load->view('footer');
	}
	
	public function inoutmissing_report_show()
	{
		$this->load->view('header',$this->data);
		$date=$this->input->post('attend_date');		
		$this->data['emp_data']=$this->Admin_model->fetch_inoutmissing_report($date);
		$this->load->view($this->view_dir.'/inoutmissing_report_show',$this->data);
		$this->load->view('footer');
	}

    public function admission_report_show()
    {
		$this->load->view('header',$this->data);		
		$this->data['stud_data']=$this->Admin_model->fetch_admission_report();		
		$this->load->view($this->view_dir.'admission_report_show',$this->data);
		$this->load->view('footer');
	}
    public function admission_report_show_naac()
    {
		$this->load->view('header',$this->data);		
		$this->data['stud_data']=$this->Admin_model->fetch_admission_report_naac();		
		$this->load->view($this->view_dir.'admission_report_show_naac',$this->data);
		$this->load->view('footer');
	}   	
    public function admission_report_details_fetch()
	{
	   $course_id=$_POST['course_id'];
	   
	   if(!empty($course_id) && $course_id==15){
			
			$stud_data=$this->Admin_model->fetch_admission_report_phd($course_id);	
		}else{
			$stud_data=$this->Admin_model->fetch_admission_report($course_id);
	   }
	   echo json_encode(array("stud_data"=>$stud_data));
	}
	public function admission_report_details_fetch_naac()
	{
	   $course_id=$_POST['course_id'];
	   
	   if(!empty($course_id) && $course_id==15){
			
			$stud_data=$this->Admin_model->fetch_admission_report_phd($course_id);	
		}else{
			$stud_data=$this->Admin_model->fetch_admission_report_naac($course_id);
	   }
	   echo json_encode(array("stud_data"=>$stud_data));
	}
	 public function admission_school_coursewise_report()
    {    
		$this->load->view('header',$this->data);		
	    $this->data['stud_data']=$this->Admin_model->fetch_school_coursewise_report();
		$this->data['year']=ACADEMIC_YEAR;
		$this->load->view($this->view_dir.'admission_school_coursewise_report',$this->data);
		$this->load->view('footer');
	}
       	
    public function admission_school_coursewise_details_fetch()
	{
	   $course_id=$_POST['course_id'];
	   $acad_year=$_POST['academic_year'];
	   if(!empty($course_id) && $course_id==15){
		$stud_data=$this->Admin_model->fetch_school_coursewise_report_phd($acad_year,$course_id);
	   }else{
		$stud_data=$this->Admin_model->fetch_school_coursewise_report($acad_year,$course_id);   
	   }
	   echo json_encode(array("stud_data"=>$stud_data));
	}
	public function display_student_details()
	{    
	    $this->load->view('header',$this->data);
		$acad_year=$this->uri->segment(3);
		$course_id=$this->uri->segment(4);
		$stream_id=$this->uri->segment(5);
		$adm_flg=$this->uri->segment(6);
		$this->data['stud_details']=$this->Admin_model->fetch_student_details($acad_year,$course_id,$stream_id,$adm_flg);
		//echo count($this->data['stud_details']);exit;
		$this->load->view($this->view_dir.'display_student_details',$this->data);
		$this->load->view('footer');
	}
	public function display_student_details_naac()
	{    
	    $this->load->view('header',$this->data);
		$acad_year=$this->uri->segment(3);
		$course_id=$this->uri->segment(4);
		$stream_id=$this->uri->segment(5);
		$adm_flg=$this->uri->segment(6);
		$this->data['stud_details']=$this->Admin_model->fetch_student_details_naac($acad_year,$course_id,$stream_id,$adm_flg);
		//echo count($this->data['stud_details']);exit;
		$this->load->view($this->view_dir.'display_student_details',$this->data);
		$this->load->view('footer');
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //for calculating total monthly attendance i.e.total day present ,total day OD,Cl,PL,etc..
    
    public function total_monthly_attendance_manual(){
    
        $this->load->view('header',$this->data);
		$this->data['school_list']= $this->Admin_model->getAllschool();  
         $this->data['dept_list']= $this->Admin_model->getAllDepartments();      
         $this->data['desig_list']= $this->Admin_model->getAllDesignations();
       // $this->data['emp_list']= $this->Admin_model->getEmployees();
/* 	   ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
         if(isset($_POST['submit'])){
           $this->data['attend_date']=$_POST['attend_date'];

           $chk_tab = $this->Admin_model->checkFinalAttendance($_POST);
		  
       if(!empty($chk_tab)){         
		 $this->data['all_attend']=$this->Admin_model->fetch_employee_monthly($_POST);   
  
         $this->data['sbtn'] = '1';
		 //echo 2;exit;  
	   }
	   else
	   { 

	        // if(!empty($chk_tab))
		
             $monatt = $this->Admin_model->checkMonthAttendance($_POST);
 //print_r($monatt); echo 6;exit; 
              if(!empty($monatt)){
				
              $this->data['sbtn'] = '0';
              $check_dt=1;
			  
			  
              if(!empty($check_dt)){
				
                  /*calculate sundays and holidyas of a serched month and total working days,present days*/
					$attend_date= $_POST['attend_date'];
					$date =  $attend_date."-01";
					$lt=date('t', strtotime($attend_date)); //get end date of month
					$end = $attend_date."-".$lt;
					$time=strtotime($attend_date);
					$d = date_parse_from_format("Y-m-d",$attend_date);
					$msearch=$d["month"];//month number
					$ysearch=date("Y",strtotime($attend_date));
					$monthName = date('F', mktime(0, 0, 0, $msearch, 10));// month name
					$cm = date('m');
             
			       if($cm == $msearch){
                   $totaldays= date('d')-1; 
                   }else{
                   $totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);
                   }
				   
                        // echo $total_days;
                   //$totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);//total month days
                    $i=1;
                   //calculate number of sundays in given month
                 //  $total_holiday=$this->Admin_model->getTotalHoliday($msearch,$ysearch);
                       
                  /***********************************end**************************************/
                  
                  if($cm == $msearch){
                  $totaldays= date('d')-1; 
                  }else{
                  $totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);
                  }
				  
				  
                         //echo $totaldays;
                  
              $all_attend=array();
			
              //for($i=0;$i<count($all_attend);$i++){

              	//echo $all_attend[$i]['manual_attendance_flag'];
              	//echo  $all_attend[$i]['emp_id'];
               // if($all_attend[$i]['manual_attendance_flag']=='Y'){
					
                 $mand = $this->Admin_model->get_Marked_Emp_attendance_manual($attend_date);
					for($i=0;$i<count($mand);$i++){
                   if($mand[$i]['gender']=='male'){ $f = 'Mr.';}else if($mand[$i]['gender']=='female'){ $f = 'Mrs.';}
				   
				
   //  if($temp_pret[0]['total_present'] != '0'){
                   $all_attend[$i]['total_present'] = $mand[$i]['total_present'];
                   $all_attend[$i]['total'] = $mand[$i]['Total'];
                   $all_attend[$i]['UserId'] = $mand[$i]['UserId'];
				   
                   $all_attend[$i]['ename'] = $f." ".$mand[$i]['fname']." ".$mand[$i]['mname']." ".$mand[$i]['lname'];
				   $all_attend[$i]['Type'] = '--';                            
                   $all_attend[$i]['month_days']=$mand[$i]['month_days']; 

               // } // if($all_attend[$i]['manual_attendance_flag']=='Y')
			  
			  
              } //for($i=0;$i<count($all_attend);$i++)
			  
             $this->data['all_attend']= $all_attend;
                
               }elseif(empty($check_dt)){
				  //  echo '5';
		//	exit;
               $this->data['all_attend']="";
                }
				
			  
               }
	  
         }//if(empty($monatt))
		 
		 
     } //if(isset($_POST['submit']))
   
 
 
         if($_POST['exp_t']=='1'){
          $this->total_attendance_export($this->data,$_POST['attend_date']);
         }
        
		
		$this->load->view($this->view_dir.'total_attendance_manual',$this->data); 
        $this->load->view('footer');
        
    }
	public function add_update_monthly_attendance_manual(){
	//echo "ddd";
	//exit;
	ini_set('max_input_vars', 3000);
	/*echo "<pre>";
	$data=file_get_contents('php://input');
	print_r($data);
	
	
	$data1=$this->input->post(NULL, FALSE);
	*/
	//echo '<pre>';print_r($_POST);exit;

     $this->data['attend_date']=$_POST['rdate'];
     $_POST['attend_date']= $_POST['rdate'];
	 $this->data['UserId']=$_POST['UserId'];
	 //echo $_POST['sbtnv']; exit;
     foreach ($_POST['UserId'] as $spk) {
			$spk_details['UserId'][] = $spk;
		}
		foreach ($_POST['pday'] as $spk2) {
			$spk_details['pday'][] = $spk2;
		}
//print_r($spk_details);exit;
        $result=$this->Admin_model->updateattendacneDetails($spk_details,$this->data['rdate']);
        
       
	   
	   
	    redirect('admin/total_monthly_attendance_manual');
       // redirect('admin/staff_manual_attendance');
        }
	  public function final_submit_Attendance_manual(){
    $fdt = $this->Admin_model->Add_final_status_attendance_manual($_POST);
    if($fdt=='updated'){
       $this->session->set_flashdata('message1','Monthly Attendance Submited successfully...');
           redirect('admin/total_monthly_attendance_manual');
    }else{
       $this->session->set_flashdata('message1','Sorry, Monthly Attendance is not Submited successfully...');
		redirect('admin/total_monthly_attendance_manual');
    }
  }	
  
  public function export_employees_act_to_excel() {
        $this->load->library('PHPExcel');

        $search_term = $this->input->get('search');
        $department_id = $this->input->get('department');
        $designation_id = $this->input->get('designation');
        $staff_type = $this->input->get('staff_type');
      
        $employees = $this->Admin_model->getEmployeesxl($department_id,$designation_id,$search_term,$staff_type);
        
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->getProperties()->setCreator("SF")
                                     ->setTitle("Active Employees Data");
        
        $objPHPExcel->setActiveSheetIndex(0);
        
        // Apply formatting to specific cells
        $objPHPExcel->getActiveSheet()
                    ->getStyle('B2:AR2')->getFont()->setBold(false);
        $objPHPExcel->getActiveSheet()
                    ->getStyle('B2:AR2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'SANDIP UNIVERSITY');
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->getStyle('B3:AR3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'TRIMBAK ROAD, MAHIRAVANI, NASHIK-422213');
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()
                    ->getStyle('B7:AR7')->getFont()->setBold(false);
        $objPHPExcel->getActiveSheet()
                    ->getStyle('B7:AR7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()
    ->getStyle('A1:AW1')
    ->getFont()
    ->setBold(true);

        
                    $objPHPExcel->getActiveSheet()
                    ->setCellValue('A1', 'Sr Num')
                    ->setCellValue('B1', 'Emp ID')
                    ->setCellValue('C1', 'Name')
                    ->setCellValue('D1', 'Date of Birth')
                    ->setCellValue('E1', 'Gender')
                    ->setCellValue('F1', 'School')
                    ->setCellValue('G1', 'Department')
                    ->setCellValue('H1', 'Designation')
                    ->setCellValue('I1', 'Staff Type')
                    ->setCellValue('J1', 'Joining Date')
                    ->setCellValue('K1', 'Personal Email')
                    ->setCellValue('L1', 'Official Email')
                    ->setCellValue('M1', 'Mobile Number')
                    ->setCellValue('N1', 'Blood Group')
                    ->setCellValue('O1', 'Scale Type')
                    ->setCellValue('P1', 'Pay Band')
                    ->setCellValue('Q1', 'Pan Number')
                    ->setCellValue('R1', 'Uan Number')
                    ->setCellValue('S1', 'Adhar Number')
                    ->setCellValue('T1', 'Category')
                    ->setCellValue('U1', 'Caste')
                    ->setCellValue('V1', 'Sub Caste')
                    ->setCellValue('W1', 'Qualification')
                    ->setCellValue('X1', 'Physical Status')
                    ->setCellValue('Y1', 'PF Status')
                    ->setCellValue('Z1', 'Weekly Off')
                    ->setCellValue('AA1', 'Usual Experiences')
                    ->setCellValue('AB1', 'Total Experiences')
                    ->setCellValue('AC1', 'Bank Ac Number')
                    ->setCellValue('AD1', 'Local Address')
                    ->setCellValue('AE1', 'Local Taluka')
                    ->setCellValue('AF1', 'Local Dist/City')
                    ->setCellValue('AG1', 'Local Pin Code')
                    ->setCellValue('AH1', 'Local State')
                    ->setCellValue('AI1', 'Local Country')
                    ->setCellValue('AJ1', 'Permanent Address')
                    ->setCellValue('AK1', 'Permanent Taluka')
                    ->setCellValue('AL1', 'Permanent Dist/City')
                    ->setCellValue('AM1', 'Permanent Pin Code')
                    ->setCellValue('AN1', 'Permanent State')
                    ->setCellValue('AO1', 'Permanent Country')
                    ->setCellValue('AP1', 'Reg Date')
                    ->setCellValue('AQ1', 'Experiences')
                    ->setCellValue('AR1', 'Hiring Type')
                    ->setCellValue('AS1', 'Is Disabled')
                    ->setCellValue('AT1', 'IFSC Code')
					->setCellValue('AU1', 'Academic/Technical')
					->setCellValue('AV1', 'Industrial/Other')
					->setCellValue('AW1', 'Research')
					->setCellValue('AX1', 'Break Month');
                
                // Populate data
                $row = 2;
                foreach ($employees as $employee) {
                    $fullName = $employee['fname'] . ' ' . $employee['mname'] . ' ' . $employee['lname'];
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $row - 1);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $employee['emp_id']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $fullName);
                     $dateOfBirth = date('d/m/Y', strtotime($employee['date_of_birth']));
                                         $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $dateOfBirth); 

                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $employee['gender']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $employee['college_code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $employee['department_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $employee['designation_name']);
                   // $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $employee['staff_type']);
                     if ($employee['staff_type'] == 1) {
                                            $staffType = 'Technical';
                                        } elseif ($employee['staff_type'] == 2) {
                                            $staffType = 'Non-Technical';
                                        } elseif ($employee['staff_type'] == 3) {
                                            $staffType = 'Teaching';
                                        } elseif ($employee['staff_type'] == 4) {
                                            $staffType = 'IC-Staff-HO';
                                        } else {
                                           
                                            $staffType = 'NA';
                                        }
                                        
                                        $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $staffType);
                                     
                                         $joiningDate = $employee['joiningDate'];
                                         $formattedDate = date("d-m-Y", strtotime($joiningDate));
                                         //echo $formattedDate;
                     
                                         $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $formattedDate);
                                         $objPHPExcel->getActiveSheet()->getStyle('J' . $row)->getNumberFormat()->setFormatCode('dd/mm/yyyy');
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $employee['pemail']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $employee['oemail']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $employee['mobileNumber']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $employee['blood_gr']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $employee['scaletype']);
                    //$objPHPExcel->getActiveSheet()->setCellValue('P' . $row, "NA");

                    if (!empty($employee['pay_band_min1']) && !empty($employee['pay_band_max1']) && !empty($employee['pay_band_gt1'])) {
                        $value = $employee['pay_band_min1'] . "-" . $employee['pay_band_max1'] . "+AGP " . $employee['pay_band_gt1'];
                    } else {
                        $value = "NA";
                    }
                    
                    $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $value);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $employee['pan_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $employee['pf_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $employee['adhar_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $employee['category']);
                    $objPHPExcel->getActiveSheet()->setCellValue('U' . $row, $employee['cast']);
                    $objPHPExcel->getActiveSheet()->setCellValue('V' . $row, $employee['sub_cast']);
                    $objPHPExcel->getActiveSheet()->setCellValue('W' . $row, $employee['qualifiaction']);
                    $pfStatus = ($employee['phy_status'] == 0) ? 'Y' : 'N';
                    $objPHPExcel->getActiveSheet()->setCellValue('X' . $row, $pfStatus);
                    $pfStatus = ($employee['pf_status'] == 0) ? 'Y' : 'N';
                    $objPHPExcel->getActiveSheet()->setCellValue('Y' . $row, $pfStatus);
                    $objPHPExcel->getActiveSheet()->setCellValue('Z' . $row, $employee['week_off']);
                    // Concatenate years and months for Usdtial Experiences
                    $initialExp = $employee['inexp_yr'] . "." . $employee['inexp_mnth'] . " Yr";
                    $objPHPExcel->getActiveSheet()->setCellValue('AA' . $row, $initialExp);

                    // Concatenate years and months for Total Experiences
                    $totalExp = $employee['texp_yr'] . "." . $employee['texp_mnth'] . " Yr";
                    $objPHPExcel->getActiveSheet()->setCellValue('AB' . $row, $totalExp);

                    $objPHPExcel->getActiveSheet()->setCellValue('AC' . $row, $employee['bank_acc_no']);
                    $value = $employee['lflatno'] . ' ' . $employee['larea_name'];
                        $objPHPExcel->getActiveSheet()->setCellValue('AD' . $row, $value);
                    //$objPHPExcel->getActiveSheet()->setCellValue('AD' . $row, $employee['larea_name']);

                    $objPHPExcel->getActiveSheet()->setCellValue('AE' . $row, $employee['ltaluka']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AF' . $row, $employee['ldist']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AG' . $row, $employee['lpincode']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AH' . $row, $employee['state_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AI' . $row, $employee['lcountry']);
                   // $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $row, $employee['parea_name']);
                    $value = $employee['pflatno'] . ' ' . $employee['parea_name'];
                    $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $row, $value);
                    $objPHPExcel->getActiveSheet()->setCellValue('AK' . $row, $employee['ptaluka']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AL' . $row, $employee['pdist']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AM' . $row, $employee['p_pincode']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AN' . $row, $employee['pstatename']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AO' . $row, $employee['pcountry']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AP' . $row, $employee['']);
                    $date1 = $employee['joiningDate'];
                    $date2 = date("Y-m-d");
                    $diff = abs(strtotime($date2) - strtotime($date1));
                    $years = floor($diff / (365*60*60*24));
                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    
                    $dur = $years . " Years " . $months . " months " . $days . " days";
                    
                    // Set the value of cell AQ$row to $dur
                    $objPHPExcel->getActiveSheet()->setCellValue('AQ' . $row, $dur);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue('AR' . $row, $employee['hiring_type']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AS' . $row, $employee['is_disabled']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AT' . $row, $employee['bank_ifsc']);
					$objPHPExcel->getActiveSheet()->setCellValue('AU' . $row, $employee['aexp_yr'].".".$employee['aexp_mnth']." Yr");
                    $objPHPExcel->getActiveSheet()->setCellValue('AV' . $row, $employee['inexp_yr'].".". $employee['inexp_mnth']." Yr");
                    $objPHPExcel->getActiveSheet()->setCellValue('AW' . $row, $employee['rexp_yr'].".".$employee['rexp_mnth']." Yr");
					$objPHPExcel->getActiveSheet()->setCellValue('AX' . $row, $employee['break_month']);
                    $row++;
                }
                
        
        
        $objPHPExcel->setActiveSheetIndex(0);
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="active_employees_data.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
    

    public function export_employees_inact_to_excel() {
      
        $this->load->library('PHPExcel');
            $search_term = $this->input->get('search');
        $department_id = $this->input->get('department');
        $designation_id = $this->input->get('designation');
        $staff_type = $this->input->get('staff_type');
      
        $employees = $this->Admin_model->getEmployeesInactXl($department_id,$designation_id,$search_term,$staff_type);
        //$employees = $this->Admin_model->getEmployeesInactXl();
    
        $objPHPExcel = new PHPExcel();
    
        $objPHPExcel->getProperties()->setCreator("Your Name")
                                     ->setTitle("Inactive Employees Data");
    
                                     $objPHPExcel->setActiveSheetIndex(0);
        
                                     // Apply formatting to specific cells
                                     $objPHPExcel->getActiveSheet()
                                                 ->getStyle('B2:AR2')->getFont()->setBold(false);
                                     $objPHPExcel->getActiveSheet()
                                                 ->getStyle('B2:AR2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                     $objPHPExcel->getActiveSheet()->setCellValue('B2', 'SANDIP UNIVERSITY');
                                     $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                     
                                     $objPHPExcel->getActiveSheet()->getStyle('B3:AR3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                     $objPHPExcel->getActiveSheet()->setCellValue('B3', 'TRIMBAK ROAD, MAHIRAVANI, NASHIK-422213');
                                     $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                     
                                     $objPHPExcel->getActiveSheet()
                                                 ->getStyle('B7:AR7')->getFont()->setBold(false);
                                     $objPHPExcel->getActiveSheet()
                                                 ->getStyle('B7:AR7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                                 $objPHPExcel->getActiveSheet()
                                                 ->getStyle('A1:AT1')
                                                 ->getFont()
                                                 ->setBold(true);
                                                 $objPHPExcel->getActiveSheet()
                                                 ->setCellValue('A1', 'Sr Num')
                                                 ->setCellValue('B1', 'Emp ID')
                                                 ->setCellValue('C1', 'Name')
                                                 ->setCellValue('D1', 'Date of Birth')
                                                 ->setCellValue('E1', 'Gender')
                                                 ->setCellValue('F1', 'School')
                                                 ->setCellValue('G1', 'Department')
                                                 ->setCellValue('H1', 'Designation')
                                                 ->setCellValue('I1', 'Staff Type')
                                                 ->setCellValue('J1', 'Joining Date')
                                                 ->setCellValue('K1', 'Personal Email')
                                                 ->setCellValue('L1', 'Official Email')
                                                 ->setCellValue('M1', 'Mobile Number')
                                                 ->setCellValue('N1', 'Blood Group')
                                                 ->setCellValue('O1', 'Scale Type')
                                                 ->setCellValue('P1', 'Pay Band')
                                                 ->setCellValue('Q1', 'Pan Number')
                                                 ->setCellValue('R1', 'Uan Number')
                                                 ->setCellValue('S1', 'Adhar Number')
                                                 ->setCellValue('T1', 'Category')
                                                 ->setCellValue('U1', 'Caste')
                                                 ->setCellValue('V1', 'Sub Caste')
                                                 ->setCellValue('W1', 'Qualification')
                                                 ->setCellValue('X1', 'Physical Status')
                                                 ->setCellValue('Y1', 'PF Status')
                                                 ->setCellValue('Z1', 'Weekly Off')
                                                 ->setCellValue('AA1', 'Usual Experiences')
                                                 ->setCellValue('AB1', 'Total Experiences')
                                                 ->setCellValue('AC1', 'Bank Ac Number')
                                                 ->setCellValue('AD1', 'Local Address')
                                                 ->setCellValue('AE1', 'Local Taluka')
                                                 ->setCellValue('AF1', 'Local Dist/City')
                                                 ->setCellValue('AG1', 'Local Pin Code')
                                                 ->setCellValue('AH1', 'Local State')
                                                 ->setCellValue('AI1', 'Local Country')
                                                 ->setCellValue('AJ1', 'Permanent Address')
                                                 ->setCellValue('AK1', 'Permanent Taluka')
                                                 ->setCellValue('AL1', 'Permanent Dist/City')
                                                 ->setCellValue('AM1', 'Permanent Pin Code')
                                                 ->setCellValue('AN1', 'Permanent State')
                                                 ->setCellValue('AO1', 'Permanent Country')
                                                 ->setCellValue('AP1', 'Reg Date')
                                                 ->setCellValue('AQ1', 'Experiences')
                                                 ->setCellValue('AR1', 'Hiring Type')
                                                 ->setCellValue('AS1', 'Is Disabled')
                                                 ->setCellValue('AT1', 'IFSC Code');
                                             
                                             // Populate data
                                             $row = 2;
                                             foreach ($employees as $employee) {
                                                 $fullName = $employee['fname'] . ' ' . $employee['mname'] . ' ' . $employee['lname'];
                                                 $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $row - 1);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $employee['emp_id']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $fullName);
                                                 $dateOfBirth = date('d/m/Y', strtotime($employee['date_of_birth']));
                                                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $dateOfBirth); 

                                                 $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $employee['gender']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $employee['college_code']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $employee['department_name']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $employee['designation_name']);
                                                // $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $employee['staff_type']);
                                                 if ($employee['staff_type'] == 1) {
                                            $staffType = 'Technical';
                                        } elseif ($employee['staff_type'] == 2) {
                                            $staffType = 'Non-Technical';
                                        } elseif ($employee['staff_type'] == 3) {
                                            $staffType = 'Teaching';
                                        } elseif ($employee['staff_type'] == 4) {
                                            $staffType = 'IC-Staff-HO';
                                        } else {
                                           
                                            $staffType = 'NA';
                                        }
                                        
                                        $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $staffType);
                                     
                                         $joiningDate = $employee['joiningDate'];
                                         $formattedDate = date("d-m-Y", strtotime($joiningDate));
                                         //echo $formattedDate;
                     
                                         $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $formattedDate);
                                         $objPHPExcel->getActiveSheet()->getStyle('J' . $row)->getNumberFormat()->setFormatCode('dd/mm/yyyy');

                                                 $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $employee['pemail']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $employee['oemail']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $employee['mobileNumber']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $employee['blood_gr']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $employee['scaletype']);
                                                // $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, "NA");

                                                 if (!empty($employee['pay_band_min1']) && !empty($employee['pay_band_max1']) && !empty($employee['pay_band_gt1'])) {
                                                    $value = $employee['pay_band_min1'] . "-" . $employee['pay_band_max1'] . "+AGP " . $employee['pay_band_gt1'];
                                                } else {
                                                    $value = "NA";
                                                }
                                                 $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $employee['pan_no']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $employee['pf_no']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $employee['adhar_no']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $employee['category']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('U' . $row, $employee['cast']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('V' . $row, $employee['sub_cast']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('W' . $row, $employee['qualifiaction']);
                                                 $pfStatus = ($employee['phy_status'] == 0) ? 'Y' : 'N';
                                                 $objPHPExcel->getActiveSheet()->setCellValue('X' . $row, $pfStatus);
                                                 $pfStatus = ($employee['pf_status'] == 0) ? 'Y' : 'N';
                                                 $objPHPExcel->getActiveSheet()->setCellValue('Y' . $row, $pfStatus);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('Z' . $row, $employee['week_off']);
                                                 // Concatenate years and months for Usdtial Experiences
                                                 $initialExp = $employee['inexp_yr'] . "." . $employee['inexp_mnth'] . " Yr";
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AA' . $row, $initialExp);
                             
                                                 // Concatenate years and months for Total Experiences
                                                 $totalExp = $employee['texp_yr'] . "." . $employee['texp_mnth'] . " Yr";
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AB' . $row, $totalExp);
                             
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AC' . $row, $employee['bank_acc_no']);
                                                 //$objPHPExcel->getActiveSheet()->setCellValue('AD' . $row, $employee['larea_name']);
                                                 $value = $employee['lflatno'] . ' ' . $employee['larea_name'];
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AD' . $row, $value);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AE' . $row, $employee['ltaluka']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AF' . $row, $employee['ldist']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AG' . $row, $employee['lpincode']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AH' . $row, $employee['state_name']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AI' . $row, $employee['lcountry']);
                                                 //$objPHPExcel->getActiveSheet()->setCellValue('AJ' . $row, $employee['parea_name']);
                                                 $value = $employee['pflatno'] . ' ' . $employee['parea_name'];
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $row, $value);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AK' . $row, $employee['ptaluka']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AL' . $row, $employee['pdist']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AM' . $row, $employee['p_pincode']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AN' . $row, $employee['pstatename']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AO' . $row, $employee['pcountry']);
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AP' . $row, $employee['']);
                                                 $date1 = $employee['joiningDate'];
                                                 $date2 = date("Y-m-d");
                                                 $diff = abs(strtotime($date2) - strtotime($date1));
                                                 $years = floor($diff / (365*60*60*24));
                                                 $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                                 $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                                 
                                                 $dur = $years . " Years " . $months . " months " . $days . " days";
                                                 
                                                 // Set the value of cell AQ$row to $dur
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AQ' . $row, $dur);
                                                 
                                                 $objPHPExcel->getActiveSheet()->setCellValue('AR' . $row, $employee['hiring_type']);
                                               
                                                 // $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, ($employee['emp_status'] == 'Y') ? 'Active' : 'Inactive');
                                                $objPHPExcel->getActiveSheet()->setCellValue('AS' . $row, ($employee['is_disabled'] == 'N') ? 'No' : 'Yes');
                                                $objPHPExcel->getActiveSheet()->setCellValue('AT' . $row, $employee['bank_ifsc']);
                                                $row++;
                                                }

    
                                                $objPHPExcel->setActiveSheetIndex(0);
                                            
                                                header('Content-Type: application/vnd.ms-excel');
                                                header('Content-Disposition: attachment;filename="inactive_employees_data.xlsx"');
                                                header('Cache-Control: max-age=0');
                                                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                                                $objWriter->save('php://output');
                                                exit;
                                            }
                                            
    
    public function export_employees_reg_to_excel() {
       
        $this->load->library('PHPExcel');
        $search_term = $this->input->get('search');
        $department_id = $this->input->get('department');
        $designation_id = $this->input->get('designation');
        $staff_type = $this->input->get('staff_type');
      
        $employees = $this->Admin_model->getRegEmployeesxl($department_id,$designation_id,$search_term,$staff_type);
      //  $employees = $this->Admin_model->getRegEmployeesxl();
    
        $objPHPExcel = new PHPExcel();
      
        $objPHPExcel->getProperties()->setCreator("SF")
                                     ->setTitle("Resign Employee_Data");
                                     $objPHPExcel->getActiveSheet()
                                     ->getStyle('A1:K1')
                                     ->getFont()
                                     ->setBold(false);
     
                                     $objPHPExcel->setActiveSheetIndex(0);
        
                                     // Apply formatting to specific cells
                                     $objPHPExcel->getActiveSheet()
                                                 ->getStyle('B2:AR2')->getFont()->setBold(false);
                                     $objPHPExcel->getActiveSheet()
                                                 ->getStyle('B2:AR2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                     $objPHPExcel->getActiveSheet()->setCellValue('B2', 'SANDIP UNIVERSITY');
                                     $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                     
                                     $objPHPExcel->getActiveSheet()->getStyle('B3:AR3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                     $objPHPExcel->getActiveSheet()->setCellValue('B3', 'TRIMBAK ROAD, MAHIRAVANI, NASHIK-422213');
                                     $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                     
                                     $objPHPExcel->getActiveSheet()
                                                 ->getStyle('B7:AR7')->getFont()->setBold(false);
                                     $objPHPExcel->getActiveSheet()
                                                 ->getStyle('B7:AR7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                                 $objPHPExcel->getActiveSheet()
                                                 ->getStyle('A1:AT1')
                                                 ->getFont()
                                                 ->setBold(true);
                                                 $objPHPExcel->getActiveSheet()
                                                 ->setCellValue('A1', 'Sr Num')
                                                 ->setCellValue('B1', 'Emp ID')
                                                 ->setCellValue('C1', 'Name')
                                                 ->setCellValue('D1', 'Date of Birth')
                                                 ->setCellValue('E1', 'Gender')
                                                 ->setCellValue('F1', 'School')
                                                 ->setCellValue('G1', 'Department')
                                                 ->setCellValue('H1', 'Designation')
                                                 ->setCellValue('I1', 'Staff Type')
                                                 ->setCellValue('J1', 'Joining Date')
                                                 ->setCellValue('K1', 'Personal Email')
                                                 ->setCellValue('L1', 'Official Email')
                                                 ->setCellValue('M1', 'Mobile Number')
                                                 ->setCellValue('N1', 'Blood Group')
                                                 ->setCellValue('O1', 'Scale Type')
                                                 ->setCellValue('P1', 'Pay Band')
                                                 ->setCellValue('Q1', 'Pan Number')
                                                 ->setCellValue('R1', 'Uan Number')
                                                 ->setCellValue('S1', 'Adhar Number')
                                                 ->setCellValue('T1', 'Category')
                                                 ->setCellValue('U1', 'Caste')
                                                 ->setCellValue('V1', 'Sub Caste')
                                                 ->setCellValue('W1', 'Qualification')
                                                 ->setCellValue('X1', 'Physical Status')
                                                 ->setCellValue('Y1', 'PF Status')
                                                 ->setCellValue('Z1', 'Weekly Off')
                                                 ->setCellValue('AA1', 'Usual Experiences')
                                                 ->setCellValue('AB1', 'Total Experiences')
                                                 ->setCellValue('AC1', 'Bank Ac Number')
                                                 ->setCellValue('AD1', 'Local Address')
                                                 ->setCellValue('AE1', 'Local Taluka')
                                                 ->setCellValue('AF1', 'Local Dist/City')
                                                 ->setCellValue('AG1', 'Local Pin Code')
                                                 ->setCellValue('AH1', 'Local State')
                                                 ->setCellValue('AI1', 'Local Country')
                                                 ->setCellValue('AJ1', 'Permanent Address')
                                                 ->setCellValue('AK1', 'Permanent Taluka')
                                                 ->setCellValue('AL1', 'Permanent Dist/City')
                                                 ->setCellValue('AM1', 'Permanent Pin Code')
                                                 ->setCellValue('AN1', 'Permanent State')
                                                 ->setCellValue('AO1', 'Permanent Country')
                                                 ->setCellValue('AP1', 'Reg Date')
                                                 ->setCellValue('AQ1', 'Experiences')
                                                 ->setCellValue('AR1', 'Hiring Type')
                                                 ->setCellValue('AS1', 'Is Disabled')
                                                 ->setCellValue('AT1', 'IFSC Code')
                                                ->setCellValue('AU1', 'Resign Date')
												->setCellValue('AV1', 'Academic/Technical')
												->setCellValue('AW1', 'Industrial/Other')
												->setCellValue('AX1', 'Research');

                         
                                     $row = 2;
                                     foreach ($employees as $employee) {
                                         $fullName = $employee['fname'] . ' ' . $employee['mname'] . ' ' . $employee['lname'];
                                         $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $row - 1);
                                         $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $employee['emp_id']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $fullName);
                                          $dateOfBirth = date('d/m/Y', strtotime($employee['date_of_birth']));
                                         $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $dateOfBirth); 

                                         $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $employee['gender']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $employee['college_code']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $employee['department_name']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $employee['designation_name']);
                                        // $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $employee['staff_type']);
                                         if ($employee['staff_type'] == 1) {
                                            $staffType = 'Technical';
                                        } elseif ($employee['staff_type'] == 2) {
                                            $staffType = 'Non-Technical';
                                        } elseif ($employee['staff_type'] == 3) {
                                            $staffType = 'Teaching';
                                        } elseif ($employee['staff_type'] == 4) {
                                            $staffType = 'IC-Staff-HO';
                                        } else {
                                           
                                            $staffType = 'NA';
                                        }
                                        
                                        $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $staffType);
                                     
                                         $joiningDate = $employee['joiningDate'];
                                         $formattedDate = date("d-m-Y", strtotime($joiningDate));
                                         //echo $formattedDate;
                     
                                         $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $formattedDate);
                                         $objPHPExcel->getActiveSheet()->getStyle('J' . $row)->getNumberFormat()->setFormatCode('dd/mm/yyyy');
                                         $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $employee['pemail']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $employee['oemail']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $employee['mobileNumber']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $employee['blood_gr']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $employee['scaletype']);
                                         //$objPHPExcel->getActiveSheet()->setCellValue('P' . $row, "NA");
                                         if (!empty($employee['pay_band_min1']) && !empty($employee['pay_band_max1']) && !empty($employee['pay_band_gt1'])) {
                                            $value = $employee['pay_band_min1'] . "-" . $employee['pay_band_max1'] . "+AGP " . $employee['pay_band_gt1'];
                                        } else {
                                            $value = "NA";
                                        }
                                         $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $employee['pan_no']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $employee['pf_no']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $employee['adhar_no']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $employee['category']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('U' . $row, $employee['cast']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('V' . $row, $employee['sub_cast']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('W' . $row, $employee['qualifiaction']);
                                         $pfStatus = ($employee['phy_status'] == 0) ? 'Y' : 'N';
                                         $objPHPExcel->getActiveSheet()->setCellValue('X' . $row, $pfStatus);
                                         $pfStatus = ($employee['pf_status'] == 0) ? 'Y' : 'N';
                                         $objPHPExcel->getActiveSheet()->setCellValue('Y' . $row, $pfStatus);
                                         $objPHPExcel->getActiveSheet()->setCellValue('Z' . $row, $employee['week_off']);
                                         // Concatenate years and months for Usdtial Experiences
                                         $initialExp = $employee['inexp_yr'] . "." . $employee['inexp_mnth'] . " Yr";
                                         $objPHPExcel->getActiveSheet()->setCellValue('AA' . $row, $initialExp);
                     
                                         // Concatenate years and months for Total Experiences
                                         $totalExp = $employee['texp_yr'] . "." . $employee['texp_mnth'] . " Yr";
                                         $objPHPExcel->getActiveSheet()->setCellValue('AB' . $row, $totalExp);
                     
                                         $objPHPExcel->getActiveSheet()->setCellValue('AC' . $row, $employee['bank_acc_no']);
                                         //$objPHPExcel->getActiveSheet()->setCellValue('AD' . $row, $employee['larea_name']);
                                         $value = $employee['lflatno'] . ' ' . $employee['larea_name'];
                                         $objPHPExcel->getActiveSheet()->setCellValue('AD' . $row, $value);
                                         $objPHPExcel->getActiveSheet()->setCellValue('AE' . $row, $employee['ltaluka']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('AF' . $row, $employee['ldist']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('AG' . $row, $employee['lpincode']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('AH' . $row, $employee['state_name']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('AI' . $row, $employee['lcountry']);
                                        // $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $row, $employee['parea_name']);

                                         $value = $employee['pflatno'] . ' ' . $employee['parea_name'];
                                         $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $row, $value);
                                         $objPHPExcel->getActiveSheet()->setCellValue('AK' . $row, $employee['ptaluka']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('AL' . $row, $employee['pdist']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('AM' . $row, $employee['p_pincode']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('AN' . $row, $employee['pstatename']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('AO' . $row, $employee['pcountry']);
                                         $objPHPExcel->getActiveSheet()->setCellValue('AP' . $row, $employee['']);
                                         $date1 = $employee['joiningDate'];
                                         $date2 = date("Y-m-d");
                                         $diff = abs(strtotime($date2) - strtotime($date1));
                                         $years = floor($diff / (365*60*60*24));
                                         $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                         $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                         
                                         $dur = $years . " Years " . $months . " months " . $days . " days";
                                         
                                         // Set the value of cell AQ$row to $dur
                                         $objPHPExcel->getActiveSheet()->setCellValue('AQ' . $row, $dur);
                                         
                                         $objPHPExcel->getActiveSheet()->setCellValue('AR' . $row, $employee['hiring_type']);
                                       
                                         // $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, ($employee['emp_status'] == 'Y') ? 'Active' : 'Inactive');
                                        $objPHPExcel->getActiveSheet()->setCellValue('AS' . $row, ($employee['is_disabled'] == 'N') ? 'No' : 'Yes');
                                        $objPHPExcel->getActiveSheet()->setCellValue('AT' . $row, $employee['bank_ifsc']);
                                         $resignDate = !empty($employee['resign_date']) ? date('d/m/Y', strtotime($employee['resign_date'])) : '';
                                         $objPHPExcel->getActiveSheet()->setCellValue('AU' . $row, $resignDate);
										  $objPHPExcel->getActiveSheet()->setCellValue('AV' . $row, $employee['aexp_yr'].".".$employee['aexp_mnth']." Yr");
										$objPHPExcel->getActiveSheet()->setCellValue('AW' . $row, $employee['inexp_yr'].".". $employee['inexp_mnth']." Yr");
										$objPHPExcel->getActiveSheet()->setCellValue('AX' . $row, $employee['rexp_yr'].".".$employee['rexp_mnth']." Yr");
                             $row++;
                         }
    
        $objPHPExcel->setActiveSheetIndex(0);
    
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Resign_employee_data.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
	//////////////////////NAD report //////////
	public function grade_card_nad_report()
	{
		$this->load->view('header',$this->data);
		$this->data['exam_session']=$this->Admin_model->fetch_stud_curr_exam_ecr();
		$this->load->view($this->view_dir.'reports/grade_card_nad_report',$this->data);
		$this->load->view('footer');
	}
	
	
	public function student_gradesheet_excel()
	{  	
		$this->data['student_data']=$this->Admin_model->fetch_student_grade_data($_POST);
		$exam_sess = explode('-', $_POST['exam_session']);	
        $exam_id = $exam_sess[2];
		$this->data['sem']=$_POST['semester'];
		$this->data['exam_id']=$exam_id;
		$this->load->view($this->view_dir.'reports/student_gradesheet_excel_report',$this->data);
	}
	
	
	 public function employee_multi_status_change(){
     $this->load->view('header',$this->data);
	 $this->data['emp_list']= $this->Admin_model->getEmployees(0,0,'NY');
     $this->load->view($this->view_dir.'emp_multi_status_change',$this->data);
     $this->load->view('footer');
  }

    public function emp_multi_status_change(){
        $this->load->view('header',$this->data);
            $empsid=$_POST['empsid'];
            $status=$_POST['status'];

            $result['temp']=$this->Admin_model->changemultiEmpStatus($empsid,$status);
            if($result){
                $_SESSION['status']="Employee Status Updated ";
                redirect('admin/employee_list/');
                
                }
            else{
                 $_SESSION['status']='Some Problem Occured ...';
                redirect('admin/employee_list/');
            }   
            $this->load->view('footer');
    }
	
	
	//////////////////
	public function ot() {
        // Load the month selection view
        $this->load->view('header',$this->data);  
        $this->load->view('Admin/over_time');
        $this->load->view('footer');

    }

    public function extra_working_hours() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();


        // Set default month as current month
        $selected_month = $this->input->post('month') ? $this->input->post('month') : date('Y-m');

        // Fetch User IDs with condition where is_ot = 'Y'
        $this->db->distinct();
        $this->db->select('pb.UserId');
        $this->db->from('employee_master em');
        $this->db->join('punching_backup pb', 'pb.UserId = em.emp_id', 'left');
        $this->db->where('em.is_ot', 'Y');
        $this->db->like('pb.Intime', $selected_month);
        $query = $this->db->get();
        $userIds = $query->result_array();

      //  print_r($userIds);exit;
        $data = [];

        foreach ($userIds as $user) {
            $userId = $user['UserId'];
            $this->db->select('pb.UserId, DATE(pb.Intime) as Date, pb.extra_working_hours, pb.Intime, pb.Outtime, SUM(FLOOR(TIME_TO_SEC(extra_working_hours) / 3600)) AS total_extra_hours, CONCAT( em.fname, " ", em.mname, " ", em.lname, " ") as fullname');
            $this->db->from('punching_backup pb');
            $this->db->join('employee_master em', 'pb.UserId = em.emp_id', 'left');
            $this->db->where('pb.UserId', $userId);
            $this->db->where('em.is_ot', 'Y');
            $this->db->like('pb.Intime', $selected_month);
            $this->db->where('pb.STATUS', 'present');
            $this->db->where('pb.extra_working_hours !=', '');
            $this->db->where('TIME_TO_SEC(pb.extra_working_hours) >', 3480);
            $this->db->group_by('pb.UserId');
            $query = $this->db->get();                                             


          
            $results = $query->result_array();

            if ($results) {
                foreach ($results as &$result) {
                    $result['valuation'] = $result['total_extra_hours'] * 175; 
                }
                $data = array_merge($data, $results);
            }
        }

        $this->load->view('header',$this->data);  

        // Pass data to the view
        $this->load->view('Admin/over_time', ['data' => $data, 'selected_month' => $selected_month]);

        $this->load->view('footer');
    }
	
	   public function employee_multi_resign(){
     $this->load->view('header',$this->data);
	 $this->data['emp_list']= $this->Admin_model->getEmployees(0,0,'N');
	 $this->data['type']= 'resign';
     $this->load->view($this->view_dir.'emp_multi_status_change',$this->data);
     $this->load->view('footer');
  }
     public function emp_multi_resign_update(){
            $this->load->view('header',$this->data);
            $empsid=$_POST['empsid'];
            $res_date=$_POST['res_date'];
            $res_reason=$_POST['res_reason'];

            $result['temp']=$this->Admin_model->updatemultiEmpresigndet($empsid,$res_date,$res_reason);
            if($result){
                 $_SESSION['status']="Employee Resignation Details Updated";
                redirect('Employee/resign_list/');                
                }
            else{
                 $_SESSION['status']='Some Problem Occured ...';
               
                redirect('Employee/resign_list/');     
              }   
            $this->load->view('footer');
       }
	   
public function visiting_faculty_lecture_att(){
		$ddate='';
	 if(isset($_POST['month']) && $_POST['month']!=''){
		$ddate=$_POST['month'];
	 }
     $this->load->view('header',$this->data);
	 $this->data['lecture_det']=$this->Admin_model->fetch_visiting_faculty_lecture_att($ddate);
	 $this->data['mon']=$_POST['month'];
     $this->load->view($this->view_dir.'visiting_faculty_lecture_att',$this->data);
     $this->load->view('footer');
  }
////////////////code by siddesh-2025-07-22////////// 
public function update_visiting_lecture_consideration_status(){

    $DB1 = $this->load->database('umsdb', TRUE);
	$emp_id = $this->input->post('emp_id');
	$stream_id = $this->input->post('stream_id');
	$division = $this->input->post('division');
	$batch = $this->input->post('batch');
	$sub_id = $this->input->post('sub_id');
	$attendance_date = $this->input->post('attendance_date');
	$slot = $this->input->post('slot');
    $status = $this->input->post('status');
    $academic_year = $this->input->post('academic_year');

    $DB1->where('stream_id', $stream_id);
    $DB1->where('faculty_code', $emp_id);
    $DB1->where('subject_id', $sub_id);
    $DB1->where('attendance_date', $attendance_date);
    $DB1->where('academic_year', $academic_year);
    $DB1->where('slot', $slot);
    $updated = $DB1->update('lecture_attendance', ['is_nt_c' => $status]);
	//echo $DB1->last_query();exit;
    echo $updated ? 'success' : 'fail';
}

   public function export_student_credit_cgpa() {
    $this->load->library('excel');
    $this->load->model('Results_model');

    $stream_id        = $this->input->post('admission-branch');
    $exam_session     = $this->input->post('exam_session');
    $selected_semester = intval($this->input->post('semester'));

    $exam_id = 0;
    if (!empty($exam_session)) {
        $parts  = explode('-', $exam_session);
        $exam_id = isset($parts[2]) ? $parts[2] : 0;
    }

    if (!$stream_id || !$exam_id || !$selected_semester) {
        show_error("Invalid input parameters.");
    }

    if ($selected_semester % 2 === 0) {
        $includeSemesters = [$selected_semester - 1, $selected_semester];
    } else {
        $includeSemesters = [$selected_semester];
    }

    $results = $this->Results_model->fetch_student_credit_data($stream_id, $exam_id, $selected_semester);

    // Group by student (no logic change; just store more fields)
    $studentData = [];
    // Fill rows
	

    // Initialize Excel
    $object = new PHPExcel();
    $sheet  = $object->setActiveSheetIndex(0);

    // Keep your original headers first (unchanged) and APPEND the new ones
    $headers = [
        'Sr.no','Enrollment No','School Name','Full Name','Gender','Category','Stream','Total Credits','CGPA','Result',
        // appended (new) columns:
        'ABC No','Father Name','DOB','Current Semester','Admission Year','Academic Year',
        'Mobile','Email','Religion','Caste','Nationality','Physically Handicap','Total Registered Credits'
    ];

    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . '1', $header);
        $col++;
    }

    $rowNum = 2;
    $srno   = 1;
    foreach ($results as $row) {
		// echo '<pre>';
		// print_r($results);exit;

        $col = 'A';
        $totalCredits     = floatval($row['semester_credits']);
        $totalRegCredits  = floatval($row['registered_credites']);
        $cumulative_gpa   = floatval($row['semester_cgpa']);

        // (keep your classification logic exactly as-is)
        if ($cumulative_gpa >= 7.75) {
            $class = "FIRST CLASS WITH DISTINCTION";
        } elseif ($cumulative_gpa >= 6.75) {
            $class = "FIRST CLASS";
        } elseif ($cumulative_gpa >= 6.25) {
            $class = "HIGHER SECOND CLASS";
        } elseif ($cumulative_gpa >= 5.5) {
            $class = "SECOND CLASS";
        } elseif ($cumulative_gpa >= 4) {
            $class = "PASS";
        } else {
            $class = "FAIL";
        }

        // original columns
        $sheet->setCellValue($col++ . $rowNum, $srno++);
        $sheet->setCellValue($col++ . $rowNum, $row['enrollment_no']);
        $sheet->setCellValue($col++ . $rowNum, $row['school_name']);
        $sheet->setCellValue($col++ . $rowNum, $row['CNAME']);
        $sheet->setCellValue($col++ . $rowNum, $row['gender']);
        $sheet->setCellValue($col++ . $rowNum, $row['category']);
        $sheet->setCellValue($col++ . $rowNum, $row['stream_name']);
        $sheet->setCellValue($col++ . $rowNum, $totalCredits);

         if ($totalRegCredits == $totalCredits) {
            $sheet->setCellValue($col++ . $rowNum, $cumulative_gpa);
            $sheet->setCellValue($col++ . $rowNum, $class);
        } else {
            $sheet->setCellValue($col++ . $rowNum, '');
            $sheet->setCellValue($col++ . $rowNum, '');
        }

        // appended columns (just data output, no logic change)
        $sheet->setCellValue($col++ . $rowNum, $row['abc_no']);
        $sheet->setCellValue($col++ . $rowNum, $row['father_name']);
        $sheet->setCellValue($col++ . $rowNum, $row['dob']);
        $sheet->setCellValue($col++ . $rowNum, $row['current_semester']);
        $sheet->setCellValue($col++ . $rowNum, $row['admission_year']);
        $sheet->setCellValue($col++ . $rowNum, $row['academic_year']);
        $sheet->setCellValue($col++ . $rowNum, $row['mobile']);
        $sheet->setCellValue($col++ . $rowNum, $row['email']);
        $sheet->setCellValue($col++ . $rowNum, $row['religion']);
        $sheet->setCellValue($col++ . $rowNum, $row['caste']);
        $sheet->setCellValue($col++ . $rowNum, $row['nationality']);
        $sheet->setCellValue($col++ . $rowNum, $row['physically_handicap']);
        $sheet->setCellValue($col++ . $rowNum, $totalRegCredits);

        $rowNum++;
    
    }
    // Output Excel (unchanged)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="student_credit_cgpa_summary.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}


	
}
?>