<!DOCTYPE html>
<html>
   <head>
      <style>
         table, td, th {
         border: 1px solid #000;
         border-collapse: collapse;
         padding:4px;
         font-size:11px;
         line-height:20px;
         font-family: sans-serif;
         }
         p ,ul li,ol li{
         font-size:11px;
         line-height:20px;
         font-family: sans-serif;
         color:#000;
         }
         .tt1{background-color:#e0e8ff}
         .tt2{background-color:
         #fffaee}
      </style>
   </head>
   <body style="color:#000">
  
      <div  style=" width:800px;margin:0px auto;padding:8px 10px;overflow:hidden;height:auto">
         
         <div class="" style="font-family: sans-serif;float:left;width:100%;text-align:center"  
            >
            <img src="<?php echo base_url('assets/su_logo.jpg')?>"  alt="Sandip university" class="desktop-logo lg-logo ptrans" style="margin-bottom:10px;width:200px">
           
         </div>
         <div style="clear:both"></div>
		 
		 
         <hr/>
      
		 <div style="float:left;width:30%;padding-bottom:0px;text-align:center">
		 <p style="font-size:14px;font-weight:bold;text-align:left;margin-bottom:0 !important">OUT:SUN/REG/25-26/FS/ </p>
         </div>
         <div style="float:right;width:70%;padding-bottom:0px;text-align:right">
            <p style="font-size:12px"><strong>Date:</strong><?=date('d-m-Y') ?></p>
			<div>  <img src= "<?php echo base_url('uploads/bankletter/QRcode/'.$stud_id.'_BANKLETTER.png'); ?>" width="80" height="80" /><br>
                <!--<span style="font-size: 10px;">Verify at sandipfoundation.org</span>-->

</div>
         </div>
         <div style="clear:both"></div>
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
         <div style="clear:both"></div>
         <H1 align="center" style="font-size:16px" > TO WHOMSOEVER IT MAY CONCERN</h1>
		 
		 
		 
         <p style="text-align:justify!important">This is to certify that  <b><?= $first_name ?></b> (PRN No. <b><?= $enrollment_no ?></b>) has been provisionally admitted on merit basis to the <b><?= get_year_name($admission_year) ?></b> year  of the <b><?= ($course_duration) ?> year (<?= $stream_name ?>)</b> degree programme at <b>Sandip University, Nashik</b> for the academic year <b><?= get_academic_year_range($admission_session) ?></b>.</p>
		
         <p><strong>The approximate fee details are as follows:</strong>
         <table width="100%">
            <tbody>
               <tr class="tt1">
                  <td width="96" style="text-align:center">
                     <strong>Particulars</strong>
                  </td>
				  
				  <?php if($fefees >0  && $lateral_entry!='Y') { ?>
                  <td width="96" style="text-align:center">
                     <strong>First Year</strong>
                  </td>
				  <?php }?>
				  <?php if($sefees >0) { ?>
                  <td width="96" style="text-align:center">
                     <strong>Second Year</strong>
                  </td>
				    <?php }?>
					<?php if($tefees >0) { ?>
                  <td width="96" style="text-align:center">
                     <strong>Third Year</strong>
                  </td>
				  <?php }?>
				  <?php if($fofees >0) { ?>
                  <td width="96" style="text-align:center">
                     <strong>Fourth Year</strong>
                  </td>
				  <?php }?>
				  <?php if($fifees >0) { ?>
                  <td width="96" style="text-align:center">
                     <strong>Fifth Year</strong>
                  </td>
				  <?php }?>
				   <?php if($sifees >0) { ?>
                  <td width="96" style="text-align:center">
                     <strong>Sixth Year</strong>
                  </td>
				  <?php }?>
                  <td width="96" style="text-align:center">
                     <strong>Total</strong>
                  </td>
               </tr>
                <tr>
                  <td  class="tt2" style="text-align:center">
                     <strong>Applicable fee</strong>
                  </td>
				  <?php if($fefees >0 && $lateral_entry!='Y') { ?>
                  <td width="96" style="text-align:center">
                      <?= 'Rs.'.formatPlainCurrency($fefees); ?>
                  </td>
				  <?php }?>
				  <?php if($sefees >0) { ?>
                  <td width="96" style="text-align:center">
                     <?= 'Rs.'.formatPlainCurrency($sefees) ?>
                  </td>
				  <?php }?>
				  <?php if($tefees >0) { ?>
                  <td width="96" style="text-align:center">
                     <?= 'Rs.'.formatPlainCurrency($tefees) ?>
                  </td>
				  <?php }?>
				  <?php if($fofees >0) { ?>
                  <td width="96" style="text-align:center">
                    <?= 'Rs.'.formatPlainCurrency($fofees) ?>
                  </td>
				  <?php }?>
				  <?php if($fifees >0) { ?>
                  <td width="96" style="text-align:center">
                     <?= 'Rs.'.formatPlainCurrency($fifees) ?>
                  </td>
				  <?php }?>
				  <?php if($sifees >0) { ?>
                  <td width="96" style="text-align:center">
                    <?= 'Rs.'.formatPlainCurrency($sifees) ?>
                  </td>
				  <?php }?>
				  <?php if( $lateral_entry=='Y'){
					  $totalfees=$totalfees-$fefees;
				  }
				  ?>
				  
				  <td width="96" style="text-align:center">
                     <?= 'Rs.'.formatPlainCurrency($totalfees) ?>
                  </td>
               </tr>
            </tbody>
         </table>
         <p style="margin-bottom:0px!important;padding-bottom:0px!important"><strong> Additional Charges (One-Time / Optional)</strong></p>
         <ul style="margin-left:-20px;    margin-top: 0px;">
		 <?php if($uniform >0) { ?>
		 <li> <strong><?= 'Rs.'.formatPlainCurrency($uniform) ?></strong>&ndash; University Uniform</li>
		 
		 <?php }?>
		 <?php if($hostel >0) { ?>
		 <li> <strong><?= 'Rs.'.formatPlainCurrency($hostel) ?> </strong>&ndash; Hostel Security Deposit (Refundable)</li>
		 
		 <?php }?>
		 <?php if($caution >0) { ?>
		 <li> <strong><?= 'Rs.'.formatPlainCurrency($caution) ?> </strong>&ndash; Caution Money (Refundable)</li>
		 
		 <?php }?>
		  <?php if($admission_form >0) { ?>
		 <li> <strong><?= 'Rs.'.formatPlainCurrency($admission_form) ?></strong>&ndash;Admission Form &amp; Prospectus</li>
		 
		 <?php }?>
         
            <li>Transportation charges are applicable if opted.</li>
         </ul>
         <p><strong>Note:</strong></p>
         <ul style="margin-left:-20px;    margin-top: 0px;">
		 <?php
		 if($is_hostel_included=='Y') {
		 ?>
		  <li> Applicable fee includes Hostel fees and Mess fees</li>
		 
		 <?php } ?>
            <li> All fees are tentative and subject to revision by the University Management.</li>
            <li>Scholarship continuation is subject to attendance, academic performance, and conduct, and will be reviewed annually.</li>
         </ul>
         <p><strong> Payment Details:</strong> </p>
         <table width="100%">
            <tbody>
               <tr class="tt1">
                  <td width="22%">
                     <strong>Particulars</strong>
                  </td>
                  <td width="26%">
                     <strong>Academic Fees</strong>
                  </td>
                  <td width="26%">
                     <strong>Hostel Fees</strong>
                  </td>
                  <td width="26%">
                     <strong>Transport Fees</strong>
                  </td>
               </tr>
               <tr>
                  <td class="tt2">
                     <strong>Beneficiary Name</strong>
                  </td>
                  <td >
                     Sandip University
                  </td>
                  <td >
                     Sandip Foundation Hostel
                  </td>
                  <td >
                     Sandip Foundation Transportation
                  </td>
               </tr>
               <tr>
                  <td class="tt2">
                     <strong>Bank Name</strong>
                  </td>
                  <td >
                    ICICI BANK
                  </td>
                  <td >
                    ICICI BANK
                  </td>
                  <td >
                    ICICI BANK
                  </td>
               </tr>
               <tr>
                  <td class="tt2">
                     <strong>Branch</strong>
                  </td>
                  <td >
                     Mulund (W), Mumbai
                  </td>
                  <td >
                     Mulund (W), Mumbai
                  </td>
                  <td >
                     Mulund (W), Mumbai
                  </td>
               </tr>
               <tr>
                  <td class="tt2">
                     <strong>Account Type</strong>
                  </td>
                  <td >
                     Saving
                  </td>
                  <td >
                     Saving
                  </td>
                  <td >
                     Saving
                  </td>
               </tr>
               <tr>
                  <td class="tt2">
                     <strong>Account No.</strong>
                  </td>
                  <td >
                     623801144820
                  </td>
                  <td >
                     623801144822
                  </td>
                  <td >
                     623801144836
                  </td>
               </tr>
               <tr>
                  <td class="tt2">
                     <strong>IFSC Code</strong>
                  </td>
                  <td >
                     ICIC0006238
                  </td>
                  <td >
                     ICIC0006238
                  </td>
                  <td >
                     ICIC0006238
                  </td>
               </tr>
            </tbody>
         </table>
         <p style="margin-top:10px;text-align:justify">This certificate is issued for the purpose of bank loan processing at the student's request (vide request letter: <strong><?= $request_no ?>)</strong> . Post loan disbursement, the disbursement letter must be submitted for transaction verification and record update. To obtain the payment receipt, please submit the original bank disbursement letter with the stamp to the SUN Finance Department. Payment receipts will only be issued upon receipt of this documentation. </p>
         <div style="clear:both"></div>
         <div style="float:left;width:30%;padding-bottom:0px;text-align:center">
         </div>
         <div style="float:right;width:70%;padding-top:17px;text-align:right">
            <p style="font-size:13px"><strong>Registrar<br/>
               Sandip University
            </p>
         </div>
      </div>
	  <hr/>
	  
	  
   </body>
</html>