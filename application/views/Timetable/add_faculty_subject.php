<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>

<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />

<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />

<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<?php 
$faculty_arr = array();
foreach ($faculty_list as $value) {
	$faculty_arr[] = $value['emp_id'].", ".$value['fac_name'].", ".$value['department_name'].", ".$value['designation_name'];
}
 ?>
<script>    
 $(document).ready(function(){
    //Assign php generated json to JavaScript variable
    var tempArray = <?php echo json_encode($faculty_arr); ?>;
	//console.log(tempArray);
   //You will be able to access the properties as 
    //alert(tempArray[0]);
    var dataSrc = tempArray;
 
    $(".faculty_search").autocomplete({
        source:dataSrc
    });
});
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

        <li class="active"><a href="#"><?=$ed?> Subject Faculty</a></li>

    </ul>

    <div class="page-header">			

        <div class="row">

            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;<?=$ed?> Subject Faculty</h1>

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

                    <div class="panel-heading" style="    background: #ffecb6 !important;
}">

                        <div class="row ">

						<div class="col-sm-3">

							<span class="panel-title">Subject Faculty</span>

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

							<form id="form" name="form" action="<?=base_url($currentModule.'/insert_subject_faculty')?>" method="POST" onsubmit="return validate_batch()">  
                                <input type="hidden" value="<?=$sub[0]['course_id']?>" id="course_id" name="course_id" />
                                <input type="hidden" value="<?=$sub[0]['stream_id']?>" id="stream_id" name="stream_id" />
                                <input type="hidden" value="<?=$sub[0]['semester']?>" id="semester" name="semester" />
                                <input type="hidden" value="<?=$sub[0]['division']?>" id="division" name="division" />
								<input type="hidden" value="<?=$reporttype?>" id="reporttype" name="reporttype" />
                                <input type="hidden" value="<?=$sub[0]['subject_code']?>" id="subject_id" name="subject_id" />
                                <input type="hidden" value="<?=$sub[0]['batch_no']?>" id="batch_no" name="batch_no" />
								<input type="hidden" value="<?=$school_code?>" id="school_code" name="school_code" />
                                <input type="hidden" value="<?=$sub[0]['academic_year']?>" id="academic_year" name="academic_year" />
                                <input type="hidden" value="<?=$sub[0]['academic_session']?>" id="academic_session" name="academic_session" />
                                <input type="hidden" value="<?=$sub[0]['subject_component']?>" id="subject_component" name="subject_component" />


							<div class="form-group">
								<label class="col-sm-2"><b>Course Name:</b> </label>
                            	<div class="col-sm-3" ><?=$sub[0]['sub_code']?>-<?=$sub[0]['subject_name']?></div>
                                <div class="col-sm-2"></div>
                              	<label class="col-sm-1"><b>Stream:</b></label>
                              	<div class="col-sm-3" id="semest" ><?=$sub[0]['stream_name']?></div>	
                            </div>

                                <div class="form-group">
									<label class="col-sm-2"><b>Semester:</b></label>
									<div class="col-sm-3"><?=$sub[0]['semester']?></div> 
                                    <div class="col-sm-2"></div>
									<label class="col-sm-1"><b>Division:</b></label>
									<div class="col-sm-3"><?=$sub[0]['division']?></div> 									
                                </div>


                                <div class="form-group">
                                	<label class="col-sm-2"><b>Subject Type:</b></label>                                    
									<div class="col-sm-3"><?php if($sub[0]['subject_component']=='TH'){ echo "Theory";}else{ echo 'Practical';}?></div>
                                    <div class="col-sm-2"></div>
									<label class="col-sm-1"><b>Batch:</b></label>                                    
									<div class="col-sm-3"><?php if($sub[0]['batch_no']==0){ echo "-";}else{ echo $sub[0]['batch_no'];}?></div>  
                                </div>                                
                                <?php
										if(!empty($sub[0]['fname'])){ ?>
                               <div class="form-group">                     
                                    <label class="col-sm-2"><b>Faculty Name:</b></label>
                                    <div class="col-sm-10" style="text-align:left;">
                                    	
											<?php echo strtoupper($sub[0]['fname'][0].'. '.$sub[0]['mname'][0].'. '.$sub[0]['lname']);?>
                                    </div>                                 
                                </div>
                                <?php }?>
                                <div class="form-group">                     
                                    <label class="col-sm-2"><b>Change Faculty:</b></label>
                                    <div class="col-sm-10"><input type="text" class="form-control faculty_search" name="faculty" id="faculty_search" value="" style="width: 500px;">
                                    	
                                    </div>                                 
                                </div>

                                

                                <div class="clearfix">&nbsp;</div>

                                <div class="form-group">

                                    <div class="col-sm-4"></div>

                                    <div class="col-sm-2">
										<button class="btn btn-primary form-control" id="btn_submit" type="submit" >Assign</button> 
									</div>                                    

                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/assign_faculty/<?=$sub[0]['stream_id']?>/<?=$sub[0]['semester']?>/<?=$sub[0]['division']?>/<?=$academicyear?>/<?=$sub[0]['course_id']?>/<?=$school_code?>/<?=$reporttype?>'">Cancel</button></div>

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

                    <div class="table-info table-responsive" style="overflow:scroll;height:400px;">    

                    <?php //if(in_array("View", $my_privileges)) { ?>

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                    <th>#</th>

                                    <!--th>Academic Year</th>

                                    <th>Stream Name</th>

                                    <th>Semester</th-->

                                    <th>Subject Name</th>

                                    <th>Type</th>

                                    <th>Division</th>

									<th>Batch No</th>

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

                </div>

                </div>

            </div>

	</div>

</div>	

<?php }?>

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

 <!-- #end model -->		