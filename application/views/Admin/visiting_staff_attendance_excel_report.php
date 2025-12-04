<?php
$date =  $attend_date."-01";
$lt=date('t', strtotime($attend_date)); //get end date of month
$end = $attend_date."-".$lt;
$time=strtotime($attend_date);
$d = date_parse_from_format("Y-m-d",$attend_date);
$msearch=$d["month"];//month number
$ysearch=date("Y",strtotime($attend_date));
$monthName = date('F', mktime(0, 0, 0, $msearch, 10));
$number = cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);

$this->load->library('excel'); 
	  header('Content-Type: application/vnd.ms-excel');
	  header('Cache-Control: max-age=0');
	  header('Content-Disposition: attachment;filename="Employee_list_test.xls"');
	  $styleArray = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
           )
      )
  );
$styleArray1 = array(
    'font'  => array(
        'bold'  => true,       
        'size'  => 8,
        'name'  => 'Arial'
    ),
	 'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'F28A8C')
        ),
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));
		
		$styleArray2 = array(
    'font'  => array(
        'size'  => 9,
        'name'  => 'Calibri'
    ),
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));
		
		 $style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
          ));		
	$pre = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		   'color' => array('rgb' => 'e5ff00')
         ));
	 $hold = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		   'color' => array('rgb' => '00ff00')
         ));
	  $woff = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		   'color' => array('rgb' => 'ec891d')
          ));
 	$abs = array(
        'font'  => array(
        'color' => array('rgb' => 'ff0000'),
          ));
	$lwp = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		   'color' => array('rgb' => 'FFB6C1')
          ));
	$odf = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		   'color' => array('rgb' => 'C0C0C0')
          ));
	  $rowlb=2;
	  $object = new PHPExcel();
                  $object->setActiveSheetIndex(0);
				  $object->getActiveSheet()->mergeCells('A1:C1');
				  $object->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
				  $object->getActiveSheet()->getStyle('A1:C1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');				  
		
				    $object->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
					$object->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
					$object->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
					$object->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
					$object->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
					
					$object->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
					$object->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
				    $object->getActiveSheet()->getStyle('A1:C1')->applyFromArray($style);
					
					$object->getActiveSheet()->setCellValue('A'.($rowlb-1), 'SUM-TEACHING ATTENDANCE'.'-'.$monthName.' '.$ysearch);
							
			$object->getActiveSheet()->setCellValue('A'.$rowlb, 'SrNo');
			$object->getActiveSheet()->getStyle('A'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('B'.$rowlb, 'Name');
			$object->getActiveSheet()->getStyle('B'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('C'.$rowlb, 'Employee Code');
			$object->getActiveSheet()->getStyle('C'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('D'.$rowlb, 'Date of joining');
			$object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('E'.$rowlb, 'Department');
			$object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('F'.$rowlb, 'Designation');
			$object->getActiveSheet()->getStyle('F'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
					
	  $s = 'G';
	  for($i=1;$i<=$number;$i++){
	  $j=$rowlb;		
	  $object->getActiveSheet()->setCellValue($s.$j, $i);	   
	  $object->getActiveSheet()->getStyle($s.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  ++$s;
	  }
	  
	  $rowlb++;
	  $srno=1;
	  	  
	  foreach($attendance  as $key=>$e ){
		 
			  $emp1 = $this->Admin_model->getVisitingEmployeeDetails($key);			 
			  $name = $emp1[0]['fname']." ".$emp1[0]['mname']." ".$emp1[0]['lname'];
		    $object->getActiveSheet()->setCellValue('A'.$rowlb, $srno);
			$object->getActiveSheet()->getStyle('A'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
			$object->getActiveSheet()->setCellValue('B'.$rowlb,  $name);
			$object->getActiveSheet()->getStyle('B'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
			$object->getActiveSheet()->setCellValue('C'.$rowlb, $key);
			$object->getActiveSheet()->getStyle('C'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
			$object->getActiveSheet()->setCellValue('D'.$rowlb, '--');
			$object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
			$object->getActiveSheet()->setCellValue('E'.$rowlb, $emp1[0]['department_name']);
			$object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
			$object->getActiveSheet()->setCellValue('F'.$rowlb, $emp1[0]['designation_name']);
			$object->getActiveSheet()->getStyle('F'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
						
foreach($attendance[$key] as $att){		
$d=date('d',strtotime($att['Intime']));
$d = intval($d);
$dayIn[$key][$d]=$d; 
$tempdayin[$key][$d]=$dayIn[$key][$d];
$timedayin[$key][$d]=$att['Intime'];
$status[$key][$d]=$att['status'];
$leave[$key][$d]=$att['leave_type'];
$durl[$key][$d]=$att['leave_duration'];
$reml[$key][$d]=$att['remark'];

if($att['late_mark']=='1'){
$latemark[$key][$d]=$att['late_mark'];
}
if($att['early_mark']=='Y'){
	$earlymark[$key][$d]=$att['early_mark'];
}
$special_case[$key][$d]=$att['special_case'];
if($att['Outtime'] != '0000-00-00 00:00:00'){
$d=date('d',strtotime($att['Outtime']));
$d = intval( $d);
$dayOut[$key][$d]=$d; 
$tempdayout[$key][$d]=$dayOut[$key][$d];
$timedayout[$key][$d]=$att['Outtime'];
} 
if(date('H:i:s',strtotime($att['Outtime'])) != '00:00:00' && date('H:i:s',strtotime($att['Intime'])) != '00:00:00'){
$d=date('d',strtotime($att['Outtime']));
$d = intval($d);
if(date('h:i:s',strtotime($att['Intime']))!='00:00:00')$time1=date('H:i',strtotime($att['Intime']));else $time1='00:00';
if(date('h:i:s',strtotime($att['Outtime']))!='00:00:00')$time2=date('H:i',strtotime($att['Outtime'])); else $time2='00:00';
$diff=$this->Admin_model->get_time_difference($time1, $time2);
$dur[$d]= $diff;   
$timedayout[$key][$d]=$att['Outtime']; 
$timedayin[$key][$d]=$att['Intime']; 
}
 }  
 while(strtotime($date) <= strtotime($end)) {
$day_num = date('d', strtotime($date));
$day_name = date('D', strtotime($date));
$totaldays['total'][]=$day_num;
$totaldays['weekd'][]=$day_name ;
$date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
}
	
$stt = 'G';
for($i=1;$i<=$number;$i++){

 $dname=$attend_date."-".$totaldays['total'][$i-1];
  $check_holiday=$this->Admin_model->checkHoliday_new($dname,$staff_type);//check for holiday
 $check_holiday;
if($check_holiday=='true'){
$day_name="Holiday";
}else{
$day_name = date('D', strtotime($dname));
}
if($status[$key][$i] =='present' && ($day_name!="Holiday" && $day_name!="Sun") ){
	
if(date('H:i',strtotime($timedayin[$key][$i])) !='00:00'){
$total_count[$key]['present'][]='1';
}
}elseif(($status[$key][$i]=='leave') || ($status[$key][$i]=='outduty')){	
$ltypes=$leave[$key][$i];
$ltypes = strtoupper($ltypes);
$dur1 = $durl[$key][$i]; 
if($leave[$key][$i]=='WFH'){
$total_count[$key]['WFHH'][]='1';
}
if($leave[$key][$i]=='official'){
$total_count[$key]['OD'][]='1';
}

$rem = $reml[$key][$i];
if(trim($dur1) == '0.5' && ($rem == 'hrs' || $rem == 'half-day')){
  if(substr($ltypes, -1) === '*'){
$total_count[$key]['LWP'][]='0.5';
$total_count[$key][substr($ltypes,0,-1)][]=$dur1;
  }else{
$total_count[$key]['present'][]='0.5';
if(trim($rem) === 'hrs'){
  $total_count[$key][$ltypes][]='0.5';
}else{
$total_count[$key][$ltypes][]=$dur1;
}
}
}else{  
if(trim($rem) === 'hrs'){
$total_count[$key][$ltypes][]='0.5';
$total_count[$key]['present'][]='0.5';
}else{
$total_count[$key][$ltypes][]=$dur1;
}
}
}  
$temp1=array_search($i,$tempdayin[$key]);
if($status[$key][$i]=='holiday' || $status[$key][$i]=='sunday'){
  $col = 'color:red;'; 
}else{
  $col ='';
}
 $cd = date('d'); 
 $cm = date('m');
$ad = date_parse_from_format("m",$attend_date);
if($cm==$ad){
if($i<=$cd){	
  if($status[$key][$i]=='sunday'){
   $total_count[$key]['sun'][] = '1';
  }
  if($status[$key][$i]=='holiday'){
  $total_count[$key]['holiday'][]='1';
  }
}
}else{	  
  if($status[$key][$i]=='sunday'){
    $total_count[$key]['sun'][] = '1';
  }
  if($status[$key][$i]=='holiday'){
   $total_count[$key]['holiday'][]='1';
  }
}
if($latemark[$key][$i]=='1'){
	$lm = 'background-color:#D2D2D2;';
}else{
	$lm = '';
}
if($status[$key][$i]=="sunday"){
	if(($status[$key][$i-1]=="present")&&($status[$key][$i+1]=="present")&&($status[$key][$i+1]=="leave")&&
	($status[$key][$i-2]=="leave")&&( $leave[$key][$i+1]!="WFH")&&( $leave[$key][$i-2]!="WFH")&&( $leave[$key][$i+1]!="OD")&&
	( $leave[$key][$i-2]!="OD")&&( $leave[$key][$i+1]!="official")&&( $leave[$key][$i-2]!="official")&&
	( $leave[$key][$i+1]!="SL")&&( $leave[$key][$i-2]!="SL")&&( $leave[$key][$i+1]=="LWP")&&( $leave[$key][$i-2]=="LWP")){

	if(($reml[$key][$i-1]=="half-day")||($reml[$key][$i+1]=="half-day")){}else{	
	 $remove_lpw[] = '1';
	}
	}
	if(($status[$key][$i-1]!="present")&&($status[$key][$i+1]!="present")){		
	}		
}
if(($status[$key][$i]=="holiday")&&($status[$key][$i+1]=="sunday")){
	if((($status[$key][$i+2]=="leave"))&&($status[$key][$i-2]=="leave")&&( $leave[$key][$i+2]!="WFH")&&
	( $leave[$key][$i-2]!="WFH")&&( $leave[$key][$i-2]!="OD")&&( $leave[$key][$i+2]!="OD")&&
	( $leave[$key][$i-2]!="official")&&( $leave[$key][$i+2]!="official")&&( $leave[$key][$i-2]!="SL")&&
	( $leave[$key][$i+2]!="SL")&&( $leave[$key][$i-2]=="LWP")&&( $leave[$key][$i+2]=="LWP")){
	if(($reml[$key][$i+2]=="half-day")){

		}else{
		$remove_lph[] = '1';
		}
	}
}
if(($status[$key][$i]=="holiday")&&($status[$key][$i+1]=="holiday")){
	if(($leave[$key][$i+2]=="LWP")&&($leave[$key][$i-1]=="LWP")){
		$remove_lph[] = '1';		
	}	
}
if(($status[$key][$i]=="holiday")&&($status[$key][$i-1]=="holiday")){	
	if(($leave[$key][$i-2]=="LWP")&&($leave[$key][$i+1]=="LWP")){
		$remove_lph[] = '1';
	}	
}
if(($status[$key][$i]=="holiday")&&($leave[$key][$i+1]=="LWP")&&($leave[$key][$i-1]=="LWP")){
		if(($reml[$key][$i-1]=="half-day")||($reml[$key][$i+1]=="half-day")){}else{
		$remove_lph[] = '1';
		}
}
if(($status[$key][$i]=="sunday")&&($leave[$key][$i+1]=="LWP" && $special_case[$key][$i+1]!="SP"
&& $status[$key][$i+1]!="present"  )&&($leave[$key][$i-1]=="LWP" && $special_case[$key][$i-1]!="SP"
&& $status[$key][$i-1]!="present")){
		if(($reml[$key][$i-1]=="half-day")||($reml[$key][$i+1]=="half-day")){}else{
		$remove_lpw[] = '1';
		$check_rr[]='1';
		$check_r[]='1';
		}
}
if($status[$key][$i]=="holiday"){
$check_3rdstatus= $status[$key][$i+3];
}
if(($status[$key][$i]=="holiday")&&($leave[$key][$i+1]=="C-OFF")&&($leave[$key][$i-1]=="LWP")){
		if($status[$key][$i+3]=="present"){}else{
		$remove_lph[] = '1';
	}
}
if(($status[$key][$i]=="sunday")&&($status[$key][$i-2]=="holiday")&&($leave[$key][$i-1]=="C-OFF")&&
($leave[$key][$i+1]=="LWP")&&($status[$key][$i-3]!="present")){
		if(($reml[$key][$i-1]=="half-day")||($reml[$key][$i+1]=="half-day")){}else{
	$remove_lpw[] = '1';
		}
}
if(($status[$key][$i-1]=="")&&($status[$key][$i]=="holiday")&&($status[$key][$i+1]=="sunday")&&($leave[$key][$i+2]=="LWP")){
		if(($reml[$key][$i-1]=="half-day")||($reml[$key][$i+1]=="half-day")){}else{
	 $remove_lpw[] = '1';
	$remove_lph[] = '1';
	}
}
if(($leave[$key][$i-2]=="LWP")&&($leave[$key][$i-1]=="LWP")&&($status[$key][$i]=="sunday")&&($status[$key][$i+1]=="holiday")
&&($status[$key][$i+2]!="present")
&&($leave[$key][$i+1]=="LWP")){
	if(($reml[$key][$i-1]=="half-day")||($reml[$key][$i+1]=="half-day")){}else{
	$remove_lpw[] = '1';
	}
}
if(($leave[$key][$i-2]=="LWP")&&($status[$key][$i-1]=="holiday")&&($status[$key][$i]=="sunday")&&($leave[$key][$i+1]=="LWP")&&($status[$key][$i+2]=="")){
	if(($reml[$key][$i-1]=="half-day")||($reml[$key][$i+1]=="half-day")){}else{		
	$remove_lph[] = '1';	
	}
}
if(($leave[$key][$i-3]=="LWP")&&($leave[$key][$i-2]=="LWP")&&($status[$key][$i-1]=="holiday")&&
($status[$key][$i]=="sunday")&&($status[$key][$i+1]=="present")){		
	if(($reml[$key][$i-1]=="half-day")||($reml[$key][$i+1]=="half-day")||($reml[$key][$i+1]=="")){}else{
	$remove_lpw[] = '1';
	}
}
if(($leave[$key][$i-2]=="LWP"  && $special_case[$key][$i-2]!="SP"
&& $status[$key][$i-2]!="present")&&($leave[$key][$i-1]=="LWP" && $special_case[$key][$i-1]!="SP"
&& $status[$key][$i-1]!="present")&&
($status[$key][$i]=="sunday")&&($leave[$key][$i+1]=="LWP" && $special_case[$key][$i+1]!="SP"
&& $status[$key][$i+1]!="present")&&(empty($check_rr))){
	if(($reml[$key][$i-1]=="half-day")||($reml[$key][$i+1]=="half-day")||($reml[$key][$i+1]=="")){}else{		
	$remove_lpw[] = '1';
	$check_r[]='1';
	}
}
if(($leave[$key][$i-3]=="LWP" && $special_case[$key][$i-3]!="SP"
&& $status[$key][$i-3]!="present")&&($leave[$key][$i-2]=="LWP"
&& $special_case[$key][$i-2]!="SP"
&& $status[$key][$i-2]!="present"

)&&($leave[$key][$i-1]=="LWP"
&& $special_case[$key][$i-1]!="SP"
&& $status[$key][$i-1]!="present"

)&&
($status[$key][$i]=="sunday")&&($leave[$key][$i+1]=="LWP" && $special_case[$key][$i+1]!="SP"
&& $status[$key][$i+1]!="present")&&(empty($check_r))){
	if(($reml[$key][$i-1]=="half-day")||($reml[$key][$i+1]=="half-day")||($reml[$key][$i+1]=="")||($status[$key][$i+2]=="")){}else{
		$remove_lpw[] = '1';
	}
}
if(($leave[$key][$i-2]=="LWP")&&($status[$key][$i-1]=="holiday")&&
($status[$key][$i]=="sunday")&&($leave[$key][$i+1]=="LWP")){
	if(($reml[$key][$i-1]=="half-day")||($reml[$key][$i+1]=="half-day")||($reml[$key][$i+1]=="")){}else{
		$remove_lpw[] = '1';
	    $remove_lph[] = '1';
	}
}
if(($leave[$key][$i-3]=="LWP")&&($leave[$key][$i-2]=="LWP")&&($leave[$key][$i-1]=="LWP")&&
($status[$key][$i]=="sunday")&&($status[$key][$i+1]=="holiday")&&($leave[$key][$i+2]=="LWP")){
	if(($reml[$key][$i-1]=="half-day")||($reml[$key][$i+1]=="half-day")||($reml[$key][$i+1]=="")){}else{
	}
}
if(($leave[$key][$i-2]=="LWP")&&($status[$key][$i-1]=="sunday")&&($status[$key][$i]=="holiday")&&($leave[$key][$i+1]=="LWP")){
	if(($reml[$key][$i-1]=="half-day")||($reml[$key][$i+1]=="half-day")){}else{
	$remove_lpw[] = '1';
	$remove_lph[] = '1';
	}
}
if(($status[$key][$i-2]=="present")&&($leave[$key][$i-1]=="LWP")&&
($status[$key][$i]=="sunday")&&($leave[$key][$i+1]=="LWP")&&(empty($check_rr))){
	if(($reml[$key][$i-1]=="half-day")||($reml[$key][$i+1]=="half-day")||($reml[$key][$i+1]=="")){}else{
		$remove_lpw[] = '1';
	}
}
if(($leave[$key][$i-4]=="LWP")&&($leave[$key][$i-3]=="LWP")&&($leave[$key][$i-2]=="LWP")&&($status[$key][$i-1]=="holiday")&&
($status[$key][$i]=="sunday")&&($status[$key][$i+1]=="present")){
		$remove_lpw[] = '1';
	    $remove_lph[] = '1';
}
}	
$stt = 'G';
	 for($i=1;$i<=$number;$i++){
		 $sts='A';
	if($status[$key][$i]=='present'){
if(date('H:i:s',strtotime($timedayout[$key][$i]))=='00:00:00' || date('H:i:s',strtotime($timedayin[$key][$i]))=='00:00:00')
{
}else{
$sts='P';
if(!empty($special_case[$key][$i])){
$sts=$special_case[$key][$i];
}
}
$total_count[$key]['present'][]='1';

}elseif($status[$key][$i]=='leave' || $status[$key][$i]=='outduty'){
	
$ltypes=$leave[$key][$i];
$dur1 = $durl[$key][$i];
 
if($ltypes=='LWP'){
 
if(trim($durl[$key][$i])=='0.5' && $reml[$key][$i]=='half-day'){
$sts=$ltypes.'(H)'; 
}else{
$sts=$ltypes; 
}
}else{
  $st = '0.5';
  if(trim($durl[$key][$i])=='0.5' && $reml[$key][$i]=='half-day'){
    $ds = '(H)';
  }elseif($reml[$key][$i]=='hrs'){
    $ds = '(Hrs)';
  }else{
    $ds ='(F)';
  }
$sts=$ltypes.''.$ds; 
}

$total_count[$key][$ltypes][]=$dur1;
}elseif($status[$key][$i]=='sunday'){
 $sts='WO'; 
}elseif($status[$key][$i]=='holiday'){
 $sts='H'; 
}
	          if($sts=='P'){
	         $object->getActiveSheet()->setCellValue($stt.$rowlb, $sts);	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($pre);
			  $stt++;
			  }
			  elseif($sts=='H')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb, $sts);	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($hold);
			  $stt++;  
			  }
			    elseif($sts=='WO')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb, $sts);	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($woff);
			  $stt++;  
			  }
			  elseif($sts=='LWP')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb, $sts);	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($lwp);
			  $stt++;   
			  }
			  elseif($sts=='OD(F)' || $sts=='OD(H)' || $sts=='OD(Hrs)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb, $sts);	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($odf);
			  $stt++; 
			  }
			  else
			  {
		      $object->getActiveSheet()->setCellValue($stt.$rowlb, $sts);	   
	          $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abs);
			  $stt++;
			  }
}				
		   $rowlb++;
		  $srno++;
		  }	  
 $rowlb+=2;

  $object->getActiveSheet()->setCellValue('D'.$rowlb, 'P');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($pre);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Present');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);$rowlb++;
  $object->getActiveSheet()->setCellValue('D'.$rowlb, 'A');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abs);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Absent');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);$rowlb++;
  $object->getActiveSheet()->setCellValue('D'.$rowlb, 'WO');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($woff);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Weekly-Off');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);$rowlb++;
  $object->getActiveSheet()->setCellValue('D'.$rowlb, 'H');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($hold);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Holiday');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);$rowlb++;
  $object->getActiveSheet()->setCellValue('D'.$rowlb, 'LWP');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($lwp);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Leave Without Pay');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);$rowlb++;
  $object->getActiveSheet()->setCellValue('D'.$rowlb, 'OD');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($odf);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Outdoor-Duty');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);$rowlb++;
    $object->getActiveSheet()->setCellValue('D'.$rowlb, 'CL');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abs);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Casual Leave');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);$rowlb++;
    $object->getActiveSheet()->setCellValue('D'.$rowlb, 'ML');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abs);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Medical Leave');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);$rowlb++;
   $object->getActiveSheet()->setCellValue('D'.$rowlb, 'WFH');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abs);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Work From Home');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);$rowlb++;
   $object->getActiveSheet()->setCellValue('D'.$rowlb, 'C-OFF');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abs);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Utilised Comp-Off');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
  
  
$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
$objWriter->setPreCalculateFormulas(true);      
					
			echo $objWriter->save('php://output');

?>