<script>    
    var base_url = '<?=base_url();?>';
	function load_streams(type){
                   // alert(type);                    
		$.ajax({
			'url' : base_url + '/Examination/load_streams',
			'type' : 'POST', //the way you want to send data to your URL
			'data' : {'course' : type},
			'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
				var container = $('#semest'); //jquery selector (get element by id)
				if(data){
				 //   alert(data);
					//alert("Marks should be less than maximum marks");
					//$("#"+type).val('');
					container.html(data);
				}
			}
		});
	}
$(document).ready(function(){
	var exam_id = $("#exam_session").val();
	//alert(exam_id);
	if (exam_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Exam_timetable/load_examttschools',
				data: 'exam_id=' + exam_id,
				success: function (html) {
					//alert(html);
					$('#school_code').html(html);
					
				}
			});
		}		   
	$('#school_code').on('change', function () {	
		var school_code = $(this).val();
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Exam_timetable/load_examttcourses',
				data: {exam_id:exam_id,school_code:school_code},
				success: function (html) {
					//alert(html);
					$('#admission-course').html(html);
				}
			});
		} else {
			$('#admission-course').html('<option value="">Select course first</option>');
		}
	});  
// edit
var school_code = '<?=$school_code?>';
var examid ='<?=$exam_id?>';
//alert(school_code);
	if (examid) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Exam_timetable/load_examttschools',
				data: 'exam_id=' + examid,
				success: function (html) {
					$('#school_code').html(html);
					$("#school_code option[value='"+school_code+"']").attr("selected", "selected");
				}
			});
		}	
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Exam_timetable/load_examttcourses',
				data: {exam_id:examid,school_code:school_code},
				success: function (html) {
					//alert(html);
					var course_id = '<?=$admissioncourse?>';
					$('#admission-course').html(html);
					$("#admission-course option[value='" + course_id + "']").attr("selected", "selected");
				}
			});
		} else {
			
			$('#admission-course').html('<option value="">Select course first</option>');
		}	
		//load streams
		$('#admission-course').on('change', function () {	
		var admission_course = $("#admission-course").val();
		var school_code = $("#school_code").val();
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Exam_timetable/load_examttstreams',
				data: {exam_id:exam_id,school_code:school_code,course_id:admission_course},
				success: function (html) {
					//alert(html);
					$('#stream_id').html(html);
				}
			});
		} else {
			$('#stream_id').html('<option value="">Select course first</option>');
		}
	}); 
	$('#stream_id').on('change', function () {	
		var stream_id = $("#stream_id").val();
		if (stream_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Exam_timetable/load_examttsemester',
				data: {exam_id:exam_id,stream_id:stream_id},
				success: function (html) {
					//alert(html);
					$('#semester').html(html);
				}
			});
		} else {
			$('#semester').html('<option value="">Select Stream first</option>');
		}
	}); 	
	// edit
var admission_course = '<?=$admissioncourse?>';
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Exam_timetable/load_examttstreams',
				data: {exam_id:examid,school_code:school_code,course_id:admission_course},
				success: function (html) {
					//alert(html);
					var stream_id = '<?=$stream?>';
					$('#stream_id').html(html);
					$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
				}
			});
		} else {
			
			$('#stream_id').html('<option value="">Select course first</option>');
		}
var stream = '<?=$stream?>';
		if (stream) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Exam_timetable/load_examttsemester',
				data: {exam_id:examid,stream_id:stream},
				success: function (html) {
					//alert(html);
					var semester = '<?=$semester?>';
					$('#semester').html(html);
					$("#semester option[value='" + semester + "']").attr("selected", "selected");
				}
			});
		}		
});
</script>
<?php 
if(isset($role_id) && $role_id==1 ){
?>
<style>
	.table{width: 150%;}
	table{max-width: 150%;}
</style>									
<?php }else{ ?>
	<style>
	table.dataTable{width: 210%;}</style>
<?php }?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Examination</a></li>
        <li class="active"><a href="#">Time Table</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;View Exam Time table</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">        
                    <div class="visible-xs clearfix form-group-margin"></div>

                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">
                            <form method="post">
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
							 <div class="col-sm-2">
                                <select name="exam_session" id="exam_session" class="form-control" required>
								<!--option value="">Select Exam Session</option-->
                                  <?php

foreach ($exam_session as $exsession) {
	$exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'];
	$exam_sess_val =$exsession['exam_id'];
    if ($exam_sess_val == $_POST['exam_session']) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="'.$exam_sess_val.'">' .$exam_sess.'</option>';
}
?></select>
                              </div>
							 
							<div class="col-sm-2">
                                <select name="school_code" id="school_code" class="form-control" required>
                                 <option value="">Select School</option>
                                  <option value="0">All School</option>
                                  <?php
/*foreach ($schools as $sch) {
    if ($sch['school_code'] == $school_code) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $sch['school_code'] . '"' . $sel . '>' . $sch['school_short_name'] . '</option>';
}*/
?></select>
                              </div>
                              <div class="col-sm-2">
                                <select name="admission-course" id="admission-course" class="form-control" required>
                                 <option value="">Select Course</option>
                                  <option value="0">All Courses</option>
                                  </select>
                              </div>
                             
                            <!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
                              <div class="col-sm-2" id="semest">
                                <select name="admission-branch" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                                  </select>
                              </div>
                              <div class="col-sm-2" id="">
                                <select name="semester" id="semester" class="form-control" required>
                                  <option value="">Select Semester</option>
                                  </select>
                             </div>
							 <div class="col-sm-2 pull-right" id="semest">
								 <input type="submit" id="" class="btn btn-primary btn-labeled pull-right" value="Search" > 
								</div>
                              
                             <!--<div class="col-sm-3" id="semest">
                               <a href="<?=base_url()?>Ums_admission/generateallpdfs">  <input type="button" id="" class="btn btn-primary btn-labeled" value="Generate All" > </a>
                            </div>-->
                            </div>
                            </form>
                        </span>
                        <div class="holder1"></div>
                </div>

            <div class="table-info panel-body"  style="overflow:scroll;height:800px;">  
			<?php 
			$role_id=$this->session->userdata('role_id');
			//if(isset($role_id) && $role_id==1 ){?>
                     
			
				<?php// }?>
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" style="<?=$tbstyle?>">    

		<?php 	
					if($_POST){
						//echo "<pre>";
						//print_r($strms);//exit;
						$i=0;
				foreach($strms as $strm){
				?>	
<table cellpadding="0" cellspacing="0" border="1" width="100%" class="table table-bordered">
<tr>
<td align="left" width="15%"><strong>Department :</strong></td>
<td><?=$strm['stream_name']?></td>
<td align="left" width="10%"><strong>Batches :</strong></td>
<td colspan='2'><?php $str_bth=''; foreach($strm['batches'] as $bt){ $str_bth .=$bt['batch'].', ';} echo rtrim($str_bth,', '); ?></td>

</tr> 

<tr>
<td><strong>F.N/A.N :</strong></td>
<td colspan='4'><?php $str_slot=''; foreach($strm['slots'] as $st){
	$str_slot .= $st['from_time'].' - '.$st['to_time'].', ';
	}
	echo rtrim($str_slot,', ');
	?></td>

</tr> 

</table> 
      
<table border="0" class="table table-bordered" >
<thead>
    <tr>
	<th>Sem</th>
	<th align="left">Course Code & Name</th>
	<th>Date</th>
	<th>Session</th>
    </tr>
</thead>
<tbody>
<?php

	foreach($strm['subjects'] as $sb){
		if($sb['from_time']=='09:30:00' && $sb['to_time']=='12:30:00'){
			$ses = 'F.N';
		}else{
			$ses = 'A.N';
		}
?>

<tr>
	<td align="left"><?=$sb['semester']?></td>
	<td align="left"><?=$sb['subject_code'].'-'.$sb['subject_name'];?></td>
	<td align="left"><?=date('d-m-Y',strtotime($sb['date']))?></td>	
	<td align="left"><?=$ses;?></td>	
</tr>
<?php 
	}
	$i++;
				}
					?>
					</tbody>
</table> 
					<a href="<?=base_url($currentModule.'/generetPdf')?>/<?=$school_code?>/<?=$admissioncourse?>/<?=$stream?>/<?=$semester?>/<?=$exam_id?>"><button class="btn btn-primary">Download PDF</button></a>
					<div class="col-sm-2">  </div>
					
                    <?php } ?>
                </div>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>