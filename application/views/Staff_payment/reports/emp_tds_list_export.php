<?php

$this->load->library('excel'); 
				header('Content-Type: application/vnd.ms-excel');
	  header('Cache-Control: max-age=0');
	  header('Content-Disposition: attachment;filename="TDS_Deduction_List_'.date('M_Y',strtotime($mon)).'.xls"');
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
				   $object->getActiveSheet()->mergeCells('B2:H2');
        $object->getActiveSheet()->getStyle('B2:H2')->getFont()->setBold(true);
        $object->getActiveSheet()->getStyle('B2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('B2', 'SANDIP UNIVERSITY');
      $object->getActiveSheet()->mergeCells('B3:H3');        
        $object->getActiveSheet()->getStyle('B3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('B3', 'TRIMBAK ROAD,MAHIRAVANI,NASHIK-422213');
      $object->getActiveSheet()->mergeCells('B7:I7');  
        $object->getActiveSheet()->getStyle('B7:I7')->getFont()->setBold(true);      
        $object->getActiveSheet()->getStyle('B7:I7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('B7', 'TDS Bill For Month of '.date('M Y',strtotime($mon)));
		
		
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
	  $object->getActiveSheet()->setCellValue('H8', 'Amount');
	  $object->getActiveSheet()->getStyle('H8')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	 
	  
	  $i=1;
	  $j=9;
	  foreach($tds_list as $val){
		  $school = $this->Admin_model->getSchoolById($val['emp_school']);
		  $department =  $this->Admin_model->getDepartmentById($val['department']); 
		  //$desig = $this->Admin_model->getDesignationById($val['designation']);
		 // $styp = $this->Admin_model->getAllEmpCategoryById($val['staff_type']);
		
		 
		   $object->getActiveSheet()->setCellValue('B'.$j, $i);
$object->getActiveSheet()->getStyle('B'.$j.':H'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
$object->getActiveSheet()->setCellValue('C'.$j, $val['emp_id']);
$object->getActiveSheet()->setCellValue('D'.$j, $val['fname']." ".$val['lname']);
$object->getActiveSheet()->setCellValue('E'.$j, $val['gender']);
$object->getActiveSheet()->setCellValue('F'.$j, $school[0]['college_code']);
$object->getActiveSheet()->setCellValue('G'.$j, $department[0]['department_name']);
$object->getActiveSheet()->setCellValue('H'.$j, $val['tds_amount']);


$i++;
$j++;
	  }  
	  $objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('test_img');
$objDrawing->setDescription('test_img');
$objDrawing->setPath('assets/images/logo_exl.jpg');
$objDrawing->setCoordinates('B1');                      
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