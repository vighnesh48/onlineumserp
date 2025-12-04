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
                              <legend class="scheduler-border">Add New</legend>
                              <div class="form-group enquiry_no">
                                 <label class="col-sm-1">DATE <?=$astrik?></label>
                            <div class="col-sm-3"><input type="text" id="Bonafide_datee" name="date" value="<?php echo date('Y-m-d');?>" class="form-control" value="" required="required" readonly="readonly"/></div>
                             </div>
                              <div class="form-group">
                               <label class="col-sm-1">&nbsp;First&nbsp;Name&nbsp;<?=$astrik?></label>
                               <div class="col-sm-3"><input type="text" id="First_name" name="First_name" value="" class="form-control" placeholder="First name" /></div>
                                <label class="col-sm-1">Middle&nbsp;Name</label>
                               <div class="col-sm-3"><input type="text" id="Middle_name" name="Middle_name" value="" class="form-control" placeholder="Middle name" /></div>
                               <label class="col-sm-1">Last&nbsp;Name</label>
                               <div class="col-sm-3"><input type="text" id="Last_name" name="Last_name" value="" class="form-control" placeholder="Last name" /></div>
                                 
                                
                              </div>
                              <div class="form-group">
                                   <label class="col-sm-1">Academic Year<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select name="academic_year" id="academic_year" class="form-control" required="required">
                           <option value="">Select Year</option>
                           
                           <option value="2021" selected="selected">2021-22</option>
                           </select>
                                 </div>
                                
                                 
                                 
                                 <label class="col-sm-1">Country&nbsp;Name<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select name="Country" id="Country" class="form-control" onchange="check_ref(this);" required="required">
                           <option value="">Select Country</option>
                            <?php $seldr=''; foreach($getcountry as $drcity){
								
								 ?>
                           <option value="<?php echo $drcity['id'];?>"  ><?php echo $drcity['name'];?></option>
                          <?php } ?>
                           </select>
                                 </div>
                                  <label class="col-sm-1"></label>
                                 <div class="col-sm-3"><input type="hidden" id="ref_no" name="ref_no" value="<?php echo $current_ref[0]['ref_no'] + 1;?>" class="form-control" placeholder="Ref No" required readonly/></div>
                                 
                                  
                                 
                              </div>
                              
                              
                              
                              <div class="form-group">
                                
                                
                                 <label class="col-sm-1">Course<?=$astrik?></label>
                                 <div class="col-sm-3">
                                  <select name="Course" id="Course" class="form-control" required="required">
                                   <option value="">Select Course</option>
                            <?php $sels=''; foreach($getcourse as $slist){
								
								 
								 ?>
                           <option value="<?php echo $slist['stream_id'];?>"><?php echo $slist['stream_name'];?></option>
                          <?php } ?>
                                    </select>
                                 </div>
                                  <label class="col-sm-1">Admission year<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select name="admission_year" id="admission_year" class="form-control" required="required">
                           <option value="">Select Admission Year</option>
                           <option value="1" <?php if($edit_data[0]['admission_year']=="1"){?> selected="selected"<?php } ?>>1st Year</option>
                           <option value="2" <?php if($edit_data[0]['admission_year']=="2"){?> selected="selected"<?php } ?>>2nd Year</option>
                         
                           </select>
                                 </div>  
                                 
                              </div>
                              
                              
                              <div class="form-group">
                                 <label class="col-sm-1">Email&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3"><input type="email" id="email_id" name="email" value="<?php echo $edit_data[0]['email'];?>" class="form-control" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required /></div>
                                 <label class="col-sm-1">Mobile1&nbsp;</label>
                                 <div class="col-sm-3">
             <input type="text" id="mobile1" name="mobile1" class="form-control" value="<?php echo $edit_data[0]['mobile1'];?>" placeholder="mobile"  maxlength="10"/>
                                 </div>
                                 <label class="col-sm-1">Mobile2&nbsp;</label>
                                 <div class="col-sm-3">
                                    <input type="text" id="mobile2" name="mobile2" class="form-control" value="<?php echo $edit_data[0]['mobile2'];?>" placeholder="Mobile12&nbsp;No"/>
                                 </div>
                              </div>
                              
                              <div class="form-group">
                              <label class="col-sm-1">Gender<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <div class="">
                                       <label class="radio-container m-r-45">Male
                                       <input type="radio" name="gender" id="gender" <?php if($edit_data[0]['gender']=="M"){?> checked="checked"<?php } ?> value="M" required>
                                       </label>
                                       <label class="radio-container">Female
                                       <input type="radio" name="gender" id="gender" <?php if($edit_data[0]['gender']=="F"){?> checked="checked" <?php } ?> value="F">
                                       </label>
                                    </div>
                                    
                                 </div>
                                  <label class="col-sm-1">Passport&nbsp;No <?=$astrik?></label>
                                 <div class="col-sm-3"><input type="text" id="aadhar_card" name="aadhar_card" value="<?php echo $edit_data[0]['aadhar_card'];?>" class="form-control" placeholder="" minlength="12" required/><span class="adhar_masg"></span></div>
                                
                              </div>
                              <div class="form-group">
                                <label class="col-sm-1">Upload</label>
                                 <div class="col-sm-3"><input type="file" id="file" name="file"  class="form-control" placeholder=""/></div>
                                
                                  <label class="col-sm-1">Amount</label>
                                 <div class="col-sm-3"><input type="text" id="Amount" name="Amount" value="<?php echo $edit_data[0]['Amount'];?>" class="form-control" placeholder="Amount"/></div>
                                 
                              </div>
                              <label class="col-sm-1"></label><div class="col-sm-5"></div>
                              <?php if(!empty($edit_data[0]['bcd_id'])){?>
                              <label class="col-sm-1"> <button class="btn btn-primary" id="btn_submit" name="submit" >Update</button></label>
                              <?php }else{ ?>
                              <label class="col-sm-1"> <button class="btn btn-primary" id="btn_submit" name="submit" >Submit</button></label>
                              <?php } ?>
                               <label class="col-sm-1"> <input class="btn btn-primary" id="btn_Close" type="RESET" ></label>
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