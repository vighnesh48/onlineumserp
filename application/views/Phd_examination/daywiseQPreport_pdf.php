<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>QP Reports</title>
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
				padding-left: 5px;
				vertical-align: middle;}
			.content-table th{
				border-left: 1px solid #333;
				border-right: 1px solid #333;
				border-bottom: 1px solid #333;}
		</style>  

	</head>


	<body>
 


  
		<table align="center" width="700"> 
			<tbody>  
				<tr>
					<td valign="top" height="40">
						<table cellpadding="0" cellspacing="0" border="0" align="center" width="800" style="margin-top:50px;">
							<tr>
							<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="<?=base_url()?>assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
							<td style="font-weight:normal;text-align:center;">
								<h1 style="font-size:30px;">Sandip University</h1>
								<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

							</td>
							<td width="120" align="right" valign="middle" style="text-align:center;padding-top:20px;">
								</td>

							<tr>
								<td></td>
								<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:12px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br><u>DAY WISE QP REQUIREMENT - <?=$exam_sess[0]['exam_month']?> <?=$exam_sess[0]['exam_year']?></u></h3></td>
								<td></td>
							</tr>
            
						</table>
					</td>
				</tr>
            
				<tr>
					<td style="padding:0;">
						<table class="content-table" width="800" cellpadding="0" cellspacing="0" border="0" align="center" style="font-size:12px;height:150px;overflow: hidden;padding-bottom: 10px">
							<tr>
								<td width="100" height="30"><strong>Date :</strong></td>
								<td><?=date('d/m/Y', strtotime($examdetails[0]['date']));?></td>					
								<td width="100" height="30"><strong>Day :</strong></td>
								<td><?=$day?></td>
								<td width="100" height="30"><strong>Time :</strong></td>
								<td><?=$fromtime[0].':'.$fromtime[1].'-'.$totime[0].':'.$totime[1];?></td>
							</tr>
							

						</table>
           
					</td>
				</tr>
            
            
				<tr>
					<td class="marks-table"  style="padding:0;">
						<table border="0" class="content-table" width="800" height="800">
							<tr>
								<th>S.No.</th>
								<th>Name of the Programme </th>
								<th>Subject</th>
								<th>Subject Code</th>
								<th>Sem</th>
								<th>Strength</th>
								<th>QP Count</th>
								<th>Remark</th>
							</tr>

							<?php
							$j=1;
							/*echo "<pre>";
							print_r($examdetails);exit;*/
							if(!empty($examdetails)){
								foreach($examdetails as $exd){
									$fromtime= explode(':', $exd['from_time']);
									$totime= explode(':', $exd['to_time']);
									?>
									<tr>
	
										<td><?=$j?></td>
										<td><?=$exd['stream_short_name']?></td>
										<td><?=$exd['subject_name']?></td>
										<td><?=$exd['subject_code1']?></td>
										<td><?=$exd['semester']?></td>
										<td><?=$exd['TOT']?></td>
										<td><?=$exd['TOT']?></td>
										<td></td>
	
	
									</tr>
									<?php 
									$j++;
								}
							}else{
								//echo "<tr><td colspan=4>No data found.</td></tr>";
							}
							?>


            
						</table>
            
					</td>
				</tr>

				<tr>
					<td style="border-top:1px solid #333;padding-left:5px;font-size:10px;height:50px;" height="60">
						<h4>Instruction to Candidate</h4>
						<ol>
							<li> Without Identification Card candidate shall not be allowed to write the examination. </li>    
							<li> Attend the Examination as per the dates mentioned above.          
							</li>    
							<li>Carrying mobile phone or any Electronic device into the examination hall is strictly prohibited.
							<li>Refer instruction at the facing sheet of the Answer book before writing the examination.
							</li> 
               
						</ol>
					</td>
				</tr>
          
				<tr>
					<td align="center" style="border-top:1px solid #333;">
						<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
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
						</table>
					</td>
				</tr>

			</tbody>
		</table>

	</body>
</html>
