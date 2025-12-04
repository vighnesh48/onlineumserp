<table border="1" class="content-table" width="800">
            <tr>
			<th align="center" width="5%" class="valin">#</th>
			<th align="center" width="5%" class="valin">PRN</th>
			<th class="valin">Student Name</th> 
			<th align="left" class="valin">Mobile</th>	
            </tr>

						<?php
							$j=1;
                            //echo "<pre>";print_r($student_details);
							if(!empty($student_details)){
							foreach($student_details as $sd)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>
								<td><?=$sd['enrollment_no']?></td>   
                                <td><?=ucfirst($sd['first_name'].' '.$sd['middle_name'].' '.$sd['last_name']);?></td>
								<td><?=$sd['mobile']?></td>
								<!--td><?=$sd['stream_name']?></td> 
                                <td><?=$sd['semester']?></td>
                                <td><?=$sd['division']?></td-->	
								
                            </tr>
                            <?php
                            $j++;
							
                            }
							}
                            ?>               
            </table>						