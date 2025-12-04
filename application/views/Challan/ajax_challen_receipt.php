 <div class="table-info">    
<table  id="search-table" class="table table-bordered table-list-search">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Receipt No</th>                                    
                                    <th>Student&nbsp;Name</th>
                                     <th>Enrollment&nbsp;No</th>
                                      <th>prov&nbsp;no</th>
                                     <th>Amount</th>  
                                  <th>Course Name</th>
                                  <th>Year</th>
                                  <th>Paid By</th>
                                  <th>Trans Date</th>
                                   <th>Cheque No</th>
                                   <th>Student Bank </th>
                                   <th>Transaction No</th>
                                   <th>Created Date</th>
                                        
                                    <th>Bank</th>  
                                    <th>Status</th>                               
                                                                        
                            </tr>
                            
                        </thead>
                        <tbody id="itemContainer">
<?php $i=1;
foreach ($rec_list as $key => $value) { 
$totamt['tamt'][]=$value['amount'];
  ?>
  <tr>
    <td><?=$i?></td>
    <td><?=$value['exam_session']?></td>
<td><?=$value['student_name']?></td>
<td><?=$value['enrollment_no']?></td>
<td><?=$value['prov_reg_no']?></td>
<td><?=$value['amount']?></td>
<td><?=$value['cousre_name']?></td>
<td><?=$value['curr_year']?></td>
<td><?=$value['fees_paid_type']?></td>
<td><?=date('d-m-Y',strtotime($value['fees_date']))?></td>
<td><?=$value['receipt_no']?></td>
<td><?=$value['student_bank']?></td>
<td><?=$value['TransactionNo']?></td>
<td><?php  echo date('d-m-Y',strtotime($value['created_on'])); ?></td>

  
<td><?=$value['su_bank_name']?></td>
<td><?php if($value['challan_status']=='VR')echo '<span style="color:Green" >Deposited</span>';
                                            else if($value['challan_status']=='CL')echo '<span style="color:red" >Cancelled</span>';else echo '<span style="color:#1d89cf" >Pending</span>';?></td>
  </tr>
<?php $i++; }
?>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td><td>&nbsp;</td>
<td>&nbsp;</td>
<td><b>Total Amount</b></td>
<td><b><?=array_sum($totamt['tamt'])?></b></td>
</tr>
</tbody>
</table>
</div>
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
                title: 'Receipt List'
            }
        ]
    } );

       
} );
</script>