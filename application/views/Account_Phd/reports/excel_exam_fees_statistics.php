<?php


                    $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Examination Fees Report');
                    $object->getActiveSheet()->setCellValue('A3', 'Exam Session:'.$exam_session);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'School');
	                $object->getActiveSheet()->setCellValue('C4', 'Course');
	                $object->getActiveSheet()->setCellValue('D4','Stream');
	                $object->getActiveSheet()->setCellValue('E4', 'Year');
	                $object->getActiveSheet()->setCellValue('F4', 'Sem');
	                $object->getActiveSheet()->setCellValue('G4', 'Student Total');
	                $object->getActiveSheet()->setCellValue('H4', 'Exam Fees');
	                $object->getActiveSheet()->setCellValue('I4', 'Late Fees');
	                $object->getActiveSheet()->setCellValue('J4', 'Fees Collected');
	                $object->getActiveSheet()->setCellValue('K4', 'Fine ');
	                $object->getActiveSheet()->setCellValue('L4', 'Batch ');


	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:L1');
	                $object->getActiveSheet()->mergeCells('A2:L2');
	                $object->getActiveSheet()->mergeCells('A3:L3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:L4')->getFont()->setBold(true);

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
                    $exam_fees= 0;
                    $collection= 0;
                    $fine= 0; $late=0;$stud=0;
                    foreach($fees_data as $row){
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                    $object->getActiveSheet()->setCellValue('B'.$x, $row['school_short_name']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['course_short_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['current_year']);
	                $object->getActiveSheet()->setCellValue('F'.$x, $row['semester']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['stud_total']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['exam_fees']);
	                $object->getActiveSheet()->setCellValue('I'.$x, $row['late_fees']);
	                $object->getActiveSheet()->setCellValue('J'.$x, $row['exam_fees_total']);
	                $object->getActiveSheet()->setCellValue('K'.$x,$row['fine']);
	                $object->getActiveSheet()->setCellValue('L'.$x,$row['admission_session']);
	                
                  $x++;
                
                  $exam_fees+= $row['exam_fees'];
                  $collection+= $row['exam_fees_total'];
                  $fine+= $row['fine'];
                  $late+= $row['late_fees'];
                  $stud+=$row['stud_total'];
                  $rowno++;
                    }
                    
                   
                     $object->getActiveSheet()->setCellValue('A'.$x,'Total');
                     $object->getActiveSheet()->mergeCells('A'.$x.':F'.$x);
                     $object->getActiveSheet()->setCellValue('G'.$x, $stud);
                     $object->getActiveSheet()->setCellValue('H'.$x, $exam_fees);
                     $object->getActiveSheet()->setCellValue('I'.$x, $late);
                     $object->getActiveSheet()->setCellValue('J'.$x, $collection);
                     $object->getActiveSheet()->setCellValue('K'.$x,$fine);
                     $object->getActiveSheet()->getStyle('A'.$x.':L'.$x)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
                     $object->getActiveSheet()->getStyle('A'.$x.':L'.$x)->getFont()->setSize(14);
                     $object->getActiveSheet()->getStyle('A'.$x.':L'.$x)->getFont()->setBold(true);
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
     
     
     
  $object->getActiveSheet()->getStyle('A1:L'.$x)->applyFromArray($styleArray);    
	                  

	                $filename='Examination Fees Report:'.$exam_session.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
	   


?>