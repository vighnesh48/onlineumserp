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
<link href="<?php echo $basepath?>assets/css/bootstrap.min.css" rel="stylesheet">

<style>
@font-face {
    font-family:'Verdana';
    src: url('Verdana.eot');
	src: url('Verdana.eot?#iefix') format('embedded-opentype'),
		url('Verdana.woff2') format('woff2'),
		url('Verdana.woff') format('woff'),
		url('Verdana.svg#Verdana') format('svg');
    font-weight: 400;
    font-style: normal;
    font-stretch: normal;
    unicode-range: U+0020-F009;
}
.container {
	width: 800px;
}
.main-wrapper {
	background: #f4f4f4;
	padding-top: 60px;
	font-size: 10px
}
.heading-1 {
	background: #CCC;
	text-align: center
}
.heading-1 h4 {
	font-size: 15px;
	text-transform: uppercase;
	margin-top: 5px;
	margin-bottom: 5px;
	font-weight: bold;
}
p {
	text-align: inherit
}
.head-add {
	font-size: 13px
}
.detail-bg {
	background: #eee;
}
.detail-bg table tr td {
	font-size: 12px!important;
	height:25px;
}
.np {
	padding: 0;
}
.detail-heading {
	background: red;
	color: #fff;
	margin: 0px;
	font-size: 15px;
	padding: 5px 0 5px 15px;
	text-transform: uppercase;
	font-weight: 600;
}
.table th{font-size:12px;}
.pb{padding-bottom:10px;}
.bb{border-bottom:1px solid #ddd}
.pt{padding-top:10px;line-height: 23px}
ul {padding-left:15px;margin-top:10px;}
</style>
</head>

<body>
<div class="container">
  <div class="row main-wrapper head-add">
	<a href="<?=base_url($currentModule."/index/".$subj_Id)?>">
		<button type="button" class="btn btn-primary ">Back</button>
	</a><br><br>
	<div class="col-lg-12 np detail-heading" style="text-align:center"><h2>Sandip University</h2></div>
	<div class="clearfix">&nbsp;</div>
		<div class="col-md-12">
			<div class="col-md-2">Test:</div><div class="col-md-2"> <?=$ut[0]['test_no']?></div>
			<div class="col-md-2"></div><div class="col-md-2"></div>		
			<div class="col-md-1">Subject:</div><div class="col-md-3"> <?=$ut[0][subject_short_name]?></div>
		</div>
	<div class="col-md-12">
		<div class="col-md-1">Date: </div><div class="col-md-3"><?=date('d-m-Y', strtotime($ut[0]['test_date']))?></div>
		<div class="col-md-1">Stream: </div><div class="col-md-3"><?=$ut[0]['stream_short_name']?></div>
		<div class="col-md-2">Semester: </div><div class="col-md-2"><?=$ut[0]['semester']?></div>
	</div>
	<div class="clearfix">&nbsp;</div>
    <div class="col-lg-12 heading-1">
      <h4>Student List 2017-18</h4>
    </div>
  </div>
  
  <div class="row detail-bg">
    <div class="col-lg-12">
	<?php
	if(!empty($td)){?>
	<form name="testdetails" id="testdetails" method="post" action="<?=base_url($currentModule)."/updateTestDetails/"?>">
	<?php }?>
	<form name="testdetails" id="testdetails" method="post" action="<?=base_url($currentModule)."/submitTestDetails/"?>">
	<input type="hidden" name="unit_test_id" id="unit_test_id" value="<?=$ut[0]['unit_test_id']?>">
	<input type="hidden" name="subjectId" id="subjectId" value="<?=$ut[0]['subject_id']?>">
	<input type="hidden" name="academic_year" id="academic_year" value="<?=$ut[0]['academic_year']?>">
	<div class="alrtmsg" id="alrtmsg" style="color:green"></div>
    <table class="table table-bordered" style="WIDTH:400%">
	  <tr>
	    <th scope="col">SR.N</th>
		<th scope="col">PRN.</th>
		<th scope="col">Name</th>
		<th scope="col">Marks</th>
	  </tr>
		<?php 
		$srNo=1;
		//echo "<pre>";
		//print_r($td);
		$i=0;
			foreach($td as $stud){
		?>
	  <tr>
	    <td><?=$srNo;?></td>  
		<td><?=$stud['enrollment_no_new']?></td>
		<td><?=$stud['first_name']?> <?=$stud['last_name']?></td>
		 <td><input type="text" name="marks_obtained[]" id="<?=$stud['stud_id']?>" class="numbersOnly"  maxlength="3" value="<?=$td[$i]['marks_obtained']?>" onblur="updateMarks(this.id)" required></td>
		 <input type="hidden" name="stud_id" id="Stud_<?=$stud['stud_id']?>" value="<?=$stud['stud_id']?>">
		 <input type="hidden" name="enrollement_no[]" value="<?=$stud['enrollement_no']?>">
	  </tr>
	  <?php 
		$i++;
		$srNo++;
		}
		?>

	</table>
	<!--input type="submit" name="save" value="Save" class="btn btn-primary"-->
	</form>
    </div>
  </div>
  
  
</div>


<!--Bootstrap core JavaScript--> 
<script src="http://www.sandipuniversity.com/js/jquery.js"></script> 
<script src="http://www.sandipuniversity.com/js/bootstrap.min.js"></script>
<script>
$('.numbersOnly').keyup(function () {
		if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
		   this.value = this.value.replace(/[^0-9\.]/g, '');
		}
	});
function updateMarks(tmarks) {
		
		var student_id = tmarks;
		var stud_marks = $("#"+tmarks).val();
		var subjectId = $("#subjectId").val();
		var unit_test_id =$("#unit_test_id").val();
		var academic_year =$("#academic_year").val();
		//alert(subjectId);
			if (student_id !='' && student_id !=0) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Unittest/updateStudMarks',
					data: {studId:student_id,stud_marks:stud_marks,subjectId:subjectId,unit_test_id:unit_test_id,academic_year:academic_year},
					success: function (data1) {
						//alert(data1);
							if(data1=='SUCCESS'){
							    //alert("kjh");
								$('#alrtmsg').html('Marks Updated Successfully');
							}
							else{
								alert("Problem while updating Marks.");	
								return true;
							}
					}
				});
			} else {
				alert("test");
			}
		}
		</script>
<!--<script src="https://cdn.jsdelivr.net/jsbarcode/3.5.8/barcodes/JsBarcode.code128.min.js"></script>-->
</body>
</html>