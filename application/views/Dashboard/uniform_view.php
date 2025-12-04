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

<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Uniform Reports</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Uniform Summary Report</h1>
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
                        <span class="panel-title">Uniform Payment Paid Summary Report </span>
                        <div class="holder"></div>
                </div>
                <div class="panel-body">
                    <div class="table-info">              
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
								<th>#</th>
								<th>Organisation</th>
								<th>Institute</th>
								<th>Student Count</th>
								<th>Fees Paid</th>
								<th>Uniform Distrubeted</th>
								<th>Uniform Pending</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;
                           $count=0;
                           $stud_count=0;	
$stud_totcount=0;						   
//$stud_pendingcount=0;						   
                            for($i=0;$i<count($uniform_data);$i++)
                            { 
						  
                              $total=$uniform_data[$i]['fees_paid'];
                              $stud_add=$uniform_data[$i]['student_count'];
                            ?>
                            <tr>
                                <td><?=$j?></td> 
                                <td><?=$uniform_data[$i]['org_frm']?></td>
                                <td><?=$uniform_data[$i]['institute']?></td>
                                <td><?=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$uniform_data[$i]['student_count'])?></td>
								<td><?= preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$uniform_data[$i]['fees_paid'])?></td>
								<td><b><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$uniform_data[$i]['uniform_distributed_count'])?></b></td>
								<td><b><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",($uniform_data[$i]['student_count']-$uniform_data[$i]['uniform_distributed_count']))?></b></td>
								<?php /*if($uniform_data[$i]['org_frm']=='SU'){
									$stud_pendingcount[] =$uniform_data[$i]['pending_count'];
									?>
								<!--td><b><a href="<?=base_url()?>dashboard/uniform_pending_summary_report/<?=$uniform_data[$i]['org_frm']?>/<?=$uniform_data[$i]['school_id']?>" target="_blank"><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",($uniform_data[$i]['pending_count']))?></b></a></td>
								<?php }else{
								$stud_pendingcount[]= $uniform_data[$i]['total_admission']-$uniform_data[$i]['student_count'];	?>
							<td><b><a href="<?=base_url()?>dashboard/uniform_pending_summary_report/<?=$uniform_data[$i]['org_frm']?>/<?=$uniform_data[$i]['institute']?>" target="_blank"><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",($uniform_data[$i]['total_admission']-$uniform_data[$i]['student_count']))?></b></a></td-->
							<?php }*/?>
                            </tr>
                            <?php
                            $j++;
							$count=$count+$total;
							$stud_count=$stud_count+$stud_add;
							$stud_totcount=$stud_totcount+$uniform_data[$i]['uniform_distributed_count'];
							
							$stud_pendingcount[]=($uniform_data[$i]['student_count']-$uniform_data[$i]['uniform_distributed_count']);
                            }
                            ?>	
							<tr><td><b>Total</b></td><td></td><td></td>
							<td><b><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$stud_count)?></b></td>
							<td><b><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$count)?></b></td>
							<td><b><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$stud_totcount)?></b></td>
							<td>
							
							<b><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",array_sum($stud_pendingcount))?></b>
							
							</td>
							</tr>
                          </tbody>
						  
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