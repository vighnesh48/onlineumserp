<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
       <!-- <li class="active"><a href="<?=base_url($currentModule)?>">School </a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Extra Working Hours Report </h1><span id="err_msg" style="color:red;"></span>
			<span id="flash-messages" style="color:Green;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>

        </div>
            <?php echo form_open('Admin/extra_working_hours'); ?>
            <div class="form-group row">
                <div class="col-md-2">
                    <input type="month" class="form-control" id="month" name="month" value="<?php echo isset($selected_month) ? $selected_month : ''; ?>" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            <?php echo form_close(); ?>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title"><b>List </b></span>
                </div>
                <div id="show_list" class="panel-body"  style="overflow-x:scroll;height:550px;">
                    <div class="table-info">    
                    <?php if (isset($data)): ?>

                    <table class="table table-bordered" id="example" style="width:100%;max-width:100%;">
                        <thead>
                            <tr>
                                <th>Sr</th>
                                <th>User ID</th>
                                <th>Employee Name</th>
                                <th>Rounded Hours</th>
                                <th>Valuation</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                        <?php if (!empty($data)): ?>
                                <?php $i = 1; foreach ($data as $row): ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($row['UserId']); ?></td>
                                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                                        <td><?php echo htmlspecialchars($row['total_extra_hours']); ?></td>
                                        <td><?php echo htmlspecialchars($row['valuation']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">No data found for the selected period.</td>
                                </tr>
                            <?php endif; ?>                         
                        </tbody>
                    </table>                    
                    <?php endif; ?>
                </div>
                </div>
            </div>
			
            </div>    
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    var selectedMonth = '<?php echo isset($selected_month) ? $selected_month : date("Y-m"); ?>';
    var excelFileName = 'OT_Report_' + selectedMonth;

    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: excelFileName,
                filename: excelFileName,
              //  messageTop: 'OT Report for ' + selectedMonth
            }
        ]
    });
});
</script>
