
                                    <?php 
									$CI =& get_instance();
									$CI->load->model('Feedback_model');
									$i=1;
									$cmnt='';
									if(!empty($esuggestions)){
							foreach($esuggestions as $ec){ 
							
											
							?>							
								<tr>
									<td><?=$i?></th>
									<td><?=$ec['prn']?></th>
									<td><?=$ec['first_name'].' '.$ec['last_name']?></th>
									<td><?=$ec['stream_short_name']?></th>
									<td><?=$ec['current_semester']?></th>
									<td><?=date('d-m-Y', strtotime($ec['suggestion_date']))?></td>
									<!--td width="15%"><?=$ec['c_name']?></td-->
									
									<?php
									foreach($category as $ct){
										$comments =$this->Feedback_model->fetch_catewisecomments($ec['prn'],$ec['suggestion_date'], $ec['role_id'], $ct['c_id']);
										?>
										<td ><?=$comments[0]['comment'];?></td>
								<?php	}
								
									//unset($cmnt);
									?>
									
									
								</tr>
								<?php $i++;
                                    }
                                    }else{
                                        echo "<tr><td colspan=12>";echo "No data found.";echo "</td></tr>";
                                    }
                                    ?>                            
                    
   