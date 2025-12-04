   <?php
  // var_dump($_SESSION);
   ?>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   
                                    <th>S.No.</th>
                                    <th>PRN</th>
                                    <th>Name</th>
									<th>Exam</th>
                                    <th>Stream </th>
									<th>Semester</th>
                                    <th>School</th>
									<?php
									if(!empty($emp_list[0]['exam_month'])){
										?>
									<th>Fees</th>
									<th>Edit</th>
                                    <th class="noExl">Exam Form</th>
									<th class="noExl">Hall-Ticket</th>
									<?php }else{?>
									 <th>Exam Form</th>
									<?php }?>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;
                            if(!empty($emp_list)){
                            for($i=0;$i<count($emp_list);$i++)
                            {
                                
                            ?>
							 <?php if($emp_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$emp_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
                                
                               <td><?=$j?></td>
                        
                                 <td><?=$emp_list[$i]['enrollment_no']?></td> 
 
                                <td>
							
								<?php
								echo $emp_list[$i]['first_name']." ".$emp_list[$i]['last_name'];
								?>
								</td> 
							<td><?=$exam[0]['exam_month'];?>-<?=$exam[0]['exam_year'];?></td> 
								<td><?=$emp_list[$i]['stream_name']?></td> 
                             
                                                      
                                <td><?=$emp_list[$i]['admission_semester'];?></td>   
                                
								 <td><?=$emp_list[$i]['school_short_name'];?></td>
								<?php
									if(!empty($emp_list[$i]['exam_month'])){
										?>
										
                                  <td><?=$fees[0]['amount'];?></td>
								<td class="noExl"><a  href="<?php echo base_url()."/examination/edit_exam_form/".base64_encode($emp_list[$i]['enrollment_no']).""?>" title="Edit" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"  ></i></a>&nbsp;&nbsp;&nbsp;&nbsp;</td> 
								
                                <td class="noExl"><a  href="<?php echo base_url()."/examination/download_pdf/".base64_encode($emp_list[$i]['stud_id']).""?>" title="View" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td> 
								
								<td class="noExl">
								<?php 
								//echo $emp_list[$i]['allow_for_exam'];
								if($emp_list[$i]['allow_for_exam']=='Y'){ ?>
									<a  href="<?php echo base_url()."/examination/hall_ticket/".base64_encode($emp_list[$i]['stud_id']).""?>" title="View" target="_blank" <?=$disable?>><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;
								<?php }else{ ?>
									<i class="fa fa fa-pause" aria-hidden="true"  style="font-size:20px;color:red;" title="Your Hall Ticket is Holded by Administration. pleease contact to exam section"></i> &nbsp;&nbsp;&nbsp;&nbsp;
								<?php }
								?>
								</td> 
								
								<?php }else{?>	
								<td class="noExl"><a  href="<?php echo base_url()."/examination/index/".base64_encode($emp_list[$i]['enrollment_no']).""?>" title="View" target="_blank"><button class="btn btn-primary" >Add</button> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td> 
								<?php }?>
                            </tr>
                            <?php
                            $j++;
                            }
							}else{ ?>
								<tr><td colspan='9' align='center'>This PRN is not Registered for this academic year.</td></tr>
							<?php }
                            ?>                            
                        </tbody>
                    </table>  
