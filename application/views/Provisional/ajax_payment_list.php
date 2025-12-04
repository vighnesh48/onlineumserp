   <?php
                            $j=1;  
						if(!empty($payment_data)){							
                            for($i=0;$i<count($payment_data);$i++)
                            {
                               
                            ?>
                            <tr  class="myHead">
                             <td><?=$j?></td>          
                             <td><?=$payment_data[$i]['prov_reg_no']?></td> 
                             <td><?=$payment_data[$i]['adm_form_no']?></td> 
                             <td><?=$payment_data[$i]['student_name']?></td>
                             <td><?=$payment_data[$i]['admission_year']?></td> 
                             <td><?=$payment_data[$i]['mobile1']?></td>
                             
                             <td><?php if($payment_data[$i]['type_id']==2){echo "Admission";}elseif($payment_data[$i]['type_id']==1){echo "Form";}else{ echo "Hostel";}?></td>
                             <td><?=$payment_data[$i]['amount']?></td>
                             <td><?=$payment_data[$i]['fees_paid_type']?></td>
                             
                           	 <td><?php if($payment_data[$i]['fees_paid_type']=="CHLN"){} else{ echo $payment_data[$i]['bank_name'];}; ?></td>
                              <!--<td><?=$payment_data[$i]['bank_city']?></td>-->
                             <td class="noExl"><a href="<?=base_url($currentModule."/viewPayments/".$payment_data[$i]['student_id'])?>" title="View" target="_blank">
                             <i class="fa fa-credit-card" aria-hidden="true"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>
                         <?php if($payment_data[$i]['payment_status']=="P"){$stat ="Pending";}
                         elseif($payment_data[$i]['payment_status']=="V"){$stat ="Verified";}
                         elseif($payment_data[$i]['payment_status']=="R"){$stat ="Rejected";}
                           elseif($payment_data[$i]['payment_status']=="C"){$stat ="Cancelled";} 
                           echo $stat;
                         ?>
                                </td>
                                 <td>
                              <?php if($payment_data[$i]['payment_status']=="V"){?>
                     		<a href="<?=base_url($currentModule."/generate_payment_receipt/".$payment_data[$i]['fees_id'])?>" title="View" target="_blank">
                               <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i></a>         
                           
                    
                  <!--   <a class="marksat" id="editpayment" data-reg_no="<?=$payment_data[$i]['prov_reg_no']?>"  data-stud_name="<?= $payment_data[$i]['student_name']; ?>" val="<?=$i?>" 
    						data-fees_id="<?=$payment_data[$i]['fees_id']; ?>" data-exam_fee="<?= $inst['exam_fees']; ?>" data-exam="<?= $ext; ?>" data-exam_id="<?= $inst['exam_id']; ?>" data-applicable_fee="<?= $inst['exam_session']; ?>" data-toggle="modal" data-target="#walkinModal" style="cursor:pointer"><button class="btn btn-primary btn-xs">Update Payment Status</button></a>
    				-->
    				
    				
    				
                                </td>
                               
                                      <td>
                              <?php /*if($payment_data[$i]['is_cancelled']=="Y"){
                                  echo "<span style='color:red'>CANCELLED</span>";
                              }else{
								  echo '-';
							  }*/
                             /* if($payment_data[$i]['is_confirmed']=="Y"){
                                  echo "<span style='color:red'>Done</span>";
                              }else{
								  echo 'Pending';
							  }*/
							  if($payment_data[$i]['is_cancelled']=="Y"){
 echo "<span style='color:red'>Cancelled</span>";
  }else{
   if($payment_data[$i]['is_confirmed']=="Y"){
  echo "<span style='color:green'>ERP Entry Done</span>";
  
   }else{
  
   if($payment_data[$i]['is_verified']=="Y"){
   echo "<span style='color:#07c4fd'>Verified</span>";
   }else{
	echo "Pending";}
   }
  }
							  
							  
                              ?>
                              
                              
                                 </td>   
                                <?php
                              }
                                ?>
                            </tr>
                            <?php
                            $j++;
                            }
						}else{ echo "<tr><td colspan=8>No data found</td></tr>";}
                            ?>    