<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>

<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />

<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />

<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<?php
$school_code = $this->uri->segment(7);
$faculty_arr = array();
foreach ($faculty_list as $value) {
	$faculty_arr[] = $value['emp_id'].", ".$value['fac_name'].", ".$value['department_name'].", ".$value['designation_name'];
}
$exfaculty_arr = array();
foreach ($exfaculty_list as $val) {
	$exfaculty_arr[] = $val['ext_faculty_code'].", ".$val['ext_fac_name'].", ".$val['ext_fac_designation'].", ".$val['ext_fac_mobile'];
}
 ?>
<script>    
 $(document).ready(function(){
	 $('#exam_date').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
	  $('#exam_date1').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
    //Assign php generated json to JavaScript variable
    var tempArray = <?php echo json_encode($faculty_arr); ?>;
	var extempArray = <?php echo json_encode($exfaculty_arr); ?>;
	//console.log(tempArray);
   //You will be able to access the properties as 
    //alert(tempArray[0]);
    var dataSrc = tempArray;
	var exdataSrc = extempArray;
    $(".faculty_search").autocomplete({
        source:dataSrc
    });
	$(".exfaculty_search").autocomplete({
        source:exdataSrc
    });
});
</script>

<?php

    $astrik='<sup class="redasterik" style="color:red">*</sup>';

	$tp = $this->uri->segment(3);
	$bkflag = $this->uri->segment(10);
	if(!empty($sub[0]['fname'])){

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

							<form id="form" name="form" action="<?=base_url($currentModule.'/insert_pract_subject_faculty')?>" method="POST" onsubmit="return validate_batch()">  

                                <input type="hidden" value="<?=$sub[0]['course_id']?>" id="course_id" name="course_id" />
								<?php //if($stream_id_bsc =='9'){ ?>
                                <input type="hidden" value="<?=$sub[0]['stream_id']?>" id="stream_id" name="stream_id" />
								<?php //}else{ ?>
									<!--input type="text" value="<?=$stream_id_bsc?>" id="stream_id" name="stream_id" /-->
								<?php// }?>
                                <input type="hidden" value="<?=$sub[0]['semester']?>" id="semester" name="semester" />
                                <input type="hidden" value="<?=$sub[0]['subject_id']?>" id="subject_id" name="subject_id" />
                                <input type="hidden" value="<?=$sub[0]['subject_component']?>" id="subject_component" name="subject_component" />
								 <input type="hidden" value="<?=$sub[0]['batch']?>" id="batch" name="batch" />
								 <?php if($bkflag==''){?>
								 <input type="hidden" value="<?=$sub[0]['division']?>" id="division" name="division" />
								 <input type="hidden" value="<?=$sub[0]['batch_no']?>" id="batch_no" name="batch_no" />
								 <?php }else{?>
								 <input type="hidden" value="A" id="division" name="division" />
								 <input type="hidden" value="1" id="batch_no" name="batch_no" />
								 <input type="hidden" value="Y" id="is_backlog" name="is_backlog" />
								 <?php }?>
                                <input type="hidden" value="<?=$exam_id?>" id="exam_id" name="exam_id" />
                                <input type="hidden" value="<?=$school_code?>" id="school_code" name="school_code" />


							<div class="form-group">
								<label class="col-sm-2"><b>Course Name: </b> </label>
                            	<div class="col-sm-4" ><?=$sub[0]['sub_code']?>-<?=$sub[0]['subject_name']?></div>
                                
                              	<label class="col-sm-2"><b>Stream: </b></label>
                              	<div class="col-sm-4" id="semest" ><?=$sub[0]['stream_name']?></div>	
                            </div>

                                <div class="form-group">
									<label class="col-sm-2"><b>Semester: </b></label>
									<div class="col-sm-4"><?=$sub[0]['semester']?></div>
																		
                                    <div class="col-sm-2"><b>Division/Batch:</b></div>
									<div class="col-sm-4"><?php if($bkflag==''){?><?=$sub[0]['division']?> / <?=$sub[0]['batch_no']?><?php }else{echo "A / 1";}?></div> 									
                                </div>

                               
                                <?php
                                if(!empty($sub[0]['fname'])){

                                    $ed1 ="Change";

                                }else{

                                    $ed1 ="Add";

                                }
										if(!empty($sub[0]['fname'])){ ?>
                               <div class="form-group">                     
                                    <label class="col-sm-2"><b>Faculty Name:</b></label>
                                    <div class="col-sm-4" style="text-align:left;">
                                    	
											<?php echo strtoupper($sub[0]['fname'][0].'. '.$sub[0]['mname'][0].'. '.$sub[0]['lname']);?>
                                    </div>                                 
                                </div>
                                <?php }?>
								
                                <div class="form-group">                     
                                    <label class="col-sm-2"><b><?=$ed1?> Faculty:</b></label>
                                    <div class="col-sm-4"><input type="text" class="form-control faculty_search" name="faculty" id="faculty_search" value="" <?php if(!empty($sub[0]['fname'])){ echo ""; }else{ ?>required <?php }?>>	
                                    </div>                                 
                                </div> 
								
<?php if(empty($sub[0]['ext_faculty_code']) && empty($sub[0]['exam_date'])){  ?>
															
                                <div class="clearfix"> <label class="col-sm-12"><b>External Faculty Details:</b></label></div><br>
								
								<!-- for external faculty--->	
								<!--div class="form-group">
								 <div class="col-sm-2">
									<input type="radio" name="filter" id="fltr" value="faculty"> Search 
									</div>
									<div class="col-sm-2">
									<input type="radio" name="filter" id="fltr1" value="add"> Add
								</div>
								</div-->
								<!--div id="filter1" style="display:none">
								<div class="form-group">                     
                                    <label class="col-sm-2"><b>Name:</b></label>
                                    <div class="col-sm-4"><input type="text" class="form-control" name="ext_fac_name" id="ext_fac_name" value="<?php if(!empty($sub[0]['ext_fac_name'])){ echo $sub[0]['ext_fac_name'];}?>" required>	
                                    </div>  
									<label class="col-sm-2"><b>Designation:</b></label>
                                    <div class="col-sm-4">
										<select class="form-control" name="ext_fac_designation" id="ext_fac_designation" required>
											<option value="">--select--</option>
											<option value="Assistant Professor">Assistant Professor</option>
											<option value="Associate Professor">Associate Professor</option>
											<option value="Professor">Professor</option>
										</select>
										
                                    </div>  									
                                </div>    
                                <div class="clearfix">&nbsp;</div>
								<div class="form-group">                     
                                    <label class="col-sm-2"><b>Mobile:</b></label>
                                    <div class="col-sm-4"><input type="text" class="form-control" name="ext_fac_mobile" id="ext_fac_mobile" value="<?php if(!empty($sub[0]['ext_fac_mobile'])){ echo $sub[0]['ext_fac_mobile'];}?>" required>	
                                    </div>  
									<label class="col-sm-2"><b>Email:</b></label>
                                    <div class="col-sm-4"><input type="email" class="form-control" name="ext_fac_email" id="ext_fac_email" value="<?php if(!empty($sub[0]['ext_fac_email'])){ echo $sub[0]['ext_fac_email'];}?>" required>	
                                    </div>  									
                                </div>    
                                <div class="clearfix">&nbsp;</div>
								<div class="form-group">                     
                                    <label class="col-sm-2"><b>Institute Name:</b></label>
                                    <div class="col-sm-4"><input type="text" class="form-control" name="ext_fac_institute" id="ext_fac_institute" value="<?php if(!empty($sub[0]['ext_fac_institute'])){ echo $sub[0]['ext_fac_institute'];}?>" required>	
                                    </div>  
							 									
                                </div>
								<div class="clearfix">&nbsp;</div>
						</div>	
						<div id="filter2" style="display:none">
							 <div class="form-group">                     
                                    <label class="col-sm-2"><b> External Faculty:</b></label>
                                    <div class="col-sm-4"><input type="text" class="form-control exfaculty_search" name="exfaculty" id="exfaculty" value="" required>	
                                    </div>                                 
                                </div>
						</div-->
						<div class="form-group">                     
                                    <label class="col-sm-2"><b>Add External Faculty:</b></label>
                                    <div class="col-sm-4"><input type="text" class="form-control exfaculty_search" name="exfaculty" id="exfaculty" value="" required>	
                                    </div>                                 
                                </div>
                                <div class="clearfix">&nbsp;</div>
								<div class="clearfix"> <label class="col-sm-12"><b>Date and Time Details:</b></label></div><br>
								<!-- for external faculty--->							
								<div class="form-group">                     
                                    <label class="col-sm-1"><b>Date:</b></label>
                                    <div class="col-sm-2"><input type="text" class="form-control" name="exam_date" id="exam_date" required>	
                                    </div>  
									<label class="col-sm-1"><b>From:</b></label>
                                    <div class="col-sm-2">
									<select class="form-control" name="exam_from_time" id="exam_from_time" required>	
										<option value="">--Select--</option>
										<?php for($i=1;$i<=12; $i++){?>
										<option value="<?=$i?>"><?=$i?>:00</option>
										<?php }?>
										</select>
                                    </div>  
								<label class="col-sm-1"><b>To:</b></label>
                                    <div class="col-sm-2">
									<select class="form-control" name="exam_to_time" id="exam_to_time" required>	
										<option value="">--Select--</option>
										<?php for($j=1;$j<=12; $j++){?>
										<option value="<?=$j?>"><?=$j?>:00</option>
										<?php }?>
										</select>
                                    </div> 	
                                    <div class="col-sm-2">
									<select class="form-control" name="time_format" id="time_format" required>	
										<option value="">--Select--</option>						
										<option value="AM">AM</option>
										<option value="PM">PM</option>
										</select>
                                    </div> 									
                                </div>    
                                <div class="clearfix">&nbsp;</div>
<?php }else{?>

<input type="hidden" value="<?php if(!empty($sub[0]['ext_faculty_code'])){ echo $sub[0]['ext_faculty_code'];}?>" id="ext_faculty_code" name="ext_faculty_code" />
<input type="hidden" value="<?php if(!empty($sub[0]['exam_pract_fact_id'])){ echo $sub[0]['exam_pract_fact_id'];}?>" id="exam_pract_fact_id" name="exam_pract_fact_id" />
								<input type="hidden" value="<?php if(!empty($sub[0]['exam_date'])){ echo $sub[0]['exam_date'];}?>" id="exam_date" name="exam_date" />
								<input type="hidden" value="<?php if(!empty($sub[0]['exam_from_time'])){ echo $sub[0]['exam_from_time'];}?>" id="exam_from_time" name="exam_from_time" />
								<input type="hidden" value="<?php if(!empty($sub[0]['exam_to_time'])){ echo $sub[0]['exam_to_time'];}?>" id="exam_to_time" name="exam_to_time" />
								<input type="hidden" value="<?php if(!empty($sub[0]['time_format'])){ echo $sub[0]['time_format'];}?>" id="	time_format" name="time_format" />	
<div class="clearfix"> <label class="col-sm-12"><b>External Faculty Details:</b></label></div><br>
								<!-- for external faculty--->	
<div class="form-group">                     
                                    <label class="col-sm-2"><b> Change External Faculty:</b></label>
                                    <div class="col-sm-4"><input type="text" class="form-control exfaculty_search" name="change_exfaculty" id="exfaculty" value="">	
                                    </div>                                 
                                </div>								
								<div class="form-group">                     
                                    <label class="col-sm-2"><b>Code/Name:</b></label>
                                    <div class="col-sm-4"><?php if(!empty($sub[0]['ext_fac_name'])){ echo $sub[0]['ext_faculty_code'].', '.$sub[0]['ext_fac_name'];}?></div>  
									<label class="col-sm-2"><b>Designation:</b></label>
                                    <div class="col-sm-4"><?php if(!empty($sub[0]['ext_fac_designation'])){ echo $sub[0]['ext_fac_designation'];}?>
                                    </div>  									
                                </div>    
                                <div class="clearfix">&nbsp;</div>
								<div class="form-group">                     
                                    <label class="col-sm-2"><b>Mobile:</b></label>
                                    <div class="col-sm-4"><?php if(!empty($sub[0]['ext_fac_mobile'])){ echo $sub[0]['ext_fac_mobile'];}?>	
                                    </div>  
									<label class="col-sm-2"><b>Email:</b></label>
                                    <div class="col-sm-4"><?php if(!empty($sub[0]['ext_fac_email'])){ echo $sub[0]['ext_fac_email'];}?>
                                    </div>  									
                                </div>    
                                <div class="clearfix">&nbsp;</div>
								<div class="form-group">                     
                                    <label class="col-sm-2"><b>Institute Name:</b></label>
                                    <div class="col-sm-4"><?php if(!empty($sub[0]['ext_fac_institute'])){ echo $sub[0]['ext_fac_institute'];}?>
                                    </div>  
							 									
                                </div>    
                                <div class="clearfix">&nbsp;</div>	
								<div class="clearfix"> <label class="col-sm-12"><b>Date and Time Details:</b></label></div><br>
								<!-- for external faculty--->							
								<!--div class="form-group">                     
                                    <label class="col-sm-1"><b>Date:</b></label>
									<div class="col-sm-4"><?php if(!empty($sub[0]['exam_date'])){ echo $sub[0]['exam_date'];}?> 	
                                    </div>  
									<label class="col-sm-1"><b>Time:</b></label>
                                    <div class="col-sm-2">
									<?php if(!empty($sub[0]['exam_from_time'])){ echo $sub[0]['exam_from_time'];}?>:00 -<?php if(!empty($sub[0]['exam_to_time'])){ echo $sub[0]['exam_to_time'];}?>:00 <?php if(!empty($sub[0]['time_format'])){ echo $sub[0]['time_format'];}?>
									
                                    </div>  
																	
                                </div-->  
<div class="form-group">                     
                                    <label class="col-sm-1"><b>Date:</b></label>
                                    <div class="col-sm-2"><input type="text" class="form-control" name="exam_date" id="exam_date1" value="<?php if(!empty($sub[0]['exam_date'])){ echo $sub[0]['exam_date'];}?>"required>	
                                    </div>  
									<label class="col-sm-1"><b>From:</b></label>
                                    <div class="col-sm-2">
									<select class="form-control" name="exam_from_time" id="exam_from_time" required>	
										<option value="">--Select--</option>
										<?php for($i=1;$i<=12; $i++){?>
										<option value="<?=$i?>" <?php if(!empty($sub[0]['exam_from_time']) && $sub[0]['exam_from_time']==$i){ echo "selected";}?>><?=$i?>:00</option>
										<?php }?>
										</select>
                                    </div>  
								<label class="col-sm-1"><b>To:</b></label>
                                    <div class="col-sm-2">
									<select class="form-control" name="exam_to_time" id="exam_to_time" required>	
										<option value="">--Select--</option>
										<?php for($j=1;$j<=12; $j++){?>
										<option value="<?=$j?>" <?php if(!empty($sub[0]['exam_to_time']) && $sub[0]['exam_to_time']==$j){ echo "selected";}?>><?=$j?>:00</option>
										<?php }?>
										</select>
                                    </div> 	
                                    <div class="col-sm-2">
									<select class="form-control" name="time_format" id="time_format" required>	
										<option value="">--Select--</option>						
										<option value="AM" <?php if(!empty($sub[0]['time_format']) && $sub[0]['time_format']=='AM'){ echo "selected";}?>>AM</option>
										<option value="PM" <?php if(!empty($sub[0]['time_format']) && $sub[0]['time_format']=='PM'){ echo "selected";}?>>PM</option>
										</select>
                                    </div> 									
                                </div>    								
                                <div class="clearfix">&nbsp;</div>
<?php }?>
								<!--external fac end---------->
								
								
                                <div class="form-group">
                                    <div class="col-sm-2"></div>

                                    <div class="col-sm-1">
										<button class="btn btn-primary form-control" id="btn_submit" type="submit" >Assign</button> 
									</div>                                    

                                    <div class="col-sm-1"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/assign_prac_faculty/<?=$sub[0]['stream_id']?>/<?=$sub[0]['semester']?>/<?=$sub[0]['course_id']?>/<?=$sub[0]['school_code']?>/<?=$sub[0]['batch_no']?>/<?=$sub[0]['acd_year']?>'">Back</button></div>

                                    <div class="col-sm-4"></div>

                                </div>

                            </form>

                            <?php //} ?>

                        </div>

                    </div>

                </div>

            </div>    

        </div>
<script type="text/javascript">
    $(document).ready(function(){
        $("input[type='radio']").click(function(){
            var radioValue = $("input[name='filter']:checked").val();
            if(radioValue=='faculty'){
				$("#ext_fac_name").val('');
                $("#filter1").hide();
				$("#filter2").show();
				$("#exfaculty").removeAttr('disabled');
				$("#ext_fac_name").prop("disabled", "disabled");
				$("#ext_fac_designation").prop("disabled", "disabled");
				$("#ext_fac_mobile").prop("disabled", "disabled");
				$("#ext_fac_email").prop("disabled", "disabled");
				$("#ext_fac_institute").prop("disabled", "disabled");
				
            }else{
				$("#exfaculty").val('');
				$("#filter2").hide();
				$("#filter1").show();
				$("#ext_fac_name").removeAttr('disabled');
				$("#ext_fac_designation").removeAttr('disabled');
				$("#ext_fac_mobile").removeAttr('disabled');
				$("#ext_fac_email").removeAttr('disabled');
				$("#ext_fac_institute").removeAttr('disabled');
				$("#exfaculty").prop("disabled", "disabled");
			}
        });
        
    });
</script>		