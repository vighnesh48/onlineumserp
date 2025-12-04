<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets')?>/javascripts/jquery-3.3.1.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/css/jquery.dataTables.min.css">
<script src="<?=base_url('assets')?>/javascripts/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/css/responsive.dataTables.min.css">
<script src="<?=base_url('assets')?>/javascripts/dataTables.responsive.min.js"></script>


<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

<style>
#edit.disabled {
  pointer-events: none;
  cursor: default;
}
</style>
<?php // print_r($state_details); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#"> Masters</a></li>
        <li class="active"><a href="<?= base_url('Result_date_updation') ?>"> Result publication dates</a></li>

    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Result publication dates</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php // if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add Result publication dates</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php // } ?>
                   
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
                        <span class="panel-title">List</span>
                        <div class="holders"></div>
                </div>
                <div class="panel-body">
                    <div class="table-info">   
                        
                    <form method="post" action="<?= base_url($currentModule) ?>" id="searchForm">
                        <div class="row">
                            <div class="col-sm-2">
                                <select name="exam_session" id="exam_session" class="form-control" required>
                                    <option value="">Exam Session</option>
                                    <?php foreach ($exam_sessions as $exsession) {
                                        $exam_sess_val = $exsession['exam_month'] . '-' . $exsession['exam_year'] . '-' . $exsession['exam_id'];
                                        $selected = ($this->input->post('exam_session') == $exam_sess_val) ? 'selected' : '';
                                        echo '<option value="' . $exam_sess_val . '"' . $selected . '>' . $exsession['exam_month'] . '-' . $exsession['exam_year'] . '</option>';
                                    } ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="<?= base_url($currentModule) ?>" class="btn btn-default">Clear</a>
                            </div>
                        </div>
                    </form>
                    <br>


                    <?php // if(in_array("View", $my_privileges)) { ?>
                    <table class="display responsive nowrap" cellspacing="0" width="100%" id="exam_session_data">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Exam Session</th>
									<th>School Name</th>
									<th>Date</th>
									<th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;                            
                            foreach($exam_session_details as $row)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>                                                                
                                <td><?= $row->exam_month . '-' . $row->exam_year. '-' . $row->examId; ?></td>
								<!-- <td><?=$row->school_name;?></td>   -->
                                <td><?= ucwords(strtolower($row->school_name)); ?></td>
                                <?php
                                $date = $row->start_date;
                                // Splitting date and time
                                $dateParts = explode("T", $date);
                                $date = $dateParts[0];
                                $time = $dateParts[1];
                                // Formatting with spaces
                                $dateFormatted = implode("-", explode("-", $date));
                                $timeFormatted = implode(":", explode(":", $time));

                                echo "<td>{$dateFormatted} T {$timeFormatted}</td>";
                                ?>

								<!-- <td><?php // $row->start_date;?></td>   -->
                                <td>
                                    <?php //  if(in_array("Edit", $my_privileges)) { ?>
                                    <!--<a href="<?=base_url($currentModule."/edit/".$row->exam_id)?>" class="disabled" id="edit"><i class="fa fa-edit"></i></a>  -->                                                                    
                                    <?php //  } ?>

                                    <?php //  if(in_array("Delete", $my_privileges)) { ?>
                                    <a href='<?=base_url($currentModule)."/"?><?= $row->is_active=="Y"?"disable/".$row->exam_id :"enable/".$row->exam_id ?>'><i class='fa <?=$row->is_active =="Y"?"fa-check":"fa-ban"?>' title='<?= $row->is_active =="Y"?"Enable":"Disable"?>'></i></a>
                                    <?php //  } ?>
                                    <?php //  if(in_array("Delete", $my_privileges)) { ?>
                                    || <a href='<?=base_url($currentModule)."/edit/$row->exam_id"?>'><i class="fa fa-clock-o" aria-hidden="true"> update Result Publication Dates</i></a>
                                    <?php //  } ?>
                                </td>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php // } ?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var table = $('#exam_session_data').DataTable({
        responsive: true,
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3] 
                }
            }
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        columnDefs: [{    
            targets: -1,  
            visible: true
        }]
    });

    //$("#exam_session_data_paginate").removeClass("dataTables_paginate");

    $("div.holder").jPages({
        containerID : "itemContainer"
    });
});
</script>
