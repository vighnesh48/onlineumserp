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
        <li class="active"><a href="#">Result Master</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Result Not generated List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    
                   
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
                    <?php  if(in_array("View", $my_privileges)) { ?>
                    <table class="display responsive nowrap" cellspacing="0" width="100%" id="exam_session_data">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>school Name </th>
									<th>Stream_name</th>
									<th>Semester</th>
									
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
                                <td><?=$row['school_short_name'];?></td>  
								<td><?=$row['stream_name'];?></td>  
								<td><?=$row['semester'];?></td>  
								
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
    $('#exam_session_data').DataTable({
     "bPaginate": false,
	 dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
        ]
});

   // $("#exam_session_data_paginate").removeClass("dataTables_paginate"); 
} );
  
</script>