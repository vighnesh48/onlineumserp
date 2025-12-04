<style>
body{font-size:12px;}
ul {
    list-style-position: outside;
}
ul>li {
        padding-bottom: 5px;
    }
</style> 
<?php
$CI =& get_instance();
$CI->load->model('Subject_model');

 function generateTreeView($items,$unitno,$topicno,$faculty,$subject,$datepl) {
    	//die;
    	foreach($items as $list)
    	{
    		if(($list['topic_no']==$topicno) && ($list['unit_no']==$unitno)  && ($list['faculty_id']==$faculty) && ($list['subject_id']==$subject) && $list['parents']!='0' && $list['planned_date']==$datepl)
    		{
    			$arrli[]=($list['topic_contents']);
    			
    		}
    	}

    	echo "<ul>";
    	foreach ($arrli as $key => $value) {
    	echo "<li>".$value."</li>";	
    	}
    	echo "</ul>";
        
    }//if(in_array("View", $my_privileges)) { ?>
                    <table class="content-table" cellpadding="5" cellspacing="0" border="1"  width="800" >
                       <thead style="background: #3da1bf !important;border-top-color: #3da1bf !important;color: #fff;border-color: #e2e2e2;">
								<tr>	
									<!--th>#</th-->
                                    <th>lecture No</th>
                                    <th>Unit No</th>
                                    <th>Topic No</th>
                                    <th>Topic to be Covered</th>
                                   
									<th>Planned date</th>
									<!-- <th>Actual Date</th> -->
									
								</tr>

								</thead>

								<tbody id="studtbl">

								<?php

								

								
								//echo "<pre>";

								//print_r($subj_details);
								$i=1;
								$str_cvrdtp='';	
								echo "<pre>";
								
									if(!empty($lessonplan)){

										foreach ($lessonplan as $lplan) {	
									
												$k=1;
											if($lplan['parents']=='0')
											{
												?>

													<tr>
														<!--td><?=$i?></td-->
														<td><?=$lplan['lecture_no']?></td>
														<td><?=$lplan['unit_no']?></td>
														<td><?=$lplan['topic_no']?></td>
														<td><? echo $lplan['topic_name'];?>
													<?php 
                                      			generateTreeView($lessonplan,$lplan['unit_no'],$lplan['topic_no'],$lplan['faculty_id'],$lplan['subject_id'],$lplan['planned_date']);
														?>
															

														</td>
														
														<td><?=$lplan['planned_date']?></td>
														<!-- <td><?php if($lplan['actual_date']=='0000-00-00'){ echo '-';}else{ echo $lplan['actual_date'];}?></td> -->
														
													

													</tr>
													
										<?php  unset($str_cvrdtp);
												$i++;
										}
									}
									}else{
										echo "<tr><td colspan='8'>No data found.</td></tr>";
									}
										?>
										</tbody>
                    </table>                    
                    <?php //} ?>