<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        h1,
        h2 {
            text-align: center;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    //  echo'<pre>';
    //  print_r($seating_arrangements);exit;
    ?>

    <table>
        <thead>
            <tr>
                <th>SR NO.</th>
                <th>NAME OF THE PROGRAMME</th>
                <th>COURSE</th>
                <th>COURSE-CODE</th>
                <th>COUNT</th>
                <th>Total</th>
                <th>PRN</th>
                <th>Room No</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $srNo = 1;
            foreach ($arrangements as $arrangement):
			
                $totalSubjects = count($arrangement['seating_arrangement']); // Total rows for this hall
                $isFirstRow = true; // Track the first row for rowspan
                ?>
                <?php foreach ($arrangement['seating_arrangement'] as $seat):
				
						// Skip row if course, prn, or program is empty or N/A
						if (
							empty($seat['max_enrollment']) || strtolower($seat['max_enrollment']) === 'n/a' &&
							empty($seat['subject_name']) || strtolower($seat['subject_name']) === 'n/a'
						) {
							$seat['count_subject_id'] = 0;
						}

                    $grandTotalStudents += $seat['count_subject_id'];
                    ?>
                    <tr>
                        <?php if ($isFirstRow): ?>
                            <td rowspan="<?= $totalSubjects ?>"><?= $srNo++ ?></td>
                        <?php endif; ?>
                        <td><?= $seat['stream_name'] ?></td>
                        <td><?= $seat['subject_name'] ?></td>
                        <td><?= $seat['subject_code'] ?></td>
                        <td><?= $seat['count_subject_id'] ?></td>
                        <?php if ($isFirstRow): ?>
                            <td rowspan="<?= $totalSubjects ?>"><?= $arrangement['total_students'] ?></td>
                        <?php endif; ?>
                        <td style="width:200px;"><?= $seat['min_enrollment'] ?> - <?= $seat['max_enrollment'] ?></td>
                        <?php if ($isFirstRow): ?>
                            <td rowspan="<?= $totalSubjects ?>"><?= $arrangement['floor'] ?>-<?= $arrangement['hall'] ?></td>
                            <?php $isFirstRow = false; ?>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" style="text-align: right;">Grand Total Students:</td>
                <td colspan="3" style="text-align: left;"><?= $grandTotalStudents ?></td>
            </tr>
        </tfoot>


    </table>
</body>

</html>

<?php // exit; ?>








