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
<tr>
<td></td>
<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:18px;">Facultywise Feedback Report11: <?=$academic_ses.'-'.$academic_year;?> </h3></td>
<td></td>
</tr>
            
 </table>
            </td>
            </tr>

            <tr>
            <td style="padding:0;">
            <table class="content-table" width="800" cellpadding="0" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
			<tr>
            <td height="30" width="150" valign="middle">&nbsp;<strong>Faculty Name:</strong></td>
            <td height="30" valign="middle" colspan="2">&nbsp;<?=$fac[0]['fac_name']?></td>
            
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
									<th align="center"><span>Sem</span></th>
									<th align="center"><span>Stream</span></th>
									<th align="center"><span>#Feedback</span></th>
									<th align="center"><span>Marks</span></th>
									<th align="center"><span>Outoff</span></th>
									<th align="center"><span>%Per</span></th>
									
									
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								$j=1;
								
								//echo "<pre>";
								//print_r($sub);exit;
								//echo count($subjects);exit;
								if(!empty($sub)){
										
									for($i=0;$i<count($subjects); $i++){
		
										$mrks = $sub['mrks'][$i][0]['Tot_marks'];//exit;
										$outoff =$sub['mrks'][$i][0]['STUD_CNT']*90;									
										?>
									<tr>
										
											<td align="center"><?=$j?></td>
											<td><?=$sub[$i]['subject_short_name']?></td>
											<td align="center"><?=$sub[$i]['semester']?></td>
											<td><?=$sub[$i]['stream_code']?></td>
											<td align="center"><?php if($sub['mrks'][$i][0]['STUD_CNT'] !=''){ echo $sub['mrks'][$i][0]['STUD_CNT'];}?></td>
											<td align="center"><?=$mrks?></td>
											<td align="center"><?=$outoff?></td>
											<td align="center"><?=round($mrks/$outoff * 100);?>%</td>
			
											
										</tr>
									
										<?php 
										//} 
										unset($mrks);
										unset($outoff);
										$j++;
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
