<?php

if($admission_type=="N")
{
    $adm="ONLY New Admission";
}
else if($admission_type=="R"){
     $adm="ONLY Re-Registration";
}
else{
     $adm="BOTH-All-Registration";
}

$filename=''; 
$tit="";
if($report_type=="4")
{
	$tit="Outstanding Fees Student Wise- ";
	$filename='Student Wise Outstanding Fees-'.$academic_year.'.xls'; 
}   
else if($report_type=="2"){
	$tit="Admission Fees Student Wise -";
	$filename='Student Wise Admission Fees-'.$academic_year.'.xls';
}
else if($report_type=="6"){
	$tit="Sem Wise Admission Fees Student Wise -";
	$filename='Sem Wise Student Wise Admission Fees-'.$academic_year.'.xls';
}
else if($report_type=="8")
{
	$tit="Sem Wise Outstanding Fees Student Wise- ";
	$filename='Sem Wise Student Wise Outstanding Fees-'.$academic_year.'.xls'; 
}  

       $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2',  $tit. $adm);
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN No');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4','Mobile');
	                $object->getActiveSheet()->setCellValue('E4', 'Gender');
	                $object->getActiveSheet()->setCellValue('F4', 'School');
	                $object->getActiveSheet()->setCellValue('G4', 'Course');
	                $object->getActiveSheet()->setCellValue('H4', 'Stream');
					$object->getActiveSheet()->setCellValue('I4', 'Is Partnership');
					
					$object->getActiveSheet()->setCellValue('J4', 'Partnership Code');
	                $object->getActiveSheet()->setCellValue('K4', 'Year');
					if($report_type==2 || $report_type==4)
					{
	                $object->getActiveSheet()->setCellValue('L4', 'Actual Fees');
	                $object->getActiveSheet()->setCellValue('M4', 'Scholorship');
	                $object->getActiveSheet()->setCellValue('N4', 'Applicable');
					
					}
					else if($report_type==6 || $report_type==8)
					{
						$object->getActiveSheet()->setCellValue('L4', 'Actual Fees');
	                $object->getActiveSheet()->setCellValue('M4', 'Sem Wise Scholorship');
	                $object->getActiveSheet()->setCellValue('N4', 'Sem Wise Applicable');
					}
					
	                $object->getActiveSheet()->setCellValue('O4', 'Opening Balance');
	                $object->getActiveSheet()->setCellValue('P4', 'Charges');
	                $object->getActiveSheet()->setCellValue('Q4', 'Other Fees');
	                $object->getActiveSheet()->setCellValue('R4', 'Refund');
	                $object->getActiveSheet()->setCellValue('S4', 'Fees Paid');
	                $object->getActiveSheet()->setCellValue('T4', 'Pending');
	                    $object->getActiveSheet()->setCellValue('U4', 'Excess Paid');
	                $object->getActiveSheet()->setCellValue('V4', 'Admission Cancel');
	                $object->getActiveSheet()->setCellValue('W4', 'Category');
	                $object->getActiveSheet()->setCellValue('X4', 'Sub-Cast');
					//$object->getActiveSheet()->setCellValue('Y4', 'Exam_form_status');
					
					$object->getActiveSheet()->setCellValue('Y4', 'Is Reported');
					$object->getActiveSheet()->setCellValue('Z4', 'Reported Date');
					/*$object->getActiveSheet()->setCellValue('Z4', 'Category');
					$object->getActiveSheet()->setCellValue('AB4', 'Category');
					$object->getActiveSheet()->setCellValue('AC4', 'Sub-Cast');*/
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:Z1');
	                $object->getActiveSheet()->mergeCells('A2:Z2');
	                $object->getActiveSheet()->mergeCells('A3:Z3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:Z3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	               $object->getActiveSheet()->getStyle('A1:Z4')->getFont()->setBold(true);

	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);

	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

	       for($col = ord('A'); $col <= ord('B'); $col++){ //set column dimension $object->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);

	                 //change the font size

	                $object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
	                $object->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                      

	        }

	//retrive contries table data

	$rowno=1;
	$x=5;
	$total=0;$other=0; $pending=0;
	foreach($fees as $row){
	$other=$row['opening_balance']+$row['cancel_charges'];
	
	if($report_type==2 || $report_type==4)
	$pending=($row['applicable_total']+$other+$row['refund'])-$row['fees_total'];
else
	$pending=(($row['applicable_total']/2)+$other+$row['refund'])-$row['fees_total'];

	$object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	$object->getActiveSheet()->setCellValue('B'.$x,"  ". $row['enrollment_no']);
	$object->getActiveSheet()->setCellValue('C'.$x,$row['first_name'].'  '.$row['middle_name'].'  '.$row['last_name']);
	$object->getActiveSheet()->setCellValue('D'.$x,$row['mobile']);
	$object->getActiveSheet()->setCellValue('E'.$x,$row['gender']);
	$object->getActiveSheet()->setCellValue('F'.$x, $row['school_name']);
	$object->getActiveSheet()->setCellValue('G'.$x, $row['course_name']);
	$object->getActiveSheet()->setCellValue('H'.$x, $row['stream_name']);
	$object->getActiveSheet()->setCellValue('I'.$x, $row['is_partnership']);
	$object->getActiveSheet()->setCellValue('J'.$x, $row['partnership_code']);
	$object->getActiveSheet()->setCellValue('K'.$x, $row['admission_year']);
	if($report_type==2 || $report_type==4)
	{
	$object->getActiveSheet()->setCellValue('L'.$x, $row['actual_fees']);
	$object->getActiveSheet()->setCellValue('M'.$x, ($row['actual_fees']-$row['applicable_total']) );
	$object->getActiveSheet()->setCellValue('N'.$x, $row['applicable_total']);
	}
	else if($report_type==6 || $report_type==8)
	{
	$object->getActiveSheet()->setCellValue('L'.$x, $row['actual_fees']/2);
	$object->getActiveSheet()->setCellValue('M'.$x, ($row['actual_fees']-$row['applicable_total'])/2 );
	$object->getActiveSheet()->setCellValue('N'.$x, $row['applicable_total']/2);
	}
	
	$object->getActiveSheet()->setCellValue('O'.$x, $row['opening_balance']);
	$object->getActiveSheet()->setCellValue('P'.$x, $row['cancel_charges']);
	$object->getActiveSheet()->setCellValue('Q'.$x, $other);
	$object->getActiveSheet()->setCellValue('R'.$x,$row['refund']);
	$object->getActiveSheet()->setCellValue('S'.$x, $row['fees_total']);
	
	if($pending>0)
	{
	$object->getActiveSheet()->setCellValue('T'.$x, $pending);
	$object->getActiveSheet()->setCellValue('U'.$x, 0);
	}
	else
	{
	$object->getActiveSheet()->setCellValue('T'.$x, 0);
	$object->getActiveSheet()->setCellValue('U'.$x, abs($pending));	    
	}
	
//	$object->getActiveSheet()->setCellValue('T'.$x, $pending);
	$object->getActiveSheet()->setCellValue('V'.$x, $row['cancelled_admission']);
	$object->getActiveSheet()->setCellValue('W'.$x, $row['category']);
	$object->getActiveSheet()->setCellValue('X'.$x, $row['sub_caste']);
	//$object->getActiveSheet()->setCellValue('Y'.$x, $row['Exam_form_status']);	
	$reported_status="No";
	if($row['reported_status']=='Y'){
		$reported_status="Yes";
	}
	$object->getActiveSheet()->setCellValue('Y'.$x, $reported_status);
	$object->getActiveSheet()->setCellValue('Z'.$x, $row['reported_date']);
	/*$object->getActiveSheet()->setCellValue('AA'.$x, $row['religion']);
	$object->getActiveSheet()->setCellValue('AB'.$x, $row['category']);
	$object->getActiveSheet()->setCellValue('AC'.$x, $row['sub_caste']);*/
	  $x++;
	  $total+= $row['amount'];
	  $rowno++;
	}
	
	$object->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$object->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$object->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
   
  $object->getActiveSheet()->getStyle('A1:Z'.$x)->applyFromArray($styleArray);    


	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
    exit(); 
 
              
	   


?>