<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<div style="width:90%;height:842px;margin:0 auto;">
    <br/>
      <?php 
    //  print_r($getpass_data1);
      
      if(!empty($getpass_data1)){
     // for($i=1;$i<=2;$i++){
      ?>
      
<table width="100%" border="0" cellspacing="0" cellpadding="8" align="center" style="font-size:12px;height:415px;margin-top:-10px;">
  <tr>
    <td valign="top" colspan="2" align="center" style="border:1px solid #000">
    <img src="<?php echo base_url(); ?>assets/images/logo-7.png">
   <p style="padding:2px 0px 0px  0px;margin:0px;"> <strong>Mahiravani, Trimbak Road, Nashik – 422 213 |</strong>
<strong>Website:</strong> http://www.sandipuniversity.edu.in<br>
<strong>Email:</strong> info@sandipuniversity.edu.in |
<strong>Phone:</strong> (02594) 222 541, 42, 43, 44, 45 |
<strong>Fax:</strong> (02594) 222 555</p></td>
  </tr>
  <tr>
    <td align="left" style="border-left:1px solid #000"><strong>No.: <?php echo $getpass_data1[0]['lid'];?></strong> </td>
    <td align="right" style="border-right:1px solid #000"><strong>Date: <?PHP echo date('d/m/Y'); ?></strong> </td>
    </tr>
    <tr>
    <td align="center" colspan="2" style="border-left:1px solid #000;border-right:1px solid #000">
    <?php  if($getpass_data1[0]['leave_apply_type'] == 'OD' && $getpass_data1[0]['leave_duration'] == 'full-day' && $gtyp == 'm'){ ?>
  <h2 style="padding:0px;margin:0px"><strong>Office Order</strong></h2>
  <?php }elseif($getpass_data1[0]['leave_apply_type'] == 'OD' && $getpass_data1[0]['leave_duration'] == 'hrs' && $gtyp == 'm'){ ?>
  <h2 style="padding:0px;margin:0px"><strong>Movement Order</strong></h2>
  <?php }else{ ?>
  <h2 style="padding:0px;margin:0px"><strong>Gate Pass</strong></h2>
  <?php } ?>
    <p style="padding:0px;margin:0px">The under mentioned staff member (s) of the University is/are authorized to proceed to visit as follows:</p>
    </td>
   </tr>
  <tr>
    <td colspan='2' style="border-left:1px solid #000;border-right:1px solid #000"><strong>Location: </strong> <?php echo $getpass_data1[0]['leave_contct_address'];?></td>
    
  </tr>
  <tr>
    <td colspan='2' style="border-left:1px solid #000;border-right:1px solid #000"><strong>Purpose: </strong> <?php echo $getpass_data1[0]['reason'];?></td>
  </tr>
  <tr>
    <td colspan='2' style="border-left:1px solid #000;border-right:1px solid #000"><strong>Leave Type: </strong> <?php echo $getpass_data1[0]['leave_apply_type'];?></td>
  </tr>
  <tr>
    <td width="40%" style="border-left:1px solid #000;"><strong>From Date:</strong> <?php echo date('d/m/Y',strtotime($getpass_data1[0]['applied_from_date'])) ;?> </td>
    <td  style="border-right:1px solid #000;" align="left"><strong>To Date:</strong> <?php echo date('d/m/Y',strtotime($getpass_data1[0]['applied_to_date']));?></td>
  </tr>
  <?php if($getpass_data1[0]['leave_apply_type'] == 'OD' && $getpass_data1[0]['leave_duration'] == 'hrs'){ ?>
  <tr>
    <td width="40%" style="border-left:1px solid #000;"><strong>Departure Time:</strong> <?php echo date('H:i:s',strtotime($getpass_data1[0]['departure_time']));?>   </td>
    <td style="border-right:1px solid #000;"><strong>Arrival Time:</strong> <?php echo date('H:i:s',strtotime($getpass_data1[0]['arrival_time'])) ; ?></td>
  </tr>
  <?php } ?>
  <tr>
  <td colspan="2" style="border-left:1px solid #000;border-right:1px solid #000;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%">
    <table width="100%" border="1" cellspacing="0" cellpadding="2">
  <tr>
    <td align="center" width="25%"><strong>Staff ID</strong></td>
    <td align="center"  width="25%"><strong>Name</strong></td>
    <td align="center"  width="25%"><strong>Designation</strong></td>
    <td align="center"  width="100%"><strong>Department</strong></td>
  </tr>
  <tr>
    <td align="center"><?php echo $getpass_data1[0]['emp_id']; ?></td>
    <td align="center"><?php echo $getpass_data1[0]['fname'].' '.$getpass_data1[0]['mname'].' '.$getpass_data1[0]['lname']; ?></td>
    <td align="center"><?php echo $getpass_data1[0]['designation_name']; ?></td>
    <td align="center"><?php echo $getpass_data1[0]['department_name'];?></td>
  </tr>
</table>

    </td>
  </tr>
</table>

  </td>
  </tr>
  <tr>
  <td colspan='2' style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000">
   <table width="100%" border="0" cellspacing="0" cellpadding="8">
       <tr>
           <td width="50%" style="padding-top:40px;"><strong>Signature of Employee</strong></td>
          
           <?php if($gtyp=='g'){ ?>
            <td width="25%" align="center" style="padding-top:40px">
           <strong>Signature of HOD/Dean</strong></td>
           <?php }else{ ?>
            <td width="50%" align="center" style="padding-top:40px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           </td>
            <?php } if($gtyp=='g'){ ?>
           <td width="100%" align="center" style="padding-top:40px"><strong>Signature of Registrar</strong></td>
           <?php }elseif($gtyp=='m'){ ?>
   <td width="100%" align="center" style="padding-top:40px"><strong>Approved BY VC/Registrar Sir</strong><br>(Signature Not Required.)</td>
           <?php } ?>
       </tr>
       
   </table>
  
  </td>
  </tr>
  
  

  
  
  
  
  
</table>
<?php if($i == '1'){?>
<br/><br/>

<?php } } //} 
?>  


</div>

</html>





              