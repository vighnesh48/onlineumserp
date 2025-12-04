<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<style>

table td p{font-size:13px!important;   line-height: 27px;  margin: 0;}
table td{font-size:13px!important; line-height: 27px;  margin: 0;}
</style>
</head>

<body>
    
<div style="height:1000px;margin:0px auto 0px auto;border:1px solid #ccc; padding:10px">
<table width="100%" border="0" cellspacing="0" cellpadding="6" align="center">
  <tr>
    <td valign="top" colspan="2" align="center" style="border-bottom:1px solid #000">
    <img src="https://erp.sandipuniversity.com/assets/images/logo-7.png"><br/>
   <p style="font-size:14px,line-height:27px;"> <strong>Mahiravani, Trimbak Road, Nashik – 422 213 </strong><br/>
<strong>Website:</strong> http://www.sandipuniversity.edu.in<br>
<strong>Email:</strong> student@sandipuniversity.edu.in |
<strong>Phone:</strong> (02594) 222 541, 42, 43, 44, 45 <br>
<strong>Fax:</strong> (02594) 222 555</p></td>
  </tr>
  <tr>
    <td align="left"><p style="font-size:12px!important;">&nbsp;</p><strong>Ref : SUN/OR/SS/BC/<?=date('Y');?>/<?=$reg?></strong> </td>
    <td align="right"><p style="font-size:12px!important;">&nbsp;</p><strong>Date: <?=str_replace("-","/",$idate)?></strong></td>
    </tr>
    <tr>
     <td colspan="" align="center" width="">
        <p>&nbsp;</p>
    <h2 style="padding-bottom:10px;"><u><strong>  BONAFIDE CERTIFICATE</strong></u></h2>
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
        $imageData = $this->awssdk->getsignedurl($bucket_key);
    ?>  
<img src="<?=$imageData?>" alt="" width="80" style="margin-bottom:30px"/>
        
         </td>   
    </tr>
    <tr>
    <td colspan="2">


        <?php
       // var_dump($bonafieddata);
        $name= $bonafieddata['first_name']." ".$bonafieddata['middle_name']." ".$bonafieddata['last_name'];
        $prn= $bonafieddata['enrollment_no'];
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
        
        ?><p>This is to certify that <b><?=$title?> <?=$name?></b> (PRN-<?=$prn?>) is a Bonafide student of the 
    Sandip University,pursuing the course from <?=$bonafieddata['admission_session']?>-<?=substr($bonafieddata['admission_session']+1,-2)?>.<br> <br></p>
<p><?=$tem?> is currently studying in <?=$bonafieddata['school_name']?> <b>(<?=trim($bonafieddata['stream_name'])?>) Semester <?=$crsem?> </b>&nbsp;(Academic Year: <?=$curryear."-".$subyear;?>) - Batch <?=$bonafieddata['admission_session']?>.<br><br>This certificate is being issued to the student to fulfill the formalities of <b><?=$purpose?></b> Purpose.
    
    </p>
    </td>
   </tr>
 
 
  
  
  
  <tr>
  <td colspan="2" style="padding-top:70px;text-align:right"> 
  <strong>
  <br> 
  Registrar/Assistant Registrar</strong>
  
  
  </td>
  </tr>
</table>



</div>
</body>
</html>

