<?php 
$this->load->library('excel');
 $object = new PHPExcel();
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

	$object->getActiveSheet()->getStyle('A1:G2')->getFont()->setBold(true);
	  $object->getActiveSheet()->getStyle('A1:G2')->applyFromArray($styleArray);
	if($styp=='monthly'){
	$object->getActiveSheet()->mergeCells('A1:G1')->setCellValue('A1','Employee Leave list '.date('F Y',strtotime('01-'.$smonth)));
}elseif($styp=='yer'){
$yerarry=explode("-",$smonth);
$myarray = array_filter(array_map('trim', $yerarry));
$object->getActiveSheet()->mergeCells('A1:G1')->setCellValue('A1','Employee Leave list From '.$myarray[0].'-'.$myarray[1].' To '.$myarray[2].'-'.$myarray[3]);

}

$object->getActiveSheet()->mergeCells('A2:B2')->setCellValue('A2','Academic Year | '.$this->config->item('current_year'));

$object->getActiveSheet()->setCellValue('C2','');
$object->getActiveSheet()->setCellValue('D2','LEAVE DETAILS');
$object->getActiveSheet()->setCellValue('E2','');
if($styp=='monthly'){
$object->getActiveSheet()->mergeCells('F2:G2')->setCellValue('F2','Month :-'.date('F',strtotime('01-'.$smonth)));
//$object->getActiveSheet()->setCellValue('G2',date('F',strtotime('01-'.$smonth)));
}

$row=4;
foreach($empl as $val){
$k= $row+6;
$object->getActiveSheet()->getStyle('A'.$row.':G'.$k)->getFont()->setBold(true);

$object->getActiveSheet()->mergeCells('A'.$row.':D'.$row)->setCellValue('A'.$row,'Staff Id : '.$val['emp_id']);
$object->getActiveSheet()->mergeCells('E'.$row.':G'.$row)->setCellValue('E'.$row,'Department : '.$val['department_name']);
$row++;
$object->getActiveSheet()->mergeCells('A'.$row.':D'.$row)->setCellValue('A'.$row,'Name : '.$val['fname']." ".$val['lname']);
$object->getActiveSheet()->mergeCells('E'.$row.':G'.$row)->setCellValue('E'.$row,'School : '.$val['college_name']);
$row++;
$object->getActiveSheet()->mergeCells('A'.$row.':D'.$row)->setCellValue('A'.$row,'Designation : '.$val['designation_name']);
$object->getActiveSheet()->mergeCells('E'.$row.':G'.$row)->setCellValue('E'.$row,'Date of Joining : '.date('d-m-Y',strtotime($val['joiningDate'])));
$row++;
$row++;
$object->getActiveSheet()->mergeCells('A'.$row.':G'.$row)->setCellValue('A'.$row,'Casual Leave (CL) ');
$row++;
$cl = $this->leave_model->get_emp_leaves($val['emp_id'],'CL',''); 
$bal = $cl[0]['leaves_allocated'] - $cl[0]['leave_used'];

$object->getActiveSheet()->mergeCells('A'.$row.':C'.$row)->setCellValue('A'.$row,'Entitled: '.$cl[0]['leaves_allocated']);
$object->getActiveSheet()->mergeCells('D'.$row.':F'.$row)->setCellValue('D'.$row,'Availed: '.$cl[0]['leave_used']);
$object->getActiveSheet()->mergeCells('G'.$row.':H'.$row)->setCellValue('G'.$row,'Balance: '.$bal);
$row++;
$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray($styleArray);
$object->getActiveSheet()->setCellValue('A'.$row,'Sr.No');
$object->getActiveSheet()->setCellValue('B'.$row,'Application Id');
$object->getActiveSheet()->setCellValue('C'.$row,'From Date ');
$object->getActiveSheet()->setCellValue('D'.$row,'To Date');
$object->getActiveSheet()->setCellValue('E'.$row,'No of Days');
$object->getActiveSheet()->setCellValue('F'.$row,'Approved By');
$object->getActiveSheet()->setCellValue('G'.$row,'Approval Date');
  
		$j=1;
			$row++;	
$lev_list = $this->leave_model->getMyAllLeave_typ($val['emp_id'],$cl[0]['id'],$smonth,$styp);
		foreach($lev_list as $valcl){		  
		$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray($styleArray);
 $appr = $this->leave_model->get_approved_reporting_leave($valcl['lid']);
	 
$object->getActiveSheet()->setCellValue('A'.$row, $j);
$object->getActiveSheet()->setCellValue('B'.$row, $valcl['lid']);
$object->getActiveSheet()->setCellValue('C'.$row,date('d-m-Y ',strtotime($valcl['applied_from_date'])));
$object->getActiveSheet()->setCellValue('D'.$row,date('d-m-Y ',strtotime($valcl['applied_to_date'])));
$object->getActiveSheet()->setCellValue('E'.$row, $valcl['no_days']);
$object->getActiveSheet()->setCellValue('F'.$row, $appr[0]['empidl']." - ".$appr[0]['fname']." ".$appr[0]['lname']);
$object->getActiveSheet()->setCellValue('G'.$row, date('d-m-Y',strtotime($appr[0]['empidd'])));
$row++;
$j++;

}
$row=$row+2;

$k= $row+2;
$object->getActiveSheet()->getStyle('A'.$row.':G'.$k)->getFont()->setBold(true);

$object->getActiveSheet()->mergeCells('A'.$row.':G'.$row)->setCellValue('A'.$row,'Medical Leave (ML) ');
$row++;
$ml = $this->leave_model->get_emp_leaves($val['emp_id'],'ML',''); 
$balml = $ml[0]['leaves_allocated'] - $ml[0]['leave_used'];

$object->getActiveSheet()->mergeCells('A'.$row.':C'.$row)->setCellValue('A'.$row,'Entitled: '.$ml[0]['leaves_allocated']);
$object->getActiveSheet()->mergeCells('D'.$row.':F'.$row)->setCellValue('D'.$row,'Availed: '.$ml[0]['leave_used']);
$object->getActiveSheet()->mergeCells('G'.$row.':H'.$row)->setCellValue('G'.$row,'Balance: '.$balml);
$row++;
$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray($styleArray);
$object->getActiveSheet()->setCellValue('A'.$row,'Sr.No');
$object->getActiveSheet()->setCellValue('B'.$row,'Application Id');
$object->getActiveSheet()->setCellValue('C'.$row,'From Date ');
$object->getActiveSheet()->setCellValue('D'.$row,'To Date');
$object->getActiveSheet()->setCellValue('E'.$row,'No of Days');
$object->getActiveSheet()->setCellValue('F'.$row,'Approved By');
$object->getActiveSheet()->setCellValue('G'.$row,'Approval Date');
  
		$j=1;
			$row++;	
$lev_listml = $this->leave_model->getMyAllLeave_typ($val['emp_id'],$ml[0]['id'],$smonth,$styp);
		foreach($lev_listml as $valml){	  
		$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray($styleArray);
 $appr = $this->leave_model->get_approved_reporting_leave($valml['lid']);
	 
$object->getActiveSheet()->setCellValue('A'.$row, $j);
$object->getActiveSheet()->setCellValue('B'.$row, $valml['lid']);
$object->getActiveSheet()->setCellValue('C'.$row,date('d-m-Y ',strtotime($valml['applied_from_date'])));
$object->getActiveSheet()->setCellValue('D'.$row,date('d-m-Y ',strtotime($valml['applied_to_date'])));
$object->getActiveSheet()->setCellValue('E'.$row, $valml['no_days']);
$object->getActiveSheet()->setCellValue('F'.$row, $appr[0]['empidl']." - ".$appr[0]['fname']." ".$appr[0]['lname']);
$object->getActiveSheet()->setCellValue('G'.$row, date('d-m-Y',strtotime($appr[0]['empidd'])));
$row++;
$j++;
}

$row=$row+2;
$k= $row+2;
$object->getActiveSheet()->getStyle('A'.$row.':G'.$k)->getFont()->setBold(true);
$object->getActiveSheet()->mergeCells('A'.$row.':G'.$row)->setCellValue('A'.$row,'Compensatory Off (C off) ');
$row++;
$coff = $this->leave_model->get_emp_leaves($val['emp_id'],'C-OFF',''); 
$balcoff = $coff[0]['leaves_allocated'] - $coff[0]['leave_used'];

$object->getActiveSheet()->mergeCells('A'.$row.':C'.$row)->setCellValue('A'.$row,'Entitled: '.$coff[0]['leaves_allocated']);
$object->getActiveSheet()->mergeCells('D'.$row.':F'.$row)->setCellValue('D'.$row,'Availed: '.$coff[0]['leave_used']);
$object->getActiveSheet()->mergeCells('G'.$row.':H'.$row)->setCellValue('G'.$row,'Balance: '.$balcoff);
$row++;
$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray($styleArray);
$object->getActiveSheet()->setCellValue('A'.$row,'Sr.No');
$object->getActiveSheet()->setCellValue('B'.$row,'Application Id');
$object->getActiveSheet()->setCellValue('C'.$row,'From Date ');
$object->getActiveSheet()->setCellValue('D'.$row,'To Date');
$object->getActiveSheet()->setCellValue('E'.$row,'No of Days');
$object->getActiveSheet()->setCellValue('F'.$row,'Approved By');
$object->getActiveSheet()->setCellValue('G'.$row,'Approval Date');
  
		$j=1;
			$row++;	
$lev_listcoff = $this->leave_model->getMyAllLeave_typ($val['emp_id'],$coff[0]['id'],$smonth,$styp);
		foreach($lev_listcoff as $valcoff){	  
	$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray($styleArray);	
 $apprcf = $this->leave_model->get_approved_reporting_leave($valcoff['lid']);
	 
$object->getActiveSheet()->setCellValue('A'.$row, $j);
$object->getActiveSheet()->setCellValue('B'.$row, $valcoff['lid']);
$object->getActiveSheet()->setCellValue('C'.$row,date('d-m-Y ',strtotime($valcoff['applied_from_date'])));
$object->getActiveSheet()->setCellValue('D'.$row,date('d-m-Y ',strtotime($valcoff['applied_to_date'])));
$object->getActiveSheet()->setCellValue('E'.$row, $valcoff['no_days']);
$object->getActiveSheet()->setCellValue('F'.$row, $apprcf[0]['empidl']." - ".$apprcf[0]['fname']." ".$apprcf[0]['lname']);
$object->getActiveSheet()->setCellValue('G'.$row, date('d-m-Y',strtotime($apprcf[0]['empidd'])));
$row++;
$j++;
}
$row=$row+2;

$k= $row+2;
$object->getActiveSheet()->getStyle('A'.$row.':G'.$k)->getFont()->setBold(true);

$object->getActiveSheet()->mergeCells('A'.$row.':G'.$row)->setCellValue('A'.$row,'Earned Leave (EL) ');
$row++;
$el = $this->leave_model->get_emp_leaves($val['emp_id'],'EL',''); 
$balel = $el[0]['leaves_allocated'] - $el[0]['leave_used'];

$object->getActiveSheet()->mergeCells('A'.$row.':C'.$row)->setCellValue('A'.$row,'Entitled: '.$el[0]['leaves_allocated']);
$object->getActiveSheet()->mergeCells('D'.$row.':F'.$row)->setCellValue('D'.$row,'Availed: '.$el[0]['leave_used']);
$object->getActiveSheet()->mergeCells('G'.$row.':H'.$row)->setCellValue('G'.$row,'Balance: '.$balel);
$row++;
$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray($styleArray);
$object->getActiveSheet()->setCellValue('A'.$row,'Sr.No');
$object->getActiveSheet()->setCellValue('B'.$row,'Application Id');
$object->getActiveSheet()->setCellValue('C'.$row,'From Date ');
$object->getActiveSheet()->setCellValue('D'.$row,'To Date');
$object->getActiveSheet()->setCellValue('E'.$row,'No of Days');
$object->getActiveSheet()->setCellValue('F'.$row,'Approved By');
$object->getActiveSheet()->setCellValue('G'.$row,'Approval Date');
  
		$j=1;
			$row++;	
			if(!empty($el[0]['id'])){
$lev_listel = $this->leave_model->getMyAllLeave_typ($val['emp_id'],$el[0]['id'],$smonth,$styp);
		foreach($lev_listel as $valel){	  
		$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray($styleArray);
 $appr = $this->leave_model->get_approved_reporting_leave($valel['lid']);
	 
$object->getActiveSheet()->setCellValue('A'.$row, $j);
$object->getActiveSheet()->setCellValue('B'.$row, $valel['lid']);
$object->getActiveSheet()->setCellValue('C'.$row,date('d-m-Y ',strtotime($valel['applied_from_date'])));
$object->getActiveSheet()->setCellValue('D'.$row,date('d-m-Y ',strtotime($valel['applied_to_date'])));
$object->getActiveSheet()->setCellValue('E'.$row, $valel['no_days']);
$object->getActiveSheet()->setCellValue('F'.$row, $appr[0]['empidl']." - ".$appr[0]['fname']." ".$appr[0]['lname']);
$object->getActiveSheet()->setCellValue('G'.$row, date('d-m-Y',strtotime($appr[0]['empidd'])));
$row++;
$j++;
}
}
$row=$row+2;

$k= $row+2;
$object->getActiveSheet()->getStyle('A'.$row.':G'.$k)->getFont()->setBold(true);

$object->getActiveSheet()->mergeCells('A'.$row.':G'.$row)->setCellValue('A'.$row,'Leave');
$row++;
$lev = $this->leave_model->get_emp_leaves($val['emp_id'],'Leave',''); 
$ballev = $lev[0]['leaves_allocated'] - $lev[0]['leave_used'];

$object->getActiveSheet()->mergeCells('A'.$row.':C'.$row)->setCellValue('A'.$row,'Entitled: '.$lev[0]['leaves_allocated']);
$object->getActiveSheet()->mergeCells('D'.$row.':F'.$row)->setCellValue('D'.$row,'Availed: '.$lev[0]['leave_used']);
$object->getActiveSheet()->mergeCells('G'.$row.':H'.$row)->setCellValue('G'.$row,'Balance: '.$ballev);
$row++;
$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray($styleArray);
$object->getActiveSheet()->setCellValue('A'.$row,'Sr.No');
$object->getActiveSheet()->setCellValue('B'.$row,'Application Id');
$object->getActiveSheet()->setCellValue('C'.$row,'From Date ');
$object->getActiveSheet()->setCellValue('D'.$row,'To Date');
$object->getActiveSheet()->setCellValue('E'.$row,'No of Days');
$object->getActiveSheet()->setCellValue('F'.$row,'Approved By');
$object->getActiveSheet()->setCellValue('G'.$row,'Approval Date');
  
		$j=1;
			$row++;	
			if(!empty($lev[0]['id'])){
$lev_listlev = $this->leave_model->getMyAllLeave_typ($val['emp_id'],$lev[0]['id'],$smonth,$styp);
		foreach($lev_listlev as $vallev){	  
		$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray($styleArray);
 $appr = $this->leave_model->get_approved_reporting_leave($vallev['lid']);
	 
$object->getActiveSheet()->setCellValue('A'.$row, $j);
$object->getActiveSheet()->setCellValue('B'.$row, $vallev['lid']);
$object->getActiveSheet()->setCellValue('C'.$row,date('d-m-Y ',strtotime($vallev['applied_from_date'])));
$object->getActiveSheet()->setCellValue('D'.$row,date('d-m-Y ',strtotime($vallev['applied_to_date'])));
$object->getActiveSheet()->setCellValue('E'.$row, $vallev['no_days']);
$object->getActiveSheet()->setCellValue('F'.$row, $appr[0]['empidl']." - ".$appr[0]['fname']." ".$appr[0]['lname']);
$object->getActiveSheet()->setCellValue('G'.$row, date('d-m-Y',strtotime($appr[0]['empidd'])));
$row++;
$j++;
}
}
$row=$row+2;
$k= $row+2;
$object->getActiveSheet()->getStyle('A'.$row.':G'.$k)->getFont()->setBold(true);
$object->getActiveSheet()->mergeCells('A'.$row.':G'.$row)->setCellValue('A'.$row,'Vacation (VL) ');
$row++;
$vl = $this->leave_model->get_emp_leaves($val['emp_id'],'VL',''); 
 foreach($vl as $vls){
      $vlids[] = $vls['id'];
      $aloc[] = $vls['leaves_allocated'];
      $usd[] = $vls['leave_used'];
    }
$vlbal = array_sum($aloc) - array_sum($usd);

$object->getActiveSheet()->mergeCells('A'.$row.':C'.$row)->setCellValue('A'.$row,'Entitled: '.array_sum($aloc));
$object->getActiveSheet()->mergeCells('D'.$row.':F'.$row)->setCellValue('D'.$row,'Availed: '.array_sum($usd));
$object->getActiveSheet()->mergeCells('G'.$row.':H'.$row)->setCellValue('G'.$row,'Balance: '.$vlbal);
$row++;
$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray($styleArray);
$object->getActiveSheet()->setCellValue('A'.$row,'Sr.No');
$object->getActiveSheet()->setCellValue('B'.$row,'Application Id');
$object->getActiveSheet()->setCellValue('C'.$row,'From Date ');
$object->getActiveSheet()->setCellValue('D'.$row,'To Date');
$object->getActiveSheet()->setCellValue('E'.$row,'No of Days');
$object->getActiveSheet()->setCellValue('F'.$row,'Approved By');
$object->getActiveSheet()->setCellValue('G'.$row,'Approval Date');
  
		$j=1;
			$row++;	
 foreach($vlids as $vlid){
  $j=1; $lev_listvl = $this->leave_model->getMyAllLeave_typ($val['emp_id'],$vlid,$smonth,$styp);
  
  foreach($lev_listvl as $lvalvl){ 
    $apprvl = $this->leave_model->get_approved_reporting_leave($lvalvl['lid']);		
 $object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray($styleArray);
	 
$object->getActiveSheet()->setCellValue('A'.$row, $j);
$object->getActiveSheet()->setCellValue('B'.$row, $lvalvl['lid']);
$object->getActiveSheet()->setCellValue('C'.$row,date('d-m-Y ',strtotime($lvalvl['applied_from_date'])));
$object->getActiveSheet()->setCellValue('D'.$row,date('d-m-Y ',strtotime($lvalvl['applied_to_date'])));
$object->getActiveSheet()->setCellValue('E'.$row, $lvalvl['no_days']);
$object->getActiveSheet()->setCellValue('F'.$row, $apprvl[0]['empidl']." - ".$apprvl[0]['fname']." ".$apprvl[0]['lname']);
$object->getActiveSheet()->setCellValue('G'.$row, date('d-m-Y',strtotime($apprvl[0]['empidd'])));
$row++;
$j++;
}
}

$row=$row+3;
}
$filename='employee_leave_application_list.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output'); ?>