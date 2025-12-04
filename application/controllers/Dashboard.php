<?php
ini_set("display_errors", "On");
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller 
{

    var $currentModule="";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Reports_model";
    var $model;
    var $view_dir='Dashboard/';
    
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
     //   echo $_SERVER['REMOTE_ADDR'];
 // var_dump($_SESSION);
// error_reporting(E_ALL);
//ini_set('display_errors', 1);
setlocale(LC_MONETARY, 'en_IN');
if(isset($this->session->userdata['role_id']))
{
   // echo "jugal";
}
//echo $this->session->userdata['role_id'].">>>>>>>>>>>>>>";
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
        $this->load->model('Fees_model');
        
        $menu_name=$this->uri->segment(1);        
      //  $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    
        public function superadmin($acyear='')
    {
         if(($this->session->userdata('role_id')==6) || ($this->session->userdata('role_id')==5) || ($this->session->userdata('role_id')==29)|| ($this->session->userdata('role_id')==40)){
          
        
        global $model;
        $academic_year=C_RE_REG_YEAR;
        if($acyear!='')
        {
           $academic_year=$acyear;   
        }
       //var_dump($this->Reports_model->geOtherFees($academic_year));
        $this->load->view('header',$this->data);    
			$this->data['academic_year']=$academic_year;   
		     // common
			 $getTotalfee_new_reg= $this->Reports_model->getTotalfee_new_reg($academic_year);
		     $getExemfee_new_reg= $this->Reports_model->getExemfee_new_reg($academic_year);
		     $getFeeReceived_new_reg= $this->Reports_model->getFeeReceived_new_reg($academic_year);
		     $get_opening_balance_new_reg= $this->Reports_model->get_opening_balance_new_reg($academic_year);
			 $geOtherFees_new_reg= $this->Reports_model->geOtherFees_new_reg($academic_year);
			 $fees_refunds_new_reg= $this->Reports_model->fees_refunds_new_reg($academic_year);

			 $this->data['getTotalfee_new']=$getTotalfee_new_reg["totalfee_new"];
			
		     $this->data['getExemfee_new']=$getExemfee_new_reg["exemfee_new"];			 
			 $this->data['getFeeReceived_new']= $getFeeReceived_new_reg["fee_received_new"];
		      $this->data['opening_balance_new']=   $get_opening_balance_new_reg["opaning_bal_new"];
			 $this->data['other_fees_new']=  $geOtherFees_new_reg["other_fees_new"];
			 $this->data['refunds_new']=  $fees_refunds_new_reg['totalrefund_new'];
			$this->data['getTotalfee_reg']=$getTotalfee_new_reg["totalfee_reg"];
			 $this->data['getExemfee_reg']=$getExemfee_new_reg["exemfee_reg"];
			 $this->data['getFeeReceived_reg']= $getFeeReceived_new_reg["fee_received_reg"];
			 
			  $this->data['getTotalAdm_reg']= $this->Reports_model->getTotalAdm_reg($academic_year);
			 $this->data['opening_balance_reg']=   $get_opening_balance_new_reg["opaning_bal_reg"];
			
			  $this->data['other_fees_reg']=  $geOtherFees_new_reg["other_fees_reg"];
			 $this->data['refunds_reg']=  $fees_refunds_new_reg['totalrefund_reg'];

             $this->data['opening_balance']= $this->Reports_model->get_opening_balance($academic_year);
             $this->data['other_fees']= $this->Reports_model->geOtherFees($academic_year);
			 $this->data['getTotalAdmAll'] = $this->Reports_model->getTotalAdmAll($academic_year); 
			 $this->data['getTotalAdmNew']= $this->Reports_model->getTotalAdmNew($academic_year);
             $this->data['refunds']= $this->Reports_model->fees_refunds($academic_year);
             $this->data['cdata']= $this->Reports_model->getchartdata($academic_year);
             //$this->data['fees']=$this->Fees_model->get_fees_statistics(array('academic_year'=>$academic_year,'get_by'=>'course'));
             $this->data['cancle']=$this->Fees_model->get_cancle_admission_details($academic_year);
			 
			 
			   $getTotal= $this->Reports_model->getTotal($academic_year);
			 
 			   $this->data['gender']=  $getTotal;
               $this->data['admyear']= $getTotal;
               $this->data['domacile']= $getTotal;  
			
            // $this->data['gender']= $this->Reports_model->getGenderwiseTotal($academic_year);
            // $this->data['admyear']= $this->Reports_model->getYearwiseTotal($academic_year);
            // $this->data['domacile']= $this->Reports_model->getDomacilewiseTotal($academic_year); 
     
     
   
		 $this->load->view($this->view_dir.'superadmin',$this->data);
		 $this->load->view('footer');
		 }else{
			  redirect('login'); 
          
        }

    }
	public function feesStatistics($academic_year='')
    {
		
		 global $model;
		   $fees=$this->Fees_model->get_fees_statistics(array('academic_year'=>$academic_year,'get_by'=>'course'));
			
        					   $result="";  
								$i=1;
									if(!empty($fees)){
										foreach($fees as $stud)
										{
													 $result.='<tr>';
													 $result.='<td>'.$i.'</td>';
													 $result.='<td>'.$stud['course'].'</td>';
													 $result.='<td><i class="fa fa-inr">&nbsp;&nbsp;'.money_format('%!.0n',(int)$stud['applicable_total']).'</i></td>';
													 $result.='<td><i class="fa fa-inr">&nbsp;&nbsp;'.money_format('%!.0n',$stud['fees_total']).'</i></td>';
													 $result.='<td><i class="fa fa-inr"></i>&nbsp;&nbsp;'.money_format('%!.0n',(int)$stud['applicable_total']-(int)$stud['fees_total']).'</td>';
													$result.='</tr>';
								
										          $i++;
										}
										
									}
									
									echo $result;
									
	}	
	 public function superadmin_reported($acyear=''){
		 global $model;
        $academic_year='2021';
		  $this->load->model('Reports_status_model');
		   $this->session->userdata('role_id');
		 // exit();
         if(($this->session->userdata('role_id')==6) || ($this->session->userdata('role_id')==5) || ($this->session->userdata('role_id')==29)){
        
        
        if($acyear!='')
        {
           $academic_year=$acyear;   
        }
       //var_dump($this->Reports_model->geOtherFees($academic_year));
        $this->load->view('header',$this->data);    
             $this->data['getTotalfee']= $this->Reports_status_model->getTotalfee($academic_year);
             $this->data['getExemfee']= $this->Reports_status_model->getExemfee($academic_year);
             $this->data['getFeeReceived']= $this->Reports_status_model->getFeeReceived($academic_year);
             $this->data['getTotalAdm']= $this->Reports_status_model->getTotalAdm($academic_year);
             $this->data['opening_balance']= $this->Reports_status_model->get_opening_balance($academic_year);
             $this->data['other_fees']= $this->Reports_status_model->geOtherFees($academic_year);
			 $this->data['getTotalAdmAll'] = $this->Reports_status_model->getTotalAdmAll($academic_year);
			 $this->data['getTotalAdmNew']= $this->Reports_status_model->getTotalAdmNew($academic_year);
             $this->data['refunds']= $this->Reports_status_model->fees_refunds($academic_year);
             $this->data['cdata']= $this->Reports_status_model->getchartdata($academic_year);
			 
             $this->data['fees']=$this->Reports_status_model->get_fees_statistics(array('academic_year'=>$academic_year,'get_by'=>'course'));
             $this->data['cancle']=$this->Reports_status_model->get_cancle_admission_details($academic_year);
			 
             $this->data['gender']= $this->Reports_status_model->getGenderwiseTotal($academic_year);
             $this->data['admyear']= $this->Reports_status_model->getYearwiseTotal($academic_year);
             $this->data['domacile']= $this->Reports_status_model->getDomacilewiseTotal($academic_year);
     
     
   
     $this->load->view($this->view_dir.'superadmin',$this->data);
     $this->load->view('footer');
	 }else{
			  redirect('login'); 
          
        }
    }
	
	function load_feelist()
	{
	    
	      $data['emp_list']= $this->Online_feemodel->getFeesajax();
	      // $data['dcourse']= $_POST['astream'];
	      //  $data['dyear']= $_POST['ayear'];
	      
	      $html = $this->load->view($this->view_dir.'load_feedata',$data,true);
	  echo $html;
	}
	
	function update_fstatus()
	{
	  $this->Online_feemodel->update_feestatus();  
	 echo "Y";   
	}

    public function admissiondashboard($academic_year='')
    {
        $academicYear =  ADMISSION_SESSION;
		
		
		
		// Getting Current Academic Year
        $getAdmissionCountCurrentYear = getAdmissionCountCurrentYear($academicYear); // Current Admissions Count

        $this->data['academicYear'] = $academicYear;
        $this->data['finalAdmissionCount'] = $getAdmissionCountCurrentYear;
        
        $this->load->view('header', $this->data);    
        $this->load->view($this->view_dir.'admissiondashboard', $this->data);
        $this->load->view('footer');
    }
    public function outstanding_report($acyear='',$today="")
    {
         if(($this->session->userdata('role_id')==6) || ($this->session->userdata('role_id')==5) || ($this->session->userdata('role_id')==29) || ($this->session->userdata('role_id')==40)){
        if(!empty($_POST['cdate'])){
				$today=$_POST['cdate'];
		}else{
			$today=date('Y-m-d');
		}
		if(!empty($_POST['academic_year'])){
				$acyear=$_POST['academic_year'];
		}else{
			$acyear='2025';
		}
		$this->data['cdate'] = $today;
		$this->data['academic_year'] = $acyear;
		
		
        $this->update_opening_balance($acyear,$today);       
        $academic_year='2023';
        if($acyear!='')
        {
           $academic_year=$acyear;   
        }
       //var_dump($this->Reports_model->geOtherFees($academic_year));
        $this->load->view('header',$this->data);    
			$this->data['academic_year']=$academic_year;   
		     // common
			 $this->data['fees']= $this->Reports_model->get_fees_details_fromdb($academic_year);
			 if($acyear==2025){
				 $getTotalfee_new_reg= $this->Reports_model->getTotalfee_new_reg_23($academic_year);
				 $getFeeReceived_new_reg= $this->Reports_model->getFeeReceived_new_reg_23($academic_year);
				 $this->data['getTotalAdmNew']= $this->Reports_model->getTotalAdmNew_23($academic_year);
				 $getExemfee_new_reg= $this->Reports_model->getExemfee_new_reg_23($academic_year);
				$fees_refunds_new_reg= $this->Reports_model->fees_refunds_new_reg_23($academic_year);				 
			}else{
				$getTotalfee_new_reg= $this->Reports_model->getTotalfee_new_reg($academic_year);
				$getFeeReceived_new_reg= $this->Reports_model->getFeeReceived_new_reg($academic_year);
				$this->data['getTotalAdmNew']= $this->Reports_model->getTotalAdmNew($academic_year);
				 $getExemfee_new_reg= $this->Reports_model->getExemfee_new_reg($academic_year);	
				 $fees_refunds_new_reg= $this->Reports_model->fees_refunds_new_reg($academic_year);
			}
			 
		    	     
		     $get_opening_balance_new_reg= $this->Reports_model->get_opening_balance_new_reg($academic_year);
			 $geOtherFees_new_reg= $this->Reports_model->geOtherFees_new_reg($academic_year);
			 

			 $this->data['getTotalfee_new']=$getTotalfee_new_reg["totalfee_new"];			
		     $this->data['getExemfee_new']=$getExemfee_new_reg["exemfee_new"];			 
			 $this->data['getFeeReceived_new']= $getFeeReceived_new_reg["fee_received_new"];
		      $this->data['opening_balance_new']=   $get_opening_balance_new_reg["opaning_bal_new"];
			 $this->data['other_fees_new']=  $geOtherFees_new_reg["other_fees_new"];
			 $this->data['refunds_new']=  $fees_refunds_new_reg['totalrefund_new'];
			$this->data['getTotalfee_reg']=$getTotalfee_new_reg["totalfee_reg"];
			 $this->data['getExemfee_reg']=$getExemfee_new_reg["exemfee_reg"];
			 $this->data['getFeeReceived_reg']= $getFeeReceived_new_reg["fee_received_reg"];
			 
			  $this->data['getTotalAdm_reg']= $this->Reports_model->getTotalAdm_reg($academic_year);
			 $this->data['opening_balance_reg']=   $get_opening_balance_new_reg["opaning_bal_reg"];
			
			  $this->data['other_fees_reg']=  $geOtherFees_new_reg["other_fees_reg"];
			 $this->data['refunds_reg']=  $fees_refunds_new_reg['totalrefund_reg'];

             $this->data['opening_balance']= $this->Reports_model->get_opening_balance($academic_year);
             $this->data['other_fees']= $this->Reports_model->geOtherFees($academic_year);
			 $this->data['getTotalAdmAll'] = $this->Reports_model->getTotalAdmAll($academic_year); 
			 
             $this->data['refunds']= $this->Reports_model->fees_refunds($academic_year);
             $this->data['cdata']= $this->Reports_model->getchartdata($academic_year);
             //$this->data['fees']=$this->Fees_model->get_fees_statistics(array('academic_year'=>$academic_year,'get_by'=>'course'));
             $this->data['cancle']=$this->Fees_model->get_cancle_admission_details($academic_year);
			 
			 
			   $getTotal= $this->Reports_model->getTotal($academic_year);
			 
 			   $this->data['gender']=  $getTotal;
               $this->data['admyear']= $getTotal;
               $this->data['domacile']= $getTotal;  
			
            // $this->data['gender']= $this->Reports_model->getGenderwiseTotal($academic_year);
            // $this->data['admyear']= $this->Reports_model->getYearwiseTotal($academic_year);
            // $this->data['domacile']= $this->Reports_model->getDomacilewiseTotal($academic_year); 
     
     
   
		 $this->load->view($this->view_dir.'outstanding_report',$this->data);
		 $this->load->view('footer');
		 }else{
			  redirect('login'); 
          
        }

    }
	public function update_opening_balance($acyear,$today)
	{
		$this->load->model("Account_model");
		$this->data['academic_year']=$acyear;
		 $DB1 = $this->load->database('umsdb', TRUE);
		$fees=$this->Account_model->get_studentwise_admission_fees_for_update($acyear);
		$todays_fees_paid=$this->Account_model->get_todays_fees_paid($acyear,$today);
		$todays_fees_paid_dec=$this->Account_model->get_todays_fees_paid_dec($acyear,$today);
		foreach($fees as $row){
				if(empty($row['opening_balance'])){
					$curent_paid=$row['fees_total'];
					$preview=0;
				}else{	
					if ($row['opening_balance'] < 0){
						$preview=0;
					}else{
						$preview=$row['opening_balance'];//$row['fees_total'] - $row['opening_balance'];
					}
					
				}
				if(empty($row['fees_total'])){
					$curent_paid=0;
				  $preview=0;
				}else{
					if ($row['opening_balance'] < 0){
						  $curent_paid=$row['fees_total'];
					}else{
						if($row['fees_total'] < $row['opening_balance']){
						  $curent_paid=0;
						  $preview=$row['fees_total'];
						}else{
						  $curent_paid=$row['fees_total'] - $row['opening_balance'];
						}					
					}
				}
				
				$current_fees_paid[] = $curent_paid;
				$opening_fees_paid[] = $preview;
		}
		
		$fcd['opening_amount_paid']=array_sum($opening_fees_paid);
		$fcd['todays_collection']=$todays_fees_paid[0]['amount'];
		$fcd['dec_collection']=$todays_fees_paid_dec[0]['amount'];
		$fcd['last_updated_on']=date('Y-m-d h:i:s');
		$academic_year=$acyear;
		 $DB1->where('academic_year', $academic_year);		
        $DB1->update('fees_dashboard',$fcd);
		//echo $DB1->last_query();exit;
		//echo 'current_fees_paid-'.array_sum($current_fees_paid);
		//echo 'opening_fees_paid-'. array_sum($opening_fees_paid);
		return true;
	}
	function transport_fees_report($admission_session='')
	 {
		 $this->load->model('dashboard_model');
		$this->load->view('header',$this->data);
        $this->data['student_data']=$this->dashboard_model->fetch_student_data($admission_session);		
		$this->load->view($this->view_dir."uni_student_view",$this->data);
		$this->load->view('footer');
		 
	 }
	 
	 function uniform_summary_report()
	 {
		  $this->load->model('dashboard_model');
		$this->load->view('header',$this->data);
        $this->data['uniform_data']=$this->dashboard_model->fetch_uniform_data();		
		$this->load->view($this->view_dir."uniform_view",$this->data);
		$this->load->view('footer');
		 
	 } 
	public function hostel_fees_report($admission_session='',$campus='')
    {
	
      $this->load->model('dashboard_model');
        $this->load->view('header',$this->data);
        $this->data['hostel_data']=$this->dashboard_model->fetch_hostel_data($admission_session,$campus);	
		$this->data['acad_year']=$this->dashboard_model->getAllAcademicYear();
        $this->load->view($this->view_dir.'uniform_report.php',$this->data);
        $this->load->view('footer');
    }
	function uniform_pending_summary_report($org='',$school_id='')
	 {
		 $this->load->model('dashboard_model');
		$this->load->view('header',$this->data);
		if($org=='SU'){
			$this->data['uniform_data']=$this->dashboard_model->fetch_uniform_pending_data($org,$school_id);
			$this->load->view($this->view_dir."uniform_view_pending",$this->data);
		}else{
			$this->data['uniform_data']=$this->dashboard_model->fetch_uniform_pending_data_sf($org,$school_id);
			$this->load->view($this->view_dir."uniform_view_pending_sf",$this->data);
		}		
		
		$this->load->view('footer');
		 
	 } 
	 function summary()
	 {

		$this->load->view("newdashboard1",$this->data);
		 
	 } 
	 function summary2()
	 {

		$this->load->view("newdashboard2",$this->data);
		 
	 } 
}
?>