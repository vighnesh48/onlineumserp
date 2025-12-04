<?php
ini_set('memory_limit', '512M');
ini_set('max_execution_time', '300');
$total=count($student_data);
$total+=2;
$this->load->library('excel'); 
	  header('Content-Type: application/vnd.ms-excel');
	  header('Cache-Control: max-age=0');
	  header('Content-Disposition: attachment;filename="student_grade_sheet.xls"');
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

	  $rowlb=2;
	  $object = new PHPExcel();
                  $object->setActiveSheetIndex(0);				  
				  $object->getActiveSheet()->mergeCells('A1:C1');
				  $object->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
                  $object->getActiveSheet()->getStyle('A1:C1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');
		
				    $object->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$object->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
					$object->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
				    $object->getActiveSheet()->getStyle('A1:C1')->applyFromArray($style);					
					$object->getActiveSheet()->setCellValue('A'.($rowlb-1), 'STUDENTS GRADE SHEET');
					
							
			$object->getActiveSheet()->setCellValue('A'.$rowlb,'ORG_NAME');
			$object->getActiveSheet()->getStyle('A'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('B'.$rowlb, 'ACADEMIC_COURSE_ID');
			$object->getActiveSheet()->getStyle('B'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('C'.$rowlb, 'COURSE_NAME');
			$object->getActiveSheet()->getStyle('C'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('D'.$rowlb, 'STREAM');
			$object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('E'.$rowlb, 'REGN_NO');
			$object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('F'.$rowlb, 'RROLL');
			$object->getActiveSheet()->getStyle('F'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('G'.$rowlb, 'CNAME');
			$object->getActiveSheet()->getStyle('G'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('H'.$rowlb, 'GENDER');
			$object->getActiveSheet()->getStyle('H'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('I'.$rowlb, 'DOB');
			$object->getActiveSheet()->getStyle('I'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('J'.$rowlb, 'FNAME');
			$object->getActiveSheet()->getStyle('J'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('K'.$rowlb, 'MNAME');
			$object->getActiveSheet()->getStyle('K'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('L'.$rowlb, 'YEAR');
			$object->getActiveSheet()->getStyle('L'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('M'.$rowlb, 'MONTH');
		    $object->getActiveSheet()->getStyle('M'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('N'.$rowlb, 'EXAM_TYPE');
			$object->getActiveSheet()->getStyle('N'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('O'.$rowlb, 'TOT_CREDIT');
			$object->getActiveSheet()->getStyle('O'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('P'.$rowlb, 'TOT_CREDIT_POINTS');
			$object->getActiveSheet()->getStyle('P'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('Q'.$rowlb, 'CGPA');
			$object->getActiveSheet()->getStyle('Q'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('R'.$rowlb, 'SGPA');
			$object->getActiveSheet()->getStyle('R'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('S'.$rowlb, 'ABC_ACCOUNT_ID');
			$object->getActiveSheet()->getStyle('S'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('T'.$rowlb, 'TERM_TYPE');
			$object->getActiveSheet()->getStyle('T'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			
		
		   $ad='U';
			 for($i=1;$i<=12;$i++)
			  {
                 $j=$rowlb;			
			$object->getActiveSheet()->setCellValue($ad.$j, 'SUB'.$i.'NM');
			$object->getActiveSheet()->getStyle($ad.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);$ad++;
            $object->getActiveSheet()->setCellValue($ad.$j, 'SUB'.$i);
			$object->getActiveSheet()->getStyle($ad.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);$ad++;
			$object->getActiveSheet()->setCellValue($ad.$j, 'SUB'.$i.'_GRADE');
			$object->getActiveSheet()->getStyle($ad.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);$ad++;
			$object->getActiveSheet()->setCellValue($ad.$j, 'SUB'.$i.'_GRADE_POINTS');
			$object->getActiveSheet()->getStyle($ad.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);$ad++;
			$object->getActiveSheet()->setCellValue($ad.$j, 'SUB'.$i.'_CREDIT');
			$object->getActiveSheet()->getStyle($ad.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);$ad++;
			$object->getActiveSheet()->setCellValue($ad.$j, 'SUB'.$i.'_CREDIT_POINTS');
			$object->getActiveSheet()->getStyle($ad.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);$ad++;
			$object->getActiveSheet()->setCellValue($ad.$j, 'SUB'.$i.'_REMARKS');
			$object->getActiveSheet()->getStyle($ad.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);$ad++;
			  } 

           	foreach($student_data as $row) {
				
		   $subject_data=$this->Admin_model->fetch_subject_data($row['RROLL'],$sem,$exam_id,$row['stream_id']);
		   $credit_data=$this->Admin_model->fetch_credit_data($row['RROLL'],$sem,$exam_id,$row['stream_id']);
		   
	       $count=count($subject_data);
		   
		   	$rowlb++;
			
            $object->getActiveSheet()->setCellValue('A'.$rowlb,$row['ORG_NAME']);
			$object->getActiveSheet()->getStyle('A'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('B'.$rowlb, $row['ACADEMIC_COURSE_ID']);
			$object->getActiveSheet()->getStyle('B'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('C'.$rowlb, $row['course_name']);
			$object->getActiveSheet()->getStyle('C'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('D'.$rowlb, $row['stream_name']);
			$object->getActiveSheet()->getStyle('D'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('E'.$rowlb, '`'.$row['REGN_NO']);
			$object->getActiveSheet()->getStyle('E'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('F'.$rowlb, '`'.$row['RROLL']);
			$object->getActiveSheet()->getStyle('F'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('G'.$rowlb, $row['CNAME']);
			$object->getActiveSheet()->getStyle('G'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('H'.$rowlb, $row['gender']);
			$object->getActiveSheet()->getStyle('H'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('I'.$rowlb, $row['dob']);
			$object->getActiveSheet()->getStyle('I'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('J'.$rowlb, $row['FNAME']);
			$object->getActiveSheet()->getStyle('J'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('K'.$rowlb, $row['MNAME']);
			$object->getActiveSheet()->getStyle('K'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('L'.$rowlb, $row['YEAR']);
			$object->getActiveSheet()->getStyle('L'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('M'.$rowlb, $row['MONTH']);
			$object->getActiveSheet()->getStyle('M'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('N'.$rowlb, $row['exam_type']);
			$object->getActiveSheet()->getStyle('N'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('O'.$rowlb, $row['credits_earned']);
			$object->getActiveSheet()->getStyle('O'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('P'.$rowlb, $credit_data[0]['subj_tot_credit_points']);
			$object->getActiveSheet()->getStyle('P'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('Q'.$rowlb, $row['RESULT']);
			$object->getActiveSheet()->getStyle('Q'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('R'.$rowlb, $row['sgpa']);
			$object->getActiveSheet()->getStyle('R'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('S'.$rowlb, $row['abc_no']);
			$object->getActiveSheet()->getStyle('S'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);
			$object->getActiveSheet()->setCellValue('T'.$rowlb, $row['belongs_to']);
			$object->getActiveSheet()->getStyle('T'.$rowlb)->applyFromArray($styleArray)->applyFromArray($styleArray1);   
			
			 $add='U';
			for($i=0;$i<$count;$i++)
			  {
                $j=$rowlb;			
			$object->getActiveSheet()->setCellValue($add.$j, $subject_data[$i]['subject_name']);
			$object->getActiveSheet()->getStyle($add.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);$add++;
            $object->getActiveSheet()->setCellValue($add.$j, $subject_data[$i]['subject_code']);	
			$object->getActiveSheet()->getStyle($add.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);$add++;
			$object->getActiveSheet()->setCellValue($add.$j, $subject_data[$i]['final_grade']);
			$object->getActiveSheet()->getStyle($add.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);$add++;
			$object->getActiveSheet()->setCellValue($add.$j, $subject_data[$i]['grade_point']);
			$object->getActiveSheet()->getStyle($add.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);$add++;
			$object->getActiveSheet()->setCellValue($add.$j, $subject_data[$i]['subj_credits']);
			$object->getActiveSheet()->getStyle($add.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);$add++;
			$object->getActiveSheet()->setCellValue($add.$j, $subject_data[$i]['subgradepoints']);
			$object->getActiveSheet()->getStyle($add.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);$add++;
			$remark='';
			if($subject_data[$i]['final_grade']=="" || $subject_data[$i]['final_grade']=="F" || $subject_data[$i]['final_grade']=="NA" || $subject_data[$i]['final_grade']=="U" || $subject_data[$i]['final_grade']=="W" || $subject_data[$i]['final_grade']=="WH"  )
			{
				$remark="Reappear";
			}else{ $remark="Pass"; }
			$object->getActiveSheet()->setCellValue($add.$j, $remark);
			$object->getActiveSheet()->getStyle($add.$j)->applyFromArray($styleArray)->applyFromArray($styleArray1);$add++;
			  }
			
			}
// Required headers
header('Content-Type: application/vnd.ms-excel');

header('Cache-Control: max-age=0');	
$object->getActiveSheet()->getStyle("A2:GU".$total)->applyFromArray($styleArray);
$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
$objWriter->setPreCalculateFormulas(true);      
echo $objWriter->save('php://output');
exit;
  
?>