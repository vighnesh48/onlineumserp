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
							<table width="100%" border="1" cellspacing="0" cellpadding="3">
							    <thead>
								<tr>
								<th rowspan="2">Sr.N.</th>
								<th rowspan="2">PRN</th>
								<th rowspan="2" align="left">Name of the Candidate</th>
								<?php foreach($sem_subjects as $subj) {
									$sub_name =$subj['subject_code'];
									if($subj['subject_component']=='EM' && $stream_id !=71){
											$colspan=6;
									}else{
										$colspan=5;
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
	<th align="center">RV</th>
    <th align="center">TOT</th>
	<?php if($dpharma!='Y'){?>
    <th align="center"><?=$grd?></th>
	<?php }
						}?></tr></thead>
							<?php
						
							$j=1;
							$CI =& get_instance();
							$CI->load->model('Results_model');
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
												$sub_mrks =$this->Result_reval_model->fetch_stud_sub_marks($studentid, $subject_id, $exam_id);
												if($sb['subject_component']=='EM'){
													$th_marks =$sub_mrks[0]['practical_marks'];
													$ex_marks =$sub_mrks[0]['exam_marks'];
													$cia_garde_marks =$sub_mrks[0]['cia_marks'];//$sub_mrks[0]['cia_garde_marks'];
													$reval_marks=$sub_mrks[0]['reval_marks'];
													
												}else{
													$th_marks =$sub_mrks[0]['exam_marks'];
													 $cia_garde_marks =$sub_mrks[0]['cia_marks'];
													$ex_marks ='';
													 $reval_marks=$sub_mrks[0]['reval_marks'];
												}
												if($sub_mrks[0]['final_grade']=='U' || $sub_mrks[0]['final_grade']=='F'){
												       $bkcolor ="style='background-color:LightGray;'"; 
												    }else{
												        $bkcolor ='';
												    }
														$final_grade='';
													if(!empty($sub_mrks[0]['reval_grade'])){
												
												 if($sub_mrks[0]['result_grade']==$sub_mrks[0]['reval_grade']){
														$final_grade= 'NC' ;
													}
													else
													{
													$final_grade=$sub_mrks[0]['reval_grade'];
													} 
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
														<td align="center"><?php if($reval_marks == NULL){ echo "-";}else{ echo $reval_marks;}?></td>
														<?php if($sb['subject_component']=='EM'){ ?>
														<td align="center"><?php if($ex_marks == NULL){ echo "-";}else{ echo $ex_marks;}?></td>
														<?php }?>
														<td align="center" ><?=$total_grademarks?></td>
														<?php if($dpharma!='Y'){?> 
														<td align="center" <?=$bkcolor?>><?= $final_grade; ?>
													
														</td>
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
									if($subj['subject_component']=='TH' || $subj['subject_component']=='EM'){
                        			$theory_max =$subj['theory_max'];
                        			$theory_min_for_pass =$subj['theory_min_for_pass'];
									}else{
									$theory_max =$subj['practical_max'];
                        			$theory_min_for_pass =$subj['practical_min_for_pass'];
									}
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
	</body>
</html>
