<!DOCTYPE html>
<html>

<head>
    <title>CIA Marks Report</title>
    <style>
        .absent_bg {
            background: #ff9b9b;
        }

        table {
            width: 100%;
            border: hidden;
        }

        th,
        td {
            border: 1px #000;
            text-align: left;
        }
    </style>
</head>

<body>
    <table align="center" width="100%" cellpadding="3" cellspacing="0" style="font-size:12px;margin-top:15px;">
        <tr>
            <td width="80" align="right" style="text-align:right;padding-top:5px;"><img
                    src="<?= base_url() ?>assets/images/su-logo.png" alt="" width="70" border="0"></td>
            <td style="font-weight:normal;text-align:center;">
                <h1 style="font-size:30px;">Sandip University</h1>
                <p>Mahiravani, Trimbak Road, Nashik – 422 213</p>
            </td>
            <td width="120" align="right" valign="top" style="text-align:center;padding-top:15px;">
                <h3 style="font-size: 25px"></h3>
            </td>
        </tr>
        <tr>
            <td></td>
            <?php if ($sts == 'Y') { ?>
                <td align="center" style="text-align:center;margin:0;padding:0">
                    <h3 style="font-size:18px;">
                        <?php if ($me[0]['marks_type'] == 'TH') {
                            echo "Theory";
                        } else {
                            echo "Laboratory";
                        } ?> Mark Entry -
                        <?= $me[0]['exam_month'] . ' ' . $me[0]['exam_year'] ?></h3>
                </td>
            <?php } else { ?>
                <td align="center" style="text-align:center;margin:0;padding:0">
                    <h3 style="font-size:18px;">CIA Marks and Attendance Report</h3>
                </td>
            <?php } ?>
            <td></td>
        </tr><br>
    </table>
    <?php
    if ($streamId != '' && $streamId == '71') {
        $semname = 'Year';
    } else {
        $semname = 'Semester';
    }
    ?>
    <table  border="1" align="center" width="100%" cellpadding="3" cellspacing="0" style="font-size:12px;">
        <tr>
            <td style="border: 0.5px solid #000; text-align: left;" width="0.500" height="30" valign="middle">
                &nbsp;<strong>School Name:</strong></td>
            <td style="border: 0.5px solid #000; text-align: left;" height="30" valign="middle" colspan='4'>&nbsp;
                <?= $StreamSrtName[0]['school_name'] ?></td>
            <td style="border: 0.5px solid #000; text-align: left;" width="85" height="30" valign="middle">
                &nbsp;<strong>Programme:</strong> </td>
            <td style="border: 0.5px solid #000; text-align: left;" height="30" valign="middle" colspan='4'>
                &nbsp;<?= $StreamSrtName[0]['stream_name'] ?> </td>
        </tr>
        <tr>
            <td style="border: 0.5px solid #000; text-align: left;" height="30">&nbsp;<strong>Course Code:</strong></td>
            <td style="border: 0.5px solid #000; text-align: left;" height="30" colspan='4'>
                &nbsp;<?= strtoupper($ut[0]['subject_code']) ?></td>
            <td style="border: 0.5px solid #000; text-align: left;" height="30" valign="middle">
                &nbsp;<strong>Name:</strong> </td>
            <td style="border: 0.5px solid #000; text-align: left;" height="30" valign="middle" colspan=4>
                &nbsp;<?= strtoupper($ut[0]['subject_name']) ?> </td>
        </tr>
        <tr>
            <td style="border: 0.5px solid #000; text-align: left;" height="30" valign="middle">
                &nbsp;<strong>Credits:</strong> </td>
            <td style="border: 0.5px solid #000; text-align: left;" height="30" colspan='4'>&nbsp;<?= $ut[0]['credits'] ?>
            </td>
            <td style="border: 0.5px solid #000; text-align: left;" height="30" valign="middle">
                &nbsp;<strong><?= $semname ?>:</strong> </td>
            <td style="border: 0.5px solid #000; text-align: left;" height="30" valign="middle">
                &nbsp;<?= $cia_marks_data[0]['semester'] ?> </td>
            <td style="border: 0.5px solid #000; text-align: left;" height="30" valign="middle">
                &nbsp;<strong>Date:</strong> </td>
            <td style="border: 0.5px solid #000; text-align: left;" height="30" colspan='2'>&nbsp;<?= date('d-m-Y') ?>
            </td>
        </tr>
    </table>
    <br>
    <table  border="1" align="center" width="100%" cellpadding="3" cellspacing="0" style="font-size:12px;">
        <thead>
            <tr>
                <th style="border: 0.5px solid #000; text-align: left;">Sr. No.</th>
                <th style="border: 0.5px solid #000; text-align: left;">Enrollment Number</th>
                <?php if ($cia_marks_data[0]['subject_component'] == 'TH') { ?>
                    <th style="border: 0.5px solid #000; text-align: left;">CIA1</th>
                    <th style="border: 0.5px solid #000; text-align: left;">CIA2</th>
                    <th style="border: 0.5px solid #000; text-align: left;">CIA3</th>
                <?php } else { ?>
                    <th style="border: 0.5px solid #000; text-align: left;">CIA1 & CIA2 (Lab-Practical Works)</th>
                    <th style="border: 0.5px solid #000; text-align: left;">CIA3 (Viva)</th>
                <?php } ?>
                <th style="border: 0.5px solid #000; text-align: left;">CIA4 (Behavioural Attitude)</th>
                <th style="border: 0.5px solid #000; text-align: left;">CIA4 (Theory and Practical Attendance)</th>
                <th style="border: 0.5px solid #000; text-align: left;"><b>TOTAL CIA Marks</b></th>
            </tr>
        </thead>
        <tbody>
            <?php $sr_no = 1; ?>
            <?php foreach ($cia_marks_data as $marks): ?>
                <tr>
                    <td style="border: 0.5px solid #000; text-align: left;"><?= $sr_no++ ?></td>
                    <td style="border: 0.5px solid #000; text-align: left;"><?= $marks['enrollment_no'] ?></td>
                    <?php if ($marks['subject_component'] == 'TH') { ?>
                        <td style="border: 0.5px solid #000; text-align: left;"><?= $marks['CIA1'] ?></td>
                        <td style="border: 0.5px solid #000; text-align: left;"><?= $marks['CIA2'] ?></td>
                        <td style="border: 0.5px solid #000; text-align: left;"><?= $marks['CIA3'] ?></td>
                    <?php } else { ?>
                        <td style="border: 0.5px solid #000; text-align: left;"><?= $marks['lab_pr_works'] ?></td>
                        <td style="border: 0.5px solid #000; text-align: left;"><?= $marks['viva'] ?></td>
                    <?php } ?>
                    <td style="border: 0.5px solid #000; text-align: left;"><?= $marks['behavioural_attitude'] ?></td>
                    <td style="border: 0.5px solid #000; text-align: left;"><?= $marks['attendance'] ?></td>
                    <td style="border: 0.5px solid #000; text-align: left;"><b><?= $marks['cia_marks'] ?></b></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>