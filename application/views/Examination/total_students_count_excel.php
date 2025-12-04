<?php
//print_r($exam_session);exit;
ob_end_clean(); // Clear any output buffering
ini_set('display_errors', 0); // Disable error output
error_reporting(0);

$examSes = $exam_session;
$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);
$object->getActiveSheet()->setCellValue('A1', 'Sandip University -Nashik');
$object->getActiveSheet()->setCellValue('A2', 'Total Student Count - '.$examSes);	
$object->getActiveSheet()->setCellValue('A3', 'Sr.No');
$object->getActiveSheet()->setCellValue('B3', 'School name');
$object->getActiveSheet()->setCellValue('C3', 'Stream Name');
$object->getActiveSheet()->setCellValue('D3', 'Semester');
$object->getActiveSheet()->setCellValue('E3', 'Total students');
$object->getActiveSheet()->setCellValue('F3', 'Exam Applied Count');
$object->getActiveSheet()->setCellValue('G3', 'Pending Count');

		

//merge cell A1 until C1

$object->getActiveSheet()->mergeCells('A1:G1');
$object->getActiveSheet()->mergeCells('A2:G2');

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

for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension 
	$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

			
}
		
//retrive contries table data

$rowno=1;
$x=4;

for($i=0;$i<count($summary_list);$i++){		 
	
	$object->getActiveSheet()->setCellValue('A'.$x,($x-3));
	$object->getActiveSheet()->setCellValue('B'.$x, ' '.$summary_list[$i]['school_short_name']);
	$object->getActiveSheet()->setCellValue('C'.$x, $summary_list[$i]['stream_name']);
	$object->getActiveSheet()->setCellValue('D'.$x, $summary_list[$i]['current_semester']);
	$object->getActiveSheet()->setCellValue('E'.$x, $summary_list[$i]['total_students']);
	$object->getActiveSheet()->setCellValue('F'.$x, $summary_list[$i]['applied']);
	$object->getActiveSheet()->setCellValue('G'.$x, ($summary_list[$i]['total_students']-$summary_list[$i]['applied']));
	$total[] = $summary_list[$i]['total_students'];
	$applied[] = $summary_list[$i]['applied'];
	$pending[] = ($summary_list[$i]['total_students']-$summary_list[$i]['applied']);
	$x++;
}

$object->getActiveSheet()->mergeCells('A'.$x.':D'.$x);
$object->getActiveSheet()->setCellValue('A'.$x,'TOTAL');
$object->getActiveSheet()->setCellValue('E'.$x, array_sum($total));
$object->getActiveSheet()->setCellValue('F'.$x, array_sum($applied));
$object->getActiveSheet()->setCellValue('G'.$x, array_sum($pending));

for($k=0; $k<$x+1; $k++){
	$object->getActiveSheet()->getStyle("A".$k.":G".$k)->applyFromArray(
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
foreach(range('A','G') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
$filename = 'Exam_Summary_list.xls';

// Required headers
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Save output
$writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
$writer->save('php://output');
exit;
  



?>