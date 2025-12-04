<table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   
                                     
                                    <th width="5%"> Sr. No.</th>
                                    <th  width="5%">Receipt No.</th>
                                     <th  width="10%">Bank Ref No</th>
                                    <th  width="20%">Name</th>
                                   <!-- <th>Phone</th>
                                    <th>Email</th>-->
                                     <th  width="5%">Amount </th>
                                    <th  width="5%"> Mode </th>
                                 <th  width="5%">Trans Status</th>
                                    <th  width="5%">Payment Date</th>
                                     <th  width="5%">Verify Status</th>
                                    
                                    <th  width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            
                          
                            $j=1;                            
                            for($i=0;$i<count($emp_list);$i++)
                            {
                                
                            ?>
							 <?php if($emp_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$emp_list[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                               <td><?=$j?></td>
                        
                                 <td>
                                     <?php if($emp_list[$i]['payment_status']=="success")
                                     {
                                         
                                     ?>
                                     
                                     <a href="http://www.sandipuniversity.com/payment/chpdf/receipt_<?=$emp_list[$i]['bank_ref_num']?>.pdf" target="_blank"> <?=$emp_list[$i]['receipt_no']?></a>
                                     
                                     <?php
                                     }
                                     else
                                     {
                                    echo $emp_list[$i]['receipt_no'];
                                     }
                                     ?>
                                     </td> 
                                  <td><?=$emp_list[$i]['bank_ref_num']?></td> 
                                <td>
							
							<?php
								echo $emp_list[$i]['firstname'];
								?>
								</td> 
								 <!--<td><?=$emp_list[$i]['phone']?></td> 
								   <td><?=$emp_list[$i]['email']?></td> -->
                                                                                              
                            <td><?=$emp_list[$i]['amount']?></td>                               
                                                      
                                <td><?=$emp_list[$i]['payment_mode'];?></td> 
                                      <td><?=$emp_list[$i]['payment_status']?></td> 
                               
                               
                                  <td><?=$emp_list[$i]['payment_date'];?></td> 
                                 <td><?php if($emp_list[$i]['verification_status']=="Y"){echo "Approved";} else{ echo "Pending";}?></td> 
                                  
                                       <td>
                                          <?php
                                           if($emp_list[$i]['verification_status']=="N" && $emp_list[$i]['payment_status']=="success"){
                                           ?>
                                           <a href="#" onclick="update_paymentstatus('<?=$emp_list[$i]['payment_id']?>')">Verify</td> 
                                            <?php
                            }
                             if($emp_list[$i]['payment_status']=="failure" && $emp_list[$i]['verification_status']!="R"){
                                           ?>
                                           <a href="#" onclick="remove_list('<?=$emp_list[$i]['payment_id']?>')">Remove</a> 
                                            <?php
                            }
                            ?>
                             <!--   <td><a  href="<?php echo base_url()."ums_admission/viewPayments/".$emp_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-credit-card" aria-hidden="true"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td>                         
                                <td><a  href="<?php echo base_url()."/Subject_allocation/view_studSubject/".$emp_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-book" aria-hidden="true"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td>                         
                                <td>
                                    <p> 
			<a  href="<?php echo base_url()."ums_admission/view_studentFormDetails/".$emp_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-eye"></i>  </a>&nbsp;&nbsp;&nbsp;&nbsp;
	        <a  href="<?php echo base_url()."ums_admission/edit_personalDetails/".$emp_list[$i]['stud_id'].""?>" title="Edit"><i class="fa fa-edit"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;
                             </td>-->
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>   
                    <form method="post" action="<?=base_url()?>Ums_admission/generatepdf/">
                    <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">
                   <!--  <input type="submit" value="Generate PDF" class="btn btn-primary btn-labeled">-->
                     
                      <input type="button" id="expdata" value="Export as Excel" class="btn btn-primary btn-labeled">
                     </form>
                     <script>
                     $("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
  filename: "Fee Payment" //do not include extension

  });

});

                     </script>
                     