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
	
	 
	$object->getActiveSheet()->setTitle('Employee leave list');

	$object->getActiveSheet()->getStyle('A1:J2')->getFont()->setBold(true);
	  $object->getActiveSheet()->getStyle('A1:J2')->applyFromArray($styleArray);
	 
	$object->getActiveSheet()->mergeCells('A1:J1')->setCellValue('A1','Employee C-OFF list '.date('F Y',strtotime('01-'.$mon)));

$object->getActiveSheet()->setCellValue('A2','Sr.No');
$object->getActiveSheet()->setCellValue('B2','Emp ID');
$object->getActiveSheet()->setCellValue('C2','Name');
$object->getActiveSheet()->setCellValue('D2','School');
$object->getActiveSheet()->setCellValue('E2','Department');
$object->getActiveSheet()->setCellValue('F2','Date');
$object->getActiveSheet()->setCellValue('G2','Status');
$object->getActiveSheet()->setCellValue('H2','Credited By');
$object->getActiveSheet()->setCellValue('I2','Credited On');
$object->getActiveSheet()->setCellValue('J2','Added By');

  $ci =&get_instance();
   $ci->load->model('admin_model');
		$j=1;
			$row = 3;	
		foreach($coffleave as $val){
			  
			  $emp = $ci->admin_model->getEmployeeById($val['emp_id']);	
$department =  $ci->admin_model->getDepartmentById($emp[0]['department']); 
$school =  $ci->admin_model->getSchoolById($emp[0]['emp_school']); 
 if($emp[0]['gender']=='male'){ $g = 'Mr.';}else if($emp[0]['gender']=='female'){ $g = 'Mrs.';}       
$un = $this->leave_model->get_username($val['inserted_by']);
$object->getActiveSheet()->setCellValue('A'.$row, $j);
$object->getActiveSheet()->setCellValue('B'.$row, $val['emp_id']);
$object->getActiveSheet()->setCellValue('C'.$row, $g." ".$emp[0]['fname']." ".$emp[0]['lname']);
$object->getActiveSheet()->setCellValue('D'.$row, $school[0]['college_code']);
$object->getActiveSheet()->setCellValue('E'.$row, $department[0]['department_name']);
$object->getActiveSheet()->setCellValue('F'.$row,date('d-m-Y',strtotime($val['date'])));
$object->getActiveSheet()->setCellValue('G'.$row,$val['status']);
$object->getActiveSheet()->setCellValue('H'.$row,$val['credited_by']);
$object->getActiveSheet()->setCellValue('I'.$row,date('d-m-Y',strtotime($val['inserted_datetime1'])));
$object->getActiveSheet()->setCellValue('J'.$row,$un[0]['username']);
  $row = $row+1;
		  $j=$j+1;			
		}
	$row=$row-1;	

for($r=3;$r<=$row;$r++){
			 $object->getActiveSheet()->getStyle('A'.$r.':J'.$r)->applyFromArray($styleArray);
		}

					
$filename='employee_leave_coff.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output'); ?>