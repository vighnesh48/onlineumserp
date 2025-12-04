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
$object->getActiveSheet()->setCellValue('A2', 'Hostel Cancelled Student Details for the academic year -'.$student_details[0]['academic_year']);	

$object->getActiveSheet()->setCellValue('A3', 'Sr.No');
$object->getActiveSheet()->setCellValue('B3', 'Student PRN');
$object->getActiveSheet()->setCellValue('C3', 'Name');
$object->getActiveSheet()->setCellValue('D3', 'Gender');
$object->getActiveSheet()->setCellValue('E3', 'Current Year');
$object->getActiveSheet()->setCellValue('F3', 'Course');
$object->getActiveSheet()->setCellValue('G3', 'Institute');
$object->getActiveSheet()->setCellValue('H3', 'Mobile');
$object->getActiveSheet()->setCellValue('I3', 'Deposit Fee');
$object->getActiveSheet()->setCellValue('J3', 'Hostel Fee');
$object->getActiveSheet()->setCellValue('K3', 'Excemption');
$object->getActiveSheet()->setCellValue('L3', 'Applicable'); 
$object->getActiveSheet()->setCellValue('M3', 'Paid');
$object->getActiveSheet()->setCellValue('N3', 'Refund_paid');
$object->getActiveSheet()->setCellValue('O3', 'Cancel Charges');
$object->getActiveSheet()->setCellValue('P3', 'Remaining');
		

//merge cell A1 until C1

$object->getActiveSheet()->mergeCells('A1:P1');
$object->getActiveSheet()->mergeCells('A2:P2');

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

for($col = ord('A'); $col <= ord('P'); $col++){ //set column dimension 
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
	$object->getActiveSheet()->setCellValue('C'.$x, ' '.$sname);
	$object->getActiveSheet()->setCellValue('D'.$x, $student_details[$i]['gender']);
	$object->getActiveSheet()->setCellValue('E'.$x, $student_details[$i]['current_year']);
	$object->getActiveSheet()->setCellValue('F'.$x, $student_details[$i]['stream_name']);
	$object->getActiveSheet()->setCellValue('G'.$x, $student_details[$i]['school_name']);
	$object->getActiveSheet()->setCellValue('H'.$x, $student_details[$i]['mobile']);

	$object->getActiveSheet()->setCellValue('I'.$x, $student_details[$i]['deposit_fees']);
	$object->getActiveSheet()->setCellValue('J'.$x, $student_details[$i]['actual_fees']);
	$object->getActiveSheet()->setCellValue('K'.$x, $student_details[$i]['excemption_fees']);
	
		$applicable=($student_details[$i]['deposit_fees']+$student_details[$i]['actual_fees'])-$student_details[$i]['excemption_fees'];

	
	$object->getActiveSheet()->setCellValue('L'.$x, ($applicable));
	$object->getActiveSheet()->setCellValue('M'.$x, $student_details[$i]['paid_amt']);
	$object->getActiveSheet()->setCellValue('N'.$x, $student_details[$i]['refund_paid']);
	//$object->getActiveSheet()->setCellValue('O'.$x, $student_details[$i]['refund_paid']);
	$object->getActiveSheet()->setCellValue('O'.$x, $student_details[$i]['cancellation_charges']);
 
	//$remaining=$student_details[$i]['paid_amt']-($student_details[$i]['refund_paid']+$student_details[$i]['cancellation_charges']);
	if($student_details[$i]['refund_paid']==0)
	$remaining=($applicable+$student_details[$i]['opening_balance']+$student_details[$i]['gym_fees']+$student_details[$i]['fine_fees']+$student_details[$i]['refund_paid'])
	-
	($student_details[$i]['paid_amt']+$student_details[$i]['cancellation_charges']);
	else if($student_details[$i]['refund_paid']>0)
		$remaining=($student_details[$i]['refund_paid']+$student_details[$i]['cancellation_charges'])-$student_details[$i]['paid_amt'];
	
	$object->getActiveSheet()->setCellValue('P'.$x, $remaining); 
	//$object->getActiveSheet()->setCellValue('R'.$x, $student_details[$i]['scholorship_allowed']);

	$x++;


}


for($k=0; $k<$x; $k++){
	$object->getActiveSheet()->getStyle("A".$k.":P".$k)->applyFromArray(
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
foreach(range('A','P') as $columnID)
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