<?php
ini_set('display_errors',1);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Import extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Import_model', 'import');
        $this->load->model('Ums_admission_model', 'ums_model');
        $this->load->model('Reports_model', 'reports');
    }

    // upload xlsx|xls file
    public function index() {
        $data['page'] = 'import';
        $data['title'] = 'Import XLSX | TechArise';
        $this->load->view('import/index', $data);
    } 
	public function exemption() {
		
		ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
		
        $data['page'] = 'import';
        $data['title'] = 'Import XLSX | TechArise';
        $this->load->view('import/scholarship', $data);
    }
    // import excel data
    public function save() {
        $this->load->library('excel');
      
        if ($this->input->post('importfile')) {
            $path = 'uploads/acimport/';
  
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls|jpg|png';
            $config['remove_spaces'] = TRUE;
			
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

         
            if (!$this->upload->do_upload('userfile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            
            if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                        . '": ' . $e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            
			//print_r($allDataInSheet); exit;
			
            $arrayCount = count($allDataInSheet);
            $flag = 0;
			$createArray = array(
			'enrollment_no',
             'Studnet_name',
             'stream_name',
			'academic_year',
            'year',
            'university_bank',
            'University_bank_city',
            'fees_paid_type',
            'trans_no',
            'trans_date',
            'amount',
            'fees_payment_date',
            'manual_receipt_no',
            'Student_bank_name',
            'Student_bank_branch'
            );
           $makeArray = array('enrollment_no'=>'enrollment_no',
             'Studnet_name'=>'Studnet_name',
             'stream_name'=>'stream_name',
			'academic_year'=>'academic_year',
            'year'=>'year',
            'university_bank'=>'university_bank',
            'University_bank_city'=>'University_bank_city',
            'fees_paid_type'=>'fees_paid_type',
            'trans_no'=>'trans_no',
            'trans_date'=>'trans_date',
            'amount'=>'amount',
            'fees_payment_date'=>'fees_payment_date',
            'manual_receipt_no'=>'manual_receipt_no',
            'Student_bank_name'=>'Student_bank_name',
            'Student_bank_branch'=>'Student_bank_branch'
            );
            //$makeArray = array('First_Name' => 'First_Name', 'Last_Name' => 'Last_Name', 'Email' => 'Email', 'DOB' => 'DOB', 'Contact_NO' => 'Contact_NO');
            $SheetDataKey = array();
            foreach ($allDataInSheet as $dataInSheet) {
                foreach ($dataInSheet as $key => $value) {
                    if (in_array(trim($value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                        $SheetDataKey[trim($value)] = $key;
                    } else {
                        
                    }
                }
            }
            $data = array_diff_key($makeArray, $SheetDataKey);
           
		   //echo "<pre>";
		   //print_r($makeArray);
		   //print_r($SheetDataKey);
		  // echo $SheetDataKey[2]['enrollment_no'];
		   //echo "stude:"; echo $student_id = $this->import->getstudentid($SheetDataKey[2]['enrollment_no']); 
			//print_r($data);
			
		   
            if (empty($data)) {
                $flag = 1;
            }
			
            if ($flag == 1) {
                for ($i = 2; $i <= $arrayCount; $i++) {
                //for ($i = 2; $i <= 4; $i++) {
                    //$addresses = array();
                    $enrollment_no = $SheetDataKey['enrollment_no'];
					//echo $student_id = $this->import->getstudentid($SheetDataKey['enrollment_no']); 
                    $Studnet_name = $SheetDataKey['Studnet_name'];
                    $stream_name = $SheetDataKey['stream_name'];
                    $academic_year = $SheetDataKey['academic_year'];
                    $year = $SheetDataKey['year'];
                    $university_bank = $SheetDataKey['university_bank'];
                    $University_bank_city = $SheetDataKey['University_bank_city'];
                    $fees_paid_type = $SheetDataKey['fees_paid_type'];
                    $trans_no = $SheetDataKey['trans_no'];
                    $trans_date = $SheetDataKey['trans_date'];
                    $amount = $SheetDataKey['amount'];
                    $fees_payment_date = $SheetDataKey['fees_payment_date'];
                    $manual_receipt_no = $SheetDataKey['manual_receipt_no'];
                    $Student_bank_name = $SheetDataKey['Student_bank_name'];
                    $Student_bank_branch = $SheetDataKey['Student_bank_branch'];
                    
					
					
                    $enrollment_no = filter_var(trim($allDataInSheet[$i][$enrollment_no]), FILTER_SANITIZE_STRING);
                    $Studnet_name = filter_var(trim($allDataInSheet[$i][$Studnet_name]), FILTER_SANITIZE_STRING);
                    $stream_name = filter_var(trim($allDataInSheet[$i][$stream_name]), FILTER_SANITIZE_EMAIL);
                    $academic_year = filter_var(trim($allDataInSheet[$i][$academic_year]), FILTER_SANITIZE_STRING);
                    $year = filter_var(trim($allDataInSheet[$i][$year]), FILTER_SANITIZE_STRING);
                    $university_bank = filter_var(trim($allDataInSheet[$i][$university_bank]), FILTER_SANITIZE_STRING);
                    $University_bank_city = filter_var(trim($allDataInSheet[$i][$University_bank_city]), FILTER_SANITIZE_STRING);
                    $fees_paid_type = filter_var(trim($allDataInSheet[$i][$fees_paid_type]), FILTER_SANITIZE_STRING);
                    $trans_no = filter_var(trim($allDataInSheet[$i][$trans_no]), FILTER_SANITIZE_STRING);
                    $trans_date = filter_var(trim($allDataInSheet[$i][$trans_date]), FILTER_SANITIZE_STRING);
                    $amount = filter_var(trim($allDataInSheet[$i][$amount]), FILTER_SANITIZE_STRING);
                    $fees_payment_date = filter_var(trim($allDataInSheet[$i][$fees_payment_date]), FILTER_SANITIZE_STRING);
                    $manual_receipt_no = filter_var(trim($allDataInSheet[$i][$manual_receipt_no]), FILTER_SANITIZE_STRING);
                    $Student_bank_name = filter_var(trim($allDataInSheet[$i][$Student_bank_name]), FILTER_SANITIZE_STRING);
                    $Student_bank_branch = filter_var(trim($allDataInSheet[$i][$Student_bank_branch]), FILTER_SANITIZE_STRING);
					$student_id = $this->import->getstudentid($enrollment_no);
                    $noofinst= $this->import->fetch_no_of_installment($student_id);
					$minbalance= $this->import->fetch_last_balance($student_id);
					$totfeepaid= $this->import->fetch_total_fee_paid($student_id);
					$actual_fees= $this->import->fetch_admission_details($student_id,$academic_year);
					
					//print_r($actual_fees); exit;
					if($enrollment_no!=''){
						$fetchData[$i] = array(
						'enrollment_no' => $enrollment_no, 
						'student_id' => $student_id,
						'noofinst'=> $noofinst[0]['max_no_installment'],
						'minbalance'=> $minbalance[0]['min_balance'],
						'totfeepaid'=> $totfeepaid[0]['tot_fee_paid'],
						'actfee'=> $actual_fees[0]['applicable_fee'],
						'Studnet_name' => $Studnet_name, 'stream_name' => $stream_name, 'academic_year' => $academic_year, 'academic_year' => $academic_year,
						'year' => $year, 'university_bank' => $university_bank, 'University_bank_city' => $University_bank_city, 'fees_paid_type' => $fees_paid_type, 'trans_no' => $trans_no,
						'trans_date' => $trans_date, 'amount' => $amount, 'fees_payment_date' => $fees_payment_date, 'manual_receipt_no' => $manual_receipt_no, 'Student_bank_name' => $Student_bank_name,'Student_bank_branch'=>$Student_bank_branch
						);
					
					
						if($manual_receipt_no!=='' && $this->import->fees_exist($manual_receipt_no)){
						try{
							$this->import->pay_Installment($fetchData[$i]);
							$fetchData[$i]['Remark']='Pass';
						} catch (Exception $e) {
							die('there is some issue while storing data');
						}
						}else{
							$fetchData[$i]['Remark']='Fail';
						}
					}
					
                }        
//print_r($fetchData); echo "</pre>";	exit;
				
               $data['stud_fees_data'] = $fetchData;
                //$this->import->pay_Installment($fetchData);
                //$this->import->importData();
            } else {
                echo "Please import correct file";
            }
			/*foreach($fetchData as $key => $values){
					print_r($values); 
					try{
						$this->import->pay_Installment($values);
					} catch (Exception $e) {
						die('there is some issue while storing data');
					}
				}*/
        }
        $this->load->view('import/display', $data);
        
    }
	
	public function mapchallan(){
		echo "<pre>";
		//echo "Jai Hind";exit;
		$academic_year='2019';
		$fees_paid_type='CHQ';
		$manual_fees = $this->import->get_manual_fees($academic_year,$fees_paid_type);
		
		foreach($manual_fees as $stdfee){
			$student_id = $stdfee['student_id'];
			$std_details = $this->import->fetch_student_details($student_id);
			
			$stream_id=$std_details[0]['admission_stream'];
			
			$academic_year=$std_details[0]['academic_year'];
			$admission_session=$std_details[0]['admission_session'];
			$current_year=$std_details[0]['current_year'];
			
			$fees_challan = $this->import->get_stud_latest_challan($academic_year,$fees_paid_type,$student_id);
			
			if(empty($fees_challan)){
				if($academic_year==$admission_session){
					//$str= $this->import->fetch_academic_fees_for_rereg($stream_id,$academic_year,$admission_session,$current_year);
				}else{
					//Re-registered student only //first entry to fees_challan table
					$student_fees_details=$fees_structure=$previous_balance=$fees_structure=$university_fees=$exam_fees=$admission_form=$caution_money=$development=$tution_fees=array();
					$str= $this->ums_model->fetch_academic_fees_for_reregistration($stream_id,$academic_year,$admission_session);
					//$previous_balance['opening_balance'] = $this->import->get_previous_balance($academic_year,$student_id);
					$university_fees['university_fees'] = $str[0]['lab']+$str[0]['student_activity']+$str[0]['seminar_training']+$str[0]['educational_industrial_visit']+
										$str[0]['internet']+$str[0]['eligibility']+$str[0]['nss']+$str[0]['library']+$str[0]['student_safety_insurance']+$str[0]['registration']+
										$str[0]['computerization']+$str[0]['disaster_management']+$str[0]['Gymkhana'];
					$exam_fees['exam_fees'] = $str[0]['exam_fees'];
					$admission_form['admission_form'] = $str[0]['admission_form'];
					$caution_money['caution_money'] = $str[0]['caution_money'];
					$development['development'] = $str[0]['development'];
					$tution_fees['tution_fees'] = $str[0]['tution_fees'];
					$std_id['student_id']=$student_id;
					$amount['amount']=$stdfee['amount'];	
					$college_receiptno['college_receiptno']=$stdfee['college_receiptno'];	
					
					//$student_fees_details,$std_id,$amount,$college_receiptno;
					$student_fees_details = array_merge($student_fees_details,$std_id,$amount,$college_receiptno);
					$fees_structure=array_merge($fees_structure,$university_fees,$exam_fees,$admission_form,$caution_money,$development,$tution_fees,$previous_balance);
					asort($fees_structure);
					echo "<pre><br> sorted fees <br>";
					
					print_r($fees_structure);
					print_r($student_fees_details);
					$new=array();
					$new['amount']=$amt=$amount['amount'];
					$new['fees_date']=$stdfee['fees_date'];
					$new['exam_session']=$stdfee['college_receiptno'];
					$new['challan_status']="VR";
					$new['is_deleted']="N";
					$new['type_id']=$stdfee['type_id'];;
					$new['bank_account_id']=$stdfee['type_id'];;
					$new['enrollment_no']=$stdfee['enrollment_no'];;
					$new['fees_paid_type']=$stdfee['fees_paid_type'];;
					$new['transactionNo']=$stdfee['receipt_no'];;
					$new['transactionDate']=$stdfee['fees_date'];;
					$new['receipt_no']=$stdfee['receipt_no'];;
					$new['bank_id']=$stdfee['bank_id'];;
					$new['bank_city']=$stdfee['bank_city'];;
					$new['academic_year']=$stdfee['academic_year'];;
					
					foreach($fees_structure as $key=>$val){
						if($amt>0){
							if($val==0){
								$new[$key]=0;
								$new[$key."_pending"]=0;
								$new[$key."_status"]='Y';
							}else{
								if($amt>$val){
									$amt=$amt-$val;
									$new[$key]=$val;
									$new[$key."_pending"]=0;
									$new[$key."_status"]='Y';
								}elseif($amt<$val){
									$new[$key]=$amt;
									$pend_amt=$val-$amt;
									$new[$key."_pending"]=$pend_amt;
									if($pend_amt==0){
										$new[$key."_status"]='Y';
									}else{
										$new[$key."_status"]='N';
									}
									$amt=0;
								}else{
									$new[$key]=0;
									$new[$key."_pending"]=$val;
									$new[$key."_status"]='N';
								}
								
							}
						}	
					}
					print_r($new);
					
					//creating the challan array
					//$fees_chall_obj= array();
					//$fees_chall_obj[''];
					
					
				}
			}else{
				//$fees_structure[$student_id]=$fees_challan;
			}
			
			//$student_challan[$stdfee['student_id']]['manual']=$stdfee;
		}
	exit;
		$students = array_unique(array_column($manual_fees, 'student_id'));
		
		
		//$fees_challan = $this->import->get_fees_challan($academic_year,$fees_paid_type,$students);
		
		foreach($fees_challan as $challan){
			$student_fees_challan[$challan[																			'student_id']]['challan']=$challan;
		}
		//print_r($student_challan);
		//$fees_receipts = $this->import->get_fees_receipt($academic_year,$fees_paid_type);
		
		//$students = array_column($manual_fees, 'amount', 'student_id');
		
		
		//print_r($student_fees_challan);
		
		$diff = array_diff_key($student_challan,$student_fees_challan);
		echo "======Diff=====";
		echo count($diff);
		
		if(!empty($diff)){
			foreach($diff as $key=>$val){
				 $std_details = $this->import->fetch_student_details($key);
				//print_r($std_details);exit;
				$stud_id=$std_details[0]['stud_id'];
				$stream_id=$std_details[0]['admission_stream'];
				$academic_year=$std_details[0]['academic_year'];
				$admission_session=$std_details[0]['admission_session'];
				$current_year=$std_details[0]['current_year'];
				if($academic_year==$admission_session){
					$fees_structure[$stud_id]= $this->import->fetch_academic_fees_for_rereg($stream_id,$academic_year,$admission_session,$current_year);
				}else{
					$fees_structure[$stud_id]= $this->ums_model->fetch_academic_fees_for_reregistration($stream_id,$academic_year,$admission_session);
				}
				//print_r($fees_structure);
		//print_r($diff);
		//exit;
				/*$val['manual']['student_id'];
				$val['manual']['amount'];
				$val['manual']['college_receiptno'];
				$fees_structure = $this->import->get_fees_structure($academic_year,$fees_paid_type,);
				$student_fees_challan[$challan['student_id']]['challan']=$challan;*/
			}
			
		}
		print_r($fees_structure);
		//print_r($diff);
		exit;
		
	}
	
	
	public function add_exemption(){
		$this->load->library('excel');
      
        if ($this->input->post('importfile')) {
            $path = 'uploads/acimport/';
  
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls|jpg|png';
            $config['remove_spaces'] = TRUE;
			
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

         
            if (!$this->upload->do_upload('userfile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            
            if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                        . '": ' . $e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            echo "<pre>";
			//print_r($allDataInSheet); exit;
			
			 $arrayCount = count($allDataInSheet);
            $flag = 0;
			$createArray = array(
			'enrollment_no',
             'Scholorship'
             
            );
           $makeArray = array(
		   'enrollment_no'=>'enrollment_no',
             'Scholorship'=>'Scholorship'
             
            );
            //$makeArray = array('First_Name' => 'First_Name', 'Last_Name' => 'Last_Name', 'Email' => 'Email', 'DOB' => 'DOB', 'Contact_NO' => 'Contact_NO');
            $SheetDataKey = array();
            foreach ($allDataInSheet as $dataInSheet) {
                foreach ($dataInSheet as $key => $value) {
                    if (in_array(trim($value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                        $SheetDataKey[trim($value)] = $key;
                    } else {
                        
                    }
                }
            }
			
            $data = array_diff_key($makeArray, $SheetDataKey);
			
			if (empty($data)) {
                $flag = 1;
            }
			
            if ($flag == 1) {
                for ($i = 2; $i <= $arrayCount; $i++) {
                //for ($i = 2; $i <= 4; $i++) {
                    //$addresses = array();
                    $enrollment_no = $SheetDataKey['enrollment_no'];
					$Scholorship = $SheetDataKey['Scholorship'];
                    
                    
					
					
                    $enrollment_no = filter_var(trim($allDataInSheet[$i][$enrollment_no]), FILTER_SANITIZE_STRING);
                    $Scholorship = filter_var(trim($allDataInSheet[$i][$Scholorship]), FILTER_SANITIZE_STRING);
					$academic_year='2019';
					$stud_details= $this->import->get_admission_details($enrollment_no, $academic_year);
                  
					$student_id=$stud_details[0]['student_id'];
                    $actual_fees=$stud_details[0]['actual_fee'];
                    $applicable_fee=$stud_details[0]['applicable_fee'];
					
					
					//print_r($stud_details);					exit;
					if($student_id!=''){
						$fetchData[$i] = array(
						'student_id' => $student_id, 
						'enrollment_no' => $enrollment_no, 
						'Scholorship' => $Scholorship,
						'actual_fees' => $actual_fees,
						'applicable_fee' => $applicable_fee,
						'academic_year' => $academic_year,
						);
						//print_r($fetchData[$i]);					exit;
						
						try{
							$this->import->update_scholarship($fetchData[$i]);
							echo $i."-".$enrollment_no."-".$student_id."<br>";
						} catch (Exception $e) {
								die('there is some issue while storing data');
						}
					
					
					
					}
					
                }        
//print_r($fetchData); echo "</pre>";	exit;
				
               //$data['stud_fees_data'] = $fetchData;
                //$this->import->pay_Installment($fetchData);
                //$this->import->importData();
            } else {
                echo "Please import correct file";
            }
		}
		
	}
}
?>