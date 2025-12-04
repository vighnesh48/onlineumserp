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

td, th {
  border: 1px solid black;
  text-align: left;
  padding: 8px;
  font-family:serif;

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

<div class="panel-body " style="border:1px solid;">

	<div class="table-info">
		<?php //if(in_array("View", $my_privileges)) { ?>

		<?php
		if ($course_id == 3 || $course_id == 9) {

		} else {
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center">
						<img src="https://erp.sandipuniversity.com/assets/images/su-logo.png" width="100" height="100"/>
						<p style="margin-top:0"><strong>Mahiravani, Trimbak Road, Nashik – 422 213,</strong><br>
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
    <span style="margin-left: 20px; color: blue;">Practical (PR): <?= $prLoad*2 ?></span>
</div>
					</td>
				</tr>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0" class="table" align="center">
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
		<?php } ?>
	</div>
</div>