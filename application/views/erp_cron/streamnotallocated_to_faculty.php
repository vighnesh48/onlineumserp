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
 	<div>
 	<table width="100%" border="0" cellspacing="0" cellpadding="0"  id="maintable" >
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
		<th>#</th>	
		<th>Stream Name </th>
		<th>Subject Name</th>
		
		<th>Semester</th>
		<th>Division</th>
		<th>Batch no</th>
		<th>Faculty</th>
		</tr>
		</thead><tbody id='studtbl'>

	<?php 
	$l=1;
	
	if(!empty($pdfarray))
	{

		for($m=0; $m<count($pdfarray);$m++)
		{
			
			$subject_code=$pdfarray[$m][1];
			$subject_name=$pdfarray[$m][2];
			$stream_name=$pdfarray[$m][3];
			$semester=$pdfarray[$m][4];
			$division=$pdfarray[$m][5];
			$batch_no=$pdfarray[$m][6];
			$faculty_code=$pdfarray[$m][7];
			?>
			
			<tr>
			<td><?=$l;?></td>
			
			<td><?=$stream_name;?></td>
			<td><?=$subject_code;?></td>
		
			<td><?=$semester;?></td>
			<td><?=$division;?></td>
			<td><?=$batch_no;?></td>
			<td>Not Assign</td>
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
