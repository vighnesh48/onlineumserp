<style>
    .sub_details {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 5px;
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


    #timetableTable {
        border-collapse: collapse;
        width: 100%;
    }

    #timetableTable thead th {
        position: sticky;
        top: 0; /* Sticks the header at the top */
        z-index: 10; /* Ensures the header stays above other elements */
        background-color:rgb(75, 177, 208); /* Set a background color to avoid transparency */
        color: #000; /* Header text color */
        text-align: center;
    }

    .table-responsive {
        max-height: 500px; /* Set max height for the container to enable scrolling */
        overflow-y: auto;
        margin: 20px 0;
    }

</style>

<?php
$role_id = $this->session->userdata('role_id');

function isOverlappedSlot($currentSlot, $slot_time)
{
    $currentStart = strtotime($currentSlot['from_time']);
    $currentEnd = strtotime($currentSlot['to_time']);

    foreach ($slot_time as $slot) {
        // Skip checking the slot against itself
        if ($currentSlot['lect_slot_id'] === $slot['lect_slot_id']) {
            continue;
        }

        $slotStart = strtotime($slot['from_time']);
        $slotEnd = strtotime($slot['to_time']);

        // Check if the current slot's start and end times fall within another slot's time range
        if ($currentStart >= $slotStart && $currentEnd <= $slotEnd) {
            return true; // It is overlapped
        }
    }
    return false; // It is not overlapped
}

?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">View Time table</a></li>

    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i
                    class="fa fa-calendar page-header-icon text-danger"></i>&nbsp;&nbsp;Faculty Lecture Time Table</h1>
            <div class="col-xs-12 col-sm-8">
            </div>
        </div>
        <div class="row ">
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row ">
                            <div class="col-sm-2"><a href="<?php echo base_url() ?>timetable/downloadFacultypdf"><i
                                        class="fa-fa-pdf">Download TImeTable</i></a></div>
                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="">
                            <?php //if(in_array("View", $my_privileges)) { ?>

                           <div class="table-responsive">
                                    <table id="timetableTable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Day / Time</th>
                                                <?php foreach ($slot_time as $slot): ?>
                                                    <th><?= htmlspecialchars($slot['from_time'] . ' ' . $slot['slot_am_pm']) ?><br>to<br><?= htmlspecialchars($slot['to_time']) ?>
                                                    </th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($wday as $dkey => $day): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($day) ?></td>
                                                    <?php foreach ($slot_time as $slot): ?>
                                                        <?php
                                                        $found = false;
                                                        $pr_count = 1;
                                                        ob_start(); // Start output buffering
                                                        ?>
                                                        <div class="sub_details">
                                                            <?php
                                                            foreach ($ttsub[$dkey] as $daySessions) {
                                                                foreach ($daySessions as $session) {
                                                                    if ($session['subject_type'] == "TH" && $session['lect_slot_id'] === $slot['lect_slot_id']) {
                                                                        ?>
                                                                        <p class="sub-name" title="<?= $session['subject_name'] ?>"
                                                                            style="cursor:pointer">
                                                                            <?php
                                                                            $specialCodes = [
                                                                                'OFF' => '',
                                                                                'Library' => 'Library',
                                                                                'Tutorial' => 'Tutorial',
                                                                                'Tutor' => 'Tutor',
                                                                                'IS' => 'Internet Slot',
                                                                                'RC' => 'Remedial Class',
                                                                                'EL' => 'Experiential Learning',
                                                                                'SPS' => 'Swayam Prabha Session',
                                                                                'ST' => 'Spoken Tutorial',
                                                                                'FAM' => 'Faculty Advisor Meet'
                                                                            ];
                                                                            echo isset($specialCodes[$session['subject_code']])
                                                                                ? $specialCodes[$session['subject_code']]
                                                                                : "{$session['sub_code']} ({$session['subject_name']}) - TH <br>({$session['stream_short_name']} - {$session['semester']} , {$session['division']})<br> 
                                           <b>Faculty:</b> {$session['fname']} {$session['lname']}<br><hr>";
                                                                            ?>
                                                                        </p>
                                                                        <?php
                                                                        $found = true;
                                                                    }

                                                                    if ($session['subject_type'] == "PR" && $session['lect_slot_id'] === $slot['lect_slot_id']) {
                                                                        ?>
                                                                        <?= $session['sub_code'] ?> ( <?= $session['subject_name'] ?> ) - PR
                                                                        <br>
                                                                        (<?= $session['stream_short_name'] ?>- <?= $session['semester'] ?>,
                                                                        <?= $session['division'] ?>)
                                                                        <b>Faculty:</b> <?= $session['fname'] ?>                         <?= $session['lname'] ?><br>
                                                                        <hr>
                                                                        <?php
                                                                        $found = true;
                                                                    }
                                                                }
                                                                if ($found)
                                                                    break;
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php
                                                        $output = ob_get_clean(); // Get buffered content
                                            
                                                        // If found, display the content; otherwise, display "-"
                                                        ?>
                                                        <td><?= $found ? $output : "-" ?></td>
                                                    <?php endforeach; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>


                                    </table>
                                </div>
</div>
                    </div>
                </div>
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
</form>