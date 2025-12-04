<?php
//$basepath ="http://www.sandipuniversity.com/sandipUniversity_final/";
//$basepath ="http://www.sandipuniversity.com/";
$basepath = base_url();
$role_id = $this->session->userdata("role_id");
//print_r($frmno);exit;
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
	var max_marks= $("#max_marks").val(); //parseInt('<?=$me[0]['max_marks']?>')
	var marks = parseInt($("#"+id).val());

	if(marks > max_marks){
		alert("Please enter min marks than Max Marks");
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
		$('.numbersOnly').keyup(function () {
		if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
		   this.value = this.value.replace(/[^0-9\.]/g, '');
		}
	});
});
</script>
</head>

<body>

<div class="container panel-body">
  <div class="row main-wrapper head-add">
 
	<form name="testdetails" id="testdetails" method="post" action="<?=base_url($currentModule)."/updateCIAStudMarks/"?>" >

	
	<div class="col-lg-12 np detail-heading" style="text-align:center;padding-top:15px;"><h2>Sandip University</h2></div>
	<table class="table table-bordered" border=1 cellspacing ="5px" cellpadding="5px" width="100%">
	    <tr>
	        <td><b>Exam Session:</b> <?=$me[0]['exam_month'].' '.$me[0]['exam_year'] ?></td><td><b>Stream:</b> <?=$StreamSrtName[0]['stream_short_name']?></td><td><b>Semester:</b> <?=$me[0]['semester']?></td><td><b>Date:</b> &nbsp;<input type="text" style="width:130px" class="form-control1" name="markentrydate" id="markentrydate" value="<?php if($me[0]['marks_entry_date'] !='0000-00-00' && $me[0]['marks_entry_date'] !=''){ echo date('d/m/Y', strtotime($me[0]['marks_entry_date']));}?>" required></td>
	    </tr>
	    
	    <tr>
	        <td><b>Subject Code:</b> <?=strtoupper($ut[0]['subject_code']);?></td><td colspan=2><b>Subject Name:</b> <?=strtoupper($ut[0]['subject_name']);?></td><td><b>Max marks:</b> <input type="text" class="form-control1 numbersOnly" style="width:70px" name="max_marks" id="max_marks" maxlength="3" value="<?php if($me[0]['max_marks'] !=''){ echo $me[0]['max_marks'];}?>" required > &nbsp;&nbsp;&nbsp;<b>Min marks:</b> <?php if($ut[0]['internal_min_for_pass'] !=''){ echo $ut[0]['internal_min_for_pass'];}?></td>
	    </tr>
	</table>
		<!--div class="col-md-12">
			<div class="col-md-2">Exam Session:</div><div class="col-md-2 pull-left"> <?=$me[0]['exam_month'].' '.$me[0]['exam_year'] ?></div>
			<div class="col-md-1">Stream:</div><div class="col-md-3"> <?=$StreamSrtName[0]['stream_short_name']?></div>
			<div class="col-md-1">Date:</div><div class="col-md-2"> <input type="text" class="form-control" name="markentrydate" id="markentrydate" value="<?php if($me[0]['marks_entry_date'] !='0000-00-00' && $me[0]['marks_entry_date'] !=''){ echo date('d/m/Y', strtotime($me[0]['marks_entry_date']));}?>"required></div>
		</div>
		<div class="clearfix">&nbsp;</div>
	<div class="col-md-12">
		<div class="col-md-2">Subject: </div><div class="col-md-2 pull-left"><?=$ut[0]['subject_short_name']?></div>		
		<div class="col-md-1">Sem: </div><div class="col-md-3"><?=$me[0]['semester']?></div>
		<div class="col-md-1">Max marks:</div><div class="col-md-2"> <input type="text" class="form-control numbersOnly" name="max_marks" id="max_marks" value="<?php if($me[0]['max_marks'] !=''){ echo $me[0]['max_marks'];}?>" required readonly></div>
	</div>
	<div class="clearfix">&nbsp;</div-->
    <div class="col-lg-12 heading-1">
      <center><h4><b><?=$me[0]['marks_type']?> Mark Entry</h4></b></center>
    </div>
  </div>
  <input type="hidden" name="m_id" value="<?=$me_id?>">
  <div class="row detail-bg" style="overflow-x:scroll;height:600px; overflow-y:scroll;width:100%;">
    <div class="col-lg-12">
	
	<input type="hidden" name="sub_details" value="<?=$sub_details?>">
	<table border="1" class="table table-bordered" align="left">
            <tr>
            <td valign="top" align="left">
	<table  border="1" class="table table-bordered" width="200">
            <tr>   
			<th style="border-top:1px solid #000;width: 3%;" align="left">S.No</th>
			<th style="border-top:1px solid #000;width: 7%;" align="left">Stud. Name</th>			
            <th style="border-top:1px solid #000;width: 11%;" align="left">PRN</th>   
			<th style="border-top:1px solid #000;width: 7%;" align="left">Marks</th>
			<th style='border-top:1px solid #000;width: 7%;' align='left'>Attendance(100%)</th>
            </tr>
			
             <?php
			$count=0;
		$i=1;
		//echo "<pre>";print_r($mrks);
				if(!empty($mrks)){
					foreach($mrks as $stud){
						$stud_name=$stud['first_name'].'. '.$stud['middle_name'][0].'. '.$stud['last_name'];
						if($count ==25) {
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
            <tr>
            <td><?=$i?></td>
			<td><?=$stud_name?></td>
            <td><?=$stud['enrollment_no']?></td>
            <td>
            	<input type="text" name="marks_obtained[]" id="mrk_<?=$stud['stud_id']?>" style="width: 50px;" onkeyup="inwords<?=$stud['stud_id']?>.innerHTML=convertNumberToWords(this.value)" value="<?=$stud['cia_marks']?>" onBlur="return check_maxmarks(this.id);" class="form-control" required style="width:100px">
            </td>
            <td>
            	<input type="text" name="attdance_marks[]" id="attd_mrk_<?=$stud['stud_id']?>" class="form-control" style="width: 50px;" class="numbersOnly" maxlength="3" value="<?=$stud['attendance_marks']?>" onBlur="return check_max_attmarks(this.id);" required>
            </td>
			<input type="hidden" name="stud_id[]" value="<?=$stud['stud_id']?>">
			<input type="hidden" name="enrollement_no[]" value="<?=$stud['enrollment_no']?>">
			<input type="hidden" name="mrk_id[]" value="<?=$stud['cia_id']?>">
            </tr>
			<?php 
			$i++;
			$count++;
				}
				}else{
					//echo "<tr><td colspan=4>No data found.</td></tr>";
				}
			?>


            </table>
			</td>
            
            
            
            
            

            </tr>
            
             
            </table>
			
	
	<?php
	if($me[0]['approved_by'] ==''){
	?>	

	<?php
	}	
	if(($me[0]['verified_by'] =='') && ($role_id =='21' || $role_id =='7' || $role_id =='12' || $role_id =='13' || $role_id =='3' || $role_id =='20')){
	?>
	<input type="submit" name="save" value="Update" class="btn btn-primary">
	<a href="<?=base_url($currentModule."/veryfyCIAStatus/".base64_encode($sub_details).'/'.base64_encode($me_id))?>"><span class="btn btn-primary">Forward to HOD/Dean</span></a> 
	<?php
	}if($role_id =='12' || $role_id =='15' || $role_id =='6' || $role_id =='20'|| $role_id =='44'){
	?>
	<input type="submit" name="save" value="Update" class="btn btn-primary">
	<a href="<?=base_url($currentModule."/approveCIAStatus/".base64_encode($sub_details).'/'.base64_encode($me_id))?>"><span class="btn btn-primary">Approve</span></a>
	<?php }?>
	</form>
    </div>
  </div>
  
  
</div>


<!--Bootstrap core JavaScript-->

<!--<script src="https://cdn.jsdelivr.net/jsbarcode/3.5.8/barcodes/JsBarcode.code128.min.js"></script>-->
</body>
</html>