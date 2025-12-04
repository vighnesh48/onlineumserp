<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Conversion Certificate</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; margin: 20px; font-size: 12px; }
        .header img { height: 60px; }
        .header-center { text-align: center; }
        .title { text-align: center; font-size: 16px; font-weight: bold; margin-top: 15px; }
        .info td { padding: 3px 8px; }
        table.marks { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 12px; }
        table.marks th, table.marks td { border: 1px solid black; padding: 5px; text-align: center; }
        .remarks { margin-top: 20px; margin-bottom: 80px; }
        .bold { font-weight: bold; }
        ul { margin-top: 5px; padding-left: 20px; }
        .logo { height: 50px !important; display: block; margin: 0 auto 5px auto; }
        .certificate { page-break-after: always; }
    </style>
</head>
<body>

<?php foreach ($exam_results as $student): ?>
<div class="certificate">

    <div class="header">
        <div class="header-center">
            <img src="<?= FCPATH ?>assets/images/LOGO-2019.jpg" alt="Logo" class="logo">
            <p class="bold">OFFICE OF THE CONTROLLER OF EXAMINATIONS</p>
        </div>
    </div>

    <hr style="border: 3px solid black; margin: 10px 0;">

    <div style="text-align: right;">Date: <?= date('d-m-Y') ?></div>

    <div class="title">
        CONVERSION CERTIFICATE<br>
        <span style="font-weight: normal; font-size: 12px;">(For Degree Programme)</span>
    </div>

    <div class="info">
        <table>
            <tr><td>PRN</td><td>: <?= htmlspecialchars($student['enrollment_no'] ?? '') ?></td></tr>
            <tr><td>Name of the Candidate</td><td>: <?= htmlspecialchars($student['first_name'] ?? '') ?></td></tr>
            <tr><td>Name of the Programme</td><td>: <?= htmlspecialchars($student['stream_name'] ?? '') ?></td></tr>
            <tr><td>(with Specialization)</td><td>: <?= htmlspecialchars($student['degree_specialization'] ?? '') ?></td></tr>
            <tr><td>Month & Year of Passing</td><td>: <?= htmlspecialchars($exam_session ?? '') ?></td></tr>
        </table>
    </div>

    <table class="marks">
        <thead>
            <tr>
                <th>Sr. No</th>
                <th>Semester</th>
                <th>GPA</th>
                <th>Out of Marks (%)</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 1; $totalSgpa = 0; $semCount = 0;
                if (!empty($student['results'])):
                    foreach ($student['results'] as $result):
                        $totalSgpa += $result['sgpa']; $semCount++;
            ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td>Semester <?= $result['semester'] ?></td>
                    <td><?= $result['sgpa'] ?></td>
                    <td><?= number_format($result['sgpa'] * 10, 2) ?></td>
                </tr>
            <?php endforeach; endif;
                $cgpa = $semCount > 0 ? $totalSgpa / $semCount : 0;
            ?>
            <tr>
                <td colspan="2" class="bold">CGPA </td>
                <td><b><?= number_format($cgpa, 2) ?></b></td>
                <td><b><?= number_format(number_format($cgpa, 2) * 10, 2) ?></b></td>
            </tr>
        </tbody>
    </table>

    <div class="remarks">
        <p><strong>Note:</strong></p>
        <ul>
            <li><i>GPA – Grade Point Average</i></li>
            <li><i>CGPA – Cumulative Grade Point Average</i></li>
            <li><i>Conversion factor of CGPA to Percentage of marks is 10</i></li>
        </ul>
        <p><strong>Remarks:</strong> The Student has <span class="bold">COMPLETED</span> the total Programme of _______.</p>
    </div>

</div>
<?php endforeach; ?>

</body>
</html>
