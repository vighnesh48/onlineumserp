<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPage2s.css">
<script src="<?=base_url('assets/javascripts')?>/jPag2es.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js" type="text/javascript"></script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Inventory Master</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Inventory In/Out List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add Inventory </a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php } ?>
                    <?php /* if(in_array("Search", $my_privileges)) { ?>
                    <form class="pull-right col-xs-12 col-sm-6" action="">
                        <div class="input-group no-margin">
                            <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                <?php
                                    for($i=0;$i<count($product_details);$i++)
                                    {
                                ?>
                                <option value="<?=$color_details[$i]['id']?>"><?=$color_details[$i]['colorname']?></option>
                                <?php
                                    }
                                ?>
								
                            </select>
                        </div>
                    </form>
                    <?php } */ ?>
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
                    <?php// if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered" id='example'>
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>School Name</th>
									<th>Gender</th>
                                    <th>Product Name</th>
									<th>Product Size Name</th>
									<!--<th>Color Name</th>-->
									<th>IN</th>
									<th>Out</th>
									<th>Remaining</th>
                                   <!-- <th>Action</th>-->
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;
                           							
							 	 //echo "<pre>";print_r($inventory_details); die;							
                               for($i=0;$i<count($inout_uniform_data);$i++) {
								   
			$remaining=(($inout_uniform_data[$i]['invalue'])-($inout_uniform_data[$i]['outvalue']));
                            ?>
                            <tr <?=$inventory_details[$i]["is_active"]=="1"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>  
                                <td><?=$inout_uniform_data[$i]['school_name']?></td>
								<td><?=$inout_uniform_data[$i]['gender']?></td>
								<td><?=$inout_uniform_data[$i]['product_name']?></td>
                                <td><?=$inout_uniform_data[$i]['sizecode']?></td>
								 <td><?=$inout_uniform_data[$i]['invalue']?></td>
								 <td><?=$inout_uniform_data[$i]['outvalue']?></td>
								 <td><?=$remaining?></td>
                                <!--<td> <?php /*
                                    <?php if(in_array("Edit", $my_privileges)) { ?>
                                    <a href="<?=base_url($currentModule."/edit/".$inventory_details[$i]['id'])?>"><i class="fa fa-edit"></i></a>                                                                        
                                    <?php } ?>
                                    <?php /* if(in_array("Delete", $my_privileges)) { ?>
                                    <a href='<?=base_url($currentModule)."/"?><?=$color_details[$i]["is_active"]=="Y"?"disable/".$color_details[$i]["id"]:"enable/".$color_details[$i]["id"]?>'><i class='fa <?=$color_details[$i]["is_active"]=="1"?"fa-ban":"fa-check"?>' title='<?=$color_details[$i]["is_active"]=="1"?"Disable":"Enable"?>'></i></a>
                                    <?php }*/ ?>
                                </td>
								-->
                            </tr>
                            <?php
                            $j++;
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
 <script type='text/javascript'>	
$(document).ready(function () {
    var table = $('#example').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
		dom: 'lBfrtip',
	    "bPaginate": false,
		"bInfo": false,
		searching: false,
        buttons: [
             'excel'
        ],
    });
});
 </script>
<script>
  $("div.holder").jPages
  ({
    containerID : "itemContainer"
  });
  $("#search_me").select2({
      placeholder: "Enter title",
      allowClear: true
    });
        $("#search_me").on('change',function()
        {
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
                    var str2="";
                    for(i=0;i<array.designation_details.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                                
                        str+='<td>'+array.designation_details[i].designation_code+'</td>';
                        str+='<td>'+array.designation_details[i].designation_name+'</td>';                        
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+array.designation_details[i].designation_id+'"><i class="fa fa-edit"></i></a>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/disable/'+array.designation_details[i].designation_id+'"><i title="Disable" class="fa fa-ban"></i></a>';
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