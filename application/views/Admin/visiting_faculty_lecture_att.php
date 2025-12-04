
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Visiting Faculty Lecture Attendance</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-money"></i>&nbsp;&nbsp;Lecture Attendance Details</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
            </div>
        </div>
        <div class="row ">
           <div class="col-sm-12">&nbsp;</div>
        </div>
		
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
				 <div class="panel-heading panel-info">
        <div class="row align-items-center">
        <!-- Label for Select Month -->
        <div class="col-sm-2 text-right">
            <label class="col-form-label">Select Month:</label>
        </div>

        <!-- Input and Button -->
			<div class="col-sm-6">
				<form id="form-faculty" name="form-faculty" action="<?= base_url($currentModule . '/visiting_faculty_lecture_att') ?>" method="POST" class="form-inline">
					<!-- Month Input Field -->
					<input 
						type="text" 
						id="monthleave" 
						name="month" 
						class="form-control monthPicker mr-2" 
						value="<?= htmlspecialchars($mon ?? date('m-Y')) ?>" 
						placeholder="Select Month"
					/>
					<!-- View Button -->
					<button id="tview" class="btn btn-primary">View</button>
				</form>
			</div>
		</div>
	        </div>
                <div class="panel-body">
                   <div class="table-info" id="fetch_data">    
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
                            <th>sno</th>
                            <th>Faculty ID</th>
                            <th>Faculty Name</th>                           
                            <th>Stream Name</th>
							<th>Division</th>
                            <th>Batch</th>
							<th>Subject Name</th>
							<th>Subject Component</th>
							<th>Attendance Date</th>
							<th>No. Of Hours</th>
							<th>From Time</th>
							<th>To Time</th>
							<th>Slot AM/PM</th>
							<th>Status</th>
							<th>Action</th>
                            </tr>
                        </thead>
					 <tbody id="itemContainer">
                            <?php 							
                            $j=1;                            
                            for($i=0;$i<count($lecture_det);$i++){?>                          
                            <tr>
							    <td><?=$j?></td>                               		
								<td><?=$lecture_det[$i]['emp_id']?></td>
								<td><?=$lecture_det[$i]['fname'].' '.$lecture_det[$i]['mname'].' '.$lecture_det[$i]['lname'] ?></td>
                                <td><?=$lecture_det[$i]['stream_name']?></td>
                                <td><?=$lecture_det[$i]['division']?></td>
								<td><?=$lecture_det[$i]['batch']?></td>
                                <td><?=$lecture_det[$i]['subject_name']?></td>
                                <td><?=$lecture_det[$i]['subject_component']?></td>
                                <td><?=date('d-m-Y', strtotime($lecture_det[$i]['attendance_date']))?></td>
                                <td><?=$lecture_det[$i]['no_of_hours']?></td>
                                <td><?=$lecture_det[$i]['from_time']?></td>
                                <td><?=$lecture_det[$i]['to_time']?></td>
                                <td><?=$lecture_det[$i]['slot_am_pm']?></td>
								<?php 
								$is_not_considered = $lecture_det[$i]['consideration_status'] == '1'; // 1 = Not Considered
								$status_label = $is_not_considered ? 'Not Considered' : 'Considered';
								$status_class = $is_not_considered ? 'text-danger' : 'text-success';

								$btn_text = $is_not_considered ? 'Mark as Considered' : 'Mark as Not Considered';
								$btn_class = $is_not_considered ? 'btn-success' : 'btn-danger';
								$new_status = $is_not_considered ? 0 : 1;
								?>

								<td><span class="status-label <?= $status_class ?>"><strong><?= $status_label ?></strong></span></td>
								<td>
									<button type="button"
										class="btn btn-sm toggle-consider-btn <?= $btn_class ?>"
										data-emp="<?= $lecture_det[$i]['emp_id'] ?>"
										data-name="<?= $lecture_det[$i]['fname'].' '.$lecture_det[$i]['lname'] ?>"
										data-stream_id="<?= $lecture_det[$i]['stream_id'] ?>"  
										data-division="<?= $lecture_det[$i]['division'] ?>"  
										data-batch="<?= $lecture_det[$i]['batch']?>"  
										data-sub_id="<?=$lecture_det[$i]['sub_id'] ?>"  
										data-attendance_date="<?= $lecture_det[$i]['attendance_date'] ?>"  
										data-slot="<?= $lecture_det[$i]['slot'] ?>"  
										data-academic_year="<?= $lecture_det[$i]['academic_year'] ?>"  
										data-status="<?= $new_status ?>">
										<?= $btn_text ?>
									</button>
								</td>
                            </tr>
							<?php $j++;
							}?>
                          </tbody> 							
                      </table> 					
                    </div>
                 </div>
              </div>
            </div>    
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js" type="text/javascript"></script>
<script>
$(document).ready(function (){
	
	    $('.monthPicker').datepicker({
       autoclose: true,
    minViewMode: 1,
    format: 'mm-yyyy',
        onClose: function (dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
					 $('#example').DataTable({
    orderCellsTop: true,
    fixedHeader: true,
    dom: 'lBfrtip',
    destroy: true,
    retrieve: true,
    paging: false,
    buttons: [
        {
            extend: 'excel',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]  // 0-based column index
            }
        }
    ],
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
});		  
					  
	     }); 
		 
		
$(document).on('click', '.toggle-consider-btn', function () {
    var emp_id = $(this).data('emp');
    var emp_name = $(this).data('name');
    var stream_id = $(this).data('stream_id');
    var division = $(this).data('division');
    var batch = $(this).data('batch');
    var sub_id = $(this).data('sub_id');
    var attendance_date = $(this).data('attendance_date');
    var slot = $(this).data('slot');
    var academic_year = $(this).data('academic_year');
    var new_status = $(this).data('status'); // 0 or 1
    var btn = $(this);
    var statusSpan = btn.siblings('.status-label');

    var confirmMsg = new_status == 0
        ? "Are you sure you want to mark " + emp_name +" - "+ emp_id + " as Considered?"
        : "Are you sure you want to mark " + emp_name +" - "+ emp_id + " as Not Considered?";

    if (confirm(confirmMsg)) {
        $.ajax({
            url: '<?= base_url("Admin/update_visiting_lecture_consideration_status") ?>',
            method: 'POST',
            data: { emp_id: emp_id, status: new_status, stream_id: stream_id, division: division, batch: batch, sub_id: sub_id, attendance_date: attendance_date, slot: slot, academic_year: academic_year },
            success: function (res) {
                if (res == 'success') {
                    // Toggle UI
                    if (new_status == 0) {
                        statusSpan.removeClass('text-danger').addClass('text-success').text('Considered');
                        btn.removeClass('btn-success').addClass('btn-danger')
                            .text('Mark as Not Considered')
                            .data('status', 1);
                    } else {
                        statusSpan.removeClass('text-success').addClass('text-danger').text('Not Considered');
                        btn.removeClass('btn-danger').addClass('btn-success')
                            .text('Mark as Considered')
                            .data('status', 0);
                    }
					
                    alert('Status updated successfully.');
					 $('#form-faculty').submit();
                } else {
                   
                    alert('Failed to update status.');
                }
            }
        });
    }
}); 
</script>
