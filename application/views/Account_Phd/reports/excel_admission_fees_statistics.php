<?php

if($admission_type=="N")
{
    $adm="New Admission";
}
else if($admission_type=="N"){
     $adm="Re-Registration";
}
else{
     $adm="All-Registration";
}
         $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
					
					if($report_type=="3")
                    $object->getActiveSheet()->setCellValue('A2', 'Admission Fees Statistics-'. $adm);
				else if($report_type=="7")
					 $object->getActiveSheet()->setCellValue('A2', 'Sem Wise Admission Fees Statistics-'. $adm);
				 
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$academic_year);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'School');
	                $object->getActiveSheet()->setCellValue('C4', 'Course');
	                $object->getActiveSheet()->setCellValue('D4', 'Stream');
					$object->getActiveSheet()->setCellValue('E4', 'Is Partnership');
					
					$object->getActiveSheet()->setCellValue('F4', 'Partnership Code');
	                $object->getActiveSheet()->setCellValue('G4', 'Year');
	                $object->getActiveSheet()->setCellValue('H4', 'Student Total');
					if($report_type=="3")
					{
	                $object->getActiveSheet()->setCellValue('I4', 'Actual Fees');
	                $object->getActiveSheet()->setCellValue('J4', 'Scholorship');
	                $object->getActiveSheet()->setCellValue('K4', 'Applicable(G-H)');
					}
					else if($report_type=="7")
					{
	                $object->getActiveSheet()->setCellValue('I4', 'Actual Fees');
	                $object->getActiveSheet()->setCellValue('J4', 'Sem Wise Scholorship');
	                $object->getActiveSheet()->setCellValue('K4', 'Sem Wise Applicable(G-H)');
					}
					
	                $object->getActiveSheet()->setCellValue('L4', 'Opening Balance');
	                $object->getActiveSheet()->setCellValue('M4', 'Charges');
	                $object->getActiveSheet()->setCellValue('N4', 'Other Fees(J+K)');
	                $object->getActiveSheet()->setCellValue('O4', 'Refund');
	                $object->getActiveSheet()->setCellValue('P4', 'Paid');
	                $object->getActiveSheet()->setCellValue('Q4','Pending(I+L-N)');
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
                    foreach($fees as $row){
                    $other=$row['cancel_charges']+$row['opening_balance'];
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
	                $object->getActiveSheet()->setCellValue('B'.$x, $row['school_short_name']);
	                $object->getActiveSheet()->setCellValue('C'.$x, $row['course_short_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x, $row['stream_short_name']);
					$object->getActiveSheet()->setCellValue('E'.$x, $row['is_partnership']);
					$object->getActiveSheet()->setCellValue('F'.$x, $row['partnership_code']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['admission_year']);
	                $object->getActiveSheet()->setCellValue('H'.$x,$row['stud_total']);
					if($report_type=="3")
					{
	                $object->getActiveSheet()->setCellValue('I'.$x, $row['actual_fees']);
	                $object->getActiveSheet()->setCellValue('J'.$x, ($row['actual_fees']-$row['applicable_total']) );
	                $object->getActiveSheet()->setCellValue('K'.$x, $row['applicable_total']);
					}
					else if($report_type=="7")
					{
	                $object->getActiveSheet()->setCellValue('I'.$x, $row['actual_fees']/2);
	                $object->getActiveSheet()->setCellValue('J'.$x, ($row['actual_fees']-$row['applicable_total'])/2 );
	                $object->getActiveSheet()->setCellValue('K'.$x, $row['applicable_total']/2);
					}
					
	                $object->getActiveSheet()->setCellValue('L'.$x, $row['opening_balance']);
	                $object->getActiveSheet()->setCellValue('M'.$x, $row['cancel_charges']);
	                $object->getActiveSheet()->setCellValue('N'.$x,  $other);
	                $object->getActiveSheet()->setCellValue('O'.$x,$row['refund']);
	                $object->getActiveSheet()->setCellValue('P'.$x, $row['fees_total']);
	                $object->getActiveSheet()->setCellValue('Q'.$x,(($row['applicable_total']+$other) -($row['fees_total']-$row['refund'])));
	               
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
   foreach(range('A','Q') as $columnID)
{
     $object->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
  $object->getActiveSheet()->getStyle('A1:Q'.$x)->applyFromArray($styleArray);    
	                  
if($report_type=="3")
       $filename='Stream Wise Admission Fees-'.$academic_year.'.xls';
   else if($report_type=="7")
	   $filename='Sem Wise Stream Wise Admission Fees-'.$academic_year.'.xls';

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
 