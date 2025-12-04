<?php
 $acd_yer =$this->config->item('current_year');
 $acd_sess =$this->config->item('current_sess');
 $CI =& get_instance();
 $CI->load->model('Student_attendance_model');
$this->load->library('excel'); 
				header('Content-Type: application/vnd.ms-excel');
	  header('Cache-Control: max-age=0');
	  header('Content-Disposition: attachment;filename="Employee_list.xls"');
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
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));
		
		$styleArray2 = array(
    'font'  => array(
        'size'  => 8,
        'name'  => 'Times New Roman'
    ),
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));
	    $object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$object->getActiveSheet()->mergeCells('B2:K2');
		$object->getActiveSheet()->getStyle('B2:K2')->getFont()->setBold(true);
		$object->getActiveSheet()->getStyle('B2:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('B2', 'SANDIP UNIVERSITY');
		$object->getActiveSheet()->mergeCells('B3:K3');        
		$object->getActiveSheet()->getStyle('B3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('B3', 'TRIMBAK ROAD,MAHIRAVANI,NASHIK-422213');
		$object->getActiveSheet()->mergeCells('B7:K7');  
		$object->getActiveSheet()->getStyle('B7:K7')->getFont()->setBold(true);      
		$object->getActiveSheet()->getStyle('B7:K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->setCellValue('B7', 'Attendance Mark Report');
		$object->getActiveSheet()->mergeCells('B8:K8');  
		$object->getActiveSheet()->getStyle('B8:K8')->getFont()->setBold(true);      
		$object->getActiveSheet()->getStyle('B8:K8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		 if($acd_sess=='WIN'){ $sess='WINTER'; }else{ $sess='SUMMER'; }
		$object->getActiveSheet()->setCellValue('B8', 'Current Session: '.$acd_yer.' ('.$sess.')');
		$object->getActiveSheet()->mergeCells('C9:F9');      
		$object->getActiveSheet()->setCellValue('C9', 'From Date:'.$fdate.' | To Date:'.$tdate);
		$object->getActiveSheet()->setCellValue('C10', 'Sr.no');
		$object->getActiveSheet()->getStyle('C10')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('D10', 'School');
		$object->getActiveSheet()->getStyle('D10')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('E10', 'Course');
		$object->getActiveSheet()->getStyle('E10')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('F10', 'Stream');
		$object->getActiveSheet()->getStyle('F10')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('G10', 'Type');
		$object->getActiveSheet()->getStyle('G10')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('H10', 'No Of lecture Asseigned');
		$object->getActiveSheet()->getStyle('H10')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('I10', 'No of lecture taken');
		$object->getActiveSheet()->getStyle('I10')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('J10', 'Present %');
		$object->getActiveSheet()->getStyle('J10')->applyFromArray($styleArray)->applyFromArray($styleArray1);
		$object->getActiveSheet()->setCellValue('K10', 'Absent %');
		$object->getActiveSheet()->getStyle('K10')->applyFromArray($styleArray)->applyFromArray($styleArray1);

		$j=11;$p=0; $t=0;
		$kk=array();
	   $cntj=count($timtab);                          
		$k=1;
 	  for($i=0;$i<$cntj;$i++){
		  
		  $object->getActiveSheet()->getStyle('C'.$j.':K'.$j)->applyFromArray($styleArray);
		  
         $attper=$CI->Student_attendance_model->get_attendance_percentage_for_mark_report($timtab[$i]['stream_id'],$acd_yer, $acd_sess, $fdate,$tdate);
						
		if($t=='r'){
		  $t= $timtab[$i-1]['school_short_name'];
		}else{
		  $t  = $timtab[$i]['school_short_name'];
		}	  

		$object->getActiveSheet()->setCellValue('C'.$j, $k);
		if($timtab[$i]['school_short_name']!=$t){
				$sch= $timtab[$i]['school_short_name']; 
			  }else{
				  $sch='';
				  }
		$object->getActiveSheet()->setCellValue('D'.$j, $sch);
		$object->getActiveSheet()->setCellValue('E'.$j, $timtab[$i]['course_short_name']);
		$object->getActiveSheet()->setCellValue('F'.$j, $timtab[$i]['stream_name']);
		if($pdata['sub_type']!=''){
				$sub= $timtab[$i]['subject_type'];
			}else{
				$sub="TH / PR";
			}
		$object->getActiveSheet()->setCellValue('G'.$j, $sub);
		$object->getActiveSheet()->setCellValue('H'.$j, $timtab[$i]['no_of_lectures']);
		$object->getActiveSheet()->setCellValue('I'.$j, $timtab[$i]['no_lecture_taken']);
		$object->getActiveSheet()->setCellValue('J'.$j, bcdiv($attper[0]['p_per'],1,2));
		$object->getActiveSheet()->setCellValue('K'.$j, bcdiv($attper[0]['a_per'],1,2));
        
		$j++;
		$k++;
		$t='r';
		$y='';
	  }  

	 $objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('test_img');
	$objDrawing->setDescription('test_img');
	$objDrawing->setPath('assets/images/logo_exl.jpg');
	$objDrawing->setCoordinates('C1');                      
	//setOffsetX works properly
	$objDrawing->setOffsetX(5); 
	$objDrawing->setOffsetY(5);                
	//set width, height
	$objDrawing->setWidth(80); 
	$objDrawing->setHeight(80); 
	$objDrawing->setWorksheet($object->getActiveSheet());
	$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
	$objWriter->setPreCalculateFormulas(true);      
		
		
		
	echo $objWriter->save('php://output');


?>