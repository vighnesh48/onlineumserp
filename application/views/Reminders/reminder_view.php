
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<style>
/* Panel Theme */
.panel {
    border-radius: 12px !important;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15) !important;
    border: none !important;
    margin-bottom: 20px !important;
}

.panel-heading {
    background: linear-gradient(90deg, #004aad, #0078d7) !important;
    color: white !important;
    font-weight: 600 !important;
    font-size: 16px !important;
    border-radius: 12px 12px 0 0 !important;
    padding: 12px 20px !important;
}

.panel-title i {
    margin-right: 8px !important;
	color: white !important;
}

.panel-body {
    background: #027cff17 !important;
    padding: 20px !important;
}

/* Table Theme */
.table {
    width: 100% !important;
    border-collapse: collapse !important;
    font-size: 13px !important;
}

.table th, .table td {
    padding: 12px !important;
    text-align: left !important;
    vertical-align: middle !important;
    border: 1px solid #dee2e6 !important;
}

.table thead th {
    background: #004aad !important;
    color: white !important;
    font-weight: 600 !important;
}

.table tbody tr:nth-child(even) {
    background-color: #f2f2f2 !important;
}

.table tbody tr[style] {
    background-color: #FBEFF2 !important; /* For inactive rows */
}

/* Buttons */
.btn-primary {
    background-color: #0078d7 !important;
    border-color: #0078d7 !important;
    color: white !important;
    border-radius: 6px !important;
    padding: 8px 16px !important;
    font-weight: 600 !important;
}

.btn-primary:hover {
    background-color: #004aad !important;
    border-color: #004aad !important;
}

/* Loader */
#loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255,255,255,0.7);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
}

.spinner {
    border: 8px solid #f3f3f3; /* Light gray */
    border-top: 8px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite; /* DO NOT use !important here */
}

/* Spinner Animation Keyframes */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Modal */
.modal-content {
    border-radius: 12px !important;
    padding: 20px !important;
}

.modal-header {
    background: linear-gradient(90deg, #004aad, #0078d7) !important;
    color: white !important;
    font-weight: 600 !important;
    border-radius: 12px 12px 0 0 !important;
    padding: 12px 20px !important;
}

.modal-footer {
    padding: 12px 20px !important;
}
</style>

<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Reminders Masters</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Reminders</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                 
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/reminder_add")?>" ><span class="btn-label icon fa fa-plus"></span>Add</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
		
		<?php if($this->session->flashdata('success')) { ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?= $this->session->flashdata('success'); ?>
    </div>
<?php } ?>

<?php if($this->session->flashdata('error')) { ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?= $this->session->flashdata('error'); ?>
    </div>
<?php } ?>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title" style="color: white !important;">Reminders List</span>
                        <div class="holder"></div>
                </div>
                <div class="panel-body">
                    <div class="table-info">    
                    <table class="table table-bordered" id='example'>
                        <thead>
                      <tr>
								<th>#</th>
								<th>Title</th>
								<th>Date</th>
								<th>Time</th>
								<th>Description</th>
								<th>Action</th>
								</tr>
								</thead>
								<tbody>

								<?php $i=1; foreach($reminders as $rem){ ?>
								<tr>
								<td><?= $i++; ?></td>
								<td><?= $rem['title']; ?></td>
								<td><?= $rem['reminder_date']; ?></td>
								<td><?= $rem['reminder_time']; ?></td>
								<td><?= substr($rem['description'],0,50).'...' ?></td>
								<td>
								<a class="btn btn-info btn-sm" href="<?= base_url('Reminder/reminder_edit/'.$rem['id']) ?>">Edit</a>
								<a class="btn btn-danger btn-sm" onclick="return confirm('Delete?')" href="<?= base_url('Reminder/reminder_delete/'.$rem['id']) ?>">Delete</a>
								</td>
								</tr>
						<?php }  ?>
						                    
                        </tbody>
                    </table>                    
              
                     </div>
                   </div>
                </div>
            </div>    
        </div>
    </div>
</div>
