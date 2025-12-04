<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<script src="<?php echo base_url('assets/javascripts').'/bootstrap-datepicker.js' ?> "></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>

<script>   
$(document).ready(function()
{
	$('#mrk_cer_date').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
});

function getExamDate(id){
	$('#'+id).datepicker( {format: 'dd/mm/yyyy',autoclose: true});
	$('#'+id).focus();
	return true;
}
    var base_url = '<?=base_url();?>';
	function load_streams(type){
                   // alert(type);
       var ex_ses = $("#exam_session").val();             
		$.ajax({
			'url' : base_url + '/Certificate/load_edstreams',
			'type' : 'POST', //the way you want to send data to your URL
			'data' : {'course' : type,ex_ses:ex_ses},
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
	var board_code = $(this).val();
			var ex_ses = $("#exam_session").val(); 
			var board_date=$("#datahidden").val(); 
			//$("#admissionbranch").val($("#stream_id option:selected" ).text());  
			if (ex_ses) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Boardvaluation/load_date',
					data: {board_code:board_code,ex_ses:ex_ses,board_date:board_date},
					success: function (newdata) {
						//alert(html);
						
						$('#board_date').html(newdata);
					//	$('#ressemester').val(newdata);
					}
				});
			} else {
				$('#board_date').html('');
				//$('#ressemester').val('');
			}
	$('#board_code').on('change', function () {
			var board_code = $(this).val();
			var ex_ses = $("#exam_session").val(); 
			var board_date=$("#datahidden").val(); 
			//$("#admissionbranch").val($("#stream_id option:selected" ).text());  
			if (ex_ses) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Boardvaluation/load_date',
					data: {board_code:board_code,ex_ses:ex_ses,board_date:board_date},
					success: function (newdata) {
						//alert(html);
						
						$('#board_date').html(newdata);
					//	$('#ressemester').val(newdata);
					}
				});
			} else {
				$('#board_date').html('');
				//$('#ressemester').val('');
			}
		});
	
	
	
	
	
	$('#exam_session').on('change', function () {	
		var exam_session = $(this).val();
		if (exam_session) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examsess_schools',
				data: 'exam_session=' + exam_session,
				success: function (html) {
					//alert(html);
					$('#school_code').html(html);
				}
			});
		} else {
			$('#school_code').html('<option value="">Select exam session first</option>');
		}
	}); 
	var exam_session = '<?=$exam?>';
		//alert(exam_session);
		if (exam_session) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examsess_schools',
				data: 'exam_session=' + exam_session,
				success: function (html) {
					var schoolcode = '<?=$school_code?>';
					$('#school_code').html(html);
					$("#school_code option[value='" + schoolcode + "']").attr("selected", "selected");
				}
			});
		} else {
			$('#school_code').html('<option value="">Select exam session first</option>');
		}	
		
	$('#school_code').on('change', function () {	
		var school_code = $(this).val();
		var ex_ses = $("#exam_session").val();
		//schoolname =$("#school_code option:selected" ).text();
		$("#schoolname").val($("#school_code option:selected" ).text());
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Certificate/load_edschools',
				data: {school_code:school_code,ex_ses:ex_ses},
				success: function (html) {
					//alert(html);
					$('#admission_course').html(html);
				}
			});
		} else {
			$('#admission_course').html('<option value="">Select course first</option>');
		}
	});  
// edit
var school_code = '<?=$school_code?>';

		if (school_code) {
			var ex_ses = $("#exam_session").val(); 
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Certificate/load_edschools',
				data: {school_code:school_code,ex_ses:ex_ses},
				success: function (html) {
					//alert(html);
					var course_id = '<?=$admissioncourse?>';
					$('#admission_course').html(html);
					$("#admission_course option[value='" + course_id + "']").attr("selected", "selected");
				}
			});
		} else {
			
			$('#admission_course').html('<option value="">Select course first</option>');
		}	
		//load streams
		$('#admission_course').on('change', function () {
		var school_code = $("#school_code").val();		
		var admission_course = $("#admission_course").val();
		var ex_ses = $("#exam_session").val(); 
		
		$("#admissioncourse").val($("#admission_course option:selected" ).text());
		//alert(admission_course);
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Certificate/load_edstreams',
				data: {course_id:admission_course,ex_ses:ex_ses,school_code:school_code},
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
			var stream_id = $(this).val();
			var ex_ses = $("#exam_session").val();    
			$("#admissionbranch").val($("#stream_id option:selected" ).text());  
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Certificate/load_edsemesters',
					data: {stream_id:stream_id,ex_ses:ex_ses},
					success: function (newdata) {
						//alert(html);
						
						$('#semester').val(newdata);
						$('#ressemester').val(newdata);
					}
				});
			} else {
				$('#semester').val('');
				$('#ressemester').val('');
			}
		});
		
		var stream_id1 = '<?=$stream?>';
			if (stream_id1) {
				var ex_ses = $("#exam_session").val();   
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Certificate/load_edsemesters',
					data: {stream_id:stream_id1,ex_ses:ex_ses},
					success: function (html_nt) {
						//alert(html);
						//var semester1 = '<?=$semester?>';
						$('#semester').val(html_nt);
						$('#ressemester').val(html_nt);
						//$("#semester option[value='" + semester1 + "']").attr("selected", "selected");
					}
				});
			} else {
				//$('#semester').html('<option value="">Select Stream first</option>');
				        $('#semester').val('');
						$('#ressemester').val('');
			}
	// edit
var admission_course = '<?=$admissioncourse?>';

		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_streams',
				data: 'course_id=' + admission_course,
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
        <li class="active"><a href="#">Results</a></li>
    </ul>
    <div class="page-header">
    	<div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Boardvaluation Generation</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row" style="color:green">
               		 <?php if(!empty($this->session->flashdata('msg'))){ echo $this->session->flashdata('msg');}?>                    
                    <hr class="visible-xs no-grid-gutter-h">
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
                            <form method="post" action ="<?=base_url()?>Boardvaluation">	
                            <div class="form-group">
							 
							 <div class="col-sm-2">
                                <select name="exam_session" id="exam_session" class="form-control" required>
                                 <option value="">Exam Session</option>
                                  <?php

									foreach ($exam_session as $exsession) {
										$exam_sess = $exsession['exam_month'].'-'.$exsession['exam_year'].'-'.$exsession['exam_id'];
									    if ($exam_sess == $_REQUEST['exam_session']) {
									        $sel = "selected";
									    } else {
									        $sel = '';
									    }
									    echo '<option value="' . $exam_sess. '"' . $sel . '>' .$exsession['exam_month'].'-'.$exsession['exam_year'].'-'.$exsession['exam_type'].'</option>';
									}
									?></select>
                              </div>
							<div class="col-sm-2">
                                <select name="board_code" id="board_code" class="form-control" required>
                                 <option value="">Select board</option>
                                 <option value="All" <?php if($board_code =="All"){ ?> selected="selected"<?php } ?>>All</option>
                                <!-- <option value="0">All School</option>-->
									                                  <?php
									foreach ($board as $sch) {
										if(!empty($sch['evaluation_board'])){
									    if ($sch['evaluation_board'] == $board_code) {
									        $sel = "selected";
									    } else {
									        $sel = '';
									    }
									    echo '<option value="' . $sch['evaluation_board'] . '"' . $sel . '>' . $sch['evaluation_board'] . '</option>';
									}}
									?></select>
                                    
                              </div>
                              
                                     <div class="col-sm-2">
                                <select name="board_date" id="board_date" class="form-control">
                                 <option value="">Select Date</option>
                                 </select>
                                    <input type="hidden" name="datahidden" value="<?php echo $board_date;?>" id="datahidden" />
                              </div>
                              
                             
                              <div class="col-sm-2" id="semest">
                                 <input type="submit" id="" class="btn btn-primary btn-labeled pull-right" value="Search" > 
                            </div>
                            </div>
                            </form>
                        </span>
                        
                </div>
			
            <div class="table-info panel-body" style="overflow-x:scroll;height:500px; overflow-y:scroll;width:100%;">  
			<?php 
			$role_id=$this->session->userdata('role_id');
			//if(isset($role_id) && $role_id==1 ){?>
          

            
				<?php // }?>
			
                <div class="col-lg-12">
                <form name="Excelpost" id="Excelpost" method="post" action="<?=base_url()?>Certificate/Manual_excel">
                <input type="hidden" name="regulation" id="regulationex" value="">
                <input type="hidden" name="exam_session" id="exam_sessionex" value="">
                <input type="hidden" name="school_code" id="school_codeex" value="">
                <input type="hidden" name="admission_course" id="admission_courseex" value="">
                <input type="hidden" name="stream_id" id="stream_idex" value="">
                <input type="hidden" name="admissionbranch" id="admissionbranchex" value="">
                <input type="hidden" name="semester" id="semesterex" value="">
                <input type="hidden" name="schoolname" id="schoolnameex" value="">
                <input type="hidden" name="admissioncourse" id="admissioncourseex" value="">
                <input type="hidden" name="admission_branch" id="admission_branchex" value="">
              
                </form>
                
                
                
                    <div class="table-info" id="stddata" >    
				<?php 	
					if($_POST){
				
				?>
				<form name="mrkcrdfrom" id="mrkcrdfrom" method="post" action="<?=base_url()?>Certificate/Manual_excel">
               <!-- <input type="hidden" name="stud_prn[]" id='stud_prn' value=""> -->
                <div class="row">
			
                        <div class="col-lg-1">
                        <?php //if($this->session->userdata("uid")==2){?>
                   <input type="button" name="generate" value="Pdf" id="pdfcard1" class="btn btn-primary">
                     <?php //} ?>
                        </div>
                    </div>
                     <div class="row">&nbsp;&nbsp;
                    
<!--<input type="hidden" name="exam_id" id='resstream_id' value="<?=$exam_id?>">-->        
<input type="hidden" name="exam_session" id="resexam_session" value="<?=$exam_month.'~'.$exam_year.'~'.$exam_id?>">
                          <input type="hidden" name="board_code" id='board_codeid' value="<?=$board_code?>">
                          <input type="hidden" name="board_date" id='board_dateid' value="<?=$board_date?>">
                     <br /></div>
<!--				<table class="table table-bordered nowrap" id="table2excel">
-->               <table id="table2excel" class="display nowrap" style="width:100%">
                         
              
                        <thead>
                               

 
                             
                            <tr>
                                   <!--<th class="noExl"><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th>-->
                                    <th>S.No.</th>
                                    <th>Board</th>
                                    <th>Batch</th>
                                    <th>Stream</th>
                                    <th>Semester</th>
                                    <th>Course Code</th>
                                    <th>Course Name</th>
                                   
                                   
                                    <th>Date</th>
                                    <th>Session</th>
                                    <th>Applied</th>
                                    <th>Appeared</th>
                                    
                                    <th>Valuator</th>

                                    
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                        	
                            <?php
                            //echo "<pre>";
							//print_r($stud_list);
							$string1='';
                          $CI =& get_instance();
							$CI->load->model('Boardvaluation_model');
                            $j=1;  $Honours='0'; $Distinction='0';  $FirstClass='0';     $SecondClass='0';   $ThirdClass='0';                           
							 $boardname=array();$batchname=array();
                            for($i=0;$i<count($stud_list);$i++){
							if(!empty($stud_list[$i]['couser_code'])){
								$faculties =$this->Boardvaluation_model->get_faculty_names($stud_list[$i]['subject_id']);
								foreach($faculties as $f){
									//$string = implode(" ",$f['faculty_name']);//$f['emp_id'].'-'.$f['faculty_name'].'-'.$f['mobile_no']
									$string1 .= $f['faculty_name'].',';
								}
								//$string=implode(",",$faculties);
                            ?>
	
							 
                            <tr>
						<!--<td class="noExl">
                            
                            
                           

            <input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox' value="<?=$stud_list[$i]['exam_id']?>">
                            </td>-->
                              <td><?=$j?></td>
                                <td><?php if(!empty($stud_list[$i]['evaluation_board'])){
									
									if(empty($boardname)){
										
									echo $stud_list[$i]['evaluation_board'];
									$boardname[]=$stud_list[$i]['evaluation_board'];	
									}else{
									//echo ($boardname[0]);
									//print_r($boardname);
									if($stud_list[$i]['evaluation_board']==$boardname[0]){
										echo '-';
										
									}else{
										echo $stud_list[$i]['evaluation_board'];
									   unset($boardname);
										$boardname[]=$stud_list[$i]['evaluation_board'];
									}
								//	unset($boardname);
									}
								}else{
									echo '--';
								}
								
								?></td>
                                <td><?php //$stud_list[$i]['batch']?>
                                <?php if($stud_list[$i]['batch']){
									if(empty($batchname)){
									echo "<b>".$stud_list[$i]['batch']."<b>";
										$batchname[]=$stud_list[$i]['batch'];
									}else{
									if($stud_list[$i]['batch']==$stud_list[$i+1]['batch']){
										echo '-';
									}else{
										echo '-';
										unset($batchname);
									}
									}
								}
								
								?>
                                
                                </td>
                                <td><?=$stud_list[$i]['stream_short_name']?></td>
                                 <td><?=$stud_list[$i]['semester']?></td> 
                                <td><?=$stud_list[$i]['couser_code']?></td> 
                                <td><?=$stud_list[$i]['subject_name'];?><?php //$stud_list[$i]['subject_id'];?></td> 	
                                
							
                                
                                
                                <td><?=$stud_list[$i]['date'];?></td>
                               <td><?php //$stud_list[$i]['from_time'];
							   if($stud_list[$i]['from_time']=='10:00:00'){
			echo $ses = 'F.N';
		}else{
			echo $ses = 'A.N';
		}
							   
							   ?></td>
                              <td><?php $Applied +=$stud_list[$i]['Applied']; echo $stud_list[$i]['Applied'];?></td>
                              <td><?php $Appear +=$stud_list[$i]['Appear']; echo $stud_list[$i]['Appear'];?></td>	
                              <td><?php echo $string1; unset($string1);?></td>		
                            </tr>
                            <?php
                            $j++;
								}}
                            ?>  
                              <tr>
                                     <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th> <th></th>
                                    <th></th>
                                    <th></th>
                                   
                                   
                                    <th></th>
                                    <th>&nbsp;Total Scripts&nbsp;</th>
                                    <th><?php echo $Applied; ?></th>
                                    <th><?php echo $Appear; ?></th>
                                    <th></th>
                              
                              
                                    
                        </tr>
                       
                     


</tbody> 
</table>
</form>	
<?php } ?>

                </div>
                </div>
                </div>
                
            </div>
            </div>    
        </div>
    </div>
</div>
<style>    
input{text-transform:uppercase};
</style> 
<script type="text/javascript">
	function checkgrade(id){

		var result_grade = $("#"+id).val().toUpperCase();
		var grade_letter1 = '<?=$grade_letters?>';
		var grade_letter2 = grade_letter1.slice(0, -1);
		var grade_letter3 = grade_letter2.split(',');

		if (jQuery.inArray(result_grade, grade_letter3)!='-1') {
            //alert(result_grade + ' is in the array!');
        } else {
            alert(result_grade + ' is NOT the Grade letter');
            $("#"+id).val('');
            $("#"+id).focus();
            return false;
        }
	}
function validate_student(strm){

	var chk_stud_checked_length = $('input[class=studCheckBox]:checked').length;
	if(chk_stud_checked_length == 0){
		 alert('please check atleast one Student from student list');
		 return false;
	}else{
		$("#mrkcrdfrom").submit();
		//return true;
	}
} 	
//$(document).ready(function () {
	$('#chk_stud_all').change(function () {
        $('.studCheckBox').prop('checked', $(this).prop('checked'));
   // });
	
		//Allocate batch
	$('#gmarkscard').on('click', function () {
		//alert("hi");
			var chk_stud = $("#chk_stud").val();
			var admission_stream = $("#resstream_id").val();
			var semester = $("#ressemester").val();
			var exam_session = $("#resexam_session").val();
			//alert(exam_session);
			var chk_checked = [];
            $.each($("input[name='chk_stud[]']:checked"), function(){            
                chk_checked.push($(this).val());
            });
			var arr_length = chk_checked.length;
			if(arr_length ==0){
				return false;
			}
			if (arr_length !=0) {
			var chk_stud=chk_checked;
					var url ='<?= base_url() ?>Certificate/generate_markscard_excel/'+chk_stud+'/'+semester+'/'+admission_stream+'/'+exam_session;
					alert(url);
					window.location.href = url;
					//data: {,semester:sem,admission_stream:stream,exam_session:exam_session},

			} else {
				$('#studtbl').html('<option value="">No data found</option>');
			}
		});
});
	
	function getBase64Image_k(img) {
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;

    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    var dataURL = canvas.toDataURL("image/png");

    return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
}
	
function getBase64Image(img) {
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    return canvas.toDataURL("image/png");
}

 $("#Excelcard1").on('click', function () {
		
		$("#regulationex").val($("#regulation").val());
		$("#exam_sessionex").val($("#exam_session").val());
		$("#school_codeex").val($("#school_code").val());
		$("#admission_courseex").val($("#admission_course").val());
		$("#stream_idex").val($("#stream_id").val());
		$("#admissionbranchex").val($("#admissionbranch").val());
		$("#semesterex").val($("#semester").val());
		$("#schoolnameex").val($("#schoolname").val());
		$("#admissioncourseex").val($("#admissioncourse").val());
		$("#admission_branchex").val($("#stream_id").val());
		$( "#Excelpost" ).trigger( "submit" );
	//	alert(admission_branch);
		/*$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Certificate/Manual_excel/',
				data: {regulation:regulation,exam_session:exam_session,school_code:school_code,
			admission_course:admission_course,stream_id:stream_id,admissionbranch:admissionbranch,
			semester:semester,schoolname:schoolname,admissioncourse:admissioncourse,
			admission_branch:admission_branch},
				success: function (html) {
					//alert(html);
					//var course_id = '<>';
					//$('#admission-course').html(html);
					//$("#admission-course option[value='" + course_id + "']").attr("selected", "selected");
				}
			});
		*/
		
		
		
	});
	
	
	 $("#pdfcard1").on('click', function () {
		/*var datepicker=$("#datepicker").val();
		if(datepicker==""){
$("#datepicker").css('border-color', 'red');
            $("#datepicker").focus();
			return false;
		}else{$("#datepicker").css('border-color', '');}*/
		//$("#regulationex").val($("#regulation").val());
		//$("#exam_sessionex").val($("#exam_session").val());
		//$("#school_codeex").val($("#school_code").val());
		//$("#admission_courseex").val($("#admission_course").val());
		//$("#stream_idex").val($("#stream_id").val());
		//$("#admissionbranchex").val($("#admissionbranch").val());
		//$("#semesterex").val($("#semester").val());
		//$("#schoolnameex").val($("#schoolname").val());
		//$("#admissioncourseex").val($("#admissioncourse").val());
		//$("#admission_branchex").val($("#stream_id").val());
		//var values = $("input[name='stud_prnn[]']")
          //    .map(function(){return $(this).val();}).get();
			  
			//  $("#stud_prn").val(values);
		$("#mrkcrdfrom").attr("action",'<?=base_url()?>Boardvaluation/Create_pdf');
		$("#mrkcrdfrom").trigger("submit");
	//	alert(admission_branch);
		/*$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Certificate/Manual_excel/',
				data: {regulation:regulation,exam_session:exam_session,school_code:school_code,
			admission_course:admission_course,stream_id:stream_id,admissionbranch:admissionbranch,
			semester:semester,schoolname:schoolname,admissioncourse:admissioncourse,
			admission_branch:admission_branch},
				success: function (html) {
					//alert(html);
					//var course_id = '<>';
					//$('#admission-course').html(html);
					//$("#admission-course option[value='" + course_id + "']").attr("selected", "selected");
				}
			});
		*/
		
		
		
	});

	
$(document).ready(function() {
	
	   
	$('#datepicker').datepicker({
        "setDate": new Date(),
        "autoclose": true
});
	
	
   /* $('#table2excel').DataTable( {
       // dom: 'Bfrtip',
        buttons: [
           'excel', 'pdf'
        ]
    } );*/
	
	 $('#tadble2excel').DataTable( {
        dom: 'Bfrtip',
         targets: 'no-sort',
       bSort: false,
     "bPaginate": false,
        buttons: [
         /*   {
                extend: '', //excelHtml5
                title: 'Provisional Certificate list',
				exportOptions: {
					
                columns: [1,2,3,4,5,6,7]
            }
            },*/
           /* {
               extend: 'pdfHtml5', //pdfHtml5
			 customize: function(doc) {

       //ensure doc.images exists
       doc.images = doc.images || {};
      // var myGlyph=
        //build dictionary
      //  doc.images['myGlyph'] = getBase64Image(myGlyph);
        //..add more images[xyz]=anotherDataUrl here

        //when the content is <img src="myglyph.png">
        //remove the text node and insert an image node
        for (var i=1;i<doc.content[1].table.body.length;i++) {
			//console.log(doc.content[1].table.body[i][3].text);
			
          //  if (doc.content[1].table.body[i][0].text == '<img src="myglyph.png">') {
           //     delete doc.content[1].table.body[i][0].text;
           //     doc.content[1].table.body[i][0].image = 'myGlyph';
           // }
        }
		
		for (var i = 1; i < doc.content[1].table.body.length; i++) {
    if (doc.content[1].table.body[i][3].text.indexOf('<img src=') !== -1) {
        html = doc.content[1].table.body[i][3].text;

        var regex = /<img.*?src=['"](.*?)['"]/;
        var src = regex.exec(html)[1];


        var tempImage = new Image();
        tempImage.src = src;
var t=getBase64Image(tempImage);
//console.log(t);
         doc.images[src] = getBase64Image(tempImage);

        delete doc.content[1].table.body[i][3].text;
        doc.content[1].table.body[i][3].image = src;
        doc.content[1].table.body[i][3].fit = [50, 50];
    }

    //here i am removing the html links so that i can use stripHtml: true,
  // if (doc.content[1].table.body[i][3].text.indexOf('<a href="details.php?') !== -1) {
      //  html = $.parseHTML(doc.content[1].table.body[i][3].text);
      //  delete doc.content[1].table.body[i][3].text;
      //  doc.content[1].table.body[i][3].text = html[0].innerHTML;
   // }

}
		
		
		
    },
                title: 'Provisional Certificate list',
				exportOptions: {
					 stripHtml: false,
                 columns: [1,2,3,4,5,6,7]
			
			
			
			
                 }
            }*/
			
        ]
		
    } );
	
	
	
} );
$(document).ready(function() {
    $('#table2excel').DataTable( {
        dom: 'Bfrtip',
         targets: 'no-sort',
bSort: false,
language: {
        search: "_INPUT_",
        searchPlaceholder: "Search..."
    },
     "bPaginate": false,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Report'
            }
            /*{
                extend: 'pdfHtml5',
                title: 'Report'
            }*/
        ]
    } );

       
} );
</script>