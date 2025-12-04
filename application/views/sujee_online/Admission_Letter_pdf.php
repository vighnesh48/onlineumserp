<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sandip University</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet">
<style>
td, th {
    padding: 10px!important;
}
table td {

    border: #ccc solid 1px!important;
}
</style>

<body style="font-family:arial !important;font-weight: 400;">
    
<div style="width:85%;height:842px;margin:20px auto 20px auto;padding:0px">
      <p>&nbsp;</p>
<table width="100%" border="0" cellspacing="0" cellpadding="6" align="center" style="xpadding:30px">
  <tr>
    <td valign="top" colspan="2" align="center" style="border-bottom:1px solid #000">
    <img src="https://erp.sandipuniversity.com/assets/images/logo-7.png">
   <p> <strong>Neelam Vidya Vihar Sijoul,Post: Mailam, Dist.: Madhubani, Bihar - 847235<br></strong>
<strong>Website:</strong> http://www.sandipuniversity.edu.in<br>
<strong>Email:</strong> info.sijoul@sandipuniversity.edu |
<strong>Phone:</strong> 7549991044/ 7549991043<br></p></td>
  </tr>
  <tr>
    <td align="left"><p>&nbsp;</p><strong>Ref : <b><?php echo $all_data[0]['full_ref_no'];?></b><!-- SUN/OR/SS/BC/<?=date('Y');?>/<?=$reg?>--></strong> </td>
    <td align="right"><p>&nbsp;</p><strong>Date: <?php echo $all_data[0]['date_in'];?></strong></td>
    </tr>
    <tr>
     <td colspan="" align="center" width="">
        <p>&nbsp;</p>
    <h2 style="padding-bottom:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><strong>  ADMISSION  LETTER</strong></u></h2>
    </td>
     
     <td colspan="" align="right" width="150">
          
        
         </td>   
    </tr>
    <tr>
    <td colspan="2" align="center">
        <?php //print_r($all_data);?>
    <p>&nbsp;</p>
    <p style="font-size:16px;padding:20px;text-align:left!important" >
        <?php
       // var_dump($bonafieddata);
        $name= $all_data[0]['student_name'];
        if($all_data[0]['gender']=='M')
        {
            $title ='Mr.';
            $tem='He';
        }
        else
        {
           $title ='Ms.'; 
            $tem='She';
        }
        
        if($all_data['admission_year']==1)
        {
            $crsem ='I';
        }
          if($all_data['admission_year']==2)
        {
            $crsem ='II';
        }
        if($all_data['admission_year']==3)
        {
            $crsem ='III';
        }
        if($all_data['admission_year']==4)
        {
            $crsem ='IV';
        }
        if($all_data['admission_year']==5)
        {
            $crsem ='V';
        }
        if($all_data['admission_year']==6)
        {
            $crsem ='VI';
        }
        if($all_data['admission_year']==7)
        {
            $crsem ='VII';
        }
        if($all_data['admission_year']==8)
        {
            $crsem ='VII';
        }
        
        ?><p style="line-height:200%">
    This is to certify that <b><?php echo $title;?>  <?php echo $name;?> </b>Daughter/Son of <b><?php echo $father_name;?></b> is being <br />
    selected on the merit basis in <b><?php echo $all_data[0]['stream_name'];?></b> in <b><?php echo $all_data[0]['admission_year'];?></b> at  Sandip University, Sijoul, Madhubani for the academic year <b>2021-22</b>.<br></p>
    
<p>The Sandip University, Sijoul is approved by Government of Bihar through <br>notification <b>(letter no. 15/MI-53/2014-1146 )</b> dated 08th June 2017 and  Bihar<br> 
 Gazette Publication (No-25) on  dated  21st  June  2017  and   University  Grant <br>Commission (UGC)   <b>Letter No. F.5-3/2018(CPP-I/PU)</b> dated 06th June 2018 stating <br>
 that the Sandip University is empowered to award degree as specified under section  <br>22 of UGC Act.
 <br></p>
 <p>
  The student should report to the Sandip University, Sijoul on <b>06th December 2020 </b>
 <br><br>

<!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This certificate is being issued to the student to fulfill the formalities of <b><?=$purpose?></b> Purpose.
-->    
    </p>
    </td>
   </tr>
 
 
  
  
  
  <tr>
  <td colspan="2" style="padding-top:100px"> 
  <strong>
  <br>
  Authorized Signatory</strong>
  
  
  </td>
  </tr>
</table>



</div>
</body>
</html>

