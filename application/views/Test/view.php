<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" type="text/css"/>
<style>
	.table1{width: 120%;}
	table1{max-width: 120%;}
</style>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Time Table Master</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Lecture  Time Table <span class="panel-title"></span></h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php// if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/")?>"><span class="btn-label icon fa fa-plus"></span>Add Time table</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php //} ?>

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
					<form name="searchTT" id="forms" method="POST" action="<?=base_url()?>timetable/ttlist">
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
										echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session']. '"' . $sel . '>' . $yr['academic_year'] .' ('.$yr['academic_session'].')</option>';
									}
									?>
                               </select>

                              </div>
                              <div class="col-sm-2" >
                                <select name="course_id" id="course_id" class="form-control" required>
                                  <option value="">Select Course</option>
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
								<div class="col-sm-2"><input type="submit" class="btn btn-primary" value="Search"></div>
								
                            </div>
                              </form> 
					</div>
                </div>
                <div class="panel-body" style="">
				
                    <div class="table-info" >    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered" width="100%" id="search-table">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <!--th>Academic Year</th>
                                    <th>Stream Name</th>
                                    <th>Semester</th-->
									<th>Subject Batch</th>
                                    <th>Subject Name</th>
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
								<td><?=$tt_details[$i]['batch']?></td>								
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
								}else if($tt_details[$i]['subject_code']== 'IS'){
									echo "Internet Slot";
								}else if($tt_details[$i]['subject_code']== 'RC'){
									echo "Remedial Class";
								}else if($tt_details[$i]['subject_code']== 'EL'){
									echo "Experiential Learning";
								}else if($tt_details[$i]['subject_code']== 'SPS'){
									echo "Swayam Prabha Session";
								}else if($tt_details[$i]['subject_code']== 'ST'){
									echo "Spoken Tutorial";
								}else if($tt_details[$i]['subject_code']== 'FAM'){
									echo "Faculty Advisor Meet";
								}else{
									echo $tt_details[$i]['sub_code'].' - '.$tt_details[$i]['subject_name'];
								}
								?>
								</td>
                                <td><?=$tt_details[$i]['subject_type']?></td>
                                <td><?=$tt_details[$i]['division']?></td>
                                <td><?=$tt_details[$i]['batch_no']?></td>
                                <!--td><?=$tt_details[$i]['room_no']?></td-->
								<td><?=strtoupper($tt_details[$i]['fname'][0].'. '.$tt_details[$i]['mname'][0].'. '.$tt_details[$i]['lname']);?></td>
								<td><?=$tt_details[$i]['wday']?></td>
								<td><?=$tt_details[$i]['from_time']?> - <?=$tt_details[$i]['to_time']?> <?=$tt_details[$i]['slot_am_pm']?></td>
                                <td>
                                    <?php //if(in_array("Edit", $my_privileges)) { ?>
                                    <a href="<?=base_url($currentModule."/edit/".$tt_details[$i]['time_table_id'])?>">
									<i class="fa fa-edit"></i></a> |
									<a href="<?=base_url($currentModule."/removeTimetableEntry/".$tt_details[$i]['time_table_id'])?>" class="tt">
									<i class="fa fa-trash-o"></i></a> 
																		
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
							<li>You can update only Lecture Slot, Week Days</li>
							<li>After updating or Adding any records, Kindly verify the Faculty Allocation.</li>
						</ul>
					</div>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
 <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script>

	     $('#search-table').DataTable( {
        dom: 'Bfrtip',
        "bPaginate": false,
        buttons: [
           
            {
                extend: 'excelHtml5',
                exportOptions: {
                     columns: [ 0, 1, 2,3,4,5,6,7,8]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6,7,8]
                }
            },
            
        ]
    } );
	
</script>
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
	$('#academic_year').on('change', function () {
			var academic_year = $(this).val();
			if (academic_year) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttcources',
					data: {academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#course_id').html(html);
					}
				});
			} else {
				$('#course_id').html('<option value="">Select academic year first</option>');
			}
		});
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
			var course_id ='<?=$courseId?>';
			var academic_year ='<?=$academicyear?>';
			if (academic_year) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttcources',
					data: {academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#course_id').html(html);
						$("#course_id option[value='" + course_id + "']").attr("selected", "selected");
					}
				});
			}
			if (course_id) {
					$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Timetable/load_tt_streams',
						data: {course_id:course_id,academic_year:academic_year},
						'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
						var container = $('#stream_id'); //jquery selector (get element by id)
						if(data){
							var stream_id = '<?=$streamId?>';
							container.html(data);
							$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
						}
					}
				});
			}
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

		$('#course_id').on('change', function () {
			var academic_year =$("#academic_year").val();
			var course_id = $(this).val();
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Timetable/load_tt_streams',
					data: {course_id:course_id,academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#stream_id').html(html);
					}
				});
			} else {
				$('#stream_id').html('<option value="">Select course first</option>');
			}
		});
		
    });

</script>
<script>
  $("div.holder").jPages
  ({
    containerID : "itemContainer1"
  });
  $("#search_me").select2({
      placeholder: "Enter Time table name",
      allowClear: true
    });
        $("#search_me").on('change',function()
        {
            var search_val = $(this).val();            
            var url  = "<?=base_url().strtolower($currentModule).'/search/'?>";	
            var data = {title: search_val};		
            var type="";
            var type_name="";
            $.ajax
            ({
                type: "POST",
                url: url,
                data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {                       
                    var array=JSON.parse(data);
                    var str="";
                    for(i=0;i<array.tt_details.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                                
                        str+='<td>'+array.tt_details[i].campus_name+'</td>';
                        str+='<td>'+array.tt_details[i].college_code+'</td>';
                        str+='<td>'+array.tt_details[i].college_name+'</td>';
                        str+='<td>'+array.tt_details[i].college_state+'</td>';
                        str+='<td>'+array.tt_details[i].college_city+'</td>';                        
                        str+='<td>'+array.tt_details[i].college_pincode+'</td>';
                        str+='<td>'+array.tt_details[i].college_address+'</td>';
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+array.tt_details[i].college_id+'"><i class="fa fa-edit"></i></a>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/disable/'+array.tt_details[i].college_id+'"><i title="Disable" class="fa fa-ban"></i></a>';
                        str+='</td>';
                        str+='</tr>';
                        $("#itemContainer").html(str);
                    }
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
				$('.tt').click(function(){
			var checkstr =  confirm('Are you sure you want to delete this?');
			if(checkstr == true){
			  // do your code
			}else{
			return false;
			}
			});
</script>