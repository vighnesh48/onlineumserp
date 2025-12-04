   
     <table  id="search-table" class="table table-bordered table-list-search">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    
                                    <th>Applicant Name</th>
                                  <th>Department</th>
                                  <th>City</th>
                                   <th>Category</th>
                                     <th>Gender</th>
                                    <th>Mobile</th>
                                     <th>Email</th>
                                        <th>Amount</th>
                                        <th>Online&nbsp;Pay</th>  
                                   <th>Verification Status</th> 
									<th>Created on</th> 								   
                                    <th>Documets</th>     
                            </tr>
                            
                        </thead>
                        <tbody id="itemContainer"><?php
                            $j=1; 

						
						if(!empty($phd_data)){							
                            for($i=0;$i<count($phd_data);$i++)
                            {
                               
                            ?>
                            <tr  class="myHead">
                                <td><?=$j?></td>          
                                   
                                 <td><?=$phd_data[$i]['student_name']?></td>
                          <td><?=$phd_data[$i]['department']?></td> 
                            <td><?=$phd_data[$i]['city_c']?></td> 
                   <td><?=$phd_data[$i]['category']?></td> 
                    <td><?=$phd_data[$i]['gender']?></td> 
                    <td><?=$phd_data[$i]['mobile_no']?></td> 
                     <td><?=$phd_data[$i]['email_id']?></td> 
                      <td><?=$phd_data[$i]['amount']?></td> 
                     <td><?php
						   if($phd_data[$i]['fees_paid']=="Y")
                                            {
												echo "Paid";
											}else{echo "Pending";  } ?></td> 
                       <td>
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
                           echo "Rejected";         
                          }
                         
                          ?>
                            
                        </td> 
						<td><?=$phd_data[$i]['entry_on']?></td> 
                                            <td><a href="<?=base_url($currentModule."/documents/".$phd_data[$i]['phd_id'])?>">View</a>
                                             <?php
                                            if($phd_data[$i]['fees_paid']=="Y")
                                            {
                                             ?>
                                             <!-- <a href="<?=base_url($currentModule."/generate_admit_card/".$phd_data[$i]['phd_id'])?>">Generate Admit Card</a>  -->
                                             <?php
                                            }
                                            ?>
                                            </td> 
                     
                            </tr>
                            <?php
                            $j++;
                            }
						}else{ echo "<tr><td colspan=8>No data found</td></tr>";}
                            ?> 
                            </tbody>
                    </table> <!--   <a class="marksat" id="editpayment" data-dept="<?=$phd_data[$i]['department']?>"  data-stud_name="<?= $phd_data[$i]['student_name']; ?>" val="<?=$i?>" 
    						data-fees_id="<?=$phd_data[$i]['payment_id']; ?>" data-toggle="modal" data-target="#walkinModal" style="cursor:pointer"><button class="btn btn-primary btn-xs">Update Payment Status</button></a>
    	-->	
                                      <script>
$(document).ready(function() {
    $('#search-table').DataTable( {
        dom: 'Bfrtip',
        targets: 'no-sort',
bSort: false,
     bPaginate: false,
        buttons: [
            
            {
                extend: 'excelHtml5',
                title: 'PHD List'
            }
           /* {
                extend: 'pdfHtml5',
                title: 'PHD List'
            }*/
        ]
    } );

       
} );
</script>