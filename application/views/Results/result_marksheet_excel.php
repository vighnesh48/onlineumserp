<?php	
$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);
$object->getActiveSheet()->setCellValue('A1', 'Sandip University -Nashik');
$object->getActiveSheet()->setCellValue('A2', 'OFFICE OF THE CONTROLLER OF EXAMINATIONS END SEMESTER EXAMINATION RESULTS - '.$exam_month.' '.$exam_year);

$object->getActiveSheet()->setCellValue('A3', 'Stream: '.$StreamShortName[0]['stream_short_name']);
$object->getActiveSheet()->setCellValue('D3', 'SEMESTER: '.$semester);

$object->getActiveSheet()->setCellValue('A4', 'Sr.No');
$object->getActiveSheet()->setCellValue('B4', 'PRN');
$object->getActiveSheet()->setCellValue('C4', 'Name of the Candidate');
ini_set('memory_limit', '512M');
$r =3;
$c = 6;
$d=3;

$int=3;
$ext=4;
$tot=5;
$grade=6;

$alpha =array('A','B','C','D','E','F','G','H','I','J','k','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','Ak','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
//echo $alpha[5];exit;
$sub_cnt = count($sem_subjects) *4; // subject count
$sub_cnt =3+$sub_cnt;
foreach($sem_subjects as $subj) {
    $sub_code =$subj['subject_short_name'];
	$sub_name =$subj['subject_code'];
	$theory_max =$subj['theory_max'];
	$internal_max =$subj['internal_max'];
	$rw = (string)$alpha[$r].'4:'.$alpha[$c].'4';
	$object->getActiveSheet()->mergeCells($rw);
	$object->getActiveSheet()->setCellValue($alpha[$r].'4', $sub_name.'('.$sub_code.') INT-'.$internal_max.', EXT:'.$theory_max);

	$object->getActiveSheet()->setCellValue($alpha[$int].'5', 'INT');
	 $object->getActiveSheet()->setCellValue($alpha[$ext].'5', 'EXT');
	 $object->getActiveSheet()->setCellValue($alpha[$tot].'5', 'TOT');
	 $object->getActiveSheet()->setCellValue($alpha[$grade].'5', 'GRD');

	$r=$r+4;
	$c = $c+4;
	$int=$int+4;
	$ext=$ext+4;
	$tot=$tot+4;
	$grade=$grade+4;
}

//$object->getActiveSheet()->mergeCells(D4:G4);
//merge cell A1 until C1

$object->getActiveSheet()->mergeCells('A1:'.$alpha[$sub_cnt].'1');
$object->getActiveSheet()->mergeCells('A2:'.$alpha[$sub_cnt].'2');
$object->getActiveSheet()->mergeCells('D3:'.$alpha[$sub_cnt].'3');
$object->getActiveSheet()->mergeCells('A3:C3');

$object->getActiveSheet()->mergeCells('A4:A5');
$object->getActiveSheet()->mergeCells('B4:B5');
$object->getActiveSheet()->mergeCells('C4:C5');

//set aligment to center for that merged cell (A1 to C1)
$object->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$object->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$object->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//make the font become bold
		
$object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
$object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

for($col = ord('A'); $col <= ord('N'); $col++){ //set column dimension 
	$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
	if($col=='B' || $col=='C'){
	
	}else{
		//$object->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
	}
			
}
		
//retrive contries table data
$CI =& get_instance();
$CI->load->model('Results_model');
$rowno=1;
$x=6;
	 
foreach($result_info as $row){
	$studentid = $row['student_id'];
	$stud_name = strtoupper($row['first_name'].' '.$row['middle_name'].' '.$row['last_name']);
	$object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	$object->getActiveSheet()->setCellValue('B'.$x, ' '.$row['enrollment_no']);
	$object->getActiveSheet()->setCellValue('C'.$x,$stud_name);
 	//echo '<pre>';
 //print_r($row['sub']);
$int1=3;
$ext1=4;
$tot1=5;
$grade1=6;	

	foreach($sem_subjects as $sb) {
		$subject_id = $sb['subject_id'];
		$sub_mrks =$this->Results_model->fetch_stud_sub_marks($studentid, $subject_id,$exam_id);
		$col_int =(string)$alpha[$int1].$x;
		if($sub_mrks[0]['cia_marks']==NULL){
			$ciamrks='-';
		}else{
			$ciamrks=$sub_mrks[0]['cia_marks'];
		}
		if($sub_mrks[0]['exam_marks']==NULL){
			$thmrks='-';
		}else{		
			$thmrks=$sub_mrks[0]['exam_marks'];
		}
		
		if(!empty($sub_mrks[0]['final_grade'])){
	    	 //exit;
			$object->getActiveSheet()->setCellValue($col_int, $ciamrks);
			$object->getActiveSheet()->setCellValue($alpha[$ext1].$x, $thmrks);
			$object->getActiveSheet()->setCellValue($alpha[$tot1].$x, $sub_mrks[0]['final_garde_marks']);
			$object->getActiveSheet()->setCellValue($alpha[$grade1].$x, $sub_mrks[0]['final_grade']);
		}else{

			$object->getActiveSheet()->setCellValue($col_int, '-');
			$object->getActiveSheet()->setCellValue($alpha[$ext1].$x, '-');
			$object->getActiveSheet()->setCellValue($alpha[$tot1].$x, '-');
			$object->getActiveSheet()->setCellValue($alpha[$grade1].$x, '-');
		}
		$int1=$int1+4;
		$ext1=$ext1+4;
		$tot1=$tot1+4;
		$grade1=$grade1+4;
	}


	$x++;
	//exit;
}
//exit;
// $object->getActiveSheet()->mergeCells('A'.$x.':E'.$x);
// $object->getActiveSheet()->setCellValue('A'.$x,'TOTAL');
// $object->getActiveSheet()->setCellValue('F'.$x, array_sum($arr));

for($k=0; $k<$x+1; $k++){
	$object->getActiveSheet()->getStyle("A".$k.":".$alpha[$sub_cnt].$k)->applyFromArray(
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
// foreach(range('A','H') as $columnID)
// {
//      $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
// }
$fname = $StreamShortName[0]['stream_short_name'].'_'.$semester.'_'.$exam_month.'_'.$exam_year;

$filename= 'Result_'.$fname.'.xls'; //save our workbook as this file name

// Required headers
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Save output
$writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
$writer->save('php://output');
exit;
?>