<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
        $('#form').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: 
            {
                menu_level:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select Menu Level'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Invalid Menu level selected.'
                      }
                    }

                }, 
                menu_parent:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select Menu Parent'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Invalid Menu Parent selected.'
                      }
                    }

                },
                menu_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please enter Menu name'
                      }
                    }

                },
                menu_path:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please enter Menu URL'
                      }
                    }

                },
                menu_seq:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select Menu Level'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Invalid Menu sequence number mentioned.'
                      }
                    }

                }, 
            }       
        })
        
        $("#menu_level").on('change',function()
        {
            var menu_level= $("#menu_level").val();
            var data={"parent":"0"}
            if(menu_level!="")
            {
                switch(menu_level)
                {
                    case "0":
                        str="<option value='0'>None</option>";
                        $("#menu_parent").html(str);
                        $("#menu_parent").attr("readonly","true");
                    break;
                    case "1":
                        var url  = "<?=base_url().strtolower($currentModule).'/get_parent_menus/'?>";                        
                        $.ajax
                        ({
                            type: "POST",
                            url: url,
                            dataType: "html",
                            data:data,
                            cache: false,
                            crossDomain: true,
                            success: function(data)
                            {     
                                var array=JSON.parse(data);
                                var str="";
                                for(i=0;i<array.menu_details.length;i++)
                                {
                                    if(array.menu_details[i].status=='Y')
                                    str+="<option value='"+array.menu_details[i].menu_id+"'>"+array.menu_details[i].menu_name+"</option>";                                    
                                }
                                $("#menu_parent").html(str);
                            },
                            error: function(data)
                            {
                                alert("Page Or Folder Not Created..!!");
                            }
                        });
                    break;
                }
            }
        });
        
        
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Add Menu</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Menu</h1>
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
                            <span class="panel-title">Menu Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">
                            <?php if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                               
                                <input type="hidden" value="" id="menu_id" name="menu_id" />
                                <div class="form-group">
                                    <label class="col-sm-3">Menu Level<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="menu_level" name="menu_level" class="form-control">
                                            <option value="">Select Level</option>
                                            <option value="0">Parent</option>
                                            <option value="1">Child</option>
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('menu_level');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Menu Parent</label>
                                    <div class="col-sm-6">
                                        <select id="menu_parent" name="menu_parent" class="form-control">                                        
                                            <option value="">Select Parent</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('menu_parent');?></span></div>
                                </div>   
                                <div class="form-group">
                                    <label class="col-sm-3">Menu Name (Visual Name) <?=$astrik?></label>
                                    <div class="col-sm-6"><input type="text" id="menu_name" name="menu_name" class="form-control" value="<?=isset($_REQUEST['menu_name'])?$_REQUEST['menu_name']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('menu_name');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Menu URL(Controller name/method name ) <?=$astrik?></label>
                                    <div class="col-sm-6"><input type="text" id="menu_path" name="menu_path" class="form-control" value="<?=isset($_REQUEST['menu_path'])?$_REQUEST['menu_path']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('menu_path');?></span></div>
                                </div>          
                                <div class="form-group">
                                    <label class="col-sm-3">Menu Sequence<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="menu_seq" name="menu_seq" class="form-control">
                                            <option value="">Select Sequence</option>
                                            <?php
                                                for($i=1;$i<=100;$i++)
                                                {
                                            ?>
                                            <option value="<?=$i?>"><?=$i?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('menu_level');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Menu Icon <?=$astrik?></label>
                                    <div class="col-sm-6" icon="menu">
                                        <input type="text" name="menu_icon" id="menu_icon" placeholder="Choose Your iCon" class="form-control" <?=isset($_REQUEST['menu_icon'])?$_REQUEST['menu_icon']:''?> readonly/>	
                                        <label class="col-sm-4 control-label">Menu iCon Preview</label>                            
                                        <div class="col-sm-8" icon="preview" id="preview" style="margin-top:8px;">                            	
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <span class="panel-title">Menu iCon's</span>
                                                </div>
                                                <div class="panel-body">    
						<div class="panel-group" id="accordion-example">
							<div class="panel">
                                                                <div class="panel-heading">
                                                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-example" href="#collapseOne">
                                                                                Web Application Icons
                                                                        </a>
                                                                </div> <!-- / .panel-heading -->
                                                                <div id="collapseOne" class="panel-collapse collapse" style="height: 0px;">
                                                                        <div class="panel-body">										
                                                                            <div class="row myclass">
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-adjust"></i>&nbsp;&nbsp;&nbsp;adjust</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-anchor"></i>&nbsp;&nbsp;&nbsp;anchor</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-archive"></i>&nbsp;&nbsp;&nbsp;archive</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-arrows"></i>&nbsp;&nbsp;&nbsp;arrows</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-arrows-h"></i>&nbsp;&nbsp;&nbsp;arrows-h</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-arrows-v"></i>&nbsp;&nbsp;&nbsp;arrows-v</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-asterisk"></i>&nbsp;&nbsp;&nbsp;asterisk</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-ban"></i>&nbsp;&nbsp;&nbsp;ban</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;&nbsp;bar-chart-o</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-barcode"></i>&nbsp;&nbsp;&nbsp;barcode</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-bars"></i>&nbsp;&nbsp;&nbsp;bars</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-beer"></i>&nbsp;&nbsp;&nbsp;beer</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-bell"></i>&nbsp;&nbsp;&nbsp;bell</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-bell-o"></i>&nbsp;&nbsp;&nbsp;bell-o</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-bolt"></i>&nbsp;&nbsp;&nbsp;bolt</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-book"></i>&nbsp;&nbsp;&nbsp;book</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-bookmark"></i>&nbsp;&nbsp;&nbsp;bookmark</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-bookmark-o"></i>&nbsp;&nbsp;&nbsp;bookmark-o</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-briefcase"></i>&nbsp;&nbsp;&nbsp;briefcase</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-bug"></i>&nbsp;&nbsp;&nbsp;bug</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-building-o"></i>&nbsp;&nbsp;&nbsp;building-o</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-bullhorn"></i>&nbsp;&nbsp;&nbsp;bullhorn</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-bullseye"></i>&nbsp;&nbsp;&nbsp;bullseye</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;calendar</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-calendar-o"></i>&nbsp;&nbsp;&nbsp;calendar-o</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-camera"></i>&nbsp;&nbsp;&nbsp;camera</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-camera-retro"></i>&nbsp;&nbsp;&nbsp;camera-retro</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-caret-square-o-down"></i>&nbsp;&nbsp;&nbsp;caret-square-o-down</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-caret-square-o-left"></i>&nbsp;&nbsp;&nbsp;caret-square-o-left</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-caret-square-o-right"></i>&nbsp;&nbsp;&nbsp;caret-square-o-right</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-caret-square-o-up"></i>&nbsp;&nbsp;&nbsp;caret-square-o-up</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-certificate"></i>&nbsp;&nbsp;&nbsp;certificate</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;check</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;&nbsp;check-circle</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;&nbsp;check-circle-o</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-check-square"></i>&nbsp;&nbsp;&nbsp;check-square</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;&nbsp;check-square-o</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-circle"></i>&nbsp;&nbsp;&nbsp;circle</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-circle-o"></i>&nbsp;&nbsp;&nbsp;circle-o</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;&nbsp;clock-o</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-cloud"></i>&nbsp;&nbsp;&nbsp;cloud</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-cloud-download"></i>&nbsp;&nbsp;&nbsp;cloud-download</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-cloud-upload"></i>&nbsp;&nbsp;&nbsp;cloud-upload</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-code"></i>&nbsp;&nbsp;&nbsp;code</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-code-fork"></i>&nbsp;&nbsp;&nbsp;code-fork</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-coffee"></i>&nbsp;&nbsp;&nbsp;coffee</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-cog"></i>&nbsp;&nbsp;&nbsp;cog</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-cogs"></i>&nbsp;&nbsp;&nbsp;cogs</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-comment"></i>&nbsp;&nbsp;&nbsp;comment</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-comment-o"></i>&nbsp;&nbsp;&nbsp;comment-o</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-comments"></i>&nbsp;&nbsp;&nbsp;comments</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-comments-o"></i>&nbsp;&nbsp;&nbsp;comments-o</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-compass"></i>&nbsp;&nbsp;&nbsp;compass</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;&nbsp;credit-card</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-crop"></i>&nbsp;&nbsp;&nbsp;crop</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-crosshairs"></i>&nbsp;&nbsp;&nbsp;crosshairs</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-cutlery"></i>&nbsp;&nbsp;&nbsp;cutlery</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-dashboard"></i>&nbsp;&nbsp;&nbsp;dashboard </div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-desktop"></i>&nbsp;&nbsp;&nbsp;desktop</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;&nbsp;dot-circle-o</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;download</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-edit"></i>&nbsp;&nbsp;&nbsp;edit </div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-ellipsis-h"></i>&nbsp;&nbsp;&nbsp;ellipsis-h</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-ellipsis-v"></i>&nbsp;&nbsp;&nbsp;ellipsis-v</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp;envelope</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;&nbsp;envelope-o</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-eraser"></i>&nbsp;&nbsp;&nbsp;eraser</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-exchange"></i>&nbsp;&nbsp;&nbsp;exchange</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-exclamation"></i>&nbsp;&nbsp;&nbsp;exclamation</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;&nbsp;exclamation-circle</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;&nbsp;exclamation-triangle</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-external-link"></i>&nbsp;&nbsp;&nbsp;external-link</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-external-link-square"></i>&nbsp;&nbsp;&nbsp;external-link-square</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-eye"></i>&nbsp;&nbsp;&nbsp;eye</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-eye-slash"></i>&nbsp;&nbsp;&nbsp;eye-slash</div>
                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-female"></i>&nbsp;&nbsp;&nbsp;female</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-fighter-jet"></i>&nbsp;&nbsp;&nbsp;fighter-jet</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-film"></i>&nbsp;&nbsp;&nbsp;film</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-filter"></i>&nbsp;&nbsp;&nbsp;filter</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-fire"></i>&nbsp;&nbsp;&nbsp;fire</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-fire-extinguisher"></i>&nbsp;&nbsp;&nbsp;fire-extinguisher</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-flag"></i>&nbsp;&nbsp;&nbsp;flag</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-flag-checkered"></i>&nbsp;&nbsp;&nbsp;flag-checkered</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-flag-o"></i>&nbsp;&nbsp;&nbsp;flag-o</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-flash"></i>&nbsp;&nbsp;&nbsp;flash </div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-flask"></i>&nbsp;&nbsp;&nbsp;flask</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-folder"></i>&nbsp;&nbsp;&nbsp;folder</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-folder-o"></i>&nbsp;&nbsp;&nbsp;folder-o</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-folder-open"></i>&nbsp;&nbsp;&nbsp;folder-open</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-folder-open-o"></i>&nbsp;&nbsp;&nbsp;folder-open-o</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-frown-o"></i>&nbsp;&nbsp;&nbsp;frown-o</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-gamepad"></i>&nbsp;&nbsp;&nbsp;gamepad</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-gavel"></i>&nbsp;&nbsp;&nbsp;gavel</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-gear"></i>&nbsp;&nbsp;&nbsp;gear </div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-gears"></i>&nbsp;&nbsp;&nbsp;gears </div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-gift"></i>&nbsp;&nbsp;&nbsp;gift</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-glass"></i>&nbsp;&nbsp;&nbsp;glass</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-globe"></i>&nbsp;&nbsp;&nbsp;globe</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-group"></i>&nbsp;&nbsp;&nbsp;group </div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-hdd-o"></i>&nbsp;&nbsp;&nbsp;hdd-o</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-headphones"></i>&nbsp;&nbsp;&nbsp;headphones</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-heart"></i>&nbsp;&nbsp;&nbsp;heart</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-heart-o"></i>&nbsp;&nbsp;&nbsp;heart-o</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;home</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-inbox"></i>&nbsp;&nbsp;&nbsp;inbox</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;info</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;info-circle</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-key"></i>&nbsp;&nbsp;&nbsp;key</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-keyboard-o"></i>&nbsp;&nbsp;&nbsp;keyboard-o</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-laptop"></i>&nbsp;&nbsp;&nbsp;laptop</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-leaf"></i>&nbsp;&nbsp;&nbsp;leaf</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-legal"></i>&nbsp;&nbsp;&nbsp;legal </div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-lemon-o"></i>&nbsp;&nbsp;&nbsp;lemon-o</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-level-down"></i>&nbsp;&nbsp;&nbsp;level-down</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-level-up"></i>&nbsp;&nbsp;&nbsp;level-up</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-lightbulb-o"></i>&nbsp;&nbsp;&nbsp;lightbulb-o</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-location-arrow"></i>&nbsp;&nbsp;&nbsp;location-arrow</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-lock"></i>&nbsp;&nbsp;&nbsp;lock</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-magic"></i>&nbsp;&nbsp;&nbsp;magic</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-magnet"></i>&nbsp;&nbsp;&nbsp;magnet</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-mail-forward"></i>&nbsp;&nbsp;&nbsp;mail-forward </div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-mail-reply"></i>&nbsp;&nbsp;&nbsp;mail-reply </div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-mail-reply-all"></i>&nbsp;&nbsp;&nbsp;mail-reply-all</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-male"></i>&nbsp;&nbsp;&nbsp;male</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-map-marker"></i>&nbsp;&nbsp;&nbsp;map-marker</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-meh-o"></i>&nbsp;&nbsp;&nbsp;meh-o</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-microphone"></i>&nbsp;&nbsp;&nbsp;microphone</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-microphone-slash"></i>&nbsp;&nbsp;&nbsp;microphone-slash</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-minus"></i>&nbsp;&nbsp;&nbsp;minus</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-minus-circle"></i>&nbsp;&nbsp;&nbsp;minus-circle</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-minus-square"></i>&nbsp;&nbsp;&nbsp;minus-square</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-minus-square-o"></i>&nbsp;&nbsp;&nbsp;minus-square-o</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-mobile"></i>&nbsp;&nbsp;&nbsp;mobile</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-mobile-phone"></i>&nbsp;&nbsp;&nbsp;mobile-phone </div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-money"></i>&nbsp;&nbsp;&nbsp;money</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-moon-o"></i>&nbsp;&nbsp;&nbsp;moon-o</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-music"></i>&nbsp;&nbsp;&nbsp;music</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;pencil</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-pencil-square"></i>&nbsp;&nbsp;&nbsp;pencil-square</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;&nbsp;pencil-square-o</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-phone"></i>&nbsp;&nbsp;&nbsp;phone</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-phone-square"></i>&nbsp;&nbsp;&nbsp;phone-square</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;&nbsp;picture-o</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-plane"></i>&nbsp;&nbsp;&nbsp;plane</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;plus</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;plus-circle</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;&nbsp;plus-square</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-plus-square-o"></i>&nbsp;&nbsp;&nbsp;plus-square-o</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-power-off"></i>&nbsp;&nbsp;&nbsp;power-off</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;print</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-puzzle-piece"></i>&nbsp;&nbsp;&nbsp;puzzle-piece</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-qrcode"></i>&nbsp;&nbsp;&nbsp;qrcode</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-question"></i>&nbsp;&nbsp;&nbsp;question</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-question-circle"></i>&nbsp;&nbsp;&nbsp;question-circle</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-quote-left"></i>&nbsp;&nbsp;&nbsp;quote-left</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-quote-right"></i>&nbsp;&nbsp;&nbsp;quote-right</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-random"></i>&nbsp;&nbsp;&nbsp;random</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-refresh"></i>&nbsp;&nbsp;&nbsp;refresh</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-reply"></i>&nbsp;&nbsp;&nbsp;reply</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-reply-all"></i>&nbsp;&nbsp;&nbsp;reply-all</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-retweet"></i>&nbsp;&nbsp;&nbsp;retweet</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-road"></i>&nbsp;&nbsp;&nbsp;road</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-rocket"></i>&nbsp;&nbsp;&nbsp;rocket</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-rss"></i>&nbsp;&nbsp;&nbsp;rss</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-rss-square"></i>&nbsp;&nbsp;&nbsp;rss-square</div>

                                                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;search</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-search-minus"></i>&nbsp;&nbsp;&nbsp;search-minus</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-search-plus"></i>&nbsp;&nbsp;&nbsp;search-plus</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-share"></i>&nbsp;&nbsp;&nbsp;share</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-share-square"></i>&nbsp;&nbsp;&nbsp;share-square</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-share-square-o"></i>&nbsp;&nbsp;&nbsp;share-square-o</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-shield"></i>&nbsp;&nbsp;&nbsp;shield</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;shopping-cart</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;&nbsp;sign-in</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;&nbsp;sign-out</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-signal"></i>&nbsp;&nbsp;&nbsp;signal</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-sitemap"></i>&nbsp;&nbsp;&nbsp;sitemap</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-smile-o"></i>&nbsp;&nbsp;&nbsp;smile-o</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-sort"></i>&nbsp;&nbsp;&nbsp;sort</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-sort-alpha-asc"></i>&nbsp;&nbsp;&nbsp;sort-alpha-asc</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-sort-alpha-desc"></i>&nbsp;&nbsp;&nbsp;sort-alpha-desc</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-sort-amount-asc"></i>&nbsp;&nbsp;&nbsp;sort-amount-asc</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-sort-amount-desc"></i>&nbsp;&nbsp;&nbsp;sort-amount-desc</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-sort-asc"></i>&nbsp;&nbsp;&nbsp;sort-asc</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-sort-desc"></i>&nbsp;&nbsp;&nbsp;sort-desc</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-sort-down"></i>&nbsp;&nbsp;&nbsp;sort-down </div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-sort-numeric-asc"></i>&nbsp;&nbsp;&nbsp;sort-numeric-asc</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-sort-numeric-desc"></i>&nbsp;&nbsp;&nbsp;sort-numeric-desc</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-sort-up"></i>&nbsp;&nbsp;&nbsp;sort-up </div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-spinner"></i>&nbsp;&nbsp;&nbsp;spinner</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-square"></i>&nbsp;&nbsp;&nbsp;square</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-square-o"></i>&nbsp;&nbsp;&nbsp;square-o</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-star"></i>&nbsp;&nbsp;&nbsp;star</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-star-half"></i>&nbsp;&nbsp;&nbsp;star-half</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-star-half-empty"></i>&nbsp;&nbsp;&nbsp;star-half-empty </div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-star-half-full"></i>&nbsp;&nbsp;&nbsp;star-half-full </div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-star-half-o"></i>&nbsp;&nbsp;&nbsp;star-half-o</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-star-o"></i>&nbsp;&nbsp;&nbsp;star-o</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-subscript"></i>&nbsp;&nbsp;&nbsp;subscript</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-suitcase"></i>&nbsp;&nbsp;&nbsp;suitcase</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-sun-o"></i>&nbsp;&nbsp;&nbsp;sun-o</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-superscript"></i>&nbsp;&nbsp;&nbsp;superscript</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-tablet"></i>&nbsp;&nbsp;&nbsp;tablet</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-tachometer"></i>&nbsp;&nbsp;&nbsp;tachometer</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-tag"></i>&nbsp;&nbsp;&nbsp;tag</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-tags"></i>&nbsp;&nbsp;&nbsp;tags</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-tasks"></i>&nbsp;&nbsp;&nbsp;tasks</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-terminal"></i>&nbsp;&nbsp;&nbsp;terminal</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-thumb-tack"></i>&nbsp;&nbsp;&nbsp;thumb-tack</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-thumbs-down"></i>&nbsp;&nbsp;&nbsp;thumbs-down</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-thumbs-o-down"></i>&nbsp;&nbsp;&nbsp;thumbs-o-down</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-thumbs-o-up"></i>&nbsp;&nbsp;&nbsp;thumbs-o-up</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;&nbsp;thumbs-up</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-ticket"></i>&nbsp;&nbsp;&nbsp;ticket</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-times"></i>&nbsp;&nbsp;&nbsp;times</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;&nbsp;times-circle</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-times-circle-o"></i>&nbsp;&nbsp;&nbsp;times-circle-o</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-tint"></i>&nbsp;&nbsp;&nbsp;tint</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-toggle-down"></i>&nbsp;&nbsp;&nbsp;toggle-down </div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-toggle-left"></i>&nbsp;&nbsp;&nbsp;toggle-left </div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-toggle-right"></i>&nbsp;&nbsp;&nbsp;toggle-right </div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-toggle-up"></i>&nbsp;&nbsp;&nbsp;toggle-up </div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;&nbsp;trash-o</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-trophy"></i>&nbsp;&nbsp;&nbsp;trophy</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-truck"></i>&nbsp;&nbsp;&nbsp;truck</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-umbrella"></i>&nbsp;&nbsp;&nbsp;umbrella</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-unlock"></i>&nbsp;&nbsp;&nbsp;unlock</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-unlock-alt"></i>&nbsp;&nbsp;&nbsp;unlock-alt</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-unsorted"></i>&nbsp;&nbsp;&nbsp;unsorted </div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-upload"></i>&nbsp;&nbsp;&nbsp;upload</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;user</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-users"></i>&nbsp;&nbsp;&nbsp;users</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-video-camera"></i>&nbsp;&nbsp;&nbsp;video-camera</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-volume-down"></i>&nbsp;&nbsp;&nbsp;volume-down</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-volume-off"></i>&nbsp;&nbsp;&nbsp;volume-off</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-volume-up"></i>&nbsp;&nbsp;&nbsp;volume-up</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-warning"></i>&nbsp;&nbsp;&nbsp;warning </div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-wheelchair"></i>&nbsp;&nbsp;&nbsp;wheelchair</div>

                                                <div class="col-xs-6  col-sm-4"><i class="fa fa-wrench"></i>&nbsp;&nbsp;&nbsp;wrench</div>
                                        </div>                                        
                                                                        </div> <!-- / .panel-body -->
                                                                </div> <!-- / .collapse -->
							</div> <!-- / .panel -->

							<div class="panel">
								<div class="panel-heading">
									<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-example" href="#collapseTwo">
										Form Control Icons
									</a>
								</div> <!-- / .panel-heading -->
								<div id="collapseTwo" class="panel-collapse collapse" style="height: 0px;">
									<div class="panel-body">
										 
                                       <div class="row myclass">

						<div class="col-xs-6  col-sm-4"><i class="fa fa-check-square"></i>&nbsp;&nbsp;&nbsp;check-square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;&nbsp;check-square-o</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-circle"></i>&nbsp;&nbsp;&nbsp;circle</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-circle-o"></i>&nbsp;&nbsp;&nbsp;circle-o</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;&nbsp;dot-circle-o</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-minus-square"></i>&nbsp;&nbsp;&nbsp;minus-square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-minus-square-o"></i>&nbsp;&nbsp;&nbsp;minus-square-o</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;&nbsp;plus-square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-plus-square-o"></i>&nbsp;&nbsp;&nbsp;plus-square-o</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-square"></i>&nbsp;&nbsp;&nbsp;square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-square-o"></i>&nbsp;&nbsp;&nbsp;square-o</div>
					</div>  
                                         
									</div> <!-- / .panel-body -->
								</div> <!-- / .collapse -->
							</div> <!-- / .panel -->

							<div class="panel">
								<div class="panel-heading">
									<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-example" href="#collapseThree">
										Currency Icons
									</a>
								</div> <!-- / .panel-heading -->
								<div id="collapseThree" class="panel-collapse collapse" style="height: 0px;">
									<div class="panel-body">
										
                                        <div class="row myclass">
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-bitcoin"></i>&nbsp;&nbsp;&nbsp;bitcoin </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-btc"></i>&nbsp;&nbsp;&nbsp;btc</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-cny"></i>&nbsp;&nbsp;&nbsp;cny </div>

						<div class="col-xs-6  col-sm-4"><i class="fa fa-dollar"></i>&nbsp;&nbsp;&nbsp;dollar </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-eur"></i>&nbsp;&nbsp;&nbsp;eur</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-euro"></i>&nbsp;&nbsp;&nbsp;euro </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-gbp"></i>&nbsp;&nbsp;&nbsp;gbp</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-inr"></i>&nbsp;&nbsp;&nbsp;inr</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-jpy"></i>&nbsp;&nbsp;&nbsp;jpy</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-krw"></i>&nbsp;&nbsp;&nbsp;krw</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-money"></i>&nbsp;&nbsp;&nbsp;money</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-rmb"></i>&nbsp;&nbsp;&nbsp;rmb </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-rouble"></i>&nbsp;&nbsp;&nbsp;rouble </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-rub"></i>&nbsp;&nbsp;&nbsp;rub</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-ruble"></i>&nbsp;&nbsp;&nbsp;ruble </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-rupee"></i>&nbsp;&nbsp;&nbsp;rupee </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-try"></i>&nbsp;&nbsp;&nbsp;try</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-turkish-lira"></i>&nbsp;&nbsp;&nbsp;turkish-lira </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-usd"></i>&nbsp;&nbsp;&nbsp;usd</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-won"></i>&nbsp;&nbsp;&nbsp;won </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-yen"></i>&nbsp;&nbsp;&nbsp;yen </div>
					</div>
                                        
									</div> <!-- / .panel-body -->
								</div> <!-- / .collapse -->
							</div> <!-- / .panel -->
                            
                            <div class="panel">
								<div class="panel-heading">
									<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-example" href="#collapseFour">
										Text Editor Icons
									</a>
								</div> <!-- / .panel-heading -->
								<div id="collapseFour" class="panel-collapse collapse" style="height: 0px;">
									<div class="panel-body">
										
                                        <div class="row myclass">
						<div class="col-xs-6  col-sm-4"><i class="fa fa-align-center"></i>&nbsp;&nbsp;&nbsp;align-center</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-align-justify"></i>&nbsp;&nbsp;&nbsp;align-justify</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-align-left"></i>&nbsp;&nbsp;&nbsp;align-left</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-align-right"></i>&nbsp;&nbsp;&nbsp;align-right</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-bold"></i>&nbsp;&nbsp;&nbsp;bold</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-chain"></i>&nbsp;&nbsp;&nbsp;chain </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-chain-broken"></i>&nbsp;&nbsp;&nbsp;chain-broken</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-clipboard"></i>&nbsp;&nbsp;&nbsp;clipboard</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-columns"></i>&nbsp;&nbsp;&nbsp;columns</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-copy"></i>&nbsp;&nbsp;&nbsp;copy </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-cut"></i>&nbsp;&nbsp;&nbsp;cut </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-dedent"></i>&nbsp;&nbsp;&nbsp;dedent </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-eraser"></i>&nbsp;&nbsp;&nbsp;eraser</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-file"></i>&nbsp;&nbsp;&nbsp;file</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-file-o"></i>&nbsp;&nbsp;&nbsp;file-o</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-file-text"></i>&nbsp;&nbsp;&nbsp;file-text</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;&nbsp;file-text-o</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-files-o"></i>&nbsp;&nbsp;&nbsp;files-o</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;&nbsp;floppy-o</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-font"></i>&nbsp;&nbsp;&nbsp;font</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-indent"></i>&nbsp;&nbsp;&nbsp;indent</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-italic"></i>&nbsp;&nbsp;&nbsp;italic</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-link"></i>&nbsp;&nbsp;&nbsp;link</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;list</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;&nbsp;list-alt</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-list-ol"></i>&nbsp;&nbsp;&nbsp;list-ol</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-list-ul"></i>&nbsp;&nbsp;&nbsp;list-ul</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-outdent"></i>&nbsp;&nbsp;&nbsp;outdent</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-paperclip"></i>&nbsp;&nbsp;&nbsp;paperclip</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-paste"></i>&nbsp;&nbsp;&nbsp;paste </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-repeat"></i>&nbsp;&nbsp;&nbsp;repeat</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-rotate-left"></i>&nbsp;&nbsp;&nbsp;rotate-left </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-rotate-right"></i>&nbsp;&nbsp;&nbsp;rotate-right </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;save </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-scissors"></i>&nbsp;&nbsp;&nbsp;scissors</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-strikethrough"></i>&nbsp;&nbsp;&nbsp;strikethrough</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;table</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-text-height"></i>&nbsp;&nbsp;&nbsp;text-height</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-text-width"></i>&nbsp;&nbsp;&nbsp;text-width</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-th"></i>&nbsp;&nbsp;&nbsp;th</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-th-large"></i>&nbsp;&nbsp;&nbsp;th-large</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-th-list"></i>&nbsp;&nbsp;&nbsp;th-list</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-underline"></i>&nbsp;&nbsp;&nbsp;underline</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-undo"></i>&nbsp;&nbsp;&nbsp;undo</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-unlink"></i>&nbsp;&nbsp;&nbsp;unlink </div>
					</div>
                                        
									</div> <!-- / .panel-body -->
								</div> <!-- / .collapse -->
							</div> <!-- / .panel -->
                            
                            <div class="panel">
								<div class="panel-heading">
									<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-example" href="#collapseFive">
										Directional Icons
									</a>
								</div> <!-- / .panel-heading -->
								<div id="collapseFive" class="panel-collapse collapse" style="height: 0px;">
									<div class="panel-body">
										
                                        <div class="row myclass">
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-angle-double-down"></i>&nbsp;&nbsp;&nbsp;angle-double-down</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;&nbsp;angle-double-left</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;angle-double-right</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-angle-double-up"></i>&nbsp;&nbsp;&nbsp;angle-double-up</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;angle-down</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-angle-left"></i>&nbsp;&nbsp;&nbsp;angle-left</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;angle-right</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;angle-up</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrow-circle-down"></i>&nbsp;&nbsp;&nbsp;arrow-circle-down</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;&nbsp;arrow-circle-left</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrow-circle-o-down"></i>&nbsp;&nbsp;&nbsp;arrow-circle-o-down</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrow-circle-o-left"></i>&nbsp;&nbsp;&nbsp;arrow-circle-o-left</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrow-circle-o-right"></i>&nbsp;&nbsp;&nbsp;arrow-circle-o-right</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrow-circle-o-up"></i>&nbsp;&nbsp;&nbsp;arrow-circle-o-up</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrow-circle-right"></i>&nbsp;&nbsp;&nbsp;arrow-circle-right</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrow-circle-up"></i>&nbsp;&nbsp;&nbsp;arrow-circle-up</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrow-down"></i>&nbsp;&nbsp;&nbsp;arrow-down</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;arrow-left</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;&nbsp;arrow-right</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrow-up"></i>&nbsp;&nbsp;&nbsp;arrow-up</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrows"></i>&nbsp;&nbsp;&nbsp;arrows</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrows-alt"></i>&nbsp;&nbsp;&nbsp;arrows-alt</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrows-h"></i>&nbsp;&nbsp;&nbsp;arrows-h</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrows-v"></i>&nbsp;&nbsp;&nbsp;arrows-v</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-caret-down"></i>&nbsp;&nbsp;&nbsp;caret-down</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-caret-left"></i>&nbsp;&nbsp;&nbsp;caret-left</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-caret-right"></i>&nbsp;&nbsp;&nbsp;caret-right</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-caret-square-o-down"></i>&nbsp;&nbsp;&nbsp;caret-square-o-down</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-caret-square-o-left"></i>&nbsp;&nbsp;&nbsp;caret-square-o-left</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-caret-square-o-right"></i>&nbsp;&nbsp;&nbsp;caret-square-o-right</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-caret-square-o-up"></i>&nbsp;&nbsp;&nbsp;caret-square-o-up</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-caret-up"></i>&nbsp;&nbsp;&nbsp;caret-up</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-chevron-circle-down"></i>&nbsp;&nbsp;&nbsp;chevron-circle-down</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;&nbsp;chevron-circle-left</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-chevron-circle-right"></i>&nbsp;&nbsp;&nbsp;chevron-circle-right</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-chevron-circle-up"></i>&nbsp;&nbsp;&nbsp;chevron-circle-up</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-chevron-down"></i>&nbsp;&nbsp;&nbsp;chevron-down</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;chevron-left</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-chevron-right"></i>&nbsp;&nbsp;&nbsp;chevron-right</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-chevron-up"></i>&nbsp;&nbsp;&nbsp;chevron-up</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-hand-o-down"></i>&nbsp;&nbsp;&nbsp;hand-o-down</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-hand-o-left"></i>&nbsp;&nbsp;&nbsp;hand-o-left</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-hand-o-right"></i>&nbsp;&nbsp;&nbsp;hand-o-right</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-hand-o-up"></i>&nbsp;&nbsp;&nbsp;hand-o-up</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-long-arrow-down"></i>&nbsp;&nbsp;&nbsp;long-arrow-down</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;&nbsp;long-arrow-left</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-long-arrow-right"></i>&nbsp;&nbsp;&nbsp;long-arrow-right</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-long-arrow-up"></i>&nbsp;&nbsp;&nbsp;long-arrow-up</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-toggle-down"></i>&nbsp;&nbsp;&nbsp;toggle-down </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-toggle-left"></i>&nbsp;&nbsp;&nbsp;toggle-left </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-toggle-right"></i>&nbsp;&nbsp;&nbsp;toggle-right </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-toggle-up"></i>&nbsp;&nbsp;&nbsp;toggle-up </div>
					</div>
                                        
									</div> <!-- / .panel-body -->
								</div> <!-- / .collapse -->
							</div> <!-- / .panel -->
                            
                            <div class="panel">
								<div class="panel-heading">
									<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-example" href="#collapseSix">
										Video Player Icons
									</a>
								</div> <!-- / .panel-heading -->
								<div id="collapseSix" class="panel-collapse collapse" style="height: 0px;">
									<div class="panel-body">
										
                                        <div class="row myclass">
						<div class="col-xs-6  col-sm-4"><i class="fa fa-arrows-alt"></i>&nbsp;&nbsp;&nbsp;arrows-alt</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-backward"></i>&nbsp;&nbsp;&nbsp;backward</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-compress"></i>&nbsp;&nbsp;&nbsp;compress</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-eject"></i>&nbsp;&nbsp;&nbsp;eject</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-expand"></i>&nbsp;&nbsp;&nbsp;expand</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-fast-backward"></i>&nbsp;&nbsp;&nbsp;fast-backward</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-fast-forward"></i>&nbsp;&nbsp;&nbsp;fast-forward</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-forward"></i>&nbsp;&nbsp;&nbsp;forward</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-pause"></i>&nbsp;&nbsp;&nbsp;pause</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-play"></i>&nbsp;&nbsp;&nbsp;play</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-play-circle"></i>&nbsp;&nbsp;&nbsp;play-circle</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-play-circle-o"></i>&nbsp;&nbsp;&nbsp;play-circle-o</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-step-backward"></i>&nbsp;&nbsp;&nbsp;step-backward</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-step-forward"></i>&nbsp;&nbsp;&nbsp;step-forward</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-stop"></i>&nbsp;&nbsp;&nbsp;stop</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-youtube-play"></i>&nbsp;&nbsp;&nbsp;youtube-play</div>
					</div>
                                        
									</div> <!-- / .panel-body -->
								</div> <!-- / .collapse -->
							</div> <!-- / .panel -->
                            
                            <div class="panel">
								<div class="panel-heading">
									<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-example" href="#collapseSeven">
										Brand Icons
									</a>
								</div> <!-- / .panel-heading -->
								<div id="collapseSeven" class="panel-collapse collapse" style="height: 0px;">
									<div class="panel-body">
										
                                        <div class="row myclass">
						<div class="col-xs-6  col-sm-4"><i class="fa fa-adn"></i>&nbsp;&nbsp;&nbsp;adn</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-android"></i>&nbsp;&nbsp;&nbsp;android</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-apple"></i>&nbsp;&nbsp;&nbsp;apple</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-bitbucket"></i>&nbsp;&nbsp;&nbsp;bitbucket</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-bitbucket-square"></i>&nbsp;&nbsp;&nbsp;bitbucket-square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-bitcoin"></i>&nbsp;&nbsp;&nbsp;bitcoin </div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-btc"></i>&nbsp;&nbsp;&nbsp;btc</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-css3"></i>&nbsp;&nbsp;&nbsp;css3</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-dribbble"></i>&nbsp;&nbsp;&nbsp;dribbble</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-dropbox"></i>&nbsp;&nbsp;&nbsp;dropbox</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-facebook"></i>&nbsp;&nbsp;&nbsp;facebook</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-facebook-square"></i>&nbsp;&nbsp;&nbsp;facebook-square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-flickr"></i>&nbsp;&nbsp;&nbsp;flickr</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-foursquare"></i>&nbsp;&nbsp;&nbsp;foursquare</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-github"></i>&nbsp;&nbsp;&nbsp;github</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-github-alt"></i>&nbsp;&nbsp;&nbsp;github-alt</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-github-square"></i>&nbsp;&nbsp;&nbsp;github-square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-gittip"></i>&nbsp;&nbsp;&nbsp;gittip</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-google-plus"></i>&nbsp;&nbsp;&nbsp;google-plus</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-google-plus-square"></i>&nbsp;&nbsp;&nbsp;google-plus-square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-html5"></i>&nbsp;&nbsp;&nbsp;html5</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-instagram"></i>&nbsp;&nbsp;&nbsp;instagram</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-linkedin"></i>&nbsp;&nbsp;&nbsp;linkedin</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-linkedin-square"></i>&nbsp;&nbsp;&nbsp;linkedin-square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-linux"></i>&nbsp;&nbsp;&nbsp;linux</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-maxcdn"></i>&nbsp;&nbsp;&nbsp;maxcdn</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-pagelines"></i>&nbsp;&nbsp;&nbsp;pagelines</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-pinterest"></i>&nbsp;&nbsp;&nbsp;pinterest</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-pinterest-square"></i>&nbsp;&nbsp;&nbsp;pinterest-square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-renren"></i>&nbsp;&nbsp;&nbsp;renren</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-skype"></i>&nbsp;&nbsp;&nbsp;skype</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-stack-exchange"></i>&nbsp;&nbsp;&nbsp;stack-exchange</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-stack-overflow"></i>&nbsp;&nbsp;&nbsp;stack-overflow</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-trello"></i>&nbsp;&nbsp;&nbsp;trello</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-tumblr"></i>&nbsp;&nbsp;&nbsp;tumblr</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-tumblr-square"></i>&nbsp;&nbsp;&nbsp;tumblr-square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-twitter"></i>&nbsp;&nbsp;&nbsp;twitter</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-twitter-square"></i>&nbsp;&nbsp;&nbsp;twitter-square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-vimeo-square"></i>&nbsp;&nbsp;&nbsp;vimeo-square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-vk"></i>&nbsp;&nbsp;&nbsp;vk</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-weibo"></i>&nbsp;&nbsp;&nbsp;weibo</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-windows"></i>&nbsp;&nbsp;&nbsp;windows</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-xing"></i>&nbsp;&nbsp;&nbsp;xing</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-xing-square"></i>&nbsp;&nbsp;&nbsp;xing-square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-youtube"></i>&nbsp;&nbsp;&nbsp;youtube</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-youtube-play"></i>&nbsp;&nbsp;&nbsp;youtube-play</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-youtube-square"></i>&nbsp;&nbsp;&nbsp;youtube-square</div>
					</div>
                                        
									</div> <!-- / .panel-body -->
								</div> <!-- / .collapse -->
							</div> <!-- / .panel -->
                            
                            <div class="panel">
								<div class="panel-heading">
									<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-example" href="#collapseEight">
										Medical Icons
									</a>
								</div> <!-- / .panel-heading -->
								<div id="collapseEight" class="panel-collapse collapse" style="height: 0px;">
									<div class="panel-body">
										
                                        <div class="row myclass">
						<div class="col-xs-6  col-sm-4"><i class="fa fa-ambulance"></i>&nbsp;&nbsp;&nbsp;ambulance</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-h-square"></i>&nbsp;&nbsp;&nbsp;h-square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-hospital-o"></i>&nbsp;&nbsp;&nbsp;hospital-o</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-medkit"></i>&nbsp;&nbsp;&nbsp;medkit</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;&nbsp;plus-square</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-stethoscope"></i>&nbsp;&nbsp;&nbsp;stethoscope</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-user-md"></i>&nbsp;&nbsp;&nbsp;user-md</div>
						
						<div class="col-xs-6  col-sm-4"><i class="fa fa-wheelchair"></i>&nbsp;&nbsp;&nbsp;wheelchair</div>
					</div>
                                        
									</div> <!-- / .panel-body -->
								</div> <!-- / .collapse -->
							</div> <!-- / .panel -->
						</div> <!-- / .panel-group -->

					</div>





</div>
</div>
                                    </div>
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus_state');?></span></div>
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
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script>
    $(".myclass > div > i ").on('click',function(){       
        var icon_str=$(this).attr("class");        
        
        str="<i class='"+icon_str+"'></i>";
        $("#preview").html(str);
        $("#menu_icon").val(icon_str);
        ; 
    });
</script>
    