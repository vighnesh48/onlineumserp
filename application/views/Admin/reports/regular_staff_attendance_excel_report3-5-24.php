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
	  header('Content-Disposition: attachment;filename="Regular_staff_attendance_report.xls"');
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
 	$abst = array(
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
					$object->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
					$object->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
					
					$object->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
					$object->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

				    $object->getActiveSheet()->getStyle('A1:C1')->applyFromArray($style);
					
					$object->getActiveSheet()->setCellValue('A'.($rowlb-1), 'SUN-TEACHING ATTENDANCE'.'-'.$monthName.' '.$ysearch);
					
			$object->getActiveSheet()->setCellValue('A'.$rowlb, 'SrNo');
			$object->getActiveSheet()->getStyle('A'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('B'.$rowlb, 'College');
			$object->getActiveSheet()->getStyle('B'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('C'.$rowlb, 'Employee Code');
			$object->getActiveSheet()->getStyle('C'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('D'.$rowlb, 'Name');
			$object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('E'.$rowlb, 'Staff Type');
			$object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('F'.$rowlb, 'Date of joining');
			$object->getActiveSheet()->getStyle('F'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('G'.$rowlb, 'Department');
			$object->getActiveSheet()->getStyle('G'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('H'.$rowlb, 'Designation');
			$object->getActiveSheet()->getStyle('H'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
					
	  $s ='I';
	  for($i=1;$i<=$number;$i++){
	  $j=$rowlb;		
	  $object->getActiveSheet()->setCellValue($s.$j, $i);	   
	  $object->getActiveSheet()->getStyle($s.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  ++$s;
	  }

      $object->getActiveSheet()->setCellValue($s.$rowlb,'P');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
	  $object->getActiveSheet()->setCellValue($s.$rowlb,'C-OFF');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
      $object->getActiveSheet()->setCellValue($s.$rowlb,'WO');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
      $object->getActiveSheet()->setCellValue($s.$rowlb,'OD');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
	  $object->getActiveSheet()->setCellValue($s.$rowlb,'EL');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
	  $object->getActiveSheet()->setCellValue($s.$rowlb,'ML');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
	  $object->getActiveSheet()->setCellValue($s.$rowlb,'SL');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
	  $object->getActiveSheet()->setCellValue($s.$rowlb,'VL');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
	  $object->getActiveSheet()->setCellValue($s.$rowlb,'CL');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
	  $object->getActiveSheet()->setCellValue($s.$rowlb,'WFH');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
      $object->getActiveSheet()->setCellValue($s.$rowlb,'A');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
      $object->getActiveSheet()->setCellValue($s.$rowlb,'H');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
      $object->getActiveSheet()->setCellValue($s.$rowlb,'MTL');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
      $object->getActiveSheet()->setCellValue($s.$rowlb,'latemarks');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
      $object->getActiveSheet()->setCellValue($s.$rowlb,'Deduction days for Late Marks');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
      $object->getActiveSheet()->setCellValue($s.$rowlb,'Salary Days');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
      $object->getActiveSheet()->setCellValue($s.$rowlb,'Check Days');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
      $object->getActiveSheet()->setCellValue($s.$rowlb,'DIFF for Cross verify');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);++$s;
      $object->getActiveSheet()->setCellValue($s.$rowlb,'Remark');
	  $object->getActiveSheet()->getStyle($s.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1)->applyFromArray($styleArray);	  
	  $rowlb++;
	  $srno=1;
//$staff_type='';  
	  foreach($all_emp as $e){
		   
		     	  
			  $det = $this->Admin_model->getEmployeeById1($e['emp_id'],'y');
			  $name = $det[0]['fname']." ".$det[0]['mname']." ".$det[0]['lname'];
			  $staff_type=$det[0]['staff_type'];
			  
			   if($staff_type==1)
			  {
				  $staff_type='Technical';
			  }
		      elseif($staff_type==2)
			  {
				   $staff_type='Non-Technical';
			  }
			  elseif($staff_type==3)
			  {
				   $staff_type='Teaching';
			  }
              else{				   
				  $staff_type='IC-Staff-HO';
			  }

		    $object->getActiveSheet()->setCellValue('A'.$rowlb, $srno);
			$object->getActiveSheet()->getStyle('A'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
			$object->getActiveSheet()->setCellValue('B'.$rowlb, $det[0]['college_name']);
			$object->getActiveSheet()->getStyle('B'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
			$object->getActiveSheet()->setCellValue('C'.$rowlb, $e['emp_id']);
			$object->getActiveSheet()->getStyle('C'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
			$object->getActiveSheet()->setCellValue('D'.$rowlb, $name);
			$object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
			$object->getActiveSheet()->setCellValue('E'.$rowlb, $staff_type);
			$object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
			$object->getActiveSheet()->setCellValue('F'.$rowlb, $det[0]['joiningDate']);
			$object->getActiveSheet()->getStyle('F'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
			$object->getActiveSheet()->setCellValue('G'.$rowlb, $det[0]['department_name']);
			$object->getActiveSheet()->getStyle('G'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
			$object->getActiveSheet()->setCellValue('H'.$rowlb, $det[0]['designation_name']);
			$object->getActiveSheet()->getStyle('H'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
			
			
$lpharray=array();
foreach($attendance[$e['emp_id']] as $att){ 
$d=date('d',strtotime($att['Intime']));
$d = intval($d);
$dayIn[$e['emp_id']][$d]=$d; //array for only punched In day 
$tempdayin[$e['emp_id']][$d]=$dayIn[$e['emp_id']][$d];
$timedayin[$e['emp_id']][$d]=$att['Intime'];
$status[$e['emp_id']][$d]=$att['status'];
$leave[$e['emp_id']][$d]=$att['leave_type'];
$durl[$e['emp_id']][$d]=$att['leave_duration'];
$reml[$e['emp_id']][$d]=$att['remark'];

//echo $d.'---'.$att['remark'];echo '<br>';

if($att['late_mark']=='1'){
$latemark[$e['emp_id']][$d]=$att['late_mark'];
}
if($att['early_mark']=='Y'){
	$earlymark[$e['emp_id']][$d]=$att['early_mark'];
}


//if(!empty($att['special_case'])){
$special_case[$e['emp_id']][$d]=$att['special_case'];
//}
if($att['Outtime'] != '0000-00-00 00:00:00'){
$d=date('d',strtotime($att['Outtime']));
$d = intval( $d);
//echo "<br/>";
$dayOut[$e['emp_id']][$d]=$d; //array for only punched In day 
$tempdayout[$e['emp_id']][$d]=$dayOut[$e['emp_id']][$d];
//echo "<br/>";
$timedayout[$e['emp_id']][$d]=$att['Outtime'];
} 

if(date('H:i:s',strtotime($att['Outtime'])) != '00:00:00' && date('H:i:s',strtotime($att['Intime'])) != '00:00:00'){
$d=date('d',strtotime($att['Outtime']));
$d = intval($d);
//  echo $att['Intime'];

if(date('h:i:s',strtotime($att['Intime']))!='00:00:00')$time1=date('H:i',strtotime($att['Intime']));else $time1='00:00';
if(date('h:i:s',strtotime($att['Outtime']))!='00:00:00')$time2=date('H:i',strtotime($att['Outtime'])); else $time2='00:00';

$diff=$this->Admin_model->get_time_difference($time1, $time2);
$dur[$d]= $diff;   
$timedayout[$e['emp_id']][$d]=$att['Outtime']; 
$timedayin[$e['emp_id']][$d]=$att['Intime']; 
}
 } 	
while(strtotime($date) <= strtotime($end)) {
$day_num = date('d', strtotime($date));
$day_name = date('D', strtotime($date));
$totaldays['total'][]=$day_num;
$totaldays['weekd'][]=$day_name ;
$date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
}


 $fc=count($totaldays['total']);


for($i=1;$i<=count($totaldays['total']);$i++){
//first check holiday and sunday ***********************
 $dname=$attend_date."-".$totaldays['total'][$i-1];

  $check_holiday=$this->Admin_model->checkHoliday_new($dname,$staff_type);//check for holiday
 $check_holiday;//die();
//echo '<br>';
if($check_holiday=='true'){
$day_name="Holiday";
}else{
$day_name = date('D', strtotime($dname));
}





// echo $day_name;
//echo $timedayin[$e['emp_id']][$temp];
if($status[$e['emp_id']][$i] =='present' && ($day_name!="Holiday" && $day_name!="Sun") ){
	
if(date('H:i',strtotime($timedayin[$e['emp_id']][$i])) !='00:00'){
//  if($durl[$e['emp_id']][$i] != '1' ){
//  echo date('H:i',strtotime($timedayin[$e['emp_id']][$temp]));
$total_count[$e['emp_id']]['present'][]='1';
// }
}

if($e['emp_id']=="120001"){
$total_count[$e['emp_id']]['present'][]='1';
}

}elseif(($status[$e['emp_id']][$i]=='leave') || ($status[$e['emp_id']][$i]=='outduty')){
	
$ltypes=$leave[$e['emp_id']][$i];
$ltypes = strtoupper($ltypes);
$dur1 = $durl[$e['emp_id']][$i]; 

if($leave[$e['emp_id']][$i]=='WFH'){
$total_count[$e['emp_id']]['WFHH'][]='1';
}



 $rem = $reml[$e['emp_id']][$i];
//echo $rem.'-----'.$i.'-----'.$e.'---'.$dur1; echo '<br>';
if((trim($dur1)=='0.5')&& ($rem == 'hrs' || $rem == 'half-day')){
//	echo $rem.'-----'.$i.'-----'.$e.'---'.$dur1.'---'.$ltypes; echo '<br>';
//echo 'Check1';echo '<br>';
if(substr($ltypes, -1) === '*'){
	// echo 'kk';//exit;
   $total_count[$e['emp_id']]['LWP'][]='0.5';
   $total_count[$e['emp_id']][substr($ltypes,0,-1)][]=$dur1;
}else{
   // echo 'jj';//exit;
 
  if(trim($rem) === 'hrs'){
  $total_count[$e['emp_id']][$ltypes][]='0.5';
  $total_count[$e['emp_id']]['present'][]='0.5';
  //$total_count[$e['emp_id']]['present'][]='0.5';
   }else{
	  //  echo $rem.'mm';//exit;
   $total_count[$e['emp_id']][$ltypes][]=$dur1;
   $total_count[$e['emp_id']]['present'][]='0.5';
   
   }
   
}

}else{  
//echo 'Check2';echo '<br>';
 // echo trim($rem);
if(trim($rem) === 'hrs'){
$total_count[$e['emp_id']][$ltypes][]='0.5';
$total_count[$e['emp_id']]['present'][]='0.5';
}else{
$total_count[$e['emp_id']][$ltypes][]=$dur1;
}


}


}  
$temp1=array_search($i,$tempdayin[$e['emp_id']]);
//echo $status[$e['emp_id']][$i];

if($status[$e['emp_id']][$i]=='holiday' || $status[$e['emp_id']][$i]=='sunday'){
  $col = 'color:red;';
  
}else{
  $col ='';
}


 $cd = date('d'); //echo '<br>';
 $cm = date('m');//echo '<br>';
 $ad = date_parse_from_format("m",$attend_date);
//echo $i;echo '<br>';
//echo $cm.'--';print_r($ad);


if($cm==$ad){
//	echo '1';
if($i<=$cd){
	//echo $i;echo '<br>';
  if($status[$e['emp_id']][$i]=='sunday'){
   $total_count[$e['emp_id']]['sun'][] = '1';
  }
  if($status[$e['emp_id']][$i]=='holiday'){
  $total_count[$e['emp_id']]['holiday'][]='1';
  }
}

}else{
	//echo '2';
	  
  if($status[$e['emp_id']][$i]=='sunday'){
	
	 // echo  $leave[$e['emp_id']][$i]
    $total_count[$e['emp_id']]['sun'][] = '1';
  }
  if($status[$e['emp_id']][$i]=='holiday'){
	//  echo $attend_date."-".$totaldays['total'][$i-1];;
   $total_count[$e['emp_id']]['holiday'][]='1';
  }
}


if($latemark[$e['emp_id']][$i]=='1'){
	$lm = 'background-color:#D2D2D2;';
}else{
	$lm = '';
}

//echo "-".$attend_date."--".$totaldays['total'][$i-1].'---'.$leave[$e['emp_id']][$i].'----'.$status[$e['emp_id']][$i];
//echo $status[$e['emp_id']][$i].'__'.$leave[$e['emp_id']][$i+1].''.$reml[$e['emp_id']][$i];
if($status[$e['emp_id']][$i]=="sunday"){
	
	if(($status[$e['emp_id']][$i-1]=="present")&&($status[$e['emp_id']][$i+1]=="present")&&($status[$e['emp_id']][$i+1]=="leave")&&($status[$e['emp_id']][$i-2]=="leave")&&( $leave[$e['emp_id']][$i+1]!="WFH")&&( $leave[$e['emp_id']][$i-2]!="WFH")&&( $leave[$e['emp_id']][$i+1]!="OD")&&( $leave[$e['emp_id']][$i-2]!="OD")&&( $leave[$e['emp_id']][$i+1]!="SL")&&( $leave[$e['emp_id']][$i-2]!="SL")&&( $leave[$e['emp_id']][$i+1]=="LWP")&&( $leave[$e['emp_id']][$i-2]=="LWP")){
	
	$remove_lpw[] = '1';
//	echo 't';
	}
	if(($status[$e['emp_id']][$i-1]!="present")&&($status[$e['emp_id']][$i+1]!="present")){
		
		//$remove_lpw[] = '-1';
	}
	
	//echo 'A_15';
	
}


if(($leave[$e['emp_id']][$i-2]=="LWP")&&($leave[$e['emp_id']][$i-1]=="LWP")&&($status[$e['emp_id']][$i]=="sunday")&&($status[$e['emp_id']][$i+1]=="holiday")
&&($status[$e['emp_id']][$i+2]!="present")
&&($leave[$e['emp_id']][$i+1]=="LWP")){
//	echo 'Ad_10';
	//echo $status[$e['emp_id']][$i+1];
	//echo $reml[$e['emp_id']][$i-1].$reml[$e['emp_id']][$i+1];
	if(($reml[$e['emp_id']][$i-1]=="half-day")||($reml[$e['emp_id']][$i+1]=="half-day")){}else{
		//echo $reml[$e['emp_id']][$i-1].$reml[$e['emp_id']][$i+1].'_A10_';
		//print_r($status[$e['emp_id']][$i]);  echo $i;
	$remove_lpw[] = '1';
	//$remove_lph[] = '1';
	}
	//$remove_lpw[] = '1';
}




if(($status[$e['emp_id']][$i]=="holiday")&&($status[$e['emp_id']][$i+1]=="sunday")){
	
	
	if(($status[$e['emp_id']][$i+2]=="leave")&&($status[$e['emp_id']][$i-2]=="leave")&&( $leave[$e['emp_id']][$i+2]!="WFH")&&
	( $leave[$e['emp_id']][$i-2]!="WFH")&&( $leave[$e['emp_id']][$i-2]!="OD")&&( $leave[$e['emp_id']][$i+2]!="OD")&&
	( $leave[$e['emp_id']][$i-2]!="SL")&&( $leave[$e['emp_id']][$i+2]!="SL")&&( $leave[$e['emp_id']][$i-2]=="LWP")&&
	( $leave[$e['emp_id']][$i+2]=="LWP")){
		$status[$e['emp_id']][$i]="leave";
		$leave[$e['emp_id']][$i]="LWP";
		$remove_lph[] = '1';
	}
	//echo 'A_14';
}
//echo $durl[$e['emp_id']][$i];
if(($status[$e['emp_id']][$i]=="holiday")&&($status[$e['emp_id']][$i+1]=="sunday")&&($status[$e['emp_id']][$i+2]=="leave")){
	//echo ($durl[$e['emp_id']][$i+2]);
if($durl[$e['emp_id']][$i]=='0.5'){
	
}
//echo 'A_13';
}

//
//&&($status[$e['emp_id']][$i+2]=="LWP")

if(($leave[$e['emp_id']][$i-2]=="LWP")&&($leave[$e['emp_id']][$i-1]=="LWP")&&($status[$e['emp_id']][$i]=="sunday" &&($status[$e['emp_id']][$i+1]=="holiday"))
){

	if(($reml[$e['emp_id']][$i-1]=="half-day")||($reml[$e['emp_id']][$i+1]=="half-day")){
		
	}
	else{
	
	$status[$e['emp_id']][$i]="leave";
	$leave[$e['emp_id']][$i]="LWP";
	$remove_lph[] = '1';
	}

}


if(($leave[$e['emp_id']][$i+2]=="LWP")&&($leave[$e['emp_id']][$i-1]=="LWP")&&($status[$e['emp_id']][$i]=="sunday" &&($status[$e['emp_id']][$i+1]=="holiday"))
){

	if(($reml[$e['emp_id']][$i-1]=="half-day")||($reml[$e['emp_id']][$i+2]=="half-day")){
		
	}
	else{
	
	$status[$e['emp_id']][$i]="leave";
	$leave[$e['emp_id']][$i]="LWP";
	$remove_lph[] = '1';
	}

}


if(($leave[$e['emp_id']][$i-2]=="LWP")&&($leave[$e['emp_id']][$i-1]=="LWP")&&($status[$e['emp_id']][$i]=="sunday" &&($fc==$i))
){
	

	if(($reml[$e['emp_id']][$i-1]=="half-day")){
		
	}
	else{
	
	$status[$e['emp_id']][$i]="leave";
	$leave[$e['emp_id']][$i]="LWP";
	$remove_lph[] = '1';
	}

}





if(($status[$e['emp_id']][$i]=="holiday")&&($status[$e['emp_id']][$i+1]=="")&&($leave[$e['emp_id']][$i-1]=="LWP")){
	
	//if(($leave[$e['emp_id']][$i+2]=="LWP")&&($leave[$e['emp_id']][$i-1]=="LWP")){
		//echo $status[$e['emp_id']][$i+1].'-'.$leave[$e['emp_id']][$i-1].'/'.$e['emp_id'].'k2'; echo '<br>';
		$remove_lph[] = '1';
		$status[$e['emp_id']][$i]="leave";
		$leave[$e['emp_id']][$i]="LWP";
	//}
	
	/*if(($leave[$e['emp_id']][$i+1]=="LWP")&&($leave[$e['emp_id']][$i-1]=="LWP")){
		$remove_lph[] = '1';
	}*/
	//echo 'A_12';
}

if(($status[$e['emp_id']][$i]=="holiday")&&($status[$e['emp_id']][$i+1]=="holiday")){
	
	if(($leave[$e['emp_id']][$i+2]=="LWP")&&($leave[$e['emp_id']][$i-1]=="LWP")){
	//	echo 'k2';
		$remove_lph[] = '1';
		$status[$e['emp_id']][$i]="leave";
		$leave[$e['emp_id']][$i]="LWP";
	}
	
	/*if(($leave[$e['emp_id']][$i+1]=="LWP")&&($leave[$e['emp_id']][$i-1]=="LWP")){
		$remove_lph[] = '1';
	}*/
	//echo 'A_11';
}

if(($status[$e['emp_id']][$i]=="holiday")&&($status[$e['emp_id']][$i-1]=="holiday")){
	
	if(($leave[$e['emp_id']][$i-2]=="LWP")&&($leave[$e['emp_id']][$i+1]=="LWP")){
	//echo 'k3';
		$remove_lph[] = '1';
		$status[$e['emp_id']][$i]="leave";
		$leave[$e['emp_id']][$i]="LWP";
	}
	
	/*if(($leave[$e['emp_id']][$i+1]=="LWP")&&($leave[$e['emp_id']][$i-1]=="LWP")){
		$remove_lph[] = '1';
	}*/
	//echo 'A_10';
}



if(($status[$e['emp_id']][$i]=="holiday")&&($leave[$e['emp_id']][$i+1]=="LWP")&&($leave[$e['emp_id']][$i-1]=="LWP")){
	
	if(($reml[$e['emp_id']][$i-1]=="half-day")||($reml[$e['emp_id']][$i+1]=="half-day")){}else{
		$remove_lph[] = '1';
		$status[$e['emp_id']][$i]="LWP";
		//echo "rrr";
		}
	
	
	
}

if($status[$e['emp_id']][$i]=="holiday"){
//echo $leave[$e['emp_id']][$i+3];
$check_3rdstatus= $status[$e['emp_id']][$i+3];
}



if(($status[$e['emp_id']][$i]=="holiday")&&($leave[$e['emp_id']][$i+1]=="C-OFF")&&($leave[$e['emp_id']][$i-1]=="LWP")){
//	echo $status[$e['emp_id']][$i+3];
//echo $leave[$e['emp_id']][$i+3];
	//if(($leave[$e['emp_id']][$i+3]=="LWP"))
	//{}else{
	//echo $status[$e['emp_id']][$i+1];
//$remove_lpw[];
	//if(($status[$e['emp_id']][$i+2]=="leave")&&($status[$e['emp_id']][$i-2]=="leave")&&( $leave[$e['emp_id']][$i+2]!="WFH")){
		//echo $check_3rdstatus;
		if($status[$e['emp_id']][$i+3]=="present"){}else{
		//	echo 'k5';
		$remove_lph[] = '1';
	}
	//echo 'A_8';
	//}
}



if(($status[$e['emp_id']][$i]=="sunday")&&($status[$e['emp_id']][$i-2]=="holiday")&&($leave[$e['emp_id']][$i-1]=="C-OFF")&&($leave[$e['emp_id']][$i+1]=="LWP")&&($status[$e['emp_id']][$i-3]!="present")){
	
	//echo $status[$e['emp_id']][$i+1];
//$remove_lpw[];
	//if(($status[$e['emp_id']][$i+2]=="leave")&&($status[$e['emp_id']][$i-2]=="leave")&&( $leave[$e['emp_id']][$i+2]!="WFH")){
	if(($reml[$e['emp_id']][$i+1]=="half-day")){
		}else{
		$remove_lpw[] = '1';
		}
	//}
	//echo 'A_7';
}


if(($status[$e['emp_id']][$i-1]=="")&&($status[$e['emp_id']][$i]=="holiday")&&($status[$e['emp_id']][$i+1]=="sunday")&&($leave[$e['emp_id']][$i+2]=="LWP")){

		if(($reml[$e['emp_id']][$i+2]=="half-day")){
		}else{
	$remove_lpw[] = '1';
	$remove_lph[] = '1';
	}
		//$remove_lpw[] = '1';
		
		//echo 'k6';
	//}
}

if(($status[$e['emp_id']][$i-1]=="LWP")&&($status[$e['emp_id']][$i]=="holiday")&&($status[$e['emp_id']][$i+1]=="sunday")&&($leave[$e['emp_id']][$i+2]=="LWP")){
		$status[$e['emp_id']][$i]="LWP";
	
		$remove_lph[] = '1';
	//}
}
//echo $leave[$e['emp_id']][$i-1];
if(($leave[$e['emp_id']][$i-1]=="LWP")&&($status[$e['emp_id']][$i]=="sunday")&&($leave[$e['emp_id']][$i+1]=="LWP")){
		
	if(($reml[$e['emp_id']][$i+1]=="half-day") || ($reml[$e['emp_id']][$i-1]=="half-day")){
		}else{
	$remove_lpw[] = '1';
	$status[$e['emp_id']][$i]="leave";
		$leave[$e['emp_id']][$i]="LWP";
	}
	
}


if(($leave[$e['emp_id']][$i-2]=="LWP")&&($status[$e['emp_id']][$i-1]=="holiday")&&($status[$e['emp_id']][$i]=="sunday")&&($leave[$e['emp_id']][$i+1]=="LWP")){
	$status[$e['emp_id']][$i]="leave";
		$leave[$e['emp_id']][$i]="LWP";
	$remove_lpw[] = '1';
	//echo 'A_3';
}

if(($status[$e['emp_id']][$i-4]!="present")&&($status[$e['emp_id']][$i-3]=="holiday")&&($status[$e['emp_id']][$i-2]=="holiday")&&($status[$e['emp_id']][$i-1]=="holiday")&&($status[$e['emp_id']][$i]=="sunday")&&($leave[$e['emp_id']][$i+1]=="LWP")){
	if(($reml[$e['emp_id']][$i+1]=="half-day")){
	}else{
	$remove_lpw[] = '1';
	}
	//echo 'A_2';
}

if(($status[$e['emp_id']][$i-3]=="present")&&($status[$e['emp_id']][$i-2]=="holiday")&&($status[$e['emp_id']][$i-1]=="holiday")&&($status[$e['emp_id']][$i]=="sunday")&&($leave[$e['emp_id']][$i+1]=="LWP")){
	//$remove_lpw[] = '1';
	//echo 'A_1';
}
}	

$stt = 'I';$pres=0;$holy=0;$wkof=0;$odp=0;$hdd=0;$coff=0;$mll=0;$cll=0;$odh=0;$abs=0;$lev=0;$levhd=0;$wfh=0;$clhd=0;$el=0;$sl=0;$vl=0;$mtl=0;$ltmrk=0;$deltmrk=0;$saldy=0;
$chkdy=0;$diffcr=0;$oth=0;$ltmrk=0;$ltmdy=0;$cofh=0;$elh=0;$vlh=0;$slh=0;$mllh=0;

	 for($i=1;$i<=$number;$i++){
		 $sts='A';
	if($status[$e['emp_id']][$i]=='present'){

if(date('H:i:s',strtotime($timedayout[$e['emp_id']][$i]))=='00:00:00' || date('H:i:s',strtotime($timedayin[$e['emp_id']][$i]))=='00:00:00')
{
}else{
$sts='P';

if(!empty($special_case[$e['emp_id']][$i])){
$sts=$special_case[$e['emp_id']][$i];
}
}
$total_count[$e['emp_id']]['present'][]='1';

}elseif($status[$e['emp_id']][$i]=='leave' || $status[$e['emp_id']][$i]=='outduty'){
	
$ltypes=$leave[$e['emp_id']][$i];
$dur1 = $durl[$e['emp_id']][$i];
 
if($ltypes=='LWP'){
 
if(trim($durl[$e['emp_id']][$i])=='0.5' && $reml[$e['emp_id']][$i]=='half-day'){
$sts=$ltypes.'(H)'; 
}else{
$sts=$ltypes; 
}
}else{
  $st = '0.5';
  if(trim($durl[$e['emp_id']][$i])=='0.5' && $reml[$e['emp_id']][$i]=='half-day'){
    $ds = '(H)';
  }elseif($reml[$e['emp_id']][$i]=='hrs'){
    $ds = '(Hrs)';
  }else{
    $ds ='(F)';
  }
$sts=$ltypes.''.$ds; 
}
$total_count[$e['emp_id']][$ltypes][]=$dur1;
}elseif($status[$e['emp_id']][$i]=='sunday'){
 $sts='WO'; 
}elseif($status[$e['emp_id']][$i]=='holiday'){
 $sts='H'; 
}
elseif($latemark[$e['emp_id']][$i]=='1'){
	$ltmrk =$ltmrk++;
	$ltmdy+=0.5;
}
	          if($sts=='P' || $sts=='SD' ){
	         $object->getActiveSheet()->setCellValue($stt.$rowlb, $sts);	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($pre);
			  $stt++;
			  $pres++;
			  }
			  elseif($sts=='H')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb, $sts);	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($hold);
			  $stt++; 
              $holy++;			  
			  }
			  elseif($sts=='WO')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb, $sts);	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($woff);
			 $stt++;
             $wkof++;			  
			  }
			  elseif($sts=='LWP')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'A');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $stt++; 
              $abs++;			  
			  }
			   elseif($sts=='A')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'A');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $stt++; 
              $abs++;			  
			  }
			   elseif($sts=='LWP(H)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'LWP(H)');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $stt++;  
              $pres+=0.5;
              $abs+=0.5;			  
			  }
			  
			  elseif($sts=='OD*(H)' )
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb, $sts);	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($odf);
			  $stt++; 
              $odh+=0.5;
              $abs+=0.5;			  
			  }
			  elseif($sts=='OD(H)' || $sts=='OD(Hrs)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb, $sts);	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($odf);
			  $stt++; 
              $odh+=0.5;
              $pres+=0.5;			  
			  }
			   elseif($sts=='OD(F)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'OD');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($odf);
			  $stt++; 
			  $odp++;
			  }
			   elseif($sts=='CL(F)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'CL');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $stt++;
              $cll++;			  
			  }
			   elseif($sts=='CL(H)' )
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'CL-HD');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $stt++; 
			  $clhd+=0.5;
			  $pres+=0.5;	
			  }
			   elseif($sts=='CL*(H)' )
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'CL-HD');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $stt++; 
			  $abs+=0.5;
			  $clhd+=0.5;	
			  }
			   elseif($sts=='Leave(F)' )
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'CL-HD');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $stt++; 
			  $pres+=1;
			  }
			
			  elseif($sts=='ML(F)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'ML');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $mll++;
			  $stt++; 
			  }	
			  elseif($sts=='ML(H)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'ML(H)');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);  
			  $stt++; 
			  $mllh+=0.5;
			  $pres+=0.5;			  
			  }			  
               elseif($sts=='C-OFF(F)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'COFF');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray( $styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $stt++;
              $coff++;			  
			  }
			      elseif($sts=='C-OFF(H)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'COFF(H)');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $stt++;
              $cofh+=0.5;
              $pres+=0.5;			  
			  }
			  elseif($sts=='SL(F)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'SL');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $stt++;
              $sl++;			  
			  }
			   elseif($sts=='SL(H)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'SL(H)');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $stt++;
              $slh+=0.5;
              $pres+=0.5;			  
			  }
			   elseif($sts=='VL(F)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'VL');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $stt++;
              $vl++;			  
			  }
			   elseif($sts=='VL(H)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'VL(H)');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $stt++;
              $vlh+=0.5;
              $pres+=0.5;			  
			  }
			    elseif($sts=='EL(F)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'EL');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $stt++;
              $el++;			  
			  }
			      elseif($sts=='EL(H)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'EL(H)');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			 $stt++;
             $elh+=0.5;
             $pres+=0.5;			  
			  }
			     elseif($sts=='WFH(F)')
			  {
			 $object->getActiveSheet()->setCellValue($stt.$rowlb,'WFH');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $stt++;
              $wfh++;			  
			  }
			    elseif($sts=='JD')
			  {
			  $object->getActiveSheet()->setCellValue($stt.$rowlb, 'P('.$sts.')');	   
	         $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($pre);
			  $stt++;
              $pres++;			  
			  }
			    elseif($sts=='SP')
			  {
			  $object->getActiveSheet()->setCellValue($stt.$rowlb, 'P('.$sts.')');	   
	          $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($pre);
			  $stt++;
              $pres++;			  
			  }
			    elseif($sts=='BL')
			  {
			  $object->getActiveSheet()->setCellValue($stt.$rowlb,'P('.$sts.')');
	          $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($pre);
			  $stt++;
              $pres++;			  
			  }
			  else
			  {
		      $object->getActiveSheet()->setCellValue($stt.$rowlb, $sts);	   
	          $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);
			  $oth++;
			  $stt++;
			  }
         }	

   $saldy=($pres+$wkof+$holy+$odp+$odh+$coff+$cofh+$mll+$mllh+$cll+$wfh+$vl+$sl+$el+$clhd+$elh+$vlh+$slh);
   
   if(($pres+$odp+$odh+$coff+$cofh+$mll+$mllh+$cll+$wfh+$vl+$sl+$el+$clhd+$elh+$vlh+$slh)==0){
	   $saldy=0;
   }
   
   $chkdy=($saldy+$abs);
   $diffcr=abs($saldy-$chkdy);
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,$pres);
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,($coff+$cofh));
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
           $object->getActiveSheet()->setCellValue($stt.$rowlb,$wkof);
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
           $object->getActiveSheet()->setCellValue($stt.$rowlb,($odp+$odh));
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
           $object->getActiveSheet()->setCellValue($stt.$rowlb,($el+$elh));
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;		   
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,($mll+$mllh));
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,($sl+$slh));
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,($vl+$vlh));
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,($cll+$clhd));
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,$wfh);
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,$abs);
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,$holy);
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,$mtl);
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,$ltmrk);
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,$ltmdy);
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,$saldy);
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,$chkdy);
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,$diffcr);
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);++$stt;
		   $object->getActiveSheet()->setCellValue($stt.$rowlb,$remark);
		   $object->getActiveSheet()->getStyle($stt.$rowlb)->applyFromArray($styleArray);
		   $rowlb++;
		   $srno++; 
		  }
 $rowlb+=2;

  $object->getActiveSheet()->setCellValue('D'.$rowlb, 'P');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($pre);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Present');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);$rowlb++;
  $object->getActiveSheet()->setCellValue('D'.$rowlb, 'A');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);  
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
  $object->getActiveSheet()->setCellValue('D'.$rowlb, 'OD');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($odf);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Outdoor-Duty');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);$rowlb++;
    $object->getActiveSheet()->setCellValue('D'.$rowlb, 'CL');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Casual Leave');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);$rowlb++;
    $object->getActiveSheet()->setCellValue('D'.$rowlb, 'ML');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Medical Leave');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);$rowlb++;
   $object->getActiveSheet()->setCellValue('D'.$rowlb, 'WFH');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Work From Home');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);$rowlb++;
   $object->getActiveSheet()->setCellValue('D'.$rowlb, 'C-OFF');
  $object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2)->applyFromArray($abst);  
  $object->getActiveSheet()->setCellValue('E'.$rowlb, 'Utilised Comp-Off');	  
  $object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray2);
  
    
$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
$objWriter->setPreCalculateFormulas(true);      
						
			echo $objWriter->save('php://output');

?>