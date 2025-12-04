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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Uniform Pending  Report</h1>
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
                        <span class="panel-title">Uniform Pending Report-2022-23 </span>
                        <div class="holder"></div>
                </div>
                <div class="panel-body">
                    <div class="table-info">              
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
								<th>#</th>
								<!--th>Belongsto</th-->
								<th>enrollment_no</th>
								<th>student name</th>
								<th>Mobile</th>
								<th>Email</th>
								<th>School</th>
								<th>Stream</th>
								<th>Semester</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;
					   
                            for($i=0;$i<count($uniform_data);$i++)
                            { 						  
                             
                            ?>
                            <tr <?php if($uniform_data[$i]['belongs_to']=='Package'){?> style="color:red;" <?php }?>>
                                <td><?=$j?></td>
								<!--td><?=$uniform_data[$i]['belongs_to']?></td-->	
                                <td><?=$uniform_data[$i]['enrollment_no']?></td>
                                <td><?=$uniform_data[$i]['student_name']?></td>
                                <td><?=$uniform_data[$i]['mobile']?></td>
                                <td><?=$uniform_data[$i]['email']?></td>
                                <td><?=$uniform_data[$i]['school_short_name']?></td>
                                <td><?=$uniform_data[$i]['stream_name']?></td>
                                <td><?=$uniform_data[$i]['current_year']?></td>
                                
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