                  <div class="table-info">    
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
                            <th>sno</th>
                            <th>Academic Year</th>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>From Month</th>
                            <th>Amount</th>
 <th>Action</th>
                            </tr>
                        </thead>
					 <tbody id="itemContainer">
                            <?php 							
                            $j=1;                            
                            for($i=0;$i<count($incre_data);$i++){?>                          
                            <tr>
							    <td><?=$j?></td>                               		
								<td><?=$incre_data[$i]['academic_year']?></td>
								<td><?=$incre_data[$i]['emp_id']?></td>
                                <td><?=$incre_data[$i]['fname'].' '.$incre_data[$i]['lname']?></td>
                                <td><?=$incre_data[$i]['from_month']?></td>
								<td><?=$incre_data[$i]['amount']?></td>
<td><a href="<?=base_url($currentModule.'/staff_basic_salary_increment/'.$incre_data[$i]['id'].'/'.'Y')?>" title="Edit"><i class="fa fa-edit"></i></a></td>
                            </tr>
							<?php $j++;
							}?>
                          </tbody> 							
                      </table> 					
                    </div>
						
<script>
 $(document).ready(function (){
		$('#example').DataTable({
						orderCellsTop: true,
                        fixedHeader: true,
						dom: 'lBfrtip',
					    destroy: true,
						retrieve:true,
						paging:true,
						buttons: [
							 'excel'
						],
						lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],					  
					  });
	           }); 	   
</script>			   