<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invigilation Duty List</title>
    <style>
        body {
            font-family: "bookman-old-style", serif;
        }

        .header-td {
            border: none;
        }

        .main_table,
        td,
        th {
            border: 1px solid #000;
            border-collapse: collapse;
            padding: 7px;
            font-size: 12px;
            line-height: 12px;
            font-family: "bookman-old-style", serif;
            margin-bottom: 10px;
        }

        .main_table {
            padding: 0;
        }

        .page-break {
            page-break-after: always;
            /* Ensures a new page starts after this element */
        }
    </style>
</head>

<body>
    <div id="header">
        <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin-bottom:5px;">
            <tr>
                <td class="header-td" style="font-weight:normal;text-align:center;">
                    <p style="font-size: 14px; font-color: grey; font-weight: bold"><?= $exam_session ?> -
                        <?= strtoupper(htmlspecialchars($title)) ?> (<?= $center ?>)
</p>
                </td>

            </tr>
        </table>
    </div>


    <div>

        <div id="header">
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin-bottom:5px;">
                <tr>
                    <td class="header-td" style="text-align:left;">
                        <p> <strong>Date:</strong><span style="font-size: 12px"> <?= htmlspecialchars($current_date) ?>
                            </span> </p>
                    </td>
                    <td class="header-td" style="text-align:right;">
                        <p> <strong>Session:</strong><span style="font-size: 12px">
                                <?= htmlspecialchars($current_session) ?> </span> </p>
                    </td>

                </tr>
            </table>
        </div>

        <table class="main_table" width="100%" style="text-align: center;">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Faculty Name</th>
                    <th>Alternet Faculty</th>
                    <th>Role Name</th>
                    <th>Contact No.</th>
                    <th>Alternet Faculty Contact</th>
                    <th>Remark</th>

                </tr>
            </thead>
            <tbody>
                <?php $rowIndex = 1; ?>
                <?php foreach ($faculty_list as $faculty) {
						$replace_emp_id = ($faculty['replace_emp_id'] == 0) ? '' : $faculty['replace_emp_id'];
                    ?>
                    <tr>
                        <td><?= $rowIndex ?></td>
                        <td><?= $faculty['emp_id'].' -'.htmlspecialchars($faculty['faculty_name']) ?></td>
                        <td><?= $replace_emp_id .' -'.htmlspecialchars($faculty['replace_faculty_name']) ?></td>
                        <td><?= htmlspecialchars($faculty['role_name']) ?></td>
                        <td><?= htmlspecialchars($faculty['mobile']) ?></td>
                        <td><?= htmlspecialchars($faculty['replace_faculty_mobile']) ?></td>
                        <td></td>
                    </tr>
                    <?php $rowIndex++ ?>

                <?php } ?>
            </tbody>
        </table>
    </div>


</body>

</html>