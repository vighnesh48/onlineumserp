<html>
<Head>
	<title>
	Provisional Certificate
</title>
<style>

.container {
	/*border:2px solid #000;
	padding:20px;*/
	overflow:hidden;
	/*height:100%;*/
	}
.container span {
	display:inline-block;
	*float:left;
	}.alignleft {
	float: left;
}
#textbox {
	width: 90%;
	margin: 90px auto;
	padding: 10px;
	border: 1px solid #cccccc;
}.alignleft {
	float: left;
}

.alignright {
	float: right;
}
ol, ul, li {
  margin:0 !important;
  padding:0 !important;
}
</style>
</Head>
   <body style="font-size:12.5px; text-align: justify;text-justify: inter-word; line-height:normal !important;">
    <?php
       // var_dump($bonafieddata);
        $name= $all_data[0]['student_name'];
        if($all_data[0]['gender']=='M')
        {
            $title ='Mr.';
            $tem='He';
			$off="Son";
        }
        else
        {
           $title ='Ms.'; 
            $tem='She';
			$off="Daughter";
        }
        
        if($all_data[0]['admission_year']==1)
        {
            $crsem ='1st Year';
			$Lateral="";
        }
          if($all_data[0]['admission_year']==2)
        {
            $crsem ='2nd Year';
			$Lateral="(Lateral Entry)";
        }
        if($all_data[0]['admission_year']==3)
        {
            $crsem ='3rd Year';
        }
        if($all_data[0]['admission_year']==4)
        {
            $crsem ='4th Year';
        }
       
	   
	    if($all_data[0]['course_duration']==1)
        {
            $course_duration ='1';
        }
        if($all_data[0]['course_duration']==2)
        {
            $course_duration ='2';
        }
        if($all_data[0]['course_duration']==3)
        {
            $course_duration ='3';
        }
        if($all_data[0]['course_duration']==4)
        {
            $course_duration ='4';
        }
		
        $countt=$Academic_Fees[0]['course_dusration']; for($i=1;$i<=$countt;$i++){
			$session=(21+$i);
		}
		
		$all_data[0]['admission_year']
        ?>
      <div style="width:100%!important; margin:auto!important;padding:2px 5px!important;">
         <!--<div  align="center" style="text-align:center!important;">
            <img src="https://www.sandipuniversity.edu.in/images/sandip-university-logo.png" alt="Sandip University Logo"><br/>
            <p align="center" style="font-size:15px!important;padding:0px 3%!important;line-height:24px!important"><strong>Neelam Vidya Vihar,Village Sijoul,Madhubani,Bihar</strong><br/>
               <span>Website</span> :http://www.sandipuniversity.edu.in <span>Email : </span>info.sijoul@sandipuniversity.edu.in</span>
               <span>Ph</span> : 1800-313-2714<br/>
            </p>
         </div>--><br/>
         <div>
<div style="font-size:11.5px !important;"><b>Ref-:<?php echo $all_data[0]['full_ref_no'];?></div>
<div style="float:right;margin-top:-30px !important; margin-left:600px !important;font-size:11.5px !important;"><b>Date-:<?php  $all_data[0]['date_in']; echo date("d-m-Y", strtotime($all_data[0]['date_in']));?></div>
</div>
         
	              <!--<div>
			     <span style="float:left;"><b>Ref-:<?php echo $all_data[0]['full_ref_no'];?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                 
                 <span style="float:right;"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date-:<?php  $all_data[0]['date_in']; echo date("d-m-Y", strtotime($all_data[0]['date_in']));?></b></span>
                
               </div>-->
             <!--<div id="textbox">
<p class="alignleft" style="float:left">Text on the left.</p>
<p class="alignright" style="float:right;">Text on the right.</p>
<div style="clear: both;"></div>
</div>-->

         <div>
            <div align="center" style="text-align:center!important;font-family:Georgia, 'Times New Roman', Times, serif"> <em><b><u>TO WHOMSOEVER IT MAY CONCERN</u><b><br>
<u>Fee Structure for Session 2021-<?php echo $session;?></u></em></div>
           
			  This is to certify that <b><?php echo $title;?><?php echo $all_data[0]['student_name'];?></b> <?php echo $off;?> of <b><?php echo $all_data[0]['father_name'];?></b> resident of </b><?php echo $all_data[0]['village'];?>,<?php echo $all_data[0]['Districtname'];?></b> has been
admitted in <b><?php echo $crsem;?></b> in Course:-<b><?php echo $all_data[0]['stream_name'];?> <?php echo $Lateral;?></b> for the Academic
Year <b>2021 – 22</b> at Sandip University, Sijoul, Madhubani. The Course duration is <b><?php echo $Academic_Fees[0]['course_dusration'];?></b> Years.
The approximate expenses for pursuing the above entire course are as under.<br><b>Academic Fees</b>
<table  border="1" style="font-size:13px;border:#ddd solid 1px !important !important;border-collapse: collapse;width:100%!important;text-align:left!important;font-size:12px!important;">
        <tr>
         <th style="padding:5px;text-align:center;">Sr.No</th>
         <th style="padding:5px;text-align:center;">Particulars</th>
         <?php $count=$Academic_Fees[0]['course_dusration']; 
		 if($all_data[0]['admission_year']==1){$ff=1;$cp=0;}else{$ff=2;$cp=1;}
		 for($i=$ff;$i<=$count+$cp;$i++){  ?>
         
		 <th style="padding:5px;text-align:center;"><?php echo $i;?> Year</th>
		 
         
         <?php } ?>
		 <th style="padding:5px;text-align:center;">Total</th>
        </tr>
        
        <?php $k=1;foreach($Academic_Fees as $list){?>
        <tr>
        <td style="padding:5px;text-align:center;"><?php echo $k;?></td>
		<td style="padding:5px;text-align:center;"><b><?php echo $list['Particulars'];?><b/></td>
        <?php if($all_data[0]['admission_year']==1){$ffk=1;$cp=0;}else{$ffk=2;$cp=1;} for($i=$ffk;$i<=$count+$cp;$i++){
		if($all_data[0]['admission_year']==1){if($i==1){$td="1st_year";}}else{} if($i==2){$td="2nd_year";}if($i==3){$td="3rd_year";}if($i==4){$td="4th_year";}
			 ?>
        <td style="padding:5px;text-align:center;"><?php echo $list[$td];?></td>
        <?php } ?>
     
        
         <td style="padding:5px; text-align:center;"><b><?php echo $list['Total'];?><b/></td>
         </tr>
         <?php $k++;} ?>
		
		
      </table>
			 <b> In addition to the academic fees mentioned above, the following will be applicable:</b>
			  <ol>
            <li><b>Hostel fee</b> will be subject to yearly revision.</li>
            <li>Rs. ___-____ for Computer/Laptop if needed.</li>
            <li>The Fee once paid will not be Refunded.</li>
            </ol>
           <b>All fee and charges indicated above are tentative and subject to revision by the Management.</b>
            <ol>
            <li>Kindly issue DD/Pay Order in favour of <b>“SANDIP UNIVERSITY” A/C. No. :
50100212258694. HDFC Bank, IFSC Code: HDFC0000118<b> payable at Mumbai for academic fees</li>
            <li>Kindly issue DD/Pay Order in favour of <b>“SANDIP FOUNDATION” A/C No.:
912010059716140,Axis Bank, IFSC Code: UTIB0001486</b> Payable at Madhubani, for Hostel fee..</li>
           <!-- <li>Kindly issue DD/Pay Order in favour of “____________________” payable at ________ for
transport charges.</li>-->
            </ol>
            <div align="center">This certificate is issued to him / her for the Loan purpose on his / her own request</div>
            <div style="">
                  <h4>Authorized Signatory. </h4>
               </div>
         </div>
        
            <!--<div>
               <div style="width:50%;float:left;10px!important;">
                  <h4>Authorized Signatory. </h4>
               </div>
               <div style="width:50%!important;;float:right!important;">
                  <h4 align="right" style="text-align:right!important;padding-top:30%!important;vertical-align:baseline;" class="men"></h4>
               </div>
            </div>-->
          <div style="clear:both!important;"></div>
      </div>
   </body>
</html>