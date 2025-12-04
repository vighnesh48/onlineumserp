<?php
//print_r($exam_session);exit;
$examSes = $exam_session;
$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);
$object->getActiveSheet()->setCellValue('A1', 'Sandip University -Nashik');
$object->getActiveSheet()->setCellValue('A2', 'Exam Applied Student Count - '.$examSes);	
$object->getActiveSheet()->setCellValue('A3', 'Sr.No');
$object->getActiveSheet()->setCellValue('B3', 'School name');
$object->getActiveSheet()->setCellValue('C3', 'Stream Name');
$object->getActiveSheet()->setCellValue('D3', 'Semester');
$object->getActiveSheet()->setCellValue('E3', 'Exam Applied Count');


		

//merge cell A1 until C1

$object->getActiveSheet()->mergeCells('A1:E1');
$object->getActiveSheet()->mergeCells('A2:E2');

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

for($col = ord('A'); $col <= ord('E'); $col++){ //set column dimension 
	$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

			
}
		
//retrive contries table data

$rowno=1;
$x=4;

for($i=0;$i<count($summary_list);$i++){		 
	
	$object->getActiveSheet()->setCellValue('A'.$x,($x-3));
	$object->getActiveSheet()->setCellValue('B'.$x, ' '.$summary_list[$i]['school_short_name']);
	$object->getActiveSheet()->setCellValue('C'.$x, $summary_list[$i]['stream_short_name']);
	$object->getActiveSheet()->setCellValue('D'.$x, $summary_list[$i]['semester']);
	$object->getActiveSheet()->setCellValue('E'.$x, $summary_list[$i]['cnt']);
	$total[] = $summary_list[$i]['cnt'];
	$x++;
}

$object->getActiveSheet()->mergeCells('A'.$x.':D'.$x);
$object->getActiveSheet()->setCellValue('A'.$x,'TOTAL');
$object->getActiveSheet()->setCellValue('E'.$x, array_sum($total));

for($k=0; $k<$x+1; $k++){
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
$filename= 'Exam_Summary_list.xls'; //save our workbook as this file name

header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache


//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

//if you want to save it as .XLSX Excel 2007 format

$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

//force user to download the Excel file without writing it to server's HD

$objWriter->save('php://output');
  



?>