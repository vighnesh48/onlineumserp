<html>
<Head>
	<title>
	Provisional Certificate
</title>
<style>.container {
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
}</style><style>
    .wrapper{position:relative;}
    .right,.left{width:50%; position:absolute;}
    .right{right:0;}
    .left{left:0;}
</style> <meta name="viewport" content="width=device-width, initial-scale=1">
 
</Head>
   <body style="font-size:12.5px; text-align: justify;text-justify: inter-word;">
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
        
		//Daughter/Son
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
        
        ?>
      <div style="width:100%!important; margin:auto!important;padding:2px 5px!important;">
         <!--<div  align="center" style="text-align:center!important;">
            <img src="https://www.sandipuniversity.edu.in/images/sandip-university-logo.png" alt="Sandip University Logo"><br/>
            <p align="center" style="font-size:15px!important;padding:0px 3%!important;line-height:24px!important"><strong>Neelam Vidya Vihar,Village Sijoul,Madhubani,Bihar</strong><br/>
               <span>Website</span> :http://www.sandipuniversity.edu.in <span>Email : </span>info.sijoul@sandipuniversity.edu.in</span>
               <span>Ph</span> : 1800-313-2714<br/>
            </p>
         </div>--><div  align="center" style="text-align:center!important;">
            <img src="https://www.sandipuniversity.edu.in/images/sandip-university-logo.png" alt="Sandip University Logo" width="300"></div>
	             
              <br><br>
            <div>
<div style="font-size:11.5px !important;"><b>Ref-:SUM/<?php //echo $all_data[0]['full_ref_no'];?><?php echo $all_data[0]['stream_name'];?>/2021-2022/<?php echo $all_data[0]['ref_no'];?></b></div>
<div style="float:right;margin-top:-30px !important; margin-left:600px !important;font-size:11.5px !important;"><b>Date-:<?php  $all_data[0]['date_in']; echo date("d-m-Y", strtotime($all_data[0]['date_in']));?></b></div>
</div>
<br>
         <div style="font-size:15px !important;">
            <div align="center" style="text-align:center!important;font-size:19.5px; font-family:Georgia, 'Times New Roman', Times, serif"><em><u>ADMISSION LETTER</u></em></div>
           
			<p>This is to certify that <b><?php echo $title;?> <?php echo $name;?></b>  <?php echo $off;?> of <b><?php echo $all_data[0]['father_name'];?></b> is being selected on the merit basis in <b><?php echo $all_data[0]['stream_name'];?> <?php echo $Lateral;?></b> in  Sandip  University,  Sijoul,  Madhubani  for  the academic year 2020-2021.</p> 
             
    <p>The <b>Sandip  University</b>,Sijoul  is  approved  by  Government  of  Bihar  through  <b>notification</b> (letter no.15/MI-53/2014-1146)dated <b>08th June 2017</b>and <b>Bihar   Gazette Publication</b> (No-25) on <b>dated 21st June 2017</b> and <b> University Grant Commission (UGC) </b>Letter No. F.5-3/2018(CPP-I/PU) dated 06th June 2018 stating that the Sandip   University is empowered to award degree as specified under section 22 of UGC Act. </p>    

			
           
         </div>
        
          
         
          <div style="">
                  <h4>Authorized Signatory. </h4>
               </div>
      </div>
       
      <div  align="center" style="text-align:center!important; margin-top:120 !important;">
      <hr/>
            <!--<img src="https://www.sandipuniversity.edu.in/images/sandip-university-logo.png" alt="Sandip University Logo">--><div align="center" style="font-family:Times,serif;font-size:16.3px;color:rgb(255,0,0);font-weight:bold;font-style:normal;text-decoration: none">SANDIP UNIVERSITY</div>
            <div align="center" style="font-family:Times,serif;font-size:10.3px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none"><span class="cls_013" >Neelam Vidya Vihar Sijoul,Post: Mailam, Dist.: Madhubani, Bihar - 847235 * Contact: 7549991044/7549991043 </span></div>
            
               <div align="center" style="font-family:Times,serif;font-size:10.3px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none"><b>Website:</b></span>http://www.sandipuniversity.edu.in <span><b>Email:</b></span>info.sijoul@sandipuniversity.edu.in</span></div>
               
            </div>
         </div>
   </body>
</html>