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
<div style="white-space: nowrap;line-height:20px;text-align:center;padding:10px;"><span style="border-bottom:1px solid #333;padding-bottom:10px;"><strong> Employee leave list for Academic year <?php echo $yer; ?></strong></span></div>
			 		
<table  border="1" style="page-break-inside:always;" id="saltab" class="table table-bordered table-hover" width="100%"  cellpadding="3">
								  <thead>
								  <tr>
								  <th rowspan='2'><b>Sr.No.</b></th>
								   <th rowspan='2'><b>Emp ID.</b></th>
								   <th rowspan='2'><b>Name.</b></th>
								   <th rowspan='2'><b>School</b></th>
								   <th rowspan='2'><b>Department</b></th>
								      <th colspan="2"><b>CL</b></th>
<th colspan="2"><b>EL</b></th>	
<th colspan="2"><b>ML</b></th>	
<th colspan="2"><b>VL</b></th>	
<th colspan="2"><b>SL</b></th>	
<th colspan="2"><b>C-OFF</b></th>	
<th colspan="2"><b>LEAVE</b></th>										  
						</tr>
						<tr>
						<th><b>A</b></th>
    <th><b>U</b></th>
    <th><b>A</b></th>
    <th><b>U</b></th>
	<th><b>A</b></th>
    <th><b>U</b></th>
	<th><b>A</b></th>
    <th><b>U</b></th>
	<th><b>A</b></th>
    <th><b>U</b></th>
	<th><b>A</b></th>
    <th><b>U</b></th>
	<th><b>A</b></th>
    <th><b>U</b></th>
						</tr>						
						</thead><tbody>		
					  <?php  $i = 1;
					  $ci =&get_instance();
   $ci->load->model('admin_model');
   if(!empty($emp_leave_allocation)){
					  foreach($emp_leave_allocation as $val) {
						  $emp = $ci->admin_model->getEmployeeById($val['employee_id']);	
						   if($emp[0]['gender'] == 'male'){
$g = 'Mr.';
}elseif($emp1[0]['gender'] == 'female'){
$g = 'Mrs.';
}
 $cl = $this->load->leave_model->get_emp_leaves($val['employee_id'],'CL',$yer);
                            $el = $this->load->leave_model->get_emp_leaves($val['employee_id'],'EL',$yer);
                           $ml = $this->load->leave_model->get_emp_leaves($val['employee_id'],'ML',$yer);
                           $vl = $this->load->leave_model->get_emp_leaves($val['employee_id'],'VL',$yer);
                           $sl = $this->load->leave_model->get_emp_leaves($val['employee_id'],'SL',$yer);
                           $leave = $this->load->leave_model->get_emp_leaves($val['employee_id'],'Leave',$yer);
                            $coff = $this->load->leave_model->get_emp_leaves($val['employee_id'],'C-OFF',$yer);
                         $department =  $ci->admin_model->getDepartmentById($emp[0]['department']); 
								 $school =  $ci->admin_model->getSchoolById($emp[0]['emp_school']); 
                              $lis = $this->load->leave_model->get_employee_leave_type($val['employee_id'],$val['academic_year']);  
						   if(!empty($lis)){
    foreach($lis as $val){
		if($val['leave_type']=='VL'){
		$vl_cnt[$val['employee_id']][] = $val['leaves_allocated'];
$vl_us_cnt[$val['employee_id']][] = $val['leave_used'];
		}
		if($val['leave_type']=='C-OFF'){
			$cff[$val['employee_id']][]= $val['leave_used'];
		}

						   }}
						  echo "<tr>";
						  echo "<td>".$i."</td>";						  
						   echo "<td>".$val['employee_id']."</td>";
						   echo "<td>".$g." ".$emp[0]['fname']." ".$emp[0]['lname']."</td>";
						    echo "<td>".$school[0]['college_code']."</td>";
							 echo "<td>".$department[0]['department_name']."</td>";
						   echo "<td>";
						   if(isset($cl[0]['leaves_allocated'])){ echo $cl[0]['leaves_allocated']; }else{echo '-'; }
							   echo "</td>"; 
                             echo "<td>";
							 if(isset($cl[0]['leave_used'])){ echo $cl[0]['leave_used']; }else{ echo '-'; }							 
							 echo "</td>                                 
                                <td>";
								if(isset($el[0]['leaves_allocated'])){ echo $el[0]['leaves_allocated']; }else{ echo "-"; } echo "</td> 
                                <td>";
								if(isset($el[0]['leave_used'])){ echo $el[0]['leave_used']; }else{ echo '-'; } echo "</td>                               
                                <td>";
								if(isset($ml[0]['leaves_allocated'])){ echo $ml[0]['leaves_allocated']; }else{ echo "-"; } echo "</td> 
                                <td>";
								if(isset($ml[0]['leave_used'])){ echo $ml[0]['leave_used']; }else{ echo "-"; } echo "</td>                                
                                <td>";
								if(empty(array_sum($vl_cnt[$val['employee_id']]))){ echo '-'; }else{ echo array_sum($vl_cnt[$val['employee_id']]); } echo "</td>  
                                 <td>";
								if(empty(array_sum($vl_us_cnt[$val['employee_id']]))){ echo "-"; }else{ array_sum($vl_us_cnt[$val['employee_id']]); } echo "</td>
                                 <td>";
								 if(isset($sl[0]['leaves_allocated'])){ echo $sl[0]['leaves_allocated']; }else{ echo "-"; } echo "</td> 
                                 <td>";
								 if(isset($sl[0]['leave_used'])){ echo $sl[0]['leave_used']; }else{ echo '-'; } echo "</td>                                
                                <td>";
								if(isset($coff[0]['leaves_allocated'])){ echo $coff[0]['leaves_allocated']; }else{ echo "-"; } echo "</td>  	
                                <td>";
								if(!empty(array_sum($cff[$val['employee_id']]))){ echo array_sum($cff[$val['employee_id']]); }else{ echo "-"; } echo "</td> 								
                                   <td>";
								 if(isset($leave[0]['leaves_allocated'])){ echo $leave[0]['leaves_allocated']; }else{ echo "-"; } echo "</td>     
                                   <td>";
								  if(isset($leave[0]['leave_used'])){ echo $leave[0]['leave_used']; }else{ echo "-"; } echo "</td>      
								</tr>";
								 $i++;
					  }
   }else{
echo "<tr  style='color:red;'><td colspan='18'>No Records found</td></tr>";
   }   ?>

	</tbody>
	  </table>
	
</body>
</html>
