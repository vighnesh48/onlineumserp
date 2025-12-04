
<table width="100%" border="0" cellspacing="0" cellpadding="0"  style="" >
<tr>
<td valign="top" align="center"  style="padding:5px 5px 5px" colspan="3">
    <img src="https://erp.sandipuniversity.com/assets/images/logo_form.png">
    
</td>
</tr>
<tr>
<td valign="top"  width="100%" colspan="3" align="center" style="font-size:12px;">
<strong>Mahiravani, Trimbak Road, Nashik - 422 213,</strong>
<strong>Website:</strong> http://www.sandipuniversity.com<br>
<strong>Email:</strong> info@sandipuniversity.com,
<strong>Phone:</strong> (02594) 222541,42,43,44,45,
<strong>Fax:</strong> (02594) 222555
</td>
</tr>

</table>

  

  

  <table width="90%" border="1" cellspacing="0" cellpadding="0" align="center" style="margin-top:20px;margin-bottom:20px;">
  <br>
 <thead>
    <tr>
    
        <th align="left" width="">Sr No.</th>
        <th align="left" width="">Reg No. </th>
          <th align="left" width="">IC Name </th>
        <th align="left">Name</th>
        <th align="left">Exam Name</th>
        <th align="left" width="">Marks</th>
         <th align="left" width="">Ranking</th>
    </tr>
</thead>
<tbody>
	
	  <?php
               
             //  var_dump($emp_list);           
            //   exit();
                          
                            $j=1;                            
                            foreach($emp_list as $emp_list)
                            {
                                
                            ?>
												
                            <tr>
                               <td height="20"><?=$j?></td>
                        
                                 <td><?=$emp_list['reg_no']?></td> 
                                  <td><?=$emp_list['ic_name']?></td> 
                                <td>
							
							<?php
								echo $emp_list['student_name'];
								?>
								</td> 
								 <td><?=$emp_list['exam_name']?></td> 
								                    <td><?=$emp_list['marks'];?></td>  
                                <td><?=$emp_list['ranking'];?></td>    
                                                      
                                                        
                             
                            </tr>
                            <?php
                            $j++;
                            }
                            ?> 
	
	
	
	
	</tbody>
	
	
	
	
 
 
    </table>
   <br>
  