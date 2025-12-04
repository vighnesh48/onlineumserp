<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Migration Certificate</title>
<style>
body{
background-color:transparent;
	background-position:center;
	background-repeat: no-repeat;
	margin-left: auto;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;}
	p{padding:10px 0;
	font-size:15px;}
table {
	font-family: arial, sans-serif;
	border-collapse: collapse;
	width: 100%;
	
	margin: 0 auto;


}
td {
	xvertical-align: top;
	font-size:14px;
}
p {
	padding: 0px;
	margin: 0px;
}
h1, h3 {
	margin: 0;
	padding: 0
}

	</style>
</head>
 
<body>
<div style=";height:1000px;margin:0px auto 0px auto;border:1px solid #ccc; padding:10px">

  <table cellpadding="0" cellspacing="0" border="0" align="center">
    <tr>
     
      <td style="font-weight:normal;text-align:center">
	    <img src="https://erp.sandipuniversity.com/assets/images/logo-7.png" width="300px" >
        <p style="font-size:15px;">Mahiravani, Trimbak Road, Nashik – 422 213</p>
        <p style="font-size:15px;"><strong>Website</strong> - www.sandipuniversity.edu.in</p></td>
    </tr>
    <tr>
      <td align="center" colspan="2"></td>
    </tr>
  </table><hr/><h3 style="font-size:18px;margin-bottom: 10px;padding-top:10px;text-align:center"> Migration Certificate</h3>
 <!-- <table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:20px;">
    <tr>
      <td width="70" align="center" style="text-align:center;padding-top:5px;xborder-bottom:1px solid #000;padding-bottom:10px;"><img src="https://erp.sandipuniversity.com/assets/images/logo-8.jpg" alt="" width="70" border="0"></td>
      <td style="font-weight:normal;text-align:center;xborder-bottom:1px solid #000;"><h1 style="font-size:28px;">Sandip University</h1>
        <p>Mahiravani, Trimbak Road, Nashik – 422 213</p>
        <p>Website- www.sandipuniversity.edu.in</p></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
      <td align="center"><h3 style="font-size:16px;margin-bottom: 10px;padding-top:10px;">Migration Certificate</h3></td>
    </tr>
  </table>
  
  <?php
  $title="";
  if($bonafieddata['gender']=='M')
  {
      $title ="Shri";
      $gen ="he";
  }
    if($bonafieddata['gender']=='F')
  {
       $title ="Smt.";
        $gen ="she";
  }
  ?>
  <table border="0" width="100%" class="content-table" style="margin:20px;">

    <tr>
      <th><?=$title?></th>
      <td><?=ucwords(strtolower($bonafieddata['last_name']." ".$bonafieddata['first_name']." ".$bonafieddata['middle_name']))?></td>
    </tr>
    
        <tr>
      <th>Folio No.: </th>
      <td> <?=$bonafieddata['general_reg_no']?>
      </td>
    </tr>
    
    
          <tr>
      <th>Sr No.: </th>
      <td> <?php  echo sprintf("%04d", $cert_data[0]['mgc_id']);?>
      </td>
    </tr>
    
    
    <tr>
      <th>Mother's Name</th>
      <td><?=ucfirst($bonafieddata['mother_name'])?> <br /> Was a bonafide student of the Sandip University. Further <?=$gen?> is
informed that Sandip University has no objection to <?=$gen?> joining any
other University.
</td>
    </tr>
    <tr>
      <th>Date</th>
      <td><?=$cert_data[0]['cert_date']?></td>
    </tr>
      

    <tr>
      <th>TC No</th>
      <td><?=$cert_data[0]['tc_no']?></td>
    </tr>

    <tr>
      <th>College</th>
      <td>Sandip <?=$bonafieddata['school_name']?>
      </td>
    </tr>

  </table>-->
  
   <?php
  if($bonafieddata['gender']=='M')
  {
      $title ="Shri";
      $gen ="he";
       $gen2 ="his";
  }
    if($bonafieddata['gender']=='F')
  {
       $title ="Smt.";
        $gen ="she";
          $gen2 ="her";
  }
  ?>
  
  
  <table width="100%" border="1" cellspacing="0" cellpadding="5" align="center" style="margin:15px 25px;line-height:30px;">
 
  <tr>
    <td align="left"><strong>Sr. No :</strong></td>
    <td> <?php  echo sprintf("%04d", $cert_data[0]['mgc_id']);?></td>
    <td align="right"><strong>Folio No.:</strong> <?=$bonafieddata['general_reg_no']?></td>
  </tr>
 <?php  if(isset($title) && $title !='') { ?>
  <tr>
    <td align="left"><strong><?=$title?> :</strong></td>
    <td colspan="2"><?=ucwords(strtolower($bonafieddata['last_name']." ".$bonafieddata['first_name']." ".$bonafieddata['middle_name']))?></td>
  </tr>
 <?php } ?>
  <tr>
    <td align="left"><strong>Mother’s Name :</strong></td>
    <td colspan="2"><?=ucfirst($bonafieddata['mother_name'])?> </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="2"><i>Was a bonafide student of the Sandip University. Further <?=$gen?>   is
informed that Sandip University has no objection to <?=$gen2?>  joining any
other University/Institute</i></td>
  </tr>
  <tr>
    <td align="left"><strong>Date :</strong></td>
    <td colspan="2"><?=$cert_data[0]['cert_date']?></td>
  </tr>
  <tr>
    <td align="left"><strong>LC No. :</strong></td>
    <td colspan="2"><?=$cert_data[0]['tc_no']?></td></td>
  </tr>
  <tr>
    <td align="left"><strong>School :</strong></td>
    <td colspan="2"> <?=$bonafieddata['school_name']?></td>
  </tr>
  <tr>
  
    <td colspan="3" align="right"><br/><br/><strong>Registrar</strong></td>
  </tr>
</table></div>
  
</body>
</html>
