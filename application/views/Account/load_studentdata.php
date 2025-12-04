   <?php
if(count($emp_list)>0)
{
   ?>
    <form method="post" action="<?=base_url()?>Ums_admission/generateID/">
 
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   <th class="noExl"><input type="checkbox"  id="ckbCheckAll"></th>
                                    <th>S.No.</th>
                                    <th>PRN</th>
                                     <th>Old PRN</th>
                                     
                                     
                                    <th>Name</th>
                                    <th>Stream </th>
                                    
                                    <th>Mobile</th>
                                    <th>Year</th>
                                    <?php
                                    if( $_SESSION['role_id']=='5')
                                    {
                                    ?>
                                    <th class="noExl">Payment</th>
                                    <?php
                                    }
                                    ?>
                                    <th class="noExl">Pay Fees</th>
                                    <th class="noExl">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            
                          
                            $j=1;                            
                            for($i=0;$i<count($emp_list);$i++)
                            {
                                
                            ?>
							 <?php if($emp_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$emp_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
                                <th class="noExl"><input type="checkbox" value="<?=$emp_list[$i]['stud_id']?>" name="lstd[]" class="checkBoxClass"></td>
                               <td><?=$j?></td>
                        
                                 <td>'<?=$emp_list[$i]['enrollment_no']?></td> 
                                  <td><?=$emp_list[$i]['enrollment_no_new']?></td> 
                                  
							 <td>
							<?php
								echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
								?>
								</td> 
							
								   <td><?=$emp_list[$i]['stream_name']?></td> 
                                                                                              
                                                      
                                                      
                                <td><?=$emp_list[$i]['mobile'];?></td>  
                                <td><?=$emp_list[$i]['current_year'];?></td>  
                                <td class="noExl"><a  href="<?php echo base_url()."account/viewPayments/".$emp_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-credit-card" aria-hidden="true"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td>                         
                              
                               
                                                       
                                <td class="noExl" style="padding:0px;" align="center">
                                    <p> 
			<a  href="<?php echo base_url()."ums_admission/view_studentFormDetails/".$emp_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-eye"></i>&nbsp;  </a>
	       
	        <?php
                                    if($_SESSION['role_id']=='1' || $_SESSION['role_id']=='2')
                                    {
                                        if($_SESSION['name']=='110051')
                                        {
                                    ?>      
	        <a  href="<?php echo base_url()."ums_admission/edit_personalDetails/".$emp_list[$i]['stud_id'].""?>" title="Edit"><i class="fa fa-edit"></i> &nbsp; </a>
       
                                
                       
                       
                          <?php
                                    }
                                    }
                          ?>
                             </td>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>  
                   
                       <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">
                     <?php
              
                      if($hide =='hide')
                     {
                     }
                     else
                     {
                     ?>
                     <input type="submit" value="Generate ID Card" class="btn btn-primary btn-labeled">
                     <?php
                     }
                     ?>
               
                     
                     
                     </form>
                      <?php
                     if($hide =='hide')
                     {
                     }
                     else
                     {
                     ?>
                    <form method="post" action="<?=base_url()?>Ums_admission/generatepdf/" style="float: left;margin-top: -29px;margin-left: 150px;">
                    <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">
                     <input type="submit" value="Generate PDF" class="btn btn-primary btn-labeled">
                     
                      <input type="button" id="expdata" value="Export as Excel" class="btn btn-primary btn-labeled">
                     </form>
                     
                     <?php
                     }

                     ?>
                     <?php
}
else
{echo "No Results Found";}
                     ?>
                     
                     
                     
                     <script>
                     
                     
                     
                     
$(document).ready(function () {
    $("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });
    
    $(".checkBoxClass").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll").prop("checked",false);
        }
    });
});
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
$("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
  filename: "Student List" //do not include extension

  });

});

                     </script>
                     
                     
	    