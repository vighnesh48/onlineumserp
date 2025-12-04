<style type="text/css">
    .stu-fe-list{width:100%;padding:5px;}
    
</style>

<?php  $sid=array();
foreach($depositelist as $list){
	
	$sid[$list['student_id']]=($list['caution_dposite']);
}

//print_r($sid);
?>

<!--<form method="post" action="<?=base_url()?>Ums_admission/applyexem/">-->
              <?php if($count_rows==0){
                  
                echo' <div class="col-sm-4"> </div><label class="col-sm-4"><span style="color:red">Records are not found.*</sapn></label>';
              }
              else {
                //  echo ;
              ?>        
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   <th><input type="checkbox"  id="ckbCheckAll"></th>
                                    <th >S.No.</th>
                                    <th>PRN</th>
                                    <th>Name</th>
                                 <!--   <th>Mobile</th>-->
                                    <th>caution Fees Deposite</th>
                                     <th>Current pay</th>
                                      <!--<th>Scholarship&nbsp;Type</th>-->
                                   <!-- <th>Excempted Fees</th>-->
                                    <!--<th>Applicable Fees</th>-->
                                    <th>Remark</th>
                                   <!-- <th width="80">Pay Fees</th>-->
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
                            <tr <?=$bg?> <?=$emp_list[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <th><input type="checkbox" value="<?=$emp_list[$i]['stud_id']?>" name="lstd[]" class="checkBoxClass" id="check_<?=$emp_list[$i]['stud_id']?>"></td>
                               <td><?=$j?></td>
                        
                                 <td ><input type="hidden" value="<?=$emp_list[$i]['enrollment_no']?>" name="enrollment_no[<?=$emp_list[$i]['stud_id']?>]"><?=$emp_list[$i]['enrollment_no']?></td> 
                                 

							<td>
							<?php
								echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
								?>
								</td> 
							                      
                                                      
                               <!-- <td><?php // $emp_list[$i]['mobile'];?></td>-->    

                              <?php // if(array_key_exists($emp_list[$i]['stud_id'],$sid)){ /*echo 'Y'.$sid[$emp_list[$i]['stud_id']];*/}else{/*echo 'N';*/}?>
                         <td>
                         <?php if(array_key_exists($emp_list[$i]['stud_id'],$sid)){ //echo 'Y'.$sid[$emp_list[$i]['stud_id']]; ?>
                         <input type="text" value="<?php echo $sid[$emp_list[$i]['stud_id']]; ?>" name="actual[<?=$emp_list[$i]['stud_id']?>]" id="actual_<?=$emp_list[$i]['stud_id']?>" class="stu-fe-list txtnum">   
						 <?php }else{?>
                         <input type="text" value="1000" name="actual[<?=$emp_list[$i]['stud_id']?>]" id="actual_<?=$emp_list[$i]['stud_id']?>" class="stu-fe-list txtnum"><?php } ?>    </td>
                         
                         
                           <td><input type="text" value="0" name="current_pay[<?=$emp_list[$i]['stud_id']?>]" id="current_pay_<?=$emp_list[$i]['stud_id']?>"  class="stu-fe-list txtnum">      </td>         
      <td><textarea name="remark[]" id="<?=$emp_list[$i]['stud_id']?>_remark"><?php //echo $emp_list[$i]['concession_remark']; ?></textarea></td>
                                    
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>  
                 
                     <input type="hidden" value="<?=$acdyear?>" name="fayear">

                 <input type="hidden" name="academicyear" value="<?=$acdyear;?>">
                 <input type="hidden" name="acourse" value="<?=$acourse;?>">
                 <input type="hidden" name="astream" value="<?=$astream;?>">
                 <input type="hidden" name="ayear" value="<?=$ayear;?>">
                     
                     <!-- <input type="submit" value="Apply Fees" class="btn btn-primary btn-labeled">-->
                     <center>
                                     <?php
                                    // if($this->session->userdata('name')=="admission"){
                                     //    echo '<input type="submit" value="Update Fee" class="btn btn-primary btn-labeled" id="feesrow">     </center>';
                                    }
                                     ?>
                                   
                     <!--<input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">-->

                    <!-- </form>-->
                    <!--<form method="post" action="<?=base_url()?>Ums_admission/generatepdf/">

                     </form>-->
                     
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
	
	
	$(function(){
      $('.checkBoxClass').click(function(){
		  var Item_Amount=$("#Item_Amount").val();
        var val = [];
		if(!$(this).is(':checked')){
    //  alert('uncheckd ' + $(this).val());
	var dele=$(this).val();
	  $("#current_pay_"+dele).val(0);
	  }
        $(':checkbox:checked').each(function(i){
			var id=$(this).val();
			//var actual=$("#_actual").val();
			//var current_pay=$("#3168_current_pay").val();
			  //  var ischecked= $(this).is(':checked');

          val[i] = $(this).val();
		  
        });
		
		var counts=(val.length);
		var new_amount=Item_Amount/counts;
		new_amount=new_amount.toFixed(2)
		$.each(val, function(index, value) {
			var id=value;
			var actual=$("#actual_"+id).val();
			//$("#actual_"+id).val(actu);
			var actu=actual - new_amount;
			 console.log(new_amount+'--'+actual);
			//if(new_amount>actual){
			//	alert('Amount not avalible to pay');
			//	$( "#check_"+id).prop( "checked", false );
				//check_
			//}else{
			//$("#actual_"+id).val(actu);
			$("#current_pay_"+id).val(new_amount);
			
			//}
  //console.log(value);
  // Will stop running after "three"
  //return (value !== 'three');
});
      });
    });
    
    $("#feesrow").click(function(){
        var count = $("[type='checkbox']:checked").length;
       
        if(count==0){
            alert("Please select the students for update the fees.");
            return false;
        }
    });
    
      $('#itemContainer').on('keydown', '.txtnum', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});

});
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
$("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
  filename: "Student List" //do not include extension

  });

});

                     </script>
                     
                     
	    