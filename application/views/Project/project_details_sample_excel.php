<?php

$this->load->library("excel");

$object = new PHPExcel();
$object->setActiveSheetIndex(0);

// Merge and center title
$object->getActiveSheet()->mergeCells('A1:E1');
$object->getActiveSheet()->mergeCells('A2:E2');

$object->getActiveSheet()->setCellValue('A1', 'Sandip University - Nashik');
$object->getActiveSheet()->setCellValue('A2', 'Please fill the project details');

// Center align and style the title
$titleStyle = [
    'font' => [
        'bold' => true,
        'size' => 14
    ],
    'alignment' => [
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    ]
];

$object->getActiveSheet()->getStyle('A1:A2')->applyFromArray($titleStyle);

// Column Headers
$headers = ['S.No.', 'Project Title', 'Enrollment No.', 'Faculty Code', 'Day'];
$columns = ['A', 'B', 'C', 'D', 'E'];

foreach ($columns as $index => $column) {
    $object->getActiveSheet()->setCellValue($column . '4', $headers[$index]);
}

// Style for headers
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF']
    ],
    'fill' => [
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => ['rgb' => '4F81BD']
    ],
    'alignment' => [
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    ],
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN
        ]
    ]
];

$object->getActiveSheet()->getStyle('A4:E4')->applyFromArray($headerStyle);

// Set column widths
$columnWidths = [10, 40, 40, 20];

foreach ($columns as $index => $column) {
    $object->getActiveSheet()->getColumnDimension($column)->setWidth($columnWidths[$index]);
}

// File download settings
$filename = "Project_Details.xls";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

// Save and output
$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
$objWriter->save('php://output');
exit();

?>
