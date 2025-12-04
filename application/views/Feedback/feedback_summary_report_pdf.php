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

</head>




<body>

  <table width="700" border="0" cellspacing="0" cellpadding="0" height="100%" style="font-size:13px;margin:50px 50px">
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
<?php
$sesdet = explode('~', $fbdses);
		$academic_sess = $sesdet[0];
		if($academic_sess =='SUM'){
			$academic_ses = 'SUMMER';
		}else{
			$academic_ses = 'WINTER';
		}
			$academic_year = $sesdet[1];
?>
<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:18px;">Feedback Summary Report: <?=$academic_ses." (".$sesdet[1].")"?></h3></td>
<td></td>
</tr>
            
 </table>
            </td>
            </tr>

            <tr>
            <td style="padding:0;">
            <table class="content-table" width="800" cellpadding="0" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
			<tr>
            <td width="125"  height="30" valign="middle">&nbsp;<strong>Stream:</strong></td>
            <td height="30" valign="middle">&nbsp;<?=$StreamSrtName[0]['stream_short_name']?></td>
            <td width="125" height="30" valign="middle">&nbsp;<strong>Semester/Division:</strong></td>
            <td height="30" valign="middle">&nbsp;<?php echo $semester.'/'.$division.''.$batch; ?></td>
            </tr>
            
             </table>
           
            </td>
            </tr>
            
            
           <tr>
            <td class="marks-table"  align="left" width="800" height="600" style="padding:0;margin-top:10px">
            <table border="0"  align="left">
            <tr>
            <td valign="top" align="left">
           <table class="content-table" width="800" cellpadding="5" cellspacing="5" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
							
							<thead>
							  <tr>
									<th align="center"><span>Sr.No</span></th>
									<th align="center"><span>Subject Name</span></th>
									<th align="center"><span>Faculty Name</span></th>
									<th align="center"><span>Status</span></th>
									<th align="center"><span>#Feedback</span></th>
									<th align="center"><span>Marks</span></th>
									<th align="center"><span>Outoff</span></th>
									<th align="center"><span>%Per</span></th>
									
									
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								$j=0;
								$i=1;
								$sum_marks=0;
								$sum_totmarks = 0;									
								if(!empty($questions)){
									foreach($questions as $que){
										$queNo ='Q'.$i;	
										$sum_marks+=$marks[$j][$queNo];
										$sum_totmarks+=$marks[$j]['quecnt'] *5;
										unset($queNo);
									}
								}
								
								if(!empty($sub)){
										
									foreach($sub as $sb){
										$stud_details = $streamId.'~'.$semester.'~'.$division.'~'.$sb['subject_code'].'~'.$sb['faculty_code'];
										if($sb['gender']=='male'){
											$sex = 'Mr.';
										}else{
											$sex = 'Mrs.';
										}	
										$mrks = $sb['mrks'][0]['Tot_marks'];
										$outoff =$sb['fb'][0]['STUD_CNT']*90;									
										?>
									<tr>
										
											<td align="center"><?=$i?></td>
											<td><?=$sb['subject_name']?></td>
											<td><?=$sex.' '.$sb['fname'].' '.$sb['mname'].' '.$sb['lname']?></td>
											<td> 
												<?php 
												if($sb['fb'][0]['feedback_id'] !=''){
													?>
													<button class="btn btn-success">Submitted</button>
													<!--a href="<?=base_url()?>Feedback/view/<?=base64_encode($stud_details)?>"><button class="btn btn-success">View</button></a-->
													<?php
												}else{?>
													<button class="btn btn-danger">Feedback Form</button>
													<?php	}
												?>
											</td>
											<td align="center"><?php if($sb['fb'][0]['STUD_CNT'] !=''){ echo $sb['fb'][0]['STUD_CNT'];}?></td>
											<td align="center"><?=$mrks?></td>
											<td align="center"><?=$outoff?></td>
											<td align="center"><?=round($mrks/$outoff * 100);?>%</td>
			
											
										</tr>
									
										<?php 
										//} 
										unset($mrks);
										unset($outoff);
										$i++;
									}
								}else{
									echo "<tr><td colspan=6>No data found.</td></tr>";
								}
								?>
								
								</tbody>
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
