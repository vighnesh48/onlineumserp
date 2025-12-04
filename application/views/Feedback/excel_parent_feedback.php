<?php

                    $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University -Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Parent Feedback Details');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:Winter-2017');
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN No');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4','School');
	                $object->getActiveSheet()->setCellValue('E4', 'Course');
	                $object->getActiveSheet()->setCellValue('F4', 'Stream');
	                $object->getActiveSheet()->setCellValue('G4', 'Year');
	                $object->getActiveSheet()->setCellValue('H4', 'FeedBack Date');
	                $object->getActiveSheet()->setCellValue('I4', 'Faculty Advisor');
	                $object->getActiveSheet()->setCellValue('J4', 'Academics');
	                $object->getActiveSheet()->setCellValue('K4', 'Transport');
	                $object->getActiveSheet()->setCellValue('L4', 'Hostel');
	                $object->getActiveSheet()->setCellValue('M4', 'Canteen');
	                $object->getActiveSheet()->setCellValue('N4', 'Admin Support');
	                $object->getActiveSheet()->setCellValue('O4', 'Suggestion');
	             
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:O1');
	                $object->getActiveSheet()->mergeCells('A2:O2');
	                $object->getActiveSheet()->mergeCells('A3:O3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:O4')->getFont()->setBold(true);
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
                    foreach($summary as $row){
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                    $object->getActiveSheet()->setCellValue('B'.$x, $row['prn']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['parent_of']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['school_short_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['course_short_name']);
	                $object->getActiveSheet()->setCellValue('F'.$x, $row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['current_year']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['f_date']);
	                $object->getActiveSheet()->setCellValue('I'.$x,$row['faculty_advisor1']);
	                $object->getActiveSheet()->setCellValue('J'.$x, $row['academic1']);
	                $object->getActiveSheet()->setCellValue('K'.$x, $row['transport1']);
	                $object->getActiveSheet()->setCellValue('L'.$x, $row['hostel1']);
	                $object->getActiveSheet()->setCellValue('M'.$x, $row['canteen1']);
	                $object->getActiveSheet()->setCellValue('N'.$x, $row['admin_support1']);
	                $object->getActiveSheet()->setCellValue('O'.$x, $row['COMMENT']);
                    $x++;
                    }
                    $object->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $object->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                $object->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	                $filename='Paren-Feedback.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              



?>