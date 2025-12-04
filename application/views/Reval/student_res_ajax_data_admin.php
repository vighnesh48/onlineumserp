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
						  <td width="38%"><?=$emp[0]['enrollment_no']?></td>
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
									<th>Semester</th>
                  <!--th>INT</th>
                  <th>EXT</th-->
                  <th>Grade</th>
				  <?php if($reval==0){?>
                  <th>Photo Copy</th>
				  <?php }else{?>
                  <th>Re-Valuation</th>
				  <?php }?>
									
								</tr>
							</thead>
							<tbody>
							<input type="hidden" name="exam_details" value="<?=$exam[0]['exam_id']?>~<?=$exam[0]['exam_month']?>~<?=$exam[0]['exam_year']?>~<?=$exam[0]['exam_master_id']?>">
							<input type="hidden" name="stream_id" value="<?=$emp[0]['admission_stream']?>">
							<input type="hidden" name="semester" value="<?=$emp[0]['admission_semester']?>">	

              <input type="hidden" name="applicable_fee" id="applicable_fee">
              <input type="hidden" name="student_id"  id="student_id" value="<?=$emp[0]['stud_id']?>">
              <input type="hidden" name="ex_master_id" id="ex_master_id" value="<?=$sublist[0]['exam_master_id']?>">
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
									<?=$sub['subject_code'].''.$sub['subject_component']?></td>
									<td><?=$sub['subject_name']?></td>
									<td><?=$sub['semester']?></td>
                  <!--td><?=$sub['cia_marks']?></td>
                  <td><?=$sub['exam_marks']?></td-->
                  <td><?=$sub['final_grade']?></td>
									<?php if($reval==0){?>				
									<td><input type="checkbox"  <?=$subject_component?> name="p_sub[]" id="<?=$i;?>_psub" class='studCheckBox' value="<?=$sub['sub_id']?>~<?=$sub['exam_subject_id']?>" onclick="CheckSubjectCNT(this.id)" <?php if($sub['photocopy_appeared']=='Y'){ echo 'checked';} ?>></td>
									<?php }else{?>
									<td><input type="checkbox"  name="r_sub[]" id="r_sub<?=$sub['sub_id']?>" class='studCheckBox' value="<?=$sub['sub_id']?>~<?=$sub['exam_subject_id']?>" onclick="CheckSubjectCNT(this.id)" <?php if($sub['reval_appeared']=='Y'){ echo 'checked';} ?>></td>
									 <?php }?>
								</tr>
								<?php 
								unset($subject_component);
									$i++;
									}
									}else{
										echo "<tr><td colspan=4>No data found.</td></tr>";
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
								    <?php if(in_array("WH", $wh_arr)){ echo "<span style='color:red;'>You are not applicable for photocopy as your result is with-held.</span>";}else{  
                  						    if($f_download =='0' ){?>
									<input type="submit" name="save" id="btn_markReval" value="Submit" class="btn btn-primary">
                 					<?php }else{
                 						if($this->session->userdata('role_id') !=4){	
                 						?>
                 					<input type="submit" name="update" id="btn_updateReval" value="Update" class="btn btn-primary">
                 					<?php }
                 				}
                 				}?>
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
						<!--/form-->
							<div class="clearfix">&nbsp;</div>
				
						</div>
          </div>
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
   		$('#'+id).prop('checked', false);
        alert("Maximum 3 subjects are allowed.");
   }
  //var r_sublist = $("[name='r_sub[]']:checked").length;
  //var sublist = p_sublist + r_sublist;
   
   //alert(app_fee);

}
$(document).ready(function () {
  //Revalidate student
	  $('#btn_markReval').on('click', function () {
		//alert("hi");
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
    //alert("hi");
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