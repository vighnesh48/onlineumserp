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

							<table width="100%" border="1" cellspacing="0" cellpadding="0">
							    <thead>
								<tr>
								<th>Sr.N.</th>
								<th>PRN</th>
								<th align="left">Name of the Candidate</th>
								<?php foreach($sem_subjects as $subj) {
									$sub_name =$subj['subject_code'];
									?>
								<th ><?=$sub_name?></th>
								<?php } ?>
								<th>GPA</th>
                                </tr>
							</thead>
							<?php
						
							$j=1;
							$CI =& get_instance();
							$CI->load->model('Results_model');
							if(!empty($result_info)){
								foreach($result_info as $row){
									$studentid = $row['student_id'];
									$stud_name = strtoupper($row['first_name'].' '.$row['middle_name'].' '.$row['last_name']);
									$gpa = $row['sgpa'];
									?>
									<tbody>
									<tr>
	
										<td align="center"><?=$j?></td>
										<td align="center"><?=$row['enrollment_no']?>&nbsp;</td>
										<td><?=$stud_name?></td>
										<?php
										$wh_arr =array();
										$ugrade_arr =array();
										$fail ='';
										foreach($sem_subjects as $sb) {
												
												$subject_id = $sb['subject_id'];
												$sub_mrks =$this->Results_model->fetch_stud_sub_marks($studentid, $subject_id,$exam_id);

												if(!empty($sub_mrks[0]['final_grade'])){
													array_push($wh_arr, $sub_mrks[0]['final_grade']);
												    if($sub_mrks[0]['final_grade']=='U' || $sub_mrks[0]['final_grade']=='F'){
												       $bkcolor ="style='background-color:LightGray;'"; 
												    }else{
												        $bkcolor ='';
												    }
													
												if($sb['subject_component']=='EM' && $sub_mrks[0]['final_grade']=='U'){	
												//echo 'inside';exit;
													$sub_min = $sb['sub_min'];
													$practical_min_for_pass = $sb['practical_min_for_pass'];
													$th_min_mrks = $sb['theory_min_for_pass'];	
													$internal_min_for_pass = $sb['internal_min_for_pass'];	
													if($sub_mrks[0]['cia_marks'] < $internal_min_for_pass || $sub_mrks[0]['cia_marks']=='AB'){
														$fail .='CIA, ';
													}
													if($sub_mrks[0]['exam_marks'] < $th_min_mrks  || $sub_mrks[0]['exam_marks']=='AB'){
														$fail .='TH, ';
													}
													if($sub_mrks[0]['practical_marks'] < $practical_min_for_pass  || $sub_mrks[0]['practical_marks']=='AB'){
														$fail .='PR, ';
													}
													if($sub_mrks[0]['final_garde_marks'] < $sub_min ){
														$fail .='SUB, ';
													}
												}else{
													
												}	
												?>
												<?php if($sb['subject_component']=='EM' && $sub_mrks[0]['final_grade']=='U'){ 
												$res_fail = rtrim($fail,', ');
												$this->Results_model->update_failed_sub_type($studentid, $subject_id,$exam_id,$res_fail);
												}
												?>
												
														<td align="center" <?=$bkcolor?>><?=$sub_mrks[0]['final_grade']?> <?php if($sb['subject_component']=='EM' && $sub_mrks[0]['final_grade']=='U'){ ?><small style="font-size:6px;">(<?=rtrim($fail,', ');?>)</small><?php }?></td>
													
											<?php }else{ echo '
														<td align="center">-</td>
	
													';}
													unset($fail);
											}
											?>
											<td> <?php 
											if(!in_array("U", $wh_arr)){
												if(in_array("WH", $wh_arr)){
													echo "WH";
													}else{
														echo number_format($gpa ,2);
														} 
											}else{
												
											}?>
											</td>
									</tr>
									<?php 
									$j++;
								}
							}
							?>


            </tbody>
						</table>
            
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
