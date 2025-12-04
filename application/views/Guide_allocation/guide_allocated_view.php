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
<script>
$(document).ready(function() {	
    $('#example').DataTable( {
        responsive: true,
        autoWidth: true,
        dom: 'Bfrtip',
		scrollY:        "700px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         true,
        fixedColumns: true,
        ordering: false,
        buttons: [
            {
                extend: 'excel',
				filename: 'guide allocation list'
            },
        ]        
    }).columns.adjust();
});
</script>
<?php
/* $faculty_arr = array();
foreach ($faculty_list as $value) {
	$faculty_arr[] = $value['emp_id'].", ".$value['fac_name'].", ".$value['department_name'];
} */
?>	

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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Guide Allocation</h1>
            <div class="col-xs-12 col-sm-6">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">					   
                </div>
            </div>
             <div class="col-xs-12 col-sm-2">
                  <a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url()?>Guide_allocation_phd/search_subAndStudent"><span class="btn-label icon fa fa-chevron-left"></span>Allocate Guide</a>
				  <div class="visible-xs clearfix form-group-margin"></div>
              </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Guide Allocation</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
							<div class="form-group">
                              <div class="col-sm-2" >
                                <select name="admission_cycle" id="admission_cycle" class="form-control" required>
                                  <option value="">Select Batch</option>
                                  <?php
									foreach ($cycle as $cycle) {
										if ($cycle['admission_cycle'] == $admission_cycle) {
											$sel1 = "selected";
										} else {
											$sel1 = '';
										}
										echo '<option value="' . $cycle['admission_cycle'] . '"' . $sel1 . '>' . $cycle['admission_cycle'] . '</option>';
									}
									?>
                               </select>
                              </div> 
                             <div class="col-sm-2" >
                                <select name="dept_id" id="dept_id" class="form-control" required>
                                  <option value="">Select Department</option>
                               </select>
                              </div> 							  
								<div class="col-sm-2 "> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
     </div>
		  <div class="row "> 
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title" id="stdname">Student List</span>
                    </div>
                    <div class="panel-body" style="overflow:scroll;height:700px;">
                        <div class="table-info" id='stud_view'>  
							<table id="example" class="table table-bordered" width="100%">
							<thead>
								<tr>
									<th>SNo</th>
									<th>PRN</th>
							    	<th>Student Name </th>
									<th>view</th>
							    	<th>Guide Id</th>
									<th>Guide Name</th>
								</tr>
								</thead>
								<tbody>
								<?php	
  								$displayed_guides = [];
								$i=1;
									if(!empty($allcated_guidelist)){
										foreach($allcated_guidelist as $stud){
			
								?>
									<tr>
										<td><?=$i?></td>		
										<td><?=$stud['enrollment_no']?></td>
										<td><?=$stud['student_name']?></td>
										<td><a href="<?=base_url();?>Guide_allocation_phd/topic_approval_add/<?=base64_encode($stud['student_id']);?>" title="View" target="_blank" ><i class="fa fa-eye"></i>&nbsp;</a>
										<a href="<?=base_url();?>Guide_allocation_phd/fetch_allocated_stud_det/<?=base64_encode($stud['student_id']);?>" title="approve" target="_blank" ><i class="fa fa-book"></i>&nbsp;</a>
										<!--a href="javascript:void(0);" class="swap-icon" data-toggle="modal" data-target="#swapModal" 
										data-stud_id="<?=$stud['student_id']?>"
										data-stud_name="<?=$stud['student_name']?>"
										>
										<i class="fa fa-exchange"></i>
									</a-->
										<?php if($stud['upload_file']!='' && $stud['status']=='Y' && $stud['type']=='RPS-5'){ ?>
										<a href="<?=base_url();?>Guide_allocation_phd/add_phd_section_upload_files/<?=base64_encode($stud['student_id']);?>" title="View" target="_blank" >upload-letters&nbsp;</a>
										<a href="<?=base_url();?>Guide_allocation_phd/add_coe_upaward_files/<?=base64_encode($stud['student_id']);?>" title="View" target="_blank" >coe-upload-letters&nbsp;</a>
										<a href="<?=base_url();?>Guide_allocation_phd/add_thesis_ev_dispatch_records/<?=base64_encode($stud['student_id']);?>" title="View" target="_blank">dispatch records&nbsp;</a>
										
										
										</td>
										<?php } ?>
										<td><?=$stud['guide_id']?></td>
										<td><?=$stud['guide_name']?> <?php if (!in_array($stud['guide_id'], $displayed_guides)): ?>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=base_url();?>Guide_allocation_phd/edit_guide_bank_details/<?=base64_encode($stud['guide_id']);?>" title="View" target="_blank" ><i class="fa fa-edit"></i>&nbsp;</a>
												<?php $displayed_guides[] = $stud['guide_id']; ?>
											<?php endif; ?></td>
									</tr>
								<?php
										$i++;
										}
									}else{
										echo "<tr><td>No data found.</td><td></td><td></td><td></td><td></td></tr>";
									}
								   ?>
								</tbody>
							</table>
						</div>
                    </div>
                </div>
			</div>		
		</div>	
    </div>
	
	
	
	<!--div class="modal fade" id="swapModal" tabindex="-1" role="dialog" aria-labelledby="swapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- modal-lg for larger view -->
        <!--div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="swapModalLabel">Swap Faculty</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="swapForm" action="<?=base_url().'Guide_allocation_phd/new_guide_assign_tostudent'?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="stud_id" name="stud_id">
                    <div class="form-group">
                        <label for="faculty">Select Faculty</label>
                        <input type="text" class="form-control" name="faculty" id="faculty_search" placeholder="Type Faculty Name or Code">
                        <small>Type Faculty Name or Code</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Swap</button>
                </div>
            </form>
        </div>
    </div>
</div-->
<script>
$(document).ready(function () {
	
$("#btn_submit").click(function(){
	// $('#stud_view').html();
	var cycle=$("#admission_cycle").val();
	var dept_id=$("#dept_id").val();
	if(cycle ==''){
	     alert('please select Batch');
		 return false;
	}else{
			$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Guide_allocation_phd/fetch_guide_student_view',
					data: {cycle:cycle,dept_id:dept_id},
				'success' : function(data){ //probably this request will return 
				   
				   $('#stud_view').html(data);
				}
			});
	     }	
    });
	
	$("#admission_cycle").change(function (){
		$('#dept_id').html();
		var cycle=$("#admission_cycle").val();
		if(cycle ==''){
	     alert('please select Batch');
		 return false;
	}else{
			$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Guide_allocation_phd/fetch_dept_onbatch',
					data: {cycle:cycle},
				'success' : function(data){ //probably this request will return 
				   
				   $('#dept_id').html(data);
				}
			});
	     }	
		
	});
}); 
</script>

