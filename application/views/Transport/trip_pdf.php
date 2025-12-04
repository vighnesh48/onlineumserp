<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>  
            table {  
                font-family: arial, sans-serif;  
                border-collapse: collapse;  
                width: 100%; font-size:12px; xmargin:0 auto;
            }  
			td{vertical-align: top;}
            th .thstyle{text-align: right;}         
            .signature{
            text-align: center;
            }
			th{align:right}
            .marks-table{
            width: 100%;xxheight:650px;
            }
            p{padding:0px;margin:0px;}
            h1, h3{margin:0;padding:0}
            .marks-table td{height:30px;vertical-align:middle;}
            .marks-table th{height:30px;}
			.content-table tr td{border:1px solid #333;vertical-align:middle;}
			.content-table th{border-left:1px solid #333;border-right:1px solid #333;border-bottom:1px solid #333;}
			.content-table td{padding-left:8px;}
        </style>  

</head>
<body>
<div align="center"  class="m" style="padding:20px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
		<td align="center" style="border-bottom:1px solid #000"><img src="<?=base_url('assets/images')?>/logo.jpg" />
		<p class="ps">Trimbak Road, Mahiravani, Nashik – 422 213</p>
		<p class="ps">www.sandipuniversity.edu.in | Email : info@sandipuniversity.edu.in </p>
		<p class="ps"><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></p>
		
		</td> 
	   </tr>         
	</table>
	<br/>
	<table>
     <tr>
	<td valign="middle" align="center" class="hd" width="200">
	<p><h3 align="center"><u>Bus Trip Report (<?=$route=='summary'?'Summary':'Day'?>Wise)</u></h3></p>
    </td> 
   </tr>
</table>
</div>

<div align="center"  class="m" style="padding:20px;">

	<table class="content-table" border="1" >
		<thead>
			<tr >
			<th>S.No</th>
				<th>Bus Number</th>
				<th>Route Name</th>  
				<th>Date</th> 
				<?php
				
				if($route=='summary')
				{
				?>
				<th>No. Of Trip</th> 
				<?php } else {	?>
				<th>Time</th> 
				<th>Status</th> 
				<?php } ?>				
			</tr>
		</thead>
		<tbody id="studtbl">
		<?php
		$j=1;
		for($i=0;$i<count($trip_details);$i++)
		{
			?>
			<tr>
			<td><?=$j?></td>
			<td><?=$trip_details[$i]['bus_no']?></td>
			<td><?=$trip_details[$i]['route_name']?></td>
			<td><?=$trip_details[$i]['trip_date']?></td>
			<?php
				
				if($route=='summary')
				{
				?>
				<td><?=$trip_details[$i]['trip_count']?></td>
				<?php } else {	?>
				<td><?=$trip_details[$i]['trip_time']?></td>
				<td><?=$trip_details[$i]['status']?></td>
				<?php } ?>	
			
			</tr>
			<?php
			$j++;
		}
			?>
		</tbody>
	</table>  
</div>    
</body>
</html>