<?php
	
$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);
$object->getActiveSheet()->setCellValue('A1', 'Sandip University -Nashik');
$object->getActiveSheet()->setCellValue('A2', 'OFFICE OF THE CONTROLLER OF EXAMINATIONS SEATING ARRANGEMENT - '.$exam_session[0]['exam_month'].' '.$exam_session[0]['exam_year']);

$timestamp = strtotime($examdetails[0]['exam_date']);
$day = date('l', $timestamp);
$frmtime = explode(':', $sublist[0]['from_time']);
$totime = explode(':', $sublist[0]['to_time']);
$slot_time=$frmtime[0].':'.$frmtime[1].'-'.$totime[0].':'.$totime[1];
		
$object->getActiveSheet()->setCellValue('A3', 'School: '.$sublist[0]['school_short_name']);

$object->getActiveSheet()->setCellValue('B3', 'Stream: '.$sublist[0]['stream_name'].', Semester: '.$sublist[0]['semester']);

$object->getActiveSheet()->setCellValue('C3', 'Time: '.$slot_time);		

//merge cell A1 until C1

$object->getActiveSheet()->mergeCells('A1:C1');
$object->getActiveSheet()->mergeCells('A2:C2');
//$object->getActiveSheet()->mergeCells('D3:G3');
//$object->getActiveSheet()->mergeCells('A3:B3');
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
for($i=0;$i<count($sublist);$i++){
	
$sublist[$i]['subject_code'];
$studlist = $sublist[$i]['studlist'];
$frmtime = explode(':', $sublist[$i]['from_time']);
$totime = explode(':', $sublist[$i]['to_time']);
$slot_time=$frmtime[0].':'.$frmtime[1].'-'.$totime[0].':'.$totime[1];
if($sublist[$i]['date'] !='0000-00-00' && $sublist[$i]['date'] !=''){
	$exdate= date('d/m/Y', strtotime($sublist[$i]['date']));
}
$object->getActiveSheet()->setCellValue('A'.$x, 'Course Code: '.$sublist[$i]['subject_code']);
$object->getActiveSheet()->setCellValue('B'.$x, 'Course Name: '.$sublist[$i]['subject_name']);
$object->getActiveSheet()->setCellValue('C'.$x, 'Date: '.$exdate);
/*$object->getActiveSheet()->setCellValue('C'.$x, 'School Name: '.$sublist[$i]['school_short_name']);	
$object->getActiveSheet()->setCellValue('E'.$x, 'Time: '.$slot_time);
$object->getActiveSheet()->setCellValue('F'.$x, 'Stream: '.$sublist[$i]['stream_name']);
$object->getActiveSheet()->setCellValue('G'.$x, 'Semester: '.$sublist[$i]['semester']);*/

	if(!empty($studlist)){
		$x=$x+1;
		$object->getActiveSheet()->setCellValue('A'.$x, 'PRN: ');
		
		 foreach($studlist as $stud){
			 $object->getActiveSheet()->setCellValue('A'.$x, '`'.$stud['enrollment_no']);
			 $object->getActiveSheet()->setCellValue('B'.$x, $stud['stud_name']);
			 $x++;
		 }
	}
	$x++;
}

for($k=0; $k<$x+1; $k++){
	$object->getActiveSheet()->getStyle("A".$k.":C".$k)->applyFromArray(
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
foreach(range('A','C') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
$filename= $sublist[0]['stream_name'].'_'.$sublist[0]['semester'].'_'.$exam_session[0]['exam_month'].'-'.$exam_session[0]['exam_year'].'_seating.xls'; //save our workbook as this file name

// Required headers
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Save output
$writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
$writer->save('php://output');
exit;
  



?>