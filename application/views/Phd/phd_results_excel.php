<?php



                    $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'SUNPET Aug 2018 Results');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year: 2018-19');
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                    $object->getActiveSheet()->setCellValue('B4', 'Registration No.');
	                $object->getActiveSheet()->setCellValue('C4', 'Applicant Name');
	            
	               
	                $object->getActiveSheet()->setCellValue('D4', 'Branch');
	                $object->getActiveSheet()->setCellValue('E4', 'Degree Type');
	                $object->getActiveSheet()->setCellValue('F4', 'Marks Scored');
	              
  
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:F1');
	                $object->getActiveSheet()->mergeCells('A2:F2');
	                $object->getActiveSheet()->mergeCells('A3:F3');
	                //set aligment to center for that merged cell (A1 to C1)
	            //    $object->getActiveSheet()->getStyle('A1:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:F4')->getFont()->setBold(true);

	                $object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);

	                $object->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

	       for($col = ord('A'); $col <= ord('B'); $col++){ //set column dimension $object->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);

	                 //change the font size

	                $object->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
	              //  $object->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                      

	        }

	                //retrive contries table data

                    $rowno=1;
                    $x=5;
                    $total=0;
                    foreach($phd_data as $row){
                           $ptype="";
                           $rarea="";
                       
                     
                            
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                     $object->getActiveSheet()->setCellValue('B'.$x,$row['reg_no']);
                    $object->getActiveSheet()->setCellValue('C'.$x,$row['student_name']);
	               
	             
	                $object->getActiveSheet()->setCellValue('D'.$x, $row['stream']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['exam_type']);
	                $object->getActiveSheet()->setCellValue('F'.$x,$row['marks_obtained']);
	               
	      
                      $x++;
                      $total+= $row['amount'];
                      $rowno++;
                    }
                    
                    $object->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	                $object->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	                $object->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
   
   foreach(range('A','F') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
  $object->getActiveSheet()->getStyle('A1:F'.$x)->applyFromArray($styleArray);    
	                  

	                $filename='SUNPET Aug 2018 Results.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
	   
exit();

?>