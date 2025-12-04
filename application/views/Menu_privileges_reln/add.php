<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
    .child_menus
    {
        padding: 5px
    }
</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
//    echo "<pre>"; print_r($menu_details['level_1']);
//    print_r($privileges_details);
    //echo "</pre>"; //die;
    
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li><a href="#">Menu Privileges Mapping</a></li>
        <li class="active"><a href="#">Add Mapping</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Mapping</h1>
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
                            <span class="panel-title">Mapping Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">
                            <?php if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST" onsubmit="return validate_form();">                                                                                               
                                <input type="hidden" id="action" name="action" value="add" /> 
                                    <div class="form-group col-sm-12">
                                    <div id="accordion-warning-example" class="panel-group panel-group-warning">
                                        <?php for($i=0;$i<count($menu_details['level_0']);$i++) { ?>
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <input class="level_0" type="checkbox" name="prev[<?=$menu_details['level_0'][$i]['menu_id']?>][]" id="menu_<?=$menu_details['level_0'][$i]['menu_id']?>" value="0">
                                                
                                                    <a href="#collapse<?=$menu_details['level_0'][$i]['menu_id']?>-warning" data-parent="#accordion-warning-example" data-toggle="collapse" class="accordion-toggle collapsed">
                                                        <i class="<?=$menu_details['level_0'][$i]['icon']?>"></i> <label><?=$menu_details['level_0'][$i]['menu_name']?> </label>                                                                                                              
                                                    </a>
                                            </div> <!-- / .panel-heading -->
                                            <div class="panel-collapse collapse" id="collapse<?=$menu_details['level_0'][$i]['menu_id']?>-warning">
                                                
                                                    <div class="panel-body">
                                                            <div id="accordion-danger-example" class="panel-group panel-group-danger">
                                                                <?php if($i!=0) { ?>
                                                                    <input class="level_0" type="checkbox" id="select_all_<?=$menu_details['level_0'][$i]['menu_id']?>" value="<?=$menu_details['level_0'][$i]['menu_id']?>" onclick="change_childs_value(this)" > Select All                                                                 
                                                                <?php } ?>
                                                                <?php for($j=0;$j<count($menu_details['level_1'][$menu_details['level_0'][$i]['menu_id']]);$j++) { ?> 
									<div class="panel">
										<div class="panel-heading child_menus">
                                                                                    <input type="checkbox" id="menu_level_<?=$menu_details['level_1'][$menu_details['level_0'][$i]['menu_id']][$j]['menu_id']?>" value="<?=$menu_details['level_0'][$i]['menu_id']?>" />&nbsp;&nbsp;                                                                                                                                                                   
                                                                                    <label><?=$menu_details['level_1'][$menu_details['level_0'][$i]['menu_id']][$j]['menu_name']?></label>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp                                                                                                
                                                                                    <input type="checkbox" id="select_all_<?=$menu_details['level_1'][$menu_details['level_0'][$i]['menu_id']][$j]['menu_id']?>" value="<?=$menu_details['level_1'][$menu_details['level_0'][$i]['menu_id']][$j]['menu_id']?>" onclick="change_childs_value2(this)" />&nbsp;&nbsp; Select All &nbsp;&nbsp;&nbsp;                                                                                                                                                                    
                                                                                    <div style="padding-right:20px" class="child_menus_1">&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        
                                                                                        <?php
                                                                                            for($k=0;$k<count($privileges_details);$k++)
                                                                                            {
                                                                                        ?>   
                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="prev_<?=$privileges_details[$k]["privileges_id"]?>" name="prev[<?=$menu_details['level_1'][$menu_details['level_0'][$i]['menu_id']][$j]['menu_id']?>][]" value="<?=$privileges_details[$k]['privileges_id']?>" onclick="change_parents_value(this,<?=$menu_details['level_1'][$menu_details['level_0'][$i]['menu_id']][$j]['menu_id']?>)" /> <?=$privileges_details[$k]['privileges_name']?>
                                                                                        <?php
                                                                                            }
                                                                                        ?>
                                                                                    </div>
										</div>
									</div>
                                                                        <?php } ?>
								</div>
                                                    </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>                                                               
                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div><script>
    $("#add_menu").click(function()
    {        
    });
    
    function change_childs_value(elem)
    {
        var parent_val=document.getElementById(elem.id).checked; 
        
        $("#"+elem.id).siblings().find("input[type=checkbox]").each(function(){
            $(this).prop("checked",parent_val)
            
        });                
    }
    
    function change_childs_value2(elem)
    {
        var parent_val=document.getElementById(elem.id).checked; 
        var parent_id = $("#"+elem.id).parent().find("input[type=checkbox]").attr("id");        
        $("#"+parent_id).prop("checked",parent_val);            
        
        $("#"+elem.id).siblings().find("input[type=checkbox]").each(function()
        {
            $(this).prop("checked",parent_val)            
        });               
    }
    function change_parents_value(elem,_id)
    {        
        $("#menu_level_"+_id).prop("checked",true)
    }
    function validate_form()
    {
        var flag=false;
        $("#form").find("input[type=checkbox]").each(function()
        {
            if($(this).is(":checked")==true)
            {
                flag=true;                
            }
            //console.log($(this).attr("id")+"===>"+$(this).attr("value")+$(this).is(":checked"))
        });  
        if(flag==false)
        {
            alert("Please select at least one checkbox.");
        }
        return flag;
    }
</script>
