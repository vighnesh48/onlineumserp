<?php
   
            $this->load->library("excel");
            $object = new PHPExcel();
            $object->setActiveSheetIndex(0);
           
            $object->getActiveSheet()->setTitle('Question Paper Remuneration');

            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Customer Signature');
            $objDrawing->setDescription('Customer Signature');
            //Path to signature .jpg file
            $signature = FCPATH.'/assets/images/logo-admin.png';    
            $objDrawing->setPath($signature);
            $objDrawing->setOffsetX(12);                     //setOffsetX works properly
            $objDrawing->setOffsetY(12);                     //setOffsetX works properly
            $objDrawing->setCoordinates('A1');             //set image to cell E38
            $objDrawing->setHeight(50);                     //signature height  
            $objDrawing->setWorksheet($object->getActiveSheet(0));


            //$object->getActiveSheet()->setCellValue('A1', 'Sandip University');
            $object->getActiveSheet()->mergeCells('A1:C4');
            $object->getActiveSheet()->setCellValue('D1', 'Sandip University');
            $object->getActiveSheet()->mergeCells('D1:L1');
            $object->getActiveSheet()->getStyle('D1')->getFont()->setBold(true)->setSize(18);
            
            $object->getActiveSheet()->setCellValue('D2', 'Mahiravani, Trimbak Road, Tal & Dist. Nashik 422213, Maharashtra');
            $object->getActiveSheet()->mergeCells('D2:L2');
            $object->getActiveSheet()->getStyle('D2:L2')->getFont()->setBold(true);

            $object->getActiveSheet()->setCellValue('D3', 'Question Paper Remuneration');
            $object->getActiveSheet()->mergeCells('D3:L3');
            $object->getActiveSheet()->getStyle('D3:L3')->getFont()->setBold(true)->setSize(18);

            $object->getActiveSheet()->setCellValue('D4', ' End Semester Exam. DEC. 2022 /JAN. 2023');
            $object->getActiveSheet()->mergeCells('D4:L4');
            $object->getActiveSheet()->getStyle('D4:L4')->getFont()->setBold(true)->setSize(18);
            
            //set aligment to center for that merged cell (A1 to D1)
            $object->getActiveSheet()->getStyle('A1:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $object->getActiveSheet()->setCellValue('A5', 'S.No');
            $object->getActiveSheet()->setCellValue('B5', 'Name of Paper Setter');
            $object->getActiveSheet()->setCellValue('C5', 'Staff ID');					
            $object->getActiveSheet()->setCellValue('D5', 'Bank Name');			
            $object->getActiveSheet()->setCellValue('E5', 'Bank A/C No');            
            $object->getActiveSheet()->setCellValue('F5', 'IFSC Code');
			$object->getActiveSheet()->setCellValue('G5', 'Branch');
            $object->getActiveSheet()->setCellValue('H5', 'UG/QP Rs.500');
            $object->getActiveSheet()->setCellValue('I5', 'UG. Total');
            $object->getActiveSheet()->setCellValue('J5', 'PG/QP Rs.700');
            $object->getActiveSheet()->setCellValue('K5', 'PG. Total');
            $object->getActiveSheet()->setCellValue('L5', 'Dip.+ UG+ PG =Total In Rs.');

            $row=6;
            $j=1; 
            $main_total = 0;
        foreach($claim_datas as $value){ 
            
            $datas = $this->Question_paper_model->get_qp_faculy_data($value['faculty_id']);
                              //echo '<pre>';print_r($datas);exit;
            $ug_count = 0;
            $ug_count_total = 0;
            $pg_count = 0;
            $pg_count_total = 0;
            $final_total = 0;
           

                              foreach($datas as $data){
                                 //echo '<pre>';print_r($data);exit;

                                 if($data['course_type'] == 'UG'){
                                    $ug_count = $data['count'];
                                    $ug_count_total = $data['total'];
                                    $final_total += $data['total'];
                                    $main_total += $final_total;


                                 }elseif($data['course_type'] == 'PG'){

                                    $pg_count =  $data['count'];
                                    $pg_count_total = $data['total'];
                                    $final_total += $data['total'];
                                    $main_total += $final_total;



                                 }else{
                                    $final_total +=$data['total'];
                                    $main_total += $final_total;


                                 }


                              }

            $object->getActiveSheet()->setCellValue('A'.$row, $j);
            $object->getActiveSheet()->setCellValue('B'.$row, $value['fname'].' '.$value['mname'].' '.$value['lname']);    
            $object->getActiveSheet()->setCellValue('C'.$row, $value['faculty_id']);         
            $object->getActiveSheet()->setCellValue('D'.$row, $value['bank_name']);              
            $object->getActiveSheet()->setCellValue('E'.$row, $value['bank_acc_no']);             
            $object->getActiveSheet()->setCellValue('F'.$row, $value['bank_ifsc']);             
            $object->getActiveSheet()->setCellValue('G'.$row, $value['branch_name']);
            $object->getActiveSheet()->setCellValue('H'.$row, $ug_count);
            $object->getActiveSheet()->setCellValue('I'.$row, $ug_count_total);
            $object->getActiveSheet()->setCellValue('J'.$row, $pg_count);
            $object->getActiveSheet()->setCellValue('K'.$row, $pg_count_total);
            $object->getActiveSheet()->setCellValue('L'.$row, $final_total);
            $row = $row+1;
            //$main_total += $final_total;
            $j=$j+1;

        }
    
         $object->getActiveSheet()->setCellValue('A'.$row, 'Total');
         $object->getActiveSheet()->mergeCells('A'.$row.':K'.$row);
         $object->getActiveSheet()->setCellValue('L'.$row, $main_total);

                
        $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );
        $object->getActiveSheet()->getStyle('A'.$row.':L'.$row)->getFont()->setBold(true)->setSize(15);
        $object->getActiveSheet()->getStyle('A1:L'.$row)->applyFromArray($styleArray);  

            
		        
          
        $filename= 'Question_Paper_Remuneration.xls'; //save our workbook as this file name
       

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache


        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)

        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 

        //force user to download the Excel file without writing it to server's HD

        $objWriter->save('php://output');
              
	   


?>