<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Exam Center Master</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Exam Center</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php // if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add Exam Center</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php // } ?>
                    <?php // if(in_array("Search", $my_privileges)) { ?>
                    <form class="pull-right col-xs-12 col-sm-6" action="">
                        <div class="input-group no-margin">
                            <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                <?php
                                    for($i=0;$i<count($exam_center_details);$i++)
                                    {
                                ?>
                                <option value="<?=$exam_center_details[$i]['ec_id']?>"><?=$exam_center_details[$i]['center_name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </form>
                    <?php // } ?>
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
                    <?php //  if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    
                                    <th>Center Name</th>

                                    <th> Center Code </th>

                                    <th> Address </th>

                                    <th> Land Mark </th>

                                    <th> Contact Person </th>

                                    <th> Contact Number </th>

                                    <th> Official Email </th>
                                   
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                           //print_r($exam_center_details);exit;
                            $j=1;                            
                            for($i=0;$i<count($exam_center_details);$i++)
                            {

                            ?>
                            <tr <?=$exam_center_details[$i]["is_active"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>                                                                
                              
                                <td><?=$exam_center_details[$i]['center_name']?></td>
                                <td><?=$exam_center_details[$i]['center_code']?></td>
                                <td><?=$exam_center_details[$i]['venue_address']?></td>
                                <td><?=$exam_center_details[$i]['land_mark']?></td>
                                <td><?=$exam_center_details[$i]['contact_person']?></td>
                                <td><?=$exam_center_details[$i]['contact_mobile']?></td>
                                <td><?=$exam_center_details[$i]['email_official']?></td>


                                  <td>
                                    <?php // if(in_array("Edit", $my_privileges)) { ?>
                                    <a href="<?=base_url($currentModule."/edit/".$exam_center_details[$i]['ec_id'])?>"><i class="fa fa-edit"></i></a>                                                                        
                                    <?php //} ?>
                                    <?php //if(in_array("Delete", $my_privileges)) { ?>
                                    <a href='<?=base_url($currentModule)."/"?><?=$exam_center_details[$i]["is_active"]=="Y"?"disable/".$exam_center_details[$i]["ec_id"]:"enable/".$exam_center_details[$i]["ec_id"]?>'><i class='fa <?=$exam_center_details[$i]["is_active"]=="Y"?"fa-ban":"fa-check"?>' title='<?=$exam_center_details[$i]["is_active"]=="Y"?"Disable":"Enable"?>'></i></a>
                                   <?php //} ?>
                                </td>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php // } ?>
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
                    for(i=0;i<array.exam_center_details.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                                
                        str+='<td>'+array.exam_center_details[i].center_name+'</td>';
                        str+='<td>'+array.exam_center_details[i].center_code+'</td>';
                        str+='<td>'+array.exam_center_details[i].venue_address+'</td>';
                        str+='<td>'+array.exam_center_details[i].land_mark+'</td>';
                        str+='<td>'+array.exam_center_details[i].contact_person+'</td>';
                        str+='<td>'+array.exam_center_details[i].contact_mobile+'</td>';
                        str+='<td>'+array.exam_center_details[i].email_official+'</td>';
                        //str+='<td>'+array.exam_center_details[i].Exam Center_type+'</td>';
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+array.exam_center_details[i].ec_id+'"><i class="fa fa-edit"></i></a>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/disable/'+array.exam_center_details[i].ec_id+'"><i title="Disable" class="fa fa-ban"></i></a>';
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