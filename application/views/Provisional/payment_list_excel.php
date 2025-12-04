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
                    $object->getActiveSheet()->setCellValue('A2', 'Provisional Admission Fees List-');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year: 2019-20');
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'Reg No');
	                $object->getActiveSheet()->setCellValue('C4', 'Form No');
	                $object->getActiveSheet()->setCellValue('D4', 'Student Name');
	                  $object->getActiveSheet()->setCellValue('E4','School');
	                    $object->getActiveSheet()->setCellValue('F4','Course');
	                $object->getActiveSheet()->setCellValue('G4','Program');
	                $object->getActiveSheet()->setCellValue('H4', 'Year');
	                $object->getActiveSheet()->setCellValue('I4', 'Receipt No');
	                $object->getActiveSheet()->setCellValue('J4', 'Paid By');
	                $object->getActiveSheet()->setCellValue('K4', 'DD/CHQ No');
	                $object->getActiveSheet()->setCellValue('L4', 'Dated');
	                $object->getActiveSheet()->setCellValue('M4', 'Amount');
	                $object->getActiveSheet()->setCellValue('N4', 'Bank');
	                $object->getActiveSheet()->setCellValue('O4', 'Branch');
	       $object->getActiveSheet()->setCellValue('P4', 'Fee Type');
 $object->getActiveSheet()->setCellValue('Q4', 'Admission Status');
  $object->getActiveSheet()->setCellValue('R4', 'Payment Status');
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:Q1');
	                $object->getActiveSheet()->mergeCells('A2:Q2');
	                $object->getActiveSheet()->mergeCells('A3:Q3');
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
                    foreach($payment_data as $row){
                        if($row['fees_paid_type']=="CHLN"){$bname='';} else{ $bname = $row['bank_name'];}
                   
                     if($row['payment_status']=="P"){$pstat='Pending';} if($row['payment_status']=="V"){ $pstat ='Verified';}
                   if($row['is_cancelled']=="Y"){$astat='Cancelled';} else{ $astat ='';}
                   
                    if($row['type_id']==2){$ftype = "Admission";}else{$ftype = "Hostel";}
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                    $object->getActiveSheet()->setCellValue('B'.$x, "  ".$row['prov_reg_no']);
					$object->getActiveSheet()->setCellValue('C'.$x, "  ".$row['adm_form_no']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['student_name']);
	                   $object->getActiveSheet()->setCellValue('E'.$x,$row['school_name']);
	                      $object->getActiveSheet()->setCellValue('F'.$x,$row['course_type']);
	                $object->getActiveSheet()->setCellValue('G'.$x,$row['sprogramm_name']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['admission_year']);
	                $object->getActiveSheet()->setCellValue('I'.$x, $row['college_receiptno']);
	                $object->getActiveSheet()->setCellValue('J'.$x,$row['fees_paid_type']);
	                $object->getActiveSheet()->setCellValue('K'.$x, $row['receipt_no']);
	                $object->getActiveSheet()->setCellValue('L'.$x, $row['fees_date']);
	                $object->getActiveSheet()->setCellValue('M'.$x, $row['amount']);
	                $object->getActiveSheet()->setCellValue('N'.$x,$bname);
	                $object->getActiveSheet()->setCellValue('O'.$x, $row['bank_city']);
	        $object->getActiveSheet()->setCellValue('P'.$x, $ftype);
	          $object->getActiveSheet()->setCellValue('Q'.$x,$astat);
	        $object->getActiveSheet()->setCellValue('R'.$x, $pstat);
	        
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
   
   foreach(range('A','R') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
  $object->getActiveSheet()->getStyle('A1:R'.$x)->applyFromArray($styleArray);    
	                  

	                $filename='Provisional Admission Fees List'.$academic_year.'.xls'; //save our workbook as this file name

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