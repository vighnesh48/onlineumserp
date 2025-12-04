<?php


	$this->load->library('excel'); // Make sure PHPExcel or PhpSpreadsheet is correctly set up
	
	// Create new Excel file
	// Create new Excel file
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("Your Name")
							 ->setTitle("Canteen Allocated Students")
							 ->setDescription("List of canteen allocated students.");

	// Set organization name based on the value of $org
	$org = $this->data['stud_details']['org'];
	if ($org == 'SU') {
	$org = 'Sandip University';
	} else if ($org == 'SF') {
	$org = 'Sandip Foundation';
	} else if ($org == 'SF-SIJOUL') {
	$org = 'Sandip Foundation Sijoul';
	} else {
	$org = 'For All Campus';
	}

	// Set values for the first rows
	$objPHPExcel->getActiveSheet()->setCellValue('A1', $org);
	$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Canteen Student Details for the academic year - ' . $this->data['stud_details']['acyear']);

	$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Sr.No');
	$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Student PRN');
	$objPHPExcel->getActiveSheet()->setCellValue('C3', 'Punching PRN');
	$objPHPExcel->getActiveSheet()->setCellValue('D3', 'Name');
	$objPHPExcel->getActiveSheet()->setCellValue('E3', 'Gender');
	$objPHPExcel->getActiveSheet()->setCellValue('F3', 'Current Year');
	$objPHPExcel->getActiveSheet()->setCellValue('G3', 'Course');
	$objPHPExcel->getActiveSheet()->setCellValue('H3', 'School');
	$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Mobile');
	$objPHPExcel->getActiveSheet()->setCellValue('J3', 'Canteen');

	// Merge cells
	$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
	$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');

	// Center align the merged cells and make fonts bold
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(16);
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true)->setSize(16);

	// Fill the student data
	$rowno = 1;
	$x = 4;

	foreach ($canteen_mapped_students as $student) {
	$rowno;
	$sname = $student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['last_name'];
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $x, $rowno);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $x, $student['enrollment_no']. ' ');
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $x, $student['punching_prn']);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $x, ' ' . $sname);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $x, $student['gender']);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $x, $student['current_year']);
	$objPHPExcel->getActiveSheet()->setCellValue('G' . $x, $student['stream_name']);
	$objPHPExcel->getActiveSheet()->setCellValue('H' . $x, $student['school_name']);
	$objPHPExcel->getActiveSheet()->setCellValue('I' . $x, $student['mobile']);
	$objPHPExcel->getActiveSheet()->setCellValue('J' . $x, $student['canteen_name']);
	$rowno++;
	$x++;
	}


	// Apply formatting and set auto column width
	foreach (range('A', 'R') as $columnID) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	}

	// Save the Excel file and output it
	$filename = 'Canteen_student_details.xls';
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="' . $filename . '"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');

  



?>