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
                campus_id:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select Campus'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Invalid value for campus selected'
                      }
                    }

                },
                college_id:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select College'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Invalid value for College selected'
                      }
                    }

                },
                course_id:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select Course'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Invalid value for Course selected'
                      }
                    }
                },
                branch_id:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select Branch'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Invalid value for Branch selected'
                      }
                    }
                }
            }       
        })
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';  
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Edit Relation</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Relation</h1>
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
                            <span class="panel-title">Course Branch Relation Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($details['ccb_id'])?$details['ccb_id']:""?>" id="ccb_id" name="ccb_id" />
                                <div class="form-group">
                                    <label class="col-sm-3">Campus <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="campus_id" name="campus_id" class="form-control">
                                            <option value="">Select Campus</option>
                                            <?php for($i=0;$i<count($campus_details);$i++){?>
                                            <option value="<?=$campus_details[$i]['campus_id']?>" <?=$campus_details[$i]['campus_id']==$details['campus_id']?"selected='selected'":""?>><?=$campus_details[$i]['campus_name']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus_id');?></span></div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3">College <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="college_id" name="college_id" class="form-control">
                                            <option value="">Select College</option>
                                            <?php for($i=0;$i<count($college_details);$i++){?>
                                            <option value="<?=$college_details[$i]['college_id']?>" <?=$college_details[$i]['college_id']==$details['college_id']?"selected='selected'":""?>><?=$college_details[$i]['college_code']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('college_id');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Course <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="course_id" name="course_id" class="form-control">
                                            <option value="">Select Course</option>
                                            <?php foreach($course_details as $key=>$val){?>
                                            <option value="<?=$key?>" <?=$key==$details['course_id']?"selected='selected'":""?>> <?=$val?></option>
                                            <?php } ?>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_id');?></span></div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3">Branch <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="branch_id" name="branch_id" class="form-control">
                                            <option value="">Select Branch</option>
                                            <?php foreach($branch_details as $key=>$val){?>
                                            <option value="<?=$key?>" <?=$key==$details['branch_id']?"selected='selected'":""?>> <?=$val?></option>
                                            <?php } ?>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('branch_id');?></span></div>
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
</div>
<script>
    $("#campus_id").on('change',function()
    {
        var campus_id=$(this).val();
        if(campus_id!="")
        {
            var url  = "<?=base_url().strtolower($currentModule).'/get_colleges/'?>";	
            var data = {"campus_id": campus_id};	
            var base_url="<?=base_url()?>";
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
                    var str="<option value=''>Select College</option>";                                        
                    for(i=0;i<array.college_details.length;i++)
                    {
                        id=array.college_details[i].college_id;
                        code=array.college_details[i].college_code;
                    
                        str+="<option value="+id+">"+code+"</option>";                        
                    }
                    $("#college_id").html(str);
                    $("#course_id").html("<option value=''>Select Course</option>");
                    $("#branch_id").html("<option value=''>Select Branch</option>");
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        }
    });
    
    $("#college_id").on('change',function()
    {
        var campus_id=$("#campus_id").val();
        var college_id=$(this).val();
        if(college_id!="")
        {
            var url  = "<?=base_url().strtolower($currentModule).'/get_collegewise_courses/'?>";	
            var data = {"campus_id":campus_id,"college_id": college_id};	
            var base_url="<?=base_url()?>";
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
                    var str="<option value=''>Select Course</option>"; 
                    if(array.course_details.length>0)
                    {
                        for(i=0;i<array.course_details.length;i++)
                        {
                            id=array.course_details[i].course_id;
                            code=array.course_details[i].course_code;                    
                            str+="<option value="+id+">"+code+"</option>";                        
                        }
                    }
                    $("#course_id").html(str);                   
                    $("#branch_id").html("<option value=''>Select Branch</option>");
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        }
    });
    
    $("#course_id").on('change',function()
    {
        var campus_id=$("#campus_id").val();
        var college_id=$("#college_id").val();
        var course_id=$(this).val();
        if(course_id!="")
        {
            var url  = "<?=base_url().strtolower($currentModule).'/get_coursewise_branches/'?>";	
            var data = {"campus_id":campus_id,"college_id": college_id,"course_id":course_id};	
            var base_url="<?=base_url()?>";
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
                    var str="<option value=''>Select Course</option>"; 
                    if(array.branch_details.length>0)
                    {
                        for(i=0;i<array.branch_details.length;i++)
                        {
                            id=array.branch_details[i].branch_id;
                            code=array.branch_details[i].branch_name;                    
                            str+="<option value="+id+">"+code+"</option>";                        
                        }
                    }
                    $("#branch_id").html(str);                   
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        }
    });    
</script>