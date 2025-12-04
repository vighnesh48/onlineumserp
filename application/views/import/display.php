<style>
table, th, td {
  border: 1px solid black;
}
</style>
<div class="table-responsive">
    <table class="table table-hover tablesorter">
        <thead>
            <tr>
                <th class="header">enrollment_no</th>
                <th class="header">Studnet_ID</th>                           
                <th class="header">Studnet_name</th>                           
                <th class="header">stream_name</th>                      
                <th class="header">academic_year</th>
                <th class="header">year</th>
                <th class="header">university_bank</th>
                <th class="header">University_bank_city</th>
                <th class="header">fees_paid_type</th>
                <th class="header">trans_no</th>
                <th class="header">trans_date</th>
                <th class="header">amount</th>
                <th class="header">fees_payment_date</th>
                <th class="header">manual_receipt_no</th>
                <th class="header">Student_bank_branch</th>
                <th class="header">max_no_installment</th>
                <th class="header">min_balance</th>
                <th class="header">tot_fee_paid</th>
                <th class="header">Remark</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($stud_fees_data) && !empty($stud_fees_data)) {
                foreach ($stud_fees_data as $key => $SheetDataKey) {
                    ?>
                    <tr>
                       
						
						<td><?php echo $SheetDataKey['enrollment_no']; ?></td>  
						<td><?php echo $SheetDataKey['student_id']; ?></td>  
					     <td><?php echo  $SheetDataKey['Studnet_name']; ?></td>  
                   <td><?php echo $SheetDataKey['stream_name']; ?></td>  
                  <td><?php echo   $SheetDataKey['academic_year']; ?></td>  
                  <td><?php echo  $SheetDataKey['year']; ?></td>  
                  <td><?php echo   $SheetDataKey['university_bank']; ?></td>  
                  <td><?php echo   $SheetDataKey['University_bank_city']; ?></td>  
                  <td><?php echo   $SheetDataKey['fees_paid_type']; ?></td>  
                   <td><?php echo  $SheetDataKey['trans_no']; ?></td>  
                   <td><?php echo  $SheetDataKey['trans_date']; ?></td>  
                  <td><?php echo  $SheetDataKey['amount']; ?></td>  
                  <td><?php echo  $SheetDataKey['fees_payment_date']; ?></td>  
                  <td><?php echo   $SheetDataKey['manual_receipt_no']; ?></td>  
                  <td><?php echo  $SheetDataKey['Student_bank_branch']; ?></td>  
                  <td><?php echo  $SheetDataKey['noofinst']; ?></td>  
                  <td><?php echo  $SheetDataKey['minbalance']; ?></td>  
                  <td><?php echo  $SheetDataKey['totfeepaid']; ?></td>  
                  <td><?php echo  $SheetDataKey['Remark']; ?></td>  
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="5">There is no Fees Entries.</td>    
                </tr>
            <?php } ?>
 
        </tbody>
    </table>
</div>