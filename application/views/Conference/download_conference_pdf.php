<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <style>
table {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.table tr td {
	padding: 3px;text-align:center;
}
table {
    border-collapse: collapse;
}
</style>

</head>
<body>
<div align="center"  class="m" style="padding:20px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
		<td width="33.3%" align="center" style="border-bottom:1px solid #000"><img src="<?=base_url('assets/images')?>/logo.jpg" />
		<p class="ps">Trimbak Road, Mahiravani, Nashik – 422 213</p>
		<p class="ps">www.sandipuniversity.edu.in | Email : info@sandipuniversity.edu.in </p>
		<p class="ps"><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></p>
		</td>
		
		<td width="33.3%" align="center" style="border-bottom:1px solid #000"><img src="<?=base_url('assets/images')?>/new-logo.png" />
		</td>
	   </tr>         
	</table>
	<p><h3 align="center"><u>Abstract Details</u></h3></p>
</div>

<div align="center"  class="m" style="padding:20px;">
	 

<table border="1" width="100%" cellspacing="0" cellpadding="0" class="table">

<tbody id="itemContainer">

<tr>
<th align="center">Paper ID</th>

<td align="left">ICEMELTS18/<?=$phd_data['id']?></td> </tr>
<tr class="myHead">

<th align="center" width="200">Author Name</th>
<td align="left"><?=$phd_data['participant_name']?></td>
</tr>
<tr>
<th align="center">Stream</th>

<td align="left"><?=$phd_data['stream']?></td>
</tr>
<tr>					
<th align="center">Mode</th>

<td align="left"><?=$phd_data['mode']?></td> </tr>
<tr>
<th align="center">Paper Title</th>

<td align="left"><?=$phd_data['paper_title']?></td> </tr>
<tr>
<th align="center">Affiliation</th>

<td align="left"><?=$phd_data['affiliation']?></td> </tr>

<tr>
<th align="center">Email</th>

<td align="left"><?=$phd_data['email']?></td> </tr>
<tr>
<th align="center">Keywords</th>
<td align="left"><?=$phd_data['keywords']?></td> </tr>

<tr>
<th align="center">Abstract</th>

<td align="left"><?=$phd_data['paper_abstract']?></td> </tr>

</tbody>
</table>
</br>
        
               
</div>    
</body>
</html>