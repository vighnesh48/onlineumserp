<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Marks Details</title>
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
  <table width="700" border="0" cellspacing="0" cellpadding="0" height="100%" style="font-size:13px;">
            <tbody>  
            <tr>
            <td valign="top"  height="40">
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="800">
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
<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:12px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br><u>END SEMESTER EXAMINATION REVAL MARKS ENTRY - <?=$exam_month?> <?=$exam_year?></u></h3></td>
<td></td>
</tr>           
 </table>
            </td>
            </tr>

            <tr>
            <td style="padding:0;">
            <table class="content-table" width="800" cellpadding="5" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;margin-top:10px;">
			<tr>
            <td height="30" valign="middle">&nbsp;<strong>Program/Sem:</strong></td>
            <td height="30" valign="middle" colspan='3'>&nbsp;<?=$StreamSrtName[0]['stream_name']?> / <?=$me[0]['semester']?></td>
            </tr>
            <tr>
            <td width="120" height="30">&nbsp;<strong>Course:</strong></td>
            <td height="30" colspan='3'>&nbsp;<?=strtoupper($ut[0]['subject_code'])?> - <?=strtoupper($ut[0]['subject_name'])?></td>
            </td>
            </tr>           
             </table>          
            </td>
            </tr>           
           <tr>
            <td class="marks-table"  align="left" width="800" height="600" style="padding:0;margin-top:10px">
            <table border="0"  align="left">
            <tr>
            <td valign="top" align="left">
            <table  border="0" width="250" class="content-table" cellpadding="5" cellspacing="5">
            
			<tr>
			<th style="border-top:1px solid #000" align="left">Sr.No</th>
			<th style="border-top:1px solid #000" align="left">PRN</th>
			<th  style="border-top:1px solid #000" align="left">INT</th>	
            <th  style="border-top:1px solid #000" align="left">RV</th> 		
            
            </tr>
             <?php
			$count=0;
			$count_AB=0;
			$k=1;
            $i=0;
				if(!empty($mrks)){
					foreach($mrks as $stud){
						if($count ==20) {
							$count =0;
                echo "</table></td><td valign='top'><table class='content-table' cellpadding='5' cellspacing='5' width='250'>
				<tr><th style='border-top:1px solid #000' align='left'>Sr.No</th><th style='border-top:1px solid #000' align='left'>PRN</th><th style='border-top:1px solid #000' align='left'>INT</th><th style='border-top:1px solid #000' align='left'>EXT</th></tr>
				";
			}
			?>
            <tr>
            <td align="center"><?=$k?></td>
            <td align="center"><?=$stud['enrollment_no']?></td>
           <td align="center"><?=$stud['marks']?></td>
           <td align="center"><?=$stud['reval_marks']?></td>
            </tr>
			<?php 

			if($stud['marks']=='AB'){
				$count_AB++;
			}
			$k++;
            $i++;
			$count++;

            }
				}
			?>
            </table>
            </td>
            </tr>
            </table>            
            </td>
            </tr>			
			<tr>
            <td align="center" style="">
           
          <table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:40px;">
  <tr>
    <td align="center">
    <table width="800" border="0" cellspacing="0" cellpadding="0" align="center"> 
  <tr>
    <td align="center" class="signature" valign="bottom" ><strong>No.of Present :</strong> <?=count($mrks)-$count_AB;?></td>
    
    <td align="center"  class="signature" valign="bottom"><strong>No.of. Absent :</strong> <?=$count_AB?></td>
   
    <td align="center" class="signature" valign="bottom"><strong>Total :</strong> <?=count($mrks);?></td>
			  </tr>
			</table>
				</td>
			  </tr>
			</table>         
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
    <td align="center" height="50" class="signature"><strong>Entry By</strong></td>
    <td align="center" height="50" class="signature"><strong>Veryfied By</strong></td>
    <td align="center" height="50" class="signature"><strong>Approved By</strong></td>
   
			  </tr>
			</table>
				</td>
			  </tr>
			</table>
            </td>
            </tr>
			 <tr>
            <td align="center">
            <table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
         <tr>
    <td align="center">
    <table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  
       <tr>
    <td align="center" height="50" class="signature"><strong>Entry Date</strong></td>
    <td align="center" height="50" class="signature"><strong>Veryfied Date</strong></td>
    <td align="center" height="50" class="signature"><strong>Approved Date</strong></td>
   
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
