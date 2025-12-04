<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a> </li><li class="active"><a href="#">Menu Privileges Mapping</a> </li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Menu Privileges Mapping</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                 
                    <?php if(in_array("Add", $my_privileges)) { ?>
                    <hr class="visible-xs no-grid-gutter-h">
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add Mapping</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php } ?>
                    <?php if(in_array("Search", $my_privileges)) { ?>
                    <form class="pull-right col-xs-12 col-sm-6" action="">
                        <div class="input-group no-margin">
                            <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                <?php
                                    for($i=0;$i<count($mapping_details);$i++)
                                    {
                                ?>
                                    <option value="<?=$mapping_details[$i]['menu_id']?>"><?=$mapping_details[$i]['menu_name']?></option>
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
                    <div class="table-info">                         
                        <?php if(in_array("View", $my_privileges)) { ?>
                            <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Menu</th>
                                    <th>Privileges</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;                 
                            $role_type="";
                            for($i=0;$i<count($mapping_details);$i++)
                            {
                                
                            ?>
                            <tr <?=$mapping_details[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>                                                                
                                <td><?=$mapping_details[$i]['menu_name']?></td>                                
                                <td><?=$mapping_details[$i]['privileges']?></td>                                
                                <td>
                                    <?php if(in_array("Edit", $my_privileges)) { ?>
                                    <?php if($mapping_details[$i]['privileges']!=""){ ?>
                                    <a href="<?=base_url($currentModule."/edit/".$mapping_details[$i]['menu_id'])?>"><i class="fa fa-edit"></i></a>                                                                        
                                    <?php } ?>
                                    <?php } ?>
                                    <?php if(in_array("Delete", $my_privileges)) { ?>
                                    <a href='<?=$mapping_details[$i]["status"]=="Y"?"disable/".$mapping_details[$i]["menu_id"]:"enable/".$mapping_details[$i]["menu_id"]?>'><i class='fa <?=$mapping_details[$i]["status"]=="Y"?"fa-ban":"fa-check"?>' title='<?=$mapping_details[$i]["status"]=="Y"?"Disable":"Enable"?>'></i></a>
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
      placeholder: "Enter Search",
      allowClear: true
    });
        $("#search_me").on('change',function()
        {
            var search_val = $(this).val();            
            var url  = "<?=base_url().strtolower($currentModule).'/search/'?>";	
            var data = {"title": search_val};		
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
                    for(i=0;i<array.mapping_details.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                                
                        str+='<td>'+array.mapping_details[i].menu_name+'</td>';                                               
                        str+='<td>'+array.mapping_details[i].privileges+'</td>';                                               
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+array.mapping_details[i].mpr_id+'"><i class="fa fa-edit"></i></a>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/disable/'+array.mapping_details[i].mpr_id+'"><i title="Disable" class="fa fa-ban"></i></a>';
                        str+='</td>';
                        str+='</tr>';
                        $("#itemContainer").html(str);
                        $("div.holder").jPages
                        ({
                            containerID : "itemContainer"
                        });
                    }
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
</script>