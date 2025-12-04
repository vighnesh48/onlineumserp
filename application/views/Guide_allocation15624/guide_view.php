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
    {    ?>
			<script>
			//alert("Your Details already Submitted.");
			var status="<?php echo $_SESSION['status'] ?>";
			 alert(status);
			</script>
        <?php 
        unset($_SESSION['status']);
       }
   ?>
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
        </div>
     </div>
		  <div class="row "> 
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title" id="stdname">Allocated Student List</span>
                    </div>
                    <div class="panel-body" style="overflow:scroll;height:700px;">
                        <div class="table-info" id='stud_view'>  
						  <?php //if(in_array("View", $my_privileges)) { ?>
							<table id="example" class="table table-bordered" width="100%">
							<thead>
								<tr>
									<th style="text-align: center">SNo</th>
									<th style="text-align: center">PRN</th>
							    	<th style="text-align: center">Student Name </th>
							    	<th style="text-align: center">Actions</th>
								</tr>
								</thead>
								<tbody>
								<?php			
								$i=1;
									if(!empty($allcated_studlist)){
										foreach($allcated_studlist as $stud){
								?>
									<tr align="center">
										<td><?=$i?></td>
										<td><?=$stud['enrollment_no']?></td>
										<td><?=$stud['student_name']?></td>
										<td><a href="<?=base_url();?>Guide_allocation_phd/fetch_allocated_stud_det/<?=base64_encode($stud['student_id']);?>" title="View" ><i class="fa fa-eye"></i>&nbsp;</a></td>
									</tr>
								<?php
										$i++;
										}
									}else{
										echo "<tr><td colspan='3'>No data found.</td></tr>";
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
