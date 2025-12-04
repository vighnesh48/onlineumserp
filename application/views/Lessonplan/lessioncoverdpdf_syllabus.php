<style>
body{font-size:12px;}
ul {
    list-style-position: outside;
}
ul>li {
        padding-bottom: 5px;
    }
</style> 
<?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="content-table" cellpadding="5" cellspacing="0" border="1" width="100%">
                        <thead style="background: #3da1bf !important;border-top-color: #3da1bf !important;color: #fff;border-color: #e2e2e2;">
								<tr>	
									<!--th>#</th-->
                                   
                                    <th>Unit No</th>
                                    <th>Topic No</th>
                                    <th>Covered Topic</th>
                                   
									<th>Actual covered date</th>
									<!-- <th>Actual Date</th> -->
							
								</tr>

								</thead>

								<tbody id="studtbl">

								<?php

								

								$CI =& get_instance();

								$CI->load->model('lessonplan_model');
								/*echo "<pre>";*/

							//	print_r($Syllabus_Covered);

								$i=1;
								$str_cvrdtp='';	
									if(!empty($Syllabus_Covered)){

										foreach ($Syllabus_Covered as $lplan) {	

											

									
												?>

													<tr>
														<!--td><?=$i?></td-->
														
														<td><?=$lplan['unit_no']?></td>
														<td><?=$lplan['topic_no']?></td>
														<td><?php if($lplan['is_from_lesson_plan']=='Y')
														{

															$result =$CI->lessonplan_model->maintopicshow($lplan['subject_id'],$lplan['unit_no'],$lplan['topic_no'],$lplan['coverd']);
															echo $result[0]['topic_name'];
															foreach($result as $list){
														echo "<ul><li>".$list['topic_contents']."</li></ul>";
															}

														} 
														else
														{
															echo "<ul><li>".$lplan['other_topic']."</li></ul>";

														}
														?></td>
                                                      
														<td><?=$lplan['attendance_date']?></td>
														
														
													<!-- <td>
														<a href="<?=base_url()?>lessonplan/delete/<?=base64_encode($subdetails)?>/<?=base64_encode($lplanid)?>"><button type="button" class="btn btn-info">Delete</button>
														</td> -->

													</tr>
													
										<?php  //unset($str_cvrdtp);
												$i++;
										}
									}else{
										echo "<tr><td colspan='8'>No data found.</td></tr>";
									}
										?>
										</tbody>
											
                    </table>                    
                    <?php //} ?>