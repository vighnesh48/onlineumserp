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
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li><a href="#">Rolewise Privileges Mapping</a></li>        
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
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST" onsubmit="return validate_form();">                                                                                               
                                <input type="hidden" id="action" name="action" value="edit" /> 
                                <div class="form-group">
                                    <div class="col-sm-4">            
                                        <label>Select Role</label>
                                        <select class="form-control" id="roles_id" name="roles_id">
                                            <option value="">Select Roles</option>
                                            <?php for($i=0;$i<count($roles_details);$i++) { ?>
                                            <option value="<?=$roles_details[$i]['roles_id']?>" <?=$roles_id==$roles_details[$i]['roles_id']?"selected='selected'":""?>><?=$roles_details[$i]['roles_name']?></option>
                                            <?php } ?>                                            
                                        </select>                                        
                                    </div>       
                                    <div class="col-sm-8">
                                        <div class="panel-group panel-group-warning" id="accordion-warning-example">
                                            <?php for($i=0;$i<count($menu_details['level_0']);$i++) { ?>
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <input type="checkbox" value="<?='0'?>" id="menu_<?=$menu_details['level_0'][$i]['menu_id']?>" name="prev[<?=$menu_details['level_0'][$i]['menu_id']?>][]" onclick="change_childs_value(this)"  
                                                           <?=in_array($menu_details['level_0'][$i]['menu_id'],$selected_menus)?'checked':''?>
                                                    >                                                
                                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-warning-example" href="#collapse<?=$menu_details['level_0'][$i]['menu_id']?>-warning">
                                                            <i class="menu-icon fa fa-dashboard"></i> <label><?=$menu_details['level_0'][$i]["menu_name"]?> </label>                                                                                                              
                                                        </a>
                                                </div> <!-- / .panel-heading -->
                                                <div id="collapse<?=$menu_details['level_0'][$i]['menu_id']?>-warning" class="panel-collapse collapse">                                                
                                                    <div class="panel-body">
                                                        <div class="panel-group panel-group-danger" id="accordion-danger-example">
                                                            <ul style="list-style-type:none" class="myclass">                                                            
                                                            <?php for($j=0;$j<count($menu_details['level_1'][$menu_details['level_0'][$i]['menu_id']]);$j++) { ?>
                                                                <li>
                                                                    <input type="checkbox" id="menu_<?=$menu_details['level_1'][$menu_details['level_0'][$i]['menu_id']][$j]['menu_id']?>" onclick="change_childs_value2(this)" parent="<?=$menu_details['level_0'][$i]['menu_id']?>"
                                                                           <?=in_array($menu_details['level_1'][$menu_details['level_0'][$i]['menu_id']][$j]['menu_id'],$selected_menus)?'checked':''?> />
                                                                    <?=$menu_details['level_1'][$menu_details['level_0'][$i]['menu_id']][$j]['menu_name']?>                                                                                                                                        
                                                                    <?php                                                                    
                                                                    $cur_menu_id=$menu_details['level_1'][$menu_details['level_0'][$i]['menu_id']][$j]['menu_id'];
                                                                    ?>
                                                                    
                                                                    <ul class="ul_<?=$cur_menu_id?>">
                                                                        <li style="display: inline;"><input type="checkbox" id="select_all_<?=$cur_menu_id?>" onclick="change_childs_value(this)" parent="<?=$cur_menu_id?>" /> Select All </li>
                                                                        <li style="display: inline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>                                                                            
                                                                        <?php   
                                                                        $new_array=$menuwise_privileges_details[$cur_menu_id];
                                                                        
                                                                        for($k=0;$k<count($new_array['privileges_id']);$k++)                                                                       
                                                                        {
                                                                            //echo '<li style="display: inline;">'.'   '.'<input type="checkbox" name="prev['.$cur_menu_id.'][]" id="priv_'.$cur_menu_id.'_'.'" value="'.$new_array['privileges_id'][$k].'" onclick="change_parents_value(this)">'.'   '.$new_array['privileges_name'][$k].'</li>';
                                                                            $str="";
                                                                            if(in_array($new_array['privileges_id'][$k], $access_details[$cur_menu_id]['privileges_id']))
                                                                            {
                                                                                $str="checked";
                                                                            }
                                                                            echo "<li style='display:inline'>"."    "."<input type='checkbox' parent='".$cur_menu_id."' name='prev[".$cur_menu_id."][]' value='".$new_array['privileges_id'][$k]."' id='prev_".$cur_menu_id."_".$new_array['privileges_id'][$k]."' onclick='change_parents_value(this)' $str />"."     ".$new_array['privileges_name'][$k]."</li>";
                                                                        }
                                                                        ?>
                                                                        <li style="display: inline;"><hr></li>                                                                            
                                                                    </ul>
                                                                    <?php
                                                                    ?>
                                                                    
                                                                </li>
                                                            <?php } ?>
                                                            </ul>
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
    
    function change_childs_value2(elem)
    {   
        var parent_val=document.getElementById(elem.id).checked;         
        var parent=$("#"+elem.id).attr("parent");
        $("#menu_"+parent).prop("checked",true);
        $("#"+elem.id).parent().children("ul").children().find("input[type=checkbox]").each(function()
        {
            $(this).prop("checked",parent_val);
        })
    }
    
    function change_childs_value(elem)
    {        
        var parent_val=document.getElementById(elem.id).checked;         
        var parent=$("#"+elem.id).attr("parent");
        
        $("#"+elem.id).parent().parent().children("li").find("input[type=checkbox]").each(function()
        {
            $(this).prop("checked",parent_val);
            $("#menu_"+parent).prop("checked",parent_val);
            
        })
    }    
    function change_parents_value(elem)
    {        
        var _id =$("#"+elem.id).attr("parent");
        $("#menu_"+_id).prop("checked",true);
        var parent=$("#menu_"+_id).attr("parent");
        $("#menu_"+parent).prop("checked",true);
    }
    function validate_form()
    {
        var flag=false;
        var roles_id=$("#roles_id").val();
        
        if(roles_id=="")
        {
            alert("Please select role.");
            $("#roles_id").focus();
            return flag;
        }
        
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
