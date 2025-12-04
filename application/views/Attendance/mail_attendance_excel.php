<?php
	
$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);
$object->getActiveSheet()->setCellValue('A1', 'Sandip University -Nashik');
$object->getActiveSheet()->setCellValue('A2', 'Daily Attendence Report');


$todysdate = date('d/m/Y', strtotime($todaysdate));
foreach($stream as $value){		
$stream_id = $value['stream_id'];
$stream_name = $value['stream_name'];
$division = $value['division'];
$semester = $value['semester'];

$object->getActiveSheet()->setCellValue('A3', 'Date: '.$todysdate);
$object->getActiveSheet()->setCellValue('D3', 'Day: '.$day);
$object->getActiveSheet()->setCellValue('C3', 'Stream'.$stream_name);

		
		
$object->getActiveSheet()->setCellValue('A4', 'Sr.No');
$object->getActiveSheet()->setCellValue('B4', 'School Name');
$object->getActiveSheet()->setCellValue('C4', 'Class');
$object->getActiveSheet()->setCellValue('D4', 'Semester');
$object->getActiveSheet()->setCellValue('E4', 'Division');
$object->getActiveSheet()->setCellValue('F4', 'Subject Name');
$object->getActiveSheet()->setCellValue('G4', 'Type');
$object->getActiveSheet()->setCellValue('H4', 'Slot');
$object->getActiveSheet()->setCellValue('I4', 'Faculty Name');
$object->getActiveSheet()->setCellValue('J4', 'Present');
$object->getActiveSheet()->setCellValue('K4', 'Absent');
$object->getActiveSheet()->setCellValue('L4', 'Total');

		

//merge cell A1 until C1

$object->getActiveSheet()->mergeCells('A1:L1');
$object->getActiveSheet()->mergeCells('A2:L2');
$object->getActiveSheet()->mergeCells('D3:L3');
$object->getActiveSheet()->mergeCells('A3:L3');
//set aligment to center for that merged cell (A1 to C1)
$object->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$object->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//make the font become bold
		
$object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
$object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

for($col = ord('A'); $col <= ord('L'); $col++){ //set column dimension 
	$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
	if($col=='B' || $col=='C'){
	
	}else{
		$object->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
	}
			
}
		
//retrive contries table data

$rowno=1;
$x=5;
foreach ($value['mdata'] as $mld) {
					$subject_name = $mld['subject_name'];
					$sub_code = $mld['sub_code'];
					$subject_type = $mld['subject_type'];
					$slot = $mld['from_time'].'-'.$mld['to_time'].' '.$mld['slot_am_pm'];
					$facname = strtoupper($mld['fname'][0].'. '.$mld['mname'][0].'. '.$mld['lname']);;
					$att_percentage = number_format($mld['att_percentage'], 2, '.', '');
					$tot_students = $mld['tot_students'];
					$totPersent = $mld['totPersent'];
					$totAbsent=$tot_students - $totPersent;
	$object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	$object->getActiveSheet()->setCellValue('B'.$x, $mld['school_name']);
	$object->getActiveSheet()->setCellValue('C'.$x, $mld['stream_name']);
	$object->getActiveSheet()->setCellValue('D'.$x, $semester);
	$object->getActiveSheet()->setCellValue('E'.$x, $division);
	$object->getActiveSheet()->setCellValue('F'.$x, $subject_name);
	$object->getActiveSheet()->setCellValue('G'.$x, $subject_type);
	$object->getActiveSheet()->setCellValue('H'.$x, $slot);
	$object->getActiveSheet()->setCellValue('I'.$x, $facname);
	$object->getActiveSheet()->setCellValue('J'.$x, $totPersent);
	$object->getActiveSheet()->setCellValue('K'.$x, $totAbsent);
	$object->getActiveSheet()->setCellValue('L'.$x, $tot_students);

	$x++;


}


for($k=0; $k<$x+1; $k++){
	$object->getActiveSheet()->getStyle("A".$k.":J".$k)->applyFromArray(
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
foreach(range('A','J') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
}
$filename= 'Hallticket.xls'; //save our workbook as this file name

header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache


//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

//if you want to save it as .XLSX Excel 2007 format

$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

//force user to download the Excel file without writing it to server's HD

$objWriter->save('php://output');
  



?>