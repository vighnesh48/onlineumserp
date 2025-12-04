<!DOCTYPE html>
<html>
<head>
    <style>
        .body {
            font-family: "Bookman Old Style", serif;     
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table, .table th, .table td {
            border: 1px solid #000;
        }
        .table th, .table td {
            padding: 8px;
            text-align: center;
        }
        .content-table tr td {
            border: 1px solid #333;
            vertical-align: middle;
        }
        .content-table th {
            border-left: 1px solid #333;
            border-right: 1px solid #333;
            border-bottom: 1px solid #333;
        }
        .content-table td {
            padding-left: 8px;
        }
        /* New Page for Each School */
        .new-page {
            page-break-before: always;
			
        }
        h1, h3 { margin: 0; padding: 0; }
        .marks-table td { height: 30px; vertical-align: middle; }
        .marks-table th { height: 30px; }
        p { padding: 0px; margin: 0px; }
        .signature {
            text-align: center;
        }
    </style>  
</head>
<body>
<?php
if($reval_type == 0){
    $fname = "PHOTOCOPY";
} else {
    $fname = "REVALUATION";
}
?>


<?php
$CI =& get_instance();
$CI->load->model('Reval_model');
foreach ($stream_list as $value) {
    // Check if it's a new school, if so, add a page break
    if ($value['school_short_name'] != $previous_school) {
        if ($previous_school != "") {
            echo "</div>";  // End previous school section
        }
        echo '<div class="new-page">'; // Start new page for new school
        echo "<h2>School Name: " . $value['school_short_name'] . "</h2>";  // Print the school name at the top
        $previous_school = $value['school_short_name'];
    }

    // Table for the streams under each school
    echo '<table class="content-table" width="800" cellpadding="0" cellspacing="0" border="1" align="center" style="font-weight:bold;height:150px;">';
    echo '<tr><td height="30" width="15%" valign="middle">&nbsp;<strong>Program:</strong></td>';
    echo '<td height="30" valign="middle" colspan="3">&nbsp;' . $value['stream_name'] . '</td></tr>';
    echo '</table>';

    // Stream-specific table with the subject list
    echo '<table class="content-table" border="1">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Course Code</th>    
                <th>Semester</th>
                <th>Course Name</th>
                <th>No. of Applied</th>           
            </tr>
        </thead>
        <tbody id="studtbl">';

    $result_data = $school_code . '~' . $stream . '~' . $exam_month . '~' . $exam_year . '~' . $exam_id;
    echo '<input type="hidden" id="res_data" name="res_data" value="' . $result_data . '">';

    $i = 0;
    $j = 1;

    if (!empty($value['subject_list'])) {                          
        foreach ($value['subject_list'] as $val) {
            $sub_stud = $this->Reval_model->fetch_revalsub_students($value['stream_id'], $val['subject_id'], $exam_id, $reval_type, $dtdate);
            echo '<tr><td align="center" rowspan="2" width="10%">' . $j . '</td>';
            echo '<td align="center" width="15%">' . $val['subject_code'] . '</td>';
            echo '<td align="center" width="10%">' . $val['semester'] . '</td>';
            echo '<td>' . $val['subject_name'] . '</td>';
            echo '<td align="center" width="15%">' . count($sub_stud) . '</td>';
            echo '</tr>';
            echo '<tr><td colspan=4 style="word-wrap: break-word;">';

            foreach ($sub_stud as $stud) {
                $enrollment_no = $stud['enrollment_no'] .' '. '(' . $stud['bundle_no'] . ')';
				echo '<p>'.$enrollment_no.'</p><br>';
            }
            echo '</td></tr>';

            $j++;
            unset($enrollment_no);
        }
    } else {
        echo "<tr><td colspan='6'>No data found.</td></tr>";
    }
    echo '</tbody></table><br>';
}
?>
</body>
</html>
