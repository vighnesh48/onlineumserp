<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Swapped Timetable Report</title>
    <style>
        body {
            font-family: "Bookman Old Style", serif;
        }
        .header-td {
            border: none;
        }
        .main_table, td {
            border-right: 1px solid rgba(138, 138, 138, 0.99);
            border-bottom: 1px solid rgba(138, 138, 138, 0.99);
            border-collapse: collapse;
            padding: 7px;
            font-size: 12px;
            line-height: 12px;
            margin-bottom: 10px;
        }
        th {
            border-right: 1px solid rgba(138, 138, 138, 0.99);
            border-bottom: 1px solid rgba(138, 138, 138, 0.99);
            border-top: 1px solid rgba(138, 138, 138, 0.99);
            border-collapse: collapse;
            padding: 7px;
            font-size: 12px;
            line-height: 12px;
            margin-bottom: 10px;
            background-color:rgb(39, 194, 255);
        }
        .main_table {
            padding: 0;
            width: 100%;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Header Section -->
<div id="header">
    <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin-bottom:5px;">
        <tr>
            <td class="header-td text-center">
                <p style="font-size: 14px; color: grey; font-weight: bold"><?= htmlspecialchars($tt_details[0]['academic_year']) ?> - Swapped Timetable Report</p>
            </td>
        </tr>
    </table>
</div>

<!-- Timetable Table -->
<table class="main_table">
    <thead>
        <tr>
            <th style="border-left: 1px solid rgba(138, 138, 138, 0.99);">#</th>
            <th>Academic Batch</th>
            <th>Subject</th>
            <th>Alternet Subject</th>
            <th>Type</th>
            <th>Div</th>
            <th>Batch</th>
            <th>Faculty</th>
            <th>Alternet Faculty</th>
            <th>Day</th>
            <th>Date</th>
            <th>Slot</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (!empty($tt_details)) {
            $i = 1;
            foreach ($tt_details as $row) {
                ?>
                <tr>
                    <td style="border-left: 1px solid rgba(138, 138, 138, 0.99);"><?= $i++; ?></td>
                    <td><?= $row['batch']; ?></td>
                    <td><?= ($row['subject_code'] == 'OFF') ? 'OFF Lecture' : $row['sub_code'].' - '.$row['subject_name']; ?></td>
                    <td><?= ($row['sub_id'] != $row['asub_id'] && $row['asub_id'] != '') ? $row['asub_code'].' - '.$row['asubject_name'] : '-'; ?></td>
                    <td><?= $row['subject_type']; ?></td>
                    <td><?= $row['division']; ?></td>
                    <td><?= $row['batch_no']; ?></td>
                    <td><?= strtoupper($row['fname'].'. '.$row['mname'].'. '.$row['lname']).' ('.$row['faculty_code'].')'; ?></td>
                    <td><?= strtoupper($row['afname'].' '.$row['amname'].' '.$row['alname']).' ('.$row['afaculty_code'].')'; ?></td>
                    <td><?= $row['wday']; ?></td>
                    <td><?= $row['dt_date']; ?></td>
                    <td><?= $row['from_time'].' - '.$row['to_time'].' '.$row['slot_am_pm']; ?></td>
                </tr>
                <?php
            }
        } else {
            echo '<tr><td colspan="12" class="text-center">No swapped records found.</td></tr>';
        }
        ?>
    </tbody>
</table>
<table width="100%" style="margin-top: 50px; font-size: 12px; border: none;">
    <tr>
    <td style="text-align: center; font-size: 12px; border: none;">
            <b> Academic Coordinator </b>
        </td>
    <td style="text-align: center; font-size: 12px; border: none;">
            <b>HoD </b>
        </td>
        <td style="text-align: center; font-size: 12px; border: none;">
            <b>Dean </b>
        </td>
    </tr>
</table>
</body>
</html>
