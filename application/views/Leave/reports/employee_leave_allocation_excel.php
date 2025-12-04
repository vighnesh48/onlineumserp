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

	$object->getActiveSheet()->getStyle('A1:S6')->getFont()->setBold(true);
	  $object->getActiveSheet()->getStyle('A5:S6')->applyFromArray($styleArray);
	  $object->getActiveSheet()->getColumnDimension('F')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('G')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('H')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('I')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('J')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('K')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('L')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('M')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('N')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('O')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('P')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('Q')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('R')->setWidth('5');
	  $object->getActiveSheet()->getColumnDimension('S')->setWidth('5');
	  
	  $object->getActiveSheet()->mergeCells('A1:S1');
        $object->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);
        $object->getActiveSheet()->getStyle('A1:S1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('A1', 'SANDIP UNIVERSITY');
     $object->getActiveSheet()->mergeCells('A2:S2');        
        $object->getActiveSheet()->getStyle('A2:S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('A2', 'TRIMBAK ROAD,MAHIRAVANI,NASHIK-422213');
      $object->getActiveSheet()->mergeCells('A3:S3');  
        $object->getActiveSheet()->getStyle('A3:S3')->getFont()->setBold(true);      
        $object->getActiveSheet()->getStyle('A3:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('A3', 'Employee leave list for Academic year '.$yer);
      
	  
	  
	  
	

$object->getActiveSheet()->mergeCells('A5:A6')->setCellValue('A5','Sr.No');
$object->getActiveSheet()->mergeCells('B5:B6')->setCellValue('B5','Emp ID');
$object->getActiveSheet()->mergeCells('C5:C6')->setCellValue('C5','Name');
$object->getActiveSheet()->mergeCells('D5:D6')->setCellValue('D5','School');
$object->getActiveSheet()->mergeCells('E5:E6')->setCellValue('E5','Department');
$object->getActiveSheet()->mergeCells('F5:G5')->setCellValue('F5','CL');

$object->getActiveSheet()->setCellValue('F6','A');
$object->getActiveSheet()->setCellValue('G6','U');
$object->getActiveSheet()->mergeCells('H5:I5')->setCellValue('H5','EL');
$object->getActiveSheet()->setCellValue('H6','A');
$object->getActiveSheet()->setCellValue('I6','U');
$object->getActiveSheet()->mergeCells('J5:K5')->setCellValue('J5','ML');
$object->getActiveSheet()->setCellValue('J6','A');
$object->getActiveSheet()->setCellValue('K6','U');
$object->getActiveSheet()->mergeCells('L5:M5')->setCellValue('L5','VL');
$object->getActiveSheet()->setCellValue('L6','A');
$object->getActiveSheet()->setCellValue('M6','U');
$object->getActiveSheet()->mergeCells('N5:O5')->setCellValue('N5','SL');
$object->getActiveSheet()->setCellValue('N6','A');
$object->getActiveSheet()->setCellValue('O6','U');
$object->getActiveSheet()->mergeCells('P5:Q5')->setCellValue('P5','C-OFF');
$object->getActiveSheet()->setCellValue('P6','A');
$object->getActiveSheet()->setCellValue('Q6','U');
 $object->getActiveSheet()->mergeCells('R5:S5')->setCellValue('R5','Leave');
$object->getActiveSheet()->setCellValue('R6','A');
$object->getActiveSheet()->setCellValue('S6','U');
  $ci =&get_instance();
   $ci->load->model('admin_model');
		$j=1;
			$row = 7;	
		foreach($emp_leave_allocation as $val){
			  $lis = $this->load->leave_model->get_employee_leave_type($val['employee_id'],$val['academic_year']);  
foreach($lis as $val){
	if($val['leave_type']=='VL'){
                 // echo $val['vl_id'];
                    $vl_cnt[$val['employee_id']][] = $val['leaves_allocated'];
$vl_us_cnt[$val['employee_id']][] = $val['leave_used'];
	}
	if($val['leave_type']=='C-OFF'){
			$cff[$val['employee_id']][]= $val['leave_used'];
		}
}
			  $emp = $ci->admin_model->getEmployeeById($val['employee_id']);	
$department =  $ci->admin_model->getDepartmentById($emp[0]['department']); 
$school =  $ci->admin_model->getSchoolById($emp[0]['emp_school']); 
                   if($emp[0]['gender']=='male'){ $g = 'Mr.';}else if($emp[0]['gender']=='female'){ $g = 'Mrs.';}       
$cl = $this->load->leave_model->get_emp_leaves($val['employee_id'],'CL',$yer);
$el = $this->load->leave_model->get_emp_leaves($val['employee_id'],'EL',$yer);
$ml = $this->load->leave_model->get_emp_leaves($val['employee_id'],'ML',$yer);
$vl = $this->load->leave_model->get_emp_leaves($val['employee_id'],'VL',$yer);
$sl = $this->load->leave_model->get_emp_leaves($val['employee_id'],'SL',$yer);
$leave = $this->load->leave_model->get_emp_leaves($val['employee_id'],'Leave',$yer);
  $coff = $this->load->leave_model->get_emp_leaves($val['employee_id'],'C-OFF',$yer);
$object->getActiveSheet()->setCellValue('A'.$row, $j);
$object->getActiveSheet()->setCellValue('B'.$row, $val['employee_id']);
$object->getActiveSheet()->setCellValue('C'.$row, $g." ".$emp[0]['fname']." ".$emp[0]['lname']);
$object->getActiveSheet()->setCellValue('D'.$row, $school[0]['college_code']);
$object->getActiveSheet()->setCellValue('E'.$row, $department[0]['department_name']);
$object->getActiveSheet()->setCellValue('F'.$row,$cl[0]['leaves_allocated']);
$object->getActiveSheet()->setCellValue('G'.$row,$cl[0]['leave_used']);
$object->getActiveSheet()->setCellValue('H'.$row,$el[0]['leaves_allocated']);
$object->getActiveSheet()->setCellValue('I'.$row,$el[0]['leave_used']);
$object->getActiveSheet()->setCellValue('J'.$row,$ml[0]['leaves_allocated']);
$object->getActiveSheet()->setCellValue('K'.$row,$ml[0]['leave_used']);
$object->getActiveSheet()->setCellValue('L'.$row,array_sum($vl_cnt[$val['employee_id']]));
$object->getActiveSheet()->setCellValue('M'.$row,array_sum($vl_us_cnt[$val['employee_id']]));
$object->getActiveSheet()->setCellValue('N'.$row,$sl[0]['leaves_allocated']);
$object->getActiveSheet()->setCellValue('O'.$row,$sl[0]['leave_used']);
$object->getActiveSheet()->setCellValue('P'.$row,$coff[0]['leaves_allocated']);
$object->getActiveSheet()->setCellValue('Q'.$row,array_sum($cff[$val['employee_id']]));
$object->getActiveSheet()->setCellValue('R'.$row,$leave[0]['leaves_allocated']);
$object->getActiveSheet()->setCellValue('S'.$row,$leave[0]['leave_used']);
		  $row = $row+1;
		  $j=$j+1;			
		}
	$row=$row-1;	

for($r=7;$r<=$row;$r++){
			 $object->getActiveSheet()->getStyle('A'.$r.':s'.$r)->applyFromArray($styleArray);
		}

					
$filename='employee_leave_allocation.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output'); ?>