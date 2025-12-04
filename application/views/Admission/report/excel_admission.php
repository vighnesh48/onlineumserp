<?php
ini_set("max_execution_time", 'time_limit');
ini_set('memory_limit', '-1');

if($report_type=="1"){
                     $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Admission Summary');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'Type');
	                $object->getActiveSheet()->setCellValue('C4', 'In-House');
	                $object->getActiveSheet()->setCellValue('D4','Partnership');
	                $object->getActiveSheet()->setCellValue('E4', 'Cancel-In House');
	                $object->getActiveSheet()->setCellValue('F4', 'Cancel Partnership');
	                $object->getActiveSheet()->setCellValue('G4', 'Overall ');
	                $object->getActiveSheet()->setCellValue('H4', 'Active');
	           
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:H1');
	                $object->getActiveSheet()->mergeCells('A2:H2');
	                $object->getActiveSheet()->mergeCells('A3:H3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:H4')->getFont()->setBold(true);

	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);

	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');


	                //retrive contries table data
    
                    $x=$adm_data[0]['new_adm']+$adm_data[0]['part_new_adm']+$adm_data[0]['cancel_new_adm']+$adm_data[0]['cancel_part_new_adm'];
                    $y=$adm_data[0]['new_adm']+$adm_data[0]['part_new_adm'];
                    $x1=$adm_data[0]['di_adm']+$adm_data[0]['part_di_adm']+$adm_data[0]['cancel_di_adm']+$adm_data[0]['cancel_part_di_adm'];
                    $y1=$adm_data[0]['di_adm']+$adm_data[0]['part_di_adm'];
                    $x2=$adm_data[0]['re_adm']+$adm_data[0]['part_re_adm']+$adm_data[0]['cancel_re_adm']+$adm_data[0]['cancel_part_re_adm'];
                    $y2=$adm_data[0]['re_adm']+$adm_data[0]['part_re_adm'];
                $z1=$adm_data[0]['new_adm_third'];
                    $object->getActiveSheet()->setCellValue('A5','1');
                    $object->getActiveSheet()->setCellValue('B5','First Year');
                    $object->getActiveSheet()->setCellValue('C5',$adm_data[0]['new_adm']);
	                $object->getActiveSheet()->setCellValue('D5',$adm_data[0]['part_new_adm']);
	                $object->getActiveSheet()->setCellValue('E5',$adm_data[0]['cancel_new_adm']);
	                $object->getActiveSheet()->setCellValue('F5',$adm_data[0]['cancel_part_new_adm']);
	                $object->getActiveSheet()->setCellValue('G5',$x);
	                $object->getActiveSheet()->setCellValue('H5',$y);
	                
	                $object->getActiveSheet()->setCellValue('A6','2');
                    $object->getActiveSheet()->setCellValue('B6','Direct Second Year');
                    $object->getActiveSheet()->setCellValue('C6',$adm_data[0]['di_adm']);
	                $object->getActiveSheet()->setCellValue('D6',$adm_data[0]['part_di_adm']);
	                $object->getActiveSheet()->setCellValue('E6',$adm_data[0]['cancel_di_adm']);
	                $object->getActiveSheet()->setCellValue('F6',$adm_data[0]['cancel_part_di_adm']);
	                $object->getActiveSheet()->setCellValue('G6',$x1);
	                $object->getActiveSheet()->setCellValue('H6',$y1);
	                
	                 $object->getActiveSheet()->setCellValue('A7','3');
                    $object->getActiveSheet()->setCellValue('B7','Direct Third Year');
                    $object->getActiveSheet()->setCellValue('C7',$adm_data[0]['new_adm_third']);
	                $object->getActiveSheet()->setCellValue('D7',0);
	                $object->getActiveSheet()->setCellValue('E7',0);
	                $object->getActiveSheet()->setCellValue('F7',0);
	                $object->getActiveSheet()->setCellValue('G7',$z1);
	                $object->getActiveSheet()->setCellValue('H7',$z1);
	               
	                $object->getActiveSheet()->setCellValue('A8','4');
                    $object->getActiveSheet()->setCellValue('B8','New Admission');
                    $object->getActiveSheet()->setCellValue('C8',$adm_data[0]['di_adm']+$adm_data[0]['new_adm']+$z1);
	                $object->getActiveSheet()->setCellValue('D8',$adm_data[0]['part_di_adm']+$adm_data[0]['part_new_adm']);
	                $object->getActiveSheet()->setCellValue('E8',$adm_data[0]['cancel_di_adm']+$adm_data[0]['cancel_new_adm']);
	                $object->getActiveSheet()->setCellValue('F8',$adm_data[0]['cancel_part_di_adm']+$adm_data[0]['cancel_part_di_adm']);
	                $object->getActiveSheet()->setCellValue('G8',$x+$x1);
	                $object->getActiveSheet()->setCellValue('H8',$y+$y1+$z1);
	                
	                $object->getActiveSheet()->setCellValue('A9','5');
                    $object->getActiveSheet()->setCellValue('B9','Re Registration');
                    $object->getActiveSheet()->setCellValue('C9',$adm_data[0]['re_adm']);
	                $object->getActiveSheet()->setCellValue('D9',$adm_data[0]['part_re_adm']);
	                $object->getActiveSheet()->setCellValue('E9',$adm_data[0]['cancel_re_adm']);
	                $object->getActiveSheet()->setCellValue('F9',$adm_data[0]['cancel_part_re_adm']);
	                $object->getActiveSheet()->setCellValue('G9',$x2);
	                $object->getActiveSheet()->setCellValue('H9',$y2);
	                
	                 $object->getActiveSheet()->setCellValue('A10','6');
                    $object->getActiveSheet()->setCellValue('B10','Total');
                    $object->getActiveSheet()->setCellValue('C10',$adm_data[0]['new_adm']+$adm_data[0]['di_adm']+$adm_data[0]['re_adm']);
	                $object->getActiveSheet()->setCellValue('D10',$adm_data[0]['part_new_adm']+$adm_data[0]['part_di_adm']+$adm_data[0]['part_re_adm']);
	                $object->getActiveSheet()->setCellValue('E10',$adm_data[0]['cancel_new_adm']+$adm_data[0]['cancel_di_adm']+$adm_data[0]['cancel_re_adm']);
	                $object->getActiveSheet()->setCellValue('F10',$adm_data[0]['cancel_part_new_adm']+$adm_data[0]['cancel_part_di_adm']+$adm_data[0]['cancel_part_re_adm']);
	                $object->getActiveSheet()->setCellValue('G10',$x+$x1+$x2+$z1);
	                $object->getActiveSheet()->setCellValue('H10',$y+$y1+$y2+$z1);

                  
                   
                                         $object->getActiveSheet()->getStyle('B9:H10')->getFont()->setBold(true)->setSize(14);;
                    $styleArray = array(
                      'borders' => array(
                        'allborders' => array(
                          'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                      )
                    );
   
                     $object->getActiveSheet()->getStyle('A1:H10')->applyFromArray($styleArray);    
	                  

	                $filename='Admission Summary-'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
                  
                exit();
                }
       else  if($report_type=="2"){

                   $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Admission Statistics');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'School');
	                $object->getActiveSheet()->setCellValue('C4', 'Course');
	                $object->getActiveSheet()->setCellValue('D4', 'Stream');
	                $object->getActiveSheet()->setCellValue('E4', 'Year');
	                $object->getActiveSheet()->setCellValue('F4', 'Male');
	                $object->getActiveSheet()->setCellValue('G4', 'Female');
	                $object->getActiveSheet()->setCellValue('H4', 'Total ');
	                $object->getActiveSheet()->setCellValue('I4', 'Cancelled ');
	                 $object->getActiveSheet()->setCellValue('J4', 'Active ');
	               
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:J1');
	                $object->getActiveSheet()->mergeCells('A2:J2');
	                $object->getActiveSheet()->mergeCells('A3:J3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:J4')->getFont()->setBold(true);

	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);

	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

	       for($col = ord('A'); $col <= ord('B'); $col++){ //set column dimension $object->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);

	                 //change the font size

	                $object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
	                $object->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                      

	        }

	                //retrive contries table data

                    $rowno=1;
                    $x=5;
                    $total=0;
                    foreach($adm_data as $row){
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	                $object->getActiveSheet()->setCellValue('B'.$x, $row['school_short_name']);
	                $object->getActiveSheet()->setCellValue('C'.$x, $row['course_short_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x, $row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['year']);
	                $object->getActiveSheet()->setCellValue('F'.$x,$row['M']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['F']);
	                $object->getActiveSheet()->setCellValue('H'.$x, ($row['M']+$row['F']) );
	                $object->getActiveSheet()->setCellValue('I'.$x, $row['cancel_adm']);
	                $object->getActiveSheet()->setCellValue('J'.$x, ($row['M']+$row['F'])-($row['cancel_adm']));

                      $x++;
                      $rowno++;
                    }
                     $object->getActiveSheet()->mergeCells('A'.$x.':E'.$x);
                     $object->getActiveSheet()->setCellValue('A'.$x,'Total');
                     $object->getActiveSheet()->setCellValue('F'.$x,'=SUM(F5:F'.$x.')');
                     $object->getActiveSheet()->setCellValue('G'.$x,'=SUM(G5:G'.$x.')');
                     $object->getActiveSheet()->setCellValue('H'.$x,'=SUM(H5:H'.$x.')');
                     $object->getActiveSheet()->setCellValue('I'.$x,'=SUM(I5:I'.$x.')');
                     $object->getActiveSheet()->setCellValue('J'.$x,'=SUM(J5:J'.$x.')');
      $object->getActiveSheet()->getStyle('A'.$x.':J'.$x)->getFont()->setBold(true)->setSize(14);;
                  
           
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
   
  $object->getActiveSheet()->getStyle('A1:J'.$x)->applyFromArray($styleArray);    
	                  

       $filename='Admission Statistics :'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
  
    
    
   exit(); 
    
  }
       else  if($report_type=="3"){
        $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Category Wise Statistics');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'School');
	                $object->getActiveSheet()->setCellValue('C4', 'Course');
	                $object->getActiveSheet()->setCellValue('D4', 'Stream');
	                $object->getActiveSheet()->setCellValue('E4', 'Year');
	                $object->getActiveSheet()->setCellValue('F4', 'Admission');
	                $object->getActiveSheet()->setCellValue('I4', 'Category');
	                $object->getActiveSheet()->setCellValue('AJ4', 'Religion ');
	                $object->getActiveSheet()->setCellValue('BB4', 'Handicap');
	                $object->getActiveSheet()->setCellValue('BE4', 'Domicile');
					$object->getActiveSheet()->setCellValue('BH4', 'International');
					$object->getActiveSheet()->setCellValue('BK4', 'Cancelled');
					$object->getActiveSheet()->setCellValue('BL4', 'Active');
					
					 $object->getActiveSheet()->setCellValue('F5', 'Overall');
					 $object->getActiveSheet()->setCellValue('I5', 'GM');
					 $object->getActiveSheet()->setCellValue('L5', 'OBC');
					 $object->getActiveSheet()->setCellValue('O5', 'SC');
					 $object->getActiveSheet()->setCellValue('R5', 'ST');
					 				
					 
					 $object->getActiveSheet()->setCellValue('U5', 'SBC');
					  $object->getActiveSheet()->setCellValue('X5', 'VJDT-A');
					   $object->getActiveSheet()->setCellValue('AA5', 'NT-D');
					    $object->getActiveSheet()->setCellValue('AD5', 'NT-C');
					     $object->getActiveSheet()->setCellValue('AG5', 'NT-B');
					 
					 $object->getActiveSheet()->setCellValue('AJ5', 'Hindu');
					  $object->getActiveSheet()->setCellValue('AM5', 'Sikh');
					   $object->getActiveSheet()->setCellValue('AP5', 'Jain');
					    $object->getActiveSheet()->setCellValue('AS5', 'Chri');
					     $object->getActiveSheet()->setCellValue('AV5', 'Mus');
					     $object->getActiveSheet()->setCellValue('AY5', 'Budh');
				
					     
					     
					 $object->getActiveSheet()->setCellValue('F6', 'M');
					 $object->getActiveSheet()->setCellValue('G6', 'F');
					 $object->getActiveSheet()->setCellValue('H6', 'T');
					
					 $object->getActiveSheet()->setCellValue('I6', 'M');
					 $object->getActiveSheet()->setCellValue('J6', 'F');
					 $object->getActiveSheet()->setCellValue('K6', 'T');
					 $object->getActiveSheet()->setCellValue('L6', 'M');
					 $object->getActiveSheet()->setCellValue('M6', 'F');
					 $object->getActiveSheet()->setCellValue('N6', 'T');
					 $object->getActiveSheet()->setCellValue('O6', 'M');
					 $object->getActiveSheet()->setCellValue('P6', 'F');
					 $object->getActiveSheet()->setCellValue('Q6', 'T');
					 $object->getActiveSheet()->setCellValue('R6', 'M');
					 $object->getActiveSheet()->setCellValue('S6', 'F');
					 $object->getActiveSheet()->setCellValue('T6', 'T');
					 $object->getActiveSheet()->setCellValue('U6', 'M');
					 $object->getActiveSheet()->setCellValue('V6', 'F');
					 $object->getActiveSheet()->setCellValue('W6', 'T');
					 $object->getActiveSheet()->setCellValue('X6', 'M');
					 $object->getActiveSheet()->setCellValue('Y6', 'F');
					 $object->getActiveSheet()->setCellValue('Z6', 'T');
					 $object->getActiveSheet()->setCellValue('AA6', 'M');
					 $object->getActiveSheet()->setCellValue('AB6', 'F');
					 $object->getActiveSheet()->setCellValue('AC6', 'T');
					 $object->getActiveSheet()->setCellValue('AD6', 'M');
					 $object->getActiveSheet()->setCellValue('AE6', 'F');
					 $object->getActiveSheet()->setCellValue('AF6', 'T');
					 $object->getActiveSheet()->setCellValue('AG6', 'M');
					 $object->getActiveSheet()->setCellValue('AH6', 'F');
					 $object->getActiveSheet()->setCellValue('AI6', 'T');
					 $object->getActiveSheet()->setCellValue('AJ6', 'M');
					 $object->getActiveSheet()->setCellValue('AK6', 'F');
					 $object->getActiveSheet()->setCellValue('AL6', 'T');
					  $object->getActiveSheet()->setCellValue('AM6', 'M');
					 $object->getActiveSheet()->setCellValue('AN6', 'F');
					 $object->getActiveSheet()->setCellValue('AO6', 'T');
					 
					 $object->getActiveSheet()->setCellValue('AP6', 'M');
					 $object->getActiveSheet()->setCellValue('AQ6', 'F');
					 $object->getActiveSheet()->setCellValue('AR6', 'T');
					 $object->getActiveSheet()->setCellValue('AS6', 'M');
					 $object->getActiveSheet()->setCellValue('AT6', 'F');
					 $object->getActiveSheet()->setCellValue('AU6', 'T');
					 $object->getActiveSheet()->setCellValue('AV6', 'M');
					 $object->getActiveSheet()->setCellValue('AW6', 'F');
					 $object->getActiveSheet()->setCellValue('AX6', 'T');
					 $object->getActiveSheet()->setCellValue('AY6', 'M');
					 $object->getActiveSheet()->setCellValue('AZ6', 'F');
					 $object->getActiveSheet()->setCellValue('BA6', 'T');
					  $object->getActiveSheet()->setCellValue('BB6', 'M');
					 $object->getActiveSheet()->setCellValue('BC6', 'F');
					 $object->getActiveSheet()->setCellValue('BD6', 'T');
					 
					 
					 
					 
					 
					 
					  $object->getActiveSheet()->setCellValue('BE6', 'MS');
					 $object->getActiveSheet()->setCellValue('BF6', 'OMS');
					 $object->getActiveSheet()->setCellValue('BG6', 'T');
					 
					  $object->getActiveSheet()->setCellValue('BH6', 'T');
					  $object->getActiveSheet()->setCellValue('BI6', 'M');
					 $object->getActiveSheet()->setCellValue('BJ6', 'F');
				
					      
					      
				
					  
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:BL1');
	                $object->getActiveSheet()->mergeCells('A2:BL2');
	                $object->getActiveSheet()->mergeCells('A3:BL3');
					$object->getActiveSheet()->mergeCells('A4:A6');
					$object->getActiveSheet()->mergeCells('B4:B6');
					$object->getActiveSheet()->mergeCells('C4:C6');
					$object->getActiveSheet()->mergeCells('D4:D6');
					$object->getActiveSheet()->mergeCells('E4:E6');
					$object->getActiveSheet()->mergeCells('F4:H4');
					 $object->getActiveSheet()->mergeCells('F5:H5');
					$object->getActiveSheet()->mergeCells('I4:AI4');//444
						$object->getActiveSheet()->mergeCells('I5:K5');
						$object->getActiveSheet()->mergeCells('L5:N5');
						$object->getActiveSheet()->mergeCells('O5:Q5');
						$object->getActiveSheet()->mergeCells('R5:T5');
						$object->getActiveSheet()->mergeCells('AJ4:BA4');
						$object->getActiveSheet()->mergeCells('U5:W5');
		               	$object->getActiveSheet()->mergeCells('X5:Z5');
		               		$object->getActiveSheet()->mergeCells('AA5:AC5');
		               			$object->getActiveSheet()->mergeCells('AD5:AF5');
		               				$object->getActiveSheet()->mergeCells('AG5:AI5');
		               				$object->getActiveSheet()->mergeCells('AJ5:AL5');
				
					$object->getActiveSheet()->mergeCells('BB4:BD5');
						$object->getActiveSheet()->mergeCells('BE4:BG5');
						$object->getActiveSheet()->mergeCells('BH4:BJ5');
						$object->getActiveSheet()->mergeCells('BK4:BK6');
						$object->getActiveSheet()->mergeCells('BL4:BL6');
			
					
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:BL6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:BL6')->getFont()->setBold(true);

	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);

	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

	        


	                //retrive contries table data

                    $rowno=1;
                    $x=7;
                    $total=0;
                    foreach($adm_data as $row){
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	                $object->getActiveSheet()->setCellValue('B'.$x, $row['school_short_name']);
	                $object->getActiveSheet()->setCellValue('C'.$x, $row['course_short_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x, $row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['year']);
	$object->getActiveSheet()->setCellValue('F'.$x, $row['M']);
	$object->getActiveSheet()->setCellValue('G'.$x, $row['F']);
	$object->getActiveSheet()->setCellValue('H'.$x, '=SUM(F'.$x.':G'.$x.')');
	$object->getActiveSheet()->setCellValue('I'.$x, $row['GM-M']);
	$object->getActiveSheet()->setCellValue('J'.$x, $row['GM-F']);
	$object->getActiveSheet()->setCellValue('K'.$x, '=SUM(I'.$x.':J'.$x.')');
	$object->getActiveSheet()->setCellValue('L'.$x, $row['OBC-M']);
	$object->getActiveSheet()->setCellValue('M'.$x, $row['OBC-F']);
	$object->getActiveSheet()->setCellValue('N'.$x, '=SUM(L'.$x.':M'.$x.')');
	$object->getActiveSheet()->setCellValue('O'.$x, $row['SC-M']);
	$object->getActiveSheet()->setCellValue('P'.$x, $row['SC-F']);
	$object->getActiveSheet()->setCellValue('Q'.$x, $row['SC-M']+$row['SC-F']);
	$object->getActiveSheet()->setCellValue('R'.$x, $row['ST-M']);
	$object->getActiveSheet()->setCellValue('S'.$x, $row['ST-F']);
	$object->getActiveSheet()->setCellValue('T'.$x, $row['ST-M']+$row['ST-F']);
	
	
	
	
	
	$object->getActiveSheet()->setCellValue('U'.$x, $row['SBC-M']);
	$object->getActiveSheet()->setCellValue('V'.$x, $row['SBC-F']);
	$object->getActiveSheet()->setCellValue('W'.$x, $row['SBC-M']+$row['SBC-F']);
	$object->getActiveSheet()->setCellValue('X'.$x, $row['VJDT-M']);
	$object->getActiveSheet()->setCellValue('Y'.$x, $row['VJDT-F']);
	$object->getActiveSheet()->setCellValue('Z'.$x, $row['VJDT-M']+$row['VJDT-F']);
	$object->getActiveSheet()->setCellValue('AA'.$x, $row['NT1-M']);
	$object->getActiveSheet()->setCellValue('AB'.$x, $row['NT1-F']);
	$object->getActiveSheet()->setCellValue('AC'.$x, $row['NT1-M']+$row['NT1-F']);
	$object->getActiveSheet()->setCellValue('AD'.$x, $row['NT2-M']);
	$object->getActiveSheet()->setCellValue('AE'.$x, $row['NT2-F']);
	$object->getActiveSheet()->setCellValue('AF'.$x, $row['NT2-M']+$row['NT2-F']);
	$object->getActiveSheet()->setCellValue('AG'.$x, $row['NT3-M']);
	$object->getActiveSheet()->setCellValue('AH'.$x, $row['NT3-F']);
	$object->getActiveSheet()->setCellValue('AI'.$x, $row['NT3-M']+$row['NT3-F']);
	
	
	$object->getActiveSheet()->setCellValue('AJ'.$x, $row['Hind-M']);
	$object->getActiveSheet()->setCellValue('AK'.$x, $row['Hind-F']);
	$object->getActiveSheet()->setCellValue('AL'.$x, $row['Hind-M']+ $row['Hind-F']);
	$object->getActiveSheet()->setCellValue('AM'.$x, $row['Jai-M']);
	$object->getActiveSheet()->setCellValue('AN'.$x, $row['Jai-F']);
	$object->getActiveSheet()->setCellValue('AO'.$x, $row['Jai-M']+$row['Jai-F']);
	$object->getActiveSheet()->setCellValue('AP'.$x, $row['Sik-M']);
	$object->getActiveSheet()->setCellValue('AQ'.$x, $row['Sik-F']);
	$object->getActiveSheet()->setCellValue('AR'.$x,  $row['Sik-M']+ $row['Sik-F']);
	$object->getActiveSheet()->setCellValue('AS'.$x, $row['Chri-M']); 
	$object->getActiveSheet()->setCellValue('AT'.$x, $row['Chri-F']);
	$object->getActiveSheet()->setCellValue('AU'.$x, $row['Chri-M']+ $row['Chri-F']);
	$object->getActiveSheet()->setCellValue('AV'.$x, $row['Bud-M']);
	$object->getActiveSheet()->setCellValue('AW'.$x, $row['Bud-F']);
	$object->getActiveSheet()->setCellValue('AX'.$x, $row['Bud-M']+$row['Bud-F']);
	$object->getActiveSheet()->setCellValue('AY'.$x, $row['Mus-M']);
	$object->getActiveSheet()->setCellValue('AZ'.$x, $row['Mus-F']);
	$object->getActiveSheet()->setCellValue('BA'.$x, $row['Mus-M']+ $row['Mus-F']);
	$object->getActiveSheet()->setCellValue('BB'.$x, $row['PHY-M']);
	$object->getActiveSheet()->setCellValue('BC'.$x, $row['PHY-F']);
	$object->getActiveSheet()->setCellValue('BD'.$x, $row['PHY-M']+$row['PHY-F']);
	$object->getActiveSheet()->setCellValue('BE'.$x, $row['MS']);
	$object->getActiveSheet()->setCellValue('BF'.$x, $row['OMS']);
	$object->getActiveSheet()->setCellValue('BG'.$x,  $row['MS']+ $row['OMS']);
	$object->getActiveSheet()->setCellValue('BH'.$x, $row['INT-M']);
	$object->getActiveSheet()->setCellValue('BI'.$x, $row['INT-F']);
	$object->getActiveSheet()->setCellValue('BJ'.$x, $row['INT-M']+ $row['INT-F']);
	$object->getActiveSheet()->setCellValue('BK'.$x, $row['cancel_adm']);
	$object->getActiveSheet()->setCellValue('BL'.$x, ($row['M']+$row['F'])-$row['cancel_adm']);
	                                                           
	               

                      $x++;
                      $rowno++;
                    }
                    
      $object->getActiveSheet()->getStyle('A'.$x.':BL'.$x)->getFont()->setBold(true)->setSize(14);
    
            
               
           
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
   
  $object->getActiveSheet()->getStyle('A1:BL'.$x)->applyFromArray($styleArray);    
	                  

       $filename='Category Statistics :'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
  
    
    
   exit(); 
      
}
       else  if($report_type=="4"){

                   $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'City Wise Statistics');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'City');
	                $object->getActiveSheet()->setCellValue('C4', 'State');
	                $object->getActiveSheet()->setCellValue('D4', 'Total');
	                $object->getActiveSheet()->setCellValue('E4', 'B.Tech');
	                $object->getActiveSheet()->setCellValue('F4', 'M.Tech');
	                $object->getActiveSheet()->setCellValue('G4', 'LLB');
	                $object->getActiveSheet()->setCellValue('H4', 'LLM');
	                $object->getActiveSheet()->setCellValue('I4', 'D.Pharma');
	                $object->getActiveSheet()->setCellValue('J4', 'BBA');
	                $object->getActiveSheet()->setCellValue('K4', 'MBA');
	                $object->getActiveSheet()->setCellValue('L4', 'BSC');
	                $object->getActiveSheet()->setCellValue('M4', 'MSC');
	                $object->getActiveSheet()->setCellValue('N4', 'BCA');
	                $object->getActiveSheet()->setCellValue('O4', 'MCA');
	                $object->getActiveSheet()->setCellValue('P4', 'BSC-CS');
	                $object->getActiveSheet()->setCellValue('Q4', 'MSC-CS');
	                $object->getActiveSheet()->setCellValue('R4', 'BCOM');
	                $object->getActiveSheet()->setCellValue('S4', 'MCOM');
	                $object->getActiveSheet()->setCellValue('T4', 'BA');
	                $object->getActiveSheet()->setCellValue('U4', 'MA');
	                $object->getActiveSheet()->setCellValue('V4', 'CERT');
	               
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:V1');
	                $object->getActiveSheet()->mergeCells('A2:V2');
	                $object->getActiveSheet()->mergeCells('A3:V3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:V3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:V4')->getFont()->setBold(true);

	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);

	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');


	                //retrive contries table data

                    $rowno=1;
                    $x=5;
                    $total=0;
                    foreach($adm_data as $row){
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	                $object->getActiveSheet()->setCellValue('B'.$x, $row['district_name']);
	                $object->getActiveSheet()->setCellValue('C'.$x, $row['state_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x, $row['city_total']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['BTECH']);
	                $object->getActiveSheet()->setCellValue('F'.$x,$row['MTECH']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['LLB']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['LLM']);
	                $object->getActiveSheet()->setCellValue('I'.$x, $row['DPHRM']);
	                $object->getActiveSheet()->setCellValue('J'.$x, $row['BBA']);
	                $object->getActiveSheet()->setCellValue('K'.$x, $row['MBA']);
	                        $object->getActiveSheet()->setCellValue('L'.$x, $row['BSC']);
	                          $object->getActiveSheet()->setCellValue('M'.$x, $row['MSC']);
	                            $object->getActiveSheet()->setCellValue('N'.$x, $row['BCA']);
	                              $object->getActiveSheet()->setCellValue('O'.$x, $row['MCA']);
	                                $object->getActiveSheet()->setCellValue('P'.$x, $row['BCS']);
	                                  $object->getActiveSheet()->setCellValue('Q'.$x, $row['MCS']);
	                                    $object->getActiveSheet()->setCellValue('R'.$x, $row['BCOM']);
	                                      $object->getActiveSheet()->setCellValue('S'.$x, $row['MCOM']);
	                                        $object->getActiveSheet()->setCellValue('T'.$x, $row['BA']);
	                                          $object->getActiveSheet()->setCellValue('U'.$x, $row['MA']);
	                                            $object->getActiveSheet()->setCellValue('V'.$x, $row['CERT']);
	                                      
	               
                      $x++;
                      $rowno++;
                    }
                    
           
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
   
  $object->getActiveSheet()->getStyle('A1:V'.$x)->applyFromArray($styleArray);    
	                  

       $filename='City Wise Statistics-'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
  
    
    
   exit(); 
    
  }
       else  if($report_type=="5"){

                   $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'ScholorShip Studednt List');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4', 'School');
	                $object->getActiveSheet()->setCellValue('E4', 'Stream');
	                $object->getActiveSheet()->setCellValue('F4', 'Year');
	                $object->getActiveSheet()->setCellValue('G4', 'Actual Fees');
	                $object->getActiveSheet()->setCellValue('H4', 'Scholorship');
	                $object->getActiveSheet()->setCellValue('I4', 'Applicable');
	                 $object->getActiveSheet()->setCellValue('J4', 'Admission Section Remark');
	               
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:J1');
	                $object->getActiveSheet()->mergeCells('A2:J2');
	                $object->getActiveSheet()->mergeCells('A3:J3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:J4')->getFont()->setBold(true);

	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);

	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');


	                //retrive contries table data

                    $rowno=1;
                    $x=5;
                    $total=0;
                    foreach($adm_data as $row){
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	                $object->getActiveSheet()->setCellValue('B'.$x," ".$row['enrollment_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['first_name'].' ' .$row['middle_name'].' '.$row['last_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x, $row['school_short_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('F'.$x,$row['year']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['actual_fee']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['actual_fee']-$row['applicable_fee']);
	                $object->getActiveSheet()->setCellValue('I'.$x, $row['applicable_fee']);
	                   $object->getActiveSheet()->setCellValue('J'.$x, $row['admission_remark']);
                      $x++;
                      $rowno++;
                    }
                    
           
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
   
  $object->getActiveSheet()->getStyle('A1:J'.$x)->applyFromArray($styleArray);    
	                  

       $filename='ScholorShip List-'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
  
    
    
   exit(); 
    
  }
       else  if($report_type=="6"){

                   $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Cancelled Studednt List');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4', 'School');
	                $object->getActiveSheet()->setCellValue('E4', 'Stream');
	                $object->getActiveSheet()->setCellValue('F4', 'Year');
	                $object->getActiveSheet()->setCellValue('G4', 'Cancel Date');
	                $object->getActiveSheet()->setCellValue('H4', 'Cancel Fees');
	                $object->getActiveSheet()->setCellValue('I4', 'Reason');
	                $object->getActiveSheet()->setCellValue('J4', 'Mobile');
	               
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:J1');
	                $object->getActiveSheet()->mergeCells('A2:J2');
	                $object->getActiveSheet()->mergeCells('A3:J3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:J4')->getFont()->setBold(true);
	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
	                //retrive contries table data

                    $rowno=1;
                    $x=5;
                    $total=0;
                    foreach($adm_data as $row){
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	                $object->getActiveSheet()->setCellValue('B'.$x," ".$row['enrollment_no_new']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['first_name'].' ' .$row['middle_name'].' '.$row['last_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x, $row['school_short_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('F'.$x,  $row['year']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['cancel_date']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['canc_fee']);
	                $object->getActiveSheet()->setCellValue('I'.$x, "");
	                  $object->getActiveSheet()->setCellValue('J'.$x, $row['mobile']);
                      $x++;
                      $rowno++;
                    }
                    
           
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
   
  $object->getActiveSheet()->getStyle('A1:J'.$x)->applyFromArray($styleArray);    
	                  

       $filename='Cancelled List-'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
  
    
    
   exit(); 
    
  }
       else  if($report_type=="7"){

                   $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Direct Admission Student List');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4', 'School');
	                $object->getActiveSheet()->setCellValue('E4', 'Stream');
	                $object->getActiveSheet()->setCellValue('F4', 'Year');
	                $object->getActiveSheet()->setCellValue('G4', 'Mobile');
	               
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:G1');
	                $object->getActiveSheet()->mergeCells('A2:G2');
	                $object->getActiveSheet()->mergeCells('A3:G3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:G4')->getFont()->setBold(true);
	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
	                //retrive contries table data

                    $rowno=1;
                    $x=5;
                    $total=0;
                    foreach($adm_data as $row){
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	                $object->getActiveSheet()->setCellValue('B'.$x," ".$row['enrollment_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['first_name'].' ' .$row['middle_name'].' '.$row['last_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x, $row['school_short_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('F'.$x,  $row['year']);
	                $object->getActiveSheet()->setCellValue('G'.$x,  $row['mobile']);
	               
                      $x++;
                      $rowno++;
                    }
                    
           
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
   
  $object->getActiveSheet()->getStyle('A1:G'.$x)->applyFromArray($styleArray);    
	                  

       $filename='Direct Admission List-'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
  
    
    
   exit(); 
    
  }
       else  if($report_type=="8"){
			
                   $this->load->library("excel");
				   //print_r($adm_data); exit ;
				   $CI =& get_instance();
					$CI->load->model('Admission_model');
					//error_reporting(E_ALL);
					// $this->Admission_model->getpaidfees($adm_data[0]['stud_id'], $adm_data[0]['academic_year']);
                  //  $this->load->model("Admission_model");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Student List');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN');
	                $object->getActiveSheet()->setCellValue('C4', 'Form No');
	                $object->getActiveSheet()->setCellValue('D4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('E4', 'School');    
	                $object->getActiveSheet()->setCellValue('F4', 'Stream');
	                $object->getActiveSheet()->setCellValue('G4', 'Year');
	                $object->getActiveSheet()->setCellValue('H4', 'Mobile');
	                $object->getActiveSheet()->setCellValue('I4', 'Email Id');
	                $object->getActiveSheet()->setCellValue('J4', 'Parent Mobile');
					$object->getActiveSheet()->setCellValue('K4', 'Admission Date');
					$object->getActiveSheet()->setCellValue('L4', 'Admission Type');
					$object->getActiveSheet()->setCellValue('M4', 'Reported_'.$academic_year);
					$object->getActiveSheet()->setCellValue('N4', 'Lecture Attending');
					$object->getActiveSheet()->setCellValue('O4', 'Fees paid');
					$object->getActiveSheet()->setCellValue('P4', 'Opening Balance');
	               
	               
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:P1');
	                $object->getActiveSheet()->mergeCells('A2:P2');
	                $object->getActiveSheet()->mergeCells('A3:P3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:P3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:P4')->getFont()->setBold(true);
	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
	                //retrive contries table data

                    $rowno=1;
                    $x=5;
                    $total=0;
                    foreach($adm_data as $row){
						
						//$this->Admission_model->getpaidfees($row['stud_id'], $row['academic_year']); exit;
					$str = mb_substr($row['enrollment_no'], 0, 2);
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	                $object->getActiveSheet()->setCellValue('B'.$x," ".$row['enrollment_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,  $row['form_number']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['first_name'].' ' .$row['middle_name'].' '.$row['last_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['school_short_name']);
	                $object->getActiveSheet()->setCellValue('F'.$x, $row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('G'.$x,  $row['year']);
	                $object->getActiveSheet()->setCellValue('H'.$x,  $row['mobile']);
	                $object->getActiveSheet()->setCellValue('I'.$x,  $row['email']);
	                $object->getActiveSheet()->setCellValue('J'.$x,  $row['parent_mobile2']);
					if($str=='19'){
						$object->getActiveSheet()->setCellValue('K'.$x,  $row['admission_date']);
						//$object->getActiveSheet()->setCellValue('L'.$x, "New" );
					}else{
						$object->getActiveSheet()->setCellValue('K'.$x,  '-');	
						//$object->getActiveSheet()->setCellValue('L'.$x,  'RR');	
					}
					if($row['admission_session']==$row['academic_year']){
						$object->getActiveSheet()->setCellValue('L'.$x, "New" );
						$object->getActiveSheet()->setCellValue('M'.$x, "");
					}else{
						$object->getActiveSheet()->setCellValue('L'.$x, "RR" );
						$object->getActiveSheet()->setCellValue('M'.$x,  $row['reported_status']);
					}
					
					$attendance= $this->Admission_model->getattendance($row['stud_id'], $row['academic_year']);
					
					$object->getActiveSheet()->setCellValue('N'.$x,  $attendance);
					
					
					$feees= $this->Admission_model->getpaidfees($row['stud_id'], $row['academic_year']);
					$object->getActiveSheet()->setCellValue('O'.$x,  $feees[0]['fees_paid']?:0);
					$object->getActiveSheet()->setCellValue('P'.$x,  $row['opening_balance']);
                      $x++;
                      $rowno++;
                    }
                    
           
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
   
  $object->getActiveSheet()->getStyle('A1:P'.$x)->applyFromArray($styleArray);    
	                  

       $filename='Student List-'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
  
    
    
   exit(); 
    
  }
else  if($report_type=="17"){

                   $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Non Reregistered Student List');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN');
	                $object->getActiveSheet()->setCellValue('C4', 'Form No');
	                $object->getActiveSheet()->setCellValue('D4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('E4', 'School');    
	                $object->getActiveSheet()->setCellValue('F4', 'Stream');
	                $object->getActiveSheet()->setCellValue('G4', 'Year');
	                $object->getActiveSheet()->setCellValue('H4', 'Mobile');
	                $object->getActiveSheet()->setCellValue('I4', 'Email Id');
	                $object->getActiveSheet()->setCellValue('J4', 'Parent Mobile');
	               
	               
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:J1');
	                $object->getActiveSheet()->mergeCells('A2:J2');
	                $object->getActiveSheet()->mergeCells('A3:J3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:J4')->getFont()->setBold(true);
	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
	                //retrive contries table data

                    $rowno=1;
                    $x=5;
                    $total=0;
                    foreach($adm_data as $row){
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	                $object->getActiveSheet()->setCellValue('B'.$x," ".$row['enrollment_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,  $row['form_number']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['first_name'].' ' .$row['middle_name'].' '.$row['last_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['school_short_name']);
	                $object->getActiveSheet()->setCellValue('F'.$x, $row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('G'.$x,  $row['year']);
	                $object->getActiveSheet()->setCellValue('H'.$x,  $row['mobile']);
	                $object->getActiveSheet()->setCellValue('I'.$x,  $row['email']);
	                $object->getActiveSheet()->setCellValue('J'.$x,  $row['parent_mobile2']);
	              
                      $x++;
                      $rowno++;
                    }
                    
           
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
   
  $object->getActiveSheet()->getStyle('A1:J'.$x)->applyFromArray($styleArray);    
	                  

       $filename='Non Reregistered Student List-'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
  
    
    
   exit(); 
    
  }       else  if($report_type=="9"){

                   $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Parent List');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4', 'School');    
	                $object->getActiveSheet()->setCellValue('E4', 'Stream');
	                $object->getActiveSheet()->setCellValue('F4', 'Year');
	                $object->getActiveSheet()->setCellValue('G4', 'Mobile');
	                 $object->getActiveSheet()->setCellValue('H4', 'Relation');
	                 $object->getActiveSheet()->setCellValue('I4', 'Occupation');
	               
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:I1');
	                $object->getActiveSheet()->mergeCells('A2:I2');
	                $object->getActiveSheet()->mergeCells('A3:I3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:I4')->getFont()->setBold(true);
	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
	                //retrive contries table data

                    $rowno=1;
                    $x=5;
                    $total=0;
                    foreach($adm_data as $row){
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	                $object->getActiveSheet()->setCellValue('B'.$x," ".$row['enrollment_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['first_name'].' ' .$row['middle_name'].' '.$row['last_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x, $row['school_short_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('F'.$x,  $row['year']);
	                $object->getActiveSheet()->setCellValue('G'.$x,  $row['parent_mobile2']);
	                 $object->getActiveSheet()->setCellValue('H'.$x,  $row['relation']);
	                $object->getActiveSheet()->setCellValue('I'.$x,  $row['occupation']);
                      $x++;
                      $rowno++;
                    }
                    
           
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
   
  $object->getActiveSheet()->getStyle('A1:I'.$x)->applyFromArray($styleArray);    
	                  

       $filename='Student List-'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
  
    
    
   exit(); 
    
  }
       else  if($report_type=="10"){

                   $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Approval List for Academic Year:'.$academic_year);
                    $object->getActiveSheet()->setCellValue('A3', 'Programme:'.$adm_data[0]['stream_name']);
	                $object->getActiveSheet()->setCellValue('A4', 'S .No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN Form No');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name Address Email');
	                $object->getActiveSheet()->setCellValue('D4', 'Gender D.O.B  Religion  Category');    
	                $object->getActiveSheet()->setCellValue('E4', 'Mobile No/Adhar No');
	                $object->getActiveSheet()->setCellValue('F4', 'Domicile/Nationality');
	                $object->getActiveSheet()->setCellValue('G4', 'Qualification');
	                $object->getActiveSheet()->setCellValue('H4', 'Photo');
	                $object->getActiveSheet()->setCellValue('I4', 'Remark');
	         
	                $object->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
	                $object->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
	                $object->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
	                $object->getActiveSheet()->getRowDimension('4')->setRowHeight(40);
	                $object->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	               
	                

	               $object->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setWrapText(true);

	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:I1');
	                $object->getActiveSheet()->mergeCells('A2:I2');
	                $object->getActiveSheet()->mergeCells('A3:I3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:I4')->getFont()->setBold(true);
	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
	                //retrive contries table data

                    $rowno=1;
                    $x=5;
                    $total=0;
                    foreach($adm_data as $row){
                        
                         if($row['taluka_name']==$row['district_name'] ){
										        $ads=$row['taluka_name'];
										    }
										    else{
										        $ads=$row['taluka_name'].'  '.$row['district_name'] ;
										    }
										    
										  if($row['degree_type1']=="SSC"){
										    $qual1='SSC,'.sprintf('%0.2f',$row['percentage1']).','.$row['passing_year1'];
										}
										if($stud['degree_type2']=="HSC"){
										    $qual2= 'HSC,'.sprintf('%0.2f',$row['percentage2']).','.$row['passing_year2'];
										}
										if($stud['degree_type3']=="Diploma"){
										    $qual3= 'Diploma,'.sprintf('%0.2f',$row['percentage3']).','.$row['passing_year3'];
										}
										if($stud['degree_type4']=="Graduation"){
										    $qual4= 'UG,'.sprintf('%0.2f',$row['percentage4']).','.$row['passing_year4'];
										}
										if($stud['degree_type5']=="Post Graduation"){
										    $qual5= 'PG,'.sprintf('%0.2f',$row['percentage5']).','.$row['passing_year5'];
										}
										 if($row['cancelled_admission']=="Y"){$remark="Admission Cancelled";}
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	                $object->getActiveSheet()->setCellValue('B'.$x," ".$row['enrollment_no']." ".$row['enrollment_no_new'] ."".$row['form_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['first_name'].' ' .$row['middle_name'].' '.$row['last_name']." ".strtoupper($row['adds'])." ".strtoupper($ads) ." ".strtoupper($row['state_name'])."-" .$row['pincode']);
	                $object->getActiveSheet()->setCellValue('D'.$x, $row['gender']."  ".$row['dob']."  ".$row['religion']."  ".$row['category']);
	                $object->getActiveSheet()->setCellValue('E'.$x,  $row['mobile']."  ".$row['adhar_card_no']."  ".$row['blood_group']."  ");
	                $object->getActiveSheet()->setCellValue('F'.$x, $row['domicile_status']."  ".$row['nationality']."  ".$row['physically_handicap']."  ");
	                $object->getActiveSheet()->setCellValue('G'.$x, $qual1 ." ".$qual2." ".$qual3." ".$qual4." ".$qual5);
	                $object->getActiveSheet()->setCellValue('H'.$x, "");
	                $object->getActiveSheet()->setCellValue('I'.$x, $remark );
                      $x++;
                      $rowno++;
                    }
                    
           
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
   
  $object->getActiveSheet()->getStyle('A1:I'.$x)->applyFromArray($styleArray);    
	     $object->getActiveSheet()->getStyle('A1:I'.$x)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);            

       $filename='Student List-'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
  
    
    
   exit(); 
    
  }
       else  if($report_type=="14"){
		   
        $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Student Information');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4', 'School');    
	                $object->getActiveSheet()->setCellValue('E4', 'Stream');
	                $object->getActiveSheet()->setCellValue('F4', 'Year');
	                $object->getActiveSheet()->setCellValue('G4', 'Address');
	                $object->getActiveSheet()->setCellValue('H4', 'City/Taluka');
	                $object->getActiveSheet()->setCellValue('I4', 'District');
	                $object->getActiveSheet()->setCellValue('J4', 'State');
	                $object->getActiveSheet()->setCellValue('K4', 'Pincode');
	                $object->getActiveSheet()->setCellValue('L4', 'Mobile');
	                $object->getActiveSheet()->setCellValue('M4', 'Email');
	                $object->getActiveSheet()->setCellValue('N4', 'Gender');
	                $object->getActiveSheet()->setCellValue('O4', 'DOB');
	                $object->getActiveSheet()->setCellValue('P4', 'Religion');
	                $object->getActiveSheet()->setCellValue('Q4', 'Category');
	                $object->getActiveSheet()->setCellValue('R4', 'Adhar No');
	                $object->getActiveSheet()->setCellValue('S4', 'Blood Group');
	                $object->getActiveSheet()->setCellValue('T4', 'Domicile');
	                $object->getActiveSheet()->setCellValue('U4', 'Nationality');
	                $object->getActiveSheet()->setCellValue('V4', 'Handicap');
					$object->getActiveSheet()->setCellValue('W4', 'Admissioin cancelled');
					$object->getActiveSheet()->setCellValue('X4', 'CET Det');
					$object->getActiveSheet()->setCellValue('Y4', 'Last Exam Name');                
					$object->getActiveSheet()->setCellValue('Z4', 'Last Exam Marks');            
					$object->getActiveSheet()->setCellValue('AA4', 'Percentage');  
					$object->getActiveSheet()->setCellValue('AB4', 'Admission Session');  
					$object->getActiveSheet()->setCellValue('AC4', 'Last Institute');
					$object->getActiveSheet()->setCellValue('AD4', 'Board Name');
	                $object->getActiveSheet()->setCellValue('AE4', 'Country');
					$object->getActiveSheet()->setCellValue('AF4', 'Old PRN');
					$object->getActiveSheet()->setCellValue('AG4', 'Academic_year');
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:AD1');
	                $object->getActiveSheet()->mergeCells('A2:AD2');
	                $object->getActiveSheet()->mergeCells('A3:AD3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:AD3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:AG4')->getFont()->setBold(true);
	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
                    $rowno=1;
                    $x=5;
                    $total=0;
					   foreach($adm_data as $row){
							
								
					$object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	                $object->getActiveSheet()->setCellValue('B'.$x," ".$row['enrollment_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['first_name'].' ' .$row['middle_name'].' '.$row['last_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['school_short_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x,$row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('F'.$x,$row['year']);
	                $object->getActiveSheet()->setCellValue('G'.$x,$row['adds']);
	                $object->getActiveSheet()->setCellValue('H'.$x,$row['taluka_name']);
	                $object->getActiveSheet()->setCellValue('I'.$x,$row['district_name']);
	                $object->getActiveSheet()->setCellValue('J'.$x,$row['state_name']);
	                $object->getActiveSheet()->setCellValue('K'.$x,$row['pincode']);
	                $object->getActiveSheet()->setCellValue('L'.$x,$row['mobile']);
	                $object->getActiveSheet()->setCellValue('M'.$x,$row['email']);
	                $object->getActiveSheet()->setCellValue('N'.$x,$row['gender']);
	                $object->getActiveSheet()->setCellValue('O'.$x,$row['dob']);
	                $object->getActiveSheet()->setCellValue('P'.$x,$row['religion']);
	                $object->getActiveSheet()->setCellValue('Q'.$x,$row['category']);
	                $object->getActiveSheet()->setCellValue('R'.$x,$row['adhar_card_no']);
	                $object->getActiveSheet()->setCellValue('S'.$x,$row['blood_group']);
	                $object->getActiveSheet()->setCellValue('T'.$x,$row['domicile_status']);
	                $object->getActiveSheet()->setCellValue('U'.$x,$row['nationality']);
	                $object->getActiveSheet()->setCellValue('V'.$x,$row['physically_handicap']);
					$object->getActiveSheet()->setCellValue('W'.$x,$row['cancelled_admission']);
	                 $object->getActiveSheet()->setCellValue('X'.$x, $row['CET']);
	                 $object->getActiveSheet()->setCellValue('Y'.$x,$exm);
	                   $object->getActiveSheet()->setCellValue('Z'.$x, $mrk);  
	                  $object->getActiveSheet()->setCellValue('AA'.$x, $per);  
	                 $object->getActiveSheet()->setCellValue('AB'.$x,$row['admission_session']); 
					 $object->getActiveSheet()->setCellValue('AC'.$x,  $row['last_institute']); 
					 $object->getActiveSheet()->setCellValue('AC'.$x,$row['last_institute']);
					 
					 $object->getActiveSheet()->setCellValue('AD'.$x,$board_uni_name);
                     $object->getActiveSheet()->setCellValue('AE'.$x,$row['country_name']);
                     $object->getActiveSheet()->setCellValue('AE'.$x,$row['enrollment_no_new']);
                     $object->getActiveSheet()->setCellValue('AF'.$x,$row['academic_year']);
								   $x++;
								  $rowno++;					
							
					   }
					   $styleArray = array(
                      'borders' => array(
                        'allborders' => array(
                          'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                      )
                    );
					$object->getActiveSheet()->getStyle('A1:AD'.$x)->applyFromArray($styleArray); 
					$filename='Student Data-'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's
	                header('Cache-Control: max-age=0'); //no cache
	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 
	                $objWriter->save('php://output');
		   //echo "ss,a,";
		  // exit;
	                //retrive contries table data
					
					/* foreach($adm_data as $row){
                     
                      if($x < 7) { 
					  $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	                $object->getActiveSheet()->setCellValue('B'.$x," fff");
	                $object->getActiveSheet()->setCellValue('C'.$x," fff");
	                $object->getActiveSheet()->setCellValue('D'.$x, " fff");
	                $object->getActiveSheet()->setCellValue('E'.$x, " fff");
	                $object->getActiveSheet()->setCellValue('F'.$x, " fff");
	                $object->getActiveSheet()->setCellValue('G'.$x,  " fff");
	                $object->getActiveSheet()->setCellValue('H'.$x,  " fff");
	                $object->getActiveSheet()->setCellValue('I'.$x,  " fff");
	                $object->getActiveSheet()->setCellValue('J'.$x,  " fff");
	                $object->getActiveSheet()->setCellValue('K'.$x, " fff");
	                $object->getActiveSheet()->setCellValue('L'.$x, " fff");
	                $object->getActiveSheet()->setCellValue('M'.$x, " fff");
	                $object->getActiveSheet()->setCellValue('N'.$x, " fff");
	                $object->getActiveSheet()->setCellValue('O'.$x, " fff");
	                $object->getActiveSheet()->setCellValue('P'.$x,  " fff");
	                $object->getActiveSheet()->setCellValue('Q'.$x, " fff");
	                $object->getActiveSheet()->setCellValue('R'.$x,  " fff");
	                $object->getActiveSheet()->setCellValue('S'.$x, " fff");
	                $object->getActiveSheet()->setCellValue('T'.$x,  " fff");
	                $object->getActiveSheet()->setCellValue('U'.$x, " fff");
	                $object->getActiveSheet()->setCellValue('V'.$x, " fff");
					/*$object->getActiveSheet()->setCellValue('W'.$x,  $row['cancelled_admission']);
	                 $object->getActiveSheet()->setCellValue('X'.$x,  $row['CET']);
	                 $object->getActiveSheet()->setCellValue('Y'.$x,  $exm);
	                   $object->getActiveSheet()->setCellValue('Z'.$x,  $mrk);  
	                  $object->getActiveSheet()->setCellValue('AA'.$x,  $per);  
	                 $object->getActiveSheet()->setCellValue('AB'.$x,  $row['admission_session']); 
					 $object->getActiveSheet()->setCellValue('AC'.$x,  $row['last_institute']);
					 
					 $object->getActiveSheet()->setCellValue('AD'.$x,  $board_uni_name);*/
					/* }
					 $x++;
                      $rowno++;
					 }*/

					 
                    /*$styleArray = array(
                      'borders' => array(
                        'allborders' => array(
                          'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                      )
                    );
   
               $object->getActiveSheet()->getStyle('A1:V'.$x)->applyFromArray($styleArray); 
	                  

	                $filename='Asdmission Summary-'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
                  
                exit();*/

    
  }
    else  if($report_type=="15"){

                   $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Last Academic Year Student Status');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4', 'School');    
	                $object->getActiveSheet()->setCellValue('E4', 'Course');
	                $object->getActiveSheet()->setCellValue('F4', 'Stream');
	                $object->getActiveSheet()->setCellValue('G4', 'Year');
	                $object->getActiveSheet()->setCellValue('H4', 'Admissioin Status');
	               
	           
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:H1');
	                $object->getActiveSheet()->mergeCells('A2:H2');
	                $object->getActiveSheet()->mergeCells('A3:H3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:H4')->getFont()->setBold(true);
	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
	                //retrive contries table data

                    $rowno=1;
                    $x=5;
                    $total=0;
                    foreach($adm_data as $row){
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	                $object->getActiveSheet()->setCellValue('B'.$x," ".$row['reg_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['student_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x, $row['school_short_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['course_short_name']);
	                $object->getActiveSheet()->setCellValue('F'.$x,  $row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('G'.$x,  $row['current_year']);
	                $object->getActiveSheet()->setCellValue('H'.$x,  $row['Remark']);
	               
	               
	                     
                      $x++;
                      $rowno++;
                    }
                    
           
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
   
  $object->getActiveSheet()->getStyle('A1:H'.$x)->applyFromArray($styleArray);    
	                  

       $filename='Student Status-'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
  
    
    
   exit(); 
    
  }
   else  if($report_type=="16"){

                   $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Non reported Student List');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4', 'School');    
	                $object->getActiveSheet()->setCellValue('E4', 'Course');
	                $object->getActiveSheet()->setCellValue('F4', 'Stream');
	                $object->getActiveSheet()->setCellValue('G4', 'Year');
	                 $object->getActiveSheet()->setCellValue('H4', 'Mobile');
	                  $object->getActiveSheet()->setCellValue('I4', 'Email id');
	                $object->getActiveSheet()->setCellValue('J4', 'Admissioin Status');
	               
	           
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:J1');
	                $object->getActiveSheet()->mergeCells('A2:J2');
	                $object->getActiveSheet()->mergeCells('A3:J3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:J4')->getFont()->setBold(true);
	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
	                //retrive contries table data

                    $rowno=1;
                    $x=5;
                    $total=0;
                    foreach($adm_data as $row){
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	                $object->getActiveSheet()->setCellValue('B'.$x," ".$row['reg_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['student_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x, $row['school_short_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['course_short_name']);
	                $object->getActiveSheet()->setCellValue('F'.$x,  $row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('G'.$x,  $row['current_year']);
	                $object->getActiveSheet()->setCellValue('H'.$x,  $row['mobile']);
	                $object->getActiveSheet()->setCellValue('I'.$x,  $row['email']);
	                $object->getActiveSheet()->setCellValue('J'.$x,  $row['Remark']);
	               
	               
	                     
                      $x++;
                      $rowno++;
                    }
                    
           
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
   
  $object->getActiveSheet()->getStyle('A1:J'.$x)->applyFromArray($styleArray);    
	                  

       $filename='Student Status-'.$academic_year.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
  
    
    
   exit(); 
    
  }

?>