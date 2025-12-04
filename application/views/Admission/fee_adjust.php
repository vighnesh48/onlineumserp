<style type="text/css">
    .stu-fe-list{width:100%;padding:5px;}
    
</style>
<script>
   function disablecheckbok(chkid) {
	   //alert(chkid);
			var cls=chkid+'_enable';
			//alert(cls);
            if ($("#"+chkid).is(":checked")) {
				//alert('inside'); 
                $("."+cls).removeAttr("disabled");
                
            } 
    }
</script>
<form method="post" action="<?=base_url()?>Ums_admission/applyexem/">
              <?php
$name_id=$this->session->userdata('name');
	if($name_id=='6031' || $name_id=='PRAMODTHASAL'){
		$readonly="";
	}else{
		$readonly="readonly";
	}		  
			  if($count_rows==0){
                  
                echo' <div class="col-sm-4"> </div><label class="col-sm-4"><span style="color:red">Records are not found.*</sapn></label>';
              }
              else {
                //  echo ;
              ?>     
<input type="hidden" name="fayear" value="<?=$acdyear?>">

                 <input type="hidden" name="academicyear" value="<?=$acdyear;?>">
                 <input type="hidden" name="acourse" value="<?=$acourse;?>">
                 <input type="hidden" name="astream" value="<?=$astream;?>">
                 <input type="hidden" name="ayear" value="<?=$ayear;?>">			  
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   <th><input type="checkbox"  id="ckbCheckAll"></th>
                                    <th >S.No.</th>
									<th>Is Package</th>
                                    <th>PRN</th>
                                    <th>Name</th>
                                 <!--   <th>Mobile</th>-->
                                    <th>Actual Fees</th>
                                    <th>Scholarship&nbsp;Type</th>
                                    <th>Duration</th>
                                    <th>Excempted Fees</th>
                                    
                                    <th>Applicable Fees</th>
									<th>Hostel</th>
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
								  else $bg="";
								  if($emp_list[$i]['belongs_to']=='Package'){ $bg1="bgcolor='#edcfcf'";}else{ $bg1="";};
								  ?>								
                            <tr <?=$bg?> <?=$bg1?> <?=$emp_list[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <th><input type="checkbox" value="<?=$emp_list[$i]['stud_id']?>" name="lstd[]" id="<?=$emp_list[$i]['stud_id']?>" class="checkBoxClass" onclick="disablecheckbok(this.id)"></td>
                               <td><?=$j?></td>
								<td ><?=$emp_list[$i]['belongs_to']?></td> 	
                                 <td ><?=$emp_list[$i]['enrollment_no']?></td> 
                                 

							<td>
							<?php
								echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
								?>
								</td> 
							                      
                                                      
                               <!-- <td><?php // $emp_list[$i]['mobile'];?></td>-->    

                         <td><input type="text" value="<?=$emp_list[$i]['actual_fee'];?>" name="<?=$emp_list[$i]['stud_id']?>_actual" id="txtnum" class="stu-fe-list <?=$emp_list[$i]['stud_id']?>_enable" <?=$readonly111?> disabled>      </td>
                                    <td><select name="<?=$emp_list[$i]['stud_id']?>_scholarship" id="Scholarship <?=$emp_list[$i]['stud_id']?>_enable" class="stu-fe-list <?=$emp_list[$i]['stud_id']?>_enable" disabled>
                                    <option value="">SELECT</option>
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
                                    </select></td>
                                    <td><select name="<?=$emp_list[$i]['stud_id']?>_duration" id="duration" class="stu-fe-list <?=$emp_list[$i]['stud_id']?>_enable" disabled>
                                    <option value="">Select Duration</option>
                                    <option value="1" <?php if($emp_list[$i]['fduration']=="1"){?> selected="selected"<?php }?> >1</option>
                                    <option value="0" <?php if($emp_list[$i]['fduration']=="0"){?> selected="selected"<?php }?> >All</option>
                                    
                                    </select><input type="hidden" name="<?=$emp_list[$i]['stud_id']?>_fid" id="<?=$emp_list[$i]['stud_id']?>_fid" value="<?=$emp_list[$i]['fid'];?>"></td>
                             <td>  <input type="text" value="<?php echo (int)$emp_list[$i]['actual_fee'] - (int)$emp_list[$i]['applicable_fee'] ;?>" name="<?=$emp_list[$i]['stud_id']?>_exem" id="txtnum" class="stu-fe-list <?=$emp_list[$i]['stud_id']?>_enable" disabled>      </td>

                                      <td>  <input type="text" value="<?=$emp_list[$i]['applicable_fee'];?>" name="<?=$emp_list[$i]['stud_id']?>_appli" <?=$readonly111?> class="stu-fe-list <?=$emp_list[$i]['stud_id']?>_enable" disabled>      </td>
									  <td><?php if(isset($emp_list[$i]['prn'])){?> <a href="<?=base_url()?>Hostel/student_facility_details/<?=$emp_list[$i]['enrollment_no']?>/<?=$emp_list[$i]['f_alloc_id']?>/SU/<?=$emp_list[$i]['academic_year']?>" target="_blank">View</a><?php }else{ echo '-';}?></td>
                                   
      <td><textarea name="<?=$emp_list[$i]['stud_id']?>_remark" id="remark" class="<?=$emp_list[$i]['stud_id']?>_enable" disabled><?php echo $emp_list[$i]['concession_remark']; ?></textarea></td>
                                    <!--<td>  <a href="<?=base_url()?>ums_admission/viewPayments/<? // $emp_list[$i]['stud_id']?>/<?=$academicyear?>" target="_blank">Pay Now</a></td>  -->
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>  
                 
                     
                     
                     <!-- <input type="submit" value="Apply Fees" class="btn btn-primary btn-labeled">-->
                     <center>
                                     <?php
                                     if($this->session->userdata('name')=="662659" || $this->session->userdata('name')=="6031" || $this->session->userdata('name')=="sunerp"){
                                         echo '<input type="submit" value="Update Fee" class="btn btn-primary btn-labeled" id="feesrow">     </center>';
									 }
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


</script>
                     
                     
	    