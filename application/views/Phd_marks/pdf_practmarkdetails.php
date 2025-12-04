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
<?php
if($streamId !='' && $streamId=='71'){
    $semname ='Year';
}else{
    $semname ='Semester';
}
?>

            <table  border="0" width="100%" class="content-table" cellpadding="5" cellspacing="5">
            
			<tr>
			<th style="border-top:1px solid #000" align="left">Sr.No</th>
			<th style="border-top:1px solid #000" align="left">PRN</th>
			<th style="border-top:1px solid #000" align="left">Student Name</th>
			<th  style="border-top:1px solid #000" align="left">MARKS</th>			
            
            </tr>
             <?php
			$count=0;
			$count_AB=0;
			$k=1;
				if(!empty($mrks)){
					foreach($mrks as $stud){
						/*if($count ==19) {
							$count =0;
                echo "</table></td><td valign='top' width='50%'><table class='content-table' cellpadding='5' cellspacing='5' width='100%'>
				<tr><th style='border-top:1px solid #000' align='left'>Sr.No</th><th style='border-top:1px solid #000' align='left'>PRN</th><th style='border-top:1px solid #000' align='left'>Student Name</th><th style='border-top:1px solid #000' align='left'>MARKS</th></tr>
				";
			}*/
			//echo $stud['enrollment_no'];
			?>
            <tr>
            <td><?=$k?></td>
            <td><?=$stud['enrollment_no']?></td>
			<td><?=$stud['first_name'].' '.$stud['middle_name'].' '.$stud['last_name']?></td>
           <td><?=$stud['marks']?></td>
            </tr>
			<?php 
			if($stud['marks']=='AB'){
				$count_AB++;
			}
			$k++;
			$count++;
				}
				}
			?>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top:25px;">
                <tr>
                    <td align="left" class="signature" valign="bottom" ><strong>No.of Present :</strong> <?=count($mrks)-$count_AB;?></td>
                    <td align="center"  class="signature" valign="bottom"><strong>No.of. Absent :</strong> <?=$count_AB?></td>
                    <td align="right" class="signature" valign="bottom"><strong>Total :</strong> <?=count($mrks);?></td>
                </tr>
                </table>

</body>
</html>
