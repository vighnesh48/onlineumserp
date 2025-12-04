<?php
//print_r($exam_session);exit;

$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);

$object->getActiveSheet()->setCellValue('A1', 'Sandip Foundation');
$object->getActiveSheet()->setCellValue('A2', 'Bus Trip Details');	

$object->getActiveSheet()->setCellValue('A3', 'Sr.No');
$object->getActiveSheet()->setCellValue('B3', 'Bus Number');
$object->getActiveSheet()->setCellValue('C3', 'Route Name');
$object->getActiveSheet()->setCellValue('D3', 'Date');

if($route=='summary')
{
	$object->getActiveSheet()->setCellValue('E3', 'No. Of Trips');
	$object->getActiveSheet()->mergeCells('A1:E1');
	$object->getActiveSheet()->mergeCells('A2:E2');
}
else
{
	$object->getActiveSheet()->setCellValue('E3', 'Time');
	$object->getActiveSheet()->setCellValue('F3', 'Status');
	
	$object->getActiveSheet()->mergeCells('A1:F1');
	$object->getActiveSheet()->mergeCells('A2:F2');
}


//set aligment to center for that merged cell (A1 to C1)
$object->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$object->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//make the font become bold
		
$object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
$object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
$object->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
$object->getActiveSheet()->getStyle('A2')->getFont()->setSize(16);
$object->getActiveSheet()->getStyle('A2')->getFill()->getStartColor()->setARGB('#333');


if($route=='summary')
{
	for($col = ord('A'); $col <= ord('E'); $col++){ //set column dimension 
		$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize();		
	}
}
else
{
	for($col = ord('A'); $col <= ord('F'); $col++){ //set column dimension 
	$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize();		
	}
}
		
//retrive contries table data

$rowno=1;
$x=4;
for($i=0;$i<count($trip_details);$i++){		 
	$object->getActiveSheet()->setCellValue('A'.$x,($x-3));
	$object->getActiveSheet()->setCellValue('B'.$x, $trip_details[$i]['bus_no']);
	$object->getActiveSheet()->setCellValue('C'.$x, $trip_details[$i]['route_name']);
	$object->getActiveSheet()->setCellValue('D'.$x, $trip_details[$i]['trip_date']);
	if($route=='summary')
	{
		$object->getActiveSheet()->setCellValue('E'.$x, floor($trip_details[$i]['trip_count']/2));
	}
else 
	{
		$object->getActiveSheet()->setCellValue('E'.$x, $trip_details[$i]['trip_time']);
		$object->getActiveSheet()->setCellValue('F'.$x, $trip_details[$i]['status']);
	}
	$x++;
}
$filename='';
if($route=='summary')
	{
		$filename= 'Bus_Trip_details.xls'; //save our workbook as this file name
		for($k=0; $k<$x; $k++){
			$object->getActiveSheet()->getStyle("A".$k.":E".$k)->applyFromArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
							'color' => array('rgb' => 'red')
						)
					)
				)
			);
		}
		foreach(range('A','E') as $columnID)
		{
			 $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
	}
	else
	{
		$filename= 'Bus_Trip_summary_details.xls'; //save our workbook as this file name
				for($k=0; $k<$x; $k++){
			$object->getActiveSheet()->getStyle("A".$k.":F".$k)->applyFromArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
							'color' => array('rgb' => 'red')
						)
					)
				)
			);
		}
		foreach(range('A','F') as $columnID)
		{
			 $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

	}
	
	


header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache


//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

//if you want to save it as .XLSX Excel 2007 format

$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

//force user to download the Excel file without writing it to server's HD

$objWriter->save('php://output');
  



?>