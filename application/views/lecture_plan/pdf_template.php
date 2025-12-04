<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background: #f2f2f2; }
        .header-table td { border: none; padding: 3px; text-align: left; vertical-align: top; }
        .header-logo { width: 100px; }
    </style>
</head>
<body>

<table class="header-table">
    <tr>
        <td class="header-logo">
            <!-- Optional logo -->
           <?php if($campus_id==1){?>
           <img src="https://www.sandipuniversity.edu.in/images/logo-dark.png" alt="Sandip university" class="desktop-logo lg-logo ptrans">
			<?php }elseif($campus_id==2){?>
           <img src="https://www.sandipuniversity.edu.in/images/logo-dark.png" alt="Sandip university" class="desktop-logo lg-logo ptrans">
			<?php }elseif($campus_id==3){?>
           <img src="https://sitrc.sandipfoundation.org/wp-content/uploads/2023/09/SIPS.png" alt="Sandip university" class="desktop-logo lg-logo ptrans">
		   <?php }?>
        </td>
		<td>
        </td>
        <td>
            <h2>Lecture Plan</h2>
            <p><strong>Subject:</strong> <?= $subject->subject_name ?> (<?= $subject->subject_code ?>)</p>
            <p><strong>Faculty:</strong> <?= $faculty_name ?></p>
            <p>
                <strong>Stream:</strong> <?= $plans[0]->stream_name ?> &nbsp; 
                <strong>Semester:</strong> <?= $semester ?> &nbsp; 
                <strong>Division:</strong> <?= $division ?> &nbsp; 
                <strong>Batch:</strong> <?= $batch ?>
            </p>
        </td>
    </tr>
</table>

<table border="1" width="100%" cellspacing="0" cellpadding="4">
    <thead>
        <tr>
            
            <th>Topic</th>
            <th>Subtopic</th>
			<th>Planned Date</th>
            <th>Hours</th>
            <th>Minutes</th>
            <th>Mode</th>
            <th>CO</th>
            <!--th>LO</th-->
            <th>Methodology</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // 🔹 Group by topic
        $topicGrouped = [];
        foreach ($plans as $plan) {
            $key = $plan->topic_order . '. ' . $plan->topic_title;
            $topicGrouped[$key][] = $plan;
        }

        foreach ($topicGrouped as $topic => $rows):
            $rowspan = count($rows);
            $firstTopic = true;

            foreach ($rows as $plan): ?>
                <tr>
                    

                    <?php if ($firstTopic): ?>
                        <td rowspan="<?= $rowspan ?>" style="background-color:#f4f6f9;font-weight:bold;vertical-align:middle;">
                            <?= $topic ?>
                        </td>
                    <?php endif; ?>

                    <td><?= $plan->srno ?> <?= $plan->subtopic_title ?></td>
					<td><?= date('d-m-Y', strtotime($plan->planned_date)) ?></td>
                    <td><?= $plan->planned_duration_hours ?></td>
                    <td><?= $plan->planned_duration_minutes ?></td>
                    <td><?= $plan->lecture_mode ?></td>
                    <td><?= $plan->course_outcome ?></td>
                    <!-- <td><?= $plan->learning_outcome ?></td> -->
                    <td><?= $plan->teaching_methodology ?></td>
                    <td><?= $plan->remarks ?></td>
                </tr>
            <?php
            $firstTopic = false;
            endforeach;
        endforeach;
        ?>
    </tbody>
</table>

<br>
<table style="width: 100%; margin-top: 50px;">
    <tr>
        <td style="text-align: center;">
            ___________________________<br>
            Faculty Signature
        </td>
        <td style="text-align: center;">
            ___________________________<br>
            HOD Signature
        </td>
        <td style="text-align: center;">
            ___________________________<br>
            Dean Academic Signature
        </td>
    </tr>
</table>
</body>
</html>
