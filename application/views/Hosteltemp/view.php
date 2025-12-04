<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
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
				
                <div class="panel-body" style="overflow-x:scroll;height:500px;">
                    <div class="table-info" >    
                       <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Campus</th>
									<th>In-Campus</th>
                                    <th>#Floor</th>
                                    <th>#Room</th>
                                    <th>#Increased Capacity</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;    
                          //  var_dump($_SESSION);
                            for($i=0;$i<count($hostel_details);$i++)
                            {
                                
                            ?>
                            <tr <?=$hostel_details[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>
                                <td><?=$hostel_details[$i]['hostel_name']?></td>
                                <td><?=$hostel_details[$i]['hostel_code']?></td>
                                <td><?=$hostel_details[$i]['hostel_type']=='B'?'Boys':'Girls'?></td>
								<td><?=$hostel_details[$i]['campus_name']?></td>
                                <td><?=$hostel_details[$i]['in_campus']=='Y'?'Yes':'No'?></td>
                                <td><?=$hostel_details[$i]['no_of_floors']?></td>
                                <td><?=$hostel_details[$i]['no_of_rooms']?></td>
                                <td><?=$hostel_details[$i]['no_of_beds']?></td>
                                <td>
								   <a style="width: 20%;" title="Edit Hostel Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit/".$hostel_details[$i]['host_id'])?>">Edit</a>
								   
								   <a style="width: 30%;" title="View Hostel Room Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/view_room_details/".$hostel_details[$i]['host_id'])?>" style="padding-left: 5px;">Room</a>
								   
								   <a style="width: 25%;" title="View Hostel's Allocation Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/hostel_allocation_view/".$hostel_details[$i]['host_id'])?>" style="padding-left: 5px;">View</a>
								   
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
<script>

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