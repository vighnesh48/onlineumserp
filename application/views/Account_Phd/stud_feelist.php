<style type="text/css">
    .stu-fe-list{width:100%;padding:5px;}
    
</style>

<form method="post" action="<?=base_url()?>Ums_admission/applyexem/">
              <?php //if($count_rows==0){
                  
              //  echo' <div class="col-sm-4"> </div><label class="col-sm-4"><span style="color:red">Records are not found.*</sapn></label>';
             // }
            //  else {
              ?>        
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                 
                                    <th >S.No.</th>
                                    <th>PRN</th>
                                    <th>Name</th>
                                  
                                    <th>Examination Fees</th>
                                    <th>Late Fees</th>
                             
 <th width="80">Pay Fees</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            
                        // var_dump($emp_list);
                            $j=1;                            
                            for($i=0;$i<count($emp_list);$i++)
                            {
                                
                            ?>
							 <?php if($emp_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$emp_list[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                               <!-- <th><input type="checkbox" value="<?=$emp_list[$i]['stud_id']?>" name="lstd[]" class="checkBoxClass"></td>-->
                               <td><?=$j?></td>
                        
                                 <td ><?=$emp_list[$i]['enrollment_no']?></td> 
                                 

							<td>
							<?php
								echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
								?>
								</td> 
							                      
                                                      
                            
                                      <td><?=$emp_list[$i]['famount']?>     </td>
                                       <td><?=$emp_list[$i]['famfine']?>     </td>

                                    <td>  <a href="<?=base_url()?>account/viewPayments/<?=$emp_list[$i]['stud_id']?>" target="_blank">Pay Now</a>    </td>  
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>  
                 
                       <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">
                     
                     <!-- <input type="submit" value="Apply Fees" class="btn btn-primary btn-labeled">-->
                     <center>
                                     <?php
                                    // if($this->session->userdata('name')=="admission"){
                                       //  echo '<input type="submit" value="Update Fee" class="btn btn-primary btn-labeled" id="feesrow">     </center>';
                                   // }
                                     ?>
                                   
                                         <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">

                     </form>
                    <form method="post" action="<?=base_url()?>Ums_admission/generatepdf/">

                     </form>
                     
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
    
    $("#feesrow").click(function(){
        var count = $("[type='checkbox']:checked").length;
       
        if(count==0){
            alert("Please select the students for update the fees.");
            return false;
        }
    });
    
      $('#itemContainer').on('keydown', '#txtnum', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});

});
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
$("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
  filename: "Student List" //do not include extension

  });

});

                     </script>
                     
                     
	    