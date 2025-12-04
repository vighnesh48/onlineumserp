<?php

if($admission_type=="N") {
    $adm = "ONLY New Admission";
} else if($admission_type=="R") {
    $adm = "ONLY Re-Registration";
} else {
    $adm = "BOTH-All-Registration";
}

$filename = ''; 
$tit = "";
$dt = date('Y-m-d h:i:s');

if($report_type=="4") {
    $tit = "Outstanding Fees Student Wise- ";
    $filename = $dt . '-Student Wise Outstanding Fees-' . $academic_year . '.xls'; 
} else if($report_type=="2") {
    $tit = "Admission Fees Student Wise -";
    $filename = $dt . '-Student Wise Admission Fees-' . $academic_year . '.xls';
} else if($report_type=="6") {
    $tit = "Sem Wise Admission Fees Student Wise -";
    $filename = $dt . '-Sem Wise Student Wise Admission Fees-' . $academic_year . '.xls';
} else if($report_type=="8") {
    $tit = "Sem Wise Outstanding Fees Student Wise- ";
    $filename = $dt . '-Sem Wise Student Wise Outstanding Fees-' . $academic_year . '.xls'; 
}

$this->load->library("excel");
$object = new PHPExcel();
$object->setActiveSheetIndex(0);

// Titles
$object->getActiveSheet()->setCellValue('A1', 'Sandip University-Nashik');
$object->getActiveSheet()->setCellValue('A2', $tit . $adm);
$object->getActiveSheet()->setCellValue('A3', 'Academic Year: ' . $academic_year);

// Headers
$headers = [
    'S.No.', 'PRN No', 'Student Name', 'Mobile', 'Gender', 'School', 'Course', 'Stream', 'Provisional PRN',
    'Partnership Code', 'Year', 'Actual Fees', 'Scholarship', 'Applicable', 'Opening Balance', 'Charges',
    'Other Fees', 'Refund', 'Fees Paid', 'Opening Paid', 'Current Paid', 'Pending', 'Excess Paid',
    'Admission Confirm', 'Category', 'Sub-Cast', 'Nationality', 'State', 'Admission Year', 'Current Sem/Year',
    'Final Sem/Year', 'Remark', 'Academic fees', 'Tution fees', 'Development fees', 'Cautionmoney fees',
    'Admission_form fees', 'Exam fees', 'Other fees', 'FinalTotal fees', 'City', 'Package', 'Package Name', 'Reported Status','Hostel Status', 'Hostel Paid', 'Admission Source','Uniform Status'
];

$col = 'A';
foreach ($headers as $header) {
    $object->getActiveSheet()->setCellValue($col . '4', $header);
    $col++;
}

// Merge and Style Title Rows
$object->getActiveSheet()->mergeCells('A1:AV1');
$object->getActiveSheet()->mergeCells('A2:AV2');
$object->getActiveSheet()->mergeCells('A3:AV3');

$object->getActiveSheet()->getStyle('A1:AV3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$object->getActiveSheet()->getStyle('A1')->getFont()->setSize(16)->setBold(true);
$object->getActiveSheet()->getStyle('A1:A3')->getFont()->setName('Calibri');
$object->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
$object->getActiveSheet()->getStyle('A1:A3')->getFill()->applyFromArray([
    'type' => PHPExcel_Style_Fill::FILL_SOLID,
    'startcolor' => ['rgb' => 'E0E0E0']
]);

// Style Header Row
$headerStyle = [
    'font' => [
        'bold' => true,
        'size' => 11,
        'color' => ['rgb' => 'FFFFFF'],
    ],
    'alignment' => [
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap' => true
    ],
    'fill' => [
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => ['rgb' => '4F81BD'],
    ]
];
$object->getActiveSheet()->getStyle('A4:AV4')->applyFromArray($headerStyle);
$object->getActiveSheet()->getRowDimension('4')->setRowHeight(25);

// Set Auto Column Width
foreach (range('A', 'AV') as $col) {
    $object->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}

// Set Default Font
$object->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);

// Fill Data Rows
$rowno = 1;
$x = 5;
$total = 0;
$other = 0;
$pending = 0;

foreach($fees as $row) {
    $other = $row['opening_balance'] + $row['cancel_charges'];
    $pending = ($report_type == 2 || $report_type == 4)
        ? ($row['applicable_total'] + $other + $row['refund']) - $row['fees_total']
        : (($row['applicable_total'] / 2) + $other + $row['refund']) - $row['fees_total'];

    $object->getActiveSheet()->setCellValue('A'.$x, ($x - 4));
    $object->getActiveSheet()->setCellValue('B'.$x, $row['enrollment_no']);
    $object->getActiveSheet()->setCellValue('C'.$x, $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
    $object->getActiveSheet()->setCellValue('D'.$x, $row['mobile']);
    $object->getActiveSheet()->setCellValue('E'.$x, $row['gender']);
    $object->getActiveSheet()->setCellValue('F'.$x, $row['school_short_name']);
    $object->getActiveSheet()->setCellValue('G'.$x, $row['course_short_name']);
    $object->getActiveSheet()->setCellValue('H'.$x, $row['stream_name']);
    $object->getActiveSheet()->setCellValue('I'.$x, $row['enrollment_no_new']);
    $object->getActiveSheet()->setCellValue('J'.$x, $row['partnership_code']);
    $object->getActiveSheet()->setCellValue('K'.$x, $row['admission_year']);

    if($report_type == 2 || $report_type == 4) {
        $object->getActiveSheet()->setCellValue('L'.$x, $row['actual_fees']);
        $object->getActiveSheet()->setCellValue('M'.$x, ($row['actual_fees'] - $row['applicable_total']));
        $object->getActiveSheet()->setCellValue('N'.$x, $row['applicable_total']);
    } else {
        $object->getActiveSheet()->setCellValue('L'.$x, $row['actual_fees'] / 2);
        $object->getActiveSheet()->setCellValue('M'.$x, ($row['actual_fees'] - $row['applicable_total']) / 2);
        $object->getActiveSheet()->setCellValue('N'.$x, $row['applicable_total'] / 2);
    }

    $object->getActiveSheet()->setCellValue('O'.$x, $row['opening_balance']);
    $object->getActiveSheet()->setCellValue('P'.$x, $row['cancel_charges']);
    $object->getActiveSheet()->setCellValue('Q'.$x, $other);
    $object->getActiveSheet()->setCellValue('R'.$x, $row['refund']);
    $object->getActiveSheet()->setCellValue('S'.$x, $row['fees_total']);

    // Paid Calculations
    $curent_paid = 0;
    $preview = 0;
    if (!empty($row['fees_total'])) {
        if ($row['opening_balance'] < 0) {
            $curent_paid = $row['fees_total'];
        } else if ($row['fees_total'] < $row['opening_balance']) {
            $preview = $row['fees_total'];
        } else {
            $curent_paid = $row['fees_total'] - $row['opening_balance'];
            $preview = $row['opening_balance'];
        }
    }

    $object->getActiveSheet()->setCellValue('T'.$x, $preview);
    $object->getActiveSheet()->setCellValue('U'.$x, $curent_paid);

    if($pending > 0) {
        $object->getActiveSheet()->setCellValue('V'.$x, $pending);
        $object->getActiveSheet()->setCellValue('W'.$x, 0);
    } else {
        $object->getActiveSheet()->setCellValue('V'.$x, 0);
        $object->getActiveSheet()->setCellValue('W'.$x, abs($pending));
    }

    $object->getActiveSheet()->setCellValue('X'.$x, $row['admission_confirm']);
    $object->getActiveSheet()->setCellValue('Y'.$x, $row['category']);
    $object->getActiveSheet()->setCellValue('Z'.$x, $row['sub_caste']);
    $object->getActiveSheet()->setCellValue('AA'.$x, $row['nationality']);
    $object->getActiveSheet()->setCellValue('AB'.$x, $row['state_name']);
    $object->getActiveSheet()->setCellValue('AC'.$x, $row['admission_session']);
    $object->getActiveSheet()->setCellValue('AD'.$x, $row['current_semester']);
    $object->getActiveSheet()->setCellValue('AE'.$x, $row['final_semester']);
    $object->getActiveSheet()->setCellValue('AF'.$x, $row['concession_remark']);
    $object->getActiveSheet()->setCellValue('AG'.$x, $row['academic_fees']);
    $object->getActiveSheet()->setCellValue('AH'.$x, $row['atution_fees']);
    $object->getActiveSheet()->setCellValue('AI'.$x, $row['development']);
    $object->getActiveSheet()->setCellValue('AJ'.$x, $row['caution_money']);
    $object->getActiveSheet()->setCellValue('AK'.$x, $row['admission_session']);
    $object->getActiveSheet()->setCellValue('AL'.$x, $row['exam_fees']);
    $object->getActiveSheet()->setCellValue('AM'.$x, $row['Other_fees']);
    $object->getActiveSheet()->setCellValue('AN'.$x, $row['Final_Total']);
    $object->getActiveSheet()->setCellValue('AO'.$x, $row['taluka_name']);
    $object->getActiveSheet()->setCellValue('AP'.$x, $row['belongs_to']);
    $object->getActiveSheet()->setCellValue('AQ'.$x, $row['package_name']);
    $object->getActiveSheet()->setCellValue('AR'.$x, $row['reported_status']);
    $object->getActiveSheet()->setCellValue('AS'.$x, $row['hostel_required']);
    $object->getActiveSheet()->setCellValue('AT'.$x, $row['hostel_paid']);
    $object->getActiveSheet()->setCellValue('AU'.$x, $row['benefit_name']);
    $object->getActiveSheet()->setCellValue('AV'.$x, $row['uniform_status']);

    $x++;
}

// Border for all cells
$object->getActiveSheet()->getStyle('A4:AV'.($x-1))->applyFromArray([
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '999999']
        ]
    ]
]);

// Output headers
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
$objWriter->save('php://output');
exit();
?>
