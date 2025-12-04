<?php $astrik="*";?>
<script type="text/javascript">
function computer_statuss(m){
	if(m.value=="Y"){
		$("#Amount").prop('readonly', false);
		$("#Amount").prop('required', true);
	}else{
		$("#Amount").prop('readonly', true);
		$("#Amount").prop('required', false);
	}
}

function hostel_statuss(m){
	if(m.value=="Y"){
		$("#hostel_type").prop('disabled', false);
		$("#hostel_type").prop('required', true);
	}else{
		$("#hostel_type").prop('disabled', true);
		$("#hostel_type").prop('required', false);
	}
}
</script>
<?php if($edit_data[0]['computer_status']=='Y'){?>

<script type="text/javascript">$(document).ready(function() {
//alert();
	$("#Amount").prop('readonly', false);
	$("#Amount").prop('required', true);
});
</script>
<?php } ?>
<?php if($edit_data[0]['hostel_status']=='Y'){?>
<script type="text/javascript">
$(document).ready(function() {
	//alert();
$("#hostel_type").prop('disabled', false);
$("#hostel_type").prop('required', true);
});
</script>
<?php } ?>
<div class="col-sm-12">
            <div id="dashboard-recent" class="panel panel-warning">
               <div class="tab-content">
                  <span style="color:red; padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                  <div id="personal-details" class="widget-comments panel-body tab-pane fade active in">
                     <div class="panel">
                     <?php if(!empty($edit_data[0]['bcd_id'])){?>
                        <form id="Bonafide_update"   name="Bonafide_update" action="<?php echo base_url();?>Bonafide/update_data" method="post"  enctype="multipart/form-data" >
                        <input type="hidden" id="bcd_id" name="bcd_id" class="form-control" value="<?php echo $edit_data[0]['bcd_id'];?>"/>
                        <?php }else{ ?>
                         <form id="Bonafide_update"   name="Bonafide_update" action="<?php echo base_url();?>Bonafide/insert_data" method="post"  enctype="multipart/form-data" >
                        <?php } ?>
                          
                           <fieldset class="scheduler-border">
                              <legend class="scheduler-border">Add Bonafide</legend>
                              <div class="form-group enquiry_no">
                                 <label class="col-sm-1">DATE <?=$astrik?></label>
                            <div class="col-sm-3"><input type="text" id="Bonafide_date" name="date" value="<?php if(!empty($edit_data[0]['date_in'])){ echo $edit_data[0]['date_in'];}else{echo date('Y-m-d');}?>" class="form-control Bonafide_date" value="" required="required"/></div>
                             </div>
                              <div class="form-group">
                               <label class="col-sm-1">Reference&nbsp;Name<?=$astrik?></label>
                                 <div class="col-sm-3"><input type="text" id="Reference_name" name="Reference_name" value="<?php if($edit_data[0]['Reference_name']!=""){ echo $edit_data[0]['Reference_name'];}?>" class="form-control" placeholder="Reference name" /></div>
                             <label class="col-sm-1">Consultant<?=$astrik?></label>
                                 <div class="col-sm-3">
                                 <select name="consultant" id="Consultant" class="form-control" required="required">
                           <option value="">Select Consultant</option>
                           <?php $sel=''; foreach($consultants_list as $list){
							   if($list['id']==$edit_data[0]['consultant']){
								   $sel='selected="selected"';
							   }else{
								   $sel='';
							   }
							    ?>
                           <option value="<?php echo $list['id'];?>" <?php echo $sel;?>><?php echo $list['contact_person'];?></option>
                           
                           <?php } ?>
                           </select>
                                 </div>
                                 
                                  <label class="col-sm-1">Academic Year<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select name="academic_year" id="academic_year" class="form-control" required="required">
                           <option value="">Select Year</option>
                           
                           <option value="2021" <?php if($edit_data[0]['academic_year']=="2021"){?> selected="selected"<?php } ?>>2021-22</option>
                           </select>
                                 </div>
                              </div>
                              <div class="form-group">
                                 
                                
                                 
                                 
                                 <label class="col-sm-1">DRCC City<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select name="drcc_city" id="drcc_city" class="form-control" onchange="check_ref(this);" required="required">
                           <option value="">Select City</option>
                            <?php $seldr=''; foreach($city_list as $drcity){
								 if($edit_data[0]['drcc_city']==$drcity['city_id']){
									 
								   $seldr='selected="selected"';
							   }else{
								   $seldr='';
							   }
								 ?>
                           <option value="<?php echo $drcity['city_id'];?>" <?php echo $seldr;?> ><?php echo $drcity['city_name'];?></option>
                          <?php } ?>
                           </select>
                                 </div>
                                  <label class="col-sm-1">Ref No<?=$astrik?></label>
                                 <div class="col-sm-3"><input type="text" id="ref_no" name="ref_no" value="<?php if($edit_data[0]['ref_no']!=""){ echo $edit_data[0]['ref_no'];}else{echo $current_ref[0]['ref_no'] + 1;}?>" class="form-control" placeholder="Ref No" required="required" readonly="readonly"/></div>
                                 
                                  <label class="col-sm-1">Full Ref No<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <input type="text" id="full_ref_no" name="full_ref_no" class="form-control" value="<?php echo $edit_data[0]['full_ref_no'];?>" placeholder="Full Ref No" required="required" title="Full Ref No" readonly="readonly"/>
                                 </div>
                              </div>
                              
                              
                              
                              <div class="form-group">
                                
                                
                                 <label class="col-sm-1">Course<?=$astrik?></label>
                                 <div class="col-sm-3">
                                  <select name="Course" id="Course" class="form-control" required="required">
                                   <option value="">Select Course</option>
                            <?php $sels=''; foreach($streams_yearwise as $slist){
								
								 if($slist['stream_id']==$edit_data[0]['Course']){
								   $sels='selected="selected"';
							   }else{
								   $sels='';
							   }
								 ?>
                           <option value="<?php echo $slist['stream_id'];?>" <?php echo $sels;?>><?php echo $slist['stream_name'];?></option>
                          <?php } ?>
                                    </select>
                                 </div>
                                  <label class="col-sm-1">Admission year<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select name="admission_year" id="admission_year" class="form-control" required="required">
                           <option value="">Select Admission Year</option>
                           <option value="1" <?php if($edit_data[0]['admission_year']=="1"){?> selected="selected"<?php } ?>>1st Year</option>
                           <option value="2" <?php if($edit_data[0]['admission_year']=="2"){?> selected="selected"<?php } ?>>2nd Year</option>
                           <option value="3" <?php if($edit_data[0]['admission_year']=="3"){?> selected="selected"<?php } ?>>3rd Year</option>
                           <option value="4" <?php if($edit_data[0]['admission_year']=="4"){?> selected="selected"<?php } ?>>4th Year</option>
                           </select>
                                 </div>  
                                 
                              </div>
                              
                              <div class="form-group">
                                 <label class="col-sm-1">Student&nbsp;Name&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3"><input type="text" id="student_name" name="student_name" class="form-control" placeholder="Student&nbsp;Name" required="required" pattern="^[A-Za-z][A-Za-z0-9!@#$%^&amp;* ]*$" title="Full Name should only letters. e.g. john" value="<?php echo $edit_data[0]['student_name'];?>"/></div>
                                 <label class="col-sm-1">Father&nbsp;Name&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <input type="text" id="father_name" name="father_name" class="form-control" value="<?php echo $edit_data[0]['father_name'];?>" placeholder="Father&nbsp;Name" required="required" pattern="^[A-Za-z][A-Za-z0-9!@#$%^&amp;* ]*$" title="Father Name should only letters. e.g. john"/>
                                 </div>
                                 <label class="col-sm-1">Mother&nbsp;Name&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <input type="text" id="mother_name" name="mother_name" class="form-control" value="<?php echo $edit_data[0]['mother_name'];?>" placeholder="Mother&nbsp;Name" required="required" pattern="^[A-Za-z][A-Za-z0-9!@#$%^&amp;* ]*$" title="Mother Name should only letters. e.g. john"/>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-1">Email&nbsp;</label>
                                 <div class="col-sm-3"><input type="email" id="email_id" name="email" value="<?php echo $edit_data[0]['email'];?>" class="form-control" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" /></div>
                                 <label class="col-sm-1">Mobile1&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3">
             <input type="text" id="mobile1" name="mobile1" class="form-control" value="<?php echo $edit_data[0]['mobile1'];?>" placeholder="mobile" required="required" maxlength="10"/>
                                 </div>
                                 <label class="col-sm-1">Mobile2&nbsp;</label>
                                 <div class="col-sm-3">
                                    <input type="text" id="mobile2" name="mobile2" class="form-control" value="<?php echo $edit_data[0]['mobile2'];?>" placeholder="Mobile12&nbsp;No"/>
                                 </div>
                              </div>
                              <div class="form-group">
                                
                                 <label class="col-sm-1">District&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3">
                                 <select name="District" id="District" class="form-control" required="required">
                                  <option value="">Select District</option>
                                   <?php foreach($city_list as $clistt){
									   if($clistt['city_id']==$edit_data[0]['District']){
								   $selst='selected="selected"';
							   }else{
								   $selst='';
							   }
									    ?>
                           <option value="<?php echo $clistt['city_id'];?>"  <?php echo $selst;?>><?php echo $clistt['city_name'];?></option>
                          <?php } ?></select>
                                 </div>
                                 
                                 <label class="col-sm-1">Village&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3">
                   <input type="text" id="village" name="village" class="form-control" value="<?php echo $edit_data[0]['village'];?>" placeholder="Village" required="required" />
                                 </div>
                                    <label class="col-sm-1">Pincode</label>
                <div class="col-sm-3"><input type="text" id="pincode" name="pincode" value="<?php echo $edit_data[0]['pincode'];?>" class="form-control" placeholder="Pincode"  /></div>
                              </div>
                              <div class="form-group">
                              <label class="col-sm-1">Gender<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <div class="">
                                       <label class="radio-container m-r-45">Male
                                       <input type="radio" name="gender" id="gender" <?php if($edit_data[0]['gender']=="M"){?> checked="checked"<?php } ?> value="M" required="required">
                                       </label>
                                       <label class="radio-container">Female
                                       <input type="radio" name="gender" id="gender" <?php if($edit_data[0]['gender']=="F"){?> checked="checked" <?php } ?> value="F">
                                       </label>
                                    </div>
                                 </div>
                                 
                                  <label class="col-sm-1">&nbsp;Hostel<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select name="hostel_status" id="hostel_status" class="form-control"  required="required" onchange="hostel_statuss(this);">
                                       <option value="">Select Hostel</option>
                                       <option value="Y" <?php if($edit_data[0]['hostel_status']=="Y"){?> selected="selected"<?php } ?>>YES</option>
                                       <option value="N" <?php if($edit_data[0]['hostel_status']=="N"){?> selected="selected"<?php } ?>>NO</option>
                                    </select>
                                 </div>
                                 <label class="col-sm-1">Hostel&nbsp;Type</label>
                                 <div class="col-sm-3">
                                    <select name="hostel_type" id="hostel_type" class="form-control" disabled="disabled">
                                       <option value="">Select Type</option>
                                       <option value="Type_1" <?php if($edit_data[0]['hostel_type']=="Type_1"){?> selected="selected"<?php } ?>>Type-1</option>
                                       <option value="Type_2" <?php if($edit_data[0]['hostel_type']=="Type_2"){?> selected="selected"<?php } ?>>Type-2</option>
                                    </select>
                                 </div>
                                 
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-1">Aadhar&nbsp;Card <?=$astrik?></label>
                                 <div class="col-sm-3"><input type="text" id="aadhar_card" name="aadhar_card" value="<?php echo $edit_data[0]['aadhar_card'];?>" class="form-control" placeholder="" minlength="12" required="required"/><span class="adhar_masg"></span></div>
                                 <label class="col-sm-1">Computer<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select name="computer_status" id="computer_status" class="form-control"  required="required" onchange="computer_statuss(this);">
                                       <option value="">Select Type</option>
                                       <option value="Y" <?php if($edit_data[0]['computer_status']==Y){?> selected="selected"<?php } ?>>YES</option>
                                       <option value="N" <?php if($edit_data[0]['computer_status']==N){?> selected="selected"<?php } ?>>NO</option>
                                    </select>
                                 </div>
                                  <label class="col-sm-1">Amount</label>
                                 <div class="col-sm-3"><input type="text" id="Amount" name="Amount" value="<?php echo $edit_data[0]['Amount'];?>" class="form-control" placeholder="" readonly="readonly"/></div>
                                 
                              </div>
                              <label class="col-sm-1"></label><div class="col-sm-5"></div>
                              <?php if(!empty($edit_data[0]['bcd_id'])){?>
                              <label class="col-sm-1"> <button class="btn btn-primary" id="btn_submit" name="submit" >Update</button></label>
                              <?php }else{ ?>
                              <label class="col-sm-1"> <button class="btn btn-primary" id="btn_submit" name="submit" >SAVE</button></label>
                              <?php } ?>
                               <label class="col-sm-1"> <button class="btn btn-primary" id="btn_Close" type="button" onclick="Close();">Close</button></label>
                     </div> 
                     <!--<div class="form-group">
                     <div class="row text-center">
                     
<button class="btn btn-primary" id="btn_cancel" type="button" onclick="History();">Back</button>
                <button class="btn btn-primary" id="btn_pdf" type="button" style="display:none;">PDF</button> 
                     </div>
                     </div>-->
                     </fieldset>
                     	      </form>
                     
                     
                  
                     
                     
               
                  
                     </div>
                  </div>
               </div>
            </div>
            
           <script type="text/javascript">
		   function Close(){
	$('#Bonafide_update')[0].reset();
	$("#msg_show").html("");
	$('#show_form').hide(1000);
	$('#Bonafide_update')[0].reset();
	table.ajax.reload();
}


$(document).ready(function() {

var opts=new Date();
$("#Bonafide_date").datepicker({
     todayBtn:  1,       
        autoclose: true,
    format: 'yyyy-mm-dd',
	setDate: 'today'/*,
     startDate: new Date() */
    })
});
</script>
<?php if(!empty($edit_data[0]['bcd_id'])){?>
<script type="text/javascript">
			var frm = $('#Bonafide_update');

    frm.submit(function (e) {

        e.preventDefault();
        $("#overlay").show();
		$("#msg_show").html("");
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
				if(data!=''){
                console.log('Submission was successful.');
                console.log(data);
				$("#msg_show").html("Updated Successfully").hide(6500);
				$("#overlay").hide();
				$('#show_form').hide(1000);
				table.ajax.reload();
				$('#Bonafide_update')[0].reset();
				}else{
					console.log('Submission was Fail.');
					$("#msg_show").html("Updated Fail").hide(6500);
					$("#overlay").hide();
					table.ajax.reload();
					$('#show_form').hide(1000);
				$('#Bonafide_update')[0].reset();
				}
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
				$("#overlay").hide();
				table.ajax.reload();
				$('#show_form').hide(1000);
				$('#Bonafide_update')[0].reset();
            },
        });
    });
            </script>
            <?php }else{?>
            <script type="text/javascript">
			 var frm = $('#Bonafide_update');

    frm.submit(function (e) {

        e.preventDefault();
		$("#msg_show").html("");
       $("#overlay").show();
	   
	   
	   
	   
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
				if(data!=''){
					if(data=='C'){
					$("#msg_show").html("Adhar No Alreday Register");
				    $("#aadhar_card").focus();	
					// $("#aadhar_card").focus();
					$(".adhar_masg").html("Adhar No Alreday Register");	
					
					$("#overlay").hide();
					return false;
				//table.ajax.reload();
				//$('#show_form').hide(1000);
				//$('#Bonafide_update')[0].reset();
					}else{
                console.log('Submission was successful.');
				$("#msg_show").html("Added Successfully").hide(6500);
                console.log(data);
				$("#overlay").hide();
				table.ajax.reload();
				$('#show_form').hide(1000);
				$('#Bonafide_update')[0].reset();
					}
				}else{
					console.log('Submission was Fail.');
					$("#msg_show").html("Submission was Fail").hide(6500);
					$("#overlay").hide();
					table.ajax.reload();
					$('#show_form').hide(1000);
					$('#Bonafide_update')[0].reset();
				}
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
				$("#msg_show").html("Submission was Fail");
				$("#overlay").hide();
            },
        });
    });
	function check_ref(m){
	var distict=$('#drcc_city option:selected').text();
	var ref_no=$('#ref_no').val();
	var value="SUM/DRCC "+distict+"/2021/"+ref_no;
	$("#full_ref_no").val(value);

}
			</script>
            <?php } ?>