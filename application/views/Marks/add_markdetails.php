<?php
//$basepath ="http://www.sandipuniversity.com/sandipUniversity_final/";
//$basepath ="http://www.sandipuniversity.com/";
$basepath = base_url();
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
		alert("Please enter min marks than Max Marks");
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
		if (this.value != this.value.replace(/[^A-B0-9\.]/g, '')) {
		   this.value = this.value.replace(/[^A-B0-9\.]/g, '');
		}
	});
});
</script>
<style>
.table-bordered > tbody > tr > th{white-space: nowrap;}
</style>
</head>

<body>

<div class="xcontainer xpanel-body" id="content-wrapper">
  <div class="row main-wrapper head-add">
  
	<?php
	if(!empty($td)){?>
	<form name="testdetails" id="testdetails" method="post" action="<?=base_url($currentModule)."/updateTestDetails/"?>">
	<?php }?>
	<form name="testdetails" id="testdetails" method="post" action="<?=base_url($currentModule)."/submitMarkDetails/"?>">
	<div class="col-lg-12 np detail-heading" style="text-align:center;padding-top: 15px;"><h2>Sandip University</h2></div>

    <table class="table table-bordered" border=1 cellspacing ="5px" cellpadding="5px" width="100%">
	    <tr>
	        <td><b>Exam Session:</b> <?=$examsession?></td><td><b>Stream:</b> <?=$StreamSrtName[0]['stream_short_name']?></td><td><b>Semester:</b> <?=$ut[0]['semester']?></td><td><b>Date:</b> &nbsp;<input type="text" style="width:130px" class="form-control1" name="markentrydate" id="markentrydate" value="<?=date('d/m/Y');?>" required></td>
	    </tr>
	    
	    <tr>
	        <td><b>Subject Code:</b> <?=strtoupper($ut[0]['subject_code']);?></td><td colspan=2><b>Subject Name:</b> <?=strtoupper($ut[0]['subject_name']);?></td><td><b>Max marks:</b> <input type="text" class="form-control1 numbersOnly" style="width:100px" name="max_marks" id="max_marks" value="<?php if($exam_type=='TH'){ echo $ut[0]['theory_max'];}else{ echo $ut[0]['practical_max'];}?>" maxlength="3"  required></td>
	    </tr>
	</table>

  </div>
  
  <div class="row detail-bg panel-body">
      
    <div class="col-lg-12 heading-1" style="align:center;border:1">
      <center><h4><b><?php if($exam_type=='TH'){ echo "Theory";}else{ echo "Practical";}?> - Mark Entry </b></h4>
	   <span style="color:red;"><small>Note: enter</small> AB <small>for Absent Students.</small></span>
	  </center>
	 
    </div>

	<input type="hidden" name="sub_details" value="<?=$sub_details?>">
    <div class="col-lg-12" style="overflow-x:scroll;height:600px;">

	<table border="1" class="table-bordered" align="left" >
            <tr>
            <td valign="top" align="left">
	<table  border="1" class="table table-bordered" width="200">
            <tr>   
			<th style="border-top:1px solid #000;width: 3%;" align="left">S.No</th>   
			<!--th style="border-top:1px solid #000;width: 7%;" align="left">Stud. Name</th-->	
			<th style="border-top:1px solid #000;width: 11%;" align="left">PRN</th>	
			<th style="border-top:1px solid #000;width: 11%;" align="left">Barcode</th>	
			<th style="border-top:1px solid #000;width: 11%;" align="left">ABN</th>				
			<th style="border-top:1px solid #000;width: 7%;" align="left">Marks</th>
			<th style="border-top:1px solid #000;" align="left">In Words</th> 
            </tr>
			
             <?php
			$count=0;
		$i=1;
				if(!empty($allbatchStudent)){
					foreach($allbatchStudent as $stud){
					    //echo $stud['is_absent']; exit;
					    if($stud['is_absent']=='A'){
					        $is_absent_value ="AB";
					    }else{
					       $is_absent_value =$td[$i]['marks_obtained']; 
					    }
						if($stud['malpractice']=='Y'){
					        $malpractice ="<span style='color:red;'>MPC</span>";
					    }else{
					       $malpractice =''; 
					    }
						if($stud['ans_bklet_no']!=''){
					        $ans_bklet_no =$stud['ans_bklet_no'];
					    }else{
					       $ans_bklet_no ='-'; 
					    }
						
						$stud_name=$stud['first_name'].'. '.$stud['middle_name'][0].'. '.$stud['last_name'];
						if($count ==30) {
                $count = 0;
                echo "</table></td><td valign='top'><table class='table table-bordered' border='1'><tr><th style='border-top:1px solid #000;width: 3%;' align='left'>S.No</th> 
           		
            <th style='border-top:1px solid #000;width: 11%;' align='left'>PRN</th>   
            <th style='border-top:1px solid #000;width: 11%;' align='left'>Barcode</th>   
            <th style='border-top:1px solid #000;width: 11%;' align='left'>ABN</th>   
			<th style='border-top:1px solid #000;width: 7%;' align='left'>Marks</th>
			<th style='border-top:1px solid #000;' align='left'>In Words</th></tr>
				";
			}
			//echo $stud['enrollment_no'];
			?>
            <tr>
            <td><?=$i?></td>
			<!--td><?=$stud_name?></td-->
            <td><b><?=$malpractice?></b> <?=$stud['enrollment_no']?></td>
			<td><?=$stud['barcode']?></td>
			<td><?=$stud['ans_bklet_no']?></td>
            <td><input type="text" style="width: 50px;" name="marks_obtained[]" onkeyup="inwords<?=$stud['stud_id']?>.innerHTML=convertNumberToWords(this.value)" id="mrk_<?=$stud['stud_id']?>" class="<?php if($is_absent_value !='AB'){ echo "numbersOnly";}?>" maxlength="3" value="<?=$is_absent_value?>" <?php if($is_absent_value !='AB'){echo 'onBlur="return check_maxmarks(this.id);" required';}else{ echo "readonly='true'";}?> ></td>
            <td id="inwords<?=$stud['stud_id']?>"></td>
		 <input type="hidden" name="stud_id[]" value="<?=$stud['stud_id']?>">
		 <input type="hidden" name="enrollement_no[]" value="<?=$stud['enrollment_no']?>">
		 <input type="hidden" name="adm_stream[]" value="<?=$stud['admission_stream']?>">
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
	   </div>
	    <center>	<input type="submit" name="save" value="Save" class="btn btn-primary"></center>
  </div>
  </form>
  
</div>

<!--Bootstrap core JavaScript-->

<!--<script src="https://cdn.jsdelivr.net/jsbarcode/3.5.8/barcodes/JsBarcode.code128.min.js"></script>-->
</body>
</html>