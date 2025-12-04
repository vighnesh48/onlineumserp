<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?=site_url()?>assets/javascripts/jspdf/jspdf.js" type="text/javascript"></script>

<style>
    table.tabsal {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
        text-align: center; /* Center align all text horizontally */
    }

    table.tabsal th,
    table.tabsal td {
        border: 1px solid #ccc;
        padding: 6px 8px;
        text-align: center; /* Center horizontally */
        vertical-align: middle; /* Center vertically */
    }

    table.tabsal th {
        background-color: #007BFF;
        color: white;
        font-weight: bold;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    table.tabsal tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    table.tabsal tbody tr:hover {
        background-color: #eef5ff;
    }

    table.tabsal td[rowspan] {
        background-color: #f0f0f0;
        font-weight: 500;
    }

    .status-absent {
        background-color: #ffdddd !important;
        color: #d00000;
        font-weight: bold;
    }

    .no-approval {
        background-color: #ff4d4d !important;
        color: white;
        font-weight: bold;
    }
</style>


<script>
  $(document).ready(function() {+
        $('.groupOfTexbox').keypress(function (event) {
            return isNumber(event, this)
        });
    });
	function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57) && (charCode != 8))
            return false;

        return true;
    }    
</script>
<?php if ($this->session->flashdata('auto_submit') === 'yes'): ?>
<script>
    window.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('autoViewForm');
        console.log('Found form:', form);
        if (form && typeof form.submit === 'function') {
            setTimeout(() => form.submit(), 300);
        } else {
            console.error("Form not found or not valid.");
        }
    });
</script>
<?php endif; ?>




<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#">Visiting Faculty Salary Details </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Visiting Faculty Salary Details </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php elseif ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
<?php endif; ?>
        <div class="row ">
            <div class="col-sm-12">
               
                        <div class="table-info">
                               <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                                  
                                                               
                             <div id="dashboard-recent" class="panel-warning">   
                               
									 
									 <div class="panel panel-warning">
              <div class="panel-heading">               <div class="row">
						<div class="col-md-6 text-left">
						For <strong><?php echo $month_name." ".$year_name; ?>
														</strong>
						</div>
						<div class="col-md-6 text-left">

	<label class="col-md-4">Select Month And Year</label>
	<form id="autoViewForm" method="POST" action="<?= base_url($currentModule . '/visiting_staff_salary_report') ?>">
    <input type="text" name="attend_date" id="ym-datepicker"
           value="<?= htmlspecialchars($mon ?? $this->session->flashdata('attend_date') ?? date('Y-m')) ?>" required />
    <input type="submit" value="View" class="btn btn-primary" />
    </form>	
         </div>
              </div>								
                  </div>
						
					
<?php

$daysInMonth = $totalDays;
$facultyData = [];

foreach ($lecture_det as $record) {
    $facultyCode = $record['emp_id'];
    $subjectCode = $record['subject_code'];
    $subjectName = $record['subject_name'];
    $subject_id = $record['subject_id'];
    $ta_tot_days = $record['ta_tot_days'];
    $attendanceDate = (int)date('d', strtotime($record['attendance_date']));
    $status = $record['present_status'];
    $hours = $record['no_of_hours'];
    $academic_year = $record['academic_year'];
    $academic_session = $record['academic_session'];
    $totalApprovalLectures = $record['total_approval_lectures'] ?? 0;
    //$subjectComponent = $record['subject_component']; // TH or PR
	$subjectComponent = !empty($record['subject_component']) ? $record['subject_component'] : $record['alt_subject_component'];

    //$facultySubjectKey = $facultyCode . '-' . $subjectCode;
	$facultySubjectKey = $facultyCode . '-' . $subjectCode . '-' . $record['stream_name'] . '-' . $record['division'] . '-' . $record['batch'] . '-' . $record['semester'];

    if (!isset($facultyData[$facultyCode])) {
        $facultyData[$facultyCode] = [
            'emp_id' => $facultyCode,
            'ta_tot_days' => $ta_tot_days,
            'name' => "{$record['fname']} {$record['mname']} {$record['lname']}",
            'school' => $record['college_code'],
            'total_payable' => 0,
            'remarks' => 'Per Hrs.',
            'subjects' => [],
            'total_approval_lectures' => $totalApprovalLectures,
            'tot_th_count' => 0,
            'tot_pr_count' => 0,
            'ta_days_set' => []
        ];
    }

    if (!isset($facultyData[$facultyCode]['subjects'][$facultySubjectKey])) {
        $facultyData[$facultyCode]['subjects'][$facultySubjectKey] = [
            'programme' => $record['stream_name'] ?: 'N/A',
            'course' => $subjectName,
            'sub_id' => $subject_id,
            'academic_year' => $academic_year,
            'academic_session' => $academic_session,
            'semester' => $record['semester'],
            'attendance' => array_fill(1, $daysInMonth, 0),
            'status' => array_fill(1, $daysInMonth, ''),
            'total_hours' => 0,
            'approval_lectures' => $totalApprovalLectures,
            'subject_component' => $subjectComponent,
            'th_count' => 0, // subject-wise TH
            'pr_count' => 0  // subject-wise PR
        ];
    }

    $facultyData[$facultyCode]['subjects'][$facultySubjectKey]['attendance'][$attendanceDate] += $hours;
    $facultyData[$facultyCode]['subjects'][$facultySubjectKey]['status'][$attendanceDate] = $status;

    /* if ($status === "Present" && $totalApprovalLectures > 0) {
        $facultyData[$facultyCode]['subjects'][$facultySubjectKey]['total_hours'] += $hours;
        $facultyData[$facultyCode]['total_payable'] += $hours;
        $facultyData[$facultyCode]['ta_days_set'][$attendanceDate] = true;

        // Count per subject
        if ($subjectComponent === 'TH' ) {
            $facultyData[$facultyCode]['subjects'][$facultySubjectKey]['th_count']++;
            $facultyData[$facultyCode]['tot_th_count']++;
        } elseif ($subjectComponent === 'PR' ) {
            $facultyData[$facultyCode]['subjects'][$facultySubjectKey]['pr_count']++;
            $facultyData[$facultyCode]['tot_pr_count']++;
        }
    } */
	
	
	
	    if ($status === "Present" && $totalApprovalLectures > 0) {
        // Ensure $hours is numeric (avoid adding empty/NULL strings)
        $hoursNum = is_numeric($hours) ? (float)$hours : 0.0;
        if ($hoursNum > 0) {
            $facultyData[$facultyCode]['subjects'][$facultySubjectKey]['total_hours'] += $hoursNum;
            $facultyData[$facultyCode]['total_payable'] += $hoursNum;
            $facultyData[$facultyCode]['ta_days_set'][$attendanceDate] = true;

            // Normalize subject component value
            $comp = strtoupper(trim((string)$subjectComponent));

            // Add hours to TH/PR counters (so 2 hours => +2)
            if ($comp === 'TH') {
                $facultyData[$facultyCode]['subjects'][$facultySubjectKey]['th_count'] += $hoursNum;
                $facultyData[$facultyCode]['tot_th_count'] += $hoursNum;
            } elseif ($comp === 'PR') {
                $facultyData[$facultyCode]['subjects'][$facultySubjectKey]['pr_count'] += $hoursNum;
                $facultyData[$facultyCode]['tot_pr_count'] += $hoursNum;
            }
        }
    }
}

// Final TA Day Count
foreach ($facultyData as $empId => &$data) {
    $data['ta_days_count'] = count($data['ta_days_set']);
    unset($data['ta_days_set']);
}

?>
						
                                <div class="panel-body" style="height:700px;overflow-y:scroll;">
								  <div class="form-group" >

                  <button class="btn btn-success" onclick="exportWithBorders()">Export to Excel</button>
								  <form id="form" name="form" action="<?=base_url($currentModule.'/add_visiting_monthly_lecturewise_salary_details')?>" method="POST" >
								 <input type="hidden" name="for_month_year" value="<?=$mon?>">

								  <table cellpadding="0" cellspacing="0" style="font-size:12px;border:1px solid;width:100%;" id='eduDetTable1' class="table tabsal" border="1">
										
									<thead>
        <tr>
            <th rowspan="2">Sr. No.</th>
            <th rowspan="2">Employee Code</th>
            <th rowspan="2">Name of Visiting Faculty</th>
            <th rowspan="2">School</th>
            <th rowspan="2">Name of Programme</th>
            <th rowspan="2">Name of Course</th>
            <th rowspan="2">Semester</th>
            <th colspan="<?=$daysInMonth?>" style="text-align: center;">Attendance for <?php echo $month_name." ".$year_name; ?></th>
            <th rowspan="2">Total Hours</th>
            <th rowspan="2">TH Count</th>
            <th rowspan="2">PR Count</th>
			<th rowspan="2">Total Payable Hrs/Lect</th>
			<!--th rowspan="2">Total TH Lec</th>
            <th rowspan="2">Total PR Lec</th-->
            <th rowspan="2">Applicable TA Days</th>
            <th rowspan="2">Total Approval TA Days</th>
            <th rowspan="2">Total Approval Hrs/Lect</th>
            <!--th rowspan="2">Remaining Hrs/Lect</th-->
            <th rowspan="2">Remarks</th>
        </tr>
        <tr>
            <?php for ($i = 1; $i <= $daysInMonth; $i++) : ?>
                <th><?= $i ?></th>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody>
<?php
//echo'<pre>';
//print_r($facultyData);exit;
$srNo = 1;
foreach ($facultyData as $faculty) {
    $rowspan = count($faculty['subjects']);
    $firstRow = true;

    foreach ($faculty['subjects'] as $subject) {
        $subjectRowStyle = ($subject['approval_lectures'] == 0) ? 'no-approval' : '';

        echo "<tr>";

        if ($firstRow) {
            echo "<td rowspan='{$rowspan}'>{$srNo}</td>";
            echo "<td rowspan='{$rowspan}'>{$faculty['emp_id']}</td>";
            echo "<td rowspan='{$rowspan}'>{$faculty['name']}</td>";
            echo "<td rowspan='{$rowspan}'>{$faculty['school']}</td>";
        }

        // Subject-wise inputs
        echo "<td>{$subject['programme']}</td>";
        echo "<td style='{$subjectRowStyle}'>{$subject['course']}</td>";
        echo "<td style='{$subjectRowStyle}'>{$subject['semester']}</td>";

        foreach ($subject['attendance'] as $day => $count) {
            $status = (isset($subject['status'][$day]) && $subject['status'][$day] === 'Absent') ? 'status-absent' : '';
            echo "<td class='{$status} {$subjectRowStyle}'>{$count}</td>"; 
        }

		// echo "<td>{$subject['th_count']}</td>";
       // echo "<td>{$subject['pr_count']}</td>";

        echo "<td style='{$subjectRowStyle}'>{$subject['total_hours']}</td>";
		echo "<td>{$subject['th_count']}</td>";
       echo "<td>{$subject['pr_count']}</td>";
       

        // Subject-wise hidden input fields for DB insert/update
        echo "<input type='hidden' name='emp_code[]' value='{$faculty['emp_id']}'>";
        echo "<input type='hidden' name='sub_id[]' value='{$subject['sub_id']}'>";
        echo "<input type='hidden' name='academic_session[]' value='{$subject['academic_session']}'>";
        echo "<input type='hidden' name='academic_year[]' value='{$subject['academic_year']}'>";
        echo "<input type='hidden' name='total_hours[]' value='{$subject['total_hours']}'>";
        echo "<input type='hidden' name='th_count[]' value='{$subject['th_count']}'>";
        echo "<input type='hidden' name='pr_count[]' value='{$subject['pr_count']}'>";

        if ($firstRow) {
            echo "<td rowspan='{$rowspan}'>{$faculty['total_payable']}</td><input type='hidden' name='total_payable[]' value='{$faculty['total_payable']}'>";
           /// echo "<td rowspan='{$rowspan}'>{$faculty['tot_th_count']}<input type='hidden' name='tot_th_count[]' value='{$faculty['tot_th_count']}'></td>";
           // echo "<td rowspan='{$rowspan}'>{$faculty['tot_pr_count']}<input type='hidden' name='tot_pr_count[]' value='{$faculty['tot_pr_count']}'></td>";
            echo "<td rowspan='{$rowspan}'>{$faculty['ta_days_count']}<input type='hidden' name='ta_days_count[]' value='{$faculty['ta_days_count']}'></td>";
            echo "<td rowspan='{$rowspan}'>{$faculty['ta_tot_days']}<input type='hidden' name='ta_tot_days[]' value='{$faculty['ta_tot_days']}'></td>";
            echo "<td rowspan='{$rowspan}'>{$faculty['total_approval_lectures']}<input type='hidden' name='total_approval_lectures[]' value='{$faculty['total_approval_lectures']}'></td>";
           /// echo "<td rowspan='{$rowspan}'></td>";
        }

        echo "<td>{$faculty['remarks']}</td>";
        echo "</tr>";

        $firstRow = false;
    }

    $srNo++;
}
?>

</tbody>

</table>
								  </div>
								  <br>

								   <div class="form-group">
												<div class="col-md-3"></div>

												<?php if ($ins == 1): ?>
													<!-- Save Button -->
													<div class="col-md-2">
														<form id="form_save" method="POST" action="<?= base_url($currentModule . '/visiting_staff_salary_report') ?>">
															<input type="hidden" name="sdate" value="<?= $mon ?>" />
															<button class="btn btn-primary form-control" type="submit">Save</button>
														</form>
													</div>

												<?php elseif ($ins == 2): ?>
													<!-- Update Button -->
													<div class="col-md-2">
														<form id="form_update" method="POST" action="<?= base_url($currentModule . '/visiting_staff_salary_report') ?>">
															<input type="hidden" name="sdate" value="<?= $mon ?>" />
															<button class="btn btn-warning form-control" type="submit">Update</button>
														</form>
													</div>

													<!-- Final Save Button -->
													<div class="col-md-2">
														<form id="formf" name="formf" onsubmit="return confirm('Are you sure you want to final save this month salary?');"
															  action="<?= base_url($currentModule . '/visiting_monthly_final_save') ?>" method="POST">
															<input type="hidden" name="sdate" value="<?= $mon ?>" />
															<input type="submit" class="btn btn-success form-control" name="finals" value="Final Save">
														</form>
													</div>

												<?php elseif ($ins == 3): ?>
													<!-- Disabled Buttons -->
													<div class="col-md-2">
														<button class="btn btn-secondary form-control" type="button" disabled>Finalized</button>
													</div>
												<?php endif; ?>
									   </div>
								</div>
							</div>
                      </div>                       
                </div>
            </div>    
        </div>
    </div>
</div>
<div id="loader" style="display:none;">Loading...</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#ym-datepicker').datepicker( {  autoclose: true,
    minViewMode: 1,
    format: 'yyyy-mm',
        onClose: function (dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }});
	var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
	$("#eduDetTable").on("click","input[name='addMore']", function(e){	
	//$("input[name='addMore']").on('click',function(){		
		//var content = $(this).parent().parent('tr').clone('true');
		$(this).parent().parent('tr').after(content);		
	});
	$("#eduDetTable").on("click","input[name='remove']", function(e){	
	//$("input[name='remove']").on('click',function(){
		var rowCount = $('#eduDetTable tbody tr').length;
		if(rowCount>1){
			$(this).parent().parent('tr').remove();
		}
	});	

});

</script>
<script>
function exportWithBorders() {
    const table = document.getElementById("eduDetTable1");
    const workbook = XLSX.utils.book_new();
    const worksheet = XLSX.utils.table_to_sheet(table, { raw: true });

    const range = XLSX.utils.decode_range(worksheet['!ref']);

    for (let R = range.s.r; R <= range.e.r; ++R) {
        for (let C = range.s.c; C <= range.e.c; ++C) {
            const cell_address = { c: C, r: R };
            const cell_ref = XLSX.utils.encode_cell(cell_address);

            if (!worksheet[cell_ref]) continue;

            if (!worksheet[cell_ref].s) worksheet[cell_ref].s = {};

            // Apply border to all cells
            worksheet[cell_ref].s.border = {
                top: { style: "thin", color: { auto: 1 } },
                right: { style: "thin", color: { auto: 1 } },
                bottom: { style: "thin", color: { auto: 1 } },
                left: { style: "thin", color: { auto: 1 } }
            };

            // Bold font for header row (row 0)
            if (R === 0) {
                worksheet[cell_ref].s.font = {
                    bold: true
                };
            }
        }
    }

    XLSX.utils.book_append_sheet(workbook, worksheet, "Report");
    XLSX.writeFile(workbook, "Visiting_Faculty_Lecture_Attendance_report.xlsx");
}
</script>










