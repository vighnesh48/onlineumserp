<?php
use Aws\Exception\AwsException;
?>
<style>  
    
			table {  
				font-family: arial, sans-serif;  
				border-collapse: collapse;  
				width: 100%; 
				font-size: 12px; 
				margin: 0 auto;
			}  
			td{
				vertical-align: top;}
                      
			.signature{
				text-align: center;
			}
			.marks-table{
				width: 100%;
				height: 650px;
			}
			p{
				padding: 0px;
				margin: 0px;}
			h1, h3{
				margin: 0;
				padding: 0}
			.marks-table td{
				height: 30px;
				vertical-align: middle;}
			
			.marks-table th{
				height: 30px;}
			.content-table td{
				border: 1px solid #333;
				xpadding-left: 5px;
				vertical-align: middle;}
			.content-table th{
				border-left: 1px solid #333;
				border-right: 1px solid #333;
				border-bottom: 1px solid #333;}
		</style> 
<table width="100%" border="0" cellspacing="0" cellpadding="0"  style="border-spacing:0px" border-spacing="0">
<tr>
<td valign="top" align="center"  style="padding:5px 5px 5px" colspan="3">
    <img src="https://erp.sandipuniversity.com/assets/images/logo_form.png">
    
</td>
</tr>
<tr>
<td valign="top"  width="100%" colspan="3" align="center" style="font-size:12px;">
<strong>Mahiravani, Trimbak Road, Nashik - 422 213,</strong>
<strong>Website:</strong> https://www.sandipuniversity.edu.in<br>
<strong>Email:</strong> info@sandipuniversity.com,
<strong>Phone:</strong> (02594) 222541,42,43,44,45,
<strong>Fax:</strong> (02594) 222555
</td>
</tr>
</table>
<h3 style="padding:0px;margin:0px;">Student List</h3>
<table style="width:100%;"  border="1" cellspacing="0" cellpadding="3" align="center">
  <tr>
       <th align="left" width="40">Sr No.</th>
        <th align="left" width="50">PRN</th>
		 <th align="left" width="50">Photo</th>
        <th align="left">Name</th>
		<th align="left" width="55">Mobile No.</th>
        <th align="left">Courses</th>
		 <th align="left">Semester</th>
		  <th align="left">Year</th>
  </tr>
  <?php  $j=1;
		$count= (count($emp_list));			
        for($i=0;$i<$count;$i++)
          {		
   ?>
   <tr>
    <td ><?=$j?></td>
	<td><?=$emp_list[$i]['enrollment_no']?></td> 
	<td>
<?php
	try{
		$bucket_key = 'uploads/student_photo/'.$emp_list[$i]['enrollment_no'].'.jpg';
    $imageData = $this->awssdk->getsignedurl($bucket_key);
  }catch(AwsException $e){
  	$imageData = '';
  }

  ?>
  <img src="<?= $imageData ?>" alt="" width="50" height="50"/></td> 
	<td>

	<?php
	echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
	?>
	</td> 
	<td><?=$emp_list[$i]['mobile'];?></td>   
	<td><?=$emp_list[$i]['course_name']?></td> 
	<td><?=$emp_list[$i]['current_semester']?></td> 
	<td><?=$emp_list[$i]['current_year']?></td> 

	
  </tr>
 <?php $j++; } ?>
</table>