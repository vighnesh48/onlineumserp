<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="https:////cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
<script src="https:////cdn.datatables.net/buttons/1.4.2/js/buttons.colVis.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">

	<?php 
     if(isset($_SESSION['status']))
    {
        ?>
			<script>
			//alert("Your Details already Submitted.");
			var status="<?php echo $_SESSION['status'] ?>";
			 alert(status);
			</script>
        <?php 
        unset($_SESSION['status']);
       }
   ?>
<style>
.form-control{border-collapse:collapse !important;}
</style>
<?php
   $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Guide Allocation</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Allocated Student List</h1>
            <div class="col-xs-12 col-sm-6">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">					   
                </div>
            </div>
        </div>
     </div>
		  <div class="row "> 
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title" id="stdname">Student PRN :- <?=$studs['enrollment_no']?>     ||    Student Name :- <?=$studs['first_name'].' '.$studs['middle_name'].' '.$studs['last_name']?></span>
                    </div>
                    <div class="panel-body" style="overflow:scroll;height:700px;">
                        <div class="table-info" id='stud_view'>  
						<?php // if(in_array("View", $my_privileges)) { ?>
							<table id="example" class="table table-bordered" width="100%">
							<thead>							
								<tr>
									<th style="text-align: center">SNo</th>
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
									if(!empty($stud_det)){
										foreach($stud_det as $stud){
								?>
									<tr align="center">
										<td><?=$i?></td>
										<td><?='Semester- '.$stud['semester']?></td>
										<td><?php  if($stud['rac_file']!=''){
 										
										$b_name = "uploads/phd_topic_approval/";
										 $dwnld_url = base_url()."Upload/download_s3file/".$stud['rac_file'].'?b_name='.$b_name; ?>
										<a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
										</td>
									<td><?php	if($stud['research_file']!=''){
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
									<?php 
									// if(in_array("Edit", $my_privileges)) {
									if($stud['status']=="Y"){ ?>
									<button class="btn btn-primary" id="btn_cancel" type="button" onclick="status_change_nonrecom(<?=$stud['student_id']?>,<?=$stud['semester']?>)">Non-Recommended?</button>
										<?php } else { ?>
										<button class="btn btn-primary" id="btn_cancel" type="button" onclick="status_change_recom(<?=$stud['student_id']?>,<?=$stud['semester']?>)">Recommended?</button>
									<?php } //} ?>
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
<script>
$(document).ready(function () {
	
});

    function status_change_nonrecom(stud_id,sem)
  {
      var status='N';
	  if(stud_id !='' && sem !=''){
		var checkstr =  confirm('Are you sure you want to Non-Recommended this?');
        if(checkstr == true){
	 	$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Guide_allocation_phd/topic_approval_status_chng',
				data: 'stud_id=' + stud_id+'&status='+status+'&sem='+sem,
				success: function (sucess) {
					
                       location.reload();
				}
			});
		}
	  }
	  else
	  {
		  alert("Something Wrong");
	  }
  }
  
     function status_change_recom(stud_id,sem)
  {
      var status='Y';
	  if(stud_id !='' && sem !=''){
		var checkstr =  confirm('Are you sure you want to Recommended this?');
        if(checkstr == true){
	 	$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Guide_allocation_phd/topic_approval_status_chng',
				data: 'stud_id=' + stud_id+'&status='+status+'&sem='+sem,
				success: function (sucess) {
					
                       location.reload();
				}
			});
		}
	  }
	  else
	  {
		  alert("Something Wrong");
	  }
  }
</script>
