<!DOCTYPE html>
<html>
<head>
    <style>
        table { border-collapse: collapse; width: 100%; font-size: 11px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f2f2f2; }
        h3 { margin-bottom: 5px; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Attendance Mark Report</h3>
    <p style="text-align:center;">
        From: <?= $from_date ?> | To: <?= $to_date ?>
    </p>

    <table>
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>School</th>
                <th>Course</th>
                <th>Stream</th>
                <th>Year</th>
                <th>Class</th>
                <th>Strength</th>
                <th>Lectures Assigned</th>
                <th>Lectures Taken</th>
                <th>Present %</th>
                <th>Absent %</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach($reportData as $row): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $row->school_name ?></td>
                <td><?= $row->course_name ?></td>
                <td><?= $row->stream_name ?></td>
                <td><?= $row->current_year ?></td>
                <td><?= $row->class_code ?></td>
                <td><?= $row->strength ?></td>
                <td><?= $row->lectures_assigned ?></td>
                <td><?= $row->lectures_taken ?></td>
                <td><?= $row->present_percentage ?>%</td>
                <td><?= $row->absent_percentage ?>%</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
