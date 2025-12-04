<?php

            $this->load->library("excel");
            $object = new PHPExcel();
                  $object->setActiveSheetIndex(0);

            $object->getActiveSheet()->setTitle('Subject List');
             $object->getActiveSheet()->setCellValue('A1', 'Subject List');
            $object->getActiveSheet()->mergeCells('A1:K1');
            $object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(18);
            
            $object->getActiveSheet()->setCellValue('A2', $course[0]['stream_name'].', Semester: '.$semesterNo.', Batch: '.$batch.' Regulation: '.$regulation);
            $object->getActiveSheet()->mergeCells('A2:K2');
            $object->getActiveSheet()->getStyle('A2:K2')->getFont()->setBold(true);
            
            //set aligment to center for that merged cell (A1 to D1)
            $object->getActiveSheet()->getStyle('A1:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $object->getActiveSheet()->getStyle('A2:K3')->getFont()->setSize(12)->setBold(true);
           // $object->getActiveSheet()->getStyle('A3:Q3')->getFont()->setBold(true);
            
            $object->getActiveSheet()->setCellValue('A3', 'S.No');
            $object->getActiveSheet()->setCellValue('B3', 'Code');
            $object->getActiveSheet()->setCellValue('C3', 'Subject Name');			$object->getActiveSheet()->setCellValue('D3', 'Type');			$object->getActiveSheet()->setCellValue('E3', 'Category');			$object->getActiveSheet()->setCellValue('F3', 'Order');            $object->getActiveSheet()->setCellValue('G3', 'Credits');
            $object->getActiveSheet()->setCellValue('H3', 'CIA');
            $object->getActiveSheet()->setCellValue('I3', 'TH');
            $object->getActiveSheet()->setCellValue('J3', 'PR');
            $object->getActiveSheet()->setCellValue('K3', 'Total');
            $object->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);
            	                //retrive contries table data
            
                               		$row=4;
		$j=1; 
							$sum_credits =0;
							$sum_cia =0;
							$sum_Thery =0;
							$sum_pract =0;
							$sum_tot =0;

		foreach($subj_details as $val){
		
			$total = $val['internal_max'] + $val['theory_max'];
			$sum_credits +=$val['credits'];
			$sum_cia +=$val['internal_max'];

			$sum_tot +=$total;  
			if($val['subject_component']=='TH'){
				$sum_Thery += $val['theory_max'];
			}else{
				$sum_pract += $val['theory_max'];
			}		
			if($val['subject_component']=='TH')
			{
				$th_max= $val['theory_max'];
			}else{ 
				$th_max="-";
			}
			if($val['subject_component']=='PR')
			{
				$pr_max= $val['theory_max'];
			}else{ 
				$pr_max="-";
			}
			
		 $object->getActiveSheet()->setCellValue('A'.$row, $j);
		 $object->getActiveSheet()->setCellValue('B'.$row, $val['subject_code']);			 
		  $object->getActiveSheet()->setCellValue('C'.$row, $val['subject_name']);		  $object->getActiveSheet()->setCellValue('D'.$row, $val['subject_component']);			  $object->getActiveSheet()->setCellValue('E'.$row, $val['subject_category']);			  $object->getActiveSheet()->setCellValue('F'.$row, $val['subject_order']);			  
          $object->getActiveSheet()->setCellValue('G'.$row, $val['credits']);
		  $object->getActiveSheet()->setCellValue('H'.$row, $val['internal_max']);
		  $object->getActiveSheet()->setCellValue('I'.$row, $th_max);
		  $object->getActiveSheet()->setCellValue('J'.$row, $pr_max);
		  //$object->getActiveSheet()->getStyle('G'.$row)->getFont()->setBold(true);
		  $object->getActiveSheet()->setCellValue('K'.$row, $total);
		   
		  $row = $row+1;
		  $j=$j+1;
			
		}
		
		
		$object->getActiveSheet()->setCellValue('A'.$row, 'Total');
		$object->getActiveSheet()->getStyle('A'.$row.':K'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $object->getActiveSheet()->mergeCells('A'.$row.':F'.$row);
		$object->getActiveSheet()->setCellValue('G'.$row, $sum_credits);
		$object->getActiveSheet()->setCellValue('H'.$row, $sum_cia);
		$object->getActiveSheet()->setCellValue('I'.$row, $sum_Thery);
		$object->getActiveSheet()->setCellValue('J'.$row, $sum_pract);
		$object->getActiveSheet()->setCellValue('K'.$row, $sum_tot);
		        
           $styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
 $object->getActiveSheet()->getStyle('A'.$row.':K'.$row)->getFont()->setBold(true)->setSize(15);
  $object->getActiveSheet()->getStyle('A1:K'.$row)->applyFromArray($styleArray);   

	             

	                $filename=$course[0]['stream_name'].'_'.$semesterNo.'.xls'; //save our workbook as this file name

	                header('Content-Type: application/vnd.ms-excel'); //mime type
	                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	                header('Cache-Control: max-age=0'); //no cache

	 
	                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	                //if you want to save it as .XLSX Excel 2007 format

	                $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	                //force user to download the Excel file without writing it to server's HD

	                $objWriter->save('php://output');
              
	   


?>