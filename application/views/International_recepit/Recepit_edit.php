<?php $astrik="*";?>
<div class="col-sm-12">
            <div id="dashboard-recent" class="panel panel-warning">
               <div class="tab-content">
                  <span style="color:red; padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                  <div id="personal-details" class="widget-comments panel-body tab-pane fade active in">
                     <div class="panel">
                     <?php if(!empty($edit_data[0]['idr'])){?>
                        <form id="Bonafide_update"   name="Bonafide_update" action="<?php echo base_url();?>International_recepit/update_data" method="post"  enctype="multipart/form-data" >
                        <input type="hidden" id="idr" name="idr" class="form-control" value="<?php echo $edit_data[0]['idr'];?>"/>
                        <?php }else{ ?>
                         <form id="Bonafide_update"   name="Bonafide_update" action="<?php echo base_url();?>International_recepit/insert_data" method="post"  enctype="multipart/form-data" >
                        <?php } ?>
                          
                           <fieldset class="scheduler-border">
                              <legend class="scheduler-border">Add Recepit</legend>
                              <div class="form-group enquiry_no">
                                 <label class="col-sm-1">DATE <?=$astrik?></label>
                            <div class="col-sm-3"><input type="text" id="Recepit_date" name="Recepit_date" class="form-control" value="<?php if(!empty($edit_data[0]['Recepit_date'])){ echo $edit_data[0]['Recepit_date'];}else{echo date('Y-m-d');}?>" required="required"/></div>
                            
                                 
                                  <label class="col-sm-1">Academic Year<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select name="academic_year" id="academic_year" class="form-control">
                           <option value="">Select Year</option>
                           
                           <option value="2021" selected="selected">2021-22</option>
                           </select>
                                 </div>
                              </div>
                              <div class="form-group">
                                 
                                
                                 
                                 
                                 <label class="col-sm-1">Country<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select name="Country" id="Country" class="form-control">
                           <option value="">Select Country</option>
                            <?php foreach($Country_list as $clist){ ?>
                            <?php 
							 if($clist['id']==$edit_data[0]['Country']){
								   $sel='selected="selected"';
							   }else{
								   $sel='';
							   }
							
							?>
                            
                            
                            
                           <option value="<?php echo $clist['id'];?>" <?php echo $sel;?>><?php echo $clist['name'];?></option>
                          <?php } ?>
                           </select>
                                 </div>
                                   <label class="col-sm-1">Course<?=$astrik?></label>
                                 <div class="col-sm-3">
                                  <select name="Course" id="Course" class="form-control" required="required">
                                   <option value="">Select Course</option>
                            <?php $sell=''; foreach($streams_yearwise as $slist){ ?>
                            <?php 
							 if($slist['stream_id']==$edit_data[0]['Course']){
								   $sell='selected="selected"';
							   }else{
								   $sell='';
							   }
							
							?>
                            
                            
                           <option value="<?php echo $slist['stream_id'];?>" <?php echo $sell;?>><?php echo $slist['stream_name'];?></option>
                          <?php } ?>
                                    </select>
                                 </div>
                                  <label class="col-sm-1">Admission year<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select name="admission_year" id="admission_year" class="form-control">
                           <option value="">Select Year</option>
                           <option value="1" <?php if($edit_data[0]['admission_year']==1){?> selected="selected"<?php } ?>>1st Year</option>
                           <option value="2" <?php if($edit_data[0]['admission_year']==2){?> selected="selected"<?php } ?>>2nd Year</option>
                  
                           </select>
                                 </div>  
                                 <div><input type="hidden" id="ref_no" name="ref_no" value="<?php if($edit_data[0]['ref_no']!=""){ echo $edit_data[0]['ref_no'];}else{echo $current_ref[0]['ref_no'] + 1;}?>" class="form-control" placeholder="Ref No" /></div>
                                 
                                  
                              </div>
                              
                              
                              
                              <div class="form-group">
                                
                                
                                
                                 
                              </div>
                              
                              <div class="form-group">
                                 <label class="col-sm-1">Student&nbsp;Name&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3"><input type="text" id="student_name" name="student_name" class="form-control" placeholder="Student&nbsp;Name" required="required" pattern="^[A-Za-z][A-Za-z0-9!@#$%^&amp;* ]*$" title="Full Name should only letters. e.g. john" value="<?php echo $edit_data[0]['student_name'];?>"/></div>
                                
                                  <label class="col-sm-1">Email&nbsp;</label>
                                 <div class="col-sm-3"><input type="email" id="email_id" name="email_id" value="<?php echo $edit_data[0]['email_id'];?>" class="form-control" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" /></div>
                                 <label class="col-sm-1">Mobile1&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <input type="text" id="mobile1" name="mobile1" class="form-control" value="<?php echo $edit_data[0]['mobile1'];?>" placeholder="mobile" required="required" maxlength="10"/>
                                 </div>
                              </div>
                              
                              
                              <div class="form-group">
                              <label class="col-sm-1">Passport&nbsp;No<?=$astrik?></label>
                                 <div class="col-sm-3"><input type="text" id="Passport_No" name="Passport_No" class="form-control" value="<?php echo $edit_data[0]['Passport_No'];?>" placeholder="" minlength="15"/></div>
                              <label class="col-sm-1">Gender<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <div class="">
                                       <label class="radio-container m-r-45">Male
                                       <input type="radio" name="gender" id="gender" <?php if($edit_data[0]['gender']=="M"){?> checked="checked"<?php } ?> value="M" required="required">
                                       </label>
                                       <label class="radio-container">Female
                                       <input type="radio" name="gender" id="gender" <?php if($edit_data[0]['gender']=="F"){?> checked="checked"<?php } ?> value="F">
                                       </label>
                                    </div>
                                 </div>
                                 
                                  <label class="col-sm-1">&nbsp;Hostel<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select name="hostel_status" id="hostel_status" class="form-control"  required="required">
                                       <option value="">Select Hostel</option>
                                       <option value="Y" <?php if($edit_data[0]['hostel_status']=="Y"){?> selected="selected"<?php } ?>>YES</option>
                                       <option value="N" <?php if($edit_data[0]['hostel_status']=="N"){?> selected="selected"<?php } ?>>NO</option>
                                    </select>
                                 </div>
                                 
                                 
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-1">Recepit Upload</label>
                                 <div class="col-sm-3"><input type="file" id="Recepit_Upload" name="Recepit_Upload" class="form-control" placeholder=""  required="required"/></div>
                                
                                  <label class="col-sm-1">Amount</label>
                                 <div class="col-sm-3"><input type="text" id="Amount" name="Amount" class="form-control" placeholder="" value="<?php echo $edit_data[0]['Amount'];?>"  required="required"/></div>
                                 
                              </div>
                              
                     </div> 
                     <div class="form-group">
                                
                                <label class="col-sm-1"></label><div class="col-sm-4"></div>
                                  <?php if(!empty($edit_data[0]['idr'])){?>
                              <label class="col-sm-1"> <button class="btn btn-primary" id="btnSubmit" name="submit" >Update</button></label>
                              <?php }else{ ?>
                               <label class="col-sm-1"> <button class="btn btn-primary" id="btnSubmit" name="submit" >SAVE</button></label>
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

</script>

<script type="text/javascript">
		
	
var frm = $('#Bonafide_update');
    $("#btnSubmit").click(function() {

        //stop submit the form, we will post it manually.
        event.preventDefault();

        // Get form
        var form = $('#Bonafide_update')[0];

        // Create an FormData object 
        var data = new FormData(form);

        // If you want to add an extra field for the FormData
      //  data.append("CustomField", "This is some extra data, testing");

        // disabled the submit button
        $("#btnSubmit").prop("disabled", true);
        $("#msg_show").html("");
        $("#overlay").show();
        
		
		$.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: frm.attr('action'),
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {

                //$("#result").text(data);
               // console.log("SUCCESS : ", data);
                //$("#btnSubmit").prop("disabled", false);
				if(data!=''){
					
					if(data=='C'){
					$("#msg_show").html("Adhar No Alreday Register");
				    $("#aadhar_card").focus();	
					// $("#aadhar_card").focus();
					$(".adhar_masg").html("Adhar No Alreday Register");	
					$("#overlay").hide();
					return false;
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
            error: function (e) {

               console.log('An error occurred.');
                console.log(data);
				$("#msg_show").html("Submission was Fail");
				$("#overlay").hide();
            }
        });

    });


          
          

			
			
			
			
			
			
	
	
	function check_ref(m){
		
	var distict=$('#drcc_city option:selected').text();
	var ref_no=$('#ref_no').val();
	var value="SUM/DRCC "+distict+"/2021/"+ref_no;
	$("#full_ref_no").val(value);

}
			</script>
            