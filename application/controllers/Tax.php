<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//ini_set('error_reporting', E_ALL);
class Tax extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="";
    var $model_name="Tax_model";
    var $model;
    var $view_dir='Tax/';
	
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
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
        $this->load->model("Tax_model");
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		$this->load->library('Awssdk');
		$this->bucket_name = 'erp-asset';
    }
    public function index()
    {
        global $model;
        $this->load->view('header',$this->data);  
        $this->data['tax_details']=$this->Tax_model->fetch_tax_details();		
        $this->load->view($this->view_dir.'tax_calculator_view',$this->data);
        $this->load->view('footer');
    }
  	public function tax_calculator_view()
	{	
		$this->load->view('header',$this->data);
		$this->data['tax_details']=$this->Tax_model->fetch_tax_details();
		$this->load->view($this->view_dir.'tax_calculator_view',$this->data);
		$this->load->view('footer');
	}
	public function tax_calculator111()
	{		
		$this->load->view('header',$this->data);
		$this->load->view($this->view_dir.'tax_calculator',$this->data);
		$this->load->view('footer');
	}
	
	public function tax_calculator()
	{		
		$this->load->view('header',$this->data);
		$gross_det=$this->Tax_model->fetch_gross_sal_det();
		$joindate=$gross_det['joiningDate'];$gross_sal='';
		if(!empty($joindate)){
		$fyear=explode('-',FINANCIAL_YEAR);
		
		$chck_date="$fyear[0]"."-06-01";
		$fyear=++$fyear[0];
		$end_date="$fyear"."-03-31";
		$date1 = new DateTime($joindate);
		$date2 = new DateTime($chck_date);
		if($date1 >=  $date2)
		{
		$start = new DateTime($joindate);
		$end = new DateTime($end_date);

		// Get the difference between the two dates
		$diff = $start->diff($end);

		//Extract the number of months and days from the difference
		$mul = $diff->m + ($diff->y * 12)+1;
		 $gross_sal=($gross_det['gross_salary']*$mul);
		}else{
			if($gross_det['scaletype']=="scale")
			{
				$gross_sal=($gross_det['gross_salary']*12);
			}
			else
			{
				$gross_sal=($gross_det['gross_salary']*11);
			}
		  }
		}
	
		$this->data['tot_gross']=$gross_sal;
		$this->load->view($this->view_dir.'tax_calculator',$this->data);
		$this->load->view('footer');
	}
	
	
		public function tax_invest_det_edit($tax_id,$emp_id='')
	{		
		$this->load->view('header',$this->data);
      	$tax_id=base64_decode($tax_id);
      	$emp_id=base64_decode($emp_id);
		$this->data['tax_edt']=$this->Tax_model->fetch_tax_details_edt($tax_id);
		$gross_det=$this->Tax_model->fetch_gross_sal_det($emp_id);
		$joindate=$gross_det['joiningDate'];$gross_sal='';
		if(!empty($joindate)){
		$fyear=explode('-',FINANCIAL_YEAR);
		
		$chck_date="$fyear[0]"."-06-01";
		$fyear=++$fyear[0];
		$end_date="$fyear"."-03-31";
		
		$date1 = new DateTime($joindate);
		$date2 = new DateTime($chck_date);
		if($date1 >=  $date2)
		{
		$start = new DateTime($joindate);
		$end = new DateTime($end_date);//////end date of month march-FINANCIAL YEAR;

		// Get the difference between the two dates
		$diff = $start->diff($end);

		//Extract the number of months and days from the difference
		$mul = $diff->m + ($diff->y * 12)+1;
		 $gross_sal=($gross_det['gross_salary']*$mul);
		}else{
			if($gross_det['scaletype']=="scale")
			{
			
				 $gross_sal=($gross_det['gross_salary']*12);;
			}
			else
			{
				$gross_sal=($gross_det['gross_salary']*11);
			}
		  }
		}
		$this->data['tot_gross']=$gross_sal;
		$this->load->view($this->view_dir.'tax_calculator_edit',$this->data);
		$this->load->view('footer');
	 }
	 
	
		public function tax_invest_det_edit11($tax_id)
	{		
		$this->load->view('header',$this->data);
      	$tax_id=base64_decode($tax_id);
		$this->data['tax_edt']=$this->Tax_model->fetch_tax_details_edt($tax_id);
		$this->load->view($this->view_dir.'tax_calculator_edit',$this->data);
		$this->load->view('footer');
	 }
	public function tax_investment_status_chng()
	{
		 $tax_id=$_POST['tax_id'];
	     $status=$_POST['status'];
		 $sts=$this->Tax_model->change_tax_details_status($tax_id,$status);
		 echo  $sts;
	}

	public function tax_calculation_det()
	{
        $tax_id=$_POST['tax_id'];
		$tax_details=$this->Tax_model->fetch_tax_details_edt($tax_id);
	    $um_id=$tax_details[0]['entry_by'];		 
		$tax_cred_det=$this->Tax_model->fetch_tax_cred_det($um_id);
		$monthly_sal_det=$this->Tax_model->fetch_monthly_sal_det($um_id);
		$gross_salary=$monthly_sal_det[0]['tot_gross'];
		if($gross_salary==0 || $gross_salary=='')
		{
		   $gross_salary=$tax_cred_det['gross_salary'];
		}			
		$basic_sal=$monthly_sal_det[0]['tot_basal'];
		$tot=$monthly_sal_det[0]['tot'];
		$epf=$monthly_sal_det[1]['tot_epf'];
		$ptax=$monthly_sal_det[1]['tot_ptax'];		
		$dp=$tax_cred_det['dp'];	
		$hra=$tax_cred_det['hra'];
		$standard_ded=50000;
		$tot_hra='';
		$joindate=$tax_cred_det['joiningDate'];
   			
		if($hra!='' && $hra!=0 && $hra >0 )
		{
		 if($tax_details[0]['house_rent_amount']!=''){
			$da=$monthly_sal_det[2]['tot_da'];
		 // $actual_hra=round($hra*$tot);  //Given by company
		   $actual_hra=$monthly_sal_det[2]['tot_hra'];  //Given by company
	       $fitypercent=round($basic_sal+($da)*0.5); //50% of[(basic_sal+da)*12]
		   $actual_rent=abs(round($tax_details[0]['house_rent_amount']-($basic_sal+($da)*0.1))); //user input-10% of[(basic_sal+da)*12]
	       $tot_hra=min($actual_hra,$fitypercent,$actual_rent); //least of three
		  }   
		}

        $src_amt=round($tot_hra+$standard_ded+$ptax+($tax_details[0]['medical_premium_amount'])+($tax_details[0]['house_loan_interest_amount']));
		
		$ext_amt=round(($tax_details[0]['expenditure_amount'])+($tax_details[0]['medical_exp_amount'])+($tax_details[0]['edu_loan_amount'])+($tax_details[0]['certain_funds_amount'])+($tax_details[0]['disability_ben_amount'])+($tax_details[0]['vehical_loan_amount'])+($tax_details[0]['nps_amount']));
		
		$total_80c=round($tax_details[0]['total_80c']+$epf);
		
		if($total_80c > 150000)
		{
			$total_80c=150000;
		}

		$taxable_income=abs(round($gross_salary-($src_amt + $total_80c + $ext_amt)));

		if($tax_cred_det['gender']=="male")
		{
			if($taxable_income <=250000)
			{
				$final_tax=0;
			}
            else if($taxable_income <=500000)
			{	
			  $final_tax=round((($taxable_income)-250000)*0.05);
			}
			else if($taxable_income <=1000000)
			{	
			  $final_tax=round(((($taxable_income)-500000)*0.2)+12500);
			}
            else if($taxable_income >1000000)
			{
				$final_tax=round(((($taxable_income)-1000000)*0.3)+112500);
			}
			else
			{
				$final_tax=0;
			}
	
		}
		else
		{
			if($taxable_income <=250000)
			{
				$final_tax=0;
			}
            else if($taxable_income <=500000)
			{	
			  $final_tax=round((($taxable_income)-250000)*0.05);
			}
			else if($taxable_income <=1000000)
			{	
			  $final_tax=round(((($taxable_income)-500000)*0.2)+12500);
			}
            else if($taxable_income >1000000)
			{
				$final_tax=round(((($taxable_income)-1000000)*0.3)+112500);
			}
			else
			{
				$final_tax=0;
			}			
		}
		 $tot_bonds=round(($tax_details[0]['tax_bond_amount'])+($tax_details[0]['other_amount'])); 
		  if($tot_bonds==0){$tot_bonds='';} 
		  $this->data['tot_bonds']=$tot_bonds;
		  $this->data['tax_details']=$tax_details;
		  $this->data['tax_cred_det']=$tax_cred_det;
		  $this->data['gross_salary']=$gross_salary;
		  $this->data['ptax']=$ptax;
		  $this->data['epf']=$epf;
		  $this->data['tot_hra']=$tot_hra;
		  $this->data['final_tax']=$final_tax;
		  $this->data['taxable_income']=$taxable_income;
		  $html = $this->load->view($this->view_dir.'tax_calculation_det',$this->data,true);
		  echo $html;
	}
	public function tax_calculator_submit()
	{
		 if(!empty($_FILES['house_rent_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['house_rent_file']['name']);
           $filenm=$rand.'-'.'house_rent'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['house_rent_file']['tmp_name']);
                   
                   $tax_files['house_rent_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['house_rent_file'] = "";    
                }

		}
		else{
			$tax_files['house_rent_file'] = '';
		  }
		  
		   
		 if(!empty($_FILES['house_loan_interest_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['house_loan_interest_file']['name']);
           $filenm=$rand.'-'.'house_loan'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['house_loan_interest_file']['tmp_name']);
                   
                   $tax_files['house_loan_interest_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['house_loan_interest_file'] = "";    
                }

		}
		else{
			$tax_files['house_loan_interest_file'] = '';
		  }
		   
		  if(!empty($_FILES['vpf_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['vpf_file']['name']);
           $filenm=$rand.'-'.'vpf'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['vpf_file']['tmp_name']);
                   
                   $tax_files['vpf_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['vpf_file'] = "";    
                }

		}
		else{
			$tax_files['vpf_file'] = '';
		  }
		  
		if(!empty($_FILES['provident_fund_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['provident_fund_file']['name']);
           $filenm=$rand.'-'.'provident'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['provident_fund_file']['tmp_name']);
                   
                   $tax_files['provident_fund_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['provident_fund_file'] = "";    
                }

		}
		else{
			$tax_files['provident_fund_file'] = '';
		  }
		  
		 if(!empty($_FILES['scss_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['scss_file']['name']);
           $filenm=$rand.'-'.'scss'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['scss_file']['tmp_name']);
                   
                   $tax_files['scss_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['scss_file'] = "";    
                }

		}
		else{
			$tax_files['scss_file'] = '';
		  }
		  
		  if(!empty($_FILES['nsc_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['nsc_file']['name']);
           $filenm=$rand.'-'.'nsc'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['nsc_file']['tmp_name']);
                   
                   $tax_files['nsc_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['nsc_file'] = "";    
                }

		}
		else{
			$tax_files['nsc_file'] = '';
		  }
		   
		  if(!empty($_FILES['txfd_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['txfd_file']['name']);
           $filenm=$rand.'-'.'txfd'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['txfd_file']['tmp_name']);
                   
                   $tax_files['txfd_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['txfd_file'] = "";    
                }

		}
		else{
			$tax_files['txfd_file'] = '';
		  }
		  
		  if(!empty($_FILES['tax_bond_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['tax_bond_file']['name']);
           $filenm=$rand.'-'.'tax_bond'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['tax_bond_file']['tmp_name']);
                   
                   $tax_files['tax_bond_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['tax_bond_file'] = "";    
                }

		}
		else{
			$tax_files['tax_bond_file'] = '';
		  }
		   
		 if(!empty($_FILES['elss_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['elss_file']['name']);
           $filenm=$rand.'-'.'elss'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['elss_file']['tmp_name']);
                   
                   $tax_files['elss_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['elss_file'] = "";    
                }

		}
		else{
			$tax_files['elss_file'] = '';
		  }
		  
		  if(!empty($_FILES['life_ins_prem_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['life_ins_prem_file']['name']);
           $filenm=$rand.'-'.'life_ins'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['life_ins_prem_file']['tmp_name']);
                   
                   $tax_files['life_ins_prem_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['life_ins_prem_file'] = "";    
                }

		}
		else{
			$tax_files['life_ins_prem_file'] = '';
		  }
		  
		  if(!empty($_FILES['nps_80c_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['nps_80c_file']['name']);
           $filenm=$rand.'-'.'nps_80c'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['nps_80c_file']['tmp_name']);
                   
                   $tax_files['nps_80c_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['nps_80c_file'] = "";    
                }

		}
		else{
			$tax_files['nps_80c_file'] = '';
		  }
		   
		 if(!empty($_FILES['pension_plan_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['pension_plan_file']['name']);
           $filenm=$rand.'-'.'pension'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['pension_plan_file']['tmp_name']);
                   
                   $tax_files['pension_plan_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['pension_plan_file'] = "";    
                }

		}
		else{
			$tax_files['pension_plan_file'] = '';
		  }
		   
		 if(!empty($_FILES['emp_pension_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['emp_pension_file']['name']);
           $filenm=$rand.'-'.'emp_pension'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['emp_pension_file']['tmp_name']);
                   
                   $tax_files['emp_pension_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['emp_pension_file'] = "";    
                }

		}
		else{
			$tax_files['emp_pension_file'] = '';
		  }
		  
		 if(!empty($_FILES['houseloan_prin_repay_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['houseloan_prin_repay_file']['name']);
           $filenm=$rand.'-'.'prin_repay'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['houseloan_prin_repay_file']['tmp_name']);
                   
                   $tax_files['houseloan_prin_repay_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['houseloan_prin_repay_file'] = "";    
                }

		}
		else{
			$tax_files['houseloan_prin_repay_file'] = '';
		  }
		 
		 if(!empty($_FILES['suk_sam_acc_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['suk_sam_acc_file']['name']);
           $filenm=$rand.'-'.'suk_sam'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['suk_sam_acc_file']['tmp_name']);
                   
                   $tax_files['suk_sam_acc_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['suk_sam_acc_file'] = "";    
                }

		}
		else{
			$tax_files['suk_sam_acc_file'] = '';
		  }
		  
		 if(!empty($_FILES['stamp_duty_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['stamp_duty_file']['name']);
           $filenm=$rand.'-'.'stamp_duty'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['stamp_duty_file']['tmp_name']);
                   
                   $tax_files['stamp_duty_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['stamp_duty_file'] = "";    
                }

		}
		else{
			$tax_files['stamp_duty_file'] = '';
		  }
		   
		  if(!empty($_FILES['tuition_fee_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['tuition_fee_file']['name']);
           $filenm=$rand.'-'.'tuition'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['tuition_fee_file']['tmp_name']);
                   
                   $tax_files['tuition_fee_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['tuition_fee_file'] = "";    
                }

		}
		else{
			$tax_files['tuition_fee_file'] = '';
		  }
		   
		 if(!empty($_FILES['other_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['other_file']['name']);
           $filenm=$rand.'-'.'house_rent'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['other_file']['tmp_name']);
                   
                   $tax_files['other_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['other_file'] = "";    
                }

		}
		else{
			$tax_files['other_file'] = '';
		  }
		  if(!empty($_FILES['nps_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['nps_file']['name']);
           $filenm=$rand.'-'.'nps'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['nps_file']['tmp_name']);
                   
                   $tax_files['nps_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['nps_file'] = "";    
                }

		}
		else{
			$tax_files['nps_file'] = '';
		  }
		 if(!empty($_FILES['medical_premium_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['medical_premium_file']['name']);
           $filenm=$rand.'-'.'med_prem'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['medical_premium_file']['tmp_name']);
                   
                   $tax_files['medical_premium_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['medical_premium_file'] = "";    
                }

		}
		else{
			$tax_files['medical_premium_file'] = '';
		  }
		  
		 if(!empty($_FILES['expenditure_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['expenditure_file']['name']);
           $filenm=$rand.'-'.'expend'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['expenditure_file']['tmp_name']);
                   
                   $tax_files['expenditure_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['expenditure_file'] = "";    
                }

		}
		else{
			$tax_files['expenditure_file'] = '';
		  }
		  
		 if(!empty($_FILES['medical_exp_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['medical_exp_file']['name']);
           $filenm=$rand.'-'.'med_exp'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['medical_exp_file']['tmp_name']);
                   
                   $tax_files['medical_exp_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['medical_exp_file'] = "";    
                }

		}
		else{
			$tax_files['medical_exp_file'] = '';
		  }
		  
		if(!empty($_FILES['edu_loan_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['edu_loan_file']['name']);
           $filenm=$rand.'-'.'edu_loan'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['edu_loan_file']['tmp_name']);
                   
                   $tax_files['edu_loan_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['edu_loan_file'] = "";    
                }

		}
		else{
			$tax_files['edu_loan_file'] = '';
		  }
		 
		if(!empty($_FILES['certain_funds_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['certain_funds_file']['name']);
           $filenm=$rand.'-'.'cer_funds'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['certain_funds_file']['tmp_name']);
                   
                   $tax_files['certain_funds_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['certain_funds_file'] = "";    
                }

		}
		else{
			$tax_files['certain_funds_file'] = '';
		  }
		  
		 if(!empty($_FILES['disability_ben_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['disability_ben_file']['name']);
           $filenm=$rand.'-'.'disability'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['disability_ben_file']['tmp_name']);
                   
                   $tax_files['disability_ben_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['disability_ben_file'] = "";    
                }

		}
		else{
			$tax_files['disability_ben_file'] = '';
		  }
		 
		if(!empty($_FILES['vehical_loan_file']['name'])){
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['vehical_loan_file']['name']);
           $filenm=$rand.'-'.'vehi_loan'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['vehical_loan_file']['tmp_name']);
                   
                   $tax_files['vehical_loan_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['vehical_loan_file'] = "";    
                }

		}
		else{
			$tax_files['vehical_loan_file'] = '';
		  }
            $check_entry=$this->Tax_model->check_entry_tax_det($_POST['financial_year']);
			
			if($check_entry <= 0){
		        $in_data=$this->Tax_model->insert_tax_files($_POST,$tax_files);
			    $_SESSION['status']="Your Details Submitted Successfully.";
			}
			else
			{
				  $_SESSION['status']="Your Details already Submitted.";
			}
			
			redirect('Tax/tax_calculator_view');
		  
	}	
	public function tax_calculator_update()
	{
		
		 if(!empty($_FILES['house_rent_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['house_rent_file']['name']);
           $filenm=$rand.'-'.'house_rent'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['house_rent_file']['tmp_name']);
                   
                   $tax_files['house_rent_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['house_rent_file'] = "";    
                }

		}
 
		 if(!empty($_FILES['house_loan_interest_file']['name'])){
			 
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['house_loan_interest_file']['name']);
           $filenm=$rand.'-'.'house_loan'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['house_loan_interest_file']['tmp_name']);
                   
                   $tax_files['house_loan_interest_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['house_loan_interest_file'] = "";    
                }

		}
		   
		  if(!empty($_FILES['vpf_file']['name'])){
			  
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['vpf_file']['name']);
           $filenm=$rand.'-'.'vpf'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['vpf_file']['tmp_name']);
                   
                   $tax_files['vpf_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['vpf_file'] = "";    
                }

		}
		  
		if(!empty($_FILES['provident_fund_file']['name'])){
			
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['provident_fund_file']['name']);
           $filenm=$rand.'-'.'provident'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['provident_fund_file']['tmp_name']);
                   
                   $tax_files['provident_fund_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['provident_fund_file'] = "";    
                }

		}
		  
		 if(!empty($_FILES['scss_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['scss_file']['name']);
           $filenm=$rand.'-'.'scss'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['scss_file']['tmp_name']);
                   
                   $tax_files['scss_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['scss_file'] = "";    
                }

		}
		  
		  if(!empty($_FILES['nsc_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['nsc_file']['name']);
           $filenm=$rand.'-'.'nsc'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['nsc_file']['tmp_name']);
                   
                   $tax_files['nsc_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['nsc_file'] = "";    
                }
		}
		   
		  if(!empty($_FILES['txfd_file']['name'])){
			  
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['txfd_file']['name']);
           $filenm=$rand.'-'.'txfd'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['txfd_file']['tmp_name']);
                   
                   $tax_files['txfd_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['txfd_file'] = "";    
                }
		}

		  
		  if(!empty($_FILES['tax_bond_file']['name'])){
			  
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['tax_bond_file']['name']);
           $filenm=$rand.'-'.'tax_bond'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['tax_bond_file']['tmp_name']);
                   
                   $tax_files['tax_bond_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['tax_bond_file'] = "";    
                }
		}

		   
		 if(!empty($_FILES['elss_file']['name'])){
			 
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['elss_file']['name']);
           $filenm=$rand.'-'.'elss'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['elss_file']['tmp_name']);
                   
                   $tax_files['elss_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['elss_file'] = "";    
                }
		}

		  
		  if(!empty($_FILES['life_ins_prem_file']['name'])){
			  
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['life_ins_prem_file']['name']);
           $filenm=$rand.'-'.'life_ins'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['life_ins_prem_file']['tmp_name']);
                   
                   $tax_files['life_ins_prem_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['life_ins_prem_file'] = "";    
                }
		}

		  
		  if(!empty($_FILES['nps_80c_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['nps_80c_file']['name']);
           $filenm=$rand.'-'.'nps_80c'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['nps_80c_file']['tmp_name']);
                   
                   $tax_files['nps_80c_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['nps_80c_file'] = "";    
                }
		}

		 if(!empty($_FILES['pension_plan_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['pension_plan_file']['name']);
           $filenm=$rand.'-'.'pension'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['pension_plan_file']['tmp_name']);
                   
                   $tax_files['pension_plan_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['pension_plan_file'] = "";    
                }
		}

		   
		 if(!empty($_FILES['emp_pension_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['emp_pension_file']['name']);
           $filenm=$rand.'-'.'emp_pension'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['emp_pension_file']['tmp_name']);
                   
                   $tax_files['emp_pension_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['emp_pension_file'] = "";    
                }
		}

		  
		 if(!empty($_FILES['houseloan_prin_repay_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['houseloan_prin_repay_file']['name']);
           $filenm=$rand.'-'.'prin_repay'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['houseloan_prin_repay_file']['tmp_name']);
                   
                   $tax_files['houseloan_prin_repay_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['houseloan_prin_repay_file'] = "";    
                }
		}

		 
		 if(!empty($_FILES['suk_sam_acc_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['suk_sam_acc_file']['name']);
           $filenm=$rand.'-'.'suk_sam'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['suk_sam_acc_file']['tmp_name']);
                   
                   $tax_files['suk_sam_acc_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['suk_sam_acc_file'] = "";    
                }
		}
		  
		 if(!empty($_FILES['stamp_duty_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['stamp_duty_file']['name']);
           $filenm=$rand.'-'.'stamp_duty'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['stamp_duty_file']['tmp_name']);
                   
                   $tax_files['stamp_duty_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['stamp_duty_file'] = "";    
                }
		}
		   
		  if(!empty($_FILES['tuition_fee_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['tuition_fee_file']['name']);
           $filenm=$rand.'-'.'tuition'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['tuition_fee_file']['tmp_name']);
                   
                   $tax_files['tuition_fee_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['tuition_fee_file'] = "";    
                }
		}

		 if(!empty($_FILES['other_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['other_file']['name']);
           $filenm=$rand.'-'.'house_rent'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['other_file']['tmp_name']);
                   
                   $tax_files['other_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['other_file'] = "";    
                }
		}
          
		   if(!empty($_FILES['nps_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['nps_file']['name']);
           $filenm=$rand.'-'.'nps'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['nps_file']['tmp_name']);
                   
                   $tax_files['nps_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['nps_file'] = "";    
                }
		  }
		  
		 if(!empty($_FILES['medical_premium_file']['name'])){
			 
		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['medical_premium_file']['name']);
           $filenm=$rand.'-'.'med_prem'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['medical_premium_file']['tmp_name']);
                   
                   $tax_files['medical_premium_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['medical_premium_file'] = "";    
                }
		}

		  
		 if(!empty($_FILES['expenditure_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['expenditure_file']['name']);
           $filenm=$rand.'-'.'expend'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['expenditure_file']['tmp_name']);
                   
                   $tax_files['expenditure_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['expenditure_file'] = "";    
                }

		}
		  
		 if(!empty($_FILES['medical_exp_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['medical_exp_file']['name']);
           $filenm=$rand.'-'.'med_exp'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['medical_exp_file']['tmp_name']);
                   
                   $tax_files['medical_exp_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['medical_exp_file'] = "";    
                }

		}
		  
		if(!empty($_FILES['edu_loan_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['edu_loan_file']['name']);
           $filenm=$rand.'-'.'edu_loan'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['edu_loan_file']['tmp_name']);
                   
                   $tax_files['edu_loan_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['edu_loan_file'] = "";    
                }

		}
		 
		if(!empty($_FILES['certain_funds_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['certain_funds_file']['name']);
           $filenm=$rand.'-'.'cer_funds'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['certain_funds_file']['tmp_name']);
                   
                   $tax_files['certain_funds_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['certain_funds_file'] = "";    
                }

		}

		  
		 if(!empty($_FILES['disability_ben_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['disability_ben_file']['name']);
           $filenm=$rand.'-'.'disability'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['disability_ben_file']['tmp_name']);
                   
                   $tax_files['disability_ben_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['disability_ben_file'] = "";    
                }
		}

		 
		if(!empty($_FILES['vehical_loan_file']['name'])){

		   $rand=rand(1000,9999);
		   $filenm_arr = explode(".",$_FILES['vehical_loan_file']['name']);
           $filenm=$rand.'-'.'vehi_loan'.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];

	      try{
                    $file_path = 'uploads/tax_calculator/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['vehical_loan_file']['tmp_name']);
                   
                   $tax_files['vehical_loan_file'] = $filenm;
                }catch(Exception $e){
				$tax_files['vehical_loan_file'] = "";    
                }

		}

		   $up_data=$this->Tax_model->update_tax_files($_POST,$tax_files);
		   if($up_data > 0){
			    $_SESSION['status']="Your Details Updated Successfully.";
			}
			else
			{
				  $_SESSION['status']="SomeThing Went Wrong.";
			}
			
		   redirect('Tax/tax_calculator_view');
	}	
		
	  public function generate_income_tax_excel($tax_id)
	{
        ini_set('memory_limit', '-1');
		$tax_details=$this->Tax_model->fetch_tax_details_edt($tax_id);
	    $um_id=$tax_details[0]['entry_by'];
		$tax_cred_det=$this->Tax_model->fetch_tax_cred_det($um_id);
		$monthly_sal_det=$this->Tax_model->fetch_monthly_sal_det($um_id);
		$gross_salary=$monthly_sal_det[0]['tot_gross'];
		$basic_sal=$monthly_sal_det[0]['tot_basal'];
		$tot=$monthly_sal_det[0]['tot'];
		$epf=$monthly_sal_det[1]['tot_epf'];
		$ptax=$monthly_sal_det[1]['tot_ptax'];	
		$dp=$tax_cred_det['dp'];
		$tot_hra=0;
	    $this->data['tax_details']=$tax_details;
		$this->data['tax_cred_det']=$tax_cred_det;
		$this->data['gross_salary']=$gross_salary; 
		$this->data['tot_hra']=$tot_hra; 
		$this->data['epf']=$epf; 
		$this->data['ptax']=$ptax; 
        $this->load->view($this->view_dir.'/generate_income_tax_excel',$this->data);
	}	
   
   
     public function tax_calculation_yearly($tax_id='',$tax_exl='')
	{
		if(isset($_POST['tax_id']) && $_POST['tax_id']!=''){
        $tax_id=$_POST['tax_id'];
	    }
		$tax_details=$this->Tax_model->fetch_tax_details_edt($tax_id);
	    $um_id=$tax_details[0]['entry_by'];		 
		$tax_cred_det=$this->Tax_model->fetch_tax_cred_det($um_id);
		$standard_ded=50000;
		$tot_hra='0';$mul='0';$epf='0';$ptax='0';$dp='0';$da='0';$gross_salary='0';$hra='0';
		$joindate=$tax_cred_det['joiningDate'];

		$fyear=explode('-',FINANCIAL_YEAR);
		 if(!empty($joindate))			 
		 {   
         	 
			 $chck_date=$fyear[0]."-06-01";
			 $fyear1=++$fyear[0];
			 $end_date=$fyear1."-03-31";
			 $date1 = new DateTime($joindate);
			 $date2 = new DateTime($chck_date);
            if($date1 >  $date2)
			{
				$start = new DateTime($joindate);
				$end = new DateTime($end_date);

				// Get the difference between the two dates
				$diff = $start->diff($end);

				//Extract the number of months and days from the difference
				$mul = $diff->m + ($diff->y * 12)+1;
				$days = $diff->d;
				$basic_sal=($tax_cred_det['basic_sal']*$mul);		
				$dp=($tax_cred_det['dp']*$mul);	
				$da=($tax_cred_det['da']*$mul);	
				$gross_salary=($tax_cred_det['gross_salary']*$mul);	
				$hra=($tax_cred_det['hra']*$mul);
				$grossM=(25000*$mul);
				$grossF=(7500*$mul);
				$grossFA=(10000*$mul);
				//Total Deduction calculations
			  if($tax_cred_det['pf_status']=='0'){
			  $epfa=(15000*$mul);
			  $epfb=$epfa+1;
			  $epf_sum = $basic_sal+$dp+$da;
			  
			  if($epf_sum<=$epfa){
				 $epf= round($epf_sum*0.12);

			  }elseif($epf_sum>=$epfb){
				 $epf=1800; 
			  }
			}else{
				$epf = '0';
			}
				$epf=($epf*$mul);	

				//Total Deduction calculations for Ptax
				if($tax_cred_det['gender']=='female'){
			  if($gross_salary<=$grossM){
				$ptax='0'; 
			  }else{
				 
				if($mons == '02'){
					$ptax = 300;
				}else{
					$ptax = '200';
				}				  
			  }
		  }elseif($tax_cred_det['gender']='male'){
			 if($gross_salary<=$grossF){
				 $ptax='0';
				 
			 }elseif($gross_salary>=($grossF+1) && $gross_salary<=$grossFA){
				 $ptax='175';
				 
			 }elseif($gross_salary>=($grossFA+1)){
				 if($mons == '02'){
					$ptax = 300;
				}else{
				  $ptax = '200';
				}
			 }
		  }	
		    $ptax=($ptax*$mul); 
			
			}
			else
			{
				if($tax_cred_det['scaletype']=="scale")
		         {  
			     $mul=12; 
				$basic_sal=($tax_cred_det['basic_sal']*$mul);		
				$dp=($tax_cred_det['dp']*$mul);	
				$da=($tax_cred_det['da']*$mul);	
				$gross_salary=($tax_cred_det['gross_salary']*$mul);	
                $hra=($tax_cred_det['hra']*12);				
			  //Total Deduction calculations for EPF
				if($tax_cred_det['pf_status']=='0'){
				$epf_sum = $basic_sal+$dp+$da;
				if($epf_sum<=180000){
				 $epf= round($epf_sum*0.12);

				}elseif($epf_sum>=180001){
				 $epf=1800; 
				}
				}else{
				$epf = '0';
				}
				$epf=($epf*$mul);	
			  
			/////////////////////////////
			if($tax_cred_det['gender']=='female'){
			  if($gross_salary<=300000){
				$ptax='0'; 
			  }else{
				 
				if($mons == '02'){
					$ptax = 300;
				}else{
					$ptax = '200';
				}				  
			  }
		  }elseif($tax_cred_det['gender']='male'){
			 if($gross_salary<=90000){
				 $ptax='0';
				 
			 }elseif($gross_salary>=90001 && $gross_salary<=120000){
				 $ptax='175';
				 
			 }elseif($gross_salary>=120001){
				 if($mons == '02'){
					$ptax = 300;
				}else{
				  $ptax = '200';
				}
			 }
		  }	
		  $ptax=($ptax*$mul);
			if($ptax > 0)
			{
				$ptax=($ptax+100);
			}	 
			}else
			{
				$mul=11;
				$basic_sal=($tax_cred_det['basic_sal']*$mul);		
				$dp=($tax_cred_det['dp']*$mul);	
				$da=($tax_cred_det['da']*$mul);	
				$gross_salary=($tax_cred_det['gross_salary']*$mul);
				$hra=($tax_cred_det['hra']*11);	
				//Total Deduction calculations for EPF
				if($tax_cred_det['pf_status']=='0'){
				$epf_sum = $basic_sal+$dp+$da;
				if($epf_sum<=165000){
				 $epf= round($epf_sum*0.12);

				}elseif($epf_sum>=165001){
				 $epf=1800; 
				}
				}else{
				$epf = '0';
				}
				$epf=($epf*$mul);	
			  
			/////////////////////////////
		 //Total Deduction calculations for Ptax
				if($tax_cred_det['gender']=='female'){
			  if($gross_salary<=275000){
				$ptax='0'; 
			  }else{
				 
				if($mons == '02'){
					$ptax = 300;
				}else{
					$ptax = '200';
				}				  
			  }
		  }elseif($tax_cred_det['gender']='male'){
			 if($gross_salary<=82500){
				 $ptax='0';
				 
			 }elseif($gross_salary>=82501 && $gross_salary<=110000){
				 $ptax='175';
				 
			 }elseif($gross_salary>=110001){
				 if($mons == '02'){
					$ptax = 300;
				}else{
				  $ptax = '200';
				}
			 }
		  }	
		  $ptax=($ptax*$mul);
		  if($ptax > 0)
			{
				$ptax=($ptax+100);
			}
	     }
		  ///////////////////////////////										
		   }
		 } 
      		 
		if($hra!='' && $hra!=0 && $hra >0)
		{
		 if($tax_details[0]['house_rent_amount']!=''){
		 // $actual_hra=round($hra*$tot);  //Given by company
		   //$actual_hra=$monthly_sal_det[2]['tot_hra'];  //Given by company
		   $actual_hra=$hra;  //Given by company
	       $fitypercent=round($basic_sal+($da)*0.5); //50% of[(basic_sal+da)*12]
		   $actual_rent=abs(round($tax_details[0]['house_rent_amount']-($basic_sal+($da)*0.1))); //user input-10% of[(basic_sal+da)*12]
	       $tot_hra=min($actual_hra,$fitypercent,$actual_rent); //least of three
		  }   
		}

        $src_amt=round($tot_hra+$standard_ded+$ptax+($tax_details[0]['medical_premium_amount'])+($tax_details[0]['house_loan_interest_amount']));
		
		$ext_amt=round(($tax_details[0]['expenditure_amount'])+($tax_details[0]['medical_exp_amount'])+($tax_details[0]['edu_loan_amount'])+($tax_details[0]['certain_funds_amount'])+($tax_details[0]['disability_ben_amount'])+($tax_details[0]['vehical_loan_amount'])+($tax_details[0]['nps_amount']));
		
		$total_80c=round($tax_details[0]['total_80c']+$epf);
		
		if($total_80c > 150000)
		{
			$total_80c=150000;
		}

		$taxable_income=abs(round($gross_salary-($src_amt + $total_80c + $ext_amt)));

		if($tax_cred_det['gender']=="male")
		{
			if($taxable_income <=250000)
			{
				$final_tax=0;
			}
            else if($taxable_income <=500000)
			{	
			  $final_tax=round((($taxable_income)-250000)*0.05);
			}
			else if($taxable_income <=1000000)
			{	
			  $final_tax=round(((($taxable_income)-500000)*0.2)+12500);
			}
            else if($taxable_income >1000000)
			{
				$final_tax=round(((($taxable_income)-1000000)*0.3)+112500);
			}
			else
			{
				$final_tax=0;
			}
	
		}
		else
		{
			if($taxable_income <=250000)
			{
				$final_tax=0;
			}
            else if($taxable_income <=500000)
			{	
			  $final_tax=round((($taxable_income)-250000)*0.05);
			}
			else if($taxable_income <=1000000)
			{	
			  $final_tax=round(((($taxable_income)-500000)*0.2)+12500);
			}
            else if($taxable_income >1000000)
			{
				$final_tax=round(((($taxable_income)-1000000)*0.3)+112500);
			}
			else
			{
				$final_tax=0;
			}			
		}
		 $tot_bonds=round(($tax_details[0]['tax_bond_amount'])+($tax_details[0]['other_amount'])); 
		  if($tot_bonds==0){$tot_bonds='';} 
		  $this->data['tot_bonds']=$tot_bonds;
		  $this->data['tax_details']=$tax_details;
		  $this->data['tax_cred_det']=$tax_cred_det;
		  $this->data['gross_salary']=$gross_salary;
		  $this->data['ptax']=$ptax;
		  $this->data['epf']=$epf;
		  $this->data['tot_hra']=$tot_hra;
		  $this->data['final_tax']=$final_tax;
		  $this->data['taxable_income']=$taxable_income;
		   if($tax_exl=="Excel"){
			  $this->load->view($this->view_dir.'/generate_income_tax_excel',$this->data);
		  }else{
		  $html = $this->load->view($this->view_dir.'tax_calculation_det',$this->data,true);
		  echo $html;
		  }
	}
}
?>