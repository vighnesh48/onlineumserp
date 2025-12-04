       

       <table class="table table-bordered" id="search-table" style="width:100%;max-width:100%;">
                        <thead>
                            <tr>
                            <th>#</th>                             
                            <th>Enrollment&nbsp;No</th>
                            <th>Student&nbsp;Name</th>
                            <th>Receipt&nbsp;No</th> 
                            <th>Created&nbsp;On</th>
                            <th>Mode</th>
                            <th>Transaction&nbsp;No</th>
                            <th>Trans&nbsp;Date</th>
                            <th>Student&nbsp;Bank </th>
                            <th>Amount</th>  
                            <th>Course&nbsp;Name</th>
                            <th>Year</th>
                            <th>Bank</th>  
                            <th>Status</th>            
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;                      
                            for($i=0;$i<count($challan_details);$i++)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td> 
                                 <td><?=$challan_details[$i]['enrollment_no']?></td>                                                               
                             <td><?=$challan_details[$i]['first_name']."".$challan_details[$i]['last_name']?></td>
                             <td><?=$challan_details[$i]['exam_session'];?></td>
                    <td><?php  echo date('d-m-Y',strtotime($challan_details[$i]['created_on'])); ?></td>
                    <td><?=$challan_details[$i]['fees_paid_type']?></td>
                    <td><?=$challan_details[$i]['TransactionNo']?></td>
                    <td><?php if($challan_details[$i]['TransactionDate']!=''){ echo date('d-m-Y',strtotime($challan_details[$i]['TransactionDate'])); }?></td>
                             <td><?=$challan_details[$i]['student_bank']?></td>  
                                <td><?=$challan_details[$i]['amount'];?></td>
                                  <td><?=$challan_details[$i]['stream_short_name'];?></td>
                                  <td><?=$challan_details[$i]['current_year'];?></td>
                                  
                                
                            
                                
                               
                                
                                
                                
                                <td><?=$challan_details[$i]['su_bank_name']?></td> 


                                <td><?php if($challan_details[$i]['challan_status']=='VR')echo '<span style="color:Green" >Deposited</span>';
                                            else if($challan_details[$i]['challan_status']=='CL')echo '<span style="color:red" >Cancelled</span>';else echo '<span style="color:#1d89cf" >Pending</span>';?>
                                                
                                            </td>
                                
                            </tr>
                                <?php
                                $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>

        


                    <script>
$(document).ready(function() {
    $('#search-table').DataTable( {
        dom: 'Bfrtip',
        targets: 'no-sort',
bSort: false,
     bPaginate: false,
        buttons: [
            
            {
                extend: 'excelHtml5',
                title: 'Receipt List'
            },
            {
                extend: 'pdfHtml5',
                title: 'Challan List'
            }
        ]
    } );

       
} );
</script>