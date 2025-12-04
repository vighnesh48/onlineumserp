   <?php
  // var_dump($_SESSION);
   ?>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="table-responsive">
<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url('Examination/allow_student_for_exam')?>" method="POST">
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
									<th>Remark</th>
									<th>Upload Doc</th>
									<th>Action</th>
									
									
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
								<td><textarea class="form-control" name='remark' id='remark' required></textarea>
								<input type='hidden' class="form-control" name='exam_id' id='exam_id' value='<?=$exam[0]['exam_id']?>'>
								<input type='hidden' class="form-control" name='student_id' id='student_id' value='<?=$emp_list[$i]['stud_id']?>'>
								<input type='hidden' class="form-control" name='enrollment_no' id='enrollment_no' value='<?=$emp_list[$i]['enrollment_no']?>'>
								</td>
								<td><input type='file' class="form-control" name='doc' id='doc'></td>
								<td class="noExl"><a  href="<?php echo base_url()."examination/index/".base64_encode($emp_list[$i]['enrollment_no']).""?>" title="View" target="_blank"><button type="submit" class="btn btn-primary" >Allow for exam</button> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td> 
								 
								
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
					</form>
</div>					
