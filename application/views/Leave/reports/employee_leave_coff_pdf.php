<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Salary EPF</title>
</head>

<body>
<div class="col-lg-12">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" align="right" style="width:20%;"><img align="right" src="<?php echo site_url();?>assets/images/lg.png" alt="Sandip University" class="img-responsive"></td>
    <td valign="top" align="center" style="width:80%;">
    <span style="font-size:25px;text-align:center"><b>Sandip University</b></span><br>
    <span style="text-align:center;font-size:11px">Trimbak Road, Mahiravani, Nashik – 422 213</span><br>
    <span style="font-size:10px;text-align:center">http://www.sandipuniversity.edu.in | Email : info@sandipuniversity.edu.in </span><br>
    <span style="font-size:13px;;text-align:center"><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></span>
    </td>
  </tr>
</table>
<hr  style="border-width:1px;">
</div>
<div style="white-space: nowrap;line-height:20px;text-align:center;padding:10px;"><span style="border-bottom:1px solid #333;padding-bottom:10px;"><strong> Employee C-OFF list for a Month  <?php echo date(' F Y',strtotime('01-'.$mon)); ?></strong></span></div>
			 		
<table  border="1" style="page-break-inside:always;" id="saltab" class="table table-bordered table-hover" width="100%"  cellpadding="3">
								  <thead>
								  <tr>
								  <th><b>Sr.No.</b></th>
								   <th><b>Emp ID.</b></th>
								   <th><b>Name.</b></th>
								   <th><b>Date</b></th>
								   <th><b>Status</b></th>
								      <th><b>Credited By</b></th>
<th><b>Credited On</b></th>	
<th><b>Added By</b></th>										  
						</tr>
												
						</thead><tbody>		
					  <?php  $i = 1;
					 
   if(!empty($coffleave)){
					  foreach($coffleave as $val) {
						  
						   if($val['gender'] == 'male'){
$g = 'Mr.';
}elseif($val['gender'] == 'female'){
$g = 'Mrs.';
}
 $un = $this->leave_model->get_username($val['inserted_by']);
						  echo "<tr>";
						  echo "<td>".$i."</td>";						  
						   echo "<td>".$val['emp_id']."</td>";
						   echo "<td>".$g." ".$val['fname']." ".$val['lname']."</td>";
						   echo "<td>".date('d-m-Y',strtotime($val['date']))."</td>";
						   echo "<td>".$val['status']."</td>";
						   echo "<td>".$val['credited_by']."</td>";
						   echo "<td>".date('d-m-Y',strtotime($val['inserted_datetime1']))."</td>";
						   echo "<td>".$un[0]['username']."</td>";
						   echo "</tr>";
								 $i++;
					  }
   }else{
echo "<tr  style='color:red;'><td colspan='7'>No Records found</td></tr>";
   }   ?>

	</tbody>
	  </table>
	
</body>
</html>
