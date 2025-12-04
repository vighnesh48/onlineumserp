<!DOCTYPE html>
<html>
<head>
    <title>Batch-Wise Results</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Batch-Wise Results</h1>

    <?php
    $current_batch = null;
    $batch_data = [];
    
    // Group results by batch
    foreach ($results as $result) {
		echo '<pre>';print_r($result);
        $batch_data[$result['batch_year']]['subjects'][] = $result['subject_name'];
        $batch_data[$result['batch_year']]['students'][$result['student_name']][$result['subject_name']] = $result['marks'];
    }

    // Display each batch separately
    foreach ($batch_data as $batch_year => $data):
        $subjects = array_unique($data['subjects']); // Get unique subjects for the batch
    ?>
        <h2>Batch <?= $batch_year; ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <?php foreach ($subjects as $subject): ?>
                        <th><?= $subject; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data['students'] as $student_name => $marks):
                ?>
                    <tr>
                        <td><?= $student_name; ?></td>
                        <?php foreach ($subjects as $subject): ?>
                            <td><?= $marks[$subject] ?? '-'; ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</body>
</html>
