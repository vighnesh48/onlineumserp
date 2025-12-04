<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="https:////cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>


<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
<style>
.absent_bg{background:#ff9b9b;}
.table{width: 150%;}
table.dataTable{width: 150%!important;}
</style>
<script>
$(document).ready(function() {
	$('#dt-datepicker1').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
	$('#dt-datepicker2').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});

    // Append a caption to the table before the DataTables initialisation
    //$('#example').append('<caption style="caption-side: bottom">A fictional company\'s staff table.</caption>');
	var printCounter = 0;
    $('#example').DataTable( {
        dom: 'Bfrtip',
		"bPaginate": false,
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Student-wise Attendance Report',
				filename: 'Student List'
            },
            /*{
                extend: 'pdf',
                messageTop: 'test',
				filename: 'Class Student'
            },
            {
                extend: 'print',
                messageTop: function () {
                    printCounter++;
 
                    if ( printCounter === 1 ) {
                        return 'This is the first time you have printed this document.';
                    }
                    else {
                        return 'You have printed this document '+printCounter+' times';
                    }
                },
                messageBottom: null
            }*/
        ]
    } );
});

function ValidateEndDate() {
       var startDate = $("#dt-datepicker1").val();
       var endDate = $("#dt-datepicker2").val();
	   //alert(startDate); alert(endDate);
       if (startDate != '' && endDate !='') {
           if (Date.parse(startDate) > Date.parse(endDate)) {
               $("#dt-datepicker2").val('');
			   $("#dt-datepicker2").focus();
               alert("Start date should not be greater than end date");
			   return false;
           }
       }
       return true;
   }
</script>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
	?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Students</a></li>
        <li class="active"><a href="#">Attendance Report</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Student-Wise Report </h1>
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
                            <span class="panel-title" id="stdname"> 
                                <div class="row ">
						<div class="col-sm-12">
						<form method="post" name="searchatt" id="searchatt" action="<?=base_url()?>attendance/studentAttendenceReport">
							<label class="col-sm-2" style="text-align:right">Subjects :</label>
							<div class="col-sm-2">
								<select class="form-control" name="sub_id" id="sub_id" required>
									<option value="">--Select--</option>
									<?php
									if(!empty($subjects)){
											foreach($subjects  as $sub){
												$batchcode = $sub['subject_id'].'-'.$sub['division'].'-'.$sub['batch'].'-'.$sub['semester'].'-'.$sub['stream_id'];
												if ($batchcode == $subId) {
													$sel = "selected";
												} else {
													$sel = '';
												}
												$subjectdetails = explode('-', $sub['batch_code']);
												$divsion = $sub['division'];
												$batchno = $sub['batch'];
												
												if($sub['subject_id'] !='OFF'){
													if($batchno ==0){
														$batch = "";
													}else{
														$batch =$batchno;
													}
													echo '<option value="'.$batchcode.'"' . $sel . '>'.$sub['subject_short_name'].'('.$sub['sub_code'].')-'.$divsion.''.$batch.'</option>';
												}
											}
										}
										?>
								</select>
							</div>
							
							<div class="col-sm-2">
							<input type="text" class="form-control" name="from_date" id="dt-datepicker1" value="<?=$_REQUEST['from_date']?>" style="width:150px;" placeholder="From Date">
							</div>
							
							<div class="col-sm-2">
							<input type="text" class="form-control" name="to_date" id="dt-datepicker2" value="<?=$_REQUEST['to_date']?>" style="width:150px;" placeholder="To Date">
							</div>
							<div class="col-sm-2">
							<input type="submit" value="Search" name="submit" onClick="return ValidateEndDate()" class="form-control btn btn-primary">
							</div>
							</form>
						</div>
					</div>
							</span>
                    </div>
					
                    <div class="panel-body">
						
                        <div class="table-info" style="overflow:scroll;height:700px;">  
						
							<table id="example" class="table table-bordered display" align="center" >
							
							<thead>
							   <tr>
									<th align="center" data-orderable="false" style="width: 14px;"><span>Roll No</span></th>
									<th align="center" data-orderable="false" style="width: 20px;"><span>PRN.</span></th>
									<th align="center" data-orderable="false" style="width: 150px;"><span>Name</span></th>
									
									<?php foreach($attDates as $attdate) {
									$attendance_date = $attdate['attendance_date'];
									
									$att_day = date('d-m', strtotime($attdate['attendance_date']) );
									$day_name = date('D', strtotime($date));
									$totaldays['total'][]=$attendance_date;

									?>
                                   <th style="width: 14px;" data-orderable="false"><?=$att_day?>
                                    </th>
                                  <?php }
									?>
									<th align="center" data-orderable="false" style="width: 14px;"><span>#Present</span></th>
									<th align="center" data-orderable="false" style="width: 14px;"><span>#Absent</span></th>
									<th align="center" data-orderable="false"style="width: 14px;"><span>#Total</span></th>
									<th align="center" data-orderable="false" style="width: 14px;"><span>#Percentage</span></th>
									
							   </tr>
								</thead>
								<tbody id="studtbl">
								<?php
								$CI =& get_instance();
								$CI->load->model('Attendance_model');
								
									if(!empty($stud_list)){
										foreach($stud_list as $stud){
										if($stud['first_name'] !=''){
								?>
									<tr>
										
										
										<td><?=$stud['roll_no']?></td>
										<td><?=$stud['enrollment_no']?></td>
										<td><?php echo strtoupper($stud['first_name']." ".$stud['middle_name']." ".$stud['last_name']);?></td>
										<?php
										$tot_present=array();
										$tot_absent=array();
											foreach($attDates as $attdate) {
												$slot_id = $attdate['slot'];
												$attendance_date = $attdate['attendance_date'];
												$check_attendance =$this->Attendance_model->check_attendance($attendance_date,$slot_id, $stud['student_id'], $subject_id);//check for attendance
												//print_r($check_attendance);
												$is_present = $check_attendance[0]['is_present'];
												if($is_present=='N'){
													$present = 'A';
													$tot_absent[] = $present;
													$color_class="red";
												}elseif($is_present=='Y'){
													$present = 'P';
													$tot_present[] = $present;
													$color_class="green";
												}else{
													$present = '-';
													$color_class="";
												}
										?>
										<td style="color:<?=$color_class;?>"><?=$present?></td>
										<?php }?>
										<td><?=count($tot_present);?></td>
										<td><?=count($tot_absent);?></td>
										<td><?php 
										$totpresent = count($tot_present);
										$tot_lecture = count($tot_present) + count($tot_absent);
										echo $tot_lecture;
										?></td>		
										<td><?php 
											$totper = ($totpresent / $tot_lecture) * 100;
										    echo round($totper); ?>%</td>										
									</tr>
									
								<?php 
								unset($tot_present);
								unset($tot_absent);
										}
										//exit;
										}
									}else{
										echo "<tr><td colspan=6>No data found.</td></tr>";
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
</div>