
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<?php // print_r($fac_list);?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">E-Suggestion</a></li>
        <li class="active"><a href="#">E-Suggestion List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;E-Suggestion List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">

                    <!--div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?= base_url($currentModule . "/add") ?>"><span class="btn-label icon fa fa-plus"></span>Add New Faculty</a></div-->                        
                    <div class="visible-xs clearfix form-group-margin"></div>

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
                        <span class="panel-title">E-Suggestion List:<button class="btn btn-primary" id="search" style="float: right;margin-top: -6px;margin-right: -5px;">Search</button><!--select class="form-control" name="category" id="category" style="width:200px;float: right;margin-top: -6px;margin-right: 15px;">
								<option value="">-Select Category-</option>
								<option value="0">All</option>
								<?php foreach($category as $cat){ ?>
								<option value="<?=$cat['c_id']?>"><?=$cat['c_name']?></option>
								<?php }?>
							  </select--> <div style="float: right;margin-top: -6px;margin-right: 30px;"><input type="radio" name="type" id="type" value="4" checked > Student &nbsp;&nbsp;&nbsp; <input type="radio" name="type" id="type" value="9"> Parent 
							  
							  </div>
							  
							</span>
                        <div class="holder"></div>
                    </div>
                    <div class="panel-body">
                        <div class="table-info table-responsive">    
                            <?php //if(in_array("View", $my_privileges)) { ?>
                            <table id="exampl1e" class="table table-bordered">
                                <thead>
                                    <tr>
										<th data-orderable="false">Sr.No</th>
										<th data-orderable="false">PRN</th>
										<th data-orderable="false">Name</th>
										<th data-orderable="false">Stream</th>
										<th data-orderable="false">Semester</th>
										<th data-orderable="false">Date</th>
										<!--th data-orderable="false">Category</th-->
										<?php foreach($category as $cat){?>
										<th><?=$cat['c_name']?></th>
										<?php }?>
                                        <!--th data-orderable="false">Action</th-->
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">
                                    <?php $i=1;
									/*if(!empty($esuggestions)){
							foreach($esuggestions as $ec){ ?>							
								<tr>
									<th width="5%"><?=$i?></th>
									<th width="5%"><?=$ec['prn']?></th>
									<td width="15%"><?=$ec['first_name'].' '.$ec['last_name']?></th>
									<td width="15%"><?=$ec['stream_short_name']?></th>
									<td width="5%"><?=$ec['current_semester']?></th>
									<td width="15%"><?=date('d-m-Y', strtotime($ec['suggestion_date']))?></td>
									<td width="15%"><?=$ec['c_name']?></td>
									<td><?=$ec['comment']?></td>
									
								</tr>
								<?php $i++;
                                    }
                                    }else{*/
                                        echo "<tr><td colspan=13>";echo "No data found.";echo "</td></tr>";
                                    //}
                                    ?>                            
                                </tbody>
                            </table>                    
                            <?php //}   ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">

<script>
$(document).ready(function() {
    $('#example').DataTable();
	         $('#search').on('click', function(){
            //alert('alert');
                var category = '';//$("#category").val();
				var type = $("input[name='type']:checked").val();
                if (type !='') {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url() ?>Feedback/fetch_escatwise_list',
                        data: {category:category,type:type},
                        success: function (html) {
                            $("#itemContainer").html(html);
                        }
                    });
                }else{
                    alert('Please select all The input fields.');
                }

        });
} );
</script>