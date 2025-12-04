<?php
	if($reval_type==0){
		$fname = "Photocopy";
	}else{
		$fname = "Revaluation";
	}
	$this->load->library("excel");
	$object = new PHPExcel();
	$object->setActiveSheetIndex(0);

	$object->getActiveSheet()->setTitle('Revaluation List');
	 $object->getActiveSheet()->setCellValue('A1', $fname.' Course wise List-'.$exam_month.' '.$exam_year);
	$object->getActiveSheet()->mergeCells('A1:G1');
	$object->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(18);
	
	
	
	//set aligment to center for that merged cell (A1 to D1)
	$object->getActiveSheet()->getStyle('A1:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//echo "<pre>";
//print_r($stream_list);	exit;
	
   // $object->getActiveSheet()->getStyle('A3:Q3')->getFont()->setBold(true);
	$row=2;   
foreach ($stream_list as $val) {
	
	$object->getActiveSheet()->setCellValue('A'.$row, $val['stream_name']);
	$object->getActiveSheet()->mergeCells('A'.$row.':G'.$row);
	$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFont()->setBold(true);
	$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '#F8F8FF')
        )
    )
);
	
	$row=$row+1;
	$object->getActiveSheet()->setCellValue('A'.$row, 'S.No');
	$object->getActiveSheet()->setCellValue('B'.$row, 'Course Code');
	$object->getActiveSheet()->setCellValue('C'.$row, 'Semester');			
	$object->getActiveSheet()->setCellValue('D'.$row, 'Course Name');			
	$object->getActiveSheet()->setCellValue('E'.$row, 'No.of Applied');			
	$object->getActiveSheet()->setCellValue('F'.$row, 'PRN');            
	$object->getActiveSheet()->setCellValue('G'.$row, 'ABN');            

	$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFont()->setBold(true);
	$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFont()->setSize(10)->setBold(true);
						//retrive contries table data
	

	$j=1; 
	$row=$row+1;
	$CI =& get_instance();
	$CI->load->model('Reval_model');

	if(!empty($val['subject_list'])){                          
		foreach ($val['subject_list'] as $value) {
			$sub_stud =$this->Reval_model->fetch_revalsub_students($val['stream_id'], $value['subject_id'],$exam_id,$reval_type);
			foreach ($sub_stud as $stud) {
				$enrollment_no[] = $stud['enrollment_no'];
				//$ans_bklet_no[] = $stud['ans_bklet_no'];
				$ans_bklet_no[] = $stud['barcode'];
			}	
			$prns = implode(', ', $enrollment_no);			
			$abn = implode(', ', $ans_bklet_no);			
			$object->getActiveSheet()->setCellValue('A'.$row, $j);
			$object->getActiveSheet()->setCellValue('B'.$row, $value['subject_code']);			 
			$object->getActiveSheet()->setCellValue('C'.$row, $value['semester']);		  
			$object->getActiveSheet()->setCellValue('D'.$row, $value['subject_name']);			  
			$object->getActiveSheet()->setCellValue('E'.$row, count($sub_stud));			  
			$object->getActiveSheet()->setCellValue('F'.$row, ' '.$prns);			  
			$object->getActiveSheet()->setCellValue('G'.$row, ' '.$abn);			  

			$row = $row+1;
			$j=$j+1;
			unset($enrollment_no);
			unset($ans_bklet_no);
		}
		
	}	

}	
	$styleArray = array(
	  'borders' => array(
		'allborders' => array(
		  'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	  )
	);
	$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFont()->setBold(true)->setSize(15);
	$object->getActiveSheet()->getStyle('A1:G'.$row)->applyFromArray($styleArray);   

	$filename=$fname.'_summary_report.xls'; //save our workbook as this file name

	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache


	//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	//if you want to save it as .XLSX Excel 2007 format

	$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	//force user to download the Excel file without writing it to server's HD

	$objWriter->save('php://output');
		  
   


?>