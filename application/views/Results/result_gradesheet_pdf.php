<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Results</title>
		<style>  
    
			table {  
				font-family: arial, sans-serif;  
				border-collapse: collapse;  
				width: 100%; 
				font-size: 12px; 
				margin: 0 auto;
			}  
			td{
				vertical-align: top;}
                      
			.signature{
				text-align: center;
			}
			.marks-table{
				width: 100%;
				height: 650px;
			}
			p{
				padding: 0px;
				margin: 0px;}
			h1, h3{
				margin: 0;
				padding: 0}
			.marks-table td{
				height: 30px;
				vertical-align: middle;}
			
			.marks-table th{
				height: 30px;}
			.content-table td{
				border: 1px solid #333;
				xpadding-left: 5px;
				vertical-align: middle;}
			.content-table th{
				border-left: 1px solid #333;
				border-right: 1px solid #333;
				border-bottom: 1px solid #333;}
		</style>  

	</head>


	<body>
 


  
		<!-- <table align="center" width="100%"> 
			<tbody>  
				<tr>
					<td valign="top" height="40">
						<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin-top:15px;">
							<tr>
							<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="<?=base_url()?>assets/images/logo-7.jpg" alt="" width="60" border="0"></td>
							<td style="font-weight:normal;text-align:center;">
								<h1 style="font-size:30px;">Sandip University</h1>
								<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

							</td>
							<td width="120" align="right" valign="middle" style="text-align:center;padding-top:10px;"></td>
						</tr>
							<tr>
								<td></td>
								<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:12px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br><u>END SEMESTER EXAMINATION RESULTS - <?=$exam_sess[0]['exam_month']?> <?=$exam_sess[0]['exam_year']?></u></h3></td>
								<td></td>
							</tr>
            				<tr>
								<td colspan='3'>&nbsp;</td>
								
							</tr>
						</table>
					</td>
				</tr>
            
			            </tbody>
            
				</table>
						<table class="content-table" width="100%" cellpadding="0" cellspacing="2" border="2" align="center" style="font-size:12px;height:150px;overflow: hidden;padding-bottom: 10px">
							<tr>
								<td width="100" height="30"><strong>Stream : </strong>
								<?=$StreamShortName[0]['stream_short_name']?></td>
								<td width="100" height="30"><strong>Semester :</strong> <?=$semester?></td>					
							</tr>
							

						</table> -->
           
				

						<!-- <table border="0" class="content-table" width="100%" height="100%">
							<tr>
								<th>S.No.</th>
								<th>PRN</th>
								<th width="185">Name of the Candidate</th>
								<?php foreach($sem_subjects as $subj) {
									$sub_name =$subj['subject_code1'];
									?>
								<th><?=$sub_name?>
									<table class="xcontent-table" width="160"><tr>
										<td width="40">INT</td><td width="40">EXT</td><td width="40">TOT</td><td width="40">GRADE</td>
									</tr></table>
								</th>
								<?php }?>

							</tr> -->
<?php
// GROUP RESULT BY BATCH
$batch_groups = [];
foreach ($result_info as $r) {
    $batch = $r['admission_session'];
    if (!isset($batch_groups[$batch])) {
        $batch_groups[$batch] = [];
    }
    $batch_groups[$batch][] = $r;
}
?>

<?php foreach ($batch_groups as $batch => $result_info) { ?>

<h3 style="font-weight:bold; margin-top:30px;">BATCH : <?= $batch ?></h3>

<table width="100%" border="1" cellspacing="0" cellpadding="2" style="margin-top:15px;">
    <thead>
        <tr>
            <th>Sr.N.</th>
            <th>PRN</th>
            <th align="left">Name of the Candidate</th>

            <?php
            // Prepare subject-wise counters for this batch
            $subject_stats = [];
            foreach ($sem_subjects as $sb) {
                $subject_stats[$sb['subject_id']] = [
                    'total' => 0,
                    'pass'  => 0,
                    'fail'  => 0,
                ];
                echo "<th>{$sb['subject_code']}</th>";
            }
            ?>

            <?php if ($stream_id != '71') { ?>
                <th>GPA</th>
            <?php } ?>
        </tr>
    </thead>

    <tbody>
    <?php
    $j = 1;
    $CI =& get_instance();
    $CI->load->model('Results_model');

    $batch_total_students = 0;
    $batch_passed = 0;
    $batch_failed = 0;

    foreach ($result_info as $row) {
        $batch_total_students++;

        $studentid = $row['student_id'];
        $stud_name = strtoupper($row['first_name'].' '.$row['middle_name'].' '.$row['last_name']);
        $gpa = $row['sgpa'];
        ?>
        <tr>
            <td align="center"><?= $j ?></td>
            <td align="center"><?= $row['enrollment_no'] ?>&nbsp;</td>
            <td><?= $stud_name ?></td>

            <?php
            $wh_arr = [];
            $fail = '';

            // Check if ANY subject has malpractice → WH override
            $hasWH = false;
            if (!empty($row['sub']) && is_array($row['sub'])) {
                foreach ($row['sub'] as $s) {
                    if (!empty($s['malpractice']) && $s['malpractice'] == 'Y') {
                        $hasWH = true;
                        break;
                    }
                }
            }

            foreach ($sem_subjects as $sb) {
                $subject_id = $sb['subject_id'];

                $sub_mrks = $CI->Results_model->fetch_stud_sub_marks($studentid, $subject_id, $exam_id);

                // ---------- SUBJECT STATS UPDATE ----------
                if (!empty($sub_mrks[0]['final_grade'])) {

                    $grade = $sub_mrks[0]['final_grade'];

                    $subject_stats[$subject_id]['total']++;

                    if ($grade == 'U' || $grade == 'F')
                        $subject_stats[$subject_id]['fail']++;
                    else
                        $subject_stats[$subject_id]['pass']++;
                }

                // ---------- DISPLAY LOGIC ----------
                if (!empty($sub_mrks[0]['final_grade'])) {

                    $grade = $sub_mrks[0]['final_grade'];
                    $wh_arr[] = $grade;

                    $bkcolor = ($grade == 'U' || $grade == 'F') ? "style='background-color:LightGray;'" : "";

                    // If global WH
                    $gradeToShow = $hasWH ? 'WH' :
                        (($sub_mrks[0]['malpractice'] == 'Y') ? 'WH' : $grade);

                    echo "<td align='center' $bkcolor>";

                    echo $gradeToShow;

                    // Fail components details
                    if (!$hasWH && $sb['subject_component'] == 'EM' && $grade == 'U') {

                        $fail = '';

                        if ($sub_mrks[0]['cia_marks'] < $sb['internal_min_for_pass'] || $sub_mrks[0]['cia_marks']=='AB')
                            $fail .= "CIA, ";

                        if ($sub_mrks[0]['exam_marks'] < $sb['theory_min_for_pass'] || $sub_mrks[0]['exam_marks']=='AB')
                            $fail .= "TH, ";

                        if ($sub_mrks[0]['practical_marks'] < $sb['practical_min_for_pass'] || $sub_mrks[0]['practical_marks']=='AB')
                            $fail .= "PR, ";

                        if ($sub_mrks[0]['final_garde_marks'] < $sb['sub_min'])
                            $fail .= "SUB, ";

                        echo "<small style='font-size:6px;'>(".rtrim($fail, ', ').")</small>";
                    }

                    echo "</td>";

                } else {
                    echo "<td align='center'>-</td>";
                }

            } // END SUBJECT LOOP
            ?>

            <?php if ($stream_id != '71') { ?>
                <td>
                <?php
                if (!in_array("U", $wh_arr) && !in_array("F", $wh_arr)) {
                    if (in_array("WH", $wh_arr)) echo "WH";
                    else echo number_format($gpa, 2);
                }
                ?>
                </td>
            <?php } ?>

        </tr>

        <?php
        // STUDENT RESULT COUNT
        $student_failed = false;
        foreach ($row['sub'] as $s) {
            if ($s['final_grade'] == 'U') {
                $student_failed = true;
                break;
            }
        }
        if ($student_failed) $batch_failed++;
        else $batch_passed++;

        $j++;
    }
    ?>
    </tbody>

    <!-- SUMMARY ROWS -->
    <tr style="font-weight:bold;">
        <td colspan="3" style="text-align:right;font-weight:bold;">Total Students</td>
        <?php foreach ($sem_subjects as $sb): ?>
            <td align="center" style="font-weight:bold;"><?= $subject_stats[$sb['subject_id']]['total'] ?></td>
        <?php endforeach; ?>
        <?php if ($stream_id!='71') { ?><td>-</td><?php } ?>
    </tr>

    <tr style="font-weight:bold;">
        <td colspan="3" style="text-align:right;font-weight:bold;">No. of Passed</td>
        <?php foreach ($sem_subjects as $sb): ?>
            <td align="center" style="font-weight:bold;"><?= $subject_stats[$sb['subject_id']]['pass'] ?></td>
        <?php endforeach; ?>
        <?php if ($stream_id!='71') { ?><td>-</td><?php } ?>
    </tr>

    <tr style="font-weight:bold;">
        <td colspan="3" style="text-align:right;font-weight:bold;">No. of Failed</td>
        <?php foreach ($sem_subjects as $sb): ?>
            <td align="center" style="font-weight:bold;"><?= $subject_stats[$sb['subject_id']]['fail'] ?></td>
        <?php endforeach; ?>
        <?php if ($stream_id!='71') { ?><td>-</td><?php } ?>
    </tr>

    <tr style="font-weight:bold;">
        <td colspan="3" style="text-align:right;font-weight:bold;">Passed %</td>
        <?php foreach ($sem_subjects as $sb):
            $s = $subject_stats[$sb['subject_id']];
            $pp = ($s['total'] > 0) ? round(($s['pass'] / $s['total']) * 100, 2) : 0;
        ?>
            <td align="center" style="font-weight:bold;"><?= $pp ?>%</td>
        <?php endforeach; ?>
        <?php if ($stream_id!='71') { ?><td>-</td><?php } ?>
    </tr>

</table>

<?php } // END BATCH LOOP ?>


            
                      <table>
					  <tr><td width="70%">					  
						<table width="50%" border="1" cellspacing="5" cellpadding="5" align="center" style="margin-top:40px;margin-bottom:20px;">
						    <tr>
						        <th align="left">Course Code</th>
								<th align="left">Course Name</th>
						        <th align="left">Credits</th>
						        <!--<th align="left">EXT</th>-->
						        
						    </tr>
						    <?php
						    foreach($sem_subjects as $subj) {
                        		    $sub_code =$subj['subject_code'];
                        			$sub_name =$subj['subject_name'];
                        			$theory_max =$subj['theory_max'];
                        			$theory_min_for_pass =$subj['theory_min_for_pass'];
                        			$internal_max =$subj['internal_max'];
                        			$internal_min_for_pass =$subj['internal_min_for_pass'];
                        			$sub_min =$subj['sub_min'];
                        			$sub_max =$subj['sub_max'];
                                	?>
							<tr>
								<td align="left"><?=strtoupper($sub_code);?></td>
								<td align="left"><?=strtoupper($sub_name);?></td>
								<td align="left"><?=$subj['credits'];?></td>
								<!--<td align="left"><?=$internal_max?></td>-->
								<!--<td align="left"><?=$theory_max?></td>-->
							</tr>
							<?php }?>
						</table>
						</td>
						<td width="30%">
						<?php if($stream_id !='71'){?>
						<table  border="1" cellspacing="5" cellpadding="5" align="center" style="margin-top:40px;margin-bottom:20px;">
						    <tr>
						        <th align="left">Grade</th>
								<th align="left">Points</th>
						        <th align="left">Performance</th>						        
						    </tr>
						    <?php
						    foreach($grade_details as $grade) {
								if($grade['grade_letter']=='W'){
									$grade_point ='-';
								}else{
									$grade_point =$grade['grade_point'];
								}
                                	?>
							<tr>
								<td align="left"><?=$grade['grade_letter']?></td>
								<td align="left"><?=$grade_point;?></td>
								<td align="left"><?=$grade['performance'];?></td>
							</tr>
							<?php }?>
							<tr>
								<td align="left">WH</td>
								<td align="left">-</td>
								<td align="left">With held</td>
							</tr>
						</table>
						<?php }else{?>
						<table  border="1" cellspacing="5" cellpadding="5" align="center" style="margin-top:40px;margin-bottom:20px;">
						    <tr>
						        <th align="left">Grade</th>
								<th align="left">Performance</th>						        
						    </tr>
							<tr>
								<td align="left">P</td>
								<td align="left">PASS</td>	
							</tr>
							<tr>
								<td align="left">U</td>
								<td align="left">Reappear/Absent</td>
								
							</tr>
							
						</table>
						<?php }?>
						</td>
					</tr>
					</table>
					

	</body>
</html>
