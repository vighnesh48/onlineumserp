<?php
$role_id = $this->session->userdata("role_id");
if($role_id ==4){
	$reval = REVAL;
}else{
	$reval = $this->session->userdata('reval');
}
if($reval==0){
    $report_name="PHOTOCOPY";
    $reportName="Photocopy";
}else{
    $report_name="REVALUATION";
    $reportName="Revaluation";
}    

            $this->load->library("excel");
            $object = new PHPExcel();
            $object->setActiveSheetIndex(0);

            $object->getActiveSheet()->setTitle($reportName.' List');
             $object->getActiveSheet()->setCellValue('A1', $report_name.' LIST-'.$rev_list[0]['exam_month'].' '.$rev_list[0]['exam_year']);
            $object->getActiveSheet()->mergeCells('A1:H1');
            $object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(18);
            
            $object->getActiveSheet()->setCellValue('A2', $course[0]['stream_name']);
            $object->getActiveSheet()->mergeCells('A2:H2');
            $object->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
            
            //set aligment to center for that merged cell (A1 to D1)
            $object->getActiveSheet()->getStyle('A1:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $object->getActiveSheet()->getStyle('A2:H3')->getFont()->setSize(12)->setBold(true);
           // $object->getActiveSheet()->getStyle('A3:Q3')->getFont()->setBold(true);
            
            $object->getActiveSheet()->setCellValue('A3', 'S.No');
            $object->getActiveSheet()->setCellValue('B3', 'PRN');
            $object->getActiveSheet()->setCellValue('C3', 'Student Name');			
            $object->getActiveSheet()->setCellValue('D3', 'Semester');			
            $object->getActiveSheet()->setCellValue('E3', 'Stream Name');			
            $object->getActiveSheet()->setCellValue('F3', $reportName.' Fees');            
            $object->getActiveSheet()->setCellValue('G3', 'No. Subjects');
			$object->getActiveSheet()->setCellValue('H3', 'Payment Status');

            $object->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
            	                //retrive contries table data
            
            $row=4;
			$j=1; 

		foreach($rev_list as $val){	
        	if($reval==0){
                $fees =$val['photocopy_fees']; 
            }else{
                $fees =$val['reval_fees']; 
            }   
           $st='Paid';
             if(empty($val['amount'])){
				 $st='Not Paid'; 
			 }			
			$object->getActiveSheet()->setCellValue('A'.$row, $j);
			$object->getActiveSheet()->setCellValue('B'.$row, ' '.$val['enrollment_no']);			 
			$object->getActiveSheet()->setCellValue('C'.$row, $val['stud_name']);		  
			$object->getActiveSheet()->setCellValue('D'.$row, $val['semester']);			  
			$object->getActiveSheet()->setCellValue('E'.$row, $val['stream_short_name']);			  
			$object->getActiveSheet()->setCellValue('F'.$row, $fees);			  
			$object->getActiveSheet()->setCellValue('G'.$row, $val['sub_cnt']);
			$object->getActiveSheet()->setCellValue('H'.$row, $st);
			$row = $row+1;
			$j=$j+1;

		}		
		        
        $styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);
 		$object->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true)->setSize(15);
  		$object->getActiveSheet()->getStyle('A1:H'.$row)->applyFromArray($styleArray);   
        if($course[0]['stream_name'] !=''){
            $filename=$course[0]['stream_name'].'_'.$semesterNo.'_List.xls'; //save our workbook as this file name
        }else{
            $filename= $reportName.'_List.xls'; //save our workbook as this file name
        }

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache


        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

        //force user to download the Excel file without writing it to server's HD

        $objWriter->save('php://output');
              
	   


?>