<?php

$this->load->library('excel'); 
				header('Content-Type: application/vnd.ms-excel');
	  header('Cache-Control: max-age=0');
	  if($soc_f==1){
	header('Content-Disposition: attachment;filename="society_bill.xls"');
	  }elseif($soc_f==2){
			header('Content-Disposition: attachment;filename="society_loan_bill.xls"');
		}else{
	  header('Content-Disposition: attachment;filename="busfare_bill.xls"');
	  }
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
				   $object->getActiveSheet()->mergeCells('B2:k2');
        $object->getActiveSheet()->getStyle('B2:k2')->getFont()->setBold(true);
        $object->getActiveSheet()->getStyle('B2:k2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('B2', 'SANDIP UNIVERSITY');
      $object->getActiveSheet()->mergeCells('B3:k3');        
        $object->getActiveSheet()->getStyle('B3:k3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('B3', 'TRIMBAK ROAD,MAHIRAVANI,NASHIK-422213');
      $object->getActiveSheet()->mergeCells('B7:k7');  
        $object->getActiveSheet()->getStyle('B7:k7')->getFont()->setBold(true);      
        $object->getActiveSheet()->getStyle('B7:k7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		if($soc_f==1){
			$object->getActiveSheet()->setCellValue('B7', 'Society Bill');
		}if($soc_f==2){
			$object->getActiveSheet()->setCellValue('B7', 'Society Loan');
		}else{
		$object->getActiveSheet()->setCellValue('B7', 'Bus Fare Bill');
		}
		
		
		 $object->getActiveSheet()->setCellValue('B8', 'Sr.no');
		 $object->getActiveSheet()->getStyle('B8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('C8', 'Emp ID');
	  $object->getActiveSheet()->getStyle('C8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	   $object->getActiveSheet()->setCellValue('D8', 'Name');
	  $object->getActiveSheet()->getStyle('D8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('E8', 'Gender');
	  $object->getActiveSheet()->getStyle('E8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	   $object->getActiveSheet()->setCellValue('F8', 'School');
	  $object->getActiveSheet()->getStyle('F8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	   $object->getActiveSheet()->setCellValue('G8', 'Department');
	  $object->getActiveSheet()->getStyle('G8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('H8', 'Designation');
	  $object->getActiveSheet()->getStyle('H8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  if($soc_f==1){
		  $object->getActiveSheet()->setCellValue('I8', 'Amount');
	  $object->getActiveSheet()->getStyle('I8')->applyFromArray($styleArray)->applyFromArray($styleArray1);	  
	  $object->getActiveSheet()->setCellValue('J8', 'Active From');
	  $object->getActiveSheet()->getStyle('J8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  }elseif($soc_f==2){
		  $object->getActiveSheet()->setCellValue('I8', 'Loan Amount');
	  $object->getActiveSheet()->getStyle('I8')->applyFromArray($styleArray)->applyFromArray($styleArray1);	  
	  $object->getActiveSheet()->setCellValue('J8', 'Monthly Deduction');
	  $object->getActiveSheet()->getStyle('J8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	   $object->getActiveSheet()->setCellValue('K8', 'Active From');
	  $object->getActiveSheet()->getStyle('K8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	   $object->getActiveSheet()->setCellValue('L8', 'Active TO');
	  $object->getActiveSheet()->getStyle('L8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  }else{
	  $object->getActiveSheet()->setCellValue('I8', 'Bus Fare');
	  $object->getActiveSheet()->getStyle('I8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('J8', 'Boarding Point');
	  $object->getActiveSheet()->getStyle('J8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  $object->getActiveSheet()->setCellValue('K8', 'Active From');
	  $object->getActiveSheet()->getStyle('K8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  }
	  $i=1;
	  $j=9;
	  foreach($busfare_list as $val){
		  $school = $this->Admin_model->getSchoolById($val['emp_school']);
		  $department =  $this->Admin_model->getDepartmentById($val['department']); 
		  $desig = $this->Admin_model->getDesignationById($val['designation']);
		 // $styp = $this->Admin_model->getAllEmpCategoryById($val['staff_type']);
		 $det = $val['bill_amount'] - $val['mobile_limit'];
			if($det < 0){
				 $det = 0;
			}else{
				 $det = $det;
			}		
		 
		   $object->getActiveSheet()->setCellValue('B'.$j, $i);
	if($soc_f==1){
$object->getActiveSheet()->getStyle('B'.$j.':J'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	}elseif($soc_f==2){
$object->getActiveSheet()->getStyle('B'.$j.':L'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	}else{	
$object->getActiveSheet()->getStyle('B'.$j.':K'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
	}
$object->getActiveSheet()->setCellValue('C'.$j, $val['emp_id']);
$object->getActiveSheet()->setCellValue('D'.$j, $val['fname']." ".$val['mname']." ".$val['lname']);
$object->getActiveSheet()->setCellValue('E'.$j, $val['gender']);
$object->getActiveSheet()->setCellValue('F'.$j, $school[0]['college_code']);
$object->getActiveSheet()->setCellValue('G'.$j, $department[0]['department_name']);
$object->getActiveSheet()->setCellValue('H'.$j, $desig[0]['designation_name']);
 if($soc_f==1){
	 $object->getActiveSheet()->setCellValue('I'.$j, $val['soc_amount']);
$object->getActiveSheet()->setCellValue('J'.$j, date('M Y',strtotime($val['active_from'])));
 }elseif($soc_f==2){
	 $object->getActiveSheet()->setCellValue('I'.$j, $val['loan_amount']);
	  $object->getActiveSheet()->setCellValue('J'.$j, $val['monthly_deduction']);
$object->getActiveSheet()->setCellValue('K'.$j, date('m-Y',strtotime($val['from_month'])));
$object->getActiveSheet()->setCellValue('L'.$j, date('m-Y',strtotime($val['to_month'])));
 }else{
$object->getActiveSheet()->setCellValue('I'.$j, $val['bus_fare']);
$object->getActiveSheet()->setCellValue('J'.$j, $val['boarding_point']);
$object->getActiveSheet()->setCellValue('K'.$j, date('M Y',strtotime($val['active_from'])));
 }
//$object->getActiveSheet()->setCellValue('K'.$j, $det);

$i++;
$j++;
	  }  
	  $objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('test_img');
$objDrawing->setDescription('test_img');
$objDrawing->setPath('assets/images/logo_exl.jpg');
$objDrawing->setCoordinates('C1');                      
//setOffsetX works properly
$objDrawing->setOffsetX(5); 
$objDrawing->setOffsetY(5);                
//set width, height
$objDrawing->setWidth(80); 
$objDrawing->setHeight(80); 
$objDrawing->setWorksheet($object->getActiveSheet());
			 $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		$objWriter->setPreCalculateFormulas(true);      
		
		
			echo $objWriter->save('php://output');


?>