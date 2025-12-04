<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Certificate</title>
<style>
@font-face {
  font-family: Monotype Corsiva;
  src: url(https://erp.sandipuniversity.com/Monotype Corsiva.ttf);
}
body{
	font-family:Monotype Corsiva;
	
}

</style>
</head>

<body class ="EN">
      <div class="container" style="width: 800px; margin: auto; padding: 40px; ">
         <div  style="">
         <?php
            $bucket_key = "uploads/phd/degree/".$exam_ses."/QRCode/qrcode_".$exam_master_id[0].".png";
            $imageData = $this->awssdk->getImageData($bucket_key);
         ?>

            <div style="width:50%;float:left;margin-top:-10px"><p>PRN: <?=$stud_data[0][0]['enrollment_no']?><br/>
               <img src="<?=$imageData ?>" width="80"></p>
            </div>
            <div style="width:50%;float:left">
               <div style="margin-top:20px;width:100px; border:#ccc solid 1px;height:100px;background-color:#f2f2f2;float:right;text-align:center; line-height:104px;"> 
                  <?php
                       $bucket_key = 'uploads/student_photo/'.$stud_data[0][0]['enrollment_no'].'.jpg';
                       $imageData = $this->awssdk->getsignedurl($bucket_key);
                  ?>
                  <img src="<?=$imageData?>" alt="" width="100" ></div>
            </div>
         </div>
         <div style="font-size: 20px;line-height: 34px;padding-top:10px;text-align:justify;">We, the President, the Vice Chancellor and the Members of the 
            Governing Body of the Sandip University, Nashik hereby <i>confer the degree</i> of <span style="word-spacing: 0px;"><strong>DOCTOR OF PHILOSOPHY</strong></span><span style="word-spacing: 0px;" > under the <span>faculty of <span style="font-size: 19px;"><strong><?=strtoupper($faculty);?></strong></span></strong></span></span>
            </div>
			 <div style="font-size: 20px;text-align:center;padding:0px!important;margin:0px!important;">on</div>
			 <div style="font-size: 20px;text-align:center;line-height: 34px;"><b><?=$stud_data[0][0]['stud_name']?></b></div>
			 <p style="font-size: 20px;line-height: 34px;text-align:justify;"> in recognition of the successful completion of all the requirements for the award of the degree in <strong> <?=strtoupper($mrk_cer_date)?>.</strong></span>
         
         <span style="font-size: 20px; line-height: 34px;text-align:justify;">The degree has been awarded in accordance with the provisions of UGC minimum standards and procedures for the award of Ph.D. Degree, Regulations 2016.</span></p>
          <p style="font-size: 20px; line-height: 34px;text-align:justify"><strong>Title of the Thesis:</strong><br/>
            <span style="color:black;font-size: 16px;text-align:justify;"><?=strtoupper($thesis);?>
            </span>
         </p>
         <p style="text-align:center;font-size: 20px; line-height: 27px;">Given under the seal of University</p>
         <!--div style="width:50%;float:left">
            <p style="text-align:left"><small>Dated:</small></p>
         </div>
         <div style="width:50%;float:left;height:30px">
            <p style="text-align:right">Vice Chancellor</p>
            <br/>
         </div-->
      </div>
   </body>
</body>
</html>
