<?php

if($report_type=="1")
{
  
                    $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip Foundation-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Hostel Fees List-'. $campus .'  '.$institute_name);
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN/Id');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4','Organization');
	                $object->getActiveSheet()->setCellValue('E4', 'Course');
	                $object->getActiveSheet()->setCellValue('F4', 'Stream');
	                $object->getActiveSheet()->setCellValue('G4', 'Year');
	                $object->getActiveSheet()->setCellValue('H4', 'Receipt No');
	                $object->getActiveSheet()->setCellValue('I4', 'Paid By');
	                $object->getActiveSheet()->setCellValue('J4', 'DD/CHQ No');
	                $object->getActiveSheet()->setCellValue('K4', 'Dated');
	                $object->getActiveSheet()->setCellValue('L4', 'Amount');
	                $object->getActiveSheet()->setCellValue('M4', 'Bank');
	                $object->getActiveSheet()->setCellValue('N4', 'Branch');
	                $object->getActiveSheet()->setCellValue('O4', 'Fees Cancelled');
	                $object->getActiveSheet()->setCellValue('P4', 'Old PRN');
	                 $object->getActiveSheet()->setCellValue('Q4', 'College/School');
                     $object->getActiveSheet()->setCellValue('R4', 'Email');
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:R1');
	                $object->getActiveSheet()->mergeCells('A2:R2');
	                $object->getActiveSheet()->mergeCells('A3:R3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:R4')->getFont()->setBold(true);

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
                    $object->getActiveSheet()->setCellValue('B'.$x,$row['enrollment_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['first_name'].'  '.$row['middle_name'].'  '.$row['last_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['organisation']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['course']);
	                $object->getActiveSheet()->setCellValue('F'.$x, $row['stream']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['year']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['college_receiptno']);
	                $object->getActiveSheet()->setCellValue('I'.$x,$row['fees_paid_type']);
	                $object->getActiveSheet()->setCellValue('J'.$x, $row['ddno']);
	                $object->getActiveSheet()->setCellValue('K'.$x, $row['fdate']);
	                $object->getActiveSheet()->setCellValue('L'.$x, $row['amount']);
	                $object->getActiveSheet()->setCellValue('M'.$x,$row['bank_name']);
	                $object->getActiveSheet()->setCellValue('N'.$x, $row['bank_city']);
	                $object->getActiveSheet()->setCellValue('O'.$x, $row['chq_cancelled']);
	                $object->getActiveSheet()->setCellValue('P'.$x, $row['enrollment_no_new']);
	                 $object->getActiveSheet()->setCellValue('Q'.$x, $row['intitute']);
					  $object->getActiveSheet()->setCellValue('R'.$x, $row['email']);
                      $x++;
                      $total+= $row['amount'];
                      $rowno++;
                    }
                    
                    $object->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	                
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);


foreach(range('A','R') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}


  $object->getActiveSheet()->getStyle('A1:R'.$x)->applyFromArray($styleArray);    
	                  

	                $filename='Hostel Fees Collection-'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
	   
exit();
}
else if($report_type=="2")
{
  
                    $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip Foundation-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Hostel Fees Student Wise-'. $campus .'  '.$institute_name);
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN/Id');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4','Gender');
	                $object->getActiveSheet()->setCellValue('E4', 'Mobile');
	                $object->getActiveSheet()->setCellValue('F4', 'Organization');
	                $object->getActiveSheet()->setCellValue('G4', 'Stream');
	                $object->getActiveSheet()->setCellValue('H4', 'Year');
	                $object->getActiveSheet()->setCellValue('I4', 'Deposit Fees');
	                $object->getActiveSheet()->setCellValue('J4', 'Hostel Fees');
	                $object->getActiveSheet()->setCellValue('K4', 'Exemption');
	                $object->getActiveSheet()->setCellValue('L4', 'Gym Fees');
	                $object->getActiveSheet()->setCellValue('M4', 'Fine Fees');
	                $object->getActiveSheet()->setCellValue('N4', 'Opening Balance');
	                $object->getActiveSheet()->setCellValue('O4', 'Applicable');
	                $object->getActiveSheet()->setCellValue('P4', 'Paid');
					$object->getActiveSheet()->setCellValue('Q4', 'Deposite Bank');
	                $object->getActiveSheet()->setCellValue('R4', 'Cancellation Charges');  
	                $object->getActiveSheet()->setCellValue('S4', 'Refund');
	                $object->getActiveSheet()->setCellValue('T4', 'Pending');
	                $object->getActiveSheet()->setCellValue('U4', 'Cancelled');
	                $object->getActiveSheet()->setCellValue('V4', 'Institute');
	                $object->getActiveSheet()->setCellValue('W4', 'Hostel ');
	                $object->getActiveSheet()->setCellValue('X4', 'Room No');
	                $object->getActiveSheet()->setCellValue('Y4', 'Email');
					$object->getActiveSheet()->setCellValue('Z4', 'Admission Date');
					$object->getActiveSheet()->setCellValue('AA4', 'Punching PRN');
					$object->getActiveSheet()->setCellValue('AB4', 'Is paskage');
					$object->getActiveSheet()->setCellValue('AC4', 'PROV. PRN');

	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:AC1');
	                $object->getActiveSheet()->mergeCells('A2:AC2');
	                $object->getActiveSheet()->mergeCells('A3:AC3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:AC3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:AC4')->getFont()->setBold(true);

	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);

	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

	       for($col = ord('A'); $col <= ord('C'); $col++){ //set column dimension $object->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);

	                 //change the font size

	                $object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
	                $object->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                      

	        }

	                //retrive contries table data

                    $rowno=1;
                    $x=5;
                    $total=0;
                    foreach($fees as $row){
                    $appl=($row['deposit_fees']+$row['actual_fees']+$row['gym_fees']+$row['fine_fees']+$row['opening_balance'])-($row['excemption_fees']);
                    
                    		    if($row['cancelled_facility']=="Y")
                                 {
                                    $bal = ($appl-$row['cancellation_refund'])-$row['fees_paid'];
                                    if( $bal<0){
                                       $refund=0-$bal; 
                                        $bal=0;
                                    }
                                    
                                 }
                                 else
                                  {
                                      //$bal =  $appl-$row['cancellation_refund']-$row['fees_paid'];
									//  $bal=($appl+(int)$row['cancellation_refund'])-$row['fees_paid'];
									  $bal = ($appl - (int)$row['fees_paid'])+(int)$row['cancellation_refund'];
                                      $refund=0;
                                  }
                    
                    
                    
                  //  $bal=$appl-($row['fees_paid']+$row['canc_amount']);
				  $adm_date =date("d-m-Y", strtotime($row['created_on']));
				 //$adm_date='';
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                    $object->getActiveSheet()->setCellValue('B'.$x,$row['enrollment_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['first_name'].'  '.$row['middle_name'].'  '.$row['last_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['gender']);
	                $object->getActiveSheet()->setCellValue('E'.$x,$row['mobile']);
	                $object->getActiveSheet()->setCellValue('F'.$x,$row['organisation']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['stream']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['year']);
	                $object->getActiveSheet()->setCellValue('I'.$x, $row['deposit_fees']);
	                $object->getActiveSheet()->setCellValue('J'.$x, $row['actual_fees']);
	                $object->getActiveSheet()->setCellValue('K'.$x, $row['excemption_fees']);
	                $object->getActiveSheet()->setCellValue('L'.$x, $row['gym_fees']);
	                $object->getActiveSheet()->setCellValue('M'.$x, $row['fine_fees']);
	                $object->getActiveSheet()->setCellValue('N'.$x, $row['opening_balance']);
	                $object->getActiveSheet()->setCellValue('O'.$x, $appl);
	                $object->getActiveSheet()->setCellValue('P'.$x,$row['fees_paid']);
					$object->getActiveSheet()->setCellValue('Q'.$x,$row['bank_name']);
	                $object->getActiveSheet()->setCellValue('R'.$x,$row['cancellation_refund']);
	                $object->getActiveSheet()->setCellValue('S'.$x,$refund);
	                $object->getActiveSheet()->setCellValue('T'.$x,$bal);
	                $object->getActiveSheet()->setCellValue('U'.$x, $row['cancelled_facility']);
	                $object->getActiveSheet()->setCellValue('V'.$x, $row['intitute']);
	                $object->getActiveSheet()->setCellValue('W'.$x,$row['hostel_name'].'-'.$row['hostel_code']);
	                $object->getActiveSheet()->setCellValue('X'.$x, $row['room_no']);
	                $object->getActiveSheet()->setCellValue('Y'.$x, $row['email']);
					$object->getActiveSheet()->setCellValue('Z'.$x, $adm_date);
					$object->getActiveSheet()->setCellValue('AA'.$x, $row['punching_prn']);
					$object->getActiveSheet()->setCellValue('AB'.$x, $row['belongs_to']);
					$object->getActiveSheet()->setCellValue('AC'.$x, $row['enrollment_no_new']);
	                
                      $x++;
                      $total+= $row['fees_paid'];
                      $rowno++;
                    }
                    
                    $object->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	                
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

foreach(range('A','AC') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

  $object->getActiveSheet()->getStyle('A1:AC'.$x)->applyFromArray($styleArray);    
	                 
	                $filename='Hostel Fees  StudentWise-'.$academic_year.'.xls'; //save our workbook as this file name
	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
	   
exit();
}
else if($report_type=="3")
{
  
                    $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip Foundation-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Hostel Institute Wise Statistics-'. $campus .'  '. $institute_name);
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'Organization');
	                $object->getActiveSheet()->setCellValue('C4', 'Institute');
	                $object->getActiveSheet()->setCellValue('D4', '#students');
	                $object->getActiveSheet()->setCellValue('E4', 'Deposit Fees');
	                $object->getActiveSheet()->setCellValue('F4', 'Hostel Fees');
	                $object->getActiveSheet()->setCellValue('G4', 'Exemption');
	                $object->getActiveSheet()->setCellValue('H4', 'Gym Fees');
	                $object->getActiveSheet()->setCellValue('I4', 'Fine Fees');
	                $object->getActiveSheet()->setCellValue('J4', 'Opening Balance');
	                $object->getActiveSheet()->setCellValue('K4', 'Applicable');
	                $object->getActiveSheet()->setCellValue('L4', 'Paid');
	                $object->getActiveSheet()->setCellValue('M4', 'Pending');
	    
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:M1');
	                $object->getActiveSheet()->mergeCells('A2:M2');
	                $object->getActiveSheet()->mergeCells('A3:M3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:M4')->getFont()->setBold(true);

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
                    $deposit_fees=0; $actual_fees=0; $gym_fees=0; $fine_fees=0; $excemption_fees=0; $opening_balance=0;$fees_paid=0;$appl1=0;$stud=0;
                    foreach($fees as $row){
                    $appl=($row['deposit_fees']+$row['actual_fees']+$row['gym_fees']+$row['fine_fees']+$row['opening_balance'])-($row['excemption_fees']);
                    $bal=$appl-$row['fees_paid'];
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                    $object->getActiveSheet()->setCellValue('B'.$x,$row['organisation']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['college_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['stud_total']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['deposit_fees']);
	                $object->getActiveSheet()->setCellValue('F'.$x, $row['actual_fees']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['excemption_fees']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['gym_fees']);
	                $object->getActiveSheet()->setCellValue('I'.$x, $row['fine_fees']);
	                $object->getActiveSheet()->setCellValue('J'.$x, $row['opening_balance']);
	                $object->getActiveSheet()->setCellValue('K'.$x, $appl);
	                $object->getActiveSheet()->setCellValue('L'.$x,$row['fees_paid']);
	                $object->getActiveSheet()->setCellValue('M'.$x,$bal);
	               
                      $x++;
                      $appl1=$appl1+$appl;$stud+=$row['stud_total'];
                       $deposit_fees+= $row['deposit_fees'];$actual_fees+= $row['actual_fees'];$gym_fees+= $row['gym_fees']; $fine_fees+=$row['fine_fees']; $excemption_fees+= $row['excemption_fees'];$opening_balance+= $row['opening_balance'];$fees_paid+= $row['fees_paid'];
                      $rowno++;
                    }
                     
                     $object->getActiveSheet()->setCellValue('A'.$x, 'Total');
                     $object->getActiveSheet()->setCellValue('D'.$x,$stud);
	                 $object->getActiveSheet()->setCellValue('E'.$x,$deposit_fees);
	                 $object->getActiveSheet()->setCellValue('F'.$x,$actual_fees);
	                 $object->getActiveSheet()->setCellValue('G'.$x,$gym_fees);
	                 $object->getActiveSheet()->setCellValue('H'.$x,$fine_fees);
	                 $object->getActiveSheet()->setCellValue('I'.$x,$excemption_fees);
	                 $object->getActiveSheet()->setCellValue('J'.$x,$opening_balance);
	                 $object->getActiveSheet()->setCellValue('K'.$x,$appl1);
	                 $object->getActiveSheet()->setCellValue('L'.$x,$fees_paid);
	                 $object->getActiveSheet()->setCellValue('M'.$x,($appl1-$fees_paid));
	                 $object->getActiveSheet()->mergeCells('A'.$x.':C'.$x);
	                 
	                  $object->getActiveSheet()->getStyle('A'.$x.':M'.$x)->getFont()->setBold(true);
                    $object->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

foreach(range('A','M') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

  $object->getActiveSheet()->getStyle('A1:M'.$x)->applyFromArray($styleArray);    
	                  
	                $filename='Hostel Inst Statistics Fees-'.$academic_year.'.xls'; //save our workbook as this file name
	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
	                //if you want to save it as .XLSX Excel 2007 format
	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 
	                //force user to download the Excel file without writing it to server's HD
	                $objWriter->save('php://output');
exit();
}

else if($report_type=="4")
{
  
                    $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip Foundation-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Hostel Outstanding Fees-'. $campus .'  '. $institute_name);
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN/Id');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4','Gender');
	                $object->getActiveSheet()->setCellValue('E4', 'Mobile');
	                $object->getActiveSheet()->setCellValue('F4', 'Organization');
	                $object->getActiveSheet()->setCellValue('G4', 'Stream');
	                $object->getActiveSheet()->setCellValue('H4', 'Year');
	                $object->getActiveSheet()->setCellValue('I4', 'Deposit Fees');
	                $object->getActiveSheet()->setCellValue('J4', 'Hostel Fees');
	                $object->getActiveSheet()->setCellValue('K4', 'Exemption');
	                $object->getActiveSheet()->setCellValue('L4', 'Gym Fees');
	                $object->getActiveSheet()->setCellValue('M4', 'Fine Fees');
	                $object->getActiveSheet()->setCellValue('N4', 'Opening Balance');
	                $object->getActiveSheet()->setCellValue('O4', 'Applicable');
	                $object->getActiveSheet()->setCellValue('P4', 'Paid');
	                $object->getActiveSheet()->setCellValue('Q4', 'Pending');
	                $object->getActiveSheet()->setCellValue('R4', 'Cancelled');
                    $object->getActiveSheet()->setCellValue('S4'.$x,'Institute');
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:S1');
	                $object->getActiveSheet()->mergeCells('A2:S2');
	                $object->getActiveSheet()->mergeCells('A3:S3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:S4')->getFont()->setBold(true);

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
                    $appl=($row['deposit_fees']+$row['actual_fees']+$row['gym_fees']+$row['fine_fees']+$row['opening_balance'])-($row['excemption_fees']);
                    $bal=$appl-$row['fees_paid'];
					$arr_fees_paid[]=$row['fees_paid']; 
					$arr_cancellation_refund[]=$row['cancellation_refund'];
					$arr_fees_pending[]=$bal;
					$arr_appl[]=$appl;
					
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                    $object->getActiveSheet()->setCellValue('B'.$x,$row['enrollment_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['first_name'].'  '.$row['middle_name'].'  '.$row['last_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['gender']);
	                $object->getActiveSheet()->setCellValue('E'.$x,$row['mobile']);
	                $object->getActiveSheet()->setCellValue('F'.$x,$row['organisation']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['stream']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['year']);
	                $object->getActiveSheet()->setCellValue('I'.$x, $row['deposit_fees']);
	                $object->getActiveSheet()->setCellValue('J'.$x, $row['actual_fees']);
	                 $object->getActiveSheet()->setCellValue('K'.$x, $row['excemption_fees']);
	                $object->getActiveSheet()->setCellValue('L'.$x, $row['gym_fees']);
	                $object->getActiveSheet()->setCellValue('M'.$x, $row['fine_fees']);
	                $object->getActiveSheet()->setCellValue('N'.$x, $row['opening_balance']);
	                $object->getActiveSheet()->setCellValue('O'.$x, $appl);
	                $object->getActiveSheet()->setCellValue('P'.$x,$row['fees_paid']);
	                $object->getActiveSheet()->setCellValue('Q'.$x,$bal);
	                $object->getActiveSheet()->setCellValue('R'.$x, $row['cancelled_facility']);
	                $object->getActiveSheet()->setCellValue('S'.$x, $row['intitute']);
                      $x++;
                      $total+= $row['fees_paid'];
                      $rowno++;
                    }
                    $sum_appl = array_sum($arr_appl);
					$sum_fees_paid = array_sum($arr_fees_paid);
					$sum_fees_pending = array_sum($arr_fees_pending);
					$object->getActiveSheet()->setCellValue('A'.$x, 'Total');
					$object->getActiveSheet()->mergeCells('B'.$x.':N'.$x);
					
	                $object->getActiveSheet()->setCellValue('O'.$x, $sum_appl);
	                $object->getActiveSheet()->setCellValue('P'.$x, $sum_fees_paid);
	                $object->getActiveSheet()->setCellValue('Q'.$x, $sum_fees_pending);
	                $object->getActiveSheet()->setCellValue('R'.$x, '');
	                $object->getActiveSheet()->setCellValue('S'.$x, '');
					 
                    $object->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$object->getActiveSheet()->getStyle('B'.$x.':S'.$x)->getFont()->setBold(true)->setSize(15);

foreach(range('A','S') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

  $object->getActiveSheet()->getStyle('A1:S'.$x)->applyFromArray($styleArray);    
	                  

	                $filename='Hostel Outstanding Fees-'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
	   
exit();
}
else if($report_type=="5")
{
  
                    $this->load->library("excel");
                    $object = new PHPExcel();
                   $sheet = $object->getActiveSheet();

// Merge title rows
$sheet->mergeCells('A1:R1');
$sheet->mergeCells('A2:R2');
$sheet->mergeCells('A3:R3');

// Set title content
$sheet->setCellValue('A1', 'Sandip Foundation-Nashik');
$sheet->setCellValue('A2', 'Hostel Statistics-'.$campus);
$sheet->setCellValue('A3', 'Academic Year:'.$academic_year);

// Title styling
$sheet->getStyle('A1:A3')->getFont()->setBold(true)->setSize(14)->getColor()->setRGB('FFFFFF');
$sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('1F4E78');
$sheet->getStyle('A2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('305496');
$sheet->getStyle('A3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');

	    
	                //merge cell A1 until C1

	                $headers = ['S.No.', 'Hostel Name', 'Campus', 'Capacity', 'Increased Capacity', 'Allocated', 'Vacant',
            'Deposit Fees', 'Hostel Fees', 'Exemption', 'Gym Fees', 'Fine Fees', 'Opening Balance',
            'Applicable', 'Paid', 'Pending', 'Owner', 'Monthly Rent'];

foreach ($headers as $index => $header) {
    $col = chr(65 + $index); // A, B, ..., Q
    $sheet->setCellValue($col.'4', $header);

    // Header styles
    $sheet->getStyle($col.'4')->getFont()->setBold(true)->setSize(11)->getColor()->setRGB('FFFFFF');
    $sheet->getStyle($col.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle($col.'4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('002060');
}

	                //retrive contries table data
					
					$rowno=1;
                    $x=5;
                    $deposit_fees=0; $actual_fees=0; $gym_fees=0; $fine_fees=0; $excemption_fees=0; $opening_balance=0;$fees_paid=0;$appl1=0;$stud_total=0;$capacity=0;$actual_capacity=0;
                    foreach($fees as $row){
					$owners = get_hostel_owners($row['host_id']);	

					$ownersdetails = ''; // Initialize as empty string
												
					foreach ($owners as $o) {
						$rent="₹{$o['rent_amount']}";
						$ownersdetails .= "{$o['owner_name']} ({$o['academic_year']}) - From: {$o['from_date']} To: {$o['to_date']}";
					}	
                    $appl=($row['deposit_fees']+$row['actual_fees']+$row['gym_fees']+$row['fine_fees']+$row['opening_balance'])-($row['excemption_fees']);
                    $bal=$appl-$row['fees_paid'];
                    $sheet->setCellValue('A'.$x,($x-4));
                    $sheet->setCellValue('B'.$x,$row['hostel_name']);
	                $sheet->setCellValue('C'.$x,$row['area'].'-'.$row['campus_name']);
	                $sheet->setCellValue('E'.$x, $row['capacity']);
	                $sheet->setCellValue('D'.$x, $row['actual_capacity']);
	                $sheet->setCellValue('F'.$x, $row['stud_total']);
	                $sheet->setCellValue('G'.$x, $row['capacity']- $row['stud_total']);
	                $sheet->setCellValue('H'.$x, $row['deposit_fees']);
	                $sheet->setCellValue('I'.$x, $row['actual_fees']);
	                $sheet->setCellValue('J'.$x, $row['excemption_fees']);
	                $sheet->setCellValue('K'.$x, $row['gym_fees']);
	                $sheet->setCellValue('L'.$x, $row['fine_fees']);
	                $sheet->setCellValue('M'.$x, $row['opening_balance']);
	                $sheet->setCellValue('N'.$x, $appl);
	                $sheet->setCellValue('O'.$x,$row['fees_paid']);
	                $sheet->setCellValue('P'.$x,$bal);
	                $sheet->setCellValueExplicit('Q'.$x, $ownersdetails, PHPExcel_Cell_DataType::TYPE_STRING);
	                $sheet->setCellValueExplicit('R'.$x, $rent);
					$sheet->getStyle('R'.$x)
      ->getNumberFormat()
      ->setFormatCode('₹#,##0.00');
	               
                      $x++;
                      $appl1=$appl1+$appl;$stud_total+=$row['stud_total'];$capacity+=$row['capacity'];$actual_capacity+=$row['actual_capacity'];
                       $deposit_fees+= $row['deposit_fees'];$actual_fees+= $row['actual_fees'];$gym_fees+= $row['gym_fees'];$fine_fees+= $row['fine_fees'];$excemption_fees+= $row['excemption_fees'];$opening_balance+= $row['opening_balance'];$fees_paid+= $row['fees_paid'];
                      $rowno++;
                    }
                     
                     $object->getActiveSheet()->setCellValue('A'.$x, 'Total');
					  $object->getActiveSheet()->setCellValue('E'.$x,$capacity);
                     $object->getActiveSheet()->setCellValue('D'.$x,$actual_capacity);
                    
                     $object->getActiveSheet()->setCellValue('F'.$x,$stud_total);
                     $object->getActiveSheet()->setCellValue('G'.$x,($capacity-$stud_total));
	                 $object->getActiveSheet()->setCellValue('H'.$x,$deposit_fees);
	                 $object->getActiveSheet()->setCellValue('I'.$x,$actual_fees);
	                 $object->getActiveSheet()->setCellValue('J'.$x,$excemption_fees);
	                 $object->getActiveSheet()->setCellValue('K'.$x,$gym_fees);
	                 $object->getActiveSheet()->setCellValue('L'.$x,$fine_fees);
	                 $object->getActiveSheet()->setCellValue('M'.$x,$opening_balance);
	                 $object->getActiveSheet()->setCellValue('N'.$x,$appl1);
	                 $object->getActiveSheet()->setCellValue('O'.$x,$fees_paid);
	                 $object->getActiveSheet()->setCellValue('P'.$x,($appl1-$fees_paid));
	                 $object->getActiveSheet()->mergeCells('A'.$x.':C'.$x);
	                 
	                  $object->getActiveSheet()->getStyle('A'.$x.':R'.$x)->getFont()->setBold(true);
                    $object->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

foreach(range('A','R') as $columnID)
{
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Apply borders and wrap text for Owner column
$sheet->getStyle('A4:R'.$x)->applyFromArray($styleArray);
$sheet->getStyle('Q5:R'.$x)->getAlignment()->setWrapText(true);    
	                  
	                $filename='Hostel Statistics Fees-'.$academic_year.'.xls'; //save our workbook as this file name
	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
	                //if you want to save it as .XLSX Excel 2007 format
	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 
	                //force user to download the Excel file without writing it to server's HD
	                $objWriter->save('php://output');
exit();
}
else if($report_type=="6")
{
  
                    $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip Foundation-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Hostel Fees Refund Details -'.$campus);
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
				
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4', 'Organization');
	                $object->getActiveSheet()->setCellValue('E4', 'Institute');
	                $object->getActiveSheet()->setCellValue('F4', 'Course');
	                $object->getActiveSheet()->setCellValue('G4', 'Stream');
	                $object->getActiveSheet()->setCellValue('H4', 'Year');
	                $object->getActiveSheet()->setCellValue('I4', 'Paid By');
	                $object->getActiveSheet()->setCellValue('J4', 'DD/CHQ No');
	                $object->getActiveSheet()->setCellValue('K4', 'Date');
	                $object->getActiveSheet()->setCellValue('L4', 'Bank Name');
	                $object->getActiveSheet()->setCellValue('M4', 'Amount');
	                $object->getActiveSheet()->setCellValue('N4', 'Remark');
	               /*  $object->getActiveSheet()->setCellValue('O4', 'Paid');
	                $object->getActiveSheet()->setCellValue('P4', 'Pending'); */
	    
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:N1');
	                $object->getActiveSheet()->mergeCells('A2:N2');
	                $object->getActiveSheet()->mergeCells('A3:N3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:N4')->getFont()->setBold(true);

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
                    $deposit_fees=0; $actual_fees=0; $gym_fees=0; $fine_fees=0; $excemption_fees=0; $opening_balance=0;$fees_paid=0;$appl1=0;$stud_total=0;$capacity=0;$actual_capacity=0;
                    foreach($fees as $row){
						
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                    $object->getActiveSheet()->setCellValue('B'.$x,$row['enrollment_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['first_name'].'  '.$row['middle_name'].'  '.$row['last_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['organisation']);
	                $object->getActiveSheet()->setCellValue('E'.$x,$row['intitute']);
	                $object->getActiveSheet()->setCellValue('F'.$x,$row['course']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['stream']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['year']);
	                $object->getActiveSheet()->setCellValue('I'.$x, $row['fees_paid_type']);
	                $object->getActiveSheet()->setCellValue('J'.$x, $row['ddno']);
	                $object->getActiveSheet()->setCellValue('K'.$x, $row['fdate']);
	                $object->getActiveSheet()->setCellValue('L'.$x, $row['bank_name']);
	                $object->getActiveSheet()->setCellValue('M'.$x, $row['amount']);
	                $object->getActiveSheet()->setCellValue('N'.$x, $row['remark']);
	                $x++;
					
                      $rowno++;
                    }
                     
                    /*  $object->getActiveSheet()->setCellValue('A'.$x, 'Total');
                     $object->getActiveSheet()->setCellValue('D'.$x,$actual_capacity);
                     $object->getActiveSheet()->setCellValue('E'.$x,$capacity);
                     $object->getActiveSheet()->setCellValue('F'.$x,$stud_total);
                     $object->getActiveSheet()->setCellValue('G'.$x,($capacity-$stud_total));
	                 $object->getActiveSheet()->setCellValue('H'.$x,$deposit_fees);
	                 $object->getActiveSheet()->setCellValue('I'.$x,$actual_fees);
	                 $object->getActiveSheet()->setCellValue('J'.$x,$excemption_fees);
	                 $object->getActiveSheet()->setCellValue('K'.$x,$gym_fees);
	                 $object->getActiveSheet()->setCellValue('L'.$x,$fine_fees);
	                 $object->getActiveSheet()->setCellValue('M'.$x,$opening_balance);
	                 $object->getActiveSheet()->setCellValue('N'.$x,$appl1);
	                 $object->getActiveSheet()->setCellValue('O'.$x,$fees_paid);
	                 $object->getActiveSheet()->setCellValue('P'.$x,($appl1-$fees_paid));
	                 $object->getActiveSheet()->mergeCells('A'.$x.':C'.$x); */
	                 
	                  $object->getActiveSheet()->getStyle('A'.$x.':N'.$x)->getFont()->setBold(true);
                    $object->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

foreach(range('A','N') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

  $object->getActiveSheet()->getStyle('A1:N'.$x)->applyFromArray($styleArray);    
	                  
	                $filename='Hostel Fees Refund Details-'.$academic_year.'.xls'; //save our workbook as this file name
	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
	                //if you want to save it as .XLSX Excel 2007 format
	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 
	                //force user to download the Excel file without writing it to server's HD
	                $objWriter->save('php://output');
exit();
}


?>