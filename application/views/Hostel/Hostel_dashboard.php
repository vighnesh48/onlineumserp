<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/jPages.css">
<script src="<?= base_url('assets/javascripts') ?>/jPages.js"></script>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<link href="<?= site_url() ?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?= site_url() ?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script src="<?= site_url() ?>assets/javascripts/jquery.table2excel.js"></script>



<div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div><div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        
        
        <div class="row ">
        
        
            <div class="form-group">
            
            <div class="col-sm-12">
            
                <div class="panel" >
                
                <div class="panel-body" >
                <div class="row ">
        
          <div class="col-sm-2">
           <a href="<?php echo base_url('Hostel/search_hostel_students');?>">
<button class="btn btn-primary form-control"  id="btn_submit1">Hostel Registration</button></a></div>
            <div class="col-sm-8">&nbsp;</div>
        </div><div class="row ">
        <div class="col-sm-1">&nbsp;</div></div>
                     <div class="row">
                         <?php
                        //print_r($ref_data);//exit();
                         if(count($ref_data)>0){
                            /* $faculty=0;
                             $student=0;
                             $admission=0;*/
                             foreach($ref_data as $row){
                                // $faculty = $faculty + $row['staff_ref_total'];
                                 // $student = $student + $row['stud_ref_total'];
                                 //  $admission = $admission + $row['admission_done'];
                                  // $sfadmission = $sfadmission + $row['sfadmission_done'];
                             ?>
							 <?php if($row['host_id'] !=""){?>
                               <div class="col-sm-3">
							    
                              <div class="stat-panel">
							<div class="stat-row">
								<!-- Purple background, small padding -->
								<div class="stat-cell bg-pa-purple padding-sm">
									<!-- Extra small text -->
									<div class="text-xs" style="margin-bottom: 5px;cursor:pointer;">
     <h4 class="text-center ref_inst" id="ref_inst" style="margin-top: 0px; margin-bottom: 0px;font-weight: bold;" value="<?=$row['host_id']?>"><?=$row['hostel_code']?>
     <span style="font-size:10px;"><?php if($row['present_status']=="Y")
     {echo'(In Campus)';}else{echo"(Out Campus)";}
	 ?> (<?php echo $row['campus_name'];?>)</span>
     &nbsp; </h4><span style="alignment-adjust:middle"><?php echo $row['hostel_name'];?> </span> </div>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text -->
								<div class="stat-counters bordered no-border-t text-center">
									<!-- Small padding, without horizontal padding -->
									<div class="stat-cell col-xs-4 padding-sm no-padding-hr">
										<!-- Big text -->
										<span class="text-bg"><strong><?=$row['total_rooms']?></strong></span><br>
										<!-- Extra small text -->
										<span class="text-xs text-muted" style="color:#000">Total</span>
									</div>
									<!-- Small padding, without horizontal padding -->
									<div class="stat-cell col-xs-4 padding-sm no-padding-hr">
										<!-- Big text -->
										<span class="text-bg" style=" color:green"><strong><?=$row['student_in']?></strong></span><br>
										<!-- Extra small text -->
										<span class="text-xs text-muted" style=" color:green">Allocate</span>
									</div>
										<div class="stat-cell col-xs-4 padding-sm no-padding-hr">
										<!-- Big text -->
										<span class="text-bg"  style=" color:#00aeef"><strong><?=$row['Guest_in']?></strong></span><br>
										<!-- Extra small text -->
										<span class="text-xs text-muted"  style=" color:#00aeef">Guest</span>
									</div>
                                    <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
										<!-- Big text -->
										<span class="text-bg" style=" color:#ed280e"><strong><?=$row['total_rooms']-$row['student_in']-$row['Guest_in'];?></strong></span><br>
										<!-- Extra small text -->
										<span class="text-xs text-muted" style=" color:#ed280e">Empty</span>
									</div>
								</div> <!-- /.stat-counters -->
								
							</div> <!-- /.stat-row -->
							
						</div>
								
                           </div>
						   <?php } ?> 
                             <?php
                             }
                         }
                         
                         ?>
                        
                          
                    </div>
                       
                    </div>
                    
                     </div>
                      </div>
                       </div>
                        </div>