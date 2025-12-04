<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
	
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
$(document).ready(function(){
    var acad_year = '<?php echo $this->uri->segment(3);?>';
    var campus = '<?php echo $this->uri->segment(4);?>';

    if (acad_year != '') {
        $('#acad_year').val(acad_year);
    } else {
        $('#acad_year').val(<?=C_RE_REG_YEAR?>);
    }

    if (campus != '') {
        $('#campus').val(campus);
    } else {
        $('#campus').val('NASHIK');
    }

    function updateReport() {
        var acad_year = $('#acad_year').val();
        var campus = $('#campus').val();
        var url = '<?=base_url()?>dashboard/hostel_fees_report/' + acad_year + '/' + campus;
        window.location.href = url;
    }

    $('#acad_year').change(updateReport);
    $('#campus').change(updateReport);
});


</script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Reports</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Hostel Summary Report</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">                 
                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
            </div>
        </div>
  
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">
                       <div class="col-sm-3">
									<select name="acad_year" id="acad_year" class="form-control">
										<option value="">Select Academic Year</option>
										<?php foreach($acad_year as $year): ?>
											<?php 
											
												$year_value = explode('-', $year['academic_year'])[0]; 
											?>
											<option value="<?= $year_value ?>" <?= ($year_value == $selected_acad_year) ? 'selected' : '' ?>>
												<?= $year['academic_year'] ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-sm-3">
									<select name="campus" id="campus" class="form-control">
										<option selected value="NASHIK">Nashik</option>
										<option value="SIJOUL">SIJOUL</option>
									</select>
								</div>
							</div>
						</span>
						<div class="holder"></div>
					</div>
                <div class="panel-body table-reponsive" style="width:100%;overflow:scroll;padding:0px;">
                    <div class="table-info">              
                    <table class="table table-bordered table-responsive table-hover" width="120%" id="example">
                        <thead>
                            <tr>
								<th>S.No.</th>
								<th>Hostel Name</th>
								<th>Campus</th>
								<th>Area</th>
								<th>#Capacity</th>
								<th>#Increased Capacity</th>
								<th>#Allocated</th>
								<th>#Vacant</th>
								<th>Deposit</th>
								<th>Hostel</th>
								<th>Exemption</th>
								<th>Gym</th>
								<th>Fine</th>
								<th>Opening Bal.</th>
								<th>Applicable</th>
								<th>Paid</th>
								<th>Refund</th>
								<th>Pending</th>
								
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                           	<?php
							$j=1;
                            $stud_count=0;
                  			$stud_ac_fees=0;
                            $stud_paid =0;	
							//echo '<pre>';
							//print_r($hostel_data);exit;
							$appl1=(array_sum(array_column($hostel_data,'deposit_fees'))+array_sum(array_column($hostel_data,'actual_fees'))+array_sum(array_column($hostel_data,'gym_fees'))+array_sum(array_column($hostel_data,'fine_fees'))+array_sum(array_column($fees,'opening_balance')))-(array_sum(array_column($hostel_data,'excemption_fees')));
							for($i=0;$i<count($hostel_data);$i++)
                            { 
						     $appl=((int)$hostel_data[$i]['deposit_fees']+(int)$hostel_data[$i]['actual_fees']+(int)$hostel_data[$i]['gym_fees']+(int)$hostel_data[$i]['fine_fees']+(int)$hostel_data[$i]['opening_balance'])-((int)$hostel_data[$i]['excemption_fees']);

						       //$count=$student_data[$i]['std_count'];
							   //$actual_sum=$student_data[$i]['actual_fees'];
							   //$paid_sum=$student_data[$i]['fees_paid'];
                            ?>
                            <tr>
							<td><?=$j?></td> 
							<td><?=$hostel_data[$i]['hostel_name']?></td>
							<td><?=$hostel_data[$i]['campus_name']?></td>
							<td><?=$hostel_data[$i]['area']?></td>
							<td><?=$hostel_data[$i]['actual_capacity']?></td>
							<td><?=$hostel_data[$i]['capacity']?></td>
							<td><?=$hostel_data[$i]['stud_total']?></td>
							<td><?=$hostel_data[$i]['capacity'] - $hostel_data[$i]['stud_total']?></td>
							<td><?=$hostel_data[$i]['deposit_fees']?></td>
							<td><?=$hostel_data[$i]['actual_fees']?></td>
							<td><?=$hostel_data[$i]['excemption_fees']?></td>
							<td><?=$hostel_data[$i]['gym_fees']?></td>
							<td><?=$hostel_data[$i]['fine_fees']?></td>
							<td><?=$hostel_data[$i]['opening_balance']?></td>
							<td><?=$appl?></td>
							<td><?=$hostel_data[$i]['fees_paid']?></td>
							<td><?=$hostel_data[$i]['cancellation_refund']?></td>
							<td><?=$appl-$hostel_data[$i]['fees_paid']-$hostel_data[$i]['cancellation_refund']?></td>
                            </tr>
                            <?php
                            $j++;
							//$stud_count=$stud_count+$count;
							//$stud_ac_fees=$stud_ac_fees+$actual_sum;
							//$stud_paid=$stud_paid+$paid_sum;
                            }
                            ?> 							
                          </tbody>
								<tr style="font:bold">
<th colspan="4">Total</th>
<th><?=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",array_sum(array_column($hostel_data,'actual_capacity')))?></th>
<th><?=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",array_sum(array_column($hostel_data,'capacity')))?></th>
<th><?=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",array_sum(array_column($hostel_data,'stud_total')))?></th>
<th><?=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",array_sum(array_column($hostel_data,'capacity'))-array_sum(array_column($hostel_data,'stud_total')))?></th>
<th><?=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",array_sum(array_column($hostel_data,'deposit_fees')))?></th>
<th><?=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",array_sum(array_column($hostel_data,'actual_fees')))?></th>
<th><?=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",array_sum(array_column($hostel_data,'excemption_fees')))?></th>
<th><?=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",array_sum(array_column($hostel_data,'gym_fees')))?></th>
<th><?=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",array_sum(array_column($hostel_data,'fine_fees')))?></th>
<th><?=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",array_sum(array_column($hostel_data,'opening_balance')))?></th>
<th><?=	preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$appl1) ?></th>
<th><?=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",array_sum(array_column($hostel_data,'fees_paid')))?></th>
<th><?=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",array_sum(array_column($hostel_data,'cancellation_refund')))?></th>
<th><?= preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$appl1-array_sum(array_column($hostel_data,'fees_paid'))) ?></th>

</tr>		

							
                       
						  
                        </table>                     	
                    </div>
                 </div>
               </div>
            </div>    
        </div>
    </div>
</div>
 <script type='text/javascript'>	
$(document).ready(function () {
    var table = $('#example').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
		dom: 'lBfrtip',
	    "bPaginate": false,
		"bInfo": false,
        buttons: [
            'excel'
        ],
		lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
});
 </script>