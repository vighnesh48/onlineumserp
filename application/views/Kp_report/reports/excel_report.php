<?php
$month=explode('-',$rpt['report_month']);
$month_to_text=array('0'=>'','1'=>'JAN','2'=>'FEB','3'=>'MAR','4'=>'APR','5'=>'MAY','6'=>'JUN','7'=>'JUL','8'=>'AUG','9'=>'SEP','10'=>'OCT','11'=>'NOV','12'=>'DEC');
 $x=array_search($month[0],array_keys($month_to_text));

 if($rpt['report_type']=="1"){
	               $tit="Admission Fees";
	          }   
	          else  if($rpt['report_type']=="2"){
	               $tit="Cancelled Checque List";
	          }
	           else  if($rpt['report_type']=="3"){
	               $tit="Refund List";
	          }
	          else  if($rpt['report_type']=="4"){
	               $tit="Examination Fees List";
	          }
	    switch($rpt['report_by']){
	        case "1":
	             $tit.=" For Date:".$rpt['report_date'];
	             break;
	              case "2":
	             $tit.=" For Month:".$month_to_text[$x].'-'.$month[1];
	             break;
	              case "3":
	             $tit.=" For Duration:".$rpt['from_date']." to ".$rpt['to_date'];
	             break;
	              
	    }

       $this->load->library("excel");
                    $object = new PHPExcel();
                    $object->setActiveSheetIndex(0);
                    $object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
                    $object->getActiveSheet()->setCellValue('A2',  $tit );
                    $object->getActiveSheet()->setCellValue('A3', 'Academic Year:'.$rpt['academic_year']);
	                $object->getActiveSheet()->setCellValue('A4', 'S.No.');
	                $object->getActiveSheet()->setCellValue('B4', 'PRN No');
	                $object->getActiveSheet()->setCellValue('C4', 'Student Name');
	                $object->getActiveSheet()->setCellValue('D4','Stream');
	                $object->getActiveSheet()->setCellValue('E4', 'Year');
	                $object->getActiveSheet()->setCellValue('F4', 'Paid By');
	                $object->getActiveSheet()->setCellValue('G4', 'DD/CHQ No');
	                $object->getActiveSheet()->setCellValue('H4', 'Recept No');
	                $object->getActiveSheet()->setCellValue('I4', 'Date');
	                $object->getActiveSheet()->setCellValue('J4', 'Amount');
	                 $object->getActiveSheet()->setCellValue('K4', 'Late Fees/Fine');
	                $object->getActiveSheet()->setCellValue('L4', 'Bank Name');
	                $object->getActiveSheet()->setCellValue('M4', 'Bank City');
	                $object->getActiveSheet()->setCellValue('N4', 'Entry By');
	                $object->getActiveSheet()->setCellValue('O4', 'Status');
	                $object->getActiveSheet()->setCellValue('P4', 'Academic Year');
	                $object->getActiveSheet()->setCellValue('Q4', 'PRN Old');
	               
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
                    foreach($acc_data as $row){
                        if($row['chq_cancelled']=="E"){
                            $status="Excess";
                        }
                       else if($row['chq_cancelled']=="C"){
                            $status="Carry Forward";
                        }else{
                             $status=$row['chq_cancelled'];
                        }
                    $object->getActiveSheet()->setCellValue('A'.$x,($x-4));
                    $object->getActiveSheet()->setCellValue('B'.$x,"'". $row['enrollment_no']);
	                $object->getActiveSheet()->setCellValue('C'.$x,$row['first_name'].'  '.$row['middle_name'].'  '.$row['last_name']);
	                $object->getActiveSheet()->setCellValue('D'.$x,$row['stream_short_name']);
	                $object->getActiveSheet()->setCellValue('E'.$x,$row['year']);
	                $object->getActiveSheet()->setCellValue('F'.$x, $row['fees_paid_type']);
	                $object->getActiveSheet()->setCellValue('G'.$x, $row['receipt_no']);
	                $object->getActiveSheet()->setCellValue('H'.$x, $row['college_receiptno']);
	                $object->getActiveSheet()->setCellValue('I'.$x, $row['fdate']);
	                $object->getActiveSheet()->setCellValue('J'.$x, $row['amount']);
	                $object->getActiveSheet()->setCellValue('K'.$x, $row['exam_fee_fine']);
	                $object->getActiveSheet()->setCellValue('L'.$x, $row['bank_name']);
	                $object->getActiveSheet()->setCellValue('M'.$x, $row['bank_city']);
	                $object->getActiveSheet()->setCellValue('N'.$x, $row['username']);
	                $object->getActiveSheet()->setCellValue('O'.$x,$status);
	                $object->getActiveSheet()->setCellValue('P'.$x,$row['academic_year']);
	                $object->getActiveSheet()->setCellValue('Q'.$x,$row['enrollment_no_new']);
	               
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
 
              
	   


?>