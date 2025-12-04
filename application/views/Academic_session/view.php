<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets')?>/javascripts/jquery-3.3.1.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/css/jquery.dataTables.min.css">
<script src="<?=base_url('assets')?>/javascripts/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/css/responsive.dataTables.min.css">
<script src="<?=base_url('assets')?>/javascripts/dataTables.responsive.min.js"></script>
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
        <li class="active"><a href="#">Academic Session Master</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Academic Session</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php  if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add Academic Session</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php } ?>
                   
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
                        <div class="holder"></div>
                </div>
                <div class="panel-body">
                    <div class="table-info">    
                    <?php  if(in_array("View", $my_privileges)) { ?>
                    <table class="display responsive nowrap" cellspacing="0" width="100%" id="academic_session_data">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Academic Year</th>
									<th>Academic Session</th>
									<th>Start Month</th>
									<th>Last Month</th>
									<th>Start Date</th>									
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;                            
                            foreach($academic_session_details as $row)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>                                                                
                                <td><?=$row->academic_year;?></td>  
								<td><?=$row->academic_session;?></td>  
								<td><?=$row->start_month;?></td>  
								<td><?=$row->last_month;?></td>  
								<td><?=$row->start_date;?></td>  								
                                <td>
                                    <?php  if(in_array("Edit", $my_privileges)) { ?>
                                    <a href="<?=base_url($currentModule."/edit/".$row->id)?>" class="disabled" id="edit"><i class="fa fa-edit"></i></a>                                                                      
                                    <?php  } ?>

                                    <?php  if(in_array("Delete", $my_privileges)) { ?>
                                    <a href='<?=base_url($currentModule)."/"?><?= $row->currently_active=="Y"?"disable/".$row->id :"enable/".$row->id ?>'><i class='fa <?=$row->currently_active =="Y"?"fa-ban":"fa-check"?>' title='<?= $row->currently_active =="Y"?"Disable":"Enable"?>'></i></a>
                                    <?php  } ?>
                                    
                                </td>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php  } ?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>
  $("div.holder").jPages
  ({
    containerID : "itemContainer"
  });
  $(document).ready(function() {
    $('#academic_session_data').DataTable({
    responsive: true
});
    $("#academic_session_data_paginate").removeClass("dataTables_paginate"); 
} );
  
</script>