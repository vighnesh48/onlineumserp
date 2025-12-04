<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ATTENDANCE SHEET</title>
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

            <table  border="0" class="content-table" cellpadding="5" cellspacing="5">
            
			<tr>
			<th style="border-top:1px solid #000" align="left">Sr.No</th>
			<th style="border-top:1px solid #000" align="left">PRN</th>
			<th style="border-top:1px solid #000" align="left">Student Name</th>
			<th  style="border-top:1px solid #000" align="left">Student Signature(<small>Mark AB as Absent</small>)</th>			
            
            </tr>
             <?php
			 $dattime = date('d-m-Y H:i:s');
			$count=0;
		$i=1;$k=1;
				if(!empty($allbatchStudent)){
					foreach($allbatchStudent as $stud){
			//echo $stud['enrollment_no'];
			?>
            <tr>
            <td width="5%"><?=$k?></td>
            <td width="35%"><?=$stud['enrollment_no']?></td>
			<td><?=$stud['first_name'].' '.$stud['middle_name'].' '.$stud['last_name']?></td>
           <td width="25%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
			<?php 
			$k++;
				}
			}
			?>


            </table>
                    
 
</body>
</html>
