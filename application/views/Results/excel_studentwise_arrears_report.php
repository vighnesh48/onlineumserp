<?php
	$this->load->library("excel");
	$object = new PHPExcel();
	$object->setActiveSheetIndex(0);

	$object->getActiveSheet()->setTitle('Arrears List');
	 $object->getActiveSheet()->setCellValue('A1', 'Student-wise Arrears List');
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
	$object->getActiveSheet()->setCellValue('B'.$row, 'PRN');
	$object->getActiveSheet()->setCellValue('C'.$row, 'Name');
	$object->getActiveSheet()->setCellValue('D'.$row, 'No. of arrear(s)'); 	
	$object->getActiveSheet()->setCellValue('E'.$row, 'Semester');			
	$object->getActiveSheet()->setCellValue('F'.$row, 'Course Code');
	$object->getActiveSheet()->setCellValue('G'.$row, 'Course Name');	
	           

	$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFont()->setBold(true);
	$object->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFont()->setSize(10)->setBold(true);
						//retrive contries table data
	

	$j=1; 
	$row=$row+1;
	$CI =& get_instance();
	$CI->load->model('Results_model');

	if(!empty($val['student_list'])){                          
		foreach ($val['student_list'] as $value) {
			$stud_sub_applied= $this->Results_model->stud_arrear_subject_list($val['stream_id'], $value['student_id'],$batch,$exam_id='');
			//foreach ($stud_sub_applied as $stud) {				
				$prns = implode(', ', $enrollment_no);
				$prev_name = $value['enrollment_no'];		
				$object->getActiveSheet()->setCellValue('A'.$row, $j);
				$object->getActiveSheet()->setCellValue('B'.$row, ' '.$value['enrollment_no']);			 
				$object->getActiveSheet()->setCellValue('C'.$row, $value['stud_name']);
				$object->getActiveSheet()->setCellValue('D'.$row, count($stud_sub_applied));
foreach ($stud_sub_applied as $stud) {					
				$object->getActiveSheet()->setCellValue('E'.$row, $stud['semester']);			  
				$object->getActiveSheet()->setCellValue('F'.$row, $stud['subject_code']);			  
				$object->getActiveSheet()->setCellValue('G'.$row, $stud['subject_name']);
$row = $row+1;				
}			
	
				
				$j=$j+1;
				unset($enrollment_no);
			//}	
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

	$filename='Student-wise_arrear_report.xls'; //save our workbook as this file name

	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache


	//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

	//if you want to save it as .XLSX Excel 2007 format

	$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

	//force user to download the Excel file without writing it to server's HD

	$objWriter->save('php://output');
		  
   


?>