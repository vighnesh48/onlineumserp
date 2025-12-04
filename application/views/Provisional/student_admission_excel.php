<?php


                    $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2', 'Provisional Admission Student List');
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'Prv.Reg No');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4','School');
	                 $object->getActiveSheet()->setCellValue('E4','Course');
	                $object->getActiveSheet()->setCellValue('F4','Steam');
	                $object->getActiveSheet()->setCellValue('G4', 'Year');
	                $object->getActiveSheet()->setCellValue('H4', 'Actual Fees');
	                $object->getActiveSheet()->setCellValue('I4', 'Scholarship');
	                $object->getActiveSheet()->setCellValue('J4', 'Applicable Fees');
	                $object->getActiveSheet()->setCellValue('K4', 'Fees paid');
	                $object->getActiveSheet()->setCellValue('L4', 'Admission date');
	                $object->getActiveSheet()->setCellValue('M4', 'Admission Cancelled');
	                $object->getActiveSheet()->setCellValue('N4', 'Admission Verified');
	                $object->getActiveSheet()->setCellValue('O4', 'ERP Entry Done');
                   
	                //merge cell A1 until C1

	                $object->getActiveSheet()->mergeCells('A1:O1');
	                $object->getActiveSheet()->mergeCells('A2:O2');
	                $object->getActiveSheet()->mergeCells('A3:O3');
	                //set aligment to center for that merged cell (A1 to C1)
	                $object->getActiveSheet()->getStyle('A1:O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	               
	                //make the font become bold

	                $object->getActiveSheet()->getStyle('A1:O4')->getFont()->setBold(true);

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
                    foreach($stud_data as $row){
                 
                    
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                    $object->getActiveSheet()->setCellValue('B'.$x,$row['prov_reg_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['student_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['school_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x,$row['course_type']);
	                $object->getActiveSheet()->setCellValue('F'.$x,$row['sprogramm_acro']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['admission_year']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['actual_fees']);
	                $object->getActiveSheet()->setCellValue('I'.$x,$row['exemption_fees']);
	                $object->getActiveSheet()->setCellValue('J'.$x, $row['applicable_fees']);
	                $object->getActiveSheet()->setCellValue('K'.$x, $row['fees_paid']);
	                $object->getActiveSheet()->setCellValue('L'.$x, $row['doa']);
	                $object->getActiveSheet()->setCellValue('M'.$x,$row['is_cancelled'] );
	                $object->getActiveSheet()->setCellValue('N'.$x, $row['is_verified']);
	                $object->getActiveSheet()->setCellValue('O'.$x, $row['is_confirmed']);
	               
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
   
   foreach(range('A','O') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
  $object->getActiveSheet()->getStyle('A1:O'.$x)->applyFromArray($styleArray);    
	                  

	                $filename='Provisional Admission Student List'.$academic_year.'.xls'; //save our workbook as this file name

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