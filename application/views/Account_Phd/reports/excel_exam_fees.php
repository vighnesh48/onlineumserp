<?php



                    $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Examination Fees List');
                    $object->getActiveSheet()->setCellValue('A3', 'Exam Session:'.$exam_session);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN No');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4','School');
	                $object->getActiveSheet()->setCellValue('E4', 'Course');
	                $object->getActiveSheet()->setCellValue('F4', 'Stream');
	                $object->getActiveSheet()->setCellValue('G4', 'Year');
	                $object->getActiveSheet()->setCellValue('H4', 'Receipt No');
	                $object->getActiveSheet()->setCellValue('I4', 'Paid By');
	                $object->getActiveSheet()->setCellValue('J4', 'DD/CHQ No');
	                $object->getActiveSheet()->setCellValue('K4', 'Dated');
	                $object->getActiveSheet()->setCellValue('L4', 'Amount');
	                 $object->getActiveSheet()->setCellValue('M4', 'Late Fees/Fine');
	                $object->getActiveSheet()->setCellValue('N4', 'Bank');
	                $object->getActiveSheet()->setCellValue('O4', 'Branch');
	                $object->getActiveSheet()->setCellValue('P4', 'Fees Cancelled');

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
                    foreach($fees_data as $row){
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                    $object->getActiveSheet()->setCellValue('B'.$x, "'".$row['enrollment_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['student_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['school_short_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['course_short_name']);
	                $object->getActiveSheet()->setCellValue('F'.$x, $row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['current_year']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['college_receiptno']);
	                $object->getActiveSheet()->setCellValue('I'.$x,$row['fees_paid_type']);
	                $object->getActiveSheet()->setCellValue('J'.$x, $row['receipt_no']);
	                $object->getActiveSheet()->setCellValue('K'.$x, $row['fdate']);
	                $object->getActiveSheet()->setCellValue('L'.$x, $row['amount']);
	                $object->getActiveSheet()->setCellValue('M'.$x, $row['exam_fee_fine']);
	                $object->getActiveSheet()->setCellValue('N'.$x,$row['bank_name']);
	                $object->getActiveSheet()->setCellValue('O'.$x, $row['bank_city']);
	                $object->getActiveSheet()->setCellValue('P'.$x, $row['chq_cancelled']);
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
   
  $object->getActiveSheet()->getStyle('A1:P'.$x)->applyFromArray($styleArray);    
	                  

	                $filename='Examination Fees:'.$exam_session.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
	   


?>