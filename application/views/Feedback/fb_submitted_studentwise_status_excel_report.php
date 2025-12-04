<?php
	
		$this->load->library("excel");
		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$object->getActiveSheet()->setCellValue('A1', 'Sandip University -Nashik');
		$object->getActiveSheet()->setCellValue('A2', 'Student Feedback Report: '.$fbsession[0]['academic_type'].'-'.$fbsession[0]['academic_year']);
		$object->getActiveSheet()->setCellValue('A3', 'Stream: '.$strmdetails[0]['stream_short_name']);
		$object->getActiveSheet()->setCellValue('A4', 'Semester/Division : '.$semester.'/'.$division);
		
		$object->getActiveSheet()->setCellValue('A5', 'Sr.No');
		$object->getActiveSheet()->setCellValue('B5', 'PRN');
		$object->getActiveSheet()->setCellValue('C5', 'Student Name');
		$object->getActiveSheet()->setCellValue('D5', 'Status');
	

		//merge cell A1 until C1

		$object->getActiveSheet()->mergeCells('A1:D1');
		$object->getActiveSheet()->mergeCells('A2:D2');
		$object->getActiveSheet()->mergeCells('A3:D3');
		$object->getActiveSheet()->mergeCells('A4:D4');

		//set aligment to center for that merged cell (A1 to C1)
		$object->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//make the font become bold
		
		$object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

		for($col = ord('A'); $col <= ord('N'); $col++){ //set column dimension 
			$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
			if($col != ord('C')){
			$object->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
		}
		
		//retrive contries table data

		$rowno=1;
		$x=6;
			if(!empty($studcnt_submitted)){
				foreach($studcnt_submitted as $std){
					//echo $stud_checked;echo "<br>";
					$stud_submitted_id[]= $std['student_id']; 
				}
			}

		foreach($class_stud as $row){
			$Student = $row['first_name'].' '.$row['middle_name'].' '.$row['last_name'];//echo "<br>";
			if (in_array($row['stud_id'], $stud_submitted_id)){
					$status = 'Submitted';
				}else{
					$status = 'Not Submitted';
				}
			$object->getActiveSheet()->setCellValue('A'.$x,($rowno));
			$object->getActiveSheet()->setCellValue('B'.$x, ' '.$row['enrollment_no']);
			$object->getActiveSheet()->setCellValue('C'.$x,$Student);
			$object->getActiveSheet()->setCellValue('D'.$x, $status);

			

			$rowno++;
			$x++;
		}
		//exit;
		for($k=0; $k<$x; $k++){
		$object->getActiveSheet()->getStyle("A".$k.":D".$k)->applyFromArray(
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

		$filename= $strmdetails[0]['stream_short_name'].'_'.$semester.'_'.$division.'.xls'; //save our workbook as this file name

		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache


		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

		//if you want to save it as .XLSX Excel 2007 format

		$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

		//force user to download the Excel file without writing it to server's HD

		$objWriter->save('php://output');
  



?>