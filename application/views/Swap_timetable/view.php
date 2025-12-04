<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" type="text/css"/>
<!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- jQuery (Ensure it's included before Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Swap Time Table Faculty <span class="panel-title"></span></h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php// if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"></div>                        
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
							$empid=$this->session->userdata('name');
											$emp_name=$this->session->userdata('emp_name');
											$roles_id=$this->session->userdata('roles_id');
							if ($this->session->flashdata('Tmessage') != ''): 
								echo $this->session->flashdata('Tmessage'); 
							endif;
							?>
						</div>
					</div>
					<div class="row">
					<form name="searchTT" id="forms" method="POST" action="<?=base_url()?>swap_timetable/index">
						<div class="form-group">
							<div class="col-sm-2" >

                                <select name="academic_year" id="academic_year" class="form-control" required>
                                  <option value="">Select Academic Year</option>
                                  <?php
									foreach ($academic_year as $yr) {
										if ($yr['academic_year'].'~'.$yr['academic_session'] == $academicyear) {
											$sel = "selected";
										} else {
											$sel = 'selected';
										}
										echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session']. '"' . $sel . '>' . $yr['academic_year'] .' ('.$yr['academic_session'].')</option>';
									}
									?>
									<?php
									//if($this->session->userdata('name')=='110074'){
										//echo '<option value="2022-23~WINTER">2022-23 (WINTER)</option>';
									//}?>
                               </select>

                              </div>
								<div class="col-sm-2">
									<input type="date" name="date" id="date" class="form-control" minlength="<?=date('Y-m-d')?>" value="<?=isset($ddate)?$ddate:date('Y-m-d');?>">
								</div>
								<div class="col-sm-2">
									<select id="faculty" name="faculty" class="form-control select2" >
											<option value="">Select Faculty</option>
											<?php
											
												if($roles_id !=3 && $roles_id !=21){
												foreach($faculty as $fac){
													if($fac['emp_id']== $faculty_id){
															$sel = "selected";
														}
														elseif($faculty_id=='ALL'){
														 	$sel = "";
														} 
														else{
														 	$sel = "";
														} 
													echo '<option value="'.$fac['emp_id'].'"' . $sel . '>'.$fac['fname'].' '.$fac['mname'].' '.$fac['lname'].'</option>';
												}
												}else{
													echo '<option value="'.$empid.'"' . $sel . '>'.$emp_name.'</option>';
												}
												
												if($roles_id==6){
													//echo '<option value="ALL"' . $sel . '>ALL</option>';
												}
											?>
									</select>
								</div>
								<div class="col-sm-2"><input type="submit" class="btn btn-primary" value="Search"></div>
								
                            </div>
                              </form> 
							  
					</div>
					 

					
                </div>
                <div class="panel-body" style="">
				
                    <div class="table-info table-responsive" >    
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
									<th>Alternet Subject</th>
                                    <th>Type</th>
                                    <th>Div</th>
									<th>Batch</th>
                                    <!--th>Room No</th-->
									<th>Faculty</th>
									<th>Alternet Faculty</th>
									<th>Day</th>
									<th>Date</th>
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
								}else if($tt_details[$i]['subject_code']== 'Soft Skill'){
									echo "Soft Skill";
								}else if($tt_details[$i]['subject_code']== 'Basic Aptitude Training'){
									echo "Basic Aptitude Training";
								}else if($tt_details[$i]['subject_code']== 'Advanced Aptitude Training'){
									echo "Advanced Aptitude Training";
								}else if($tt_details[$i]['subject_code']== 'Value Added Course'){
									echo "Value Added Course";
								}else if($tt_details[$i]['subject_code']== 'Certificate Course'){
									echo "Certificate Course";
								}else{
									echo $tt_details[$i]['sub_code'].' - '.$tt_details[$i]['subject_name'];
								}
								?>
								</td>
								<td><?php
								
								if($tt_details[$i]['sub_id'] != $tt_details[$i]['asub_id'] && $tt_details[$i]['asub_id'] != ''){

								echo $tt_details[$i]['asub_code'].' - '.$tt_details[$i]['asubject_name']; 
								
								}else{
									echo '-';
								} ?></td>
                                <td><?=$tt_details[$i]['subject_type']?></td>
                                <td><?=$tt_details[$i]['division']?></td>
                                <td><?=$tt_details[$i]['batch_no']?></td>
                                <!--td><?=$tt_details[$i]['room_no']?></td-->
								<td><?=strtoupper($tt_details[$i]['fname'].'. '.$tt_details[$i]['mname'].'. '.$tt_details[$i]['lname']);?><?=$tt_details[$i]['faculty_code']?></td>
								<td><?=strtoupper($tt_details[$i]['afname'].' '.$tt_details[$i]['amname'].' '.$tt_details[$i]['alname']);?><?=$tt_details[$i]['afaculty_code']?></td>
								<td><?=$tt_details[$i]['wday']?></td>
								<td><?=$tt_details[$i]['dt_date']?></td>
								<td><?=$tt_details[$i]['from_time']?> - <?=$tt_details[$i]['to_time']?> <?=$tt_details[$i]['slot_am_pm']?></td>
                                <td>
                                    <?php //if(in_array("Edit", $my_privileges)) { ?>
									                <!-- Swap Icon -->
									<a href="javascript:void(0);" class="swap-icon" data-toggle="modal" data-target="#swapModal" 
										data-timetableid="<?=$tt_details[$i]['time_table_id']?>"
										data-facultyid="<?=$tt_details[$i]['faculty_code']?>"
										data-subjectcode="<?=$tt_details[$i]['sub_id']?>"
										data-div="<?=$tt_details[$i]['division']?>"
										data-batch="<?=$tt_details[$i]['batch_no']?>"
										data-academicyear="<?=$tt_details[$i]['academic_year']?>"
										data-academicsession="<?=$tt_details[$i]['academic_session']?>"
										data-subtype="<?=$tt_details[$i]['subject_component']?>"
										data-subcode="<?=$tt_details[$i]['subject_code']?>"
										data-courseid="<?=$tt_details[$i]['course_id']?>"
										data-streamid="<?=$tt_details[$i]['stream_id']?>"
										data-semester="<?=$tt_details[$i]['semester']?>"
										data-ddate="<?=$ddate?>"
										data-lectslot="<?=$tt_details[$i]['lecture_slot']?>"
										>
										<i class="fa fa-exchange"></i>
									</a>
																		
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
<?php
                           
							if(!empty($tt_details)){	?>				
					<div class="col-sm-2">
                                                                <button type="button" id="download-pdf" class="btn btn-danger">Download PDF</button>
                                                        </div>
							<?php }?>
					<!-- Swap Modal -->
<div class="modal fade" id="swapModal" tabindex="-1" role="dialog" aria-labelledby="swapModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="swapModalLabel">Swap Faculty</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="swapForm" action="<?=base_url().'Swap_timetable/swap_faculty_subjects'?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="timetable_id" name="timetable_id">
					<input type="hidden" id="div" name="division">
					<input type="hidden" id="sem" name="semester">
					<input type="hidden" id="btch" name="batch">
					<input type="hidden" id="academic_yr" name="academic_year">
					<input type="hidden" id="cours" name="course">
					<input type="hidden" id="strid" name="stream_id">
					<input type="hidden" id="academic_ssn" name="academic_session">
					<input type="hidden" id="sub_type" name="sub_type">
					<input type="hidden" id="sub_code" name="sub_code">
					<input type="hidden" id="lect_slot" name="lect_slot">
					<input type="hidden" id="ddate" name="date">



                    <div class="form-group">
                        <label for="faculty">Select Faculty</label>
						<select id="faculty_id" name="faculty_id" class="form-control select2" >
								<option value="">Select Faculty</option>
								<?php 
									foreach($faculty as $fac){
									/*	if($fac['emp_id']==$faculty){
												$sel = "selected";
											}else{
											 	$sel = "";
											} */
										echo '<option value="'.$fac['emp_id'].'">'.$fac['fname'].' '.$fac['mname'].' '.$fac['lname'].'</option>';
									}
								?>
						</select>
                    </div>

                    <div class="form-group">
                        <label for="subject">Select Subject</label>
                        <select id="subject" name="subject" class="form-control">
                            <option value="">Select Subject</option>
                            <?php 
                                foreach($subjects as $sub){
                                    echo '<option value="'.$sub['subject_code'].'">'.$sub['subject_name'].'</option>';
                                }
                            ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Swap</button>
                </div>
            </form>
        </div>
    </div>
</div>


                    <?php //} ?>
										<div>
						<!--<b>NOTE:</b>
						<ul>
							<li>You can update only Lecture Slot, Week Days</li>
							<li>After updating or Adding any records, Kindly verify the Faculty Allocation.</li>
						</ul> -->
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

$(document).ready(function() {
    $('#faculty').select2({
        placeholder: "Select Faculty",
        allowClear: true
    });
});
$(document).ready(function(){
    $(".swap-icon").click(function(){
        // Fetch all data attributes from clicked swap icon
        var timetableId = $(this).data("timetableid");
        var facultyId = $(this).data("facultyid");
        var subjectCode = $(this).data("subjectcode");
        var division = $(this).data("div");
        var batch = $(this).data("batch");
        var academicYear = $(this).data("academicyear");
		var academicSession = $(this).data("academicsession");
        var courseId = $(this).data("courseid");
        var streamId = $(this).data("streamid");
        var semester = $(this).data("semester");
        var ddate = $(this).data("ddate");
		var subtype = $(this).data("subtype");
		var subcode = $(this).data("subcode");
		var lectslot = $(this).data("lectslot");
		

        // Set hidden fields in the form
        $("#timetable_id").val(timetableId);
        $("#faculty_id").val(facultyId);
        $("#subject").val(subjectCode);
		$("#div").val(division);
		$("#btch").val(batch);
		$("#academic_yr").val(academicYear);
		$("#academic_ssn").val(academicSession);
		$("#cours").val(courseId);
		$("#strid").val(streamId);
		$("#sem").val(semester);
		$("#sub_type").val(subtype);
		$("#sub_code").val(subcode);
		$("#lect_slot").val(lectslot);
		$("#ddate").val(ddate);
		//$("#academic_ssn").val(academic_ssn);

        // Fetch faculty and subject options dynamically via AJAX
        $.ajax({
            url: "<?=base_url().'Swap_timetable/fetch_faculty_swap'?>", // Replace with actual endpoint
            type: "POST",
            data: {
                timetable_id: timetableId,
                faculty_id: facultyId,
                subject_code: subjectCode,
                division: division,
                batch: batch,
                academic_year: academicYear,
                academic_ssn: academicSession,
                course_id: courseId,
                stream_id: streamId,
                semester: semester,
                date: ddate
            },
            success: function(response){
                // Assuming response is a JSON object with 'faculty' and 'subjects' arrays
                if(response.success){
                    var facultyOptions = '<option value="">Select Faculty</option>';
                    $.each(response.faculty, function(index, fac){
                        var selected = fac.emp_id == facultyId ? "selected" : "";
                        facultyOptions += '<option value="'+fac.emp_id+'" '+selected+'>'+fac.emp_id+'-'+fac.fname+' '+fac.mname+' '+fac.lname+'</option>';
                    });

                    var subjectOptions = '<option value="">Select Subject</option>';
                    $.each(response.subjects, function(index, sub){
                        var selected = sub.sub_id == subjectCode ? "selected" : "";
                        subjectOptions += '<option value="'+sub.sub_id+'" '+selected+'>'+sub.subject_name+'</option>';
                    });

                    // Update dropdowns
                    $("#faculty_id").html(facultyOptions).trigger("change");
                    $("#subject").html(subjectOptions);
                } else {
                    alert("Error fetching faculty and subjects.");
                }
            },
            error: function(){
                alert("Error fetching data.");
            }
        });
    });

    $("#swapForm").submit(function(e){
        e.preventDefault(); // Prevent default form submission
        
        $.ajax({
            url: $(this).attr("action"),
            type: "POST",
            data: $(this).serialize(),
            success: function(response){
                alert("Swap Successful!");
                location.reload();
            },
            error: function(){
                alert("Error swapping faculty.");
            }
        });
    }); 
});


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
        $(document).ready(function () {
                $("#download-pdf").click(function () {
                        var faculty = $("#faculty").val();
                        var academic_year = $("#academic_year").val();
                        var date = $("#date").val();

                        if (faculty === "" || academic_year === "" || date === "") {
                                alert("Please select all required filters.");
                                return false;
                        }

                        var pdf_url = "<?= base_url('swap_timetable/generate_pdf') ?>?faculty=" + faculty + "&academic_year=" + academic_year + "&date=" + date;
                        window.open(pdf_url); // Open the PDF directly in the browser
                });
        });


        /*    document.addEventListener("DOMContentLoaded", function() {
                        var today = new Date().toISOString().split("T")[0];
                        document.getElementById("date").setAttribute("min", today);
                }); */
</script>


