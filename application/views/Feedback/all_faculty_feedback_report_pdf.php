  <table width="700" border="0" cellspacing="0" cellpadding="0" style="font-size:13px;margin:50px 50px">
            <tbody>  
            <tr>
            <td valign="top"  height="40">
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="800" style="margin-top:50px;">
            <tr>
<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="<?=base_url()?>assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
<td style="font-weight:normal;text-align:center;">
<h1 style="font-size:30px;">Sandip University</h1>
<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

</td>
<td width="120" align="right" valign="middle" style="text-align:center;padding-top:20px;">
<span style="border:0px solid #333;padding:10px;"></span></td>

<tr>
<td></td>
<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:18px;">Faculty Feedback Report: <?=$active_session['academic_session']." (".$active_session['academic_year'].")"?> </h3></td>
<td></td>
</tr>
            
 </table>
            </td>
            </tr>

            <tr>
            <td style="padding:0;">
            <table class="content-table" width="800" cellpadding="0" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
			<tr>
            <td height="30" valign="middle">&nbsp;<strong>Faculty:</strong></td>
            <td height="30" valign="middle">&nbsp;<?php if($sb['gender']=='male'){
												$sex = 'Mr.';
											}else{
												$sex = 'Mrs.';
											}?>	<?=$sex?> <?=$fac[0]['fname']." ".$fac[0]['lname']?></td>
            <td width="120" height="30" valign="middle">&nbsp;<strong>Stream:</strong></td>
            <td height="30" valign="middle">&nbsp;<?=$StreamSrtName[0]['stream_short_name']?></td>
            </tr>
            <tr>
            <td width="120" height="30">&nbsp;<strong>Subject:</strong></td>
            <td height="30">&nbsp;<?=$subj[0]['subject_short_name']?></td>
			<td width="80" height="30" valign="middle">&nbsp;<strong>Semester/Division</strong> </td>
            <td height="30" valign="middle">&nbsp;<?=$semester?> /&nbsp;<?php echo $division.''.$batch; ?></td>
            </td>
            </tr>
             </table>
           
            </td>
            </tr>
            
            
           <tr>
            <td class="marks-table"  align="left" width="800" height="900" style="padding:0;margin-top:10px">
            <table border="0"  align="left">
            <tr>
            <td valign="top" align="left">
           <table class="content-table" width="800" cellpadding="0" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
							
							<thead>
							   <tr>
									<th align="center"><span>Q.No</span></th>
									<th align="center"><span>Question</span></th>
									<th align="center"><span>Marks</span></th>
									<th align="center"><span>Out of </span></th>
									<th align="center"><span>Percentage(%)</span></th>
									
							   </tr>
								</thead>
								<tbody id="studtbl">
								<?php 
								
									$i=1;
									$j=0;
									$sum_marks=0;
									$sum_totmarks = 0;									
										if(!empty($questions)){
											foreach($questions as $que){
											$queNo ='Q'.$i;	
											$sum_marks+=$marks[$j][$queNo];
											$sum_totmarks+=$marks[$j]['quecnt'] *5;
									?>
									<tr>
										
										<td>&nbsp;<?=$i?></td> 
										<td>&nbsp;<?=$que['question_name']?></td>
										<td> &nbsp;<?=$marks[$j][$queNo]?></td>
										<td> &nbsp;<?=$marks[$j]['quecnt'] *5;?></td>
										<td> &nbsp;<?php
										$mrkobt = $marks[$j][$queNo];
										$mrkoutof = $marks[$j]['quecnt'] *5;
										echo $per = round($mrkobt / $mrkoutof *100);
										?>%</td>
											
										
											
									</tr>
									
								<?php 
								unset($queNo);
								//$j++;
										$i++;
										}
									}else{
										echo "<tr><td colspan=3>No data found.</td></tr>";
									}
								?>
								<tr>
									<td></td>
									<td>
										<table width="400px" border="0">
											<tr>
												<td style="border:0"><b>No of feedback:</b><b> <?=$marks[0]['quecnt']?></b></td>
												<td align="right" style="border:0;padding-right:10px" ><b>Total</b></td>
											</tr>
										</table>
									</td>
									<td>&nbsp;<b><?=$sum_marks?></b></td>
									<td>&nbsp;<b><?=$sum_totmarks?></b></td>
									<td>&nbsp;<b><?=round($sum_marks/$sum_totmarks * 100);?>%</b></td>
								</tr>
								
								</tbody>
							</table>
            </td>

            </tr>
            
             
            </table>
            
            </td>
            </tr>
			

            </tbody>
            </table>
			
