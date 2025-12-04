<?php
	$this->load->library("excel");
	$object = new PHPExcel();
	$object->setActiveSheetIndex(0);
	$object->getActiveSheet()->setCellValue('A1', 'Floor wise empty beds list of '.$emptybeddetail[0]['hostel_code']);
	
	$object->getActiveSheet()->setCellValue('A2', 'S.No');
	$object->getActiveSheet()->setCellValue('B2', 'Hostel');
	$object->getActiveSheet()->setCellValue('C2', '#Floor');
	$object->getActiveSheet()->setCellValue('D2','#Room');
	$object->getActiveSheet()->setCellValue('E2', '#Bed Available');


	//merge cell A1 until C1

	$object->getActiveSheet()->mergeCells('A1:E1');
	
	//set aligment to center for that merged cell (A1 to C1)
	$object->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   
	//make the font become bold

	$object->getActiveSheet()->getStyle('A1:E2')->getFont()->setBold(true);

	$object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);

	$object->getActiveSheet()->getStyle('A2')->getFill()->getStartColor()->setARGB('#333');

	for($col = ord('A'); $col <= ord('B'); $col++){ //set column dimension $object->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);

			 //change the font size

			$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
			$object->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				  

	}

	//retrive contries table data

	$rowno=1;
	$x=3;
	$total=0; 
	foreach($emptybeddetail as $row){
		if($row['floor_no']==0)
		$floor="Ground";
	else
		$floor=$row['floor_no'];
	$object->getActiveSheet()->setCellValue('A'.$x,($x-2));
	$object->getActiveSheet()->setCellValue('B'.$x,$row['hostel_code']);
	$object->getActiveSheet()->setCellValue('C'.$x,$floor);
	$object->getActiveSheet()->setCellValue('D'.$x,$row['room_no']);
	$object->getActiveSheet()->setCellValue('E'.$x, $row['beds_available']);

	  $x++;
	  $total+= $row['beds_available'];
	  $rowno++;
	}
	$object->getActiveSheet()->setCellValue('A'.$x, 'Total');
    $object->getActiveSheet()->setCellValue('E'.$x,$total);
	$object->getActiveSheet()->mergeCells('A'.$x.':D'.$x);
	$object->getActiveSheet()->getStyle('A'.$x.':E'.$x)->getFont()->setBold(true);
	
	
	$object->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	                
	$styleArray = array(
	  'borders' => array(
		'allborders' => array(
		  'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	  )
	);


	foreach(range('A','E') as $columnID)
	{
		 $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	}


	$object->getActiveSheet()->getStyle('A1:E'.$x)->applyFromArray($styleArray);    
	                  

	$filename='Floor_wise_empty_beds-'.$emptybeddetail[0]['hostel_code'].'.xls'; //save our workbook as this file name

	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache


	//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	//if you want to save it as .XLSX Excel 2007 format

	$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	//force user to download the Excel file without writing it to server's HD

	$objWriter->save('php://output');
     
	exit();  


?>