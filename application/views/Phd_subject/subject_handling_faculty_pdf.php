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
            width: 100%;
            }
            p{padding:0px;margin:0px;}
            h1{margin:0;padding:0}
            .marks-table td{height:30px;vertical-align:middle;}
			
            .marks-table th{height:30px;}
.content-table td{border:1px solid #333;padding-left:5px;vertical-align:middle;}
.content-table th{border-left:1px solid #333;border-right:1px solid #333;border-bottom:1px solid #333;}
        </style>  

</head>


<body>
 
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="800" style="">
            <tr>
<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="<?=base_url()?>assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
<td style="font-weight:normal;text-align:center;" colspan="2">
<h1 style="font-size:30px;">Sandip University</h1>
<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

</td>
<td width="120" align="right" valign="top" style="text-align:center;">
<span style="border:0px solid #333;padding:10px;font-size:30px;"><b>COE</b></span></td>
</tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" align="center" width="800" style="">
 <tr>
	<td align="center" colspan="4"><h3>Subject Handling Faculty Details</h3></td>
</tr>
 <tr>
	<td align="center" colspan="4">&nbsp;</td>
</tr>
<tr>
<td><b>Department:</b> <?=$course[0]['stream_name']?></td>
<td><b>Batch:</b> <?=$batch?></td>
<td><b>Semester:</b> <?=$semester?></td>
<td align="right"><b>Printed On:</b> <?=date('d-m-Y H:i:s')?></td>
</tr>         
 </table>
            <table border="1" class="content-table" width="800" style="margin-top:10px;">
             <thead>
                            <tr>
                                    <th rowspan="2" width="5%" class="valin">#</th>
                                    <th rowspan="2" class="valin">Course Information</th> 
									<th rowspan="2" width="5%" class="valin">Batch</th>
									<th rowspan="2" width="5%" class="valin">Sem</th>
									<th colspan="<?=count($ttdivisions);?>" style="text-align: -webkit-center;">Faculty Name</th>	
                                    <!--th width="10%">Mobile No.</th-->
                            </tr>
							
							<tr>
									<?php foreach($ttdivisions as $div){ ?>
										<th><?=$div['division'];?></th>	
									<?php } ?>						
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							$CI =& get_instance();
							$CI->load->model('Subject_model');
                            $j=1;
                            $fac_app =0;
                            //echo "<pre>";print_r($subject_details);
							if(!empty($subject_details)){
							foreach($subject_details as $sd)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>
								   
                                <td><?=$sd['subject_code']?>-<?=$sd['subject_name']?></td>
                                <td><?=$sd['batch']?></td>
								<td><?=$sd['semester']?></td>
                                
								<?php 
								foreach($ttdivisions as $div){
									$fc = $this->Subject_model->getSubFacDetails($sd['sub_id'], $sd['stream_id'],$sd['semester'],$div['division']);
								?>
								<td>
								<?php if(!empty($fc[0]['fname'])){ echo strtoupper($fc[0]['fname'].' '.$fc[0]['lname']);}else{ echo "-";}?><br>
									<?php if(!empty($fc[0]['mobile_no'])){ echo $fc[0]['mobile_no'];}?><br> 
								</td>	
								<?php unset($fc);}?>
								
								
                            </tr>
                            <?php
                            $j++;
                            }
							}else{
								echo "<tr>";echo "<td colspan=7>";echo "No data found.";echo "</td>";echo "</tr>";
							}
                            ?>  
						
                        </tbody>
            
            </table>
</body>
</html>
