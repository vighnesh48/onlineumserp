<?php

	$mpdf=new mPDF();
	$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');

ob_start();
?>

<style>
    .report-title {
        text-align: center;
        font-size: 24px;
        font-weight: 700;
        color: #2e86c1;
        margin-bottom: 20px;
    }

    .school-name {
        font-size: 16px;
        font-weight: bold;
        margin: 10px 0 25px;
        color: #1f618d;
        background-color: #b6babb;
        padding: 10px 15px;
        border-left: 4px solid #2980b9;
        border-radius: 4px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 35px;
        box-shadow: 0 2px 4px rgba(46, 134, 193, 0.15);
    }

    th, td {
        border: 1px solid #ccd1d1;
        padding: 8px;
        font-size: 12px;
        text-align: center;
    }

    th {
        background-color: #d6eaf8;
        color: #1b4f72;
        font-weight: 600;
    }

    .stream-header {
        background-color: #ebf5fb;
        font-weight: 700;
        color: #21618c;
        text-align: left;
        padding-left: 10px;
    }

    .total-row td {
        background-color: #aed6f1;
        font-weight: bold;
        color: #154360;
    }

    tr:nth-child(even) td {
        background-color: #f9f9f9;
    }

  @media print {
    .page-break { page-break-before: always; }
  }

</style>
<?php if($rpt['report_type'] == '5'){?>

<div class="report-title">RESULT ANALYSIS REPORT <?=$result[0]['exam_name']?></div>

<?php

// group data

$schools = [];
foreach ($result as $row) {
    $original_school = $row['school_short_name'];
    $semester = (int)$row['semester'];
    $stream   = $row['stream_name'];
    $schools[$original_school][$stream][$semester][] = $row;
}

// overall accumulator across ALL schools
$overallTotals = ['appeared' => 0, 'pass' => 0, 'fail' => 0];

$schoolCount = count($schools);
$schoolIdx   = 0;

foreach ($schools as $school_name => $streams): ?>
    <div class="school-section">
        <div class="school-name">School Name :- <?= htmlspecialchars($school_name) ?></div>

        <?php
        // per-school accumulator
        $schoolTotals = ['appeared' => 0, 'pass' => 0, 'fail' => 0];
        ?>

        <?php foreach ($streams as $stream_name => $semesters): ?>
            <table border="1" cellspacing="0" cellpadding="4" width="100%">
                <tr>
                    <td class="stream-header" colspan="5">Stream Name:- <?= htmlspecialchars($stream_name) ?></td>
                </tr>
                <tr>
                    <th>Semester</th>
                    <th>Applied Students</th>
                    <th>Passed Students</th>
                    <th>Fail Students</th>
                    <th>Passing Percentage</th>
                </tr>

                <?php
                // per-stream accumulator
                $streamTotals = ['appeared' => 0, 'pass' => 0, 'fail' => 0];

                foreach ($semesters as $semester => $components):
                    $appeared = 0; $pass = 0; $fail = 0;

                    foreach ($components as $row) {
                        $appeared += (int)$row['appeared'];
                        $pass     += (int)$row['all_clear'];
                        $fail     += (int)$row['fail'];
                    }

                    // add to stream + school
                    $streamTotals['appeared'] += $appeared;
                    $streamTotals['pass']     += $pass;
                    $streamTotals['fail']     += $fail;

                    $schoolTotals['appeared'] += $appeared;
                    $schoolTotals['pass']     += $pass;
                    $schoolTotals['fail']     += $fail;

                    $percent = ($appeared > 0) ? round(($pass / $appeared) * 100, 2) : 0;
                ?>
                    <tr>
                        <td><?= (int)$semester ?></td>
                        <td><?= $appeared ?></td>
                        <td><?= $pass ?></td>
                        <td><?= $fail ?></td>
                        <td><?= $percent ?>%</td>
                    </tr>
                <?php endforeach; ?>

                <?php
                $percent_total = ($streamTotals['appeared'] > 0)
                    ? round(($streamTotals['pass'] / $streamTotals['appeared']) * 100, 2) : 0;
                ?>
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td><?= $streamTotals['appeared'] ?></td>
                    <td><?= $streamTotals['pass'] ?></td>
                    <td><?= $streamTotals['fail'] ?></td>
                    <td><?= $percent_total ?>%</td>
                </tr>
            </table>
            <br>
        <?php endforeach; ?>

        <?php
        // per-school grand total
        $school_percent = ($schoolTotals['appeared'] > 0)
            ? round(($schoolTotals['pass'] / $schoolTotals['appeared']) * 100, 2) : 0;

        // add to overall
        $overallTotals['appeared'] += $schoolTotals['appeared'];
        $overallTotals['pass']     += $schoolTotals['pass'];
        $overallTotals['fail']     += $schoolTotals['fail'];
        ?>
        <table border="1" cellspacing="0" cellpadding="4" width="100%">
            <tr class="total-row">
                <td colspan="1"><strong>Grand Total (<?= htmlspecialchars($school_name) ?>)</strong></td>
                <td>Appeared : <?= $schoolTotals['appeared'] ?></td>
                <td>Pass : <?= $schoolTotals['pass'] ?></td>
                <td>Fail : <?= $schoolTotals['fail'] ?></td>
                <td>Percentage : <?= $school_percent ?>%</td>
            </tr>
        </table>
    </div>

    <?php
    // page break between schools (not after the last one)
    $schoolIdx++;
    if ($schoolIdx < $schoolCount): ?>
        <div class="page-break"></div>
    <?php endif; ?>

<?php endforeach; ?>

<?php
// OVERALL total across all schools
$overall_percent = ($overallTotals['appeared'] > 0)
    ? round(($overallTotals['pass'] / $overallTotals['appeared']) * 100, 2) : 0;
?>
<br>
<table border="1" cellspacing="0" cellpadding="4" width="100%">
    <tr class="total-row">
        <td colspan="1"><strong>Overall Grand Total</strong></td>
        <td>Appeared : <?= $overallTotals['appeared'] ?></td>
        <td>Pass : <?= $overallTotals['pass'] ?></td>
        <td>Fail : <?= $overallTotals['fail'] ?></td>
        <td>Percentage : <?= $overall_percent ?>%</td>
    </tr>
</table>



<?php } else { ?>
<div class="report-title">EXAM SUMMARY REPORT</div>

<?php
$schools = [];
foreach ($result as $row) {
    $original_school = $row['school_short_name'];
    $school = in_array($original_school, ['SOET', 'SOCSE']) ? 'Engineering' : $original_school;

    $semester = (int)$row['semester'];
    $stream = ($semester === 1 || $semester === 2) ? 'General First Year' : $row['stream_name'];
    $semesterKey = $semester;
    $schools[$school][$stream][$semesterKey][] = $row;
}
?>

<?php foreach ($schools as $school_name => $streams): ?>
    <div class="school-name">School Name :- <?= $school_name ?></div>

    <?php
    $grand_total_applied = 0;
    $grand_total_pass = 0;
    $grand_total_fail = 0;
    $grand_th = ['appeared' => 0, 'pass' => 0, 'fail' => 0];
    $grand_pr = ['appeared' => 0, 'pass' => 0, 'fail' => 0];
    ?>

    <?php foreach ($streams as $stream_name => $semesters): ?>
        <table border="1">
            <tr>
                <td class="stream-header" colspan="10">Stream Name:- <?= $stream_name ?></td>
            </tr>
            <tr>
                <th rowspan="2">Semester</th>
                <th colspan="2">Applied Students</th>
                <th colspan="2">Passed Students</th>
                <th colspan="2">Fail Students</th>
                <th colspan="2">Passing Percentage</th>
            </tr>
            <tr>
                <th>TH</th><th>PR</th>
                <th>TH</th><th>PR</th>
                <th>TH</th><th>PR</th>
                <th>TH</th><th>PR</th>
            </tr>

            <?php
            $total_th = ['appeared' => 0, 'pass' => 0, 'fail' => 0];
            $total_pr = ['appeared' => 0, 'pass' => 0, 'fail' => 0];
            ?>

            <?php foreach ($semesters as $semester => $components): ?>
                <?php
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

                // Stream Totals
                $total_th['appeared'] += $componentsData['TH']['appeared'];
                $total_th['pass'] += $componentsData['TH']['pass'];
                $total_th['fail'] += $componentsData['TH']['fail'];

                $total_pr['appeared'] += $componentsData['PR']['appeared'];
                $total_pr['pass'] += $componentsData['PR']['pass'];
                $total_pr['fail'] += $componentsData['PR']['fail'];

                // Grand Totals
                $grand_th['appeared'] += $componentsData['TH']['appeared'];
                $grand_th['pass'] += $componentsData['TH']['pass'];
                $grand_th['fail'] += $componentsData['TH']['fail'];

                $grand_pr['appeared'] += $componentsData['PR']['appeared'];
                $grand_pr['pass'] += $componentsData['PR']['pass'];
                $grand_pr['fail'] += $componentsData['PR']['fail'];
                ?>
                <tr>
                    <td><?= $semester ?></td>
                    <td><?= $componentsData['TH']['appeared'] ?></td>
                    <td><?= $componentsData['PR']['appeared'] ?></td>
                    <td><?= $componentsData['TH']['pass'] ?></td>
                    <td><?= $componentsData['PR']['pass'] ?></td>
                    <td><?= $componentsData['TH']['fail'] ?></td>
                    <td><?= $componentsData['PR']['fail'] ?></td>
                    <td><?= $percentTH ?>%</td>
                    <td><?= $percentPR ?>%</td>
                </tr>
            <?php endforeach; ?>

            <?php
            $percentTH_total = $total_th['appeared'] > 0 ? round(($total_th['pass'] / $total_th['appeared']) * 100, 2) : 0;
            $percentPR_total = $total_pr['appeared'] > 0 ? round(($total_pr['pass'] / $total_pr['appeared']) * 100, 2) : 0;
            ?>
            <tr class="total-row">
                <td><strong>Total</strong></td>
                <td><?= $total_th['appeared'] ?></td>
                <td><?= $total_pr['appeared'] ?></td>
                <td><?= $total_th['pass'] ?></td>
                <td><?= $total_pr['pass'] ?></td>
                <td><?= $total_th['fail'] ?></td>
                <td><?= $total_pr['fail'] ?></td>
                <td><?= $percentTH_total ?>%</td>
                <td><?= $percentPR_total ?>%</td>
            </tr>
        </table>
    <?php endforeach; ?>

    <?php
    $grand_percentTH = $grand_th['appeared'] > 0 ? round(($grand_th['pass'] / $grand_th['appeared']) * 100, 2) : 0;
    $grand_percentPR = $grand_pr['appeared'] > 0 ? round(($grand_pr['pass'] / $grand_pr['appeared']) * 100, 2) : 0;
    ?>
    <table border="1">
        <tr class="total-row">
            <td><strong>Grand Total</strong></td>
            <td><?= $grand_th['appeared'] ?></td>
            <td><?= $grand_pr['appeared'] ?></td>
            <td><?= $grand_th['pass'] ?></td>
            <td><?= $grand_pr['pass'] ?></td>
            <td><?= $grand_th['fail'] ?></td>
            <td><?= $grand_pr['fail'] ?></td>
            <td><?= $grand_percentTH ?>%</td>
            <td><?= $grand_percentPR ?>%</td>
        </tr>
    </table>
<?php endforeach; ?>
<?php } ?>
<?php
$html = ob_get_clean();
$mpdf->WriteHTML($html);
$mpdf->Output('exam_summary_report.pdf', 'D');
exit;
