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
if($stream_id==71){
	$grd ='RES';
	if(isset($gdview) && $gdview=='Y'){
		$colspan=3;
	}else{
		$colspan=4;
	}
}else{
	$grd ='GRD';
	$colspan=5;
}
?>
							<table width="100%" border="1" cellspacing="0" cellpadding="0">
							    <thead>
								<tr>
								<th rowspan="2">Sr.N.</th>
								<th rowspan="2">PRN</th>
								<th rowspan="2" align="left">Name of the Candidate</th>
								<?php foreach($sem_subjects as $subj) {
									$sub_name =$subj['subject_code'];
									if($subj['subject_component']=='EM' && $stream_id !=71){
											$colspan=5;
									}else{
										$colspan=4;
									}
									?>
								<th colspan="<?=$colspan?>"><?=$sub_name?></th></tr>
								<?php } ?>

							<tr>
							<?php foreach($sem_subjects as $subj) { ?>
    <th align="center">INT</th>	
	<?php if($subj['subject_component']=='EM'){ ?>
    <th align="center">EXT</th>
	<?php } ?>
	<th align="center">TH</th>
    <th align="center">TOT</th>
	<?php if($dpharma!='Y'){?>
    <th align="center"><?=$grd?></th>
	<?php }
						}?></tr></thead>
							<?php
						
							$j=1;
							$CI =& get_instance();
							$CI->load->model('Phd_results_model');
							if(!empty($result_info)){
								foreach($result_info as $row){
									$studentid = $row['student_id'];
									$stud_name = strtoupper($row['first_name'].' '.$row['middle_name'].' '.$row['last_name']);
									?>
									<tbody>
									<tr>
	
										<td align="center"><?=$j?></td>
										<td align="center"><?=$row['enrollment_no']?>&nbsp;</td>
										<td><?=$stud_name?></td>
										<?php

										foreach($sem_subjects as $sb) {
											
												$subject_id = $sb['subject_id'];
												$sub_mrks =$this->Phd_results_model->fetch_stud_sub_marks($studentid, $subject_id, $exam_id);
												if($sb['subject_component']=='EM'){
													$th_marks =$sub_mrks[0]['practical_marks'];
													$ex_marks =$sub_mrks[0]['exam_marks'];
													$cia_garde_marks =$sub_mrks[0]['cia_marks'];//$sub_mrks[0]['cia_garde_marks'];
													
												}else{
													$th_marks =$sub_mrks[0]['exam_marks'];
													$cia_garde_marks =$sub_mrks[0]['cia_marks'];
													$ex_marks ='';
												}
												$total_grademarks = $sub_mrks[0]['final_garde_marks'];
												if($sub_mrks[0]['final_grade']=='WH'){
													$cia_garde_marks ='WH';
													$th_marks ='WH';
													$ex_marks ='WH';
													$cia_garde_marks ='WH';
													$total_grademarks='WH';
												}
												
												//if(!empty($sub_mrks[0]['exam_marks'])){
												?>
														<td align="center"><?php if($cia_garde_marks == NULL){ echo "-";}else{ echo $cia_garde_marks;}?></td>
														
														<td align="center"><?php if($th_marks == NULL){ echo "-";}else{ echo $th_marks;}?></td>
														<?php if($sb['subject_component']=='EM'){ ?>
														<td align="center"><?php if($ex_marks == NULL){ echo "-";}else{ echo $ex_marks;}?></td>
														<?php }?>
														<td align="center"><?=$total_grademarks?></td>
														<?php if($dpharma!='Y'){?>
														<td align="center"><?=$sub_mrks[0]['final_grade']?></td>
													
											<?php 
														}
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
            
                      <table width="50%" border="1" cellspacing="5" cellpadding="5" align="center" style="margin-top:40px;margin-bottom:20px;">
						    <tr>
						        <th rowspan=2 align="left">Course Code</th>
								<th rowspan=2 align="left">Course Name</th>
						        <th colspan=2 align="left">INT</th>
						        <th colspan=2 align="left">EXT</th>	
								<th colspan=2 align="left">SUB</th>								
						    </tr>
							<tr>
							<th align="center">MAX</th>
							<th align="center">MIN</th>
							<th align="center">MAX</th>
							<th align="center">MIN</th>
							<th align="center">MAX</th>
							<th align="center">MIN</th>
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
								<td align="left"><?=$internal_max?></td>
								<td align="left"><?=$internal_min_for_pass?></td>
								<td align="left"><?=$theory_max?></td>
								<td align="left"><?=$theory_min_for_pass?></td>
								<td align="left"><?=$sub_max?></td>
								<td align="left"><?=$sub_min?></td>
							</tr>
							<?php }?>
						</table>
						<!-- <table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">
									<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  
										<tr>
											<td align="center" class="signature" height="50" >&nbsp;</td>
											<td align="center" class="signature">&nbsp;</td>
											<td align="center" class="signature">&nbsp;</td>
   
										</tr>
										<tr>
											<td align="center" height="50" class="signature"><strong>Student Signature</strong></td>
											<td align="center" height="50" class="signature"><strong>Dean Signature</strong></td>
											<td align="center" height="50" class="signature"><strong>COE Signature</strong></td>
   
										</tr>
									</table>

								</td>
							</tr>
						</table> -->
					

	</body>
</html>
