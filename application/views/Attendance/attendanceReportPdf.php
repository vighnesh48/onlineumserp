<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background: #f2f2f2; }
        .subject-header { background: #ddd; }
        .low { color: red; font-weight: bold; }
        .high { color: green; font-weight: bold; }

        /* Header styles */
        .college-name { font-size: 18px; font-weight: bold; text-align: center; margin-bottom: 5px; }
        .header img { height: 60px; }
        .title { font-size: 16px; font-weight: bold; margin-top: 5px; }
        .meta { font-size: 12px;margin-top:5px}

        /* Page setup */
        @page {
            margin: 60px 30px 40px 30px;
        }
        header { position: fixed; top: -90px; left: 0; right: 0; text-align: center; }
        footer { position: fixed; bottom: -40px; left: 0; right: 0; font-size: 10px; text-align: center; color: #555; }
        .pagenum:before { content: counter(page); }

        /* Signature page */
        .signature-page { page-break-before: always; position: relative; }

        .signatures { width: 100%; margin-top: 3px; }
        .signatures td {
            width: 33%;
            text-align: center;
            vertical-align: bottom;
            height: 80px;
            font-weight: bold;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 40%;
            left: 15%;
            font-size: 60px;
            color: rgba(180,180,180,0.2);
            transform: rotate(-30deg);
            white-space: nowrap;
            z-index: 0;
        }

        /* Averages */
        .summary { margin-top: 10px; }
        .summary th { background: #e6e6e6; }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <!--<div class="college-name">Sandip Foundation, Nashik</div>-->
        <img src="<?= FCPATH ?>assets/images/su-logo.png" alt="Logo" style="height:120px;padding-top:50px!important"><br>
        <div class="title">Student Attendance Report</div>
        <div class="meta">
    <strong>Academic Year:</strong> <?= $academic_year ?> |
   <strong> Stream:</strong> <?= $streamName ?> | <strong>Semester:</strong> <?= $semester ?> | <strong>Division:</strong> <?= $division ?> |
    <strong>Period: </strong><?= $from_date ?> to <?= $to_date ?>
</div>
		
    </header>

    <!-- Footer -->
    <footer>
        Generated on <?= date('d-m-Y H:i:s') ?> | Page <span class="pagenum"></span>
    </footer>

    <!-- Main content -->
    <main style="margin-top:120px!important;">
        <table>
    <thead>
        <tr>
            <?php if ($report_type == 'B'): ?>
                <th rowspan="2">Batch</th> <!-- ✅ Batch column -->
            <?php endif; ?>
			  <!-- ✅ Sr. No. -->
            <th rowspan="2">PRN</th>
            <th rowspan="2">Student Name</th>
            <?php foreach ($subjects as $sub): ?>
                <th colspan="3" class="subject-header"><?= $sub['subject_name'] ?></th>
            <?php endforeach; ?>
            <th colspan="3" class="subject-header">Overall</th>
        </tr>
        <tr>
            <?php foreach ($subjects as $sub): ?>
                <th>Total</th>
                <th>Attended</th>
                <th>%</th>
            <?php endforeach; ?>
            <th>Total</th>
            <th>Attended</th>
            <th>%</th>
        </tr>
    </thead>
     <tbody>
        <?php if ($report_type == 'B'): ?>
            <?php 
            // ✅ Group students by batch
            $batchGroups = [];
            foreach ($attendanceReport as $row) {
                $batchGroups[$row['batch_name']][] = $row;
            }
            ?>
            <?php foreach ($batchGroups as $batchName => $students): ?>
                <?php $rowspan = count($students); ?>
				
                <?php foreach ($students as $index => $row): ?>
                    <tr>
                        <?php if ($index == 0): ?>
                            <!-- ✅ Batch only once per group, with count -->
                            <td rowspan="<?= $rowspan ?>"><?= $batchName ?> (<?= $rowspan ?>)</td>
                        <?php endif; ?>
                       
                        <td><?= $row['enrollment_no'] ?></td>
                        <td><?= $row['student_name'] ?></td>

                        <?php foreach ($subjects as $sub): 
                            $sname   = preg_replace('/[^A-Za-z0-9]/', '_', $sub['subject_name']); 
                            $percent = $row[$sname.'_Percent'] ?? null;
                        ?>
                            <td><?= $row[$sname.'_Total'] ?? '-' ?></td>
                            <td><?= $row[$sname.'_Attended'] ?? '-' ?></td>
                            <td class="<?= ($percent !== null && $percent < 75) ? 'low' : 'high' ?>">
                                <?= $percent !== null ? $percent : '-' ?>
                            </td>
                        <?php endforeach; ?>

                        <?php $overallPercent = $row['Overall_Percent']; ?>
                        <td><?= $row['Overall_Total'] ?></td>
                        <td><?= $row['Overall_Attended'] ?></td>
                        <td class="<?= ($overallPercent < 75) ? 'low' : 'high' ?>">
                            <?= $overallPercent ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <?php $i=1;  foreach ($attendanceReport as $row): ?>
                <tr>
				
                    <td><?= $row['enrollment_no'] ?></td>
                    <td><?= $row['student_name'] ?></td>

                    <?php foreach ($subjects as $sub): 
                        $sname   = preg_replace('/[^A-Za-z0-9]/', '_', $sub['subject_name']); 
                        $percent = $row[$sname.'_Percent'] ?? null;
                    ?>
                        <td><?= $row[$sname.'_Total'] ?? '-' ?></td>
                        <td><?= $row[$sname.'_Attended'] ?? '-' ?></td>
                        <td class="<?= ($percent !== null && $percent < 75) ? 'low' : 'high' ?>">
                            <?= $percent !== null ? $percent : '-' ?>
                        </td>
                    <?php endforeach; ?>

                    <?php $overallPercent = $row['Overall_Percent']; ?>
                    <td><?= $row['Overall_Total'] ?></td>
                    <td><?= $row['Overall_Attended'] ?></td>
                    <td class="<?= ($overallPercent < 75) ? 'low' : 'high' ?>">
                        <?= $overallPercent ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>


</table>


        <!-- Summary section -->
        <div class="summary">
            <h3 style="text-align:center; margin-bottom:5px;">Class Average Attendance</h3>
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Average %</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subjects as $sub): 
                        $sname = preg_replace('/[^A-Za-z0-9]/', '_', $sub['subject_name']);
                        $totalPercent = 0; $count = 0;
                        foreach ($attendanceReport as $row) {
                            if (isset($row[$sname.'_Percent'])) {
                                $totalPercent += $row[$sname.'_Percent'];
                                $count++;
                            }
                        }
                        $avg = $count ? round($totalPercent / $count, 2) : 0;
                    ?>
                        <tr>
                            <td><?= $sub['subject_code'] ?>-<?= $sub['subject_name'] ?></td>
                            <td class="<?= ($avg < 75) ? 'low' : 'high' ?>"><?= $avg ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
			<br>
			<table class="signatures">
            <tr>
                <td>_________________<br>Class Teacher</td>
                <td>_________________<br>Head of Department</td>
                <td>_________________<br>Dean</td>
            </tr>
        </table>
        </div>
		    <!-- Signature page -->
    
    </main>


</body>
</html>
