<?php

if($report_type=="1")
{
  
                    $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip Foundation-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Transport Fees List-'. $campus .'  '.$institute_name);
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN');
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

	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:Q1');
	                $object->getActiveSheet()->mergeCells('A2:Q2');
	                $object->getActiveSheet()->mergeCells('A3:Q3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:Q4')->getFont()->setBold(true);

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


foreach(range('A','Q') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}


  $object->getActiveSheet()->getStyle('A1:Q'.$x)->applyFromArray($styleArray);    
	                  

	                $filename='Transport Fees Collection-'.$academic_year.'.xls'; //save our workbook as this file name

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
                    $object->getActiveSheet()->setCellValue('A2', 'Transport Fees Student Wise-'. $campus .'  '.$institute_name);
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
	                $object->getActiveSheet()->setCellValue('J4', 'Transport Fees');
	                $object->getActiveSheet()->setCellValue('K4', 'Exemption');
	                $object->getActiveSheet()->setCellValue('L4', 'Gym Fees');
	                $object->getActiveSheet()->setCellValue('M4', 'Fine Fees');
	                $object->getActiveSheet()->setCellValue('N4', 'Opening Balance');
	                $object->getActiveSheet()->setCellValue('O4', 'Applicable');
	                $object->getActiveSheet()->setCellValue('P4', 'Paid');
	                $object->getActiveSheet()->setCellValue('Q4', 'Cancellation Charges');  
	                $object->getActiveSheet()->setCellValue('R4', 'Refund');
	                $object->getActiveSheet()->setCellValue('S4', 'Pending');
	                $object->getActiveSheet()->setCellValue('T4', 'Cancelled');
	                $object->getActiveSheet()->setCellValue('U4', 'Institute');
	                $object->getActiveSheet()->setCellValue('V4', 'Boarding Point');
	                $object->getActiveSheet()->setCellValue('W4', 'Campus');
	               

	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:W1');
	                $object->getActiveSheet()->mergeCells('A2:W2');
	                $object->getActiveSheet()->mergeCells('A3:W3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:W3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:W4')->getFont()->setBold(true);

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
                                      $bal =  $appl-$row['fees_paid'];
                                      $refund=0;
                                  }
                    
                    
                    
                  //  $bal=$appl-($row['fees_paid']+$row['canc_amount']);
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
	                $object->getActiveSheet()->setCellValue('Q'.$x,$row['cancellation_refund']);
	                $object->getActiveSheet()->setCellValue('R'.$x,$refund);
	                $object->getActiveSheet()->setCellValue('S'.$x,$bal);
	                $object->getActiveSheet()->setCellValue('T'.$x, $row['cancelled_facility']);
	                $object->getActiveSheet()->setCellValue('U'.$x, $row['intitute']);
	                $object->getActiveSheet()->setCellValue('V'.$x, $row['boarding_point']);
	                $object->getActiveSheet()->setCellValue('W'.$x, $row['campus']);
	           
	                
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

foreach(range('A','W') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

  $object->getActiveSheet()->getStyle('A1:W'.$x)->applyFromArray($styleArray);    
	                 
	                $filename='Transport Fees  StudentWise-'.$academic_year.'.xls'; //save our workbook as this file name
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
                    $object->getActiveSheet()->setCellValue('A2', 'Transport Institute Wise Statistics-'. $campus .'  '. $institute_name);
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'Organization');
	                $object->getActiveSheet()->setCellValue('C4', 'Institute');
	                $object->getActiveSheet()->setCellValue('D4', '#students');
	                $object->getActiveSheet()->setCellValue('E4', 'Transport Fees');
	                $object->getActiveSheet()->setCellValue('F4', 'Exemption');
	                $object->getActiveSheet()->setCellValue('G4', 'Opening Balance');
	                $object->getActiveSheet()->setCellValue('H4', 'Applicable');
	                $object->getActiveSheet()->setCellValue('I4', 'Paid');
	                $object->getActiveSheet()->setCellValue('J4', 'Pending');
	               /*  $object->getActiveSheet()->setCellValue('K4', '');
	                $object->getActiveSheet()->setCellValue('L4', '');
	                $object->getActiveSheet()->setCellValue('M4', ''); */
	    
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:J1');
	                $object->getActiveSheet()->mergeCells('A2:J2');
	                $object->getActiveSheet()->mergeCells('A3:J3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:J4')->getFont()->setBold(true);

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
                    $appl=($row['actual_fees']+$row['opening_balance'])-($row['excemption_fees']);
                    $bal=$appl-$row['fees_paid'];
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                    $object->getActiveSheet()->setCellValue('B'.$x,$row['organisation']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['college_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['stud_total']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['actual_fees']);
	                $object->getActiveSheet()->setCellValue('F'.$x, $row['excemption_fees']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['opening_balance']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $appl);
	                $object->getActiveSheet()->setCellValue('I'.$x, $row['fees_paid']);
	                $object->getActiveSheet()->setCellValue('J'.$x, $bal);
	                /* $object->getActiveSheet()->setCellValue('K'.$x, );
	                $object->getActiveSheet()->setCellValue('L'.$x,$row['']);
	                $object->getActiveSheet()->setCellValue('M'.$x,$); */
	               
                      $x++;
                      $appl1=$appl1+$appl;
					  $stud+=$row['stud_total'];
                       
					   $actual_fees+= $row['actual_fees'];
					   
					   $excemption_fees+= $row['excemption_fees'];
					   $opening_balance+= $row['opening_balance'];
					   $fees_paid+= $row['fees_paid'];
                      $rowno++;
                    }
                     
                     $object->getActiveSheet()->setCellValue('A'.$x, 'Total');
                     $object->getActiveSheet()->setCellValue('D'.$x,$stud);
	                 $object->getActiveSheet()->setCellValue('E'.$x,$actual_fees);
	                 $object->getActiveSheet()->setCellValue('F'.$x,$excemption_fees);
	                 $object->getActiveSheet()->setCellValue('G'.$x,$opening_balance);
	                 $object->getActiveSheet()->setCellValue('H'.$x,$appl1);
	                 $object->getActiveSheet()->setCellValue('I'.$x,$fees_paid);
	                 $object->getActiveSheet()->setCellValue('J'.$x,($appl1-$fees_paid));
	                /*  $object->getActiveSheet()->setCellValue('K'.$x,$);
	                 $object->getActiveSheet()->setCellValue('L'.$x,$);
	                 $object->getActiveSheet()->setCellValue('M'.$x,); */
	                 $object->getActiveSheet()->mergeCells('A'.$x.':C'.$x);
	                 
	                  $object->getActiveSheet()->getStyle('A'.$x.':J'.$x)->getFont()->setBold(true);
                    $object->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

foreach(range('A','J') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

  $object->getActiveSheet()->getStyle('A1:J'.$x)->applyFromArray($styleArray);    
	                  
	                $filename='Transport Inst Statistics Fees-'.$academic_year.'.xls'; //save our workbook as this file name
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
                    $object->getActiveSheet()->setCellValue('A2', 'Transport Outstanding Fees-'. $campus .'  '. $institute_name);
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN/Id');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4','Gender');
	                $object->getActiveSheet()->setCellValue('E4', 'Mobile');
	                $object->getActiveSheet()->setCellValue('F4', 'Organization');
	                $object->getActiveSheet()->setCellValue('G4', 'Stream');
	                $object->getActiveSheet()->setCellValue('H4', 'Year');
	                $object->getActiveSheet()->setCellValue('I4', 'Transport Fees');
	                $object->getActiveSheet()->setCellValue('J4', 'Exemption');
	                $object->getActiveSheet()->setCellValue('K4', 'Opening Balance');
	                $object->getActiveSheet()->setCellValue('L4', 'Applicable');
	                $object->getActiveSheet()->setCellValue('M4', 'Paid');
	                $object->getActiveSheet()->setCellValue('N4', 'Pending');
	                $object->getActiveSheet()->setCellValue('O4', 'Cancelled');
	                $object->getActiveSheet()->setCellValue('P4'.$x,'Institute');
	              /*   $object->getActiveSheet()->setCellValue('Q4', '');
	                $object->getActiveSheet()->setCellValue('R4', '');
                    $object->getActiveSheet()->setCellValue('S4'); */
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:P1');
	                $object->getActiveSheet()->mergeCells('A2:P2');
	                $object->getActiveSheet()->mergeCells('A3:P3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:P3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:P4')->getFont()->setBold(true);

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
                    $appl=($row['actual_fees']+$row['opening_balance'])-($row['excemption_fees']);
                    $bal=$appl-$row['fees_paid'];
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                    $object->getActiveSheet()->setCellValue('B'.$x,$row['enrollment_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['first_name'].'  '.$row['middle_name'].'  '.$row['last_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['gender']);
	                $object->getActiveSheet()->setCellValue('E'.$x,$row['mobile']);
	                $object->getActiveSheet()->setCellValue('F'.$x,$row['organisation']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['stream']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['year']);
	                $object->getActiveSheet()->setCellValue('I'.$x, $row['actual_fees']);
	                $object->getActiveSheet()->setCellValue('J'.$x, $row['excemption_fees']);
	                 $object->getActiveSheet()->setCellValue('K'.$x, $row['opening_balance']);
	                $object->getActiveSheet()->setCellValue('L'.$x, $appl);
	                $object->getActiveSheet()->setCellValue('M'.$x, $row['fees_paid']);
	                $object->getActiveSheet()->setCellValue('N'.$x, $bal);
	                $object->getActiveSheet()->setCellValue('O'.$x, $row['cancelled_facility']);
	                $object->getActiveSheet()->setCellValue('P'.$x,$row['intitute']);
	               /*  $object->getActiveSheet()->setCellValue('Q'.$x,$);
	                $object->getActiveSheet()->setCellValue('R'.$x, $);
	                $object->getActiveSheet()->setCellValue('S'.$x, $row['']); */
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

foreach(range('A','P') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

  $object->getActiveSheet()->getStyle('A1:P'.$x)->applyFromArray($styleArray);    
	                  

	                $filename='Transport Outstanding Fees-'.$academic_year.'.xls'; //save our workbook as this file name

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
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip Foundation-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Transport Statistics-'.$campus);
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
					
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'Boarding Point');
	                $object->getActiveSheet()->setCellValue('C4', 'Campus');
	                $object->getActiveSheet()->setCellValue('D4', 'Students Count');
	                $object->getActiveSheet()->setCellValue('E4', 'Transport');
	                $object->getActiveSheet()->setCellValue('F4', 'Exemption');
	                $object->getActiveSheet()->setCellValue('G4', 'Fine Fees');
	                $object->getActiveSheet()->setCellValue('H4', 'Opening Balance');
	                $object->getActiveSheet()->setCellValue('I4', 'Applicable');
	                $object->getActiveSheet()->setCellValue('J4', 'Paid');
	                $object->getActiveSheet()->setCellValue('K4', 'Pending');
	                /*$object->getActiveSheet()->setCellValue('L4', '');
	                $object->getActiveSheet()->setCellValue('M4', '');
	                $object->getActiveSheet()->setCellValue('N4', '');
	                $object->getActiveSheet()->setCellValue('O4', '');
	                $object->getActiveSheet()->setCellValue('P4', ''); */
	    
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:K1');
	                $object->getActiveSheet()->mergeCells('A2:K2');
	                $object->getActiveSheet()->mergeCells('A3:K3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:K4')->getFont()->setBold(true);

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
                    $appl=($row['actual_fees']+$row['opening_balance'])-($row['excemption_fees']);
                    $bal=$appl-$row['fees_paid'];
										
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                    $object->getActiveSheet()->setCellValue('B'.$x,$row['boarding_point']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['campus']);
	                $object->getActiveSheet()->setCellValue('D'.$x, $row['stud_total']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['actual_fees']);
	                $object->getActiveSheet()->setCellValue('F'.$x, $row['excemption_fees']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['fine_fees']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['opening_balance']);
	                $object->getActiveSheet()->setCellValue('I'.$x, $appl);
	                $object->getActiveSheet()->setCellValue('J'.$x, $row['fees_paid']);
	                $object->getActiveSheet()->setCellValue('K'.$x, $appl-$row['fees_paid']);
	              /*   $object->getActiveSheet()->setCellValue('L'.$x, $row['fine_fees']);
	                $object->getActiveSheet()->setCellValue('M'.$x, $row['opening_balance']);
	                $object->getActiveSheet()->setCellValue('N'.$x, $appl);
	                $object->getActiveSheet()->setCellValue('O'.$x,$row['fees_paid']);
	                $object->getActiveSheet()->setCellValue('P'.$x,$bal); */
	               
                      $x++;
                      $appl1=$appl1+$appl;
					  $stud_total+=$row['stud_total'];
					  
                    
					   $actual_fees+= $row['actual_fees'];
					   
					   $fine_fees+= $row['fine_fees'];
					   $excemption_fees+= $row['excemption_fees'];
					   $opening_balance+= $row['opening_balance'];
					   $fees_paid+= $row['fees_paid'];
                      $rowno++;
                    }
                     
                     $object->getActiveSheet()->setCellValue('A'.$x, 'Total');
                     $object->getActiveSheet()->setCellValue('D'.$x,$stud_total);
                     $object->getActiveSheet()->setCellValue('E'.$x,$actual_fees);
                     $object->getActiveSheet()->setCellValue('F'.$x,$excemption_fees);
                     $object->getActiveSheet()->setCellValue('G'.$x,$fine_fees);
	                 $object->getActiveSheet()->setCellValue('H'.$x,$opening_balance);
	                 $object->getActiveSheet()->setCellValue('I'.$x,$appl1);
	                 $object->getActiveSheet()->setCellValue('J'.$x,$fees_paid);
	                 $object->getActiveSheet()->setCellValue('K'.$x,($appl1-$fees_paid));
	                 /* $object->getActiveSheet()->setCellValue('L'.$x,$);
	                 $object->getActiveSheet()->setCellValue('M'.$x,$);
	                 $object->getActiveSheet()->setCellValue('N'.$x,$);
	                 $object->getActiveSheet()->setCellValue('O'.$x,$);
	                 $object->getActiveSheet()->setCellValue('P'.$x,); */
	                 $object->getActiveSheet()->mergeCells('A'.$x.':C'.$x);
	                 
	                  $object->getActiveSheet()->getStyle('A'.$x.':K'.$x)->getFont()->setBold(true);
                    $object->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

foreach(range('A','K') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

  $object->getActiveSheet()->getStyle('A1:K'.$x)->applyFromArray($styleArray);    
	                  
	                $filename='Transport Statistics Fees-'.$academic_year.'.xls'; //save our workbook as this file name
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