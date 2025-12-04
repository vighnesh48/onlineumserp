<?php 
      if($studid !=''){
		$role_id = $this->session->userdata("role_id");
		if($role_id ==4){
			$reval = REVAL;
		}else{
			$reval = $this->session->userdata('reval');
		}
		if($reval==0){
		    $report_name="PHOTOCOPY";
		    $reportName="Photocopy";
		}else{
		    $report_name="REVALUATION";
		    $reportName="Revaluation";
		}    

    ?>
		
		
		
    <div class="row ">
	<form id="form" name="form"  action="https://secure.payu.in/_payment"  method="POST" onsubmit="return submitPayuForm()">
			<div class="col-sm-12">
				<div class="panel">           
        <div class="panel-body">
					<div class="col-sm-12">
						<div class="panel">
						<div class="panel-heading">
                <span class="panel-title">Personal Details</span>
						</div>
					<!--form name="exam_form" method="POST" action="<?=base_url($currentModule.'/update_subject_details')?>"-->
				       
                         
						<table class="table table-bordered">
    					<tr>
    					  <th width="12%">PRN No :</th>
						  <td width="38%"><?=$emp[0]['enrollment_no']?>-<?=$this->session->userdata("uid")?></td>
						  <th width="12%">Exam Name :</th>
						  <td width="38%"><?=$exam[0]['exam_month']?>-<?=$exam[0]['exam_year']?></td>
						</tr>
						<tr>
						  <th scope="col">Student Name :</th>
						  <td><?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></td>
						   <th >DOB:</th>
						   <td><?=$emp[0]['dob']?> </td>
						</tr>
						<tr>
    					  <th scope="col">Course Name :</th>
						  <td><?=$emp[0]['stream_name']?></td>
						   <th>School :</th>
						   <td><?=$emp[0]['school_code']?>-<?=$emp[0]['school_name']?></td>
    					</tr>

						</table>
						</div>
						</div>

						<div class="col-sm-12">
						<div class="panel">
						<div class="panel-heading">
              <div class="panel-title" >Subject Appeared</div>
						</div>
						<div class="panel-body">	
							<table class="table table-bordered">
							<thead>
								<tr>
									<th>Sr.No</th>
									<th>Course Code</th>
									<th>Course Name</th>
									<th>Subject Type</th>
									<th>Semester</th>
                  <!--th>INT</th>
                  <th>EXT</th-->
                  <th>Grade</th>
				  <?php if($reval==0){
					  $productinfo ='Photocopy_Examination';
					  ?>
                  <th>Photo Copy</th>
				  <?php }else{
					  $productinfo ='REVAL_Examination';
					  ?>
                  <th>Re-Valuation</th>
				  <?php }?>
									
								</tr>
							</thead>
							<tbody>
							<input type="hidden" name="exam_details" value="<?=$exam[0]['exam_id']?>~<?=$exam[0]['exam_month']?>~<?=$exam[0]['exam_year']?>~<?=$exam[0]['exam_master_id']?>">
							<input type="hidden" name="stream_id" value="<?=$emp[0]['admission_stream']?>">
							<input type="hidden" name="semester" value="<?=$emp[0]['admission_semester']?>">	
							<input type="hidden" name="reval_type" value="<?=$reval?>">	
							<input type="hidden" name="exam_id" id="exam_id" value="<?php echo $exam[0]['exam_id']; ?>">

                      <input type="hidden" name="applicable_fee" id="applicable_fee">
                      <input type="hidden" name="student_id"  id="student_id" value="<?=$emp[0]['stud_id']?>">
                      <input type="hidden" name="ex_master_id" id="ex_master_id" value="<?=$sublist[0]['exam_master_id']?>">
			         <input type="hidden" name="key" value="soe5Fh" /><?php //echo $MERCHANT_KEY ?>
                     <input type="hidden" name="hash" id="hash" value=""/>
                     <input type="hidden" name="txnid" id="txnid" value="" />
                     <input type="hidden" name="amount" id="amount" value="1" />
                    <!-- <input type="hidden" name="action" value="https://secure.payu.in/_payment" />-->
                     <?php // $vat = date('ymd')."".rand(1000,9999); ?>
                     <input name="firstname" id="firstname" type="hidden"  placeholder="Enter your Name*"  value="<?php echo trim( $emp[0]['first_name']); ?>"  required />
                     <input name="email" id="email" type="hidden"  placeholder="Email*"  value="<?php echo $emp[0]['email']; ?>"  required />
                     <input type="hidden" name="mobile" id="mobile_hp" value="<?php echo $emp[0]['mobile']; ?>" required="required">
                     <input type="hidden" name="udf1" id="udf1" value="">
                     <input type="hidden" name="udf2" id="udf2" value="<?php echo $exam[0]['exam_id']; ?>">
                     <input type="hidden" name="udf3" id="udf3" value="<?php echo $emp[0]['enrollment_no']; ?>"> 
                     <input type="hidden" name="academic_year" value="<?php echo C_RE_REG_YEAR ?>">					 
                     <input type="hidden" name="udf4" id="udf4" value="<?php echo $emp[0]['mobile']; ?>">
                     <input type="hidden" name="udf5" id="udf5" value="<?php echo $emp[0]['stud_id']; ?>"> 
                     <input type="hidden" name="stud_id" id="stud_id" value="<?php echo $emp[0]['stud_id']; ?>" required="required">
                     <input type="hidden" name="surl" value="https://erp.sandipuniversity.com/Online_fee/reval_exam_success"/>
                     <input type="hidden" name="furl" value="https://erp.sandipuniversity.com/Online_fee/reval_failure"/>
                     <!--input type="hidden" name="productinfo" id="productinfo" value="<?php echo $exam[0]['exam_month'] ?>-<?php echo $exam[0]['exam_year'] ?>_Exam_Fees" / -->
                     <input type="hidden" name="productinfo" id="productinfo" value="<?=$productinfo?>" />
								<?php
								$i=1;
								$f_download =0;
								$no_of_sub_appered =0;
								$wh_arr =array();
									if(!empty($sublist)){
										foreach($sublist as $sub){
										    array_push($wh_arr, $sub['final_grade']);
											if($sub['subject_component'] =='PR'){
												$subject_component ="disabled";
											}else{
												$subject_component ="";
											}
											if($reval==0){	
												if($sub['photocopy_appeared'] =='Y'){
													$f_download =1;
													$no_of_sub_appered += 1;
												}
											}else{
												if($sub['reval_appeared'] =='Y'){
													$f_download =1;
													$no_of_sub_appered += 1;
												}
											}
								?>
								<tr>
									<td><?=$i;?></td>
									<td>
									<?=$sub['subject_code']?></td>
									<td><?=$sub['subject_name']?></td>
									<td><?=$sub['subject_component']?> <?php if($sub['subject_component'] == 'EM'){echo '<small>('.$sub['failed_sub_type'].')</small>';} ?></td>
									<td><?=$sub['semester']?></td>
                  <!--td><?=$sub['cia_marks']?></td>
                  <td><?=$sub['exam_marks']?></td-->
                  <td><?=$sub['final_grade']?></td>
									<?php if($reval==0){?>				
									<td><input type="checkbox" <?=$subject_component?> name="p_sub[]" id="<?=$i;?>_psub" class='studCheckBox' value="<?=$sub['sub_id']?>~<?=$sub['exam_subject_id']?>" onclick="CheckSubjectCNT(this.id)" <?php if($sub['photocopy_appeared']=='Y'){ echo 'checked disabled';} ?>></td>
									<?php }else{?>
									<td><input type="checkbox"  name="r_sub[]" id="r_sub<?=$sub['sub_id']?>" class='studCheckBox' value="<?=$sub['sub_id']?>~<?=$sub['exam_subject_id']?>" onclick="CheckSubjectCNT(this.id)" <?php if($sub['reval_appeared']=='Y'){ echo 'checked';} ?>></td>
									 <?php }?>
								</tr>
								<?php 
									$i++;
									}
									}else{
										echo "<tr><td colspan=6>No data found.</td></tr>";
									}
								?>
								</tbody>
							</table><br>
							<div class="row">
								<div class="col-sm-12">
									<div class="col-sm-6" style="float:left;text-align: left;">Fee to be Paid: <b><span id="total_fees"><?php 
									if($reval==0){ 
										if(!empty($sublist[0]['photocopy_fees'])){ 
											echo $sublist[0]['photocopy_fees'].'/';
										}
									}else{ 
										if(!empty($sublist[0]['reval_fees'])){ 
											echo $sublist[0]['reval_fees'].'/';
										}
									}?></span></b></div>
									<div class="col-sm-6" style="float:right;text-align: right;"> No. Of subject appeared: <b><span id="no_of_sub_appered"><?php if(!empty($sublist)){ echo $no_of_sub_appered;}?></span></b> </div>
								</div>
							</div>
							</div>
						</div>
							
							<div class="row">
								<div class="col-sm-12">
                  
								<div class="col-sm-2">
                  						<?php if(in_array("WH", $wh_arr)){ echo "<span style='color:red;'>You are not applicable for Revaluation as your result is with-held.</span>";}else{ 
                  						if($f_download =='0' ){
											if(!empty($sublist)){
											?>
									        <input type="submit" name="save" id="btn_markReval11" value="Submit" class="btn btn-primary">
											<?php }}else{
                 						        if($this->session->userdata('role_id') !=4){	
                 						?>
                 					        <input type="submit" name="update" id="btn_updateReval111" value="Update" class="btn btn-primary">
                 					<?php       }
                 				        }
                                    }
                 				   ?>
								</div>
								<?php 
								if($this->session->userdata('role_id') !=4){	
                 						?>
								<div class="col-sm-8"><button class="btn btn-primary pull-left" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/list_applied'">Cancel</button>
								</div>	
								<?php }?>
								<div class="col-sm-2">	
									<?php if($f_download =='1'){?>
								<button class="btn btn-primary pull-right" id="btn_download_form" type="button">Download PDF</button>
								<?php }?>
								</div>							
							</div>
							</div><br><br>
							<div class="row">
								<div class="col-sm-12">
									<ul><b>NOTE:</b><br>
									<li>Only Theory papers are allowed for <?=$reportName?>.</li>
									<!--li>Select the maximum 3 papers for <?=$reportName?> and submit the form.</li--> 
									<li>Download the pdf of the <?=$reportName?> form. </li>
									<li>Make payment to the accounts department and submit to the Finance department.</li>
									<li>No any changes are allowed after submission of the form except COE department. </li>
									</ul>
								</div>
							</div>
							</div>
						</div>
						
							<div class="clearfix">&nbsp;</div>
				
						</div>
			
          </div>
		  </form>
        </div>
			</div>
		</div>
    <?php }else{ ?>
    <div class="row ">
      <div class="col-sm-12" style="color:red;">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">Student with this PRN is not registered.</div>
      </div>
    </div>
    <?php }?>

<style>

.table,table{width: 100%;max-width: 100%;}
.table-info table {
    border-top-color: #f6deac!important;
}
.table-info thead th, .table-info thead tr {
    background: #f9f1c7;
        border-color: #f6deac!important;color:#8a6d3b;
}
.panel-warning > .panel-heading {
    color: #8a6d3b;
    background-color: #fcf8e3;
    border-color: #faebcc!important;
}
.table thead tr th {
    font-size: 12px!important;
    /* font-weight: 600; */
}
</style>
<script>
 function  donep(){ //$(".loader").hide();
   var payuForm = document.forms.form;
   payuForm.submit();
 //$('#payuForm').trigger('submit');

   }
   function submitPayuForm() {
	   //alert(1);
	if(confirm("Are you sure to update the Form?")){
		
	  var applicable_fee = $("#applicable_fee").val();
      var student_id = $("#student_id").val();
      var ex_master_id = $("#ex_master_id").val();
      var exam_id ='<?=$exam[0]['exam_id']?>';
      //alert(stream_code);
      var p_checked = [];
            $.each($("input[name='p_sub[]']:checked"), function(){            
                p_checked.push($(this).val());
            });
            //alert(p_checked);
            //console.log(p_checked); 
      var r_checked = [];
            $.each($("input[name='r_sub[]']:checked"), function(){            
                r_checked.push($(this).val());
            });
		
        if (p_checked || r_checked) {
			
      	var reval = '<?=$reval?>';
		//alert(reval);
      	if(reval==0){
      		//var url1="update_revalsubject_details";
      		var url1="update_revalsubjects";
      	}else{
      		var url1="update_revalsubjects"
      	}
		var data = $('#form').serializeArray(); // convert form to array
		 console.log(data);
         data.push({r_checked: "r_checked", p_checked: p_checked});
	   $.ajax({
          type: 'POST',
          url: '<?= base_url() ?>Reval/'+url1,
          //data: $.param(data),
		  data: $('#form').serialize() + '&r_checked=' + r_checked,
		  'dataType': "json",
          success: function (data){
       //alert(data); 
   //probably this request will return anything, it'll be put in var "data"
   //var container = $('#feepend'); //jquery selector (get element by id)
   if(data!==''){
	   console.log(data);
	   //return false;
	   //break;
	 if(data.amount !== ''){
      //alert(data);
 
    $('#txnid').val(data.txnid);
	$('#hash').val(data.hash);
	$('#amount').val(data.amount);
	
	$('#udf1').val(data.udf1);
	//$('#udf2').val(data.udf2);
	$('#udf3').val(data.udf3);
	$('#udf4').val(data.udf4);
	$('#udf5').val(data.udf5);
	/* if(productinfo=='Re-Registration'){
	 $('#amount').attr('readonly', true); 
	}else{
	$('#amount').attr('readonly', false); 
	} */
	setTimeout(function(){ donep() }, 1000);
	return true;
	
   }
   else{
	   //alert(data.path);
	  return false; 
	   //window.location.href = base_url+data.path;
	   
	   
   }
   }
   }
   })
   return false;
		}else {
			return false;
        
	}}else{
		  //return false;
	  }
   }
</script>
<script>
function CheckSubjectCNT(id){
	var maxAllowed = 3;
	var app_fee = 500;
	var reval ='<?=$reval?>';
	if(reval==0){
	  	var p_sublist = $("[name='p_sub[]']:checked").length;
	  }else{
	  	var p_sublist = $("[name='r_sub[]']:checked").length;
	  }
  	if (p_sublist <= 3) {
        var tot_fee = app_fee * p_sublist;
   //alert(p_sublist);
	    
	    $('#total_fees').html(tot_fee+'/-');
	    $('#applicable_fee').val(tot_fee);
		$('#no_of_sub_appered').html(p_sublist);
   }else{
   		//alert(id);
        alert("Maximum 3 subjects are allowed.");
		$('#'+id).prop('checked', false);
   }
  //var r_sublist = $("[name='r_sub[]']:checked").length;
  //var sublist = p_sublist + r_sublist;
   
   //alert(app_fee);

}
$(document).ready(function () {
  //Revalidate student
	  $('#btn_markReval1').on('click', function () {
		alert("hi");
		 if(confirm("Are you sure to submit the Form?")){
		  var applicable_fee = $("#applicable_fee").val();
		  var student_id = $("#student_id").val();
		  var ex_master_id = $("#ex_master_id").val();
		  //alert(stream_code);
		  var p_checked = [];
				$.each($("input[name='p_sub[]']:checked"), function(){            
					p_checked.push($(this).val());
				});
				//alert(p_checked);
				//console.log(p_checked); 
		  var r_checked = [];
				$.each($("input[name='r_sub[]']:checked"), function(){            
					r_checked.push($(this).val());
				});  
				//console.log(p_checked);          
		  if (p_checked || r_checked) {
			$.ajax({
			  type: 'POST',
			  url: '<?= base_url() ?>Reval/revalidate',
			  data: {r_checked:r_checked,p_checked:p_checked,applicable_fee:applicable_fee,student_id:student_id,ex_master_id:ex_master_id},
			  success: function (data) {
				//alert(data);
				if(data=='SUCCESS'){
					var studid = '<?=$this->session->userdata('role_id')?>';
					alert("Form submitted successfully.");
					if(studid==4){
					location.reload();
					}
				}else{
				  alert("You have already Re-validated");
				}
				
			  }
			});
		  } else {
			
		  }
	  }else{
		  return false;
	  }
    });
  // update reval subjects
    $('#btn_updateReval').on('click', function () {
    alert("hi");
	if(confirm("Are you sure to update the Form?")){
      var applicable_fee = $("#applicable_fee").val();
      var student_id = $("#student_id").val();
      var ex_master_id = $("#ex_master_id").val();
      var exam_id ='<?=$exam_id?>';
      //alert(stream_code);
      var p_checked = [];
            $.each($("input[name='p_sub[]']:checked"), function(){            
                p_checked.push($(this).val());
            });
            //alert(p_checked);
            //console.log(p_checked); 
      var r_checked = [];
            $.each($("input[name='r_sub[]']:checked"), function(){            
                r_checked.push($(this).val());
            });  
            //console.log(p_checked);          
      if (p_checked || r_checked) {
      	var reval = '<?=$reval?>';
      	if(reval==0){
      		var url1="update_revalsubject_details";
      	}else{
      		var url1="update_revalsubjects"
      	}
        $.ajax({
          type: 'POST',
          url: '<?= base_url() ?>Reval/'+url1,
          data: {r_checked:r_checked,p_checked:p_checked,applicable_fee:applicable_fee,student_id:student_id,ex_master_id:ex_master_id,exam_id:exam_id},
          success: function (data) {
            //alert(data);
            if(data=='SUCCESS'){
					alert("Form Updated successfully.");
					location.reload();
				}else{
              alert("You have already Re-validated");
            }
            
          }
        });
      } else {
        
      }
	   }else{
		  return false;
	  }
    });

  

    $('#btn_download_form').on('click', function () {	
    	var student_id = $("#student_id").val();
    	var exam_id= '<?=$exam_id?>';
    	//alert(exam_id);
    	window.location.href = '<?= base_url() ?>Reval/btn_download_rvalform/'+student_id+'/'+exam_id;
	}); 

});    
</script>