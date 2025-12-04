<?php
//echo $stud_data[0][0]['stream_name'];
//echo "<pre>";	print_r($stud_data);exit;
$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);
$object->getActiveSheet()->setCellValue('A1', 'Sandip University -Nashik');
$object->getActiveSheet()->setCellValue('A2', 'OFFICE OF THE CONTROLLER OF EXAMINATIONS MARKSCARD - '.$stud_data[0][0]['exam_month'].' '.$stud_data[0][0]['exam_year']);

$CI =& get_instance();
$CI->load->model('Marks_model');

$object->getActiveSheet()->setCellValue('A3', 'School: '.$stud_data[0][0]['school_name']);
$object->getActiveSheet()->setCellValue('C3', 'Stream: '.$stud_data[0][0]['stream_name']);
$object->getActiveSheet()->setCellValue('G3', 'Regulation: '.$stud_data[0][0]['admission_session']);		
//merge cell A1 until C1

$object->getActiveSheet()->mergeCells('A1:J1');
$object->getActiveSheet()->mergeCells('A2:J2');
$object->getActiveSheet()->mergeCells('A3:B3');
$object->getActiveSheet()->mergeCells('C3:F3');
$object->getActiveSheet()->mergeCells('G3:J3');
//set aligment to center for that merged cell (A1 to C1)
$object->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$object->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//make the font become bold
		
$object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
$object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

for($col = ord('A'); $col <= ord('N'); $col++){ //set column dimension 
	$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
	if($col=='B' || $col=='C'){
	
	}else{
		$object->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
	}
			
}
		
//retrive contries table data
		$object->getActiveSheet()->setCellValue('A4', 'NAME OF THE CANDIDATE');
		$object->getActiveSheet()->setCellValue('B4', 'PRN');
		$object->getActiveSheet()->setCellValue('C4', 'SEM');
		$object->getActiveSheet()->setCellValue('D4', 'COURSE CODE');
		$object->getActiveSheet()->setCellValue('E4', 'COURSE NAME');
		$object->getActiveSheet()->setCellValue('F4', 'ATTENDANCE GRADE');
		$object->getActiveSheet()->setCellValue('G4', 'CREDITS');
		$object->getActiveSheet()->setCellValue('H4', 'LETTER GRADE');
		$object->getActiveSheet()->setCellValue('I4', 'GRADE POINTS');
		$object->getActiveSheet()->setCellValue('J4', 'RESULT');
$rowno=1;
$x=4;
 $i=0; 
 foreach($stud_data as $stud){	
	$studcredits =$this->Marks_model->fetch_credits_earned($stud[0]['enrollment_no']);

	//$object->getActiveSheet()->setCellValue('A'.$x, 'Name of Candidate: '.$stud[0]['stud_name'].', PRN: '.$stud[0]['enrollment_no']);
	//$object->getActiveSheet()->setCellValue('B'.$x, 'PERMANENT REGISTRATION NO: '.$stud[0]['enrollment_no']);
	//$object->getActiveSheet()->setCellValue('C'.$x, 'DATE OF BIRTH: '.$stud[0]['dob']);
	/*$object->getActiveSheet()->setCellValue('C'.$x, 'School Name: '.$stud_data[$i]['school_short_name']);	
	$object->getActiveSheet()->setCellValue('E'.$x, 'Time: '.$slot_time);
	$object->getActiveSheet()->setCellValue('F'.$x, 'Stream: '.$stud_data[$i]['stream_name']);
	$object->getActiveSheet()->setCellValue('G'.$x, 'Semester: '.$stud_data[$i]['semester']);*/
	//$object->getActiveSheet()->mergeCells("A".$x.":H".$x);
	if(!empty($stud_data)){
		$x=$x+1;
	
		 foreach($stud as $val){
			 if($val['final_grade']=='U' || $val['final_grade']=='W' || $val['final_grade'] =='WH'){
				$grade = "RA";
			}else{
				$grade = "PASS";
			}
			if($val['final_grade']=='A+'){
				$grade_points = 9;
			}elseif($val['final_grade']=='A'){
				$grade_points = 8;
			}elseif($val['final_grade']=='B+'){
				$grade_points = 7;
			}elseif($val['final_grade']=='B'){
				$grade_points = 6;
			}elseif($val['final_grade']=='C+'){
				$grade_points = 5;
			}elseif($val['final_grade']=='C'){
				$grade_points = 4;
			}elseif($val['final_grade']=='U' || $val['final_grade']=='W'){
				$grade_points = 0;
			}else{
				$grade_points = 0;
			}
			//$x=$x+1;
			 $object->getActiveSheet()->setCellValue('A'.$x, ''.$val['stud_name']);
			 $object->getActiveSheet()->setCellValue('B'.$x, ' '.$val['enrollment_no']);
			 $object->getActiveSheet()->setCellValue('C'.$x, ''.$val['semester']);
			 $object->getActiveSheet()->setCellValue('D'.$x, ''.strtoupper($val['subject_code']));
			 $object->getActiveSheet()->setCellValue('E'.$x, ''.$val['subject_name']);
			 $object->getActiveSheet()->setCellValue('F'.$x, '');
			 $object->getActiveSheet()->setCellValue('G'.$x, ''.$val['credits']);
			 $object->getActiveSheet()->setCellValue('H'.$x, ''.$val['final_grade']);
			 $object->getActiveSheet()->setCellValue('I'.$x, ''.$grade_points);
			 $object->getActiveSheet()->setCellValue('J'.$x, ''.$grade);
			 
			 $x++;
		 }
	}
	//$x++;
}

for($k=0; $k<$x+1; $k++){
	$object->getActiveSheet()->getStyle("A".$k.":J".$k)->applyFromArray(
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
foreach(range('A','J') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
$filename= $stud_data[0][0]['stream_name'].'_'.$stud_data[0][0]['semester'].'_'.$stud_data[0][0]['exam_month'].'-'.$stud_data[0][0]['exam_year'].'_Markscards.xls'; //save our workbook as this file name

header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache


//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

//if you want to save it as .XLSX Excel 2007 format

$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

//force user to download the Excel file without writing it to server's HD

$objWriter->save('php://output');
  



?>