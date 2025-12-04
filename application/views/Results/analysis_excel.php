<?php


 if($rpt['report_type']=="1"){
	               $tit="Result Analysis Programme Wise";
	          }   
	          else  if($rpt['report_type']=="2"){
	               $tit="Result Analysis Course Wise";
	          }
	          
	    switch($rpt['report_type']){
	        case "1":
       $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2',  $tit );
                    $object->getActiveSheet()->setCellValue('A3', 'Exam Session:'.$result[0]['exam_name']);
                    $object->getActiveSheet()->setCellValue('A4', 'S.No');
	                $object->getActiveSheet()->setCellValue('B4', 'Stream');
	                $object->getActiveSheet()->setCellValue('C4', 'Semester');
	                $object->getActiveSheet()->setCellValue('D4', 'No of Appeared');
	                $object->getActiveSheet()->setCellValue('E4','P1');
	                $object->getActiveSheet()->setCellValue('F4', 'P2');
	                $object->getActiveSheet()->setCellValue('G4', 'P3');
	                $object->getActiveSheet()->setCellValue('H4', 'P4');
	                $object->getActiveSheet()->setCellValue('I4', 'P5');
	                $object->getActiveSheet()->setCellValue('J4', 'P6');
	                $object->getActiveSheet()->setCellValue('K4', 'P7');
	                 $object->getActiveSheet()->setCellValue('L4', 'P8');
	                $object->getActiveSheet()->setCellValue('M4', 'P9');
	                $object->getActiveSheet()->setCellValue('N4', 'P10');
	                $object->getActiveSheet()->setCellValue('O4', 'With Held');
	                $object->getActiveSheet()->setCellValue('P4', 'All Clear');
	                $object->getActiveSheet()->setCellValue('Q4', 'Passing (%)');
	               
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:Q1');
	                $object->getActiveSheet()->mergeCells('A2:Q2');
	                $object->getActiveSheet()->mergeCells('A3:Q3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:Q4')->getFont()->setBold(true);

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
                    foreach($result as $row){
                        
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                    $object->getActiveSheet()->setCellValue('B'.$x,$row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['semester']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['appeared']);
	                $object->getActiveSheet()->setCellValue('E'.$x,$row['sub1']);
	                $object->getActiveSheet()->setCellValue('F'.$x, $row['sub2']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['sub3']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['sub4']);
	                $object->getActiveSheet()->setCellValue('I'.$x, $row['sub5']);
	                $object->getActiveSheet()->setCellValue('J'.$x, $row['sub6']);
	                $object->getActiveSheet()->setCellValue('K'.$x, $row['sub7']);
	                $object->getActiveSheet()->setCellValue('L'.$x, $row['sub8']);
	                $object->getActiveSheet()->setCellValue('M'.$x, $row['sub9']);
	                $object->getActiveSheet()->setCellValue('N'.$x, $row['sub10']);
	                $object->getActiveSheet()->setCellValue('O'.$x,$row['with_heald']);
	                $object->getActiveSheet()->setCellValue('P'.$x,$row['all_clear']);
	                $object->getActiveSheet()->setCellValue('Q'.$x,sprintf('%.2f',round((((int)$row['all_clear']/(int)$row['appeared'])*100),2)));
	               
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
   
  $object->getActiveSheet()->getStyle('A1:Q'.$x)->applyFromArray($styleArray);    
	          
	          $filename= $tit.'.xls';
          
	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
    exit(); 
    break;
     case "2":
       $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2',  $tit );
                    $object->getActiveSheet()->setCellValue('A3', 'Exam Session:'.$result[0]['exam_name']);
                     $object->getActiveSheet()->setCellValue('A4', 'S.No');
	                $object->getActiveSheet()->setCellValue('B4', 'Stream');
	                $object->getActiveSheet()->setCellValue('C4', 'Semester');
	                $object->getActiveSheet()->setCellValue('D4', 'Code');
	                $object->getActiveSheet()->setCellValue('E4','Name');
	                $object->getActiveSheet()->setCellValue('F4', 'No of Appeared');
	                $object->getActiveSheet()->setCellValue('G4', 'Fail');
	                $object->getActiveSheet()->setCellValue('H4', 'With Held');
	                $object->getActiveSheet()->setCellValue('I4', 'All Clear');
	                $object->getActiveSheet()->setCellValue('J4', 'Passing(%)');
	               
	               
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
                    foreach($result as $row){
                        
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                    $object->getActiveSheet()->setCellValue('B'.$x,$row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['semester']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['subject_code']);
	                $object->getActiveSheet()->setCellValue('E'.$x,$row['subject_name']);
	                $object->getActiveSheet()->setCellValue('F'.$x,$row['sub_total']);
	                $object->getActiveSheet()->setCellValue('G'.$x,$row['fail']);
	                $object->getActiveSheet()->setCellValue('H'.$x,$row['withheald']);
	                $object->getActiveSheet()->setCellValue('I'.$x,$row['pass']);
	                $object->getActiveSheet()->setCellValue('J'.$x,sprintf('%.2f',round((((int)$row['pass']/(int)$row['sub_total'])*100),2)));
	               
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
	          
	          $filename= $tit.'.xls';
          
	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
    exit(); 
    break;
	    }
 
              
	   


?>