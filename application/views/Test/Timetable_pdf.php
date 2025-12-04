<!DOCTYPE html>
<html lang="en">
<head>

<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" type="text/css"/>
<style>

.table-striped > tbody > tr th{background-color:#DDAC20!important;text-align: center!important;text-transform:uppercase;font-size:13px }
.table-striped > tbody > tr:nth-child(odd) > td{background-color:#FFCC0080!important}
.table-striped > tbody > tr:nth-child(even) > td{background-color:#FF66!important}
.time-table{border:2px solid #000}
.time-table > thead > tr > th, .time-table > tbody > tr > th, .time-table > tfoot > tr > th, .time-table > thead > tr > td, .time-table > tbody > tr > td, .time-table > tfoot > tr > td{
	border-right:2px solid #000;border-left:2px solid #000;border-top:2px solid #000;
}
.time-table > tbody > tr td{font-size:12px;}
	.time-table > thead > tr > th, .time-table > tbody > tr > th, .time-table > tfoot > tr > th, .time-table > thead > tr > td, .time-table > tbody > tr > td, .time-table > tfoot > tr > td{
	border-bottom:2px solid #000
}
.table-striped{font-size:12px;}
.sub-name{text-transform: uppercase;font-size:12px;}
.theme-default .bordered, .theme-default, .theme-default .table, .theme-default hr{border-color:#4d717f!important}
.table{width:100%}
</style>
</head>
<body><div class="panel-body">
<div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    
                    			<?php
						if($course_id==3 || $course_id==9)
						{
							
						}
						else{
						?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="maintable">
  <tr>
    <td align="center">
    <img src="http://sandipuniversity.com/erp/assets/images/logo_form.png" width="300" />
    <p style="margin-top:0"><strong>SANDIP UNIVERSITY,NASHIK</strong></p>
    <p style="margin-top:0"><strong><?php echo $curr_session[0]['academic_session'].'-'.$curr_session[0]['academic_year']; ?></strong></p>

  </tr>
</table>
<br>
                        
                        
                        
                    <table width="100%" cellpadding="0" cellspacing="0" border="1" class="table time-table table-striped table-bordered" align="center" id="search-table" >
    <tbody>
       <tr>
            <th><span style="color:#000;">Day/Time</span></th>
			<?php
			$emp_id = $this->session->userdata("name");
			$m=0;
			//print_r($slot_time);
			//for($i=0;$i<count($slot_time);$i++)
			foreach($slot_time as $listslot)
			{
				
				if($listslot['subject_type']){
					//$arr_frmtime[]=$slot_time[$i]['from_time'];
				?>
				
            <th align="center" style="color:#FFF; background-color:#FF66 !important;"><?=$listslot['from_time']?>
             <?=$listslot['slot_am_pm']?><br>to<br><?=$listslot['to_time']?></th>
			<?php } 
			}?>
			
       </tr>
	   <?php
			//$j=1; 
			//echo "<pre>";
			//print_r($arr_frmtime);	
			if(!empty($ttsub)){
			for($l=0;$l<count($wday);$l++)
			{
				
			?>
			<tr <?=$slot[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
				<td align="center" style="background-color:#FF66 !important;"><strong><?=$wday[$l]?></strong></td>
				<?php 
				//echo count($ttsub);
					$pr_count=1;
					$pr_slot="";
					$pr_display="";

					$th_slot="";
					$th_display="";
					
					for($j=0;$j<count($ttsub);$j++){

						$colmn_cnt = 6;
						for($k=0;$k<count($ttsub[$l][$j]);$k++){
							
							$faculty = $ttsub[$l][$j][$k]['faculty_code']; 
							
							//echo $faculty[0];
							if($emp_id==$faculty){
								$bk_color = "style='background-color: #F9BE67!important;'";
							}else{
								$bk_color ='';
							}
							
						?>
						
							<?php 
							//echo $ttsub[$l][$j][$k]['wday'];
							if($ttsub[$l][$j][$k]['subject_type']=='TH' && $ttsub[$l][$j][$k]['subject_code'] !='' )
							
							{
								$faculty_th[] = $ttsub[$l][$j][$k]['faculty_code']; 
								if(($th_slot=="")&&($ttsub[$l][$j][$k]['wday']==$wday[$l])){
									$th_display = $ttsub[$l][$j][$k]['sub_code']." (".$ttsub[$l][$j][$k]['subject_short_name'].") <br> ".strtoupper($ttsub[$l][$j][$k]['fname'][0].'. '.$ttsub[$l][$j][$k]['mname'][0].'. '.$ttsub[$l][$j][$k]['lname']);
									$th_slot=$ttsub[$l][$j][$k]['lect_slot_id'];
									
								}
								else if(($th_slot=$ttsub[$l][$j][$k]['lect_slot_id'])&&($ttsub[$l][$j][$k]['wday']==$wday[$l])) {
									$th_display .='<br>'.$ttsub[$l][$j][$k]['sub_code']." (".$ttsub[$l][$j][$k]['subject_short_name'].") <br> ".strtoupper($ttsub[$l][$j][$k]['fname'][0].'. '.$ttsub[$l][$j][$k]['mname'][0].'. '.$ttsub[$l][$j][$k]['lname']);			
								}
								
								$current_slot_th = $ttsub[$l][$j][$k]['lect_slot_id'];
								$next_slot_th = $ttsub[$l][$j][$k+1]['lect_slot_id'];
								
								if(in_array($emp_id, $faculty_th)){
									$bkth_color = "style='background-color: #F9BE67!important;'";
								}else{
									$bkth_color = "style='color: transparent;
										text-shadow: 0 0 8px #000;
									'";
								}	
								if($current_slot_th != $next_slot_th){


							?>
							<td <?=$bkth_color?>>
							<strong class="sub-name" title="<?=$ttsub[$l][$j][$k]['subject_name']?>" style="cursor:pointer">
							<?php
							
								if($ttsub[$l][$j][$k]['subject_code']== 'OFF'){
									echo "";
								}else if($ttsub[$l][$j][$k]['subject_code']=='Library'){
									echo "Library";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'Tutorial'){
									echo "Tutorial";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'Tutor'){
									echo "Tutor";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'IS'){
									echo "Internet Slot";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'RC'){
									echo "Remedial Class";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'EL'){
									echo "Experiential Learning";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'SPS'){
									echo "Swayam Prabha Session";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'ST'){
									echo "Spoken Tutorial";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'FAM'){
									echo "Faculty Advisor Meet";
								}else{
									echo $th_display;
								}
								?>	
							</strong>
							
							</td>
							
							<?php
							$th_slot="";
							$th_display="";
							$faculty_th="";
								}							
							
							}
							elseif($ttsub[$l][$j][$k]['subject_type']=='PR'){
								
								//echo $timediff = round((strtotime('08:00') - strtotime('11:30')) /3600,0);
								 
								$timediff = round((strtotime($ttsub[$l][$j][$k]['to_time']) - strtotime($ttsub[$l][$j][$k]['from_time'])) /3600,0);
								//echo $ttsub[$l][$j][$k]['from_time'].' -'.$ttsub[$l][$j][$k]['to_time'].'='.$timediff;
								
									$faculty_pr[] = $ttsub[$l][$j][$k]['faculty_code']; 
										if(($pr_slot=="")&&($ttsub[$l][$j][$k]['wday']==$wday[$l])){
											$pr_display=$ttsub[$l][$j][$k]['sub_code']." (".$ttsub[$l][$j][$k]['subject_short_name'].")-".$ttsub[$l][$j][$k]['division']."".$ttsub[$l][$j][$k]['batch_no']." / ".strtoupper($ttsub[$l][$j][$k]['fname'][0].'. '.$ttsub[$l][$j][$k]['mname'][0].'. '.$ttsub[$l][$j][$k]['lname']).'<br>';
											$pr_count++;
											$pr_slot=$ttsub[$l][$j][$k]['lect_slot_id'];
											
										}
						else if(($pr_slot=$ttsub[$l][$j][$k]['lect_slot_id'])&&($ttsub[$l][$j][$k]['wday']==$wday[$l])) {
						$pr_display.=$ttsub[$l][$j][$k]['sub_code']." (".$ttsub[$l][$j][$k]['subject_short_name'].")-".$ttsub[$l][$j][$k]['division']."".$ttsub[$l][$j][$k]['batch_no']." / ".strtoupper($ttsub[$l][$j][$k]['fname'][0].'. '.$ttsub[$l][$j][$k]['mname'][0].'. '.$ttsub[$l][$j][$k]['lname']).'<br>';
					$pr_count++;
											$pr_slot=$ttsub[$l][$j][$k]['lect_slot_id'];
											
											
										}
										//echo "<pre>";print_r($faculty_pr);//if($pr_slot != $next_slot)
										if(in_array($emp_id, $faculty_pr)){
											$bkpr_color = "style='background-color: #F9BE67!important;'";
										}else{
											$bkpr_color =  "style='color: transparent;
										text-shadow: 0 0 8px #000;
									'";
										}	
								$next_slot=$ttsub[$l][$j][$k+1]['lect_slot_id'];
								if($ttsub[$l][$j][$k]['lect_slot_id'] != $next_slot){ 
									if($timediff > 1){
										$colspan = $timediff;
									}else{
										$colspan = '';
									}
									
								?>
								<td colspan="<?=$colspan?>" <?=$bkpr_color?>>
									<strong class="sub-name" title="" style="cursor:pointer"><?=$pr_display?></strong><br>
							    </td>
											
								<?php	
									unset($timediff);
									unset($colspan);
									unset($pr_display);
								}		
								
							}
							else{
							?>	
							<td colspan="1" <?=$bk_color?>>
									<strong class="sub-name" title="" style="cursor:pointer"></strong><br>
								</td>
							<?php }?>
						
				<?php }
				$faculty_pr="";
				
				//$next_slot="";
				}
				$th_display="";
				$current_slot_th = "";
				$next_slot_th = "";
				?>								
			</tr>
			
			<?php
			//exit;
			
			} 
			}			
			?>
		
</tbody>
</table>                   
                    <?php } ?>
                </div></div>
                </body>
                </html>