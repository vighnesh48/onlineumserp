<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- <title>Untitled Document</title> -->
<!-- <style>
body{font-family: arial, sans-serif;font-size:12px;}
table tr th{padding:5px;}
table tr td{padding:5px;}
table{border-collapse:collapse;}
</style> -->
<style>  
         h1, h2, h3, h4 ,h5,h6{font-family: sans-serif;}
         ol li{
         margin-left: -22px;
         line-height: 25px;
         font-family: sans-serif;
         font-size:15px;
         }
         h2{font-size: 20px;line-height: 0px;}
         h6 {
         font-size: 15px;
         line-height: 0px;
         }
         h3 {
         font-size: 19px;
         line-height: 0px;
         }
         .wt1{border:#000 Solid 2px;}
         .wt{width:50%;float:left;}
         .clear{clear:both;}
       
		 p, table th td {
         font-family: sans-serif;
         font-size:14px;line-height:18px;
         }
		 
		 
         table {
         font-family: sans-serif;
         border-collapse: collapse;
         width: 100%;font-size:14px;line-height:24px;
         }
         .t{border:2px solid #fff!important}
         td{
         border: 0px solid #000;
         text-align: left;
         padding: 4px;
         }
         th {
         border: 0px solid #000;
         text-align: center;
         padding: 4px;
         }
         tr,th,td{border: 1px solid #000;}
      </style>

</head>
<?php
//$siteurl = "https://sandipuniversity.com/PHD19";
$siteurl = "https://www.sandipuniversity.com/PHD_Sunpet/";
?>
<body>
<!-- <body>
<div style="width:100%;height:1200px;margin:0 auto;overflow:hidden;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  
    <td align="center">
    <img src="<?= base_url() ?>assets/images/logo-7.png" width="200">
    <p style="padding:0;margin:0px;">Mahiravani, Trimbak Road, Nashik – 422 213</p>
    <h3 style="font-size:18px;">SUNPET - JULY 2019 (ACADEMIC YEAR 2019-20)</h3>
      <h3 style="font-size:18px;"><u>ADMIT CARD</u></h3>
    </td>
  
  </tr>
</table>


<br>
 
<table width="100%" border="1" cellspacing="0" cellpadding="0">

 <tr>
      
    <td width="180"><strong> HALL TICKET NO.: </strong></td>
        <td colspan="2"><?=strtoupper($students['phd_reg_no'])?> </td>
    <td rowspan="3" width="100"><img src="<?=$siteurl ?>/uploads/phd/<?= $doc['doc_file']?>" width="100"></td>
    </tr>
  <tr>
      
    <td width="180"><strong> NAME OF THE CANDIDATE: </strong></td>
        <td colspan="2"><?=strtoupper($students['student_name'])?> </td>
  
    </tr>
  <tr>
    <td ><strong>DATE OF BIRTH: </strong></td>
      <td colspan="2"><?=date('d-m-Y',strtotime($students['dob']))?></td>
    </tr>
  <tr>
    <td ><strong>ADDRESS: </strong>
    </td>
   
     <td colspan="3"><?=$students['address_c']?> 
    <?=$students['city_c']?>
    <?=$students['cstate']?>
    <?=$students['pincode_c']?>
    </td>
    </tr>
      
    
  <tr>
    <td ><strong>CATEGORY: </strong></td>
   <td colspan="3"><?=$students['category']?></td>
    </tr>

    
  <tr>
    <td><strong>COURSE CATEGORY: </strong></td>
   <td colspan="3"><?php if($students['admission_category']=="FT"){echo "Full Time";} if($students['admission_category']=="PT"){echo "Part Time";}?></td>
  
  
    </tr>

  <tr>
    <td> <strong>DEPARTMENT: </strong></td>
    <td colspan="3"><?= $students['department']?></td>
    </tr>

  <tr>
    <td> <strong>DATE: </strong></td>
    <td colspan="3">18<sup>th</sup> - AUGUST - 2019 (SUNDAY)</td>
    </tr>
     <tr>
    <td> <strong>TIME: </strong></td>
    <td colspan="3">12:00 Hrs-14:00 Hrs</td>
    </tr> 
      <tr>
    <td> <strong>VENUE: </strong></td>
    <td colspan="3">“O” BUILDING SANDIP UNIVERSITY NASHIK
Trimbak Road, Mahiravani, Nashik - 422213, Maharashtra, India</td>
    </tr>
   
   
    <tr>
    <td colspan="4"> 
   <strong>Note: </strong>
   <ul>
     <li> <p align="left">Please bring your original ADHAAR/PAN/PASSPORT to appear in SUNPET Exam as Identity Proof.</p></li>
   <li> <p align="left">Please be present One hour before the Commencement of Examination.</p></li>
    <li> <p align="left">All the Candidates are requested to submit one set of self-attested photocopies of all the necessary documents as mentioned in the application form just before the commencement of Examination in the respective Examination Hall</p>
     </li>
    </td>
    </tr>
    
    



    
</table>
<br><br><br>
<table border="0" width="100%">
    <tr>  
  <td  height="100" width="50%" valign="bottom"><p align="right"><strong>Candidate Signature</strong></p></td>
  <td height="80" valign="bottom" align="right">
      <img src="<?= base_url() ?>assets/images/Sign-COE-011.png" width="" style="margin-bottom:-15px"><br>
      <strong>Controller of Examinations</strong>
</td>

    
    </tr>  
    </table>

</div> -->


<div style="border:#000 double 4px;padding:20px; margin:10px">
         <!--Header-->
         <div align="center" style="width:70%;margin:0px auto">
           
				  <img class="act" src="https://erp.sandipuniversity.com/assets/su_logo.jpg" width=" 200px;" alt="sandip-university" style="margin-bottom:5px;">
                    <!-- <h1 style="text-align: center;">SANDIP UNIVERSITY</h1>-->
                     <p style="text-align: center;font-size:13px;margin-bottom:0px;">Trimbak Road, Mahiravani, Nashik – 422 213<br/> www.sandipuniversity.edu.in | <strong>Email:</strong> sun.phd@sandipuniversity.edu.in 
					 <strong>Phone:</strong> (02594) 222 541 | <strong>Fax: </strong>(02594) 222 555
</p>
    <p style="text-align: center;font-size:14px;font-weight:bold;margin-bottom:0px;">
            SUN Ph.D. Entrance Test Hall Ticket – SUNPET JULY-2024
         </p>

            </div>
			
	<p style="margin-bottom:10px;">........................................................................................................................................................</p>
         <table >
            <tbody>
               <tr >
                  <td width="45%" >
                     <p>Applicant Name
                  </td>
                  <td width="45%">
                    <?=strtoupper($students['student_name'])?>
                  </td>
                  <?php 
				  
				  $path = 'https://sandipuniversity.com/PHD_Sunpet/uploads/phd/'.$doc['doc_file'];
				 //echo '<pre>';
                  //print_r($doc['doc_file']);exit;  ?> 
                  <td rowspan="5"  width="10%" valign="top" >
                     <div ><img  src="<?php echo $path; ?>" style="width:100px!important;"></div>
                  </td>
               </tr>
               <tr>
                  <td>
                     Discipline / Branch
                  </td>
                  <td>
                    <?= $students['department']?>
                  </td>
               </tr>
               <tr>
                  <td>
                     Day/Date
                  </td>
                  <td>
                     Saturday, 21<sup>st</sup> SEPT 2024
                  </td>
               </tr>
               <tr>
                    <td>
                    (Reporting Time:) </td>
                    <td> 09:30 am</td>
                  </tr>
                    <tr>
                    <td>
                    <strong>Time :</strong> Part-I (Research Methodology) </td>
                    <td>10:00 am  to 11.00 am</td>
                  </tr> 
                 <tr><td>
                    <strong>Time :</strong> Part-II (Discipline / Branch) </td>
                    <td colspan ="2"> 11:00 am  to 12.00 pm
                  </td>
                  
               </tr>
               <tr>
                  <td valign="top">
                     Venue
                  </td>
                  <td colspan ="2">
                     O-Building, Sandip University Campus, Mahiravani, Trimbak Road, Nashik &ndash; 422213
                  </td>
               </tr>
               <tr>
                  <td>
                     Admission Ticket No
                  </td>
                  <td  colspan ="2">
                     <big><strong>2409<?= $students['phd_id']?></strong></big>
                  </td>
               </tr>


            </tbody>
         </table>
         <table>
            <tr>  
  <td  height="100" width="50%" valign="bottom"><p align="right"><strong>Candidate Signature</strong></p></td>
  <td height="80" valign="bottom" align="right">
      <img src="<?= base_url() ?>assets/images/Sign-COE-011.png" width="" style="margin-bottom:-30px"><br>
      <strong>Controller of Examinations</strong>
</td>

    
    </tr> 
	
	<tr>
    <td colspan="2"> 
  
   
     <p align="left" style="text-align: justify;"> <strong>Instruction: </strong><br>1. It is mandatory to carry a valid Government approved Identity proof during Examination(e.g:- Adhar, Pan, Voter ID, Passport etc.)<br>  
													2. Candidate should report to the Examination Hall on said time, else He/She will not be permitted. </p>
    </td>
    </tr>
         </table>
      </div>
</body>
</html>
