<?php
$CI =& get_instance();
$CI->load->model('Attendance_model');	
$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);
$object->getActiveSheet()->setCellValue('A1', 'Sandip University -Nashik');
$object->getActiveSheet()->setCellValue('A2', 'FACULTYWISE LOAD REPORT FOR - '.strtoupper($attendance_data[0]['college_name']));
				
$object->getActiveSheet()->setCellValue('A3', 'Sr.No');
$object->getActiveSheet()->setCellValue('B3', 'Staff Id');
$object->getActiveSheet()->setCellValue('C3', 'Staff Name');
$object->getActiveSheet()->setCellValue('D3', 'Department');
$object->getActiveSheet()->setCellValue('E3', 'Designation');
//$object->getActiveSheet()->setCellValue('F3', 'Load(Norms)');
$object->getActiveSheet()->setCellValue('F3', 'Load Allocated');
$object->getActiveSheet()->setCellValue('G3', 'Excepted LECT Load');
$object->getActiveSheet()->setCellValue('H3', 'Lect. taken');
$object->getActiveSheet()->setCellValue('I3', 'ATT(%)');	

//merge cell A1 until C1

$object->getActiveSheet()->mergeCells('A1:I1');
$object->getActiveSheet()->mergeCells('A2:I2');

//set aligment to center for that merged cell (A1 to C1)
$object->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$object->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//make the font become bold
		
$object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
$object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

for($col = ord('A'); $col <= ord('N'); $col++){ //set column dimension 
	$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
	if($col=='B' || $col=='C'){
	
	}else{
		//$object->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
	}
			
}
		
//retrive contries table data

$rowno=1;
$x=4;
for($i=0;$i<count($attendance_data);$i++){	
	 
$subjects = $attendance_data[$i]['sublist'];
$faculty_code = $attendance_data[$i]['faculty_code'];
$faculty_name =strtoupper($attendance_data[$i]['fname'].'. '.$attendance_data[$i]['mname'][0].'. '.$attendance_data[$i]['lname']);

$lect_tkn_load =$this->Attendance_model->fetch_fac_taken_lect_load_excel($faculty_code, $academic_year,$from_date,$to_date);

//if(!empty($lect_tkn_load[0]['taken_lect_load'])){ $lect_t_load = $lect_tkn_load[0]['taken_lect_load'];}else{ $lect_t_load = "-";}
$srt_ltl='';
foreach($lect_tkn_load as $ltl){
	$tot_lect[] = $ltl['lslotcnt'];
	if($ltl['subject_component']=='TH' || $ltl['subject_component']=='EM'){
		$stype='TH';
	}else{
		$stype='PR';
	}
	$srt_ltl .= $stype.'='.$ltl['lslotcnt'].', ';
}
if(!empty($tot_lect)){
$str_ltl = array_sum($tot_lect).' ('.rtrim($srt_ltl,', ').')';
}else{
	$str_ltl ='-';
}
if($attendance_data[$i]['designation_name']=='Assistant Professor'){
$load_noms ='18';
}elseif($attendance_data[$i]['designation_name']=='Associate Professor'){
$load_noms ='16';
}
elseif($attendance_data[$i]['designation_name']=='Professor'){
$load_noms ='14';
}
elseif($attendance_data[$i]['designation_name']=='Dean'){
$load_noms ='01';
}else{
$load_noms ='';
}


if(!empty($attendance_data[$i]['tot_lecture_load'])){  
	$tot_lecture_load =$attendance_data[$i]['cnt_slot'];
}else{ 
	$tot_lecture_load = "-";
}
$attperc =number_format($attendance_data[$i]['att_percentage'], 2, '.', '');
$fromtime= $attendance_data[$i]['from_time'];
$totime= $attendance_data[$i]['to_time'];
	$ex_time = $fromtime.'-'.$totime;	
	$object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	$object->getActiveSheet()->setCellValue('B'.$x, $faculty_code);
	$object->getActiveSheet()->setCellValue('C'.$x, $faculty_name);
	$object->getActiveSheet()->setCellValue('D'.$x, $attendance_data[$i]['department_name']);
	$object->getActiveSheet()->setCellValue('E'.$x, $attendance_data[$i]['designation_name']);
	//$object->getActiveSheet()->setCellValue('F'.$x, $load_noms);
	$object->getActiveSheet()->setCellValue('F'.$x, $tot_lecture_load);
	$object->getActiveSheet()->setCellValue('G'.$x, $tot_lecture_load-$attendance_data[$i]['leaves']);
	$object->getActiveSheet()->setCellValue('H'.$x, $str_ltl);
	$object->getActiveSheet()->setCellValue('I'.$x, $attperc);
	$x++;
	unset($str_ltl);
	unset($tot_lect);
}


for($k=0; $k<$x+1; $k++){
	$object->getActiveSheet()->getStyle("A".$k.":I".$k)->applyFromArray(
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
$filename= 'Faculty_load_details.xls'; //save our workbook as this file name

header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache


//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

//if you want to save it as .XLSX Excel 2007 format

$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

//force user to download the Excel file without writing it to server's HD

$objWriter->save('php://output');
  



?>