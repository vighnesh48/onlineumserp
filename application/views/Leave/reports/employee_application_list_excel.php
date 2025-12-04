<?php 
$this->load->library('excel');
 $object = new PHPExcel();
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

	$object->getActiveSheet()->getStyle('A1:M2')->getFont()->setBold(true);
	  $object->getActiveSheet()->getStyle('A1:M2')->applyFromArray($styleArray);
	  if($ltyp =='od'){ 
$object->getActiveSheet()->mergeCells('A1:M1')->setCellValue('A1','Employee OD Application list '.date('F Y',strtotime('01-'.$mon)));

	  }else{
	$object->getActiveSheet()->mergeCells('A1:M1')->setCellValue('A1','Employee Leave Application list '.date('F Y',strtotime('01-'.$mon)));
}
$object->getActiveSheet()->setCellValue('A2','Sr.No');
$object->getActiveSheet()->setCellValue('B2','Appl ID');
$object->getActiveSheet()->setCellValue('C2','Date & Time');
$object->getActiveSheet()->setCellValue('D2','Emp ID');
$object->getActiveSheet()->setCellValue('E2','Name of Applicant');
$object->getActiveSheet()->setCellValue('F2','School');
$object->getActiveSheet()->setCellValue('G2','Department');
$object->getActiveSheet()->setCellValue('H2','Leave Type');
$object->getActiveSheet()->setCellValue('I2','From Date');
$object->getActiveSheet()->setCellValue('J2','To Date');
$object->getActiveSheet()->setCellValue('K2','No. Of Days');
$object->getActiveSheet()->setCellValue('L2','Date & Time of Forward by RO');
$object->getActiveSheet()->setCellValue('M2','Signature');
  
		$j=1;
			$row = 3;	
		foreach($applicant_leave as $val){
			  
			  if($val['leave_type'] == 'lwp' || $val['leave_type'] == 'LWP'){
                                            //echo 'LWP';
                                         $lt = $this->leave_model->getLeaveTypeById1('9');
                                    }else{
                                          $lt = $this->leave_model->getLeaveTypeById($val['leave_type']);
                                   if($lt == 'VL'){
                                  $cnt =  $this->leave_model->get_vid_emp_allocation($val['leave_type']);
            $lt = $lt." - ".$cnt[0]['slot_type']." ";    
        }else{
            $lt = $lt;
        }

                                    }
 if($val['gender']=='male'){ $g = 'Mr.';}else if($val['gender']=='female'){ $g = 'Mrs.';}       
//$un = $this->leave_model->get_username($val['inserted_by']);
 $uid = $this->session->userdata("name");
									if($val['emp1_reporting_person'] == $uid){							
								$st = $val['emp1_reporting_status'];
								$empr = '1';
									}elseif($val['emp2_reporting_person'] == $uid){									
									$st = $val['emp2_reporting_status'];
									$empr = '2';
									}elseif($val['emp3_reporting_person'] == $uid){									
									$st = $val['emp3_reporting_status'];
									$empr = '3';
									}elseif($val['emp4_reporting_person']==$uid){										
									$st = $val['emp4_reporting_status'];
									$empr = '4';
									}
									
									
if($sel == 'pending'){
	 if($empr != 1){
	 $r = $empr - 1;
	 }else{
		 $r = $empr;
	 }
	 if(empty($st) && !empty($val['emp'.$r.'_reporting_date']) && $val['emp'.$r.'_reporting_status'] != 'Rejected' ){
	 
$object->getActiveSheet()->setCellValue('A'.$row, $j);
$object->getActiveSheet()->setCellValue('B'.$row, $val['lid']);
$object->getActiveSheet()->setCellValue('C'.$row,date('d-m-Y h:i',strtotime($val['inserted_datetime'])));
$object->getActiveSheet()->setCellValue('D'.$row, $val['emp_id']);
$object->getActiveSheet()->setCellValue('E'.$row, $g." ".$val['fname']." ".$val['lname']);
$object->getActiveSheet()->setCellValue('F'.$row, $val['college_code']);
$object->getActiveSheet()->setCellValue('G'.$row, $val['department_name']);
if($ltyp =='od'){
$object->getActiveSheet()->setCellValue('H'.$row,'OD');
	}else{
$object->getActiveSheet()->setCellValue('H'.$row,$lt);
}
$object->getActiveSheet()->setCellValue('I'.$row,date('d-m-Y',strtotime($val['applied_from_date'])));
$object->getActiveSheet()->setCellValue('J'.$row,date('d-m-Y',strtotime($val['applied_to_date'])));

if($ltyp =='od'){
if($val['leave_apply_type'] == 'OD' && $val['leave_duration'] == 'hrs'){ 
           $object->getActiveSheet()->setCellValue('K'.$row,$val['no_hrs'].' Hrs');
                                          }else{ 
       $object->getActiveSheet()->setCellValue('K'.$row,$val['no_days']);
                                      } 
           }else{
$object->getActiveSheet()->setCellValue('K'.$row,$val['no_days']);
}
 $object->getActiveSheet()->setCellValue('L'.$row,date('d-m-Y h:i',strtotime($val['emp'.$r.'_reporting_date'])));
$object->getActiveSheet()->setCellValue('M'.$row,'');
$row = $row+1;
		  $j=$j+1;	
	 }
}elseif($sel == 'approved'){
	    if($empr != 1){
	 $r = $empr - 1;
	 }else{
		 $r = $empr;
	 }
	 if(!empty($st)){
		$object->getActiveSheet()->setCellValue('A'.$row, $j);
$object->getActiveSheet()->setCellValue('B'.$row, $val['lid']);
$object->getActiveSheet()->setCellValue('C'.$row,date('d-m-Y h:i',strtotime($val['inserted_datetime'])));
$object->getActiveSheet()->setCellValue('D'.$row, $val['emp_id']);
$object->getActiveSheet()->setCellValue('E'.$row, $g." ".$val['fname']." ".$val['lname']);
$object->getActiveSheet()->setCellValue('F'.$row, $val['college_code']);
$object->getActiveSheet()->setCellValue('G'.$row, $val['department_name']);
if($ltyp =='od'){
$object->getActiveSheet()->setCellValue('H'.$row,'OD');
	}else{
$object->getActiveSheet()->setCellValue('H'.$row,$lt);
}
$object->getActiveSheet()->setCellValue('I'.$row,date('d-m-Y',strtotime($val['applied_from_date'])));
$object->getActiveSheet()->setCellValue('J'.$row,date('d-m-Y',strtotime($val['applied_to_date'])));
if($ltyp =='od'){

if($val['leave_apply_type'] == 'OD' && $val['leave_duration'] == 'hrs'){ 
           $object->getActiveSheet()->setCellValue('K'.$row,$val['no_hrs'].' Hrs');
                                          }else{ 
       $object->getActiveSheet()->setCellValue('K'.$row,$val['no_days']);
                                      } 
           }else{
$object->getActiveSheet()->setCellValue('K'.$row,$val['no_days']);
}
 $object->getActiveSheet()->setCellValue('L'.$row,date('d-m-Y h:i',strtotime($val['emp'.$r.'_reporting_date'])));
$object->getActiveSheet()->setCellValue('M'.$row,'');
$row = $row+1;
		  $j=$j+1;	
} 
					  }else{
						    if($empr != 1){
	 $r = $empr - 1;
	 }else{
		 $r = $empr;
	 }
		 $object->getActiveSheet()->setCellValue('A'.$row, $j);
$object->getActiveSheet()->setCellValue('B'.$row, $val['lid']);
$object->getActiveSheet()->setCellValue('C'.$row,date('d-m-Y h:i',strtotime($val['inserted_datetime'])));
$object->getActiveSheet()->setCellValue('D'.$row, $val['emp_id']);
$object->getActiveSheet()->setCellValue('E'.$row, $g." ".$val['fname']." ".$val['lname']);
$object->getActiveSheet()->setCellValue('F'.$row, $val['college_code']);
$object->getActiveSheet()->setCellValue('G'.$row, $val['department_name']);
if($ltyp =='od'){
$object->getActiveSheet()->setCellValue('H'.$row,'OD');
	}else{
$object->getActiveSheet()->setCellValue('H'.$row,$lt);
}
$object->getActiveSheet()->setCellValue('I'.$row,date('d-m-Y',strtotime($val['applied_from_date'])));
$object->getActiveSheet()->setCellValue('J'.$row,date('d-m-Y',strtotime($val['applied_to_date'])));
if($ltyp =='od'){

if($val['leave_apply_type'] == 'OD' && $val['leave_duration'] == 'hrs'){ 
           $object->getActiveSheet()->setCellValue('K'.$row,$val['no_hrs'].' Hrs');
                                          }else{ 
       $object->getActiveSheet()->setCellValue('K'.$row,$val['no_days']);
                                      } 
           }else{
$object->getActiveSheet()->setCellValue('K'.$row,$val['no_days']);
}

if(!empty($val['emp'.$r.'_reporting_date'])){
 $object->getActiveSheet()->setCellValue('L'.$row,date('d-m-Y h:i',strtotime($val['emp'.$r.'_reporting_date'])));
}else{
	$object->getActiveSheet()->setCellValue('L'.$row,'');
}
 $object->getActiveSheet()->setCellValue('M'.$row,'');
$row = $row+1;
		  $j=$j+1;	
					  } 
  		
		}
	$row=$row-1;	

for($r=3;$r<=$row;$r++){
			 $object->getActiveSheet()->getStyle('A'.$r.':M'.$r)->applyFromArray($styleArray);
		}					
$filename='employee_leave_application_list.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output'); ?>