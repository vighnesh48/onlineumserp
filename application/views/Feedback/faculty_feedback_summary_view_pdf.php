<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Feedback Report</title>
 <style>  
            table {  
                font-family: arial, sans-serif;  
                border-collapse: collapse;  
                width: 100%; font-size:12px; xmargin:0 auto;
            }  
      td{vertical-align: top;}
                      
            .signature{
            text-align: center;
            }
            .marks-table{
            width: 100%;xxheight:650px;
            }
            p{padding:0px;margin:0px;}
            h1, h3{margin:0;padding:0}
            .marks-table td{height:30px;vertical-align:middle;}
            .marks-table th{height:30px;}
.content-table tr td{border:1px solid #333;vertical-align:middle;}
.content-table th{border-left:1px solid #333;border-right:1px solid #333;border-bottom:1px solid #333;}
        </style>  

<body>
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
<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:18px;">Faculty  Report: <?php //$active_session['academic_session']." (".$active_session['academic_year'].")"?> </h3></td>
<td></td>
</tr>
<tr><td>
 </td>
</tr>
            
 </table>
 
 
 
 <table width="100%" cellpadding="0" cellspacing="0" border="1" class="table time-table table-striped table-bordered" align="center" style="font-size:13px;margin:50px 50px">
							
							<thead>
								<tr>
									<th align="center"><span>Sr.No</span></th>
									<th align="center"><span>School</span></th>
									<th align="center"><span>Stream</span></th>
									<th align="center"><span>Semester</span></th>
									<th align="center"><span>Division</span></th>
									<th align="center"><span>#stud</span></th>
									<th align="center"><span>#studAppeared(>80)</span></th>
									<th align="center"><span>#submitted</span></th>
									<!--<th align="center"><span>Action</span></th>-->
									
									
								</tr>
							</thead>
							<tbody id="studtbl">
								<?php
								$j=0;
								$i=1;
								//echo "<pre>";
								//print_r($class);
								
								if(!empty($class)){
									//echo "<pre>";										//print_r($class);
									foreach($class as $fbcls){
										$stud_cnt = count($fbcls['class_studcnt']);
										$fdappeared_studcnt = count($fbcls['fdappeared_studcnt']);										
										$studcnt_submitted = count($fbcls['studcnt_submitted']);
										$sub_cnt[] =$studcnt_submitted; 
										if($fbcls['stream_id']=='9'){
											$stream_name='B.Tech First Year';
										}else{
											$stream_name=$fbcls['stream_short_name'];
										}
										?>
										<tr>
										
											<td><?=$i?></td>
											<td><?=$fbcls['school_short_name']?></td>
											<td><?=$stream_name?></td>
											<td><?=$fbcls['semester']?></td>
											<td><?=$fbcls['division']?></td>

											<td><?=$stud_cnt?></td>	
											<td><?=$fdappeared_studcnt?></td>
											<td><?=$studcnt_submitted?>	</td>								
											
											
										</tr>
									
										<?php 
										$i++;										unset($stud_cnt);unset($stud_cnt);
									}
								}else{
									echo "<tr><td colspan=8>No data found.</td></tr>";
								}
								echo "<tr><td colspan=8> Total Feedback Submitted: <b>".array_sum($sub_cnt)."</b></td></tr>";
								//echo array_sum($sub_cnt);
								?>
								
								
							</tbody>
						</table>	</body>
         </html>