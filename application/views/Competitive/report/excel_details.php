<?php
$academic_year=$fees[0]['academic_year'];
if($report_type=="2")
{
	$this->load->library("excel");
	$object = new PHPExcel();
	$object->setActiveSheetIndex(0);
	$object->getActiveSheet()->setCellValue('A1', 'Sandip Foundation-Nashik');
	$object->getActiveSheet()->setCellValue('A2', 'Competitive Exam Fees Details Student Wise');
	$object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	$object->getActiveSheet()->setCellValue('A4', 'S.No');
	$object->getActiveSheet()->setCellValue('B4', 'Reg No');
	$object->getActiveSheet()->setCellValue('C4', 'Student Name');
	$object->getActiveSheet()->setCellValue('D4','Gender');
	$object->getActiveSheet()->setCellValue('E4', 'Mobile');
	$object->getActiveSheet()->setCellValue('F4', 'Organization');
	$object->getActiveSheet()->setCellValue('G4', 'Entrance Type');
	$object->getActiveSheet()->setCellValue('H4', 'Applicable');
	$object->getActiveSheet()->setCellValue('I4', 'Paid Amount');
	$object->getActiveSheet()->setCellValue('J4', 'Pending');
	//merge cell A1 until C1

	$object->getActiveSheet()->mergeCells('A1:J1');
	$object->getActiveSheet()->mergeCells('A2:J2');
	$object->getActiveSheet()->mergeCells('A3:J3');
	//set aligment to center for that merged cell (A1 to C1)
	$object->getActiveSheet()->getStyle('A1:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   
	//make the font become bold

	$object->getActiveSheet()->getStyle('A1:J4')->getFont()->setBold(true);

	$object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);

	$object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

	for($col = ord('A'); $col <= ord('B'); $col++){ //set column dimension $object->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);

			 //change the font size

	$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
	$object->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	}

	//retrive contries table data

	$rowno=1;
	$x=5;
	$total=0;$pending_tot=0;
	foreach($fees as $row){
	$appl=((int)$row['applicable_fees']);

	$pend=$appl-$row['fees_paid'];
	
	$object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	$object->getActiveSheet()->setCellValue('B'.$x,$row['reg_no']);
	$object->getActiveSheet()->setCellValue('C'.$x,$row['student_name']);
	$object->getActiveSheet()->setCellValue('D'.$x,(($row['gender']=='M')?'Male':'Female'));
	$object->getActiveSheet()->setCellValue('E'.$x,$row['student_mobileno']);
	$object->getActiveSheet()->setCellValue('F'.$x,$row['student_org']);
	$object->getActiveSheet()->setCellValue('G'.$x, $row['entrance_type']);
	$object->getActiveSheet()->setCellValue('H'.$x, $appl);
	$object->getActiveSheet()->setCellValue('I'.$x, ((!empty($row['fees_paid']))?$row['fees_paid']:0));
	$object->getActiveSheet()->setCellValue('J'.$x, $pend);
	   $x++;
	  $total+= $row['fees_paid'];
	  $pending_tot+=$pend;
	  $rowno++;
	}
	
	 $object->getActiveSheet()->setCellValue('I'.$x,$total);
	// $object->getActiveSheet()->setCellValue('J'.$x,$pending_tot);
	$object->getActiveSheet()->setCellValue('A'.$x, 'Total');
	$object->getActiveSheet()->mergeCells('A'.$x.':H'.$x);
	
	$object->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	                
	$styleArray = array(
	'borders' => array(
	'allborders' => array(
	  'style' => PHPExcel_Style_Border::BORDER_THIN
	)
	)
	);

	foreach(range('A','J') as $columnID)
	{
	 $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	}

	$object->getActiveSheet()->getStyle('A1:J'.$x)->applyFromArray($styleArray);    
	                 
	$filename='Competitive Exam Fees Details Student Wise-'.$academic_year.'.xls'; //save our workbook as this file name
	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
	//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
	//if you want to save it as .XLSX Excel 2007 format

	$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	//force user to download the Excel file without writing it to server's HD

	$objWriter->save('php://output');
              
	   
exit();
}

else if($report_type=="4")
{
	$this->load->library("excel");
	$object = new PHPExcel();
	$object->setActiveSheetIndex(0);
	$object->getActiveSheet()->setCellValue('A1', 'Sandip Foundation-Nashik');
	$object->getActiveSheet()->setCellValue('A2', 'Competitive Exam Fees Out Standing Details');
	$object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	$object->getActiveSheet()->setCellValue('A4', 'S.No');
	$object->getActiveSheet()->setCellValue('B4', 'Reg No');
	$object->getActiveSheet()->setCellValue('C4', 'Student Name');
	$object->getActiveSheet()->setCellValue('D4','Gender');
	$object->getActiveSheet()->setCellValue('E4', 'Mobile');
	$object->getActiveSheet()->setCellValue('F4', 'Organization');
	$object->getActiveSheet()->setCellValue('G4', 'Entrance Type');
	$object->getActiveSheet()->setCellValue('H4', 'Applicable');
	$object->getActiveSheet()->setCellValue('I4', 'Paid Amount');
	$object->getActiveSheet()->setCellValue('J4', 'Pending');
	//merge cell A1 until C1

	$object->getActiveSheet()->mergeCells('A1:J1');
	$object->getActiveSheet()->mergeCells('A2:J2');
	$object->getActiveSheet()->mergeCells('A3:J3');
	//set aligment to center for that merged cell (A1 to C1)
	$object->getActiveSheet()->getStyle('A1:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   
	//make the font become bold

	$object->getActiveSheet()->getStyle('A1:J4')->getFont()->setBold(true);

	$object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);

	$object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

	for($col = ord('A'); $col <= ord('B'); $col++){ //set column dimension $object->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);

			 //change the font size

	$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
	$object->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	}

	//retrive contries table data

	$rowno=1;
	$x=5;
	$total=0;
	foreach($fees as $row){
	$appl=((int)$row['applicable_fees']);

	$pend=$appl-$row['fees_paid'];
	
	$object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	$object->getActiveSheet()->setCellValue('B'.$x,$row['reg_no']);
	$object->getActiveSheet()->setCellValue('C'.$x,$row['student_name']);
	$object->getActiveSheet()->setCellValue('D'.$x,(($row['gender']=='M')?'Male':'Female'));
	$object->getActiveSheet()->setCellValue('E'.$x,$row['student_mobileno']);
	$object->getActiveSheet()->setCellValue('F'.$x,$row['student_org']);
	$object->getActiveSheet()->setCellValue('G'.$x, $row['entrance_type']);
	$object->getActiveSheet()->setCellValue('H'.$x, $appl);
	$object->getActiveSheet()->setCellValue('I'.$x, ((!empty($row['fees_paid']))?$row['fees_paid']:0));
	$object->getActiveSheet()->setCellValue('J'.$x, $pend);
	   $x++;
	  $total+= $row['fees_paid'];
	  $pending_tot+=$pend;
	  $rowno++;
	}
	
	 $object->getActiveSheet()->setCellValue('I'.$x,$total);
	 $object->getActiveSheet()->setCellValue('J'.$x,$pending_tot);
	$object->getActiveSheet()->setCellValue('A'.$x, 'Total');
	$object->getActiveSheet()->mergeCells('A'.$x.':H'.$x);
	
	$object->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	                
	$styleArray = array(
	'borders' => array(
	'allborders' => array(
	  'style' => PHPExcel_Style_Border::BORDER_THIN
	)
	)
	);

	foreach(range('A','J') as $columnID)
	{
	 $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	}

	$object->getActiveSheet()->getStyle('A1:J'.$x)->applyFromArray($styleArray);    
	                 
	$filename='Competitive Exam Fees Details Student Wise-'.$academic_year.'.xls'; //save our workbook as this file name
	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
	//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
	//if you want to save it as .XLSX Excel 2007 format

	$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	//force user to download the Excel file without writing it to server's HD

	$objWriter->save('php://output');
              
	   
exit();
}

?>