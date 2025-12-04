<style>
   
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


<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">View Time table</a></li>
        
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-calendar page-header-icon text-danger"></i>&nbsp;&nbsp;Lecture Time Table</h1>
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
                      <?php echo "<b>Course : </b>".$filters['course_short_name'].", <b>Stream : </b>".$filters['stream_name'].", <b>Semester : </b>".$filters['semester'].", <b>Division :  </b>".$filters['division'].''.$filters['batch_no']." </b>"; ?>		
					<div class="row">

<?php if (isset($error)): ?>
    <p style="color:red"><?= $error ?></p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Day / Slot</th>
                <?php foreach ($slots as $slot): ?>
                    <th><?= $slot->from_time ?> - <?= $slot->to_time ?> <?= $slot->slot_am_pm ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            foreach ($days as $day):
            ?>
                <tr>
                    <td><strong><?= $day ?></strong></td>
                    <?php foreach ($slots as $slot): ?>
                        <td>
                            <?php
                            $lectures = $timetable[$day][$slot->lect_slot_id] ?? [];
                           foreach ($lectures as $lecture):
								$displayName = '';
								switch ($lecture->subject_code) {
									case 'OFF':
										$displayName = 'OFF';
										break;
									case 'Library':
										$displayName = 'Library';
										break;
									case 'Tutorial':
									case 'Tutor':
										$displayName = 'Tutorial';
										break;
									case 'IS':
										$displayName = 'Internet Slot';
										break;
									case 'RC':
										$displayName = 'Remedial Class';
										break;
									case 'EL':
										$displayName = 'Experiential Learning';
										break;
									case 'SPS':
										$displayName = 'Swayam Prabha Session';
										break;
									case 'ST':
										$displayName = 'Spoken Tutorial';
										break;
									case 'FAM':
										$displayName = 'Faculty Advisor Meet';
										break;
									default:
										$displayName = $lecture->sub_code . ' / ' . $lecture->subject_name. ' / (' . $lecture->subject_type.')';
										break;
								}
								$facultyFullName = trim("{$lecture->fname} {$lecture->mname} {$lecture->lname}");
								if ($displayName !== '') {
										$cssClass = 'lecture-other';
										if (strpos(strtolower($lecture->subject_type), 'th') !== false) {
											$cssClass = 'lecture-th';
										} elseif (strpos(strtolower($lecture->subject_type), 'pr') !== false) {
											$cssClass = 'lecture-pr';
										}

										echo "<div class='{$cssClass}'>";
										echo "<strong>{$displayName}</strong><br>";
										echo "<strong>Div:</strong> {$lecture->division} | Batch: {$lecture->batch_no}<br>";
										echo "<strong>Faculty:</strong> {$facultyFullName}<br><br/>";
										echo "<span class='bulding'>{$lecture->buliding_name}-{$lecture->floor_no}-{$lecture->room_no}</span>";
										echo "</div><hr>";
								}
							endforeach;

                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
