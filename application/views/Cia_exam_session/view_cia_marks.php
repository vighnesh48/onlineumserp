<!-- Rewritten code with security improvements -->
<script src="<?=base_url('assets/javascripts')?>/bootstrap-datepicker.js"></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css"/>
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">

<!-- jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons JS -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>

<style>
.absent_bg{background:#ff9b9b;}
</style>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Report</a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-8 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; CIA Marks</h1>
            <div class="col-xs-12 col-sm-4">
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">

                </div>
                <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="table-info">
                            <div>
                            </div>
                            <?php // echo'<pre>';print_r($cia_marks_data[0]['subject_component']);?>
                            <table class="table table-bordered" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Enrollment Number</th>
                                        <?php if ($cia_marks_data[0]['subject_component'] == 'TH') { ?>
                                        <th>CIA1</th>
                                        <th>CIA2</th>
                                        <th>CIA3</th>
                                        <?php } else {?>
                                        <th>CIA1 & CIA2(Lab-Practical Works)</th>
                                        <th>CIA3(Viva)</th>
                                        <?php } ?>
                                        <th>CIA4(Behavioural Attitude)</th>
                                        <th>CIA4(Theory and Pactical Attendance)</th>
                                        <th><b>TOTAL CIA Marks</b></th>
                                    </tr>
                                </thead>
                                <tbody id="studtbl">
                                    <?php $sr_no = 1; ?>    
                                    <?php foreach ($cia_marks_data as  $marks) : ?> 
                                    <tr>    
                                        <?php // echo'<pre>';print_r($marks); ?>    
                                        <td><?= $sr_no++ ?></td>    
                                        <td><?= $marks['enrollment_no'] ?></td> 
                                        <?php if ($marks['subject_component'] == 'TH') { ?>     
                                        <td><?= $marks['CIA1'] ?></td>  
                                        <td><?= $marks['CIA2'] ?></td>  
                                        <td><?= $marks['CIA3'] ?></td>  
                                        <?php } else {?>    
                                        <td><?= $marks['lab_pr_works'] ?></td>  
                                        <td><?= $marks['viva'] ?></td>  
                                        <?php } ?>  
                                        <td><?= $marks['behavioural_attitude'] ?></td>  
                                        <td><?= $marks['attendance'] ?></td>    
                                        <td><b><?= $marks['cia_marks'] ?></b></td>    
                                    </tr>   
                                    <?php endforeach; ?>    
                                </tbody>
                            </table>
                            <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //datatable
    $(document).ready(function() {
        $('#datatable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                },
            ]
        });
    });
</script>

