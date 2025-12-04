<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detaintion List</title>
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
	<td align="center" colspan="4"><h3>Detention List For - <?php 
	/*if(!empty(school_name)){
		echo $school_name[0]['school_name'];echo '<br>';
	}*/
	?><?=$examses?></h3></td>
</tr>
 
 </table>
            <table border="1" class="content-table" width="800" style="margin-top:10px;">
             <thead>
				<tr>
									   
				<th>S.No.</th>
				<th>PRN</th>
				<th>Name</th>
				<th>Detain Date</th>
				<th>School</th>
				<th>Stream </th>
				<th>Sem</th>
				<th>Reason</th>		
				</tr>

            </thead>
				<tbody id="itemContainer">
					<?php
		$j=1;
		if(!empty($detaintion_list)){
			for($i=0;$i<count($detaintion_list);$i++){
                                
				?>
				<?php if($detaintion_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
				else $bg="";?>								
				<tr <?=$bg?> <?=$detaintion_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
                                
					<td><?=$j?></td>
                        
					<td><?=$detaintion_list[$i]['enrollment_no']?></td> 
 
					<td>	
						<?php
						echo $detaintion_list[$i]['first_name']." ".$detaintion_list[$i]['last_name'];
						?>
					</td> 
					<td><?=date('d-m-Y', strtotime($detaintion_list[$i]['created_on']));?></td> 
					<td><?=$detaintion_list[$i]['school_name'];?></td>
					<td><?=$detaintion_list[$i]['stream_short_name'];?></td>
					<td><?=$detaintion_list[$i]['semester'];?></td>  
					  	
					<td><?php if($detaintion_list[$i]['reason']!=''){ echo $detaintion_list[$i]['reason'];}?></td>
								
								
							
				</tr>

				<?php
				$j++;
			}
		}else{ ?>
								
			<tr><td colspan='7' align='center'>No data found.</td></tr>
			<?php }
		?>             
				</tbody>
            
            </table>
</body>
</html>
