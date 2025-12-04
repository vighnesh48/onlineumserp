<?php
//print_r($exam_session);exit;

$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);
/* <option value="SU">Sandip University</option>
					  <option value="SF">Sandip Foundation</option>
				  <option value="SF-SIJOUL">Sandip Foundation Sijoul</option> */
$org=$boardingfee_details[0]['campus'].' Campus';

$object->getActiveSheet()->setCellValue('A1', 'Sandip University '.$org);
$object->getActiveSheet()->setCellValue('A2', 'Transport Fees - '.$boardingfee_details[0]['academic_year']);	

$object->getActiveSheet()->setCellValue('A3', 'Sr.No');
$object->getActiveSheet()->setCellValue('B3', 'Boarding Point');
$object->getActiveSheet()->setCellValue('C3', 'Transport Fees');
		

//merge cell A1 until C1

$object->getActiveSheet()->mergeCells('A1:C1');
$object->getActiveSheet()->mergeCells('A2:C2');

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

for($col = ord('A'); $col <= ord('C'); $col++){ //set column dimension 
	$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize();

			
}
		
//retrive contries table data

$rowno=1;
$x=4;
for($i=0;$i<count($boardingfee_details);$i++){		 

	$object->getActiveSheet()->setCellValue('A'.$x,($x-3));
	$object->getActiveSheet()->setCellValue('B'.$x, $boardingfee_details[$i]['boarding_point']);
	$object->getActiveSheet()->setCellValue('C'.$x, $boardingfee_details[$i]['fees']);
	$x++;


}


for($k=0; $k<$x; $k++){
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
$filename= $boardingfee_details[0]['academic_year'].'boarding_fees.xls'; //save our workbook as this file name

header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache


//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

//if you want to save it as .XLSX Excel 2007 format

$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

//force user to download the Excel file without writing it to server's HD

$objWriter->save('php://output');
  



?>