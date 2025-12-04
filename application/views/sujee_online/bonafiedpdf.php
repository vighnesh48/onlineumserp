<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
    
<div style="width:85%;height:842px;margin:20px auto 20px auto;border:0px solid #000;padding:0px">
      <p>&nbsp;</p>
<table width="100%" border="0" cellspacing="0" cellpadding="6" align="center" style="xpadding:30px">
  <tr>
    <td valign="top" colspan="2" align="center" style="border-bottom:1px solid #000">
    <img src="https://erp.sandipuniversity.com/assets/images/logo-7.png">
   <p> <strong>Mahiravani, Trimbak Road, Nashik – 422 213 |</strong>
<strong>Website:</strong> http://www.sandipuniversity.edu.in<br>
<strong>Email:</strong> info@sandipuniversity.edu.in |
<strong>Phone:</strong> (02594) 222 541, 42, 43, 44, 45 <br>
<strong>Fax:</strong> (02594) 222 555</p></td>
  </tr>
  <tr>
    <td align="left"><p>&nbsp;</p><strong>Ref : SUN/OR/SS/BC/<?=date('Y');?>/<?=$reg?></strong> </td>
    <td align="right"><p>&nbsp;</p><strong>Date: <?=str_replace("-","/",$idate)?></strong></td>
    </tr>
    <tr>
     <td colspan="" align="center" width="">
        <p>&nbsp;</p>
    <h2 style="padding-bottom:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><strong>  BONAFIDE CERTIFICATE</strong></u></h2>
    </td>
     
     <td colspan="" align="right" width="150">
             <?php
    
                                   
                                   /*    if (file_exists('uploads/2017-18/'.$bonafieddata['form_number'].'/'. $bonafieddata['form_number'].'_PHOTO.bmp')) {
                                        //  echo "****************";
                                           $ext = 'bmp';
                                       }
                                       else
                                       {
                                             $ext = 'jpg';
                                       }*/
                                       ?>
  
    <?php
        $bucket_key = 'uploads/student_photo/'.$bonafieddata['enrollment_no'].'.jpg';
        $imageData = $this->awssdk->getImageData($bucket_key);
    ?>
<img src="<?=$imageData?>" alt="" width="80"/>
        
         </td>   
    </tr>
    <tr>
    <td colspan="2">
        
    <p>&nbsp;</p>
    <p style="font-size:16px;padding:20px;text-align:left!important">
        <?php
       // var_dump($bonafieddata);
        $name= $bonafieddata['first_name']." ".$bonafieddata['middle_name']." ".$bonafieddata['last_name'];
        if($bonafieddata['gender']=='M')
        {
            $title ='Mr.';
            $tem='He';
        }
        else
        {
           $title ='Ms.'; 
            $tem='She';
        }
        
        if($bonafieddata['current_semester']==1)
        {
            $crsem ='I';
        }
          if($bonafieddata['current_semester']==2)
        {
            $crsem ='II';
        }
        if($bonafieddata['current_semester']==3)
        {
            $crsem ='III';
        }
        if($bonafieddata['current_semester']==4)
        {
            $crsem ='IV';
        }
        if($bonafieddata['current_semester']==5)
        {
            $crsem ='V';
        }
        if($bonafieddata['current_semester']==6)
        {
            $crsem ='VI';
        }
        if($bonafieddata['current_semester']==7)
        {
            $crsem ='VII';
        }
        if($bonafieddata['current_semester']==8)
        {
            $crsem ='VII';
        }
        
        ?><p style="line-height:200%">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is to certify that <b><?=$title?> <?=$name?></b> is a Bonafide student of the 
    Sandip University,pursuing the course from <?=$bonafieddata['admission_session']?>-<?=substr($bonafieddata['admission_session']+1,-2)?>.<br><br></p>
<p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$tem?> is currently studying in <?=$bonafieddata['school_name']?> <b>(<?=trim($bonafieddata['stream_name'])?>) Semester <?=$crsem?> </b>&nbsp;(Academic Year: <?=$curryear."-".$subyear;?>) - Batch <?=$bonafieddata['admission_year']?>.<br><br></p>
 <p>
  The Sandip University, Sijoul is approved by Government of Bihar through notification <br>(letter no. 15/MI-53/2014-1146 ) dated 08th June 2017 and <br><br> Bihar Gazette Publication (No-25) on  dated  21st  June  2017  and   University  Grant  Commission (UGC) <br><br>  Letter No. F.5-3/2018(CPP-I/PU) dated 06th June 2018 stating that<br><br> the Sandip University is empowered to award degree as specified under section 22 of UGC Act.<br><br>
The student should report to the Sandip University, Sijoul on 06th December 2020 
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
  Registrar</strong>
  
  
  </td>
  </tr>
</table>



</div>
</body>
</html>

