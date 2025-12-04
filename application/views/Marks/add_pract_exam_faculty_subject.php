<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>

<style>
/* ====== Modern Form Design ====== */
body {
  background-color: #f8fafc;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  color: #333;
}

.panel {
  border: none;
  border-radius: 10px;
  box-shadow: 0px 3px 15px rgba(0,0,0,0.1);
}

.panel-heading {
  background: linear-gradient(to right, #4b6cb7, #182848); !important;
  color: #fff !important;
  border-top-left-radius: 10px !important;
  border-top-right-radius: 10px !important;
  padding: 15px 20px !important;
  font-weight: 600 !important;
  font-size: 16px !important;
}

.panel-title {
  font-size: 18px;
  color: #fff;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* ====== Form Structure ====== */
.form-group label {
  font-weight: 600;
  color: #374151;
  margin-top: 5px;
}

.form-control {
  border-radius: 6px;
  border: 1px solid #d1d5db;
  box-shadow: none;
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 4px rgba(59,130,246,0.4);
}

/* ====== Buttons ====== */
.btn-primary {
  background: linear-gradient(90deg, #3b82f6, #2563eb);
  border: none;
  border-radius: 6px;
  transition: all 0.3s ease;
}

.btn-primary:hover {
  background: linear-gradient(90deg, #2563eb, #1d4ed8);
  transform: translateY(-1px);
}

.btn-primary:active {
  background: #1e40af;
  transform: translateY(0);
}

.redasterik {
  color: #ef4444 !important;
}

/* ====== Breadcrumb ====== */
.breadcrumb-page {
  background: #fff;
  border-radius: 6px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
  padding: 10px 15px;
}

.breadcrumb-page li a {
  color: #2563eb;
  font-weight: 500;
}

.breadcrumb-page li.active a {
  color: #111827;
  font-weight: 600;
}

/* ====== Headings ====== */
.page-header {
  border-bottom: none;
  margin-bottom: 10px;
}

.page-header-icon {
  color: #2563eb;
}

/* ====== Table Info / Panel Body ====== */
.table-info, .panel-body {
  background-color: #ffffff;
  border-radius: 0 0 10px 10px;
  padding: 20px 25px;
}

/* ====== Section Titles ====== */
label.col-sm-12 {
  background: #f3f4f6;
  padding: 8px 10px;
  border-radius: 6px;
  font-size: 15px;
  font-weight: 600;
  color: #374151;
  border-left: 4px solid #2563eb;
}

/* ====== Flash Messages ====== */
.col-sm-9[style*="color:red"] {
  background: #fee2e2;
  padding: 8px 10px;
  border-radius: 5px;
}

.col-sm-9[style*="color:green"] {
  background: #dcfce7;
  padding: 8px 10px;
  border-radius: 5px;
}

/* ====== Datepicker & Autocomplete Fields ====== */
.ui-autocomplete {
  z-index: 1051;
  max-height: 200px;
  overflow-y: auto;
  overflow-x: hidden;
  background: #fff;
  border: 1px solid #d1d5db;
  border-radius: 6px;
}

.ui-menu-item {
  padding: 8px 12px;
  cursor: pointer;
  transition: background 0.2s ease;
}

.ui-menu-item:hover {
  background: #eff6ff;
}
.btn-primary {
  background: linear-gradient(to right, #5d8fff, #0037a5) !important;
  border: none !important;
}
.btn-primary:hover {
  background: linear-gradient(to right, #3e5ca4, #152043) !important;
}
/* ====== Responsive ====== */
@media (max-width: 768px) {
  .form-group label {
    text-align: left !important;
    margin-bottom: 5px;
  }
  .breadcrumb-page {
    font-size: 13px;
  }
  .panel-title {
    font-size: 16px;
  }
}
</style>


<?php
$school_code = $this->uri->segment(7);
$lab_arr = array();
foreach ($labs as $lab) {
    $lab_arr[] = $lab['id'] . ", " . $lab['building_name'] . ", " . $lab['hall_no'] . " - " . $lab['lab_name'] . " #Capacity : " . $lab['capacity'];
}

$faculty_arr = array();
foreach ($faculty_list as $value) {
	$faculty_arr[] = $value['emp_id'].", ".$value['fac_name'].", ".$value['department_name'].", ".$value['designation_name'];
}
$peon_arr = array();
foreach ($peon_list as $value) {
	$peon_arr[] = $value['emp_id'].", ".$value['fac_name'].", ".$value['department_name'].", ".$value['designation_name'];
}
$exfaculty_arr = array();
foreach ($exfaculty_list as $val) {
	$exfaculty_arr[] = $val['ext_faculty_code'].", ".$val['ext_fac_name'].", ".$val['ext_fac_designation'].", ".$val['ext_fac_mobile'];
}
$lab_assist_arr = array();
foreach ($lab_assist_list as $value) {
	$lab_assist_arr[] = $value['emp_id'].", ".$value['fac_name'].", ".$value['department_name'].", ".$value['designation_name'];
}
 ?>
<script>    
 $(document).ready(function(){
	 $('#exam_date').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
	  $('#exam_date1').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
    //Assign php generated json to JavaScript variable
    var tempArray = <?php echo json_encode($faculty_arr); ?>;
    var peonArray = <?php echo json_encode($peon_arr); ?>;
	var extempArray = <?php echo json_encode($exfaculty_arr); ?>;
	var lab_assist_arr = <?php echo json_encode($lab_assist_arr); ?>;
	//console.log(tempArray);
   //You will be able to access the properties as 
    //alert(tempArray[0]);
    var dataSrc = tempArray;
    var peondataSrc = peonArray;
	var exdataSrc = extempArray;
	var labdataSrc = lab_assist_arr;
	var labArray = <?php echo json_encode($lab_arr); ?>;
	
	$(".lab_search").autocomplete({
		source: labArray,
		select: function (event, ui) {
			$('#lab_id').val(ui.item.value.split(',')[0]); // store lab_code as ID
		}
	
	});
    $(".faculty_search").autocomplete({
        source:dataSrc
    }); 
	$(".peon_search").autocomplete({
        source:peondataSrc
    });
	$(".exfaculty_search").autocomplete({
        source:exdataSrc
    });
	$(".lab_assist_search").autocomplete({
        source:labdataSrc
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

                    <div class="panel-heading">

                        <div class="row ">

						<div class="col-sm-3">

							<span class="panel-title"><?=$ed?> Subject Faculty</span>

						</div>	

							<?php

							if ($this->session->flashdata('dup_msg') != ''){

							?>

							<div class="col-sm-9">

						

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

							<div class="col-sm-9">

							

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

							<form id="form" name="form" action="<?=base_url($currentModule.'/insert_pract_subject_faculty')?>" method="POST" onsubmit="return confirmSubmit();">  

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
								 <?php if($bkflag==''){
									  // if($school_code=='1002'){
										//	$batch=0;
										// }else{
										 	$batch=$sub[0]['batch_no'];
										// }
									 ?>
								 <input type="hidden" value="<?=$sub[0]['division']?>" id="division" name="division" />
								 <input type="hidden" value="<?=$batch?>" id="batch_no" name="batch_no" />
								 <?php }else{
									     if($school_code=='1002'){
											$batch=0;
										 }else{
											$batch=1;
										 }
									 ?>
								 <input type="hidden" value="A" id="division" name="division" />
								 <input type="hidden" value="<?=$batch?>" id="batch_no" name="batch_no" />
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
							<div class="form-group">
								<label class="col-sm-2"><b>Subject Category:</b></label>
                                <div class="col-sm-4">
									<select class="form-control" name="subject_category" id="subject_category" required>	
										<option value="">--Select--</option>
										<option value="practical" 	 <?php if(!empty($sub[0]['subject_category']) && $sub[0]['subject_category']=="practical"){ echo "selected";}?> >Practical</option>
										<option value="project"   	 <?php if(!empty($sub[0]['subject_category']) && $sub[0]['subject_category']=="project"){ echo "selected";}?> >Project</option>
										<option value="viva"      	 <?php if(!empty($sub[0]['subject_category']) && $sub[0]['subject_category']=="viva"){ echo "selected";}?> >Viva Voce</option>
										<option value="dissertation" <?php if(!empty($sub[0]['subject_category']) && $sub[0]['subject_category']=="dissertation"){ echo "selected";}?> >Dissertation</option>
										<option value="seminar" <?php if(!empty($sub[0]['subject_category']) && $sub[0]['subject_category']=="seminar"){ echo "selected";}?> >Seminar</option>
									</select>
                                </div>  
                            <div class="clearfix"> <label class="col-sm-12"><b>Lab Details:</b></label></div>
                           
							<?php if(empty($sub[0]['lab_name'])){ ?> 
							
									<label class="col-sm-2"><b>Select Lab:</b></label>
									<div class="col-sm-4">
										<input type="text" class="form-control lab_search" name="lab" id="lab_search" value="" required>
									</div>

							
							<?php }else{ ?> 
							</div>	
							<div class="form-group">                     
                                    <label class="col-sm-2"><b>Hall No./Lab Name:</b></label>
                                    <div class="col-sm-4"><?php if(!empty($sub[0]['lab_name'])){ echo $sub[0]['hall_no'].'/ '.$sub[0]['lab_name'];}?></div>  
									<label class="col-sm-2"><b>Capacity:</b></label>
                                    <div class="col-sm-4"><?php if(!empty($sub[0]['capacity'])){ echo $sub[0]['capacity'];}?>
                                    </div>  									
                            </div> 
							<div class="form-group">
								<label class="col-sm-2"><b>Change Lab:</b></label>
								<div class="col-sm-4">
									<input type="text" class="form-control lab_search" name="change_lab" id="lab_search" value="">
								</div>

							</div>
							<?php } ?>
                            <div class="clearfix"> <label class="col-sm-12"><b>Internal Details:</b></label></div>
								<div class="form-group"> 
                                <?php
                                if(!empty($sub[0]['fname'])){

                                    $ed1 ="Change";

                                }else{

                                    $ed1 ="Select";

                                }
								
								if(!empty($sub[0]['fname'])){ ?>
                                                   
                                    <label class="col-sm-2"><b> Internal Faculty:</b></label>
                                    <div class="col-sm-4" style="text-align:left;">
                                    	
											<?php echo strtoupper($sub[0]['fname'][0].'. '.$sub[0]['mname'][0].'. '.$sub[0]['lname']);?>
                                    </div>                                 
                                
                                <?php }?>
								
                                                  
                                    <label class="col-sm-2"><b><?=$ed1?> Internal Faculty:</b></label>
                                    <div class="col-sm-4">
									<input type="text" class="form-control faculty_search" name="faculty" id="faculty_search" value="" <?php if(!empty($sub[0]['fname'])){ echo ""; }else{ ?>required <?php }?>>	
                                    </div>                                 
                                </div>                                 
								<div class="form-group"> 
								<?php
                                if(!empty($sub[0]['lab_fname'])){

                                    $ed1 ="Change";

                                }else{

                                    $ed1 ="Select";

                                }
								if(!empty($sub[0]['lab_fname'])){ ?>
								                       
										<label class="col-sm-2"><b> Lab Assistant Detail:</b></label>
										<div class="col-sm-4" style="text-align:left;">
												<?php echo strtoupper($sub[0]['lab_fname'][0].'. '.$sub[0]['lab_mname'][0].'. '.$sub[0]['lab_lname']);?>
										</div>                                 
									
                                <?php 
								} ?>
								
                                                    
                                    <label class="col-sm-2"><b><?=$ed1?> Lab Assistant Faculty:</b></label>
                                    <div class="col-sm-4">
									<input type="text" class="form-control lab_assist_search" name="lab_assist" id="lab_assist" value="" <?php if(!empty($sub[0]['lab_fname'])){ echo ""; }else{ ?>required <?php }?>>	
                                    </div>                                 
                                </div> 
								<?php /* ?><div class="form-group"> 
								<?php
									if(!empty($sub[0]['peon_fname'])){

										$ed1 ="Change";

									}else{

										$ed1 ="Select";

									}
											if(!empty($sub[0]['peon_fname'])){ ?>
								                       
										<label class="col-sm-2"><b> Peon:</b></label>
										<div class="col-sm-4" style="text-align:left;">
											
												<?php echo strtoupper($sub[0]['peon_fname'][0].'. '.$sub[0]['peon_mname'][0].'. '.$sub[0]['peon_lname']);?>
										</div>                                 
									
									<?php }?>
									
									                   
										<label class="col-sm-2"><b><?=$ed1?> Peon:</b></label>
										<div class="col-sm-4">
										<input type="text" class="form-control peon_search" name="peon" id="peon_search" value="" <?php if(!empty($sub[0]['peon_fname'])){ echo ""; }else{ ?>required <?php }?>>	
										</div>                                 
									</div> 
								<?php */ ?>
								
								
								<?php if(empty($sub[0]['ext_faculty_code']) && empty($sub[0]['exam_date'])){  ?>
															
                                <div class="clearfix"> <label class="col-sm-12"><b>External Faculty Details:</b></label></div>
								

								<div class="form-group">                     
									<label class="col-sm-2"><b>Select External Faculty:</b></label>
                                    <div class="col-sm-4"><input type="text" class="form-control exfaculty_search" name="exfaculty" id="exfaculty" value="" required>	
                                    </div>                                 
                                </div>

                               
								<div class="clearfix"> <label class="col-sm-12"><b>Date and Time Details:</b></label></div>
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
								<input type="hidden" value="<?php if(!empty($sub[0]['faculty_code'])){ echo $sub[0]['faculty_code'];}?>" id="int_faculty_code" name="int_faculty_code" />
								<input type="hidden" value="<?php if(!empty($sub[0]['lab_assistant'])){ echo $sub[0]['lab_assistant'];}?>" id="lab_assistant" name="lab_assistant" />
								<input type="hidden" value="<?php if(!empty($sub[0]['peon'])){ echo $sub[0]['peon'];}?>" id="peon_id" name="peon_id" />
								<input type="hidden" value="<?php if(!empty($sub[0]['lab_id'])){ echo $sub[0]['lab_id'];}?>" id="lab_id" name="lab_id" />
								<input type="hidden" value="<?php if(!empty($sub[0]['exam_pract_fact_id'])){ echo $sub[0]['exam_pract_fact_id'];}?>" id="exam_pract_fact_id" name="exam_pract_fact_id" />
								<input type="hidden" value="<?php if(!empty($sub[0]['exam_date'])){ echo $sub[0]['exam_date'];}?>" id="exam_date" name="exam_date" />
								<input type="hidden" value="<?php if(!empty($sub[0]['exam_from_time'])){ echo $sub[0]['exam_from_time'];}?>" id="exam_from_time" name="exam_from_time" />
								<input type="hidden" value="<?php if(!empty($sub[0]['exam_to_time'])){ echo $sub[0]['exam_to_time'];}?>" id="exam_to_time" name="exam_to_time" />
								<input type="hidden" value="<?php if(!empty($sub[0]['time_format'])){ echo $sub[0]['time_format'];}?>" id="	time_format" name="time_format" />	
								<div class="clearfix"> <label class="col-sm-12"><b>External Faculty Details:</b></label></div>
								<!-- for external faculty--->							
								<div class="form-group">                     
                                    <label class="col-sm-2"><b>Code/Name:</b></label>
                                    <div class="col-sm-4"><?php if(!empty($sub[0]['ext_fac_name'])){ echo $sub[0]['ext_faculty_code'].'/ '.$sub[0]['ext_fac_name'];}?></div>  
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
                                    <label class="col-sm-2"><b> Change External Faculty:</b></label>
                                    <div class="col-sm-4"><input type="text" class="form-control exfaculty_search" name="change_exfaculty" id="exfaculty" value="">	
                                    </div>                                 
                                </div>		
								<div class="clearfix"> <label class="col-sm-12"><b>Date and Time Details:</b></label></div>
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
                                    <div class="col-sm-4"></div>

                                    <div class="col-sm-2">
										<button class="btn btn-primary form-control" id="btn_submit" type="submit" >Assign</button> 
									</div>                                    

                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/assign_prac_faculty/<?=$sub[0]['stream_id']?>/<?=$sub[0]['semester']?>/<?=$sub[0]['course_id']?>/<?=$sub[0]['school_code']?>/<?=$sub[0]['batch_no']?>/<?=$sub[0]['acd_year']?>'">Back</button></div>

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
				$("#lab_assist").removeAttr('disabled');
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
				$("#lab_assist_name").removeAttr('disabled');
				$("#ext_fac_designation").removeAttr('disabled');
				$("#ext_fac_mobile").removeAttr('disabled');
				$("#ext_fac_email").removeAttr('disabled');
				$("#ext_fac_institute").removeAttr('disabled');
				$("#exfaculty").prop("disabled", "disabled");
			}
        });
        
    });
  $(function () {
    $('#form').on('submit', function (e) {
      if (!confirm('Please Verify The Details Before Submission, After Submission It Will Locked And Edit Option Will Be Possible Through The Office Of The COE')) {
        e.preventDefault();
      }
    });
  });
</script>		


