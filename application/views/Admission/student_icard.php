<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<title>Gate pass</title>-->
<style>
body{font-family:'Lato', sans-serif;font-size:9px;}
</style>

</head>
<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
ini_set('max_execution_time', 300000);
require('code128.class.php');
include_once "phpqrcode/qrlib.php";



$font = 'Verdana.ttf';
//$stdid = 'dfgg565656';













?>
<div style="width:100%;height:100%;margin:0 auto;padding:10px">
<?php
// var_dump($ids);
// exit(0);
for($i=0;$i<count($ids);$i++)
                            {
                               /*$ext = '';
                             
         $form_no = $ids[$i]['enrollment_no'];
$barcode = new phpCode128($form_no, 80, $font, 25);
$barcode->saveBarcode('barcodes/'.$form_no.'.jpg');

 //  echo "jugal";
 //   exit();  




		//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
		$tempDir = 'qrcodes/';
		//$po_id = $p_row[0]['ord_no'];
		$site_url="http://www.sandipuniversity.com/student/index.php";
		$codeContents = $site_url.'?prn='.$form_no;
		
		// we need to generate filename somehow, 
		// with md5 or with database ID used to obtains $codeContents...
		$fileName = 'qrcode_'.$form_no.'.jpg';		
		$pngAbsoluteFilePath = $tempDir.$fileName;
		$urlRelativeFilePath = $pngAbsoluteFilePath;
		
		// generating
		//if (!file_exists($pngAbsoluteFilePath)) {
		define('IMAGE_WIDTH',500);
define('IMAGE_HEIGHT',500);
		QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 4, 2);			
		//}
		//$output .='<table><tr><td height="20"></td></tr><tr><td><img src="'.$urlRelativeFilePath.'" /></td></tr></table>';
		//qrcode code ends
		global $qrimg;
		$qrimg = $urlRelativeFilePath;   */   
                                
								?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="324" style="border:1px solid red">
<table border="0" cellpadding="0" cellspacing="0" width="100%"  style="border:1px solid red; height:;">
<tr>
<td valign="top" style="background-color:red;height:30px;width:180px;padding:5px;border-right:1px dotted #fff;border-radius-left-top:5px">
<img src="https://erp.sandipuniversity.com/assets/images/white-logo.jpg" alt="" width="150"/>
</td>
<td valign="top" style="background-color:red;height:30px;padding:15px 5px 5px 5px;color:#fff;font-weight:bold;font-size:12px" width="180">Simply World Class..</td>
</tr>
<tr>
<td valign="top" colspan="2" style="padding:5px;xheight: 50px;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td valign="top">
 <img src="https://erp.sandipuniversity.com/uploads/student_photo/<?=$ids[$i]['enrollment_no']?>.jpg" alt="" width="40"/>
                                   
    
    </td>
<td valign="top" width="100%">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td valign="top" style="line-height:10px;font-size:10px;" width="100%"><strong><?=$ids[$i]['first_name']." ".$ids[$i]['middle_name']." ".$ids[$i]['last_name']?></strong><br><small><strong><?=$short_stream?></strong></small></td>
<td valign="middle" style="border:1px solid #000;border-radius:5px;text-align:right;margin:0!important;padding:5px!important;" align="right"><strong><?=$ids[$i]['enrollment_no']?></strong></td>
</tr>
<tr>
<td colspan="2">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td><font size="12">Date of Birth</font></td>
<td><font size="12"><strong>: <?=$ids[$i]['dob']?></strong></font></td>
</tr>
<tr>
<td><font size="12">Blood Group</font></td>
<td><font size="12"><strong>: <?=$ids[$i]['blood_group']?></strong></font></td>
</tr>
<tr>
<td><font size="12">Contact No.</font></td>
<td><font size="12"><strong>: <?=$ids[$i]['mobile']?></strong></font></td>
</tr>

</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>  

<tr>
<td colspan="2" valign="top" style="padding-left:5px;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="100%" style="padding-right:10px">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="100%"  style="border-bottom:1px dotted #000;padding-bottom:5px">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<!--<tr>
<td style="padding-top:0px">&nbsp;</td>
</tr>-->
<tr>
<td align="center" style="font-size:9px" width="150">
    
    <img src="<?=base_url('assets/images')?>/auth_sign.jpg" alt="" width="70"/>
    <h3 style="margin-bottom:0;border-top:1px dashed #333; padding-top: 7px;margin-top: 0;">Authorised signature</h3></td>
</tr>
</table>
</td>
<td align="center" style="font-size:9px;border-bottom:1px dotted #000">
VALID<br>THRU
</td>
<td align="center" style="border-bottom:1px dotted #000;">Month/Year<br><strong>06 / <?php echo $ids[$i]['admission_session'] + $valid;?></strong></td>
</tr>
<tr>
<td colspan="3" style="font-weight:bold;">Sandip University, Trimbak Road, Nashik, MH, India. www.sandipuniversity.com | Toll Free: 1800-212-2714 </td>
</tr>
</table>
</td>
<td><img src="https://erp.sandipuniversity.com/qrcodes/<?=$fileName?>" alt="" width="50"/></td>
</tr>
</table>

</td>

</tr>
</table>
</td>
<td width="324" valign="top" style="border:1px solid red">
<table border="0" cellpadding="0" cellspacing="0" width="100%"  style="border:2px solid white; height:;">
<tr>
    <td colspan="2">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
         <tr>
             <td width="50%"><img src="https://erp.sandipuniversity.com/barcodes/<?=$form_no?>.jpg" alt="Sandip University" /></td>
             <td align="right" width="100%">
                <table border="1" cellpadding="2" cellspacing="0" width="100%">
                    <tr>
                       
                           <th width="50">I<sup>st</sup></th>
                           <?php
                        if($valid==2 || $valid==3 ||$valid==4){
                        ?>
                        <th width="50">II<sup>nd</sup></th>
                        <?php
                        }
                       if($valid==3 ||$valid==4){
                        ?>
                        <th width="50">III<sup>rd</sup></th>
                        <?php
                       }
                        if($valid==4){
                        ?>
                        <th width="50">IV<sup>th</sup></th>
                        <?php
                        }
                        ?>
                    </tr>
                    <tr>
                         <td>&nbsp;</td>
 <?php
                        if($valid==2 || $valid==3 ||$valid==4){
                        ?>
                         <td>&nbsp;</td>
                        <?php
                        }
                       if($valid==3 ||$valid==4){
                        ?>
                         <td>&nbsp;</td>
                        <?php
                       }
                        if($valid==4){
                        ?>
                         <td>&nbsp;</td>
                            <?php
                        }
                        ?>
                        
                        
                        
                        
                        
                        <?php
                      // for($i=0;$i<$valid;$i++){
                        ?>
                       
                        <?php
                        //    }
                        ?>
                        
                                             </tr>
                    
                </table> 
             </td>
         </tr> 
          
      </table>  
    </td>
</tr>    
    


<tr>
<td align="" valign="top" height="20" colspan="2" style="padding:5px" >
<b>Address :</b> <?=$ids[$i]['add']?>
</td>

</tr>
<tr>
<td colspan="2" valign="top" align="center" style="background:red;height:8px;color:#fff">If found of Emergency Contact us</td>

</tr>
<tr>
<td colspan="2" valign="top" style="padding:5px 0px;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td valign="top" width="100%" align="center" style="border-right:1px dotted #000;border-bottom:1px dotted #000;">Parents/Guardian Contact No.<br>+91 <?=$ids[$i]['pmobile']?></td>
<td align="center" style="border-bottom:1px dotted #000;">Institute Contact No.<br>+91 9545453255</td>
</tr>
<tr>
<td colspan="2" align="center" style="padding:5px;font-size:8px;font-weight: bold;">
1) Your Card remains the property of the University and must be returned when you suspend, withdraw from, or complete your course(s) at the University or your enrolment is terminated by the University. 2) Your Card is not transferable. 3) You are responsible for use of your Card at all times. 4) You must keep your Card secure.
</td>
</tr>
</table>
</td></tr>
</table>


</td>
</tr>
</table>
<hr style="margin:2px 0px;padding:0px;">
    <?php
  
    
							}
                                     
                                       ?>
  
    
  




</div>

