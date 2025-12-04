<?php
$this->load->library("excel");
$object = new PHPExcel();
$rowno=1;
$x=4;
$worksheet=0;
$adm_year=$academic_fees_details[0]['admission_year'];

	$object->createSheet();
	$object->setActiveSheetIndex($worksheet);
	$object->getActiveSheet()->setTitle('AdmissionYear'.$academic_fees_details[0]['admission_year']);
	$object->getActiveSheet()->setCellValue('A1', 'Sandip University');
	$object->getActiveSheet()->setCellValue('A2', 'Fee Details for the academic year -'.$academic_fees_details[0]['academic_year']);	

	$object->getActiveSheet()->setCellValue('A3', 'Sr.No');
	$object->getActiveSheet()->setCellValue('B3', 'School Name');
	$object->getActiveSheet()->setCellValue('C3', 'Course Name');
	$object->getActiveSheet()->setCellValue('D3', 'Stream Name');
	$object->getActiveSheet()->setCellValue('E3', 'Admission Year');
		
	$arr=explode("-",$academic_fees_details[0]['admission_year']);
		$ac_year=$arr[0];
	
	if($ac_year<2018)
	{
		$object->getActiveSheet()->setCellValue('F3', 'Tution Fees');
		$object->getActiveSheet()->setCellValue('G3', 'Development');
		$object->getActiveSheet()->setCellValue('H3', 'Academic Fees');
		$object->getActiveSheet()->setCellValue('I3', 'Caution Money');
		$object->getActiveSheet()->setCellValue('J3', 'Admission Form');
		$object->getActiveSheet()->setCellValue('K3', 'Gymkhana');
		$object->getActiveSheet()->setCellValue('L3', 'Disaster Management');
		$object->getActiveSheet()->setCellValue('M3', 'Computerization');
		$object->getActiveSheet()->setCellValue('N3', 'Registration');
		$object->getActiveSheet()->setCellValue('O3', 'Student Safety Insurance');
		$object->getActiveSheet()->setCellValue('P3', 'Library');
		$object->getActiveSheet()->setCellValue('Q3', 'NSS');

		$object->getActiveSheet()->setCellValue('R3', 'Exam fees');
		$object->getActiveSheet()->setCellValue('S3', 'Total fees');
		//$object->getActiveSheet()->setCellValue('R3', 'Scholorship Allowed');
				

		//merge cell A1 until C1

		$object->getActiveSheet()->mergeCells('A1:S1');
		$object->getActiveSheet()->mergeCells('A2:S2');
		
		for($col = ord('A'); $col <= ord('S'); $col++){ //set column dimension 
			$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize();
		}
	}
	else
	{
		$object->getActiveSheet()->setCellValue('F3', 'Year');
		$object->getActiveSheet()->setCellValue('G3', 'Tution Fees');
		$object->getActiveSheet()->setCellValue('H3', 'Development');
		$object->getActiveSheet()->setCellValue('I3', 'Academic Fees');
		$object->getActiveSheet()->setCellValue('J3', 'Caution Money');
		$object->getActiveSheet()->setCellValue('K3', 'Admission Form');
		$object->getActiveSheet()->setCellValue('L3', 'Exam fees');
		$object->getActiveSheet()->setCellValue('M3', 'Student Safety Insurance');
		$object->getActiveSheet()->setCellValue('N3', 'Enrollment');
		$object->getActiveSheet()->setCellValue('O3', 'Sports & Ammenties');
		
		$object->getActiveSheet()->setCellValue('P3', 'Eligibility');
		$object->getActiveSheet()->setCellValue('Q3', 'Library');
		$object->getActiveSheet()->setCellValue('R3', 'Internet');
		$object->getActiveSheet()->setCellValue('S3', 'Industrial_visit');
		$object->getActiveSheet()->setCellValue('T3', 'Seminar training');
		$object->getActiveSheet()->setCellValue('U3', 'Student activity');
		$object->getActiveSheet()->setCellValue('V3', 'Lab ');
		$object->getActiveSheet()->setCellValue('W3', 'Total fees');
		//merge cell A1 until C1

		$object->getActiveSheet()->mergeCells('A1:W1');
		$object->getActiveSheet()->mergeCells('A2:W2');
		
		for($col = ord('A'); $col <= ord('V'); $col++){ //set column dimension 
			$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize();
		}
	}
	//set aligment to center for that merged cell (A1 to C1)
	$object->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$object->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	//make the font become bold
			
	$object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
	$object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
	$object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
	$object->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
	$object->getActiveSheet()->getStyle('A2')->getFont()->setSize(16);
	$object->getActiveSheet()->getStyle('A2')->getFill()->getStartColor()->setARGB('#333');

	
		
//below retrive table data
$count=0;
$last_academicy='';
$last_admissiony='';
for($i=0;$i<count($academic_fees_details);$i++){		 
	if($adm_year!=$academic_fees_details[$i]['admission_year'])
	{
		if($count==0)
		{
			if($ac_year<2018)
			{
				for($k=0; $k<$x; $k++){
				$object->getActiveSheet()->getStyle("A".$k.":S".$k)->applyFromArray(
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
				foreach(range('A','S') as $columnID)
				{
					 $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
				}
			}
			else
			{
				for($k=0; $k<$x; $k++){
				$object->getActiveSheet()->getStyle("A".$k.":W".$k)->applyFromArray(
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
				foreach(range('A','W') as $columnID)
				{
					 $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
				}
			}
			$count++;
		}
		else
		{
			$arr=explode("-",$academic_fees_details[$i]['admission_year']);
			$ac_year=$arr[0];
			if($ac_year<2018)
			{
				for($k=0; $k<$x; $k++){
				$object->getActiveSheet()->getStyle("A".$k.":S".$k)->applyFromArray(
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
				foreach(range('A','S') as $columnID)
				{
					 $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
				}
			}
			else
			{
				for($k=0; $k<$x; $k++){
				$object->getActiveSheet()->getStyle("A".$k.":W".$k)->applyFromArray(
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
				foreach(range('A','W') as $columnID)
				{
					 $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
				}
			}
		}
		
		
		$rowno=1;
		$x=4;
		$worksheet++;
		
		$object->createSheet();
		$object->setActiveSheetIndex($worksheet);
		$object->getActiveSheet()->setTitle('AdmissionYear'.$academic_fees_details[$i]['admission_year']);
		$object->getActiveSheet()->setCellValue('A1', 'Sandip University');
		$object->getActiveSheet()->setCellValue('A2', 'Fee Details for the academic year -'.$academic_fees_details[0]['academic_year']);	

		$object->getActiveSheet()->setCellValue('A3', 'Sr.No');
		$object->getActiveSheet()->setCellValue('B3', 'School Name');
		$object->getActiveSheet()->setCellValue('C3', 'Course Name');
		$object->getActiveSheet()->setCellValue('D3', 'Stream Name');
		$object->getActiveSheet()->setCellValue('E3', 'Admission Year');
		
		$arr=explode("-",$academic_fees_details[$i]['admission_year']);
		$ac_year=$arr[0];
	
		if($ac_year<2018)
		{
			$object->getActiveSheet()->setCellValue('F3', 'Tution Fees');
			$object->getActiveSheet()->setCellValue('G3', 'Development');
			$object->getActiveSheet()->setCellValue('H3', 'Academic Fees');
			$object->getActiveSheet()->setCellValue('I3', 'Caution Money');
			$object->getActiveSheet()->setCellValue('J3', 'Admission Form');
			$object->getActiveSheet()->setCellValue('K3', 'Gymkhana');
			$object->getActiveSheet()->setCellValue('L3', 'Disaster Management');
			$object->getActiveSheet()->setCellValue('M3', 'Computerization');
			$object->getActiveSheet()->setCellValue('N3', 'Registration');
			$object->getActiveSheet()->setCellValue('O3', 'Student Safety Insurance');
			$object->getActiveSheet()->setCellValue('P3', 'Library');
			$object->getActiveSheet()->setCellValue('Q3', 'NSS');

			$object->getActiveSheet()->setCellValue('R3', 'Exam fees');
			$object->getActiveSheet()->setCellValue('S3', 'Total fees');
			//$object->getActiveSheet()->setCellValue('R3', 'Scholorship Allowed');
					

			//merge cell A1 until C1

			$object->getActiveSheet()->mergeCells('A1:S1');
			$object->getActiveSheet()->mergeCells('A2:S2');
			
			for($col = ord('A'); $col <= ord('S'); $col++){ //set column dimension 
				$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize();
			}
		}
		else
		{
			$object->getActiveSheet()->setCellValue('F3', 'Year');
			$object->getActiveSheet()->setCellValue('G3', 'Tution Fees');
			$object->getActiveSheet()->setCellValue('H3', 'Development');
			$object->getActiveSheet()->setCellValue('I3', 'Academic Fees');
			$object->getActiveSheet()->setCellValue('J3', 'Caution Money');
			$object->getActiveSheet()->setCellValue('K3', 'Admission Form');
			$object->getActiveSheet()->setCellValue('L3', 'Exam fees');
			$object->getActiveSheet()->setCellValue('M3', 'Student Safety Insurance');
			$object->getActiveSheet()->setCellValue('N3', 'Enrollment');
			$object->getActiveSheet()->setCellValue('O3', 'Sports & Ammenties');
			$object->getActiveSheet()->setCellValue('P3', 'Eligibility');
			$object->getActiveSheet()->setCellValue('Q3', 'Library');
			$object->getActiveSheet()->setCellValue('R3', 'Internet');
			$object->getActiveSheet()->setCellValue('S3', 'Industrial_visit');
			$object->getActiveSheet()->setCellValue('T3', 'Seminar training');
			$object->getActiveSheet()->setCellValue('U3', 'Student activity');
			$object->getActiveSheet()->setCellValue('V3', 'Lab ');
			$object->getActiveSheet()->setCellValue('W3', 'Total fees');
			//merge cell A1 until C1

			$object->getActiveSheet()->mergeCells('A1:W1');
			$object->getActiveSheet()->mergeCells('A2:W2');
			
			for($col = ord('A'); $col <= ord('W'); $col++){ //set column dimension 
				$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize();
			}
		}

		//set aligment to center for that merged cell (A1 to C1)
		$object->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		//make the font become bold
				
		$object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
		$object->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$object->getActiveSheet()->getStyle('A2')->getFont()->setSize(16);
		$object->getActiveSheet()->getStyle('A2')->getFill()->getStartColor()->setARGB('#333');
		
		$adm_year=$academic_fees_details[$i]['admission_year'];
	}
	
		$sname = $academic_fees_details[$i]['stream_short_name'];

		$object->getActiveSheet()->setCellValue('A'.$x,($x-3));
		$object->getActiveSheet()->setCellValue('B'.$x, $academic_fees_details[$i]['school_name']);
		$object->getActiveSheet()->setCellValue('C'.$x, $academic_fees_details[$i]['course_name']);
		$object->getActiveSheet()->setCellValue('D'.$x, ' '.$sname);
		$object->getActiveSheet()->setCellValue('E'.$x, $academic_fees_details[$i]['admission_year']);
		
		
		$arr=explode("-",$academic_fees_details[$i]['admission_year']);
		$ac_year=$arr[0];

		if($ac_year<2018)
		{
			$object->getActiveSheet()->setCellValue('F'.$x, $academic_fees_details[$i]['tution_fees']);
			$object->getActiveSheet()->setCellValue('G'.$x, $academic_fees_details[$i]['development']);
			$object->getActiveSheet()->setCellValue('H'.$x, $academic_fees_details[$i]['academic_fees']);
			$object->getActiveSheet()->setCellValue('I'.$x, $academic_fees_details[$i]['caution_money']);
			$object->getActiveSheet()->setCellValue('J'.$x, $academic_fees_details[$i]['admission_form']);
			$object->getActiveSheet()->setCellValue('K'.$x, $academic_fees_details[$i]['Gymkhana']);
			$object->getActiveSheet()->setCellValue('L'.$x, $academic_fees_details[$i]['disaster_management']);
			$object->getActiveSheet()->setCellValue('M'.$x, $academic_fees_details[$i]['computerization']);
			$object->getActiveSheet()->setCellValue('N'.$x, $academic_fees_details[$i]['registration']);
			$object->getActiveSheet()->setCellValue('O'.$x, $academic_fees_details[$i]['student_safety_insurance']);
			$object->getActiveSheet()->setCellValue('P'.$x, $academic_fees_details[$i]['library']);
			$object->getActiveSheet()->setCellValue('Q'.$x, $academic_fees_details[$i]['nss']);
			$object->getActiveSheet()->setCellValue('R'.$x, $academic_fees_details[$i]['exam_fees']);
			$object->getActiveSheet()->setCellValue('S'.$x, $academic_fees_details[$i]['total_fees']);
		}
		else
		{
			$object->getActiveSheet()->setCellValue('F'.$x, $academic_fees_details[$i]['year']);
		$object->getActiveSheet()->setCellValue('G'.$x, $academic_fees_details[$i]['tution_fees']);
		$object->getActiveSheet()->setCellValue('H'.$x, $academic_fees_details[$i]['development']);
		$object->getActiveSheet()->setCellValue('I'.$x, $academic_fees_details[$i]['academic_fees']);
		$object->getActiveSheet()->setCellValue('J'.$x, $academic_fees_details[$i]['caution_money']);
		$object->getActiveSheet()->setCellValue('K'.$x, $academic_fees_details[$i]['admission_form']);
			$object->getActiveSheet()->setCellValue('L'.$x, $academic_fees_details[$i]['exam_fees']);
			$object->getActiveSheet()->setCellValue('M'.$x, $academic_fees_details[$i]['student_safety_insurance']);
			$object->getActiveSheet()->setCellValue('N'.$x, $academic_fees_details[$i]['registration']);
			$object->getActiveSheet()->setCellValue('O'.$x, $academic_fees_details[$i]['Gymkhana']);
			$object->getActiveSheet()->setCellValue('P'.$x, $academic_fees_details[$i]['eligibility']);
			$object->getActiveSheet()->setCellValue('Q'.$x, $academic_fees_details[$i]['library']);
			$object->getActiveSheet()->setCellValue('R'.$x, $academic_fees_details[$i]['internet']);
			$object->getActiveSheet()->setCellValue('S'.$x, $academic_fees_details[$i]['educational_industrial_visit']);
			$object->getActiveSheet()->setCellValue('T'.$x, $academic_fees_details[$i]['seminar_training']);
			$object->getActiveSheet()->setCellValue('U'.$x, $academic_fees_details[$i]['student_activity']);
			$object->getActiveSheet()->setCellValue('V'.$x, $academic_fees_details[$i]['lab']);
			$object->getActiveSheet()->setCellValue('W'.$x, $academic_fees_details[$i]['total_fees']);
		}
	
	$x++;
	$last_academicy=$academic_fees_details[$i]['academic_year'];
	$last_admissiony=$academic_fees_details[$i]['admission_year'];
}


$arr=explode("-",$last_admissiony);
$ac_year=$arr[0];
if($ac_year>=2018)
{
	for($k=0; $k<$x; $k++){
		$object->getActiveSheet()->getStyle("A".$k.":W".$k)->applyFromArray(
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
	foreach(range('A','W') as $columnID)
	{
		 $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	}
}
else
{
	for($k=0; $k<$x; $k++){
		$object->getActiveSheet()->getStyle("A".$k.":S".$k)->applyFromArray(
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
	foreach(range('A','S') as $columnID)
	{
		 $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	}
}

$filename= 'academic_fees_details.xls'; //save our workbook as this file name

header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache


//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

//if you want to save it as .XLSX Excel 2007 format

$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

//force user to download the Excel file without writing it to server's HD

$objWriter->save('php://output');
  
?>