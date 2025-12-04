<style>
    table { border-collapse: collapse; width: 100%; margin-bottom: 30px; font-family: Arial, sans-serif; }
    th, td { border: 1px solid #444; padding: 6px; text-align: center; vertical-align: top; font-size: 12px; }
    th { background: #f2f2f2; }
    td { min-width: 160px; }
    .lecture-block { padding: 4px; border-radius: 4px; color: #000; font-size: 12px; }
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center">
						<img src="https://erp.sandipuniversity.com/assets/images/su-logo.png" width="100" height="100"/>
						<p style="margin-top:0"><strong>Mahiravani, Trimbak Road, Nashik – 422 213,</strong><br></td>
</tr>
<tr>
<td class="sub-header">
<?php //echo $courseId;exit;
if(!empty($courseId)){ ?>
    <b>Academic Year:</b> <?= $academicyear ?? '' ?> &nbsp;&nbsp; | 
    <b>Course:</b> <?= $courseName ?? '' ?> &nbsp;&nbsp; | 
    <b>Stream:</b> <?= $streamName ?? '' ?> &nbsp;&nbsp; | 
    <b>Semester:</b> <?= $semesterNo ?? '' ?> &nbsp;&nbsp; | 
    <b>Division:</b> <?= $division ?? '' ?>
<?php }else{?>
<b>Academic Year:</b> <?= $academicyear ?? '' ?> &nbsp;&nbsp; | 
    <b>Faculty Name:</b> <?= $faculty_id ?? '' ?><?= $faculty_name ?? '' ?> &nbsp;&nbsp;  
<?php }?>
</td>
</tr>
</table>
<table>
    <thead>
	
        <tr>
            <th>Time / Day</th>
            <?php 
            $days = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
            foreach($days as $d): ?>
                <th><?= $d ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($hours as $i => $slot): ?>
            <tr>
                <td><b><?= date("h:i A", strtotime($slot['start'])) ?> - <?= date("h:i A", strtotime($slot['end'])) ?></b></td>
                <?php foreach($days as $day): ?>
                    <td>
                        <?php 
                        if(isset($timetable[$day][$i]) && !empty($timetable[$day][$i])):
                            $lectures = $timetable[$day][$i];
                            $count = count($lectures);
                            foreach($lectures as $idx => $lec):

                                // Set color based on lecture type
                                if($lec['subject_type'] == 'TH'){
                                    $color = '#BBDEFB'; // Blue for Theory
                                } else {
                                    $color = '#C8E6C9'; // Green for Practical/Project/etc
                                }
                        ?>
                        <div class="lecture-block" style="background-color:<?= $color ?>; margin-bottom:<?= $count>1?'2px':'0'?>;">
                            <b><?= $lec['subcode'] ?></b>-<b><?= $lec['subject_code'] ?></b> (<?= $lec['subject_type'] ?>)<br>
                            Faculty: <?= $lec['faculty_code'].'-'.$lec['faculty_name'] ?><br>
                            Division: <?= $lec['division'].'-'.$lec['batch_no'] ?><br>
							Program/sem: <?= $lec['stream_name'].'-'.$lec['semester'] ?><br>
                            Time: <?= date("h:i A", strtotime($lec['from_time'])).'-'.date("h:i A", strtotime($lec['to_time'])) ?><br>
                            Room: <?= $lec['buliding_name'] ?> <?= $lec['floor_no'].'-'.$lec['room_no'] ?>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
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
