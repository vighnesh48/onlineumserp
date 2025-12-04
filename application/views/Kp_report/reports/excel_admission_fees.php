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

$CI =& get_instance();
$CI->load->model('Kp_report_model');			
    

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
	                $object->getActiveSheet()->setCellValue('J4', 'Actual Fees');
	                $object->getActiveSheet()->setCellValue('K4', 'Scholorship');
	                $object->getActiveSheet()->setCellValue('L4', 'Applicable');
					$object->getActiveSheet()->setCellValue('M4', 'Tution fees');
					$object->getActiveSheet()->setCellValue('N4', 'Charges');
	                $object->getActiveSheet()->setCellValue('O4', 'Opening Balance');
					$object->getActiveSheet()->setCellValue('P4', 'Other Fees');
					$object->getActiveSheet()->setCellValue('Q4', 'Refund');
					$object->getActiveSheet()->setCellValue('R4', 'Collection');
					$object->getActiveSheet()->setCellValue('S4', 'Pending');
					$object->getActiveSheet()->setCellValue('T4', 'Admission cancel');

	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:T1');
	                $object->getActiveSheet()->mergeCells('A2:T2');
	                $object->getActiveSheet()->mergeCells('A3:T3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:T3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:T4')->getFont()->setBold(true);

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
			$tfees =$this->Kp_report_model->fetch_tution_fees($row['student_id'], $row['admission_session'],$academic_year,$row['stream_id'],$row['admission_year']);
			$other=$row['opening_balance']+$row['cancel_charges'];
			$pending=($row['applicable_total']+$other+$row['refund'])-$row['fees_total'];
		$object->getActiveSheet()->setCellValue('A'.$x,($x-4));
		$object->getActiveSheet()->setCellValue('B'.$x, "  ".$row['enrollment_no']);
		$object->getActiveSheet()->setCellValue('C'.$x,$row['first_name'].'  '.$row['middle_name'].'  '.$row['last_name']);
		$object->getActiveSheet()->setCellValue('D'.$x,$row['school_short_name']);
		$object->getActiveSheet()->setCellValue('E'.$x, $row['course_short_name']);
		$object->getActiveSheet()->setCellValue('F'.$x, $row['stream_short_name']);
		$object->getActiveSheet()->setCellValue('G'.$x, $row['is_partnership']);
		$object->getActiveSheet()->setCellValue('H'.$x, $row['partnership_code']);
		$object->getActiveSheet()->setCellValue('I'.$x, $row['admission_year']);
		$object->getActiveSheet()->setCellValue('J'.$x, $row['actual_fees']);
		$object->getActiveSheet()->setCellValue('K'.$x,$row['actual_fees']-(int)$row['applicable_total']);
		$object->getActiveSheet()->setCellValue('L'.$x, $row['applicable_total']);
		$object->getActiveSheet()->setCellValue('M'.$x, $tfees[0]['tution_fees']);
		$object->getActiveSheet()->setCellValue('N'.$x, $row['opening_balance']);
		$object->getActiveSheet()->setCellValue('O'.$x, $row['cancel_charges']);
		$object->getActiveSheet()->setCellValue('P'.$x, $other);
		$object->getActiveSheet()->setCellValue('Q'.$x, $row['refund']);
		$object->getActiveSheet()->setCellValue('R'.$x, $row['fees_total']);
		$object->getActiveSheet()->setCellValue('S'.$x, $pending);
		$object->getActiveSheet()->setCellValue('T'.$x, $row['cancelled_admission']);
			
				
		  $x++;
		  $total+= $row['amount'];
		  $rowno++;
		  unset($tfees[0]['tution_fees']);
			unset($tfees);
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
   
   foreach(range('A','T') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
  $object->getActiveSheet()->getStyle('A1:T'.$x)->applyFromArray($styleArray);    
	                  
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