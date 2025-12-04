<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>

<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />

<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />

<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<?php 
$faculty_arr = array();
foreach ($faculty_list as $value) {
	$faculty_arr[] = $value['emp_id'].", ".$value['fac_name'].", ".$value['department_name'];
}

 ?>
<script>    
 $(document).ready(function(){
	 $("#sub_code_div").hide();
	 $("#subject_title").prop('required',false);
    //Assign php generated json to JavaScript variable
    var tempArray = <?php echo json_encode($faculty_arr); ?>;
	//console.log(tempArray);
   //You will be able to access the properties as 
    //alert(tempArray[0]);
    var dataSrc = tempArray;
 
    $(".faculty_search").autocomplete({
        source:dataSrc
    });
	 $(".faculty_search1").autocomplete({
        source:dataSrc
    });
	$('#dt-datepicker1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#dt-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
});




</script>
<script>    

    $(document).ready(function()

    {

        $('#form').bootstrapValidator

        ({  

            message: 'This value is not valid',

            group: 'form-group',

            feedbackIcons: 

            {

                valid: 'glyphicon glyphicon-ok',

                invalid: 'glyphicon glyphicon-remove',

                validating: 'glyphicon glyphicon-refresh'

            },

            fields: 

            {

                subject_name:

                {

                    validators: 

                    {

                      notEmpty: 

                      {

                       message: 'please enter subject name'

                      }

                    }



                },

                subject_code:

                {

                    validators: 

                    {

                      notEmpty: 

                      {

                       message: 'time table code should not be empty'

                      },

                      stringLength: 

                        {

                        max: 20,

                        min: 2,

                        message: 'time table code should be 2-20 characters.'

                        }

                    }

                },

                subject_type:

                {

                    validators: 

                    {

                      notEmpty: 

                      {

                       message: 'Time table type should not be empty'

                      }

                    }

                },

                stream_id:

                {

                    validators: 

                    {                      

                      notEmpty: 

                      {

                       message: 'stream should not be empty'

                      }

                    }



                },

				semester:

                {

                    validators: 

                    {                      

                      notEmpty: 

                      {

                       message: 'semester should not be empty'

                      }

                    }



                },

				sub_type:

                {

                    validators: 

                    {                      

                      notEmpty: 

                      {

                       message: 'lecture type should not be empty'

                      }

                    }



                },

				room_no1:

                {

                    validators: 

                    {                      

                      notEmpty: 

                      {

                       message: 'Room No should not be empty'

                      }

                    }



                },

				division:

                {

                    validators: 

                    {                      

                      notEmpty: 

                      {

                       message: 'division should not be empty'

                      }

                    }



                },

				faculty1:

                {

                    validators: 

                    {                      

                      notEmpty: 

                      {

                       message: 'faculty should not be empty'

                      }

                    }



                },

				lecture_slot:

                {

                    validators: 

                    {                      

                      notEmpty: 

                      {

                       message: 'slot should not be empty'

                      }

                    }



                },

				subject:

                {

                    validators: 

                    {                      

                      notEmpty: 

                      {

                       message: 'subject should not be empty'

                      }

                    }



                },

				wday:

                {

                    validators: 

                    {                      

                      notEmpty: 

                      {

                       message: 'week day should not be empty'

                      }

                    }



                },

				

            }       

        })

		

		// Num check logic

		$('.numbersOnly').keyup(function () {

			if (this.value != this.value.replace(/[^0-9\.]/g, '')) {

			   this.value = this.value.replace(/[^0-9\.]/g, '');

			} 

		});

		//

		var course_id = $("#course_id").val();

		//alert(course_id);

		if (course_id) {

			$.ajax({

				'url' : base_url + 'timetable/load_streams',

				'type' : 'POST', //the way you want to send data to your URL

				'data' : {'course' : course_id},

				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"

					var container = $('#stream_id'); //jquery selector (get element by id)

					//alert(data);

					if(data){

						var stream_id_session = '<?= $streamId ?>';

						var stream_id_edit = '<?= $ttdet[0]['stream_id'] ?>';

						if(stream_id_session !=''){

							var stream_id = stream_id_session;

						}else if(stream_id_edit !=''){

							var stream_id = stream_id_edit;

						}else{

							var stream_id='';

						}

						//alert(stream_id);

						container.html(data);

						$("#semest option[value='" + stream_id + "']").attr("selected", "selected");

					}

				}

			});

		}

		

		var semesterId = '<?php if($semesterNo !=''){echo $semesterNo;}else{ echo $ttdet[0]['semester'];} ?>';

		if(semesterId !=''){

			var streamId = '<?php if($streamId !=''){echo $streamId;}else{ echo $ttdet[0]['stream_id'];} ?>';

			var course_id = '<?php if($courseId !=''){echo $courseId;}else{ echo $ttdet[0]['course_id'];} ?>';
			var batch = $("#batch").val();
			

			//alert(semesterId);alert(streamId);alert(course_id);

			$.ajax({

				'url' : base_url + 'Timetable/load_subject',

				'type' : 'POST', //the way you want to send data to your URL

				'data' : {'course' : course_id,'streamId':streamId,'semesterId':semesterId,'batch':batch},

				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"

					var container = $('#subject'); //jquery selector (get element by id)

					if(data){

						//alert(data);

						var sub = '<?php if($Tsubject !=''){echo $Tsubject;}else{ echo $ttdet[0]['subject_code'];} ?>';

						container.html(data);

						$("#subject option[value='" + sub + "']").attr("selected", "selected");
						 <?php if($ttdet[0]['subject_code']){ ?>
						checkOfflecture();
						fetch_sub_title();
						<?php } ?>

					}

				}

			});

		}

		// subjuct type change batch selection

		// for theroy there should not be any batch

		$("#sub_type").change(function(){

		    var subtype = $("#sub_type").val();

		    if(subtype=="TH"){

		        $("#batch_no").html("<option value=''>Select</option><option value='0'>No Batch</option>");

		        //$("#batch_no option[value='0']").attr("selected", "selected");

		    }else{

				//$("#batch_no").prop('required',true);

		        $("#batch_no").html("<option value=''>Select</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='0'>0-mba</option>");

		    }

		    

		});

		

		$("#batch_no").change(function(){

		    var batch_no = $("#batch_no").val();

		    if(batch_no !=''){

		        $("#batch_1").html("");

				$("#btn_submit").prop('disabled', false);

				$("#btn_submit1").prop('disabled', false);

		        //$("#batch_no option[value='0']").attr("selected", "selected");

		    }else{

				

		    }

		    

		});

		

		var subtype1 = '<?=$ttdet[0]['subject_type']?>';

		//alert(subtype1);

			if(subtype1){

				

		    if(subtype1=="TH"){

			//	alert('hi');

		        $("#batch_no").html("<option value=''>Select</option><option value='0'>No Batch</option>");

		        $("#batch_no option[value='0']").attr("selected", "selected");

		    }

			}

		

		// revert semester id

		$("#stream_id").change(function(){

		  $('#semester option').attr('selected', false);

		});

		

		$("#semester").change(function(){

			var streamId = $("#stream_id").val();

			var course_id = $("#course_id").val();

			var semesterId = $("#semester").val();
			var batch = $("#batch").val();
			

			$.ajax({

				'url' : base_url + 'Timetable/load_subject',

				'type' : 'POST', //the way you want to send data to your URL

				'data' : {'course' : course_id,'streamId':streamId,'semesterId':semesterId,'batch':batch},

				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"

					var container = $('#subject'); //jquery selector (get element by id)

					if(data){

						//var stream_id = '<?= $ttdet[0]['stream_id'] ?>';

						container.html(data);

						//$("#semest option[value='" + stream_id + "']").attr("selected", "selected");

					}

				}

			});

		});
		$("#subject").change(function(){
			var subject = $("#subject").val();		
			$.ajax({
				'url' : base_url + 'Timetable/load_subject_type',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'subject' : subject},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#sub_type'); //jquery selector (get element by id)
					if(data){
						container.html(data);
					}
				}
			});
		});
		
		//fetch department

		$("#school").change(function(){

			var school_id = $("#school").val();		

			$.ajax({

				'url' : base_url + 'Timetable/load_department',

				'type' : 'POST', //the way you want to send data to your URL

				'data' : {'school_id' : school_id},

				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"

					var container = $('#dept'); //jquery selector (get element by id)

					if(data){

						container.html(data);

					}

				}

			});

		});

		//fetch faculty

		$("#dept").change(function(){

			var school_id = $("#school").val();		

			var dept = $("#dept").val();

			var faculty_type = $("#faculty_type").val();

			$.ajax({

				'url' : base_url + 'Timetable/load_faculty',

				'type' : 'POST', //the way you want to send data to your URL

				'data' : {'school_id' : school_id,'dept_id':dept, 'faculty_type':faculty_type},

				'success' : function(data1){ //probably this request will return anything, it'll be put in var "data"

					var container1 = $('#faculty_id'); //jquery selector (get element by id)

					if(data1){

						container1.html(data1);

					}

				}

			});

		});

		//Asign faculty 

		$("#faculty_id").change(function(){

			var fac_id = $("#faculty_id").val();	

			if(fac_id !=''){

				$("#faculty").val(fac_id);

				$("#faculty_val").html("");

			}else{

				$("#faculty").val('');

			}

		});

    });

function checkOfflecture(){

	var subjectval = $("#subject").val();	

	if(subjectval=='OFF'){

		$("#faculty").prop('required',false);

	}
	if(subjectval == "18157" || subjectval == "18150" || subjectval == "18152" || subjectval == "18148" || subjectval == "18149"){
            $("#sub_code_div").show(); 
			$("#subject_title").prop('required',true);// Enable div
        } else {
            $("#sub_code_div").hide(); // Disable div
			$("#subject_title").prop('required',false);
        }

}
function fetch_sub_title(){
 
 var subject = $("#subject").val();	
var selectedValue = '<?=$ttdet[0]['sub_title_id']?>';
			$.ajax({
				'url' : base_url + 'Timetable/load_subject_type_title',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'subject' : subject},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#sub_title_id'); //jquery selector (get element by id)
					if(data){
						container.html(data);
						container.val(selectedValue);
					}
				}
	  });
 }
 
 
function validate_batch(){

	var batch = $("#batch_no").val();	

	var faculty = $("#faculty").val();	

	//alert(batch);
/////inside validate_batch()

var fdate = $("#dt-datepicker").val();	
	var tdate = $("#dt-datepicker1").val();

	if(batch==''){

		$("#batch_no").prop('required',true);

		$("#batch_1").html("Please select batch");

		//alert('please select batch');

		$("#batch_no").focus();

		return false;

		//alert('inside');

		

	}else if(faculty==''){

		$("#faculty").prop('required',true);

		$("#faculty_val").html("Please select faculty");

		//alert('please select faculty');

		$("#faculty").focus();

		return false;

		//alert('inside');

		

	}else if(fdate==''){
		
		  alert('please select From Date');
           $("#btn_submit").prop("disabled",false);
		return false;
		

	}else if(tdate==''){

		  alert('please select To Date');
		  $("#btn_submit").prop("disabled",false);

		return false;

	}else if(fdate !='' && tdate !=''){
           
		   if(fdate > tdate)
		   {
			  	  alert('From Date must be less than To Date'); 
				  $("#btn_submit").prop("disabled",false);
				  	return false;
		   }

	}else{

	return true;

	}

}

</script>

<?php

    $astrik='<sup class="redasterik" style="color:red">*</sup>';

	$tp = $this->uri->segment(3);

	if($tp!=''){

		$ed ="Edit";

	}else{

		$ed ="Add";

	}

?>

<div id="content-wrapper">

    <ul class="breadcrumb breadcrumb-page">

        <div class="breadcrumb-label text-light-gray">You are here: </div>

        <li><a href="#">Masters</a></li>

        <li class="active"><a href="#"><?=$ed?> Time table</a></li>

    </ul>

    <div class="page-header">			

        <div class="row">

            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;<?=$ed?> Time table</h1>

            <div class="col-xs-12 col-sm-8">

                <div class="row">                    

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

                        <div class="row ">

						<div class="col-sm-10">

	<span class="panel-title">Time table</span>
	<div class="pull-right col-xs-12 col-sm-auto">
			 <a href="javascript:void(0);" class="btn btn-primary swap-icon" data-toggle="modal" data-target="#swapModal" data-stud_id="<?=$stud['student_id']?>" data-stud_name="<?=$stud['student_name']?>">Add VAP/SS/CERT Subject Title</a>
	
</div>	
</div>

							<?php

							if ($this->session->flashdata('dup_msg') != ''){

							?>

							<div class="col-sm-9" style="color:red;float:left;font-weight: 900;">

						

						<?php

							if ($this->session->flashdata('dup_msg') != ''): 

								echo $this->session->flashdata('dup_msg'); 

							endif;

							?>

							</div>

							

						

							<?php

							}

							if ($this->session->flashdata('Tmessage') != ''){

							?>

							<div class="col-sm-9" style="color:green;float:left;font-weight: 900;">

							

							<?php

							if ($this->session->flashdata('Tmessage') != ''): 

								echo $this->session->flashdata('Tmessage'); 

							endif;

							?>

							</div>

							<?php }?>

					</div>

                    </div>



                    <div class="panel-body">

                        <div class="table-info">                            

                            <?php if(!empty($ttdet[0]['time_table_id'])) { 
								$read_only= "readonly='true'";
								$disabled= "disabled='true'";
							?>

                            <form id="form" name="form" action="<?=base_url($currentModule.'/update_timetable')?>" method="POST" onsubmit="return validate_batch()">  
								<input type="hidden" value="<?=isset($ttdet[0]['wday']) ? $ttdet[0]['wday'] : ''?>" id="wday" name="wday" />
							<?php }else{ 
							$read_only= "";
								$disabled= "";
							?>

							<form id="form" name="form" action="<?=base_url($currentModule.'/insert_timetable')?>" method="POST" onsubmit="return validate_batch()">  

							<?php }?>							

                                <input type="hidden" value="<?=isset($ttdet[0]['time_table_id']) ? $ttdet[0]['time_table_id'] : ''?>" id="time_table_id" name="time_table_id" />

							<div class="form-group">
							<div class="col-sm-2">Academic year <?=$astrik?></div>

                              <div class="col-sm-3" >

                                <select name="academic_year" id="academic_year" class="form-control" required <?=$disabled?>>
                                  <option value="">Select Academic Year</option>
                                  <?php
                                  if($ttdet[0]['academic_session']=='WIN'){
                                  	$curr_sess = "WINTER";
                                  }else{
                                  	$curr_sess = "SUMMER";
                                  }
                                  if($ttdet[0]['academic_year'] !=''){
                                  		$acad_year =$ttdet[0]['academic_year'].'~'.$curr_sess;
                                  }else{
                                  	$acad_year = $academicyear;
                                  }
                                  

									foreach ($academic_year as $yr) {
										if ($yr['academic_year'].'~'.$yr['academic_session'] == $acad_year) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session']. '"' . $sel . '>' . $yr['academic_year'] .'-'.$yr['academic_session'].'</option>';
									}
									?>
									<?php
									//if($this->session->userdata('name')=='110074'){
										//echo '<option value="2021-22~WINTER">2021-22 (WINTER)</option>';
									//}?>
                               </select>

                              </div>
							  <div class="col-sm-2">Batch <?php //print_r($tt_details);  ?> <?=$astrik?></div>

                              <div class="col-sm-3" >

                                <select name="batch" id="batch" class="form-control" required >
                                  <option value="">Select Batch</option>
                                  <?php
								  if($tt_details[0]['batch'] !=''){
                                  		$batch =$tt_details[0]['batch'];
                                  }else if($ttdet[0]['batch'] !=''){
									  $batch =$ttdet[0]['batch'];
								  }else{
                                  	$batch = '';
                                  }
									foreach ($batches as $bth) {
										if ($bth['batch'] == $batch) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' .$bth['batch'].'"' .$sel. '>'.$bth['batch'].'</option>';
									}
									?>
                               </select>

                              </div>
                              </div>
                              <div class="form-group">
							<div class="col-sm-2">Course <?=$astrik?></div>

                              <div class="col-sm-3" >

                                <select name="course_id" id="course_id" class="form-control" onchange="load_streams(this.value)" required >

                                  <option value="">Select Course</option>

                                  <?php

									foreach ($course_details as $course) {

										if($ttdet[0]['course_id'] !=''){

											$courseIdT = $ttdet[0]['course_id'];

										}else{

											$courseIdT = $courseId;

										}

										if ($course['course_id'] == $courseIdT) {

											$sel = "selected";

										} else {

											$sel = '';

										}

										echo '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';

									}

									?>

                               </select>

                              </div>

                              <script>

                                     var base_url = '<?php

										echo site_url();

										?>';

                                      function load_streams(type){

											   // alert(type);

												

											$.ajax({

												'url' : base_url + 'timetable/load_streams',

												'type' : 'POST', //the way you want to send data to your URL

												'data' : {'course' : type},

												'success' : function(data){ //probably this request will return anything, it'll be put in var "data"

													var container = $('#stream_id'); //jquery selector (get element by id)

													if(data){

													 //   alert(data);

														//alert("Marks should be less than maximum marks");

														//$("#"+type).val('');

														container.html(data);

													}

												}

											});

										}

										

                                    </script>

                              <div class="col-sm-2">Stream <?=$astrik?></div>

                              <div class="col-sm-3" id="semest">

                                <select name="stream_id" class="form-control" id="stream_id" required >

                                  <option value="">Select Stream </option>

                                  

                               </select>

                              </div>	

                            </div>

                                <div class="form-group">

									<div class="col-sm-2">Semester <?=$astrik?></div>

									<div class="col-sm-3">

									<select id="semester" name="semester" class="form-control" >

                                            <option value="">Select Semester</option>

											<?php 

											if($semesterNo !=''){ $semT = $semesterNo;}else{$semT = $ttdet[0]['semester'];}

											for($i=1;$i<=10;$i++) {

												if ($i == $semT) {

													$sel3 = "selected";

												} else {

													$sel3 = '';

												}
											if(empty($ttdet[0]['time_table_id'])){
											if($i%2==0)
												{
													$even=$i;
													if($cur_session[0]['academic_session']=='SUMMER'){
													?>
													
													<option value="<?=$even?>" <?=$sel3?>><?=$even?></option>
													<!--option value="<?=$odd?>" <?=$sel3?>><?=$odd?></option-->
													<?php }}else{
													$odd=$i;
													if($cur_session[0]['academic_session']=='WINTER'){
													?> 
												<option value="<?=$odd?>" <?=$sel3?>><?=$odd?></option>
												<!--option value="<?=$even?>" <?=$sel3?>><?=$even?></option-->
													<?php }}
													}else{
											?>

                                            <option value="<?=$i?>" <?=$sel3?>><?=$i?></option>

                                            <?php } 
											} ?>
												<option value="2" <?=$sel3?>>2</option>
												<!--option value="3" <?=$sel3?>>3</option-->
									</select>

									</div> 

									<label class="col-sm-2">Division<?=$astrik?></label>

									<div class="col-sm-3">

									<?php

										if($division !=''){ $divT = $division;}else{$divT = $ttdet[0]['division'];}
										$divisions = array_merge(range('A', 'Z'), ['PP', 'QQ', 'RR', 'SS', 'TT', 'VV', 'WW', 'XX', 'YY', 'ZZ']);
									?>

									   <select id="division" name="division" class="form-control" <?= $disabled ?>>
											<option value="">Select</option>
											<?php
											foreach ($divisions as $division) {
												$selected = (!empty($divT) && $divT == $division) ? "selected" : "";
												echo "<option value=\"$division\" $selected>$division</option>";
											}
											?>
										</select>

									

									</div> 									



                                </div>



                                <div class="form-group">

                                    

                                    

                                </div>
								<div class="form-group">
									<label class="col-sm-2">Subject <?=$astrik?></label>                                    
									<div class="col-sm-3">
                                        <select id="subject" name="subject" class="form-control" onchange="checkOfflecture();fetch_sub_title();" <!--?=$disabled?-->>
                                            <option value="">Select Subject</option>	
										</select>											
                                    </div>
                                      <div id="sub_code_div">									
                                    <label class="col-sm-2">Subject Title<?=$astrik?></label>                                    
									<div class="col-sm-3">
                                       <select id="sub_title_id" name="sub_title_id" class="form-control" >

                                            <option value="">Select Subject Title</option>	

										</select>
                                    </div>                                    
                                    </div>                                    
                                </div> 
                                <div class="form-group">

									
                                    <label class="col-sm-2">Lecture Type<?=$astrik?></label>

                                    <div class="col-sm-3">

									<select id="sub_type" name="sub_type" class="form-control" />

										<option value="">Select</option>
										<?php 
											if($sub_type !=''){
												$subtype = $sub_type;
												}else{
													$subtype  = $ttdet[0]['subject_component'];
											}
											if($subtype=='TH'){
										?>
										<option value="TH" <?php if(!empty($subtype) && $subtype =='TH'){ echo "selected";}elseif(!empty($Tsub_type) && $Tsub_type =='TH'){ echo "selected"; }?>>Theory</option>
										<?php 
											}else{
										?>
										<option value="PR" <?php if(!empty($subtype) && $subtype =='PR'){ echo "selected";}elseif(!empty($Tsub_type) && $Tsub_type =='PR'){ echo "selected"; }?>>Practical</option>
										<?php 
											}
										?>

									</select>

									</div>                                    

                                     

                                </div>                                

                                <div class="form-group">

                                    

									<label class="col-sm-2">Lecture Slot<?=$astrik?></label>

								    <div class="col-sm-3">

										<select id="lecture_slot" name="lecture_slot" class="form-control"/>

										<option value="">Select</option>

										<?php

										foreach ($slot as $slt) {

										

												if ($slt['lect_slot_id'] == $ttdet[0]['lecture_slot']) {

													$sel4 = "selected";

												} else {

													$sel4 = '';

												}

											echo '<option value="'.$slt['lect_slot_id'].'" '.$sel4.'>'.$slt['from_time'].' - '.$slt['to_time'].' '.$slt['slot_am_pm'].'</option>';

										}

										?>

									</select>

									</div>

                                    <label class="col-sm-2">Week Day<?=$astrik?></label>

								    <div class="col-sm-3">

										<select id="wday" name="wday" class="form-control"/>

										<option value="">Select</option>

										<option value="Monday" <?php if(!empty($ttdet[0]['wday']) && $ttdet[0]['wday'] =='Monday'){ echo "selected";}?>>Monday</option>

										<option value="Tuesday" <?php if(!empty($ttdet[0]['wday']) && $ttdet[0]['wday'] =='Tuesday'){ echo "selected";}?>>Tuesday</option>

										<option value="Wednesday" <?php if(!empty($ttdet[0]['wday']) && $ttdet[0]['wday'] =='Wednesday'){ echo "selected";}?>>Wednesday</option>

										<option value="Thursday" <?php if(!empty($ttdet[0]['wday']) && $ttdet[0]['wday'] =='Thursday'){ echo "selected";}?>>Thursday</option>

										<option value="Friday" <?php if(!empty($ttdet[0]['wday']) && $ttdet[0]['wday'] =='Friday'){ echo "selected";}?>>Friday</option>

										<option value="Saturday" <?php if(!empty($ttdet[0]['wday']) && $ttdet[0]['wday'] =='Saturday'){ echo "selected";}?>>Saturday</option>

										<option value="Sunday" <?php if(!empty($ttdet[0]['wday']) && $ttdet[0]['wday'] =='Sunday'){ echo "selected";}?>>Sunday</option>

									</select>								

									</div>

                                </div>

                                <div class="form-group">

									

                                    <!--label class="col-sm-3">Faculty<?=$astrik?></label>

                                    <div class="col-sm-3"><a href="" data-toggle="modal" data-target="#loginbox" style="text-decoration:none;"><input type="text" id="faculty" name="faculty" class="form-control" value="<?=isset($ttdet[0]['faculty_code']) ? $ttdet[0]['faculty_code'].'/'.$f_name[0]['fname'][0].'. '.$f_name[0]['mname'][0].'. '.$f_name[0]['lname'] : $Tfaculty?>"/></a>

										<div id="faculty_val" style="color:red;margin-top:2px;"></div>

									</div-->                                 

                                    <label class="col-sm-2">Batch<?=$astrik?></label>

                                    <div class="col-sm-3"><select id="batch_no" name="batch_no" class="form-control"/>

										<option value="">Select</option>
										<?php 
										if($Tbatch_no !=''){
												$subbatch_no = $Tbatch_no;
												}else{
													$subbatch_no  = $ttdet[0]['batch_no'];
											}
											if($subtype=='PR'){
										?>
										<option value="1" <?php if(!empty($subbatch_no) && $subbatch_no =='1'){ echo "selected";}elseif(!empty($Tbatch_no) && $Tbatch_no =='1'){ echo "selected"; }?>>1</option>

										<option value="2" <?php if(!empty($subbatch_no) && $subbatch_no =='2'){ echo "selected";}elseif(!empty($Tbatch_no) && $Tbatch_no =='2'){ echo "selected"; }?>>2</option>

										<option value="3" <?php if(!empty($subbatch_no) && $subbatch_no =='3'){ echo "selected";}elseif(!empty($Tbatch_no) && $Tbatch_no =='3'){ echo "selected"; }?>>3</option>

										<option value="4" <?php if(!empty($subbatch_no) && $subbatch_no =='4'){ echo "selected";}elseif(!empty($Tbatch_no) && $Tbatch_no =='4'){ echo "selected"; }?>>4</option>	
										<option value="5" <?php if(!empty($subbatch_no) && $subbatch_no =='5'){ echo "selected";}elseif(!empty($Tbatch_no) && $Tbatch_no =='5'){ echo "selected"; }?>>5</option>										
										<option value="6" <?php if(!empty($subbatch_no) && $subbatch_no =='6'){ echo "selected";}elseif(!empty($Tbatch_no) && $Tbatch_no =='6'){ echo "selected"; }?>>6</option>										
										<option value="7" <?php if(!empty($subbatch_no) && $subbatch_no =='7'){ echo "selected";}elseif(!empty($Tbatch_no) && $Tbatch_no =='7'){ echo "selected"; }?>>7</option>										
										<option value="8" <?php if(!empty($subbatch_no) && $subbatch_no =='8'){ echo "selected";}elseif(!empty($Tbatch_no) && $Tbatch_no =='8'){ echo "selected"; }?>>8</option>										
										<option value="9" <?php if(!empty($subbatch_no) && $subbatch_no =='9'){ echo "selected";}elseif(!empty($Tbatch_no) && $Tbatch_no =='9'){ echo "selected"; }?>>9</option>										
										<option value="10" <?php if(!empty($subbatch_no) && $subbatch_no =='10'){ echo "selected";}elseif(!empty($Tbatch_no) && $Tbatch_no =='10'){ echo "selected"; }?>>10</option>										

<option value="0" <?php if(!empty($subbatch_no) && $subbatch_no =='0'){ echo "selected";}elseif(!empty($Tbatch_no) && $Tbatch_no =='0'){ echo "selected"; }?>>0-MBA</option>										
										<?php }else{?>
										<option value="0" selected>No Batch</option>
										<?php }?>
									</select>

									<div id="batch_1" style="color:red;margin-top:2px;"></div>

									</div> 
									<label class="col-sm-2">Buliding Name</label>

									<div class="col-sm-3">

									<input type="text" id="buliding_name" name="buliding_name" class="form-control" value="<?php if(!empty($ttdet[0]['buliding_name'])){ echo $ttdet[0]['buliding_name'];}?>" required />

									

									</div>
                                </div>
								
								
								<div class="form-group">

									<label class="col-sm-2">Floor No</label>
									<div class="col-sm-3">
									<input type="text" id="floor_no" name="floor_no" class="form-control" value="<?php if(!empty($ttdet[0]['floor_no'])){ echo $ttdet[0]['floor_no'];}?>" required />
									</div>
									<label class="col-sm-2">Class Room No:</label>
									<div class="col-sm-3">
                                    <input type="text" id="room_no" name="room_no" class="form-control" value="<?php if(!empty($ttdet[0]['room_no'])){ echo $ttdet[0]['room_no'];}?>" required />	
								</div>
                                    </div>
								<?php if(!empty($ttdet[0]['time_table_id']))
								{
								?>
								<div class="form-group">

									<label class="col-sm-2">Faculty Name:</label>
                                    <div class="col-sm-3" style="text-align:left;">
                                    	
											<?=isset($ttdet[0]['faculty_code']) ? $ttdet[0]['faculty_code'].'/'.$f_name[0]['fname'][0].'. '.$f_name[0]['mname'][0].'. '.$f_name[0]['lname'] : $Tfaculty?>
											
                                    </div> 
									<label class="col-sm-2">Change Faculty:</label>
                                    <div class="col-sm-3"><input type="text" class="form-control faculty_search" name="faculty" id="faculty_search" value=""><small>Type Faculty Name or Code</small>	
                                    </div>

								</div>
								<?php }?>
								<?php
									$emp_id = $this->session->userdata("name");		
									$ex =explode("_",$emp_id);
									$sccode = $ex[1];
									if($sccode==1009){
								?>
									 <div class="form-group">
									<label class="col-sm-2">Select Faculty:</label>
                                    <div class="col-sm-2"><input type="text" class="form-control faculty_search1" name="faculty" id="faculty_search" value=""><small>Type Faculty Name or Code</small>	
                                    </div>

									<label class="col-sm-1">From Date</label>

									<div class="col-sm-2">

									<input type="text" id="dt-datepicker" name="fdate" class="form-control" value="<?php if(!empty($ttdet[0]['tdate'])){ echo $ttdet[0]['tdate'];}
									  if(!empty($Tfdate)){ echo $Tfdate;}
									?>" <?=$disabled;?> />

									</div>
									<label class="col-sm-1">To Date</label>

									<div class="col-sm-2">

									<input type="text" id="dt-datepicker1" name="tdate" class="form-control" value="<?php if(!empty($ttdet[0]['tdate'])){ echo $ttdet[0]['tdate'];}  if(!empty($Ttdate)){ echo $Ttdate;}
									?>" />



									</div>
									</div>
									<?php }?>
                                <div class="clearfix">&nbsp;</div>

                                <div class="form-group">

                                    <div class="col-sm-2"></div>

                                    <div class="col-sm-2">

										<?php if($tp !=''){?>

                                        <button class="btn btn-primary form-control" id="btn_submit1" type="submit" >Update</button> 

										<?php }else{?>  

										<button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button> 

										<?php }?>                                        										

                                    </div>                                    

                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/ttlist'">Cancel</button></div>

                                    <div class="col-sm-4"></div>

                                </div>

                            </form>

                            <?php //} ?>
							
                        </div>

                    </div>

                </div>

            </div>    

        </div>

    <!----------------- View table list------------------------------->

	<?php if($tp ==''){?>

<div class="row ">

            <div class="col-sm-12">

                <div class="panel">

				<div class="panel-heading">

                        <span class="panel-title">Time Table</span>

                        <div class="holder"></div>

                </div>

                <div class="panel-body">

                    <div class="table-info" style="">    

                    <?php //if(in_array("View", $my_privileges)) { ?>

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                    <th>#</th>

                                    <!--th>Academic Year</th>

                                    <th>Stream Name</th>

                                    <th>Semester</th-->

                                    <th>Subject Name</th>
									<th>Subject Title</th>	
                                    <th>Type</th>

                                    <th>Div</th>

									<th>Batch</th>

                                    <!--th>Room No</th-->

									<th>Faculty</th>

									<th>Day</th>

									<th>Slot</th>

                                    <th>Action</th>

                            </tr>

                        </thead>

                        <tbody id="itemContainer">

                            <?php

                            $j=1;

							if(!empty($tt_details)){

                            for($i=0;$i<count($tt_details);$i++)

                            {

                                

                            ?>

                            <tr <?=$tt_details[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>

                                <td><?=$j?></td>     

								<!--td><?=$tt_details[$i]['academic_year']?></td>								

                                <td><?=$tt_details[$i]['stream_name']?></td>

                                <td><?=$tt_details[$i]['semester']?></td-->

                                <td>

								<?php

								if($tt_details[$i]['subject_code']== 'OFF'){

									echo "OFF Lecture";

								}else if($tt_details[$i]['subject_code']=='Library'){

									echo "Library";

								}else if($tt_details[$i]['subject_code']== 'Tutorial'){

									echo "Tutorial";

								}else if($tt_details[$i]['subject_code']== 'Tutor'){

									echo "Tutor";

								}else if($tt_details[$i]['subject_code']=='Soft Skill'){

									echo "Soft Skill";

								}else if($tt_details[$i]['subject_code']==' Basic Aptitude Training'){

									echo " Basic Aptitude Training";

								}else if($tt_details[$i]['subject_code']=='Advanced Aptitude Training'){

									echo "Advanced Aptitude Training";

								}else if($tt_details[$i]['subject_code']=='Value Added Course'){

									echo "Value Added Course";

								}else if($tt_details[$i]['subject_code']=='Value Added Course-Advanced Excel'){

									echo "Value Added Course-Advanced Excel";

								}else if($tt_details[$i]['subject_code']=='Certificate Course'){

									echo "Certificate Course";
									echo "Certificate Course";

								}else{

									echo $tt_details[$i]['sub_code'].' - '.$tt_details[$i]['subject_name'];

								}

								?>

								</td> 
<td><?=$tt_details[$i]['subject_title']?></td>	
                                <td><?=$tt_details[$i]['subject_type']?></td>

                                <td><?=$tt_details[$i]['division']?></td>

                                <td><?=$tt_details[$i]['batch_no']?></td>

                                <!--td><?=$tt_details[$i]['room_no']?></td--> 

								<td><?=strtoupper($tt_details[$i]['fname'][0].'. '.$tt_details[$i]['mname'][0].'. '.$tt_details[$i]['lname']);?></td>

								<td><?=$tt_details[$i]['wday']?></td>

								<td><?=$tt_details[$i]['from_time']?> - <?=$tt_details[$i]['to_time']?> <?=$tt_details[$i]['slot_am_pm']?></td>

                                <td>

                                    <?php //if(in_array("Edit", $my_privileges)) { ?>

                                    <a href="<?=base_url($currentModule."/edit/".$tt_details[$i]['time_table_id'])?>"><i class="fa fa-edit"></i></a> | 

									<a class="close" href="<?=base_url($currentModule."/removeTimetableEntry/".$tt_details[$i]['time_table_id'])?>"><i class="fa fa-trash-o"></i></a> 	    

									

                                    <?php// } ?>

                                    <?php //if(in_array("Delete", $my_privileges)) { ?>

                                    <!--a href='<?=base_url($currentModule).$tt_details[$i]["status"]=="Y"?"disable/".$tt_details[$i]["time_table_id"]:"enable/".$tt_details[$i]["sub_id"]?>'><i class='fa <?=$tt_details[$i]["status"]=="Y"?"fa-ban":"fa-check"?>' title='<?=$tt_details[$i]["status"]=="Y"?"Disable":"Enable"?>'></i></a-->

                                    <?php //} ?>

                                </td>

                            </tr>

                            <?php

                            $j++;

                            }

							}else{

								echo "<tr>";echo "<td colspan=13>";echo "No data found.";echo "</td>";echo "</tr>";

							}

                            ?>                            

                        </tbody>

                    </table>                    

                    <?php //} ?>
					<div>
						<b>NOTE:</b>
						<ul>
							<li>Lecture Slot, Week Days, Batch allowed for update.</li>
							<li>In case of change in Subjet, Division kindly do the new entry.</li>
						</ul>
					</div>
                </div>

                </div>

            </div>

	</div>

</div>	

<?php }?>

    </div>

</div>
<!-- Model For Add subject Title -->

<div class="modal fade" id="swapModal" tabindex="-1" role="dialog" aria-labelledby="swapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- modal-lg for larger view -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="swapModalLabel">Add Subject Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="swapForm" action="<?=base_url().'Timetable/add_new_vap_subject_title'?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="faculty">Select Subject</label>
                        <select name="subject" class="form-control" id="subject" required>
			             <option value="">Select Subject</option>
						 <option value="18157">Value Added Programe</option>
						 <option value="18150">Soft Skill</option>
						 <option value="18149">Certificate Course</option>
						 <option value="18152">Basic Aptitude Training</option>
						 <option value="18148">Advanced Aptitude Training</option>
						 
						 </select>
						 </div>
						 <div class="form-group">
						 <label for="faculty">Title</label>
						 <input type="text" class="form-control" name="sub_title" id="sub_title" value="">
						 </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">ADD</button>
                </div>
            </form>
        </div>
    </div>
<!--- Add Faculty POP uP------------>

<div class="modal fade" id="loginbox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        

                        <h4 class="modal-title" id="myModalLabel">Select Faculty</h4>

                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-sm-12">

                                <div class="panel panel-default panel-hovered panel-stacked">

                                    <div class="panel-body">

                                        <form class="form-horizoontal" role="form" name="frmlogin" id="frmlogin">

										<div class="row">

											<div class="form-group">

												<label class="col-sm-3">Faculty Type</label>

												<div class="col-sm-6">

													<select name="faculty_type" class="form-control" id="faculty_type">

														<option value="">--Select--</option>

														<option value="per">Permenent</option>

														<option value="guest">Visiting</option>

													</select>  

												</div>

											</div>

										</div>

										<div class="row">

											<div class="form-group">

												<label class="col-sm-3">School</label>

												<div class="col-sm-6">

													<select name="school" class="form-control" id="school">

														<option value="">--Select--</option>

														<?php

														foreach ($school_details as $school) {

															if ($school['course_id'] == $courseId) {

																$sel = "selected";

															} else {

																$sel = '';

															}

															echo '<option value="' . $school['college_id'] . '"' . $sel . '>' . $school['college_name'] . '</option>';

														}

														?>

													</select>

												</div>

											</div>

											

										</div>

										<div class="clearfix">&nbsp;</div>

										<div class="row">

											<div class="form-group">

												<label class="col-sm-3">Department</label>

												<div class="col-sm-6">

													<select name="dept" class="form-control" id="dept">

														<option value="">--Select--</select>

													</select>

												</div>

											</div>

										</div>

										<div class="clearfix">&nbsp;</div>

										<div class="row">

											<div class="form-group">

												<label class="col-sm-3">Faculty</label>

												<div class="col-sm-6">

													<select name="faculty_id" class="form-control" id="faculty_id">

														<option value="">--Select--</select>

													</select>

												</div>

											</div>

										</div>

                                        </form>

                                    </div>

                                    <!-- #end panel body -->

                                </div>

                                <!-- #end panel -->

                            </div>



                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        <button type="button" id="btnlogin" data-dismiss="modal" class="btn btn-primary">OK</button>

                    </div>

                </div>

            </div>

        </div>
		
<script>
	$("#swapForm").submit(function(e){
    e.preventDefault(); // Prevent default form submission

    $.ajax({
        url: $(this).attr("action"),
        type: "POST",
        data: $(this).serialize(),
        dataType: "json", // Expect JSON response
        success: function(response){
            if (response.status === "success") {
                alert(response.message);
				fetch_sub_title();
				$('#swapModal').modal('hide'); 
                //location.reload(); // Reload if successful
            } else {
                alert(response.message); // Show error message if no update occurred
            }
        },
        error: function(){
            alert("Error on Assigning new Guide.");
        }
    });
});
		</script>
 <!-- #end model -->		