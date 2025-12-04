<?php

if($admission_type=="N")
{
    $adm="New Admission";
}
else if($admission_type=="N"){
     $adm="Re-Registration";
}
else{
     $adm="All-Registration";
}


    

                    $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
					if($report_type==1)
                    $object->getActiveSheet()->setCellValue('A2', 'Admission Fees List-'. $adm);
				else if($report_type==5)
					 $object->getActiveSheet()->setCellValue('A2', 'Sem Wise Admission Fees List-'. $adm);
					
					
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN No');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4','School');
	                $object->getActiveSheet()->setCellValue('E4', 'Course');
	                $object->getActiveSheet()->setCellValue('F4', 'Stream');
					$object->getActiveSheet()->setCellValue('G4', 'Is Partnership');
					
					$object->getActiveSheet()->setCellValue('H4', 'Partnership Code');
					
	                $object->getActiveSheet()->setCellValue('I4', 'Year');
	                $object->getActiveSheet()->setCellValue('J4', 'Receipt No');
	                $object->getActiveSheet()->setCellValue('K4', 'Paid By');
	                $object->getActiveSheet()->setCellValue('L4', 'DD/CHQ No');
	                $object->getActiveSheet()->setCellValue('M4', 'Dated');
					
					if($report_type==1)
					{
					$object->getActiveSheet()->setCellValue('N4', 'Actual Fees');
					$object->getActiveSheet()->setCellValue('O4', 'Scholorship');
					$object->getActiveSheet()->setCellValue('P4', 'Applicable Fees');
					}
					else if($report_type==5)
					{
						$object->getActiveSheet()->setCellValue('N4', 'Actual Fees');
						$object->getActiveSheet()->setCellValue('O4', 'Sem Wise Scholorship');
						$object->getActiveSheet()->setCellValue('P4', 'Sem Wise Applicable Fees');
					}
					
					
	                $object->getActiveSheet()->setCellValue('Q4', 'Amount');
	                $object->getActiveSheet()->setCellValue('R4', 'Bank');
	                $object->getActiveSheet()->setCellValue('S4', 'Branch');
	                $object->getActiveSheet()->setCellValue('T4', 'Fees Cancelled');
	                $object->getActiveSheet()->setCellValue('U4', 'Old PRN');

	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:U1');
	                $object->getActiveSheet()->mergeCells('A2:U2');
	                $object->getActiveSheet()->mergeCells('A3:U3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:U3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:U4')->getFont()->setBold(true);

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
		$total=0;
		foreach($fees as $row){
		$object->getActiveSheet()->setCellValue('A'.$x,($x-4));
		$object->getActiveSheet()->setCellValue('B'.$x, "  ".$row['enrollment_no']);
		$object->getActiveSheet()->setCellValue('C'.$x,$row['first_name'].'  '.$row['middle_name'].'  '.$row['last_name']);
		$object->getActiveSheet()->setCellValue('D'.$x,$row['school_short_name']);
		$object->getActiveSheet()->setCellValue('E'.$x, $row['course_short_name']);
		$object->getActiveSheet()->setCellValue('F'.$x, $row['stream_short_name']);
		$object->getActiveSheet()->setCellValue('G'.$x, $row['is_partnership']);
		$object->getActiveSheet()->setCellValue('H'.$x, $row['partnership_code']);
		$object->getActiveSheet()->setCellValue('I'.$x, $row['year']);
		$object->getActiveSheet()->setCellValue('J'.$x, $row['college_receiptno']);
		$object->getActiveSheet()->setCellValue('K'.$x,$row['fees_paid_type']);
		$object->getActiveSheet()->setCellValue('L'.$x, $row['ddno']);
		$object->getActiveSheet()->setCellValue('M'.$x, $row['fdate']);
		
		if($report_type==1)
		{
			$object->getActiveSheet()->setCellValue('N'.$x, $row['actual_fee']);
		$object->getActiveSheet()->setCellValue('O'.$x, $row['actual_fee']-$row['applicable_fee']);
		$object->getActiveSheet()->setCellValue('P'.$x, $row['applicable_fee']);
		}
		else if($report_type==5)
		{
			$object->getActiveSheet()->setCellValue('N'.$x, $row['actual_fee']/2);
		$object->getActiveSheet()->setCellValue('O'.$x, ($row['actual_fee']-$row['applicable_fee'])/2);
		$object->getActiveSheet()->setCellValue('P'.$x, ($row['applicable_fee'])/2);
		}		
				
		$object->getActiveSheet()->setCellValue('Q'.$x, $row['amount']);
		$object->getActiveSheet()->setCellValue('R'.$x,$row['bank_name']);
		$object->getActiveSheet()->setCellValue('S'.$x, $row['bank_city']);
		$object->getActiveSheet()->setCellValue('T'.$x, $row['chq_cancelled']);
		$object->getActiveSheet()->setCellValue('U'.$x, $row['enrollment_no_new']);
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
   
   foreach(range('A','U') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
  $object->getActiveSheet()->getStyle('A1:U'.$x)->applyFromArray($styleArray);    
	                  
			if($report_type==1)
                   $filename='Admission Fees:'.$academic_year.'.xls';
				else if($report_type==5)
					$filename='Sem Wise Admission Fees:'.$academic_year.'.xls';
				 
	                 //save our workbook as this file name

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