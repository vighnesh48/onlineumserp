<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<style>
body{font-size:12px}
table tr td{padding:3px;}
table tr td > strong{font-size:11px;}
</style>
</head>
<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
ini_set('max_execution_time', 300000);
require('code128.class.php');
//include_once "phpqrcode/qrlib.php";
$font = 'Verdana.ttf';
$form_no = $std_gatepass_details['fees_id'];
/* $barcode = new phpCode128($form_no);
$barcode->saveBarcode('uploads/facility_challan/'.$form_no.'.jpg'); */
$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
$barcode = 'data:image/png;base64,' .base64_encode($generator->getBarcode($form_no, $generator::TYPE_CODE_128));
?>
<body>
<br/><br/><br/><br/>
<table width="842" border="0" cellspacing="0" cellpadding="0" height="595" style="border:1px solid red;" align="center">
  <tr>
    <td valign="top">
    <table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3"><strong>BANK COPY : </strong></td>
    </tr>
  <tr>
    <td width="50%"><strong>Bank A/c No. :</strong> <?=$std_challan_details['account_no']?></td>
    <td colspan="2"><strong>Date :</strong> 9/8/2017</td>
  </tr>
  <tr>
    <td colspan="3"><strong>Bank A/c Name :</strong> <?=$std_challan_details['account_name']?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Journel No. : </strong></td>
  </tr>
  <tr>
    <td><strong>Ac-Year : </strong><?=$std_challan_details['academic_year']?></td>
    <td colspan="2"><strong>Mode of Payment :</strong> <?=$std_challan_details['fees_paid_type']?></td>
  </tr>
  <tr>
    <td><strong>Student ID :</strong><?=$std_challan_details['enrollment_no']?></td>
    <td colspan="2"><strong>College Name :</strong> <?=$std_challan_details['school_name']?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Name of Student  : </strong><?=$std_challan_details['first_name']?> <?=$std_challan_details['middle_name']?> <?=$std_challan_details['last_name']?></td>
    </tr>
  <tr>
    <td><strong>Route Name :</strong> Devlali Camp</td>
      <td colspan="2"><strong>Branch :</strong> <?=$std_challan_details['course_name']?></td>
</tr>
    <tr>
    <td colspan="3"><strong>Pick up Point :</strong> Papya Corner</td>
    </tr>
      <tr>
    <td colspan="3"><strong>Challan No. :<?=$std_challan_details['exam_session']?></strong></td>
    </tr>

    <tr>
    <td colspan="3"><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <th>Sr. No.</th>
        <th>Particulars</th>
        <th>Amount (Rs.)</th>
      </tr>
      <tr>
        <td align="center">1</td>
        <td>Transport Fees</td>
        <td align="center"><?=$std_challan_details['amount']?></td>
      </tr>
      <tr>
        <td colspan="2" align="right">Total Rs.</td>
        <td align="center"><strong><?=$std_challan_details['amount']?></strong></td>
      </tr>
    </table></td>
    </tr>

    <tr>
    <td colspan="3">Amount In Words : <strong>Rupees Ten Thousand Thirty Only</strong></td>
    </tr>

    <tr>
    <td height="60" colspan="3" align="right" valign="bottom"><strong>Signature of Student / Remitter</strong></td>
    </tr>

    <tr>
    <td><strong>DD. No :</strong> <?=$std_challan_details['receipt_no']?></td>
    <td colspan="2"><strong>Date : </strong><?=$std_challan_details['fees_date']?></td>
  </tr>

    <tr>
    <td colspan="3">&nbsp;</td>
    </tr>

    <tr>
    <td colspan="3"><strong>Bank Name :</strong><?=$std_challan_details['bank_name']?></td>
    </tr>

    <tr>
    <td colspan="3"><strong>Branch Name : </strong><?=$std_challan_details['bank_city']?></td>
    </tr>

    <tr>
    <td><strong>Note : Do Not Accept Old Notes of Rs. 500/- &amp; 1,000/-</strong></td>
    <td><strong>Rs. </strong></td>
    <td><strong>Date:</strong></td>
    </tr>

</table>
</td>
    <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3"><strong>BANK COPY : </strong></td>
    </tr>
  <tr>
    <td width="50%"><strong>Bank A/c No. :</strong> <?=$std_challan_details['account_no']?></td>
    <td colspan="2"><strong>Date :</strong> 9/8/2017</td>
  </tr>
  <tr>
    <td colspan="3"><strong>Bank A/c Name :</strong> <?=$std_challan_details['account_name']?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Journel No. : </strong></td>
  </tr>
  <tr>
    <td><strong>Ac-Year : </strong><?=$std_challan_details['academic_year']?></td>
    <td colspan="2"><strong>Mode of Payment :</strong> <?=$std_challan_details['fees_paid_type']?></td>
  </tr>
  <tr>
    <td><strong>Student ID :</strong><?=$std_challan_details['enrollment_no']?></td>
    <td colspan="2"><strong>College Name :</strong> <?=$std_challan_details['school_name']?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Name of Student  : </strong><?=$std_challan_details['first_name']?> <?=$std_challan_details['middle_name']?> <?=$std_challan_details['last_name']?></td>
    </tr>
  <tr>
    <td><strong>Route Name :</strong> Devlali Camp</td>
     <td colspan="2"><strong>Branch :</strong> <?=$std_challan_details['course_name']?></td>
</tr>
    <tr> 
    <td colspan="3"><strong>Pick up Point :</strong> Papya Corner</td>
    </tr>
      <tr>
    <td colspan="3"><strong>Challan No. :<?=$std_challan_details['exam_session']?></strong></td>
    </tr>

    <tr>
    <td colspan="3"><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <th>Sr. No.</th>
        <th>Particulars</th>
        <th>Amount (Rs.)</th>
      </tr>
      <tr>
        <td align="center">1</td>
        <td>Transport Fees</td>
        <td align="center"><?=$std_challan_details['amount']?></td>
      </tr>
      <tr>
        <td colspan="2" align="right">Total Rs.</td>
        <td align="center"><strong><?=$std_challan_details['amount']?></strong></td>
      </tr>
    </table></td>
    </tr>

    <tr>
    <td colspan="3">Amount In Words : <strong>Rupees Ten Thousand Thirty Only</strong></td>
    </tr>

    <tr>
    <td height="60" colspan="3" align="right" valign="bottom"><strong>Signature of Student / Remitter</strong></td>
    </tr>

    <tr>
    <td><strong>DD. No :</strong> <?=$std_challan_details['receipt_no']?></td>
    <td colspan="2"><strong>Date : </strong><?=$std_challan_details['fees_date']?></td>
  </tr>

    <tr>
    <td colspan="3">&nbsp;</td>
    </tr>

    <tr>
    <td colspan="3"><strong>Bank Name :</strong><?=$std_challan_details['bank_name']?></td>
    </tr>

    <tr>
    <td colspan="3"><strong>Branch Name : </strong><?=$std_challan_details['bank_city']?></td>
    </tr>

    <tr>
    <td><strong>Note : Do Not Accept Old Notes of Rs. 500/- &amp; 1,000/-</strong></td>
    <td><strong>Rs. </strong></td>
    <td><strong>Date:</strong></td>
    </tr>
</table></td>
    <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3"><strong>BANK COPY : </strong></td>
    </tr>
  <tr>
    <td width="50%"><strong>Bank A/c No. :</strong> <?=$std_challan_details['account_no']?></td>
    <td colspan="2"><strong>Date :</strong> 9/8/2017</td>
  </tr>
  <tr>
    <td colspan="3"><strong>Bank A/c Name :</strong> <?=$std_challan_details['account_name']?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Journel No. : </strong></td>
  </tr>
  <tr>
    <td><strong>Ac-Year : </strong><?=$std_challan_details['academic_year']?></td>
    <td colspan="2"><strong>Mode of Payment :</strong> <?=$std_challan_details['fees_paid_type']?></td>
  </tr>
  <tr>
    <td><strong>Student ID :</strong><?=$std_challan_details['enrollment_no']?></td>
    <td colspan="2"><strong>College Name :</strong> <?=$std_challan_details['school_name']?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Name of Student  : </strong><?=$std_challan_details['first_name']?> <?=$std_challan_details['middle_name']?> <?=$std_challan_details['last_name']?></td>
    </tr>
  <tr>
    <td><strong>Route Name :</strong> Devlali Camp</td>
     <td colspan="2"><strong>Branch :</strong> <?=$std_challan_details['course_name']?></td>
</tr>
    <tr> 
    <td colspan="3"><strong>Pick up Point :</strong> Papya Corner</td>
    </tr>
      <tr>
    <td colspan="3"><strong>Challan No. :<?=$std_challan_details['exam_session']?></strong></td>
    </tr>

    <tr>
    <td colspan="3"><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <th>Sr. No.</th>
        <th>Particulars</th>
        <th>Amount (Rs.)</th>
      </tr>
      <tr>
        <td align="center">1</td>
        <td>Transport Fees</td>
        <td align="center"><?=$std_challan_details['amount']?></td>
      </tr>
      <tr>
        <td colspan="2" align="right">Total Rs.</td>
        <td align="center"><strong><?=$std_challan_details['amount']?></strong></td>
      </tr>
    </table></td>
    </tr>

    <tr>
    <td colspan="3">Amount In Words : <strong>Rupees Ten Thousand Thirty Only</strong></td>
    </tr>

    <tr>
    <td height="60" colspan="3" align="right" valign="bottom"><strong>Signature of Student / Remitter</strong></td>
    </tr>

    <tr>
    <td><strong>DD. No :</strong> <?=$std_challan_details['receipt_no']?></td>
    <td colspan="2"><strong>Date : </strong><?=$std_challan_details['fees_date']?></td>
  </tr>

    <tr>
    <td colspan="3">&nbsp;</td>
    </tr>

    <tr>
    <td colspan="3"><strong>Bank Name :</strong><?=$std_challan_details['bank_name']?></td>
    </tr>

    <tr>
    <td colspan="3"><strong>Branch Name : </strong><?=$std_challan_details['bank_city']?></td>
    </tr>

    <tr>
    <td><strong>Note : Do Not Accept Old Notes of Rs. 500/- &amp; 1,000/-</strong></td>
    <td><strong>Rs. </strong></td>
    <td><strong>Date:</strong></td>
    </tr>
</table></td>
  </tr>
</table>









</body>
</html>
