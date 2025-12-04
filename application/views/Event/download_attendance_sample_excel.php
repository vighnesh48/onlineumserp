<?php

$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);
$object->getActiveSheet()->setCellValue('A1', 'Sandip University -Nashik');
$object->getActiveSheet()->setCellValue('A2', 'Upload Event Attendance');
$object->getActiveSheet()->setCellValue('A3', 'Ensure Correct Enrollment Number');
$object->getActiveSheet()->setCellValue('A4', 'S.No.');
$object->getActiveSheet()->setCellValue('B4', 'Enrollment No');


//merge cell A1 until C1

$object->getActiveSheet()->mergeCells('A1:O1');
$object->getActiveSheet()->mergeCells('A2:O2');
$object->getActiveSheet()->mergeCells('A3:O3');
//set aligment to center for that merged cell (A1 to C1)
$object->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//make the font become bold

$object->getActiveSheet()->getStyle('A1:O4')->getFont()->setBold(true);
$object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
$object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
for ($col = ord('A'); $col <= ord('B'); $col++) { //set column dimension $object->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
	//change the font size
	$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
	$object->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
}
//retrive contries table data

$object->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$object->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$object->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$filename = 'Event-Attendance-Sheet.xls'; //save our workbook as this file name

header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache


//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

//if you want to save it as .XLSX Excel 2007 format

$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');

//force user to download the Excel file without writing it to server's HD

$objWriter->save('php://output');
