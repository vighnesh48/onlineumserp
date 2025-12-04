<!DOCTYPE html>
<html>
   <head>
      <style>
         table, td, th {
         border: 1px solid #000;
         border-collapse: collapse;
         padding:3px;
         font-size:13px;
         line-height:22px;
         font-family: sans-serif;
         }
         p ,ul li,ol li{
         font-size:13px;
         line-height:19px;
         font-family: sans-serif;
         color:#000;
         }
         .tt1{background-color:#e0e8ff}
         .tt2{background-color:
         #fffaee}
      </style>
   </head>
   <body style="color:#000">
      <div  style=" width:800px;margin:0px auto;padding:3px 20px;overflow:hidden;height:auto">
         <div class="" style="font-family: sans-serif;float:left;width:100%;text-align:center"  
            >
            <img src="https://www.sandipuniversity.edu.in/images/logo-dark.png" alt="Sandip university" class="desktop-logo lg-logo ptrans" style="margin-bottom:10px">
            <p style="font-family: sans-serif;font-weight:600;line-height: 15px; padding: 0px; margin: 0px;font-size:10px">A UNIVERSITY U/S 2(F) OF THE UGC ACT 1956 WITH THE RIGHT TO CONFER DEGREES, ESTABLISHED UNDER GOVT OF MAHARASHTRA ACT NO. XXXVIII OF 2015</p>
         </div>
         <div style="clear:both"></div>
         <hr/>
         <div style="float:left;width:80%;">
            <p style="font-size:13px;font-weight:bold;"><strong>SUN-REG/25-26/ </strong></p>
         </div>
         <div style="float:left;width:18%;padding-bottom:0px;;border:#000 solid 1px">
            <p style="font-size:13px;text-align:right!important"><strong><strong>Date: <?=date('d-m-Y') ?></strong></strong></p>
         </div>
         <div style="clear:both"></div>
         <h3 style="text-align: center;margin:0px;padding:0px;"><strong>TO WHOMSOEVER IT MAY CONCERN</strong></h3>

            <p style="font-size:13px;"><b>To,<br /><br />The Manager</b>,<br />Bank Name: <br/>Branch:</p>


         <p><b>Sub: Demand Letter against Loan.</b></p>
         <p>Dear Sir,</p>
         <p>This is to certify that <b>Mr./Ms <?= $first_name ?> (PRN. <?= $enrollment_no ?>)</b> has been admitted in the Sandip University, Nashik for First Year <b><?= $stream_name ?> </b> course in <b>2025-26</b>. He/ She has been sanctioned an education loan by your bank.</p>
         <p>We would like to inform you that the Demanding fees for  <?=$admission_year;?> Year <b><?= $stream_name ?> </b> for the Academic Year 2025-26 is <b>Applicable fees = Rs. <?php echo formatPlainCurrency($fefees);?>/-, Paid fees = Rs. <?php echo formatPlainCurrency($total_fees_paid);?>/-, Balance fees = Rs. <?php echo formatPlainCurrency($fefees-$total_fees_paid);?>/-. </b></p>
         <p><b>Demanding fees is Rs. <?php echo formatPlainCurrency($fefees-$total_fees_paid);?>/- as per student's request.</b></p>
         <p><b>Payment Details: </b></p>
         <table width="100%">
            <tbody>
               <tr>
                  <td width="25%" class="tt1">
                     <b>Particulars </b>
                  </td>
                  <td width="25%" class="tt1">
                     <b>Academic Fees</b>
                  </td>
                  <td width="25%" class="tt1">
                     <b>Hostel Fees</b>
                  </td>
                  <td width="25%" class="tt1">
                     <b>Transport Fees</b>
                  </td>
               </tr>
               <tr>
                  <td width="25%">
                     <b>Beneficiary Name </b>
                  </td>
                  <td width="25%" align="right">
                     Sandip University
                  </td>
                  <td width="25%" align="right">
                     Sandip Foundation Hostel
                  </td>
                  <td width="25%" align="right">
                     Sandip Foundation
                     Transportation
                  </td>
               </tr>
               <tr>
                  <td width="25%">
                     <b>Bank Name </b>
                  </td>
                  <td width="25%" align="right">
                     ICICI BANK
                  </td>
                  <td width="25%" align="right">
                     ICICI BANK
                  </td>
                  <td width="25%" align="right">
                     ICICI BANK
                  </td>
               </tr>
               <tr>
                  <td width="25%">
                     <b>Branch </b>
                  </td>
                  <td width="25%" align="right">
                     Mulund (W), Mumbai 
                  </td>
                  <td width="25%" align="right">
                     Mulund (W), Mumbai 
                  </td>
                  <td width="25%" align="right">
                     Mulund (W), Mumbai 
                  </td>
               </tr>
               <tr>
                  <td width="25%">
                     <b>Account Type</b>
                  </td>
                  <td width="25%" align="right">
                     Saving
                  </td>
                  <td width="25%" align="right">
                     Saving
                  </td>
                  <td width="25%" align="right">
                     Saving
                  </td>
               </tr>
               <tr>
                  <td width="25%">
                     <b>Account No. </b>
                  </td>
                  <td width="25%" align="right">
                     623801144820
                  </td>
                  <td width="25%" align="right">
                     623801144822 
                  </td>
                  <td width="25%" align="right">
                     623801144836
                  </td>
               </tr>
               <tr>
                  <td width="25%">
                     <b>IFSC Code  </b>
                  </td>
                  <td width="25%" align="right">
                     ICIC0006238
                  </td>
                  <td width="25%" align="right">
                     ICIC0006238
                  </td>
                  <td width="25%" align="right">
                     ICIC0006238
                  </td>
               </tr>
            </tbody>
         </table>
         <div style="width:100%;padding-bottom:0px;text-align:left">
     <p style="text-indent:50px;padding-top:10px">This certificate has been issued at the student's request (vide request letter: <?= $request_no ?>). After loan disbursement, the original stamped bank disbursement letter must be submitted to the Finance Department of Sandip University for Transaction Verification and record update. Payment receipts will only be issued upon submission of this documentation.</p>
         </div>
         <div style="clear:both"></div>
         <div style="float:left;width:30%;padding-top:50px;text-align:left"><b>Registrar<br/>
            Sandip University</b>
         </div>
         <div style="float:right;width:70%;padding-top:0px;text-align:left">
            <p style="font-size:13px"</p>
         </div>
      </div>
   </body>
</html>