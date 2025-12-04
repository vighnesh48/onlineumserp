<?php 
$this->load->library('excel');
 $object = new PHPExcel();
//print_r($sdet);exit;
	  //$iccode = $this->session->userdata("ic_code");

$styleArray = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      ),
	  'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        )
  );
  $styleArray2 = array(
    'font'  => array(
        'size'  => 12,
        'name'  => 'Times New Roman'
    ),
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));

$object->setActiveSheetIndex(0);
	
	 
	$object->getActiveSheet()->setTitle('Vacation Leaves Slot List');

	$object->getActiveSheet()->getStyle('A1:K2')->getFont()->setBold(true);
	  $object->getActiveSheet()->getStyle('A1:K2')->applyFromArray($styleArray);
	 
	$object->getActiveSheet()->mergeCells('A1:K1')->setCellValue('A1','Vacation Leaves Slot List for Academic Year  '.$yer);

$object->getActiveSheet()->setCellValue('A2','Sr.No');
$object->getActiveSheet()->setCellValue('B2','Emp ID');
$object->getActiveSheet()->setCellValue('C2','Name');
$object->getActiveSheet()->setCellValue('D2','School');
$object->getActiveSheet()->setCellValue('E2','Department');
$object->getActiveSheet()->setCellValue('F2','Year');
$object->getActiveSheet()->setCellValue('G2','Vacation Type');
$object->getActiveSheet()->setCellValue('H2','Slot');
$object->getActiveSheet()->setCellValue('I2','From Date');
$object->getActiveSheet()->setCellValue('J2','To Date');
$object->getActiveSheet()->setCellValue('K2','Days');

  
		$j=1;
			$row = 3;	
		foreach($vl_slot_emp as $val){
			  
			  
 if($val['gender']=='male'){ $g = 'Mr.';}else if($val['gender']=='female'){ $g = 'Mrs.';}       
$un = $this->leave_model->get_username($val['inserted_by']);
$object->getActiveSheet()->setCellValue('A'.$row, $j);
$object->getActiveSheet()->setCellValue('B'.$row, $val['employee_id']);
$object->getActiveSheet()->setCellValue('C'.$row, $g." ".$val['fname']." ".$val['lname']);
$object->getActiveSheet()->setCellValue('D'.$row, $val['college_code']);
$object->getActiveSheet()->setCellValue('E'.$row, $val['department_name']);
$object->getActiveSheet()->setCellValue('F'.$row,$val['academic_year']);
$object->getActiveSheet()->setCellValue('G'.$row,$val['vacation_type']);
$object->getActiveSheet()->setCellValue('H'.$row,$val['slot_type']);
$object->getActiveSheet()->setCellValue('I'.$row,date('d-m-Y',strtotime($val['from_date'])));
$object->getActiveSheet()->setCellValue('J'.$row,date('d-m-Y',strtotime($val['to_date'])));
$object->getActiveSheet()->setCellValue('K'.$row,$val['no_days']);
  $row = $row+1;
		  $j=$j+1;			
		}
	$row=$row-1;	

for($r=3;$r<=$row;$r++){
			 $object->getActiveSheet()->getStyle('A'.$r.':K'.$r)->applyFromArray($styleArray);
		}

					
$filename='Vacation_Leaves_Slot_List.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output'); ?>