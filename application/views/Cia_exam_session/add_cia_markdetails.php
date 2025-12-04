	<?php
	//$basepath ="http://www.sandipuniversity.com/sandipUniversity_final/";
	//$basepath ="http://www.sandipuniversity.com/";
	$basepath = base_url();
	//print_r($frmno);exit;

		if($batch_details !=''){
			$btdet = explode('-', $batch_details);
			if(!empty($btdet[2]) && $btdet[2] !=0){
				$bthdetails = $btdet[1].'-'.$btdet[2];
			}else{
				$bthdetails = $btdet[1];				
			}
		}
	?>

	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sandip University</title>
	<script src="<?=site_url()?>assets/javascripts/numbertowords.js" type="text/javascript"></script>

	<script>
	function  check_maxmarks(id){
		//alert(id);
		var max_marks= $("#max_marks").val();
		var max_marks1 = parseInt(max_marks);
		//alert(max_marks);
		if(max_marks==''){
			alert("Please enter max marks first.");
			$("#"+id).val('');
			$("#max_marks").focus();
		}
		var marks = parseInt($("#"+id).val());

		if(marks > max_marks1){
			alert("Please enter marks less than Max Marks");
			$("#"+id).val('');
			$("#"+id).focus();
			
			return false;
			
		}else{
			return true;
		}
		
		
	}
		function  check_max_attmarks(id){
		//alert(id);
		var max_marks= 100;
		var max_marks1 = parseInt(max_marks);

		var marks = parseInt($("#"+id).val());

		if(marks > max_marks1){
			alert("Please enter marks less than 100 Marks");
			$("#"+id).val('');
			$("#"+id).focus();
			
			return false;
			
		}else{
			return true;
		}
		
		
	}
	 $(document).ready(function()
	{
		$('#markentrydate').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
	/*	$('.numbersOnly').keyup(function () {
			if (this.value != this.value.replace(/[^A-B0-9\.]/g, '')) {
			   this.value = this.value.replace(/[^A-B0-9\.]/g, '');
			}
		});*/
	}); 

	document.addEventListener('DOMContentLoaded', function() {
    // Apply the same validation to both input types
    document.querySelectorAll('.numbersOnly').forEach(function(input) {
        input.addEventListener('keypress', function(event) {
            // Allow only digits (0-9), 'A', and 'B'
            if (!(event.which >= 48 && event.which <= 57) && event.which !== 65 && event.which !== 66) {
                event.preventDefault();
            }
        });
        
        input.addEventListener('input', function() {
            // Remove non-digit, non-'A', and non-'B' characters
            this.value = this.value.replace(/[^0-9AB]/g, '');
        });
    });
});
	    // Function to check and set attendance marks
		function check_max_attmarks(inputId) {
        var input = document.getElementById(inputId);
        var value = parseInt(input.value, 10);

        if (value >= 90 && value <= 100) {
            input.value = 5;
        } else if (value >= 85 && value <= 89) {
            input.value = 4;
        } else if (value >= 80 && value <= 84) {
            input.value = 3;
        } else {
            input.value = ''; // Clear the value if it does not match any range
        }
    }

    // Event listener to restrict input to numbers only
    document.querySelectorAll('#attd_mrk_<?=$allexamStudent['stud_id']?>').forEach(function(element) {
        element.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
	</script>





	</head>

	<body>

	<div class="container panel-body">
	  <div class="row main-wrapper head-add">
		<?php
		if(!empty($td)){?>
		<form name="testdetails" id="testdetails" method="post" action="<?=base_url($currentModule)."/updateCIATestDetails/"?>" >
		<?php }?>
		<form name="testdetails" id="testdetails" method="post" action="<?=base_url($currentModule)."/submitCIAMarkDetails/"?>" >
		<div class="col-lg-12 np detail-heading" style="text-align:center;padding-top:15px;"><h2>Sandip University</h2></div>
		<table class="table table-bordered" border=1 cellspacing ="5px" cellpadding="5px" width="100%">
		    <tr>
		        <td><b>Exam Session:</b> <?=substr($examsession, 0, -3);?></td>
				<td><b>Stream:</b> <?=$StreamSrtName[0]['stream_short_name']?></td>
				<td><b>Semester/Batch:</b> <?=$ut[0]['semester']?> /<?=$bthdetails;?> </td>
				<td><b>Date:</b> &nbsp;<input type="text" style="width:130px" class="form-control1" name="markentrydate" id="markentrydate" required></td>
		    </tr>
		    
		    <tr>
		        <td><b>Subject Code:</b> <?= ucwords($ut[0]['subject_code']); ?></td>
				<td colspan = 2 ><b>Subject Name:</b> <?= ucwords($ut[0]['subject_name']); ?></td>
				<td>
					<b>Max Marks:</b>
						<input type="text" class="form-control1 numbersOnly" style="width:50px" name="max_marks" id="max_marks" value="<?php echo $max_marks; ?>" maxlength="3" required readonly> &nbsp;&nbsp;&nbsp; 
						<?php //echo $ut[0]['internal_min_for_pass'];?>
				</td>
		    </tr>
		</table>
		<?php // print_r($this->data['cia_exam_type']); ?>

			<!--div class="col-md-12">
				<div class="col-md-2">Exam Session:</div><div class="col-md-2 pull-left"> <?=$examsession?></div>
				<div class="col-md-1">Stream:</div><div class="col-md-3"> <?=$StreamSrtName[0]['stream_short_name']?></div>
				<div class="col-md-1">Date:</div><div class="col-md-2"> <input type="text" class="form-control" name="markentrydate" id="markentrydate" required></div>
			</div>
			<div class="clearfix">&nbsp;</div>
		<div class="col-md-12">
			<div class="col-md-2">Subject: </div><div class="col-md-2 pull-left"><?=$ut[0]['subject_short_name']?></div>		
			<div class="col-md-1">Sem: </div><div class="col-md-3"><?=$ut[0]['semester']?></div>
			<div class="col-md-1">Max marks:</div><div class="col-md-2"> <input type="text" class="form-control numbersOnly" name="max_marks" id="max_marks" maxlength="3" required></div>
		</div>
		<div class="clearfix">&nbsp;</div-->
	    <div class="col-lg-12 heading-1">
	      <center><h4><b><?=$exam_type?> Mark Entry </b></h4></center><span class="pull-left" style="color:red;">Note - For Absent entries of CIA or Attendance, Please enter AB (Capital AB).</span>
	    </div>
	  </div>
	  
	  <div class="row detail-bg">
	    <div class="col-lg-12">

		<input type="hidden" name="sub_details" value="<?=$sub_details?>">
		<input type="hidden" name="division" value="<?=$btdet[1]?>">
		<input type="hidden" name="batch" value="<?=$btdet[2]?>">
		<div class="col-lg-12" style="overflow-x:scroll;height:600px;">

		<table border="1" class="table table-bordered" align="left">
	            <tr>
	            <td valign="top" align="left">
		<table  border="1" class="table table-bordered" width="200">
	            <tr>   
				<th style="border-top:1px solid #000;width: 3%;" align="left">S.No</th> 
				<th style="border-top:1px solid #000;width: 7%;" align="left">Stud. Name</th>   				
	            <th style="border-top:1px solid #000;width: 11%;" align="left">PRN</th>  
				
				<?php if($this->data['cia_exam_type'] !='attendance'){ ?>

				<th style="border-top:1px solid #000;width: 7%;" align="left">Marks</th>	

				<?php } if($this->data['cia_exam_type'] =='attendance'){ ?>
	
				<th style='border-top:1px solid #000;width: 7%;' align='left'>Attendance(100%)</th>

				<?php } ?>
	            </tr>
				
	             <?php
				$count=0;
			$i=1;
					if(!empty($allexamStudent)){
							foreach($allexamStudent as $batchstud){
								$stud_batch_id[]= $batchstud['stud_id']; 
							}
					}
									//echo "<pre>";
									//print_r($stud_batch_id);

					if(!empty($allexamStudent)){
						foreach($allexamStudent as $stud){
							if($stud['is_detained']=='Y'){
								$is_detained="disabled";
							}else{
								$is_detained="";
							}
							$stud_name=$stud['first_name'].'. '.$stud['middle_name'][0].'. '.$stud['last_name'];
							//echo $stud['stud_id'];echo "<br>";
							//if (in_array($stud['stud_id'], $stud_batch_id)){
								if($count ==30) {
						                $count = 0;
						                echo "</table></td><td valign='top'><table class='table table-bordered' border='1'><tr><th style='border-top:1px solid #000;width: 3%;' align='left'>S.No</th> 
										<th style='border-top:1px solid #000;width: 7%;' align='left'>Stud. Name</th>  
						            <th style='border-top:1px solid #000;width: 11%;' align='left'>PRN</th>   
									<th style='border-top:1px solid #000;width: 7%;' align='left'>Marks</th>
									<th style='border-top:1px solid #000;width: 7%;' align='left'>Attendance(100%)</th></tr>
									
										";
									}
									//echo $stud['enrollment_no'];
									?>
						            <tr <?php if($stud['is_detained']=='Y'){ ?> style="color:red;" <?php }?>>
						            <td><?=$i?></td>
									<td><?=$stud['stud_name']?></td>
						            <td><?=$stud['enrollment_no']?><input type="hidden" name="stream_id[]" value="<?=$stud['admission_stream']?>" <?=$is_detained;?>></td>

									<?php if ($this->data['cia_exam_type'] != 'attendance') { ?>
										<td>
											<input type="text" name="marks_obtained[]" id="mrk_<?=$stud['stud_id']?>" 
												style="width: 50px;" class="numbersOnly" maxlength="3" 
												value="<?php if ($ut[0]['internal_max'] == 0) { echo $ut[0]['internal_max']; } ?>" 
												onBlur="return check_maxmarks(this.id);" <?=$is_detained;?> 
												pattern="[0-9AB]{0,3}" title="Only numeric values and capital letters 'A' or 'B' are allowed" required>
										</td>
									<?php } if ($this->data['cia_exam_type'] == 'attendance') { ?>
										<td>
											<input type="text" name="attdance_marks[]" id="attd_mrk_<?=$stud['stud_id']?>" 
												style="width: 50px;" class="numbersOnly" maxlength="3" value="" 
												onBlur="return check_max_attmarks(this.id);" <?=$is_detained;?> 
												pattern="[0-9AB]{0,3}" title="Only numeric values and capital letters 'A' or 'B' are allowed">
										</td>
									<?php } ?>


								 <input type="hidden" name="stud_id[]" value="<?=$stud['stud_id']?>" <?=$is_detained;?>>
								 <input type="hidden" name="enrollement_no[]" value="<?=$stud['enrollment_no']?>" <?=$is_detained;?>>
						            </tr>
									<?php 
									$i++;
									$count++;
								}
						//}
					}else{
						//echo "<tr><td colspan=4>No data found.</td></tr>";
					}
				?>

				
	            </table>
			</td>
	      </tr>  
			<tr><td><center><input type="submit" name="save" value="Save" class="btn btn-primary"></center></td></tr>
</table>
</div>
		<br>
		
		
		</form>
	    </div>
	  </div>
	  
	  
	</div>


	<!--Bootstrap core JavaScript-->

	<!--<script src="https://cdn.jsdelivr.net/jsbarcode/3.5.8/barcodes/JsBarcode.code128.min.js"></script>-->
	</body>
	</html>