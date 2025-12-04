<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<style>
	.table{width: 120%;}
	table{max-width: 120%;}
</style>
<?php 
$faculty_arr = array();
foreach ($faculty_list as $value) {
	$faculty_arr[] = $value['emp_id'].", ".$value['fac_name'].", ".$value['department_name'].", ".$value['designation_name'];
}
foreach ($class_faculty_list as $clsval) {
	$class_faculty_arr[] = $clsval['faculty_code'].", ".$clsval['fac_name'];
}
 ?>
<script type="text/javascript">
 $(document).ready(function(){
    //Assign php generated json to JavaScript variable
    var tempArray = <?php echo json_encode($faculty_arr); ?>;
    var dataSrc = tempArray;
    $(".faculty_search").autocomplete({
        source:dataSrc
    });
	//
 	var tempArray1 = <?php echo json_encode($class_faculty_arr); ?>;
    var dataSrc1 = tempArray1;
    $(".faculty_search1").autocomplete({
        source:dataSrc1
    });
    //

    $(".faculty_search2").autocomplete({
        source:dataSrc1
    });
    //

    $(".faculty_search3").autocomplete({
        source:dataSrc1
    });
    //

    $(".faculty_search0").autocomplete({
        source:dataSrc1
    });

});

</script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Time Table </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Lecture Faculty Allocation </h1>
            <div class="col-xs-12 col-sm-8">

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
						<div class="col-sm-3">
							
						</div>	
						<div class="col-sm-9" style="color:green;float:left;font-weight: 900;">
							<?php
							if ($this->session->flashdata('Tmessage') != ''): 
								echo $this->session->flashdata('Tmessage'); 
							endif;
							?>
						</div>
					</div>
					<div class="row">
					<form name="searchTT" id="forms" method="POST" action="<?=base_url()?>timetable/assign_faculty">
						<div class="form-group">
							<div class="col-sm-2" >
                                <select name="academic_year" id="academic_year" class="form-control" required>
                                  <option value="">Select Academic Year</option>
                                  <?php
									foreach ($academic_year as $yr) {
										if ($yr['academic_year'].'~'.$yr['academic_session'] == $academicyear) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session'].'"' . $sel . '>' . $yr['academic_year'].' ('.$yr['academic_session'] . ')</option>';
									}
									?>
                               </select>
                              </div>
                              <div class="col-sm-2" >
                                <select name="course_id" id="course_id" class="form-control" required>
                                  <option value="">Select Course</option>
                                  <?php
									foreach ($course_details as $course) {
										if ($course['course_id'] == $courseId) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
									}
									?>
                               </select>
                              </div> 
                              <div class="col-sm-2" id="semest" >
                                <select name="stream_id" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                               </select>
                              </div>
								<div class="col-sm-2">
									<select id="semester" name="semester" class="form-control" required>
											<option value="">Semester</option>
									</select>
								</div> 
								<div class="col-sm-2">
									<select id="division" name="division" class="form-control" required>
											<option value="">Division</option>
									</select>
								</div>
								<div class="col-sm-2">
									<select id="faculty" name="faculty" class="form-control" required>
										<option value="0">Select Faculty</option>
											<option value="1">Assigned faculty</option>
											<option value="2">Not Assigned faculty</option>
									</select>
								</div>
								<div class="col-sm-2"><input type="submit" class="btn btn-primary" value="Search"></div>
								
                            </div>
                              </form> 
					</div>
                </div>
                <div class="panel-body">
				
                    <div class="table-info" >    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered" style="width:100%!important">
                        <thead>
                            <tr>
                                    <th width="5%">#</th>
                                    <!--th>Academic Year</th>
                                    <th>Stream Name</th>
                                    <th>Semester</th-->
                                    <th width="12%">Course Code</th>
                                    <th>Course Name</th>
                                    <th width="5%">Type</th>
                                    <th width="5%">Division</th>
									<th width="5%">Batch</th>
                                    <!--th>Room No</th-->
									<th>Faculty</th>	
                                    <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;
                            $fac_app =0;
                            //echo "<pre>";print_r($tt_details);
							if(!empty($tt_details)){
                            for($i=0;$i<count($tt_details);$i++)
                            {
                                
                            ?>
                            <tr <?=$tt_details[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>     
                                <td><?=$tt_details[$i]['sub_code']?></td>
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
								}else{
									echo $tt_details[$i]['subject_name'];
								}
								?>
								</td>
                                <td><?=$tt_details[$i]['subtype']?></td>
                                <td><?=$tt_details[$i]['division']?></td>
                                <td><?php if($tt_details[$i]['batch_no']==0){ echo "-";}else{ echo $tt_details[$i]['batch_no'];}?></td>
                                <!--td><?=$tt_details[$i]['room_no']?></td-->
								<td>
									<?php
										if(!empty($tt_details[$i]['fname'])){
											echo strtoupper($tt_details[$i]['fname'][0].'. '.$tt_details[$i]['mname'][0].'. '.$tt_details[$i]['lname']);
										}else{ 
											$fac_app=1;
										echo "<small style='color:red;'>Not Assigned</small>";
									}?>

								</td>
								
                                <td>
                                	<a href="<?=base_url($currentModule."/add_subject_faculty/".$tt_details[$i]['subject_code'].'/'.$tt_details[$i]['stream_id'].'/'.$tt_details[$i]['semester'].'/'.$tt_details[$i]['division'].'/'.$tt_details[$i]['batch_no'].'/'.$courseId.'/'.$academicyear)?>">
									<i class="fa fa-edit"></i></a>
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
                    </table><br> 
                   <?php if($fac_app ==0  && !empty($streamId)){?>
                   <table class="table table-bordered" style="width:100%!important;">
				   <?php 
						if(!empty($tt_details[0]['facultyname'][0]['class_teacher'])){
							$class_teacher = $tt_details[0]['facultyname'][0]['class_teacher'].', '.$tt_details[0]['facultyname'][0]['fname1'].' '.$tt_details[0]['facultyname'][0]['lname1'];
						}else{
						   $class_teacher ="";
						}
						
						if(!empty($tt_details[0]['facultyname'][0]['tutor1_code'])){
							$tutor1_code = $tt_details[0]['facultyname'][0]['tutor1_code'].', '.$tt_details[0]['facultyname'][0]['fname2'].' '.$tt_details[0]['facultyname'][0]['lname2'];
						}else{
						   $tutor1_code ="";
						}
						if(!empty($tt_details[0]['facultyname'][0]['tutor2_code'])){
							$tutor2_code = $tt_details[0]['facultyname'][0]['tutor2_code'].', '.$tt_details[0]['facultyname'][0]['fname3'].' '.$tt_details[0]['facultyname'][0]['lname3'];
						}else{
						   $tutor2_code ="";
						}
					   if(!empty($tt_details[0]['facultyname'][0]['tutur3_code'])){
							$tutor3_code = $tt_details[0]['facultyname'][0]['tutur3_code'].', '.$tt_details[0]['facultyname'][0]['fname4'].' '.$tt_details[0]['facultyname'][0]['lname4'];
						}else{
						   $tutor3_code ="";
						}
					   ?>
	                   	<tr>
	                   		<td><b>Class Teacher :</b> <input type="text" name="class_teacher" id="class_teacher" class="form-control faculty_search0" value="<?php echo $class_teacher;?>"></td>
	                   		<td><b>Tutor 1 :</b> <input type="text" name="tutor_1" id="tutor_1" class="form-control faculty_search1" value="<?php echo $tutor1_code;?>"></td>
	                   		<td><b>Tutor 2 :</b> <input type="text" name="tutor_2" id="tutor_2" class="form-control faculty_search2" value="<?php echo $tutor2_code;?>"></td>
	                   		<td><b>Tutor 3 :</b> <input type="text" name="tutor_3" id="tutor_3" class="form-control faculty_search3" value="<?php echo $tutor3_code;?>"></td>
	                   	</tr>
	                   	<tr>
	                   		<td colspan="4" align="center"><input type="button" name="saveClassInfo" id="saveClassInfo" value="Submit" class="btn btn-primary"></td>
	                   		
	                   	</tr>
               		</table>                  
                    <?php } ?>

                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>    
    $(document).ready(function()
    {
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
				'url' : base_url + '/Batch_allocation/load_streams',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course_id' : course_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#stream_id'); //jquery selector (get element by id)
					if(data){
						var stream_id = '<?=$streamId ?>';
						container.html(data);
						$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}

		$('#course_id').on('change', function () {
			
			var course_id = $(this).val();
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>batch_allocation/load_streams',
					data: 'course_id=' + course_id,
					success: function (html) {
						//alert(html);
						$('#stream_id').html(html);
					}
				});
			} else {
				$('#stream_id').html('<option value="">Select course first</option>');
			}
		});
		//update class teacher
		$('#saveClassInfo').on('click', function () {
			//alert('alert');
			var class_teacher = $("#class_teacher").val();
			var tutor_1 = $("#tutor_1").val();
			var tutor_2 = $("#tutor_2").val();
			var tutor_3 = $("#tutor_3").val();
			var stream_id='<?=$streamId?>';
			var semester='<?=$semesterNo?>';
			var academic_year='<?=$academicyear?>';
			var division='<?=$division?>';
			if (class_teacher!='' && tutor_3!='' && tutor_2 !='' && tutor_1 !='') {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/update_class_details',
					data: {class_teacher:class_teacher,tutor_1:tutor_1,tutor_2:tutor_2,tutor_3:tutor_3,stream_id:stream_id,semester:semester,academic_year:academic_year,division:division},
					success: function (html) {
						if(html=='SUCCESS'){
							alert("Successfully Updated");
						}else{
							alert("Problem while adding");
						}
					}
				});
			}else{
				alert('Please Enter all The input fields.');
			}
		});
		
    });

</script>
<script>
		$('#stream_id').on('change', function () {
			var stream_id = $(this).val();
			var academic_year =$("#academic_year").val();
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttsemesters',
					data: {stream_id:stream_id,academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#semester').html(html);
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
		});
		//

			var stream_id ='<?=$streamId?>';
			var academic_year ='<?=$academicyear?>';
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttsemesters',
					data: {stream_id:stream_id,academic_year:academic_year},
					success: function (html) {
						var semester = '<?=$semesterNo?>';
						$('#semester').html(html);
						$("#semester option[value='" + semester + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}


		$('#semester').on('change', function () {
			var semester = $(this).val();
			var stream_id =$("#stream_id").val();
			var academic_year =$("#academic_year").val();
			if (semester) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttdivision',
					data: {stream_id:stream_id,academic_year:academic_year,stream_id:stream_id, semester:semester},
					success: function (html) {
						
						$('#division').html(html);
						
					}
				});
			} else {
				$('#division').html('<option value="">Select Stream first</option>');
			}
		});

			var semester = '<?=$semesterNo?>';
			if (semester) {
				var academic_year ='<?=$academicyear?>';
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttdivision',
					data: {stream_id:stream_id,academic_year:academic_year,stream_id:stream_id, semester:semester},
					success: function (html) {
						var division ='<?=$division?>';
						$('#division').html(html);
						$("#division option[value='" + division + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#division').html('<option value="">Select Stream first</option>');
			}

		// search faculty 
	$('#search_faculty').keyup( function() {
    //alert('gg');
       var that = this;
        // affect all table rows on in systems table
        var tableBody = $('.table-bordered tbody');
        var tableRowsClass = $('.table-bordered tbody tr');
		
		var k = [];
        $('.search-sf').remove();
        tableRowsClass.each( function(i, val) {        
            //Lower text for case insensitive
            var rowText = $(val).text().toLowerCase();
            var inputText = $(that).val().toLowerCase();
            if( rowText.indexOf( inputText ) == -1 )
            {
                //hide rows
				if(tableRowsClass.eq(i).find(":checkbox").attr('data-messid') == '0'){
				 tableRowsClass.eq(i).find(":checkbox").attr('name','assledun[]');
				}
				//alert(id);
                tableRowsClass.eq(i).hide();                
            }
            else
            {
                $('.search-sf').remove();
				if(tableRowsClass.eq(i).find(":checkbox").attr('data-messid') == '0'){
				tableRowsClass.eq(i).find(":checkbox").attr('name','assled[]');
				}
                tableRowsClass.eq(i).show();
                k.push(1);
            }
        });
        $('#fcnt').text(k.length);
        //all tr elements are hidden
        if(tableRowsClass.children(':visible').length == 0)
        {
            tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="8">No records  found.</td></tr>');
        }
    });
</script>