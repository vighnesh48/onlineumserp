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
<div style="white-space: nowrap;line-height:20px;text-align:center;padding:10px;"><span style="border-bottom:1px solid #333;padding-bottom:10px;"><strong> Vacation Leaves Slot List for the Academic Year of  <?php echo $yer; ?></strong></span></div>
			 		
<table  border="1" style="page-break-inside:always;" id="saltab" class="table table-bordered table-hover" width="100%"  cellpadding="3">
								  <thead>
								  <tr>
								  <th><b>Sr.No.</b></th>
								   <th><b>Emp ID.</b></th>
								   <th><b>Name.</b></th>
								   <th><b>School</b></th>
								   <th><b>Department</b></th>
								      <th><b>Year</b></th>
<th><b>Vacation Type</b></th>	
<th><b>Slot</b></th>
<th><b>From Date</b></th>	
<th><b>To Date</b></th>
<th><b>Days</b></th>	
										  
						</tr>
												
						</thead><tbody>		
					  <?php  $i = 1;
					 
   if(!empty($vl_slot_emp)){
					  foreach($vl_slot_emp as $val) {
						  
						   if($val['gender'] == 'male'){
$g = 'Mr.';
}elseif($val['gender'] == 'female'){
$g = 'Mrs.';
}
 
						  echo "<tr>";
						  echo "<td>".$i."</td>";						  
						   echo "<td>".$val['employee_id']."</td>";
						   echo "<td>".$g." ".$val['fname']." ".$val['lname']."</td>";
						   echo "<td>".$val['college_code']."</td>";
						   echo "<td>".$val['department_name']."</td>";
						   echo "<td>".$val['academic_year']."</td>";
						   echo "<td>".$val['vacation_type']."</td>";
						   echo "<td>".$val['slot_type']."</td>";
						   echo "<td>".date('d-m-Y',strtotime($vl_slot_emp[$i]['from_date']))."</td>";
						   echo "<td>".date('d-m-Y',strtotime($vl_slot_emp[$i]['to_date']))."</td>";
						   echo "<td>".$val['no_days']."</td>";
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
