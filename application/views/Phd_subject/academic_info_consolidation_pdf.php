<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Academic Information Consolidation</title>
    <style>  
    table {  
                font-family: arial, sans-serif;  
                border-collapse: collapse;  
                width: 100%; font-size:12px; margin:0 auto;
            }  
      td{vertical-align: top;}
                      
            .signature{
            text-align: center;
            }
            .marks-table{
            width: 100%;
            }
            p{padding:0px;margin:0px;}
            h1, h3{margin:0;padding:0}
            .marks-table td{height:30px;vertical-align:middle;}
			
            .marks-table th{height:30px;}
.content-table td{border:1px solid #333;padding-left:5px;vertical-align:middle;}
.content-table th{border-left:1px solid #333;border-right:1px solid #333;border-bottom:1px solid #333;}
        </style>  

</head>


<body>
 <table cellpadding="0" cellspacing="0" border="0" align="center" width="800" style="">
<tr>
<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="<?=base_url()?>assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
<td style="font-weight:normal;text-align:center;" colspan="2">
<h1 style="font-size:30px;">Sandip University</h1>
<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

</td>
<td width="120" align="right" valign="top" style="text-align:center;">
<span style="border:0px solid #333;padding:10px;font-size:30px;"><b>COE</b></span></td>
</tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" align="center" width="800" style="margin-bottom:10px;">
 <tr>
	<td align="center" colspan="4"><h3>Academic Information Consolidation</h3></td>
</tr>
 <tr>
	<td align="center" colspan="4">&nbsp;</td>
</tr>
<tr>
<td><b>Department:</b> <?=$course[0]['stream_name']?></td>
<td><b>Batch:</b> <?=$batch?></td>
<td><b>Semester:</b> <?=$semester?></td>
<td align="right"><b>Total Strength:</b> <?php if(!empty($stud_strength)){ echo $stud_strength[0]['stud_streangth'];}?></td>
</tr>         
 </table>
            
            <table border="1" class="content-table" width="800">
            <tr>
			<th width="5%" class="valin">#</th>
			<!--th width="5%" class="valin">Batch</th-->
			<th class="valin">Course Information</th> 
			<!--th width="5%" class="valin">Sem</th-->
			<th>Type</th>
			<th>Credits</th>
			<th>Max INT.</th>
			<th>Max EXT.</th>
			<th>Division </th>
			<th>Student</th>
			<th>faculity</th>
			<th>Total</th>			
            </tr>

						<?php
							$CI =& get_instance();
							$CI->load->model('Subject_model');
                            $j=1;
                            $fac_app =0;
                            //echo "<pre>";print_r($subject_details);
							if(!empty($subject_details)){
							foreach($subject_details as $sd)
                            {
                               	$sumof_count=array();
                                $stud = $this->Subject_model->sectionwise_strength($sd['sub_id'], $streamId, $academicyear, $semester);
                               if(!empty($stud))
                               {
	                               	//this loop is being used for sum of studentcount
	                                foreach($stud as $sds)
		                            {
		                            	$sumof_count[]=$sds['stud_cnt'];
		                            }
		                            //end of loop sum of studentcount
		                             $cnt_sub = count($stud);

                               }
                                
                            ?>
                            <tr >
                                <td rowspan="<?=$cnt_sub?>"><?=$j?></td>
								<!--td><?=$sd['batch']?></td-->   
                                <td rowspan="<?=$cnt_sub?>"><?=$sd['subject_code']?>-<?=$sd['subject_name']?></td>
								<!--td><?=$sd['semester']?></td-->
								 <td rowspan="<?=$cnt_sub?>"><?php 
                                if($sd['subject_component']=='PR'){ echo 'Practical';}else{ echo 'Theory';}
                                ?></td>
                                <td rowspan="<?=$cnt_sub?>"><?=$sd['credits']?></td>
                                <td rowspan="<?=$cnt_sub?>"><?=$sd['internal_max']?></td>
                                <td rowspan="<?=$cnt_sub?>"> 
									<?php 
									if($sd['theory_max']!=''){
									echo $sd['theory_max'];}else{ echo "-";}
									?>
								</td>
	
                                
                                 <?php
									$str_stud='';
									$i=0;

									foreach($stud as $st){
										
										
										//$cnt_stud[]=$st['stud_cnt'];
										$studdetials = $this->Subject_model->getSubFacDetails($sd['sub_id'], $streamId, $semester,$st['division']);

										if(!empty($studdetials))
										{
											$facultyname_mobile=$studdetials[0]['fname']."&nbsp;".$studdetials[0]['lname']."-".$studdetials[0]['mobile_no'];

										}
										else
										{
											$facultyname_mobile='';

										}
										$str_stud .= $st['division'].'-'.$st['stud_cnt'].'-'.$facultyname_mobile.'<br/>';
										if($i==0)
										{
										?>
										
									
										<td align="center"><?=$st['division']?></td>
						                <td align="center"><?=$st['stud_cnt']?></td>
						                <td><?=$facultyname_mobile;?></td>
						                <td rowspan="<?=$cnt_sub?>" align="center"><?=array_sum($sumof_count);?></td>


										<?php } else { ?>
											<tr>

										<td align="center"><?=$st['division']?></td>
						                <td align="center"><?=$st['stud_cnt']?></td>
						                <td><?=$facultyname_mobile;?></td>
						            </tr>
											<?php 
										}
										$i++;

									}
									//echo rtrim($str_stud,', ');
									//unset($str_stud);
								?>
                               
                              
                            </tr>
                            <?php
                            $j++;
							unset($cnt_stud);
                            }
							}
                            ?>               
            </table>
			
			<h3 style="font-size:12px;padding-top:10px;padding-bottom:10px;text-align:center">Class Coordinator Information</h3>
			<table border="1" class="content-table" width="800">
            <tr>
			<?php 
			$all_divns = array_unique($div);
			foreach($all_divns as $dv)
            {
			?>
			<th width="5%" class="valin"><?=$dv;?></th>
			<?php }?>			
            </tr>

						
            <tr >  
			<?php
			if(!empty($all_divns)){								
				foreach($all_divns as $dv)
				{
					$cls = $this->Subject_model->class_adv_info($dv, $streamId, $academicyear, $semester);
				?>                            
					<td><?php if(!empty($cls[0]['class_teacher'])){
						echo $name = $cls[0]['fname'].' '.$cls[0]['mname'][0].' '.$cls[0]['lname'];echo"<br>";
						echo $des = $cls[0]['designation_name'].'/'.$cls[0]['stream_short_name'];echo"<br>";
						echo 'Mobile No.: '.$name = $cls[0]['mobile_no'];
					}else{
						echo "No Data Found.";
					}
					?></td>
				<?php
				}
			}
			?> 
		</tr>
					
            </table>						
</body>
</html>
