<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Salary EPF</title>
<style>body{font-size:11px;font-family: Arial, Helvetica, sans-serif;}</style>
</head>
<body>
<div class="col-lg-12">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" align="right" style="width:40%;"><img width="70" src="<?php echo site_url();?>assets/images/lg.png" alt="Sandip University" class="img-responsive"></td>
    <td valign="top" align="left"><h1 style="margin:0px;padding:0px;">Sandip University</h1>
    <p style="margin-top:0px;padding:0px;">Trimbak Road, Mahiravani, Nashik – 422 213<br>
    http://www.sandipuniversity.edu.in | Email : info@sandipuniversity.edu.in<br>
    <strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></p>
    </td>
  </tr>
</table>
<hr  style="border-width:1px;">
</div>
<?php if($ltyp =='od'){ ?>
<div style="white-space: nowrap;line-height:20px;font-size:15px;text-align:center;padding:10px;"><span style="border-bottom:1px solid #333;padding-bottom:10px;"><strong> Employee OD Application list for a Month  <?php echo date(' F Y',strtotime('01-'.$mon)); ?></strong></span></div>
	<?php }else{ ?>
<div style="white-space: nowrap;line-height:20px;font-size:15px;text-align:center;padding:10px;"><span style="border-bottom:1px solid #333;padding-bottom:10px;"><strong> Employee Leave Application list for a Month  <?php echo date(' F Y',strtotime('01-'.$mon)); ?></strong></span></div>

	<?php } ?>		 		
<table  border="1" style="page-break-inside:always;" id="saltab" class="table table-bordered table-hover" width="100%"  cellpadding="3">
								  <thead>
								  <tr>
								  <th><b>Sr.No.</b></th>
								   <th><b>Appl ID.</b></th> 
								   <th><b>Date & Time of <br/> Application.</b></th>
								    <th><b>Emp ID</b></th>
								   <th><b>Name of Applicant</b></th>
								   <th><b>School</b></th>
								   <th><b>Department</b></th>
								      <th><b>Leave Type</b></th>
<th><b>From Date</b></th>	
<th><b>To Date</b></th>
<th><b>No. of Days</b></th>
<th><b>Date & time of<br/>Forward by RO</b></th>
<th><b>Signature</b></th><th><b>Remark</b></th>											  
						</tr>												
						</thead><tbody>		
					  <?php  $i = 1;
				 //print_r($applicant_leave);exit;
   if(!empty($applicant_leave)){
					  foreach($applicant_leave as $val) {
						  
						   if($val['gender'] == 'male'){
$g = 'Mr.';
}elseif($val['gender'] == 'female'){
$g = 'Mrs.';
}
  if($val['leave_type'] == 'lwp' || $val['leave_type'] == 'LWP'){
                                            //echo 'LWP';
                                         $lt = $this->leave_model->getLeaveTypeById1('9');
                                    }else{
                                          $lt = $this->leave_model->getLeaveTypeById($val['leave_type']);
                                   if($lt == 'VL'){
                                  $cnt =  $this->leave_model->get_vid_emp_allocation($val['leave_type']);
            $lt = $lt." - ".$cnt[0]['slot_type']." ";    
        }else{
            $lt = $lt;
        }
									}
									
									 $uid = $this->session->userdata("name");
									if($val['emp1_reporting_person'] == $uid){							
								$st = $val['emp1_reporting_status'];
								$empr = '1';
									}elseif($val['emp2_reporting_person'] == $uid){									
									$st = $val['emp2_reporting_status'];
									$empr = '2';
									}elseif($val['emp3_reporting_person'] == $uid){									
									$st = $val['emp3_reporting_status'];
									$empr = '3';
									}elseif($val['emp4_reporting_person']==$uid){										
									$st = $val['emp4_reporting_status'];
									$empr = '4';
									}
 //$un = $this->leave_model->get_username($val['inserted_by']);
									//echo $sel;exit;
 if($sel == 'pending'){
	 if($empr != 1){
	 $r = $empr - 1;
	 }else{
		 $r = $empr;
	 }
	 if(empty($st) && !empty($val['emp'.$r.'_reporting_date']) && $val['emp'.$r.'_reporting_status'] != 'Rejected' ){
	 
						  echo "<tr>";
						  echo "<td>".$i."</td>";						  
						   echo "<td>".$val['lid']."</td>";
						    echo "<td>".date('d-m-Y H:i',strtotime($val['inserted_datetime']))."</td>";
						   echo "<td>".$val['emp_id']."</td>";
						   echo "<td>".$g." ".$val['fname']." ".$val['lname']."</td>";
						  
						   echo "<td>".$val['college_code']."</td>";
						    echo "<td>".$val['department_name']."</td>";
							if($ltyp =='od'){
echo "<td>OD</td>";
							}else{
						   echo "<td>".$lt."</td>";
						}
						      echo "<td>".date('d-m-Y',strtotime($val['applied_from_date']))."</td>";
						   echo "<td>".date('d-m-Y',strtotime($val['applied_to_date']))."</td>";
						   
if($ltyp =='od'){

if($val['leave_apply_type'] == 'OD' && $val['leave_duration'] == 'hrs'){ 
                                           echo '<td>'.$val['no_hrs'].' Hrs</td>';
                                          }else{ 
                                        echo '<td>'.$val['no_days'].'</td>';
                                      } 
}else{
						   echo "<td>".$val['no_days']."</td>";
						  }
						    echo "<td>".date('d-m-Y h:i',strtotime($val['emp'.$r.'_reporting_date']))."</td>";
							 echo "<td></td>"; echo "<td></td>";
						   echo "</tr>";
								 $i++;
								 unset($e);
 }}elseif($sel == 'approved'){
	    if($empr != 1){
	 $r = $empr - 1;
	 }else{
		 $r = $empr;
	 }
	 if(!empty($st)){
	 
						  echo "<tr>";
						  echo "<td>".$i."</td>";						  
						   echo "<td>".$val['lid']."</td>";
						    echo "<td>".date('d-m-Y H:i',strtotime($val['inserted_datetime']))."</td>";
						     echo "<td>".$val['emp_id']."</td>";
						   echo "<td>".$g." ".$val['fname']." ".$val['lname']."</td>";
						  
						   echo "<td>".$val['college_code']."</td>";
						    echo "<td>".$val['department_name']."</td>";
							
						   if($ltyp =='od'){
echo "<td>OD</td>";
							}else{
						   echo "<td>".$lt."</td>";
						}
						      echo "<td>".date('d-m-Y',strtotime($val['applied_from_date']))."</td>";
						   echo "<td>".date('d-m-Y',strtotime($val['applied_to_date']))."</td>";
						 if($ltyp =='od'){

if($val['leave_apply_type'] == 'OD' && $val['leave_duration'] == 'hrs'){ 
                                           echo '<td>'.$val['no_hrs'].' Hrs</td>';
                                          }else{ 
                                        echo '<td>'.$val['no_days'].'</td>';
                                      } 
}else{
						   echo "<td>".$val['no_days']."</td>";
						  }
						  
						    echo "<td>".date('d-m-Y h:i',strtotime($val['emp'.$r.'_reporting_date']))."</td>";
							 echo "<td></td>"; echo "<td></td>";
						   echo "</tr>";
								 $i++;
								 unset($e);
	 
					  } 
					  }else{
						    if($empr != 1){
	 $r = $empr - 1;
	 }else{
		 $r = $empr;
	 }
	 
						  echo "<tr>";
						  echo "<td>".$i."</td>";						  
						   echo "<td>".$val['lid']."</td>";
						    echo "<td>".date('d-m-Y H:i',strtotime($val['inserted_datetime']))."</td>";
						     echo "<td>".$val['emp_id']."</td>";
						   echo "<td>".$g." ".$val['fname']." ".$val['lname']."</td>";
						  
						   echo "<td>".$val['college_code']."</td>";
						    echo "<td>".$val['department_name']."</td>";
							
						  if($ltyp =='od'){
echo "<td>OD</td>";
							}else{
						   echo "<td>".$lt."</td>";
						}
						      echo "<td>".date('d-m-Y',strtotime($val['applied_from_date']))."</td>";
						   echo "<td>".date('d-m-Y',strtotime($val['applied_to_date']))."</td>";
						  if($ltyp =='od'){

if($val['leave_apply_type'] == 'OD' && $val['leave_duration'] == 'hrs'){ 
                                           echo '<td>'.$val['no_hrs'].' Hrs</td>';
                                          }else{ 
                                        echo '<td>'.$val['no_days'].'</td>';
                                      } 
}else{
						   echo "<td>".$val['no_days']."</td>";
						  }
						  if(!empty($val['emp'.$r.'_reporting_date'])){
						    echo "<td>".date('d-m-Y h:i',strtotime($val['emp'.$r.'_reporting_date']))."</td>";
						  }else{
							  echo "<td>--</td>";
						  }
							 echo "<td></td>"; echo "<td></td>";
						   echo "</tr>";
								 $i++;
								 unset($e);
	 
					  }	  
   }	  
   }else{
echo "<tr  style='color:red;'><td colspan='7'>No Records found</td></tr>";
   }   ?>

	</tbody>
	  </table>
	
</body>
</html>
