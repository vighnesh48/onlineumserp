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
    <td valign="top" align="right" style="width:50%;"><img align="right" src="<?php echo site_url();?>assets/images/lg.png" alt="Sandip University" class="img-responsive"></td>
    <td valign="top" align="center" style="width:50%;">
    <span style="font-size:25px;text-align:center"><b>Sandip University</b></span><br>
    <span style="text-align:center;font-size:11px">Trimbak Road, Mahiravani, Nashik – 422 213</span><br>
    <span style="font-size:10px;text-align:center">http://www.sandipuniversity.edu.in | Email : info@sandipuniversity.edu.in </span><br>
    <span style="font-size:13px;;text-align:center"><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></span>
    </td>
  </tr>
</table>
<hr  style="border-width:1px;">
</div>
<div style="white-space: nowrap;line-height:20px;text-align:center;padding:10px;"><span style="border-bottom:1px solid #333;padding-bottom:10px;"><strong>Leave Monthly Report <?php echo date('M Y',strtotime($dt));?></strong></span></div>
			 		
<table  border="1" style="page-break-inside:always;" id="saltab" class="table table-bordered table-hover" width="100%"  cellpadding="3">
								  <thead>
								  <tr>
								  <th style="border: 1px solid black;padding:20px;"  ><b>Sr.No.</b></th>
								   <th style="border: 1px solid black;text-align:center;padding:20px;"  ><b>Application No.</b></th>
								    <th style="border: 1px solid black;text-align:center;padding:20px;"><b>Application Date</b></th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>Employee Id</b></th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>Employee Name</b></th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>School</b></th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>Department</b></th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>Leave Type</b></th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>Form Date</b></th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>To Date</b></th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>No. Of Days</b></th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>Reason</b></th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>Reporting Officer1</b> </th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>Reporting Officer1 <br>Recomm. Date Time</b></th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>Reporting Officer1 Remark</b></th>
<th style="border: 1px solid black;text-align:center;padding:20px;"><b>Reporting Officer2 </b></th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>Reporting Officer2</b> <br><b>Recomm. Date Time</b></th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>Reporting Officer2 Remark</b></th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>Reporting Officer3</b> </th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>Reporting Officer3 <br>Recomm. Date Time</b></th>
					  <th style="border: 1px solid black;text-align:center;padding:20px;"><b>Reporting Officer3 Remark</b></th>
					  <th><b>Status</b></th>				
						</tr></thead><tbody>		
					  <?php  $i = 1;
					  $ci =&get_instance();
   $ci->load->model('leave_model');
   if(!empty($app_data)){
					  foreach($app_data as $val) {
						  $emp = $ci->leave_model->fetchEmployeeData($val['emp_id']);
						   if($emp[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($emp1[0]['gender'] == 'female'){
$g = 'Mrs.';
}
$empr1 = $ci->leave_model->fetchEmployeeData($val['emp1_reporting_person']);
						   if($empr1[0]['gender'] == 'male'){
$g1 = 'Mr.';
}elseif($empr1[0]['gender'] == 'female'){
$g1 = 'Mrs.';
}else{
	$g1 ='';
}
$empr2 = $ci->leave_model->fetchEmployeeData($val['emp2_reporting_person']);
						   if($empr2[0]['gender'] == 'male'){
$g2 = 'Mr.';
}elseif($empr2[0]['gender'] == 'female'){
$g2 = 'Mrs.';
}else{
	$g2 ='';
}
$empr3 = $ci->leave_model->fetchEmployeeData($val['emp3_reporting_person']);
						   if($empr3[0]['gender'] == 'male'){
$g3 = 'Mr.';
}elseif($empr3[0]['gender'] == 'female'){
$g3 = 'Mrs.';
}else{
	$g3 ='';
}
						  echo "<tr>";
						  echo "<td>".$i."</td>";
						  echo "<td>".$val['lid']."</td>";
						   echo "<td>".date('d-m-Y',strtotime($val['applied_on_date']))."</td>";
						   echo "<td>".$val['emp_id']."</td>";
						   echo "<td>".$g." ".$emp[0]['fname']." ".$emp[0]['lname']."</td>";
						    echo "<td>".$val['college_code']."</td>";
							 echo "<td>".$val['department_name']."</td>";
						   echo "<td>"; 
                                        if($val['leave_type'] == 'lwp' || $val['leave_type'] == 'LWP'){
                                            //echo 'LWP';
                                     echo $l = $ci->leave_model->getLeaveTypeById1('9');
                                    }elseif($val['leave_type'] == 'official'){
echo "OD";
									}else{
                          $lt = $ci->leave_model->getLeaveTypeById($val['leave_type']);
                                   if($lt == 'VL'){
                                  $cnt =  $ci->leave_model->get_vid_emp_allocation($val['leave_type']);
                                        
        echo $lt." - ".$cnt[0]['slot_type']." ";    
        }else{
            echo $lt;
        }                                    }
                                       echo "</td>";
						   echo "<td>".date('d-m-Y',strtotime($val['applied_from_date']))."</td>";
						   echo "<td>".date('d-m-Y',strtotime($val['applied_to_date']))."</td>";
						   echo "<td>".$val['no_days']."</td>";
						   echo "<td>".$val['reason']."</td>";
						   //echo "<td>".$val['applied_from_date']."</td>";
						   echo "<td>".$g1." ".$empr1[0]['fname']." ".$empr1[0]['lname']."</td>";
							  if(!empty($val['emp1_reporting_date'])){
							  	echo "<td>".date('d-m-Y H:i:s',strtotime($val['emp1_reporting_date']))."</td>";
								}else{
									echo "<td></td>";
								}
							   echo "<td>".$val['emp1_reporting_remark']."</td>";
							    echo "<td>".$g2." ".$empr2[0]['fname']." ".$empr2[0]['lname']."</td>";
								if(!empty($val['emp2_reporting_date'])){
							  	echo "<td>".date('d-m-Y H:i:s',strtotime($val['emp2_reporting_date']))."</td>";
								}else{
									echo "<td></td>";
								}
							  echo "<td>".$val['emp2_reporting_remark']."</td>";
							    echo "<td>".$g3." ".$empr3[0]['fname']." ".$empr3[0]['lname']."</td>";
								if(!empty($val['emp3_reporting_date'])){
							  echo "<td>".date('d-m-Y H:i:s',strtotime($val['emp3_reporting_date']))."</td>";
							  }else{
									echo "<td></td>";
								}
							  echo "<td>".$val['emp3_reporting_remark']."</td>";
								 echo "<td>".$val['fstatus']."</td>";
								 echo "</tr>";
								 $i++;
					  }
   }else{
echo "<tr  style='color:red;'><td colspan='17'>No Records found</td></tr>";
   }   ?>

	</tbody>
	  </table>
	
</body>
</html>
