<?php
	
$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);
$object->getActiveSheet()->setCellValue('A1', 'Sandip University -Nashik');
$object->getActiveSheet()->setCellValue('A2', 'OFFICE OF THE CONTROLLER OF EXAMINATIONS END SEMESTER EXAMINATION RESULTS - '.$session);

$object->getActiveSheet()->setCellValue('A3', 'Stream: '.$StreamShortName[0]['stream_short_name']);
$object->getActiveSheet()->setCellValue('D3', 'SEMESTER: '.$semester);

$object->getActiveSheet()->setCellValue('A4', 'Sr.No');
$object->getActiveSheet()->setCellValue('B4', 'PRN');
$object->getActiveSheet()->setCellValue('C4', 'Name of the Candidate');
ini_set('memory_limit', '512M');
$r =3;
$c = 4;
$d=3;

$int=3;
$ext=4;


$alpha =array('A','B','C','D','E','F','G','H','I','J','k','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','Ak','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','Bk','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','Ck','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ');
//echo $alpha[5];exit;
$sub_cnt = count($sem_subjects) *2; // subject count
$sub_cnt =2+$sub_cnt;
foreach($sem_subjects as $subj) {
    $sub_code =$subj['subject_short_name'];
	$sub_name =$subj['subject_code'];
	$theory_max =$subj['theory_max'];
	$internal_max =$subj['internal_max'];
	$rw = (string)$alpha[$r].'4:'.$alpha[$c].'4';
	$object->getActiveSheet()->mergeCells($rw);
	$object->getActiveSheet()->setCellValue($alpha[$r].'4', $sub_name.'('.$sub_code.')');

	$object->getActiveSheet()->setCellValue($alpha[$int].'5', 'CIA');
	 $object->getActiveSheet()->setCellValue($alpha[$ext].'5', 'ATT(%)');

	$r=$r+2;
	$c = $c+2;
	$int=$int+2;
	$ext=$ext+2;

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
	$studentid = $row['stud_id'];
	$stud_name = strtoupper($row['first_name'].' '.$row['middle_name'].' '.$row['last_name']);
	$object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	$object->getActiveSheet()->setCellValue('B'.$x, ' '.$row['enrollment_no']);
	$object->getActiveSheet()->setCellValue('C'.$x,$stud_name);
 	//echo '<pre>';
 //print_r($row['sub']);
$int1=3;
$ext1=4;


	foreach($sem_subjects as $sb) {
		$subject_id = $sb['subject_id'];
		$sub_mrks =$this->Marks_model->fetchstudentsubCIAmarks($studentid, $subject_id,$exam_month,$exam_year, $exam_id);
		$col_int =(string)$alpha[$int1].$x;
		if(!empty($sub_mrks[0]['cia_marks'])){
	    	 //exit;
			$object->getActiveSheet()->setCellValue($col_int, $sub_mrks[0]['cia_marks']);
			$object->getActiveSheet()->setCellValue($alpha[$ext1].$x, $sub_mrks[0]['attendance_marks']);
		}else{

			$object->getActiveSheet()->setCellValue($col_int, '-');
			$object->getActiveSheet()->setCellValue($alpha[$ext1].$x, '-');
		}
		$int1=$int1+2;
		$ext1=$ext1+2;
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
$fname = $StreamShortName[0]['stream_short_name'].'_'.$semester.'_'.$exam_sess[0]['exam_month'].'_'.$exam_sess[0]['exam_year'];

$filename= 'Result_'.$fname.'.xls'; //save our workbook as this file name

header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache


//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

//if you want to save it as .XLSX Excel 2007 format

$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

//force user to download the Excel file without writing it to server's HD

$objWriter->save('php://output');
  



?>