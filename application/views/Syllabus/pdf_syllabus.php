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
                    <table class="content-table" cellpadding="5" cellspacing="0" border="1">
                        <thead style="background: #3da1bf !important;border-top-color: #3da1bf !important;color: #fff;border-color: #e2e2e2;">
                            <tr>
                                    <!--th>#</th-->  
                                    <th>Unit No.</th>
                                    <th>Topic Name</th>
                                    <!--th>Action</th-->
                            </tr>
                        </thead>
                        <tbody id="subjectList">
							<?php 
							$CI =& get_instance();
							$CI->load->model('Syllabus_model');
							
							$j=1;
							if(!empty($topic_details)){
								foreach($topic_details as $tpc){
								$stopc =$CI->Syllabus_model->get_uniquesubtopics($tpc['subject_id'], $tpc['unit_no']);
								?>
									<tr>
                                    <!--td><?=$j?></td-->  
									<td valign="top"><?=$tpc['unit_no']?></td>  
									 <td>
									     <?php
									     if(!empty($stopc)){
													foreach($stopc as $sutpc){?>
														
													<strong><?=$sutpc['topic_name']?></strong> 
												
												
									     <ul class="a">
									 <?php
									 $subtopc =$CI->Syllabus_model->get_subtopic_details($tpc['subject_id'], $tpc['unit_no'], $sutpc['topic_no']);
												$k=1;
												if(!empty($subtopc)){
													foreach($subtopc as $stpc){?>
														
														<li style="padding-bottom:10px;"><?=$stpc['topic_contents']?></li> 
												
												<?php 
												$k++;
													}
												}
												?>
									 </ul><br>
									 <?php 
									 
													}
									     }
									 ?>
									 </td>  
                            </tr>

								<?php
								$j++;
								    
								}
							}
							?>
                        </tbody>
                    </table>                    
                    <?php //} ?>