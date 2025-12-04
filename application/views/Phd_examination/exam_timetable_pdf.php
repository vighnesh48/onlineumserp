<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exam Time table</title>
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
            width: 100%;height:650px;
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

				<?php 	
					if(!empty($strms)){
						//echo "<pre>";
						//print_r($strms);//exit;
						$i=0;
				foreach($strms as $strm){
				?>	
<table cellpadding="0" cellspacing="0" border="1" width="100%" class="cell-padding">
<tr>
<td align="left" width="15%"><strong>Department :</strong></td>
<td><?=$strm['stream_name']?></td>
<td align="left" width="10%"><strong>Batches :</strong></td>
<td colspan='2'><?php $str_bth=''; foreach($strm['batches'] as $bt){ $str_bth .=$bt['batch'].', ';} echo rtrim($str_bth,', '); ?></td>

</tr> 

<tr>
<td><strong>F.N/A.N :</strong></td>
<td colspan='4'><?php $str_slot=''; foreach($strm['slots'] as $st){
	$str_slot .= $st['from_time'].' - '.$st['to_time'].', ';
	}
	echo rtrim($str_slot,', ');
	?>
</td>

</tr> 

</table> 
  <br>          
<table border="1" class="content-table" width="800" height="800">
    <tr>
	<th>Sem</th>
	<th align="left">Course Code & Name</th>
	<th>Date</th>
	<th>Session</th>
    </tr>

<?php

	foreach($strm['subjects'] as $sb){
		if($sb['from_time']=='10:00:00' && $sb['to_time']=='01:00:00'){
			$ses = 'F.N';
		}else{
			$ses = 'A.N';
		}
?>
<tr>
	<td align="center"><?=$sb['semester']?></td>
	<td align="left"><?=$sb['subject_code'].'-'.$sb['subject_name'];?></td>
	<td align="center"><?=date('d-m-Y',strtotime($sb['date']))?></td>	
	<td align="center"><?=$ses;?></td>	
</tr>

<?php 
	}
	$i++;
	?></table><br><?php
	
				}
					}
?>

            
</body>
</html>
