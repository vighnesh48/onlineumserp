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
$object->getActiveSheet()->setCellValue('A2', 'Hostel Student Details for the academic year -'.$student_details[0]['academic_year']);	

$object->getActiveSheet()->setCellValue('A3', 'Sr.No');
$object->getActiveSheet()->setCellValue('B3', 'Student PRN');
$object->getActiveSheet()->setCellValue('C3', 'Punching PRN');
$object->getActiveSheet()->setCellValue('D3', 'Name');
$object->getActiveSheet()->setCellValue('E3', 'Gender');
$object->getActiveSheet()->setCellValue('F3', 'Current Year');
$object->getActiveSheet()->setCellValue('G3', 'Course');
$object->getActiveSheet()->setCellValue('H3', 'School');
$object->getActiveSheet()->setCellValue('I3', 'Mobile');
$object->getActiveSheet()->setCellValue('J3', 'Hostel');
$object->getActiveSheet()->setCellValue('K3', 'Floor#');
$object->getActiveSheet()->setCellValue('L3', 'Room#'); 
$object->getActiveSheet()->setCellValue('M3', 'Deposit Fee');
$object->getActiveSheet()->setCellValue('N3', 'Actual Fee');
$object->getActiveSheet()->setCellValue('O3', 'Applicable');
$object->getActiveSheet()->setCellValue('P3', 'Opening Balance'); 
$object->getActiveSheet()->setCellValue('Q3', 'Paid'); 
$object->getActiveSheet()->setCellValue('R3', 'Remaining');
		

//merge cell A1 until C1

$object->getActiveSheet()->mergeCells('A1:R1');
$object->getActiveSheet()->mergeCells('A2:R2');

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

for($col = ord('A'); $col <= ord('R'); $col++){ //set column dimension 
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
	$object->getActiveSheet()->setCellValue('B'.$x, $student_details[$i]['enrollment_no'].' ');
	$object->getActiveSheet()->setCellValue('C'.$x, $student_details[$i]['punching_prn']);
	$object->getActiveSheet()->setCellValue('D'.$x, ' '.$sname);
	$object->getActiveSheet()->setCellValue('E'.$x, $student_details[$i]['gender']);
	$object->getActiveSheet()->setCellValue('F'.$x, $student_details[$i]['current_year']);
	$object->getActiveSheet()->setCellValue('G'.$x, $student_details[$i]['stream_name']);
	$object->getActiveSheet()->setCellValue('H'.$x, $student_details[$i]['school_name']);
	$object->getActiveSheet()->setCellValue('I'.$x, $student_details[$i]['mobile']);
	$object->getActiveSheet()->setCellValue('J'.$x, $student_details[$i]['hostel_code']);
	$object->getActiveSheet()->setCellValue('K'.$x, ($student_details[$i]['floor_no']==0?'G':$student_details[$i]['floor_no']));
	$object->getActiveSheet()->setCellValue('L'.$x, $student_details[$i]['room_no']);
	$object->getActiveSheet()->setCellValue('M'.$x, $student_details[$i]['deposit_fees']);
	$object->getActiveSheet()->setCellValue('N'.$x, $student_details[$i]['actual_fees']);
	
	$applicable=($student_details[$i]['deposit_fees']+$student_details[$i]['actual_fees']+$student_details[$i]['fine_fees'])-$student_details[$i]['excemption_fees'];
	
	$object->getActiveSheet()->setCellValue('O'.$x, $applicable);
	$object->getActiveSheet()->setCellValue('P'.$x, $student_details[$i]['opening_balance']);
	
	$object->getActiveSheet()->setCellValue('Q'.$x, $student_details[$i]['paid_amt']); 
	$remaining=($applicable+$student_details[$i]['opening_balance'])-$student_details[$i]['paid_amt'];
	
	$object->getActiveSheet()->setCellValue('R'.$x, $remaining); 
	//$object->getActiveSheet()->setCellValue('R'.$x, $student_details[$i]['scholorship_allowed']);

	$x++;


}


for($k=0; $k<$x; $k++){
	$object->getActiveSheet()->getStyle("A".$k.":R".$k)->applyFromArray(
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
foreach(range('A','R') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
$filename= 'student_details.xls'; //save our workbook as this file name

header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache


//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

//if you want to save it as .XLSX Excel 2007 format

$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

//force user to download the Excel file without writing it to server's HD

$objWriter->save('php://output');
  



?>