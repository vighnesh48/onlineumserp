<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div class="col-lg-12">
<?php include('pdf_header.php'); ?>
<hr  style="border-width:1px;">

</div>
<div style="text-align:left;"><b>To,<br/>
The Branch Manager,<br/>
HDFC Bank Ltd, Sandip Foundation<br/>
Branch,Mahiravani ,Nashik.</b></div><br/>
<div style="text-align:center;"><b>Subject: Salary Transfer Letter for the Month of <?php echo date('M Y',strtotime($dt));?></b></div><br/>
<div style="text-align:left;">Find enclosed Cheque No. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dt. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; of Rs.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; towards Salary of
employees for the month of <?php echo date('M Y',strtotime($dt)); ?><br/>Kindly arrange to transfer the amount to their respective Bank Accounts.</div><br/>
	<div style="width:80%;margin-left:50px;" >
	<table  border="1" style="page-break-inside:always;width:100%;" id="saltab"  width="100%"  cellpadding="3" cellspacing="0">
								  <thead>
								  <tr>
								  <th style="border: 1px solid black;width:10%;" width="10%"  ><b>Sr.No.</b></th>
								   <th style="border: 1px solid black;width:10%;" width="10%" ><b>Staff Id</b></th>
								    <th style="border: 1px solid black;width:30% !important;" width="30%"><b>Name of Staff</b></th>
									<th style="border: 1px solid black;width:5%;" width="5%"><b>Bank Account No.</b></th>
<th style="border: 1px solid black;width:5%;" width="5%" ><b>Net Pay</b></th>
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
									  <td><?php echo $val['bank_acc_no']; ?></td>
					<td><?php echo $val['final_net_sal'];?></td>
				</tr>	
	 <?php  $tsoc[] = $val['final_net_sal']; 
	 	  $i++;
	  $j++;
 } ?>
<tr>
 <td colspan='5' style='text-align:right;'><b>TOTAL AMOUNT IN RS. :-<?php echo array_sum($tsoc);?></b></td>
	</tr>
	</tbody>
	  </table></div>	 <br/><div>Thanks & Regards<br/>For Sandip University</div><br/><br/><br/><br/><b>Principal</b> 
	
</body>
</html>
