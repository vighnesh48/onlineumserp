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
             .bapu tr td,.bapu tr th{
				 border:1px solid black;
			 }         
		</style>  

	</head>


	<body>


							<table width="100%" border="1" cellspacing="0" cellpadding="3" class="bapu1">
							    <thead>
								<tr>
								<th rowspan="2">Sr.N.</th>
								<th rowspan="2">PRN</th>
								<th rowspan="2" align="left">Name of the Candidate</th>
								<?php foreach($sem_subjects as $subj) {
									$sub_name =$subj['subject_code'];
									?>
								<th colspan="2"><?=$sub_name?><BR> <?=$subj['subject_short_name']?></th></tr>
								<?php } ?>
								<tr>
								<?php foreach($sem_subjects as $subj) {
									?>
										<th align="center">CIA</th><th align='center'>ATT</th>
								<?php } ?>
                                </tr>
							</thead>
							<tbody>
							<?php
								
							$j=1;
							$CI =& get_instance();
							$CI->load->model('Marks_model');
							if(!empty($result_info)){
								foreach($result_info as $row){
									$studentid = $row['stud_id'];
									$stud_name = strtoupper($row['first_name'].' '.$row['middle_name'].' '.$row['last_name']);
									?>
									
									<tr style="border:1px solid black;">
	
										<td align="center" style="border:1px solid black;"><?=$j?></td>
										<td align="center" style="border:1px solid black;"><?=$row['enrollment_no']?>&nbsp;</td>
										<td style="border:1px solid black;"><?=$stud_name?></td>
										<?php

										foreach($sem_subjects as $sb) {
											$subject_id = $sb['subject_id'];
											$sub_mrks =$this->Marks_model->fetchstudentsubCIAmarks($studentid, $subject_id,$exam_month,$exam_year, $exam_id);
											
											//if(!empty($sub_mrks[0]['cia_marks'])){
												
											?>
											<td align='center'><?php if(!empty($sub_mrks[0]['cia_marks'])){ echo $sub_mrks[0]['cia_marks'];}else{ echo "-";}?></td>
											<td align='center'><?php if(!empty($sub_mrks[0]['attendance_marks'])){ echo $sub_mrks[0]['attendance_marks'];}else{ echo "-";}?></td>										
											<?php /*}else{ echo '
														<td align="center">-</td>
														<td align="center">-</td>
													';}*/
											}
											?>
	
									</tr>
									<?php 
									$j++;
								}
							}
							?>
							</tbody>
						</table>
	</body>
</html>
