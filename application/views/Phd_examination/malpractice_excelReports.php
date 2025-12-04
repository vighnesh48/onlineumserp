<?php
//print_r($exam_session);exit;

$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);
$object->getActiveSheet()->setCellValue('A1', 'Sandip University -Nashik');
$object->getActiveSheet()->setCellValue('A2', 'MALPRACTICE LIST - '.$exam_session);	
$object->getActiveSheet()->setCellValue('A3', 'Sr.No');
$object->getActiveSheet()->setCellValue('B3', 'PRN');
$object->getActiveSheet()->setCellValue('C3', 'Name');
$object->getActiveSheet()->setCellValue('D3', 'Subject');
$object->getActiveSheet()->setCellValue('E3', 'Stream');
$object->getActiveSheet()->setCellValue('F3', 'Semester');
$object->getActiveSheet()->setCellValue('G3', 'Date');
$object->getActiveSheet()->setCellValue('H3', 'Session');
$object->getActiveSheet()->setCellValue('I3', 'Remark');

		

//merge cell A1 until C1

$object->getActiveSheet()->mergeCells('A1:I1');
$object->getActiveSheet()->mergeCells('A2:I2');

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

for($col = ord('A'); $col <= ord('I'); $col++){ //set column dimension 
	$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

			
}
		
//retrive contries table data

$rowno=1;
$x=4;
for($i=0;$i<count($malpractice_list);$i++){		 

    $sname = $malpractice_list[$i]['first_name']." ".$malpractice_list[$i]['middle_name']." ".$malpractice_list[$i]['last_name'];
	$mpractice_date = date('d-m-Y', strtotime($malpractice_list[$i]['date']));
	$frmtime = explode(':' ,$malpractice_list[$i]['from_time']); $to_time = explode(':', $malpractice_list[$i]['to_time']);
	$ex_ses = $frmtime[0].':'.$frmtime[1].'-'.$to_time[0].':'.$to_time[1];
	//$ex_ses = $malpractice_list[$i]['from_time'].'-'.$malpractice_list[$i]['to_time'];

	$object->getActiveSheet()->setCellValue('A'.$x,($x-3));
	$object->getActiveSheet()->setCellValue('B'.$x, ' '.$malpractice_list[$i]['enrollment_no']);
	$object->getActiveSheet()->setCellValue('C'.$x, $sname);
	$object->getActiveSheet()->setCellValue('D'.$x, $malpractice_list[$i]['subject_code'].'-'.$malpractice_list[$i]['subject_name']);
	$object->getActiveSheet()->setCellValue('E'.$x, $malpractice_list[$i]['stream_short_name']);
	$object->getActiveSheet()->setCellValue('F'.$x, $malpractice_list[$i]['semester']);
	$object->getActiveSheet()->setCellValue('G'.$x, $mpractice_date);
	$object->getActiveSheet()->setCellValue('H'.$x, $ex_ses);
	$object->getActiveSheet()->setCellValue('I'.$x, $malpractice_list[$i]['remark']);


	$x++;


}


for($k=0; $k<$x; $k++){
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
foreach(range('A','I') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
$filename= 'MalPractice_list.xls'; //save our workbook as this file name

header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache


//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

//if you want to save it as .XLSX Excel 2007 format

$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

//force user to download the Excel file without writing it to server's HD

$objWriter->save('php://output');
  



?>