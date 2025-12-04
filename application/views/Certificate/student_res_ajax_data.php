<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<?php 
      if(!empty($emp)){  

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
					<form name="prov_form" id="prov_form" method="POST" action="<?=base_url($currentModule.'/add_provisional_form')?>">
                         
						<table class="table table-bordered">
    					<tr>
    					  <th width="15%">Student Name :</th>
						  <td width="38%"><?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></td>
						  <th width="15%" scope="col">PRN No :</th>
						  <td><?=$emp[0]['enrollment_no']?></td>

						  
						</tr>
						<tr>
    					  <th scope="col">Course Name :</th>
						  <td><?=$emp[0]['gradesheet_name']?></td>
						   <th>School :</th>
						   <td><?=$emp[0]['school_name']?></td>
    					</tr>
    					<tr>
    					  <th scope="col">Dipatch No :</th>
						  <td><input type="text" name="ppc_no" id="ppc_no" class="form-control" value="<?=$emp[0]['ppc_no']?>" style="width:200px;"></td>
						   <th scope="col">Student PRN :</th>
						   <td colspan="1"><input type="text" name="student_prn" id="student_prn" class="form-control" value="<?=$emp[0]['student_prn']?>"  style="width:200px;" required></td>
    					</tr>
    					<tr>
    					  <th scope="col">Acadamic Year :</th>
						  <td>
						  	<select class="form-control" style="width: 200px;" name="academic_year" id="academic_year" required>
						  		<option value="">-Select-</option>
						  		<?php
						  			foreach ($academic_year as $key => $value) {
						  				if($emp[0]['academic_year'] == $value['academic_year']){
						  					$sel = "selected";
						  				}else{
						  					$sel = "";
						  				}
						  			?>
						  			<option value="<?=$value['academic_year']?>" <?=$sel?>><?=$value['academic_year']?></option>
						  			<?php }
						  		?>
						  	</select>
						  </td>
						   <th>Exam Year :</th>
						   <td>
						   	<select class="form-control" style="width: 200px;" name="degree_completed" id="degree_completed" required>
						  		<option value="">-Select-</option>
						  		<?php
						  			foreach ($exam_session as $key => $exses) {
						  				$ex_session = $exses['exam_month'].'-'.$exses['exam_year'].'-'.$exses['exam_id'];
						  				if($emp[0]['degree_completed'].'-'.$emp[0]['exam_id'] == $ex_session){
						  					$sel1 = "selected";
						  				}else{
						  					$sel1 = "";
						  				}
						  			?>
						  			<option value="<?=$exses['exam_month'].'-'.$exses['exam_year'].'-'.$exses['exam_id'];?>" <?=$sel1?>><?=$exses['exam_month'].'-'.$exses['exam_year']?></option>
						  			<?php }
						  		?>
						  	</select>
						   </td>
    					</tr>
    					
    					<tr>
    						<input type="hidden" name="student_id" id="student_id" value="<?=$emp[0]['stud_id']?>">
							<input type="hidden" name="erp_prn" id="erp_prn" value="<?=$emp[0]['enrollment_no']?>">
							<input type="hidden" name="stream_id" id="stream_id" value="<?=$emp[0]['admission_stream']?>">
    					  <th scope="col">Placed In :</th>
						  <td>
						  <?php 
								$yr= substr($emp[0]['enrollment_no'],0,2);
							?>
						  	<select name="placed_in" id="placed_in" class="form-control" style="width:200px;" required>
						  		<option value="">-Select-</option>
								<?php 
								//$yr= substr($emp[0]['enrollment_no'],2);
								if($yr=='16'){?>
								<option value="First Division with Distinction" <?php if($emp[0]['placed_in']=='First Division with Distinction'){ echo 'selected';}?>>First Division with Distinction</option>
						  		<option value="First Division" <?php if($emp[0]['placed_in']=='First Division'){ echo 'selected';}?>>First Division</option>
						  		<option value="Second Division" <?php if($emp[0]['placed_in']=='Second Division'){ echo 'selected';}?>>Second Division</option>	
								<?}else{
								?>
						  		<option value="First Class with Honours" <?php if($emp[0]['placed_in']=='First Class with Honours'){ echo 'selected';}?>>First Class with Honours</option>
						  		<option value="First Class with Distinction" <?php if($emp[0]['placed_in']=='First Class with Distinction'){ echo 'selected';}?>>First Class with Distinction</option>
						  		<option value="First Class" <?php if($emp[0]['placed_in']=='First Class'){ echo 'selected';}?>>First Class</option>
						  		<option value="Second Class" <?php if($emp[0]['placed_in']=='Second Class'){ echo 'selected';}?>>Second Class</option>
								<option value="Third Class" <?php if($emp[0]['placed_in']=='Third Class'){ echo 'selected';}?>>Third Class</option>
								<?php }?>
						  	</select>
						  </td>
						  <th>Issued Date :</th>
						   <td><input type="text" name="issued_date" id="issued_date" class="form-control" value="<?php if(!empty($emp[0]['issued_date'])){ echo date('d/m/Y', strtotime($emp[0]['issued_date']));}?>" style="width:200px;" readonly="true"></td>
						  
    					</tr>
						<tr>
							<th>GPA</th>
							<td><input type="text" name="sem1_gpa" id="sem1_gpa" class="form-control" value="<?php if(!empty($emp[0]['sem1_gpa'])){ echo $emp[0]['sem1_gpa'];}?>" style="width:80px;" required placeholder="SEM-1"></td><td>
							<input type="text" name="sem2_gpa" id="sem2_gpa" class="form-control" value="<?php if(!empty($emp[0]['sem2_gpa'])){ echo $emp[0]['sem2_gpa'];}?>" style="width:80px;" required placeholder="SEM-2"></td><td>
							<input type="text" name="sem3_gpa" id="sem3_gpa" class="form-control" value="<?php if(!empty($emp[0]['sem3_gpa'])){ echo $emp[0]['sem3_gpa'];}?>" style="width:80px;" required placeholder="SEM-3"></td>
							</tr>
							<tr>
							<th></th>
							<td>
							<input type="text" name="sem4_gpa" id="sem4_gpa" class="form-control" value="<?php if(!empty($emp[0]['sem4_gpa'])){ echo $emp[0]['sem4_gpa'];}?>" style="width:80px;" required placeholder="SEM-4"></td>
							
							<td>
							<input type="text" name="sem5_gpa" id="sem5_gpa" class="form-control" value="<?php if(!empty($emp[0]['sem5_gpa'])){ echo $emp[0]['sem5_gpa'];}?>" style="width:80px;"  placeholder="SEM-5"></td><td>
							<input type="text" name="sem6_gpa" id="sem6_gpa" class="form-control" value="<?php if(!empty($emp[0]['sem6_gpa'])){ echo $emp[0]['sem6_gpa'];}?>" style="width:80px;"  placeholder="SEM-6">
							
							</td>
						</tr>
						<tr>
							<th></th>
							<td>
							<input type="text" name="sem7_gpa" id="sem7_gpa" class="form-control" value="<?php if(!empty($emp[0]['sem7_gpa'])){ echo $emp[0]['sem7_gpa'];}?>" style="width:80px;"  placeholder="SEM-7"></td>
							<td>
							<input type="text" name="sem8_gpa" id="sem8_gpa" class="form-control" value="<?php if(!empty($emp[0]['sem8_gpa'])){ echo $emp[0]['sem8_gpa'];}?>" style="width:80px;"  placeholder="SEM-8">
							
							</td>
							<td>
							<input type="text" name="sem9_gpa" id="sem9_gpa" class="form-control" value="<?php if(!empty($emp[0]['sem9_gpa'])){ echo $emp[0]['sem9_gpa'];}?>" style="width:80px;"  placeholder="SEM-9">
							
							</td></tr>
						<tr> 
						<tr>
							<th></th>
							<td>
							<input type="text" name="sem10_gpa" id="sem10_gpa" class="form-control" value="<?php if(!empty($emp[0]['sem10_gpa'])){ echo $emp[0]['sem10_gpa'];}?>" style="width:80px;"  placeholder="SEM-10">							
							</td>
						</tr>
						<tr> 
							<th>CGPA</th>
							<td><input type="text" name="cgpa" id="cgpa" class="form-control" value="<?php if(!empty($emp[0]['cgpa'])){ echo $emp[0]['cgpa'];}?>" style="width:80px;"  placeholder="CGPA" required></td>
							</tr>
    					<tr>
    						<?php if(!empty($emp[0]['placed_in'])){?>
    							<input type="hidden" name="updateflag" id="update_flag" value="<?=$emp[0]['provcert_id']?>">
    					  <td colspan="4" align="center"><input type="submit" name="update" id="btn_update" value="Update" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;<a href="<?=base_url()?>Certificate/provisional/"><input type="button" class="btn btn-primary" value="Cancle"></a></td>
    					<?php }else{ ?>
    							<td colspan="4" align="center"><input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary"></td>
								
    					<?php }?>
    					</tr>
						</table>
						</div>
						</div>
					
						</div>
						<form>
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


$(document).ready(function () {
	$('.numbersOnly').keyup(function () {
		if (this.value != this.value.replace(/[^A-B0-9\.]/g, '')) {
		   this.value = this.value.replace(/[^A-B0-9\.]/g, '');
		}
	});
	$('#issued_date').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
	$("#prov_form").submit(function(e){
    	e.preventDefault();
    	//alert("inside");
    	if(confirm("Are you sure to submit the PPC Form?")){
		  var student_id = $("#student_id").val();
		  var erp_prn = $("#erp_prn").val();
		  var student_prn = $("#student_prn").val();
		  var academic_year = $("#academic_year").val();
		  var degree_completed	 = $("#degree_completed	").val();
		  var stream_id = $("#stream_id").val();
		  var issued_date = $("#issued_date").val();
		  var placed_in = $("#placed_in").val();
		  var ppc_no = $("#ppc_no").val();
		  var sem1_gpa = $("#sem1_gpa").val();
		  var sem2_gpa = $("#sem2_gpa").val();
		  var sem3_gpa = $("#sem3_gpa").val();
		  var sem4_gpa = $("#sem4_gpa").val();
		  var sem5_gpa = $("#sem5_gpa").val();
		  var sem6_gpa = $("#sem6_gpa").val();
		   var sem7_gpa = $("#sem7_gpa").val();
		    var sem8_gpa = $("#sem8_gpa").val();
			 var sem9_gpa = $("#sem9_gpa").val();
			  var sem10_gpa = $("#sem10_gpa").val();
		  var cgpa = $("#cgpa").val();
		  var update_flag = $("#update_flag").val();
		  //alert(update_flag);
		  if(typeof update_flag === "undefined"){
		  	var action_var ='add_provisional_form';
		  	var sus = 'submitted';
		  }else{
		  	var action_var ='update_provisional_form';
		  	var sus = 'updated';
		  }

		  if (student_id) {
			$.ajax({
			  type: 'POST',
			  url: '<?= base_url() ?>Certificate/'+action_var,
			  data: {student_id:student_id,erp_prn:erp_prn,student_prn:student_prn,academic_year:academic_year,degree_completed:degree_completed,stream_id:stream_id,issued_date:issued_date,placed_in:placed_in,ppc_no:ppc_no,provcert_id:update_flag,sem1_gpa:sem1_gpa,sem2_gpa:sem2_gpa,sem3_gpa:sem3_gpa,sem4_gpa:sem4_gpa,sem5_gpa:sem5_gpa,sem6_gpa:sem6_gpa,sem7_gpa:sem7_gpa,sem8_gpa:sem8_gpa,sem9_gpa:sem9_gpa,sem10_gpa:sem10_gpa,cgpa:cgpa},
			  success: function (data) {
				//alert(data);
				if(data=='SUCCESS'){					
					alert("PPC Form "+sus+" successfully.");
					if(typeof update_flag === "undefined"){					
					window.location.href = '<?= base_url() ?>Certificate/provisional/';
					}else{
						location.reload();
					}
				}else{
					alert("Problem while Adding form...");
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