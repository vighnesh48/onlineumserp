<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TDS REPORT</title>
   <style>
	   @font-face {
         font-family: "Cambria";
         src: url("font/Cambria-Font-For-Windows.ttf") format("truetype");
         font-weight: normal;
         font-style: normal;
         }
	  
	  body{font-size:13px;font-family: "Cambria";}
         table td{padding:5px;font-family: "Cambria";}
		 
      </style>
</head>

<body>
<div class="col-lg-12">
<?php include('pdf_header.php'); ?>
					
</div>
<div style="white-space: nowrap;text-align:center;padding:10px;"><strong>TDS on Proff.of Visiting Faculty Remuneartion for the month of <?php echo strtoupper(date('F Y', strtotime($dt))); ?></strong></div>
			 		
<table  border="1" style="page-break-inside:always;margin-left:50px;" id="saltab" class="table table-bordered table-hover" width="95%"  cellpadding="5" cellspacing="0">
								  <thead>
								  <tr>
								  <th style="border: 1px solid black;padding:5px 10px;width:5%"  ><b>Sr.No.</b></th>
								    <th style="border: 1px solid black;padding:5px 10px;text-align:left;width:30%" ><b>Party Name</b></th>
									<th style="border: 1px solid black;text-align:center;padding:5px 10px;width:15%" ><b>PAN NO.</b></th>
									<th style="border: 1px solid black;text-align:center;padding:5px 10px;width:10%" ><b>Date</b></th>
									<th style="border: 1px solid black;text-align:center;padding:5px 10px;width:10%" ><b>Bill Amount</b></th>
									<th style="border: 1px solid black;text-align:center;padding:5px 10px;width:10%" ><b>Tds Amount</b></th>
									<th style="border: 1px solid black;text-align:center;padding:5px 10px;width:10%" ><b>Section</b></th>
									</tr></thead><tbody>		
<?php 

$j=7;
	  $i=1;
	  $tsoc = array();$tsoc1 = array();
foreach($visit_sal as $val){ 
 if($val['tds_amount'] >0) {
?>
 <tr>
	    <td style="text-align:center;"><?php echo $i;?></td>	
		  <td ><?php echo $val['fullname'];?></td>
		  <td ><?=$val['pan_card_no']? $val['pan_card_no'] : '-'; ?></td>
		   <td style='text-align:center;'><?php echo date('M-y', strtotime($val['month_of_sal'] . '-01')) ?></td>
		   <td style='text-align:right;'><?php echo format_inr($val['bill_amount']);?></td>
		   <td style='text-align:right;'><?php echo format_inr($val['tds_amount']);?></td>
		   <td style='text-align:center;'>194J</td>

	   <?php $tsoc[] = $val['tds_amount']; $tsoc1[] = $val['bill_amount']; ?>
				</tr>	
	 <?php
	 	  $i++;
	  $j++;
} } ?>
<tr>
 <td colspan='4' style='text-align:right;'><b>TOTAL AMOUNT IN RS. :-</b></td><td style='text-align:right;'><?php echo format_inr(array_sum($tsoc1));?></td><td style='text-align:right;'><?php echo format_inr(array_sum($tsoc));?></td><td></td>
	</tr>
	</tbody>
	  </table>
		    <br>
	  <br>
	  <br>
	  <br>
	  <br>
	<div style="width: 95%; margin-left: 50px; margin-top: 50px; font-size: 12px; font-weight: bold;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 25%; text-align: center;">PREPARED BY</td>
            <td style="width: 25%; text-align: center;">CHECKED BY</td>
            <td style="width: 25%; text-align: center;">VERIFIED BY</td>
            <td style="width: 25%; text-align: center;">APPROVED BY</td>
        </tr>
        <tr><td colspan="4" style="height: 60px;"></td></tr> <!-- space for signature -->
        <tr>
            <td style="text-align: center;">Nsk Accountant</td>
            <td style="text-align: center;">Nsk Accountant</td>
            <td style="text-align: center;">HO Accountant</td>
            <td style="text-align: center;">Registrar/Principal</td>
        </tr>
    </table>
</div>

<br>  
</body>
</html>
