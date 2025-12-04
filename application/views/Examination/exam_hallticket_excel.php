<?php
	
$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);
$object->getActiveSheet()->setCellValue('A1', 'Sandip University -Nashik');
$object->getActiveSheet()->setCellValue('A2', 'OFFICE OF THE CONTROLLER OF EXAMINATIONS HALLTICKET - '.$exam_session[0]['exam_month'].' '.$exam_session[0]['exam_year']);

$timestamp = strtotime($examdetails[0]['exam_date']);
$day = date('l', $timestamp);
$fromtime= explode(':', $examdetails[0]['from_time']);
$totime= explode(':', $examdetails[0]['to_time']);
$date_exam = date('d/m/Y', strtotime($examdetails[0]['date']));
		
//$object->getActiveSheet()->setCellValue('A3', 'Date: '.$date_exam);
//$object->getActiveSheet()->setCellValue('D3', 'Day: '.$day);
//$object->getActiveSheet()->setCellValue('C3', 'Time: '.$fromtime[0].':'.$fromtime[1].'-'.$totime[0].':'.$totime[1]);

		
		
$object->getActiveSheet()->setCellValue('A4', 'Sr.No');
$object->getActiveSheet()->setCellValue('B4', 'Name');
$object->getActiveSheet()->setCellValue('C4', 'Semester');
$object->getActiveSheet()->setCellValue('D4', 'Course Code');
$object->getActiveSheet()->setCellValue('E4', 'Course Name');
$object->getActiveSheet()->setCellValue('F4', 'School');
$object->getActiveSheet()->setCellValue('G4', 'Course');
$object->getActiveSheet()->setCellValue('H4', 'Stream');
$object->getActiveSheet()->setCellValue('I4', 'Date');
$object->getActiveSheet()->setCellValue('J4', 'Time');
		

//merge cell A1 until C1

$object->getActiveSheet()->mergeCells('A1:J1');
$object->getActiveSheet()->mergeCells('A2:J2');
$object->getActiveSheet()->mergeCells('D3:J3');
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
for($i=0;$i<count($emp_list);$i++){		 
$subjects = $emp_list[$i]['sublist'];
$sname = $emp_list[$i]['stud_name'];
$fromtime= $emp_list[$i]['from_time'];
$totime= $emp_list[$i]['to_time'];
	$ex_time = $fromtime.'-'.$totime;	
	$object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	$object->getActiveSheet()->setCellValue('B'.$x, $sname);
	$object->getActiveSheet()->setCellValue('C'.$x, $emp_list[$i]['semester']);
	$object->getActiveSheet()->setCellValue('D'.$x, $emp_list[$i]['subject_code']);
	$object->getActiveSheet()->setCellValue('E'.$x, $emp_list[$i]['subject_name']);
	$object->getActiveSheet()->setCellValue('F'.$x, $emp_list[$i]['school_short_name']);
	$object->getActiveSheet()->setCellValue('G'.$x, $emp_list[$i]['course_short_name']);
	$object->getActiveSheet()->setCellValue('H'.$x, $emp_list[$i]['stream_short_name']);
	$object->getActiveSheet()->setCellValue('I'.$x, $emp_list[$i]['date']);
	$object->getActiveSheet()->setCellValue('J'.$x, $ex_time);

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