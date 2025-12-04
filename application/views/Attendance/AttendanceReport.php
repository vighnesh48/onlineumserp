<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Attendance Mark Report</title>
<style>
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color:#111; }
    .header { text-align:center; margin-bottom:10px; }
    .logo { margin-bottom:8px; }
    .logo img { height:60px; }
    h2 { margin: 0; font-size: 20px; font-weight:700; color:#0b3b6d; }
    .meta { text-align:center; font-size: 13px; color:#444; margin: 6px 0 15px; }

    table { width:100%; border-collapse: collapse; }
    th, td { border:1px solid #444; padding:7px 6px; }
    th {
        background: #e9edf5;
        color:#0b3b6d;
        font-weight: 700;
        font-size: 13px;
    }
    tbody tr:nth-child(even) { background:#fafafa; }
    tbody tr:hover { background:#f3f6fb; }
    .num { text-align:right; white-space:nowrap; }
    .bad { color:#b00020; font-weight:700; background:#ffe6ea; } /* Present% < 60% */
</style>
</head>
<body>

    <!-- Centered logo -->
    <div style="text-align:center; margin-bottom:10px;">
    <?php if (!empty($logo_url)): ?>
        <img src="<?= html_escape($logo_url) ?>" alt="Campus Logo" style="height:35px;"><br>
    <?php endif; ?>
    <h2 style="margin:5px 0 0; font-size:20px; color:#0b3b6d;">Attendance Mark Report</h2>
    <div style="font-size:13px; color:#444; margin-top:4px;">
        <strong>Session:</strong> <?= html_escape($acad_year_sched) ?> |
        <strong>Date:</strong> <?= html_escape($report_date) ?> |
        <strong>Campus:</strong> <?= html_escape($campus_label) ?>
    </div>
</div>

    <style>
    table { 
        width:100%; 
        border-collapse: collapse; 
        page-break-inside: auto;   /* allow table to split across pages */
    }
    thead { 
        display: table-header-group; /* repeat header on new page */
    }
    tfoot { 
        display: table-row-group; 
    }
    tr { 
        page-break-inside: avoid; 
        page-break-after: auto; 
    }
    td, th {
        border:1px solid #444;
        padding:6px 5px;
    }
    .num { text-align:right; }
    .bad { color:#b00020; font-weight:700; background:#ffe6ea; }
</style>

<table>
    <thead>
        <tr>
            <th>Sr. No</th>
            <th>School</th>
            <th>Course</th>
            <th>Stream</th>
            <th>Year</th>
            <th class="num">Strength</th>
            <th class="num">Lectures Assigned</th>
            <th class="num">Lectures Taken</th>
            <th class="num">Present %</th>
            <th class="num">Absent %</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($rows)): ?>
        <?php
        $grouped = [];
        foreach ($rows as $r) { $grouped[$r['School']][] = $r; }

        $sr = 1;
        foreach ($grouped as $school => $schoolRows):
            $rowspan = count($schoolRows);
            foreach ($schoolRows as $i => $r):
                $sem = (int)$r['Year'];
                if (in_array($sem, [1,2]))       $yearLabel = 'First Year';
                elseif (in_array($sem, [3,4]))   $yearLabel = 'Second Year';
                elseif (in_array($sem, [5,6]))   $yearLabel = 'Third Year';
                elseif (in_array($sem, [7,8]))   $yearLabel = 'Fourth Year';
                elseif (in_array($sem, [9,10]))  $yearLabel = 'Fifth Year';
                else                             $yearLabel = '—';

                $present = (float)$r['PresentPercentage'];
                $absent  = (float)$r['AbsentPercentage'];
                $presentClass = ($present < 50.0) ? 'bad' : '';
        ?>
        <tr>
            <td class="num"><?= $sr++ ?></td>
            <?php if ($i === 0): ?>
                <td rowspan="<?= $rowspan ?>"><?= html_escape($school) ?></td>
            <?php endif; ?>
            <td><?= html_escape($r['Course']) ?></td>
            <td><?= html_escape($r['Stream']) ?></td>
            <td><?= $yearLabel ?></td>
            <td class="num"><?= (int)$r['Strength'] ?></td>
            <td class="num"><?= (int)$r['No_of_lecture_assigned'] ?></td>
            <td class="num"><?= (int)$r['No_of_lecture_taken'] ?></td>
            <td class="num <?= $presentClass ?>"><?= number_format($present,2) ?></td>
            <td class="num"><?= number_format($absent,2) ?></td>
        </tr>
        <?php endforeach; endforeach; ?>
    <?php else: ?>
        <tr><td colspan="10" style="text-align:center; color:#666;">No data available</td></tr>
    <?php endif; ?>
    </tbody>
</table>


</body>
</html>
