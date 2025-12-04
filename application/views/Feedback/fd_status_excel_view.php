<?php

            $this->load->library("excel");
            $object = new PHPExcel();
                  $object->setActiveSheetIndex(0);

            $object->getActiveSheet()->setTitle('Feedback');
             $object->getActiveSheet()->setCellValue('A1', 'Feedback Student Status');
            $object->getActiveSheet()->mergeCells('A1:H1');
            $object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(18);

            $object->getActiveSheet()->mergeCells('A2:H2');
            $object->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
            
            //set aligment to center for that merged cell (A1 to D1)
            $object->getActiveSheet()->getStyle('A1:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $object->getActiveSheet()->getStyle('A2:H3')->getFont()->setSize(12)->setBold(true);
           // $object->getActiveSheet()->getStyle('A3:Q3')->getFont()->setBold(true);
            
            $object->getActiveSheet()->setCellValue('A3', 'S.No');
            $object->getActiveSheet()->setCellValue('B3', 'PRN');
            $object->getActiveSheet()->setCellValue('C3', 'Student Name');			
			$object->getActiveSheet()->setCellValue('D3', 'Stream');			
			$object->getActiveSheet()->setCellValue('E3', 'Semester');			
			$object->getActiveSheet()->setCellValue('F3', 'Mobile');            
			$object->getActiveSheet()->setCellValue('G3', 'Att %');
            $object->getActiveSheet()->setCellValue('H3', 'Feedback Status');
            $object->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
            	                //retrive contries table data
            
        $row=4;
		$j=1; 
		foreach($emp_list as $val){
			$stud_name = $val['first_name']." ".$val['middle_name']." ".$val['last_name'];
			$attper = sprintf('%0.2f', $val['att_percentage']);
			if(!empty($val['status'])){ 
				$fbstatusecho = "Submitted";
			}else{ 
				$fbstatusecho = "Not Submitted";
			}
			if(!empty($val['status'])){ 
				$submitted[] = $fd+1; 
			}
		 $object->getActiveSheet()->setCellValue('A'.$row, $j);
		 $object->getActiveSheet()->setCellValue('B'.$row, '`'.$val['enrollment_no']);			 
		  $object->getActiveSheet()->setCellValue('C'.$row, $stud_name);		  
		  $object->getActiveSheet()->setCellValue('D'.$row, $val['stream_name']);			  
		  $object->getActiveSheet()->setCellValue('E'.$row, $val['current_semester']);			  
		  $object->getActiveSheet()->setCellValue('F'.$row, $val['mobile']);			  
          $object->getActiveSheet()->setCellValue('G'.$row, $attper);
		  $object->getActiveSheet()->setCellValue('H'.$row, $fbstatusecho);		   
		  $row = $row+1;
		  $j=$j+1;
			
		}
		
		$fbsubmtted = array_sum($submitted);
		$notfbsubmtted = count($emp_list) - array_sum($submitted);
		$object->getActiveSheet()->setCellValue('A'.$row, 'Total Submitted:' .$fbsubmtted);
		$object->getActiveSheet()->setCellValue('E'.$row, 'Not Submitted:' .$notfbsubmtted);
		$object->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $object->getActiveSheet()->mergeCells('A'.$row.':D'.$row);
		$object->getActiveSheet()->mergeCells('E'.$row.':H'.$row);
		        
           $styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
 $object->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true)->setSize(15);
  $object->getActiveSheet()->getStyle('A1:H'.$row)->applyFromArray($styleArray);   

	             

	                $filename='Feedback.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
	   


?>