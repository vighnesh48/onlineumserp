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
                                <input type="hidden" value="<?=$sub[0]['stream_id']?>" id="stream_id" name="stream_id" />
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
                            	<div class="col-sm-3" ><?=$sub[0]['sub_code']?>-<?=$sub[0]['subject_name']?></div>
                                <div class="col-sm-2"></div>
                              	<label class="col-sm-2"><b>Stream: </b></label>
                              	<div class="col-sm-3" id="semest" ><?=$sub[0]['stream_name']?></div>	
                            </div>

                                <div class="form-group">
									<label class="col-sm-2"><b>Semester: </b></label>
									<div class="col-sm-3"><?=$sub[0]['semester']?></div>
									<div class="col-sm-2"></div>									
                                    <div class="col-sm-2"><b>Division/Batch:</b></div>
									<div class="col-sm-3"><?php if($bkflag==''){?><?=$sub[0]['division']?> / <?=$sub[0]['batch_no']?><?php }else{echo "A / 1";}?></div> 									
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
                                    <div class="col-sm-10" style="text-align:left;">
                                    	
											<?php echo strtoupper($sub[0]['fname'][0].'. '.$sub[0]['mname'][0].'. '.$sub[0]['lname']);?>
                                    </div>                                 
                                </div>
                                <?php }?>
                                <div class="form-group">                     
                                    <label class="col-sm-2"><b><?=$ed1?> Faculty:</b></label>
                                    <div class="col-sm-10"><input type="text" class="form-control faculty_search" name="faculty" id="faculty_search" value="" style="width: 500px;">
                                    	
                                    </div>                                 
                                </div>

                                

                                <div class="clearfix">&nbsp;</div>

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