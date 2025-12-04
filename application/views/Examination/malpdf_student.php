
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
      <style>
body{font-family:'Time New Roman';text-align: justify; }

      .center {
         display: block;
         margin-left: auto;
         margin-right: auto;
         width: 26%;
         }
         .title1{ Font-weight: bold;
         Color: #03A9F4;
         text-transform: capitalize;
         font-size: 15px;
         padding-top: 20px;}
         .h4, h4 {
         font-size: 15px;
         Font-weight: bold;
         color: #000;
         }
         p {
         color: #000;
         font-size: 12px;
         line-height: 24px;
         }
         .mark {
         background: #ff0;
         color: #000;
         padding: 4px;
         font-weight: bold;
         }
         .padding-left{padding-left:10%;Font-weight: bold;}
         .padding-leftt{padding-left:10%;font-size: 12px;Font-weight: bold; }
		 @media (min-width: 1200px) {
    .container{
        max-width: 970px;
    }
}


    
            table {  
                font-family: arial, sans-serif;  
                border-collapse: collapse;  
                width: 100%; font-size:12px; margin:0 auto;
            }  
      td{vertical-align: top;}
                      
            .signature{
            text-align: center;
            }
            .marks-table{
            width: 100%;height:650px;
            }
            p{padding:0px;margin:0px;}
            h1, h3{margin:0;padding:0}
            .marks-table td{height:30px;vertical-align:middle;}
         
            .marks-table th{height:30px;}
            table th{background-color:#f2f2f2; }
table td{border:1px solid #333;padding-left:5px;vertical-align:middle; padding:5px!important;}
table th{border-left:1px solid #333;border-right:1px solid #333;border-bottom:1px solid #333;padding:5px!important}
strong.bo{text:bold;}
        </style> 

  
   </head>
   <body>
      <div class="container" style="border:#ccc solid 1px">
         <div class="row">
            <div class="col-sm-12 text-center">
               <h1><img src="<?=base_url()?>assets/images/LOGO-2019.jpg"  width="200px" class="img-responsive center"></h1>
               <p class="title1">OFFICE OF THE CONTROLLER OF EXAMINATIONS</p>
               <hr/>
            </Div>
         </div>
         <!-- Row 1-->
         <div class="row">
            <div class="col-sm-6">
               <h4 class="text-left">Lr.No: SUN/COE/<?php echo $exam_year."/".$exam_month."/".$malpractice_list[0]['school_short_name']."/MC/".$malpractice_list[0]['mal_practice_token'];?></h4>
            </div>
            <div class="col-sm-6">
               <h4 class="text-right"> Date: <?php echo date('d-m-Y');?>	</h4>
            </div>
         </div>
         <!-- Row 1-->
         <!-- Row 2-->
         <div class="row">
            <div class="col-sm-12">
               <h6><b>To</b></h6>
               <p class="padding-leftt"><?php
                  echo $malpractice_list[0]['first_name']." ".$malpractice_list[0]['last_name'];
                  ?><br/>
                  <?=$malpractice_list[0]['enrollment_no']?><br/>
                  <?=$malpractice_list[0]['stream_name']?> - <?=$malpractice_list[0]['current_year']?> year. <br/>
                 <?=$malpractice_list[0]['school_name']?>
               </p>
            </div>
         </div>
         <!-- Row 2-->
         <!-- Row3-->
         <br/>
         <div class="row">
            <div class="col-sm-12">
               <p style="margin-left: 10px;"><span style="font-weight: bold;">Sub:</span> Show cause notice in respect of Malpractice at the University Examination held in <strong style="font-weight: bold;"> <?=$exam_month." ".$exam_year?> </strong></p>
               <br/>
               <p>I write to inform you that the office of the Controller of Examinations has received a report about malpractice resorted  by you during the examination held in <strong style="font-weight: bold;"><?=$exam_month." ".$exam_year?></strong>. The details of the same have been committed by you are given below:-</p>
               <h6 class="padding-left;text-center" style="padding:5px;"><b>Examination : </b><?php if($malpractice_list[0]['exam_type']=='Makeup') { echo "Special Supplementary Exam March-2018"; } else { echo "End-Semester Examination";}?>   </h6>

               <table  cellpadding="0" cellspacing="0" border="1" width="100%" class="cell-padding" >
               <thead align="center">
                <tr>                        
               <th>S.No.</th>
               <th>Subject</th>
                <th>Semester</th>
               
               <th>Date of Examination</th>
               <th>Nature of Malpractice</th>
          
               </tr>
            </thead>
            <tbody id="itemContainer">
               <?php
            $j=1;
            if(!empty($malpractice_list)){
               for($i=0;$i<count($malpractice_list);$i++){
                                
            ?>
            <tr>
               <td><?=$j?></td>
                        
               <td width="15%"><?php echo $malpractice_list[$i]['subject_code']."-".$malpractice_list[$i]['subject_name']?></td> 
               <td><?=$malpractice_list[$i]['semester'];?></td>
                
               <td><?=date('d-m-Y', strtotime($malpractice_list[$i]['date']));?></td>
               <td width="50%"><?php echo $malpractice_list[$i]['remark']?></td>
 
            </tr>
            <?php
            $j++;
         } ?>
          <tr><td colspan='5'><span class="bold"><span style="font-weight: bold;">Total No of Malpractice</span>:&nbsp;<?=$malpractice_list[0]['malcount'];?></span></td></tr>
     <?php }else{ ?>
                        
         <tr><td colspan='5' align='center'>No data found.</td></tr>
         <?php }
      ?>          

            </tbody>
            </table> 
                 
         
               <br/>
               <p>The Malpractice case will be investigated by the Enquiry Committee. You are therefore asked to remain present before the said Committee in the <span style="font-weight: bold;"> <?=$malpractice_list[0]['build_block_date']?> </span>along with your written explanation to this Show Cause Notice. If you fail to appear before Committee, it will be presumed that you have nothing to say in this matter and the Committee will take decision in your case in absentia, on the basis of the available evidence/documents, which shall be binding on you.</p>
               <br/>
               <p><strong>Yours faithfully</strong><br/>
                  Controller of Examinations<br/>
                  <strong style="font-weight: bold;">Note: Forwarded through Dean with stamp</strong>
               </p>
            </div>
         </div>
         <!-- Row 3-->
      </div>
   </body>
</html>

