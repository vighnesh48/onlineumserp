<?php
//print_r($exam_session);exit;

$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);
/* <option value="SU">Sandip University</option>
					  <option value="SF">Sandip Foundation</option>
				  <option value="SF-SIJOUL">Sandip Foundation Sijoul</option> */
$org=$student_details[0]['organisation'];
if($org=='SU')
$org='Sandip University';
else if($org=='SF')
	$org='Sandip Foundation';
else if($org=='SF-SIJOUL')
	$org='Sandip Foundation Sijoul';
else
	$org='For All Campus';

$object->getActiveSheet()->setCellValue('A1', $org);
$object->getActiveSheet()->setCellValue('A2', 'Transport List for the Academic Year -'.$student_details[0]['academic_year']);	

$object->getActiveSheet()->setCellValue('A3', 'Sr.No');
$object->getActiveSheet()->setCellValue('B3', 'Student PRN');
$object->getActiveSheet()->setCellValue('C3', 'Student ID');
$object->getActiveSheet()->setCellValue('D3', 'Name');
$object->getActiveSheet()->setCellValue('E3', 'Gender');
$object->getActiveSheet()->setCellValue('F3', 'Campus');
$object->getActiveSheet()->setCellValue('G3', 'Year');
$object->getActiveSheet()->setCellValue('H3', 'Course');
$object->getActiveSheet()->setCellValue('I3', 'School');
$object->getActiveSheet()->setCellValue('J3', 'Mobile');
$object->getActiveSheet()->setCellValue('K3', 'Boarding Point'); 
$object->getActiveSheet()->setCellValue('L3', 'Transport Fee');
$object->getActiveSheet()->setCellValue('M3', 'Applicable');
$object->getActiveSheet()->setCellValue('N3', 'Paid'); 
$object->getActiveSheet()->setCellValue('O3', 'Remaining');
		

//merge cell A1 until C1

$object->getActiveSheet()->mergeCells('A1:O1');
$object->getActiveSheet()->mergeCells('A2:O2');

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

for($col = ord('A'); $col <= ord('O'); $col++){ //set column dimension 
	$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize();

			
}
		
//retrive contries table data

$rowno=1;
$x=4;
for($i=0;$i<count($student_details);$i++){		 
	$applicable='';
	$remaining='';
	
    $sname = $student_details[$i]['first_name'].' '.$student_details[$i]['middle_name'].' '.$student_details[$i]['last_name'];

	$object->getActiveSheet()->setCellValue('A'.$x,($x-3));
	$object->getActiveSheet()->setCellValue('B'.$x, ' '.$student_details[$i]['enrollment_no']);
	$object->getActiveSheet()->setCellValue('C'.$x, $student_details[$i]['student_id']);
	$object->getActiveSheet()->setCellValue('D'.$x, ' '.$sname);
	$object->getActiveSheet()->setCellValue('E'.$x, $student_details[$i]['gender']=='M'?'Male':'Female');
	$object->getActiveSheet()->setCellValue('F'.$x, $student_details[$i]['campus']);
	$object->getActiveSheet()->setCellValue('G'.$x, $student_details[$i]['current_year']);
	$object->getActiveSheet()->setCellValue('H'.$x, $student_details[$i]['stream_name']);
	$object->getActiveSheet()->setCellValue('I'.$x, $student_details[$i]['school_name']);
	$object->getActiveSheet()->setCellValue('J'.$x, $student_details[$i]['mobile']);
	$object->getActiveSheet()->setCellValue('K'.$x, $student_details[$i]['boarding_point']);
	$object->getActiveSheet()->setCellValue('L'.$x, $student_details[$i]['actual_fees']);
	
	$applicable=($student_details[$i]['deposit_fees']+$student_details[$i]['actual_fees']+$student_details[$i]['fine_fees'])-$student_details[$i]['excemption_fees'];
	
	$object->getActiveSheet()->setCellValue('M'.$x, $applicable);
	
	$object->getActiveSheet()->setCellValue('N'.$x, $student_details[$i]['paid_amt']); 
	$remaining=$applicable-$student_details[$i]['paid_amt'];
	
	$object->getActiveSheet()->setCellValue('O'.$x, $remaining); 
	//$object->getActiveSheet()->setCellValue('R'.$x, $student_details[$i]['scholorship_allowed']);

	$x++;
}


for($k=0; $k<$x; $k++){
	$object->getActiveSheet()->getStyle("A".$k.":O".$k)->applyFromArray(
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
foreach(range('A','O') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
$filename= 'Transport_student_details.xls'; //save our workbook as this file name

header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache


//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

//if you want to save it as .XLSX Excel 2007 format

$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

//force user to download the Excel file without writing it to server's HD

$objWriter->save('php://output');
  



?>