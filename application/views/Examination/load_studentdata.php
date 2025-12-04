   <?php
  // var_dump($_SESSION);
   ?>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="table-responsive">
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
									if(!empty($emp_list[0]['exam_details'][0]['exam_month']) && $emp_list[0]['exam_details'][0]['exam_month'] == $exam[0]['exam_month']){
										?>
									<th>Fees</th>
									<!--th>Edit</th-->
									<?php if($this->session->userdata('role_id')!=4 && $this->session->userdata('role_id')!=9){?>
                                    <th class="noExl">Exam Form</th>
                                    <?php if($emp_list[0]['exam_details'][0]['exam_fees']!=0){ ?>
                                    <!--th class="noExl">Arrear Form</th-->
                                    <?php } ?>
									<th class="noExl">Hall-Ticket</th>
									<?php }if($this->session->userdata('role_id')==4 || $this->session->userdata('role_id')==9){?>
									 <th class="noExl">Exam Form</th>
									 <?php if($emp_list[0]['exam_details'][0]['exam_fees']!=0){ ?>
                                    <!--th class="noExl">Arrear Form</th-->
                                    <?php } ?>
									<th class="noExl">Action</th>
									<?php }else{ ?>
										<th class="noExl">Action</th>
									<?php }?>
									<?php }else{?>
									 <th>Exam Form</th>
									<?php }?>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;
							//echo "<pre>";
							//print_r($emp_list);
							 //if(!empty($emp_list[0])){
                            if(!empty($emp_list)){
							 
                            for($i=0;$i<count($emp_list);$i++)
                            {
                            	if($exam[0]['exam_type']=='Regular'){
									$semester = $emp_list[$i]['current_semester'];
								}else{
									$semester = $emp_list[$i]['exam_details'][0]['exam_semester'];
								}
                                
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
                             
                                                      
                                <td><?=$semester;?></td>   
                                
								 <td><?=$emp_list[$i]['school_short_name'];?></td>
								<?php
									if(!empty($emp_list[$i]['exam_details'][0]['exam_month']) &&  $emp_list[$i]['exam_details'][0]['exam_month']== $exam[0]['exam_month']){
										?>
										
                                  <td><?=$emp_list[$i]['exam_details'][0]['exam_fees'];?></td>

								<?php if($this->session->userdata('role_id')!=4 && $this->session->userdata('role_id')!=9  && ($this->session->userdata('role_id')==15
								|| $this->session->userdata('role_id')==14 || $this->session->userdata('role_id')==6|| $this->session->userdata('role_id')==66 
								|| $this->session->userdata('role_id')==69 || $this->session->userdata('role_id')==65 )){?>
                                <td class="noExl"><a  href="<?php echo base_url()."examination/download_pdf/".base64_encode($emp_list[$i]['stud_id'])."/".base64_encode($exam[0]['exam_id'])."/"?>" title="View" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td> 
								<?php if($emp_list[0]['exam_details'][0]['exam_fees']!=0){ ?>
                                    <!--td class="noExl"><a  href="<?php echo base_url()."examination/download_arrearpdf/".base64_encode($emp_list[$i]['stud_id'])."/".base64_encode($exam[0]['exam_id'])."/"?>" title="View" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td-->
                                    <?php } ?>
								<td class="noExl">
								<?php 
								
								if($emp_list[$i]['exam_details'][0]['allow_for_exam']=='Y'){ ?>
									<a  href="<?php echo base_url()."examination/hall_ticket/".base64_encode($emp_list[$i]['stud_id']).""?>" title="View" target="_blank" <?=$disable?>><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;
								<?php }else{ ?>
									<i class="fa fa fa-pause" aria-hidden="true"  style="font-size:20px;color:red;" title="Your Hall Ticket is Holded by Administration. pleease contact to exam section"></i> &nbsp;&nbsp;&nbsp;&nbsp;
								<?php }
								?>
								</td> 

								<?php }if($this->session->userdata('role_id')!=4 && $this->session->userdata('role_id')!=9 && $this->session->userdata('role_id')==15){?>
									<td class="noExl">
									<a  href="<?php echo base_url()."examination/edit_exam_form/".base64_encode($emp_list[$i]['enrollment_no']).""?>" title="Edit" target="_blank" <?=$disable?>><i class="fa fa-edit" aria-hidden="true"  style="font-size:20px;"></i> </a> <br>|| <br><a  href="<?php echo base_url()."examination/delete_exam_form/".$emp_list[$i]['enrollment_no']."/".$exam[0]['exam_id']?>" title="Delete" target="_blank" <?=$disable?> onclick = "if (! confirm('Delete this exam form?')) { return false; }"><i class="fa fa-trash" aria-hidden="true"  style="font-size:20px;"></i> </a> <br> <!--|| <a  href="<?php echo base_url()."examination/edit_exam_form_contocoe/".base64_encode($emp_list[$i]['enrollment_no']).""?>" title="Edit" target="_blank" <?=$disable?>>Update Subjects </a-->	
								</td> 
									<?php }else if($this->session->userdata('role_id')==4){
										//echo $emp_list[$i]['exam_details'][0]['exam_fees']; echo ' ==ol-'.$online_fees[0]['amount'];
										//print_r($online_fees);
										?>
									<?php if($emp_list[$i]['exam_details'][0]['exam_fees'] ==0 || ($online_fees[0]['amount'] >=$emp_list[$i]['exam_details'][0]['exam_fees'])){
									?>
									<td class="noExl"><a  href="<?php echo base_url()."examination/download_pdf/".base64_encode($emp_list[$i]['stud_id'])."/".base64_encode($exam[0]['exam_id'])."/"?>" title="View" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <!--td class="noExl"><a  href="<?php echo base_url()."examination/download_arrearpdf/".base64_encode($emp_list[$i]['stud_id'])."/".$exam[0]['exam_id']."/"?>" title="View" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td-->
									<?php }else if($emp_list[$i]['exam_details'][0]['exam_fees'] !=0 && ($emp_list[$i]['exam_details'][0]['exam_fees']!=$online_fees[0]['amount'])){?>
									
									
									 <td class="noExl"><a  href="#" onclick="feesnotpaid();" title="View"><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <!--td class="noExl"><a  href="<?php echo base_url()."examination/download_arrearpdf/".base64_encode($emp_list[$i]['stud_id'])."/".$exam[0]['exam_id']."/"?>" title="View" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td-->
                                    <?php }?>
										<td class="noExl">
									<a  href="<?php echo base_url()."examination/view_form/".base64_encode($emp_list[$i]['enrollment_no']).""?>" title="view" target="_blank" <?=$disable?>><i class="fa fa-eye" aria-hidden="true"  style="font-size:20px;"></i> </a>	<!--|| <a  href="<?php echo base_url()."examination/edit_exam_form_student/".base64_encode($emp_list[$i]['enrollment_no']).""?>" title="Edit" target="_blank" <?=$disable?>><i class="fa fa-edit" aria-hidden="true"  style="font-size:20px;"></i> </a-->
								</td> 
							
									<?php }?>
								<?php }else{?>	
								<td class="noExl"><a  href="<?php echo base_url()."examination/index/".base64_encode($emp_list[$i]['enrollment_no']).""?>" title="View" target="_blank"><button class="btn btn-primary" >Add</button> </a>&nbsp;&nbsp;&nbsp;&nbsp;
								<?php if($this->session->userdata('role_id')!=4 && $this->session->userdata('role_id')!=9){?>
									 <!--a  href="<?php echo base_url()."examination/edit_exam_form_contocoe/".base64_encode($emp_list[$i]['enrollment_no']).""?>" title="Edit" target="_blank" <?=$disable?>>Update Subjects </a-->	
								<?php }?>
								
								</td> 
								<?php }?>
                            </tr>
                            <?php
                            $j++;
                            }
							?>
								
								
							<?php 
							}else{ ?>
								
								<tr><td colspan='11' align='center'>This PRN is not Registered for this academic year.</td></tr>
							<?php }
                            ?>                            
                        </tbody>
                    </table>  
</div>		
<script>
function feesnotpaid(){
	alert("Updated Backlog Exam fees not Paid. Go to My menu=>Pay online and pay exam fees");
}
</script>