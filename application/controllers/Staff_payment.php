<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//ini_set('error_reporting', E_ALL);
class Staff_payment extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="employee_income_detail";
    var $model_name="Staff_payment_model";
    var $model;
    var $view_dir='Staff_payment/';
    
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        $this->load->helper("url");	
 $this->load->helper("convertexcel");		
        $this->load->library('form_validation');
        $this->load->library('Message_api');
       
         if(!$this->session->has_userdata('uid'))
        redirect('login');  
        /* if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
           $title=$this->master_arr['index']; */
       
        
        $this->currentModule=$this->uri->segment(1);
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
        $this->load->model('Admin_model');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		
			
		$allowed_functions = ['salary_slip','download_salary_slip'];

        if ($this->session->userdata("role_id") != 1 && $this->session->userdata("role_id") != 5 && $this->session->userdata("role_id") != 6 && $this->session->userdata("role_id") != 48 && $this->session->userdata("role_id")!=33 && !in_array($this->router->fetch_method(), $allowed_functions)) {
            redirect('home');
        }	
			
			
    }
    
    public function income_details()
    {
		/* */
         global $model;
        $this->load->view('header',$this->data); 
		
		$this->data['school_list']= $this->Admin_model->getAllschool();	 
        $this->data['dept_list']= $this->Admin_model->getAllDepartments();	
       // $this->data['emp_list']=
          if(isset($_POST)&&!empty($_POST)){			
		    $income['school']=$this->input->post('emp_school');
            $income['dept']=$this->input->post('department');		
		    $income['dt']=$this->input->post('attend_date');
			$d = date_parse_from_format("Y-m-d", $income['dt']);
								//print_r($d);
								$msearch=$d["month"];
							$month_name = date("F", mktime(0, 0, 0, $msearch, 10));
                                $ysearch=$d["year"];
			$dt1=$ysearch.'-'.$msearch."-01";	
			$income['dt']=$ysearch;
		 $this->data['emp_income']=$this->Staff_payment_model->getEmpList($ysearch,$msearch);
	     /*  echo "<pre>"; print_R( $this->data['emp_income']);"</pre>";
		  exit;  */ 
		//  $cnt =  count($this->data['emp_income']);
		 
		  if(empty($this->data['emp_income'])){
$this->data['flag'] = '1';
			 $this->data['emp_income']=$this->Staff_payment_model->fetchEmpListForAddingIncome(); 
			 $this->session->set_flashdata('message1','No Staff Income detail Defined.');
		  }else{
			  $this->data['flag'] = '0';
			   $this->data['emp_income'] = $this->Staff_payment_model->get_income_details($ysearch,$msearch);
			  $this->session->set_flashdata('message1','');
		  }
		  
		  }
		  $this->data['dt1']=$dt1;//searched date
         $this->data['month_name']=$month_name;
         $this->data['year_name']=$ysearch;
        $dept= $this->Admin_model->getDepartmentById($this->input->post('department'));//$this->data['emp_income'][0]['college_name'];
        $this->data['fordepart']=$dept[0]['department_name'];
		$sch=$this->Admin_model->getSchoolById($this->input->post('emp_school'));//data['emp_income'][0]['department_name'];
        $this->data['forschool']=$sch[0]['college_name'];
		$this->load->view($this->view_dir.'income_details',$this->data);
        $this->load->view('footer'); 
    }
	public function add_income_details(){   
	
              $add_income=$this->Staff_payment_model->add_income_details($_POST);
			  /* print_r($add_income);
			  die(); */
               if($add_income==1){
				   $this->session->set_flashdata('message1','Staff Income detail updated successfully......');
				   redirect('staff_payment/income_details');
			   }			  
		}
		
/***********************************************Staff Deduction **************************/
public function staff_deductions(){
	if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6){}else{
			redirect('home');
		}
	 $this->load->view('header',$this->data); 	
	 $menu_name='staff_payment/staff_deductions';        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name); 
		//$this->data['school_list']= $this->Admin_model->getAllschool();	 
       // $this->data['dept_list']= $this->Admin_model->getAllDepartments();
	  if(isset($_POST)&&!empty($_POST)){			
		   // $income['school']=$this->input->post('emp_school');
            //$income['dept']=$this->input->post('department');		
		    $income['dt']=$this->input->post('attend_date');
			$d = date_parse_from_format("Y-m-d", $income['dt']);
								//print_r($d);
								$msearch=$d["month"];
							$month_name = date("F", mktime(0, 0, 0, $msearch, 10));
                                $ysearch=$d["year"];
			$dt1=$ysearch.'-'.$msearch."-01";	
			$income['dt']=$ysearch;
			$income['mn']=$msearch;
$att_chk =$this->Staff_payment_model->check_final_monthly_attendance($income['mn'],$ysearch);  

if(count($att_chk) > 0){
		 $this->data['emp_deduction']=$this->Staff_payment_model->getEmpListForDeductions($income);
	      //echo "<pre>"; print_R($this->data['emp_deduction']);"</pre>";
		  //exit;   
		 $this->data['ma']='1';
		  if(empty($this->data['emp_deduction'])){
			 $dedc = $this->Staff_payment_model->getEmpListForDeductions1($income);
			 $dcnt = count($dedc);
			 if($dcnt > 0){
				 $this->data['emp_deduction'] = $dedc;
				 $this->data['ins']='2';
			 }else{
				 $this->data['ins']='1';
			   $this->data['emp_deduction']=$this->Staff_payment_model->fetchEmpListForAddingIncome1($msearch,$ysearch);//here for deduction fetching employee list 
			 }
			  //$this->session->set_flashdata('message1','No staff Deductions Added for searched date.');
			  
		  }else{
			  $this->session->set_flashdata('message1','');
			  $this->data['ins']='3';
		  } 
		  
		  }else{
			$this->data['ma']='2';
		}

		}
         $this->data['dt1']=$dt1;//searched date
	     $this->data['month_name']=$month_name;
         $this->data['year_name']=$ysearch;
        $dept= $this->Admin_model->getDepartmentById($this->input->post('department'));//$this->data['emp_income'][0]['college_name'];
        $this->data['fordepart']=$dept[0]['department_name'];
		$sch=$this->Admin_model->getSchoolById($this->input->post('emp_school'));//data['emp_income'][0]['department_name'];
        $this->data['forschool']=$sch[0]['college_name'];
		$this->load->view($this->view_dir.'staff_deductions',$this->data);
        $this->load->view('footer'); 
}

public function add_staff_deductions(){
	 $add_deduct=$this->Staff_payment_model->add_staff_deductions_details($_POST);
			  /* print_r($add_income);
			  die(); */
               if($add_deduct==1){
				   $this->session->set_flashdata('message1','Staff Deductions details Saved successfully......');
				   redirect('staff_payment/staff_deductions');
			   }
}	

/***********************************Staff Salary Calculation************************/
public function staff_salary(){
	if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==1){}else{
			redirect('home');
		}
	//ini_set('error_reporting', E_ALL);
	$this->load->view('header',$this->data); 	 
		$this->data['school_list']= $this->Admin_model->getAllschool();	 
        $this->data['dept_list']= $this->Admin_model->getAllDepartments();
        $menu_name='staff_payment/staff_salary';        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		$this->data['attend_date']=$this->input->post('attend_date');
		if(!empty($this->input->post('attend_date'))){
			$income['dt']=$this->input->post('attend_date');
			$d = date_parse_from_format("Y-m-d", $income['dt']);
			$msearch=$d["month"];
			$ysearch=$d["year"];
			$dt1=$ysearch.'-'.$msearch."-01";
			$this->data['dt1']=$dt1;//searched date
			$this->data['month_name']=$msearch;
			$this->data['year_name']=$ysearch;
			$sal_mon = $this->Staff_payment_model->check_monthly_earning_deduction($msearch,$ysearch);
		
		}else{
			$d = date_parse_from_format("Y-m-d",date('Y-m-d'));
			$msearch=$d["month"];
			$ysearch=$d["year"];
			$income['dt']= date('Y-m');
		}
		
		//print_r($sal_mon);
		if(count($sal_mon) <= '0'){
			if(isset($_POST)&&!empty($_POST)){
				//$income['school']=$this->input->post('emp_school');
				//    $income['dept']=$this->input->post('department');		
				$income['dt']=$this->input->post('attend_date');
				$d = date_parse_from_format("Y-m-d", $income['dt']);
				//print_r($d);
				$msearch=$d["month"];
				$month_name = date("F", mktime(0, 0, 0, $msearch, 10));
				$ysearch=$d["year"];
				$dt1=$ysearch.'-'.$msearch."-01";	
				$income['dt']=$ysearch;
				$income['mn']=$msearch;
				$att_chk =$this->Staff_payment_model->check_final_monthly_attendance($income['mn'],$ysearch);  
				$dect = $this->Staff_payment_model->getEmpListForDeductions($income);
				// echo "kk".count($dect);exit;
				if(count($att_chk)=='0' && count($dect)=='0'){
					$this->session->set_flashdata('message1','Monthly Attendance and Deduction list is not Submitted.');
				}elseif(count($att_chk)=='0'){
					$this->session->set_flashdata('message1','Monthly Attendance is not Submitted');

				}elseif(count($dect)=='0'){
					$this->session->set_flashdata('message1','Monthly Deduction List is not Submitted');
				}else{
				if(count($dect)>0){
					 $this->data['flag'] = '1';
					$emp_list=$this->Staff_payment_model->fetchEmpList();
					//	echo "<pre>"; print_R($emp_list);"</pre>";
					$this->data['emp_sal']=$this->Staff_payment_model->getEmpSalForMonth($income,$att_chk);
					 //echo "<pre>"; print_R($this->data['emp_sal']);"</pre>";
					//exit;  	
					if(!empty($this->data['emp_sal'])){
						$ecnt = count($this->data['emp_sal']);
						for($i=0;$i<$ecnt;$i++){
							$get_emp_presenty=$this->Staff_payment_model->getAttendance($this->data['emp_sal'][$i]['emp_id'],$income['mn'],$income['dt']);
							$this->data['emp_sal'][$i]['pdays']=$get_emp_presenty;		 
							}
						}

					}
				}
			}
		}else{

				$this->data['flag'] = '0';
				$dt1=$ysearch.'-'.$msearch."-01";
				$this->data['dt1']=$dt1;//searched date
				$this->data['month_name']=$msearch;
				$this->data['year_name']=$ysearch;
				$this->data['emp_sal'] = $this->Staff_payment_model->get_monthly_earning_deduction($msearch,$ysearch);
		}
		$dt1=$ysearch.'-'.$msearch."-01";

		$this->data['dt1']= $dt1;//searched date 

		$this->data['month_name']=$msearch;
		$this->data['year_name']=$ysearch;
		$this->load->view($this->view_dir.'staff_salary',$this->data);
		$this->load->view('footer'); 
	
}	
   //add final staff salary to the database
function add_staff_monthly_sal(){
	
	$data=array();
	$data=$_POST;
	//echo count($data['ins']);
	//echo "<pre>";print_r($_POST);echo"</pre>";
	//exit;
	for($i=0;$i<count($data['ins']);$i++){
		$temp[$i]['emp_id']=$data['ins'][$i]['emp_id'];
		//$temp[$i]['ename']=$data['ins'][$i]['ename'];
		$temp[$i]['pdays']=$data['ins'][$i]['pdays'];
		$temp[$i]['basic_sal']=$data['ins'][$i]['basic_sal'];
		$temp1[$i]['basic']=$data['ins'][$i]['basic_sal'];
		if(!empty($data['ins'][$i]['gross'])){ $temp[$i]['gross']=$data['ins'][$i]['gross'];}else{$temp[$i]['gross']=0;}
		if(!empty($data['ins'][$i]['ctc'])){ $temp[$i]['ctc']=$data['ins'][$i]['ctc'];}else{$temp[$i]['ctc']=0;}
		if(!empty($data['ins'][$i]['total_deduct'])){ $temp[$i]['total_deduct']=$data['ins'][$i]['total_deduct'];}else{$temp[$i]['total_deduct']=0;}
		if(!empty($data['ins'][$i]['final_net_sal'])){ $temp[$i]['final_net_sal']=$data['ins'][$i]['final_net_sal'];}else{$temp[$i]['final_net_sal']=0;}

		/*$temp[$i]['gross']=$data['ins'][$i]['gross'];
		$temp[$i]['total_deduct']=$data['ins'][$i]['total_deduct'];
		$temp[$i]['final_net_sal']=$data['ins'][$i]['final_net_sal'];*/
		$temp[$i]['for_month_year']=$data['for_month_year'];
		//$temp[$i]['inserted_by']=$this->session->userdata("uid");
		//$temp[$i]['inserted_date']=date('Y-m-d h:m:i');
		//earning
		$temp1[$i]['emp_id']=$data['ins'][$i]['emp_id'];
		$temp1[$i]['dp']=$data['ins'][$i]['DP'];
		$temp1[$i]['da']=$data['ins'][$i]['DA'];
		$temp1[$i]['hra']=$data['ins'][$i]['HRA'];
		$temp1[$i]['ta']=$data['ins'][$i]['TA'];
		$temp1[$i]['increment']=$data['ins'][$i]['increment'];
		if(!empty($data['ins'][$i]['Incom_Diff'])){ $temp1[$i]['difference']=$data['ins'][$i]['Incom_Diff'];}else{$temp1[$i]['difference']=0;}
		if(!empty($data['ins'][$i]['otherinc'])){ $temp1[$i]['other_allowance']=$data['ins'][$i]['otherinc'];}else{$temp1[$i]['other_allowance']=0;}
		if(!empty($data['ins'][$i]['special_allowance'])){ $temp1[$i]['special_allowance']=$data['ins'][$i]['special_allowance'];}else{$temp1[$i]['special_allowance']=0;}
		if(!empty($data['ins'][$i]['epf'])){ $temp1[$i]['epf']=$data['ins'][$i]['epf'];}else{$temp1[$i]['epf']=0;}

		/*$temp1[$i]['difference']=$data['ins'][$i]['Incom_Diff'];
		$temp1[$i]['other_allowance']=$data['ins'][$i]['otherinc'];
		$temp1[$i]['special_allowance']=$data['ins'][$i]['special_allowance'];*/
		$temp1[$i]['for_month']=$data['for_month_year'];
		//deduction
		$temp2[$i]['emp_id']=$data['ins'][$i]['emp_id'];
		//$temp2[$i]['epf']=$data['ins'][$i]['epf'];
		if(!empty($data['ins'][$i]['epf_er'])){ $temp2[$i]['epf_er']=$data['ins'][$i]['epf_er'];}else{$temp2[$i]['epf_er']=0;}
		if(!empty($data['ins'][$i]['gratuity'])){ $temp2[$i]['gratuity']=$data['ins'][$i]['gratuity'];}else{$temp2[$i]['gratuity']=0;}
		if(!empty($data['ins'][$i]['epf'])){ $temp2[$i]['epf']=$data['ins'][$i]['epf'];}else{$temp2[$i]['epf']=0;}
		if(!empty($data['ins'][$i]['ptax'])){ $temp2[$i]['ptax']=$data['ins'][$i]['ptax'];}else{$temp2[$i]['ptax']=0;}
		if(!empty($data['ins'][$i]['TDS'])){ $temp2[$i]['TDS']=$data['ins'][$i]['TDS'];}else{$temp2[$i]['TDS']=0;}
		if(!empty($data['ins'][$i]['mobile_bill'])){ $temp2[$i]['mobile_bill']=$data['ins'][$i]['mobile_bill'];}else{$temp2[$i]['mobile_bill']=0;}
		if(!empty($data['ins'][$i]['bus_ded'])){ $temp2[$i]['bus_fare']=$data['ins'][$i]['bus_ded'];}else{$temp2[$i]['bus_fare']=0;}
		if(!empty($data['ins'][$i]['Society_Charg'])){ $temp2[$i]['co_op_society']=$data['ins'][$i]['Society_Charg'];}else{$temp2[$i]['co_op_society']=0;}
		if(!empty($data['ins'][$i]['Off_Adv'])){ $temp2[$i]['Off_Adv']=$data['ins'][$i]['Off_Adv'];}else{$temp2[$i]['Off_Adv']=0;}
		if(!empty($data['ins'][$i]['Other_Deduct'])){ $temp2[$i]['other_advance']=$data['ins'][$i]['Other_Deduct'];}else{$temp2[$i]['other_advance']=0;}
		//if(!empty($data['ins'][$i]['bus_fare'])){ $temp2[$i]['bus_fare']=$data['ins'][$i]['bus_fare'];}else{$temp2[$i]['bus_fare']=0;}
		//if(!empty($data['ins'][$i]['bus_fare'])){ $temp2[$i]['bus_fare']=$data['ins'][$i]['bus_fare'];}else{$temp2[$i]['bus_fare']=0;}
		/*$temp2[$i]['TDS']=$data['ins'][$i]['TDS'];
		$temp2[$i]['mobile_bill']=$data['ins'][$i]['mobile_bill'];
		$temp2[$i]['bus_fare']=$data['ins'][$i]['bus_ded'];
		$temp2[$i]['co_op_society']=$data['ins'][$i]['Society_Charg'];
		$temp2[$i]['Off_Adv']=$data['ins'][$i]['Off_Adv'];
		$temp2[$i]['other_advance']=$data['ins'][$i]['Other_Deduct'];*/
		$temp2[$i]['inserted_by']=$this->session->userdata("uid");
		$temp2[$i]['inserted_date']=date('Y-m-d h:m:i');
		$temp2[$i]['for_month']=$data['for_month_year'];

	}
	
	$add_month_sal_ern=$this->Staff_payment_model->addEmp_monthly_sal_earnings($temp1);
	$add_month_sal_ded=$this->Staff_payment_model->addEmp_monthly_sal_deduction($temp2);
	
	$add_month_sal=$this->Staff_payment_model->addEmp_monthly_sal($temp);
	if($add_month_sal==1){
		
		$this->session->set_flashdata('message2','Employee monthly salary added successfully.');
        redirect('staff_payment/staff_salary'); 		
	}else{
		$this->session->set_flashdata('message2','Some problem occured.');
        redirect('staff_payment/staff_salary'); 
	}
	
} 
   
 //***********add staff basic salary details************//
//Staff basic salary List
	public function staff_basic_salary_details_list(){
		if($this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==1 || $this->session->userdata("role_id")==48 ){
			//echo 1;exit;
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);
		$this->data['all_emp_basicsal']=$this->Staff_payment_model->fetchAllEmpBasicSal();
		/* echo"<pre>";print_r($this->data['all_emp_leave']);
		die(); */
		$menu_name='staff_payment/staff_basic_salary_details_list';        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		$this->load->view($this->view_dir.'staff_basic_salary_details_list',$this->data);
	    $this->load->view('footer');
		
	}
	function get_emp_history($eid){
			$emp_data=$this->Staff_payment_model->fetchEmpBasicSalByempid($eid);
	$j=1;
	for($i=0;$i<count($emp_data);$i++)
                            {
       echo '<tr>
			<td>'.$j.'</td>                                  
			<td>'.$emp_data[$i]['basic_sal'].'</td>				                                                    
			 <td>'.$emp_data[$i]['pay_band_min'].'</td>                                
			<td>'.$emp_data[$i]['pay_band_max'].'</td>		                               
			<td>'.$emp_data[$i]['pay_band_gt'].'</td>       
			<td>'.$emp_data[$i]['da'].'</td>                                
			<td>'.$emp_data[$i]['hra'].'</td>       
			<td>'.$emp_data[$i]['ta'].'</td>                                
			    
			<td>'.$emp_data[$i]['difference'].'</td>                                
				                            
			<td>'.$emp_data[$i]['other_allowance'].'</td>       			
			<td>'.$emp_data[$i]['special_allowance'].'</td>   
    	
<td><b>'.$emp_data[$i]['gross_salary'].'</b></td>
<td>'.date('d-m-Y',strtotime($emp_data[$i]['created_on'])).'</td> 					
			          <td>'.$emp_data[$i]['active_status'].'</td>                
										
		</tr>';
	   
                            $j++;
                            }
	}
function staff_basic_salarydetails($sid=''){
	if(($this->session->userdata("role_id")==1) ||($this->session->userdata("role_id")==6)){				
			}else{
				redirect('home');
			}
$this->load->view('header',$this->data); 	
//$menu_name='staff_basic_salarydetails';        
     //   $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
$this->data['school_list']= $this->Admin_model->getAllschool();	 
$this->data['dept_list']= $this->Admin_model->getAllDepartments();		 
$this->data['desig_list']= $this->Admin_model->getAllDesignations(); 
if(isset($sid)){
			 
			 $this->data['emp_basic_sal_info']=$this->Staff_payment_model->getEmpBasic_Sal($sid);
			// print_r($this->data['emp_leave_info']);exit;
		 }
		 if(isset($_POST['inupdate'])){
				 $update=$this->Staff_payment_model->updateStaffBasicSalary($_POST);
			if($update==1){
				$this->session->set_flashdata('message1','Employee Basic Salary updated successsfully');
				redirect('staff_payment/staff_basic_salary_details_list');
			} 
			 }elseif(isset($_POST['basic_submit'])){
	
	 $add=$this->Staff_payment_model->addStaffBasicSalary($_POST);
			if($add==1){
				$this->session->set_flashdata('message1','Employee Basic Salary added successsfully');
				redirect('staff_payment/staff_basic_salary_details_list');
			}	
}
     
$this->load->view($this->view_dir.'staff_basic_salary_details',$this->data);
$this->load->view('footer'); 
}
    
public function getEmpListDepartmentSchoolForBasicSalary(){
		$school=$_REQUEST['school'];
		$department=$_REQUEST['department'];
		$this->data['emp_list']=$this->Staff_payment_model->getEmployeeListForBasicSalary($school,$department);
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
  
	 public function emp_monthly_deduction_add(){
		$this->load->view('header',$this->data);
		 $this->data['emp']=$this->Staff_payment_model->get_employee();
		$this->data['all_emp_basicsal']=$this->Staff_payment_model->fetchAllEmpBasicSal();
		/* echo"<pre>";print_r($this->data['all_emp_leave']);
		die(); */
		$this->load->view($this->view_dir.'emp_monthly_deduction_add',$this->data);
	    $this->load->view('footer');
		
	}
	public function emp_monthly_deduction_add_submit(){
		//print_R($_POST);
		//exit;
		 $ins =$this->Staff_payment_model->add_monthly_deduction_auto($_POST);
		//exit;
		if($ins=='ard'){
			redirect('staff_payment/emp_monthly_deduction_add/?e=1');
		}else{
		redirect('staff_payment/emp_monthly_deduction_list');
		}
	}
	
	public function emp_monthly_deduction_list($mon=''){
			$this->load->view('header',$this->data);
			if(empty($mon)){
				$mon = date('m-Y');
			}else{
				$mon = $mon;
			}
			$this->data['mon']=$mon;
		$this->data['deduction_list']=$this->Staff_payment_model->fetchAllEmpdeductionlist($mon);
		/* echo"<pre>";print_r($this->data['all_emp_leave']);
		die(); */
		$this->load->view($this->view_dir.'emp_monthly_deduction_list',$this->data);
	    $this->load->view('footer');
	}
	public function emp_monthly_deduction_update($did){
		$this->load->view('header',$this->data);
		//echo $did;
		$this->data['emp_deduction_details']=$this->Staff_payment_model->fetchEmpDeductionDetails($did);
		// echo"<pre>";print_r($this->data['emp_deduction_details']);
		//die(); 
		$this->load->view($this->view_dir.'emp_monthly_deduction_update',$this->data);
	    $this->load->view('footer');
	}
	public function emp_monthly_deduction_update_submit(){
		//print_R($_POST);
		//exit;
		$this->data['all_emp_basicsal']=$this->Staff_payment_model->update_monthly_deduction_auto($_POST);
		redirect('staff_payment/emp_monthly_deduction_list');
	}
	public function get_emp_deduction_history($eid,$transof){
		$emp_data=$this->Staff_payment_model->fetchEmpDeductionByempid($eid,$transof);
	$j=1;
	for($i=0;$i<count($emp_data);$i++)
                            {
       echo '<tr>
			<td>'.$j.'</td>                                  
			<td>'.$emp_data[$i]['trans_of'].'</td>				                                                    
			 <td>';
			 if($emp_data[$i]['type']=='I'){
									  echo "Individual";
								  }elseif($emp_data[$i]['type']=='A'){
									  echo 'All';
								  }
			 echo '</td>                                
			<td>';
			if($emp_data[$i]['frequency']=='1'){
								echo "One Time";
							}elseif($emp_data[$i]['frequency']=='2'){
								echo "Monthly";
							}
							
							echo '</td>	
<td>'.$emp_data[$i]['amount'].'</td>				
			<td>';
			if(date('M-Y',strtotime($emp_data[$i]['valid_from'])) == date('M-Y',strtotime($emp_data[$i]['valid_to']))){
				echo date('M-Y',strtotime($emp_data[$i]['valid_from']));
			}else{
				echo date('M-Y',strtotime($emp_data[$i]['valid_from']))." to ".date('M-Y',strtotime($emp_data[$i]['valid_to']));
			} echo '</td>                                
			   
<td>'.$emp_data[$i]['active'].'</td>					
			       					
		</tr>';
	   
                            $j++;
                            }
	}
	
	 public function staff_salary_reports(){
	$this->load->view('header',$this->data); 	 
		//$this->data['school_list']= $this->Admin_model->getAllschool();	 
       // $this->data['dept_list']= $this->Admin_model->getAllDepartments();
		if(isset($_POST)&&!empty($_POST)){
		//$income['school']=$this->input->post('emp_school');
         //   $income['dept']=$this->input->post('department');		
		    $income['dt']=$this->input->post('attend_date');
			$income['staff_type']=$this->input->post('staff_type');
			$d = date_parse_from_format("Y-m-d", $income['dt']);
								//print_r($d);
								$msearch=$d["month"];
							$month_name = date("F", mktime(0, 0, 0, $msearch, 10));
                                $ysearch=$d["year"];
			$dt1=$ysearch.'-'.$msearch."-01";	
			$income['dt']=$ysearch;
            $income['mn']=$msearch;
              //
             $emp_list=$this->Staff_payment_model->fetchEmpList($income['staff_type']);
		//	echo "<pre>"; print_R($emp_list);"</pre>";
			 $this->data['emp_sal']=$this->Staff_payment_model->getEmpSalForMonth_final($income,$emp_list);
			  /* echo "<pre>"; print_R($this->data['emp_sal']);"</pre>";
		  exit;  */		
	          if(!empty($this->data['emp_sal'])){
		  for($i=0;$i<count($this->data['emp_sal']);$i++){
			  $get_emp_presenty=$this->Staff_payment_model->getAttendance($this->data['emp_sal'][$i]['emp_id'],$income['mn'],$income['dt']);
               $this->data['emp_sal'][$i]['pdays']=$get_emp_presenty;		 
		 }
			  }	  	  
		 
		}
		
		$this->data['dt1']=$dt1;//searched date
	     $this->data['month_name']=$month_name;
         $this->data['year_name']=$ysearch;
		$this->load->view($this->view_dir.'staff_salary_reports',$this->data);
        $this->load->view('footer'); 
	
}	
 public function export_excel()
    {
       // $this->load->library('excel');     
		$trep = $this->input->post('treport');
		$income['dt']=$this->input->post('attend_date');
		$income['staff_type']=$this->input->post('staff_type');
		$d = date_parse_from_format("Y-m-d", $income['dt']);
		//print_r($d);
		$msearch=$d["month"];
		$month_name = date("F", mktime(0, 0, 0, $msearch, 10));
		$ysearch=$d["year"];
		$dt1=$ysearch.'-'.$msearch."-01";	
		$income['dt']=$ysearch;
		$income['mn']=$msearch;
		$d_mo = cal_days_in_month(CAL_GREGORIAN,$msearch,$ysearch);
		//  $emp_list=$this->Staff_payment_model->fetchEmpList($income['staff_type']);
		$emp_list=$this->Staff_payment_model->fetchEmpListforSalary_report($msearch,$ysearch,$income['staff_type']);
		//	echo "<pre>"; print_R($emp_list);"</pre>";
		if($trep=='salary_status'){
			$this->data['emp_sal']=$this->Staff_payment_model->get_salary_status_report($income,$emp_list);
		}elseif($trep=='salary_attendance'){
			$this->data['emp_sal']=$this->Staff_payment_model->get_final_monthly_attendance($msearch,$ysearch,$this->input->post('staff_type'));
		// print_r($this->data['emp_sal']);exit;
		}else{
			$this->data['emp_sal']=$this->Staff_payment_model->getEmpSalForMonth_final_report($income,$emp_list,$trep);
		}

		$rtyp = $this->input->post('rtype');

		$this->data['dt']=$this->input->post('attend_date');
		$this->data['trep']=$trep;
//	  exit;
	  
	if($rtyp == 'exl'){
		
		if($trep=='salary_soc'){
		$this->data['title'] =  'Co.Op.SOCIETY DEDUCTION REPORT FOR THE MONTH OF '.date('M Y',strtotime($dt1));
		}elseif($trep=='salary_ptax'){
			$this->data['title'] = 'PTAX DEDUCTION REPORT FOR THE MONTH '.date('M Y',strtotime($dt1));
				}elseif($trep=='salary_busfare'){
			$this->data['title'] = 'BUS FARE DEDUCTION REPORT FOR THE MONTH OF '.date('M Y',strtotime($dt1));
				}elseif($trep=='salary_epf'){
			$this->data['title'] = 'EPF DEDUCTION REPORT FOR THE MONTH OF '.date('M Y',strtotime($dt1));
				}elseif($trep=='salary_status'){
			$this->data['title'] = 'SALARY STATUS REPORT FOR THE MONTH OF '.date('M Y',strtotime($dt1));
				}else{
		$this->data['title'] = 'ATTENDANCE REPORT FOR THE MONTH OF '.date('M Y',strtotime($dt1));
					}
		 if($trep=='salary_soc'){
		 $this->data['filename'] = "SOCIETY REPORT";
		  }elseif($trep=='salary_ptax'){
		  $this->data['filename'] = "PTAX REPORT";
		  }elseif($trep=='salary_busfare'){
		  $this->data['filename'] = "BUSFARE REPORT";
		  }elseif($trep=='salary_tds'){
		  $this->data['filename'] = "TDS REPORT";
		  }elseif($trep=='salary_epf'){
		  $this->data['filename'] ="EPF REPORT";
		  }elseif($trep=='salary_reg'){
$this->data['filename'] ="Salary Register";
		  }elseif($trep=='salary_status'){ 
$this->data['filename'] ="SALARY STATUS REPORT";
		  }else{
		 $this->data['filename'] ="ATTENDANCE REPORT";
		 	  		  }
		
		
		$this->load->view($this->view_dir.'reports/exl',$this->data);
	}else{
     $this->load->library('m_pdf');
		ini_set("memory_limit", "-1");
		  $html1 = $this->load->view($this->view_dir.'reports/'.$trep, $this->data, true);//exit;

        $pdfFilePath = $trep.".pdf";
		
		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		if($trep=='salary_reg'){
//$this->m_pdf->pdf=new mPDF('L','A4-L','','',5,5,5,5,5,5);
$this->m_pdf->pdf=new mPDF('utf-8', array(400,300));
}else{
$this->m_pdf->pdf=new mPDF('','A4','','',5,5,5,5,5,5);	
}		$this->m_pdf->pdf->AddPage();
        $this->m_pdf->pdf->WriteHTML($html1);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");	
	}
	  
		//readfile($filePath);
		//return true;		
    }
	public function salary_status(){
		$this->load->view('header',$this->data); 
if(isset($_POST)&&!empty($_POST)){
	$income['dt']=$this->input->post('attend_date');
			$d = date_parse_from_format("Y-m-d", $income['dt']);
			$msearch=$d["month"];
			$ysearch=$d["year"];
	$this->data['emp_sal']=$this->Staff_payment_model->check_monthly_earning_deduction($msearch,$ysearch);
			
}
$this->load->view($this->view_dir.'salary_status',$this->data);
        $this->load->view('footer'); 
	}
	public function add_salary_status(){
		$this->load->view('header',$this->data);
		if(isset($_POST)&&!empty($_POST)){
		$ins =	$this->Staff_payment_model->update_salary_status($_POST);
		}
		if(isset($ins)){
			redirect('staff_payment/salary_status');
		}
	}
	public function emp_mobile_master_add(){
		$this->load->view('header',$this->data); 
  $this->load->model('Admin_model');
$this->data['school_list']= $this->Admin_model->getAllschool();	       		
        $this->load->view($this->view_dir.'emp_mobile_master_add',$this->data);
        $this->load->view('footer');
	}
	public function employee_mobile_master_add_submit(){
		$ins = $this->Staff_payment_model->insert_mobile_limit($_POST);
	//exit;
		if($ins =='1'){
			redirect('staff_payment/emp_mobile_bill_list');
		}elseif($ins == 'ee'){
$this->session->set_flashdata('message1','Mobile No already assign to this employee.');
			redirect('staff_payment/emp_mobile_master_add');
		}else{
			$this->session->set_flashdata('message1','Mobile No Already assigned.');
			redirect('staff_payment/emp_mobile_master_add');
		}
		
	}
	public function employee_mobile_master_list(){
		$this->load->view('header',$this->data);   
$this->data['mobile_list']= $this->Staff_payment_model->getAllMobileList();	       		
        $this->load->view($this->view_dir.'emp_mobile_master_list',$this->data);
        $this->load->view('footer');
	}
	public function employee_mobile_master_update($id){
				$this->load->view('header',$this->data);   
$this->data['mobile_details']= $this->Staff_payment_model->getAllMobileList($id);	       		
        $this->load->view($this->view_dir.'emp_mobile_master_update',$this->data);
        $this->load->view('footer');
		
	}
	public function employee_mobile_master_update_submit(){
		$upd = $this->Staff_payment_model->update_mobile_limit($_POST);
	//exit;
		if($upd =='1'){
			redirect('staff_payment/emp_mobile_bill_list');
		}else{
			$this->session->set_flashdata('message1','Mobile No Already assigned.');
			redirect('staff_payment/employee_mobile_master_update/'.$_POST['mobile_id']);
		}
	}
	public function employee_mobile_master_delete($id){
		$del = $this->Staff_payment_model->delete_mobile_limit($id);
	//exit;
		if($del =='1'){
			$this->session->set_flashdata('message1','Deleted successfully');
			redirect('staff_payment/emp_mobile_bill_list');
		}else{			
			redirect('staff_payment/emp_mobile_bill_list');
		}
	}
	public function employee_mobile_bill_add(){
				$this->load->view('header',$this->data); 
  $this->load->model('Admin_model');
  $this->data['mobile_list']= $this->Staff_payment_model->getAllMobileList_dect();	      
$this->data['school_list']= $this->Admin_model->getAllschool();	       		
        $this->load->view($this->view_dir.'emp_mobile_bill_add',$this->data);
        $this->load->view('footer');
	}
	
	public function emp_upload_mobile_file(){
	    
		//ini_set('error_reporting', E_ALL);
	//	var_dump(extension_loaded ('zip'));
	//	exit();
		$this->load->view('header',$this->data); 
		   $file = $_FILES['file_up']['tmp_name'];			
			
    	 $this->load->library('excel');
	try {
    $objPHPExcel = PHPExcel_IOFactory::load($file);
	 } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }
    //get only the Cell Collection
            $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
		$data=array();
		//print_r($highestRow);
		$this->load->model('Admin_model');
        for ($row = 2; $row <= $highestRow; $row++) {                           // Read a row of data into an array                 
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            	//print_r($rowData);
        $mlimt =  $this->Staff_payment_model->get_mobile_limit_amount($rowData[0][1]);
		$emp = $this->Admin_model->getEmployeeById($rowData[0][0]);
		//$department =  $this->admin_model->getDepartmentById($emp[0]['department']); 
			//					 $school =  $this->admin_model->getSchoolById($emp[0]['emp_school']); 
		//echo $rowData[0][2];
            $det = $rowData[0][2] - $mlimt;
			if($det < 0){
				$det = 0;
			}else{
				$det = $det;
			}
			if(!empty($mlimt)){
			$data[] = array(                                                      // Sesuaikan sama nama kolom tabel di database
                "emp_id" => $rowData[0][0],
                "mobile" => $rowData[0][1],
                "amt" => $rowData[0][2],
				"mobile_limit"=>$mlimt,
				"det"=>$det,
				"department"=>$emp[0]['department'],
				"emp_school"=>$emp[0]['emp_school'],
            );
            }      
        }

		//print_r($data); exit;
		$this->data['mobile_list'] = $data;
		$this->data['mon'] = $_POST['month1'];
	 $this->load->view($this->view_dir.'emp_mobile_bill_add',$this->data);
        $this->load->view('footer');
	
	
	}
	
	function add_mobile_bill_list(){
		$this->load->view('header',$this->data); 
		$file = $_FILES['file_up']['tmp_name'];
		if(!empty($file)){
			$this->load->library('excel');
    //read file from path
	 
	try {
    $objPHPExcel = PHPExcel_IOFactory::load($file);
	 } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }
    //get only the Cell Collection
            $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
		$data=array();
		$this->load->model('Admin_model');
        for ($row = 2; $row <= $highestRow; $row++) {                           // Read a row of data into an array                 
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            	//print_r($rowData);
        $mlimt =  $this->Staff_payment_model->get_mobile_limit_amount($rowData[0][1]);
		$emp = $this->Admin_model->getEmployeeById($rowData[0][0]);
		//$department =  $this->admin_model->getDepartmentById($emp[0]['department']); 
			//					 $school =  $this->admin_model->getSchoolById($emp[0]['emp_school']); 
		
            $det = $rowData[0][2] - $mlimt;
			if($det < 0){
				$det = 0;
			}else{
				$det = $det;
			}
			if(!empty($mlimt)){
			$data[] = array(                                                      // Sesuaikan sama nama kolom tabel di database
                "emp_id" => $rowData[0][0],
                "mobile" => $rowData[0][1],
                "amt" => $rowData[0][2],
				"mobile_limit"=>$mlimt,
				"det"=>$det,
				"department"=>$emp[0]['department'],
				"emp_school"=>$emp[0]['emp_school'],
            );
            }
		}
       $this->data['mobile_list'] = $data;
		$this->data['mon'] = $_POST['month1'];
	 $this->load->view($this->view_dir.'emp_mobile_bill_add',$this->data);
        $this->load->view('footer');			
			
		}else{
		$bill = $this->Staff_payment_model->add_mobile_bill($_POST);
		if(isset($bill)){
			redirect('staff_payment/emp_mobile_bill_list/'.$_POST['month1']);
		}
	}
	}
	function emp_mobile_bill_list($mon=''){
		//ini_set('error_reporting', E_ALL);
		$this->load->view('header',$this->data); 
if(empty($mon)){
$mon = date('Y-m');
}else{
$mon = $mon;
}
$this->data['mon']= $mon;	
$ex = explode('-',$mon);
		$fa = $this->Staff_payment_model->check_monthly_earning_deduction($ex[1],$ex[0]);
		$cnt = count($fa);
		if($cnt == '0'){
$this->data['upflag'] = 1;
		}
$this->data['mobile_list']= $this->Staff_payment_model->getAllMobileList();	 
$this->data['mobile_bill']= $this->Staff_payment_model->getAllMobileBill($mon);	 
$menu_name='staff_payment/emp_mobile_bill_list';  
$this->data['my_privileges']=$this->retrieve_privileges($menu_name);    		
        $this->load->view($this->view_dir.'emp_mobile_bill_list',$this->data);
        $this->load->view('footer');
	}
	function export_excel_mobile_bill(){
		$this->data['mobile_bill']= $this->Staff_payment_model->getAllMobileBill($_POST['rmon']);		
		$this->load->view($this->view_dir.'reports/emp_mobile_bill_list_export',$this->data);
	}
	public function update_mob_bill_list(){
		//print_r($_POST);exit;
		$up = $this->Staff_payment_model->update_mob_bill_update($_POST);
		redirect("staff_payment/emp_mobile_bill_list/".$_POST['smon']);
	}
	public function emp_bus_fare_add(){
		$this->load->view('header',$this->data); 
  $this->load->model('Admin_model');
$this->data['school_list']= $this->Admin_model->getAllschool();	       		
        $this->load->view($this->view_dir.'emp_bus_fare_add',$this->data);
        $this->load->view('footer');
	}
	public function emp_bus_fare_add_submit(){
		$ins = $this->Staff_payment_model->add_bus_fare($_POST);
		if(isset($ins)){
			if($ins=='ex'){
				$this->session->set_flashdata('message1','Record Already exits.');
			redirect('staff_payment/emp_bus_fare_add');
			}else{
			redirect('Staff_payment/emp_bus_fare_list');
		}
		}
	}
	public function emp_bus_fare_list(){
		$this->load->view('header',$this->data); 
		$this->data['busfare_list']= $this->Staff_payment_model->getBusFareList(); 
		 $this->load->view($this->view_dir.'emp_bus_fare_list',$this->data);
        
        $this->load->view('footer');
	}
	public function export_excel_busfare(){
		$this->data['busfare_list']= $this->Staff_payment_model->getBusFareList();		
		$this->load->view($this->view_dir.'reports/emp_busfare_list_export',$this->data);
	}
	public function emp_bus_fare_update($id){
		$this->load->view('header',$this->data);
		$this->data['busfare_details'] = $this->Staff_payment_model->getBusfareByID($id);
		$this->load->view($this->view_dir.'emp_bus_fare_update',$this->data);
		$this->load->view('footer');
	}
	public function emp_bus_fare_update_submit(){
		$up = $this->Staff_payment_model->updatebusfare($_POST);		
			redirect('Staff_payment/emp_bus_fare_list');		
	}
	public function emp_busfare_delete($id){
		$del = $this->Staff_payment_model->delete_busfare($id);
	//exit;
		if($del =='1'){
			$this->session->set_flashdata('message1','Deleted successfully');
			redirect('staff_payment/emp_bus_fare_list');
		}else{			
			redirect('staff_payment/emp_bus_fare_list');
		}
	}
	public function emp_society_add(){
		$this->load->view('header',$this->data); 
  $this->load->model('Admin_model');
$this->data['school_list']= $this->Admin_model->getAllschool();	
   $this->load->model('leave_model');
     	$this->data['emp_list']=	$this->leave_model->get_employee_code($txt='');
        $this->load->view($this->view_dir.'emp_society_add',$this->data);
        $this->load->view('footer');
	}
	public function emp_society_add_submit(){
		$ins = $this->Staff_payment_model->add_society($_POST);
		if($ins!= 1){
			if($ins=='e'){
				$this->session->set_flashdata('message1','Record Already exits.');
		}else{
			$this->session->set_flashdata('message1','Already exits for this month.');
		}
		redirect('Staff_payment/emp_society_add');

	}else{
			redirect('Staff_payment/emp_society_list');
		}
	}
	public function emp_society_list(){
		$this->load->view('header',$this->data); 
		$this->data['society_list']= $this->Staff_payment_model->getSocietyList(); 
		$this->data['society_loan_list']= $this->Staff_payment_model->getSocietyLoanList(); 
		$menu_name='staff_payment/emp_society_list';        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		 $this->load->view($this->view_dir.'emp_society_list',$this->data);
        $this->load->view('footer');
	}
	public function emp_society_update($id){
		$this->load->view('header',$this->data);
		$this->data['society_details'] = $this->Staff_payment_model->getSocietyByID($id);
		$this->load->view($this->view_dir.'emp_society_update',$this->data);
		 $this->load->view('footer');
	}
	public function emp_society_update_submit(){
		$up = $this->Staff_payment_model->updatesoiety($_POST);		
			redirect('Staff_payment/emp_society_list');		
	}
	public function emp_society_delete($id){
		$del = $this->Staff_payment_model->delete_society($id);
	//exit;
		if($del =='1'){
			$this->session->set_flashdata('message1','Deleted successfully');
			redirect('staff_payment/emp_society_list');
		}else{			
			redirect('staff_payment/emp_society_list');
		}
	}
	public function export_excel_society(){
		$this->data['busfare_list']= $this->Staff_payment_model->getSocietyList(); 	
$this->data['soc_f'] = 1;		
		$this->load->view($this->view_dir.'reports/emp_busfare_list_export',$this->data);
	}
	public function emp_society_loan_add(){
		$this->load->view('header',$this->data); 
  $this->load->model('Admin_model');
$this->data['school_list']= $this->Admin_model->getAllschool();	       		
        $this->load->view($this->view_dir.'emp_society_loan_add',$this->data);
        $this->load->view('footer');
	}
	public function emp_society_loan_add_submit(){
		$ins = $this->Staff_payment_model->add_society_loan($_POST);
		if($ins !=='ext'){
			redirect('Staff_payment/emp_society_list');
		}else{
			$this->session->set_flashdata('message1','Exits on this date.');
			redirect('staff_payment/emp_society_loan_add');
		}
	}
	public function emp_society_loan_list(){
		$this->load->view('header',$this->data); 
		$this->data['society_loan_list']= $this->Staff_payment_model->getSocietyLoanList(); 
		 $this->load->view($this->view_dir.'emp_society_loan_list',$this->data);
        $this->load->view('footer');
	}
	public function emp_society_loan_update($id){
		$this->load->view('header',$this->data);
		$this->data['society_loan_details'] = $this->Staff_payment_model->getSocietyLoanByID($id);
		$this->load->view($this->view_dir.'emp_society_loan_update',$this->data);
		 $this->load->view('footer');
	}
	public function emp_society_loan_update_submit(){
		$up = $this->Staff_payment_model->updatesoietyloan($_POST);		
			redirect('Staff_payment/emp_society_list');		
	}
	public function emp_society_loan_delete($id){
		$del = $this->Staff_payment_model->delete_society_loan($id);
	//exit;
		if($del =='1'){
			$this->session->set_flashdata('message1','Deleted successfully');
			redirect('staff_payment/emp_society_list');
		}else{			
			redirect('staff_payment/emp_society_list');
		}
	}
	public function export_excel_society_loan(){
		$this->data['busfare_list']= $this->Staff_payment_model->getSocietyLoanList(); 	
$this->data['soc_f'] = 2;		
		$this->load->view($this->view_dir.'reports/emp_busfare_list_export',$this->data);
	}
	public function emp_tds_bill_add(){
		$this->load->view('header',$this->data);  
  $this->data['emp_list']= $this->Staff_payment_model->get_employee();      		
        $this->load->view($this->view_dir.'emp_tds_bill_add',$this->data);
        $this->load->view('footer');
	}
	public function upload_csv_file(){
			$this->load->view('header',$this->data);
			
				 $filename=$_FILES["fupl"]["tmp_name"];		
      $file = fopen($filename, "r");
	//$rr=  fgetcsv($file, 10000, ",") ; 
//print_r($rr);
	//exit;
	 while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
	 	$num = count($column);
	 	if($num == '2'){
		 if(is_numeric($column[1]) && is_numeric($column[0])){
		 $arr[$column[0]][] = $column[1];
		 }
		}else{
			$this->session->set_flashdata('umessage','Uploaded File columns are mismatch, Only employee ID and TDS Deduction are required.');
		}
	 }
	 $this->data['upd_emp_list'] = $arr;
	  $this->data['emp_list']= $this->Staff_payment_model->get_employee();      		
        $this->load->view($this->view_dir.'emp_tds_bill_add',$this->data);
        $this->load->view('footer');
	}
	public function download_csv_format(){
		$filename = "TDS_Deduction.csv";
		$f = fopen('php://memory', 'w');
    $delimiter = ",";
    //set column headers
    $fields = array('Emp ID','Amount');
    fputcsv($f, $fields, $delimiter);
    fseek($f, 0);
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    
    fpassthru($f);
	}
	public function download_csv_format_arrears(){
		$filename = "Arrears.csv";
		$f = fopen('php://memory', 'w');
    $delimiter = ",";
    //set column headers
    $fields = array('Emp ID','Amount');
    fputcsv($f, $fields, $delimiter);
    fseek($f, 0);
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    
    fpassthru($f);
	}
	public function emp_add_tds_bill(){
		//exit;
		$ins = $this->Staff_payment_model->add_tds_bill($_POST);
		//if(isset($ins)){
			redirect('staff_payment/emp_tds_bill_list/'.$_POST['month']);
		//}
	}
	public function emp_tds_bill_list($mon=""){		
		$this->load->view('header',$this->data);
		if(empty($mon)){
$mon = date('Y-m');
}else{
$mon = $mon;
}
$this->data['mon']= $mon;	
$ex = explode('-',$mon);
		$fa = $this->Staff_payment_model->check_monthly_earning_deduction($ex[1],$ex[0]);
		$cnt = count($fa);
		if($cnt == '0'){
$this->data['upflag'] = 1;
		}
		$this->data['tds_list']= $this->Staff_payment_model->getTdsList($mon); 
		$menu_name='staff_payment/emp_tds_bill_list';
		$this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		 $this->load->view($this->view_dir.'emp_tds_bill_list',$this->data);
        $this->load->view('footer');
	}
	public function emp_tds_bill_update($id){
		$this->load->view('header',$this->data);  
  $this->data['emp_tds']= $this->Staff_payment_model->getTdsId($id);      		
        $this->load->view($this->view_dir.'emp_tds_bill_update',$this->data);
        $this->load->view('footer');
	}
	public function update_tds_list(){
		$ups = $this->Staff_payment_model->updateTdsList($_POST);
		redirect('Staff_payment/emp_tds_bill_list/'.$_POST['cmon']);	
	}
	public function employee_tds_bill_update_submit(){
		$up = $this->Staff_payment_model->updateTds($_POST);		
			redirect('Staff_payment/emp_tds_bill_list/'.$_POST['tds_mon']);	
	}
	public function export_excel_tds_list(){
		//ini_set('error_reporting', E_ALL);
		$mon = $_POST['rmon'];
		if(empty($mon)){
$mon = date('Y-m');
}else{
$mon = $mon;
}
$this->data['mon']= $mon;	
		$this->data['tds_list']= $this->Staff_payment_model->getTdsList($mon); 		
		$this->load->view($this->view_dir.'reports/emp_tds_list_export',$this->data);
	}

	public function emp_salary_release_status(){
		$this->load->view('header',$this->data);  
		 if(isset($_POST)&&!empty($_POST)){
			 $mon = $_POST['attend_date'];
			$this->data['tds_list']= $this->Staff_payment_model->get_salary_sheet($mon);
		 $this->data['mon']= date('F Y',strtotime($mon));
		 }
		  $this->load->view($this->view_dir.'emp_salary_release_status',$this->data);
        $this->load->view('footer');
	}
	public function add_staff_salary_release(){
		$this->Staff_payment_model->insert_staff_relese_status($_POST);
		redirect('staff_payment/emp_salary_release_status');		
	}

	public function staff_master_export(){
		$this->load->library('excel');  
		$all_emp_basicsal=$this->Staff_payment_model->fetchAllEmpBasicSal();
        header('Content-Type: application/vnd.ms-excel');
	  header('Cache-Control: max-age=0');
	  header('Content-Disposition: attachment;filename="salary_master.xls"');
	  $styleArray = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      )
  );
$styleArray1 = array(
    'font'  => array(
        'bold'  => true,       
        'size'  => 8,
        'name'  => 'Arial'
    ),
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));
		
		$styleArray2 = array(
    'font'  => array(
        'size'  => 8,
        'name'  => 'Times New Roman'
    ),
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));
	  $object = new PHPExcel();
	         $object->setActiveSheetIndex(0);
				   $object->getActiveSheet()->mergeCells('B2:S2');
        $object->getActiveSheet()->getStyle('B2:S2')->getFont()->setBold(true);
        $object->getActiveSheet()->getStyle('B2:S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('B2', 'SANDIP UNIVERSITY');
      $object->getActiveSheet()->mergeCells('B3:S3');        
        $object->getActiveSheet()->getStyle('B3:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('B3', 'TRIMBAK ROAD,MAHIRAVANI,NASHIK-422213');
      $object->getActiveSheet()->mergeCells('B6:S6');  
        $object->getActiveSheet()->getStyle('B6:S6')->getFont()->setBold(true);      
        $object->getActiveSheet()->getStyle('B6:S6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('B6', 'Salary Structure Details ');

 $object->getActiveSheet()->setCellValue('A8', 'Sr.no');
		 $object->getActiveSheet()->getStyle('A8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('B8', 'Emp ID');
	  $object->getActiveSheet()->getStyle('B8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	   $object->getActiveSheet()->setCellValue('C8', 'Name');
	  $object->getActiveSheet()->getStyle('C8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	 	   $object->getActiveSheet()->setCellValue('D8', 'School');
	  $object->getActiveSheet()->getStyle('D8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	   $object->getActiveSheet()->setCellValue('E8', 'Department');
	  $object->getActiveSheet()->getStyle('E8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('F8', 'Designation');
	  $object->getActiveSheet()->getStyle('F8')->applyFromArray($styleArray)->applyFromArray($styleArray1);

$object->getActiveSheet()->setCellValue('G8', 'Bank Account NO');
	  $object->getActiveSheet()->getStyle('G8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('H8', 'PAN No');
	  $object->getActiveSheet()->getStyle('H8')->applyFromArray($styleArray)->applyFromArray($styleArray1);

      $object->getActiveSheet()->setCellValue('I8', 'Staff Type');
	  $object->getActiveSheet()->getStyle('I8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('J8', 'Joining Date');
	  $object->getActiveSheet()->getStyle('J8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('K8', 'Scale Type');
	  $object->getActiveSheet()->getStyle('K8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('L8', 'Pay Band');
	  $object->getActiveSheet()->getStyle('L8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('M8', 'Basic Salary');
	  $object->getActiveSheet()->getStyle('M8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('N8', 'DA');
	  $object->getActiveSheet()->getStyle('N8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('O8', 'HRA');
	  $object->getActiveSheet()->getStyle('O8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('P8', 'TA');
	  $object->getActiveSheet()->getStyle('P8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('Q8', 'Other Allowance');
	  $object->getActiveSheet()->getStyle('Q8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('R8', 'Special Allowance');
	  $object->getActiveSheet()->getStyle('R8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  
	  $object->getActiveSheet()->setCellValue('S8', 'Gross Salary');
	  $object->getActiveSheet()->getStyle('S8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $i=1;
	  $j=9;
	  $this->load->model('Admin_model');
	  foreach($all_emp_basicsal as $val){
		$da= round(($val['da']/100)*$val['basic_sal']);
$hra= round(($val['hra']/100)*$val['basic_sal']);
		  $styp = $this->Admin_model->getAllEmpCategoryById($val['staff_type']);
		   $object->getActiveSheet()->setCellValue('A'.$j, $i);
$object->getActiveSheet()->getStyle('A'.$j.':Q'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
$object->getActiveSheet()->setCellValue('B'.$j, $val['emp_id']);

$object->getActiveSheet()->setCellValue('C'.$j, $val['fname']." ".$val['mname']." ".$val['lname']);
//$object->getActiveSheet()->setCellValue('E'.$j, $val['gender']);
$object->getActiveSheet()->setCellValue('D'.$j, $val['college_code']);
$object->getActiveSheet()->setCellValue('E'.$j, $val['department_name']);
$object->getActiveSheet()->setCellValue('F'.$j, $val['designation_name']);

$object->getActiveSheet()->setCellValue('G'.$j, $val['bank_acc_no']);
$object->getActiveSheet()->setCellValue('H'.$j, $val['pan_no']);

$object->getActiveSheet()->setCellValue('I'.$j, $styp[0]['emp_cat_name']);
$object->getActiveSheet()->setCellValue('J'.$j, date('d-m-Y',strtotime($val['joiningDate'])));
$object->getActiveSheet()->setCellValue('K'.$j, $val['scaletype']);
if(!empty($val['pay_band_min'])&&!empty($val['pay_band_max'])&&!empty($val['pay_band_gt'])){
$object->getActiveSheet()->setCellValue('L'.$j, $val['pay_band_min']."-".$val['pay_band_max']."+AGP ".$val['pay_band_gt']);
}else{
$object->getActiveSheet()->setCellValue('L'.$j, "NA" );
}
$object->getActiveSheet()->setCellValue('M'.$j, $val['basic_sal']);

if($val['scaletype']=='scale'){
$object->getActiveSheet()->setCellValue('N'.$j, $da."(".$val['da']."%)");
}else{
$object->getActiveSheet()->setCellValue('N'.$j, "NA");
}
if($val['scaletype']=='scale'){
$object->getActiveSheet()->setCellValue('O'.$j, $hra."(".$val['hra']."%)");
}else{
$object->getActiveSheet()->setCellValue('O'.$j, "NA");	
}
$object->getActiveSheet()->setCellValue('P'.$j, $val['ta']);
$object->getActiveSheet()->setCellValue('Q'.$j, $val['other_allowance']);
$object->getActiveSheet()->setCellValue('R'.$j, $val['special_allowance']);
$object->getActiveSheet()->setCellValue('S'.$j, $val['gross_salary']);

$i++;
$j++;
}


       $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		$objWriter->setPreCalculateFormulas(true);      
		
		
			echo $objWriter->save('php://output');
        
	}
	public function salary_attendance(){
		$this->load->view('header',$this->data); 
		
//print_r($_POST['submit']);exit;
		 if(isset($_POST['submit'])){
$mon = $_POST['attend_date'];
		$emon = explode("-",$mon);
		$d = date_parse_from_format("Y-m-d", $mon);
			$this->data['monthName']= date('F',strtotime("1-".$d["month"]."-".$d["year"]));
			$this->data['ysearch'] =$d["year"];
		$this->data['emp_att'] = $this->Staff_payment_model->check_final_monthly_attendance($emon[1],$emon[0]);
	

		 }
		 $this->load->view($this->view_dir.'salary_attendance',$this->data);
        $this->load->view('footer');
	}
	public function get_total_monthly_attendance(){
		$this->load->view('header',$this->data); 
			$this->load->view($this->view_dir.'salary_attendance',$this->data);
        $this->load->view('footer');
	}
	public function export_mobile_list(){
		$this->data['emp_sal']= $this->Staff_payment_model->getAllMobileList();	    
		$this->data['title'] = 'Mobile List';
		
		 $this->data['filename'] = "MOBILE LIST";
		$this->data['trep'] = "mobile_list";
		$this->load->view($this->view_dir.'reports/exl',$this->data);
	}
	public function upload_csv_file_mob_bill(){
			$this->load->view('header',$this->data);
			
				$filename=$_FILES["fupl"]["tmp_name"];		
      $file = fopen($filename, "r");
	  
	 while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
	 	$num = count($column);
	 	//print_r($num);die;
	 	if($num == '18'){
	 		/*print_r($column[0]);
	 		print_r($column[1]);
	 		print_r($column[2]);
	 		die;*/
		 //if(is_numeric($column[2]) && is_numeric($column[2])){
		 $arr[$column[2]][] = $column[1];
		 $arr[$column[2]][] = $column[2];
		 $arr[$column[2]][] = $column[3];
		 $arr[$column[2]][] = $column[4];
		 $arr[$column[2]][] = $column[5];
		 $arr[$column[2]][] = $column[6];
		 $arr[$column[2]][] = $column[7];
		 $arr[$column[2]][] = $column[8];
		 $arr[$column[2]][] = $column[9];
		 $arr[$column[2]][] = $column[10];
		 $arr[$column[2]][] = $column[11];
		 $arr[$column[2]][] = $column[12];
		 $arr[$column[2]][] = $column[13];
		 $arr[$column[2]][] = $column[14];
		 $arr[$column[2]][] = $column[15];
		 $arr[$column[2]][] = $column[16];
		 $arr[$column[2]][] = $column[17];
		// }
		 }else{
			$this->session->set_flashdata('umessage','Uploaded File columns are mismatch, Only employee ID and TDS Deduction are required.');
		}
	 }
	 //echo "<pre>";print_r($arr);exit;
	 $this->data['upd_mob_list'] = $arr;
	  $this->data['mobile_list']= $this->Staff_payment_model->getAllMobileList_dect();	      		
        $this->load->view($this->view_dir.'emp_mobile_bill_add',$this->data);
        $this->load->view('footer');
	}
	public function download_csv_format_mobile(){
		$filename = "mobile_bill.csv";
		$f = fopen('php://memory', 'w');
    $delimiter = ",";
    //set column headers
    $fields = array('Sr No',
					'EMP ID',
					'MOBILE NO',
    	            'Monthly Charges',
    	            'Local',
    	            'STD',
    	            'ISD',
    	            'GPRS',
					'Download',
    	            'SMS',
					'Conference Call Charges',
    	            'Roming Charges',
    	            'Discount',
    	            'Previous Balance',
					'Grand Total',
					'SGST',
					'CGST',
    	            'Current Charges',
    	           );
    fputcsv($f, $fields, $delimiter);
    fseek($f, 0);    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');    
    fpassthru($f);
	}
	public function check_monthly_mobbill($mon){
		$ex = explode('-',$mon);
			$fa = $this->Staff_payment_model->check_monthly_earning_deduction($ex[1],$ex[0]);
		 $cfa = count($fa);
		if($cfa == '0'){
		$ml = $this->Staff_payment_model->getAllMobileBill($mon);
		if(count($ml)>0){
			echo "Mobile Bill for ".date('M Y',strtotime($mon.'-01'))." are already submitted.";
		}
		}else{
		echo "false";
	}
	}
	public function check_monthly_tdsbill($mon){
		$ex = explode('-',$mon);
		$fa = $this->Staff_payment_model->check_monthly_earning_deduction($ex[1],$ex[0]);
		 $cfa = count($fa);
		if($cfa == '0'){
		$ml = $this->Staff_payment_model->getTdsList($mon);
		if(count($ml)>0){
			echo "TDS Bill for ".date('M Y',strtotime($mon.'-01'))." are already submitted.";
		}
	
	}else{
		echo "false";
	}
	}
	public function save_final_staff_deductions(){
	$up = $this->Staff_payment_model->update_final_status_staff_deduction($_POST);
	redirect('staff_payment/staff_deductions');
}

public function employee_epf_add(){
	$this->load->view('header',$this->data);  
		
			$this->data['emp_list']= $this->Staff_payment_model->get_employee_epf();
		
		  $this->load->view($this->view_dir.'emp_epf_add',$this->data);
        $this->load->view('footer');
}
public function add_emp_epf(){
	//print_r($_POST);
	$up = $this->Staff_payment_model->update_epf_emp($_POST);
	redirect('staff_payment/employee_epf_add');
}

public function update_status($id=''){
$response=0;
if(!empty($id))	{
$dt=$this->db->query("select * from employee_salary_structure where sal_structure_id=$id")->row();

if(!empty($dt)){
	$status=$dt->active_status;
	if($status=="Y"){
		$status="N";
	}
	else{
		$status="Y";
	}
	$dtu=array("active_status"=>$status);
	$this->db->where('sal_structure_id', $id);
    $this->db->update('employee_salary_structure', $dtu);
	
	 $response=$this->db->affected_rows();

}
}
echo $response;

}
/////////////////////////////////////////////
public function employee_att_mannual_add(){
				$this->load->view('header',$this->data); 
  $this->load->model('Admin_model');
  $this->data['mobile_list']= $this->Staff_payment_model->getAllMobileList_dect();	      
$this->data['school_list']= $this->Admin_model->getAllschool();	       		
        $this->load->view($this->view_dir.'emp_att_upload_add',$this->data);
        $this->load->view('footer');
	}
public function upload_csv_file_mannualatt(){
			$this->load->view('header',$this->data);
			
				$filename=$_FILES["fupl"]["tmp_name"];		
      $file = fopen($filename, "r");
		$flag = true;
	  $i=0;
	 while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
		 if($flag) {
			$flag = false;continue;  
		 }
	 	$num = count($column);
	 	//print_r($num);//die;
	 	if($num == '4'){
	 		/*print_r($column[0]);
	 		print_r($column[1]);
	 		print_r($column[2]);
	 		die;*/
		 //if(is_numeric($column[2]) && is_numeric($column[2])){
		 $arr[$i][] = $column[1];
		 $arr[$i][] = $column[2];
		 $arr[$i][] = $column[3];
		// }
		 }else{
			$this->session->set_flashdata('umessage','Uploaded File columns are mismatch, Only employee ID and Names are required.');
		}
		$i++;
		 
	 }
	// echo "<pre>";print_r($arr);exit;
	 $this->data['upd_mob_list'] = $arr;
	  $this->data['mobile_list']= $this->Staff_payment_model->getAllMobileList_dect();	      		
        $this->load->view($this->view_dir.'emp_att_upload_add',$this->data);
        $this->load->view('footer');
	}	
function add_mannual_atta_data(){
		$this->load->view('header',$this->data); 
		
		//echo '<pre>';print_r($_POST);exit;
		$m_id = $_POST['month'];
		foreach ($_POST['emp_id'] as $spk) {
			$spk_details['emp_id'][] = $spk;
		}
		foreach ($_POST['staff_name'] as $spk1) {
			$spk_details['staff_name'][] = $spk1;
		}
		foreach ($_POST['present_days'] as $spk2) {
			$spk_details['present_days'][] = $spk2;
		}
		$speakerupdate = $this->Staff_payment_model->updateattendacneDetails($spk_details, $m_id);
		$this->data['mobile_list'] = $data;
		$this->data['mon'] = $_POST['month1'];
		$this->load->view($this->view_dir.'emp_att_upload_add',$this->data);
        $this->load->view('footer');			
	}
	public function download_csv_format_emp_attendance(){
		$filename = "format_emp_attendance.csv";
		$f = fopen('php://memory', 'w');
    $delimiter = ",";
    //set column headers
    $fields = array('Sr No',
					'EMP ID',
					'EMP Name',
    	            'Present days',
    	            
   	           );
    fputcsv($f, $fields, $delimiter);
    fseek($f, 0);    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');    
    fpassthru($f);
	}
	public function salary_slip()
    {	 

		$this->load->view('header'); 
		$this->load->view($this->view_dir.'vew_salary_sleep',$this->data);
        $this->load->view('footer'); 
	}
	public function download_salary_slip()
    {
       // $this->load->library('excel');     
		#$trep = $this->input->post('treport');
		$prev_month = date('Y-m', strtotime('-1 month')); 
		$curr_month = date('Y-m');
		$curr_date = date('Y-m-d'); // Full current date (e.g., 2025-03-04)
		$salary_date = $curr_month . '-10'; // Salary date (10th of the current month)

		$income['dt'] = $this->input->post('attend_date'); // Expected format: "Y-m"
		$salary_month = date('Y-m', strtotime($income['dt'] . '-01'));
		if ($salary_month == $prev_month) {
			// If it's the current month, check if today is on or after the 10th
			if ($curr_date >= $salary_date) {
				//echo 1; exit;// Salary can be generated 
			} else {
				echo 'Salary Not generated';exit; // Before the 10th, salary not generated
			}
		} else {
			//echo 11;exit; // If it's not the current month, condition is always true
		}

		#$income['staff_type']=$this->input->post('staff_type');
		$d = date_parse_from_format("Y-m-d", $income['dt']);
		//print_r($d);
		$msearch=$d["month"];
		$month_name = date("F", mktime(0, 0, 0, $msearch, 10));
		$ysearch=$d["year"];
		$dt1=$ysearch.'-'.$msearch."-01";	
		$income['dt']=$ysearch;
		$income['mn']=$msearch;
		$d_mo = cal_days_in_month(CAL_GREGORIAN,$msearch,$ysearch);
		//  $emp_list=$this->Staff_payment_model->fetchEmpList($income['staff_type']);
		// $emp_list=$this->session->userdata('name');
		$emp_id=$this->session->userdata('name');
		//	echo "<pre>"; print_R($emp_list);"</pre>";

		$this->data['emp_sal']=$this->Staff_payment_model->getEmpSalForMonth_final_indu($income,$emp_id);
		if(!empty($this->data['emp_sal'])){
		$this->data['dt']=$this->input->post('attend_date');
		$this->load->library('m_pdf');
		
		$html1 = $this->load->view($this->view_dir.'reports/salary_slip', $this->data, true);

		$pdfFilePath = $emp_id."salary_slip.pdf";

		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		$this->m_pdf->pdf=new mPDF('','A4','','',5,5,15,15,5,5);	
		$this->m_pdf->pdf->WriteHTML($html1);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");	
		}else{
			echo "Salary Slip Not generated.";
		}
    }
	
	public function staff_basic_salary_increment33($emp_id='')
  {
	 $this->load->view('header',$this->data); 
	 $this->data['emp_id']=$emp_id;
	 $this->data['emp_list']=$this->Staff_payment_model->get_active_emp();
	 $this->load->view($this->view_dir.'staff_basic_salary_increment',$this->data);
     $this->load->view('footer');   
  } 
  
  	public function staff_basic_salary_increment($emp_id='',$upd='')
  {
	 $this->load->view('header',$this->data); 
	 $this->data['emp_id']=$emp_id;
	 if($upd=='Y')
	 {
	  $this->data['upd']=$upd; 
	  $this->data['incre_det']=$this->Staff_payment_model->get_emp_increment_det($emp_id);
	 }	
	 $this->data['emp_list']=$this->Staff_payment_model->get_active_emp();
	 $this->load->view($this->view_dir.'staff_basic_salary_increment',$this->data);
     $this->load->view('footer');   
  }
   public function update_increment()
  {
	  if(!empty($_POST))
     {
	  $incre=$this->Staff_payment_model->update_staff_salary_increment_det($_POST);
	    if($incre > 0){
			     $_SESSION['status']="Increment Updated Successfully.";
			}
			else
			{
				  $_SESSION['status']="SomeThing Went Wrong.";
			}
	  redirect("staff_payment/staff_basic_salary_increment".'/'.$_POST['eid'].'/'.'Y');
     }
     	 
  }

  public function save_increment()
  {
	  if(!empty($_POST))
     {
	  $incre=$this->Staff_payment_model->insert_staff_salary_increment_det($_POST);
	    if($incre > 0){
			    $_SESSION['status']="Increment Added Successfully.";
			}
			else
			{
				  $_SESSION['status']="SomeThing Went Wrong.";
			}
	  redirect("staff_payment/staff_basic_salary_increment");
     }
     	 
  }
  
  
  public function emp_last_date(){
        $this->load->view('header',$this->data); 
        $this->data['emp_list']= $this->Admin_model->getEmployees1('Y');
        $this->data['emp_det']= $this->Staff_payment_model->getEmployeeslastdate();
        $this->load->view($this->view_dir.'employee_last_date',$this->data);
        $this->load->view('footer');    
    }
	
	public function save_emp_last_date()
	{
	
		$emp=$_POST['empsid'];
		$ldate=$_POST['last_date'];
		$val='';
		foreach($emp as $emp_id)
		{ 
		   $this->db->select('*');
		   $this->db->from('emp_last_date');
		   $this->db->where('emp_id',$emp_id);
		   $this->db->where('status','Y');
		   $query=$this->db->get();
		   $ldata=$query->result_array();
       if(empty($ldata))
        {
			$temp['emp_id']=$emp_id;
			$temp['last_date']=$ldate;
			$temp['created_on']=date('Y-m-d H:i:s');
			$temp['created_by']=$_SESSION['uid'];
            if($this->db->insert('emp_last_date',$temp))
			{
				$_SESSION['status']='Data Inserted successfully';
			}
			else
			{
				$_SESSION['status']='Something Went Wrong';
			}

           }
		}
		 redirect('Staff_payment/emp_last_date');
	}
	
	
	
		 public function change_emp_last_date_status()
	{
	  	$eid=$_POST['eid'];
		$status=$_POST['status'];
		$sts=$this->Staff_payment_model->change_emp_last_date_status($eid,$status);
	    echo  $sts;		
		

	}


    public function staff_basic_salary_increment_detview()
  {
	  $this->load->view('header',$this->data); 
	  $this->load->view($this->view_dir.'staff_basic_salary_increment_view',$this->data);
      $this->load->view('footer');  
  }
      public function fetch_staff_increment_data()
   {
	   $academic_year=$_REQUEST['acad_year'];
	   $from_date=$_REQUEST['from_date'];
	   $to_date=$_REQUEST['to_date'];
	   $this->data['incre_data']=$this->Staff_payment_model->fetch_staff_increment_search_data($academic_year,$from_date,$to_date);	
	    $html = $this->load->view($this->view_dir.'search_view',$this->data,true);
        echo $html ;	   
   }

////////////////////////////////////////////////////////////
///////////////////////////Arrears //////////////////

	public function arrears_list($mon=""){		
		$this->load->view('header',$this->data);
		if(empty($mon)){
		$mon = date('Y-m');
		}else{
		$mon = $mon;
		}
		$this->data['mon']= $mon;	
		$ex = explode('-',$mon);
		$fa = $this->Staff_payment_model->check_monthly_earning_deduction($ex[1],$ex[0]);
		$cnt = count($fa);
		if($cnt == '0'){
		$this->data['upflag'] = 1;
		}
		$this->data['arrears_list']= $this->Staff_payment_model->getArrearsList($mon); 
		$menu_name='staff_payment/arrears_list';
		$this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		$this->load->view($this->view_dir.'arrears_list',$this->data);
        $this->load->view('footer');
	}
     
	public function arrears_add(){
		$this->load->view('header',$this->data);  
		$this->data['emp_list']= $this->Staff_payment_model->get_employee();      		
		$this->load->view($this->view_dir.'arrears_add',$this->data);
		$this->load->view('footer');
	}
	
	public function emp_add_arrears(){
		
		$ins = $this->Staff_payment_model->add_arrears($_POST);
		redirect('staff_payment/arrears_list/'.$_POST['month']);
	
	}
   	public function upload_csv_file_arrears(){
		
	  $this->load->view('header',$this->data);
	  $filename=$_FILES["fupl"]["tmp_name"];		
      $file = fopen($filename, "r");

	 while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
	 	$num = count($column);
	 	if($num == '2'){
		 if(is_numeric($column[1]) && is_numeric($column[0])){
		 $arr[$column[0]][] = $column[1];
		 }
		}else{
			$this->session->set_flashdata('umessage','Uploaded File columns are mismatch, Only employee ID and Arrears amount is required.');
		}
	 }
		$this->data['upd_emp_list'] = $arr;
		$this->data['emp_list']= $this->Staff_payment_model->get_employee();      		
		$this->load->view($this->view_dir.'arrears_add',$this->data);
		$this->load->view('footer');
	}
  
   public function update_arrears_list(){
		$ups = $this->Staff_payment_model->updateArrearsList($_POST);
		redirect('Staff_payment/arrears_list/'.$_POST['cmon']);	
	}
	
	public function employee_arrears_update_submit(){
		$up = $this->Staff_payment_model->updateArrears($_POST);		
		redirect('Staff_payment/arrears_list/'.$_POST['arr_mon']);	
	}
   public function emp_arrears_update($id){
		$this->load->view('header',$this->data);  
        $this->data['emp_arrs']= $this->Staff_payment_model->getArrearsId($id);      		
        $this->load->view($this->view_dir.'emp_arrears_update',$this->data);
        $this->load->view('footer');
	}

    public function check_monthly_arrears($mon){
		$ex = explode('-',$mon);
		$fa = $this->Staff_payment_model->check_monthly_earning_deduction($ex[1],$ex[0]);
		$cfa = count($fa);
		if($cfa != '0'){
	      echo "false";
	    }else{
			echo 'true';
		}
	}
	
	public function export_excel_arrears_list(){
		//ini_set('error_reporting', E_ALL);
		$mon = $_POST['rmon'];
		if(empty($mon)){
		$mon = date('Y-m');
		}else{
		$mon = $mon;
		}
		$this->data['mon']= $mon;
		$this->data['arrears_list']= $this->Staff_payment_model->getArrearsList($mon); 	
        ob_clean();				
		$this->load->view($this->view_dir.'reports/emp_arrears_list_export',$this->data);
	}
  
}
?>