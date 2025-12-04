<!DOCTYPE html>
<html>
<head>
	<link href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css' rel='stylesheet' id='bootstrap-css'>
<script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js'></script>
<script src='//code.jquery.com/jquery-1.11.1.min.js'></script>
<!------ Include the above in your HEAD tag ---------->

<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
<script src='http://getbootstrap.com/dist/js/bootstrap.min.js'></script>
<style>
	
td 
{
	height: 30px; 
	width: 30px;
}

#cssTable td 
{
	text-align: center; 
	padding-left:4px; 
	vertical-align: middle;
}
#cssTable th 
{
	text-align: center; 
	vertical-align: middle;
}
#maintable p 
{
	font-size: 20px;
}
</style>
</head>
<body>

 <div class='table-responsive'>
 	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="maintable" >
  <tr>
    <td align="center">
    <img src="http://sandipuniversity.com/erp/assets/images/logo_form.png" width="300" />
    <p style="margin-top:0"><strong>Mahiravani, Trimbak Road, Nashik – 422 213,</strong></p><br/>
    	  <p style="margin-top:20; font-size:18px !important;"><b><?php echo $school_name;?>.</b></p>

    </td>
  </tr>
</table>
<br/>
<table id='mytable' class='table table-bordred table-striped' border='1' id='cssTable'>
		<thead>
		<tr>	
		<th>S.No</th>
		<th>School Code</th>
		<th>Stream Name</th>
		<th>Semester</th>
		<th>Status</th>
		</tr>
		</thead><tbody id='studtbl'>

	<?php 
	$l=1;
	
	if(!empty($pdfarray))
	{

		for($m=0; $m<count($pdfarray);$m++)
		{
			$school_code=$pdfarray[$m][0];
			
			$stream_name=$pdfarray[$m][1];
			$semester=$pdfarray[$m][2];
			$entry_status=$pdfarray[$m][3];
			?>
			
			<tr>
			<td><?=$l;?></td>
			<td><?=$school_code;?></td>
			<td><?=$stream_name;?></td>
			<td><?=$semester;?></td>
			<td><?=$entry_status;?></td>
			</tr>
			<?php 
				$l++;
		}
		
	} ?>
</tbody>
</table>
</div>

</body>
</html>
