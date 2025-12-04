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
        <li class="active"><a href="#">Earlygo-Latemark Report</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Earlygo-Latemark Report</h1>
            <div class="col-xs-12 col-sm-8">
        
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">List</span>
                        <div class="holder"></div>
                </div>
                <div class="panel-body">
                    <div class="table-info">    
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
								<th>#</th>
								<th>Employee ID</th>
								<th>Punch In Time</th>
								<th>Punch Out Time</th>
								<th>Shift In Time</th>
								<th>Shift Out Time</th>
								<th>Late Punch</th>
								<th>Early Go</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;                            
                            for($i=0;$i<count($emp_data);$i++)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td> 
                                <td><?=$emp_data[$i]['UserId']?></td>
                                <td><?=$emp_data[$i]['Intime']?></td>
								<td><?=$emp_data[$i]['Outtime']?></td>
								<td><?=$emp_data[$i]['shift_in']?></td>
								<td><?=$emp_data[$i]['shift_out']?></td>
								<?php if($emp_data[$i]['late_mark']==1){ ?>
								<td><?php echo "Yes" ?></td>
								<?php }else{ ?>
								<td><?php echo "---" ?></td>
								<?php }
								 if($emp_data[$i]['early_mark']=='Y'){
								?>
								<td><?php echo "Yes" ?></td>
								<?php }else{ ?>
								<td><?php echo "---"?></td>
								<?php } ?>
                            </tr>
                            <?php
                            $j++;
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