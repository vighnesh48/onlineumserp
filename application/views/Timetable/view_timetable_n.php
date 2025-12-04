<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/jPages.css">
<script src="<?= base_url('assets/javascripts') ?>/jPages.js"></script>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<style>
    .sub_details {
        padding: 15px;
        border-radius: 8px;
        /* Rounded corners for sub_detailss */
        border: none;
        text-align: left;
        background-color: #f0f0f0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Subtle shadow for 3D effect */
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .sub_details:hover {
        transform: translateY(-3px);
        /* Slight lift effect on hover */
        box-shadow: 0 6px 12px rgb(55 117 255 / 62%);
    }

    .sub_details:not(:empty) {
        background-color: #4bb1d052;
        /* Bootstrap primary color for occupied sub_detailss */
        color: black;
    }

    hr {
        border-color: #0083a1 !important;
    }
	    th, td {
        border: 1px solid #e2e2e2;
        text-align: center;
        vertical-align: top;
        padding: 8px;
    }
	table {
    width: 100%;
    border-collapse: collapse;
    font-size: 15px;
    background: #fff;
}
th {
    background-color: #3969ad;
    font-weight: bold;
    color: #fff;
    font-size: 16px;
}
    
.bulding {
    background-color: #f2dbdb;
    padding: 5px;
    border-radius: 20px;
    margin-top: 10px;
	border: #d9b8b8 solid 1px;
}
	
	
	
	
	
    .lecture-pr {
        background-color:#d3e0f1;
		 padding: 10px;
    border-radius: 10px;
	border: #98bbe9 solid 1px;
    }
    .lecture-other {
        background-color:#f2dbdb ;
    }
	.lecture-th {
    background-color: #cdf3cd;
    padding: 10px;
    border-radius: 10px;
	border: #93e593 solid 1px;
}
</style>
<?php
$role_id = $this->session->userdata('role_id');
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">View Time table</a></li>

    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i
                    class="fa fa-calendar page-header-icon text-danger"></i>&nbsp;&nbsp;Lecture Time Table 12</h1>
            <div class="col-xs-12 col-sm-8">
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <?php
                        if ($role_id == '4' || $role_id == '9') {

                            echo "<b>Stream : " . $course_short_name . ", Semester : " . $semester . ", Division :  " . $division . '' . $batch . " </b>";
                        } else {

                            if ($role_id != '4' && $role_id != '9') {
                                ?>
                                <div class="row">
                                    <form name="searchTT" method="POST" action="<?= base_url() ?>timetable/viewTtable">
                                        <div class="form-group">
                                            <div class="col-sm-2">
                                                <select name="academic_year" id="academic_year" class="form-control" required>
                                                    <option value="">Select Academic Year </option>
                                                    <?php
                                                    foreach ($academic_year as $yr) {
                                                        if ($yr['academic_year'] . '~' . $yr['academic_session'] == $academicyear) {
                                                            $sel = "selected";
                                                        } else {
                                                            $sel = '';
                                                        }
                                                        echo '<option value="' . $yr['academic_year'] . '~' . $yr['academic_session'] . '"' . $sel . '>' . $yr['academic_year'] . '(' . $yr['academic_session'] . ')</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <?php
                                            if ($role_id == 20 || $role_id == 44) {
                                                ?>
                                                <div class="col-sm-2">
                                                    <select name="course_id" id="course_id" class="form-control" required>
                                                        <option value="">Select Course</option>

                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <select name="stream_id" class="form-control" id="stream_id" required>
                                                        <option value="">Select Stream </option>

                                                    </select>
                                                </div>
                                                <?php
                                                if ($role_id == 3) {
                                                    ?>
                                                    <div class="col-sm-2">
                                                        <select id="semester" name="semester" class="form-control">
                                                            <option value="">Semester</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <select id="division" name="division" class="form-control">
                                                            <option value="">Division</option>
                                                        </select>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="col-sm-2">
                                                        <select id="semester" name="semester" class="form-control">
                                                            <option value="">Semester</option>
                                                            <?php
                                                            $semesterNo = $_REQUEST['semester'];
                                                            for ($i = 1; $i < 9; $i++) {
                                                                if ($i == $semesterNo) {
                                                                    $sel3 = "selected";
                                                                } else {
                                                                    $sel3 = '';
                                                                }
                                                                ?>
                                                                <option value="<?= $i ?>" <?= $sel3 ?>><?= $i ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <select id="division" name="division" class="form-control">
                                                            <option value="">Division</option>
                                                            <?php
                                                            $div = array('A', 'B', 'C', 'D', 'E', 'F');

                                                            for ($i = 0; $i < count($div); $i++) {
                                                                if ($div[$i] == $_REQUEST['division']) {
                                                                    $sel4 = "selected";
                                                                } else {
                                                                    $sel4 = '';
                                                                }
                                                                ?>
                                                                <option value="<?= $div[$i] ?>" <?= $sel4 ?>><?= $div[$i] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                <?php }
                                            } ?>
                                            <?php
                                            if ($role_id != '' && in_array($role_id, [6, 53, 58])) {
                                                ?>
                                                <div class="col-sm-2">
                                                    <select name="faculty_id" id="faculty_id" class="form-control " required>
                                                        <option value="">Select Faculty</option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                            <div class="col-sm-2"><input type="submit" class="btn btn-primary" value="Search">
                                            </div>

                                        </div>
                                        <div class="col-sm-2"><input type="button" class="btn btn-primary" value="Download Pdf"
                                                id="getpdf"></div>
                                    </form>
									<?php
$uniqueTH = [];
$uniquePR = [];

foreach ($ttsub as $dayKey => $daySessions) {
    foreach ($daySessions as $slotSessions) {
        foreach ($slotSessions as $session) {
            $key = $dayKey . '_' . $session['lect_slot_id'] . '_' . $session['subject_type'];
            if ($session['subject_type'] === 'TH') {
                $uniqueTH[$key] = true;
            } elseif ($session['subject_type'] === 'PR') {
                $uniquePR[$key] = true;
            }
        }
    }
}

$thLoad = count($uniqueTH);
$prLoad = count($uniquePR);
?>
<div style="margin-bottom: 20px;">
    <strong>Faculty Weekly Load:</strong>
    <span style="margin-left: 10px; color: green;">Theory (TH): <?= $thLoad ?></span>
    <span style="margin-left: 20px; color: blue;">Practical (PR): <?= $prLoad *2 ?></span>
</div>


                                </div>
                            <?php }
                        } ?>
                    </div>
                    <div class="panel-body">

                        <div class="table-info">
                            <?php //if(in_array("View", $my_privileges)) { ?>

                            <?php
                            if ($course_id == 3 || $course_id == 9) {

                            } else {
                                ?>
											
                                <div class="table-responsive">
    <table id="timetableTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Day / Time</th>
                <?php foreach ($slot_time as $slot): ?>
                    <th><?= htmlspecialchars($slot['from_time']) ?>-<?= htmlspecialchars($slot['to_time']) ?> <?=$slot['slot_am_pm']?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wday as $dkey => $day): ?>
                <tr>
                    <td><?= htmlspecialchars($day) ?></td>
                    <?php foreach ($slot_time as $slot): ?>
                        <?php
                        $outputTH = '';
                        $outputPR = '';
                        if (isset($ttsub[$dkey])) {
                            foreach ($ttsub[$dkey] as $daySessions) {
                                foreach ($daySessions as $session) {
                                    if ($session['lect_slot_id'] === $slot['lect_slot_id']) {
                                        $subTitle = isset($specialCodes[$session['subject_code']])
                                            ? $specialCodes[$session['subject_code']]
                                            : "{$session['sub_code']} ({$session['subject_name']}) - {$session['subject_type']}<br>({$session['stream_short_name']} - {$session['semester']}, {$session['division']})<br><b>Faculty:</b> {$session['fname']} {$session['lname']}<br>";

                                        if ($session['subject_type'] === 'TH') {
                                            $outputTH .= "<div class='lecture-th'><p title='{$session['subject_name']}' style='cursor:pointer'>{$subTitle}</p></div><br>";
                                        } elseif ($session['subject_type'] === 'PR') {
                                            $outputPR .= "<div class='lecture-pr'><p title='{$session['subject_name']}' style='cursor:pointer'>{$subTitle}</p></div><br>";
                                        }
                                    }
                                }
                            }
                        }

                        $finalOutput = '';
                        if ($outputTH !== '') {
                            $finalOutput .= $outputTH;
                        }
                        if ($outputPR !== '') {
                            $finalOutput .= $outputPR;
                        }
                        ?>
                        <td><?= $finalOutput !== '' ? $finalOutput : '-' ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Commerce</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<form action="<?php echo base_url() ?>timetable/downloadpdf" id="exportpf" name="exportpf" method="post">
    <input type="hidden" name="academic_year" id="academic_yearpf" />
    <input type="hidden" name="course_id" id="course_idpf" />
    <input type="hidden" name="stream_id" id="stream_idpf" />
    <input type="hidden" name="semester" id="semesterpf" />
    <input type="hidden" name="division" id="divisionpf" />
    <input type="hidden" name="faculty_id" id="faculty_idpf" />
</form>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script>
    $('#search-table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0, ':visible']
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
            },

        ]
    });
</script>
<script>

    $(document).ready(function () {
        // Initialize Select2
        $('#faculty_id').select2({
            placeholder: "Select Faculty",
            allowClear: true
        });

        // Trigger AJAX when school or stream changes
        $('#academic_year').on('change', function () {

            var academic_year = $('#academic_year').val();

            var faculty_code = '<?= $faculty_id ?>';

            if (academic_year) {
                $.ajax({
                    url: "<?= base_url('timetable/fetchFaculty') ?>", // Call Controller Function
                    type: "POST",
                    data: {
                        academic_year: academic_year,
                    },
                    dataType: "json",
                    success: function (response) {
                        $('#faculty_id').empty().append('<option value="">Select Faculty</option>');
                        $.each(response, function (index, faculty) {
                            $('#faculty_id').append('<option value="' + faculty.faculty_code + '">' + faculty.faculty_code +'-'+faculty.faculty_name + '</option>');

                        });
                        // $('#faculty_id').trigger('change'); // Refresh Select2
                        $("#faculty_id option[value='" + faculty_code + "']").attr("selected", "selected");
                    }
                });
            } else {
                $('#faculty_id').empty().append('<option value="">Select Faculty</option>');
            }
        });

        $('#academic_year').trigger('change');

        $('#academic_year').on('change', function () {
            var academic_year = $(this).val();
            if (academic_year) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>timetable/load_ttcources',
                    data: { academic_year: academic_year },
                    success: function (html) {
                        //alert(html);
                        $('#course_id').html(html);
                    }
                });
            } else {
                $('#course_id').html('<option value="">Select academic year first</option>');
            }
        });
        $('#course_id').on('change', function () {
            var academic_year = $("#academic_year").val();
            var course_id = $(this).val();
            if (course_id) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>Timetable/load_tt_streams',
                    data: { course_id: course_id, academic_year: academic_year },
                    success: function (html) {
                        //alert(html);
                        $('#stream_id').html(html);
                    }
                });
            } else {
                $('#stream_id').html('<option value="">Select course first</option>');
            }
        });
        $('#stream_id').on('change', function () {
            var stream_id = $(this).val();
            var academic_year = $("#academic_year").val();
            if (stream_id) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>timetable/load_ttsemesters',
                    data: { stream_id: stream_id, academic_year: academic_year },
                    success: function (html) {
                        //alert(html);
                        $('#semester').html(html);
                    }
                });
            } else {
                $('#semester').html('<option value="">Select Stream first</option>');
            }
        });
        //
        var course_id = '<?= $courseId ?>';
        var academic_year = '<?= $academicyear ?>';
        if (academic_year) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>timetable/load_ttcources',
                data: { academic_year: academic_year },
                success: function (html) {
                    //alert(html);
                    $('#course_id').html(html);
                    $("#course_id option[value='" + course_id + "']").attr("selected", "selected");
                }
            });
        }

        if (course_id) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>Timetable/load_tt_streams',
                data: { course_id: course_id, academic_year: academic_year },
                'success': function (data) { //probably this request will return anything, it'll be put in var "data"
                    var container = $('#stream_id'); //jquery selector (get element by id)
                    if (data) {
                        var stream_id = '<?= $streamId ?>';
                        container.html(data);
                        $("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
                    }
                }
            });
        }
        var stream_id = '<?= $streamId ?>';

        if (stream_id) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>timetable/load_ttsemesters',
                data: { stream_id: stream_id, academic_year: academic_year },
                success: function (html) {
                    var semester = '<?= $semesterNo ?>';
                    $('#semester').html(html);
                    $("#semester option[value='" + semester + "']").attr("selected", "selected");
                }
            });
        } else {
            $('#semester').html('<option value="">Select Stream first</option>');
        }


        $('#semester').on('change', function () {
            var semester = $(this).val();
            var stream_id = $("#stream_id").val();
            var academic_year = $("#academic_year").val();
            if (semester) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>timetable/load_ttdivision',
                    data: { stream_id: stream_id, academic_year: academic_year, stream_id: stream_id, semester: semester },
                    success: function (html) {

                        $('#division').html(html);

                    }
                });
            } else {
                $('#division').html('<option value="">Select Stream first</option>');
            }
        });

        var semester = '<?= $semesterNo ?>';
        if (semester) {
            var academic_year = '<?= $academicyear ?>';
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>timetable/load_ttdivision',
                data: { stream_id: stream_id, academic_year: academic_year, stream_id: stream_id, semester: semester },
                success: function (html) {
                    var division = '<?= $division ?>';
                    $('#division').html(html);
                    $("#division option[value='" + division + "']").attr("selected", "selected");
                }
            });
        } else {
            $('#division').html('<option value="">Select Stream first</option>');
        }

    });
    $("div.holder").jPages
        ({
            containerID: "itemContainer"
        });
    $("#search_me").select2({
        placeholder: "Enter Time table name",
        allowClear: true
    });
    $("#search_me").on('change', function () {
        var search_val = $(this).val();
        var url = "<?= base_url() . strtolower($currentModule) . '/search/' ?>";
        var data = { title: search_val };
        var type = "";
        var type_name = "";
        $.ajax
            ({
                type: "POST",
                url: url,
                data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function (data) {
                    var array = JSON.parse(data);
                    var str = "";
                    for (i = 0; i < array.slot.length; i++) {
                        str += '<tr style="display: table-row; opacity: 1;">';
                        str += '<td>' + (i + 1) + '</td>';
                        str += '<td>' + array.slot[i].campus_name + '</td>';
                        str += '<td>' + array.slot[i].college_code + '</td>';
                        str += '<td>' + array.slot[i].college_name + '</td>';
                        str += '<td>' + array.slot[i].college_state + '</td>';
                        str += '<td>' + array.slot[i].college_city + '</td>';
                        str += '<td>' + array.slot[i].college_pincode + '</td>';
                        str += '<td>' + array.slot[i].college_address + '</td>';
                        str += '<td>';
                        str += '<a href="<?= base_url(strtolower($currentModule)) ?>/edit/' + array.slot[i].college_id + '"><i class="fa fa-edit"></i></a>';
                        str += '<a href="<?= base_url(strtolower($currentModule)) ?>/disable/' + array.slot[i].college_id + '"><i title="Disable" class="fa fa-ban"></i></a>';
                        str += '</td>';
                        str += '</tr>';
                        $("#itemContainer").html(str);
                    }
                },
                error: function (data) {
                    alert("Page Or Folder Not Created..!!");
                }
            });
    });
</script>
<script>

    $("#getpdf").click(function () {

        $("#academic_yearpf").val($("#academic_year").val());
        $("#course_idpf").val($("#course_id").val());
        $("#stream_idpf").val($("#stream_id").val());
        $("#semesterpf").val($("#semester").val());
        $("#divisionpf").val($("#division").val());
        $("#faculty_idpf").val($("#faculty_id").val());

        $("#exportpf").trigger("submit");

    });
</script>