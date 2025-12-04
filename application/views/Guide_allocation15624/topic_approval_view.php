<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
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
               rac_topic_file:
                {
                    validators: 
                    {
	                file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 2048 * 1024,
                        message: 'Pdf files allowed And Size Must be less than 2MB'
                        }
                    }

                },
              reserch_sem_file:
                {
                    validators: 
                    {
	                file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 2048 * 1024,
                        message: 'Pdf files allowed And Size Must be less than 2MB'
                        }
                    }
                },
            }       
        })
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Topic Approval</a></li>
    </ul>
    <div class="page-header">			
    <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; <?php if($doc_det_stud[0]['id']!=''){ ?>Edit <?php }else { ?>Add <?php  } ?>Topic Approval</h1>
            <div class="col-xs-12 col-sm-6">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">					   
                </div>
            </div>
			<?php if($doc_det_stud[0]['id']!=''){ ?>
              <div class="col-xs-12 col-sm-2">
                  <a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url()?>Guide_allocation_phd/topic_approval_add"><span class="btn-label icon fa fa-chevron-left"></span>Back</a>
				  <div class="visible-xs clearfix form-group-margin"></div>
              </div>
			<?php } ?>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
		<?php 
     if(isset($_SESSION['status']))
     {
        ?>
			<script>
			var status="<?php echo $_SESSION['status'] ?>";
			 alert(status);
			</script>
        <?php 
        unset($_SESSION['status']);
       }
   ?>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Current Semester :- </b> <span style="background-color:yellow;">Sem-<?=$sem_det['current_semester'];?></span></span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info"> 
						<?php //if (in_array("Add", $my_privileges) { ?>
                  <?php if($doc_det_stud[0]['id']!=''){ ?>						
						     <form id="form" name="form" action="<?=base_url($currentModule.'/update_topic_approval')?>" method="POST" enctype="multipart/form-data">
				             <input type='hidden' name="app_id" value="<?=$doc_det_stud[0]['id']?>">
				<?php }else{ ?>
				    <form id="form" name="form" action="<?=base_url($currentModule.'/submit_topic_approval')?>" method="POST" enctype="multipart/form-data">
					 <input type='hidden' name="semester" value="<?=$sem_det['current_semester']?>">
				<?php } ?>
				               <!--div class="form-group">
							   <label class="col-sm-3">Current Semester<?=$astrik?></label>
							   <div class="col-sm-6"><input type="input" id="semester" name="semester" class="form-control" readonly /></div>
							   </div-->
                                <div class="form-group">
                                   <label class="col-sm-3">Rac topic</label>
                                    <div class="col-sm-6"><input type="file" id="rac_topic_file" name="rac_topic_file" class="form-control" /></div>
									   <?php	
								  if($doc_det_stud[0]['rac_file']!=''){
								 $b_name = "uploads/phd_topic_approval/";
							    $dwnld_url = base_url()."Upload/download_s3file/".$doc_det_stud[0]['rac_file'].'?b_name='.$b_name; ?>
							     <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-download" aria-hidden="true"></i></a>
								 <input type="hidden" name="up[rac_file]" id="up[rac_file]" value="<?=$doc_det_stud[0]['rac_file']?>">
								   <?php } ?>
                                </div>
								  <div class="form-group">
                                    <label class="col-sm-3">Research Program Seminar <?=$astrik?></label>
                                    <div class="col-sm-6"><input type="file" id="research_sem_file" name="research_sem_file" class="form-control" <?php if($doc_det_stud[0]['research_file']==''){ ?>required <?php }?>/></div>
									   <?php	
								   if($doc_det_stud[0]['research_file']!=''){
								   
								 $b_name = "uploads/phd_topic_approval/";
							    $dwnld_url = base_url()."Upload/download_s3file/".$doc_det_stud[0]['research_file'].'?b_name='.$b_name; ?>
							     <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-download" aria-hidden="true"></i></a>
								 <input type="hidden" name="up[research_file]" id="up[research_file]" value="<?=$doc_det_stud[0]['research_file']?>">
								   <?php } ?>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                      <button class="btn btn-primary form-control" id="btn_submit" type="submit" ><?php if($doc_det_stud[0]['id']!=''){ ?>Update <?php }else { ?>Submit <?php  } ?></button>
                                    </div>                                    
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
						<?php //} ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
		 <div class="row "> 
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title" id="stdname">Documents Uploaded</span>
                    </div>
                    <div class="panel-body" style="overflow:scroll;height:700px;">
                        <div class="table-info" id='stud_view'> 
                         <?php //if(in_array("View", $my_privileges)) { ?>
							<table id="example" class="table table-bordered" width="100%">
							<thead>
								<tr>
									<th style="text-align: center">Sr No.</th>
									<th style="text-align: center">Semester</th>
									<th style="text-align: center">Rac File</th>
							    	<th style="text-align: center">Research Seminar File</th>
							    	<th style="text-align: center">Status</th>
							    	<th style="text-align: center">Actions</th>
								</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									if(!empty($doc_det)){
										foreach($doc_det as $stud){
								?>
									<tr align="center">
										<td><?=$i?></td>
										<td><?='Semester- '.$stud['semester']?></td>
										<td><?php  if($stud['rac_file']!=''){	
										$b_name = "uploads/phd_topic_approval/";
										 $dwnld_url = base_url()."Upload/download_s3file/".$stud['rac_file'].'?b_name='.$b_name; ?>
										<a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
										</td>
									<td><?php  if($stud['research_file']!=''){	
									     $b_name = "uploads/phd_topic_approval/";
										 $dwnld_url = base_url()."Upload/download_s3file/".$stud['research_file'].'?b_name='.$b_name; ?>
									<a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
                                       </td>
									      <?php if($stud['status']=="Y"){ ?>
										 <td style="color:green">Recommended</td>  
										   
									<?php   } else { ?>
										 <td style="color:red">Non-Recommended</td>     
									<?php  }  ?>
									<td>
									 <?php if($stud['status']=="N"){ 
									  //if(in_array("Edit", $my_privileges)) {
									 ?>
									 <a href="<?=base_url();?>Guide_allocation_phd/topic_approval_add/<?=base64_encode($stud['semester']);?>"><i class="fa fa-edit" ></i></a>
									 <?php  } //} ?>
									</td>
									</tr>
								<?php
										$i++;
										}
									}else{
										echo "<tr><td colspan='6'>No data found.</td></tr>";
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
    </div>
</div>