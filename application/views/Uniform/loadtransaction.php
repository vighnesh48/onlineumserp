<table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   
                                     <th width="5%"> Sr. No.</th>
                                     <th  width="5%">Transaction No</th>
                                     <th  width="20%">Student Name</th>
                                     <th  width="10%">Enrollment no</th>
                                     <th  width="10%">School</th>
                                     <th  width="10%">Remark</th>
                                     <th  width="5%" class="noExl">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            
                       //   var_dump($emp_list);
                            $j=1;                            
                            for($i=0;$i<count($transaction_list);$i++)
                            {
                                
                            ?>
							 								
                            <tr>
                               <td><?=$j?></td>
                        
                               
                                 
                                  <td><?=$transaction_list[$i]['transaction_no']."-".str_pad($transaction_list[$i]['transaction_id'], 4, '0', STR_PAD_LEFT);?></td> 
                                  <td><?=$transaction_list[$i]['firstname']?></td> 
								                  <td><?=$transaction_list[$i]['enrollment_no']?></td>
								                  <td><?=$transaction_list[$i]['organisation']."-".$transaction_list[$i]['institute']?></td>
                                  <td><?=$transaction_list[$i]['remark']?></td>
                                  
                                       <td>
									  <a  href="<?=base_url("Uniform/download_transaction_pdf/".$transaction_list[$i]['transaction_id'])?>" title="View" target="_blank" ><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a> 
									   
                                           </td> 
                           
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>   

                    <form method="post" action="<?=base_url()?>Ums_admission/generatepdf/">
                    <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">
                   <!--  <input type="submit" value="Generate PDF" class="btn btn-primary btn-labeled">-->
                     
                      <input type="button" id="expdata" value="Export as Excel" class="btn btn-primary btn-labeled">
                     </form>
                     <script>
                     $("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
  filename: "Fee Payment" //do not include extension

  });

});

                     </script>
                     