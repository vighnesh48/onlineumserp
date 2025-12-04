<style type="text/css">
    .stu-fe-list{width:100%;padding:5px;}
    
</style>

<form method="post" action="<?=base_url()?>Account/applyexem/">
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
                                    <th >Sr.No.</th>
                                    <th>PRN</th>
                                    <th>Name</th>
                                 <!--   <th>Mobile</th>-->
								  
                                    <th>Actual Fees</th>
									  <th>Tuition Fees</th>
                                    <th>Scholarship&nbsp;Type</th>
                                    <th>Duration</th>
                                    <th>Excempted Fees</th>
                                    <th>Applicable Fees</th>
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
                                <th><input type="checkbox" value="<?=$emp_list[$i]['stud_id']?>" name="lstd[]" class="checkBoxClass"></td>
                               <td><?=$j?></td>
                        
                                 <td ><?=$emp_list[$i]['enrollment_no']?></td> 
                                 

							<td>
							<?php
								echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
								?>
								</td> 
							                      
                                                      
                               <!-- <td><?php // $emp_list[$i]['mobile'];?></td>-->    


                         <td><input type="text" value="<?=$emp_list[$i]['actual_fee'];?>" name="<?=$emp_list[$i]['stud_id']?>_actual" id="actual_fees" class="stu-fe-list" readonly="readonly">      </td>
						  <td><input type="text" value="<?=$emp_list[$i]['tution_fees'];?>" name="<?=$emp_list[$i]['stud_id']?>_tution" id="<?=$emp_list[$i]['stud_id']?>_tution" class="stu-fe-list" readonly="readonly">      </td>
                                    <td>
									<select name="<?=$emp_list[$i]['stud_id']?>_scholarship" id="Scholarship" onChange="get_discount_value(this.value,<?=$emp_list[$i]['stud_id']?>)" class="stu-fe-list">
									<option value="">SELECT</option>

									
					  <option value="" style="background-color: #CCC; padding:3px;" disabled >Other</option>
					 <?php foreach($Scholarship_typee as $Other) { 
                        if(($Other['type']=="Other_Scholarship")&&($Other['state_wise']=="ALL")&&($Other['year']==0))
                        { ?>
                      <option value="<?php echo $Other['type'];?>-<?php echo $Other['s_id'];?>" data-foo="<?php echo $Other['consession_allowed'];?>"
                      <?php if($emp_list[$i]['concession_id']==$Other['s_id']){ echo "selected"; } ?>


					  ><?php echo $Other['schlorship_name'];?>&nbsp;(<?php echo $Other['Criteria'];?>)&nbsp;(<?php echo $Other['consession_allowed'];?>)%</option>
									 <?php } }?>
									  <option value="" style="background-color: #CCC; padding:3px;" disabled >Sports</option>
									 <?php foreach($Scholarship_typee as $Sports) { 
                        if(($Sports['type']=="Sports_Scholarship")&&($Sports['state_wise']=="ALL")&&($Sports['year']==1)){
                        ?>
						  <option value="<?php echo $Sports['type'];?>-<?php echo $Sports['s_id'];?>"  data-foo="<?php echo $Sports['consession_allowed'];?>"
 <?php if($emp_list[$i]['concession_id']==$Sports['s_id']){ echo "selected"; } ?>

						  ><?php echo $Sports['schlorship_name'];?>&nbsp;(<?php echo $Sports['Criteria'];?>)&nbsp;(<?php echo $Sports['consession_allowed'];?>)%</option>
						  <?php }} ?> 
						   <option value="" style="background-color: #CCC; padding:3px;" disabled >Merit(Maharashtra)</option>
						    <?php foreach($Scholarship_typee as $typee) { 
                        if(($typee['type']=="Merit_Scholarship")&&($typee['state_wise']=="MH")&&($typee['year']==1))
                        {
                        ?>
						 <option value="<?php echo $typee['type'];?>-<?php echo $typee['s_id'];?>" data-foo="<?php echo $typee['consession_allowed'];?>" 
 <?php if($emp_list[$i]['concession_id']==$typee['s_id']){ echo "selected"; } ?>


						 ><?php echo $typee['schlorship_name'];?>&nbsp;(<?php echo $typee['Criteria'];?>)&nbsp;(<?php echo $typee['consession_allowed'];?>)%</option>
						    <?php }} ?>       
 <option value="" style="background-color: #CCC; padding:3px;" disabled >Merit(Other than Maharashtra)</option>
<?php foreach($Scholarship_typee as $typee) { 
                        if(($typee['type']=="Merit_Scholarship")&&($typee['state_wise']=="OMH")&&($typee['year']==1))
                        {
                        ?>		
 <option value="<?php echo $typee['type'];?>-<?php echo $typee['s_id'];?>" <?php if($emp_list[$i]['concession_id']==$typee['s_id']){ echo "selected"; } ?>  data-foo="<?php echo $typee['consession_allowed'];?>"><?php echo $typee['schlorship_name'];?>&nbsp;(<?php echo $typee['Criteria'];?>)&nbsp;(<?php echo $typee['consession_allowed'];?>)%</option>	
  <?php }} ?>     
					 </select>
					
									<!--
                                     <?php echo str_replace('_',' ',$type['type']);?>&nbsp;<input type="checkbox" class="Scholarship_type" value="<?php echo $type['type'];?>" id="<?php echo $type['type'];?>" name="Scholarship_type[]" />
                                    <option value="" style="background-color: #CCC; padding:3px;" disabled>&nbsp;CAST&nbsp;</option>
                                    
                                    <option value="OBC" <?php if($emp_list[$i]['concession_type']=="OBC"){?> selected="selected"<?php }?>>&nbsp;OBC&nbsp;</option>
                                    <option value="SC/ST/NT" <?php if($emp_list[$i]['concession_type']=="SC/ST/NT"){?> selected="selected"<?php }?>>&nbsp;SC/ST/NT&nbsp;</option>
                                    <option value="EBC" <?php if($emp_list[$i]['concession_type']=="EBC"){?> selected="selected"<?php }?>>&nbsp;EBC&nbsp;</option>
                                    <option value="EARLY BIRD" <?php if($emp_list[$i]['concession_type']=="EARLY BIRD"){?> selected="selected"<?php }?>>&nbsp;EARLY BIRD&nbsp;</option>
                                    <option value="EARLY BIRD + CAST" <?php if($emp_list[$i]['concession_type']=="EARLY BIRD + CAST"){?> selected="selected"<?php }?>>&nbsp;EARLY BIRD&nbsp;+&nbsp;Cast</option>
                                    <option value="" style="background-color:#CCC; padding:3px;" disabled>&nbsp;MERIT&nbsp;</option>
                                    <option value="Above_85" <?php if($emp_list[$i]['concession_type']=="Above_85"){?> selected="selected"<?php }?>>&nbsp;Above 85%&nbsp;</option>
                                    <option value="80_84" <?php if($emp_list[$i]['concession_type']=="80_84"){?> selected="selected"<?php }?>>&nbsp;80 To 84.99%&nbsp;</option>
                                    <option value="75_79" <?php if($emp_list[$i]['concession_type']=="75_79"){?> selected="selected"<?php }?>>&nbsp;75 To 79.99%&nbsp;</option>
                                    <option value="" style="background-color:#CCC; padding:3px;" disabled>&nbsp;OTHER&nbsp;</option>
                                    <option value="Special Scholarship" <?php if($emp_list[$i]['concession_type']=="Special Scholarship"){?> selected="selected"<?php }?>>&nbsp;Special Scholarship&nbsp;</option>
                                     <option value="Sp10" <?php if($emp_list[$i]['concession_type']=="Sp10"){?> selected="selected"<?php }?>>&nbsp;10%&nbsp;</option>
                                     <option value="Sp20" <?php if($emp_list[$i]['concession_type']=="Sp20"){?> selected="selected"<?php }?>>&nbsp;20%&nbsp;</option>
                                     <option value="Sp25" <?php if($emp_list[$i]['concession_type']=="Sp25"){?> selected="selected"<?php }?>>&nbsp;25%&nbsp;</option>
                                     <option value="Sp50" <?php if($emp_list[$i]['concession_type']=="Sp50"){?> selected="selected"<?php }?>>&nbsp;50%&nbsp;</option>
                                     <option value="Sp100" <?php if($emp_list[$i]['concession_type']=="Sp100"){?> selected="selected"<?php }?>>&nbsp;100%&nbsp;</option>
                                     <option value="Lump_Sum" <?php if($emp_list[$i]['concession_type']=="Lump_Sum"){?> selected="selected"<?php }?>>&nbsp;Lump-Sum&nbsp;</option>
                                     <option value="Lump_Sum" <?php if($emp_list[$i]['concession_type']=="Other_Scholarship"){?> selected="selected"<?php }?>>&nbsp;Other Scholarship&nbsp;</option>
                                    <option value=""></option>
                                    </select>
									-->
									
									
									</td>
                                    <td><select name="<?=$emp_list[$i]['stud_id']?>_duration" id="duration" class="stu-fe-list">
                                    <option value="">Select Duration</option>
                                    <option value="1" <?php if($emp_list[$i]['fduration']=="1"){?> selected="selected"<?php }?> >1</option>
                                    <option value="0" <?php if($emp_list[$i]['fduration']=="0"){?> selected="selected"<?php }?> >All</option>
                                    
                                    </select><input type="hidden" name="<?=$emp_list[$i]['stud_id']?>_fid" id="<?=$emp_list[$i]['stud_id']?>_fid" value="<?=$emp_list[$i]['fid'];?>"></td>
                             <td>  <input type="text" value="<?php echo (int)$emp_list[$i]['actual_fee'] - (int)$emp_list[$i]['applicable_fee'] ;?>" name="<?=$emp_list[$i]['stud_id']?>_exem" id="expfee" readonly class="stu-fe-list">      </td>

                                      <td>  <input type="text" value="<?=$emp_list[$i]['applicable_fee'];?>" name="<?=$emp_list[$i]['stud_id']?>_appli" readonly class="stu-fe-list" id="applicable_fee" readonly>      </td>
                                   
      <td><textarea name="<?=$emp_list[$i]['stud_id']?>_remark" id="remark"><?php echo $emp_list[$i]['concession_remark']; ?></textarea></td>
                                    <!--<td>  <a href="<?=base_url()?>ums_admission/viewPayments/<? // $emp_list[$i]['stud_id']?>/<?=$academicyear?>" target="_blank">Pay Now</a></td>  -->
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
                                         echo '<input type="submit" value="Update Fee" class="btn btn-primary btn-labeled" id="feesrow">     </center>';
                                    }
                                     ?>
                                   
                     <!--<input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">-->

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

function get_discount_value(val,id){
	 /*var selected = $("#"+id+"_scholarship").find('option:selected');
	 console.log(selected);
	 var extra = selected.data('foo'); 
	 alert(extra);*/
	 //alert(id+"_scholarship");
	
		var sel = document.getElementById("Scholarship");
	
		var selected = sel.options[sel.selectedIndex];
		var extra = selected.getAttribute('data-foo');
		//alert(extra);
	var tutuion_fees=$("#"+id+"_tution").val();
	var discount=0;
    discount=parseInt((tutuion_fees * extra / 100));
	$("#expfee").val(discount);
	var actual_fees=$("#actual_fees").val();
	$("#applicable_fee").val(parseInt(actual_fees-discount));
	//10074_appli
	//alert("dfdd");
	//alert(val);
}

                     </script>
                     
                     
	    