<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BANK REPORT</title>
   <style>
	   @font-face {
         font-family: "Cambria";
         src: url("font/Cambria-Font-For-Windows.ttf") format("truetype");
         font-weight: normal;
         font-style: normal;
         }
	  
	  body{font-size:11px;font-family: "Cambria";}
         table td{padding:5px;font-family: "Cambria";}
		 
      </style>
</head>

<body>
<div class="col-lg-12">
<?php include('pdf_header.php'); ?>

<?php 
$tsoc1 = array_column($visit_sal, 'net_pay');
$total_salary = format_inr(array_sum($tsoc1));

?>
</div><br>
<div style="text-align:left;margin-left:50px;"><b> To,</div>
 <div style="text-align:left;margin-left:50px;"><b>The Branch Manager,<br/>
HDFC Bank,<br/> Sandip Foundation Branch<br/>Nashik.
</b></div><br/>
<div style="text-align:left;margin-left:50px;">Subject : Regarding the Remuneration for Visiting Faculties_Odd Sem for the month of <u><?php echo strtoupper(date('F Y', strtotime($dt))); ?></u></div><br/><div style="text-align:left;margin-left:50px;">Dear Sir/Madam,</div><br/>		
<div style="text-align:left;margin-left:50px;">Find enclosed Cheque No. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dt. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; of Rs. <b><?php echo $total_salary; ?></b>&nbsp;&nbsp;towards Remuneration <br> for visiting Faculties_odd sem for the month of <b><u><?php echo strtoupper(date('F Y', strtotime($dt))); ?></u></b><br/></div><br/>
	<div style="width:85%;margin-left:3px;margin-left: 50px" >
	Kindly arrange to transfer the amount to their respective Bank Accounts.
	<table  border="1" style="page-break-inside:always;width:50%;" id="saltab"  width="100%"  cellpadding="3" cellspacing="0">
								  <thead>
								  <tr>
								  <th style="border: 1px solid black;width:10%;" width="3%"  ><b>Sr.No.</b></th>
								    <th style="border: 1px solid black;width:30%;padding:7px;text-align:left;" width="30%"><b>Name</b></th>
									<th style="border: 1px solid black;width:5%;" width="15%"><b>Bank Account No.</b></th>
                                      <th style="border: 1px solid black;width:5%;" width="10%" ><b>Amount</b></th>
									</tr></thead><tbody>		
<?php 

$j=7;
	  $i=1;
	  $tsoc = array();
foreach($visit_sal as $val){ ?>
 <tr>
	    <td style='text-align:center;'><?php echo $i;?></td>	
		  <td><?php echo $val['fullname'];?></td>
			<td ><?php echo $val['bank_acc_no']; ?></td>
			  <td style='text-align:right;'><?php echo format_inr($val['net_pay']);?></td>
				</tr>	
	 <?php  $tsoc[] = $val['net_pay']; 
	 	  $i++;
	  $j++;
 } ?>
<tr>
 <td colspan='3' style='text-align:right;'><b>TOTAL AMOUNT IN RS. :-</b></td><td style='text-align:right;'><?php echo format_inr(array_sum($tsoc));?></td>
	</tr>
	</tbody>
	  </table>
	  <?php include('pdf_footer.php'); ?>
	  </div>
	
</body>
</html>
