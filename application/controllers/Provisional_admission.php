<?php
/*ini_set("display_errors", "On");
error_reporting(1);
error_reporting(E_ALL);*/

defined('BASEPATH') OR exit('No direct script access allowed');
class Provisional_admission extends CI_Controller 
{

	//error_reporting(E_ALL);

    var $currentModule="";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Provisional_adm_model";
    var $model;
    var $view_dir='Provisional/';
    
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
    //    ini_set('memory_limit', '1024M');
        $this->load->helper("url");		
        $this->load->library('form_validation');
		 //$this->load->library('upload');
        	$this->load->library('Message_api');
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add_ic etc.
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
    
    
 public function index(){
		$this->load->view('header', $this->data);
        
		//$this->data['eventList'] = $this->students_model->get_event_details();
		$this->load->view($this->view_dir . 'basicInformation_view', $this->data);
		$this->load->view('footer');
	}   
    
    public function bank_list()
    {
     if($_POST['type']=='CHLN')
        {
	
	$uni_bankdet = $this->Provisional_adm_model->university_bank_details();	
	 echo '<option value="" ' . $sel . '>Select Bank</option>';
    
	foreach ($uni_bankdet as $branch) {
										  if($branch['bank_id']==$indet[0]['bank_id'])
										  $sel ="selected";
										  else
										  $sel='';
											echo '<option value="' . $branch['bank_id'] . '" ' . $sel . '>' . $branch['bank_name'] . '</option>';
										}
        }
        else
        {
    $bank_details = $this->Provisional_adm_model->get_bank_details();   
    
    echo '<option value="" ' . $sel . '>Select Bank</option>';
    	foreach ($bank_details as $branch) {
										  if($branch['bank_id']==$indet[0]['bank_id'])
										  $sel ="selected";
										  else
										  $sel='';
											echo '<option value="' . $branch['bank_id'] . '" ' . $sel . '>' . $branch['bank_name'] . '</option>';
										}
        }
    }
    
	
	
	
	function list_admissions()
    {
		       
   		$this->load->view('header', $this->data);
    	$this->data['stud_data']	=  $this->Provisional_adm_model->list_admissions('N');
		$this->data['stud_data_confirm']	=  $this->Provisional_adm_model->list_admissions('Y');
      	//$this->data['ic_list']	=  $this->Provisional_adm_model->list_ics();	
        $this->load->view($this->view_dir . 'student_list_ajax', $this->data);//student_list
     	$this->load->view('footer');         
        
    }
	
	
	 function list_admissions_l()
    {
		       
   		$this->load->view('header', $this->data);
    	$this->data['stud_data']	=  $this->Provisional_adm_model->list_admissions();
		$this->data['stud_data_confirm']	=  $this->Provisional_adm_model->list_admissions('Y');
      	//$this->data['ic_list']	=  $this->Provisional_adm_model->list_ics();	
		//$this->Provisional_adm_model->count_all();
        $this->load->view($this->view_dir . 'student_list_ajax', $this->data);
     	$this->load->view('footer');         
        
    }
	
	 function list_admissions_ajax()
    {
		       
   		
		$role_id =$this->session->userdata('role_id');
		$year=$_POST['year'];
		$type_param=$_POST['type_param'];
		$Document_status=$_POST['Document_status'];
		$admission_status=$_POST['admission_status'];
		
		$type='N';
		if($admission_status=='Confirm'){
			$type='Y';
		}
		$list = $this->Provisional_adm_model->get_datatables($year,$type_param,$type,$Document_status,$admission_status);
		
		$data = array();$statusn='';$statusy='';
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			$row[] = $no;
			
			
			//$row[] = $customers->form_no;ums_admission/view_studentFormDetails/3168
			if($role_id==2 || $role_id==27){

				$row[] = '<a href="'.base_url().'ums_admission/edit_personalDetails/'.$customers->stud_id.'/pro" target="_blank">'.$customers->enrollment_no.'<a>';
				
				}else{
					$row[] = '<a href="'.base_url().'ums_admission/view_studentFormDetails/'.$customers->stud_id.'" target="_blank">'.$customers->enrollment_no.'<a>';
			}
			
			$course_id =$customers->course_id;
			
			if ($course_id == 3 || $course_id == 19 || $course_id == 12 || $course_id == 10 || $course_id == 35 || $course_id == 39 || $course_id == 22) {
				$uni_var = 'NA';
			} elseif ($customers->payment_id == '') {
				$uni_var = 'NO';
			} else {
				$uni_var = 'YES';
			}
			
			$row[] = $uni_var;
			$row[] = $customers->first_name;
			$row[] = $customers->email;
			$row[] = $customers->mobile;
			$row[] = $customers->adhar_card_no;
			$row[] = $customers->school_short_name;
			$row[] = $customers->stream_name;
			$row[] = $customers->admission_year;
			$row[] = $customers->nationality;
			$row[] = $customers->state_name;
			$row[] = $customers->district_name;
			$row[] = $customers->taluka_name;
			if($customers->docuemnt_confirm==""){
				$row[] = 'Pending';	
			}else{
				if($customers->docuemnt_confirm=='N'){
					$row[] = 'Pending';
				}else{
					$row[] = 'Confirm';
				}
			}
			if($customers->final_confirm==""){
				$row[] = 'Pending';	
			}else{
				if($customers->final_confirm=='N'){
					$row[] = 'Pending';
				}else{
					$row[] = 'Confirm';
				}
			}
			
			if($role_id==7){
				
				
				if($customers->confirm_admission==''){
			$current = 'Pending';
			$statusn='selected="selected"';
			$statusy='';	
			}else{
				if($customers->confirm_admission=='N'){
			$current = 'Pending';
			$statusn='selected="selected"';
			$statusy='';
				}else{
			$current = 'Done';
			$statusn='';
			$statusy='selected="selected"';
				}
				
			}
				
				
				$row[] = '<select name="confirm_admi" id="confirm_admi" class="confirm_admi" lang="'.$customers->stud_id.'" onchange="admissiom_chnage(this,'.$course_id.')">
				<option value="">Select</option>
				<option value="N" '.$statusn.'>Pending</option>
				<option value="Y" '.$statusy.'>Done</option>
				</select><input type="hidden" name="docuemnt_confirm" id="docuemnt_confirm" value="'.$customers->docuemnt_confirm.'"/>';
				
				}else {
			if($customers->confirm_admission==''){
			$row[] = 'Pending';		
			}else{
				if($customers->confirm_admission=='N'){
			$row[] = 'Pending';
				}else{
			$row[] = 'Done';
				}
			//$row[] = $customers->confirm_admission;
			}
			}
			
			//$row[] = $customers->confirm_date;
			//$row[] = '';
			
			
			

			$data[] = $row;
		}
	//	$count_all=$this->Provisional_adm_model->count_all();
//echo ($count_all);
//exit();




		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Provisional_adm_model->count_all('N',$year),
						"recordsFiltered" => $this->Provisional_adm_model->count_filtered($year,$type_param,'N',$Document_status,$admission_status),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
		
		
		
		
		
        
    }
	
	
	function confirm_admissions()
    {
		       
   		$this->load->view('header', $this->data);
    	$this->data['stud_data']	=  $this->Provisional_adm_model->list_admissions('Y');
      	//$this->data['ic_list']	=  $this->Provisional_adm_model->list_ics();	
		//$this->Provisional_adm_model->count_all();
        $this->load->view($this->view_dir . 'student_confirm_ajax', $this->data);
     	$this->load->view('footer');         
        
    }
	
	
	 function list_confirm_ajax()
    {
		       
   		
		$role_id =$this->session->userdata('role_id');
		$year=$_POST['year'];
		$type_param=$_POST['type_param'];
		$Document_status=$_POST['Document_status'];
		$admission_status=$_POST['admission_status'];
		
		$type='Y';
		if($admission_status=='Pending'){
			$type='N';
		}
		$list = $this->Provisional_adm_model->get_datatables($year,$type_param,'Y',$Document_status,$admission_status);
		//echo $DB1->last_query();exit;
		
	
		$data = array();$statusn='';$statusy='';
		
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			
			$row = array();
			//if($customers->confirm_admission=='Y'){
			$row[] = $no;
			
			if($role_id==2 || $role_id==27){
				$row[] = '<a href="https://erp.sandipuniversity.com/ums_admission/edit_personalDetails/'.$customers->stud_id.'/pro" target="_blank">'.$customers->enrollment_no_new.'<a>';			
			}else{
				$row[] = '<a href="https://erp.sandipuniversity.com/ums_admission/view_studentFormDetails/'.$customers->stud_id.'" target="_blank">'.$customers->enrollment_no_new.'<a>';
			}
			//$row[] = $customers->form_no;ums_admission/view_studentFormDetails/3168
			if($role_id==2 || $role_id==27){
				$row[] = '<a href="https://erp.sandipuniversity.com/ums_admission/edit_personalDetails/'.$customers->stud_id.'/pro" target="_blank">'.$customers->enrollment_no.'<a>';
			
			}else{
				$row[] = '<a href="https://erp.sandipuniversity.com/ums_admission/view_studentFormDetails/'.$customers->stud_id.'" target="_blank">'.$customers->enrollment_no.'<a>';
			}
			
			$row[] = $customers->form_number;
			$row[] = $customers->first_name;
			$row[] = $customers->email;
			$row[] = $customers->mobile;
			$row[] = $customers->school_short_name;
			$row[] = $customers->stream_name;
			$row[] = $customers->admission_year;
			$row[] = $customers->nationality;
			$row[] = $customers->state_name;
			$row[] = $customers->district_name;
			$row[] = $customers->taluka_name;
			$row[] = $customers->admission_date;
			if($customers->docuemnt_confirm==""){
			$row[] = 'Pending';	
			}else{
				if($customers->docuemnt_confirm=='N'){
			$row[] = 'Pending';
				}else{
			$row[] = 'Confirm';
				}
			}
			
			if($role_id==7){
				
				
			if($customers->confirm_admission==''){
			$current = 'Pending';
			$statusn='selected="selected"';
			$statusy='';	
			}else{
				if($customers->confirm_admission=='N'){
			$current = 'Pending';
			$statusn='selected="selected"';
			$statusy='';
				}else{
			$current = 'Done';
			$statusn='';
			$statusy='selected="selected"';
				}
				
			}
				
				 
				$row[] = '<select name="confirm_admi" id="confirm_admi" class="confirm_admi" lang="'.$customers->stud_id.'" onchange="admissiom_chnage(this)">
				<option value="">Select</option>
				<option value="N" '.$statusn.'>Pending</option>
				<option value="Y" '.$statusy.'>Done</option>
				</select><input type="hidden" name="docuemnt_confirm" id="docuemnt_confirm" value="'.$customers->docuemnt_confirm.'"/>';
				
				}else{
		
			if($customers->confirm_admission==''){
			$row[] = 'Pending';		
			}else{
			
			if($customers->confirm_admission=='N'){
			$row[] = 'Pending';
			}else{
			$row[] = 'Done';
			}
			//$row[] = $customers->confirm_admission;
			}
			}
			$row[] = $customers->username;
			$row[] = $customers->password;
			//$row[] = $customers->confirm_date;
			//$row[] = '';
			$data[] = $row;
			}
			

			
		//}
	//	$count_all=$this->Provisional_adm_model->count_all();
//echo ($count_all);
//exit();




		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Provisional_adm_model->count_all('Y',$year),
						"recordsFiltered" => $this->Provisional_adm_model->count_filtered($year,$type_param,'Y',$Document_status,$admission_status),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
		
		
		
		
		
        
    }
	
	public function check_uniform_payments(){
		//ini_set("display_errors", "On");
//error_reporting(1);
//error_reporting(E_ALL);
		$values=$this->input->post('org_frm');
		$id=$this->input->post('id');
		$studdata = $this->Provisional_adm_model->check_student_details($id);
		//echo $studdata[0]['nationality'];
		//exit;
		if($studdata[0]['nationality']=='Indian'){
			echo $stdata = $this->Provisional_adm_model->check_uniform_payments($values,$id);
		}else{
			echo 1;
		}
	}	
	
	public function Update_admission(){
		//ini_set("display_errors", "On");
//error_reporting(1);
//error_reporting(E_ALL);
		$values=$this->input->post('values');
		$id=$this->input->post('id');
		
		echo $stdata = $this->Provisional_adm_model->Update_admission($values,$id);
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	 function Admission_report()
    {
		       
   		$this->load->view('header', $this->data);
    	$this->data['stud_data']	=  $this->Provisional_adm_model->list_admissions();
      	//$this->data['ic_list']	=  $this->Provisional_adm_model->list_ics();	
		//$this->Provisional_adm_model->count_all();
        $this->load->view($this->view_dir . 'Admission_report_list', $this->data);
     	$this->load->view('footer');         
        
    }
	
	
	 function Admission_report_ajax()
    {
		       
   		
		$role_id =$this->session->userdata('role_id');
		$date=$_POST['date'];
		$type_param=$_POST['type_param'];
		$Document_status=$_POST['Document_status'];
		$admission_status=$_POST['admission_status'];
		$list = $this->Provisional_adm_model->get_datatables_report($date,$type_param,'N',$Document_status,$admission_status);
		//print_r($list);exit();
		$data = array();$statusn='';$statusy='';
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			$row[] = $no;
			
			
			//$row[] = $customers->form_no;ums_admission/view_studentFormDetails/3168
			
			
			
			$row[] = $customers->school_short_name;
			$row[] = $customers->stream_name;
			$row[] = $customers->current_year;
			$row[] = $customers->student_count;
			$row[] = $customers->Confirm_count;
			$row[] = $customers->student_count-$customers->Confirm_count;
			$row[] = $customers->totall_mh;
			$row[] = $customers->totall_omh;
			$row[] = $customers->totall_International;
			$row[] = $customers->totall_cancle;
			
			
			
			
		
			
			//$row[] = $customers->confirm_date;
			//$row[] = '';
			
			
			

			$data[] = $row;
		}
	//	$count_all=$this->Provisional_adm_model->count_all();
//echo ($count_all);
//exit();




		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Provisional_adm_model->count_all_report('N'),
						"recordsFiltered" => $this->Provisional_adm_model->count_filtered_report($date,$type_param,'N',$Document_status,$admission_status),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
		
		
		
		
		
        
    }
	
	
	
	
	
	
	
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// edit student personal details
	public function edit_personalDetails($stud_id)
    {
    // error_reporting(E_ALL);
//ini_set('display_errors', 1);
    	$this->load->helper('date_helper');
    	//test();die;
        $this->session->set_userdata('studId', $stud_id);
        $this->load->view('header',$this->data);  
        $this->data['states'] = $this->Ums_admission_model->fetch_states();
        $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
		$this->data['doc_list']= $this->Ums_admission_model->getdocumentlist();
		$this->data['category']= $this->Ums_admission_model->getcategorylist();
		$this->data['religion']= $this->Ums_admission_model->getreligionlist();
	    $this->data['course_year']= $this->Ums_admission_model->getCourseYRClg($college_id);
	    $this->data['branches']= $this->Ums_admission_model->getbranch($college_id);
	    $stdata = $this->Ums_admission_model->fetch_personal_details($stud_id);
	   
        $this->data['emp_list']= $this->Ums_admission_model->fetch_personal_details($stud_id);
         $this->data['local_address']= $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');
          $this->data['perm_address']= $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','PERMNT');
           $this->data['parent_address']= $this->Ums_admission_model->fetch_address_details($stud_id,'PARENT','PERMNT');
           $this->data['parent_details']= $this->Ums_admission_model->fetch_parent_details($stud_id);
            $this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id); 
            $loadd = $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');
	    $peradd = $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','PERMNT');
	    $parentadd = $this->Ums_admission_model->fetch_address_details($stud_id,'PARENT','PERMNT');
           
    
            $this->data['localcity']= $this->Ums_admission_model->fetch_distcity_details('taluka_master','district_id',$loadd[0]['district_id']);
             $this->data['localdistrict']= $this->Ums_admission_model->fetch_distcity_details('district_name','state_id',$loadd[0]['state_id']);
            $this->data['permcity']= $this->Ums_admission_model->fetch_distcity_details('taluka_master','district_id',$peradd[0]['district_id']);
            $this->data['permdistrict']= $this->Ums_admission_model->fetch_distcity_details('district_name','state_id',$peradd[0]['state_id']);
            $this->data['parentcity']= $this->Ums_admission_model->fetch_distcity_details('taluka_master','district_id',$parentadd[0]['district_id']);
             $this->data['parentdistrict']= $this->Ums_admission_model->fetch_distcity_details('district_name','state_id',$parentadd[0]['state_id']);
        
            $this->data['coursedet']= $this->Ums_admission_model->fetch_stcouse_details1($stdata[0]['admission_stream']);
            $cde = $this->Ums_admission_model->fetch_stcouse_details1($stdata[0]['admission_stream']);
            
               $this->data['stream']= $this->Ums_admission_model->fetch_stcouse_details($cde[0]['course_id']);
      //  $this->data['district'] =  $this->Ums_admission_model->fetch_stcouse_details->getStatewiseDistrict('18');
       //  $this->data['city'] =  $this->Ums_admission_model->fetch_stcouse_details->getStateDwiseCity('18','282');
        //$this->data['stud_addr']= $this->Ums_admission_model->fetch_address_details($stud_id);
        $this->load->view($this->view_dir.'personal_details',$this->data);
        $this->load->view('footer');
    }
	// edit student edu details
	public function edit_eduDetails()
    {
		//var_dump($_SESSION);
        $stud_id = $this->session->userdata('studId');
        $this->load->view('header',$this->data);     
		
		$this->data['qual']= $this->Ums_admission_model->fetch_stud_qualifications($stud_id);
		$this->data['ent_exams']= $this->Ums_admission_model->fetch_stud_entranceexams($stud_id);
		$this->data['subjects']= $this->Ums_admission_model->fetch_qua_subjects_details($stud_id);
        $this->load->view($this->view_dir.'educational_details',$this->data);
        $this->load->view('footer');
    }
	// edit student Docs &cert details
	public function edit_docsndcertDetails()
    {
        $stud_id = $this->session->userdata('studId');
        $this->load->view('header',$this->data);   
        
         $this->data['get_icert_details']= $this->Ums_admission_model->get_cert_details($stud_id,'Income');
         $this->data['get_ccert_details']= $this->Ums_admission_model->get_cert_details($stud_id,'Cast-category');
         $this->data['get_rcert_details']= $this->Ums_admission_model->get_cert_details($stud_id,'Residence-State Subject');
     //   $this->data['course_details']= $this->Ums_admission_model->getCollegeCourse($college_id);
	//	$this->data['doc_list']= $this->Ums_admission_model->getdocumentlist();
	    $this->data['doc_list']= $this->Ums_admission_model->userdoc_list($stud_id);
		$this->data['category']= $this->Ums_admission_model->getcategorylist();
		$this->data['religion']= $this->Ums_admission_model->getreligionlist();
	    $this->data['course_year']= $this->Ums_admission_model->getCourseYRClg($college_id);
	    $this->data['branches']= $this->Ums_admission_model->getbranch($college_id);
	    
        $this->data['emp_list']= $this->Ums_admission_model->fetch_personal_details($stud_id);
		
        $this->load->view($this->view_dir.'certificates_and_docs',$this->data);
        $this->load->view('footer');
    }
	// edit student reference details
	public function edit_refDetails()
    {
        $stud_id = $this->session->userdata('studId');
        $this->load->view('header',$this->data);   
        
        $this->data['is_from_reference']= $this->Ums_admission_model->get_referencedetails('is_from_reference',$stud_id);
	   $this->data['is_uni_employed']= $this->Ums_admission_model->get_referencedetails('is_uni_employed',$stud_id);
	    $this->data['is_uni_alumni']= $this->Ums_admission_model->get_referencedetails('is_uni_alumni',$stud_id);
	    $this->data['is_uni_student']= $this->Ums_admission_model->get_referencedetails('is_uni_student',$stud_id);
	    $this->data['is_reference']= $this->Ums_admission_model->get_referencedetails('is_reference',$stud_id);
	     $this->data['is_concern']= $this->Ums_admission_model->get_referencedetails('is_concern_ins',$stud_id);
	   $this->data['pmedia']= $this->Ums_admission_model->getpmedias(); 
        $this->data['emp_list']= $this->Ums_admission_model->fetch_personal_details($stud_id);
        $this->load->view($this->view_dir.'references',$this->data);
        $this->load->view('footer');
    }  
	// edit student payment details
	public function edit_paymentDetails()
    {
        $stud_id = $this->session->userdata('studId');
        $this->load->view('header',$this->data);  
       // echo $stud_id;
       // exit(0);
        
        $this->data['get_feedetails']= $this->Ums_admission_model->get_feedetails($stud_id);
		$this->data['get_bankdetails']= $this->Ums_admission_model->get_bankdetails($stud_id);
		 $this->data['emp_list']= $this->Ums_admission_model->fetch_personal_details($stud_id);
		 	$this->data['bank_details']= $this->Ums_admission_model->getbanks();
		 	 $this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id); 
		//$this->data['category']= $this->Ums_admission_model->getcategorylist();
	//	$this->data['religion']= $this->Ums_admission_model->getreligionlist();
	   // $this->data['course_year']= $this->Ums_admission_model->getCourseYRClg($college_id);
	 //   $this->data['branches']= $this->Ums_admission_model->getbranch($college_id);
	    
        //$this->data['emp_list']= $this->Ums_admission_model->fetch_personal_details($stud_id);
        $this->load->view($this->view_dir.'payments',$this->data);
        $this->load->view('footer');
    }  
	
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
	
	
	
	
	
	
    
    
function generate_payment_receipt($fees_id)
{
    
    //error_reporting(E_ALL);
//ini_set('display_errors', 1);


$data['fee_det']= $this->Provisional_adm_model->generate_payment_receipt($fees_id);

$html = $this->load->view($this->view_dir.'payment_receipt_pdf',$data,true);

	 $this->load->library('M_pdf');
        $mpdf=new mPDF('utf-8', 'A4');
          $mpdf=new mPDF('','', 0, '', 0, 0, 0,0, 0, 0,'L');
			
			
		$pdfFilePath = 'Receipt'.$fees_id. ".pdf";


	
		///	$mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
		//	$mpdf->SetHTMLFooter('<br><div class="row xbottom-text" style="margin-bottom:10px;height:30px;"></div>');
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		
		
		  $mpdf->AddPage('P', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            0, // margin top
            5, // margin bottom
            5, // margin header
            5); // margin footer
			$mpdf->WriteHTML($html);
			$mpdf->Output($pdfFilePath, "D");
   
     
    
}
    
   
   public function edit_fdetails()
{
    $stud_id =$_POST['feeid'];
	$this->data['bank_details']= $this->Provisional_adm_model->get_bank_details();
			$this->data['indet']= $this->Provisional_adm_model->get_feedet_byfeesid($stud_id);
			$this->data['online_det']= $this->Provisional_adm_model->online_feedet_byfeesid($stud_id);		
		$this->data['uni_bankdet']= $this->Provisional_adm_model->university_bank_details();		
		
       $this->load->view($this->view_dir.'edit_fee',$this->data);
}
 
 public function generate_receipt_no()
 {
     $this->Provisional_adm_model->generate_receipt_no();
 }
 
    
    	public function update_fee_det()
    {
        
  // error_reporting(E_ALL);
//ini_set('display_errors', 1);
		//print_r($_FILES);exit;
		date_default_timezone_set('Asia/Kolkata');
        $stud_id= $_POST['sid'];
      //  echo $stud_id;
     //   exit();
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
        $this->data['emp']= $this->Provisional_adm_model->update_fee_det($_POST,$payfile );
        redirect('Provisional_admission/viewPayments/'.$stud_id);
    }	
    
    
    
    
    
    
    public function add_payment()
    {
        
  // error_reporting(E_ALL);
//ini_set('display_errors', 1);
		//print_r($_FILES);exit;
		date_default_timezone_set('Asia/Kolkata');
        $stud_id= $_POST['sid'];
      //  echo $stud_id;
     //   exit();
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
        $this->data['emp']= $this->Provisional_adm_model->add_payment($_POST,$payfile );
        redirect('Provisional_admission/viewPayments/'.$stud_id);
    }	
    
    
    
    
    
    
    
    
    public function viewPayments($stud_id,$acyear='')
    {
        $this->session->set_userdata('studId', $stud_id);
        $this->load->view('header',$this->data);  
        
        
         
       
        $this->data['std_det']= $this->Provisional_adm_model->get_std_details_byid($stud_id);
        
     //     echo $this->data['std_det']['prov_reg_no'];
     //    exit();
         $this->data['adm_det']= $this->Provisional_adm_model->check_admission_confirm($this->data['std_det']['prov_reg_no']);
         
         
     //   echo $this->data['std_det'][]
          $this->data['installment']= $this->Provisional_adm_model->received_payment_details_in($stud_id);
          		$this->data['bank_details']= $this->Provisional_adm_model->get_bank_details();
          		
    $this->data['total_paid']= $this->Provisional_adm_model->total_fees_paid($stud_id);
    
    
          		
       //	$this->data['uni_bank_details']= $this->Provisional_adm_model->university_bank_details();   
  
        /*
        $this->data['emp']= $this->Ums_admission_model->fetch_personal_details($stud_id);
		$this->data['get_feedetails']= $this->Ums_admission_model->get_feedetails($stud_id,$acyear);
		$this->data['get_bankdetails']= $this->Ums_admission_model->get_bankdetails($stud_id);
		$this->data['bank_details']= $this->Ums_admission_model->getbanks();
			$this->data['admission_detail']= $this->Ums_admission_model->fetch_admission_details_all($stud_id,$acyear); 
		
		$this->data['admission_details']= $this->Ums_admission_model->fetch_admission_details($stud_id,$acyear); 
		$this->data['installment']= $this->Ums_admission_model->fetch_installment_details($stud_id);
			$this->data['canc_charges']= $this->Ums_admission_model->fetch_canc_charges($stud_id);
		//	var_dump($this->Ums_admission_model->fetch_canc_charges($stud_id));
			$this->data['get_refunds']= $this->Ums_admission_model->get_refundetails($stud_id);
			$this->data['tot_refunds']= $this->Ums_admission_model->get_tot_refunds($stud_id);
			
	
		$this->data['minbalance']= $this->Ums_admission_model->fetch_last_balance($stud_id);
		$this->data['totfeepaid']= $this->Ums_admission_model->fetch_total_fee_paid($stud_id);
			$this->data['acye']=$acyear; 
		*/
        $this->load->view($this->view_dir.'view_payment_details',$this->data);
		$this->load->view('footer');
        //$this->load->view('footer');
    } 
    
    
    
    
 public function search_student()
 {
$result = $this->Provisional_adm_model->search_student($_POST['smobile']);
   //  var_dump($result);
     //exit();
     if($result['mobile1']!='' )
{
    
 if($result['adm_id']!='')
 {
     //exit();
      $stat = "Student already taken provisional Admission";
   
   		$this->load->view('header', $this->data);
        
		$this->data['stat'] = $stat;
		$this->data['det'] = $result;
		$this->load->view($this->view_dir . 'basicInformation_view', $this->data);
		$this->load->view('footer');
   
 }
 else
 {
     redirect('Provisional_admission/update_student/'.$result['id']);
   $stat = "A";
   //return $stat;
 }
 
}
else
{
    redirect('Provisional_admission/add_student/'.$_POST['smobile']);
//return $stat;
    
}
     
     
 }
 
 
 public function get_referby_details()
 {
$data =  $this->Provisional_adm_model->get_referby_details();   




 }
 
 
 public function calculate_exem()
 {
         if($_POST['amt']!='')
    {
     if($_POST['stype']=="P") 
      {
    $exem = ceil($_POST['tut']*$_POST['amt']/100);   
      $appli = $_POST['appli'] - $exem;
      }
         if($_POST['stype']=="F") 
      {
      $appli = $_POST['appli'] -  $_POST['amt'];  
      $exem = $_POST['amt'];       
      }
        
        echo $appli."@".$exem;
    }
 }
 
 public function get_sujee_score()
 {
      $this->Provisional_adm_model->get_sujee_score(); 
     
 }
 
 
 
public function add_student($mob)
{
  // $this->Provisional_adm_model->last_prov_regno();
//   var_dump($_SESSION);
//   exit();
    
    if($_POST)
    {
       $this->Provisional_adm_model->add_student();
       
   
    }
    else
    {
    $this->load->model('School_model');
				$this->load->model('college_model');
			
				$this->data['state']        = $this->School_model->get_state_details();
				$this->data['city']         = $this->School_model->get_city_details();
 $this->data['collegeTypes'] = $this->college_model->get_collegetyps();
				$this->data['streams']      = $this->college_model->get_streams();
				$this->data['courses']      = $this->college_model->get_courses();
				$this->data['standards']    = $this->college_model->get_standards();
		$this->load->view('header', $this->data);
    $this->data['add_sources'] = $this->Provisional_adm_model->get_add_sources();
    
    
		//$this->data['eventList'] = $this->students_model->get_event_details();
		$this->load->view($this->view_dir . 'add', $this->data);
		$this->load->view('footer'); 
    }
 
 
    
}




public function get_ref_details()
{
     $this->Provisional_adm_model->get_ref_details();   
}

public function update_student($mob)
{
//    error_reporting(E_ALL);
//ini_set('display_errors', 1);
   // echo $mob;
  //  exit();
    if($_POST)
    {
       $this->Provisional_adm_model->update_student();
    }
    else
    {
    $this->load->model('School_model');
				$this->load->model('college_model');
			
			
			  // $this->data['std_det'] = $this->Provisional_adm_model->get_std_details();
			
			
				$this->data['state']        = $this->School_model->get_state_details();
				$this->data['city']         = $this->School_model->get_city_details();
                $this->data['collegeTypes'] = $this->college_model->get_collegetyps();
				$this->data['streams']      = $this->college_model->get_streams();
				$this->data['courses']      = $this->college_model->get_courses();
				$this->data['standards']    = $this->college_model->get_standards();
				
			
				
				    
		$this->load->view('header', $this->data);
		  $this->data['add_sources'] = $this->Provisional_adm_model->get_add_sources();
		  
		  $stdat =  $this->Provisional_adm_model->search_student_byid($mob);
	//	  $stdat =  $this->Provisional_adm_model->search_student($mob);
		if($stdat['ic_code']=='SF_REF_18')  
		  {
		      if($stdat['executive_id']==$stdat['event_code'])
		      {
		      $ref_type="STAFF";  
		       $ref_id=$stdat['executive_id'];
		  	$this->data['ref_type']    =  $ref_type;    
		 	$this->data['ref_id']    =  $ref_id;        
		$this->data['staff_list']    = $this->Provisional_adm_model->list_staff(); 	      
		      }
		      else
		      {
		      $ref_type="STUD"; 
		            $ref_id=$stdat['event_code'];
	
			  	$this->data['ref_type']    =  $ref_type;    
		 	$this->data['ref_id']    =  $ref_id;   
		            
	//	$this->data['stud']    = $stdat['event_code']; 	      
		      
		      }
		     // $ref="";
		  // $iccode =  $stdat;  
		  }
			else if($stdat['ic_code']=='digital')  
		  {
		      $ref="";
		  }
	else
	{
	    
	     $ref_type="IC";
	  $ref_id =$stdat['ic_code']; 
	  
	  		  	$this->data['ref_type']    =  $ref_type;    
		 	$this->data['ref_id']    =  $ref_id;   
	  
	  
	 		$this->data['ic_list']    = $this->Provisional_adm_model->list_ics();    
	    
	}
		  
    //$this->data['student_det'] = $this->Provisional_adm_model->search_student($mob);
   $this->data['student_det'] = $this->Provisional_adm_model->search_student_byid($mob); 
    
        $this->data['city'] = $this->Provisional_adm_model->city_by_state($stdat['state_id']);
    
    	$this->data['course_cat'] = $this->Provisional_adm_model->get_course_category($stdat['highest_qualification']);

   $this->data['streams'] = $this->Provisional_adm_model->get_category_stream($stdat['course_category'],$stdat['highest_qualification']);

		$this->load->view($this->view_dir . 'update_student', $this->data);
		$this->load->view('footer'); 
    }
 
    
}




public function update_provisional($mob)
{

    if($_POST)
    {
        $prov='2';
       $this->Provisional_adm_model->update_student($prov);
    }
    else
    {
    $this->load->model('School_model');
				$this->load->model('college_model');
			
			
			  // $this->data['std_det'] = $this->Provisional_adm_model->get_std_details();
			
			
				$this->data['state']        = $this->School_model->get_state_details();
				$this->data['city']         = $this->School_model->get_city_details();
                $this->data['collegeTypes'] = $this->college_model->get_collegetyps();
				$this->data['streams']      = $this->college_model->get_streams();
				$this->data['courses']      = $this->college_model->get_courses();
				$this->data['standards']    = $this->college_model->get_standards();
				
			
				
				    
		$this->load->view('header', $this->data);
		  $this->data['add_sources'] = $this->Provisional_adm_model->get_add_sources();
		  $stdat =  $this->Provisional_adm_model->get_std_details_byid($mob);
		if($stdat['admission_refer_by']=='STAFF')  
		  {
		    
		        	$this->data['ref_type']="STAFF";  
		$this->data['staff_list']    = $this->Provisional_adm_model->list_staff(); 	      
		 $this->data['ref_id'] =$stdat['admission_refer_id'];   
		
		  }
		  

  	else if($stdat['admission_refer_by']=='IC')
	{
	    
	       	$this->data['ref_type']="IC";
	  $this->data['ref_id'] =$stdat['admission_refer_id'];      
	 		$this->data['ic_list']    = $this->Provisional_adm_model->list_ics();    
	    
	}
   else 
	 {
	     
	      	$this->data['ref_type']=$stdat['admission_refer_by'];
	 $this->data['ref_id'] =$stdat['admission_refer_id'];
	  
	  
		  }

		  
    $this->data['student_det'] = $this->Provisional_adm_model->get_std_details_byid($mob);
        $this->data['city'] = $this->Provisional_adm_model->city_by_state($stdat['state_id']);
    
    	$this->data['course_cat'] = $this->Provisional_adm_model->get_course_category($stdat['highest_qualification']);

   $this->data['streams'] = $this->Provisional_adm_model->get_category_stream($stdat['course_category'],$stdat['highest_qualification']);

		$this->load->view($this->view_dir . 'update_provisional', $this->data);
		$this->load->view('footer'); 
    }
 
    
}












public function get_course_category() {
        //echo $_POST['std1'];
        //exit;
       // error_reporting(E_ALL);
  // ini_set('display_errors', 1);
        $std_cat = $this->Provisional_adm_model->get_course_category($_POST['std1']);
       // var_dump($std_cat);
        //print_r($std_cat);
        $cat='<option value="">Select School</option>';
        foreach ($std_cat as $val) {
          
           $cat .='<option value="'.$val['school_id'].'">'.$val['school_name'].'</option>';
           
        }
        echo $cat;
    }



public function get_years()
{
     $this->Provisional_adm_model->get_years();
}



    public function get_course_stream() {
           //    error_reporting(E_ALL);
 // ini_set('display_errors', 1);
        //echo $_POST['std'];
        $std_cat = $this->Provisional_adm_model->get_category_stream();
       // print_r($std_cat);
           $cat='<option value="">Select Stream</option>';
          //  $std_cat1 = $this->Provisional_adm_model->get_category_stream_list($std_cat['course']);
            foreach ($std_cat as $val1) {
               $cat .='<option value="'.$val1['sp_id'].'">'.$val1['sprogramm_name'].'</option>';
           
            }
        echo $cat;
    }


 public function payment_details($stdid){

               if($_POST)
    {
            //     error_reporting(E_ALL);
//ini_set('display_errors', 1);
        		if(!empty($_FILES['payfile']['name'])){
			$filenm=$stdid.'-'.rand().'-'.$_FILES['payfile']['name'];
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
        
     
     
     
     
     	if(!empty($_FILES['hpayfile']['name'])){
			$filenm=$stdid.'-'.rand().'-'.$_FILES['hpayfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('hpayfile')){
				$uploadData = $this->upload->data();
				$hpayfile = $uploadData['file_name'];
			}else{
				$hpayfile = '';
			}
		}
		else{
			$hpayfile = '';
		}
        
     
     
        
        
        
        
        
       $this->Provisional_adm_model->add_payment_details($_POST,$payfile,$hpayfile);
    }
    else
    {
        
                $stream = $this->Provisional_adm_model->get_std_details_byid($stdid);
                
                
        $std_data = $this->Provisional_adm_model->calculate_applicable_fees($stream['course_interested'],$stream['admission_year']);
        
          $this->data['stid']=$stdid;
		$this->load->view('header', $this->data);
        
        	$this->data['acct_data'] = $std_data;
        
		$this->data['bank_details'] = $this->Provisional_adm_model->get_bank_details();
		
				$this->data['uni_bank_details'] = $this->Provisional_adm_model->university_bank_details();
				
		$this->load->view($this->view_dir . 'payment_details', $this->data);
		$this->load->view('footer');
		
    }
		
	}   
    
    
    
    
    
     public function update_payment_details($stdid){

               if($_POST)
    {
            //     error_reporting(E_ALL);
//ini_set('display_errors', 1);
        		if(!empty($_FILES['payfile']['name'])){
			$filenm=$stdid.'-'.rand().'-'.$_FILES['payfile']['name'];
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
        
     
     
     
     
     	if(!empty($_FILES['hpayfile']['name'])){
			$filenm=$stdid.'-'.rand().'-'.$_FILES['hpayfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('hpayfile')){
				$uploadData = $this->upload->data();
				$hpayfile = $uploadData['file_name'];
			}else{
				$hpayfile = '';
			}
		}
		else{
			$hpayfile = '';
		}
        
     
     
        
        
        
        
        
       $this->Provisional_adm_model->update_payment_details($_POST,$payfile,$hpayfile);
    }
    else
    {
        
         $this->data['acad'] = $this->Provisional_adm_model->get_fees_details_academic($stdid);
        
         $this->data['hostel'] = $this->Provisional_adm_model->get_fees_details_hostel($stdid);
         
         
        
        
        	$this->data['uni_bank_details'] = $this->Provisional_adm_model->university_bank_details();
        
                $stream = $this->Provisional_adm_model->get_std_details_byid($stdid);
                        //var_dump($stream);
                
        $std_data = $this->Provisional_adm_model->calculate_applicable_fees($stream['course_interested'],$stream['admission_year']);
        
    //    var_dump($std_data);
    //    exit();
        
        
          $this->data['stid']=$stdid;
		$this->load->view('header', $this->data);
        
        	$this->data['acct_data'] = $std_data;
     	$this->data['adm_remark'] = $stream;
        
		$this->data['bank_details'] = $this->Provisional_adm_model->get_bank_details();
		$this->load->view($this->view_dir . 'update_payment_details', $this->data);
		$this->load->view('footer');
		
    }
		
	}   
    
    
    
    
       
    function jtest()
    {
  $test = NEW Message_api();
					$mob = "9821739610";
				    //$mob = trim('9987928501');mobile1
					$content="Dear 
You have been registered for 
Your Reference Number is

Regards,
Sandip University";
			$test->send_sms($mob,$content);
        
    }
    
    
    
    function test()
    {
 echo $this->Provisional_adm_model->last_receipt_no();
        
    }
    
    
    function generate_challan($stdid,$type,$fees_id)
    {
   
    $this->datab['students']=$this->Provisional_adm_model->list_admissions($stdata);
     
    $this->datab['student_data']=$this->Provisional_adm_model->get_std_details_byid($stdid,5);
    
    $this->datab['bank_acount']=$this->Provisional_adm_model->university_bank_details($this->datab['student_data']['bank_id']); 
    
    
       $this->datab['fees']=$this->Provisional_adm_model->get_feedet_byid($stdata);
     $this->datab['academics']=$this->Provisional_adm_model->get_academic_byid($stdata);
        
  $this->datab['refer_by']=$this->Provisional_adm_model->referby_details($this->datab['students']);     
       
   // var_dump($this->Provisional_adm_model->referby_details($this->datab['students']));    
        
        //exit();
    //    print_r($this->Provisional_adm_model->list_admissions($stdata));
         
//echo $html = $this->load->view($this->view_dir . 'adm_form', $this->data);
//$html = $this->load->view($this->view_dir . 'adm_form', $this->datab,true);
$html = $this->load->view($this->view_dir . 'challan_pdf', $this->datab,true);
	//	echo $html;
		//	exit();
		
		 $this->load->library('M_pdf');
        $mpdf=new mPDF('utf-8', 'A4');
          $mpdf=new mPDF('','', 0, '', 0, 0, 0,0, 0, 0,'L');
			
			
		$pdfFilePath = 'Challan'.$this->datab['students'][0]['prov_reg_no']. ".pdf";


			
			$stylpath = base_url() . "css/style.css";
			$bootpath = base_url() . "css/bootstrap.css";
		    $fontpath = base_url() . "css/font-awesome.css";
		///	$mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
		//	$mpdf->SetHTMLFooter('<br><div class="row xbottom-text" style="margin-bottom:10px;height:30px;"></div>');
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		
		
		  $mpdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            5, // margin top
            5, // margin bottom
            5, // margin header
            5); // margin footer
			$mpdf->WriteHTML($html);
			$mpdf->Output($pdfFilePath, "D");
   
   
   
   
   
   
   
   
   
   
   
        
    }
    
    
    
    
    
    
    
    
    
    
    function generate_form_pdf($stdata)
    {

    // error_reporting(E_ALL);
//ini_set('display_errors', 1);  
      $this->datab['students']=$this->Provisional_adm_model->list_admissions($stdata);
       $this->datab['fees']=$this->Provisional_adm_model->get_feedet_byid($stdata);
     $this->datab['academics']=$this->Provisional_adm_model->get_academic_byid($stdata);
        
  $this->datab['refer_by']=$this->Provisional_adm_model->referby_details($this->datab['students']);     
       
   // var_dump($this->Provisional_adm_model->referby_details($this->datab['students']));    
        
        //exit();
    //    print_r($this->Provisional_adm_model->list_admissions($stdata));
         
//echo $html = $this->load->view($this->view_dir . 'adm_form', $this->data);
//$html = $this->load->view($this->view_dir . 'adm_form', $this->datab,true);
$html = $this->load->view($this->view_dir . 'adm_pdf', $this->datab,true);
	//	echo $html;
		//	exit();
		
		 $this->load->library('M_pdf');
        $mpdf=new mPDF('utf-8', 'A4');
          $mpdf=new mPDF('','', 0, '', 15, 15, 15,0, 0, 0,'L');
			
			
		$pdfFilePath = 'Admission_form_'.$this->datab['students'][0]['prov_reg_no']. ".pdf";


			
			$stylpath = base_url() . "css/style.css";
			$bootpath = base_url() . "css/bootstrap.css";
		    $fontpath = base_url() . "css/font-awesome.css";
		///	$mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
		//	$mpdf->SetHTMLFooter('<br><div class="row xbottom-text" style="margin-bottom:10px;height:30px;"></div>');
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$mpdf->WriteHTML($html);
			$mpdf->Output($pdfFilePath, "D");
        
    
        

        
        
        
        

    }



public function update_payment_status()
{
       $this->Provisional_adm_model->update_payment_status();    
    
}




public function received_payment_details()
{
if($_POST)
{
    
// error_reporting(E_ALL);
//ini_set('display_errors', 1);
    
      $this->data['payment_data']	=  $this->Provisional_adm_model->received_payment_details();
       $this->load->view($this->view_dir . 'payment_list_excel.php', $this->data);
}
else
{
    	$this->load->view('header', $this->data);
   $this->data['payment_data']	=  $this->Provisional_adm_model->received_payment_details();
   	
        $this->load->view($this->view_dir . 'payment_list', $this->data);
     	$this->load->view('footer');       
}       
           
}


public function search_received_payment_details()
{

    //	$this->load->view('header', $this->data);
   $this->data['payment_data']	=  $this->Provisional_adm_model->received_payment_details_search();
   	
        echo $this->load->view($this->view_dir . 'ajax_payment_list', $this->data);
     //	$this->load->view('footer');       
        
           
}






    public function add_edu_details($suid) {
        //$stud_id = $this->session->userdata('user_id');
            if($_POST)
    {
       $this->Provisional_adm_model->add_edu_details();
    }
    else
    {
        $this->data['stid']=$suid;
	$this->load->view('header', $this->data);
        $this->load->view($this->view_dir . 'education_detail_view', $this->data);
     	$this->load->view('footer');   
        
    }
    }
    
    
    
    
    public function update_edu_details($suid) {
        
 //    error_reporting(E_ALL);
//ini_set('display_errors', 1);
        //$stud_id = $this->session->userdata('user_id');
 
 //var_dump($_POST);   
// exit();
            if($_POST)
    {
      //  echo "jugal";
       // exit();
       $this->Provisional_adm_model->update_edu_details();
    }
    else
    {
        
   //     echo "jugal";
        $this->data['stud_det'] =  $this->Provisional_adm_model->get_std_details_byid($suid);
       $this->data['edu_det'] =  $this->Provisional_adm_model->fetch_edu_details($suid);  
        
	    $this->load->view('header', $this->data);
        $this->load->view($this->view_dir . 'education_detail_update', $this->data);
     	$this->load->view('footer');   
        
    }
    }
    

    
    
    function list_admissions_demo()
    {
		$this->load->library("pagination");
        $config = array();
        $config['base_url'] = base_url() . "provisional_admission/list_admissions_demo";
        $config['total_rows'] =3000; //$this->Provisional_adm_model->admissions_get_count();
        $config['per_page'] = 100;
        $config['uri_segment'] = 3;
      //  $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
//exit;
//print_r($this->pagination->create_links());
//exit;
       
    	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);
        $mobile='';
   		$this->load->view('header', $this->data);
		$this->data['per_page'] = $page;
		$this->data['new_links'] = $this->pagination->create_links();
        $this->data['stud_data']	=  $this->Provisional_adm_model->list_admissions_new($mobile,$config["per_page"], $page);
      	$this->data['ic_list']	=  $this->Provisional_adm_model->list_ics();	
        $this->load->view($this->view_dir . 'student_list_demo', $this->data);
     	$this->load->view('footer');         
        
    }

    
    
	
	
    
    function studentwise_list(){
           $year='2018';
          $this->data['academic_year']=$year;
          $this->data['stud_data']=$this->Provisional_adm_model->provisional_admission_student_wise($year); 
          
          $this->load->view($this->view_dir.'student_admission_excel', $this->data);
    }
    
    function new_search(){
          $new_search=$this->input->post('new_search'); 
          $searchby=$this->input->post('searchby'); 
		  $status=$this->input->post('status');
          //	$this->load->view('header', $this->data);
   $this->data['payment_data']= $this->Provisional_adm_model->received_payment_details_new_search($new_search,$status, $searchby);
   	
        echo $this->load->view($this->view_dir . 'ajax_payment_list', $this->data);
    }
	
	
	function Send_login_details(){
		 $this->load->view('header', $this->data);
        $this->load->view($this->view_dir . 'Send_login_details', $this->data);
     	$this->load->view('footer'); 
		
		
	}
	
	
	
	
	
	
	function send_login(){
		
		
		$prn=$this->input->post('enrollment_no');
		
	echo	$id=$this->Provisional_adm_model->send_login();
		
		
		
	}
	
	function create_login(){
		
		
		 $prn=$this->input->post('enrollment_no');
		
		echo $id=$this->Provisional_adm_model->create_student_login_by_prn($prn);
		
		
		
	}
	
	
	function send_login_credentials_new()
{
	exit();
		//error_reporting(E_ALL);
	   $DB1 = $this->load->database('umsdb', TRUE);
              
		$DB1->select("*");
		$DB1->from("user_master");
			//$DB1->like('username', "19", 'after');
		$DB1->where("um_id >",36227);
		$DB1->where("roles_id",4);
		$DB1->where("status",'Y');
		$DB1->order_by("um_id", "asc");
		$query=$DB1->get(); 
		/*echo $DB1->last_query();
		exit(0);
		die;*/
		
		$result = $query->result_array(); 

    
        $s=1;
       $p=1;
    
   for($i=0;$i<count($result);$i++)
   {
      
      if($result[$i]['roles_id']=='4')
     {
   //  $sdet = $this->get_login_list('user_master','um_id',$_POST['um_id'],'roles_id','4');

$udet = $this->get_student_detail_by_prn_new_for_login_sms($result[$i]['username']);
//print_r($udet);//exit;
//$fname = $udet['first_name'].' '.$udet['middle_name'].' '.$udet['last_name'];
if($udet['mobile']!='')
{
$mobile= $udet['mobile'];
//$mobile= '8850633088';

$username = $result[$i]['username'];
$password = $result[$i]['password'];
$sms_message ="Dear Student
To get your academic information and regular updates kindly logon to
https://www.sandipuniversity.edu.in/erp-login.php
Username: $username
Password: $password
Thank you
Sandip University.
";

//echo "<br>stu".$mobile.">>".$sms_message;exit;

  
	$sms=urlencode($sms_message);

	$smsGatewayUrl = "http://bulksms.bulkfactory.in/api/v2/sms/send?access_token=b5bb44175fe4aafb9b7e3b7c482d4b8e&message=$sms&sender=SANDIP&to=$mobile&service=T";  
	$smsgatewaydata = $smsGatewayUrl;
	$url = $smsgatewaydata;
	$ch = curl_init();                       // initialize CURL
	curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);         
        
  $s++;
  //exit;
}
     }
    /* if($result[$i]['roles_id']=='9')
     {

  $updet = $this->get_student_detail_by_prn_new_for_login_sms($result[$i]['username']);
  $pmob = $this->fetch_parent_details($updet['stud_id']);
  //print_r($pmob);
 if(!empty($pmob[0]['parent_mobile2']))
 {
//$mobile= $pmob[0]['parent_mobile2'];
$mobile= '8850633088';

$username = $result[$i]['username'];
$password = $result[$i]['password'];
$sms_message ="Dear Parent
To get your Ward academic information and regular updates kindly logon to
https://www.sandipuniversity.edu.in/erp-login.php
Username: $username
Password: $password
Thank you
Sandip University
";
   $sms=urlencode($sms_message);
$smsGatewayUrl = "http://bulksms.bulkfactory.in/api/v2/sms/send?access_token=b5bb44175fe4aafb9b7e3b7c482d4b8e&message=$sms&sender=SANDIP&to=$mobile&service=T";  
        $smsgatewaydata = $smsGatewayUrl;
        $url = $smsgatewaydata;

        $ch = curl_init();                       // initialize CURL
        curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch); 


  $p++;
 }
     }*/
    
   //exit; 
   }
    
    echo $s."##".$p;
    
   
    
}
	
	

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
}
    