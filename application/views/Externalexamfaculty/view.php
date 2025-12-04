
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
        <li class="active"><a href="#">External Faculty Masters</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;External Faculty</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add/".base64_encode($btype))?>"><span class="btn-label icon fa fa-plus"></span>Add External Faculty</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php //} ?>

                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
		
		<!-- Loader Element -->
		<div id="loader" style="display:none;">
		  <div class="spinner"></div>
		</div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title" style="color: white !important;">External Faculty List</span>
                        <div class="holder"></div>
                </div>
                <div class="panel-body">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered" id='example'>
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Designation</th>
									<th>Campus Type</th>
                                    <th>Institute</th>
                                    <th>Distance(KM)</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;   
                         if(!empty($campus_details)){							
                            for($i=0;$i<count($campus_details);$i++)
                            {
                                
                            ?>
                            <tr <?=$campus_details[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>                                                                
                                <td><?=$campus_details[$i]['ext_faculty_code']?></td>
                                <td><?=$campus_details[$i]['ext_fac_name']?></td>
                                <td><?=$campus_details[$i]['ext_fac_mobile']?></td>
                                <td><?=$campus_details[$i]['ext_fac_email']?></td>
                                <td><?=$campus_details[$i]['ext_fac_designation']?></td>
                                <td><?=$campus_details[$i]['campus_type']?></td>
                                <td><?=$campus_details[$i]['ext_fac_institute']?></td>
                                <td><?=$campus_details[$i]['distance_km']?></td>
                                <td>
                                    <?php //if(in_array("Edit", $my_privileges)) { ?>
                                    <a href="<?=base_url($currentModule."/edit/".$campus_details[$i]['id']."/".base64_encode($btype))?>"><i class="fa fa-edit"></i></a> 
                                  <a href="#" class=" extview" id="<?=$campus_details[$i]['id']?>" data-toggle="modal"  data-target="#myModal"><i class="fa fa-eye"></i></a>									
                                    <?php //} ?>
                                    <?php //if(in_array("Delete", $my_privileges)) { ?>
                                    <a href='<?=$campus_details[$i]["status"]=="Y"?"disable/".$campus_details[$i]["id"]:"enable/".$campus_details[$i]["id"]?>'><i class='fa <?=$campus_details[$i]["status"]=="Y"?"fa-ban":"fa-check"?>' title='<?=$campus_details[$i]["status"]=="Y"?"Disable":"Enable"?>'></i></a>
                                    <?php //} ?>
                                </td>
                            </tr>
                            <?php
                            $j++;
                            }
								}else{
									echo "<tr><td colspan=8>No data found</td></tr>";
								}
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php //} ?>
                     </div>
                   </div>
                </div>
            </div>    
        </div>
    </div>
</div>

	
	
<div id="view_tax_cal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:50%;">
    <!-- Modal content-->
    <div class="modal-content" >
       <div class="modal-header">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">&times;</button>
        <p class="modal-title" ><strong>External Details: </strong> 
        </p>
      </div>
      <div class="modal-body" >
      <div class="row table-responsive" id="emp_cnt">    
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </div>
    </div>
<script>
  $(document).ready(function() {

   $('#example').DataTable({
			orderCellsTop: true,
			fixedHeader: true,
			dom: 'lBfrtip',
			destroy: true,
			retrieve:true,
			paging:true,
			
			 buttons: [
			 {
				  extend: 'excel',
               exportOptions: {
                columns: [0,1,2,3,4,5,6] 
               }
			 }
			], 
			lengthMenu: [[50, 100, 150, -1], [50, 100, 150, "All"]],			
		  });		   
});		
		
		  $(".extview").on('click',function()
        {
			$("#emp_cnt").html('');
            var eid = $(this).attr('id');
            var btype='<?=base64_decode($btype)?>';

             var url  = "<?=base_url().strtolower($currentModule).'/get_external_details/'?>"+eid+"/"+btype; 
        
            $.ajax
            ({
                type: "POST",
                url: url,
               // data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {  
                $("#empid").text(eid);
                $("#emp_cnt").html(data);
				$("#view_tax_cal").modal('show');
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
		
$(document).ready(function(){
  // Show loader on AJAX start
  $(document).ajaxStart(function(){
    $("#loader").show();
  });

  // Hide loader on AJAX complete
  $(document).ajaxStop(function(){
    $("#loader").hide();
  });
});
</script>