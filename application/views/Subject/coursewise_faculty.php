<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<style>
	.table{width: 120%;}
	table{max-width: 120%;}
	.valin{vertical-align: top !IMPORTANT; }
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
        <li class="active"><a href="#">Course Master </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Subject Handling Faculty details. </h1>
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
					<form name="searchTT" id="forms" method="POST" action="<?=base_url()?>subject/coursewise_faculty">
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
                                <select name="batch" id="batch" class="form-control" required>
                                  <option value="">Select Batch</option>
                                  <?php
                                    foreach ($batches as $bth) {
                                        if ($bth['batch'] == $batch) {
                                            $sel = "selected";
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . $bth['batch'] . '"' . $sel . '>' . $bth['batch'] . '</option>';
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
								<!--div class="col-sm-2">
									<select id="division" name="division" class="form-control" required>
											<option value="">Division</option>
									</select>
								</div-->
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
                                    <th rowspan="2"width="5%" class="valin">#</th>
                                    <th rowspan="2" class="valin">Course Information</th> 
									<th rowspan="2" width="5%" class="valin">Batch</th>
									<th rowspan="2"width="5%" class="valin">Sem</th>
									<th colspan="<?=count($ttdivisions);?>" style="text-align: -webkit-center;">Faculty Name</th>	
                                    <!--th width="10%">Mobile No.</th-->
                            </tr>
							<tr>
									<?php foreach($ttdivisions as $div){ ?>
										<th><?=$div['division'];?></th>	
									<?php } ?>								
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							$CI =& get_instance();
							$CI->load->model('Subject_model');
                            $j=1;
                            $fac_app =0;
                            //echo "<pre>";print_r($subject_details);
							if(!empty($subject_details)){
							foreach($subject_details as $sd)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>
								   
                                <td><?=$sd['subject_code']?>-<?=$sd['subject_name']?></td>
                                <td><?=$sd['batch']?></td>
								<td><?=$sd['semester']?></td>
                                
								<?php 
								foreach($ttdivisions as $div){
									$fc = $this->Subject_model->getSubFacDetails($sd['sub_id'], $sd['stream_id'],$sd['semester'],$div['division']);
								?>
								<td>
								<?php if(!empty($fc[0]['fname'])){ echo strtoupper($fc[0]['fname'].' '.$fc[0]['lname']);}else{ echo "-";}?><br>
									<?php if(!empty($fc[0]['mobile_no'])){ echo $fc[0]['mobile_no'];}else{ echo "-";}?><br> 
								</td>	
								<?php unset($fc);}?>
								
								
                            </tr>
                            <?php
                            $j++;
                            }
							}else{
								echo "<tr>";echo "<td colspan=7>";echo "No data found.";echo "</td>";echo "</tr>";
							}
                            ?>                            
                        </tbody>
                    </table>
					<a href="<?=base_url()?>subject/subject_handling_faculty_pdf/<?=$academicyear?>/<?=$streamId?>/<?=$semester?>/<?=$batch?>"><button class="btn btn-primary" >PDF</button>
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
	$('#stream_id').change(function () {
        var stream_id = $("#stream_id").val();
		var batch = $("#batch").val();

		if (stream_id) {
			$.ajax({
				'url' : base_url + '/Subject/load_semester',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'batch' : batch,stream_id:stream_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#semester'); //jquery selector (get element by id)
					if(data){	
						container.html(data);
					}
				}
			});
		}
    });	
		//

			var stream_id ='<?=$streamId?>';
			var batch = '<?=$batch?>';
			if (stream_id) {
				$.ajax({
					type: 'POST',
					'url' : base_url + '/Subject/load_semester',
					data: {'batch' : batch,stream_id:stream_id},
					success: function (html) {
						var semester = '<?=$semester?>';
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