<?php


    // echo "<pre>";
    // print_r($canteen_data);
    // echo "</pre>";
    // exit; // Temporarily stop script execution to inspect the data.
    // $breakfast_price = $canteen_slot_price_breakfast['price'];
    // $lunch_price = $canteen_slot_price_lunch['price'];
    // $dinner_price = $canteen_slot_price_dinner['price'];
    // $student_count = $this->data['student_count'];
    
    // Load PHPExcel library
    $this->load->library('excel'); // Ensure PHPExcel is correctly set up

    // Create new Excel file
    $objPHPExcel = new PHPExcel();
    $sheetIndex = 0;
    $objPHPExcel->getProperties()->setCreator("Sandip Foundation")
                                 ->setTitle("Canteen Report")
                                 ->setDescription("Canteen Details Report for " . $month . " " . $year);

    foreach ($canteen_data as $canteen) {
       // Create a new sheet for each canteen
       if ($sheetIndex > 0) {
           $objPHPExcel->createSheet($sheetIndex);
       }

       $breakfast_price = $canteen['breakfast_price'];
       $lunch_price = $canteen['lunch_price'];
       $dinner_price = $canteen['dinner_price'];

        // Set active sheet for this canteen
        $objPHPExcel->setActiveSheetIndex($sheetIndex);
        $sheet = $objPHPExcel->getActiveSheet();

        // Set sheet title to canteen name
        $sheet->setTitle(substr($canteen['canteen_name'], 0, 30));

            // Set organization name and other details
            $sheet->setCellValue('A1', 'SANDIP FOUNDATION');
            $sheet->setCellValue('A2', $canteen['canteen_name']);
            $sheet->setCellValue('A3', "$month - $year");

            // Set table headers
            $headers = [
                'Sr.No',
                'Date',
                'Total (BreakFast)',
                'Present (BreakFast)',
                'AB (BreakFast)',
                'Total (Lunch)',
                'Present (Lunch)',
                'AB (Lunch)',
                'Total (Dinner)',
                'Present (Dinner)',
                'AB (Dinner)',
            ];
        
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '5', $header);

                $col++;
            }
            $sheet->getStyle('A5:K5')->getFont()->setBold(true);

        
            // Merge header cells and set styles
            $sheet->mergeCells('A1:K1');
            $sheet->mergeCells('A2:K2');
            $sheet->mergeCells('A3:K3');
        
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
            $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(12);

            $sheet->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        
            // Fill data into the Excel file
            $row = 6; // Start filling data from row 6
            foreach ($canteen['punching_details'] as $i => $data) {
                $sheet->setCellValue('A' . $row, $i + 1)
                      ->setCellValue('B' . $row, $data['punch_date'])
                      ->setCellValue('C' . $row, $canteen['student_count']['breakfast_count'])
                      ->setCellValue('D' . $row, $data['breakfast_present'])
                      ->setCellValue('E' . $row, $canteen['student_count']['breakfast_count'] - $data['breakfast_present'])
                      ->setCellValue('F' . $row, $canteen['student_count']['lunch_count'])
                      ->setCellValue('G' . $row, $data['lunch_present'])
                      ->setCellValue('H' . $row, $canteen['student_count']['lunch_count'] - $data['lunch_present'])
                      ->setCellValue('I' . $row, $canteen['student_count']['dinner_count'])
                      ->setCellValue('J' . $row, $data['dinner_present'])
                      ->setCellValue('K' . $row, $canteen['student_count']['dinner_count'] - $data['dinner_present']);
                $row++;
                $total_student_breakfast += $canteen['student_count']['breakfast_count'];
                $total_student_lunch += $canteen['student_count']['lunch_count'];
                $total_student_dinner += $canteen['student_count']['dinner_count'];

                $total_present_breakfast += $data['breakfast_present'];
                $total_present_lunch += $data['lunch_present'];
                $total_present_dinner += $data['dinner_present'];

                $total_absent_breakfast += $canteen['student_count']['breakfast_count'] - $data['breakfast_present'];
                $total_absent_lunch += $canteen['student_count']['lunch_count'] - $data['lunch_present'];
                $total_absent_dinner += $canteen['student_count']['dinner_count'] - $data['dinner_present'];
            }
            $row++; // Skip one row

            // Total row
                $sheet->setCellValue('B' . $row, 'Total')
                      ->setCellValue('C' . $row, $total_student_breakfast)
                      ->setCellValue('D' . $row, $total_present_breakfast)
                      ->setCellValue('E' . $row, $total_absent_breakfast)

                      ->setCellValue('F' . $row, $total_student_lunch)
                      ->setCellValue('G' . $row, $total_present_lunch)
                      ->setCellValue('H' . $row, $total_absent_lunch)

                      ->setCellValue('I' . $row, $total_student_dinner)
                      ->setCellValue('J' . $row, $total_present_dinner)
                      ->setCellValue('K' . $row, $total_absent_dinner);
        
            $sheet->getStyle('B' . $row . ':K' . $row)->getFont()->setBold(true);
        
            // Define border style array
            $borderStyleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '00000000'), // Black color
                    ),
                ),
            );
        
            // Apply borders to data section
            $sheet->getStyle('A5:K' . $row)->applyFromArray($borderStyleArray);
        
            // Adding amount calculation section
            $row += 2; // Skip one row
            $sheet->setCellValue('B'. $row, 'Breakfast');
            $sheet->setCellValue('E'. $row, 'Lunch');
            $sheet->setCellValue('H'. $row, 'Dinner');
        
            $sheet->mergeCells('B'.$row.':D'.$row);
            $sheet->mergeCells('E'.$row.':G'.$row);
            $sheet->mergeCells('H'.$row.':J'.$row);
        
            $sheet->getStyle('B'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $sheet->getStyle('B' . $row . ':J' . $row)->getFont()->setBold(true);

            $row++;
            $sheet->setCellValue('B' . $row, 'Rate');
            $sheet->setCellValue('C' . $row, 'Present');
            $sheet->setCellValue('D' . $row, 'Total');
            $sheet->setCellValue('E' . $row, 'Rate');
            $sheet->setCellValue('F' . $row, 'Present');
            $sheet->setCellValue('G' . $row, 'Total');
            $sheet->setCellValue('H' . $row, 'Rate');
            $sheet->setCellValue('I' . $row, 'Present');
            $sheet->setCellValue('J' . $row, 'Total');

            $sheet->getStyle('B'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('I'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('J'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
            // Apply borders to the amount section
            $sheet->getStyle('B' . $row . ':J' . $row)->applyFromArray($borderStyleArray);
            $sheet->getStyle('B' . $row . ':J' . $row)->getFont()->setBold(true);
        
            $row++;
            $sheet->setCellValue('B' . $row, $breakfast_price)
                  ->setCellValue('C' . $row, $total_present_breakfast)
                  ->setCellValue('D' . $row, $total_present_breakfast * $breakfast_price)
                  ->setCellValue('E' . $row, $lunch_price)
                  ->setCellValue('F' . $row, $total_present_lunch)
                  ->setCellValue('G' . $row, $total_present_lunch * $lunch_price)
                  ->setCellValue('H' . $row, $dinner_price)
                  ->setCellValue('I' . $row, $total_present_dinner)
                  ->setCellValue('J' . $row, $total_present_dinner * $dinner_price);

             $sheet->getStyle('B'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $sheet->getStyle('C'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $sheet->getStyle('D'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $sheet->getStyle('E'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $sheet->getStyle('F'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $sheet->getStyle('G'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $sheet->getStyle('H'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $sheet->getStyle('I'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $sheet->getStyle('J'. $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
            // Apply borders to the last section
            $sheet->getStyle('B' . ($row-2) . ':J' . $row)->applyFromArray($borderStyleArray);
        
            $row += 2;
            $total_amount = ($total_present_breakfast * $breakfast_price) + 
                            ($total_present_lunch * $lunch_price) + 
                            ($total_present_dinner * $dinner_price);
            $sheet->setCellValue('B' . $row, 'Total Amount')
                                          ->setCellValue('C' . $row, $total_amount);

             
            
        
            // Apply borders to total amount
            $sheet->getStyle('B' . $row . ':C' . $row)->applyFromArray($borderStyleArray);
            $sheet->getStyle('B' . $row . ':C' . $row)->getFont()->setBold(true);
        
            // Apply formatting and set auto column width
            foreach (range('A', 'K') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            $total_student_breakfast = 0;
            $total_student_lunch = 0;
            $total_student_dinner = 0;
            $total_present_breakfast = 0;
            $total_present_lunch = 0;
            $total_present_dinner = 0;
            $total_absent_breakfast = 0;
            $total_absent_lunch = 0;
            $total_absent_dinner = 0;

            $sheetIndex++;
    }
            // Save the Excel file and output it
    $filename = 'Canteen_Report_' . $month . '_' . $year . '.xls';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit();

?>
