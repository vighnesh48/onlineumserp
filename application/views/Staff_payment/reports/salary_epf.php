<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Salary EPF</title>
</head>

<body>
<div class="col-lg-12">
<?php include('pdf_header.php'); ?>
<hr  style="border-width:1px;">

</div>
<div style="white-space: nowrap;text-align:center;padding:10px;"><strong>EPF DEDUCTION REPORT FOR THE MONTH OF <?php echo date('M Y',strtotime($dt));?></strong></div>
			 		
<table  border="1" style="page-break-inside:always;" id="saltab" class="table table-bordered table-hover" width="100%"  cellpadding="3" cellspacing="0">
								  <thead>
								  <tr>
								  <th style="border: 1px solid black;padding:10px;"  ><b>Sr.No.</b></th>
								   <th style="border: 1px solid black;text-align:center;padding:10px;"  ><b>Staff Id</b></th>
								    <th style="border: 1px solid black;padding:10px;"  ><b>Name of Staff</b></th>
									<th style="border: 1px solid black;text-align:center;padding:10px;" ><b>PF NO.</b></th>
<th style="border: 1px solid black;text-align:center;padding:10px;" ><b>Applicable Salary</b></th>
<th style="border: 1px solid black;text-align:center;padding:10px;" ><b>PF Amount</b></th>				
						</tr></thead><tbody>		
<?php 
$j=7;
	  $i=1;
	  $tsoc = array();
foreach($emp_sal as $val){ ?>
 <tr>
	    <td><?php echo $i;?></td>	
		 <td><?php echo $val['emp_id']; ?></td>
		  <td>
		  <?php if($val['gender']=='male'){
                                       echo 'Mr.';
									   }else if($val[$i]['gender']=='female'){ 
									   echo 'Mrs.';}
									  echo $val['fname']." ".$val['mname']." ".$val['lname'];?></td>
									   <td><?php echo $val['pf_no']; ?></td>
		  <?php if($val['epf']=='1800'){ ?>
			  <td>15,000</td>
		  <?php }else{ ?>
			<td><?php echo $val['basic_sal']; ?></td>
		 <?php } ?>
				<td><?php echo $val['epf']+$val['epf_er']; ?></td>
	<?php   $tsoc[] = $val['epf']+$val['epf_er']; ?>
				</tr>	
	 <?php
	 	  $i++;
	  $j++;
 } ?>
<tr>
 <td colspan='5' style='text-align:right;'><b>TOTAL AMOUNT IN RS. :-<?php echo array_sum($tsoc);?></b></td>
	</tr>
	</tbody>
	  </table>
	
</body>
</html>
