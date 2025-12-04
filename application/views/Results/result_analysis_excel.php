<?php
$this->load->library("excel");
$object = new PHPExcel();
$sheet = $object->setActiveSheetIndex(0);
$sheet->setTitle("Exam Summary Report");

$rowIndex = 1;

// Title
$sheet->setCellValue("A$rowIndex", "EXAM SUMMARY REPORT");
$sheet->mergeCells("A$rowIndex:I$rowIndex");
$sheet->getStyle("A$rowIndex")->getFont()->setBold(true)->setSize(14)->getColor()->setRGB('FFFFFF');
$sheet->getStyle("A$rowIndex")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('4F81BD');
$rowIndex++;

// Group data: SOET + SOCSE => Engineering
$schools = [];
foreach ($result as $row) {
    $original_school = $row['school_short_name'];
    $school = in_array($original_school, ['SOET', 'SOCSE']) ? 'Engineering' : $original_school;
    $semester = (int)$row['semester'];
    $stream = ($semester === 1 || $semester === 2) ? 'General First Year' : $row['stream_name'];
    $schools[$school][$stream][$semester][] = $row;
}

// Iterate schools
foreach ($schools as $school_name => $streams) {
    $sheet->setCellValue("A$rowIndex", "School Name :- $school_name");
    $sheet->mergeCells("A$rowIndex:I$rowIndex");
    $sheet->getStyle("A$rowIndex")->getFont()->setBold(true);
    $rowIndex++;

    $grand_total_applied = 0;
    $grand_total_pass = 0;
    $grand_total_fail = 0;
    $grand_th = ['appeared' => 0, 'pass' => 0, 'fail' => 0];
    $grand_pr = ['appeared' => 0, 'pass' => 0, 'fail' => 0];

    foreach ($streams as $stream_name => $semesters) {
        $sheet->setCellValue("A$rowIndex", "Stream Name:- $stream_name");
        $sheet->mergeCells("A$rowIndex:I$rowIndex");
        $sheet->getStyle("A$rowIndex")->getFont()->setBold(true);
        $rowIndex++;

        // Header
        $headers1 = ['Semester', 'Applied Students', '', 'Passed Students', '', 'Fail Students', '', 'Passing Percentage', ''];
        $headers2 = ['', 'TH', 'PR', 'TH', 'PR', 'TH', 'PR', 'TH', 'PR'];
        $sheet->fromArray($headers1, null, "A$rowIndex");
        $sheet->fromArray($headers2, null, "A" . ($rowIndex + 1));

        $sheet->getStyle("A$rowIndex:I" . ($rowIndex + 1))->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A$rowIndex:I" . ($rowIndex + 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('305496');
        $rowIndex += 2;

        $total_th = ['appeared' => 0, 'pass' => 0, 'fail' => 0];
        $total_pr = ['appeared' => 0, 'pass' => 0, 'fail' => 0];

        foreach ($semesters as $semester => $components) {
            $componentsData = [
                'TH' => ['appeared' => 0, 'pass' => 0, 'fail' => 0],
                'PR' => ['appeared' => 0, 'pass' => 0, 'fail' => 0],
            ];
            foreach ($components as $row) {
                $comp = ($row['subject_component'] === 'EM') ? 'TH' : $row['subject_component'];
                if (!isset($componentsData[$comp])) {
                    $componentsData[$comp] = ['appeared' => 0, 'pass' => 0, 'fail' => 0];
                }
                $componentsData[$comp]['appeared'] += $row['appeared'];
                $componentsData[$comp]['pass'] += $row['all_clear'];
                $componentsData[$comp]['fail'] += $row['fail'];
            }

            $percentTH = $componentsData['TH']['appeared'] > 0 ? round(($componentsData['TH']['pass'] / $componentsData['TH']['appeared']) * 100, 2) : 0;
            $percentPR = $componentsData['PR']['appeared'] > 0 ? round(($componentsData['PR']['pass'] / $componentsData['PR']['appeared']) * 100, 2) : 0;

            $rowData = [
                $semester,
                $componentsData['TH']['appeared'], $componentsData['PR']['appeared'],
                $componentsData['TH']['pass'], $componentsData['PR']['pass'],
                $componentsData['TH']['fail'], $componentsData['PR']['fail'],
                $percentTH . '%', $percentPR . '%'
            ];
            $sheet->fromArray($rowData, null, "A$rowIndex");

            // Stream totals
            $total_th['appeared'] += $componentsData['TH']['appeared'];
            $total_th['pass'] += $componentsData['TH']['pass'];
            $total_th['fail'] += $componentsData['TH']['fail'];

            $total_pr['appeared'] += $componentsData['PR']['appeared'];
            $total_pr['pass'] += $componentsData['PR']['pass'];
            $total_pr['fail'] += $componentsData['PR']['fail'];

            // Grand totals
            $grand_th['appeared'] += $componentsData['TH']['appeared'];
            $grand_th['pass'] += $componentsData['TH']['pass'];
            $grand_th['fail'] += $componentsData['TH']['fail'];

            $grand_pr['appeared'] += $componentsData['PR']['appeared'];
            $grand_pr['pass'] += $componentsData['PR']['pass'];
            $grand_pr['fail'] += $componentsData['PR']['fail'];

            $rowIndex++;
        }

        $percentTH_total = $total_th['appeared'] > 0 ? round(($total_th['pass'] / $total_th['appeared']) * 100, 2) : 0;
        $percentPR_total = $total_pr['appeared'] > 0 ? round(($total_pr['pass'] / $total_pr['appeared']) * 100, 2) : 0;
        $sheet->fromArray(['Total',
            $total_th['appeared'], $total_pr['appeared'],
            $total_th['pass'], $total_pr['pass'],
            $total_th['fail'], $total_pr['fail'],
            $percentTH_total . '%', $percentPR_total . '%'
        ], null, "A$rowIndex");
        $sheet->getStyle("A$rowIndex:I$rowIndex")->getFont()->setBold(true);
        $sheet->getStyle("A$rowIndex:I$rowIndex")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D9E1F2');
        $rowIndex += 2;
    }

    $grand_percentTH = $grand_th['appeared'] > 0 ? round(($grand_th['pass'] / $grand_th['appeared']) * 100, 2) : 0;
    $grand_percentPR = $grand_pr['appeared'] > 0 ? round(($grand_pr['pass'] / $grand_pr['appeared']) * 100, 2) : 0;
    $sheet->fromArray(['Grand Total',
        $grand_th['appeared'], $grand_pr['appeared'],
        $grand_th['pass'], $grand_pr['pass'],
        $grand_th['fail'], $grand_pr['fail'],
        $grand_percentTH . '%', $grand_percentPR . '%'
    ], null, "A$rowIndex");
    $sheet->getStyle("A$rowIndex:I$rowIndex")->getFont()->setBold(true);
    $sheet->getStyle("A$rowIndex:I$rowIndex")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BDD7EE');
    $rowIndex += 2;
}

// Auto column width
foreach (range('A', 'I') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Output file
while (ob_get_level()) ob_end_clean();
$filename = 'exam_summary_report.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
$objWriter->save('php://output');
exit;
?>
