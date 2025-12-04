<?php



                    $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'PhD Registration List-');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year: 2018-19');
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                    $object->getActiveSheet()->setCellValue('B4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('C4', 'Fees');
	            
	               
	                $object->getActiveSheet()->setCellValue('D4', 'City');
	                $object->getActiveSheet()->setCellValue('E4', 'Category');
	                $object->getActiveSheet()->setCellValue('F4', 'Gender');
	                $object->getActiveSheet()->setCellValue('G4', 'Mobile');
	                $object->getActiveSheet()->setCellValue('H4', 'Email');
	            
	             $object->getActiveSheet()->setCellValue('I4','Department');
	                 $object->getActiveSheet()->setCellValue('J4', 'Research Area');
	      $object->getActiveSheet()->setCellValue('K4', 'Title of proposed Research');
  $object->getActiveSheet()->setCellValue('L4', 'Ph.D Type');
  
  
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:L1');
	                $object->getActiveSheet()->mergeCells('A2:L2');
	                $object->getActiveSheet()->mergeCells('A3:L3');
	                //set aligment to center for that merged cell (A1 to C1)
	            //    $object->getActiveSheet()->getStyle('A1:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:L4')->getFont()->setBold(true);

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
                    foreach($stud_data as $row){
                           $ptype="";
                           $rarea="";
                        if($row['admission_category']=="PT")
                        {
                        $ptype="Part Time";    
                        }
                    if($row['admission_category']=="FT")
                        {
                        $ptype="Full Time";    
                        }
                       if($row['research_area']=="O")
                        {
                        $rarea="Own Specialization";    
                        }
                    if($row['research_area']=="I")
                        {
                        $rarea="Interdisciplinary";    
                        }   
                            
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                     $object->getActiveSheet()->setCellValue('B'.$x,$row['student_name']);
                    $object->getActiveSheet()->setCellValue('C'.$x,$row['amount']);
	               
	             
	                $object->getActiveSheet()->setCellValue('D'.$x, $row['city_c']);
	                $object->getActiveSheet()->setCellValue('E'.$x, $row['category']);
	                $object->getActiveSheet()->setCellValue('F'.$x,$row['gender']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['mobile_no']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['email_id']);
	       $object->getActiveSheet()->setCellValue('I'.$x,$row['department']);
	                     $object->getActiveSheet()->setCellValue('J'.$x, $rarea);
	                          $object->getActiveSheet()->setCellValue('K'.$x, $row['research_title']);
	                               $object->getActiveSheet()->setCellValue('L'.$x, $ptype);
	      
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
   
   foreach(range('A','L') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
  $object->getActiveSheet()->getStyle('A1:L'.$x)->applyFromArray($styleArray);    
	                  

	                $filename='Provisional Admission List'.$academic_year.'.xls'; //save our workbook as this file name

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