<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script>
$(document).ready(function()
{
	$('#sss').keyup( function() {
    //alert('gg');
       var that = this;
        // affect all table rows on in systems table
        var tableBody = $('.table-bordered tbody');
        var tableRowsClass = $('.table-bordered tbody tr');
        $('.search-sf').remove();
        tableRowsClass.each( function(i, val) {        
            //Lower text for case insensitive
            var rowText = $(val).text().toLowerCase();
            var inputText = $(that).val().toLowerCase();
            if( rowText.indexOf( inputText ) == -1 )
            {
                //hide rows
                tableRowsClass.eq(i).hide();                
            }
            else
            {
                $('.search-sf').remove();
                tableRowsClass.eq(i).show();
            }
        });
        //all tr elements are hidden
        if(tableRowsClass.children(':visible').length == 0)
        {
            tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="8">No records  found.</td></tr>');
        }
    });
});
</script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Transport</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Bus Allocation List</h1>
			<div class="pull-right col-xs-4 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/bus_allocation")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>

		
        </div>

        <div class="row ">
            <div class="col-sm-12">
               <div class="panel">
             	<div class="panel-heading">
                    <span class="panel-title"><b>Details</b></span><span id="err_msg" style="color:red;padding-left:50px;"></span>
					
			<span id="flash-messages" style="color:Green;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
			<span id="flash-messages" style="color:red;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
			 
			 <div class="pull-right col-sm-3">
				<input type="text" class="form-control" name="sss" id="sss" placeholder="Search">                                     
			</div>
			 
                </div>	
				<div class="panel-body" >
                <?php
				if(!empty($allocatedbus_details))
				{
					?>
                    <div class="table-info table-responsive">    
                    
                    <table class="table table-bordered" style="max-width:100%;">
                        <thead>
						<tr>
                                    <th>#</th>
                                    
									<th>Bus Number</th>
									<th>Vendor Name</th>
									<th>Route Name</th>
                                    <th>Driver Name</th>
									
									<th>Pickup Time</th>
									<th>Departure Time</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                              <?php
							  
                            $j=1;                      
                            if(!empty($allocatedbus_details)){
							foreach($allocatedbus_details as $bus){
							?>	<tr>
									<!--<td><?=$bus['academic_year']?></td>-->
									<td><?=$j?></td>
									<td><?=$bus['bus_no']?></td>
									<td><?=$bus['vendor_name']?></td>
									<td><?=$bus['route_name']?></td>
									<td><?=$bus['driver_name']?></td>
									
									<td><?=$bus['pickup_time']?></td>
									<td><?=$bus['departure_time']?></td>
									<td><a title="Edit Allocation Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_bus_allocation/".$bus['driver_bus_id'])?>">Edit</a></td>
									
								</tr>
								<?php	
								$j++;
								}
                            }
								
                            ?>                           
                        </tbody>
                    </table>                    
                   
                </div>
				
				<?php
				}else{
					?>
					<h4 style="color:red;padding-left:200px;">Bus Allocation Has Not Done Yet</h4>
					<?php
				}
				  ?>
			   </div>
			</div>
		</div>
			
            </div>    
        </div>
    </div>
</div>

