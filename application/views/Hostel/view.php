<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
         <li class="active"><a href="<?=base_url($currentModule)?>">Hostel </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Hostel List</h1>
			
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					   <hr class="visible-xs no-grid-gutter-h">
                    
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    
                    
                   
                </div>
            </div>
			
			<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>

        </div>
       
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">Hostel Details</span>
                        
                </div>
				
                <div class="panel-body" >
                    <div class="table-info" >    
                       <table class="table table-bordered" id="hostel_table">
                        <thead>
                            <tr>
                                    <th  width="3%">#</th>
                                    <th>Name</th>
                                    <th  width="3%">Code</th>
                                    <th  width="3%">Type</th>
                                    <th  width="3%">Campus</th>
									<th  width="3%">In-Campus</th>
                                    <th  width="3%">#Floor</th>
                                    <th  width="3%">#Room</th>
                                    <th width="3%">#Capacity</th>
                                    <th width="3%">#Allocated</th>
                                    <th width="3%">#Vacant</th>
                                    <th>Owner</th>
                                    <th width="3%">Rent</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;    
                          //  var_dump($_SESSION);
						  $roles_id = $this->session->userdata('roles_id');
                            for($i=0;$i<count($hostel_details);$i++)
                            {
                                $owners = get_hostel_owners($hostel_details[$i]['host_id']);	

								$ownersdetails = ''; // Initialize as empty string
								$rent='';
								$fmt = new \NumberFormatter('en_IN', NumberFormatter::CURRENCY);
						
								foreach ($owners as $o) {
									$rent = $fmt->formatCurrency($o['rent_amount'], 'INR');	
									$ownersdetails .= "{$o['owner_name']} ({$o['academic_year']}) - From: {$o['from_date']} To: {$o['to_date']}";
								}
                            ?>
                            <tr <?=$hostel_details[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>
                                <td ><?=$hostel_details[$i]['hostel_name']?></td>
                                <td><?=$hostel_details[$i]['hostel_code']?></td>
                                <td><?=$hostel_details[$i]['hostel_type']=='B'?'Boys':'Girls'?></td>
								<td><?=$hostel_details[$i]['campus_name']?></td>
                                <td><?=$hostel_details[$i]['in_campus']=='Y'?'Yes':'No'?></td>
                                <td><?=$hostel_details[$i]['no_of_floors']?></td>
                                <td><?=$hostel_details[$i]['no_of_rooms']?></td>
                                <td><?=$hostel_details[$i]['no_of_beds']?></td>
                                <td><?=$hostel_details[$i]['allocated_students']?></td>
                                <td><?=$hostel_details[$i]['vacant']?></td>
								<td width="20%">
								
								<?php
									$owners = get_hostel_owners($hostel_details[$i]['host_id']); // 👈 using helper
									if (!empty($ownersdetails)) {
									  echo  "<em>".$ownersdetails."</em>";
									  
									} else {
									  //echo "<em>No owners assigned</em>";
									}
								  ?>
								</td>
								<td><?=$rent?></td>
                                <td width="20%">
								<?php  $name=$this->session->userdata('name');
									//if($roles_id==6){
									if($name=='hostel_nashik'){
									
									?>
								   <a style="width: 10%;" title="Edit Hostel Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit/".$hostel_details[$i]['host_id'])?>">Edit</a>
								
								   <a style="width: 10%;" title="View Hostel Room Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/view_room_details/".$hostel_details[$i]['host_id'])?>" style="padding-left: 5px;">Room</a>
								   <?php }?>
								   <a style="width: 10%;" title="View Hostel's Allocation Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/hostel_allocation_view/".$hostel_details[$i]['host_id'])?>" style="padding-left: 5px;">View</a>
								   
								    <a style="width: 12%;margin-right: 4px;" title="Excel Hostel's Allocation Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/hostel_allocation_excel/".$hostel_details[$i]['host_id'])?>" style="padding-left: 4px;margin-right: 4px;">Excel</a>
									<button class="btn btn-primary btn-xs" onclick="openOwnerModal(<?=$hostel_details[$i]['host_id']; ?>, '<?= $hostel_details[$i]['hostel_name']; ?>')" style="float: right;">Add Owner</button>
									
								   
								</td>
								
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
<div class="modal fade" id="ownerModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="ownerForm" method="post" action="<?= base_url('hostel/save_owner') ?>">
      <input type="hidden" name="hostel_id" id="modal_hostel_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Owner for <span id="hostelNameText"></span></h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label>Owner Name</label>
              <input type="text" name="owner_name" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Academic Year</label>
              <input type="text" name="academic_year" class="form-control" placeholder="e.g. 2024-25" required>
            </div>
            <div class="form-group">
              <label>From Date</label>
              <input type="date" name="from_date" class="form-control" required>
            </div>
            <div class="form-group">
              <label>To Date</label>
              <input type="date" name="to_date" class="form-control">
            </div>
            <div class="form-group">
              <label>Rent Amount (₹)</label>
              <input type="number" name="rent_amount" step="0.01" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Owner</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#hostel_table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Hostel_List_Export',
                text: '<i class="fa fa-file-excel-o"></i> Excel Export',
                className: 'btn btn-success',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // exclude Action column
                }
            }
        ],
        pageLength: 50
    });
});
function openOwnerModal(hostelId, hostelName) {
  $('#modal_hostel_id').val(hostelId);
  $('#hostelNameText').text(hostelName);
  $('#ownerForm')[0].reset();
  $('#ownerModal').modal('show');
}

$(document).ready(function(){
	    // Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
});


  /* $("div.holder").jPages
  ({
    containerID : "itemContainer"
  }); */
  $("#search_me").select2({
      placeholder: "Enter Hostel name",
      allowClear: true
    });
        $("#search_me").on('change',function()
        {
			//alert("called");
            var search_val = $(this).val();            
            var url  = "<?=base_url().strtolower($currentModule).'/search/'?>";	
            var data = {title: search_val};		
            var type="";
            var type_name="";
            $.ajax
            ({
                type: "POST",
                url: url,
                data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {                       
                    var array=JSON.parse(data);
                    var str="";
					alert(hostel_details[0].hostel_name);
                    for(i=0;i<array.hostel_details.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                               
                        str+='<td>'+array.hostel_details[i].hostel_name+'</td>';
                        str+='<td>'+array.hostel_details[i].hostel_code+'</td>';
                        str+='<td>'+array.hostel_details[i].hostel_type+'</td>';
                        str+='<td>'+array.hostel_details[i].in_campus+'</td>';
                        str+='<td>'+array.hostel_details[i].no_of_floors+'</td>';                        
                        str+='<td>'+array.hostel_details[i].no_of_rooms+'</td>';
                        str+='<td>'+array.hostel_details[i].no_of_beds+'</td>';
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+array.hostel_details[i].host_id+'"><i class="fa fa-edit"></i></a>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/disable/'+array.hostel_details[i].host_id+'"><i title="Disable" class="fa fa-ban"></i></a>';
                        str+='</td>';
                        str+='</tr>';
                        $("#itemContainer").html(str);
                    }
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
</script>