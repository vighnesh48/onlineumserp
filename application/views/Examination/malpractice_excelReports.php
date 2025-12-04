<?php
$CI =& get_instance();
$CI->load->model('Examination_model');
$this->load->library("excel");

$object = new PHPExcel();
$sheet = $object->setActiveSheetIndex(0);

// Header Titles
$sheet->setCellValue('A1', 'Sandip University - Nashik');
$sheet->setCellValue('A2', 'MALPRACTICE LIST - '.$exam_session);	
$sheet->setCellValue('A3', 'Sr.No');
$sheet->setCellValue('B3', 'PRN');
$sheet->setCellValue('C3', 'Name');
$sheet->setCellValue('D3', 'Malpractice count');
$sheet->setCellValue('E3', 'Repetition Count');
$sheet->setCellValue('F3', 'Subject');
$sheet->setCellValue('G3', 'Stream');
$sheet->setCellValue('H3', 'Semester');
$sheet->setCellValue('I3', 'Date');
$sheet->setCellValue('J3', 'Session');
$sheet->setCellValue('K3', 'Remark');

// Merge Header Cells
$sheet->mergeCells('A1:K1');
$sheet->mergeCells('A2:K2');

// Style Header Titles
$headerStyle = [
    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
    'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER],
    'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => ['rgb' => '4F81BD']]
];

$sheet->getStyle('A1')->applyFromArray($headerStyle);
$sheet->getStyle('A2')->applyFromArray($headerStyle);

// Column Titles Style
$columnHeaderStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
    'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => ['rgb' => 'D9E1F2']],
    'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]],
    'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER]
];

$sheet->getStyle('A3:K3')->applyFromArray($columnHeaderStyle);

// Loop Data
$x = 4;
foreach ($malpractice_list as $i => $row) {
    $mcount = $this->Examination_model->malpractice_count($row['enrollment_no']);
    $sname = $row['first_name']." ".$row['middle_name']." ".$row['last_name'];
    $mpractice_date = date('d-m-Y', strtotime($row['date']));
    $frmtime = explode(':' ,$row['from_time']); 
    $to_time = explode(':', $row['to_time']);
    $ex_ses = $frmtime[0].':'.$frmtime[1].'-'.$to_time[0].':'.$to_time[1];

    $sheet->setCellValue('A'.$x, $x - 3);
    $sheet->setCellValue('B'.$x, ' '.$row['enrollment_no']);
    $sheet->setCellValue('C'.$x, $sname);
    $sheet->setCellValue('D'.$x, $row['malcount']);
    $sheet->setCellValue('E'.$x, $mcount[0]['malcount']);
    $sheet->setCellValue('F'.$x, $row['subject_code'].'-'.$row['subject_name']);
    $sheet->setCellValue('G'.$x, $row['stream_short_name']);
    $sheet->setCellValue('H'.$x, $row['semester']);
    $sheet->setCellValue('I'.$x, $mpractice_date);
    $sheet->setCellValue('J'.$x, $ex_ses);
    $sheet->setCellValue('K'.$x, $row['remark']);

    // Zebra stripe rows
    $fillColor = ($x % 2 == 0) ? 'FFFFFF' : 'F2F2F2';
    $sheet->getStyle("A$x:K$x")->applyFromArray([
        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => ['rgb' => $fillColor]],
        'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]],
        'alignment' => ['vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER],
    ]);

    // Highlight high malpractice count
    if ((int)$row['malcount'] > 1) {
        $sheet->getStyle("D$x")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FF0000']]
        ]);
    }

    $x++;
}

// Auto-size columns
foreach (range('A', 'K') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Export
$filename = 'MalPractice_list.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
$writer->save('php://output');
exit;
?>
