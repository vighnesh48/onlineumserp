<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Faculty Feedback Report</title>
<style>
    body {
        font-family: "DejaVu Sans", Arial, sans-serif;
        margin: 10px;
        padding: 0;
        font-size: 12px;
        color: #222;
        background: #fff;
    }

    h1, h2, h3, h4, h5, p {
        margin: 0;
        padding: 0;
    }

    .main-container {
        width: 100%;
        padding: 10px;
        background: #fff;
        border: 1px solid #ddd;
        box-sizing: border-box;
    }

    /* HEADER */
    .header-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    .header-table td {
        vertical-align: middle;
        text-align: center;
    }

    .header-logo {
        width: 90px;
        text-align: center;
    }

    .header-logo img {
        width: 75px;
    }

    .header-title {
        font-size: 26px;
        font-weight: bold;
        color: #003366;
        line-height: 1.3;
    }

    .sub-header {
        font-size: 13px;
        color: #555;
    }

    .report-title {
        font-size: 16px;
        margin-top: 6px;
        font-weight: bold;
        color: #111;
        text-transform: uppercase;
    }

    /* DETAILS */
    .details-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .details-table td {
        border: 1px solid #333;
        padding: 6px 8px;
        vertical-align: middle;
    }

    .details-table strong {
        color: #000;
    }

    /* CONTENT TABLE */
    .content-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 12px;
    }

    .content-table th {
        background: #f2f2f2;
        border: 1px solid #333;
        padding: 6px;
        font-weight: bold;
        text-align: center;
    }

    .content-table td {
        border: 1px solid #666;
        padding: 6px;
        text-align: center;
    }

    .content-table tr:nth-child(even) {
        background-color: #fafafa;
    }

    .summary-row {
        background: #e8f0fe;
        font-weight: bold;
    }

    .no-data {
        text-align: center;
        padding: 15px;
        color: #666;
        font-style: italic;
    }

    /* FOOTER TABLE */
    .footer-table {
        margin-top: 40px;
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }

    .footer-table td {
        width: 33%;
        text-align: center;
        padding-top: 40px;
        font-size: 12px;
        border-top: 1px solid #333;
    }

</style>
</head>

<body>
<div class="main-container">

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td class="header-logo">
                <img src="<?= base_url() ?>assets/images/logo-7.jpg" alt="Logo">
            </td>
            <td>
                <div class="header-title">Sandip University</div>
                <div class="sub-header">Mahiravani, Trimbak Road, Nashik – 422 213</div>
                <?php
                    $sesdet = explode('~', $fbdses);
                    $academic_sess = ($sesdet[0] == 'SUM') ? 'SUMMER' : 'WINTER';
                    $academic_year = $sesdet[1];
                ?>
                <div class="report-title">Faculty Feedback Report: <?= $academic_sess . " (" . $academic_year . ")" ?></div>
            </td>
        </tr>
    </table>

    <!-- Faculty Details -->
    <table class="details-table">
        <tr>
            <td><strong>Faculty:</strong></td>
            <td>
                <?php $sex = ($sb['gender'] == 'male') ? 'Mr.' : 'Mrs.'; ?>
                <?= $sex . ' ' . $fac[0]['fname'] . ' ' . $fac[0]['lname']; ?>
            </td>
            <td><strong>Stream:</strong></td>
            <td><?= $StreamSrtName[0]['stream_name'] ?></td>
        </tr>
        <tr>
            <td><strong>Subject:</strong></td>
            <td><?= $sub[0]['subject_name'] ?></td>
            <td><strong>Semester / Division:</strong></td>
            <td><?= $semester ?> / <?= $division . ' ' . $batch ?></td>
        </tr>
    </table>

    <!-- Feedback Data -->
    <table class="content-table">
        <thead>
            <tr>
                <th>Q. No</th>
                <th>Question</th>
                <th>Marks</th>
                <th>Out of</th>
                <th>Percentage (%)</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $i = 1; $j = 0; $sum_marks = 0; $sum_totmarks = 0;
            if (!empty($questions)) {
                foreach ($questions as $que) {
                    $queNo = 'Q'.$i;
                    $sum_marks += $marks[$j][$queNo];
                    $sum_totmarks += $marks[$j]['quecnt'] * 5;
                    $mrkobt = $marks[$j][$queNo];
                    $mrkoutof = $marks[$j]['quecnt'] * 5;
                    $per = round($mrkobt / $mrkoutof * 100);
        ?>
            <tr>
                <td><?= $i ?></td>
                <td style="text-align:left;"><?= $que['question_name'] ?></td>
                <td><?= $mrkobt ?></td>
                <td><?= $mrkoutof ?></td>
                <td><?= $per ?>%</td>
            </tr>
        <?php $i++; } ?>
            <tr class="summary-row">
                <td></td>
                <td style="text-align:right;">Total (<?= $marks[0]['quecnt'] ?> Feedbacks)</td>
                <td><?= $sum_marks ?></td>
                <td><?= $sum_totmarks ?></td>
                <td><?= round($sum_marks / $sum_totmarks * 100) ?>%</td>
            </tr>
        <?php } else { ?>
            <tr><td colspan="5" class="no-data">No feedback data available</td></tr>
        <?php } ?>
        </tbody>
    </table>

    <!-- Footer Signature Table -->
    <table class="footer-table">
        <tr>
            <td>Faculty Signature</td>
            <td>HOD Signature</td>
            <td>Dean Academics</td>
        </tr>
    </table>

</div>
</body>
</html>
