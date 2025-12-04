<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <style>
table {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.table tr td {
	padding: 3px;text-align:center;
}
table {
    border-collapse: collapse;
}
</style>

</head>
<body>
<div align="center"  class="m" style="padding:20px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
		<td align="center" style="border-bottom:1px solid #000"><img src="<?=base_url('assets/images')?>/logo.jpg" />
		<p class="ps">Trimbak Road, Mahiravani, Nashik – 422 213</p>
		<p class="ps">www.sandipuniversity.edu.in | Email : info@sandipuniversity.edu.in </p>
		<p class="ps"><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></p>
		
		</td> 
	   </tr>         
	</table>
	<p><h3 align="center"><u>Conference Report</u></h3></p>
</div>

<div align="center"  class="m" style="padding:20px;">
	 
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table border="1" cellspacing="0" cellpadding="0" class="table">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    
                                    <th>Author Name</th>
                                  <th>Stream</th>
                                  <th>Mode</th>
                                   <th>Paper Title</th>
                                     <th>Affiliation</th>
                                    <th>Abstract</th>
                                     <th>Email</th>
                                        <th>Keywords</th>
                                 
                            </tr>
                            
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;  
						if(!empty($phd_data)){							
                            for($i=0;$i<count($phd_data);$i++)
                            {
                               
                            ?>
                            <tr  class="myHead">
                                <td><?=$j?></td>          
                                   
                                 <td width="150" ><?=$phd_data[$i]['participant_name']?></td>
                          <td><?=$phd_data[$i]['stream']?></td> 
                            <td><?=$phd_data[$i]['mode']?></td> 
                   <td><?=$phd_data[$i]['paper_title']?></td> 
                    <td><?=$phd_data[$i]['affiliation']?></td> 
                    <td><?=$phd_data[$i]['paper_abstract']?></td> 
                     <td><?=$phd_data[$i]['email']?></td> 
                      <td><?=$phd_data[$i]['keywords']?></td> 
                      
                       <!-- <td>
                          <?php
                          if($phd_data[$i]['verification']=="P")
                          {
                          echo "Pending";  
                           ?>
                          
          	<?php
    		
                          }
                          else if($phd_data[$i]['verification']=="V")
                          {
                         echo "Verified";     
                          }
                          else
                          {
                           echo "Cancelled";         
                          }
                         
                          ?>

							</td> 
							<td><a href="<?=base_url($currentModule."/documents/".$phd_data[$i]['phd_id'])?>">View</a> 
							<?php
							if($phd_data[$i]['fees_paid']=="Y")
							{
							?>
							| <a href="<?=base_url($currentModule."/generate_admit_card/".$phd_data[$i]['phd_id'])?>">Generate Admit Card</a> 
							<?php
							}
							?>

							</td> -->
                     
                            </tr>
                            <?php
                            $j++;
                            }
						}else{ echo "<tr><td colspan=8>No data found</td></tr>";}
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php //} ?>
               
</div>    
</body>
</html>