<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
        .subtotal { font-weight: bold; background-color: #e9e9e9; }
        .grand-total { font-weight: bold; background-color: #d1e7dd; }
    </style>
</head>
<body>

<h2>SUN-School-wise Re-Registration Report (2025–2026)</h2>

<table>
    <thead>
        <tr>
            <th>School</th>
            <th>Course</th>
            <th>Stream</th>
            <th>Total Students (2024)</th>
            <th>Re-Registered (2025)</th>
            <th>Today's Registrations</th>
            <th>Pending</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $prev_school = '';
    $school_total = $school_re = $school_today = $school_pending = 0;
    $grand_total = $grand_re = $grand_today = $grand_pending = 0;

    foreach ($reportData as $i => $row):
        $is_new_school = $row['school_short_name'] != $prev_school;

        // Print subtotal for previous school
        if ($i > 0 && $is_new_school) {
            echo "<tr class='subtotal'>
                    <td colspan='3'>Total for $prev_school</td>
                    <td>{$school_total}</td>
                    <td>{$school_re}</td>
                    <td>{$school_today}</td>
                    <td>{$school_pending}</td>
                </tr>";

            // Reset school totals
            $school_total = $school_re = $school_today = $school_pending = 0;
        }

        // Print row
        echo "<tr>";
        echo "<td>" . ($is_new_school ? $row['school_short_name'] : '') . "</td>";
        echo "<td>{$row['course_short_name']}</td>";
        echo "<td>{$row['stream_name']}</td>";
        echo "<td>{$row['total_students_2024']}</td>";
        echo "<td>{$row['re_registered_count']}</td>";
        echo "<td>{$row['today_re_registered_count']}</td>";
        echo "<td>{$row['pending_count']}</td>";
        echo "</tr>";

        // Update counters
        $school_total += $row['total_students_2024'];
        $school_re += $row['re_registered_count'];
        $school_today += $row['today_re_registered_count'];
        $school_pending += $row['pending_count'];

        $grand_total += $row['total_students_2024'];
        $grand_re += $row['re_registered_count'];
        $grand_today += $row['today_re_registered_count'];
        $grand_pending += $row['pending_count'];

        $prev_school = $row['school_short_name'];
    endforeach;

    // Last school's subtotal
    if (!empty($prev_school)) {
        echo "<tr class='subtotal'>
                <td colspan='3'>Total for $prev_school</td>
                <td>{$school_total}</td>
                <td>{$school_re}</td>
                <td>{$school_today}</td>
                <td>{$school_pending}</td>
            </tr>";
    }

    // Grand total row
    echo "<tr class='grand-total'>
            <td colspan='3'>Grand Total (All Schools)</td>
            <td>{$grand_total}</td>
            <td>{$grand_re}</td>
            <td>{$grand_today}</td>
            <td>{$grand_pending}</td>
        </tr>";
    ?>
    </tbody>
</table>

