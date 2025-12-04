<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finance extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Finance_model');
    }

   public function dashboard($academicYear="", $tdate="")
	{
		// Academic Year filter
		if(!empty($_GET['academic_year'])){
			$academicYear= $_GET['academic_year'];
			$data['academicYear']= $_GET['academic_year'];
		}else{
			$academicYear="2025";
			$data['academicYear']="2025";
		}

		// Date filter
		if(!empty($_GET['date'])){
			$tdate = $_GET['date'];
			$data['tdate'] = $_GET['date'];
		} else {
			$tdate = date('Y-m-d');  // default today
			$data['tdate'] = $tdate;
		}

		$data['bankCount']   = $this->Finance_model->getBankCount();
		$data['invCount']    = $this->Finance_model->getInvestmentCount();
		$data['investments'] = $this->Finance_model->getInvestments();
		$data['maturity']    = $this->Finance_model->getMaturityCounts();

		// Campus wise with date filter
		$data['nashikSummary']     = $this->Finance_model->getFeeSummary($academicYear, 'nashik','0', $tdate);
		$data['sijoulSummary']     = $this->Finance_model->getFeeSummary($academicYear, 'sijoul','0', $tdate);
		$data['drccsijoulSummary'] = $this->Finance_model->getFeeSummary($academicYear, 'sijoul','1', $tdate);
		$data['sfsummary']         = $this->Finance_model->getFeeSummary_sf($academicYear, $tdate);
		//print_r($data['sfsummary']);exit;
		$data['sfscholarship']     = $this->Finance_model->getscholarshipSummary_sf($academicYear, $tdate);
		//
		$data['uniformToday'] = $this->Finance_model->getTodayUniformCollection($academicYear, 'nashik', $tdate);
		$data['hostelToday'] = $this->Finance_model->getTodaysfacilityCollection($academicYear, '1', $tdate);
		$data['transportToday'] = $this->Finance_model->getTodaysfacilityCollection($academicYear, '2', $tdate);
		//

		$data['nashikToday']   = $this->Finance_model->getTodayCollection($academicYear, 'nashik', $tdate);
		$data['sijoulToday']   = $this->Finance_model->getTodayCollection($academicYear, 'sijoul', $tdate);
		$datasfToday   = $this->Finance_model->getTodayCollection($academicYear, 'sf', $tdate);
		//print_r($datasfToday); echo'<br>';
		if($academicYear=='2025'){
			$academicYear = "2025-2026";
		}else if($academicYear=='2024'){
			$academicYear = "2024-2025";
		}else if($academicYear=='2023'){
			$academicYear = "2023-2024";
		}else if($academicYear=='2022'){
			$academicYear = "2022-2023";
		}else if($academicYear=='2021'){
			$academicYear = "2021-2022";
		}else{
			$academicYear = "2025-2026";
		}
		
		$dt = DateTime::createFromFormat('Y-m-d', $tdate);

		$outdate = ($dt && $dt->format('Y-m-d') === $tdate)
			? $dt->format('d/m/Y')     // "09/10/2025"
			: null;  
		$apiUrl = "https://sandiperp.com/RequestApi.aspx?ApiType=105&AcYear=$academicYear&Date=$outdate&UserTypeId=1";// echo '<br>';exit;
		$json   = file_get_contents($apiUrl);
		$data_jsn   = json_decode($json, true);
		foreach ($data_jsn as $row) {
			$amt = (float) str_replace([',',' '], '', $row['AcademicFees'] ?? 0);
			$total += $amt;
			
			$schamt = (float) str_replace([',',' '], '', $row['ScholarshipReceived'] ?? 0);
			$sf_schlorship_total += $schamt;
		}
		//echo $total;echo '<br>'; echo $datasfToday;exit;
		$data['sfToday']=$total+$datasfToday;
		$data['sf_schlorship_total']=$sf_schlorship_total;
		//print_r($data_jsn);exit;
		$this->load->view('finance_dashboard', $data);
	}

	
	


}
