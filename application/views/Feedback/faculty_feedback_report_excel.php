<?php
	if($fac[0]['gender']=='male'){ $sex="Mr.";}else{$sex="Mrs.";}
		$this->load->library("excel");
		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$object->getActiveSheet()->setCellValue('A1', 'Sandip University -Nashik');
		$object->getActiveSheet()->setCellValue('A2', 'Faculty Feedback Report: '.$active_session['academic_session']." (".$active_session['academic_year'].")");
		$object->getActiveSheet()->setCellValue('A3', 'Subject: '.$sub[0]['subject_name']);
		$object->getActiveSheet()->setCellValue('H3', 'Faculty: '.$sex.' '.$fac[0]['fname'].' '.$fac[0]['lname']);
		$object->getActiveSheet()->setCellValue('A4', 'Stream: '.$StreamSrtName[0]['stream_short_name']);
		$object->getActiveSheet()->setCellValue('H4', 'Semester/Division : '.$semester.'/'.$division);
		
		$object->getActiveSheet()->setCellValue('A5', 'Sr.No');
		$object->getActiveSheet()->setCellValue('B5', 'Q1');
		$object->getActiveSheet()->setCellValue('C5', 'Q2');
		$object->getActiveSheet()->setCellValue('D5', 'Q3');
		$object->getActiveSheet()->setCellValue('E5', 'Q4');
		$object->getActiveSheet()->setCellValue('F5', 'Q5');
		$object->getActiveSheet()->setCellValue('G5', 'Q6');
		$object->getActiveSheet()->setCellValue('H5', 'Q7');
		$object->getActiveSheet()->setCellValue('I5', 'Q8');
		$object->getActiveSheet()->setCellValue('J5', 'Q9');
		$object->getActiveSheet()->setCellValue('K5', 'Q10');
		$object->getActiveSheet()->setCellValue('L5', 'Q11');
		$object->getActiveSheet()->setCellValue('M5', 'Q12');
		$object->getActiveSheet()->setCellValue('N5', 'Q13');
		$object->getActiveSheet()->setCellValue('O5', 'Remark');

		//merge cell A1 until C1

		$object->getActiveSheet()->mergeCells('A1:O1');
		$object->getActiveSheet()->mergeCells('A2:O2');
		$object->getActiveSheet()->mergeCells('A3:G3');
		$object->getActiveSheet()->mergeCells('H3:O3');
		$object->getActiveSheet()->mergeCells('A4:G4');
		$object->getActiveSheet()->mergeCells('H4:O4');
		//set aligment to center for that merged cell (A1 to C1)
		$object->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		//make the font become bold
		
		$object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

		for($col = ord('A'); $col <= ord('N'); $col++){ //set column dimension 
			$object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
			$object->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		
		//retrive contries table data

		$rowno=1;
		$x=6;
		 $arr=array(); 
		 $CNT =COUNT($marks);	
		 $outof= $CNT *5;
		foreach($marks as $row){
		
		$object->getActiveSheet()->setCellValue('A'.$x,($x-5));
		$object->getActiveSheet()->setCellValue('B'.$x, $row['Q1']);
		$object->getActiveSheet()->setCellValue('C'.$x,$row['Q2']);
		$object->getActiveSheet()->setCellValue('D'.$x,$row['Q3']);
		$object->getActiveSheet()->setCellValue('E'.$x, $row['Q4']);
		$object->getActiveSheet()->setCellValue('F'.$x, $row['Q5']);
		$object->getActiveSheet()->setCellValue('G'.$x, $row['Q6']);
		$object->getActiveSheet()->setCellValue('H'.$x, $row['Q7']);
		$object->getActiveSheet()->setCellValue('I'.$x,$row['Q8']);
		$object->getActiveSheet()->setCellValue('J'.$x, $row['Q9']);
		$object->getActiveSheet()->setCellValue('K'.$x, $row['Q10']);
		$object->getActiveSheet()->setCellValue('L'.$x, $row['Q11']);
		$object->getActiveSheet()->setCellValue('M'.$x,$row['Q12']);
		$object->getActiveSheet()->setCellValue('N'.$x, $row['Q13']);
		$object->getActiveSheet()->setCellValue('O'.$x, $row['comment']);
		$x++;
		$arr[] = $row['Q1'];
		$arr1[] = $row['Q2'];
		$arr2[] = $row['Q3'];
		$arr3[] = $row['Q4'];
		$arr4[] = $row['Q5'];
		$arr5[] = $row['Q6'];
		$arr6[] = $row['Q7'];
		$arr7[] = $row['Q8'];
		$arr8[] = $row['Q9'];
		$arr9[] = $row['Q10'];
		$arr10[] = $row['Q11'];
		$arr11[] = $row['Q12'];
		$arr12[] = $row['Q13'];

		}
		// TOTAL
		$object->getActiveSheet()->setCellValue('A'.$x,'TOTAL');
		$object->getActiveSheet()->setCellValue('B'.$x, array_sum($arr));
		$object->getActiveSheet()->setCellValue('C'.$x, array_sum($arr1));
		$object->getActiveSheet()->setCellValue('D'.$x, array_sum($arr2));
		$object->getActiveSheet()->setCellValue('E'.$x, array_sum($arr3));
		$object->getActiveSheet()->setCellValue('F'.$x, array_sum($arr4));
		$object->getActiveSheet()->setCellValue('G'.$x, array_sum($arr5));
		$object->getActiveSheet()->setCellValue('H'.$x, array_sum($arr6));
		$object->getActiveSheet()->setCellValue('I'.$x, array_sum($arr7));
		$object->getActiveSheet()->setCellValue('J'.$x, array_sum($arr8));
		$object->getActiveSheet()->setCellValue('K'.$x, array_sum($arr9));
		$object->getActiveSheet()->setCellValue('L'.$x, array_sum($arr10));
		$object->getActiveSheet()->setCellValue('M'.$x, array_sum($arr11));
		$object->getActiveSheet()->setCellValue('N'.$x, array_sum($arr12));
		$x=$x+1;
		// OUT OF
		$object->getActiveSheet()->setCellValue('A'.$x,'OUT OF');
		$object->getActiveSheet()->setCellValue('B'.$x, $outof);
		$object->getActiveSheet()->setCellValue('C'.$x, $outof);
		$object->getActiveSheet()->setCellValue('D'.$x, $outof);
		$object->getActiveSheet()->setCellValue('E'.$x, $outof);
		$object->getActiveSheet()->setCellValue('F'.$x, $outof);
		$object->getActiveSheet()->setCellValue('G'.$x, $outof);
		$object->getActiveSheet()->setCellValue('H'.$x, $outof);
		$object->getActiveSheet()->setCellValue('I'.$x, $outof);
		$object->getActiveSheet()->setCellValue('J'.$x, $outof);
		$object->getActiveSheet()->setCellValue('K'.$x, $outof);
		$object->getActiveSheet()->setCellValue('L'.$x, $outof);
		$object->getActiveSheet()->setCellValue('M'.$x, $outof);
		$object->getActiveSheet()->setCellValue('N'.$x, $outof);
		$x=$x+1;
		// percentage
		
		$object->getActiveSheet()->setCellValue('A'.$x,'Percentage%');
		$object->getActiveSheet()->setCellValue('B'.$x, round(array_sum($arr)/$outof *100).'%');
		$object->getActiveSheet()->setCellValue('C'.$x, round(array_sum($arr1)/$outof *100).'%');
		$object->getActiveSheet()->setCellValue('D'.$x, round(array_sum($arr2)/$outof *100).'%');
		$object->getActiveSheet()->setCellValue('E'.$x, round(array_sum($arr3)/$outof *100).'%');
		$object->getActiveSheet()->setCellValue('F'.$x, round(array_sum($arr4)/$outof *100).'%');
		$object->getActiveSheet()->setCellValue('G'.$x, round(array_sum($arr5)/$outof *100).'%');
		$object->getActiveSheet()->setCellValue('H'.$x, round(array_sum($arr6)/$outof *100).'%');
		$object->getActiveSheet()->setCellValue('I'.$x, round(array_sum($arr7)/$outof *100).'%');
		$object->getActiveSheet()->setCellValue('J'.$x, round(array_sum($arr8)/$outof *100).'%');
		$object->getActiveSheet()->setCellValue('K'.$x, round(array_sum($arr9)/$outof *100).'%');
		$object->getActiveSheet()->setCellValue('L'.$x, round(array_sum($arr10)/$outof *100).'%');
		$object->getActiveSheet()->setCellValue('M'.$x, round(array_sum($arr11)/$outof *100).'%');
		$object->getActiveSheet()->setCellValue('N'.$x, round(array_sum($arr12)/$outof *100).'%');

		for($k=0; $k<$x+1; $k++){
		$object->getActiveSheet()->getStyle("A".$k.":O".$k)->applyFromArray(
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

		$filename= $StreamSrtName[0]['stream_short_name'].'_'.$semester.'_'.$division.'.xls'; //save our workbook as this file name

		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache


		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

		//if you want to save it as .XLSX Excel 2007 format

		$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

		//force user to download the Excel file without writing it to server's HD

		$objWriter->save('php://output');
  



?>