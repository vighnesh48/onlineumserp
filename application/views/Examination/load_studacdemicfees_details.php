   <?php
   //var_dump($_SESSION);exit;
   ?>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <table class="table table-bordered" id="table2excel">
                        <tbody id="itemContainer">
						<?php 
						//print_r($res_status);
						if(!empty($res_status)){?>
                            <tr>    
                               <td style='color:red'><b>Your Result is with held. Kindly contact to COE office.</b></td>  
                            </tr>
						<?php }else{?> 
								<tr>    
                               <td style='color:red'><b>Your Academic fee is pending. Kindly contact to HOD/DEAN/Account office. <a href="<?=base_url()?>online_fee/pay_fees">or Click here to pay from your login</a></b></td>  
                            </tr>
						<?php } ?>							
                        </tbody>
                    </table> 
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  padding: 9px;
}
</style>			<b>Note: </b>		
					<table cellpadding="5px" cellspacing="3px">
  <tr>
    <th>Sr.No</th>
    <th>Particulars</th>
    <th colspan="2">Fees Paid Status</th>    
  </tr>
  <tr>
    <td>1</td>
    <td>New Admission FY Students</td>    
    <td>100% Academic Fees to be paid</td>  
  </tr>  
  <tr>
    <td>2</td>
    <td>New Admission DSY Students</td>    
    <td>70% Academic Fees to be paid</td>  
  </tr>
  <tr>
    <td>3</td>
    <td>Regular Students</td>    
    <td>70% Academic Fees to be paid</td>  
  </tr>
</table>

