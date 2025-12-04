<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sandip University Marksheet</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            margin: 40px;
        }
        .header .info div {
            margin: 3px 0;
        }
        .title-table {
            width: 100%;
            border: 2px solid black;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .title-table td {
            padding: 8px;
            border: 1px solid black;
            font-weight: bold;
        }
        .marks-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .marks-table th, .marks-table td {
            border: 1px solid black;
            text-align: center;
            padding: 8px;
        }
        /* .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .footer div {
            width: 33%;
            text-align: center;
            font-weight: bold;
        } */
        .note {
            margin-top: 10px;
            font-style: italic;
            margin-bottom: 80px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

<?php
function roman_numerals($number) {
    $map = [
        1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
        5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
        9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
    ];
    return $map[$number] ?? $number;
}

foreach ($transcript_data as $student): 
    // Prepare semesters array with keys 1 to 8, fill empty if missing
    $semesters = [];
    for ($i = 1; $i <= 12; $i++) {
        if (isset($student['semesters'][$i])) {
            $semesters[$i] = $student['semesters'][$i];
            $semesters[$i] = ['obtain_marks' => '', 'total_marks_out_of' => ''];
        } else {
            $semesters[$i] = ['obtain_marks' => '', 'total_marks_out_of' => ''];
        }
    }

    $totalMarks = 0;
    $totalOutOf = 0;
?>
<div class="page-break">

    <!-- Header -->
    <div style="border: 4px solid black; border-radius: 20px; overflow: hidden; width: 100%; margin-bottom: 15px;">
        <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
            <tr>
                <!-- Logo column -->
                <td style="width: 110px; text-align: center; vertical-align: middle;">
                    <img src="<?= FCPATH ?>assets/images/su-logo.png" alt="Logo"
                        style="height: 90px; width: 90px; border: 3px solid black; border-radius: 20px; padding: 6px; box-sizing: border-box;">
				</td>

                <!-- Text column -->
                <td style="vertical-align: middle; text-align: center; padding-right: 15px;">
                    <div style="font-size: 17px; font-weight: bold; margin-bottom:5;">SANDIP UNIVERSITY</div>
                    <div style="font-size: 14px; font-weight: bold;">OFFICE OF THE CONTROLLER OF EXAMINATIONS</div>
                    <div style="font-size: 11px;">Mahiravani, Trimbak Road, Tal & Dist. Nashik–422213, Maharashtra.</div>
                    <div style="font-size: 11px;"><a href="https://www.sandipuniversity.edu.in" target="_blank">www.sandipuniversity.edu.in</a></div>
                    <div style="font-size: 11px;">Mobile: 9607978068 &nbsp; Email: suncoeexam@sandipuniversity.edu.in</div>
                </td>
            </tr>
        </table>
    </div>

    <?php
// Get the first non-empty exam_name from semesters
$passing_exam_name = '';

if (!empty($student['semesters']) && is_array($student['semesters'])) {
    foreach ($student['semesters'] as $semester) {
        if (!empty($semester['exam_name'])) {
            $passing_exam_name = is_array($semester['exam_name'])
                ? $semester['exam_name'][0] // if exam_name is array
                : $semester['exam_name'];   // if it's a string
            break; // stop at first found
        }
    }
}
?>




    <!-- Student Info Table -->
    <table class="title-table">
        <tr>
            <td>Name of the Student:-</td>
            <td><?= htmlspecialchars($student['first_name'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td>PRN :-</td>
            <td><?= htmlspecialchars($student['enrollment_no'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td>Course Name:-</td>
            <td><?= htmlspecialchars($student['stream_name'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td>Month & Year of Passing:-</td>
            <td><?= htmlspecialchars($passing_exam_name ?: 'N/A') ?></td>
        </tr>

        <!-- Add passing year if you have that field -->
    </table>

    <!-- Marks Table -->
    <!-- Marks Table -->
<table class="marks-table">
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Semester</th>
            <th>Marks Obtained</th>
            <th>Marks Out of</th>
            <th>Percentage</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $totalMarks = 0;
            $totalOutOf = 0;
            $srNo = 1;
            $semesterNo = 1; // 👈 Start semester from 1

            foreach ($student['semesters'] as $semester):
                $marks = $semester['obtain_marks'] ?? '';
                $outof = $semester['total_marks_out_of'] ?? '';
                $percent = ($marks !== '' && $outof !== '' && $outof != 0) ? round(($marks / $outof) * 100, 2) . '%' : '';
                $totalMarks += is_numeric($marks) ? $marks : 0;
                $totalOutOf += is_numeric($outof) ? $outof : 0;
            ?>
            <tr>
                <td><?= $srNo++ ?></td>
                <td><?= roman_numerals($semesterNo++) ?></td>
                <td><?= htmlspecialchars($marks) ?></td>
                <td><?= htmlspecialchars($outof) ?></td>
                <td><?= htmlspecialchars($percent) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="2"><strong>Total</strong></td>
            <td><strong><?= $totalMarks ?></strong></td>
            <td><strong><?= $totalOutOf ?></strong></td>
            <td><strong><?= $totalOutOf ? round(($totalMarks / $totalOutOf) * 100, 2) . '%' : 'N/A' ?></strong></td>
        </tr>
    </tbody>
</table>

    <!-- Note -->
     <p class="note">Note: These marks are given only for admission purpose to PG Course.</p>


</div>
<?php endforeach; ?>

</body>
</html>
<!-- 
im getting semester name course enrollment not correct rest im not getting obtained marks total marks exam  -->