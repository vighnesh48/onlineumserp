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
<table cellpadding="0" cellspacing="0" border="0" align="center" width="800">
	<tr>
		<td width="80" align="center" style="text-align:center;padding-top:5px;" rowspan="2"><img src="<?=base_url()?>assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
		<td style="font-weight:normal;text-align:center;">
			<h1 style="font-size:30px;">Sandip University</h1>
			<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>
		</td>
		<td width="120" align="right" valign="top" style="text-align:right;" rowspan="2">
			<span style="font-size: 20px;"><b>COE</b></span>
		</td>
	</tr>
	<tr>
		<td align="center" style="text-align:center;padding-top:2px;">
		<h3 style="font-size:14px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br><br>
		<u style="font-size:15px;">GRADE-SHEET DISPATCH LIST - <?=$exam_month?> <?=$exam_year?></u></h3>
		</td>
	</tr>      
 </table>
<hr>
<table width="100%" cellpadding="0" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;">
<tr>
<td width="15%" valign="middle">&nbsp;<strong>Stream Name:</strong></td>
<td valign="middle">&nbsp; <?=$strmname[0]['stream_name']?></td>
<td width="15%" height="30" valign="middle">&nbsp;<strong>Semester:</strong> </td>
<td  height="30" valign="middle">&nbsp;<?=$semester?> </td>
</tr>
 </table>

							<table width="100%" border="1" cellspacing="5" cellpadding="5" class="bapu1">
							    <thead>
								<tr>
								<th width="5%">Sr.No.</th>
								<th width="15%">PRN</th>
								<th align="left">Name of the Candidate</th>
								<th width="17%" align="left">Gradesheet No.</th>
								<th width="15%" align="left">Sign</th>
                                </tr>
							</thead>
							<tbody>
							<?php
								
							$j=1;
							
							if(!empty($stud_list)){
								foreach($stud_list as $row){									
									$stud_name = strtoupper($row['first_name'].' '.$row['middle_name'].' '.$row['last_name']);
									?>
									
									<tr style="border:1px solid black;">
	
										<td align="center" style="border:1px solid black;"><?=$j?></td>
										<td align="center" style="border:1px solid black;"><?=$row['enrollment_no']?>&nbsp;</td>
										<td style="border:1px solid black;"><?=$row['stud_name'];?></td>	
										<td align="center" style="border:1px solid black;"><?=$row['markscard_no']?></td>	
										<td style="border:1px solid black;"></td>										
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
