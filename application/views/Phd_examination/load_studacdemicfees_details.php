   <?php
  // var_dump($_SESSION);
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
                               <td style='color:red'><b>Your Academic fee is pending. Kindly contact to Registrar office.</b></td>  
                            </tr>
						<?php } ?>							
                        </tbody>
                    </table>  
