<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">College Master</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;College</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add College</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php } ?>
                    <?php if(in_array("Search", $my_privileges)) { ?>
                    <form class="pull-right col-xs-12 col-sm-6" action="">
                        <div class="input-group no-margin">
                            <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                <?php
                                    for($i=0;$i<count($college_details);$i++)
                                    {
                                ?>
                                <option value="<?=$college_details[$i]['college_id']?>"><?=$college_details[$i]['college_name']." [ ".$college_details[$i]['campus_name']." ] "?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </form>
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
                    <div class="table-info table-responsive">    
                    <?php if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Campus name</th>
                                    <th>College Code</th>
                                    <th>College Name</th>
                                    <th>College State</th>
                                    <th>College City</th>
                                    <th>College Pincode</th>
                                    <th>College Address</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;                            
                            for($i=0;$i<count($college_details);$i++)
                            {
                                
                            ?>
                            <tr <?=$college_details[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>                                                                
                                <td><?=$college_details[$i]['campus_name']?></td>
                                <td><?=$college_details[$i]['college_code']?></td>
                                <td><?=$college_details[$i]['college_name']?></td>
                                <td><?=$college_details[$i]['college_state']?></td>
                                <td><?=$college_details[$i]['college_city']?></td>
                                <td><?=$college_details[$i]['college_pincode']?></td>
                                <td><?=$college_details[$i]['college_address']?></td>
                                <td>
                                    <?php if(in_array("Edit", $my_privileges)) { ?>
                                    <a href="<?=base_url($currentModule."/edit/".$college_details[$i]['college_id'])?>"><i class="fa fa-edit"></i></a>                                                                        
                                    <?php } ?>
                                    <?php if(in_array("Delete", $my_privileges)) { ?>
                                    <a href='<?=base_url($currentModule).$college_details[$i]["status"]=="Y"?"disable/".$college_details[$i]["college_id"]:"enable/".$college_details[$i]["college_id"]?>'><i class='fa <?=$college_details[$i]["status"]=="Y"?"fa-ban":"fa-check"?>' title='<?=$college_details[$i]["status"]=="Y"?"Disable":"Enable"?>'></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php } ?>
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
  $("#search_me").select2({
      placeholder: "Enter college name",
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
                    for(i=0;i<array.college_details.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                                
                        str+='<td>'+array.college_details[i].campus_name+'</td>';
                        str+='<td>'+array.college_details[i].college_code+'</td>';
                        str+='<td>'+array.college_details[i].college_name+'</td>';
                        str+='<td>'+array.college_details[i].college_state+'</td>';
                        str+='<td>'+array.college_details[i].college_city+'</td>';                        
                        str+='<td>'+array.college_details[i].college_pincode+'</td>';
                        str+='<td>'+array.college_details[i].college_address+'</td>';
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+array.college_details[i].college_id+'"><i class="fa fa-edit"></i></a>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/disable/'+array.college_details[i].college_id+'"><i title="Disable" class="fa fa-ban"></i></a>';
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