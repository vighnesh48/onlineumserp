<?php // print_r($this->data);exit;?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Parent Letter</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 13px;
            margin: 50px;
            padding: 20px;
            border: 1px solid black;
            width: 800px;
        }

        ul li {
            font-size: 13px
        }

        .header,
        .sub-header,
        .contact {
            text-align: center;
            font-weight: bold;
        }

        .header {
            font-size: 13pt;
            margin-bottom: 10px;
        }

        .sub-header {
            font-size: 8pt;
            margin-bottom: 15px;
        }

        .contact {

            margin-bottom: 0px;
        }

        .content {

            margin-bottom: 20px;
        }

        .table-container {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 13px
        }

        .table-container th,
        .table-container td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        .signature {
            margin-top: 40px;
            font-weight: bold;
        }

        .date {
            text-align: right;
            margin-bottom: 20px;
            font-size: 8pt;
        }

        .bold {
            font-weight: bold;
        }

        ul {
            font-size: 12pt;
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <!-- <div class="header">
        <span style="color:red">SANDIP INSTITUTE OF TECHNOLOGY & RESEARCH CENTRE, NASHIK</span><br />
        <span style="font-size:14px">Affiliated to University of Pune, Approved by AICTE, New Delhi & (ISO 9001:2008 certified)</span>
    </div> -->

    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 15%; text-align: left; vertical-align: top; padding-bottom:15px;">
                <img src="<?= base_url('assets/images/su-logo.jpg'); ?>" style="width: 80px; height: auto;">
            </td>

            <td style="width: 85%; text-align: center; vertical-align: middle;">
                <?php if ($db_name == 'sf') { ?>
                    <span style="color:red; font-weight: bold;">SANDIP INSTITUTE OF TECHNOLOGY & RESEARCH CENTRE, NASHIK</span><br />

                    <div class="contact">
                        Website: <a href="https://www.sandipfoundation.org">www.sandipfoundation.org</a> |
                        Email: sandipfoundation@gmail.com <br>
                        Ph. No.: 02594 222551 - 53 | Fax: 02594 222555
                    </div>
                <?php } else { ?>
                    <span style="color:red; font-weight: bold;font-size:20px">SANDIP UNIVERSITY, NASHIK</span><br />

                    <div class="contact">
                        Website: <a href="https://www.sandipuniversity.edu.in">https://www.sandipuniversity.edu.in</a> |
                        Email: info@sandipuniversity.edu.in <br>
                        Ph. No.: 1800-212-2714
                    </div>

                <?php } ?>
            </td>
        </tr>
    </table>
    <hr />

    <div class="date">
        <strong>Date:</strong> <?= date('d/m/Y') ?>
    </div>

    <div class="content" style="width:50%;float:left">
        <strong>To,</strong> <br>
        <strong><?= $attendance_data[0]['first_name'] ?></strong> <br /><br />
        <?= $attendance_data[0]['address'] ?>, <?= $attendance_data[0]['taluka'] ?>, <br>
        <?= $attendance_data[0]['district'] ?>, <?= $attendance_data[0]['state'] ?> - <?= $attendance_data[0]['pincode'] ?> <br>

    </div>
    <div class="content" style="width:50%;float:right;text-align:right">

        <strong>Student ID:</strong> <?= $attendance_data[0]['enrollment_no'] ?> <br>
        <!-- <strong>Enrollment No:</strong> <?php // $attendance_data[0]['enrollment_no'] 
                                                ?> <br> -->
    </div>

    <div style="clear:both"></div>

    <div class="content" style="display:inline">
        <span style="padding:3px 20px;"><strong>Academic Progress Report of your Son/Daughter</strong> </span>
        <span style="padding:3px 20px;"><strong>Student Name:</strong> <?= $attendance_data[0]['first_name'] ?> </span> <br>
        <span style="padding:3px 20px;">
		<?php if(!empty($from_date)){?>
            <strong>Study Duration:</strong>
            From <?= !empty($from_date) ? $from_date : '--' ?>
            To <?= !empty($to_date) ? $to_date : '--' ?>
        </span>
		<?php }?>
        <?php
        $year_mapping = [
            1 => 'F.E',
            2 => 'S.E',
            3 => 'T.E',
            4 => 'B.E',
            5 => 'Fifth Year',
            6 => 'Sixth Year'
        ];
        $class_name = isset($attendance_data[0]['current_year']) ? ($year_mapping[$attendance_data[0]['current_year']] ?? 'Unknown') : 'Unknown';
        ?>

        <span style="padding:3px 20px;"><strong>Class:</strong> <?= $class_name ?> | <strong>Division:</strong> <?= $attendance_data[0]['division'] ?></span>
    </div>

    <table class="table-container">
        <tr style="font-size: 13px!important;">
            <th>Subject Name</th>
            <th>No. of Classes Conducted</th>
            <th>No. of Classes Attended</th>
            <th>Attendance (%)</th>
        </tr>

        <?php
        $total_percentage = 0;
        $subject_count = count($attendance_data);

        foreach ($attendance_data as $attendance) :
            $attendance_percentage = ($attendance['total_lectures'] > 0) ?
                round(($attendance['total_attended_lectures'] / $attendance['total_lectures']) * 100, 2) : 0;

            $total_percentage += $attendance_percentage;
        ?>
            <tr style="font-size: 13px!important;">
                <td><?= $attendance['subject_name'] ?></td>
                <td><?= $attendance['total_lectures'] ?></td>
                <td><?= $attendance['total_attended_lectures'] ?></td>
                <td><?= $attendance_percentage . '%' ?></td>
            </tr>
        <?php endforeach; ?>

        <?php
        $overall_attendance = ($subject_count > 0) ? round(($total_percentage / $subject_count), 2) : 0;
        ?>
    </table>


    <div class="content" style="text-align: right; font-size: 14px; font-weight: bold; margin-top: 20px;">
        <span>Overall Attendance Percentage:
            <span style="color: <?= ($overall_attendance >= 75) ? 'green' : 'red' ?>;">
                <?= $overall_attendance ?>%
            </span>
        </span>
    </div>

    <div class="content">
        <ul>
            <li>Your ward is <strong><?= ($overall_attendance  >= 75) ? 'regular' : 'not regular' ?></strong> in attending classes.</li>
            <li>Your ward is advised to attend the classes regularly in the subjects where attendance is below 75%.</li>
            <li>Ask your ward to appear for tests/exams compulsorily.</li>
            <li>Absentees/failures will be penalized.</li>
            <li>Ask your ward to spend extra hours with the subject teacher for subjects where marks are low.</li>
            <li>Parents are requested to meet the undersigned regarding the progress of their ward.</li>
            <li>As per Sandip University norms, 75% attendance in each subject is compulsory, failing which your ward will be detained from the final exam.</li>
        </ul>
    </div>

    <div style="width:50%;float:left;">
        <strong>Thanking you,</strong> <br><br>
        Yours sincerely,<br><br>--------------------------------- <br><br>
        <strong>Tutor</strong>

    </div>
    <div style="width:45%;float:right;text-align:right;">
        <br><br><br><br>
        <strong>HOD</strong> <br>

    </div>

</body>

</html>