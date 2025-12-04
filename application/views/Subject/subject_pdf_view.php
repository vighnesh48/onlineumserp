<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subject List</title>
    <style>  
    
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
.content-table td{border:1px solid #333;padding-left:5px;vertical-align:middle;}
.content-table th{border-left:1px solid #333;border-right:1px solid #333;border-bottom:1px solid #333;}
        </style>  

</head>


<body>
 
 
   <table align="center" width="700"> 
            <tbody>  
            <tr>
            <td valign="top" height="40">
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="800" style="">
            <tr>
<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="<?=base_url()?>assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
<td style="font-weight:normal;text-align:center;">
<h1 style="font-size:30px;">Sandip University</h1>
<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

</td>
<td width="120" align="right" valign="middle" style="text-align:center;padding-top:20px;">
<span style="border:0px solid #333;padding:10px;"></td>

<tr>
<td></td>
<td align="center" style="text-align:center;margin:0;padding:0" colspan=2><h3 style="font-size:14px;">Subject List - <?=$course[0]['stream_name']?>, Semester -<?=$semesterNo?></h3></td>
</tr>
<tr>
<td></td>
<td align="center" style="text-align:center;margin:0;padding:0" colspan=2><h3 style="font-size:14px;">Batch -<?=$batch?>, Regulation -<?=$regulation?></h3></td>
</tr>            
 </table>
            </td>
            </tr>

            
            
            <tr>
            <td class="marks-table"  style="padding:0;border-top:1px solid #333;">
            <table border="0" class="content-table" width="800" height="800">
            <tr>
			<th>S.No.</th>
            <th>Code</th>
			<th align="left">Subject Name</th>	
			<th>Evaluation Board</th>				
			<th>Type</th>			
			<th>Order</th>
			<th>Credits</th>
			<th>CIA</th>
			<th>TH</th>
			<th>PR</th>
			<th>Total</th>			
            </tr>

						<?php
                            $j=1; 
							$sum_credits =0;
							$sum_cia =0;
							$sum_Thery =0;
							$sum_pract =0;
							$sum_tot =0;
							
							if(!empty($subj_details)){
                            for($i=0;$i<count($subj_details);$i++)
                            {
								if($subj_details[$i]['subject_category']=='NCR'){
									$subject_category = '*';
								}elseif($subj_details[$i]['subject_category']=='MNR'){
									$subject_category = '**';
								}elseif($subj_details[$i]['subject_category']=='ADL'){
									$subject_category = '***';
								}elseif($subj_details[$i]['subject_category']=='URE'){
									$subject_category = '****';
								}else{
									$subject_category='';
								}

								$total = $subj_details[$i]['internal_max'] + $subj_details[$i]['theory_max']+ $subj_details[$i]['practical_max'];
								$sum_credits +=$subj_details[$i]['credits'];
								$sum_cia +=$subj_details[$i]['internal_max'];

								$sum_tot +=$total;  
								if($subj_details[$i]['subject_component']=='TH'){
									$sum_Thery += $subj_details[$i]['theory_max'];
								}else{
									$sum_pract += $subj_details[$i]['practical_max'];
								}
                            ?>
                            <tr >
                                <td align="center"><?=$j?></td> 
                               
                                <td align="center"><?=$subj_details[$i]['subject_code']?></td>	
								<td align="left"><?=$subj_details[$i]['subject_name']?> <?=$subject_category;?></td>
								<td align="left"><?=$subj_details[$i]['evaluation_board']?></td>									
								<td align="center"><?=$subj_details[$i]['subject_component']?></td>
								<td align="center"><?=$subj_details[$i]['subject_order']?></td>								
                                <td align="center"><?=$subj_details[$i]['credits']?></td>
                                <td align="center"><?=$subj_details[$i]['internal_max']?></td>
                                <td align="center">
									<?php 
									if($subj_details[$i]['subject_component']=='TH'){
									echo $subj_details[$i]['theory_max'];}else{ echo "-";}
									?>
								</td>
								<td align="center">
									<?php if($subj_details[$i]['subject_component']=='PR'){
									echo $subj_details[$i]['practical_max'];}else{ echo "-";}
									?>
								</td>	
                                
                                <td align="center"><?php
								echo $total;
								?></td>
                               
                              
                            </tr>
                            <?php
                            $j++;
							/*unset($sum_credits);
							unset($sum_cia);
							unset($sum_Thery);
							unset($sum_pract);
							unset($sum_tot);*/
                            }
							}
                            ?>    
						<tr >

                                <td colspan="6"><b>Total</b></td>
								<td align="center"><b><?=$sum_credits?></b></td>								
                                <td align="center"><b><?=$sum_cia?></b></td>
                                <td align="center"><b><?=$sum_Thery?></b></td>
                                <td align="center"><b><?=$sum_pract?></b></td>                              
                                <td align="center"><b><?php
								echo $sum_tot;
								?></b></td>
                               
                              
                            </tr>	
							<tr>
								<td colspan=10 style="border:0px !important">Notations: <small><b>TH</b>-Theory, <b>PR</b>-Practical, <b>EM</b>-Embeded Practical</small></td>
							</tr>
            
            </table>
            </td>
            </tr>


            </tbody>
            </table>
  


</body>
</html>
