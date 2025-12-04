<?php
	
$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);
$object->getActiveSheet()->setCellValue('A1', 'Sandip University -Nashik');
$object->getActiveSheet()->setCellValue('A2', 'OFFICE OF THE CONTROLLER OF EXAMINATIONS DAY WISE QP REQUIREMENT - '.$exam_sess[0]['exam_month'].' '.$exam_sess[0]['exam_year']);

$timestamp = strtotime($examdetails[0]['exam_date']);
$day = date('l', $timestamp);
$fromtime= explode(':', $examdetails[0]['from_time']);
$totime= explode(':', $examdetails[0]['to_time']);
$date_exam = date('d/m/Y', strtotime($examdetails[0]['date']));
		
$object->getActiveSheet()->setCellValue('A3', 'Date: '.$date_exam);
$object->getActiveSheet()->setCellValue('D3', 'Day: '.$day);
//$object->getActiveSheet()->setCellValue('C3', 'Time: '.$fromtime[0].':'.$fromtime[1].'-'.$totime[0].':'.$totime[1]);

		
		
$object->getActiveSheet()->setCellValue('A4', 'Sr.No');
$object->getActiveSheet()->setCellValue('B4', 'Name of the Programme');
$object->getActiveSheet()->setCellValue('C4', 'Course');
$object->getActiveSheet()->setCellValue('D4', 'Course Code');
$object->getActiveSheet()->setCellValue('E4', 'Sem');
$object->getActiveSheet()->setCellValue('F4', 'Strength');
$object->getActiveSheet()->setCellValue('G4', 'QP Count');
$object->getActiveSheet()->setCellValue('H4', 'Remark');$object->getActiveSheet()->setCellValue('I4', 'Time');
		

//merge cell A1 until C1

$object->getActiveSheet()->mergeCells('A1:I1');
$object->getActiveSheet()->mergeCells('A2:I2');
$object->getActiveSheet()->mergeCells('D3:I3');
$object->getActiveSheet()->mergeCells('A3:B3');
//set aligment to center for that merged cell (A1 to C1)
$object->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$object->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//make the font become bold
		
$object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
$object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

for($col = ord('A'); $col <= ord('N'); $col++){ //set column dimension 
	$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
	if($col=='B' || $col=='C'){
	
	}else{
		$object->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
	}
			
}
		
//retrive contries table data

$rowno=1;
$x=5;
		 
foreach($examdetails as $row){
$from_time= explode(':', $row['from_time']);$to_time= explode(':', $row['to_time']);	$slot = $from_time[0].':'.$from_time[1].'-'.$to_time[0].':'.$to_time[1];
	$object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	$object->getActiveSheet()->setCellValue('B'.$x, $row['stream_short_name']);
	$object->getActiveSheet()->setCellValue('C'.$x,$row['subject_name']);
	$object->getActiveSheet()->setCellValue('D'.$x,$row['subject_code']);
	$object->getActiveSheet()->setCellValue('E'.$x, $row['semester']);
	$object->getActiveSheet()->setCellValue('F'.$x, $row['TOT']);
	$object->getActiveSheet()->setCellValue('G'.$x, '');
	$object->getActiveSheet()->setCellValue('H'.$x, '');	$object->getActiveSheet()->setCellValue('I'.$x, $slot);

	$x++;
$arr[] = $row['TOT'];

}
$object->getActiveSheet()->mergeCells('A'.$x.':E'.$x);
$object->getActiveSheet()->setCellValue('A'.$x,'TOTAL');
$object->getActiveSheet()->setCellValue('F'.$x, array_sum($arr));

for($k=0; $k<$x+1; $k++){
	$object->getActiveSheet()->getStyle("A".$k.":I".$k)->applyFromArray(
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
foreach(range('A','H') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
$filename= 'DaywiseQp.xls'; //save our workbook as this file name

header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache


//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

//if you want to save it as .XLSX Excel 2007 format

$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

//force user to download the Excel file without writing it to server's HD

$objWriter->save('php://output');
  



?>