<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/jPages.css">
<script src="<?= base_url('assets/javascripts') ?>/jPages.js"></script>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" type="text/css" />
<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid black;
        text-align: left;
        padding: 2px;
        font-size: 10px;
        width:15%;
    }

    .sub_details {
        padding: 15px;
        border-radius: 8px;
        /* Rounded corners for sub_detailss */
        border: none;
        text-align: center;
    }


    hr {
        border-color: #0083a1 !important;
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
<div class="panel-body ">

    <div class="table-info">
        <?php //if(in_array("View", $my_privileges)) { ?>

        <?php
        if ($course_id == 3 || $course_id == 9) {

        } else {
            ?>
            <table id="timetableTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Day / Time</th>
                                            <pre>
                                            <?php foreach ($slot_time as $slot):

                                                // if suppose there is slot 10:00 to 12:00 and two more slot 10:00 to 11:00 and 11:00 to 12:00 then show those two slots remove 10:00 to 12:00 slot
                                                //  print_r($slot);
                                                //   if($slot['from_time'])
                                            
                                                if (isOverlappedSlot($slot, $slot_time)) {

                                                    ?>
                                                        <th><?= htmlspecialchars($slot['from_time'] . ' ' . $slot['slot_am_pm']) ?><br>to<br><?= htmlspecialchars($slot['to_time']) ?>
                                                        </th>
                                                <?php }endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($wday as $dkey => $day): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($day) ?></td>

                                                        <?php foreach ($slot_time as $slot):
                                                            //  if($slot['subject_type'] !='PR'){
                                                            // echo '<pre>';     

                                                            if (isOverlappedSlot($slot, $slot_time)) {
                                                                //   echo '<pre>';
                                                                //   print_r($slot);
                                                                ?>
                                                                <?php // htmlspecialchars($slot['from_time'] . ' ' . $slot['slot_am_pm']) .'to'. htmlspecialchars($slot['to_time']) ?>

                                                                <td>
                                                                    <!-- <div class="sub_details"> -->

                                                                        <?php
                                                                        $found = false;
                                                                        $pr_count = 1;

                                                                        foreach ($ttsub[$dkey] as $daySessions) {

                                                                            // print_r($daySessions);
                                                                            $i = 0;
                                                                            foreach ($daySessions as $session) {

                                                                                if ($session['subject_type'] == "TH") {

                                                                                    if ($session['lect_slot_id'] == $slot['lect_slot_id']) {
                                                                                        ?>

                                                                                                        <p class="sub-name" title="<?= $session['subject_name'] ?>"
                                                                                                            style="cursor:pointer">
                                                                                                            <?php
                                                                                                            if ($session['subject_code'] == 'OFF') {
                                                                                                                echo "";
                                                                                                            } else if ($session['subject_code'] == 'Library') {
                                                                                                                echo "Library";
                                                                                                            } else if ($session['subject_code'] == 'Tutorial') {
                                                                                                                echo "Tutorial";
                                                                                                            } else if ($session['subject_code'] == 'Tutor') {
                                                                                                                echo "Tutor";
                                                                                                            } else if ($session['subject_code'] == 'IS') {
                                                                                                                echo "Internet Slot";
                                                                                                            } else if ($session['subject_code'] == 'RC') {
                                                                                                                echo "Remedial Class";
                                                                                                            } else if ($session['subject_code'] == 'EL') {
                                                                                                                echo "Experiential Learning";
                                                                                                            } else if ($session['subject_code'] == 'SPS') {
                                                                                                                echo "Swayam Prabha Session";
                                                                                                            } else if ($session['subject_code'] == 'ST') {
                                                                                                                echo "Spoken Tutorial";
                                                                                                            } else if ($session['subject_code'] == 'FAM') {
                                                                                                                echo "Faculty Advisor Meet";
                                                                                                            } else { ?>
                                                                                                            <?= $session['sub_code'] ?> ( <?= $session['subject_name'] ?>)<br>
                                                                                                            <b> Stream: </b> <?= $session['stream_name'] ?><br>
                                                                                                            <b> Semester: </b> <?= $session['semester'] ?><br>
                                                                                                            <b> Division: </b> <?= $session['division'] ?>

                                                                                                            <?php
                                                                                                            $found = true;
                                                                                                            }

                                                                                                            ?>
                                                                                                        </p>
                                                                                               
                                                                                                        <hr>
                                                                                                      
                                                                                                        <?php
                                                                                        }
                                                                                    }
                                                                                                //  }
                                                                                                // if ($found)
                                                                                                //    break;
                                                                                
                                                                                            ?>


                                                                                <?php
                                                                                        
                                                                                if ($session['subject_type'] == "PR") {

                                                                                    $timediff = round((strtotime($session['to_time']) - strtotime($session['from_time'])) / 3600, 0);
                                                                                    $next_slot = $daySessions[$i + 1]['lect_slot_id'];
                                                                                        //  echo '<pre>';
                                                                                        //   print_r($slot);
                                                                                        //  print_r($session);exit;
                                                                                    if ($session['lect_slot_id'] != $next_slot) {
                                                                                        if ($timediff > 1) {
                                                                                            $colspan = $timediff;
                                                                                        } else {
                                                                                            $colspan = '';
                                                                                        }
                                                                                        //  echo "Session Time: " . $session['from_time'] . " & Slot Time: " . $slot['from_time'] . "<br>";

                                                                                        if ($session['from_time'] == $slot['from_time'] || $session['to_time'] == $slot['to_time']) { 
                                                                                        // echo '<pre>';
                                                                                        // print_r($slot);
                                                                                        // print_r($session);
                                                                                            ?>
                                                     
                                                                                        <?php  echo $session['sub_code'] ?> ( <?php  echo $session['subject_name'] ?> ) -
                                                                                        PRACTICAL<br>
                                                                                        <b> Stream: </b> <?php  echo $session['stream_name'] ?><br>
                                                                                        <b> Semester: </b> <?php  echo $session['semester'] ?><br>
                                                                                        <b> Division: </b>
                                                                                        <?php  echo $session['division'] ?>   <?php  echo $session['batch_no'] ?><br>
                                                                     
                                                                                    <hr>
                                                                                        <?php

                                                                                            $pr_count++;
                                                                                            $pr_slot = $session['lect_slot_id'];
                                                                                        }
                                                                                    }
                                                                                }
                                                                                    
                                                                                unset($timediff);
                                                                                unset($colspan);

                                                                                //  if ($found)
                                                                                //  break;
                                                                            }
                                                                        }
                                                                        if (!$found) {
                                                                            echo " ";
                                                                        }  ?>
                                                                    <!-- </div> -->
                                                                </td>

                                                                <?php 
                                                            }

                                                            ?>

                                                        <?php endforeach; // exit;?>

                                                </tr>
                                        <?php endforeach; ?>

                                    </tbody>

                                </table>
        <?php } ?>
    </div>
</div>